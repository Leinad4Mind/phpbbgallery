<?php

/**
 * @copyright (c) 2019-2022 Leinad4Mind
 * @license GNU General Public License, version 2 (GPL-2.0)
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
	'AGE'             => 'Idade',
	'ALL'             => 'Todos',
	'CLEAR_FILTER'    => 'Limpar filtro',
	'DATE_OF_BIRTH'   => 'Data de nascimento',
	'FILTER_BY'       => 'Filtrar Nome de utilizador por',
	'FILTER_USERNAME' => 'Nome de utilizador',
	'OTHER'           => 'Outros',
	'REG_AGE_SORT'    => 'Ordenar',
	'SORT_PROFILE'    => 'Data de Nascimento',
	'SORT_USERNAME'   => 'Nome de utilizador',
	'SORT_AGE'        => 'Idade',
	'STATUS'          => 'Estado',
	'TOTAL_USERS'     => 'Contagem de utilizadores : <strong>%1$s</strong>',
	'VERSION'         => 'Versão',
	'START_CHARACTER' => 'A',
	'END_CHARACTER'   => 'Z',
]);
