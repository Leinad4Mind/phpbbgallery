<?php
/*
* @package cBB Blockgets
* @version v2.0.2 12/01/2021
*
* @copyright (c) 2021 CaniDev
* @license https://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\blockgets\migrations;

class v202 extends \phpbb\db\migration\migration
{
	protected $block_ary = null;

	public function effectively_installed()
	{
		return isset($this->config['blg_version']) && version_compare($this->config['blg_version'], '2.0.2', '>=');
	}

	static public function depends_on()
	{
		return array(
			'\canidev\blockgets\migrations\v201',
		);
	}

	public function update_data()
	{
		$this->prepare();

		return array(
			array('config.update',	array('blg_version', '2.0.2')),

			array('custom', array(array($this, 'update_block_config'))),
		);
	}
	
	public function prepare()
	{
		if(!defined('BLG_BLOCK_TABLE'))
		{
			$table_prefix = $this->table_prefix;
			include($this->phpbb_root_path . 'ext/canidev/blockgets/libraries/constants.' . $this->php_ext);
		}
	}

	protected function obtain_blocks($filter = '')
	{
		if($this->block_ary === null)
		{
			$this->block_ary = array();

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

	public function update_block_config()
	{
		$block_ary 	= $this->obtain_blocks();

		foreach($this->block_ary as $block_id => $row)
		{
			$data = null;

			switch($row['block_alias'])
			{
				case 'leaders_block':
					$data = unserialize($row['block_content']);

					$data['only_online'] = 0;
				break;

				case 'recent_topics_block':
					$data = unserialize($row['block_content']);

					$data['show_parent'] 	= 0;
					$data['sections'] 		= \canidev\blockgets\blocks\recent_topics_block::$default_sections;

					unset($data['title_limit']);
				break;

				case 'top_topics_block':
				case 'topic_index_block':
					$data = unserialize($row['block_content']);

					$data['show_parent'] 	= 0;
				break;
			}

			if($data !== null)
			{
				$sql = 'UPDATE ' . BLG_BLOCK_TABLE . "
					SET block_content = '" . (is_array($data) ? serialize($data) : $data) . "'
					WHERE block_id = $block_id";
				$this->db->sql_query($sql);
			}
		}
	}
}
