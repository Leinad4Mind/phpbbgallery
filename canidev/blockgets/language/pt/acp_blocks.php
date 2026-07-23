<?php

/**
 * @package cBB Blockgets for phpBB.
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

/**
 * @acp_blockgets_pages
*/
$lang = array_merge($lang, [
	// Blocks global config
	'BLOCK_COLLAPSE'             => 'Permitir recolher o bloco',
	'BLOCK_COLLAPSE_EXPLAIN'     => 'Ativa ou desativa a possibilidade de cada utilizador recolher/expandir este bloco e define o seu estado inicial.',
	'BLOCK_ENABLED'              => 'Bloco ativado',
	'BLOCK_ENABLED_EXPLAIN'      => 'Define se este bloco é apresentado no fórum.',
	'BLOCK_CURRENT_ICON'         => 'Ícone do bloco',
	'BLOCK_CURRENT_ICON_EXPLAIN' => 'Ícone atual definido para o bloco.',
	'BLOCK_GROUP'                => 'Grupos',
	'BLOCK_GROUP_EXPLAIN'        => 'Escolhe os grupos que podem ver este bloco no fórum.<br />Podes selecionar vários grupos utilizando a tecla <em>Ctrl</em> do teclado.',
	'BLOCK_NO_CONFIG'            => 'Este bloco não necessita de configuração adicional',
	'BLOCK_STYLE'                => 'Aspeto do bloco',
	'BLOCK_STYLE_EXPLAIN'        => 'Com esta opção podes escolher o aspeto de cada bloco individualmente. Nota que a forma como é apresentado depende do estilo instalado no fórum e da sua compatibilidade com a extensão.',
	'BLOCK_TITLE'                => 'Título do bloco',
	'BLOCK_TITLE_EXPLAIN'        => 'Nome único para o teu bloco.<br />Este título será mostrado no bloco.<br />Limite: 100 caracteres.',

	// Common tags
	'ALL_FORUMS'                => 'Todos os fóruns',
	'COLLAPSE_HIDDEN'           => 'Permitir (recolhido por defeito)',
	'COLLAPSE_NONE'             => 'Não permitir',
	'COLLAPSE_VISIBLE'          => 'Permitir (visível por defeito)',
	'CONFIG'                    => 'Configuração',
	'DESIGN_FULL'               => 'Completo',
	'DESIGN_SIMPLE'             => 'Simples',
	'FORUMS'                    => 'Fóruns',
	'FORUMS_EXPLAIN'            => 'Fóruns que contêm os tópicos a mostrar. Podes selecionar quantos quiseres utilizando a tecla <em>Ctrl</em> do teclado.',
	'IGNORE_AUTH'               => 'Ignorar permissões',
	'IGNORE_AUTH_EXPLAIN'       => 'Se ativado, será mostrado todo o conteúdo, independentemente de o utilizador ter permissões para o ver.',
	'NO_LISTS'                  => 'Sem listas disponíveis',
	'SHOW_PAGINATION'           => 'Mostrar paginação',
	'SHOW_PAGINATION_EXPLAIN'   => 'Mostra a paginação para permitir ao utilizador ver mensagens mais antigas.',
	'TITLE_LIMIT'               => 'Limite do título',
	'TITLE_LIMIT_EXPLAIN'       => 'Número máximo de caracteres que serão apresentados nos títulos dos tópicos.<br />
		<em>Define 0 para mostrar o título completo.</em>',
	'TOPIC_DESIGN'              => 'Aspeto do bloco',
	'TOPIC_DESIGN_EXPLAIN'      => 'Determina como os tópicos serão apresentados no bloco.<br />
		<em><strong>Completo:</strong> Mostra toda a informação sempre que possível.</em><br />
		<em><strong>Simples:</strong> Mostra apenas a informação básica.</em>',
	'TOPIC_PARENT_SHOW'         => 'Mostrar fórum superior',
	'TOPIC_PARENT_SHOW_EXPLAIN' => 'Se ativado, será apresentado um link para o fórum de cada tópico.',

	// age_ranges_block
	'AGE_START'    => 'Idade mínima',
	'AGE_END'      => 'Idade máxima',
	'AGE_INTERVAL' => 'Intervalo',

	// announcements_block
	'ANN_MAX_NUMBER'           => 'Número de anúncios',
	'ANN_MAX_NUMBER_EXPLAIN'   => 'Número máximo de anúncios apresentados dentro do bloco.',
	'ANN_MAX_SIZE'             => 'Tamanho do anúncio',
	'ANN_MAX_SIZE_EXPLAIN'     => 'Tamanho máximo de caracteres permitido nos anúncios. O texto é cortado se este valor for excedido.',
	'ANN_SHOW_GLOBALS'         => 'Mostrar anúncios globais',
	'ANN_SHOW_GLOBALS_EXPLAIN' => 'Se ativado, também são lidos os elementos marcados como "globais", caso contrário só são lidos os anúncios simples.',
	'ANN_COLLAPSE'             => 'Recolher anúncios',
	'ANN_COLLAPSE_EXPLAIN'     => 'Se ativado, o bloco mostra apenas um anúncio e recolhe os restantes. Caso contrário, os anúncios aparecem todos de uma vez no bloco.',

	// attachments_block
	'ATTACH_FORUM'             => 'Fórum dos anexos',
	'ATTACH_FORUM_EXPLAIN'     => 'Se especificado, mostra apenas anexos deste fórum, ignorando os restantes.<br />O fórum deve conter diretamente o tópico onde está o anexo; as categorias ou fóruns acima são ignorados aqui.',
	'ATTACH_EXTENSION'         => 'Extensões de anexos',
	'ATTACH_EXTENSION_EXPLAIN' => 'Se especificado, todos os anexos que não contenham estas extensões serão ignorados.<br />Separa as extensões com ",".<br />Ex. extensões válidas: jpg,png,gif...',
	'ATTACH_NUM'               => 'Número de anexos',
	'ATTACH_NUM_EXPLAIN'       => 'Número máximo de anexos apresentados simultaneamente no bloco.',
	'ATTACH_SPECIFIC'          => 'Anexo específico',
	'ATTACH_SPECIFIC_EXPLAIN'  => 'Se especificado, apenas o anexo com o nome indicado será mostrado no bloco. O campo deve conter o nome original do ficheiro do anexo, Ex: myfile.jpg<br /><br /><strong>Nota:</strong> este campo substitui os restantes campos.',

	// banners_block, banners_multiple_block
	'BANNERS_TITLE'            => 'Título do banner',
	'BANNERS_TITLE_EXPLAIN'    => 'Se ativado, o título será apresentado por baixo dos banners no bloco.',
	'BANNERS_LS_TYPE'          => 'Tipo de lista',
	'BANNERS_LS_TYPE_EXPLAIN'  => 'Define como mostrar os banners.<br />Pode ser definido em deslocamento horizontal, vertical ou fixo.',
	'BANNERS_NUMBER'           => 'Banners a mostrar',
	'BANNERS_NUMBER_EXPLAIN'   => 'Número máximo de banners a mostrar no bloco.<br />
		<em>Define 0 para mostrar toda a lista.</em>',
	'BANNERS_RANDOM'           => 'Ordem aleatória',
	'BANNERS_RANDOM_EXPLAIN'   => 'Define se os elementos são mostrados pela ordem da lista ou por ordem aleatória.',
	'LIST_NO_SCROLL'           => 'Sem deslocamento',
	'LIST_SCROLL_H'            => 'Deslocamento horizontal',
	'LIST_SCROLL_V'            => 'Deslocamento vertical',
	'BANNERS_B_HEIGHT'         => 'Altura do bloco',
	'BANNERS_B_HEIGHT_EXPLAIN' => 'Introduz a altura do bloco que será utilizada para as listas com deslocamento.',

	// birthdays_block
	'NEXT_BIRTHDAYS'         => 'Próximos aniversários',
	'NEXT_BIRTHDAYS_EXPLAIN' => 'Mostra os aniversários que ocorrem nos próximos dias.<br />
		<em>Máximo 30 dias. Define 0 para desativar.</em>',

	// calendar_block
	'CALENDAR_EVENTS'         => 'Mostrar eventos',
	'CALENDAR_EVENTS_EXPLAIN' => 'Se ativado, os eventos são assinalados e apresentados no calendário.',
	'CALENDAR_MONTHS'         => 'Meses a mostrar',
	'CALENDAR_MONTHS_EXPLAIN' => 'Número de meses a apresentar simultaneamente no bloco.',

	// contact block
	'CONTACT_CHECK_EMAIL'         => 'Verificar email',
	'CONTACT_CHECK_EMAIL_EXPLAIN' => 'Se ativado, o domínio do email do utilizador será verificado e validado.',
	'CONTACT_EMAIL'               => 'Email de destino',
	'CONTACT_HIDE_FIELDS'         => 'Ocultar dados do utilizador',
	'CONTACT_HIDE_FIELDS_EXPLAIN' => 'Se ativado, os campos "Nome" e "Email" para os utilizadores registados ficarão ocultos e o bloco utilizará os valores do seu perfil.',

	// countdown block
	'COUNTDOWN_COMPLETE_MSG'         => 'Texto ao concluir',
	'COUNTDOWN_COMPLETE_MSG_EXPLAIN' => 'Texto a apresentar quando o contador chegar a 0.',
	'COUNTDOWN_TARGET'               => 'Prazo',
	'COUNTDOWN_TARGET_EXPLAIN'       => 'Define a data e hora em que o contador chegará a 0.<br /><br />
		<em><strong>Formatos válidos</strong>
			<br />Ano/Mês/Dia
			<br />Ano/Mês/Dia Hora:Minuto:Segundo
		</em>',
	'COUNTDOWN_RUNNING_MSG'          => 'Texto de espera',
	'COUNTDOWN_RUNNING_MSG_EXPLAIN'  => 'Texto a apresentar enquanto o contador está em curso.',

	// counter block
	'COUNTER_LOCAL'         => 'Contador local',
	'COUNTER_LOCAL_EXPLAIN' => 'Se ativado, o contador mostra apenas as visitas a esta página; caso contrário, mostra o total de visitas ao fórum.',

	// empty_block
	'BLOCK_CONTENT'         => 'Conteúdo do bloco',
	'BLOCK_CONTENT_EXPLAIN' => 'Conteúdo a apresentar no bloco.<br />Limite: 8000 caracteres.<br /><br />São permitidas variáveis de idioma e de template, por exemplo, usa <em>{S_USERNAME}</em> para mostrar o nome do utilizador.',

	// clock_block
	'DISPLAY_CLOCK'         => 'Relógio a mostrar',
	'DISPLAY_CLOCK_EXPLAIN' => 'Relógio apresentado no bloco.',
	'PREVIEW_CLOCK'         => 'Pré-visualização',
	'PREVIEW_CLOCK_EXPLAIN' => 'Pré-visualização do relógio selecionado.',

	// cloud_tags_block
	'CLOUD_ANIMATION'         => 'Animação ativada',
	'CLOUD_ANIMATION_EXPLAIN' => 'Se ativado, as palavras "tags" aparecem numa nuvem animada; caso contrário, aparecem como palavras fixas no bloco.',
	'CLOUD_MODE'              => 'Tipo de palavras',
	'CLOUD_MODE_EXPLAIN'      => 'Especifica que palavras serão mostradas no bloco.',
	'CLOUD_WORDS'             => 'Número de palavras',
	'CLOUD_WORDS_EXPLAIN'     => 'Número máximo de palavras apresentadas no bloco.',
	'MODE_SEARCH'             => 'Últimas palavras pesquisadas',
	'MODE_USERS'              => 'Utilizadores com mais mensagens',

	// forums block
	'FORUMS_FORUM' => 'Fórum a mostrar',

	// frame_block
	'MIME_HTML'  => 'Página Web',
	'MIME_PDF'   => 'Ficheiro PDF',
	'MIME_PLAIN' => 'Ficheiro de texto simples',

	'FRAME_HEIGHT'           => 'Altura da frame',
	'FRAME_HEIGHT_EXPLAIN'   => 'Altura da frame em pixels. Define 0 para ajuste automático.',
	'FRAME_MIMETYPE'         => 'Tipo de documento',
	'FRAME_MIMETYPE_EXPLAIN' => 'O tipo de documento apresentado na frame.',
	'FRAME_URL'              => 'URL do documento',
	'FRAME_URL_EXPLAIN'      => 'URL do documento ou página apresentada na frame.',
	'FRAME_WIDTH'            => 'Largura da frame',
	'FRAME_WIDTH_EXPLAIN'    => 'Largura da frame em pixels. Define 0 para ajuste automático.',

	// gallery_block
	'GALLERY_CUSTOM'             => 'Imagens personalizadas',
	'GALLERY_CUSTOM_EXPLAIN'     => 'Especifica a lista que contém as imagens a apresentar.',
	'GALLERY_DIRECTION'          => 'Direção do deslocamento',
	'GALLERY_FORUMS'             => 'Fóruns',
	'GALLERY_FORUMS_EXPLAIN'     => 'Define os fóruns dos quais ler os anexos.',
	'GALLERY_FPS'                => 'Velocidade de deslocamento',
	'GALLERY_HEIGHT'             => 'Altura da galeria',
	'GALLERY_MANAGE'             => 'Gerir galeria',
	'GALLERY_MARGIN'             => 'Margem da imagem',
	'GALLERY_MAX_NUMBER'         => 'Número de imagens',
	'GALLERY_MAX_NUMBER_EXPLAIN' => 'Número máximo de anexos que serão lidos dos fóruns/tópicos/mensagens',
	'GALLERY_ORDER'              => 'Ordem dos tópicos/mensagens',
	'GALLERY_ORDER_EXPLAIN'      => 'Define a ordem pela qual os tópicos ou mensagens do fórum serão carregados.',
	'GALLERY_POSTS'              => 'Mensagens',
	'GALLERY_POSTS_EXPLAIN'      => 'IDs das mensagens das quais ler os anexos, separados por vírgulas. (Ex: 1,2,3).',
	'GALLERY_SOURCE'             => 'Origem das imagens',
	'GALLERY_SOURCE_EXPLAIN'     => 'Define que tipo de imagens serão carregadas dos fóruns, tópicos ou mensagens especificados.',
	'GALLERY_TOPICS'             => 'Tópicos',
	'GALLERY_TOPICS_EXPLAIN'     => 'IDs dos tópicos dos quais ler os anexos, separados por vírgulas. (Ex: 1,2,3).',
	'GALLERY_ZOOM'               => 'Zoom',
	'GALLERY_ZOOM_EXPLAIN'       => 'Diferença de tamanho ao passar o rato sobre a imagem (em pixels)',

	'GALLERY_ORDER_LAST' => 'Mais recente primeiro',
	'GALLERY_ORDER_RAND' => 'Aleatório',

	'GALLERY_SOURCE_ALL'         => 'Todas',
	'GALLERY_SOURCE_ATTACHMENTS' => 'Apenas anexos',
	'GALLERY_SOURCE_IMAGES'      => 'Apenas imagens incorporadas',

	'IMG_TITLE'       => 'Título da imagem',
	'IMG_URL'         => 'URL da imagem',
	'IMG_URL_EXPLAIN' => 'URL de uma imagem JPG, GIF ou PNG. Ex:http://omeudominio.com/imagem.jpg',

	// google_translate_block
	'GOOGLE_LANGS'              => 'Idiomas a mostrar no bloco',
	'GOOGLE_SHOW_NAMES'         => 'Mostrar nomes',
	'GOOGLE_SHOW_NAMES_EXPLAIN' => 'Se ativado, o nome do idioma será apresentado junto à respetiva bandeira.',

	// latest_bots_block
	'BOTS_NUMBER'         => 'Bots a mostrar',
	'BOTS_NUMBER_EXPLAIN' => 'Número máximo de bots da última visita que serão mostrados no bloco.',

	// latest_members_block
	'MEMBERS_NUMBER'         => 'Utilizadores a mostrar',
	'MEMBERS_NUMBER_EXPLAIN' => 'Número máximo de utilizadores que serão mostrados no bloco.',

	// leaders_block
	'LEADERS_ALL_GROUPS'          => 'Mostrar utilizadores em todos os grupos',
	'LEADERS_ALL_GROUPS_EXPLAIN'  => 'Se ativado, os utilizadores serão mostrados em todos os grupos de que são membros.
		Caso contrário, só serão mostrados no seu grupo por defeito.',
	'LEADERS_GROUPS'              => 'Grupos',
	'LEADERS_GROUPS_EXPLAIN'      => 'Grupos que serão mostrados no bloco. Se não selecionares grupos, o bloco mostrará os Administradores e Moderadores.',
	'LEADERS_MODE'                => 'Modo de apresentação',
	'LEADERS_MODE_ACCORDION'      => 'Acordeão',
	'LEADERS_MODE_SIMPLE'         => 'Lista simples',
	'LEADERS_ONLY_ONLINE'         => 'Apenas utilizadores online',
	'LEADERS_ONLY_ONLINE_EXPLAIN' => 'Se ativado, só serão apresentados os utilizadores dos grupos selecionados que tenham sessão iniciada.',

	// link_us_block
	'US_BANNER'         => 'Mini banner do link',
	'US_BANNER_EXPLAIN' => 'Mini banner que será a imagem em que é necessário clicar para aceder ao fórum a partir do link.',

	// Login Block
	'ALT_LOGIN'             => 'Mostrar métodos alternativos',
	'ALT_LOGIN_EXPLAIN'     => 'Ativa/desativa a apresentação de métodos alternativos de identificação.<br /><em>Ex: Oauth</em>',
	'FULL_LOGIN'            => 'Mostrar início de sessão completo',
	'FULL_LOGIN_EXPLAIN'    => 'Ativa/desativa as opções avançadas na identificação do utilizador.',
	'SHOW_REGISTER'         => 'Mostrar registo',
	'SHOW_REGISTER_EXPLAIN' => 'Opção de apresentação para o registo de utilizadores.',

	// map_block
	'LATITUDE'                  => 'Latitude',
	'LONGITUDE'                 => 'Longitude',
	'LOCATION_ADD'              => 'Adicionar localização',
	'LOCATION_EDIT'             => 'Editar localização',
	'LOCATION_IMAGE'            => 'Imagem',
	'LOCATION_IMAGE_EXPLAIN'    => 'Imagem que marcará o ponto no mapa.<br /><em>Se não definires nenhuma, será utilizada a marca por defeito</em>.',
	'LOCATION_INCORRECT'        => 'A posição introduzida está incorreta.',
	'LOCATION_POSITION'         => 'Posição',
	'LOCATION_POSITION_EXPLAIN' => 'Define a latitude e longitude da localização.',
	'LOCATION_TEXT'             => 'Conteúdo',
	'LOCATION_TEXT_EXPLAIN'     => 'Texto a apresentar no mapa ao clicar no ícone da localização.<br /><em>É permitido BBCode.</em>',
	'LOCATION_TITLE'            => 'Título',
	'MAP'                       => 'Mapa',
	'MAP_CENTER'                => 'Ponto central',
	'MAP_CENTER_EXPLAIN'        => 'Define a latitude e longitude do ponto central por defeito.',
	'MAP_LOCATIONS'             => 'Localizações',
	'MAP_ZOOM'                  => 'Zoom',
	'MAP_ZOOM_EXPLAIN'          => 'Define o zoom por defeito.',
	'SEARCH_ADDRESS'            => 'Pesquisar localização',
	'SELECT_LOCATION'           => 'Selecionar localização',

	// menu_block
	'ICON_WIDTH'         => 'Largura do ícone',
	'ICON_WIDTH_EXPLAIN' => 'A largura dos ícones do bloco, em pixels.',

	// most_poster_block
	'POSTER_LIMIT'         => 'Limite de utilizadores',
	'POSTER_LIMIT_EXPLAIN' => 'O limite de utilizadores apresentados no bloco.',
	'POST_RANGE'           => 'Intervalo de mensagens',
	'POST_RANGE_EXPLAIN'   => 'Limite de tempo para a contagem de mensagens.',

	'ALL_POSTS'  => 'Todas as mensagens',
	'LAST_DAY'   => 'Último dia',
	'LAST_WEEK'  => 'Última semana',
	'LAST_MONTH' => 'Último mês',
	'LAST_YEAR'  => 'Último ano',

	// news_block
	'NEWS_DISPLAY'          => 'Informação a mostrar',
	'NEWS_DISPLAY_EXPLAIN'  => '<em><strong>Conteúdo básico:</strong>Mostra título, autor e data.<br />
		<strong>Conteúdo completo:</strong>Mostra toda a informação da notícia.</em>',
	'NEWS_NUMBER'           => 'Número de notícias',
	'NEWS_NUMBER_EXPLAIN'   => 'Número máximo de notícias apresentadas no bloco.',
	'NEWS_SIZE'             => 'Tamanho da notícia',
	'NEWS_SIZE_EXPLAIN'     => 'Tamanho máximo de caracteres permitido nas notícias. O texto da notícia será cortado se este valor for excedido.',
	'NEWS_ALL'              => 'Mostrar todos os tópicos',
	'NEWS_ALL_EXPLAIN'      => 'Se ativado, também são lidos os elementos marcados como "anúncio" e "fixo"; caso contrário, só são lidos os tópicos "normais".',
	'NEWS_COLLAPSE'         => 'Recolher notícias',
	'NEWS_COLLAPSE_EXPLAIN' => 'Se ativado, o bloco mostra apenas uma notícia e recolhe as restantes. Caso contrário, as notícias aparecem todas de uma vez no bloco.',
	'NEWS_SHOW_FULL'        => 'Conteúdo completo',
	'NEWS_SHOW_SIMPLE'      => 'Conteúdo básico',

	// paypal_block
	'PAYPAL_ACCOUNT'            => 'Conta PayPal',
	'PAYPAL_ACCOUNT_EXPLAIN'    => 'Introduz o endereço de email da tua conta PayPal ex: xxx@xxx.com',
	'PAYPAL_ITEM'               => 'Descrição do pagamento',
	'PAYPAL_ITEM_EXPLAIN'       => 'Introduz o nome (descrição) pelo qual os pagamentos serão identificados através do bloco.',
	'PAYPAL_MSG'                => 'Mensagem',
	'PAYPAL_MSG_EXPLAIN'        => 'Mensagem personalizável que aparecerá no bloco.<br />São permitidas variáveis de idioma e de template, por exemplo, usa <em>{S_USERNAME}</em> para mostrar o nome do utilizador.',
	'PAYPAL_IMG'                => 'Imagem do botão',
	'PAYPAL_IMG_EXPLAIN'        => 'Imagem a utilizar para o botão de "doação". Deixa este campo em branco para utilizar a imagem por defeito.',
	'PAYPAL_AMOUNTS'            => 'Valores',
	'PAYPAL_AMOUNTS_EXPLAIN'    => 'Valor monetário na seleção. Separa os valores com ";" (Ex: 5;10;15).',
	'PAYPAL_CURRENCIES'         => 'Moedas',
	'PAYPAL_CURRENCIES_EXPLAIN' => 'Tipo de moeda a mostrar no bloco. Podes selecionar mais do que uma e definir a moeda por defeito.',

	//player block
	'PLAYER_AUTOPLAY'          => 'Reprodução automática',
	'PLAYER_AUTOPLAY_EXPLAIN'  => 'Define se o leitor começará a reproduzir as faixas automaticamente ao carregar a página.<br /><br />
		<em><strong>Nota:</strong>Os navegadores limitam esta funcionalidade, pelo que a reprodução só começará depois de o utilizador clicar em qualquer parte da página.</em>',
	'PLAYER_PLAYLIST'          => 'Mostrar lista de reprodução',
	'PLAYER_PLAYLIST_EXPLAIN'  => 'Define se a lista de reprodução é apresentada no leitor.',
	'PLAYER_TRACKLIST'         => 'Lista de faixas',
	'PLAYER_TRACKLIST_EXPLAIN' => 'As faixas ou músicas do leitor.',

	'TRACK_TITLE'         => 'Título da faixa',
	'TRACK_TITLE_EXPLAIN' => 'O nome ou título apresentado no leitor.',
	'TRACK_URL'           => 'URL da faixa',
	'TRACK_URL_EXPLAIN'   => 'Um URL de rádio (Ex: http://127.0.0.1:8888), um ficheiro áudio mp3 ou wav (Ex: http://oservidor.com/audio.mp3) ou um ficheiro de lista de reprodução válido (m3u, asx, pls).',

	// poll_block
	'DISPLAY_POLL'         => 'Sondagem a mostrar',
	'DISPLAY_POLL_EXPLAIN' => 'Sondagem apresentada no bloco.',
	'DISPLAY_RESULTS'      => 'Mostrar resultados',
	'NO_POLLS'             => 'Nenhuma sondagem disponível',

	// poll_random_block
	'POLL_FORUM'         => 'Fórum das sondagens',
	'POLL_FORUM_EXPLAIN' => 'Fórum que contém as sondagens a mostrar no bloco.',
	'POLL_NUM'           => 'Número de sondagens',
	'POLL_NUM_EXPLAIN'   => 'O número de sondagens que serão apresentadas de uma vez dentro do bloco.',
	'NO_FORUMS'          => 'Nenhum fórum disponível',

	// post_view_block
	'PV_ITEM_URL'         => 'URL de referência',
	'PV_ITEM_URL_EXPLAIN' => 'Especifica aqui o URL do fórum, tópico ou mensagem que queres apresentar.<br />
		<em><strong>Nota:</strong> O URL de um fórum ou tópico apresentará a sua última mensagem.</em>',

	// quote_of_day_block
	'QUOTE_AUTHOR'               => 'Autor da citação',
	'QUOTE_TEXT'                 => 'Texto da citação',
	'QUOTES_ALL_DAY'             => 'Manter todo o dia',
	'QUOTES_ALL_DAY_EXPLAIN'     => 'Se ativado, verás a mesma citação durante todo o dia. Caso contrário, verás uma citação diferente sempre que a página carregar.',
	'QUOTES_LIST'                => 'Lista de citações',
	'QUOTES_RAND'                => 'Ordem aleatória',
	'QUOTES_RAND_EXPLAIN'        => 'Define se as citações são apresentadas por ordem aleatória ou mantendo a ordem da lista.',
	'QUOTES_SHOW_AUTHOR'         => 'Mostrar autor',
	'QUOTES_SHOW_AUTHOR_EXPLAIN' => 'Define se o autor da citação é apresentado no bloco.',

	// ranks_block
	'ORPHAN_RANKS'         => 'Mostrar categorias órfãs',
	'ORPHAN_RANKS_EXPLAIN' => 'Se ativado, mostra as categorias que não estão atribuídas a nenhum utilizador.',
	'ONLY_SPECIAL_RANKS'   => 'Apenas categorias especiais',

	// recent_topics_block
	'RECENT_FORUMS'              => 'Fóruns dos tópicos',
	'RECENT_FORUMS_EXPLAIN'      => 'Fóruns que contêm os elementos a apresentar. Se não selecionares nenhum, serão utilizados todos os fóruns. Podes selecionar quantos quiseres utilizando a tecla <em>Ctrl</em> do teclado.',
	'RECENT_SECTIONS'            => 'Secções',
	'RECENT_SECTIONS_EXPLAIN'    => 'Define as secções a apresentar no bloco e a sua ordem.',
	'RECENT_TOPIC_LIMIT'         => 'Limite de tópicos',
	'RECENT_TOPIC_LIMIT_EXPLAIN' => 'Número máximo de elementos a apresentar em cada separador.',

	// Rss block
	'1_HOUR'  => 'Uma hora',
	'2_HOURS' => 'Duas horas',
	'6_HOURS' => 'Seis horas',

	'RSS_COLLAPSABLE'         => 'Recolhível',
	'RSS_COLLAPSABLE_EXPLAIN' => 'Define se os elementos são apresentados em acordeão ou em deslocamento. Se definido como "Sim", substitui o deslocamento do bloco.',
	'RSS_DIRECTION'           => 'Direção do deslocamento',
	'RSS_DIRECTION_EXPLAIN'   => 'Define a direção do deslocamento do texto. Esta opção é anulada se os elementos forem apresentados em acordeão.',
	'RSS_HEIGHT'              => 'Altura do bloco',
	'RSS_HEIGHT_EXPLAIN'      => 'Define a altura do bloco, em pixels. Só se aplica se os elementos não forem apresentados em formato de acordeão.',
	'RSS_IGNORE_LANG'         => 'Ignorar idioma do feed',
	'RSS_IGNORE_LANG_EXPLAIN' => 'Se ativado, são lidos todos os URLs, independentemente do seu idioma; caso contrário, só serão apresentados os conteúdos escritos no idioma do utilizador.',
	'RSS_LIMIT'               => 'Limite do feed',
	'RSS_LIMIT_EXPLAIN'       => 'Número máximo de elementos a ler de cada URL.',
	'RSS_SOURCES'             => 'Fontes do feed',
	'RSS_TITLE'               => 'Título do feed',
	'RSS_TTL'                 => 'Tempo de atualização',
	'RSS_TTL_EXPLAIN'         => 'Tempo que os elementos permanecerão em cache antes de se tentar ler a fonte novamente.',
	'RSS_URL'                 => 'URL do ficheiro',
	'RSS_URL_EXPLAIN'         => 'Ex: <em>http://omeudominio.com/rss.xml</em>',

	// scroll_message_block
	'MARQUEE_DIRECTION'           => 'Direção do deslocamento',
	'MARQUEE_DIRECTION_EXPLAIN'   => 'Direção do deslocamento do texto. Este atributo controla o sentido do deslocamento.',
	'MARQUEE_SPEED'               => 'Quantidade de deslocamento',
	'MARQUEE_SPEED_EXPLAIN'       => 'Controla a quantidade de movimento (em pixels) entre as apresentações sucessivas que dão a impressão de animação.',
	'MARQUEE_SCROLLDELAY'         => 'Atraso do deslocamento',
	'MARQUEE_SCROLLDELAY_EXPLAIN' => 'Controla o atraso (em milissegundos) entre as apresentações sucessivas que dão a impressão de animação.',
	'MARQUEE_ALIGN'               => 'Alinhamento do deslocamento',
	'MARQUEE_ALIGN_EXPLAIN'       => 'Esta etiqueta controla o posicionamento da caixa de deslocamento em relação ao texto atual, exatamente da mesma forma que o atributo align da etiqueta img.',
	'MARQUEE_BGCOLOR'             => 'Cor de fundo do deslocamento',
	'MARQUEE_BGCOLOR_EXPLAIN'     => 'Esta etiqueta controla a cor de fundo da caixa de apresentação.',
	'MARQUEE_HEIGHT'              => 'Altura do deslocamento',
	'MARQUEE_HEIGHT_EXPLAIN'      => 'Controla a altura da caixa de apresentação.',
	'MARQUEE_PADDING'             => 'Espaçamento da caixa de deslocamento',
	'MARQUEE_PADDING_EXPLAIN'     => 'Espaço em torno da caixa de deslocamento. Este atributo equivale ao atributo "padding" do CSS.',
	'MARQUEE_TEXT'                => 'Texto da mensagem de deslocamento',
	'MARQUEE_TEXT_EXPLAIN'        => 'Adiciona/altera aqui uma mensagem de deslocamento. Limite de 2000 caracteres.<br /><br />São permitidas variáveis de idioma e de template, por exemplo, usa <em>{S_USERNAME}</em> para mostrar o nome do utilizador.',

	'BOTTOM' => 'Inferior',
	'DOWN'   => 'Para baixo',
	'LEFT'   => 'Esquerda',
	'CENTER' => 'Centro',
	'UP'     => 'Para cima',
	'RIGHT'  => 'Direita',
	'TOP'    => 'Superior',

	//share_block
	'SHARE_SHOW_NAMES'         => 'Mostrar nomes',
	'SHARE_SHOW_NAMES_EXPLAIN' => 'Se ativado, o nome da rede social será apresentado junto ao respetivo ícone.',
	'SHARE_URL'                => 'URL de referência',
	'SHARE_URL_EXPLAIN'        => 'Define um URL de referência fixo para os botões. Deixa este campo em branco para utilizar a página apresentada.',
	'SHARE_BUTTONS'            => 'Botões a mostrar',

	// stats_block
	'STATS_INLINE' => 'Mostrar dados em linha',
	'USER_STATS'   => 'Mostrar estatísticas de utilizadores',

	// steam_block
	'STEAM_GROUP_URL'         => 'URL do grupo',
	'STEAM_GROUP_URL_EXPLAIN' => '<em>Ex: https://steamcommunity.com/groups/examplegroup</em>',

	// top_topics_block
	'TOPT_LIMIT'         => 'Limite de tópicos',
	'TOPT_LIMIT_EXPLAIN' => 'Número máximo de tópicos a mostrar.',
	'TOPT_MODE'          => 'Tópicos a mostrar',
	'TOPT_MODE_ACTIVE'   => 'Últimos tópicos mais ativos',
	'TOPT_MODE_UNREAD'   => 'Últimos tópicos não lidos',
	'TOPT_MODE_VIEWED'   => 'Tópicos mais vistos',

	// topic_index_block
	'TINDEX_CHAR_SELECT'         => 'Mostrar índice',
	'TINDEX_CHAR_SELECT_EXPLAIN' => 'Apenas disponível se o método de ordenação for <em>Título do tópico</em>.',
	'TINDEX_PER_PAGE'            => 'Tópicos por página',
	'TINDEX_PER_PAGE_EXPLAIN'    => 'Número de tópicos apresentados ao mesmo tempo. Define 0 para desativar a paginação.',
	'TINDEX_SORT_MODE'           => 'Ordenar por',
	'TINDEX_SORT_MODE_EXPLAIN'   => 'Método que será utilizado para definir a ordem dos tópicos na lista.',

	'TOPIC_TIME'     => 'Data do tópico',
	'LAST_POST_TIME' => 'Data da última mensagem',

	// welcome_block
	'WELCOME_GUEST'          => 'Mensagem para convidados',
	'WELCOME_GUEST_EXPLAIN'  => 'Mensagem a apresentar a todos os convidados. Máximo de 2000 caracteres.<br /><br />São permitidas variáveis de idioma e de template, por exemplo, usa <em>{S_USERNAME}</em> para mostrar o nome do utilizador.',
	'WELCOME_MEMBER'         => 'Mensagem para membros',
	'WELCOME_MEMBER_EXPLAIN' => 'Mensagem a apresentar a todos os utilizadores registados no fórum. Máximo de 2000 caracteres.<br /><br />São permitidas variáveis de idioma e de template, por exemplo, usa <em>{S_USERNAME}</em> para mostrar o nome do utilizador.',

	// whos_online_block
	'WHOS_ADVANCED'          => 'Modo avançado',
	'WHOS_ADVANCED_EXPLAIN'  => 'Se ativado, mostra toda a informação; caso contrário, aparece apenas informação básica (adequado para blocos laterais).',
	'WHOS_USERNAMES'         => 'Mostrar lista de utilizadores',
	'WHOS_USERNAMES_EXPLAIN' => 'Se ativado, mostra a lista de utilizadores online (apenas no modo avançado).',

	// youtube_block
	'YT_AUTOPLAY'               => 'Reprodução automática ativada',
	'YT_AUTOPLAY_EXPLAIN'       => 'Se ativado, o vídeo será reproduzido automaticamente.<br />Se tiveres vários vídeos, apenas o primeiro reproduz automaticamente.',
	'YT_DISPLAY_MODE'           => 'Modo de apresentação',
	'YT_FULL_PREVIEW'           => 'Mostrar miniaturas, título e descrição',
	'YT_LIST'                   => 'Mostrar uma lista com os títulos',
	'YT_RANDOM_DISPLAY'         => 'Apresentação aleatória',
	'YT_RANDOM_DISPLAY_EXPLAIN' => 'Se ativado, apenas um vídeo aparecerá aleatoriamente. Caso contrário, todos os vídeos e canais aparecem de uma vez.',
	'YT_RESULT_LIMIT'           => 'Número de vídeos do canal',
	'YT_RESULT_LIMIT_EXPLAIN'   => 'Número máximo de vídeos carregados em cada canal.',
	'YT_SIMPLE_PREVIEW'         => 'Mostrar miniaturas e títulos',
	'YT_TEXT_LIMIT'             => 'Limite de texto',
	'YT_TEXT_LIMIT_EXPLAIN'     => 'Número máximo de caracteres na descrição do vídeo.',
	'YT_VIDEO_PREVIEW'          => 'Mostrar pré-visualização do vídeo',
	'YT_VIDEO_SIZE'             => 'Tamanho do leitor',
	'YT_VIDEO_TITLE'            => 'Título do vídeo',
	'YT_VIDEO_URL'              => 'URL do vídeo',
	'YT_VIDEO_URL_EXPLAIN'      => 'Ex: <em>https://www.youtube.com/watch?v=NHH_v0k7Gus</em>',
]);
