<?php

/**
 * @package Gyazo for phpBB.
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

	'SS_HELPER_NOTY' => 'O SiteSplat BBcore não existe!<br />Faça o download do <a href="https://sitesplat.com" target="_blank">BBcore</a> e copie a pasta BBcore para a pasta da sua extensão sitesplat.',
	'GYAZO_NOTICE'   => '<div style="width:auto;margin:20px auto;"><p>A configuração para esta extensão encontra-se em <strong>%1$s &#187; %2$s &#187; %3$s.</strong><br />Irá ser necessário registar uma aplicação do GYAZO para conseguir receber a Identificação do Cliente (Client ID) obrigatória para o funcionamento da extensão. <br />Para criar uma nova aplicação, visite <a href="https://gyazo.com/api" target="_blank">https://gyazo.com/api</a> e proceda ao registro seguindo as indicações fornecidas. <br />Seguidamente, adicione a Identificação do Cliente (Client ID) em <strong>ACP &#187; Mensagens &#187; Definições de Anexos: Gyazo Client ID</strong><br />A opção do avatar encontra-se em: Geral &#187; Configuração do fórum &#187; Definições de avatar.<br />A opção da assinatura encontra-se em: Geral &#187; Configuração do fórum &#187; Definições de assinatura.</p></div>',

]);
