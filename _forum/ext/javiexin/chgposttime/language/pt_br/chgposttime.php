<?php

/**
 * @copyright (c) 2014-2020 Leinad4Mind, Feneck91, etc.
 * @license GNU General Public License, version 2 (GPL-2.0)
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
	'LOG_MCP_JX_CHANGE_POSTTIME' => '<strong>Alterou o tempo da mensagem #%4$s no tópico "%1$s"</strong><br />» de %2$s para %3$s',
]);
