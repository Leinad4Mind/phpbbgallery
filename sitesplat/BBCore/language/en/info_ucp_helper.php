<?php
/**
*
* @package language
* @package sitesplat BBcore addon
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

$lang = array_merge(
	$lang, array(
		'UCP_IR'				    => 'Image Resizer',
		'IMAGE_RESIZE'			    => 'Image Resize',
		'IMAGE_RESIZE_EXPLAIN'	    => 'Crop your %1$s from the picture and confirm.',
		// Your avatar will be saved with a height of %1$s pixels and a width of %2$s pixels.',

		'IMAGE_RESIZE_ERROR'	    => 'No app or file to send!',
		'IMAGERESIZE_NOTICE'	    => '<div class="phpinfo"><p>There is no specific configuration for this extension. After the user uploaded the avatar via UCP Avatar upload, the crop option will be available.<br /> Check the ACP &#62; Avatar settings: "Maximum avatar file size" to be 0 or 2mb or more for a smooth user experience.</p></div>',
		'ERROR_IMAGERESIZE_DISABLE'	=> 'You cannot disable BBAvatarResize because of other active SiteSplat\'s extensions<br /><div>» %s</div>',
	    'SS_HELPER_NOTY'	    	=> 'SiteSplat BBcore does not exist!<br />Download the <a href="http://sitesplat.com" target="_blank">BBcore</a> and copy the BBcore folder into your sitesplat extension folder.',
	)
);
