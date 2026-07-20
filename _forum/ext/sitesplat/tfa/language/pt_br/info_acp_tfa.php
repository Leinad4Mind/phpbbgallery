<?php

/**
 * @package Two Factor Authentication for phpBB.
 * @copyright (c) 2016 SiteSplat All rights reserved
 * @license Proprietary
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
	'TFA' => 'Autenticação de Dois Fatores (Two Factor Authentication)',

	'TFA_SETTING'         => 'Configuração da Autenticação de Dois Fatores',
	'TFA_SETTING_EXPLAIN' => 'Selecione as opções de Autenticação de Dois Fatores',

	'TFA_DISABLED'               => 'Autenticação de dois fatores desabilitada',
	'TFA_NOT_REQUIRED'           => 'Não exigir autenticação de dois fatores',
	'TFA_REQUIRED_FOR_ACP_LOGIN' => 'Exigir autenticação de dois fatores apenas para o início de sessão (login) no ACP',
	'TFA_REQUIRED_FOR_ADMIN'     => 'Exigir autenticação de dois fatores para todos os administradores',
	'TFA_REQUIRED_FOR_MODERATOR' => 'Exigir autenticação de dois fatores para todos os moderadores e administradores',
	'TFA_REQUIRED'               => 'Exigir autenticação de dois fatores para todos os usuários',

	'TFA_NOTICE'     => '<div class="phpinfo"><p>As configurações desta extensão encontram-se em <strong>%1$s » %2$s » %3$s</strong>.</p></div>',
	'SS_HELPER_NOTY' => 'O SiteSplat BBcore não existe!<br />Faça o download do <a href="http://sitesplat.com" target="_blank">BBcore</a> e copie a pasta BBcore para a pasta da sua extensão sitesplat.',
]);
