<?php

/**
 *
 * @package phpBB Extension - mChat Icons Menu
 * @copyright (c) 2016 kasimi - https://kasimi.net
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace kasimi\mchaticonsmenu\event;

use dmzx\mchat\core\settings;
use phpbb\user;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

abstract class base implements EventSubscriberInterface
{
	/** @var user */
	protected $user;

	/** @var settings */
	protected $settings;

	/** @var array */
	private $listener_config;

	/**
	 * Constructor
	 *
	 * @param user		$user
	 * @param settings	$settings
	 */
	public function __construct(
		user $user,
		settings $settings = null
	)
	{
		$this->user		= $user;
		$this->settings	= $settings;

		$this->listener_config = $this->get_listener_config();
	}

	/**
	 * @return mixed
	 */
	protected abstract function get_listener_config();

	/**
	 * @return array
	 */
	static public function getSubscribedEvents()
	{
		return array(
			'dmzx.mchat.ucp_settings_modify'							=> 'ucp_settings_modify',
			'core.acp_users_prefs_modify_template_data'					=> array('acp_add_lang', 10),
			'dmzx.mchat.acp_globalusersettings_modify_template_data'	=> array('acp_add_lang', 10),
			'dmzx.mchat.ucp_modify_template_data'						=> array('ucp_add_lang', 10),
			'core.permissions'											=> array('permissions', -10),
		);
	}

	/**
	 * @param Event $event
	 */
	public function acp_add_lang($event)
	{
		$this->add_lang('acp');
	}

	/**
	 * @param Event $event
	 */
	public function ucp_add_lang($event)
	{
		$this->add_lang('ucp');
	}

	/**
	 * @param string $panel
	 */
	protected function add_lang($panel)
	{
		if ($this->settings !== null && !empty($this->listener_config['lang'][$panel]))
		{
			call_user_func_array(array($this->user, 'add_lang_ext'), $this->listener_config['lang'][$panel]);
		}
	}

	/**
	 * @param object $event
	 */
	public function ucp_settings_modify($event)
	{
		if ($this->settings !== null && !empty($this->listener_config['settings']['ucp']))
		{
			$ucp_settings = array();

			foreach ($this->listener_config['settings']['ucp'] as $setting_name => $setting_config)
			{
				$ucp_settings[$setting_name] = array('default' => $setting_config['default']);
			}

			$event['ucp_settings'] = array_merge($event['ucp_settings'], $ucp_settings);
		}
	}

	/**
	 * @param Event $event
	 */
	public function permissions($event)
	{
		if ($this->settings !== null && !empty($event['categories']['mchat_user_config']) && !empty($this->listener_config['settings']['ucp']))
		{
			$permissions = $event['permissions'];

			foreach (array_keys($this->listener_config['settings']['ucp']) as $setting_name)
			{
				$permissions['u_' . $setting_name] = array(
					'lang'	=> 'ACL_U_' . strtoupper($setting_name),
					'cat'	=> 'mchat_user_config',
				);
			}

			$event['permissions'] = $permissions;
		}
	}
}
