<?php
/**
 *
 * BBwatchlist. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2018, SiteSplat
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 */

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

$lang = array_merge($lang, array(
	'SUBJECT_KEYWORD_NOTIFICATION_TITLE'	=> 'Überwachtes Schlüsselwort im Thema gefunden',
	'SUBJECT_KEYWORD_NOTIFICATION_CONTENT'	=> 'Das Schlüsselwort "%s" wurde in einem neu erstellten Thema gefunden.',
	'CONTENT_KEYWORD_NOTIFICATION_TITLE'	=> 'Überwachtes Schlüsselwort im Beitrag gefunden',
	'CONTENT_KEYWORD_NOTIFICATION_CONTENT'	=> 'Das Schlüsselwort "%s" wurde in einem neu erstellten Beitrag gefunden.',
));
