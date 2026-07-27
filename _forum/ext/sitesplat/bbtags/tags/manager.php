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
	private $table_bbtags_topic;

	public function __construct(driver_interface $db, config $config, auth $auth, $table_bbtags, $table_bbtags_context, $table_bbtags_topic)
	{
		$this->db					= $db;
		$this->config				= $config;
		$this->auth					= $auth;
		$this->table_bbtags			= $table_bbtags;
		$this->table_bbtags_context	= $table_bbtags_context;
		$this->table_bbtags_topic	= $table_bbtags_topic;
	}

	public function get_tags($topic_id)
	{
		$topic_id = (int) $topic_id;
		$sql = 'SELECT t.tag
			FROM ' . $this->table_bbtags . ' t';
		if ($topic_id > 0)
		{
			$sql .= ' JOIN ' . $this->table_bbtags_topic . ' tt ON tt.tag_id = t.id
				WHERE tt.topic_id = ' . $topic_id;
		}
		$sql .= ' ORDER BY t.count DESC';
		$result = $this->db->sql_query_limit($sql, $topic_id ? $this->config['bbtags_max_tags'] : $this->config['bbtags_cloud_limit']);
		$tag = array();
		while ($row = $this->db->sql_fetchrow($result))
		{
			$tag[] = $row['tag'];
		}
		$this->db->sql_freeresult($result);

		return implode(', ' , $tag);
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

	public function assign_tags_to_topic($topic_id, $valid_tags)
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
			if (!$this->create_missing_tags($tags))
			{
				$this->db->sql_transaction('rollback');
				return false;
			}

			$ids = $this->get_existing_tags($tags, true);
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
	public function get_predefined_tags($term = '', $limit = 0)
	{
		$sql = 'SELECT t.tag
			FROM ' . $this->table_bbtags . ' t
			JOIN ' . $this->table_bbtags_context . " tc ON tc.tag_id = t.id
			WHERE t.is_predefined = 1
				AND tc.provider = '" . self::FORUM_PROVIDER . "'
				AND tc.is_enabled = 1
			ORDER BY t.tag ASC";
		$result = $this->db->sql_query($sql);
		$term = $this->canonical_tag($term);
		$tags = array();
		while ($row = $this->db->sql_fetchrow($result))
		{
			$tag = (string) $row['tag'];
			if ($term !== '' && strpos($this->canonical_tag($tag), $term) !== 0)
			{
				continue;
			}
			$tags[] = $tag;
			if ($limit > 0 && count($tags) >= $limit)
			{
				break;
			}
		}
		$this->db->sql_freeresult($result);

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
				);
			}
		}

		return empty($new_contexts) || $this->db->sql_multi_insert($this->table_bbtags_context, $new_contexts) !== false;
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
