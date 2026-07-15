<?php
/**
*
* @package BBemoji
* @copyright (c) 2016 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bbemoji\migrations;

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

	/**
	 * Add the like table schema to the database:
	 *
	 * @return array Array of table schema
	 * @access public
	 */
	public function update_schema()
	{
		return array(
			'add_tables'	=> array(
				$this->table_prefix . 'emoji_icons'	=> array(
					'COLUMNS'	=> array(
						'icons_id'				=> array('UINT', NULL, 'auto_increment'),
						'icons_emoji'			=> array('VCHAR', ''),
						'icons_order'			=> array('UINT', 0),
						'display_on_posting'	=> array('BOOL', 1),
					),
					'PRIMARY_KEY'	=> 'icons_id',
					'KEYS'	=> array(
						'dop'	=> array('INDEX', 'display_on_posting'),
					),
				),
			)
		);
	}

	/**
	 * Drop the like table schema from the database
	 *
	 * @return array Array of table schema
	 * @access public
	 */
	public function revert_schema()
	{
		return array(
			'drop_tables'	=> array(
				$this->table_prefix . 'emoji_icons',
			),
		);
	}
}
