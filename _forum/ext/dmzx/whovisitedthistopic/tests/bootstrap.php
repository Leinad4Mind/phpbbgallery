<?php
/**
 *
 * @package phpBB Extension - Who Visited This Topic
 * @copyright (c) 2026 Leinad4Mind
 * @license https://opensource.org/licenses/GPL-2.0 GNU General Public License v2
 *
 */

error_reporting(E_ALL & ~E_DEPRECATED);

define('IN_PHPBB', true);
define('CONFIG_TABLE', 'phpbb_config');
define('FORUMS_TABLE', 'phpbb_forums');
define('FORUMS_ACCESS_TABLE', 'phpbb_forums_access');
define('USERS_TABLE', 'phpbb_users');
define('TOPICS_TABLE', 'phpbb_topics');

$phpbb_root = dirname(__DIR__, 4);
require $phpbb_root . '/vendor/autoload.php';

spl_autoload_register(function ($class) use ($phpbb_root) {
	if (strpos($class, 'phpbb\\') !== 0)
	{
		return;
	}

	$file = $phpbb_root . '/' . str_replace('\\', '/', $class) . '.php';
	if (is_file($file))
	{
		require $file;
	}
});

$extension_root = dirname(__DIR__);
require $extension_root . '/core/forum_access.php';
require $extension_root . '/core/profile_view.php';
require $extension_root . '/core/visit_repository.php';
require $extension_root . '/event/listener.php';
require $extension_root . '/migrations/whovisitedthistopic_1_1_0_data.php';
require $extension_root . '/migrations/whovisitedthistopic_1_1_0_schema.php';
require __DIR__ . '/template_noop_token_parser.php';
