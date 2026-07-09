<?php
/**
*
* @package BBemoji
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
	'ACP_BBEMOJI'					=> 'Topic Icons - BBemoji Enabled',
	'ACP_BBEMOJI_TITLE_EXPLAIN'		=> 'NOTE: You can enable/disable topic subject BBemoji per forum basis (disabled globally by default), via ACP > FORUMS (edit forum option). <br />Also, topic icons can be enabled/disabled per forum basis as well. ACP > FORUMS (edit forum option). Enjoy!',
	'SS_HELPER_NOTY'	            => 'SiteSplat BBcore does not exist!<br />Download the <a href="http://sitesplat.com" target="_blank">BBcore</a> and copy the BBcore folder into your sitesplat extension folder.',
	'BBEMOJI_NOTICE'	            => '<div class="phpinfo"><p>Type a semicolon in posting page or quick reply form, like this ":" to get the autosuggest to show up.<br />The emoji can be disabled at the user level via <strong>UCP &#187; Board preferences &#187; Edit display options &#187; "Display smilies as images"</strong><br />Note: Emoji are also automatically enabled for <strong>topic icons</strong>(they can be added/edited from ACP, Postings, Topic Icons).<br>Emoji are also available for "post subjects". They are disabled by default but they can be enabled under ACP &#187; FORUMS &#187; (edit forum by clicking on the cog icon) &#187; "Enable BBemoji in subject".<br> Other Premium extensions like <strong>"BBstatus"</strong>, <strong>"BBgreetings"</strong>, <strong>"BBreaction"</strong> etc, will also support BBemoji if you have it installed.</p></div>',

	'ICON_ADD'						=> 'Add new icon',
	'ICON'							=> 'Custom Topic icon',
	'ICON_EXPLAIN'					=> 'Add your custom icon path, relative to phpBB root, here.',
	'ICON_EMOJI'					=> 'Emoji Icon',
	'ICON_EMOJI_EXPLAIN'			=> 'Start typing a semicolon to get the list of the emoji from the autosuggestion menu',
	'ICON_ADDED'					=> 'New icon has been added',
	'ICON_NOT_EXIST'				=> 'Icon does not exist',

	'ENABLE_SUBJECT_EMOJI'			=> 'Enable BBemoji in subject',
    'ENABLE_SUBJECT_EMOJI_EXPLAIN'	=> 'Enable/disable emoji in topic subject. There is some considerations to be taken into account and a "wise" Admin should definitely read about the impact of emoji in title. Here are some recent great articles: <a href="https://yoast.com/ask-yoast-emojis-seo/" target="_blank">Emojis and SEO</a> and: <a href="https://www.wordtracker.com/academy/seo/page-optimization/will-an-emoji-in-the-description-harm-my-rankings" target="_blank">Will an emoji in the description harm my rankings?</a>.',
	
	// BBreaction
	'ACP_BBREACTION_EMOJI'			=> 'BBemoji',
	'ACP_BBREACTION_EMOJI_EXPLAIN'	=> 'Pick a BBemoji as icon. Start by typing :.',
));

