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

/**
 * @ignore
 */

/**
* Handles all functionallity regarding tags.
*/
class manager
{
	private $db;
	private $config;
	private $auth;

	private $table_bbtags;
	private $table_bbtags_topic;

	public function __construct(\phpbb\db\driver\driver_interface $db, \phpbb\config\config $config, \phpbb\auth\auth $auth, $table_bbtags, $table_bbtags_topic)
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
				' . (($topic_id) ? ', '. $this->table_bbtags_topic . ' AS tt WHERE tt.topic_id = ' . (int) $topic_id . '	AND t.id = tt.tag_id ' : '') . '
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
			(!$this->in_array_r($tag, $existing_tags)) ? $sql_ary_new_tags[] = array('tag' => $tag, 'route' => $this->Slug($tag)) : null;
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

	public function Slug($string)
	{
		return strtolower(trim(preg_replace('~[^0-9a-z]+~i', '-', html_entity_decode(preg_replace('~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i', '$1', htmlentities($string, ENT_QUOTES, 'UTF-8')), ENT_QUOTES, 'UTF-8')), '-'));
	}

}
