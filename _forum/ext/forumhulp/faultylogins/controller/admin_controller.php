<?php
/**
 *
 * @package phpBB Extension - Faulty Logins
 * @copyright (c) 2014 John Peskens (http://ForumHulp.com)
 * @copyright (c) 2026 Leinad4Mind
 * @license https://opensource.org/licenses/GPL-2.0 GNU General Public License v2
 *
 */

namespace forumhulp\faultylogins\controller;

use forumhulp\faultylogins\core\attempt_repository;
use forumhulp\faultylogins\core\crypto_manager;
use phpbb\cache\driver\driver_interface as cache_driver;
use phpbb\config\config;
use phpbb\language\language;
use phpbb\log\log_interface;
use phpbb\pagination;
use phpbb\request\request_interface;
use phpbb\template\template;
use phpbb\user;

class admin_controller
{
	const FORM_LOGS = 'faultylogins_logs';
	const FORM_SECURITY = 'faultylogins_security';
	const PER_PAGE = 50;
	const MAX_UNLOCK_FAILURES = 5;
	const UNLOCK_LOCK_SECONDS = 900;

	protected $config;
	protected $template;
	protected $log;
	protected $user;
	protected $request;
	protected $language;
	protected $pagination;
	protected $cache;
	protected $crypto;
	protected $attempts;
	protected $u_action;

	public function __construct(
		config $config,
		template $template,
		log_interface $log,
		user $user,
		request_interface $request,
		language $language,
		pagination $pagination,
		cache_driver $cache,
		crypto_manager $crypto,
		attempt_repository $attempts
	)
	{
		$this->config = $config;
		$this->template = $template;
		$this->log = $log;
		$this->user = $user;
		$this->request = $request;
		$this->language = $language;
		$this->pagination = $pagination;
		$this->cache = $cache;
		$this->crypto = $crypto;
		$this->attempts = $attempts;
	}

	public function set_page_url($u_action)
	{
		$this->u_action = $u_action;
	}

	public function logs()
	{
		$this->language->add_lang('info_acp_faultylogins', 'forumhulp/faultylogins');
		add_form_key(self::FORM_LOGS);
		$errors = [];
		$private_key = false;
		$unlocked = false;

		if ($this->request->is_set_post('unlock'))
		{
			if (!check_form_key(self::FORM_LOGS))
			{
				$errors[] = $this->language->lang('FORM_INVALID');
			}
			else if ($this->unlock_is_blocked())
			{
				$errors[] = $this->language->lang('FAULTYLOGINS_UNLOCK_LOCKED', self::UNLOCK_LOCK_SECONDS / 60);
			}
			else
			{
				$passphrase = $this->request->untrimmed_variable('passphrase', '', true);
				$private_key = $this->crypto->unlock_private_key($passphrase);
				$this->crypto->wipe($passphrase);
				if ($private_key === false)
				{
					$this->record_unlock_failure();
					$errors[] = $this->language->lang('FAULTYLOGINS_INVALID_PASSPHRASE');
				}
				else
				{
					$this->clear_unlock_failures();
					$unlocked = true;
				}
			}
		}

		$start = max(0, $this->request->variable('start', 0));
		$total = $this->attempts->count();
		$rows = $this->attempts->get(self::PER_PAGE, $start);
		$revealed = 0;
		foreach ($rows as $row)
		{
			$password = false;
			if ($unlocked)
			{
				$password = $this->crypto->decrypt_password($row['password_cipher'], $this->row_context($row), $private_key);
				if ($password !== false)
				{
					$revealed++;
				}
			}

			$this->template->assign_block_vars('attempts', [
				'ID' => (int) $row['attempt_id'],
				'DATE' => $this->user->format_date((int) $row['attempt_time']),
				'USERNAME' => (string) $row['attempted_username'],
				'IP' => (string) $row['ip_address'],
				'REASON' => $this->reason((int) $row['login_status'], (string) $row['error_text']),
				'PASSWORD' => $password === false ? '' : $password,
				'S_PASSWORD_AVAILABLE' => $password !== false,
				'S_PASSWORD_TRUNCATED' => !empty($row['password_truncated']),
			]);
			if ($password !== false)
			{
				$this->crypto->wipe($password);
			}
		}

		if ($private_key !== false)
		{
			$this->crypto->wipe($private_key);
			$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_FAULTYLOGINS_VIEWED', false, [$revealed]);
		}

		$this->pagination->generate_template_pagination($this->u_action, 'pagination', 'start', $total, self::PER_PAGE, $start);
		$this->template->assign_vars([
			'U_ACTION' => $this->u_action,
			'S_INITIALIZED' => !empty($this->config['faultylogins_initialized']),
			'S_UNLOCKED' => $unlocked,
			'S_ERROR' => (bool) $errors,
			'ERROR_MSG' => implode("\n", $errors),
			'TOTAL_ATTEMPTS' => $total,
		]);
	}

