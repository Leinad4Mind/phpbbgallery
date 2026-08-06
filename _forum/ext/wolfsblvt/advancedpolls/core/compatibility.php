<?php
/**
 *
 * Advanced Polls
 *
 * @copyright (c) 2026 Leinad4Mind
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 *
 */

namespace wolfsblvt\advancedpolls\core;

final class compatibility
{
	/**
	 * Check the supported runtime range.
	 *
	 * phpBB releases enforce their own PHP upper bounds. This extension only
	 * enforces the oldest PHP API it uses and the supported phpBB major line.
	 *
	 * @param string $php_version PHP version
	 * @param string $phpbb_version phpBB version
	 * @return bool
	 */
	public static function supports($php_version, $phpbb_version)
	{
		return version_compare($php_version, '7.1.3', '>=')
			&& version_compare(strtolower($phpbb_version), '3.3.0', '>=')
			&& version_compare(strtolower($phpbb_version), '4.0.0@dev', '<');
	}
}
