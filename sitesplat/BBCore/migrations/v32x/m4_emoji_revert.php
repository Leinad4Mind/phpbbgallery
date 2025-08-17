<?php
/**
*
* @package sitesplat BBcore addon
* @copyright (c) 2018 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\BBCore\migrations\v32x;

class m4_emoji_revert extends \phpbb\db\migration\container_aware_migration
{

	static public function depends_on()
	{
		return array('\sitesplat\BBCore\migrations\v32x\m3_updater');
	}

	public function update_data()
	{
		return array(
			array('config.add', array('sitesplat_bbcore_emoji_revert', 0)),
		);
	}

	public function revert_data()
	{
		return array(
			array('config.remove', array('sitesplat_bbcore_emoji_revert')),
		);
	}
}
