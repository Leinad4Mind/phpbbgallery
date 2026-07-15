<?php
/**
*
* @package BBgdpr
* @copyright (c) 2018 SiteSplat All rights reserved
* @license Proprietary
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
	'UCP_PRIVACY'	=> 'Privacy',

	'UCP_REVIEW'				=> 'Review personal data',
	'UCP_REVIEW_EXPLAIN'		=> 'Below you will find the details of your personal data that we store on this site. Don\'t forget to check the profile tab here to see other personal information.',
	'REG_DATE'					=> 'Registration date and time',
	'COOKIE_CHANGED_MIND'		=> 'Changed your mind? <a href="%s">Accept cookies</a>.',
	'REG_IP'					=> 'Registration IP',
	'USER_IPS'					=> 'IP addresses that you have used',

	'UCP_DOWNLOAD'				=> 'Download data',
	'UCP_DOWNLOAD_EXPLAIN'		=> 'Below you can download all data this board stores about you or your posts only. You will be provided with a ZIP file containing <samp>posts/</samp> directory with another subdirectories structured like this: first directory is forum ID, inside are other subdirectories named after topic ID in this forum. Inside these directories are HTML files named as UNIX timestamp of time when you created the post. If you choose to download all your data, you will be provided with another file named <samp>personal.txt</samp> where you can find all personal data that this board stores about you.',
    'UCP_DOWNLOAD_BTN_POSTS'	=> 'Download Posts',
	'UCP_DOWNLOAD_BTN_DATA'		=> 'Download your Personal Data',
	'UCP_USER_NO_POSTS'			=> 'You don\'t have any posts to download.',
	
	'UCP_DELETE'				=> 'Delete account',
	'CANNOT_DELETE_ACCOUNT'		=> 'You cannot delete your account because you are a founder of this board.',
	'DELETE_MY_ACCOUNT_TEXT'	=> 'You can use this form to delete your own account. Once completed all your personal and private data will be removed from this site and you will no longer be able to login.',
	'REALY_DELETE'				=> 'I really wish to delete my account.',
	'UNDERSTAND_DELETE'			=> 'I understand that this action can not be undone.',
	'DELETE_MY_POSTS'			=> 'Also delete my posts (posts will become guest posts with random fake name if unchecked).',
	'ENTER_PASSWORD'			=> 'Enter your password',
	'ENTER_PASSWORD_EXPLAIN'	=> 'This is the same password you are currently using for your account.',
	'ENTER_PASSWORD_HERE'		=> 'type your password here ...',
	'DELETE_FINAL'				=> 'Final Confirmation',
	'DELETE_FINAL_CONFIRM'		=> '<p>Thank-you for being a member of this site. We are sorry to see you go.</p><p>Your account deletion request has been validated. This is a final confirmation and cannot be undone. Are you sure you want to permanently delete your account?</p>',

	'FOUNDER_ERROR'				=> 'Founders can not use the self deletion process.',
	'REALLY_ERROR'				=> 'You must confirm that you really wish to delete your account.',
	'UNDERSTAND_ERROR'			=> 'You must confirm that you understand that this process can not be undone.',
	'PASSWORD_ERROR'			=> 'The password that you entered was not correct.',
	'GOODBYE_ERROR'				=> 'Your account has been deleted.',

	'REQUEST_FOR_DELETION_SUBJECT'	=> 'Request for account deletion - GDPR',
	'REQUEST_FOR_DELETION_BODY'		=> 'I request to delete my account.',
	'DELETE_REQUEST_REALLY'			=> 'Final Confirmation',
	'DELETE_REQUEST_REALLY_CONFIRM'	=> '<p>Thank-you for being a member of this site. We are sorry to see you go.</p><p>Your account deletion request has been validated. This is a final confirmation. Are you sure you want request Administrators of this board to permanently delete your account?</p>',
	'REQUEST_FOR_DELETION_SENT'		=> 'Your request has been successfully sent to the Administrators. They will handle your request as soon as possible.',
));
