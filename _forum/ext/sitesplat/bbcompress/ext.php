<?php
/**
*
* BBcompress extension for the phpBB Forum Software package.
*
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\bbcompress;

class ext extends \phpbb\extension\base
{
	/**
	 * Overwrite enable_step to enable BBcompress system
	 * before any included migrations are installed.
	 *
	 * @param mixed $old_state State returned by previous call of this method
	 * @return mixed Returns false after last step, otherwise temporary state
	 * @access public
	 */

	public function is_enableable()
	{
		return $this->container->get('ext.manager')->is_enabled('sitesplat/BBCore');
	}

	public function enable_step($old_state)
	{
		if (empty($old_state))
		{
			$this->container->get('user')->add_lang_ext('sitesplat/bbcompress', 'info_acp_bbcompress');
			$this->container->get('template')->assign_var('L_EXTENSION_ENABLE_SUCCESS', $this->container->get('user')->lang['EXTENSION_ENABLE_SUCCESS'] .
				(isset($this->container->get('user')->lang['BBCOMPRESS_NOTICE']) ?
					sprintf($this->container->get('user')->lang['BBCOMPRESS_NOTICE'],
									$this->container->get('user')->lang['ACP_CAT_GENERAL'])  : ''));
		}

		// Run parent enable step method
		return parent::enable_step($old_state);
	}
}
