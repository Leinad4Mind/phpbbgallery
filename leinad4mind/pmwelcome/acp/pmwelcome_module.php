<?php

/**
*
* @package PM Welcome
* @copyright (c) 2019 Leinad4Mind
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

namespace leinad4mind\pmwelcome\acp;

class pmwelcome_module
{
	var $u_action;
	var $new_config = array();

	function main($id, $mode)
	{
		global $config, $user, $template, $request, $phpbb_container;
		global $phpbb_root_path, $phpEx;

		$this->tpl_name = 'acp_pmwelcome';
		$this->page_title = 'ACP_PMWELCOME_SETTINGS';

		$user->add_lang(array('acp/board', 'posting'));

		$submit = $request->is_set_post('submit');
		$preview = $request->is_set_post('preview');

		$form_key = 'pmwelcome';
		add_form_key($form_key);

		$user_name = '';
		if (!$submit)
		{
			$user_info = $this->pm_welcome_user_row($config['pmwelcome_user']);
			$user_name = get_username_string('full', $user_info['user_id'] ?? ANONYMOUS, $user_info['username'] ?? $user->lang('GUEST'), $user_info['user_colour'] ?? '');
		}

		$display_vars = array(
			'title'	=> 'ACP_PMWELCOME',
			'vars'	=> array(
				'legend1'	=> 'ACP_PMWELCOME_SETTINGS',
				'pmwelcome_user'		=> array('lang' => 'ACP_PMWELCOME_USER',	'validate' => 'int:2:999999',	'type' => 'number:2:999999', 'explain' => true, 'append' => ' ' . $user_name),
				'pmwelcome_subject'		=> array('lang' => 'ACP_PMWELCOME_SUBJECT',	'validate' => 'string',		'type' => 'text:20:250', 'explain' => false),
				'pmwelcome_post_text'	=> array('lang' => 'ACP_PMWELCOME_TEXT',	'validate' => '',			'type' => 'textarea:5:30', 'explain' => true),

				'legend2'	=> 'ACP_SUBMIT_CHANGES',
			),
		);

		if (isset($display_vars['lang']))
		{
			$user->add_lang($display_vars['lang']);
		}

		$this->new_config = $config;

		$cfg_array = ($request->is_set('config')) ? $request->variable('config', array('' => ''), true) : $this->new_config;
		$error = array();

		// We validate the complete config if wished
		validate_config_vars($display_vars['vars'], $cfg_array, $error);

		if ($submit && !check_form_key($form_key))
		{
			$error[] = $user->lang['FORM_INVALID'];
		}

		// Do not write values if there is an error
		if (sizeof($error))
		{
			$submit = false;
		}

		/* Config text Welcome */
		$config_text = $phpbb_container->get('config_text');
		$text_ary = array('pmwelcome_post_text');

		// We go through the display_vars to make sure no one is trying to set variables he/she is not allowed to...
		foreach ($display_vars['vars'] as $config_name => $null)
		{
			if (!isset($cfg_array[$config_name]) || strpos($config_name, 'legend') !== false)
			{
				continue;
			}

			$this->new_config[$config_name] = $config_value = $cfg_array[$config_name];

			if ($submit || $preview)
			{
				/* Find user */
				if ($config_name == 'pmwelcome_user')
				{
					$user_info = $this->pm_welcome_user_row($config_value);
					if (isset($user_info['error']) && $user_info['error'])
					{
						$error[] = $user_info['error'];
						$submit = false;
						continue;
					}
				}

				if ($submit)
				{
					$config->set($config_name, $config_value);
				}
			}
		}

		if ($submit && !$error)
		{
			$config_text->set('pmwelcome_post_text', $request->variable('pmwelcome_post_text', '', true));

			trigger_error($user->lang['CONFIG_UPDATED'] . adm_back_link($this->u_action));
		}

		/* Config text Welcome Preview */
		$preview_text = '';
		$subject_text = '';
		if ($preview && !$error)
		{
			$flags = 3;
			$uid = $bitfield = '';

			$tokens = [
				'{USER_ID}'			=> $user->data['user_id'],
				'{USERNAME}'		=> $user->data['username'],
				'{USER_EMAIL}'		=> $user->data['user_email'],
				'{SITE_NAME}'		=> $config['sitename'],
				'{SITE_DESC}'		=> $config['site_desc'],
				'{BOARD_CONTACT}'	=> $config['board_contact'],
				'{BOARD_EMAIL}'		=> $config['board_email'],
				'{BOARD_SIG}'		=> $config['board_email_sig'],
			];

			$preview_text = $this->replace_tokens($request->variable('pmwelcome_post_text', '', true), $tokens);
			generate_text_for_storage($preview_text, $uid, $bitfield, $flags, true, true, true);
			$preview_text = generate_text_for_display($preview_text, $uid, $bitfield, $flags);

			$subject_text = $this->replace_tokens($cfg_array['pmwelcome_subject'], $tokens);
		}

		$this->page_title = $display_vars['title'];

		$template->assign_vars(array(
			'L_TITLE'			=> $user->lang[$display_vars['title']],
			'L_TITLE_EXPLAIN'	=> $user->lang[$display_vars['title'] . '_EXPLAIN'],
			'S_ERROR'			=> (sizeof($error)) ? true : false,
			'ERROR_MSG'			=> implode('<br />', $error),
			'POST_TEXT'			=> $preview ? $request->variable('pmwelcome_post_text', '', true) : $config_text->get('pmwelcome_post_text'),
			'PREVIEW_TEXT'		=> $preview_text,
			'SUBJECT_PREVIEW'	=> $subject_text,
			'U_ACTION'			=> $this->u_action,
		));

		if (!function_exists('display_custom_bbcodes'))
		{
			include_once($phpbb_root_path . 'includes/functions_display.' . $phpEx);
		}

		display_custom_bbcodes();

		// Output relevant page
		foreach ($display_vars['vars'] as $config_key => $vars)
		{
			if (!is_array($vars) && strpos($config_key, 'legend') === false)
			{
				continue;
			}

			if (strpos($config_key, 'legend') !== false)
			{
				$template->assign_block_vars('options', array(
					'S_LEGEND'		=> true,
					'LEGEND'		=> (isset($user->lang[$vars])) ? $user->lang[$vars] : $vars)
				);
				continue;
			}

			$type = explode(':', $vars['type']);

			$l_explain = '';
			if ($vars['explain'] && isset($vars['lang_explain']))
			{
				$l_explain = (isset($user->lang[$vars['lang_explain']])) ? $user->lang[$vars['lang_explain']] : $vars['lang_explain'];
			}
			else if ($vars['explain'])
			{
				$l_explain = (isset($user->lang[$vars['lang'] . '_EXPLAIN'])) ? $user->lang[$vars['lang'] . '_EXPLAIN'] : '';
			}

			/* Get config text && Anvar */
			if (in_array($config_key, $text_ary))
			{
				continue;
				//$this->new_config[$config_key] = $config_text->get($config_key);
			}

			$content = build_cfg_template($type, $config_key, $this->new_config, $config_key, $vars);

			if (empty($content))
			{
				continue;
			}

			$template->assign_block_vars('options', array(
				'KEY'			=> $config_key,
				'TITLE'			=> (isset($user->lang[$vars['lang']])) ? $user->lang[$vars['lang']] : $vars['lang'],
				'S_EXPLAIN'		=> $vars['explain'],
				'TITLE_EXPLAIN'	=> $l_explain,
				'CONTENT'		=> $content,
				)
			);

			unset($display_vars['vars'][$config_key]);
		}
	}

	function replace_tokens(string $str, array $tokens): string
	{
		foreach ($tokens as $token => $value)
		{
			$str = str_replace($token, $value, $str);
		}

		return $str;
	}

	function pm_welcome_user_row($user_id)
	{
		global $db, $user;

		$sql = 'SELECT u.*
			FROM ' . USERS_TABLE . ' u
			WHERE user_id = ' . (int) $user_id;
		$result = $db->sql_query($sql);
		$user_row = $db->sql_fetchrow($result);
		$db->sql_freeresult($result);

		if (!$user_row || !isset($user_row['username']))
		{
			$user_row = ['error' => $user->lang['NO_USER']];
		}

		return $user_row;
	}
}
