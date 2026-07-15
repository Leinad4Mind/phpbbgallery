<?php
/**
*
* @package phpBB Extension - Topic Index
* @copyright (c) 2015 dmzx - http://www.dmzx-web.net
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
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

// Merge the following language entries into the lang array
$lang = array_merge($lang, array(
	'OFFICIAL_TOPIC_INDEX'			=> 'Manage Official Topic Index Extension',
	'ADD_NEW_TOPICS_LIST'			=> 'Add a new list',
	'LIST_NAME'						=> 'List name',
	'OINDEX_CFG_SETUP'				=> 'Configure Official Topic Index',
	'OVERFLOW_IN_TOPIC'				=> 'Allow scroll bar on the inner topic list',
	'NAME_FORUM_LIST_EMPTY'			=> 'The list name can’t be empty.',
	'SELECT_FORUM_LIST_EMPTY'		=> 'At least a forum must be selected.',
	'OINDEX_ADDED_LIST'				=> 'List saved successfully.',
	'OINDEX_DELETED_LIST'			=> 'List successfully deleted.',
	'OINDEX_EDIT_CFG'				=> 'Config of Official Topic Index successfully edited.',
	'OINDEX_FORUMS'					=> 'Forums',
	'OINDEX_SELECT_FORUM'			=> 'Select a forum',
	'OTINDEX_LIST_ALONE_DSC'		=> 'Create a external list of all topics of a single forum or a set of forums together. Instead list in a topic, the external one do not need to be activated directly in the forum but in that case will be listed all topics with no choice.',
	'OTINDEX_LIST_INTOPIC_DSC'		=> 'Create a organized topics list that will appear inside a chosen topic. Once you active this function in all first post of each topic will appear new icons to insert or remove the topic from the list.',
	'ACTIVE_TOPIC_INDEX'			=> 'Active and select the topic for the list',
	'TOPIC_INDEX_DEFAULT'			=> 'Choose which topics to add by default.',
	'ACTIVE_TOPIC_INDEX_EXPLAIN'	=> 'Choose the topic from <strong>sticky or announce</strong> topics will become the list. So you must have at least one topic on the forum.',
	'TOPIC_INDEX_DEFAULT_EXPLAIN'	=> 'Choose the system by which the topics will included to the list',
	'ACTIVE_INDEX_FILTER'			=> 'Active tag filter',
	'ACTIVE_INDEX_FILTER_EXPLAIN'	=> 'You must activate this if you have topics with common TAG on title. We support tag with this format single or double: <strong>[]</strong>,<strong>{}</strong>,<strong>()</strong>.',
));
