<?php
/**
 * @package Dropbox Upload
 * @copyright (c) 2016 david63
 * @license GNU General Public License, version 2 (GPL-2.0)
 */

namespace leinad4mind\dropboxupload\controller;

use leinad4mind\dropboxupload\core\functions;
use leinad4mind\dropboxupload\core\upload_policy;
use phpbb\config\config;
use phpbb\config\db_text;
use phpbb\language\language;
use phpbb\log\log;
use phpbb\request\request_interface;
use phpbb\template\template;
use phpbb\user;

class admin_controller
{
	protected $config;
	protected $config_text;
	protected $request;
	protected $template;
	protected $user;
	protected $language;
	protected $log;
	protected $functions;
	protected $u_action;

	public function __construct(config $config, db_text $config_text, request_interface $request, template $template, user $user, language $language, log $log, functions $functions)
	{
		$this->config = $config;
		$this->config_text = $config_text;
		$this->request = $request;
		$this->template = $template;
		$this->user = $user;
		$this->language = $language;
		$this->log = $log;
		$this->functions = $functions;
	}
	public function display_options()
	{
		$this->language->add_lang(array('acp_dropboxupload', 'acp_common'), $this->functions->get_ext_namespace());
		$form_key = 'leinad4mind_dropboxupload_manage';
		add_form_key($form_key);
		if ($this->request->is_set_post('submit'))
		{
			if (!check_form_key($form_key))
			{
				trigger_error($this->language->lang('FORM_INVALID') . adm_back_link($this->u_action), E_USER_WARNING);
			}
			try
			{
				$this->set_options();
			}
			catch (\InvalidArgumentException $exception)
			{
				trigger_error($this->language->lang($exception->getMessage()) . adm_back_link($this->u_action), E_USER_WARNING);
			}
			$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'DROPBOX_UPLOAD_LOG');
			trigger_error($this->language->lang('CONFIG_UPDATED') . adm_back_link($this->u_action));
		}

		$credentials = $this->get_credentials();
		$this->assign_header();
		$this->assign_options($credentials);
	}
	protected function assign_header()
	{
		$version = $this->functions->version_check();
		$download = isset($version['download']) && filter_var($version['download'], FILTER_VALIDATE_URL) && parse_url($version['download'], PHP_URL_SCHEME) === 'https' ? $version['download'] : '';
		$this->template->assign_vars(array(
			'HEAD_TITLE' => $this->language->lang('DROPBOX_UPLOAD'),
			'HEAD_DESCRIPTION' => $this->language->lang('DROPBOX_UPLOAD_EXPLAIN'),
			'S_VERSION_CHECK' => isset($version['current']) ? $version['current'] : false,
			'VERSION_DOWNLOAD' => $download,
			'VERSION_NUMBER' => $this->functions->get_meta('version'),
		));
	}
	protected function assign_options(array $credentials)
	{
		$options = array();
		$current = isset($this->config['dropbox_folder_opt']) ? $this->config['dropbox_folder_opt'] : 'DEFAULT';
		foreach (upload_policy::get_folder_options() as $value)
		{
			$options[] = array(
				'VALUE' => $value,
				'LABEL' => $this->language->lang('DROPBOX_FOLDER_' . $value),
				'S_SELECTED' => $value === $current,
			);
		}
		$this->template->assign_vars(array(
			'DROPBOX_FOLDER' => isset($this->config['dropbox_folder']) ? $this->config['dropbox_folder'] : '',
			'DROPBOX_FOLDER_OPTIONS' => $options,
			'DROPBOX_FREQUENCY' => isset($this->config['dropbox_frequency_interval']) ? (int) $this->config['dropbox_frequency_interval'] : 1,
			'DROPBOX_UPLOAD_ENABLED' => !empty($this->config['dropbox_upload_enable']),
			'U_ACTION' => $this->u_action,
		));
		$this->template->assign_vars(array(
			'DROPBOX_APP_KEY_SET' => !empty($credentials['dropbox_app_key']),
			'DROPBOX_APP_SECRET_SET' => !empty($credentials['dropbox_app_secret']),
			'DROPBOX_REFRESH_TOKEN_SET' => !empty($credentials['dropbox_refresh_token']),
			'DROPBOX_ACCESS_TOKEN_SET' => !empty($credentials['dropbox_access_token']),
		));
	}
	protected function get_credentials()
	{
		$keys = array('dropbox_app_key', 'dropbox_app_secret', 'dropbox_refresh_token', 'dropbox_access_token');
		$credentials = $this->config_text->get_array($keys);
		return array_replace(array_fill_keys($keys, ''), $credentials);
	}
	protected function set_options()
	{
		$folder = upload_policy::normalize_folder($this->request->variable('dropbox_folder', '', true));
		$folder_option = $this->request->variable('dropbox_folder_opt', 'DEFAULT');
		$frequency = $this->request->variable('dropbox_frequency_interval', 1);
		$enabled = $this->request->variable('dropbox_upload_enable', 0) ? 1 : 0;
		$credentials = $this->updated_credentials($this->get_credentials());
		upload_policy::validate_options($folder_option, $frequency);
		upload_policy::validate_credentials($credentials, (bool) $enabled);

		$this->config->set('dropbox_folder', $folder);
		$this->config->set('dropbox_folder_opt', $folder_option);
		$this->config->set('dropbox_frequency_interval', $frequency);
		$this->config->set('dropbox_upload_enable', $enabled);
		$this->config_text->set_array($credentials);
	}
	protected function updated_credentials(array $credentials)
	{
		foreach (array_keys($credentials) as $key)
		{
			if ($this->request->variable('clear_' . $key, 0))
			{
				$credentials[$key] = '';
				continue;
			}
			$value = trim($this->request->variable($key, '', true));
			if ($value !== '')
			{
				$credentials[$key] = $value;
			}
		}
		return $credentials;
	}

	public function set_page_url($u_action)
	{
		$this->u_action = $u_action;
	}
}
