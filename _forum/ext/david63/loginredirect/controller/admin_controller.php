<?php
/**
*
* @package User Login Redirect
* @copyright (c) 2014 david63
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace david63\loginredirect\controller;

use phpbb\config\config;
use phpbb\request\request;
use phpbb\db\driver\driver_interface;
use phpbb\template\template;
use phpbb\user;
use phpbb\log\log;
use phpbb\language\language;
use david63\loginredirect\core\functions;

/**
* Admin controller
*/
class admin_controller implements admin_interface
{
	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\request\request */
	protected $request;

	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\user */
	protected $user;

	/** @var \phpbb\log\log */
	protected $log;

	/** @var \phpbb\language\language */
	protected $language;

	/** @var \david63\loginredirect\core\functions */
	protected $functions;

	/** @var string phpBB tables */
	protected $tables;

	/** @var string Custom form action */
	protected $u_action;

	/**
	* Constructor for admin controller
	*
	* @param \phpbb\config\config					$config		Config object
	* @param \phpbb\request\request					$request	Request object
	* @param \phpbb\db\driver\driver_interface		$db			Database object
	* @param \phpbb\template\template				$template	Template object
	* @param \phpbb\user							$user		User object
	* @param \phpbb\log\log							$log		Log object
	* @param \phpbb\language\language				$language	Language object
	* @param \david63\loginredirect\core\functions	functions	Functions for the extension
	* @param array									$tables		phpBB db tables
	*
	* @return \david63\loginredirect\controller\admin_controller
	* @access public
	*/
	public function __construct(config $config, request $request, driver_interface $db, template $template, user $user, log $log, language $language, functions $functions, $tables)
	{
		$this->config		= $config;
		$this->request		= $request;
		$this->db			= $db;
		$this->template		= $template;
		$this->user	   		= $user;
		$this->log			= $log;
		$this->language		= $language;
		$this->functions	= $functions;
		$this->tables		= $tables;
	}

	/**
	* Display the options a user can configure for this extension
	*
	* @return null
	* @access public
	*/
	public function display_options()
	{
		// Add the language files
		$this->language->add_lang(array('acp_loginredirect', 'acp_common'), $this->functions->get_ext_namespace());

		// Create a form key for preventing CSRF attacks
		$form_key = 'login_redirect';
		add_form_key($form_key);

		$back = false;

		// Is the form being submitted
		if ($this->request->is_set_post('submit'))
		{
			// Is the submitted form is valid
			if (!check_form_key($form_key))
			{
				trigger_error($this->language->lang('FORM_INVALID') . adm_back_link($this->u_action), E_USER_WARNING);
			}

			// Check that the entered topics are valid
			$this->topic_valid($this->request->variable('redirect_announce_topic_id', ''), $this->language->lang('INVALID_ANNOUNCEMENT_TOPIC'));
			$this->topic_valid($this->request->variable('redirect_welcome_topic_id', ''), $this->language->lang('INVALID_WELCOME_TOPIC'));
			$this->topic_valid($this->request->variable('redirect_group_topic_id', ''), $this->language->lang('INVALID_GROUP_TOPIC'));

			// If no errors, process the form data
			// Set the options the user configured
			$this->set_options();

			// Add option settings change action to the admin log
			$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_LOGIN_REDIRECT');

			// Option settings have been updated and logged
			// Confirm this to the user and provide link back to previous page
			trigger_error($this->language->lang('CONFIG_UPDATED') . adm_back_link($this->u_action));
		}

		// Template vars for header panel
		$version_data	= $this->functions->version_check();

		$this->template->assign_vars(array(
			'DOWNLOAD'			=> (array_key_exists('download', $version_data)) ? '<a class="download" href =' . $version_data['download'] . '>' . $this->language->lang('NEW_VERSION_LINK') . '</a>' : '',

			'HEAD_TITLE'		=> $this->language->lang('REDIRECT_LOGIN'),
			'HEAD_DESCRIPTION'	=> $this->language->lang('REDIRECT_LOGIN_EXPLAIN'),

			'NAMESPACE'			=> $this->functions->get_ext_namespace('twig'),

			'S_BACK'			=> $back,
			'S_VERSION_CHECK'	=> (array_key_exists('current', $version_data)) ? $version_data['current'] : false,

			'VERSION_NUMBER'	=> $this->functions->get_meta('version'),
		));

		// Set output vars for display in the template
		$this->template->assign_vars(array(
			'REDIRECT_ALWAYS'				=> isset($this->config['redirect_always']) ? $this->config['redirect_always'] : '',
			'REDIRECT_ANNOUNCE'				=> isset($this->config['redirect_announce']) ? $this->config['redirect_announce'] : '',
			'REDIRECT_ANNOUNCE_PRIORITY'	=> isset($this->config['redirect_announce_priority']) ? $this->config['redirect_announce_priority'] : '',
			'REDIRECT_ANNOUNCE_REFRESH'		=> isset($this->config['redirect_announce_refresh']) ? $this->config['redirect_announce_refresh'] : '',
			'REDIRECT_ANNOUNCE_TOPIC_ID'	=> isset($this->config['redirect_announce_topic_id']) ? $this->config['redirect_announce_topic_id'] : '',
			'REDIRECT_ANY_ANNOUNCE'			=> isset($this->config['redirect_any_announce']) ? $this->config['redirect_any_announce'] : '',
			'REDIRECT_ENABLED'				=> isset($this->config['redirect_enabled']) ? $this->config['redirect_enabled'] : '',
			'REDIRECT_GLOBAL'				=> isset($this->config['redirect_global']) ? $this->config['redirect_global'] : '',
			'REDIRECT_GROUP'				=> isset($this->config['redirect_group']) ? $this->config['redirect_group'] : '',
			'REDIRECT_GROUP_ALL'			=> isset($this->config['redirect_group_all']) ? $this->config['redirect_group_all'] : '',
			'REDIRECT_GROUP_REFRESH'		=> isset($this->config['redirect_group_refresh']) ? $this->config['redirect_group_refresh'] : '',
			'REDIRECT_GROUP_TOPIC_ID'		=> isset($this->config['redirect_group_topic_id']) ? $this->config['redirect_group_topic_id'] : '',
			'REDIRECT_WELCOME'				=> isset($this->config['redirect_welcome']) ? $this->config['redirect_welcome'] : '',
			'REDIRECT_WELCOME_REFRESH'		=> isset($this->config['redirect_welcome_refresh']) ? $this->config['redirect_welcome_refresh'] : '',
			'REDIRECT_WELCOME_TOPIC_ID'		=> isset($this->config['redirect_welcome_topic_id']) ? $this->config['redirect_welcome_topic_id'] : '',

			'S_REDIRECT_GROUP_OPTIONS'		=> group_select_options($this->config['redirect_group_id'], false, false),

			'U_ACTION' 						=> $this->u_action,
		));
	}

