<?php

/**
 * @package cBB Blockgets for phpBB.
 * @version 2.0.7 01/07/2024
 * @copyright (c) 2024 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 * @translation Leinad4Mind [Brazilian Portuguese [pt_br]] (2026)
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
	'BLOCK_COLLAPSE_EXPLAIN'     => 'Ativa ou desativa a possibilidade de cada usuário recolher/expandir este bloco e define seu estado inicial.',
	'BLOCK_ENABLED'              => 'Bloco ativado',
	'BLOCK_ENABLED_EXPLAIN'      => 'Define se este bloco será exibido no fórum.',
	'BLOCK_CURRENT_ICON'         => 'Ícone do bloco',
	'BLOCK_CURRENT_ICON_EXPLAIN' => 'Ícone atual definido para o bloco.',
	'BLOCK_GROUP'                => 'Grupos',
	'BLOCK_GROUP_EXPLAIN'        => 'Escolha os grupos que podem ver este bloco no fórum.<br />Você pode selecionar vários grupos usando a tecla <em>Ctrl</em> do teclado.',
	'BLOCK_NO_CONFIG'            => 'Este bloco não requer configuração adicional',
	'BLOCK_STYLE'                => 'Aparência do bloco',
	'BLOCK_STYLE_EXPLAIN'        => 'Com esta opção você pode escolher a aparência de cada bloco individualmente. Observe que a forma de exibição depende do estilo instalado no fórum e de sua compatibilidade com a extensão.',
	'BLOCK_TITLE'                => 'Título do bloco',
	'BLOCK_TITLE_EXPLAIN'        => 'Nome exclusivo para o seu bloco.<br />Este título será exibido no bloco.<br />Limite: 100 caracteres.',

	// Common tags
	'ALL_FORUMS'              => 'Todos os fóruns',
	'COLLAPSE_HIDDEN'         => 'Permitir (recolhido por padrão)',
	'COLLAPSE_NONE'           => 'Não permitir',
	'COLLAPSE_VISIBLE'        => 'Permitir (exibido por padrão)',
	'CONFIG'                  => 'Configuração',
	'DESIGN_FULL'             => 'Completo',
	'DESIGN_SIMPLE'           => 'Simples',
	'FORUMS'                  => 'Fóruns',
	'FORUMS_EXPLAIN'          => 'Fóruns que contêm os tópicos a exibir. Você pode selecionar quantos desejar usando a tecla <em>Ctrl</em> do teclado.',
	'IGNORE_AUTH'             => 'Ignorar permissões',
	'IGNORE_AUTH_EXPLAIN'     => 'Se ativado, todo o conteúdo será exibido, ignorando se o usuário tem permissão para visualizá-lo.',
	'NO_LISTS'                => 'Nenhuma lista disponível',
	'SHOW_PAGINATION'         => 'Exibir paginação',
	'SHOW_PAGINATION_EXPLAIN' => 'Exibe a paginação para permitir que o usuário visualize mensagens mais antigas.',
	'TITLE_LIMIT'             => 'Limite do título',
	'TITLE_LIMIT_EXPLAIN'     => 'Número máximo de caracteres que serão exibidos nos títulos dos tópicos.<br />
		<em>Defina 0 para exibir o título completo.</em>',
	'TOPIC_DESIGN'         => 'Design do bloco',
	'TOPIC_DESIGN_EXPLAIN' => 'Determina como os tópicos serão exibidos no bloco.<br />
		<em><strong>Completo:</strong> Exibe todas as informações sempre que possível.</em><br />
		<em><strong>Simples:</strong> Exibe apenas informações básicas.</em>',
	'TOPIC_PARENT_SHOW'         => 'Exibir fórum de origem',
	'TOPIC_PARENT_SHOW_EXPLAIN' => 'Se ativado, será exibido um link para o fórum de cada tópico.',

	// age_ranges_block
	'AGE_START'    => 'Idade mínima',
	'AGE_END'      => 'Idade máxima',
	'AGE_INTERVAL' => 'Intervalo',

	// announcements_block
	'ANN_MAX_NUMBER'           => 'Número de anúncios',
	'ANN_MAX_NUMBER_EXPLAIN'   => 'Número máximo de anúncios que serão exibidos dentro do bloco.',
	'ANN_MAX_SIZE'             => 'Tamanho do anúncio',
	'ANN_MAX_SIZE_EXPLAIN'     => 'Tamanho máximo de caracteres permitido nos anúncios. O texto será cortado se esse valor for excedido.',
	'ANN_SHOW_GLOBALS'         => 'Exibir anúncios globais',
	'ANN_SHOW_GLOBALS_EXPLAIN' => 'Se ativado, também serão lidos os itens marcados como "globais"; caso contrário, apenas os anúncios simples serão lidos.',
	'ANN_COLLAPSE'             => 'Recolher anúncios',
	'ANN_COLLAPSE_EXPLAIN'     => 'Se ativado, o bloco exibirá apenas um anúncio e recolherá os demais. Caso contrário, os anúncios aparecerão todos de uma vez no bloco.',

	// attachments_block
	'ATTACH_FORUM'             => 'Anexos do fórum',
	'ATTACH_FORUM_EXPLAIN'     => 'Se especificado, apenas os anexos deste fórum serão exibidos, ignorando os demais.<br />O fórum deve conter diretamente o tópico onde está o anexo; as categorias ou fóruns acima são ignorados aqui.',
	'ATTACH_EXTENSION'         => 'Extensões de anexo',
	'ATTACH_EXTENSION_EXPLAIN' => 'Se especificado, todos os anexos que não contiverem estas extensões serão ignorados.<br />Separe as extensões com ",".<br />Ex. extensões válidas: jpg,png,gif...',
	'ATTACH_NUM'               => 'Número de anexos',
	'ATTACH_NUM_EXPLAIN'       => 'Número máximo de anexos exibidos simultaneamente no bloco.',
	'ATTACH_SPECIFIC'          => 'Anexo específico',
	'ATTACH_SPECIFIC_EXPLAIN'  => 'Se especificado, apenas o anexo com o nome indicado será exibido no bloco. O campo deve conter o nome original do arquivo do anexo, Ex: meuarquivo.jpg<br /><br /><strong>Nota:</strong> este campo substitui os demais campos.',

	// banners_block, banners_multiple_block
	'BANNERS_TITLE'           => 'Título do banner',
	'BANNERS_TITLE_EXPLAIN'   => 'Se ativado, o título será exibido abaixo dos banners no bloco.',
	'BANNERS_LS_TYPE'         => 'Tipo de lista',
	'BANNERS_LS_TYPE_EXPLAIN' => 'Define como os banners serão exibidos.<br />Pode ser definida uma rolagem horizontal, vertical ou permanecer fixa.',
	'BANNERS_NUMBER'          => 'Banners a exibir',
	'BANNERS_NUMBER_EXPLAIN'  => 'Número máximo de banners a exibir no bloco.<br />
		<em>Defina 0 para exibir toda a lista.</em>',
	'BANNERS_RANDOM'           => 'Ordem aleatória',
	'BANNERS_RANDOM_EXPLAIN'   => 'Define se os elementos serão exibidos na ordem da lista ou em ordem aleatória.',
	'LIST_NO_SCROLL'           => 'Sem rolagem',
	'LIST_SCROLL_H'            => 'Rolagem horizontal',
	'LIST_SCROLL_V'            => 'Rolagem vertical',
	'BANNERS_B_HEIGHT'         => 'Altura do bloco',
	'BANNERS_B_HEIGHT_EXPLAIN' => 'Informe a altura do bloco que será usada para rolar as listas.',

	// birthdays_block
	'NEXT_BIRTHDAYS'         => 'Próximos aniversários',
	'NEXT_BIRTHDAYS_EXPLAIN' => 'Exibe os aniversários que ocorrem nos próximos dias.<br />
 		<em>Máximo de 30 dias. Defina 0 para desativar.</em>',

	// calendar_block
	'CALENDAR_EVENTS'         => 'Exibir eventos',
	'CALENDAR_EVENTS_EXPLAIN' => 'Se ativado, os eventos serão marcados e exibidos no calendário.',
	'CALENDAR_MONTHS'         => 'Meses a exibir',
	'CALENDAR_MONTHS_EXPLAIN' => 'Número de meses a serem exibidos simultaneamente no bloco.',

	// contact block
	'CONTACT_CHECK_EMAIL'         => 'Verificar e-mail',
	'CONTACT_CHECK_EMAIL_EXPLAIN' => 'Se ativado, o domínio do e-mail do usuário será verificado e validado.',
	'CONTACT_EMAIL'               => 'E-mail de destino',
	'CONTACT_HIDE_FIELDS'         => 'Ocultar dados do usuário',
	'CONTACT_HIDE_FIELDS_EXPLAIN' => 'Se ativado, os campos "Nome" e "E-mail" para os usuários registrados ficarão ocultos e o bloco usará os valores do perfil.',

	// countdown block
	'COUNTDOWN_COMPLETE_MSG'         => 'Texto ao concluir',
	'COUNTDOWN_COMPLETE_MSG_EXPLAIN' => 'Texto a ser exibido quando o contador chegar a 0.',
	'COUNTDOWN_TARGET'               => 'Prazo final',
	'COUNTDOWN_TARGET_EXPLAIN'       => 'Define a data e hora em que o contador chegará a 0.<br /><br />
		<em><strong>Formatos válidos</strong>
			<br />Ano/Mês/Dia
			<br />Ano/Mês/Dia Hora:Minuto:Segundo
		</em>',
	'COUNTDOWN_RUNNING_MSG'         => 'Texto em andamento',
	'COUNTDOWN_RUNNING_MSG_EXPLAIN' => 'Texto a ser exibido enquanto o contador está em andamento.',

	// counter block
	'COUNTER_LOCAL'         => 'Contador local',
	'COUNTER_LOCAL_EXPLAIN' => 'Se ativado, o contador exibirá apenas as visitas à sua página; caso contrário, o contador exibirá o total de visitas ao fórum.',

	// empty_block
	'BLOCK_CONTENT'         => 'Conteúdo do bloco',
	'BLOCK_CONTENT_EXPLAIN' => 'Conteúdo a ser exibido no bloco.<br />Limite: 8000 caracteres.<br /><br />São permitidas variáveis de idioma e de template, por exemplo, use <em>{S_USERNAME}</em> para exibir o nome do usuário.',

	// clock_block
	'DISPLAY_CLOCK'         => 'Relógio a exibir',
	'DISPLAY_CLOCK_EXPLAIN' => 'Relógio exibido no bloco.',
	'PREVIEW_CLOCK'         => 'Pré-visualização',
	'PREVIEW_CLOCK_EXPLAIN' => 'Pré-visualização do relógio selecionado.',

	// cloud_tags_block
	'CLOUD_ANIMATION'         => 'Animação ativada',
	'CLOUD_ANIMATION_EXPLAIN' => 'Se ativado, as palavras "tags" aparecem em uma nuvem animada; caso contrário, aparecem como palavras fixas no bloco.',
	'CLOUD_MODE'              => 'Tipo de palavras',
	'CLOUD_MODE_EXPLAIN'      => 'Especifica quais palavras serão exibidas no bloco.',
	'CLOUD_WORDS'             => 'Número de palavras',
	'CLOUD_WORDS_EXPLAIN'     => 'Número máximo de palavras que aparecem no bloco.',
	'MODE_SEARCH'             => 'Últimas palavras pesquisadas',
	'MODE_USERS'              => 'Usuários com mais mensagens',

	// forums block
	'FORUMS_FORUM' => 'Fórum a exibir',

	// frame_block
	'MIME_HTML'  => 'Página Web',
	'MIME_PDF'   => 'Arquivo PDF',
	'MIME_PLAIN' => 'Arquivo de texto simples',

	'FRAME_HEIGHT'           => 'Altura do frame',
	'FRAME_HEIGHT_EXPLAIN'   => 'Altura do frame em pixels. Defina 0 para ajuste automático.',
	'FRAME_MIMETYPE'         => 'Tipo de documento',
	'FRAME_MIMETYPE_EXPLAIN' => 'O tipo de documento exibido no frame.',
	'FRAME_URL'              => 'URL do documento',
	'FRAME_URL_EXPLAIN'      => 'URL do documento ou página exibido no frame.',
	'FRAME_WIDTH'            => 'Largura do frame',
	'FRAME_WIDTH_EXPLAIN'    => 'Largura do frame em pixels. Defina 0 para ajuste automático.',

	// gallery_block
	'GALLERY_CUSTOM'             => 'Imagens personalizadas',
	'GALLERY_CUSTOM_EXPLAIN'     => 'Especifique a lista contendo as imagens a serem exibidas.',
	'GALLERY_DIRECTION'          => 'Direção da rolagem',
	'GALLERY_FORUMS'             => 'Fóruns',
	'GALLERY_FORUMS_EXPLAIN'     => 'Define os fóruns dos quais os anexos serão lidos.',
	'GALLERY_FPS'                => 'Velocidade de rolagem',
	'GALLERY_HEIGHT'             => 'Altura da galeria',
	'GALLERY_MANAGE'             => 'Gerenciar galeria',
	'GALLERY_MARGIN'             => 'Margem da imagem',
	'GALLERY_MAX_NUMBER'         => 'Número de imagens',
	'GALLERY_MAX_NUMBER_EXPLAIN' => 'Número máximo de anexos que serão lidos dos fóruns/tópicos/mensagens',
	'GALLERY_ORDER'              => 'Ordem de tópicos/mensagens',
	'GALLERY_ORDER_EXPLAIN'      => 'Define a ordem em que os tópicos ou mensagens do fórum serão carregados.',
	'GALLERY_POSTS'              => 'Mensagens',
	'GALLERY_POSTS_EXPLAIN'      => 'IDs das mensagens para ler os anexos, separados por vírgulas. (Ex: 1,2,3).',
	'GALLERY_SOURCE'             => 'Origem das imagens',
	'GALLERY_SOURCE_EXPLAIN'     => 'Define que tipo de imagens serão carregadas dos fóruns, tópicos ou mensagens especificados.',
	'GALLERY_TOPICS'             => 'Tópicos',
	'GALLERY_TOPICS_EXPLAIN'     => 'IDs dos tópicos para ler os anexos, separados por vírgulas. (Ex: 1,2,3).',
	'GALLERY_ZOOM'               => 'Zoom',
	'GALLERY_ZOOM_EXPLAIN'       => 'Diferença de tamanho ao passar o mouse sobre a imagem (em pixels)',

	'GALLERY_ORDER_LAST' => 'Mais recente primeiro',
	'GALLERY_ORDER_RAND' => 'Aleatório',

	'GALLERY_SOURCE_ALL'         => 'Todas',
	'GALLERY_SOURCE_ATTACHMENTS' => 'Somente anexos',
	'GALLERY_SOURCE_IMAGES'      => 'Somente imagens incorporadas',

	'IMG_TITLE'       => 'Título da imagem',
	'IMG_URL'         => 'URL da imagem',
	'IMG_URL_EXPLAIN' => 'URL de uma imagem JPG, GIF ou PNG. Ex:http://meudominio.com/imagem.jpg',

	// google_translate_block
	'GOOGLE_LANGS'              => 'Idiomas a exibir no bloco',
	'GOOGLE_SHOW_NAMES'         => 'Exibir nomes',
	'GOOGLE_SHOW_NAMES_EXPLAIN' => 'Se ativado, o nome do idioma será exibido ao lado de sua bandeira.',

	// latest_bots_block
	'BOTS_NUMBER'         => 'Bots a exibir',
	'BOTS_NUMBER_EXPLAIN' => 'Número máximo de bots da última visita que serão exibidos no bloco.',

	// latest_members_block
	'MEMBERS_NUMBER'         => 'Usuários a exibir',
	'MEMBERS_NUMBER_EXPLAIN' => 'Número máximo de usuários que serão exibidos no bloco.',

	// leaders_block
	'LEADERS_ALL_GROUPS'         => 'Exibir usuários em todos os seus grupos',
	'LEADERS_ALL_GROUPS_EXPLAIN' => 'Se ativado, os usuários serão exibidos em todos os grupos dos quais são membros.
		Caso contrário, serão exibidos apenas em seu grupo padrão.',
	'LEADERS_GROUPS'              => 'Grupos',
	'LEADERS_GROUPS_EXPLAIN'      => 'Grupos que serão exibidos no bloco. Se você não selecionar grupos, o bloco exibirá os Administradores e Moderadores.',
	'LEADERS_MODE'                => 'Modo de exibição',
	'LEADERS_MODE_ACCORDION'      => 'Acordeão',
	'LEADERS_MODE_SIMPLE'         => 'Lista simples',
	'LEADERS_ONLY_ONLINE'         => 'Somente usuários online',
	'LEADERS_ONLY_ONLINE_EXPLAIN' => 'Se ativado, somente os usuários dos grupos selecionados que estiverem conectados serão exibidos.',

	// link_us_block
	'US_BANNER'         => 'Link do mini banner',
	'US_BANNER_EXPLAIN' => 'Mini banner que será a imagem na qual é preciso clicar para acessar o fórum a partir do link.',

	// Login Block
	'ALT_LOGIN'             => 'Exibir métodos alternativos',
	'ALT_LOGIN_EXPLAIN'     => 'Ativa/desativa a exibição de métodos alternativos de identificação.<br /><em>Ex: Oauth</em>',
	'FULL_LOGIN'            => 'Exibir login completo',
	'FULL_LOGIN_EXPLAIN'    => 'Ativa/desativa as opções avançadas na identificação do usuário.',
	'SHOW_REGISTER'         => 'Exibir registro',
	'SHOW_REGISTER_EXPLAIN' => 'Opção de exibição para o registro de usuário.',

	// map_block
	'LATITUDE'                  => 'Latitude',
	'LONGITUDE'                 => 'Longitude',
	'LOCATION_ADD'              => 'Adicionar localização',
	'LOCATION_EDIT'             => 'Editar localização',
	'LOCATION_IMAGE'            => 'Imagem',
	'LOCATION_IMAGE_EXPLAIN'    => 'Imagem que marcará o ponto no mapa.<br /><em>Se você não definir nenhuma, a marcação padrão será usada</em>.',
	'LOCATION_INCORRECT'        => 'A posição informada está incorreta.',
	'LOCATION_POSITION'         => 'Posição',
	'LOCATION_POSITION_EXPLAIN' => 'Define a latitude e a longitude da localização.',
	'LOCATION_TEXT'             => 'Conteúdo',
	'LOCATION_TEXT_EXPLAIN'     => 'Texto a ser exibido no mapa, ao clicar no ícone de localização.<br /><em>É permitido o uso de BBCode.</em>',
	'LOCATION_TITLE'            => 'Título',
	'MAP'                       => 'Mapa',
	'MAP_CENTER'                => 'Ponto central',
	'MAP_CENTER_EXPLAIN'        => 'Define a latitude e a longitude do ponto central padrão.',
	'MAP_LOCATIONS'             => 'Localizações',
	'MAP_ZOOM'                  => 'Zoom',
	'MAP_ZOOM_EXPLAIN'          => 'Define o zoom padrão.',
	'SEARCH_ADDRESS'            => 'Pesquisar localização',
	'SELECT_LOCATION'           => 'Selecionar localização',

	// menu_block
	'ICON_WIDTH'         => 'Largura do ícone',
	'ICON_WIDTH_EXPLAIN' => 'A largura dos ícones do bloco, em pixels.',

	// most_poster_block
	'POSTER_LIMIT'         => 'Limite de usuários',
	'POSTER_LIMIT_EXPLAIN' => 'O limite de usuários exibidos no bloco.',
	'POST_RANGE'           => 'Intervalo de mensagens',
	'POST_RANGE_EXPLAIN'   => 'Limite de tempo para a contagem de mensagens.',

	'ALL_POSTS'  => 'Todas as mensagens',
	'LAST_DAY'   => 'Último dia',
	'LAST_WEEK'  => 'Última semana',
	'LAST_MONTH' => 'Último mês',
	'LAST_YEAR'  => 'Último ano',

	// news_block
	'NEWS_DISPLAY'         => 'Informações a exibir',
	'NEWS_DISPLAY_EXPLAIN' => '<em><strong>Conteúdo básico:</strong>Exibe título, autor e data.<br />
		<strong>Conteúdo completo:</strong>Exibe todas as informações da notícia.</em>',
	'NEWS_NUMBER'           => 'Número de notícias',
	'NEWS_NUMBER_EXPLAIN'   => 'Número máximo de notícias exibidas no bloco.',
	'NEWS_SIZE'             => 'Tamanho da notícia',
	'NEWS_SIZE_EXPLAIN'     => 'Tamanho máximo de caracteres permitido nas notícias. O texto da notícia será cortado se esse valor for excedido.',
	'NEWS_ALL'              => 'Exibir todos os tópicos',
	'NEWS_ALL_EXPLAIN'      => 'Se ativado, também serão lidos os itens marcados como "anúncio" e "fixo"; caso contrário, apenas os tópicos "normais" serão lidos.',
	'NEWS_COLLAPSE'         => 'Recolher notícias',
	'NEWS_COLLAPSE_EXPLAIN' => 'Se ativado, o bloco exibirá apenas uma notícia e recolherá as demais. Caso contrário, as notícias aparecerão todas de uma vez no bloco.',
	'NEWS_SHOW_FULL'        => 'Conteúdo completo',
	'NEWS_SHOW_SIMPLE'      => 'Conteúdo básico',

	// paypal_block
	'PAYPAL_ACCOUNT'            => 'Conta do Paypal',
	'PAYPAL_ACCOUNT_EXPLAIN'    => 'Informe o endereço de e-mail da sua conta Paypal ex: xxx@xxx.com',
	'PAYPAL_ITEM'               => 'Descrição do pagamento',
	'PAYPAL_ITEM_EXPLAIN'       => 'Informe o nome (descrição) pelo qual os pagamentos serão identificados através do bloco.',
	'PAYPAL_MSG'                => 'Mensagem',
	'PAYPAL_MSG_EXPLAIN'        => 'Mensagem personalizável que aparecerá no bloco.<br />São permitidas variáveis de idioma e de template, por exemplo, use <em>{S_USERNAME}</em> para exibir o nome do usuário.',
	'PAYPAL_IMG'                => 'Imagem do botão',
	'PAYPAL_IMG_EXPLAIN'        => 'Imagem a ser usada para o botão "doar". Deixe este campo em branco para usar a imagem padrão.',
	'PAYPAL_AMOUNTS'            => 'Valores',
	'PAYPAL_AMOUNTS_EXPLAIN'    => 'Valor em dinheiro no seletor. Separe os valores com ";" (Ex: 5;10;15).',
	'PAYPAL_CURRENCIES'         => 'Moedas',
	'PAYPAL_CURRENCIES_EXPLAIN' => 'Tipo de moeda que será exibida no bloco. Você pode selecionar mais de uma e definir a moeda padrão.',

	//player block
	'PLAYER_AUTOPLAY'         => 'Reprodução automática',
	'PLAYER_AUTOPLAY_EXPLAIN' => 'Define se o player iniciará a reprodução das faixas automaticamente ao carregar a página.<br /><br />
		<em><strong>Nota:</strong>Os navegadores limitam este recurso, portanto a reprodução não começará até que o usuário clique em qualquer lugar da página.</em>',
	'PLAYER_PLAYLIST'          => 'Exibir playlist',
	'PLAYER_PLAYLIST_EXPLAIN'  => 'Define se a playlist é exibida no player.',
	'PLAYER_TRACKLIST'         => 'Lista de faixas',
	'PLAYER_TRACKLIST_EXPLAIN' => 'As faixas ou músicas do player.',

	'TRACK_TITLE'         => 'Título da faixa',
	'TRACK_TITLE_EXPLAIN' => 'O nome ou título exibido no player.',
	'TRACK_URL'           => 'URL da faixa',
	'TRACK_URL_EXPLAIN'   => 'Uma URL de rádio (Ex: http://127.0.0.1:8888), um arquivo de áudio mp3 ou wav (Ex: http://meuservidor.com/audio.mp3) ou um arquivo de playlist válido (m3u, asx, pls).',

	// poll_block
	'DISPLAY_POLL'         => 'Enquete a exibir',
	'DISPLAY_POLL_EXPLAIN' => 'Enquete exibida no bloco.',
	'DISPLAY_RESULTS'      => 'Exibir resultados',
	'NO_POLLS'             => 'Nenhuma enquete disponível',

	// poll_random_block
	'POLL_FORUM'         => 'Fórum de enquetes',
	'POLL_FORUM_EXPLAIN' => 'Fórum que contém as enquetes exibidas no bloco.',
	'POLL_NUM'           => 'Número de enquetes',
	'POLL_NUM_EXPLAIN'   => 'O número de enquetes que serão exibidas de uma vez dentro do bloco.',
	'NO_FORUMS'          => 'Nenhum fórum disponível',

	// post_view_block
	'PV_ITEM_URL'         => 'URL de referência',
	'PV_ITEM_URL_EXPLAIN' => 'Informe aqui a URL do fórum, tópico ou mensagem que deseja exibir.<br />
		<em><strong>Nota:</strong> A URL de um fórum ou tópico exibirá sua última mensagem.</em>',

	// quote_of_day_block
	'QUOTE_AUTHOR'               => 'Autor da citação',
	'QUOTE_TEXT'                 => 'Texto da citação',
	'QUOTES_ALL_DAY'             => 'Manter o dia todo',
	'QUOTES_ALL_DAY_EXPLAIN'     => 'Se ativado, você verá a mesma citação o dia todo. Caso contrário, a cada carregamento da página você verá uma citação diferente.',
	'QUOTES_LIST'                => 'Lista de citações',
	'QUOTES_RAND'                => 'Ordem aleatória',
	'QUOTES_RAND_EXPLAIN'        => 'Define se as citações são exibidas em ordem aleatória ou mantendo a ordem da lista.',
	'QUOTES_SHOW_AUTHOR'         => 'Exibir autor',
	'QUOTES_SHOW_AUTHOR_EXPLAIN' => 'Define se o autor da citação será exibido no bloco.',

	// ranks_block
	'ORPHAN_RANKS'         => 'Exibir classificações órfãs',
	'ORPHAN_RANKS_EXPLAIN' => 'Se ativado, serão exibidas as classificações que não estão atribuídas a nenhum usuário.',
	'ONLY_SPECIAL_RANKS'   => 'Somente classificações especiais',

	// recent_topics_block
	'RECENT_FORUMS'              => 'Fóruns de tópicos',
	'RECENT_FORUMS_EXPLAIN'      => 'Fóruns que contêm os itens a serem exibidos. Se você não selecionar nenhum, todos os fóruns serão usados. Você pode selecionar quantos desejar usando a tecla <em>Ctrl</em> do teclado.',
	'RECENT_SECTIONS'            => 'Seções',
	'RECENT_SECTIONS_EXPLAIN'    => 'Define as seções a serem exibidas no bloco e sua ordem.',
	'RECENT_TOPIC_LIMIT'         => 'Limite de tópicos',
	'RECENT_TOPIC_LIMIT_EXPLAIN' => 'Número máximo de itens a serem exibidos em cada aba.',

	// Rss block
	'1_HOUR'  => 'Uma hora',
	'2_HOURS' => 'Duas horas',
	'6_HOURS' => 'Seis horas',

	'RSS_COLLAPSABLE'         => 'Recolhível',
	'RSS_COLLAPSABLE_EXPLAIN' => 'Define se os itens serão exibidos em acordeão ou em rolagem. Se definido como "Sim", substituirá a rolagem do bloco.',
	'RSS_DIRECTION'           => 'Direção da rolagem',
	'RSS_DIRECTION_EXPLAIN'   => 'Define a direção da rolagem do texto. Esta opção é cancelada se os itens forem exibidos em acordeão.',
	'RSS_HEIGHT'              => 'Altura do bloco',
	'RSS_HEIGHT_EXPLAIN'      => 'Define a altura do bloco, em pixels. Aplica-se apenas se os itens não forem exibidos em formato de acordeão.',
	'RSS_IGNORE_LANG'         => 'Ignorar idioma do feed',
	'RSS_IGNORE_LANG_EXPLAIN' => 'Se ativado, todas as URLs serão lidas, independentemente de seu idioma; caso contrário, serão exibidos apenas os conteúdos escritos no idioma do usuário.',
	'RSS_LIMIT'               => 'Limite do feed',
	'RSS_LIMIT_EXPLAIN'       => 'Número máximo de itens a serem lidos de cada URL.',
	'RSS_SOURCES'             => 'Fontes do feed',
	'RSS_TITLE'               => 'Título do feed',
	'RSS_TTL'                 => 'Tempo de atualização',
	'RSS_TTL_EXPLAIN'         => 'Tempo que os itens permanecerão em cache antes de tentar ler a fonte novamente.',
	'RSS_URL'                 => 'URL do arquivo',
	'RSS_URL_EXPLAIN'         => 'Ex: <em>http://meudominio.com/rss.xml</em>',

	// scroll_message_block
	'MARQUEE_DIRECTION'           => 'Direção da rolagem',
	'MARQUEE_DIRECTION_EXPLAIN'   => 'Direção da rolagem do texto. Este atributo controla a direção da rolagem.',
	'MARQUEE_SPEED'               => 'Quantidade de rolagem',
	'MARQUEE_SPEED_EXPLAIN'       => 'Controla a quantidade de movimento (em pixels) entre as exibições sucessivas que causam a impressão de animação.',
	'MARQUEE_SCROLLDELAY'         => 'Atraso da rolagem',
	'MARQUEE_SCROLLDELAY_EXPLAIN' => 'Controla o atraso (em milissegundos) entre as exibições sucessivas que causam a impressão de animação.',
	'MARQUEE_ALIGN'               => 'Alinhamento da rolagem',
	'MARQUEE_ALIGN_EXPLAIN'       => 'Esta tag controla o posicionamento da caixa de exibição do letreiro em relação ao texto atual, exatamente da mesma forma que o atributo align da tag img.',
	'MARQUEE_BGCOLOR'             => 'Cor de fundo da rolagem',
	'MARQUEE_BGCOLOR_EXPLAIN'     => 'Esta tag controla a cor de fundo da caixa de exibição.',
	'MARQUEE_HEIGHT'              => 'Altura da rolagem',
	'MARQUEE_HEIGHT_EXPLAIN'      => 'Controla a altura da caixa de exibição.',
	'MARQUEE_PADDING'             => 'Espaçamento da caixa de rolagem',
	'MARQUEE_PADDING_EXPLAIN'     => 'Espaço ao redor da caixa de rolagem. Este atributo equivale ao atributo "padding" do CSS.',
	'MARQUEE_TEXT'                => 'Texto da mensagem em rolagem',
	'MARQUEE_TEXT_EXPLAIN'        => 'Adicione/altere aqui uma mensagem em rolagem. Limite de 2000 caracteres.<br /><br />São permitidas variáveis de idioma e de template, por exemplo, use <em>{S_USERNAME}</em> para exibir o nome do usuário.',

	'BOTTOM' => 'Inferior',
	'DOWN'   => 'Para baixo',
	'LEFT'   => 'Esquerda',
	'CENTER' => 'Centro',
	'UP'     => 'Para cima',
	'RIGHT'  => 'Direita',
	'TOP'    => 'Superior',

	//share_block
	'SHARE_SHOW_NAMES'         => 'Exibir nomes',
	'SHARE_SHOW_NAMES_EXPLAIN' => 'Se ativado, o nome da rede social será exibido ao lado de seu ícone.',
	'SHARE_URL'                => 'URL de referência',
	'SHARE_URL_EXPLAIN'        => 'Define uma URL de referência fixa para os botões. Deixe este campo em branco para usar a página exibida.',
	'SHARE_BUTTONS'            => 'Botões a exibir',

	// stats_block
	'STATS_INLINE' => 'Exibir dados em linha',
	'USER_STATS'   => 'Exibir estatísticas do usuário',

	// steam_block
	'STEAM_GROUP_URL'         => 'URL do grupo',
	'STEAM_GROUP_URL_EXPLAIN' => '<em>Ex: https://steamcommunity.com/groups/examplegroup</em>',

	// top_topics_block
	'TOPT_LIMIT'         => 'Limite de tópicos',
	'TOPT_LIMIT_EXPLAIN' => 'Número máximo de tópicos a exibir.',
	'TOPT_MODE'          => 'Tópicos a exibir',
	'TOPT_MODE_ACTIVE'   => 'Últimos tópicos mais ativos',
	'TOPT_MODE_UNREAD'   => 'Últimos tópicos não lidos',
	'TOPT_MODE_VIEWED'   => 'Tópicos mais visualizados',

	// topic_index_block
	'TINDEX_CHAR_SELECT'         => 'Exibir índice',
	'TINDEX_CHAR_SELECT_EXPLAIN' => 'Disponível apenas se o método de ordenação for <em>Título do tópico</em>.',
	'TINDEX_PER_PAGE'            => 'Tópicos por página',
	'TINDEX_PER_PAGE_EXPLAIN'    => 'Número de tópicos que serão exibidos ao mesmo tempo. Defina 0 para desativar a paginação.',
	'TINDEX_SORT_MODE'           => 'Ordenar por',
	'TINDEX_SORT_MODE_EXPLAIN'   => 'Método que será usado para definir a ordem dos tópicos na lista.',

	'TOPIC_TIME'     => 'Data do tópico',
	'LAST_POST_TIME' => 'Data da última mensagem',

	// welcome_block
	'WELCOME_GUEST'          => 'Mensagem para visitantes',
	'WELCOME_GUEST_EXPLAIN'  => 'Mensagem a ser exibida a todos os visitantes. Máximo de 2000 caracteres.<br /><br />São permitidas variáveis de idioma e de template, por exemplo, use <em>{S_USERNAME}</em> para exibir o nome do usuário.',
	'WELCOME_MEMBER'         => 'Mensagem para membros',
	'WELCOME_MEMBER_EXPLAIN' => 'Mensagem a ser exibida a todos os usuários registrados do fórum. Máximo de 2000 caracteres.<br /><br />São permitidas variáveis de idioma e de template, por exemplo, use <em>{S_USERNAME}</em> para exibir o nome do usuário.',

	// whos_online_block
	'WHOS_ADVANCED'          => 'Modo avançado',
	'WHOS_ADVANCED_EXPLAIN'  => 'Se ativado, exibirá todas as informações; caso contrário, aparecerão apenas informações básicas (adequado para blocos laterais).',
	'WHOS_USERNAMES'         => 'Exibir lista de usuários',
	'WHOS_USERNAMES_EXPLAIN' => 'Se ativado, exibe a lista de usuários online (somente no modo avançado).',

	// youtube_block
	'YT_AUTOPLAY'               => 'Reprodução automática ativada',
	'YT_AUTOPLAY_EXPLAIN'       => 'Se ativado, o vídeo será reproduzido automaticamente.<br />Se houver vários vídeos, apenas o primeiro reproduzirá automaticamente.',
	'YT_DISPLAY_MODE'           => 'Modo de exibição',
	'YT_FULL_PREVIEW'           => 'Exibir miniaturas, título e descrição',
	'YT_LIST'                   => 'Exibir uma lista com títulos',
	'YT_RANDOM_DISPLAY'         => 'Exibição aleatória',
	'YT_RANDOM_DISPLAY_EXPLAIN' => 'Se ativado, apenas um vídeo aparecerá aleatoriamente. Caso contrário, todos os vídeos e canais aparecem de uma vez.',
	'YT_RESULT_LIMIT'           => 'Número de vídeos do canal',
	'YT_RESULT_LIMIT_EXPLAIN'   => 'Número máximo de vídeos carregados em cada canal.',
	'YT_SIMPLE_PREVIEW'         => 'Exibir miniaturas e títulos',
	'YT_TEXT_LIMIT'             => 'Limite de texto',
	'YT_TEXT_LIMIT_EXPLAIN'     => 'Número máximo de caracteres na descrição do vídeo.',
	'YT_VIDEO_PREVIEW'          => 'Exibir pré-visualização do vídeo',
	'YT_VIDEO_SIZE'             => 'Tamanho do player',
	'YT_VIDEO_TITLE'            => 'Título do vídeo',
	'YT_VIDEO_URL'              => 'URL do vídeo',
	'YT_VIDEO_URL_EXPLAIN'      => 'Ex: <em>https://www.youtube.com/watch?v=NHH_v0k7Gus</em>',
]);
