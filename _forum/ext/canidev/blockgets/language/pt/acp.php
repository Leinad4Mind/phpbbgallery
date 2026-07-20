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

// @acp_blockgets
$lang = array_merge($lang, [
	'BLG_CONFIG_TITLE'     => 'Configuração geral',
	'BLG_CONFIG_EXPLAIN'   => 'Obrigado por escolheres o cBB Blockgets como complemento para o teu fórum!<br />Aqui podes definir as configurações principais da extensão.<br />Os links laterais permitem-te aceder a todas as opções para configurares a extensão comodamente.',
	'BLG_IMAGES_TITLE'     => 'Imagens disponíveis',
	'BLG_OPTIONAL_TITLE'   => 'Configuração adicional',
	'BLG_OPTIONAL_EXPLAIN' => 'Aqui podes definir configurações adicionais para o site.',

	'BLG_ADMIN_BAR'             => 'Mostrar barra de acesso rápido',
	'BLG_ADMIN_BAR_EXPLAIN'     => 'Se ativado, será apresentada uma barra no topo do fórum que te permite aceder rapidamente às opções da página onde estás.',
	'BLG_BLOCK_AUTOFIT'         => 'Blocos com ajuste automático',
	'BLG_BLOCK_AUTOFIT_EXPLAIN' => 'Se ativado, o conteúdo e a disposição dos blocos serão ajustados à coluna.',
	'BLG_COLLAPSE'              => 'Permitir recolher blocos',
	'BLG_COLLAPSE_EXPLAIN'      => 'Ativa/desativa globalmente a possibilidade de cada utilizador recolher/expandir os blocos individualmente. Esta opção substitui a configuração individual do bloco.',
	'BLG_FULL_EDITOR'           => 'Editor completo',
	'BLG_ON_BOARD'              => 'Blocos dentro do fórum',
	'BLG_ON_BOARD_EXPLAIN'      => 'Define se os blocos são apresentados nas páginas do fórum. Esta opção substitui a configuração individual da página.<br /><br />
		<em>
			&nbsp;&nbsp;<strong>Não mostrar:</strong> Não mostra blocos em nenhuma página.<br />
			&nbsp;&nbsp;<strong>Páginas individuais:</strong> Mostra os blocos nas páginas configuradas para tal.<br />
			&nbsp;&nbsp;<strong>Páginas iguais:</strong> Os blocos do "Índice Geral" são mostrados em todas as páginas.
		</em>',

	'BLG_REDIRECTIONS'            => 'Redirecionamentos',
	'BLG_REDIRECT_404'            => 'Página não encontrada',
	'BLG_REDIRECT_404_EXPLAIN'    => 'Define a página para a qual o utilizador será encaminhado ao tentar aceder a uma localização que não existe.<br />
		<em>Substitui a mensagem No route found for "GET" do phpBB.</em>',
	'BLG_REDIRECT_LOGIN'          => 'Início de sessão',
	'BLG_REDIRECT_LOGIN_EXPLAIN'  => 'Define a página para a qual o utilizador será encaminhado depois de iniciar sessão no fórum.',
	'BLG_REDIRECT_LOGOUT'         => 'Fim de sessão',
	'BLG_REDIRECT_LOGOUT_EXPLAIN' => 'Define a página para a qual o utilizador será encaminhado ao terminar a sessão.',

	'DEFAULT'              => 'Por defeito',
	'LINKS'                => 'Links',
	'OPEN_GALLERY'         => 'Abrir galeria',
	'SAVE_AND_ADD'         => 'Guardar e adicionar mais',
	'TYPE_DOMAIN_HOME'     => 'Página principal do domínio',
	'TYPE_FORUM_HOME'      => 'Página principal do fórum',
	'TYPE_FORUM_SECONDARY' => 'Página secundária do fórum',

	'BOARD_BLOCK_INDIVIDUAL' => 'Páginas individuais',
	'BOARD_BLOCK_NONE'       => 'Não mostrar',
	'BOARD_BLOCK_SAME'       => 'Páginas iguais',

	'AVATAR_RESIZE_WIDTH'         => 'Tamanho dos avatares',
	'AVATAR_RESIZE_WIDTH_EXPLAIN' => 'Tamanho máximo permitido (em pixels) para os avatares.<br />
		<em>Define 0 para desativar o redimensionamento de avatares</em>.',
	'CALENDAR_ENABLED'            => 'Calendário ativado',
	'CALENDAR_ENABLED_EXPLAIN'    => 'Define se o calendário estará disponível tanto no <em>caminho /calendar</em> como nos blocos.',
	'CALENDAR_BIRTHDAYS'          => 'Mostrar aniversários',
	'CALENDAR_BIRTHDAYS_EXPLAIN'  => 'Se ativado, os aniversários dos utilizadores serão assinalados e apresentados no calendário, como se fossem eventos.',
	'CALENDAR_LINK'               => 'Link',
	'CALENDAR_LINK_EXPLAIN'       => 'Define em que parte do fórum aparecerá um link para o calendário.',
	'CALENDAR_FIRST_DAY'          => 'Primeiro dia da semana',
	'CALENDAR_FIRST_DAY_EXPLAIN'  => 'Define o primeiro dia da semana no calendário.',
	'COUNTER'                     => 'Contador de visitas',
	'COUNTER_RESET'               => 'Repor contador de visitas',
	'COUNTER_RESET_EXPLAIN'       => 'Repõe as visitas a 0 e o início do contador para a data atual.',
	'HOME_TYPE_DISPLAY'           => 'Comportamento da página inicial',
	'HOME_TYPE_DISPLAY_EXPLAIN'   => 'Define como funcionará a página inicial, caso esteja ativada.',
	'IMAGE_RESIZE'                => 'Redimensionar imagens',
	'IMAGE_RESIZE_POST'           => 'Redimensionar imagens nas mensagens',
	'IMAGE_RESIZE_POST_EXPLAIN'   => 'Ativa/Desativa o redimensionamento das imagens dentro das mensagens do fórum.',
	'IMAGE_RESIZE_WIDTH'          => 'Tamanho máximo das imagens',
	'IMAGE_RESIZE_WIDTH_EXPLAIN'  => 'Tamanho máximo (em pixels) para as imagens. O valor por defeito é 450.<br />
		<em>Define 0 para desativar o redimensionamento de imagens</em>.',

	'INDEX_FILE_ERROR' => 'Falha ao concluir a configuração',
]);

