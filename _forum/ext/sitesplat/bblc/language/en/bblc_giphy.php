<?php
/**
 * BBlivechat Giphy Addon
 * @copyright (c) 2021 SiteSplat. All rights reserved.
 * @license Proprietary
 */

if (!defined('IN_PHPBB')) {
	return;
}

if (empty($addon_lang)) {
	$addon_lang = [];
}

$addon_lang = array_merge($addon_lang, [
	'GIPHY_LABEL'		=> 'Giphy API Key',
	'GIPHY_EXPLAIN'		=> 'If you do not have a Giphy API key, you can generate one at <strong><a href="https://developers.giphy.com/dashboard/" target="_blank">developers.giphy.com/dashboard/</a></strong><br />
		Create a GIPHY API Key by clicking "Create an App". Select the API box and enter the app name and description you prefer.
		Once done, paste the API key in the field here to enable the chat GIPHY functionality. <strong>Note:</strong> All API Keys start as beta keys,
		which are rate limited (42 reads per hour and 1000 searches/API calls per day.)',
]);
