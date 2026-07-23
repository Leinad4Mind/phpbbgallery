<?php

/**
 * BBpostdated
 * @copyright (c) 2015 SiteSplat All rights reserved
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
	'LOG_FUTURE_POST_APROVED' => '<strong>Publicação futura aprovada</strong><br />&#187; %s',
	'FUTUREPOSTS_NOTICE'      => '<div style="width:80%;margin:20px auto;"><p>As definições desta extensão (selector de data) encontram-se no editor de mensagens.<br />Não te esqueças de verificar/ajustar as permissões se necessário. ACP &#187; Permissões &#187; Funções de permissões &#187; Funções de moderador &#187; Moderador Global (roda dentada verde, editar) &#187; Diversos (separador): Pode gerir publicações futuras</p></div>',
	'SS_HELPER_NOTY'          => 'O SiteSplat BBcore não existe!<br />Transfere o <a href="http://sitesplat.com" target="_blank">BBcore</a> e copia a pasta BBcore para a pasta da tua extensão sitesplat.',

]);
