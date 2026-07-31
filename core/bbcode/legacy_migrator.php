<?php
/**
 * phpBB Gallery - Core Extension
 *
 * @package   phpbbgallery/core
 * @author    Leinad4Mind
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\core\bbcode;

/**
 * Convert the hidden Gallery [album] compatibility alias in stored phpBB text.
 */
class legacy_migrator
{
	private const BATCH_SIZE = 250;

	/** Gallery storage connection. */
	private \phpbb\db\driver\driver_interface $db;

	/** Gallery configuration, including the active image BBCode tag. */
	private \phpbbgallery\core\config $gallery_config;

	/** phpBB installation root. */
	private string $phpbb_root_path;

	/** phpBB PHP file extension. */
	private string $php_ext;

	/** BBCode definition table. */
	private string $bbcodes_table;

	/** @var array<string, array<string, string>> */
	private array $sources;

	public function __construct(
		\phpbb\db\driver\driver_interface $db,
		\phpbbgallery\core\config $gallery_config,
		string $phpbb_root_path,
		string $php_ext,
		string $bbcodes_table,
		string $posts_table,
		string $privmsgs_table,
		string $users_table
	)
	{
		$this->db = $db;
		$this->gallery_config = $gallery_config;
		$this->phpbb_root_path = $phpbb_root_path;
		$this->php_ext = $php_ext;
		$this->bbcodes_table = $bbcodes_table;
		$this->sources = [
			'post_text' => [
				'table' => $posts_table,
				'id' => 'post_id',
				'text' => 'post_text',
				'bitfield' => 'bbcode_bitfield',
			],
			'pm_text' => [
				'table' => $privmsgs_table,
				'id' => 'msg_id',
				'text' => 'message_text',
				'bitfield' => 'bbcode_bitfield',
			],
			'user_signature' => [
				'table' => $users_table,
				'id' => 'user_id',
				'text' => 'user_sig',
				'bitfield' => 'user_sig_bbcode_bitfield',
			],
		];
	}

	public function count_remaining(): int
	{
		$total = 0;
		foreach ($this->sources as $source)
		{
			$sql = 'SELECT COUNT(' . $source['id'] . ') AS legacy_count
				FROM ' . $source['table'] . '
				WHERE ' . $this->legacy_condition($source['text']);
			$result = $this->db->sql_query($sql);
			$total += (int) $this->db->sql_fetchfield('legacy_count');
			$this->db->sql_freeresult($result);
		}

		return $total;
	}

	/**
	 * Convert one bounded batch. Running the action again safely resumes the work.
	 *
	 * @return array{migrated: int, failed: int, remaining: int}
	 */
	public function migrate_batch(int $limit = self::BATCH_SIZE): array
	{
		$active_tag = $this->gallery_config->get_bbcode_tag();
		$bbcode_ids = $this->get_bbcode_ids($active_tag);
		$migrated = 0;
		$failed = 0;
		$remaining_capacity = max(1, $limit);

		foreach ($this->sources as $source)
		{
			if ($remaining_capacity === 0)
			{
				break;
			}

			foreach ($this->get_records($source, $remaining_capacity) as $record)
			{
				$remaining_capacity--;
				if ($this->migrate_record($source, $record, $active_tag, $bbcode_ids))
				{
					$migrated++;
				}
				else
				{
					$failed++;
				}
			}
		}

		return [
			'migrated' => $migrated,
			'failed' => $failed,
			'remaining' => $this->count_remaining(),
		];
	}

	/**
	 * Rewrite the two phpBB storage formats without invoking third-party parser events.
	 *
	 * @return array{text: string, classic_replacements: int, xml_replacements: int}
	 */
	public function rewrite_stored_text(string $text, string $active_tag): array
	{
		$active_tag = $this->normalize_active_tag($active_tag);
		$classic_replacements = 0;
		$xml_replacements = 0;
		$classic = preg_replace_callback(
			'~\[album:([a-z0-9]+)\]\s*([0-9]+)\s*\[/album:\1\]~i',
			static function (array $match) use ($active_tag, &$classic_replacements): string
			{
				$classic_replacements++;

				return '[' . $active_tag . ':' . $match[1] . ']' . $match[2] . '[/' . $active_tag . ':' . $match[1] . ']';
			},
			$text
		);
		$classic = is_string($classic) ? $classic : $text;
		$xml_tag = strtoupper($active_tag);
		$xml = preg_replace_callback(
			'~<ALBUM content="([0-9]+)"><s>\[album\]</s>\1<e>\[/album\]</e></ALBUM>~i',
			static function (array $match) use ($active_tag, $xml_tag, &$xml_replacements): string
			{
				$xml_replacements++;

				return '<' . $xml_tag . ' content="' . $match[1] . '"><s>[' . $active_tag . ']</s>' .
					$match[1] . '<e>[/' . $active_tag . ']</e></' . $xml_tag . '>';
			},
			$classic
		);

		return [
			'text' => is_string($xml) ? $xml : $classic,
			'classic_replacements' => $classic_replacements,
			'xml_replacements' => $xml_replacements,
		];
	}

