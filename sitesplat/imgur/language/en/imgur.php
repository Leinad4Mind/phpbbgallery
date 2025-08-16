<?php
/**
*
* Imgur - forum images uploader
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

$lang = array_merge($lang, array(
	'IMGUR_CLIENT_ID'			=> 'IMGUR Client ID',
	'IMGUR_CLIENT_ID_EXPLAIN'	=> 'You need to register an Imgur app to get the <strong>Client ID</strong>.<br /> For creating a new App go to <a href="https://api.imgur.com/oauth2/addclient" target="_blank">this page</a>. Then enter the Client ID here.',
	
	'IMGUR_UPLOAD_TITLE'		=> 'Upload an Image',
	'IMGUR_UPLOAD_MAIN'			=> 'Upload an Image to use in topic via <a href="https://imgur.com" target="_blank">IMGUR</a> service. The image is automatically inserted in the post field above once submitted',
	'IMGUR_UPLOAD'				=> 'Upload Image now',
	'IMGUR_SELECT'				=> 'Select Image',
    'IMGUR_COPY'				=> 'Copy',
       
	'IMGUR_OUTPUT_LINK'			=> 'Direct link',
	'IMGUR_OUTPUT_IMAGE'		=> 'BBcode tag',
	'IMGUR_OUTPUT_IMAGE_DELETE'	=> 'Deletion Link',
	'IMGUR_OUTPUT_MARKDOWN'	    => 'Markdown',
	'MARKDOWN_WHATIS'	        => '<a href="//themeforest.net/user/themesplat/portfolio?ref=ThemeSplat" title="for use with &#34;BBmarkdown&#34; Premium extension for phpBB Premium themes" target="_blank"><i class="fa fa-question-circle"></i></a>',
	'IMGUR_OUTPUT_PLACEHOLDER'	=> 'Waiting image upload...',

	'IMGUR_SIGNATURE'	=> 'Allow use of IMGUR image upload in user signatures',

	'ALLOW_IMGUR'					=> 'Allow IMGUR avatars',
	'AVATAR_DRIVER_IMGUR_TITLE'		=> 'IMGUR avatar',
	'AVATAR_DRIVER_IMGUR_EXPLAIN'	=> '',
	'IMGUR_AVATAR'					=> 'IMGUR avatar',

	'IMGUR_QUICKREPLY'	=> 'Allow IMGUR in Snappy Smart Reply',

));
