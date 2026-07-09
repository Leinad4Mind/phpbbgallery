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
	'ACP_BBGDPR'				=> 'BBgdpr',
	'ACP_BBGDPR_EXPLAIN'		=> 'Remember to check the group permission for allowing users to delete their posts when they delete their accounts (it\'s disabled by default and the deleted account username will be replaced by an automated random generated username). <br/>You can also review user acceptance dates under ACP &#62; Users and Groups: Manage Users.<br /> A log of users deletion is also recorded under ACP &#62; Maintenance: user logs.',
	'GDPR'						=> 'GDPR',
	'DELETED_USERS'				=> 'Total of users who deleted their account under GDPR: <strong>%d</strong>.<br />',

	'SS_HELPER_NOTY'	        => 'SiteSplat BBcore does not exist!<br />Download the <a href="https://sitesplat.com" target="_blank">BBcore</a> and copy the BBcore folder into your sitesplat extension folder.',
	'BBGDPR_NOTICE'	            => '<div class="phpinfo"><p>The settings for this extension are under the "EXTENSIONS" tab.<br /> There are also other settings in various locations: <br />&#45;Group permission <br />&#45;ACP &#62; Users and Groups: Manage Users <br />&#45;ACP &#62; Maintenance: user logs<br />&#45; UCP &#62; Privacy<br />Finally make sure to review the privacy template right away to make sure it represents correctly your forum.</p></div>',
	
	'ACP_GDPR_SETTINGS_SAVED'	=> 'GDPR setting has been saved.',

	'PRIVACY_POLICY'			=> 'Privacy Policy',
	'PRIVACY_POLICY_EXPLAIN'	=> 'Content entered here will be displayed to all users to accept your policy as required by GDPR. You can use HTML.<br />Please note, everytime you edit this form the GDPR acceptance date will be reset and required to accept again for all users. This is so to make it easier for the Admins to enforce again the GDPR policy when an update occurs.<br /> Make sure to review the default policy right away as it is for general forums coverage and it might not be a good fit for your forum.',

	'COOKIES_BANNER'					=> 'Cookies EU banner',
	'TRACKING_CODES'					=> 'Tracking codes',
	'TRACKING_CODES_EXPLAIN'			=> 'Paste all tracking codes you use for analytics and/or other purposes here without <samp>&lt;script&gt;</samp> tag wrapping it, separated by blank line. Codes will be executed only for users who accept cookies that such services generate (IE: Google Analytics).',
	'SITESPLAT_BBGDPR_ADSENSE'			=> 'AdSense code',
	'SITESPLAT_BBGDPR_ADSENSE_EXPLAIN'	=> 'Paste your AdSense code which will be included only when user accepted cookies. (See more info here: <a href="https://support.google.com/adsense/answer/9007336" target="_blank">EU user consent controls in AdSense</a> ) <br>Use the following code: <br><code>&#x3C;!-- IF S_GDPR_JS_ALLOWED --&#x3E;{{ GDPR_ADSENSE }}&#x3C;!-- ENDIF --&#x3E;</code> in your premium theme like FLATBOOTS templates to display it.<br> If you have the Mini CMS installed you could also modify it to use the code like this for example: <br><code> &#x3C;!-- IF ADSENSE_FOOTER neq &#x27;&#x27; --&#x3E;&#x3C;!-- IF S_GDPR_JS_ALLOWED --&#x3E;&#x3C;div class=&#x22;clearfix text-center&#x22;&#x3E;{ADSENSE_FOOTER}&#x3C;/div&#x3E;&#x3C;!-- ENDIF --&#x3E;&#x3C;!-- ENDIF --&#x3E;</code>',
	'SITESPLAT_BBGDPR_GEOIP'			=> 'Use GeoIP location service to determine EU citizens',
	'SITESPLAT_BBGDPR_GEOIP_EXPLAIN'	=> 'This will allow locating users by their IP address in order to display Cookies EU banner only to EU citizens. Note that this location service is imprecise and can result in wrong detection of the user location. Also, IP lookup is a load-sensitive task which may slow down the server.',

	'SITESPLAT_BBGDPR_DELETE_KEEP_USERNAME'			=> 'Keep username when deleting account',
	'SITESPLAT_BBGDPR_DELETE_KEEP_USERNAME_EXPLAIN'	=> 'Set to No to generate random username which will replace current username when user deletes their account.',
	'SITESPLAT_BBGDPR_ACCEPT_OLD_USERS'				=> 'Force GDPR page for existent users only',
	'SITESPLAT_BBGDPR_ACCEPT_OLD_USERS_EXPLAIN'		=> 'There is no need for new users to be forced as these user already accepted on registration page. Set to No to force all users to accept GDPR page.',
	'SITESPLAT_BBGDPR_REQUEST_DELETE'				=> 'Type of deletion',
	'SITESPLAT_BBGDPR_REQUEST_DELETE_EXPLAIN'		=> 'Set to Request to receive an PM from user who wants to delete their account. Otherwise users will be able to delete their account themselves.',
	'REQUEST_DELETE'								=> 'Request',
	'SELF_DELETE'									=> 'Self',

	'LOG_USER_REJECTED_PRIVACY'	=> '<strong>Rejected new privacy policy.</strong><br>» Previous acceptance date: %s',
));
