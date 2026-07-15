<?php
/**
* [Spanish [Es]]
* @package cBB Blockgets
* @version 2.0.5 15/01/2023
*
* @copyright (c) 2023 CaniDev
* @license https://creativecommons.org/licenses/by-nc/4.0/
*/

// @ignore
if(!defined('IN_PHPBB'))
{
	exit;
}

if(empty($lang) || !is_array($lang))
{
	$lang = [];
}

/**
 * @acp_blockgets_pages
*/
$lang = array_merge($lang, array(
	// Blocks global config
	'BLOCK_COLLAPSE'			=> 'Permitir colapsar el bloque',
	'BLOCK_COLLAPSE_EXPLAIN'	=> 'Habilita/deshabilita la posibilidad de que cada usuario pueda colapsar/desplegar este bloque y define su estado inicial.',
	'BLOCK_ENABLED'				=> 'Bloque activado',
	'BLOCK_ENABLED_EXPLAIN'		=> 'Define si este bloque se mostrará o no en el foro.',
	'BLOCK_CURRENT_ICON'			=> 'Icono del bloque',
	'BLOCK_CURRENT_ICON_EXPLAIN'	=> 'Icono actual establecido para el bloque.',
	'BLOCK_GROUP'				=> 'Grupos',
	'BLOCK_GROUP_EXPLAIN'		=> 'Escoja los grupos de usuarios que podrán ver este bloque en el foro.<br />Puede seleccionar varios grupos usando la tecla <em>Ctrl</em> de su teclado.',
	'BLOCK_NO_CONFIG'			=> 'Este bloque no necesita configuración adicional',
	'BLOCK_STYLE'				=> 'Aspecto del bloque',
	'BLOCK_STYLE_EXPLAIN'		=> 'Con esta opción puede escoger la apariencia de cada bloque individualmente. Tenga en cuenta que la forma en que se muestre el bloque dependerá del estilo instalado en el foro y su compatibilidad con la extensión.',
	'BLOCK_TITLE'				=> 'Título del bloque',
	'BLOCK_TITLE_EXPLAIN'		=> 'Nombre único para su bloque.<br />Este título será mostrado en el bloque.<br />Límite de 100 caracteres.',

	// Common tags
	'ALL_FORUMS'				=> 'Todos los foros',
	'COLLAPSE_HIDDEN'			=> 'Permitir (colapsado por defecto)',
	'COLLAPSE_NONE'				=> 'No permitir',
	'COLLAPSE_VISIBLE'			=> 'Permitir (desplegado por defecto)',
	'CONFIG'					=> 'Configuración',
	'DESIGN_FULL'				=> 'Completo',
	'DESIGN_SIMPLE'				=> 'Simple',
	'FORUMS'					=> 'Foros',
	'FORUMS_EXPLAIN'			=> 'Foros que contienen los temas que se mostrarán. Puede seleccionar tantos como quiera usando la tecla <em>Ctrl</em> de su teclado.',
	'IGNORE_AUTH'				=> 'Ignorar permisos',
	'IGNORE_AUTH_EXPLAIN'		=> 'Si se habilita, se mostrará todo el contenido sin tener en cuenta los permisos de los foros implicados.',
	'NO_LISTS'					=> 'No hay listas disponibles',
	'SHOW_PAGINATION'			=> 'Mostrar paginación',
	'SHOW_PAGINATION_EXPLAIN'	=> 'Muestra la paginación para permitir ver mensajes más antiguos.',
	'TITLE_LIMIT'				=> 'Límite de titulo',
	'TITLE_LIMIT_EXPLAIN'		=> 'Máximo número de caracteres que se mostrarán en los títulos de los temas.<br />
		<em>Establezca 0 para mostrar el título completo.</em>',
	'TOPIC_DESIGN'				=> 'Diseño del bloque',
	'TOPIC_DESIGN_EXPLAIN'		=> 'Determina como se mostrarán los temas en el bloque.<br />
		<em><strong>Completo:</strong> Muestra toda la información siempre que sea posible.</em><br />
		<em><strong>Simple:</strong> Muestra solo información básica.</em>',
	'TOPIC_PARENT_SHOW'			=> 'Mostrar foro padre',
	'TOPIC_PARENT_SHOW_EXPLAIN'	=> 'Si se habilita, se mostrará un enlace al foro de cada tema.',

	// age_ranges_block
	'AGE_START'					=> 'Edad mínima',
	'AGE_END'					=> 'Edad máxima',
	'AGE_INTERVAL'				=> 'Intervalo',
	
	// announcements_block
	'ANN_MAX_NUMBER'			=> 'Número de anuncios',
	'ANN_MAX_NUMBER_EXPLAIN'	=> 'Número máximo de anuncios que se mostrarán dentro del bloque.',
	'ANN_MAX_SIZE'				=> 'Tamaño del anuncio',
	'ANN_MAX_SIZE_EXPLAIN'		=> 'Tamaño máximo de caracteres permitidos dentro de los anuncios. El texto del anuncio se cortará si supera este valor.',
	'ANN_SHOW_GLOBALS'			=> 'Mostrar anuncios globales',
	'ANN_SHOW_GLOBALS_EXPLAIN'	=> 'Si se habilita, se leerán tambien los temas marcados como "global", de lo contrario solo se leerán los anuncios simples.',
	'ANN_COLLAPSE'				=> 'Colapsar anuncios',
	'ANN_COLLAPSE_EXPLAIN'		=> 'Si se habilita, sólo se mostrará un anuncio y los demás se colapsarán. De lo contrario, los anuncios aparecerán todos a la vez en el bloque.',
	
	// attachments_block
	'ATTACH_FORUM'				=> 'Foro de adjuntos',
	'ATTACH_FORUM_EXPLAIN'		=> 'Si se especifica, solo se mostrarán los adjuntos dentro de este foro ignorando el resto.<br />El foro debe ser directamente el que contenga el tema donde está el adjunto, las categorias o foros superiores se ignoran aquí.',
	'ATTACH_EXTENSION'			=> 'Extensiones del adjunto',
	'ATTACH_EXTENSION_EXPLAIN'	=> 'Si se especifica, se ignorarán todos los adjuntos que no contengan estas extensiones.<br />Separe las extensiones con ",".<br />Ej. de extensiones válidas: jpg,png,gif,...',
	'ATTACH_NUM'				=> 'Número de adjuntos',
	'ATTACH_NUM_EXPLAIN'		=> 'Número máximo de adjuntos que se mostrarán simultáneamente dentro del bloque.',
	'ATTACH_SPECIFIC'			=> 'Adjunto específico',
	'ATTACH_SPECIFIC_EXPLAIN'	=> 'Si se especifica, solo se mostrará en el bloque el adjunto con el nombre especificado. El campo debe contener el nombre original del adjunto, Ej: mi-archivo.jpg<br /><br /><strong>Nota:</strong> este campo sobreescribe a los demás.',

	// banners_block, banners_multiple_block
	'BANNERS_TITLE'				=> 'Título del banner',
	'BANNERS_TITLE_EXPLAIN'		=> 'Si se habilita, el título aparecerá debajo de los banners en el bloque.',
	'BANNERS_LS_TYPE'			=> 'Tipo de lista',
	'BANNERS_LS_TYPE_EXPLAIN'	=> 'Define la forma en la que se mostrarán los banners.<br />Puede establecerse un desplazamiento horizontal, vertical o que permanezcan fijos.',
	'BANNERS_NUMBER'			=> 'Banners a mostrar',
	'BANNERS_NUMBER_EXPLAIN'	=> 'Número máximo de banners que se mostrarán en el bloque.<br />
		<em>Establezca 0 para mostrar toda la lista.</em>',
	'BANNERS_RANDOM'			=> 'Orden aleatorio',
	'BANNERS_RANDOM_EXPLAIN'	=> 'Define si los elementos de la lista se mostrarán de forma aleatoria o en el orden establecido.',
	'LIST_NO_SCROLL'			=> 'Sin Desplazamiento',
	'LIST_SCROLL_H'				=> 'Desplazamiento horizontal',
	'LIST_SCROLL_V'				=> 'Desplazamiento vertical',
	'BANNERS_B_HEIGHT'			=> 'Alto del bloque',
	'BANNERS_B_HEIGHT_EXPLAIN'	=> 'Especifique el alto del bloque que se usarán en las listas con scroll.',

	// birthdays_block
	'NEXT_BIRTHDAYS'			=> 'Pŕoximos cumpleaños',
	'NEXT_BIRTHDAYS_EXPLAIN'	=> 'Mostrar los cumpleaños que se producirán en los próximos dias.<br />
		<em>Máximo 30 dias. Establézcalo en 0 para deshabilitarlo.</em>',

	// calendar_block
	'CALENDAR_EVENTS'				=> 'Mostrar eventos',
	'CALENDAR_EVENTS_EXPLAIN'		=> 'Si se habilita, se marcarán y mostrarán los eventos en el calendario.',
	'CALENDAR_MONTHS'				=> 'Meses a mostrar',
	'CALENDAR_MONTHS_EXPLAIN'		=> 'Número de meses que se mostrarán simultáneamente en el bloque.',
	
	// contact block
	'CONTACT_CHECK_EMAIL'			=> 'Comprobar email',
	'CONTACT_CHECK_EMAIL_EXPLAIN'	=> 'Si se habilita, se comprobará si el dominio del email especificado por el usuario es válido.',
	'CONTACT_EMAIL'					=> 'Email de destino',
	'CONTACT_HIDE_FIELDS'			=> 'Ocultar datos del usuario',
	'CONTACT_HIDE_FIELDS_EXPLAIN'	=> 'Si se habilita, se ocultarán los campos "Nombre" y "Email" para los usuarios registrados y se usarán los datos de su perfil.',

	// countdown block
	'COUNTDOWN_COMPLETE_MSG'			=> 'Texto al completar',
	'COUNTDOWN_COMPLETE_MSG_EXPLAIN'	=> 'Texto que se mostrará cuando el contador llegue a 0.',
	'COUNTDOWN_TARGET'					=> 'Fecha límite',
	'COUNTDOWN_TARGET_EXPLAIN'			=> 'Establece la fecha y hora en la que el contador llegará a 0.<br /><br />
		<em><strong>Formatos válidos</strong>
			<br />Año/Mes/Día
			<br />Año/Mes/Día Hora:Minuto:Segundo
		</em>',
	'COUNTDOWN_RUNNING_MSG'				=> 'Texto de espera',
	'COUNTDOWN_RUNNING_MSG_EXPLAIN'		=> 'Texto que se mostrará mientras el contador esté funcionando.',

	// counter block
	'COUNTER_LOCAL'				=> 'Contador local',
	'COUNTER_LOCAL_EXPLAIN'		=> 'Si se habilita, sólo se contarán y mostrarán las visitas a la página en la que se encuentre el contador, en caso contrario, se mostrarán las visitas totales al foro.',

	// empty_block
	'BLOCK_CONTENT'				=> 'Contenido del bloque',
	'BLOCK_CONTENT_EXPLAIN'		=> 'Contenido que se mostrará en el bloque.<br />El límite es de 8000 caracteres.<br /><br />Acepta variables de idioma y plantillas, por ejemplo, use <em>{S_USERNAME}</em> para mostrar el nombre del usuario.',

	// clock_block
	'DISPLAY_CLOCK'				=> 'Reloj a mostrar',
	'DISPLAY_CLOCK_EXPLAIN'		=> 'Reloj que se mostrará en el bloque.',
	'PREVIEW_CLOCK'				=> 'Vista previa',
	'PREVIEW_CLOCK_EXPLAIN'		=> 'Vista previa del reloj seleccionado.',

	// cloud_tags_block
	'CLOUD_ANIMATION'			=> 'Animación',
	'CLOUD_ANIMATION_EXPLAIN'	=> 'Si se habilita, las palabras "tags" aparecerán en una nube animada, de lo contrario, aparecerán como palabras fijas en el bloque.',
	'CLOUD_MODE'				=> 'Tipo de palabras',
	'CLOUD_MODE_EXPLAIN'		=> 'Especifica que palabras se mostrarán en el bloque.',
	'CLOUD_WORDS'				=> 'Número de palabras',
	'CLOUD_WORDS_EXPLAIN'		=> 'Número máximo de palabras que se mostrarán en el bloque.',
	'MODE_SEARCH'				=> 'Últimas palabras buscadas',
	'MODE_USERS'				=> 'Usuarios con mas mensajes',
	
	// forums block
	'FORUMS_FORUM'		=> 'Foro a mostrar',
	
	// frame_block
	'MIME_HTML'			=> 'Página Web',
	'MIME_PDF'			=> 'Archivo PDF',
	'MIME_PLAIN'		=> 'Archivo de texto plano',

	'FRAME_HEIGHT'				=> 'Alto del marco',
	'FRAME_HEIGHT_EXPLAIN'		=> 'Alto del marco en píxeles. Establezca 0 para ajustar automáticamente.',
	'FRAME_MIMETYPE'			=> 'Tipo de documento',
	'FRAME_MIMETYPE_EXPLAIN'	=> 'Especifica el tipo de documento que se mostrará en el marco.',
	'FRAME_URL'					=> 'URL del documento',
	'FRAME_URL_EXPLAIN'			=> 'Dirección del documento/página que se mostrará en el marco.',
	'FRAME_WIDTH'				=> 'Ancho del marco',
	'FRAME_WIDTH_EXPLAIN'		=> 'Ancho del marco en píxeles. Establezca 0 para ajustar automáticamente.',
	
	// gallery_block
	'GALLERY_CUSTOM'				=> 'Imágenes personalizadas',
	'GALLERY_CUSTOM_EXPLAIN'		=> 'Especifique la lista que contiene las imágenes que se mostrarán.',
	'GALLERY_DIRECTION'				=> 'Dirección de desplazamiento',
	'GALLERY_FORUMS'				=> 'Foros',
	'GALLERY_FORUMS_EXPLAIN'		=> 'Define los foros de los cuales se leerán los adjuntos. Puede seleccionar tantos como quiera usando la tecla <em>Ctrl</em> de su teclado.',
	'GALLERY_FPS'					=> 'Velocidad de desplazamiento',
	'GALLERY_HEIGHT'				=> 'Alto de la galería',
	'GALLERY_MANAGE'				=> 'Administrar galería',
	'GALLERY_MARGIN'				=> 'Margen entre imágenes',
	'GALLERY_MAX_NUMBER'			=> 'Número máximo de imágenes',
	'GALLERY_MAX_NUMBER_EXPLAIN'	=> 'Adjuntos máximos que se leerán de los foros/temas/mensajes',
	'GALLERY_ORDER'					=> 'Orden de los temas/mensajes',
	'GALLERY_ORDER_EXPLAIN'			=> 'Define el orden en el que se cargarán los temas o mensajes del foro.',
	'GALLERY_POSTS'					=> 'Mensajes',
	'GALLERY_POSTS_EXPLAIN'			=> 'IDs de los mensajes de los cuales se leerán los adjuntos, separados por comas. (Ej: 1,2,3).',
	'GALLERY_SOURCE'				=> 'Origen de las imágenes',
	'GALLERY_SOURCE_EXPLAIN'		=> 'Define que tipo de imágenes se cargarán de los foros, temas o mensajes especificados.',
	'GALLERY_TOPICS'				=> 'Temas',
	'GALLERY_TOPICS_EXPLAIN'		=> 'IDs de los temas de los cuales se leerán los adjuntos, separados por comas. (Ej: 1,2,3).',
	'GALLERY_ZOOM'					=> 'Zoom',
	'GALLERY_ZOOM_EXPLAIN'			=> 'Píxeles que se aumentarán al pasar el ratón por encima de la imagen.',

	'GALLERY_ORDER_LAST'			=> 'Últimos primero',
	'GALLERY_ORDER_RAND'			=> 'Aleatorio',
	
	'GALLERY_SOURCE_ALL'			=> 'Todas',
	'GALLERY_SOURCE_ATTACHMENTS'	=> 'Solo adjuntos',
	'GALLERY_SOURCE_IMAGES'			=> 'Solo imágenes incrustadas',
	
	'IMG_TITLE'			=> 'Título de la imagen',
	'IMG_URL'			=> 'Url de la imagen',
	'IMG_URL_EXPLAIN'	=> 'Dirección de la imagen JPG, GIF o PNG. Ej:http://midominio.com/imagen.jpg',
	
	// google_translate_block
	'GOOGLE_LANGS'				=> 'Idiomas a mostrar en el bloque',
	'GOOGLE_SHOW_NAMES'			=> 'Mostrar nombres',
	'GOOGLE_SHOW_NAMES_EXPLAIN'	=> 'Si se habilita, se mostrará el nombre del idioma al lado de su bandera.',
	
	// latest_bots_block
	'BOTS_NUMBER'				=> 'Bots a mostrar',
	'BOTS_NUMBER_EXPLAIN'		=> 'Numero máximo de bots que se mostrarán en el bloque.',

	// latest_members_block
	'MEMBERS_NUMBER'			=> 'Usuarios a mostrar',
	'MEMBERS_NUMBER_EXPLAIN'	=> 'Numero máximo de usuarios que se mostrarán en el bloque.',
	
	// leaders_block
	'LEADERS_ALL_GROUPS'			=> 'Mostrar usuarios en todos sus grupos',
	'LEADERS_ALL_GROUPS_EXPLAIN'	=> 'Si se habilita, los usuarios se mostrarán en todos los grupos de los que sean miembros.
		En caso contrario solo se mostrarán en su grupo por defecto.',
	'LEADERS_GROUPS'				=> 'Grupos',
	'LEADERS_GROUPS_EXPLAIN'		=> 'Grupos que se mostrarán en el bloque. Si no selecciona ninguno se mostrarán los grupos de Administradores y Moderadores.',
	'LEADERS_MODE'					=> 'Modo de visualización',
	'LEADERS_MODE_ACCORDION'		=> 'Acordeón',
	'LEADERS_MODE_SIMPLE'			=> 'Lista Simple',
	'LEADERS_ONLY_ONLINE'			=> 'Solo usuarios online',
	'LEADERS_ONLY_ONLINE_EXPLAIN'	=> 'Si se habilita, solo se mostrarán los usuarios de los grupos seleccionados que estén conectados.',

	// link_us_block
	'US_BANNER'					=> 'Mini banner del enlace',
	'US_BANNER_EXPLAIN'			=> 'Mini banner que será la imagen en la que se tenga que hacer clic para acceder al foro desde el enlace.',

	// Login Block
	'ALT_LOGIN'					=> 'Mostrar métodos alternativos',
	'ALT_LOGIN_EXPLAIN'			=> 'Activa/desactiva la visualización de los métodos alternativos de identificación.<br /><em>Ej: Oauth</em>',
	'FULL_LOGIN'				=> 'Mostrar Login completo',
	'FULL_LOGIN_EXPLAIN'		=> 'Activa/desactiva las opciones avanzadas en la identificación de los usuarios.',
	'SHOW_REGISTER'				=> 'Mostrar Registro',
	'SHOW_REGISTER_EXPLAIN'		=> 'Mostrar opción para el registro de usuarios.',
	
	// map_block
	'LATITUDE'					=> 'Latitud',
	'LONGITUDE'					=> 'Longitud',
	'LOCATION_ADD'				=> 'Añadir ubicación',
	'LOCATION_EDIT'				=> 'Editar ubicación',
	'LOCATION_IMAGE'			=> 'Imagen',
	'LOCATION_IMAGE_EXPLAIN'	=> 'Imagen que marcará el punto en el mapa.<br /><em>Si no define ninguna se usará la marca predeterminada</em>.',
	'LOCATION_INCORRECT'		=> 'La posición introducida es incorrecta.',
	'LOCATION_POSITION'			=> 'Posición',
	'LOCATION_POSITION_EXPLAIN'	=> 'Define la latitud y longitud de la ubicación.',
	'LOCATION_TEXT'				=> 'Contenido',
	'LOCATION_TEXT_EXPLAIN'		=> 'Texto que se mostrará en el mapa, al hacer clic en el icono de la ubicación.<br /><em>BBcode está permitido.</em>',
	'LOCATION_TITLE'			=> 'Título',
	'MAP'						=> 'Mapa',
	'MAP_CENTER'				=> 'Punto central',
	'MAP_CENTER_EXPLAIN'		=> 'Define la latitud y longitud del punto central por defecto.',
	'MAP_LOCATIONS'				=> 'Ubicaciones',
	'MAP_ZOOM'					=> 'Zoom',
	'MAP_ZOOM_EXPLAIN'			=> 'Define el zoom por defecto.',
	'SEARCH_ADDRESS'			=> 'Buscar dirección',
	'SELECT_LOCATION'			=> 'Seleccionar ubicación',

	// menu_block
	'ICON_WIDTH'				=> 'Ancho de los iconos',
	'ICON_WIDTH_EXPLAIN'		=> 'El ancho que tienen los iconos en el bloque, en píxeles.',

	// most_poster_block
	'POSTER_LIMIT'				=> 'Límite de usuarios',
	'POSTER_LIMIT_EXPLAIN'		=> 'El límite de usuarios que se mostrarán en el bloque.',
	'POST_RANGE'				=> 'Rango de mensajes',
	'POST_RANGE_EXPLAIN'		=> 'Límite de tiempo para el conteo de mensajes.',

	'ALL_POSTS'			=> 'Todos los mensajes',
	'LAST_DAY'			=> 'Último día',
	'LAST_WEEK'			=> 'Última semana',
	'LAST_MONTH'		=> 'Último mes',
	'LAST_YEAR'			=> 'Último año',

	// news_block
	'NEWS_DISPLAY'				=> 'Información a mostrar',
	'NEWS_DISPLAY_EXPLAIN'		=> '<em><strong>Contenido básico:</strong> Muestra título, autor y fecha.<br />
		<strong>Contenido completo:</strong> Muestra toda la información de la noticia.</em>',
	'NEWS_NUMBER'				=> 'Número de noticias',
	'NEWS_NUMBER_EXPLAIN'		=> 'Número máximo de noticias que se mostrarán dentro del bloque.',
	'NEWS_SIZE'					=> 'Tamaño de las noticias',
	'NEWS_SIZE_EXPLAIN'			=> 'Tamaño máximo de caracteres permitidos dentro de las noticias. El texto de las noticias se cortará si supera este valor.',
	'NEWS_ALL'					=> 'Mostrar todos los temas',
	'NEWS_ALL_EXPLAIN'			=> 'Si se habilita, se leerán tambien los temas marcados como "anuncio" y "fijo", de lo contrario solo se leerán los temas "normales".',
	'NEWS_COLLAPSE'				=> 'Colapsar noticias',
	'NEWS_COLLAPSE_EXPLAIN'		=> 'Si se habilita, sólo se mostrará una noticia y las demás se colapsarán. De lo contrario, las noticias aparecerán todas a la vez en el bloque.',
	'NEWS_SHOW_FULL'			=> 'Contenido completo',
	'NEWS_SHOW_SIMPLE'			=> 'Contenido básico',
	
	// paypal_block
	'PAYPAL_ACCOUNT'			=> 'Cuenta de paypal',
	'PAYPAL_ACCOUNT_EXPLAIN'	=> 'Especifique la dirección de e-mail de su cuenta Paypal ej: xxx@xxx.com',
	'PAYPAL_ITEM'				=> 'Concepto de pago',
	'PAYPAL_ITEM_EXPLAIN'		=> 'Especifique el nombre (concepto) con el cual se identificarán los pagos hechos a través del bloque.',
	'PAYPAL_MSG'				=> 'Mensaje',
	'PAYPAL_MSG_EXPLAIN'		=> 'Mensaje personalizable que aparecerá en el bloque.<br /><br />Acepta variables de idioma y plantillas, por ejemplo, use <em>{S_USERNAME}</em> para mostrar el nombre del usuario.',
	'PAYPAL_IMG'				=> 'Imagen del botón',
	'PAYPAL_IMG_EXPLAIN'		=> 'Imagen que se usará para el botón "donar" del bloque. Deje este campo vacío para usar la imagen por defecto.',
	'PAYPAL_AMOUNTS'			=> 'Cantidades',
	'PAYPAL_AMOUNTS_EXPLAIN'	=> 'Cantidades de dinero del menú desplegable. Separe los valores con punto y coma (ej: 5;10;15).',
	'PAYPAL_CURRENCIES'			=> 'Monedas',
	'PAYPAL_CURRENCIES_EXPLAIN'	=> 'Tipo de monedas que se mostrarán en el bloque. Puede definir tantas como quiera y seleccionar la que se mostrará por defecto.',

	// player block
	'PLAYER_AUTOPLAY'			=> 'Reproducción automática',
	'PLAYER_AUTOPLAY_EXPLAIN'	=> 'Define si el reproductor comenzará automáticamente la reproducción de las pistas al cargar la página.<br /><br />
		<em><strong>Nota:</strong>Los navegadores limitan esta característica por lo que la reproducción no comenzará hasta que el usuario haga clic en cualquier parte de la página.</em>',
	'PLAYER_PLAYLIST'			=> 'Mostrar lista de pistas',
	'PLAYER_PLAYLIST_EXPLAIN'	=> 'Define si se mostrará la lista de pistas en el bloque.',
	'PLAYER_TRACKLIST'			=> 'Lista de pistas',
	'PLAYER_TRACKLIST_EXPLAIN'	=> 'Pistas o canciones que se reproducirán.',

	'TRACK_TITLE'			=> 'Título de pista',
	'TRACK_TITLE_EXPLAIN'	=> 'El nombre o título que se mostrará en el reproductor.',
	'TRACK_URL'				=> 'Url de la pista',
	'TRACK_URL_EXPLAIN'		=> 'Puede ser la dirección de una emisora (Ej: http://127.0.0.1:8888), la dirección de un archivo mp3 o wav (Ej: http://miservidor.com/audio.mp3) o la direccion de una lista m3u, asx o pls que contenga los archivos mp3 o wav.',

	// poll_block
	'DISPLAY_POLL'				=> 'Encuesta a mostrar',
	'DISPLAY_POLL_EXPLAIN'		=> 'Encuesta que se mostrará en el bloque.',
	'DISPLAY_RESULTS'			=> 'Mostrar resultados',
	'NO_POLLS'					=> 'No hay encuestas disponibles',

	// poll_random_block
	'POLL_FORUM'				=> 'Foro de encuestas',
	'POLL_FORUM_EXPLAIN'		=> 'Foro que contiene las encuestas que se mostrarán en el bloque.',
	'POLL_NUM'					=> 'Número de encuestas',
	'POLL_NUM_EXPLAIN'			=> 'El número de encuestas que se mostrarán a la vez, dentro del bloque.',
	'NO_FORUMS'					=> 'No hay foros disponibles',
	
	// post_view_block
	'PV_ITEM_URL'			=> 'URL de referencia',
	'PV_ITEM_URL_EXPLAIN'	=> 'Especifique aquí la URL del foro, tema o mensaje que quiera mostrar.<br />
		<em><strong>Nota:</strong> La url de un foro o tema mostrará su último mensaje.</em>',
	
	// quote_of_day_block
	'QUOTE_AUTHOR'				=> 'Autor de la cita',
	'QUOTE_TEXT'				=> 'Texto de la cita',
	'QUOTES_ALL_DAY'			=> 'Mantener todo el día',
	'QUOTES_ALL_DAY_EXPLAIN'	=> 'Si se habilita, se mostrará la misma cita todo el día. En caso contrario, cada vez que se cargue la página se mostrará una distinta.',
	'QUOTES_LIST'				=> 'Lista de citas',
	'QUOTES_RAND'				=> 'Orden aleatorio',
	'QUOTES_RAND_EXPLAIN'		=> 'Define si las citas se mostrarán en orden aleatorio o manteniendo el orden de la lista.',
	'QUOTES_SHOW_AUTHOR'		=> 'Mostrar autor',
	'QUOTES_SHOW_AUTHOR_EXPLAIN'	=> 'Define si se mostrará o no el autor de la cita en el bloque.',
	
	// ranks_block
	'ORPHAN_RANKS'					=> 'Mostrar rangos huérfanos',
	'ORPHAN_RANKS_EXPLAIN'			=> 'Si se habilita, se mostrarán los rangos que no están asignados a ningún usuario.',
	'ONLY_SPECIAL_RANKS'			=> 'Sólo rangos especiales',
	
	// recent_topics_block
	'RECENT_FORUMS'					=> 'Foros de temas',
	'RECENT_FORUMS_EXPLAIN'			=> 'Foros que contienen los temas que se mostrarán. En caso de no seleccionar ninguno, se usarán todos los foros. Puede seleccionar tantos como quiera usando la tecla <em>Ctrl</em> de su teclado.',
	'RECENT_SECTIONS'				=> 'Secciones',
	'RECENT_SECTIONS_EXPLAIN'		=> 'Define las secciones que se mostrarán en el bloque y su orden.',
	'RECENT_TOPIC_LIMIT'			=> 'Límite de temas',
	'RECENT_TOPIC_LIMIT_EXPLAIN'	=> 'Máximo número de temas que se mostrarán en cada pestaña.',

	// Rss block
	'1_HOUR'		=> 'Una hora',
	'2_HOURS'		=> 'Dos horas',
	'6_HOURS'		=> 'Seis horas',
	
	'RSS_COLLAPSABLE'			=> 'Colapsable',
	'RSS_COLLAPSABLE_EXPLAIN'	=> 'Establece si los articulos se mostrarán en forma de acordeón o se desplazarán. Si se define como "Si" se anula la configuración de desplazamiento del bloque.',
	'RSS_DIRECTION'				=> 'Dirección de desplazamiento',
	'RSS_DIRECTION_EXPLAIN'		=> 'Define la dirección de desplazamiento del texto. Esta opción se anula si los artículos se muestran en forma de acordeón.',
	'RSS_HEIGHT'				=> 'Alto del bloque',
	'RSS_HEIGHT_EXPLAIN'		=> 'Establece el alto del bloque, en píxeles. Solo se aplicará si los artículos no se muestran en formato acordeón.',
	'RSS_IGNORE_LANG'			=> 'Ignorar idioma',
	'RSS_IGNORE_LANG_EXPLAIN'	=> 'Si se habilita, se leerán todas las URL, independientemente de su idioma, de lo contrario, solo se mostrará el contenido escrito en el idioma del usuario.',
	'RSS_LIMIT'					=> 'Límite de artículos',
	'RSS_LIMIT_EXPLAIN'			=> 'Número máximo de artículos que se leerán de cada URL.',
	'RSS_SOURCES'				=> 'Fuentes de los artículos',
	'RSS_TITLE'					=> 'Título de la fuente',
	'RSS_TTL'					=> 'Tiempo de refresco',
	'RSS_TTL_EXPLAIN'			=> 'Tiempo que permanecerán guardados en caché los artículos antes de que se intente volver a leer la fuente.',
	'RSS_URL'					=> 'Dirección del archivo',
	'RSS_URL_EXPLAIN'			=> 'Ej: <em>http://midominio.com/rss.xml</em>',

	// scroll_message_block
	'MARQUEE_DIRECTION'				=> 'Dirección del Desplazamiento',
	'MARQUEE_DIRECTION_EXPLAIN'		=> 'Dirección de desplazamiento del texto. Este atributo controla la dirección de desplazamiento.',
	'MARQUEE_SPEED'					=> 'Velocidad del desplazamiento',
	'MARQUEE_SPEED_EXPLAIN'			=> 'Esto controla la velocidad de movimiento (en pixeles) en los despliegues sucesivos para dar la impresión de animación.',
	'MARQUEE_SCROLLDELAY'			=> 'Retraso',
	'MARQUEE_SCROLLDELAY_EXPLAIN'	=> 'Esto controla el retraso (en milisegundos) entre los desplazamientos sucesivos para dar la impresión de animación.',
	'MARQUEE_ALIGN'					=> 'Alineación de la marquesina',
	'MARQUEE_ALIGN_EXPLAIN'			=> 'Controla el posicionamiento de la marquesina relativo al texto actual, exactamente de la misma manera en que la etiqueta encuadra el atributo .',
	'MARQUEE_BGCOLOR'				=> 'Color de fondo',
	'MARQUEE_BGCOLOR_EXPLAIN'		=> 'Esta etiqueta controla el color del fondo de la caja de desplazamiento.',
	'MARQUEE_HEIGHT'				=> 'Altura de la marquesina',
	'MARQUEE_HEIGHT_EXPLAIN'		=> 'Esto controla la altura de la caja de desplazamiento.',
	'MARQUEE_PADDING'				=> 'Padding de la marquesina',
	'MARQUEE_PADDING_EXPLAIN'		=> 'Espacio alrededor de la caja de desplazamiento. Este atributo es equivalente al atributo "padding" de CSS.',
	'MARQUEE_TEXT'					=> 'Texto del mensaje de desplazamiento',
	'MARQUEE_TEXT_EXPLAIN'			=> 'Agregue/Cambie el mensaje de desplazamiento aquí.<br />Se permiten hasta 2000 carácteres.<br /><br />Acepta variables de idioma y plantillas, por ejemplo, use <em>{S_USERNAME}</em> para mostrar el nombre del usuario.',

	'BOTTOM'		=> 'Inferior',
	'DOWN'			=> 'Abajo',
	'LEFT'			=> 'Izquierda',
	'CENTER'		=> 'Centro',
	'UP'			=> 'Arriba',
	'RIGHT'			=> 'Derecha',
	'TOP'			=> 'Superior',
	
	//share_block
	'SHARE_SHOW_NAMES'			=> 'Mostrar nombres',
	'SHARE_SHOW_NAMES_EXPLAIN'	=> 'Si se habilita, se mostrará el nombre de la red social al lado de su icono.',
	'SHARE_URL'					=> 'URL de referencia',
	'SHARE_URL_EXPLAIN'			=> 'Establece una url de referencia fija para los botones. Deje este campo en blanco para usar la página que se muestra.',
	'SHARE_BUTTONS'				=> 'Botones a mostrar',

	// stats_block
	'STATS_INLINE'			=> 'Mostrar datos en línea',
	'USER_STATS'			=> 'Mostrar estadísticas de usuarios',

	// steam_block
	'STEAM_GROUP_URL'			=> 'Url del grupo',
	'STEAM_GROUP_URL_EXPLAIN'	=> '<em>Ej: https://steamcommunity.com/groups/grupodeejemplo</em>',
	
	// top_topics_block
	'TOPT_LIMIT'			=> 'Límite de temas',
	'TOPT_LIMIT_EXPLAIN'	=> 'Número máximo de temas que se mostrarán.',
	'TOPT_MODE'				=> 'Temas a mostrar',
	'TOPT_MODE_ACTIVE'		=> 'Últimos temas más activos',
	'TOPT_MODE_UNREAD'		=> 'Últimos temas sin leer',
	'TOPT_MODE_VIEWED'		=> 'Temas más vistos',
	
	// topic_index_block
	'TINDEX_CHAR_SELECT'			=> 'Mostrar Índice',
	'TINDEX_CHAR_SELECT_EXPLAIN'	=> 'Solo disponible si el método de orden está definido como <em>Título del tema</em>.',
	'TINDEX_PER_PAGE'			=> 'Temas por página',
	'TINDEX_PER_PAGE_EXPLAIN'	=> 'Número de temas que se mostrarán simultáneamente. Especifique 0 para deshabilitar la paginación.',
	'TINDEX_SORT_MODE'			=> 'Ordenar por',
	'TINDEX_SORT_MODE_EXPLAIN'	=> 'Método que se usará para ordenar los temas en el bloque.',

	'TOPIC_TIME'		=> 'Fecha de publicación',
	'LAST_POST_TIME'	=> 'Fecha del último mensaje',
	
	// welcome_block
	'WELCOME_GUEST'				=> 'Mensaje para los invitados',
	'WELCOME_GUEST_EXPLAIN'		=> 'Mensaje que se mostrará a todos los invitados. Máximo 2000 caracteres.<br /><br />Acepta variables de idioma y plantillas, por ejemplo, use <em>{S_USERNAME}</em> para mostrar el nombre del usuario.',
	'WELCOME_MEMBER'			=> 'Mensaje para los miembros',
	'WELCOME_MEMBER_EXPLAIN'	=> 'Mensaje que se mostrará a todos los usuarios registrados en el foro. Máximo 2000 caracteres.<br /><br />Acepta variables de idioma y plantillas, por ejemplo, use <em>{S_USERNAME}</em> para mostrar el nombre del usuario.',

	// whos_online_block
	'WHOS_ADVANCED'				=> 'Modo avanzado',
	'WHOS_ADVANCED_EXPLAIN'		=> 'Si se habilita se mostraŕa toda la información, de lo contrario, solo aparecerá la información básica (idóneo para los bloques laterales).',
	'WHOS_USERNAMES'			=> 'Mostrar usuarios',
	'WHOS_USERNAMES_EXPLAIN'	=> 'Si se habilita, se mostrará la lista de usuarios online (solo en el modo avanzado)',

	// youtube_block
	'YT_AUTOPLAY'				=> 'Reprodución automática',
	'YT_AUTOPLAY_EXPLAIN'		=> 'Si se activa, el primer video se reproducirá automáticamente.',
	'YT_DISPLAY_MODE'			=> 'Modo de visualización',
	'YT_FULL_PREVIEW'			=> 'Mostrar miniaturas, título y descripción',
	'YT_LIST'					=> 'Mostrar una lista con títulos',
	'YT_RANDOM_DISPLAY'			=> 'Visualización aleatoria',
	'YT_RANDOM_DISPLAY_EXPLAIN'	=> 'Si se habilita, los vídeos se leerán de uno en uno aleatoriamente, sino, todos los vídeos aparecerán a la vez.',
	'YT_RESULT_LIMIT'			=> 'Número de videos por canal',
	'YT_RESULT_LIMIT_EXPLAIN'	=> 'Número máximo de vídeos que se cargarán de cada canal.',
	'YT_SIMPLE_PREVIEW'			=> 'Mostrar miniaturas y título',
	'YT_TEXT_LIMIT'				=> 'Límite de texto',
	'YT_TEXT_LIMIT_EXPLAIN'		=> 'Número máximo de caracteres para la descripción de los videos.',
	'YT_VIDEO_PREVIEW'			=> 'Mostrar videos',
	'YT_VIDEO_SIZE'				=> 'Tamaño del reproductor',
	'YT_VIDEO_TITLE'			=> 'Título',
	'YT_VIDEO_URL'				=> 'Dirección',
	'YT_VIDEO_URL_EXPLAIN'		=> 'Ej: <em>https://www.youtube.com/watch?v=NHH_v0k7Gus</em>',
));
