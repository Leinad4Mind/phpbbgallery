<?php
/**
*
* BBtags
*
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bbtags\tags;

use phpbb\db\driver\driver_interface;
use phpbb\config\config;
use phpbb\auth\auth;

/**
 * @ignore
 */

/**
* Handles all functionality regarding tags.
*/
class manager
{
	const FORUM_PROVIDER = 'forum_topics';
	const MAX_TAG_LENGTH = 64;

	private $db;
	private $config;
	private $auth;

	private $table_bbtags;
	private $table_bbtags_context;
	private $table_bbtags_scope;
	private $table_bbtags_topic;

	public function __construct(driver_interface $db, config $config, auth $auth, $table_bbtags, $table_bbtags_context, $table_bbtags_scope, $table_bbtags_topic)
	{
		$this->db					= $db;
		$this->config				= $config;
		$this->auth					= $auth;
		$this->table_bbtags			= $table_bbtags;
		$this->table_bbtags_context	= $table_bbtags_context;
		$this->table_bbtags_scope	= $table_bbtags_scope;
		$this->table_bbtags_topic	= $table_bbtags_topic;
	}

	public function get_tags($topic_id)
	{
		$topic_id = (int) $topic_id;
		$sql = 'SELECT t.id, t.tag';
		if ($topic_id > 0)
		{
			$sql .= ', topics.forum_id
				FROM ' . $this->table_bbtags . ' t
				JOIN ' . $this->table_bbtags_topic . ' tt ON tt.tag_id = t.id
				JOIN ' . TOPICS_TABLE . ' topics ON topics.topic_id = tt.topic_id
				JOIN ' . $this->table_bbtags_context . ' tc ON tc.tag_id = t.id
				WHERE tt.topic_id = ' . $topic_id . '
					AND tc.provider = \'' . self::FORUM_PROVIDER . '\'
					AND tc.is_enabled = 1';
		}
		else
		{
			$sql .= '
				FROM ' . $this->table_bbtags . ' t
				JOIN ' . $this->table_bbtags_context . ' tc ON tc.tag_id = t.id
				WHERE tc.provider = \'' . self::FORUM_PROVIDER . '\'
					AND tc.is_enabled = 1';
		}
		$sql .= ' ORDER BY t.count DESC';
		$result = $this->db->sql_query_limit($sql, $topic_id ? $this->config['bbtags_max_tags'] : $this->config['bbtags_cloud_limit']);
		$rows = array();
		while ($row = $this->db->sql_fetchrow($result))
		{
			$rows[] = $row;
		}
		$this->db->sql_freeresult($result);
		if ($topic_id > 0 && !empty($rows))
		{
			$scope_path = $this->get_forum_scope_path((int) $rows[0]['forum_id']);
			$available = array_flip($this->filter_available_tag_ids(array_column($rows, 'id'), self::FORUM_PROVIDER, $scope_path));
			$rows = array_filter($rows, static function ($row) use ($available)
			{
				return isset($available[(int) $row['id']]);
			});
		}

		return implode(', ', array_column($rows, 'tag'));
	}

	public function remove_tags_from_topics($topic_ids)
	{
		$topic_ids = array_values(array_filter(array_map('intval', (array) $topic_ids)));
		if (empty($topic_ids))
		{
			return 0;
		}

		$this->db->sql_transaction('begin');
		try
		{
			$affected = $this->delete_topic_relations($topic_ids);
			if ($affected === false || $this->delete_unused_tags() === false || !$this->calc_count_tags())
			{
				$this->db->sql_transaction('rollback');
				return false;
			}
		}
		catch (\Throwable $exception)
		{
			$this->db->sql_transaction('rollback');
			throw $exception;
		}

		$this->db->sql_transaction('commit');
		return $affected;
	}

	private function delete_topic_relations(array $topic_ids)
	{
		if (empty($topic_ids))
		{
			return 0;
		}

		$sql = 'DELETE FROM ' . $this->table_bbtags_topic . '
			WHERE ' . $this->db->sql_in_set('topic_id', $topic_ids);
		if ($this->db->sql_query($sql) === false)
		{
			return false;
		}

		return $this->db->sql_affectedrows();
	}

	private function get_unused_tag_ids()
	{
		$sql = 'SELECT t.id
			FROM ' . $this->table_bbtags . ' t
			WHERE t.is_predefined = 0
				AND NOT EXISTS (
				SELECT 1
				FROM ' . $this->table_bbtags_topic . ' tt
					WHERE tt.tag_id = t.id
			)
				AND NOT EXISTS (
				SELECT 1
				FROM ' . $this->table_bbtags_context . " tc
					WHERE tc.tag_id = t.id
						AND tc.provider <> '" . self::FORUM_PROVIDER . "'
						AND (tc.is_enabled = 1 OR tc.usage_count > 0)
			)";
		$result = $this->db->sql_query($sql);
		$ids = array();
		while ($row = $this->db->sql_fetchrow($result))
		{
			$ids[] = (int) $row['id'];
		}
		$this->db->sql_freeresult($result);
		return $ids;
	}

	public function delete_unused_tags()
	{
		$ids = $this->get_unused_tag_ids();
		if (empty($ids))
		{
			return 0;
		}
		$sql = 'DELETE FROM ' . $this->table_bbtags_scope . ' WHERE ' . $this->db->sql_in_set('tag_id', $ids);
		if ($this->db->sql_query($sql) === false)
		{
			return false;
		}
		$sql = 'DELETE FROM ' . $this->table_bbtags_context . ' WHERE ' . $this->db->sql_in_set('tag_id', $ids);
		if ($this->db->sql_query($sql) === false)
		{
			return false;
		}
		$sql = 'DELETE FROM ' . $this->table_bbtags . ' WHERE ' . $this->db->sql_in_set('id', $ids);
		if ($this->db->sql_query($sql) === false)
		{
			return false;
		}
		return $this->db->sql_affectedrows();
	}

	/**
	 * Delete a tag and all of its topic associations.
	 *
	 * @param int $tag_id Tag identifier
	 *
	 * @return bool True when the operation completed successfully
	 */
	public function delete_tag($tag_id)
	{
		$tag_id = (int) $tag_id;
		if ($tag_id <= 0)
		{
			return false;
		}

		$this->db->sql_transaction('begin');
		$sql = 'DELETE FROM ' . $this->table_bbtags_topic . '
			WHERE tag_id = ' . $tag_id;
		if ($this->db->sql_query($sql) === false)
		{
			$this->db->sql_transaction('rollback');
			return false;
		}

		$sql = 'DELETE FROM ' . $this->table_bbtags_scope . '
			WHERE tag_id = ' . $tag_id;
		if ($this->db->sql_query($sql) === false)
		{
			$this->db->sql_transaction('rollback');
			return false;
		}

		$sql = 'DELETE FROM ' . $this->table_bbtags_context . '
			WHERE tag_id = ' . $tag_id;
		if ($this->db->sql_query($sql) === false)
		{
			$this->db->sql_transaction('rollback');
			return false;
		}

		$sql = 'DELETE FROM ' . $this->table_bbtags . '
			WHERE id = ' . $tag_id;
		if ($this->db->sql_query($sql) === false)
		{
			$this->db->sql_transaction('rollback');
			return false;
		}

		$this->db->sql_transaction('commit');
		return true;
	}

