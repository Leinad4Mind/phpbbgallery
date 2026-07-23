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
	'UCP_BBPOINTS_EXPLAIN'         => 'Visão Geral dos pontos ganhos',
	'BB_DONATION'                  => 'Oferecidos por',
	'BB_TRANSFER'                  => 'Transferir para',
	'BBPOINTS_LOG'                 => 'Log dos PontosGold',
	'BBPOINTS_TRANSFER_AMT'        => 'Valor Transferido',
	'TRANSFER_DESCR'               => 'Comentário',
	'BBPOINTS_COMMENT_PLACEHOLDER' => 'Adicione um comentário para ser entregue com os pontos enviados',
	'BBPOINTS_NO_RECORDS'          => 'Desculpe, ainda não existem registros!',

	'BBPOINTS_STATS'      => 'Estatísticas dos PontosGold',
	'BBPOINTS_STATS_BAR'  => 'e progresso geral dos objetivos',
	'BBPOINTS_GOAL'       => 'Objetivo de Pontos',
	'BBPOINTS_GOAL_TO_GO' => 'faltando!',

	'EARN_PER_TOPIC' => 'Você pode ganhar <strong>%1$s</strong> por tópico',
	'EARN_PER_POST'  => 'Você pode ganhar <strong>%1$s</strong> por postagem',
	'EARN_PER_WORD'  => 'Você pode ganhar <strong>%1$s</strong> por palavra',

	'TRANSFER_TO'                => 'Aqui você pode transferir/doar pontos seus para outro usuário - Não pode ser desfeito!',
	'TRANSFER_SUCCESS'           => 'A transferência foi feita com sucesso.',
	'TRANSFER_TO_HIDDEN_TOPIC'   => 'Para ler e reagir a este tópico você precisa negociar <span class="label label-primary">%1$s pontos</span><br />Esta é uma negociação única com o Autor do Tópico<br />Veja aqui como você pode ganhar pontos: <a href="https://goldtuganime.com/forum/viewtopic.php?f=29&t=10711">Sistema de Pontos GoldTugAnime</a>',
	'NO_USER_SELECTED'           => 'Você não selecionou nenhum usuário',
	'NO_AMOUNT_SELECTED'         => 'Você não selecionou nenhum valor ou o valor é menor que 5',
	'TRANSFER_NOT_ENOUGH_POINTS' => 'Você não tem pontos suficientes para transferir.',

	'POINTS_RETURN_POST'     => 'Voltar ao tópico',
	'POINTS_RETURN_INDEX'    => 'Voltar ao índice',
	'POINTS_RETURN_TRANSFER' => 'Voltar à transferência',
	'POINTS_MAIN'            => 'Visão geral de %s',
	'POINTS_MODIFY'          => 'Modificar',
	'POINTS_DONATE'          => 'Doar PontosGold',
	'POINTS_DISABLED'        => 'O PontosGold está desativado no momento',

	'POINTS_RECEIVED_POST_MESSAGE'      => 'Você recebeu <strong>%1$s %2$s</strong> por este tópico',
	'POINTS_RECEIVED_REPLY_MESSAGE'     => 'Você recebeu <strong>%1$s %2$s</strong> por esta postagem',
	'POINTS_RECEIVED_POST_MOD_MESSAGE'  => 'Você receberá <strong>%1$s %2$s</strong> por este tópico quando ele for aprovado',
	'POINTS_RECEIVED_REPLY_MOD_MESSAGE' => 'Você receberá <strong>%1$s %2$s</strong> por esta postagem quando ela for aprovada',
	'POINTS_POST_REMOVED'               => 'Você perdeu <strong>%1$s %2$s</strong> por excluir esta postagem',

	'TRANSFER_DISABLED'           => 'A transferência está desativada',
	'TRANSFER_USERNAME_NOT_EXIST' => 'Não existe nenhum usuário com esse nome de usuário.',
	'TRANSFER_PM_SUBJECT'         => 'Você recebeu PontosGold!',
	'TRANSFER_PM_BODY'            => 'Você recebeu %1$s PontosGold de %2$s.',
	'TRANSFER_PM_BODY_COMMENT'    => 'Você recebeu %1$s PontosGold de %2$s com o seguinte comentário: <br />%3$s',
	'TRANSFER_POINTS_TITLE'       => 'Transferir %s',
	'TRANSFER_POINTS'             => 'Transferir %s',
	'TRANSFER_AMOUNT'             => 'Valor',
	'TRANSFER_COMMENT'            => 'Comentário',
	'BBPOINTS_LOG'                => 'Log de Transferências',


	'CHANGE_NO_USER_SELECTED' => 'Nenhum usuário selecionado',
	'CHANGE_SUCCESS'          => 'O usuário foi atualizado.',
	'CHANGE_POINTS'           => 'Alterar %s',
	'CHANGE_AMOUNT'           => 'Novo valor',

	'MAIN_HELLO' => 'Olá, %s!',
	'MAIN_TEXT'  => 'Você tem %1$s %2$s.<br /><br />%2$s por novo tópico: %3$s<br />%2$s por nova postagem: %4$s<br />%2$s por palavra: %5$s',
]);
