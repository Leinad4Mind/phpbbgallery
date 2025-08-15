<?php
/**
*
* @package BBnewsletter
* @copyright (c) 2016 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\newsletter\controller;

use phpbb\config\config;
use phpbb\controller\helper;
use phpbb\template\template;
use phpbb\user;
use phpbb\auth\auth;
use phpbb\request\request;
use phpbb\db\driver\driver_interface;
use phpbb\pagination;
use phpbb\passwords\manager;

/**
* Main controller
*/
class main_controller
{
	protected $config;
	protected $helper;
	protected $template;
	protected $user;
	protected $auth;
	protected $request;
	protected $db;
	protected $pagination;
	protected $passwords_manager;
	protected $newsletter_table;
	protected $phpbb_root_path;
	protected $php_ext;

	/**
	* Constructor
	* @access public
	*/
	public function __construct(config $config, helper $helper, template $template, user $user, auth $auth, request $request, driver_interface $db, pagination $pagination, manager $passwords_manager, $newsletter_table, $phpbb_root_path, $phpEx)
	{
		$this->config = $config;
		$this->helper = $helper;
		$this->template = $template;
		$this->user = $user;
		$this->auth 				= $auth;
		$this->request = $request;
		$this->db = $db;
		$this->pagination = $pagination;
		$this->passwords_manager = $passwords_manager;
		$this->newsletter_table = $newsletter_table;
		$this->phpbb_root_path = $phpbb_root_path;
		$this->php_ext = $phpEx;
	}

