<?php
/**
*
* @package BBgdpr
* @copyright (c) 2018 SiteSplat All rights reserved
* @license Proprietary
*/

namespace sitesplat\bbgdpr\ucp;

use \sitesplat\bbgdpr\RecursiveZipArchive;

/**
 * BBgdpr UCP module.
 */
class main_module
{
	public $u_action;

	protected $db;
	protected $template;
	protected $user;
	protected $language;
	protected $request;
	protected $type_collection;
	protected $auth;
	protected $phpbb_dispatcher;
	protected $log;
	protected $notification_manager;
	protected $config;
	protected $root_path;
	public function __construct()
	{
		global $phpbb_container;

		$this->db = $phpbb_container->get('dbal.conn');
		$this->template = $phpbb_container->get('template');
		$this->user = $phpbb_container->get('user');
		$this->language = $phpbb_container->get('language');
		$this->request = $phpbb_container->get('request');
		$this->type_collection = $phpbb_container->get('profilefields.type_collection');
		$this->auth = $phpbb_container->get('auth');
		$this->phpbb_dispatcher = $phpbb_container->get('dispatcher');
		$this->log = $phpbb_container->get('log');
		$this->notification_manager = $phpbb_container->get('notification_manager');
		$this->config = $phpbb_container->get('config');
		$this->root_path = $phpbb_container->getParameter('core.root_path');
	}

