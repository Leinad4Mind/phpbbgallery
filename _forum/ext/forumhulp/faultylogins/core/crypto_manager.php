<?php
/**
 *
 * @package phpBB Extension - Faulty Logins
 * @copyright (c) 2014 John Peskens (http://ForumHulp.com)
 * @copyright (c) 2026 Leinad4Mind
 * @license https://opensource.org/licenses/GPL-2.0 GNU General Public License v2
 *
 */

namespace forumhulp\faultylogins\core;

use phpbb\config\config;

class crypto_manager
{
	const PRIVATE_KEY_AAD = 'forumhulp/faultylogins:private-key:v1';
	const PAYLOAD_VERSION = 1;
	const MIN_PASSPHRASE_LENGTH = 14;
	const MAX_PASSPHRASE_LENGTH = 1024;

	/** @var config */
	protected $config;

	public function __construct(config $config)
	{
		$this->config = $config;
	}

	public function is_available()
	{
		return function_exists('sodium_crypto_box_seal')
			&& function_exists('sodium_crypto_box_seal_open')
			&& function_exists('sodium_crypto_pwhash')
			&& function_exists('sodium_crypto_aead_xchacha20poly1305_ietf_encrypt')
			&& function_exists('sodium_crypto_aead_xchacha20poly1305_ietf_decrypt');
	}

	public function validate_passphrase($passphrase)
	{
		$length = preg_match_all('/./us', (string) $passphrase, $matches);
		$length = $length === false ? strlen((string) $passphrase) : $length;

		return $length >= self::MIN_PASSPHRASE_LENGTH && strlen((string) $passphrase) <= self::MAX_PASSPHRASE_LENGTH;
	}

	public function initialise($passphrase)
	{
		$this->assert_available();
		$keypair = sodium_crypto_box_keypair();
		$public_key = sodium_crypto_box_publickey($keypair);
		$private_key = sodium_crypto_box_secretkey($keypair);
		$wrapped = $this->wrap_private_key($private_key, $passphrase);
		$wrapped['public_key'] = base64_encode($public_key);
		$wrapped['recovery_key'] = base64_encode($private_key);

		$this->wipe($private_key);
		$this->wipe($keypair);

		return $wrapped;
	}

	public function change_passphrase($current_passphrase, $new_passphrase)
	{
		$private_key = $this->unlock_private_key($current_passphrase);
		if ($private_key === false)
		{
			return false;
		}

		$wrapped = $this->wrap_private_key($private_key, $new_passphrase);
		$this->wipe($private_key);

		return $wrapped;
	}

	public function recover($recovery_key, $new_passphrase)
	{
		$this->assert_available();
		$private_key = base64_decode(trim((string) $recovery_key), true);
		$public_key = $this->decode_config('faultylogins_public_key');
		if ($private_key === false || strlen($private_key) !== SODIUM_CRYPTO_BOX_SECRETKEYBYTES || $public_key === false)
		{
			return false;
		}

		$derived_public_key = sodium_crypto_scalarmult_base($private_key);
		if (!hash_equals($public_key, $derived_public_key))
		{
			$this->wipe($private_key);
			$this->wipe($derived_public_key);
			return false;
		}

		$wrapped = $this->wrap_private_key($private_key, $new_passphrase);
		$this->wipe($private_key);
		$this->wipe($derived_public_key);

		return $wrapped;
	}

	public function unlock_private_key($passphrase)
	{
		$this->assert_available();
		$ciphertext = $this->decode_config('faultylogins_private_key_cipher');
		$nonce = $this->decode_config('faultylogins_private_key_nonce');
		$salt = $this->decode_config('faultylogins_kdf_salt');
		if ($ciphertext === false || $nonce === false || $salt === false)
		{
			return false;
		}

		$key = $this->derive_key($passphrase, $salt);
		$private_key = sodium_crypto_aead_xchacha20poly1305_ietf_decrypt(
			$ciphertext,
			self::PRIVATE_KEY_AAD,
			$nonce,
			$key
		);
		$this->wipe($key);

		if ($private_key === false || strlen($private_key) !== SODIUM_CRYPTO_BOX_SECRETKEYBYTES)
		{
			return false;
		}

		return $private_key;
	}

