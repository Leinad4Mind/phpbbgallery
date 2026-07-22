<?php

/**
 * LikePoints extension for the phpBB Forum Software package.
 * @copyright (c) 2022 Leinad4Mind All rights reserved
 * @license Proprietary
 * @translation Leinad4Mind [Portuguese [pt_preao]] (2026)
 */

/**
 * DO NOT CHANGE
 */
if (!defined('IN_PHPBB')) {
   exit;
}

if (!isset($lang) || !is_array($lang)) {
   $lang = [];
}

$lang = array_merge($lang, [
   'PER_LIKES_ENABLE' => 'Activar transferência de PontosGold por gostos',
   'PER_LIKES_AMOUNT' => 'Quantidade de PontosGold transferidos ao gostar da mensagem',
   'ACP_POINTS_PER_LIKES' => 'Pontos por gosto',
   'ACP_POINTS_PER_LIKES_EXPLAIN' => 'Define a quantidade predefinida de pontos transferidos ao gostar de mensagens. Define como 0 para desactivar.',
   'CONTRIBUTORS_ENABLE' => 'Activar colaboradores',
   'SYNC_LIKE_POINTS' => 'Sincronizar pontos de gostos',
   'SYNC_LIKE_POINTS_EXPLAIN' => 'Calcula todos os pontos para os gostos definidos acima para todos os utilizadores.<br>Pode demorar vários minutos e depende de quantos utilizadores, mensagens e gostos o teu fórum tem.<br>Não interrompas o processo depois de iniciado.',
   'SYNC_LIKE_POINTS_PROCESSING' => 'A processar...',
   'SYNC_LIKE_POINTS_TOTAL_POSTS' => 'Total de mensagens',
]);
