<?php

/**
 * @package BBavatar+ for phpBB.
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
	'ACP_BBAVATARPLUS'    => 'BBavatar+',
	'UCP_UCP'             => 'Painel de Controlo do Utilizador',
	'SS_HELPER_NOTY'      => 'O SiteSplat BBcore não existe!<br />Transfere o <a href="http://sitesplat.com" target="_blank">BBcore</a> e copia a pasta BBcore para a pasta da tua extensão sitesplat.',
	'BBAVATARPLUS_NOTICE' => '<div class="phpinfo"><p>As configurações desta extensão encontram-se em <strong>%1$s » %2$s » %3$s</strong> seleciona o driver <strong>"Avatar Material"</strong> ou <strong>"Gerador de Avatares"</strong>.<br />Para melhores resultados é fortemente recomendado aumentar o tamanho máximo do avatar para 400x400 em <strong>ACP > Configurações de avatar > Dimensões máximas do avatar</strong>. </p></div>',
]);
