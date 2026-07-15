<?php
/**
*
* BBlightbox
* @copyright (c) 2017 sitesplat.com All rights reserved
* @license Proprietary
*
*/

/**
* DO NOT CHANGE
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
	// Titles
	'ACP_BBLIGHTBOX'					=> 'BBlightBox',
	'ACP_BBLIGHTBOX_TITLE'				=> 'BBlightBox',
	'ACP_BBLIGHTBOX_EXPLAIN'			=> 'Welcome to your new Lightbox addon setting page. From here you can change settings depending on the chosen plugin. There are four plugins in total. Two are vanilla JavaScript powered and two are jQuery dependent. <br />Choose the one fits your needs best!',
	'ACP_SETTINGS'						=> 'Settings',

	// General settings
	'ACP_BBLIGHTBOX_GENERAL_OPTIONS'	=> 'General settings',
	'ACP_BBLIGHTBOX_ALLOW'				=> 'Allow BBlightBox',
	'ACP_BBLIGHTBOX_BBCODE_ALLOW'		=> 'BBlightBox for IMG BBcodes',
	'ACP_BBLIGHTBOX_BBCODE_EXPLAIN'		=> 'Allow BBlightBox for images posted via the default IMG BBcode',
	'BBLIGHTBOX_CAPTIONS'				=> 'Captions',
	'BBLIGHTBOX_CAPTIONS_EXPLAIN'		=> 'Allows images captions or comment whenever possible',
	'BBLIGHTBOX_SLIDE'					=> 'Slideshow between pictures',
	'BBLIGHTBOX_SLIDE_EXPLAIN'			=> 'Allow to create a slideshow for the attached (BBCode images included) when possible. <br />This depends on the plugin chosen and will either slideshow groups of images, for example XX post or the whole images contained in XX topic.',
	'QUOTED_IMAGES'						=> 'Resize quoted IMG BBcode',
	'QUOTED_IMAGES_EXPLAIN'				=> 'Allow to resize quoted (between a post quote) images posted via the IMG BBcode',
	'RESIZED_IMAGES'					=> 'Resize IMG BBcode images',
	'RESIZED_IMAGES_EXPLAIN'			=> 'Resize the default IMG BBcode images to xx pixels. 0 to switch off',
	'ACP_BBLIGHTBOX_LAYOUT_PREVIEW'	    => 'Attachment layout',
	'COLUMN_LAYOUT'						=> 'Attachment layout',
	'COLUMN_LAYOUT_EXPLAIN'				=> 'Allow to choose a predefined post attachment layout to create a more modern and visually pleasing format. IMG BBcodes are not affected.<small style="margin-top:-4px;margin-bottom: 14px;display: block;"><br /><strong>Standard layout:</strong> theme default. Images are displayed "as is". They can take up to the full post width.<br /><strong>Column:</strong> Images are neatly orginized into a full column and all the same size.<br /><strong>Grouped (medium):</strong> images are grouped in medium size and with a masonry like positioning.<br /><strong>grouped (small):</strong> Images are positioned the same as the grouped medium except just smaller in size.</small>',
	'1COLLUMS'							=> 'Standard layout',
	'2COLLUMS'							=> 'column',
	'3COLLUMS'							=> 'grouped (medium)',
	'4COLLUMS'							=> 'grouped (small)',

	// Plugins
	'ACP_BBLIGHTBOX_PLUGINS'			=> 'Plugins',
	'ACP_BBLIGHTBOX_PLUGIN'				=> 'Main LightBox plugin',
	'ACP_BBLIGHTBOX_PLUGIN_EXPLAIN'		=> 'Choose, which plugin you wish to use as a main lightbox. See more detail regarding the plugins here:<br /><a href="https://github.com/feimosi/baguetteBox.js" target="blank" title="">BaguetteBox (Vanilla JS)</a><br /><a href="http://fancyapps.com/fancybox/3/" target="blank" title="">Fancybox (jQuery)</a><br /><a href="https://github.com/nicolas-t/Chocolat/" target="blank" title="">Chocolat (jQuery)</a><br /><a href="http://jslightbox.felixhagspiel.de/" target="blank" title="">jsOnlyLightbox (Vanilla JS)</a>',

	// baguetteBox
	'BAGUETTEBOX_ANIMATION'				=> 'Animation',
	'SLIDEIN'							=> 'slideIn',
	'FADEIN'							=> 'fadeIn',
	'ZOOM'								=> 'Zoom',
	'ZOOM_IN_OUT'						=> 'Zoom in-out',
	'NONE'								=> 'none',

	// fancybox
	'FANCYBOX_PROTECT'					=> 'Protect images from download',
	'FANCYBOX_PROTECT_EXLPLAIN'			=> 'Prevent the download of the attached images when possible',
	'FANCYBOX_ANIMATIONEFFECT'			=> 'Animation effect',
	'FANCYBOX_ANIMATIONEFFECT_EXPLAIN'	=> 'Allow an animation effect when supported',

	// Chocolat
	'CHOCOLAT_ENABLEZOOM'				=> 'Enable zooming feature',
	'CHOCOLAT_ENABLEZOOM_EXPLAIN'		=> 'Allow zooming images feature when possible. Support touch screen.',

	// misc stuff ext detail etc
	'BBLIGHTBOX_DESCRIPTION'			=> 'A modern and power LightBox system for your forum post images',
	'BBLIGHTBOX_DEVELOPERS'				=> 'Developers',
	'BBLIGHTBOX_TASKS_1'				=> 'Touch screen support, keyboard navigation, responsive and more',
	'BBLIGHTBOX_TASKS_2'				=> 'Slideshow',
	'BBLIGHTBOX_TASKS_3'				=> 'Multi LightBox support',
	'BBLIGHTBOX_TASKS_4'				=> 'Common pages like UCP, MCP, Posting, viewtopic etc ready',
	'BBLIGHTBOX_TASKS_5'				=> 'Checkout the premium extensions on <a href="http://www.sitesplat.com/phpBB3/marketplace.php">sitesplat.com/marketplace.php</a>',
	'BBLIGHTBOX_TASKS_6'				=> 'Much more..!',
	
	'SITESPLAT_COM'		       		    => 'http://sitesplat.com',
	'SITESPLAT_COPY'		    		=> '&#169; SiteSplat',
	'LICENSE_INFO'		        		=> 'Proprietary - SiteSplat All rights reserved',
	'EXTENSION_DEVELOPER'	    		=> 'Developer',
	'ACP_BBLIGHTBOX_NOTICE_CLOSE'		=> 'Close',
	
	'ACP_BBLIGHTBOX_VERSION'			=> '1.0.0',
    'ACP_LOADING'			    		=> 'Hold On. Loading...',
	
	// Error/success messages
	'ACP_BBLIGHTBOX_SETTING_SAVED'		=> 'BBlightBox settings saved',
	'SS_HELPER_NOTY'	                => 'SiteSplat BBcore does not exist!<br />Download the <a href="http://sitesplat.com" target="_blank">BBcore</a> and copy the BBcore folder into your sitesplat extension folder.',
	'BBLIGHTBOX_NOTICE'					=> '<div class="phpinfo"><p>The settings for this extension are in <strong>%1$s &#187; %2$s &#187; %3$s</strong>.</p></div>',
));

// Description of Upload extension
$lang = array_merge($lang, array(
	'DESCRIPTION_PAGE'		=> 'Description',
	'DESCRIPTION_NOTICE'	=> 'Extension note',
	'ext_details' => array(
		'details' => array(
			'DESCRIPTION_1'		=> 'Up to 4 lightboxes',
			'DESCRIPTION_2'		=> 'Slideshow',
			'DESCRIPTION_3'		=> 'Captions',
		),
		'note' => array(
			'NOTICE_1'			=> 'all common pages like UCP, MCP, Posting, viewtopic etc ready',
			'NOTICE_2'			=> 'phpBB 3.2 ready.',
		)
	)
));
