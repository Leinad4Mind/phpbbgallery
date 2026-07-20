<?php

/**
 * BBadblock extension for the phpBB Forum Software package.
 * @copyright (c) 2015 SiteSplat All rights reserved
 * @license Proprietary
 * @translation Leinad4Mind [Brazilian Portuguese [pt_br]] (2026)
 */

/**
* DO NOT CHANGE
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
	'BBADBLOCK_MSG'      => 'Está a utilizar um bloqueador de anúncios, nós respeitamos isso mas não é fixe, pois precisamos que os anúncios estejam ativos :-/',
	'BBADBLOCK_MSG_POST' => 'Esta publicação está escondida porque está a usar um adblock. Nós compreendemos, mas precisamos dos anúncios ativos. Por favor, adicione o nosso site à lista de permissões.',
	'BBADBLOCK_TOGO'     => 'páginas restantes'
]);
