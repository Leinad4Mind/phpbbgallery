<?php
/**
 *
 * @package phpBB Extension - Forum Icons
 * @copyright (c) 2015 dmzx - https://www.dmzx-web.net
 * @license https://opensource.org/license/gpl-2-0 GNU General Public License v2
 *
 */

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = [];
}

$lang = array_merge($lang, [
	'AVAILABLE_FORUM_IMAGE'             => 'Available forum images',
	'AVAILABLE_FORUM_IMAGE_EXPLAIN'     => 'Select a PNG or GIF image. Previews are fitted within 32 × 32 pixels.',
	'SELECTED_FORUM_IMAGE'              => 'Selected forum image',
	'CLEAR_BUTTON'                      => 'Clear forum image',
	'FORUMICONS_DIRECTORY_UNAVAILABLE' => 'The images/forumicons directory does not exist or is not readable.',
	'FORUMICONS_NO_IMAGES'              => 'No PNG or GIF images were found in the images/forumicons directory.',
	'FORUMICONS_LIMIT_REACHED'          => 'Only the first 500 valid images are shown. Remove unused files to display the remaining images.',
]);
