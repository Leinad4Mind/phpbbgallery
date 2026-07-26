<?php

/**
 * @package phpbbgallery/favorite for phpBB.
 * phpBB Gallery - Favorite Extension
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
* Language for the gallery favorites
*/
$lang = array_merge($lang, [
	'UCP_GALLERY_FAVORITES'		=> 'Favorieten beheren',
	'YOUR_FAVORITE_IMAGES'		=> 'Hier zie je de afbeeldingen die je als favoriet hebt opgeslagen. Je kunt de afbeeldingen verwijderen die je niet langer wilt bewaren.',

	'FAVORITE_IMAGE'			=> 'Aan favorieten toevoegen',
	'UNFAVORITE_IMAGE'			=> 'Uit favorieten verwijderen',
	'FAVORITED_IMAGE'			=> 'De afbeelding is aan je favorieten toegevoegd.',
	'UNFAVORITED_IMAGE'			=> 'De afbeelding is uit je favorieten verwijderd.',
	'UNFAVORITED_IMAGES'		=> 'De afbeeldingen zijn uit je favorieten verwijderd.',

	'REMOVE_FROM_FAVORITES'		=> 'Uit favorieten verwijderen',
	'NO_FAVORITES'				=> 'Je hebt geen favorieten.',
	'FAVORITE_CHOOSE_ACTION'	=> 'Kies een actie',
	'TOTAL_FAVORITES'			=> [
		0	=> 'Geen favorieten',
		1	=> '%d favoriet',
		2	=> '%d favorieten',
	],

	'FAVORITE_NOT_AUTHORISED'	=> 'Je mag deze afbeelding niet als favoriet opslaan.',
	'LOGIN_EXPLAIN_FAVORITE'	=> 'Je moet geregistreerd en ingelogd zijn om afbeeldingen aan je favorieten toe te voegen.',

	'WATCH_FAVO'				=> 'Abonneren op afbeeldingen die ik als favoriet opsla',
	'WATCH_FAVO_EXPLAIN'		=> 'Indien ingeschakeld word je bij het toevoegen van een afbeelding aan je favorieten ook op de hoogte gehouden van nieuwe reacties erop.',

	'GALLERY_CORE_NOT_FOUND'	=> 'De phpBB Gallery Core-extensie moet eerst worden geïnstalleerd en ingeschakeld.',
	'EXTENSION_ENABLE_SUCCESS'	=> 'De extensie is ingeschakeld.',
]);
