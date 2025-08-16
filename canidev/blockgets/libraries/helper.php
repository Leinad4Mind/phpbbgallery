<?php
/**
 * @package cBB Blockgets
 * @version 2.0.5 15/01/2023
 *
 * @copyright (c) 2023 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 */

namespace canidev\blockgets\libraries;

use \Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RequestContext;

class helper
{
	protected $auth;
	protected $config;
	protected $container;
	protected $db;
	protected $filesystem;
	protected $language;
	protected $path;
	protected $request;
	protected $router;
	protected $symfony_request;
	protected $template;
	protected $user;

	protected $phpbb_root_path;
	protected $php_ext;

	protected $media = null;
	
	public $json;
	
	/**
	 * Constructor
	 *
	 * @param \phpbb\auth\auth 							$auth				Authentication object
	 * @param \phpbb\config\config 						$config				Config Object
	 * @param ContainerInterface 						$container			Service container interface
	 * @param \phpbb\db\driver\driver_interface			$db					DB Object
	 * @param \phpbb\filesystem\filesystem				$filesystem			Filesystem Object
	 * @param \phpbb\language\language					$language			Language Object
	 * @param \phpbb\path_helper						$path_helper		Path Helper Object
	 * @param \phpbb\request\request 					$request			Request object
	 * @param \phpbb\symfony_request					$symfony_request	Symfony Request
	 * @param \phpbb\template\template					$template     		Template object
	 * @param \phpbb\user								$user				User object
	 *
	 * @access public
	 */
	public function __construct(
		\phpbb\auth\auth $auth,
		\phpbb\config\config $config,
		ContainerInterface $container,
		\phpbb\db\driver\driver_interface $db,
		\phpbb\filesystem\filesystem $filesystem,
		\phpbb\language\language $language,
		\phpbb\path_helper $path_helper,
		\phpbb\request\request $request,
		\phpbb\symfony_request $symfony_request,
		\phpbb\template\template $template,
		\phpbb\user $user)
	{
		$this->auth				= $auth;
		$this->config			= $config;
		$this->container		= $container;
		$this->db				= $db;
		$this->filesystem 		= $filesystem;
		$this->json				= \canidev\core\json_response::get_instance();
		$this->language			= $language;
		$this->path				= $path_helper;
		$this->request			= $request;
		$this->symfony_request	= $symfony_request;
		$this->template			= $template;
		$this->user				= $user;
		
		$this->phpbb_root_path	= $path_helper->get_phpbb_root_path();
		$this->php_ext			= $path_helper->get_php_ext();
	}
	
	/**
	 * Get a relative root path from the current URL
	 * @return string
	 */
	public function get_web_root_path()
	{
		return $this->path->get_web_root_path();
	}

	/**
	 * Create short date from the user date format to use in blocks
	 *
	 * @param int	$time 				The time point number
	 * @param bool	$allow_timezone 	Define if use the user timezone or not
	 * 
	 * @return string
	*/
	public function format_short_date($time, $allow_timezone = true)
	{
		$format = preg_replace('#[aABgGhHisueIOPTZcrU,\|:]+#', '', $this->user->data['user_dateformat']);

		if(!$allow_timezone)
		{
			return strtr(date($format, $time), array_filter($this->language->lang_raw('datetime'), 'is_string'));
		}

		return $this->user->format_date($time, $format);
	}

	/**
	 * Check if user has permissions, based on groups
	 * 
	 * @param array|string 		$groups 	Valid Group's IDs
	 * @return bool
	 */
	public function group_auth($groups)
	{
		return $this->container->get('canidev.core.lib')->group_auth($groups);
	}
	
