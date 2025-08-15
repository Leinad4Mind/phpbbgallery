<?php
/**
*
* @package BBnewsletter
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
	'ACP_NEWSLETTER'			=> 'Newsletter',
	'ACP_NEWSLETTER_EXPLAIN'	=> 'Setup your Newsletter, several options are available below. Please make sure your mailserver accepts all mails, otherwise it will use phpbb\'s mail settings to send emails in small batches. <br />The weekly and monthly "Catch-up" forum news are sent out by the cron task. Install <a href="https://github.com/ForumHulp/cronstatus" target="_blank">Cronstatus extension</a> and select "Run cron always" in the options to run more often the "Catch-up" News (This is especially useful for small forums). <br />For HTML e-mails install <a href=" https://github.com/ForumHulp/htmlemail" target="_blank">HTML emails Extension</a> which enables the HTML settings.<br />',

	'SEND_IMMEDIATELY'			=> 'Send immediately',
	'SEND_IMMEDIATELY_EXPLAIN'	=> 'Attempt to send the emails immediately. This depends on the server email configuration parameters',
	'PERIOD'					=> 'Email Overview (or Catch-up) Period',
	'PERIOD_EXPLAIN'			=> 'This will send autmatic "Catch-up"  emails to the users that are subscribed. The e-mail will be generated based on the new topics in the forum. The user will receive an email with the purpose of engaging the user\'s interest in the recent board\'s activity. Edit the templates file named newsletter_html.txt for the HTML version and newsletter_txt.txt for the TXT version from:<br /> <code>root\ext\sitesplat\newsletter\language\en\email\</code> <br /> To learn how to send out professional looking HTML emails check out the tutorials over at <a href=" http://sitesplat.com/" target="_blank">sitesplat.com</a> or click the "Tutorials" label above.',
	'WEEKLY'					=> 'Weekly',
	'MONTHLY'					=> 'Monthly',
	'NO_OVERVIEW'				=> 'None',
	'PERIOD_SEND'				=> 'Set period for automatic newsletter',
	'SEND_TO_GROUP'				=> 'Send to group',
	'SEND_TO_USERS'				=> 'Send to user(s)',
	'SEND_TO_USERS_EXPLAIN'		=> 'When using this field it will overide the groupselect. Each user on a new line',
	'ALL_USERS'					=> 'All users',
	'NEW_USER'					=> 'Allow new users',
	'MAIL_LOW_PRIORITY'			=> 'Low',
	'MAIL_NORMAL_PRIORITY'		=> 'Normal',
	'MAIL_HIGH_PRIORITY'		=> 'High',
	'MAIL_PRIORITY'				=> 'Mail priority',
	'USE_HTML'					=> 'Use HTML emails',
	'COMPOSE_HTML'				=> 'Send manually',
	'COMPOSE_HTML_EXPLAIN'		=> 'If "Send manually" is selected the HTML editor will be available to send the emails in HTML format.',
	'MASS_MESSAGE'				=> 'Message (Newsletter Body)',
	'MASS_MESSAGE_EXPLAIN'		=> 'HTML message will be stripped if HTML email Extension is not enabled. To use the HTML editor click on "Tools" then "Source code" and enter the HTML code in the code editor ',
	'FHHTML_EMAIL_NOT_ENABLED'	=> 'HTML email extension not enabled. Download it from https://github.com/ForumHulp/htmlemail',
	'FHHTML_EMAIL_DOWNLOAD'	    => 'HTML email Extension not enabled. Download it from <a href="https://github.com/ForumHulp/htmlemail" target="blank">GithHub HTML Email Ext</a>',
	'LAST_SEND'					=> '<span id="viewsubscribers" class="label label-info" title="View subscribers">%1$s Members</span> subscribed, last letter was sent on <strong class="text-info">%2$s</strong>',
	'LAST_SEND_LETTERS'			=> 'Last newsletters',
	'LAST_SEND_EXPLAIN'			=> '**Please note, new registered users are automatically subscribed. (Click "X Members" above to view the users list)',
	'LAST_NEWSLETTERS_EXPLAIN'	=> '**Please note, the following template visualized on the single emails below does NOT reflect 100% the email that was sent out. This is due to phpBB\'s ACP stylesheet obsolete CSS reset rules. Refer to your email copy or front-end archive for the exact email accuracy.<br /> This is a list with the sole purpose of keeping track of the emails and users in a simple manner.<br />Always save a copy of the composed HTML email before sending it out if you wish to re-use it in the future.',
	'NEWS_PAGE'					=> 'Visible',
	'HIDE'						=> 'Hide',
	'SHOW'						=> 'Show',
	'DELETE_MAIL_SUCCES'		=> 'Newsletter deleted',
	'ACP_NEWSOVERVIEW_SEND'		=> 'Newsletter(s) sent succesfully',
	'ACP_NEWSOVERVIEW_SAVED'	=> 'Settings saved succesfully',
	
	'SITESPLAT_COM'		        => 'http://sitesplat.com',
	'SITESPLAT_COPY'		    => '&#169; SiteSplat',
	'LICENSE_INFO'		        => 'Proprietary - SiteSplat All rights reserved',
	'EXTENSION_DEVELOPER'	    => 'Developer',
	'ACP_NOTICE_CLOSE'			=> 'Close',
	'ACP_NEWS_VERSION'          => '1.0.3',
	'ACP_LOADING'		        => 'Loading... Hold on',
	'FORUM_CONTENT'		        => 'forum content',
	'EXT_NEWS_DESCRIPTION_PAGE'	=> 'A Newsletter system with an archive, weekly, monthly and many more options to run your own HTML style newsletter like a pro!',
	'EXT_NEWS_TASKS_1'			=> 'Newsletter Archive',
	'EXT_NEWS_TASKS_2'			=> 'Full HTML Enabled',
	'EXT_NEWS_TASKS_3'			=> 'Synchronization with Cron tasks and compatible with <a href="https://www.phpbb.com/customise/db/extension/cronstatus/">Cron Status</a>',
	'EXT_NEWS_TASKS_4'			=> 'Scheduled Newsletter',
	'EXT_NEWS_TASKS_5'			=> 'Checkout the other premium addons on <a href="http://www.sitesplat.com/phpBB3/marketplace.php">sitesplat.com/marketplace.php</a>',
	'EXT_NEWS_TASKS_6'			=> 'phpBB 3.2 ready',

	'EXT_NEWS_TUTORIALS_TITLE'  => 'Tutorials',
	'EXT_NEWS_TUTORIALS_EXPLAIN'=> '<li><p>Templates</p>
					<ul>
					<li><a href="http://htmlemailboilerplate.com/" target="_blank"><strong>HTML Email Boilerplate</strong></a>: A great <strong>starting point</strong> for coding emails.</li>
					<li><a href="http://www.campaignmonitor.com/templates/" target="_blank"><strong>Campaign Monitor Templates</strong></a>: Template builder + free downloadable templates</li>
					</ul>
					</li>
					
					<li><p>Tutorials &amp; Guides</p>

					<ul>
					<li><a href="http://kb.mailchimp.com/article/how-to-code-html-emails" target="_blank"><strong>How To Code HTML Emails (Mailchimp)</strong></a>: How HTML email works, basic concepts, best practices, tips and tricks</li>
					<li><a href="http://www.smashingmagazine.com/2010/01/19/design-and-build-an-email-newsletter-without-losing-your-mind/" target="_blank"><strong>Design and Build Email Newsletters Without Losing Your Mind (and Soul)</strong></a>:  information you need to plan, design and build an HTML newsletter that renders well</li>
					<li><a href="http://mailchimp.com/resources/guides/email-marketing-field-guide/html/" target="_blank"><strong>Email Marketing Field Guide (Mailchimp)</strong></a></li>
					<li><a href="http://mattmedia.net/2007/08/23/8-html-email-tips-i-wish-i-knew-sooner/" target="_blank"><strong>8 HTML Email Tips I Wish I’d Known Sooner</strong></a></li>
					<li><a href="http://www.campaignmonitor.com/css/" target="_blank"><strong>The Ultimate Guide</a>: From Campaign Monitor</strong></li>
					<li><a href="http://css-tricks.com/using-css-in-html-emails-the-real-story/" target="_blank"><strong>CSS Tricks: Using CSS in HTML Emails</strong></a>: Some "I told you so"\'s and tips about HTML emails and CSS.</li>
					</ul>
					</li>
					
					<li><p>Testing</p>

					<ul>
					<li><a href="http://www.emailonacid.com/" target="_blank"><strong>Email on Acid</strong></a>: Free and paid testing</li>
					<li><a href="http://litmus.com/" target="_blank"><strong>Litmus</strong></a></li>
					</ul>
					</li>
					
					<li><p>Other Resources</p>

					<ul>
					<li><a href="http://www.campaignmonitor.com/resources/will-it-work/email-clients/" target="_blank"><strong>Campaign Monitor\'s Popular E-Mail Clients</strong></a></li>
					</ul>
					</li>',
	
	
	'NEWSLETTER_NOTICE'			=> '<div class="phpinfo"><p>The settings for this extension are under <strong>%1$s &#187; %2$s &#187; %3$s</strong>.</p></div>',
	'SS_HELPER_NOTY'			=> 'SiteSplat BBcore does not exist!<br />Download the <a href="http://sitesplat.com" target="_blank">BBcore</a> and copy the BBcore folder into your sitesplat extension folder.',
));

// Description of Donations extension
$lang = array_merge($lang, array(
	'DESCRIPTION_PAGE'		=> 'Description',
	'DESCRIPTION_NOTICE'	=> 'Extension note',
	'ext_details' => array(
		'details' => array(
			'DESCRIPTION_1'	=> 'HTML newsletter',
			'DESCRIPTION_2'	=> 'Groupselect',
			'DESCRIPTION_3'	=> 'Weekly / monthly news overview',
			'DESCRIPTION_4'	=> 'Send immediately or in batch',
			'DESCRIPTION_5'	=> 'Overview subscribers',
		),
		'note' => array(
			'NOTICE_1'		=> '<a href="https://github.com/ForumHulp/htmlemail" target="_blank">HTML email extension</a> is needed to enable the HTML settings.',
			'NOTICE_2'		=> 'phpBB 3.2 ready'
		)
	)
));
