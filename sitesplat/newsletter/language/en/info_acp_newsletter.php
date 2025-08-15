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
    'FORUMS_NEWS_FROM'		    => 'Newsletter forum source',
	'FORUMS_FROM_EXPLAIN'		=> 'Select the forums you would like the users to receive the news from',
	'SEND_IMMEDIATELY'			=> 'Send immediately',
	'SEND_IMMEDIATELY_EXPLAIN'	=> 'Attempt to send the emails immediately. This depends on the server email configuration parameters',
	'PERIOD'					=> 'Email Overview (or Catch-up) Period',
	'PERIOD_EXPLAIN'			=> 'This will send autmatic "Catch-up"  emails to the users that are subscribed. The e-mail will be generated based on the new topics in the forum. The user will receive an email with the purpose of engaging the user\'s interest in the recent board\'s activity. Edit the templates file named newsletter_html.txt for the HTML version and newsletter_txt.txt for the TXT version from:<br /> <code>root\ext\sitesplat\newsletter\language\en\email\</code> <br /> To learn how to send out professional looking HTML emails check out the tutorials over at <a href=" https://sitesplat.com/" target="_blank">sitesplat.com</a> or click the "Tutorials" label above.',
	'WEEKLY'					=> 'Weekly',
	'MONTHLY'					=> 'Monthly',
	'NO_OVERVIEW'				=> 'None',
	'PERIOD_SEND'				=> 'Set period for automatic newsletter',
	'SEND_TO_GROUP'				=> 'Send to group',
	'SEND_TO_USERS'				=> 'Send to user(s)',
	'SEND_TO_USERS_EXPLAIN'		=> 'When using this field it will override the "Send to Group" option above. Each user on a new line',
	'ALL_USERS'					=> 'All users',
	'NEW_USER'					=> 'Allow new users',
	'MAIL_LOW_PRIORITY'			=> 'Low',
	'MAIL_NORMAL_PRIORITY'		=> 'Normal',
	'MAIL_HIGH_PRIORITY'		=> 'High',
	'MAIL_PRIORITY'				=> 'Mail priority',
	'USE_HTML'					=> 'Use HTML emails',
	'COMPOSE_HTML'				=> 'Send manually',
	'COMPOSE_HTML_EXPLAIN'		=> 'If "Send manually" is selected the HTML editor will be available to send custom emails in HTML format',
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
	'ACP_NEWSOVERVIEW_SEND'		=> 'Newsletter(s) sent successfully',
	'ACP_NEWSOVERVIEW_SAVED'	=> 'Settings saved successfully',
	
	'SITESPLAT_COM'		        => 'https://sitesplat.com',
	'SITESPLAT_COPY'		    => '&#169; SiteSplat',
	'LICENSE_INFO'		        => 'Proprietary - SiteSplat All rights reserved',
	'EXTENSION_DEVELOPER'	    => 'Developer',
	'ACP_NOTICE_CLOSE'			=> 'Close',
	'ACP_NEWS_VERSION'          => '1.0.5',
	'ACP_LOADING'		        => 'Loading... Hold on',
	'FORUM_CONTENT'		        => 'forum content',
	'EXT_NEWS_DESCRIPTION_PAGE'	=> 'A Newsletter system with an archive, weekly, monthly and many more options to run your own HTML style newsletter like a pro!',
	'EXT_NEWS_TASKS_1'			=> 'Newsletter Archive',
	'EXT_NEWS_TASKS_2'			=> 'Full HTML Enabled',
	'EXT_NEWS_TASKS_3'			=> 'Synchronization with Cron tasks and compatible with <a href="https://www.phpbb.com/customise/db/extension/cronstatus/">Cron Status</a>',
	'EXT_NEWS_TASKS_4'			=> 'Scheduled Newsletter',
	'EXT_NEWS_TASKS_5'			=> 'Checkout the other premium addons on <a href="https://sitesplat.com/phpBB3/marketplace.php">sitesplat.com/marketplace.php</a>',
	'EXT_NEWS_TASKS_6'			=> 'phpBB 3.2 ready',

	'NEWS_SUBSCRIBERS_INFO'     => 'Subscribers and news info',
	'NEWS_TRICKS_TITLE'         => 'Tips and Tricks',
	'ACP_NEWS_TRICK_EXPLAIN'	=> '<p>Does your ISP limit the number of emails you can send each day?</p>
									<p><strong>Of course they do!</strong>
									</p>
									<p>Every outgoing SMTP mail server is guided by a provider’s email policy which includes hourly and/or daily email send limits. This policy will ultimately determine how many emails you can send each day. You can find a list of the hourly and daily send limits for most of the major ISPs, web hosting companies and Free email address providers below.</p>
									<p><strong><a title="Email sending limits for isp, web hosting and free email providers" href="http://group-mail.com/sending-email/email-sending-limits-for-isp-web-hosting-and-free-email-providers/">Email Sending Limits of ISP, Web Hosting and Free Email Providers</a></strong>
									</p>
									<p>If you try to send more email than the hourly or daily email sending limits of your mail server, you will notice errors being returned after the specified quota is met, saying something along the lines of:<em> </em>
									</p>
									<blockquote>
										<p><em>you have reached your daily sending quota</em>…</p>
									</blockquote>
									<p>If you surpass the daily <a title="SMTP email sending limits" href="http://group-mail.com/sending-email/email-sending-limits-for-isp-web-hosting-and-free-email-providers/">SMTP email sending limits</a> of your provider, you will generally have to wait 24 hours before you can send more email through that particular server.</p>
									<p>But, what are the hourly or daily email sending limits for <em>your</em> email server?</p>
									<ul>
										<li>The Gmail mail server send limit is approximately 100-150 emails per day when connected to the server from a remote email client. You can send 500 emails each day through the Gmail SMTP server when logged into their web interface.</li>
										<li>The Comcast mail server limits residential customers to send 1,000 messages per day. Comcast Business customers can send 24,000 emails per day through the Comcast outgoing SMTP mail server.</li>
										<li>The basic GoDaddy email server limits senders to send&nbsp; only 250 outgoing emails per day, but you can <a title="send more email by adding SMTP relays to your GoDaddy account" href="http://group-mail.com/sending-email/how-to-increase-your-godaddy-email-sending-limits/">send more email by adding SMTP relays to your GoDaddy account</a>
										</li>
									</ul>
									<p>&nbsp;</p>
									<p>So, what’s a guy to do if he needs to get his monthly email newsletter out to 5,000 eager subscribers but his ISP has a daily send limit of 500 emails per day?</p>
									<p><strong>What can you do if your mail server has limits that don’t support the size of your mailing list?</strong>
									</p>
									<p>If your current outgoing SMTP email server does not support your email list size or sending frequency, you have a variety of options:</p>
									<p style="padding-left: 30px;">1. Contact the host of your outgoing SMTP mail server(s) and ask if they have a business account that lets you send more emails each day to support your business.</p>
									<p style="padding-left: 30px;">2. Use GroupMail’s <a title="sending email without an external SMTP mail server" href="http://group-mail.com/sending-email/sending-email-without-an-external-smtp-mail-server/">Direct Send option</a>, which allows you to bypass your external SMTP server altogether and send email directly from your computer to your recipients using GroupMail’s own internal SMTP engine.</p>
									<p style="padding-left: 30px;">3. Use an outgoing SMTP service like <a title="SMTP2Go outgoing relay pricing" href="http://groupmail.smtp2go.com">SMTP2Go</a> to relay your large email campaigns.</p>
									<p style="padding-left: 30px;">4. Find a web hosting company who has daily email sending limits that meet your needs.</p>
									<p style="padding-left: 30px;">5. Setup your own <a href="http://www.msexchange.org/tutorials/MF002.html">MS Exchange Server</a> and configure it for SMTP email delivery.</p>
									<p>So, while GroupMail allows you to send and manage email lists of an <strong>unlimited</strong> size; the success of email delivery to large groups is ultimately dependent upon the sending limits set forth in the email sending policy of the SMTP mail server you are using.</p>
									<p><strong>Related articles you might find interesting:</strong>
									</p>
									<p><a title="email sending limits of ISPs web hosting and free email providers" href="http://group-mail.com/sending-email/email-sending-limits-for-isp-web-hosting-and-free-email-providers/">Email Sending Limits for ISPs, Web Hosting and Free Email Providers</a>
									</p>
									<p><a title="Common email error code descriptions and fixes" href="http://group-mail.com/email-error-codes/common-email-error-codes/">Common Email Error Code Descriptions and Fixes</a>
									</p>
									<p><a title="Free Email Newsletter and Marketing Software and Services" href="http://group-mail.com/email-marketing/free-email-newsletter-and-marketing-software-and-services/">Free Email Newsletter and Marketing Software and Services</a>
									</p>
									<p><a title="Email Settings for the Most Common Email Server hosts" href="http://group-mail.com/category/email-settings/">Email Settings for the Most Common Email Server Hosts</a>
									</p>
									<p><a title="step by step guide for email setup and delivery" href="http://group-mail.com/getting-started-with-groupmail/step-by-step-guide-for-email-setup-and-delivery/">Step-by-Step Guide for Email Setup and Delivery</a>
									</p>
									<p>&nbsp;</p>
									<hr>
									<p></p>',
	
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
	
	
	'NEWSLETTER_NOTICE'			=> '<div class="phpinfo"><p>The settings for this extension are under <strong>%1$s &#187; %2$s &#187; %3$s</strong>. <br />Please note, at first setup when the period is set (for example weekly) and the format (HTML) the first automatic newsletter overview is sent out immediately right after the settings are saved! <br />This is needed to start the Synchronization. With this in mind, consider using a test board before using the extension to make sure the end result of the newlsetter is the preferred look.</p></div>',
	'SS_HELPER_NOTY'			=> 'SiteSplat BBcore does not exist!<br />Download the <a href="https://sitesplat.com" target="_blank">BBcore</a> and copy the BBcore folder into your sitesplat extension folder.',
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
