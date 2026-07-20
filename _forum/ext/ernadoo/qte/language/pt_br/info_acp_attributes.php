<?php

/**
 * @package Quick Title Edition Extension for phpBB.
 * @copyright (c) 2015 ABDev
 * @copyright (c) 2015 PastisD
 * @copyright (c) 2015 Geolim4 <http://geolim4.com>
 * @copyright (c) 2015 Zoddo <zoddo.ino@gmail.com>
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 * @translation Leinad4Mind [Brazilian Portuguese [pt_br]] (2026)
 */

// ignore
if (!defined('IN_PHPBB'))
{
	exit;
}

// init lang ary, if it doesn't !
if (empty($lang) || !is_array($lang))
{
	$lang = [];
}

// administration
$lang = array_merge($lang, [
	'QTE_MANAGE'         => 'Gerenciar atributos do tópico',
	'QTE_MANAGE_TITLE'   => 'Atributos do tópico',
	'QTE_MANAGE_EXPLAIN' => 'Aqui você pode gerenciar os termos e os ícones usados ​​como atributos do tópico.',
]);
