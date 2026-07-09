<?php
/**
*
* UserDefaults extension for the phpBB Forum Software package.
*
* @copyright (c) 2016 ForumHulp.com <http://forumhulp.com>
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
	'ACP_USERDEFAULT'			=> 'User Defaults',
	'ACP_USERDEFAULT_EXPLAIN'	=> 'Setup User Defaults, once changed it will not affect older users but wil be the default settings for new registered users. If you want the setup for all users you have to run "Synchronize users", it will change all setting for all registered users to the default as displayed.',
	'ACP_USERDEFAUL_SETTINGS'	=> 'Setup User Defaults',

	'POPUP_PM'					=> 'Popup new PM messages in  a new window',
	'VIEW_POSTS_TOPICS'			=> 'Post and Topics setting',
	'SORT_DAYS'					=> 'Sort time',	
	'SORT_DIRECTION'			=> 'Sort direction',
	'VARIANT_DATE_SEPARATOR'	=> ' | ',
	'ACP_USERDEFAULT_SAVED'		=> 'User Defaults saved',
	'SYNC_USERS'				=> 'Synchronize all users',
	'SYNC_USERS_EXPLAIN'		=> 'Set default settings for all users, be carefull as it\'s not reversable!',
    'USERDEFAULT_NOTICE'		=> '<div class="phpinfo"><p class="entry">Config setting of this module are in %1$s » %2$s » %3$s.</p></div>',
	'FH_HELPER_NOTICE'			=> 'Forumhulp helper application does not exist!<br />Download <a href="https://github.com/ForumHulp/helper">forumhulp/helper</a> and copy the helper folder to your forumhulp extension folder.',
));

// Description of Upload extension
$lang = array_merge($lang, array(
	'DESCRIPTION_PAGE'		=> 'Description',
	'DESCRIPTION_NOTICE'	=> 'Extension note',
	'ext_details' => array(
		'details' => array(
			'DESCRIPTION_1'		=> 'Options',
			'DESCRIPTION_2'		=> 'General options',
			'DESCRIPTION_3'		=> 'Post & Topic settings',
			'DESCRIPTION_4'		=> 'Notification settings',
			'DESCRIPTION_5'		=> 'Default setup all users',
		),
		'note' => array(
			'NOTICE_1'			=> '3.2.1 ready.',
		)
	)
));
