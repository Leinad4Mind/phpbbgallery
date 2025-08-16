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
		'NO_DEA_EMAILS_INSTALL_ERROR'		=> '“No DEA Emails” can not be installed.<br><br>- PhpBB 3.2.4 or later is required.',
		'NO_DEA_EMAILS_NO_CURL'				=> '“No DEA Emails” can not be installed.<br><br>- Is required extension “curl” of PHP loaded.',
		'NO_DEA_EMAILS_FOUND'				=> 'ERROR: The ((%s)) Email DOMAIN is not valid.<br>Our website does NOT support disposable or temporary email accounts <a href="https://bit.ly/2LBsbqe" target="_blank">(DEA)</a>.<br>If you wish to continue registering on our website, you must use a non-disposable email account.',
		'NO_DEA_EMAILS_TITLE_FORCE_CHANGE'	=> 'Change Required by Extension “No Dea Emails”',
		'NO_DEA_EMAILS_FORCE_CHANGE'		=> 'Before you continue browsing the site you need to change your "Email".',
		'NO_DEA_EMAILS_NOT_FORCE_CHANGE'	=> 'Before you continue browsing the site you need to change your "Email".<br>You do not have permissions to make the change.<br>You need to contact the Site Administration and request your update.',
		'LOG_NO_DEA_EMAILS'					=> 'No DEA Emails',
		'LOG_NO_DEA_EMAILS_SETTINGS'		=> 'CRON Management & External DEA Mail Domains',
		'LOG_NO_DEA_EMAILS_LOCALS'			=> 'Local Management of Mail Domains DEA',
		'LOG_NO_DEA_EMAILS_USERS'			=> 'Users with DEA Mail Accounts',
));
