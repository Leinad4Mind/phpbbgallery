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
	'SS_HELPER_NOTY'         => 'SiteSplat BBcore does not exist!<br />Download the <a href="http://sitesplat.com" target="_blank">BBcore</a> and copy the BBcore folder into your sitesplat extension folder.',
	'PMNOTIFICATIONS_NOTICE' => '<div class="phpinfo"><p>There are no specific settings for this extension. The PM\'s will be automatically separated from the internal phpBB notification system. <br />The filter button is under PM message view.</p></div>',
]);
