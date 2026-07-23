<?php

/**
 * @package PMnotifications for phpBB.
 * @copyright (c) 2016 SiteSplat All rights reserved
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
	'ACP_PMNOTIFICATIONS'    => 'Notificações de MP',
	'SS_HELPER_NOTY'         => 'O SiteSplat BBcore não existe!<br />Transfere o <a href="http://sitesplat.com" target="_blank">BBcore</a> e copia a pasta BBcore para a pasta da tua extensão sitesplat.',
	'PMNOTIFICATIONS_NOTICE' => '<div class="phpinfo"><p>Não existem definições específicas para esta extensão. As MPs serão automaticamente separadas do sistema interno de notificações do phpBB. <br />O botão de filtro encontra-se na visualização das mensagens de MP.</p></div>',
]);