	/**
	 * @param array<string, string> $source
	 * @return array<int, array<string, mixed>>
	 */
	private function get_records(array $source, int $limit): array
	{
		$sql = 'SELECT ' . $source['id'] . ' AS record_id,
				' . $source['text'] . ' AS record_text,
				' . $source['bitfield'] . ' AS record_bitfield
			FROM ' . $source['table'] . '
			WHERE ' . $this->legacy_condition($source['text']) . '
			ORDER BY ' . $source['id'] . ' ASC';
		$result = $this->db->sql_query_limit($sql, $limit);
		$records = $this->db->sql_fetchrowset($result);
		$this->db->sql_freeresult($result);

		return $records;
	}

	/**
	 * @param array<string, string> $source
	 * @param array<string, mixed>  $record
	 * @param array<string, int>    $bbcode_ids
	 */
	private function migrate_record(array $source, array $record, string $active_tag, array $bbcode_ids): bool
	{
		$rewritten = $this->rewrite_stored_text((string) $record['record_text'], $active_tag);
		$total_replacements = $rewritten['classic_replacements'] + $rewritten['xml_replacements'];
		if ($total_replacements === 0)
		{
			return false;
		}

		$sql_ary = [$source['text'] => $rewritten['text']];
		if ($rewritten['classic_replacements'] > 0)
		{
			if (!isset($bbcode_ids['album'], $bbcode_ids[$active_tag]))
			{
				return false;
			}
			$this->load_content_functions();
			$bitfield = new \bitfield((string) $record['record_bitfield']);
			$bitfield->clear($bbcode_ids['album']);
			$bitfield->set($bbcode_ids[$active_tag]);
			$sql_ary[$source['bitfield']] = $bitfield->get_base64();
		}

		$sql = 'UPDATE ' . $source['table'] . '
			SET ' . $this->db->sql_build_array('UPDATE', $sql_ary) . '
			WHERE ' . $source['id'] . ' = ' . (int) $record['record_id'];
		$this->db->sql_query($sql);

		return true;
	}

	/** @return array<string, int> */
	private function get_bbcode_ids(string $active_tag): array
	{
		$ids = [];
		$sql = 'SELECT bbcode_id, bbcode_tag
			FROM ' . $this->bbcodes_table . '
			WHERE ' . $this->db->sql_in_set('LOWER(bbcode_tag)', ['album', $active_tag]);
		$result = $this->db->sql_query($sql);
		while ($row = $this->db->sql_fetchrow($result))
		{
			$ids[strtolower((string) $row['bbcode_tag'])] = (int) $row['bbcode_id'];
		}
		$this->db->sql_freeresult($result);

		return $ids;
	}

	private function legacy_condition(string $column): string
	{
		$conditions = [];
		foreach (range(0, 9) as $digit)
		{
			// Classic phpBB storage includes a BBCode UID; current phpBB storage uses
			// XML. Requiring a numeric body excludes documentation examples such as
			// [album:%]%[/album:%]% from the migration counter and batches.
			$conditions[] = $column . " LIKE '%[album:%]" . $digit . "%[/album:%]%'";
			$conditions[] = $column . " LIKE '%<ALBUM content=\"" . $digit . "%[/album]%'";
		}

		return '(' . implode(' OR ', $conditions) . ')';
	}

	private function normalize_active_tag(string $active_tag): string
	{
		return in_array($active_tag, ['image', 'galleryimage'], true) ? $active_tag : 'image';
	}

	private function load_content_functions(): void
	{
		if (!class_exists('bitfield'))
		{
			include $this->phpbb_root_path . 'includes/functions_content.' . $this->php_ext;
		}
	}
}
