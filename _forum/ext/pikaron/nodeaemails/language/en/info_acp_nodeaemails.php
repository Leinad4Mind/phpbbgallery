<?php
/**
 *
 * No DEA Emails extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2019 Picaron
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

$lang = array_merge($lang, array(
		'ACP_NO_DEA_EMAILS'					=> 'No DEA Emails',
		'ACP_NO_DEA_EMAILS_EXPLAIN'			=> 'This extension prevents the registration of a user in the forum when a disposable or temporary e-mail account is used <a href="https://bit.ly/2LBsbqe" target="_blank">(DEA)</a>.',
		'ACP_NO_DEA_EMAILS_WARNING_CRON'	=> 'In this section, the CRON status data is obtained.<br>- The option to define the time interval for execution of the CRON is enabled.<br>A relation of the DEA-type Email domains is shown with which they will be filtered in forward the Email Accounts of the Users of the forum.',
		'ACP_NO_DEA_EMAILS_WARNING_LOCAL'	=> 'In this section you can manage (include/remove) locally domains of disposable or temporary e-mail accounts <a href="https://bit.ly/2LBsbqe" target="_blank">(DEA)</a>.<br><br>Special attention should be paid, because if a valid domain is included, we will prevent users from using it to register.<br><i>Example: If we register the domain "gmail.com" we will leave all our users without being able to use email accounts of Google.</i> ',
		'ACP_NO_DEA_EMAILS_WARNING_USERS'	=> 'This section collects information on all Forum Users who have a Disposable Email <a href="https://bit.ly/2LBsbqe" target="_blank">(DEA)</a> associated with their account.<br><br>We can <strong>DELETE COMPLETELY</strong> the users that are selected.<br>(Including all their published messages)<br><br><strong>ATTENTION:<br>This action is NOT REVERSIBLE, be careful when using this option if your forum is in production.</strong>',
		'ACP_NO_DEA_EMAILS_SETTINGS'		=> 'CRON Management & External DEA Mail Domains',
		'ACP_NO_DEA_EMAILS_LOCALS'			=> 'Local Management of Mail Domains DEA',
		'ACP_NO_DEA_EMAILS_USERS'			=> 'Users with DEA Mail Accounts',
		'ACP_SUBMIT_DELETE'					=> 'Apply Changes',
		'LOG_CONFIG_CONFIGURATION'			=> '<strong>Updated Configuration Extension “No DEA Emails”</strong>',
		'LOG_CONFIG_USERS'					=> '<strong>Users DELETED from “No DEA Emails”</strong>',
		'LOG_FORCE_CHG_EMAIL'				=> '<strong>No DEA Emails</strong><br>» %s',
		'LOG_FORCE_USERS_CHG_EMAIL'			=> '<strong>MARKED Users to FORCE CHANGE of Email</strong>',
		'LOG_FORCE_USERS_NO_CHG_EMAIL'		=> '<strong>UNMARKED Users to FORCE CHANGE of Email</strong>',
		'LOG_FORCE_USER_CHG_EMAIL'			=> 'User MARKED to FORCE CHANGE of Email',
		'L_NO_DEA_EMAILS_DELAY'				=> 'Interval for execution of the CRON',
		'L_NO_DEA_EMAILS_DELAY_EXPLAIN'		=> '(Minimum: 300 Seconds, Maximum: 86400 Seconds = 1 Day)',
		'L_DEA_DELAY'						=> 'Seconds',
		'L_DEA_DELAY_MIN'					=> 'Minutes',
		'L_NO_DEA_EMAILS_VERSION'			=> 'Extension Version: ',
		'L_NO_DEA_EMAILS_CONFIG'			=> 'CRON Configuration Options',
		'L_NO_DEA_EMAILS_TEX'				=> 'Email Domains “DEA” collected through CRON',
		'L_NO_DEA_EMAILS_TEX_LOCAL'			=> 'Email Domains “DEA” collected Locally',
		'L_NO_DEA_EMAILS_COUNTER'			=> 'Execution of the CRON',
		'L_NO_DEA_EMAILS_TIMES'				=> 'Since the installation of the extension, the CRON has been executed <strong>%s</strong> times.',
		'L_NO_DEA_EMAILS_DATE'				=> 'Last execution of the CRON',
		'L_NO_DEA_EMAILS_USERS'				=> 'User Management with DEA Email Accounts',
		'L_NO_DEA_EMAILS_TOT_USERS'			=> 'Total Registered Users',
		'L_NO_DEA_EMAILS_TOT_USERS_EXPLAIN'	=> 'Including Bots and inactive users.',
		'L_NO_DEA_EMAILS_DEA_USERS'			=> 'Total Users with DEA Email Accounts',
		'L_NO_DEA_EMAILS_DOMAIN'			=> 'Disposable Email Domain',
		'L_NO_DEA_EMAILS_PLACE'				=> 'Enter a Disposable Email Domain',
		'L_NO_DEA_EMAILS_ACTION'			=> 'Action',
		'L_NO_DEA_EMAILS_SAVE'				=> 'Save',
		'L_NO_DEA_EMAILS_DEL'				=> 'Delete',
		'L_NO_DEA_EMAILS_DOM_SAVE'			=> 'The DEA Email Domain has been SAVED correctly: <strong>((%s))</strong>',
		'L_NO_DEA_EMAILS_DOM_DEL'			=> 'The DEA Email Domain has been DELETED correctly: <strong>((%s))</strong>',
		'L_NO_DEA_EMAILS_DOM_VALID'			=> 'The DEA Email Domain: <strong>((%s))</strong> is not valid.',
		'L_NO_DEA_EMAILS_DOM_LOCATE'		=> 'The DEA Email Domain has not been located: <strong>((%s))</strong>.',
		'L_NO_DEA_EMAILS_CANNOT_FOUNDER'	=> 'It is not allowed to eliminate the founder accounts..<br><br>User <strong>%s</strong> can not be deleted.',
		'L_NO_DEA_EMAILS_CANNOT_YOURSELF'	=> 'You can not delete your own account.',
		'L_NO_DEA_EMAILS_DEL_USERS'			=> 'Basic tools',
		'L_NO_DEA_EMAILS_DEL_USERS_EXPLAIN'	=> 'Please note that the deletion of a user is final, it can not be recovered. Private messages sent by the unread user will be deleted and will not be available to their recipients.',
		'L_NO_DEA_EMAILS_FORCE_CHG_EMAIL'	=> 'Force change of “Email”',
		'L_NO_DEA_EMAILS_N_FORCE_CHG_EMAIL' => 'DO NOT Force change of “Email”',
		'L_NO_DEA_EMAILS_SEND_PM'			=> 'Send Private Message',
		'L_NO_DEA_EMAILS_RETAIN_POSTS'		=> 'DELETE USER and Hold Your Messages',
		'L_NO_DEA_EMAILS_REMOVE_POSTS'		=> 'DELETE USER and Delete Your Messages',
		'L_NO_DEA_EMAILS_NEED_ACTION'		=> 'You must select a “Basic Tool”.',
		'L_NO_DEA_EMAILS_NO_USERS'			=> 'No Users selected',
		'L_NO_DEA_EMAILS_PERCENTAGE'		=> '<i>(%s &#37; of Total Registered Users)</i>',
));
