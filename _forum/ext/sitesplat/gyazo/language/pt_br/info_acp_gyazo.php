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
	'GYAZO_NOTICE'   => '<div style="width:auto;margin:20px auto;"><p>A configuração desta extensão está em <strong>%1$s &#187; %2$s &#187; %3$s.</strong><br />Você vai precisar registrar um aplicativo do GYAZO para obter a Identificação do Cliente (Client ID) necessária para o funcionamento da extensão. <br />Para criar um novo aplicativo, acesse <a href="https://gyazo.com/api" target="_blank">https://gyazo.com/api</a> e faça o registro seguindo as instruções fornecidas. <br />Depois, use a Identificação do Cliente (Client ID) em <strong>ACP &#187; Mensagens &#187; Configurações de anexos: Gyazo Client ID</strong><br />A opção de avatar está em: Geral &#187; Configuração do fórum &#187; Configurações de avatar.<br />A opção de assinatura está em: Geral &#187; Configuração do fórum &#187; Configurações de assinatura.</p></div>',

]);
