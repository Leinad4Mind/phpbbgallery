<?php
/**
*
* @package phpBB Extension - LMDI My Topics
* @copyright (c) 2015-2017 Pierre Duhem - LMDI
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

// Some characters you may want to copy&paste:
// ’ » “ ” …

$lang = array_merge($lang, array(
	'ACP_MYTOP_TITLE'		=> 'Your Topics',
	'ACP_MYTOP_CONFIG'		=> 'Extension settings',
	'ACP_MYTOP_UPDATED'		=> 'The configuration was successfully updated.',
	'ACP_MYTOP_TOP'		=> 'Top',
	'ACP_MYTOP_BOTTOM'		=> 'Bottom',
	'MY_TOPICS'			=> 'Your Topics',
	'MYTOP_POS'			=> '“Your Topics” as first item',
	'MYTOP_POS_EXPLAIN'		=> 'Select “Top” to put the new menu item at the beginning of the “Quick links” dropdown menu. Select “Bottom” to put it at the end.',
	'MYPOST_NO'			=> 'Hide the “Your Posts” item',
	'MYPOST_NO_EXPLAIN'		=> 'You may want to hide the “Your Posts” item in the “Quick links” menu, since both menu items are really similar.',
));
