<?php

/**
 * @copyright (c) 2019-2022 Leinad4Mind
 * @license GNU General Public License, version 2 (GPL-2.0)
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
	'BAN_REASON'                     => 'Menor de idade',
	'ENTER_BIRTHDATE'                => 'Introduza a sua data de nascimento',
	'REGISTRATION_AGE_ERROR'         => 'A idade introduzida é %1$s. A idade mínima neste fórum é %2$s.',
	'REGISTRATION_AGE_MISSING'       => 'Dados da data de nascimento inválidos.',
	'REGISTRATION_AGE_REQUIRED'      => 'Deve inserir o seu aniversário.',
	'REGISTRATION_AGE_CANNOT_CHANGE' => 'Não pode alterar o seu aniversário.',
	'REGISTRATION_AGE_PROFILE'       => 'Quem pode ver a minha idade',
	'REGISTRATION_AGE_EVERYBODY'     => 'Todos',
	'REGISTRATION_AGE_NOBODY'        => 'Ninguém',
	'REGISTRATION_AGE_FRIENDS'       => 'Apenas os meus amigos',
]);
