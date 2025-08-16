<?php
/**
 * @package cBB Blockgets
 * @version 2.0.6 20/09/2023
 *
 * @copyright (c) 2023 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 */

namespace canidev\blockgets\event;

use canidev\blockgets\libraries\constants;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class listener implements EventSubscriberInterface
{
	protected $blockgets;
	protected $config;
	protected $helper;
	protected $language;
	protected $parser;
	protected $request;
	protected $user;
	protected $php_ext;
	protected $table_prefix;
	
	protected $user_event = false;
	
	/**
	 * Constructor
	 *
	 * @param \canidev\blockgets\libraries\blockgets	$blockgets			Blockgets Object
	 * @param \phpbb\config\config 						$config				Config Object
	 * @param \canidev\blockgets\libraries\helper		$helper				Blockgets helper Object
	 * @param \phpbb\language\language					$language			Language Object
	 * @param \phpbb\request\request 					$request			Request object
	 * @param \phpbb\user								$user				User object
	 * @param string									$phpEx				phpEx
	 *
	 * @access public
	 */
	public function __construct(
		\canidev\blockgets\libraries\blockgets $blockgets,
		\phpbb\config\config $config,
		\canidev\blockgets\libraries\helper $helper,
		\phpbb\language\language $language,
		\phpbb\request\request $request,
		\phpbb\user $user,
		$php_ext)
	{
		$this->blockgets		= $blockgets;
		$this->config			= $config;
		$this->helper			= $helper;
		$this->language			= $language;
		$this->request			= $request;
		$this->user				= $user;
		$this->php_ext			= $php_ext;
	}

	/**
	 * {@inheritDoc}
	 */
	static public function getSubscribedEvents()
	{
		return [
			'core.page_footer'						=> 'on_footer',
			'core.adm_page_footer'					=> 'on_footer',
			'core.user_setup'						=> 'on_setup',
			'core.user_setup_after'					=> ['on_setup_after', 10], // Make sure it's load before other extensions
			'core.permissions'						=> 'add_permissions',
			'core.validate_config_variable'			=> 'validate_config_variable',
			'core.modify_text_for_display_after'	=> ['modify_text_for_display', 10], // Make sure it's load before other extensions
			
			'kernel.exception'				=> 'on_kernel_exception',
			'core.login_box_redirect'		=> 'on_login',
			'core.session_kill_after' 		=> 'on_session_kill',
			'core.functions.redirect' 		=> 'on_redirect',
		];
	}

	/**
	 * core.user_setup
	 * @param \phpbb\event\data 	$data
	 */
	public function on_setup($event)
	{
		// Update de counter
		if(!defined('ADMIN_START'))
		{
			// Redirect pages if neccessary or not allowed
			if($this->blockgets->phpbb_root_path == './' && $this->user->page['page_name'] == "index.{$this->php_ext}")
			{
				if($this->config['blg_home_type'] == constants::TYPE_FORUM_HOME && preg_match('#.*/$#', $this->request->server('REQUEST_URI', '')))
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
				$_EXTRA_URL = ['cstyle=' . $style];
			}

			// Do request for the language_select_block
			if($lang = $this->request->variable('lng', ''))
			{
				$event['user_lang_name'] = $lang;
				$SID .= '&amp;lng=' . $lang;
				$_EXTRA_URL = ['lng=' . $lang];
			}
		}

		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = [
			'ext_name' => 'canidev/blockgets',
			'lang_set' => 'main',
		];
		$event['lang_set_ext'] = $lang_set_ext;
	}
	
	/**
	 * core.user_setup_after
	 */
	public function on_setup_after()
	{
		// Fix login redirect url
		if($this->user->page['page_name'] == 'blockgets.' . $this->php_ext && $this->config['blg_home_type'] == constants::TYPE_DOMAIN_HOME)
		{
			$this->user->page['page'] = str_replace('blockgets.' . $this->php_ext, '', $this->user->page['page']);
		}

		$this->blockgets->parse_ajax();
	}
	
	/**
	 * core.page_footer
	 * core.adm_page_footer
	 */
	public function on_footer()
	{
		$this->blockgets->display_page();
	}

	/**
	 * core.modify_text_for_display_after
	 * @param \phpbb\event\data 	$data
	 */
	public function modify_text_for_display($event)
	{
		$flags = $event['flags'];

		if($flags && ($flags & constants::FLAG_HTML))
		{
			if(!$this->parser)
			{
				$this->parser = new \canidev\blockgets\libraries\parser;
			}

			$event['text'] = $this->parser->parse_bbcode($event['text']);
		}
	}

	/**
	 * core.permissions
	 * Add administrative permissions
	 * 
	 * @param \phpbb\event\data 	$event
	 */
	public function add_permissions($event)
	{
		$event['categories'] = array_merge($event['categories'], [
			'blockgets'	=> 'ACP_BLOCKGETS',
		]);

		$event['permissions'] = array_merge($event['permissions'], [
			'a_blockgets'				=> ['lang'	=> 'ACL_A_BLOCKGETS_MANAGE',		'cat'	=> 'misc'],
			'u_blockgets_birthdays'		=> ['lang'	=> 'ACL_U_BLOCKGETS_BIRTHDAYS',		'cat'	=> 'blockgets'],
			'u_blockgets_calendar'		=> ['lang'	=> 'ACL_U_BLOCKGETS_CALENDAR',		'cat'	=> 'blockgets'],
			'u_blockgets_events'		=> ['lang'	=> 'ACL_U_BLOCKGETS_EVENTS',		'cat'	=> 'blockgets'],
		]);
	}
	
	/**
	 * core.validate_config_variable
	 * @param \phpbb\event\data 	$event
	 */
	public function validate_config_variable($event)
	{
		$config_name 	= $event['config_name'];
		$err			= '';
		
		switch($event['config_definition']['validate'])
		{
			case 'url':
				if(!preg_match('#\b(?:(?:https?|ftp):\/\/)[-a-z0-9+&@\/%?=~_|!:,.;]*[-a-z0-9+&@\/%=~_|]#i', $event['cfg_array'][$config_name]))
				{
					$err = $this->language->lang('URL_INVALID');
				}
			break;

			case 'regexp':
				$valid	= false;
				$regexp	= $event['config_definition']['regexp'];
				$regexp	= (is_array($regexp) ? $regexp : [$regexp]);
				
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
					$err = $this->language->lang('FORMAT_INVALID');
				}
			break;
		}
		
		// Output the error
		if($err)
		{
			$error = $event['error'];
			$error[] = $this->language->lang($event['config_definition']['lang']) . ': ' . $err;
			$event['error'] = $error;
		}
	}
	
	/**
	 * kernel.exception
	 * @param object $event
	 */
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
	
	/**
	 * core.login_box_redirect
	 * @param \phpbb\event\data 	$event
	 */
	public function on_login($event)
	{
		if(!$event['admin'])
		{
			$this->user_event = 'login';
		}
	}
	
	/**
	 * core.session_kill_after
	 */
	public function on_session_kill()
	{
		$this->user_event = 'logout';
	}
	
	/**
	 * core.functions.redirect
	 * @param \phpbb\event\data 	$event
	 */
	public function on_redirect($event)
	{
		if($this->user_event && ($redirect = $this->get_redirect($this->user_event)) !== false)
		{
			$event['url'] = $redirect['url'];
		}
		
		$this->user_event = false;
	}
	
	/**
	 * Get redirect object
	 * 
	 * @param string 	$type
	 * 
	 * @return array
	 * @access private
	 */
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
			$redirect = [
				'controller'	=> null,
				'params'		=> null,
				'url'			=> $this->helper->url('index'),
			];
		}
		else if($page == 'home')
		{
			$redirect = [
				'controller'	=> 'canidev.blockgets.controller:display',
				'params'		=> null,
				'url'			=> $this->helper->route('canidev_blockgets_controller'),
			];
		}
		else if(is_numeric($page))
		{
			$page		= (int)$page;
			$page_ary	= $this->blockgets->get_pages();
			
			if(isset($page_ary['pages'][constants::PAGE_CUSTOM][$page]))
			{
				$row = $page_ary['pages'][constants::PAGE_CUSTOM][$page];
				
				if($row['page_enabled'] && $this->helper->group_auth($row['page_groups']))
				{
					$params = [
						'page'	=> ($row['page_alias']) ? $row['page_alias'] : $row['page_id'],
					];

					$redirect = [
						'controller'	=> 'canidev.blockgets.controller:display',
						'params'		=> $params,
						'url'			=> $this->helper->route('canidev_blockgets_page_' . $row['page_id']),
					];
				}
			}
			
			unset($page_ary);
		}

		return $redirect;
	}
}
