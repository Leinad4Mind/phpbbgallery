<?php
/**
 *
 * This file is part of the phpBB Forum Software package.
 * Russian translation by HD321kbps
 *
 * @copyright (c) phpBB Limited <https://www.phpbb.com>
 * @license GNU General Public License, version 2 (GPL-2.0)
 *
 * For full copyright and license information, please see
 * the docs/CREDITS.txt file.
 *
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
	'TIME_TO_READ'	=> array(
		1 => 'Прочитано %d минуту назад',
		2 => 'Прочитано %d минуты назад',
		3 => 'Прочитано %d минут назад'
	),
));