// @acp_blockgets_lists
$lang = array_merge($lang, [
	'ADD_ITEM' => 'Adicionar elemento',
	'CAT'      => 'Categoria',

	'LINK'                     => 'Link',
	'LINK_DESCRIPTION'         => 'Descrição',
	'LINK_DESCRIPTION_EXPLAIN' => 'Este texto será mostrado nalguns blocos como informação adicional do link.',
	'LINK_GROUP'               => 'Grupos',
	'LINK_GROUP_EXPLAIN'       => 'Seleciona os grupos de utilizadores que podem ver este link no menu.<br />Podes selecionar vários grupos utilizando a tecla <em>Ctrl</em> do teclado.',
	'LINK_IMG'                 => 'Imagem',
	'LINK_TITLE'               => 'Título do link',
	'LINK_TITLE_EXPLAIN'       => 'Título que identifica o link. Limite de 100 caracteres.',
	'LINK_TYPE'                => 'Tipo de link',
	'LINK_URL'                 => 'URL do link',
	'LINK_URL_EXPLAIN'         => 'O endereço que abre ao clicares no link. Limite de 255 caracteres.',
	'LINK_WINDOW'              => 'Abrir numa nova janela',
]);

// @acp_blockgets_pages
$lang = array_merge($lang, [
	'ADD_BLOCK'               => 'Adicionar bloco',
	'ADD_BLOCK_TIP'           => 'Arrasta um bloco para a posição onde o queres adicionar.',
	'ADD_BLOCK_TITLE'         => 'Adicionar bloco :: %1$s',
	'ADD_BLOCK_TITLE_EXPLAIN' => 'Aqui podes adicionar um novo bloco ao teu fórum e definir a sua configuração. Também podes definir configurações adicionais, caso o bloco precise.',
	'ADD_GROUP'               => 'Adicionar grupo',
	'ADD_GROUP_EXPLAIN'       => 'Arrasta este botão para a posição pretendida para adicionar um grupo',
	'ADVANCED_OPTIONS'        => 'Opções avançadas',

	'BLOCK_SETTINGS'           => 'Opções gerais do bloco',
	'BLOCK_SPACE'              => 'Espaço entre blocos',
	'BLOCK_SPACE_EXPLAIN'      => 'Valor em pixels ou percentagem. O valor mínimo é 1.',
	'BOTTOM_COLUMN'            => 'Coluna inferior',
	'CENTER_COLUMN'            => 'Coluna central',
	'CHG_GROUPS_BLOCK'         => 'Alterar permissões',
	'CHG_GROUP_EXPLAIN'        => 'Escolhe os grupos que podem ver os blocos selecionados',
	'COLUMN_SETTINGS'          => 'Opções das colunas',
	'COPY_BLOCK'               => 'Copiar para outra página',
	'DELETE_BLOCK_CONFIRM'     => 'Tens a certeza de que queres eliminar os blocos selecionados?',
	'DISABLE_BLOCK'            => 'Desativar',
	'EDIT_BLOCK_TITLE'         => 'Editar bloco :: %1$s',
	'EDIT_BLOCK_TITLE_EXPLAIN' => 'Aqui podes editar a configuração do bloco, bem como as configurações adicionais, caso o bloco precise.',
	'ENABLE_BLOCK'             => 'Ativar',
	'EXT_ROUTES'               => 'Rotas da extensão',
	'FILTER_TYPE_GET'          => 'Url (GET)',
	'FILTER_TYPE_POST'         => 'Formulário (POST)',
	'FORUM_ROUTES'             => 'Rotas do fórum',
	'LEFT_COLUMN'              => 'Coluna esquerda',
	'LEFT_COLUMN_EXPLAIN'      => 'Largura da coluna esquerda em pixels ou percentagem.<br />Define 0 para desativar a coluna.',
	'LINK_BOTTOM'              => 'Inferior',
	'LINK_QUICK'               => 'Links rápidos',
	'LINK_NONE'                => 'Sem link',
	'LINK_TOP'                 => 'Superior',
	'MANAGE_PAGE'              => 'Gerir página',
	'MOVE_BLOCK'               => 'Mover para outra página',
	'NO_PAGES_CREATED'         => 'Nenhuma página criada.',
	'NO_PAGE_FILTERS'          => 'Sem filtros',

	'PAGE'                       => 'Página',
	'PAGE_ADD'                   => 'Nova página',
	'PAGE_ALIAS'                 => 'Alias da página',
	'PAGE_ALIAS_EXPLAIN'         => 'Podes definir um alias (letras, números e traços) para criar uma página separada.<br />Se deixares este campo em branco, será criada uma página separada e será utilizado o ID como alias.',
	'PAGE_ALIAS_ERROR'           => 'O valor inserido no campo "Alias da página" contém caracteres inválidos ou um caminho inválido.',
	'PAGE_BACKGROUND'            => 'Fundo da página',
	'PAGE_BACKGROUND_EXPLAIN'    => 'Podes definir uma cor (ex. white, #FFFFFF) ou uma imagem (ex. http://omeudominio.com/imagem.jpg). Deixa este campo em branco para utilizar o fundo por defeito.',
	'PAGE_CUSTOM'                => 'Páginas personalizadas',
	'PAGE_CUSTOM_EXPLAIN'        => 'Estas são páginas criadas por ti ou por outro administrador deste site. Podes adicionar, editar e gerir quantas páginas quiseres.',
	'PAGE_CUSTOM_ONE'            => 'Página personalizada',
	'PAGE_DESCRIPTION'           => 'Descrição SEO',
	'PAGE_DESCRIPTION_EXPLAIN'   => 'Define uma descrição visível para os motores de busca.<br /><em>Google, bing, etc...</em>',
	'PAGE_ENABLED'               => 'Página ativada',
	'PAGE_ENABLED_EXPLAIN'       => 'Ativa ou desativa completamente as funções da página. Esta opção substitui todas as outras.',
	'PAGE_FILTERS'               => 'Filtros',
	'PAGE_FILTERS_EXPLAIN'       => 'Define os parâmetros necessários (GET e POST) para que a página seja carregada.<br />Consulta a <strong>Documentação Online</strong> para mais informações sobre como definir estes filtros.',
	'PAGE_FILTER_PARAM'          => 'Parâmetros',
	'PAGE_FILTER_PARAM_EXPLAIN'  => 'Podes definir quantos quiseres separados por ","<br />Ex: mode=mymode,style=1',
	'PAGE_FILTER_TYPE'           => 'Tipo',
	'PAGE_FILTER_TYPE_EXPLAIN'   => 'Seleciona o tipo de parâmetros de localização.',
	'PAGE_FORUM'                 => 'Páginas dentro do fórum',
	'PAGE_FORUM_EXPLAIN'         => 'Estas são páginas pertencentes ao fórum às quais podes adicionar blocos. Podes gerir e editar os seus parâmetros principais tal como nas páginas personalizadas.',
	'PAGE_GROUP'                 => 'Grupos',
	'PAGE_GROUP_EXPLAIN'         => 'Escolhe os grupos que podem ver os blocos desta página.<br />Podes selecionar vários grupos utilizando a <em>tecla Ctrl</em> do teclado.',
	'PAGE_HOME'                  => 'Página inicial',
	'PAGE_HOME_EXPLAIN'          => 'Esta é uma página concebida para ser utilizada como página inicial de um site, como um "Portal".',
	'PAGE_LINK'                  => 'Link',
	'PAGE_LINK_ICON'             => 'Ícone do link',
	'PAGE_LINK_ICON_EXPLAIN'     => 'Define o ícone que o link para esta página terá.',
	'PAGE_LINK_POSITION'         => 'Posição do link',
	'PAGE_LINK_POSITION_EXPLAIN' => 'Define em que parte do fórum aparecerá um link para esta página.',
	'PAGE_LOGO'                  => 'Logótipo',
	'PAGE_LOGO_EXPLAIN'          => 'Define o url da imagem a utilizar como logótipo.<br />Deixa em branco para utilizar o logótipo por defeito.',
	'PAGE_STYLE'                 => 'Estilo',
	'PAGE_STYLE_EXPLAIN'         => 'Define o estilo a utilizar na página.<br /><em>Esta opção não será aplicada às páginas originais do fórum.</em>',
	'PAGE_STYLESHEET'            => 'Tema personalizado',
	'PAGE_STYLESHEET_EXPLAIN'    => 'Podes definir o caminho para um ou mais ficheiros *.css (um por linha) ou definir diretamente as variáveis do tema a utilizar.',
	'PAGE_THEME'                 => 'Tema',
	'PAGE_THEME_BACKGROUND'      => 'Definir fundo',
	'PAGE_THEME_DEFAULT'         => 'Utilizar configuração por defeito',
	'PAGE_THEME_STYLE'           => 'Definir estilo',
	'PAGE_THEME_STYLESHEET'      => 'Utilizar tema personalizado',
	'PAGE_TITLE'                 => 'Título da página',
	'PAGE_TITLE_EXPLAIN'         => 'O título será apresentado no navegador.',
	'PAGE_URL'                   => 'URL da página',

	'PAGES_ADD_TITLE'            => 'Adicionar nova página',
	'PAGES_ADD_TITLE_EXPLAIN'    => 'Aqui podes adicionar uma nova página e definir a configuração e aparência personalizadas.',
	'PAGES_BLOCKS_TITLE'         => 'Gerir blocos :: %s',
	'PAGES_BLOCKS_TITLE_EXPLAIN' => 'Aqui podes criar/editar/eliminar blocos para mostrar nesta página.<br />
		Os blocos podem ser divididos em cinco colunas (esquerda, centro, direita, superior e inferior). Arrasta os blocos para alterar a sua posição.<br />
		Também podes adicionar <strong>grupos</strong> que te permitem colocar blocos em até 3 colunas de forma independente.',
	'PAGES_EDIT_TITLE'           => 'Editar página :: %s',
	'PAGES_EDIT_TITLE_EXPLAIN'   => 'Aqui podes editar a configuração principal e a aparência da página.',
	'PAGES_SELECT_TITLE_EXPLAIN' => 'Seleciona a página a gerir.',
	'PAGES_TITLE'                => 'Gerir páginas',
	'PAGES_TITLE_EXPLAIN'        => 'Aqui podes criar/editar/eliminar páginas adicionais para o teu fórum. Também podes editar a configuração e os blocos nas páginas predefinidas.',

	'RIGHT_COLUMN'         => 'Coluna direita',
	'RIGHT_COLUMN_EXPLAIN' => 'Largura da coluna direita em pixels ou percentagem.<br />Define 0 para desativar a coluna.',
	'SHOW_FOOTER'          => 'Mostrar rodapé',
	'SHOW_FOOTER_EXPLAIN'  => 'Esta opção permite-te decidir se o rodapé do fórum é apresentado nesta página.',
	'SHOW_HEADER'          => 'Mostrar cabeçalho',
	'SHOW_HEADER_EXPLAIN'  => 'Esta opção permite-te decidir se o cabeçalho do fórum é apresentado nesta página.',
	'STYLE_DEFAULT'        => 'Estilo por defeito',
	'STYLE_ALTERNATIVE'    => 'Estilo alternativo',
	'STYLE_CONTENT_FULL'   => 'Apenas conteúdo (com título)',
	'STYLE_CONTENT_SIMPLE' => 'Apenas conteúdo (sem título)',
	'SUBMIT_CHANGES'       => 'Aplicar alterações',
	'TARGET_PAGE_EXPLAIN'  => 'Seleciona a página de destino para os blocos selecionados.<br /><em>Os blocos serão colocados na respetiva coluna</em>',
	'TOP_COLUMN'           => 'Coluna superior',
]);

