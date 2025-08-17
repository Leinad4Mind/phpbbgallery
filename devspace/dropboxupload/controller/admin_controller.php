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
class admin_controller
{
	/** @var config */
	protected $config;

	/** @var request */
	protected $request;

	/** @var template */
	protected $template;

	/** @var user */
	protected $user;

	/** @var language */
	protected $language;

	/** @var log */
	protected $log;

	/** @var functions */
	protected $functions;

	/** @var string */
	protected $ext_images_path;

	/** @var string Custom form action */
	protected $u_action;

	/**
	 * Constructor for admin controller
	 *
	 * @param config		$config     		Config object
	 * @param request		$request    		Request object
	 * @param template		$template   		Template object
	 * @param user			$user       		User object
	 * @param language		$language   		Language object
	 * @param log			$log        		Log object
	 * @param functions		$functions			Functions for the extension
	 * @param string		$ext_images_path	Path to this extension's images
	 *
	 * @return \david63\dropboxupload\controller\admin_controller
	 * @access public
	 */
	public function __construct(config $config, request $request, template $template, user $user, language $language, log $log, functions $functions, string $ext_images_path)
	{
		$this->config    		= $config;
		$this->request   		= $request;
		$this->template  		= $template;
		$this->user      		= $user;
		$this->language  		= $language;
		$this->log       		= $log;
		$this->functions 		= $functions;
		$this->ext_images_path	= $ext_images_path;
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
		$this->language->add_lang(['acp_dropboxupload', 'acp_common'], $this->functions->get_ext_namespace());
		$this->language->add_lang('acp_common', $this->functions->get_ext_namespace());

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
		$version_data = $this->functions->version_check();

		// Are the PHP and phpBB versions valid for this extension?
		$valid = $this->functions->ext_requirements();

		$this->template->assign_vars([
			'DOWNLOAD' 			=> (array_key_exists('download', $version_data)) ? '<a class="download" href =' . $version_data['download'] . '>' . $this->language->lang('NEW_VERSION_LINK') . '</a>' : '',

			'EXT_IMAGE_PATH'	=> $this->ext_images_path,

			'HEAD_TITLE' 		=> $this->language->lang('DROPBOX_UPLOAD'),
			'HEAD_DESCRIPTION'	=> $this->language->lang('DROPBOX_UPLOAD_EXPLAIN'),

			'NAMESPACE' 		=> $this->functions->get_ext_namespace('twig'),

			'PHP_VALID' 		=> $valid[0],
			'PHPBB_VALID' 		=> $valid[1],

			'S_BACK' 			=> $back,
			'S_VERSION_CHECK' 	=> (array_key_exists('current', $version_data)) ? $version_data['current'] : false,

			'VERSION_NUMBER' 	=> $this->functions->get_meta('version'),
		]);

		// Set output vars for display in the template
		$this->template->assign_vars([
			'DROPBOX_FOLDER' 			=> isset($this->config['dropbox_folder']) ? $this->config['dropbox_folder'] : '',
			'DROPBOX_FOLDER_OPTIONS'	=> $folder_opts,
			'DROPBOX_FREQUENCY' 		=> isset($this->config['dropbox_frequency_interval']) ? $this->config['dropbox_frequency_interval'] : '',
			'DROPBOX_KEY' 				=> isset($this->config['dropbox_key']) ? $this->config['dropbox_key'] : '',
			'DROPBOX_SECRET' 			=> isset($this->config['dropbox_secret']) ? $this->config['dropbox_secret'] : '',
			'DROPBOX_TOKEN' 			=> isset($this->config['dropbox_token']) ? $this->config['dropbox_token'] : '',
			'DROPBOX_UPLOAD_ENABLED' 	=> isset($this->config['dropbox_upload_enable']) ? $this->config['dropbox_upload_enable'] : '',

			'U_ACTION' => $this->u_action,
		]);
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
