<?php

/**
*
* @package PM Welcome [Brazilian Portuguese] 
* @copyright BB3.Mobi 2015 (c) Anvar(http://apwa.ru)
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
* Translated to Brazilian Portuguese by null2 (https://github.com/phpBBTraducoes)
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
// ’ « » “ ” …
//

$lang = array_merge($lang, array(
	'ACP_PMWELCOME'					=> 'Mensagem de Boas-Vindas',
	'ACP_PMWELCOME_EXPLAIN'			=> 'Você pode definir o texto da Mensagem Privada que será enviada ao usuário em seu primeiro acesso.',
	'ACP_PMWELCOME_SETTINGS'		=> 'Configuração da mensagem de Boas-Vindas.',
	'ACP_PMWELCOME_USER'			=> 'Remetente',
	'ACP_PMWELCOME_USER_EXPLAIN'	=> 'Coloque a identificação do usuário remetente da Mensagem Privada.',
	'ACP_PMWELCOME_SUBJECT'			=> 'Assunto da mensagem',
	'ACP_PMWELCOME_TEXT'			=> 'Texto da mensagem',
	'ACP_PMWELCOME_TEXT_EXPLAIN'	=> 'Você pode usar bbcodes, smiles e as chaves "{USERNAME}, {USER_EMAIL}, {SITE_NAME}, {SITE_DESC}, {BOARD_CONTACT}, {BOARD_EMAIL} e {BOARD_SIG}".',
));
