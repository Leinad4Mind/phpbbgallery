<?php

/**
 * @package Quick Title Edition Extension for phpBB.
 * @copyright (c) 2015 ABDev
 * @copyright (c) 2015 PastisD
 * @copyright (c) 2015 Geolim4 <http://geolim4.com>
 * @copyright (c) 2015 Zoddo <zoddo.ino@gmail.com>
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 * @translation Leinad4Mind [Portuguese [pt_preao]] (2026)
 */

// ignore
if (!defined('IN_PHPBB'))
{
	exit;
}

// init lang ary, if it doesn't !
if (empty($lang) || !is_array($lang))
{
	$lang = [];
}

$lang = array_merge($lang, [
	'QTE_CAN_USE_ATTR' => 'Pode usar o atributo %s',

	// select
	'QTE_ATTRIBUTES' => 'Atributos do tópico',
	'QTE_ATTRIBUTE'  => 'Atributo do tópico',

	'QTE_ATTRIBUTE_ADD'     => 'Selecciona um atributo de tópico',
	'QTE_ATTRIBUTE_REMOVE'  => 'Remover o atributo do tópico',
	'QTE_ATTRIBUTE_DESIRED' => 'Seleccionar o atributo desejado',
	'QTE_ATTRIBUTE_KEEP'    => 'Manter o atributo actual',

	// notifications
	'QTE_ATTRIBUTE_ADDED'   => 'Um atributo foi aplicado ao título do tópico',
	'QTE_ATTRIBUTE_UPDATED' => 'O atributo do tópico foi actualizado',
	'QTE_ATTRIBUTE_REMOVED' => 'O atributo de tópico foi removido',

	'QTE_TOPIC_ATTRIBUTE_ADDED'    => 'Um atributo foi aplicado ao tópico seleccionado',
	'QTE_TOPICS_ATTRIBUTE_ADDED'   => 'Um atributo foi aplicado aos tópicos seleccionados',
	'QTE_TOPIC_ATTRIBUTE_UPDATED'  => 'O atributo do tópico seleccionado foi actualizado',
	'QTE_TOPICS_ATTRIBUTE_UPDATED' => 'O atributo dos tópicos seleccionados foi actualizado',
	'QTE_TOPIC_ATTRIBUTE_REMOVED'  => 'O atributo do tópico seleccionado foi removido',
	'QTE_TOPICS_ATTRIBUTE_REMOVED' => 'O atributo dos tópicos seleccionados foi removido',

	// search
	'QTE_ATTRIBUTE_SELECT'         => 'Seleccionar um atributo de tópico',
	'QTE_ATTRIBUTE_SEARCH'         => 'Pesquisar atributos',
	'QTE_ATTRIBUTE_SEARCH_EXPLAIN' => 'Selecciona o atributo que desejas pesquisar',

	// sort
	'QTE_SORT' => 'Como atributo',
	'QTE_ALL'  => 'Todos',

	// mistake messages
	'QTE_ATTRIBUTE_UNSELECTED' => 'Deves seleccionar um atributo!',

	// placeholders
	'QTE_KEY_USERNAME' => '¦user¦',
	'QTE_KEY_DATE'     => '¦date¦',
]);

// topic attributes as keys
$lang = array_merge($lang, [
	'QTE_SOLVED'    => '[Resolvido por %mod% :: %date%]',
	'QTE_CANCELLED' => 'Cancelado',
]);
