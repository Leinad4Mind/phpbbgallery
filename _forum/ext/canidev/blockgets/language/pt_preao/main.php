<?php

/**
 * @package cBB Blockgets for phpBB.
 * @version 2.0.7 01/07/2024
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

$lang = array_merge($lang, [
	'PORTAL'        => 'Portal',
	'READ_FULL'     => 'Ler tópico completo',
	'BLG_OR'        => 'ou',
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
	'HIDE_ME_NOW'   => 'Ocultar-me nesta sessão',
	'MY_BOOKMARKS'  => 'Favoritos',
	'MY_SUBSCRIBED' => 'Subscrições',
	'REMEMBER_ME'   => 'Lembrar-me',

	// Link Us Block
	'LINK_US_TXT' => 'Sente-te à vontade para colocar um link para <strong>%s</strong>. Utiliza o seguinte HTML:',

	// Stats Block and whos_online block
	'GUEST_VISITS_TOTAL'     => '%d Visitantes',
	'GUEST_VISIT_TOTAL'      => '%d Visitante',
	'HIDDEN_VISITS_TOTAL'    => '%d ocultos, ',
	'HIDDEN_VISIT_TOTAL'     => '%d oculto, ',
	'LASTVISIT_VISITS_TOTAL' => 'No total estiveram <strong>%d</strong> utilizadores online nas últimas 24 horas :: ',
	'LASTVISIT_VISIT_TOTAL'  => 'No total esteve <strong>%d</strong> utilizador online nas últimas 24 horas :: ',
	'REG_VISITS_TOTAL'       => '%d Registados, ',
	'REG_VISIT_TOTAL'        => '%d Registado, ',

	'ST_ACTIVE_POSTERS'  => 'Autores mais activos',
	'ST_ANNS'            => 'Anúncios',
	'ST_ATTACHMENTS'     => 'Anexos',
	'ST_BOARD_STARTDATE' => 'Data de início',
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
	'LANGUAGE_SELECT'   => 'Seleccionar Idioma',

	// news_block
	'POSTED_BY'     => 'Criado por',
	'COMMENTS'      => 'Comentários',
	'POLL'          => 'Votação',
	'TOPIC_VIEWS'   => 'Visualizações',
	'NO_NEWS'       => 'Sem notícias disponíveis',
	'VIEW_COMMENTS' => 'Ver comentários',

	// recent_topics_block
	'BLG_RECENT_ACTIVITY' => 'Actividade Recente',
	'BLG_RECENT_ANN'      => 'Anúncios Recentes',
	'BLG_RECENT_TOPICS'   => 'Tópicos Recentes',

	// paypal_block
	'AMOUNT_MSG' => 'Montante a doar',
	'CLICK_MSG'  => 'Prosseguir para a doação',
	'CODE_MSG'   => 'Moeda',

	'currencies' => [
		'AUD' => 'Dólar Australiano',
		'CAD' => 'Dólar Canadiano',
		'CZK' => 'Coroa Checa',
		'DKK' => 'Coroa Dinamarquesa',
		'HKD' => 'Dólar de Hong Kong',
		'HUF' => 'Forint Húngaro',
		'NZD' => 'Dólar Neozelandês',
		'NOK' => 'Coroa Norueguesa',
		'PLN' => 'Zloti Polaco',
		'GBP' => 'Libra Esterlina',
		'SGD' => 'Dólar de Singapura',
		'SEK' => 'Coroa Sueca',
		'CHF' => 'Franco Suíço',
		'JPY' => 'Iene Japonês',
		'USD' => 'Dólar',
		'EUR' => 'Euro',
		'MXN' => 'Peso Mexicano',
		'ILS' => 'Novo Shekel Israelita'
	],

	// most_poster_block
	'MEMBER_POSTS'   => '%d (%.2f/dia)',
	'USER'           => 'Utilizador',
	'NO_MOST_POSTER' => 'Sem utilizadores para exibir',

	// contact block
	'EMAIL_EMPTY'   => 'Tens de indicar um email.',
	'EMAIL_INVALID' => 'O email indicado é inválido.',

	// counter block
	'COUNTER_LOCAL'     => 'Visitas a esta página',
	'COUNTER_TOTAL'     => 'Total de visitas',
	'COUNTER_STARTDATE' => 'A contar desde:<br />%s',
	'HITS_PER_DAY'      => 'Visitas por dia',
	'HITS_PER_HOUR'     => 'Visitas por hora',
	'HITS_PER_MONTH'    => 'Visitas por mês',
	'HITS_PER_USER'     => 'Visitas por utilizador',
	'HITS_PER_WEEK'     => 'Visitas por semana',
	'HITS_PER_YEAR'     => 'Visitas por ano',

	// style_select_block
	'STYLE_CHANGE'   => 'Alterar estilo',
	'STYLE_DEFAULT'  => 'Estilo original',
	'STYLE_SET_MINE' => 'Definir como meu estilo',
	'STYLE_SELECT'   => 'Seleccionar estilo',

	// latest_bots_block
	'NO_BOTS' => 'Nenhum bot visitou o fórum',

	// latest_unread_block
	'NO_UNREAD' => 'Sem tópicos',

	// ranks_block
	'MIN_POSTS'    => 'Mensagens mínimas',
	'SPECIAL_RANK' => 'Posto especial',

	// online_friends_block
	'FRIENDS_ONLINE'     => 'Amigos online',
	'FRIENDS_OFFLINE'    => 'Amigos offline',
	'NO_FRIENDS_ONLINE'  => 'Nenhum amigo online',
	'NO_FRIENDS_OFFLINE' => 'Nenhum amigo offline',
	'NO_FRIENDS'         => 'Nenhum amigo encontrado',

	// age_ranges_block
	'RANGE'        => 'Categoria',
	'RANGE_USERS'  => 'Utilizadores (%)',
	'AGE_COUNTS'   => 'Utilizadores contados',
	'AGE_AV'       => 'Idade média',
	'AGE_AV_COUNT' => '%.2f anos',

	// search_block
	'SH_ENGINE' => 'Motores de busca',

	// announcements_block
	'NO_ANNOUNCEMENTS' => 'Sem Anúncios',

	//birthday_block
	'TODAY_BIRTHDAYS'    => 'Aniversários de hoje',
	'TOMORROW_BIRTHDAYS' => 'Aniversários de amanhã',
	'BIRTHDAYS_FOR'      => 'Aniversários de %1$s de %2$s',

	// calendar
	'ADD_EVENT'    => 'Adicionar evento',
	'DELETE_EVENT' => 'Remover Evento',
	'EDIT_EVENT'   => 'Editar Evento',
	'EVENTS'       => 'Eventos',

	'EMPTY_EVENT_TITLE' => 'Tens de colocar um título para o evento.',
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
	'WIN_OPEN_EXPLAIN' => 'A reproduzir na janela',
	'WIN_RETURN'       => 'Forçar leitor no bloco',
	'PLAY'             => 'Reproduzir',
	'PLAY_MSG'         => 'A reproduzir',
	'PLAYER'           => 'Leitor',
	'STOP'             => 'Parar',
	'STOP_MSG'         => 'Parou',
	'VOLUME'           => 'Volume',
	'VOLUME_MSG'       => 'Volume: %d%',

	// rss block
	'NO_RSS' => 'Sem Rss/Feed para mostrar.',

	// steam block
	'STEAM_IN_GAME' => 'A jogar',
	'STEAM_ONLINE'  => 'Online',
	'STEAM_MEMBERS' => 'Membros',

	// topic index block
	'CHAR_ALL' => 'Todos',

	// youtube block
	'NO_VIDEOS' => 'Sem vídeos para mostrar',
	'YT_VIEWS'  => '%d vistos',
]);

// General messages
$lang = array_merge($lang, [
	'ACTION_ERROR'     => 'Nenhuma acção realizada',
	'BLOCK_LOAD_ERROR' => 'Falha ao carregar o bloco',
	'FORMAT_INVALID'   => 'O formato não é válido',
	'EVENT_ERROR'      => 'O evento seleccionado não existe',
	'NO_TRACKLIST'     => 'Sem lista de faixas disponível.',
	'NO_PAGE'          => 'Esta página não existe.',
	'URL_INVALID'      => 'O URL não é válido.',
]);
