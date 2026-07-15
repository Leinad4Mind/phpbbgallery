<?php
/**
 * [English [En]]
 * @package cBB Debugger
 * @version 1.0.1 20/09/2023
 *
 * @copyright (c) 2023 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 */

// DO NOT CHANGE
if(!defined('IN_PHPBB'))
{
	exit;
}

if(empty($lang) || !is_array($lang))
{
	$lang = [];
}

$lang = array_merge($lang, [
	'ACP_DEBUGGER'			=> 'Debugging',
	'ACP_DEBUGGER_EXPLAIN'	=> 'From here you can enable the debugging mode of the forum, as well as other statistics options.',

	'DEBUG_ALLOWED_IPS'			=> 'Allowed IPs',
	'DEBUG_ALLOWED_IPS_EXPLAIN'	=> 'Defines the ips from which debug mode can be seen.<br />
		Leave this field blank so that debug mode is visible to everyone.<br /><br />
		<em>You must separate the ips by a comma or set each one per line.</em>',
	'DEBUG_ENABLE'				=> 'Enable debug',
	'DEBUG_ENABLE_EXPLAIN'		=> 'Define whether debug mode is enabled to display errors in the forum code and their extensions.',
	'DEBUG_SHOW_STATS'			=> 'Show statistics',
	'DEBUG_SHOW_STATS_EXPLAIN'	=> 'Define whether statistics of execution time and resource usage will be displayed in the footer.',

	'LOG_DEBUGGER_CONFIG'		=> '<strong>cBB Debugger:</strong> Modified configuration',

	'CORE_INSTALL_ERROR'	=> 'You have not uploaded all the files from the installation package or you are trying to install an old package.<br />
		Please make sure to upload all the files (including the <em>core</em> folder) and use a package downloaded from the official website.',
]);
