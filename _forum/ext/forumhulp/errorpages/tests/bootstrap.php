<?php
/**
 *
 * @package Error Pages
 * @copyright (c) 2014 ForumHulp.com
 * @copyright (c) 2026 Leinad4Mind
 * @license https://opensource.org/licenses/GPL-2.0 GNU General Public License v2
 *
 */

namespace forumhulp\errorpages\event
{
	class page_state
	{
		public static $header;
		public static $footer;
	}

	function page_header($title, $display_online = false, $item_id = 0, $item = 'forum', $send_headers = true)
	{
		page_state::$header = [$title, $display_online, $item_id, $item, $send_headers];
	}

	function page_footer($run_cron = true, $display_template = true, $exit_handler = true)
	{
		page_state::$footer = [$run_cron, $display_template, $exit_handler];
	}

	function phpbb_insert_config_array($display_vars, $add_config_vars, $where)
	{
		if (!is_array($where) || !array_key_exists(current($where), $display_vars))
		{
			return $display_vars;
		}

		$position = array_search(current($where), array_keys($display_vars), true);
		$position += key($where) === 'before' ? 0 : 1;

		return array_merge(
			array_slice($display_vars, 0, $position),
			$add_config_vars,
			array_slice($display_vars, $position)
		);
	}
}

namespace
{
	error_reporting(E_ALL & ~E_DEPRECATED);

	if (!defined('IN_PHPBB'))
	{
		define('IN_PHPBB', true);
	}

	if (!defined('CONFIG_TABLE'))
	{
		define('CONFIG_TABLE', 'phpbb_config');
	}

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
	require $extension_root . '/event/listener.php';
	require $extension_root . '/event/acp_listener.php';
	require $extension_root . '/migrations/install_errorpages.php';
	require $extension_root . '/migrations/errorpages_3_2_0.php';
}
