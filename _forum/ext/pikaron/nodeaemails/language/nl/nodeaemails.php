<?php
/**
 *
 * No DEA Emails extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019 Picaron
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
	$lang = array();
}

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine

$lang = array_merge($lang, array(
		'NO_DEA_EMAILS_INSTALL_ERROR'		=> '“Geen DEA e-mails” kan niet worden geïnstalleerd.<br><br>- PhpBB 3.2.4 of hoger is vereist.',
		'NO_DEA_EMAILS_NO_CURL'				=> '“Geen DEA e-mails” kan niet worden geïnstalleerd.<br><br>- Is benodigd: PHP "curl" extensie geladen.',
		'NO_DEA_EMAILS_FOUND'				=> 'FOUT: Het ((%s)) E-mail DOMEIN is niet geldig.<br>Onze website ondersteunt GEEN wegwerp of tijdelijke e-mailaccounts <a href="https://bit.ly/2LBsbqe" target="_blank">(DEA)</a>.<br>Als u wilt registreren op onze website moet u een niet wegwerpbaar e-mailaccount gebruiken.',
));
