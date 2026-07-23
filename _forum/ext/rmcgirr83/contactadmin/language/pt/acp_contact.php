<?php

/**
 * Contact Admin extension for the phpBB Forum Software package.
 * @copyright 2016 Rich McGirr (RMcGirr83)
 * @license GNU General Public License, version 2 (GPL-2.0)
 * @translation Leinad4Mind [Portuguese [pt]] (2026)
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
		0 => 'Não existem Administradores que permitam e-mails. Tens de escolher um método de contacto diferente.',
		2 => 'Não existem Administradores que permitam mensagens privadas. Tens de escolher um método de contacto diferente.',
	],
	'CONTACT_CONFIG_SAVED'           => 'A configuração de Contacto ao Administrador foi atualizada',
	'CONTACT_ACP_CONFIRM'            => 'Ativar confirmação visual',
	'CONTACT_ACP_CONFIRM_EXPLAIN'    => 'Se ativares esta opção, os utilizadores terão de introduzir uma confirmação visual para enviar a mensagem.<br>Isto serve para prevenir mensagens de spam. Nota que esta opção é apenas para a página de contacto. Não afeta as restantes configurações de confirmação visual.',
	'CONTACT_ATTACHMENTS'            => 'Anexos permitidos',
	'CONTACT_ATTACHMENTS_EXPLAIN'    => 'Se definido, os anexos serão permitidos na publicação no fórum e em mensagens privadas.<br>As extensões permitidas são as mesmas da configuração do fórum.<br><span style="color:red;">Não se aplica ao método de contacto via “E-mail”.</span>',
	'CONTACT_CONFIRM_GUESTS'         => 'Confirmação visual apenas para visitantes',
	'CONTACT_CONFIRM_GUESTS_EXPLAIN' => 'Se esta opção estiver ativada, a confirmação visual só será mostrada a visitantes (se estiver ativada)',
	'CONTACT_WHO'                    => 'Quem contactar',
	'CONTACT_WHO_EXPLAIN'            => 'Quem deve ser contactado via E-mail ou MP',
	'CONTACT_MAX_ATTEMPTS'           => 'Máximo de tentativas de confirmação',
	'CONTACT_MAX_ATTEMPTS_EXPLAIN'   => 'Quantas vezes pode um utilizador tentar introduzir a imagem de confirmação correta?<br>Introduz 0 para tentativas ilimitadas',
	'CONTACT_METHOD'                 => 'Método de contacto',
	'CONTACT_METHOD_EXPLAIN'         => 'Como pretendes que os utilizadores possam contactar',
	'CONTACT_POST_OPTIONS'           => 'Opções de Publicação de Contacto ou MP',
	'CONTACT_REASONS'                => 'Razões de contacto',
	'CONTACT_REASONS_EXPLAIN'        => 'Introduz as razões para contactar, separadas por novas linhas.<br>Se não quiseres utilizar esta funcionalidade, deixa este campo em branco',
	// Bot config options
	'CONTACT_BOT_FORUM'            => 'Fórum do bot de contacto',
	'CONTACT_BOT_FORUM_EXPLAIN'    => 'Seleciona o fórum onde o bot de contacto deve publicar, se o método de contacto estiver definido para “Publicação no fórum”',
	'CONTACT_BOT_POSTER'           => 'Bot como Autor',
	'CONTACT_BOT_POSTER_EXPLAIN'   => 'Se definido, as MPs e as publicações parecerão vir do utilizador bot de contacto escolhido acima, com base nas configurações aqui definidas. Se for selecionado “Nenhum”, o bot não é utilizado como autor. As publicações e as MPs serão feitas com base nas informações introduzidas no formulário de contacto',
	'CONTACT_BOT_USER'             => 'Utilizador bot de contacto',
	'CONTACT_BOT_USER_EXPLAIN'     => 'Seleciona o utilizador sob o qual as mensagens serão publicadas se o método de contacto estiver definido para “Mensagem Privada” ou “Publicação no Fórum”.',
	'CONTACT_NO_BOT_USER'          => '<strong>O ID do utilizador bot de contacto escolhido não existe</strong>',
	'CONTACT_BOT_IS_BOT'           => '<strong>O bot de contacto escolhido está designado como bot do fórum. Tens a certeza de que desejas este utilizador como bot?</strong>',
	'CONTACT_USERNAME_CHK'         => 'Verificar Nome de Utilizador',
	'CONTACT_USERNAME_CHK_EXPLAIN' => 'Se definido para sim, o nome de utilizador introduzido será verificado na base de dados. Se o nome for encontrado, o utilizador receberá um erro e ser-lhe-á pedido que introduza um nome de utilizador diferente',
	'CONTACT_EMAIL_CHK'            => 'Verificar E-mail',
	'CONTACT_EMAIL_CHK_EXPLAIN'    => 'Se definido para sim, o e-mail introduzido será verificado na base de dados. Se o endereço de e-mail for encontrado, o utilizador receberá um erro e ser-lhe-á pedido que introduza um endereço de e-mail diferente',

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
	'CONTACT_EXTENSION_ACTIVE' => '<span style="color:red;">As definições aqui não terão importância, uma vez que tens atualmente a extensão Contact Admin ativada. Não conseguirás definir isto para ativado sem primeiro desativar a extensão</span>',
	'CONTACT_GDPR'             => 'RGPD',
	'CONTACT_GDPR_EXPLAIN'     => 'Se definido para sim, será apresentada uma caixa de verificação ao utilizador para reconhecer a política de privacidade do fórum. A caixa deve ser assinalada para o formulário de contacto ser enviado',
	'EMAIL_NOT_CONFIGURED'     => 'O e-mail não está configurado para o fórum, por favor faz uma seleção diferente para o método de contacto',
]);
