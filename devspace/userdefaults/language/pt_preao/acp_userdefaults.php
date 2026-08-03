<?php

/**
 * @package User Defaults Extension for phpBB.
 * @copyright (c) 2016 david63
 * @copyright (c) 2022 devspace
 * @copyright (c) 2026 Leinad4Mind
 * @license GNU General Public License, version 2 (GPL-2.0)
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

/**
 * DEVELOPERS PLEASE NOTE
 *
 * All language files should use UTF-8 as their encoding and the files must not contain a BOM.
 *
 * Placeholders can now contain order information, e.g. instead of
 * 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
 * translators to re-order the output of data while ensuring it remains correct
 *
 * You do not need this where single placeholders are used, e.g. 'Message %d' is fine
 * equally where a string contains only two placeholders which are used to wrap text
 * in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
 *
 * Some characters you may want to copy&paste:
 * â€™ Â» â€œ â€ â€¦
 *
 */

$lang = array_merge($lang, [
	'DEFAULT_ALL_POSTS'    => '<strong>PadrÃ£o = Todas as mensagens</strong>',
	'DEFAULT_ALL_TOPICS'   => '<strong>PadrÃ£o = Todos os tÃ³picos</strong>',
	'DEFAULT_ASC'          => '<strong>PadrÃ£o = Ascendente</strong>',
	'DEFAULT_DATE_FORMAT'  => '<strong>PadrÃ£o = %s</strong>',
	'DEFAULT_DESC'         => '<strong>PadrÃ£o = Descendente</strong>',
	'DEFAULT_EMAIL'        => '<strong>PadrÃ£o = E-mail</strong>',
	'DEFAULT_NO'           => '<strong>PadrÃ£o = NÃ£o</strong>',
	'DEFAULT_NOTIFICATION' => '<strong>PadrÃ£o = NotificaÃ§Ã£o</strong>',
	'DEFAULT_POST_TIME'    => '<strong>PadrÃ£o = Hora da mensagem</strong>',
	'DEFAULT_YES'          => '<strong>PadrÃ£o = Sim</strong>',
	'DISPLAY_SETTINGS'     => 'OpÃ§Ãµes de apresentaÃ§Ã£o',

	'EMAIL' => 'E-mail',

	'GLOBAL_SETTINGS' => 'ConfiguraÃ§Ãµes globais',

	'NOTIFICATION' => 'NotificaÃ§Ã£o',

	'POSTING_SETTINGS' => 'PadrÃµes de publicaÃ§Ã£o',

	'USER_DEFAULTS_EXPLAIN' => 'Define aqui os valores que deseja como valores padrÃ£o para <strong>novos</strong> utilizadores.<br>Quaisquer alteraÃ§Ãµes feitas atravÃ©s deste formulÃ¡rio <strong>nÃ£o</strong> afetarÃ£o utilizadores jÃ¡ existentes.',
]);