	public function security()
	{
		$this->language->add_lang('info_acp_faultylogins', 'forumhulp/faultylogins');
		add_form_key(self::FORM_SECURITY);
		$errors = [];
		$message = '';
		$recovery_key = '';

		if ($this->request->is_set_post('initialize'))
		{
			$this->require_valid_form($errors);
			if (!$errors && !empty($this->config['faultylogins_initialized']))
			{
				$errors[] = $this->language->lang('FAULTYLOGINS_ALREADY_INITIALIZED');
			}
			if (!$errors)
			{
				$new_passphrase = $this->validated_new_passphrase($errors);
				if (!$errors)
				{
					try
					{
						$key_data = $this->crypto->initialise($new_passphrase);
						$this->crypto->persist_wrapped_key($key_data, true);
						$recovery_key = $key_data['recovery_key'];
						$legacy = $this->attempts->migrate_legacy($this->crypto);
						$message = $this->language->lang('FAULTYLOGINS_INITIALIZED', $legacy['migrated'], $legacy['removed']);
						$this->log_action('LOG_FAULTYLOGINS_INITIALIZED');
					}
					catch (\Throwable $exception)
					{
						$errors[] = $this->language->lang('FAULTYLOGINS_CRYPTO_FAILURE');
					}
				}
				$this->crypto->wipe($new_passphrase);
			}
		}
		else if ($this->request->is_set_post('change_passphrase'))
		{
			$this->require_valid_form($errors);
			$current = $this->request->untrimmed_variable('current_passphrase', '', true);
			$new = $this->validated_new_passphrase($errors);
			if (!$errors)
			{
				$wrapped = $this->crypto->change_passphrase($current, $new);
				if ($wrapped === false)
				{
					$errors[] = $this->language->lang('FAULTYLOGINS_INVALID_PASSPHRASE');
				}
				else
				{
					$this->crypto->persist_wrapped_key($wrapped);
					$message = $this->language->lang('FAULTYLOGINS_PASSPHRASE_CHANGED');
					$this->log_action('LOG_FAULTYLOGINS_PASSPHRASE_CHANGED');
				}
			}
			$this->crypto->wipe($current);
			$this->crypto->wipe($new);
		}
		else if ($this->request->is_set_post('recover'))
		{
			$this->require_valid_form($errors);
			$provided_recovery_key = $this->request->untrimmed_variable('recovery_key', '', true);
			$new = $this->validated_new_passphrase($errors);
			if (!$errors)
			{
				$wrapped = $this->crypto->recover($provided_recovery_key, $new);
				if ($wrapped === false)
				{
					$errors[] = $this->language->lang('FAULTYLOGINS_INVALID_RECOVERY_KEY');
				}
				else
				{
					$this->crypto->persist_wrapped_key($wrapped);
					$message = $this->language->lang('FAULTYLOGINS_RECOVERED');
					$this->log_action('LOG_FAULTYLOGINS_RECOVERED');
				}
			}
			$this->crypto->wipe($provided_recovery_key);
			$this->crypto->wipe($new);
		}
		else if ($this->request->is_set_post('export_recovery'))
		{
			$this->require_valid_form($errors);
			$current = $this->request->untrimmed_variable('export_passphrase', '', true);
			if (!$errors)
			{
				$private_key = $this->crypto->unlock_private_key($current);
				if ($private_key === false)
				{
					$errors[] = $this->language->lang('FAULTYLOGINS_INVALID_PASSPHRASE');
				}
				else
				{
					$recovery_key = base64_encode($private_key);
					$this->crypto->wipe($private_key);
					$message = $this->language->lang('FAULTYLOGINS_RECOVERY_EXPORTED');
					$this->log_action('LOG_FAULTYLOGINS_RECOVERY_EXPORTED');
				}
			}
			$this->crypto->wipe($current);
		}
		else if ($this->request->is_set_post('save_settings'))
		{
			$this->require_valid_form($errors);
			if (!$errors)
			{
				$retention = max(1, min(3650, $this->request->variable('retention_days', 30)));
				$throttle = max(0, min(3600, $this->request->variable('throttle_seconds', 10)));
				$this->config->set('faultylogins_retention_days', $retention);
				$this->config->set('faultylogins_throttle_seconds', $throttle);
				$message = $this->language->lang('FAULTYLOGINS_SETTINGS_SAVED');
				$this->log_action('LOG_FAULTYLOGINS_SETTINGS_CHANGED');
			}
		}
		else if ($this->request->is_set_post('migrate_legacy'))
		{
			$this->require_valid_form($errors);
			if (!$errors && !empty($this->config['faultylogins_initialized']))
			{
				try
				{
					$legacy = $this->attempts->migrate_legacy($this->crypto);
					$message = $this->language->lang('FAULTYLOGINS_LEGACY_MIGRATED', $legacy['migrated'], $legacy['removed']);
				}
				catch (\Throwable $exception)
				{
					$errors[] = $this->language->lang('FAULTYLOGINS_CRYPTO_FAILURE');
				}
			}
		}
		else if ($this->request->is_set_post('purge_logs'))
		{
			$this->require_valid_form($errors);
			if (!$this->request->variable('confirm_purge', false))
			{
				$errors[] = $this->language->lang('FAULTYLOGINS_PURGE_CONFIRM_REQUIRED');
			}
			if (!$errors)
			{
				$deleted = $this->attempts->delete_all();
				$message = $this->language->lang('FAULTYLOGINS_PURGED', $deleted);
				$this->log_action('LOG_FAULTYLOGINS_PURGED', [$deleted]);
			}
		}

		$this->template->assign_vars([
			'U_ACTION' => $this->u_action,
			'S_INITIALIZED' => !empty($this->config['faultylogins_initialized']),
			'S_SODIUM_AVAILABLE' => $this->crypto->is_available(),
			'S_ERROR' => (bool) $errors,
			'ERROR_MSG' => implode("\n", $errors),
			'S_MESSAGE' => $message !== '',
			'MESSAGE' => $message,
			'RECOVERY_KEY' => $recovery_key,
			'LEGACY_COUNT' => $this->attempts->count_legacy(),
			'TOTAL_ATTEMPTS' => $this->attempts->count(),
			'RETENTION_DAYS' => isset($this->config['faultylogins_retention_days']) ? (int) $this->config['faultylogins_retention_days'] : 30,
			'THROTTLE_SECONDS' => isset($this->config['faultylogins_throttle_seconds']) ? (int) $this->config['faultylogins_throttle_seconds'] : 10,
		]);
	}

