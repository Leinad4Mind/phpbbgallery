<?php
/**
 *
 * @package phpBB Extension - Faulty Logins
 * @copyright (c) 2014 John Peskens (http://ForumHulp.com)
 * @copyright (c) 2026 Leinad4Mind
 * @license https://opensource.org/licenses/GPL-2.0 GNU General Public License v2
 *
 */

namespace forumhulp\faultylogins\event;

use forumhulp\faultylogins\core\attempt_repository;
use forumhulp\faultylogins\core\crypto_manager;
use phpbb\cache\driver\driver_interface as cache_driver;
use phpbb\config\config;
use phpbb\user;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class listener implements EventSubscriberInterface
{
	const MAX_PASSWORD_BYTES = 4096;
	const MAX_USERNAME_CHARS = 180;

	protected $config;
	protected $cache;
	protected $crypto;
	protected $attempts;
	protected $user;

	public function __construct(config $config, cache_driver $cache, crypto_manager $crypto, attempt_repository $attempts, user $user)
	{
		$this->config = $config;
		$this->cache = $cache;
		$this->crypto = $crypto;
		$this->attempts = $attempts;
		$this->user = $user;
	}

	static public function getSubscribedEvents()
	{
		return [
			'core.login_box_failed' => 'log_login',
		];
	}

	public function log_login($event)
	{
		if (empty($this->config['faultylogins_initialized']) || !$this->crypto->is_available())
		{
			return;
		}

		$result = $event['result'];
		$status = isset($result['status']) ? $result['status'] : null;
		if (!in_array($status, $this->failure_statuses(), true))
		{
			return;
		}

		$ip = substr((string) $this->user->ip, 0, 40);
		if ($this->is_throttled($ip))
		{
			return;
		}

		$username = $this->limit_username((string) $event['username']);
		$password = (string) $event['password'];
		$truncated = strlen($password) > self::MAX_PASSWORD_BYTES;
		$password = substr($password, 0, self::MAX_PASSWORD_BYTES);
		$timestamp = time();
		$context = [
			'username' => $username,
			'ip' => $ip,
			'time' => $timestamp,
			'status' => (int) $status,
		];

		try
		{
			$ciphertext = $this->crypto->encrypt_password($password, $context);
			if ($ciphertext === false)
			{
				return;
			}

			$user_row = isset($result['user_row']) && is_array($result['user_row']) ? $result['user_row'] : [];
			$error_key = isset($result['error_msg']) && is_string($result['error_msg']) ? $result['error_msg'] : 'LOGIN_ERROR';
			if (!preg_match('/^[A-Z0-9_]{1,255}$/D', $error_key))
			{
				$error_key = 'LOGIN_ERROR';
			}

			$this->attempts->add([
				'attempt_time' => $timestamp,
				'actor_user_id' => isset($this->user->data['user_id']) ? (int) $this->user->data['user_id'] : (defined('ANONYMOUS') ? ANONYMOUS : 1),
				'attempted_user_id' => isset($user_row['user_id']) ? (int) $user_row['user_id'] : 0,
				'attempted_username' => $username,
				'ip_address' => $ip,
				'login_status' => (int) $status,
				'error_key' => $error_key,
				'error_text' => $this->safe_error_text(isset($event['err']) ? $event['err'] : ''),
				'password_cipher' => $ciphertext,
				'password_truncated' => $truncated,
			]);
		}
		catch (\Throwable $exception)
		{
			// Logging must never interrupt or alter the authentication flow.
		}
		finally
		{
			$this->crypto->wipe($password);
		}
	}

	protected function failure_statuses()
	{
		return [
			LOGIN_ERROR_USERNAME,
			LOGIN_ERROR_PASSWORD,
			LOGIN_ERROR_ACTIVE,
			LOGIN_ERROR_ATTEMPTS,
			LOGIN_ERROR_EXTERNAL_AUTH,
			LOGIN_ERROR_PASSWORD_CONVERT,
		];
	}

	protected function is_throttled($ip)
	{
		$seconds = isset($this->config['faultylogins_throttle_seconds']) ? max(0, (int) $this->config['faultylogins_throttle_seconds']) : 0;
		if ($seconds === 0)
		{
			return false;
		}

		$key = '_faultylogins_' . hash('sha256', (string) $ip);
		if ($this->cache->get($key) !== false)
		{
			return true;
		}
		$this->cache->put($key, 1, $seconds);

		return false;
	}

	protected function limit_username($username)
	{
		return function_exists('utf8_substr') ? utf8_substr($username, 0, self::MAX_USERNAME_CHARS) : substr($username, 0, self::MAX_USERNAME_CHARS);
	}

	protected function safe_error_text($error)
	{
		$error = trim(strip_tags((string) $error));

		return function_exists('utf8_substr') ? utf8_substr($error, 0, 255) : substr($error, 0, 255);
	}
}
