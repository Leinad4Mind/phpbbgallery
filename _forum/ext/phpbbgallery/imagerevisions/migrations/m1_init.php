<?php
/**
 * phpBB Gallery - Image Revisions Extension
 *
 * @package   phpbbgallery/imagerevisions
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\imagerevisions\migrations;

use phpbb\db\migration\migration;

class m1_init extends migration
{
	public static function depends_on(): array
	{
		return ['\phpbbgallery\core\migrations\release_1_2_0_db_create'];
	}

	public function update_schema(): array
	{
		return [
			'add_tables' => [
				$this->table_prefix . 'gallery_image_revisions' => [
					'COLUMNS' => [
						'revision_id'       => ['UINT', null, 'auto_increment'],
						'image_id'          => ['UINT', 0],
						'revision_filename' => ['VCHAR:255', ''],
						'revision_filesize' => ['UINT:20', 0],
						'revision_time'     => ['UINT:11', 0],
						'revision_user_id'  => ['UINT', 0],
					],
					'PRIMARY_KEY' => 'revision_id',
					'KEYS' => [
						'image_time' => ['INDEX', ['image_id', 'revision_time']],
					],
				],
			],
		];
	}

	public function revert_schema(): array
	{
		return [
			'drop_tables' => [
				$this->table_prefix . 'gallery_image_revisions',
			],
		];
	}

	public function update_data(): array
	{
		return [
			['permission.add', ['a_gallery_imagerevisions', true, 'a_board']],
			['module.add', ['acp', 'PHPBB_GALLERY', [
				'module_basename' => '\phpbbgallery\imagerevisions\acp\main_module',
				'module_langname' => 'ACP_GALLERY_IMAGE_REVISIONS',
				'module_mode'     => 'settings',
				'module_auth'     => 'ext_phpbbgallery/imagerevisions && acl_a_gallery_imagerevisions',
			]]],
			['config.add', ['phpbb_gallery_imagerevisions_enabled', 0]],
			['config.add', ['phpbb_gallery_imagerevisions_limit', 5]],
		];
	}

	public function revert_data(): array
	{
		return [
			['custom', [[$this, 'delete_revision_files']]],
		];
	}

	/**
	 * Delete the historical source files owned by this add-on before its table is dropped.
	 */
	public function delete_revision_files(): void
	{
		$source_root = realpath($this->phpbb_root_path . 'files/phpbbgallery/core/source');
		if ($source_root === false || !is_dir($source_root))
		{
			return;
		}

		$sql = 'SELECT revision_filename
			FROM ' . $this->table_prefix . 'gallery_image_revisions';
		$result = $this->db->sql_query($sql);
		while ($row = $this->db->sql_fetchrow($result))
		{
			$filename = (string) $row['revision_filename'];
			if ($filename === '' || strpos($filename, "\0") !== false || preg_match('#(^|[\\\\/])\.\.([\\\\/]|$)#', $filename)
				|| preg_match('#^(?:[a-z]:|[\\\\/])#i', $filename))
			{
				continue;
			}

			$path = realpath($source_root . DIRECTORY_SEPARATOR . str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $filename));
			$root_prefix = rtrim(str_replace('\\', '/', $source_root), '/') . '/';
			$normalized_path = $path === false ? '' : str_replace('\\', '/', $path);
			if ($path !== false && is_file($path) && strncasecmp($normalized_path, $root_prefix, strlen($root_prefix)) === 0)
			{
				@unlink($path);
			}
		}
		$this->db->sql_freeresult($result);
	}
}
