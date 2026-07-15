<?php
/**
*
* Gyazo - forum images uploader
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
	'GYAZO_CLIENT_ID'			=> 'Gyazo Access Token',
	'GYAZO_CLIENT_ID_EXPLAIN'	=> 'You need to register a Gyazo app to get the <strong>Access Token</strong>.<br /> For creating a new App go to <a href="https://gyazo.com/api">https://gyazo.com/api</a>. Then enter the Access Token here.',
	
	'GYAZO_UPLOAD_TITLE'		=> 'Upload an Image',
	'GYAZO_UPLOAD_MAIN'			=> 'Upload an Image to use in topic via Gyazo service. The image is automatically inserted in the post field above once submitted',
	'GYAZO_UPLOAD'				=> 'Upload Image now',
	'GYAZO_SELECT'				=> 'Select Image',
    'GYAZO_COPY'				=> 'Copy',
       
	'GYAZO_OUTPUT_LINK'			=> 'Direct link',
	'GYAZO_OUTPUT_IMAGE'		=> 'BBcode tag',
	'GYAZO_OUTPUT_IMAGE_DELETE'	=> 'Deletion Link',
	'GYAZO_OUTPUT_MARKDOWN'	    => 'Markdown',
	'MARKDOWN_WHATIS'	        => '<a href="//themeforest.net/user/themesplat/portfolio?ref=ThemeSplat" title="for use with &#34;BBmarkdown&#34; Premium extension for phpBB Premium themes" target="_blank"><i class="fa fa-question-circle"></i></a>',
	'GYAZO_OUTPUT_PLACEHOLDER'	=> 'Waiting image upload...',

	'GYAZO_SIGNATURE'	=> 'Allow use of Gyazo image upload in user signatures',

	'ALLOW_GYAZO'					=> 'Allow Gyazo avatars',
	'AVATAR_DRIVER_GYAZO_TITLE'		=> 'Gyazo avatar',
	'AVATAR_DRIVER_GYAZO_EXPLAIN'	=> '',
	'GYAZO_AVATAR'					=> 'Gyazo avatar',

	'GYAZO_QUICKREPLY'	=> 'Allow Gyazo in Snappy Smart Reply',

));
