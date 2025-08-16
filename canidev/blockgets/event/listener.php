<?php
/*
* @package cBB Blockgets
* @version v2.0.3 26/07/2021
*
* @copyright (c) 2021 CaniDev
* @license https://opensource.org/licenses/gpl-license.php GNU Public License
*/

namespace canidev\blockgets\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class listener implements EventSubscriberInterface
{
	protected $blockgets;
	protected $config;
	protected $helper;
	protected $lang;
	protected $parser;
	protected $request;
	protected $user;
	protected $php_ext;
	protected $table_prefix;
	
	protected $user_event = false;
	
	/**
	* Constructor
	*
	* @param \canidev\blockgets\libraries\blockgets		$blockgets			Blockgets Object
	* @param \phpbb\config\config 						$config				Config Object
	* @param ContainerInterface 						$container			Service container interface
	* @param \canidev\blockgets\libraries\helper		$helper				Blockgets helper Object
	* @param \phpbb\language\language					$language			Language Object
	* @param \phpbb\request\request 					$request			Request object
	* @param \phpbb\user								$user				User object
	* @param string										$phpEx				phpEx
	* @param string										$table_prefix		Table Prefix
	*
	* @access public
	*/
	public function __construct(
		\canidev\blockgets\libraries\blockgets $blockgets,
		\phpbb\config\config $config,
		\Symfony\Component\DependencyInjection\ContainerInterface $container,
		\canidev\blockgets\libraries\helper $helper,
		\phpbb\language\language $language,
		\phpbb\request\request $request,
		\phpbb\user $user,
		$phpEx,
		$table_prefix)
	{
		$this->blockgets		= $blockgets;
		$this->config			= $config;
		$this->helper			= $helper;
		$this->lang				= $language;
		$this->request			= $request;
		$this->user				= $user;
		$this->php_ext			= $phpEx;
		$this->table_prefix 	= $table_prefix;
		
		\canidev\core\lib::get_instance($container);
	}

	static public function getSubscribedEvents()
	{
		$events = array();
		
		if(!defined('IN_INSTALL'))
		{
			$events = array(
				'core.common'							=> 'on_init',
				'core.page_footer'						=> 'on_footer',
				'core.adm_page_footer'					=> 'on_footer',
				'core.user_setup'						=> 'on_setup',
				'core.user_setup_after'					=> array('on_setup_after', 1), // Make sure it's load before other extensions, like cBB Chat
				'core.permissions'						=> 'add_permissions',
				'core.validate_config_variable'			=> 'validate_config_variable',
				'core.modify_text_for_display_after'	=> 'modify_text_for_display',
				
				'kernel.exception'				=> 'on_kernel_exception',
				'core.login_box_redirect'		=> 'on_login',
				'core.session_kill_after' 		=> 'on_session_kill',
				'core.functions.redirect' 		=> 'on_redirect',
			);
		}

		return $events;
	}
	
	public function on_init()
	{
		$table_prefix = &$this->table_prefix;
		
		if((@include $this->helper->get_ext_path() . 'libraries/constants.' . $this->php_ext) == true)
		{
			$this->blockgets->enabled = $this->blockgets->active = true;
		}
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

			global $SID, $_EXTRA_URL;
			
			// Do request for the style_select_block
			if($style = $this->request->variable('cstyle', 0))
			{
				$event['style_id'] = $style;
				$SID .= '&amp;cstyle=' . $style;
				$_EXTRA_URL = array('cstyle=' . $style);
			}

			// Do request for the language_select_block
			if($lang = $this->request->variable('lng', ''))
			{
				$event['user_lang_name'] = $lang;
				$SID .= '&amp;lng=' . $lang;
				$_EXTRA_URL = array('lng=' . $lang);
			}
		}

		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = array(
			'ext_name' => 'canidev/blockgets',
			'lang_set' => 'main',
		);
		$event['lang_set_ext'] = $lang_set_ext;
	}
	
	public function on_setup_after()
	{
		// Fix login redirect url
		if($this->user->page['page_name'] == 'blockgets.' . $this->php_ext && $this->config['blg_home_type'] == TYPE_DOMAIN_HOME)
		{
			$this->user->page['page'] = str_replace('blockgets.' . $this->php_ext, '', $this->user->page['page']);
		}

		$this->blockgets->parse_ajax();
	}
	
	public function on_footer()
	{
		$this->blockgets->display_page();
	}

	public function modify_text_for_display($event)
	{
		$flags = $event['flags'];

		if($flags && ($flags & BLG_FLAG_HTML))
		{
			if(!$this->parser)
			{
				$this->parser = new \canidev\blockgets\libraries\parser();
			}

			$event['text'] = $this->parser->parse_bbcode($event['text']);
		}
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
					$err = $this->lang->lang('URL_INVALID');
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
					$err = $this->lang->lang('FORMAT_INVALID');
				}
			break;
		}
		
		// Output the error
		if($err)
		{
			$error = $event['error'];
			$error[] = $this->lang->lang($event['config_definition']['lang']) . ': ' . $err;
			$event['error'] = $error;
		}
	}
	
	public function on_kernel_exception($event)
	{
		$exception = $event->getException();

		if(method_exists($exception, 'getStatusCode') && $exception->getStatusCode() == 404 &&
			!preg_match('#\.(js|css)$#', $this->user->page['page_name']) &&
			($redirect = $this->get_redirect('404')) !== false)
		{
			$http_kernel 	= $event->getKernel();
			$request		= $event->getRequest();

			$request->attributes->set('_controller', $redirect['controller']);

			if($redirect['params'])
			{
				$request->attributes->add($redirect['params']);
			}

			$response = $http_kernel->handle($request);
			$response->setStatusCode(404);
			$response->send();
			$http_kernel->terminate($request, $response);
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
		if($this->user_event && ($redirect = $this->get_redirect($this->user_event)) !== false)
		{
			$event['url'] = $redirect['url'];
		}
		
		$this->user_event = false;
	}
	
	private function get_redirect($type)
	{
		if(empty($this->config["blg_redirect_$type"]))
		{
			return false;
		}

		$page 		= $this->config["blg_redirect_$type"];
		$redirect	= false;
		
		if($page == '/')
		{
			$redirect = array(
				'controller'	=> null,
				'params'		=> null,
				'url'			=> $this->helper->url('index'),
			);
		}
		else if($page == 'home')
		{
			$redirect = array(
				'controller'	=> 'canidev.blockgets.controller:display',
				'params'		=> null,
				'url'			=> $this->helper->route('canidev_blockgets_controller'),
			);
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
					$params = array(
						'page'	=> ($row['page_alias']) ? $row['page_alias'] : $row['page_id'],
					);

					$redirect = array(
						'controller'	=> 'canidev.blockgets.controller:display',
						'params'		=> $params,
						'url'			=> $this->helper->route('canidev_blockgets_page_' . $row['page_id']),
					);
				}
			}
			
			unset($page_ary);
		}

		return $redirect;
	}
}
