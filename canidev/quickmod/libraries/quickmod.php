<?php
/**
 * @package cBB QuickMod
 * @version 1.1.6 01/11/2024
 *
 * @copyright (c) 2024 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 */

namespace canidev\quickmod\libraries;

use \Symfony\Component\DependencyInjection\ContainerInterface;
use canidev\core\JsonResponse;

class quickmod
{
	protected $auth;
	protected $cache;
	protected $config;
	protected $container;
	protected $db;
	protected $dispatcher;
	protected $language;
	protected $request;
	protected $template;
	protected $tools;
	protected $user;
	
	protected $phpbb_root_path;
	protected $php_ext;

	protected $categories 	= [];
	protected $tasks 		= null;

	public $forum_id		= false;
	public $active			= false;

	/**
	* Constructor
	*
	* @param \phpbb\auth\auth 						$auth				Authentication object
	* @param \phpbb\cache\driver\driver_interface 	$cache				Cache Driver
	* @param \phpbb\config\config 					$config				Config Object
	* @param ContainerInterface 					$container			Service container interface
	* @param \phpbb\db\driver\driver_interface		$db					DB Object
	* @param \phpbb\event\dispatcher_interface		$dispatcher			Event dispatcher
	* @param \phpbb\language\language 				$language			Language object
	* @param \phpbb\request\request 				$request			Request object
	* @param \canidev\core\template 				$template 			Core Template
	* @param \canidev\core\tools 					$tools 				Core Tools
	* @param \phpbb\user							$user				User object
	* @param string									$root_path			phpBB root path
	* @param string									$php_ext			phpEx
	*
	* @access public
	*/
	public function __construct(
		\phpbb\auth\auth $auth,
		\phpbb\cache\driver\driver_interface $cache,
		\phpbb\config\config $config,
		ContainerInterface $container,
		\phpbb\db\driver\driver_interface $db,
		\phpbb\event\dispatcher_interface $dispatcher,
		\phpbb\language\language $language,
		\phpbb\request\request $request,
		\canidev\core\template $template,
		\canidev\core\tools $tools,
		\phpbb\user $user,
		$root_path,
		$php_ext)
	{
		$this->auth			= $auth;
		$this->cache 		= $cache;
		$this->config 		= $config;
		$this->container	= $container;
		$this->db			= $db;
		$this->dispatcher	= $dispatcher;
		$this->language		= $language;
		$this->request		= $request;
		$this->template		= $template;
		$this->tools 		= $tools;
		$this->user			= $user;
		
		$this->phpbb_root_path	= $root_path;
		$this->php_ext			= $php_ext;
	}
	
	/**
	 * Do initial setup
	 */
	public function setup()
	{
		$this->forum_id = $this->request->variable('f', 0);
		
		$active	= false;

		if($this->phpbb_root_path == './' &&
			preg_match('#^(viewforum|search)(\.' . $this->php_ext . '|/|$)#', $this->user->page['page_name']))
		{
			$active = true;
		}

		$active	= ($active && $this->auth->acl_get('m_', $this->forum_id));

		$categories = [
			'OPTIONS_APPROVE'	=> 'fa-check',
			'OPTIONS_LOCK'		=> 'fa-lock',
			'OPTIONS_REMOVE'	=> 'fa-trash',
			'TOPIC_TYPE'		=> 'fa-thumb-tack',
			'OPTIONS_TOOLS'		=> 'fa-gear',
		];

		/**
		 * @event quickmod.setup
		 * @var array 	categories 	Categories for tasks
		 * @var	bool	active		Status of the extension
		 * @since 1.1.0
		 */
		$vars = ['categories', 'active'];
		extract($this->dispatcher->trigger_event('quickmod.setup', compact($vars)));

		$this->active		= $active;
		$this->categories 	= $categories;
		unset($active, $categories);
		
		if(!$this->active)
		{
			return false;
		}

		$this->get_available_tasks();

		if($this->request->is_ajax() && $this->request->variable('ajaxModule', '') == 'quickmod')
		{
			$this->do_ajax_action();
			exit_handler();
		}

		foreach($this->tasks as $task_id => $task_class)
		{
			if(!class_exists($task_class))
			{
				unset($this->tasks[$task_id]);
				continue;
			}

			$this->tasks[$task_id] = new $task_class($this->container);
		}

		$this->template->append_asset('css', '@canidev_quickmod/quickmod.css');
		$this->template->append_asset('js', '@canidev_quickmod/js/jquickmod.min.js');
	}
	
