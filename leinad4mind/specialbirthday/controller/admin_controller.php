<?php
/**
*
* @package Registration Age Check
* @copyright (c) 2016 david63
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace david63\registrationage\controller;

use phpbb\config\config;
use phpbb\request\request;
use phpbb\template\template;
use phpbb\user;
use phpbb\language\language;
use phpbb\log\log;
use david63\registrationage\core\functions;

/**
* Admin controller
*/
class admin_controller implements admin_interface
{
	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\request\request */
	protected $request;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\user */
	protected $user;

	/** @var \phpbb\language\language */
	protected $language;

	/** @var \phpbb\log\log */
	protected $log;

	/** @var \david63\registrationage\core\functions */
	protected $functions;

	/** @var string custom constants */
	protected $rpconstants;

	/** @var string Custom form action */
	protected $u_action;

	/**
	* Constructor for admin controller
	*
	* @param \phpbb\config\config						$config		Config object
	* @param \phpbb\request\request						$request	Request object
	* @param \phpbb\template\template					$template	Template object
	* @param \phpbb\user								$user		User object
	* @param \phpbb\language\language					$language	Language object
	* @param \phpbb\log\log								$log		Log object
	* @param \david63\registrationage\core\functions	$functions	Functions for the extension
	* @param array	                            		$constants	Constants
	*
	* @return \david63\registrationage\controller\admin_controller
	* @access public
	*/
	public function __construct(config $config, request $request, template $template, user $user, language $language, log $log, functions $functions, $rpconstants)
	{
		$this->config		= $config;
		$this->request		= $request;
		$this->template		= $template;
		$this->user			= $user;
		$this->language		= $language;
		$this->log			= $log;
		$this->functions	= $functions;
		$this->constants	= $rpconstants;
	}

	/**
	* Display the options a user can configure for this extension
	*
	* @return null
	* @access public
	*/
	public function display_options()
	{
		// Add the language file
		$this->language->add_lang('acp_registrationage', $this->functions->get_ext_namespace());

		// Create a form key for preventing CSRF attacks
		add_form_key($this->constants['form_key']);

		$back = false;

		// Is the form being submitted
		if ($this->request->is_set_post('submit'))
		{
			// Is the submitted form is valid
			if (!check_form_key($this->constants['form_key']))
			{
				trigger_error($this->language->lang('FORM_INVALID') . adm_back_link($this->u_action), E_USER_WARNING);
			}

			// If no errors, process the form data
			// Set the options the user configured
			$this->set_options();

			// Add option settings change action to the admin log
			$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'REGISTRATION_AGE_LOG');

			// Option settings have been updated and logged
			// Confirm this to the user and provide link back to previous page
			trigger_error($this->language->lang('CONFIG_UPDATED') . adm_back_link($this->u_action));
		}

		// Create the ban end select options
		$ban_end_options = '';
		foreach ($this->language->lang_raw('BAN_END_TEXT') as $key => $ban_opt)
		{
			$selected = ($this->config['registration_age_ban_length'] == $key) ? ' selected="selected"' : '';
			$ban_end_options .= '<option value="' . $key . '"' . $selected . '>' . $ban_opt . '</option>';
		}

		$ban_opts = '<select name="registration_age_ban_length" id="registration_age_ban_length">' . $ban_end_options . '</select>';

		// Template vars for header panel
		$this->template->assign_vars(array(
			'HEAD_TITLE'		=> $this->language->lang('REGISTRATION_AGE'),
			'HEAD_DESCRIPTION'	=> $this->language->lang('REGISTRATION_AGE_EXPLAIN'),

			'NAMESPACE'			=> $this->functions->get_ext_namespace('twig'),

			'S_BACK'			=> $back,
			'S_VERSION_CHECK'	=> $this->functions->version_check(),

			'VERSION_NUMBER'	=> $this->functions->get_this_version(),
		));

		// Set output vars for display in the template
		$this->template->assign_vars(array(
			'REGISTRATION_AGE'				=> isset($this->config['registration_age']) ? $this->config['registration_age'] : '',
			'REGISTRATION_AGE_ADMIN'		=> isset($this->config['registration_age_admin']) ? $this->config['registration_age_admin'] : '',
			'REGISTRATION_AGE_BAN_LENGTH'	=> $ban_opts,
			'REGISTRATION_AGE_BAN_REASON'	=> isset($this->config['registration_age_ban_reason']) ? $this->config['registration_age_ban_reason'] : '',
			'REGISTRATION_AGE_COPY'			=> isset($this->config['registration_age_copy']) ? $this->config['registration_age_copy'] : '',
			'REGISTRATION_AGE_DISPLAY'		=> isset($this->config['registration_age_display']) ? $this->config['registration_age_display'] : '',
			'REGISTRATION_AGE_IP'			=> isset($this->config['registration_age_ip']) ? $this->config['registration_age_ip'] : '',
			'REGISTRATION_AGE_LOG'			=> isset($this->config['registration_age_log']) ? $this->config['registration_age_log'] : '',
			'REGISTRATION_AGE_STORE'		=> isset($this->config['registration_age_store']) ? $this->config['registration_age_store'] : '',

			'U_ACTION'						=> $this->u_action,
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
		$this->config->set('registration_age', $this->request->variable('registration_age', 18));
		$this->config->set('registration_age_admin', $this->request->variable('registration_age_admin', 0));
		$this->config->set('registration_age_ban_length', $this->request->variable('registration_age_ban_length', 0));
		$this->config->set('registration_age_ban_reason', $this->request->variable('registration_age_ban_reason', ''));
		$this->config->set('registration_age_copy', $this->request->variable('registration_age_copy', 0));
		$this->config->set('registration_age_display', $this->request->variable('registration_age_display', 0));
		$this->config->set('registration_age_ip', $this->request->variable('registration_age_ip', 0));
		$this->config->set('registration_age_log', $this->request->variable('registration_age_log', 1));
		$this->config->set('registration_age_store', $this->request->variable('registration_age_store', 1));
	}
}
