<?php

/**
 * @package BBembed for phpBB.
 * @copyright (c) 2016 SiteSplat All rights reserved
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

	'SS_HELPER_NOTY' => 'O SiteSplat BBcore não existe!<br />Transfere o <a href="https://sitesplat.com" target="_blank">BBcore</a> e copia a pasta BBcore para a pasta da tua extensão sitesplat.',
	'IMGUR_NOTICE'   => '<div style="width:auto;margin:20px auto;"><p>A configuração para esta extensão encontra-se em <strong>%1$s &#187; %2$s &#187; %3$s.</strong><br />Irá ser necessário registar uma aplicação do Imgur para conseguir receber a Identificação do Cliente (Client ID) obrigatória para o funcionamento da extensão. <br />Para criar uma nova aplicação, visite <a href="https://api.imgur.com/oauth2/addclient" target="_blank">https://api.imgur.com/oauth2/addclient</a> e proceda ao registo seguindo as indicações fornecidas. <br />Seguidamente, adicione o código referente à Identificação do Cliente (Client ID) em <strong>ACP &#187; Mensagens &#187; Definições de Anexos: Imgur Client ID</strong><br />A opção do avatar encontra-se em: Geral &#187; Configuração do fórum &#187; Definições de avatar.<br />A opção da assinatura encontra-se em: Geral &#187; Configuração do fórum &#187; Definições de assinatura.</p></div>',

]);
