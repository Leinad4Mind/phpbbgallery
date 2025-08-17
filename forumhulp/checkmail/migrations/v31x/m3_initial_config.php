<?php
/**
*
* @package Check mail
* @copyright (c) 2016 ForumHulp.com <http://forumhulp.com>
* @license Proprietary
*
*/

namespace forumhulp\checkmail\migrations\v31x;

use phpbb\db\migration\container_aware_migration;

/**
* Migration stage 4: Initial config
*/
class m3_initial_config extends container_aware_migration
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
		return array('\forumhulp\checkmail\migrations\v31x\m2_initial_module');
	}

	/**
	 * Add or update data in the database
	 *
	 * @return array Array of table data
	 * @access public
	 */
	public function update_data()
	{
		return array(
			array('config.add', array('checkmail_gc', 300)),
			array('config.add', array('checkmail_last_gc', 0, true)),
		);
	}
}