	/**
	 * Queries the session table to get information about today visits
	 *
	 * @return array An array containing the ids of today visits, hidden and visible users, as well as statistical info
	 */
	public function obtain_today_visits()
	{
		$user_list = [];

		$today_users = [
			'lastvisit_users'	=> '',
			'userlist'			=> '',
			'total_today'		=> 0,
			'visible_today'		=> 0,
			'hidden_today'		=> 0,
			'guests_today'		=> 0,

			'hidden_online'		=> 0,
		];

		// Get the last visit guests
		$sql = 'SELECT COUNT(DISTINCT s.session_ip) as guest_count
			FROM ' . SESSIONS_TABLE . ' s
			WHERE s.session_user_id = ' . ANONYMOUS . '
			AND s.session_last_visit > ' . strtotime('-1 day');
		$result = $this->db->sql_query($sql, 600); // cache the sql during 10 minutes
		$today_users['guests_today'] = $this->db->sql_fetchfield('guest_count');
		$this->db->sql_freeresult($result);

		// Get the last visit users
		$sql = 'SELECT username, username_clean, user_id, user_type, user_allow_viewonline, user_colour, user_lastvisit
			FROM ' . USERS_TABLE . '
			WHERE user_lastvisit > ' . strtotime('-1 day') . '
			AND user_id <> ' . ANONYMOUS . '
			ORDER BY username_clean ASC';
		$result = $this->db->sql_query($sql, 600); // cache the sql during 10 minutes
		while($row = $this->db->sql_fetchrow($result))
		{
			if($row['user_allow_viewonline'])
			{
				$today_users['visible_today']++;
			}
			else
			{
				$row['username'] = '<em>' . $row['username'] . '</em>';
				$today_users['hidden_online']++;
			}

			if($row['user_allow_viewonline'] || $this->auth->acl_get('u_viewonline'))
			{
				$user_list[] = get_username_string(($row['user_type'] <> USER_IGNORE) ? 'full' : 'no_profile', $row['user_id'], $row['username'], $row['user_colour']);
			}
		}
		$this->db->sql_freeresult($result);

		if(!empty($user_list))
		{
			$today_users['userlist'] = $this->language->lang('REGISTERED_USERS') . ' ' . implode(', ', $user_list);
		}
		unset($user_list);

		$today_users['total_today'] = $today_users['guests_today'] + $today_users['visible_today'] + $today_users['hidden_today'];

		// Build online listing
		$vars_lastvisit = [
			'LASTVISIT'	=> 'total_today',
			'REG'		=> 'visible_today',
			'HIDDEN'	=> 'hidden_today',
			'GUEST'		=> 'guests_today',
		];

		foreach($vars_lastvisit as $v_prefix => $var)
		{
			$today_users['lastvisit_users'] .= $this->language->lang($v_prefix . (($today_users[$var] == 1) ? '_VISIT_TOTAL' : '_VISITS_TOTAL'), $today_users[$var]);
		}
		unset($vars_lastvisit);

		return $today_users;
	}
	
	/**
	 * Get correct image filename
	 * 
	 * @param string 		$image 			Image filename
	 * @param bool 			$full_url 		Set if must return a complete URL
	 * 
	 * @return string
	 */
	public function build_image_filename($image, $full_url = false)
	{
		return $this->get_media(false)->get_full_path($image, $full_url);
	}
	
	/**
	 * Get the local lang code from user lang code
	 *
	 * @param string			$lang_name 		The lang iso name to find or '_get' param to only load the files
	 * @param string			$type 			(iso|name|name_eng). The type of data to proccess
	 * @return string|array 					Returns the locale lang or the default lang if not exists.
	 */
	public function locale_lang($lang_name = false, $type = false)
	{
		static $blg_lang_locale;
		
		if(empty($blg_lang_locale))
		{
			include($this->get_ext_path() . 'libraries/lang_locale.' . $this->php_ext);
		}

		$lang_name = (!$lang_name) ? $this->user->lang_name : $lang_name;

		if($lang_name == 'raw')
		{
			return $blg_lang_locale;
		}

		if($type === false)
		{
			return isset($blg_lang_locale[$lang_name]) ? $blg_lang_locale[$lang_name] : [];
		}

		return isset($blg_lang_locale[$lang_name][$type]) ? $blg_lang_locale[$lang_name][$type] : '';
	}
	
	/**
	 * Get extension path
	 * 
	 * @param bool 		$correct_path 		Set if path must be corrected (for public urls)
	 * @return string
	 */
	public function get_ext_path($correct_path = false)
	{
		$ext_path = str_replace(['\libraries', '\\'], ['', '/'], __NAMESPACE__);
		return (($correct_path) ? $this->path->get_web_root_path() : $this->phpbb_root_path) . 'ext/' . $ext_path . '/';
	}
	
