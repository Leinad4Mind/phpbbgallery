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
	'DEFAULT_RGRAVATAR_EXPLAIN'	=> 'This will assign a random gravatar for new users',
	'DEFAULT_CUAVATAR'	        => 'Set Custom Avatar default for new users',
	'DEFAULT_CUAVATAR_EXPLAIN'	=> 'Upload images you wish te be random avatars under root/images/avatars/random/ before using this function.',

	'SS_HELPER_NOTY'	=> 'SiteSplat BBcore does not exist!<br />Download the <a href="http://sitesplat.com" target="_blank">BBcore</a> and copy the BBcore folder into your sitesplat extension folder.',
	'BBRANDOM_NOTICE'	=> '<div class="phpinfo"><p>The setting for this extension are in <strong> ACP &#62; Board configuration &#62; Avatar settings</strong> and in <strong>ACP &#62; User and groups &#62; User administration &#62; User &#62; avatar</strong>.<br />Each user is also able to choose whether he or she wants to use a random avatar under UCP &#62; Profile &#62; Edit avatar. Custom avatar images should be uploaded in <strong>root/images/avatars/random/</strong></p></div>',
));

// Description of extension
$lang = array_merge($lang, array(
	'DESCRIPTION_PAGE'		=> 'Description',
	'DESCRIPTION_NOTICE'	=> 'Extension note',
	'ext_details' => array(
		'details' => array(
			'DESCRIPTION_1'		=> 'Random gravatars',
			'DESCRIPTION_2'		=> 'For each user',
			'DESCRIPTION_3'		=> 'Hosted at gravatar.com',
		),
		'note' => array(
			'NOTICE_1'			=> 'phpBB 3.2 ready'
		)
	)
));
