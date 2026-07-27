<?php
/**
 *
 * BBTags
 *
 * @copyright (c) 2015 SiteSplat All rights reserved
 * @license Proprietary
 *
 */

namespace sitesplat\bbtags\migrations\v33x;

/**
 * Convert the legacy topic-only tags into the global catalogue.
 */
class m8_global_catalog_data extends \phpbb\db\migration\migration
{
	const FORUM_PROVIDER = 'forum_topics';

	/**
	 * {@inheritdoc}
	 */
	public static function depends_on()
	{
		return array('\sitesplat\bbtags\migrations\v33x\m7_global_catalog_schema');
	}

	/**
	 * {@inheritdoc}
	 */
	public function update_data()
	{
		return array(
			array('custom', array(array($this, 'migrate_catalog'))),
		);
	}

	/**
	 * Normalize catalogue rows and preserve all valid topic associations.
	 */
	public function migrate_catalog()
	{
		$this->db->sql_transaction('begin');
		try
		{
			$this->normalize_existing_tags();
			$this->import_predefined_tags();
			$this->deduplicate_topic_relations();
			$this->synchronize_forum_context();
		}
		catch (\Throwable $exception)
		{
			$this->db->sql_transaction('rollback');
			throw $exception;
		}

		$this->db->sql_transaction('commit');
	}

	/**
	 * Normalize existing rows and merge equivalent canonical names.
	 */
	protected function normalize_existing_tags()
	{
		$table = $this->table_prefix . 'bbtags';
		$sql = 'SELECT id, tag, route, is_predefined
			FROM ' . $table . '
			ORDER BY id ASC';
		$result = $this->db->sql_query($sql);
		$canonical = $duplicates = array();
		while ($row = $this->db->sql_fetchrow($result))
		{
			$row['id'] = (int) $row['id'];
			$row['tag'] = $this->normalize_display_name($row['tag'], $row['id']);
			$row['tag_clean'] = $this->canonical_name($row['tag'], $row['id']);
			$row['is_predefined'] = !empty($row['is_predefined']);

			if (isset($canonical[$row['tag_clean']]))
			{
				$canonical[$row['tag_clean']]['is_predefined'] = $canonical[$row['tag_clean']]['is_predefined'] || $row['is_predefined'];
				$duplicates[$row['id']] = $canonical[$row['tag_clean']]['id'];
				continue;
			}

			$canonical[$row['tag_clean']] = $row;
		}
		$this->db->sql_freeresult($result);

		foreach ($duplicates as $duplicate_id => $canonical_id)
		{
			$sql = 'UPDATE ' . $this->table_prefix . 'bbtags_topic
				SET tag_id = ' . (int) $canonical_id . '
				WHERE tag_id = ' . (int) $duplicate_id;
			$this->db->sql_query($sql);
		}

		if (!empty($duplicates))
		{
			$sql = 'DELETE FROM ' . $table . '
				WHERE ' . $this->db->sql_in_set('id', array_keys($duplicates));
			$this->db->sql_query($sql);
		}

		$used_routes = array();
		foreach ($canonical as $row)
		{
			$route = $this->unique_route($row['route'], $row['tag'], $row['id'], $used_routes);
			$sql_ary = array(
				'tag' => $row['tag'],
				'tag_clean' => $row['tag_clean'],
				'route' => $route,
				'is_predefined' => (int) $row['is_predefined'],
			);
			$sql = 'UPDATE ' . $table . '
				SET ' . $this->db->sql_build_array('UPDATE', $sql_ary) . '
				WHERE id = ' . (int) $row['id'];
			$this->db->sql_query($sql);
		}
	}

	/**
	 * Import the legacy predefined list without removing its config fallback.
	 */
	protected function import_predefined_tags()
	{
		$config_text_table = defined('CONFIG_TEXT_TABLE') ? CONFIG_TEXT_TABLE : $this->table_prefix . 'config_text';
		$sql = 'SELECT config_value
			FROM ' . $config_text_table . "
			WHERE config_name = 'bbtags_pre_tags'";
		$result = $this->db->sql_query($sql);
		$row = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);
		$predefined = $row ? json_decode($row['config_value'], true) : array();
		if (!is_array($predefined) || empty($predefined))
		{
			return;
		}

		$table = $this->table_prefix . 'bbtags';
		$sql = 'SELECT id, tag_clean, route FROM ' . $table . ' ORDER BY id ASC';
		$result = $this->db->sql_query($sql);
		$catalog = $used_routes = array();
		while ($tag_row = $this->db->sql_fetchrow($result))
		{
			$catalog[$tag_row['tag_clean']] = (int) $tag_row['id'];
			$used_routes[$tag_row['route']] = true;
		}
		$this->db->sql_freeresult($result);

