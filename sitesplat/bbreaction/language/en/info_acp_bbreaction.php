<?php
/**
*
* BBreaction.
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
	'ACP_BBREACTION'			            => 'BBreaction',
	'ACP_BBREACTION_EXPLAIN'	            => 'Manage your reaction types. Choose for multivote and/or percentage type. Move up and/or down for ordering your reaction types. Once a type has been voted for, you cannot delete it until you deactivate that reaction type. <br />Deleting a reaction type will also delete all votes. If you wish to keep the votes then simply deactivate the type. Deactivated types won\'t be calculated in the stats result',
    'ACP_BBREACTION_MANAGE'		            => 'Manage BBreaction',
	
	'BADGE_DESCRIPTION'			            => 'Award users with badges based on custom and default rules',
	'BADGE_DEVELOPERS'			            => 'Developers',
	'BADGE_TASKS_1'				            => 'Makes lurkers useful for something and gives them a means of interaction',
	'BADGE_TASKS_2'				            => 'Improves quality of posts (posters want to avoid negative ratings)',
	'BADGE_TASKS_3'				            => 'Makes it easy to get reactions to the post, but without the hassle of writing a whole comment',
	'BADGE_TASKS_4'				            => 'Compatible with <a href="http://www.sitesplat.com/phpBB3/marketplace.php">BBAwards</a> extension that allows custom badges awards',
	'BADGE_TASKS_5'				            => 'Configurable buttons (how many, what text, icons, negative or positive, animation etc)',
	'BADGE_TASKS_6'				            => 'Much more..!',
	
	'ACP_BBREACTION_VERSION'	            => '1.0.6',
	'ACP_BBREACTION'			            => 'BBreaction',
    'ACP_LOADING'			                => 'Hold On. Loading...',
	'ACP_SIDEBAR_NOTICE_CLOSE'			    => 'Close',

	'SITESPLAT_COM'		                    => 'http://sitesplat.com',
	'SITESPLAT_COPY'		                => '&#169; SiteSplat',
	'LICENSE_INFO'		                    => 'Proprietary - SiteSplat All rights reserved',
	'EXTENSION_DEVELOPER'			        => 'Developer',
	
	'ACP_BBREACTION_DELETE_LOG'				=> 'Reaction type deleted',
	'ACP_BBREACTION_ACTIVE_LOG'				=> 'Reaction %s is %s',
	'ACP_ACTIVE'							=> 'activated',
	'ACP_DO_ACTIVATE'						=> 'Activate',
	'ACP_DEACTIVE'							=> 'deactivated',
	'ACP_DO_DEACTIVATE'						=> 'Deactivate',
	'ACP_MULTIVOTE'							=> 'User multivote',
	'ACP_PERCENT'							=> 'Percentages % or votes #',
	'ACP_PROGRESSBAR'						=> 'Progressbar in Mini Profile (topic page)',
	'ACP_MEMBERLIST_STAT'					=> 'Stats in member profile',
	'ACP_BBREACTION_SAVE_GENERAL'			=> 'Save options',
	'ACP_BBREACTION_CREATE_TYPE'			=> 'Create reaction type',
	'ACP_BBREACTION_STATISTICS'				=> 'BBreaction statistics',

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

	'ACP_BBREACTION_SEPERATOR'				=> 'Seperator',
	'ACP_BBREACTION_SEPERATOR_EXPLAIN'		=> 'Draws a seperator rule to the left of this button',
	'ACP_BBREACTION_NOTIFY'					=> 'Notify',
	'ACP_BBREACTION_NOTIFY_EXPLAIN'			=> 'Sends a notification to the poster when there is a new reaction',
	
	'ACP_BBREACTION_NAME_USED'				=> 'Name already in use',
	'ACP_BBREACTION_SAVED_LOG'				=> 'Reaction type saved',
	'ACP_BBREACTION_SAVED_LOG'				=> 'Reaction type added',
	'ACP_BBREACTION_SUBMIT_SUCCESS'			=> 'Reaction type saved',
	'ACP_BBREACTION_DELETE_SUCCESS'			=> 'Reaction type and votes succesfully deleted',
	'ACP_BBREACTION_DELETE_LOG'				=> 'Reaction type %s and votes succesfully deleted',
	
	'ACP_BBREACTION_USED'					=> 'Voted',
	'ACP_REACTIONS'							=> 'BBreaction',
	'ACP_BBREACTION_EMPTY'					=> 'No BBreaction records',

	'BBREACTION_NOTICE'	                    => '<div style="width:80%;margin:20px auto;"><p>The setting for this extension are in <strong>%1$s » %2$s » %3$s.</strong></p></div>',

));

?>