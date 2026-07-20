<?php

/**
 * @copyright (c) 2024
 * @license GNU General Public License, version 2 (GPL-2.0)
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
$lang = array_merge($lang, [
	'AD_NAME'       => 'Nome',
	'AD_START_DATE' => 'Data de Início',
	'AD_END_DATE'   => 'Data de Fim',
	'AD_VIEWS'      => 'Visualizações',
	'AD_CLICKS'     => 'Cliques',
	'AD_STATUS'     => 'Estado',
	'EXPIRED'       => 'Expirado',
	'ACTIVE_ADS'    => 'Anúncios ativos',
	'EXPIRED_ADS'   => 'Anúncios expirados',
	'NO_ADS'        => '<strong>Não tem nenhum anúncio a ser exibido neste fórum.</strong>',
]);
