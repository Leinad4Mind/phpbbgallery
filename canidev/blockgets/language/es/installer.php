<?php
/*
* [Spanish [Es]]
* @package cBB Blockgets
* @version v2.0.4 30/08/2021
*
* @copyright (c) 2021 CaniDev
* @license https://opensource.org/licenses/gpl-license.php GNU Public License
*/

// @ignore
if(!defined('IN_PHPBB'))
{
	exit;
}

if(empty($lang) || !is_array($lang))
{
	$lang = array();
}

// Local Variables
$lang = array_merge($lang, array(
	'PORTAL'			=> 'Portal',
	'DOCK_MENU'			=> 'Menú Dock',
	'MAIN_MENU'			=> 'Menú Principal',
	'RECOMMENDED'		=> 'Recomendados',

	'P_ADMIN'			=> 'Administración',
	'P_MAIN'			=> 'Principal',
	'P_MCP'				=> 'Panel de Moderación',
	'P_ACP'				=> 'Panel de Administración',

	'PHPBB_TITLE'		=> 'Sitio oficial de phpBB',
	'XAMPP_TITLE'		=> 'Xampp',
	'SOURCEFORGE_TITLE'	=> 'Aplicaciones libres',

	'WELCOME_GUEST'		=> '[html]<div style="text-align:center; font-size:1.2em;"><a href="https://www.canidev.com"><span class="blg-image logo-img"></span></a><br /><strong><i>Foro equipado con cBB Blockgets</i><br /><br />¡Bienvenido a nuestro foro!<br />Regístrese para tener acceso a todo el contenido.</strong></div>[/html]',
	'WELCOME_MEMBER'	=> '[html]<div style="text-align:center; font-size:1.2em;"><a href="https://www.canidev.com"><span class="blg-image logo-img"></span></a><br /><strong><i>Foro equipado con cBB Blockgets</i><br /><br />Bienvenido de nuevo a nuestro foro {S_USERNAME}</strong></div>[/html]',

	'CORE_INSTALL_ERROR'	=> 'No ha subido todos los archivos del paquete de instalación o está intentando instalar un paquete antiguo.<br />
		Por favor, asegúrese de subir todos los archivos (incluída la carpeta <em>core</em>) y de utilizar un paquete descargado de la web oficial.',
));
