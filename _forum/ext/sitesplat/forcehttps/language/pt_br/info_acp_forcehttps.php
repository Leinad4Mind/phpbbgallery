<?php

/**
 * Force https extension for the phpBB Forum Software package.
 * @copyright (c) 2017 sitesplat.com <http://sitesplat.com>
 * @license Proprietary
 * @translation Leinad4Mind [Brazilian Portuguese [pt_br]] (2026)
 */

/**
* @ignore
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
	'FORCEHTTPS_NOTICE' => '<div class="phpinfo"><p>O seu fórum está agora corretamente configurado para funcionar no modo HTTPS. <br /><strong>Isso pressupõe que o certificado SSL e a configuração do servidor já tenham sido configurados corretamente com antecedência.</strong></p></div>',
	'SS_HELPER_NOTY'    => 'O SiteSplat BBcore não existe!<br />Faça o download do <a href="http://sitesplat.com" target="_blank">BBcore</a> e copie a pasta BBcore para a pasta da sua extensão sitesplat.',
]);
