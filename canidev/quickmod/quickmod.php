<?php
/*
* @name quickmod.php
* @package cBB QuickMod
* @version 1.1.0 17/01/2017
*
* @copyright (c) 2017 CaniDev
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\quickmod;

// @ignore
if(!defined('IN_PHPBB'))
{
	exit;
}

use Symfony\Component\DependencyInjection\ContainerInterface;

class quickmod
{
	protected $auth;
	protected $config;
	protected $container;
	protected $db;
	protected $dispatcher;
	protected $request;
	protected $template;
	protected $user;
	
	protected $phpbb_root_path;
	protected $php_ext;

	public $actions = array(
		'legend1'				=> 'OPTIONS_BASIC',
		'approve'				=> array('lang' => 'APPROVE',				'auth' => 'm_approve'),
		'delete'				=> array('lang' => 'DELETE',				'auth' => 'm_softdelete'),
		'delete_permanently'	=> array('lang' => 'DELETE_PERMANENTLY',	'auth' => 'm_delete'),
		'restore'				=> array('lang' => 'RESTORE',				'auth' => 'm_approve'),
		'move'					=> array('lang' => 'MOVE',					'auth' => 'm_move'),
		'lock'					=> array('lang' => 'LOCK',					'auth' => 'm_lock'),
		'unlock'				=> array('lang' => 'UNLOCK',				'auth' => 'm_lock'),

		'legend2'			=> 'TOPIC_TYPE',
		'make_normal'		=> array('lang' => 'MAKE_NORMAL',	'auth' => array('f_sticky', 'f_announce')),
		'make_sticky'		=> array('lang' => 'MAKE_STICKY',	'auth' => 'f_sticky'),
		'make_announce'		=> array('lang' => 'MAKE_ANNOUNCE',	'auth' => 'f_announce'),
		'make_global'		=> array('lang' => 'MAKE_GLOBAL',	'auth' => 'f_announce'),

		'legend3'			=> 'OPTIONS_ADVANCED',
		'rename'			=> array('lang' => 'RENAME',		'auth' => 'm_',	'in_list' => false,	'action' => "jQM.quickmod('rename', 'show')"),
		'chgposter'			=> array('lang' => 'CHANGE_POSTER',	'auth' => 'm_chgposter'),
		'chgicon'			=> array('lang' => 'CHANGE_ICON',	'auth' => 'f_icons'),
		'chgtime'			=> array('lang' => 'CHANGE_TIME',	'auth' => 'm_'),
	);
					
	public $forum_id		= false;
	public $active			= false;
	private $topic_count	= 0;
	private $action			= '';

	public function __construct(\phpbb\auth\auth $auth, \phpbb\config\config $config, ContainerInterface $container, \phpbb\db\driver\driver_interface $db, $phpbb_dispatcher, \phpbb\request\request $request, \phpbb\template\template $template, \phpbb\user $user, $root_path, $php_ext)
	{
		$this->auth			= $auth;
		$this->config 		= $config;
		$this->container	= $container;
		$this->db			= $db;
		$this->dispatcher	= $phpbb_dispatcher;
		$this->request		= $request;
		$this->template		= $template;
		$this->user			= $user;
		
		$this->phpbb_root_path	= $root_path;
		$this->php_ext			= $php_ext;
	}
	
	public function setup()
	{
		global $phpbb_hook;

		$active		= ($this->auth->acl_get('m_', $this->forum_id) ? true : false);
		$actions	= $this->actions;
		
		/**
		* Event to setup additional data
		*
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
		
		$phpbb_hook->register('phpbb_user_session_handler', array($this, 'parse_ajax'));
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

		$this->template->assign_vars(array(
			'S_QUICKMOD_ENABLED'	=> true,
			'S_QUICK_OPTIONS'		=> $this->make_select($quick_options, ''),
			'S_QM_MARK_OPTIONS'		=> $this->make_select($mark_options, '-1'),
			
			'S_QM_TYPE'				=> $this->config['qm_type'],
			'S_QM_VERSION'			=> $this->config['qm_version'],
			'T_QUICKMOD_PATH'		=> $this->phpbb_root_path . 'ext/canidev/quickmod/',
			
			'U_QUICK_ACTION'		=> $this->build_current_url(),

			'S_HIDDEN_FIELDS'	=> build_hidden_fields(array(
				'f'				=> $this->forum_id
			)),
		));
		
		$compatibility	= $this->container->get('canidev.quickmod.compatibility.manager');
		
		if(($sources = $compatibility->get_sources()) !== false)
		{
			$this->template->assign_block_vars_array('qm_additional_source', $sources);
		}

		if(trim($js_events_code	= $compatibility->get_js_events()))
		{
			$this->template->assign_var('S_QM_EVENTS', $js_events_code);
		}
		
		/**
		* Event to modify display vars
		*
		* @event quickmod.display
		* @var	array	mark_options		Array with options to the mark select
		* @since 1.1.0
		*/
		$vars = array('mark_options');
		extract($this->dispatcher->trigger_event('quickmod.display', compact($vars)));
		
		$this->set_stylesheet();
	}
	
	public function set_stylesheet()
	{
		$this->template->assign_vars(array(
			'S_QUICKMOD_STYLESHEET'	=> 'phpbb' . str_replace('.', '', substr(PHPBB_VERSION, 0, 3)) . 'x.css',
		));
	}
	
	public function parse_ajax()
	{
		if($this->request->is_set_post('qm_ajax'))
		{
			$this->do_ajax_action();
			exit_handler();
		}
	}

	function do_ajax_action()
	{
		if(!$this->active)
		{
			return false;
		}

		if(!function_exists('move_topics'))
		{
			include($this->phpbb_root_path . 'includes/functions_admin.' . $this->php_ext);
		}

		if(!function_exists('qm_rename_topic'))
		{
			include($this->phpbb_root_path . 'ext/canidev/quickmod/functions.' . $this->php_ext);
		}

		$this->user->add_lang('mcp');
		
		$is_fb	= $this->request->is_set_post('fb');
		$submit = $this->request->is_set_post('submit_action');

		$action			= ($is_fb) ? request_var('a', '') : request_var('quick_mod_action', '');
		$topic_ids		= ($is_fb) ? array(request_var('t', 0)) : request_var('topic_id_list', array(0));

		$message = $new_data = '';
		$no_authorized_ids = array();
		
		/**
		* Event to do some stuff before ajax request
		*
		* @event quickmod.before_ajax_action
		* @var	string	action		The current request action
		* @var	array	topic_ids	List of selected topics
		* @since 1.1.0
		*/
		$vars = array('action', 'topic_ids');
		extract($this->dispatcher->trigger_event('quickmod.before_ajax_action', compact($vars)));
		
		$this->action = $action;

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

		switch($this->action)
		{
			case 'lock':
			case 'unlock':
				if($this->confirm(strtoupper($this->action)))
				{
					$message = qm_lock_unlock($this->action, $topic_ids);
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
					$message = qm_change_topic_type($this->action, $topic_ids, $this->forum_id, $global_involved);
				}
			break;

			case 'move':
				if($submit)
				{
					$message = qm_move_topic($topic_ids, $this->forum_id);
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
					$message = qm_delete_topic($topic_ids, false);
				}
			break;

			case 'delete':
				if($submit)
				{
					$reason		= utf8_normalize_nfc(request_var('delete_reason', '', true));
					$message	= qm_delete_topic($topic_ids, true, $reason);
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
					$message = qm_restore_topic($topic_ids);
				}
			break;

			case 'rename':
				if($this->confirm('RENAME'))
				{
					$message = qm_rename_topic($topic_ids, $new_data);
				}
			break;

			case 'approve':
				if($submit)
				{
					$message = qm_approve_topic($this->action, $topic_ids);
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
					$message = qm_change_poster($topic_ids);
				}
				else
				{
					$this->template->assign_vars(array(
						'MESSAGE_TITLE'		=> $this->user->lang['CHANGE_POSTER'],
						'S_CHGPOSTER'		=> true,
						'U_FIND_USERNAME'	=> append_sid($this->phpbb_root_path . 'memberlist.' . $this->php_ext, 'mode=searchuser&amp;form=quick_mod_form&amp;field=username&amp;select_single=true'),
					));

					$this->send('tpl');
				}
			break;

			case 'chgicon':
				if($submit)
				{
					$message = qm_change_icon($topic_ids);
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
					$message = qm_change_time($topic_ids);
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
						'S_HOUR'			=> sprintf('%d:%d:%d', $now['hours'], $now['minutes'], $now['seconds']),
					));
					
					unset($now);

					$this->send('tpl');
				}
			break;

			default:
			break;
		}
		
		/**
		* Event to do some stuff after ajax request
		*
		* @event quickmod.after_ajax_action
		* @var	string	action		The current request action
		* @var	array	topic_ids	List of selected topics
		* @var	string	message		The output message
		* @since 1.1.0
		*/
		$vars = array('action', 'topic_ids', 'message');
		extract($this->dispatcher->trigger_event('quickmod.after_ajax_action', compact($vars)));

		$message = (is_array($message)) ? $message : array($message, false, $new_data);

		call_user_func_array(array($this, 'send'), $message);
	}
	
	private function build_current_url($is_amp = true)
	{
		$obtain_params 	= array('st' => 0,	'sk' => '',	'sd' => '');
		$strip_params	= array('submit');
		$u_action 		= append_sid(generate_board_url() . '/' . $this->user->page['page'], false, false);

		if(($pos = strpos($u_action, '?')) !== false)
		{
			// Parse url to prevent duplicated variables
			preg_match_all('#[\?|\&](.*?)\=([^\&]+)#i', $u_action, $matches);
			foreach($matches[1] as $id => $key)
			{
				$key = urldecode($key);

				if(strpos($key, '[]') === false)
				{
					$params[$key] = $matches[2][$id];
					continue;
				}
				
				$key = str_replace('[]', '', $key);

				if(empty($params[$key]))
				{
					$params[$key] = array();
				}

				$params[$key][] = $matches[2][$id];
			}
			
			// Obtain extra POST params and add to the url
			foreach($obtain_params as $id => $value)
			{
				if(!isset($params[$id]))
				{
					$params[$id] = request_var($id, $value);
				}
			}
			
			// Delete not allowed or empty params and prepare the values
			foreach($params as $key => $value)
			{
				unset($params[$key]);
				
				if(!in_array($key, $strip_params))
				{
					if(is_array($value))
					{
						foreach($value as $id => $param)
						{
							if($param)
							{
								$subkey = $key . '[' . $id . ']';
								$params[$subkey] = $key . '%5B%5D=' . $param;
							}
						}
					}
					elseif($value)
					{
						$params[$key] = $key . '=' . $value;
					}
				}
			}
			
			$u_action = substr($u_action, 0, $pos);
			
			if(sizeof($params))
			{
				$u_action .= '?' . implode((($is_amp) ? '&amp;' : '&'), array_values($params));
			}
			
			unset($params);
		}
		
		return $u_action;
	}

	public function get_row_content($forum_id, $topic_id, $topic_type, $topic_status, $topic_visibility)
	{
		$qm_content 		= '';
		$topic_unapproved	= (($topic_visibility == ITEM_UNAPPROVED || $topic_visibility == ITEM_REAPPROVE) && $this->auth->acl_get('m_approve', $forum_id));

		if($this->active)
		{
			$selected_actions = explode(',', $this->config['qm_buttons']);

			$qm_content .= '<div class="quick_mod_buttons">';

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
				
				if(!isset($data['action']))
				{
					$data['action'] = "jQM.quickmod('go', this)";
				}

				if($this->auth->acl_gets($data['auth'], $forum_id))
				{
					$qm_content .= '<a href="#" onclick="' . $data['action'] . '; return false;" data-action="' . $action . '" title="' . $this->user->lang[$data['lang'] . '_TOPIC'] . '"><span class="qm-icon-' . $action . '"></span></a>';
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
		$is_confirmed = request_var('confirm', false);
		
		$message = 'CONFIRM_' . $message . '_TOPIC' . (($this->topic_count > 1) ? 'S' : '');
		
		if($this->config['qm_confirm'] && !$is_confirmed && !$submit)
		{
			$this->send(array(
				'msg'	=> (isset($this->user->lang[$message]) ? $this->user->lang[$message] : $message),
				'type'	=> 'confirm',
			));
			
			return false;
		}
		
		return true;
	}

	public function send($message, $error = false, $new_data = '', $template = 'quickmod_ajax.html')
	{
		$in_rename = false;
		
		$json = array(
			'type'		=> 'json'
		);
		
		if(is_array($message))
		{
			$json = array_merge($json, $message);
		}
		else if($message == 'tpl')
		{
			$s_hidden_fields = array();
			$s_fb = 'false';

			if($this->request->is_set_post('fb'))
			{
				$s_fb = 'true';

				$s_hidden_fields = array(
					'fb'	=> 1,
					'a'		=> request_var('a', ''),
					't'		=> request_var('t', 0),
				);
			}

			$this->template->assign_vars(array(
				'DIALOG_CONTENT'		=> true,
				'S_QM_HIDDEN_FIELDS'	=> build_hidden_fields($s_hidden_fields),
				'S_FB'					=> $s_fb,
			));
			
			$json['type'] = 'html';
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

			// Return message in JSON format
			$json += array(
				'action'	=> $this->action,
				'msg'		=> ($in_rename) ? $new_data : $this->user->lang($message),
				'status'	=> ($error) ? 2 : 1,
				'redirect'	=> (!$in_rename) ? $this->build_current_url(false) : '',
			);
		}

		if (!defined('HEADER_INC'))
		{
			$http_headers = array(
				'Content-type' 	=> 'text/html; charset=UTF-8',
				'Cache-Control' => 'private, no-cache="set-cookie"',
				'Expires' 		=> gmdate('D, d M Y H:i:s', time()) . ' GMT',
			);

			if(!empty($this->user->data['is_bot']))
			{
				// Let reverse proxies know we detected a bot.
				$http_headers['X-PHPBB-IS-BOT'] = 'yes';
			}

			foreach($http_headers as $hname => $hval)
			{
				header((string) $hname . ': ' . (string) $hval);
			}
		}
		
		$this->template->assign_var('JSON_RESULT', json_encode($json));

		$this->template->set_filenames(array(
			'quickmod' => $template,
		));

		$this->template->set_style(array('ext/canidev/quickmod/styles'));
		$this->template->display('quickmod');
		
		garbage_collection();
		exit_handler();
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