	public function main($id, $mode)
	{
		switch ($mode)
		{
			case 'review':

				$this->tpl_name = 'ucp_review';
				$this->page_title = $this->user->lang('UCP_REVIEW');

				$user_data = $this->get_user_data();
				$this->template->assign_vars($user_data);

				$user_cpfs = $this->get_user_cpfs();
				foreach ($user_cpfs as $user_cpf)
				{
					$this->template->assign_block_vars('cpf_data', array(
						'FIELD_NAME'	=> $user_cpf['field_name'],
						'FIELD_DATA'	=> $user_cpf['field_data'],
					));
				}

				$user_ips = $this->get_user_ips();
				foreach ($user_ips as $user_ip)
				{
					$this->template->assign_block_vars('ips', array(
						'IP'	=> $user_ip,
					));
				}

				/**
				* Assign additional personal data that your extension might have added.
				*
				* @event sitesplat.bbgdpr.ucp_review
				*/
				extract($this->phpbb_dispatcher->trigger_event('sitesplat.bbgdpr.ucp_review'));

			break;

			case 'download':

				$this->tpl_name = 'ucp_download';
				$this->page_title = $this->user->lang('UCP_DOWNLOAD');

				$action = $this->request->variable('action', '');

				// prepare directory
				if ($action == 'posts' || $action == 'everything')
				{
					$root_dir = $this->root_path . 'store/bbgdpr/' . $this->user->data['user_id'];
					$this->rmdir($root_dir);
					mkdir($root_dir, 0755, true);
				}

				switch ($action)
				{
					case 'everything':

						// Stores label => value
						$personal_data = array();

						// Simple values
						$user_data = $this->get_user_data();
						foreach ($user_data as $lang => $value)
						{
							if (!empty($value))
							{
								$personal_data[$this->language->lang($lang)] = $value;
							}
						}

						// CPFs
						$user_cpfs = $this->get_user_cpfs();
						foreach ($user_cpfs as $user_cpf)
						{
							$personal_data[$user_cpf['field_name']] = $user_cpf['field_data'];
						}

						// User IPs
						$user_ips = $this->get_user_ips();
						if (!empty($user_ips))
						{
							$personal_data[$this->language->lang('USER_IPS')] = implode($user_ips, ', ');
						}

						/**
						* Assign additional personal user data that your extension might have added.
						* Expected format is "translated label" => "value".
						* Every key will be outputted as one line, so either implode multiple values
						* with a comma or hack the system using "\n".
						*
						* @event sitesplat.bbgdpr.ucp_download_personal_data
						* @var	array	personal_data	Array of personal user data
						*/
						$vars = array(
							'personal_data',
						);
						extract($this->phpbb_dispatcher->trigger_event('sitesplat.bbgdpr.ucp_download_personal_data', compact($vars)));

						// Generate file
						$template = '';
						foreach ($personal_data as $lang => $value)
						{
							$template .= $lang . ': ' . $value . "\n";
						}
						file_put_contents($root_dir . '/personal.txt', $template);

					// no break;

					case 'posts':

						$posts_dir = $root_dir . '/posts';
						mkdir($posts_dir, 0755, true);

						$sql = 'SELECT forum_id, topic_id, bbcode_bitfield, post_text, bbcode_uid, bbcode_bitfield, post_time
								FROM ' . POSTS_TABLE . '
								WHERE poster_id = ' . $this->user->data['user_id'];
						$result = $this->db->sql_query($sql);
						while ($row = $this->db->sql_fetchrow($result))
						{
							$post_dir = $posts_dir . '/' . $row['forum_id'] . '/' . $row['topic_id'];
							mkdir($post_dir, 0755, true);

							$parse_flags = ($row['bbcode_bitfield'] ? OPTION_FLAG_BBCODE : 0) | OPTION_FLAG_SMILIES;
							$contents = generate_text_for_display($row['post_text'], $row['bbcode_uid'], $row['bbcode_bitfield'], $parse_flags, false);
							// replace relative URLs with absolute ones
							$contents = str_replace('src=".', 'src="' . generate_board_url(), $contents);
							file_put_contents($post_dir . '/' . $row['post_time'] . '.html', $contents);
						}
					
					// no break;

					default:

						if (!empty($action))
						{
							/**
							* Perform additional actions to prepare user data to be
							* downloaded. Only store the data to subdorectories in $root_dir!
							*
							* @event sitesplat.bbgdpr.ucp_download_zip_before
							* @var	string	$root_dir	Root dir to store data
							*/
							$vars = array(
								'root_dir',
							);
							extract($this->phpbb_dispatcher->trigger_event('sitesplat.bbgdpr.ucp_download_zip_before', compact($vars)));

							// Pack the data
							$zip_filename = 'gdpr_' . $this->user->data['user_id'] . '.zip';
							$zip_file = $this->root_path . 'store/bbgdpr/' . md5($zip_filename . time());
							RecursiveZipArchive::zipTree($root_dir, $zip_file, \ZipArchive::CREATE);
							$this->rmdir($root_dir);

							// Send the data
							header('Content-type:  application/zip');
							header('Content-Length: ' . filesize($zip_file));
							header('Content-Disposition: attachment; filename="' . $zip_filename . '"');
							readfile($zip_file);
							exit;
						}
				}

				$this->template->assign_vars(array(
					'U_DOWNLOAD_POSTS'		=> $this->u_action . '&action=posts',
					'U_DOWNLOAD_EVERYTHING'	=> $this->u_action . '&action=everything',
				));

			break;

			case 'delete':

				$this->tpl_name = 'ucp_delete';
				$this->page_title = $this->user->lang('UCP_DELETE');
				add_form_key('sitesplat/bbgdpr_delete');

				if (confirm_box(true))
				{
					// send notification to admins
					$this->notification_manager->add_notifications('sitesplat.bbgdpr.notification.type.user_deleted', array(
						'user_id'	=> $this->user->data['user_id'],
						'username'	=> $this->user->data['username'],
					));

					$this->delete_account();
				}
				else
				{
					if ($this->request->variable('submit', false))
					{
						$delete_type = $this->delete_confirmation();
		
						confirm_box(false, 'DELETE_FINAL', build_hidden_fields(array(
							'submit'		=> false,
							'delete_type'	=> $delete_type,
						)));
					}
				}

				$this->template->assign_vars(array(
					'S_CAN_DELETE'		=> $this->user->data['user_type'] != USER_FOUNDER,
					'S_CAN_DELPOSTS'	=> $this->auth->acl_get('u_delete_my_account_posts'),
					'U_ACTION'			=> $this->u_action,
				));

			break;
		}
	}

	protected function get_user_data()
	{
		$sql = 'SELECT *
				FROM ' . USERS_TABLE . '
				WHERE user_id = ' . $this->user->data['user_id'];
		$result = $this->db->sql_query($sql);
		$row = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);