// @general messages
$lang = array_merge($lang, [
	'BLOCK_ADDED'                => 'Bloco adicionado com sucesso',
	'BLOCK_COPIED'               => 'Bloco(s) copiado(s) com sucesso',
	'BLOCK_NEED_REQUIREMENTS'    => 'O bloco selecionado necessita de alguns requisitos mínimos para ser utilizado.<br />Consulta a documentação para mais informações.',
	'BLOCK_MOVED'                => 'Bloco(s) movido(s) com sucesso',
	'BLOCK_NOT_ADDED'            => 'Erro ao adicionar o bloco',
	'BLOCK_NOT_EXISTS'           => 'O bloco selecionado não existe',
	'BLOCK_NOT_UPDATED'          => 'Erro ao atualizar o bloco',
	'BLOCK_POSITION_UPDATED'     => 'Posição dos blocos atualizada com sucesso',
	'BLOCK_POSITION_NOT_UPDATED' => 'Erro ao atualizar a posição dos blocos',
	'BLOCK_REMOVED'              => 'Bloco(s) removido(s) com sucesso',
	'BLOCK_UPDATED'              => 'Bloco atualizado com sucesso',
	'GROUPS_CHANGED'             => 'Grupos atualizados com sucesso',

	'ITEM_REMOVED'     => 'Elemento removido com sucesso',
	'ITEM_UPDATED'     => 'Elemento atualizado com sucesso',
	'ITEM_ADDED'       => 'Elemento adicionado com sucesso',
	'ITEM_NOT_ADDED'   => 'Erro ao adicionar o elemento',
	'ITEM_NOT_UPDATED' => 'Erro ao atualizar o elemento',

	'PAGE_ADDED' => 'Página adicionada com sucesso',

	'PAGE_REMOVED' => [
		1 => 'A página foi removida com sucesso',
		2 => '%d páginas eliminadas com sucesso',
	],

	'PAGE_UPDATED'       => 'Configuração da página atualizada com sucesso',
	'BLG_CONFIG_UPDATED' => 'Configuração atualizada com sucesso',

	'CONFIRM_PAGE_DELETE' => 'Tens a certeza de que queres eliminar esta página e todos os blocos nela contidos?',
]);

