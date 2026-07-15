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
	'BBOPENGRAPH_TITLE'				=> 'BBopengraph settings',
	'BBOPENGRAPH_FB_ID'				=> 'Facebook ID',
	'BBOPENGRAPH_FB_ID_EXPLAIN'		=> 'You can retrieve this information by looking at the url of your profile photo on facebook.',
	'BBOPENGRAPH_FB_APPID'			=> 'Facebook Application ID',
	'BBOPENGRAPH_FB_APPID_EXPLAIN'	=> 'Enter your Facebook SDK App ID. You can create a new App via this link: <a href="https://developers.facebook.com/docs/opengraph/getting-started" target="blank">https://developers.facebook.com/docs/opengraph/</a> <br />If the App ID is entered the script will be injected after the forum body tag.<br />The SDK setup can be used to perform common tasks, such as the Like Button, wall comments etc.<br /> Configure and add external Facebook plugins via here: <a href="https://developers.facebook.com/docs/plugins/" target="blank">https://developers.facebook.com/docs/plugins/</a>',
	'BBOPENGRAPH_TW_ID'				=> 'Twitter ID',
	'BBOPENGRAPH_TW_ID_EXPLAIN'		=> 'This is your twitter handle. No need to add the @ sign. If entered twitter cards will be created when content is shared.',
	'BBOPENGRAPH_IMAGE'				=> 'Image path',
	'BBOPENGRAPH_IMAGE_EXPLAIN'		=> 'Relative path (from phpbbroot, ex. images/spacer.gif) to your image, if no topic attachments are found the placeholder provided will be used in topic. This is also needed for your index page. <br /> Image size requirements: <a href="https://developers.facebook.com/docs/sharing/best-practices#images" target="blank">https://developers.facebook.com/docs/sharing/best-practices#images</a>',
	
    'BBOPENGRAPH_NOTICE'			=> '<div class="phpinfo"><p>The settings for this extension are in %1$s » %2$s » %3$s.</p></div>',
));

// Description of Upload extension
$lang = array_merge($lang, array(
	'DESCRIPTION_PAGE'		   		=> 'Description',
	'DESCRIPTION_NOTICE'	   		=> 'Extension note',
	'ext_details' => array(
		'details' => array(
			'DESCRIPTION_1'			=> 'Options',
			'DESCRIPTION_2'			=> 'General options',
			'DESCRIPTION_3'			=> 'Post & Topic settings',
			'DESCRIPTION_4'			=> 'Default setup all users',
		),
		'note' => array(
			'NOTICE_1'				=> '3.2 ready.',
		)
	)
));
