<?php
/**
*
* @package Auto db Backup (3.2)
* @copyright (c) 2015 david63
* @license GNU General Public License, version 2 (GPL-2.0)
*
*/

namespace david63\autodbbackup\controller;

use \phpbb\config\config;
use \phpbb\request\request;
use \phpbb\template\template;
use \phpbb\user;
use \phpbb\log\log;
use \phpbb\language\language;
use \david63\autodbbackup\ext;

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

	/** @var phpbb\language\language */
	protected $language;

	/** @var string Custom form action */
	protected $u_action;

	protected $backup_date;

	/**
	* Constructor for admin controller
	*
	* @param \phpbb\config\config		$config		Config object
	* @param \phpbb\request\request		$request	Request object
	* @param \phpbb\template\template	$template	Template object
	* @param \phpbb\user				$user		User object
	* @param \phpbb\log\log				$log		Log object
	* @param \phpbb\language\language	$language	Language object
	*
	* @return \david63\autodbbackup\controller\admin_controller
	* @access public
	*/
	public function __construct(config $config, request $request, template $template, user $user, log $log, language $language)
	{
		$this->config	= $config;
		$this->request	= $request;
		$this->template	= $template;
		$this->user		= $user;
		$this->log		= $log;
		$this->language	= $language;
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
		$this->language->add_lang('acp_autobackup', 'david63/autodbbackup');

		// Create a form key for preventing CSRF attacks
		$form_key = 'auto_db_backup';
		add_form_key($form_key);

		$this->get_filetypes();

		// Make sure that the correct timezone is being used for the board
		date_default_timezone_set($this->user->data['user_timezone']);
		$time = time();

		// Submit
		if ($this->request->is_set_post('submit'))
		{
			// Is the submitted form is valid?
			if (!check_form_key($form_key))
			{
				trigger_error($this->language->lang('FORM_INVALID') . adm_back_link($this->u_action), E_USER_WARNING);
			}

			// Get the date/time variables
			$day	= $this->request->variable('auto_db_backup_day', 0);
			$month	= $this->request->variable('auto_db_backup_month', 0);
			$year	= $this->request->variable('auto_db_backup_year', 0);
			$hour	= $this->request->variable('auto_db_backup_hour', 0);
			$minute	= $this->request->variable('auto_db_backup_minute', 0);
			$enable = $this->request->variable('auto_db_backup_enable', 0);

			$dst = date('I', $time);
			$this->backup_date = mktime($hour + $dst, $minute, 0, $month, $day, $year);

			// Let's do a bit of validation if not disabling
			if ($enable)
			{
				if (!checkdate($month, $day, $year))
				{
					trigger_error($this->language->lang('DATE_TIME_ERROR') . adm_back_link($this->u_action), E_USER_WARNING);
				}

				if ($this->backup_date <= $time)
				{
					trigger_error($this->language->lang('AUTO_DB_BACKUP_TIME_ERROR') . adm_back_link($this->u_action), E_USER_WARNING);
				}
			}

			// Set the options the user has configured
			$this->set_options();

			// Add option settings change action to the admin log
			$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_AUTO_DB_BACKUP_SETTINGS');
			trigger_error($this->language->lang('AUTO_DB_BACKUP_SETTINGS_CHANGED') . adm_back_link($this->u_action));
		}

		$next_backup_date = ($this->config['auto_db_backup_last_gc'] < $time) ? getdate($this->config['auto_db_backup_last_gc'] + $this->config['auto_db_backup_gc']) : getdate($this->config['auto_db_backup_last_gc']);

		// Output the page
		$this->template->assign_vars(array(
			'AUTO_DB_BACKUP_COPIES'		=> $this->config['auto_db_backup_copies'],
			'AUTO_DB_BACKUP_DAY' 		=> $next_backup_date['mday'],
			'AUTO_DB_BACKUP_GC'			=> $this->config['auto_db_backup_gc'] / ext::seconds,
			'AUTO_DB_BACKUP_HOUR' 		=> $next_backup_date['hours'],
			'AUTO_DB_BACKUP_MINUTE' 	=> $next_backup_date['minutes'],
			'AUTO_DB_BACKUP_MONTH' 		=> $next_backup_date['mon'],
			'AUTO_DB_BACKUP_VERSION'	=> ext::AUTO_DB_BACKUP_VERSION,
			'AUTO_DB_BACKUP_YEAR' 		=> $next_backup_date['year'],

			'S_AUTO_DB_BACKUP_ENABLE'	=> $this->config['auto_db_backup_enable'],
			'S_AUTO_DB_BACKUP_OPTIMIZE'	=> $this->config['auto_db_backup_optimize'],

			'U_ACTION'					=> $this->u_action,
			
			'YEAR_START' 				=> $next_backup_date['year'],
			'YEAR_END' 					=> $next_backup_date['year'] + 1,
		));
	}

	protected function set_options()
	{
		$this->config->set('auto_db_backup_copies', $this->request->variable('auto_db_backup_copies', 0));
		$this->config->set('auto_db_backup_enable', $this->request->variable('auto_db_backup_enable', 0));
		$this->config->set('auto_db_backup_filetype', $this->request->variable('auto_db_backup_filetype', 'text'));
		$this->config->set('auto_db_backup_gc', $this->request->variable('auto_db_backup_gc', 0) * ext::seconds);
		$this->config->set('auto_db_backup_last_gc', $this->backup_date - ($this->request->variable('auto_db_backup_gc', 0) * ext::seconds), 0);
		$this->config->set('auto_db_backup_optimize', $this->request->variable('auto_db_backup_optimize', 0));
		$this->config->set('auto_db_backup_timezone', $this->user->data['user_timezone'], '');
	}

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
}