		$personal_data = array(
			'USERNAME'				=> $row['username'],
			'PRIVACY_ACCEPT_DATE'	=> ($row['user_privacy_accept_date'] > 0) ? $this->user->format_date($row['user_privacy_accept_date'], false, true) : $this->language->lang('NOT_ACCEPTED'),
			'COOKIE_ACCEPT_DATE'	=> ($row['user_cookie_accept_date'] > 0) ? $this->user->format_date($row['user_cookie_accept_date'], false, true) : $this->language->lang('NOT_ACCEPTED'),
			'BIRTHDAY'				=> $row['user_birthday'],
			'EMAIL'					=> $row['user_email'],
			'REG_DATE'				=> $this->user->format_date($row['user_regdate'], false, true),
			'REG_IP'				=> $row['user_ip'],
		);

		if ($row['user_mcp_accept_date'] > 0)
		{
			$personal_data['MCP_ACCEPT_DATE'] = $this->user->format_date($row['user_mcp_accept_date'], false, true);
		}

		/**
		* Assign additional personal user data that your extension might have added.
		*
		* @event sitesplat.bbgdpr.ucp_personal_user_data
		* @var	array	personal_data	Array of personal user data
		*/
		$vars = array(
			'personal_data',
		);
		extract($this->phpbb_dispatcher->trigger_event('sitesplat.bbgdpr.ucp_personal_user_data', compact($vars)));

