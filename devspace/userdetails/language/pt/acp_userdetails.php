<?php

/**
 * @package User Details Extension for phpBB.
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
	'ACP_USER_DETAILS'       => 'Detalhes de utilizador',
	'ALL'                    => 'Todos',
	'CLEAR_FILTER'           => ' Limpar filtros ',
	'DEFAULT_STYLE'          => '<strong>** %1$s **</strong>',
	'ERROR_EXPLAIN'          => '<strong>Nota:</strong> Quaisquer atributos rodeados por "**" indicam que este atributo para o utilizador está em falta na base de dados, ou é inválido.',
	'FILTER_BY'              => 'Filtrar por',
	'HASH'                   => '#',
	'NO_ATTRIBUTES_SELECTED' => 'Nenhum atributo selecionado',
	'NO_DATA'                => 'O pedido não criou quaisquer dados para apresentar',
	'NO_GROUP'               => '<strong>** Nenhum grupo **</strong>',
	'NO_VISIT'               => 'Nunca visitou',
	'OTHER'                  => 'Outro',
	'TOTAL_USERS'            => 'Total de utilizadores',
	'UD_BACK'                => ' « Voltar para seleção ',
	'UD_GO'                  => ' Ordenar/Filtrar ',
	'USER_ALLOW_PM'          => 'Permitir MP',
	'USER_ALLOW_VIEWONLINE'  => 'Ver online',
	'USER_ALLOW_VIEWEMAIL'   => 'Ver e-mail',
	'USER_ALLOW_MASSEMAIL'   => 'E-mail em massa',
	'USER_AOL'               => 'AOL',
	'USER_AVATAR'            => 'Avatar',
	'USER_AVATAR_TYPE'       => 'Tipo de avatar',
	'USER_BIRTHDAY'          => 'Aniversário',
	'USER_DATE_FORMAT'       => 'Formato da data',
	'USER_DETAILS_DISPLAY'   => 'Esta é a apresentação dos atributos de utilizador que selecionou.',
	'USER_EMAIL'             => 'E-mail',
	'USER_EMAILTIME'         => 'Hora do e-mail',
	'USER_GROUP'             => 'Grupo',
	'USER_ID'                => 'ID de utilizador',
	'USER_INACTIVE_REASON'   => 'Razão de inatividade',
	'USER_INACTIVE_TIME'     => 'Tempo de inatividade',
	'USER_IP'                => 'IP de utilizador',
	'USER_JABBER'            => 'Jabber',
	'USER_LANG'              => 'Idioma',
	'USER_LASTMARK'          => 'Última marca',
	'USER_LAST_PAGE'         => 'Última página',
	'USER_LAST_PRIVMSG'      => 'Última mensagem privada',
	'USER_LAST_SEARCH'       => 'Última pesquisa',
	'USER_LAST_WARNING'      => 'Último aviso',
	'USER_LASTPOST_TIME'     => 'Hora da última mensagem',
	'USER_LASTVISIT'         => 'Última visita',
	'USER_LOGIN_ATTEMPTS'    => 'Tentativas de login',
	'USER_NEW_PRIVMSG'       => 'Novas mensagens privadas',
	'USER_NOTIFY'            => 'Notificar mensagem',
	'USER_NOTIFY_PM'         => 'Notificar MP',
	'USER_NOTIFY_TYPE'       => 'Tipo de notificação',
	'USER_PASS_CHANGE'       => 'Alteração de palavra-passe',
	'USER_POSTS'             => 'Mensagens',
	'USER_RANK'              => 'Rank',
	'USER_REGDATE'           => 'Data de registo',
	'USER_SIG'               => 'Assinatura',
	'USER_STYLE'             => 'Estilo',
	'USER_TIMEZONE'          => 'Fuso horário',
	'USER_TYPE'              => 'Tipo de utilizador',
	'USER_UNREAD_PRIVMSG'    => 'Mensagens privadas não lidas',
	'USER_WARNINGS'          => 'Avisos',

	'START_CHARACTER' => 'A',
	'END_CHARACTER'   => 'Z',

	'avatar_type' => [
		AVATAR_UPLOAD            => 'Avatar carregado',
		AVATAR_REMOTE            => 'Avatar remoto',
		AVATAR_GALLERY           => 'Avatar da galeria',
		'avatar.driver.gravatar' => 'Gravatar',
	],

	'inactive_type' => [
		INACTIVE_REGISTER => 'Conta recém-registada',
		INACTIVE_PROFILE  => 'Detalhes do perfil alterados',
		INACTIVE_MANUAL   => 'Conta desativada pelo administrador',
		INACTIVE_REMIND   => 'Reativação de conta de utilizador forçada',
	],

	'month_types' => [
		'1'  => 'Janeiro',
		'2'  => 'Fevereiro',
		'3'  => 'Março',
		'4'  => 'Abril',
		'5'  => 'Maio',
		'6'  => 'Junho',
		'7'  => 'Julho',
		'8'  => 'Agosto',
		'9'  => 'Setembro',
		'10' => 'Outubro',
		'11' => 'Novembro',
		'12' => 'Dezembro',
	],

	'notify_type' => [
		NOTIFY_EMAIL => 'E-mail',
		NOTIFY_IM    => 'Jabber',
		NOTIFY_BOTH  => 'E-mail & Jabber',
	],

	'user_type' => [
		USER_NORMAL   => 'Normal',
		USER_INACTIVE => 'Inativo',
		USER_IGNORE   => 'Ignorado',
		USER_FOUNDER  => 'Fundador',
	],
]);
