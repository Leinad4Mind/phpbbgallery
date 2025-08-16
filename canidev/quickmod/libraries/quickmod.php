<?php
/*
* @package cBB QuickMod
* @version v1.1.2 01/03/2020
*
* @copyright (c) 2020 CaniDev
* @license https://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\quickmod\libraries;

// @ignore
if(!defined('IN_PHPBB'))
{
	exit;
}

use canidev\core\json_response;

class quickmod
{
	protected $auth;
	protected $config;
	protected $container;
	protected $db;
	protected $dispatcher;
	protected $language;
	protected $request;
	protected $template;
	protected $user;
	
	protected $phpbb_root_path;
	protected $php_ext;

	public $actions = array(
		'legend1'				=> 'OPTIONS_BASIC',
		'approve'				=> array('lang' => 'APPROVE',				'auth' => 'm_approve',		'icon' => 'fa-check'),
		'delete'				=> array('lang' => 'DELETE',				'auth' => 'm_softdelete',	'icon' => 'fa-trash-o'),
		'delete_permanently'	=> array('lang' => 'DELETE_PERMANENTLY',	'auth' => 'm_delete',		'icon' => 'fa-times'),
		'restore'				=> array('lang' => 'RESTORE',				'auth' => 'm_approve',		'icon' => 'fa-exchange'),
		'move'					=> array('lang' => 'MOVE',					'auth' => 'm_move',			'icon' => 'fa-random'),
		'lock'					=> array('lang' => 'LOCK',					'auth' => 'm_lock',			'icon' => 'fa-lock'),
		'unlock'				=> array('lang' => 'UNLOCK',				'auth' => 'm_lock',			'icon' => 'fa-unlock'),

		'legend2'			=> 'TOPIC_TYPE',
		'make_normal'		=> array('lang' => 'MAKE_NORMAL',	'auth' => array('f_sticky', 'f_announce'),	'icon' => 'fa-file-o'),
		'make_sticky'		=> array('lang' => 'MAKE_STICKY',	'auth' => 'f_sticky',		'icon' => 'fa-thumb-tack'),
		'make_announce'		=> array('lang' => 'MAKE_ANNOUNCE',	'auth' => 'f_announce',		'icon' => 'fa-newspaper-o'),
		'make_global'		=> array('lang' => 'MAKE_GLOBAL',	'auth' => 'f_announce',		'icon' => 'fa-globe'),

		'legend3'			=> 'OPTIONS_ADVANCED',
		'rename'			=> array('lang' => 'RENAME',		'auth' => 'm_',				'icon' => 'fa-pencil-square-o',	'in_list' => false),
		'chgposter'			=> array('lang' => 'CHANGE_POSTER',	'auth' => 'm_chgposter',	'icon' => 'fa-user'),
		'chgicon'			=> array('lang' => 'CHANGE_ICON',	'auth' => 'f_icons',		'icon' => 'fa-picture-o'),
		'chgtime'			=> array('lang' => 'CHANGE_TIME',	'auth' => 'm_',				'icon' => 'fa-clock-o'),
	);

	public $forum_id		= false;
	public $active			= false;
	private $topic_count	= 0;
	private $action			= '';
	private $topic_ids		= array();

	/**
	* Constructor
	*
	* @param \phpbb\auth\auth 						$auth				Authentication object
	* @param \phpbb\config\config 					$config				Config Object
	* @param ContainerInterface 					$container			Service container interface
	* @param \phpbb\db\driver\driver_interface		$db					DB Object
	* @param \phpbb\event\dispatcher_interface		$dispatcher			Event dispatcher
	* @param \phpbb\language\language 				$language			Language object
	* @param \phpbb\request\request 				$request			Request object
	* @param \phpbb\user							$user				User object
	* @param string									$root_path			phpBB root path
	* @param string									$php_ext			phpEx
	*
	* @access public
	*/
	public function __construct(
		\phpbb\auth\auth $auth,
		\phpbb\config\config $config,
		\Symfony\Component\DependencyInjection\ContainerInterface $container,
		\phpbb\db\driver\driver_interface $db,
		\phpbb\event\dispatcher_interface $dispatcher,
		\phpbb\language\language $language,
		\phpbb\request\request $request,
		\phpbb\user $user,
		$root_path,
		$php_ext)
	{
		$this->auth			= $auth;
		$this->config 		= $config;
		$this->container	= $container;
		$this->db			= $db;
		$this->dispatcher	= $dispatcher;
		$this->lang			= $language;
		$this->request		= $request;
		$this->template		= \canidev\core\template::get_instance($container);
		$this->user			= $user;
		
		$this->phpbb_root_path	= $root_path;
		$this->php_ext			= $php_ext;
	}
	
	public function setup()
	{
		$this->forum_id = $this->request->variable('f', 0);
		
		$active			= false;
		$mod_pages		= array('viewforum', 'search', 'viewforum.' . $this->php_ext, 'search.' . $this->php_ext);

		if($this->phpbb_root_path == './' && in_array($this->user->page['page_name'], $mod_pages))
		{
			$active = true;
		}

		$active		= ($active && $this->auth->acl_get('m_', $this->forum_id));
		$actions	= $this->actions;
		
		/**
		* @event quickmod.setup
		* @var	array	actions		Array with all allowed actions
		* @var	bool	active		Status of the extension
		* @since 1.1.0
		*/
		$vars = array('actions', 'active');
		extract($this->dispatcher->trigger_event('quickmod.setup', compact($vars)));
		
		$this->actions	= $actions;
		$this->active	= $active;
		unset($actions, $active);
		
		if(!$this->active)
		{
			return false;
		}
		
		if($this->request->is_ajax() && $this->request->variable('ajaxModule', '') == 'quickmod')
		{
			$this->do_ajax_action();
			exit_handler();
		}

		$this->template->append_asset('css', '@canidev_quickmod/../theme/quickmod.css');
		$this->template->append_asset('js', '@canidev_quickmod/js/jquickmod.min.js');
	}
	
	public function display()
	{
		if(!$this->active)
		{
			return false;
		}

		$quick_options = array('' => 'SELECT_ACTION');

		foreach($this->actions as $action => $data)
		{
			if(strpos($action, 'legend') !== false)
			{
				$quick_options[$action] = $data;
				continue;
			}
			
			if(isset($data['in_list']) && !$data['in_list'])
			{
				continue;
			}

			if(!$this->forum_id || $this->auth->acl_gets($data['auth'], $this->forum_id))
			{
				$quick_options[$action] = $data['lang'] . '_TOPIC';
			}
		}
		
		$mark_options = array(
			'-1'		=> 'MARK_TOPICS',

			'legend1'	=> 'MARK_GENERAL',
				'all'		=> 'MARK_ALL',
				'none'		=> 'UNMARK_ALL',
			
			'legend2'	=> 'MARK_BY_STATUS',
				'status-' . ITEM_LOCKED		=> 'MARK_LOCKED',
				'status-' . ITEM_UNLOCKED	=> 'MARK_UNLOCKED',
				'status-' . ITEM_MOVED		=> 'MARK_MOVED',
			
			'legend3'	=> 'MARK_BY_TYPE',
				'type-' . POST_NORMAL	=> 'MARK_NORMAL',
				'type-' . POST_STICKY	=> 'MARK_STICKY',
				'type-' . POST_ANNOUNCE	=> 'MARK_ANNOUNCE',
				'type-' . POST_GLOBAL	=> 'MARK_GLOBAL',
		);

		add_form_key('quick_mod_form');
		
		/**
		* @event quickmod.display
		* @var	array	mark_options		Array with options to the mark select
		* @var	array	quick_options		Array with options to the actions select
		* @since 1.1.0
		*/
		$vars = array('mark_options', 'quick_options');
		extract($this->dispatcher->trigger_event('quickmod.display', compact($vars)));

		$this->template->assign_vars(array(
			'S_QUICKMOD_ENABLED'	=> true,
			'S_QUICK_OPTIONS'		=> $this->make_select($quick_options, ''),
			'S_QM_MARK_OPTIONS'		=> $this->make_select($mark_options, '-1'),
			'S_QM_TYPE'				=> $this->config['qm_type'],

			'S_HIDDEN_FIELDS'	=> build_hidden_fields(array(
				'f'				=> $this->forum_id
			)),
		));
	}

	function do_ajax_action()
	{
		if(!$this->active)
		{
			return false;
		}

		$this->user->add_lang('mcp');
		
		$submit 		= $this->request->is_set_post('submit');
		$action			= $this->request->variable('action', '');
		$topic_ids		= $this->request->variable('topic_id_list', array(0));
		$functions 		= $this->container->get('canidev.quickmod.functions');

		$message = $new_data = '';
		$no_authorized_ids = array();
		
		/**
		* @event quickmod.before_ajax_action
		* @var	string	action		The current request action
		* @var	array	topic_ids	List of selected topics
		* @since 1.1.0
		*/
		$vars = array('action', 'topic_ids');
		extract($this->dispatcher->trigger_event('quickmod.before_ajax_action', compact($vars)));
		
		$this->action 		= $action;
		$this->topic_ids	= $topic_ids;

		if($this->action != 'finduser')
		{
			if(!isset($this->actions[$this->action]) || !check_form_key('quick_mod_form'))
			{
				$this->send('FORM_INVALID', true);
			}

			if(empty($topic_ids))
			{
				$this->send('NO_TOPIC_SELECTED', true);
			}

			$this->topic_count = sizeof($topic_ids);

			/* If no general forum present, determine each forum individually */
			if(!$this->forum_id)
			{
				$sql = 'SELECT topic_id, forum_id
					FROM ' . TOPICS_TABLE . '
					WHERE ' . $this->db->sql_in_set('topic_id', $topic_ids) . '
					AND forum_id <> 0';
				$result = $this->db->sql_query($sql);
				while($row = $this->db->sql_fetchrow($result))
				{
					if(!$this->auth->acl_gets($this->actions[$this->action]['auth'], $row['forum_id']))
					{
						$no_authorized_ids[] = $row['topic_id'];
					}
				}
				$this->db->sql_freeresult($result);
				
				if(sizeof($no_authorized_ids))
				{
					$topic_ids = array_diff($topic_ids, $no_authorized_ids);
					
					if(empty($topic_ids))
					{
						$this->send('NO_AUTH_OPERATION', true);
					}
				}
			}
			else if(!$this->auth->acl_gets($this->actions[$this->action]['auth'], $this->forum_id))
			{
				$this->send('NO_AUTH_OPERATION', true);
			}
		}

		switch($this->action)
		{
			case 'lock':
			case 'unlock':
				if($this->confirm(strtoupper($this->action)))
				{
					$message = $functions->lock_unlock($this->action, $topic_ids);
				}
			break;

			case 'make_announce':
			case 'make_sticky':
			case 'make_global':
			case 'make_normal':
				// Global topic involved?
				$global_involved = false;

				$sql = 'SELECT forum_id
					FROM ' . TOPICS_TABLE . '
					WHERE ' . $this->db->sql_in_set('topic_id', $topic_ids) . '
						AND forum_id = 0';
				$result = $this->db->sql_query($sql);
				$row = $this->db->sql_fetchrow($result);
				$this->db->sql_freeresult($result);

				if($row)
				{
					$global_involved = true;
				}

				if(!$submit && !$this->forum_id && $this->action != 'make_global' && $global_involved)
				{
					$this->template->assign_vars(array(
						'MESSAGE_TITLE'		=> $this->user->lang('FORUM_SELECT'),
						'S_FORUM_REQUEST'	=> true,
						'S_FORUM_SELECT'	=> make_forum_select(false, false, false, true, true, true),
					));

					$this->send('tpl');
				}
				else if($this->confirm('CHANGE', $submit))
				{
					$message = $functions->change_topic_type($this->action, $topic_ids, $this->forum_id, $global_involved);
				}
			break;

			case 'move':
				if($submit)
				{
					$message = $functions->move_topic($topic_ids, $this->forum_id);
				}
				else
				{
					$this->template->assign_vars(array(
						'MESSAGE_TITLE'		=> $this->user->lang['MOVE_TOPIC'],
						'S_FORUM_REQUEST'	=> true,
						'S_CAN_LEAVE'		=> ($this->forum_id) ? true : false,
						'S_FORUM_SELECT'	=> make_forum_select(false, $this->forum_id, false, true, true, true),
					));

					$this->send('tpl');
				}
			break;

			case 'delete_permanently':
				if($this->confirm('DELETE'))
				{
					$message = $functions->delete_topic($topic_ids, false);
				}
			break;

			case 'delete':
				if($submit)
				{
					$reason		= utf8_normalize_nfc(request_var('delete_reason', '', true));
					$message	= $functions->delete_topic($topic_ids, true, $reason);
				}
				else
				{
					$this->template->assign_vars(array(
						'MESSAGE_TITLE'		=> $this->user->lang['DELETE_TOPIC'],
						'S_DELETE'			=> true,
					));

					$this->send('tpl');
				}
			break;

			case 'restore':
				if($this->confirm('RESTORE'))
				{
					$message = $functions->restore_topic($topic_ids);
				}
			break;

			case 'rename':
				if($this->confirm('RENAME'))
				{
					$message = $functions->rename_topic($topic_ids, $new_data);
				}
			break;

			case 'approve':
				if($submit)
				{
					$message = $functions->approve_topic($this->action, $topic_ids);
				}
				else
				{
					$this->template->assign_vars(array(
						'MESSAGE_TITLE'		=> $this->user->lang['APPROVE_TOPIC'],
						'S_APPROVE'			=> true,
					));

					$this->send('tpl');
				}
			break;

			case 'chgposter':
				if($submit)
				{
					$message = $functions->change_poster($topic_ids);
				}
				else
				{
					$this->template->assign_vars(array(
						'MESSAGE_TITLE'		=> $this->user->lang['CHANGE_POSTER'],
						'S_CHGPOSTER'		=> true,
						'U_FIND_USERNAME'	=> append_sid($this->phpbb_root_path . 'memberlist.' . $this->php_ext, 'mode=searchuser&amp;form=qm-dialog-form&amp;field=username&amp;select_single=true'),
					));

					$this->send('tpl');
				}
			break;

			case 'chgicon':
				if($submit)
				{
					$message = $functions->change_icon($topic_ids);
				}
				else
				{
					if(!function_exists('posting_gen_topic_icons'))
					{
						include($this->phpbb_root_path . 'includes/functions_posting.' . $this->php_ext);
					}
					
					$this->template->assign_vars(array(
						'MESSAGE_TITLE'		=> $this->user->lang['CHANGE_ICON'],
						'S_CHGICON'			=> true,
					));
					
					posting_gen_topic_icons('edit', 0);

					$this->send('tpl');
				}
			break;

			case 'chgtime':
				if($submit)
				{
					$message = $functions->change_time($topic_ids);
				}
				else
				{
					$month_names = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');

					$s_day_options = $s_month_options = $s_year_options = '';

					$time = $this->user->create_datetime();
					$now = phpbb_gmgetdate($time->getTimestamp() + $time->getOffset());

					for ($i = 1; $i < 32; $i++)
					{
						$selected = ($i == $now['mday']) ? ' selected="selected"' : '';
						$s_day_options .= "<option value=\"$i\"$selected>$i</option>";
						
						if($i < 13)
						{
							$month_name = $this->user->lang['datetime'][$month_names[$i-1]];

							$selected = ($i == $now['mon']) ? ' selected="selected"' : '';
							$s_month_options .= "<option value=\"$i\"$selected>$month_name</option>";
						}
					}

					for ($i = $now['year'] - 100; $i <= $now['year']; $i++)
					{
						$selected = ($i == $now['year']) ? ' selected="selected"' : '';
						$s_year_options .= "<option value=\"$i\"$selected>$i</option>";
					}

					$this->template->assign_vars(array(
						'MESSAGE_TITLE'		=> $this->user->lang['CHANGE_TIME_TOPIC'],
						'S_CHGTIME'			=> true,
						
						'S_DAY_OPTIONS'		=> $s_day_options,
						'S_MONTH_OPTIONS'	=> $s_month_options,
						'S_YEAR_OPTIONS'	=> $s_year_options,
						'S_HOUR'			=> sprintf('%02d:%02d', $now['hours'], $now['minutes']),
					));
					
					unset($now);

					$this->send('tpl');
				}
			break;
			
			case 'finduser':
				$query			= $this->request->variable('query', '', true);
				$username_clean = utf8_clean_string($query);
				$user_ary 		= array();
				$limit 			= 100;

				// Base query
				$sql_ary = array(
					'SELECT'	=> 'u.user_id, u.username, u.user_avatar, u.user_avatar_type, u.user_avatar_width, u.user_avatar_height',
					'FROM'		=> array(USERS_TABLE => 'u'),
					'ORDER_BY'	=> 'u.username_clean ASC'
				);
				
				// First, find user that start with search query
				$sql_ary['WHERE'] = $this->db->sql_in_set('user_type', array(USER_NORMAL, USER_FOUNDER)) . '
					AND username_clean ' . $this->db->sql_like_expression($username_clean . $this->db->get_any_char());
				$result = $this->db->sql_query_limit($this->db->sql_build_query('SELECT', $sql_ary), $limit);
				while($row = $this->db->sql_fetchrow($result))
				{
					$user_id = (int)$row['user_id'];
					$user_ary[$user_id] = $row;
				}
				$this->db->sql_freeresult($result);

				// Second, find users that contains search query
				$sql_ary['WHERE'] = $this->db->sql_in_set('user_type', array(USER_NORMAL, USER_FOUNDER)) . '
					AND username_clean ' . $this->db->sql_like_expression($this->db->get_any_char() . $username_clean . $this->db->get_any_char());
				
				if(sizeof($user_ary))
				{
					$sql_ary['WHERE'] .= ' AND ' . $this->db->sql_in_set('u.user_id', array_keys($user_ary), true);
				}

				$result = $this->db->sql_query_limit($this->db->sql_build_query('SELECT', $sql_ary), $limit);
				while($row = $this->db->sql_fetchrow($result))
				{
					$user_id = (int)$row['user_id'];
					$user_ary[$user_id] = $row;
				}
				$this->db->sql_freeresult($result);

				$user_ary = array_slice($user_ary, 0, $limit, true);

				foreach($user_ary as $row)
				{
					$this->template->assign_block_vars('user', array(
						'S_AVATAR_IMG'			=> phpbb_get_user_avatar($row),
						'S_USERNAME'			=> $row['username'],
						'S_USERNAME_FORMATTED'	=> preg_replace('#(' . preg_quote($query) . ')#i', '<strong>$1</strong>', $row['username'])
					));
				}
				
				$this->template->assign_vars(array(
					'S_USERLIST'	=> true
				));

				$message = array(
					array(
						'query'		=> $query,
						'results'	=> sizeof($user_ary)
					)
				);
			break;

			default:
			break;
		}
		
		/**
		* @event quickmod.after_ajax_action
		* @var	string	action		The current request action
		* @var	array	topic_ids	List of selected topics
		* @var	string	message		The output message
		* @var	string	new_data	New value (for topic rename)
		* @since 1.1.0
		*/
		$vars = array('action', 'topic_ids', 'message', 'new_data');
		extract($this->dispatcher->trigger_event('quickmod.after_ajax_action', compact($vars)));

		$message = (is_array($message)) ? $message : array($message, false, $new_data);

		call_user_func_array(array($this, 'send'), $message);
	}

	public function get_row_content($forum_id, $topic_id, $topic_type, $topic_status, $topic_visibility)
	{
		$qm_content 		= '';
		$topic_unapproved	= (($topic_visibility == ITEM_UNAPPROVED || $topic_visibility == ITEM_REAPPROVE) && $this->auth->acl_get('m_approve', $forum_id));

		if($this->active)
		{
			$selected_actions = explode(',', $this->config['qm_buttons']);

			$qm_content .= '<div class="quick_mod_buttons cbb-helper-hidden">';

			foreach($selected_actions as $action)
			{
				if(!isset($this->actions[$action]))
				{
					continue;
				}

				$data = $this->actions[$action];
				
				if(isset($data['in_button']) && !$data['in_button'])
				{
					continue;
				}

				if(($topic_type == POST_NORMAL && $action == 'make_normal') ||
					($topic_type == POST_STICKY && $action == 'make_sticky') ||
					($topic_type == POST_ANNOUNCE && $action == 'make_announce') ||
					($topic_type == POST_GLOBAL && $action == 'make_global') ||
					($topic_status == ITEM_LOCKED && $action == 'lock') ||
					($topic_status == ITEM_UNLOCKED && $action == 'unlock') ||
					(!$topic_unapproved && $action == 'approve') ||
					($topic_status == ITEM_MOVED && $action != 'rename' && $action != 'delete_permanently') ||
					($topic_visibility == ITEM_DELETED && $action == 'delete') ||
					($topic_visibility != ITEM_DELETED && $action == 'restore'))
				{
					continue;
				}

				if($this->auth->acl_gets($data['auth'], $forum_id))
				{
					$qm_content .= '<a href="#" data-action="' . $action . '" title="' . $this->user->lang[$data['lang'] . '_TOPIC'] . '"><i class="fa ' . $data['icon'] . '"></i></a>';
				}
			}
			
			/**
			* Event to add content in the topic rows
			*
			* @event quickmod.row_content
			* @var	string	qm_content			The output string included in the row
			* @var	array	selected_actions	List of actions to be applied
			* @var	int		forum_id			Current forum ID
			* @var	int		topic_id			Current topic ID
			* @var	int		topic_type			Current topic type
			* @var	int		topic_status		Current topic status
			* @var	int		topic_visibility	Current topic visibility
			* @since 1.1.0
			*/
			$vars = array(
				'qm_content',
				'selected_actions',
				'forum_id',
				'topic_id',
				'topic_type',
				'topic_status',
				'topic_visibility'
			);
			extract($this->dispatcher->trigger_event('quickmod.row_content', compact($vars)));

			$qm_content .= "</div>\n";
			
			$qm_content .= build_hidden_fields(array(
				'topic_id'			=> $topic_id,
				'topic_type'		=> $topic_type,
				'topic_status'		=> $topic_status,
			));
		}

		return $qm_content;
	}
	
	public function confirm($message, $submit = false)
	{
		$message = 'CONFIRM_' . $message . '_TOPIC' . (($this->topic_count > 1) ? 'S' : '');

		if(!$this->config['qm_confirm'] || confirm_box(true))
		{
			return true;
		}

		confirm_box(
			false,
			$this->lang->lang($message),
			'',
			'@canidev_core/confirmbox.html'
		);
		
		return false;
	}

	public function send($message, $error = false, $new_data = '', $template = '@canidev_quickmod/quickmod_ajax.html')
	{
		$in_rename = false;
		
		$json = array(
			'status'	=> json_response::JSON_STATUS_SUCCESS,
		);
		
		if(is_array($message))
		{
			$json = array_merge($json, $message);
		}
		else if($message == 'tpl')
		{
			$s_hidden_fields = array(
				'action'			=> $this->action,
				'topic_id_list'		=> $this->topic_ids,
			);

			$this->template->assign_vars(array(
				'DIALOG_CONTENT'		=> true,
				'S_QM_HIDDEN_FIELDS'	=> build_hidden_fields($s_hidden_fields),
			));
		}
		else
		{
			if(!$message || $message === false)
			{
				$message = 'NOTHING';
				$error = true;
			}

			if($message == 'TOPIC_RENAMED_SUCCESS')
			{
				$in_rename = true;
			}

			$json = array_merge($json, array(
				'action'	=> $this->action,
				'msg'		=> ($in_rename) ? $new_data : $this->user->lang($message),
				'reload'	=> !$in_rename,
				'status'	=> ($error) ? json_response::JSON_STATUS_ERROR : json_response::JSON_STATUS_SUCCESS,
			));
		}
		
		$this->template->set_filenames(array(
			'quickmod' => $template
		));
		
		$response = new json_response;
		
		$response
			->add($json)
			->add_html($this->template->assign_display('quickmod'))
			->send();
	}
	
	public function make_select($options, $select = false, $parse_lang = true, $empty_label = false)
	{
		$string = '';
		
		$in_group = false;

		foreach($options as $value => $lang)
		{
			$title		= (($parse_lang && isset($this->user->lang[$lang])) ? $this->user->lang[$lang] : $lang);

			if(strpos($value, 'legend') !== false)
			{
				$string .= (($in_group) ? '</optgroup>' : '') . '<optgroup label="' . $title . '">';
				$in_group = true;
				
				continue;
			}

			$selected	= (($value == $select) ? ' selected="selected"' : '');
			$string .= '<option value="' . $value . '"' . $selected . '>' . $title . '</option>';
		}
		
		if($in_group)
		{
			$string .= '</optgroup>';
		}
		
		if(!$string && $empty_label !== false)
		{
			$string = '<option value="0">' . (isset($this->user->lang[$empty_label]) ? $this->user->lang[$empty_label] : $empty_label) . '</option>';
		}

		return $string;
	}
}