	protected function validated_new_passphrase(array &$errors)
	{
		$new = $this->request->untrimmed_variable('new_passphrase', '', true);
		$confirmation = $this->request->untrimmed_variable('confirm_passphrase', '', true);
		if (!$this->crypto->validate_passphrase($new))
		{
			$errors[] = $this->language->lang('FAULTYLOGINS_PASSPHRASE_REQUIREMENTS', crypto_manager::MIN_PASSPHRASE_LENGTH);
		}
		else if (!hash_equals($new, $confirmation))
		{
			$errors[] = $this->language->lang('FAULTYLOGINS_PASSPHRASE_MISMATCH');
		}
		$this->crypto->wipe($confirmation);

		return $new;
	}

	protected function require_valid_form(array &$errors)
	{
		if (!check_form_key(self::FORM_SECURITY))
		{
			$errors[] = $this->language->lang('FORM_INVALID');
		}
	}

	protected function row_context(array $row)
	{
		return [
			'username' => (string) $row['attempted_username'],
			'ip' => (string) $row['ip_address'],
			'time' => (int) $row['attempt_time'],
			'status' => (int) $row['login_status'],
		];
	}

	protected function reason($status, $fallback)
	{
		$keys = [
			10 => 'FAULTYLOGINS_REASON_USERNAME',
			11 => 'FAULTYLOGINS_REASON_PASSWORD',
			12 => 'FAULTYLOGINS_REASON_ACTIVE',
			13 => 'FAULTYLOGINS_REASON_ATTEMPTS',
			14 => 'FAULTYLOGINS_REASON_EXTERNAL',
			15 => 'FAULTYLOGINS_REASON_CONVERT',
		];

		return isset($keys[$status]) ? $this->language->lang($keys[$status]) : ($fallback !== '' ? $fallback : $this->language->lang('FAULTYLOGINS_REASON_UNKNOWN'));
	}

	protected function unlock_cache_key()
	{
		return '_faultylogins_unlock_' . (int) $this->user->data['user_id'] . '_' . hash('sha256', (string) $this->user->ip);
	}

	protected function unlock_is_blocked()
	{
		$data = $this->cache->get($this->unlock_cache_key());

		return is_array($data) && isset($data['locked_until']) && (int) $data['locked_until'] > time();
	}

	protected function record_unlock_failure()
	{
		$key = $this->unlock_cache_key();
		$data = $this->cache->get($key);
		$count = is_array($data) && isset($data['count']) ? (int) $data['count'] + 1 : 1;
		$this->cache->put($key, [
			'count' => $count,
			'locked_until' => $count >= self::MAX_UNLOCK_FAILURES ? time() + self::UNLOCK_LOCK_SECONDS : 0,
		], self::UNLOCK_LOCK_SECONDS);
	}

	protected function clear_unlock_failures()
	{
		$this->cache->destroy($this->unlock_cache_key());
	}

	protected function log_action($operation, array $data = [])
	{
		$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, $operation, false, $data);
	}
}
