<?php
/**
*
* @package Two Factor Authentication
* @copyright (c) 2016 SiteSplat All rights reserved
* @license Proprietary
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
// ’ » “ ” …
//

$lang = array_merge(
	$lang, array(
		'TFA_NO_KEYS'				=> 'N\A',
		'TFA_NO_KEY_FOUND'			=> 'No two factor authentication key found. Download Google Authenticator app on your mobile device and associate the account by entering a new key. <a href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&hl=en" target="blank"><i class="fa fa-android"></i> Android</a> &#47; <a href="https://itunes.apple.com/ca/app/google-authenticator/id388497605" target="blank"><i class="fa fa-apple"></i> Apple</a>',
		'TFA_KEYS'					=> 'On this page you can manage your two factor authentication keys. If you loose your keys, make sure to remove the key from your Authenticator! You can reset your key with the forget password function, then you will be able to login again and create a new key.',
		'TFA_NO_MODE'				=> 'No Mode',
		'TFA_KEYS_DELETED'			=> 'Selected keys removed.',
		'TFA_NEW'                   => 'Add new key',
		'TFA_ERROR'					=> 'It seems something went wrong...',
		'TFA_REG_FAILED'			=> 'Registration failed with error: ',
		'TFA_REG_EXISTS'			=> 'The provided key has already been registered to your account',
		'TFA_ADD_KEY'				=> 'Register new key',
		'TFA_KEY_ADDED'				=> 'Your security key has been added and can be used.',
		'TFA_INSERT_KEY'			=> 'Insert your security key, and press the button on the key',
		'TFA_REGISTERED'			=> 'Key registered',
		'TFA_LAST_USED'				=> 'Key last used',
		'TFA_LOGIN_FROM'			=> 'Last login from',
		'TFA_MODULE_NOT_FOUND'		=> 'The selected module (%s) has not been found',
		'TFA_MODULE_NO_REGISTER'	=> 'The selected module does not accept new keys for registration',
		'TFA_SELECT_NEW'			=> 'Add new key',
		'TFA_ADD_NEW_OTP_KEY'		=> 'Add a new OTP key to your account',
		'TFA_ADD_OTP_KEY_MAIN'	    => 'Scan the QR code below with Google Authenticator App for <a href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&hl=en" target="blank"><i class="fa fa-android"></i> Android</a> &#47; <a href="https://itunes.apple.com/ca/app/google-authenticator/id388497605" target="blank"><i class="fa fa-apple"></i> Apple</a>, or you can also use the generated key below.<br /> Once done, enter the code provided by your Authenticator app to finally associate your account.',
		'TFA_OTP_KEY'				=> 'Generated key here then hit submit',
		'TFA_ADD_OTP_KEY_EXPLAIN'	=> '<span>%s</span>',
		'TFA_OTP_INVALID_KEY'		=> 'Invalid key provided.',
		'TFA_KEYTYPE'				=> 'Key type',
		'TFA_KEY_NOT_USED'			=> 'Not used yet',
	)
);