	/**
	* Display the page
	*
	* @param string $route The route name for a page
	* @return \Symfony\Component\HttpFoundation\Response A Symfony Response object
	* @access public
	*/
	public function display($route)
	{
		$submit = $this->request->is_set_post('submit');
		$action = $this->request->variable('action', '');
		$deregister = 0;

		$this->user->add_lang_ext('sitesplat/newsletter', 'newsletter');

		// this is kinda dangerous...should be mb_strtolower
		$email = strtolower($this->request->variable('email', ''));

		$emtype = empty($this->user->data['user_email_hash']) ? " WHERE user_email = '" . $this->db->sql_escape($email) . "'" : ' WHERE user_email_hash = ' . phpbb_email_hash($email);

		if ($this->user->data['is_registered'])
		{
			$sql = 'SELECT user_id, user_allow_massemail
					FROM ' . USERS_TABLE . $emtype;
			$result = $this->db->sql_query($sql);
			$row =  $this->db->sql_fetchrow($result);

			if ($row['user_id'] > 1)
			{
				$deregister = $row['user_allow_massemail'];
			}
		}
		$deregister = $this->user->data['is_registered'] && $this->user->data['user_allow_massemail'] || $deregister;

		if ($submit || $action == 'deregister')
		{
			if ($action == 'register' && !$deregister)
			{
				$uname = utf8_normalize_nfc($this->request->variable('username', '', true));

				if ($this->user->data['is_registered'])
				{
					$sql = 'UPDATE ' . USERS_TABLE . ' SET user_allow_massemail = 1 WHERE user_id = ' . $this->user->data['user_id'];
					$this->db->sql_query($sql);

					$this->template->assign_vars(array('REGISTER' => true, 'BEDANKT' => $this->user->lang['SUBSCRIBED']));
				} else
				{
					$sql = 'SELECT user_id, user_password FROM ' . USERS_TABLE . $emtype;
					$result = $this->db->sql_query($sql);
					$row =  $this->db->sql_fetchrow($result);

					if ($row['user_id'] > 1)
					{
						$pass = $this->request->variable('password', '', true);

						if ($pass)
						{
							$userid = $row['user_id'];
							if ($this->passwords_manager->check($pass, $row['user_password'], $row))
							{
								$sql = 'UPDATE ' . USERS_TABLE . ' SET user_allow_massemail = 1 WHERE user_id = ' . $userid;
								$this->db->sql_query($sql);

								$this->template->assign_vars(array('REGISTER' => true, 'BEDANKT' => $this->user->lang['SUBSCRIBED']));
							} else
							{
								$this->template->assign_vars(array('REGISTER' => true, 'BEDANKT' => $this->user->lang['LOGIN_ERROR_PASSWORD']));
							}
						} else
						{
							$this->template->assign_vars(array('REGISTER' => true, 'PASS' => true,
								'UNAME'		=> $uname,
								'UEMAIL'	=> $email,
							));
						}
					} else // No member
					{
						$pass = $this->request->variable('password', '', true);

						if ($pass)
						{
							$sql = 'SELECT group_id
									FROM ' . GROUPS_TABLE . " WHERE group_name = '" . $this->db->sql_escape('REGISTERED') . "' AND group_type = " . GROUP_SPECIAL;
							$result = $this->db->sql_query($sql);
							$row = $this->db->sql_fetchrow($result);

							$data = array(
								'username'				=> $uname,
								'user_password'			=> $this->passwords_manager->hash($pass),
								'user_email'			=> $email,
								'group_id'				=> $row['group_id'],
								'user_type'				=> USER_NORMAL,
								'user_lang'				=> $this->config['default_lang'],
								'user_timezone'			=> $this->config['board_timezone'],
								'user_actkey'			=> '',
								'user_ip'				=> $this->user->ip,
								'user_regdate'			=> time(),
								'user_inactive_reason'	=> 0,
								'user_inactive_time'	=> 0,
								'user_new'				=> 1,
							);

							include ($this->phpbb_root_path . 'includes/functions_user.' . $this->php_ext);
							$error = validate_data($data, array(
								'username'			=> array(
									array('string', false, $this->config['min_name_chars'], $this->config['max_name_chars']),
									array('username', $uname)),
								'user_email'		=> array(
									array('string', false, 6, 60),
									array('user_email')),
								'user_timezone'		=> array('timezone'),
								'user_lang'			=> array('language_iso_name'),
							));

							$config_aray = json_decode($this->config['newsletter_settings'], true);
							if (!$config_aray['newuser'])
							{
								$error[] = 'LOGIN_VIEWFORUM';
							}

							if (sizeof($error))
							{
								$this->user->lang = array_merge($this->user->lang, array(
									'INVALID_CHARS'	=> $this->config['LOGIN_ERROR_USERNAME']
								));

								// Replace "error" strings with their real, localised form
								$error = array_map(array($this->user, 'lang'), $error);
								$this->template->assign_vars(array('REGISTER' => true, 'BEDANKT' => implode('<br />', $error) ));
							} else
							{
								$user_id = user_add($data);
								$result = $this->auth->login($uname, $pass);

								$this->template->assign_vars(array('REGISTER' => true, 'BEDANKT' => $this->user->lang['SUBSCRIBED']));
							}
						} else
						{
							$this->template->assign_vars(array('REGISTER' => true, 'PASS' => true,
								'UNAME'		=> $uname,
								'UEMAIL'	=> $email,
							));
						}
					}
				}


			} elseif ($action == 'deregister' || $deregister)
			{
				if ($this->user->data['is_registered'])
				{
					$sql = 'UPDATE ' . USERS_TABLE . ' SET user_allow_massemail = 0 WHERE user_id = ' . $this->user->data['user_id'];
					$this->db->sql_query($sql);

					$this->template->assign_vars(array('REGISTER' => true, 'BEDANKT' => $this->user->lang['UNSUBSCRIBED']));
				} else
				{
					$sql = 'SELECT user_id, username, user_password
							FROM ' . USERS_TABLE . $emtype;
					$result = $this->db->sql_query($sql);
					$row =  $this->db->sql_fetchrow($result);

					if ($row['user_id'] > 1)
					{
						$pass = $this->request->variable('password', '', true);

						if ($pass)
						{
							$userid = $row['user_id'];
							if ($this->passwords_manager->check($pass, $row['user_password'], $row))
							{
								$sql = 'UPDATE ' . USERS_TABLE . ' SET user_allow_massemail = 0 WHERE user_id = ' . $userid;
								$this->db->sql_query($sql);

								$this->template->assign_vars(array('REGISTER' => true, 'BEDANKT' => $this->user->lang['UNSUBSCRIBED']));
							} else
							{
								$this->template->assign_vars(array('REGISTER' => true, 'BEDANKT' => $this->user->lang['LOGIN_ERROR_PASSWORD']));
							}
						} else
						{
							$this->template->assign_vars(array(
								'REGISTER'		=> true,
								'PASS'			=> true,
								'DEREGISTER'	=> 1,
								'UNAME'			=> $row['username'],
								'UEMAIL'		=> $email,
							));
						}
					} else
					{
						$this->template->assign_vars(array('REGISTER' => 1, 'DEREGISTER' => 1));
					}
				}
			} else
			{
				$this->template->assign_vars(array(
					'REGISTER'		=> true,
					'DEREGISTER'	=> $deregister,
					'EMAIL'			=> ($this->user->data['user_email'] != '') ? $this->user->data['user_email'] : $email,
					'USERNAME' 		=> ($this->user->data['user_id'] > 1) ? $this->user->data['username'] : '',
				));
			}
			$this->template->assign_vars(array(
				'EMAIL'			=> $this->user->data['user_email'],
				'SUBSCRIBE'		=> ($this->user->data['user_allow_massemail']) ? $this->user->lang['UNSUBSCRIBE'] : $this->user->lang['SUBSCRIBE']
			));
		}

		// Load the page data to display
		$display = $this->load_page_data($route);


		if ($action == 'deregister')
		{
			$this->template->assign_vars(array(
				'REGISTER'		=> true,
				'DEREGISTER'	=> $deregister
			));
		}
		// Create breadcrumbs
		$this->template->assign_block_vars('navlinks', array(
			'FORUM_NAME'	=> $this->user->lang['NEWSLETTER'],
			'U_VIEW_FORUM'	=> $this->helper->route('sitesplat_newsletter_main_controller', array('route' => $route)),
		));

		// Send all data to the template file
		return $this->helper->render('newsletter.html', $this->user->lang['NEWSLETTER'] . ' ' . $this->config['server_name']);
	}

