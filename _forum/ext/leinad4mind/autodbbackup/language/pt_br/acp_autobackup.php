<?php

/**
 * @package Auto db Backup for phpBB.
 * @copyright (c) 2015 david63
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
// ’ » “ ” …
//

$lang = array_merge($lang, [
	'AUTO_DB_BACKUP_COPIES'                => 'Backups armazenados',
	'AUTO_DB_BACKUP_COPIES_EXPLAIN'        => 'O número de backups que serão armazenados no servidor.<br>0 significa desativado e todos os backups serão armazenados no servidor.',
	'AUTO_DB_BACKUP_ENABLE'                => 'Habilitar backup automático do banco de dados',
	'AUTO_DB_BACKUP_ENABLE_EXPLAIN'        => 'Habilitar ou desabilitar os backups automáticos do banco de dados',
	'AUTO_DB_BACKUP_FILETYPE'              => 'Tipo de arquivo',
	'AUTO_DB_BACKUP_FILETYPE_EXPLAIN'      => 'Selecione o tipo de arquivo para os backups.',
	'AUTO_DB_BACKUP_FREQ'                  => 'Frequência de backup',
	'AUTO_DB_BACKUP_FREQ_EXPLAIN'          => 'Defina a frequência de backup em horas.',
	'AUTO_DB_BACKUP_MAINTAIN_FREQ'         => 'Manter a frequência de tempo do backup',
	'AUTO_DB_BACKUP_MAINTAIN_FREQ_EXPLAIN' => 'Definir isto como <strong>"Sim"</strong> significa que o tempo da frequência de backup será mantido.<br>Por exemplo - se a hora for definida para as 23:15 e a frequência definida para 24 horas, o próximo backup será às 23:15 do dia seguinte. Se estiver definido como <strong>"Não"</strong>, o próximo backup será 24 horas após a execução do backup.',
	'AUTO_DB_BACKUP_SETTINGS'              => 'Configurações de backup automático do banco de dados',
	'AUTO_DB_BACKUP_SETTINGS_CHANGED'      => 'As configurações de backup automático do banco de dados foram alteradas.',
	'AUTO_DB_BACKUP_SETTINGS_EXPLAIN'      => 'Configure backups lógicos automáticos do banco de dados. Os backups são armazenados em <samp>/store/</samp> e podem ser restaurados no painel de <em>Restauração</em>.<br><strong>Nota de consistência:</strong> atividade durante um backup lógico pode incluir dados de momentos ligeiramente diferentes. Use snapshots nativos do banco de dados para recuperação rigorosa em um ponto no tempo.',
	'AUTO_DB_BACKUP_TIME'                  => 'Próxima hora de backup',
	'AUTO_DB_BACKUP_TIME_ERROR'            => 'A <strong>próxima hora de backup</strong> está incorreta. A hora tem que ser definida no futuro.',
	'AUTO_DB_BACKUP_TIME_EXPLAIN'          => 'A hora a que deve ser feito o próximo backup do banco de dados.<br><strong>Nota:</strong> A data/hora especificada deve ser no futuro.',

	'DATE_FORMAT_ERROR' => 'O formato da data/hora do próximo backup é inválido.',
	'AUTO_DB_BACKUP_BOOLEAN_ERROR'  => 'Uma opção de ativação/desativação é inválida.',
	'AUTO_DB_BACKUP_COPIES_ERROR'   => 'O número de backups armazenados deve estar entre 0 e 99.',
	'AUTO_DB_BACKUP_FILETYPE_ERROR' => 'O tipo de arquivo selecionado não está disponível.',
	'AUTO_DB_BACKUP_FREQ_ERROR'     => 'A frequência deve estar entre 1 e 350 horas.',
	'AUTO_DB_BACKUP_HELPER_MISSING'   => 'O auxiliar de backup do banco de dados do phpBB não está disponível.',
	'AUTO_DB_BACKUP_INVALID_FILENAME' => 'O nome de arquivo de backup gerado é inválido.',
	'AUTO_DB_BACKUP_INVALID_PATH'     => 'O caminho do backup é inválido ou está fora da pasta store.',
	'AUTO_DB_BACKUP_MANIFEST_FAILED'  => 'Não foi possível salvar o manifesto de propriedade dos backups.',
	'AUTO_DB_BACKUP_NO_TABLES'        => 'Nenhuma tabela do phpBB foi encontrada para incluir no backup.',
	'AUTO_DB_BACKUP_VERIFY_FAILED'    => 'O backup gerado falhou na verificação de integridade.',

	'INVALID_USER_TIMEZONE' => 'Existe um problema com a sua configuração de fuso horário no UCP.',

	'NO_TIMEZONE_SET' => 'Não tem um fuso horário definido no seu UCP - por favor defina-o antes de poder continuar.',

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