	/**
	 * Generate a URL to a route
	 *
	 * @param string			$route				Name of the route to travel
	 * @param array				$params				String or array of additional url parameters
	 * @param bool				$is_amp				Is url using &amp; (true) or & (false)
	 * @param string|bool		$session_id			Possibility to use a custom session id instead of the global one
	 * @param bool|string		$reference_type 	The type of reference to be generated (one of the constants)
	 * 
	 * @return string 								The URL already passed through append_sid()
	 */
	public function route($route, array $params = [], $is_amp = true, $session_id = false, $absolute_url = false)
	{
		$protocol		= ($this->request->is_secure()) ? 'https://' : 'http://';
		$reference_type = ($absolute_url) ? UrlGeneratorInterface::ABSOLUTE_URL : UrlGeneratorInterface::ABSOLUTE_PATH;
		$anchor			= '';
		
		if(isset($params['#']))
		{
			$anchor = '#' . $params['#'];
			unset($params['#']);
		}

		// Simple way to return home url
		if($route == 'canidev_blockgets_controller' && $this->config['blg_home_type'] == constants::TYPE_DOMAIN_HOME)
		{
			return append_sid($protocol . $this->user->host . '/', $params, $is_amp, $session_id, true);
		}

		$context = new RequestContext();
		$context->fromRequest($this->symfony_request);

		if($this->config['force_server_vars'])
		{
			$context->setHost($this->config['server_name']);
			$context->setScheme(substr($this->config['server_protocol'], 0, -3));
			$context->setHttpPort($this->config['server_port']);
			$context->setHttpsPort($this->config['server_port']);
			$context->setBaseUrl(rtrim($this->config['script_path'], '/'));
		}

		$script_name	= $this->symfony_request->getScriptName();
		$page_name		= substr($script_name, -1, 1) == '/' ? '' : utf8_basename($script_name);

		$base_url = $context->getBaseUrl();

		// Append page name if base URL does not contain it
		if (!empty($page_name) && strpos($base_url, '/' . $page_name) === false)
		{
			$base_url .= '/' . $page_name;
		}

		$rewrite_enabled = !empty($this->config['enable_mod_rewrite']) || !empty($this->config['blg_rewrite']);

		// If enable_mod_rewrite is false we need to replace the current front-end by app.php, otherwise we need to remove it.
		$base_url = str_replace('/' . $page_name, (!$rewrite_enabled) ? '/app.' . $this->php_ext : '', $base_url);

		// We need to update the base url to move to the directory of the app.php file if the current script is not app.php
		if ($page_name !== 'app.php' && !$this->config['force_server_vars'])
		{
			if (!$rewrite_enabled)
			{
				$base_url = str_replace('/app.' . $this->php_ext, '/' . $this->phpbb_root_path . 'app.' . $this->php_ext, $base_url);
			}
			else
			{
				$base_url .= preg_replace(get_preg_expression('path_remove_dot_trailing_slash'), '$2', $this->phpbb_root_path);
			}
		}

		$base_url = $this->request->escape($this->filesystem->clean_path($base_url), true);

		$context->setBaseUrl($base_url);
		
		$this->router = $this->container->get('router');
		
		$this->router->setContext($context);
		$route_url = $this->router->generate($route, $params, $reference_type);

		if($is_amp)
		{
			$route_url = str_replace(['&amp;', '&'], ['&', '&amp;'], $route_url);
		}

		if($reference_type === UrlGeneratorInterface::RELATIVE_PATH && empty($this->config['blg_rewrite']))
		{
			$route_url = 'app.' . $this->php_ext . '/' . $route_url;
		}

		return append_sid($route_url . $anchor, false, $is_amp, $session_id, true);
	}
	