	public function encrypt_password($password, array $context)
	{
		$this->assert_available();
		$public_key = $this->decode_config('faultylogins_public_key');
		if ($public_key === false || strlen($public_key) !== SODIUM_CRYPTO_BOX_PUBLICKEYBYTES)
		{
			return false;
		}

		$payload = json_encode([
			'v' => self::PAYLOAD_VERSION,
			'password' => base64_encode((string) $password),
			'context' => $this->context_hash($context),
		]);
		if ($payload === false)
		{
			return false;
		}

		return base64_encode(sodium_crypto_box_seal($payload, $public_key));
	}

	public function decrypt_password($ciphertext, array $context, $private_key)
	{
		$this->assert_available();
		$public_key = $this->decode_config('faultylogins_public_key');
		$encrypted = base64_decode((string) $ciphertext, true);
		if ($public_key === false || $encrypted === false || strlen((string) $private_key) !== SODIUM_CRYPTO_BOX_SECRETKEYBYTES)
		{
			return false;
		}

		$keypair = sodium_crypto_box_keypair_from_secretkey_and_publickey($private_key, $public_key);
		$payload = sodium_crypto_box_seal_open($encrypted, $keypair);
		$this->wipe($keypair);
		if ($payload === false)
		{
			return false;
		}

		$data = json_decode($payload, true);
		$this->wipe($payload);
		if (!is_array($data) || (int) ($data['v'] ?? 0) !== self::PAYLOAD_VERSION || !isset($data['password'], $data['context']))
		{
			return false;
		}

		if (!hash_equals($this->context_hash($context), (string) $data['context']))
		{
			return false;
		}

		return base64_decode((string) $data['password'], true);
	}

	public function persist_wrapped_key(array $key_data, $initialise = false)
	{
		$this->config->set('faultylogins_private_key_cipher', $key_data['private_key_cipher'], true);
		$this->config->set('faultylogins_private_key_nonce', $key_data['private_key_nonce'], true);
		$this->config->set('faultylogins_kdf_salt', $key_data['kdf_salt'], true);
		if ($initialise)
		{
			$this->config->set('faultylogins_public_key', $key_data['public_key'], true);
			$this->config->set('faultylogins_initialized', 1, true);
		}
	}

	public function wipe(&$value)
	{
		if (is_string($value) && function_exists('sodium_memzero'))
		{
			sodium_memzero($value);
		}
		$value = null;
	}

	protected function wrap_private_key($private_key, $passphrase)
	{
		if (!$this->validate_passphrase($passphrase))
		{
			throw new \InvalidArgumentException('Passphrase does not meet the security requirements.');
		}

		$salt = random_bytes(SODIUM_CRYPTO_PWHASH_SALTBYTES);
		$nonce = random_bytes(SODIUM_CRYPTO_AEAD_XCHACHA20POLY1305_IETF_NPUBBYTES);
		$key = $this->derive_key($passphrase, $salt);
		$ciphertext = sodium_crypto_aead_xchacha20poly1305_ietf_encrypt(
			$private_key,
			self::PRIVATE_KEY_AAD,
			$nonce,
			$key
		);
		$this->wipe($key);

		return [
			'private_key_cipher' => base64_encode($ciphertext),
			'private_key_nonce' => base64_encode($nonce),
			'kdf_salt' => base64_encode($salt),
		];
	}

	protected function derive_key($passphrase, $salt)
	{
		return sodium_crypto_pwhash(
			SODIUM_CRYPTO_AEAD_XCHACHA20POLY1305_IETF_KEYBYTES,
			(string) $passphrase,
			$salt,
			SODIUM_CRYPTO_PWHASH_OPSLIMIT_MODERATE,
			SODIUM_CRYPTO_PWHASH_MEMLIMIT_INTERACTIVE,
			SODIUM_CRYPTO_PWHASH_ALG_ARGON2ID13
		);
	}

	protected function context_hash(array $context)
	{
		$canonical = implode("\0", [
			(string) ($context['username'] ?? ''),
			(string) ($context['ip'] ?? ''),
			(string) ($context['time'] ?? 0),
			(string) ($context['status'] ?? 0),
		]);

		return hash('sha256', $canonical);
	}

	protected function decode_config($name)
	{
		if (empty($this->config[$name]))
		{
			return false;
		}

		return base64_decode((string) $this->config[$name], true);
	}

	protected function assert_available()
	{
		if (!$this->is_available())
		{
			throw new \RuntimeException('The Sodium extension is required.');
		}
	}
}
