<?php

/**
 * @package Avatar Resize for phpBB.
 * @copyright (c) 2016 SiteSplat All rights reserved
 * @license Proprietary
 * @translation Leinad4Mind [Brazilian Portuguese [pt_br]] (2026)
 */

/**
 * DO NOT CHANGE
 */
if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = [];
}

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
//
// Some characters you may want to copy&paste:
// ’ » “ ” …
//

$lang = array_merge(
	$lang, [
		'AVATAR_RESIZE'         => 'Redimensionamento de Avatar',
		'AVATAR_RESIZE_EXPLAIN' => 'Clique no botão com um lápis para cortar o seu %1$s e de seguida envie. O seu %1$s será guardado com uma altura de %2$s pixels e uma largura de %3$s pixels.',
		'BBAVATARRSIZE_NOTICE'  => '<div class="phpinfo"><p>Não existem definições específicas para esta extensão. Depois de o usuário enviar o avatar via PCU (Painel de Controlo do Usuário), a opção de corte ficará disponível.<br />Verifique o ACP &#62; Configurações de avatar: "Tamanho máximo do arquivo do avatar" em "0" ou "2mb" (ou superior) para uma experiência de utilização ideal e mais adequada.</p></div>',
		'SS_HELPER_NOTY'        => 'O SiteSplat BBcore não existe!<br />Faça o download do <a href="https://sitesplat.com" target="_blank">BBcore</a> e copie a pasta BBcore para a pasta da sua extensão sitesplat.',
	]
);
