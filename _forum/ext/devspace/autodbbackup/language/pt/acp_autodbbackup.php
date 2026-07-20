<?php

/**
 * @copyright (c) 2022 devspace
 * @license GNU General Public License, version 2 (GPL-2.0)
 * @translation Leinad4Mind [Portuguese [pt]] (2026)
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
	'ADD_EXTENSIONS'                => 'Não esquecer que precisará de uma extensão para criar o backup',
	'AUTO_DB_BACKUP_AVAILABLE'      => 'O backup automático da base de dados não pode ser ativado - não existem extensões de armazenamento de backup instaladas/ativadas. %s',
	'AUTO_DB_BACKUP_ENABLE'         => 'Ativar backup automático da base de dados',
	'AUTO_DB_BACKUP_ENABLE_EXPLAIN' => 'Ao ativar o backup automático da base de dados não desativa a sua cópia de segurança regular.',
	'AUTO_DB_BACKUP_GC'             => 'Lixo do backup automático',
	'AUTO_DB_BACKUP_GC_EXPLAIN'     => 'O número de backups armazenados antes dos backups mais antigos serem eliminados.<br>Definir como 0 (zero) fará com que nunca sejam eliminados',
	'AUTO_DB_BACKUP_TIME'           => 'Hora do backup automático da base de dados',
	'AUTO_DB_BACKUP_TIME_EXPLAIN'   => 'O backup da base de dados não acontecerá à hora exata especificada, mas sim no próximo acesso à placa depois desta hora.',
	'AUTO_DB_BACKUP_TYPE'           => 'Localização de armazenamento do backup automático da base de dados',
	'AUTO_DB_BACKUP_TYPE_EXPLAIN'   => 'Se selecionar várias opções, apenas a primeira selecionada (na ordem em que aparecem abaixo) será executada.',
	'NO_STORAGE_AVAILABLE'          => '<strong>Infelizmente, não tem extensões de armazenamento instaladas ou ativadas</strong>',
]);
