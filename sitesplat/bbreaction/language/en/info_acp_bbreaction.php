<?php
/**
*
* BBreaction
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
	'ACP_BBREACTION'			            => 'BBreaction',
	'ACP_BBREACTION_EXPLAIN'	            => 'Manage your reaction types. Choose for multi-vote and/or percentage type. Move up and/or down for ordering your reaction types. Once a type has been voted for, you cannot delete it until you deactivate that reaction type. <br />Deleting a reaction type will also delete all votes. If you wish to keep the votes then simply deactivate the type. Deactivated types won\'t be calculated in the stats result',
    'ACP_BBREACTION_MANAGE'		            => 'Manage BBreaction',
	
	'BBREACTION_META_DESCRIPTION'			=> 'Award users with badges based on custom and default rules',
	'BBREACTION_META_DEVELOPERS'			=> 'Developers',
	'BBREACTION_META_TASKS_1'				=> 'Makes lurkers useful for something and gives them a means of interaction',
	'BBREACTION_META_TASKS_2'				=> 'Improves quality of posts (posters want to avoid negative ratings)',
	'BBREACTION_META_TASKS_3'				=> 'Makes it easy to get reactions to the post, but without the hassle of writing a whole comment',
	'BBREACTION_META_TASKS_4'				=> 'Compatible with <a href="https://sitesplat.com/phpBB3/marketplace.php">BBAwards</a> extension that allows custom badges awards',
	'BBREACTION_META_TASKS_5'				=> 'Configurable buttons (how many, what text, icons, negative or positive, animation etc)',
	'BBREACTION_META_TASKS_6'				=> 'Much more..!',
	
	'ACP_BBREACTION_VERSION'	            => '1.2.8',
	'ACP_BBREACTION'			            => 'BBreaction',
    'ACP_LOADING'			                => 'Hold On. Loading...',
	'ACP_SIDEBAR_NOTICE_CLOSE'			    => 'Close',

	'SITESPLAT_COM'		                    => 'https://sitesplat.com',
	'SITESPLAT_COPY'		                => '&#169; SiteSplat',
	'LICENSE_INFO'		                    => 'Proprietary - SiteSplat All rights reserved',
	'EXTENSION_DEVELOPER'			        => 'Developer',
	
	'NOTICE_BBEMOJI'						=> 'The extension <a href="https://sitesplat.com/phpBB3/marketplace.php?mode=view&item_id=29"><strong>BBeomji</strong></a> is not installed, you can NOT use the Emojis as reactions.',
	'ACP_BBREACTION_DELETE_LOG'				=> 'Reaction type deleted',
	'ACP_BBREACTION_ACTIVE_LOG'				=> 'Reaction %s is %s',
	'ACP_ACTIVE'							=> 'activated',
	'ACP_DO_ACTIVATE'						=> 'Activate',
	'ACP_DEACTIVE'							=> 'deactivated',
	'ACP_DO_DEACTIVATE'						=> 'Deactivate',
	'ACP_MULTIVOTE'							=> 'Multivote',
	'ACP_PERCENT'							=> 'Percent / #',
	'ACP_PROGRESSBAR'						=> 'Progressbar',
	'ACP_MEMBERLIST_STAT'					=> 'Stats',
	'ACP_DISPLAY_TOP'						=> 'Topic stats position',
	'ACP_BBREACTION_SAVE_GENERAL'			=> 'Save options',
	'ACP_BBREACTION_CREATE_TYPE'			=> 'Create reaction type',
	'ACP_BBREACTION_STATISTICS'				=> 'BBreaction statistics',

	'ACP_ALLOW_LOCKED'						=> 'Allow in locked topics',
	'ACP_ALLOW_GLOBAL'						=> 'Allow in global announcements',

	'ACP_BBREACTION_ADD'					=> 'Add reaction type',
	'ACP_BBREACTION_EDIT'					=> 'Edit reaction type',
	'ACP_BBREACTION_DELETE_CONFIRM'			=> 'Delete reaction type and all it\'s votes?',
	'ACP_BBREACTION_NAME'					=> 'Reaction name',
	'ACP_BBREACTION_NAME_EXPLAIN'			=> 'Give a short name to explain the type of this reaction',
	'ACP_BBREACTION_DESCRIPTION'			=> 'Description',
	'ACP_BBREACTION_DESCRIPTION_EXPLAIN'	=> 'Description of the type, only for internal use',
	'ACP_BBREACTION_SYMBOL'					=> 'Glyph icon',
	'ACP_BBREACTION_SYMBOL_EXPLAIN'			=> 'Font Awesome glyph icon on the reaction button. Add a second parameter for spinner animation. <br />For example <strong>fa-spin</strong>. More info <a href="https://fortawesome.github.io/Font-Awesome/examples/#animated">Animated Icons</a>',
	'ACP_BBREACTION_NEGATIVE'				=> 'Positive reaction',
	'ACP_BBREACTION_NEGATIVE_EXPLAIN'		=> 'Mark this reaction type as Positive or Negative. Positive will have a green color and Negative will have red.',

	'ACP_BBREACTION_SEPERATOR'				=> 'Separator',
	'ACP_BBREACTION_SEPERATOR_EXPLAIN'		=> 'Draws a separator rule to the left of this button',
	'ACP_BBREACTION_NOTIFY'					=> 'Notify',
	'ACP_BBREACTION_NOTIFY_EXPLAIN'			=> 'Sends a notification to the poster when there is a new reaction',
	
	'ACP_BBREACTION_NAME_USED'				=> 'Name already in use',
	'ACP_BBREACTION_SAVED_LOG'				=> 'Reaction type saved',
	'ACP_BBREACTION_SAVED_LOG'				=> 'Reaction type added',
	'ACP_BBREACTION_SUBMIT_SUCCESS'			=> 'Reaction type saved',
	'ACP_BBREACTION_DELETE_SUCCESS'			=> 'Reaction type and votes successfully deleted',
	'ACP_BBREACTION_DELETE_LOG'				=> 'Reaction type %s and votes successfully deleted',
	
	'ACP_BBREACTION_USED'					=> 'Voted',
	'ACP_REACTIONS'							=> 'BBreaction',
	'ACP_BBREACTION_EMPTY'					=> 'No BBreaction records',

	'SS_HELPER_NOTY'	                    => 'SiteSplat BBcore does not exist!<br />Download the <a href="https://sitesplat.com" target="_blank">BBcore</a> and copy the BBcore folder into your sitesplat extension folder.',
	'BBREACTION_NOTICE'	                    => '<div style="width:80%;margin:20px auto;"><p>The setting for this extension are in <strong>%1$s &#187; %2$s &#187; %3$s.</strong><br />Make sure to check the Group Permission and adjust as needed. The default reactions have the user notification already enabled.</p></div>',

	// BBemoji
	'ACP_BBREACTION_EMOJI'			=> 'BBemoji',
	'ACP_BBREACTION_EMOJI_EXPLAIN'	=> 'Pick a BBemoji as icon. Start by typing :.',
));
