<?php
/**
 * AJAX Username Check
 * @copyright (c) 2020 WelshPaul. 2025 Leinad4Mind. All rights reserved.
 * @license Proprietary
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
    'WELSHPAUL_AJAXUSERNAMECHECK_INVALID_QUERY'        => 'The query is invalid!',
    'WELSHPAUL_AJAXUSERNAMECHECK_USERNAME_OK'          => '<i class="fa fa-check"></i>&nbsp;Username is available',
    'WELSHPAUL_AJAXUSERNAMECHECK_USERNAME_TAKEN'       => '<i class="fa fa-times"></i>&nbsp;Username is taken',
    'WELSHPAUL_AJAXUSERNAMECHECK_USERNAME_DISALLOWED'  => '<i class="fa fa-times"></i>&nbsp;Username is not allowed',
]);
