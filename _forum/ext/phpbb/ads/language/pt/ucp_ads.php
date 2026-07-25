<?php

/**
 *
 * Advertisement management. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2017 phpBB Limited <https://www.phpbb.com>
 * @license GNU General Public License, version 2 (GPL-2.0)
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

	'PHPBB_ADS_PRIVACY_POLICY' => '
		<br><br>
		<h3>Publicidade</h3>
		O “%1$s” pode exibir publicidade fornecida por redes ou serviços de terceiros. Estes anúncios podem utilizar cookies, pixels de rastreio ou tecnologias semelhantes para recolher informações sobre a sua atividade de navegação neste site e, nalguns casos, noutros websites. Esta informação pode ser utilizada para apresentar anúncios relevantes, medir a eficácia de campanhas publicitárias e adaptar o conteúdo aos seus interesses.
		<br><br>
		Quaisquer dados recolhidos através desses serviços publicitários de terceiros estão sujeitos às políticas de privacidade e de cookies dos respetivos fornecedores. O “%1$s” não controla os cookies nem as práticas de recolha de dados desses terceiros. Recomendamos que consulte as políticas dos fornecedores de publicidade relevantes para mais informações sobre como os seus dados são processados.
	',
]);