	/**
	 * Rename an existing tag using the database driver's escaping rules.
	 *
	 * @param int    $tag_id Tag identifier
	 * @param string $tag    New tag name
	 *
	 * @return bool True when the operation completed successfully
	 */
	public function rename_tag($tag_id, $tag)
	{
		$tag_id = (int) $tag_id;
		$tag = $this->clean_tag($tag);
		if ($tag_id <= 0 || $tag === '')
		{
			return false;
		}

		$sql_ary = array(
			'tag' => $tag,
			'tag_clean' => $this->canonical_tag($tag),
			'route' => $this->unique_route($tag, $tag_id),
		);
		$sql = 'UPDATE ' . $this->table_bbtags . '
			SET ' . $this->db->sql_build_array('UPDATE', $sql_ary) . '
			WHERE id = ' . $tag_id;
		return $this->db->sql_query($sql) !== false;
	}

	public function assign_tags_to_topic(int $topic_id, array $valid_tags, int $forum_id = 0, bool $create_missing = true): bool
	{
		$topic_id = (int) $topic_id;
		if ($topic_id <= 0)
		{
			return false;
		}

		$tags = array();
		foreach ((array) $valid_tags as $tag)
		{
			$tag = $this->clean_tag($tag);
			if ($tag !== '')
			{
				$tags[] = $tag;
			}
		}
		$tags = array_values(array_unique($tags));

		$this->db->sql_transaction('begin');
		try
		{
			if ($create_missing && !$this->create_missing_tags($tags))
			{
				$this->db->sql_transaction('rollback');
				return false;
			}

			$ids = $this->get_existing_tags($tags, true);
			if ($create_missing && !$this->ensure_forum_contexts($ids))
			{
				$this->db->sql_transaction('rollback');
				return false;
			}
			$ids = $this->filter_available_tag_ids($ids, self::FORUM_PROVIDER, $this->get_forum_scope_path($forum_id));
			if ($this->delete_topic_relations(array($topic_id)) === false)
			{
				$this->db->sql_transaction('rollback');
				return false;
			}

			if (!empty($ids))
			{
				$sql_ary = array();
				foreach ($ids as $id)
				{
					$sql_ary[] = array('topic_id' => $topic_id, 'tag_id' => (int) $id);
				}
				if ($this->db->sql_multi_insert($this->table_bbtags_topic, $sql_ary) === false)
				{
					$this->db->sql_transaction('rollback');
					return false;
				}
			}

			if ($this->delete_unused_tags() === false || !$this->calc_count_tags())
			{
				$this->db->sql_transaction('rollback');
				return false;
			}
		}
		catch (\Throwable $exception)
		{
			$this->db->sql_transaction('rollback');
			throw $exception;
		}

		$this->db->sql_transaction('commit');
		return true;
	}

	private function create_missing_tags($tags, $created_by = 0)
	{
		if (empty($tags))
		{
			return true;
		}

		$tags = array_unique($tags);
		$existing_tags = $this->get_existing_tags($tags);
		$existing_clean = array();
		foreach ($existing_tags as $existing_tag)
		{
			$existing_clean[] = isset($existing_tag['tag_clean']) ? $existing_tag['tag_clean'] : $this->canonical_tag($existing_tag['tag']);
		}

		$sql_ary_new_tags = array();
		$reserved_routes = array();
		foreach ($tags as $tag)
		{
			$tag_clean = $this->canonical_tag($tag);
			if (!in_array($tag_clean, $existing_clean, true))
			{
				$sql_ary_new_tags[] = array(
					'tag' => $tag,
					'tag_clean' => $tag_clean,
					'route' => $this->unique_route($tag, 0, $reserved_routes),
					'count' => 0,
					'is_predefined' => 0,
					'created_by' => max(0, (int) $created_by),
					'created_at' => time(),
				);
				$existing_clean[] = $tag_clean;
			}
		}
		if (empty($sql_ary_new_tags))
		{
			return true;
		}

		return $this->db->sql_multi_insert($this->table_bbtags, $sql_ary_new_tags) !== false;
	}

	public function get_existing_tags($tags = null, $only_ids = false)
	{
		$where = '';
		if (!is_null($tags))
		{
			if (empty($tags))
			{
				return array();
			}
			$tags = array_values(array_unique(array_map(array($this, 'canonical_tag'), $tags)));
			$where = ' WHERE ' . $this->db->sql_in_set('tag_clean', $tags);
		}
		$sql = 'SELECT id, tag, tag_clean FROM ' . $this->table_bbtags . $where;
		$result = $this->db->sql_query($sql);
		$ids = array();
		while ($row = $this->db->sql_fetchrow($result))
		{
			$ids[] = ($only_ids) ? $row['id'] : array('id' => $row['id'], 'tag' => $row['tag'], 'tag_clean' => $row['tag_clean']);
		}
		$this->db->sql_freeresult($result);
		return $ids;
	}

	/**
	 * Return submitted tags that are already enabled in the effective provider scope.
	 */
	public function get_available_tags(array $tags, string $provider, array $scope_path): array
	{
		return $this->classify_tags($tags, $provider, $scope_path)['available'];
	}

	/**
	 * Classify submitted tags without allowing explicit provider or scope denials
	 * to be converted into moderation suggestions.
	 *
	 * @return array{available: array, suggestible: array, blocked: array}
	 */
	public function classify_tags(array $tags, string $provider, array $scope_path): array
	{
		$normalized = [];
		foreach ($tags as $tag)
		{
			$tag = $this->clean_tag($tag);
			$tag_clean = $this->canonical_tag($tag);
			if ($tag !== '' && $tag_clean !== '')
			{
				$normalized[$tag_clean] = $tag;
			}
		}
		if (empty($normalized))
		{
			return ['available' => [], 'suggestible' => [], 'blocked' => []];
		}

		$existing = $this->get_existing_tags(array_values($normalized));
		$rows_by_clean = [];
		$tag_ids = [];
		foreach ($existing as $row)
		{
			$rows_by_clean[(string) $row['tag_clean']] = $row;
			$tag_ids[] = (int) $row['id'];
		}

		$provider = $this->validate_provider($provider);
		if ($provider === '')
		{
			return ['available' => [], 'suggestible' => [], 'blocked' => array_values($normalized)];
		}
		$scope_path = array_values(array_unique(array_map('intval', $scope_path)));
		if (!in_array(0, $scope_path, true))
		{
			$scope_path[] = 0;
		}
		$contexts = [];
		$rules = [];
		if (!empty($tag_ids))
		{
			$sql = 'SELECT tag_id, scope_mode, is_enabled
				FROM ' . $this->table_bbtags_context . '
				WHERE provider = \'' . $this->db->sql_escape($provider) . '\'
					AND ' . $this->db->sql_in_set('tag_id', $tag_ids);
			$result = $this->db->sql_query($sql);
			while ($row = $this->db->sql_fetchrow($result))
			{
				$contexts[(int) $row['tag_id']] = $row;
			}
			$this->db->sql_freeresult($result);
			$rules = $this->load_scope_rules($tag_ids, $provider, $scope_path);
		}

		$classified = ['available' => [], 'suggestible' => [], 'blocked' => []];
		foreach ($normalized as $tag_clean => $tag)
		{
			if (!isset($rows_by_clean[$tag_clean]))
			{
				$classified['suggestible'][] = $tag;
				continue;
			}
			$tag_id = (int) $rows_by_clean[$tag_clean]['id'];
			if (!isset($contexts[$tag_id]))
			{
				$classified['suggestible'][] = $tag;
				continue;
			}
			if (empty($contexts[$tag_id]['is_enabled']))
			{
				$classified['blocked'][] = $tag;
				continue;
			}
			$scope_rule = $this->resolve_scope_rule($rules[$tag_id] ?? [], $scope_path);
			if ($scope_rule === 'deny')
			{
				$classified['blocked'][] = $tag;
			}
			else if ($scope_rule === 'allow' || $contexts[$tag_id]['scope_mode'] === 'global')
			{
				$classified['available'][] = (string) $rows_by_clean[$tag_clean]['tag'];
			}
			else
			{
				$classified['suggestible'][] = $tag;
			}
		}

		return $classified;
	}

