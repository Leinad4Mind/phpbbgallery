<?php

/**
 * @package phpBB Extension - LMDI My Topics for phpBB.
 * @copyright (c) 2015-2017 Pierre Duhem - LMDI
 * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
 * @translation Leinad4Mind [Portuguese [pt]] (2026)
 */

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = [];
}

// Some characters you may want to copy&paste:
// ’ » “ ” …

$lang = array_merge($lang, [
	'ACP_MYTOP_TITLE'   => 'Os Meus Tópicos',
	'ACP_MYTOP_CONFIG'  => 'Configurações da Extensão',
	'ACP_MYTOP_UPDATED' => 'A configuração foi atualizada com sucesso.',
	'ACP_MYTOP_TOP'     => 'Topo',
	'ACP_MYTOP_BOTTOM'  => 'Inferior',
	'MY_TOPICS'         => 'Os Meus Tópicos',
	'MYTOP_POS'         => '“Os Meus Tópicos” como primeiro item',
	'MYTOP_POS_EXPLAIN' => 'Seleciona "Topo" para colocar o novo item de menu no início do menu suspenso "Links rápidos". Seleciona "Inferior" para colocá-lo no final.',
	'MYPOST_NO'         => 'Ocultar o item “As Minhas Mensagens”',
	'MYPOST_NO_EXPLAIN' => 'Podes querer ocultar o item “As Minhas Mensagens” no menu “Links Rápidos”, já que ambos os itens do menu são realmente similares.',
]);
