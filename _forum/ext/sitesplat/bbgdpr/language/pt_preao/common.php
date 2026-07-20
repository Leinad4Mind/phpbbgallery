<?php

/**
 * @package BBgdpr for phpBB.
 * @copyright (c) 2018 SiteSplat All rights reserved
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
	'BBGDPR'                        => 'BBgdpr',
	'ACP_BBGDPR'                    => 'BBgdpr',
	'PRIVACY_TERMS_CHANGED'         => 'Os nossos Termos de Política de Privacidade foram atualizados. É necessário que tome conhecimento e os reveja, para que possa aceitá-los de modo a poder continuar a usufruir da sua conta e continuar a usar os nossos serviços.',
	'SITESPLAT_BBGDPR_ACCEPT'       => 'Eu Li, Compreendo e Aceito.',
	'SITESPLAT_BBGDPR_DISAGREE'     => 'Lamento, não aceito e desejo que a minha conta e dados sejam removidos permanentemente.',
	'SITESPLAT_BBGDPR_DISAGREE_TXT' => 'Não pode discordar dos termos e políticas e utilizar os nossos serviços ao mesmo tempo.',

	'ACP_BBGDPR_EMAIL_SUBJECT' => 'Novo pedido de eliminação do Regulamento Geral sobre a Proteção de Dados (GDPR)!',
	'ACP_BBGDPR_EMAIL_BODY'    => 'O utilizador » %s enviou-nos um pedido para procedermos à eliminação e remoção de todos os seus dados e respetiva conta devido a alterações nas novas regras e consentimentos em torno da Política de Privacidade no site.',
]);
