<?php
/**
 *
 * @package phpBB Extension - Who Visited This Topic
 * @copyright (c) 2016 dmzx - https://www.dmzx-web.net
 * @copyright (c) 2026 Leinad4Mind
 * @license https://opensource.org/licenses/GPL-2.0 GNU General Public License v2
 *
 */

namespace dmzx\whovisitedthistopic\controller;

use dmzx\whovisitedthistopic\core\user_repository;
use phpbb\config\config;
use phpbb\language\language;
use phpbb\log\log_interface;
use phpbb\request\request_interface;
use phpbb\template\template;
use phpbb\user;

class admin_controller
{
	const MAX_EXCLUDED_USERS = 500;

	protected $config;
	protected $template;
	protected $log;
	protected $user;
	protected $request;
	protected $language;
	protected $users;
	protected $u_action;

	public function __construct(
		config $config,
		template $template,
		log_interface $log,
		user $user,
		request_interface $request,
		language $language,
		user_repository $users
	)
	{
		$this->config = $config;
		$this->template = $template;
		$this->log = $log;
		$this->user = $user;
		$this->request = $request;
		$this->language = $language;
		$this->users = $users;
	}

	public function display_options()
	{
		add_form_key('whovisitedthistopic');
		$this->language->add_lang('whovisitedthistopic_acp', 'dmzx/whovisitedthistopic');

		$is_submitted = $this->request->is_set_post('submit');
		$errors = [];
		if ($is_submitted)
		{
			if (!check_form_key('whovisitedthistopic'))
			{
				trigger_error($this->language->lang('FORM_INVALID'));
			}

			$errors = $this->set_options();
			if (!$errors)
			{
				$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_WHOVISITEDTHISTOPIC_UPDATE');
				trigger_error($this->language->lang('ACP_WHOVISITEDTHISTOPIC_OPTIONS_SAVED') . adm_back_link($this->u_action));
			}
		}

		$members = $is_submitted
			? $this->request->variable('whovisitedthistopic_members', '', true)
			: implode("\n", $this->users->get_names($this->config_ids('whovisitedthistopic_members')));
		$profile_members = $is_submitted
			? $this->request->variable('whovisitedthistopic_members_profile', '', true)
			: implode("\n", $this->users->get_names($this->config_ids('whovisitedthistopic_members_profile')));

		$this->template->assign_vars([
			'U_ACTION' => $this->u_action,
			'S_ERROR' => (bool) $errors,
			'ERROR_MSG' => implode('<br>', $errors),
			'WHOVISITEDTHISTOPIC_ALLOW_TOPICS' => $this->form_value('whovisitedthistopic_allow_topics', 0),
			'WHOVISITEDTHISTOPIC_SETTING' => $this->form_value('whovisitedthistopic_value', 10),
			'WHOVISITEDTHISTOPIC_ALLOW_MEMBERPAGE' => $this->form_value('whovisitedthistopic_allow_memberpage', 0),
			'WHOVISITEDTHISTOPIC_VISIT_SETTING' => $this->form_value('whovisitedthistopic_visit_value', 10),
			'WHOVISITEDTHISTOPIC_ALLOW_COUNT' => $this->form_value('whovisitedthistopic_allow_count', 0),
			'WHOVISITEDTHISTOPIC_SHOW_AVATAR' => $this->form_value('whovisitedthistopic_show_avatar', 0),
			'WHOVISITEDTHISTOPIC_RETENTION_DAYS' => $this->form_value('whovisitedthistopic_retention_days', 0),
			'WHOVISITEDTHISTOPIC_MEMBERS' => $members,
			'WHOVISITEDTHISTOPIC_MEMBERS_PROFILE' => $profile_members,
		]);
	}

	protected function set_options()
	{
		$topic_names = $this->parse_names($this->request->variable('whovisitedthistopic_members', '', true));
		$profile_names = $this->parse_names($this->request->variable('whovisitedthistopic_members_profile', '', true));
		$errors = [];

		if (count($topic_names) > self::MAX_EXCLUDED_USERS || count($profile_names) > self::MAX_EXCLUDED_USERS)
		{
			$errors[] = $this->language->lang('WHOVISITEDTHISTOPIC_TOO_MANY_USERS', self::MAX_EXCLUDED_USERS);
			return $errors;
		}

		$topic_users = $this->users->resolve_names($topic_names);
		$profile_users = $this->users->resolve_names($profile_names);
		$missing = array_values(array_unique(array_merge($topic_users['missing'], $profile_users['missing'])));
		if ($missing)
		{
			$missing = array_map(function ($username) {
				return htmlspecialchars($username, ENT_COMPAT, 'UTF-8');
			}, $missing);
			$errors[] = $this->language->lang('WHOVISITEDTHISTOPIC_USERS_NOT_FOUND', implode(', ', $missing));
			return $errors;
		}

		$this->config->set('whovisitedthistopic_allow_topics', $this->request->variable('whovisitedthistopic_allow_topics', (int) $this->config['whovisitedthistopic_allow_topics']) ? 1 : 0);
		$this->config->set('whovisitedthistopic_value', $this->bounded_request('whovisitedthistopic_value', 2, 255, 10));
		$this->config->set('whovisitedthistopic_allow_memberpage', $this->request->variable('whovisitedthistopic_allow_memberpage', (int) $this->config['whovisitedthistopic_allow_memberpage']) ? 1 : 0);
		$this->config->set('whovisitedthistopic_visit_value', $this->bounded_request('whovisitedthistopic_visit_value', 2, 255, 10));
		$this->config->set('whovisitedthistopic_allow_count', $this->request->variable('whovisitedthistopic_allow_count', (int) $this->config['whovisitedthistopic_allow_count']) ? 1 : 0);
		$this->config->set('whovisitedthistopic_show_avatar', $this->request->variable('whovisitedthistopic_show_avatar', (int) $this->config['whovisitedthistopic_show_avatar']) ? 1 : 0);
		$this->config->set('whovisitedthistopic_retention_days', $this->bounded_request('whovisitedthistopic_retention_days', 0, 3650, 0));
		$this->config->set('whovisitedthistopic_members', json_encode($topic_users['ids']));
		$this->config->set('whovisitedthistopic_members_profile', json_encode($profile_users['ids']));

		return [];
	}

	public function set_page_url($u_action)
	{
		$this->u_action = $u_action;
	}

	private function parse_names($value)
	{
		$names = preg_split('/\R/u', (string) $value);
		$names = array_map('trim', is_array($names) ? $names : []);

		return array_values(array_unique(array_filter($names, 'strlen')));
	}

	private function config_ids($key)
	{
		$ids = json_decode(isset($this->config[$key]) ? $this->config[$key] : '[]', true);

		return is_array($ids) ? $ids : [];
	}

	private function bounded_request($name, $minimum, $maximum, $default)
	{
		return max($minimum, min($maximum, $this->request->variable($name, $default)));
	}

	private function form_value($name, $default)
	{
		if ($this->request->is_set_post('submit'))
		{
			return $this->request->variable($name, $default);
		}

		return isset($this->config[$name]) ? $this->config[$name] : $default;
	}
}
