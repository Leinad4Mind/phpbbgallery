<?php

/**
 * @package BBgdpr for phpBB.
 * @copyright (c) 2018 SiteSplat All rights reserved
 * @license Proprietary
 * @translation Leinad4Mind [Brazilian Portuguese [pt_br]] (2026)
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
	// used both in ACP and/or UCP and/or all pages
	'BBGDPR_TITLE'          => 'GDPR',
	'BBGDPR_PRIVACY_POLICY' => 'GDPR - Regulamento Geral de Proteção de Dados',
	'BBGDPR_ACCEPTED'       => 'Aceito em',
	'PRIVACY_ACCEPT_DATE'   => 'Data de aceitação da política de privacidade',
	'COOKIE_ACCEPT_DATE'    => 'Data de aceitação da política de cookies',
	'NOT_ACCEPTED'          => 'A política ainda não foi aceita',
	'MCP_ACCEPT_DATE'       => 'Data de revisão das diretrizes do GDPR para o MCP',
	'LOG_USER_DELETED'      => 'O usuário %s (ID %s) excluiu a própria conta. ',
	'LOG_POST_RETAINED'     => 'As postagens dele(a) foram mantidas.',
	'LOG_POST_REMOVED'      => 'As postagens dele(a) foram removidas.',
	'LOG_NO_POSTS'          => 'Ele(a) não tinha postagens.',

	'LOG_USER_DELETED_RETAINED' => '<strong>Usuário excluído via GDPR</strong><br />» O usuário %s (ID %s) excluiu a própria conta. As postagens dele(a) foram mantidas.',
	'LOG_USER_DELETED_REMOVED'  => '<strong>Usuário excluído via GDPR</strong><br />» O usuário %s (ID %s) excluiu a própria conta. As postagens dele(a) foram removidas.',
	'LOG_USER_DELETED_NO'       => '<strong>Usuário excluído via GDPR</strong><br />» O usuário %s (ID %s) excluiu a própria conta. Ele(a) não tinha postagens.',

	// notification
	'SITESPLAT_BBGDPR_USER_DELETED' => 'O usuário %s excluiu sua conta.',
	'NOTIFICATION_TYPE_BBGDPR'      => 'Um Usuário exclui sua conta sob o GDPR',

	// cookies
	'COOKIE_CONSENT'        => 'Ao continuar sua visita a este site, você aceita o uso de cookies.',
	'REJECT_BBGDPR_COOKIE'  => 'Rejeitar',
	'ACCEPT_BBGDPR_COOKIE'  => 'Eu Aceito o Uso de Cookies',
	'ACCEPT_GDPR'           => 'Eu Aceito a Política do GDPR',
	'REJECT_GDPR'           => 'Rejeitar (você será desconectado)',
	// mcp
	'GDPR_REVIEW'           => 'Revisão das diretrizes do GDPR',
	'GDPR_NOT_REVIEWED'     => 'Para acessar o MCP, você precisa confirmar que revisou as diretrizes do GDPR. Revise as diretrizes do GDPR: <a href="https://gdpr-info.eu/">https://gdpr-info.eu/</a>',
	'GDPR_REVIEW_CONFIRM'   => 'Confirmo que revisei as diretrizes do GDPR',
	'MCP_ACCEPT_FIRST'      => 'Para acessar o MCP, você precisa confirmar que revisou as diretrizes do GDPR. Por favor, <a href="%s">confirme isso antes de realizar qualquer ação de moderador</a>.',

	// privacy
	'BBGDPR_LAST_UPDATED'  => 'Última atualização: %s',
	'BBGDPR_GDPR_ACCEPTED' => 'Aceito anteriormente em ',
	'REVIEW_PERSONAL_DATA' => 'Revisar seus dados pessoais',
	'REACCEPT_COOKIE'      => 'Parece que você rejeitou anteriormente a política de cookies. Mudou de ideia?',
]);
