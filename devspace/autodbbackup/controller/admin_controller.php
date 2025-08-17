<?php
/**
*
* @package Auto db Backup (3.2)
* @copyright (c) 2015 david63
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace david63\autodbbackup\controller;

use phpbb\config\config;
use phpbb\request\request;
use phpbb\template\template;
use phpbb\user;
use phpbb\log\log;
use phpbb\language\language;
use david63\autodbbackup\core\functions;

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

	/** @var \phpbb\log\log */
	protected $log;

	/** @var \phpbb\language\language */
	protected $language;

	/** @var \david63\autodbbackup\core\functions */
	protected $functions;

	/** @var string Custom form action */
	protected $u_action;

	/** @var int Backup date */
	protected $backup_date;

	/**
	* Constructor for admin controller
	*
	* @param \phpbb\config\config					$config		Config object
	* @param \phpbb\request\request					$request	Request object
	* @param \phpbb\template\template				$template	Template object
	* @param \phpbb\user							$user		User object
	* @param \phpbb\log\log							$log		Log object
	* @param \phpbb\language\language				$language	Language object
	* @param \david63\autodbbackup\core\functions	functions	Functions for the extension
	*
	* @return \david63\autodbbackup\controller\admin_controller
	* @access public
	*/
	public function __construct(config $config, request $request, template $template, user $user, log $log, language $language, functions $functions)
	{
		$this->config		= $config;
		$this->request		= $request;
		$this->template		= $template;
		$this->user			= $user;
		$this->log			= $log;
		$this->language		= $language;
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
		$this->language->add_lang('acp_autobackup', $this->functions->get_ext_namespace());

		// Create a form key for preventing CSRF attacks
		$form_key = 'auto_db_backup';
		add_form_key($form_key);

		$back = false;

		// Submit
		if ($this->request->is_set_post('submit'))
		{
			// Is the submitted form is valid?
			if (!check_form_key($form_key))
			{
				trigger_error($this->language->lang('FORM_INVALID') . adm_back_link($this->u_action), E_USER_WARNING);
			}

			// Let's check that we have a valid date & time and convert it to a timestamp so that we have a common value.
			if (($this->backup_date = strtotime($this->request->variable('auto_db_time', ''))) === false)
			{
				trigger_error($this->language->lang('DATE_FORMAT_ERROR') . adm_back_link($this->u_action), E_USER_WARNING);
			}

			if ($this->request->variable('auto_db_backup_enable', 0) && ($this->backup_date <= time()))
			{
				trigger_error($this->language->lang('AUTO_DB_BACKUP_TIME_ERROR') . adm_back_link($this->u_action), E_USER_WARNING);
			}

			// Set the options the user has configured
			$this->set_options();

			// Add option settings change action to the admin log
			$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_AUTO_DB_BACKUP_SETTINGS');
			trigger_error($this->language->lang('AUTO_DB_BACKUP_SETTINGS_CHANGED') . adm_back_link($this->u_action));
		}

		// Template vars for header panel
		$this->template->assign_vars(array(
			'HEAD_TITLE'		=> $this->language->lang('AUTO_DB_BACKUP_SETTINGS'),
			'HEAD_DESCRIPTION'	=> $this->language->lang('AUTO_DB_BACKUP_SETTINGS_EXPLAIN'),

			'NAMESPACE'			=> $this->functions->get_ext_namespace('twig'),

			'S_BACK'			=> $back,
			'S_VERSION_CHECK'	=> $this->functions->version_check(),

			'VERSION_NUMBER'	=> $this->functions->get_this_version(),
		));

		// Output the page
		$timezone = new \DateTimeZone($this->user->data['user_timezone']);
		$this->get_filetypes();

		$this->template->assign_vars(array(
			'AUTO_DB_BACKUP_COPIES'			=> $this->config['auto_db_backup_copies'],
			'AUTO_DB_BACKUP_GC'				=> $this->config['auto_db_backup_gc'],
			'AUTO_DB_BACKUP_MAINTAIN_FREQ'	=> $this->config['auto_db_backup_maintain_freq'],

			'NEXT_BACKUP_TIME'				=> date('d-m-Y H:i', $this->config['auto_db_backup_next_gc']),

			'TIMEZONE'						=>  $timezone->getOffset(new \DateTime) / 60, // In minutes

			'RTL_LANGUAGE'					=> ($this->language->lang('DIRECTION') == 'rtl') ? true : false,

			'S_AUTO_DB_BACKUP_ENABLE'		=> $this->config['auto_db_backup_enable'],
			'S_AUTO_DB_BACKUP_OPTIMIZE'		=> $this->config['auto_db_backup_optimize'],

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
		$this->config->set('auto_db_backup_copies', $this->request->variable('auto_db_backup_copies', 0));
		$this->config->set('auto_db_backup_enable', $this->request->variable('auto_db_backup_enable', 0));
		$this->config->set('auto_db_backup_filetype', $this->request->variable('auto_db_backup_filetype', 'text'));
		$this->config->set('auto_db_backup_gc', $this->request->variable('auto_db_backup_gc', 0));
		$this->config->set('auto_db_backup_next_gc', $this->backup_date);
		$this->config->set('auto_db_backup_maintain_freq', $this->request->variable('auto_db_backup_maintain_freq', 0));
		$this->config->set('auto_db_backup_optimize', $this->request->variable('auto_db_backup_optimize', 0));
	}

	/**
	* Create the filetype array
	*
	* @return template variables
	* @access protected
	*/
	protected function get_filetypes()
	{
		$filetypes = array();

		if (@extension_loaded('zlib'))
		{
			$filetypes['gzip'] = $this->language->lang(['FILETYPE', 'gzip']);
		}

		if (@extension_loaded('bz2'))
		{
			$filetypes['bzip2'] = $this->language->lang(['FILETYPE', 'bzip2']);
		}

		$filetypes['text'] = $this->language->lang(['FILETYPE', 'text']);

		foreach ($filetypes as $filetype => $value)
		{
			$this->template->assign_block_vars('filetypes', array(
				'FILETYPE'	=> $filetype,
				'VALUE'		=> $value,
				'S_CHECKED'	=> ($this->config['auto_db_backup_filetype'] == $filetype) ? true : false,
			));
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
		return $this->u_action = $u_action;
	}
}
