<?php
/**
*
* BBAvatars
*
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\titlesandavatars\migrations\v31x;

/**
* Migration stage 1: Initial data changes to the files
*/
class m1_initial_config extends \phpbb\db\migration\migration
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
		return  array('\sitesplat\BBCore\migrations\v31x\m1_initial_file');
	}

	public function update_data()
	{
		return array(
			array('config.add', array('titles_avatar_setting', 0)),
			array('config.add', array('titles_avatar_participants', 1)),
			array('config.add', array('titles_avatar_memberlist', 1)),
			array('config.add', array('titles_avatar_online', 1)),
		);
	}
}
