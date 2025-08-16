<?php
/** 
* main.php [Spanish [Es]]
* @package cBB Chat
* @version v1.1.3 10/03/2017
*
* @copyright (c) 2017 CaniDev
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
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
	'CHAT_ARCHIVE'				=> 'Archivo de Chat',
	'CHAT_BAN_DATE'				=> 'Fin de la exclusión',
	'CHAT_BAN_DATE_EXPLAIN'		=> 'El formato válido es DD/MM/YYYY hh:mm:ss.',
	'CHAT_BAN_PERIOD'			=> 'Duración de la exclusión',
	'CHAT_BAN_USER'				=> 'Excluir del chat',
	'CHAT_BBCODE'				=> 'BBcodes',
	'CHAT_CANCEL'				=> 'Cancelar',
	'CHAT_CLEAR_BBCODE'			=> 'Eliminar BBcode',
	'CHAT_CLEAR_INPUT'			=> 'Eliminar Todo',
	'CHAT_COLOR'				=> 'Color de texto',
	'CHAT_CONNECT'				=> 'Conectar/Desconectar',
	'CHAT_CUSTOM_BBCODES'		=> 'BBcodes personalizados',
	'CHAT_DELETE_USER'			=> 'Borrar usuario',
	'CHAT_DEST_ROOM'			=> 'Destino',
	'CHAT_DISCONNECT_MESSAGE'	=> 'Está desconectado.',
	'CHAT_FLOOD_WAIT'			=> 'Se ha establecido un límite de saturación. Por favor, espere...',
	'CHAT_GUEST'				=> 'Invitado_%s',
	'CHAT_GUEST_ROOM'			=> 'General',
	'CHAT_MENTION'				=> 'Mencionar',
	'CHAT_MOVE'					=> 'Mover a otra sala',
	'CHAT_MOVE_CONFIRM'			=> '¿Está seguro de que desea mover los mensajes seleccionados?',
	'CHAT_NO_INFORMATION'		=> 'No hay información disponible.',
	'CHAT_PM_EXCEED'			=> 'No puede abrir más conversaciones privadas debido a un límite establecido por la administración.',
	'CHAT_PURGE'				=> 'Purgar mensajes',
	'CHAT_PURGE_CONFIRM'		=> '¿Está seguro de que desea eliminar todos los mensajes de la sala <strong><em>%s</em></strong>?',
	'CHAT_REFRESH'				=> 'Actualizar',
	'CHAT_REMAINING_CHARS'		=> 'caracteres restantes.',
	'CHAT_RULES'				=> 'Reglas del chat',
	'CHAT_SEND_PM'				=> 'Mensaje Privado',
	'CHAT_SMILIES'				=> 'Emoticonos',
	'CHAT_SOUND'				=> 'Activar/Desactivar sonido',
	
	'CHAT_ENTER_AS_GUEST'		=> 'Entrar como invitado',
	'CHAT_ENTER_AS_REGISTERED'	=> 'Entrar como miembro del foro',
	
	'CHAT_STATUS_AVAILABLE'		=> 'Disponible',
	'CHAT_STATUS_AWAY'			=> 'Ausente',
	'CHAT_STATUS_BUSY'			=> 'Ocupado',
	'CHAT_STATUS_HIDDEN'		=> 'Invisible',
	
	'CHAT_SUBMIT'				=> 'Aceptar',
	'CHAT_TIP'					=> 'Consejo',
	'CHAT_UNBAN_USER'			=> 'Quitar exclusión',
	'CHAT_USER_BANNED_PERIOD'		=> 'Usted ha sido excluído del chat. No podrá acceder a él hasta: %s',
	'CHAT_USER_BANNED_PERMANENT'	=> 'Usted ha sido excluído del chat permanentemente.',
	'CHAT_USER_ALREADY_EXISTS'		=> 'El usuario especificado ya está en uso.',

	'BATCH_ACTIONS'		=> 'Acciones en lote',
	'CUSTOM_DATE'		=> 'Fecha personalizada',
	'EDIT'				=> 'Editar',
	'NEW_TOPIC'			=> 'Nuevo Tema',
	'PERMANENT'			=> 'Permanente',
	'QUOTE'				=> 'Citar',
	
	'HALF_AN_HOUR'	=> 'Media hora',
	'NO_LIMIT'		=> 'Sin límite',
	'ONE_DAY'		=> 'Un día',
	'ONE_HOUR'		=> 'Una hora',
	'ONE_WEEK'		=> 'Una semana',
	'ONE_MONTH'		=> 'Un mes',
	'ONE_YEAR'		=> 'Un año',
	'TWO_YEARS'		=> 'Dos años',
));

// Text language
$lang = array_merge($lang, array());
