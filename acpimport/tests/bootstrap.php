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

require_once dirname(__DIR__) . '/acp/import_storage.php';
