<?php

/**
 * @package BBrandom for phpBB.
 * @copyright (c) 2016 SiteSplat All rights reserved
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
	'ACP_BBRANDOM'                    => 'BBrandom',
	'SS_HELPER_NOTY'                  => 'O SiteSplat BBcore não existe!<br />Faça o download do <a href="http://sitesplat.com" target="_blank">BBcore</a> e copie a pasta BBcore para a pasta da sua extensão sitesplat.',
	'BBRANDOM_NOTICE'                 => '<div class="phpinfo"><p>A configuração para esta extensão encontra-se em <strong>%1$s &#187; %2$s &#187; %3$s</strong>.</p></div>',
	'ACP_BBRANDOM_SETTING_SAVED'      => 'As configurações do BBrandom foram guardadas',
	'BBRANDOM_EXCLUDE_FORUMS'         => 'Fóruns excluídos',
	'BBRANDOM_EXCLUDE_FORUMS_EXPLAIN' => 'Selecione os fóruns que deseja excluir dos tópicos aleatórios.',
]);
