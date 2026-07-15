<?php
/*
* @name v112.php
* @package cBB Chat
* @version v1.1.2 20/08/2016
*
* @copyright (c) 2016 CaniDev
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\chat\migrations;

class v112 extends \phpbb\db\migration\migration
{
	/**
	 * {@inheritdoc}
	 */
	public function effectively_installed()
	{
		return isset($this->config['chat_version']) && version_compare($this->config['chat_version'], '1.1.2', '>=');
	}

	/**
	 * {@inheritdoc}
	 */
	static public function depends_on()
	{
		return array(
			'\canidev\chat\migrations\v111',
		);
	}
	
	public function update_schema()
	{
		return array(
			'add_columns' => array(
				$this->table_prefix . 'chat_rooms' => array(
					'room_autopurge_time'		=> array('UINT:11', 0),
					'room_autopurge_check'		=> array('UINT:11', 0),
					'room_msg_limit'			=> array('UINT:6', 0),
				),
				$this->table_prefix . 'chat_users' => array(
					'user_trace_time'		=> array('UINT:11', 0),
				),
			),
		);
	}

	public function update_data()
	{
		return array(
			array('config.add',		array('chat_forum_posts', 0)),
			array('config.add',		array('chat_group_users', 0)),
			array('config.update',	array('chat_version', '1.1.2')),

			// Update the new values of the rooms
			array('custom', array(array($this, 'update_chat_values'))),

			array('config.remove', array('chat_store_time')),
			array('config.remove', array('chat_show_topics')),
		);
	}
	
	public function update_chat_values()
	{
		if(!empty($this->config['chat_store_time']))
		{
			$sql = 'UPDATE '. $this->table_prefix . 'chat_rooms
				SET room_autopurge_time = ' . $this->config['chat_store_time'];
			$this->db->sql_query($sql);
		}
		
		if(!empty($this->config['chat_show_topics']))
		{
			set_config('chat_forum_posts', 1);
		}
	}
}
