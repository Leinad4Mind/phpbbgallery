<?php

/**
 *
 * Invite. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2010-2015, KillBill
 * @copyright (c) 2017, kasimi
 * @copyright (c) 2017-2018, Leinad4Mind, https://leinad4mind.top/forum
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace leinad4mind\invitation\controller;

use leinad4mind\invitation\ext;
use leinad4mind\invitation\includes\config as ext_config;
use leinad4mind\invitation\includes\functions;
use leinad4mind\invitation\includes\functions_ucp;
use phpbb\auth\auth;
use phpbb\captcha\factory;
use phpbb\config\config as phpbb_config;
use phpbb\db\driver\driver_interface as db_interface;
use phpbb\language\language;
use phpbb\log\log_interface;
use phpbb\request\request_interface;
use phpbb\template\template;
use phpbb\user;

class ucp extends controller_base
{
	/** @var db_interface */
	protected $db;

	/** @var user */
	protected $user;

	/** @var language */
	protected $language;

	/** @var request_interface */
	protected $request;

	/** @var auth */
	protected $auth;

	/** @var phpbb_config */
	protected $config;

	/** @var ext_config */
	protected $ext_config;

	/** @var factory */
	protected $captcha_factory;

	/** @var functions */
	protected $functions;

	/** @var functions_ucp */
	protected $functions_ucp;

	/** @var template */
	protected $template;

	/** @var log_interface */
	protected $log;

	/** @var string */
	protected $table_invite;

	/** @var string */
	protected $root_path;

	/** @var string */
	protected $php_ext;

	/**
	 * ucp constructor.
	 *
	 * @param \phpbb\db\driver\driver_interface              $db
	 * @param \phpbb\user                                    $user
	 * @param \phpbb\language\language                       $language
	 * @param \phpbb\request\request_interface               $request
	 * @param \phpbb\auth\auth                               $auth
	 * @param \phpbb\config\config                           $config
	 * @param \leinad4mind\invitation\includes\config        $ext_config
	 * @param \phpbb\captcha\factory                         $captcha_factory
	 * @param \leinad4mind\invitation\includes\functions     $functions
	 * @param \leinad4mind\invitation\includes\functions_ucp $functions_ucp
	 * @param \phpbb\template\template                       $template
	 * @param \phpbb\log\log_interface                       $log
	 * @param string                                         $table_invite
	 * @param string                                         $root_path
	 * @param string                                         $php_ext
	 */
	public function __construct(db_interface $db, user $user, language $language, request_interface $request, auth $auth, phpbb_config $config, ext_config $ext_config, factory $captcha_factory, functions $functions, functions_ucp $functions_ucp, template $template, log_interface $log, $table_invite, $root_path, $php_ext)
	{
		$this->db = $db;
		$this->user = $user;
		$this->language = $language;
		$this->request = $request;
		$this->auth = $auth;
		$this->config = $config;
		$this->ext_config = $ext_config;
		$this->captcha_factory = $captcha_factory;
		$this->functions = $functions;
		$this->functions_ucp = $functions_ucp;
		$this->template = $template;
		$this->log = $log;
		$this->table_invite = $table_invite;
		$this->root_path = $root_path;
		$this->php_ext = $php_ext;
	}

	/**
	 * @param string $id
	 * @param string $mode
	 * @param string $u_action
	 */
	public function main($id, $mode, $u_action)
	{
		$this->tpl_name = 'ucp_meghivo';

		if (!$this->ext_config['meghivo_enable'])
		{
			meta_refresh(3, append_sid("{$this->root_path}ucp.$this->php_ext"));
			trigger_error($this->language->lang('UCP_MEGHIVO_DISABLED', '<a href="' . append_sid("{$this->root_path}ucp.$this->php_ext") . '">', '</a>'));
		}

		$form_key = 'ucp_meghivo';
		add_form_key($form_key);

		$aia	= append_sid("{$this->root_path}ucp.$this->php_ext", "i=" . ext::get_module_id('ucp') . "&amp;mode=adat");
		$aback	= $this->language->lang('UCP_MEGHIVO_BACK' , '<a href="' . $aia . '">', '</a>');
		$uback	= $this->language->lang('UCP_MEGHIVO_BACK' , '<a href="' . $u_action . '">', '</a>');

		$submit		= $this->request->is_set_post('submit');
		$message	= $this->request->variable('message', '', true);
		$error		= array();
		$mmu		= $this->functions_ucp->meghivok($this->user->data['user_id']);
		$cmt		= $this->functions_ucp->cmt($mmu, $this->user->data['user_id']);

		switch ($mode)
		{
			case 'adat':
				$this->page_title = 'UCP_MEGHIVO_ADAT';

				$this->template->assign_vars(array(
					'S_MEGHIVO_ADAT'				=> true,

					'L_UCP_MEGHIVO_DB_USER'			=> $this->language->lang('UCP_MEGHIVO_DB_USER' . ($this->user->data['user_meghivo_member'] > 1 ? 'S' : '')),
					'L_UCP_MEGHIVO_DB_USER_EXPLAIN'	=> $this->language->lang('UCP_MEGHIVO_DB_USER' . ($this->user->data['user_meghivo_member'] > 1 ? 'S' : '') . '_EXPLAIN'),

					'MEGHIVO_DB_USER'				=> $this->language->lang('UCP_MEGHIVO_DB', $this->user->data['user_meghivo_member']),
					'MEGHIVO_DB_SZAM'				=> $this->ext_config['meghivo_db'] || $this->auth->acl_get('u_meghivo_max') ? $this->language->lang('UCP_MEGHIVO_DB_MAX') : $this->language->lang('UCP_MEGHIVO_DB', $this->user->data['user_meghivo']),
					'MEGHIVO_DB_KULDES'				=> $this->ext_config['meghivo_day_db'] ? $this->language->lang('UCP_MEGHIVO_DB', $this->ext_config['meghivo_day_db']) : $this->language->lang('UCP_MEGHIVO_KULDES_MAX'),
					'MEGHIVO_DAY_DB'				=> $this->language->lang('UCP_MEGHIVO_DB', $cmt['ma_kuld']),
					'MEGHIVO_DB_PENDING'			=> $this->language->lang('UCP_MEGHIVO_DB', $cmt['fuggo']),
					'MEGHIVO_TIME_END'				=> $this->ext_config['meghivo_ervenyessege'] / 86400,
					'MEGHIVO_UTOLSO_USER'			=> $cmt['username'] ? $this->language->lang('UCP_MEGHIVO_UT_REG_INFO', $cmt['username'], $this->user->format_date($cmt['user_regdate'])) : $this->language->lang('UCP_MEGHIVO_NO_REG'),
				));

			break;

			case 'kuldes':
				$this->page_title = 'UCP_MEGHIVO_KULDES';

				if ($this->config['require_ac_invite'] == ext::ACC_INVITE_DISABLE || !$this->config['email_enable'])
				{
					meta_refresh(5, $aia);
					trigger_error($this->language->lang('UCP_MEGHIVO_SEND_OFF') . $aback);
				}

				if (!$this->auth->acl_get('u_meghivo_kuld'))
				{
					meta_refresh(5, $aia);
					trigger_error($this->language->lang('UCP_MEGHIVO_NO_PERM') . $aback);
				}

				if ($this->user->data['user_posts'] < $this->ext_config['meghivo_post_limit'])
				{
					meta_refresh(5, $aia);
					trigger_error($this->language->lang('UCP_MEGHIVO_POST_LIMIT', $this->ext_config['meghivo_post_limit']) . $aback);
				}

				if ($cmt['ma_kuld'] >= $this->ext_config['meghivo_day_db'] && $this->ext_config['meghivo_day_db'])
				{
					$error[] = $this->language->lang('UCP_MEGHIVO_DAY_OFF');
				}

				if (!$this->auth->acl_get('u_sendemail'))
				{
					$error[] = $this->language->lang('UCP_MEGHIVO_NO_PERM_EMAIL');
				}

				if (!$this->ext_config['meghivo_db'] && !$this->user->data['user_meghivo'] && !$this->auth->acl_get('u_meghivo_max'))
				{
					$error[] = $this->language->lang('UCP_MEGHIVO_NULL');
				}

				if (sizeof($error))
				{
					meta_refresh(10, $aia);
					trigger_error(implode('<br />', $error) . $aback);
				}

				$previous_lang	= $this->request->variable('previous_lang', '');
				$user_lang		= $this->request->variable('invite_lang', $this->user->lang_name);
				$email			= strtolower($this->request->variable('email', ''));
				$subject		= $this->request->variable('subject', '', true);
				$friend			= $this->request->variable('friend', false);
				$lang			= false;

				if ($user_lang != $previous_lang)
				{
					$submit = false;

					if ($user_lang != $this->user->lang_name)
					{
						$lang = $this->functions->trans_lang('info_ucp_meghivo', $user_lang);
					}
				}

				$email_lang_path = $this->root_path . 'ext/leinad4mind/invitation/language/' . $user_lang . '/email/';

				if (!file_exists($email_lang_path . 'user_invite.txt'))
				{
					$error[] = $this->language->lang('UCP_MEGHIVO_NOT_LANGUAGE', $email_lang_path . 'user_invite.txt');
				}

				if (!file_exists($email_lang_path . 'user_invites.txt'))
				{
					$error[] = $this->language->lang('UCP_MEGHIVO_NOT_LANGUAGE', $email_lang_path . 'user_invites.txt');
				}

				$s_hidden_fields = array(
					'previous_lang' => $user_lang,
				);

				$captcha = false;
				if ($this->ext_config['meghivo_captcha_enable'])
				{
					$captcha = $this->captcha_factory->get_instance($this->config['captcha_plugin']);
					$captcha->init(CONFIRM_POST);
				}

				if ($submit)
				{
					if (!check_form_key($form_key))
					{
						$error[] = $this->language->lang('FORM_INVALID');
					}

					if ($captcha)
					{
						$vc_response = $captcha->validate();

						if ($vc_response !== false)
						{
							$error[] = $vc_response;
						}
					}

					if (time() - $this->user->data['user_emailtime'] < $this->config['flood_interval'])
					{
						$error[] = $this->language->lang('UCP_MEGHIVO_FLOOD_LIMIT');
					}

					if (!$email)
					{
						$error[] = $this->language->lang('UCP_MEGHIVO_NO_EMAIL');
					}

					$emailreuse = array();

					if (!sizeof($error))
					{
						if ($this->ext_config['meghivo_email_db'] > 1)
						{
							$email_ary = array_map('strtolower', explode(" ", $email));

							$ed_count = 0;
							$emvs = array();

							foreach ($email_ary as $key => $email_address)
							{
								if (!$email_address)
								{
									unset($email_ary[$key]);
									continue;
								}

								$ed_count++;

								$error = array_merge($error, $this->functions_ucp->email_verify($email_address));

								if (!empty($emvs[$email_address]))
								{
									if ($this->config['allow_emailreuse'])
									{
										$emailreuse[$email_address] = !isset($emailreuse[$email_address]) ? 2 : $emailreuse[$email_address] + 1;
										unset($email_ary[$key]);
									}
									else
									{
										$error[] = $this->language->lang('UCP_MEGHIVO_EDUP', $email_address);
									}
								}

								$emvs[$email_address] = 1;
							}

							unset($emvs);

							if ($ed_count > $this->ext_config['meghivo_day_db'] - $cmt['ma_kuld'] && $this->ext_config['meghivo_day_db'])
							{
								$error[] = $this->language->lang('UCP_MEGHIVO_FUG_LIMIT', $this->ext_config['meghivo_day_db'] - $cmt['ma_kuld'], $ed_count);
							}

							if ($ed_count > $this->ext_config['meghivo_email_db'])
							{
								$error[] = $this->language->lang('UCP_MEGHIVO_KULDES_EMAIL_MAX', $this->ext_config['meghivo_email_db'], $ed_count);
							}
						}
						else
						{
							$error = array_merge($error, $this->functions_ucp->email_verify($email));
						}

						if (!$subject)
						{
							$error[] = $this->language->lang('NO_SUBJECT');
						}

						if (!$message)
						{
							$error[] = $this->language->lang('NO_EMAIL_MESSAGE');
						}
					}

					if (!sizeof($error))
					{
						$email_cim = array();
						$user_lang = $this->functions_ucp->get_lang_for_email('user_invite', $user_lang);
						$messenger = $this->functions_ucp->messenger('user_invite', $subject, $this->ext_config['meghivo_email_priority'], $user_lang);

						if ($this->ext_config['meghivo_email_db'] > 1 && isset($email_ary))
						{
							$invite_count = 0;
							foreach ($email_ary as $email)
							{
								$this->functions_ucp->send($email, $message, $messenger, $friend, $user_lang, $emailreuse);
								$count = !isset($emailreuse[$email]) ? 1 : $emailreuse[$email];
								$invite_count = intval($invite_count + $count);
								$email_cim[] = $email . ($count > 1 ? " - ($count)" : '');
							}
						}
						else
						{
							$this->functions_ucp->send($email, $message, $messenger, $friend, $user_lang);
							$invite_count = 1;
							$email_cim[] = $email;
						}

						unset($messenger);

						$this->log->add('user', $this->user->data['user_id'], $this->user->ip, 'LOG_INVITE_SEND_INVITATION' . ($invite_count > 1 ? 'S' : ''), false, array('reportee_id' => $this->user->data['user_id'], implode(', ', $email_cim)));
						$this->ext_config->set('total_pend', $this->ext_config['total_pend'] + $invite_count);
						meta_refresh(3, $u_action);
						trigger_error($this->language->lang('UCP_MEGHIVO_EMAIL' . ($invite_count == 1 ? '' : 'S') . '_SENT') . $uback);
					}
				}

				$lang_row = array();
				$sql = 'SELECT lang_id FROM ' . LANG_TABLE;
				$result = $this->db->sql_query($sql);
				while ($row = $this->db->sql_fetchrow($result))
				{
					$lang_row[] = $row;
				}
				$this->db->sql_freeresult($result);

				if ($this->ext_config['meghivo_captcha_enable'])
				{
					$s_hidden_fields = array_merge($s_hidden_fields, $captcha->get_hidden_fields());

					$this->template->assign_vars(array(
						'S_CONFIRM_REFRESH'	=> $this->config['confirm_refresh'],
						'CAPTCHA_TEMPLATE'	=> $captcha->get_template(),
					));
				}

				$this->template->assign_vars(array(
					'S_MEGHIVO_MAIL'		=> true,
					'S_FRIEND'				=> $friend,
					'S_INVITE_LANG_OPTIONS'	=> sizeof($lang_row > 1) ? language_select($user_lang) : false,
					'S_HIDDEN_FIELDS'		=> build_hidden_fields($s_hidden_fields),
					'MORE_RECIPIENTS'		=> $this->ext_config['meghivo_email_db'] > 1 ? $this->language->lang('UCP_MEGHIVO_DB', $this->ext_config['meghivo_email_db']) : false,
					'EMAIL_CIM'				=> $email,
					'EMAIL_TEMA'			=> $lang ? $lang->lang('UCP_MEGHIVO') : $this->language->lang('UCP_MEGHIVO'),
					'EMAIL_MESSAGE'			=> $message,
				));

				unset($lang_row);
			break;

			case 'keres':
				$this->page_title = 'UCP_MEGHIVO_KERES';

				if ($this->ext_config['meghivo_db'] || $this->auth->acl_get('u_meghivo_max'))
				{
					meta_refresh(5, $aia);
					trigger_error($this->language->lang('UCP_MEGHIVO_MAX_ERROR') . $aback);
				}

				if (!$this->ext_config['meghivo_req_max'])
				{
					meta_refresh(5, $aia);
					trigger_error($this->language->lang('UCP_MEGHIVO_KERES_DISABLED') . $aback);
				}

				$keres_enable = !$this->functions_ucp->keres($this->user->data['user_id']);
				$igeny_db = $this->request->variable('igeny_db', 0);

				$igeny_post = $this->request->variable('igeny_post' , 0);

				if ($igeny_db > $this->ext_config['meghivo_req_max'])
				{
					$error[] = $this->language->lang('UCP_MEGHIVO_KERES_MAX', $this->ext_config['meghivo_req_max']);
				}

				if ($submit && $this->ext_config['meghivo_req_cause'] && $igeny_db > $this->ext_config['meghivo_req_cause'] && !$message && !$igeny_post)
				{
					$submit = false;
				}

				if ($submit)
				{
					if (!check_form_key($form_key))
					{
						$error[] = $this->language->lang('FORM_INVALID');
					}

					if ($igeny_db < 1)
					{
						$error[] = $this->language->lang('UCP_MEGHIVO_KERES_MIN');
					}

					if ($igeny_db > $this->ext_config['meghivo_req_cause'] && !$message && $igeny_post)
					{
						$error[] = $this->language->lang('UCP_MEGHIVO_KERES_NO_MES');
					}

					if (!sizeof($error) && ($keres_enable === true))
					{
						$this->functions_ucp->adm_send($this->user->data['user_id'], $igeny_db);
						$this->functions_ucp->adm_message($message ?: $this->language->lang('UCP_MEGHIVO_KERES_MESSAGE_NO_DB'), $igeny_db);
						meta_refresh(5, $u_action);
						trigger_error($this->language->lang('UCP_MEGHIVO_KERES_SUCC' . ($igeny_db == 1 ? '' : 'S')) . $this->language->lang('UCP_MEGHIVO_BACK' , '<a href="' . $u_action . '">', '</a>'));
					}
				}

				$this->template->assign_vars(array(
					'S_MEGHIVO_KERES'				=> true,
					'S_IGENY_HSZ_KOTELES'			=> !$error && $this->ext_config['meghivo_req_cause'] && $igeny_db > $this->ext_config['meghivo_req_cause'],
					'MEGHIVO_KERES_ON'				=> $keres_enable,
					'UCP_MEGHIVO_KERES_SOK_EXPLAIN'	=> $this->language->lang('UCP_MEGHIVO_KERES_SOK_EXPLAIN', $this->ext_config['meghivo_req_cause']),
					'MEGHIVO_KERES_DB_SELECT'		=> $igeny_db,
					'MESSAGE'						=> $message,
					'TITLE_MEGHIVO_KERES'			=> $this->language->lang('UCP_MEGHIVO_KERES'),
					'SUBT_MEGHIVO_KERES'			=> $this->language->lang('UCP_MEGHIVO_KERES_TITLE'),
					'SUBT_MEGHIVO_KERES_EXPLAIN'	=> $this->language->lang('UCP_MEGHIVO_KERES_TITLE_EXPLAIN', $this->ext_config['meghivo_req_max']),
					'MEGHIVO_KERES_SUBMIT'			=> $this->language->lang('UCP_MEGHIVO_KERES_SUBMIT'),
				));
			break;

			case 'user':
				$this->page_title = 'UCP_MEGHIVO_USER';
				$this->functions->members_list('ucp');
			break;

			case 'delete':
				$this->page_title = 'UCP_MEGHIVO_DELETE';

				$delete	= $this->request->variable('delete' , 0);
				$email	= strtolower($this->request->variable('email', ''));

				if ($submit)
				{
					if (!check_form_key($form_key))
					{
						$error[] = $this->language->lang('FORM_INVALID');
					}

					if (!$delete)
					{
						$error[] = $this->language->lang('UCP_MEGHIVO_DELETE_NO_CONFIRM');
					}

					if (!sizeof($error))
					{
						$invite_ids = array();
						foreach ($mmu as $row)
						{
							if ($row['meghivo_email'] == $email)
							{
								$invite_ids[] = $row['id'];
							}
						}

						if (sizeof($invite_ids))
						{
							$this->functions->delete_key($invite_ids);
							$this->functions_ucp->add_invite(sizeof($invite_ids));

							$this->log->add('user', $this->user->data['user_id'], $this->user->ip, 'LOG_MEGHIVO_DELETE', false, array('reportee_id' => $this->user->data['user_id'], $email));

							meta_refresh(3, $u_action);
							trigger_error($this->language->lang('UCP_MEGHIVO_DELETE_SUCCES') . $this->language->lang('UCP_MEGHIVO_BACK', '<a href="' . $u_action . '">', '</a>'));
						}
					}
				}

				$this->template->assign_vars(array(
					'S_MEGHIVO_DELETE'				=> true,
					'UCP_MEGHIVO_DELETE_EXPLAIN'	=> $this->language->lang('UCP_MEGHIVO_DELETE_EXPLAIN', $this->ext_config['meghivo_delet_time']),
				));

				foreach ($mmu as $row)
				{
					$count = 0;
					if (!empty($c_mail[$row['meghivo_email']]) || !$row['meghivo_email'] || (time() - $row['meghivo_time'] > ($this->ext_config['meghivo_delet_time'] * 60)))
					{
						continue;
					}

					$c_mail[$row['meghivo_email']] = 1;

					if ($this->config['allow_emailreuse'])
					{
						foreach ($mmu as $cc)
						{
							if ($row['meghivo_email'] == $cc['meghivo_email'])
							{
								$count++;
							}
						}
					}

					$this->template->assign_block_vars('email', array(
						'COUNT' => $count,
						'EMAIL' => $row['meghivo_email'],
					));
				}
			break;

			default:
				trigger_error('NO_ACTION_MODE', E_USER_ERROR);
			break;
		}

		$this->template->assign_vars(array(
			'U_ACTION'			=> $u_action,
			'ERROR_MESSAGE'		=> implode('<br />', $error),
		));
	}
}
