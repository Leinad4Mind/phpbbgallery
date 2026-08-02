<?php
/**
 * @package User Login Redirect
 * @copyright (c) 2026 Leinad4Mind
 * @license GNU General Public License, version 2 (GPL-2.0)
 */

namespace david63\loginredirect\controller;

use david63\loginredirect\core\redirect_helper;
use david63\loginredirect\core\redirect_policy;
use david63\loginredirect\core\topic_repository;
use phpbb\config\config;
use phpbb\language\language;
use phpbb\user;

class main_controller
{
	protected $config;
	protected $user;
	protected $language;
	protected $topics;
	protected $redirect_helper;

	public function __construct(config $config, user $user, language $language, topic_repository $topics, redirect_helper $redirect_helper)
	{
		$this->config = $config;
		$this->user = $user;
		$this->language = $language;
		$this->topics = $topics;
		$this->redirect_helper = $redirect_helper;
	}

	public function login_redirect($event)
	{
		if (empty($this->config['loginredirect_enabled']) || !empty($event['admin']) || $this->is_banned_non_founder($event))
		{
			return $event;
		}
		$target = $this->welcome_target();
		if ($target === null)
		{
			$target = $this->announcement_target();
		}
		if ($target === null)
		{
			$target = $this->group_target();
		}
		if ($target === null)
		{
			return $event;
		}

		$url = $this->redirect_helper->topic_url($target['topic_id']);
		$event['redirect'] = $url;
		if ($target['refresh'])
		{
			$this->redirect_helper->show_message(
				$url,
				$this->language->lang($target['message']),
				$this->language->lang($target['link'])
			);
		}
		return $event;
	}

	protected function welcome_target()
	{
		$first_login = (int) $this->user->data['user_lastvisit'] === 0;
		$enabled = !empty($this->config['loginredirect_always']) || (!empty($this->config['loginredirect_welcome']) && $first_login);
		if (!$enabled)
		{
			return null;
		}
		$topic = $this->topics->find_topic((int) $this->config['loginredirect_welcome_topic_id']);
		return $topic ? $this->target($topic, 'WELCOME', !empty($this->config['loginredirect_welcome_refresh'])) : null;
	}

	protected function announcement_target()
	{
		$last_visit = (int) $this->user->data['user_lastvisit'];
		$latest = null;
		$selected = null;
		if (!empty($this->config['loginredirect_announce']))
		{
			$topic = $this->topics->find_latest_announcement(!empty($this->config['loginredirect_global']));
			$latest = redirect_policy::is_unseen($topic, $last_visit) ? $topic : null;
		}
		if (!empty($this->config['loginredirect_any_announce']))
		{
			$topic = $this->topics->find_topic((int) $this->config['loginredirect_announce_topic_id'], true);
			$selected = redirect_policy::is_unseen($topic, $last_visit) ? $topic : null;
		}
		$topic = redirect_policy::choose_announcement($latest, $selected, !empty($this->config['loginredirect_announce_priority']));
		return $topic ? $this->target($topic, 'ANNOUNCE', !empty($this->config['loginredirect_announce_refresh'])) : null;
	}

	protected function group_target()
	{
		if (empty($this->config['loginredirect_group']))
		{
			return null;
		}
		$allowed = !empty($this->config['loginredirect_group_all']) || $this->topics->user_in_group(
			(int) $this->user->data['user_id'],
			(int) $this->config['loginredirect_group_id']
		);
		if (!$allowed)
		{
			return null;
		}
		$topic = $this->topics->find_topic((int) $this->config['loginredirect_group_topic_id']);
		if (!redirect_policy::is_unseen($topic, (int) $this->user->data['user_lastvisit']))
		{
			return null;
		}
		return $this->target($topic, 'GROUP', !empty($this->config['loginredirect_group_refresh']));
	}

	protected function target(array $topic, $type, $refresh)
	{
		return array(
			'topic_id' => (int) $topic['topic_id'],
			'message' => 'REDIRECT_LOGIN_' . $type . '_TOPIC',
			'link' => 'REDIRECT_REFRESH_' . $type,
			'refresh' => (bool) $refresh,
		);
	}

	protected function is_banned_non_founder($event)
	{
		if (!defined('IN_CHECK_BAN'))
		{
			return false;
		}
		$result = isset($event['result']) && is_array($event['result']) ? $event['result'] : array();
		$user_row = isset($result['user_row']) && is_array($result['user_row']) ? $result['user_row'] : $this->user->data;
		return !isset($user_row['user_type']) || (int) $user_row['user_type'] !== USER_FOUNDER;
	}
}
