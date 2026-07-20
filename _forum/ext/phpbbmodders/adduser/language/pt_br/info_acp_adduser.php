<?php

/**
 * @package phpBB Extension - Add User for phpBB.
 * @author RMcGirr83  (Rich McGirr) rmcgirr83@rmcgirr83.org
 * @copyright (c) 2014 phpbbmodders.net
 * @license GNU General Public License, version 2 (GPL-2.0)
 * @translation Leinad4Mind [Brazilian Portuguese [pt_br]] (2026)
 */

/**
* @ignore
*/
if (!defined('IN_PHPBB'))
{
	exit;
}

/**
* DO NOT CHANGE
*/
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

$lang = array_merge($lang, [
	'ACP_ADD_USER'               => 'ACP Adicionar Usuário',
	'DIR_NOT_EXIST'              => 'O idioma que escolheu %s não tem os arquivos necessários para a extensão. Por favor, traduza-os e faça o upload para a diretoria %s da extensão para poder usá-la.',
	'ACP_ACCOUNT_ADDED'          => 'A conta do usuário foi criada. O usuário pode agora entrar com o nome de usuário e a senha enviada para o endereço de e-mail que forneceu.',
	'ACP_ACCOUNT_INACTIVE'       => 'A conta do usuário foi criada. No entanto, as configurações do fórum exigem que o usuário ative a sua conta.<br />Uma chave de habilitação foi enviada para o endereço de e-mail que forneceu para o usuário.',
	'ACP_ACCOUNT_INACTIVE_ADMIN' => 'A conta foi criada. No entanto, as configurações do fórum exigem a habilitação da conta por um administrador.<br />Um e-mail foi enviado para os Administradores e o usuário será informado quando a sua conta for habilitada.',
	'ACP_ADMIN_ACTIVATE'         => 'Um e-mail será enviado a um Administrador para habilitação da conta. Em alternativa, pode marcar a caixa "Habilitar conta de usuário" abaixo para habilitar a conta instantaneamente assim que criada. O usuário receberá um e-mail contendo os detalhes de login da conta.',
	'ACP_EMAIL_ACTIVATE'         => 'Uma vez criada a conta, o usuário receberá um e-mail contendo um link de habilitação para habilitar a conta.',
	'ACP_INSTANT_ACTIVATE'       => 'A conta será habilitada instantaneamente. O usuário receberá um e-mail com os detalhes de login da conta.',
	'ADD_USER'                   => 'Adicionar Usuário',
	'ADD_USER_EXPLAIN'           => 'Criar uma nova conta de usuário. Se as suas configurações de habilitação forem apenas para Habilitação por Administrador, terá a opção de habilitar o usuário instantaneamente.',
	'ADMIN_ACTIVATE'             => 'Habilitar conta de usuário',
	'CONFIRM_PASSWORD'           => 'Confirmar senha',
	'EDIT_USER_GROUPS'           => '%sClique aqui para editar os grupos de usuários deste usuário%s',
	'GROUP_ADD'                  => 'Fazer uma seleção aqui adicionará o usuário ao grupo selecionado, bem como ao grupo de usuários registados.',
	'GROUP_DEFAULT_EXPLAIN'      => 'Marcar esta caixa definirá o grupo selecionado acima como sendo o predefinido do usuário.',
	'CONTINUE_EDIT_USER'         => '%1$sClique aqui para gerir o perfil de %2$s%3$s',
	'PASSWORD_EXPLAIN'           => 'Se deixado em branco, será gerada automaticamente uma senha.',
	'ENABLE_NEWUSER'             => 'Habilitar novo usuário',
	'ENABLE_NEWUSER_EXPLAIN'     => 'Se definido como sim, o usuário será adicionado ao grupo de novos usuários registados',
	'LOG_USER_ADDED'             => '<strong>Novo usuário criado</strong><br />» %s',
]);
