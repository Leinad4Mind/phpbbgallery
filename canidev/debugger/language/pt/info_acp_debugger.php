<?php

/**
 * @package cBB Debugger for phpBB.
 * [English [En]]
 * @version 1.0.2 11/03/2024
 * @copyright (c) 2024 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 * @translation Leinad4Mind [Portuguese [pt]] (2026)
 */

// DO NOT CHANGE
if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = [];
}

$lang = array_merge($lang, [
	'ACP_DEBUGGER'         => 'Depuração',
	'ACP_DEBUGGER_EXPLAIN' => 'A partir daqui podes ativar o modo de depuração do fórum, bem como outras opções de estatísticas.',

	'DEBUG_ALLOWED_IPS'         => 'IPs Permitidos',
	'DEBUG_ALLOWED_IPS_EXPLAIN' => 'Define os ips a partir dos quais o modo de depuração pode ser visto.<br />
		Deixa este campo em branco para que o modo de depuração seja visível para todos.<br /><br />
		<em>Deves separar os ips por uma vírgula ou colocar um por linha.</em>',
	'DEBUG_ENABLE'             => 'Ativar depuração',
	'DEBUG_ENABLE_EXPLAIN'     => 'Define se o modo de depuração está ativado para exibir erros no código do fórum e nas suas extensões.',
	'DEBUG_SHOW_STATS'         => 'Mostrar estatísticas',
	'DEBUG_SHOW_STATS_EXPLAIN' => 'Define se as estatísticas do tempo de execução e do uso de recursos serão exibidas no rodapé.',

	'LOG_DEBUGGER_CONFIG' => '<strong>cBB Debugger:</strong> Configuração modificada',

	'CORE_INSTALL_ERROR' => 'Não carregaste todos os ficheiros do pacote de instalação ou estás a tentar instalar um pacote antigo.<br />
		Por favor, certifica-te de que carregas todos os ficheiros (incluindo a pasta <em>core</em>) e usas um pacote descarregado do site oficial.',
]);
