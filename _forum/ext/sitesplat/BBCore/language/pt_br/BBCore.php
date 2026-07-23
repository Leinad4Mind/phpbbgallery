<?php

/**
 * @package sitesplat BBcore for phpBB.
 * BBCore [English]
 * @copyright (c) 2015 SiteSplat All rights reserved
 * @license Proprietary
 * @translation Leinad4Mind [Brazilian Portuguese [pt_br]] (2026)
 */

// TRANSLATORS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
//
// Some characters you may want to copy&paste:
// ’ » “ ” …
//

/**
 * DO NOT CHANGE
 */
if (!defined('IN_PHPBB'))
{
	exit;
}
if (empty($lang) || !is_array($lang))
{
	$lang = [];
}

// load addon lang files first...allow BBCore to overwrite if needed
$addon_lang = [];
\sitesplat\load_ext_lang(__DIR__, $addon_lang);
$lang = array_merge($lang, $addon_lang);

// BBCore
$lang = array_merge($lang, [

	'PM_NEW_MSG' => [
		1 => 'Você Tem %d Nova Mensagem Privada',
		2 => 'Você Tem %d Novas Mensagens Privadas',
	],
	'PM_UNREAD_MSG' => [
		1 => 'Você Tem %d Mensagem Privada Não Lida',
		2 => 'Você Tem %d Mensagens Privadas Não Lidas',
	],
	'PM_NEW_MSG_BUBBLE' => [
		1 => '%d',
		2 => '%d',
	],

	'SITESPLAT_EXT'            => 'Outras Extensões',
	'BBCORE_DASHBOARD'         => 'Painel',
	'SITESPLAT_UPDATE_MANAGER' => 'Gerenciador de Atualizações',
	'BBCORE_SETTINGS'          => 'Configurações',
	'BBCORE_FS_REQUIRE'        => '%s requer o SiteSplat Filesystem',
	'BBCORE_MYSQL_REQUIRE'     => '%s requer MySQL',
	'BBCORE_BAD_SERVER'        => 'As configurações do seu servidor são incompatíveis com %s',
	'SS_CHATBOX'               => 'Chat',
	'CHATBOX_MODERATORS'       => 'Moderadores do Chat',
	'BBCORE_MEM'               => '%1$s no total, %2$s em uso',
	'SS_ADDONS'                => 'Addons',
	'SS_ADDON_SETTINGS'        => 'Configurações dos Addons',
	'SS_LID_INFO'              => 'Esta é a sua Chave de Licença SiteSplat. Você precisará digitar esta chave depois de instalar ou atualizar o BBCore.',

	'UCP_MAIN'              => 'Geral',
	'UCP_MAIN_FRONT'        => 'Página Principal',
	'UCP_MAIN_SUBSCRIPTION' => 'Gerenciar Inscrições',
	'UCP_MAIN_BOOKMARKS'    => 'Gerenciar Favoritos',
	'UCP_MAIN_DRAFTS'       => 'Gerenciar Rascunhos',
	'UCP_MAIN_ATTACHMENTS'  => 'Gerenciar Anexos',

	'USER_PANEL'                => 'Painel de Controle',
	'UCP_PROFILE'               => 'Perfil',
	'UCP_PROFILE_PROFILE'       => 'Editar Perfil',
	'UCP_PROFILE_SIGNITURE'     => 'Editar Assinatura',
	'UCP_PROFILE_AVATAR'        => 'Editar Avatar',
	'UCP_PROFILE_SETTINGS'      => 'Detalhes da Conta',
	'UCP_AVATAR_SELECT_OPTIONS' => 'Opções do Avatar',
	'UCP_AVATAR_SELECT_UPLOAD'  => 'Envie o avatar a partir do seu dispositivo',
	'UCP_SUBMIT_TO_UPLOAD'      => 'Clique abaixo para enviar',

	'UCP_PREFERENCE'          => 'Preferências',
	'UCP_PREFERENCE_SETTINGS' => 'Editar configurações pessoais',
	'UCP_PREFERENCE_DEFAULTS' => 'Editar mensagens enviadas',
	'UCP_PREFERENCE_OPTIONS'  => 'Editar exibição de mensagens',

	'UCP_MESSAGES'               => 'Mensagens Privadas',
	'UCP_PM_COMPOSE'             => 'Criar mensagem privada',
	'UCP_PM_DRAFTS'              => 'Gerenciar rascunhos',
	'UCP_PM_INBOX'               => 'Caixa de Entrada',
	'UCP_PM_OUTBOX'              => 'Caixa de Saída',
	'UCP_PM_SENTBOX'             => 'Mensagens Enviadas',
	'UCP_PM_OPTIONS'             => 'Opções (Regras e Pastas)',
	'UCP_NO_USER_CHANGE_ALLOWED' => '**Não é permitido alterar o Nome de Usuário**',
	'UCP_REGISTER_EMAIL_EXPLAIN' => 'Por favor, não utilize e-mails descartáveis',
	'UCP_USERGROUPS_EXPLAIN'     => '(Escolha um grupo e depois clique em Adicionar)',

	'WIDTH_SIZE'  => 'largura',
	'PIXEL_SIZE'  => 'px',
	'HEIGHT_SIZE' => 'altura',

	'UCP_GROUPS'            => 'Grupos de Usuários',
	'UCP_GROUPS_MEMBERSHIP' => 'Editar Inscrições em Grupos',
	'UCP_GROUPS_MANAGE'     => 'Gerenciar grupos',

	'UCP_ZEBRA'                   => 'Amigos e Inimigos',
	'UCP_ZEBRA_FRIENDS'           => 'Gerenciar Amigos',
	'UCP_ZEBRA_FOES'              => 'Gerenciar Inimigos',
	'UCP_APPLY'                   => 'Alterar',
	'UCP_PM_DEFAULT_RULE_TAG'     => 'Ação Padrão',
	'UCP_PM_DEFAULT_RULE'         => 'Não serão aceitas novas Mensagens',
	'UCP_PM_DEFAULT_RULE_EXPLAIN' => 'Esta ação será disparada se nenhuma das regras acima for aplicável. As Mensagens novas serão retidas até haver espaço disponível',
	'UCP_PM_NEW_MESSAGE'          => 'Nova Mensagem',
	'BIO'                         => 'Informações Pessoais',
	'MANAGE'                      => 'Gerenciar',
	'JOINED_BOARD'                => 'Entrou no Fórum',
	'VISITED_BOARD'               => 'Última visita',
	'SEE_MORE'                    => 'Mais',
	'ATTACH_SIGNATURE'            => 'Anexar assinatura',
	'BBCODES'                     => 'BBcodes',

	'DELETE_POST_SOFT'           => 'Enviar Mensagem para a Lixeira',
	'DELETE_POST_PERMANENT'      => 'Excluir Mensagem Permanentemente ',
	'DELETE_POST_SOFT_WARN'      => 'Poderá ser recuperada',
	'DELETE_POST_PERMANENT_WARN' => 'NÃO poderá ser recuperada',

	'POLL_MAX_OPTIONS_EXPLAIN_ALT' => 'Digite o número máx. de opções que o usuário poderá selecionar',
	'POLL_VOTE_CHANGE_LABEL'       => 'Permitir Alterar Voto',
	'NO_VOTES_NA'                  => 'N/A',
	'NOT_AVAILABLE'                => 'Indisponível',
	'POST_TOPIC_NEW'               => 'Novo Tópico',
	'QUICK_REPLY_SHOW_HIDE'        => 'Mostrar/Ocultar Resposta Rápida',
	'CHARACTERS_COUNT'             => 'Caracteres',
	'CHARACTERS_COUNT_REM'         => 'Restantes',
	'BOOKMARKED_TOPICS_UCP'        => 'Tópicos favoritos',
	'ATTACH_EXPLANATION_SORTABLE'  => 'Clique para ordenar',
	'ATTACH_FORUM'                 => 'Anexo(s)',
	'MCP_DETAILS_LOG'              => 'Detalhes',
	'MCP_DETAIL_U_IP'              => 'Usuário &amp; IP',
	'MCP_MANAG_BAN'                => 'Gerenciar Banimentos',
	'MCP_UNAPPROVED_POSTS_ZERO'    => 'Não existem mensagens aguardando aprovação',
	'MCP_REPORTS_ZERO'             => 'Não existem denúncias para revisar',
	'MCP_PM_REPORTS_ZERO'          => 'Não existem denúncias de Mensagens Privadas para revisar',


	'SUBFORUM_LINK'             => 'O link abre em uma nova aba',
	'FORUMLIST_UNAPPROVED'      => 'Pelo menos um tópico neste fórum não foi aprovado',
	'FORUMLIST_UNAPPROVED_POST' => 'Pelo menos uma mensagem neste fórum não foi aprovada',
	'FORUMLIST_LASTPOST'        => 'Ver a última mensagem',
	'TOPICS_POSTS_STATISTICS'   => 'Estatísticas',
	'TOPICS_ROW_REPORTED'       => 'Este tópico foi denunciado',
	'TOPICS_ROW_NOT_APPROVED'   => 'Este tópico não foi aprovado',
	'TOPICS_ROW_DELETED'        => 'Este tópico foi excluído',
	'MODERATOR_PANEL_GENERAL'   => 'Painel de Moderação',
	'ADMIN_PANEL_GENERAL'       => 'Painel de Administração',
	'RANK_IMAGE'                => 'Imagem de Rank',

	'WELCOME_INDEX'     => 'Bem-vindo',
	'FAQ'               => 'FAQ',
	'CAPTION_FAQ'       => 'Perguntas Mais Frequentes',
	'CAPTION_SEARCH'    => 'Procure primeiro!',
	'CAPTION_MEMBERS'   => 'Procurando alguém?',
	'MEMBERS_CAP'       => 'Membros',
	'CAPTION_UCP'       => 'Defina suas preferências',
	'UCP_CAP'           => 'Painel de Controle do Usuário',
	'INDEX_CAPTION'     => 'Esta é a página inicial do fórum',
	'VIEWTOPIC_CAP'     => 'Título do Tópico',
	'CAPTION_VIEWTOPIC' => 'Descrição do Tópico',
	'CAPTION_VIEWFORUM' => 'Navegue por todas as categorias do fórum',
	'POSTINGS_CAP'      => 'Editor de Mensagens',
	'CAPTION_POSTINGS'  => 'Postando coisas!',

	'MCP_CAPTION'               => 'É aqui que você pode usar seus Super-Poderes ;-)',
	'BOOTSTRAP_ELEMENT'         => 'Elementos Bootstrap',
	'BOOTSTRAP_ELEMENT_CAPTION' => 'Documentação do Fórum KickStart',
	'MAIN_FORUM'                => 'Fórum',
	'MAIN_MAIN_STUFF'           => 'As coisas principais',
	'MAIN_TRENDS'               => 'Veja as tendências',

	'MAIN_SEARCH_IT_UP' => 'Procure primeiro',
	'SUB_NO_ICON'       => 'Nenhum ícone encontrado aqui',
	'EXAMPLE_WITH_ICON' => 'Exemplo com Ícone',
	'EXAMPLE_LINK'      => 'Exemplo de Link',
	'MAIN_SOCIAL'       => 'Social',
	'SOCIAL_P'          => 'Bata um papo ;-)',

	'MORE'             => 'Mais',
	'EXPAND_CLOSE'     => 'Fechar Visualização',
	'MARK_TOPICS_READ' => 'Marcar tópicos como lidos',
	'CONTACT'          => 'Contato',
	'GET_IN_TOUCH'     => 'Entre em contato',
	'HANG_AROUND'      => 'Participe',
	'JOIN_THE_CLUB'    => 'Junte-se ao clube',
	'MENU'             => 'MENU',
	'YOU_ARE_HERE'     => 'Você está aqui',
	'IN_FOOTER'        => 'Em:',
	'REPLY'            => 'Resposta',

	'LOGIN_REMEMBER'   => 'Manter conectado',
	'LOGIN_HIDE_ME'    => 'Ocultar sessão',
	'LOGIN_ME_IN'      => 'Entrar',
	'SIGN_IN_ACCOUNT'  => 'Entrar na conta',
	'CREATE_ACCOUNT'   => 'Criar Conta',
	'GO_TO_SEARCH_ADV' => 'Voltar à busca avançada',

	'CREATE_ACCOUNT_DISABLED' => 'Os registros estão fechados',
	'REGISTRATION_DISABLED'   => 'Parece que os registros estão fechados no momento. Isso também pode ser uma medida temporária. Se você acredita que isto é um possível erro, por favor entre em contato com o webmaster e avise-o. Pedimos desculpas por qualquer inconveniente que isto possa ter causado. Nossa Política de Privacidade e Termos de Uso estão disponíveis abaixo.',
	'CONTACT_WEBMASTER'       => 'Contatar o Administrador',
	'CONFIRM_QA_EXPLAIN_ALT'  => 'Prove que você é humano e responda a esta pergunta',

	'PLUPLOAD_PLACE_INLINE' => 'Adicionar',
	'PLUPLOAD_DELETE_FILE'  => 'Excluir',


	'REG_CREATING'   => 'Criando Perfil...',
	'LOADING'        => 'Carregando...',
	'SAVING'         => 'Salvando...',
	'CANCELLING'     => 'Cancelando...',
	'SENDING'        => 'Enviando...',
	'SEARCHING'      => 'Buscando...',
	'LOADING_LOG_IN' => 'Conectando...',
	'FILE_UPLOADING' => 'Enviando Arquivo...',
	'CASTING_VOTE'   => 'Enviando Voto...',
	'LOADING_FORM'   => 'Carregando Formulário...',

	'MEMBERLIST_P_JOINED'      => 'Registrou-se no fórum',
	'MEMBERLIST_P_EXPL'        => 'Quando me registrei no fórum',
	'MEMBERLIST_P_DATE_EXPL'   => 'Última vez que visitei o fórum',
	'SPAMMER'                  => 'Spammer',
	'SPAMMER_PLACEHOLDER'      => 'Você não pode simplesmente fazer Spam e sair impune!',
	'MARK_PLACEHOLDER'         => 'Marque sua escolha',
	'INFO_BOX'                 => 'Informações:',
	'USER_REMOVE_PLACEHOLDER'  => 'Clique para remover o usuário',
	'GROUP_REMOVE_PLACEHOLDER' => 'Clique para remover o grupo',
	'EDIT_LINK_PLACEHOLDER'    => 'Esqueci de colocar código nos meus links',
	'POST_IT_UP_PLACEHOLDER'   => 'Enviar!',

	'UCP_REG_USR_PLACEHOLDER'    => 'Ex.: John Doe',
	'UCP_REG_EMAIL_PLACEHOLDER'  => 'Ex.: john@mail.com',
	'UCP_REG_PSWD_PLACEHOLDER'   => 'Ex.: ASDFasdf123',
	'UCP_REG_CTCHA_PLACEHOLDER'  => 'Ex.: céu dourado',
	'SEARCH_USR_PLACEHOLDER'     => 'Ex.: GoldTugAnime',
	'YEAR_MONTH_DAY_PLACEHOLDER' => 'Ex.: 2018-12-22',
	'IP_PLACEHOLDER'             => 'Ex.: 216.161.111.33',
	'POSTS_PLACEHOLDER'          => 'Ex.: 12',
	'SEARCH_KWDS_PLACEHOLDER'    => 'Ex.: gatos, ou gatos+, ou gatos-, ou gatos|cães, ou gat*',

	'MESSAGE_ENTER_PLACEHOLDER'  => 'Digite sua mensagem...',
	'FILE_COMMENT_PLACEHOLDER'   => 'Comente seu arquivo',
	'HEIGTH_PLACEHOLDER'         => 'altura',
	'WIDTH_PLACEHOLDER'          => 'largura',
	'UCP_OCCUPATION_PLACEHOLDER' => 'Descreva brevemente sua ocupação...',
	'UCP_INTERESTS_PLACEHOLDER'  => 'Descreva seus interesses...',
	'SOFT_DELETE_PLACEHOLDER'    => 'Adicione seus motivos, caso deseje...',
	'ADD_DESCRIPTION'            => 'Adicionar descrição',

	'FILE_SELECT'                 => 'Selecione o arquivo',
	'FILE_CHANGE'                 => 'Alterar',
	'SELECT_IMAGE'                => 'Selecione a imagem',
	'NOTE'                        => 'Observação',
	'EDIT_DRAFT'                  => 'Editar Rascunho',
	'PM_BALOON_NOTIFICATION'      => 'Ativar notificação de MP (Mensagem Privada) via Pop-Up',
	'MARK_ALL_NOTIFICATIONS_READ' => 'Marcar todas como lidas',
	'DAYS_AGO'                    => 'Dias atrás',
	'WORK_IN_PROGRESS'            => 'Manutenção',
	'DISABLE_MESSAGE'             => 'Fórum indisponível',
	'DISABLE_RETURN'              => 'Voltar à página inicial',
	'BOARD_DISABLED_SHUFFLE'      => 'Divirta-se e embaralhe algumas letras :-)',
	'DISABLE_TEXT_TRY'            => 'Teste você mesmo!',
	'DISABLE_TEXT_TYPE'           => 'Digite algo e pressione enter...',

	'GRAVATAR_EXPLAIN'         => 'Se um <a href="//en.gravatar.com/" target="_blank">GRAVATAR</a> estiver associado ao seu endereço de e-mail, ele será usado por padrão.',
	'GRAVATAR_EXPLAIN_CONFIRM' => 'Por favor, confirme seu endereço de e-mail aqui',

	'DELETE_POLL'           => 'Excluir Votação',
	'POLL_DELETE_HELPER'    => '(Isto exclui apenas a votação) marque e envie',
	'JUMP_TO_POST'          => 'Ir para a mensagem',
	'JUMP_SELECT_FORUM'     => 'Selecione o Fórum para onde ir',
	'JUMP_TO_PAGE_NUMBER'   => 'Ir para a página #',
	'VIEW_FIRST_UNREAD'     => 'Ver primeira mensagem não lida',
	'BOOKMARK_TOPIC_REMOVE' => 'Remover dos favoritos',

	'NEW_MESSAGES'           => 'Novas mensagens',
	'YOU_HAVE'               => 'Você tem',
	'AND'                    => 'e',
	'HELLO'                  => 'Olá',
	'DISMISS_PM'             => 'Adiar 5 minutos',
	'READ_NOW'               => 'Ler agora',
	'PRIVATE_MESSAGE_NEW'    => 'nova mensagem privada',
	'PRIVATE_MESSAGE_UNREAD' => 'mensagem privada não lida',
	'NO_PMS_INFO'            => 'Tudo em dia! Escrever nova MP?',

	'DATES'       => 'DATA',
	'POWERED'     => 'Desenvolvido com',
	'HANDCRAFTED' => 'Feito à Mão Com',
	'BY'          => 'Por',

	'RECENT_TOPICS' => 'Tópicos recentes',
	'TWITTER'       => 'Twitter',
	'FAVORITES'     => 'Favoritos',

	'GALLERY'          => 'Galeria',
	'CHAT'             => 'Chat',
	'ABOUT'            => 'Sobre Nós',
	'ABOUT_PART_ONE'   => 'BBOOTS&#8482; é o primeiro e único Tema HTML5/CSS3 não-oficial totalmente responsivo para PhpBB&reg;. Seu design limpo e nítido é INCRÍVEL em todos os navegadores e dispositivos.',
	'ABOUT_PART_TWO'   => 'Utiliza um layout baseado no Bootstrap, muito aguardado, e que certamente vai surpreender os fãs do phpBB.',
	'ABOUT_PART_THREE' => 'O Tema Responsivo Não-Oficial',
	'BB'               => 'B',
	'BOOTS'            => 'BOOTS',
	'BBOOTS'           => 'BBOOTS',

	'BBOOTS_VERSION' => '<a href="http://www.sitesplat.com/phpBB3/">BBOOTS</a>',
	'U_LOGOUT'       => 'Sair',

	'SITESPLAT_STATISTICS'      => 'Estatísticas',
	'SITESPLAT_SEE_DETAILS'     => 'Ver detalhes',
	'SITESPLAT_SEARCH_LAST_DAY' => 'Mensagens das últimas 24h',
	'SITESPLAT_SEARCH_WEEK'     => 'Mensagens dos últimos 7 dias',

	'SITESPLAT_TOTAL_POSTS'       => 'Total de mensagens',
	'SITESPLAT_TOTAL_TOPICS'      => 'Total de tópicos',
	'SITESPLAT_TOTAL_USERS'       => 'Total de usuários',
	'SITESPLAT_NEWEST_MEMBER'     => 'Membro mais novo',
	'SITESPLAT_USERS_ONLINE'      => 'Usuários Online',
	'SITESPLAT_MOST_USERS_ONLINE' => 'Recorde de Usuários Online',
	'SITESPLAT_BIRTHDAYS'         => 'Aniversariantes de hoje',

	'BOOTSTRAP_VERSION' => '3.3.6',
	'FLATBOOTS'         => 'FLATBOOTS',
	'CHANGE_AVATAR'     => 'Alterar Avatar',
	'CHANGE_PASSWORD'   => 'Alterar Senha',

	'ADMIN_TIPS'         => 'Dicas e Truques do Administrador',
	'ADMIN_TIP_INTRO'    => 'Você sabia que pode tornar seu fórum phpBB ainda mais seguro com alguns passos simples?',
	'ADMIN_TIP_ONE'      => 'Mantenha seu software atualizado.',
	'ADMIN_TIP_TWO'      => 'Use sempre senhas fortes que contenham sequências aleatórias de letras, números e caracteres especiais.',
	'ADMIN_TIP_THREE'    => 'Restrinja o acesso à pasta de administração...',
	'ADMIN_CHECK_IT_BTN' => 'Visite SiteSplat.com para saber mais',

	'USER_MINI_PROFILE'           => 'Mini-perfil do usuário',
	'USER_MINI_PROFILE_VIEW_FULL' => 'Ver perfil completo',
	'OFF_LINE'                    => 'Off-line',
	'USER_STATUS'                 => 'Status',
	'USER'                        => 'Usuário',
	'TITLE'                       => 'Título',
	'END_TIMELINE'                => 'Fim da linha do tempo',
	'MEMBERS'                     => 'Membros',
	'DRAFTS'                      => 'Rascunhos',
	'REPORTS'                     => 'Denúncias',
	'MODERATOR_LOGS'              => 'Registros de Moderador',
	'QUEUE'                       => 'Fila',
	'LINKS'                       => 'Links',
	'TOPIC_PERMISSIONS'           => 'Permissões do tópico',
	'MODERATOR_OPTIONS'           => 'Moderar',
	'PASSWORD_EXPLAIN_CONFIRM'    => 'Certifique-se de que corresponde',
	'FORUM_REDIRECTS'             => 'Redirecionamentos:',

	'FANCY_TOPICS_TITLE' => 'Tópicos recentes do fórum',
	'POST_BY'            => 'Postado por',
	'REPLY_BY'           => 'Respondido por',
	'NO_REPLIES'         => 'Sem respostas',
	'READ_MORE'          => 'Ler mais',
	'RT_READ_MORE'       => 'LER MAIS',
	'VIEW_MORE_TOPICS'   => 'VER MAIS TÓPICOS',
	'BACK_TO_START'      => 'VOLTAR AO INÍCIO',

	'TOGGLE_NAV' => 'Alternar Navegação',
	'NAVIGATION' => 'Navegação',

	'DEMO_LINK'        => 'Link de demonstração sem ícones',
	'DEMO_HEADER_MENU' => 'Exemplo de introdução no cabeçalho',

	'FLATBOOTS_INTRO'          => 'Bootstrap Framework',
	'FLATBOOTS_EXPLAIN'        => 'Mais de uma dúzia de componentes reutilizáveis criados para fornecer iconografia, menus suspensos, grupos de campos, navegação, alertas e muito mais...',
	'CALL_TO_ACTION_FOOTER'    => 'Ative e desative addons, use apenas o que você realmente precisa!',
	'PURCHASE_NOW_BTN'         => 'Compre agora',
	'FLATBOOTS_ABOUT_PART_ONE' => 'Por que se contentar com menos quando você pode ter mais? Não deixe que outros autores te enganem com palavras de marketing vazias. O FLATBOOTS é o que você merece. Construído para durar, construído do zero, nada menos.',
	'FLATBOOTS_ABOUT_TITLE'    => 'Construído para durar',
	'DMCA'                     => 'DMCA',
	'TERMS'                    => 'Termos',
	'ADVERTISE'                => 'Anuncie',
	'SITESPLAT'                => 'SiteSplat',
	'SITESPLAT_URL'            => '<a href="https://sitesplat.com" class="btn btn-default" target="blank" rel="noopener">SiteSplat.com</a>',
	'SS_URL'                   => '<a href="https://sitesplat.com/" title="SiteSplat Premium Themes" target="_blank" rel="noopener">SiteSplat</a>',
	'PHPBB_CREDIT'             => 'Desenvolvido com <a href="https://www.phpbb.com/" title="Forum Software &copy; phpBB&reg; Group" target="_blank" rel="noopener">phpBB</a> e ',
	'SS_HANDCRAFTED'           => '<a href="https://sitesplat.com/" title="SiteSplat Premium Themes and Extensions" target="_blank" rel="noopener">SiteSplat</a>, feito à mão com <i class="fa fa-heart text-flatboots-red"></i> e <i class="fa fa-coffee"></i>',
	'JOIN_US_TWITTER'          => 'Junte-se a nós no Twitter',
	'TWEET_EXAMPLE'            => 'O BBOOTS chegou a 2000 vendas! Obrigado a todos que apoiam este projeto incrível e contribuem para construir a comunidade SiteSplat. O que vem a seguir? Fique ligado e me siga no Twitter: <a href="#">http://bit.ly/000fefs</a>',
]);
