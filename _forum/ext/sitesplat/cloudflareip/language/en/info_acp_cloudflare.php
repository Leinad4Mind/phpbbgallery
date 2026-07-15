<?php
/**
*
* Cloudflare IP
*
* @copyright (c) 2016 SiteSplat All rights reserved
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
	'ACP_CLOUDFLARE'				=> 'CloudFlare IP',
	'ACP_CLOUDFLARE_EXPLAIN'		=> 'Welcome to CloudFlare settings. Once you enter your CloudFlare email, API Key and Domain, you will be able to set development mode and clear cache from this place.',
	'SS_HELPER_NOTY'	            => 'SiteSplat BBcore does not exist!<br />Download the <a href="https://sitesplat.com" target="_blank">BBcore</a> and copy the BBcore folder into your sitesplat extension folder.',
	'CLOUDFLARE_NOTICE'	            => '<div class="phpinfo"><p>There are no specific settings for this extension. The IP addresses are now all normalized and will be the real users IP. Enjoy!<br />You might get kicked out from the ACP after you click away from this page. This is normal as your current IP is normalized. Login again if that happens.<br />CloudFlare API settings are under the <strong>ACP &#62; EXTENSIONS</strong> tab and once the API info are entered it will be possible to clear the CF cache directly in the <strong>ACP &#62; GENERAL</strong> tab. Enjoy!</p></div>',

	'CLOUDFLARE_FETCH_FAILED'			=> 'Unable to fetch CloudFlare data. Please, verify your email, API key and domain. Errors returned from CloudFlare:<br><br>%s',
	'CLOUDFLARE_SETTINGS_SAVED'			=> 'CloudFlare local settings has been saved.',
	'CLOUDFLARE_DEV_MODE_FAILED'		=> 'CloudFlare development mode change was unsuccessful:<br><br>%s.',
	'CLOUDFLARE_DEV_MODE_SUCCESS'		=> 'CloudFlare development mode change was successful.',
	'CLOUDFLARE_CLEAR_CACHE_FAILED'		=> 'CloudFlare cache clearing was not successful:<br><br>%s.',
	'CLOUDFLARE_CLEAR_CACHE_SUCCESS'	=> 'CloudFlare cache clearing was successful.',

	'CLOUDFLARE_EMAIL'						=> 'CloudFlare Account Email',
	'CLOUDFLARE_API_KEY'					=> 'API Key (Global API Key)',
	'CLOUDFLARE_API_KEY_EXPLAIN'			=> 'Login to your CloudFlare account and visit your Account page. In the "Overview" page, in the bottom right corner, you should see the “API” section. Click “Get your API token” link. In the next step from there you should see the “Global API Key” button. Click "View" and copy that API key. Paste it in this field.',
	'CLOUDFLARE_DOMAIN'						=> 'Domain',
	'CLOUDFLARE_DOMAIN_EXPLAIN'				=> 'Enter you forum domain as per CF entry (full URL protocol is not needed). Usually is as: "domain.com".',
	'CLOUDFLARE_DEVELOPMENT_MODE'			=> 'Development Mode',
	'CLOUDFLARE_DEVELOPMENT_MODE_EXPLAIN'	=> 'Development Mode temporarily allows you to enter development mode for your websites if you need to make changes to your site. This will bypass CloudFlare’s accelerated cache and slow down your site, but is useful if you are making changes to cacheable content (like images, css, or JavaScript) and would like to see those changes right away. Once entered, development mode will last for 3 hours and then automatically toggle off.',
	'CLOUDFLARE_CLEAR_CACHE'				=> 'Clear Cache',
	'CLOUDFLARE_CLEAR_CACHE_EXPLAIN'		=> 'Remove ALL files from CloudFlare’s cache',

	'CLOUDFLARE_CF_CLEAR_CACHE'	=> 'Clear CloudFlare’s cache',

	'LOG_PURGE_CLOUDFLARE_CACHE'	=> '<strong>Purged CloudFlare’s cache</strong>',
));
