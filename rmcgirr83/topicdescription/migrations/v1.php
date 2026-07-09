<?php
/**
*
* @package Topic description
* @copyright (c) 2016 Rich McGirr (RMcGirr83)
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace rmcgirr83\topicdescription\migrations;

class v1 extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
		return array('\phpbb\db\migration\data\v310\dev');
	}

	public function update_schema()
	{
		return array(
			'add_columns'	=> array(
				$this->table_prefix . 'topics'	=> array(
					'topic_desc'	=> array('VCHAR_UNI', ''),
				),
			),
		);
	}

	public function revert_schema()
	{
		return array(
			'drop_columns' => array(
				$this->table_prefix . 'topics'	=> array(
					'topic_desc',
				),
			),
		);
	}

	public function update_data()
	{
		return array(
			// Add permission
			array('permission.add', array('f_topic_desc', false)),
			// Set permissions,
			array('permission.permission_set',array('ROLE_FORUM_FULL','f_topic_desc','role')),
			array('permission.permission_set',array('ROLE_FORUM_STANDARD','f_topic_desc','role')),
			array('permission.permission_set',array('ROLE_FORUM_POLLS','f_topic_desc','role')),
		);
	}
}
