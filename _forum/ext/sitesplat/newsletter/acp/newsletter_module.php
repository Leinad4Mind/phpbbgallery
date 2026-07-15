<?php
/**
*
* @package BBnewsletter
* @copyright (c) 2016 SiteSplat All rights reserved
* @license Proprietary
*
*/

namespace sitesplat\newsletter\acp;

class newsletter_module
{
	protected $config;
	protected $db;
	protected $user;
	protected $request;
	protected $template;
	protected $phpbb_container;
	protected $phpbb_root_path;
	protected $php_ext;

	public $u_action;
	
	function main($id, $mode)
	{
		global $config, $db, $user, $request, $template, $phpbb_container, $phpbb_root_path, $phpEx, $phpbb_admin_path;

		$this->config = $config;
		$this->db = $db;
		$this->user = $user;
		$this->request = $request;
		$this->template = $template;
		$this->root_path = $phpbb_root_path;
		$this->php_ext = $phpEx;
		$this->helper = $phpbb_container->get('sitesplat.newsletter.helper');
		$this->table_newsletter = $phpbb_container->getParameter('sitesplat.newsletter.tables.newsletter');

		$this->tpl_name = 'acp_newsletter';
		$this->page_title = 'ACP_NEWSLETTER';

		$form_key = 'acp_email_html';
		add_form_key($form_key);

		// Set some vars
		$submit		= $this->request->is_set_post('submit');
		$action		= $this->request->variable('action', '');
		$mail_id	= $this->request->variable('mail', 0);
		$error		= array();

		
		$user->add_lang_ext('sitesplat/newsletter', 'info_acp_newsletter');
			
		switch ($action){
			case 'details':
				$phpbb_container->get('sitesplat.BBCore.helper')->detail('sitesplat/newsletter');
				$this->tpl_name = 'acp_ext_details';
			break;

			case 'delete':
				$sql = 'DELETE FROM ' . $this->table_newsletter . ' WHERE id = ' . $mail_id;
				$result = $this->db->sql_query($sql);
				
				trigger_error($user->lang['DELETE_MAIL_SUCCES'] . adm_back_link($this->u_action));
			break;

			case 'view':
				$sql = 'SELECT * FROM ' . $this->table_newsletter . ' WHERE id = ' . $mail_id;
				$result = $this->db->sql_query_limit($sql, 1);
				
				if ($result)
				{
					$row = $this->db->sql_fetchrow($result);
					$this->db->sql_freeresult($result);
						
					$template->assign_vars(array(
						'MAIL_ID'	    => $row['id'],
						'USERNAME_FULL'	=> get_username_string('full', $row['user_id'], $row['username'], $row['user_colour'], $user->lang['GUEST']),
						'SUBJECT'		=> htmlspecialchars_decode($row['subject']),
						'MESSAGE'		=> htmlspecialchars_decode($row['message']),
						'TIME'			=> $user->format_date($row['time']),
						'DISPLAY_IT'	=> ($row['display_it']) ? true : false,
						'U_ACTION'		=> $this->u_action,
						'U_DELETE'		=> $this->u_action . '&amp;action=delete&amp;mail=' . $row['id'],
						'U_BACK'		=> $this->u_action,
					));
					
				} else
				{
					$message = $user->lang['ID_NOT_EXIST'];
					trigger_error($message . adm_back_link($this->u_action), E_USER_WARNING);
				}
			break;
			
			case 'display':
				$sql = 'UPDATE ' . $this->table_newsletter . ' SET display_it = ' . $this->request->variable('display', 0) . ' WHERE id = ' . $mail_id;
				$result = $this->db->sql_query($sql);

			default:
				if ($this->request->is_set_post('submit'))
				{
					if (!check_form_key('acp_email_html'))
					{
						trigger_error('FORM_INVALID');
					}
					$settings = $this->request->variable('newsletter_settings', array('' => ''));
					$forums = $this->request->variable('newsletter_forums', array(0 => 0));
					if ($this->request->variable('compose', 0))
					{
						$sql_ary = array(
							'user_id'			=> $this->user->data['user_id'],
							'username'			=> $this->user->data['username'],
							'user_colour'		=> $this->user->data['user_colour'],
							'subject'			=> utf8_normalize_nfc($this->request->variable('subject', '', true)),
							'message'			=> utf8_normalize_nfc($this->request->variable('message', '', true)),
							'display_it'		=> 1,
							'time'				=> time(),
							'hits'				=> 0
						);
						
						$sql = 'INSERT INTO ' . $this->table_newsletter . ' ' . $this->db->sql_build_array('INSERT', $sql_ary);
						$result = $this->db->sql_query($sql);
						
						$this->helper->send_letter($settings);
					} else
					{
						$this->config->set('newsletter_settings', json_encode($settings));
						$this->config->set('newsletter_forums', json_encode($forums));
						$this->config->set('newsletter_gc', ($settings['period'] > 1) ? 604800 : (604800 * 4));					
					}
					trigger_error($this->user->lang('ACP_NEWSOVERVIEW_' . (($this->request->variable('compose', 0)) ? 'SEND' : 'SAVED')) . adm_back_link($this->u_action));
				}
							
				$config_aray = json_decode($this->config['newsletter_settings'], true);

				$lastsend = 0;
				$sql = 'SELECT * FROM ' . $this->table_newsletter . ' ORDER BY id DESC';
				$result = $this->db->sql_query($sql);
				while ($row = $this->db->sql_fetchrow($result))
				{
					$template->assign_block_vars('mailrow', array(
						'MAIL_ID'	    => $row['id'],
						'USERNAME_FULL'	=> get_username_string('full', $row['user_id'], $row['username'], $row['user_colour'], $user->lang['GUEST']),
						'SUBJECT'		=> htmlspecialchars_decode($row['subject']),
						'TIME'			=> $user->format_date($row['time']),
						'HITS'			=> $row['hits'],
						'DISPLAY_IT'	=> ($row['display_it']) ? true : false,
						'U_VIEW'		=> $this->u_action . '&amp;action=view&amp;mail=' . $row['id'],
						'U_DISPLAY'		=> $this->u_action . '&amp;action=display&amp;mail=' . $row['id'] . '&amp;display='. (($row['display_it']) ? '0' : '1'),
						'U_DELETE'		=> $this->u_action . '&amp;action=delete&amp;mail=' . $row['id']
					));
					$lastsend = ($lastsend < $row['time']) ? $row['time'] : $lastsend;
				}

				$sql = 'SELECT group_id FROM ' . GROUPS_TABLE . " WHERE group_name IN ('BOTS', 'GUESTS')";
				$result = $this->db->sql_query($sql);
				$exclude = array();
				while ($row = $this->db->sql_fetchrow($result))
				{
					$exclude[] = $row['group_id'];
				}
				$this->db->sql_freeresult($result);
		
				$select_list = '<option value="0">' . $this->user->lang['ALL_USERS'] . '</option>';
				$select_list .= group_select_options($config_aray['group'], $exclude);
				
				$mail_priority = array('MAIL_LOW_PRIORITY', 'MAIL_NORMAL_PRIORITY', 'MAIL_HIGH_PRIORITY');
				$s_priority_options = '';
				foreach ($mail_priority as $priority)
				{
					$s_priority_options .= '<option value="' . constant($priority) . '"' . ((constant($priority) == $config_aray['priority']) ? 'selected="selected"': '') . '>' . $this->user->lang[$priority] . '</option>';
				}

				$subscribed = 0;
				$sql = 'SELECT u.user_id, u.username, u.user_email, l.lang_local_name 
						FROM ' . USERS_TABLE . ' u
						LEFT JOIN ' . LANG_TABLE . ' l ON l.lang_iso = u.user_lang
						WHERE user_allow_massemail = 1 ORDER BY username ASC';
				$result = $this->db->sql_query($sql);
				while ($row = $this->db->sql_fetchrow($result))
				{
					$template->assign_block_vars('userrow', array(
						'ID'			=> ++$subscribed,
						'USERNAME'		=> $row['username'],
						'EMAIL'			=> $row['user_email'],
						'LANG'			=> $row['lang_local_name']
					));
				}
		
				$sql = 'SELECT forum_id, forum_name FROM ' . FORUMS_TABLE . ' WHERE forum_type = 1 ORDER BY forum_name';
				$result = $this->db->sql_query($sql);
				$forum_ary = json_decode($this->config['newsletter_forums'], true);
				while ($row = $this->db->sql_fetchrow($result))
				{
					$template->assign_block_vars('forumrows', array(
						'ID'			=> $row['forum_id'],
						'FORUMNAME'		=> $row['forum_name'],
						'SELECTED'		=> (in_array($row['forum_id'], $forum_ary)) ? ' selected="selected"' : '',
					));
				}
				$this->db->sql_freeresult($result);
		
				$enable_html = $phpbb_container->get('ext.manager')->is_enabled('forumhulp/htmlemail');
				$template->assign_vars(array(
					'WARNING_MSG'			=> (sizeof($error)) ? implode('<br />', $error) : '',
					'U_ACTION'				=> $this->u_action,
					'S_GROUP_OPTIONS'		=> $select_list,
					'USERNAMES'				=> $config_aray['usernames'],
					'U_FIND_USERNAME'		=> append_sid("{$this->root_path}memberlist.$this->php_ext", 'mode=searchuser&amp;form=acp_email&amp;field=usernames'),
					'S_PRIORITY_OPTIONS'	=> $s_priority_options,
					'IMMEDIATELY'			=> $config_aray['immediately'],
					'PERIOD'				=> $config_aray['period'],
					'ENABLE_HTML'			=> $enable_html,
					'NEW_USER'				=> $config_aray['newuser'],
					'USE_HTML'				=> ($enable_html && $config_aray['use_html']) ? true : false,
					'LAST_SEND'				=> $this->user->lang('LAST_SEND', $subscribed, $this->user->format_date(max($lastsend, $this->config['newsletter_last_gc'])))
					)
				);
			break;
		}
	}
}
