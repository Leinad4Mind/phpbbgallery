<?php

/**
 *
 * LikePoints extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2022 Leinad4Mind All rights reserved
 * @license Proprietary
 *
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
   'CONTRIBUTOR_LABEL' => 'Contributors',
   'LOG_TRANSFER_POINTS' => 'Transferring %d BBPoints to user %d',
   'LOG_TRANSFER_POINTS_NOT_ENOUGH' => 'Tried to transfer %d BBPoints to user %d, but did not have enough on balance',
   'LOG_DISLIKE_TRANSFER_POINTS_NOT_ENOUGH' => 'Tried to transfer %d BBPoints back from user %d to user %d after a dislike, but they did not have enough on balance',
   'LOG_LIKE_TRANSFER_ABORTED' => 'Like action taken back. %d BBPoints returned to user %d from user %d',
   'REASON_LIKE' => 'Awarded %d points for getting a like from %d.',
   'REASON_DISLIKE' => 'Taken %d points for getting a dislike from %d.',
   'REASON_LIKE_KUDO' => 'Awarded %d points for getting a like from %d as contributors from the poster.',
]);