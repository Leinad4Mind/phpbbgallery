<?php

/**
 * @package Active Sessions Extension for phpBB.
 * @copyright (c) 2022 devspace
 * @license GNU General Public License, version 2 (GPL-2.0)
 * @translation Leinad4Mind [Portuguese [pt]] (2026)
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
 * ’ » “ ” …
 *
 */

$lang = array_merge($lang, [
	'ACTIVE_SESSIONS_EXPLAIN' => 'Aqui está uma lista das sessões ativas atuais no fórum.<br><br>Clica em "IP da Sessão" para expandir os detalhes do IP.<br>Clica em "ID da Sessão" para expandir os detalhes da sessão.',
	'ADMIN_USER'              => 'Utilizador administrador',
	'ALL'                     => 'Todos',
	'AUTO_LOGIN'              => 'Login automático definido',
	'BROWSER'                 => 'Tipo de navegador',
	'CLEAR_FILTER'            => 'Limpar filtro',
	'FILTER_BY'               => 'Filtrar Nome de utilizador por',
	'FILTER_USERNAME'         => 'Nome de utilizador',
	'LAST_VISIT'              => 'Última visita do utilizador',
	'NO_SESSION_DATA'         => 'Não existem dados de sessão disponíveis para este pedido.',
	'OTHER'                   => 'Outro',
	'SESSION_FORWARD_FOR'     => 'Sessão reencaminhada para',
	'SESSION_IP'              => 'IP da Sessão',
	'SESSION_ID'              => 'ID da Sessão',
	'SESSION_START'           => 'Início da Sessão',
	'SESSION_TIME'            => 'Tempo da Sessão',
	'SESSION_VIEWONLINE'      => 'Ver online',
	'TOTAL_SESSIONS'          => 'Contagem total de sessões : <strong>%1$s</strong>',
	'USER_PAGE'               => 'Última página visitada',
	'START_CHARACTER'         => 'A',
	'END_CHARACTER'           => 'Z',
]);
