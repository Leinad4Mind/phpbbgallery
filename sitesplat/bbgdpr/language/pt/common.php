<?php

/**
 * @package BBgdpr for phpBB.
 * @copyright (c) 2018 SiteSplat All rights reserved
 * @license Proprietary
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
	// used both in ACP and/or UCP and/or all pages
	'BBGDPR_TITLE'          => 'GDPR',
	'BBGDPR_PRIVACY_POLICY' => 'GDPR - Regulamento Geral sobre a Proteção de Dados',
	'BBGDPR_ACCEPTED'       => 'Aceite em',
	'PRIVACY_ACCEPT_DATE'   => 'Data de aceitação da política de privacidade',
	'COOKIE_ACCEPT_DATE'    => 'Data de aceitação da política de cookies',
	'NOT_ACCEPTED'          => 'A política ainda não foi aceite',
	'MCP_ACCEPT_DATE'       => 'Data de revisão das diretrizes do GDPR para o MCP',
	'LOG_USER_DELETED'      => 'O utilizador %s (ID %s) eliminou a sua própria conta. ',
	'LOG_POST_RETAINED'     => 'As suas publicações foram mantidas.',
	'LOG_POST_REMOVED'      => 'As suas publicações foram removidas.',
	'LOG_NO_POSTS'          => 'Não tinha publicações.',

	'LOG_USER_DELETED_RETAINED' => '<strong>Utilizador eliminado via GDPR</strong><br />» O utilizador %s (ID %s) eliminou a sua própria conta. As suas publicações foram mantidas.',
	'LOG_USER_DELETED_REMOVED'  => '<strong>Utilizador eliminado via GDPR</strong><br />» O utilizador %s (ID %s) eliminou a sua própria conta. As suas publicações foram removidas.',
	'LOG_USER_DELETED_NO'       => '<strong>Utilizador eliminado via GDPR</strong><br />» O utilizador %s (ID %s) eliminou a sua própria conta. Não tinha publicações.',

	// notification
	'SITESPLAT_BBGDPR_USER_DELETED' => 'O utilizador %s eliminou a sua conta.',
	'NOTIFICATION_TYPE_BBGDPR'      => 'Um Utilizador elimina a sua conta ao abrigo do GDPR',

	// cookies
	'COOKIE_CONSENT'        => 'Ao continuares a tua visita a este site, aceitas o uso de cookies.',
	'REJECT_BBGDPR_COOKIE'  => 'Rejeitar',
	'ACCEPT_BBGDPR_COOKIE'  => 'Aceito o Uso de Cookies',
	'ACCEPT_GDPR'           => 'Aceito a Política do GDPR',
	'REJECT_GDPR'           => 'Rejeitar (a tua sessão será terminada)',
	// mcp
	'GDPR_REVIEW'           => 'Revisão das diretrizes do GDPR',
	'GDPR_NOT_REVIEWED'     => 'Para aceder ao MCP, precisas de confirmar que revisaste as diretrizes do GDPR. Revê as diretrizes do GDPR: <a href="https://gdpr-info.eu/">https://gdpr-info.eu/</a>',
	'GDPR_REVIEW_CONFIRM'   => 'Confirmo que revi as diretrizes do GDPR',
	'MCP_ACCEPT_FIRST'      => 'Para aceder ao MCP, precisas de confirmar que revisaste as diretrizes do GDPR. Por favor, <a href="%s">confirma isso antes de realizares qualquer ação de moderador</a>.',

	// privacy
	'BBGDPR_LAST_UPDATED'  => 'Última atualização: %s',
	'BBGDPR_GDPR_ACCEPTED' => 'Aceite anteriormente em ',
	'REVIEW_PERSONAL_DATA' => 'Rever os teus dados pessoais',
	'REACCEPT_COOKIE'      => 'Parece que rejeitaste anteriormente a política de cookies. Mudaste de ideias?',
]);
