<?php
/**
 * phpBB Gallery - Core Extension tests
 *
 * @package   phpbbgallery/core
 * @copyright 2007-2012 nickvergessen, 2014- satanasov, 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbb\filesystem
{
	if (!interface_exists('phpbb\\filesystem\\filesystem_interface'))
	{
		interface filesystem_interface
		{
			const CHMOD_READ = 4;
			const CHMOD_WRITE = 2;
		}
	}
}

namespace
{
	if (!defined('IN_PHPBB'))
	{
		define('IN_PHPBB', true);
	}

	// Load only packaged Twig classes so isolated tests do not initialize unrelated Composer file autoloaders.
	spl_autoload_register(static function (string $class_name): void
	{
		$twig_prefix = 'Twig\\';
		if (strpos($class_name, $twig_prefix) !== 0)
		{
			return;
		}

		$twig_file = dirname(__DIR__, 4) . '/vendor/twig/twig/src/' . str_replace('\\', '/', substr($class_name, strlen($twig_prefix))) . '.php';
		if (is_file($twig_file))
		{
			$error_level = error_reporting();
			error_reporting($error_level & ~E_DEPRECATED);
			require_once $twig_file;
			error_reporting($error_level);
		}
	});

	if (!function_exists('unique_id'))
	{
		function unique_id()
		{
			// phpcs:ignore -- PHPUnit fixture override uses the PHP superglobal.
			if (isset($GLOBALS['phpbbgallery_test_unique_id']))
			{
				// phpcs:ignore -- PHPUnit fixture override uses the PHP superglobal.
				return $GLOBALS['phpbbgallery_test_unique_id'];
			}

			return uniqid('', true);
		}
	}

	if (!function_exists('phpbb_optionget'))
	{
		function phpbb_optionget(int $bit, int $data): bool
		{
			return (bool) ($data & 1 << $bit);
		}
	}

	if (!function_exists('phpbb_optionset'))
	{
		function phpbb_optionset(int $bit, bool $set, int $data): int
		{
			if ($set)
			{
				return $data | 1 << $bit;
			}

			return $data & ~(1 << $bit);
		}
	}

	require_once dirname(__DIR__, 4) . '/vendor/symfony/event-dispatcher/EventSubscriberInterface.php';
	require_once dirname(__DIR__, 4) . '/vendor/symfony/event-dispatcher/Event.php';
	require_once dirname(__DIR__, 4) . '/phpbb/event/data.php';
	require_once dirname(__DIR__, 4) . '/phpbb/db/driver/driver_interface.php';
	require_once dirname(__DIR__, 4) . '/phpbb/cron/task/task.php';
	require_once dirname(__DIR__, 4) . '/phpbb/cron/task/base.php';
	require_once dirname(__DIR__, 4) . '/phpbb/request/request_interface.php';
	require_once dirname(__DIR__, 4) . '/phpbb/template/template.php';
	require_once dirname(__DIR__, 4) . '/phpbb/language/language.php';
	require_once dirname(__DIR__, 4) . '/phpbb/files/types/type_interface.php';
	require_once dirname(__DIR__, 4) . '/phpbb/files/types/base.php';
	require_once dirname(__DIR__, 4) . '/phpbb/notification/type/type_interface.php';
	require_once dirname(__DIR__, 4) . '/phpbb/notification/type/base.php';
	require_once dirname(__DIR__, 4) . '/phpbb/cache/service.php';
	require_once __DIR__ . '/stubs/phpbb_extension_base.php';
	require_once __DIR__ . '/stubs/phpbb_notification_exception.php';
	require_once __DIR__ . '/stubs/phpbb_config.php';
	require_once __DIR__ . '/stubs/phpbb_user.php';
	require_once __DIR__ . '/stubs/template_noop_token_parser.php';
	require_once dirname(__DIR__) . '/upload.php';
	require_once dirname(__DIR__) . '/auth/image_authorization.php';
	require_once dirname(__DIR__) . '/auth/auth.php';
	require_once dirname(__DIR__) . '/ext.php';
	require_once dirname(__DIR__) . '/controller/moderate.php';
	require_once dirname(__DIR__) . '/controller/index.php';
	require_once dirname(__DIR__) . '/controller/file.php';
	require_once dirname(__DIR__) . '/controller/search.php';
	require_once dirname(__DIR__) . '/controller/album.php';
	require_once dirname(__DIR__) . '/controller/upload.php';
	require_once dirname(__DIR__) . '/controller/comment.php';
	require_once dirname(__DIR__) . '/controller/image.php';
	require_once dirname(__DIR__) . '/event/main_listener.php';
	require_once dirname(__DIR__) . '/acp/main_module.php';
	require_once dirname(__DIR__) . '/acp/config_module.php';
	require_once dirname(__DIR__) . '/acp/permissions_module.php';
	require_once dirname(__DIR__) . '/acp/albums_module.php';
	require_once dirname(__DIR__) . '/ucp/main_module.php';
	require_once dirname(__DIR__) . '/config.php';
	require_once dirname(__DIR__) . '/cache.php';
	require_once dirname(__DIR__) . '/url.php';
	require_once dirname(__DIR__) . '/auth/set.php';
	require_once dirname(__DIR__) . '/auth/level.php';
	require_once dirname(__DIR__) . '/block.php';
	require_once dirname(__DIR__) . '/contest.php';
	require_once dirname(__DIR__) . '/file/file.php';
	require_once dirname(__DIR__) . '/file/types/multiform.php';
	require_once dirname(__DIR__) . '/album/album.php';
	require_once dirname(__DIR__) . '/album/display.php';
	require_once dirname(__DIR__) . '/album/loader.php';
	require_once dirname(__DIR__) . '/album/manage.php';
	require_once dirname(__DIR__) . '/image/image.php';
	require_once dirname(__DIR__) . '/comment.php';
	require_once dirname(__DIR__) . '/rating.php';
	require_once dirname(__DIR__) . '/report.php';
	require_once dirname(__DIR__) . '/search.php';
	require_once dirname(__DIR__) . '/notification.php';
	require_once dirname(__DIR__) . '/notification/helper.php';
	require_once dirname(__DIR__) . '/notification/events/phpbbgallery_image_approved.php';
	require_once dirname(__DIR__) . '/notification/events/phpbbgallery_image_for_approval.php';
	require_once dirname(__DIR__) . '/notification/events/phpbbgallery_image_not_approved.php';
	require_once dirname(__DIR__) . '/notification/events/phpbbgallery_new_comment.php';
	require_once dirname(__DIR__) . '/notification/events/phpbbgallery_new_image.php';
	require_once dirname(__DIR__) . '/notification/events/phpbbgallery_new_report.php';
	require_once dirname(__DIR__) . '/moderate.php';
	require_once dirname(__DIR__) . '/user.php';
	require_once dirname(__DIR__) . '/log.php';
	require_once dirname(__DIR__) . '/misc.php';
	require_once dirname(__DIR__) . '/cron/cron_cleaner.php';
	require_once dirname(__DIR__) . '/ucp/settings_module.php';
}
