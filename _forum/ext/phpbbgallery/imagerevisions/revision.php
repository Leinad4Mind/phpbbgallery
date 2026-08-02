<?php
/**
 * phpBB Gallery - Image Revisions Extension
 *
 * @package   phpbbgallery/imagerevisions
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\imagerevisions;

class revision
{
	private const MAX_REVISIONS = 50;

	protected \phpbb\db\driver\driver_interface $db;
	protected \phpbb\user $user;
	protected \phpbbgallery\core\url $url;
	protected \phpbbgallery\core\log $gallery_log;
	protected \phpbbgallery\core\cache $gallery_cache;
	protected \phpbbgallery\core\file\file $file;
	protected string $table_images;
	protected string $table_revisions;

	public function __construct(\phpbb\db\driver\driver_interface $db, \phpbb\user $user, \phpbbgallery\core\url $url,
		\phpbbgallery\core\log $gallery_log, \phpbbgallery\core\cache $gallery_cache, \phpbbgallery\core\file\file $file,
		string $table_images, string $table_revisions)
	{
		$this->db = $db;
		$this->user = $user;
		$this->url = $url;
		$this->gallery_log = $gallery_log;
		$this->gallery_cache = $gallery_cache;
		$this->file = $file;
		$this->table_images = $table_images;
		$this->table_revisions = $table_revisions;
	}

	public function get_revisions(int $image_id): array
	{
		if ($image_id < 1)
		{
			return [];
		}

		$sql = 'SELECT r.*, u.username, u.user_colour
			FROM ' . $this->table_revisions . ' r
			LEFT JOIN ' . USERS_TABLE . ' u
				ON (r.revision_user_id = u.user_id)
			WHERE r.image_id = ' . $image_id . '
			ORDER BY r.revision_time DESC, r.revision_id DESC';
		$result = $this->db->sql_query($sql);
		$revisions = [];
		while ($row = $this->db->sql_fetchrow($result))
		{
			$revisions[] = $row;
		}
		$this->db->sql_freeresult($result);

		return $revisions;
	}

	public function get_revision(int $image_id, int $revision_id): array|false
	{
		if ($image_id < 1 || $revision_id < 1)
		{
			return false;
		}

		$sql = 'SELECT *
			FROM ' . $this->table_revisions . '
			WHERE revision_id = ' . $revision_id . '
				AND image_id = ' . $image_id;
		$result = $this->db->sql_query($sql);
		$revision = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);

		return is_array($revision) ? $revision : false;
	}

	public function replace_file(int $image_id, int $uploaded_image_id, int $limit): bool
	{
		if ($image_id < 1 || $uploaded_image_id < 1 || $image_id === $uploaded_image_id)
		{
			return false;
		}

		$rows = $this->get_image_rows([$image_id, $uploaded_image_id]);
		if (!isset($rows[$image_id], $rows[$uploaded_image_id]))
		{
			return false;
		}

		$current = $rows[$image_id];
		$uploaded = $rows[$uploaded_image_id];
		if ((int) $current['image_status'] === (int) \phpbbgallery\core\block::STATUS_ORPHAN
			|| (int) $uploaded['image_status'] !== (int) \phpbbgallery\core\block::STATUS_ORPHAN
			|| (int) $uploaded['image_user_id'] !== (int) $this->user->data['user_id']
			|| (int) $uploaded['image_album_id'] !== (int) $current['image_album_id']
			|| $this->resolve_source_file((string) $uploaded['image_filename']) === false)
		{
			return false;
		}

		$current_exists = $this->resolve_source_file((string) $current['image_filename']) !== false;
		$pruned_files = [];
		$this->db->sql_transaction('begin');
		try
		{
			if ($current_exists)
			{
				$this->insert_revision($current);
			}

			$sql_ary = [
				'image_filename'    => $uploaded['image_filename'],
				'filesize_upload'   => (int) $uploaded['filesize_upload'],
				'filesize_medium'   => 0,
				'filesize_cache'    => 0,
				'image_filemissing' => 0,
			];
			if (!$this->update_image_file($image_id, $sql_ary, (string) $current['image_filename']))
			{
				$this->db->sql_transaction('rollback');
				return false;
			}

			$sql = 'DELETE FROM ' . $this->table_images . '
				WHERE image_id = ' . $uploaded_image_id;
			$this->db->sql_query($sql);
			$pruned_files = $this->prune($image_id, $limit);
			$this->db->sql_transaction('commit');
		}
		catch (\Throwable $exception)
		{
			$this->db->sql_transaction('rollback');
			throw $exception;
		}

		$this->finish_change($current, (string) $uploaded['image_filename'], $pruned_files);

		return true;
	}

	public function restore(int $image_id, int $revision_id, int $limit): bool
	{
		$current_rows = $this->get_image_rows([$image_id]);
		$restored = $this->get_revision($image_id, $revision_id);
		if (!isset($current_rows[$image_id]) || $restored === false
			|| (int) $current_rows[$image_id]['image_status'] === (int) \phpbbgallery\core\block::STATUS_ORPHAN
			|| $this->resolve_source_file((string) $restored['revision_filename']) === false)
		{
			return false;
		}

		$current = $current_rows[$image_id];
		$current_exists = $this->resolve_source_file((string) $current['image_filename']) !== false;
		$pruned_files = [];
		$this->db->sql_transaction('begin');
		try
		{
			if ($current_exists)
			{
				$this->insert_revision($current);
			}

			$sql_ary = [
				'image_filename'    => $restored['revision_filename'],
				'filesize_upload'   => (int) $restored['revision_filesize'],
				'filesize_medium'   => 0,
				'filesize_cache'    => 0,
				'image_filemissing' => 0,
			];
			if (!$this->update_image_file($image_id, $sql_ary, (string) $current['image_filename']))
			{
				$this->db->sql_transaction('rollback');
				return false;
			}

			$sql = 'DELETE FROM ' . $this->table_revisions . '
				WHERE revision_id = ' . $revision_id . '
					AND image_id = ' . $image_id;
			$this->db->sql_query($sql);
			$pruned_files = $this->prune($image_id, $limit);
			$this->db->sql_transaction('commit');
		}
		catch (\Throwable $exception)
		{
			$this->db->sql_transaction('rollback');
			throw $exception;
		}

		$this->finish_change($current, (string) $restored['revision_filename'], $pruned_files);

		return true;
	}

	public function delete_for_images(array $image_ids): int
	{
		$image_ids = array_values(array_unique(array_filter(array_map('intval', $image_ids), static fn (int $image_id): bool => $image_id > 0)));
		if (!$image_ids)
		{
			return 0;
		}

		$sql = 'SELECT revision_filename
			FROM ' . $this->table_revisions . '
			WHERE ' . $this->db->sql_in_set('image_id', $image_ids);
		$result = $this->db->sql_query($sql);
		$filenames = [];
		while ($row = $this->db->sql_fetchrow($result))
		{
			$filenames[] = $row['revision_filename'];
		}
		$this->db->sql_freeresult($result);
		if ($filenames)
		{
			$this->file->delete($filenames);
		}

		$sql = 'DELETE FROM ' . $this->table_revisions . '
			WHERE ' . $this->db->sql_in_set('image_id', $image_ids);
		$this->db->sql_query($sql);

		return count($filenames);
	}

	public function reconcile_orphans(int $batch_size = 500): int
	{
		$deleted = 0;
		$batch_size = max(1, min(self::MAX_REVISIONS * 20, $batch_size));
		do
		{
			$sql = 'SELECT DISTINCT revision.image_id
				FROM ' . $this->table_revisions . ' revision
				LEFT JOIN ' . $this->table_images . ' image
					ON image.image_id = revision.image_id
				WHERE image.image_id IS NULL';
			$result = $this->db->sql_query_limit($sql, $batch_size);
			$image_ids = [];
			while ($row = $this->db->sql_fetchrow($result))
			{
				$image_ids[] = (int) $row['image_id'];
			}
			$this->db->sql_freeresult($result);
			if (!$image_ids)
			{
				break;
			}
			$deleted += $this->delete_for_images($image_ids);
		}
		while (count($image_ids) === $batch_size);

		return $deleted;
	}

	public function resolve_source_file(string $filename): string|false
	{
		if ($filename === '' || strpos($filename, "\0") !== false || preg_match('#(^|[\\\\/])\.\.([\\\\/]|$)#', $filename)
			|| preg_match('#^(?:[a-z]:|[\\\\/])#i', $filename))
		{
			return false;
		}

		$root = realpath((string) $this->url->path('upload'));
		$file = $root === false ? false : realpath($root . DIRECTORY_SEPARATOR . str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $filename));
		if ($root === false || $file === false || !is_file($file))
		{
			return false;
		}

		$root_prefix = rtrim(str_replace('\\', '/', $root), '/') . '/';
		$normalized_file = str_replace('\\', '/', $file);

		return strncasecmp($normalized_file, $root_prefix, strlen($root_prefix)) === 0 ? $file : false;
	}

	private function get_image_rows(array $image_ids): array
	{
		$sql = 'SELECT *
			FROM ' . $this->table_images . '
			WHERE ' . $this->db->sql_in_set('image_id', $image_ids);
		$result = $this->db->sql_query($sql);
		$rows = [];
		while ($row = $this->db->sql_fetchrow($result))
		{
			$rows[(int) $row['image_id']] = $row;
		}
		$this->db->sql_freeresult($result);

		return $rows;
	}

	private function insert_revision(array $image): void
	{
		$sql_ary = [
			'image_id'          => (int) $image['image_id'],
			'revision_filename' => $image['image_filename'],
			'revision_filesize' => (int) $image['filesize_upload'],
			'revision_time'     => time(),
			'revision_user_id'  => (int) $this->user->data['user_id'],
		];
		$sql = 'INSERT INTO ' . $this->table_revisions . ' ' . $this->db->sql_build_array('INSERT', $sql_ary);
		$this->db->sql_query($sql);
	}

	/**
	 * Replace the active filename only if no concurrent editor changed it first.
	 */
	private function update_image_file(int $image_id, array $sql_ary, string $expected_filename): bool
	{
		$sql = 'UPDATE ' . $this->table_images . '
			SET ' . $this->db->sql_build_array('UPDATE', $sql_ary) . '
			WHERE image_id = ' . $image_id . "
				AND image_filename = '" . $this->db->sql_escape($expected_filename) . "'";
		$this->db->sql_query($sql);

		return $this->db->sql_affectedrows() === 1;
	}

	private function prune(int $image_id, int $limit): array
	{
		$limit = max(1, min(self::MAX_REVISIONS, $limit));
		$sql = 'SELECT revision_id, revision_filename
			FROM ' . $this->table_revisions . '
			WHERE image_id = ' . $image_id . '
			ORDER BY revision_time DESC, revision_id DESC';
		$result = $this->db->sql_query($sql);
		$position = 0;
		$revision_ids = [];
		$filenames = [];
		while ($row = $this->db->sql_fetchrow($result))
		{
			if (++$position <= $limit)
			{
				continue;
			}
			$revision_ids[] = (int) $row['revision_id'];
			$filenames[] = $row['revision_filename'];
		}
		$this->db->sql_freeresult($result);

		if ($revision_ids)
		{
			$sql = 'DELETE FROM ' . $this->table_revisions . '
				WHERE ' . $this->db->sql_in_set('revision_id', $revision_ids);
			$this->db->sql_query($sql);
		}

		return $filenames;
	}

	private function finish_change(array $current, string $new_filename, array $pruned_files): void
	{
		$this->file->delete_cache([(string) $current['image_filename'], $new_filename]);
		if ($pruned_files)
		{
			$this->file->delete($pruned_files);
		}
		$this->gallery_log->add_log('user', 'edit', (int) $current['image_album_id'], (int) $current['image_id'], ['LOG_GALLERY_EDITED', $current['image_name']]);
		$this->gallery_cache->destroy_images();
	}
}
