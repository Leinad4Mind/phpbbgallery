Existem diferencas reais no codigo ou texto. Diferencas de formatacao (espacos, tabs) foram ignoradas abaixo.

```diff
diff --git "[ORIGINAL]/rmcgirr83\\searchusertopics/composer.json" "[FORUM_EXT]/rmcgirr83\\searchusertopics/composer.json"
--- "[ORIGINAL]/rmcgirr83\\searchusertopics/composer.json"
+++ "[FORUM_EXT]/rmcgirr83\\searchusertopics/composer.json"
@@ -2,8 +2,8 @@
     "name": "rmcgirr83/searchusertopics",
     "type": "phpbb-extension",
     "description": "This Extension displays number of topics started by a user when visiting that users profile",
-    "version": "1.0.7",
-    "time": "2025-01-25",
+    "version": "1.0.5",
+    "time": "2020-09-12",
     "keywords": [
         "phpbb",
         "extension",
@@ -19,8 +19,8 @@
         }
     ],
     "require": {
-        "php": ">=7.4",
-        "phpbb/phpbb": ">=3.3",
+        "php": ">=7.1",
+        "phpbb/phpbb": ">=3.2",
         "composer/installers": "~1.0.0"
     },
     "require-dev": {
@@ -29,7 +29,7 @@
     "extra": {
         "display-name": "Search user topics",
         "soft-require": {
-            "phpbb/phpbb": ">=3.3"
+            "phpbb/phpbb": ">=3.2"
         },
         "version-check": {
             "host": "www.phpbb.com",
diff --git "[ORIGINAL]/rmcgirr83\\searchusertopics/config/services.yml" "[FORUM_EXT]/rmcgirr83\\searchusertopics/config/services.yml"
--- "[ORIGINAL]/rmcgirr83\\searchusertopics/config/services.yml"
+++ "[FORUM_EXT]/rmcgirr83\\searchusertopics/config/services.yml"
@@ -7,7 +7,6 @@ services:
             - '@dbal.conn'
             - '@language'
             - '@template'
-            - '@user'
             - '%core.root_path%'
             - '%core.php_ext%'
         tags:
diff --git "[FORUM_EXT]/rmcgirr83\\searchusertopics/diff_full.tmp" "[FORUM_EXT]/rmcgirr83\\searchusertopics/diff_full.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/rmcgirr83\\searchusertopics/diff_full.tmp"
@@ -0,0 +1,313 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\searchusertopics/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\searchusertopics/composer.json"
+index f64f37603..f45beab57 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\searchusertopics/composer.json"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\searchusertopics/composer.json"
+@@ -2,8 +2,8 @@
+     "name": "rmcgirr83/searchusertopics",
+     "type": "phpbb-extension",
+     "description": "This Extension displays number of topics started by a user when visiting that users profile",
+-    "version": "1.0.7",
+-    "time": "2025-01-25",
++    "version": "1.0.5",
++    "time": "2020-09-12",
+     "keywords": [
+         "phpbb",
+         "extension",
+@@ -19,8 +19,8 @@
+         }
+     ],
+     "require": {
+-        "php": ">=7.4",
+-        "phpbb/phpbb": ">=3.3",
++        "php": ">=7.1",
++        "phpbb/phpbb": ">=3.2",
+         "composer/installers": "~1.0.0"
+     },
+     "require-dev": {
+@@ -29,7 +29,7 @@
+     "extra": {
+         "display-name": "Search user topics",
+         "soft-require": {
+-            "phpbb/phpbb": ">=3.3"
++            "phpbb/phpbb": ">=3.2"
+         },
+         "version-check": {
+             "host": "www.phpbb.com",
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\searchusertopics/config/services.yml" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\searchusertopics/config/services.yml"
+index 6aafa5510..61043ec2b 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\searchusertopics/config/services.yml"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\searchusertopics/config/services.yml"
+@@ -7,7 +7,6 @@ services:
+             - '@dbal.conn'
+             - '@language'
+             - '@template'
+-            - '@user'
+             - '%core.root_path%'
+             - '%core.php_ext%'
+         tags:
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\searchusertopics/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\searchusertopics/diff_full.tmp"
+new file mode 100644
+index 000000000..e69de29bb
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\searchusertopics/event/listener.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\searchusertopics/event/listener.php"
+index 1149c72b3..93cbe0c6e 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\searchusertopics/event/listener.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\searchusertopics/event/listener.php"
+@@ -18,7 +18,6 @@ use phpbb\config\config;
+ use phpbb\db\driver\driver_interface;
+ use phpbb\language\language;
+ use phpbb\template\template;
+-use phpbb\user;
+ 
+ use Symfony\Component\EventDispatcher\EventSubscriberInterface;
+ 
+@@ -27,24 +26,21 @@ use Symfony\Component\EventDispatcher\EventSubscriberInterface;
+ */
+ class listener implements EventSubscriberInterface
+ {
+-	/** @var auth */
++	/** @var \phpbb\auth\auth */
+ 	protected $auth;
+ 
+-	/** @var config */
++	/** @var \phpbb\config\config */
+ 	protected $config;
+ 
+-	/** @var driver_interface */
++	/** @var \phpbb\db\driver\driver_interface */
+ 	protected $db;
+ 
+-	/** @var language */
++	/** @var \phpbb\language\language */
+ 	protected $language;
+ 
+-	/** @var template */
++	/** @var \phpbb\template\template */
+ 	protected $template;
+ 
+-	/** @var user */
+-	protected $user;
+-
+ 	/** @var string phpBB root path */
+ 	protected $root_path;
+ 
+@@ -57,7 +53,6 @@ class listener implements EventSubscriberInterface
+ 		driver_interface $db,
+ 		language $language,
+ 		template $template,
+-		user $user,
+ 		$root_path,
+ 		$php_ext)
+ 	{
+@@ -66,7 +61,6 @@ class listener implements EventSubscriberInterface
+ 		$this->db = $db;
+ 		$this->language = $language;
+ 		$this->template = $template;
+-		$this->user = $user;
+ 		$this->root_path = $root_path;
+ 		$this->php_ext = $php_ext;
+ 	}
+@@ -83,24 +77,12 @@ class listener implements EventSubscriberInterface
+ 		return array(
+ 			'core.acp_extensions_run_action_after'	=>	'acp_extensions_run_action_after',
+ 			'core.memberlist_view_profile'				=> 'memberlist_view_profile',
+-			'core.page_header_after'	=> 'page_header_after',
+ 		);
+ 	}
+ 
+-	/**
+-	* Display topics search for the user in quick links
+-	*
+-	* @param object $event The event object
+-	* @return null
+-	* @access public
+-	*/
+-	public function page_header_after($event)
++	public function load_language($event)
+ 	{
+ 		$this->language->add_lang('common', 'rmcgirr83/searchusertopics');
+-		$user_id = $this->user->data['user_id'];
+-		$this->template->assign_vars(array(
+-			'U_SEARCH_TOPICS'	=> ($this->auth->acl_get('u_search')) ? append_sid("{$this->root_path}search.$this->php_ext", "author_id=$user_id&amp;sr=topics&amp;sf=firstpost") : '',
+-		));
+ 	}
+ 
+ 	/* Display additional metdate in extension details
+@@ -168,7 +150,7 @@ class listener implements EventSubscriberInterface
+ 				'L_TOTAL_TOPICS'	=> $this->language->lang('TOTAL_TOPICS', $topics_num),
+ 				'TOPICS_PER_DAY'	=> $this->language->lang('TOPICS_PER_DAY', $topics_per_day),
+ 				'TOPICS_PERCENT'	=> $this->language->lang('TOPICS_PERCENT', $topics_percent),
+-				'U_SEARCH_USER_TOPICS'	=> ($this->auth->acl_get('u_search')) ? append_sid("{$this->root_path}search.$this->php_ext", "author_id=$user_id&amp;sr=topics&amp;sf=firstpost") : '',
++				'U_SEARCH_TOPICS'	=> ($this->auth->acl_get('u_search')) ? append_sid("{$this->root_path}search.$this->php_ext", "author_id=$user_id&amp;sr=topics&amp;sf=firstpost") : '',
+ 			));
+ 		}
+ 	}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\searchusertopics/language/en/common.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\searchusertopics/language/en/common.php"
+index ac2bdd52a..9092ee5e4 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\searchusertopics/language/en/common.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\searchusertopics/language/en/common.php"
+@@ -36,7 +36,6 @@ $lang = array_merge($lang, [
+ 	'TOPICS_PER_DAY'		=> '%.2f topics per day',
+ 	'TOPICS_PERCENT'		=> '%.2f%% of all topics',
+ 	'SUT_TOTAL_TOPICS'		=> 'Total topics',
+-	'SEARCH_TOPICS'			=> 'Your topics',
+ 	//Donation
+ 	'PAYPAL_IMAGE_URL'          => 'https://www.paypalobjects.com/webstatic/en_US/i/btn/png/silver-pill-paypal-26px.png',
+ 	'PAYPAL_ALT'                => 'Donate using PayPal',
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\searchusertopics/language/pt/common.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\searchusertopics/language/pt/common.php"
+new file mode 100644
+index 000000000..acef54e9a
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\searchusertopics/language/pt/common.php"
+@@ -0,0 +1,46 @@
++<?php
++/**
++*
++* @package - Search User Topics
++* @copyright (c) 2015 RMcGirr83
++* @license http://opensource.org/licenses/gpl-license.php GNU Public License
++*
++*/
++
++if (!defined('IN_PHPBB'))
++{
++	exit;
++}
++
++if (empty($lang) || !is_array($lang))
++{
++	$lang = [];
++}
++
++// DEVELOPERS PLEASE NOTE
++//
++// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
++//
++// Placeholders can now contain order information, e.g. instead of
++// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
++// translators to re-order the output of data while ensuring it remains correct
++//
++// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
++// equally where a string contains only two placeholders which are used to wrap text
++// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
++// Some characters you may want to copy&paste:
++// ’ » “ ” …
++
++$lang = array_merge($lang, [
++	'SEARCH_USER_TOPICS'	=> 'Pesquisar tópicos do utilizador',
++	'TOPICS_PER_DAY'		=> '%.2f tópicos por dia',
++	'TOPICS_PERCENT'		=> '%.2f%% de todos os tópicos',
++	'SUT_TOTAL_TOPICS'		=> 'Total de tópicos',
++	//Donation
++	'PAYPAL_IMAGE_URL'          => 'https://www.paypalobjects.com/webstatic/en_US/i/btn/png/silver-pill-paypal-26px.png',
++	'PAYPAL_ALT'                => 'Donate using PayPal',
++	'BUY_ME_A_BEER_URL'         => 'https://paypal.me/RMcGirr83',
++	'BUY_ME_A_BEER'				=> 'Buy me a beer for creating this extension',
++	'BUY_ME_A_BEER_SHORT'		=> 'Make a donation for this extension',
++	'BUY_ME_A_BEER_EXPLAIN'		=> 'This extension is completely free. It is a project that I spend my time on for the enjoyment and use of the phpBB community. If you enjoy using this extension, or if it has benefited your forum, please consider <a href="https://paypal.me/RMcGirr83" target="_blank" rel="noreferrer noopener">buying me a beer</a>. It would be greatly appreciated. <i class="fa fa-smile-o" style="color:green;font-size:1.5em;" aria-hidden="true"></i>',
++]);
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\searchusertopics/language/pt_preao/common.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\searchusertopics/language/pt_preao/common.php"
+new file mode 100644
+index 000000000..5593b621f
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\searchusertopics/language/pt_preao/common.php"
+@@ -0,0 +1,47 @@
++<?php
++/**
++*
++* @package - Search User Topics
++* @copyright (c) 2015 RMcGirr83
++* @license http://opensource.org/licenses/gpl-license.php GNU Public License
++*
++*/
++
++if (!defined('IN_PHPBB'))
++{
++	exit;
++}
++
++if (empty($lang) || !is_array($lang))
++{
++	$lang = [];
++}
++
++// DEVELOPERS PLEASE NOTE
++//
++// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
++//
++// Placeholders can now contain order information, e.g. instead of
++// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
++// translators to re-order the output of data while ensuring it remains correct
++//
++// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
++// equally where a string contains only two placeholders which are used to wrap text
++// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
++// Some characters you may want to copy&paste:
++// ’ » “ ” …
++
++$lang = array_merge($lang, [
++	'SEARCH_USER_TOPICS'	=> 'Pesquisar tópicos do utilizador',
++	'TOPICS_PER_DAY'		=> '%.2f tópicos por dia',
++	'TOPICS_PERCENT'		=> '%.2f%% de todos os tópicos',
++	'SUT_TOTAL_TOPICS'		=> 'Total de tópicos',
++	'MY_TOPICS'			=> 'Os Meus Tópicos',
++	//Donation
++	'PAYPAL_IMAGE_URL'          => 'https://www.paypalobjects.com/webstatic/en_US/i/btn/png/silver-pill-paypal-26px.png',
++	'PAYPAL_ALT'                => 'Donate using PayPal',
++	'BUY_ME_A_BEER_URL'         => 'https://paypal.me/RMcGirr83',
++	'BUY_ME_A_BEER'				=> 'Buy me a beer for creating this extension',
++	'BUY_ME_A_BEER_SHORT'		=> 'Make a donation for this extension',
++	'BUY_ME_A_BEER_EXPLAIN'		=> 'This extension is completely free. It is a project that I spend my time on for the enjoyment and use of the phpBB community. If you enjoy using this extension, or if it has benefited your forum, please consider <a href="https://paypal.me/RMcGirr83" target="_blank" rel="noreferrer noopener">buying me a beer</a>. It would be greatly appreciated. <i class="fa fa-smile-o" style="color:green;font-size:1.5em;" aria-hidden="true"></i>',
++]);
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\searchusertopics/styles/FLATBOOTS/template/event/ss_memberlist_view_timeline_item_middle.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\searchusertopics/styles/FLATBOOTS/template/event/ss_memberlist_view_timeline_item_middle.html"
+new file mode 100644
+index 000000000..d395c97e3
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\searchusertopics/styles/FLATBOOTS/template/event/ss_memberlist_view_timeline_item_middle.html"
+@@ -0,0 +1,18 @@
++<!-- IF TOPICS -->
++	<div class="tl-item">
++		<div class="tl-body">
++			<div class="tl-entry">
++				<div class="tl-time"></div>
++				<div class="tl-icon square-icon sm bg-success"><i class="fa fa-file-text"></i></div>
++				<div class="tl-content">
++					<h4 class="tl-tile text-warning">{L_SUT_TOTAL_TOPICS}</h4>
++					<p>
++					{TOPICS}&nbsp;
++					<!-- IF U_SEARCH_TOPICS -->&#45;<strong><a href="{U_SEARCH_TOPICS}">&nbsp;{L_SEARCH_USER_TOPICS}</a></strong><!-- ENDIF -->
++					<!-- IF TOPICS_PERCENT -->&#40;{TOPICS_PERCENT}&nbsp;&#47;&nbsp;{TOPICS_PER_DAY}&#41;<!-- ENDIF -->
++					</p>
++				</div>
++			</div>
++		</div>
++	</div>
++<!-- ENDIF -->
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\searchusertopics/styles/prosilver/template/event/memberlist_view_user_statistics_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\searchusertopics/styles/prosilver/template/event/memberlist_view_user_statistics_after.html"
+index 5ace65df0..53d745135 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\searchusertopics/styles/prosilver/template/event/memberlist_view_user_statistics_after.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\searchusertopics/styles/prosilver/template/event/memberlist_view_user_statistics_after.html"
+@@ -1,6 +1,6 @@
+-{% if U_SEARCH_USER_TOPICS %}
++{% if TOPICS %}
+ 	<dt>{{ lang('SUT_TOTAL_TOPICS') }}{{ lang('COLON') }}</dt>
+-	<dd>{{ TOPICS }} | <strong><a href="{{ U_SEARCH_USER_TOPICS }}">{{ lang('SEARCH_USER_TOPICS') }}</a></strong>
++	<dd>{{ TOPICS }} {% if U_SEARCH_TOPICS %}| <strong><a href="{{ U_SEARCH_TOPICS }}">{{ lang('SEARCH_USER_TOPICS') }}</a></strong>{% endif %}
+ 		{% if TOPICS_PERCENT %}<br>({{ TOPICS_PERCENT }} / {{ TOPICS_PER_DAY }}){% endif %}
+ 	</dd>
+ {% endif %}
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\searchusertopics/styles/prosilver/template/event/navbar_header_quick_links_before.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\searchusertopics/styles/prosilver/template/event/navbar_header_quick_links_before.html"
+deleted file mode 100644
+index 94ae88611..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\searchusertopics/styles/prosilver/template/event/navbar_header_quick_links_before.html"
++++ /dev/null
+@@ -1,7 +0,0 @@
+-						<!-- IF S_REGISTERED_USER -->
+-							<li>
+-								<a href="{U_SEARCH_TOPICS}" role="menuitem">
+-									<i class="icon fa-file-o fa-fw icon-gray" aria-hidden="true"></i><span>{L_SEARCH_TOPICS}</span>
+-								</a>
+-							</li>
+-						<!-- ENDIF -->
+\ No newline at end of file
diff --git "[FORUM_EXT]/rmcgirr83\\searchusertopics/diff_nospace.tmp" "[FORUM_EXT]/rmcgirr83\\searchusertopics/diff_nospace.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/rmcgirr83\\searchusertopics/diff_nospace.tmp"
@@ -0,0 +1,339 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\searchusertopics/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\searchusertopics/composer.json"
+index f64f37603..f45beab57 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\searchusertopics/composer.json"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\searchusertopics/composer.json"
+@@ -2,8 +2,8 @@
+     "name": "rmcgirr83/searchusertopics",
+     "type": "phpbb-extension",
+     "description": "This Extension displays number of topics started by a user when visiting that users profile",
+-    "version": "1.0.7",
+-    "time": "2025-01-25",
++    "version": "1.0.5",
++    "time": "2020-09-12",
+     "keywords": [
+         "phpbb",
+         "extension",
+@@ -19,8 +19,8 @@
+         }
+     ],
+     "require": {
+-        "php": ">=7.4",
+-        "phpbb/phpbb": ">=3.3",
++        "php": ">=7.1",
++        "phpbb/phpbb": ">=3.2",
+         "composer/installers": "~1.0.0"
+     },
+     "require-dev": {
+@@ -29,7 +29,7 @@
+     "extra": {
+         "display-name": "Search user topics",
+         "soft-require": {
+-            "phpbb/phpbb": ">=3.3"
++            "phpbb/phpbb": ">=3.2"
+         },
+         "version-check": {
+             "host": "www.phpbb.com",
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\searchusertopics/config/services.yml" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\searchusertopics/config/services.yml"
+index 6aafa5510..61043ec2b 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\searchusertopics/config/services.yml"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\searchusertopics/config/services.yml"
+@@ -7,7 +7,6 @@ services:
+             - '@dbal.conn'
+             - '@language'
+             - '@template'
+-            - '@user'
+             - '%core.root_path%'
+             - '%core.php_ext%'
+         tags:
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\searchusertopics/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\searchusertopics/diff_full.tmp"
+new file mode 100644
+index 000000000..3f9118a6d
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\searchusertopics/diff_full.tmp"
+@@ -0,0 +1,313 @@
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\searchusertopics/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\searchusertopics/composer.json"
++index f64f37603..f45beab57 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\searchusertopics/composer.json"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\searchusertopics/composer.json"
++@@ -2,8 +2,8 @@
++     "name": "rmcgirr83/searchusertopics",
++     "type": "phpbb-extension",
++     "description": "This Extension displays number of topics started by a user when visiting that users profile",
++-    "version": "1.0.7",
++-    "time": "2025-01-25",
+++    "version": "1.0.5",
+++    "time": "2020-09-12",
++     "keywords": [
++         "phpbb",
++         "extension",
++@@ -19,8 +19,8 @@
++         }
++     ],
++     "require": {
++-        "php": ">=7.4",
++-        "phpbb/phpbb": ">=3.3",
+++        "php": ">=7.1",
+++        "phpbb/phpbb": ">=3.2",
++         "composer/installers": "~1.0.0"
++     },
++     "require-dev": {
++@@ -29,7 +29,7 @@
++     "extra": {
++         "display-name": "Search user topics",
++         "soft-require": {
++-            "phpbb/phpbb": ">=3.3"
+++            "phpbb/phpbb": ">=3.2"
++         },
++         "version-check": {
++             "host": "www.phpbb.com",
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\searchusertopics/config/services.yml" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\searchusertopics/config/services.yml"
++index 6aafa5510..61043ec2b 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\searchusertopics/config/services.yml"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\searchusertopics/config/services.yml"
++@@ -7,7 +7,6 @@ services:
++             - '@dbal.conn'
++             - '@language'
++             - '@template'
++-            - '@user'
++             - '%core.root_path%'
++             - '%core.php_ext%'
++         tags:
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\searchusertopics/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\searchusertopics/diff_full.tmp"
++new file mode 100644
++index 000000000..e69de29bb
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\searchusertopics/event/listener.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\searchusertopics/event/listener.php"
++index 1149c72b3..93cbe0c6e 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\searchusertopics/event/listener.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\searchusertopics/event/listener.php"
++@@ -18,7 +18,6 @@ use phpbb\config\config;
++ use phpbb\db\driver\driver_interface;
++ use phpbb\language\language;
++ use phpbb\template\template;
++-use phpbb\user;
++ 
++ use Symfony\Component\EventDispatcher\EventSubscriberInterface;
++ 
++@@ -27,24 +26,21 @@ use Symfony\Component\EventDispatcher\EventSubscriberInterface;
++ */
++ class listener implements EventSubscriberInterface
++ {
++-	/** @var auth */
+++	/** @var \phpbb\auth\auth */
++ 	protected $auth;
++ 
++-	/** @var config */
+++	/** @var \phpbb\config\config */
++ 	protected $config;
++ 
++-	/** @var driver_interface */
+++	/** @var \phpbb\db\driver\driver_interface */
++ 	protected $db;
++ 
++-	/** @var language */
+++	/** @var \phpbb\language\language */
++ 	protected $language;
++ 
++-	/** @var template */
+++	/** @var \phpbb\template\template */
++ 	protected $template;
++ 
++-	/** @var user */
++-	protected $user;
++-
++ 	/** @var string phpBB root path */
++ 	protected $root_path;
++ 
++@@ -57,7 +53,6 @@ class listener implements EventSubscriberInterface
++ 		driver_interface $db,
++ 		language $language,
++ 		template $template,
++-		user $user,
++ 		$root_path,
++ 		$php_ext)
++ 	{
++@@ -66,7 +61,6 @@ class listener implements EventSubscriberInterface
++ 		$this->db = $db;
++ 		$this->language = $language;
++ 		$this->template = $template;
++-		$this->user = $user;
++ 		$this->root_path = $root_path;
++ 		$this->php_ext = $php_ext;
++ 	}
++@@ -83,24 +77,12 @@ class listener implements EventSubscriberInterface
++ 		return array(
++ 			'core.acp_extensions_run_action_after'	=>	'acp_extensions_run_action_after',
++ 			'core.memberlist_view_profile'				=> 'memberlist_view_profile',
++-			'core.page_header_after'	=> 'page_header_after',
++ 		);
++ 	}
++ 
++-	/**
++-	* Display topics search for the user in quick links
++-	*
++-	* @param object $event The event object
++-	* @return null
++-	* @access public
++-	*/
++-	public function page_header_after($event)
+++	public function load_language($event)
++ 	{
++ 		$this->language->add_lang('common', 'rmcgirr83/searchusertopics');
++-		$user_id = $this->user->data['user_id'];
++-		$this->template->assign_vars(array(
++-			'U_SEARCH_TOPICS'	=> ($this->auth->acl_get('u_search')) ? append_sid("{$this->root_path}search.$this->php_ext", "author_id=$user_id&amp;sr=topics&amp;sf=firstpost") : '',
++-		));
++ 	}
++ 
++ 	/* Display additional metdate in extension details
++@@ -168,7 +150,7 @@ class listener implements EventSubscriberInterface
++ 				'L_TOTAL_TOPICS'	=> $this->language->lang('TOTAL_TOPICS', $topics_num),
++ 				'TOPICS_PER_DAY'	=> $this->language->lang('TOPICS_PER_DAY', $topics_per_day),
++ 				'TOPICS_PERCENT'	=> $this->language->lang('TOPICS_PERCENT', $topics_percent),
++-				'U_SEARCH_USER_TOPICS'	=> ($this->auth->acl_get('u_search')) ? append_sid("{$this->root_path}search.$this->php_ext", "author_id=$user_id&amp;sr=topics&amp;sf=firstpost") : '',
+++				'U_SEARCH_TOPICS'	=> ($this->auth->acl_get('u_search')) ? append_sid("{$this->root_path}search.$this->php_ext", "author_id=$user_id&amp;sr=topics&amp;sf=firstpost") : '',
++ 			));
++ 		}
++ 	}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\searchusertopics/language/en/common.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\searchusertopics/language/en/common.php"
++index ac2bdd52a..9092ee5e4 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\searchusertopics/language/en/common.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\searchusertopics/language/en/common.php"
++@@ -36,7 +36,6 @@ $lang = array_merge($lang, [
++ 	'TOPICS_PER_DAY'		=> '%.2f topics per day',
++ 	'TOPICS_PERCENT'		=> '%.2f%% of all topics',
++ 	'SUT_TOTAL_TOPICS'		=> 'Total topics',
++-	'SEARCH_TOPICS'			=> 'Your topics',
++ 	//Donation
++ 	'PAYPAL_IMAGE_URL'          => 'https://www.paypalobjects.com/webstatic/en_US/i/btn/png/silver-pill-paypal-26px.png',
++ 	'PAYPAL_ALT'                => 'Donate using PayPal',
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\searchusertopics/language/pt/common.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\searchusertopics/language/pt/common.php"
++new file mode 100644
++index 000000000..acef54e9a
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\searchusertopics/language/pt/common.php"
++@@ -0,0 +1,46 @@
+++<?php
+++/**
+++*
+++* @package - Search User Topics
+++* @copyright (c) 2015 RMcGirr83
+++* @license http://opensource.org/licenses/gpl-license.php GNU Public License
+++*
+++*/
+++
+++if (!defined('IN_PHPBB'))
+++{
+++	exit;
+++}
+++
+++if (empty($lang) || !is_array($lang))
+++{
+++	$lang = [];
+++}
+++
+++// DEVELOPERS PLEASE NOTE
+++//
+++// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
+++//
+++// Placeholders can now contain order information, e.g. instead of
+++// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
+++// translators to re-order the output of data while ensuring it remains correct
+++//
+++// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
+++// equally where a string contains only two placeholders which are used to wrap text
+++// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
+++// Some characters you may want to copy&paste:
+++// ’ » “ ” …
+++
+++$lang = array_merge($lang, [
+++	'SEARCH_USER_TOPICS'	=> 'Pesquisar tópicos do utilizador',
+++	'TOPICS_PER_DAY'		=> '%.2f tópicos por dia',
+++	'TOPICS_PERCENT'		=> '%.2f%% de todos os tópicos',
+++	'SUT_TOTAL_TOPICS'		=> 'Total de tópicos',
+++	//Donation
+++	'PAYPAL_IMAGE_URL'          => 'https://www.paypalobjects.com/webstatic/en_US/i/btn/png/silver-pill-paypal-26px.png',
+++	'PAYPAL_ALT'                => 'Donate using PayPal',
+++	'BUY_ME_A_BEER_URL'         => 'https://paypal.me/RMcGirr83',
+++	'BUY_ME_A_BEER'				=> 'Buy me a beer for creating this extension',
+++	'BUY_ME_A_BEER_SHORT'		=> 'Make a donation for this extension',
+++	'BUY_ME_A_BEER_EXPLAIN'		=> 'This extension is completely free. It is a project that I spend my time on for the enjoyment and use of the phpBB community. If you enjoy using this extension, or if it has benefited your forum, please consider <a href="https://paypal.me/RMcGirr83" target="_blank" rel="noreferrer noopener">buying me a beer</a>. It would be greatly appreciated. <i class="fa fa-smile-o" style="color:green;font-size:1.5em;" aria-hidden="true"></i>',
+++]);
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\searchusertopics/language/pt_preao/common.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\searchusertopics/language/pt_preao/common.php"
++new file mode 100644
++index 000000000..5593b621f
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\searchusertopics/language/pt_preao/common.php"
++@@ -0,0 +1,47 @@
+++<?php
+++/**
+++*
+++* @package - Search User Topics
+++* @copyright (c) 2015 RMcGirr83
+++* @license http://opensource.org/licenses/gpl-license.php GNU Public License
+++*
+++*/
+++
+++if (!defined('IN_PHPBB'))
+++{
+++	exit;
+++}
+++
+++if (empty($lang) || !is_array($lang))
+++{
+++	$lang = [];
+++}
+++
+++// DEVELOPERS PLEASE NOTE
+++//
+++// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
+++//
+++// Placeholders can now contain order information, e.g. instead of
+++// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
+++// translators to re-order the output of data while ensuring it remains correct
+++//
+++// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
+++// equally where a string contains only two placeholders which are used to wrap text
+++// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
+++// Some characters you may want to copy&paste:
+++// ’ » “ ” …
+++
+++$lang = array_merge($lang, [
+++	'SEARCH_USER_TOPICS'	=> 'Pesquisar tópicos do utilizador',
+++	'TOPICS_PER_DAY'		=> '%.2f tópicos por dia',
+++	'TOPICS_PERCENT'		=> '%.2f%% de todos os tópicos',
+++	'SUT_TOTAL_TOPICS'		=> 'Total de tópicos',
+++	'MY_TOPICS'			=> 'Os Meus Tópicos',
+++	//Donation
+++	'PAYPAL_IMAGE_URL'          => 'https://www.paypalobjects.com/webstatic/en_US/i/btn/png/silver-pill-paypal-26px.png',
+++	'PAYPAL_ALT'                => 'Donate using PayPal',
+++	'BUY_ME_A_BEER_URL'         => 'https://paypal.me/RMcGirr83',
+++	'BUY_ME_A_BEER'				=> 'Buy me a beer for creating this extension',
+++	'BUY_ME_A_BEER_SHORT'		=> 'Make a donation for this extension',
+++	'BUY_ME_A_BEER_EXPLAIN'		=> 'This extension is completely free. It is a project that I spend my time on for the enjoyment and use of the phpBB community. If you enjoy using this extension, or if it has benefited your forum, please consider <a href="https://paypal.me/RMcGirr83" target="_blank" rel="noreferrer noopener">buying me a beer</a>. It would be greatly appreciated. <i class="fa fa-smile-o" style="color:green;font-size:1.5em;" aria-hidden="true"></i>',
+++]);
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\searchusertopics/styles/FLATBOOTS/template/event/ss_memberlist_view_timeline_item_middle.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\searchusertopics/styles/FLATBOOTS/template/event/ss_memberlist_view_timeline_item_middle.html"
++new file mode 100644
++index 000000000..d395c97e3
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\searchusertopics/styles/FLATBOOTS/template/event/ss_memberlist_view_timeline_item_middle.html"
++@@ -0,0 +1,18 @@
+++<!-- IF TOPICS -->
+++	<div class="tl-item">
+++		<div class="tl-body">
+++			<div class="tl-entry">
+++				<div class="tl-time"></div>
+++				<div class="tl-icon square-icon sm bg-success"><i class="fa fa-file-text"></i></div>
+++				<div class="tl-content">
+++					<h4 class="tl-tile text-warning">{L_SUT_TOTAL_TOPICS}</h4>
+++					<p>
+++					{TOPICS}&nbsp;
+++					<!-- IF U_SEARCH_TOPICS -->&#45;<strong><a href="{U_SEARCH_TOPICS}">&nbsp;{L_SEARCH_USER_TOPICS}</a></strong><!-- ENDIF -->
+++					<!-- IF TOPICS_PERCENT -->&#40;{TOPICS_PERCENT}&nbsp;&#47;&nbsp;{TOPICS_PER_DAY}&#41;<!-- ENDIF -->
+++					</p>
+++				</div>
+++			</div>
+++		</div>
+++	</div>
+++<!-- ENDIF -->
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\searchusertopics/styles/prosilver/template/event/memberlist_view_user_statistics_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\searchusertopics/style
\ No newline at end of file
diff --git "[ORIGINAL]/rmcgirr83\\searchusertopics/event/listener.php" "[FORUM_EXT]/rmcgirr83\\searchusertopics/event/listener.php"
--- "[ORIGINAL]/rmcgirr83\\searchusertopics/event/listener.php"
+++ "[FORUM_EXT]/rmcgirr83\\searchusertopics/event/listener.php"
@@ -18,7 +18,6 @@ use phpbb\config\config;
 use phpbb\db\driver\driver_interface;
 use phpbb\language\language;
 use phpbb\template\template;
-use phpbb\user;
 
 use Symfony\Component\EventDispatcher\EventSubscriberInterface;
 
@@ -27,24 +26,21 @@ use Symfony\Component\EventDispatcher\EventSubscriberInterface;
 */
 class listener implements EventSubscriberInterface
 {
-	/** @var auth */
+	/** @var \phpbb\auth\auth */
 	protected $auth;
 
-	/** @var config */
+	/** @var \phpbb\config\config */
 	protected $config;
 
-	/** @var driver_interface */
+	/** @var \phpbb\db\driver\driver_interface */
 	protected $db;
 
-	/** @var language */
+	/** @var \phpbb\language\language */
 	protected $language;
 
-	/** @var template */
+	/** @var \phpbb\template\template */
 	protected $template;
 
-	/** @var user */
-	protected $user;
-
 	/** @var string phpBB root path */
 	protected $root_path;
 
@@ -57,7 +53,6 @@ class listener implements EventSubscriberInterface
 		driver_interface $db,
 		language $language,
 		template $template,
-		user $user,
 		$root_path,
 		$php_ext)
 	{
@@ -66,7 +61,6 @@ class listener implements EventSubscriberInterface
 		$this->db = $db;
 		$this->language = $language;
 		$this->template = $template;
-		$this->user = $user;
 		$this->root_path = $root_path;
 		$this->php_ext = $php_ext;
 	}
@@ -83,24 +77,12 @@ class listener implements EventSubscriberInterface
 		return array(
 			'core.acp_extensions_run_action_after'	=>	'acp_extensions_run_action_after',
 			'core.memberlist_view_profile'				=> 'memberlist_view_profile',
-			'core.page_header_after'	=> 'page_header_after',
 		);
 	}
 
-	/**
-	* Display topics search for the user in quick links
-	*
-	* @param object $event The event object
-	* @return null
-	* @access public
-	*/
-	public function page_header_after($event)
+	public function load_language($event)
 	{
 		$this->language->add_lang('common', 'rmcgirr83/searchusertopics');
-		$user_id = $this->user->data['user_id'];
-		$this->template->assign_vars(array(
-			'U_SEARCH_TOPICS'	=> ($this->auth->acl_get('u_search')) ? append_sid("{$this->root_path}search.$this->php_ext", "author_id=$user_id&amp;sr=topics&amp;sf=firstpost") : '',
-		));
 	}
 
 	/* Display additional metdate in extension details
@@ -168,7 +150,7 @@ class listener implements EventSubscriberInterface
 				'L_TOTAL_TOPICS'	=> $this->language->lang('TOTAL_TOPICS', $topics_num),
 				'TOPICS_PER_DAY'	=> $this->language->lang('TOPICS_PER_DAY', $topics_per_day),
 				'TOPICS_PERCENT'	=> $this->language->lang('TOPICS_PERCENT', $topics_percent),
-				'U_SEARCH_USER_TOPICS'	=> ($this->auth->acl_get('u_search')) ? append_sid("{$this->root_path}search.$this->php_ext", "author_id=$user_id&amp;sr=topics&amp;sf=firstpost") : '',
+				'U_SEARCH_TOPICS'	=> ($this->auth->acl_get('u_search')) ? append_sid("{$this->root_path}search.$this->php_ext", "author_id=$user_id&amp;sr=topics&amp;sf=firstpost") : '',
 			));
 		}
 	}
diff --git "[ORIGINAL]/rmcgirr83\\searchusertopics/language/en/common.php" "[FORUM_EXT]/rmcgirr83\\searchusertopics/language/en/common.php"
--- "[ORIGINAL]/rmcgirr83\\searchusertopics/language/en/common.php"
+++ "[FORUM_EXT]/rmcgirr83\\searchusertopics/language/en/common.php"
@@ -36,7 +36,6 @@ $lang = array_merge($lang, [
 	'TOPICS_PER_DAY'		=> '%.2f topics per day',
 	'TOPICS_PERCENT'		=> '%.2f%% of all topics',
 	'SUT_TOTAL_TOPICS'		=> 'Total topics',
-	'SEARCH_TOPICS'			=> 'Your topics',
 	//Donation
 	'PAYPAL_IMAGE_URL'          => 'https://www.paypalobjects.com/webstatic/en_US/i/btn/png/silver-pill-paypal-26px.png',
 	'PAYPAL_ALT'                => 'Donate using PayPal',
diff --git "[FORUM_EXT]/rmcgirr83\\searchusertopics/language/pt/common.php" "[FORUM_EXT]/rmcgirr83\\searchusertopics/language/pt/common.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/rmcgirr83\\searchusertopics/language/pt/common.php"
@@ -0,0 +1,46 @@
+<?php
+/**
+*
+* @package - Search User Topics
+* @copyright (c) 2015 RMcGirr83
+* @license http://opensource.org/licenses/gpl-license.php GNU Public License
+*
+*/
+
+if (!defined('IN_PHPBB'))
+{
+	exit;
+}
+
+if (empty($lang) || !is_array($lang))
+{
+	$lang = [];
+}
+
+// DEVELOPERS PLEASE NOTE
+//
+// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
+//
+// Placeholders can now contain order information, e.g. instead of
+// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
+// translators to re-order the output of data while ensuring it remains correct
+//
+// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
+// equally where a string contains only two placeholders which are used to wrap text
+// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
+// Some characters you may want to copy&paste:
+// ’ » “ ” …
+
+$lang = array_merge($lang, [
+	'SEARCH_USER_TOPICS'	=> 'Pesquisar tópicos do utilizador',
+	'TOPICS_PER_DAY'		=> '%.2f tópicos por dia',
+	'TOPICS_PERCENT'		=> '%.2f%% de todos os tópicos',
+	'SUT_TOTAL_TOPICS'		=> 'Total de tópicos',
+	//Donation
+	'PAYPAL_IMAGE_URL'          => 'https://www.paypalobjects.com/webstatic/en_US/i/btn/png/silver-pill-paypal-26px.png',
+	'PAYPAL_ALT'                => 'Donate using PayPal',
+	'BUY_ME_A_BEER_URL'         => 'https://paypal.me/RMcGirr83',
+	'BUY_ME_A_BEER'				=> 'Buy me a beer for creating this extension',
+	'BUY_ME_A_BEER_SHORT'		=> 'Make a donation for this extension',
+	'BUY_ME_A_BEER_EXPLAIN'		=> 'This extension is completely free. It is a project that I spend my time on for the enjoyment and use of the phpBB community. If you enjoy using this extension, or if it has benefited your forum, please consider <a href="https://paypal.me/RMcGirr83" target="_blank" rel="noreferrer noopener">buying me a beer</a>. It would be greatly appreciated. <i class="fa fa-smile-o" style="color:green;font-size:1.5em;" aria-hidden="true"></i>',
+]);
diff --git "[FORUM_EXT]/rmcgirr83\\searchusertopics/language/pt_preao/common.php" "[FORUM_EXT]/rmcgirr83\\searchusertopics/language/pt_preao/common.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/rmcgirr83\\searchusertopics/language/pt_preao/common.php"
@@ -0,0 +1,47 @@
+<?php
+/**
+*
+* @package - Search User Topics
+* @copyright (c) 2015 RMcGirr83
+* @license http://opensource.org/licenses/gpl-license.php GNU Public License
+*
+*/
+
+if (!defined('IN_PHPBB'))
+{
+	exit;
+}
+
+if (empty($lang) || !is_array($lang))
+{
+	$lang = [];
+}
+
+// DEVELOPERS PLEASE NOTE
+//
+// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
+//
+// Placeholders can now contain order information, e.g. instead of
+// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
+// translators to re-order the output of data while ensuring it remains correct
+//
+// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
+// equally where a string contains only two placeholders which are used to wrap text
+// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
+// Some characters you may want to copy&paste:
+// ’ » “ ” …
+
+$lang = array_merge($lang, [
+	'SEARCH_USER_TOPICS'	=> 'Pesquisar tópicos do utilizador',
+	'TOPICS_PER_DAY'		=> '%.2f tópicos por dia',
+	'TOPICS_PERCENT'		=> '%.2f%% de todos os tópicos',
+	'SUT_TOTAL_TOPICS'		=> 'Total de tópicos',
+	'MY_TOPICS'			=> 'Os Meus Tópicos',
+	//Donation
+	'PAYPAL_IMAGE_URL'          => 'https://www.paypalobjects.com/webstatic/en_US/i/btn/png/silver-pill-paypal-26px.png',
+	'PAYPAL_ALT'                => 'Donate using PayPal',
+	'BUY_ME_A_BEER_URL'         => 'https://paypal.me/RMcGirr83',
+	'BUY_ME_A_BEER'				=> 'Buy me a beer for creating this extension',
+	'BUY_ME_A_BEER_SHORT'		=> 'Make a donation for this extension',
+	'BUY_ME_A_BEER_EXPLAIN'		=> 'This extension is completely free. It is a project that I spend my time on for the enjoyment and use of the phpBB community. If you enjoy using this extension, or if it has benefited your forum, please consider <a href="https://paypal.me/RMcGirr83" target="_blank" rel="noreferrer noopener">buying me a beer</a>. It would be greatly appreciated. <i class="fa fa-smile-o" style="color:green;font-size:1.5em;" aria-hidden="true"></i>',
+]);
diff --git "[FORUM_EXT]/rmcgirr83\\searchusertopics/styles/FLATBOOTS/template/event/ss_memberlist_view_timeline_item_middle.html" "[FORUM_EXT]/rmcgirr83\\searchusertopics/styles/FLATBOOTS/template/event/ss_memberlist_view_timeline_item_middle.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/rmcgirr83\\searchusertopics/styles/FLATBOOTS/template/event/ss_memberlist_view_timeline_item_middle.html"
@@ -0,0 +1,18 @@
+<!-- IF TOPICS -->
+	<div class="tl-item">
+		<div class="tl-body">
+			<div class="tl-entry">
+				<div class="tl-time"></div>
+				<div class="tl-icon square-icon sm bg-success"><i class="fa fa-file-text"></i></div>
+				<div class="tl-content">
+					<h4 class="tl-tile text-warning">{L_SUT_TOTAL_TOPICS}</h4>
+					<p>
+					{TOPICS}&nbsp;
+					<!-- IF U_SEARCH_TOPICS -->&#45;<strong><a href="{U_SEARCH_TOPICS}">&nbsp;{L_SEARCH_USER_TOPICS}</a></strong><!-- ENDIF -->
+					<!-- IF TOPICS_PERCENT -->&#40;{TOPICS_PERCENT}&nbsp;&#47;&nbsp;{TOPICS_PER_DAY}&#41;<!-- ENDIF -->
+					</p>
+				</div>
+			</div>
+		</div>
+	</div>
+<!-- ENDIF -->
\ No newline at end of file
diff --git "[ORIGINAL]/rmcgirr83\\searchusertopics/styles/prosilver/template/event/memberlist_view_user_statistics_after.html" "[FORUM_EXT]/rmcgirr83\\searchusertopics/styles/prosilver/template/event/memberlist_view_user_statistics_after.html"
--- "[ORIGINAL]/rmcgirr83\\searchusertopics/styles/prosilver/template/event/memberlist_view_user_statistics_after.html"
+++ "[FORUM_EXT]/rmcgirr83\\searchusertopics/styles/prosilver/template/event/memberlist_view_user_statistics_after.html"
@@ -1,6 +1,6 @@
-{% if U_SEARCH_USER_TOPICS %}
+{% if TOPICS %}
 	<dt>{{ lang('SUT_TOTAL_TOPICS') }}{{ lang('COLON') }}</dt>
-	<dd>{{ TOPICS }} | <strong><a href="{{ U_SEARCH_USER_TOPICS }}">{{ lang('SEARCH_USER_TOPICS') }}</a></strong>
+	<dd>{{ TOPICS }} {% if U_SEARCH_TOPICS %}| <strong><a href="{{ U_SEARCH_TOPICS }}">{{ lang('SEARCH_USER_TOPICS') }}</a></strong>{% endif %}
 		{% if TOPICS_PERCENT %}<br>({{ TOPICS_PERCENT }} / {{ TOPICS_PER_DAY }}){% endif %}
 	</dd>
 {% endif %}
\ No newline at end of file
diff --git "[ORIGINAL]/rmcgirr83\\searchusertopics/styles/prosilver/template/event/navbar_header_quick_links_before.html" "[ORIGINAL]/rmcgirr83\\searchusertopics/styles/prosilver/template/event/navbar_header_quick_links_before.html"
deleted file mode 100644
--- "[ORIGINAL]/rmcgirr83\\searchusertopics/styles/prosilver/template/event/navbar_header_quick_links_before.html"
+++ /dev/null
@@ -1,7 +0,0 @@
-						<!-- IF S_REGISTERED_USER -->
-							<li>
-								<a href="{U_SEARCH_TOPICS}" role="menuitem">
-									<i class="icon fa-file-o fa-fw icon-gray" aria-hidden="true"></i><span>{L_SEARCH_TOPICS}</span>
-								</a>
-							</li>
-						<!-- ENDIF -->
\ No newline at end of file
```
