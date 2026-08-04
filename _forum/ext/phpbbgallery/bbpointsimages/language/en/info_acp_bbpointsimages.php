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
	'ACP_BBPOINTSIMAGES_ALBUM_RULES_EXPLAIN' => 'This read-only overview follows the Gallery album hierarchy. Edit an album to change its direct values; bold values are the settings currently in effect.',
	'ACP_BBPOINTSIMAGES_ALBUM' => 'Album',
	'ACP_BBPOINTSIMAGES_ALBUM_SETTINGS' => 'BBPoints Images',
	'ACP_BBPOINTSIMAGES_ALBUM_SETTINGS_EXPLAIN' => 'Use -1 to inherit each numeric value independently from the nearest configured parent or the global setting.',
	'ACP_BBPOINTSIMAGES_INHERIT' => 'Inherit',
	'ACP_BBPOINTSIMAGES_INHERIT_EXPLAIN' => 'Use -1 to inherit the value from the nearest configured ancestor or from the global setting.',
	'ACP_BBPOINTSIMAGES_EFFECTIVE_VALUE' => 'Effective value: %1$d.',
	'ACP_BBPOINTSIMAGES_EFFECTIVE_TOGGLE' => 'Effective setting: %1$s.',
	'ACP_BBPOINTSIMAGES_INHERITED' => 'Inherited',
	'ACP_BBPOINTSIMAGES_DIRECT_VALUE' => 'Direct value: %1$d',
	'ACP_BBPOINTSIMAGES_DIRECT_SETTING' => 'Direct setting',
	'ACP_BBPOINTSIMAGES_NO_ALBUMS' => 'No Gallery albums are available.',
	'ACP_BBPOINTSIMAGES_SAVED' => 'The BBPoints Images settings were saved.',
	'ACP_BBPOINTSIMAGES_SYNC' => 'Historical image rewards',
	'ACP_BBPOINTSIMAGES_SYNC_EXPLAIN' => 'Scan approved historical images and grant their configured publication reward. Existing rewards and exact duplicate files are skipped.',
	'ACP_BBPOINTSIMAGES_SYNC_BUTTON' => 'Synchronize historical rewards',
	'ACP_BBPOINTSIMAGES_SYNC_CONFIRM' => 'Are you sure you want to reward all eligible historical images using the current album policies?',
	'ACP_BBPOINTSIMAGES_SYNC_PROGRESS' => 'Historical reward synchronization is continuing. %1$d images scanned and %2$d rewards granted so far.',
	'ACP_BBPOINTSIMAGES_SYNC_COMPLETE' => 'Historical reward synchronization completed. %1$d images were scanned and %2$d rewards were granted.',
	'BBPOINTSIMAGES_SOURCE_LOGIN' => 'You must sign in to purchase this original image file.',
	'BBPOINTSIMAGES_SOURCE_PURCHASE_CONFIRM' => 'Downloading this original image file costs %1$d points. Do you want to continue?',
	'BBPOINTSIMAGES_INSUFFICIENT_FUNDS' => 'You have %1$d points, but this original image file requires %2$d points.',
	'BBPOINTSIMAGES_SOURCE_UNAVAILABLE' => 'The original image file cannot be purchased at this time.',
	'BBPOINTSIMAGES_DOWNLOADS' => 'Original downloads',
	'ACP_BBPOINTSIMAGES_CONTRIBUTORS' => 'Allow contributor assignment',
	'ACP_BBPOINTSIMAGES_CONTRIBUTORS_EXPLAIN' => 'Allow image authors and editors to record contributors. Existing contributors keep their attribution and share of paid downloads when this is disabled.',
	'ACP_BBPOINTSIMAGES_CONTRIBUTORS_BULK' => 'Contributor assignment for all albums',
	'ACP_BBPOINTSIMAGES_CONTRIBUTORS_BULK_EXPLAIN' => 'Set an explicit choice on every public album, or reset every album to inherit the global setting. Reward and source-cost overrides are preserved.',
	'ACP_BBPOINTSIMAGES_INHERIT_GLOBAL' => 'Make all albums inherit',
	'ACP_BBPOINTSIMAGES_ENABLE_ALL' => 'Enable on every album',
	'ACP_BBPOINTSIMAGES_DISABLE_ALL' => 'Disable on every album',
	'ACP_BBPOINTSIMAGES_APPLY_ALL' => 'Apply to all albums',
	'ACP_BBPOINTSIMAGES_CONTRIBUTORS_BULK_CONFIRM' => 'Are you sure you want to change contributor assignment for every public Gallery album?',
	'ACP_BBPOINTSIMAGES_CONTRIBUTORS_BULK_SAVED' => 'Contributor assignment was updated for every public Gallery album.',
	'BBPOINTSIMAGES_CONTRIBUTORS' => 'Contributors',
	'BBPOINTSIMAGES_CONTRIBUTORS_EXPLAIN' => 'Enter one registered username per line, up to %1$d. The image author is excluded automatically.',
	'BBPOINTSIMAGES_CONTRIBUTORS_UNKNOWN' => 'These contributors could not be found or are inactive: %1$s.',
	'BBPOINTSIMAGES_CONTRIBUTORS_TOO_MANY' => 'An image may have no more than %1$d contributors.',
	'NOTIFICATION_TYPE_BBPOINTSIMAGES_REWARD' => 'Gallery image rewards',
	'NOTIFICATION_BBPOINTSIMAGES_REWARD' => 'You received %1$d points for publishing image <strong>%2$s</strong>.',
	'NOTIFICATION_TYPE_BBPOINTSIMAGES_SOURCE_PURCHASE' => 'Gallery original-source sales',
	'NOTIFICATION_BBPOINTSIMAGES_SOURCE_PURCHASE' => '%1$s purchased the original source for <strong>%3$s</strong>; you received %2$d points.',
]);
