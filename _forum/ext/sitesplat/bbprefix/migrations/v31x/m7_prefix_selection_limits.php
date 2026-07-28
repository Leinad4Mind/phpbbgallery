<?php
/**
 *
* @package BBprefix
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
 *
 */

namespace sitesplat\bbprefix\migrations\v31x;

class m7_prefix_selection_limits extends \phpbb\db\migration\migration
{
	static public function depends_on()
	{
		return ['\sitesplat\bbprefix\migrations\v31x\m6_prefix_forums_mode'];
	}

	/**
	 * @inheritdoc
	 */
	public function effectively_installed()
	{
		return isset($this->config['bbprefix_min_selected']) && isset($this->config['bbprefix_max_selected']);
	}

	/**
	 * @inheritdoc
	 */
	public function update_data()
	{
		return [
			// 0 means "no limit" for both, so nothing changes until an admin
			// sets one.
			['config.add', ['bbprefix_min_selected', 0]],
			['config.add', ['bbprefix_max_selected', 0]],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function revert_data()
	{
		return [
			['config.remove', ['bbprefix_min_selected']],
			['config.remove', ['bbprefix_max_selected']],
		];
	}
}
