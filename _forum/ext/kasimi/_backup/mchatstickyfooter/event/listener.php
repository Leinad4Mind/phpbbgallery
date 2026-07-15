<?php

/**
 *
 * @package phpBB Extension - mChat Sticky Footer
 * @copyright (c) 2016 kasimi - https://kasimi.net
 * @license proprietary
 *
 */

namespace kasimi\mchatstickyfooter\event;

use dmzx\mchat\core\functions;
use dmzx\mchat\core\mchat;
use dmzx\mchat\core\settings;
use kasimi\mchatstickyfooter\controller\resize;
use phpbb\auth\auth;
use phpbb\controller\helper;
use phpbb\event\data;
use phpbb\event\dispatcher_interface;
use phpbb\language\language;
use phpbb\template\template;
use phpbb\user;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class listener implements EventSubscriberInterface
{
	/** @var user */
	protected $user;

	/** @var language */
	protected $lang;

	/** @var auth */
	protected $auth;

	/** @var template */
	protected $template;

	/** @var dispatcher_interface */
	protected $dispatcher;

	/** @var helper */
	protected $helper;

	/** @var mchat */
	protected $mchat;

	/** @var functions */
	protected $functions;

	/** @var settings */
	protected $settings;

	/** @var string */
	protected $mchat_page = '';

	/** @var bool */
	protected $need_whois_action = false;

	/** @var int */
	protected $mchat_users = null;

	/**
	 * @param user					$user
	 * @param language				$lang
	 * @param auth					$auth
	 * @param template				$template
	 * @param dispatcher_interface	$dispatcher
	 * @param helper				$helper
	 * @param mchat					$mchat
	 * @param functions				$functions
	 * @param settings				$settings
	 */
	public function __construct(
		user $user,
		language $lang,
		auth $auth,
		template $template,
		dispatcher_interface $dispatcher,
		helper $helper,
		mchat $mchat = null,
		functions $functions = null,
		settings $settings = null
	)
	{
		$this->user			= $user;
		$this->lang			= $lang;
		$this->auth			= $auth;
		$this->template		= $template;
		$this->dispatcher	= $dispatcher;
		$this->helper		= $helper;
		$this->mchat		= $mchat;
		$this->functions	= $functions;
		$this->settings		= $settings;
	}

	/**
	 * @return array
	 */
	public static function getSubscribedEvents()
	{
		return [
			// Inject our settings
			'dmzx.mchat.ucp_settings_modify'							=> 'ucp_settings_modify',
			'dmzx.mchat.ucp_update_data'								=> 'mchat_reset_sticky_size',

			// Display on every page
			'core.page_footer'											=> 'display_mchat',
			'dmzx.mchat.render_page_before'								=> 'disable_mchat',

			// Display number of chat users in title
			'dmzx.mchat.render_page_after'								=> 'mchat_render_after',
			'dmzx.mchat.active_users_after'								=> 'mchat_active_users_after',
			'dmzx.mchat.global_settings_modify'							=> 'mchat_global_settings_modify',
			'dmzx.mchat.action_whois_after'								=> 'mchat_action_whois_after',

			// UCP and ACP settings
			'core.permissions'											=> ['permissions', -10],
			'core.acp_users_prefs_modify_template_data'					=> ['add_lang', 10],
			'dmzx.mchat.acp_globalusersettings_modify_template_data'	=> ['add_lang', 10],
			'dmzx.mchat.ucp_modify_template_data'						=> ['add_lang', 10],
		];
	}

	/**
	 * @param data $event
	 */
	public function disable_mchat($event)
	{
		$this->mchat_page = $event['page'];
	}

	/**
	 * @param data $event
	 */
	public function mchat_render_after($event)
	{
		$this->need_whois_action = !in_array('whois', $event['actions']);
	}

	/**
	 * @param data $event
	 */
	public function mchat_active_users_after($event)
	{
		$this->mchat_users = count($event['mchat_users']);
	}

	/**
	 * @param data $event
	 */
	public function mchat_global_settings_modify($event)
	{
		$event['global_settings'] = array_merge($event['global_settings'], [
			'mchat_sticky_active_users' => ['default' => 1, 'validation' => ['num', false, 0, 1]],
		]);
	}

	/**
	 *
	 */
	public function mchat_action_whois_after($event)
	{
		if (!$this->auth->acl_get('u_mchat_view') || !$this->settings->cfg('mchat_sticky_footer') || !$this->settings->cfg('mchat_sticky_active_users'))
		{
			return;
		}

		if ($this->mchat_users === null)
		{
			// Trigger event to get number of active users
			$this->functions->mchat_active_users();
		}

		$event['response'] = array_merge($event['response'], [
			'stickyUsers' => $this->mchat_users,
		]);
	}

	/**
	 *
	 */
	public function display_mchat()
	{
		if ($this->mchat === null || $this->settings === null)
		{
			return;
		}

		if (!$this->auth->acl_get('u_mchat_view') || !$this->settings->cfg('mchat_sticky_footer'))
		{
			return;
		}

		if ($this->settings->cfg('board_disable') && !$this->auth->acl_gets('a_', 'm_') && !$this->auth->acl_getf_global('m_'))
		{
			return;
		}

		$template_vars = [];

		if ($this->mchat_page === '')
		{
			// We use the page_index() method to render mChat so we need
			// to enable mChat on the index page only for this request
			$this->user->data['user_mchat_index'] = 1;
			$this->settings->set_cfg('mchat_index', 1, true);

			// Render mChat
			$this->mchat->page_index();

			$is_sticky_footer = true;

			$template_vars = array_merge($template_vars, [
				'MCHAT_INDEX'	=> false,
				'MCHAT_PAGE'	=> 'sticky_footer',
			]);
		}
		else
		{
			// Display mChat as sticky footer unless...
			$is_sticky_footer = !(
				// ... we're on the index page and the user has 'Display on index' enabled
				($this->mchat_page === 'index' && $this->settings->cfg('mchat_index'))
				// ... we're on the custom page
				|| $this->mchat_page === 'custom'
				// ... we're on the archive page
				|| $this->mchat_page === 'archive'
			);
		}

		if ($is_sticky_footer && $this->settings->cfg('mchat_sticky_active_users'))
		{
			if ($this->mchat_users === null)
			{
				// Trigger event to get number of active users
				$this->functions->mchat_active_users();
			}

			if ($this->need_whois_action)
			{
				$this->template->assign_var('MCHAT_WHOIS_REFRESH', $this->settings->cfg('mchat_whois_refresh') * 1000);

				$this->template->assign_block_vars('mchaturl', [
					'ACTION'	=> 'whois',
					'URL'		=> $this->helper->route('dmzx_mchat_action_whois_controller', [], false),
				]);
			}
		}

		$resize = $is_sticky_footer && $this->user->data['is_registered'];

		$template_vars = array_merge($template_vars, [
			'MCHAT_IS_STICKY_FOOTER'	=> $is_sticky_footer,
			'U_MCHAT_STICKY_RESIZE'		=> $resize ? $this->helper->route('kasimi_mchatstickyfooter_resize', [], false) : '',
			'MCHAT_STICKY_WIDTH'		=> $resize ? $this->user->data['mchat_sticky_width'] : 0,
			'MCHAT_STICKY_HEIGHT'		=> $resize ? $this->user->data['mchat_sticky_height'] : 0,
			'MCHAT_STICKY_SHOW_USERS'	=> $this->settings->cfg('mchat_sticky_active_users'),
			'MCHAT_STICKY_USERS'		=> $this->mchat_users,
		]);

		/**
		 * Event to modify template data
		 *
		 * @event kasimi.mchatstickyfooter.modify_template_data
		 * @var	array	template_vars	The template data.
		 * @since 1.0.3
		 */
		$vars = [
			'template_vars',
		];
		extract($this->dispatcher->trigger_event('kasimi.mchatstickyfooter.modify_template_data', compact($vars)));

		$this->template->assign_vars($template_vars);
	}

	/**
	 *
	 */
	public function add_lang()
	{
		if ($this->mchat !== null && $this->settings !== null)
		{
			$this->lang->add_lang('mchatstickyfooter_ucp', 'kasimi/mchatstickyfooter');
		}
	}

	/**
	 * @param data $event
	 */
	public function ucp_settings_modify($event)
	{
		$event['ucp_settings'] = array_merge($event['ucp_settings'], [
			'mchat_sticky_footer' => ['default' => 0],
		]);
	}

	/**
	 * @param data $event
	 */
	public function mchat_reset_sticky_size($event)
	{
		if (!$event['mchat_sticky_footer'])
		{
			$event['mchat_new_config'] = array_merge($event['mchat_new_config'], [
				'mchat_sticky_width'	=> resize::STICKY_DEFAULT_WIDTH,
				'mchat_sticky_height'	=> resize::STICKY_DEFAULT_HEIGHT,
			]);
		}
	}

	/**
	 * @param data $event
	 */
	public function permissions($event)
	{
		$category = 'mchat_user_config';

		$new_permissions = [
			'u_mchat_isticky_footer',
		];

		$categories = $event['categories'];

		if (!empty($categories[$category]))
		{
			$permissions = $event['permissions'];

			foreach ($new_permissions as $new_permission)
			{
				$permissions[$new_permission] = [
					'lang' => 'ACL_' . strtoupper($new_permission),
					'cat' => $category,
				];
			}

			$event['permissions'] = $permissions;
		}
	}
}
