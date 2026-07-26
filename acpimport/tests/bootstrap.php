<?php
// phpcs:ignoreFile PSR1.Files.SideEffects.FoundWithSymbols -- PHPUnit bootstrap intentionally defines IN_PHPBB before loading the class under test.
/**
 * phpBB Gallery - ACP Import Extension tests
 *
 * @package   phpbbgallery/acpimport
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

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

require_once dirname(__DIR__) . '/acp/import_storage.php';
require_once dirname(__DIR__) . '/acp/main_module.php';
