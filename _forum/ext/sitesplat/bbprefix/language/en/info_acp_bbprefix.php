<?php
/**
 *
* @package BBprefix
* @copyright (c) 2015 SiteSplat All rights reserved
* @license Proprietary
 *
 */

if (empty($lang) || !is_array($lang))
{
	$lang = [];
}

// DEVELOPERS PLEASE NOTE
//
// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
//
// Placeholders can now contain order information, e.g. instead of
// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
// translators to re-order the output of data while ensuring it remains correct
//
// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
// equally where a string contains only two placeholders which are used to wrap text
// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
//
// Some characters you may want to copy&paste:
// ’ » “ ” …
//

$lang = array_merge($lang, [
	'ACP_BBPREFIX_MANAGEMENT'		=> 'BBprefix Management',
	'ACP_BBPREFIX_MANAGE'			=> 'Manage BBprefix',
	
	'ACP_BBPREFIX_MANAGE_EXPLAIN'	=> 'On this page, you can manage the topic prefixes for your board. Use of variables in your prefix is possible. Custom BBcodes is also supported so you can create fun and flexible prefixes. <br />You can also exclude forums and exclude groups from using prefixes. Have Fun!!!',
    'BBPREFIX_MANAGE_EXONE'	        => '<h3>Font Awesome icon could be:</h3> <br /><br /><strong>BBCode usage:</strong> <code>[fa-bug][/fa-bug]</code> <br /><strong>HTML Replacement</strong> <code>&lt;i class=&quot;fa fa-bug&quot;&gt;&lt;/i&gt;</code> <br /><strong>Prefix usage:</strong> <code>[fa-bug][/fa-bug]</code>',
	'BBPREFIX_MANAGE_EXTWO'	        => '<h3>Bootstrap labels could be:</h3> <br /><br /><strong>BBCode usage:</strong> <code>[label-warning][/label-warning]</code> <br /><strong>HTML Replacement</strong> <code>&lt;span class=&quot;label label-warning&quot;&gt;MyTextHere&lt;/span&gt;</code> <br /><strong>Prefix usage:</strong> <code>[label-warning][/label-warning]</code> ',
	'BBPREFIX_MANAGE_EXTHREE'	    => '<h3>Image based bbcode could be:</h3> <br /><br /><strong>BBCode usage:</strong> <code>[img-owl][/img-owl]</code> <br /><strong>HTML Replacement</strong> <code>&lt;img class="bbprefix-index-tag" src=&quot;https://cdn2.iconfinder.com/data/icons/thesquid-ink-40-free-flat-icon-pack/64/owl-20.png&quot; alt=""&gt;</code> <br /><strong>Prefix usage:</strong> <code>[img-owl][/img-owl]</code><br />**<small>Note the class="bbprefix-index-tag" for images which is necessary to ensure the correct max size is applied on the index page.</small>',
	
	
	'TITLE_EXPLAIN_TIPS'			=> 'Tips and Usage:',
	'TITLE_EXPLAIN_TIPS_EXPLAIN'	=> 'The current allowed variables are: (<strong>{DATE}</strong>, <strong>{POSTER}</strong> and <strong>{USERNAME}</strong>)<br /> Custom BBcodes would need to be created <strong>first</strong> and then the BBcode can be used in BBprefix as follows for example:',
	'TITLE_EXPLAIN_TIPS_STAR'	    => '<small>**Create your custom BBcode FIRST under  ACP > POSTING > Messages > BBcodes and then create your BBprefix entry.</small>',
	
	'BBPREFIX_NOTICE'				=> '<div class="phpinfo"><p>The settings for this extension are in <strong>%1$s &#187; %2$s &#187; %3$s</strong>.</p></div>',
    'SS_HELPER_NOTY'	            => 'SiteSplat BBcore does not exist!<br />Download the <a href="https://sitesplat.com" target="_blank">BBcore</a> and copy the BBcore folder into your sitesplat extension folder.',
	
	'ACP_BBPREFIX'					=> 'Topic Prefixes',
	'PREFIX_NAME'					=> 'Prefix name',
	'PREFIX_PARSED'					=> 'Prefix',
	'EX_FORUMS'						=> 'Excluded forums',
	'USED'							=> 'Used',
	'ADD_PREFIX'					=> 'New Prefix',

	'BBPREFIX_TITLE'				=> 'Prefix',
	'BBPREFIX_TITLE_EXPLAIN'		=> 'This is what will actually be displayed in front of the topic title. BBCode is supported. <br />Certain variables may be used, which will be substituted with actual data when the prefix is applied. <br />See <strong>Prefix usage</strong> below under <strong>Tips and Usage</strong> on How to use the prefix created from the BBcode',
	'BBPREFIX_NAME'					=> 'Prefix name',
	'BBPREFIX_NAME_EXPLAIN'			=> 'This is a unique identifier to help you differentiate between prefixes.',
	'BBPREFIX_ON_INDEX'				=> 'Prefix on topic list',
	'BBPREFIX_ON_INDEX_EXPLAIN'		=> 'Display prefixes on index and viewforum pages. If one prefix isn\'t allowed to show there will be no prefix on these pages where the topic titles are shown.<br />This is particularly useful when there are many prefixes in use and therefore could clutter the topic list.<br /><br />',
	'BBPREFIX_FORUMS'				=> 'Exclude forums',
	'BBPREFIX_FORUMS_EXPLAIN'		=> 'Specify which forums are excluded to use this prefix.',
	'BBPREFIX_GROUPS'				=> 'Groups',
	'BBPREFIX_GROUPS_EXPLAIN'		=> 'Specify which groups can apply this prefix.',

	'DELETE_PREFIX'					=> 'Are you sure you want to delete the specified prefix?',
	'DELETE_PREFIX_CONFIRM'			=> 'The prefix and all of its instances will be deleted. This cannot be undone.',

	'BBPREFIX_EMPTY_ERROR'			=> 'Empty name and / or prefix',
	'BBPREFIX_NAME_ERROR'			=> 'This BBprefix id already taken',
	'BBPREFIX_TITLE_ERROR'			=> 'This prefix already exists',

	'PREFIX_ADDED_SUCCESS'			=> 'The prefix has been added successfully.',
	'PREFIX_EDITED_SUCCESS'			=> 'The prefix has been updated successfully.',
	'PREFIX_DELETED_SUCCESS'		=> 'The prefix has been deleted successfully.',
	'NO_PREFIX_ID_SPECIFIED'		=> 'You must specify a valid prefix ID.',
	'PREFIX_REORDERED_SUCCESS'		=> 'The prefix order has been saved successfully.',

	'BBPREFIX_SAVE_ORDER'			=> 'Save order',
	'BBPREFIX_DRAG_TO_REORDER'		=> 'Drag to reorder',

	'BBPREFIX_TYPE'					=> 'Type',
	'BBPREFIX_TYPE_EXPLAIN'			=> 'A prefix is shown before the topic title, a suffix after it.',
	'BBPREFIX_PREFIX'				=> 'Prefix',
	'BBPREFIX_SUFFIX'				=> 'Suffix',

	'BBPREFIX_MANAGE_CATEGORIES'	=> 'Manage categories',
	'BBPREFIX_CATEGORY'				=> 'Category',
	'BBPREFIX_CATEGORY_EXPLAIN'		=> 'Prefixes in the same category are combined with OR when filtering topics; different categories are combined with AND.',
	'BBPREFIX_CATEGORY_NONE'		=> '- None -',
	'BBPREFIX_CATEGORY_EMPTY_ERROR'	=> 'The category name cannot be empty.',
	'BBPREFIX_CATEGORY_SAVED_SUCCESS'	=> 'The category has been saved successfully.',
	'BBPREFIX_CATEGORY_DELETED_SUCCESS'	=> 'The category has been deleted. Prefixes that used it are now uncategorised.',
	'NO_CATEGORY_ID_SPECIFIED'		=> 'You must specify a valid category ID.',

	'DELETE_CATEGORY'				=> 'Are you sure you want to delete the specified category?',
	'DELETE_CATEGORY_CONFIRM'		=> 'Prefixes using this category are not deleted - they are simply left without a category. This cannot be undone.',

	'BBPREFIX_FORUMS_MODE'			=> 'Forums mode',
	'BBPREFIX_FORUMS_MODE_EXPLAIN'		=> 'Choose whichever list below is shorter for this prefix.',
	'BBPREFIX_FORUMS_MODE_EXCLUDE'		=> 'Apply to all forums except these',
	'BBPREFIX_FORUMS_MODE_INCLUDE'		=> 'Apply only to these forums',
	'BBPREFIX_FORUMS_TOO_LONG'		=> 'This forum list is too large. Try "%s" instead.',

	'BBPREFIX_SETTINGS'				=> 'Settings',
	'BBPREFIX_MIN_SELECTED'			=> 'Minimum prefixes',
	'BBPREFIX_MIN_SELECTED_EXPLAIN'		=> 'The fewest prefixes (and suffixes) a topic must carry. 0 means no minimum.',
	'BBPREFIX_MAX_SELECTED'			=> 'Maximum prefixes',
	'BBPREFIX_MAX_SELECTED_EXPLAIN'		=> 'The most prefixes (and suffixes) a topic may carry. 0 means no maximum.',
	
	'BBPREFIX_DESCRIPTION'			=> 'Ads some powerful and stylish prexies to the forum topics',
	'BBPREFIX_DEVELOPERS'			=> 'Developers',
	'BBPREFIX_TASKS_1'				=> 'Smart options',
	'BBPREFIX_TASKS_2'				=> 'BBcode enabled',
	'BBPREFIX_TASKS_3'				=> 'Support images, text, labels anything you can place in a BBcode',
	'BBPREFIX_TASKS_4'				=> 'Forum Exclusion',
	'BBPREFIX_TASKS_5'				=> 'Group Exclusion',
	'BBPREFIX_TASKS_6'				=> 'Much more..!',
	
	'SITESPLAT_COM'		       		=> 'https://sitesplat.com',
	'SITESPLAT_COPY'		    	=> '&#169; SiteSplat',
	'LICENSE_INFO'		        	=> 'Proprietary - SiteSplat All rights reserved',
	'EXTENSION_DEVELOPER'	    	=> 'Developer',
	'ACP_BBPREFIX_NOTICE_CLOSE'		=> 'Close',
	
	'ACP_BBPREFIX_VERSION'			=> '1.0.10',
	'ACP_BBPREFIX'					=> 'BBprefix',
    'ACP_LOADING'			    	=> 'Hold On. Loading...'
]);

// Description misc
$lang = array_merge($lang, array(
	'DESCRIPTION_PAGE'				=> 'Description',
	'DESCRIPTION_NOTICE'			=> 'Extension note',
	'ext_details' => array(
		'details' => array(
			'DESCRIPTION_1'			=> 'Multiple prefixes',
			'DESCRIPTION_2'			=> 'Limited per group and or per forum',
			'DESCRIPTION_3'			=> 'Use of variables',
			'DESCRIPTION_4'			=> 'Stats',
		),
		'note' => array(
			'NOTICE_1'				=> 'php version > 5.4',
			'NOTICE_2'				=> 'phpBB 3.2 ready'
		)
	)
));
