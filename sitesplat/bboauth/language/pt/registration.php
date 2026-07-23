<?php

/**
 * BBOAuth
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
	'AGREE_AND_REGISTER'  => 'Concordo com os termos e pretendo registar-me associando o meu %s',
	'OAUTH_ACCOUNT_ADDED' => 'Obrigado por te teres registado, a tua conta foi criada através dos meios e plataforma da rede social ou canal de comunicação online que escolheste e selecionaste com agrado entre as nossas opções e, sendo assim, não temos mais nada a acrescentar a não ser os parabéns e informar-te de que foi de pronto e com enorme sucesso efetuada a ligação, tendo sido também devidamente associada, validada e conetada em modo e modelo automático pelo sistema!',
]);
