<?php

/**
 * @package Two Factor Authentication for phpBB.
 * @copyright (c) 2016 SiteSplat All rights reserved
 * @license Proprietary
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

$lang = array_merge(
	$lang, [
		'TFA'                      => 'Autenticação de Dois Fatores (Two Factor Authentication)',
		'TFA_REQUIRED_KEY_MISSING' => 'O administrador deste fórum requer que você tenha adicionado uma chave de Autenticação de Dois Fatores para acesso a partes (limitadas) deste fórum, contudo, de momento não tem chaves (Compatíveis) registadas na sua conta. Pode adicionar uma nova chave de segurança <a href="%s">aqui</a>.
												<br />Por motivos de segurança, o fórum foi desativado até adicionar uma chave de segurança à sua conta. Pode ser-lhe exigido que preencha a sua senha ao adicionar uma chave de segurança!',
		// Controller
		'TFA_SOMETHING_WENT_WRONG'     => 'Aconteceu algo inesperado. Por favor, tente novamente mais tarde',
		'ERR_NO_MATCHING_REQUEST'      => 'Nenhum pedido correspondente encontrado',
		'ERR_NO_MATCHING_REGISTRATION' => 'Nenhum registro correspondente encontrado',
		'ERR_AUTHENTICATION_FAILURE'   => 'A autenticação falhou',
		'ERR_UNMATCHED_CHALLENGE'      => 'O desafio de registro não corresponde',
		'ERR_ATTESTATION_SIGNATURE'    => 'A assinatura de atestado não corresponde',
		'ERR_ATTESTATION_VERIFICATION' => 'O certificado de atestado não pode ser validado',
		'ERR_BAD_RANDOM'               => 'Não foi possível obter uma boa fonte de aleatoriedade',
		'ERR_COUNTER_TOO_LOW'          => 'Contador demasiado baixo',
		'ERR_PUBKEY_DECODE'            => 'A descodificação da chave pública falhou',
		'ERR_BAD_UA_RETURNING'         => 'O User-agent (agente de usuário) devolveu um erro',
		'ERR_OLD_OPENSSL'              => 'O OpenSSL tem de ser, pelo menos, a versão 1.0.0, esta é %s',
		'UNKNOWN_ERROR'                => 'Aconteceu um erro desconhecido durante a validação da sua chave de segurança. Por favor, tente novamente mais tarde.',

		'ERR_TFA_NO_REQUEST_FOUND_IN_SESSION' => 'Nenhum pedido encontrado na sessão atual. Submeteu através de uma página diferente?',
		'TFA_TFA_NOT_REGISTERED'              => 'A chave de segurança utilizada não estava registada na sua conta',

		'TFA_NO_ACCESS'                => 'Parece que não tem acesso a esta página?',
		'TFA_UNABLE_TO_UPDATE_SESSION' => 'Não foi possível atualizar a sessão. Por favor, contacte o administrador do fórum',
		'TFA_DISABLED'                 => 'A autenticação de dois fatores foi desabilitada',

		'TFA_OTP_KEY_LOG'         => 'Chave gerada aqui, em seguida carregue em submeter',
		'TFA_OTP_KEY_LOG_EXPLAIN' => 'Introduza o código de verificação gerado pela Aplicação (App) Authenticator do seu telemóvel para iniciar sessão de forma segura na sua conta.',
		'TFA_INCORRECT_KEY'       => 'A chave fornecida estava incorreta.',
		'TFA_NO_KEY_PROVIDED'     => 'Nenhuma chave fornecida',
		'TFA_KEY_REQUIRED'        => 'Por favor, forneça a sua chave de segurança',

		'TFA_OTP' => 'OTP',
	]
);
