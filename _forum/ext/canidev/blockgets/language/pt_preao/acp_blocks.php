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

/**
 * @acp_blockgets_pages
*/
$lang = array_merge($lang, [
	// Blocks global config
	'BLOCK_COLLAPSE'             => 'Permitir colapsar o bloco',
	'BLOCK_COLLAPSE_EXPLAIN'     => 'Activa ou desactiva a possibilidade de cada utilizador colapsar/expandir este bloco e define o seu estado inicial.',
	'BLOCK_ENABLED'              => 'Bloco activado',
	'BLOCK_ENABLED_EXPLAIN'      => 'Define se este bloco é exibido no fórum.',
	'BLOCK_CURRENT_ICON'         => 'Ícone do bloco',
	'BLOCK_CURRENT_ICON_EXPLAIN' => 'Ícone actualmente definido para o bloco.',
	'BLOCK_GROUP'                => 'Grupos',
	'BLOCK_GROUP_EXPLAIN'        => 'Escolhe os grupos que podem ver este bloco no fórum.<br />Podes seleccionar vários grupos utilizando a tecla <em>Ctrl</em> do teu teclado.',
	'BLOCK_NO_CONFIG'            => 'Este bloco não necessita de configuração adicional',
	'BLOCK_STYLE'                => 'Aspecto do bloco',
	'BLOCK_STYLE_EXPLAIN'        => 'Com esta opção podes escolher o aspecto de cada bloco individualmente. Nota que a forma como é exibido depende do estilo instalado no fórum e da sua compatibilidade com a extensão.',
	'BLOCK_TITLE'                => 'Título do bloco',
	'BLOCK_TITLE_EXPLAIN'        => 'Nome único para o teu bloco.<br />Este título será mostrado no bloco.<br />Limite: 100 caracteres.',

	// Common tags
	'ALL_FORUMS'              => 'Todos os fóruns',
	'COLLAPSE_HIDDEN'         => 'Permitir (colapsado por defeito)',
	'COLLAPSE_NONE'           => 'Não permitir',
	'COLLAPSE_VISIBLE'        => 'Permitir (exibido por defeito)',
	'CONFIG'                  => 'Configuração',
	'DESIGN_FULL'             => 'Completo',
	'DESIGN_SIMPLE'           => 'Simples',
	'FORUMS'                  => 'Fóruns',
	'FORUMS_EXPLAIN'          => 'Fóruns que contêm os tópicos a mostrar. Podes seleccionar quantos quiseres utilizando a tecla <em>Ctrl</em> do teu teclado.',
	'IGNORE_AUTH'             => 'Ignorar permissões',
	'IGNORE_AUTH_EXPLAIN'     => 'Se activado, será mostrado todo o conteúdo, ignorando se o utilizador tem permissões para o ver.',
	'NO_LISTS'                => 'Sem listas disponíveis',
	'SHOW_PAGINATION'         => 'Mostrar paginação',
	'SHOW_PAGINATION_EXPLAIN' => 'Mostra a paginação para permitir ao utilizador ver mensagens mais antigas.',
	'TITLE_LIMIT'             => 'Limite do título',
	'TITLE_LIMIT_EXPLAIN'     => 'Número máximo de caracteres que serão exibidos nos títulos dos tópicos.<br />
		<em>Define 0 para mostrar o título completo.</em>',
	'TOPIC_DESIGN'         => 'Design do bloco',
	'TOPIC_DESIGN_EXPLAIN' => 'Determina como os tópicos serão exibidos no bloco.<br />
		<em><strong>Completo:</strong> Mostra toda a informação sempre que possível.</em><br />
		<em><strong>Simples:</strong> Mostra apenas a informação básica.</em>',
	'TOPIC_PARENT_SHOW'         => 'Mostrar fórum superior',
	'TOPIC_PARENT_SHOW_EXPLAIN' => 'Se activado, será exibido um link para o fórum de cada tópico.',

	// age_ranges_block
	'AGE_START'    => 'Idade mínima',
	'AGE_END'      => 'Idade máxima',
	'AGE_INTERVAL' => 'Intervalo',

	// announcements_block
	'ANN_MAX_NUMBER'           => 'Número de anúncios',
	'ANN_MAX_NUMBER_EXPLAIN'   => 'Número máximo de anúncios exibidos dentro do bloco.',
	'ANN_MAX_SIZE'             => 'Tamanho do anúncio',
	'ANN_MAX_SIZE_EXPLAIN'     => 'Tamanho máximo de caracteres permitido nos anúncios. O texto é cortado se este valor for excedido.',
	'ANN_SHOW_GLOBALS'         => 'Mostrar anúncios globais',
	'ANN_SHOW_GLOBALS_EXPLAIN' => 'Se activado, também são lidos os itens marcados como "globais", caso contrário só são lidos anúncios simples.',
	'ANN_COLLAPSE'             => 'Colapsar anúncios',
	'ANN_COLLAPSE_EXPLAIN'     => 'Se activado, o bloco mostra apenas um anúncio e colapsa os restantes. Caso contrário, os anúncios aparecem todos de uma vez no bloco.',

	// attachments_block
	'ATTACH_FORUM'             => 'Anexos do fórum',
	'ATTACH_FORUM_EXPLAIN'     => 'Se especificado, só mostra anexos deste fórum, ignorando os restantes.<br />O fórum deve conter directamente o tópico onde está o anexo; as categorias ou fóruns acima são ignorados aqui.',
	'ATTACH_EXTENSION'         => 'Extensões dos anexos',
	'ATTACH_EXTENSION_EXPLAIN' => 'Se especificado, todos os anexos que não contenham estas extensões serão ignorados.<br />Separa as extensões com ",".<br />Ex. extensões válidas: jpg,png,gif...',
	'ATTACH_NUM'               => 'Número de anexos',
	'ATTACH_NUM_EXPLAIN'       => 'Número máximo de anexos exibidos simultaneamente no bloco.',
	'ATTACH_SPECIFIC'          => 'Anexo específico',
	'ATTACH_SPECIFIC_EXPLAIN'  => 'Se especificado, apenas o anexo com o nome indicado será mostrado no bloco. O campo deve conter o nome de ficheiro original do anexo, Ex: oteuficheiro.jpg<br /><br /><strong>Nota:</strong> este campo sobrepõe-se aos restantes campos.',

	// banners_block, banners_multiple_block
	'BANNERS_TITLE'           => 'Título do banner',
	'BANNERS_TITLE_EXPLAIN'   => 'Se activado, o título aparecerá por baixo dos banners no bloco.',
	'BANNERS_LS_TYPE'         => 'Tipo de lista',
	'BANNERS_LS_TYPE_EXPLAIN' => 'Define como exibir os banners.<br />Pode ser definido um deslocamento horizontal, vertical ou permanecer fixo.',
	'BANNERS_NUMBER'          => 'Banners a mostrar',
	'BANNERS_NUMBER_EXPLAIN'  => 'Número máximo de banners a exibir no bloco.<br />
		<em>Define 0 para mostrar toda a lista.</em>',
	'BANNERS_RANDOM'           => 'Ordem aleatória',
	'BANNERS_RANDOM_EXPLAIN'   => 'Define se os elementos serão mostrados pela ordem da lista ou por ordem aleatória.',
	'LIST_NO_SCROLL'           => 'Sem deslocamento',
	'LIST_SCROLL_H'            => 'Deslocamento horizontal',
	'LIST_SCROLL_V'            => 'Deslocamento vertical',
	'BANNERS_B_HEIGHT'         => 'Altura do bloco',
	'BANNERS_B_HEIGHT_EXPLAIN' => 'Indica a altura do bloco a utilizar para as listas com deslocamento.',

	// birthdays_block
	'NEXT_BIRTHDAYS'         => 'Próximos aniversários',
	'NEXT_BIRTHDAYS_EXPLAIN' => 'Mostra os aniversários que ocorrem nos próximos dias.<br />
		<em>Máximo de 30 dias. Define 0 para desactivar.</em>',

	// calendar_block
	'CALENDAR_EVENTS'         => 'Mostrar eventos',
	'CALENDAR_EVENTS_EXPLAIN' => 'Se activado, os eventos são assinalados e exibidos no calendário.',
	'CALENDAR_MONTHS'         => 'Meses a mostrar',
	'CALENDAR_MONTHS_EXPLAIN' => 'Número de meses a exibir simultaneamente no bloco.',

	// contact block
	'CONTACT_CHECK_EMAIL'         => 'Verificar email',
	'CONTACT_CHECK_EMAIL_EXPLAIN' => 'Se activado, o domínio do email do utilizador será verificado e validado.',
	'CONTACT_EMAIL'               => 'Email de destino',
	'CONTACT_HIDE_FIELDS'         => 'Ocultar dados do utilizador',
	'CONTACT_HIDE_FIELDS_EXPLAIN' => 'Se activado, os campos "Nome" e "Email" serão ocultados para os utilizadores registados, e o bloco utilizará os valores do seu perfil.',

	// countdown block
	'COUNTDOWN_COMPLETE_MSG'         => 'Texto ao concluir',
	'COUNTDOWN_COMPLETE_MSG_EXPLAIN' => 'Texto a exibir quando o contador chegar a 0.',
	'COUNTDOWN_TARGET'               => 'Data limite',
	'COUNTDOWN_TARGET_EXPLAIN'       => 'Define a data e hora em que o contador chegará a 0.<br /><br />
		<em><strong>Formatos válidos</strong>
			<br />Ano/Mês/Dia
			<br />Ano/Mês/Dia Hora:Minuto:Segundo
		</em>',
	'COUNTDOWN_RUNNING_MSG'         => 'Texto de espera',
	'COUNTDOWN_RUNNING_MSG_EXPLAIN' => 'Texto a exibir enquanto o contador está em curso.',

	// counter block
	'COUNTER_LOCAL'         => 'Contador local',
	'COUNTER_LOCAL_EXPLAIN' => 'Se activado, o contador mostra apenas as visitas à sua página; caso contrário, mostra o total de visitas ao fórum.',

	// empty_block
	'BLOCK_CONTENT'         => 'Conteúdo do bloco',
	'BLOCK_CONTENT_EXPLAIN' => 'Conteúdo a exibir no bloco.<br />Limite: 8000 caracteres.<br /><br />São permitidas variáveis de idioma e de template, por exemplo, utiliza <em>{S_USERNAME}</em> para mostrar o nome do utilizador.',

	// clock_block
	'DISPLAY_CLOCK'         => 'Relógio a mostrar',
	'DISPLAY_CLOCK_EXPLAIN' => 'Relógio exibido no bloco.',
	'PREVIEW_CLOCK'         => 'Pré-visualização',
	'PREVIEW_CLOCK_EXPLAIN' => 'Pré-visualização do relógio seleccionado.',

	// cloud_tags_block
	'CLOUD_ANIMATION'         => 'Animação activada',
	'CLOUD_ANIMATION_EXPLAIN' => 'Se activado, as palavras "etiquetas" aparecem numa nuvem animada; caso contrário, aparecem como palavras fixas no bloco.',
	'CLOUD_MODE'              => 'Tipo de palavras',
	'CLOUD_MODE_EXPLAIN'      => 'Especifica que palavras serão mostradas no bloco.',
	'CLOUD_WORDS'             => 'Número de palavras',
	'CLOUD_WORDS_EXPLAIN'     => 'Número máximo de palavras que aparecem no bloco.',
	'MODE_SEARCH'             => 'Últimas palavras pesquisadas',
	'MODE_USERS'              => 'Utilizadores com mais mensagens',

	// forums block
	'FORUMS_FORUM' => 'Fórum a mostrar',

	// frame_block
	'MIME_HTML'  => 'Página Web',
	'MIME_PDF'   => 'Ficheiro PDF',
	'MIME_PLAIN' => 'Ficheiro de texto simples',

	'FRAME_HEIGHT'           => 'Altura do frame',
	'FRAME_HEIGHT_EXPLAIN'   => 'Altura do frame em pixels. Define 0 para ajuste automático.',
	'FRAME_MIMETYPE'         => 'Tipo de documento',
	'FRAME_MIMETYPE_EXPLAIN' => 'O tipo de documento exibido no frame.',
	'FRAME_URL'              => 'URL do documento',
	'FRAME_URL_EXPLAIN'      => 'URL do documento ou página exibida no frame.',
	'FRAME_WIDTH'            => 'Largura do frame',
	'FRAME_WIDTH_EXPLAIN'    => 'Largura do frame em pixels. Define 0 para ajuste automático.',

	// gallery_block
	'GALLERY_CUSTOM'             => 'Imagens personalizadas',
	'GALLERY_CUSTOM_EXPLAIN'     => 'Especifica a lista que contém as imagens a exibir.',
	'GALLERY_DIRECTION'          => 'Direcção do deslocamento',
	'GALLERY_FORUMS'             => 'Fóruns',
	'GALLERY_FORUMS_EXPLAIN'     => 'Define os fóruns dos quais ler os anexos.',
	'GALLERY_FPS'                => 'Velocidade do deslocamento',
	'GALLERY_HEIGHT'             => 'Altura da galeria',
	'GALLERY_MANAGE'             => 'Gerir galeria',
	'GALLERY_MARGIN'             => 'Margem da imagem',
	'GALLERY_MAX_NUMBER'         => 'Número de imagens',
	'GALLERY_MAX_NUMBER_EXPLAIN' => 'Número máximo de anexos a ler dos fóruns/tópicos/mensagens',
	'GALLERY_ORDER'              => 'Ordem dos tópicos/mensagens',
	'GALLERY_ORDER_EXPLAIN'      => 'Define a ordem em que os tópicos ou mensagens do fórum serão carregados.',
	'GALLERY_POSTS'              => 'Mensagens',
	'GALLERY_POSTS_EXPLAIN'      => 'IDs das mensagens das quais ler os anexos, separados por vírgulas. (Ex: 1,2,3).',
	'GALLERY_SOURCE'             => 'Origem das imagens',
	'GALLERY_SOURCE_EXPLAIN'     => 'Define que tipo de imagens serão carregadas dos fóruns, tópicos ou mensagens especificados.',
	'GALLERY_TOPICS'             => 'Tópicos',
	'GALLERY_TOPICS_EXPLAIN'     => 'IDs dos tópicos dos quais ler os anexos, separados por vírgulas. (Ex: 1,2,3).',
	'GALLERY_ZOOM'               => 'Zoom',
	'GALLERY_ZOOM_EXPLAIN'       => 'Diferença de tamanho ao passar o rato sobre a imagem (em pixels)',

	'GALLERY_ORDER_LAST' => 'Últimos primeiro',
	'GALLERY_ORDER_RAND' => 'Aleatória',

	'GALLERY_SOURCE_ALL'         => 'Todas',
	'GALLERY_SOURCE_ATTACHMENTS' => 'Apenas anexos',
	'GALLERY_SOURCE_IMAGES'      => 'Apenas imagens incorporadas',

	'IMG_TITLE'       => 'Título da imagem',
	'IMG_URL'         => 'Url da imagem',
	'IMG_URL_EXPLAIN' => 'Url de uma imagem JPG, GIF ou PNG. Ex: http://meudominio.com/imagem.jpg',

	// google_translate_block
	'GOOGLE_LANGS'              => 'Idiomas a mostrar no bloco',
	'GOOGLE_SHOW_NAMES'         => 'Mostrar nomes',
	'GOOGLE_SHOW_NAMES_EXPLAIN' => 'Se activado, o nome do idioma será exibido junto à sua bandeira.',

	// latest_bots_block
	'BOTS_NUMBER'         => 'Bots a mostrar',
	'BOTS_NUMBER_EXPLAIN' => 'Número máximo de bots da última visita a mostrar no bloco.',

	// latest_members_block
	'MEMBERS_NUMBER'         => 'Utilizadores a mostrar',
	'MEMBERS_NUMBER_EXPLAIN' => 'Número máximo de utilizadores a mostrar no bloco.',

	// leaders_block
	'LEADERS_ALL_GROUPS'         => 'Mostrar utilizadores em todos os seus grupos',
	'LEADERS_ALL_GROUPS_EXPLAIN' => 'Se activado, os utilizadores serão mostrados em todos os grupos de que são membros.
		Caso contrário, só serão mostrados no seu grupo por defeito.',
	'LEADERS_GROUPS'              => 'Grupos',
	'LEADERS_GROUPS_EXPLAIN'      => 'Grupos a mostrar no bloco. Se não seleccionares grupos, o bloco mostrará os Administradores e Moderadores.',
	'LEADERS_MODE'                => 'Modo de exibição',
	'LEADERS_MODE_ACCORDION'      => 'Acordeão',
	'LEADERS_MODE_SIMPLE'         => 'Lista simples',
	'LEADERS_ONLY_ONLINE'         => 'Apenas utilizadores online',
	'LEADERS_ONLY_ONLINE_EXPLAIN' => 'Se activado, só serão exibidos os utilizadores dos grupos seleccionados que tenham sessão iniciada.',

	// link_us_block
	'US_BANNER'         => 'Link do mini banner',
	'US_BANNER_EXPLAIN' => 'Mini banner que será a imagem na qual é preciso clicar para aceder ao fórum a partir do link.',

	// Login Block
	'ALT_LOGIN'             => 'Mostrar métodos alternativos',
	'ALT_LOGIN_EXPLAIN'     => 'Activa/desactiva a exibição de métodos alternativos de identificação.<br /><em>Ex: Oauth</em>',
	'FULL_LOGIN'            => 'Mostrar início de sessão completo',
	'FULL_LOGIN_EXPLAIN'    => 'Activa/desactiva as opções avançadas na identificação do utilizador.',
	'SHOW_REGISTER'         => 'Mostrar registo',
	'SHOW_REGISTER_EXPLAIN' => 'Opção de exibição para o registo de utilizadores.',

	// map_block
	'LATITUDE'                  => 'Latitude',
	'LONGITUDE'                 => 'Longitude',
	'LOCATION_ADD'              => 'Adicionar localização',
	'LOCATION_EDIT'             => 'Editar localização',
	'LOCATION_IMAGE'            => 'Imagem',
	'LOCATION_IMAGE_EXPLAIN'    => 'Imagem que assinalará o ponto no mapa.<br /><em>Se não definires nenhuma, será utilizado o marcador por defeito</em>.',
	'LOCATION_INCORRECT'        => 'A posição indicada está incorrecta.',
	'LOCATION_POSITION'         => 'Posição',
	'LOCATION_POSITION_EXPLAIN' => 'Define a latitude e longitude da localização.',
	'LOCATION_TEXT'             => 'Conteúdo',
	'LOCATION_TEXT_EXPLAIN'     => 'Texto a exibir no mapa ao clicar no ícone da localização.<br /><em>É permitido BBCode.</em>',
	'LOCATION_TITLE'            => 'Título',
	'MAP'                       => 'Mapa',
	'MAP_CENTER'                => 'Ponto central',
	'MAP_CENTER_EXPLAIN'        => 'Define a latitude e longitude do ponto central por defeito.',
	'MAP_LOCATIONS'             => 'Localizações',
	'MAP_ZOOM'                  => 'Zoom',
	'MAP_ZOOM_EXPLAIN'          => 'Define o zoom por defeito.',
	'SEARCH_ADDRESS'            => 'Pesquisar localização',
	'SELECT_LOCATION'           => 'Seleccionar localização',

	// menu_block
	'ICON_WIDTH'         => 'Largura do ícone',
	'ICON_WIDTH_EXPLAIN' => 'A largura dos ícones do bloco, em pixels.',

	// most_poster_block
	'POSTER_LIMIT'         => 'Limite de utilizadores',
	'POSTER_LIMIT_EXPLAIN' => 'O limite de utilizadores exibidos no bloco.',
	'POST_RANGE'           => 'Intervalo de mensagens',
	'POST_RANGE_EXPLAIN'   => 'Limite de tempo para a contagem de mensagens.',

	'ALL_POSTS'  => 'Todas as mensagens',
	'LAST_DAY'   => 'Último dia',
	'LAST_WEEK'  => 'Última semana',
	'LAST_MONTH' => 'Último mês',
	'LAST_YEAR'  => 'Último ano',

	// news_block
	'NEWS_DISPLAY'         => 'Informação a mostrar',
	'NEWS_DISPLAY_EXPLAIN' => '<em><strong>Conteúdo básico:</strong>Mostra título, autor e data.<br />
		<strong>Conteúdo completo:</strong>Mostra toda a informação da notícia.</em>',
	'NEWS_NUMBER'           => 'Número de notícias',
	'NEWS_NUMBER_EXPLAIN'   => 'Número máximo de notícias exibidas no bloco.',
	'NEWS_SIZE'             => 'Tamanho da notícia',
	'NEWS_SIZE_EXPLAIN'     => 'Tamanho máximo de caracteres permitido na notícia. O texto da notícia será cortado se este valor for excedido.',
	'NEWS_ALL'              => 'Mostrar todos os tópicos',
	'NEWS_ALL_EXPLAIN'      => 'Se activado, também são lidos os itens marcados como "anúncio" e "fixo"; caso contrário, só são lidos os tópicos "normais".',
	'NEWS_COLLAPSE'         => 'Colapsar notícias',
	'NEWS_COLLAPSE_EXPLAIN' => 'Se activado, o bloco mostra apenas uma notícia e colapsa as restantes. Caso contrário, as notícias aparecem todas de uma vez no bloco.',
	'NEWS_SHOW_FULL'        => 'Conteúdo completo',
	'NEWS_SHOW_SIMPLE'      => 'Conteúdo básico',

	// paypal_block
	'PAYPAL_ACCOUNT'            => 'Conta Paypal',
	'PAYPAL_ACCOUNT_EXPLAIN'    => 'Indica o endereço de email da tua conta Paypal, ex: xxx@xxx.com',
	'PAYPAL_ITEM'               => 'Descrição do pagamento',
	'PAYPAL_ITEM_EXPLAIN'       => 'Indica o nome (descrição) pelo qual os pagamentos serão identificados através do bloco.',
	'PAYPAL_MSG'                => 'Mensagem',
	'PAYPAL_MSG_EXPLAIN'        => 'Mensagem personalizável que aparecerá no bloco.<br />São permitidas variáveis de idioma e de template, por exemplo, utiliza <em>{S_USERNAME}</em> para mostrar o nome do utilizador.',
	'PAYPAL_IMG'                => 'Imagem do botão',
	'PAYPAL_IMG_EXPLAIN'        => 'Imagem a utilizar para o botão de "doação". Deixa este campo em branco para utilizar a imagem por defeito.',
	'PAYPAL_AMOUNTS'            => 'Valores',
	'PAYPAL_AMOUNTS_EXPLAIN'    => 'Valores monetários na lista. Separa os valores com ";" (Ex: 5;10;15).',
	'PAYPAL_CURRENCIES'         => 'Moedas',
	'PAYPAL_CURRENCIES_EXPLAIN' => 'Tipo de moeda a mostrar no bloco. Podes seleccionar mais do que uma e definir a moeda por defeito.',

	//player block
	'PLAYER_AUTOPLAY'         => 'Reprodução automática',
	'PLAYER_AUTOPLAY_EXPLAIN' => 'Define se o leitor começará automaticamente a reproduzir as faixas quando a página carrega.<br /><br />
		<em><strong>Nota:</strong>Os navegadores limitam esta funcionalidade, pelo que a reprodução só começará depois de o utilizador clicar em qualquer parte da página.</em>',
	'PLAYER_PLAYLIST'          => 'Mostrar lista de reprodução',
	'PLAYER_PLAYLIST_EXPLAIN'  => 'Define se a lista de reprodução é exibida no leitor.',
	'PLAYER_TRACKLIST'         => 'Lista de faixas',
	'PLAYER_TRACKLIST_EXPLAIN' => 'As faixas ou músicas do leitor.',

	'TRACK_TITLE'         => 'Título da faixa',
	'TRACK_TITLE_EXPLAIN' => 'O nome ou título exibido no leitor.',
	'TRACK_URL'           => 'URL da faixa',
	'TRACK_URL_EXPLAIN'   => 'Um URL de rádio (Ex: http://127.0.0.1:8888), um ficheiro áudio mp3 ou wav (Ex: http://oteuservidor.com/audio.mp3) ou um ficheiro de lista de reprodução válido (m3u, asx, pls).',

	// poll_block
	'DISPLAY_POLL'         => 'Votação a mostrar',
	'DISPLAY_POLL_EXPLAIN' => 'Votação exibida no bloco.',
	'DISPLAY_RESULTS'      => 'Mostrar resultados',
	'NO_POLLS'             => 'Sem votações disponíveis',

	// poll_random_block
	'POLL_FORUM'         => 'Fórum da votação',
	'POLL_FORUM_EXPLAIN' => 'Fórum que contém as votações mostradas no bloco.',
	'POLL_NUM'           => 'Número de votações',
	'POLL_NUM_EXPLAIN'   => 'O número de votações a exibir de uma vez dentro do bloco.',
	'NO_FORUMS'          => 'Sem fóruns disponíveis',

	// post_view_block
	'PV_ITEM_URL'         => 'URL de referência',
	'PV_ITEM_URL_EXPLAIN' => 'Especifica aqui o URL do fórum, tópico ou mensagem que queres exibir.<br />
		<em><strong>Nota:</strong> O url de um fórum ou tópico exibirá a sua última mensagem.</em>',

	// quote_of_day_block
	'QUOTE_AUTHOR'               => 'Autor da citação',
	'QUOTE_TEXT'                 => 'Texto da citação',
	'QUOTES_ALL_DAY'             => 'Manter durante o dia todo',
	'QUOTES_ALL_DAY_EXPLAIN'     => 'Se activado, verás a mesma citação durante todo o dia. Caso contrário, sempre que a página carregar verás uma citação diferente.',
	'QUOTES_LIST'                => 'Lista de citações',
	'QUOTES_RAND'                => 'Ordem aleatória',
	'QUOTES_RAND_EXPLAIN'        => 'Define se as citações são exibidas por ordem aleatória ou mantendo a ordem da lista.',
	'QUOTES_SHOW_AUTHOR'         => 'Mostrar autor',
	'QUOTES_SHOW_AUTHOR_EXPLAIN' => 'Define se o autor da citação é exibido no bloco.',

	// ranks_block
	'ORPHAN_RANKS'         => 'Mostrar postos órfãos',
	'ORPHAN_RANKS_EXPLAIN' => 'Se activado, mostrará os postos que não estão atribuídos a nenhum utilizador.',
	'ONLY_SPECIAL_RANKS'   => 'Apenas postos especiais',

	// recent_topics_block
	'RECENT_FORUMS'              => 'Fóruns dos tópicos',
	'RECENT_FORUMS_EXPLAIN'      => 'Fóruns que contêm os itens a exibir. Se não seleccionares nenhum, serão utilizados todos os fóruns. Podes seleccionar quantos quiseres utilizando a tecla <em>Ctrl</em> do teu teclado.',
	'RECENT_SECTIONS'            => 'Secções',
	'RECENT_SECTIONS_EXPLAIN'    => 'Define as secções a exibir no bloco e a sua ordem.',
	'RECENT_TOPIC_LIMIT'         => 'Limite de tópicos',
	'RECENT_TOPIC_LIMIT_EXPLAIN' => 'Número máximo de itens a exibir em cada separador.',

	// Rss block
	'1_HOUR'  => 'Uma hora',
	'2_HOURS' => 'Duas horas',
	'6_HOURS' => 'Seis horas',

	'RSS_COLLAPSABLE'         => 'Colapsável',
	'RSS_COLLAPSABLE_EXPLAIN' => 'Define se os itens são exibidos em acordeão ou em deslocamento. Se definido como "Sim", sobrepõe-se ao deslocamento do bloco.',
	'RSS_DIRECTION'           => 'Direcção do deslocamento',
	'RSS_DIRECTION_EXPLAIN'   => 'Define a direcção do deslocamento do texto. Esta opção é anulada se os itens forem exibidos em acordeão.',
	'RSS_HEIGHT'              => 'Altura do bloco',
	'RSS_HEIGHT_EXPLAIN'      => 'Define a altura do bloco, em pixels. Só se aplica se os itens não forem exibidos em formato de acordeão.',
	'RSS_IGNORE_LANG'         => 'Ignorar idioma do feed',
	'RSS_IGNORE_LANG_EXPLAIN' => 'Se activado, todos os URLs são lidos, independentemente do seu idioma; caso contrário, só serão exibidos os conteúdos escritos no idioma do utilizador.',
	'RSS_LIMIT'               => 'Limite do feed',
	'RSS_LIMIT_EXPLAIN'       => 'Número máximo de itens a ler de cada URL.',
	'RSS_SOURCES'             => 'Fontes do feed',
	'RSS_TITLE'               => 'Título do feed',
	'RSS_TTL'                 => 'Tempo de actualização',
	'RSS_TTL_EXPLAIN'         => 'Tempo que os itens permanecerão em cache antes de se tentar ler a fonte novamente.',
	'RSS_URL'                 => 'Url do ficheiro',
	'RSS_URL_EXPLAIN'         => 'Ex: <em>http://omeudominio.com/rss.xml</em>',

	// scroll_message_block
	'MARQUEE_DIRECTION'           => 'Direcção do deslocamento',
	'MARQUEE_DIRECTION_EXPLAIN'   => 'Direcção do deslocamento do texto. Este atributo controla a direcção do deslocamento.',
	'MARQUEE_SPEED'               => 'Quantidade de deslocamento',
	'MARQUEE_SPEED_EXPLAIN'       => 'Controla a quantidade de movimento (em pixels) entre as exibições sucessivas que dão a impressão de animação.',
	'MARQUEE_SCROLLDELAY'         => 'Atraso do deslocamento',
	'MARQUEE_SCROLLDELAY_EXPLAIN' => 'Controla o atraso (em milissegundos) entre as exibições sucessivas que dão a impressão de animação.',
	'MARQUEE_ALIGN'               => 'Alinhamento do deslocamento',
	'MARQUEE_ALIGN_EXPLAIN'       => 'Esta tag controla o posicionamento da caixa de exibição do texto em deslocamento em relação ao texto actual, exactamente da mesma forma que o atributo align da tag img.',
	'MARQUEE_BGCOLOR'             => 'Cor de fundo do deslocamento',
	'MARQUEE_BGCOLOR_EXPLAIN'     => 'Esta tag controla a cor de fundo da caixa de exibição.',
	'MARQUEE_HEIGHT'              => 'Altura do deslocamento',
	'MARQUEE_HEIGHT_EXPLAIN'      => 'Controla a altura da caixa de exibição.',
	'MARQUEE_PADDING'             => 'Espaçamento da caixa de deslocamento',
	'MARQUEE_PADDING_EXPLAIN'     => 'Espaço à volta da caixa de deslocamento. Este atributo equivale ao atributo "padding" do CSS.',
	'MARQUEE_TEXT'                => 'Texto da mensagem em deslocamento',
	'MARQUEE_TEXT_EXPLAIN'        => 'Adiciona/altera aqui uma mensagem com deslocamento. Limite de 2000 caracteres.<br /><br />São permitidas variáveis de idioma e de template, por exemplo, utiliza <em>{S_USERNAME}</em> para mostrar o nome do utilizador.',

	'BOTTOM' => 'Inferior',
	'DOWN'   => 'Baixo',
	'LEFT'   => 'Esquerda',
	'CENTER' => 'Centro',
	'UP'     => 'Cima',
	'RIGHT'  => 'Direita',
	'TOP'    => 'Superior',

	//share_block
	'SHARE_SHOW_NAMES'         => 'Mostrar nomes',
	'SHARE_SHOW_NAMES_EXPLAIN' => 'Se activado, o nome da rede social será exibido junto ao seu ícone.',
	'SHARE_URL'                => 'URL de referência',
	'SHARE_URL_EXPLAIN'        => 'Define um url de referência fixo para os botões. Deixa este campo em branco para utilizar a página exibida.',
	'SHARE_BUTTONS'            => 'Botões a mostrar',

	// stats_block
	'STATS_INLINE' => 'Mostrar dados em linha',
	'USER_STATS'   => 'Exibir estatísticas do utilizador',

	// steam_block
	'STEAM_GROUP_URL'         => 'Url do grupo',
	'STEAM_GROUP_URL_EXPLAIN' => '<em>Ex: https://steamcommunity.com/groups/grupodeexemplo</em>',

	// top_topics_block
	'TOPT_LIMIT'         => 'Limite de tópicos',
	'TOPT_LIMIT_EXPLAIN' => 'Número máximo de tópicos a mostrar.',
	'TOPT_MODE'          => 'Tópicos a mostrar',
	'TOPT_MODE_ACTIVE'   => 'Tópicos mais activos recentemente',
	'TOPT_MODE_UNREAD'   => 'Últimos tópicos não lidos',
	'TOPT_MODE_VIEWED'   => 'Tópicos mais vistos',

	// topic_index_block
	'TINDEX_CHAR_SELECT'         => 'Mostrar índice',
	'TINDEX_CHAR_SELECT_EXPLAIN' => 'Apenas disponível se o método de ordenação for <em>Título do tópico</em>.',
	'TINDEX_PER_PAGE'            => 'Tópicos por página',
	'TINDEX_PER_PAGE_EXPLAIN'    => 'Número de tópicos a mostrar em simultâneo. Define 0 para desactivar a paginação.',
	'TINDEX_SORT_MODE'           => 'Ordenar por',
	'TINDEX_SORT_MODE_EXPLAIN'   => 'Método a utilizar para definir a ordem dos tópicos na lista.',

	'TOPIC_TIME'     => 'Data do tópico',
	'LAST_POST_TIME' => 'Data da última mensagem',

	// welcome_block
	'WELCOME_GUEST'          => 'Mensagem para visitantes',
	'WELCOME_GUEST_EXPLAIN'  => 'Mensagem a exibir a todos os visitantes. Máximo de 2000 caracteres.<br /><br />São permitidas variáveis de idioma e de template, por exemplo, utiliza <em>{S_USERNAME}</em> para mostrar o nome do utilizador.',
	'WELCOME_MEMBER'         => 'Mensagem para membros',
	'WELCOME_MEMBER_EXPLAIN' => 'Mensagem a exibir a todos os utilizadores registados do fórum. Máximo de 2000 caracteres.<br /><br />São permitidas variáveis de idioma e de template, por exemplo, utiliza <em>{S_USERNAME}</em> para mostrar o nome do utilizador.',

	// whos_online_block
	'WHOS_ADVANCED'          => 'Modo avançado',
	'WHOS_ADVANCED_EXPLAIN'  => 'Se activado, exibirá toda a informação; caso contrário, aparecerá apenas informação básica (adequada para blocos laterais).',
	'WHOS_USERNAMES'         => 'Mostrar lista de utilizadores',
	'WHOS_USERNAMES_EXPLAIN' => 'Se activado, exibe a lista de utilizadores online (apenas no modo avançado).',

	// youtube_block
	'YT_AUTOPLAY'               => 'Reprodução automática activada',
	'YT_AUTOPLAY_EXPLAIN'       => 'Se activado, o vídeo será reproduzido automaticamente.<br />Se tiveres vários vídeos, apenas o primeiro é reproduzido automaticamente.',
	'YT_DISPLAY_MODE'           => 'Modo de exibição',
	'YT_FULL_PREVIEW'           => 'Mostrar miniaturas, título e descrição',
	'YT_LIST'                   => 'Mostrar uma lista com títulos',
	'YT_RANDOM_DISPLAY'         => 'Exibição aleatória',
	'YT_RANDOM_DISPLAY_EXPLAIN' => 'Se activado, apenas um vídeo aparecerá aleatoriamente. Caso contrário, todos os vídeos e canais aparecem de uma vez.',
	'YT_RESULT_LIMIT'           => 'Número de vídeos do canal',
	'YT_RESULT_LIMIT_EXPLAIN'   => 'Número máximo de vídeos carregados em cada canal.',
	'YT_SIMPLE_PREVIEW'         => 'Mostrar miniaturas e títulos',
	'YT_TEXT_LIMIT'             => 'Limite de texto',
	'YT_TEXT_LIMIT_EXPLAIN'     => 'Número máximo de caracteres na descrição do vídeo.',
	'YT_VIDEO_PREVIEW'          => 'Mostrar pré-visualização do vídeo',
	'YT_VIDEO_SIZE'             => 'Tamanho do leitor',
	'YT_VIDEO_TITLE'            => 'Título do vídeo',
	'YT_VIDEO_URL'              => 'Url do vídeo',
	'YT_VIDEO_URL_EXPLAIN'      => 'Ex: <em>https://www.youtube.com/watch?v=NHH_v0k7Gus</em>',
]);
