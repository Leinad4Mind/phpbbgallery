<?php

/**
 * @package phpbbgallery/favorite for phpBB.
 * phpBB Gallery - Favorite Extension
 * @author    Leinad4Mind
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 * @translation Leinad4Mind [Brazilian Portuguese [pt_br]] (2026)
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
	'UCP_GALLERY_FAVORITES'		=> 'Gerenciar favoritos',
	'YOUR_FAVORITE_IMAGES'		=> 'Aqui você pode ver as imagens que marcou como favoritas. Você pode remover as que não quiser mais guardar.',

	'FAVORITE_IMAGE'			=> 'Adicionar aos favoritos',
	'UNFAVORITE_IMAGE'			=> 'Remover dos favoritos',
	'FAVORITED_IMAGE'			=> 'A imagem foi adicionada aos seus favoritos.',
	'UNFAVORITED_IMAGE'			=> 'A imagem foi removida dos seus favoritos.',
	'UNFAVORITED_IMAGES'		=> 'As imagens foram removidas dos seus favoritos.',

	'REMOVE_FROM_FAVORITES'		=> 'Remover dos favoritos',
	'NO_FAVORITES'				=> 'Você não tem nenhum favorito.',
	'FAVORITE_CHOOSE_ACTION'	=> 'Escolha uma ação',
	'TOTAL_FAVORITES'			=> [
		0	=> 'Nenhum favorito',
		1	=> '%d favorito',
		2	=> '%d favoritos',
	],

	'FAVORITE_NOT_AUTHORISED'	=> 'Você não tem permissão para marcar esta imagem como favorita.',
	'LOGIN_EXPLAIN_FAVORITE'	=> 'Você precisa estar registrado e conectado para adicionar imagens aos favoritos.',

	'WATCH_FAVO'				=> 'Acompanhar as imagens que eu marcar como favoritas',
	'WATCH_FAVO_EXPLAIN'		=> 'Se habilitado, ao adicionar uma imagem aos favoritos você também passa a ser notificado sobre os novos comentários dela.',

	'GALLERY_CORE_NOT_FOUND'	=> 'A extensão phpBB Gallery Core deve ser instalada e habilitada primeiro.',
	'EXTENSION_ENABLE_SUCCESS'	=> 'A extensão foi habilitada com sucesso.',
	'FAVORITE_SHOW_IN_LISTINGS' => 'Mostrar os controles de favoritos nas listas de imagens',
	'FAVORITE_SHOW_IN_LISTINGS_EXPLAIN' => 'Mostra o coração dos favoritos nos álbuns e nos resultados da pesquisa. Se desativado, os membros ainda podem gerenciar favoritos na página de cada imagem.',
]);
