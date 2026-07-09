<?php
/**
*
* @package BBnewsletter
* @copyright (c) 2016 SiteSplat All rights reserved
* @license Proprietary
*
*/

// This file is needed for phpBB3 to properly register the extension

namespace sitesplat\newsletter;

class ext extends \phpbb\extension\base
{
	public function is_enableable()
	{
		if (!class_exists('sitesplat\BBCore\helper'))
		{
			$this->container->get('user')->add_lang_ext('sitesplat/newsletter', 'info_acp_newsletter');
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
			$this->container->get('user')->add_lang_ext('sitesplat/newsletter', 'info_acp_newsletter');
			$this->container->get('template')->assign_var('L_EXTENSION_ENABLE_SUCCESS', $this->container->get('user')->lang['EXTENSION_ENABLE_SUCCESS'] .
				(isset($this->container->get('user')->lang['NEWSLETTER_NOTICE']) ?
							sprintf($this->container->get('user')->lang['NEWSLETTER_NOTICE'],
									$this->container->get('user')->lang['ACP_CAT_GENERAL'],
									$this->container->get('user')->lang['ACP_CLIENT_COMMUNICATION'],
									$this->container->get('user')->lang['ACP_NEWSLETTER']) : ''));
		}

		// Run parent enable step method
		return parent::enable_step($old_state);
	}
}