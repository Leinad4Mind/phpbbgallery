<?php

/**
 * @package PM Monitor Extension for phpBB.
 * @copyright (c) 2015 david63
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 * @translation Leinad4Mind [Portuguese [pt_preao]] (2026)
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
	'AUTHOR_IP'      => 'IP do Autor',
	'CONFIRM_DELETE' => 'Confirmar eliminação',
	'DELETE_PMS'     => 'Eliminar MPs',
	'IS_GROUP'       => 'G',
	'MSG_COUNT'      => 'Contagem de mensagens',
	'NO_PM_DATA'     => 'Não existem dados de MP para apresentar.',
	'NO_PM_SELECTED' => 'Nenhuma MP seleccionada',

	'PM_BOX'                  => 'Caixa de MP',
	'PM_DELETED'              => 'Eliminadas',
	'PM_FORWARDED'            => 'Reencaminhadas',
	'PM_HOLDBOX'              => 'Retidas',
	'PM_INBOX'                => 'Caixa de entrada',
	'PM_MARKED'               => 'Marcadas',
	'PM_MONITOR_READ'         => 'Lista de mensagens privadas',
	'PM_MONITOR_READ_EXPLAIN' => 'Aqui está uma lista de todas as mensagens privadas do teu fórum.',
	'PM_NEW'                  => 'Novas',
	'PM_NOBOX'                => 'Sem caixa',
	'PM_OUTBOX'               => 'Caixa de saída',
	'PM_REPLIED'              => 'Respondidas',
	'PM_SAVED'                => 'Guardadas',
	'PM_SENTBOX'              => 'Enviadas',
	'PM_UNREAD'               => 'Não lidas',

	'SORT_BCC'    => 'BCC',
	'SORT_FROM'   => 'De',
	'SORT_PM_BOX' => 'Caixa de MP',
	'SORT_TO'     => 'Para',

	'VERSION' => 'Versão',
]);
