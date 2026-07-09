<?php
/**
*
* @package BBgdpr
* @copyright (c) 2018 SiteSplat All rights reserved
* @license Proprietary
*/

namespace sitesplat\bbgdpr\migrations;

class m3_acp extends \phpbb\db\migration\migration
{
	public function effectively_installed()
	{
		$sql = 'SELECT module_id
			FROM ' . $this->table_prefix . "modules
			WHERE module_class = 'acp'
				AND module_langname = 'ACP_BBGDPR'";
		$result = $this->db->sql_query($sql);
		$module_id = $this->db->sql_fetchfield('module_id');
		$this->db->sql_freeresult($result);

		return $module_id !== false;
	}

	static public function depends_on()
	{
		return array('\sitesplat\bbgdpr\migrations\m2_add_accept_dates');
	}

	public function update_data()
	{
		return array(
			array('config_text.add', array('sitesplat_bbgdpr_js', '')),
			array('config_text.add', array('sitesplat_bbgdpr_privacy_policy', '&lt;h1&gt;GDPR Policy&lt;/h1&gt; 
	  &lt;p&gt;Privacy and General Data Protection Regulation &lt;a rel=&quot;nofollow&quot; href=&quot;https://eur-lex.europa.eu/legal-content/EN/TXT/?uri=celex%3A32016R0679&quot;&gt;(GDPR) (EU) 2016/679&lt;/a&gt;&lt;/p&gt;
	  &lt;dl&gt;
		  &lt;dt&gt;Privacy Principles Relating to Processing and Usage of User Personal Data&lt;/dt&gt;
		  &lt;dd&gt;
		    &lt;p&gt;This forum does store personal information for each user for the purpose of enhancing user experience. There are mandatory info and optional info divided as follows:&lt;/p&gt;
			  &lt;strong&gt;Mandatory:&lt;/strong&gt;
			  &lt;ul&gt;
				 &lt;li&gt;Username&lt;/li&gt;
				 &lt;li&gt;E-mail&lt;/li&gt;
				 &lt;li&gt;Account password&lt;/li&gt;
				 &lt;li&gt;User IP/s&lt;/li&gt;
			  &lt;/ul&gt;
			  &lt;strong&gt;Optional:&lt;/strong&gt;
              &lt;ul&gt;			  
				 &lt;li&gt;Date of Birth&lt;/li&gt;
				 &lt;li&gt;Avatar&lt;/li&gt;
				 &lt;li&gt;User Signature&lt;/li&gt;
				 &lt;li&gt;Website&lt;/li&gt;
				 &lt;li&gt;Facebook&lt;/li&gt;
				 &lt;li&gt;Twitter&lt;/li&gt;
				 &lt;li&gt;Skype&lt;/li&gt;
				 &lt;li&gt;YouTube&lt;/li&gt;
				 &lt;li&gt;Google+&lt;/li&gt;
			  &lt;/ul&gt;
			 &lt;p&gt;We do not disclose personal information to third parties. User can easily and clearly delete all their personal information (Mandatory and Optional) via their UCP (User Control Panel) under the &quot;Privacy&quot; section.&lt;/p&gt;
		  &lt;/dd&gt;
		&lt;/dl&gt;
       &lt;dl&gt; 		
		  &lt;dt&gt;Data Protection Officer &lt;abbr title=&quot;Data Protection Officer&quot; class=&quot;initialism&quot;&gt;DPO&lt;/abbr&gt;&lt;/dt&gt;
		  &lt;dd&gt;Based on this forum criteria we do NOT require a Data Protection Officer DPO to be appointed. The forum Global Moderators are required and trained to be knowledgeable of the GDPR regulation: &lt;a href=&quot;https://gdpr-info.eu/&quot; target=&quot;_blank&quot;&gt;https://gdpr-info.eu/&lt;/a&gt;&lt;/dd&gt;
		&lt;/dl&gt;
		&lt;dl&gt; 
		  &lt;dt&gt;Data Controller Officer &lt;abbr title=&quot;Data Controller Officer&quot; class=&quot;initialism&quot;&gt;DCO&lt;/abbr&gt;&lt;/dt&gt;
		  &lt;dd&gt;Based on this forum criteria we do NOT require a Data Controller Officer DCO to be appointed.&lt;/dd&gt;
        &lt;/dl&gt;
		&lt;dl&gt;
		  &lt;dt&gt;Breach Notification&lt;/dt&gt;
		  &lt;dd&gt;In the event of a breach of security all the users involved in the breach will be promptly notified by the forum Admin.&lt;/dd&gt;
	  &lt;/dl&gt;
	 
	&lt;h1&gt;Cookies Policy&lt;/h1&gt;
    &lt;p&gt;This forum (&quot;us&quot;, &quot;we&quot;, or &quot;our&quot;) uses cookies on this website (the &quot;Service&quot;). By using the Service, you consent to the use of cookies. Our Cookies Policy explains what cookies are, how we use cookies, how third-parties we may partner with may use cookies on the Service, your choices regarding cookies and further information about cookies.&lt;/p&gt;
    &lt;dl&gt;
      &lt;dt&gt;What are cookies&lt;/dt&gt;
      &lt;dd&gt;Cookies are small pieces of text sent by your web browser by a website you visit. A cookie file is stored in your web browser and allows the Service or a third-party to recognize you and make your next visit easier and the Service more useful to you.&lt;/dd&gt;
      &lt;dd&gt;Cookies can be &quot;persistent&quot; or &quot;session&quot; cookies. Persistent cookies remain on your personal computer or mobile device when you go offline, while session cookies are deleted as soon as you close your web browser.&lt;/dd&gt;
    &lt;/dl&gt;
    &lt;dl&gt;
      &lt;dt&gt;How we uses cookies&lt;/dt&gt;
      &lt;dd&gt;When you use and access the Service, we may place a number of cookies files in your web browser. We use cookies for the following purposes:&lt;/dd&gt;
      &lt;dd&gt;
        &lt;ul&gt;
            &lt;li&gt;To enable certain functions of the Service&lt;/li&gt;
            &lt;li&gt;We use both session and persistent cookies on the Service and we use different types of cookies to run the Service.&lt;/li&gt;
            &lt;li&gt;Essential cookies. We may use essential cookies to authenticate users and prevent fraudulent use of user accounts.&lt;/li&gt;
        &lt;/ul&gt;
      &lt;/dd&gt;
    &lt;/dl&gt;
    &lt;dl&gt;
      &lt;dt&gt;What are your choices regarding cookies&lt;/dt&gt;
      &lt;dd&gt;If you would like to delete cookies or instruct your web browser to delete or refuse cookies, please visit the help pages of your web browser.&lt;/dd&gt;
      &lt;dd&gt;Please note, however, that if you delete cookies or refuse to accept them, you might not be able to use all of the features we offer, you may not be able to store your preferences, and some of our pages might not display properly.&lt;/dd&gt;
      &lt;dd&gt;
        &lt;ul&gt;
          &lt;li&gt;For the Chrome web browser, please visit this page from Google: &lt;a href=&quot;https://support.google.com/accounts/answer/32050&quot;&gt;https://support.google.com/accounts/answer/32050&lt;/a&gt;&lt;/li&gt;
          &lt;li&gt;For the Internet Explorer web browser, please visit this page from Microsoft: &lt;a href=&quot;http://support.microsoft.com/kb/278835&quot;&gt;http://support.microsoft.com/kb/278835&lt;/a&gt;&lt;/li&gt;
          &lt;li&gt;For the Firefox web browser, please visit this page from Mozilla: &lt;a href=&quot;https://support.mozilla.org/en-US/kb/delete-cookies-remove-info-websites-stored&quot;&gt;https://support.mozilla.org/en-US/kb/delete-cookies-remove-info-websites-stored&lt;/a&gt;&lt;/li&gt;
          &lt;li&gt;For the Safari web browser, please visit this page from Apple: &lt;a href=&quot;https://support.apple.com/kb/PH21411?locale=en_US&quot;&gt;https://support.apple.com/kb/PH21411?locale=en_US&lt;/a&gt;&lt;/li&gt;
          &lt;li&gt;For any other web browser, please visit your web browser\'s official web pages.&lt;/li&gt;
        &lt;/ul&gt;
      &lt;/dd&gt;
    &lt;/dl&gt;
    &lt;dl&gt;
      &lt;dt&gt;Where can you find more information about cookies&lt;/dt&gt;
      &lt;dd&gt;You can learn more about cookies and the following third-party websites:&lt;/dd&gt;
      &lt;dd&gt;
        &lt;ul&gt;
          &lt;li&gt;AllAboutCookies: &lt;a href=&quot;http://www.allaboutcookies.org/&quot;&gt;http://www.allaboutcookies.org/&lt;/a&gt;&lt;/li&gt;
          &lt;li&gt;Network Advertising Initiative: &lt;a href=&quot;http://www.networkadvertising.org/&quot;&gt;http://www.networkadvertising.org/&lt;/a&gt;&lt;/li&gt;
        &lt;/ul&gt;
      &lt;/dd&gt;
    &lt;/dl&gt;')),

			array('permission.add', array('u_delete_my_account_posts')),
			array('permission.add', array('u_delete_my_account_pms')),

			array('module.add', array(
				'acp',
				'ACP_CAT_DOT_MODS',
				'ACP_BBGDPR'
			)),
			array('module.add', array(
				'acp',
				'ACP_BBGDPR',
				array(
					'module_basename'	=> '\sitesplat\bbgdpr\acp\main_module',
					'modes'				=> array('settings'),
				),
			)),
		);
	}
}