	/**
	 * Display extension
	 */
	public function display()
	{
		if(!$this->active)
		{
			return;
		}

		$tasks_tree 	= [];
		$quick_options 	= [];
		$i 				= 0;

		foreach($this->tasks as $task_id => $task)
		{
			if($task->category === null)
			{
				continue;
			}

			$categories 	= is_array($task->category) ? $task->category : [$task->category];
			$order 			= $task->order;

			foreach($categories as $category)
			{
				if(!isset($tasks_tree[$category]))
				{
					$tasks_tree[$category] = [];
				}

				if(!isset($tasks_tree[$category][$order]))
				{
					$tasks_tree[$category][$order] = [];
				}

				$tasks_tree[$category][$order][] = $task_id;
			}
		}

		foreach($this->categories as $category_name => $category_icon)
		{
			if(isset($tasks_tree[$category_name]))
			{
				$quick_options['legend_' . $i] = [
					'icon'	=> $category_icon,
					'label'	=> $category_name
				];

				ksort($tasks_tree[$category_name]);

				foreach($tasks_tree[$category_name] as $order => $task_ids)
				{
					foreach($task_ids as $task_id)
					{
						if(!$this->forum_id || $this->auth->acl_gets($this->tasks[$task_id]->permissions, $this->forum_id))
						{
							$quick_options[$task_id] = [
								'icon'	=> $this->tasks[$task_id]->icon,
								'label'	=> $this->tasks[$task_id]->title,
							];
						}
					}
				}
			}

			$i++;
		}
		
		$mark_options = [
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
		];

		add_form_key('quick_mod_form', '_QM');
		
		/**
		 * @event quickmod.display
		 * @var	array	mark_options		Array with options to the mark select
		 * @var	array	quick_options		Array with options to the actions select
		 * @since 1.1.0
		 */
		$vars = ['mark_options', 'quick_options'];
		extract($this->dispatcher->trigger_event('quickmod.display', compact($vars)));

		$this->template->assign_vars([
			'S_QUICKMOD_ENABLED'	=> true,
			'S_QM_MARK_OPTIONS'		=> $this->tools->make_select($mark_options, false, '-1'),
			'S_QM_LAYOUT'			=> $this->config['qm_layout'],
			'S_QM_TYPE'				=> $this->config['qm_type'],

			'S_QM_HIDDEN_FIELDS'	=> build_hidden_fields([
				'f'				=> $this->forum_id
			]),
		]);

		foreach($quick_options as $key => $row)
		{
			if(strpos($key, 'legend') === 0)
			{
				$this->template->assign_block_vars('qm_quick_options', [
					'ICON'		=> $row['icon'],
					'LABEL'		=> $this->language->lang($row['label']),
				]);

				continue;
			}

			$this->template->assign_block_vars('qm_quick_options.action', [
				'ICON'		=> $row['icon'],
				'LABEL'		=> $this->language->lang($row['label']),
				'VALUE'		=> $key,
			]);
		}
	}

