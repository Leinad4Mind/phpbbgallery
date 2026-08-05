<?php

namespace forumhulp\faultylogins\tests\core;

use forumhulp\faultylogins\core\crypto_manager;
use phpbb\config\config;
use PHPUnit\Framework\TestCase;

class crypto_manager_test extends TestCase
{
	protected function setUp(): void
	{
		if (!extension_loaded('sodium'))
		{
			self::markTestSkipped('Sodium is required.');
		}
	}

	public function test_encryption_unlock_change_and_recovery()
	{
		$config = new config([]);
		$crypto = new crypto_manager($config);
		$initial = $crypto->initialise('correct horse battery staple');
		$crypto->persist_wrapped_key($initial, true);
		$context = ['username' => 'alice', 'ip' => '192.0.2.10', 'time' => 123456, 'status' => 11];
		$ciphertext = $crypto->encrypt_password('<script>alert(1)</script>', $context);

		self::assertIsString($ciphertext);
		self::assertStringNotContainsString('script', $ciphertext);
		self::assertFalse($crypto->unlock_private_key('incorrect passphrase value'));

		$private_key = $crypto->unlock_private_key('correct horse battery staple');
		self::assertSame('<script>alert(1)</script>', $crypto->decrypt_password($ciphertext, $context, $private_key));
		self::assertFalse($crypto->decrypt_password($ciphertext, array_merge($context, ['ip' => '198.51.100.1']), $private_key));
		$crypto->wipe($private_key);

		$changed = $crypto->change_passphrase('correct horse battery staple', 'another strong passphrase value');
		self::assertIsArray($changed);
		$crypto->persist_wrapped_key($changed);
		self::assertFalse($crypto->unlock_private_key('correct horse battery staple'));
		$private_key = $crypto->unlock_private_key('another strong passphrase value');
		self::assertSame('<script>alert(1)</script>', $crypto->decrypt_password($ciphertext, $context, $private_key));
		$crypto->wipe($private_key);

		$recovered = $crypto->recover($initial['recovery_key'], 'recovered strong passphrase');
		self::assertIsArray($recovered);
		$crypto->persist_wrapped_key($recovered);
		$private_key = $crypto->unlock_private_key('recovered strong passphrase');
		self::assertSame('<script>alert(1)</script>', $crypto->decrypt_password($ciphertext, $context, $private_key));
		$crypto->wipe($private_key);
	}

	public function test_passphrase_policy()
	{
		$crypto = new crypto_manager(new config([]));
		self::assertFalse($crypto->validate_passphrase('123456'));
		self::assertTrue($crypto->validate_passphrase('uma passphrase bastante forte'));
	}
}
