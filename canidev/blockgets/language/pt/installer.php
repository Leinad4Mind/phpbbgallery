<?php

/**
 * @package cBB Blockgets for phpBB.
 * @version 2.0.7 01/07/2024
 * @copyright (c) 2024 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 * @translation Leinad4Mind [Portuguese [pt]] (2026)
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
	'MAIN_MENU'   => 'Menu principal',
	'RECOMMENDED' => 'Recomendado',

	'P_ADMIN' => 'Administração',
	'P_MAIN'  => 'Principal',
	'P_MCP'   => 'Painel de Moderação',
	'P_ACP'   => 'Painel de Administração',

	'PHPBB_TITLE'       => 'Site oficial do phpBB',
	'XAMPP_TITLE'       => 'Xampp',
	'SOURCEFORGE_TITLE' => 'Aplicações de código aberto',

	'WELCOME_GUEST'  => '[html]<div style="text-align:center; font-size:1.2em;"><a href="https://www.canidev.com"><span class="blg-image logo-img"></span></a><br /><strong><i>Fórum equipado com o cBB Blockgets</i><br /><br />Bem-vindo ao nosso fórum!<br />Regista-te para aceder a todo o conteúdo!.</strong></div>[/html]',
	'WELCOME_MEMBER' => '[html]<div style="text-align:center; font-size:1.2em;"><a href="https://www.canidev.com"><span class="blg-image logo-img"></span></a><br /><strong><i>Fórum equipado com o cBB Blockgets</i><br /><br />Bem-vindo de volta ao nosso fórum, {S_USERNAME}</strong></div>[/html]',

	'CORE_INSTALL_ERROR' => 'Não fizeste upload de todos os ficheiros do pacote de instalação ou estás a tentar instalar um pacote desatualizado.<br />
		Certifica-te de que fazes upload de todos os ficheiros (incluindo a pasta <em>core</em>) e utiliza um pacote transferido a partir do site oficial.',
]);
