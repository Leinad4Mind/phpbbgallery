<?php
/**
*
* @package phpBB Extension - Official Topic Index
 * @copyright (c) 2015-2022 Leinad4Mind - https://leinad4mind.top/forum
* @copyright (c) 2015 dmzx - https://www.dmzx-web.net
 * @copyright (c) 2026 Leinad4Mind
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
	$lang = [];
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

$lang = array_merge($lang, [
	'ADD_INILIST'           => '+List',
	'REMOVE_INILIST'        => '-List',
	'OTINDEX_LINK_TITLE'    => 'Topics list',
	'NUM'                   => 'N°',
	'POSTER'                => 'Posted by',
	'INDEX_POST_PRES'       => 'Before to opening a new topic, please check if is not already in this list. If there is use that topic to write your posts.<br />Thanks',
	'NON_ACTIVE'            => 'Inactive',
	'DEF_ALL_TOPICS_IN'     => 'All new topic automatically',
	'DEF_ALL_TOPICS_OFF'    => 'Add manually topics to the list',
	'REMOVE_FROM_LIST'      => 'remove',
	'TOPICINDEX_VERSION'    => 'Version',
	'ALL'                   => 'All',
	'09'                    => '0-9',
	'SYMB'                  => '#&%',
	'ANY_TOPIC_IN_LIST'     => 'Any topics',
	'SELECT_A_LIST'         => 'Select a list',
	'OIINDEX_HEADER'        => 'Topics List',
	'LANGUAGE'              => 'Language',
	'CATEGORY'              => 'Category',
	'COMMENTS'              => 'Comments',
	'BUTTON_UPLOAD'         => 'Share Project',
	'BUTTON_UPLOAD_EXPLAIN' => 'Yes! Start sharing projects in our community!',
	'TOPICINDEX_FILTERS'        => 'Topic index filters',
	'TOPICINDEX_LIST_NOT_FOUND' => 'The requested topic list does not exist.',
	'LOG_TOPICINDEX_ADD_TOPIC'  => '<strong>Added topic to the topic index</strong><br>Topic ID: %d',
	'LOG_TOPICINDEX_REMOVE_TOPIC' => '<strong>Removed topic from the topic index</strong><br>Topic ID: %d',
]);
