<?php
/**
 *
 * @package ReplyToUnhide
 * @copyright (c) 2016 SiteSplat <http://sitesplat.com>
 * @license Proprietary
 *
 */

namespace sitesplat\replytounhide;

/**
 * Main extension class for Custom User Title extension.
 */
class ext extends \phpbb\extension\base
{
  /** 
	public function is_enableable()
	{
		if (!class_exists('sitesplat\BBCore\helper'))
		{
			$this->container->get('user')->add_lang_ext('sitesplat/replytounhide', 'info_acp_replytounhide');
			trigger_error($this->container->get('user')->lang['SS_HELPER_NOTICE'], E_USER_WARNING);
		}

		if (!$this->container->get('ext.manager')->is_enabled('sitesplat/BBCore'))
		{
			$this->container->get('ext.manager')->enable('sitesplat/BBCore');
		}

		return class_exists('sitesplat\BBCore\helper');
	}
  */
	
	public function is_enableable()
	{
		$manager = $this->container->get('ext.manager');

		return $manager->is_enabled('sitesplat/BBCore');
	}


	public function enable_step($old_state)
	{
		if (empty($old_state))
		{
			$this->container->get('user')->add_lang_ext('sitesplat/replytounhide', 'info_acp_replytounhide');
			$this->container->get('template')->assign_var('L_EXTENSION_ENABLE_SUCCESS', $this->container->get('user')->lang['EXTENSION_ENABLE_SUCCESS'] .
				(isset($this->container->get('user')->lang['REPLYTOUNHIDE_NOTICE']) ?
					sprintf($this->container->get('user')->lang['REPLYTOUNHIDE_NOTICE'],
									$this->container->get('user')->lang['ACP_CAT_GENERAL'],
									$this->container->get('user')->lang['ACP_BOARD_CONFIGURATION'],
									$this->container->get('user')->lang['ACP_BOARD_FEATURES'])  : ''));
		}
		// Run parent enable step method
		return parent::enable_step($old_state);
	}
}
