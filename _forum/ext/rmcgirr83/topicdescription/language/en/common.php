<?php
/**
*
* @package Topic description
* @copyright (c) 2016 Rich McGirr (RMcGirr83)
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

/**
* @ignore
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

/**
* DO NOT CHANGE
*/
if (empty($lang) || !is_array($lang))
{
	$lang = [];
}

$lang = array_merge($lang, [
	'TOPIC_DESC'				=> 'Original Title',
	'TOPIC_DESC_TITLE'			=> 'Original Title (Year)',
	'UNSUPPORTED_CHARACTERS_TD'	=> 'The topic description contains the following unsupported characters:<br />%s',
]);
