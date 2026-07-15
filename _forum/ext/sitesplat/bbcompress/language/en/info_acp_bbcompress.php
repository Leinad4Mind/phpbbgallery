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
	'ACP_BBCOMPRESS'							=> 'BBcompress',
	'ACP_BBCOMPRESS_TITLE'						=> 'BBcompress',
	'ACP_SETTINGS'								=> 'Settings',

	'SS_HELPER_NOTY'	                        => 'SiteSplat BBcore does not exist!<br />Download the <a href="https://sitesplat.com" target="_blank">BBcore</a> and copy the BBcore folder into your sitesplat extension folder.',
	'BBCOMPRESS_NOTICE'						    => '<div class="phpinfo"><p>The settings for this extension are under the <strong>Extension</strong> tab.</p></div>',
	'ACP_BBCOMPRESS_NOTE'					    => 'Please note, script timeout value as well as the max_upload_file_size might need to be increased. These can sometimes be overridden through .htaccess but not always. This is usually done via php.ini on your server configuration. If you get timeout errors ask your host to increase the script timeout value as well as the max_upload_file_size.',
	
	'ACP_BBCOMPRESS_SETTINGS_EXPLAIN'			=> 'Here you can set all BBcompress settings. Select, whether you want to optimize images in posts and PMs and/or avatars. Choose from the provided list of drivers the compression setting. Each driver outputs different results and/or has optional settings and restrictions. <br /><br /><strong>BBcompress already optimized and saved you: <span class="badge badge-success">%s</span></strong>',

	'ACP_OPTIMIZER_GENERAL_OPTIONS'				=> 'General settings',
	'ACP_BBCOMPRESS_ALLOWED_POSTS'				=> 'Allow optimization on new posted images',
	'ACP_BBCOMPRESS_ALLOWED_POSTS_EXPLAIN'		=> 'This will allow extension to optimize all new images uploaded as attachments to posts and PMs.',
	'ACP_BBCOMPRESS_ALLOWED_AVATARS'			=> 'Allow optimization on new avatars',
	'ACP_BBCOMPRESS_ALLOWED_AVATARS_EXPLAIN'	=> 'This will allow extension to optimize all new images uploaded as avatars.',

	'ACP_OPTIMIZER_DRIVER'						=> 'Optimizer driver',
	'ACP_OPTIMIZER_DRIVER_EXPLAIN'				=> 'Select from available list of optimizer drivers. Selected driver will optimize images before they are stored. Additional options may show up for selected driver, please, review them carefuly.',

	'ACP_IMAGEOPTIM_USERNAME'					=> 'ImageOptim username',
	'ACP_IMAGEOPTIM_USERNAME_EXPLAIN'			=> 'Please fill in an API username to start compressing images. Visit <a href="https://im2.io/register" target="_blank">ImageOptim API account registration page</a> to get an API username.',

	'ACP_KRAKEN_API_KEY'						=> 'Kraken API key',
	'ACP_KRAKEN_API_KEY_EXPLAIN'				=> 'Please fill in an API key to start compressing images. Visit <a href="https://kraken.io/account" target="_blank">Kraken Account section</a> to get an API key.',
	'ACP_KRAKEN_API_SECRET'						=> 'Kraken API secret',
	'ACP_KRAKEN_API_SECRET_EXPLAIN'				=> 'Please fill in an API secret to start compressing images. Visit <a href="https://kraken.io/account" target="_blank">Kraken Account section</a> to get an API secret.',

	'ACP_TINIFY_API_KEY'						=> 'TinyPNG API key',
	'ACP_TINIFY_API_KEY_EXPLAIN'				=> 'Please fill in an API key to start compressing images. Visit <a href="https://tinypng.com/developers" target="_blank">TinyPNG Developer section</a> to get an API key.',

	'ACP_TINIFY_RESIZE'							=> 'Resize method',
	'ACP_TINIFY_RESIZE_EXPLAIN'					=> 'Choose a resize method. Keep in mind, that resizing counts as one additional compression.<br>
												<strong>Scale</strong> scales the image down proportionally. You must provide either a target width or a target height, but not both. The scaled image will have exactly the provided width or height.<br>
												<strong>Fit</strong> scales the image down proportionally so that it fits within the given dimensions. You must provide both a width and a height. The scaled image will not exceed either of these dimensions.<br>
												<strong>Cover</strong> scales the image proportionally and crops it if necessary so that the result has exactly the given dimensions. You must provide both a width and a height. Which parts of the image are cropped away is determined automatically. An intelligent algorithm determines the most important areas and leaves these intact. You can <a href="mailto:support@tinify.com">send a feedback</a> to TinyPNG team about the algorithm.',
	'NO_RESIZE'									=> 'No resize',
	'RESIZE_SCALE'								=> 'Scale',
	'RESIZE_FIT'								=> 'Fit',
	'RESIZE_COVER'								=> 'Cover',
	'ACP_TINIFY_WIDTH'							=> 'Width',
	'ACP_TINIFY_HEIGHT'							=> 'Height',
	
	'ACP_TINIFY_WIDTH_EXPLAIN'					=> 'px unit size',
	'ACP_TINIFY_HEIGHT_EXPLAIN'					=> 'px unit size',
	
	'ACP_BBCOMPRESS_SETTING_SAVED'				=> 'BBcompress settings saved',
	'ACP_TINIFY_API_KEY_INVALID'				=> 'TinyPNG API key is stored, but BBcompress was unable to verify your API key, or you have exceeded your limit. Please, try again with valid API key if exceeded limit is not your case. If you are sure your API key is correct and your limit is not exceeded, there may be a problem in a network. In such case, please, try it later.',
	'ACP_KRAKEN_INACTIVE'						=> 'Your account is inactive. Please, check that it did not exceed quota.',
	'ACP_KRAKEN_API_KEY_INVALID'				=> 'Kraken keys are invalid. Please, review them.',
));
