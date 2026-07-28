<?php
/**
 * phpBB Gallery - EXIF test bootstrap
 *
 * @package   phpbbgallery/exif
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace Symfony\Component\EventDispatcher
{
	interface EventSubscriberInterface
	{
		public static function getSubscribedEvents();
	}
}

namespace
{
	// Language files bail out with exit; when this is missing, which would kill the
	// whole test run rather than fail a single test.
	if (!defined('IN_PHPBB'))
	{
		define('IN_PHPBB', true);
	}

	if (!function_exists('utf8_htmlspecialchars'))
	{
		function utf8_htmlspecialchars(string $value): string
		{
			return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
		}
	}

	require_once dirname(__DIR__, 2) . '/core/auth/auth.php';
	require_once dirname(__DIR__, 2) . '/core/block.php';
	require_once dirname(__DIR__) . '/exif.php';
	require_once dirname(__DIR__) . '/event/exif_listener.php';
}