	/**
	* Load the page data
	*
	* @param string $route The route name for a page
	* @return object $entity The entity object, or false if page can't be displayed
	* @access public
	*/
	protected function load_page_data($route)
	{
		// Load the requested page by route
		$season = $this->season(time());
		$user_pr = 1;

		$letter = $this->request->variable('letter', 0);
		$sqlwhere = (!$user_pr) ? 'display_it = 1' : 'display_it >= 0';

		if ($letter)
		{
			$sql = 'SELECT id FROM ' . $this->newsletter_table . ' WHERE ' . $sqlwhere . ' AND id = ' . $letter;
			$result = $this->db->sql_query($sql);
			if (!($row = $this->db->sql_fetchrow($result)))
			{
				$sql = 'SELECT id FROM ' . $this->newsletter_table . ' WHERE ' . $sqlwhere . ' ORDER BY time DESC LIMIT 1';
				$result = $this->db->sql_query($sql);
				$letter = (int) $this->db->sql_fetchfield('id');
				$this->db->sql_freeresult($result);
			}

			$sql = 'SELECT * FROM ' . $this->newsletter_table . ' WHERE ' . $sqlwhere . ' AND id = ' . $letter;
			$result = $this->db->sql_query_limit($sql, 1);

			if ($result)
			{
				$row = $this->db->sql_fetchrow($result);
				$this->db->sql_freeresult($result);
				$concept = ($row['display_it'] == 0) ? 'Concept ' : '';
				$this->template->assign_vars(array(
					'S_MAIL_VIEW'	=> true,
					'MAIL_SUBJECT'	=> $concept.htmlspecialchars_decode($row['subject']),
					'MAIL_MESSAGE'	=> htmlspecialchars_decode($row['message']),
					'MAIL_DATE'		=> $this->user->format_date($row['time'], 'j F Y'),
					)
				);
				$this->db->sql_query('UPDATE ' . $this->newsletter_table . ' SET hits = hits + 1 WHERE id = '.$letter);
			}
		} else
		{
			$sql = 'SELECT * FROM ' . $this->newsletter_table . '
					WHERE ' . $sqlwhere .
					(sizeof($season) ? ' AND time BETWEEN ' . $season[key($season)]['datebegin'] . ' AND ' . $season[key($season)]['dateend'] : '') . '
					ORDER BY id DESC';
			$result = $this->db->sql_query($sql);

			if ($result)
			{
				$rows = $this->db->sql_fetchrowset($result);
				$count = 0;
				foreach ($rows as $row)
				{
					$concept = ($row['display_it'] == 0) ? 'Concept ' : '';
					$this->template->assign_block_vars('mailrow', array(
						'MAIL_ID'	    => $row['id'],
						'SUBJECT'		=> $concept.htmlspecialchars_decode($row['subject']),
						'TIME'			=> $this->user->format_date($row['time'], 'j F Y'),
						'U_VIEW'		=> $this->helper->route('sitesplat_newsletter_main_controller', array('route' => $route)) . '?letter='.$row['id'],
						'S_ROW_COUNT'	=> $count
						)
					);
					$count++;
				}
			}

			$last_mon = 0;
			$archive_rows = array();
			foreach ($season as $key => $a)
			{
				$sql = 'SELECT id, subject, time as datum FROM ' . $this->newsletter_table . '
						WHERE display_it = 1 AND time BETWEEN ' . $a['datebegin'] . ' AND ' . $a['dateend'] . ' ORDER BY datum DESC';
				$result = $this->db->sql_query($sql);
				while ($row = $this->db->sql_fetchrow($result))
				{
					if ($key != $last_mon)
					{
						$archive_row = array(
							'ARCHIVE'	=> $this->user->format_date($row['datum'], 'Y'),
							'monthrow'	=> array(),
						);
						$archive_rows[] = $archive_row;
					}

					$archive_row_month = array(
						'TITLE'			=> $row['subject'],
						'U_VIEW'		=> $row['id'],
						'DATE'			=> $this->user->format_date($row['datum'], 'j F Y'),
					);

					$archive_rows[sizeof($archive_rows) - 1]['monthrow'][] = $archive_row_month;
					$last_mon = $key;
				}
			}

			foreach($archive_rows as $row)
			{
				$this->template->assign_block_vars('archiverow', $row);
			}

			$this->template->assign_vars(array(
				'S_ARCHIVES'	=> (sizeof($archive_rows)) ? true : false,
				'T_THEME_PATH'	=> '/styles/' . rawurlencode($this->user->style['style_path']) . '/theme',
				'IMG_PLUS'		=> '/ext/sitesplat/newsletter/styles/all/template/css/images/plus.png',
				'IMG_MINUS'		=> '/ext/sitesplat/newsletter/styles/all/template/css/images/min.png',
			));
		}
		$this->template->assign_vars(array(
			'USERNAME'		=> ($this->user->data['is_registered']) ? $this->user->data['username'] : '',
			'EMAIL'			=> $this->user->data['user_email'],
			'DEREGISTER'	=> ($this->user->data['user_allow_massemail']) ? true : false
		));
	}

	protected function season($time)
	{
		$sql = 'SELECT DISTINCT FROM_UNIXTIME(time, "%Y") AS jaar FROM ' . $this->newsletter_table . ' WHERE display_it = 1 ORDER BY jaar DESC';
		$result = $this->db->sql_query($sql);
		$i = 1;
		$season = array();
		while ($row = $this->db->sql_fetchrow($result))
		{
			$season[$i] = array('datebegin' => strtotime($row['jaar'] . '-01-01 00:00:01'), 'dateend' => strtotime($row['jaar'] . '-12-31 23:59:59'));
			$i++;
		}
		$result = array();
		foreach ($season as $key => $a)
		{
			if ($time >= $a['datebegin'] && $time <= $a['dateend']) {$result[$i - $key] = $a;}
			if ($time >= $a['datebegin'] && $time >= $a['dateend']) {$result[$i - $key] = $a;}
		}
		return $result;
	}
}
