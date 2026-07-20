<?php

/**
 * No DEA Emails. An extension for the phpBB Forum Software package.
 * @copyright (c) 2020, Picaron, https://github.com/picaronin/
 * @license GNU General Public License, version 2 (GPL-2.0)
 * @translation Leinad4Mind [Brazilian Portuguese [pt_br]] (2026)
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

$lang = array_merge($lang, [
	'NO_DEA_EMAILS_INSTALL_ERROR'      => '?oNo DEA Emails?? não pode ser instalada.<br><br>- É necessário o PhpBB 3.2.4 ou superior.',
	'NO_DEA_EMAILS_PHP_ERROR'          => '?oNo DEA Emails?? não pode ser instalada.<br><br>- É necessário o PHP 5.6.0 ou superior.',
	'NO_DEA_EMAILS_NO_CURL'            => '?oNo DEA Emails?? não pode ser instalada.<br><br>- É necessária a extensão ?ocurl?? carregada no PHP.',
	'NO_DEA_EMAILS_FOUND'              => 'ERRO: O domínio de e-mail ((%s)) não é válido.<br>O nosso site NÃO suporta contas de e-mail descartáveis ou temporárias <a href="https://bit.ly/2LBsbqe" target="_blank">(DEA)</a>.<br>Se deseja continuar o registro no nosso site, tem de utilizar uma conta de e-mail não descartável.',
	'NO_DEA_EMAILS_TITLE_FORCE_CHANGE' => 'Alteração Exigida pela Extensão ?oNo DEA Emails??',
	'NO_DEA_EMAILS_FORCE_CHANGE'       => 'Antes de continuar a navegar no site, necessita de alterar o seu "E-mail".',
	'NO_DEA_EMAILS_NOT_FORCE_CHANGE'   => 'Antes de continuar a navegar no site, necessita de alterar o seu "E-mail".<br>Não tem permissões para efetuar a alteração.<br>Terá de contactar a Administração do site e solicitar a atualização.',
	'LOG_NO_DEA_EMAILS'                => 'Bloquear e-mails DEA',
	'LOG_NO_DEA_EMAILS_SETTINGS'       => 'Gestão Cron & Domínios de e-mail DEA externos',
	'LOG_NO_DEA_EMAILS_LOCALS'         => 'Gestão local de domínios de e-mail DEA',
	'LOG_NO_DEA_EMAILS_USERS'          => 'Usuários com contas de e-mail DEA',
]);
