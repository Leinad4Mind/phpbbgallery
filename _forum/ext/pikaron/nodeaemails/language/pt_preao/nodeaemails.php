<?php

/**
 * No DEA Emails. An extension for the phpBB Forum Software package.
 * @copyright (c) 2020, Picaron, https://github.com/picaronin/
 * @license GNU General Public License, version 2 (GPL-2.0)
 * @translation Leinad4Mind [Portuguese [pt_preao]] (2026)
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
	'NO_DEA_EMAILS_INSTALL_ERROR'      => '"No DEA Emails" não pode ser instalada.<br><br>- É necessário o phpBB 3.2.4 ou superior.',
	'NO_DEA_EMAILS_PHP_ERROR'          => '"No DEA Emails" não pode ser instalada.<br><br>- É necessário o PHP 5.6.0 ou superior.',
	'NO_DEA_EMAILS_NO_CURL'            => '"No DEA Emails" não pode ser instalada.<br><br>- É necessária a extensão "curl" do PHP.',
	'NO_DEA_EMAILS_FOUND'              => 'ERRO: O domínio de e-mail ((%s)) não é válido.<br>O nosso site NÃO suporta contas de e-mail descartáveis ou temporárias <a href="https://bit.ly/2LBsbqe" target="_blank">(DEA)</a>.<br>Se desejas continuar o registo no nosso site, tens de utilizar uma conta de e-mail não descartável.',
	'NO_DEA_EMAILS_TITLE_FORCE_CHANGE' => 'Alteração Exigida pela Extensão "No DEA Emails"',
	'NO_DEA_EMAILS_FORCE_CHANGE'       => 'Antes de continuares a navegar no site, precisas de alterar o teu "E-mail".',
	'NO_DEA_EMAILS_NOT_FORCE_CHANGE'   => 'Antes de continuares a navegar no site, precisas de alterar o teu "E-mail".<br>Não tens permissões para efectuar a alteração.<br>Terás de contactar a Administração do site e solicitar a actualização.',
	'LOG_NO_DEA_EMAILS'                => 'No DEA Emails',
	'LOG_NO_DEA_EMAILS_SETTINGS'       => 'Gestão de CRON e Domínios de E-mail DEA Externos',
	'LOG_NO_DEA_EMAILS_LOCALS'         => 'Gestão Local de Domínios de E-mail DEA',
	'LOG_NO_DEA_EMAILS_USERS'          => 'Utilizadores com Contas de E-mail DEA',
]);
