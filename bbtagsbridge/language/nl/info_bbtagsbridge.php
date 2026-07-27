<?php
if (!defined('IN_PHPBB'))
{
	exit;
}
$lang = array_merge($lang ?? [], [
	'BBTAGSBRIDGE_DEPENDENCIES_MISSING' => 'De volgende vereiste extensies zijn niet beschikbaar of uitgeschakeld: %s.',
	'EXTENSION_ENABLE_SUCCESS' => 'De extensie is succesvol ingeschakeld.',
]);
