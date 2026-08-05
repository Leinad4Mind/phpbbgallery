<?php
/**
*
* @package Statistics
* @copyright (c) 2014 ForumHulp.com
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace forumhulp\statistics\migrations\v32x;

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
		return array('\forumhulp\statistics\migrations\v32x\m1_config_data');
	}

	/**
	 * Change the table schema to the database:
	 *
	 * @return array Array of table schema
	 * @access public
	 */
	public function update_schema()
	{
		return array(
			'change_columns'	=> array(
			  $this->table_prefix . 'statistics_online'		=> array(
					'module'	=> array('VCHAR:100', ''),
				),
			)
		);
	}

	/**
	 * Change the table schema from the database
	 *
	 * @return array Array of table schema
	 * @access public
	 */
	public function revert_schema()
	{
		return array(
			'change_columns'	=> array(
			  $this->table_prefix . 'statistics_online'		=> array(
					'module'	=> array('VCHAR:50', ''),
				),
			)
		);
	}
}
