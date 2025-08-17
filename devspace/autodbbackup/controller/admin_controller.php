<?php
/**
 *
 * @package Auto db Backup
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
class admin_controller
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

	/** @var string */
	protected $ext_images_path;

	/** @var string Custom form action */
	protected $u_action;

	/** @var int Backup date */
	protected $backup_date;

	/**
	 * Constructor for admin controller
	 *
	 * @param \phpbb\config\config                   $config             Config object
	 * @param \phpbb\request\request                 $request            Request object
	 * @param \phpbb\template\template               $template           Template object
	 * @param \phpbb\user                            $user               User object
	 * @param \phpbb\log\log                         $log                Log object
	 * @param \phpbb\language\language               $language           Language object
	 * @param \david63\autodbbackup\core\functions   functions           Functions for the extension
	 * @param string                                 $ext_images_path    Path to this extension's images
	 *
	 * @return \david63\autodbbackup\controller\admin_controller
	 * @access public
	 */
	public function __construct(config $config, request $request, template $template, user $user, log $log, language $language, functions $functions, string $ext_images_path)
	{
		$this->config          = $config;
		$this->request         = $request;
		$this->template        = $template;
		$this->user            = $user;
		$this->log             = $log;
		$this->language        = $language;
		$this->functions       = $functions;
		$this->ext_images_path = $ext_images_path;
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
		$this->language->add_lang(array('acp_autobackup', 'acp_common'), $this->functions->get_ext_namespace());

		// Need to do some timezone checking before we go any further
		// Does the user have a timezone set?
		if (!$this->user->data['user_timezone'])
		{
			trigger_error($this->language->lang('NO_TIMEZONE_SET'), E_USER_WARNING);
		}

		// Is the user's timezone valid?
		// This should never happen!
		if (!in_array($this->user->data['user_timezone'], timezone_identifiers_list()))
		{
			trigger_error($this->language->lang('INVALID_USER_TIMEZONE'), E_USER_WARNING);
		}

		// Is there a valid timezone in php.ini?
		if (!in_array(ini_get('date.timezone'), timezone_identifiers_list()))
		{
			trigger_error($this->language->lang('INVALID_PHP_TIMEZONE'), E_USER_WARNING);
		}

		// Create a form key for preventing CSRF attacks
		$form_key = 'auto_db_backup';
		add_form_key($form_key);

		$back = false;

		// Let's do some timezone manipulation
		$utc_offset  = $this->functions->get_utc_offset();
		$user_dtz    = new \DateTimeZone($this->user->data['user_timezone']);
		$user_offset = $user_dtz->getOffset(new \DateTime);
		$user_offset = ($user_offset > 0) ? $user_offset : 0;

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

			if ($this->request->variable('auto_db_backup_enable', 0) && (($this->backup_date - $user_offset) <= (time() - $utc_offset)))
			{
				trigger_error($this->language->lang('AUTO_DB_BACKUP_TIME_ERROR') . adm_back_link($this->u_action), E_USER_WARNING);
			}

			// Set the options the user has configured
			$this->backup_date = ($this->backup_date - $user_offset + $utc_offset);
			$this->set_options();

			// Add option settings change action to the admin log
			$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_AUTO_DB_BACKUP_SETTINGS');
			trigger_error($this->language->lang('AUTO_DB_BACKUP_SETTINGS_CHANGED') . adm_back_link($this->u_action));
		}

		// Template vars for header panel
		$version_data = $this->functions->version_check();

		// Are the PHP and phpBB versions valid for this extension?
		$valid = $this->functions->ext_requirements();

		$this->template->assign_vars(array(
			'DOWNLOAD' 			=> (array_key_exists('download', $version_data)) ? '<a class="download" href =' . $version_data['download'] . '>' . $this->language->lang('NEW_VERSION_LINK') . '</a>' : '',

			'EXT_IMAGE_PATH'	=> $this->ext_images_path,

			'HEAD_TITLE' 		=> $this->language->lang('AUTO_DB_BACKUP_SETTINGS'),
			'HEAD_DESCRIPTION' 	=> $this->language->lang('AUTO_DB_BACKUP_SETTINGS_EXPLAIN'),

			'NAMESPACE' 		=> $this->functions->get_ext_namespace('twig'),

			'PHP_VALID' 		=> $valid[0],
			'PHPBB_VALID' 		=> $valid[1],

			'S_BACK' 			=> $back,
			'S_VERSION_CHECK' 	=> (array_key_exists('current', $version_data)) ? $version_data['current'] : false,

			'VERSION_NUMBER' 	=> $this->functions->get_meta('version'),
		));

		// Output the page
		$this->get_filetypes();

		$this->template->assign_vars(array(
			'AUTO_DB_BACKUP_COPIES' 		=> $this->config['auto_db_backup_copies'],
			'AUTO_DB_BACKUP_GC' 			=> $this->config['auto_db_backup_gc'],
			'AUTO_DB_BACKUP_MAINTAIN_FREQ'	=> $this->config['auto_db_backup_maintain_freq'],

			'NEXT_BACKUP_TIME' 				=> date('d-m-Y H:i', $this->config['auto_db_backup_next_gc'] + $user_offset - $utc_offset),

			'RTL_LANGUAGE' 					=> ($this->language->lang('DIRECTION') == 'rtl') ? true : false,

			'S_AUTO_DB_BACKUP_ENABLE' 		=> $this->config['auto_db_backup_enable'],
			'S_AUTO_DB_BACKUP_OPTIMIZE' 	=> $this->config['auto_db_backup_optimize'],

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
		$this->config->set('auto_db_backup_copies', $this->request->variable('auto_db_backup_copies', 0));
		$this->config->set('auto_db_backup_enable', $this->request->variable('auto_db_backup_enable', 0));
		$this->config->set('auto_db_backup_filetype', $this->request->variable('auto_db_backup_filetype', 'text'));
		$this->config->set('auto_db_backup_gc', $this->request->variable('auto_db_backup_gc', 0));
		$this->config->set('auto_db_backup_next_gc', $this->backup_date, 0);
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
			$filetypes['gzip'] = $this->language->lang(array('FILETYPE', 'gzip'));
		}

		if (@extension_loaded('bz2'))
		{
			$filetypes['bzip2'] = $this->language->lang(array('FILETYPE', 'bzip2'));
		}

		$filetypes['text'] = $this->language->lang(array('FILETYPE', 'text'));

		foreach ($filetypes as $filetype => $value)
		{
			$this->template->assign_block_vars('filetypes', array(
				'FILETYPE' => $filetype,
				'VALUE' => $value,
				'S_CHECKED' => ($this->config['auto_db_backup_filetype'] == $filetype) ? true : false,
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
