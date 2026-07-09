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
	// used both in ACP and/or UCP and/or all pages
	'BBGDPR_TITLE'	        => 'GDPR',
	'BBGDPR_PRIVACY_POLICY'	=> 'GDPR - General Data Protection Regulation',
	'BBGDPR_ACCEPTED'	    => 'Accepted on',
	'PRIVACY_ACCEPT_DATE'	=> 'Privacy policy acceptance date',
	'COOKIE_ACCEPT_DATE'	=> 'Cookie policy acceptance date',
	'NOT_ACCEPTED'			=> 'Policy has not been accepted',
	'MCP_ACCEPT_DATE'		=> 'GDPR guidelines review date for MCP',
	'LOG_USER_DELETED'		=> 'User %s (ID %s) has deleted their own account. ',
	'LOG_POST_RETAINED'		=> 'Their posts were retained.',
	'LOG_POST_REMOVED'		=> 'Their posts were removed.',
	'LOG_NO_POSTS'			=> 'They had no posts.',

	'LOG_USER_DELETED_RETAINED'		=> '<strong>Deleted user via GDPR</strong><br />» User %s (ID %s) has deleted their own account. Their posts were retained.',
	'LOG_USER_DELETED_REMOVED'		=> '<strong>Deleted user via GDPR</strong><br />» User %s (ID %s) has deleted their own account. Their posts were removed.',
	'LOG_USER_DELETED_NO'			=> '<strong>Deleted user via GDPR</strong><br />» User %s (ID %s) has deleted their own account. They had no posts.',
	
	// notification
	'SITESPLAT_BBGDPR_USER_DELETED'		=> 'User %s deleted their account.',
	'NOTIFICATION_TYPE_BBGDPR'	    	=> 'A User deletes their account under GDPR',

	// cookies
	'COOKIE_CONSENT'			=> 'By continuing your visit to this site, you accept the use of cookies.',
	'REJECT_BBGDPR_COOKIE'		=> 'Reject',
	'ACCEPT_BBGDPR_COOKIE'		=> 'I Accept Cookie Usage',
	'ACCEPT_GDPR'	   			=> 'I Accept GDPR Policy',
	'REJECT_GDPR'				=> 'Reject (You will be logged-out)',
	// mcp
	'GDPR_REVIEW'			=> 'GDPR guidelines review',
	'GDPR_NOT_REVIEWED'		=> 'In order to access MCP, you need to confirm you have reviewed the GDPR guidelines. Review the GDPR guidelines: <a href="https://gdpr-info.eu/">https://gdpr-info.eu/</a>',
	'GDPR_REVIEW_CONFIRM'	=> 'I confirm to have reviewed the GDPR guidelines',
	'MCP_ACCEPT_FIRST'		=> 'In order to access MCP, you need to confirm you have reviewed the GDPR guidelines. Please, <a href="%s">confirm it before you perform any moderator action</a>.',

	// privacy
	'BBGDPR_LAST_UPDATED'	=> 'Last updated: %s',
	'BBGDPR_GDPR_ACCEPTED'	=> 'Previously accepted on ',
	'REVIEW_PERSONAL_DATA'	=> 'Review your personal data',
	'REACCEPT_COOKIE'		=> 'Looks like you previously rejected the cookie policy. Changed your mind?',
));