	/**
	 * Perform ajax actions
	 */
	protected function do_ajax_action()
	{
		if(!function_exists('move_topics'))
		{
			include($this->phpbb_root_path . 'includes/functions_admin.' . $this->php_ext);
		}
		
		if(!function_exists('phpbb_get_topic_data'))
		{
			include($this->phpbb_root_path . 'includes/functions_mcp.' . $this->php_ext);
		}

		$this->language->add_lang('mcp');

		$action			= $this->request->variable('action', '');
		$topic_ids		= $this->request->variable('topic_id_list', [0]);
		$response 		= \canidev\core\JsonResponse::getInstance();

		$no_authorized_ids = [];
		
		/**
		 * @event quickmod.before_ajax_action
		 * @var	string	action		The current request action
		 * @var	array	topic_ids	List of selected topics
		 * @since 1.1.0
		 */
		$vars = ['action', 'topic_ids'];
		extract($this->dispatcher->trigger_event('quickmod.before_ajax_action', compact($vars)));

		if($action == 'finduser')
		{
			$query			= $this->request->variable('query', '', true);
			$username_clean = utf8_clean_string($query);
			$user_ary 		= [];
			$limit 			= 100;

			// Base query
			$sql_ary = [
				'SELECT'	=> 'u.user_id, u.username, u.user_avatar, u.user_avatar_type, u.user_avatar_width, u.user_avatar_height',
				'FROM'		=> [USERS_TABLE => 'u'],
				'ORDER_BY'	=> 'u.username_clean ASC'
			];
			
			// First, find user that start with search query
			$sql_ary['WHERE'] = $this->db->sql_in_set('user_type', [USER_NORMAL, USER_FOUNDER]) . '
				AND username_clean ' . $this->db->sql_like_expression($username_clean . $this->db->get_any_char());
			$result = $this->db->sql_query_limit($this->db->sql_build_query('SELECT', $sql_ary), $limit);
			while($row = $this->db->sql_fetchrow($result))
			{
				$user_id = (int)$row['user_id'];
				$user_ary[$user_id] = $row;
			}
			$this->db->sql_freeresult($result);

			// Second, find users that contains search query
			$sql_ary['WHERE'] = $this->db->sql_in_set('user_type', [USER_NORMAL, USER_FOUNDER]) . '
				AND username_clean ' . $this->db->sql_like_expression($this->db->get_any_char() . $username_clean . $this->db->get_any_char());
			
			if(count($user_ary))
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
				$this->template->assign_block_vars('user', [
					'S_AVATAR_IMG'			=> phpbb_get_user_avatar($row),
					'S_USERNAME'			=> $row['username'],
					'S_USERNAME_FORMATTED'	=> preg_replace('#(' . preg_quote($query) . ')#i', '<strong>$1</strong>', $row['username'])
				]);
			}
			
			$this->template->assign_vars([
				'S_USERLIST'	=> true
			]);

			$this->template->set_filenames([
				'quickmod' => '@canidev_quickmod/quickmod_ajax.html'
			]);

			$response
				->add([
					'query'		=> $query,
					'results'	=> count($user_ary)
				])
				->addHtml($this->template->assign_display('quickmod'))
				->send();
		}
		else
		{
			if(!isset($this->tasks[$action]) || !check_form_key('quick_mod_form'))
			{
				$response->error($this->language->lang('FORM_INVALID'));
			}

			if(empty($topic_ids))
			{
				$response->error($this->language->lang('NO_TOPIC_SELECTED'));
			}

			$task = new $this->tasks[$action]($this->container);

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
					if(!$this->auth->acl_gets($task->permissions, $row['forum_id']))
					{
						$no_authorized_ids[] = $row['topic_id'];
					}
				}
				$this->db->sql_freeresult($result);
				
