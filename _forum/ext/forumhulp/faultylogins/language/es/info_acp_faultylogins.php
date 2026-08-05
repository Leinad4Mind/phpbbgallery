<?php
/**
 * Translated By : [Spanish [es]]
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

include __DIR__ . '/../en/info_acp_faultylogins.php';

$lang = array_merge($lang, [
	'ACP_FAULTYLOGINS_TITLE' => 'Inicios de sesión fallidos',
	'ACP_FAULTYLOGINS_LOGS' => 'Intentos de inicio de sesión cifrados',
	'ACP_FAULTYLOGINS_SECURITY' => 'Seguridad y retención',
	'FAULTYLOGINS_CHANGE_PASSPHRASE' => 'Cambiar passphrase',
	'FAULTYLOGINS_CONFIRM_PASSPHRASE' => 'Confirmar passphrase',
	'FAULTYLOGINS_CURRENT_PASSPHRASE' => 'Passphrase actual',
	'FAULTYLOGINS_DATE' => 'Fecha',
	'FAULTYLOGINS_IP' => 'Dirección IP',
	'FAULTYLOGINS_NEW_PASSPHRASE' => 'Nueva passphrase',
	'FAULTYLOGINS_PASSWORD' => 'Contraseña intentada',
	'FAULTYLOGINS_REASON' => 'Motivo',
	'FAULTYLOGINS_REASON_PASSWORD' => 'Contraseña incorrecta',
	'FAULTYLOGINS_REASON_USERNAME' => 'Nombre de usuario desconocido',
	'FAULTYLOGINS_RECOVER_ACCESS' => 'Recuperar acceso',
	'FAULTYLOGINS_RECOVERY_KEY' => 'Clave privada de recuperación',
	'FAULTYLOGINS_UNLOCK' => 'Mostrar contraseñas',
	'FAULTYLOGINS_USERNAME' => 'Nombre de usuario intentado',
]);
