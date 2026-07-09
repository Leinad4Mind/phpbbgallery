<?php
/**
*
* @package BBinfinitepagination
* @copyright (c) 2019 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bbinfinitepagination;

class ext extends \phpbb\extension\base
{
	
	public function is_enableable()
	{
		if (!class_exists('sitesplat\BBCore\helper'))
		{
			$this->container->get('user')->add_lang_ext('sitesplat/bbinfinitepagination', 'info_acp_donations');
			trigger_error($this->container->get('user')->lang['SS_HELPER_NOTY'], E_USER_WARNING);	
		}
		
		if (!$this->container->get('ext.manager')->is_enabled('sitesplat/BBCore'))
		{
			$this->container->get('ext.manager')->enable('sitesplat/BBCore');
		}

		return class_exists('sitesplat\BBCore\helper');
	}

	function enable_step($old_state)
	{
		switch ($old_state)
		{
			case '': // Empty means nothing has run yet
				if (empty($old_state))
				{
					$this->container->get('user')->add_lang_ext('sitesplat/bbinfinitepagination', 'info_acp_bbinfinitepagination');
					$this->container->get('template')->assign_var('L_EXTENSION_ENABLE_SUCCESS', $this->container->get('user')->lang['EXTENSION_ENABLE_SUCCESS'] . 
						(isset($this->container->get('user')->lang['BBPAGINATION_NOTICE']) ?
							sprintf($this->container->get('user')->lang['BBPAGINATION_NOTICE'],
									$this->container->get('user')->lang['ACP_CAT_POSTING'],
									$this->container->get('user')->lang['ACP_POST_SETTINGS'],
									$this->container->get('user')->lang['ACP_BBPAGINATION']) : ''));
				}

				// Run parent enable step method
				return parent::enable_step($old_state);
			
			break;
			
			default:
			
				// Run parent enable step method
				return parent::enable_step($old_state);
				
			break;
		}
	}
}