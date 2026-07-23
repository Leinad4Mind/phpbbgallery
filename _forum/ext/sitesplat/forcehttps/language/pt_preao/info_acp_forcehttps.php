<?php

/**
 * Force https extension for the phpBB Forum Software package.
 * @copyright (c) 2017 sitesplat.com <http://sitesplat.com>
 * @license Proprietary
 * @translation Leinad4Mind [Portuguese [pt_preao]] (2026)
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
	'FORCEHTTPS_NOTICE' => '<div class="phpinfo"><p>O teu fórum está agora correctamente configurado para funcionar em modo HTTPS. <br /><strong>Isto pressupõe que o certificado SSL e a configuração do servidor já tenham sido previamente configurados correctamente.</strong></p></div>',
	'SS_HELPER_NOTY'    => 'O SiteSplat BBcore não existe!<br />Transfere o <a href="http://sitesplat.com" target="_blank">BBcore</a> e copia a pasta BBcore para a pasta da tua extensão sitesplat.',
]);
