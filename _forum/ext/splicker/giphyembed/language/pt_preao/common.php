<?php

/**
 * @package Splicker Giphy Embed for phpBB.
 * @copyright (c) 2021 SplickerSnap.com
 * @author Splicker
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 * @translation Leinad4Mind [Portuguese [pt_preao]] (2026)
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
	'ACP_GE_TITLE'          => 'Configurações Splicker Giphy',
	'ACP_GE_SETTINGS_TITLE' => 'Configurações do Giphy Embed',
	'ACP_GE'                => 'Giphy Embed',
	'ACP_GE_DISPLAY_TITLE'  => 'Configuração',
	'ACP_GE_TITLE_SUB'      => 'Ajustar definições',
	'ACP_GE_ENABLE'         => 'Ativar Giphy',
	'ACP_GE_SETTINGS_SAVED' => 'Configurações do Giphy Embed Guardadas.',
	'ACP_GE_ENABLE_TEXT'    => 'Mostra o painel Giphy na página de publicações.',
	'ACP_YES'               => 'Sim',
	'ACP_NO'                => 'Não',
	'ACP_GE_API'            => 'Chave API',
	'ACP_GE_API_TEXT'       => 'Introduza a sua chave API do Giphy',
	'ACP_GE_RATING'         => 'Classificação (Rating) Giphy',
	'ACP_GE_SCROLL'         => 'Ativar Rolagem (Scroll)',
	'ACP_GE_SCROLL_TEXT'    => 'Se ativado irá mostrar os gifs em tamanho real numa caixa rolável (com scroll).',
	'ACP_GE_RATING_TEXT'    => 'Escolha a classificação para mostrar gifs adequados para a idade/site.',
	'ACP_GE_AG_G'           => '(G) Seguro para Crianças',
	'ACP_GE_AG_PG'          => '(PG) Pode conter linguagem profana moderada',
	'ACP_GE_AG_PGT'         => '(PG-13) Pode conter linguagem profana intermédia',
	'ACP_GE_AG_R'           => '(R) Inclui imagens de cariz adulto',
	'GE_TAB_EXPLAIN'        => 'Pesquise gifs para adicionar à sua mensagem.',
	'GE_TAB_SEARCHBOX'      => 'Introduza o termo de pesquisa',
	'GE_TAB'                => 'Giphy Embed',
	'GE_BACK'               => 'Voltar',

]);
