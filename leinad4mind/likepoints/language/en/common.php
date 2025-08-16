<?php
if (!defined('IN_PHPBB'))
{
	exit;
}

if (!isset($lang) || !is_array($lang))
{
	$lang = [];
}

$lang = array_merge($lang, [
  'KUDOS_LABEL' => 'Kudos',
]);
