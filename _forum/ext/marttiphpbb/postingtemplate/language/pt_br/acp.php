<?php

/**
 * @copyright (c) 2024
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
	'ACP_POSTINGTEMPLATE'         => 'Modelo de mensagem',
	'ACP_POSTINGTEMPLATE_EXPLAIN' => 'Ao iniciar um tópico, o editor de texto será pré-preenchido com o modelo de mensagem. Deixe em branco quando não quiser utilizar isto.',
]);
