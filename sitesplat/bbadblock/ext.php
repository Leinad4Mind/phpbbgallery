<?php
/**
*
* BBadblock extension for the phpBB Forum Software package.
*
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bbadblock;

class ext extends \phpbb\extension\base
{
	/**
	 * Overwrite enable_step to enable BBadblock system
	 * before any included migrations are installed.
	 *
	 * @param mixed $old_state State returned by previous call of this method
	 * @return mixed Returns false after last step, otherwise temporary state
	 * @access public
	 */

	public function is_enableable()
	{
		if (!class_exists('sitesplat\BBCore\helper'))
		{
			$this->container->get('user')->add_lang_ext('sitesplat/bbadblock', 'info_acp_bbadblock');
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
			$this->container->get('user')->add_lang_ext('sitesplat/bbadblock', 'info_acp_bbadblock');
			$this->container->get('template')->assign_var('L_EXTENSION_ENABLE_SUCCESS', $this->container->get('user')->lang['EXTENSION_ENABLE_SUCCESS'] .
				(isset($this->container->get('user')->lang['BBADBLOCK_NOTICE']) ?
					sprintf($this->container->get('user')->lang['BBADBLOCK_NOTICE'],
									$this->container->get('user')->lang['ACP_CAT_GENERAL'],
									$this->container->get('user')->lang['ACP_QUICK_ACCESS'],
									$this->container->get('user')->lang['ACP_BBADBLOCK_INDEX_TITLE'])  : ''));
		}

		// Run parent enable step method
		return parent::enable_step($old_state);
	}
}
