<?php
/**
 * Translated By : [Portuguese [pt_preao]]
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
	'ACP_FAULTYLOGINS_LOGS' => 'Tentativas de login encriptadas',
	'ACP_FAULTYLOGINS_SECURITY_EXPLAIN' => 'Configure as chaves de encriptação, o material de recuperação e a política de retenção automática.',
	'FAULTYLOGINS_CHANGE_PASSPHRASE_EXPLAIN' => 'Alterar a passphrase volta a encriptar a mesma chave privada. Os registos anteriores e futuros continuam acessíveis.',
	'FAULTYLOGINS_INITIALIZE' => 'Inicializar encriptação',
	'FAULTYLOGINS_INITIAL_SETUP' => 'Configuração inicial da encriptação',
]);
