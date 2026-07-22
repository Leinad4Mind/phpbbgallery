<?php

/**
 * LikePoints extension for the phpBB Forum Software package.
 * @copyright (c) 2022 Leinad4Mind All rights reserved
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

if (!isset($lang) || !is_array($lang))
{
   $lang = [];
}

$lang = array_merge($lang, [
   'CONTRIBUTOR_LABEL'                     => 'Colaboradores',
   'LOG_TRANSFER_POINTS'                   => 'A transferir %d PontosGold para o utilizador %d',
   'LOG_TRANSFER_POINTS_NOT_ENOUGH'        => 'Tentativa de transferir %d PontosGold para o utilizador %d, mas não tinha saldo suficiente',
   'LOG_UNLIKE_TRANSFER_POINTS_NOT_ENOUGH' => 'Tentativa de transferir de volta %d PontosGold do utilizador %d para o utilizador %d após uma remoção de gosto, mas não tinham saldo suficiente',
   'LOG_LIKE_TRANSFER_ABORTED'             => 'Ação de gosto revertida. %d PontosGold devolvidos ao utilizador %d por parte do utilizador %d',
   'REASON_LIKE'                           => 'GOSTO: Atribuídos %d pontos por receber um gosto de %d.',
   'REASON_UNLIKE'                         => 'REMOÇÃO DE GOSTO: Retirados %d pontos por receber a remoção de um gosto de %d.',
   'REASON_LIKE_CONTRIBUTOR'               => 'GOSTO DE COLABORADOR: Atribuídos %d pontos por receber um gosto de %d como colaborador do autor.',
   'REASON_UNLIKE_CONTRIBUTOR'             => 'REMOÇÃO DE GOSTO DE COLABORADOR: Retirados %d pontos por remover um gosto de %d como colaborador do autor.',
   'ENTER_TAGS_PLACEHOLDER'                => 'Introduz nomes de utilizadores',
   'CONTRIBUTED'                           => 'contribuiu',
   'CONTRIBUTEDS'                          => 'contribuíram',
   'NOT_ENOUGH_BALANCE_LIKE'               => 'Não tens pontos suficientes para agradecer :(<br>Participa e ajuda a comunidade de forma a obteres mais pontos!',
]);
