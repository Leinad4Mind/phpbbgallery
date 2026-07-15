<?php

/**
*
* @package Special Birthday
* @copyright (c) 2019 Leinad4Mind
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
//
// Some characters you may want to copy&paste:
// ’ » “ ” …
//

$lang = array_merge($lang, array(
	'NEW_VERSION'							=> 'New Version',
	'NEW_VERSION_EXPLAIN'					=> 'There is a newer version of this extension available.',

	'REGISTRATION_AGE_ADMIN'				=> 'Allow admins/mods to see the age',
	'REGISTRATION_AGE_BAN_LENGTH'			=> 'Length of ban',
	'REGISTRATION_AGE_BAN_LENGTH_EXPLAIN'	=> 'The length of time that the user’s IP&nbsp;address will be banned.',
	'REGISTRATION_AGE_BAN_REASON'			=> 'Reason shown to the banned',
	'REGISTRATION_AGE_BAN_REASON_EXPLAIN'	=> 'This is the reason for the ban that will be shown to the user.',
	'REGISTRATION_AGE_MEMBERLIST'			=> 'Show age on memberlist (view profile)',
	'REGISTRATION_AGE_VIEWTOPIC'			=> 'Show age on viewtopic',
	'REGISTRATION_AGE_SEARCH'				=> 'Show age on search results (posts view)',
	'REGISTRATION_AGE_CHANGE'				=> 'Allow users to change their birthday',
	'REGISTRATION_AGE_EXPLAIN'				=> 'Select the age at which you want to limit access.',
	'REGISTRATION_AGE_REQUIRED'				=> 'Users are required to enter their birthday',
	'REGISTRATION_AGE_REG_DISPLAY'			=> 'Display birthday field on registration',
	'REGISTRATION_AGE_IP'					=> 'Block IP',
	'REGISTRATION_AGE_IP_EXPLAIN'			=> 'Ban the IP address for the user attempting to register under age.',
	'REGISTRATION_AGE_LOG'					=> 'Log failed attempts',
	'REGISTRATION_AGE_LOG_EXPLAIN'			=> 'Create a log entry for any attempted registrations that fail due to an incorrect age being entered.',
	'REGISTRATION_AGE_OPTIONS'				=> 'Special Birthdate options',

	'BAN_END_TEXT' => array(
		'0' 	=> 'Permanent',
		'30' 	=> '30 minute',
		'60' 	=> '1 hour',
		'360' 	=> '6 hours',
		'1440' 	=> '1 day',
		'10080' => '7 days',
		'20160'	=> '2 weeks',
		'40320'	=> '1 month',
	),
));
