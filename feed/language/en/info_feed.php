<?php
/**
 * phpBB Gallery - Feed Extension
 *
 * @package   phpbbgallery/feed
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
* Language for the gallery feed
*/
$lang = array_merge($lang, [
	'FEED'						=> 'Feed',
	'FEED_SETTINGS'				=> 'Feed settings',

	'FEED_ENABLED'				=> 'Enable gallery feed',
	'FEED_ENABLED_EXPLAIN'		=> 'If enabled, the gallery publishes an ATOM feed of the newest images.',
	'FEED_ENABLED_PEGAS'		=> 'Include personal galleries',
	'FEED_ENABLED_PEGAS_EXPLAIN'=> 'If enabled, images from personal galleries may also appear in the feed. Album and viewing permissions are always honoured.',
	'FEED_LIMIT'				=> 'Number of items',
	'FEED_LIMIT_EXPLAIN'		=> 'Maximum number of images published in a single feed.',

	'ALBUM_FEED'				=> 'Publish this album in the feed',
	'ALBUM_FEED_EXPLAIN'		=> 'If disabled, images of this album never appear in the gallery feed.',

	'NO_FEED'					=> 'No feed is available for this album.',
	'NO_FEED_ENABLED'			=> 'The gallery feed is not enabled on this board.',

	'GALLERY_CORE_NOT_FOUND'	=> 'phpBB Gallery Core is missing! Please download it and install it before this extension.',
	'EXTENSION_ENABLE_SUCCESS'	=> 'The extension was enabled successfully.',
]);
