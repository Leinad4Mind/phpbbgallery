<?php
/**
*
* BBtags
*
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bbtags;

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
		if (!class_exists('sitesplat\BBCore\helper'))
		{
			$this->container->get('user')->add_lang_ext('sitesplat/bbtags', 'info_acp_bbtags');
			trigger_error($this->container->get('user')->lang['SS_HELPER_NOTY'], E_USER_WARNING);	
		}
		
		if (!$this->container->get('ext.manager')->is_enabled('sitesplat/BBCore'))
		{
			$this->container->get('ext.manager')->enable('sitesplat/BBCore');
		}

		return class_exists('sitesplat\BBCore\helper');
	}

	public function enable_step($old_state)
	{
		if (empty($old_state))
		{
			$this->container->get('user')->add_lang_ext('sitesplat/bbtags', 'info_acp_bbtags');
			$this->container->get('template')->assign_var('L_EXTENSION_ENABLE_SUCCESS', $this->container->get('user')->lang['EXTENSION_ENABLE_SUCCESS'] .
							(isset($this->container->get('user')->lang['BBTAGS_NOTICE']) ?
							sprintf($this->container->get('user')->lang['BBTAGS_NOTICE'],
									$this->container->get('user')->lang['ACP_CAT_POSTING'],
									$this->container->get('user')->lang['ACP_MESSAGES'],
									$this->container->get('user')->lang['ACP_BBTAGS']) : ''));
		}
		// Run parent enable step method
		return parent::enable_step($old_state);
	}
}
