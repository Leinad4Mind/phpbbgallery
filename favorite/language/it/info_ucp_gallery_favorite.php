<?php

/**
 * @package phpbbgallery/favorite for phpBB.
 * phpBB Gallery - Favorite Extension
 * @author    Leinad4Mind
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 * @translation Leinad4Mind [Italian [it]] (2026)
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
* Language for the Gallery favorites and UCP module
*/
$lang = array_merge($lang, [
	'UCP_GALLERY_FAVORITES'		=> 'Gestisci preferiti',
	'YOUR_FAVORITE_IMAGES'		=> 'Qui puoi vedere le immagini che hai segnato come preferite. Puoi rimuovere quelle che non vuoi più conservare.',

	'FAVORITE_IMAGE'			=> 'Aggiungi ai preferiti',
	'UNFAVORITE_IMAGE'			=> 'Rimuovi dai preferiti',
	'FAVORITED_IMAGE'			=> 'L\'immagine è stata aggiunta ai tuoi preferiti.',
	'UNFAVORITED_IMAGE'			=> 'L\'immagine è stata rimossa dai tuoi preferiti.',
	'UNFAVORITED_IMAGES'		=> 'Le immagini sono state rimosse dai tuoi preferiti.',

	'REMOVE_FROM_FAVORITES'		=> 'Rimuovi dai preferiti',
	'NO_FAVORITES'				=> 'Non hai nessun preferito.',
	'FAVORITE_CHOOSE_ACTION'	=> 'Scegli un\'azione',
	'TOTAL_FAVORITES'			=> [
		0	=> 'Nessun preferito',
		1	=> '%d preferito',
		2	=> '%d preferiti',
	],

	'FAVORITE_NOT_AUTHORISED'	=> 'Non hai il permesso di aggiungere questa immagine ai preferiti.',
	'LOGIN_EXPLAIN_FAVORITE'	=> 'Devi essere registrato e connesso per aggiungere immagini ai tuoi preferiti.',

	'WATCH_FAVO'				=> 'Iscrivimi alle immagini che aggiungo ai preferiti',
	'WATCH_FAVO_EXPLAIN'		=> 'Se abilitato, aggiungendo un\'immagine ai preferiti verrai avvisato anche dei suoi nuovi commenti.',

	'GALLERY_CORE_NOT_FOUND'	=> 'L\'estensione phpBB Gallery Core deve essere prima installata e abilitata.',
	'EXTENSION_ENABLE_SUCCESS'	=> 'L\'estensione è stata abilitata con successo.',
]);
