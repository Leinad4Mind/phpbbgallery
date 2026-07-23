<?php

/**
 * @package Ban Hammer for phpBB.
 * @copyright (c) 2015 phpBB Modders <https://phpbbmodders.net/>
 * @author Jari Kanerva
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 * @translation Leinad4Mind [Portuguese [pt]] (2026)
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
	'ACP_BAN_EMAIL'          => 'Banir endereço de e-mail de utilizadores',
	'ACP_BAN_IP'             => 'Banir endereço IP de utilizadores',
	'ACP_BAN_IP_EXPLAIN'     => '<strong>Cuidado com isto.</strong> A maioria dos utilizadores domésticos possui endereços IP dinâmicos e só precisam de reiniciar o router/modem para obter um novo endereço IP. No dia seguinte, esse endereço IP pode ser atribuído a um utilizador que deseja no seu fórum. Os spammers também usam proxies de anonimato na internet ou a rede Tor, tornando inútil o banimento de IP.',
	'ACP_DEL_AVATAR'         => 'Apagar avatar de utilizadores',
	'ACP_DEL_PRIVMSGS'       => 'Apagar mensagens privadas de utilizadores',
	'ACP_DEL_POSTS'          => 'Apagar mensagens de utilizadores',
	'ACP_DEL_PROFILE'        => 'Apagar campos de perfil de utilizadores',
	'ACP_DEL_SIGNATURE'      => 'Apagar assinatura de utilizadores',
	'ACP_GROUP_MISSING'      => 'O grupo "%s" não existe.',
	'ACP_MOVE_GROUP'         => 'Mover para o grupo',
	'ACP_MOVE_GROUP_EXPLAIN' => 'Nome do grupo para o qual os utilizadores banidos devem ser movidos. Este também será o seu grupo predefinido.<br /><strong>Se não houver mais nada além de <em>"Nenhum grupo especificado."</em> na lista pendente, então não configurou nenhum grupo.</strong>',
	'BAN_LENGTH_EXPLAIN'     => 'Se qualquer uma das opções de banimento for definida, o utilizador será banido pelo tempo definido aqui. Isto também pode ser definido ao banir o utilizador (Ban Hammer).',
	'SETTINGS_ERROR'         => 'Ocorreu um erro ao guardar as suas configurações. Por favor envie o relatório de erros.',
	'SFS_API_KEY'            => 'Chave da API do SFS',
	'SFS_API_KEY_EXPLAIN'    => 'Se quiser denunciar spammers automaticamente para o StopForumSpam, vai precisar de uma chave de API, <a href="http://www.stopforumspam.com/signup">http://www.stopforumspam.com/signup</a>.',
	'SFS_NEEDS_CURL'         => '<span style="color:red;">O seu servidor necessita de ter o cURL instalado para utilizar o serviço stop forum spam.</span>',
]);
