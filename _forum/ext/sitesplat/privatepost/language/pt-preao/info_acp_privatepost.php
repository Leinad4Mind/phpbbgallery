<?php
/**
*
* Private Post
*
* @copyright (c) 2016 SiteSplat All rights reserved
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

if ( empty($lang) || !is_array($lang) )
{
	$lang = array();
}

$lang = array_merge($lang, array(
	'PRIVATEPOST_NOTICE'		    => '<div class="phpinfo"><p><br />The settings for this extensions are in <strong>%1$s » %2$s » %3$s</strong>.<br />The permission is forum-based. This means that you need to select a group AND a forum to which you want to grant the permission to.<br /> If you want to make this quicker, navigate to <strong>Permissions Roles -> Forum roles -> Full access</strong> and set permission there (for each role). It will be automatically update all groups that use Full access role (or any other roles you adjusted) across the board.<br /><br /> <strong>WARNING</strong>: Please note that due to the nature of this extension all the posts that have been marked as private will be deleted as "Soft Delete" when the extension is disabled. <br />Soft deleted posts or topics can be found under the Moderation Control Panel. (MCP)</p></div>',
	'ACP_PRIVATEPOST_PERMISSIONS'	=> 'select Group and forum then "Advanced Permissions" » Content Tab "Can read private post"',
	'SS_HELPER_NOTY'				=> 'SiteSplat BBcore does not exist!<br />Download the <a href="http://sitesplat.com" target="_blank">BBcore</a> and copy the BBcore folder into your sitesplat extension folder.',
));

