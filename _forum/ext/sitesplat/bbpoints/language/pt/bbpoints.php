<?php

/**
 * BBPoints extension for the phpBB Forum Software package.
 * @copyright (c) 2015-2022 SiteSplat All rights reserved
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
	'UCP_BBPOINTS_EXPLAIN'         => 'Visão Geral dos pontos ganhos',
	'BB_DONATION'                  => 'Oferecidos por',
	'BB_TRANSFER'                  => 'Transferir para',
	'BBPOINTS_LOG'                 => 'Log dos PontosGold',
	'BBPOINTS_TRANSFER_AMT'        => 'Montante Transferido',
	'TRANSFER_DESCR'               => 'Comentário',
	'BBPOINTS_COMMENT_PLACEHOLDER' => 'Adiciona um comentário para ser entregue com os pontos enviados',
	'BBPOINTS_NO_RECORDS'          => 'Lamentamos, não existem ainda registos!',

	'BBPOINTS_STATS'      => 'Estatísticas dos PontosGold',
	'BBPOINTS_STATS_BAR'  => 'e progresso geral dos objectivos',
	'BBPOINTS_GOAL'       => 'Objectivos de Pontos',
	'BBPOINTS_GOAL_TO_GO' => 'em falta!',

	'EARN_PER_TOPIC' => 'Podes ganhar <strong>%1$s</strong> por tópico',
	'EARN_PER_POST'  => 'Podes ganhar <strong>%1$s</strong> por mensagem',
	'EARN_PER_WORD'  => 'Podes ganhar <strong>%1$s</strong> por palavra',

	'TRANSFER_TO'                => 'Podes transferir/oferecer pontos teus a outro utilizador - Esta acção é irreversível!',
	'TRANSFER_SUCCESS'           => 'A transferência de pontos foi feita com sucesso.',
	'TRANSFER_TO_HIDDEN_TOPIC'   => 'Para poderes aceder a este tópico terás de efectuar uma troca de <span class="label label-primary">%1$s pontos</span><br />Estes pontos serão transferidos uma única vez para a conta do Autor do Tópico<br />Vejam aqui como podem ganhar pontos: <a href="https://goldtuganime.com/forum/viewtopic.php?f=29&t=10711">Sistema de Pontos GoldTugAnime</a>',
	'NO_USER_SELECTED'           => 'Não seleccionaste nenhum utilizador',
	'NO_AMOUNT_SELECTED'         => 'Não seleccionaste nenhum montante ou o montante é menor do que 5',
	'TRANSFER_NOT_ENOUGH_POINTS' => 'Não tens pontos suficientes para oferecer.',

	'POINTS_RETURN_POST'     => 'Regressar ao tópico',
	'POINTS_RETURN_INDEX'    => 'Regressar ao índice',
	'POINTS_RETURN_TRANSFER' => 'Regressar à transferência',
	'POINTS_MAIN'            => '%s visão geral',
	'POINTS_MODIFY'          => 'Modificar',
	'POINTS_DONATE'          => 'Oferecer',
	'POINTS_DISABLED'        => 'Os PontosGold estão de momento desactivados',

	'POINTS_RECEIVED_POST_MESSAGE'      => 'Recebeste <strong>%1$s %2$s</strong> por este tópico',
	'POINTS_RECEIVED_REPLY_MESSAGE'     => 'Recebeste <strong>%1$s %2$s</strong> por esta mensagem',
	'POINTS_RECEIVED_POST_MOD_MESSAGE'  => 'Irás receber <strong>%1$s %2$s</strong> por este tópico assim que for aprovado',
	'POINTS_RECEIVED_REPLY_MOD_MESSAGE' => 'Irás receber <strong>%1$s %2$s</strong> por esta mensagem assim que for aprovada',
	'POINTS_POST_REMOVED'               => 'Perdeste <strong>%1$s %2$s</strong> por teres apagado esta mensagem',

	'TRANSFER_DISABLED'           => 'A transferência de pontos está desactivada',
	'TRANSFER_USERNAME_NOT_EXIST' => 'Não existe nenhum utilizador com esse nome.',
	'TRANSFER_PM_SUBJECT'         => 'Recebeste PontosGold!',
	'TRANSFER_PM_BODY'            => 'Recebeste %1$s PontosGold da parte de %2$s.',
	'TRANSFER_PM_BODY_COMMENT'    => 'Recebeste %1$s PontosGold da parte de %2$s com o seguinte comentário: <br />%3$s',
	'TRANSFER_POINTS_TITLE'       => 'Transferir %s',
	'TRANSFER_POINTS'             => 'Transferir %s',
	'TRANSFER_AMOUNT'             => 'Montante',
	'TRANSFER_COMMENT'            => 'Comentário',
	'BBPOINT_LOG'                 => 'Log de Transferências',


	'CHANGE_NO_USER_SELECTED' => 'Nenhum utilizador seleccionado',
	'CHANGE_SUCCESS'          => 'O utilizador foi actualizado.',
	'CHANGE_POINTS'           => 'Alterar %s',
	'CHANGE_AMOUNT'           => 'Novo montante',

	'MAIN_HELLO' => 'Olá, %s!',
	'MAIN_TEXT'  => 'Tens %1$s %2$s.<br /><br />%2$s por novos tópicos: %3$s<br />%2$s por novas mensagens: %4$s<br />%2$s por palavra: %5$s',
]);
