<?php
/**
 * @package cBB Blockgets
 * @version 2.0.7 01/07/2024
 *
 * @copyright (c) 2024 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 */

namespace canidev\blockgets\libraries;

class block_manager
{
	protected $db;
	protected $table_prefix;

	protected $block_ary = [];

	/**
	 * Constructor
	 *
	 * @param \phpbb\db\driver\driver_interface		$db				DB Object
	 * @param string 								$table_prefix 	Table Prefix
	 *
	 * @access public
	 */
	public function __construct(
		\phpbb\db\driver\driver_interface $db,
		$table_prefix
	)
	{
		$this->db 			= $db;
		$this->table_prefix = $table_prefix;

		$sql = 'SELECT *
			FROM ' . $this->table_prefix . 'blockgets_blocks';
		$result = $this->db->sql_query($sql);
		while($row = $this->db->sql_fetchrow($result))
		{
			$block_id = (int)$row['block_id'];
			$this->block_ary[$block_id] = $row;
		}
		$this->db->sql_freeresult($result);
	}

	/**
	 * Gets a single block or block collection
	 * 
	 * @param string		$filter
	 * @return array
	 */
	public function get($filter = '')
	{
		if($filter)
		{
			$result = [];

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
	 * Add config to block
	 * @param array		$data 		Must be (block_alias => new_config)
	 */
	public function add_config($data)
	{
		$update_ary = [];

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
						$block_data = [];
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
						
					$update_ary[$block_id] = [
						'block_content'	=> serialize($block_data),
					];
				}
				else
				{
					$update_ary[$block_id] = [
						'block_content'	=> $new_config,
					];
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
	 * Update block
	 * 
	 * @param int		$block_id
	 * @param array 	$sql_ary
	 */
	public function update_block($block_id, $sql_ary)
	{
		$sql = 'UPDATE ' . $this->table_prefix . 'blockgets_blocks
			SET ' . $this->db->sql_build_array('UPDATE', $sql_ary) . '
			WHERE block_id = ' . (int)$block_id;
		$this->db->sql_query($sql);
	}
}
