<?php
/**
*
* @package BBrandom
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
	'ALLOW_RGRAVATAR'	        => 'Allow Random Gravatars',
	'DEFAULT_RGRAVATAR'	        => 'Set Random Gravatar default for new users',
	'DEFAULT_RGRAVATAR_EXPLAIN'	=> 'This will assign a random Gravatar for Newly Registered Users<br />This option will also be available under UCP &#62; Profile &#62; Edit avatar',
	'DEFAULT_CUAVATAR'	        => 'Set Custom Avatar default for new users',
	'DEFAULT_CUAVATAR_EXPLAIN'	=> 'Upload images you wish te be random avatars under <strong>root/images/avatars/random/</strong> before using this function!<br /> This is only for the Newly Registered Users and will not available under UCP &#62; Profile &#62; Edit avatar',
	'DEFAULT_RGRAVATAR_STYLE'	=> 'Default Random Gravatar style',

	'SS_HELPER_NOTY'	        => 'SiteSplat BBcore does not exist!<br />Download the <a href="https://sitesplat.com" target="_blank">BBcore</a> and copy the BBcore folder into your sitesplat extension folder.',
	'BBRANDOM_NOTICE'	        => '<div class="phpinfo"><p>The setting for this extension are in <strong> ACP &#62; Board configuration &#62; Avatar settings</strong> <br>Also in: <strong>ACP &#62; User and groups &#62; Manage Users &#62; User administration &#62;</strong> Select user and submit then from the dropdown menu, then hit "avatar".<br />Each user is also able to choose whether he or she wants to use a random avatar under <strong>UCP &#62; Profile &#62; Edit avatar</strong>. Custom avatar images should be uploaded in <strong>root/images/avatars/random/</strong></p></div>',
	'BBRANDOM_SITESPLAT'	    => '<i class="icon fa fa-info-circle"></i>Random Avatars Extension by <a href="https://sitesplat.com" title="Professional Web Development"><strong>SiteSplat.com</strong></a> built for <a href="https://themeforest.net/user/themesplat/portfolio?ref=ThemeSplat" title="Professional Premium Themes"><strong>SiteSplat\'s Themes</strong></a>',
));

// Description of extension
$lang = array_merge($lang, array(
	'DESCRIPTION_PAGE'		=> 'Description',
	'DESCRIPTION_NOTICE'	=> 'Extension note',
	'ext_details' => array(
		'details' => array(
			'DESCRIPTION_1'		=> 'Random Gravatars',
			'DESCRIPTION_2'		=> 'For each user',
			'DESCRIPTION_3'		=> 'Hosted at gravatar.com',
		),
		'note' => array(
			'NOTICE_1'			=> 'phpBB 3.2 ready'
		)
	)
));
