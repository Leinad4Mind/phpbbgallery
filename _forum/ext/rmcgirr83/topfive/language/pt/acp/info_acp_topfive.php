<?php
/**
*
* topfive [Portuguese]
*
* @package language Top Five
* @copyright (c) 2014 RMcGirr83
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
* @translation Leinad4Mind [Portuguese [pt]] (2026)
*
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
	// ACP
	'TF_ACP'        => 'Extensão Top Five',
	'TF_ACTIVE'     => 'Ativado',
	'TF_TITLE'      => 'Configurações da Extensão Top Five',
	'TF_VERSION'    => 'Versão do Top Five',
	'TOPFIVE_MOD'   => 'Top Five',
	'TF_CONFIG'     => 'Configurações',
	'TF_SELECT'     => 'Top Five',
	'TF_SAVED'      => 'Alterações Guardadas',
	'TF_HOWMANY'    => 'Quantos',
	'TF_HOWMANY_EXPLAIN'   => 'Quantos gostarias de mostrar... o mínimo exigido é 5, o máximo é 100',
	'TF_IGNORE_USERS'      => 'Ignorar Utilizadores Inativos',
	'TF_IGNORE_USERS_EXPLAIN'  => 'Irá excluir utilizadores inativos da exibição nos melhores autores e utilizadores mais recentes',
	'TF_IGNORE_FOUNDER'        => 'Ignorar Fundador(es)',
	'TF_IGNORE_FOUNDER_EXPLAIN'    => 'Irá excluir fundadores da exibição nos melhores autores e utilizadores mais recentes',
	'TF_LOCATION'   => 'Localização no fórum',
	'TF_LOCATION_EXPLAIN'  => 'Onde gostarias que o mod fosse exibido na página inicial',
	'TF_SHOW_ADMINS_MODS'  => 'Incluir Administradores e Moderadores',
	'TF_SHOW_ADMINS_MODS_EXPLAIN'  => 'Irá mostrar administradores e moderadores nos melhores autores',
	'TOO_SMALL_TOP_FIVE_HOW_MANY'  => 'O valor a exibir é demasiado pequeno.',
	'TOO_LARGE_TOP_FIVE_HOW_MANY'  => 'O valor a exibir é demasiado grande.',
	'TOP_OF_FORUM'  => 'Topo do Fórum',
	'BOTTOM_OF_FORUM'   => 'Fundo do Fórum',

]);
