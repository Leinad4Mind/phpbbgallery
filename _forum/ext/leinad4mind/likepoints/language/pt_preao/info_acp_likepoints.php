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
   'PER_LIKES_ENABLE' => 'Enable transfer of BBPoints for likes',
   'PER_LIKES_AMOUNT' => 'Amount of BBPoints transferred on liking the post',
   'ACP_POINTS_PER_LIKES' => 'Points per likes',
   'ACP_POINTS_PER_LIKES_EXPLAIN' => 'Set the default amount of points transferred on liking posts. Set to 0 to switch off.',
   'CONTRIBUTORS_ENABLE' => 'Enable contributors',
   'SYNC_LIKE_POINTS' => 'Sync like points',
   'SYNC_LIKE_POINTS_EXPLAIN' => 'Calculates all the points for likes set above for all the users.<br>It can take several minutes and it depends on how many users, posts and likes your board hosts.<br>Do NOT interrput the process once started.',
   'SYNC_LIKE_POINTS_PROCESSING' => 'Processing...',
   'SYNC_LIKE_POINTS_TOTAL_POSTS' => 'Total posts',
]);
