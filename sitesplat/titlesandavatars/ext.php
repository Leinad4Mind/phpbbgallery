<?php
/**
*
* BBAvatars
*
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\titlesandavatars;

/**
 * This ext class is optional and can be omitted if left empty.
 * However you can add special (un)installation commands in the
 * methods enable_step(), disable_step() and purge_step(). As it is,
 * these methods are defined in \phpbb\extension\base, which this
 * class extends, but you can overwrite them to give special
 * instructions for those cases.
 */
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
			$this->container->get('user')->add_lang_ext('sitesplat/titlesandavatars', 'info_acp_titlesandavatars');
			$this->container->get('template')->assign_var('L_EXTENSION_ENABLE_SUCCESS', $this->container->get('user')->lang['EXTENSION_ENABLE_SUCCESS'] .
				(isset($this->container->get('user')->lang['TAT_NOTICE']) ? 
				sprintf($this->container->get('user')->lang['TAT_NOTICE'],
					$this->container->get('user')->lang['ACP_CAT_GENERAL'],
					$this->container->get('user')->lang['ACP_BOARD_CONFIGURATION'],
					$this->container->get('user')->lang['ACP_AVATAR_SETTINGS']) : ''));
		}
		// Run parent enable step method
		return parent::enable_step($old_state);
	}
}
