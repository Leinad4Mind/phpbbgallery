<?php
/**
*
* @package User Login Redirect
* @copyright (c) 2014 david63
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
*/

/**
* DO NOT CHANGE
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
//
// Some characters you may want to copy&paste:
// ’ » “ ” …
//

$lang = array_merge($lang, array(
	'REDIRECT_LOGIN_ANNOUNCE_TOPIC'		=> 'Você se logou. Um novo anúncio foi postado desde sua última visita e você será direcionado para lá.',
	'REDIRECT_LOGIN_GROUP_TOPIC'		=> 'Você se logou. Uma nova mensagem de grupo foi postada desde sua última visita e você será direcionado para lá.',
	'REDIRECT_LOGIN_WELCOME_TOPIC'		=> 'Você se logou. Como é sua primeira visita, você será direcionado à página de apresentações.',

	'REDIRECT_REFRESH_ANNOUNCE'			=> '%sIr ao novo anúncio%s',
	'REDIRECT_REFRESH_GROUP' 			=> '%sIr à mensagem de grupo%s',
	'REDIRECT_REFRESH_WELCOME'			=> '%sIr à página de apresentações%s',
));
