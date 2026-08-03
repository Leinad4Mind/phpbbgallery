<?php

/**
 * @package User Defaults Extension for phpBB.
 * @copyright (c) 2016 david63
 * @copyright (c) 2022 devspace
 * @copyright (c) 2026 Leinad4Mind
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

/**
 * DEVELOPERS PLEASE NOTE
 *
 * All language files should use UTF-8 as their encoding and the files must not contain a BOM.
 *
 * Placeholders can now contain order information, e.g. instead of
 * 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
 * translators to re-order the output of data while ensuring it remains correct
 *
 * You do not need this where single placeholders are used, e.g. 'Message %d' is fine
 * equally where a string contains only two placeholders which are used to wrap text
 * in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
 *
 * Some characters you may want to copy&paste:
 * ’ » “ ” …
 *
 */

$lang = array_merge($lang, [
	'DEFAULT_ALL_POSTS'    => '<strong>Padrão = Todas as mensagens</strong>',
	'DEFAULT_ALL_TOPICS'   => '<strong>Padrão = Todos os tópicos</strong>',
	'DEFAULT_ASC'          => '<strong>Padrão = Ascendente</strong>',
	'DEFAULT_DATE_FORMAT'  => '<strong>Padrão = %s</strong>',
	'DEFAULT_DESC'         => '<strong>Padrão = Descendente</strong>',
	'DEFAULT_EMAIL'        => '<strong>Padrão = E-mail</strong>',
	'DEFAULT_NO'           => '<strong>Padrão = Não</strong>',
	'DEFAULT_NOTIFICATION' => '<strong>Padrão = Notificação</strong>',
	'DEFAULT_POST_TIME'    => '<strong>Padrão = Hora da mensagem</strong>',
	'DEFAULT_YES'          => '<strong>Padrão = Sim</strong>',
	'DISPLAY_SETTINGS'     => 'Opções de apresentação',
	'DISPLAY_ONLINE_STATUS' => 'Mostrar estado online',

	'EMAIL' => 'E-mail',

	'GLOBAL_SETTINGS' => 'Configurações globais',

	'NOTIFICATION' => 'Notificação',

	'POSTING_SETTINGS' => 'Padrões de publicação',
	'POPUP_ON_PM' => 'Abrir uma janela para novas mensagens privadas',

	'SYNC_USERS' => 'Sincronizar utilizadores existentes',
	'SYNC_USERS_EXPLAIN' => 'Aplicar estas predefinições aos utilizadores normais e fundadores já existentes.',
	'SYNC_USERS_WARNING' => 'Esta operação altera as preferências e subscrições de notificações dos utilizadores existentes. Não pode ser anulada automaticamente.',
	'SYNC_USERS_CONFIRM' => 'Compreendo que as preferências dos utilizadores existentes serão alteradas.',
	'SYNC_USERS_CONFIRM_REQUIRED' => 'Tem de confirmar a sincronização antes de a iniciar.',
	'SYNC_USERS_RUNNING' => 'A sincronizar utilizadores...',
	'SYNC_USERS_COMPLETE' => 'Sincronização concluída',
	'SYNC_USERS_BATCH_COMPLETE' => 'Foram sincronizados %1$d de %2$d utilizadores. Sem JavaScript, utilize novamente o botão para continuar.',

	'USER_DEFAULTS_EXPLAIN' => 'Define aqui os valores que deseja como valores padrão para <strong>novos</strong> utilizadores.<br>Quaisquer alterações feitas através deste formulário <strong>não</strong> afetarão utilizadores já existentes.',
]);
