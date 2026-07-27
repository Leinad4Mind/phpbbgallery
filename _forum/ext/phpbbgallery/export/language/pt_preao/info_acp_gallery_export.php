<?php

/**
 * @package phpbbgallery/export for phpBB.
 * phpBB Gallery - Export Extension
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
* Language for the gallery export ACP module
*/
$lang = array_merge($lang, [
	'ACP_GALLERY_EXPORT'			=> 'Exportação da galeria',
	'ACP_GALLERY_EXPORT_EXPLAIN'	=> 'Exporta as imagens da galeria para um arquivo ZIP. Os ficheiros ficam com os nomes que o fórum mostra e agrupados nos seus álbuns, para que o arquivo seja legível, ao contrário dos nomes cifrados guardados no disco. É adicionado ao arquivo um manifesto com a lista de todas as imagens.',
]);
