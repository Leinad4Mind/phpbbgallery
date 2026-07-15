<?php
/**
 * BBlivechat
 * @copyright (c) 2021 SiteSplat. All rights reserved.
 * @license Proprietary
 */
$bblc_config = [
	// lang filename(.php) must match the array keys
	// filename(.php) uses phpBB lang code
	'langNames' => [
		'ar' => 'عربي',
		'bg' => 'Български',
		'ca' => 'Català',
		'cs' => 'Česky',
		'da' => 'Dansk',
		'de' => 'Deutsch',
		'el' => 'Ελληνικα',
		'en' => 'English', // en_US (i18n)
		'es' => 'Español',
		'et' => 'Eesti',
		'fa' => 'فارسی',
		'fi' => 'Suomi',
		'fr' => 'Français',
		'gl' => 'Galego',
		'he' => 'עברית',
		'hr' => 'Hrvatski',
		'hu' => 'Magyar',
		'id' => 'Bahasa Indonesia', // id_ID (i18n)
		'it' => 'Italiano',
		'ja' => '日本語',
		'ka' => 'ქართული',
		'kr' => '한 글',
		'mk' => 'Македонски',
		'nl' => 'Nederlands',
		'nb' => 'Norsk', // nb_NO (i18n)
		'pl'=> 'Polski',
		'pt_br' => 'Português (Brasil)', // pt_BR (i18n)
		'pt' => 'Português (Portugal)', // pt_PT (i18n)
		'ro' => 'România',
		'ru' => 'Русский',
		'sl'=> 'Slovenčina',
		'sk' => 'Slovensko',
		'bs' => 'Srpski', // bs_BA (i18n)
		'sv'=> 'Svenska',
		'th' => 'ภาษาไทย',
		'tr' => 'Türkçe',
		'uk' => 'Українська',
		'zh_cmn_hans' => '中文 (简体)', // zh_CN (i18n)
		'zh_cmn_hant' => '中文 (繁體)', // zh_TW (i18n)
	],
];

