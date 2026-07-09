<?php
/**
*
* BBbreadcrumbs
* @copyright (c) 2016 SiteSplat All rights reserved
* @license Proprietary
*
*/

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = array();
}

$lang = array_merge($lang, array(
	'ACP_BREADCRUMBS'				=> 'BBbreadcrumbs',
	'SS_HELPER_NOTY'	            => 'SiteSplat BBcore does not exist!<br />Download the <a href="http://sitesplat.com" target="_blank">BBcore</a> and copy the BBcore folder into your sitesplat extension folder.',
	'BREADCRUMBS_NOTICE'	        => '<div class="phpinfo"><p>There are no specific settings for this extension. The breadrcumb is active and now will be automatically working across the forum pages.</p></div>',
));

