<?php

/**
 *
 * @package BBEmoji
 * @copyright (c) 2016-2022 SiteSplat All rights reserved
 * @license Proprietary
 *
 */

namespace sitesplat\bbemoji;

use phpbb\extension\base;

class ext extends base
{

	public function is_enableable()
	{
		if (!class_exists('sitesplat\BBCore\helper')) {
			$this->container->get('user')->add_lang_ext('sitesplat/bbemoji', 'info_acp_bbemoji');
			trigger_error($this->container->get('user')->lang['SS_HELPER_NOTY'], E_USER_WARNING);
		}

		if (!$this->container->get('ext.manager')->is_enabled('sitesplat/BBCore')) {
			$this->container->get('ext.manager')->enable('sitesplat/BBCore');
		}

		return class_exists('sitesplat\BBCore\helper');
	}

	/**
	 * @param mixed $old_state State returned by previous call of this method
	 * @return mixed Returns false after last step, otherwise temporary state
	 * @access public
	 */
	function enable_step($old_state)
	{
		switch ($old_state) {
			case '': // Empty means nothing has run yet
				if (empty($old_state)) {
					$this->container->get('user')->add_lang_ext('sitesplat/bbemoji', 'info_acp_bbemoji');
					$this->container->get('template')->assign_var('L_EXTENSION_ENABLE_SUCCESS', $this->container->get('user')->lang['EXTENSION_ENABLE_SUCCESS'] .
						(isset($this->container->get('user')->lang['BBEMOJI_NOTICE']) ?
							sprintf(
								$this->container->get('user')->lang['BBEMOJI_NOTICE'],
								$this->container->get('user')->lang['ACP_CAT_POSTING'],
								$this->container->get('user')->lang['ACP_MESSAGES'],
								$this->container->get('user')->lang['ACP_BBEMOJI']
							) : ''));
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