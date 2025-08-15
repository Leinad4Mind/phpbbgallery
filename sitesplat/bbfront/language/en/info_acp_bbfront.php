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
	'ACP_BBFRONT'						=> 'BBfront Advanced',
	'ACP_BBFRONT_EXPLAIN'				=> 'Welcome to your BBfront Advanced page settings. Take a moment to check a few options, forums and permissions. <br />Don\'t forget to select topics to publish on your BBfront page while in post editor mode or in post view via the Ajax button.<br /> YouTube, Twitch, Vimeo, Medium and Twitter Media Embeds are automatically embedded if BBembed is installed :-)',
	'ACP_BBFRONT_FORUMS'				=> 'BBfront forums',
	'ACP_BBFRONT_FORUMS_EXPLAIN'		=> 'Select forums BBfront Advanced can use, there should be min one forum else BBfront cannot work.',
	'ACP_BBFRONT_GROUPS'				=> 'BBfront groups',
	'ACP_BBFRONT_GROUPS_EXPLAIN'		=> 'Select groups a user must be a member of, in order to be able to publish on BBfront page',
	'ACP_BBFRONT_NAME'					=> 'BBfront page name',
	'ACP_BBFRONT_NAME_EXPLAIN'			=> 'Enter in your BBfront page name',
	'ACP_BBFRONT_CHARS'					=> 'Maximum characters',
	'ACP_BBFRONT_CHARS_EXPLAIN'			=> 'Characters in post block before text is truncated',
	'ACP_BBFRONT_PAGES'					=> 'Cards per page on initial page load',
	'ACP_BBFRONT_PAGES_EXPLAIN'			=> 'Set the amount of cards per the initial page load',
	'ACP_BBFRONT_PAGES_LOAD'			=> 'Cards per page when loading more cards',
	'ACP_BBFRONT_PAGES_LOAD_EXPLAIN'	=> 'Cards per page after the load more button or infinite scroll is triggered',
	'USE_AVATAR'						=> 'Use avatar in BBfront page',
	'BBFRONT_GRID_LAYOUT'				=> 'Grid layout',
	'BBFRONT_GRID_LAYOUT_EXPLAIN'		=> 'Select the preferred cards layout',
	'BBFRONT_GRID_LAYOUT_4L'			=> '4 columns, large gutter',
	'BBFRONT_GRID_LAYOUT_5S'			=> '5 columns, small gutter',
	'BBFRONT_GRID_LAYOUT_4S'			=> '4 columns, small gutter',
	'BBFRONT_GRID_FX_FIRST'				=> 'Grid effect on page load',
	'BBFRONT_GRID_FX_FIRST_EXPLAIN'		=> 'Select the initial animation when the cards first load',
	'BBFRONT_GRID_FX_LOAD'				=> 'Grid effect when loading more cards',
	'BBFRONT_GRID_FX_LOAD_EXPLAIN'		=> 'Select an animation when the cards load on click or when infinite scroll is triggered',
	'BBFRONT_GRID_FX_HAPI'				=> 'Hapi',
	'BBFRONT_GRID_FX_AMUN'				=> 'Amun',
	'BBFRONT_GRID_FX_KEK'				=> 'Kek',
	'BBFRONT_GRID_FX_ISIS'				=> 'Isis',
	'BBFRONT_GRID_FX_MONTU'				=> 'Montu',
	'BBFRONT_GRID_FX_OSIRIS'			=> 'Osiris',
	'BBFRONT_GRID_FX_SATET'				=> 'Satet',
	'BBFRONT_GRID_FX_ATUM'				=> 'Atum',
	'BBFRONT_GRID_FX_RA'				=> 'Ra',
	'BBFRONT_GRID_FX_SOBEK'				=> 'Sobek',
	'BBFRONT_GRID_FX_PTAH'				=> 'Ptah',
	'BBFRONT_GRID_FX_BES'				=> 'Bes',
	'BBFRONT_GRID_FX_SEKER'				=> 'Seker',
	'BBFRONT_GRID_FX_NUT'				=> 'Nut',
	'BBFRONT_GRID_FX_SHU'				=> 'Shu',
	'ACP_BBFRONT_INFINITE_SCROLL'			=> 'Use infinite scroll',
	'ACP_BBFRONT_INFINITE_SCROLL_EXPLAIN'	=> 'Enable or disable infinite scroll effect. When enabled the cards will be automatically loaded when the user scrolls down to view more cards.',
	'ACP_BBFRONT_AJAX_NEW_POSTS'			=> 'Load new posts without page reload',
	'ACP_BBFRONT_AD_FREQUENCY'				=> 'Ad card frequency',
	'ACP_BBFRONT_AD_FREQUENCY_EXPLAIN'		=> 'Select the frequency of which the advertisement or custom code is shown between cards. Relatively high number is recommended',
	'ACP_BBFRONT_AD_CONTENT'				=> 'Ad code',
	'ACP_BBFRONT_AD_CONTENT_EXPLAIN'		=> 'Add your advertisement code or custom code. HTML is enabled.',
	
	'SITESPLAT_COM'		        			=> 'https://sitesplat.com',
	'SITESPLAT_COPY'		    			=> '&#169; SiteSplat',
	'LICENSE_INFO'		        			=> 'Proprietary - SiteSplat All rights reserved',
	'EXTENSION_DEVELOPER'	    			=> 'Developer',
	'ACP_NOTICE_CLOSE'						=> 'Close',
	'ACP_BBFRONT_VERSION'       			=> '2.0.2',
	'ACP_LOADING'		        			=> 'Loading... Hold on',

	'EXT_BBF_DESCRIPTION_PAGE'				=> 'A modern front page WordPress style for your board',
	'EXT_BBF_TASKS_1'						=> 'Special Group permissions',
	'EXT_BBF_TASKS_2'						=> 'Choose what to publish and the format',
	'EXT_BBF_TASKS_3'						=> 'Checkout the other premium addons on <a href="https://sitesplat.com/phpBB3/marketplace.php">sitesplat.com/marketplace.php</a>',
	'EXT_BBF_TASKS_4'						=> 'Supports video embed with BBembed premium extension',
	'EXT_BBF_TASKS_5'						=> 'Dynamic Masonry layout',
	'EXT_BBF_TASKS_6'						=> 'phpBB 3.2 ready',
	
	'ACP_BBTAGS_NOTICE_CLOSE'				=> 'Close',
	'NOTICE_BBTAGS'							=> 'The extension <a href="https://sitesplat.com/phpBB3/marketplace.php?mode=view&item_id=36"><strong>BBtags</strong></a> is not installed, you can NOT use the Tags in the published blocks',
	'NOTICE_BBEMBED'						=> 'The extension <a href="https://sitesplat.com/phpBB3/marketplace.php?mode=view&item_id=32"><strong>BBembed</strong></a> is not installed, you can NOT use Media Rich Cards in the published blocks',
	'NOTICE_LIKEBB'							=> 'The extension <a href="https://sitesplat.com/phpBB3/marketplace.php?mode=view&item_id=22"><strong>LikeBB</strong></a> is not installed, you can NOT use Like/dislike system in the published blocks',
	'SS_HELPER_NOTY'	            		=> 'SiteSplat BBcore does not exist!<br />Download the <a href="https://sitesplat.com" target="_blank">BBcore</a> and copy the BBcore folder into your sitesplat extension folder.',
	'BBFRONT_NOTICE'	            		=> '<div class="phpinfo"><p>The settings for this extension are in <strong>%1$s » %2$s » %3$s</strong>.<br/>You can add cards to the front page while composing a post and/or also via the ajax quick card pin directly in viewtopic page.</p></div>',
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
			'NOTICE_1'			=> 'phpBB 3.3 ready',
		)
	)
));
