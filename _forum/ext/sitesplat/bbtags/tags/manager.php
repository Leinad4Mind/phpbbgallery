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
	private $db;
	private $config;
	private $auth;

	private $table_bbtags;
	private $table_bbtags_topic;

	public function __construct(driver_interface $db, config $config, auth $auth, $table_bbtags, $table_bbtags_topic)
	{
		$this->db					= $db;
		$this->config				= $config;
		$this->auth					= $auth;
		$this->table_bbtags			= $table_bbtags;
		$this->table_bbtags_topic	= $table_bbtags_topic;
	}

	public function get_tags($topic_id)
	{
		$sql = 'SELECT t.tag FROM ' . $this->table_bbtags . ' AS t 
				' . (($topic_id) ? ', '. $this->table_bbtags_topic . ' AS tt WHERE tt.topic_id = ' . (int) $topic_id . ' AND t.id = tt.tag_id ' : '') . '
				ORDER BY t.count DESC';
		$result = $this->db->sql_query_limit($sql, $topic_id ? $this->config['bbtags_max_tags'] : $this->config['bbtags_cloud_limit']);
		$tag = array();
		while ($row = $this->db->sql_fetchrow($result))
		{
			$tag[] = $row['tag'];
		}
		return implode(', ' , $tag);
	}

	public function remove_tags_from_topics($topic_ids)
	{
		$sql = 'DELETE FROM ' . $this->table_bbtags_topic . ' WHERE ' . $this->db->sql_in_set('topic_id', (array) $topic_ids);
		$this->db->sql_query($sql);
	}

	private function get_unused_tag_ids()
	{
		$sql = 'SELECT t.id
			FROM ' . $this->table_bbtags . ' t
			WHERE NOT EXISTS (
				SELECT 1
				FROM ' . $this->table_bbtags_topic . ' tt
					WHERE tt.tag_id = t.id
			)';
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
		$sql = 'DELETE FROM ' . $this->table_bbtags . ' WHERE ' . $this->db->sql_in_set('id', $ids);
		$this->db->sql_query($sql);
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
			'route' => $this->slug($tag, array('transliterate' => true)),
		);
		$sql = 'UPDATE ' . $this->table_bbtags . '
			SET ' . $this->db->sql_build_array('UPDATE', $sql_ary) . '
			WHERE id = ' . $tag_id;
		return $this->db->sql_query($sql) !== false;
	}

	public function assign_tags_to_topic($topic_id, $valid_tags)
	{
		$this->remove_tags_from_topics((int) $topic_id);
		$this->create_missing_tags($valid_tags);

		$ids = $this->get_existing_tags($valid_tags, true);

		$sql_ary = array();
		foreach ($ids as $id)
		{
			$sql_ary[] = array('topic_id' => (int) $topic_id, 'tag_id' => $id);
		}
		$this->db->sql_multi_insert($this->table_bbtags_topic, $sql_ary);

		$this->delete_unused_tags();
		$this->calc_count_tags();
	}

	private function create_missing_tags($tags)
	{
		$tags = array_unique($tags);
		$existing_tags = $this->get_existing_tags($tags);

		$sql_ary_new_tags = array();
		foreach ($tags as $tag)
		{
			(!$this->in_array_r($tag, $existing_tags)) ? $sql_ary_new_tags[] = array('tag' => $tag, 'route' => $this->slug($tag, array('transliterate' => true))) : null;
		}
		$this->db->sql_multi_insert($this->table_bbtags, $sql_ary_new_tags);
	}

	private function in_array_r($needle, $haystack, $strict = false)
	{
		foreach ($haystack as $item)
		{
			if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && $this->in_array_r($needle, $item, $strict)))
			{
				return true;
			}
		}
		return false;
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
			$where = ' WHERE ' . $this->db->sql_in_set('tag', $tags);
		}
		$sql = 'SELECT id, tag FROM ' . $this->table_bbtags . $where;
		$result = $this->db->sql_query($sql);
		$ids = array();
		while ($row = $this->db->sql_fetchrow($result))
		{
			$ids[] = ($only_ids) ? $row['id'] : array('id' => $row['id'], 'tag' => $row['tag']);
		}
		$this->db->sql_freeresult($result);
		return $ids;
	}

	public function clean_tag($tag)
	{
		$tag = trim(utf8_strtolower($tag), '.,');
		$tag = utf8_substr($tag, 0, 30);
		$tag = trim($tag);
		return $tag;
	}

	public function calc_count_tags()
	{
		$sql = 'SELECT tag_id, COUNT(topic_id) AS count FROM ' . $this->table_bbtags_topic . ' GROUP BY tag_id';
		$result = $this->db->sql_query($sql);
		while ($row = $this->db->sql_fetchrow($result))
		{
			$sql = 'UPDATE ' . $this->table_bbtags . ' SET count = ' . $row['count'] . ' WHERE id = ' . $row['tag_id'];
			$this->db->sql_query($sql);
		}
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
