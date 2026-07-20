<?php

/**
 * Force https extension for the phpBB Forum Software package.
 * @copyright (c) 2017 sitesplat.com <http://sitesplat.com>
 * @license Proprietary
 * @translation Leinad4Mind [Portuguese [pt]] (2026)
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
	'FORCEHTTPS_NOTICE' => '<div class="phpinfo"><p>O seu fórum encontra-se a partir de agora corretamente configurado para o uso restrito sendo processado ativamente debaixo do modo base encriptado pelo HTTPS. <br /><strong>Para que isto ocorra, parte-se naturalmente do pressuposto e é claro de exigir que você tem um certificado de origem num SSL válido e que a mesma configuração do seu servidor já o havia ativado prévia e corretamente.</strong></p></div>',
	'SS_HELPER_NOTY'    => 'O SiteSplat BBcore não existe!<br />Faça o download do <a href="http://sitesplat.com" target="_blank">BBcore</a> e copie a pasta BBcore para a pasta da sua extensão sitesplat.',
]);