/**
* Blocks names and explains from block_alias
*/
$lang = array_merge($lang, [
	'blocks' => [
		'announcements_title'      => 'Anúncios',
		'announcements_explain'    => 'Mostra um número definido de mensagens (anúncios) dos fóruns estabelecidos.',
		'attachments_title'        => 'Anexos',
		'attachments_explain'      => 'Mostra informação e links para os anexos especificados.',
		'banners_title'            => 'Banners',
		'banners_explain'          => 'Mostra a lista especificada de banners. É apresentada de forma fixa ou em rotação.',
		'birthdays_title'          => 'Aniversários',
		'birthdays_explain'        => 'Mostra a lista de aniversários de hoje e dos próximos dias (opcional).',
		'empty_title'              => 'Personalizado',
		'empty_explain'            => 'Bloco totalmente vazio que também pode incluir qualquer texto HTML, CSS, JavaScript, etc...',
		'calendar_title'           => 'Calendário',
		'calendar_explain'         => 'Calendário no qual podes adicionar eventos personalizados e mostrar aniversários.',
		'clock_title'              => 'Relógio',
		'clock_explain'            => 'Mostra um relógio em formato flash (podes escolher vários modelos e adicionar o teu próprio relógio).',
		'cloud_tag_title'          => 'Nuvem de Tags',
		'cloud_tag_explain'        => 'Amostra de etiquetas num balão em formato flash. Podes mostrar as últimas palavras pesquisadas ou os utilizadores com mais mensagens.',
		'contact_title'            => 'Contacto',
		'contact_explain'          => 'Mostra um formulário de contacto padrão.',
		'countdown_title'          => 'Contagem decrescente',
		'countdown_explain'        => 'Mostra uma contagem decrescente até à data indicada.',
		'counter_title'            => 'Contador de visitas',
		'counter_explain'          => 'Mostra um contador de visitas com estatísticas de visitas, visitas por dia, visitas por hora, visitas semanais, visitas por mês e visitas por ano.',
		'dockmenu_title'           => 'Menu Dock',
		'dockmenu_explain'         => 'Mostra um menu com estilo Mac Dock com os elementos da lista especificada.',
		'forums_title'             => 'Fóruns',
		'forums_explain'           => 'Lista com fóruns completos ou personalizados.',
		'frame_title'              => 'Frame',
		'frame_explain'            => 'Mostra uma página Web, um ficheiro PDF, um ficheiro Flash ou um ficheiro de texto dentro do bloco.',
		'gallery_title'            => 'Galeria de fotos',
		'gallery_explain'          => 'Galeria de fotos personalizável com imagens do fórum (anexos) ou imagens externas. As imagens movem-se e associam o destino de cada uma.',
		'google_translate_title'   => 'Tradutor do Google',
		'google_translate_explain' => 'Bloco que te permite traduzir a página onde está instalado, abrindo uma nova janela e traduzindo-a através da tecnologia do Google.',
		'language_select_title'    => 'Seleção de idioma',
		'language_select_explain'  => 'Permite ao utilizador ver o fórum em qualquer idioma instalado no fórum e defini-lo como o seu idioma por defeito.',
		'latest_bots_title'        => 'Visitas de bots',
		'latest_bots_explain'      => 'Lista simples dos últimos bots que entraram no fórum e a data da sua última visita.',
		'latest_members_title'     => 'Membros mais recentes',
		'latest_members_explain'   => 'Lista dos utilizadores mais recentemente registados no fórum e a data em que se registaram.',
		'leaders_title'            => 'Líderes',
		'leaders_explain'          => 'Mostra uma lista de grupos (personalizável) com os líderes do fórum.',
		'link_us_title'            => 'Liga-te a nós',
		'link_us_explain'          => 'Bloco que mostra um link selecionável pelo utilizador para a página onde está instalado. Podes definir um mini banner associado ao link.',
		'login_title'              => 'Início de sessão',
		'login_explain'            => 'Permite a um utilizador iniciar sessão diretamente a partir do bloco. Depois de identificado, mostra a informação e os links principais do utilizador.',
		'map_title'                => 'Mapa',
		'map_explain'              => 'Mostra um mapa que pode conter marcas com localizações diferentes.',
		'menu_title'               => 'Menu',
		'menu_explain'             => 'Menu em formato de árvore que mostra os elementos da lista selecionada.',
		'most_poster_title'        => 'Mais Ativos',
		'most_poster_explain'      => 'Mostra uma lista pendente com os utilizadores que mais mensagens publicaram no fórum, e a informação mais relevante.',
		'news_title'               => 'Notícias',
		'news_explain'             => 'Menu pendente que mostra as últimas mensagens dos fóruns especificados como notícias.',
		'online_friends_title'     => 'Amigos online',
		'online_friends_explain'   => 'Lista simples dos amigos e inimigos do utilizador que estão ligados ao fórum.',
		'paypal_title'             => 'Donativos',
		'paypal_explain'           => 'Permite aos utilizadores doar dinheiro através do PayPal.',
		'player_title'             => 'Leitor de música',
		'player_explain'           => 'Leitor para reproduzir músicas em formato MP3 ou WAV. Permite criar uma lista de músicas ou utilizar listas de reprodução M3U, ASX ou PLS.',
		'poll_title'               => 'Sondagem',
		'poll_explain'             => 'Mostra uma única sondagem especificada na sua configuração.',
		'poll_random_title'        => 'Sondagem (aleatória)',
		'poll_random_explain'      => 'Mostra um número selecionado de sondagens escolhidas por ordem aleatória, dentro do fórum especificado.',
		'post_view_title'          => 'Mensagem do fórum',
		'post_view_explain'        => 'Mostra o conteúdo de uma mensagem. Podes mostrar a última mensagem de um fórum, a primeira ou última mensagem de um tópico ou uma mensagem personalizada.',
		'quote_of_day_title'       => 'Citação do dia',
		'quote_of_day_explain'     => 'Mostra uma "citação" ou frase do dia ou uma dica diferente em cada visita à página.',
		'random_member_title'      => 'Membro aleatório',
		'random_member_explain'    => 'Mostra informação básica e o avatar de um utilizador aleatório.',
		'ranks_title'              => 'Categorias',
		'ranks_explain'            => 'Mostra uma lista com as categorias do fórum.',
		'recent_topics_title'      => 'Tópicos recentes',
		'recent_topics_explain'    => 'Tópicos recentes do fórum. Permite selecionar os fóruns dos quais ler os tópicos.',
		'rss_title'                => 'Leitor RSS',
		'rss_explain'              => 'Mostra os artigos mais recentes dos feeds RSS especificados. Os itens serão apresentados em modo de deslocamento ou acordeão.',
		'share_title'              => 'Partilhar',
		'share_explain'            => 'Mostra os botões das redes sociais mais populares no formato pretendido.',
		'search_title'             => 'Pesquisa',
		'search_explain'           => 'Permite aos utilizadores fazer pesquisas rápidas no fórum ou num motor de busca.',
		'scroll_message_title'     => 'Texto em rotação',
		'scroll_message_explain'   => 'Mensagem de texto que roda dentro do bloco. Permite utilizar BBCode e HTML no texto.',
		'stats_title'              => 'Estatísticas',
		'stats_explain'            => 'Obtém a informação mais relevante do fórum. Este bloco mostra o número de novas mensagens e tópicos, o número total de mensagens e tópicos, estatísticas de mensagens e tópicos escritos por dia, o número total de anexos e o número de utilizadores que permanecem ativos (a publicar mensagens).',
		'steam_title'              => 'Steam',
		'steam_explain'            => 'Mostra informação sobre o grupo Steam.',
		'style_select_title'       => 'Seleção de estilo',
		'style_select_explain'     => 'Permite ao utilizador ver o fórum com qualquer estilo instalado no fórum e defini-lo como o seu estilo por defeito.',
		'top_topics_title'         => 'Melhores tópicos',
		'top_topics_explain'       => 'Lista de tópicos personalizada que pode mostrar os últimos tópicos não lidos, os tópicos mais ativos ou os tópicos mais vistos.',
		'topic_index_title'        => 'Índice de tópicos',
		'topic_index_explain'      => 'Mostra uma lista ordenada com os tópicos dos fóruns selecionados. A lista pode ser ordenada por título do tópico, data do tópico ou data da última mensagem do tópico.',
		'welcome_title'            => 'Boas-vindas',
		'welcome_explain'          => 'Este bloco ativa uma mensagem de boas-vindas diferente para convidados e utilizadores registados. O bloco decide qual a mensagem a mostrar.',
		'whos_online_title'        => 'Quem está online',
		'whos_online_explain'      => 'Mostra a lista de utilizadores ligados (tal como é mostrado por defeito no Índice do fórum) e os utilizadores que iniciaram sessão nas últimas 24 horas.',
		'youtube_title'            => 'YouTube',
		'youtube_explain'          => 'Mostra vídeos ou canais do YouTube.',
	]
]);
