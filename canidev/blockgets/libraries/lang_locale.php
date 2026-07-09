<?php
/**
 * @package cBB Blockgets
 * @version 2.0.7 01/07/2024
 *
 * @copyright (c) 2024 CaniDev
 * @license https://creativecommons.org/licenses/by-nc/4.0/
 */

// @ignore
if(!defined('IN_PHPBB'))
{
	exit;
}

$blg_lang_locale = [
	'ar'		=> ['iso'	=> 'en_US',	'name'	=> 'العربي ',			'name_eng'	=> 'Arabic'],
	'eu'		=> ['iso'	=> 'es_ES',	'name'	=> 'Euskara',			'name_eng'	=> 'Basque'],
	'be'		=> ['iso'	=> 'en_US',	'name'	=> 'Беларуская',		'name_eng'	=> 'Belarusian'],
	'bg'		=> ['iso'	=> 'bg_BG',	'name'	=> 'български език',	'name_eng'	=> 'Bulgarian'],
	'ca'		=> ['iso'	=> 'es_ES',	'name'	=> 'Catalá',			'name_eng'	=> 'Catalan'],
	'cs'		=> ['iso'	=> 'en_GB',	'name'	=> 'česky',				'name_eng'	=> 'Czech'],
	'da'		=> ['iso'	=> 'en_GB',	'name'	=> 'Dansk',				'name_eng'	=> 'Danish'],
	'nl'		=> ['iso'	=> 'en_GB',	'name'	=> 'Nederlands',		'name_eng'	=> 'Dutch'],
	'et'		=> ['iso'	=> 'en_GB',	'name'	=> 'Eesti keel',		'name_eng'	=> 'Estonian'],
	'fi'		=> ['iso'	=> 'fi_FI',	'name'	=> 'Suomi',				'name_eng'	=> 'Finnish'],
	'fr'		=> ['iso'	=> 'fr_FR',	'name'	=> 'Français',			'name_eng'	=> 'French'],
	'gl'		=> ['iso'	=> 'es_ES',	'name'	=> 'Galego',			'name_eng'	=> 'Galician'],
	'de'		=> ['iso'	=> 'de_DE',	'name'	=> 'Deutsch',			'name_eng'	=> 'German'],
	'el'		=> ['iso'	=> 'el_GR',	'name'	=> 'Ελληνικά',			'name_eng'	=> 'Greek'],
	'iw'		=> ['iso'	=> 'iw_IL',	'name'	=> 'עברית ',			'name_eng'	=> 'Hebrew'],
	'hu'		=> ['iso'	=> 'hu_HU',	'name'	=> 'Magyar',			'name_eng'	=> 'Hungarian'],
	'id'		=> ['iso'	=> 'id_ID',	'name'	=> 'Bahasa Indonesia',	'name_eng'	=> 'Indonesian'],
	'it'		=> ['iso'	=> 'it_IT',	'name'	=> 'Italiano',			'name_eng'	=> 'Italian'],
	'ja'		=> ['iso'	=> 'ja_JP',	'name'	=> '日本語',			'name_eng'	=> 'Japanese'],
	'lt'		=> ['iso'	=> 'lt_LT',	'name'	=> 'Lietuvių',			'name_eng'	=> 'Lithuanian'],
	'zh-CN'		=> ['iso'	=> 'zh_CN',	'name'	=> '正體中文',			'name_eng'	=> 'Chinese traditional'],
	'fa'		=> ['iso'	=> 'fa_FA',	'name'	=> 'فارسی ',			'name_eng'	=> 'Persian'],
	'pl'		=> ['iso'	=> 'pl_PL',	'name'	=> 'polski',			'name_eng'	=> 'Polish'],
	'pt'		=> ['iso'	=> 'pt_PT',	'name'	=> 'Português',			'name_eng'	=> 'Portuguese'],
	'ro'		=> ['iso'	=> 'ro_RO',	'name'	=> 'română',			'name_eng'	=> 'Romanian'],
	'ru'		=> ['iso'	=> 'ru_RU',	'name'	=> 'русский язык',		'name_eng'	=> 'Russian'],
	'sr'		=> ['iso'	=> 'sr_RS',	'name'	=> 'Српска ћирилица',	'name_eng'	=> 'Serbian'],
	'sk'		=> ['iso'	=> 'sk_SK',	'name'	=> 'Slovenčina',		'name_eng'	=> 'Slovak'],
	'en'		=> ['iso'	=> 'en_GB',	'name'	=> 'English',			'name_eng'	=> 'English'],
	'es'		=> ['iso'	=> 'es_ES',	'name'	=> 'Español',			'name_eng'	=> 'Spanish'],
	'sv'		=> ['iso'	=> 'sv_SE',	'name'	=> 'Svenska',			'name_eng'	=> 'Swedish'],
	'th'		=> ['iso'	=> 'th_TW',	'name'	=> 'ภาษาไทย',			'name_eng'	=> 'Thai'],
	'tr'		=> ['iso'	=> 'tr_TR',	'name'	=> 'Türkçe',			'name_eng'	=> 'Turkish'],
	'uk'		=> ['iso'	=> 'uk_UA',	'name'	=> 'Українська',		'name_eng'	=> 'Ukrainian'],
	'vi'		=> ['iso'	=> 'vi_VN',	'name'	=> 'Tiếng Việt',		'name_eng'	=> 'Vietnamese'],
];
