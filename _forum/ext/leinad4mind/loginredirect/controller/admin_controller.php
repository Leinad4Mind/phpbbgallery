<?php
/**
 * @package User Login Redirect
 * @copyright (c) 2026 Leinad4Mind
 * @license GNU General Public License, version 2 (GPL-2.0)
 */

namespace leinad4mind\loginredirect\controller;

use leinad4mind\loginredirect\core\functions;
use leinad4mind\loginredirect\core\topic_repository;
use phpbb\config\config;
use phpbb\language\language;
use phpbb\log\log;
use phpbb\request\request_interface;
use phpbb\template\template;
use phpbb\user;

class admin_controller
{
	protected $config;
	protected $request;
	protected $template;
	protected $user;
	protected $log;
	protected $language;
	protected $functions;
	protected $topics;
	protected $u_action;

	public function __construct(config $config, request_interface $request, template $template, user $user, log $log, language $language, functions $functions, topic_repository $topics)
	{
		$this->config = $config;
		$this->request = $request;
		$this->template = $template;
		$this->user = $user;
		$this->log = $log;
		$this->language = $language;
		$this->functions = $functions;
		$this->topics = $topics;
	}

	public function display_options()
	{
		$this->language->add_lang(array('acp_loginredirect', 'acp_common'), $this->functions->get_ext_namespace());
		$form_key = 'leinad4mind_loginredirect';
		add_form_key($form_key);
		if ($this->request->is_set_post('submit'))
		{
			if (!check_form_key($form_key))
			{
				trigger_error($this->language->lang('FORM_INVALID') . adm_back_link($this->u_action), E_USER_WARNING);
			}
			$options = $this->request_options();
			$this->validate_options($options);
			foreach ($options as $key => $value)
			{
				$this->config->set('loginredirect_' . $key, $value);
			}
			$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_LOGIN_REDIRECT');
			trigger_error($this->language->lang('CONFIG_UPDATED') . adm_back_link($this->u_action));
		}

		$this->assign_header();
		$this->assign_options();
	}

	protected function request_options()
	{
		$boolean = array('always', 'announce', 'announce_priority', 'announce_refresh', 'any_announce', 'enabled', 'global', 'group', 'group_all', 'group_refresh', 'welcome', 'welcome_refresh');
		$options = array();
		foreach ($boolean as $key)
		{
			$options[$key] = $this->request->variable('redirect_' . $key, 0) ? 1 : 0;
		}
		foreach (array('announce_topic_id', 'group_id', 'group_topic_id', 'welcome_topic_id') as $key)
		{
			$options[$key] = max(0, $this->request->variable('redirect_' . $key, 0));
		}
		return $options;
	}

	protected function validate_options(array $options)
	{
		$this->validate_topic($options['welcome_topic_id'], 'INVALID_WELCOME_TOPIC', $options['welcome'] || $options['always']);
		$this->validate_topic($options['announce_topic_id'], 'INVALID_ANNOUNCEMENT_TOPIC', (bool) $options['any_announce'], true);
		$this->validate_topic($options['group_topic_id'], 'INVALID_GROUP_TOPIC', (bool) $options['group']);
		if ($options['group'] && !$options['group_all'] && ($options['group_id'] <= 0 || !$this->topics->group_exists($options['group_id'])))
		{
			$this->fail('INVALID_REDIRECT_GROUP');
		}
	}

	protected function validate_topic($topic_id, $error_key, $required, $announcement_only = false)
	{
		if (($required && $topic_id <= 0) || ($topic_id > 0 && !$this->topics->topic_exists($topic_id, $announcement_only)))
		{
			$this->fail($error_key);
		}
	}

	protected function fail($key)
	{
		trigger_error($this->language->lang($key) . adm_back_link($this->u_action), E_USER_WARNING);
	}

	protected function assign_header()
	{
		$version = $this->functions->version_check();
		$download = isset($version['download']) && filter_var($version['download'], FILTER_VALIDATE_URL) && strtolower((string) parse_url($version['download'], PHP_URL_SCHEME)) === 'https' ? $version['download'] : '';
		$this->template->assign_vars(array(
			'HEAD_TITLE' => $this->language->lang('REDIRECT_LOGIN'),
			'HEAD_DESCRIPTION' => $this->language->lang('REDIRECT_LOGIN_EXPLAIN'),
			'S_VERSION_CHECK' => isset($version['current']) ? $version['current'] : false,
			'VERSION_DOWNLOAD' => $download,
			'VERSION_NUMBER' => $this->functions->get_meta('version'),
		));
	}

	protected function assign_options()
	{
		$map = array(
			'REDIRECT_ALWAYS' => 'always',
			'REDIRECT_ANNOUNCE' => 'announce',
			'REDIRECT_ANNOUNCE_PRIORITY' => 'announce_priority',
			'REDIRECT_ANNOUNCE_REFRESH' => 'announce_refresh',
			'REDIRECT_ANNOUNCE_TOPIC_ID' => 'announce_topic_id',
			'REDIRECT_ANY_ANNOUNCE' => 'any_announce',
			'REDIRECT_ENABLED' => 'enabled',
			'REDIRECT_GLOBAL' => 'global',
			'REDIRECT_GROUP' => 'group',
			'REDIRECT_GROUP_ALL' => 'group_all',
			'REDIRECT_GROUP_REFRESH' => 'group_refresh',
			'REDIRECT_GROUP_TOPIC_ID' => 'group_topic_id',
			'REDIRECT_WELCOME' => 'welcome',
			'REDIRECT_WELCOME_REFRESH' => 'welcome_refresh',
			'REDIRECT_WELCOME_TOPIC_ID' => 'welcome_topic_id',
		);
		$vars = array();
		foreach ($map as $template_key => $config_key)
		{
			$vars[$template_key] = isset($this->config['loginredirect_' . $config_key]) ? (int) $this->config['loginredirect_' . $config_key] : 0;
		}
		$group_id = isset($this->config['loginredirect_group_id']) ? (int) $this->config['loginredirect_group_id'] : 0;
		$vars['S_REDIRECT_GROUP_OPTIONS'] = group_select_options($group_id, false, false);
		$vars['U_ACTION'] = $this->u_action;
		$this->template->assign_vars($vars);
	}

	public function set_page_url($u_action)
	{
		$this->u_action = $u_action;
	}
}
