<?php

/**
 * Contact Admin extension for the phpBB Forum Software package.
 * @copyright 2016 Rich McGirr (RMcGirr83)
 * @license GNU General Public License, version 2 (GPL-2.0)
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
// ’ » “ ” …
//

$lang = array_merge($lang, [
	'ADMINS_NOT_EXIST_FOR_METHOD' => [
		0 => 'Não existem Administradores que permitam e-mails. Tem de escolher um método de contato diferente.',
		2 => 'Não existem Administradores que permitam mensagens privadas. Tem de escolher um método de contato diferente.',
	],
	'CONTACT_CONFIG_SAVED'           => 'A configuração de Contato ao Administrador foi atualizada',
	'CONTACT_ACP_CONFIRM'            => 'Habilitar confirmação visual',
	'CONTACT_ACP_CONFIRM_EXPLAIN'    => 'Se habilitar esta opção, os usuários terão de introduzir uma confirmação visual para enviar a mensagem.<br>Isto serve para prevenir mensagens de spam. Note que esta opção é apenas para a página de contato. Não afeta as restantes configurações de confirmação visual.',
	'CONTACT_ATTACHMENTS'            => 'Anexos permitidos',
	'CONTACT_ATTACHMENTS_EXPLAIN'    => 'Se definido, os anexos serão permitidos na publicação no fórum e em mensagens privadas.<br>As extensões permitidas são as mesmas da configuração do fórum.<br><span style="color:red;">Não se aplica ao método de contato via “E-mail”.</span>',
	'CONTACT_CONFIRM_GUESTS'         => 'Confirmação visual apenas para visitantes',
	'CONTACT_CONFIRM_GUESTS_EXPLAIN' => 'Se esta opção estiver habilitada, a confirmação visual só será mostrada a visitantes (se estiver habilitada)',
	'CONTACT_WHO'                    => 'Quem contatar',
	'CONTACT_WHO_EXPLAIN'            => 'Quem deve ser contactado via E-mail ou MP',
	'CONTACT_MAX_ATTEMPTS'           => 'Máximo de tentativas de confirmação',
	'CONTACT_MAX_ATTEMPTS_EXPLAIN'   => 'Quantas vezes pode um usuário tentar introduzir a imagem de confirmação correta?<br>Introduza 0 para tentativas ilimitadas',
	'CONTACT_METHOD'                 => 'Método de contato',
	'CONTACT_METHOD_EXPLAIN'         => 'Como pretende que os usuários possam contatar',
	'CONTACT_POST_OPTIONS'           => 'Opções de Publicação de Contato ou MP',
	'CONTACT_REASONS'                => 'Razões de contato',
	'CONTACT_REASONS_EXPLAIN'        => 'Introduza as razões para contatar, separadas por novas linhas.<br>Se não quiser utilizar esta funcionalidade, deixe este campo em branco',
	// Bot config options
	'CONTACT_BOT_FORUM'            => 'Fórum do bot de contato',
	'CONTACT_BOT_FORUM_EXPLAIN'    => 'Selecione o fórum onde o bot de contato deve publicar, se o método de contato estiver definido para “Publicação no fórum”',
	'CONTACT_BOT_POSTER'           => 'Bot como Autor',
	'CONTACT_BOT_POSTER_EXPLAIN'   => 'Se definido, as MPs e as publicações parecerão vir do usuário bot de contato escolhido acima, com base nas configurações aqui definidas. Se for selecionado “Nenhum”, o bot não é utilizado como autor. As publicações e as MPs serão feitas com base nas informações introduzidas no formulário de contato',
	'CONTACT_BOT_USER'             => 'Usuário bot de contato',
	'CONTACT_BOT_USER_EXPLAIN'     => 'Selecione o usuário sob o qual as mensagens serão publicadas se o método de contato estiver definido para “Mensagem Privada” ou “Publicação no Fórum”.',
	'CONTACT_NO_BOT_USER'          => '<strong>O ID do usuário bot de contato escolhido não existe</strong>',
	'CONTACT_BOT_IS_BOT'           => '<strong>O bot de contato escolhido está designado como bot do fórum. Tem a certeza que deseja este usuário como bot?</strong>',
	'CONTACT_USERNAME_CHK'         => 'Verificar Nome de Usuário',
	'CONTACT_USERNAME_CHK_EXPLAIN' => 'Se definido para sim, o nome de usuário introduzido será verificado na base de dados. Se o nome for encontrado, o usuário receberá um erro e ser-lhe-á pedido que introduza um nome de usuário diferente',
	'CONTACT_EMAIL_CHK'            => 'Verificar E-mail',
	'CONTACT_EMAIL_CHK_EXPLAIN'    => 'Se definido para sim, o e-mail introduzido será verificado na base de dados. Se o endereço de e-mail for encontrado, o usuário receberá um erro e ser-lhe-á pedido que introduza um endereço de e-mail diferente',

	// Contact methods
	'CONTACT_METHOD_EMAIL' => 'E-mail',
	'CONTACT_METHOD_PM'    => 'Mensagem privada',
	'CONTACT_METHOD_POST'  => 'Publicação no fórum',

	// Contact methods
	'CONTACT_WHO_ALL_ADMINS'    => 'Todos os Administradores',
	'CONTACT_WHO_BOARD_FOUNDER' => 'Fundador do Fórum',
	'CONTACT_WHO_BOARD_DEFAULT' => 'E-mail Padrão do Fórum',

	// Contact posters...user bot
	'CONTACT_POST_NEITHER' => 'Nenhum',
	'CONTACT_POST_GUEST'   => 'Apenas visitantes',
	'CONTACT_POST_ALL'     => 'Todos',

	// Overwrite the default contact page lang
	'CONTACT_EXTENSION_ACTIVE' => '<span style="color:red;">As definições aqui não terão importância, uma vez que tem atualmente a extensão Contact Admin habilitada. Não conseguirá definir isto para ativado sem primeiro desabilitar a extensão</span>',
	'CONTACT_GDPR'             => 'RGPD',
	'CONTACT_GDPR_EXPLAIN'     => 'Se definido para sim, será apresentada uma caixa de verificação ao usuário para reconhecer a política de privacidade do fórum. A caixa deve ser assinalada para o formulário de contato ser enviado',
	'EMAIL_NOT_CONFIGURED'     => 'O e-mail não está configurado para o fórum, por favor faça uma seleção diferente para o método de contato',
]);
