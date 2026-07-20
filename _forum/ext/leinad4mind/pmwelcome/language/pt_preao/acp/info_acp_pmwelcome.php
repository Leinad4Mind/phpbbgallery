<?php

/**
 * @package PM Welcome for phpBB.
 * @copyright (c) 2015 Anvar
 * @copyright (c) 2020 RMcGirr83
 * @copyright (c) 2019-2022 Leinad4Mind
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 * @translation Leinad4Mind [Portuguese [pt_preao]] (2026)
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
// Some characters for use
// ’ » “ ” …


$lang = array_merge($lang, [
   'ACP_PMWELCOME'                 => 'Mensagem de boas-vindas',
   'ACP_PMWELCOME_EXPLAIN'         => 'Pode especificar o texto da mensagem privada que será enviada ao utilizador após o registo.',
   'ACP_PMWELCOME_SETTINGS'        => 'Configurações de mensagem privada de boas-vindas',
   'ACP_PMWELCOME_USER'            => 'Remetente',
   'ACP_PMWELCOME_USER_EXPLAIN'    => 'O utilizador, em nome do qual, será enviada a mensagem privada ao novo membro do fórum.',
   'ACP_PMWELCOME_SUBJECT'         => 'Assunto das boas-vindas',
   'ACP_PMWELCOME_SUBJECT_SHORT'   => 'Assunto',
   'ACP_PMWELCOME_TEXT'            => 'Texto da mensagem de boas-vindas',
   'ACP_PMWELCOME_TEXT_SHORT'      => 'Texto',
   'ACP_PMWELCOME_TEXT_EXPLAIN'    => 'Pode usar bbcode e smilies, e as seguintes variáveis: {USERNAME} para substituir pelo nome do utilizador que recebe a mensagem privada; {USER_EMAIL} para substituir pelo email do utilizador; {SITE_NAME} e {SITE_DESC} para substituir pelo nome e descrição do fórum; {BOARD_CONTACT}, {BOARD_EMAIL} e {BOARD_SIG} para substituir pelo contacto do fórum, email e assinatura; Bem como {SENDER} para inserir o nome do remetente.',
   'ACP_PMWELCOME_PREVIEW'         => 'Mensagem Privada de Boas-vindas - Pré-visualização',
   'ACP_PMWELCOME_NO_USER'         => '<b>O remetente solicitado não existe</b>',
   'ACP_PMWELCOME_CONFIG_SAVED'    => 'Configuração da Mensagem Privada de Boas-vindas foi guardada',
   'TOO_SHORT_PMWELCOME_SUBJECT'   => 'O valor para o assunto de boas-vindas é muito curto',
   'TOO_SHORT_PMWELCOME_POST_TEXT' => 'O valor para o texto da mensagem privada de boas-vindas é muito curto',
   'LOG_CONFIG_PMWELCOME_ADMIN'    => '<strong>Alterou as configurações da página da extensão da mensagem privada de boas-vindas</strong>',
   'LOG_PMWELCOME_CONFIG_UPDATE'   => '<strong>Atualizou as configurações da mensagem privada de boas-vindas</strong>',
]);
