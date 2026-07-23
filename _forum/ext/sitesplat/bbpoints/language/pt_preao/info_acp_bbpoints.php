<?php

/**
 * BBPoints extension for the phpBB Forum Software package.
 * @copyright (c) 2015-2022 SiteSplat All rights reserved
 * @license Proprietary
 * @translation Leinad4Mind [Portuguese [pt_preao]] (2026)
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
	'ACP_POINTS'               => 'PontosGold',
	'ACP_POINTS_INDEX_TITLE'   => 'Configurações de PontosGold',
	'ACP_POINTS_INDEX_EXPLAIN' => 'Atribui pontos por tópico, publicação ou palavras, ou atribui-os por fórum através da Gestão de Fóruns. Também podes excluir fóruns dos PontosGold.<br /> Dá pontos a grupos à tua escolha ou até a um único utilizador. Sincroniza e reinicia os pontos quando quiseres. Diverte-te e torna o teu fórum único e cativante para os teus utilizadores!<br /><br /><strong>NOTA</strong>: A funcionalidade Ocultar Tópico permite a um utilizador definir uma quantidade mínima de pontos para que o tópico seja visível ao próximo utilizador. Precisa de ser definida através da permissão de grupo do fórum "O utilizador pode ocultar o seu próprio tópico"',
	'ACP_ENABLE_POINTS'        => 'Activar PontosGold',

	'POINTS_NAME'         => 'Símbolo dos Pontos (ou nome)',
	'POINTS_NAME_EXPLAIN' => 'Escolhe o símbolo da moeda. Este será exibido em diversos locais do fórum.<br /> Também podes escolher a posição à esquerda ou à direita.<br /> Podes facilmente usar o teu próprio nome de pontos personalizado editando uma linha do ficheiro de idioma localizado em:<br /> <strong>root/ext/sitesplat/bbpoints/language/bbpoints_common.php</strong>',

	'EXT_SYMBOL'         => 'Símbolo da Extensão',
	'EXT_SYMBOL_EXPLAIN' => 'Escolhe o símbolo para esta extensão',

	'ACP_POINTS_EXPLAIN'     => 'Define quantos pontos um utilizador irá receber, em geral. Estes valores serão substituídos se for introduzido um valor diferente na gestão de fóruns. <strong>ACP > FÓRUNS > O teu fórum</strong> Depois clica em editar para os fóruns existentes ou procura a configuração dos PontosGold para novos fóruns.',
	'ACP_POINTS_PER_EXPLAIN' => 'Define quantos pontos um utilizador irá receber por login, registo ou no seu aniversário. Define como 0 para desativar.',

	'POINTS_PERLOGIN'    => 'Pontos por login',
	'POINTS_PERREGISTER' => 'Pontos pelo registo',
	'POINTS_PERBIRTHDAY' => 'Pontos pelo aniversário',

	'ENABLE_STATS'         => 'Activar Estatísticas',
	'ENABLE_STATS_EXPLAIN' => 'Activa ou desativa as estatísticas gerais',
	'BAR_STATS'            => 'Exibir barra de progresso no Índice',
	'BAR_STATS_EXPLAIN'    => 'Exibe uma barra de progresso e o teu objetivo de pontos na página do índice',

	'BBPOINT_STATS'         => 'Exibir estatísticas dos PontosGold na página do índice',
	'BBPOINT_STATS_EXPLAIN' => 'Exibe estatísticas do utilizador na página do índice',

	'TRANSFER_NOTIFY'                 => 'Permitir transferência',
	'TRANSFER_NOTIFY_EXPLAIN'         => 'Permite e notifica o utilizador quando alguém lhe envia PontosGold',
	'POINTS_GROUP_TRANSFER_NO_AMOUNT' => 'Tens de definir a quantidade de pontos a transferir',
	'POINTS_GROUP_TRANSFER_SUCCESS'   => 'A transferência foi processada com sucesso',
	'POINTS_GROUP_TRANSFER_NO_USERS'  => 'Não existem utilizadores neste grupo',
	'POINTS_COMMENTS'                 => 'Permitir comentários',
	'POINTS_COMMENTS_EXPLAIN'         => 'Permite ao utilizador deixar um comentário sobre a transferência de pontos',

	'ACP_POINTS_VERSION'       => '1.2.4',
	'ACP_LOADING'              => 'Aguarda. A carregar...',
	'ACP_SIDEBAR_NOTICE_CLOSE' => 'Fechar',

	'SITESPLAT_COM'       => 'https://sitesplat.com',
	'SITESPLAT_COPY'      => '&#169; SiteSplat',
	'LICENSE_INFO'        => 'Proprietário - SiteSplat Todos os direitos reservados',
	'EXTENSION_DEVELOPER' => 'Programador',

	'BBPOINTS_NOTICE' => '<div style="width:80%;margin:20px auto;"><p>A configuração para esta extensão encontra-se em <strong>%1$s » %2$s » %3$s</strong>.<br />Não te esqueças de verificar as Permissões de Grupo do Fórum e também as opções de Gestão de Fóruns!</p></div>',
	'SS_HELPER_NOTY'  => 'O SiteSplat BBcore não existe!<br />Transfere o <a href="https://sitesplat.com" target="_blank">BBcore</a> e copia a pasta BBcore para a pasta da tua extensão sitesplat.',

	'POINTS_DESCRIPTION' => 'Os PontosGold permitem que os membros do teu fórum se divirtam e coleccionem pontos por determinadas acções...',
	'POINTS_TASKS_1'     => 'Pontos por tópico, publicação, palavras, novos registos, aniversários e muito mais!',
	'POINTS_TASKS_2'     => 'Transfere/oferece pontos a outros utilizadores',
	'POINTS_TASKS_3'     => 'Controlo granular de pontos configurável por fórum',
	'POINTS_TASKS_4'     => 'Sincroniza e reinicia os pontos',
	'POINTS_TASKS_5'     => 'Visão geral dos teus pontos na UCP, com registo',
	'POINTS_TASKS_6'     => 'Sincronização com tarefas cron e compatível com a extensão <a href="https://www.phpbb.com/customise/db/extension/cronstatus/">Cron Status</a>',


	'FORUM_PERPOST'                => 'Pontos por publicação',
	'FORUM_PERPOST_EXPLAIN'        => 'Define quantos pontos os utilizadores irão receber por criar uma nova publicação.',
	'FORUM_PERPOST_FORUM_EXPLAIN'  => 'Define quantos pontos os utilizadores irão receber por criar uma nova publicação neste fórum. Se definires 0, será usada a opção padrão.',
	'FORUM_PERWORD'                => 'Pontos por palavra',
	'FORUM_PERWORD_EXPLAIN'        => 'Define quantos pontos os utilizadores irão receber por cada palavra na publicação.',
	'FORUM_PERWORD_FORUM_EXPLAIN'  => 'Define quantos pontos os utilizadores irão receber por cada palavra na publicação, neste fórum. Se definires 0, será usada a opção padrão.',
	'FORUM_PERTOPIC'               => 'Pontos por tópico',
	'FORUM_PERTOPIC_EXPLAIN'       => 'Define quantos pontos os utilizadores irão receber por criar um novo tópico.',
	'FORUM_PERTOPIC_FORUM_EXPLAIN' => 'Define quantos pontos os utilizadores irão receber por criar um novo tópico neste fórum. Se definires 0, será usada a opção padrão.',
	'POINTS_TRANSFER'              => 'Permitir que os utilizadores transfiram pontos',
	'POINTS_TRANSFER_EXPLAIN'      => 'Permite que os utilizadores transfiram os seus pontos para outro utilizador',

	'POINTS_CONFIG_SUCCESS' => 'As configurações dos PontosGold foram actualizadas com sucesso',

	'POINTS_GROUP_TRANSFER'                    => 'Transferir pontos para um grupo ou um único utilizador',
	'POINTS_GROUP_TRANSFER_EXPLAIN'            => 'Começa a escrever o nome de utilizador para o qual desejas enviar os pontos, ou selecciona o grupo',
	'POINTS_GROUP_TRANSFER_PM_ERROR'           => 'Tens de introduzir o assunto, assim como a mensagem, para enviar a MP ao grupo.',
	'POINTS_GROUP_TRANSFER_GROUP'              => 'Grupo',
	'POINTS_GROUP_TRANSFER_AMOUNT'             => 'Quantidade',
	'POINTS_GROUP_TRANSFER_AMOUNT_EXPLAIN'     => 'Introduz a quantidade que desejas transferir para o grupo ou utilizador',
	'POINTS_GROUP_TRANSFER_SENDER'             => 'Remetente',
	'POINTS_GROUP_TRANSFER_SENDER_EXPLAIN'     => 'O utilizador em nome de quem a mensagem privada será enviada',
	'POINTS_SMILIES'                           => 'Smilies',
	'POINTS_GROUP_TRANSFER_PM_TITLE'           => 'Assunto da mensagem privada',
	'POINTS_GROUP_TRANSFER_PM_TITLE_EXPLAIN'   => 'Introduz um Assunto de MP sobre a transferência',
	'POINTS_GROUP_TRANSFER_PM_COMMENT'         => 'Texto da mensagem privada',
	'POINTS_GROUP_TRANSFER_PM_COMMENT_EXPLAIN' => 'Introduz uma mensagem de MP sobre a transferência',

	'POINTS_GROUP_TRANSFER_FUNCTION' => 'Função',
	'POINTS_GROUP_TRANSFER_ADD'      => 'Adicionar',
	'POINTS_GROUP_TRANSFER_SET'      => 'Definir',
	'POINTS_GROUP_TRANSFER_REMOVE'   => 'Remover',

	'SYNC_POINTS_CONFIRM'  => 'Tens a certeza de que queres sincronizar todos os pontos?<br />Nota: Esta acção não pode ser desfeita!',
	'SYNC_POINTS'          => 'Sincronizar pontos dos utilizadores',
	'LOG_RESYNC_SUCCESS'   => 'Os PontosGold foram reiniciados com sucesso',
	'RESET_POINTS_CONFIRM' => 'Tens a certeza de que queres reiniciar todos os pontos?<br />Nota: Esta acção não pode ser desfeita!',
	'RESET_POINTS'         => 'Reiniciar pontos dos utilizadores',

	'RESET_POINTS_EXPLAIN' => 'Esta acção não pode ser desfeita! Irá reiniciar os pontos dos utilizadores',
	'SYNC_POINTS_EXPLAIN'  => 'Calcula todos os critérios de pontos definidos acima para todos os utilizadores.<br />Pode demorar vários minutos, dependendo de quantos utilizadores e publicações o teu fórum tiver.<br /> NÃO interrompas o processo depois de iniciado.',

	'ENTER_USER' => 'Introduzir utilizador ...',
]);