		foreach ($predefined as $tag)
		{
			$display_name = $this->normalize_display_name($tag);
			if ($display_name === '')
			{
				continue;
			}

			$tag_clean = $this->canonical_name($display_name);
			if (isset($catalog[$tag_clean]))
			{
				$sql = 'UPDATE ' . $table . '
					SET is_predefined = 1
					WHERE id = ' . $catalog[$tag_clean];
				$this->db->sql_query($sql);
				continue;
			}

			$route = $this->unique_route('', $display_name, 0, $used_routes);
			$sql_ary = array(
				'tag' => $display_name,
				'tag_clean' => $tag_clean,
				'route' => $route,
				'count' => 0,
				'is_predefined' => 1,
				'created_by' => 0,
				'created_at' => 0,
			);
			$sql = 'INSERT INTO ' . $table . ' ' . $this->db->sql_build_array('INSERT', $sql_ary);
			$this->db->sql_query($sql);
			$catalog[$tag_clean] = (int) $this->db->sql_nextid();
		}
	}

	/**
	 * Remove duplicate topic/tag pairs before adding the unique index.
	 */
	protected function deduplicate_topic_relations()
	{
		$table = $this->table_prefix . 'bbtags_topic';
		$sql = 'SELECT id, topic_id, tag_id
			FROM ' . $table . '
			ORDER BY topic_id ASC, tag_id ASC, id ASC';
		$result = $this->db->sql_query($sql);
		$seen = $duplicate_ids = array();
		while ($row = $this->db->sql_fetchrow($result))
		{
			$key = (int) $row['topic_id'] . ':' . (int) $row['tag_id'];
			if (isset($seen[$key]))
			{
				$duplicate_ids[] = (int) $row['id'];
				continue;
			}
			$seen[$key] = true;
		}
		$this->db->sql_freeresult($result);

		if (!empty($duplicate_ids))
		{
			$sql = 'DELETE FROM ' . $table . '
				WHERE ' . $this->db->sql_in_set('id', $duplicate_ids);
			$this->db->sql_query($sql);
		}
	}

	/**
	 * Seed the forum provider usage count and refresh the legacy count column.
	 */
	protected function synchronize_forum_context()
	{
		$tags_table = $this->table_prefix . 'bbtags';
		$topic_table = $this->table_prefix . 'bbtags_topic';
		$context_table = $this->table_prefix . 'bbtags_context';
		$sql = 'SELECT t.id, COUNT(tt.topic_id) AS usage_count
			FROM ' . $tags_table . ' t
			LEFT JOIN ' . $topic_table . ' tt ON tt.tag_id = t.id
			GROUP BY t.id
			ORDER BY t.id ASC';
		$result = $this->db->sql_query($sql);
		while ($row = $this->db->sql_fetchrow($result))
		{
			$tag_id = (int) $row['id'];
			$usage_count = (int) $row['usage_count'];
			$sql = 'UPDATE ' . $tags_table . '
				SET count = ' . $usage_count . '
				WHERE id = ' . $tag_id;
			$this->db->sql_query($sql);

			$sql_ary = array(
				'tag_id' => $tag_id,
				'provider' => self::FORUM_PROVIDER,
				'usage_count' => $usage_count,
				'is_enabled' => 1,
			);
			$sql = 'INSERT INTO ' . $context_table . ' ' . $this->db->sql_build_array('INSERT', $sql_ary);
			$this->db->sql_query($sql);
		}
		$this->db->sql_freeresult($result);
	}

	/**
	 * Normalize a tag label while retaining its human-readable form.
	 *
	 * @param string $tag    Tag label
	 * @param int    $tag_id Existing identifier used for corrupt empty labels
	 *
	 * @return string
	 */
	protected function normalize_display_name($tag, $tag_id = 0)
	{
		$tag = function_exists('utf8_normalize_nfc') ? utf8_normalize_nfc((string) $tag) : (string) $tag;
		$tag = preg_replace('#[\x00-\x1F\x7F]+#u', '', $tag);
		$tag = trim($tag, " \t\n\r\0\x0B.,");
		$tag = function_exists('utf8_substr') ? utf8_substr($tag, 0, 64) : mb_substr($tag, 0, 64, 'UTF-8');

		return ($tag !== '') ? $tag : (($tag_id > 0) ? 'tag-' . $tag_id : '');
	}

	/**
	 * Build the case-insensitive canonical lookup value.
	 *
	 * @param string $tag    Tag label
	 * @param int    $tag_id Existing identifier used for corrupt empty labels
	 *
	 * @return string
	 */
	protected function canonical_name($tag, $tag_id = 0)
	{
		$clean = function_exists('utf8_clean_string') ? utf8_clean_string($tag) : mb_strtolower($tag, 'UTF-8');
		$clean = trim($clean);

		return ($clean !== '') ? $clean : (($tag_id > 0) ? 'tag-' . $tag_id : '');
	}

	/**
	 * Create a stable, unique route within the catalogue.
	 *
	 * @param string $current_route Existing route
	 * @param string $tag           Tag label
	 * @param int    $tag_id        Tag identifier
	 * @param array  $used_routes   Routes already assigned
	 *
	 * @return string
	 */
	protected function unique_route($current_route, $tag, $tag_id, array &$used_routes)
	{
		$route = trim((string) $current_route);
		if ($route === '')
		{
			$route = $this->canonical_name($tag, $tag_id);
			$route = preg_replace('/[^\p{L}\p{Nd}]+/u', '-', $route);
			$route = trim($route, '-');
		}
		$route = function_exists('utf8_substr') ? utf8_substr($route, 0, 64) : mb_substr($route, 0, 64, 'UTF-8');
		if ($route === '')
		{
			$route = 'tag-' . max(1, (int) $tag_id);
		}

		$base = $route;
		$suffix = ($tag_id > 0) ? '-' . $tag_id : '-tag';
		$attempt = 1;
		while (isset($used_routes[$route]))
		{
			$current_suffix = ($attempt === 1) ? $suffix : $suffix . '-' . $attempt;
			$maximum_base = 64 - strlen($current_suffix);
			$route = (function_exists('utf8_substr') ? utf8_substr($base, 0, $maximum_base) : mb_substr($base, 0, $maximum_base, 'UTF-8')) . $current_suffix;
			$attempt++;
		}

		$used_routes[$route] = true;
		return $route;
	}
}
