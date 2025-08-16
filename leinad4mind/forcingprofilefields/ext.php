<?php

/**
 *
 * Forcing Profile Fields. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2017, leinad4mind, https://leinad4mind.top/forum
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */
namespace leinad4mind\forcingprofilefields;

use phpbb\extension\base;
use phpbb\language\language;
use phpbb\template\template;

class ext extends base
{
	public function enable_step($old_state)
	{
		if (empty($old_state)) // Empty means nothing has run yet
		{
			/** @var language $lang */
			$lang = $this->container->get('language');

			/** @var template $template */
			$template = $this->container->get('template');

			$lang->add_lang('info_acp_forcingprofilefields', 'leinad4mind/forcingprofilefields');

			if ($lang->is_set('FORCINGPROFILEFIELDS_ENABLE_NOTICE'))
			{
				$template->assign_var('L_EXTENSION_ENABLE_SUCCESS', $lang->lang('EXTENSION_ENABLE_SUCCESS') . $lang->lang('FORCINGPROFILEFIELDS_ENABLE_NOTICE', $lang->lang('ACP'), $lang->lang('ACP_CAT_GENERAL'),  $lang->lang('ACP_BOARD_FEATURES')));
			}
		}

		// Run parent enable step method
		return parent::enable_step($old_state);
	}
}
