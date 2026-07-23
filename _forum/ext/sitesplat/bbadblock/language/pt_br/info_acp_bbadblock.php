<?php

/**
 * BBadblock extension for the phpBB Forum Software package.
 * @copyright (c) 2015 SiteSplat All rights reserved
 * @license Proprietary
 * @translation Leinad4Mind [Brazilian Portuguese [pt_br]] (2026)
 */

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

$lang = array_merge($lang, [
	'ACP_BBADBLOCK'                      => 'BBadblock',
	'ACP_BBADBLOCK_INDEX_TITLE'          => 'Configurações do BBadblock',
	'ACP_BBADBLOCK_EXPLAIN'              => 'Os adblocks são tão incômodos quanto os próprios anúncios :) para o Administrador do fórum, e vão fazer você perder receita. <br />O BBadblock vai contrariar os usuários de adblock e atrapalhar a experiência no fórum, para que o usuário acabe adicionando seu fórum à lista de permissões. Opções inteligentes disponíveis, como mensagens modais, ocultar posts, etc...',
	'ACP_BBADBLOCK_ADS_EXPLAIN'          => '<br />Se os Anúncios não estiverem habilitados, você deve preencher o nome da classe onde seus anúncios estarão.',
	'ACP_BBADBLOCK_BBMEMBERSHIP_EXPLAIN' => '<br />Se o BBmembership estiver habilitado, você pode usar um dos grupos de membros para desabilitar o bloqueador de anúncios. O grupo de usuário deve então ser o padrão para o membro.',

	'BBADBLOCK_NOTICE' => '<div class="phpinfo"><p>As configurações desta extensão encontram-se em <strong>%1$s &#187; %2$s &#187; %3$s</strong>.</p></div>',
	'SS_HELPER_NOTY'    => 'O SiteSplat BBcore não existe!<br />Baixe o <a href="http://sitesplat.com" target="_blank">BBcore</a> e copie a pasta BBcore para a pasta da sua extensão sitesplat.',

	'BBADBLOCK_CLASSNAME'                   => 'Nome da Classe',
	'BBADBLOCK_CLASSNAME_EXPLAIN'           => 'Nome da classe div onde estão seus anúncios. <br /> Você não deve alterar isto a menos que saiba o que está fazendo. <br /> Envolva seus anúncios em blocos DIV com a classe aqui inserida. <br />Por padrão, os anúncios de teste estão em: <br /><strong class="small">- /ext/sitesplat/bbadblock/styles/FLATBOOTS/template/event/overall_footer_content_after.html</strong> <br /><strong class="small">- /ext/sitesplat/bbadblock/styles/FLATBOOTS/template/event/viewtopic_body_postrow_post_after.html</strong>',
	'BBADBLOCK_REDIRECT'                    => 'Página de Redirecionamento',
	'BBADBLOCK_REDIRECTE_EXPLAIN'           => 'URL de redirecionamento para onde o usuário será forçado quando qualquer plugin de bloqueio de anúncios estiver habilitado. Verifique as regras de rewrite do seu servidor se algo não estiver funcionando ou se for mostrado ao usuário o erro "muitos redirecionamentos". <br />Por exemplo: <strong>/forum/memberships.php</strong>',
	'BBADBLOCK_MESSAGE'                     => 'Mensagem Modal Ajax',
	'BBADBLOCK_MESSAGE_EXPLAIN'             => 'Insira a mensagem que você gostaria de exibir aos usuários que têm o bloqueador de anúncios habilitado',
	'BBADBLOCK_MODAL_ALERT'                 => 'Mostrar Modal Ajax',
	'BBADBLOCK_MODAL_ALERT_EXPLAIN'         => 'Mostra o Modal Ajax quando o usuário está usando um bloqueador de anúncios',
	'BBADBLOCK_AUTO_RESET'                  => 'Reiniciar Automaticamente a Contagem de Páginas',
	'BBADBLOCK_AUTO_RESET_EXPLAIN'          => 'Quando definido como SIM, o plugin vai contar cada visualização de página para cada usuário com o bloqueador de anúncios habilitado, e quando o usuário finalmente desabilitar o bloqueador, terá que visualizar as páginas tantas vezes quantas visualizou anteriormente com o bloqueador habilitado, até a contagem chegar a zero, para poder ver todos os posts. DESABILITADO desliga o contador.<br /> <strong>OBSERVAÇÃO</strong>: Esta opção destina-se a incomodar o usuário e a praticamente forçá-lo a desabilitar o bloqueador de anúncios, caso contrário a experiência no fórum será extremamente perturbadora. Use por sua conta e risco.',
	'BBADBLOCK_EXCLUDE_GROUP'               => 'Exclusão de Grupo do BBmembership',
	'BBADBLOCK_EXCLUDE_GROUP_EXPLAIN'       => 'Grupo de membros que NÃO será afetado pelas funções do BBadblock.',
	'BBADBLOCK_EXCLUDE_HIDE_FORUMS'         => 'Exclusão de Fóruns',
	'BBADBLOCK_EXCLUDE_HIDE_FORUMS_EXPLAIN' => 'Todos os posts, exceto o primeiro, serão ocultados quando o usuário tiver um bloqueador de anúncios habilitado, com exceção dos fóruns aqui selecionados',
	'BBADBLOCK_BLOCKED_SINCE'               => 'Usando bloqueador de anúncios desde',
	'BBADBLOCK_LOG'                         => 'Registro do BBadblock',
	'BBADBLOCK_LOG_EXPLAIN'                 => 'Este é o registro de todos os usuários que usam um bloqueador de anúncios, e a contagem de páginas visualizadas com o bloqueador habilitado. Você pode filtrar e excluir as entradas registradas. <br /><strong>OBSERVAÇÃO</strong>: Administradores "fundadores" são excluídos por padrão de qualquer registro ou opção usada acima ;-)',
	'BBADBLOCK_HITS'                        => 'Visualizações',
	'BBADBLOCK_NO_USERS'                    => 'Nenhum usuário reportado usando bloqueador de anúncios',
	'NOTICE_BBMEMBERSHIP'                   => 'A extensão <a href="http://www.sitesplat.com/phpBB3/marketplace.php?mode=view&item_id=31"><strong>BBmembership</strong></a> não está instalada, você não pode usar as opções de redirecionamento automático e de grupo de usuário.',
	'ACP_NOTICE_CLOSE'                      => 'Fechar',

	'NOTICE_BBADBLOCK'         => 'A extensão <a href="http://www.sitesplat.com/phpBB3/marketplace.php?mode=view&item_id=31"><strong>BBmembership</strong></a> não está instalada, você não pode usar as opções de redirecionamento automático e de grupo de usuário.',
	'NOTICE_BBADBLOCK_MINICMS' => 'A extensão <a href="http://www.sitesplat.com/phpBB3/marketplace.php?mode=view&item_id=18"><strong>Mini CMS</strong></a> não está instalada, você não pode criar posições dinâmicas de anúncios',
	'ACP_BBADBLOCK_MANAGE'         => 'Gerenciar BBadblock',
	'ACP_BBADBLOCK_MANAGE_EXPLAIN' => 'Usando este formulário você pode adicionar, editar, ver e excluir configurações do BBadblock.',

	'BBADBLOCK_DESCRIPTION' => 'Contraria os plugins de Adblock e adiciona métodos eficazes para combatê-los',
	'BBADBLOCK_DEVELOPERS'  => 'Desenvolvedores',
	'BBADBLOCK_TASKS_1'     => 'Opções inteligentes',
	'BBADBLOCK_TASKS_2'     => 'Opção de lista de permissões de fóruns',
	'BBADBLOCK_TASKS_3'     => 'Opções de lista de permissões de grupos',
	'BBADBLOCK_TASKS_4'     => 'Opções especiais para a extensão <a href="http://www.sitesplat.com/phpBB3/marketplace.php?mode=view&item_id=31"><strong>BBmembership</strong></a>',
	'BBADBLOCK_TASKS_5'     => 'Compatível com a extensão <a href="http://www.sitesplat.com/phpBB3/marketplace.php?mode=view&item_id=18"><strong>Mini CMS</strong></a>, permitindo definir 3 posições de anúncios predefinidas',
	'BBADBLOCK_TASKS_6'     => 'Muito mais...!',

	'SITESPLAT_COM'              => 'http://sitesplat.com',
	'SITESPLAT_COPY'             => '&#169; SiteSplat',
	'LICENSE_INFO'               => 'Proprietary - SiteSplat All rights reserved',
	'EXTENSION_DEVELOPER'        => 'Desenvolvedor',
	'ACP_BBADBLOCK_NOTICE_CLOSE' => 'Fechar',

	'ACP_BBADBLOCK_VERSION' => '1.0.5',
	'ACP_LOADING'            => 'Aguarde. Carregando...',
]);

// Update check stuff
$lang = array_merge($lang, [
	'DESCRIPTION_PAGE'   => 'Descrição',
	'DESCRIPTION_NOTICE' => 'Nota da extensão',
	'ext_details' => [
		'details' => [
			'DESCRIPTION_1' => 'Visão geral dos usuários usando bloqueador de anúncios',
			'DESCRIPTION_2' => 'Alerta de uso de bloqueador de anúncios',
			'DESCRIPTION_3' => 'Ocultar respostas do tópico',
			'DESCRIPTION_4' => 'Ordenação',
		],
		'note' => [
			'NOTICE_1' => 'Integra-se com o Mini CMS da sitesplat',
			'NOTICE_2' => 'Integra-se com o BBmembership',
			'NOTICE_3' => 'Pronto para phpBB 3.2',
		]
	]
]);
