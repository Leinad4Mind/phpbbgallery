<?php
/**
 *
 * HTML email extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2015 ForumHulp.com <http://forumhulp.com>
 * @copyright (c) 2026 Leinad4Mind <https://leinad4mind.top>
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
// ’ « » “ ” …
//

$lang = array_merge($lang, [
	'HTML_EMAIL_NOTICE'             => '<div class="phpinfo"><p class="entry">Configuration settings for this extension are not necessary.<br />Once enabled, all emails sent by the forum will automatically support HTML format. You can update your email templates to whatever you like.</p></div>',
	'ACP_HTMLEMAIL_TITLE'           => 'HTML Email Editor',
	'ACP_HTMLEMAIL_EXPLAIN'         => 'Here you can view and edit all email templates (.txt) from phpBB core and extensions. You can inject HTML code directly into these files.',
	'ACP_HTMLEMAIL_OVERVIEW'        => 'Overview',
	'ACP_HTMLEMAIL_FILTER'          => 'Filter templates...',
	'ACP_HTMLEMAIL_FILENAME'        => 'Filename',
	'ACP_HTMLEMAIL_ORIGIN'          => 'Origin',
	'ACP_HTMLEMAIL_LANGUAGE'        => 'Language',
	'ACP_HTMLEMAIL_STATUS'          => 'Format',
	'ACP_HTMLEMAIL_NO_TEMPLATES'    => 'No email templates found.',
	'ACP_HTMLEMAIL_EDIT'            => 'Edit Template',
	'ACP_HTMLEMAIL_PATH'            => 'Absolute Path',
	'ACP_HTMLEMAIL_RESTORE'         => 'Restore Original Backup',
	'ACP_HTMLEMAIL_RESTORE_CONFIRM' => 'Are you sure you want to restore the original backup? All changes will be lost.',
	'ACP_HTMLEMAIL_NOT_FOUND'       => 'The requested template could not be found.',
	'ACP_HTMLEMAIL_SAVED'           => 'Template saved successfully.',
	'ACP_HTMLEMAIL_SAVE_ERROR'      => 'Error saving the template. Please check file permissions.',
	'ACP_HTMLEMAIL_RESTORED'        => 'Original template restored successfully.',
	'ACP_HTMLEMAIL_RESTORE_ERROR'   => 'Error restoring the template. Backup might not exist or file is not writable.',
	'ACP_HTMLEMAIL_TAB_EDITOR'      => 'Editor',
	'ACP_HTMLEMAIL_TAB_PREVIEW'     => 'Preview',
	'ACP_HTMLEMAIL_TAB_SPLIT'       => 'Split View',
	'ACP_HTMLEMAIL_PREVIEW'         => 'Preview',
	'ACP_HTMLEMAIL_FULLSCREEN'      => 'Fullscreen Preview',
]);
