<?php

/**
 * @package phpbbgallery/export for phpBB.
 * phpBB Gallery - Export Extension
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
* Language for the gallery export ACP module
*/
$lang = array_merge($lang, [
	'ACP_GALLERY_EXPORT'			=> 'Exportação da galeria',
	'ACP_GALLERY_EXPORT_EXPLAIN'	=> 'Exporta as imagens da galeria para um arquivo ZIP. Os arquivos ficam com os nomes que o fórum mostra e agrupados em seus álbuns, tornando o arquivo legível, ao contrário dos nomes cifrados salvos no disco. Um manifesto com a lista de todas as imagens é adicionado ao arquivo.',
]);
