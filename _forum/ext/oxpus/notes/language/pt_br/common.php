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
	'SLIDE_NOTES'      => 'Abrir notas como lista de títulos, exibir ao clicar no título',
	'FILTER_NOTES'     => '<strong>Modo Filtrado</strong><br />Pressione o botão de pesquisa novamente ou altere o método de ordenação para exibir todas as notas.',
	'NOTES_MEM'        => 'Adicionar lembrete!',
	'NOTES_MEM_ENABLE' => 'Sim, me lembre!',
	'NOTES_MEM_TIME'   => 'Definir data e hora',
	'NOTES_MEMTEXT'    => '<strong>Você inseriu notas com lembretes.</strong><br />%sClique aqui para listar essas notas.%s<br />(Clicar removerá o lembrete)',
	'NO_NOTES'         => 'Você não tem nenhuma nota no momento',

	'NOTES_DISCLAIMER'       => '**As notas que você vê aqui só podem ser vistas por você, e isso inclui moderadores e administradores. Se tiver alguma dúvida ou preocupação, entre em contato com um Administrador do Fórum.',
	'NOTES_DISCLAIMER_POPUP' => '**As notas que você vê aqui só podem ser vistas por você, e isso inclui moderadores e administradores.',

	'NOTES_CONFIG_SUCCESSFULL' => 'As configurações das notas foram salvas com sucesso.',
	'NOTES_DELETE_CONFIRM'     => 'Tem certeza de que deseja apagar esta nota?',
	'NOTES_LOG_CONFIG'         => 'Alterar número de notas por usuário',
]);
