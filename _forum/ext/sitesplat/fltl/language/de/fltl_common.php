<?php
/**
*
* Fancy Lazy Topics Loader
*
* @copyright (c) 2015 SiteSplat All rights reserved
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
	'FLTL'							=> 'Fancy Lazy Topics Loader',
	'FLTL_EXPLAIN'					=> 'Scrolle herunter für mehr Themen',
	'FLTL_BY'					    => '&nbsp;&#45;&nbsp;von&nbsp;',
	'FLTL_LIMIT'					=> 'Posts to display',
	'FLTL_LIMIT_EXPLAIN'			=> 'Setzt die Anzahl der Post-Blöcke pro Zeile (Standard: 4)',
	
	'FLTL_TIME'						=> 'Topic Fetch Limit',
	'FLTL_TIME_EXPLAIN'				=> 'Anzahl der Tage, wie weit zurück Beiträge aus der Datenbank geladen werden sollen.',

	'FLTL_TYPE'						=> 'Sortierreihenfolge',
	'FLTL_TYPE_EXPLAIN'				=> 'Zeige die ersten oder letzten Beiträge von kürzlich hinzugefügten Themen',
	
	'FLTL_EXCLUDED_FORUMS'			=> 'Schliesse Foren vom Fancy Lazy Topics loader aus',
	'FLTL_EXCLUDED_FORUMS_EXPLAIN'	=> 'Halte Shift oder Control gedrückt um mehrere Foren auszuwählen',
	
	'FLTL_PRIVATE'					=> '[private post]',
	'FLTL_READ_MORE'				=> 'MEHR LESEN',
	'FLTL_BACK_TO_START'			=> 'ZURÜCK ZUM ANFANG',
	'FLTL_VIEW_MORE_TOPICS'			=> 'MEHR THEMEN ANSEHEN'
));
