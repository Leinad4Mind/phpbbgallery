<?php

/**
 * Notification_manager for the phpBB Forum Software package.
 * @copyright (c) 2017 ForumHulp.com <http://forumhulp.com>
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
	'FH_HELPER_NOTICE'             => 'O aplicativo auxiliar forumhulp não existe!<br />Baixe <a href="https://github.com/ForumHulp/helper" target="_blank">forumhulp/helper</a> e copie a pasta helper para a pasta da sua extensão forumhulp.',
		'NOTIFICATION_MANAGER_NOTICE' => '<div class="phpinfo"><p class="entry">Esta extensão substitui o seu antigo gerenciador de notificações no painel de controle.</p></div>'
	]
);
