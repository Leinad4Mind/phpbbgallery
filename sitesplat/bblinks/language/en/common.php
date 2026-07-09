<?php
/**
*
* @package sitesplat BBlinks
* @copyright (c) 2017 SiteSplat All rights reserved
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
	'BBLINKS_MODAL_TITLE'	=> 'External URL Detected',
	'BBLINKS_PROCEED'	    => 'The link clicked is an external URL. Do you really wish to proceed to an external URL?',
	'BBLINKS_PROCEED_NO'	=> 'No',
	'BBLINKS_PROCEED_YES'	=> 'Yes',
));
