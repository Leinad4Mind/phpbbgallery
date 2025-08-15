<?php
/**
*
* @package BBSidebar
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
	// ACP
	'ACP_SIDEBAR_TITLE'					=> 'BBsidebar Settings',
	'AD_SIDEBAR_EXPLAIN'				=> 'Configure BBsidebar options and blocks. There are many configurations possible and with the use of the custom blocks there are no limits as it supports HTML. You can also choose to enable or disable completely the blocks for mobile and tablet devices.<br/> Please note, <strong>the blocks activity is cached for 5min</strong> to improve the server performance. In order to see immediate changes you will need to purge the forum cache from ACP > General : Purge the Cache.',
	
	'ACP_SIDEBAR_HEADSUP'				=> 'Heads up',
	'ACP_SIDEBAR_HEADSIP_EXPLAIN'		=> '<strong>Custom</strong> type block allows HTML to be used. <br /><strong>Staff online</strong> type block will show the staff online in the forum. Create a new users Group named "staff" under "Users and Groups" &#187; "Manage groups" &#187; "Create new group" and then enter the username of the people you would like to display as staff online for the block.<br /><strong>Hot topics</strong> type block follows the board setting for the "popular topic" under: "Posting" &#187; "Messages" &#187; "Post settings" &#187; "Popular topic threshold"<br /><strong>Other Blocks</strong> Other blocks type become available after the corresponding Premium addon has been enabled. You can find many premium addons here: <a href="https://sitesplat.com/phpBB3/marketplace.php"><strong>Marketplace</strong></a>.',
	
	'ACP_SIDEBAR_CONFIG'				=> 'BBsidebar',
	'ACP_SIDEBAR_OPTIONS'				=> 'BBsidebar options',
	'ACP_SIDEBAR_SETTINGS'				=> 'BBsidebar settings',
	'ACP_SIDEBAR_SAVED'					=> 'Changes Saved.',
	
	'ACP_SIDEBAR_SLOTS'					=> 'Sidebar Slot',
	'ACP_SIDEBAR_SLOTS_EXPLAIN'			=> 'Set how many slots you would you like to use. Maximum is 10',
	'ACP_SIDEBAR_SLOT' 					=> 'Active slot',
	
	'ACP_SIDEBAR_PANEL_PAGES'			=> 'View Sidebar in setting pages',
	'ACP_SIDEBAR_PANEL_PAGES_EXPLAIN'	=> 'Enable or disable the sidebar in the UCP, MCP and under registration pages',
	'ACP_SIDEBAR_ALL_PAGES'				=> 'View Sidebar in all pages',
	'ACP_SIDEBAR_ALL_PAGES_EXPLAIN'		=> 'Set to ON to have the side blocks display in any forum page, OFF to have the sidebar on index only. <br />(NOTE: BBsidebar is automatically disabled in the following extensions: BBdownloads, BBfront, BBgallery and BBclassifieds regardless of the on/off settings.)',
	'ACP_SIDEBAR_SHUFFLE'				=> 'Shuffle blocks',
	'ACP_SIDEBAR_SHUFFLE_EXPLAIN'		=> 'Set to ON to randomize the blocks at each page refresh',
	
	'ACP_SIDEBAR_WIDTH'			        => 'Sidebar width',
	'ACP_SIDEBAR_WIDTH_EXPLAIN'			=> 'Choose the default sidebar width',

	'ACP_SIDEBAR_HEIGHT' 				=> 'Dynamic height:',
	'ACP_SIDEBAR_HEIGHT_EXPLAIN' 		=> 'If the dynamic height set to ON the height of the forum will be calculated and the side blocks will <strong>never be longer</strong> then the forum',
	'ACP_SIDEBAR_HEIGHT_N' 				=> 'No',
	
	'ACP_SIDEBAR_WIDTH_15'				=> '15%',
	'ACP_SIDEBAR_WIDTH_20'				=> '20%',
	'HOWMANY'							=> 'How many records',
	'HOWMANY_EXPLAIN'					=> 'Set how many records you would like to display. Maximum is 10',
	'IGNORE'							=> 'Ignore',
	'IGNORE_EXPLAIN'					=> 'Exclude inactive users, admins and global moderators from the sidebar records. (NOT the blocks)',
	'IGNORE_USERS'						=> 'Ignore Inactive Users',
	'IGNORE_FOUNDER'					=> 'Ignore Founder(s)',
	'IGNORE_ADMINS_MODS'				=> 'Ignore Admins and Mods',
	
	'ACP_TITLE_SLOT'					=> 'Slot Title',
	'ACP_TITLE_SLOT_EXPLAIN'			=> 'Insert the title for the slot',
	'ACP_SIDEBAR_TEXT'					=> 'Insert the HTML code',
	'ACP_SIDEBAR_TEXT_EXPLAIN'			=> 'HTML code',

	'ACP_SIDEBAR_TYPE'					=> 'Sidebar Switch',
	'ACP_SIDEBAR_TYPE_EXPLAIN'			=> 'Show Sidebar Left or Right',
	'LEFT'								=> 'Left side',
	'RIGHT'								=> 'Right side',
	'SHOW_MOBILE'						=> 'Show on mobile',
	'SHOW_TABLET'						=> 'Show on tablet',
	'SHOW_TYPE'							=> 'Block type',
	
	'SIDEBAR_DESCRIPTION_PAGE'			=> 'Sidebar page',
	'SIDEBAR_DESCRIPTION_PAGE_OVERVIEW'	=> 'A sidebar in your forum, switchable and configurable',
	'SIDEBAR_DESCRIPTION_PAGE_STATUS'	=> 'Left - Right, Width and predefined blocks',
	'SIDEBAR_DESCRIPTION_PAGE_ABILITY'	=> 'Fully customizable',
	'SIDEBAR_DEVELOPERS'				=> 'Developers',
	
	'SIDEBAR_TYPE_NOT_EXIST'			=> 'The Sidebar type `%1$s` does not exist.',
	'NOTICE_BADGE'					    => 'The extension <a href="https://sitesplat.com/phpBB3/marketplace.php?mode=view&item_id=24"><strong>BBAwards</strong></a> is not installed, you can NOT use the BBAwards type block.',
	'NOTICE_BBDONATION'					=> 'The extension <a href="https://sitesplat.com/phpBB3/marketplace.php?mode=view&item_id=44"><strong>BBDonation</strong></a> is not installed, you can NOT use the Donations type block.',
	'NOTICE_BBMEMBERSHIP'				=> 'The extension <a href="https://sitesplat.com/phpBB3/marketplace.php?mode=view&item_id=31"><strong>BBMembership</strong></a> is not installed, you can NOT use the Membership type block.',
	'NOTICE_BBPOINTS'					=> 'The extension <a href="https://sitesplat.com/phpBB3/marketplace.php?mode=view&item_id=22"><strong>BBpoints</strong></a> is not installed, you can NOT use the BBpoints type block.',
	'NOTICE_BBREACTION'					=> 'The extension <a href="https://sitesplat.com/phpBB3/marketplace.php?mode=view&item_id=27"><strong>BBreaction</strong></a> is not installed, you can NOT use the BBreaction type block.',
	'NOTICE_LIKEDD'						=> 'The extension <a href="https://sitesplat.com/phpBB3/marketplace.php?mode=view&item_id=22"><strong>LikeBB</strong></a> is not installed, you can NOT use the LikeBB type block.',
	'NOTICE_NEWSLETTER'					=> 'The extension <a href="https://sitesplat.com/phpBB3/marketplace.php?mode=view&item_id=21"><strong>E-mail Subscribers</strong></a> is not installed, you can NOT use the E-mail Subscribers type block.',
	'NOTICE_BBDOWNLOAD'					=> 'The extension <a href="https://sitesplat.com/phpBB3/marketplace.php"><strong>BBdownloads</strong></a> is not installed, you can NOT use the Download type block.',
	'SIDEBAR_NOTICE'					=> '<div style="width:80%;margin:20px auto;"><p>The Setting for this extension are in <strong>%1$s » %2$s » %3$s</strong>.</p></div>',
	'SS_HELPER_NOTY'					=> 'The BBcore addon does not exist!<br />Download the <a href="#">BBcore</a> and copy the folder to your sitesplat extension folder.',
	
	'SIDEBAR_TYPE_BBPOINTS'				=> 'BBpoints',
	'SIDEBAR_TYPE_LAST_BADGES'			=> 'Last badges',
	'SIDEBAR_TYPE_LAST_BBREACTIONS'		=> 'Last BBreactions',
	'SIDEBAR_TYPE_LAST_MEMBERS'			=> 'Last members',
	'SIDEBAR_TYPE_LIKEDD'				=> 'Last likes',
	'SIDEBAR_TYPE_BIRTHDAY'				=> 'Birthday',
	'SIDEBAR_TYPE_CALENDAR'				=> 'Calendar',
	'SIDEBAR_TYPE_TOP_POSTERS'			=> 'Top posters',
	'SIDEBAR_TYPE_STAFF'				=> 'Staff online',
	'SIDEBAR_TYPE_DONATIONS'			=> 'Donations',
	'SIDEBAR_TYPE_MEMBERSHIP'			=> 'Membership',
	'SIDEBAR_TYPE_TOP_TOPICS'			=> 'Last topics',
	'SIDEBAR_TYPE_HOT_TOPICS'			=> 'Hot topics',
	'SIDEBAR_TYPE_CLOCK'				=> 'Clock',
	'SIDEBAR_TYPE_POLL'					=> 'Last poll',
	'SIDEBAR_TYPE_NEWSLETTER'			=> 'Newsletter',
	'SIDEBAR_TYPE_BBDOWNLOADS'			=> 'BBdownloads',
	
	'ONE_S'					            => 'S',
	'ONE_I'			                    => 'I',
	'ONE_D'								=> 'D',
	'ONE_E'								=> 'E',
	'ONE_B'			                    => 'B',
	'ONE_A'								=> 'A',
	'ONE_R'								=> 'R',
	
	
	'SITESPLAT_COM'		                => 'https://sitesplat.com',
	'SITESPLAT_COPY'		            => '&#169; SiteSplat',
	'LICENSE_INFO'		                => 'Proprietary - SiteSplat All rights reserved',
	'EXTENSION_DEVELOPER'			    => 'Developer',
	'ACP_SIDEBAR_NOTICE_CLOSE'			=> 'Close',
	
	'ACP_SIDEBAR_VERSION'		        => '1.4.4',
	'ACP_LOADING'		                => 'Loading... Hold on',
	
	'FORUM_CONTENT'		                => 'forum content',
	'SIDEBAR_DESCRIPTION_PAGE'			=> 'This extension adds a flexible multi-block system for your forum. Tons of options available and it comes with many modern blocks by default',
	'SIDEBAR_TASKS_1'				    => 'Modern Blocks',
	'SIDEBAR_TASKS_2'				    => 'Bootstrap grid system',
	'SIDEBAR_TASKS_3'				    => 'Ignore rules',
	'SIDEBAR_TASKS_4'				    => 'Fine tuning settings like mobile and tablet options',
	'SIDEBAR_TASKS_5'				    => 'Expandable with support for many Premium addons out of the box. Checkout the premium addons on <a href="https://sitesplat.com/phpBB3/marketplace.php">sitesplat.com/marketplace.php</a>',
	'SIDEBAR_TASKS_6'				    => 'Much more..!'
));