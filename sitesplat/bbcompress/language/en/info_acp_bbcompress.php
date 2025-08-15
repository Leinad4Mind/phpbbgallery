<?php
/**
*
* BBcompress
*
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
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

$lang = array_merge($lang, array(
	'ACP_BBCOMPRESS'				            => 'BBcompress',
	'ACP_BBCOMPRESS_TITLE'			            => 'BBcompress',
	'ACP_SETTINGS'					            => 'Settings',

	'BBCOMPRESS_NOTICE'						    => '<div class="phpinfo"><p>The settings for this extension are under the <strong>Extension</strong> tab.</p></div>',
	
	'ACP_BBCOMPRESS_SETTINGS_EXPLAIN'	        => 'BBcompress settings. Select, whether you want to optimize attached images in posts, PMs and **avatars (**<i>Avatars support ready. Just waiting for phpBB 3.1.9 core.events</i>) . Choose from the provided list of drivers the compression setting. Each driver outputs different results and or has optional settings and restrictions. <br /><br /><strong>BBcompress already optimized and saved you: %s</strong>.',

	'ACP_OPTIMIZER_GENERAL_OPTIONS'				=> 'General settings',
	'ACP_BBCOMPRESS_ALLOWED_POSTS'				=> 'Allow optimization on new images in posts',
	'ACP_BBCOMPRESS_ALLOWED_POSTS_EXPLAIN'		=> 'This will allow extension to optimize all new images upladed as attachments to posts and PMs.',
	'ACP_BBCOMPRESS_ALLOWED_AVATARS'			=> 'Allow optimization on new avatars',
	'ACP_BBCOMPRESS_ALLOWED_AVATARS_EXPLAIN'	=> 'This will allow extension to optimize all new images upladed as avatars.',

	'ACP_OPTIMIZER_DRIVER'			            => 'Optimizer driver',
	'ACP_OPTIMIZER_DRIVER_EXPLAIN'	            => 'Select from available list of optimizer drivers. Selected driver will optimize images before they are stored. Additional options may show up for selected driver, review them carefuly.',

	'ACP_TINIFY_API_KEY'			            => 'TinyPNG/JPG API key',
	'ACP_TINIFY_API_KEY_EXPLAIN'	            => 'Please fill in an API key to start compressing images. Visit <a href="https://tinypng.com/developers" target="_blank">TinyPNG/JPG Developer section</a> to get a free API key.',

	'ACP_BBCOMPRESS_SETTING_SAVED'	            => 'BBcompress settings saved',
	'ACP_TINIFY_API_KEY_INVALID'	            => 'TinyPNG/JPG API key is stored, but BBcompress was unable to verify your API key, or you have exceeded your limit. Please, try again with valid API key if exceeded limit is not your case. If you are sure your API key is correct and your limit is not exceeded, there may be a network issue. Please try again later.',
));
