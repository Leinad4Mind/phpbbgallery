<?php
/*
* @package Ext Common Core
* @version v1.0.4 01/02/2020
*
* @copyright (c) 2020 CaniDev
* @license https://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\core;

class bbcode_manager
{
	private $cache 			= null;
	private $max_bbcode_id	= 0;
	
	protected $bbcode_tool;
	protected $db;

	/**
	* Constructor
	*
	* @param \phpbb\db\driver\driver_interface		$db				DB Object
	* @param string									$root_path		phpBB root path
	* @param string									$php_ext		phpEx
	*
	* @access public
	*/
	public function __construct(
		\phpbb\db\driver\driver_interface $db,
		$root_path,
		$php_ext)
	{
		// Load the acp_bbcode class
		if(!class_exists('acp_bbcodes', false))
		{
			include($root_path . 'includes/acp/acp_bbcodes.' . $php_ext);
		}

		$this->bbcode_tool		= new \acp_bbcodes;
		$this->db				= $db;
	}
	
	public function get_installed_bbcodes()
	{
		if($this->cache === null)
		{
			$this->cache = array();

			$sql = 'SELECT bbcode_id, bbcode_tag, bbcode_match, bbcode_tpl
				FROM ' . BBCODES_TABLE;
			$result = $this->db->sql_query($sql);
			while($row = $this->db->sql_fetchrow($result))
			{
				$row['bbcode_id']	= (int)$row['bbcode_id'];
				$bbcode_tag 		= strtolower($row['bbcode_tag']);
				
				$this->cache[$bbcode_tag] = $row;
				$this->max_bbcode_id = max($this->max_bbcode_id, $row['bbcode_id']);
			}
			$this->db->sql_freeresult($result);

			$this->max_bbcode_id = max($this->max_bbcode_id, NUM_CORE_BBCODES);
		}
		
		return $this->cache;
	}

	public function insert($bbcode_ary, $overwrite = false, $backup = false)
	{
		$insert_ary	= array();
		
		$this->get_installed_bbcodes();

		foreach($bbcode_ary as $bbcode_name => $bbcode_array)
		{
			// Build the BBCodes
			$data = $this->bbcode_tool->build_regexp($bbcode_array['bbcode_match'], $bbcode_array['bbcode_tpl']);

			$bbcode_array = array_merge($bbcode_array, array(
				'bbcode_tag'			=> $data['bbcode_tag'],
				'bbcode_match'			=> $bbcode_array['bbcode_match'],
				'bbcode_tpl'			=> $bbcode_array['bbcode_tpl'],
				'first_pass_match'		=> $data['first_pass_match'],
				'first_pass_replace'	=> $data['first_pass_replace'],
				'second_pass_match'		=> $data['second_pass_match'],
				'second_pass_replace'	=> $data['second_pass_replace'],
				'display_on_posting'	=> isset($bbcode_array['display_on_posting']) ? $bbcode_array['display_on_posting'] : 1,
			));
			
			$bbcode_tag	= strtolower($bbcode_array['bbcode_tag']);
			$bbcode		= isset($this->cache[$bbcode_tag]) ? $this->cache[$bbcode_tag] : false;
			
			if($bbcode !== false && !$overwrite)
			{
				continue;
			}

			if($bbcode !== false)
			{
				if($backup && $bbcode['bbcode_tpl'] != $bbcode_array['bbcode_tpl'])
				{
					$content = $bbcode['bbcode_match'] . "\n----\n" . $bbcode['bbcode_tpl'] . "\n<!--//-->\n";
					@file_put_contents($this->phpbb_root_path . 'store/bbcode_backup.txt', $content, FILE_APPEND);
				}

				// Update existing BBCode
				$this->update_by_tag($bbcode['bbcode_tag'], $bbcode_array);
			}
			else
			{
				if($this->max_bbcode_id > BBCODE_LIMIT - 1)
				{
					continue;
				}

				// Create new BBCode
				$this->max_bbcode_id++;
				$bbcode_array['bbcode_id'] = $this->max_bbcode_id;
				
				$this->cache[$bbcode_tag] = $bbcode_array;
				$insert_ary[] = $bbcode_array;
			}
		}
		
		foreach($insert_ary as $ary)
		{
			$sql = 'INSERT INTO ' . BBCODES_TABLE . ' ' . $this->db->sql_build_array('INSERT', $ary);
			$this->db->sql_query($sql);
		}
	}
	
	public function update_by_tag($bbcode_tag, $bbcode_data)
	{
		$bbcode_tag = (is_array($bbcode_tag) ? $bbcode_tag : array($bbcode_tag));
		
		if(isset($bbcode_data['bbcode_match']) && !isset($bbcode_data['first_pass_match']))
		{
			// Build the BBCode data
			$data = $this->bbcode_tool->build_regexp($bbcode_data['bbcode_match'], $bbcode_data['bbcode_tpl']);

			$bbcode_data = array_merge($bbcode_data, array(
				'bbcode_tag'			=> $data['bbcode_tag'],
				'bbcode_match'			=> $bbcode_data['bbcode_match'],
				'bbcode_tpl'			=> $bbcode_data['bbcode_tpl'],
				'first_pass_match'		=> $data['first_pass_match'],
				'first_pass_replace'	=> $data['first_pass_replace'],
				'second_pass_match'		=> $data['second_pass_match'],
				'second_pass_replace'	=> $data['second_pass_replace'],
			));
		}
		
		$sql = 'UPDATE ' . BBCODES_TABLE . '
			SET ' . $this->db->sql_build_array('UPDATE', $bbcode_data) . '
			WHERE ' . $this->db->sql_in_set('bbcode_tag', $bbcode_tag);
		$this->db->sql_query($sql);
	}
}
