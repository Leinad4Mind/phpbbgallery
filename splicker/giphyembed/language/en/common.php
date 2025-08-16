<?php
/**
* @package Splicker Giphy Embed
* @copyright (c) 2021 SplickerSnap.com
* @author Splicker
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

$lang = array_merge($lang, array(
	'ACP_GE_TITLE'				=> 'Splicker Giphy Settings',
	'ACP_GE_SETTINGS_TITLE'		=> 'Giphy Embed Settings',
	'ACP_GE'					=> 'Giphy Embed',
	'ACP_GE_DISPLAY_TITLE'		=> 'Setup',
	'ACP_GE_TITLE_SUB'			=> 'Adjust settings',
	'ACP_GE_ENABLE'				=> 'Enable Giphy',
	'ACP_GE_SETTINGS_SAVED'		=> 'Giphy Embed Settings Saved.',	
	'ACP_GE_ENABLE_TEXT'		=> 'Shows Giphy panel on posting page.',
	'ACP_YES'					=> 'Yes',
	'ACP_NO'					=> 'No',
	'ACP_GE_API'				=> 'API Key',
	'ACP_GE_API_TEXT'			=> 'Enter your Giphy API key',
	'ACP_GE_RATING'				=> 'Giphy Rating',
	'ACP_GE_SCROLL'				=> 'Enable Scroll',
	'ACP_GE_SCROLL_TEXT'		=> 'If enabled will show gifs full size in a scrollable box.',	
	'ACP_GE_RATING_TEXT'		=> 'Choose rating to show age/site appropriate gifs.',
	'ACP_GE_AG_G'				=> '(G) Kid Safe',
	'ACP_GE_AG_PG'				=> '(PG) May contain mild profanity',
	'ACP_GE_AG_PGT'				=> '(PG-13) May contain moderate profanity',
	'ACP_GE_AG_R'				=> '(R) Includes adult themed images',
	'GE_TAB_EXPLAIN'			=> 'Search for gifs to add to your post.',
	'GE_TAB_SEARCHBOX'			=> 'Enter search term',
	'GE_TAB'					=> 'Giphy Embed',
	'GE_BACK'					=> 'Back',
		
));
