<?php
/** 
* acp.php [Spanish [Es]]
* @package cBB Chat
* @version v1.1.1 01/07/2015
*
* @copyright (c) 2015 CaniDev
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/

// DO NOT CHANGE
if(!defined('IN_PHPBB'))
{
	exit;
}

if(empty($lang) || !is_array($lang))
{
	$lang = array();
}

$lang = array_merge($lang, array(
	'CHAT_CONFIG_TITLE'		=> 'Configurar Chat',
	'CHAT_CONFIG_EXPLAIN'	=> '¡Gracias por escoger cBB Chat como complemento para su foro!<br />
		Desde esta página puede modificar las principales características del chat.',
	'CHAT_PAGES_TITLE'		=> 'Administrar páginas',
	'CHAT_PAGES_EXPLAIN'	=> 'Desde aquí puede administrar las páginas en las que se mostrará el chat así como su posición en ellas.',
	'CHAT_ROOMS_TITLE'		=> 'Administrar salas',
	'CHAT_ROOMS_EXPLAIN'	=> 'Desde aquí puede administrar las salas especiales que se mostrarán en el chat.<br />Puede ordenar las salas arrastrándolas a su posición correcta.',
	'CHAT_TEXTS_TITLE'		=> 'Administrar textos y reglas',
	'CHAT_TEXTS_EXPLAIN'	=> 'Desde aquí puede administrar las noticias, consejos y reglas del chat.<br />
		Para escoger el orden en el que aparecerán en el chat sólo tiene que arrastrarlos a su posición correcta.',
	
	'CHAT_ALLOW_BBCODE'			=> 'Permitir BBcode',
	'CHAT_ALLOW_BBCODE_EXPLAIN'	=> 'Define si se permitirá usar etiquetas BBcode en el chat.',
	'CHAT_ALLOW_PM'				=> 'Permitir mensajes privados',
	'CHAT_ALLOW_PM_EXPLAIN'		=> 'Habilita/deshabilita los mensajes privados entre los usuarios.',
	'CHAT_AUTOCONNECT'			=> 'Autoconectar',
	'CHAT_AUTOCONNECT_EXPLAIN'	=> 'Define si el chat se conectará automáticamente al abrir la página.',
	'CHAT_AUTO_AWAY'			=> 'Tiempo de estado <em>Disponible</em>',
	'CHAT_AUTO_AWAY_EXPLAIN'	=> 'Define el tiempo de inactividad (en minutos) después del cual el estado de un usuario <em><strong>Disponible</strong></em> cambiará a <em><strong>Ausente</strong></em>.<br /><em>Defina 0 para deshabilitar esta función</em>.',
	'CHAT_AUTO_AWAY_ERROR'		=> 'El tiempo de cambio de estado debe ser inferior al tiempo de desconexión',
	'CHAT_AVATARS'				=> 'Mostrar avatares',
	'CHAT_BBCODE_FORMAT'		=> 'Formato de BBCodes personalizados',
	'CHAT_BBCODE_FORMAT_EXPLAIN'	=> 'Define el aspecto de los BBcodes personalizados en el chat.',
	'CHAT_BBCODE_INBUTTON'		=> 'Botones',
	'CHAT_BBCODE_INSELECT'		=> 'Menú desplegable',
	'CHAT_CHARS'				=> 'Caracteres de los mensajes',
	'CHAT_CHARS_EXPLAIN'		=> 'Número máximo de caracteres permitidos en los mensajes.<br />
		<em>Defina 0 para deshabilitar este límite</em>.',
	'CHAT_DIRECTION'			=> 'Dirección de los mensajes',
	'CHAT_DIRECTION_EXPLAIN'	=> 'Especifica el orden en el que aparecerán los mensajes en el chat.',
	'CHAT_DIRECTION_DOWN'		=> 'Antiguos primero',
	'CHAT_DIRECTION_UP'			=> 'Nuevos primero',
	'CHAT_DISALLOWED_BBCODE'	=> 'Etiquetas BBcode no permitidas',
	'CHAT_DISALLOWED_BBCODE_EXPLAIN'	=> 'Define las etiquetas BBcode que <strong>no</strong> estarán permitidas en el chat.<br />
		Puede seleccionar tantas como quiera usando la tecla <em>Ctrl</em> de su teclado.',
	'CHAT_ENABLED'				=> 'Chat activado',
	'CHAT_ENABLED_EXPLAIN'		=> 'Habilita/deshabilita todas las funciones del chat.',
	'CHAT_FLOOD'				=> 'Límite de saturación',
	'CHAT_FLOOD_EXPLAIN'		=> 'Especifica el tiempo (en segundos) que debe esperar un usuario para escribir un nuevo mensaje.<br />
		<em>Defina 0 para deshabilitar este límite</em>.',
	'CHAT_HEIGHT'				=> 'Alto del chat',
	'CHAT_HEIGHT_EXPLAIN'		=> 'Define el alto (en píxeles) del cuadro de conversación del chat.',
	'CHAT_HEIGHT_PAGE'			=> 'Alto del chat',
	'CHAT_HEIGHT_PAGE_EXPLAIN'	=> 'Define el alto (en píxeles) del cuadro de conversación del chat en esta página.<br /><em>Establezca 0 para usar el valor por defecto.</em>',
	'CHAT_HELP'					=> 'Documentación y Soporte',
	'CHAT_MAIN_CONFIG'			=> 'Configuración principal',
	'CHAT_MAX_PM'				=> 'Límite de mensajes privados',
	'CHAT_MAX_PM_EXPLAIN'		=> 'Establece el número máximo de mensajes privados que un usuario podrá abrir simultáneamente.<br /><em>Establezca 0 para deshabilitar este límite</em>.',
	'CHAT_MESSAGES_CONFIG'		=> 'Configuración de mensajes',
	'CHAT_NOTICES_ADD'			=> 'Añadir noticia',
	'CHAT_NOTICES_EDIT'			=> 'Editar noticia',
	'CHAT_NOTICES_EXPLAIN'		=> 'Los textos establecidos aquí se mostrarán como noticias o avisos en la parte superior del chat.',
	'CHAT_NOTICES_ITEM'			=> 'Noticia',
	'CHAT_NOTICES_ITEM_EXPLAIN'	=> 'Puede usar variables de idioma igual que en los estilos, por ejemplo <em>{L_CHAT}</em>.<br />
		<em>BBcode o HTML está permitido.<br />
		Emoticonos están permitidos.</em>',
	'CHAT_NOTICES_TITLE'		=> 'Noticias',
	'CHAT_PAGE_ALIAS'			=> 'Identificador de la página',
	'CHAT_PAGE_ALIAS_EXPLAIN'	=> 'Especifica un identificador único para la página que se usará en el archivo de configuración si se establece.<br /><em>Sólo se permiten letras y números</em>.',
	'CHAT_PAGE_CONFIG'			=> 'Configuración de la página',
	'CHAT_PAGE_CUSTOM'			=> 'Ruta personalizada',
	'CHAT_PAGE_CUSTOM_EXPLAIN'	=> 'Define la ruta completa (relativa a phpBB) de la página.<br />Por ejemplo: <em>carpeta/archivo.php</em>.',
	'CHAT_PAGE_ENABLED'			=> 'Página del chat activada',
	'CHAT_PAGE_ENABLED_EXPLAIN'	=> 'Habilita/Deshabilita la página principal del chat.',
	'CHAT_PAGE_FILE'			=> 'Archivo de la página',
	'CHAT_PAGE_FILE_EXPLAIN'	=> 'Define el archivo en el que será cargado el chat.',
	'CHAT_PAGE_FORUMS'			=> 'Foros',
	'CHAT_PAGE_FORUMS_EXPLAIN'	=> 'Define los foros en los que se mostrará el chat.<br />Puede seleccionar tantos como quiera usando la tecla <em>Ctrl</em> de su teclado.<br /><em>Si no selecciona ningún foro el chat se mostrará en todos.</em>',
	'CHAT_PM_CONFIG'			=> 'Configuración de mensajes privados',
	'CHAT_POSITION'				=> 'Posición del chat',
	'CHAT_POSITION_EXPLAIN'		=> 'Posición en la que aparecerá el chat dentro de la página.',
	'CHAT_POSITION_BOTTOM'		=> 'Parte inferior',
	'CHAT_POSITION_TOP'			=> 'Parte superior',
	'CHAT_REFRESH_TIME'			=> 'Tiempo de actualización',
	'CHAT_REFRESH_TIME_EXPLAIN'	=> 'Intervalo de tiempo (en segundos) que tardará el chat en actualizarse.',
	'CHAT_REMEMBER_STATUS'		=> 'Recordar estado de los usuarios',
	'CHAT_REMEMBER_STATUS_EXPLAIN'	=> 'Si se habilita, el chat recordará el estado de los usuarios en nuevas conexiones, por el contrario, los usuarios tendrán el estado <em><strong>Disponible</strong></em> cuando se conecten.',
	'CHAT_ROOM_AUTH'			=> 'Permisos de visualización',
	'CHAT_ROOM_CONFIG'			=> 'Configuración de la sala',
	'CHAT_ROOM_ENABLED'			=> 'Sala activada',
	'CHAT_ROOM_GROUPS'			=> 'Grupos autorizados',
	'CHAT_ROOM_GROUPS_EXPLAIN'	=> 'Define los grupos de usuarios que podrán visualizar esta sala.<br />Puede seleccionar varios grupos usando la tecla <em>Ctrl</em> de su teclado.',
	'CHAT_ROOM_ADDED'			=> 'La sala se ha creado con éxito.',
	'CHAT_ROOM_UPDATED'			=> 'La configuración de la sala se ha modificado con éxito.',
	'CHAT_ROOM_TITLE'			=> 'Título de la sala',
	'CHAT_ROOM_TITLE_EXPLAIN'	=> 'Admite variables de idioma.',
	'CHAT_ROOM_USERS'			=> 'Usuarios autorizados',
	'CHAT_ROOM_USERS_EXPLAIN'	=> 'Define los usuarios que podrán visualizar esta sala.<br />Establezca cada nombre de usuario en una línea.',
	'CHAT_ROWS'					=> 'Mensajes en chat',
	'CHAT_ROWS_EXPLAIN'			=> 'Número máximo de mensajes que se mostrarán en el cuadro de conversación del chat.',
	'CHAT_RULES_ADD'			=> 'Añadir regla',
	'CHAT_RULES_EDIT'			=> 'Editar regla',
	'CHAT_RULES_EXPLAIN'		=> 'Los textos establecidos aquí se mostrarán como <em>reglas</em> o <em>normas</em> en la lista establecida para ello.',
	'CHAT_RULES_ITEM'			=> 'Regla',
	'CHAT_RULES_ITEM_EXPLAIN'	=> 'Puede usar variables de idioma igual que en los estilos, por ejemplo <em>{L_CHAT}</em>.<br />
		<em>BBcode o HTML está permitido.<br />
		Emoticonos están permitidos.</em>',
	'CHAT_RULES_TITLE'			=> 'Reglas',
	'CHAT_SOUND_ENABLED'		=> 'Sonido activado',
	'CHAT_SHOW_TOPICS'			=> 'Mostrar temas nuevos',
	'CHAT_SHOW_TOPICS_EXPLAIN'	=> 'Establece si el chat mostrará los nuevos temas del foro en la sala General.',
	'CHAT_STORE'				=> 'Tiempo de almacenamiento',
	'CHAT_STORE_EXPLAIN'		=> 'Define el tiempo que permanecerán los mensajes guardados en la base de datos.<br />
		<em>Los mensajes que se encuentren fuera del límite serán eliminados</em>.',
	'CHAT_TIMEOUT'				=> 'Tiempo de desconexión',
	'CHAT_TIMEOUT_EXPLAIN'		=> 'Define el tiempo (en minutos) que necesita el chat para considerar a un usuario "inactivo" y desconectarlo del chat.<br /><em>Defina 0 para deshabilitar esta función</em>.',
	'CHAT_TIPS_ADD'				=> 'Añadir consejo',
	'CHAT_TIPS_EDIT'			=> 'Editar consejo',
	'CHAT_TIPS_EXPLAIN'			=> 'Los textos establecidos aquí se mostrarán como pequeños consejos justo encima del cuadro de texto del chat.',
	'CHAT_TIPS_ITEM'			=> 'Consejo',
	'CHAT_TIPS_ITEM_EXPLAIN'	=> 'Puede usar variables de idioma igual que en los estilos, por ejemplo <em>{L_CHAT}</em>.<br />
		<em>BBcode o HTML está permitido.<br />
		Emoticonos están permitidos.</em>',
	'CHAT_TIPS_TITLE'			=> 'Consejos',
	'CHAT_USERS_CONFIG'			=> 'Configuración de usuarios',

	'ADD_ROOM'				=> 'Añadir sala',
	'CONTENT'				=> 'Contenido',
	'CUSTOM_BBCODES'		=> 'BBcodes personalizados',
	'CUSTOM_FILE'			=> 'Archivo personalizado',
	'CUSTOM_FILES'			=> 'Archivos personalizados',
	'DEFAULT_BBCODES'		=> 'BBcodes predeterminados',
	'FORUM_FILES'			=> 'Archivos del foro',
	'MOD_NOT_INSTALLED'		=> 'Mod no instalado correctamente',
	'NO_PAGES'				=> 'No hay páginas para mostrar',
	'NO_TEXTS'				=> 'No hay textos para mostrar',
	'PAGE_ADD'				=> 'Añadir página',
	'PAGE_ALIAS'			=> 'Identificación',
	'PAGE_URL'				=> 'Url de la página',
	'ROOM_TITLE'			=> 'Título de la sala',
	'SELECT_PAGE'			=> 'Seleccionar página',
	
	'INVALID_FILE'			=> 'El archivo especificado no existe o tiene un formato no válido.',
	'NO_ALIAS'				=> 'No ha especificado un Identificador de página válido.',
	'PAGE_ALREADY_EXISTS'	=> 'La página especificada ya está en uso.',
	
	'REMOVE_ROOM_CONFIRM'	=> '¿Está seguro de que desea eliminar esta sala y todos sus mensajes?',
			
	'CHAT_VERSION_NOT_UP_TO_DATE'	=> 'Existe una versión más reciente de cBB Chat.<br />
		Debajo encontrará un enlace al anuncio de publicación de la última versión así como también instrucciones de cómo realizar la actualización.',
));
