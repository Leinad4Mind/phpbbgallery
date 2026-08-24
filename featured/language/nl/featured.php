<?php
/**
 * phpBB Gallery - Featured Images language.
 */

if (!defined('IN_PHPBB'))
{
	exit;
}

$lang = array_merge($lang, [
	'FEATURED_IMAGES' => 'Featured images',
	'FEATURED_SETTINGS' => 'Featured images and slideshow',
	'FEATURE_IMAGE' => 'Feature image',
	'UNFEATURE_IMAGE' => 'Remove from featured images',
	'FEATURED_IMAGE_ADDED' => 'The image was added to the featured selection.',
	'FEATURED_IMAGE_REMOVED' => 'The image was removed from the featured selection.',
	'FEATURED_NOT_AUTHORISED' => 'You are not authorised to curate featured images in this album.',
	'FEATURED_APPROVED_ONLY' => 'Only approved images can be featured.',
	'FEATURED_ENABLE' => 'Display featured images',
	'FEATURED_ENABLE_EXPLAIN' => 'Displays the moderator-curated selection on the Gallery index.',
	'FEATURED_COUNT' => 'Featured image count',
	'FEATURED_COUNT_EXPLAIN' => 'Number of visible featured images to display, from 1 to 20. Permission filtering is applied separately for every viewer.',
	'FEATURED_SLIDESHOW' => 'Use slideshow presentation',
	'FEATURED_SLIDESHOW_EXPLAIN' => 'Displays one large featured image at a time with accessible navigation. When disabled, the selection uses the configured Gallery card layout.',
	'FEATURED_AUTOPLAY' => 'Start slideshow automatically',
	'FEATURED_AUTOPLAY_EXPLAIN' => 'Autoplay is disabled for visitors who request reduced motion and can always be paused.',
	'FEATURED_INTERVAL' => 'Slideshow interval',
	'FEATURED_INTERVAL_EXPLAIN' => 'Time between automatic slide changes, from 3 to 30 seconds.',
	'FEATURED_INCLUDE_PERSONAL' => 'Include personal-album images',
	'FEATURED_INCLUDE_PERSONAL_EXPLAIN' => 'Allows selected images from personal albums to appear when the viewer has permission to see them.',
	'FEATURED_SLIDESHOW_CONTROLS' => 'Featured image controls',
	'FEATURED_PREVIOUS' => 'Previous featured image',
	'FEATURED_NEXT' => 'Next featured image',
	'FEATURED_PLAY' => 'Play slideshow',
	'FEATURED_PAUSE' => 'Pause slideshow',
	'FEATURED_GO_TO' => 'Show featured image %d',
	'GALLERY_CORE_NOT_FOUND' => 'Gallery Core 4.2.0 or newer must be installed and enabled before Featured Images can be enabled.',
]);
