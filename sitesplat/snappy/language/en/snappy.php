<?php

/**
 *
 * Snappy Smart Reply
 *
 * @copyright (c) 2015-2022 SiteSplat All rights reserved
 * @license Proprietary
 *
 */

if (!defined('IN_PHPBB')) {
	exit;
}

if (empty($lang) || !is_array($lang)) {
	$lang = array();
}

$lang = array_merge($lang, array(

	'BBEMOJI_CHARS_REMAINING'	 => 'characters remaining',

));