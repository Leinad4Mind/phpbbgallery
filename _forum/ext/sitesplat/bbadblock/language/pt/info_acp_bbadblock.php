<?php

/**
 * BBadblock extension for the phpBB Forum Software package.
 * @copyright (c) 2015 SiteSplat All rights reserved
 * @license Proprietary
 * @translation Leinad4Mind [Portuguese [pt]] (2026)
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
	'ACP_BBADBLOCK_INDEX_TITLE'          => 'Definições do BBadblock',
	'ACP_BBADBLOCK_EXPLAIN'              => 'Os adblocks são tão incômodos como os próprios anúncios :) para o Administrador do fórum, e vão fazer-te perder receita. <br />O BBadblock vai contrariar os utilizadores de adblock e perturbar a experiência no fórum, para que o utilizador acabe por adicionar o teu fórum à lista de permissões. Opções inteligentes disponíveis, como mensagens modais, ocultar publicações, etc...',
	'ACP_BBADBLOCK_ADS_EXPLAIN'          => '<br />Se os Anúncios não estiverem ativados, deves preencher o nome da classe onde os teus anúncios estarão.',
	'ACP_BBADBLOCK_BBMEMBERSHIP_EXPLAIN' => '<br />Se o BBmembership estiver ativado, podes usar um dos grupos de membros para desativar o bloqueador de anúncios. O grupo de utilizador deve então ser o predefinido para o membro.',

	'BBADBLOCK_NOTICE' => '<div class="phpinfo"><p>As definições desta extensão encontram-se em <strong>%1$s &#187; %2$s &#187; %3$s</strong>.</p></div>',
	'SS_HELPER_NOTY'   => 'O SiteSplat BBcore não existe!<br />Transfere o <a href="http://sitesplat.com" target="_blank">BBcore</a> e copia a pasta BBcore para a pasta da tua extensão sitesplat.',

	'BBADBLOCK_CLASSNAME'                   => 'Nome da Classe',
	'BBADBLOCK_CLASSNAME_EXPLAIN'           => 'Nome da classe div onde estão os teus anúncios. <br /> Não deves alterar isto a menos que saibas o que estás a fazer. <br /> Envolve os teus anúncios em blocos DIV com a classe aqui inserida. <br />Por predefinição, os anúncios de teste encontram-se em: <br /><strong class="small">- /ext/sitesplat/bbadblock/styles/FLATBOOTS/template/event/overall_footer_content_after.html</strong> <br /><strong class="small">- /ext/sitesplat/bbadblock/styles/FLATBOOTS/template/event/viewtopic_body_postrow_post_after.html</strong>',
	'BBADBLOCK_REDIRECT'                    => 'Página de Redirecionamento',
	'BBADBLOCK_REDIRECTE_EXPLAIN'           => 'URL de redirecionamento para onde o utilizador será forçado quando qualquer plugin de bloqueio de anúncios estiver ativado. Verifica as regras de rewrite do teu servidor se algo não estiver a funcionar ou se for mostrado ao utilizador o erro "demasiados redirecionamentos". <br />Por exemplo: <strong>/forum/memberships.php</strong>',
	'BBADBLOCK_MESSAGE'                     => 'Mensagem Modal Ajax',
	'BBADBLOCK_MESSAGE_EXPLAIN'             => 'Insere a mensagem que gostarias de mostrar aos utilizadores que têm o bloqueador de anúncios ativado',
	'BBADBLOCK_MODAL_ALERT'                 => 'Mostrar Modal Ajax',
	'BBADBLOCK_MODAL_ALERT_EXPLAIN'         => 'Mostra o Modal Ajax quando o utilizador está a usar um bloqueador de anúncios',
	'BBADBLOCK_AUTO_RESET'                  => 'Reiniciar Automaticamente a Contagem de Páginas',
	'BBADBLOCK_AUTO_RESET_EXPLAIN'          => 'Quando definido como SIM, o plugin vai contar cada visualização de página para cada utilizador com o bloqueador de anúncios ativado, e quando o utilizador finalmente desativar o bloqueador, terá de visualizar as páginas tantas vezes quantas visualizou anteriormente com o bloqueador ativado, até a contagem chegar a zero, para poder ver todas as publicações. DESATIVADO desliga o contador.<br /> <strong>NOTA</strong>: Esta opção destina-se a incomodar o utilizador e a praticamente forçá-lo a desativar o bloqueador de anúncios, caso contrário a experiência no fórum será extremamente perturbadora. Usa por tua conta e risco.',
	'BBADBLOCK_EXCLUDE_GROUP'               => 'Exclusão de Grupo do BBmembership',
	'BBADBLOCK_EXCLUDE_GROUP_EXPLAIN'       => 'Grupo de membros que NÃO será afetado pelas funções do BBadblock.',
	'BBADBLOCK_EXCLUDE_HIDE_FORUMS'         => 'Exclusão de Fóruns',
	'BBADBLOCK_EXCLUDE_HIDE_FORUMS_EXPLAIN' => 'Todas as publicações, exceto a primeira, serão ocultadas quando o utilizador tiver um bloqueador de anúncios ativado, com exceção dos fóruns aqui selecionados',
	'BBADBLOCK_BLOCKED_SINCE'               => 'A usar bloqueador de anúncios desde',
	'BBADBLOCK_LOG'                         => 'Registo do BBadblock',
	'BBADBLOCK_LOG_EXPLAIN'                 => 'Este é o registo de todos os utilizadores que usam um bloqueador de anúncios, e a contagem de páginas visualizadas com o bloqueador ativado. Podes filtrar e eliminar as entradas registadas. <br /><strong>NOTA</strong>: Os administradores "fundadores" são excluídos por predefinição de qualquer registo ou opção usada acima ;-)',
	'BBADBLOCK_HITS'                        => 'Visualizações',
	'BBADBLOCK_NO_USERS'                    => 'Nenhum utilizador reportado a usar bloqueador de anúncios',
	'NOTICE_BBMEMBERSHIP'                   => 'A extensão <a href="http://www.sitesplat.com/phpBB3/marketplace.php?mode=view&item_id=31"><strong>BBmembership</strong></a> não está instalada, não podes usar as opções de redirecionamento automático e de grupo de utilizador.',
	'ACP_NOTICE_CLOSE'                      => 'Fechar',

	'NOTICE_BBADBLOCK'             => 'A extensão <a href="http://www.sitesplat.com/phpBB3/marketplace.php?mode=view&item_id=31"><strong>BBmembership</strong></a> não está instalada, não podes usar as opções de redirecionamento automático e de grupo de utilizador.',
	'NOTICE_BBADBLOCK_MINICMS'     => 'A extensão <a href="http://www.sitesplat.com/phpBB3/marketplace.php?mode=view&item_id=18"><strong>Mini CMS</strong></a> não está instalada, não podes criar posições dinâmicas de anúncios',
	'ACP_BBADBLOCK_MANAGE'         => 'Gerir BBadblock',
	'ACP_BBADBLOCK_MANAGE_EXPLAIN' => 'Usando este formulário podes adicionar, editar, ver e eliminar configurações do BBadblock.',

	'BBADBLOCK_DESCRIPTION' => 'Contraria os plugins de Adblock e adiciona métodos eficazes para os combater',
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
	'ACP_LOADING'           => 'Aguarda. A Carregar...',
]);

// Update check stuff
$lang = array_merge($lang, [
	'DESCRIPTION_PAGE'   => 'Descrição',
	'DESCRIPTION_NOTICE' => 'Nota da extensão',
	'ext_details'        => [
		'details' => [
			'DESCRIPTION_1' => 'Vista geral dos utilizadores a usar bloqueador de anúncios',
			'DESCRIPTION_2' => 'Alerta de utilização de bloqueador de anúncios',
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
