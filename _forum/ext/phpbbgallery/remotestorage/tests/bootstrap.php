<?php
// phpcs:ignoreFile PSR1.Files.SideEffects.FoundWithSymbols -- PHPUnit bootstrap defines IN_PHPBB before loading language fixtures.
/**
 * phpBB Gallery - Remote Storage test bootstrap
 *
 * @package   phpbbgallery/remotestorage
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

if (!defined('IN_PHPBB'))
{
	define('IN_PHPBB', true);
}

if (!class_exists(\phpbb\config\config::class))
{
	require_once __DIR__ . '/config_stub.php';
}

if (!interface_exists(\Symfony\Component\DependencyInjection\ContainerInterface::class))
{
	require_once dirname(__DIR__, 4) . '/vendor/psr/container/src/ContainerInterface.php';
	require_once dirname(__DIR__, 4) . '/vendor/symfony/dependency-injection/ContainerInterface.php';
}

if (!interface_exists(\phpbb\request\request_interface::class))
{
	require_once dirname(__DIR__, 4) . '/phpbb/request/request_interface.php';
}

if (!interface_exists(\phpbb\db\driver\driver_interface::class))
{
	require_once dirname(__DIR__, 4) . '/phpbb/db/driver/driver_interface.php';
}

spl_autoload_register(static function (string $class_name): void
{
	$prefix = 'Twig\\';
	if (!str_starts_with($class_name, $prefix))
	{
		return;
	}
	$file = dirname(__DIR__, 4) . '/vendor/twig/twig/src/'
		. str_replace('\\', '/', substr($class_name, strlen($prefix))) . '.php';
	if (is_file($file))
	{
		$error_level = error_reporting();
		error_reporting($error_level & ~E_DEPRECATED);
		require_once $file;
		error_reporting($error_level);
	}
});

require_once dirname(__DIR__) . '/providers/s3/signer.php';
require_once dirname(__DIR__, 2) . '/core/storage/provider_interface.php';
require_once dirname(__DIR__, 2) . '/core/storage/provider_factory_interface.php';
require_once dirname(__DIR__, 2) . '/core/storage/local_provider.php';
require_once dirname(__DIR__) . '/providers/s3/configuration.php';
require_once dirname(__DIR__) . '/http/response.php';
require_once dirname(__DIR__) . '/http/client_interface.php';
require_once dirname(__DIR__) . '/configured_provider_factory_interface.php';
require_once dirname(__DIR__) . '/rotating_credentials_factory_interface.php';
require_once dirname(__DIR__) . '/providers/s3/provider.php';
require_once dirname(__DIR__) . '/providers/s3/factory.php';
require_once dirname(__DIR__) . '/providers/s3/configured_factory.php';
require_once dirname(__DIR__) . '/providers/azure/configuration.php';
require_once dirname(__DIR__) . '/providers/azure/signer.php';
require_once dirname(__DIR__) . '/providers/azure/provider.php';
require_once dirname(__DIR__) . '/providers/azure/factory.php';
require_once dirname(__DIR__) . '/providers/azure/configured_factory.php';
require_once dirname(__DIR__) . '/providers/sftp/configuration.php';
require_once dirname(__DIR__) . '/providers/sftp/client_interface.php';
require_once dirname(__DIR__) . '/providers/sftp/native_client.php';
require_once dirname(__DIR__) . '/providers/sftp/provider.php';
require_once dirname(__DIR__) . '/providers/sftp/factory.php';
require_once dirname(__DIR__) . '/providers/sftp/configured_factory.php';
require_once dirname(__DIR__) . '/providers/dropbox/configuration.php';
require_once dirname(__DIR__) . '/providers/dropbox/token_manager.php';
require_once dirname(__DIR__) . '/providers/dropbox/provider.php';
require_once dirname(__DIR__) . '/providers/dropbox/factory.php';
require_once dirname(__DIR__) . '/providers/dropbox/configured_factory.php';
require_once dirname(__DIR__) . '/providers/google_drive/configuration.php';
require_once dirname(__DIR__) . '/providers/google_drive/token_manager.php';
require_once dirname(__DIR__) . '/providers/google_drive/provider.php';
require_once dirname(__DIR__) . '/providers/google_drive/factory.php';
require_once dirname(__DIR__) . '/providers/google_drive/configured_factory.php';
require_once dirname(__DIR__) . '/providers/box/configuration.php';
require_once dirname(__DIR__) . '/providers/box/token_store_interface.php';
require_once dirname(__DIR__) . '/providers/box/memory_token_store.php';
require_once dirname(__DIR__) . '/providers/box/config_token_store.php';
require_once dirname(__DIR__) . '/providers/box/token_manager.php';
require_once dirname(__DIR__) . '/providers/box/provider.php';
require_once dirname(__DIR__) . '/providers/box/configured_factory.php';
require_once dirname(__DIR__) . '/providers/mediafire/configuration.php';
require_once dirname(__DIR__) . '/providers/mediafire/session_store_interface.php';
require_once dirname(__DIR__) . '/providers/mediafire/memory_session_store.php';
require_once dirname(__DIR__) . '/providers/mediafire/config_session_store.php';
require_once dirname(__DIR__) . '/providers/mediafire/api_client.php';
require_once dirname(__DIR__) . '/providers/mediafire/provider.php';
require_once dirname(__DIR__) . '/providers/mediafire/configured_factory.php';
require_once dirname(__DIR__) . '/providers/pcloud/configuration.php';
require_once dirname(__DIR__) . '/providers/pcloud/api_client.php';
require_once dirname(__DIR__) . '/providers/pcloud/provider.php';
require_once dirname(__DIR__) . '/providers/pcloud/configured_factory.php';
require_once dirname(__DIR__) . '/providers/koofr/configuration.php';
require_once dirname(__DIR__) . '/providers/koofr/provider.php';
require_once dirname(__DIR__) . '/providers/koofr/configured_factory.php';
require_once dirname(__DIR__) . '/providers/fourshared/configuration.php';
require_once dirname(__DIR__) . '/providers/fourshared/oauth_signer.php';
require_once dirname(__DIR__) . '/providers/fourshared/api_client.php';
require_once dirname(__DIR__) . '/providers/fourshared/operation_lock.php';
require_once dirname(__DIR__) . '/providers/fourshared/provider.php';
require_once dirname(__DIR__) . '/providers/fourshared/configured_factory.php';
require_once dirname(__DIR__) . '/connection_tester.php';
require_once dirname(__DIR__) . '/migration/provider_resolver_interface.php';
require_once dirname(__DIR__) . '/migration/provider_resolver.php';
require_once dirname(__DIR__) . '/migration/state_store_interface.php';
require_once dirname(__DIR__) . '/migration/provider_migrator.php';
