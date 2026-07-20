<?php

/**
 * @package cBB QuickMod for phpBB.
 * [English [En]]
 * @version 1.1.6 01/11/2024
 * @copyright (c) 2024 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 * @translation Leinad4Mind [Brazilian Portuguese [pt_br]] (2026)
 */

// DO NOT CHANGE
if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = [];
}

$lang = array_merge($lang, [
	'APPROVE_TOPIC'       => 'Aprovar',
	'CHANGE_ICON'         => 'Mudar ícone',
	'CHANGE_ICON_TOPIC'   => 'Mudar ícone',
	'CHANGE_POSTER_TOPIC' => 'Mudar autor',
	'CHANGE_TIME_TOPIC'   => 'Mudar data de publicação',
	'DISAPPROVE_TOPIC'    => 'Desaprovar',

	'CONFIRM_CHANGE_TOPIC'   => 'Tem a certeza de que queres modificar o tópico selecionado?',
	'CONFIRM_CHANGE_TOPICS'  => 'Tem a certeza de que queres modificar os tópicos selecionados?',
	'CONFIRM_DELETE_TOPIC'   => 'Tem a certeza de que queres excluir o tópico selecionado?',
	'CONFIRM_DELETE_TOPICS'  => 'Tem a certeza de que queres excluir os tópicos selecionados?',
	'CONFIRM_LOCK_TOPIC'     => 'Tem a certeza de que queres trancar o tópico selecionado?',
	'CONFIRM_LOCK_TOPICS'    => 'Tem a certeza de que queres trancar os tópicos selecionados?',
	'CONFIRM_RENAME_TOPIC'   => 'Tem a certeza de que queres renomear o tópico selecionado?',
	'CONFIRM_RENAME_TOPICS'  => 'Tem a certeza de que queres renomear os tópicos selecionados?',
	'CONFIRM_RESTORE_TOPIC'  => 'Tem a certeza de que queres restaurar o tópico selecionado?',
	'CONFIRM_RESTORE_TOPICS' => 'Tem a certeza de que queres restaurar os tópicos selecionados?',
	'CONFIRM_UNLOCK_TOPIC'   => 'Tem a certeza de que queres destrancar o tópico selecionado?',
	'CONFIRM_UNLOCK_TOPICS'  => 'Tem a certeza de que queres destrancar os tópicos selecionados?',

	'DELETE_TOPIC'             => 'Excluir',
	'DELETE_PERMANENTLY_TOPIC' => 'Excluir permanentemente',
	'FORK_TOPIC'               => 'Copiar',
	'MAKE_ANNOUNCE_TOPIC'      => 'Mudar para Anúncio',
	'MAKE_GLOBAL_TOPIC'        => 'Mudar para Global',
	'MAKE_NORMAL_TOPIC'        => 'Mudar para Normal',
	'MAKE_STICKY_TOPIC'        => 'Mudar para Importante',

	'MARK_ANNOUNCE'  => 'Marcar Anúncios',
	'MARK_BY_STATUS' => 'Marcar por estado',
	'MARK_BY_TYPE'   => 'Marcar por tipo',
	'MARK_GENERAL'   => 'Geral',
	'MARK_GLOBAL'    => 'Marcar tópicos globais',
	'MARK_LOCKED'    => 'Marcar tópicos trancados',
	'MARK_MOVED'     => 'Marcar tópicos movidos',
	'MARK_NORMAL'    => 'Marcar tópicos normais',
	'MARK_STICKY'    => 'Marcar tópicos importantes',
	'MARK_TOPICS'    => 'Marcar tópicos',
	'MARK_UNLOCKED'  => 'Marcar tópicos destrancados',

	'MOVE_TOPIC'        => 'Mover',
	'NO_TOPIC_SELECTED' => 'Nenhum tópico selecionado',
	'OPTIONS_APPROVE'   => 'Ações de aprovação',
	'OPTIONS_LOCK'      => 'Ações de trancamento',
	'OPTIONS_REMOVE'    => 'Ações de remoção',
	'OPTIONS_TOOLS'     => 'Ferramentas',
	'RENAME_TOPIC'      => 'Renomear',
	'RESTORE_TOPIC'     => 'Restaurar',
	'RESYNC_TOPIC'      => 'Sincronizar',
	'TOPIC_TYPE'        => 'Tipo de tópico',
	'UNLOCK_TOPIC'      => 'Destrancar',

	'ICON'          => 'Ícone',
	'NOTHING'       => 'Não houve alterações',
	'SELECT_ACTION' => 'Selecionar ação',
	'WITH_SELECTED' => 'Com os selecionados',

	'AUTHOR_CHANGE_SUCCESS' => 'O autor dos tópicos foi alterado corretamente.',
	'ICON_CHANGE_SUCCESS'   => 'O ícone foi alterado corretamente.',
	'TIME_CHANGE_SUCCESS'   => 'A data foi alterada corretamente.',
	'TOPIC_RENAMED_SUCCESS' => 'O tópico foi renomeado corretamente.',

	'CORE_INSTALL_ERROR' => 'Não carregaste todos os arquivos do pacote de instalação ou está a tentar instalar um pacote antigo.<br />
		Por favor, certifica-te de que carregas todos os arquivos (incluindo a pasta <em>core</em>) e usas um pacote descarregado do site oficial.',
]);
