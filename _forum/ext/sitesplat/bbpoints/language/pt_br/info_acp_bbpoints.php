<?php

/**
 * BBPoints extension for the phpBB Forum Software package.
 * @copyright (c) 2015-2022 SiteSplat All rights reserved
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
	'ACP_POINTS'               => 'PontosGold',
	'ACP_POINTS_INDEX_TITLE'   => 'Configurações de PontosGold',
	'ACP_POINTS_INDEX_EXPLAIN' => 'Atribua pontos por tópico, postagem ou palavras, ou atribua-os por fórum através do Gerenciamento de Fóruns. Você também pode excluir fóruns dos PontosGold.<br /> Dê pontos a grupos de sua escolha ou até mesmo a um único usuário. Sincronize e reinicie os pontos quando quiser. Divirta-se e torne o seu fórum único e envolvente para os seus usuários!<br /><br /><strong>OBSERVAÇÃO</strong>: O recurso Ocultar Tópico permite que um usuário defina uma quantidade mínima de pontos para que o tópico fique visível para o próximo usuário. Precisa ser definido pela permissão de grupo do fórum "O usuário pode ocultar o próprio tópico"',
	'ACP_ENABLE_POINTS'        => 'Ativar PontosGold',

	'POINTS_NAME'         => 'Símbolo dos Pontos (ou nome)',
	'POINTS_NAME_EXPLAIN' => 'Escolha o símbolo da moeda. Ele será exibido em diversos locais do fórum.<br /> A posição à esquerda ou à direita também pode ser selecionada.<br /> Você pode facilmente usar o seu próprio nome de pontos personalizado editando uma linha do arquivo de idioma localizado em:<br /> <strong>root/ext/sitesplat/bbpoints/language/bbpoints_common.php</strong>',

	'EXT_SYMBOL'         => 'Símbolo da Extensão',
	'EXT_SYMBOL_EXPLAIN' => 'Escolha o símbolo para esta extensão',

	'ACP_POINTS_EXPLAIN'     => 'Defina quantos pontos um usuário receberá, em geral. Esses valores serão substituídos se um valor diferente for inserido no gerenciamento de fóruns. <strong>ACP > FÓRUNS > Seu fórum</strong> Depois clique em editar para os fóruns existentes ou encontre a configuração de PontosGold para novos fóruns.',
	'ACP_POINTS_PER_EXPLAIN' => 'Defina quantos pontos um usuário receberá por login, registro ou no seu aniversário. Defina como 0 para desativar.',

	'POINTS_PERLOGIN'    => 'Pontos por login',
	'POINTS_PERREGISTER' => 'Pontos pelo registro',
	'POINTS_PERBIRTHDAY' => 'Pontos pelo aniversário',

	'ENABLE_STATS'         => 'Ativar Estatísticas',
	'ENABLE_STATS_EXPLAIN' => 'Ativa ou desativa as estatísticas gerais',
	'BAR_STATS'            => 'Exibir barra de progresso no Índice',
	'BAR_STATS_EXPLAIN'    => 'Exibe uma barra de progresso e a sua meta de pontos na página do índice',

	'BBPOINT_STATS'         => 'Exibir estatísticas de PontosGold na página do índice',
	'BBPOINT_STATS_EXPLAIN' => 'Exibe estatísticas do usuário na página do índice',

	'TRANSFER_NOTIFY'                 => 'Permitir transferência',
	'TRANSFER_NOTIFY_EXPLAIN'         => 'Permite e notifica o usuário quando alguém envia PontosGold para ele',
	'POINTS_GROUP_TRANSFER_NO_AMOUNT' => 'Você precisa definir a quantidade de pontos a transferir',
	'POINTS_GROUP_TRANSFER_SUCCESS'   => 'A transferência foi processada com sucesso',
	'POINTS_GROUP_TRANSFER_NO_USERS'  => 'Não existem usuários neste grupo',
	'POINTS_COMMENTS'                 => 'Permitir comentários',
	'POINTS_COMMENTS_EXPLAIN'         => 'Permite que o usuário deixe um comentário sobre a transferência de pontos',

	'ACP_POINTS_VERSION'       => '1.2.4',
	'ACP_LOADING'              => 'Aguarde. Carregando...',
	'ACP_SIDEBAR_NOTICE_CLOSE' => 'Fechar',

	'SITESPLAT_COM'       => 'https://sitesplat.com',
	'SITESPLAT_COPY'      => '&#169; SiteSplat',
	'LICENSE_INFO'        => 'Proprietário - SiteSplat Todos os direitos reservados',
	'EXTENSION_DEVELOPER' => 'Desenvolvedor',

	'BBPOINTS_NOTICE' => '<div style="width:80%;margin:20px auto;"><p>As configurações para esta extensão encontram-se em <strong>%1$s » %2$s » %3$s</strong>.<br />Não se esqueça de verificar as Permissões de Grupo do Fórum e também as opções de Gerenciamento de Fóruns!</p></div>',
	'SS_HELPER_NOTY'  => 'O SiteSplat BBcore não existe!<br />Baixe o <a href="https://sitesplat.com" target="_blank">BBcore</a> e copie a pasta BBcore para a pasta da sua extensão sitesplat.',

	'POINTS_DESCRIPTION' => 'Os PontosGold permitem que os membros do seu fórum se divirtam e colecionem pontos por determinadas ações...',
	'POINTS_TASKS_1'     => 'Pontos por tópico, postagem, palavras, novos registros, aniversários e muito mais!',
	'POINTS_TASKS_2'     => 'Transfira/doe pontos para outros usuários',
	'POINTS_TASKS_3'     => 'Controle granular de pontos configurável para cada fórum',
	'POINTS_TASKS_4'     => 'Sincronize e reinicie os pontos',
	'POINTS_TASKS_5'     => 'Visão geral dos seus pontos na UCP, com log',
	'POINTS_TASKS_6'     => 'Sincronização com tarefas cron e compatível com a extensão <a href="https://www.phpbb.com/customise/db/extension/cronstatus/">Cron Status</a>',


	'FORUM_PERPOST'                => 'Pontos por postagem',
	'FORUM_PERPOST_EXPLAIN'        => 'Defina quantos pontos os usuários receberão por criar uma nova postagem.',
	'FORUM_PERPOST_FORUM_EXPLAIN'  => 'Defina quantos pontos os usuários receberão por criar uma nova postagem neste fórum. Se você definir 0, a opção padrão será usada.',
	'FORUM_PERWORD'                => 'Pontos por palavra',
	'FORUM_PERWORD_EXPLAIN'        => 'Defina quantos pontos os usuários receberão por cada palavra na postagem.',
	'FORUM_PERWORD_FORUM_EXPLAIN'  => 'Defina quantos pontos os usuários receberão por cada palavra na postagem, neste fórum. Se você definir 0, a opção padrão será usada.',
	'FORUM_PERTOPIC'               => 'Pontos por tópico',
	'FORUM_PERTOPIC_EXPLAIN'       => 'Defina quantos pontos os usuários receberão por criar um novo tópico.',
	'FORUM_PERTOPIC_FORUM_EXPLAIN' => 'Defina quantos pontos os usuários receberão por criar um novo tópico neste fórum. Se você definir 0, a opção padrão será usada.',
	'POINTS_TRANSFER'              => 'Permitir que os usuários transfiram pontos',
	'POINTS_TRANSFER_EXPLAIN'      => 'Permite que os usuários transfiram os seus pontos para outro usuário',

	'POINTS_CONFIG_SUCCESS' => 'As configurações de PontosGold foram atualizadas com sucesso',

	'POINTS_GROUP_TRANSFER'                    => 'Transferir pontos para um grupo ou um único usuário',
	'POINTS_GROUP_TRANSFER_EXPLAIN'            => 'Comece a digitar o nome de usuário para o qual deseja enviar os pontos, ou selecione o grupo',
	'POINTS_GROUP_TRANSFER_PM_ERROR'           => 'Você precisa inserir o assunto, assim como a mensagem, para enviar a MP ao grupo.',
	'POINTS_GROUP_TRANSFER_GROUP'              => 'Grupo',
	'POINTS_GROUP_TRANSFER_AMOUNT'             => 'Quantidade',
	'POINTS_GROUP_TRANSFER_AMOUNT_EXPLAIN'     => 'Digite a quantidade que deseja transferir para o grupo ou usuário',
	'POINTS_GROUP_TRANSFER_SENDER'             => 'Remetente',
	'POINTS_GROUP_TRANSFER_SENDER_EXPLAIN'     => 'O usuário em nome de quem a mensagem privada será enviada',
	'POINTS_SMILIES'                           => 'Smilies',
	'POINTS_GROUP_TRANSFER_PM_TITLE'           => 'Assunto da mensagem privada',
	'POINTS_GROUP_TRANSFER_PM_TITLE_EXPLAIN'   => 'Digite um Assunto de MP sobre a transferência',
	'POINTS_GROUP_TRANSFER_PM_COMMENT'         => 'Texto da mensagem privada',
	'POINTS_GROUP_TRANSFER_PM_COMMENT_EXPLAIN' => 'Digite uma mensagem de MP sobre a transferência',

	'POINTS_GROUP_TRANSFER_FUNCTION' => 'Função',
	'POINTS_GROUP_TRANSFER_ADD'      => 'Adicionar',
	'POINTS_GROUP_TRANSFER_SET'      => 'Definir',
	'POINTS_GROUP_TRANSFER_REMOVE'   => 'Remover',

	'SYNC_POINTS_CONFIRM'  => 'Tem certeza de que quer sincronizar todos os pontos?<br />Observação: Esta ação não pode ser desfeita!',
	'SYNC_POINTS'          => 'Sincronizar pontos dos usuários',
	'LOG_RESYNC_SUCCESS'   => 'Os PontosGold foram reiniciados com sucesso',
	'RESET_POINTS_CONFIRM' => 'Tem certeza de que quer reiniciar todos os pontos?<br />Observação: Esta ação não pode ser desfeita!',
	'RESET_POINTS'         => 'Reiniciar pontos dos usuários',

	'RESET_POINTS_EXPLAIN' => 'Esta ação não pode ser desfeita! Ela vai reiniciar os pontos dos usuários',
	'SYNC_POINTS_EXPLAIN'  => 'Calcula todos os critérios de pontos definidos acima para todos os usuários.<br />Pode levar vários minutos, dependendo de quantos usuários e postagens o seu fórum tiver.<br /> NÃO interrompa o processo depois de iniciado.',

	'ENTER_USER' => 'Digitar usuário ...',
]);