	/**
	 * Create or resolve one canonical catalogue row.
	 *
	 * @return int|false Tag identifier
	 */
	public function ensure_catalog_tag(string $tag, int $created_by = 0): int|false
	{
		$tag = $this->clean_tag($tag);
		if ($tag === '' || !$this->create_missing_tags([$tag], $created_by))
		{
			return false;
		}
		$ids = $this->get_existing_tags([$tag], true);

		return empty($ids) ? false : (int) $ids[0];
	}

	/**
	 * Ensure that a catalogue tag is known and enabled by a provider.
	 */
	public function ensure_provider_context(int $tag_id, string $provider, string $scope_mode = 'global'): bool
	{
		$provider = $this->validate_provider($provider);
		if ($tag_id <= 0 || $provider === '' || !in_array($scope_mode, ['global', 'restricted'], true))
		{
			return false;
		}

		$sql = 'SELECT tag_id, is_enabled
			FROM ' . $this->table_bbtags_context . '
			WHERE tag_id = ' . $tag_id . '
				AND provider = \'' . $this->db->sql_escape($provider) . '\'';
		$result = $this->db->sql_query_limit($sql, 1);
		$row = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);
		if ($row)
		{
			if (!empty($row['is_enabled']))
			{
				return true;
			}
			$sql_ary = [
				'is_enabled' => 1,
				'scope_mode' => $scope_mode,
			];
			$sql = 'UPDATE ' . $this->table_bbtags_context . '
				SET ' . $this->db->sql_build_array('UPDATE', $sql_ary) . '
				WHERE tag_id = ' . $tag_id . '
					AND provider = \'' . $this->db->sql_escape($provider) . '\'';
			return $this->db->sql_query($sql) !== false;
		}

