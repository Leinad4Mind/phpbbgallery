<?php
/**
 * BBlivechat Sidebar HTML Addon
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
	'BBLC_SBHTML'					=> 'Replacement sidebar HTML',
	'BBLC_SBHTML_EXPLAIN'			=> ' The limit is roughly 30K. <strong>Please make sure the HTML content is SAFE and VALID before submitting!</strong>',
]);
