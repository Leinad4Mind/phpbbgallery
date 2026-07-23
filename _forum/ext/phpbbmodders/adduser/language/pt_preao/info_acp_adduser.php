<?php

/**
 * @package phpBB Extension - Add User for phpBB.
 * @author RMcGirr83  (Rich McGirr) rmcgirr83@rmcgirr83.org
 * @copyright (c) 2014 phpbbmodders.net
 * @license GNU General Public License, version 2 (GPL-2.0)
 * @translation Leinad4Mind [Portuguese [pt_preao]] (2026)
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
	'ACP_ADD_USER'               => 'ACP Adicionar Utilizador',
	'DIR_NOT_EXIST'              => 'O idioma que escolheste %s não tem os ficheiros necessários para a extensão. Por favor, traduz-os e faz o upload para a directoria %s da extensão para poderes usá-la.',
	'ACP_ACCOUNT_ADDED'          => 'A conta do utilizador foi criada. O utilizador pode agora entrar com o nome de utilizador e a palavra-passe enviada para o endereço de e-mail que forneceu.',
	'ACP_ACCOUNT_INACTIVE'       => 'A conta do utilizador foi criada. No entanto, as configurações do fórum exigem que o utilizador ative a sua conta.<br />Uma chave de ativação foi enviada para o endereço de e-mail que forneceu para o utilizador.',
	'ACP_ACCOUNT_INACTIVE_ADMIN' => 'A conta foi criada. No entanto, as configurações do fórum exigem a ativação da conta por um administrador.<br />Um e-mail foi enviado para os Administradores e o utilizador será informado quando a sua conta for ativada.',
	'ACP_ADMIN_ACTIVATE'         => 'Um e-mail será enviado a um Administrador para ativação da conta. Em alternativa, podes marcar a caixa "Ativar conta de utilizador" abaixo para ativar a conta instantaneamente assim que criada. O utilizador receberá um e-mail contendo os detalhes de login da conta.',
	'ACP_EMAIL_ACTIVATE'         => 'Uma vez criada a conta, o utilizador receberá um e-mail contendo um link de ativação para ativar a conta.',
	'ACP_INSTANT_ACTIVATE'       => 'A conta será ativada instantaneamente. O utilizador receberá um e-mail com os detalhes de login da conta.',
	'ADD_USER'                   => 'Adicionar Utilizador',
	'ADD_USER_EXPLAIN'           => 'Criar uma nova conta de utilizador. Se as tuas configurações de ativação forem apenas para Ativação por Administrador, terás a opção de ativar o utilizador instantaneamente.',
	'ADMIN_ACTIVATE'             => 'Ativar conta de utilizador',
	'CONFIRM_PASSWORD'           => 'Confirmar palavra-passe',
	'EDIT_USER_GROUPS'           => '%sClica aqui para editar os grupos de utilizadores deste utilizador%s',
	'GROUP_ADD'                  => 'Fazer uma seleção aqui adicionará o utilizador ao grupo selecionado, bem como ao grupo de utilizadores registados.',
	'GROUP_DEFAULT_EXPLAIN'      => 'Marcar esta caixa definirá o grupo selecionado acima como sendo o predefinido do utilizador.',
	'CONTINUE_EDIT_USER'         => '%1$sClica aqui para gerir o perfil de %2$s%3$s',
	'PASSWORD_EXPLAIN'           => 'Se deixado em branco, será gerada automaticamente uma palavra-passe.',
	'ENABLE_NEWUSER'             => 'Ativar novo utilizador',
	'ENABLE_NEWUSER_EXPLAIN'     => 'Se definido como sim, o utilizador será adicionado ao grupo de novos utilizadores registados',
	'LOG_USER_ADDED'             => '<strong>Novo utilizador criado</strong><br />» %s',
]);
