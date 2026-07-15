<?php

/**
*
* @package phpBB Extension - Personal Notes
* @copyright (c) 2014 OXPUS - www.oxpus.net
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
*
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
	'ACP_NOTES'				=> 'Configurar notas',
	'ACP_NOTES_SETTINGS'	=> 'Número máximo de notas por utilizador',
	'UCP_NOTES'				=> 'Notas Pessoais',
	'UCP_NOTES_CONFIG'		=> 'Configurações',

	'NOTES'				=> 'Notas Pessoais',
	'NEW_NOTE'			=> 'Nova Nota',
	'POST_NEW_NOTE'		=> 'Colocar uma nova nota',
	'POPUP_NOTES'		=> 'Mostrar Notas Pessoais em Popup',
	'FILTER_NOTES'		=> '<strong>Modo Filtragem</strong><br />Pressiona o botão de pesquisa novamente ou altere o método de ordenação para exibir todas as notas.',
	'NOTES_MEM'			=> 'Lembrete',
	'NOTES_MEM_ENABLE'	=> 'Sim, relembra-me!',
	'NOTES_MEM_TIME'	=> 'Tempo do Lembrete',
	'NOTES_MEMTEXT'		=> '<strong>Introduziste notas com lembrete.</strong><br />%sClique aqui para ver essas notas.%s<br />(Ao clicar irá remover o lembrete)',
	'NO_NOTES'			=> 'De momento não tens nenhuma nota',

	'NOTES_DISCLAIMER'			=> '**As notas aqui visíveis apenas poderão ser vistas por ti, nenhum administrador ou moderador têm acesso. Caso tenhas alguma dúvida ou preocupação, por favor, contacta um Administrador.',
	'NOTES_DISCLAIMER_POPUP'	=> '**As notas aqui visíveis apenas poderão ser vistas por ti, nenhum administrador ou moderador têm acesso.',

	'NOTES_CONFIG_SUCCESSFULL'	=> 'As configurações das notas foram guardadas com sucesso.<br /><br />%sClique aqui para regressar à configuração%s',
	'NOTES_DELETE_CONFIRM'		=> 'Tens a certeza que desejas apagar esta nota?',
	'NOTES_LOG_CONFIG'			=> 'Alterar número de notas por utilizador',
]);
