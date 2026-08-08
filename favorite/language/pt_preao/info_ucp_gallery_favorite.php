<?php

/**
 * @package phpbbgallery/favorite for phpBB.
 * phpBB Gallery - Favorite Extension
 * @author    Leinad4Mind
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 * @translation Leinad4Mind [Portuguese [pt_preao]] (2026)
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
	'UCP_GALLERY_FAVORITES'		=> 'Gerir favoritos',
	'YOUR_FAVORITE_IMAGES'		=> 'Aqui podes ver as imagens que marcaste como favoritas. Podes remover as que já não queiras guardar.',

	'FAVORITE_IMAGE'			=> 'Adicionar aos favoritos',
	'UNFAVORITE_IMAGE'			=> 'Remover dos favoritos',
	'FAVORITED_IMAGE'			=> 'A imagem foi adicionada aos teus favoritos.',
	'UNFAVORITED_IMAGE'			=> 'A imagem foi removida dos teus favoritos.',
	'UNFAVORITED_IMAGES'		=> 'As imagens foram removidas dos teus favoritos.',

	'REMOVE_FROM_FAVORITES'		=> 'Remover dos favoritos',
	'NO_FAVORITES'				=> 'Não tens nenhum favorito.',
	'FAVORITE_CHOOSE_ACTION'	=> 'Escolhe uma acção',
	'TOTAL_FAVORITES'			=> [
		0	=> 'Nenhum favorito',
		1	=> '%d favorito',
		2	=> '%d favoritos',
	],

	'FAVORITE_NOT_AUTHORISED'	=> 'Não tens permissão para marcar esta imagem como favorita.',
	'LOGIN_EXPLAIN_FAVORITE'	=> 'Tens de estar registado e com sessão iniciada para adicionares imagens aos favoritos.',

	'WATCH_FAVO'				=> 'Subscrever as imagens que marco como favoritas',
	'WATCH_FAVO_EXPLAIN'		=> 'Se activado, ao adicionares uma imagem aos favoritos passas também a ser notificado dos novos comentários dela.',

	'GALLERY_CORE_NOT_FOUND'	=> 'A extensão phpBB Gallery Core deve ser instalada e activada primeiro.',
	'EXTENSION_ENABLE_SUCCESS'	=> 'A extensão foi activada com sucesso.',
	'FAVORITE_SHOW_IN_LISTINGS' => 'Mostrar os controlos de favoritos nas listagens de imagens',
	'FAVORITE_SHOW_IN_LISTINGS_EXPLAIN' => 'Mostra o coração dos favoritos nos álbuns e nos resultados da pesquisa. Se estiver desactivado, os membros continuam a poder gerir os favoritos na página de cada imagem.',
]);
