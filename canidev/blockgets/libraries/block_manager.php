<?php
/*
* @package cBB Blockgets
* @version v2.0.4 30/08/2021
*
* @copyright (c) 2021 CaniDev
* @license https://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\blockgets\libraries;

class block_manager
{
	protected $db;

	protected $block_ary = array();

	/**
	* Constructor
	*
	* @param \phpbb\db\driver\driver_interface		$db			DB Object
	*
	* @access public
	*/
	public function __construct(\phpbb\db\driver\driver_interface $db)
	{
		$this->db = $db;

		$sql = 'SELECT *
			FROM ' . BLG_BLOCK_TABLE;
		$result = $this->db->sql_query($sql);
		while($row = $this->db->sql_fetchrow($result))
		{
			$block_id = (int)$row['block_id'];
			$this->block_ary[$block_id] = $row;
		}
		$this->db->sql_freeresult($result);
	}

	/**
	* @param string		$filter
	* @access public
	*/
	public function get($filter = '')
	{
		if($filter)
		{
			$result = array();

			foreach($this->block_ary as $block_id => $row)
			{
				if($row['block_alias'] != $filter)
				{
					continue;
				}

				$result[$block_id] = $row;
			}

			return $result;
		}

		return $this->block_ary;
	}

	/**
	* @param array		$data 		Must be (block_alias => new_config)
	* @access public
	*/
	public function add_config($data)
	{
		$update_ary = array();

		foreach($data as $block_alias => $new_config)
		{
			$block_ary = $this->get($block_alias);

			foreach($block_ary as $block_id => $row)
			{
				if(is_array($new_config))
				{
					$block_data = @unserialize($row['block_content']);

					if($block_data === false)
					{
						$block_data = array();
					}

					$block_data = array_merge($block_data, $new_config);

					// null elements must be deleted
					foreach($block_data as $key => $value)
					{
						if($value === null)
						{
							unset($block_data[$key]);
						}
					}
						
					$update_ary[$block_id] = array(
						'block_content'	=> serialize($block_data),
					);
				}
				else
				{
					$update_ary[$block_id] = array(
						'block_content'	=> $new_config,
					);
				}
			}
		}

		foreach($update_ary as $block_id => $ary)
		{
			$this->update_block($block_id, $ary);
		}

		unset($update_ary);
	}

	/**
	* @param int		$block_id
	* @param array 		$sql_ary
	* @access public
	*/
	public function update_block($block_id, $sql_ary)
	{
		$sql = 'UPDATE ' . BLG_BLOCK_TABLE . '
			SET ' . $this->db->sql_build_array('UPDATE', $sql_ary) . '
			WHERE block_id = ' . (int)$block_id;
		$this->db->sql_query($sql);
	}
}
