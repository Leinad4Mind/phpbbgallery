<?php
/**
*
* @package Dropbox Upload
* @copyright (c) 2016 david63
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace david63\dropboxupload\controller;

use phpbb\config\config;
use phpbb\request\request;
use phpbb\template\template;
use phpbb\user;
use phpbb\language\language;
use phpbb\log\log;
use david63\dropboxupload\core\functions;

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

	/** @var \david63\dropboxupload\core\functions */
	protected $functions;

	/** @var string Custom form action */
	protected $u_action;

	/**
	* Constructor for admin controller
	*
	* @param \phpbb\config\config					$config		Config object
	* @param \phpbb\request\request					$request	Request object
	* @param \phpbb\template\template				$template	Template object
	* @param \phpbb\user							$user		User object
	* @param \phpbb\language\language				$language	Language object
	* @param \phpbb\log\log							$log		Log object
	* @param \david63\dropboxupload\core\functions	functions	Functions for the extension
	*
	* @return \david63\dropboxupload\controller\admin_controller
	* @access public
	*/
	public function __construct(config $config, request $request, template $template, user $user, language $language, log $log, functions $functions)
	{
		$this->config		= $config;
		$this->request		= $request;
		$this->template		= $template;
		$this->user			= $user;
		$this->language		= $language;
		$this->log			= $log;
		$this->functions	= $functions;
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
		$this->language->add_lang('acp_dropboxupload', $this->functions->get_ext_namespace());

		// Create a form key for preventing CSRF attacks
		$form_key = 'dropboxupload_manage';
		add_form_key($form_key);

		$back = false;

		// Is the form being submitted?
		if ($this->request->is_set_post('submit'))
		{
			// Is the submitted form is valid?
			if (!check_form_key($form_key))
			{
				trigger_error($this->language->lang('FORM_INVALID') . adm_back_link($this->u_action), E_USER_WARNING);
			}

			// If no errors, process the form data
			// Set the options the user configured
			$this->set_options();

			// Add option settings change action to the admin log
			$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'DROPBOX_UPLOAD_LOG');

			// Option settings have been updated and logged
			// Confirm this to the user and provide link back to previous page
			trigger_error($this->language->lang('CONFIG_UPDATED') . adm_back_link($this->u_action));
		}

		$folder_options = '';
		foreach ($this->language->lang_raw('dbx_folder_opts') as $key => $folder_opt)
		{
			$selected = ($this->config['dropbox_folder_opt'] == $key) ? ' selected="selected"' : '';
			$folder_options .= '<option value="' . $key . '"' . $selected . '>' . $folder_opt . '</option>';
		}

		$folder_opts = '<select name="dropbox_folder_opt" id="dropbox_folder_opt">' . $folder_options . '</select>';

		// Template vars for header panel
		$this->template->assign_vars(array(
			'HEAD_TITLE'		=> $this->language->lang('DROPBOX_UPLOAD'),
			'HEAD_DESCRIPTION'	=> $this->language->lang('DROPBOX_UPLOAD_EXPLAIN'),

			'NAMESPACE'			=> $this->functions->get_ext_namespace('twig'),

			'S_BACK'			=> $back,
			'S_VERSION_CHECK'	=> $this->functions->version_check(),

			'VERSION_NUMBER'	=> $this->functions->get_this_version(),
		));

		// Set output vars for display in the template
		$this->template->assign_vars(array(
			'DROPBOX_FOLDER'			=> isset($this->config['dropbox_folder']) ? $this->config['dropbox_folder'] : '',
			'DROPBOX_FOLDER_OPTIONS'	=> $folder_opts,
			'DROPBOX_FREQUENCY'			=> isset($this->config['dropbox_frequency_interval']) ? $this->config['dropbox_frequency_interval'] : '',
			'DROPBOX_KEY'				=> isset($this->config['dropbox_key']) ? $this->config['dropbox_key'] : '',
			'DROPBOX_SECRET'			=> isset($this->config['dropbox_secret']) ? $this->config['dropbox_secret'] : '',
			'DROPBOX_TOKEN'				=> isset($this->config['dropbox_token']) ? $this->config['dropbox_token'] : '',
			'DROPBOX_UPLOAD_ENABLED'	=> isset($this->config['dropbox_upload_enable']) ? $this->config['dropbox_upload_enable'] : '',

			'U_ACTION' 					=> $this->u_action,
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
		$this->config->set('dropbox_folder', $this->request->variable('dropbox_folder', '', true));
		$this->config->set('dropbox_folder_opt', $this->request->variable('dropbox_folder_opt', '', true));
		$this->config->set('dropbox_frequency_interval', $this->request->variable('dropbox_frequency_interval', 0));
		$this->config->set('dropbox_key', $this->request->variable('dropbox_key', '', true));
		$this->config->set('dropbox_secret', $this->request->variable('dropbox_secret', '', true));
		$this->config->set('dropbox_token', $this->request->variable('dropbox_token', '', true));
		$this->config->set('dropbox_upload_enable', $this->request->variable('dropbox_upload_enable', 0));
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
		return $this->u_action = $u_action;
	}
}
