<?php
/*
* @name listener.php
* @package cBB Blockgets
* @version v2.0.0 30/05/2017
*
* @copyright (c) 2017 CaniDev
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\blockgets\event;

// @ignore
if(!defined('IN_PHPBB'))
{
	exit;
}

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class listener implements EventSubscriberInterface
{
	protected $blockgets;
	protected $config;
	protected $helper;
	protected $lang;
	protected $request;
	protected $user;
	protected $php_ext;
	
	protected $user_event = false;
	
	/**
	* Constructor
	*
	* @param \canidev\blockgets\libraries\blockgets		$blockgets		Blockgets Object
	* @param \phpbb\config\config 						$config			Config Object
	* @param \canidev\blockgets\libraries\helper		$helper			Blockgets helper Object
	* @param \canidev\blockgets\libraries\language		$language		Blockgets language Object
	* @param \phpbb\request\request 					$request		Request object
	* @param \phpbb\user								$user			User object
	* @param string										$php_ext		phpEx
	*
	* @access public
	*/
	public function __construct(\canidev\blockgets\libraries\blockgets $blockgets, \phpbb\config\config $config, \canidev\blockgets\libraries\helper $helper, \canidev\blockgets\libraries\language $language, \phpbb\request\request $request, \phpbb\user $user, $phpEx)
	{
		$this->blockgets	= $blockgets;
		$this->config		= $config;
		$this->helper		= $helper;
		$this->lang			= $language;
		$this->request		= $request;
		$this->user			= $user;
		$this->php_ext		= $phpEx;
	}

	static public function getSubscribedEvents()
	{
		global $phpbb_container;

		$events = array();
		
		if(!defined('IN_INSTALL'))
		{
			$events = array(
				'core.common'					=> 'on_init',
				'core.page_footer'				=> 'on_footer',
				'core.adm_page_footer'			=> 'on_footer',
				'core.user_setup'				=> 'on_setup',
				'core.permissions'				=> 'add_permissions',
				'core.validate_config_variable'	=> 'validate_config_variable',
				
				'kernel.exception'				=> 'on_kernel_exception',
				'core.login_box_redirect'		=> 'on_login',
				'core.session_kill_after' 		=> 'on_session_kill',
				'core.functions.redirect' 		=> 'on_redirect',
			);
			
			$phpbb_container->get('canidev.blockgets.compatibility.manager')->get_core_events();
		}

		return $events;
	}
	
	public function on_init()
	{
		global $phpbb_hook, $table_prefix;
		
		if((@include $this->helper->get_ext_path() . 'libraries/constants.' . $this->php_ext) == true)
		{
			$this->blockgets->enabled = $this->blockgets->active = true;
		}
		
		$phpbb_hook->register('phpbb_user_session_handler', array($this->blockgets, 'parse_ajax'));
	}
	
	public function on_setup($event)
	{
		// Update de counter
		if(!defined('ADMIN_START'))
		{
			// Redirect pages if neccessary or not allowed
			if($this->blockgets->enabled && $this->blockgets->phpbb_root_path == './' && $this->user->page['page_name'] == "index.{$this->php_ext}")
			{
				if($this->config['blg_home_type'] == TYPE_FORUM_HOME && preg_match('#.*/$#', $this->request->server('REQUEST_URI', '')))
				{
					redirect($this->helper->route('canidev_blockgets_controller'));
				}
			}
			
			if(!$this->helper->counter_session('all'))
			{
				$this->config->increment('blg_counter_visit_count', 1, false);
			}
			
			// Do style request for the style_select_block
			if($style = $this->request->variable('cstyle', 0))
			{
				global $SID, $_EXTRA_URL;

				$event['style_id'] = $style;
				$SID .= '&amp;cstyle=' . $style;
				$_EXTRA_URL = array('cstyle=' . $style);
			}
		}

		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = array(
			'ext_name' => 'canidev/blockgets',
			'lang_set' => 'main',
		);
		$event['lang_set_ext'] = $lang_set_ext;
	}
	
	public function on_footer()
	{
		$this->blockgets->display_page();
	}

	/**
	* Add administrative permissions to manage Chat
	*
	* @param object $event The event object
	* @access public
	*/
	public function add_permissions($event)
	{
		$event['permissions'] = array_merge($event['permissions'], array(
			'a_blockgets'			=> array('lang'	=> 'ACL_A_BLOCKGETS_MANAGE',	'cat'	=> 'misc'),
			'u_blockgets_calendar'	=> array('lang'	=> 'ACL_U_BLOCKGETS_CALENDAR',	'cat'	=> 'misc'),
			'u_blockgets_events'	=> array('lang'	=> 'ACL_U_BLOCKGETS_EVENTS',	'cat'	=> 'misc'),
		));
	}
	
	public function validate_config_variable($event)
	{
		$config_name 	= $event['config_name'];
		$err			= '';
		
		switch($event['config_definition']['validate'])
		{
			case 'url':
				if(!preg_match('#\b(?:(?:https?|ftp):\/\/)[-a-z0-9+&@\/%?=~_|!:,.;]*[-a-z0-9+&@\/%=~_|]#i', $event['cfg_array'][$config_name]))
				{
					$err = $this->lang->get('URL_INVALID');
				}
			break;

			case 'regexp':
				$valid	= false;
				$regexp	= $event['config_definition']['regexp'];
				$regexp	= (is_array($regexp) ? $regexp : array($regexp));
				
				foreach($regexp as $expression)
				{
					if(preg_match($expression, $event['cfg_array'][$config_name]))
					{
						$valid = true;
						break;
					}
				}
				
				if(!$valid)
				{
					$err = $this->lang->get('URL_INVALID');
				}
			break;
		}
		
		// Output the error
		if($err)
		{
			$error = $event['error'];
			$error[] = $this->lang->get($event['config_definition']['lang']) . ': ' . $err;
			$event['error'] = $error;
		}
	}
	
	public function on_kernel_exception($event)
	{
		$exception = $event->getException();

		if(method_exists($exception, 'getStatusCode') && $exception->getStatusCode() == 404 && ($redirect = $this->get_redirect('404')))
		{
			redirect($redirect);
		}
	}
	
	public function on_login($event)
	{
		if(!$event['admin'])
		{
			$this->user_event = 'login';
		}
	}
	
	public function on_session_kill()
	{
		$this->user_event = 'logout';
	}
	
	public function on_redirect($event)
	{
		if($this->user_event && ($redirect = $this->get_redirect($this->user_event)))
		{
			$event['url'] = $redirect;
		}
		
		$this->user_event = false;
	}
	
	private function get_redirect($type)
	{
		if(empty($this->config["blg_redirect_$type"]))
		{
			return '';
		}

		$page 		= $this->config["blg_redirect_$type"];
		$u_redirect	= '';
		
		if($page == '/')
		{
			$u_redirect = $this->helper->url('index');
		}
		else if($page == 'home')
		{
			$u_redirect = $this->helper->route('canidev_blockgets_controller');
		}
		else if(is_numeric($page))
		{
			$page		= (int)$page;
			$page_ary	= $this->blockgets->get_pages();
			
			if(isset($page_ary['pages'][PAGE_CUSTOM][$page]))
			{
				$row = $page_ary['pages'][PAGE_CUSTOM][$page];
				
				if($row['page_enabled'] && $this->helper->group_auth($row['page_groups']))
				{
					$u_redirect = $this->helper->route('canidev_blockgets_page_controller', array(
						'page'	=> ($row['page_alias']) ? $row['page_alias'] : $row['page_id']
					));
				}
			}
			
			unset($page_ary);
		}

		return $u_redirect;
	}
}