//=================================
//  DO NOT EDIT BEYOND THIS POINT
//     YOU HAVE BEEN WARNED!!!
//=================================
$bblc_prefix = 'bblc'; $bblc_config = array_merge($bblc_config, [ 'chatClosed' => false, 'layout' => '', 'langDefault' => 'en', 'refreshRate' => 5, 'displayAvatars' => false, 'chatBotName' => 'ChatBot', 'allowPrivateChannels' => true, 'allowPrivateMessages' => true, 'allowUserMessageDelete' => false, 'inactiveTimeout' => 5, 'inactiveCheckInterval' => 5, 'defaultBanTime' => 5, 'requestMessagesLimit' => 20, 'maxUsersLoggedIn' => 32, 'messageTextMaxLength' => 1024, 'maxMessageRate' => 6, 'announce' => '', 'showChannelMessages' => true, 'dbConnection' => [ 'host' => null, 'user' => null, 'pass' => null, 'name' => null, 'type' => null, 'link' => null, ], 'dbTableNames' => [ 'online' => "{$bblc_prefix}_online", 'messages' => "{$bblc_prefix}_messages", 'bans' => "{$bblc_prefix}_bans", 'invitations' => "{$bblc_prefix}_invitations", ], 'styleAvailable' => ['SiteSplat'], 'styleDefault' => 'SiteSplat', 'sessionName' => 'bblivechat', 'sessionKeyPrefix' => $bblc_prefix, 'sessionCookieLifeTime' => 365, 'sessionCookiePath' => '/', 'sessionCookieDomain' => null, 'sessionCookieSecure' => false, 'contentEncoding' => 'UTF-8', 'sourceEncoding' => 'UTF-8', 'contentType' => 'text/html', 'privateChannelPrefix' => '[', 'privateChannelSuffix' => ']', 'defaultChannelName' => 'Public', 'defaultChannelID' => 0, 'limitChannelList' => null, 'forceAutoLogin' => false, 'timeZoneOffset' => null, 'openingHour' => 0, 'closingHour' => 24, 'openingWeekDays' => [0,1,2,3,4,5,6], 'logsUserAccess' => false, 'logsUserAccessChannelList' => null, 'logsFirstYear' => 2020, 'logsPurgeLogs' => true, 'logsPurgeTimeDiff' => 30, 'logsRequestMessagesLimit' => 50, 'logsRequestMessagesTimeDiff' => 1, 'privateChannelDiff' => 50000000, 'privateMessageDiff' => 100000000, 'allowGuestLogins' => false, 'allowGuestWrite' => false, 'allowGuestUserName' => false, 'guestUserPrefix' => '(', 'guestUserSuffix' => ')', 'minGuestUserID' => 40000000, 'allowNickChange' => false, 'changedNickPrefix' => '(', 'changedNickSuffix' => ')', 'userNameMaxLength' => 20, 'chatBotID' => 2147483647, 'requestMessagesPriorChannelEnter' => true, 'requestMessagesPriorChannelEnterList' => null, 'requestMessagesTimeDiff' => 24, 'logoutData' => './?logout=true', 'ipCheck' => false, 'socketServerEnabled' => false, ]); $bblc_config['langAvailable'] = array_keys($bblc_config['langNames']); $js_config = [ 'loginChannelID' => null, 'loginChannelName' => null, 'ajaxURL' => './?ajax=true', 'baseURL' => './', 'regExpMediaUrl' => '^((http)|(https)):\\/\\/', 'startChatOnLoad' => true, 'domIDs' => [ 'chatList' => 'chatList', 'onlineList' => 'onlineList', 'inputField' => 'inputField', 'messageLengthCounter' => 'messageLengthCounter', 'channelSelection' => 'channelSelection', 'styleSelection' => 'styleSelection', 'emoticonsContainer' => 'emoticonsContainer', 'colorCodesContainer' => 'colorCodesContainer', 'flashInterfaceContainer' => 'flashInterfaceContainer', ], 'settings' => [ 'bbCode' => true, 'bbCodeImages' => true, 'bbCodeColors' => true, 'hyperLinks' => true, 'lineBreaks' => true, 'emoticons' => true, 'autoFocus' => true, 'autoScroll' => true, 'maxMessages' => 0, 'wordWrap' => true, 'maxWordLength' => 32, 'dateFormat' => '%Y-%m-%d %H:%i:%s', 'persistFontColor' => true, 'fontColor' => null, 'audio' => true, 'audioVolume' => 1.0, 'soundReceive' => 'sound_1', 'soundSend' => 'sound_2', 'soundEnter' => 'sound_3', 'soundLeave' => 'sound_4', 'soundChatBot' => 'sound_5', 'soundError' => 'sound_6', 'blink' => true, 'blinkInterval' => 500, 'blinkIntervalNumber' => 10, ], 'nonPersistentSettings' => [], 'bbCodeTags' => [ 'b', 'i', 'u', 'quote', 'code', 'color', 'url', 'img', ], 'colorCodes' => [ 'gray', 'silver', 'white', 'yellow', 'orange', 'red', 'fuchsia', 'purple', 'navy', 'blue', 'aqua', 'teal', 'green', 'lime', 'olive', 'maroon', 'black', 'salmon', 'greenyellow', 'rebeccapurple', 'blueviolet', ], 'emoticonCodes' => [ ':-)', ':-D', ';-)', ':x', ':P', ':-(', ':-o', ':-/', '8-)', ':bored:', ':crying:', ':ninja:', ':angelo:', ':mad:', ':devil:', ':nerd:', ':party:', ':oops:', ':sick:', ':beaten:', ':clown:', ':doubt:', ':emo:', ':frozen:', ':indian:', ':karate:', ':kisses:', ':laugh:', ':love:', ':million:', ':pirate:', ':punk:', ':santas:', ':sweating:', ':vamp:', ':wacky:', ], 'emoticonTitles' => [ 'smile', 'Very Happy', 'Wink', 'speechless', 'tongue', 'Sad', 'Shocked', 'Confused', 'Cool', 'Bored', 'Crying', 'Ninja', 'Angel', 'Very Mad', 'Devil', 'Nerd', 'Party', 'Embarrassed', 'Sick', 'Beaten', 'Clown', 'Doubtful', 'Emo', 'Frozen', 'Indian', 'Karate', 'Kisses', 'Laugh', 'Love', 'Millionaire', 'Pirate', 'Punk', 'Santa', 'Sweating', 'Vampire', 'Wacky', ], 'emoticonFiles' => [ 'smile.svg', 'grin.svg', 'wink.svg', 'speechless.svg', 'tongue.svg', 'sad.svg', 'amazed.svg', 'confused.svg', 'cool.svg', 'bored.svg', 'cry.svg', 'ninja.svg', 'angel.svg', 'angry.svg', 'devil.svg', 'nerd.svg', 'party.svg', 'shy.svg', 'sick.svg', 'beaten.svg', 'clown.svg', 'doubtful.svg', 'emo.svg', 'frozen.svg', 'indian.svg', 'karate.svg', 'kiss.svg', 'laugh.svg', 'love.svg', 'millionaire.svg', 'pirate.svg', 'punk.svg', 'santa.svg', 'sweating.svg', 'vampire.svg', 'wacky.svg', ], 'emoticonsDir' => '../ext/sitesplat/bblivechat/chat/media/emoticons/', 'socketServerEnabled' => $bblc_config['socketServerEnabled'], 'sessionName' => $bblc_config['sessionName'], 'cookieExpiration' => $bblc_config['sessionCookieLifeTime'], 'cookiePath' => $bblc_config['sessionCookiePath'], 'cookieDomain' => null, 'cookieSecure' => null, 'chatBotID' => $bblc_config['chatBotID'], 'privateChannelDiff' => $bblc_config['privateChannelDiff'], 'privateMessageDiff' => $bblc_config['privateMessageDiff'], 'chatBotName' => '', 'timerRate' => 0, 'displayAvatars' => 0, 'allowUserMessageDelete' => 0, 'inactiveTimeout' => 0, 'showChannelMessages' => 0, 'messageTextMaxLength' => 0, 'soundFiles' => [ 'sound_1' => '{{ SOUND_1 }}', 'sound_2' => '{{ SOUND_2 }}', 'sound_3' => '{{ SOUND_3 }}', 'sound_4' => '{{ SOUND_4 }}', 'sound_5' => '{{ SOUND_5 }}', 'sound_6' => '{{ SOUND_6 }}', ], ];