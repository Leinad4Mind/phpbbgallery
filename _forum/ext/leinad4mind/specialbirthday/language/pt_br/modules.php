<?php

/**
 * @copyright (c) 2019-2022 Leinad4Mind
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
	'ACP_USER_UTILS'                  => 'Utilitários do usuário',
	'REGISTRATION_AGE'                => 'Aniversário Especial',
	'REGISTRATION_AGE_LOG'            => '<strong>Configurações do Aniversário Especial Atualizadas</strong>',
	'REGISTRATION_AGE_MANAGE'         => 'Gerir Aniversário Especial',
	'REGISTRATION_AGE_LOG_FAIL'       => '<strong>Verificação da data de nascimento falhou</strong><br>» %1$s introduziu uma idade de %2$s',
	'REGISTRATION_AGE_CHANGED'        => '<strong>Aniversário alterado</strong><br>» de %1$s para %2$s',
	'REGISTRATION_AGE_CHANGE_ATTEMPT' => '<strong>Tentativa de alterar aniversário</strong><br>» para %1$s, idade: %2$d',
]);
