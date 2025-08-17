<?php
/**
*
* @package Check mail
* @copyright (c) 2016 ForumHulp.com <http://forumhulp.com>
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
	'ACP_CHECKMAIL'				=> 'Check mail',
	'ACP_CHECKMAIL_SETTINGS'	=> 'Check mail',
	'ACP_CHECKMAIL_EXPLAIN'		=> 'Check mail checks mailaddresses for a valid domain and mx-record, communication report for every member.<br />Checkmail checks periodically for emailaddresses of your members.',
	'EMAIL_STATUS'				=> 'Email status',
	'CHECK_STATUS'				=> 'Check',
	'CHECK_MAIL_ADDRESS'		=> 'Check Email address',
	'CHECKMAIL_USERS'			=> 'Checked users',
	'CHECKMAIL_TOTAL'			=> 'Total users',
	
	'EMAIL'			=> 'Email &lt;',
	'EXIST'			=> '&gt; exist!',
	'VALID'			=> '&gt; valid, but not exist!',
	'NOT_VALID'		=> '&gt; not valid and doesn\'t exist!',
	
	'FH_HELPER_NOTICE'	=> 'Forumhulp helper application does not exist!<br />Download <a href="https://github.com/ForumHulp/helper" target="_blank">forumhulp/helper</a> and copy the helper folder to your forumhulp extension folder.',
	'CHECKMAIL_NOTICE'	=> '<div class="phpinfo"><p class="entry">This extension resides in %1$s » %2$s » %3$s.</p></div>',
));

// Description of Donations extension
$lang = array_merge($lang, array(
	'DESCRIPTION_PAGE'		=> 'Description',
	'DESCRIPTION_NOTICE'	=> 'Extension note',
	'ext_details' => array(
		'details' => array(
			'DESCRIPTION_1'	=> 'Overview of users emailaddresses',
			'DESCRIPTION_2'	=> 'Manual and periodic check',
			'DESCRIPTION_3'	=> 'Communication report',
			'DESCRIPTION_4'	=> 'Sorting',
		),
		'note' => array(
			'NOTICE_1'		=> 'phpBB 3.2 ready'
		)
	)
));
