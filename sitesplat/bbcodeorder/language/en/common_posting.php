<?php
/**
*
* BBcodeOrder+
* @copyright (c) 2016 SiteSplat All rights reserved
* @license Proprietary
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
	'BBCODE_B'						=> 'Bold',
	'BBCODE_I'						=> 'Italic',
	'BBCODE_U'						=> 'Underline',
	'BBCODE_L'						=> 'List',
	'BBCODE_O'						=> 'List Ordered',
	'BBCODE_LISTITEM'				=> 'List Item',
	'BBCODE_C'						=> 'Code',
	'BBCODE_Q'						=> 'Quote',
	'BBCODE_IMG'					=> 'Image',
	'BBCODE_URL'					=> 'URL',
	'BBCODE_FLASH'					=> 'FLASH',
));
