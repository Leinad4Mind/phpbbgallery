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

require_once dirname(__DIR__) . '/s3/signer.php';
require_once dirname(__DIR__, 2) . '/core/storage/provider_interface.php';
require_once dirname(__DIR__) . '/s3/configuration.php';
require_once dirname(__DIR__) . '/http/response.php';
require_once dirname(__DIR__) . '/http/client_interface.php';
require_once dirname(__DIR__) . '/s3/provider.php';
require_once dirname(__DIR__) . '/s3/factory.php';
require_once dirname(__DIR__) . '/s3/configured_factory.php';
require_once dirname(__DIR__) . '/connection_tester.php';
