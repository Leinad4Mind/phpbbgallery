<?php

/**
 * @package Auto db Backup for phpBB.
 * @copyright (c) 2015 david63
 * @copyright (c) 2026 Leinad4Mind
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
// â€™ Â» â€œ â€ â€¦
//

$lang = array_merge($lang, [
	'ACP_AUTO_DB_BACKUP'          => 'Backup AutomÃ¡tico do Banco de Dados',
	'ACP_AUTO_DB_BACKUP_SETTINGS' => 'ConfiguraÃ§Ãµes de backup automÃ¡tico',

	'LOG_AUTO_DB_BACKUP'          => '<strong>Backup automÃ¡tico do banco de dados concluÃ­do<br>Â»</strong>%1$s (%2$s)',
	'LOG_AUTO_DB_BACKUP_EXPORT_FAILED' => '<strong>Falha ao exportar o backup automÃ¡tico do banco de dados</strong><br>Â» %s',
	'LOG_AUTO_DB_BACKUP_FAILED'        => '<strong>Falha no backup automÃ¡tico do banco de dados</strong><br>Â» %s',
	'LOG_AUTO_DB_BACKUP_PRUNE_FAILED'  => '<strong>NÃ£o foi possÃ­vel remover backups automÃ¡ticos antigos</strong><br>Â» %s',
	'LOG_AUTO_DB_BACKUP_SETTINGS' => '<strong>ConfiguraÃ§Ãµes do Backup AutomÃ¡tico do Banco de Dados alteradas</strong>',
]);
