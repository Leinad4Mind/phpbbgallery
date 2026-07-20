<?php

/**
 * @package Ban Hammer for phpBB.
 * @copyright (c) 2015 phpBB Modders <https://phpbbmodders.net/>
 * @author Rich McGirr (RMcGirr83)
 * @author Jari Kanerva
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 * @translation Leinad4Mind [Portuguese [pt_preao]] (2026)
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

$lang = array_merge($lang, [
	'BANNED_ERROR'           => 'Ocorreu um erro!',
	'BANNED_SUCCESS'         => 'Todas as acções foram efetuadas corretamente.',
	'ERROR_BAN_EMAIL'        => 'Falha ao banir o e-mail.',
	'ERROR_BAN_IP'           => 'Falha ao banir o IP.',
	'ERROR_BAN_USER'         => 'Falha ao banir o nome de utilizador.',
	'ERROR_DEL_POSTS'        => 'Falha ao apagar as mensagens do utilizador.',
	'ERROR_MOVE_GROUP'       => 'Falha ao mover o utilizador para o grupo selecionado.',
	'ERROR_SFS'              => 'Erro ao reportar à base de dados do Stop Forum Spam',
	'BH_BAN_EMAIL'           => 'Banir o endereço de e-mail deste utilizador',
	'BH_BAN_GIVE_REASON'     => 'O motivo do banimento mostrado ao utilizador',
	'BH_BAN_IP'              => 'Banir o endereço IP deste utilizador',
	'BH_BAN_IP_EXPLAIN'      => '<strong>Cuidado com isto.</strong> A maioria dos utilizadores domésticos possui endereços IP dinâmicos e só precisam de reiniciar o router/modem para obter um novo endereço IP. No dia seguinte, esse endereço IP pode ser atribuído a um utilizador que deseja no seu fórum. Os spammers também usam proxies de anonimato na internet ou a rede Tor, tornando inútil o banimento de IP.',
	'BH_BAN_LENGTH'          => 'Banir este utilizador por %s',
	'BH_BAN_REASON'          => 'A razão interna para o banimento',
	'BH_BAN_USER'            => 'Banir este utilizador por %s',
	'BH_BAN_USER_PERM'       => 'Banir permanentemente este nome de utilizador',
	'BH_BAN_EMAIL_PERM'      => 'Banir permanentemente o endereço de e-mail deste utilizador',
	'BH_BAN_EMAIL_FOR'       => 'Banir o endereço de e-mail deste utilizador por %s',
	'BH_BAN_IP_PERM'         => 'Banir permanentemente o endereço IP deste utilizador',
	'BH_BAN_IP_FOR'          => 'Banir o endereço IP deste utilizador por %s',
	'BH_BANNED'              => 'Este utilizador está banido',
	'BH_DEL_AVATAR'          => 'Apagar o avatar deste utilizador',
	'BH_DEL_PRIVMSGS'        => 'Apagar as mensagens privadas deste utilizador',
	'BH_DEL_POSTS'           => 'Apagar as mensagens deste utilizador',
	'BH_DEL_PROFILE'         => 'Apagar os campos de perfil deste utilizador',
	'BH_DEL_SIGNATURE'       => 'Apagar a assinatura deste utilizador',
	'BH_MOVE_GROUP'          => 'Mover este utilizador para o grupo "%s"',
	'BH_REASON'              => 'Razão interna "%s"',
	'BH_REASON_USER'         => 'Razão para o utilizador "%s"',
	'BH_SUBMIT_SFS'          => 'Enviar para o Stop Forum Spam',
	'BH_THIS_USER'           => 'Banir este utilizador (Ban Hammer)',
	'SFS_REPORT'             => 'Reportar este utilizador ao Stop Forum Spam',
	'SURE_BAN'               => 'Tem a certeza de que deseja banir <strong>%s</strong>?',
	'THIS_WILL'              => 'Isto irá',
	'EXTENSION_REQUIREMENTS' => 'A extensão requer pelo menos a versão %1$s do phpBB. Tem de actualizar a sua versão do phpBB para utilizar esta extensão.',
]);
