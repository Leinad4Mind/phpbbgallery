<?php
/**
 * BBlivechat Dark Mode Addon
 * @copyright (c) 2020 SiteSplat. All rights reserved.
 * @license Proprietary
 */

if (!defined('IN_PHPBB')) {
	return;
}

if (empty($addon_lang)) {
	$addon_lang = [];
}

$addon_lang = array_merge($addon_lang, [
	'BBLC_DARKMODE'					=> 'Dark Mode CSS',
	'BBLC_DARKMODE_EXPLAIN'			=> 'Enter your Dark Mode CSS here. The limit is roughly 30K.',
]);
