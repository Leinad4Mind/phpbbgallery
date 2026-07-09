<?php
/**
*
* @package Avatar Resize
* @copyright (c) 2016 SiteSplat All rights reserved
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
		'AVATAR_RESIZE'			=> 'Avatar Resize',
		'AVATAR_RESIZE_EXPLAIN'	=> 'Hit the pencil button to crop your %1$s, then submit. Your %1$s will be saved with a height of %2$s pixels and a width of %3$s pixels.',
		'BBAVATARRSIZE_NOTICE'	=> '<div class="phpinfo"><p>There is no specific configuration for this extension. After the user uploaded the avatar via UCP Avatar upload, the crop option will be available.<br /> Check the ACP &#62; Avatar settings: "Maximum avatar file size" to be 0 or 2mb or more for a smooth user experience.</p></div>',
		'SS_HELPER_NOTY'	    => 'SiteSplat BBcore does not exist!<br />Download the <a href="https://sitesplat.com" target="_blank">BBcore</a> and copy the BBcore folder into your sitesplat extension folder.',
	)
);
