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
	'AUTO_DB_BACKUP_COPIES'                => 'Backups armazenados',
	'AUTO_DB_BACKUP_COPIES_EXPLAIN'        => 'O nÃºmero de backups que serÃ£o armazenados no servidor.<br>0 significa desativado e todos os backups serÃ£o armazenados no servidor.',
	'AUTO_DB_BACKUP_ENABLE'                => 'Habilitar backup automÃ¡tico do banco de dados',
	'AUTO_DB_BACKUP_ENABLE_EXPLAIN'        => 'Habilitar ou desabilitar os backups automÃ¡ticos do banco de dados',
	'AUTO_DB_BACKUP_FILETYPE'              => 'Tipo de arquivo',
	'AUTO_DB_BACKUP_FILETYPE_EXPLAIN'      => 'Selecione o tipo de arquivo para os backups.',
	'AUTO_DB_BACKUP_FREQ'                  => 'FrequÃªncia de backup',
	'AUTO_DB_BACKUP_FREQ_EXPLAIN'          => 'Defina a frequÃªncia de backup em horas.',
	'AUTO_DB_BACKUP_MAINTAIN_FREQ'         => 'Manter a frequÃªncia de tempo do backup',
	'AUTO_DB_BACKUP_MAINTAIN_FREQ_EXPLAIN' => 'Definir isto como <strong>"Sim"</strong> significa que o tempo da frequÃªncia de backup serÃ¡ mantido.<br>Por exemplo - se a hora for definida para as 23:15 e a frequÃªncia definida para 24 horas, o prÃ³ximo backup serÃ¡ Ã s 23:15 do dia seguinte. Se estiver definido como <strong>"NÃ£o"</strong>, o prÃ³ximo backup serÃ¡ 24 horas apÃ³s a execuÃ§Ã£o do backup.',
	'AUTO_DB_BACKUP_SETTINGS'              => 'ConfiguraÃ§Ãµes de backup automÃ¡tico do banco de dados',
	'AUTO_DB_BACKUP_SETTINGS_CHANGED'      => 'As configuraÃ§Ãµes de backup automÃ¡tico do banco de dados foram alteradas.',
	'AUTO_DB_BACKUP_SETTINGS_EXPLAIN'      => 'Configure backups lÃ³gicos automÃ¡ticos do banco de dados. Os backups sÃ£o armazenados em <samp>/store/</samp> e podem ser restaurados no painel de <em>RestauraÃ§Ã£o</em>.<br><strong>Nota de consistÃªncia:</strong> atividade durante um backup lÃ³gico pode incluir dados de momentos ligeiramente diferentes. Use snapshots nativos do banco de dados para recuperaÃ§Ã£o rigorosa em um ponto no tempo.',
	'AUTO_DB_BACKUP_TIME'                  => 'PrÃ³xima hora de backup',
	'AUTO_DB_BACKUP_TIME_ERROR'            => 'A <strong>prÃ³xima hora de backup</strong> estÃ¡ incorreta. A hora tem que ser definida no futuro.',
	'AUTO_DB_BACKUP_TIME_EXPLAIN'          => 'A hora a que deve ser feito o prÃ³ximo backup do banco de dados.<br><strong>Nota:</strong> A data/hora especificada deve ser no futuro.',

	'DATE_FORMAT_ERROR' => 'O formato da data/hora do prÃ³ximo backup Ã© invÃ¡lido.',
	'AUTO_DB_BACKUP_BOOLEAN_ERROR'  => 'Uma opÃ§Ã£o de ativaÃ§Ã£o/desativaÃ§Ã£o Ã© invÃ¡lida.',
	'AUTO_DB_BACKUP_COPIES_ERROR'   => 'O nÃºmero de backups armazenados deve estar entre 0 e 99.',
	'AUTO_DB_BACKUP_FILETYPE_ERROR' => 'O tipo de arquivo selecionado nÃ£o estÃ¡ disponÃ­vel.',
	'AUTO_DB_BACKUP_FREQ_ERROR'     => 'A frequÃªncia deve estar entre 1 e 350 horas.',
	'AUTO_DB_BACKUP_HELPER_MISSING'   => 'O auxiliar de backup do banco de dados do phpBB nÃ£o estÃ¡ disponÃ­vel.',
	'AUTO_DB_BACKUP_INVALID_FILENAME' => 'O nome de arquivo de backup gerado Ã© invÃ¡lido.',
	'AUTO_DB_BACKUP_INVALID_PATH'     => 'O caminho do backup Ã© invÃ¡lido ou estÃ¡ fora da pasta store.',
	'AUTO_DB_BACKUP_MANIFEST_FAILED'  => 'NÃ£o foi possÃ­vel salvar o manifesto de propriedade dos backups.',
	'AUTO_DB_BACKUP_NO_TABLES'        => 'Nenhuma tabela do phpBB foi encontrada para incluir no backup.',
	'AUTO_DB_BACKUP_DISK_SPACE'       => 'N&atilde;o h&aacute; espa&ccedil;o livre suficiente para criar um backup com seguran&ccedil;a.',
	'AUTO_DB_BACKUP_VERIFY_FAILED'    => 'O backup gerado falhou na verificaÃ§Ã£o de integridade.',

	'INVALID_USER_TIMEZONE' => 'Existe um problema com a sua configuraÃ§Ã£o de fuso horÃ¡rio no UCP.',

	'NO_TIMEZONE_SET' => 'NÃ£o tem um fuso horÃ¡rio definido no seu UCP - por favor defina-o antes de poder continuar.',

	'FILETYPE' => [
		'gzip'  => 'gzip',
		'bzip2' => 'bzip2',
		'text'  => 'texto',
	],

	'FILE_SIZE' => [
		1 => 'bytes',
		2 => 'KB',
		3 => 'MB',
		4 => 'GB',
		5 => 'TB',
	],
]);

// Date/time picker
$lang = array_merge($lang, [
	'HOUR_TEXT'   => 'Hora',
	'MINUTE_TEXT' => 'Minuto',
	'NEXT_TEXT'   => 'Seguinte Â»',
	'PREV_TEXT'   => 'Â« Anterior',
	'TIME_TEXT'   => 'Hora',

	'DAY_NAMES_MIN' => '["Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "SÃ¡b"]',
	'MONTH_NAMES'   => '["Janeiro", "Fevereiro", "MarÃ§o", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"]',
]);
