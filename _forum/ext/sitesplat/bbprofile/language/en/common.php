<?php
/**
*
* BBbbprofile. An extension for the phpBB Forum Software package.
* @copyright (c) 2016, SiteSplat
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
	'COMPLETE_PROFILE_TITLE'	=> 'Complete your profile',
	'COMPLETED_PERCENTAGE'		=> '%d%% completed',

	'BBPROFILE_BIRTHDATE_TEXT'		=> 'Let your friend wish you a happy birthday.',
	'BBPROFILE_BIRTHDATE_BUTTON'	=> 'Add your birthday',
	'BBPROFILE_SIGNATURE_TEXT'		=> 'Promote your ideas.',
	'BBPROFILE_SIGNATURE_BUTTON'	=> 'Add signature under every post',
	'BBPROFILE_AVATAR_TEXT'			=> 'Express yourself and show who you are or maybe represent, believe in...',
	'BBPROFILE_AVATAR_BUTTON'		=> 'Add an avatar',

	'BBPROFILE_INTERESTS_TEXT'		=> 'Come on, stop being an asshole and share with your friends your awesome interests',
	'BBPROFILE_INTERESTS_BUTTON'	=> 'Add your interests',
	'BBPROFILE_OCCUPATION_TEXT'		=> 'What do you really do? Don\'t say "PLEASE"! Barney Stinson said it enough!',
	'BBPROFILE_OCCUPATION_BUTTON'	=> 'Add your hobbies',
	'BBPROFILE_WEBSITE_TEXT'		=> 'Do you own any website or blog?',
	'BBPROFILE_WEBSITE_BUTTON'		=> 'Promote what is yours, be proud!',
	'BBPROFILE_LOCATION_TEXT'		=> 'Do you want to share your location? What, did you call us stalkers?! But you always accept on Smartphone!',
	'BBPROFILE_LOCATION_BUTTON'		=> 'Fine. I want to meet nerdy neighbors anyway!',

	'BBPROFILE_FACEBOOK_TEXT'		=> 'Make friends. But doesn\'t talk with strangers (Mother Siny tip)',
	'BBPROFILE_FACEBOOK_BUTTON'		=> 'Add your Facebook account',
	'BBPROFILE_SKYPE_TEXT'			=> 'Talk to others.',
	'BBPROFILE_SKYPE_BUTTON'		=> 'Add your Skype account',
	'BBPROFILE_TWITTER_TEXT'		=> 'Let your tweets be heard.',
	'BBPROFILE_TWITTER_BUTTON'		=> 'Add your Twitter account',
	'BBPROFILE_YOUTUBE_TEXT'		=> 'Make your videos popular.',
	'BBPROFILE_YOUTUBE_BUTTON'		=> 'Add your Youtube account',
	'BBPROFILE_GOOGLEPLUS_TEXT'		=> 'Make friends.',
	'BBPROFILE_GOOGLEPLUS_BUTTON'	=> 'Add your Google+ account',

	'BBPROFILE_FIRST_POST_TEXT'		=> 'Get involved in discussion. Select a forum and create a new topic!',
	'BBPROFILE_FIRST_POST_BUTTON'	=> 'Create your first post.',

	'BBPROFILE_CPF_TEXT'		=> 'What is your %s?',
	'BBPROFILE_CPF_BTN_LABEL'	=> 'Add %s',
));
