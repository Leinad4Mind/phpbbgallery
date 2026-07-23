<?php
/**
 * [Spanish [Es]]
 * @package cBB Chat
 * @version 1.2.7 07/03/2025
 *
 * @copyright (c) 2025 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 */

// DO NOT CHANGE
if(!defined('IN_PHPBB'))
{
	exit;
}

if(empty($lang) || !is_array($lang))
{
	$lang = [];
}

$lang = array_merge($lang, [
	'ACP_CHAT_CONFIG_EXPLAIN'	=> '¡Gracias por escoger cBB Chat como complemento para su foro!<br />
		Desde esta página puede modificar las principales características del chat.',
	'ACP_CHAT_PAGES_EXPLAIN'	=> 'Desde aquí puede administrar las páginas en las que se mostrará el chat así como su posición en ellas.',
	'ACP_CHAT_ROOMS_EXPLAIN'	=> 'Desde aquí puede administrar las salas especiales que se mostrarán en el chat.<br />Puede ordenar las salas arrastrándolas a su posición correcta.',
	'ACP_CHAT_TEXTS_EXPLAIN'	=> 'Desde aquí puede administrar las noticias, consejos y reglas del chat.<br />
		Para escoger el orden en el que aparecerán en el chat sólo tiene que arrastrarlos a su posición correcta.',
	
	'CHAT_ALLOW_BBCODE'			=> 'Permitir BBcode',
	'CHAT_ALLOW_BBCODE_EXPLAIN'	=> 'Define si se permitirá usar etiquetas BBcode en el chat.',
	'CHAT_ALLOW_PM'				=> 'Permitir mensajes privados',
	'CHAT_ALLOW_PM_EXPLAIN'		=> 'Habilita/deshabilita los mensajes privados entre los usuarios.',
	'CHAT_ANONYMOUS_ALLOWED'	=> 'Permitir invitados sin nombre',
	'CHAT_ANONYMOUS_ALLOWED_EXPLAIN'	=> 'Si se habilita, los invitados accederán al chat con un nombre aleatorio en lugar de tener que decidir su nombre.<br />
		<em>Esta opción sólo es válida si el grupo de Invitados posee permisos para ver el chat.</em>',
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
	'CHAT_FLOOD'				=> 'Límite de saturación',
	'CHAT_FLOOD_EXPLAIN'		=> 'Especifica el tiempo (en segundos) que debe esperar un usuario para escribir un nuevo mensaje.<br />
		<em>Defina 0 para deshabilitar este límite</em>.',
	'CHAT_FORUM_POSTS'			=> 'Mensajes del foro',
	'CHAT_FORUM_POSTS_EXPLAIN'	=> 'Define si se mostrarán los nuevos mensajes o temas del foro en las salas del chat.',
	'CHAT_GROUP_USERS'			=> 'Agrupar usuarios por grupos',
	'CHAT_GROUP_USERS_EXPLAIN'	=> 'Si se habilita, los usuarios serán agrupados en el chat según su grupo por defecto.',
	'CHAT_HEIGHT'				=> 'Alto del chat',
	'CHAT_HEIGHT_EXPLAIN'		=> 'Define el alto (en píxeles) del cuadro de conversación del chat.',
	'CHAT_HEIGHT_PAGE'			=> 'Alto del chat',
	'CHAT_HEIGHT_PAGE_EXPLAIN'	=> 'Define el alto (en píxeles) del cuadro de conversación del chat en esta página.<br /><em>Establezca 0 para usar el valor por defecto.</em>',
	'CHAT_HIDE_POPUP'			=> 'Ocultar menús automáticamente',
	'CHAT_HIDE_POPUP_EXPLAIN'	=> 'Si se habilita, los menús BBcode, color y emoticonos se cerrarán de forma automática al realizar la acción.',
	'CHAT_MAIN_CONFIG'			=> 'Configuración principal',
	'CHAT_MESSAGES_CONFIG'		=> 'Configuración de mensajes',
	'CHAT_NOTICES_ADD'			=> 'Añadir noticia',
	'CHAT_NOTICES_EDIT'			=> 'Editar noticia',
	'CHAT_NOTICES_EXPLAIN'		=> 'Los textos establecidos aquí se mostrarán como noticias o avisos en la parte superior del chat.',
	'CHAT_NOTICES_ITEM'			=> 'Noticia',
	'CHAT_NOTICES_ITEM_EXPLAIN'	=> 'Puede usar variables de idioma igual que en los estilos, por ejemplo <em>{L_CHAT}</em>.<br />
		<em>BBcode o HTML está permitido.<br />
		Emoticonos están permitidos.</em>',
	'CHAT_NOTICES'				=> 'Noticias',
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
	'CHAT_PM_IGNORE_FLOOD'		=> 'Ignorar límite de saturación',
	'CHAT_PM_IGNORE_FLOOD_EXPLAIN'	=> 'Si se habilita, el límite de saturación establecido no se aplicará al escribir mensajes privados entre usuarios.',
	'CHAT_PM_MAX'				=> 'Límite de salas privadas',
	'CHAT_PM_MAX_EXPLAIN'		=> 'Establece el número máximo de salas privadas que un usuario podrá abrir simultáneamente.<br /><em>Establezca 0 para deshabilitar este límite</em>.',
	'CHAT_PM_MAXAGE'			=> 'Tiempo de guardado',
	'CHAT_PM_MAXAGE_EXPLAIN'	=> 'Establece el tiempo (en días) que se guardarán los mensajes privados.
		<br />Los mensajes que sobrepasen esta antigüedad serán eliminados.
		<br /><br /><em>Valor mínimo 1, valor máximo 365</em>.',
	'CHAT_POSITION'				=> 'Posición del chat',
	'CHAT_POSITION_EXPLAIN'		=> 'Posición en la que aparecerá el chat dentro de la página.',
	'CHAT_POSITION_BOTTOM'		=> 'Parte inferior',
	'CHAT_POSITION_TOP'			=> 'Parte superior',
	'CHAT_REFRESH_TIME'			=> 'Tiempo de actualización',
	'CHAT_REFRESH_TIME_EXPLAIN'	=> 'Intervalo de tiempo (en segundos) que tardará el chat en actualizarse.',
	'CHAT_REMEMBER_STATUS'		=> 'Recordar estado de los usuarios',
	'CHAT_REMEMBER_STATUS_EXPLAIN'	=> 'Si se habilita, el chat recordará el estado de los usuarios en nuevas conexiones, por el contrario, los usuarios tendrán el estado <em><strong>Disponible</strong></em> cuando se conecten.',
	'CHAT_ROOM_AUTH'			=> 'Permisos de visualización',
	'CHAT_ROOM_AUTOPURGE'		=> 'Autopurga',
	'CHAT_ROOM_AUTOPURGE_EXPLAIN'	=> 'Define cada cuanto tiempo se eliminarán todos los mensajes de esta sala.',
	'CHAT_ROOM_CONFIG'			=> 'Configuración de la sala',
	'CHAT_ROOM_CONNECTIONS'		=> 'Conexiones',
	'CHAT_ROOM_ENABLED'			=> 'Sala activada',
	'CHAT_ROOM_GROUPS'			=> 'Grupos autorizados',
	'CHAT_ROOM_GROUPS_EXPLAIN'	=> 'Define los grupos de usuarios que podrán visualizar esta sala.<br />Puede seleccionar varios grupos usando la tecla <em>Ctrl</em> de su teclado.',
	'CHAT_ROOM_GUEST_FORUMS'			=> 'Foros enlazados a esta sala',
	'CHAT_ROOM_GUEST_FORUMS_EXPLAIN'	=> 'Aquí puede seleccionar los foros de los cuales se leerán los temas y mensajes que se mostrarán en la sala principal del chat.<br />
		Si no selecciona ninguno, se usarán todos (excepto los asignados a otras salas).<br />
		Puede seleccionar tantos como desee utilizando la tecla <em>Ctrl</em> de su teclado.',
	'CHAT_ROOM_LINKED_FORUMS'			=> 'Foros enlazados a esta sala',
	'CHAT_ROOM_LINKED_FORUMS_EXPLAIN'	=> 'Esta sala será la sala por defecto para los foros aquí seleccionados además, los temas y posts de estos foros se mostrarán en esta sala en lugar de en la sala General.<br />
		Puede seleccionar tantos como desee utilizando la tecla <em>Ctrl</em> de su teclado.',
	'CHAT_ROOM_LINKED_GROUPS'			=> 'Grupos enlazados a esta sala',
	'CHAT_ROOM_LINKED_GROUPS_EXPLAIN'	=> 'Esta sala se abrirá por defecto para los grupos aquí seleccionados.<br />
		Puede seleccionar tantos como desee utilizando la tecla <em>Ctrl</em> de su teclado.',
	'CHAT_ROOM_ADDED'				=> 'La sala se ha creado con éxito.',
	'CHAT_ROOM_UPDATED'				=> 'La configuración de la sala se ha modificado con éxito.',
	'CHAT_ROOM_MSG_LIMIT'			=> 'Límite de mensajes',
	'CHAT_ROOM_MSG_LIMIT_EXPLAIN'	=> 'Establece el número máximo de mensajes que se guardarán en esta sala. Si se supera este límite, los mensajes más antiguos se eliminarán periódicamente.
		<br /><em>Establezca 0 para deshabilitar este límite.</em>',
	'CHAT_ROOM_TITLE'			=> 'Título de la sala',
	'CHAT_ROOM_TITLE_EXPLAIN'	=> 'Admite variables de idioma.',
	'CHAT_ROOM_USERS'			=> 'Usuarios autorizados',
	'CHAT_ROOM_USERS_EXPLAIN'	=> 'Define los usuarios que podrán visualizar esta sala.<br />Establezca cada nombre de usuario en una línea.',
	'CHAT_ROW_ALIGN'			=> 'Alineación de los mensajes',
	'CHAT_ROW_ALIGN_EXPLAIN'	=> 'Define en que lado se mostrarán los mensajes en el chat.<br /><em>Esta configuración se ve afectada si el idioma usado es RTL.</em>',
	'CHAT_ROW_BUBBLE'			=> 'Burbuja',
	'CHAT_ROW_FORMAT'			=> 'Formato de los mensajes',
	'CHAT_ROW_FORMAT_EXPLAIN'	=> 'Define el estilo visual de los mensajes.',
	'CHAT_ROW_LEFT'				=> 'Mostrar a la izquierda',
	'CHAT_ROW_MEOTHER'			=> 'Mostrar usuario actual a un lado y resto al otro',
	'CHAT_ROW_NORMAL'			=> 'Normal',
	'CHAT_ROW_RIGHT'			=> 'Mostrar a la derecha',
	'CHAT_ROW_ZIGZAG'			=> 'Mostrar en ZigZag',
	'CHAT_ROWS'					=> 'Mensajes en chat',
	'CHAT_ROWS_EXPLAIN'			=> 'Número máximo de mensajes que se mostrarán en el cuadro de conversación del chat.',
	'CHAT_RULES_ADD'			=> 'Añadir regla',
	'CHAT_RULES_EDIT'			=> 'Editar regla',
	'CHAT_RULES_EXPLAIN'		=> 'Los textos establecidos aquí se mostrarán como <em>reglas</em> o <em>normas</em> en la lista establecida para ello.',
	'CHAT_RULES_ITEM'			=> 'Regla',
	'CHAT_RULES_ITEM_EXPLAIN'	=> 'Puede usar variables de idioma igual que en los estilos, por ejemplo <em>{L_CHAT}</em>.<br />
		<em>BBcode o HTML está permitido.<br />
		Emoticonos están permitidos.</em>',
	'CHAT_RULES'				=> 'Reglas',
	'CHAT_SOUND_ENABLED'		=> 'Sonido activado',
	'CHAT_SHOW_NONE'			=> 'No mostrar',
	'CHAT_SHOW_POSTS'			=> 'Todos los mensajes nuevos',
	'CHAT_SHOW_TOPICS'			=> 'Solo temas nuevos',
	'CHAT_TIMEOUT'				=> 'Tiempo de desconexión',
	'CHAT_TIMEOUT_EXPLAIN'		=> 'Define el tiempo (en minutos) que necesita el chat para considerar a un usuario "inactivo" y desconectarlo del chat.<br /><em>Defina 0 para deshabilitar esta función</em>.',
	'CHAT_TIPS_ADD'				=> 'Añadir consejo',
	'CHAT_TIPS_EDIT'			=> 'Editar consejo',
	'CHAT_TIPS_EXPLAIN'			=> 'Los textos establecidos aquí se mostrarán como pequeños consejos justo encima del cuadro de texto del chat.',
	'CHAT_TIPS_ITEM'			=> 'Consejo',
	'CHAT_TIPS_ITEM_EXPLAIN'	=> 'Puede usar variables de idioma igual que en los estilos, por ejemplo <em>{L_CHAT}</em>.<br />
		<em>BBcode o HTML está permitido.<br />
		Emoticonos están permitidos.</em>',
	'CHAT_TIPS'					=> 'Consejos',
	'CHAT_USERS_CONFIG'			=> 'Configuración de usuarios',
	
	'EACH_DAY'		=> 'Cada día',
	'EACH_WEEK'		=> 'Cada semana',
	'EACH_MONTH'	=> 'Cada mes',
	'EACH_YEAR'		=> 'Cada año',

	'ADD_ROOM'					=> 'Añadir sala',
	'CONTENT'					=> 'Contenido',
	'CUSTOM_BBCODES'			=> 'BBcodes personalizados',
	'CUSTOM_ROUTE'				=> 'Ruta personalizada',
	'CUSTOM_ROUTES'				=> 'Rutas personalizadas',
	'DEFAULT_BBCODES'			=> 'BBcodes predeterminados',
	'FORUM_ROUTES'				=> 'Rutas del foro',
	'NO_PAGES'					=> 'No hay páginas para mostrar',
	'NO_ROOM'					=> 'La sala seleccionada no existe',
	'NO_TEXTS'					=> 'No hay textos para mostrar',
	'PAGE_ADD'					=> 'Añadir página',
	'PAGE_ALIAS'				=> 'Identificación',
	'PAGE_URL'					=> 'Url de la página',
	'ROOM_TITLE'				=> 'Título de la sala',
	'SELECT_PAGE'				=> 'Seleccionar página',

	'INVALID_FILE'				=> 'El archivo especificado no existe o tiene un formato no válido.',
	'NO_ALIAS'					=> 'No ha especificado un Identificador de página válido.',
	'PAGE_ALREADY_EXISTS'		=> 'La página especificada ya está en uso.',
	
	'REMOVE_ROOM_CONFIRM'	=> '¿Está seguro de que desea eliminar esta sala y todos sus mensajes?',
]);
