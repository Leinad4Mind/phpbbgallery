<?php
/**
 * phpBB Gallery - BBPoints Images
 *
 * @package   phpbbgallery/bbpointsimages
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 */

if (!defined('IN_PHPBB'))
{
	exit;
}

$lang = array_merge($lang, [
	'BBPOINTSIMAGES_DEPENDENCIES_MISSING' => 'The required extensions are not enabled: %s.',
	'ACP_BBPOINTSIMAGES_SETTINGS' => 'BBPoints Images',
	'ACP_BBPOINTSIMAGES_SETTINGS_EXPLAIN' => 'Configure Gallery publication rewards and original-source access costs.',
	'ACP_BBPOINTSIMAGES_GLOBAL' => 'Global settings',
	'ACP_BBPOINTSIMAGES_UPLOAD_REWARD' => 'Reward per approved image',
	'ACP_BBPOINTSIMAGES_UPLOAD_REWARD_EXPLAIN' => 'Points credited once to the final author when an image is approved. Set to 0 to disable rewards.',
	'ACP_BBPOINTSIMAGES_SOURCE_COST' => 'Original source cost',
	'ACP_BBPOINTSIMAGES_SOURCE_COST_EXPLAIN' => 'Points required to purchase access to the original source. Set to 0 for free access.',
	'ACP_BBPOINTSIMAGES_ALBUM_RULES' => 'Album overrides',
	'ACP_BBPOINTSIMAGES_ALBUM_RULES_EXPLAIN' => 'Each value overrides its nearest ancestor independently. Use -1 to inherit.',
	'ACP_BBPOINTSIMAGES_ALBUM' => 'Album',
	'ACP_BBPOINTSIMAGES_INHERIT_EXPLAIN' => 'Use -1 to inherit the value from the nearest configured ancestor or from the global setting.',
	'ACP_BBPOINTSIMAGES_NO_ALBUMS' => 'No Gallery albums are available.',
	'ACP_BBPOINTSIMAGES_SAVED' => 'The BBPoints Images settings were saved.',
	'ACP_BBPOINTSIMAGES_SYNC' => 'Historical image rewards',
	'ACP_BBPOINTSIMAGES_SYNC_EXPLAIN' => 'Scan approved historical images and grant their configured publication reward. Existing rewards and exact duplicate files are skipped.',
	'ACP_BBPOINTSIMAGES_SYNC_BUTTON' => 'Synchronize historical rewards',
	'ACP_BBPOINTSIMAGES_SYNC_CONFIRM' => 'Are you sure you want to reward all eligible historical images using the current album policies?',
	'ACP_BBPOINTSIMAGES_SYNC_PROGRESS' => 'Historical reward synchronization is continuing. %1$d images scanned and %2$d rewards granted so far.',
	'ACP_BBPOINTSIMAGES_SYNC_COMPLETE' => 'Historical reward synchronization completed. %1$d images were scanned and %2$d rewards were granted.',
]);
