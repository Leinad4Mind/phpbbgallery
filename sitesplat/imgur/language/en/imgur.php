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
	'IMGUR_CLIENT_ID_EXPLAIN'	=> 'You need to register an Imgur app to get the <strong>Client ID</strong>.<br /> For creating a new App go to <a href="https://api.imgur.com/oauth2/addclient">this page</a>. Then enter the Client ID here.',
	
	'IMGUR_UPLOAD_TITLE'		=> 'Upload an Image',
	'IMGUR_UPLOAD_MAIN'			=> 'Upload an Image to use in topic via Imgur service. The image is automatically inserted in the post field above once submitted',
	'IMGUR_UPLOAD'				=> 'Upload Image now',
	'IMGUR_SELECT'				=> 'Select Image',
    'IMGUR_COPY'				=> 'Copy',
       
	'IMGUR_OUTPUT_LINK'			=> 'Direct link',
	'IMGUR_OUTPUT_IMAGE'		=> 'BBcode tag',
	'IMGUR_OUTPUT_IMAGE_DELETE'	=> 'Deletion Link',
	'IMGUR_OUTPUT_PLACEHOLDER'	=> 'Waiting image upload...',

	'IMGUR_QUICKREPLY'	        => 'Allow IMGUR in Smart Snappy Reply',

));
