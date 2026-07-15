<?php
/**
*
* @package phpBB Extension - LMDI My Topics
* @copyright (c) 2015-2017 Pierre Duhem - LMDI
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
* Brazilian Portuguese translation by eunaumtenhoid (c) 2019 [ver 1.0.12] (https://github.com/phpBBTraducoes)
*/

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

// Some characters you may want to copy&paste:
// ’ » “ ” …

$lang = array_merge($lang, array(
	'ACP_MYTOP_TITLE'		=> 'Seus tópicos',
	'ACP_MYTOP_CONFIG'		=> 'Configurações da extensão',
	'ACP_MYTOP_UPDATED'		=> 'A configuração foi atualizada com sucesso.',
	'ACP_MYTOP_TOP'		=> 'Topo',
	'ACP_MYTOP_BOTTOM'		=> 'Inferior',
	'MY_TOPICS'			=> 'Seus tópicos',
	'MYTOP_POS'			=> '“Seus tópicos” como primeiro item',
	'MYTOP_POS_EXPLAIN'		=> 'Selecione "Topo" para colocar o novo item de menu no início do menu suspenso "Links rápidos". Selecione "Inferior" para colocá-lo no final.',
	'MYPOST_NO'			=> 'Ocultar o item “Seus Posts”',
	'MYPOST_NO_EXPLAIN'		=> 'Você pode querer ocultar o item “Seus Posts” no menu “Links Rápidos”, já que ambos os itens do menu são realmente similares.',
));
