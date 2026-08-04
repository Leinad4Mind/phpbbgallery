<?php
/**
 * Topic Index Bridge language file.
 * @copyright (c) 2018 kasimi - https://kasimi.net
 * @copyright (c) 2026 Leinad4Mind
 * @license GNU General Public License, version 2 (GPL-2.0)
 */

if (!defined('IN_PHPBB'))
{
	exit;
}

$lang = array_merge($lang, [
	'TOPICINDEX_BRIDGE_TITLE'                    => 'Topic Index Bridge',
	'TOPICINDEX_BRIDGE_EXPLAIN'                  => 'Enable each optional integration independently. An integration only runs when its dependency is enabled.',
	'TOPICINDEX_BRIDGE_FORUMINFO'                => 'Forum information and topic icons',
	'TOPICINDEX_BRIDGE_QTE'                      => 'Quick Title Edition attributes',
	'TOPICINDEX_BRIDGE_BBPREFIX'                 => 'BBPrefix prefixes',
	'TOPICINDEX_BRIDGE_BBEMOJI'                  => 'BBEmoji in topic titles',
	'TOPICINDEX_BRIDGE_TOPICIMAGEPREVIEW'        => 'Topic Image Preview',
	'TOPICINDEX_BRIDGE_USERTOPICS'               => 'User topic indexes',
	'TOPICINDEX_BRIDGE_ACTIVE'                   => 'Available and active.',
	'TOPICINDEX_BRIDGE_INACTIVE'                 => 'Available but disabled.',
	'TOPICINDEX_BRIDGE_UNAVAILABLE'              => 'The required extension or service is not available.',
	'TOPICINDEX_BRIDGE_LEGACY_ACTIVE'            => 'A legacy Kasimi bridge is active, so this module is temporarily suppressed to prevent duplicate output.',
	'TOPICINDEX_BRIDGE_PROFILE_LIST'             => 'Profile topic list',
	'TOPICINDEX_BRIDGE_PROFILE_LIST_EXPLAIN'     => 'Standalone list used by the link on member profiles.',
	'TOPICINDEX_BRIDGE_SELF_LIST'                => 'Current user topic list',
	'TOPICINDEX_BRIDGE_SELF_LIST_EXPLAIN'        => 'Standalone list used by the quick link for the signed-in user.',
]);
