<?php

/**
 * @package Auto db Backup for phpBB.
 * @copyright (c) 2015 david63
 * @license GNU General Public License, version 2 (GPL-2.0)
 * @translation Leinad4Mind [Portuguese [pt]] (2026)
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

$lang = array_merge($lang, [
	'AUTO_DB_BACKUP_COPIES'                => 'Backups armazenados',
	'AUTO_DB_BACKUP_COPIES_EXPLAIN'        => 'O número de backups que serão armazenados no servidor.<br>0 significa desativado e todos os backups serão armazenados no servidor.',
	'AUTO_DB_BACKUP_ENABLE'                => 'Ativar backup automático da base de dados',
	'AUTO_DB_BACKUP_ENABLE_EXPLAIN'        => 'Ativar ou desativar os backups automáticos da base de dados',
	'AUTO_DB_BACKUP_FILETYPE'              => 'Tipo de ficheiro',
	'AUTO_DB_BACKUP_FILETYPE_EXPLAIN'      => 'Seleciona o tipo de ficheiro para os backups.',
	'AUTO_DB_BACKUP_FREQ'                  => 'Frequência de backup',
	'AUTO_DB_BACKUP_FREQ_EXPLAIN'          => 'Define a frequência de backup em horas.',
	'AUTO_DB_BACKUP_MAINTAIN_FREQ'         => 'Manter a frequência de tempo do backup',
	'AUTO_DB_BACKUP_MAINTAIN_FREQ_EXPLAIN' => 'Definir isto como <strong>"Sim"</strong> significa que o tempo da frequência de backup será mantido.<br>Por exemplo - se a hora for definida para as 23:15 e a frequência definida para 24 horas, o próximo backup será às 23:15 do dia seguinte. Se estiver definido como <strong>"Não"</strong>, o próximo backup será 24 horas após a execução do backup.',
	'AUTO_DB_BACKUP_OPTIMIZE'              => 'Otimizar a base de dados antes de efetuar o backup',
	'AUTO_DB_BACKUP_OPTIMIZE_EXPLAIN'      => 'Otimizar apenas as tabelas da base de dados não otimizadas antes de fazer o backup.',
	'AUTO_DB_BACKUP_SETTINGS'              => 'Configurações de backup automático da base de dados',
	'AUTO_DB_BACKUP_SETTINGS_CHANGED'      => 'As configurações de backup automático da base de dados foram alteradas.',
	'AUTO_DB_BACKUP_SETTINGS_EXPLAIN'      => 'Aqui podes definir as configurações padrão para os backups automáticos da base de dados. Dependendo da configuração do teu servidor, poderá ser possível comprimir a base de dados.<br>Todos os backups serão armazenados na pasta <samp>/store/</samp>. Podes restaurar um backup através do painel de <em>Restauro</em>.',
	'AUTO_DB_BACKUP_TIME'                  => 'Próxima hora de backup',
	'AUTO_DB_BACKUP_TIME_ERROR'            => 'A <strong>próxima hora de backup</strong> está incorreta. A hora tem que ser definida no futuro.',
	'AUTO_DB_BACKUP_TIME_EXPLAIN'          => 'A hora a que deve ser feito o próximo backup da base de dados.<br><strong>Nota:</strong> A data/hora especificada deve ser no futuro.',

	'CLICK_SELECT' => 'Clica na caixa de texto para selecionar a data/hora',

	'DATE_FORMAT_ERROR' => 'O formato da data/hora do próximo backup é inválido.',

	'INVALID_PHP_TIMEZONE'  => 'O fuso horário padrão no teu ficheiro php.ini é inválido.',
	'INVALID_USER_TIMEZONE' => 'Existe um problema com a tua configuração de fuso horário no UCP.',

	'NO_TIMEZONE_SET' => 'Não tens um fuso horário definido no teu UCP - por favor define-o antes de poderes continuar.',

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
	'NEXT_TEXT'   => 'Seguinte »',
	'PREV_TEXT'   => '« Anterior',
	'TIME_TEXT'   => 'Hora',

	'DAY_NAMES_MIN' => '["Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sáb"]',
	'MONTH_NAMES'   => '["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"]',
]);
