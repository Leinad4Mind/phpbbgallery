<?php
/**
*
* BBcodeOrder+
* @copyright (c) 2016 SiteSplat All rights reserved
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
	'BBCODEORDER_EXPLAIN'		=> '<hr><h3>Usage And Tips:</h3> <br /><strong>Default BBCode:</strong> Default bbcodes have new options, like the possibility to be sorted or be hidden. Unfortunately they cannot be edited directly from here like the custom BBCodes<br /><strong>Custom BBcodes:</strong> Custom BBcodes can also be sorted, have a custom icon, set group permission etc. <br /><strong>General Use:</strong> You can add "dividers", which basically divide button groups. They are marked as "-" and you can add as many of them as you like and can also be moved/sorted.(you can use drag&drop as well) <br /> You can create different button groups or single buttons. <br />There is also a special divider marked as "--", which marks the start of the selectbox in the front-end. <br />Any bbcode ordered below this special divider will be displayed in the selectbox option, yes even default bbcodes :-). Color and font are the exceptions, because you cannot place a selectbox into a selectbox. <br /> Flash and Font-size are usually just a clutter and ideally would be better to have them hidden to have more room for other elements.<br /> <a href="http://sitesplat.com/phpBB3/marketplace.php?mode=view&item_id=11" target="blank" title="">Smart Snappy Reply</a> is natively supported as well.',
	'NEW_DIVIDER'				=> 'Add a new divider',
	'HIDE'						=> 'Hide',
	'SHOW'						=> 'Show',
	'BBCODE_HIDDEN'				=> 'The BBCode has been hidden.',
	'BBCODES_ORDERED'			=> 'The BBCode order has been updated.',
	'BBCODES_DIVIDERS_PROBLEM'	=> 'You cannot position divider after selectbox start.',
	'BBCODE_ICON'				=> 'Icon',
	'BBCODE_ICON_EXPLAIN'		=> '<a href="http://fontawesome.io/icons/">Font Awesome icon</a> without fa- prefix.',
	'BBCODE_GROUP'				=> 'Manage groups that can use this BBCode',
	'BBCODE_GROUP_EXPLAIN'		=> 'If no groups are selected, then all users can use this BBCode. Use CTRL+CLICK (or CMD+CLICK on Mac) to select/deselect more than one group.',
	'BBCODEORDER_IMGUR_UPLOAD'	=> 'Click to upload to IMGUR',
	
	'BBCODE_B'						=> 'Bold',
	'BBCODE_I'						=> 'Italic',
	'BBCODE_U'						=> 'Underline',
	'BBCODE_L'						=> 'List',
	'BBCODE_O'						=> 'List Ordered',
	'BBCODE_LISTITEM'				=> 'List Item',
	'BBCODE_C'						=> 'Code',
	'BBCODE_Q'						=> 'Quote',
	'BBCODE_IMG'					=> 'Image',
	'BBCODE_URL'					=> 'URL',
	'BBCODE_FLASH'					=> 'FLASH',
));
