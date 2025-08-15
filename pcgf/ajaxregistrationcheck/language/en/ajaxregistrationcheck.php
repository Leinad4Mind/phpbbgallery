<?php

/**
 * @author    MarkusWME <markuswme@pcgamingfreaks.at>
 * @copyright 2017 MarkusWME
 * @license   http://opensource.org/gpl-2.0.php GNU General Public License v2
 * @version   1.0.0
 */

if (!defined('IN_PHPBB'))
{
    exit;
}

if (empty($lang) || !is_array($lang))
{
    $lang = array();
}

// Merge AJAX Registration Check language data to the existing language data
$lang = array_merge($lang, array(
    'PCGF_AJAXREGISTRATIONCHECK_INVALID_QUERY'        => 'The query is invalid!',
    'PCGF_AJAXREGISTRATIONCHECK_USERNAME_OK'          => 'The given username can be taken.',
    'PCGF_AJAXREGISTRATIONCHECK_EMAIL_INVALID'        => 'The input is not a valid E-Mail address!',
    'PCGF_AJAXREGISTRATIONCHECK_EMAIL_OK'             => 'The given E-Mail address can be taken.',
    'PCGF_AJAXREGISTRATIONCHECK_CONFIRM_PASSWORD_OK'  => 'The given passwords are the same.',
    'PCGF_AJAXREGISTRATIONCHECK_PASSWORD_STRENGTH'    => 'Password strength',
    'PCGF_AJAXREGISTRATIONCHECK_PASSWORD_VERY_WEAK'   => 'Very weak',
    'PCGF_AJAXREGISTRATIONCHECK_PASSWORD_WEAK'        => 'Weak',
    'PCGF_AJAXREGISTRATIONCHECK_PASSWORD_NORMAL'      => 'Normal',
    'PCGF_AJAXREGISTRATIONCHECK_PASSWORD_STRONG'      => 'Strong',
    'PCGF_AJAXREGISTRATIONCHECK_PASSWORD_VERY_STRONG' => 'Very strong',
));
