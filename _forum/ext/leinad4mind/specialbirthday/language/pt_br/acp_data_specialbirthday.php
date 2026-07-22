<?php

/**
 * @copyright (c) 2019-2022 Leinad4Mind
 * @license GNU General Public License, version 2 (GPL-2.0)
 * @translation Leinad4Mind [Brazilian Portuguese [pt_br]] (2026)
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
	'AGE'             => 'Idade',
	'ALL'             => 'Todos',
	'CLEAR_FILTER'    => 'Limpar filtro',
	'DATE_OF_BIRTH'   => 'Data de nascimento',
	'FILTER_BY'       => 'Filtrar Nome de usuário por',
	'FILTER_USERNAME' => 'Nome de usuário',
	'OTHER'           => 'Outros',
	'REG_AGE_SORT'    => 'Ordenar',
	'SORT_PROFILE'    => 'Data de Nascimento',
	'SORT_USERNAME'   => 'Nome de usuário',
	'SORT_AGE'        => 'Idade',
	'STATUS'          => 'Estado',
	'TOTAL_USERS'     => 'Contagem de usuários : <strong>%1$s</strong>',
	'VERSION'         => 'Versão',
	'START_CHARACTER' => 'A',
	'END_CHARACTER'   => 'Z',
]);
