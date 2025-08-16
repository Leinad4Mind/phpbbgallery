<?php
/**
 * @package cBB Blockgets
 * @version 2.0.5 15/01/2023
 *
 * @copyright (c) 2023 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 */

// @ignore
if(!defined('IN_PHPBB'))
{
	exit;
}

$blg_lang_locale = array(
	'ar'		=> array('iso'	=> 'en_US',	'name'	=> 'العربي ',			'name_eng'	=> 'Arabic'),
	'eu'		=> array('iso'	=> 'es_ES',	'name'	=> 'Euskara',			'name_eng'	=> 'Basque'),
	'be'		=> array('iso'	=> 'en_US',	'name'	=> 'Беларуская',		'name_eng'	=> 'Belarusian'),
	'bg'		=> array('iso'	=> 'bg_BG',	'name'	=> 'български език',	'name_eng'	=> 'Bulgarian'),
	'ca'		=> array('iso'	=> 'es_ES',	'name'	=> 'Catalá',			'name_eng'	=> 'Catalan'),
	'cs'		=> array('iso'	=> 'en_GB',	'name'	=> 'česky',				'name_eng'	=> 'Czech'),
	'da'		=> array('iso'	=> 'en_GB',	'name'	=> 'Dansk',				'name_eng'	=> 'Danish'),
	'nl'		=> array('iso'	=> 'en_GB',	'name'	=> 'Nederlands',		'name_eng'	=> 'Dutch'),
	'et'		=> array('iso'	=> 'en_GB',	'name'	=> 'Eesti keel',		'name_eng'	=> 'Estonian'),
	'fi'		=> array('iso'	=> 'fi_FI',	'name'	=> 'Suomi',				'name_eng'	=> 'Finnish'),
	'fr'		=> array('iso'	=> 'fr_FR',	'name'	=> 'Français',			'name_eng'	=> 'French'),
	'gl'		=> array('iso'	=> 'es_ES',	'name'	=> 'Galego',			'name_eng'	=> 'Galician'),
	'de'		=> array('iso'	=> 'de_DE',	'name'	=> 'Deutsch',			'name_eng'	=> 'German'),
	'el'		=> array('iso'	=> 'el_GR',	'name'	=> 'Ελληνικά',			'name_eng'	=> 'Greek'),
	'iw'		=> array('iso'	=> 'iw_IL',	'name'	=> 'עברית ',			'name_eng'	=> 'Hebrew'),
	'hu'		=> array('iso'	=> 'hu_HU',	'name'	=> 'Magyar',			'name_eng'	=> 'Hungarian'),
	'id'		=> array('iso'	=> 'id_ID',	'name'	=> 'Bahasa Indonesia',	'name_eng'	=> 'Indonesian'),
	'it'		=> array('iso'	=> 'it_IT',	'name'	=> 'Italiano',			'name_eng'	=> 'Italian'),
	'ja'		=> array('iso'	=> 'ja_JP',	'name'	=> '日本語',			'name_eng'	=> 'Japanese'),
	'lt'		=> array('iso'	=> 'lt_LT',	'name'	=> 'Lietuvių',			'name_eng'	=> 'Lithuanian'),
	'zh-CN'		=> array('iso'	=> 'zh_CN',	'name'	=> '正體中文',			'name_eng'	=> 'Chinese traditional'),
	'fa'		=> array('iso'	=> 'fa_FA',	'name'	=> 'فارسی ',			'name_eng'	=> 'Persian'),
	'pl'		=> array('iso'	=> 'pl_PL',	'name'	=> 'polski',			'name_eng'	=> 'Polish'),
	'pt'		=> array('iso'	=> 'pt_PT',	'name'	=> 'Português',			'name_eng'	=> 'Portuguese'),
	'ro'		=> array('iso'	=> 'ro_RO',	'name'	=> 'română',			'name_eng'	=> 'Romanian'),
	'ru'		=> array('iso'	=> 'ru_RU',	'name'	=> 'русский язык',		'name_eng'	=> 'Russian'),
	'sr'		=> array('iso'	=> 'sr_RS',	'name'	=> 'Српска ћирилица',	'name_eng'	=> 'Serbian'),
	'sk'		=> array('iso'	=> 'sk_SK',	'name'	=> 'Slovenčina',		'name_eng'	=> 'Slovak'),
	'en'		=> array('iso'	=> 'en_GB',	'name'	=> 'English',			'name_eng'	=> 'English'),
	'es'		=> array('iso'	=> 'es_ES',	'name'	=> 'Español',			'name_eng'	=> 'Spanish'),
	'es_x_tu'	=> array('iso'	=> 'es_ES',	'name'	=> 'Español (Tú)',		'name_eng'	=> 'Spanish (Casual)'),
	'sv'		=> array('iso'	=> 'sv_SE',	'name'	=> 'Svenska',			'name_eng'	=> 'Swedish'),
	'th'		=> array('iso'	=> 'th_TW',	'name'	=> 'ภาษาไทย',			'name_eng'	=> 'Thai'),
	'tr'		=> array('iso'	=> 'tr_TR',	'name'	=> 'Türkçe',			'name_eng'	=> 'Turkish'),
	'uk'		=> array('iso'	=> 'uk_UA',	'name'	=> 'Українська',		'name_eng'	=> 'Ukrainian'),
	'vi'		=> array('iso'	=> 'vi_VN',	'name'	=> 'Tiếng Việt',		'name_eng'	=> 'Vietnamese'),
);
