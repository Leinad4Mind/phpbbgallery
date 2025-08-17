<?php
/**
*
* @package BBembed
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
	
	'SS_HELPER_NOTY'	            => 'SiteSplat BBcore does not exist!<br />Download the <a href="https://sitesplat.com" target="_blank">BBcore</a> and copy the BBcore folder into your sitesplat extension folder.',
	'SNAPPY_NOTICE'				    => '<div style="width:80%;margin:20px auto;"><p>There are no specific settings for this extension. Remember to enable the phpBB quick reply option in: <strong>%1$s &#187; %2$s &#187; %3$s "Allow quick reply".</strong><br />Please note, if you have the <a href="http://www.sitesplat.com/phpBB3/marketplace.php?mode=view&item_id=23" target="_blank">IMGUR</a> extensions installed you can also enable or disable the IMGUR option in quick reply.<br />The option is in: <strong>ACP &#187; General &#187; Board configuration &#187; Attachment settings "Allow IMGUR in Smart Snappy Reply"</strong></p></div>',
	
));

