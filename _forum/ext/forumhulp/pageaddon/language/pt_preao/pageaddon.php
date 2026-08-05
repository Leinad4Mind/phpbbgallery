<?php

/**
 * @copyright (c) 2014-2016 ForumHulp.com
 * @license GNU General Public License, version 2 (GPL-2.0)
 * @translation Leinad4Mind [Portuguese [pt_preao]] (2026)
 */
if (!defined('IN_PHPBB'))
{
exit;
}
if (empty($lang) || !is_array($lang))
{
$lang = [];
}
$lang = array_merge($lang, [
	'WYSIWYG_TEXT'     => 'Esta página foi transformada num editor HTML WYSIWYG com o pageaddon de <a href="http://forumhulp.com" target="_blank">ForumHulp.com</a>. BBCodes não funcionarão com este add-on. Podes adicionar paginação às tuas páginas inserindo "Quebras de Página" a partir do menu Inserir.',
	'FH_HELPER_NOTICE' => 'A aplicação ajudante forumhulp não existe!<br />Transfere <a href="https://github.com/ForumHulp/helper" target="_blank">forumhulp/helper</a> e copia a pasta helper para a pasta da tua extensão forumhulp.',
	'PAGEADDON_NOTICE' => '<div class="phpinfo"><p class="entry">Esta extensão transforma as Páginas phpBB num editor WYSIWYG. Vai para as Páginas no ACP para ver esta extensão.</p></div>',
	'PAGES_NOTICE'      => 'A extensão phpBB Pages não foi encontrada!<br />Instala e activa a phpbb/pages antes de activar esta extensão.',
]);
