<?php

/**
 * @copyright (c) 2024
 * @license GNU General Public License, version 2 (GPL-2.0)
 * @translation Leinad4Mind [Portuguese [pt]] (2026)
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
	'CREATE_POST'        => '%s %s criou uma nova %s no tópico %s localizado no fórum %s',
	'UPDATE_POST_SELF'   => '%s %s editou a sua %s no tópico %s localizado no fórum %s',
	'UPDATE_POST_OTHER'  => '%s %s editou a %s escrita por %s no tópico %s localizado no fórum %s',
	'DELETE_POST'        => '%s Eliminou mensagem do utilizador %s no tópico %s localizado no fórum %s',
	'LOCK_POST'          => '%s A %s escrita pelo utilizador %s no tópico intitulado %s no fórum %s foi bloqueada',
	'UNLOCK_POST'        => '%s A %s escrita pelo utilizador %s no tópico intitulado %s no fórum %s foi desbloqueada',
	'APPROVE_POST'       => '%s A %s escrita pelo utilizador %s no tópico intitulado %s no fórum %s foi aprovada',
	'CREATE_TOPIC'       => '%s %s criou um novo tópico intitulado %s no fórum %s',
	'UPDATE_TOPIC_SELF'  => '%s %s editou o seu tópico %s localizado no fórum %s',
	'UPDATE_TOPIC_OTHER' => '%s %s editou o tópico %s escrito por %s localizado no fórum %s',
	'DELETE_TOPIC'       => '%s Eliminou o tópico iniciado pelo utilizador %s intitulado \'%s\' contendo %d mensagens no fórum %s',
	'LOCK_TOPIC'         => '%s O tópico intitulado %s no fórum %s iniciado pelo utilizador %s foi bloqueado',
	'UNLOCK_TOPIC'       => '%s O tópico intitulado %s no fórum %s iniciado pelo utilizador %s foi desbloqueado',
	'APPROVE_TOPIC'      => '%s O tópico intitulado %s no fórum %s iniciado pelo utilizador %s foi aprovado',
	'CREATE_USER'        => '%s Nova conta de utilizador criada para %s',
	'DELETE_USER'        => '%s Eliminou a conta do utilizador %s',
	'DELETE_MULTI_USER'  => '%s Eliminou contas dos utilizadores %s',
	'PREVIEW'            => 'Pré-visualização: ',
	'REASON'             => 'Razão: ',
	'POST'               => 'mensagem',
	'AND'                => 'e',
	'CONJ'               => ',',
	'OTHER'              => 'outro',
	'OTHERS'             => 'outros',
	'UNKNOWN_USER'       => '{utilizador}',
	'UNKNOWN_FORUM'      => '{fórum}',
	'UNKNOWN_TOPIC'      => '{tópico}',
]);
