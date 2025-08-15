<?php
/**
*
* @package BBfront
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
	'ACP_BBFRONT'					=> 'BBfront',
	'ACP_BBFRONT_EXPLAIN'			=> 'Welcome to your BBfront page settings. Take a moment to check a few options, forums and permissions. <br />Don\'t forget to select topics to publish on your BBfront page while in post editor mode.<br /> Vimeo and Twitter Media Embeds are automatically embedded if BBembed is installed. Full media emebeds support for BBfront Advanced version only.',
	'ACP_BBFRONT_FORUMS'			=> 'BBfront forums',
	'ACP_BBFRONT_FORUMS_EXPLAIN'	=> 'Select forums BBfront can use, there should be min one forum else BBfront cannot work.',
	'ACP_BBFRONT_GROUPS'			=> 'BBfront groups',
	'ACP_BBFRONT_GROUPS_EXPLAIN'	=> 'Select groups a user must be a member of, in order to be able to publish on BBfront page',
	'ACP_BBFRONT_NAME'				=> 'BBfront page name',
	'ACP_BBFRONT_NAME_EXPLAIN'		=> 'Enter in your BBfront page name',
	'ACP_BBFRONT_CHARS'				=> 'Maximum characters',
	'ACP_BBFRONT_CHARS_EXPLAIN'		=> 'Characters in post block before text is truncated',
	'ACP_BBFRONT_PAGES'				=> 'Cards per page',
	'ACP_BBFRONT_PAGES_EXPLAIN'		=> 'Select the cards per page to load',
	'BBFRONT_USE_AVATAR'			=> 'Use avatar in BBfront page',
	'BBFRONT_USE_AVATAR_EXPLAIN'    => 'Enable or disable the use of avatars in BBfront page',
	
	'SITESPLAT_COM'		        => 'http://sitesplat.com',
	'SITESPLAT_COPY'		    => '&#169; SiteSplat',
	'LICENSE_INFO'		        => 'Proprietary - SiteSplat All rights reserved',
	'EXTENSION_DEVELOPER'	    => 'Developer',
	'ACP_NOTICE_CLOSE'			=> 'Close',
	'ACP_BBFRONT_VERSION'       => '1.0.5',
	'ACP_LOADING'		        => 'Loading... Hold on',

	'EXT_BBF_DESCRIPTION_PAGE'	=> 'A modern front page WordPress style for your board',
	'EXT_BBF_TASKS_1'			=> 'Special Group permissions',
	'EXT_BBF_TASKS_2'			=> 'Choose what to publish and the format',
	'EXT_BBF_TASKS_3'			=> 'Checkout the other premium addons on <a href="http://www.sitesplat.com/phpBB3/marketplace.php">sitesplat.com/marketplace.php</a>',
	'EXT_BBF_TASKS_4'			=> 'Supports video embed with BBembed premium extension',
	'EXT_BBF_TASKS_5'			=> 'Dynamic Masonry layout',
	'EXT_BBF_TASKS_6'			=> 'phpBB 3.2 ready',
	
	'ACP_BBTAGS_NOTICE_CLOSE'		=> 'Close',
	'NOTICE_BBTAGS'					=> 'The extension <a href="http://www.sitesplat.com/phpBB3/marketplace.php?mode=view&item_id=36"><strong>BBtags</strong></a> is only supported for BBfront Advanced version.',
	'NOTICE_BBEMBED'				=> 'The extension <a href="http://www.sitesplat.com/phpBB3/marketplace.php?mode=view&item_id=32"><strong>BBembed</strong></a> is not installed, you can NOT use Media Rich Cards in the published blocks',
	'NOTICE_LIKEBB'				    => 'The extension <a href="http://www.sitesplat.com/phpBB3/marketplace.php?mode=view&item_id=22"><strong>LikeBB</strong></a> is only supported for BBfront Advanced version.',
	'SS_HELPER_NOTY'	            => 'SiteSplat BBcore does not exist!<br />Download the <a href="http://sitesplat.com" target="_blank">BBcore</a> and copy the BBcore folder into your sitesplat extension folder.',
	'BBFRONT_NOTICE'	            => '<div class="phpinfo"><p>The settings for this extension are in <strong>%1$s » %2$s » %3$s</strong>.</p></div>',
));

// Description of Donations extension
$lang = array_merge($lang, array(
	'DESCRIPTION_PAGE'		=> 'Description',
	'DESCRIPTION_NOTICE'	=> 'Extension note',
	'ext_details' => array(
		'details' => array(
			'DESCRIPTION_1'		=> 'Selectable forums',
			'DESCRIPTION_2'		=> 'Selectable groups',
			'DESCRIPTION_3'		=> 'Frontpage name',
		),
		'note' => array(
			'NOTICE_1'			=> 'phpBB 3.2 ready',
		)
	)
));
