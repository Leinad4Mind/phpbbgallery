<?php
// phpcs:disable PSR1.Files.SideEffects
/**
 * BBTags tests.
 *
 * @package sitesplat/bbtags
 * @copyright (c) 2015 SiteSplat All rights reserved
 * @license Proprietary
 */

namespace
{
	if (!defined('IN_PHPBB'))
	{
		define('IN_PHPBB', true);
	}

	if (!function_exists('utf8_strtolower'))
	{
		function utf8_strtolower($value)
		{
			return mb_strtolower($value, 'UTF-8');
		}
	}

	if (!function_exists('utf8_substr'))
	{
		function utf8_substr($value, $offset, $length = null)
		{
			return mb_substr($value, $offset, $length, 'UTF-8');
		}
	}

	if (!function_exists('utf8_strlen'))
	{
		function utf8_strlen($value)
		{
			return mb_strlen($value, 'UTF-8');
		}
	}

	if (!function_exists('utf8_normalize_nfc'))
	{
		function utf8_normalize_nfc($value)
		{
			return $value;
		}
	}

	if (!function_exists('utf8_clean_string'))
	{
		function utf8_clean_string($value)
		{
			return mb_strtolower(trim($value), 'UTF-8');
		}
	}

	if (!function_exists('append_sid'))
	{
		function append_sid($url, $params = false)
		{
			return $params ? $url . '?' . $params : $url;
		}
	}

	if (!defined('CONFIG_TEXT_TABLE'))
	{
		define('CONFIG_TEXT_TABLE', 'phpbb_config_text');
	}

	if (!defined('FORUMS_TABLE'))
	{
		define('FORUMS_TABLE', 'phpbb_forums');
	}

	if (!defined('TOPICS_TABLE'))
	{
		define('TOPICS_TABLE', 'phpbb_topics');
	}

	if (!interface_exists('Symfony\Component\EventDispatcher\EventSubscriberInterface'))
	{
		require_once __DIR__ . '/stubs/event_subscriber_interface.php';
	}

	require_once __DIR__ . '/stubs/phpbb_config.php';
	require_once __DIR__ . '/stubs/phpbb_auth.php';
	require_once dirname(__DIR__, 4) . '/phpbb/db/driver/driver_interface.php';
	require_once dirname(__DIR__, 4) . '/phpbb/db/tools/tools_interface.php';
	require_once dirname(__DIR__, 4) . '/phpbb/db/migration/migration_interface.php';
	require_once dirname(__DIR__, 4) . '/phpbb/db/migration/migration.php';
	require_once dirname(__DIR__) . '/tags/manager.php';
	require_once dirname(__DIR__) . '/provider/provider_interface.php';
	require_once dirname(__DIR__) . '/provider/provider_registry.php';
	require_once dirname(__DIR__) . '/provider/forum_provider.php';
	require_once dirname(__DIR__) . '/tags/moderation.php';
	require_once dirname(__DIR__) . '/tags/search_query.php';
	require_once dirname(__DIR__) . '/tags/filter_url.php';
	require_once dirname(__DIR__) . '/event/listener.php';
	require_once dirname(__DIR__) . '/migrations/v33x/m7_global_catalog_schema.php';
	require_once dirname(__DIR__) . '/migrations/v33x/m8_global_catalog_data.php';
	require_once dirname(__DIR__) . '/migrations/v33x/m9_global_catalog_constraints.php';
	require_once dirname(__DIR__) . '/migrations/v33x/m10_hierarchical_scopes.php';
	require_once dirname(__DIR__) . '/migrations/v33x/m11_tag_moderation.php';
	require_once dirname(__DIR__) . '/migrations/v33x/m12_catalog_ready.php';
}
