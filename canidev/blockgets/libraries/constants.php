<?php
/**
 * @package cBB Blockgets
 * @version 2.0.7 01/07/2024
 *
 * @copyright (c) 2024 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 */

namespace canidev\blockgets\libraries;

class constants
{
	// Lists settings
	const LIST_CAT 		= 0;
	const LIST_LINK 	= 1;

	const LIST_TYPE_NONE 	= 0;
	const LIST_TYPE_ICON 	= 1;
	const LIST_TYPE_IMAGE 	= 2;

	// Page settings
	const PAGE_HOME 	= 0;
	const PAGE_FORUM 	= 1;
	const PAGE_CUSTOM 	= 2;

	// Block settings
	const BOARD_BLOCK_NONE 			= 0;
	const BOARD_BLOCK_INDIVIDUAL 	= 1;
	const BOARD_BLOCK_SAME 			= 2;

	const BLOCK_COLLAPSE_NONE 		= 0;
	const BLOCK_COLLAPSE_VISIBLE 	= 1;
	const BLOCK_COLLAPSE_HIDDEN 	= 2;

	// Block styles
	const BLOCK_STYLE_DEFAULT 			= 1;
	const BLOCK_STYLE_ALTERNATIVE 		= 2;
	const BLOCK_STYLE_CONTENT_FULL 		= 3;
	const BLOCK_STYLE_CONTENT_SIMPLE 	= 4;

	// Scroll settings
	const SCROLL_NONE 	= 0;
	const SCROLL_H 		= 1;
	const SCROLL_V 		= 2;

	// Data Types
	const DATA_ATTACHMENT 	= 1;
	const DATA_EVENT 		= 2;

	// Portal display types
	const TYPE_DOMAIN_HOME 		= 1;
	const TYPE_FORUM_HOME 		= 2;
	const TYPE_FORUM_SECONDARY 	= 3;

	// Message Parser
	const FLAG_HTML 	= 8;

	// Google API Key
	const GOOGLE_KEY 	= 'QUl6YVN5Qmx3MkFfWXBxNjlHTGFWa0VHMFJ1clppRFRLemstZS1r';
}
