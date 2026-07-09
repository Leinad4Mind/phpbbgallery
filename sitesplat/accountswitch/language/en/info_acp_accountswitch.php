<?php
/**
*
* @package BBSwitch
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
	'ACCOUNTSWITCH_OK'				=> 'BBswitch is ready to be used',
	'ACCOUNTSWITCH_REUSE'			=> 'However, BBswitch is <strong>not</strong> yet ready to be used due to the email-reuse setting set to <strong>NO</strong>. Set to <strong>yes</strong> the <strong>Allow Email-reuse</strong> under the <strong>ACP &#187; Board configuration &#187; User registration settings</strong>',
	'LOG_ACCOUNTSWITCH'				=> '<strong>Accountswitch</strong><br />» Switched to account %s',
	'ACCOUNTSWITCH_LINKED_ACCOUNTS'	=> 'Linked accounts',
	'SS_HELPER_NOTY'				=> 'SiteSplat BBcore does not exist!<br />Download the <a href="http://sitesplat.com" target="_blank">BBcore</a> and copy the BBcore folder into your sitesplat extension folder.',
    'ACCOUNTSWITCH_NOTICE'			=> '<div class="phpinfo"><p>This extension doesn\'t have any configurable settings.<br />%1$s.<br />Remember to set the activation to "<strong>By user (email verification)</strong>" in order to prevent any account hacking!</p></div>',
));
