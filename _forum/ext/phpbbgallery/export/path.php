<?php
/**
 * phpBB Gallery - Export Extension
 *
 * @package   phpbbgallery/export
 * @author    Leinad4Mind
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

namespace phpbbgallery\export;

/**
 * Anchor the configured gallery paths to the board root.
 *
 * The container hands out paths relative to whichever script is running, and an
 * export is driven from the ACP, the UCP and the cron in turn. Resolving them the
 * same way the core file controller does keeps all three pointing at one directory.
 */
class path
{
	/**
	 * Turn a configured path into one that does not depend on the working directory.
	 *
	 * @param string $path Configured path
	 * @return string
	 */
	public static function resolve(string $path): string
	{
		$path = str_replace('\\', '/', $path);
		if (preg_match('#^(?:[a-z]:/|/)#i', $path))
		{
			return $path;
		}

		foreach (['files/phpbbgallery/', 'ext/phpbbgallery/'] as $root_marker)
		{
			$offset = strpos($path, $root_marker);
			if ($offset !== false)
			{
				return str_replace('\\', '/', dirname(__DIR__, 3)) . '/' . substr($path, $offset);
			}
		}

		return $path;
	}
}
