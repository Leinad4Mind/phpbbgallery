<?php
/**
 * BBlivechat Custom CSS Addon
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
	'BBLC_CCLASS'					=> 'BBlivechat CSS classes',
	'BBLC_CCLASS_EXPLAIN'			=> 'Here you can specify CSS classes that will be applied to the main BBlivechat content area. Then you can add your custom CSS below to make your own adjustments.',
	'BBLC_CCSS'						=> 'BBlivechat custom CSS',
	'BBLC_CCSS_EXPLAIN'				=> 'Enter your BBlivechat custom CSS here. The limit is roughly 62K.',
]);
