<?php
/**
*
* topfive [Brazilian Portuguese]
*
* @package language Top Five
* @copyright (c) 2014 RMcGirr83
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
* @translation Leinad4Mind [Brazilian Portuguese [pt_br]] (2026)
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
	'TF_ACTIVE'     => 'Habilitado',
	'TF_TITLE'      => 'Configurações da Extensão Top Five',
	'TF_VERSION'    => 'Versão do Top Five',
	'TOPFIVE_MOD'   => 'Top Five',
	'TF_CONFIG'     => 'Configurações',
	'TF_SELECT'     => 'Top Five',
	'TF_SAVED'      => 'Alterações Salvas',
	'TF_HOWMANY'    => 'Quantos',
	'TF_HOWMANY_EXPLAIN'   => 'Quantos você gostaria de exibir... o mínimo exigido é 5, o máximo é 100',
	'TF_IGNORE_USERS'      => 'Ignorar Usuários Inativos',
	'TF_IGNORE_USERS_EXPLAIN'  => 'Vai excluir usuários inativos da exibição nos melhores autores e usuários mais recentes',
	'TF_IGNORE_FOUNDER'        => 'Ignorar Fundador(es)',
	'TF_IGNORE_FOUNDER_EXPLAIN'    => 'Vai excluir fundadores da exibição nos melhores autores e usuários mais recentes',
	'TF_LOCATION'   => 'Localização no fórum',
	'TF_LOCATION_EXPLAIN'  => 'Onde você gostaria que o mod fosse exibido na página inicial',
	'TF_SHOW_ADMINS_MODS'  => 'Incluir Administradores e Moderadores',
	'TF_SHOW_ADMINS_MODS_EXPLAIN'  => 'Vai exibir administradores e moderadores nos melhores autores',
	'TOO_SMALL_TOP_FIVE_HOW_MANY'  => 'O valor a exibir é muito pequeno.',
	'TOO_LARGE_TOP_FIVE_HOW_MANY'  => 'O valor a exibir é muito grande.',
	'TOP_OF_FORUM'  => 'Topo do Fórum',
	'BOTTOM_OF_FORUM'   => 'Rodapé do Fórum',

]);
