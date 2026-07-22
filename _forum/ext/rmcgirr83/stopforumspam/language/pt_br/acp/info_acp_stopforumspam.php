<?php
/**
*
* Stop forum Spam extension for the phpBB Forum Software package.
*
* @copyright (c) 2015 Rich McGirr (RMcGirr83)
* @license GNU General Public License, version 2 (GPL-2.0)
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
// Some characters for use
// ’ » “ ” …


$lang = array_merge($lang, [

	// ACP entries
	'ACP_SFS_TITLE'			=> 'Stop Forum Spam',
	'SFS_CONTROL'			=> 'Configurações do Stop Forum Spam',
	// ACP message logs
	'LOG_SFS_MESSAGE'		=> '<strong>Stop Forum Spam acionado</strong>:<br />Nome de usuário: %1$s<br />IP: %2$s<br />E-mail: %3$s',
	'LOG_SFS_DOWN'			=> '<strong>O Stop Forum Spam estava fora do ar durante um registro ou uma postagem no fórum</strong>',
	'LOG_SFS_DOWN_USER_ALLOWED' => '<strong>O Stop Forum Spam estava fora do ar.</strong> O seguinte usuário foi permitido no fórum:<br />Nome de usuário: %1$s<br />IP:%2$s<br />E-mail: %3$s',
	'LOG_SFS_NEED_CURL'		=> 'A extensão stop forum spam precisa do <strong>cURL</strong> para funcionar corretamente. Por favor, fale com o seu provedor de hospedagem para que o cURL seja instalado e ativado.',
	'LOG_SFS_CURL_ERROR'	=> '<strong>Erro cURL do Stop Forum Spam</strong><br>» %1$s',
	'LOG_SFS_CONFIG_SAVED'	=> '<strong>Configurações do Stop Forum Spam alteradas</strong>',
	'LOG_SFS_REPORTED'		=> '<strong>O usuário foi denunciado ao Stop Forum Spam</strong><br>» %1$s',
	'LOG_SFS_PM_REPORTED'	=> '<strong>A MP do usuário foi denunciada ao Stop Forum Spam</strong><br>» %1$s',
	'LOG_SFS_REPORTED_CLEARED'	=> 'As mensagens e mensagens privadas denunciadas ao stop forum spam foram limpas',
	'LOG_ADMINSMODS_CACHE_BUILT'	=> 'O cache de Administradores e Moderadores do stop forum spam foi criado',
]);
