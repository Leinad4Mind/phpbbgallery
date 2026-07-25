<?php

/**
 *
 * Auto Groups extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2014 phpBB Limited <https://www.phpbb.com>
 * @license GNU General Public License, version 2 (GPL-2.0)
 * @translation Leinad4Mind [Portuguese [pt_preao]] (2026)
 *
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
	'ACP_AUTOGROUPS_MANAGE'         => 'Gerir Autogrupos',
	'ACP_AUTOGROUPS_MANAGE_EXPLAIN' => 'Neste formulário pode adicionar, editar, ver e eliminar configurações de Autogrupos.',
	'ACP_AUTOGROUPS_ADD'            => 'Adicionar Autogrupo',
	'ACP_AUTOGROUPS_EDIT'           => 'Editar Autogrupo',

	'ACP_AUTOGROUPS_GROUP_NAME'             => 'Grupo',
	'ACP_AUTOGROUPS_GROUP_NAME_EXPLAIN'     => 'Escolha um grupo ao qual adicionar/remover utilizadores automaticamente.',
	'ACP_AUTOGROUPS_CONDITION_NAME'         => 'Tipo de Autogrupo',
	'ACP_AUTOGROUPS_CONDITION_NAME_EXPLAIN' => 'Escolha o tipo de condição pela qual os utilizadores serão adicionados ou removidos deste grupo.',
	'ACP_AUTOGROUPS_MIN_VALUE'              => 'Valor mínimo',
	'ACP_AUTOGROUPS_MIN_VALUE_EXPLAIN'      => 'Os utilizadores serão adicionados a este grupo se atingirem ou excederem o valor mínimo.',
	'ACP_AUTOGROUPS_MAX_VALUE'              => 'Valor máximo',
	'ACP_AUTOGROUPS_MAX_VALUE_EXPLAIN'      => 'Os utilizadores serão removidos deste grupo se atingirem ou excederem o valor máximo. Defina como 0 se não quiser que os utilizadores sejam removidos.',
	'ACP_AUTOGROUPS_DEFAULT'                => 'Definir grupo predefinido',
	'ACP_AUTOGROUPS_DEFAULT_EXPLAIN'        => 'Torna este grupo o novo grupo predefinido do utilizador.',
	'ACP_AUTOGROUPS_DEFAULT_EXEMPTION'      => 'Isto não afectará os utilizadores cujo grupo predefinido seja um dos seguintes: %s.',
	'ACP_AUTOGROUPS_NOTIFY'                 => 'Notificar utilizadores',
	'ACP_AUTOGROUPS_NOTIFY_EXPLAIN'         => 'Envia uma notificação aos utilizadores depois de serem adicionados ou removidos automaticamente deste grupo.',

	'ACP_AUTOGROUPS_EXCLUDED_GROUPS'        => 'Grupos excluídos',
	'ACP_AUTOGROUPS_EXCLUDE_GROUP'          => 'Excluir membros destes grupos',
	'ACP_AUTOGROUPS_EXCLUDE_GROUP_EXPLAIN'  => 'Os membros pertencentes a <em>qualquer grupo</em> seleccionado nesta lista serão ignorados. Deixe este campo em branco se quiser que este Autogrupo seja aplicado a <em>todos os membros</em> do fórum. Seleccione vários grupos mantendo premida a tecla <samp>CTRL</samp> (ou <samp>&#8984;CMD</samp> no Mac) e clicando nos grupos.',
	'ACP_AUTOGROUPS_INVALID_EXCLUDE_GROUPS' => 'Ocorreu um erro. O grupo desta condição também não pode estar seleccionado no campo de grupos excluídos.',
	'ACP_AUTOGROUPS_EXEMPT_GROUP'           => 'Definir excepções ao grupo predefinido',
	'ACP_AUTOGROUPS_EXEMPT_GROUP_EXPLAIN'   => 'O grupo predefinido de um utilizador não será alterado automaticamente se este estiver seleccionado nesta lista. Seleccione vários grupos mantendo premida a tecla <samp>CTRL</samp> (ou <samp>&#8984;CMD</samp> no Mac) e clicando nos grupos.',

	'ACP_AUTOGROUPS_CREATE_RULE'    => 'Criar novo Autogrupo',
	'ACP_AUTOGROUPS_SUBMIT_SUCCESS' => 'Autogrupo configurado com sucesso.',
	'ACP_AUTOGROUPS_DELETE_CONFIRM' => 'Tem a certeza de que quer eliminar esta configuração de Autogrupo?',
	'ACP_AUTOGROUPS_DELETE_SUCCESS' => 'Autogrupo eliminado com sucesso.',
	'ACP_AUTOGROUPS_EMPTY'          => 'Não existem Autogrupos.',
	'ACP_AUTOGROUPS_NO_GROUPS'      => 'Não existem grupos disponíveis',
	'ACP_AUTOGROUPS_INVALID_GROUPS' => 'Ocorreu um erro. Não foi seleccionado um grupo de utilizadores válido.<br>Os Autogrupos só podem ser usados com grupos definidos pelo utilizador, que podem ser criados na página de gestão de grupos.',
	'ACP_AUTOGROUPS_INVALID_RANGE'  => 'Ocorreu um erro. Os valores mínimo e máximo não podem ser iguais.',

	// Conditions
	'AUTOGROUPS_TYPE_BIRTHDAYS'  => 'Idade do utilizador',
	'AUTOGROUPS_TYPE_LASTVISIT'  => 'Dias desde a última visita',
	'AUTOGROUPS_TYPE_MEMBERSHIP' => 'Dias como membro',
	'AUTOGROUPS_TYPE_POSTS'      => 'Mensagens',
	'AUTOGROUPS_TYPE_WARNINGS'   => 'Avisos',
]);