	/**
	* Set the options a user can configure
	*
	* @return null
	* @access protected
	*/
	protected function set_options()
	{
		$this->config->set('redirect_always', $this->request->variable('redirect_always', 0));
		$this->config->set('redirect_announce', $this->request->variable('redirect_announce', 0));
		$this->config->set('redirect_announce_priority', $this->request->variable('redirect_announce_priority', 0));
		$this->config->set('redirect_announce_refresh', $this->request->variable('redirect_announce_refresh', 0));
		$this->config->set('redirect_announce_topic_id', $this->request->variable('redirect_announce_topic_id', ''));
		$this->config->set('redirect_any_announce', $this->request->variable('redirect_any_announce', 0));
		$this->config->set('redirect_enabled', $this->request->variable('redirect_enabled', 0));
		$this->config->set('redirect_global', $this->request->variable('redirect_global', 0));
		$this->config->set('redirect_group', $this->request->variable('redirect_group', 0));
		$this->config->set('redirect_group_all', $this->request->variable('redirect_group_all', 0));
		$this->config->set('redirect_group_id', $this->request->variable('redirect_group_id', 0));
		$this->config->set('redirect_group_refresh', $this->request->variable('redirect_group_refresh', 0));
		$this->config->set('redirect_group_topic_id', $this->request->variable('redirect_group_topic_id', ''));
		$this->config->set('redirect_welcome', $this->request->variable('redirect_welcome', 0));
		$this->config->set('redirect_welcome_refresh', $this->request->variable('redirect_welcome_refresh', 0));
		$this->config->set('redirect_welcome_topic_id', $this->request->variable('redirect_welcome_topic_id', ''));
	}

	/**
	* Validate a topic
	*
	* @return null
	* @access protected
	*/
	protected function topic_valid($topic_id, $error_message)
	{
		if ($topic_id <> '')
		{
			$sql = 'SELECT topic_id
				FROM ' . $this->tables['topics'] . '
					WHERE topic_id = ' . (int) $topic_id;

			$result	= $this->db->sql_query($sql);
			$row	= $this->db->sql_fetchrow($result);

			$this->db->sql_freeresult($result);

			if (!$row)
			{
				trigger_error($error_message . adm_back_link($this->u_action), E_USER_WARNING);
			}
		}
	}

	/**
	* Set page url
	*
	* @param string $u_action Custom form action
	* @return null
	* @access public
	*/
	public function set_page_url($u_action)
	{
		$this->u_action = $u_action;
	}
}
