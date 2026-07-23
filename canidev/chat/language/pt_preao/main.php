<?php

/**
 * @package cBB Chat for phpBB.
 * [English [En]]
 * @version 1.2.6 01/07/2024
 * @copyright (c) 2024 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 * @translation Leinad4Mind [Portuguese [pt_preao]] (2026)
 */

// @ignore
if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = [];
}

// Chat language
$lang = array_merge($lang, [
	'CHAT'                    => 'Chat',
	'CHAT_APPLY'              => 'Aplicar',
	'CHAT_ARCHIVE'            => 'Arquivo do chat',
	'CHAT_BAN_DATE'           => 'Fim da exclusão',
	'CHAT_BAN_DATE_EXPLAIN'   => 'O formato válido é DD/MM/AAAA hh:mm:ss.',
	'CHAT_BAN_PERIOD'         => 'Duração da exclusão',
	'CHAT_BAN_USER'           => 'Excluir',
	'CHAT_BBCODE'             => 'BBcodes',
	'CHAT_CHANGE_NAME'        => 'Mudar nome de utilizador',
	'CHAT_COLOR'              => 'Cor do texto',
	'CHAT_CONNECT'            => 'Ligar/Desligar',
	'CHAT_CUSTOM_BBCODES'     => 'BBcodes personalizados',
	'CHAT_DELETE_USER'        => 'Eliminar utilizador',
	'CHAT_DEST_ROOM'          => 'Destino',
	'CHAT_DISCONNECT_MESSAGE' => 'Estás desligado.',
	'CHAT_FLOOD_WAIT'         => 'O limite de tempo (flood) está activo. Por favor, aguarda...',
	'CHAT_GUEST'              => 'Visitante_%s',
	'CHAT_GUEST_ROOM'         => 'Geral',
	'CHAT_MENTION'            => 'Mencionar',
	'CHAT_MOVE'               => 'Mover para outra sala',
	'CHAT_MOVE_CONFIRM'       => 'Tens a certeza de que queres mover as mensagens seleccionadas?',
	'CHAT_NO_INFORMATION'     => 'Nenhuma informação disponível.',
	'CHAT_PM_EXCEED'          => 'Não podes abrir mais conversas privadas devido a um limite definido pela administração.',
	'CHAT_PURGE'              => 'Expurgar mensagens',
	'CHAT_PURGE_CONFIRM'      => 'Tens a certeza de que queres eliminar todas as mensagens da sala <strong><em>%s</em></strong>?',
	'CHAT_REFRESH'            => 'Actualizar',
	'CHAT_RULES'              => 'Regras do chat',
	'CHAT_SEND_PM'            => 'Mensagem privada',
	'CHAT_SMILIES'            => 'Emoticons',
	'CHAT_SOUND'              => 'Activar/Desactivar som',

	'CHAT_ENTER_AS_GUEST'      => 'Entrar como visitante',
	'CHAT_ENTER_AS_REGISTERED' => 'Entrar como membro',

	'CHAT_STATUS_AVAILABLE' => 'Disponível',
	'CHAT_STATUS_AWAY'      => 'Ausente',
	'CHAT_STATUS_BUSY'      => 'Ocupado',
	'CHAT_STATUS_HIDDEN'    => 'Oculto',

	'CHAT_TIP'                   => 'Dica',
	'CHAT_UNBAN_USER'            => 'Remover exclusão',
	'CHAT_USER_BANNED_PERIOD'    => 'Estás excluído do chat até: %s',
	'CHAT_USER_BANNED_PERMANENT' => 'Estás excluído do chat permanentemente.',
	'CHAT_USER_ALREADY_EXISTS'   => 'O nome de utilizador já está em uso.',
	'CHAT_VIEW_HISTORY'          => 'Ver mensagens anteriores',

	'CUSTOM_DATE'  => 'Data personalizada',
	'EDIT'         => 'Editar',
	'HALF_AN_HOUR' => 'Meia hora',
	'NEW_TOPIC'    => 'Novo Tópico',
	'PERMANENT'    => 'Permanente',
	'QUOTE'        => 'Citar',

	'CORE_INSTALL_ERROR' => 'Não carregaste todos os ficheiros do pacote de instalação ou estás a tentar instalar um pacote antigo.<br />
		Por favor, certifica-te de que carregas todos os ficheiros (incluindo a pasta <em>core</em>) e usas um pacote descarregado do site oficial.',
]);

// Text language
$lang = array_merge($lang, []);
