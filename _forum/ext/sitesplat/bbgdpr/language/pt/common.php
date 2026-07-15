<?php
/**
*
* @package BBgdpr
* @copyright (c) 2018 SiteSplat All rights reserved
* @license Proprietary
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
	// used both in ACP and/or UCP and/or all pages
	'BBGDPR_TITLE'	        => 'RGPD',
	'BBGDPR_PRIVACY_POLICY'	=> 'RGPD - Regulamento Geral de Proteção de Dados',
	'PRIVACY_ACCEPT_DATE'	=> 'Data da aceitação da Política de Privacidade',
	'COOKIE_ACCEPT_DATE'	=> 'Data da aceitação da Política de Cookies',
	'NOT_ACCEPTED'			=> 'A nossa Política não foi aceite',
	'MCP_ACCEPT_DATE'		=> 'Data da revisão das diretrizes do RGPD para o PCM',
	'LOG_USER_DELETED'		=> 'Utilizador %s (ID %s) removeu a sua própria conta.',
	'LOG_POST_RETAINED'		=> 'As suas mensagens foram mantidas.',
	'LOG_POST_REMOVED'		=> 'As suas mensagens foram removidas.',
	'LOG_NO_POSTS'			=> 'Não tinham mensagens enviadas.',

	'LOG_USER_DELETED_RETAINED'	=> '<strong>Utilizador removido via RGPD</strong><br />» Utilizador %s (ID %s) removeu a sua própria conta. As suas mensagens foram mantidas.',
	'LOG_USER_DELETED_REMOVED'	=> '<strong>Utilizador removido via RGPD</strong><br />» Utilizador %s (ID %s) removeu a sua própria conta. As suas mensagens foram removidas.',
	'LOG_USER_DELETED_NO'		=> '<strong>Utilizador removido via RGPD</strong><br />» Utilizador %s (ID %s) removeu a sua própria conta. Não tinham mensagens enviadas.',
	
	// notification
	'SITESPLAT_BBGDPR_USER_DELETED'	=> 'Utilizador %s removeu a sua conta.',
	'NOTIFICATION_TYPE_BBGDPR'	    => 'Um utilizador removeu a sua conta de acordo com o RGPD',

	// cookies
	'COOKIE_CONSENT'		=> 'Ao continuar a usar este site, estás a aceitar o uso de cookies.',
	'REJECT'				=> 'Rejeitar',
	'ACCEPT'				=> 'Aceito o uso de Cookies',
	'ACCEPT_GDPR'	   		=> 'Aceitar a Política RGPD',
	'REJECT_GDPR'			=> 'Rejeitar (Serás desconectado da tua conta)',
	// mcp
	'GDPR_REVIEW'			=> 'Revisão das diretrizes do RGPD',
	'GDPR_NOT_REVIEWED'		=> 'Para aceder ao PCM, precisas de confirmar que reveste as diretrizes do RGPD. Revê as diretrizes: <a href="https://gdpr-info.eu/">https://gdpr-info.eu/</a>',
	'GDPR_REVIEW_CONFIRM'	=> 'Confirmo que revi as diretrizes do RGPD',
	'MCP_ACCEPT_FIRST'		=> 'Para aceder ao PCM, precisas de confirmar que reveste as diretrizes do RGPD. Por favor, <a href="%s">confirma antes de executar qualquer acção moderativa</a>.',

	// privacy
	'LAST_UPDATED'			=> 'Actualizado pela última vez em: %s',
	'REVIEW_PERSONAL_DATA'	=> 'Rever dados pessoais',
	'REACCEPT_COOKIE'		=> 'Parece que rejeitaste anteriormente a política dos cookies. Mudaste de ideias?',
));
