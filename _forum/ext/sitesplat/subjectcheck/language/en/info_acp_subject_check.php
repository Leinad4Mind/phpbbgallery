<?php
/**
 *
 * Subject Check. An extension for the phpBB Forum Software package.
 *
 * @copyright (c) 2016, SiteSplat
 * @license GNU General Public License, version 2 (GPL-2.0)
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
	// ACP labels
	'ACP_SUBJECT_CHECK_TITLE'		=> 'Subject Check',
	'SUBJECT_CHECK_ENABLE'			=> 'Enable subject check',
	'SUBJECT_CHECK_ENABLE_EXPLAIN'	=> 'Turning off this feature will disable it for all forums.',
	'SUBJECT_CHECK_BYPASS'			=> 'Allow bypassing',
	'SUBJECT_CHECK_BYPASS_EXPLAIN'	=> 'Bypassing allows a person to post their topic even after being presented with a list of similar topics.',
	'SUBJECT_CHECK_STRICT'			=> 'Enable strict mode',
	'SUBJECT_CHECK_STRICT_EXPLAIN'	=> 'Only checks for topics that have identical subjects.',
	'SUBJECT_CHECK_AJAX'			=> 'Enable AJAX mode',
	'SUBJECT_CHECK_AJAX_EXPLAIN'	=> 'Display results without requiring a separate page load.',
	'SUBJECT_CHECK_LOCKED'			=> 'Check locked topics',
	'SUBJECT_CHECK_LOCKED_EXPLAIN'	=> 'Check locked topics when checking subjects.',
	'SUBJECT_CHECK_POP'				=> 'Open topic links in new window',
	'SUBJECT_CHECK_POP_EXPLAIN'		=> 'Open the listed topic links in a new browser window.',
	'SUBJECT_CHECK_ADMIN'			=> 'Administrator override',
	'SUBJECT_CHECK_ADMIN_EXPLAIN'	=> 'Allow admins to post without checking subjects.',
	'SUBJECT_CHECK_MOD'				=> 'Moderator override',
	'SUBJECT_CHECK_MOD_EXPLAIN'		=> 'Allow moderators to post without checking subjects.',
	'SUBJECT_CHECK_COMMON'			=> 'Check common words',
	'SUBJECT_CHECK_COMMON_EXPLAIN'	=> 'Common words are normally ignored when comparing subjects.',
	'SUBJECT_CHECK_FORUMS'			=> 'Check all forums',
	'SUBJECT_CHECK_FORUMS_EXPLAIN'	=> 'Check all forums instead of just the one being posted to.',
	'SUBJECT_CHECK_FNAMES'			=> 'Display forum names',
	'SUBJECT_CHECK_FNAMES_EXPLAIN'	=> 'Display forum names in front of each topic that is found.',
	'SUBJECT_CHECK_LIMIT'			=> 'Maximum number of topics to display',
	'SUBJECT_CHECK_LIMIT_EXPLAIN'	=> 'Set to 0 for unlimited topics.',
	'SUBJECT_CHECK_ACTIVE'			=> 'Check topics active within these days',
	'SUBJECT_CHECK_ACTIVE_EXPLAIN'	=> 'Only check topics that have seen activity within this number of days. Set to 0 for unlimited.',
	'SUBJECT_CHECK_COUNT'			=> 'Post Count',
	'SUBJECT_CHECK_COUNT_EXPLAIN'	=> 'Topics from users above this post count will not be checked for similar topics. Enter 0 to disable.',
	'SUBJECT_CHECK_BYPASS_EXACT'	=> 'If no exact match exists',

	'ACP_SUBJECT_CHECK_SETTING_SAVED'	=> 'Subject Check settings has been saved.',
	
	'ACP_SUBCHECK_SETTINGS'		    => 'Settings',
	'ACP_SUBCHECK'					=> 'Subject Check',
	'SS_HELPER_NOTY'	            => 'SiteSplat BBcore does not exist!<br />Download the <a href="http://sitesplat.com" target="_blank">BBcore</a> and copy the BBcore folder into your sitesplat extension folder.',
	'SUBCHECK_NOTICE'	            => '<div class="phpinfo"><p>The settings for this extension are in <strong>%1$s &#187; %2$s &#187; %3$s</strong>. <br />Don\'t forget to check/set the permission for each forum if need be. <strong>ACP &#187; FORUMS &#187; Edit forum &#187; Enable subject check</strong></p></div>',

	// ACP labels for individual forums
	'SUBJECT_CHECK_FORUM'			=> 'Enable subject check',
	'SUBJECT_CHECK_FORUM_EXPLAIN'	=> 'Check subjects of new topics against existing topics.',
));
