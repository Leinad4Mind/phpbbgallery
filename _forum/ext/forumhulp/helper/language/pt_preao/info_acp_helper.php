<?php

/**
 * @package Forumhulp Helper for phpBB.
 * @copyright (c) 2015 ForumHulp.com
 * @license Proprietary
 * @translation Leinad4Mind [Portuguese [pt_preao]] (2026)
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
	'FH_DISABLE_ALL'        => 'Desactivar todas as extensões',
	'LOG_CORE_INSTALLED'    => '<strong>Ajudante Forumhulp</strong><br />» Ficheiros alterados com sucesso',
	'LOG_CORE_DEINSTALLED'  => '<strong>Ajudante Forumhulp</strong><br />» Ficheiros restaurados com sucesso',
	'LOG_CORE_NOT_REPLACED' => '<strong>Ajudante Forumhulp</strong><br />» Não foi possível substituir ficheiro(s)<br />» %s',
	'LOG_CORE_NOT_UPDATED'  => '<strong>Ajudante Forumhulp</strong><br />» Não foi possível actualizar ficheiro(s)<br />» %s',
	'ERROR_DISABLE'         => 'Não pode desactivar o Ajudante ForumHulp devido a extensões ForumHulp ativas<br /><div style="margin: 0px auto; width: 50%%; text-align: left;">» %s</div>'
]);
