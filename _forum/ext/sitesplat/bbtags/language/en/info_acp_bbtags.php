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
	'BBTAGS_SETTINGS_SAVED'			=> 'BBTags settings saved successfully.',
	'BBTAGS_TAG_DELETED'				=> 'The tag was deleted successfully.',
	'BBTAGS_TAG_NOT_FOUND'			=> 'The requested tag does not exist.',
	'BBTAGS_TAG_UPDATED'				=> 'The tag was updated successfully.',
	'BBTAGS_TAG_UPDATE_FAILED'		=> 'The tag could not be updated. Its name may already be in use.',
	'BBTAGS_TAG_EXISTS_USE_MERGE'	=> 'That tag already exists. Use the merge tool to combine both tags.',
	'ACP_BBTAGS_MERGE'				=> 'Merge tags',
	'ACP_BBTAGS_MERGE_EXPLAIN'		=> 'Move every relation from a source tag into an existing destination tag. The destination name, route and policy are kept.',
	'BBTAGS_MERGE_SOURCE'			=> 'Source tag',
	'BBTAGS_MERGE_SOURCE_EXPLAIN'	=> 'This tag will be removed after its relations are transferred.',
	'BBTAGS_MERGE_DESTINATION'		=> 'Destination tag',
	'BBTAGS_MERGE_DESTINATION_EXPLAIN' => 'This tag and its current policy will be kept.',
	'BBTAGS_MERGE_SUBMIT'			=> 'Merge tags',
	'BBTAGS_MERGE_INVALID'			=> 'The source and destination tags must be different.',
	'BBTAGS_MERGE_CONFIRM'			=> 'Are you sure you want to merge “%1$s” into “%2$s”? This cannot be undone.',
	'BBTAGS_MERGE_EXTERNAL_PROVIDER'=> 'The source tag cannot be merged because it is actively used by these external providers: %s.',
	'BBTAGS_MERGE_FAILED'			=> 'The tags could not be merged. No changes were committed.',
	'BBTAGS_MERGE_SUCCESS'			=> 'The tags were merged successfully.',

	'SS_HELPER_NOTY'	                => 'SiteSplat BBcore does not exist!<br />Download the <a href="https://sitesplat.com" target="_blank">BBcore</a> and copy the BBcore folder into your sitesplat extension folder.',
	'BBTAGS_NOTICE'						=> '<div class="phpinfo"><p>The extension settings are under <strong>%1$s &#187; %2$s &#187; %3$s</strong>.<br />Don\'t forget to review/adjust the <strong>User Permission Roles</strong> under <strong>Permissions &#187; Permission roles &#187; User Roles (Select the Role and hit edit) &#187; Misc (tab): "Can Manage BBtags"</strong>.</p></div>',

	'ACP_BBTAGS_MANAGE'					=> 'Manage the current topic tags',
	'ACP_BBTAGS_MANAGE_EXPLAIN'			=> 'Using this form you can add, edit, view and delete tags',

	'ACP_BBTAGS_POLICY'                    => 'Forum policy',
	'ACP_BBTAGS_POLICY_EXPLAIN'            => 'Configure where the tag "%s" is available for topics.',
	'ACP_BBTAGS_POLICY_PROVIDER'           => 'Topic tag availability',
	'ACP_BBTAGS_POLICY_ENABLED'            => 'Enable for topics',
	'ACP_BBTAGS_POLICY_ENABLED_EXPLAIN'    => 'Disable this tag for the forum_topics provider without removing it from the shared catalogue.',
	'ACP_BBTAGS_POLICY_MODE'               => 'Default availability',
	'ACP_BBTAGS_POLICY_MODE_EXPLAIN'       => 'Global makes the tag available unless a branch is denied. Restricted requires an explicit allow rule.',
	'ACP_BBTAGS_POLICY_MODE_GLOBAL'        => 'Available in all forums',
	'ACP_BBTAGS_POLICY_MODE_RESTRICTED'    => 'Only available in allowed forums',
	'ACP_BBTAGS_POLICY_FORUM_RULES'        => 'Forum hierarchy',
	'ACP_BBTAGS_POLICY_FORUM_RULES_EXPLAIN'=> 'A rule applies to the selected forum and its descendants unless a closer descendant overrides it. Inherit uses the nearest parent rule or the default availability mode.',
	'ACP_BBTAGS_POLICY_FORUM'              => 'Forum',
	'ACP_BBTAGS_POLICY_RULE'               => 'Rule',
	'ACP_BBTAGS_POLICY_RULE_INHERIT'       => 'Inherit',
	'ACP_BBTAGS_POLICY_RULE_ALLOW'         => 'Allow',
	'ACP_BBTAGS_POLICY_RULE_DENY'          => 'Deny',
	'ACP_BBTAGS_POLICY_NO_FORUMS'          => 'There are no forums to configure.',
	'ACP_BBTAGS_POLICY_SAVED'              => 'The forum policy was saved successfully.',
	'ACP_BBTAGS_POLICY_SAVE_FAILED'        => 'The forum policy could not be saved.',
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

	'ACP_LOADING'			    		=> 'Hold On. Loading...',

));
