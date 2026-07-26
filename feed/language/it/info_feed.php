<?php

/**
 * @package phpbbgallery/feed for phpBB.
 * phpBB Gallery - Feed Extension
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
* Language for the gallery feed
*/
$lang = array_merge($lang, [
	'FEED'						=> 'Feed',
	'FEED_SETTINGS'				=> 'Impostazioni del feed',

	'FEED_ENABLED'				=> 'Abilita il feed della galleria',
	'FEED_ENABLED_EXPLAIN'		=> 'Se abilitato, la galleria pubblica un feed ATOM con le immagini più recenti.',
	'FEED_ENABLED_PEGAS'		=> 'Includi le gallerie personali',
	'FEED_ENABLED_PEGAS_EXPLAIN'=> 'Se abilitato, anche le immagini delle gallerie personali possono comparire nel feed. I permessi di album e di visualizzazione sono sempre rispettati.',
	'FEED_LIMIT'				=> 'Numero di elementi',
	'FEED_LIMIT_EXPLAIN'		=> 'Numero massimo di immagini pubblicate in un feed.',

	'ALBUM_FEED'				=> 'Pubblica questo album nel feed',
	'ALBUM_FEED_EXPLAIN'		=> 'Se disabilitato, le immagini di questo album non compaiono mai nel feed della galleria.',

	'NO_FEED'					=> 'Non è disponibile alcun feed per questo album.',
	'NO_FEED_ENABLED'			=> 'Il feed della galleria non è abilitato su questo forum.',

	'GALLERY_CORE_NOT_FOUND'	=> 'L\'estensione phpBB Gallery Core deve essere prima installata e abilitata.',
	'EXTENSION_ENABLE_SUCCESS'	=> 'L\'estensione è stata abilitata con successo.',
]);
