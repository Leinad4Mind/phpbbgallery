<?php
/**
*
* @package Log Searches Extension
* @copyright (c) 2015 david63
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace david63\logsearches\migrations;

class version_2_1_1 extends \phpbb\db\migration\migration
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
		return array('\david63\logsearches\migrations\version_2_1_0');
	}

	public function update_schema()
	{
		return array(
			'add_columns'	=> array(
				$this->table_prefix . 'search_log'	=> array(
					'log_title'	=> array('VCHAR:60', ''),
				),
			),
		);
	}
}
