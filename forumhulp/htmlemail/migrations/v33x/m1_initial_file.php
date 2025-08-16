<?php
/**
*
* HTML email extension for the phpBB Forum Software package.
*
* @copyright (c) 2015 ForumHulp.com <http://forumhulp.com>
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace forumhulp\htmlemail\migrations\v33x;

use phpbb\db\migration\container_aware_migration;

/**
 * Migration stage 1: Initial schema
 */
class m1_initial_file extends container_aware_migration
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
		return array('\phpbb\db\migration\data\v330\v330');
	}
}