		return $this->insert_provider_context($tag_id, $provider, $scope_mode);
	}

	private function insert_provider_context(int $tag_id, string $provider, string $scope_mode): bool
	{
		$sql_ary = [
			'tag_id'      => $tag_id,
			'provider'    => $provider,
			'usage_count' => 0,
			'is_enabled'  => 1,
			'scope_mode'  => $scope_mode,
		];
		$sql = 'INSERT INTO ' . $this->table_bbtags_context . ' ' . $this->db->sql_build_array('INSERT', $sql_ary);

		return $this->db->sql_query($sql) !== false;
	}

	public function clean_tag($tag)
	{
		$tag = function_exists('utf8_normalize_nfc') ? utf8_normalize_nfc((string) $tag) : (string) $tag;
		$tag = preg_replace('#[\x00-\x1F\x7F]+#u', '', $tag);
		$tag = trim(utf8_strtolower($tag), " \t\n\r\0\x0B.,");
		$tag = utf8_substr($tag, 0, self::MAX_TAG_LENGTH);
		$tag = trim($tag);
		return $tag;
	}

	/**
	 * Return the canonical, case-insensitive lookup value for a tag.
	 *
	 * @param string $tag Tag label
	 *
	 * @return string
	 */
	public function canonical_tag($tag)
	{
		$tag = $this->clean_tag($tag);
		return function_exists('utf8_clean_string') ? utf8_clean_string($tag) : $tag;
	}

	public function calc_count_tags()
	{
		$sql = 'UPDATE ' . $this->table_bbtags . ' SET count = 0';
		if ($this->db->sql_query($sql) === false)
		{
			return false;
		}

		$sql = 'UPDATE ' . $this->table_bbtags_context . '
			SET usage_count = 0
			WHERE provider = \'' . self::FORUM_PROVIDER . '\'';
		if ($this->db->sql_query($sql) === false)
		{
			return false;
		}

		$sql = 'SELECT tag_id
			FROM ' . $this->table_bbtags_context . '
			WHERE provider = \'' . self::FORUM_PROVIDER . '\'';
		$context_result = $this->db->sql_query($sql);
		$context_ids = array();
		while ($context_row = $this->db->sql_fetchrow($context_result))
		{
			$context_ids[(int) $context_row['tag_id']] = true;
		}
		$this->db->sql_freeresult($context_result);

		$sql = 'SELECT tag_id, COUNT(topic_id) AS count FROM ' . $this->table_bbtags_topic . ' GROUP BY tag_id';
		$result = $this->db->sql_query($sql);
		$new_contexts = array();
		while ($row = $this->db->sql_fetchrow($result))
		{
			$tag_id = (int) $row['tag_id'];
			$count = (int) $row['count'];
			$sql = 'UPDATE ' . $this->table_bbtags . ' SET count = ' . $count . ' WHERE id = ' . $tag_id;
			if ($this->db->sql_query($sql) === false)
			{
				$this->db->sql_freeresult($result);
				return false;
			}

			if (isset($context_ids[$tag_id]))
			{
				$sql = 'UPDATE ' . $this->table_bbtags_context . '
					SET usage_count = ' . $count . ', is_enabled = 1
					WHERE tag_id = ' . $tag_id . '
						AND provider = \'' . self::FORUM_PROVIDER . '\'';
				if ($this->db->sql_query($sql) === false)
				{
					$this->db->sql_freeresult($result);
					return false;
				}
				continue;
			}

			$new_contexts[] = array(
				'tag_id' => $tag_id,
				'provider' => self::FORUM_PROVIDER,
				'usage_count' => $count,
				'is_enabled' => 1,
				'scope_mode' => 'global',
			);
		}
		$this->db->sql_freeresult($result);
		if (!empty($new_contexts) && $this->db->sql_multi_insert($this->table_bbtags_context, $new_contexts) === false)
		{
			return false;
		}

		return true;
	}

	/**
	 * Return predefined tags available to the forum provider.
	 *
	 * @param string $term  Optional canonical prefix
	 * @param int    $limit Maximum number of matches; zero means unlimited
	 *
	 * @return array
	 */
	public function get_predefined_tags($term = '', $limit = 0, $forum_id = 0)
	{
		$sql = 'SELECT t.id, t.tag, tc.scope_mode
			FROM ' . $this->table_bbtags . ' t
			JOIN ' . $this->table_bbtags_context . " tc ON tc.tag_id = t.id
			WHERE t.is_predefined = 1
				AND tc.provider = '" . self::FORUM_PROVIDER . "'
				AND tc.is_enabled = 1
			ORDER BY t.tag ASC";
		$result = $this->db->sql_query($sql);
		$term = $this->canonical_tag($term);
		$rows = array();
		while ($row = $this->db->sql_fetchrow($result))
		{
			$rows[] = $row;
		}
		$this->db->sql_freeresult($result);

		$scope_path = $this->get_forum_scope_path($forum_id);
		$rules = $this->load_scope_rules(array_column($rows, 'id'), self::FORUM_PROVIDER, $scope_path);
		$tags = array();
		foreach ($rows as $row)
		{
			$tag = (string) $row['tag'];
			if ($term !== '' && strpos($this->canonical_tag($tag), $term) !== 0)
			{
				continue;
			}
			$tag_id = (int) $row['id'];
			$scope_mode = isset($row['scope_mode']) ? $row['scope_mode'] : 'global';
			if (!$this->scope_allows($scope_mode, isset($rules[$tag_id]) ? $rules[$tag_id] : array(), $scope_path))
			{
				continue;
			}
			$tags[] = $tag;
			if ($limit > 0 && count($tags) >= $limit)
			{
				break;
			}
		}
		return $tags;
	}

	/**
	 * Return enabled provider tags available in at least one supplied scope.
	 *
	 * @param string $term        Optional canonical prefix
	 * @param int    $limit       Maximum matches; zero means unlimited
	 * @param string $provider    Provider name
	 * @param array  $scope_paths Scope paths indexed by leaf identifier
	 *
	 * @return array
	 */
	public function get_provider_tags($term, $limit, $provider, array $scope_paths)
	{
		$provider = $this->validate_provider($provider);
		if ($provider === '' || empty($scope_paths))
		{
			return array();
		}
		$sql = 'SELECT t.id, t.tag
			FROM ' . $this->table_bbtags . ' t
			INNER JOIN ' . $this->table_bbtags_context . " tc ON tc.tag_id = t.id
			WHERE tc.provider = '" . $this->db->sql_escape($provider) . "'
				AND tc.is_enabled = 1
			ORDER BY t.tag ASC";
		$result = $this->db->sql_query($sql);
		$rows = array();
		while ($row = $this->db->sql_fetchrow($result))
		{
			$rows[] = $row;
		}
		$this->db->sql_freeresult($result);

		$term = $this->canonical_tag($term);
		$allowed_scopes = $this->get_allowed_scope_ids_by_tag(
			array_column($rows, 'id'),
			$provider,
			$scope_paths
		);
		$tags = array();
		foreach ($rows as $row)
		{
			$tag_id = (int) $row['id'];
			$tag = (string) $row['tag'];
			if (empty($allowed_scopes[$tag_id])
				|| ($term !== '' && strpos($this->canonical_tag($tag), $term) !== 0))
			{
				continue;
			}
			$tags[] = $tag;
			if ($limit > 0 && count($tags) >= $limit)
			{
				break;
			}
		}

		return $tags;
	}

	/**
	 * Replace the global predefined list and enable it for forum topics.
	 *
	 * @param array $tags       Tag labels
	 * @param int   $created_by Administrator identifier for new catalogue rows
	 *
	 * @return bool
	 */
	public function replace_predefined_tags(array $tags, $created_by = 0)
	{
		$normalized = array();
		foreach ($tags as $tag)
		{
			$tag = $this->clean_tag($tag);
			if ($tag !== '')
			{
				$normalized[$this->canonical_tag($tag)] = $tag;
			}
		}
		$normalized = array_values($normalized);

		$this->db->sql_transaction('begin');
		try
		{
			$sql = 'UPDATE ' . $this->table_bbtags . ' SET is_predefined = 0';
			if ($this->db->sql_query($sql) === false || !$this->create_missing_tags($normalized, $created_by))
			{
				$this->db->sql_transaction('rollback');
				return false;
			}

			$ids = $this->get_existing_tags($normalized, true);
			if (!empty($ids))
			{
				$sql = 'UPDATE ' . $this->table_bbtags . '
					SET is_predefined = 1
					WHERE ' . $this->db->sql_in_set('id', $ids);
				if ($this->db->sql_query($sql) === false || !$this->ensure_forum_contexts($ids))
				{
					$this->db->sql_transaction('rollback');
					return false;
				}
			}
		}
		catch (\Throwable $exception)
		{
			$this->db->sql_transaction('rollback');
			throw $exception;
		}

		$this->db->sql_transaction('commit');
		return true;
	}

	/**
	 * Add missing forum context rows without changing their usage counts.
	 *
	 * @param array $tag_ids Tag identifiers
	 *
	 * @return bool
	 */
	private function ensure_forum_contexts(array $tag_ids)
	{
		$tag_ids = array_values(array_unique(array_map('intval', $tag_ids)));
		if (empty($tag_ids))
		{
			return true;
		}

		$sql = 'SELECT tag_id
			FROM ' . $this->table_bbtags_context . '
			WHERE provider = \'' . self::FORUM_PROVIDER . '\'
				AND ' . $this->db->sql_in_set('tag_id', $tag_ids);
		$result = $this->db->sql_query($sql);
		$existing = array();
		while ($row = $this->db->sql_fetchrow($result))
		{
			$existing[(int) $row['tag_id']] = true;
		}
		$this->db->sql_freeresult($result);

		$new_contexts = array();
		foreach ($tag_ids as $tag_id)
		{
			if (!isset($existing[$tag_id]))
			{
				$new_contexts[] = array(
					'tag_id' => $tag_id,
					'provider' => self::FORUM_PROVIDER,
					'usage_count' => 0,
					'is_enabled' => 1,
					'scope_mode' => 'global',
				);
			}
		}

		return empty($new_contexts) || $this->db->sql_multi_insert($this->table_bbtags_context, $new_contexts) !== false;
	}

	/**
	 * Confirm that a moderation subject is the requested forum topic.
	 */
	public function topic_matches_scope(int $topic_id, int $forum_id): bool
	{
		if ($topic_id <= 0 || $forum_id <= 0)
		{
			return false;
		}
		$sql = 'SELECT forum_id
			FROM ' . TOPICS_TABLE . '
			WHERE topic_id = ' . $topic_id;
		$result = $this->db->sql_query_limit($sql, 1);
		$row = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);

		return $row && (int) $row['forum_id'] === $forum_id;
	}

	/**
	 * Attach an approved catalogue tag to its originating forum topic.
	 */
	public function attach_tag_to_topic(int $tag_id, int $topic_id, int $forum_id): bool
	{
		if ($tag_id <= 0 || !$this->topic_matches_scope($topic_id, $forum_id))
		{
			return false;
		}
		$sql = 'SELECT id
			FROM ' . $this->table_bbtags_topic . '
			WHERE topic_id = ' . $topic_id . '
				AND tag_id = ' . $tag_id;
		$result = $this->db->sql_query_limit($sql, 1);
		$row = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);
		if (!$row)
		{
			$sql_ary = ['topic_id' => $topic_id, 'tag_id' => $tag_id];
			$sql = 'INSERT INTO ' . $this->table_bbtags_topic . ' ' . $this->db->sql_build_array('INSERT', $sql_ary);
			if ($this->db->sql_query($sql) === false)
			{
				return false;
			}
		}

		return $this->calc_count_tags();
	}

	/**
	 * Return the current forum followed by its ancestors and the global root.
	 *
	 * @param int $forum_id Forum identifier
	 *
	 * @return array
	 */
	public function get_forum_scope_path($forum_id)
	{
		$forum_id = (int) $forum_id;
		if ($forum_id <= 0)
		{
			return array(0);
		}

		$sql = 'SELECT forum_left, forum_right
			FROM ' . FORUMS_TABLE . '
			WHERE forum_id = ' . $forum_id;
		$result = $this->db->sql_query($sql);
		$row = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);
		if (!$row)
		{
			return array($forum_id, 0);
		}

		$sql = 'SELECT forum_id
			FROM ' . FORUMS_TABLE . '
			WHERE forum_left <= ' . (int) $row['forum_left'] . '
				AND forum_right >= ' . (int) $row['forum_right'] . '
			ORDER BY forum_left DESC';
		$result = $this->db->sql_query($sql);
		$path = array();
		while ($ancestor = $this->db->sql_fetchrow($result))
		{
			$path[] = (int) $ancestor['forum_id'];
		}
		$this->db->sql_freeresult($result);
		$path[] = 0;

		return array_values(array_unique($path));
	}

	/**
	 * Return every forum path from the forum itself to the global root.
	 *
	 * @return array Paths indexed by forum identifier
	 */
	public function get_forum_scope_paths()
	{
		$sql = 'SELECT forum_id, forum_left, forum_right
			FROM ' . FORUMS_TABLE . '
			ORDER BY forum_left ASC';
		$result = $this->db->sql_query($sql);
		$forums = array();
		while ($row = $this->db->sql_fetchrow($result))
		{
			$forums[] = array(
				'forum_id' => (int) $row['forum_id'],
				'forum_left' => (int) $row['forum_left'],
				'forum_right' => (int) $row['forum_right'],
			);
		}
		$this->db->sql_freeresult($result);

		$paths = array(0 => array(0));
		foreach ($forums as $forum)
		{
			$ancestors = array();
			foreach ($forums as $candidate)
			{
				if ($candidate['forum_left'] <= $forum['forum_left'] && $candidate['forum_right'] >= $forum['forum_right'])
				{
					$ancestors[$candidate['forum_left']] = $candidate['forum_id'];
				}
			}
			krsort($ancestors, SORT_NUMERIC);
			$ancestors[] = 0;
			$paths[$forum['forum_id']] = array_values(array_unique($ancestors));
		}

		return $paths;
	}

	/**
	 * Return the complete forum tree in display order for policy editing.
	 *
	 * Categories remain in the tree because rules assigned to them are inherited
	 * by every descendant forum.
	 *
	 * @return array<int, array{forum_id: int, parent_id: int, forum_name: string, depth: int}>
	 */
	public function get_forum_tree(): array
	{
		$sql = 'SELECT forum_id, parent_id, forum_name, left_id
			FROM ' . FORUMS_TABLE . '
			ORDER BY left_id ASC, forum_id ASC';
		$result = $this->db->sql_query($sql);
		$rows = [];
		$parents = [];
		while ($row = $this->db->sql_fetchrow($result))
		{
			$forum_id = (int) $row['forum_id'];
			$parent_id = max(0, (int) $row['parent_id']);
			$rows[$forum_id] = [
				'forum_id' => $forum_id,
				'parent_id' => $parent_id,
				'forum_name' => (string) $row['forum_name'],
				'depth' => 0,
			];
			$parents[$forum_id] = $parent_id;
		}
		$this->db->sql_freeresult($result);

		foreach ($rows as $forum_id => &$row)
		{
			$parent_id = $parents[$forum_id];
			$seen = [$forum_id => true];
			while ($parent_id > 0 && isset($parents[$parent_id]) && !isset($seen[$parent_id]))
			{
				$seen[$parent_id] = true;
				$row['depth']++;
				$parent_id = $parents[$parent_id];
			}
		}
		unset($row);

		return array_values($rows);
	}

	/**
	 * Resolve the forum identifiers in which each tag is currently available.
	 *
	 * @param array $tag_ids Tag identifiers
	 *
	 * @return array Forum identifiers indexed by tag identifier
	 */
	public function get_allowed_forum_ids_by_tag(array $tag_ids)
	{
		$tag_ids = array_values(array_unique(array_filter(array_map('intval', $tag_ids))));
		if (empty($tag_ids))
		{
			return array();
		}

		$sql = 'SELECT tag_id, scope_mode, is_enabled
			FROM ' . $this->table_bbtags_context . '
			WHERE provider = \'' . self::FORUM_PROVIDER . '\'
				AND ' . $this->db->sql_in_set('tag_id', $tag_ids);
		$result = $this->db->sql_query($sql);
		$contexts = array();
		while ($row = $this->db->sql_fetchrow($result))
		{
			$contexts[(int) $row['tag_id']] = $row;
		}
		$this->db->sql_freeresult($result);

		$scope_paths = $this->get_forum_scope_paths();
		$rules = $this->load_scope_rules($tag_ids, self::FORUM_PROVIDER, array_keys($scope_paths));
		$allowed = array_fill_keys($tag_ids, array());
		foreach ($tag_ids as $tag_id)
		{
			if (empty($contexts[$tag_id]['is_enabled']))
			{
				continue;
			}
			foreach ($scope_paths as $forum_id => $scope_path)
			{
				if ($this->scope_allows($contexts[$tag_id]['scope_mode'], isset($rules[$tag_id]) ? $rules[$tag_id] : array(), $scope_path))
				{
					$allowed[$tag_id][] = (int) $forum_id;
				}
			}
		}

		return $allowed;
	}

	/**
	 * Resolve the leaf scopes in which each provider tag is effectively available.
	 */
	public function get_allowed_scope_ids_by_tag(array $tag_ids, $provider, array $scope_paths)
	{
		$tag_ids = array_values(array_unique(array_filter(array_map('intval', $tag_ids))));
		$provider = $this->validate_provider($provider);
		if (empty($tag_ids) || $provider === '' || empty($scope_paths))
		{
			return array();
		}
		$normalized_paths = array();
		$all_scope_ids = array();
		foreach ($scope_paths as $scope_id => $scope_path)
		{
			$scope_id = max(0, (int) $scope_id);
			$scope_path = array_values(array_unique(array_map('intval', (array) $scope_path)));
			if (!in_array(0, $scope_path, true))
			{
				$scope_path[] = 0;
			}
			$normalized_paths[$scope_id] = $scope_path;
			$all_scope_ids = array_merge($all_scope_ids, $scope_path);
		}

		$sql = 'SELECT tag_id, scope_mode, is_enabled
			FROM ' . $this->table_bbtags_context . "
			WHERE provider = '" . $this->db->sql_escape($provider) . "'
				AND " . $this->db->sql_in_set('tag_id', $tag_ids);
		$result = $this->db->sql_query($sql);
		$contexts = array();
		while ($row = $this->db->sql_fetchrow($result))
		{
			$contexts[(int) $row['tag_id']] = $row;
		}
		$this->db->sql_freeresult($result);

		$rules = $this->load_scope_rules(
			$tag_ids,
			$provider,
			array_values(array_unique($all_scope_ids))
		);
		$allowed = array_fill_keys($tag_ids, array());
		foreach ($tag_ids as $tag_id)
		{
			if (empty($contexts[$tag_id]['is_enabled']))
			{
				continue;
			}
			foreach ($normalized_paths as $scope_id => $scope_path)
			{
				if ($this->scope_allows(
					$contexts[$tag_id]['scope_mode'],
					isset($rules[$tag_id]) ? $rules[$tag_id] : array(),
					$scope_path
				))
				{
					$allowed[$tag_id][] = (int) $scope_id;
				}
			}
		}

		return $allowed;
	}

	/**
	 * Return the shared catalogue with its configuration for one provider.
	 *
	 * Catalogue tags without a provider context are returned as disabled and
	 * restricted so an administrator can enable them explicitly.
	 *
	 * @return array<int, array{id: int, tag: string, tag_clean: string, is_enabled: int, scope_mode: string}>
	 */
	public function get_provider_policies(string $provider): array
	{
		$provider = $this->validate_provider($provider);
		if ($provider === '')
		{
			return [];
		}

		$sql = 'SELECT t.id, t.tag, t.tag_clean, tc.is_enabled, tc.scope_mode
			FROM ' . $this->table_bbtags . ' t
			LEFT JOIN ' . $this->table_bbtags_context . " tc
				ON tc.tag_id = t.id
				AND tc.provider = '" . $this->db->sql_escape($provider) . "'
			ORDER BY t.tag_clean ASC";
		$result = $this->db->sql_query($sql);
		$policies = [];
		while ($row = $this->db->sql_fetchrow($result))
		{
			$policies[] = [
				'id' => (int) $row['id'],
				'tag' => (string) $row['tag'],
				'tag_clean' => (string) $row['tag_clean'],
				'is_enabled' => isset($row['is_enabled']) ? (int) $row['is_enabled'] : 0,
				'scope_mode' => in_array($row['scope_mode'] ?? '', ['global', 'restricted'], true)
					? (string) $row['scope_mode']
					: 'restricted',
			];
		}
		$this->db->sql_freeresult($result);

		return $policies;
	}

	/**
	 * Return the explicit rules for one provider tag, indexed by scope.
	 *
	 * @return array<int, string>
	 */
	public function get_scope_rules(int $tag_id, string $provider): array
	{
		$provider = $this->validate_provider($provider);
		if ($tag_id <= 0 || $provider === '')
		{
			return [];
		}

		$sql = 'SELECT scope_id, scope_rule
			FROM ' . $this->table_bbtags_scope . '
			WHERE tag_id = ' . $tag_id . "
				AND provider = '" . $this->db->sql_escape($provider) . "'
			ORDER BY scope_id ASC";
		$result = $this->db->sql_query($sql);
		$rules = [];
		while ($row = $this->db->sql_fetchrow($result))
		{
			if (in_array($row['scope_rule'], ['allow', 'deny'], true))
			{
				$rules[max(0, (int) $row['scope_id'])] = (string) $row['scope_rule'];
			}
		}
		$this->db->sql_freeresult($result);

		return $rules;
	}

	/**
	 * Atomically replace one provider policy and all of its explicit rules.
	 */
	public function save_provider_policy(
		int $tag_id,
		string $provider,
		bool $is_enabled,
		string $scope_mode,
		array $rules
	): bool
	{
		$provider = $this->validate_provider($provider);
		if ($tag_id <= 0 || $provider === '' || !in_array($scope_mode, ['global', 'restricted'], true))
		{
			return false;
		}

		$explicit_rules = [];
		foreach ($rules as $scope_id => $rule)
		{
			$scope_id = (int) $scope_id;
			if ($scope_id < 0 || !in_array($rule, ['allow', 'deny', 'inherit'], true))
			{
				return false;
			}
			if ($rule !== 'inherit')
			{
				$explicit_rules[$scope_id] = $rule;
			}
		}

		$result = $this->db->sql_query_limit(
			'SELECT id FROM ' . $this->table_bbtags . ' WHERE id = ' . $tag_id,
			1
		);
		$catalogue_row = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);
		if (!$catalogue_row)
		{
			return false;
		}

		$this->db->sql_transaction('begin');
		try
		{
			$result = $this->db->sql_query_limit(
				'SELECT tag_id FROM ' . $this->table_bbtags_context . '
					WHERE tag_id = ' . $tag_id . "
						AND provider = '" . $this->db->sql_escape($provider) . "'",
				1
			);
			$context_row = $this->db->sql_fetchrow($result);
			$this->db->sql_freeresult($result);
			$context_data = [
				'is_enabled' => $is_enabled ? 1 : 0,
				'scope_mode' => $scope_mode,
			];
			if ($context_row)
			{
				$sql = 'UPDATE ' . $this->table_bbtags_context . '
					SET ' . $this->db->sql_build_array('UPDATE', $context_data) . '
					WHERE tag_id = ' . $tag_id . "
						AND provider = '" . $this->db->sql_escape($provider) . "'";
			}
			else
			{
				$context_data += [
					'tag_id' => $tag_id,
					'provider' => $provider,
					'usage_count' => 0,
				];
				$sql = 'INSERT INTO ' . $this->table_bbtags_context . ' '
					. $this->db->sql_build_array('INSERT', $context_data);
			}
			if ($this->db->sql_query($sql) === false)
			{
				throw new \RuntimeException('Unable to store provider context.');
			}

			$sql = 'DELETE FROM ' . $this->table_bbtags_scope . '
				WHERE tag_id = ' . $tag_id . "
					AND provider = '" . $this->db->sql_escape($provider) . "'";
			if ($this->db->sql_query($sql) === false)
			{
				throw new \RuntimeException('Unable to replace provider rules.');
			}

			$rows = [];
			foreach ($explicit_rules as $scope_id => $rule)
			{
				$rows[] = [
					'tag_id' => $tag_id,
					'provider' => $provider,
					'scope_id' => $scope_id,
					'scope_rule' => $rule,
				];
			}
			if (!empty($rows) && $this->db->sql_multi_insert($this->table_bbtags_scope, $rows) === false)
			{
				throw new \RuntimeException('Unable to insert provider rules.');
			}
			$this->db->sql_transaction('commit');
		}
		catch (\Throwable $exception)
		{
			$this->db->sql_transaction('rollback');
			return false;
		}

		return true;
	}

	/**
	 * Filter tag identifiers through provider state and inherited scope rules.
	 *
	 * @param array  $tag_ids    Tag identifiers
	 * @param string $provider   Provider name
	 * @param array  $scope_path Current scope followed by its ancestors
	 *
	 * @return array
	 */
	public function filter_available_tag_ids(array $tag_ids, $provider, array $scope_path)
	{
		$tag_ids = array_values(array_unique(array_filter(array_map('intval', $tag_ids))));
		$provider = $this->validate_provider($provider);
		if (empty($tag_ids) || $provider === '')
		{
			return array();
		}

		$sql = 'SELECT tag_id, scope_mode, is_enabled
			FROM ' . $this->table_bbtags_context . '
			WHERE provider = \'' . $this->db->sql_escape($provider) . '\'
				AND ' . $this->db->sql_in_set('tag_id', $tag_ids);
		$result = $this->db->sql_query($sql);
		$contexts = array();
		while ($row = $this->db->sql_fetchrow($result))
		{
			$contexts[(int) $row['tag_id']] = $row;
		}
		$this->db->sql_freeresult($result);

		$rules = $this->load_scope_rules($tag_ids, $provider, $scope_path);
		$available = array();
		foreach ($tag_ids as $tag_id)
		{
			if (empty($contexts[$tag_id]['is_enabled']))
			{
				continue;
			}
			if ($this->scope_allows($contexts[$tag_id]['scope_mode'], isset($rules[$tag_id]) ? $rules[$tag_id] : array(), $scope_path))
			{
				$available[] = $tag_id;
			}
		}

		return $available;
	}

	/**
	 * Resolve nearest-ancestor allow/deny rules.
	 *
	 * @param string $scope_mode Provider default: global or restricted
	 * @param array  $rules      Rules indexed by scope identifier
	 * @param array  $scope_path Current scope followed by its ancestors
	 *
	 * @return bool
	 */
	public function scope_allows($scope_mode, array $rules, array $scope_path)
	{
		$scope_rule = $this->resolve_scope_rule($rules, $scope_path);
		return $scope_rule !== null ? $scope_rule === 'allow' : $scope_mode === 'global';
	}

	/**
	 * Return the nearest explicit scope rule, or null when the provider default applies.
	 */
	public function resolve_scope_rule(array $rules, array $scope_path): ?string
	{
		$scope_path = array_values(array_unique(array_map('intval', $scope_path)));
		if (!in_array(0, $scope_path, true))
		{
			$scope_path[] = 0;
		}
		foreach ($scope_path as $scope_id)
		{
			if (isset($rules[$scope_id]))
			{
				return in_array($rules[$scope_id], ['allow', 'deny'], true) ? $rules[$scope_id] : null;
			}
		}

		return null;
	}

	/**
	 * Set global or restricted fallback behaviour for a provider tag.
	 *
	 * @param int    $tag_id   Tag identifier
	 * @param string $provider Provider name
	 * @param string $mode     global or restricted
	 *
	 * @return bool
	 */
	public function set_scope_mode($tag_id, $provider, $mode)
	{
		$tag_id = (int) $tag_id;
		$provider = $this->validate_provider($provider);
		if ($tag_id <= 0 || $provider === '' || !in_array($mode, array('global', 'restricted'), true))
		{
			return false;
		}

		$sql_ary = array('scope_mode' => $mode);
		$sql = 'UPDATE ' . $this->table_bbtags_context . '
			SET ' . $this->db->sql_build_array('UPDATE', $sql_ary) . '
			WHERE tag_id = ' . $tag_id . '
				AND provider = \'' . $this->db->sql_escape($provider) . '\'';

		return $this->db->sql_query($sql) !== false;
	}

	/**
	 * Store an explicit scope rule, or remove it when inheriting.
	 *
	 * @param int    $tag_id   Tag identifier
	 * @param string $provider Provider name
	 * @param int    $scope_id Provider-specific scope identifier
	 * @param string $rule     allow, deny or inherit
	 *
	 * @return bool
	 */
	public function set_scope_rule($tag_id, $provider, $scope_id, $rule)
	{
		$tag_id = (int) $tag_id;
		$scope_id = max(0, (int) $scope_id);
		$provider = $this->validate_provider($provider);
		if ($tag_id <= 0 || $provider === '' || !in_array($rule, array('allow', 'deny', 'inherit'), true))
		{
			return false;
		}

		$where = 'tag_id = ' . $tag_id . '
			AND provider = \'' . $this->db->sql_escape($provider) . '\'
			AND scope_id = ' . $scope_id;
		if ($rule === 'inherit')
		{
			return $this->db->sql_query('DELETE FROM ' . $this->table_bbtags_scope . ' WHERE ' . $where) !== false;
		}

		$sql = 'SELECT id FROM ' . $this->table_bbtags_scope . ' WHERE ' . $where;
		$result = $this->db->sql_query_limit($sql, 1);
		$row = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);
		$sql_ary = array('scope_rule' => $rule);
		if ($row)
		{
			$sql = 'UPDATE ' . $this->table_bbtags_scope . '
				SET ' . $this->db->sql_build_array('UPDATE', $sql_ary) . '
				WHERE id = ' . (int) $row['id'];
		}
		else
		{
			$sql_ary += array(
				'tag_id' => $tag_id,
				'provider' => $provider,
				'scope_id' => $scope_id,
			);
			$sql = 'INSERT INTO ' . $this->table_bbtags_scope . ' ' . $this->db->sql_build_array('INSERT', $sql_ary);
		}

		return $this->db->sql_query($sql) !== false;
	}

	/**
	 * Load explicit rules for the requested provider path.
	 */
	private function load_scope_rules(array $tag_ids, $provider, array $scope_path)
	{
		$tag_ids = array_values(array_unique(array_filter(array_map('intval', $tag_ids))));
		$scope_path = array_values(array_unique(array_map('intval', $scope_path)));
		if (!in_array(0, $scope_path, true))
		{
			$scope_path[] = 0;
		}
		if (empty($tag_ids) || empty($scope_path))
		{
			return array();
		}

		$sql = 'SELECT tag_id, scope_id, scope_rule
			FROM ' . $this->table_bbtags_scope . '
			WHERE provider = \'' . $this->db->sql_escape($provider) . '\'
				AND ' . $this->db->sql_in_set('tag_id', $tag_ids) . '
				AND ' . $this->db->sql_in_set('scope_id', $scope_path);
		$result = $this->db->sql_query($sql);
		$rules = array();
		while ($row = $this->db->sql_fetchrow($result))
		{
			$rules[(int) $row['tag_id']][(int) $row['scope_id']] = $row['scope_rule'];
		}
		$this->db->sql_freeresult($result);

		return $rules;
	}

	/**
	 * Validate a provider key used in database filters.
	 */
	private function validate_provider($provider)
	{
		$provider = (string) $provider;
		return preg_match('/^[a-z][a-z0-9_]{1,31}$/D', $provider) ? $provider : '';
	}

	/**
	 * Build a route that does not collide with a different catalogue row.
	 *
	 * @param string $tag            Tag label
	 * @param int        $excluded_tag_id Tag identifier allowed to own the route
	 * @param array|null $reserved_routes Routes reserved by the current bulk insert
	 *
	 * @return string
	 */
	private function unique_route($tag, $excluded_tag_id = 0, ?array &$reserved_routes = null)
	{
		$base = $this->slug($tag, array('transliterate' => true));
		$base = ($base !== '') ? utf8_substr($base, 0, self::MAX_TAG_LENGTH) : 'tag';
		$route = $base;
		$attempt = 0;

		do
		{
			$sql = 'SELECT id
				FROM ' . $this->table_bbtags . '
				WHERE ' . $this->db->sql_build_array('SELECT', array('route' => $route));
			$result = $this->db->sql_query_limit($sql, 1);
			$row = $this->db->sql_fetchrow($result);
			$this->db->sql_freeresult($result);
			if ((!$row || (int) $row['id'] === (int) $excluded_tag_id) && !isset($reserved_routes[$route]))
			{
				if (is_array($reserved_routes))
				{
					$reserved_routes[$route] = true;
				}
				return $route;
			}

			$attempt++;
			$suffix = '-' . substr(hash('sha256', $this->canonical_tag($tag) . ':' . $attempt), 0, 8);
			$route = utf8_substr($base, 0, self::MAX_TAG_LENGTH - strlen($suffix)) . $suffix;
		}
		while ($attempt < 100);

		return 'tag-' . substr(hash('sha256', $this->canonical_tag($tag)), 0, 16);
	}

	public function slug($string, $options = array())
	{
		// Make sure string is in UTF-8 and strip invalid UTF-8 characters
		$string = mb_convert_encoding((string) $string, 'UTF-8', mb_list_encodings());

		$defaults = array(
			'delimiter' => '-',
			'limit' => null,
			'lowercase' => true,
			'replacements' => array(),
			'transliterate' => false,
		);

		// Merge options
		$options = array_merge($defaults, $options);

		$char_map = array(
			// Latin
			'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A', 'Å' => 'A', 'Æ' => 'AE', 'Ç' => 'C',
			'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I', 'Î' => 'I', 'Ï' => 'I',
			'Ð' => 'D', 'Ñ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ő' => 'O',
			'Ø' => 'O', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ű' => 'U', 'Ý' => 'Y', 'Þ' => 'TH',
			'ß' => 'ss',
			'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'æ' => 'ae', 'ç' => 'c',
			'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i',
			'ð' => 'd', 'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'o', 'ő' => 'o',
			'ø' => 'o', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u', 'ű' => 'u', 'ý' => 'y', 'þ' => 'th',
			'ÿ' => 'y',

			// Latin symbols
			'©' => '(c)',

			// Greek
			'Α' => 'A', 'Β' => 'B', 'Γ' => 'G', 'Δ' => 'D', 'Ε' => 'E', 'Ζ' => 'Z', 'Η' => 'H', 'Θ' => '8',
			'Ι' => 'I', 'Κ' => 'K', 'Λ' => 'L', 'Μ' => 'M', 'Ν' => 'N', 'Ξ' => '3', 'Ο' => 'O', 'Π' => 'P',
			'Ρ' => 'R', 'Σ' => 'S', 'Τ' => 'T', 'Υ' => 'Y', 'Φ' => 'F', 'Χ' => 'X', 'Ψ' => 'PS', 'Ω' => 'W',
			'Ά' => 'A', 'Έ' => 'E', 'Ί' => 'I', 'Ό' => 'O', 'Ύ' => 'Y', 'Ή' => 'H', 'Ώ' => 'W', 'Ϊ' => 'I',
			'Ϋ' => 'Y',
			'α' => 'a', 'β' => 'b', 'γ' => 'g', 'δ' => 'd', 'ε' => 'e', 'ζ' => 'z', 'η' => 'h', 'θ' => '8',
			'ι' => 'i', 'κ' => 'k', 'λ' => 'l', 'μ' => 'm', 'ν' => 'n', 'ξ' => '3', 'ο' => 'o', 'π' => 'p',
			'ρ' => 'r', 'σ' => 's', 'τ' => 't', 'υ' => 'y', 'φ' => 'f', 'χ' => 'x', 'ψ' => 'ps', 'ω' => 'w',
			'ά' => 'a', 'έ' => 'e', 'ί' => 'i', 'ό' => 'o', 'ύ' => 'y', 'ή' => 'h', 'ώ' => 'w', 'ς' => 's',
			'ϊ' => 'i', 'ΰ' => 'y', 'ϋ' => 'y', 'ΐ' => 'i',

			// Turkish
			'Ş' => 'S', 'İ' => 'I', 'Ç' => 'C', 'Ü' => 'U', 'Ö' => 'O', 'Ğ' => 'G',
			'ş' => 's', 'ı' => 'i', 'ç' => 'c', 'ü' => 'u', 'ö' => 'o', 'ğ' => 'g',

			// Russian
			'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Д' => 'D', 'Е' => 'E', 'Ё' => 'Yo', 'Ж' => 'Zh',
			'З' => 'Z', 'И' => 'I', 'Й' => 'J', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N', 'О' => 'O',
			'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T', 'У' => 'U', 'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C',
			'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sh', 'Ъ' => '', 'Ы' => 'Y', 'Ь' => '', 'Э' => 'E', 'Ю' => 'Yu',
			'Я' => 'Ya',
			'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo', 'ж' => 'zh',
			'з' => 'z', 'и' => 'i', 'й' => 'j', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n', 'о' => 'o',
			'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c',
			'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sh', 'ъ' => '', 'ы' => 'y', 'ь' => '', 'э' => 'e', 'ю' => 'yu',
			'я' => 'ya',

			// Ukrainian
			'Є' => 'Ye', 'І' => 'I', 'Ї' => 'Yi', 'Ґ' => 'G',
			'є' => 'ye', 'і' => 'i', 'ї' => 'yi', 'ґ' => 'g',

			// Czech
			'Č' => 'C', 'Ď' => 'D', 'Ě' => 'E', 'Ň' => 'N', 'Ř' => 'R', 'Š' => 'S', 'Ť' => 'T', 'Ů' => 'U',
			'Ž' => 'Z',
			'č' => 'c', 'ď' => 'd', 'ě' => 'e', 'ň' => 'n', 'ř' => 'r', 'š' => 's', 'ť' => 't', 'ů' => 'u',
			'ž' => 'z',

			// Polish
			'Ą' => 'A', 'Ć' => 'C', 'Ę' => 'e', 'Ł' => 'L', 'Ń' => 'N', 'Ó' => 'o', 'Ś' => 'S', 'Ź' => 'Z',
			'Ż' => 'Z',
			'ą' => 'a', 'ć' => 'c', 'ę' => 'e', 'ł' => 'l', 'ń' => 'n', 'ó' => 'o', 'ś' => 's', 'ź' => 'z',
			'ż' => 'z',

			// Latvian
			'Ā' => 'A', 'Č' => 'C', 'Ē' => 'E', 'Ģ' => 'G', 'Ī' => 'i', 'Ķ' => 'k', 'Ļ' => 'L', 'Ņ' => 'N',
			'Š' => 'S', 'Ū' => 'u', 'Ž' => 'Z',
			'ā' => 'a', 'č' => 'c', 'ē' => 'e', 'ģ' => 'g', 'ī' => 'i', 'ķ' => 'k', 'ļ' => 'l', 'ņ' => 'n',
			'š' => 's', 'ū' => 'u', 'ž' => 'z'
		);

		// Make custom replacements
		$string = preg_replace(array_keys($options['replacements']), $options['replacements'], $string);

		// Transliterate characters to ASCII
		if ($options['transliterate'])
		{
			$string = str_replace(array_keys($char_map), $char_map, $string);
		}

		// Replace non-alphanumeric characters with our delimiter
		$string = preg_replace('/[^\p{L}\p{Nd}]+/u', $options['delimiter'], $string);

		// Remove duplicate delimiters
		$string = preg_replace('/(' . preg_quote($options['delimiter'], '/') . '){2,}/', '$1', $string);

		// Truncate slug to max. characters
		$string = mb_substr($string, 0, ($options['limit'] ? $options['limit'] : mb_strlen($string, 'UTF-8')), 'UTF-8');

		// Remove delimiter from ends
		$string = trim($string, $options['delimiter']);

		return $options['lowercase'] ? mb_strtolower($string, 'UTF-8') : $string;
	}
}
