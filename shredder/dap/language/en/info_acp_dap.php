<?php

/**
*
* info_acp_dap [English]
*
* @package Double Account Preventer
* @copyright (c) 2014 www.phpbb-work.ru
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
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
	'ACP_CAT_DAP_MOD'						=> 'Double Account Preventer',
	'ACP_DAP_ADD_NAME'						=> 'Add user to',
	'ACP_DAP_ADD_TO_BLACKLIST'				=> 'Blacklist',
	'ACP_DAP_ADD_TO_WHITELIST'				=> 'Whitelist',
	'ACP_DAP_ADD_TO_EXCLUSION'				=> 'Exclusion',
	'ACP_DAP_BLACKLIST'						=> 'Ban by Cookie',
	'ACP_DAP_BLACKLIST_EXPLAIN'				=> 'From here you can ban users by Cookie.<br />Red username color means blacklisted user. When user logs in under red name, this extension creates a special cookie on userвЂ™s browser, and if it exists, the user cannot view the forum under this <strong>browser</strong>. Green username color means user in the whitelist: when user logs in under green name, ban cookie removes from userвЂ™s browser. Blue username color means an exception from ban check. <strong>Note:</strong> if the user denied cookie acceptance in his browser, then cookie ban wonвЂ™t work on him. But under blacklisted name he canвЂ™t log in anyway.',
	'ACP_DAP_BLACKLIST_UPDATED'				=> 'The banlist has been updated successfully.',
	'ACP_DAP_COOKIE_BAN'					=> 'Ban one or more usernames',
	'ACP_DAP_COOKIE_BAN_EXPLAIN'			=> 'You can ban multiple users in one go by entering each name on a new line. Use the В«Find a memberВ» facility to look up and add one or more users automatically.',
	'ACP_DAP_COOKIE_BAN_SETTINGS'			=> 'Cookie Ban Settings',
	'ACP_DAP_COOKIE_UNBAN'					=> 'Un-ban or un-exclude usernames',
	'ACP_DAP_COOKIE_UNBAN_EXPLAIN'			=> 'You can unban (or un-exclude) multiple users in one go using the appropriate combination of mouse and keyboard for your computer and browser.',
	'ACP_DAP_DELETE_BY_TIME'				=> 'Delete entries older than',
	'ACP_DAP_DELETE_FROM_BLOCKLIST'			=> 'Delete from block list',
	'ACP_DAP_DELETE_USER'					=> 'Delete user',
	'ACP_DAP_DUPE_LOG'						=> 'Suspicious auths log',
	'ACP_DAP_DUPE_LOG_EXPLAIN'				=> 'When cookie check enabled, here is list of events when user logs in with other userвЂ™s data in cookie of his browser, which may indicate a duplicate account or illegal auth. This can help track duplicates already registered on your forum. If the user attempts to authenticate while he is present in the cookie blocking list, you will see his current status under nickname in left column.',
	'ACP_DAP_DUPE_USER_LIST'				=> 'Duplicate Users List',
	'ACP_DAP_DUPE_USER_LIST_EXPLAIN'		=> 'List of all users marked at registration as duplicate accounts.<br /><strong>Please note:</strong> IP detection method does not guarantee that the revealed user is user of same computer as his common names, because some networks has a different computers with same IP. <strong>Cookie</strong> detection method gives almost full guarantee in case of finding matches. Read <a href="http://www.phpbb-work.ru/double-account-preventer-ext-t92.html">here</a> for more info (Russian only).',
	'ACP_DAP_EXCLUDES_MANAGE'				=> 'Suspicious logвЂ™s exclusions management',
	'ACP_DAP_EXCLUDE_USERS'					=> 'Users to exclude',
	'ACP_DAP_EXCLUDED_USERS'				=> 'Excluded pairs',
	'ACP_DAP_EXCLUDED_USERS_EXPLAIN'		=> 'Record &laquo;user1 - user2&raquo; is identical to the record &laquo;user2 - user1&raquo;. Use suitable combinations of the keyboard and the mouse to choose and delete at once some pairs from the list.',
	'ACP_DAP_EXCLUDED_USERS_LIST'			=> 'Exclusions list',
	'ACP_DAP_FORUM_ID_ERROR'				=> 'Too many forums selected. Try to select less.',
	'ACP_DAP_NO_EXCLUDES'					=> 'Exclusions list is empty',
	'ACP_DAP_NO_MATCHES'					=> 'No records to delete were found.',
	'ACP_DAP_NO_USERS_SELECTED'				=> 'No selected pairs for deletion.',
	'ACP_DAP_NOTIFICATIONS'					=> 'Notification Settings',
	'ACP_DAP_NOTIFICATIONS_EXPLAIN'			=> 'Configure Double Account Preventer notifications.',
	'ACP_DAP_NO_PERMISSIONS'				=> 'You donвЂ™t have the required permissions to perform this operation.',
	'ACP_DAP_PM_NOTIFICATION'				=> 'PM Notifications',
	'ACP_DAP_POST_NOTIFICATION'				=> 'Post notifications',
	'ACP_DAP_QUICK_ACTIONS'					=> 'Quick actions',
	'ACP_DAP_SAVED_SETTINGS'				=> 'Double Account Preventer Settings saved.',
	'ACP_DAP_SETTINGS'						=> 'Double Account Preventer Settings',
	'ACP_DAP_SETTINGS_EXPLAIN'				=> 'Configure the various checks to prevent double accounts.<br />Extension Version: <strong>%s</strong>. See <a style="font-weight: bold;" href="http://www.phpbb-work.ru/double-account-preventer-ext-t92.html" onclick="window.open(this.href);return false;">support page</a> for the latest version or to get help with this extension.',
	'ACP_DAP_SETTINGS_UPDATED'				=> '<strong>Altered Double Account Preventer settings</strong>',
	'ACP_DAP_USER_ID_ERROR'					=> 'User with entered ID doesnвЂ™t exist.',
	'ACP_DAP_USERNAME'						=> 'Username / Ban Status',
	'ACP_DAP_USER_DELETED'					=> 'User successfully deleted',

	'BAN_TRIGGERED_BY_DAP'					=> 'A ban has been issued on your username.',

	'CANNOT_REMOVE_ANONYMOUS'				=> 'You are not able to remove the guest user account.',
	'CANNOT_REMOVE_FOUNDER'					=> 'You are not allowed to remove founder user account.',
	'CANNOT_REMOVE_YOURSELF'				=> 'You are not allowed to remove your own user account.',

	'COOKIE_CHECK_REGISTRATION'				=> 'Cookie check',
	'COOKIE_CHECK_REGISTRATION_EXPLAIN'		=> 'Searches for a cookie with other userвЂ™s data on the userвЂ™s browser at registration and login. If it exists, the user will be marked as duplicate account.',

	'DAP_ALERT_USER_ID'						=> 'Alert user ID',
	'DAP_ALERT_USER_ID_EXPLAIN'				=> 'User ID to use to send post notifications and PMs. Only use one user ID.',
	'DAP_CANNOT_BAN_ANONYMOUS'				=> 'You are not allowed to ban anonymous account.',
	'DAP_CANNOT_BAN_BOT'					=> 'You are not allowed to ban bot account.',
	'DAP_CANNOT_BAN_FOUNDER'				=> 'You are not allowed to ban founder account.',
	'DAP_CANNOT_BAN_YOURSELF'				=> 'You are not allowed to ban yourself.',
	'DAP_CONTACT_ADMIN_MESSAGE'				=> 'Please contact the %2$sBoard Administrator%3$s for more information.',
	'DAP_COOKIE_AUTOBAN_ENABLED'			=> 'Enable AutoBan',
	'DAP_COOKIE_AUTOBAN_ENABLED_EXPLAIN'	=> 'If user logs in or register under not banned username with banned cookie on his browser and username is not in exclusions or whitelist, the new account will be automatically added in the Blackist.',
	'DAP_COOKIE_BAN_ENABLED'				=> 'Enable Cookie Ban',
	'DAP_COOKIE_BAN_ENABLED_EXPLAIN'		=> 'Enables or disables Cookie Ban features.',
	'DAP_COOKIE_BAN_MESSAGE'				=> 'Ban reason',
	'DAP_COOKIE_BAN_MESSAGE_EXPLAIN'		=> 'Message displayed when user is banned by cookie. Leave empty if you have a multilingual board and you want to display text from <samp>DAP_COOKIE_BAN_MESSAGE_TEXT</samp> variable located in <em>ext/shredder/dap/language/en/info_acp_dap.php</em>',
	'DAP_COOKIE_BAN_MESSAGE_TEXT'			=> 'Violation of forum rules.',
	'DAP_COOKIE_COMMON_NAMES'				=> 'Cookie Common Names',
	'DAP_COOKIE_DENY_MESSAGE'				=> 'Deny register message',
	'DAP_COOKIE_DENY_MESSAGE_EXPLAIN'		=> 'Message displayed when user is denied registration by cookie. Leave empty if you have a multilingual board and you want to display text from <samp>DAP_COOKIE_DENY_REGISTER_TEXT</samp> variable located in <em>ext/shredder/dap/language/en/info_acp_dap.php</em>',
	'DAP_COOKIE_DENY_REGISTER'				=> 'Deny register for banned users',
	'DAP_COOKIE_DENY_REGISTER_EXPLAIN'		=> 'The user will denied registration if ban Cookie on his browser were found.',
	'DAP_COOKIE_DENY_REGISTER_TEXT'			=> 'You cannot register on this forum.',
	'DAP_EXCLUDE_NAMES_EXPLAIN'				=> 'To specify several different usernames enter each on a new line.',
	'DAP_EXCLUDES_NAMES'					=> 'Names of users-exclusions',
	'DAP_EXCLUDES_NAMES_EXPLAIN'			=> 'To each user from the top list the name-exclusion or several names from this field will be appropriated. Excluded pairs will not be recorded as suspicious auths if cookie with a name of one user are found in the browser of the other user.',
	'DAP_EXCLUDES_UPDATE_SUCCESSFUL'		=> 'Exclusions list updated successfully.',
	'DAP_DUPLICATES_PER_PAGE'				=> 'Number of duplicates per page',
	'DAP_DUPLICATES_PER_PAGE_EXPLAIN'		=> 'Number of users marked as duplicates displayed per page in Duplicate Users List.',
	'DAP_EMAIL_NOTIFICATION'				=> 'Enable email notifications',
	'DAP_EMAIL_NOTIFICATION_EXPLAIN'		=> 'Send email notifications when a double account is detected. Email will be sent to all users that have permission to Administrate users.',
	'DAP_IGNORE_INACTIVE'					=> 'Ignore inactive users',
	'DAP_IGNORE_INACTIVE_EXPLAIN'			=> 'If enabled, accounts will be excluded from userвЂ™s matches if they were inactive at the moment of his detection. If all matched accounts are inactive, report about duplicate will not be created at all. The same for Suspicious auths log.',
	'DAP_IP_ADRESS'							=> 'IP-Adress',
	'DAP_IP_COMMON_NAMES'					=> 'IP Common Names',
	'DAP_NO_DUPE_USERS'						=> 'No duplicate users',
	'DAP_NOTIFICATION_MESSAGE'				=> 'The new user shares common IP addresses and/or common cookies with some other users. Please visit his profile for detailed information.

User details:

Username: [username]
User IP adress: [user_ip]
E-mail: [user_email]
Registered on: [user_regdate]
IP Common Names: [ip_common_names]
Cookie Common Names: [c_common_names]',
	'DAP_NOTIFICATION_SUBJECT'				=> 'Possible double account: [username]',
	'DAP_PM_NOTIFICATION'					=> 'Enable PM notifications',
	'DAP_PM_NOTIFICATION_EXPLAIN'			=> 'Send PM notifications when a double account is detected. PM will be sent to all users that have permission to Administrate users.',
	'DAP_POST_NOTIFICATION'					=> 'Enable post notifications',
	'DAP_POST_NOTIFICATION_EXPLAIN'			=> 'Send post notifications to all selected forums when a double account is detected. Select multiple forums by holding <samp>CTRL</samp> and clicking. Do not select forums if you do not want to use this feature.',
	'DAP_QUICK_DELETION'					=> 'Quick deletion',
	'DAP_QUICK_DELETION_EXPLAIN'			=> 'If enabled, duplicated names and their cookie-matching will have quick deletion icon. If &laquo;Notify&raquo; enabled, the user will receive an e-mail after deletion. Text of e-mail can be found in the file <em>ext/shredder/dap/language/en/email/user_dap_deleted.txt</em>',
	'DAP_STATUS_BLACKLIST'					=> 'Banned',
	'DAP_STATUS_WHITELIST'					=> 'Whitelisted',
	'DAP_STATUS_EXCLUSION'					=> 'Excluded',
	'DAP_USER_NO_BANNED'					=> 'Block List is empty',
	'DAP_USER_NOTES_ENTRY'					=> 'Enable user notes notifications',
	'DAP_USER_NOTES_ENTRY_EXPLAIN'			=> 'Adds info to user notes about userвЂ™s matches if these are found at registration or sign in to the board. Records of auths at different times but with the same data will not be repeated.',

	'DELETE_ALL_ENTRIES'					=> 'Delete all entries',
	'DAP_DELETE_POSTS'							=> 'Delete posts',

	'IP_CHECK_FULL'							=> 'Full scan',
	'IP_CHECK_LIGHT'						=> 'Light scan',
	'IP_CHECK_NONE'							=> 'No scan',
	'IP_CHECK_REGISTRATION'					=> 'Duplicate IP check at registration',
	'IP_CHECK_REGISTRATION_EXPLAIN'			=> 'This can search same IP addreses at registration in database logs. <strong>Light</strong> option only searchs sessions and users tables, <strong>Full</strong> option scans all IP logged database tables, so takes longer.',
	'IP_WHOIS_FOR'							=> 'Info about this IP',

	'LOG_EXCLUDES_UPDATED'					=> '<strong>Updated suspicious logвЂ™s exclusions</strong>',
	'LOG_BLACKLIST_BLOCK'					=> '<strong>Rejected by DAP blacklist when attempted to log in with the data of</strong><br />» %s',
	'LOG_CLEAR_DAP'							=> '<strong>Log of suspicious auths cleared</strong>',
	'LOG_CLEAR_DUPE_LIST'					=> '<strong>Dupe Users List cleared</strong>',
	'LOG_COOKIE_AUTOBAN'					=> '<strong>User automatically banned by cookie</strong><br />» %s',
	'LOG_COOKIE_BLACKLIST'					=> '<strong>User added to cookie blacklist</strong><br />» %s',
	'LOG_COOKIE_BLACKLIST_MANY'				=> '<strong>Users added to cookie blacklist</strong><br />» %s',
	'LOG_COOKIE_WHITELIST'					=> '<strong>User added to cookie whitelist</strong><br />» %s',
	'LOG_COOKIE_WHITELIST_MANY'				=> '<strong>Users added to cookie whitelist</strong><br />» %s',
	'LOG_COOKIE_EXCLUSION'					=> '<strong>User added to cookie exclusions</strong><br />» %s',
	'LOG_COOKIE_EXCLUSION_MANY'				=> '<strong>Users added to cookie exclusions</strong><br />» %s',
	'LOG_COOKIE_BLOCK'						=> '<strong>Rejected by cookie when attempted to log in with the data of</strong><br />» %s',
	'LOG_COOKIE_UNBAN'						=> '<strong>User deleted from cookie block list</strong><br />» %s',
	'LOG_COOKIE_UNBAN_MANY'					=> '<strong>Users deleted from cookie block list</strong><br />» %s',
	'LOG_LOGIN_WITH_DATA'					=> '<strong>Successful login with the data of</strong><br />» %s',
	'LOG_LOGIN_WITH_DATA_ACP'				=> '<strong>Successful login to ACP with the data of</strong><br />» %s',
	'LOG_STANDARD_BLOCK'					=> '<strong>Rejected by default phpBB ban when attempted to log in with the data of</strong><br />» %s',
	'LOG_USER_NOTE_AUTH'					=> '<strong>Cookie-match with another user found in user’s browser when user logged in to the board</strong><br />» %s',
	'LOG_USER_NOTE_COOKIE'					=> '<strong>Cookie-match with another user found in user’s browser when user joined in to the board</strong><br />» %s',
	'LOG_USER_NOTE_IP'						=> '<strong>IP-matches with another users found when user joined in to the board</strong><br />» %s',

	'QUICK_DELETE_NOTIFY'					=> 'Notify',
	'QUICK_DELETE_SILENT'					=> 'Without notification',
));
