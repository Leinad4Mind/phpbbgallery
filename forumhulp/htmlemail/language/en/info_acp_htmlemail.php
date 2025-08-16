<?php
/**
*
* HTML email extension for the phpBB Forum Software package.
*
* @copyright (c) 2015 ForumHulp.com <http://forumhulp.com>
* @license GNU General Public License, version 2 (GPL-2.0)
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
// ’ « » “ ” …
//

$lang = array_merge($lang, array(
	'FH_HELPER_NOTICE'		=> 'Forumhulp helper application does not exist!<br />Download <a href="https://github.com/ForumHulp/helper" target="_blank">forumhulp/helper</a> and copy the helper folder to your forumhulp extension folder.',
	'HTML_EMAIL_NOTICE'		=> '<div class="phpinfo"><p class="entry">Config setting of this extension are not necessary.<br />You can use it for email on birthday extension by switching on "use html in email" in Board features. Do you want to use html in other mails you have to let know messenger it should send html emails by configure messenger with $messenger->set_mail_html(true). Update your mail-templates to whatever you like.</p></div>',
	'DELETE_DATA_NOTICE'	=> '<div style="width:80%;margin:20px auto;"><p style="text-align:left;">Not all files are replaced ! Please replace by hand the file(s) mentioned in the Admin log</p></div>',
	'ENABLE_DATA_NOTICE'	=> '<div style="width:80%;margin:20px auto;"><p style="text-align:left;"><br />However not all updates are done properly because of file permissions or missing files. See admin log for a overview.<br /><br />Please update files by hand to enjoy all functions !</p></div>'
));

