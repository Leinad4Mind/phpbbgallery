<?php

/**
*
* @package PM Welcome [Portuguese] 
* @copyright (c) 2019 Leinad4Mind
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
* Translated to Portuguese by Leinad4Mind (https://leinad4mind.top/forum)
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
	$lang = [];
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
// ’ « » “ ” …
//

$lang = array_merge($lang, [
	'ACP_PMWELCOME'					=> 'Mensagem de Boas-Vindas',
	'ACP_PMWELCOME_EXPLAIN'			=> 'Pode definir o corpo da Mensagem Privada que será enviada ao utilizador quando este entrar pela primeira vez no fórum.',
	'ACP_PMWELCOME_SETTINGS'		=> 'Configuração da mensagem de Boas-Vindas.',
	'ACP_PMWELCOME_USER'			=> 'Remetente',
	'ACP_PMWELCOME_USER_EXPLAIN'	=> 'Coloque a identificação do utilizador remetente da Mensagem Privada.',
	'ACP_PMWELCOME_SUBJECT'			=> 'Assunto da mensagem',
	'ACP_PMWELCOME_TEXT'			=> 'Corpo da mensagem',
	'ACP_PMWELCOME_TEXT_EXPLAIN'	=> 'Pode usar BBCodes, Smilies e as variáveis "{USERNAME}, {USER_EMAIL}, {SITE_NAME}, {SITE_DESC}, {BOARD_CONTACT}, {BOARD_EMAIL} e {BOARD_SIG}".',
]);
