<?php

/**
 * @package ReplyToUnhide for phpBB.
 * @copyright (c) 2016 SiteSplat <http://sitesplat.com>
 * @license Proprietary
 * @translation Leinad4Mind [Portuguese [pt_preao]] (2026)
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

$lang = array_merge($lang, [
	'REPLYTOUNHIDE_NOTICE' => '<div class="phpinfo"><p>Não existem definições para esta extensão. O BBcode HIDE está disponível para ser usado na página de publicação de mensagens.</p></div>',
	'SS_HELPER_NOTICE'     => 'A extensão BBcore não existe!<br />Transfere o <a href="http://sitesplat.com">BBcore</a> e copia a pasta para a pasta da tua extensão sitesplat.',
]);