		return $personal_data;
	}

	protected function get_user_cpfs()
	{
		$sql = 'SELECT pf.field_name, pl.lang_name
				FROM ' . PROFILE_FIELDS_TABLE . ' pf
				LEFT JOIN ' . PROFILE_LANG_TABLE . ' pl
					ON (pl.field_id = pf.field_id)
				LEFT JOIN ' . LANG_TABLE . ' l
					ON (pl.lang_id = l.lang_id)
				WHERE l.lang_iso = "' . $this->db->sql_escape($this->user->data['user_lang']) . '"';
		$result = $this->db->sql_query($sql);
		$pf_fields_array = array();
		while ($row = $this->db->sql_fetchrow($result))
		{
			$pf_fields_array['pf_' . $row['field_name']] = $this->language->lang($row['lang_name']);
		}
		$this->db->sql_freeresult($result);

		$sql = 'SELECT *
				FROM ' . PROFILE_FIELDS_DATA_TABLE . '
				WHERE user_id = ' . $this->user->data['user_id'];
		$result = $this->db->sql_query($sql);
		$pf_data = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);

		$user_cpfs = array();

		if ($pf_data)
		{
			foreach($pf_data as $key => $data)
			{
				if ($data && $key != 'user_id')
				{
					$user_cpfs[] = array(
						'field_name'	=> $pf_fields_array[$key],
						'field_data'	=> $this->get_pf_data($data, $key),
					);
				}
			}
		}

		return $user_cpfs;
	}

	protected function get_user_ips()
	{
		$user_ips = array();

		$sql = 'SELECT poster_ip
				FROM ' . POSTS_TABLE . '
				WHERE poster_id = ' . $this->user->data['user_id'] . "
				GROUP BY poster_ip";
		$result = $this->db->sql_query($sql);
		while ($row = $this->db->sql_fetchrow($result))
		{
			$user_ips[] = $row['poster_ip'];
		}
		$this->db->sql_freeresult($result);

		return $user_ips;
	}

	protected function get_pf_data($field_value, $field_name)
	{
		// Remove 'pf_' from the field name
		$field_name = substr($field_name, 3);

		// Get the field data
		$sql = $this->db->sql_build_query('SELECT', array(
			'SELECT'	=> 'pf.*, pfl.lang_id, pfl.option_id, pfl.lang_value',
			'FROM'		=> array(
				PROFILE_FIELDS_TABLE => 'pf',
			),
			'LEFT_JOIN'	=> array(
				array(
					'FROM'	=> array(PROFILE_FIELDS_LANG_TABLE	=> ' pfl',),
					'ON'	=> 'pf.field_id = pfl.field_id',
				),
			),
			'WHERE' => "pf.field_name = '" . $field_name . "'",
		));
		$result = $this->db->sql_query($sql);
		$profile_data = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);

		$profile_field = $this->type_collection[$profile_data['field_type']];
		return $profile_field->get_profile_value($field_value, $profile_data);
	}

	protected function rmdir($dir)
	{
		if (!file_exists($dir))
		{
			return;
		}

		$files = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($dir, \RecursiveDirectoryIterator::SKIP_DOTS), \RecursiveIteratorIterator::CHILD_FIRST);
		
		foreach ($files as $fileinfo)
		{
			$todo = $fileinfo->isDir() ? 'rmdir' : 'unlink';
			$todo($fileinfo->getRealPath());
		}
		
		rmdir($dir);
	}

	private function delete_confirmation()
	{
		global $phpbb_container;

		$passwords_manager = $phpbb_container->get('passwords.manager');

		$delete       = $this->request->variable('delete', false);
		$understand   = $this->request->variable('understand', false);
		$password     = $this->request->variable('password', '', true);
		$remove_posts = $this->request->variable('remove_posts', false);

		if (!check_form_key('sitesplat/bbgdpr_delete'))
		{
			trigger_error($this->language->lang('FORM_INVALID') . $this->ucp_back_link(), E_USER_WARNING);
		}

		// Decide if the posts are to be deleted or not
		$delete_type = $this->auth->acl_get('u_delete_my_account_posts') ? ($remove_posts ? 'remove' : 'retain') : 'retain';

		// Stop Founders from deleting themselves
		if ($this->user->data['user_type'] == USER_FOUNDER)
		{
			trigger_error($this->user->lang('FOUNDER_ERROR') . $this->ucp_back_link(), E_USER_WARNING);
		}

		// Check the user really wants to delete themselves
		if (!$delete)
		{
			trigger_error($this->language->lang('REALLY_ERROR') . $this->ucp_back_link(), E_USER_WARNING);
		}

		// Check the user understands that it can not be undone
		if (!$understand)
		{
			trigger_error($this->language->lang('UNDERSTAND_ERROR') . $this->ucp_back_link(), E_USER_WARNING);
		}

		// Check that the user entered their password correctly
		if (!$passwords_manager->check($password, $this->user->data['user_password']))
		{
			trigger_error($this->language->lang('PASSWORD_ERROR') . $this->ucp_back_link(), E_USER_WARNING);
		}

		return $delete_type;
	}

	private function delete_account()
	{
		$delete_type = $this->request->variable('delete_type', 'retain');

		// Create the log message
		$log = $this->language->lang('LOG_USER_DELETED', $this->user->data['username'], $this->user->data['user_id']);

		// Append the log message with a note about what happened to the posts
		if ($this->user->data['user_posts'] > 0)
		{
			$log .= ($delete_type == 'retain') ? $this->language->lang('LOG_POST_RETAINED') : $this->language->lang('LOG_POST_REMOVED');
		}
		else
		{
			$log .= $this->user->lang('LOG_NO_POSTS');
		}

		// Add the deletion to the user log using ANONYMOUS user_id (we have to do this before the delete otherwise it won't work)
		$this->log->add('user', ANONYMOUS, $this->user->data['user_ip'], 'LOG_USER_DELETED', time(), array('reportee_id' => ANONYMOUS, 'log_data' => $log));

		// Change the username so that it will be unique
		$faker = \Faker\Factory::create();
		$new_name = $faker->name;

		// Update the various places it might be set outside of the user table
		user_update_name($this->user->data['username'], $new_name);

		// Update the user table but only the username column (not username-clean) because we'll delete the user next anyway
		$this->db->sql_query('UPDATE ' . USERS_TABLE . " SET username = '" . $this->db->sql_escape($new_name) . "' WHERE user_id = " . (int) $this->user->data['user_id']);

		// Delete the user (and the posts if requested otherwise we keep them with the new username)
		user_delete($delete_type, $this->user->data['user_id'], true);

		// Update total amount of deleted GDPR users
		$this->config->increment('sitesplat_bbgdpr_deleted', 1);

		// Say goodbye to the user and redirect them to the board root
		meta_refresh(6, $this->root_path);
		trigger_error('GOODBYE_ERROR');
	}

	function ucp_back_link()
	{
		return '<br /><br /><a href="' . $this->u_action . '">&laquo; ' . $this->language->lang('BACK_TO_PREV') . '</a>';
	}
}
