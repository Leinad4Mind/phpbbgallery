<?php
/**
 *
 * @package phpBB Extension - Username Colour Changer
 * @copyright (c) 2015 dmzx - https://www.dmzx-web.net
 * @license https://opensource.org/licenses/GPL-2.0 GNU General Public License v2
 * @translation Leinad4Mind [Brazilian Portuguese [pt_br]] (2026)
 *
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
	'COLOUR' => 'Alteração da cor do nome de usuário',
	'USERNAMECOLOURCHANGER_INVALID_COLOUR' => 'A cor do nome de usuário deve ficar vazia ou conter três ou seis dígitos hexadecimais.',
]);
