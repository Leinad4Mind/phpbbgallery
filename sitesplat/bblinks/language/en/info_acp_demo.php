<?php
/**
*
* @package sitesplat BBlinks
* @copyright (c) 2017 SiteSplat All rights reserved
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
	'BBLINKS_TITLE'			=> 'BBlinks',
	'BBLINKS_SETTING_SAVED'	=> 'BBlinks settings saved.',

	'BBLINKS_ENABLE'								=> 'Enable BBlinks',
	'BBLINKS_ENABLE_MODAL'							=> 'Enable modal for external links',
	'BBLINKS_ENABLE_MODAL_EXPLAIN'					=> 'A modal with confirmation will pop up after user clicks on external link.',
	'BBLINKS_SKIP_LINK_TYPES'						=> 'Skip link types',
	'BBLINKS_SKIP_LINK_TYPES_EXPLAIN'				=> 'Don\'t process links to these file types. Separate by pipe (|). Example: \'pdf|jpg|png\'.',
	'BBLINKS_INTERNAL_LINK_TYPES'					=> 'Internal link types',
	'BBLINKS_INTERNAL_LINK_TYPES_EXPLAIN'			=> 'Specified link types will be always considered internal. Separate by pipe (|). Example: \'pdf|jpg|png\'.',
	'BBLINKS_EXTERNAL_LINK_TYPES'					=> 'External link types',
	'BBLINKS_EXTERNAL_LINK_TYPES_EXPLAIN'			=> 'Specified link types will be always considered external. Separate by pipe (|). Example: \'zip|rar|7z\'.',
	'BBLINKS_FORBIDDEN_DOMAINS'						=> 'Forbidden domains',
	'BBLINKS_FORBIDDEN_DOMAINS_EXPLAIN'				=> 'List of domains for which links should be removed, separated by semicolons (;). Example: \'http://www.google.com\'',
	'BBLINKS_FORBIDDEN_NEW_URL'						=> 'Forbidden new URL',
	'BBLINKS_FORBIDDEN_NEW_URL_EXPLAIN'				=> 'URL to insert in place of any removed links. Example: \'http://www.google.com\' or \'#top\'',
	'BBLINKS_INTERNAL_LINK_CLASS'					=> 'Internal link class',
	'BBLINKS_EXTERNAL_LINK_CLASS'					=> 'External link class',
	'BBLINKS_INTERNAL_LINK_TARGET'					=> 'Internal link target',
	'BBLINKS_EXTERNAL_LINK_TARGET'					=> 'External link target',
	'BBLINKS_INTERNAL_LINK_REL'						=> 'Internal link rel',
	'BBLINKS_EXTERNAL_LINK_REL'						=> 'External link rel',
	'BBLINKS_LINK_REL_EXPLAIN'						=> 'See recommendations: <a href="https://webmasters.googleblog.com/2019/09/evolving-nofollow-new-ways-to-identify.html" target="_blank">googleblog.com</a> and: <a href="https://support.google.com/webmasters/answer/96569" target="_blank">support.google.com</a>',
	'BBLINKS_HIDE_LINKS_FROM_GUESTS'				=> 'Hide links from guests',
	'BBLINKS_HIDE_LINKS_FROM_GUESTS_TEXT'			=> 'Hide links from guests text',
	'BBLINKS_HIDE_LINKS_FROM_GUESTS_TEXT_EXPLAIN'	=> 'Text of the link will be replaced with this string.',
	'BBLINKS_SKIP_PREFIX_TYPES'						=> 'Skip prefix types',
	'BBLINKS_SKIP_PREFIX_TYPES_EXPLAIN'				=> 'Don\'t add an external link prefix for these file types.',
	'BBLINKS_EXTERNAL_PREFIX'						=> 'External link prefix',
	'BBLINKS_EXTERNAL_PREFIX_EXPLAIN'				=> 'Example: \'http://anonym.to?\'',
	'BBLINKS_INTERNAL_LINK_DOMAINS'					=> 'Internal link domains',
	'BBLINKS_INTERNAL_LINK_DOMAINS_EXPLAIN'			=> 'List of domains to be considered local, separated by semicolons (;). Example: \'http://www.alternate-domain.com\'',
	'BBLINKS_CPF_LINK_NEW_WINDOW'					=> 'Open Custom Profile Fields in a new window',
	'BBLINKS_SIGNATURE'								=> 'Apply settings above to signatures as well',

	'ACP_LOCALURLTOTEXT_TITLE'			=> 'Local URL To Text',
	'ACP_LOCALURLTOTEXT_SETTINGS'		=> 'Settings',
	'ACP_LOCALURLTOTEXT_SETTING_SAVED'	=> 'Settings have been saved successfully!',
	'ACP_LOCALURLTOTEXT_FORUM'			=> 'Placeholder for forum link text',
	'ACP_LOCALURLTOTEXT_FORUM_EXPLAIN'	=> 'Enter placeholder, HTML is allowed. Available variables: {FORUM_NAME}',
	'ACP_LOCALURLTOTEXT_TOPIC'			=> 'Placeholder for topic link text',
	'ACP_LOCALURLTOTEXT_TOPIC_EXPLAIN'	=> 'Enter placeholder, HTML is allowed. Available variables: {TOPIC_TITLE}, {FORUM_NAME}',
	'ACP_LOCALURLTOTEXT_POST'			=> 'Placeholder for post link text',
	'ACP_LOCALURLTOTEXT_POST_EXPLAIN'	=> 'Enter placeholder, HTML is allowed. Available variables: {USER_NAME}, {USER_COLOUR}, {POST_SUBJECT}, {TOPIC_TITLE}, {POST_OR_TOPIC_TITLE}, {FORUM_NAME}',
	'ACP_LOCALURLTOTEXT_USER'			=> 'Placeholder for user link text',
	'ACP_LOCALURLTOTEXT_USER_EXPLAIN'	=> 'Enter placeholder, HTML is allowed. Available variables: {USER_NAME}, {USER_COLOUR}',
	'ACP_LOCALURLTOTEXT_PAGE'			=> 'Placeholder for Pages link text',
	'ACP_LOCALURLTOTEXT_PAGE_EXPLAIN'	=> 'For the <a href="https://www.phpbb.com/customise/db/extension/pages/" target="_blank">Pages extension</a>. Enter placeholder, HTML is allowed. Available variables: {PAGE_TITLE}',
	'ACP_LOCALURLTOTEXT_CPF'			=> 'Replace links within Custom profile fields',
	'ACP_LOCALURLTOTEXT_CPF_EXPLAIN'	=> 'Whether local links should be replaced within Custom profile fields. Only Custom profile fields of type "URL (Link)" are considered.',
));
