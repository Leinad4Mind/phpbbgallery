<?php

/**
 * @package phpbbgallery/feed for phpBB.
 * phpBB Gallery - Feed Extension
 * @author    Leinad4Mind
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 * @translation Leinad4Mind [Dutch [nl]] (2026)
 */

/**
* @ignore
*/

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = [];
}

/**
* Language for the gallery feed
*/
$lang = array_merge($lang, [
	'FEED'						=> 'Feed',
	'FEED_SETTINGS'				=> 'Feedinstellingen',

	'FEED_ENABLED'				=> 'Galerijfeed inschakelen',
	'FEED_ENABLED_EXPLAIN'		=> 'Indien ingeschakeld publiceert de galerij een ATOM-feed met de nieuwste afbeeldingen.',
	'FEED_ENABLED_PEGAS'		=> 'Persoonlijke galerijen opnemen',
	'FEED_ENABLED_PEGAS_EXPLAIN'=> 'Indien ingeschakeld kunnen ook afbeeldingen uit persoonlijke galerijen in de feed verschijnen. Album- en weergaverechten worden altijd gerespecteerd.',
	'FEED_LIMIT'				=> 'Aantal items',
	'FEED_LIMIT_EXPLAIN'		=> 'Maximaal aantal afbeeldingen dat in één feed wordt gepubliceerd.',

	'ALBUM_FEED'				=> 'Dit album in de feed publiceren',
	'ALBUM_FEED_EXPLAIN'		=> 'Indien uitgeschakeld verschijnen afbeeldingen uit dit album nooit in de galerijfeed.',

	'NO_FEED'					=> 'Er is geen feed beschikbaar voor dit album.',
	'NO_FEED_ENABLED'			=> 'De galerijfeed is niet ingeschakeld op dit forum.',

	'GALLERY_CORE_NOT_FOUND'	=> 'De phpBB Gallery Core-extensie moet eerst worden geïnstalleerd en ingeschakeld.',
	'EXTENSION_ENABLE_SUCCESS'	=> 'De extensie is ingeschakeld.',
]);
