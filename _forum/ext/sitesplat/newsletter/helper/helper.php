<?php
/**
*
* @package BBnewsletter
* @copyright (c) 2016 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\newsletter\helper;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
* Main controller
*/
class helper
{
	protected $config;
	protected $db;
	protected $template;
	protected $user;
	protected $request;
	protected $ext_manager;
	protected $helper;
	protected $phpbb_root_path;
	protected $php_ext;

	/**
	* Constructor
	*
	* @access public
	*/
	public function __construct(\phpbb\config\config $config, \phpbb\db\driver\driver_interface $db, \phpbb\template\template $template, \phpbb\user $user, \phpbb\request\request $request, \phpbb\extension\manager $ext_manager, \phpbb\controller\helper $helper, $phpbb_root_path, $phpEx)
	{
		$this->config = $config;
		$this->db = $db;
		$this->template = $template;
		$this->user = $user;
		$this->request = $request;
		$this->ext_manager = $ext_manager;
		$this->helper = $helper;
		$this->phpbb_root_path = $phpbb_root_path;
		$this->php_ext = $phpEx;
	}
	
	function send_letter($config_aray)
	{
	//	$config_aray = json_decode($this->config['newsletter_settings'], true);

		if ($config_aray['usernames'])
		{
			// If giving usernames the admin is able to email inactive users too...
			$sql = 'SELECT user_id, username, user_email, user_notify_type, user_lang 
				FROM ' . USERS_TABLE . '
				WHERE ' . $this->db->sql_in_set('username_clean', array_map('utf8_clean_string', explode("\n", $config_aray['usernames']))) . '
					AND user_allow_massemail = 1
				ORDER BY user_lang, user_notify_type';
		} else
		{
			if ($config_aray['group'])
			{
				$sql = 'SELECT u.user_id, u.user_email, u.username, u.username_clean, u.user_lang, u.user_notify_type  
					FROM ' . USERS_TABLE . ' u, ' . USER_GROUP_TABLE . ' ug
					WHERE ug.group_id = ' . $config_aray['group'] . '
						AND ug.user_pending = 0
						AND u.user_id = ug.user_id
						AND u.user_allow_massemail = 1
						AND u.user_type IN (' . USER_NORMAL . ', ' . USER_FOUNDER . ')
					ORDER BY u.user_lang, u.user_notify_type';
			} else
			{
				$sql = 'SELECT user_id, username, username_clean, user_email, user_notify_type, user_lang  
					FROM ' . USERS_TABLE . '
					WHERE user_allow_massemail = 1
						AND user_type IN (' . USER_NORMAL . ', ' . USER_FOUNDER . ')
					ORDER BY user_lang, user_notify_type';
			}
		}
		$result = $this->db->sql_query($sql);
		$row = $this->db->sql_fetchrow($result);

		$i = $j = 0;

		// Send with BCC, no more than 50 recipients for one mail (to not exceed the limit)
		$max_chunk_size = 50;
		$email_list = array();
		$old_lang = $row['user_lang'];
		$old_notify_type = $row['user_notify_type'];

		do
		{
			if (($row['user_notify_type'] == NOTIFY_EMAIL && $row['user_email']) ||
				($row['user_notify_type'] == NOTIFY_IM) ||
				($row['user_notify_type'] == NOTIFY_BOTH && $row['user_email']))
			{
				if ($i == $max_chunk_size || $row['user_lang'] != $old_lang || $row['user_notify_type'] != $old_notify_type)
				{
					$i = 0;

					if (sizeof($email_list))
					{
						$j++;
					}

					$old_lang = $row['user_lang'];
					$old_notify_type = $row['user_notify_type'];
				}

				$email_list[$j][$i]['lang']				= $row['user_lang'];
				$email_list[$j][$i]['method']			= $row['user_notify_type'];
				$email_list[$j][$i]['email']			= $row['user_email'];
				$email_list[$j][$i]['name']				= $row['username'];
				$email_list[$j][$i]['user_id']			= $row['user_id'];
				$i++;
			}
		}
		while ($row = $this->db->sql_fetchrow($result));
		$this->db->sql_freeresult($result);

		if (sizeof($email_list))
		{
			if (!class_exists('messenger'))
			{
				include($this->phpbb_root_path . 'includes/functions_messenger.' . $this->php_ext);
			}
			$server_url = generate_board_url();
			$found_topics = false;
			$use_html = ($this->ext_manager->is_enabled('forumhulp/htmlemail') && $config_aray['use_html']) ? true : false;
			$messenger = new \messenger(!$config_aray['immediately']);
			$messenger->set_mail_priority($config_aray['priority']);
			($use_html) ? $messenger->set_mail_html(true) : null;
									   
			$messenger->headers('X-AntiAbuse: Board servername - ' . $this->config['server_name']);
			$messenger->headers('X-AntiAbuse: User_id - ' . $this->user->data['user_id']);
			$messenger->headers('X-AntiAbuse: Username - ' . $this->user->data['username']);
			$messenger->headers('X-AntiAbuse: User IP - ' . $this->user->ip);
			$messenger->assign_vars(array(
				'SITE_LOGO_IMG'		=> $server_url . '/ext/sitesplat/newsletter/vendor/assets/images/gold-logo.png',
				'BOARD_URL'			=> $server_url,
				'NEWSLETTER_ONLINE'	=> preg_replace("/$this->php_ext(&amp;|&)+?/", "$this->php_ext?", preg_replace('/(\?)?(&amp;|&)?sid=[a-z0-9]+/', '', 
									   $this->helper->route('sitesplat_newsletter_main_controller', array('route' => 'index.html'), true, '', UrlGeneratorInterface::ABSOLUTE_URL))),
				'NEWSLETTER_OPTOUT'	=> preg_replace("/$this->php_ext(&amp;|&)+?/", "$this->php_ext?", preg_replace('/(\?)?(&amp;|&)?sid=[a-z0-9]+/', '', 
									   $this->helper->route('sitesplat_newsletter_main_controller', array('route' => 'index.html', 'action' => 'deregister'), true, '', UrlGeneratorInterface::ABSOLUTE_URL)))
				)
			);
			
	// topic limits //sql_query_limit($sql, 20)// to 20 topics max otherwise emails are impossible to read
			$forum_ary = json_decode($this->config['newsletter_forums'], true);
			if (!$this->request->variable('compose', 0) && sizeof($forum_ary))
			{
				$sql = 'SELECT t.topic_title, t.topic_id, t.topic_last_post_id, t.forum_id, f.forum_name
						FROM ' . TOPICS_TABLE . ' t
						LEFT JOIN ' . FORUMS_TABLE . ' f ON f.forum_id = t.forum_id
						WHERE t.forum_id IN (' . implode(',', $forum_ary) . ') AND t.topic_visibility not IN (0, 3) 
						AND t.topic_last_post_time BETWEEN ' . $this->config['newsletter_last_gc'] . ' AND ' . time() . '
						ORDER BY topic_last_post_time DESC';
				$result = $this->db->sql_query_limit($sql, 20);
				while ($row = $this->db->sql_fetchrow($result))
				{
					$messenger->assign_block_vars('mailrow', array(
						'FORUMS'	=> $row['forum_name'],
						'U_FORUM'	=> $server_url . '/viewforum.' . $this->php_ext . '?f=' . $row['forum_id'],
						'TOPIC'		=> $row['topic_title'],
						'U_TOPIC'	=> $server_url . '/viewtopic.' . $this->php_ext . '?f=' . $row['forum_id'] . '&p=' . $row['topic_last_post_id'] . '#p' . $row['topic_last_post_id']
					));
					$found_topics = true;
				}
			} else
			{
				$messenger->assign_vars(array(
					'SUBJECT'			=> utf8_normalize_nfc($this->request->variable('subject', '', true)),
					'MESSAGE'			=> ($use_html) ? htmlspecialchars_decode(utf8_normalize_nfc($this->request->variable('message', '', true))) : 
											strip_tags(htmlspecialchars_decode(utf8_normalize_nfc($this->request->variable('message', '', true)))),
				));				
			}

			if ($this->request->variable('compose', 0) || $found_topics)
			{
				for ($i = 0, $size = sizeof($email_list); $i < $size; $i++)
				{
					$used_lang = $email_list[$i][0]['lang'];
					$used_method = $email_list[$i][0]['method'];
					
					$templ = ($this->request->variable('compose', 0)) ? 'newsletter_' : 'newsoverview_';
					$templ = ($use_html) ? $templ . 'html' : $templ . 'txt';
					$messenger->template('@sitesplat_newsletter/' . $templ, $used_lang);
								   
					for ($j = 0, $list_size = sizeof($email_list[$i]); $j < $list_size; $j++)
					{
						$email_row = $email_list[$i][$j];
						$messenger->{((sizeof($email_list[$i]) == 1) ? 'to' : 'bcc')}($email_row['email'], $email_row['name']);
					}
	
					if (!($messenger->send($used_method)))
					{
						$errored = true;
					}
				}
				unset($email_list);
				$messenger->save_queue();
			}
		}
	}
}