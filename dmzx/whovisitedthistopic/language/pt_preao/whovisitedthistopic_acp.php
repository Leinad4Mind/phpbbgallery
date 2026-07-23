<?php

/**
 * @package phpBB Extension - Who Visited This Topic for phpBB.
 * @copyright (c) 2016 dmzx - https://www.dmzx-web.net
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
// ’ « » “ ” …
//

$lang = array_merge($lang, [
	'WHOVISITEDTHISTOPIC_TOPIC_SETTINGS'              => 'Activar "Quem Visitou Este Tópico" nos tópicos',
	'WHOVISITEDTHISTOPIC_TOPIC_SETTINGS_EXPLAIN'      => 'Isto irá mostrar "Quem Visitou Este Tópico" na visualização dos tópicos.',
	'WHOVISITEDTHISTOPIC_COUNT_SETTINGS'              => 'Activar o contador "Quem Visitou Este Tópico" nos tópicos',
	'WHOVISITEDTHISTOPIC_COUNT_SETTINGS_EXPLAIN'      => 'Isto irá mostrar o contador "Quem Visitou Este Tópico" nos tópicos.',
	'WHOVISITEDTHISTOPIC_SHOW_AVATAR'                 => 'Activar avatares "Quem Visitou Este Tópico" nos tópicos',
	'WHOVISITEDTHISTOPIC_SHOW_AVATAR_EXPLAIN'         => 'Isto irá mostrar os avatares "Quem Visitou Este Tópico" nos tópicos.',
	'WHOVISITEDTHISTOPIC_MEMBERPAGE_SETTINGS'         => 'Activar "Quem Visitou Este Tópico" no perfil',
	'WHOVISITEDTHISTOPIC_MEMBERPAGE_SETTINGS_EXPLAIN' => 'Isto irá mostrar "Quem Visitou Este Tópico" no perfil.',
	'WHOVISITEDTHISTOPIC_SETTING'                     => 'Definir o valor para "Quem Visitou Este Tópico" nos tópicos',
	'WHOVISITEDTHISTOPIC_SETTING_EXPLAIN'             => 'Valor ajustável entre 2 e 255 membros. <em>Por predefinição é 10.</em>',
	'WHOVISITEDTHISTOPIC_VISIT_SETTING'               => 'Definir o valor para "Últimos Tópicos Visitados" no perfil',
	'WHOVISITEDTHISTOPIC_VISIT_SETTING_EXPLAIN'       => 'Valor ajustável entre 2 e 255. <em>Por predefinição é 10.</em>',
	'WHOVISITEDTHISTOPIC_DISABLED_TOPIC'              => 'Desactivado - define "Activar Quem Visitou Este Tópico nos tópicos" para Sim para poderes inserir um valor',
	'WHOVISITEDTHISTOPIC_DISABLED_MEMBERPAGE'         => 'Desactivado - define "Activar Quem Visitou Este Tópico no perfil" para Sim para poderes inserir um valor',
	'WHOVISITEDTHISTOPIC_SETTINGS_EXPLAIN'            => 'Vai ao separador <em><strong>Quem Visitou Este Tópico</strong></em> na secção de permissões de grupo para ajustar as permissões de cada grupo.',
	'WHOVISITEDTHISTOPIC_MEMBERS'                     => 'Excluir membros na visualização do tópico',
	'WHOVISITEDTHISTOPIC_MEMBERS_EXPLAIN'             => 'Aqui podes gerir os utilizadores que queres excluir (não os ver) ou removê-los da lista de exclusão.<br><strong>Nota:</strong> Cada utilizador numa linha nova.',
	'WHOVISITEDTHISTOPIC_MEMBERS_PROFILE'             => 'Excluir membros na visualização do perfil',
	'WHOVISITEDTHISTOPIC_MEMBERS_PROFILE_EXPLAIN'     => 'Aqui podes gerir os utilizadores que queres excluir (não os ver) ou removê-los da lista de exclusão.<br><strong>Nota:</strong> Cada utilizador numa linha nova.',
]);
