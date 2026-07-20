<?php

/**
 * @package Ext Common Core for phpBB.
 * [English [En]]]
 * @version 1.1.6 17/06/2024
 * @copyright (c) 2024 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 * @translation Leinad4Mind [Portuguese [pt_preao]] (2026)
 */

// @ignore
if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = [];
}

$lang = array_merge($lang, [
	'ACCEPT'                    => 'Aceitar',
	'ALL_GROUPS'                => 'Todos os grupos',
	'APPLY'                     => 'Aplicar',
	'BATCH_ACTIONS'             => 'Acções em massa',
	'CLIPBOARD_LINK_ERROR'      => 'A ligação não pôde ser copiada',
	'CLIPBOARD_LINK_SUCCESS'    => 'Ligação copiada para a área de transferência',
	'CLIPBOARD_TEXT_ERROR'      => 'O texto não pôde ser copiado',
	'CLIPBOARD_TEXT_SUCCESS'    => 'Texto copiado para a área de transferência',
	'CONFIGURE'                 => 'Configurar',
	'COPY_TO_CLIPBOARD'         => 'Copiar para a área de transferência',
	'DOCUMENTATION_AND_SUPPORT' => 'Documentação e Suporte',
	'EDIT'                      => 'Editar',
	'ENABLE_DISABLE'            => 'Ativar/Desactivar',
	'NO_ITEMS'                  => 'Nenhum item para mostrar',
	'ONLY_DEFAULT_GROUPS'       => 'Considerar apenas grupo predefinido',
	'REPORT_EXPLAIN'            => 'Lista abaixo o máximo de informação possível sobre o erro.<br /><br />
		Além do descrito aqui, informações básicas sobre o ambiente de execução serão enviadas para a correta análise do problema.<br />
		<a href="https://www.canidev.com/api/report/documentation" onclick="window.open(this.href); return false;">Ver detalhes</a>',
	'REPORT_SENDED' => 'Relatório enviado com sucesso',
	'REPORT_TITLE'  => 'Reportar erro',
	'SAVE'          => 'Guardar',
	'SEND'          => 'Enviar',

	'NO_LIMIT'  => 'Sem limite',
	'ONE_DAY'   => 'Um dia',
	'ONE_HOUR'  => 'Uma hora',
	'ONE_WEEK'  => 'Uma semana',
	'ONE_MONTH' => 'Um mês',
	'ONE_YEAR'  => 'Um ano',
	'TWO_YEARS' => 'Dois anos',

	// Errors
	'ERROR_REPORT_SEND' => 'O teu relatório não pôde ser enviado',
]);
