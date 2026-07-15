<?php
/**
*
* BBtags
*
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bbtags\migrations\v31x;

/**
 * Migration stage 1: Initial schema
 */
class m1_initial_schema extends \phpbb\db\migration\migration
{
	/**
	 * Assign migration file dependencies for this migration
	 *
	 * @return array Array of migration files
	 * @static
	 * @access public
	 */
	static public function depends_on()
	{
		return array('\phpbb\db\migration\data\v310\gold');
	}

	public function update_schema()
	{
		return array(
			// We have to create our own tables
			'add_tables' => array(
				$this->table_prefix . 'bbtags' => array(
					'COLUMNS'		=> array(
						'id'			=> array('UINT', NULL, 'auto_increment'),
						'tag'			=> array('VCHAR:30', ''),
						'route'			=> array('VCHAR:30', ''),
						'count'			=> array('UINT', 0),
					),
					'PRIMARY_KEY'	=> 'id',
					'KEYS'			=> array(
						'unq_tag'		=> array('UNIQUE', array('tag')),
						'route'			=> array('INDEX', array('route')),
					),
				),
				$this->table_prefix . 'bbtags_topic'	=> array(
					'COLUMNS'		=> array(
						'id'			=> array('UINT', NULL, 'auto_increment'),
						'topic_id'		=> array('UINT', 0),
						'tag_id'		=> array('UINT', 1),
					),
					'PRIMARY_KEY'	=> 'id',
					'KEYS'			=> array(
						'idx_topic'		=> array('INDEX', array('topic_id')),
						'idx_tag'		=> array('INDEX', array('tag_id')),
					),
				)
			)
		);
	}

	public function revert_schema()
	{
		return array(
			'drop_tables' => array(
				$this->table_prefix . 'bbtags',
				$this->table_prefix . 'bbtags_topic'
			)
		);
	}
}
