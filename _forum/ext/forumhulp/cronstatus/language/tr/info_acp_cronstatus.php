<?php
/**
 *
 * @package       Cron Status
 * @copyright (c) 2014 - 2021 Igor Lavrov, John Peskens, Leinad4Mind
 * @license       http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
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
	'ACP_CRON_STATUS_TITLE'	=> 'Cron Durumu',
	'LOG_CORE_INSTALLED'	=> 'Files succesfully changed',
	'LOG_CORE_DEINSTALLED'	=> 'Files succesfully changed back',
	'LOG_CORE_NOT_REPLACED'	=> 'Could not replaced file(s)<br />» %s',
	'LOG_CORE_NOT_UPDATED'	=> 'Could not update file(s)<br />» %s',
	'FH_HELPER_NOTICE'		=> 'Forumhulp helper application does not exist!<br />Download <a href="https://github.com/ForumHulp/helper" target="_blank">forumhulp/helper</a> and copy the helper folder to your forumhulp extension folder.',
	'CRONSTAT_NOTICE'		=> '<div class="phpinfo"><p class="entry">This extension resides in %1$s » %2$s » %3$s.</p></div>',
));

// Description of Cron Status extension
$lang = array_merge($lang, array(
	'DESCRIPTION_PAGE'		=> 'Description',
	'DESCRIPTION_NOTICE'	=> 'Extension note',
	'ext_details' => array(
		'details' => array(
			'DESCRIPTION_1'		=> 'Cron İşleri genel bakışı(sıralamalı)',
			'DESCRIPTION_2'		=> 'Her Cron görevinin durumunu gösterir',
			'DESCRIPTION_3'		=> 'Herhangi bir görevi elle çalıştırabilirsiniz',
			'DESCRIPTION_4'		=> 'Reset cronlock with a simple click',
		),
		'note' => array(
			'NOTICE_1'			=> 'Cron Durumu Uyarısı (opsiyonel)',
			'NOTICE_2'			=> 'Site ayarlarında kapatılabilir',
			'NOTICE_3'			=> 'Switchable Run Cron Always',
			'NOTICE_4'			=> 'phpBB 3.2 ready'
		)
	)
));
