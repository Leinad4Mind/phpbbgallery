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
	'BULK_EMAILS'				=> 'E-mails',
	'BULK_EMAILS_EXPLAIN'		=> 'By checking this checkbox you agree that administrators of this board are allowed to send emails to you. Acceptance is required in order to allow registration. E-mails are needed as forum activation or other important security emails are sent out to users.',

	'PRIVACY_POLICY_EXPLAIN'	=> 'By checking this checkbox you confirm that you agree to Privacy Policy of this board which was just displayed on the terms page. You can also find the Privacy Policy once you logged-in. Acceptance is required in order to allow registration.',

	'REG_UNDRSTD'	        	=> 'I understand and Agree',
	
	'AGREEMENTS_REQUIRED'		=> 'You must agree to Bulk emails (It\'s not Spam) and Privacy Policy',
));
