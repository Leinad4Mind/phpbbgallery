<?php

/**
 * @package sitesplat BBcore for phpBB.
 * common [English]
 * @version $Id$
 * @copyright (c) 2015 SiteSplat All rights reserved
 * @license Proprietary
 * @translation Leinad4Mind [Brazilian Portuguese [pt_br]] (2026)
 */

// TRANSLATORS PLEASE NOTE
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

$lang = array_merge($lang, [

	'ACP_SITESPLAT_UPDATE_MANAGER' => 'Administrar Actualizações de SiteSplat',
	'VERSION_INSTALLED'            => 'Versão Instalada',
	'NEW_BOOTS_VERSION'            => 'Nova versão disponível: %s',
	'VERSIONNUMBERS'               => 'Versão instalada: %s, transfira a nova versão que se encontra no servidor: <a style="color:#fff;" href="%s" title="Transferir" target="_blank">%s</a>',
	'SS_RAPID_DISABLE'             => 'Desactivar Rápido SS',
	'SS_RAPID_DISABLE_TLT'         => 'Desactiva (todas) as extensões SiteSplat de uma só vez. Faça um Backup primeiro!!!',

	'DOWNLOAD_MSG'      => 'A versão actual <span class="label label-success">%s</span> pode ser transferida pelo Themeforest: <a href="%s" title="Transferir" target="_blank">%s - phpBB3</a>',
	'CHANGE_LOG_MSG'    => 'O Changelog encontra-se aqui: <a href="%s" target="_blank">%s (phpBB3.1) Changelog</a>',
	'SUPPORT_FORUM_MSG' => 'O Fórum de Suporte encontra-se na página oficial da comunidade: <a href="%s" title="Transferir" target="_blank">http://www.sitesplat.com</a>',
	'COLORIZE_MSG'      => 'O serviço Colorize encontra-se aqui: <a href="http://www.sitesplat.com/phpBB3/themer.php" target="_blank">Colorize</a> (Certifique-se de entrar na sua conta primeiro)',
	'NO_VERSIONINFO'    => 'Informação da versão não se encontra disponível de momento, tente mais tarde!',

	'LOG_FILES_CHANGED'        => '<strong>O BBcore alterou o(s) seguinte(s) %s arquivo(s) por ti:</strong><br />» %s',
	'LOG_THEME_INSTALLED'      => '<strong>O BBcore foi instalado com sucesso</strong>',
	'LOG_FILES_CHANGED_FAILED' => '<strong>O BBcore não foi instalado com sucesso</strong><br />» Algumas funcionalidades podem não funcionar!',
	'LOG_THEME_UNINSTALLED'    => '<strong>O BBcore foi desinstalado com sucesso</strong>',

	'LOG_FILE_NOT_REPLACED' => '<strong>O BBcore não conseguiu substituir o arquivo original por ti:</strong><br />» %s',
	'LOG_FILE_NOT_UPDATED'  => '<strong>O BBcore não conseguiu actualizar o(s) seguinte(s) %s arquivo(s) por ti:</strong><br />» %s',

	'LOG_BBCORE_INSTALLED'   => '<strong>O Sitesplat BBCore foi instalado com sucesso</strong>',
	'LOG_BBCORE_DEINSTALLED' => '<strong>O Sitesplat BBCore foi desinstalado com sucesso</strong>',

	'LOG_BBCORE_NOT_REPLACED' => '<strong>O Sitesplat BBCore não foi desinstalado com sucesso</strong><br />Não foi possível substituir o(s) seguinte(s) arquivo(s)<br />» %s',
	'LOG_BBCORE_NOT_UPDATED'  => '<strong>O Sitesplat BBCore não foi instalado com sucesso</strong><br />Não conseguiu actualizar o(s) seguinte(s) arquivo(s)<br />» %s',

	'ACP_BBCORE_MSG_FILES_FAIL' => 'Nem TODOS os arquivos foram editados! Por favor, substitui manualmente o(s) arquivo(s) mencionado(s) no Log Administrativo situado na ABA MANUTENÇÃO.',
	'ACP_BBCORE_MSG_SETTINGS'   => 'Não existem configurações para esta extensão.<br />No entanto, nem todas as actualizações foram implementadas correctamente devido a problemas nas permissões de arquivos no servidor ou à falta de arquivos nele.<br />Vê o Log Administrativo para mais informações.<br /><br />Por favor, actualiza os arquivos manualmente para desfrutar de todas as funcionalidades.',
	'BBCORE_ERROR_DISABLE'      => 'Não pode desactivar o SiteSplat BBCore devido a outras extensões SiteSplat\'s que se encontram ainda activas.<br />Desactive primeiro as extensões SiteSplat\'s. (Pode usar o "Desactivar Rápido SS" para desactivar todas as extensões SiteSplat\'s de uma só vez.)<br /><br /><div style="margin: 0px auto; width: 50%%;"><strong>» %s</strong></div>'
]);
