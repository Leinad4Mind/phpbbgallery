<?php
/**
*
* @package Log Searches Extension
* @copyright (c) 2015 david63
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace david63\logsearches\migrations;

class version_2_1_2 extends \phpbb\db\migration\migration
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
		return array('\david63\logsearches\migrations\version_2_1_1');
	}

	public function update_data()
	{
		return array(
			array('config.remove', array('search_log_enable')),
		);
	}
}
