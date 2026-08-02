<?php
/**
 * @package User Login Redirect
 * @copyright (c) 2026 Leinad4Mind
 * @license GNU General Public License, version 2 (GPL-2.0)
 * @translation Leinad4Mind [Brazilian Portuguese [pt_br]] (2026)
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
	'NEW_VERSION_LINK' => 'Descarregue aqui',
	'NO_VERSION_EXPLAIN' => 'A informação de atualização da versão não está disponível.',
	'VERSION' => 'Versão',
));
