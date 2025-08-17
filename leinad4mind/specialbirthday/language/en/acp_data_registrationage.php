<?php
/**
*
* @package Registration Age Check
* @copyright (c) 2016 david63
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
	'AGE' 						=> 'Age',
	'AGE_AGREE'					=> 'Ages match',
	'AGE_ERROR'					=> 'Ages do not match',
	'AGE_QUERY'					=> 'Age missing',
	'ALL'						=> 'All',

	'CLEAR_FILTER'				=> 'Clear filter',

	'DATE_OF_BIRTH' 			=> 'Date of birth',

	'FILTER_BY'					=> 'Filter Username by',
	'FILTER_USERNAME'			=> 'Username',

	'OTHER'						=> 'Other',

	'PROFILE_DATA' 				=> 'From profile',

	'REG_AGE_SORT'				=> 'Sort',
	'REGISTRATION_DATA'			=> 'From registration',
	'REGISTRATION_DATA_EXPLAIN' => 'Here is a comparison of the dates of birth entered in the user’s profile and that entered at the time of registration.',

	'SORT_PROFILE'				=> 'Profile dob',
	'SORT_REGISTRATION'			=> 'Registration dob',
	'SORT_USERNAME'				=> 'Username',
	'STATUS' 					=> 'Status',

	'TOTAL_USERS'				=> 'User count : <strong>%1$s</strong>',

	'VERSION'					=> 'Version',


	// Translators - set these to whatever is most appropriate in your language
	// These are used to populate the filter keys
	'START_CHARACTER'		=> 'A',
	'END_CHARACTER'			=> 'Z',
));
