<?php
/**
*
* @package User Login Redirect
* @copyright (c) 2014 david63
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace david63\loginredirect\migrations;

class version_1_1_0 extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
		return array('david63\loginredirect\migrations\version_1_0_0');
	}

	public function update_data()
	{
		return array(
			array('config.add', array('redirect_announce_priority', 1)),
			array('config.add', array('redirect_announce_topic_id', '')),
			array('config.add', array('redirect_any_announce', '0')),

			array('config.update', array('version_loginredirect', '1.1.0')),
		);
	}
}
