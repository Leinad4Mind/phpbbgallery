<?php
/**
*
* BBadblock extension for the phpBB Forum Software package.
*
* @copyright (c) 2015 SiteSplat All rights reserved
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
	'ACP_BBADBLOCK'							=> 'BBadblock',
	'ACP_BBADBLOCK_INDEX_TITLE'				=> 'BBadblock Settings',
	'ACP_BBADBLOCK_EXPLAIN'					=> 'Adblocks are annoying as much as the ads :) for forum Admin and will make you loose revenue. <br />BBadblock will counter the adblock users and disrupt the forum experience to make the user hopefully whitelist your forum. Smart options available like modal messages, hide posts etc...',
	'ACP_BBADBLOCK_ADS_EXPLAIN'				=> '<br />If Ads is not enabled you should fill in the classname where your ads will reside',
	'ACP_BBADBLOCK_BBMEMBERSHIP_EXPLAIN'	=> '<br />If BBmembership is enabled you can use one of the membergroups to disable the adblocker. The usergroup should be default for the member then.',
    
	'BBADBLOCK_NOTICE'						=> '<div class="phpinfo"><p>The settings for this extension are in <strong>%1$s &#187; %2$s &#187; %3$s</strong>.</p></div>',
	'SS_HELPER_NOTY'	                    => 'SiteSplat BBcore does not exist!<br />Download the <a href="http://sitesplat.com" target="_blank">BBcore</a> and copy the BBcore folder into your sitesplat extension folder.',
	
	'BBADBLOCK_CLASSNAME'					=> 'Classname',
	'BBADBLOCK_CLASSNAME_EXPLAIN'			=> 'Name of the div class where your ads reside. <br /> This should not change unless you know what you are doing. <br /> Wrap your ads inside DIV blocks with the class entered here. <br />By default the ads test are in: <br /><strong class="small">- /ext/sitesplat/bbadblock/styles/FLATBOOTS/template/event/overall_footer_content_after.html</strong> <br /><strong class="small">- /ext/sitesplat/bbadblock/styles/FLATBOOTS/template/event/viewtopic_body_postrow_post_after.html</strong>',
	'BBADBLOCK_REDIRECT'					=> 'Redirection Page',
	'BBADBLOCK_REDIRECTE_EXPLAIN'			=> 'Redirection URL where the user will be forced to when any adblocker plugin is enabled. Check your server setting rewrite rules if something is not working or "too many redirections" error shown to the user. <br />For Example: <strong>/forum/memberships.php</strong>',
	'BBADBLOCK_MESSAGE'						=> 'Ajax Modal Message',
	'BBADBLOCK_MESSAGE_EXPLAIN'				=> 'Enter the message you would like to dispaly to the users that have the adblocker enabled',
	'BBADBLOCK_MODAL_ALERT'					=> 'Show Ajax Modal',
	'BBADBLOCK_MODAL_ALERT_EXPLAIN'			=> 'Show the Ajax Modal when the user is using an adblocker',
	'BBADBLOCK_AUTO_RESET'					=> 'Autoreset Pages Count',
	'BBADBLOCK_AUTO_RESET_EXPLAIN'			=> 'When set to YES the plugin will count each page view for each user with the adblock enabled and when finally when the user disables the adblock he/she will have to view the pages as many times as he/she previously viewed the pages with the adblock enabled until the count reaches zero in order to see all the posts. OFF disables the counter.<br /> <strong>NOTE</strong>: This option is meant to annoy the user and practically force them to disable the adblock or the forum experience is extremely disrupting. Use at your own risk.',
	'BBADBLOCK_EXCLUDE_GROUP'				=> 'BBmembership Group Exclusion',
	'BBADBLOCK_EXCLUDE_GROUP_EXPLAIN'		=> 'Member group that will NOT be affected by the BBadblock functions.',
	'BBADBLOCK_EXCLUDE_HIDE_FORUMS'			=> 'Forum Exclusion',
	'BBADBLOCK_EXCLUDE_HIDE_FORUMS_EXPLAIN'	=> 'All the posts except for the first will be hidden when the user has an adblocker enabled for exception of the forums selected here',
	'BBADBLOCK_BLOCKED_SINCE'				=> 'Using adblocker since',
	'BBADBLOCK_LOG'				            => 'BBadblock Log',
	'BBADBLOCK_LOG_EXPLAIN'				    => 'This is the log of all the user using an Adblocker and the count of the viewed pages with the adblock enabled. You can filter and delete the recorded entries. <br /><strong>NOTE</strong>: Admins "founder" are excluded by default to any logging or any option used above ;-)',
	'BBADBLOCK_HITS'						=> 'Views',
	'BBADBLOCK_NO_USERS'					=> 'No users reported using adblocker',
	'NOTICE_BBMEMBERSHIP'					=> 'The extension <a href="http://www.sitesplat.com/phpBB3/marketplace.php?mode=view&item_id=31"><strong>BBmembership</strong></a> is not installed, you can NOT use the autoredirect and usegroup options.',
	'ACP_NOTICE_CLOSE'						=> 'Close',
	
	'NOTICE_BBADBLOCK'						=> 'The extension <a href="http://www.sitesplat.com/phpBB3/marketplace.php?mode=view&item_id=31"><strong>BBmembership</strong></a> is not installed, you can NOT use the autoredirect and usergroup options.',
	'NOTICE_BBADBLOCK_MINICMS'				=> 'The extension <a href="http://www.sitesplat.com/phpBB3/marketplace.php?mode=view&item_id=18"><strong>Mini CMS</strong></a> is not installed, you can NOT create dynamic ads positions',
	'ACP_BBADBLOCK_MANAGE'					=> 'Manage BBadblock',
	'ACP_BBADBLOCK_MANAGE_EXPLAIN'			=> 'Using this form you can add, edit, view and delete BBadblock configurations.',

	'BBADBLOCK_DESCRIPTION'					=> 'Counters the Adblock plugins and adds effective methods to fight them',
	'BBADBLOCK_DEVELOPERS'					=> 'Developers',
	'BBADBLOCK_TASKS_1'						=> 'Smart options',
	'BBADBLOCK_TASKS_2'						=> 'Whitelist forums option',
	'BBADBLOCK_TASKS_3'						=> 'Whitelist group options',
	'BBADBLOCK_TASKS_4'						=> 'Special options for the <a href="http://www.sitesplat.com/phpBB3/marketplace.php?mode=view&item_id=31"><strong>BBmembership</strong></a> extension',
	'BBADBLOCK_TASKS_5'						=> 'Compatible with <a href="http://www.sitesplat.com/phpBB3/marketplace.php?mode=view&item_id=18"><strong>Mini CMS</strong></a> extension allows to set 3 predefined ads spots',
	'BBADBLOCK_TASKS_6'						=> 'Much more..!',
	
	'SITESPLAT_COM'		       		    	=> 'http://sitesplat.com',
	'SITESPLAT_COPY'		    			=> '&#169; SiteSplat',
	'LICENSE_INFO'		        			=> 'Proprietary - SiteSplat All rights reserved',
	'EXTENSION_DEVELOPER'	    			=> 'Developer',
	'ACP_BBADBLOCK_NOTICE_CLOSE'		    => 'Close',
	
	'ACP_BBADBLOCK_VERSION'					=> '1.0.5',
	'ACP_BBADBLOCK'							=> 'BBadblock',
    'ACP_LOADING'			    			=> 'Hold On. Loading...'
));

// Update check stuff
$lang = array_merge($lang, array(
	'DESCRIPTION_PAGE'		=> 'Description',
	'DESCRIPTION_NOTICE'	=> 'Extension note',
	'ext_details' => array(
		'details' => array(
			'DESCRIPTION_1'	=> 'Overview of users using adblocker',
			'DESCRIPTION_2'	=> 'Alert use of adblocker',
			'DESCRIPTION_3'	=> 'Hide topic replies',
			'DESCRIPTION_4'	=> 'Sorting',
		),
		'note' => array(
			'NOTICE_1'		=> 'Integrates with sitesplat Mini CMS',
			'NOTICE_2'		=> 'Integrates with BBmembership',
			'NOTICE_3'		=> 'phpBB 3.2 ready'
		)
	)
));