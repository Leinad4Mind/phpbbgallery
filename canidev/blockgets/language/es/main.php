<?php
/*
* main.php [Spanish [Es]]
* @package cBB Blockgets
* @version v2.0.1 01/02/2020
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

$lang = array_merge($lang, array(
	'PORTAL'			=> 'Portal',
	'READ_FULL'			=> 'Leer tema completo',
	'BLG_READ_MORE'		=> '%sSeguir leyendo%s',

	'ADD_PAGE'					=> 'Crear página',
	'BANNERS'					=> 'Banners',
	'CALENDAR'					=> 'Calendario',
	'CALENDAR_BIRTHDAY_TITLE'	=> '%1$s y <strong>%2$d más</strong>.',
	'EDIT_CONFIGURATION'		=> 'Editar configuración',
	'EDIT_THIS_PAGE'			=> 'Editar esta página',
	'EDITOR'					=> 'Editor',
	'EXPAND_CONTRACT'			=> 'Expandir/Contraer',
	'INSERT_ON_ENTRY'			=> 'Insertar en entrada',
	'MANAGE_BLOCKS'				=> 'Administrar bloques',
	'PRINT'						=> 'Imprimir',
	'SELECT_COLOUR'				=> 'Seleccionar color',
	'SMILIES'					=> 'Emoticonos',
	'TODAY'						=> 'Hoy',
	
	// Editor
	'HTML_TITLE' 		=> 'Html:',
	'INSERT_HTML' 		=> 'Insertar código HTML',

	// Login Block
	'HIDE_ME_NOW'		=> 'Ocultarme en esta sesión',
	'MY_BOOKMARKS'		=> 'Favoritos',
	'MY_SUBSCRIBED'		=> 'Subscripciones',
	'REMEMBER_ME'		=> 'Recordarme',

	// Link Us Block
	'LINK_US_TXT'		=> 'Por favor, siéntase libre para vincular a <strong>%s</strong>. Use el siguiente texto HTML:',

	// Stats Block and whos_online block
	'GUEST_VISITS_TOTAL'		=> '%d Invitados',
	'GUEST_VISIT_TOTAL'			=> '%d Invitado',
	'HIDDEN_VISITS_TOTAL'		=> '%d ocultos, ',
	'HIDDEN_VISIT_TOTAL'		=> '%d oculto, ',
	'LASTVISIT_VISITS_TOTAL'	=> 'En total hubo <strong>%d</strong> usuarios en línea en las últimas 24 horas :: ',
	'LASTVISIT_VISIT_TOTAL'		=> 'En total hubo <strong>%d</strong> usuario en línea en las últimas 24 horas  :: ',
	'REG_VISITS_TOTAL'			=> '%d Registrados, ',
	'REG_VISIT_TOTAL'			=> '%d Registrado, ',

	'ST_ACTIVE_POSTERS'			=> 'Posteadores Activos',
	'ST_ANNS'					=> 'Anuncios',
	'ST_ATTACHMENTS'			=> 'Adjuntos',
	'ST_BOARD_STARTDATE'		=> 'Fecha Inicio',
	'ST_NEW'					=> 'Nuevo',
	'ST_NEWEST_USER'			=> 'Miembro más reciente',
	'ST_POSTS'					=> 'Mensajes',
	'ST_POSTS_PER_DAY'			=> 'Mensajes por dia',
	'ST_POSTS_PER_TOPIC'		=> 'Mensajes por Tema',
	'ST_POSTS_PER_USER'			=> 'Mensajes por usuario',
	'ST_STICKYS'				=> 'Importantes',
	'ST_TOP'					=> 'Total',
	'ST_TOPICS'					=> 'Temas',
	'ST_TOPICS_PER_DAY'			=> 'Temas por dia',
	'ST_TOPICS_PER_USER'		=> 'Temas por usuario',
	'ST_TOTAL_USERS'			=> 'Usuarios totales',
	'ST_USERS_PER_DAY'			=> 'Usuarios por dia',
	'ST_VISIT_IP'				=> 'Su IP',

	'WIO_ONLINE'			=> 'Usuarios online',
	'WIO_LASTDAY'			=> 'Usuarios hoy',
	'WIO_TOTAL'				=> 'Total',
	'WIO_REGISTERED'		=> 'Registrados',
	'WIO_HIDDEN'			=> 'Ocultos',
	'WIO_GUEST'				=> 'Invitados',

	// polls
	'NO_POLL'				=> 'Encuesta no disponible',

	// attachments_block
	'ATTACH_DATE'				=> 'Publicado',
	'ATTACH_SIZE'				=> 'Tamaño',
	'ATTACH_DOWNLOAD'			=> 'Descargado',
	'ATTACH_VIEW'				=> 'Visto',

	'ATTACH_COUNT'				=> array(
		0	=> 'Nunca',
		1	=> '%d vez',
		2	=> '%d veces',
	),

	'VIEW_TOPIC'				=> 'Ver tema',
	'DOWNLOAD'					=> 'Descargar',
	'NO_ATTACHMENTS'			=> 'No hay adjuntos disponibles',

	// language_select_block
	'LANGUAGE_CHANGE'		=> 'Cambiar Idioma',
	'LANGUAGE_DEFAULT'		=> 'Idioma original',
	'LANGUAGE_SET_MINE'		=> 'Establecer como mi idioma',
	'LANGUAGE_SELECT'		=> 'Seleccionar idioma',

	// news_block
	'POSTED_BY'			=> 'Publicado por',
	'COMMENTS'			=> 'Comentarios',
	'POLL'				=> 'Encuesta',
	'TOPIC_VIEWS'		=> 'Vistas',
	'NO_NEWS'			=> 'No hay noticias disponibles',
	'VIEW_COMMENTS'		=> 'Ver comentarios',

	// recent_topics_block
	'BLG_RECENT_ACTIVITY'	=> 'Actividad reciente',
	'BLG_RECENT_ANN'		=> 'Anuncios recientes',
	'BLG_RECENT_TOPICS'		=> 'Temas recientes',

	// paypal_block
	'AMOUNT_MSG'	=> 'Cantidad a donar',
	'CLICK_MSG'		=> 'Proceder a la donación',
	'CODE_MSG'		=> 'Tipo de moneda',

	'currencies'	=> array(
		'AUD'	=> 'Dólar Australiano',
		'CAD'	=> 'Dólar Canadiense',
		'CZK'	=> 'Corona Checa',
		'DKK'	=> 'Corona Danesa',
		'HKD'	=> 'Dólar de Hong Kong',
		'HUF'	=> 'Florín húngaro',
		'NZD'	=> 'Dólar de Nueva Zelanda',
		'NOK'	=> 'Kroner Noruego',
		'PLN'	=> 'Zloty Polaco',
		'GBP'	=> 'Libras esterlinas',
		'SGD'	=> 'Dólar de Singapur',
		'SEK'	=> 'Corona Sueca',
		'CHF'	=> 'Franco Suizo',
		'JPY'	=> 'Yen Japonés',
		'USD'	=> 'Dólar',
		'EUR'	=> 'Euro',
		'MXN'	=> 'Peso mejicano',
		'ILS'	=> 'Israeli New Shekels'
	),

	// most_poster_block
	'MEMBER_POSTS'		=> '%d (%.2f/día)',
	'USER'				=> 'Usuario',
	'NO_MOST_POSTER'	=> 'No hay usuarios para mostrar',
	
	// contact block
	'EMAIL_EMPTY'		=> 'Debe proporcionar una dirección de email',
	'EMAIL_INVALID'		=> 'El email ingresado no es válido.',

	// counter block
	'COUNTER_LOCAL'		=> 'Visitas a esta página',
	'COUNTER_TOTAL' 	=> 'Visitas totales',
	'COUNTER_STARTDATE' => 'Contando desde:<br />%s',
	'HITS_PER_DAY'		=> 'Visitas por día',
	'HITS_PER_HOUR'		=> 'Visitas por hora',
	'HITS_PER_MONTH'	=> 'Visitas por mes',
	'HITS_PER_USER'		=> 'Visitas por usuario',
	'HITS_PER_WEEK'		=> 'Visitas por semana',
	'HITS_PER_YEAR'		=> 'Visitas por año',

	// style_select_block
	'STYLE_CHANGE'		=> 'Cambiar Estilo',
	'STYLE_DEFAULT'		=> 'Estilo original',
	'STYLE_SET_MINE'	=> 'Establecer como mi estilo',
	'STYLE_SELECT'		=> 'Seleccionar estilo',

	// latest_bots_block
	'NO_BOTS'			=> 'Ningún bot visitó el foro',

	// latest_unread_block
	'NO_UNREAD'			=> 'No hay temas',

	// ranks_block
	'MIN_POSTS'			=> 'Mensajes mínimos',
	'SPECIAL_RANK'		=> 'Rango Especial',

	// online_friends_block
	'FRIENDS_ONLINE'		=> 'Amigos conectados',
	'FRIENDS_OFFLINE'		=> 'Amigos desconectados',
	'NO_FRIENDS_ONLINE'		=> 'No hay amigos conectados',
	'NO_FRIENDS_OFFLINE'	=> 'No hay amigos desconectados',
	'NO_FRIENDS'			=> 'No se han encontrado amigos',

	// age_ranges_block
	'RANGE'				=> 'Rango',
	'RANGE_USERS'		=> 'Usuarios (%)',
	'AGE_COUNTS'		=> 'Usuarios contados',
	'AGE_AV'			=> 'Edad de media',
	'AGE_AV_COUNT'		=> '%.2f años',

	// search_block
	'SH_ENGINE'			=> 'Motores de búsqueda',

	// announcements_block
	'NO_ANNOUNCEMENTS'	=> 'No hay anuncios para mostrar',

	// birthday_block
	'TODAY_BIRTHDAYS'		=> 'Cumpleaños para Hoy',
	'TOMORROW_BIRTHDAYS'	=> 'Cumpleaños para mañana',
	'BIRTHDAYS_FOR'			=> 'Cumpleaños para el %1$s de %2$s',

	// calendar
	'ADD_EVENT'				=> 'Añadir Evento',
	'DELETE_EVENT'			=> 'Eliminar Evento',
	'EDIT_EVENT'			=> 'Editar Evento',
	'EVENTS'				=> 'Eventos',

	'EMPTY_EVENT_TITLE'	=> 'Debe especificar un título para el evento.',
	'EVENT_ADDED'		=> 'Evento añadido con éxito',
	'EVENT_COLOR'		=> 'Color',
	'EVENT_EDITED'		=> 'Evento editado con éxito',
	'EVENT_GROUPS'		=> 'Grupos autorizados',
	'EVENT_TITLE'		=> 'Título del evento',
	'EVENT_TIME'		=> 'Fecha del evento',
	'EVENT_DETAILS'		=> 'Detalles',
	'EVENT_REMOVED'		=> 'Evento eliminado con éxito',
	'NO_EVENTS'			=> 'No hay eventos',
	
	// player block
	'MUTE'				=> 'Silencio',
	'WIN_CLOSE'			=> 'Cerrar ventana y devolver reproductor al bloque',
	'WIN_OPEN'			=> 'Abrir en ventana separada',
	'WIN_OPEN_EXPLAIN'	=> 'Reproduciendo en ventana',
	'WIN_RETURN'		=> 'Forzar reproductor en el bloque',
	'PLAY'				=> 'Reproducir',
	'PLAY_MSG'			=> 'Reproduciendo',
	'PLAYER'			=> 'Reproductor',
	'STOP'				=> 'Detener',
	'STOP_MSG'			=> 'Detenido',
	'VOLUME'			=> 'Volumen',
	'VOLUME_MSG'		=> 'Volumen: %d%',
	
	// rss block
	'NO_RSS'		=> 'No hay novedades para mostrar',
	
	// topic index block
	'CHAR_ALL'		=> 'Todos',
	
	// youtube block
	'NO_VIDEOS'		=> 'No hay videos para mostrar',
	'YT_VIEWS'		=> '%d reproducciones',
));

// General messages
$lang = array_merge($lang, array(
	'ACTION_ERROR'		=> 'No se ha realizado ninguna acción',
	'BLOCK_LOAD_ERROR'	=> 'No se ha podido cargar el bloque',
	'FORMAT_INVALID'	=> 'El formato no es válido',
	'EVENT_ERROR'		=> 'El evento seleccionado no existe',
	'NO_TRACKLIST'		=> 'No es posible mostrar la lista de pistas del reproductor.',
	'NO_PAGE'			=> 'La página solicitada no existe',
	'URL_INVALID'		=> 'La URL no es válida.',
));
