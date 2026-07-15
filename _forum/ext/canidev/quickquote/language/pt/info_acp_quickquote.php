<?php
/**
* info_acp_quickquote.php [Spanish [Es]]
* @package cBB QuickQuote
* @version v1.0.1 10/02/2019
*
* @copyright (c) 2019 CaniDev
* @license https://opensource.org/licenses/gpl-license.php GNU Public License
*/

// DO NOT CHANGE
if(!defined('IN_PHPBB'))
{
	exit;
}

if(empty($lang) || !is_array($lang))
{
	$lang = array();
}

$lang = array_merge($lang, array(
	'ACP_CAT_QUICKQUOTE'			=> 'QuickQuote',
	'ACP_QUICKQUOTE_CONFIG'			=> 'Configuração',
	'ACP_QUICKQUOTE_CONFIG_EXPLAIN'	=> 'Podes gerir as opções principais da extensão.',
	
	'MAIN_OPTIONS'					=> 'Opções principais',
	'QUICKQUOTE_FLOATBTN'			=> 'Botão flutuante',
	'QUICKQUOTE_FLOATBTN_EXPLAIN'	=> 'Si se habilita, se mostrará un botón en la parte inferior de todas las páginas permitidas, mostrando las citas guardadas.
		En caso contrario, se mostrará un botón en el editor para insertar las citas',
	'QUICKQUOTE_GROUPS'				=> 'Grupos autorizados',
	'QUICKQUOTE_GROUPS_EXPLAIN'		=> 'Define os grupos que poderão utilizar esta extensão.<br />
		Podes seleccionar vários grupos usando a tecla <em>Ctrl</em> do teclado.<br /><br />
		<em>Para além deste parâmetro, o uso da extensão estará condicionado pelas permisões para publicar mensagens.</em>',
	'QUICKQUOTE_REPLY_OVERWRITE'			=> 'Sobrescrever texto da resposta',
	'QUICKQUOTE_REPLY_OVERWRITE_EXPLAIN'	=> 'Decide se o texto escrito na resposta rápida será substituído ao usar a funcão <em>responder</em>.<br />
		Caso escolha "Não", a citação será inserido no fim do texto.',
	
	'ALL_GROUPS'				=> 'Todos os grupos',
	'DOCUMENTATION_AND_SUPPORT'	=> 'Documentação e Suporte',
	'SAVE'						=> 'Guardar',
));
