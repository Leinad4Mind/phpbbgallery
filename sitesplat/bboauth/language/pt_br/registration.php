<?php

/**
 * BBOAuth
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
	'AGREE_AND_REGISTER'  => 'Concordo com os termos e pretendo me registrar associando o meu %s',
	'OAUTH_ACCOUNT_ADDED' => 'Obrigado por se registrar, a sua conta foi criada através dos meios e plataforma da rede social ou canal de comunicação online que você escolheu e selecionou com agrado entre as nossas opções e, sendo assim, não temos mais nada a acrescentar a não ser os parabéns e informá-lo(a) de que foi imediatamente e com grande sucesso efetuada a conexão, tendo sido também devidamente associada, validada e conectada em modo e modelo automático pelo sistema!',
]);
