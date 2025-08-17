<?php

/**
 *
 * Special Activity Stats. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019, Leinad4Mind, https://leinad4mind.top/forum
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace leinad4mind\specialactivitystats\acp;

/**
 * @ignore
 */
use leinad4mind\specialactivitystats\modes;
use leinad4mind\specialactivitystats\prefixes;

class specialactivitystats_module
{

	/** @var string */
	public $u_action;

	public function main($id, $mode)
	{
		global $config, $request, $template, $user, $cache, $phpbb_container;

		// shortcut
		$conf_prefix = prefixes::CONFIG;

		// common language file for DATEFORMAT_EXPLANATION
		$user->add_lang('acp/board');

		// Add the specialactivitystats ACP lang file
		$user->add_lang_ext('leinad4mind/specialactivitystats', 'specialactivitystats_acp');

		// Load a template from adm/style for our ACP page
		$this->tpl_name = 'specialactivitystats';

		// Set the page title for our ACP page
		$this->page_title = 'ACP_SPECIAL_ACTIVITY_STATS_SETTINGS';

		// Define the name of the form for use as a form key
		$form_name = 'activity/stats';
		add_form_key($form_name);

		if ($request->is_set_post('submit'))
		{
			if (!check_form_key($form_name))
			{
				trigger_error('FORM_INVALID');
			}

			$config->set($conf_prefix.'_disp_new_topics', $request->variable($conf_prefix.'_disp_new_topics', 0));
			$config->set($conf_prefix.'_disp_new_posts', $request->variable($conf_prefix.'_disp_new_posts', 0));
			$config->set($conf_prefix.'_disp_new_users', $request->variable($conf_prefix.'_disp_new_users', 0));
			$config->set($conf_prefix.'_disp_bots', $request->variable($conf_prefix.'_disp_bots', 0));
			$config->set($conf_prefix.'_disp_guests', $request->variable($conf_prefix.'_disp_guests', 0));
			$config->set($conf_prefix.'_disp_hidden', $request->variable($conf_prefix.'_disp_hidden', 0));
			$config->set($conf_prefix.'_disp_time', $request->variable($conf_prefix.'_disp_time', 0));
			$config->set($conf_prefix.'_disp_time_format', utf8_normalize_nfc($request->variable($conf_prefix.'_disp_time_format', 'H:i', true)));
			$config->set($conf_prefix.'_disp_ip', $request->variable($conf_prefix.'_disp_ip', 0));
			$config->set($conf_prefix.'_mode', $request->variable($conf_prefix.'_mode', modes::TODAY));
			$config->set($conf_prefix.'_del_time_d', $request->variable($conf_prefix.'_del_time_d', 0));
			$config->set($conf_prefix.'_del_time_h', $request->variable($conf_prefix.'_del_time_h', 0));
			$config->set($conf_prefix.'_del_time_m', $request->variable($conf_prefix.'_del_time_m', 0));
			$config->set($conf_prefix.'_del_time_s', $request->variable($conf_prefix.'_del_time_s', 0));
			$config->set($conf_prefix.'_sort_by', $request->variable($conf_prefix.'_sort_by', 0));
			$config->set($conf_prefix.'_check_permissions', $request->variable($conf_prefix.'_check_permissions', 0));
			$config->set($conf_prefix.'_cache_time', $request->variable($conf_prefix.'_cache_time', 600));
			$config->set($conf_prefix.'_record', $request->variable($conf_prefix.'_record', 0));
			$config->set($conf_prefix.'_record_timeformat', utf8_normalize_nfc($request->variable($conf_prefix.'_record_timeformat', 'D j. M Y', true)));
			if ($request->variable($conf_prefix.'_reset', 0) > 0)
			{
				$reset_time = time();
				$config->set($conf_prefix.'_record_count', 1);
				$config->set($conf_prefix.'_record_time', $reset_time);
				$config->set($conf_prefix.'_reset_time', $reset_time);
				$sessions_manager = $phpbb_container->get('leinad4mind.specialactivitystats.sessions_manager');
				$sessions_manager->prune($reset_time);
			}
			// clear cache
			$cache->destroy('_leinad4mind_specialactivitystats');

			trigger_error($user->lang('SPECIAL_ACTIVITY_STATS_SETTINGS_SAVED') . adm_back_link($this->u_action));
		}

		$template->assign_vars(array(
			'SPECIAL_ACTIVITY_STATS_MOD_VERSION'		=> $user->lang('SPECIAL_ACTIVITY_STATS_INSTALLED', $config[$conf_prefix.'_version']),
			'SPECIAL_ACTIVITY_STATS_DISP_NEW_TOPICS'	=> $config[$conf_prefix.'_disp_new_topics'],
			'SPECIAL_ACTIVITY_STATS_DISP_NEW_POSTS'		=> $config[$conf_prefix.'_disp_new_posts'],
			'SPECIAL_ACTIVITY_STATS_DISP_NEW_USERS'		=> $config[$conf_prefix.'_disp_new_users'],
			'SPECIAL_ACTIVITY_STATS_DISP_BOTS'			=> $config[$conf_prefix.'_disp_bots'],
			'SPECIAL_ACTIVITY_STATS_DISP_GUESTS'		=> $config[$conf_prefix.'_disp_guests'],
			'SPECIAL_ACTIVITY_STATS_DISP_HIDDEN'		=> $config[$conf_prefix.'_disp_hidden'],
			'SPECIAL_ACTIVITY_STATS_DISP_TIME'			=> $config[$conf_prefix.'_disp_time'],
			'SPECIAL_ACTIVITY_STATS_DISP_TIME_FORMAT'	=> $config[$conf_prefix.'_disp_time_format'],
			'SPECIAL_ACTIVITY_STATS_DISP_IP'			=> $config[$conf_prefix.'_disp_ip'],
			'SPECIAL_ACTIVITY_STATS_MODE'				=> $config[$conf_prefix.'_mode'],
			'SPECIAL_ACTIVITY_STATS_DEL_TIME_D'			=> $config[$conf_prefix.'_del_time_d'],
			'SPECIAL_ACTIVITY_STATS_DEL_TIME_H'			=> $config[$conf_prefix.'_del_time_h'],
			'SPECIAL_ACTIVITY_STATS_DEL_TIME_M'			=> $config[$conf_prefix.'_del_time_m'],
			'SPECIAL_ACTIVITY_STATS_DEL_TIME_S'			=> $config[$conf_prefix.'_del_time_s'],
			'SPECIAL_ACTIVITY_STATS_SORT_BY'			=> $config[$conf_prefix.'_sort_by'],
			'SPECIAL_ACTIVITY_STATS_CACHE_TIME'			=> $config[$conf_prefix.'_cache_time'],
			'SPECIAL_ACTIVITY_STATS_CHECK_PERMISSIONS'	=> $config[$conf_prefix.'_check_permissions'],
			'SPECIAL_ACTIVITY_STATS_RECORD'				=> $config[$conf_prefix.'_record'],
			'SPECIAL_ACTIVITY_STATS_RECORD_TIMEFORMAT'	=> $config[$conf_prefix.'_record_timeformat'],
			'U_ACTION'									=> $this->u_action,
		));

	}
}
