<?php

/**
 * @package cBB Blockgets for phpBB.
 * @version 2.0.7 01/07/2024
 * @copyright (c) 2024 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 * @translation Leinad4Mind [Brazilian Portuguese [pt_br]] (2026)
 */

// @ignore
if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = [];
}

// Local Variables
$lang = array_merge($lang, [
	'PORTAL'      => 'Portal',
	'DOCK_MENU'   => 'Menu Dock',
	'MAIN_MENU'   => 'Menu Principal',
	'RECOMMENDED' => 'Recomendado',

	'P_ADMIN' => 'Administração',
	'P_MAIN'  => 'Principal',
	'P_MCP'   => 'Painel de Moderação',
	'P_ACP'   => 'Painel de Administração',

	'PHPBB_TITLE'       => 'Site oficial do phpBB',
	'XAMPP_TITLE'       => 'Xampp',
	'SOURCEFORGE_TITLE' => 'Aplicativos de código aberto',

	'WELCOME_GUEST'  => '[html]<div style="text-align:center; font-size:1.2em;"><a href="https://www.canidev.com"><span class="blg-image logo-img"></span></a><br /><strong><i>Fórum equipado com o cBB Blockgets</i><br /><br />Bem-vindo ao nosso fórum!<br />Registre-se para acessar todo o conteúdo!.</strong></div>[/html]',
	'WELCOME_MEMBER' => '[html]<div style="text-align:center; font-size:1.2em;"><a href="https://www.canidev.com"><span class="blg-image logo-img"></span></a><br /><strong><i>Fórum equipado com o cBB Blockgets</i><br /><br />Bem-vindo de volta ao nosso fórum, {S_USERNAME}</strong></div>[/html]',

	'CORE_INSTALL_ERROR' => 'Você não enviou todos os arquivos do pacote de instalação ou está tentando instalar um pacote desatualizado.<br />
		Certifique-se de enviar todos os arquivos (incluindo a pasta <em>core</em>) e use um pacote baixado do site oficial.',
]);
