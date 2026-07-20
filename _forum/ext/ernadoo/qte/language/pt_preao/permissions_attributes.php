<?php

/**
 * @package Quick Title Edition Extension for phpBB.
 * @copyright (c) 2015 ABDev
 * @copyright (c) 2015 PastisD
 * @copyright (c) 2015 Geolim4 <http://geolim4.com>
 * @copyright (c) 2015 Zoddo <zoddo.ino@gmail.com>
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 * @translation Leinad4Mind [Portuguese [pt_preao]] (2026)
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

$lang = array_merge($lang, [
	'ACL_A_ATTR_MANAGE' => 'Pode gerir atributos de tópicos',
	'ACL_M_ATTR_DEL'    => 'Pode eliminar atributos',
	'ACL_M_ATTR_EDIT'   => 'Pode editar atributos',

	'ACL_CAT_QTE' => 'QTE',
]);
