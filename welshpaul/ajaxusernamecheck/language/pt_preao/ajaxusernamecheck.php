<?php
/**
 * AJAX Username Check
 * @copyright (c) 2020 WelshPaul. All rights reserved.
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
	'WELSHPAUL_AJAXUSERNAMECHECK_INVALID_QUERY'        => 'A query é inválida!',
	'WELSHPAUL_AJAXUSERNAMECHECK_USERNAME_OK'          => '<i class="fa fa-check"></i>&nbsp;Nome ainda disponível',
	'WELSHPAUL_AJAXUSERNAMECHECK_USERNAME_TAKEN'       => '<i class="fa fa-times"></i>&nbsp;Esse nome já tem registo',
	'WELSHPAUL_AJAXUSERNAMECHECK_USERNAME_DISALLOWED'  => '<i class="fa fa-times"></i>&nbsp;Nome não permitido',
]);
