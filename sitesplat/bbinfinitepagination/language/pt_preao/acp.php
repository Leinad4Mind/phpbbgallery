<?php

/**
 * @package BBinfinitepagination for phpBB.
 * @copyright (c) 2019 SiteSplat All rights reserved
 * @license Proprietary
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
	'BBINFINITEPAGINATION'            => 'BBinfinitepagination',
	'BBINFINITEPAGINATION_FX'         => 'Efeito da BBinfinitepagination',
	'BBINFINITEPAGINATION_VIEWTOPIC'  => 'Permitir que a BBinfinitepagination carregue mais publicações na leitura de tópicos (viewtopic)',
	'BBINFINITEPAGINATION_MEMBERLIST' => 'Permitir que a BBinfinitepagination carregue mais membros na lista de membros (memberlist)',
	'BBINFINITEPAGINATION_VIEWONLINE' => 'Permitir que a BBinfinitepagination carregue mais utilizadores nos membros activos online (viewonline)',
	'BBINFINITEPAGINATION_SEARCH'     => 'Permitir que a BBinfinitepagination carregue mais publicações/tópicos nos resultados de pesquisa (search)',
	'BBINFINITEPAGINATION_VIEWFORUM'  => 'Permitir que a BBinfinitepagination carregue mais tópicos nos subfóruns (viewforum)',
]);
