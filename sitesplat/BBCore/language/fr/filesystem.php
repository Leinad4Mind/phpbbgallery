<?php
/**
*
* @package sitesplat BBcore
* @copyright (c) 2020 SiteSplat All rights reserved
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
	'SITESPLAT_SYSINFO'		=> 'System Information',

	'BBCORE_BIG_INCORRECT'	=> 'INCORRECT!',
	'PHP_OPEN_BASEDIR'		=> 'PHP open_basedir restrictions: <strong>%s</strong>',
	'PHP_EXT_MISSING'		=> 'PHP is missing the <strong>%s</strong> extension.',
	'PHP_POSIX_MISSING'		=> 'It is not possible to provide file/system ownership information because PHP is missing the <strong>POSIX</strong> extension.',
	'PHP_FN_DISABLED'		=> 'Since you have disabled important core PHP functions (<strong>%s</strong>), the system information provided by BBCore will be limited, and some extensions/addons will have limited functionality. Please consider enabling these functions! Your system configuration has been checked and they pose no security risk.',
	'BBCORE_USEROWNER'		=> 'Owner of ext/sitesplat directory: <strong>%s</strong>',
	'BBCORE_PHPOWNER'		=> 'PHP is running as user: <strong>%s</strong>',

	'FS_BAD_WINDOWS'		=> 'Windows has incompatible ACL restrictions.',
	'FS_BAD_CGI'			=> 'PHP is running in CGI mode, but due to a configuration error, it cannot write to the filesystem. Please fix the error, or set up the FTP configuration in BBCore Settings.',
	'FS_BAD_CREDS'			=> 'FTP credentials are missing or incorrect.',
	'FS_INCOMPATIBLE'		=> 'Your server is incompatible with BBCore auto-update and a number of SiteSplat extensions.',

	'FTP_SETTINGS'			=> 'FTP Configuration',
	'FTP_HOST_EXPLAIN'		=> '<em><strong>Please try to connect with this field left blank.</strong></em> If it fails, use the FTP hostname provided by your hosting company.',
	'FTP_PORT_EXPLAIN'		=> 'The FTP port number provided by your hosting company. If you leave this field blank, the port number will be set to 21.',
	'FTP_SSL'				=> 'Use explicit TLS encryption',
	'FTP_SSL_EXPLAIN'		=> '<em><strong>If the FTP host field is blank, please try to connect with this option set to NO.</strong></em> If it fails, ask your hosting company for the correct FTP encryption setting.',
	'FTP_USERNAME_EXPLAIN'	=> '<strong>(Required)</strong> The username for FTP access to your phpBB files. If your server supports it, a suggestion will be provided.',

	'FTP_BAD_HOST'			=> 'The hostname or port you entered was not valid, or the encryption setting was incorrect',
	'FTP_BAD_USER'			=> 'The username or password you entered was not valid',
	'FTP_NO_PATH'			=> 'Unable to determine path to phpBB',
	'FTP_BAD_PATH'			=> 'Unable to select phpBB directory',
	'FTP_FS_SUCCESS'		=> 'FTP access to filesystem was successful',

	'BBCORE_SETTINGS'		=> 'BBCore Settings',
	'BBCORE_OPT_SAVED'		=> 'BBCore Settings have been saved.',

	// minification
	'SITESPLAT_BBCORE_MINIFY_HTML'			=> 'Minify HTML',
	'SITESPLAT_BBCORE_MINIFY_HTML_EXPLAIN'	=> 'This is a BBCore option. Generated content will be minified prior to sending it to the user. This will reduce network traffic but will also increase CPU and memory usage on server side.',

	// Emoji stuff
	'SS_DEFAULT_EMOJI'				=> 'Default topic titles emoji behavior',
	'SS_DEFAULT_EMOJI_EXPLAIN'		=> 'Enable or disable the default phpBB topic title emoji behavior. Sadly starting with phpBB 3.2.9 users can freely "spam" emojis in topic titles. The phpBB team decided to blindly allow this and offer no way for admins to control it (not cool!). Luckily, you are using the SiteSplat\'s BBCore for added functionality to phpBB :-). It is strongly recommended to leave this option enabled to avoid users spamming titles.<br>Use then: <strong><a href="https://sitesplat.com/phpBB3/marketplace.php?mode=view&item_id=29" target="_blank">BBemoji</a></strong> (a premium extension) instead if you wish to take this a step further and have total control via proper forum permission basis for this behavior. This way you can designate a specific forum to allow emojis being posted in topic titles.',
));