	/**
	 * Return the current url
	 * 
	 * @param array 		$params 		Additional params added to url
	 * @param bool 			$amp 			Define if $amp; must be used as separator
	 * @param array 		$ignore_params 	Define the params to be removed from the url
	 *
	 * @return string
	 */
	public function current_url($params = [], $amp = true, $ignore_params = [])
	{
		$url = generate_board_url(true) . $this->request->escape($this->symfony_request->getRequestUri(), true);
		
		if(sizeof($params) || sizeof($ignore_params))
		{
			$query_str	= '';
			$query		= [];
			
			if(strpos($url, '?') !== false)
			{
				list($url, $query_str) = explode('?', $url);
			}

			if($query_str)
			{
				$query_str = str_replace('&amp;', '&', $query_str);
				parse_str($query_str, $query);
			}
			
			$query = array_merge($query, $params);
			
			if(sizeof($ignore_params))
			{
				foreach($ignore_params as $ignore_key)
				{
					unset($query[$ignore_key]);
				}
			}
			
			return $url . (sizeof($query) ? '?' . http_build_query($query, '', (($amp) ? '&amp;' : '&')) : '');
		}
		
		return ($amp) ? $url : str_replace('&amp;', '&', $url);
	}
	
	/**
	 * Build page url
	 * 
	 * @param string 	$page_name
	 * @param array 	$params
	 * @param bool 		$is_amp
	 * 
	 * @return string
	 */
	public function url($page_name, $params = [], $is_amp = true)
	{
		return append_sid($this->phpbb_root_path . $page_name . '.' . $this->php_ext, $params, $is_amp);
	}
	
	/**
	 * Check if counter is updated in the current session
	 * 
	 * @param int 	$counter_id 		Counter|Block ID
	 * @return bool
	 */
	public function counter_session($counter_id)
	{
		$cookie_data = $this->request->variable($this->config['cookie_name'] . '_counter_track', '', true, \phpbb\request\request_interface::COOKIE);
		$cookie_data = explode('.', $cookie_data);

		if(in_array($counter_id, $cookie_data))
		{
			return true;
		}

		$cookie_data[] = $counter_id;

		$this->user->set_cookie('counter_track', implode('.', $cookie_data), 0);
		return false;
	}

	/**
	 * Get topic track info from rowset
	 * 
	 * @param array 	$rowset
	 * @return array
	 */
	public function get_rowset_tracking($rowset)
	{
		if(!sizeof($rowset))
		{
			return [];
		}

		$topic_tracking_info 	= [];
		$forums 				= [];

		foreach($rowset as $topic_id => $row)
		{
			if(!isset($forums[$row['forum_id']]))
			{
				$forums[$row['forum_id']] = [
					'mark_time'		=> 0,
					'topic_list'	=> [],
				];

				if($this->user->data['is_registered'] && $this->config['load_db_lastread'] && isset($row['f_mark_time']))
				{
					$forums[$row['forum_id']]['mark_time'] = $row['f_mark_time'];
				}
			}
			
			$forums[$row['forum_id']]['topic_list'][] = $topic_id;
		}

		foreach($forums as $forum_id => $forum)
		{
			if($this->user->data['is_registered'] && $this->config['load_db_lastread'])
			{
				$topic_tracking_info += get_topic_tracking($forum_id, $forum['topic_list'], $rowset, [$forum_id => $forum['mark_time']]);
			}
			else if($this->config['load_anon_lastread'] || $this->user->data['is_registered'])
			{
				$topic_tracking_info += get_complete_topic_tracking($forum_id, $forum['topic_list']);
			}
		}

		unset($forums);

		return $topic_tracking_info;
	}

	/**
	 * Get core media instance
	 * 
	 * @param bool 		$preload 		Set if media language and assets will be load
	 * @param bool 		$do_actions 	Set if media ajax actions will be processed
	 * 
	 * @return \canidev\core\media
	 */
	public function get_media($preload = true, $do_actions = false)
	{
		if($this->media === null)
		{
			$this->media = \canidev\core\media::get_instance($this->container, 'blockgets');
			
			$this->media
				->set_referer_ext('blockgets')
				->set_upload_path('files/blockgets/');
		}

		if($preload)
		{
			$this->media->preload();
		}

		if($do_actions)
		{
			$this->media->do_actions();
		}
		
		return $this->media;
	}
}
