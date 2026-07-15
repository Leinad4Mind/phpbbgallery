<?php
/** 
* main.php [Portuguese [pt]]
* @package cBB Chat
* @version v1.2.1 01/02/2020
*
* @copyright (c) 2020 CaniDev
* @license https://opensource.org/licenses/gpl-license.php GNU Public License
*/

// @ignore
if(!defined('IN_PHPBB'))
{
	exit;
}

if(empty($lang) || !is_array($lang))
{
	$lang = array();
}

// Chat language
$lang = array_merge($lang, array(
	'CHAT'						=> 'Chat',
	'CHAT_APPLY'				=> 'Aplicar',
	'CHAT_ARCHIVE'				=> 'Arquivo do chat',
	'CHAT_BAN_DATE'				=> 'Fim da exclusão',
	'CHAT_BAN_DATE_EXPLAIN'		=> 'O formato válido é DD/MM/AA hh:mm:ss.',
	'CHAT_BAN_PERIOD'			=> 'Duração da exclusão',
	'CHAT_BAN_USER'				=> 'Banir',
	'CHAT_BBCODE'				=> 'BBcodes',
	'CHAT_CHANGE_NAME'			=> 'Alterar nome de utilizador',
	'CHAT_COLOR'				=> 'Cor do texto',
	'CHAT_CONNECT'				=> 'Conectar/Desconectar',
	'CHAT_CUSTOM_BBCODES'		=> 'BBcodes personalizados',
	'CHAT_DELETE_USER'			=> 'Remover utilizador',
	'CHAT_DEST_ROOM'			=> 'Destino',
	'CHAT_DISCONNECT_MESSAGE'	=> 'Você está desconectado.',
	'CHAT_FLOOD_WAIT'			=> 'O tempo de Flood esta definido. Por favor, espere...',
	'CHAT_GUEST'				=> 'Visitante_%s',
	'CHAT_GUEST_ROOM'			=> 'Geral',

	'CHAT_MENTION'				=> 'Menção',
	'CHAT_MOVE'					=> 'Mover para outra sala',
	'CHAT_MOVE_CONFIRM'			=> 'Tem certeza de que deseja mover as mensagens selecionadas?',
	'CHAT_NO_INFORMATION'		=> 'Informação não disponível.',
	'CHAT_PM_EXCEED'			=> 'Você não pode abrir mais conversas privadas por causa de um limite definido pela administração.',
	'CHAT_PURGE'				=> 'Limpar Chat',
	'CHAT_PURGE_CONFIRM'		=> 'Tem certeza de que deseja excluir todas as mensagens da sala <strong><em>%s</em></strong> ?',
	'CHAT_REFRESH'				=> 'Atualizar',
	'CHAT_RULES'				=> 'Regras do chat',
	'CHAT_SEND_PM'				=> 'Mensagem privada',
	'CHAT_SMILIES'				=> 'Emojis',
	'CHAT_SOUND'				=> 'Activar/Desactivar som',

	'CHAT_ENTER_AS_GUEST'		=> 'Entrar como visitante',
	'CHAT_ENTER_AS_REGISTERED'	=> 'Entrar como membro',
	
	'CHAT_STATUS_AVAILABLE'		=> 'Disponível',
	'CHAT_STATUS_AWAY'			=> 'Ausente',
	'CHAT_STATUS_BUSY'			=> 'Ocupado',
	'CHAT_STATUS_HIDDEN'		=> 'Oculto',

	'CHAT_TIP'					=> 'Dicas',
	'CHAT_UNBAN_USER'			=> 'Remover exclusão',
	'CHAT_USER_BANNED_PERIOD'		=> 'Você está excluído do chat até: %s',
	'CHAT_USER_BANNED_PERMANENT'	=> 'Você está excluído do chat permanentemente.',
	'CHAT_USER_ALREADY_EXISTS'		=> 'O usuário já está em uso.',
	'CHAT_VIEW_HISTORY'				=> 'Ver mensagens anteriores',

	'BATCH_ACTIONS'		=> 'Ações em lote',
	'CUSTOM_DATE'	=> 'Data personalizada',
	'EDIT'			=> 'Editar',
	'NEW_TOPIC'		=> 'Novo tópico',
	'PERMANENT'		=> 'Permanente',
	'QUOTE'			=> 'Citar',
	
	'HALF_AN_HOUR'	=> 'Meia hora',
	'NO_LIMIT'		=> 'Sem limite',
	'ONE_DAY'		=> 'Um dia',
	'ONE_HOUR'		=> 'Uma hora',
	'ONE_WEEK'		=> 'Uma semana',
	'ONE_MONTH'		=> 'Um mês',
	'ONE_YEAR'		=> 'Um ano',
	'TWO_YEARS'		=> 'Dois anos',

	'CORE_INSTALL_ERROR'	=> 'You have not uploaded all the files from the installation package or you are trying to install an old package.<br />	
		Please make sure to upload all the files (including the <em>core</em> folder) and use a package downloaded from the official website.',
));

// Text language
$lang = array_merge($lang, array());