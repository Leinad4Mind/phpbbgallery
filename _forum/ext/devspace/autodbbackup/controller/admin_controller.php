<?php
/**
 *
 * @package Auto db Backup
 * @copyright (c) 2015 david63
 * @copyright (c) 2026 Leinad4Mind
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

namespace devspace\autodbbackup\controller;

use devspace\autodbbackup\core\backup_policy;
use devspace\autodbbackup\core\functions;
use phpbb\config\config;
use phpbb\language\language;
use phpbb\log\log;
use phpbb\request\request;
use phpbb\template\template;
use phpbb\user;

/**
 * ACP settings controller.
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

	/** @var log */
	protected $log;

	/** @var language */
	protected $language;

	/** @var functions */
	protected $functions;

	/** @var string */
	protected $u_action;

	/**
	 * @param config    $config Config object
	 * @param request   $request Request object
	 * @param template  $template Template object
	 * @param user      $user User object
	 * @param log       $log Log object
	 * @param language  $language Language object
	 * @param functions $functions Extension helpers
	 */
	public function __construct(config $config, request $request, template $template, user $user, log $log, language $language, functions $functions)
	{
		$this->config = $config;
		$this->request = $request;
		$this->template = $template;
		$this->user = $user;
		$this->log = $log;
		$this->language = $language;
		$this->functions = $functions;
	}

	/**
	 * Display and process extension settings.
	 */
	public function display_options()
	{
		$this->language->add_lang(array('acp_autobackup', 'acp_common'), $this->functions->get_ext_namespace());

		$timezone_name = isset($this->user->data['user_timezone']) ? $this->user->data['user_timezone'] : '';
		if ($timezone_name === '')
		{
			trigger_error($this->language->lang('NO_TIMEZONE_SET'), E_USER_WARNING);
		}

		if (!in_array($timezone_name, timezone_identifiers_list(), true))
		{
			trigger_error($this->language->lang('INVALID_USER_TIMEZONE'), E_USER_WARNING);
		}

		$user_timezone = new \DateTimeZone($timezone_name);
		$form_key = 'devspace/autodbbackup';
		add_form_key($form_key);
		$available_file_types = $this->get_available_file_types();

		if ($this->request->is_set_post('submit'))
		{
			if (!check_form_key($form_key))
			{
				trigger_error($this->language->lang('FORM_INVALID') . adm_back_link($this->u_action), E_USER_WARNING);
			}

			$settings = array(
				'copies'   => $this->request->variable('auto_db_backup_copies', 0),
				'enabled'  => $this->request->variable('auto_db_backup_enable', 0),
				'file_type' => $this->request->variable('auto_db_backup_filetype', 'text'),
				'interval' => $this->request->variable('auto_db_backup_gc', 0),
				'maintain' => $this->request->variable('auto_db_backup_maintain_freq', 0),
			);

			try
			{
				backup_policy::validate_settings($settings['interval'], $settings['copies'], $settings['enabled'], $settings['maintain'], $settings['file_type'], $available_file_types);
			}
			catch (\InvalidArgumentException $exception)
			{
				trigger_error($this->language->lang($exception->getMessage()) . adm_back_link($this->u_action), E_USER_WARNING);
			}

			$backup_date = backup_policy::parse_local_time($this->request->variable('auto_db_time', ''), $user_timezone);
			if ($backup_date === false)
			{
				trigger_error($this->language->lang('DATE_FORMAT_ERROR') . adm_back_link($this->u_action), E_USER_WARNING);
			}

			if ($settings['enabled'] && $backup_date <= time())
			{
				trigger_error($this->language->lang('AUTO_DB_BACKUP_TIME_ERROR') . adm_back_link($this->u_action), E_USER_WARNING);
			}

			$this->set_options($settings, $backup_date);
			$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_AUTO_DB_BACKUP_SETTINGS');
			trigger_error($this->language->lang('AUTO_DB_BACKUP_SETTINGS_CHANGED') . adm_back_link($this->u_action));
		}

		$version_data = $this->functions->version_check();
		$valid = $this->functions->ext_requirements();
		$download_url = isset($version_data['download']) ? (string) $version_data['download'] : '';
		if (parse_url($download_url, PHP_URL_SCHEME) !== 'https')
		{
			$download_url = '';
		}

		$this->assign_file_types($available_file_types);
		$this->template->assign_vars(array(
			'AUTO_DB_BACKUP_COPIES'        => (int) $this->config['auto_db_backup_copies'],
			'AUTO_DB_BACKUP_GC'            => (int) $this->config['auto_db_backup_gc'],
			'AUTO_DB_BACKUP_MAINTAIN_FREQ' => (bool) $this->config['auto_db_backup_maintain_freq'],
			'DOWNLOAD_URL'                  => $download_url,
			'HEAD_DESCRIPTION'              => $this->language->lang('AUTO_DB_BACKUP_SETTINGS_EXPLAIN'),
			'HEAD_TITLE'                    => $this->language->lang('AUTO_DB_BACKUP_SETTINGS'),
			'NAMESPACE'                     => $this->functions->get_ext_namespace('twig'),
			'NEXT_BACKUP_TIME'              => backup_policy::format_local_time((int) $this->config['auto_db_backup_next_gc'], $user_timezone),
			'PHP_VALID'                     => $valid[0],
			'PHPBB_VALID'                   => $valid[1],
			'S_AUTO_DB_BACKUP_ENABLE'       => (bool) $this->config['auto_db_backup_enable'],
			'S_BACK'                        => false,
			'S_VERSION_CHECK'               => isset($version_data['current']) ? $version_data['current'] : false,
			'U_ACTION'                      => $this->u_action,
			'VERSION_NUMBER'                => $this->functions->get_meta('version'),
		));
	}

	/**
	 * Store already validated settings.
	 *
	 * @param array $settings Validated settings
	 * @param int   $backup_date Next run timestamp
	 */
	protected function set_options(array $settings, $backup_date)
	{
		$this->config->set('auto_db_backup_copies', $settings['copies']);
		$this->config->set('auto_db_backup_enable', $settings['enabled']);
		$this->config->set('auto_db_backup_filetype', $settings['file_type']);
		$this->config->set('auto_db_backup_gc', $settings['interval']);
		$this->config->set('auto_db_backup_next_gc', $backup_date, true);
		$this->config->set('auto_db_backup_maintain_freq', $settings['maintain']);
	}

	/**
	 * @return array File types supported by this PHP installation
	 */
	protected function get_available_file_types()
	{
		$file_types = array('text');

		if (extension_loaded('zlib'))
		{
			$file_types[] = 'gzip';
		}

		if (extension_loaded('bz2'))
		{
			$file_types[] = 'bzip2';
		}

		return $file_types;
	}

	/**
	 * @param array $file_types Supported file types
	 */
	protected function assign_file_types(array $file_types)
	{
		foreach ($file_types as $file_type)
		{
			$this->template->assign_block_vars('filetypes', array(
				'FILETYPE' => $file_type,
				'S_CHECKED' => (string) $this->config['auto_db_backup_filetype'] === $file_type,
				'VALUE' => $this->language->lang(array('FILETYPE', $file_type)),
			));
		}
	}

	/**
	 * @param string $u_action ACP form action
	 */
	public function set_page_url($u_action)
	{
		$this->u_action = $u_action;
	}
}
