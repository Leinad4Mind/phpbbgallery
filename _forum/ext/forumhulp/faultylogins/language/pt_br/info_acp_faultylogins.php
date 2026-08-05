<?php
/**
 * Translated By : [Brazilian Portuguese [pt_br]]
 *
 * @package phpBB Extension - Faulty Logins
 * @copyright (c) 2014 John Peskens (http://ForumHulp.com)
 * @copyright (c) 2026 Leinad4Mind
 * @license https://opensource.org/licenses/GPL-2.0 GNU General Public License v2
 *
 */

if (!defined('IN_PHPBB'))
{
	exit;
}

include __DIR__ . '/../pt/info_acp_faultylogins.php';

$lang = array_merge($lang, [
	'ACP_FAULTYLOGINS_LOGS_EXPLAIN' => 'As senhas são criptografadas antes de serem armazenadas e permanecem ocultas até que a passphrase seja informada. A passphrase nunca é armazenada.',
	'FAULTYLOGINS_CRYPTO_FAILURE' => 'A operação criptográfica falhou. Nenhuma senha em texto simples foi armazenada.',
	'FAULTYLOGINS_PASSWORD' => 'Senha informada',
	'FAULTYLOGINS_PASSWORD_TRUNCATED' => 'A entrada excedeu 4096 bytes e foi truncada com segurança.',
	'FAULTYLOGINS_PURGE_CONFIRM' => 'Entendo que as senhas excluídas não poderão ser recuperadas.',
	'FAULTYLOGINS_REASON_CONVERT' => 'É necessária a conversão da senha antiga',
	'FAULTYLOGINS_REASON_PASSWORD' => 'Senha incorreta',
	'FAULTYLOGINS_REASON_USERNAME' => 'Nome de usuário desconhecido',
	'FAULTYLOGINS_RECOVERY_KEY_EXPLAIN' => 'Esta chave pode descriptografar todas as senhas armazenadas. Copie-a para um armazenamento offline seguro; ela não será exibida novamente de forma automática.',
	'FAULTYLOGINS_UNLOCK' => 'Revelar senhas',
	'FAULTYLOGINS_USERNAME' => 'Nome de usuário informado',
	'LOG_FAULTYLOGINS_VIEWED' => '<strong>Revelou senhas criptografadas dos Logins falhados</strong><br>» %d registros',
]);
