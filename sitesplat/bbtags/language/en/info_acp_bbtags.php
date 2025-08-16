<?php
/**
*
* BBtags
*
* @copyright (c) 2015 SiteSplat All rights reserved
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
	'ACP_BBTAGS'						=> 'BBtags',
	'ACP_BBTAGS_EXPLAIN'				=> 'Manage your tags<br />Delete or edit tags from the current topics. Manage your pre-tags for the auto-suggestion in topic.',
	'BBTAGS_MIN_LENGTH'					=> 'Min. length Tag',
	'BBTAGS_MIN_LENGTH_EXPLAIN'			=> 'Set the min. characters length per Tag',
	'BBTAGS_MAX_TAGS'					=> 'Max. amount of topic tags',
	'BBTAGS_MAX_TAGS_EXPLAIN'			=> 'Set the max amount of Tags per topic.',
	'BBTAGS_CLOUD_LIMIT'				=> 'Max. amount of Tags in cloud',
	'BBTAGS_CLOUD_LIMIT_EXPLAIN'		=> 'Set the max amount of Tags in cloud.',
	'BBTAGS_ON_INDEX'					=> 'BBtags cloud',
	'BBTAGS_ON_INDEX_EXPLAIN'			=> 'Display a tag cloud',
	'INDEX_ONLY'						=> 'Index only',
	'PRE_BBTAGS'						=> 'Pre BBtags',
	'PRE_BBTAGS_EXPLAIN'				=> 'Display the tag auto-suggestion when the user starts typing',
	'SAVE'								=> 'Save',
	
	'TAG'								=> 'Tag',
	'QTY'								=> 'Qty',
	'PAGEBACK'							=> 'Previous page',
	'PAGEFURTHER'						=> 'Next page',
	'BBTAGS_NO_TAGS'					=> 'No BBtags found',
	
	'SS_HELPER_NOTY'	                => 'SiteSplat BBcore does not exist!<br />Download the <a href="https://sitesplat.com" target="_blank">BBcore</a> and copy the BBcore folder into your sitesplat extension folder.',
	'BBTAGS_NOTICE'						=> '<div class="phpinfo"><p>The extension settings are under <strong>%1$s &#187; %2$s &#187; %3$s</strong>.<br />Don\'t forget to review/adjust the <strong>User Permission Roles</strong> under <strong>Permissions &#187; Permission roles &#187; User Roles (Select the Role and hit edit) &#187; Misc (tab): "Can Manage BBtags"</strong>.</p></div>',

    'ACP_BBTAGS_MANAGE'					=> 'Manage the current topic tags',
	'ACP_BBTAGS_MANAGE_EXPLAIN'			=> 'Using this form you can add, edit, view and delete tags',

	'BBTAGS_DESCRIPTION'				=> 'Next level of coolness and a step closer to WordPress with the classic Tags',
	'BBTAGS_DEVELOPERS'					=> 'Developers',
	'BBTAGS_TASKS_1'					=> 'Group Permissions',
	'BBTAGS_TASKS_2'					=> 'Min and Max Tags Settings',
	'BBTAGS_TASKS_3'					=> 'ACP Module to manage your tags and settings',
	'BBTAGS_TASKS_4'					=> 'Tag Cloud',
	'BBTAGS_TASKS_5'					=> 'Built-in Support for BBPreview extension <a href="https://sitesplat.com/phpBB3/marketplace.php">sitesplat.com/marketplace.php</a>',
	'BBTAGS_TASKS_6'					=> 'Much more..!',
	
	'SITESPLAT_COM'		       		    => 'https://sitesplat.com/',
	'SITESPLAT_COPY'		    		=> '&#169; SiteSplat',
	'LICENSE_INFO'		        		=> 'Proprietary - SiteSplat All rights reserved',
	'EXTENSION_DEVELOPER'	    		=> 'Developer',
	'ACP_BBTAGS_NOTICE_CLOSE'			=> 'Close',
	
	'ACP_BBTAGS_VERSION'				=> '1.1.5',
    'ACP_LOADING'			    		=> 'Hold On. Loading...',
	
));
