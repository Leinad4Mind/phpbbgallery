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
   $lang = array();
}

$lang = array_merge($lang, [
   'PER_LIKES_ENABLE' => 'Enable transfer of BBPoints for likes',
   'PER_LIKES_AMOUNT' => 'Amount of BBPoints transferred on liking the post',
]);