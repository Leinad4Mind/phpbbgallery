<?php

/**
 * BBbbprofile. An extension for the phpBB Forum Software package.
 * @copyright (c) 2016, SiteSplat
 * @license Proprietary
 * @translation Leinad4Mind [Portuguese [pt]] (2026)
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
	'ACP_BBPROFILE'           => 'BBprofile',
	'BBPROFILE_SETTING_SAVED' => 'BBprofile settings has been saved.',

	'SS_HELPER_NOTY'   => 'SiteSplat BBcore does not exist!<br />Download the <a href="http://sitesplat.com" target="_blank">BBcore</a> and copy the BBcore folder into your sitesplat extension folder.',
	'BBPROFILE_NOTICE' => '<div class="phpinfo"><p>The settings for this extension are under the <strong>EXTENSIONS</strong> tab.</p><br /><p>Don\'t forget to check the Group Permissions "Can see BBprofile box" under: Group Permissions &#187; Misc.</p></div>',

	'BBPROFILE_LABEL'         => 'When should we display BBprofile?',
	'BBPROFILE_LABEL_EXPLAIN' => 'Choose the profile box location',
	'UCP_ONLY'                => 'UCP only',
	'OVEARALL_HEADER'         => 'Overall header',

	'BBPROFILE_ENABLED'         => 'Enabled BBprofile parts:',
	'BBPROFILE_ENABLED_EXPLAIN' => 'Choose the profile parts that should be counted towards the 100% profile completion',

		'PREDEFINED' => 'Predefined',
	'CPF'         => 'Custom Profile Fields',

	'BBPROFILE_HIDE_FOR_ADMINS'   => 'Hide BBprofile box for admins:',
	'HIDE_FOR_ADMINS'             => 'Hide for admins',
	'BBPROFILE_HIDE_FOR_MODS'     => 'Hide BBprofile box for global moderators',
	'HIDE_FOR_MODS'               => 'Hide for global moderators',
	'BBPROFILE_HIDDEN_FOR_ADMINS' => 'BBprofile box has been hidden for admins.',
	'BBPROFILE_HIDDEN_FOR_MODS'   => 'BBprofile box has been hidden for global moderators.',
]);
