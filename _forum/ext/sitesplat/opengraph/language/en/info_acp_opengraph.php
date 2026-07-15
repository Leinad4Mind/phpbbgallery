<?php
/**
*
* BBopengraph
*
* @copyright (c) 2015 SiteSplat All rights reserved
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
	'OPENGRAPH_TITLE'				=> 'BBopengraph settings',
	'OPENGRAPH_FB_ID'				=> 'Facebook ID',
	'OPENGRAPH_FB_ID_EXPLAIN'		=> 'You can retrieve this information by looking at the url of your profile photo on Facebook.<br />Check this example: <a href="http://i.gyazo.com/6b666b008dd0d45694e873689257fec2.png" target="blank">http://i.gyazo.com/6b666b008dd0d45694e873689257fec2.png</a>',
	'OPENGRAPH_FB_APPID'			=> 'Facebook application id',
	'OPENGRAPH_FB_APPID_EXPLAIN'	=> 'Enter your Facebook SDK App ID. You can create a new App via this link: <a href="https://developers.facebook.com/docs/opengraph/getting-started" target="blank">https://developers.facebook.com/docs/opengraph/</a> <br />The APP ID will look something like this: <a href="https://gyazo.com/f953cc65232d4aeafcf28a6d07c4eb34.png" target="blank">https://gyazo.com/f953cc65232d4aeafcf28a6d07c4eb34.png</a> <br />If the App ID is entered the script will be injected after the forum body tag.<br />The SDK setup can be used to perform common tasks, such as the Like Button, wall comments etc.<br /> Configure and add external Facebook plugins via here: <a href="https://developers.facebook.com/docs/plugins/" target="blank">https://developers.facebook.com/docs/plugins/</a>',
	'OPENGRAPH_TW_ID'				=> 'Twitter ID',
	'OPENGRAPH_TW_ID_EXPLAIN'		=> 'This is your twitter handle (Do NOT add the &#64; symbol). If entered Twitter and Open Graph tags to define a summary card will be created when content is shared. See: <a href="https://developer.twitter.com/en/docs/tweets/optimize-with-cards/guides/getting-started#opengraph" target="blank">Opengraph Twitter Summary Cards</a>',
	'OPENGRAPH_IMAGE'				=> 'Image path',
	'OPENGRAPH_IMAGE_EXPLAIN'		=> 'Relative path (from phpbb root, ex. images/spacer.gif) to your image, if no topic attachments are found the placeholder provided will be used in topic. This is also needed for your index page. <br /> Image size requirements: <a href="https://developers.facebook.com/docs/sharing/best-practices#images" target="blank">https://developers.facebook.com/docs/sharing/best-practices#images</a>',
	
    'OPENGRAPH_NOTICE'			    => '<div class="phpinfo"><p>The settings for this extension are in %1$s &#187; %2$s &#187; %3$s.</p></div>',
	'SS_HELPER_NOTY'				=> 'SiteSplat BBcore does not exist!<br />Download the <a href="https://sitesplat.com" target="_blank">BBcore</a> and copy the BBcore folder into your sitesplat extension folder.',
));
