<?php
/**
 * phpBB Gallery - Feed test bootstrap
 *
 * @package   phpbbgallery/feed
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace Symfony\Component\EventDispatcher
{
	if (!interface_exists('Symfony\\Component\\EventDispatcher\\EventSubscriberInterface', false))
	{
		interface EventSubscriberInterface
		{
			public static function getSubscribedEvents();
		}
	}
}

namespace phpbb\db\driver
{
	if (!interface_exists('phpbb\\db\\driver\\driver_interface', false))
	{
		interface driver_interface
		{
		}
	}
}

namespace phpbbgallery\core
{
	if (!class_exists('phpbbgallery\\core\\config', false))
	{
		class config
		{
		}
	}
}

namespace phpbbgallery\core\auth
{
	if (!class_exists('phpbbgallery\\core\\auth\\auth', false))
	{
		class auth
		{
		}
	}
}

namespace phpbbgallery\core\album
{
	if (!class_exists('phpbbgallery\\core\\album\\album', false))
	{
		class album
		{
		}
	}
}

namespace
{
	if (!defined('IN_PHPBB'))
	{
		define('IN_PHPBB', true);
	}

	require_once dirname(__DIR__, 2) . '/core/block.php';
	require_once dirname(__DIR__) . '/feed.php';
	require_once dirname(__DIR__) . '/event/feed_listener.php';
}
