<?php
/**
*
* @package phpBB Extension - LMDI My Topics
* @copyright (c) 2015-2017 Pierre Duhem — LMDI
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
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

// Some characters you may want to copy&paste:
// ’ » “ ” …


$lang = array_merge($lang, array(
	'ACP_MYTOP_TITLE'		=> 'Mes sujets',
	'ACP_MYTOP_CONFIG'		=> 'Configuration de l’extension',
	'ACP_MYTOP_UPDATED'		=> 'La configuration a bien été mise à jour.',
	'ACP_MYTOP_TOP'		=> 'Haut',
	'ACP_MYTOP_BOTTOM'		=> 'Bas',
	'MY_TOPICS'			=> 'Mes sujets',
	'MYTOP_POS'			=> 'Rubrique « Mes sujets » en haut du menu',
	'MYTOP_POS_EXPLAIN'		=> 'Sélectionnez « Haut » pour insérer le nouveau menu en haut du menu « Accès rapide ». Sélectionnez « Bas » pour le mettre à la fin.',
	'MYPOST_NO'			=> 'Masquage de la rubrique « Mes messages »',
	'MYPOST_NO_EXPLAIN'		=> 'Vous pouvez souhaiter masquer la rubrique « Mes messages » dans le menu « Accès rapide », dans la mesure où les deux rubriques ont une utilisation très proche.',
));
