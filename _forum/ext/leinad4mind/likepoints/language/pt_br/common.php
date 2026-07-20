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
   'LOG_TRANSFER_POINTS'                   => 'Transferring %d BBPoints to user %d',
   'LOG_TRANSFER_POINTS_NOT_ENOUGH'        => 'Tried to transfer %d BBPoints to user %d, but did not have enough on balance',
   'LOG_UNLIKE_TRANSFER_POINTS_NOT_ENOUGH' => 'Tried to transfer %d BBPoints back from user %d to user %d after a unlike, but they did not have enough on balance',
   'LOG_LIKE_TRANSFER_ABORTED'             => 'Like action taken back. %d BBPoints returned to user %d from user %d',
   'REASON_LIKE'                           => 'LIKE: Awarded %d points for getting a like from %d.',
   'REASON_UNLIKE'                         => 'UNLIKE: Taken %d points for getting a unlike from %d.',
   'REASON_LIKE_CONTRIBUTOR'               => 'CONTRIBUTOR LIKE: Awarded %d points for getting a like from %d as contributors from the poster.',
   'REASON_UNLIKE_CONTRIBUTOR'             => 'CONTRIBUTOR UNLIKE: Taken %d points for removing a like from %d as contributors from the poster.',
   'ENTER_TAGS_PLACEHOLDER'                => 'Introduza nomes de usuários',
   'CONTRIBUTED'                           => 'contribuiu',
   'CONTRIBUTEDS'                          => 'contribuíram',
   'NOT_ENOUGH_BALANCE_LIKE'               => 'Não tem pontos suficientes para agradecer :(<br>Participa e ajuda a comunidade de forma a obteres mais pontos!',
]);
