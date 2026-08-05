<?php
/**
 *
 * @package phpBB Extension - Username Colour Changer
 * @copyright (c) 2015 dmzx - https://www.dmzx-web.net
 * @license https://opensource.org/licenses/GPL-2.0 GNU General Public License v2
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
	'COLOUR' => 'Username colour change',
	'USERNAMECOLOURCHANGER_INVALID_COLOUR' => 'The username colour must be empty or a three- or six-digit hexadecimal value.',
]);
