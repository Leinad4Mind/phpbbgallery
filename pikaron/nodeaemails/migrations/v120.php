<?php
/**
 *
 * No DEA Emails. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019, Picaron, https://github.com/picaronin/
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace pikaron\nodeaemails\migrations;

class v120 extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
		return array('\pikaron\nodeaemails\migrations\v100_rc5');
	}

	public function update_data()
	{
		return array(
			array('config.update', array('nodeaemails_version', '1.2.0')),
		);
	}
}
