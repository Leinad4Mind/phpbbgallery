<?php

/**
 * @package BB@mention for phpBB.
 * @copyright (c) 2015 SiteSplat All rights reserved
 * @license Proprietary
 * @translation Leinad4Mind [Portuguese [pt]] (2026)
 */

/**
 * DO NOT CHANGE
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
	'NOTIFICATION_BBMENTION'      => 'Foi <strong>Mencionado</strong> por %1$s em:',
	'NOTIFICATION_TYPE_BBMENTION' => 'Alguém menciona o teu nome (ou um grupo que lideras) numa publicação',
]);
