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
	require_once dirname(__DIR__, 2) . '/core/auth/auth.php';
	require_once dirname(__DIR__, 2) . '/core/block.php';
	require_once dirname(__DIR__) . '/exif.php';
	require_once dirname(__DIR__) . '/event/exif_listener.php';
}
