<?php

/**
 * @package cBB Chat for phpBB.
 * [English [En]]
 * @version 1.2.6 01/07/2024
 * @copyright (c) 2024 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 * @translation Leinad4Mind [Portuguese [pt_preao]] (2026)
 */

// DO NOT CHANGE
if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = [];
}

$lang = array_merge($lang, [
	'ACP_CHAT_CONFIG_EXPLAIN' => 'Obrigado por escolheres o cBB Chat como um complemento para o teu fórum!<br />
		A partir desta página podes modificar as funcionalidades principais do chat.',
	'ACP_CHAT_PAGES_EXPLAIN' => 'A partir daqui podes gerir as páginas em que o chat será carregado e a respectiva posição.',
	'ACP_CHAT_ROOMS_EXPLAIN' => 'A partir daqui podes gerir as salas especiais a serem exibidas no chat.<br />Podes ordenar arrastando as salas para a sua posição correcta.',
	'ACP_CHAT_TEXTS_EXPLAIN' => 'A partir daqui podes gerir os anúncios, dicas e regras do chat.<br />
		Para escolheres a ordem dos textos, arrasta-os para a posição correcta.',

	'CHAT_ALLOW_BBCODE'              => 'Permitir BBcode',
	'CHAT_ALLOW_BBCODE_EXPLAIN'      => 'Define se os utilizadores podem usar tags BBcode no chat.',
	'CHAT_ALLOW_PM'                  => 'Permitir mensagens privadas',
	'CHAT_ALLOW_PM_EXPLAIN'          => 'Activar/Desactivar as mensagens privadas entre utilizadores.',
	'CHAT_ANONYMOUS_ALLOWED'         => 'Permitir visitantes anónimos',
	'CHAT_ANONYMOUS_ALLOWED_EXPLAIN' => 'Se activado, os visitantes irão aceder ao chat com um nome aleatório em vez de terem de escolher o nome.<br />
		<em>Esta opção só é válida se o grupo de visitantes tiver permissões para ver o chat. </em>',
	'CHAT_AUTOCONNECT'           => 'Autoconectar',
	'CHAT_AUTOCONNECT_EXPLAIN'   => 'Define se o chat conecta automaticamente ao carregar a página.',
	'CHAT_AUTO_AWAY'             => 'Tempo para o estado <em>Disponível</em>',
	'CHAT_AUTO_AWAY_EXPLAIN'     => 'Define o tempo de espera (em minutos) após o qual o estado de um utilizador muda de <em><strong>Disponível</strong></em> para <em><strong>Ausente</strong></em>.<br /><em> Define para 0 para desactivar esta função</em>.',
	'CHAT_AUTO_AWAY_ERROR'       => 'O tempo de mudança de estado deve ser inferior ao tempo de desconexão',
	'CHAT_AVATARS'               => 'Mostrar avatares',
	'CHAT_BBCODE_FORMAT'         => 'Formato dos BBcodes personalizados',
	'CHAT_BBCODE_FORMAT_EXPLAIN' => 'Define a aparência dos BBcodes personalizados no chat.',
	'CHAT_BBCODE_INBUTTON'       => 'Botões',
	'CHAT_BBCODE_INSELECT'       => 'Menu seleccionável',
	'CHAT_CHARS'                 => 'Caracteres por mensagem',
	'CHAT_CHARS_EXPLAIN'         => 'Número máximo de caracteres permitidos por mensagem.<br />
		<em>Define 0 para desactivar este limite</em>.',
	'CHAT_DIRECTION'                 => 'Direcção das mensagens',
	'CHAT_DIRECTION_EXPLAIN'         => 'Define a ordem das mensagens no chat.',
	'CHAT_DIRECTION_DOWN'            => 'Mais antigas primeiro',
	'CHAT_DIRECTION_UP'              => 'Mais recentes primeiro',
	'CHAT_DISALLOWED_BBCODE'         => 'Tags BBcode não permitidas',
	'CHAT_DISALLOWED_BBCODE_EXPLAIN' => 'Tags BBcode que <strong>não</strong> serão permitidas no chat.<br />
		Podes seleccionar várias tags usando a tecla <em>Ctrl</em> do teu teclado.',
	'CHAT_FLOOD'         => 'Limite de flood',
	'CHAT_FLOOD_EXPLAIN' => 'Define o tempo (em segundos) que os utilizadores devem esperar para escrever uma nova mensagem.<br />
		<em>Define 0 para desactivar este limite</em>.',
	'CHAT_FORUM_POSTS'          => 'Mensagens do fórum',
	'CHAT_FORUM_POSTS_EXPLAIN'  => 'Define se os novos tópicos ou mensagens no fórum serão mostrados nas salas de chat.',
	'CHAT_GROUP_USERS'          => 'Agrupar utilizadores por grupos',
	'CHAT_GROUP_USERS_EXPLAIN'  => 'Se activado, os utilizadores serão agrupados no chat pelo seu grupo predefinido.',
	'CHAT_HEIGHT'               => 'Altura do chat',
	'CHAT_HEIGHT_EXPLAIN'       => 'Define a altura (em pixels) do recipiente de conversa.',
	'CHAT_HEIGHT_PAGE'          => 'Altura do chat',
	'CHAT_HEIGHT_PAGE_EXPLAIN'  => 'Define a altura (em pixels) do recipiente de conversa nesta página.<br /><em>Define 0 para usar o valor predefinido.</em>',
	'CHAT_HIDE_POPUP'           => 'Ocultar menus automaticamente',
	'CHAT_HIDE_POPUP_EXPLAIN'   => 'Se activado, os menus de BBcode, cor e emoticons fecharão automaticamente quando realizares a acção.',
	'CHAT_MAIN_CONFIG'          => 'Configuração principal',
	'CHAT_MESSAGES_CONFIG'      => 'Configuração das mensagens',
	'CHAT_NOTICES_ADD'          => 'Adicionar anúncio',
	'CHAT_NOTICES_EDIT'         => 'Editar anúncio',
	'CHAT_NOTICES_EXPLAIN'      => 'Estes textos serão mostrados como <em>anúncios</em> ou alertas no topo do chat.',
	'CHAT_NOTICES_ITEM'         => 'Anúncio',
	'CHAT_NOTICES_ITEM_EXPLAIN' => 'Podes usar variáveis de idioma, por exemplo <em>{L_CHAT}</em>.<br />
		<em>É permitido BBcode ou HTML.<br />
		São permitidos emoticons.</em>',
	'CHAT_NOTICES'                 => 'Anúncios',
	'CHAT_PAGE_ALIAS'              => 'Alias da Página',
	'CHAT_PAGE_ALIAS_EXPLAIN'      => 'Define um id único para a página que será usado no ficheiro de configuração.<br /><em>São permitidas apenas letras e números</em>.',
	'CHAT_PAGE_CONFIG'             => 'Configuração da página',
	'CHAT_PAGE_CUSTOM'             => 'Caminho personalizado',
	'CHAT_PAGE_CUSTOM_EXPLAIN'     => 'Define o caminho completo (relativo ao phpBB) da página.<br />Por exemplo: <em>pasta/ficheiro.php</em>.',
	'CHAT_PAGE_ENABLED'            => 'Página do chat activada',
	'CHAT_PAGE_ENABLED_EXPLAIN'    => 'Activar/Desactivar a página principal do chat.',
	'CHAT_PAGE_FILE'               => 'Ficheiro da página',
	'CHAT_PAGE_FILE_EXPLAIN'       => 'Define o ficheiro que irá carregar o chat.',
	'CHAT_PAGE_FORUMS'             => 'Fóruns',
	'CHAT_PAGE_FORUMS_EXPLAIN'     => 'Define os fóruns onde o chat é exibido.<br />Podes seleccionar tantos quantos quiseres usando a tecla <em>Ctrl</em> do teu teclado.<br /><em>Se não seleccionares nenhum fórum o chat mostra em todos.</em> ',
	'CHAT_PM_CONFIG'               => 'Configuração de mensagens privadas',
	'CHAT_PM_IGNORE_FLOOD'         => 'Ignorar limite de flood',
	'CHAT_PM_IGNORE_FLOOD_EXPLAIN' => 'Se activado, o limite de flood estabelecido não se aplicará ao escrever mensagens privadas entre utilizadores.',
	'CHAT_PM_MAX'                  => 'Limite de mensagens privadas',
	'CHAT_PM_MAX_EXPLAIN'          => 'Define o número máximo de mensagens privadas que um utilizador pode ter abertas simultaneamente.<br /><em>Define 0 para desactivar este limite</em>.',
	'CHAT_PM_MAXAGE'               => 'Tempo de armazenamento',
	'CHAT_PM_MAXAGE_EXPLAIN'       => 'Define o tempo (em dias) em que as mensagens privadas serão salvas.
		<br />As mensagens que ultrapassarem esta idade serão eliminadas.
		<br /><br /><em>Valor mínimo 1, valor máximo 365</em>.',
	'CHAT_POSITION'                  => 'Posição do chat',
	'CHAT_POSITION_EXPLAIN'          => 'Posição do chat dentro da página.',
	'CHAT_POSITION_BOTTOM'           => 'Fundo',
	'CHAT_POSITION_TOP'              => 'Topo',
	'CHAT_REFRESH_TIME'              => 'Intervalo de actualização',
	'CHAT_REFRESH_TIME_EXPLAIN'      => 'Intervalo de tempo (em segundos) que o chat espera para actualizar.',
	'CHAT_REMEMBER_STATUS'           => 'Lembrar o estado do utilizador',
	'CHAT_REMEMBER_STATUS_EXPLAIN'   => 'Se activado, o chat irá lembrar o estado dos utilizadores nas novas conexões, no entanto, os utilizadores terão o estado <em><strong>Disponível</strong></em> quando se ligarem.',
	'CHAT_ROOM_AUTH'                 => 'Permissões de visualização',
	'CHAT_ROOM_AUTOPURGE'            => 'Autolimpeza',
	'CHAT_ROOM_AUTOPURGE_EXPLAIN'    => 'Define com que frequência todas as mensagens são removidas desta sala.',
	'CHAT_ROOM_CONFIG'               => 'Configuração da sala',
	'CHAT_ROOM_CONNECTIONS'          => 'Conexões',
	'CHAT_ROOM_ENABLED'              => 'Sala activada',
	'CHAT_ROOM_GROUPS'               => 'Grupos permitidos',
	'CHAT_ROOM_GROUPS_EXPLAIN'       => 'Define grupos de utilizadores que podem usar esta sala.<br />Podes seleccionar vários grupos usando a tecla <em>Ctrl</em> do teu teclado.',
	'CHAT_ROOM_GUEST_FORUMS'         => 'Fóruns associados a esta sala',
	'CHAT_ROOM_GUEST_FORUMS_EXPLAIN' => 'Aqui podes seleccionar os fóruns a partir dos quais os tópicos e as mensagens serão exibidos na sala de chat principal.<br />
		Se não seleccionares nenhum, todos serão usados (excepto os atribuídos a outras salas).<br />
		Podes seleccionar quantos quiseres usando a tecla <em>Ctrl</em> do teu teclado.',
	'CHAT_ROOM_LINKED_FORUMS'         => 'Fóruns associados a esta sala',
	'CHAT_ROOM_LINKED_FORUMS_EXPLAIN' => 'Esta sala será a sala predefinida para os fóruns seleccionados aqui, e os tópicos e mensagens destes fóruns serão mostrados nesta sala em vez de na sala Geral.<br />
		Podes seleccionar quantos quiseres usando a tecla <em>Ctrl</em> do teu teclado.',
	'CHAT_ROOM_LINKED_GROUPS'         => 'Grupos associados a esta sala',
	'CHAT_ROOM_LINKED_GROUPS_EXPLAIN' => 'Esta sala irá abrir por defeito para os grupos aqui seleccionados.<br />
		Podes seleccionar quantos quiseres usando a tecla <em>Ctrl</em> do teu teclado.',
	'CHAT_ROOM_ADDED'             => 'A sala foi criada com sucesso.',
	'CHAT_ROOM_UPDATED'           => 'A configuração da sala foi alterada com sucesso.',
	'CHAT_ROOM_MSG_LIMIT'         => 'Limite de mensagens',
	'CHAT_ROOM_MSG_LIMIT_EXPLAIN' => 'Define o número máximo de mensagens que são armazenadas nesta sala. Se este limite for excedido, as mensagens mais antigas são periodicamente eliminadas.
		<br /><em>Define 0 para desactivar este limite.</em>',
	'CHAT_ROOM_TITLE'         => 'Título da sala',
	'CHAT_ROOM_TITLE_EXPLAIN' => 'Suporta variáveis de idioma.',
	'CHAT_ROOM_USERS'         => 'Utilizadores permitidos',
	'CHAT_ROOM_USERS_EXPLAIN' => 'Define os utilizadores que podem usar esta sala.<br />Insere um utilizador por linha.',
	'CHAT_ROW_ALIGN'          => 'Alinhamento das mensagens',
	'CHAT_ROW_ALIGN_EXPLAIN'  => 'Define de que lado as mensagens serão exibidas no chat.<br /><em>Esta configuração é afetada se o idioma usado for RTL.</em>',
	'CHAT_ROW_BUBBLE'         => 'Bolha',
	'CHAT_ROW_FORMAT'         => 'Formato da mensagem',
	'CHAT_ROW_FORMAT_EXPLAIN' => 'Define o estilo visual das mensagens.',
	'CHAT_ROW_LEFT'           => 'Mostrar à esquerda',
	'CHAT_ROW_MEOTHER'        => 'Mostrar o utilizador actual num lado e os restantes no outro',
	'CHAT_ROW_NORMAL'         => 'Normal',
	'CHAT_ROW_RIGHT'          => 'Mostrar à direita',
	'CHAT_ROW_ZIGZAG'         => 'Mostrar em ZigZag',
	'CHAT_ROWS'               => 'Mensagens no chat',
	'CHAT_ROWS_EXPLAIN'       => 'Número máximo de mensagens que serão mostradas no recipiente de conversa.',
	'CHAT_RULES_ADD'          => 'Adicionar regra',
	'CHAT_RULES_EDIT'         => 'Editar regra',
	'CHAT_RULES_EXPLAIN'      => 'Estes textos serão exibidos como <em>regras</em> na lista de regras do chat.',
	'CHAT_RULES_ITEM'         => 'Regra',
	'CHAT_RULES_ITEM_EXPLAIN' => 'Podes usar variáveis de idioma, por exemplo <em>{L_CHAT}</em>.<br />
		<em>É permitido BBcode ou HTML.<br />
		São permitidos emoticons.</em>',
	'CHAT_RULES'             => 'Regras',
	'CHAT_SOUND_ENABLED'     => 'Som activado',
	'CHAT_SHOW_NONE'         => 'Não mostrar',
	'CHAT_SHOW_POSTS'        => 'Todas as novas mensagens',
	'CHAT_SHOW_TOPICS'       => 'Apenas novos tópicos',
	'CHAT_TIMEOUT'           => 'Tempo de desconexão',
	'CHAT_TIMEOUT_EXPLAIN'   => 'Define o tempo (em minutos) que o chat precisa para considerar um utilizador como "inactivo" e o desconectar do chat.<br /><em>Define como 0 para desactivar esta função</em>.',
	'CHAT_TIPS_ADD'          => 'Adicionar dica',
	'CHAT_TIPS_EDIT'         => 'Editar dica',
	'CHAT_TIPS_EXPLAIN'      => 'Estes textos serão mostrados como pequenas <em>dicas</em> sobre o campo de introdução de texto do chat.',
	'CHAT_TIPS_ITEM'         => 'Dica',
	'CHAT_TIPS_ITEM_EXPLAIN' => 'Podes usar variáveis de idioma, por exemplo <em>{L_CHAT}</em>.<br />
		<em>É permitido BBcode ou HTML.<br />
		São permitidos emoticons.</em>',
	'CHAT_TIPS'         => 'Dicas',
	'CHAT_USERS_CONFIG' => 'Configuração de utilizador',

	'EACH_DAY'   => 'A cada dia',
	'EACH_WEEK'  => 'A cada semana',
	'EACH_MONTH' => 'A cada mês',
	'EACH_YEAR'  => 'A cada ano',

	'ADD_ROOM'        => 'Adicionar sala',
	'CONTENT'         => 'Conteúdo',
	'CUSTOM_BBCODES'  => 'BBcodes personalizados',
	'CUSTOM_ROUTE'    => 'Rota personalizada',
	'CUSTOM_ROUTES'   => 'Rotas personalizadas',
	'DEFAULT_BBCODES' => 'BBcodes predefinidos',
	'FORUM_ROUTES'    => 'Rotas do fórum',
	'NO_PAGES'        => 'Nenhuma página disponível',
	'NO_ROOM'         => 'A sala seleccionada não existe',
	'NO_TEXTS'        => 'Nenhum texto disponível',
	'PAGE_ADD'        => 'Adicionar página',
	'PAGE_ALIAS'      => 'Id da Página',
	'PAGE_URL'        => 'Url da página',
	'ROOM_TITLE'      => 'Título da sala',
	'SELECT_PAGE'     => 'Seleccionar ficheiro',

	'INVALID_FILE'        => 'O ficheiro não existe ou tem um formato inválido.',
	'NO_ALIAS'            => 'O Alias da página é inválido.',
	'PAGE_ALREADY_EXISTS' => 'A página já está em uso.',

	'REMOVE_ROOM_CONFIRM' => 'Tens a certeza de que queres eliminar esta sala e todas as mensagens?',
]);
