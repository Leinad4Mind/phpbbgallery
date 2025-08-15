<?php
/**
 *
* @package BBprefix
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
 *
 */

namespace sitesplat\bbprefix\migrations\v31x;

/**
 * Initial data changes needed for Extension installation
 */
class m2_initial_data extends \phpbb\db\migration\migration
{
	/**
	 * @inheritdoc
	 */
	static public function depends_on()
	{
		return ['\sitesplat\bbprefix\migrations\v31x\m1_initial_schema'];
	}

	/**
	 * @inheritdoc
	 */
	public function update_data()
	{
		return [
			['module.add', ['acp', 'ACP_MESSAGES', [
					'module_basename'	=> '\sitesplat\bbprefix\acp\bbprefix_module',
					'modes'				=> ['prefixes'],
			]]],
		];
	}
}
