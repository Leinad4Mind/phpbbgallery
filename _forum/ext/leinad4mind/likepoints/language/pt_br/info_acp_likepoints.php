<?php

/**
 * LikePoints extension for the phpBB Forum Software package.
 * @copyright (c) 2022 Leinad4Mind All rights reserved
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

if (!isset($lang) || !is_array($lang))
{
   $lang = [];
}

$lang = array_merge($lang, [
   'PER_LIKES_ENABLE'             => 'Habilitar transferência de PontosGold por curtidas',
   'PER_LIKES_AMOUNT'             => 'Quantidade de PontosGold transferidos ao curtir a mensagem',
   'ACP_POINTS_PER_LIKES'         => 'Pontos por curtida',
   'ACP_POINTS_PER_LIKES_EXPLAIN' => 'Defina a quantidade padrão de pontos transferidos ao curtir mensagens. Defina como 0 para desativar.',
   'CONTRIBUTORS_ENABLE'          => 'Habilitar colaboradores',
   'SYNC_LIKE_POINTS'             => 'Sincronizar pontos de curtidas',
   'SYNC_LIKE_POINTS_EXPLAIN'     => 'Calcula todos os pontos para as curtidas definidas acima para todos os usuários.<br>Pode levar vários minutos e depende de quantos usuários, posts e curtidas seu fórum hospeda.<br>Não interrompa o processo depois de iniciado.',
   'SYNC_LIKE_POINTS_PROCESSING'  => 'Processando...',
   'SYNC_LIKE_POINTS_TOTAL_POSTS' => 'Total de posts',
]);
