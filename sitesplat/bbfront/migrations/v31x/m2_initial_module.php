<?php
/**
*
* @package BBfront
* @copyright (c) 2016 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bbfront\migrations\v31x;

class m2_initial_module extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
		return array('\sitesplat\bbfront\migrations\v31x\m1_initial_schema');
	}

	public function update_data()
	{
		return array(
			array('module.add', array(
				'acp',
				'ACP_MESSAGES',
				array(
					'module_basename'	=> '\sitesplat\bbfront\acp\bbfront_module',
					'modes'				=> array('settings'),
				),
			)),
		);
	}
}
