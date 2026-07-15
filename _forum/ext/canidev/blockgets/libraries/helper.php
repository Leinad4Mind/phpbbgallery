<?php
/*
* @name helper.php
* @package cBB Blockgets
* @version v2.0.0 30/05/2017
*
* @copyright (c) 2017 CaniDev
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\blockgets\libraries;

// @ignore
if(!defined('IN_PHPBB'))
{
	exit;
}

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RequestContext;

class helper
{
	protected $auth;
	protected $config;
	protected $container;
	protected $db;
	protected $filesystem;
	protected $json;
	protected $lang;
	protected $path;
	protected $request;
	protected $router;
	protected $symfony_request;
	protected $template;
	protected $user;

	protected $phpbb_root_path;
	protected $php_ext;
	
	/**
	* Constructor
	*
	* @param \phpbb\auth\auth 							$auth				Authentication object
	* @param \phpbb\config\config 						$config				Config Object
	* @param ContainerInterface 						$container			Service container interface
	* @param \phpbb\db\driver\driver_interface			$db					DB Object
	* @param \phpbb\filesystem							$filesystem			Filesystem Object
	* @param \canidev\blockgets\libraries\json_response	$json_response		Blockgets Json Object
	* @param \canidev\blockgets\libraries\language		$language			Blockgets language Object
	* @param \phpbb\path_helper							$path_helper		Path Helper Object
	* @param \phpbb\request\request 					$request			Request object
	* @param \phpbb\symfony_request						$symfony_request	Symfony Request
	* @param \phpbb\template\template					$template     		Template object
	* @param \phpbb\user								$user				User object
	*
	* @access public
	*/
	public function __construct(\phpbb\auth\auth $auth, \phpbb\config\config $config, ContainerInterface $container, \phpbb\db\driver\driver_interface $db, $filesystem, \canidev\blockgets\libraries\json_response $json_response, \canidev\blockgets\libraries\language $language, \phpbb\path_helper $path_helper, \phpbb\request\request $request, \phpbb\symfony_request $symfony_request, \phpbb\template\template $template, \phpbb\user $user)
	{
		$this->auth				= $auth;
		$this->config			= $config;
		$this->container		= $container;
		$this->db				= $db;
		$this->filesystem 		= $filesystem;
		$this->json				= $json_response;
		$this->lang				= $language;
		$this->path				= $path_helper;
		$this->request			= $request;
		$this->symfony_request	= $symfony_request;
		$this->template			= $template;
		$this->user				= $user;
		
		$this->phpbb_root_path	= $path_helper->get_phpbb_root_path();
		$this->php_ext			= $path_helper->get_php_ext();
	}
	
	public function get_web_root_path()
	{
		return $this->path->get_web_root_path();
	}

	/**
	 * format_short_date
	 * Create short date from the user date format to use in blocks
	 *
	 * @param int	$time . The time point number
	 * @param bool	$allow_timezone . Define if use the user timezone or not
	*/
	public function format_short_date($time, $allow_timezone = true)
	{
		$format = preg_replace('#[aABgGhHisueIOPTZcrU,\|:]+#', '', $this->user->data['user_dateformat']);

		if(!$allow_timezone)
		{
			return strtr(date($format, $time), array_filter($this->lang->get_raw('datetime'), 'is_string'));
		}

		return $this->user->format_date($time, $format);
	}

	public function group_auth($groups)
	{
		$group_ary = explode(',', $groups);

		if($groups == 'all' || in_array($this->user->data['group_id'], $group_ary))
		{
			return true;
		}
		
		return false;
	}
	
	/**
	 * obtain_today_visits
	 * Queries the session table to get information about today visits
	 *
	 * @return array An array containing the ids of today visits, hidden and visible users, as well as statistical info
	*/
	public function obtain_today_visits()
	{
		$user_list = array();

		$today_users = array(
			'lastvisit_users'	=> '',
			'userlist'			=> '',
			'total_today'		=> 0,
			'visible_today'		=> 0,
			'hidden_today'		=> 0,
			'guests_today'		=> 0,

			'hidden_online'		=> 0,
		);

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
			$today_users['userlist'] = $this->lang->get('REGISTERED_USERS') . ' ' . implode(', ', $user_list);
		}
		unset($user_list);

		$today_users['total_today'] = $today_users['guests_today'] + $today_users['visible_today'] + $today_users['hidden_today'];

		// Build online listing
		$vars_lastvisit = array(
			'LASTVISIT'	=> 'total_today',
			'REG'		=> 'visible_today',
			'HIDDEN'	=> 'hidden_today',
			'GUEST'		=> 'guests_today',
		);

		foreach($vars_lastvisit as $v_prefix => $var)
		{
			$today_users['lastvisit_users'] .= $this->lang->get($v_prefix . (($today_users[$var] == 1) ? '_VISIT_TOTAL' : '_VISITS_TOTAL'), $today_users[$var]);
		}
		unset($vars_lastvisit);

		return $today_users;
	}
	
	public function confirm_box($check, $title = '', $hidden = array(), $html_body = '', $u_action = '')
	{
		global $phpbb_path_helper;

		if($this->request->is_set_post('cancel'))
		{
			return false;
		}
		
		$confirm = ($this->lang->get('YES') === $this->request->variable('confirm', '', true, \phpbb\request\request_interface::POST));

		if($check && $confirm)
		{
			$user_id		= $this->request->variable('confirm_uid', 0);
			$session_id 	= $this->request->variable('sess', '');

			if($user_id != $this->user->data['user_id'] || $session_id != $this->user->session_id)
			{
				return false;
			}

			return true;
		}
		else if($check)
		{
			return false;
		}
		
		$s_hidden_fields = build_hidden_fields(array_merge($hidden, array(
			'confirm_uid'	=> $this->user->data['user_id'],
			'sess'			=> $this->user->session_id,
			'sid'			=> $this->user->session_id,
		)));
		
		// re-add sid / transform & to &amp; for user->page (user->page is always using &)
		$use_page = ($u_action) ? $u_action : str_replace('&', '&amp;', $this->user->page['page']);
		$u_action = reapply_sid($phpbb_path_helper->get_valid_page($use_page, $this->config['enable_mod_rewrite']));
	
		$message	= (!$this->lang->is_set($title . '_CONFIRM')) ? $title : $this->lang->get($title . '_CONFIRM');
		$title		= (!$this->lang->is_set($title)) ? $this->lang->get('CONFIRM') : $this->lang->get($title);

		$this->template->assign_vars(array(
			'MESSAGE_TITLE'		=> $title,
			'MESSAGE_TEXT'		=> $message,

			'YES_VALUE'			=> $this->lang->get('YES'),
			'S_CONFIRM_ACTION'	=> $u_action,
			'S_HIDDEN_FIELDS'	=> $s_hidden_fields,
			'S_AJAX_REQUEST'	=> $this->request->is_ajax(),
		));
		
		if($this->request->is_ajax())
		{
			$this->template->assign_vars(array(
				'S_CONFIRM_BOX'		=> true,
			));
			
			$this->template->set_filenames(array(
				'confirm'	=> ($html_body) ? $html_body : 'ajax_body.html',
			));
			
			$this->json->send(array(
				'confirmbox'	=> true,
				'htmlContent'	=> $this->template->assign_display('confirm'),
			));
		}
		
		if(defined('IN_ADMIN') && isset($this->user->data['session_admin']) && $this->user->data['session_admin'])
		{
			adm_page_header($title);
		}
		else
		{
			page_header($title);
		}

		$this->template->set_filenames(array(
			'body' => ($html_body) ? $html_body : 'confirm_body.html',
		));
		
		if(defined('IN_ADMIN') && isset($this->user->data['session_admin']) && $this->user->data['session_admin'])
		{
			adm_page_footer();
		}
		else
		{
			page_footer();
		}
	}
	
	public function trigger_error($data = array(), $break = true)
	{
		$data['status'] = (isset($data['status']) ? $data['status'] : BLG_JSON_SUCCESS);

		$message = (isset($data['message']) ? $data['message'] : '');
		$message = $this->lang->get($message);

		if($this->request->is_ajax())
		{
			if($data['status'] == BLG_JSON_SUCCESS && $break && !empty($data['return_url']) && empty($data['timeout']))
			{
				$data['timeout'] = BLG_RETURN_TIMEOUT;
			}
			
			$data['message'] = $message;

			$this->json->add($data);
			
			if($break !== false)
			{
				$this->template->set_filenames(array(
					'body' => ($break === true) ? 'message_body.html' : $break
				));

				page_footer(false);
			}
		}
		else if(!empty($data['redirect']))
		{
			redirect($data['redirect']);
		}
		else
		{
			if(!empty($data['return_url']))
			{
				$message .= adm_back_link($data['return_url']);
			}
			else if(defined('IN_ADMIN'))
			{
				$message .= adm_back_link(append_sid($this->phpbb_root_path . (($this->user->page['page_dir']) ? $this->user->page['page_dir'] . '/' : '') . $this->user->page['page_name'], array(
					'i'		=> $this->request->variable('i', ''),
					'mode'	=> $this->request->variable('mode', ''),
				)));
			}
			
			if($data['status'] == BLG_JSON_ERROR)
			{
				trigger_error($message, E_USER_WARNING);
			}
			
			trigger_error($message);
		}
	}
	
	public function build_image_filename($image, $full_url = false)
	{
		$filename = '';
		$web_path = $this->path->get_web_root_path();
		
		if(substr($image, 0, 2) == './')
		{
			$filename = $this->get_ext_path(true) . 'images/' . substr($image, 2);
		}
		else if(substr($image, 0, 4) == 'http' || substr($image, 0, 2) == '//')
		{
			return $image;
		}
		else if($image)
		{
			$filename = $web_path . 'files/blockgets/' . $image;
		}
		
		if($full_url && $filename)
		{
			return generate_board_url() . '/' . str_replace($web_path, '', $filename);
		}
		
		return $filename;
	}
	
	public function html_truncate($input = '', $limit = 0, $append = '', $count_all = false)
	{
		$check_len = ($count_all) ? utf8_strlen($input) : utf8_strlen(strip_tags($input));

		if(!$input || $limit <= 0 || $check_len <= $limit)
		{
			return $input;
		}

		$splits = preg_split('#(</?[^>]*/?>)#', $input, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);

		$text		= '';
		$open_tag	= false;

		foreach($splits as $split)
		{
			// If no open tag, open it if necessary
			if($open_tag === false)
			{
				if(preg_match('#^<([a-zA-Z]+).*>#', $split, $match))
				{
					if(utf8_substr($match[0], -2) !== '/>')
					{
						$open_tag = $match[1];
					}
				}
			}

			// Close tag, if the current
			if($open_tag !== false)
			{
				if($split === "</$open_tag>")
				{
					$open_tag = false;
				}
			}

			// Adjust the string
			if($open_tag === false && $split[0] != '<')
			{ 
				$length = ($count_all) ? utf8_strlen($text) : utf8_strlen(strip_tags($text));

				if(($length + utf8_strlen($split)) > $limit)
				{
					$split = utf8_substr($split, 0, $limit - $length);
				}
			}

			$text .= $split;

			// If exceed the limit and no open tags finish here,
			// and it is looking backwards to remove the tag open.
			$check_len = ($count_all) ? utf8_strlen($text) : utf8_strlen(strip_tags($text));
			if($check_len >= $limit)
			{
				if($open_tag !== false)
				{
					$tag = '<' . $open_tag; 
					$text = utf8_substr($text, 0, utf8_strrpos($text, $tag));
				}
		
				break;
			}
		}

		return $text . (($append) ? $append : '');
	}
	
	/**
	* locale_lang
	* Get the local lang code from user lang code
	*
	* @param string	$lang_name . The lang iso name to find or '_get' param to only load the files
	* @param string	$type . (iso|name). The type of data to proccess
	* @return string|bool . Returns the locale lang or the default lang if not exists.
	*/
	public function locale_lang($lang_name = false, $type = 'iso')
	{
		static $blg_lang_locale;
		
		if(empty($blg_lang_locale))
		{
			include($this->get_ext_path() . 'libraries/lang_locale.' . $this->php_ext);
		}

		$lang_name	= (!$lang_name) ? $this->user->lang_name : $lang_name;
		$result		= array();
		
		if($lang_name != 'raw')
		{
			return (isset($blg_lang_locale[$lang_name][$type]) ? $blg_lang_locale[$lang_name][$type] : (($type == 'iso') ? 'en_US' : ''));
		}
		
		foreach($blg_lang_locale as $code => $row)
		{
			$result[$code] = $row[$type];
		}
		
		return $result;
	}
	
	public function get_ext_path($correct_path = false)
	{
		$ext_path = str_replace(array('\libraries', '\\'), array('', '/'), __NAMESPACE__);
		return (($correct_path) ? $this->path->get_web_root_path() : $this->phpbb_root_path) . 'ext/' . $ext_path . '/';
	}
	
		/**
	* Generate a URL to a route
	*
	* @param string	$route		Name of the route to travel
	* @param array	$params		String or array of additional url parameters
	* @param bool	$is_amp		Is url using &amp; (true) or & (false)
	* @param string|bool		$session_id	Possibility to use a custom session id instead of the global one
	* @param bool|string		$reference_type The type of reference to be generated (one of the constants)
	* @return string The URL already passed through append_sid()
	*/
	public function route($route, array $params = array(), $is_amp = true, $session_id = false, $absolute_url = false)
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
		if($route == 'canidev_blockgets_controller' && $this->config['blg_home_type'] == TYPE_DOMAIN_HOME)
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

		// If enable_mod_rewrite is false we need to replace the current front-end by app.php, otherwise we need to remove it.
		$base_url = str_replace('/' . $page_name, empty($this->config['blg_rewrite']) ? '/app.' . $this->php_ext : '', $base_url);

		// We need to update the base url to move to the directory of the app.php file if the current script is not app.php
		if ($page_name !== 'app.php' && !$this->config['force_server_vars'])
		{
			if (empty($this->config['blg_rewrite']))
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
		
		$this->get_router();
		
		$this->router->setContext($context);
		$route_url = $this->router->generate($route, $params, $reference_type);

		if($is_amp)
		{
			$route_url = str_replace(array('&amp;', '&'), array('&', '&amp;'), $route_url);
		}

		if($reference_type === UrlGeneratorInterface::RELATIVE_PATH && empty($this->config['blg_rewrite']))
		{
			$route_url = 'app.' . $this->php_ext . '/' . $route_url;
		}

		return append_sid($route_url . $anchor, false, $is_amp, $session_id, true);
	}

	public function get_router()
	{
		if(!$this->router)
		{
			if($this->container->has('router'))
			{
				// phpBB 3.2 behavior
				$this->router = $this->container->get('router');
			}
			else
			{
				// phpBB 3.1 behavior
				$this->router = new router($this->container);
			}
		}
		
		return $this->router;
	}
	
	/**
	* Return the current url
	*
	* @return string
	*/
	public function current_url($params = array(), $amp = true, $ignore_params = array())
	{
		$url = generate_board_url(true) . $this->request->escape($this->symfony_request->getRequestUri(), true);
		
		if(sizeof($params) || sizeof($ignore_params))
		{
			$query_str	= '';
			$query		= array();
			
			if(strpos($url, '?') !== false)
			{
				list($url, $query_str) = explode('?', $url);
			}

			if($query_str)
			{
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
	
	public function url($page_name, $params = array(), $is_amp = true)
	{
		return append_sid($this->phpbb_root_path . $page_name . '.' . $this->php_ext, $params, $is_amp);
	}
	
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
}
