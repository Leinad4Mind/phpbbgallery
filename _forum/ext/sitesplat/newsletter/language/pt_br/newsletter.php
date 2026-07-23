<?php

/**
 * @package BBnewsletter for phpBB.
 * @copyright (c) 2016 SiteSplat All rights reserved
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
	'NEWSLETTER' => 'Newsletter',
	'OVERVIEW'   => 'Bem-vindo à nossa Newsletter! :-) Nesta página você encontrará as últimas Newsletters, bem como os arquivos dos anos anteriores.',

	'SUBSCRIBE_NO'          => 'NÃO quero mais receber a Newsletter',
	'SUBSCRIBE_YES'         => 'Sim, quero receber a Newsletter',
	'SUBSCRIBE_BTN_NO'      => 'Cancelar',
	'SUBSCRIBE_BTN_YES'     => 'Assinar',
	'SUBSCRIBE_CONFIRM_NO'  => 'Por favor, envie para cancelar a sua assinatura',
	'SUBSCRIBE_CONFIRM_YES' => 'Por favor, envie para confirmar a sua assinatura',

	'SUBSCRIBE_Y_EMAIL' => 'O seu email',
	'SUBSCRIBE'         => 'Assinar',
	'UNSUBSCRIBE'       => 'Cancelar assinatura de',
	'SUBSCRIBE_INFO'    => 'A nossa newsletter. Os membros que cancelarem a assinatura deixam de receber o nosso resumo periódico de novidades.',

	'OVERVIEW_ARCHIVE' => 'Arquivo',
	'ARCHIVES'         => 'Arquivos',
	'SUBSCRIBED'       => 'Obrigado por assinar! A partir de hoje você vai receber a nossa newsletter!',
	'UNSUBSCRIBED'     => 'Assinatura cancelada com sucesso, você deixará de receber a nossa newsletter'
]);
