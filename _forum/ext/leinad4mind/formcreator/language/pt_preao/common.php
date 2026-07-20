<?php

/**
 * @package phpBB Extension - Form Creator for phpBB.
 * @copyright (c) 2017 dmzx - http://www.dmzx-web.net & michaelo - http://www.phpbbireland.com
 * @copyright (c) 2019 Leinad4Mind - https://leinad4mind.top/forum
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 * @translation Leinad4Mind [Portuguese [pt_preao]] (2026)
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
// ’ » “ ” …
//

$lang = array_merge($lang, [
	'CLOSE_FORM'        => 'Cancelar',
	'OPEN_FORM'         => 'Modo Gerador Automático',
	'OPEN_POST'         => 'Modo BBCode Manual',
	'FORM_MOD_PREVIEW'  => 'Alternar para pré-visualizar e manter os dados do formulário actual...',
	'FORM_MOD_SUBMIT'   => 'Converte e adiciona os dados do formulário à mensagem...',
	'OPEN_FORM_EXPLAIN' => 'Alterar para Gerador Automático...',
	'OPEN_POST_EXPLAIN' => 'Alterar para BBCode Manual...',
	'REFRESHING_FORM'   => 'O fórum selecionado actualmente é',
	'REQUIRED'          => 'Não preencheste todos os campos obrigatórios!',
	'MANDATORY'         => 'Campos marcados com asterisco são de preenchimento obrigatório.',

	'ERROR_MANDATORY'        => 'O campo %s é obrigatório.',
	'ERROR_MIN_MAX_CHECKBOX' => 'Precisas de escolher pelo menos %d item e menos de %d itens para o campo %s.',
	'ERROR_MIN_CHECKBOX'     => [
		1 => 'Precisas de escolher pelo menos %d item para o campo %s.',
		2 => 'Precisas de escolher pelo menos %d itens para o campo %s.',
	],
	'ERROR_MAX_CHECKBOX' => [
		1 => 'Podes escolher no máximo %d item para o campo %s.',
		2 => 'Podes escolher no máximo %d itens para o campo %s.',
	],
]);
