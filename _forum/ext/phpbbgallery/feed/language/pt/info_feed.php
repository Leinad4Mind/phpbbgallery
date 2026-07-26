<?php

/**
 * @package phpbbgallery/feed for phpBB.
 * phpBB Gallery - Feed Extension
 * @author    Leinad4Mind
 * @copyright 2026 Leinad4Mind
 * @license   GPL-2.0-only
 * @translation Leinad4Mind [Portuguese [pt]] (2026)
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
	'FEED_SETTINGS'				=> 'Definições do feed',

	'FEED_ENABLED'				=> 'Ativar o feed da galeria',
	'FEED_ENABLED_EXPLAIN'		=> 'Se ativado, a galeria publica um feed ATOM com as imagens mais recentes.',
	'FEED_ENABLED_PEGAS'		=> 'Incluir galerias pessoais',
	'FEED_ENABLED_PEGAS_EXPLAIN'=> 'Se ativado, as imagens das galerias pessoais também podem aparecer no feed. As permissões de álbum e de visualização são sempre respeitadas.',
	'FEED_LIMIT'				=> 'Número de itens',
	'FEED_LIMIT_EXPLAIN'		=> 'Número máximo de imagens publicadas num feed.',

	'ALBUM_FEED'				=> 'Publicar este álbum no feed',
	'ALBUM_FEED_EXPLAIN'		=> 'Se desativado, as imagens deste álbum nunca aparecem no feed da galeria.',

	'NO_FEED'					=> 'Não existe nenhum feed disponível para este álbum.',
	'NO_FEED_ENABLED'			=> 'O feed da galeria não está ativado neste fórum.',

	'GALLERY_CORE_NOT_FOUND'	=> 'A extensão phpBB Gallery Core deve ser instalada e ativada primeiro.',
	'EXTENSION_ENABLE_SUCCESS'	=> 'A extensão foi ativada com sucesso.',
]);
