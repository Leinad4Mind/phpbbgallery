<?php
/**
 * phpBB Gallery Contest ACP language.
 *
 * @package   phpbbgallery/contest
 * @copyright 2018- Leinad4Mind
 * @license   GPL-2.0-only
 */

if (!defined('IN_PHPBB'))
{
	exit;
}

$lang = array_merge($lang, [
	'CONTEST_CREATION'                    => 'Allow new contests',
	'CONTEST_CREATION_EXPLAIN'            => 'Allows administrators to create new contest albums. Existing contests remain active and editable when this is disabled.',
	'CONTEST_CREATION_DISABLED'           => 'Creating new contest albums is disabled in the Gallery configuration.',
]);
