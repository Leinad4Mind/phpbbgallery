<?php
/**
 * @package User Login Redirect
 * @copyright (c) 2026 Leinad4Mind
 * @license GNU General Public License, version 2 (GPL-2.0)
 * @translation Leinad4Mind [Portuguese [pt]] (2026)
 */

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

$lang = array_merge($lang, array(
	'NEW_VERSION' => 'Nova Versão - %s',
	'NEW_VERSION_LINK' => 'Transfere aqui',
	'NO_VERSION_EXPLAIN' => 'A informação de atualização da versão não está disponível.',
	'VERSION' => 'Versão',
));
