<?php

/**
 * @package snappy reply for phpBB.
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
	'SNAPPY_NOTICE'  => '<div style="width:auto;margin:20px auto;"><p>Não existem definições específicas para esta extensão. Lembra-te de activar a opção de resposta rápida do phpBB em: <strong>%1$s &#187; %2$s &#187; %3$s "Permitir resposta rápida".</strong><br />Tem em atenção que, se tiveres a extensão <a href="http://www.sitesplat.com/phpBB3/marketplace.php?mode=view&item_id=23" target="_blank">IMGUR</a> instalada, também podes activar ou desactivar a opção IMGUR na resposta rápida, e se tiveres a extensão <a href="https://sitesplat.com/phpBB3/marketplace.php?mode=view&item_id=62" target="_blank">GYAZO</a> instalada, também podes activar ou desactivar a opção GYAZO na resposta rápida.<br />A opção encontra-se em: <strong>ACP &#187; Geral &#187; Configuração do fórum &#187; Definições de anexos "Permitir IMGUR/GYAZO no Smart Snappy Reply"</strong></p></div>',

]);
