<?php

/**
 * @package BBSidebar for phpBB.
 * @copyright (c) 2015 SiteSplat All rights reserved
 * @license Proprietary
 * @translation Leinad4Mind [Portuguese [pt]] (2026)
 */

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = [];
}

$lang = array_merge($lang, [
	// ACP
	'ACP_SIDEBAR_TITLE'  => 'Configurações da BBsidebar',
	'AD_SIDEBAR_EXPLAIN' => 'Configure opções e blocos da BBsidebar. Existem muitas configurações possíveis e, com a utilização de blocos personalizados, não existem limites, pois suporta HTML. Também pode optar por ativar ou desativar completamente os blocos para telemóveis e tablets.<br/> Tenha em atenção que, <strong>a atividade dos blocos é armazenada em cache durante 5 minutos</strong> para melhorar o desempenho do servidor. Para ver as alterações imediatamente, terá de limpar a cache do fórum a partir do ACP > Geral : Limpar a Cache.',

	'ACP_SIDEBAR_HEADSUP'         => 'Atenção (Heads up)',
	'ACP_SIDEBAR_HEADSIP_EXPLAIN' => 'O bloco de tipo <strong>Personalizado (Custom)</strong> permite a utilização de HTML. <br />O bloco de tipo <strong>Equipa (Staff) online</strong> mostrará os membros da equipa online no fórum. Crie um novo grupo de utilizadores designado "staff" em "Utilizadores e Grupos" &#187; "Gerir grupos" &#187; "Criar novo grupo" e, em seguida, introduza o nome de utilizador das pessoas que gostaria de exibir como equipa (staff) online no bloco.<br />O bloco de tipo <strong>Tópicos populares</strong> segue as definições do fórum para o "tópico popular" em: "Geral" &#187; "Configuração do Fórum" &#187; "Definições de mensagens" &#187; "Limite para tópico popular"<br /><strong>Outros Blocos</strong> Outros tipos de blocos ficam disponíveis após a extensão (addon) Premium correspondente ter sido ativada. Pode encontrar muitas extensões (addons) premium aqui: <a href="https://sitesplat.com/phpBB3/marketplace.php"><strong>Marketplace</strong></a>.',

	'ACP_SIDEBAR_CONFIG'   => 'BBsidebar',
	'ACP_SIDEBAR_OPTIONS'  => 'Opções da BBsidebar',
	'ACP_SIDEBAR_SETTINGS' => 'Configurações da BBsidebar',
	'ACP_SIDEBAR_SAVED'    => 'Alterações Guardadas.',

	'ACP_SIDEBAR_SLOTS'         => 'Espaço na barra lateral (Slot)',
	'ACP_SIDEBAR_SLOTS_EXPLAIN' => 'Defina quantos slots quer utilizar. O máximo é 10',
	'ACP_SIDEBAR_SLOT'          => 'Slot ativo',

	'ACP_SIDEBAR_PANEL_PAGES'         => 'Ver a barra lateral nas páginas de configuração',
	'ACP_SIDEBAR_PANEL_PAGES_EXPLAIN' => 'Ative ou desative a barra lateral no UCP, MCP e nas páginas de registo',
	'ACP_SIDEBAR_ALL_PAGES'           => 'Ver a barra lateral em todas as páginas',
	'ACP_SIDEBAR_ALL_PAGES_EXPLAIN'   => 'Defina como SIM para que os blocos laterais sejam exibidos em qualquer página do fórum, NÃO para ter a barra lateral apenas no índice. <br />(NOTA: A BBsidebar é automaticamente desativada nas seguintes extensões: BBdownloads, BBfront, BBgallery e BBclassifieds independentemente das configurações SIM/NÃO.)',
	'ACP_SIDEBAR_SHUFFLE'             => 'Baralhar blocos',
	'ACP_SIDEBAR_SHUFFLE_EXPLAIN'     => 'Defina como SIM para randomizar os blocos a cada atualização de página',

	'ACP_SIDEBAR_WIDTH'         => 'Largura da barra lateral',
	'ACP_SIDEBAR_WIDTH_EXPLAIN' => 'Escolha a largura da barra lateral padrão',

	'ACP_SIDEBAR_HEIGHT'         => 'Altura dinâmica:',
	'ACP_SIDEBAR_HEIGHT_EXPLAIN' => 'Se a altura dinâmica for definida como SIM, a altura do fórum será calculada e os blocos laterais <strong>nunca serão mais compridos</strong> do que o fórum',
	'ACP_SIDEBAR_HEIGHT_N'       => 'Não',

	'ACP_SIDEBAR_WIDTH_15' => '15%',
	'ACP_SIDEBAR_WIDTH_20' => '20%',
	'HOWMANY'              => 'Quantos registos',
	'HOWMANY_EXPLAIN'      => 'Defina quantos registos gostaria de exibir. O máximo é 10',
	'IGNORE'               => 'Ignorar',
	'IGNORE_EXPLAIN'       => 'Exclua utilizadores inativos, administradores e moderadores globais dos registos da barra lateral. (NÃO os blocos)',
	'IGNORE_USERS'         => 'Ignorar utilizadores inativos',
	'IGNORE_FOUNDER'       => 'Ignorar o(s) fundador(es)',
	'IGNORE_ADMINS_MODS'   => 'Ignorar Administradores e Moderadores',

	'ACP_TITLE_SLOT'           => 'Título do Slot',
	'ACP_TITLE_SLOT_EXPLAIN'   => 'Introduza o título do slot',
	'ACP_SIDEBAR_TEXT'         => 'Inserir o código HTML',
	'ACP_SIDEBAR_TEXT_EXPLAIN' => 'Código HTML',

	'ACP_SIDEBAR_TYPE'         => 'Alternar a barra lateral',
	'ACP_SIDEBAR_TYPE_EXPLAIN' => 'Mostrar a barra lateral à esquerda ou à direita',
	'LEFT'                     => 'Lado esquerdo',
	'RIGHT'                    => 'Lado direito',
	'SHOW_MOBILE'              => 'Mostrar no telemóvel',
	'SHOW_TABLET'              => 'Mostrar no tablet',
	'SHOW_TYPE'                => 'Tipo de bloco',

	'SIDEBAR_DESCRIPTION_PAGE'          => 'Página da barra lateral',
	'SIDEBAR_DESCRIPTION_PAGE_OVERVIEW' => 'Uma barra lateral no seu fórum, comutável e configurável',
	'SIDEBAR_DESCRIPTION_PAGE_STATUS'   => 'Esquerda - Direita, Largura e blocos predefinidos',
	'SIDEBAR_DESCRIPTION_PAGE_ABILITY'  => 'Totalmente personalizável',
	'SIDEBAR_DEVELOPERS'                => 'Desenvolvedores',

	'SIDEBAR_TYPE_NOT_EXIST' => 'O tipo de barra lateral `%1$s` não existe.',
	'NOTICE_BADGE'           => 'A extensão <a href="https://sitesplat.com/phpBB3/marketplace.php?mode=view&item_id=24"><strong>BBAwards</strong></a> não está instalada, pelo que NÃO poderá utilizar o bloco de tipo BBAwards.',
	'NOTICE_BBDONATION'      => 'A extensão <a href="https://sitesplat.com/phpBB3/marketplace.php?mode=view&item_id=44"><strong>BBDonation</strong></a> não está instalada, pelo que NÃO poderá utilizar o bloco de tipo Donations (Doações).',
	'NOTICE_BBMEMBERSHIP'    => 'A extensão <a href="https://sitesplat.com/phpBB3/marketplace.php?mode=view&item_id=31"><strong>BBMembership</strong></a> não está instalada, pelo que NÃO poderá utilizar o bloco de tipo Membership (Assinaturas).',
	'NOTICE_BBPOINTS'        => 'A extensão <a href="https://sitesplat.com/phpBB3/marketplace.php?mode=view&item_id=22"><strong>BBpoints</strong></a> não está instalada, pelo que NÃO poderá utilizar o bloco de tipo BBpoints.',
	'NOTICE_BBREACTION'      => 'A extensão <a href="https://sitesplat.com/phpBB3/marketplace.php?mode=view&item_id=27"><strong>BBreaction</strong></a> não está instalada, pelo que NÃO poderá utilizar o bloco de tipo BBreaction.',
	'NOTICE_LIKEDD'          => 'A extensão <a href="https://sitesplat.com/phpBB3/marketplace.php?mode=view&item_id=22"><strong>LikeBB</strong></a> não está instalada, pelo que NÃO poderá utilizar o bloco de tipo LikeBB.',
	'NOTICE_NEWSLETTER'      => 'A extensão <a href="https://sitesplat.com/phpBB3/marketplace.php?mode=view&item_id=21"><strong>E-mail Subscribers</strong></a> não está instalada, pelo que NÃO poderá utilizar o bloco de tipo E-mail Subscribers (Subscritores de email).',
	'NOTICE_BBDOWNLOAD'      => 'A extensão <a href="https://sitesplat.com/phpBB3/marketplace.php"><strong>BBdownloads</strong></a> não está instalada, pelo que NÃO poderá utilizar o bloco de tipo Download.',
	'SIDEBAR_NOTICE'         => '<div style="width:auto;margin:20px auto;"><p>A Configuração para esta extensão encontra-se em <strong>%1$s » %2$s » %3$s</strong>.</p></div>',
	'SS_HELPER_NOTY'         => 'O addon BBcore não existe!<br />Faça o download do <a href="#">BBcore</a> e copie a pasta para a sua pasta de extensões sitesplat.',

	'SIDEBAR_TYPE_BBPOINTS'         => 'BBpoints',
	'SIDEBAR_TYPE_LAST_BADGES'      => 'Últimos emblemas',
	'SIDEBAR_TYPE_LAST_BBREACTIONS' => 'Últimas BBreactions',
	'SIDEBAR_TYPE_LAST_MEMBERS'     => 'Últimos membros',
	'SIDEBAR_TYPE_LIKEDD'           => 'Últimos gostos (Likes)',
	'SIDEBAR_TYPE_BIRTHDAY'         => 'Aniversários',
	'SIDEBAR_TYPE_CALENDAR'         => 'Calendário',
	'SIDEBAR_TYPE_TOP_POSTERS'      => 'Top posters (Principais Publicadores)',
	'SIDEBAR_TYPE_STAFF'            => 'Equipa (Staff) online',
	'SIDEBAR_TYPE_DONATIONS'        => 'Doações',
	'SIDEBAR_TYPE_MEMBERSHIP'       => 'Assinaturas (Membros VIP)',
	'SIDEBAR_TYPE_TOP_TOPICS'       => 'Últimos tópicos',
	'SIDEBAR_TYPE_HOT_TOPICS'       => 'Tópicos populares',
	'SIDEBAR_TYPE_CLOCK'            => 'Relógio',
	'SIDEBAR_TYPE_POLL'             => 'Última votação',
	'SIDEBAR_TYPE_NEWSLETTER'       => 'Newsletter',
	'SIDEBAR_TYPE_BBDOWNLOADS'      => 'BBdownloads',

	'ONE_S' => 'S',
	'ONE_I' => 'I',
	'ONE_D' => 'D',
	'ONE_E' => 'E',
	'ONE_B' => 'B',
	'ONE_A' => 'A',
	'ONE_R' => 'R',


	'SITESPLAT_COM'            => 'https://sitesplat.com',
	'SITESPLAT_COPY'           => '&#169; SiteSplat',
	'LICENSE_INFO'             => 'Proprietário - SiteSplat Todos os direitos reservados',
	'EXTENSION_DEVELOPER'      => 'Desenvolvedor',
	'ACP_SIDEBAR_NOTICE_CLOSE' => 'Fechar',

	'ACP_SIDEBAR_VERSION' => '1.4.7',
	'ACP_LOADING'         => 'A Carregar... Aguarde',

	'FORUM_CONTENT'            => 'conteúdo do fórum',
	'SIDEBAR_DESCRIPTION_PAGE' => 'Esta extensão adiciona um sistema flexível multi-bloco para o seu fórum. Toneladas de opções disponíveis e vem com muitos blocos modernos por predefinição',
	'SIDEBAR_TASKS_1'          => 'Blocos Modernos',
	'SIDEBAR_TASKS_2'          => 'Sistema de grelha Bootstrap',
	'SIDEBAR_TASKS_3'          => 'Regras a ignorar',
	'SIDEBAR_TASKS_4'          => 'Opções de ajuste fino, como opções para telemóvel e tablet',
	'SIDEBAR_TASKS_5'          => 'Expansível com suporte para muitos addons Premium. Veja os addons premium em <a href="https://sitesplat.com/phpBB3/marketplace.php">sitesplat.com/marketplace.php</a>',
	'SIDEBAR_TASKS_6'          => 'E muito mais..!'
]);
