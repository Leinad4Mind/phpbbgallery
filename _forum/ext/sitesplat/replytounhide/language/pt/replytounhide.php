<?php
/**
*
 * @package ReplyToUnhide
 * @copyright (c) 2016 SiteSplat <http://sitesplat.com>
 * @license Proprietary
*
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

$lang = array_merge($lang, array(
	// Hide BBCode
	'HIDE_ON'		=> 'Conteúdo Oculto',
	'HIDE_OFF'		=> 'Conteúdo Oculto (Apenas para membros)',
	'HIDE_EXPLAIN'	=> 'Precisas de <strong>agradecer</strong> o tópico para poderes visualizar o conteúdo.<br><br>Se estiver difícil... Procura por um botão como este: <a href="#thanks_button"><span class="btn-primary btn-sm">&nbsp;<i class="fa fa-thumbs-up"></i><strong>&nbsp;Agradecer</strong></span></a> Acreditamos em ti! Tu consegues encontrá-lo!',
	'HIDE_HELPLINE'	=> '[hide]{TEXT}[/hide]'
));
