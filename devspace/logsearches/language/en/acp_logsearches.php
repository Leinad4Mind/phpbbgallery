<?php
/**
*
* @package Log Searches Extension
* @copyright (c) 2015 david63
* * @license GNU General Public License, version 2 (GPL-2.0)
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

/// DEVELOPERS PLEASE NOTE
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
	'NEW_VERSION'					=> 'New Version',
	'NEW_VERSION_EXPLAIN'			=> 'There is a newer version of this extension available.',

	'SEARCH_ALL'					=> 'All',
	'SEARCH_FAILED'					=> 'Failed',
	'SEARCH_LOG_ALL'				=> 'Log all searches',
	'SEARCH_LOG_ALL_EXPLAIN'		=> 'Setting this to “Failed” will only log searches that produce no results.',
	'SEARCH_LOG_PER_PAGE'			=> 'Items per page',
	'SEARCH_LOG_PER_PAGE_EXPLAIN'	=> 'Set the number of search log items per page.',
	'SEARCH_LOG_PRUNE_ALL'			=> 'Prune all search log entries',
	'SEARCH_LOG_PRUNE_ALL_EXPLAIN'	=> 'Setting this to “Successful” will only prune successful search log entries leaving failed searches in the log.',
	'SEARCH_LOG_PRUNE_DAYS'			=> 'Prune log file days',
	'SEARCH_LOG_PRUNE_DAYS_EXPLAIN'	=> 'The number of days to leave entries in the search log.<br>Setting this to zero will disable the pruning of the search log file.',
	'SEARCH_SUCCESSFUL'				=> 'Successful',

	'VERSION'						=> 'Version',
));

// Donate
$lang = array_merge($lang, array(
	'DONATE'					=> 'Donate',
	'DONATE_EXTENSIONS'			=> 'Donate to my extensions',
	'DONATE_EXTENSIONS_EXPLAIN'	=> 'This extension, as with all of my extensions, is totally free of charge. If you have benefited from using it then please consider making a donation by clicking the PayPal donation button opposite - I would appreciate it. I promise that there will be no spam nor requests for further donations, although they would always be welcome.',

	'PAYPAL_BUTTON'				=> 'Donate with PayPal button',
	'PAYPAL_TITLE'				=> 'PayPal - The safer, easier way to pay online!',
));
