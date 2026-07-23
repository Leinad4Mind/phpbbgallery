<?php

/**
 * Extension Manager Plus. An extension for the phpBB Forum Software package.
 * @copyright (c) 2022, LukeWCS, https://www.wcsaga.org
 * @license GNU General Public License, version 2 (GPL-2.0-only)
 * Note: This extension is 100% genuine handcraft and consists of selected
 * natural raw materials. There was no AI involved in making it.
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
// ’ « » “ ” … „ “

$lang = array_merge($lang, [
	// info table
	'EXTMGRPLUS_COL_AVAILABLE_EXTENSIONS' => 'Extensões disponíveis',
	'EXTMGRPLUS_COL_WITH_VERSIONCHECK'    => 'Com verificação de versão',
	'EXTMGRPLUS_COL_LAST_VERSIONCHECK'    => 'Última verificação de versão',
	'EXTMGRPLUS_COL_AVAILABLE_UPDATES'    => 'Atualizações disponíveis',
	'EXTMGRPLUS_AVAILABLE_EXTENSIONS'     => [
		0 => '%2$u',
		1 => '%2$u (%1$u inválida)',
	],
	'EXTMGRPLUS_VERSIONCHECK_DATE' => [
		0 => '%2$s (%3$u seg.)',
		1 => '%2$s (%3$u seg. / %1$u erro)',
		2 => '%2$s (%3$u seg. / %1$u erros)',
	],

	// link bar
	'EXTMGRPLUS_LINK_EXT_PROPERTIES'  => 'Propriedades da extensão',
	'EXTMGRPLUS_LINK_SAVE_CHECKBOXES' => 'Salvar',

	// settings order and ignore
	'EXTMGRPLUS_SECTION_SETTINGS'   => 'Configurações (Plus)',
	'EXTMGRPLUS_ORDER'              => '%s Ordem e Dependência',
	'EXTMGRPLUS_ORDER_EXPLAIN'      => 'Nesta coluna, você pode definir grupos de ordem no intervalo de 0 a 99 para as ações "Habilitar selecionados" e "Desabilitar selecionados". Isso permite que extensões que dependem de outras extensões sejam habilitadas antes delas, evitando mensagens de erro. As extensões que pertencem a esse grupo são habilitadas primeiro, começando pelo grupo 0, depois o grupo 1, e assim por diante. As extensões sem grupo são habilitadas por último. Ao desabilitar, a ordem é invertida.',
	'EXTMGRPLUS_DEPENDENCY'         => 'Dependência',
	'EXTMGRPLUS_DEPENDENCY_EXPLAIN' => 'Uma extensão pode ser associada a um grupo colocando <code>+</code> antes dela. Por exemplo, se você tiver a extensão B que depende da extensão A, pode inserir <code>0</code> para A e <code>+0</code> para B. Se ambas as extensões estiverem habilitadas, selecionar A também selecionará B. Se ambas as extensões estiverem desabilitadas, selecionar B também selecionará A.',
	'EXTMGRPLUS_IGNORE'             => '%s Ignorar',
	'EXTMGRPLUS_IGNORE_EXPLAIN'     => 'Esta coluna permite que você especifique quais extensões devem ser ignoradas durante as ações "Habilitar selecionados" e "Desabilitar selecionados". Extensões ignoradas não podem mais ser selecionadas na lista de extensões e novas migrações não serão detectadas nem exibidas para essas extensões. Se um grupo de ordem tiver sido definido para uma extensão ignorada, ele é mantido, mas deixa de ter qualquer significado.',

	// ext manager
	'EXTMGRPLUS_COL_CDB'                  => 'Extensão validada',
	'EXTMGRPLUS_COL_MIGRATIONS'           => 'Novas migrações',
	'EXTMGRPLUS_COL_SELECT'               => 'Selecionar',
	'EXTMGRPLUS_COL_ORDER'                => 'Ordem',
	'EXTMGRPLUS_COL_IGNORE'               => 'Ignorar',
	'EXTMGRPLUS_DISABLE_ALL'              => 'Desabilitar selecionados',
	'EXTMGRPLUS_ENABLE_ALL'               => 'Habilitar selecionados',
	'EXTMGRPLUS_EXTENSIONS_ENABLED'       => 'Extensões Habilitadas: %u',
	'EXTMGRPLUS_EXTENSIONS_DISABLED'      => 'Extensões Desabilitadas: %u',
	'EXTMGRPLUS_EXTENSIONS_NOT_INSTALLED' => 'Extensões Não Instaladas: %u',

	// tooltips
	'EXTMGRPLUS_TOOLTIP_HAS_MIGRATION' => 'Esta extensão tem novas migrações que são aplicadas ao habilitar a extensão.',
	'EXTMGRPLUS_TOOLTIP_DISABLE_ALL'   => 'Desabilitar todas as extensões selecionadas.',
	'EXTMGRPLUS_TOOLTIP_ENABLE_ALL'    => 'Habilitar todas as extensões selecionadas.',
	'EXTMGRPLUS_TOOLTIP_ORDER'         => 'Grupo de ordem no intervalo 0-99. Um grupo pode ser associado com um + antes.',
	'EXTMGRPLUS_TOOLTIP_IGNORE'        => 'Ignorar extensão.',
	'EXTMGRPLUS_TOOLTIP_SELECT_ALL'    => 'Selecionar ou desmarcar todas as extensões.',
	'EXTMGRPLUS_TOOLTIP_SELECT'        => 'Selecionar extensão.',
	'EXTMGRPLUS_TOOLTIP_IS_LOCKED'     => 'A seleção desta extensão está bloqueada devido a novas migrações.',
	// tooltips icons
	'EXTMGRPLUS_TOOLTIP_CDB_EXT'            => 'Esta extensão foi oficialmente validada.',
	'EXTMGRPLUS_TOOLTIP_OUTDATED'           => 'A versão instalada desta extensão está desatualizada.',
	'EXTMGRPLUS_TOOLTIP_VERSIONCHECK_ERROR' => 'Ocorreu um erro durante a verificação de versão. Clique em "Detalhes" para saber mais.',
	'EXTMGRPLUS_TOOLTIP_VERSIONCHECK_EMPTY' => 'Nenhuma verificação de versão foi realizada para esta extensão.',
	'EXTMGRPLUS_TOOLTIP_NO_VERSIONCHECK'    => 'Esta extensão não oferece verificação de versão.',
	'EXTMGRPLUS_TOOLTIP_IS_IGNORED'         => 'Esta extensão é ignorada pela "Extension Manager Plus".',

	// misc
	'EXTMGRPLUS_EXTENSION_PLURAL' => [
		0 => '0 extensões',
		1 => '1 extensão',
		2 => '%u extensões',
	],
	'EXTMGRPLUS_SECOND_PLURAL' => [
		0 => '0 segundos',
		1 => '1 segundo',
		2 => '%u segundos',
	],
	'EXTMGRPLUS_SPOILER_LABEL' => 'Explicação',

	// details
	'EXTMGRPLUS_SECTION_DETAILS'     => 'Informações do Extension Manager Plus',
	'EXTMGRPLUS_DETAILS_CDB_PAGE'    => 'Página do banco de dados de extensões do phpBB',
	'EXTMGRPLUS_DETAILS_VERSION_URL' => 'Link para o arquivo de versão',

	// messages
	'EXTMGRPLUS_MSG_CONFIRM_DISABLE'      => 'Tem certeza de que deseja desabilitar %s?',
	'EXTMGRPLUS_MSG_CONFIRM_ENABLE'       => 'Tem certeza de que deseja habilitar %s?',
	'EXTMGRPLUS_MSG_EXT_PROPERTIES_SAVED' => 'Propriedades da extensão salvas com sucesso.',
	'EXTMGRPLUS_MSG_CHECKBOXES_SAVED'     => 'Seleção das caixas de seleção salva com sucesso.',
	'EXTMGRPLUS_MSG_PROCESS_ABORTED'      => 'A operação "%s" foi interrompida pela seguinte extensão:',
	'EXTMGRPLUS_MSG_DEACTIVATION'         => '%1$u de %2$u extensões foram desabilitadas.',
	'EXTMGRPLUS_MSG_ACTIVATION'           => '%1$u de %2$u extensões foram habilitadas.',
	'EXTMGRPLUS_MSG_DEACTIVATION_FAILED'  => 'As seguintes extensões não puderam ser desabilitadas:',
	'EXTMGRPLUS_MSG_ACTIVATION_FAILED'    => 'As seguintes extensões não puderam ser habilitadas:',
	'EXTMGRPLUS_MSG_SAFE_TIME_EXCEEDED'   => 'O intervalo de tolerância (%u segundos) do tempo máximo de execução do PHP foi excedido.',
	'EXTMGRPLUS_MSG_SELF_DISABLE'         => 'Nota: A extensão "Extension Manager Plus" também será desabilitada.',
	// messages versioncheck
	'EXTMGRPLUS_MSG_VERSIONCHECK_HINT'     => 'As extensões estão sendo verificadas em busca de novas versões.',
	'EXTMGRPLUS_MSG_VERSIONCHECK_BLOCK'    => 'Bloco atual (máximo %s)',
	'EXTMGRPLUS_MSG_VERSIONCHECK_PROGRESS' => 'Extensões verificadas: %1$u / %2$u',
]);
