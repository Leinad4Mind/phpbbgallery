<?php
/**
*
* BBOAuth
*
* @copyright (c) 2018 SiteSplat All rights reserved
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
	'ACP_BBOAUTH'					=> 'BBoauth',
	'SS_HELPER_NOTY'	            => 'SiteSplat BBcore does not exist!<br />Download the <a href="http://sitesplat.com" target="_blank">BBcore</a> and copy the BBcore folder into your sitesplat extension folder.',
	'BBOAUTH_NOTICE'	            => '<div class="phpinfo"><p>The settings for this extension are under <strong>%1$s &#187; %2$s &#187; %3$s</strong>. <br />Select "Oauth" then add the appropriate keys for each providers in order to enable them.<br />Autogroup and other options are: <strong>ACP &#187; Board Configuration &#187; User registration settings  &#187; BBoauth.<br />Create the Oauth app via these providers: <a href="https://www.coinbase.com/settings/api" target="_blank">Coinbase</a>, <a href="https://discordapp.com/developers/applications/#top" target="_blank">Discord</a>, <a href="https://www.dropbox.com/developers/apps" target="_blank">Dropbox</a>, <a href="https://developer.github.com/apps/building-oauth-apps/creating-an-oauth-app/" target="_blank">Github</a>, <a href="https://www.instagram.com/developer/" target="_blank">instagram</a>, <a href="https://api.slack.com/apps" target="_blank">Slack</a>, <a href="https://api.razer.com/projects/" target="_blank">Razer ID</a>, <a href="https://console.developers.google.com/apis/credentials" target="_blank">Google</a></strong></p></div>',

	'BBOAUTH_AUTOREGISTER'			=> 'Automatically register with OAuth',
	'BBOAUTH_AUTOREGISTER_EXPLAIN'	=> 'Set to Yes to skip registration process when a user tries to log-in using the OAuth service. BBoauth will pull all the necessary information from the OAuth service (username and email) and generate a random password for the user. A welcome email is also sent out to the user with the password.<br/> NOTE: Some providers will not release certain information regarding the user trying to register. If the email and or username are not provided the auto-registration will not be possible. However in such cases BBoauth will pre-fill any info available in the registration stage to make it easier for the user. The new user will also be automatically logged-in if the "Account activation" is set to: "No Activation (Immediate Access)" which is the recommended method as we assume that the user is not a Bot as he is passing through the social media account first.',
	'BBOAUTH_GROUP'					=> 'Group for OAuth users',
	'BBOAUTH_GROUP_EXPLAIN'			=> 'Users who use OAuth login function will be automatically added to the selected group chosen here.',
));

