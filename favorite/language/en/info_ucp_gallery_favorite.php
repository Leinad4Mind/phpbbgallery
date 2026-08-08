<?php
/**
 * phpBB Gallery - Favorite Extension
 *
 * @package   phpbbgallery/favorite
 * @author    Leinad4Mind
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
  */

/**
* @ignore
*/

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = [];
}

/**
* Language for the Gallery favorites and UCP module
*/
$lang = array_merge($lang, [
	'UCP_GALLERY_FAVORITES'		=> 'Manage favorites',
	'YOUR_FAVORITE_IMAGES'		=> 'Here you can see the images you marked as favorite. You may remove the ones you no longer want to keep.',

	'FAVORITE_IMAGE'			=> 'Add to favorites',
	'UNFAVORITE_IMAGE'			=> 'Remove from favorites',
	'FAVORITED_IMAGE'			=> 'The image was added to your favorites.',
	'UNFAVORITED_IMAGE'			=> 'The image was removed from your favorites.',
	'UNFAVORITED_IMAGES'		=> 'The images were removed from your favorites.',

	'REMOVE_FROM_FAVORITES'		=> 'Remove from favorites',
	'NO_FAVORITES'				=> 'You do not have any favorites.',
	'FAVORITE_CHOOSE_ACTION'	=> 'Choose an action',
	'TOTAL_FAVORITES'			=> [
		0	=> 'No favorites',
		1	=> '%d favorite',
		2	=> '%d favorites',
	],

	'FAVORITE_NOT_AUTHORISED'	=> 'You are not allowed to favorite this image.',
	'LOGIN_EXPLAIN_FAVORITE'	=> 'You must be registered and logged in to add images to your favorites.',

	'WATCH_FAVO'				=> 'Subscribe to images I favorite',
	'WATCH_FAVO_EXPLAIN'		=> 'If enabled, adding an image to your favorites also subscribes you to its new comments.',

	'GALLERY_CORE_NOT_FOUND'	=> 'phpBB Gallery Core is missing! Please download it and install it before this extension.',
	'EXTENSION_ENABLE_SUCCESS'	=> 'The extension was enabled successfully.',
]);
