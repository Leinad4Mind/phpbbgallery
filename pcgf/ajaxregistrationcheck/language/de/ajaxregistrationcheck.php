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
    'PCGF_AJAXREGISTRATIONCHECK_INVALID_QUERY'        => 'Die durchgeführte Abfrage ist ungültig!',
    'PCGF_AJAXREGISTRATIONCHECK_USERNAME_OK'          => 'Der angegebene Benutzername darf verwendet werden.',
    'PCGF_AJAXREGISTRATIONCHECK_EMAIL_INVALID'        => 'Die Eingabe ist keine gültige E-Mail-Adresse!',
    'PCGF_AJAXREGISTRATIONCHECK_EMAIL_OK'             => 'Die angegebene E-Mail-Adresse darf verwendet werden.',
    'PCGF_AJAXREGISTRATIONCHECK_CONFIRM_PASSWORD_OK'  => 'Die angegebenen Passwörter stimmen überein.',
    'PCGF_AJAXREGISTRATIONCHECK_PASSWORD_STRENGTH'    => 'Passwortstärke',
    'PCGF_AJAXREGISTRATIONCHECK_PASSWORD_VERY_WEAK'   => 'Sehr schwach',
    'PCGF_AJAXREGISTRATIONCHECK_PASSWORD_WEAK'        => 'Schwach',
    'PCGF_AJAXREGISTRATIONCHECK_PASSWORD_NORMAL'      => 'Normal',
    'PCGF_AJAXREGISTRATIONCHECK_PASSWORD_STRONG'      => 'Stark',
    'PCGF_AJAXREGISTRATIONCHECK_PASSWORD_VERY_STRONG' => 'Sehr stark',
));
