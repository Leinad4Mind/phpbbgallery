<?php

/**
 * BBpostdated
 * @copyright (c) 2015 SiteSplat All rights reserved
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
	'LOG_FUTURE_POST_APROVED' => '<strong>Postagem futura aprovada</strong><br />&#187; %s',
	'FUTUREPOSTS_NOTICE'      => '<div style="width:80%;margin:20px auto;"><p>As configurações desta extensão (seletor de data) podem ser encontradas no editor de postagens.<br />Não se esqueça de verificar/ajustar as permissões, se necessário. ACP &#187; Permissões &#187; Funções de permissões &#187; Funções de moderador &#187; Moderador Completo (engrenagem verde, editar) &#187; Diversos (aba): Pode gerenciar postagens futuras</p></div>',
	'SS_HELPER_NOTY'          => 'O SiteSplat BBcore não existe!<br />Faça o download do <a href="http://sitesplat.com" target="_blank">BBcore</a> e copie a pasta BBcore para a pasta da sua extensão sitesplat.',

]);
