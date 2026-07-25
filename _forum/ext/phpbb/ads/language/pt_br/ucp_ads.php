<?php

/**
 *
 * Advertisement management. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2017 phpBB Limited <https://www.phpbb.com>
 * @license GNU General Public License, version 2 (GPL-2.0)
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
		O “%1$s” pode exibir publicidade fornecida por redes ou serviços de terceiros. Esses anúncios podem usar cookies, pixels de rastreamento ou tecnologias semelhantes para coletar informações sobre suas atividades de navegação neste site e, em alguns casos, em outros sites. Essas informações podem ser usadas para exibir anúncios relevantes, medir a eficácia de campanhas publicitárias e personalizar o conteúdo de acordo com seus interesses.
		<br><br>
		Quaisquer dados coletados por meio desses serviços de publicidade de terceiros estão sujeitos às políticas de privacidade e cookies dos respectivos provedores. O “%1$s” não controla os cookies nem as práticas de coleta de dados desses terceiros. Recomendamos que você consulte as políticas dos provedores de publicidade relevantes para mais detalhes sobre como suas informações são processadas.
	',
]);
