<?php
/**
*
* Nightstalker
*
* @copyright (c) 2015 sitesplat.com <http://sitesplat.com>
* @license Proprietary
*
*/

/**
* DO NOT CHANGE
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
	'NIGHTSTALKER'			=> 'Nighstalker mode',
	'NORMAL_VIEW'			=> 'Normal mode',
	'NIGHTSTALKER_NOTICE'	=> '<div class="phpinfo"><p>There are no specific settings for this extension.<br />Nighstalker (Night Mode) is activated by clicking on the Nightstalker mode from the user navigation.</p></div>',
));
