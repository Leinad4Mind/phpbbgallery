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
   'PER_LIKES_ENABLE' => 'Enable transfer of BBPoints for likes',
   'PER_LIKES_AMOUNT' => 'Amount of BBPoints transferred on liking the post',
   'CONTRIBUTORS_ENABLE' => 'Enable contributors',
   'SYNC_LIKE_POINTS' => 'Sync like points',
   'SYNC_LIKE_POINTS_EXPLAIN' => 'Calculates all the points for likes set above for all the users.<br>It can take several minutes and it depends on how many users, posts and likes your board hosts.<br>Do NOT interrput the process once started.',
]);
