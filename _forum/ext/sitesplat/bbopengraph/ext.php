<?php
/**
*
* BBopengraph
*
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

// This file is needed for phpBB3 to properly register the extension

namespace sitesplat\bbopengraph;

class ext extends \phpbb\extension\base
{
	public function is_enableable()
	{
		$manager = $this->container->get('ext.manager');

		return $manager->is_enabled('sitesplat/BBCore');
	}

	public function enable_step($old_state)
	{
		if (empty($old_state))
		{
			$this->container->get('user')->add_lang_ext('sitesplat/bbopengraph', 'info_acp_bbopengraph');
			$this->container->get('template')->assign_var('L_EXTENSION_ENABLE_SUCCESS', $this->container->get('user')->lang['EXTENSION_ENABLE_SUCCESS'] .
				(isset($this->container->get('user')->lang['BBOPENGRAPH_NOTICE']) ?
					sprintf($this->container->get('user')->lang['BBOPENGRAPH_NOTICE'],
									$this->container->get('user')->lang['ACP_CAT_GENERAL'],
									$this->container->get('user')->lang['ACP_BOARD_CONFIGURATION'],
									$this->container->get('user')->lang['ACP_BOARD_SETTINGS'])  : ''));
		}
		// Run parent enable step method
		return parent::enable_step($old_state);
	}
}
