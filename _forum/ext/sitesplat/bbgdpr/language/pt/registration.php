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
	'BULK_EMAILS'				=> 'E-mails',
	'BULK_EMAILS_EXPLAIN'		=> 'Ao marcar esta caixa, concordas que os administradores deste fórum possam enviar-te emails. É obrigatório concordar de forma a concluir o registo. Os e-mails são necessários para a ativação da conta e para e-mails importantes que possamos ter de enviar a todos os utilizadores.',

	'PRIVACY_POLICY'			=> 'Privacidade',
    'PRIVACY_POLICY_EXPLAIN'    => 'Ao marcar esta caixa, concordas com a Política de Privacidade deste fórum que pode ser encontrada na página dos termos. Também terás acesso à mesma depois de entrares com a tua conta. É obrigatório concordar de forma a concluir o registo.',
	'REG_UNDRSTD'	        	=> 'Compreendo e Aceito',
	
	'AGREEMENTS_REQUIRED'		=> 'Tens de concordar com o envio de e-mails (não te preocupes, não enviaremos Spam) e com a nossa Política de Privacidade',
	
	'BULK_EMAILS_QUICK_AGREE'				=> 'E-mails do Fórum',
	'PRIVACY_POLICY_QUICK_AGREE'				=> 'RGPD da Comunidade',
	
));
