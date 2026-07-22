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
   'CONTRIBUTOR_LABEL'                     => 'Colaboradores',
   'LOG_TRANSFER_POINTS'                   => 'Transferindo %d PontosGold para o usuário %d',
   'LOG_TRANSFER_POINTS_NOT_ENOUGH'        => 'Tentativa de transferir %d PontosGold para o usuário %d, mas não tinha saldo suficiente',
   'LOG_UNLIKE_TRANSFER_POINTS_NOT_ENOUGH' => 'Tentativa de transferir de volta %d PontosGold do usuário %d para o usuário %d após uma remoção de curtida, mas não tinham saldo suficiente',
   'LOG_LIKE_TRANSFER_ABORTED'             => 'Ação de curtida revertida. %d PontosGold devolvidos ao usuário %d pelo usuário %d',
   'REASON_LIKE'                           => 'CURTIDA: Concedidos %d pontos por receber uma curtida de %d.',
   'REASON_UNLIKE'                         => 'REMOÇÃO DE CURTIDA: Retirados %d pontos por receber a remoção de uma curtida de %d.',
   'REASON_LIKE_CONTRIBUTOR'               => 'CURTIDA DE COLABORADOR: Concedidos %d pontos por receber uma curtida de %d como colaborador do autor.',
   'REASON_UNLIKE_CONTRIBUTOR'             => 'REMOÇÃO DE CURTIDA DE COLABORADOR: Retirados %d pontos por remover uma curtida de %d como colaborador do autor.',
   'ENTER_TAGS_PLACEHOLDER'                => 'Insira nomes de usuários',
   'CONTRIBUTED'                           => 'contribuiu',
   'CONTRIBUTEDS'                          => 'contribuíram',
   'NOT_ENOUGH_BALANCE_LIKE'               => 'Você não tem pontos suficientes para agradecer :(<br>Participe e ajude a comunidade para obter mais pontos!',
]);
