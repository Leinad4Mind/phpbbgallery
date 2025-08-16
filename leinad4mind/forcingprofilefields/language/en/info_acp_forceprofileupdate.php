<?php

/**
 *
 * Forcing Profile Fields. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2017, leinad4mind, https://leinad4mind.top/forum
 * @license GNU General Public License, version 2 (GPL-2.0)
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
	'FORCINGPROFILEFIELDS_SKIP_METAREFRESH'			=> 'Skip meta-refresh when redirecting user to update his profile',
	'FORCINGPROFILEFIELDS_SKIP_METAREFRESH_EXPLAIN'	=> 'If set to yes, the user is redirected to the UCP profile edit page without any message being displayed.',
]);
