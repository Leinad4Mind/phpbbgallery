<?php
/**
*
* @package Search Results
* @copyright (c) 2014 John Peskens (http://ForumHulp.com)
* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
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
	'ACP_SEARCHRESULTS'				=> 'Search results',
	'PRUNE_SEARCHRESULTS'			=> 'Search Results',
	'PRUNE_SEARCHRESULTS_EXPLAIN'	=> 'Max records in searchresults table before pruning, 0 will disable this function.',

	'LOG_SR_REMOVED'		=> '<strong>Prune search results</strong><br />» Search results (%1$s),  %2$s records',
	'LOG_SR_REMOVED_ALL'	=> '<strong>Purged search results</strong>',
	'FH_HELPER_NOTICE'		=> 'Forumhulp helper application does not exist!<br />Download <a href="https://github.com/ForumHulp/helper" target="_blank">forumhulp/helper</a> and copy the helper folder to your forumhulp extension folder.',
	'SEARCHRESULTS_NOTICE'	=> '<div class="phpinfo"><p class="entry">This extension resides in %1$s » %2$s » %3$s.<br>Config settings are in %4$s » %5$s » %6$s.</p></div>',
));

// Description of extension
$lang = array_merge($lang, array(
	'DESCRIPTION_PAGE'		=> 'Description',
	'DESCRIPTION_NOTICE'	=> 'Extension note',
	'ext_details' => array(
		'details' => array(
			'DESCRIPTION_1'		=> 'Sortable',
			'DESCRIPTION_2'		=> 'Automatic prune of older records',
			'DESCRIPTION_3'		=> 'Grouped in find and not find in post',
		),
		'note' => array(
			'NOTICE_1'			=> 'phpBB 3.2 ready'
		)
	)
));
