<?php
/*
* @package cBB Blockgets
* @version v2.0.2 12/01/2021
*
* @copyright (c) 2021 CaniDev
* @license https://opensource.org/licenses/gpl-license.php GNU Public License
*/

// @ignore
if(!defined('IN_PHPBB'))
{
	exit;
}

// Lists settings
define('LIST_CAT', 	0);
define('LIST_LINK', 1);

define('LIST_TYPE_NONE', 	0);
define('LIST_TYPE_ICON', 	1);
define('LIST_TYPE_IMAGE', 	2);

// Page settings
define('PAGE_HOME', 	0);
define('PAGE_FORUM', 	1);
define('PAGE_CUSTOM', 	2);

define('BOARD_BLOCK_NONE',			0);
define('BOARD_BLOCK_INDIVIDUAL',	1);
define('BOARD_BLOCK_SAME',			2);

define('BLOCK_STYLE_DEFAULT', 			1);
define('BLOCK_STYLE_ALTERNATIVE', 		2);
define('BLOCK_STYLE_CONTENT_FULL', 		3);
define('BLOCK_STYLE_CONTENT_SIMPLE', 	4);

define('BLOCK_COLLAPSE_NONE', 		0);
define('BLOCK_COLLAPSE_VISIBLE', 	1);
define('BLOCK_COLLAPSE_HIDDEN', 	2);

// Scroll settings
define('BLG_NO_SCROLL', 0);
define('BLG_SCROLL_H', 	1);
define('BLG_SCROLL_V', 	2);

// Other Settings
define('BLG_NOTICE_TIMEOUT',	2000);
define('BLG_RETURN_TIMEOUT',	900);

// Data Types
define('BLG_DATA_ATTACHMENT',	1);
define('BLG_DATA_EVENT',		2);

// Portal display types
define('TYPE_DOMAIN_HOME',			1);
define('TYPE_FORUM_HOME',			2);
define('TYPE_FORUM_SECONDARY',		3);

// Message Parser
define('BLG_FLAG_HTML', 8);

// Google API Key
define('BLG_GOOGLE_KEY', 'QUl6YVN5Qmx3MkFfWXBxNjlHTGFWa0VHMFJ1clppRFRLemstZS1r');

// Table names
define('BLG_BLOCK_TABLE',		$table_prefix . 'blockgets_blocks');
define('BLG_DATA_TABLE',		$table_prefix . 'blockgets_data');
define('BLG_PAGES_TABLE',		$table_prefix . 'blockgets_pages');
