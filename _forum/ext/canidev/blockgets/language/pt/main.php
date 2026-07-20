<?php

/**
 * @package cBB Blockgets for phpBB.
 * [English [En]]
 * @version 2.0.7 01/07/2024
 * @copyright (c) 2024 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 * @translation Leinad4Mind [Portuguese [pt]] (2026)
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

$lang = array_merge($lang, [
	'PORTAL'        => 'Portal',
	'READ_FULL'     => 'Read full topic',
	'BLG_READ_MORE' => '%sLer mais%s',

	'ADD_PAGE'                => 'Criar página',
	'BANNERS'                 => 'Banners',
	'CALENDAR'                => 'Calendário',
	'CALENDAR_BIRTHDAY_TITLE' => '%1$s e <strong>mais %2$d</strong>.',
	'CALENDAR_SELECT_DATE'    => 'Seleccionar data',
	'EDIT_CONFIGURATION'      => 'Editar configuração',
	'EDIT_THIS_PAGE'          => 'Editar esta página',
	'EDITOR'                  => 'Editor',
	'EXPAND_CONTRACT'         => 'Expandir/colapsar',
	'INSERT_ON_ENTRY'         => 'Inserir no texto',
	'MANAGE_BLOCKS'           => 'Gerir blocos',
	'PRINT'                   => 'Imprimir',
	'SELECT_COLOUR'           => 'Seleccionar cor',
	'SMILIES'                 => 'Emoticons',
	'TODAY'                   => 'Hoje',

	// Editor
	'HTML_TITLE'  => 'Html:',
	'INSERT_HTML' => 'Inserir Código HTML',

	// Login Block
	'HIDE_ME_NOW'   => 'Hide me in this session',
	'MY_BOOKMARKS'  => 'Favoritos',
	'MY_SUBSCRIBED' => 'Subscrições',
	'REMEMBER_ME'   => 'Lembrar-me',

	// Link Us Block
	'LINK_US_TXT' => 'Please feel free to link to <strong>%s</strong>. Use the following HTML:',

	// Stats Block and whos_online block
	'GUEST_VISITS_TOTAL'     => '%d Visitantes',
	'GUEST_VISIT_TOTAL'      => '%d Visitante',
	'HIDDEN_VISITS_TOTAL'    => '%d ocultos, ',
	'HIDDEN_VISIT_TOTAL'     => '%d oculto, ',
	'LASTVISIT_VISITS_TOTAL' => 'In total there were <strong>%d</strong> users online in the last 24 hours :: ',
	'LASTVISIT_VISIT_TOTAL'  => 'In total there is <strong>%d</strong> user online in the last 24 hours  :: ',
	'REG_VISITS_TOTAL'       => '%d Registados, ',
	'REG_VISIT_TOTAL'        => '%d Registado, ',

	'ST_ACTIVE_POSTERS'  => 'Active posters',
	'ST_ANNS'            => 'Announcements',
	'ST_ATTACHMENTS'     => 'Anexos',
	'ST_BOARD_STARTDATE' => 'Start date',
	'ST_NEW'             => 'Novo',
	'ST_NEWEST_USER'     => 'Último membro',
	'ST_POSTS'           => 'Mensagens',
	'ST_POSTS_PER_DAY'   => 'Mensagens por dia',
	'ST_POSTS_PER_TOPIC' => 'Mensagens por tópico',
	'ST_POSTS_PER_USER'  => 'Mensagens por utilizador',
	'ST_STICKYS'         => 'Importantes',
	'ST_TOP'             => 'Total',
	'ST_TOPICS'          => 'Tópicos',
	'ST_TOPICS_PER_DAY'  => 'Tópicos por dia',
	'ST_TOPICS_PER_USER' => 'Tópicos por utilizador',
	'ST_TOTAL_USERS'     => 'Total utilizadores',
	'ST_USERS_PER_DAY'   => 'Utilizadores por dia',
	'ST_VISIT_IP'        => 'O teu IP',

	'WIO_ONLINE'     => 'Utilizadores online',
	'WIO_LASTDAY'    => 'Utilizadores hoje',
	'WIO_TOTAL'      => 'Total',
	'WIO_REGISTERED' => 'Registados',
	'WIO_HIDDEN'     => 'Ocultos',
	'WIO_GUEST'      => 'Visitantes',

	// polls
	'NO_POLL' => 'Votação indisponível',

	// attachments_block
	'ATTACH_DATE'     => 'Publicado',
	'ATTACH_SIZE'     => 'Tamanho',
	'ATTACH_DOWNLOAD' => 'Transferido',
	'ATTACH_VIEW'     => 'Visto',

	'ATTACH_COUNT' => [
		0 => 'Nunca',
		1 => '%d vez',
		2 => '%d vezes',
	],

	'VIEW_TOPIC'     => 'Ver Tópico',
	'DOWNLOAD'       => 'Download',
	'NO_ATTACHMENTS' => 'Sem anexos disponíveis',

	// language_select_block
	'LANGUAGE_CHANGE'   => 'Alterar idioma',
	'LANGUAGE_DEFAULT'  => 'Idioma Original',
	'LANGUAGE_SET_MINE' => 'Gravar como meu idioma',
	'LANGUAGE_SELECT'   => 'Selecionar Idioma',

	// news_block
	'POSTED_BY'       => 'Criado por',
	'LAST_REPLIED_BY' => 'Última resposta por',
	'COMMENTS_PORTAL' => 'Comentários',
	'POLL'            => 'Votação',
	'TOPIC_VIEWS'     => 'Visto',
	'NO_NEWS'         => 'Sem notícias disponíveis',
	'VIEW_COMMENTS'   => 'Ver comentários',

	// recent_topics_block
	'BLG_RECENT_ACTIVITY' => 'Actividade Recente',
	'BLG_RECENT_ANN'      => 'Anúncios Recentes',
	'BLG_RECENT_TOPICS'   => 'Tópicos Recentes',

	// paypal_block
	'AMOUNT_MSG' => 'Amount to donate',
	'CLICK_MSG'  => 'Proceed to donation',
	'CODE_MSG'   => 'Currency',

	'currencies' => [
		'AUD' => 'Aussie',
		'CAD' => 'Canadian Dollar',
		'CZK' => 'Czech Koruna',
		'DKK' => 'Danish Kroner',
		'HKD' => 'Hong Kong Dollar',
		'HUF' => 'Hungarian Forint',
		'NZD' => 'New Zealand Dollar',
		'NOK' => 'Norwegian Kroner',
		'PLN' => 'Polish Zlotych',
		'GBP' => 'British Pounds',
		'SGD' => 'Singapore Dollar',
		'SEK' => 'Swedish Kronor',
		'CHF' => 'Swiss Francs',
		'JPY' => 'Japanese Yen',
		'USD' => 'Dollar',
		'EUR' => 'Euro',
		'AUD' => 'Mexican Peso',
		'ILS' => 'New Israeli Shekels'
	],

	// most_poster_block
	'MEMBER_POSTS'   => '%d (%.2f/dia)',
	'USER'           => 'Utilizador',
	'NO_MOST_POSTER' => 'Sem utilizadores para exibir',

	// contact block
	'EMAIL_EMPTY'   => 'You must set an email.',
	'EMAIL_INVALID' => 'The entered email is invalid.',

	// counter block
	'COUNTER_LOCAL'     => 'Visits to this page',
	'COUNTER_TOTAL'     => 'Total visits',
	'COUNTER_STARTDATE' => 'Counting from:<br />%s',
	'HITS_PER_DAY'      => 'Visits per day',
	'HITS_PER_HOUR'     => 'Visits per hour',
	'HITS_PER_MONTH'    => 'Visits per month',
	'HITS_PER_USER'     => 'Visits per user',
	'HITS_PER_WEEK'     => 'Visits per week',
	'HITS_PER_YEAR'     => 'Visits per year',

	// style_select_block
	'STYLE_CHANGE'   => 'Change Style',
	'STYLE_DEFAULT'  => 'Original style',
	'STYLE_SET_MINE' => 'Set as my style',
	'STYLE_SELECT'   => 'Select style',

	// latest_bots_block
	'NO_BOTS' => 'Nenhum bot visitou o fórum',

	// latest_unread_block
	'NO_UNREAD' => 'Sem tópicos',

	// ranks_block
	'MIN_POSTS'    => 'Minimum Posts',
	'SPECIAL_RANK' => 'Special Rank',

	// online_friends_block
	'FRIENDS_ONLINE'     => 'Online friends',
	'FRIENDS_OFFLINE'    => 'Offline friends',
	'NO_FRIENDS_ONLINE'  => 'No friends online',
	'NO_FRIENDS_OFFLINE' => 'No friends offline',
	'NO_FRIENDS'         => 'No friends found',

	// age_ranges_block
	'RANGE'        => 'Rank',
	'RANGE_USERS'  => 'Utilizadores (%)',
	'AGE_COUNTS'   => 'Utilizadores contados',
	'AGE_AV'       => 'Idade média',
	'AGE_AV_COUNT' => '%.2f anos',

	// search_block
	'SH_ENGINE' => 'Search Engines',

	// announcements_block
	'NO_ANNOUNCEMENTS' => 'Sem Anúncios',

	//birthday_block
	'TODAY_BIRTHDAYS'    => 'Today Birthdays',
	'TOMORROW_BIRTHDAYS' => 'Tomorrow Birthdays',
	'BIRTHDAYS_FOR'      => 'Birthdays for %1$s of %2$s',

	// calendar
	'ADD_EVENT'    => 'Adicionar evento',
	'DELETE_EVENT' => 'Remover Evento',
	'EDIT_EVENT'   => 'Editar Evento',
	'EVENTS'       => 'Eventos',

	'EMPTY_EVENT_TITLE' => 'Tem de colocar um título para o evento.',
	'EVENT_ADDED'       => 'Evento adicionado com sucesso',
	'EVENT_COLOR'       => 'Cor',
	'EVENT_EDITED'      => 'Evento editado com sucesso',
	'EVENT_GROUPS'      => 'Grupos autorizados',
	'EVENT_TITLE'       => 'Título do Evento',
	'EVENT_TIME'        => 'Data do Evento',
	'EVENT_DETAILS'     => 'Detalhes',
	'EVENT_REMOVED'     => 'Evento removido com sucesso',
	'NO_EVENTS'         => 'Sem eventos',

	//player block
	'MUTE'             => 'Silenciar',
	'WIN_CLOSE'        => 'Fechar janela e regressar ao bloco',
	'WIN_OPEN'         => 'Abrir numa nova janela',
	'WIN_OPEN_EXPLAIN' => 'Playing in Window',
	'WIN_RETURN'       => 'Forze player in the block',
	'PLAY'             => 'Play',
	'PLAY_MSG'         => 'Playing',
	'PLAYER'           => 'Player',
	'STOP'             => 'Parar',
	'STOP_MSG'         => 'Parou',
	'VOLUME'           => 'Volume',
	'VOLUME_MSG'       => 'Volume: %d%',

	// rss block
	'NO_RSS' => 'Sem Rss/Feed para mostrar.',

	// topic index block
	'CHAR_ALL' => 'Todos',

	// youtube block
	'YT_EMPTY' => 'Sem vídeos para mostrar',
	'YT_VIEWS' => '%d vistos',
]);

// General messages
$lang = array_merge($lang, [
	'ACTION_ERROR'     => 'No action taken',
	'BLOCK_LOAD_ERROR' => 'Failed to load block',
	'FORMAT_INVALID'   => 'The format is not valid',
	'EVENT_ERROR'      => 'The selected event does not exist',
	'NO_TRACKLIST'     => 'No avaliable tracklist.',
	'NO_PAGE'          => 'This page no exists.',
	'URL_INVALID'      => 'The URL is not valid.',
]);
