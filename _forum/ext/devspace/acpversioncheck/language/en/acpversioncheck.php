<?php
/**
 *
 * @package ACP Version Check
 * @copyright (c) 2022 devspace
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

/**
 * DO NOT CHANGE
 */
if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = [];
}

/**
 * DEVELOPERS PLEASE NOTE
 *
 * All language files should use UTF-8 as their encoding and the files must not contain a BOM.
 *
 * Placeholders can now contain order information, e.g. instead of
 * 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
 * translators to re-order the output of data while ensuring it remains correct
 *
 * You do not need this where single placeholders are used, e.g. 'Message %d' is fine
 * equally where a string contains only two placeholders which are used to wrap text
 * in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
 *
 * Some characters you may want to copy&paste:
 * ’ » “ ” …
 *
 */

$lang = array_merge($lang, [
	'CONSTANT_VERSION' 		=> 'phpBB version in “includes/constants.php”',

	'DATABASE_VERSION' 		=> 'phpBB version reported by the database',

	'HIDE' 					=> '«« hide details ««',

	'LANG_NAME' 			=> 'Languages',
	'LANG_VERSION' 			=> 'Language version',

	'MISSING'				=> '«« Data missing »»',

	'NOT_VALID_LANG'		=> 'Not a valid phpBB4 language pack',
	'NOT_VALID_STYLE'		=> 'Not a valid phpBB4 style',

	'PHPBB'					=> 'phpBB',
	'PHPBB_VERSION' 		=> 'phpBB Version',

	'STYLE_NAME' 			=> 'Styles',
	'STYLE_VERSION' 		=> 'Style version',
	'SYMFONY_VERSION' 		=> 'Symfony version',

	'TWIG_VERSION' 			=> 'Twig version',

	'VENDOR'				=> 'Vendor',
	'VENDOR_VERSION' 		=> 'Vendor Version',
	'VERSION' 				=> 'Version',
	'VERSION_INFO' 			=> 'Version information',
	'VERSIONS_CORRECT' 		=> 'All phpBB versions on this board are consistent.',
	'VERSIONS_INCORRECT'	=> 'There are inconsistencies with the phpBB versions on this board',
	'VIEW' 					=> '»» view details »»',
]);
