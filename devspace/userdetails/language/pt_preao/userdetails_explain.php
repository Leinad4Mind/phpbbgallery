<?php

/**
 * @package User Details Extension for phpBB.
 * @copyright (c) 2022 devspace
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
 * ’ » “ ” …
 *
 */

$lang = array_merge($lang, [
	'ATTRIBUTE'                     => 'Atributo',
	'ATTRIBUTE_EXPLAIN'             => 'Descrição do atributo',
	'CAN_FILTER'                    => 'Pode filtrar',
	'CLEAR_ATTRIB'                  => 'Limpar atributos',
	'CSV'                           => 'Exportar para CSV',
	'SIZE'                          => 'Tamanho da coluna do atributo',
	'USER_ALLOW_MASSEMAIL_EXPLAIN'  => 'O utilizador pode ser contactado por e-mail em massa de um Administrador?',
	'USER_ALLOW_PM_EXPLAIN'         => 'Permitir que outros utilizadores enviem uma mensagem privada a este utilizador.',
	'USER_ALLOW_VIEWEMAIL_EXPLAIN'  => 'Um utilizador pode contactar este utilizador por e-mail?',
	'USER_ALLOW_VIEWONLINE_EXPLAIN' => 'O utilizador oculta o seu estado online?',
	'USER_AOL_EXPLAIN'              => 'O endereço AOL do utilizador.',
	'USER_AVATAR_EXPLAIN'           => 'Mostrar o avatar do utilizador.',
	'USER_AVATAR_TYPE_EXPLAIN'      => 'O tipo de avatar do utilizador.',
	'USER_BIRTHDAY_EXPLAIN'         => 'A data de nascimento do utilizador, se introduzida, e a idade.',
	'USER_DATE_FORMAT_EXPLAIN'      => 'O formato em que o utilizador vê a data e a hora.',
	'USER_DETAILS_SELECT'           => '&bull;&nbsp;A partir daqui pode selecionar os atributos de Utilizador que deseja apresentar.<br>&bull;&nbsp;Tenha em atenção que o número de atributos selecionados pode não caber corretamente na página (isto dependerá da largura do navegador).',
	'USER_EMAIL_EXPLAIN'            => 'O endereço de e-mail do utilizador.',
	'USER_EMAILTIME_EXPLAIN'        => 'A data e hora do último e-mail do utilizador.',
	'USER_GROUP_EXPLAIN'            => 'O grupo padrão do utilizador.',
	'USER_ID_EXPLAIN'               => 'O id do utilizador neste fórum.',
	'USER_INACTIVE_REASON_EXPLAIN'  => 'A razão pela qual a conta deste utilizador está inativa.',
	'USER_INACTIVE_TIME_EXPLAIN'    => 'A data e hora em que a conta do utilizador se tornou inativa.',
	'USER_IP_EXPLAIN'               => 'O endereço de ip do utilizador no registo neste fórum.',
	'USER_JABBER_EXPLAIN'           => 'O endereço Jabber do utilizador.',
	'USER_LANG_EXPLAIN'             => 'O idioma do utilizador.',
	'USER_LASTMARK_EXPLAIN'         => 'A última vez que o utilizador marcou todos os fóruns como lidos.',
	'USER_LAST_PAGE_EXPLAIN'        => 'A última página que o utilizador visitou.',
	'USER_LAST_PRIVMSG_EXPLAIN'     => 'A data e hora da última mensagem privada do utilizador.',
	'USER_LAST_SEARCH_EXPLAIN'      => 'A data e hora em que o utilizador utilizou a pesquisa pela última vez.',
	'USER_LAST_WARNING_EXPLAIN'     => 'A data em que o utilizador recebeu o seu último aviso.',
	'USER_LASTPOST_TIME_EXPLAIN'    => 'A data e hora em que o utilizador publicou pela última vez neste fórum.',
	'USER_LASTVISIT_EXPLAIN'        => 'A data e hora da última visita do utilizador a este fórum.',
	'USER_LOGIN_ATTEMPTS_EXPLAIN'   => 'O número de tentativas de login falhadas que o utilizador efetuou.',
	'USER_NEW_PRIVMSG_EXPLAIN'      => 'O número de novas mensagens privadas que o utilizador tem.',
	'USER_NOTIFY_EXPLAIN'           => 'O utilizador recebe notificações de novas mensagens nos fóruns que subscreveu?',
	'USER_NOTIFY_PM_EXPLAIN'        => 'O utilizador recebe notificações de MPs?',
	'USER_NOTIFY_TYPE_EXPLAIN'      => 'Que tipo de notificações o utilizador recebe?',
	'USER_PASS_CHANGE_EXPLAIN'      => 'A data em que a palavra-passe do utilizador deve ser alterada.',
	'USER_POSTS_EXPLAIN'            => 'O número de mensagens que o utilizador publicou neste fórum.',
	'USER_RANK_EXPLAIN'             => 'O rank do utilizador.',
	'USER_REGDATE_EXPLAIN'          => 'A data em que o utilizador se registou neste fórum.',
	'USER_SIG_EXPLAIN'              => 'Mostrar a assinatura do utilizador.',
	'USER_STYLE_EXPLAIN'            => 'O estilo do utilizador.<br>NOTA: Este pode não ser o estilo que o utilizador vê - depende se a substituição do estilo de utilizador foi definida ao nível do fórum.',
	'USER_TIMEZONE_EXPLAIN'         => 'O fuso horário do utilizador.',
	'USER_TYPE_EXPLAIN'             => 'O tipo de utilizador.',
	'USER_UNREAD_PRIVMSG_EXPLAIN'   => 'O número de mensagens privadas não lidas que o utilizador tem.',
	'USER_WARNINGS_EXPLAIN'         => 'O número de avisos que o utilizador recebeu.',
]);