				if(count($no_authorized_ids))
				{
					$topic_ids = array_diff($topic_ids, $no_authorized_ids);
					
					if(empty($topic_ids))
					{
						$response->error($this->language->lang('NO_AUTH_OPERATION'));
					}
				}
			}
			else if(!$this->auth->acl_gets($task->permissions, $this->forum_id))
			{
				$response->error($this->language->lang('NO_AUTH_OPERATION'));
			}

			if(!empty($topic_ids) && is_array($topic_ids))
			{
				$response->add([
					'action'	=> $action,
					'reload'	=> true,
					'status'	=> JsonResponse::JSON_STATUS_SUCCESS,
				]);

				$task->set_run_services($this->container);

				if($task->run($topic_ids, $this->forum_id) !== false)
				{
					/**
					 * @event quickmod.after_ajax_action
					 * @var	string									action		The current request action
					 * @var	array									topic_ids	List of selected topics
					 * @var	\canidev\core\JsonResponse 				response 	Core JsonResponse Object
					 * @var \canidev\quickmod\libraries\tasks\base 	task 		Task Object
					 * @since 1.1.0
					 */
					$vars = ['action', 'topic_ids', 'response', 'task'];
					extract($this->dispatcher->trigger_event('quickmod.after_ajax_action', compact($vars)));
					
					$response->send();
				}
			}

			$response->error($this->language->lang('NOTHING'));
		}
	}

	/**
	 * Get available tasks
	 * 
	 * @param bool 	$initialize_tasks
	 * @return array
	 */
	public function get_available_tasks($initialize_tasks = false)
	{
		if($this->tasks === null)
		{
			if(($tasks = $this->cache->get('_quickmod_tasks')) === false)
			{
				$tasks = [];

				$base_path	= $this->phpbb_root_path . 'ext/canidev/quickmod/libraries/tasks/';
				$directory	= new \RecursiveDirectoryIterator($base_path);
				$iterator	= new \RecursiveIteratorIterator($directory);
				$regex		= new \RegexIterator($iterator, '/([a-z0-9_\-]+)\.' . $this->php_ext . '$/i');

				foreach($regex as $file)
				{
					$basename = $file->getBasename('.' . $this->php_ext);

					if($basename == 'base')
					{
						continue;
					}

					$tasks[$basename] = '\\canidev\\quickmod\\libraries\\tasks\\' . $basename;
				}

				$this->cache->put('_quickmod_tasks', $tasks);
			}

			/**
			 * Event to allow task customization
			 * 
			 * @event quickmod.available_tasks
			 * @var array 	tasks 		List of available tasks
			 * @since 1.1.6
			 */
			$vars = ['tasks'];
			extract($this->dispatcher->trigger_event('quickmod.available_tasks', compact($vars)));

			$this->tasks = $tasks;
		}

		if($initialize_tasks)
		{
			foreach($this->tasks as $task_id => $task_class)
			{
				if(!is_string($task_class))
				{
					continue;
				}

				if(!class_exists($task_class))
				{
					unset($this->tasks[$task_id]);
					continue;
				}
	
				$this->tasks[$task_id] = new $task_class($this->container);
			}
		}

		return $this->tasks;
	}

	/**
	 * Get topic row actions
	 * 
	 * @param int 	$forum_id
	 * @param int 	$topic_id
	 * @param int 	$topic_type
	 * @param int 	$topic_status
	 * @param int 	$topic_visibility
	 * 
	 * @return string
	 */
	public function get_row_content($forum_id, $topic_id, $topic_type, $topic_status, $topic_visibility)
	{
		$qm_content 		= '';

		if($this->active)
		{
			$selected_actions = explode(',', $this->config['qm_buttons']);

			$qm_content .= '<div class="quick_mod_buttons cbb-helper-hidden">';

			foreach($selected_actions as $action)
			{
				if(!isset($this->tasks[$action]))
				{
					continue;
				}

				$task = $this->tasks[$action];

				if(!$task->available_on_row($topic_type, $topic_status, $topic_visibility) || 
					!$this->auth->acl_gets($task->permissions, $forum_id))
				{
					continue;
				}

				$qm_content .= '<a href="#" data-action="' . $action . '" title="' . $this->language->lang($task->title) . '"><i class="fa ' . $task->icon . '"></i></a>';
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
			$vars = [
				'qm_content',
				'selected_actions',
				'forum_id',
				'topic_id',
				'topic_type',
				'topic_status',
				'topic_visibility'
			];
			extract($this->dispatcher->trigger_event('quickmod.row_content', compact($vars)));

			$qm_content .= "</div>\n";
			
			$qm_content .= build_hidden_fields([
				'topic_id'			=> $topic_id,
				'topic_type'		=> $topic_type,
				'topic_status'		=> $topic_status,
			]);
		}

		return $qm_content;
	}
}
