<?php
/**
 * Translated By : [Portuguese [pt]]
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

$lang = array_merge($lang, [
	'ACP_FAULTYLOGINS_TITLE' => 'Logins falhados',
	'ACP_FAULTYLOGINS_LOGS' => 'Tentativas de login cifradas',
	'ACP_FAULTYLOGINS_LOGS_EXPLAIN' => 'As palavras-passe são cifradas antes de serem guardadas e permanecem ocultas até ser introduzida a passphrase. A passphrase nunca é guardada.',
	'ACP_FAULTYLOGINS_SECURITY' => 'Segurança e retenção',
	'ACP_FAULTYLOGINS_SECURITY_EXPLAIN' => 'Configure as chaves de cifragem, o material de recuperação e a política de retenção automática.',
	'FAULTYLOGINS_ALREADY_INITIALIZED' => 'A cifragem já foi inicializada.',
	'FAULTYLOGINS_CHANGE_PASSPHRASE' => 'Alterar passphrase',
	'FAULTYLOGINS_CHANGE_PASSPHRASE_EXPLAIN' => 'Alterar a passphrase volta a cifrar a mesma chave privada. Os registos anteriores e futuros continuam acessíveis.',
	'FAULTYLOGINS_CONFIRM_PASSPHRASE' => 'Confirmar passphrase',
	'FAULTYLOGINS_CRYPTO_FAILURE' => 'A operação criptográfica falhou. Nenhuma palavra-passe em texto simples foi guardada.',
	'FAULTYLOGINS_CURRENT_PASSPHRASE' => 'Passphrase atual',
	'FAULTYLOGINS_DATE' => 'Data',
	'FAULTYLOGINS_EXPORT_RECOVERY' => 'Exportar chave de recuperação',
	'FAULTYLOGINS_EXPORT_RECOVERY_EXPLAIN' => 'Introduza a passphrase atual para apresentar a chave privada de recuperação. Guarde-a offline e nunca a envie por email.',
	'FAULTYLOGINS_INITIALIZE' => 'Inicializar cifragem',
	'FAULTYLOGINS_INITIALIZED' => 'Cifragem inicializada. Foram cifrados %1$d registos antigos e removidas %2$d entradas antigas inseguras.',
	'FAULTYLOGINS_INITIAL_SETUP' => 'Configuração inicial da cifragem',
	'FAULTYLOGINS_INITIAL_SETUP_EXPLAIN' => 'Escolha uma passphrase forte. Uma chave pública cifrará novas tentativas e a chave privada ficará protegida por esta passphrase.',
	'FAULTYLOGINS_INVALID_PASSPHRASE' => 'A passphrase está incorreta.',
	'FAULTYLOGINS_INVALID_RECOVERY_KEY' => 'A chave de recuperação é inválida ou não pertence a esta instalação.',
	'FAULTYLOGINS_IP' => 'Endereço IP',
	'FAULTYLOGINS_LEGACY_LOGS' => 'Logs antigos inseguros',
	'FAULTYLOGINS_LEGACY_LOGS_EXPLAIN' => 'Ainda existem %d entradas antigas no log administrativo que necessitam de migração segura.',
	'FAULTYLOGINS_LEGACY_MIGRATED' => 'Foram cifrados %1$d registos antigos e removidas %2$d entradas inseguras.',
	'FAULTYLOGINS_LEGACY_REASON' => 'Falha de login antiga',
	'FAULTYLOGINS_MIGRATE_LEGACY' => 'Cifrar e remover logs antigos',
	'FAULTYLOGINS_NEW_PASSPHRASE' => 'Nova passphrase',
	'FAULTYLOGINS_NOT_INITIALIZED' => 'A cifragem ainda não foi configurada. Abra a página Segurança antes de recolher novas tentativas.',
	'FAULTYLOGINS_NO_ATTEMPTS' => 'Não existem tentativas de login cifradas.',
	'FAULTYLOGINS_PASSWORD' => 'Palavra-passe tentada',
	'FAULTYLOGINS_PASSWORD_TRUNCATED' => 'A entrada excedeu 4096 bytes e foi truncada com segurança.',
	'FAULTYLOGINS_PASSPHRASE' => 'Passphrase',
	'FAULTYLOGINS_PASSPHRASE_CHANGED' => 'A passphrase foi alterada. Todos os registos continuam acessíveis com a nova passphrase.',
	'FAULTYLOGINS_PASSPHRASE_MISMATCH' => 'A nova passphrase e a confirmação não coincidem.',
	'FAULTYLOGINS_PASSPHRASE_REQUIREMENTS' => 'A passphrase deve ter pelo menos %d caracteres e não pode ser um PIN curto.',
	'FAULTYLOGINS_PURGE' => 'Eliminar logs cifrados',
	'FAULTYLOGINS_PURGE_CONFIRM' => 'Compreendo que as palavras-passe eliminadas não podem ser recuperadas.',
	'FAULTYLOGINS_PURGE_CONFIRM_REQUIRED' => 'Confirme que compreende a eliminação permanente.',
	'FAULTYLOGINS_PURGE_EXPLAIN' => 'Eliminar permanentemente as %d tentativas cifradas. As chaves de cifragem serão preservadas.',
	'FAULTYLOGINS_PURGED' => 'Foram eliminadas permanentemente %d tentativas de login cifradas.',
	'FAULTYLOGINS_REASON' => 'Motivo',
	'FAULTYLOGINS_REASON_ACTIVE' => 'Conta inativa ou ignorada',
	'FAULTYLOGINS_REASON_ATTEMPTS' => 'Demasiadas tentativas ou falha no CAPTCHA',
	'FAULTYLOGINS_REASON_CONVERT' => 'Necessária conversão de palavra-passe antiga',
	'FAULTYLOGINS_REASON_EXTERNAL' => 'Falha de autenticação externa',
	'FAULTYLOGINS_REASON_PASSWORD' => 'Palavra-passe incorreta',
	'FAULTYLOGINS_REASON_UNKNOWN' => 'Falha de autenticação desconhecida',
	'FAULTYLOGINS_REASON_USERNAME' => 'Nome de utilizador desconhecido',
	'FAULTYLOGINS_RECOVER_ACCESS' => 'Recuperar acesso',
	'FAULTYLOGINS_RECOVER_ACCESS_EXPLAIN' => 'Utilize a chave de recuperação offline para proteger a chave privada existente com uma nova passphrase.',
	'FAULTYLOGINS_RECOVERED' => 'Acesso recuperado. Os registos anteriores e futuros utilizam agora a nova passphrase.',
	'FAULTYLOGINS_RECOVERY_EXPORTED' => 'A chave de recuperação é apresentada abaixo. Copie-a agora e guarde-a offline.',
	'FAULTYLOGINS_RECOVERY_KEY' => 'Chave privada de recuperação',
	'FAULTYLOGINS_RECOVERY_KEY_EXPLAIN' => 'Esta chave pode desencriptar todas as palavras-passe guardadas. Copie-a para armazenamento offline seguro; não será apresentada novamente de forma automática.',
	'FAULTYLOGINS_RETENTION_DAYS' => 'Período de retenção',
	'FAULTYLOGINS_RETENTION_DAYS_EXPLAIN' => 'As tentativas cifradas mais antigas do que este número de dias serão eliminadas automaticamente (1–3650).',
	'FAULTYLOGINS_SETTINGS' => 'Definições de recolha',
	'FAULTYLOGINS_SETTINGS_SAVED' => 'As definições de recolha e retenção foram guardadas.',
	'FAULTYLOGINS_SODIUM_REQUIRED' => 'A extensão Sodium do PHP é obrigatória. A cifragem não pode funcionar sem ela.',
	'FAULTYLOGINS_THROTTLE_SECONDS' => 'Intervalo mínimo por IP',
	'FAULTYLOGINS_THROTTLE_SECONDS_EXPLAIN' => 'Suprimir escritas repetidas do mesmo IP durante este número de segundos (0–3600).',
	'FAULTYLOGINS_TOTAL' => '%d tentativas cifradas guardadas.',
	'FAULTYLOGINS_UNLOCK' => 'Revelar palavras-passe',
	'FAULTYLOGINS_UNLOCK_EXPLAIN' => 'A passphrase revela apenas a página atual e é descartada imediatamente após a apresentação.',
	'FAULTYLOGINS_UNLOCK_LOCKED' => 'Demasiadas tentativas incorretas. A validação da passphrase está bloqueada durante %d minutos.',
	'FAULTYLOGINS_USERNAME' => 'Nome de utilizador tentado',
	'LOG_FAULTYLOGINS_INITIALIZED' => '<strong>Inicializou a cifragem dos Logins falhados</strong>',
	'LOG_FAULTYLOGINS_PASSPHRASE_CHANGED' => '<strong>Alterou a passphrase dos Logins falhados</strong>',
	'LOG_FAULTYLOGINS_PURGED' => '<strong>Eliminou registos dos Logins falhados</strong><br>» %d registos',
	'LOG_FAULTYLOGINS_RECOVERED' => '<strong>Recuperou o acesso à cifragem dos Logins falhados</strong>',
	'LOG_FAULTYLOGINS_RECOVERY_EXPORTED' => '<strong>Exportou a chave de recuperação dos Logins falhados</strong>',
	'LOG_FAULTYLOGINS_SETTINGS_CHANGED' => '<strong>Alterou as definições dos Logins falhados</strong>',
	'LOG_FAULTYLOGINS_VIEWED' => '<strong>Revelou palavras-passe cifradas dos Logins falhados</strong><br>» %d registos',
]);
