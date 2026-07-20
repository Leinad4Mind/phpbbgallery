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
	'ACP_GROUPRULES_EXPLAIN'        => 'Este formulário permite-lhe definir quais grupos devem ser monitorizados para certos eventos e que ações tomar para eles. Note que tornar um grupo predefinido, promover e despromover só têm efeito se o usuário já estiver no grupo especificado. Certifique-se de não definir loops.',
	'ACP_GROUPRULES_RULES'          => 'Regras',
	'ACP_GROUPRULES_ADD_RULE'       => 'Adicionar regra',
	'ACP_GROUPRULES_ADD_ACTION'     => 'Adicionar ação',
	'ACP_GROUPRULES_RULE_REMOVED'   => '<strong>Regras de Grupo</strong> regra removida.',
	'ACP_GROUPRULES_ACTION_REMOVED' => '<strong>Regras de Grupo</strong> ação removida.',
	'ACP_GROUPRULES_RULE_WHEN'      => 'Quando um usuário %1$s grupo %2$s, então',
	'ACP_GROUPRULES_RULE_THEN'      => '%1$s grupo %2$s',
	'ACP_GROUPRULES_WHEN_ADD'       => 'é adicionado ao',
	'ACP_GROUPRULES_WHEN_DEL'       => 'é removido do',
	'ACP_GROUPRULES_WHEN_DEFAULT'   => 'é tornado predefinido no',
	'ACP_GROUPRULES_WHEN_PROMOTE'   => 'é promovido no',
	'ACP_GROUPRULES_WHEN_DEMOTE'    => 'é despromovido no',
	'ACP_GROUPRULES_THEN_ADD'       => 'adicionar usuário ao',
	'ACP_GROUPRULES_THEN_DEL'       => 'remover usuário do',
	'ACP_GROUPRULES_THEN_DEFAULT'   => 'tornar usuário predefinido no',
	'ACP_GROUPRULES_THEN_PROMOTE'   => 'promover usuário no',
	'ACP_GROUPRULES_THEN_DEMOTE'    => 'despromover usuário no',
	'ACP_GROUPRULES_STOP'           => 'não despoletar outras regras',
	'ACP_GROUPRULES_SETTINGS_SAVED' => '<strong>Regras de Grupo</strong> configurações guardadas.',
]);
