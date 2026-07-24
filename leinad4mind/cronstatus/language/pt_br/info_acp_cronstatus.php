<?php

/**
 * @package   Cron Status
 * @author    John Peskens, Igor Lavrov, Leinad4Mind
 * @copyright (c) 2014 - 2021 John Peskens, Igor Lavrov | (c) 2022-2026 Leinad4Mind
 * @license   http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
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

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
//
// Some characters you may want to copy&paste:
// ’ « » “ ” …
//

$lang = array_merge($lang, [
	'ACP_CRON_STATUS_TITLE'        => 'Estado do Cron',
	'ACP_CRON_STATUS_CONFIG_TITLE' => 'Verificar o Estado do Cron',
	'CRONSTAT_NOTICE'              => '<div class="phpinfo"><p>Esta extensão está localizada em %1$s » %2$s » %3$s.</p></div>',
	'CRONSTAT_UNLOCKED'            => 'Bloqueio do cron reiniciado.',
]);

// Description of Cron Status extension
$lang = array_merge($lang, [
	'DESCRIPTION_PAGE'   => 'Descrição',
	'DESCRIPTION_NOTICE' => 'Nota da extensão',
	'ext_details'        => [
		'details' => [
			'DESCRIPTION_1' => 'Visão geral das Tarefas Cron (com ordenação)',
			'DESCRIPTION_2' => 'Mostra o status de cada Tarefa Cron',
			'DESCRIPTION_3' => 'Execute qualquer tarefa pronta agora, ou execute todas de uma vez',
			'DESCRIPTION_4' => 'Reinicie o bloqueio do cron com um simples clique',
		],
		'note' => [
			'NOTICE_1' => 'Aviso de Estado do Cron na página principal do ACP',
			'NOTICE_2' => 'Configurável nas configurações do fórum',
			'NOTICE_3' => 'Opção "Executar cron sempre" alternável para tráfego de bots',
			'NOTICE_4' => 'Pronto para o phpBB 3.3',
		],
	],
]);
