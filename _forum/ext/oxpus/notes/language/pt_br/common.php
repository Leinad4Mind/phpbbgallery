<?php

/**
 * @package phpBB Extension - Personal Notes for phpBB.
 * @copyright (c) 2014 OXPUS - www.oxpus.net
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 * @translation Leinad4Mind [Brazilian Portuguese [pt_br]] (2026)
 */

/*
* [ english ] language file
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

$lang = array_merge($lang, [
	'ACP_NOTES'          => 'Configurar Notas',
	'ACP_NOTES_SETTINGS' => 'Número máximo de notas por usuário',
	'UCP_NOTES'          => 'Notas',
	'UCP_NOTES_CONFIG'   => 'Configurações',

	'NOTES'            => 'Notas',
	'NEW_NOTE'         => 'Nova nota',
	'POST_NEW_NOTE'    => 'Adicionar nova nota',
	'POPUP_NOTES'      => 'Exibir Notas Pessoais como Popup',
	'SLIDE_NOTES'      => 'Abrir notas com lista de títulos, exibir ao clicar no título',
	'FILTER_NOTES'     => '<strong>Modo Filtrado</strong><br />Pressiona o botão de pesquisa novamente ou altera a ordenação para mostrar todas as notas.',
	'NOTES_MEM'        => 'Adicionar lembrete!',
	'NOTES_MEM_ENABLE' => 'Sim, lembra-me!',
	'NOTES_MEM_TIME'   => 'Colocar data e hora',
	'NOTES_MEMTEXT'    => '<strong>Introduziste notas com lembretes.</strong><br />%sClica aqui para listas essas notas.%s<br />(Clicar irá remover o lembrete)',
	'NO_NOTES'         => 'Não tem quaisquer notas',

	'NOTES_DISCLAIMER'       => '**As notas que aqui vês só podem ser vistas por ti, e isso inclui moderadores e administradores. Se tiveres alguma dúvida ou preocupações, por favor, contacta a Administração.',
	'NOTES_DISCLAIMER_POPUP' => '**As notas que aqui vês só podem ser vistas por ti, e isso inclui moderadores e administradores.',

	'NOTES_CONFIG_SUCCESSFULL' => 'As configurações das notas foram guardadas com sucesso.',
	'NOTES_DELETE_CONFIRM'     => 'Tem a certeza que desejas apagar esta nota?',
	'NOTES_LOG_CONFIG'         => 'Alterar número de notas por usuário',
]);
