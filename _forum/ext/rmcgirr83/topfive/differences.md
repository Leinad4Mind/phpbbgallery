Existem diferencas reais no codigo ou texto. Diferencas de formatacao (espacos, tabs) foram ignoradas abaixo.

```diff
diff --git "[ORIGINAL]/rmcgirr83\\topfive/acp/topfive_info.php" "[FORUM_EXT]/rmcgirr83\\topfive/acp/topfive_info.php"
--- "[ORIGINAL]/rmcgirr83\\topfive/acp/topfive_info.php"
+++ "[FORUM_EXT]/rmcgirr83\\topfive/acp/topfive_info.php"
@@ -19,9 +19,9 @@ class topfive_info
 		return array(
 			'filename'	=> '\rmcgirr83\topfive\acp\topfive_module',
 			'title'		=> 'TF_ACP',
-			'version'	=> '1.2.3',
+			'version'	=> '1.0.0',
 			'modes'		=> array(
-				'settings'	=> array('title' => 'TF_CONFIG', 'auth'	=> 'ext_rmcgirr83/topfive && acl_a_extensions' , 'cat'	=> array('TOPFIVE_MOD')),
+				'settings'	=> array('title' => 'TF_CONFIG', 'auth'	=> 'ext_rmcgirr83/topfive', 'cat'	=> array('TOPFIVE_MOD')),
 			),
 		);
 	}
diff --git "[ORIGINAL]/rmcgirr83\\topfive/acp/topfive_module.php" "[FORUM_EXT]/rmcgirr83\\topfive/acp/topfive_module.php"
--- "[ORIGINAL]/rmcgirr83\\topfive/acp/topfive_module.php"
+++ "[FORUM_EXT]/rmcgirr83\\topfive/acp/topfive_module.php"
@@ -11,21 +11,67 @@ namespace rmcgirr83\topfive\acp;
 
 class topfive_module
 {
-	public $u_action;
+	var $u_action;
 
 	function main($id, $mode)
 	{
-		global $phpbb_container;
+		global $db, $user, $auth, $template, $cache, $request;
+		global $config, $phpbb_root_path, $phpbb_admin_path, $phpEx;
 
+		$this->config = $config;
+		$this->request = $request;
+
+		$user->add_lang('acp/common');
+		$user->add_lang_ext('rmcgirr83/topfive', 'acp/info_acp_topfive');
 		$this->tpl_name = 'acp_topfive';
-		$this->page_title = $phpbb_container->get('language')->lang('TF_ACP');
+		$this->page_title = $user->lang['TOPFIVE_MOD'];
+		add_form_key('acp_topfive');
+
+		if ($request->is_set_post('submit'))
+		{
+			if (!check_form_key('acp_topfive'))
+			{
+				trigger_error('FORM_INVALID');
+			}
+			if (!function_exists('validate_data'))
+			{
+				include($phpbb_root_path . 'includes/functions_user.' . $phpEx);
+			}
 
-		// Get an instance of the admin controller
-		$admin_controller = $phpbb_container->get('rmcgirr83.topfive.admin.controller');
+			$check_row = array('top_five_how_many' => $request->variable('top_five_how_many', 0));
+			$validate_row = array('top_five_how_many' => array('num', false, 5, 100));
+			$error = validate_data($check_row, $validate_row);
+
+			// Replace "error" strings with their real, localised form
+			$error = array_map(array($user, 'lang'), $error);
+
+			if (!sizeof($error))
+			{
+				$config->set('top_five_how_many', $request->variable('top_five_how_many', 0));
+				$config->set('top_five_ignore_inactive_users', $request->variable('top_five_ignore_inactive_users', true));
+				$config->set('top_five_ignore_founder', $request->variable('top_five_ignore_founder', true));
+				$config->set('top_five_show_admins_mods', $request->variable('top_five_show_admins_mods', true));
+				$config->set('top_five_location', $request->variable('top_five_location', true));
+				$config->set('top_five_active', $request->variable('top_five_active', true));
+
+				$cache->destroy('_top_five_newest_users');
+				$cache->destroy('_top_five_posters');
+
+				trigger_error($user->lang['TF_SAVED'] . adm_back_link($this->u_action));
+			}
+		}
 
-		// Make the $u_action url available in the admin controller
-		$admin_controller->set_page_url($this->u_action);
+		$template->assign_vars(array(
+			'TF_ERROR'			=> isset($error) ? ((sizeof($error)) ? implode('<br />', $error) : '') : '',
+			'HOWMANY'			=> (!empty($this->config['top_five_how_many'])) ? $this->config['top_five_how_many'] : 0,
+			'IGNORE_INACTIVE'	=> (!empty($this->config['top_five_ignore_inactive_users'])) ? true : false,
+			'IGNORE_FOUNDER'	=> (!empty($this->config['top_five_ignore_founder'])) ? true : false,
+			'SHOW_ADMINS_MODS'	=> (!empty($this->config['top_five_show_admins_mods'])) ? true : false,
+			'LOCATION'			=> (!empty($this->config['top_five_location'])) ? true : false,
+			'ACTIVE'			=> (!empty($this->config['top_five_active'])) ? true : false,
+			'TF_VERSION'		=> $this->config['top_five_version'],
 
-		$admin_controller->display_options();
+			'U_ACTION'			=> $this->u_action,
+		));
 	}
 }
diff --git "[ORIGINAL]/rmcgirr83\\topfive/adm/style/acp_topfive.html" "[FORUM_EXT]/rmcgirr83\\topfive/adm/style/acp_topfive.html"
--- "[ORIGINAL]/rmcgirr83\\topfive/adm/style/acp_topfive.html"
+++ "[FORUM_EXT]/rmcgirr83\\topfive/adm/style/acp_topfive.html"
@@ -1,60 +1,51 @@
-{% INCLUDE 'overall_header.html' %}
+<!-- INCLUDE overall_header.html -->
 
-<h1>{{ lang('TF_TITLE') }}</h1>
-<fieldset>
-	<legend>{{ lang('BUY_ME_A_BEER') }}</legend>
-	<dl>
-		<dt><label>{{ lang('BUY_ME_A_BEER_SHORT') }}{{ lang('COLON') }}</label><br /><span>{{ lang('BUY_ME_A_BEER_EXPLAIN') }}</span></dt>
-		<dd><a href="{{ lang('BUY_ME_A_BEER_URL') }}" target="_blank" rel="noreferrer noopener"><img src="{{ lang('PAYPAL_IMAGE_URL') }}" border="0" alt="{{ lang('PAYPAL_ALT') }}" style="cursor:pointer;margin-top:15px;"></a></dd>
-	</dl>
-</fieldset>
-{% if TF_ERROR %}
-	<div class="errorbox"><h3>{{ lang('WARNING') }}</h3>
-		<p>{{ TF_ERROR }}</p>
+<h1>{L_TF_TITLE}</h1>
+<p>{L_TF_VERSION} {TF_VERSION}</p>
+
+<!-- IF TF_ERROR -->
+	<div class="errorbox"><h3>{L_WARNING}</h3>
+		<p>{TF_ERROR}</p>
 	</div>
-{% endif %}
+<!-- ENDIF -->
 
-<form id="acp_topfive" method="post" action="{{ U_ACTION }}">
+<form id="acp_topfive" method="post" action="{U_ACTION}">
 	<fieldset>
-		<legend>{{ lang('TF_CONFIG') }}</legend>
-		<dl>
-			<dt><label>{{ lang('TF_LOCATION') ~ lang('COLON') }}</label><br>
-			<span>{{ lang('TF_LOCATION_EXPLAIN') }}</span></dt>
-			<dd><select name="top_five_location">{{ LOCATION }}</select></dd>
-		</dl>
+		<legend>{L_TF_CONFIG}</legend>
 		<dl>
-			<dt><label>{{ lang('TF_AVATARS') }}</label><br />{{ lang('TF_AVATARS_EXPLAIN') }}</dt>
-			<dd><input type="radio" class="radio" name="top_five_avatars" value="1" {% if AVATARS %}checked="checked"{% endif %}/> {{ lang('YES') }} &nbsp;
-				<input type="radio" class="radio" name="top_five_avatars" value="0" {% if not AVATARS %}checked="checked"{% endif %} /> {{ lang('NO') }}</dd>
+			<dt><label id="top_five_active" for="top_five_active">{L_TF_ACTIVE}</label></dt>
+			<dd><input type="radio" class="radio" name="top_five_active" value="1" <!-- IF ACTIVE -->checked="checked"<!-- ENDIF -->/> {L_YES} &nbsp;
+				<input type="radio" class="radio" name="top_five_active" value="0" <!-- IF not ACTIVE -->checked="checked"<!-- ENDIF --> /> {L_NO}</dd>
 		</dl>
 		<dl>
-			<dt><label>{{ lang('TF_HOWMANY') }}</label><br />{{ lang('TF_HOWMANY_EXPLAIN') }}</dt>
-			<dd><input type="number" name="top_five_how_many" size="10" min="5" max="100" value="{{ HOWMANY }}" /></dd>
+			<dt><label id="top_five_location" for="top_five_location">{L_TF_LOCATION}</label><br />{L_TF_LOCATION_EXPLAIN}</dt>
+			<dd><input type="radio" class="radio" name="top_five_location" value="1" <!-- IF LOCATION -->checked="checked"<!-- ENDIF -->/> {L_TOP_OF_FORUM} &nbsp;
+				<input type="radio" class="radio" name="top_five_location" value="0" <!-- IF not LOCATION -->checked="checked"<!-- ENDIF --> /> {L_BOTTOM_OF_FORUM}</dd>
 		</dl>
 		<dl>
-			<dt><label>{{ lang('TF_EXCLUDED') ~ lang('COLON') }}</label><br /><span>{{ lang('TF_EXCLUDED_EXPLAIN') }}</span></dt>
-			<dd>{{ TF_EXCLUDED }}</dd>
+			<dt><label id="top_five_how_many" for="top_five_how_many">{L_TF_HOWMANY}</label><br />{L_TF_HOWMANY_EXPLAIN}</dt>
+			<dd><input type="text" name="top_five_how_many" id="top_five_how_many" size="10" value="{HOWMANY}" /></dd>
 		</dl>
 		<dl>
-			<dt><label>{{ lang('TF_IGNORE_USERS') }}</label><br />{{ lang('TF_IGNORE_USERS_EXPLAIN') }}</dt>
-			<dd><input type="radio" class="radio" name="top_five_ignore_inactive_users" value="1" {% if IGNORE_INACTIVE %}checked="checked"{% endif %}/> {{ lang('YES') }} &nbsp;
-				<input type="radio" class="radio" name="top_five_ignore_inactive_users" value="0" {% if not IGNORE_INACTIVE %}checked="checked"{% endif %} /> {{ lang('NO') }}</dd>
+			<dt><label id="top_five_ignore_inactive_users" for="top_five_ignore_inactive_users">{L_TF_IGNORE_USERS}</label><br />{L_TF_IGNORE_USERS_EXPLAIN}</dt>
+			<dd><input type="radio" class="radio" name="top_five_ignore_inactive_users" value="1" <!-- IF IGNORE_INACTIVE -->checked="checked"<!-- ENDIF -->/> {L_YES} &nbsp;
+				<input type="radio" class="radio" name="top_five_ignore_inactive_users" value="0" <!-- IF not IGNORE_INACTIVE -->checked="checked"<!-- ENDIF --> /> {L_NO}</dd>
 		</dl>
 		<dl>
-			<dt><label>{{ lang('TF_IGNORE_FOUNDER') }}</label><br />{{ lang('TF_IGNORE_FOUNDER_EXPLAIN') }}</dt>
-			<dd><input type="radio" class="radio" name="top_five_ignore_founder" value="1" {% if IGNORE_FOUNDER %}checked="checked"{% endif %}/> {{ lang('YES') }} &nbsp;
-				<input type="radio" class="radio" name="top_five_ignore_founder" value="0" {% if not IGNORE_FOUNDER %}checked="checked"{% endif %} /> {{ lang('NO') }}</dd>
+			<dt><label id="top_five_ignore_founder" for="top_five_ignore_founder">{L_TF_IGNORE_FOUNDER}</label><br />{L_TF_IGNORE_FOUNDER_EXPLAIN}</dt>
+			<dd><input type="radio" class="radio" name="top_five_ignore_founder" value="1" <!-- IF IGNORE_FOUNDER -->checked="checked"<!-- ENDIF -->/> {L_YES} &nbsp; 
+				<input type="radio" class="radio" name="top_five_ignore_founder" value="0" <!-- IF not IGNORE_FOUNDER -->checked="checked"<!-- ENDIF --> /> {L_NO}</dd>
 		</dl>
 		<dl>
-			<dt><label>{{ lang('TF_SHOW_ADMINS_MODS') }}</label><br />{{ lang('TF_SHOW_ADMINS_MODS_EXPLAIN') }}</dt>
-			<dd><input type="radio" class="radio" name="top_five_show_admins_mods" value="1" {% if SHOW_ADMINS_MODS %}checked="checked"{% endif %}/> {{ lang('YES') }} &nbsp;
-				<input type="radio" class="radio" name="top_five_show_admins_mods" value="0" {% if not SHOW_ADMINS_MODS %}checked="checked"{% endif %} /> {{ lang('NO') }}</dd>
+			<dt><label id="top_five_show_admins_mods" for="top_five_show_admins_mods">{L_TF_SHOW_ADMINS_MODS}</label><br />{L_TF_SHOW_ADMINS_MODS_EXPLAIN}</dt>
+			<dd><input type="radio" class="radio" name="top_five_show_admins_mods" value="1" <!-- IF SHOW_ADMINS_MODS -->checked="checked"<!-- ENDIF -->/> {L_YES} &nbsp;
+				<input type="radio" class="radio" name="top_five_show_admins_mods" value="0" <!-- IF not SHOW_ADMINS_MODS -->checked="checked"<!-- ENDIF --> /> {L_NO}</dd>
 		</dl>
 		<p class="submit-buttons">
-			<input class="button1" type="submit" id="submit" name="submit" value="{{ lang('SUBMIT') }}" />&nbsp;
-			<input class="button2" type="reset" id="reset" name="reset" value="{{ lang('RESET') }}" />
-		{{ S_FORM_TOKEN }}
+			<input class="button1" type="submit" id="submit" name="submit" value="{L_SUBMIT}" />&nbsp;
+			<input class="button2" type="reset" id="reset" name="reset" value="{L_RESET}" />
+		{S_FORM_TOKEN}
 		</p>
 	</fieldset>
 </form>
-{% INCLUDE 'overall_footer.html' %}
+<!-- INCLUDE overall_footer.html -->
diff --git "[ORIGINAL]/rmcgirr83\\topfive/adm/style/event/acp_ext_details_end.html" "[ORIGINAL]/rmcgirr83\\topfive/adm/style/event/acp_ext_details_end.html"
deleted file mode 100644
--- "[ORIGINAL]/rmcgirr83\\topfive/adm/style/event/acp_ext_details_end.html"
+++ /dev/null
@@ -1,9 +0,0 @@
-{% if S_BUY_ME_A_BEER_TOPFIVE %}
-	<fieldset>
-		<legend>{{ lang('BUY_ME_A_BEER') }}</legend>
-		<dl>
-			<dt><label>{{ lang('BUY_ME_A_BEER_SHORT') }}{{ lang('COLON') }}</label><br /><span>{{ lang('BUY_ME_A_BEER_EXPLAIN') }}</span></dt>
-			<dd><a href="{{ lang('BUY_ME_A_BEER_URL') }}" target="_blank" rel="noreferrer noopener"><img src="{{ lang('PAYPAL_IMAGE_URL') }}" border="0" alt="{{ lang('PAYPAL_ALT') }}" style="cursor:pointer;margin-top:15px;"></a></dd>
-		</dl>
-	</fieldset>
-{% endif %}
\ No newline at end of file
diff --git "[ORIGINAL]/rmcgirr83\\topfive/composer.json" "[FORUM_EXT]/rmcgirr83\\topfive/composer.json"
--- "[ORIGINAL]/rmcgirr83\\topfive/composer.json"
+++ "[FORUM_EXT]/rmcgirr83\\topfive/composer.json"
@@ -1,38 +1,36 @@
 {
     "name": "rmcgirr83/topfive",
     "type": "phpbb-extension",
-    "description": "Displays statistics of the latest new posts, new users and most active users on the forum index page.",
+    "description": "Displays statistics of the latest new posts, new users and most active users on the boards index page.",
     "homepage": "https://github.com/RMcGirr83/topfive",
-    "version": "1.2.8",
-    "time": "2024-10-26",
+    "version": "1.0.2",
+    "time": "2015-05-28",
     "keywords": [
         "phpbb",
         "extension",
         "top five"
     ],
-    "license": "GPL-2.0-only",
+    "license": "GPL-2.0",
     "authors": [
         {
             "name": "Rich McGirr",
-            "homepage": "https://paypal.me/rmcgirr83",
+            "homepage": "https://www.phpbb.com/customise/db/author/rmcgirr83/contributions",
+            "email": "rmcgirr83@rmcgirr83.org",
             "role": "Lead Developer"
         }
     ],
     "require": {
-        "php": ">=7.4",
-        "phpbb/phpbb": ">=3.3",
-        "composer/installers": "~1.0.0"
+        "php": ">=5.3.3"
     },
     "extra": {
-        "display-name": "Top Five Extension",
+        "display-name": "Top Five",
         "soft-require": {
-            "phpbb/phpbb": ">=3.3"
+            "phpbb/phpbb": ">=3.1.2,<3.2.*@dev"
         },
         "version-check": {
             "host": "www.phpbb.com",
             "directory": "/customise/db/extension/topfiveext",
-            "filename": "version_check",
-            "ssl": true
+            "filename": "version_check"
         }
     }
 }
\ No newline at end of file
diff --git "[ORIGINAL]/rmcgirr83\\topfive/config/services.yml" "[FORUM_EXT]/rmcgirr83\\topfive/config/services.yml"
--- "[ORIGINAL]/rmcgirr83\\topfive/config/services.yml"
+++ "[FORUM_EXT]/rmcgirr83\\topfive/config/services.yml"
@@ -1,20 +1,5 @@
-imports:
-    - { resource: topfive_constants.yml }
-
 services:
-    rmcgirr83.topfive.admin.controller:
-        class: rmcgirr83\topfive\controller\admin_controller
-        arguments:
-            - '@cache'
-            - '@config'
-            - '@language'
-            - '@request'
-            - '@template'
-            - '%core.root_path%'
-            - '%core.php_ext%'
-            - '%topfive_constants%'
-
-    rmcgirr83.topfive.topfive:
+    rmcgirr83.topfive.functions:
         class: rmcgirr83\topfive\core\topfive
         arguments:
             - '@auth'
@@ -23,25 +8,17 @@ services:
             - '@content.visibility'
             - '@dbal.conn'
             - '@dispatcher'
-            - '@language'
             - '@template'
             - '@user'
             - '%core.root_path%'
             - '%core.php_ext%'
-            - '@?senky.relativedates.listener'
-            - '@?rmcgirr83.nationalflags.nationalflags'
 
     rmcgirr83.topfive.listener:
         class: rmcgirr83\topfive\event\listener
         arguments:
-            - '@rmcgirr83.topfive.topfive'
+            - '@rmcgirr83.topfive.functions'
             - '@config'
-            - '@language'
             - '@template'
             - '@user'
-            - '@controller.helper'
-            - '%core.php_ext%'
-            - '%topfive_constants%'
-            - '@?phpbb.collapsiblecategories.operator'
         tags:
             - { name: event.listener }
diff --git "[ORIGINAL]/rmcgirr83\\topfive/config/topfive_constants.yml" "[ORIGINAL]/rmcgirr83\\topfive/config/topfive_constants.yml"
deleted file mode 100644
--- "[ORIGINAL]/rmcgirr83\\topfive/config/topfive_constants.yml"
+++ /dev/null
@@ -1,6 +0,0 @@
-parameters:
-    topfive_constants:
-        top_of_index: 0
-        bottom_of_index: 1
-        top_of_entire_forum: 2
-        bottom_of_entire_forum: 3
\ No newline at end of file
diff --git "[ORIGINAL]/rmcgirr83\\topfive/controller/admin_controller.php" "[ORIGINAL]/rmcgirr83\\topfive/controller/admin_controller.php"
deleted file mode 100644
--- "[ORIGINAL]/rmcgirr83\\topfive/controller/admin_controller.php"
+++ /dev/null
@@ -1,190 +0,0 @@
-<?php
-/**
-*
-* Top Five extension for the phpBB Forum Software package.
-*
-* @copyright 2016 Rich McGirr (RMcGirr83)
-* @license GNU General Public License, version 2 (GPL-2.0)
-*
-*/
-
-namespace rmcgirr83\topfive\controller;
-
-use phpbb\cache\service as cache;
-use phpbb\config\config;
-use phpbb\language\language;
-use phpbb\request\request;
-use phpbb\template\template;
-
-class admin_controller
-{
-	/** @var cache */
-	protected $cache;
-
-	/** @var config */
-	protected $config;
-
-	/** @var language */
-	protected $language;
-
-	/** @var request */
-	protected $request;
-
-	/** @var template */
-	protected $template;
-
-	/** @var string phpBB root path */
-	protected $root_path;
-
-	/** @var string phpEx */
-	protected $php_ext;
-
-	/* @var array topfive_constants */
-	protected $topfive_constants;
-
-	/** @var string Custom form action */
-	protected $u_action;
-
-	/**
-	* Constructor
-	*
-	* @param cache						$cache				Cache object
-	* @param config						$config				Config object
-	* @param language					$language			Language object
-	* @param request					$request			Request object
-	* @param template					$template			Template object
-	* @param string						$root_path			phpBB root path
-	* @param string						$php_ext			phpEx
-	* @param array						$topfive_constants	Constants for the extension
-	* @access public
-	*/
-	public function __construct(
-			cache $cache,
-			config $config,
-			language $language,
-			request $request,
-			template $template,
-			string $root_path,
-			string $php_ext,
-			array $topfive_constants)
-	{
-		$this->cache = $cache;
-		$this->config = $config;
-		$this->language = $language;
-		$this->request = $request;
-		$this->template = $template;
-		$this->root_path = $root_path;
-		$this->php_ext = $php_ext;
-		$this->topfive_constants = $topfive_constants;
-	}
-
-	public function display_options()
-	{
-		$this->language->add_lang('acp_topfive', 'rmcgirr83/topfive');
-
-		// Create a form key for preventing CSRF attacks
-		add_form_key('acp_topfive');
-
-		// get the excluded forums
-		$excluded_forums = explode(',', $this->config['top_five_excluded']);
-
-		if ($this->request->is_set_post('submit'))
-		{
-			if (!check_form_key('acp_topfive'))
-			{
-				trigger_error('FORM_INVALID');
-			}
-			if (!function_exists('validate_data'))
-			{
-				include($this->root_path . 'includes/functions_user.' . $this->php_ext);
-			}
-
-			$check_row = array('top_five_how_many' => $this->request->variable('top_five_how_many', 0));
-			$validate_row = array('top_five_how_many' => array('num', false, 5, 100));
-			$error = validate_data($check_row, $validate_row);
-			// Replace "error" strings with their real, localised form
-			$error = array_map(array($this->language, 'lang'), $error);
-
-			if (!sizeof($error))
-			{
-				$this->set_options();
-
-				$this->cache->destroy('_top_five_newest_users');
-				$this->cache->destroy('_top_five_posters');
-
-				trigger_error($this->language->lang('TF_SAVED') . adm_back_link($this->u_action));
-			}
-		}
-
-		$this->template->assign_vars(array(
-			'TF_ERROR'			=> isset($error) ? ((sizeof($error)) ? implode('<br />', $error) : '') : '',
-			'HOWMANY'			=> isset($this->config['top_five_how_many']) ? $this->config['top_five_how_many'] : 0,
-			'IGNORE_INACTIVE'	=> isset($this->config['top_five_ignore_inactive_users']) ? $this->config['top_five_ignore_inactive_users'] : false,
-			'IGNORE_FOUNDER'	=> isset($this->config['top_five_ignore_founder']) ? $this->config['top_five_ignore_founder'] : false,
-			'SHOW_ADMINS_MODS'	=> isset($this->config['top_five_show_admins_mods']) ? $this->config['top_five_show_admins_mods'] : false,
-			'LOCATION'			=> $this->location($this->config['top_five_location']),
-			'ACTIVE'			=> isset($this->config['top_five_active']) ? $this->config['top_five_active'] : false,
-			'TF_EXCLUDED'		=> $this->forum_select($excluded_forums),
-			'AVATARS'		=> isset($this->config['top_five_avatars']) ? $this->config['top_five_avatars'] : false,
-
-			'U_ACTION'			=> $this->u_action,
-		));
-	}
-
-	protected function set_options()
-	{
-		$this->config->set('top_five_how_many', $this->request->variable('top_five_how_many', 0));
-		$this->config->set('top_five_ignore_inactive_users', $this->request->variable('top_five_ignore_inactive_users', 0));
-		$this->config->set('top_five_ignore_founder', $this->request->variable('top_five_ignore_founder', 0));
-		$this->config->set('top_five_show_admins_mods', $this->request->variable('top_five_show_admins_mods', 0));
-		$this->config->set('top_five_location', $this->request->variable('top_five_location', 0));
-		$this->config->set('top_five_active', $this->request->variable('top_five_active', 0));
-
-		// variable should be '' as it is a string ("1, 2, 3928") here, not an integer.
-		$forums = $this->request->variable('selectForms',  array(''));
-		// change the array to a string
-		$forums  = implode(',', $forums);
-		$this->config->set('top_five_excluded', $forums);
-		$this->config->set('top_five_avatars', $this->request->variable('top_five_avatars',0));
-	}
-
-	/**
-	 * Display a drop down of all forums for selection
-	 *
-	 * @return drop down select
-	 * @access protected
-	 */
-	private function forum_select($value)
-	{
-		return '<select id="top_five_excluded" name="selectForms[]" multiple="multiple">' . make_forum_select($value, false, true, true) . '</select>';
-	}
-
-	/**
-	 * Create the selection for the post method
-	 */
-	public function location($location = 0)
-	{
-		// location options
-		$location_text = [$this->topfive_constants['top_of_index'] => $this->language->lang('TOP_OF_FORUM'), $this->topfive_constants['bottom_of_index'] => $this->language->lang('BOTTOM_OF_FORUM'), $this->topfive_constants['top_of_entire_forum'] => $this->language->lang('TOP_OF_ENTIRE_FORUM'), $this->topfive_constants['bottom_of_entire_forum'] => $this->language->lang('BOTTOM_OF_ENTIRE_FORUM')];
-		$location_options = '';
-		foreach ($location_text as $value => $text)
-		{
-			$selected = ($value == $location) ? ' selected="selected"' : '';
-			$location_options .= "<option value='{$value}'$selected>$text</option>";
-		}
-
-		return $location_options;
-	}
-
-	/**
-	 * Set page url
-	 *
-	 * @param string $u_action Custom form action
-	 * @return null
-	 * @access public
-	 */
-	public function set_page_url($u_action)
-	{
-		$this->u_action = $u_action;
-	}
-}
diff --git "[ORIGINAL]/rmcgirr83\\topfive/core/topfive.php" "[FORUM_EXT]/rmcgirr83\\topfive/core/topfive.php"
--- "[ORIGINAL]/rmcgirr83\\topfive/core/topfive.php"
+++ "[FORUM_EXT]/rmcgirr83\\topfive/core/topfive.php"
@@ -11,65 +11,39 @@
 
 namespace rmcgirr83\topfive\core;
 
-use phpbb\auth\auth;
-use phpbb\config\config;
-use phpbb\cache\service as cache_service;
-use phpbb\content_visibility;
-use phpbb\db\driver\driver_interface;
-use phpbb\event\dispatcher_interface;
-use phpbb\language\language;
-use phpbb\template\template;
-use phpbb\user;
-
 class topfive
 {
-	/** @var auth */
+	/** @var \phpbb\auth\auth */
 	protected $auth;
 
-	/** @var config */
+	/** @var \phpbb\config\config */
 	protected $config;
 
-	/** @var cache */
+	/** @var \phpbb\cache\driver\driver_interface */
 	protected $cache;
 
-	/** @var content_visibility */
+	/** @var \phpbb\content_visibility */
 	protected $content_visibility;
 
-	/** @var db */
+	/** @var \phpbb\db\driver\driver_interface */
 	protected $db;
 
-	/** @var dispatcher */
+	/** @var \phpbb\event\dispatcher_interface */
 	protected $dispatcher;
 
-	/** @var language */
-	protected $language;
-
-	/** @var template */
+	/** @var \phpbb\template\template */
 	protected $template;
 
-	/** @var user */
+	/** @var \phpbb\user */
 	protected $user;
 
-	/** @var string phpbb_root_path */
+	/** @var string phpBB root path */
 	protected $phpbb_root_path;
 
-	/** @var string php_ext */
+	/** @var string PHP extension */
 	protected $php_ext;
 
-	public function __construct(
-		auth $auth,
-		config $config,
-		cache_service $cache,
-		content_visibility $content_visibility,
-		driver_interface $db,
-		dispatcher_interface $dispatcher,
-		language $language,
-		template $template,
-		user $user,
-		string $phpbb_root_path,
-		string $php_ext,
-		\senky\relativedates\event\listener $relativedates = null,
-		\rmcgirr83\nationalflags\core\nationalflags $nationalflags= null)
+	public function __construct(\phpbb\auth\auth $auth, \phpbb\config\config $config, \phpbb\cache\service $cache, \phpbb\content_visibility $content_visibility, \phpbb\db\driver\driver_interface $db, \phpbb\event\dispatcher_interface $dispatcher, \phpbb\template\template $template, \phpbb\user $user, $phpbb_root_path, $php_ext)
 	{
 		$this->auth = $auth;
 		$this->config = $config;
@@ -77,27 +51,18 @@ class topfive
 		$this->content_visibility = $content_visibility;
 		$this->db = $db;
 		$this->dispatcher = $dispatcher;
-		$this->language = $language;
 		$this->template = $template;
 		$this->user = $user;
 		$this->root_path = $phpbb_root_path;
 		$this->php_ext = $php_ext;
-		$this->relativedates = $relativedates;
-		$this->nationalflags = $nationalflags;
 	}
 
-	/**
-	* Display activity
-	*
-	* @param	string	$tpl_loopname	Name of the html file
-	* @return 	null
-	* @access 	public
-	*/
 	public function toptopics($tpl_loopname = 'top_five_topic')
 	{
+
 		$howmany = $this->howmany();
 
-		$forum_ary = [];
+		$forum_ary = array();
 		$forum_read_ary = $this->auth->acl_getf('f_read');
 
 		foreach ($forum_read_ary as $forum_id => $allowed)
@@ -109,35 +74,19 @@ class topfive
 		}
 		$forum_ary = array_unique($forum_ary);
 
-		// want to exclude some forums
-		$excluded_forums = explode(',', $this->config['top_five_excluded']);
-
-		// now remove those topics from the display per the excluded forums array
-		$forum_ary = array_diff($forum_ary, $excluded_forums);
-
-		if (!sizeof($forum_ary))
+		if (sizeof($forum_ary))
 		{
-			$this->template->assign_block_vars($tpl_loopname, [
-				'NO_TOPIC_TITLE'	=> $this->language->lang('NO_TOPIC_EXIST'),
-			]);
-
-			return false;
-		}
-
 			/**
 			* Select topic_ids
 			*/
-		// grab all posts that meet criteria and auths
-		$sql_array = [
-			'SELECT'	=> 't.forum_id, t.topic_id, t.topic_type',
-			'FROM'		=> [TOPICS_TABLE => 't'],
-			'WHERE'		=> $this->content_visibility->get_forums_visibility_sql('topic', $forum_ary) . ' AND topic_status <> ' . ITEM_MOVED,
-			'ORDER_BY'	=> 't.topic_last_post_time DESC',
-		];
-
-		$result = $this->db->sql_query_limit($this->db->sql_build_query('SELECT', $sql_array), $howmany);
-
-		$forums = $ga_topic_ids = $topic_ids = [];
+			$sql = 'SELECT forum_id, topic_id, topic_type
+				FROM ' . TOPICS_TABLE . '
+				WHERE ' . $this->content_visibility->get_forums_visibility_sql('topic', $forum_ary) . '
+				AND topic_status <> ' . ITEM_MOVED . '
+				ORDER BY topic_last_post_time DESC';
+
+			$result = $this->db->sql_query_limit($sql, $howmany);
+			$forums = $ga_topic_ids = $topic_ids = array();
 			while ($row = $this->db->sql_fetchrow($result))
 			{
 				$topic_ids[] = $row['topic_id'];
@@ -153,7 +102,7 @@ class topfive
 			$this->db->sql_freeresult($result);
 
 			// Get topic tracking
-		$topic_tracking_info = [];
+			$topic_tracking_info = array();
 			foreach ($forums as $forum_id => $topic_id)
 			{
 				$topic_tracking_info[$forum_id] = get_complete_topic_tracking($forum_id, $topic_id, $ga_topic_ids);
@@ -163,37 +112,25 @@ class topfive
 			* must have topic_ids.
 			* A user can have forums and not have topic_ids before installing this extension
 			*/
-		if (!sizeof($topic_ids))
+			if (sizeof($topic_ids))
 			{
-			$this->template->assign_block_vars($tpl_loopname, [
-				'NO_TOPIC_TITLE'	=> $this->language->lang('NO_TOPIC_EXIST'),
-			]);
-
-			return false;
-		}
-
 				// grab all posts that meet criteria and auths
-		$sql_array = [
-			'SELECT'	=> 'u.user_id, u.username, u.user_colour, u.user_avatar, u.user_avatar_type, u.user_avatar_height, u.user_avatar_width, t.topic_title, t.forum_id, t.topic_id, t.topic_first_post_id, t.topic_last_post_id, t.topic_last_post_time, t.topic_last_poster_name, f.forum_name',
-			'FROM'		=> [TOPICS_TABLE => 't'],
-			'LEFT_JOIN'	=> [
-				[
-					'FROM'	=> [USERS_TABLE => 'u'],
+				$sql_array = array(
+					'SELECT'	=> 'u.user_id, u.username, u.user_colour, u.user_avatar, u.user_avatar_type, u.user_avatar_width, u.user_avatar_height, t.topic_title, t.forum_id, t.topic_id, t.topic_first_post_id, t.topic_last_post_id, t.topic_last_post_time, t.topic_last_poster_name, f.forum_name',
+					'FROM'		=> array(TOPICS_TABLE => 't'),
+					'LEFT_JOIN'	=> array(
+						array(
+							'FROM'	=> array(USERS_TABLE => 'u'),
 							'ON'	=> 't.topic_last_poster_id = u.user_id',
-				],
-				[
-					'FROM'	=> [FORUMS_TABLE => 'f'],
+						),
+						array(
+							'FROM'	=> array(FORUMS_TABLE => 'f'),
 							'ON'	=> 't.forum_id = f.forum_id',
-				],
-			],
+						),
+					),
 					'WHERE'		=> $this->db->sql_in_set('t.topic_id', $topic_ids),
 					'ORDER_BY'	=> 't.topic_last_post_time DESC',
-		];
-		if ($this->nationalflags !== null)
-		{
-			$sql_array['SELECT'].= ', u.user_flag';
-		}
-
+				);
 				/**
 				* Event to modify the SQL query before the topics data is retrieved
 				*
@@ -201,10 +138,11 @@ class topfive
 				* @var	array	sql_array		The SQL array
 				* @since 1.0.0
 				*/
-		$vars = ['sql_array'];
+				$vars = array('sql_array');
 				extract($this->dispatcher->trigger_event('rmcgirr83.topfive.sql_pull_topics_data', compact($vars)));
 
-		$result = $this->db->sql_query_limit($this->db->sql_build_query('SELECT', $sql_array), $howmany);
+				// cache the query for one minute
+				$result = $this->db->sql_query_limit($this->db->sql_build_query('SELECT', $sql_array), $howmany, 0, 60);
 
 				while ($row = $this->db->sql_fetchrow($result))
 				{
@@ -213,49 +151,26 @@ class topfive
 					$forum_name = $row['forum_name'];
 
 					$post_unread = (isset($topic_tracking_info[$forum_id][$topic_id]) && $row['topic_last_post_time'] > $topic_tracking_info[$forum_id][$topic_id]) ? true : false;
-			$view_topic_url = !empty($post_unread) ? append_sid("{$this->root_path}viewtopic.$this->php_ext", 't=' . $topic_id . '&amp;view=unread') . '#unread' : append_sid("{$this->root_path}viewtopic.$this->php_ext", 't=' . $topic_id);
-			/** To go to the last post in a topic use the below as the last argument in the above $view_topic_url variable
-			append_sid("{$this->root_path}viewtopic.$this->php_ext", 'f=' . $row['forum_id'] . '&amp;p=' . $row['topic_last_post_id'] . '#p' . $row['topic_last_post_id'])
-			**/
-			$forum_name_url = append_sid("{$this->root_path}viewforum.$this->php_ext", 'f=' . $row['forum_id']);
+					$view_topic_url = append_sid("{$this->phpbb_root_path}viewtopic.$this->php_ext", 'f=' . $row['forum_id'] . '&amp;p=' . $row['topic_last_post_id'] . '#p' . $row['topic_last_post_id']);
+					$forum_name_url = append_sid("{$this->phpbb_root_path}viewforum.$this->php_ext", 'f=' . $row['forum_id']);
 					$topic_title = censor_text($row['topic_title']);
-			$topic_title = truncate_string($topic_title, 60, 255, false, $this->language->lang('ELLIPSIS'));
-
-			$is_guest = ($row['user_id'] == ANONYMOUS) ? true : false;
-
-			$user_avatar = phpbb_get_user_avatar($row);
-			$display_avatar = (!empty($this->config['top_five_avatars']) && $this->user->optionget('viewavatars') && !empty($user_avatar)) ? true : false;
-
-			$user_avatar = $display_avatar ? '<span class="topfive-avatar">' . $user_avatar . '</span>&nbsp;' : '';
-
-			// relativedates installed?
-			if ($this->relativedates !== null)
+					if (utf8_strlen($topic_title) >= 60)
 					{
-				$last_topic_time = $this->user->format_date($row['topic_last_post_time'], false, false, false);
-			}
-			else
-			{
-				$last_topic_time = $this->user->format_date($row['topic_last_post_time']);
-			}
-
-			$user_flag = '';
-			// nationalflags installed?
-			if (!empty($row['user_flag']))
-			{
-				$user_flag = $this->nationalflags->get_user_flag($row['user_flag'], 12);
+						$topic_title = (utf8_strlen($topic_title) > 60 + 3) ? utf8_substr($topic_title, 0, 60) . '...' : $topic_title;
 					}
+					$is_guest = ($row['user_id'] == ANONYMOUS) ? true : false;
+                    $user_avatar = ($row['user_avatar']) ? get_user_avatar($row['user_avatar'], $row['user_avatar_type'], 50, 50) : '<img src="' . generate_board_url() . '/styles/' . '/FLATBOOTS/' . '/theme/images/no_avatar.gif" height="50" width="50" alt="Default Avatar" />';
 					
-			$tpl_ary = [
+					$tpl_ary = array(
 						'U_TOPIC'			=> $view_topic_url,
 						'U_FORUM'			=> $forum_name_url,
+						'TOP5_AVATAR' 	    => $user_avatar,
 						'S_UNREAD'			=> ($post_unread) ? true : false,
-				'USERNAME_FULL'	=> ($is_guest || !$this->auth->acl_get('u_viewprofile')) ? $this->language->lang('BY') . $user_avatar . get_username_string('no_profile', $row['user_id'], $row['username'], $row['user_colour'], $row['topic_last_poster_name']) : $this->language->lang('BY') . $user_avatar . get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']),
-				'LAST_TOPIC_TIME'	=> $last_topic_time,
+						'USERNAME_FULL'		=> ($is_guest || !$this->auth->acl_get('u_viewprofile')) ? $this->user->lang['POST_BY_AUTHOR'] . ' ' . get_username_string('no_profile', $row['user_id'], $row['username'], $row['user_colour'], $row['topic_last_poster_name']) : $this->user->lang['POST_BY_AUTHOR'] . ' ' . get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']),
+						'LAST_TOPIC_TIME'	=> $this->user->format_date($row['topic_last_post_time']),
 						'TOPIC_TITLE' 		=> $topic_title,
 						'FORUM_NAME'		=> $forum_name,
-				'USER_FLAG'	=> !empty($user_flag) ? $user_flag : '',
-			];
-
+					);
 					/**
 					* Modify the topic data before it is assigned to the template
 					*
@@ -264,65 +179,79 @@ class topfive
 					* @var	array	tpl_ary		Template block array with topic data
 					* @since 1.0.0
 					*/
-			$vars = ['row', 'tpl_ary'];
+					$vars = array('row', 'tpl_ary');
 					extract($this->dispatcher->trigger_event('rmcgirr83.topfive.modify_tpl_ary', compact($vars)));
 
 					$this->template->assign_block_vars($tpl_loopname, $tpl_ary);
 				}
 				$this->db->sql_freeresult($result);
 			}
+			else
+			{
+				$this->template->assign_block_vars($tpl_loopname, array(
+					'NO_TOPIC_TITLE'	=> $this->user->lang['NO_TOPIC_EXIST'],
+				));
+			}
+		}
+		else
+		{
+			$this->template->assign_block_vars($tpl_loopname, array(
+				'NO_TOPIC_TITLE'	=> $this->user->lang['NO_TOPIC_EXIST'],
+			));
+		}
+	}
 
-	/**
-	* Get the top posters
-	*
-	* @return 	null
-	* @access 	public
-	*/
 	public function topposters()
 	{
 		$howmany = $this->howmany();
 		$sql_where = $this->ignore_users();
 
+		//set two variables for the sql
+		$sql_and = $sql_other = '';
+
 		if (($user_posts = $this->cache->get('_top_five_posters')) === false)
 		{
-			$user_posts = [];
 
-			$sql_where .= empty($sql_where) ? 'u.user_posts <> 0' : ' AND u.user_posts <> 0';
+			$user_posts = $admin_mod_array = array();
+			// quick check for forum moderators and administrators
+			// some may not want to show them
+			$show_admins_mods = $this->config['top_five_show_admins_mods'];
 
-			// do the main sql query
-			$sql_array = [
-				'SELECT' => 'u.user_id, u.username, u.user_colour, u.user_posts, u.user_avatar, u.user_avatar_width, u.user_avatar_height, u.user_avatar_type, u.user_lastpost_time',
-				'FROM' => [USERS_TABLE => 'u'],
-				'WHERE' => $sql_where,
-				'ORDER_BY' => 'u.user_lastpost_time DESC, u.user_posts DESC',
-			];
-
-			if ($this->nationalflags !== null)
+			if (!$show_admins_mods)
 			{
-				$sql_array['SELECT'] .= ', u.user_flag';
+				// grab all admins
+				$admin_ary = $this->auth->acl_get_list(false, 'a_', false);
+				$admin_ary = (!empty($admin_ary[0]['a_'])) ? $admin_ary[0]['a_'] : array();
+
+				//grab all mods
+				$mod_ary = $this->auth->acl_get_list(false,'m_', false);
+				$mod_ary = (!empty($mod_ary[0]['m_'])) ? $mod_ary[0]['m_'] : array();
+				$admin_mod_array = array_unique(array_merge($admin_ary, $mod_ary));
+				if (sizeof($admin_mod_array))
+				{
+					$sql_and = empty($sql_where) ? ' WHERE' : ' AND';
+					$sql_and .= ' ' . $this->db->sql_in_set('user_id', $admin_mod_array, true);
 				}
-			$result = $this->db->sql_query_limit($this->db->sql_build_query('SELECT', $sql_array), $howmany);
+			}
+			$sql_other = (empty($sql_and) && empty($sql_where)) ? ' WHERE' : ' AND';
+			$sql_other .=  ' user_posts <> 0';
+
+			// do the main sql query
+			$sql = 'SELECT user_id, username, user_colour, user_posts
+				FROM ' . USERS_TABLE . '
+				 ' . $sql_where . ' ' . $sql_and . '
+				' . $sql_other . '
+				ORDER BY user_posts DESC';
 
+			$result = $this->db->sql_query_limit($sql, $howmany);
 			while ($row = $this->db->sql_fetchrow($result))
 			{
-				$user_flag = '';
-				// nationalflags installed?
-				if (!empty($row['user_flag']))
-				{
-					$user_flag = $this->nationalflags->get_user_flag($row['user_flag'], 12);
-				}
-				$user_posts[$row['user_id']] = [
+				$user_posts[$row['user_id']] = array(
 					'user_id'      => $row['user_id'],
 					'username'      => $row['username'],
 					'user_colour'   => $row['user_colour'],
 					'user_posts'    => $row['user_posts'],
-					'user_avatar'	=> $row['user_avatar'],
-					'user_avatar_width'	=> $row['user_avatar_width'],
-					'user_avatar_height'	=> $row['user_avatar_height'],
-					'user_avatar_type'	=> $row['user_avatar_type'],
-					'user_lastpost_time'	=> $row['user_lastpost_time'],
-					'user_flag'	=> !empty($user_flag) ? $user_flag : '',
-				];
+				);
 			}
 			$this->db->sql_freeresult($result);
 
@@ -332,81 +261,44 @@ class topfive
 
 		foreach ($user_posts as $row)
 		{
-			$user_avatar = phpbb_get_user_avatar($row);
-			$display_avatar = (!empty($this->config['top_five_avatars']) && $this->user->optionget('viewavatars') && !empty($user_avatar)) ? true : false;
-
-			$user_avatar = $display_avatar ? '<span class="topfive-avatar">' . $user_avatar . '</span>&nbsp;' : '';
-
-			$username_string = ($this->auth->acl_get('u_viewprofile')) ? $user_avatar . get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']) : $user_avatar . get_username_string('no_profile', $row['user_id'], $row['username'], $row['user_colour']);
-			if ($this->relativedates !== null)
-			{
-				$user_lastpost_time = $this->user->format_date($row['user_lastpost_time'], false, false, false);
-			}
-			else
-			{
-				$user_lastpost_time = $this->user->format_date($row['user_lastpost_time']);
-			}
+			$username_string = ($this->auth->acl_get('u_viewprofile')) ? get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']) : get_username_string('no_profile', $row['user_id'], $row['username'], $row['user_colour']);
 
-			$this->template->assign_block_vars('top_five_active',[
-				'S_SEARCH_ACTION'	=> append_sid("{$this->root_path}search.$this->php_ext", 'author_id=' . $row['user_id'] . '&amp;sr=posts'),
+			$this->template->assign_block_vars('top_five_active',array(
+				'S_SEARCH_ACTION'	=> append_sid("{$this->phpbb_root_path}search.$this->php_ext", 'author_id=' . $row['user_id'] . '&amp;sr=posts'),
 				'POSTS' 			=> number_format($row['user_posts']),
 				'USERNAME_FULL'		=> $username_string,
-				'USER_LASTPOST_TIME'	=> $this->language->lang('USER_LASTPOST_TIME', $user_lastpost_time),
-				'USER_FLAG'	=> !empty($row['user_flag']) ? $row['user_flag'] : '',
-			]);
+			));
 		}
 	}
 
-	/**
-	* Get the newest members
-	*
-	* @return 	null
-	* @access 	public
-	*/
 	public function newusers()
 	{
+
 		$howmany = $this->howmany();
 		$sql_where = $this->ignore_users();
 
-		$sql_where .= !empty($sql_where) ? ' AND u.user_inactive_reason = 0' : ' u.user_inactive_reason = 0';
+		$sql_and = !empty($sql_where) ? ' AND user_inactive_reason = 0' : ' WHERE user_inactive_reason = 0';
 		// newest registered users
 		if (($newest_users = $this->cache->get('_top_five_newest_users')) === false)
 		{
-			$newest_users = [];
+			$newest_users = array();
 
 			// grab most recent registered users
-			$sql_array = [
-				'SELECT' => 'u.user_id, u.username, u.user_colour, u.user_regdate, u.user_avatar, u.user_avatar_width, u.user_avatar_height, u.user_avatar_type',
-				'FROM' => [USERS_TABLE => 'u'],
-				'WHERE' => $sql_where,
-				'ORDER_BY' =>  'u.user_regdate DESC',
-			];
-			if ($this->nationalflags !== null)
-			{
-				$sql_array['SELECT'] .= ', u.user_flag';
-			}
-			$result = $this->db->sql_query_limit($this->db->sql_build_query('SELECT', $sql_array), $howmany);
+			$sql = 'SELECT user_id, username, user_colour, user_regdate
+				FROM ' . USERS_TABLE . '
+				' . $sql_where . '
+				' . $sql_and . '
+				ORDER BY user_regdate DESC';
+			$result = $this->db->sql_query_limit($sql, $howmany);
 
 			while ($row = $this->db->sql_fetchrow($result))
 			{
-				$user_flag = '';
-				// nationalflags installed?
-				if (!empty($row['user_flag']))
-				{
-					$user_flag = $this->nationalflags->get_user_flag($row['user_flag'], 12);
-				}
-
-				$newest_users[$row['user_id']] = [
+				$newest_users[$row['user_id']] = array(
 					'user_id'				=> $row['user_id'],
 					'username'				=> $row['username'],
 					'user_colour'			=> $row['user_colour'],
 					'user_regdate'			=> $row['user_regdate'],
-					'user_avatar'			=> $row['user_avatar'],
-					'user_avatar_width'		=> $row['user_avatar_width'],
-					'user_avatar_height'	=> $row['user_avatar_height'],
-					'user_avatar_type'		=> $row['user_avatar_type'],
-					'user_flag'				=> !empty($user_flag) ? $user_flag : '',
-				];
+				);
 			}
 			$this->db->sql_freeresult($result);
 
@@ -416,27 +308,15 @@ class topfive
 
 		foreach ($newest_users as $row)
 		{
-			$user_avatar = phpbb_get_user_avatar($row);
-			$display_avatar = (!empty($this->config['top_five_avatars']) && $this->user->optionget('viewavatars') && !empty($user_avatar)) ? true : false;
-
-			$user_avatar = $display_avatar ? '<span class="topfive-avatar">' . $user_avatar . '</span>&nbsp;' : '';
-
-			$username_string = ($this->auth->acl_get('u_viewprofile')) ? $user_avatar . get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']) : $user_avatar . get_username_string('no_profile', $row['user_id'], $row['username'], $row['user_colour']);
+			$username_string = ($this->auth->acl_get('u_viewprofile')) ? get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']) : get_username_string('no_profile', $row['user_id'], $row['username'], $row['user_colour']);
 
-			$this->template->assign_block_vars('top_five_newest',[
+			$this->template->assign_block_vars('top_five_newest',array(
 				'REG_DATE'			=> $this->user->format_date($row['user_regdate']),
 				'USERNAME_FULL'		=> $username_string,
-				'USER_FLAG'			=> !empty($row['user_flag']) ? $row['user_flag'] : '',
-			]);
+			));
 		}
 	}
 
-	/**
-	* How many to display
-	*
-	* @return 	int 	$howmany
-	* @access 	private
-	*/
 	private function howmany()
 	{
 		$howmany = $this->config['top_five_how_many'];
@@ -444,24 +324,18 @@ class topfive
 		return (int) $howmany;
 	}
 
-	/**
-	* Ignore users
-	*
-	* @return 	string 	$sql_where
-	* @access 	private
-	*/
 	private function ignore_users()
 	{
 		// an array of user types we dont' bother with
-		$ignore_users = $ignore_founders = [];
+		$ignore_users = $ignore_founders = array();
 		if ($this->config['top_five_ignore_inactive_users'])
 		{
-			$ignore_users = [USER_IGNORE, USER_INACTIVE];
+			$ignore_users = array(USER_IGNORE, USER_INACTIVE);
 		}
 
 		if ($this->config['top_five_ignore_founder'])
 		{
-			$ignore_founders = [USER_FOUNDER];
+			$ignore_founders = array(USER_FOUNDER);
 		}
 
 		$ignore_users = array_merge($ignore_users, $ignore_founders);
@@ -470,28 +344,9 @@ class topfive
 		$sql_where = '';
 		if (sizeof($ignore_users))
 		{
-			$sql_where = $this->db->sql_in_set('u.user_type', $ignore_users, true);
+			$sql_where = 'WHERE ' . $this->db->sql_in_set('user_type', $ignore_users, true);
 		}
-		$admin_mod_array = [];
-		// quick check for forum moderators and administrators
-		// some may not want to show them
-		$show_admins_mods = $this->config['top_five_show_admins_mods'];
 
-		if (!$show_admins_mods)
-		{
-			// grab all admins
-			$admin_ary = $this->auth->acl_get_list(false, 'a_', false);
-			$admin_ary = (!empty($admin_ary[0]['a_'])) ? $admin_ary[0]['a_'] : [];
-
-			//grab all mods
-			$mod_ary = $this->auth->acl_get_list(false,'m_', false);
-			$mod_ary = (!empty($mod_ary[0]['m_'])) ? $mod_ary[0]['m_'] : [];
-			$admin_mod_array = array_unique(array_merge($admin_ary, $mod_ary));
-			if (sizeof($admin_mod_array))
-			{
-				$sql_where .= empty($sql_where) ? $this->db->sql_in_set('u.user_id', $admin_mod_array, true) : ' AND ' . $this->db->sql_in_set('u.user_id', $admin_mod_array, true);
-			}
-		}
 		return $sql_where;
 	}
 }
diff --git "[FORUM_EXT]/rmcgirr83\\topfive/diff_full.tmp" "[FORUM_EXT]/rmcgirr83\\topfive/diff_full.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/rmcgirr83\\topfive/diff_full.tmp"
@@ -0,0 +1,3248 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/acp/topfive_info.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\topfive/acp/topfive_info.php"
+index 591b4fa8f..c0f748d31 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/acp/topfive_info.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\topfive/acp/topfive_info.php"
+@@ -19,9 +19,9 @@ class topfive_info
+ 		return array(
+ 			'filename'	=> '\rmcgirr83\topfive\acp\topfive_module',
+ 			'title'		=> 'TF_ACP',
+-			'version'	=> '1.2.3',
++			'version'	=> '1.0.0',
+ 			'modes'		=> array(
+-				'settings'	=> array('title' => 'TF_CONFIG', 'auth'	=> 'ext_rmcgirr83/topfive && acl_a_extensions' , 'cat'	=> array('TOPFIVE_MOD')),
++				'settings'	=> array('title' => 'TF_CONFIG', 'auth'	=> 'ext_rmcgirr83/topfive', 'cat'	=> array('TOPFIVE_MOD')),
+ 			),
+ 		);
+ 	}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/acp/topfive_module.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\topfive/acp/topfive_module.php"
+index 3cc28d045..c1801a315 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/acp/topfive_module.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\topfive/acp/topfive_module.php"
+@@ -11,21 +11,67 @@ namespace rmcgirr83\topfive\acp;
+ 
+ class topfive_module
+ {
+-	public $u_action;
++	var $u_action;
+ 
+ 	function main($id, $mode)
+ 	{
+-		global $phpbb_container;
++		global $db, $user, $auth, $template, $cache, $request;
++		global $config, $phpbb_root_path, $phpbb_admin_path, $phpEx;
+ 
++		$this->config = $config;
++		$this->request = $request;
++
++		$user->add_lang('acp/common');
++		$user->add_lang_ext('rmcgirr83/topfive', 'acp/info_acp_topfive');
+ 		$this->tpl_name = 'acp_topfive';
+-		$this->page_title = $phpbb_container->get('language')->lang('TF_ACP');
++		$this->page_title = $user->lang['TOPFIVE_MOD'];
++		add_form_key('acp_topfive');
++
++		if ($request->is_set_post('submit'))
++		{
++			if (!check_form_key('acp_topfive'))
++			{
++				trigger_error('FORM_INVALID');
++			}
++			if (!function_exists('validate_data'))
++			{
++				include($phpbb_root_path . 'includes/functions_user.' . $phpEx);
++			}
++
++			$check_row = array('top_five_how_many' => $request->variable('top_five_how_many', 0));
++			$validate_row = array('top_five_how_many' => array('num', false, 5, 100));
++			$error = validate_data($check_row, $validate_row);
++
++			// Replace "error" strings with their real, localised form
++			$error = array_map(array($user, 'lang'), $error);
++
++			if (!sizeof($error))
++			{
++				$config->set('top_five_how_many', $request->variable('top_five_how_many', 0));
++				$config->set('top_five_ignore_inactive_users', $request->variable('top_five_ignore_inactive_users', true));
++				$config->set('top_five_ignore_founder', $request->variable('top_five_ignore_founder', true));
++				$config->set('top_five_show_admins_mods', $request->variable('top_five_show_admins_mods', true));
++				$config->set('top_five_location', $request->variable('top_five_location', true));
++				$config->set('top_five_active', $request->variable('top_five_active', true));
++
++				$cache->destroy('_top_five_newest_users');
++				$cache->destroy('_top_five_posters');
+ 
+-		// Get an instance of the admin controller
+-		$admin_controller = $phpbb_container->get('rmcgirr83.topfive.admin.controller');
++				trigger_error($user->lang['TF_SAVED'] . adm_back_link($this->u_action));
++			}
++		}
+ 
+-		// Make the $u_action url available in the admin controller
+-		$admin_controller->set_page_url($this->u_action);
++		$template->assign_vars(array(
++			'TF_ERROR'			=> isset($error) ? ((sizeof($error)) ? implode('<br />', $error) : '') : '',
++			'HOWMANY'			=> (!empty($this->config['top_five_how_many'])) ? $this->config['top_five_how_many'] : 0,
++			'IGNORE_INACTIVE'	=> (!empty($this->config['top_five_ignore_inactive_users'])) ? true : false,
++			'IGNORE_FOUNDER'	=> (!empty($this->config['top_five_ignore_founder'])) ? true : false,
++			'SHOW_ADMINS_MODS'	=> (!empty($this->config['top_five_show_admins_mods'])) ? true : false,
++			'LOCATION'			=> (!empty($this->config['top_five_location'])) ? true : false,
++			'ACTIVE'			=> (!empty($this->config['top_five_active'])) ? true : false,
++			'TF_VERSION'		=> $this->config['top_five_version'],
+ 
+-		$admin_controller->display_options();
++			'U_ACTION'			=> $this->u_action,
++		));
+ 	}
+ }
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/adm/style/acp_topfive.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\topfive/adm/style/acp_topfive.html"
+index 48224526d..f799a7138 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/adm/style/acp_topfive.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\topfive/adm/style/acp_topfive.html"
+@@ -1,60 +1,51 @@
+-{% INCLUDE 'overall_header.html' %}
++<!-- INCLUDE overall_header.html -->
+ 
+-<h1>{{ lang('TF_TITLE') }}</h1>
+-<fieldset>
+-	<legend>{{ lang('BUY_ME_A_BEER') }}</legend>
+-	<dl>
+-		<dt><label>{{ lang('BUY_ME_A_BEER_SHORT') }}{{ lang('COLON') }}</label><br /><span>{{ lang('BUY_ME_A_BEER_EXPLAIN') }}</span></dt>
+-		<dd><a href="{{ lang('BUY_ME_A_BEER_URL') }}" target="_blank" rel="noreferrer noopener"><img src="{{ lang('PAYPAL_IMAGE_URL') }}" border="0" alt="{{ lang('PAYPAL_ALT') }}" style="cursor:pointer;margin-top:15px;"></a></dd>
+-	</dl>
+-</fieldset>
+-{% if TF_ERROR %}
+-	<div class="errorbox"><h3>{{ lang('WARNING') }}</h3>
+-		<p>{{ TF_ERROR }}</p>
++<h1>{L_TF_TITLE}</h1>
++<p>{L_TF_VERSION} {TF_VERSION}</p>
++
++<!-- IF TF_ERROR -->
++	<div class="errorbox"><h3>{L_WARNING}</h3>
++		<p>{TF_ERROR}</p>
+ 	</div>
+-{% endif %}
++<!-- ENDIF -->
+ 
+-<form id="acp_topfive" method="post" action="{{ U_ACTION }}">
++<form id="acp_topfive" method="post" action="{U_ACTION}">
+ 	<fieldset>
+-		<legend>{{ lang('TF_CONFIG') }}</legend>
+-		<dl>
+-			<dt><label>{{ lang('TF_LOCATION') ~ lang('COLON') }}</label><br>
+-			<span>{{ lang('TF_LOCATION_EXPLAIN') }}</span></dt>
+-			<dd><select name="top_five_location">{{ LOCATION }}</select></dd>
+-		</dl>
++		<legend>{L_TF_CONFIG}</legend>
+ 		<dl>
+-			<dt><label>{{ lang('TF_AVATARS') }}</label><br />{{ lang('TF_AVATARS_EXPLAIN') }}</dt>
+-			<dd><input type="radio" class="radio" name="top_five_avatars" value="1" {% if AVATARS %}checked="checked"{% endif %}/> {{ lang('YES') }} &nbsp;
+-				<input type="radio" class="radio" name="top_five_avatars" value="0" {% if not AVATARS %}checked="checked"{% endif %} /> {{ lang('NO') }}</dd>
++			<dt><label id="top_five_active" for="top_five_active">{L_TF_ACTIVE}</label></dt>
++			<dd><input type="radio" class="radio" name="top_five_active" value="1" <!-- IF ACTIVE -->checked="checked"<!-- ENDIF -->/> {L_YES} &nbsp;
++				<input type="radio" class="radio" name="top_five_active" value="0" <!-- IF not ACTIVE -->checked="checked"<!-- ENDIF --> /> {L_NO}</dd>
+ 		</dl>
+ 		<dl>
+-			<dt><label>{{ lang('TF_HOWMANY') }}</label><br />{{ lang('TF_HOWMANY_EXPLAIN') }}</dt>
+-			<dd><input type="number" name="top_five_how_many" size="10" min="5" max="100" value="{{ HOWMANY }}" /></dd>
++			<dt><label id="top_five_location" for="top_five_location">{L_TF_LOCATION}</label><br />{L_TF_LOCATION_EXPLAIN}</dt>
++			<dd><input type="radio" class="radio" name="top_five_location" value="1" <!-- IF LOCATION -->checked="checked"<!-- ENDIF -->/> {L_TOP_OF_FORUM} &nbsp;
++				<input type="radio" class="radio" name="top_five_location" value="0" <!-- IF not LOCATION -->checked="checked"<!-- ENDIF --> /> {L_BOTTOM_OF_FORUM}</dd>
+ 		</dl>
+ 		<dl>
+-			<dt><label>{{ lang('TF_EXCLUDED') ~ lang('COLON') }}</label><br /><span>{{ lang('TF_EXCLUDED_EXPLAIN') }}</span></dt>
+-			<dd>{{ TF_EXCLUDED }}</dd>
++			<dt><label id="top_five_how_many" for="top_five_how_many">{L_TF_HOWMANY}</label><br />{L_TF_HOWMANY_EXPLAIN}</dt>
++			<dd><input type="text" name="top_five_how_many" id="top_five_how_many" size="10" value="{HOWMANY}" /></dd>
+ 		</dl>
+ 		<dl>
+-			<dt><label>{{ lang('TF_IGNORE_USERS') }}</label><br />{{ lang('TF_IGNORE_USERS_EXPLAIN') }}</dt>
+-			<dd><input type="radio" class="radio" name="top_five_ignore_inactive_users" value="1" {% if IGNORE_INACTIVE %}checked="checked"{% endif %}/> {{ lang('YES') }} &nbsp;
+-				<input type="radio" class="radio" name="top_five_ignore_inactive_users" value="0" {% if not IGNORE_INACTIVE %}checked="checked"{% endif %} /> {{ lang('NO') }}</dd>
++			<dt><label id="top_five_ignore_inactive_users" for="top_five_ignore_inactive_users">{L_TF_IGNORE_USERS}</label><br />{L_TF_IGNORE_USERS_EXPLAIN}</dt>
++			<dd><input type="radio" class="radio" name="top_five_ignore_inactive_users" value="1" <!-- IF IGNORE_INACTIVE -->checked="checked"<!-- ENDIF -->/> {L_YES} &nbsp;
++				<input type="radio" class="radio" name="top_five_ignore_inactive_users" value="0" <!-- IF not IGNORE_INACTIVE -->checked="checked"<!-- ENDIF --> /> {L_NO}</dd>
+ 		</dl>
+ 		<dl>
+-			<dt><label>{{ lang('TF_IGNORE_FOUNDER') }}</label><br />{{ lang('TF_IGNORE_FOUNDER_EXPLAIN') }}</dt>
+-			<dd><input type="radio" class="radio" name="top_five_ignore_founder" value="1" {% if IGNORE_FOUNDER %}checked="checked"{% endif %}/> {{ lang('YES') }} &nbsp;
+-				<input type="radio" class="radio" name="top_five_ignore_founder" value="0" {% if not IGNORE_FOUNDER %}checked="checked"{% endif %} /> {{ lang('NO') }}</dd>
++			<dt><label id="top_five_ignore_founder" for="top_five_ignore_founder">{L_TF_IGNORE_FOUNDER}</label><br />{L_TF_IGNORE_FOUNDER_EXPLAIN}</dt>
++			<dd><input type="radio" class="radio" name="top_five_ignore_founder" value="1" <!-- IF IGNORE_FOUNDER -->checked="checked"<!-- ENDIF -->/> {L_YES} &nbsp; 
++				<input type="radio" class="radio" name="top_five_ignore_founder" value="0" <!-- IF not IGNORE_FOUNDER -->checked="checked"<!-- ENDIF --> /> {L_NO}</dd>
+ 		</dl>
+ 		<dl>
+-			<dt><label>{{ lang('TF_SHOW_ADMINS_MODS') }}</label><br />{{ lang('TF_SHOW_ADMINS_MODS_EXPLAIN') }}</dt>
+-			<dd><input type="radio" class="radio" name="top_five_show_admins_mods" value="1" {% if SHOW_ADMINS_MODS %}checked="checked"{% endif %}/> {{ lang('YES') }} &nbsp;
+-				<input type="radio" class="radio" name="top_five_show_admins_mods" value="0" {% if not SHOW_ADMINS_MODS %}checked="checked"{% endif %} /> {{ lang('NO') }}</dd>
++			<dt><label id="top_five_show_admins_mods" for="top_five_show_admins_mods">{L_TF_SHOW_ADMINS_MODS}</label><br />{L_TF_SHOW_ADMINS_MODS_EXPLAIN}</dt>
++			<dd><input type="radio" class="radio" name="top_five_show_admins_mods" value="1" <!-- IF SHOW_ADMINS_MODS -->checked="checked"<!-- ENDIF -->/> {L_YES} &nbsp;
++				<input type="radio" class="radio" name="top_five_show_admins_mods" value="0" <!-- IF not SHOW_ADMINS_MODS -->checked="checked"<!-- ENDIF --> /> {L_NO}</dd>
+ 		</dl>
+ 		<p class="submit-buttons">
+-			<input class="button1" type="submit" id="submit" name="submit" value="{{ lang('SUBMIT') }}" />&nbsp;
+-			<input class="button2" type="reset" id="reset" name="reset" value="{{ lang('RESET') }}" />
+-		{{ S_FORM_TOKEN }}
++			<input class="button1" type="submit" id="submit" name="submit" value="{L_SUBMIT}" />&nbsp;
++			<input class="button2" type="reset" id="reset" name="reset" value="{L_RESET}" />
++		{S_FORM_TOKEN}
+ 		</p>
+ 	</fieldset>
+ </form>
+-{% INCLUDE 'overall_footer.html' %}
++<!-- INCLUDE overall_footer.html -->
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/adm/style/event/acp_ext_details_end.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/adm/style/event/acp_ext_details_end.html"
+deleted file mode 100644
+index 5a3267046..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/adm/style/event/acp_ext_details_end.html"
++++ /dev/null
+@@ -1,9 +0,0 @@
+-{% if S_BUY_ME_A_BEER_TOPFIVE %}
+-	<fieldset>
+-		<legend>{{ lang('BUY_ME_A_BEER') }}</legend>
+-		<dl>
+-			<dt><label>{{ lang('BUY_ME_A_BEER_SHORT') }}{{ lang('COLON') }}</label><br /><span>{{ lang('BUY_ME_A_BEER_EXPLAIN') }}</span></dt>
+-			<dd><a href="{{ lang('BUY_ME_A_BEER_URL') }}" target="_blank" rel="noreferrer noopener"><img src="{{ lang('PAYPAL_IMAGE_URL') }}" border="0" alt="{{ lang('PAYPAL_ALT') }}" style="cursor:pointer;margin-top:15px;"></a></dd>
+-		</dl>
+-	</fieldset>
+-{% endif %}
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\topfive/composer.json"
+index 531076584..ac1d70338 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/composer.json"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\topfive/composer.json"
+@@ -1,38 +1,36 @@
+ {
+     "name": "rmcgirr83/topfive",
+     "type": "phpbb-extension",
+-    "description": "Displays statistics of the latest new posts, new users and most active users on the forum index page.",
++    "description": "Displays statistics of the latest new posts, new users and most active users on the boards index page.",
+     "homepage": "https://github.com/RMcGirr83/topfive",
+-    "version": "1.2.8",
+-    "time": "2024-10-26",
++    "version": "1.0.2",
++    "time": "2015-05-28",
+     "keywords": [
+         "phpbb",
+         "extension",
+         "top five"
+     ],
+-    "license": "GPL-2.0-only",
++    "license": "GPL-2.0",
+     "authors": [
+         {
+             "name": "Rich McGirr",
+-            "homepage": "https://paypal.me/rmcgirr83",
++            "homepage": "https://www.phpbb.com/customise/db/author/rmcgirr83/contributions",
++            "email": "rmcgirr83@rmcgirr83.org",
+             "role": "Lead Developer"
+         }
+     ],
+     "require": {
+-        "php": ">=7.4",
+-        "phpbb/phpbb": ">=3.3",
+-        "composer/installers": "~1.0.0"
++        "php": ">=5.3.3"
+     },
+     "extra": {
+-        "display-name": "Top Five Extension",
++        "display-name": "Top Five",
+         "soft-require": {
+-            "phpbb/phpbb": ">=3.3"
++            "phpbb/phpbb": ">=3.1.2,<3.2.*@dev"
+         },
+         "version-check": {
+             "host": "www.phpbb.com",
+             "directory": "/customise/db/extension/topfiveext",
+-            "filename": "version_check",
+-            "ssl": true
++            "filename": "version_check"
+         }
+     }
+ }
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/config/services.yml" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\topfive/config/services.yml"
+index c499f0988..7654a7bd9 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/config/services.yml"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\topfive/config/services.yml"
+@@ -1,20 +1,5 @@
+-imports:
+-    - { resource: topfive_constants.yml }
+-
+ services:
+-    rmcgirr83.topfive.admin.controller:
+-        class: rmcgirr83\topfive\controller\admin_controller
+-        arguments:
+-            - '@cache'
+-            - '@config'
+-            - '@language'
+-            - '@request'
+-            - '@template'
+-            - '%core.root_path%'
+-            - '%core.php_ext%'
+-            - '%topfive_constants%'
+-
+-    rmcgirr83.topfive.topfive:
++    rmcgirr83.topfive.functions:
+         class: rmcgirr83\topfive\core\topfive
+         arguments:
+             - '@auth'
+@@ -23,25 +8,17 @@ services:
+             - '@content.visibility'
+             - '@dbal.conn'
+             - '@dispatcher'
+-            - '@language'
+             - '@template'
+             - '@user'
+             - '%core.root_path%'
+             - '%core.php_ext%'
+-            - '@?senky.relativedates.listener'
+-            - '@?rmcgirr83.nationalflags.nationalflags'
+ 
+     rmcgirr83.topfive.listener:
+         class: rmcgirr83\topfive\event\listener
+         arguments:
+-            - '@rmcgirr83.topfive.topfive'
++            - '@rmcgirr83.topfive.functions'
+             - '@config'
+-            - '@language'
+             - '@template'
+             - '@user'
+-            - '@controller.helper'
+-            - '%core.php_ext%'
+-            - '%topfive_constants%'
+-            - '@?phpbb.collapsiblecategories.operator'
+         tags:
+             - { name: event.listener }
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/config/topfive_constants.yml" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/config/topfive_constants.yml"
+deleted file mode 100644
+index b60ea6065..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/config/topfive_constants.yml"
++++ /dev/null
+@@ -1,6 +0,0 @@
+-parameters:
+-    topfive_constants:
+-        top_of_index: 0
+-        bottom_of_index: 1
+-        top_of_entire_forum: 2
+-        bottom_of_entire_forum: 3
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/controller/admin_controller.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/controller/admin_controller.php"
+deleted file mode 100644
+index 40a3df971..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/controller/admin_controller.php"
++++ /dev/null
+@@ -1,190 +0,0 @@
+-<?php
+-/**
+-*
+-* Top Five extension for the phpBB Forum Software package.
+-*
+-* @copyright 2016 Rich McGirr (RMcGirr83)
+-* @license GNU General Public License, version 2 (GPL-2.0)
+-*
+-*/
+-
+-namespace rmcgirr83\topfive\controller;
+-
+-use phpbb\cache\service as cache;
+-use phpbb\config\config;
+-use phpbb\language\language;
+-use phpbb\request\request;
+-use phpbb\template\template;
+-
+-class admin_controller
+-{
+-	/** @var cache */
+-	protected $cache;
+-
+-	/** @var config */
+-	protected $config;
+-
+-	/** @var language */
+-	protected $language;
+-
+-	/** @var request */
+-	protected $request;
+-
+-	/** @var template */
+-	protected $template;
+-
+-	/** @var string phpBB root path */
+-	protected $root_path;
+-
+-	/** @var string phpEx */
+-	protected $php_ext;
+-
+-	/* @var array topfive_constants */
+-	protected $topfive_constants;
+-
+-	/** @var string Custom form action */
+-	protected $u_action;
+-
+-	/**
+-	* Constructor
+-	*
+-	* @param cache						$cache				Cache object
+-	* @param config						$config				Config object
+-	* @param language					$language			Language object
+-	* @param request					$request			Request object
+-	* @param template					$template			Template object
+-	* @param string						$root_path			phpBB root path
+-	* @param string						$php_ext			phpEx
+-	* @param array						$topfive_constants	Constants for the extension
+-	* @access public
+-	*/
+-	public function __construct(
+-			cache $cache,
+-			config $config,
+-			language $language,
+-			request $request,
+-			template $template,
+-			string $root_path,
+-			string $php_ext,
+-			array $topfive_constants)
+-	{
+-		$this->cache = $cache;
+-		$this->config = $config;
+-		$this->language = $language;
+-		$this->request = $request;
+-		$this->template = $template;
+-		$this->root_path = $root_path;
+-		$this->php_ext = $php_ext;
+-		$this->topfive_constants = $topfive_constants;
+-	}
+-
+-	public function display_options()
+-	{
+-		$this->language->add_lang('acp_topfive', 'rmcgirr83/topfive');
+-
+-		// Create a form key for preventing CSRF attacks
+-		add_form_key('acp_topfive');
+-
+-		// get the excluded forums
+-		$excluded_forums = explode(',', $this->config['top_five_excluded']);
+-
+-		if ($this->request->is_set_post('submit'))
+-		{
+-			if (!check_form_key('acp_topfive'))
+-			{
+-				trigger_error('FORM_INVALID');
+-			}
+-			if (!function_exists('validate_data'))
+-			{
+-				include($this->root_path . 'includes/functions_user.' . $this->php_ext);
+-			}
+-
+-			$check_row = array('top_five_how_many' => $this->request->variable('top_five_how_many', 0));
+-			$validate_row = array('top_five_how_many' => array('num', false, 5, 100));
+-			$error = validate_data($check_row, $validate_row);
+-			// Replace "error" strings with their real, localised form
+-			$error = array_map(array($this->language, 'lang'), $error);
+-
+-			if (!sizeof($error))
+-			{
+-				$this->set_options();
+-
+-				$this->cache->destroy('_top_five_newest_users');
+-				$this->cache->destroy('_top_five_posters');
+-
+-				trigger_error($this->language->lang('TF_SAVED') . adm_back_link($this->u_action));
+-			}
+-		}
+-
+-		$this->template->assign_vars(array(
+-			'TF_ERROR'			=> isset($error) ? ((sizeof($error)) ? implode('<br />', $error) : '') : '',
+-			'HOWMANY'			=> isset($this->config['top_five_how_many']) ? $this->config['top_five_how_many'] : 0,
+-			'IGNORE_INACTIVE'	=> isset($this->config['top_five_ignore_inactive_users']) ? $this->config['top_five_ignore_inactive_users'] : false,
+-			'IGNORE_FOUNDER'	=> isset($this->config['top_five_ignore_founder']) ? $this->config['top_five_ignore_founder'] : false,
+-			'SHOW_ADMINS_MODS'	=> isset($this->config['top_five_show_admins_mods']) ? $this->config['top_five_show_admins_mods'] : false,
+-			'LOCATION'			=> $this->location($this->config['top_five_location']),
+-			'ACTIVE'			=> isset($this->config['top_five_active']) ? $this->config['top_five_active'] : false,
+-			'TF_EXCLUDED'		=> $this->forum_select($excluded_forums),
+-			'AVATARS'		=> isset($this->config['top_five_avatars']) ? $this->config['top_five_avatars'] : false,
+-
+-			'U_ACTION'			=> $this->u_action,
+-		));
+-	}
+-
+-	protected function set_options()
+-	{
+-		$this->config->set('top_five_how_many', $this->request->variable('top_five_how_many', 0));
+-		$this->config->set('top_five_ignore_inactive_users', $this->request->variable('top_five_ignore_inactive_users', 0));
+-		$this->config->set('top_five_ignore_founder', $this->request->variable('top_five_ignore_founder', 0));
+-		$this->config->set('top_five_show_admins_mods', $this->request->variable('top_five_show_admins_mods', 0));
+-		$this->config->set('top_five_location', $this->request->variable('top_five_location', 0));
+-		$this->config->set('top_five_active', $this->request->variable('top_five_active', 0));
+-
+-		// variable should be '' as it is a string ("1, 2, 3928") here, not an integer.
+-		$forums = $this->request->variable('selectForms',  array(''));
+-		// change the array to a string
+-		$forums  = implode(',', $forums);
+-		$this->config->set('top_five_excluded', $forums);
+-		$this->config->set('top_five_avatars', $this->request->variable('top_five_avatars',0));
+-	}
+-
+-	/**
+-	 * Display a drop down of all forums for selection
+-	 *
+-	 * @return drop down select
+-	 * @access protected
+-	 */
+-	private function forum_select($value)
+-	{
+-		return '<select id="top_five_excluded" name="selectForms[]" multiple="multiple">' . make_forum_select($value, false, true, true) . '</select>';
+-	}
+-
+-	/**
+-	 * Create the selection for the post method
+-	 */
+-	public function location($location = 0)
+-	{
+-		// location options
+-		$location_text = [$this->topfive_constants['top_of_index'] => $this->language->lang('TOP_OF_FORUM'), $this->topfive_constants['bottom_of_index'] => $this->language->lang('BOTTOM_OF_FORUM'), $this->topfive_constants['top_of_entire_forum'] => $this->language->lang('TOP_OF_ENTIRE_FORUM'), $this->topfive_constants['bottom_of_entire_forum'] => $this->language->lang('BOTTOM_OF_ENTIRE_FORUM')];
+-		$location_options = '';
+-		foreach ($location_text as $value => $text)
+-		{
+-			$selected = ($value == $location) ? ' selected="selected"' : '';
+-			$location_options .= "<option value='{$value}'$selected>$text</option>";
+-		}
+-
+-		return $location_options;
+-	}
+-
+-	/**
+-	 * Set page url
+-	 *
+-	 * @param string $u_action Custom form action
+-	 * @return null
+-	 * @access public
+-	 */
+-	public function set_page_url($u_action)
+-	{
+-		$this->u_action = $u_action;
+-	}
+-}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/core/topfive.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\topfive/core/topfive.php"
+index 4facdbedc..3d9f9352e 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/core/topfive.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\topfive/core/topfive.php"
+@@ -11,65 +11,39 @@
+ 
+ namespace rmcgirr83\topfive\core;
+ 
+-use phpbb\auth\auth;
+-use phpbb\config\config;
+-use phpbb\cache\service as cache_service;
+-use phpbb\content_visibility;
+-use phpbb\db\driver\driver_interface;
+-use phpbb\event\dispatcher_interface;
+-use phpbb\language\language;
+-use phpbb\template\template;
+-use phpbb\user;
+-
+ class topfive
+ {
+-	/** @var auth */
++	/** @var \phpbb\auth\auth */
+ 	protected $auth;
+ 
+-	/** @var config */
++	/** @var \phpbb\config\config */
+ 	protected $config;
+ 
+-	/** @var cache */
++	/** @var \phpbb\cache\driver\driver_interface */
+ 	protected $cache;
+ 
+-	/** @var content_visibility */
++	/** @var \phpbb\content_visibility */
+ 	protected $content_visibility;
+ 
+-	/** @var db */
++	/** @var \phpbb\db\driver\driver_interface */
+ 	protected $db;
+ 
+-	/** @var dispatcher */
++	/** @var \phpbb\event\dispatcher_interface */
+ 	protected $dispatcher;
+ 
+-	/** @var language */
+-	protected $language;
+-
+-	/** @var template */
++	/** @var \phpbb\template\template */
+ 	protected $template;
+ 
+-	/** @var user */
++	/** @var \phpbb\user */
+ 	protected $user;
+ 
+-	/** @var string phpbb_root_path */
++	/** @var string phpBB root path */
+ 	protected $phpbb_root_path;
+ 
+-	/** @var string php_ext */
++	/** @var string PHP extension */
+ 	protected $php_ext;
+ 
+-	public function __construct(
+-		auth $auth,
+-		config $config,
+-		cache_service $cache,
+-		content_visibility $content_visibility,
+-		driver_interface $db,
+-		dispatcher_interface $dispatcher,
+-		language $language,
+-		template $template,
+-		user $user,
+-		string $phpbb_root_path,
+-		string $php_ext,
+-		\senky\relativedates\event\listener $relativedates = null,
+-		\rmcgirr83\nationalflags\core\nationalflags $nationalflags= null)
++	public function __construct(\phpbb\auth\auth $auth, \phpbb\config\config $config, \phpbb\cache\service $cache, \phpbb\content_visibility $content_visibility, \phpbb\db\driver\driver_interface $db, \phpbb\event\dispatcher_interface $dispatcher, \phpbb\template\template $template, \phpbb\user $user, $phpbb_root_path, $php_ext)
+ 	{
+ 		$this->auth = $auth;
+ 		$this->config = $config;
+@@ -77,27 +51,18 @@ class topfive
+ 		$this->content_visibility = $content_visibility;
+ 		$this->db = $db;
+ 		$this->dispatcher = $dispatcher;
+-		$this->language = $language;
+ 		$this->template = $template;
+ 		$this->user = $user;
+ 		$this->root_path = $phpbb_root_path;
+ 		$this->php_ext = $php_ext;
+-		$this->relativedates = $relativedates;
+-		$this->nationalflags = $nationalflags;
+ 	}
+ 
+-	/**
+-	* Display activity
+-	*
+-	* @param	string	$tpl_loopname	Name of the html file
+-	* @return 	null
+-	* @access 	public
+-	*/
+ 	public function toptopics($tpl_loopname = 'top_five_topic')
+ 	{
++
+ 		$howmany = $this->howmany();
+ 
+-		$forum_ary = [];
++		$forum_ary = array();
+ 		$forum_read_ary = $this->auth->acl_getf('f_read');
+ 
+ 		foreach ($forum_read_ary as $forum_id => $allowed)
+@@ -109,220 +74,184 @@ class topfive
+ 		}
+ 		$forum_ary = array_unique($forum_ary);
+ 
+-		// want to exclude some forums
+-		$excluded_forums = explode(',', $this->config['top_five_excluded']);
+-
+-		// now remove those topics from the display per the excluded forums array
+-		$forum_ary = array_diff($forum_ary, $excluded_forums);
+-
+-		if (!sizeof($forum_ary))
++		if (sizeof($forum_ary))
+ 		{
+-			$this->template->assign_block_vars($tpl_loopname, [
+-				'NO_TOPIC_TITLE'	=> $this->language->lang('NO_TOPIC_EXIST'),
+-			]);
+-
+-			return false;
+-		}
+-
+-		/**
+-		* Select topic_ids
+-		*/
+-		// grab all posts that meet criteria and auths
+-		$sql_array = [
+-			'SELECT'	=> 't.forum_id, t.topic_id, t.topic_type',
+-			'FROM'		=> [TOPICS_TABLE => 't'],
+-			'WHERE'		=> $this->content_visibility->get_forums_visibility_sql('topic', $forum_ary) . ' AND topic_status <> ' . ITEM_MOVED,
+-			'ORDER_BY'	=> 't.topic_last_post_time DESC',
+-		];
+-
+-		$result = $this->db->sql_query_limit($this->db->sql_build_query('SELECT', $sql_array), $howmany);
+-
+-		$forums = $ga_topic_ids = $topic_ids = [];
+-		while ($row = $this->db->sql_fetchrow($result))
+-		{
+-			$topic_ids[] = $row['topic_id'];
+-			if ($row['topic_type'] == POST_GLOBAL)
++			/**
++			* Select topic_ids
++			*/
++			$sql = 'SELECT forum_id, topic_id, topic_type
++				FROM ' . TOPICS_TABLE . '
++				WHERE ' . $this->content_visibility->get_forums_visibility_sql('topic', $forum_ary) . '
++				AND topic_status <> ' . ITEM_MOVED . '
++				ORDER BY topic_last_post_time DESC';
++
++			$result = $this->db->sql_query_limit($sql, $howmany);
++			$forums = $ga_topic_ids = $topic_ids = array();
++			while ($row = $this->db->sql_fetchrow($result))
+ 			{
+-				$ga_topic_ids[] = $row['topic_id'];
++				$topic_ids[] = $row['topic_id'];
++				if ($row['topic_type'] == POST_GLOBAL)
++				{
++					$ga_topic_ids[] = $row['topic_id'];
++				}
++				else
++				{
++					$forums[$row['forum_id']][] = $row['topic_id'];
++				}
+ 			}
+-			else
++			$this->db->sql_freeresult($result);
++
++			// Get topic tracking
++			$topic_tracking_info = array();
++			foreach ($forums as $forum_id => $topic_id)
+ 			{
+-				$forums[$row['forum_id']][] = $row['topic_id'];
++				$topic_tracking_info[$forum_id] = get_complete_topic_tracking($forum_id, $topic_id, $ga_topic_ids);
+ 			}
+-		}
+-		$this->db->sql_freeresult($result);
+ 
+-		// Get topic tracking
+-		$topic_tracking_info = [];
+-		foreach ($forums as $forum_id => $topic_id)
+-		{
+-			$topic_tracking_info[$forum_id] = get_complete_topic_tracking($forum_id, $topic_id, $ga_topic_ids);
+-		}
+-
+-		/*
+-		* must have topic_ids.
+-		* A user can have forums and not have topic_ids before installing this extension
+-		*/
+-		if (!sizeof($topic_ids))
+-		{
+-			$this->template->assign_block_vars($tpl_loopname, [
+-				'NO_TOPIC_TITLE'	=> $this->language->lang('NO_TOPIC_EXIST'),
+-			]);
+-
+-			return false;
+-		}
+-
+-		// grab all posts that meet criteria and auths
+-		$sql_array = [
+-			'SELECT'	=> 'u.user_id, u.username, u.user_colour, u.user_avatar, u.user_avatar_type, u.user_avatar_height, u.user_avatar_width, t.topic_title, t.forum_id, t.topic_id, t.topic_first_post_id, t.topic_last_post_id, t.topic_last_post_time, t.topic_last_poster_name, f.forum_name',
+-			'FROM'		=> [TOPICS_TABLE => 't'],
+-			'LEFT_JOIN'	=> [
+-				[
+-					'FROM'	=> [USERS_TABLE => 'u'],
+-					'ON'	=> 't.topic_last_poster_id = u.user_id',
+-				],
+-				[
+-					'FROM'	=> [FORUMS_TABLE => 'f'],
+-					'ON'	=> 't.forum_id = f.forum_id',
+-				],
+-			],
+-			'WHERE'		=> $this->db->sql_in_set('t.topic_id', $topic_ids),
+-			'ORDER_BY'	=> 't.topic_last_post_time DESC',
+-		];
+-		if ($this->nationalflags !== null)
+-		{
+-			$sql_array['SELECT'].= ', u.user_flag';
+-		}
+-
+-		/**
+-		* Event to modify the SQL query before the topics data is retrieved
+-		*
+-		* @event rmcgirr83.topfive.sql_pull_topics_data
+-		* @var	array	sql_array		The SQL array
+-		* @since 1.0.0
+-		*/
+-		$vars = ['sql_array'];
+-		extract($this->dispatcher->trigger_event('rmcgirr83.topfive.sql_pull_topics_data', compact($vars)));
+-
+-		$result = $this->db->sql_query_limit($this->db->sql_build_query('SELECT', $sql_array), $howmany);
+-
+-		while ($row = $this->db->sql_fetchrow($result))
+-		{
+-			$topic_id = $row['topic_id'];
+-			$forum_id = $row['forum_id'];
+-			$forum_name = $row['forum_name'];
+-
+-			$post_unread = (isset($topic_tracking_info[$forum_id][$topic_id]) && $row['topic_last_post_time'] > $topic_tracking_info[$forum_id][$topic_id]) ? true : false;
+-			$view_topic_url = !empty($post_unread) ? append_sid("{$this->root_path}viewtopic.$this->php_ext", 't=' . $topic_id . '&amp;view=unread') . '#unread' : append_sid("{$this->root_path}viewtopic.$this->php_ext", 't=' . $topic_id);
+-			/** To go to the last post in a topic use the below as the last argument in the above $view_topic_url variable
+-			append_sid("{$this->root_path}viewtopic.$this->php_ext", 'f=' . $row['forum_id'] . '&amp;p=' . $row['topic_last_post_id'] . '#p' . $row['topic_last_post_id'])
+-			**/
+-			$forum_name_url = append_sid("{$this->root_path}viewforum.$this->php_ext", 'f=' . $row['forum_id']);
+-			$topic_title = censor_text($row['topic_title']);
+-			$topic_title = truncate_string($topic_title, 60, 255, false, $this->language->lang('ELLIPSIS'));
+-
+-			$is_guest = ($row['user_id'] == ANONYMOUS) ? true : false;
+-
+-			$user_avatar = phpbb_get_user_avatar($row);
+-			$display_avatar = (!empty($this->config['top_five_avatars']) && $this->user->optionget('viewavatars') && !empty($user_avatar)) ? true : false;
+-
+-			$user_avatar = $display_avatar ? '<span class="topfive-avatar">' . $user_avatar . '</span>&nbsp;' : '';
+-
+-			// relativedates installed?
+-			if ($this->relativedates !== null)
++			/*
++			* must have topic_ids.
++			* A user can have forums and not have topic_ids before installing this extension
++			*/
++			if (sizeof($topic_ids))
+ 			{
+-				$last_topic_time = $this->user->format_date($row['topic_last_post_time'], false, false, false);
++				// grab all posts that meet criteria and auths
++				$sql_array = array(
++					'SELECT'	=> 'u.user_id, u.username, u.user_colour, u.user_avatar, u.user_avatar_type, u.user_avatar_width, u.user_avatar_height, t.topic_title, t.forum_id, t.topic_id, t.topic_first_post_id, t.topic_last_post_id, t.topic_last_post_time, t.topic_last_poster_name, f.forum_name',
++					'FROM'		=> array(TOPICS_TABLE => 't'),
++					'LEFT_JOIN'	=> array(
++						array(
++							'FROM'	=> array(USERS_TABLE => 'u'),
++							'ON'	=> 't.topic_last_poster_id = u.user_id',
++						),
++						array(
++							'FROM'	=> array(FORUMS_TABLE => 'f'),
++							'ON'	=> 't.forum_id = f.forum_id',
++						),
++					),
++					'WHERE'		=> $this->db->sql_in_set('t.topic_id', $topic_ids),
++					'ORDER_BY'	=> 't.topic_last_post_time DESC',
++				);
++				/**
++				* Event to modify the SQL query before the topics data is retrieved
++				*
++				* @event rmcgirr83.topfive.sql_pull_topics_data
++				* @var	array	sql_array		The SQL array
++				* @since 1.0.0
++				*/
++				$vars = array('sql_array');
++				extract($this->dispatcher->trigger_event('rmcgirr83.topfive.sql_pull_topics_data', compact($vars)));
++
++				// cache the query for one minute
++				$result = $this->db->sql_query_limit($this->db->sql_build_query('SELECT', $sql_array), $howmany, 0, 60);
++
++				while ($row = $this->db->sql_fetchrow($result))
++				{
++					$topic_id = $row['topic_id'];
++					$forum_id = $row['forum_id'];
++					$forum_name = $row['forum_name'];
++
++					$post_unread = (isset($topic_tracking_info[$forum_id][$topic_id]) && $row['topic_last_post_time'] > $topic_tracking_info[$forum_id][$topic_id]) ? true : false;
++					$view_topic_url = append_sid("{$this->phpbb_root_path}viewtopic.$this->php_ext", 'f=' . $row['forum_id'] . '&amp;p=' . $row['topic_last_post_id'] . '#p' . $row['topic_last_post_id']);
++					$forum_name_url = append_sid("{$this->phpbb_root_path}viewforum.$this->php_ext", 'f=' . $row['forum_id']);
++					$topic_title = censor_text($row['topic_title']);
++					if (utf8_strlen($topic_title) >= 60)
++					{
++						$topic_title = (utf8_strlen($topic_title) > 60 + 3) ? utf8_substr($topic_title, 0, 60) . '...' : $topic_title;
++					}
++					$is_guest = ($row['user_id'] == ANONYMOUS) ? true : false;
++                    $user_avatar = ($row['user_avatar']) ? get_user_avatar($row['user_avatar'], $row['user_avatar_type'], 50, 50) : '<img src="' . generate_board_url() . '/styles/' . '/FLATBOOTS/' . '/theme/images/no_avatar.gif" height="50" width="50" alt="Default Avatar" />';
++					
++					$tpl_ary = array(
++						'U_TOPIC'			=> $view_topic_url,
++						'U_FORUM'			=> $forum_name_url,
++						'TOP5_AVATAR' 	    => $user_avatar,
++						'S_UNREAD'			=> ($post_unread) ? true : false,
++						'USERNAME_FULL'		=> ($is_guest || !$this->auth->acl_get('u_viewprofile')) ? $this->user->lang['POST_BY_AUTHOR'] . ' ' . get_username_string('no_profile', $row['user_id'], $row['username'], $row['user_colour'], $row['topic_last_poster_name']) : $this->user->lang['POST_BY_AUTHOR'] . ' ' . get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']),
++						'LAST_TOPIC_TIME'	=> $this->user->format_date($row['topic_last_post_time']),
++						'TOPIC_TITLE' 		=> $topic_title,
++						'FORUM_NAME'		=> $forum_name,
++					);
++					/**
++					* Modify the topic data before it is assigned to the template
++					*
++					* @event rmcgirr83.topfive.modify_tpl_ary
++					* @var	array	row			Array with topic data
++					* @var	array	tpl_ary		Template block array with topic data
++					* @since 1.0.0
++					*/
++					$vars = array('row', 'tpl_ary');
++					extract($this->dispatcher->trigger_event('rmcgirr83.topfive.modify_tpl_ary', compact($vars)));
++
++					$this->template->assign_block_vars($tpl_loopname, $tpl_ary);
++				}
++				$this->db->sql_freeresult($result);
+ 			}
+ 			else
+ 			{
+-				$last_topic_time = $this->user->format_date($row['topic_last_post_time']);
++				$this->template->assign_block_vars($tpl_loopname, array(
++					'NO_TOPIC_TITLE'	=> $this->user->lang['NO_TOPIC_EXIST'],
++				));
+ 			}
+-
+-			$user_flag = '';
+-			// nationalflags installed?
+-			if (!empty($row['user_flag']))
+-			{
+-				$user_flag = $this->nationalflags->get_user_flag($row['user_flag'], 12);
+-			}
+-
+-			$tpl_ary = [
+-				'U_TOPIC'	=> $view_topic_url,
+-				'U_FORUM'	=> $forum_name_url,
+-				'S_UNREAD'	=> ($post_unread) ? true : false,
+-				'USERNAME_FULL'	=> ($is_guest || !$this->auth->acl_get('u_viewprofile')) ? $this->language->lang('BY') . $user_avatar . get_username_string('no_profile', $row['user_id'], $row['username'], $row['user_colour'], $row['topic_last_poster_name']) : $this->language->lang('BY') . $user_avatar . get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']),
+-				'LAST_TOPIC_TIME'	=> $last_topic_time,
+-				'TOPIC_TITLE'	=> $topic_title,
+-				'FORUM_NAME'	=> $forum_name,
+-				'USER_FLAG'	=> !empty($user_flag) ? $user_flag : '',
+-			];
+-
+-			/**
+-			* Modify the topic data before it is assigned to the template
+-			*
+-			* @event rmcgirr83.topfive.modify_tpl_ary
+-			* @var	array	row			Array with topic data
+-			* @var	array	tpl_ary		Template block array with topic data
+-			* @since 1.0.0
+-			*/
+-			$vars = ['row', 'tpl_ary'];
+-			extract($this->dispatcher->trigger_event('rmcgirr83.topfive.modify_tpl_ary', compact($vars)));
+-
+-			$this->template->assign_block_vars($tpl_loopname, $tpl_ary);
+ 		}
+-		$this->db->sql_freeresult($result);
++		else
++		{
++			$this->template->assign_block_vars($tpl_loopname, array(
++				'NO_TOPIC_TITLE'	=> $this->user->lang['NO_TOPIC_EXIST'],
++			));
++		}
+ 	}
+ 
+-	/**
+-	* Get the top posters
+-	*
+-	* @return 	null
+-	* @access 	public
+-	*/
+ 	public function topposters()
+ 	{
+ 		$howmany = $this->howmany();
+ 		$sql_where = $this->ignore_users();
+ 
++		//set two variables for the sql
++		$sql_and = $sql_other = '';
++
+ 		if (($user_posts = $this->cache->get('_top_five_posters')) === false)
+ 		{
+-			$user_posts = [];
+ 
+-			$sql_where .= empty($sql_where) ? 'u.user_posts <> 0' : ' AND u.user_posts <> 0';
++			$user_posts = $admin_mod_array = array();
++			// quick check for forum moderators and administrators
++			// some may not want to show them
++			$show_admins_mods = $this->config['top_five_show_admins_mods'];
+ 
+-			// do the main sql query
+-			$sql_array = [
+-				'SELECT' => 'u.user_id, u.username, u.user_colour, u.user_posts, u.user_avatar, u.user_avatar_width, u.user_avatar_height, u.user_avatar_type, u.user_lastpost_time',
+-				'FROM' => [USERS_TABLE => 'u'],
+-				'WHERE' => $sql_where,
+-				'ORDER_BY' => 'u.user_lastpost_time DESC, u.user_posts DESC',
+-			];
+-
+-			if ($this->nationalflags !== null)
++			if (!$show_admins_mods)
+ 			{
+-				$sql_array['SELECT'] .= ', u.user_flag';
++				// grab all admins
++				$admin_ary = $this->auth->acl_get_list(false, 'a_', false);
++				$admin_ary = (!empty($admin_ary[0]['a_'])) ? $admin_ary[0]['a_'] : array();
++
++				//grab all mods
++				$mod_ary = $this->auth->acl_get_list(false,'m_', false);
++				$mod_ary = (!empty($mod_ary[0]['m_'])) ? $mod_ary[0]['m_'] : array();
++				$admin_mod_array = array_unique(array_merge($admin_ary, $mod_ary));
++				if (sizeof($admin_mod_array))
++				{
++					$sql_and = empty($sql_where) ? ' WHERE' : ' AND';
++					$sql_and .= ' ' . $this->db->sql_in_set('user_id', $admin_mod_array, true);
++				}
+ 			}
+-			$result = $this->db->sql_query_limit($this->db->sql_build_query('SELECT', $sql_array), $howmany);
++			$sql_other = (empty($sql_and) && empty($sql_where)) ? ' WHERE' : ' AND';
++			$sql_other .=  ' user_posts <> 0';
+ 
++			// do the main sql query
++			$sql = 'SELECT user_id, username, user_colour, user_posts
++				FROM ' . USERS_TABLE . '
++				 ' . $sql_where . ' ' . $sql_and . '
++				' . $sql_other . '
++				ORDER BY user_posts DESC';
++
++			$result = $this->db->sql_query_limit($sql, $howmany);
+ 			while ($row = $this->db->sql_fetchrow($result))
+ 			{
+-				$user_flag = '';
+-				// nationalflags installed?
+-				if (!empty($row['user_flag']))
+-				{
+-					$user_flag = $this->nationalflags->get_user_flag($row['user_flag'], 12);
+-				}
+-				$user_posts[$row['user_id']] = [
++				$user_posts[$row['user_id']] = array(
+ 					'user_id'      => $row['user_id'],
+ 					'username'      => $row['username'],
+ 					'user_colour'   => $row['user_colour'],
+ 					'user_posts'    => $row['user_posts'],
+-					'user_avatar'	=> $row['user_avatar'],
+-					'user_avatar_width'	=> $row['user_avatar_width'],
+-					'user_avatar_height'	=> $row['user_avatar_height'],
+-					'user_avatar_type'	=> $row['user_avatar_type'],
+-					'user_lastpost_time'	=> $row['user_lastpost_time'],
+-					'user_flag'	=> !empty($user_flag) ? $user_flag : '',
+-				];
++				);
+ 			}
+ 			$this->db->sql_freeresult($result);
+ 
+@@ -332,81 +261,44 @@ class topfive
+ 
+ 		foreach ($user_posts as $row)
+ 		{
+-			$user_avatar = phpbb_get_user_avatar($row);
+-			$display_avatar = (!empty($this->config['top_five_avatars']) && $this->user->optionget('viewavatars') && !empty($user_avatar)) ? true : false;
+-
+-			$user_avatar = $display_avatar ? '<span class="topfive-avatar">' . $user_avatar . '</span>&nbsp;' : '';
++			$username_string = ($this->auth->acl_get('u_viewprofile')) ? get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']) : get_username_string('no_profile', $row['user_id'], $row['username'], $row['user_colour']);
+ 
+-			$username_string = ($this->auth->acl_get('u_viewprofile')) ? $user_avatar . get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']) : $user_avatar . get_username_string('no_profile', $row['user_id'], $row['username'], $row['user_colour']);
+-			if ($this->relativedates !== null)
+-			{
+-				$user_lastpost_time = $this->user->format_date($row['user_lastpost_time'], false, false, false);
+-			}
+-			else
+-			{
+-				$user_lastpost_time = $this->user->format_date($row['user_lastpost_time']);
+-			}
+-
+-			$this->template->assign_block_vars('top_five_active',[
+-				'S_SEARCH_ACTION'	=> append_sid("{$this->root_path}search.$this->php_ext", 'author_id=' . $row['user_id'] . '&amp;sr=posts'),
+-				'POSTS'	=> number_format($row['user_posts']),
+-				'USERNAME_FULL'	=> $username_string,
+-				'USER_LASTPOST_TIME'	=> $this->language->lang('USER_LASTPOST_TIME', $user_lastpost_time),
+-				'USER_FLAG'	=> !empty($row['user_flag']) ? $row['user_flag'] : '',
+-			]);
++			$this->template->assign_block_vars('top_five_active',array(
++				'S_SEARCH_ACTION'	=> append_sid("{$this->phpbb_root_path}search.$this->php_ext", 'author_id=' . $row['user_id'] . '&amp;sr=posts'),
++				'POSTS' 			=> number_format($row['user_posts']),
++				'USERNAME_FULL'		=> $username_string,
++			));
+ 		}
+ 	}
+ 
+-	/**
+-	* Get the newest members
+-	*
+-	* @return 	null
+-	* @access 	public
+-	*/
+ 	public function newusers()
+ 	{
++
+ 		$howmany = $this->howmany();
+ 		$sql_where = $this->ignore_users();
+ 
+-		$sql_where .= !empty($sql_where) ? ' AND u.user_inactive_reason = 0' : ' u.user_inactive_reason = 0';
++		$sql_and = !empty($sql_where) ? ' AND user_inactive_reason = 0' : ' WHERE user_inactive_reason = 0';
+ 		// newest registered users
+ 		if (($newest_users = $this->cache->get('_top_five_newest_users')) === false)
+ 		{
+-			$newest_users = [];
++			$newest_users = array();
+ 
+ 			// grab most recent registered users
+-			$sql_array = [
+-				'SELECT' => 'u.user_id, u.username, u.user_colour, u.user_regdate, u.user_avatar, u.user_avatar_width, u.user_avatar_height, u.user_avatar_type',
+-				'FROM' => [USERS_TABLE => 'u'],
+-				'WHERE' => $sql_where,
+-				'ORDER_BY' =>  'u.user_regdate DESC',
+-			];
+-			if ($this->nationalflags !== null)
+-			{
+-				$sql_array['SELECT'] .= ', u.user_flag';
+-			}
+-			$result = $this->db->sql_query_limit($this->db->sql_build_query('SELECT', $sql_array), $howmany);
++			$sql = 'SELECT user_id, username, user_colour, user_regdate
++				FROM ' . USERS_TABLE . '
++				' . $sql_where . '
++				' . $sql_and . '
++				ORDER BY user_regdate DESC';
++			$result = $this->db->sql_query_limit($sql, $howmany);
+ 
+ 			while ($row = $this->db->sql_fetchrow($result))
+ 			{
+-				$user_flag = '';
+-				// nationalflags installed?
+-				if (!empty($row['user_flag']))
+-				{
+-					$user_flag = $this->nationalflags->get_user_flag($row['user_flag'], 12);
+-				}
+-
+-				$newest_users[$row['user_id']] = [
++				$newest_users[$row['user_id']] = array(
+ 					'user_id'				=> $row['user_id'],
+ 					'username'				=> $row['username'],
+ 					'user_colour'			=> $row['user_colour'],
+ 					'user_regdate'			=> $row['user_regdate'],
+-					'user_avatar'			=> $row['user_avatar'],
+-					'user_avatar_width'		=> $row['user_avatar_width'],
+-					'user_avatar_height'	=> $row['user_avatar_height'],
+-					'user_avatar_type'		=> $row['user_avatar_type'],
+-					'user_flag'				=> !empty($user_flag) ? $user_flag : '',
+-				];
++				);
+ 			}
+ 			$this->db->sql_freeresult($result);
+ 
+@@ -416,27 +308,15 @@ class topfive
+ 
+ 		foreach ($newest_users as $row)
+ 		{
+-			$user_avatar = phpbb_get_user_avatar($row);
+-			$display_avatar = (!empty($this->config['top_five_avatars']) && $this->user->optionget('viewavatars') && !empty($user_avatar)) ? true : false;
+-
+-			$user_avatar = $display_avatar ? '<span class="topfive-avatar">' . $user_avatar . '</span>&nbsp;' : '';
+-
+-			$username_string = ($this->auth->acl_get('u_viewprofile')) ? $user_avatar . get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']) : $user_avatar . get_username_string('no_profile', $row['user_id'], $row['username'], $row['user_colour']);
++			$username_string = ($this->auth->acl_get('u_viewprofile')) ? get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']) : get_username_string('no_profile', $row['user_id'], $row['username'], $row['user_colour']);
+ 
+-			$this->template->assign_block_vars('top_five_newest',[
++			$this->template->assign_block_vars('top_five_newest',array(
+ 				'REG_DATE'			=> $this->user->format_date($row['user_regdate']),
+ 				'USERNAME_FULL'		=> $username_string,
+-				'USER_FLAG'			=> !empty($row['user_flag']) ? $row['user_flag'] : '',
+-			]);
++			));
+ 		}
+ 	}
+ 
+-	/**
+-	* How many to display
+-	*
+-	* @return 	int 	$howmany
+-	* @access 	private
+-	*/
+ 	private function howmany()
+ 	{
+ 		$howmany = $this->config['top_five_how_many'];
+@@ -444,24 +324,18 @@ class topfive
+ 		return (int) $howmany;
+ 	}
+ 
+-	/**
+-	* Ignore users
+-	*
+-	* @return 	string 	$sql_where
+-	* @access 	private
+-	*/
+ 	private function ignore_users()
+ 	{
+ 		// an array of user types we dont' bother with
+-		$ignore_users = $ignore_founders = [];
++		$ignore_users = $ignore_founders = array();
+ 		if ($this->config['top_five_ignore_inactive_users'])
+ 		{
+-			$ignore_users = [USER_IGNORE, USER_INACTIVE];
++			$ignore_users = array(USER_IGNORE, USER_INACTIVE);
+ 		}
+ 
+ 		if ($this->config['top_five_ignore_founder'])
+ 		{
+-			$ignore_founders = [USER_FOUNDER];
++			$ignore_founders = array(USER_FOUNDER);
+ 		}
+ 
+ 		$ignore_users = array_merge($ignore_users, $ignore_founders);
+@@ -470,28 +344,9 @@ class topfive
+ 		$sql_where = '';
+ 		if (sizeof($ignore_users))
+ 		{
+-			$sql_where = $this->db->sql_in_set('u.user_type', $ignore_users, true);
++			$sql_where = 'WHERE ' . $this->db->sql_in_set('user_type', $ignore_users, true);
+ 		}
+-		$admin_mod_array = [];
+-		// quick check for forum moderators and administrators
+-		// some may not want to show them
+-		$show_admins_mods = $this->config['top_five_show_admins_mods'];
+ 
+-		if (!$show_admins_mods)
+-		{
+-			// grab all admins
+-			$admin_ary = $this->auth->acl_get_list(false, 'a_', false);
+-			$admin_ary = (!empty($admin_ary[0]['a_'])) ? $admin_ary[0]['a_'] : [];
+-
+-			//grab all mods
+-			$mod_ary = $this->auth->acl_get_list(false,'m_', false);
+-			$mod_ary = (!empty($mod_ary[0]['m_'])) ? $mod_ary[0]['m_'] : [];
+-			$admin_mod_array = array_unique(array_merge($admin_ary, $mod_ary));
+-			if (sizeof($admin_mod_array))
+-			{
+-				$sql_where .= empty($sql_where) ? $this->db->sql_in_set('u.user_id', $admin_mod_array, true) : ' AND ' . $this->db->sql_in_set('u.user_id', $admin_mod_array, true);
+-			}
+-		}
+ 		return $sql_where;
+ 	}
+ }
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\topfive/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\topfive/diff_full.tmp"
+new file mode 100644
+index 000000000..7131d19bf
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\topfive/diff_full.tmp"
+@@ -0,0 +1,1183 @@
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/acp/topfive_info.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\topfive/acp/topfive_info.php"
++index 591b4fa8f..c0f748d31 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/acp/topfive_info.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\topfive/acp/topfive_info.php"
++@@ -19,9 +19,9 @@ class topfive_info
++ 		return array(
++ 			'filename'	=> '\rmcgirr83\topfive\acp\topfive_module',
++ 			'title'		=> 'TF_ACP',
++-			'version'	=> '1.2.3',
+++			'version'	=> '1.0.0',
++ 			'modes'		=> array(
++-				'settings'	=> array('title' => 'TF_CONFIG', 'auth'	=> 'ext_rmcgirr83/topfive && acl_a_extensions' , 'cat'	=> array('TOPFIVE_MOD')),
+++				'settings'	=> array('title' => 'TF_CONFIG', 'auth'	=> 'ext_rmcgirr83/topfive', 'cat'	=> array('TOPFIVE_MOD')),
++ 			),
++ 		);
++ 	}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/acp/topfive_module.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\topfive/acp/topfive_module.php"
++index 3cc28d045..c1801a315 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/acp/topfive_module.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\topfive/acp/topfive_module.php"
++@@ -11,21 +11,67 @@ namespace rmcgirr83\topfive\acp;
++ 
++ class topfive_module
++ {
++-	public $u_action;
+++	var $u_action;
++ 
++ 	function main($id, $mode)
++ 	{
++-		global $phpbb_container;
+++		global $db, $user, $auth, $template, $cache, $request;
+++		global $config, $phpbb_root_path, $phpbb_admin_path, $phpEx;
++ 
+++		$this->config = $config;
+++		$this->request = $request;
+++
+++		$user->add_lang('acp/common');
+++		$user->add_lang_ext('rmcgirr83/topfive', 'acp/info_acp_topfive');
++ 		$this->tpl_name = 'acp_topfive';
++-		$this->page_title = $phpbb_container->get('language')->lang('TF_ACP');
+++		$this->page_title = $user->lang['TOPFIVE_MOD'];
+++		add_form_key('acp_topfive');
+++
+++		if ($request->is_set_post('submit'))
+++		{
+++			if (!check_form_key('acp_topfive'))
+++			{
+++				trigger_error('FORM_INVALID');
+++			}
+++			if (!function_exists('validate_data'))
+++			{
+++				include($phpbb_root_path . 'includes/functions_user.' . $phpEx);
+++			}
+++
+++			$check_row = array('top_five_how_many' => $request->variable('top_five_how_many', 0));
+++			$validate_row = array('top_five_how_many' => array('num', false, 5, 100));
+++			$error = validate_data($check_row, $validate_row);
+++
+++			// Replace "error" strings with their real, localised form
+++			$error = array_map(array($user, 'lang'), $error);
+++
+++			if (!sizeof($error))
+++			{
+++				$config->set('top_five_how_many', $request->variable('top_five_how_many', 0));
+++				$config->set('top_five_ignore_inactive_users', $request->variable('top_five_ignore_inactive_users', true));
+++				$config->set('top_five_ignore_founder', $request->variable('top_five_ignore_founder', true));
+++				$config->set('top_five_show_admins_mods', $request->variable('top_five_show_admins_mods', true));
+++				$config->set('top_five_location', $request->variable('top_five_location', true));
+++				$config->set('top_five_active', $request->variable('top_five_active', true));
+++
+++				$cache->destroy('_top_five_newest_users');
+++				$cache->destroy('_top_five_posters');
++ 
++-		// Get an instance of the admin controller
++-		$admin_controller = $phpbb_container->get('rmcgirr83.topfive.admin.controller');
+++				trigger_error($user->lang['TF_SAVED'] . adm_back_link($this->u_action));
+++			}
+++		}
++ 
++-		// Make the $u_action url available in the admin controller
++-		$admin_controller->set_page_url($this->u_action);
+++		$template->assign_vars(array(
+++			'TF_ERROR'			=> isset($error) ? ((sizeof($error)) ? implode('<br />', $error) : '') : '',
+++			'HOWMANY'			=> (!empty($this->config['top_five_how_many'])) ? $this->config['top_five_how_many'] : 0,
+++			'IGNORE_INACTIVE'	=> (!empty($this->config['top_five_ignore_inactive_users'])) ? true : false,
+++			'IGNORE_FOUNDER'	=> (!empty($this->config['top_five_ignore_founder'])) ? true : false,
+++			'SHOW_ADMINS_MODS'	=> (!empty($this->config['top_five_show_admins_mods'])) ? true : false,
+++			'LOCATION'			=> (!empty($this->config['top_five_location'])) ? true : false,
+++			'ACTIVE'			=> (!empty($this->config['top_five_active'])) ? true : false,
+++			'TF_VERSION'		=> $this->config['top_five_version'],
++ 
++-		$admin_controller->display_options();
+++			'U_ACTION'			=> $this->u_action,
+++		));
++ 	}
++ }
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/adm/style/acp_topfive.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\topfive/adm/style/acp_topfive.html"
++index 48224526d..f799a7138 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/adm/style/acp_topfive.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\topfive/adm/style/acp_topfive.html"
++@@ -1,60 +1,51 @@
++-{% INCLUDE 'overall_header.html' %}
+++<!-- INCLUDE overall_header.html -->
++ 
++-<h1>{{ lang('TF_TITLE') }}</h1>
++-<fieldset>
++-	<legend>{{ lang('BUY_ME_A_BEER') }}</legend>
++-	<dl>
++-		<dt><label>{{ lang('BUY_ME_A_BEER_SHORT') }}{{ lang('COLON') }}</label><br /><span>{{ lang('BUY_ME_A_BEER_EXPLAIN') }}</span></dt>
++-		<dd><a href="{{ lang('BUY_ME_A_BEER_URL') }}" target="_blank" rel="noreferrer noopener"><img src="{{ lang('PAYPAL_IMAGE_URL') }}" border="0" alt="{{ lang('PAYPAL_ALT') }}" style="cursor:pointer;margin-top:15px;"></a></dd>
++-	</dl>
++-</fieldset>
++-{% if TF_ERROR %}
++-	<div class="errorbox"><h3>{{ lang('WARNING') }}</h3>
++-		<p>{{ TF_ERROR }}</p>
+++<h1>{L_TF_TITLE}</h1>
+++<p>{L_TF_VERSION} {TF_VERSION}</p>
+++
+++<!-- IF TF_ERROR -->
+++	<div class="errorbox"><h3>{L_WARNING}</h3>
+++		<p>{TF_ERROR}</p>
++ 	</div>
++-{% endif %}
+++<!-- ENDIF -->
++ 
++-<form id="acp_topfive" method="post" action="{{ U_ACTION }}">
+++<form id="acp_topfive" method="post" action="{U_ACTION}">
++ 	<fieldset>
++-		<legend>{{ lang('TF_CONFIG') }}</legend>
++-		<dl>
++-			<dt><label>{{ lang('TF_LOCATION') ~ lang('COLON') }}</label><br>
++-			<span>{{ lang('TF_LOCATION_EXPLAIN') }}</span></dt>
++-			<dd><select name="top_five_location">{{ LOCATION }}</select></dd>
++-		</dl>
+++		<legend>{L_TF_CONFIG}</legend>
++ 		<dl>
++-			<dt><label>{{ lang('TF_AVATARS') }}</label><br />{{ lang('TF_AVATARS_EXPLAIN') }}</dt>
++-			<dd><input type="radio" class="radio" name="top_five_avatars" value="1" {% if AVATARS %}checked="checked"{% endif %}/> {{ lang('YES') }} &nbsp;
++-				<input type="radio" class="radio" name="top_five_avatars" value="0" {% if not AVATARS %}checked="checked"{% endif %} /> {{ lang('NO') }}</dd>
+++			<dt><label id="top_five_active" for="top_five_active">{L_TF_ACTIVE}</label></dt>
+++			<dd><input type="radio" class="radio" name="top_five_active" value="1" <!-- IF ACTIVE -->checked="checked"<!-- ENDIF -->/> {L_YES} &nbsp;
+++				<input type="radio" class="radio" name="top_five_active" value="0" <!-- IF not ACTIVE -->checked="checked"<!-- ENDIF --> /> {L_NO}</dd>
++ 		</dl>
++ 		<dl>
++-			<dt><label>{{ lang('TF_HOWMANY') }}</label><br />{{ lang('TF_HOWMANY_EXPLAIN') }}</dt>
++-			<dd><input type="number" name="top_five_how_many" size="10" min="5" max="100" value="{{ HOWMANY }}" /></dd>
+++			<dt><label id="top_five_location" for="top_five_location">{L_TF_LOCATION}</label><br />{L_TF_LOCATION_EXPLAIN}</dt>
+++			<dd><input type="radio" class="radio" name="top_five_location" value="1" <!-- IF LOCATION -->checked="checked"<!-- ENDIF -->/> {L_TOP_OF_FORUM} &nbsp;
+++				<input type="radio" class="radio" name="top_five_location" value="0" <!-- IF not LOCATION -->checked="checked"<!-- ENDIF --> /> {L_BOTTOM_OF_FORUM}</dd>
++ 		</dl>
++ 		<dl>
++-			<dt><label>{{ lang('TF_EXCLUDED') ~ lang('COLON') }}</label><br /><span>{{ lang('TF_EXCLUDED_EXPLAIN') }}</span></dt>
++-			<dd>{{ TF_EXCLUDED }}</dd>
+++			<dt><label id="top_five_how_many" for="top_five_how_many">{L_TF_HOWMANY}</label><br />{L_TF_HOWMANY_EXPLAIN}</dt>
+++			<dd><input type="text" name="top_five_how_many" id="top_five_how_many" size="10" value="{HOWMANY}" /></dd>
++ 		</dl>
++ 		<dl>
++-			<dt><label>{{ lang('TF_IGNORE_USERS') }}</label><br />{{ lang('TF_IGNORE_USERS_EXPLAIN') }}</dt>
++-			<dd><input type="radio" class="radio" name="top_five_ignore_inactive_users" value="1" {% if IGNORE_INACTIVE %}checked="checked"{% endif %}/> {{ lang('YES') }} &nbsp;
++-				<input type="radio" class="radio" name="top_five_ignore_inactive_users" value="0" {% if not IGNORE_INACTIVE %}checked="checked"{% endif %} /> {{ lang('NO') }}</dd>
+++			<dt><label id="top_five_ignore_inactive_users" for="top_five_ignore_inactive_users">{L_TF_IGNORE_USERS}</label><br />{L_TF_IGNORE_USERS_EXPLAIN}</dt>
+++			<dd><input type="radio" class="radio" name="top_five_ignore_inactive_users" value="1" <!-- IF IGNORE_INACTIVE -->checked="checked"<!-- ENDIF -->/> {L_YES} &nbsp;
+++				<input type="radio" class="radio" name="top_five_ignore_inactive_users" value="0" <!-- IF not IGNORE_INACTIVE -->checked="checked"<!-- ENDIF --> /> {L_NO}</dd>
++ 		</dl>
++ 		<dl>
++-			<dt><label>{{ lang('TF_IGNORE_FOUNDER') }}</label><br />{{ lang('TF_IGNORE_FOUNDER_EXPLAIN') }}</dt>
++-			<dd><input type="radio" class="radio" name="top_five_ignore_founder" value="1" {% if IGNORE_FOUNDER %}checked="checked"{% endif %}/> {{ lang('YES') }} &nbsp;
++-				<input type="radio" class="radio" name="top_five_ignore_founder" value="0" {% if not IGNORE_FOUNDER %}checked="checked"{% endif %} /> {{ lang('NO') }}</dd>
+++			<dt><label id="top_five_ignore_founder" for="top_five_ignore_founder">{L_TF_IGNORE_FOUNDER}</label><br />{L_TF_IGNORE_FOUNDER_EXPLAIN}</dt>
+++			<dd><input type="radio" class="radio" name="top_five_ignore_founder" value="1" <!-- IF IGNORE_FOUNDER -->checked="checked"<!-- ENDIF -->/> {L_YES} &nbsp; 
+++				<input type="radio" class="radio" name="top_five_ignore_founder" value="0" <!-- IF not IGNORE_FOUNDER -->checked="checked"<!-- ENDIF --> /> {L_NO}</dd>
++ 		</dl>
++ 		<dl>
++-			<dt><label>{{ lang('TF_SHOW_ADMINS_MODS') }}</label><br />{{ lang('TF_SHOW_ADMINS_MODS_EXPLAIN') }}</dt>
++-			<dd><input type="radio" class="radio" name="top_five_show_admins_mods" value="1" {% if SHOW_ADMINS_MODS %}checked="checked"{% endif %}/> {{ lang('YES') }} &nbsp;
++-				<input type="radio" class="radio" name="top_five_show_admins_mods" value="0" {% if not SHOW_ADMINS_MODS %}checked="checked"{% endif %} /> {{ lang('NO') }}</dd>
+++			<dt><label id="top_five_show_admins_mods" for="top_five_show_admins_mods">{L_TF_SHOW_ADMINS_MODS}</label><br />{L_TF_SHOW_ADMINS_MODS_EXPLAIN}</dt>
+++			<dd><input type="radio" class="radio" name="top_five_show_admins_mods" value="1" <!-- IF SHOW_ADMINS_MODS -->checked="checked"<!-- ENDIF -->/> {L_YES} &nbsp;
+++				<input type="radio" class="radio" name="top_five_show_admins_mods" value="0" <!-- IF not SHOW_ADMINS_MODS -->checked="checked"<!-- ENDIF --> /> {L_NO}</dd>
++ 		</dl>
++ 		<p class="submit-buttons">
++-			<input class="button1" type="submit" id="submit" name="submit" value="{{ lang('SUBMIT') }}" />&nbsp;
++-			<input class="button2" type="reset" id="reset" name="reset" value="{{ lang('RESET') }}" />
++-		{{ S_FORM_TOKEN }}
+++			<input class="button1" type="submit" id="submit" name="submit" value="{L_SUBMIT}" />&nbsp;
+++			<input class="button2" type="reset" id="reset" name="reset" value="{L_RESET}" />
+++		{S_FORM_TOKEN}
++ 		</p>
++ 	</fieldset>
++ </form>
++-{% INCLUDE 'overall_footer.html' %}
+++<!-- INCLUDE overall_footer.html -->
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/adm/style/event/acp_ext_details_end.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/adm/style/event/acp_ext_details_end.html"
++deleted file mode 100644
++index 5a3267046..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/adm/style/event/acp_ext_details_end.html"
+++++ /dev/null
++@@ -1,9 +0,0 @@
++-{% if S_BUY_ME_A_BEER_TOPFIVE %}
++-	<fieldset>
++-		<legend>{{ lang('BUY_ME_A_BEER') }}</legend>
++-		<dl>
++-			<dt><label>{{ lang('BUY_ME_A_BEER_SHORT') }}{{ lang('COLON') }}</label><br /><span>{{ lang('BUY_ME_A_BEER_EXPLAIN') }}</span></dt>
++-			<dd><a href="{{ lang('BUY_ME_A_BEER_URL') }}" target="_blank" rel="noreferrer noopener"><img src="{{ lang('PAYPAL_IMAGE_URL') }}" border="0" alt="{{ lang('PAYPAL_ALT') }}" style="cursor:pointer;margin-top:15px;"></a></dd>
++-		</dl>
++-	</fieldset>
++-{% endif %}
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\topfive/composer.json"
++index 531076584..ac1d70338 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/composer.json"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\topfive/composer.json"
++@@ -1,38 +1,36 @@
++ {
++     "name": "rmcgirr83/topfive",
++     "type": "phpbb-extension",
++-    "description": "Displays statistics of the latest new posts, new users and most active users on the forum index page.",
+++    "description": "Displays statistics of the latest new posts, new users and most active users on the boards index page.",
++     "homepage": "https://github.com/RMcGirr83/topfive",
++-    "version": "1.2.8",
++-    "time": "2024-10-26",
+++    "version": "1.0.2",
+++    "time": "2015-05-28",
++     "keywords": [
++         "phpbb",
++         "extension",
++         "top five"
++     ],
++-    "license": "GPL-2.0-only",
+++    "license": "GPL-2.0",
++     "authors": [
++         {
++             "name": "Rich McGirr",
++-            "homepage": "https://paypal.me/rmcgirr83",
+++            "homepage": "https://www.phpbb.com/customise/db/author/rmcgirr83/contributions",
+++            "email": "rmcgirr83@rmcgirr83.org",
++             "role": "Lead Developer"
++         }
++     ],
++     "require": {
++-        "php": ">=7.4",
++-        "phpbb/phpbb": ">=3.3",
++-        "composer/installers": "~1.0.0"
+++        "php": ">=5.3.3"
++     },
++     "extra": {
++-        "display-name": "Top Five Extension",
+++        "display-name": "Top Five",
++         "soft-require": {
++-            "phpbb/phpbb": ">=3.3"
+++            "phpbb/phpbb": ">=3.1.2,<3.2.*@dev"
++         },
++         "version-check": {
++             "host": "www.phpbb.com",
++             "directory": "/customise/db/extension/topfiveext",
++-            "filename": "version_check",
++-            "ssl": true
+++            "filename": "version_check"
++         }
++     }
++ }
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/config/services.yml" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\topfive/config/services.yml"
++index c499f0988..7654a7bd9 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/config/services.yml"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\topfive/config/services.yml"
++@@ -1,20 +1,5 @@
++-imports:
++-    - { resource: topfive_constants.yml }
++-
++ services:
++-    rmcgirr83.topfive.admin.controller:
++-        class: rmcgirr83\topfive\controller\admin_controller
++-        arguments:
++-            - '@cache'
++-            - '@config'
++-            - '@language'
++-            - '@request'
++-            - '@template'
++-            - '%core.root_path%'
++-            - '%core.php_ext%'
++-            - '%topfive_constants%'
++-
++-    rmcgirr83.topfive.topfive:
+++    rmcgirr83.topfive.functions:
++         class: rmcgirr83\topfive\core\topfive
++         arguments:
++             - '@auth'
++@@ -23,25 +8,17 @@ services:
++             - '@content.visibility'
++             - '@dbal.conn'
++             - '@dispatcher'
++-            - '@language'
++             - '@template'
++             - '@user'
++             - '%core.root_path%'
++             - '%core.php_ext%'
++-            - '@?senky.relativedates.listener'
++-            - '@?rmcgirr83.nationalflags.nationalflags'
++ 
++     rmcgirr83.topfive.listener:
++         class: rmcgirr83\topfive\event\listener
++         arguments:
++-            - '@rmcgirr83.topfive.topfive'
+++            - '@rmcgirr83.topfive.functions'
++             - '@config'
++-            - '@language'
++             - '@template'
++             - '@user'
++-            - '@controller.helper'
++-            - '%core.php_ext%'
++-            - '%topfive_constants%'
++-            - '@?phpbb.collapsiblecategories.operator'
++         tags:
++             - { name: event.listener }
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/config/topfive_constants.yml" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/config/topfive_constants.yml"
++deleted file mode 100644
++index b60ea6065..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/config/topfive_constants.yml"
+++++ /dev/null
++@@ -1,6 +0,0 @@
++-parameters:
++-    topfive_constants:
++-        top_of_index: 0
++-        bottom_of_index: 1
++-        top_of_entire_forum: 2
++-        bottom_of_entire_forum: 3
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/controller/admin_controller.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/controller/admin_controller.php"
++deleted file mode 100644
++index 40a3df971..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/controller/admin_controller.php"
+++++ /dev/null
++@@ -1,190 +0,0 @@
++-<?php
++-/**
++-*
++-* Top Five extension for the phpBB Forum Software package.
++-*
++-* @copyright 2016 Rich McGirr (RMcGirr83)
++-* @license GNU General Public License, version 2 (GPL-2.0)
++-*
++-*/
++-
++-namespace rmcgirr83\topfive\controller;
++-
++-use phpbb\cache\service as cache;
++-use phpbb\config\config;
++-use phpbb\language\language;
++-use phpbb\request\request;
++-use phpbb\template\template;
++-
++-class admin_controller
++-{
++-	/** @var cache */
++-	protected $cache;
++-
++-	/** @var config */
++-	protected $config;
++-
++-	/** @var language */
++-	protected $language;
++-
++-	/** @var request */
++-	protected $request;
++-
++-	/** @var template */
++-	protected $template;
++-
++-	/** @var string phpBB root path */
++-	protected $root_path;
++-
++-	/** @var string phpEx */
++-	protected $php_ext;
++-
++-	/* @var array topfive_constants */
++-	protected $topfive_constants;
++-
++-	/** @var string Custom form action */
++-	protected $u_action;
++-
++-	/**
++-	* Constructor
++-	*
++-	* @param cache						$cache				Cache object
++-	* @param config						$config				Config object
++-	* @param language					$language			Language object
++-	* @param request					$request			Request object
++-	* @param template					$template			Template object
++-	* @param string						$root_path			phpBB root path
++-	* @param string						$php_ext			phpEx
++-	* @param array						$topfive_constants	Constants for the extension
++-	* @access public
++-	*/
++-	public function __construct(
++-			cache $cache,
++-			config $config,
++-			language $language,
++-			request $request,
++-			template $template,
++-			string $root_path,
++-			string $php_ext,
++-			array $topfive_constants)
++-	{
++-		$this->cache = $cache;
++-		$this->config = $config;
++-		$this->language = $language;
++-		$this->request = $request;
++-		$this->template = $template;
++-		$this->root_path = $root_path;
++-		$this->php_ext = $php_ext;
++-		$this->topfive_constants = $topfive_constants;
++-	}
++-
++-	public function display_options()
++-	{
++-		$this->language->add_lang('acp_topfive', 'rmcgirr83/topfive');
++-
++-		// Create a form key for preventing CSRF attacks
++-		add_form_key('acp_topfive');
++-
++-		// get the excluded forums
++-		$excluded_forums = explode(',', $this->config['top_five_excluded']);
++-
++-		if ($this->request->is_set_post('submit'))
++-		{
++-			if (!check_form_key('acp_topfive'))
++-			{
++-				trigger_error('FORM_INVALID');
++-			}
++-			if (!function_exists('validate_data'))
++-			{
++-				include($this->root_path . 'includes/functions_user.' . $this->php_ext);
++-			}
++-
++-			$check_row = array('top_five_how_many' => $this->request->variable('top_five_how_many', 0));
++-			$validate_row = array('top_five_how_many' => array('num', false, 5, 100));
++-			$error = validate_data($check_row, $validate_row);
++-			// Replace "error" strings with their real, localised form
++-			$error = array_map(array($this->language, 'lang'), $error);
++-
++-			if (!sizeof($error))
++-			{
++-				$this->set_options();
++-
++-				$this->cache->destroy('_top_five_newest_users');
++-				$this->cache->destroy('_top_five_posters');
++-
++-				trigger_error($this->language->lang('TF_SAVED') . adm_back_link($this->u_action));
++-			}
++-		}
++-
++-		$this->template->assign_vars(array(
++-			'TF_ERROR'			=> isset($error) ? ((sizeof($error)) ? implode('<br />', $error) : '') : '',
++-			'HOWMANY'			=> isset($this->config['top_five_how_many']) ? $this->config['top_five_how_many'] : 0,
++-			'IGNORE_INACTIVE'	=> isset($this->config['top_five_ignore_inactive_users']) ? $this->config['top_five_ignore_inactive_users'] : false,
++-			'IGNORE_FOUNDER'	=> isset($this->config['top_five_ignore_founder']) ? $this->config['top_five_ignore_founder'] : false,
++-			'SHOW_ADMINS_MODS'	=> isset($this->config['top_five_show_admins_mods']) ? $this->config['top_five_show_admins_mods'] : false,
++-			'LOCATION'			=> $this->location($this->config['top_five_location']),
++-			'ACTIVE'			=> isset($this->config['top_five_active']) ? $this->config['top_five_active'] : false,
++-			'TF_EXCLUDED'		=> $this->forum_select($excluded_forums),
++-			'AVATARS'		=> isset($this->config['top_five_avatars']) ? $this->config['top_five_avatars'] : false,
++-
++-			'U_ACTION'			=> $this->u_action,
++-		));
++-	}
++-
++-	protected function set_options()
++-	{
++-		$this->config->set('top_five_how_many', $this->request->variable('top_five_how_many', 0));
++-		$this->config->set('top_five_ignore_inactive_users', $this->request->variable('top_five_ignore_inactive_users', 0));
++-		$this->config->set('top_five_ignore_founder', $this->request->variable('top_five_ignore_founder', 0));
++-		$this->config->set('top_five_show_admins_mods', $this->request->variable('top_five_show_admins_mods', 0));
++-		$this->config->set('top_five_location', $this->request->variable('top_five_location', 0));
++-		$this->config->set('top_five_active', $this->request->variable('top_five_active', 0));
++-
++-		// variable should be '' as it is a string ("1, 2, 3928") here, not an integer.
++-		$forums = $this->request->variable('selectForms',  array(''));
++-		// change the array to a string
++-		$forums  = implode(',', $forums);
++-		$this->config->set('top_five_excluded', $forums);
++-		$this->config->set('top_five_avatars', $this->request->variable('top_five_avatars',0));
++-	}
++-
++-	/**
++-	 * Display a drop down of all forums for selection
++-	 *
++-	 * @return drop down select
++-	 * @access protected
++-	 */
++-	private function forum_select($value)
++-	{
++-		return '<select id="top_five_excluded" name="selectForms[]" multiple="multiple">' . make_forum_select($value, false, true, true) . '</select>';
++-	}
++-
++-	/**
++-	 * Create the selection for the post method
++-	 */
++-	public function location($location = 0)
++-	{
++-		// location options
++-		$location_text = [$this->topfive_constants['top_of_index'] => $this->language->lang('TOP_OF_FORUM'), $this->topfive_constants['bottom_of_index'] => $this->language->lang('BOTTOM_OF_FORUM'), $this->topfive_constants['top_of_entire_forum'] => $this->language->lang('TOP_OF_ENTIRE_FORUM'), $this->topfive_constants['bottom_of_entire_forum'] => $this->language->lang('BOTTOM_OF_ENTIRE_FORUM')];
++-		$location_options = '';
++-		foreach ($location_text as $value => $text)
++-		{
++-			$selected = ($value == $location) ? ' selected="selected"' : '';
++-			$location_options .= "<option value='{$value}'$selected>$text</option>";
++-		}
++-
++-		return $location_options;
++-	}
++-
++-	/**
++-	 * Set page url
++-	 *
++-	 * @param string $u_action Custom form action
++-	 * @return null
++-	 * @access public
++-	 */
++-	public function set_page_url($u_action)
++-	{
++-		$this->u_action = $u_action;
++-	}
++-}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/core/topfive.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\topfive/core/topfive.php"
++index 4facdbedc..3d9f9352e 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/core/topfive.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\topfive/core/topfive.php"
++@@ -11,65 +11,39 @@
++ 
++ namespace rmcgirr83\topfive\core;
++ 
++-use phpbb\auth\auth;
++-use phpbb\config\config;
++-use phpbb\cache\service as cache_service;
++-use phpbb\content_visibility;
++-use phpbb\db\driver\driver_interface;
++-use phpbb\event\dispatcher_interface;
++-use phpbb\language\language;
++-use phpbb\template\template;
++-use phpbb\user;
++-
++ class topfive
++ {
++-	/** @var auth */
+++	/** @var \phpbb\auth\auth */
++ 	protected $auth;
++ 
++-	/** @var config */
+++	/** @var \phpbb\config\config */
++ 	protected $config;
++ 
++-	/** @var cache */
+++	/** @var \phpbb\cache\driver\driver_interface */
++ 	protected $cache;
++ 
++-	/** @var content_visibility */
+++	/** @var \phpbb\content_visibility */
++ 	protected $content_visibility;
++ 
++-	/** @var db */
+++	/** @var \phpbb\db\driver\driver_interface */
++ 	protected $db;
++ 
++-	/** @var dispatcher */
+++	/** @var \phpbb\event\dispatcher_interface */
++ 	protected $dispatcher;
++ 
++-	/** @var language */
++-	protected $language;
++-
++-	/** @var template */
+++	/** @var \phpbb\template\template */
++ 	protected $template;
++ 
++-	/** @var user */
+++	/** @var \phpbb\user */
++ 	protected $user;
++ 
++-	/** @var string phpbb_root_path */
+++	/** @var string phpBB root path */
++ 	protected $phpbb_root_path;
++ 
++-	/** @var string php_ext */
+++	/** @var string PHP extension */
++ 	protected $php_ext;
++ 
++-	public function __construct(
++-		auth $auth,
++-		config $config,
++-		cache_service $cache,
++-		content_visibility $content_visibility,
++-		driver_interface $db,
++-		dispatcher_interface $dispatcher,
++-		language $language,
++-		template $template,
++-		user $user,
++-		string $phpbb_root_path,
++-		string $php_ext,
++-		\senky\relativedates\event\listener $relativedates = null,
++-		\rmcgirr83\nationalflags\core\nationalflags $nationalflags= null)
+++	public function __construct(\phpbb\auth\auth $auth, \phpbb\config\config $config, \phpbb\cache\service $cache, \phpbb\content_visibility $content_visibility, \phpbb\db\driver\driver_interface $db, \phpbb\event\dispatcher_interface $dispatcher, \phpbb\template\template $template, \phpbb\user $user, $phpbb_root_path, $php_ext)
++ 	{
++ 		$this->auth = $auth;
++ 		$this->config = $config;
++@@ -77,27 +51,18 @@ class topfive
++ 		$this->content_visibility = $content_visibility;
++ 		$this->db = $db;
++ 		$this->dispatcher = $dispatcher;
++-		$this->language = $language;
++ 		$this->template = $template;
++ 		$this->user = $user;
++ 		$this->root_path = $phpbb_root_path;
++ 		$this->php_ext = $php_ext;
++-		$this->relativedates = $relativedates;
++-		$this->nationalflags = $nationalflags;
++ 	}
++ 
++-	/**
++-	* Display activity
++-	*
++-	* @param	string	$tpl_loopname	Name of the html file
++-	* @return 	null
++-	* @access 	public
++-	*/
++ 	public function toptopics($tpl_loopname = 'top_five_topic')
++ 	{
+++
++ 		$howmany = $this->howmany();
++ 
++-		$forum_ary = [];
+++		$forum_ary = array();
++ 		$forum_read_ary = $this->auth->acl_getf('f_read');
++ 
++ 		foreach ($forum_read_ary as $forum_id => $allowed)
++@@ -109,220 +74,184 @@ class topfive
++ 		}
++ 		$forum_ary = array_unique($forum_ary);
++ 
++-		// want to exclude some forums
++-		$excluded_forums = explode(',', $this->config['top_five_excluded']);
++-
++-		// now remove those topics from the display per the excluded forums array
++-		$forum_ary = array_diff($forum_ary, $excluded_forums);
++-
++-		if (!sizeof($forum_ary))
+++		if (sizeof($forum_ary))
++ 		{
++-			$this->template->assign_block_vars($tpl_loopname, [
++-				'NO_TOPIC_TITLE'	=> $this->language->lang('NO_TOPIC_EXIST'),
++-			]);
++-
++-			return false;
++-		}
++-
++-		/**
++-		* Select topic_ids
++-		*/
++-		// grab all posts that meet criteria and auths
++-		$sql_array = [
++-			'SELECT'	=> 't.forum_id, t.topic_id, t.topic_type',
++-			'FROM'		=> [TOPICS_TABLE => 't'],
++-			'WHERE'		=> $this->content_visibility->get_forums_visibility_sql('topic', $forum_ary) . ' AND topic_status <> ' . ITEM_MOVED,
++-			'ORDER_BY'	=> 't.topic_last_post_time DESC',
++-		];
++-
++-		$result = $this->db->sql_query_limit($this->db->sql_build_query('SELECT', $sql_array), $howmany);
++-
++-		$forums = $ga_topic_ids = $topic_ids = [];
++-		while ($row = $this->db->sql_fetchrow($result))
++-		{
++-			$topic_ids[] = $row['topic_id'];
++-			if ($row['topic_type'] == POST_GLOBAL)
+++			/**
+++			* Select topic_ids
+++			*/
+++			$sql = 'SELECT forum_id, topic_id, topic_type
+++				FROM ' . TOPICS_TABLE . '
+++				WHERE ' . $this->content_visibility->get_forums_visibility_sql('topic', $forum_ary) . '
+++				AND topic_status <> ' . ITEM_MOVED . '
+++				ORDER BY topic_last_post_time DESC';
+++
+++			$result = $this->db->sql_query_limit($sql, $howmany);
+++			$forums = $ga_topic_ids = $topic_ids = array();
+++			while ($row = $this->db->sql_fetchrow($result))
++ 			{
++-				$ga_topic_ids[] = $row['topic_id'];
+++				$topic_ids[] = $row['topic_id'];
+++				if ($row['topic_type'] == POST_GLOBAL)
+++				{
+++					$ga_topic_ids[] = $row['topic_id'];
+++				}
+++				else
+++				{
+++					$forums[$row['forum_id']][] = $row['topic_id'];
+++				}
++ 			}
++-			else
+++			$this->db->sql_freeresult($result);
+++
+++			// Get topic tracking
+++			$topic_tracking_info = array();
+++			foreach ($forums as $forum_id => $topic_id)
++ 			{
++-				$forums[$row['forum_id']][] = $row['topic_id'];
+++				$topic_tracking_info[$forum_id] = get_complete_topic_tracking($forum_id, $topic_id, $ga_topic_ids);
++ 			}
++-		}
++-		$this->db->sql_freeresult($result);
++ 
++-		// Get topic tracking
++-		$topic_tracking_info = [];
++-		foreach ($forums as $forum_id => $topic_id)
++-		{
++-			$topic_tracking_info[$forum_id] = get_complete_topic_tracking($forum_id, $topic_id, $ga_topic_ids);
++-		}
++-
++-		/*
++-		* must have topic_ids.
++-		* A user can have forums and not have topic_ids before installing this extension
++-		*/
++-		if (!sizeof($topic_ids))
++-		{
++-			$this->template->assign_block_vars($tpl_loopname, [
++-				'NO_TOPIC_TITLE'	=> $this->language->lang('NO_TOPIC_EXIST'),
++-			]);
++-
++-			return false;
++-		}
++-
++-		// grab all posts that meet criteria and auths
++-		$sql_array = [
++-			'SELECT'	=> 'u.user_id, u.username, u.user_colour, u.user_avatar, u.user_avatar_type, u.user_avatar_height, u.user_avatar_width, t.topic_title, t.forum_id, t.topic_id, t.topic_first_post_id, t.topic_last_post_id, t.topic_last_post_time, t.topic_last_poster_name, f.forum_name',
++-			'FROM'		=> [TOPICS_TABLE => 't'],
++-			'LEFT_JOIN'	=> [
++-				[
++-					'FROM'	=> [USERS_TABLE => 'u'],
++-					'ON'	=> 't.topic_last_poster_id = u.user_id',
++-				],
++-				[
++-					'FROM'	=> [FORUMS_TABLE => 'f'],
++-					'ON'	=> 't.forum_id = f.forum_id',
++-				],
++-			],
++-			'WHERE'		=> $this->db->sql_in_set('t.topic_id', $topic_ids),
++-			'ORDER_BY'	=> 't.topic_last_post_time DESC',
++-		];
++-		if ($this->nationalflags !== null)
++-		{
++-			$sql_array['SELECT'].= ', u.user_flag';
++-		}
++-
++-		/**
++-		* Event to modify the SQL query before the topics data is retrieved
++-		*
++-		* @event rmcgirr83.topfive.sql_pull_topics_data
++-		* @var	array	sql_array		The SQL array
++-		* @since 1.0.0
++-		*/
++-		$vars = ['sql_array'];
++-		extract($this->dispatcher->trigger_event('rmcgirr83.topfive.sql_pull_topics_data', compact($vars)));
++-
++-		$result = $this->db->sql_query_limit($this->db->sql_build_query('SELECT', $sql_array), $howmany);
++-
++-		while ($row = $this->db->sql_fetchrow($result))
++-		{
++-			$topic_id = $row['topic_id'];
++-			$forum_id = $row['forum_id'];
++-			$forum_name = $row['forum_name'];
++-
++-			$post_unread = (isset($topic_tracking_info[$forum_id][$topic_id]) && $row['topic_last_post_time'] > $topic_tracking_info[$forum_id][$topic_id]) ? true : false;
++-			$view_topic_url = !empty($post_unread) ? append_sid("{$this->root_path}viewtopic.$this->php_ext", 't=' . $topic_id . '&amp;view=unread') . '#unread' : append_sid("{$this->root_path}viewtopic.$this->php_ext", 't=' . $topic_id);
++-			/** To go to the last post in a topic use the below as the last argument in the above $view_topic_url variable
++-			append_sid("{$this->root_path}viewtopic.$this->php_ext", 'f=' . $row['forum_id'] . '&amp;p=' . $row['topic_last_post_id'] . '#p' . $row['topic_last_post_id'])
++-			**/
++-			$forum_name_url = append_sid("{$this->root_path}viewforum.$this->php_ext", 'f=' . $row['forum_id']);
++-			$topic_title = censor_text($row['topic_title']);
++-			$topic_title = truncate_string($topic_title, 60, 255, false, $this->language->lang('ELLIPSIS'));
++-
++-			$is_guest = ($row['user_id'] == ANONYMOUS) ? true : false;
++-
++-			$user_avatar = phpbb_get_user_avatar($row);
++-			$display_avatar = (!empty($this->config['top_five_avatars']) && $this->user->optionget('viewavatars') && !empty($user_avatar)) ? true : false;
++-
++-			$user_avatar = $display_avatar ? '<span class="topfive-avatar">' . $user_avatar . '</span>&nbsp;' : '';
++-
++-			// relativedates installed?
++-			if ($this->relativedates !== null)
+++			/*
+++			* must have topic_ids.
+++			* A user can have forums and not have topic_ids before installing this extension
+++			*/
+++			if (sizeof($topic_ids))
++ 			{
++-				$last_topic_time = $this->user->format_date($row['topic_last_post_time'], false, false, false);
+++				// grab all posts that meet criteria and auths
+++				$sql_array = array(
+++					'SELECT'	=> 'u.user_id, u.username, u.user_colour, u.user_avatar, u.user_avatar_type, u.user_avatar_width, u.user_avatar_height, t.topic_title, t.forum_id, t.topic_id, t.topic_first_post_id, t.topic_last_post_id, t.topic_last_post_time, t.topic_last_poster_name, f.forum_name',
+++					'FROM'		=> array(TOPICS_TABLE => 't'),
+++					'LEFT_JOIN'	=> array(
+++						array(
+++							'FROM'	=> array(USERS_TABLE => 'u'),
+++							'ON'	=> 't.topic_last_poster_id = u.user_id',
+++						),
+++						array(
+++							'FROM'	=> array(FORUMS_TABLE => 'f'),
+++							'ON'	=> 't.forum_id = f.forum_id',
+++						),
+++					),
+++					'WHERE'		=> $this->db->sql_in_set('t.topic_id', $topic_ids),
+++					'ORDER_BY'	=> 't.topic_last_post_time DESC',
+++				);
+++				/**
+++				* Event to modify the SQL query before the topics data is retrieved
+++				*
+++				* @event rmcgirr83.topfive.sql_pull_topics_data
+++				* @var	array	sql_array		The SQL array
+++				* @since 1.0.0
+++				*/
+++				$vars = array('sql_array');
+++				extract($this->dispatcher->trigger_event('rmcgirr83.topfive.sql_pull_topics_data', compact($vars)));
+++
+++				// cache the query for one minute
+++				$result = $this->db->sql_query_limit($this->db->sql_build_query('SELECT', $sql_array), $howmany, 0, 60);
+++
+++				while ($row = $this->db->sql_fetchrow($result))
+++				{
+++					$topic_id = $row['topic_id'];
+++					$forum_id = $row['forum_id'];
+++					$forum_name = $row['forum_name'];
+++
+++					$post_unread = (isset($topic_tracking_info[$forum_id][$topic_id]) && $row['topic_last_post_time'] > $topic_tracking_info[$forum_id][$topic_id]) ? true : false;
+++					$view_topic_url = append_sid("{$this->phpbb_root_path}viewtopic.$this->php_ext", 'f=' . $row['forum_id'] . '&amp;p=' . $row['topic_last_post_id'] . '#p' . $row['topic_last_post_id']);
+++					$forum_name_url = append_sid("{$this->phpbb_root_path}viewforum.$this->php_ext", 'f=' . $row['forum_id']);
+++					$topic_title = censor_text($row['topic_title']);
+++					if (utf8_strlen($topic_title) >= 60)
+++					{
+++						$topic_title = (utf8_strlen($topic_title) > 60 + 3) ? utf8_substr($topic_title, 0, 60) . '...' : $topic_title;
+++					}
+++					$is_guest = ($row['user_id'] == ANONYMOUS) ? true : false;
+++                    $user_avatar = ($row['user_avatar']) ? get_user_avatar($row['user_avatar'], $row['user_avatar_type'], 50, 50) : '<img src="' . generate_board_url() . '/styles/' . '/FLATBOOTS/' . '/theme/images/no_avatar.gif" height="50" width="50" alt="Default Avatar" />';
+++					
+++					$tpl_ary = array(
+++						'U_TOPIC'			=> $view_topic_url,
+++						'U_FORUM'			=> $forum_name_url,
+++						'TOP5_AVATAR' 	    => $user_avatar,
+++						'S_UNREAD'			=> ($post_unread) ? true : false,
+++						'USERNAME_FULL'		=> ($is_guest || !$this->auth->acl_get('u_viewprofile')) ? $this->user->lang['POST_BY_AUTHOR'] . ' ' . get_username_string('no_profile', $row['user_id'], $row['username'], $row['user_colour'], $row['topic_last_poster_name']) : $this->user->lang['POST_BY_AUTHOR'] . ' ' . get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']),
+++						'LAST_TOPIC_TIME'	=> $this->user->format_date($row['topic_last_post_time']),
+++						'TOPIC_TITLE' 		=> $topic_title,
+++						'FORUM_NAME'		=> $forum_name,
+++					);
+++					/**
+++					* Modify the topic data before it is assigned to the template
+++					*
+++					* @event rmcgirr83.topfive.modify_tpl_ary
+++					* @var	array	row			Array with topic data
+++					* @var	array	tpl_ary		Template block array with topic data
+++					* @since 1.0.0
+++					*/
+++					$vars = array('row', 'tpl_ary');
+++					extract($this->dispatcher->trigger_event('rmcgirr83.topfive.modify_tpl_ary', compact($vars)));
+++
+++					$this->template->assign_block_vars($tpl_loopname, $tpl_ary);
+++				}
+++				$this->db->sql_freeresult($result);
++ 			}
++ 			else
++ 			{
++-				$last_topic_time = $this->user->format_date($row['topic_last_post_time']);
+++				$this->template->assign_block_vars($tpl_loopname, array(
+++					'NO_TOPIC_TITLE'	=> $this->user->lang['NO_TOPIC_EXIST'],
+++				));
++ 			}
++-
++-			$user_flag = '';
++-			// nationalflags installed?
++-			if (!empty($row['user_flag']))
++-			{
++-				$user_flag = $this->nationalflags->get_user_flag($row['user_flag'], 12);
++-			}
++-
++-			$tpl_ary = [
++-				'U_TOPIC'	=> $view_topic_url,
++-				'U_FORUM'	=> $forum_name_url,
++-				'S_UNREAD'	=> ($post_unread) ? true : false,
++-				'USERNAME_FULL'	=> ($is_guest || !$this->auth->acl_get('u_viewprofile')) ? $this->language->lang('BY') . $user_avatar . get_username_string('no_profile', $row['user_id'], $row['username'], $row['user_colour'], $row['topic_last_poster_name']) : $this->language->lang('BY') . $user_avatar . get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']),
++-				'LAST_TOPIC_TIME'	=> $last_topic_time,
++-				'TOPIC_TITLE'	=> $topic_title,
++-				'FORUM_NAME'	=> $forum_name,
++-				'USER_FLAG'	=> !empty($user_flag) ? $user_flag : '',
++-			];
++-
++-			/**
++-			* Modify the topic data before it is assigned to the template
++-			*
++-			* @event rmcgirr83.topfive.modify_tpl_ary
++-			* @var	array	row			Array with topic data
++-			* @var	array	tpl_ary		Template block array with topic data
++-			* @since 1.0.0
++-			*/
++-			$vars = ['row', 'tpl_ary'];
++-			extract($this->dispatcher->trigger_event('rmcgirr83.topfive.modify_tpl_ary', compact($vars)));
++-
++-			$this->template->assign_block_vars($tpl_loopname, $tpl_ary);
++ 		}
++-		$this->db->sql_freeresult($result);
+++		else
+++		{
+++			$this->template->assign_block_vars($tpl_loopname, array(
+++				'NO_TOPIC_TITLE'	=> $this->user->lang['NO_TOPIC_EXIST'],
+++			));
+++		}
++ 	}
++ 
++-	/**
++-	* Get the top posters
++-	*
++-	* @return 	null
++-	* @access 	public
++-	*/
++ 	public function topposters()
++ 	{
++ 		$howmany = $this->howmany();
++ 		$sql_where = $this->ignore_users();
++ 
+++		//set two variables for the sql
+++		$sql_and = $sql_other = '';
+++
++ 		if (($user_posts = $this->cache->get('_top_five_posters')) === false)
++ 		{
++-			$user_posts = [];
++ 
++-			$sql_where .= empty($sql_where) ? 'u.user_posts <> 0' : ' AND u.user_posts <> 0';
+++			$user_posts = $admin_mod_array = array();
+++			// quick check for forum moderators and administrators
+++			// some may not want to show them
+++			$show_admins_mods = $this->config['top_five_show_admins_mods'];
++ 
++-			// do the main sql query
++-			$sql_array = [
++-				'SELECT' => 'u.user_id, u.username, u.user_colour, u.user_posts, u.user_avatar, u.user_avatar_width, u.user_avatar_height, u.user_avatar_type, u.user_lastpost_time',
++-				'FROM' => [USERS_TABLE => 'u'],
++-				'WHERE' => $sql_where,
++-				'ORDER_BY' => 'u.user_lastpost_time DESC, u.user_posts DESC',
++-			];
++-
++-			if ($this->nationalflags !== null)
+++			if (!$show_admins_mods)
++ 			{
++-				$sql_array['SELECT'] .= ', u.user_flag';
+++				// grab all admins
+++				$admin_ary = $this->auth->acl_get_list(false, 'a_', false);
+++				$admin_ary = (!empty($admin_ary[0]['a_'])) ? $admin_ary[0]['a_'] : array();
+++
+++				//grab all mods
+++				$mod_ary = $this->auth->acl_get_list(false,'m_', false);
+++				$mod_ary = (!empty($mod_ary[0]['m_'])) ? $mod_ary[0]['m_'] : array();
+++				$admin_mod_array = array_unique(array_merge($admin_ary, $mod_ary));
+++				if (sizeof($admin_mod_array))
+++				{
+++					$sql_and = empty($sql_where) ? ' WHERE' : ' AND';
+++					$sql_and .= ' ' . $this->db->sql_in_set('user_id', $admin_mod_array, true);
+++				}
++ 			}
++-			$result = $this->db->sql_query_limit($this->db->sql_build_query('SELECT', $sql_array), $howmany);
+++			$sql_other = (empty($sql_and) && empty($sql_where)) ? ' WHERE' : ' AND';
+++			$sql_other .=  ' user_posts <> 0';
++ 
+++			// do the main sql query
+++			$sql = 'SELECT user_id, username, user_colour, user_posts
+++				FROM ' . USERS_TABLE . '
+++				 ' . $sql_where . ' ' . $sql_and . '
+++				' . $sql_other . '
+++				ORDER BY user_posts DESC';
+++
+++			$result = $this->db->sql_query_limit($sql, $howmany);
++ 			while ($row = $this->db->sql_fetchrow($result))
++ 			{
++-				$user_flag = '';
++-				// nationalflags installed?
++-				if (!empty($row['user_flag']))
++-				{
++-					$user_flag = $this->nationalflags->get_user_flag($row['user_flag'], 12);
++-				}
++-				$user_posts[$row['user_id']] = [
+++				$user_posts[$row['user_id']] = array(
++ 					'user_id'      => $row['user_id'],
++ 					'username'      => $row['username'],
++ 					'user_colour'   => $row['user_colour'],
++ 					'user_posts'    => $row['user_posts'],
++-					'user_avatar'	=> $row['user_avatar'],
++-					'user_avatar_width'	=> $row['user_avatar_width'],
++-					'user_avatar_height'	=> $row['user_avatar_height'],
++-					'user_avatar_type'	=> $row['user_avatar_type'],
++-					'user_lastpost_time'	=> $row['user_lastpost_time'],
++-					'user_flag'	=> !empty($user_flag) ? $user_flag : '',
++-				];
+++				);
++ 			}
++ 			$this->db->sql_freeresult($result);
++ 
++@@ -332,81 +261,44 @@ class topfive
++ 
++ 		foreach ($user_posts as $row)
++ 		{
++-			$user_avatar = phpbb_get_user_avatar($row);
++-			$display_avatar = (!empty($this->config['top_five_avatars']) && $this->user->optionget('viewavatars') && !empty($user_avatar)) ? true : false;
++-
++-			$user_avatar = $display_avatar ? '<span class="topfive-avatar">' . $user_avatar . '</span>&nbsp;' : '';
+++			$username_string = ($this->auth->acl_get('u_viewprofile')) ? get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']) : get_username_string('no_profile', $row['user_id'], $row['username'], $row['user_colour']);
++ 
++-			$username_string = ($this->auth->acl_get('u_viewprofile')) ? $user_avatar . get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']) : $user_avatar . get_username_string('no_profile', $row['user_id'], $row['username'], $row['user_colour']);
++-			if ($this->relativedates !== null)
++-			{
++-				$user_lastpost_time = $this->user->format_date($row['user_lastpost_time'], false, false, false);
++-			}
++-			else
++-			{
++-				$user_lastpost_time = $this->user->format_date($row['user_lastpost_time']);
++-			}
++-
++-			$this->template->assign_block_vars('top_five_active',[
++-				'S_SEARCH_ACTION'	=> append_sid("{$this->root_path}search.$this->php_ext", 'author_id=' . $row['user_id'] . '&amp;sr=posts'),
++-				'POSTS'	=> number_format($row['user_posts']),
++-				'USERNAME_FULL'	=> $username_string,
++-				'USER_LASTPOST_TIME'	=> $this->language->lang('USER_LASTPOST_TIME', $user_lastpost_time),
++-				'USER_FLAG'	=> !empty($row['user_flag']) ? $row['user_flag'] : '',
++-			]);
+++			$this->template->assign_block_vars('top_five_active',array(
+++				'S_SEARCH_ACTION'	=> append_sid("{$this->phpbb_root_path}search.$this->php_ext", 'author_id=' . $row['user_id'] . '&amp;sr=posts'),
+++				'POSTS' 			=> number_format($row['user_posts']),
+++				'USERNAME_FULL'		=> $username_string,
+++			));
++ 		}
++ 	}
++ 
++-	/**
++-	* Get the newest members
++-	*
++-	* @return 	null
++-	* @access 	public
++-	*/
++ 	public function newusers()
++ 	{
+++
++ 		$howmany = $this->howmany();
++ 		$sql_where = $this->ignore_users();
++ 
++-		$sql_where .= !empty($sql_where) ? ' AND u.user_inactive_reason = 0' : ' u.user_inactive_reason = 0';
+++		$sql_and = !empty($sql_where) ? ' AND user_inactive_reason = 0' : ' WHERE user_inactive_reason = 0';
++ 		// newest registered users
++ 		if (($newest_users = $this->cache->get('_top_five_newest_users')) === false)
++ 		{
++-			$newest_users = [];
+++			$newest_users = array();
++ 
++ 			// grab most recent registered users
++-			$sql_array = [
++-				'SELECT' => 'u.user_id, u.username, u.user_colour, u.user_regdate, u.user_avatar, u.user_avatar_width, u.user_avatar_height, u.user_avatar_type',
++-				'FROM' => [USERS_TABLE => 'u'],
++-				'WHERE' => $sql_where,
++-				'ORDER_BY' =>  'u.user_regdate DESC',
++-			];
++-			if ($this->nationalflags !== null)
++-			{
++-				$sql_array['SELECT'] .= ', u.user_flag';
++-			}
++-			$result = $this->db->sql_query_limit($this->db->sql_build_query('SELECT', $sql_array), $howmany);
+++			$sql = 'SELECT user_id, username, user_colour, user_regdate
+++				FROM ' . USERS_TABLE . '
+++				' . $sql_where . '
+++				' . $sql_and . '
+++				ORDER BY user_regdate DESC';
+++			$result = $this->db->sql_query_limit($sql, $howmany);
++ 
++ 			while ($row = $this->db->sql_fetchrow($result))
++ 			{
++-				$user_flag = '';
++-				// nationalflags installed?
++-				if (!empty($row['user_flag']))
++-				{
++-					$user_flag = $this->nationalflags->get_user_flag($row['user_flag'], 12);
++-				}
++-
++-				$newest_users[$row['user_id']] = [
+++				$newest_users[$row['user_id']] = array(
++ 					'user_id'				=> $row['user_id'],
++ 					'username'				=> $row['username'],
++ 					'user_colour'			=> $row['user_colour'],
++ 					'user_regdate'			=> $row['user_regdate'],
++-					'user_avatar'			=> $row['user_avatar'],
++-					'user_avatar_width'		=> $row['user_avatar_width'],
++-					'user_avatar_height'	=> $row['user_avatar_height'],
++-					'user_avatar_type'		=> $row['user_avatar_type'],
++-					'user_flag'				=> !empty($user_flag) ? $user_flag : '',
++-				];
+++				);
++ 			}
++ 			$this->db->sql_freeresult($result);
++ 
++@@ -416,27 +308,15 @@ class topfive
++ 
++ 		foreach ($newest_users as $row)
++ 		{
++-			$user_avatar = phpbb_get_user_avatar($row);
++-			$display_avatar = (!empty($this->config['top_five_avatars']) && $this->user->optionget('viewavatars') && !empty($user_avatar)) ? true : false;
++-
++-			$user_avatar = $display_avatar ? '<span class="topfive-avatar">' . $user_avatar . '</span>&nbsp;' : '';
++-
++-			$username_string = ($this->auth->acl_get('u_viewprofile')) ? $user_avatar . get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']) : $user_avatar . get_username_string('no_profile', $row['user_id'], $row['username'], $row['user_colour']);
+++			$username_string = ($this->auth->acl_get('u_viewprofile')) ? get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']) : get_username_string('no_profile', $row['user_id'], $row['username'], $row['user_colour']);
++ 
++-			$this->template->assign_block_vars('top_five_newest',[
+++			$this->template->assign_block_vars('top_five_newest',array(
++ 				'REG_DATE'			=> $this->user->format_date($row['user_regdate']),
++ 				'USERNAME_FULL'		=> $username_string,
++-				'USER_FLAG'			=> !empty($row['user_flag']) ? $row['user_flag'] : '',
++-			]);
+++			));
++ 		}
++ 	}
++ 
++-	/**
++-	* How many to display
++-	*
++-	* @return 	int 	$howmany
++-	* @access 	private
++-	*/
++ 	private function howmany()
++ 	{
++ 		$howmany = $this->config['top_five_how_many'];
++@@ -444,24 +324,18 @@ class topfive
++ 		return (int) $howmany;
++ 	}
++ 
++-	/**
++-	* Ignore users
++-	*
++-	* @return 	string 	$sql_where
++-	* @access 	private
++-	*/
++ 	private function ignore_users()
++ 	{
++ 		// an array of user types we dont' bother with
++-		$ignore_users = $ignore_founders = [];
+++		$ignore_users = $ignore_founders = array();
++ 		if ($this->config['top_five_ignore_inactive_users'])
++ 		{
++-			$ignore_users = [USER_IGNORE, USER_INACTIVE];
+++			$ignore_users = array(USER_IGNORE, USER_INACTIVE);
++ 		}
++ 
++ 		if ($this->config['top_five_ignore_founder'])
++ 		{
++-			$ignore_founders = [USER_FOUNDER];
+++			$ignore_founders = array(USER_FOUNDER);
++ 		}
++ 
++ 		$ignore_users = array_merge($ignore_users, $ignore_founders);
++@@ -470,28 +344,9 @@ class topfive
++ 		$sql_where = '';
++ 		if (sizeof($ignore_users))
++ 		{
++-			$sql_where = $this->db->sql_in_set('u.user_type', $ignore_users, true);
+++			$sql_where = 'WHERE ' . $this->db->sql_in_set('user_type', $ignore_users, true);
++ 		}
++-		$admin_mod_array = [];
++-		// quick check for forum moderators and administrators
++-		// some may not want to show them
++-		$show_admins_mods = $this->config['top_five_show_admins_mods'];
++ 
++-		if (!$show_admins_mods)
++-		{
++-			// grab all admins
++-			$admin_ary = $this->auth->acl_get_list(false, 'a_', false);
++-			$admin_ary = (!empty($admin_ary[0]['a_'])) ? $admin_ary[0]['a_'] : [];
++-
++-			//grab all mods
++-			$mod_ary = $this->auth->acl_get_list(false,'m_', false);
++-			$mod_ary = (!empty($mod_ary[0]['m_'])) ? $mod_ary[0]['m_'] : [];
++-			$admin_mod_array = array_unique(array_merge($admin_ary, $mod_ary));
++-			if (sizeof
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/event/listener.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\topfive/event/listener.php"
+index c809efb63..5821f4bd5 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/event/listener.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\topfive/event/listener.php"
+@@ -12,13 +12,6 @@ namespace rmcgirr83\topfive\event;
+ /**
+ * @ignore
+ */
+-use rmcgirr83\topfive\core\topfive;
+-use phpbb\config\config;
+-use phpbb\language\language;
+-use phpbb\template\template;
+-use phpbb\user;
+-use phpbb\controller\helper;
+-
+ use Symfony\Component\EventDispatcher\EventSubscriberInterface;
+ 
+ /**
+@@ -26,153 +19,51 @@ use Symfony\Component\EventDispatcher\EventSubscriberInterface;
+ */
+ class listener implements EventSubscriberInterface
+ {
+-	/* @var topfive */
+-	protected $topfive;
++	/* @var \rmcgirr83\topfive\core\topfive */
++	protected $functions;
+ 
+-	/** @var config */
++	/** @var \phpbb\config\config */
+ 	protected $config;
+ 
+-	/** @var language */
+-	protected $language;
+-
+-	/** @var template */
++	/** @var \phpbb\template\template */
+ 	protected $template;
+ 
+-	/** @var user */
++	/** @var \phpbb\user */
+ 	protected $user;
+ 
+-	/** @var helper */
+-	protected $helper;
+-
+-	/** @var string php_ext */
+-	protected $php_ext;
+-
+-	/* @var array topfive_constants */
+-	protected $topfive_constants;
+-
+-	public function __construct(
+-		topfive $topfive,
+-		config $config,
+-		language $language,
+-		template $template,
+-		user $user,
+-		helper $helper,
+-		string $php_ext,
+-		array $topfive_constants,
+-		\phpbb\collapsiblecategories\operator\operator $operator = null)
++	public function __construct(\rmcgirr83\topfive\core\topfive $functions, \phpbb\config\config $config, \phpbb\template\template $template, \phpbb\user $user)
+ 	{
+-		$this->topfive = $topfive;
++		$this->functions = $functions;
+ 		$this->config = $config;
+-		$this->language = $language;
+ 		$this->template = $template;
+ 		$this->user = $user;
+-		$this->helper = $helper;
+-		$this->php_ext = $php_ext;
+-		$this->topfive_constants = $topfive_constants;
+-		$this->operator = $operator;
+ 	}
+ 
+ 	static public function getSubscribedEvents()
+ 	{
+ 
+-		return [
+-			'core.acp_extensions_run_action_after'	=> 'acp_extensions_run_action_after',
+-			'core.index_modify_page_title'	=> 'index_page',
+-			'core.page_header' => 'entire_forum',
+-		];
+-	}
+-
+-	/* Display additional metdate in extension details
+-	*
+-	* @param $event			event object
+-	* @param return null
+-	* @access public
+-	*/
+-	public function acp_extensions_run_action_after($event)
+-	{
+-		if ($event['ext_name'] == 'rmcgirr83/topfive' && $event['action'] == 'details')
+-		{
+-			$this->language->add_lang('acp_topfive', $event['ext_name']);
+-			$this->template->assign_var('S_BUY_ME_A_BEER_TOPFIVE', true);
+-		}
++		return array(
++			'core.page_footer'	=> 'main',
++		);
+ 	}
+ 
+-	/* Display top five on index page
+-	*
+-	* @param $event			event object
+-	* @param return null
+-	* @access public
+-	*/
+-	public function index_page($event)
++	public function main($event)
+ 	{
+-		$should_display = in_array((int) $this->config['top_five_location'], [$this->topfive_constants['top_of_index'], $this->topfive_constants['bottom_of_index']]) ? true : false;
+-
+-		if (!$should_display)
++		if (!$this->config['top_five_active'])
+ 		{
+ 			return;
+ 		}
+ 
+ 		// add lang file
+-		$this->language->add_lang('topfive', 'rmcgirr83/topfive');
++		$this->user->add_lang_ext('rmcgirr83/topfive', 'topfive');
+ 
+-		$this->topfive->topposters();
+-		$this->topfive->newusers();
+-		$this->topfive->toptopics();
++		$this->functions->topposters();
++		$this->functions->newusers();
++		$this->functions->toptopics();
+ 
+-		if ($this->operator !== null)
+-		{
+-			$fid = 'topfive'; // can be any unique string to identify your extension's collapsible element
+-			$this->template->assign_vars([
+-				'S_TOPFIVE_HIDDEN' => $this->operator->is_collapsed($fid),
+-				'U_TOPFIVE_COLLAPSE_URL' => $this->operator->get_collapsible_link($fid),
+-			]);
+-		}
+-		$this->template->assign_vars([
++		$this->template->assign_vars(array(
++			'S_TOPFIVE'	=>	$this->config['top_five_active'],
+ 			'S_TOPFIVE_LOCATION'	=> $this->config['top_five_location'],
+-		]);
+-	}
+-
+-	/* Display top five on every page
+-	*
+-	* @param $event			event object
+-	* @param return null
+-	* @access public
+-	*/
+-	public function entire_forum($event)
+-	{
+-		$should_display = (in_array((int) $this->config['top_five_location'], [$this->topfive_constants['top_of_entire_forum'], $this->topfive_constants['bottom_of_entire_forum']]) && !$this->is_non_content_page($this->user->page['page_name'])) ? true : false;
+-
+-		if (!$should_display)
+-		{
+-			return;
+-		}
+-
+-		// add lang file
+-		$this->language->add_lang('topfive', 'rmcgirr83/topfive');
+-
+-		$this->topfive->topposters();
+-		$this->topfive->newusers();
+-		$this->topfive->toptopics();
+-
+-		$this->template->assign_vars([
+-			'S_TOPFIVE_LOCATION'	=> $this->config['top_five_location']
+-		]);
+-	}
+-
+-	/**
+-	 * Check if the given page name is designated as a non-content page.
+-	 *
+-	 * @param string $page_name
+-	 * @return bool True or false
+-	 */
+-	private function is_non_content_page($page_name)
+-	{
+-		return in_array($page_name, [
+-			'memberlist.' . $this->php_ext,
+-			'posting.' . $this->php_ext,
+-			'viewonline.' . $this->php_ext,
+-			'ucp.' . $this->php_ext,
+-			'mcp.' . $this->php_ext,
+-		]);
++		));
+ 	}
+ }
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/ext.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\topfive/ext.php"
+index bc8f2d3e7..f51579231 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/ext.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\topfive/ext.php"
+@@ -23,6 +23,6 @@ class ext extends \phpbb\extension\base
+ 	public function is_enableable()
+ 	{
+ 		$config = $this->container->get('config');
+-		return version_compare($config['version'], '3.3', '>=');
++		return version_compare($config['version'], '3.1.2', '>=');
+ 	}
+ }
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/language/en/acp/info_acp_topfive.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\topfive/language/en/acp/info_acp_topfive.php"
+index 703d7c494..8e22ad810 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/language/en/acp/info_acp_topfive.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\topfive/language/en/acp/info_acp_topfive.php"
+@@ -16,11 +16,32 @@ if (!defined('IN_PHPBB'))
+ 
+ if (empty($lang) || !is_array($lang))
+ {
+-	$lang = [];
++	$lang = array();
+ }
+ 
+-$lang = array_merge($lang, [
++$lang = array_merge($lang, array(
+ 	// ACP
+ 	'TF_ACP'		=> 'Top Five Extension',
++	'TF_ACTIVE'		=> 'Enabled',
++	'TF_TITLE'		=> 'Top Five Extension Settings',
++	'TF_VERSION'	=> 'Top Five Version',
++	'TOPFIVE_MOD'	=> 'Top Five',
+ 	'TF_CONFIG'		=> 'Settings',
+-]);
++	'TF_SELECT'		=> 'Top Five',
++	'TF_SAVED'		=> 'Changes Saved',
++	'TF_HOWMANY'	=> 'How Many',
++	'TF_HOWMANY_EXPLAIN'	=> 'How many would you like to display...minimum required is 5, maximum is 100',
++	'TF_IGNORE_USERS'		=> 'Ignore Inactive Users',
++	'TF_IGNORE_USERS_EXPLAIN'	=> 'Will exclude inactive users from the display in top posters and newest users',
++	'TF_IGNORE_FOUNDER'		=> 'Ignore Founder(s)',
++	'TF_IGNORE_FOUNDER_EXPLAIN'	=> 'Will exclude founders from the display in top posters and newest users',
++	'TF_LOCATION'	=> 'Location on forum',
++	'TF_LOCATION_EXPLAIN'	=> 'Where do you want the mod to display on the index page',
++	'TF_SHOW_ADMINS_MODS'	=> 'Include Admins and Mods',
++	'TF_SHOW_ADMINS_MODS_EXPLAIN'	=> 'Will display admins and mods in top posters',
++	'TOO_SMALL_TOP_FIVE_HOW_MANY'	=> 'The number to display value is too small.',
++	'TOO_LARGE_TOP_FIVE_HOW_MANY'	=> 'The number to display value is too large.',
++	'TOP_OF_FORUM'	=> 'Top of Forum',
++	'BOTTOM_OF_FORUM'	=> 'Bottom of Forum',
++
++));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/language/en/acp_topfive.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/language/en/acp_topfive.php"
+deleted file mode 100644
+index 0ee0f664a..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/language/en/acp_topfive.php"
++++ /dev/null
+@@ -1,56 +0,0 @@
+-<?php
+-/**
+-*
+-* topfive [English]
+-*
+-* @package language Top Five
+-* @copyright (c) 2014 RMcGirr83
+-* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+-*
+-*/
+-
+-if (!defined('IN_PHPBB'))
+-{
+-	exit;
+-}
+-
+-if (empty($lang) || !is_array($lang))
+-{
+-	$lang = [];
+-}
+-
+-$lang = array_merge($lang, [
+-	'TF_ACTIVE'		=> 'Enabled',
+-	'TF_AVATARS'	=> 'Avatars',
+-	'TF_AVATARS_EXPLAIN'	=> 'Choose yes or no to display users avatars',
+-	'TF_TITLE'		=> 'Top Five Extension Settings',
+-	'TOPFIVE_MOD'	=> 'Top Five',
+-	'TF_CONFIG'		=> 'Settings',
+-	'TF_SAVED'		=> 'Changes Saved',
+-	'TF_HOWMANY'	=> 'How Many',
+-	'TF_EXCLUDED'	=> 'Excluded forums',
+-	'TF_EXCLUDED_EXPLAIN'	=> 'Use CTRL/CMD and mouse click to choose or unchoose multiple forums<br><em>If you don&#39;t want to exclude a forum, either don&#39;t select any or unselect the ones you have chosen</em>',
+-
+-	'TF_HOWMANY_EXPLAIN'	=> 'How many would you like to display... minimum required is 5, maximum is 100',
+-	'TF_IGNORE_USERS'		=> 'Ignore Inactive Users',
+-	'TF_IGNORE_USERS_EXPLAIN'	=> 'Will exclude inactive users from the display in top posters and newest users',
+-	'TF_IGNORE_FOUNDER'		=> 'Ignore Founder(s)',
+-	'TF_IGNORE_FOUNDER_EXPLAIN'	=> 'Will exclude founders from the display in top posters and newest users',
+-	'TF_LOCATION'	=> 'Location on forum',
+-	'TF_LOCATION_EXPLAIN'	=> 'Where do you want the extension to display on the forum.<br><i>If you choose top or bottom of entire forum, the extension will only display on those pages that are considered content pages.</i>',
+-	'TF_SHOW_ADMINS_MODS'	=> 'Include Admins and Mods',
+-	'TF_SHOW_ADMINS_MODS_EXPLAIN'	=> 'Will display admins and mods in top posters',
+-	'TOO_SMALL_TOP_FIVE_HOW_MANY'	=> 'The number to display value is too small.',
+-	'TOO_LARGE_TOP_FIVE_HOW_MANY'	=> 'The number to display value is too large.',
+-	'TOP_OF_FORUM'	=> 'Top of index page',
+-	'BOTTOM_OF_FORUM'	=> 'Bottom of index page',
+-	'TOP_OF_ENTIRE_FORUM'	=> 'Top of entire forum',
+-	'BOTTOM_OF_ENTIRE_FORUM'	=> 'Bottom of entire forum',
+-	//Donation
+-	'PAYPAL_IMAGE_URL'          => 'https://www.paypalobjects.com/webstatic/en_US/i/btn/png/silver-pill-paypal-26px.png',
+-	'PAYPAL_ALT'                => 'Donate using PayPal',
+-	'BUY_ME_A_BEER_URL'         => 'https://paypal.me/RMcGirr83',
+-	'BUY_ME_A_BEER'				=> 'Buy me a beer for creating this extension',
+-	'BUY_ME_A_BEER_SHORT'		=> 'Make a donation for this extension',
+-	'BUY_ME_A_BEER_EXPLAIN'		=> 'This extension is completely free. It is a project that I spend my time on for the enjoyment and use of the phpBB community. If you enjoy using this extension, or if it has benefited your forum, please consider <a href="https://paypal.me/RMcGirr83" target="_blank" rel="noreferrer noopener">buying me a beer</a>. It would be greatly appreciated. <i class="fa fa-smile-o" style="color:green;font-size:1.5em;" aria-hidden="true"></i>',
+-]);
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/language/en/topfive.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\topfive/language/en/topfive.php"
+index 0a2f6eb0c..ea78eee99 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/language/en/topfive.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\topfive/language/en/topfive.php"
+@@ -17,7 +17,7 @@ if (!defined('IN_PHPBB'))
+ 
+ if (empty($lang) || !is_array($lang))
+ {
+-	$lang = [];
++	$lang = array();
+ }
+ 
+ // DEVELOPERS PLEASE NOTE
+@@ -32,11 +32,12 @@ if (empty($lang) || !is_array($lang))
+ // equally where a string contains only two placeholders which are used to wrap text
+ // in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
+ 
+-$lang = array_merge($lang, [
++$lang = array_merge($lang, array(
++	'TOP_FIVE'			=> 'Top Activity',
+ 	'NEWEST_TOPICS'		=> 'Newest Posts',
+ 	'NO_TOPIC_EXIST'	=> 'No posts exist for viewing',
+ 	'TOP_FIVE_ACTIVE'	=> 'Top Active Users',
+ 	'TOP_FIVE_NEWEST'	=> 'Newest Users',
+-	'BY'                => 'by&nbsp;',
+-	'USER_LASTPOST_TIME'	=> 'Last Post: %s',
+-]);
++	'IN'                => 'In',
++	'BY'                => 'by:',
++));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/migrations/top_five_v111.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/migrations/top_five_v111.php"
+deleted file mode 100644
+index 815c1fdff..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/migrations/top_five_v111.php"
++++ /dev/null
+@@ -1,25 +0,0 @@
+-<?php
+-/**
+-*
+-* @package Top Five
+-* @copyright (c) 2015 Rich Mcgirr (RMcGirr83)
+-* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+-*
+-*/
+-
+-namespace rmcgirr83\topfive\migrations;
+-
+-class top_five_v111 extends \phpbb\db\migration\migration
+-{
+-	static public function depends_on()
+-	{
+-		return array('\rmcgirr83\topfive\migrations\top_five_v14');
+-	}
+-
+-	public function update_data()
+-	{
+-		return array(
+-			array('config.add', array('top_five_avatars', 0)),
+-		);
+-	}
+-}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/migrations/top_five_v123.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/migrations/top_five_v123.php"
+deleted file mode 100644
+index 299e61205..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/migrations/top_five_v123.php"
++++ /dev/null
+@@ -1,34 +0,0 @@
+-<?php
+-/**
+-*
+-* @package Top Five
+-* @copyright (c) 2015 Rich Mcgirr (RMcGirr83)
+-* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+-*
+-*/
+-
+-namespace rmcgirr83\topfive\migrations;
+-
+-class top_five_v123 extends \phpbb\db\migration\migration
+-{
+-	static public function depends_on()
+-	{
+-		return ['\rmcgirr83\topfive\migrations\top_five_v111'];
+-	}
+-
+-	public function update_data()
+-	{
+-		return [
+-			['module.remove', ['acp', false, 'TF_CONFIG']],
+-			['module.add', [
+-				'acp',
+-				'TF_ACP',
+-				[
+-					'module_basename'	=> '\rmcgirr83\topfive\acp\topfive_module',
+-					'auth'				=> 'ext_rmcgirr83/topfive && acl_a_extensions',
+-					'modes'				=> ['settings'],
+-				],
+-			]],
+-		];
+-	}
+-}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/migrations/top_five_v125.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/migrations/top_five_v125.php"
+deleted file mode 100644
+index 366cfda08..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/migrations/top_five_v125.php"
++++ /dev/null
+@@ -1,25 +0,0 @@
+-<?php
+-/**
+-*
+-* @package Top Five
+-* @copyright (c) 2015 Rich Mcgirr (RMcGirr83)
+-* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+-*
+-*/
+-
+-namespace rmcgirr83\topfive\migrations;
+-
+-class top_five_v125 extends \phpbb\db\migration\migration
+-{
+-	static public function depends_on()
+-	{
+-		return ['\rmcgirr83\topfive\migrations\top_five_v123'];
+-	}
+-
+-	public function update_data()
+-	{
+-		return [
+-			['config.update', ['top_five_active', 1]],
+-		];
+-	}
+-}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/migrations/top_five_v126.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/migrations/top_five_v126.php"
+deleted file mode 100644
+index eb030420e..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/migrations/top_five_v126.php"
++++ /dev/null
+@@ -1,25 +0,0 @@
+-<?php
+-/**
+-*
+-* @package Top Five
+-* @copyright (c) 2024 Rich Mcgirr (RMcGirr83)
+-* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+-*
+-*/
+-
+-namespace rmcgirr83\topfive\migrations;
+-
+-class top_five_v126 extends \phpbb\db\migration\migration
+-{
+-	static public function depends_on()
+-	{
+-		return ['\rmcgirr83\topfive\migrations\top_five_v125'];
+-	}
+-
+-	public function update_data()
+-	{
+-		return [
+-			['config.remove', ['top_five_active']],
+-		];
+-	}
+-}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/migrations/top_five_v13.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/migrations/top_five_v13.php"
+deleted file mode 100644
+index 302c891ec..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/migrations/top_five_v13.php"
++++ /dev/null
+@@ -1,31 +0,0 @@
+-<?php
+-/**
+-*
+-* @package Top Five
+-* @copyright (c) 2015 RMcGirr83
+-* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+-*
+-*/
+-
+-namespace rmcgirr83\topfive\migrations;
+-
+-class top_five_v13 extends \phpbb\db\migration\migration
+-{
+-	public function effectively_installed()
+-	{
+-		return isset($this->config['top_five_version']) && version_compare($this->config['top_five_version'], '1.0.3', '>=');
+-	}
+-
+-	static public function depends_on()
+-	{
+-		return array('\rmcgirr83\topfive\migrations\top_five_v12');
+-	}
+-
+-	public function update_data()
+-	{
+-		return array(
+-			array('config.update', array('top_five_version', '1.0.3')),
+-			array('config.add', array('top_five_excluded', 0)),
+-		);
+-	}
+-}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/migrations/top_five_v14.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/migrations/top_five_v14.php"
+deleted file mode 100644
+index 6973c212b..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/migrations/top_five_v14.php"
++++ /dev/null
+@@ -1,25 +0,0 @@
+-<?php
+-/**
+-*
+-* @package Top Five
+-* @copyright (c) 2015 Rich Mcgirr (RMcGirr83)
+-* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+-*
+-*/
+-
+-namespace rmcgirr83\topfive\migrations;
+-
+-class top_five_v14 extends \phpbb\db\migration\migration
+-{
+-	static public function depends_on()
+-	{
+-		return array('\rmcgirr83\topfive\migrations\top_five_v13');
+-	}
+-
+-	public function update_data()
+-	{
+-		return array(
+-			array('config.remove', array('top_five_version')),
+-		);
+-	}
+-}
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\topfive/styles/BBOOTS/template/event/recent_topics_body.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\topfive/styles/BBOOTS/template/event/recent_topics_body.html"
+new file mode 100644
+index 000000000..d9345da55
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\topfive/styles/BBOOTS/template/event/recent_topics_body.html"
+@@ -0,0 +1,3 @@
++<!-- IF S_TOPFIVE and not S_TOPFIVE_LOCATION -->
++	<!-- INCLUDE topfive_body.html -->
++<!-- ENDIF -->
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\topfive/styles/BBOOTS/template/topfive_body.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\topfive/styles/BBOOTS/template/topfive_body.html"
+new file mode 100644
+index 000000000..4139dc116
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\topfive/styles/BBOOTS/template/topfive_body.html"
+@@ -0,0 +1,10 @@
++<!-- BEGIN top_five_topic -->
++<div class="recent-topic text-overflow">
++	<a href="#" class="blogImage" title="">{top_five_topic.TOP5_AVATAR}</a>
++	<!-- IF top_five_topic.NO_TOPIC_TITLE-->{top_five_topic.NO_TOPIC_TITLE}<!-- ELSE -->
++	<a href="{top_five_topic.U_TOPIC}" title="{top_five_topic.TOPIC_TITLE}"><i class="fa fa-mail-forward text-muted"></i> {top_five_topic.TOPIC_TITLE}</a>
++	<p><i class="fa fa-user"></i> {top_five_topic.USERNAME_FULL}</p>
++	<p><i class="fa fa-clock-o"></i> {top_five_topic.LAST_TOPIC_TIME}</p>
++	 <!-- ENDIF -->
++</div>
++<!-- END top_five_topic -->
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/styles/prosilver/template/event/index_body_forumlist_body_after.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/styles/prosilver/template/event/index_body_forumlist_body_after.html"
+deleted file mode 100644
+index 98c7ad3ae..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/styles/prosilver/template/event/index_body_forumlist_body_after.html"
++++ /dev/null
+@@ -1,3 +0,0 @@
+-{% if S_TOPFIVE_LOCATION == 1 %}
+-	{% INCLUDE '@rmcgirr83_topfive/topfive_body.html' %}
+-{% endif %}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/styles/prosilver/template/event/index_body_markforums_after.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/styles/prosilver/template/event/index_body_markforums_after.html"
+deleted file mode 100644
+index e4cad34d5..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/styles/prosilver/template/event/index_body_markforums_after.html"
++++ /dev/null
+@@ -1,3 +0,0 @@
+-{% if S_TOPFIVE_LOCATION == 0 %}
+-	{% INCLUDE '@rmcgirr83_topfive/topfive_body.html' %}
+-{% endif %}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/styles/prosilver/template/event/overall_footer_content_after.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/styles/prosilver/template/event/overall_footer_content_after.html"
+deleted file mode 100644
+index 30126369b..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/styles/prosilver/template/event/overall_footer_content_after.html"
++++ /dev/null
+@@ -1,3 +0,0 @@
+-{% if S_TOPFIVE_LOCATION == 3 %}
+-	{% INCLUDE '@rmcgirr83_topfive/topfive_body.html' %}
+-{% endif %}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/styles/prosilver/template/event/overall_header_content_before.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/styles/prosilver/template/event/overall_header_content_before.html"
+deleted file mode 100644
+index eae255cdb..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/styles/prosilver/template/event/overall_header_content_before.html"
++++ /dev/null
+@@ -1,3 +0,0 @@
+-{% if S_TOPFIVE_LOCATION == 2 %}
+-	{% INCLUDE '@rmcgirr83_topfive/topfive_body.html' %}
+-{% endif %}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/styles/prosilver/template/event/overall_header_head_append.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/styles/prosilver/template/event/overall_header_head_append.html"
+deleted file mode 100644
+index 5cb14c0f6..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/styles/prosilver/template/event/overall_header_head_append.html"
++++ /dev/null
+@@ -1 +0,0 @@
+-{% INCLUDECSS '@rmcgirr83_topfive/topfive.css' %}
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/styles/prosilver/template/topfive_body.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/styles/prosilver/template/topfive_body.html"
+deleted file mode 100644
+index 651faf88f..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/styles/prosilver/template/topfive_body.html"
++++ /dev/null
+@@ -1,57 +0,0 @@
+-<a class="category{% if S_TOPFIVE_HIDDEN %} hidden-category{% endif %}" style="display: none; height: 0"></a>
+-<div class="forabg" id="top_five">
+-	<div class="inner">
+-	<ul class="topiclist">
+-		<li class="header">
+-			<dl class="row-item">
+-				<dt><div class="list-inner">{{ lang('NEWEST_TOPICS') }}</div></dt>
+-				<dd class="topics tf-active-header">{{ lang('TOP_FIVE_ACTIVE') }}</dd>
+-				<dd class="lastpost"><span>{{ lang('TOP_FIVE_NEWEST') }}</span></dd>
+-			</dl>
+-			{% if U_TOPFIVE_COLLAPSE_URL %}<a href="{{ U_TOPFIVE_COLLAPSE_URL }}" class="collapse-btn collapse-{% if S_TOPFIVE_HIDDEN %}show{% else %}hide{% endif %}" data-hidden="{{ S_TOPFIVE_HIDDEN }}" data-ajax="phpbb_collapse" data-overlay="true" title="{{ lang('COLLAPSIBLE_CATEGORIES_TITLE') }}" style="display: none; line-height: 0;"></a>{% endif %}
+-		</li>
+-	</ul>
+-	<ul class="topiclist forums">
+-		<li class="row">
+-			<dl>
+-				<dt>
+-					<div class="list-inner">
+-						<ul>
+-							{% for top_five_topic in loops.top_five_topic %}
+-								<li class="top_five">
+-									{% if top_five_topic.NO_TOPIC_TITLE%}
+-										{{ top_five_topic.NO_TOPIC_TITLE }}
+-									{% else %}
+-										<a href="{{ top_five_topic.U_TOPIC }}" class="topictitle subforum{% if top_five_topic.S_UNREAD %} unread{% else %} read{% endif %}">
+-											<i class="icon fa-file-o fa-fw {% if top_five_topic.S_UNREAD %} icon-red{% else %} icon-blue{% endif %} icon-md" aria-hidden="true"></i>
+-											{{ top_five_topic.TOPIC_TITLE }}</a><span class="meta">{{ top_five_topic.USERNAME_FULL }} {% if top_five_topic.USER_FLAG %} {{ top_five_topic.USER_FLAG }} {% endif %}&raquo; {{ top_five_topic.LAST_TOPIC_TIME }} &raquo; {{ lang('IN') }}&nbsp;<a href="{{ top_five_topic.U_FORUM }}">{{ top_five_topic.FORUM_NAME }}</a></span>
+-										{% EVENT rmcgirr83_top_five_topiclist_row_append %}
+-									{% endif %}
+-								</li>
+-							{% endfor %}
+-						</ul>
+-					</div>
+-				</dt>
+-				<dd class="topics tf-most-active">
+-					<ul>
+-						{% for top_five_active in loops.top_five_active %}
+-							<li>
+-								<span class="meta">{{ top_five_active.USERNAME_FULL }} {% if top_five_active.USER_FLAG %} {{ top_five_active.USER_FLAG }} {% endif %}<span><br>&nbsp;&nbsp;{{ lang('POSTS') }}{{ lang('COLON') }} <a href="{{ top_five_active.S_SEARCH_ACTION }}" title="{{ top_five_active.USER_LASTPOST_TIME }}">{{ top_five_active.POSTS }}</a></span></span>
+-							</li>
+-						{% endfor %}
+-					</ul>
+-				</dd>
+-				<dd class="lastpost tf-newest"><span>
+-					<ul>
+-						{% for top_five_newest in loops.top_five_newest %}
+-							<li>
+-								<span class="meta">{{ top_five_newest.USERNAME_FULL }}{% if top_five_newest.USER_FLAG %} {{ top_five_newest.USER_FLAG }} {% endif %}<span><br>&nbsp;&nbsp;{{ lang('JOINED') }}{{ lang('COLON') }} {{ top_five_newest.REG_DATE }}</span></span>
+-							</li>
+-						{% endfor %}
+-					</ul>
+-				</span></dd>
+-			</dl>
+-		</li>
+-	</ul>
+-	</div>
+-</div>
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/styles/prosilver/theme/topfive.css" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/styles/prosilver/theme/topfive.css"
+deleted file mode 100644
+index 4d339e5c0..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/styles/prosilver/theme/topfive.css"
++++ /dev/null
+@@ -1,81 +0,0 @@
+-dd.tf-most-active {
+-	font-size: 1.2em;
+-	line-height: 1.2em;
+-	text-align: left;
+-	width: 185px;
+-}
+-
+-.rtl dd.tf-most-active  {
+-	text-align: right;
+-}
+-
+-dd.tf-newest {
+-	font-size: 1.2em;	
+-	line-height: 1.2em;
+-	text-align: left;
+-}
+-
+-.rtl dd.tf-newest {
+-	text-align: right;
+-}
+-
+-dd.tf-active-header {
+-	width: 185px;
+-	text-align:left;
+-}
+-
+-.rtl dd.tf-active-header {
+-	text-align:right;
+-}
+-
+-#top_five ul {
+-	list-style-type: none;
+-}
+-
+-#top_five li {
+-	padding: 2px 0;
+-}
+-
+-#top_five li:first-child {
+-	padding-top: 0;
+-}
+-
+-#top_five li:last-child {
+-	padding-bottom: 0;
+-}
+-
+-#top_five .meta {
+-	display: block;
+-	padding-left: 8px;
+-}
+-
+-.rtl #top_five {
+-	text-align: right;
+-}
+-
+-.rtl #top_five .meta {
+-	padding-left: 0;
+-	padding-right: 8px;
+-}
+-
+-#top_five ul.topiclist li.row a.subforum {
+-	white-space: normal;
+-}
+-
+-@media only screen and (max-width: 970px) {
+-	#top_five {
+-		display: none;
+-	}
+-}
+-
+-/* Fixes avatar aspect-ratio */
+-#top_five .topfive-avatar img { 
+-	max-height: 20px;
+-    vertical-align: middle;
+-    width: auto;
+-}
+-
+-/* fixes national flags position */
+-.top_five .flag_image {
+-  vertical-align: middle;
+-}
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/styles/scaffoldBB/template/event/index_body_forumlist_body_after.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/styles/scaffoldBB/template/event/index_body_forumlist_body_after.html"
+deleted file mode 100644
+index 98c7ad3ae..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/styles/scaffoldBB/template/event/index_body_forumlist_body_after.html"
++++ /dev/null
+@@ -1,3 +0,0 @@
+-{% if S_TOPFIVE_LOCATION == 1 %}
+-	{% INCLUDE '@rmcgirr83_topfive/topfive_body.html' %}
+-{% endif %}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/styles/scaffoldBB/template/event/index_body_markforums_after.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/styles/scaffoldBB/template/event/index_body_markforums_after.html"
+deleted file mode 100644
+index e4cad34d5..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/styles/scaffoldBB/template/event/index_body_markforums_after.html"
++++ /dev/null
+@@ -1,3 +0,0 @@
+-{% if S_TOPFIVE_LOCATION == 0 %}
+-	{% INCLUDE '@rmcgirr83_topfive/topfive_body.html' %}
+-{% endif %}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/styles/scaffoldBB/template/event/overall_footer_page_body_after.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/styles/scaffoldBB/template/event/overall_footer_page_body_after.html"
+deleted file mode 100644
+index 30126369b..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/styles/scaffoldBB/template/event/overall_footer_page_body_after.html"
++++ /dev/null
+@@ -1,3 +0,0 @@
+-{% if S_TOPFIVE_LOCATION == 3 %}
+-	{% INCLUDE '@rmcgirr83_topfive/topfive_body.html' %}
+-{% endif %}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/styles/scaffoldBB/template/event/overall_header_content_before.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/styles/scaffoldBB/template/event/overall_header_content_before.html"
+deleted file mode 100644
+index eae255cdb..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/styles/scaffoldBB/template/event/overall_header_content_before.html"
++++ /dev/null
+@@ -1,3 +0,0 @@
+-{% if S_TOPFIVE_LOCATION == 2 %}
+-	{% INCLUDE '@rmcgirr83_topfive/topfive_body.html' %}
+-{% endif %}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/styles/scaffoldBB/template/event/overall_header_head_append.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/styles/scaffoldBB/template/event/overall_header_head_append.html"
+deleted file mode 100644
+index fb88b4a3a..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/styles/scaffoldBB/template/event/overall_header_head_append.html"
++++ /dev/null
+@@ -1,3 +0,0 @@
+-{% if S_TOPFIVE %}
+-	{% INCLUDECSS '@rmcgirr83_topfive/topfive.css' %}
+-{% endif %}
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/styles/scaffoldBB/template/topfive_body.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/styles/scaffoldBB/template/topfive_body.html"
+deleted file mode 100644
+index 9f9a5f410..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/styles/scaffoldBB/template/topfive_body.html"
++++ /dev/null
+@@ -1,45 +0,0 @@
+-<a class="category{% if S_TOPFIVE_HIDDEN %} hidden-category{% endif %}" style="display: none; height: 0"></a>
+-<div class="bg-gradient bg-primary forabg mb-3 rounded-3 py-1 px-2 d-none d-md-block {% if S_TOPFIVE_LOCATION == 3 %}mx-md-3{% endif %}" id="top_five">
+-	<ul class="header row gx-0 list-unstyled my-1">
+-		<li class="col-7 fw-bold text-uppercase text-white text-decoration-none"><div class="list-inner">{{ lang('NEWEST_TOPICS') }}</div></li>
+-		<li class="topics col-2 text-white tf-active-header text-uppercase">{{ lang('TOP_FIVE_ACTIVE') }}</li>
+-		<li class="lastpost col-3 text-white text-uppercase"><span>{{ lang('TOP_FIVE_NEWEST') }}</span></li>
+-	</ul>
+-	{% if U_TOPFIVE_COLLAPSE_URL %}<a href="{{ U_TOPFIVE_COLLAPSE_URL }}" class="collapse-btn " data-hidden="{{ S_TOPFIVE_HIDDEN }}" data-ajax="phpbb_collapse" data-overlay="true" title="{{ lang('COLLAPSIBLE_CATEGORIES_TITLE') }}" style="display: none; line-height: 0;"></a>{% endif %}
+-	<ul class="bg-body topiclist forums list-unstyled mb-1 row gx-0 p-2">
+-		<li class="col-7">
+-			<ul class="list-unstyled">
+-				{% for top_five_topic in loops.top_five_topic %}
+-					<li>
+-						{% if top_five_topic.NO_TOPIC_TITLE%}
+-							{{ top_five_topic.NO_TOPIC_TITLE }}
+-						{% else %}
+-							<a href="{{ top_five_topic.U_TOPIC }}" class="text-decoration-none topictitle subforum{% if top_five_topic.S_UNREAD %} unread{% else %} read{% endif %}">
+-								<i class="icon fa fa-file-o fa-fw {% if top_five_topic.S_UNREAD %} icon-red{% else %} icon-blue{% endif %} icon-md" aria-hidden="true"></i>
+-								{{ top_five_topic.TOPIC_TITLE }}</a><span class="meta d-block ps-2">{{ top_five_topic.USERNAME_FULL }} &raquo; {{ top_five_topic.LAST_TOPIC_TIME }} &raquo; {{ lang('IN') }}&nbsp;<a class="text-decoration-none" href="{{ top_five_topic.U_FORUM }}">{{ top_five_topic.FORUM_NAME }}</a></span>
+-							{% EVENT rmcgirr83_top_five_topiclist_row_append %}
+-						{% endif %}
+-					</li>
+-				{% endfor %}
+-			</ul>
+-		</li>
+-		<li class="col-2 topics tf-most-active border-start border-end">
+-			<ul class="list-unstyled">
+-				{% for top_five_active in loops.top_five_active %}
+-					<li>
+-						<span class="meta d-block ps-2">{{ top_five_active.USERNAME_FULL }}<span><br />&nbsp;&nbsp;{{ lang('POSTS') }}{{ lang('COLON') }} <a class="text-decoration-none" href="{{ top_five_active.S_SEARCH_ACTION }}">{{ top_five_active.POSTS }}</a></span></span>
+-					</li>
+-				{% endfor %}
+-			</ul>
+-		</li>
+-		<li class="col-3 lastpost tf-newest">
+-			<ul class="list-unstyled">
+-				{% for top_five_newest in loops.top_five_newest %}
+-					<li>
+-						<span class="meta d-block ps-2">{{ top_five_newest.USERNAME_FULL }}<span><br />&nbsp;&nbsp;{{ lang('JOINED') }}{{ lang('COLON') }} {{ top_five_newest.REG_DATE }}</span></span>
+-					</li>
+-				{% endfor %}
+-			</ul>
+-		</li>
+-	</ul>
+-</div>
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/styles/scaffoldBB/theme/topfive.css" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/styles/scaffoldBB/theme/topfive.css"
+deleted file mode 100644
+index 59755b122..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/styles/scaffoldBB/theme/topfive.css"
++++ /dev/null
+@@ -1,7 +0,0 @@
+-
+-/* Fixes avatar aspect-ratio */
+-#top_five .topfive-avatar img { 
+-	max-height: 20px;
+-    vertical-align: middle;
+-    width: auto;
+-}
+\ No newline at end of file
diff --git "[FORUM_EXT]/rmcgirr83\\topfive/diff_nospace.tmp" "[FORUM_EXT]/rmcgirr83\\topfive/diff_nospace.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/rmcgirr83\\topfive/diff_nospace.tmp"
@@ -0,0 +1,4319 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/acp/topfive_info.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\topfive/acp/topfive_info.php"
+index 591b4fa8f..c0f748d31 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/acp/topfive_info.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\topfive/acp/topfive_info.php"
+@@ -19,9 +19,9 @@ class topfive_info
+ 		return array(
+ 			'filename'	=> '\rmcgirr83\topfive\acp\topfive_module',
+ 			'title'		=> 'TF_ACP',
+-			'version'	=> '1.2.3',
++			'version'	=> '1.0.0',
+ 			'modes'		=> array(
+-				'settings'	=> array('title' => 'TF_CONFIG', 'auth'	=> 'ext_rmcgirr83/topfive && acl_a_extensions' , 'cat'	=> array('TOPFIVE_MOD')),
++				'settings'	=> array('title' => 'TF_CONFIG', 'auth'	=> 'ext_rmcgirr83/topfive', 'cat'	=> array('TOPFIVE_MOD')),
+ 			),
+ 		);
+ 	}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/acp/topfive_module.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\topfive/acp/topfive_module.php"
+index 3cc28d045..c1801a315 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/acp/topfive_module.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\topfive/acp/topfive_module.php"
+@@ -11,21 +11,67 @@ namespace rmcgirr83\topfive\acp;
+ 
+ class topfive_module
+ {
+-	public $u_action;
++	var $u_action;
+ 
+ 	function main($id, $mode)
+ 	{
+-		global $phpbb_container;
++		global $db, $user, $auth, $template, $cache, $request;
++		global $config, $phpbb_root_path, $phpbb_admin_path, $phpEx;
+ 
++		$this->config = $config;
++		$this->request = $request;
++
++		$user->add_lang('acp/common');
++		$user->add_lang_ext('rmcgirr83/topfive', 'acp/info_acp_topfive');
+ 		$this->tpl_name = 'acp_topfive';
+-		$this->page_title = $phpbb_container->get('language')->lang('TF_ACP');
++		$this->page_title = $user->lang['TOPFIVE_MOD'];
++		add_form_key('acp_topfive');
++
++		if ($request->is_set_post('submit'))
++		{
++			if (!check_form_key('acp_topfive'))
++			{
++				trigger_error('FORM_INVALID');
++			}
++			if (!function_exists('validate_data'))
++			{
++				include($phpbb_root_path . 'includes/functions_user.' . $phpEx);
++			}
+ 
+-		// Get an instance of the admin controller
+-		$admin_controller = $phpbb_container->get('rmcgirr83.topfive.admin.controller');
++			$check_row = array('top_five_how_many' => $request->variable('top_five_how_many', 0));
++			$validate_row = array('top_five_how_many' => array('num', false, 5, 100));
++			$error = validate_data($check_row, $validate_row);
++
++			// Replace "error" strings with their real, localised form
++			$error = array_map(array($user, 'lang'), $error);
++
++			if (!sizeof($error))
++			{
++				$config->set('top_five_how_many', $request->variable('top_five_how_many', 0));
++				$config->set('top_five_ignore_inactive_users', $request->variable('top_five_ignore_inactive_users', true));
++				$config->set('top_five_ignore_founder', $request->variable('top_five_ignore_founder', true));
++				$config->set('top_five_show_admins_mods', $request->variable('top_five_show_admins_mods', true));
++				$config->set('top_five_location', $request->variable('top_five_location', true));
++				$config->set('top_five_active', $request->variable('top_five_active', true));
++
++				$cache->destroy('_top_five_newest_users');
++				$cache->destroy('_top_five_posters');
++
++				trigger_error($user->lang['TF_SAVED'] . adm_back_link($this->u_action));
++			}
++		}
+ 
+-		// Make the $u_action url available in the admin controller
+-		$admin_controller->set_page_url($this->u_action);
++		$template->assign_vars(array(
++			'TF_ERROR'			=> isset($error) ? ((sizeof($error)) ? implode('<br />', $error) : '') : '',
++			'HOWMANY'			=> (!empty($this->config['top_five_how_many'])) ? $this->config['top_five_how_many'] : 0,
++			'IGNORE_INACTIVE'	=> (!empty($this->config['top_five_ignore_inactive_users'])) ? true : false,
++			'IGNORE_FOUNDER'	=> (!empty($this->config['top_five_ignore_founder'])) ? true : false,
++			'SHOW_ADMINS_MODS'	=> (!empty($this->config['top_five_show_admins_mods'])) ? true : false,
++			'LOCATION'			=> (!empty($this->config['top_five_location'])) ? true : false,
++			'ACTIVE'			=> (!empty($this->config['top_five_active'])) ? true : false,
++			'TF_VERSION'		=> $this->config['top_five_version'],
+ 
+-		$admin_controller->display_options();
++			'U_ACTION'			=> $this->u_action,
++		));
+ 	}
+ }
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/adm/style/acp_topfive.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\topfive/adm/style/acp_topfive.html"
+index 48224526d..f799a7138 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/adm/style/acp_topfive.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\topfive/adm/style/acp_topfive.html"
+@@ -1,60 +1,51 @@
+-{% INCLUDE 'overall_header.html' %}
++<!-- INCLUDE overall_header.html -->
+ 
+-<h1>{{ lang('TF_TITLE') }}</h1>
+-<fieldset>
+-	<legend>{{ lang('BUY_ME_A_BEER') }}</legend>
+-	<dl>
+-		<dt><label>{{ lang('BUY_ME_A_BEER_SHORT') }}{{ lang('COLON') }}</label><br /><span>{{ lang('BUY_ME_A_BEER_EXPLAIN') }}</span></dt>
+-		<dd><a href="{{ lang('BUY_ME_A_BEER_URL') }}" target="_blank" rel="noreferrer noopener"><img src="{{ lang('PAYPAL_IMAGE_URL') }}" border="0" alt="{{ lang('PAYPAL_ALT') }}" style="cursor:pointer;margin-top:15px;"></a></dd>
+-	</dl>
+-</fieldset>
+-{% if TF_ERROR %}
+-	<div class="errorbox"><h3>{{ lang('WARNING') }}</h3>
+-		<p>{{ TF_ERROR }}</p>
++<h1>{L_TF_TITLE}</h1>
++<p>{L_TF_VERSION} {TF_VERSION}</p>
++
++<!-- IF TF_ERROR -->
++	<div class="errorbox"><h3>{L_WARNING}</h3>
++		<p>{TF_ERROR}</p>
+ 	</div>
+-{% endif %}
++<!-- ENDIF -->
+ 
+-<form id="acp_topfive" method="post" action="{{ U_ACTION }}">
++<form id="acp_topfive" method="post" action="{U_ACTION}">
+ 	<fieldset>
+-		<legend>{{ lang('TF_CONFIG') }}</legend>
+-		<dl>
+-			<dt><label>{{ lang('TF_LOCATION') ~ lang('COLON') }}</label><br>
+-			<span>{{ lang('TF_LOCATION_EXPLAIN') }}</span></dt>
+-			<dd><select name="top_five_location">{{ LOCATION }}</select></dd>
+-		</dl>
++		<legend>{L_TF_CONFIG}</legend>
+ 		<dl>
+-			<dt><label>{{ lang('TF_AVATARS') }}</label><br />{{ lang('TF_AVATARS_EXPLAIN') }}</dt>
+-			<dd><input type="radio" class="radio" name="top_five_avatars" value="1" {% if AVATARS %}checked="checked"{% endif %}/> {{ lang('YES') }} &nbsp;
+-				<input type="radio" class="radio" name="top_five_avatars" value="0" {% if not AVATARS %}checked="checked"{% endif %} /> {{ lang('NO') }}</dd>
++			<dt><label id="top_five_active" for="top_five_active">{L_TF_ACTIVE}</label></dt>
++			<dd><input type="radio" class="radio" name="top_five_active" value="1" <!-- IF ACTIVE -->checked="checked"<!-- ENDIF -->/> {L_YES} &nbsp;
++				<input type="radio" class="radio" name="top_five_active" value="0" <!-- IF not ACTIVE -->checked="checked"<!-- ENDIF --> /> {L_NO}</dd>
+ 		</dl>
+ 		<dl>
+-			<dt><label>{{ lang('TF_HOWMANY') }}</label><br />{{ lang('TF_HOWMANY_EXPLAIN') }}</dt>
+-			<dd><input type="number" name="top_five_how_many" size="10" min="5" max="100" value="{{ HOWMANY }}" /></dd>
++			<dt><label id="top_five_location" for="top_five_location">{L_TF_LOCATION}</label><br />{L_TF_LOCATION_EXPLAIN}</dt>
++			<dd><input type="radio" class="radio" name="top_five_location" value="1" <!-- IF LOCATION -->checked="checked"<!-- ENDIF -->/> {L_TOP_OF_FORUM} &nbsp;
++				<input type="radio" class="radio" name="top_five_location" value="0" <!-- IF not LOCATION -->checked="checked"<!-- ENDIF --> /> {L_BOTTOM_OF_FORUM}</dd>
+ 		</dl>
+ 		<dl>
+-			<dt><label>{{ lang('TF_EXCLUDED') ~ lang('COLON') }}</label><br /><span>{{ lang('TF_EXCLUDED_EXPLAIN') }}</span></dt>
+-			<dd>{{ TF_EXCLUDED }}</dd>
++			<dt><label id="top_five_how_many" for="top_five_how_many">{L_TF_HOWMANY}</label><br />{L_TF_HOWMANY_EXPLAIN}</dt>
++			<dd><input type="text" name="top_five_how_many" id="top_five_how_many" size="10" value="{HOWMANY}" /></dd>
+ 		</dl>
+ 		<dl>
+-			<dt><label>{{ lang('TF_IGNORE_USERS') }}</label><br />{{ lang('TF_IGNORE_USERS_EXPLAIN') }}</dt>
+-			<dd><input type="radio" class="radio" name="top_five_ignore_inactive_users" value="1" {% if IGNORE_INACTIVE %}checked="checked"{% endif %}/> {{ lang('YES') }} &nbsp;
+-				<input type="radio" class="radio" name="top_five_ignore_inactive_users" value="0" {% if not IGNORE_INACTIVE %}checked="checked"{% endif %} /> {{ lang('NO') }}</dd>
++			<dt><label id="top_five_ignore_inactive_users" for="top_five_ignore_inactive_users">{L_TF_IGNORE_USERS}</label><br />{L_TF_IGNORE_USERS_EXPLAIN}</dt>
++			<dd><input type="radio" class="radio" name="top_five_ignore_inactive_users" value="1" <!-- IF IGNORE_INACTIVE -->checked="checked"<!-- ENDIF -->/> {L_YES} &nbsp;
++				<input type="radio" class="radio" name="top_five_ignore_inactive_users" value="0" <!-- IF not IGNORE_INACTIVE -->checked="checked"<!-- ENDIF --> /> {L_NO}</dd>
+ 		</dl>
+ 		<dl>
+-			<dt><label>{{ lang('TF_IGNORE_FOUNDER') }}</label><br />{{ lang('TF_IGNORE_FOUNDER_EXPLAIN') }}</dt>
+-			<dd><input type="radio" class="radio" name="top_five_ignore_founder" value="1" {% if IGNORE_FOUNDER %}checked="checked"{% endif %}/> {{ lang('YES') }} &nbsp;
+-				<input type="radio" class="radio" name="top_five_ignore_founder" value="0" {% if not IGNORE_FOUNDER %}checked="checked"{% endif %} /> {{ lang('NO') }}</dd>
++			<dt><label id="top_five_ignore_founder" for="top_five_ignore_founder">{L_TF_IGNORE_FOUNDER}</label><br />{L_TF_IGNORE_FOUNDER_EXPLAIN}</dt>
++			<dd><input type="radio" class="radio" name="top_five_ignore_founder" value="1" <!-- IF IGNORE_FOUNDER -->checked="checked"<!-- ENDIF -->/> {L_YES} &nbsp; 
++				<input type="radio" class="radio" name="top_five_ignore_founder" value="0" <!-- IF not IGNORE_FOUNDER -->checked="checked"<!-- ENDIF --> /> {L_NO}</dd>
+ 		</dl>
+ 		<dl>
+-			<dt><label>{{ lang('TF_SHOW_ADMINS_MODS') }}</label><br />{{ lang('TF_SHOW_ADMINS_MODS_EXPLAIN') }}</dt>
+-			<dd><input type="radio" class="radio" name="top_five_show_admins_mods" value="1" {% if SHOW_ADMINS_MODS %}checked="checked"{% endif %}/> {{ lang('YES') }} &nbsp;
+-				<input type="radio" class="radio" name="top_five_show_admins_mods" value="0" {% if not SHOW_ADMINS_MODS %}checked="checked"{% endif %} /> {{ lang('NO') }}</dd>
++			<dt><label id="top_five_show_admins_mods" for="top_five_show_admins_mods">{L_TF_SHOW_ADMINS_MODS}</label><br />{L_TF_SHOW_ADMINS_MODS_EXPLAIN}</dt>
++			<dd><input type="radio" class="radio" name="top_five_show_admins_mods" value="1" <!-- IF SHOW_ADMINS_MODS -->checked="checked"<!-- ENDIF -->/> {L_YES} &nbsp;
++				<input type="radio" class="radio" name="top_five_show_admins_mods" value="0" <!-- IF not SHOW_ADMINS_MODS -->checked="checked"<!-- ENDIF --> /> {L_NO}</dd>
+ 		</dl>
+ 		<p class="submit-buttons">
+-			<input class="button1" type="submit" id="submit" name="submit" value="{{ lang('SUBMIT') }}" />&nbsp;
+-			<input class="button2" type="reset" id="reset" name="reset" value="{{ lang('RESET') }}" />
+-		{{ S_FORM_TOKEN }}
++			<input class="button1" type="submit" id="submit" name="submit" value="{L_SUBMIT}" />&nbsp;
++			<input class="button2" type="reset" id="reset" name="reset" value="{L_RESET}" />
++		{S_FORM_TOKEN}
+ 		</p>
+ 	</fieldset>
+ </form>
+-{% INCLUDE 'overall_footer.html' %}
++<!-- INCLUDE overall_footer.html -->
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/adm/style/event/acp_ext_details_end.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/adm/style/event/acp_ext_details_end.html"
+deleted file mode 100644
+index 5a3267046..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/adm/style/event/acp_ext_details_end.html"
++++ /dev/null
+@@ -1,9 +0,0 @@
+-{% if S_BUY_ME_A_BEER_TOPFIVE %}
+-	<fieldset>
+-		<legend>{{ lang('BUY_ME_A_BEER') }}</legend>
+-		<dl>
+-			<dt><label>{{ lang('BUY_ME_A_BEER_SHORT') }}{{ lang('COLON') }}</label><br /><span>{{ lang('BUY_ME_A_BEER_EXPLAIN') }}</span></dt>
+-			<dd><a href="{{ lang('BUY_ME_A_BEER_URL') }}" target="_blank" rel="noreferrer noopener"><img src="{{ lang('PAYPAL_IMAGE_URL') }}" border="0" alt="{{ lang('PAYPAL_ALT') }}" style="cursor:pointer;margin-top:15px;"></a></dd>
+-		</dl>
+-	</fieldset>
+-{% endif %}
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\topfive/composer.json"
+index 531076584..ac1d70338 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/composer.json"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\topfive/composer.json"
+@@ -1,38 +1,36 @@
+ {
+     "name": "rmcgirr83/topfive",
+     "type": "phpbb-extension",
+-    "description": "Displays statistics of the latest new posts, new users and most active users on the forum index page.",
++    "description": "Displays statistics of the latest new posts, new users and most active users on the boards index page.",
+     "homepage": "https://github.com/RMcGirr83/topfive",
+-    "version": "1.2.8",
+-    "time": "2024-10-26",
++    "version": "1.0.2",
++    "time": "2015-05-28",
+     "keywords": [
+         "phpbb",
+         "extension",
+         "top five"
+     ],
+-    "license": "GPL-2.0-only",
++    "license": "GPL-2.0",
+     "authors": [
+         {
+             "name": "Rich McGirr",
+-            "homepage": "https://paypal.me/rmcgirr83",
++            "homepage": "https://www.phpbb.com/customise/db/author/rmcgirr83/contributions",
++            "email": "rmcgirr83@rmcgirr83.org",
+             "role": "Lead Developer"
+         }
+     ],
+     "require": {
+-        "php": ">=7.4",
+-        "phpbb/phpbb": ">=3.3",
+-        "composer/installers": "~1.0.0"
++        "php": ">=5.3.3"
+     },
+     "extra": {
+-        "display-name": "Top Five Extension",
++        "display-name": "Top Five",
+         "soft-require": {
+-            "phpbb/phpbb": ">=3.3"
++            "phpbb/phpbb": ">=3.1.2,<3.2.*@dev"
+         },
+         "version-check": {
+             "host": "www.phpbb.com",
+             "directory": "/customise/db/extension/topfiveext",
+-            "filename": "version_check",
+-            "ssl": true
++            "filename": "version_check"
+         }
+     }
+ }
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/config/services.yml" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\topfive/config/services.yml"
+index c499f0988..7654a7bd9 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/config/services.yml"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\topfive/config/services.yml"
+@@ -1,20 +1,5 @@
+-imports:
+-    - { resource: topfive_constants.yml }
+-
+ services:
+-    rmcgirr83.topfive.admin.controller:
+-        class: rmcgirr83\topfive\controller\admin_controller
+-        arguments:
+-            - '@cache'
+-            - '@config'
+-            - '@language'
+-            - '@request'
+-            - '@template'
+-            - '%core.root_path%'
+-            - '%core.php_ext%'
+-            - '%topfive_constants%'
+-
+-    rmcgirr83.topfive.topfive:
++    rmcgirr83.topfive.functions:
+         class: rmcgirr83\topfive\core\topfive
+         arguments:
+             - '@auth'
+@@ -23,25 +8,17 @@ services:
+             - '@content.visibility'
+             - '@dbal.conn'
+             - '@dispatcher'
+-            - '@language'
+             - '@template'
+             - '@user'
+             - '%core.root_path%'
+             - '%core.php_ext%'
+-            - '@?senky.relativedates.listener'
+-            - '@?rmcgirr83.nationalflags.nationalflags'
+ 
+     rmcgirr83.topfive.listener:
+         class: rmcgirr83\topfive\event\listener
+         arguments:
+-            - '@rmcgirr83.topfive.topfive'
++            - '@rmcgirr83.topfive.functions'
+             - '@config'
+-            - '@language'
+             - '@template'
+             - '@user'
+-            - '@controller.helper'
+-            - '%core.php_ext%'
+-            - '%topfive_constants%'
+-            - '@?phpbb.collapsiblecategories.operator'
+         tags:
+             - { name: event.listener }
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/config/topfive_constants.yml" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/config/topfive_constants.yml"
+deleted file mode 100644
+index b60ea6065..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/config/topfive_constants.yml"
++++ /dev/null
+@@ -1,6 +0,0 @@
+-parameters:
+-    topfive_constants:
+-        top_of_index: 0
+-        bottom_of_index: 1
+-        top_of_entire_forum: 2
+-        bottom_of_entire_forum: 3
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/controller/admin_controller.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/controller/admin_controller.php"
+deleted file mode 100644
+index 40a3df971..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/controller/admin_controller.php"
++++ /dev/null
+@@ -1,190 +0,0 @@
+-<?php
+-/**
+-*
+-* Top Five extension for the phpBB Forum Software package.
+-*
+-* @copyright 2016 Rich McGirr (RMcGirr83)
+-* @license GNU General Public License, version 2 (GPL-2.0)
+-*
+-*/
+-
+-namespace rmcgirr83\topfive\controller;
+-
+-use phpbb\cache\service as cache;
+-use phpbb\config\config;
+-use phpbb\language\language;
+-use phpbb\request\request;
+-use phpbb\template\template;
+-
+-class admin_controller
+-{
+-	/** @var cache */
+-	protected $cache;
+-
+-	/** @var config */
+-	protected $config;
+-
+-	/** @var language */
+-	protected $language;
+-
+-	/** @var request */
+-	protected $request;
+-
+-	/** @var template */
+-	protected $template;
+-
+-	/** @var string phpBB root path */
+-	protected $root_path;
+-
+-	/** @var string phpEx */
+-	protected $php_ext;
+-
+-	/* @var array topfive_constants */
+-	protected $topfive_constants;
+-
+-	/** @var string Custom form action */
+-	protected $u_action;
+-
+-	/**
+-	* Constructor
+-	*
+-	* @param cache						$cache				Cache object
+-	* @param config						$config				Config object
+-	* @param language					$language			Language object
+-	* @param request					$request			Request object
+-	* @param template					$template			Template object
+-	* @param string						$root_path			phpBB root path
+-	* @param string						$php_ext			phpEx
+-	* @param array						$topfive_constants	Constants for the extension
+-	* @access public
+-	*/
+-	public function __construct(
+-			cache $cache,
+-			config $config,
+-			language $language,
+-			request $request,
+-			template $template,
+-			string $root_path,
+-			string $php_ext,
+-			array $topfive_constants)
+-	{
+-		$this->cache = $cache;
+-		$this->config = $config;
+-		$this->language = $language;
+-		$this->request = $request;
+-		$this->template = $template;
+-		$this->root_path = $root_path;
+-		$this->php_ext = $php_ext;
+-		$this->topfive_constants = $topfive_constants;
+-	}
+-
+-	public function display_options()
+-	{
+-		$this->language->add_lang('acp_topfive', 'rmcgirr83/topfive');
+-
+-		// Create a form key for preventing CSRF attacks
+-		add_form_key('acp_topfive');
+-
+-		// get the excluded forums
+-		$excluded_forums = explode(',', $this->config['top_five_excluded']);
+-
+-		if ($this->request->is_set_post('submit'))
+-		{
+-			if (!check_form_key('acp_topfive'))
+-			{
+-				trigger_error('FORM_INVALID');
+-			}
+-			if (!function_exists('validate_data'))
+-			{
+-				include($this->root_path . 'includes/functions_user.' . $this->php_ext);
+-			}
+-
+-			$check_row = array('top_five_how_many' => $this->request->variable('top_five_how_many', 0));
+-			$validate_row = array('top_five_how_many' => array('num', false, 5, 100));
+-			$error = validate_data($check_row, $validate_row);
+-			// Replace "error" strings with their real, localised form
+-			$error = array_map(array($this->language, 'lang'), $error);
+-
+-			if (!sizeof($error))
+-			{
+-				$this->set_options();
+-
+-				$this->cache->destroy('_top_five_newest_users');
+-				$this->cache->destroy('_top_five_posters');
+-
+-				trigger_error($this->language->lang('TF_SAVED') . adm_back_link($this->u_action));
+-			}
+-		}
+-
+-		$this->template->assign_vars(array(
+-			'TF_ERROR'			=> isset($error) ? ((sizeof($error)) ? implode('<br />', $error) : '') : '',
+-			'HOWMANY'			=> isset($this->config['top_five_how_many']) ? $this->config['top_five_how_many'] : 0,
+-			'IGNORE_INACTIVE'	=> isset($this->config['top_five_ignore_inactive_users']) ? $this->config['top_five_ignore_inactive_users'] : false,
+-			'IGNORE_FOUNDER'	=> isset($this->config['top_five_ignore_founder']) ? $this->config['top_five_ignore_founder'] : false,
+-			'SHOW_ADMINS_MODS'	=> isset($this->config['top_five_show_admins_mods']) ? $this->config['top_five_show_admins_mods'] : false,
+-			'LOCATION'			=> $this->location($this->config['top_five_location']),
+-			'ACTIVE'			=> isset($this->config['top_five_active']) ? $this->config['top_five_active'] : false,
+-			'TF_EXCLUDED'		=> $this->forum_select($excluded_forums),
+-			'AVATARS'		=> isset($this->config['top_five_avatars']) ? $this->config['top_five_avatars'] : false,
+-
+-			'U_ACTION'			=> $this->u_action,
+-		));
+-	}
+-
+-	protected function set_options()
+-	{
+-		$this->config->set('top_five_how_many', $this->request->variable('top_five_how_many', 0));
+-		$this->config->set('top_five_ignore_inactive_users', $this->request->variable('top_five_ignore_inactive_users', 0));
+-		$this->config->set('top_five_ignore_founder', $this->request->variable('top_five_ignore_founder', 0));
+-		$this->config->set('top_five_show_admins_mods', $this->request->variable('top_five_show_admins_mods', 0));
+-		$this->config->set('top_five_location', $this->request->variable('top_five_location', 0));
+-		$this->config->set('top_five_active', $this->request->variable('top_five_active', 0));
+-
+-		// variable should be '' as it is a string ("1, 2, 3928") here, not an integer.
+-		$forums = $this->request->variable('selectForms',  array(''));
+-		// change the array to a string
+-		$forums  = implode(',', $forums);
+-		$this->config->set('top_five_excluded', $forums);
+-		$this->config->set('top_five_avatars', $this->request->variable('top_five_avatars',0));
+-	}
+-
+-	/**
+-	 * Display a drop down of all forums for selection
+-	 *
+-	 * @return drop down select
+-	 * @access protected
+-	 */
+-	private function forum_select($value)
+-	{
+-		return '<select id="top_five_excluded" name="selectForms[]" multiple="multiple">' . make_forum_select($value, false, true, true) . '</select>';
+-	}
+-
+-	/**
+-	 * Create the selection for the post method
+-	 */
+-	public function location($location = 0)
+-	{
+-		// location options
+-		$location_text = [$this->topfive_constants['top_of_index'] => $this->language->lang('TOP_OF_FORUM'), $this->topfive_constants['bottom_of_index'] => $this->language->lang('BOTTOM_OF_FORUM'), $this->topfive_constants['top_of_entire_forum'] => $this->language->lang('TOP_OF_ENTIRE_FORUM'), $this->topfive_constants['bottom_of_entire_forum'] => $this->language->lang('BOTTOM_OF_ENTIRE_FORUM')];
+-		$location_options = '';
+-		foreach ($location_text as $value => $text)
+-		{
+-			$selected = ($value == $location) ? ' selected="selected"' : '';
+-			$location_options .= "<option value='{$value}'$selected>$text</option>";
+-		}
+-
+-		return $location_options;
+-	}
+-
+-	/**
+-	 * Set page url
+-	 *
+-	 * @param string $u_action Custom form action
+-	 * @return null
+-	 * @access public
+-	 */
+-	public function set_page_url($u_action)
+-	{
+-		$this->u_action = $u_action;
+-	}
+-}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/core/topfive.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\topfive/core/topfive.php"
+index 4facdbedc..3d9f9352e 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/core/topfive.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\topfive/core/topfive.php"
+@@ -11,65 +11,39 @@
+ 
+ namespace rmcgirr83\topfive\core;
+ 
+-use phpbb\auth\auth;
+-use phpbb\config\config;
+-use phpbb\cache\service as cache_service;
+-use phpbb\content_visibility;
+-use phpbb\db\driver\driver_interface;
+-use phpbb\event\dispatcher_interface;
+-use phpbb\language\language;
+-use phpbb\template\template;
+-use phpbb\user;
+-
+ class topfive
+ {
+-	/** @var auth */
++	/** @var \phpbb\auth\auth */
+ 	protected $auth;
+ 
+-	/** @var config */
++	/** @var \phpbb\config\config */
+ 	protected $config;
+ 
+-	/** @var cache */
++	/** @var \phpbb\cache\driver\driver_interface */
+ 	protected $cache;
+ 
+-	/** @var content_visibility */
++	/** @var \phpbb\content_visibility */
+ 	protected $content_visibility;
+ 
+-	/** @var db */
++	/** @var \phpbb\db\driver\driver_interface */
+ 	protected $db;
+ 
+-	/** @var dispatcher */
++	/** @var \phpbb\event\dispatcher_interface */
+ 	protected $dispatcher;
+ 
+-	/** @var language */
+-	protected $language;
+-
+-	/** @var template */
++	/** @var \phpbb\template\template */
+ 	protected $template;
+ 
+-	/** @var user */
++	/** @var \phpbb\user */
+ 	protected $user;
+ 
+-	/** @var string phpbb_root_path */
++	/** @var string phpBB root path */
+ 	protected $phpbb_root_path;
+ 
+-	/** @var string php_ext */
++	/** @var string PHP extension */
+ 	protected $php_ext;
+ 
+-	public function __construct(
+-		auth $auth,
+-		config $config,
+-		cache_service $cache,
+-		content_visibility $content_visibility,
+-		driver_interface $db,
+-		dispatcher_interface $dispatcher,
+-		language $language,
+-		template $template,
+-		user $user,
+-		string $phpbb_root_path,
+-		string $php_ext,
+-		\senky\relativedates\event\listener $relativedates = null,
+-		\rmcgirr83\nationalflags\core\nationalflags $nationalflags= null)
++	public function __construct(\phpbb\auth\auth $auth, \phpbb\config\config $config, \phpbb\cache\service $cache, \phpbb\content_visibility $content_visibility, \phpbb\db\driver\driver_interface $db, \phpbb\event\dispatcher_interface $dispatcher, \phpbb\template\template $template, \phpbb\user $user, $phpbb_root_path, $php_ext)
+ 	{
+ 		$this->auth = $auth;
+ 		$this->config = $config;
+@@ -77,27 +51,18 @@ class topfive
+ 		$this->content_visibility = $content_visibility;
+ 		$this->db = $db;
+ 		$this->dispatcher = $dispatcher;
+-		$this->language = $language;
+ 		$this->template = $template;
+ 		$this->user = $user;
+ 		$this->root_path = $phpbb_root_path;
+ 		$this->php_ext = $php_ext;
+-		$this->relativedates = $relativedates;
+-		$this->nationalflags = $nationalflags;
+ 	}
+ 
+-	/**
+-	* Display activity
+-	*
+-	* @param	string	$tpl_loopname	Name of the html file
+-	* @return 	null
+-	* @access 	public
+-	*/
+ 	public function toptopics($tpl_loopname = 'top_five_topic')
+ 	{
++
+ 		$howmany = $this->howmany();
+ 
+-		$forum_ary = [];
++		$forum_ary = array();
+ 		$forum_read_ary = $this->auth->acl_getf('f_read');
+ 
+ 		foreach ($forum_read_ary as $forum_id => $allowed)
+@@ -109,35 +74,19 @@ class topfive
+ 		}
+ 		$forum_ary = array_unique($forum_ary);
+ 
+-		// want to exclude some forums
+-		$excluded_forums = explode(',', $this->config['top_five_excluded']);
+-
+-		// now remove those topics from the display per the excluded forums array
+-		$forum_ary = array_diff($forum_ary, $excluded_forums);
+-
+-		if (!sizeof($forum_ary))
++		if (sizeof($forum_ary))
+ 		{
+-			$this->template->assign_block_vars($tpl_loopname, [
+-				'NO_TOPIC_TITLE'	=> $this->language->lang('NO_TOPIC_EXIST'),
+-			]);
+-
+-			return false;
+-		}
+-
+ 			/**
+ 			* Select topic_ids
+ 			*/
+-		// grab all posts that meet criteria and auths
+-		$sql_array = [
+-			'SELECT'	=> 't.forum_id, t.topic_id, t.topic_type',
+-			'FROM'		=> [TOPICS_TABLE => 't'],
+-			'WHERE'		=> $this->content_visibility->get_forums_visibility_sql('topic', $forum_ary) . ' AND topic_status <> ' . ITEM_MOVED,
+-			'ORDER_BY'	=> 't.topic_last_post_time DESC',
+-		];
+-
+-		$result = $this->db->sql_query_limit($this->db->sql_build_query('SELECT', $sql_array), $howmany);
+-
+-		$forums = $ga_topic_ids = $topic_ids = [];
++			$sql = 'SELECT forum_id, topic_id, topic_type
++				FROM ' . TOPICS_TABLE . '
++				WHERE ' . $this->content_visibility->get_forums_visibility_sql('topic', $forum_ary) . '
++				AND topic_status <> ' . ITEM_MOVED . '
++				ORDER BY topic_last_post_time DESC';
++
++			$result = $this->db->sql_query_limit($sql, $howmany);
++			$forums = $ga_topic_ids = $topic_ids = array();
+ 			while ($row = $this->db->sql_fetchrow($result))
+ 			{
+ 				$topic_ids[] = $row['topic_id'];
+@@ -153,7 +102,7 @@ class topfive
+ 			$this->db->sql_freeresult($result);
+ 
+ 			// Get topic tracking
+-		$topic_tracking_info = [];
++			$topic_tracking_info = array();
+ 			foreach ($forums as $forum_id => $topic_id)
+ 			{
+ 				$topic_tracking_info[$forum_id] = get_complete_topic_tracking($forum_id, $topic_id, $ga_topic_ids);
+@@ -163,37 +112,25 @@ class topfive
+ 			* must have topic_ids.
+ 			* A user can have forums and not have topic_ids before installing this extension
+ 			*/
+-		if (!sizeof($topic_ids))
++			if (sizeof($topic_ids))
+ 			{
+-			$this->template->assign_block_vars($tpl_loopname, [
+-				'NO_TOPIC_TITLE'	=> $this->language->lang('NO_TOPIC_EXIST'),
+-			]);
+-
+-			return false;
+-		}
+-
+ 				// grab all posts that meet criteria and auths
+-		$sql_array = [
+-			'SELECT'	=> 'u.user_id, u.username, u.user_colour, u.user_avatar, u.user_avatar_type, u.user_avatar_height, u.user_avatar_width, t.topic_title, t.forum_id, t.topic_id, t.topic_first_post_id, t.topic_last_post_id, t.topic_last_post_time, t.topic_last_poster_name, f.forum_name',
+-			'FROM'		=> [TOPICS_TABLE => 't'],
+-			'LEFT_JOIN'	=> [
+-				[
+-					'FROM'	=> [USERS_TABLE => 'u'],
++				$sql_array = array(
++					'SELECT'	=> 'u.user_id, u.username, u.user_colour, u.user_avatar, u.user_avatar_type, u.user_avatar_width, u.user_avatar_height, t.topic_title, t.forum_id, t.topic_id, t.topic_first_post_id, t.topic_last_post_id, t.topic_last_post_time, t.topic_last_poster_name, f.forum_name',
++					'FROM'		=> array(TOPICS_TABLE => 't'),
++					'LEFT_JOIN'	=> array(
++						array(
++							'FROM'	=> array(USERS_TABLE => 'u'),
+ 							'ON'	=> 't.topic_last_poster_id = u.user_id',
+-				],
+-				[
+-					'FROM'	=> [FORUMS_TABLE => 'f'],
++						),
++						array(
++							'FROM'	=> array(FORUMS_TABLE => 'f'),
+ 							'ON'	=> 't.forum_id = f.forum_id',
+-				],
+-			],
++						),
++					),
+ 					'WHERE'		=> $this->db->sql_in_set('t.topic_id', $topic_ids),
+ 					'ORDER_BY'	=> 't.topic_last_post_time DESC',
+-		];
+-		if ($this->nationalflags !== null)
+-		{
+-			$sql_array['SELECT'].= ', u.user_flag';
+-		}
+-
++				);
+ 				/**
+ 				* Event to modify the SQL query before the topics data is retrieved
+ 				*
+@@ -201,10 +138,11 @@ class topfive
+ 				* @var	array	sql_array		The SQL array
+ 				* @since 1.0.0
+ 				*/
+-		$vars = ['sql_array'];
++				$vars = array('sql_array');
+ 				extract($this->dispatcher->trigger_event('rmcgirr83.topfive.sql_pull_topics_data', compact($vars)));
+ 
+-		$result = $this->db->sql_query_limit($this->db->sql_build_query('SELECT', $sql_array), $howmany);
++				// cache the query for one minute
++				$result = $this->db->sql_query_limit($this->db->sql_build_query('SELECT', $sql_array), $howmany, 0, 60);
+ 
+ 				while ($row = $this->db->sql_fetchrow($result))
+ 				{
+@@ -213,49 +151,26 @@ class topfive
+ 					$forum_name = $row['forum_name'];
+ 
+ 					$post_unread = (isset($topic_tracking_info[$forum_id][$topic_id]) && $row['topic_last_post_time'] > $topic_tracking_info[$forum_id][$topic_id]) ? true : false;
+-			$view_topic_url = !empty($post_unread) ? append_sid("{$this->root_path}viewtopic.$this->php_ext", 't=' . $topic_id . '&amp;view=unread') . '#unread' : append_sid("{$this->root_path}viewtopic.$this->php_ext", 't=' . $topic_id);
+-			/** To go to the last post in a topic use the below as the last argument in the above $view_topic_url variable
+-			append_sid("{$this->root_path}viewtopic.$this->php_ext", 'f=' . $row['forum_id'] . '&amp;p=' . $row['topic_last_post_id'] . '#p' . $row['topic_last_post_id'])
+-			**/
+-			$forum_name_url = append_sid("{$this->root_path}viewforum.$this->php_ext", 'f=' . $row['forum_id']);
++					$view_topic_url = append_sid("{$this->phpbb_root_path}viewtopic.$this->php_ext", 'f=' . $row['forum_id'] . '&amp;p=' . $row['topic_last_post_id'] . '#p' . $row['topic_last_post_id']);
++					$forum_name_url = append_sid("{$this->phpbb_root_path}viewforum.$this->php_ext", 'f=' . $row['forum_id']);
+ 					$topic_title = censor_text($row['topic_title']);
+-			$topic_title = truncate_string($topic_title, 60, 255, false, $this->language->lang('ELLIPSIS'));
+-
+-			$is_guest = ($row['user_id'] == ANONYMOUS) ? true : false;
+-
+-			$user_avatar = phpbb_get_user_avatar($row);
+-			$display_avatar = (!empty($this->config['top_five_avatars']) && $this->user->optionget('viewavatars') && !empty($user_avatar)) ? true : false;
+-
+-			$user_avatar = $display_avatar ? '<span class="topfive-avatar">' . $user_avatar . '</span>&nbsp;' : '';
+-
+-			// relativedates installed?
+-			if ($this->relativedates !== null)
++					if (utf8_strlen($topic_title) >= 60)
+ 					{
+-				$last_topic_time = $this->user->format_date($row['topic_last_post_time'], false, false, false);
+-			}
+-			else
+-			{
+-				$last_topic_time = $this->user->format_date($row['topic_last_post_time']);
+-			}
+-
+-			$user_flag = '';
+-			// nationalflags installed?
+-			if (!empty($row['user_flag']))
+-			{
+-				$user_flag = $this->nationalflags->get_user_flag($row['user_flag'], 12);
++						$topic_title = (utf8_strlen($topic_title) > 60 + 3) ? utf8_substr($topic_title, 0, 60) . '...' : $topic_title;
+ 					}
++					$is_guest = ($row['user_id'] == ANONYMOUS) ? true : false;
++                    $user_avatar = ($row['user_avatar']) ? get_user_avatar($row['user_avatar'], $row['user_avatar_type'], 50, 50) : '<img src="' . generate_board_url() . '/styles/' . '/FLATBOOTS/' . '/theme/images/no_avatar.gif" height="50" width="50" alt="Default Avatar" />';
+ 					
+-			$tpl_ary = [
++					$tpl_ary = array(
+ 						'U_TOPIC'			=> $view_topic_url,
+ 						'U_FORUM'			=> $forum_name_url,
++						'TOP5_AVATAR' 	    => $user_avatar,
+ 						'S_UNREAD'			=> ($post_unread) ? true : false,
+-				'USERNAME_FULL'	=> ($is_guest || !$this->auth->acl_get('u_viewprofile')) ? $this->language->lang('BY') . $user_avatar . get_username_string('no_profile', $row['user_id'], $row['username'], $row['user_colour'], $row['topic_last_poster_name']) : $this->language->lang('BY') . $user_avatar . get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']),
+-				'LAST_TOPIC_TIME'	=> $last_topic_time,
++						'USERNAME_FULL'		=> ($is_guest || !$this->auth->acl_get('u_viewprofile')) ? $this->user->lang['POST_BY_AUTHOR'] . ' ' . get_username_string('no_profile', $row['user_id'], $row['username'], $row['user_colour'], $row['topic_last_poster_name']) : $this->user->lang['POST_BY_AUTHOR'] . ' ' . get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']),
++						'LAST_TOPIC_TIME'	=> $this->user->format_date($row['topic_last_post_time']),
+ 						'TOPIC_TITLE' 		=> $topic_title,
+ 						'FORUM_NAME'		=> $forum_name,
+-				'USER_FLAG'	=> !empty($user_flag) ? $user_flag : '',
+-			];
+-
++					);
+ 					/**
+ 					* Modify the topic data before it is assigned to the template
+ 					*
+@@ -264,65 +179,79 @@ class topfive
+ 					* @var	array	tpl_ary		Template block array with topic data
+ 					* @since 1.0.0
+ 					*/
+-			$vars = ['row', 'tpl_ary'];
++					$vars = array('row', 'tpl_ary');
+ 					extract($this->dispatcher->trigger_event('rmcgirr83.topfive.modify_tpl_ary', compact($vars)));
+ 
+ 					$this->template->assign_block_vars($tpl_loopname, $tpl_ary);
+ 				}
+ 				$this->db->sql_freeresult($result);
+ 			}
++			else
++			{
++				$this->template->assign_block_vars($tpl_loopname, array(
++					'NO_TOPIC_TITLE'	=> $this->user->lang['NO_TOPIC_EXIST'],
++				));
++			}
++		}
++		else
++		{
++			$this->template->assign_block_vars($tpl_loopname, array(
++				'NO_TOPIC_TITLE'	=> $this->user->lang['NO_TOPIC_EXIST'],
++			));
++		}
++	}
+ 
+-	/**
+-	* Get the top posters
+-	*
+-	* @return 	null
+-	* @access 	public
+-	*/
+ 	public function topposters()
+ 	{
+ 		$howmany = $this->howmany();
+ 		$sql_where = $this->ignore_users();
+ 
++		//set two variables for the sql
++		$sql_and = $sql_other = '';
++
+ 		if (($user_posts = $this->cache->get('_top_five_posters')) === false)
+ 		{
+-			$user_posts = [];
+ 
+-			$sql_where .= empty($sql_where) ? 'u.user_posts <> 0' : ' AND u.user_posts <> 0';
++			$user_posts = $admin_mod_array = array();
++			// quick check for forum moderators and administrators
++			// some may not want to show them
++			$show_admins_mods = $this->config['top_five_show_admins_mods'];
+ 
+-			// do the main sql query
+-			$sql_array = [
+-				'SELECT' => 'u.user_id, u.username, u.user_colour, u.user_posts, u.user_avatar, u.user_avatar_width, u.user_avatar_height, u.user_avatar_type, u.user_lastpost_time',
+-				'FROM' => [USERS_TABLE => 'u'],
+-				'WHERE' => $sql_where,
+-				'ORDER_BY' => 'u.user_lastpost_time DESC, u.user_posts DESC',
+-			];
+-
+-			if ($this->nationalflags !== null)
++			if (!$show_admins_mods)
+ 			{
+-				$sql_array['SELECT'] .= ', u.user_flag';
++				// grab all admins
++				$admin_ary = $this->auth->acl_get_list(false, 'a_', false);
++				$admin_ary = (!empty($admin_ary[0]['a_'])) ? $admin_ary[0]['a_'] : array();
++
++				//grab all mods
++				$mod_ary = $this->auth->acl_get_list(false,'m_', false);
++				$mod_ary = (!empty($mod_ary[0]['m_'])) ? $mod_ary[0]['m_'] : array();
++				$admin_mod_array = array_unique(array_merge($admin_ary, $mod_ary));
++				if (sizeof($admin_mod_array))
++				{
++					$sql_and = empty($sql_where) ? ' WHERE' : ' AND';
++					$sql_and .= ' ' . $this->db->sql_in_set('user_id', $admin_mod_array, true);
+ 				}
+-			$result = $this->db->sql_query_limit($this->db->sql_build_query('SELECT', $sql_array), $howmany);
++			}
++			$sql_other = (empty($sql_and) && empty($sql_where)) ? ' WHERE' : ' AND';
++			$sql_other .=  ' user_posts <> 0';
++
++			// do the main sql query
++			$sql = 'SELECT user_id, username, user_colour, user_posts
++				FROM ' . USERS_TABLE . '
++				 ' . $sql_where . ' ' . $sql_and . '
++				' . $sql_other . '
++				ORDER BY user_posts DESC';
+ 
++			$result = $this->db->sql_query_limit($sql, $howmany);
+ 			while ($row = $this->db->sql_fetchrow($result))
+ 			{
+-				$user_flag = '';
+-				// nationalflags installed?
+-				if (!empty($row['user_flag']))
+-				{
+-					$user_flag = $this->nationalflags->get_user_flag($row['user_flag'], 12);
+-				}
+-				$user_posts[$row['user_id']] = [
++				$user_posts[$row['user_id']] = array(
+ 					'user_id'      => $row['user_id'],
+ 					'username'      => $row['username'],
+ 					'user_colour'   => $row['user_colour'],
+ 					'user_posts'    => $row['user_posts'],
+-					'user_avatar'	=> $row['user_avatar'],
+-					'user_avatar_width'	=> $row['user_avatar_width'],
+-					'user_avatar_height'	=> $row['user_avatar_height'],
+-					'user_avatar_type'	=> $row['user_avatar_type'],
+-					'user_lastpost_time'	=> $row['user_lastpost_time'],
+-					'user_flag'	=> !empty($user_flag) ? $user_flag : '',
+-				];
++				);
+ 			}
+ 			$this->db->sql_freeresult($result);
+ 
+@@ -332,81 +261,44 @@ class topfive
+ 
+ 		foreach ($user_posts as $row)
+ 		{
+-			$user_avatar = phpbb_get_user_avatar($row);
+-			$display_avatar = (!empty($this->config['top_five_avatars']) && $this->user->optionget('viewavatars') && !empty($user_avatar)) ? true : false;
+-
+-			$user_avatar = $display_avatar ? '<span class="topfive-avatar">' . $user_avatar . '</span>&nbsp;' : '';
+-
+-			$username_string = ($this->auth->acl_get('u_viewprofile')) ? $user_avatar . get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']) : $user_avatar . get_username_string('no_profile', $row['user_id'], $row['username'], $row['user_colour']);
+-			if ($this->relativedates !== null)
+-			{
+-				$user_lastpost_time = $this->user->format_date($row['user_lastpost_time'], false, false, false);
+-			}
+-			else
+-			{
+-				$user_lastpost_time = $this->user->format_date($row['user_lastpost_time']);
+-			}
++			$username_string = ($this->auth->acl_get('u_viewprofile')) ? get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']) : get_username_string('no_profile', $row['user_id'], $row['username'], $row['user_colour']);
+ 
+-			$this->template->assign_block_vars('top_five_active',[
+-				'S_SEARCH_ACTION'	=> append_sid("{$this->root_path}search.$this->php_ext", 'author_id=' . $row['user_id'] . '&amp;sr=posts'),
++			$this->template->assign_block_vars('top_five_active',array(
++				'S_SEARCH_ACTION'	=> append_sid("{$this->phpbb_root_path}search.$this->php_ext", 'author_id=' . $row['user_id'] . '&amp;sr=posts'),
+ 				'POSTS' 			=> number_format($row['user_posts']),
+ 				'USERNAME_FULL'		=> $username_string,
+-				'USER_LASTPOST_TIME'	=> $this->language->lang('USER_LASTPOST_TIME', $user_lastpost_time),
+-				'USER_FLAG'	=> !empty($row['user_flag']) ? $row['user_flag'] : '',
+-			]);
++			));
+ 		}
+ 	}
+ 
+-	/**
+-	* Get the newest members
+-	*
+-	* @return 	null
+-	* @access 	public
+-	*/
+ 	public function newusers()
+ 	{
++
+ 		$howmany = $this->howmany();
+ 		$sql_where = $this->ignore_users();
+ 
+-		$sql_where .= !empty($sql_where) ? ' AND u.user_inactive_reason = 0' : ' u.user_inactive_reason = 0';
++		$sql_and = !empty($sql_where) ? ' AND user_inactive_reason = 0' : ' WHERE user_inactive_reason = 0';
+ 		// newest registered users
+ 		if (($newest_users = $this->cache->get('_top_five_newest_users')) === false)
+ 		{
+-			$newest_users = [];
++			$newest_users = array();
+ 
+ 			// grab most recent registered users
+-			$sql_array = [
+-				'SELECT' => 'u.user_id, u.username, u.user_colour, u.user_regdate, u.user_avatar, u.user_avatar_width, u.user_avatar_height, u.user_avatar_type',
+-				'FROM' => [USERS_TABLE => 'u'],
+-				'WHERE' => $sql_where,
+-				'ORDER_BY' =>  'u.user_regdate DESC',
+-			];
+-			if ($this->nationalflags !== null)
+-			{
+-				$sql_array['SELECT'] .= ', u.user_flag';
+-			}
+-			$result = $this->db->sql_query_limit($this->db->sql_build_query('SELECT', $sql_array), $howmany);
++			$sql = 'SELECT user_id, username, user_colour, user_regdate
++				FROM ' . USERS_TABLE . '
++				' . $sql_where . '
++				' . $sql_and . '
++				ORDER BY user_regdate DESC';
++			$result = $this->db->sql_query_limit($sql, $howmany);
+ 
+ 			while ($row = $this->db->sql_fetchrow($result))
+ 			{
+-				$user_flag = '';
+-				// nationalflags installed?
+-				if (!empty($row['user_flag']))
+-				{
+-					$user_flag = $this->nationalflags->get_user_flag($row['user_flag'], 12);
+-				}
+-
+-				$newest_users[$row['user_id']] = [
++				$newest_users[$row['user_id']] = array(
+ 					'user_id'				=> $row['user_id'],
+ 					'username'				=> $row['username'],
+ 					'user_colour'			=> $row['user_colour'],
+ 					'user_regdate'			=> $row['user_regdate'],
+-					'user_avatar'			=> $row['user_avatar'],
+-					'user_avatar_width'		=> $row['user_avatar_width'],
+-					'user_avatar_height'	=> $row['user_avatar_height'],
+-					'user_avatar_type'		=> $row['user_avatar_type'],
+-					'user_flag'				=> !empty($user_flag) ? $user_flag : '',
+-				];
++				);
+ 			}
+ 			$this->db->sql_freeresult($result);
+ 
+@@ -416,27 +308,15 @@ class topfive
+ 
+ 		foreach ($newest_users as $row)
+ 		{
+-			$user_avatar = phpbb_get_user_avatar($row);
+-			$display_avatar = (!empty($this->config['top_five_avatars']) && $this->user->optionget('viewavatars') && !empty($user_avatar)) ? true : false;
+-
+-			$user_avatar = $display_avatar ? '<span class="topfive-avatar">' . $user_avatar . '</span>&nbsp;' : '';
+-
+-			$username_string = ($this->auth->acl_get('u_viewprofile')) ? $user_avatar . get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']) : $user_avatar . get_username_string('no_profile', $row['user_id'], $row['username'], $row['user_colour']);
++			$username_string = ($this->auth->acl_get('u_viewprofile')) ? get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']) : get_username_string('no_profile', $row['user_id'], $row['username'], $row['user_colour']);
+ 
+-			$this->template->assign_block_vars('top_five_newest',[
++			$this->template->assign_block_vars('top_five_newest',array(
+ 				'REG_DATE'			=> $this->user->format_date($row['user_regdate']),
+ 				'USERNAME_FULL'		=> $username_string,
+-				'USER_FLAG'			=> !empty($row['user_flag']) ? $row['user_flag'] : '',
+-			]);
++			));
+ 		}
+ 	}
+ 
+-	/**
+-	* How many to display
+-	*
+-	* @return 	int 	$howmany
+-	* @access 	private
+-	*/
+ 	private function howmany()
+ 	{
+ 		$howmany = $this->config['top_five_how_many'];
+@@ -444,24 +324,18 @@ class topfive
+ 		return (int) $howmany;
+ 	}
+ 
+-	/**
+-	* Ignore users
+-	*
+-	* @return 	string 	$sql_where
+-	* @access 	private
+-	*/
+ 	private function ignore_users()
+ 	{
+ 		// an array of user types we dont' bother with
+-		$ignore_users = $ignore_founders = [];
++		$ignore_users = $ignore_founders = array();
+ 		if ($this->config['top_five_ignore_inactive_users'])
+ 		{
+-			$ignore_users = [USER_IGNORE, USER_INACTIVE];
++			$ignore_users = array(USER_IGNORE, USER_INACTIVE);
+ 		}
+ 
+ 		if ($this->config['top_five_ignore_founder'])
+ 		{
+-			$ignore_founders = [USER_FOUNDER];
++			$ignore_founders = array(USER_FOUNDER);
+ 		}
+ 
+ 		$ignore_users = array_merge($ignore_users, $ignore_founders);
+@@ -470,28 +344,9 @@ class topfive
+ 		$sql_where = '';
+ 		if (sizeof($ignore_users))
+ 		{
+-			$sql_where = $this->db->sql_in_set('u.user_type', $ignore_users, true);
++			$sql_where = 'WHERE ' . $this->db->sql_in_set('user_type', $ignore_users, true);
+ 		}
+-		$admin_mod_array = [];
+-		// quick check for forum moderators and administrators
+-		// some may not want to show them
+-		$show_admins_mods = $this->config['top_five_show_admins_mods'];
+ 
+-		if (!$show_admins_mods)
+-		{
+-			// grab all admins
+-			$admin_ary = $this->auth->acl_get_list(false, 'a_', false);
+-			$admin_ary = (!empty($admin_ary[0]['a_'])) ? $admin_ary[0]['a_'] : [];
+-
+-			//grab all mods
+-			$mod_ary = $this->auth->acl_get_list(false,'m_', false);
+-			$mod_ary = (!empty($mod_ary[0]['m_'])) ? $mod_ary[0]['m_'] : [];
+-			$admin_mod_array = array_unique(array_merge($admin_ary, $mod_ary));
+-			if (sizeof($admin_mod_array))
+-			{
+-				$sql_where .= empty($sql_where) ? $this->db->sql_in_set('u.user_id', $admin_mod_array, true) : ' AND ' . $this->db->sql_in_set('u.user_id', $admin_mod_array, true);
+-			}
+-		}
+ 		return $sql_where;
+ 	}
+ }
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\topfive/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\topfive/diff_full.tmp"
+new file mode 100644
+index 000000000..357e59407
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\topfive/diff_full.tmp"
+@@ -0,0 +1,3248 @@
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/acp/topfive_info.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\topfive/acp/topfive_info.php"
++index 591b4fa8f..c0f748d31 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/acp/topfive_info.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\topfive/acp/topfive_info.php"
++@@ -19,9 +19,9 @@ class topfive_info
++ 		return array(
++ 			'filename'	=> '\rmcgirr83\topfive\acp\topfive_module',
++ 			'title'		=> 'TF_ACP',
++-			'version'	=> '1.2.3',
+++			'version'	=> '1.0.0',
++ 			'modes'		=> array(
++-				'settings'	=> array('title' => 'TF_CONFIG', 'auth'	=> 'ext_rmcgirr83/topfive && acl_a_extensions' , 'cat'	=> array('TOPFIVE_MOD')),
+++				'settings'	=> array('title' => 'TF_CONFIG', 'auth'	=> 'ext_rmcgirr83/topfive', 'cat'	=> array('TOPFIVE_MOD')),
++ 			),
++ 		);
++ 	}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/acp/topfive_module.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\topfive/acp/topfive_module.php"
++index 3cc28d045..c1801a315 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/acp/topfive_module.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\topfive/acp/topfive_module.php"
++@@ -11,21 +11,67 @@ namespace rmcgirr83\topfive\acp;
++ 
++ class topfive_module
++ {
++-	public $u_action;
+++	var $u_action;
++ 
++ 	function main($id, $mode)
++ 	{
++-		global $phpbb_container;
+++		global $db, $user, $auth, $template, $cache, $request;
+++		global $config, $phpbb_root_path, $phpbb_admin_path, $phpEx;
++ 
+++		$this->config = $config;
+++		$this->request = $request;
+++
+++		$user->add_lang('acp/common');
+++		$user->add_lang_ext('rmcgirr83/topfive', 'acp/info_acp_topfive');
++ 		$this->tpl_name = 'acp_topfive';
++-		$this->page_title = $phpbb_container->get('language')->lang('TF_ACP');
+++		$this->page_title = $user->lang['TOPFIVE_MOD'];
+++		add_form_key('acp_topfive');
+++
+++		if ($request->is_set_post('submit'))
+++		{
+++			if (!check_form_key('acp_topfive'))
+++			{
+++				trigger_error('FORM_INVALID');
+++			}
+++			if (!function_exists('validate_data'))
+++			{
+++				include($phpbb_root_path . 'includes/functions_user.' . $phpEx);
+++			}
+++
+++			$check_row = array('top_five_how_many' => $request->variable('top_five_how_many', 0));
+++			$validate_row = array('top_five_how_many' => array('num', false, 5, 100));
+++			$error = validate_data($check_row, $validate_row);
+++
+++			// Replace "error" strings with their real, localised form
+++			$error = array_map(array($user, 'lang'), $error);
+++
+++			if (!sizeof($error))
+++			{
+++				$config->set('top_five_how_many', $request->variable('top_five_how_many', 0));
+++				$config->set('top_five_ignore_inactive_users', $request->variable('top_five_ignore_inactive_users', true));
+++				$config->set('top_five_ignore_founder', $request->variable('top_five_ignore_founder', true));
+++				$config->set('top_five_show_admins_mods', $request->variable('top_five_show_admins_mods', true));
+++				$config->set('top_five_location', $request->variable('top_five_location', true));
+++				$config->set('top_five_active', $request->variable('top_five_active', true));
+++
+++				$cache->destroy('_top_five_newest_users');
+++				$cache->destroy('_top_five_posters');
++ 
++-		// Get an instance of the admin controller
++-		$admin_controller = $phpbb_container->get('rmcgirr83.topfive.admin.controller');
+++				trigger_error($user->lang['TF_SAVED'] . adm_back_link($this->u_action));
+++			}
+++		}
++ 
++-		// Make the $u_action url available in the admin controller
++-		$admin_controller->set_page_url($this->u_action);
+++		$template->assign_vars(array(
+++			'TF_ERROR'			=> isset($error) ? ((sizeof($error)) ? implode('<br />', $error) : '') : '',
+++			'HOWMANY'			=> (!empty($this->config['top_five_how_many'])) ? $this->config['top_five_how_many'] : 0,
+++			'IGNORE_INACTIVE'	=> (!empty($this->config['top_five_ignore_inactive_users'])) ? true : false,
+++			'IGNORE_FOUNDER'	=> (!empty($this->config['top_five_ignore_founder'])) ? true : false,
+++			'SHOW_ADMINS_MODS'	=> (!empty($this->config['top_five_show_admins_mods'])) ? true : false,
+++			'LOCATION'			=> (!empty($this->config['top_five_location'])) ? true : false,
+++			'ACTIVE'			=> (!empty($this->config['top_five_active'])) ? true : false,
+++			'TF_VERSION'		=> $this->config['top_five_version'],
++ 
++-		$admin_controller->display_options();
+++			'U_ACTION'			=> $this->u_action,
+++		));
++ 	}
++ }
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/adm/style/acp_topfive.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\topfive/adm/style/acp_topfive.html"
++index 48224526d..f799a7138 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/adm/style/acp_topfive.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\topfive/adm/style/acp_topfive.html"
++@@ -1,60 +1,51 @@
++-{% INCLUDE 'overall_header.html' %}
+++<!-- INCLUDE overall_header.html -->
++ 
++-<h1>{{ lang('TF_TITLE') }}</h1>
++-<fieldset>
++-	<legend>{{ lang('BUY_ME_A_BEER') }}</legend>
++-	<dl>
++-		<dt><label>{{ lang('BUY_ME_A_BEER_SHORT') }}{{ lang('COLON') }}</label><br /><span>{{ lang('BUY_ME_A_BEER_EXPLAIN') }}</span></dt>
++-		<dd><a href="{{ lang('BUY_ME_A_BEER_URL') }}" target="_blank" rel="noreferrer noopener"><img src="{{ lang('PAYPAL_IMAGE_URL') }}" border="0" alt="{{ lang('PAYPAL_ALT') }}" style="cursor:pointer;margin-top:15px;"></a></dd>
++-	</dl>
++-</fieldset>
++-{% if TF_ERROR %}
++-	<div class="errorbox"><h3>{{ lang('WARNING') }}</h3>
++-		<p>{{ TF_ERROR }}</p>
+++<h1>{L_TF_TITLE}</h1>
+++<p>{L_TF_VERSION} {TF_VERSION}</p>
+++
+++<!-- IF TF_ERROR -->
+++	<div class="errorbox"><h3>{L_WARNING}</h3>
+++		<p>{TF_ERROR}</p>
++ 	</div>
++-{% endif %}
+++<!-- ENDIF -->
++ 
++-<form id="acp_topfive" method="post" action="{{ U_ACTION }}">
+++<form id="acp_topfive" method="post" action="{U_ACTION}">
++ 	<fieldset>
++-		<legend>{{ lang('TF_CONFIG') }}</legend>
++-		<dl>
++-			<dt><label>{{ lang('TF_LOCATION') ~ lang('COLON') }}</label><br>
++-			<span>{{ lang('TF_LOCATION_EXPLAIN') }}</span></dt>
++-			<dd><select name="top_five_location">{{ LOCATION }}</select></dd>
++-		</dl>
+++		<legend>{L_TF_CONFIG}</legend>
++ 		<dl>
++-			<dt><label>{{ lang('TF_AVATARS') }}</label><br />{{ lang('TF_AVATARS_EXPLAIN') }}</dt>
++-			<dd><input type="radio" class="radio" name="top_five_avatars" value="1" {% if AVATARS %}checked="checked"{% endif %}/> {{ lang('YES') }} &nbsp;
++-				<input type="radio" class="radio" name="top_five_avatars" value="0" {% if not AVATARS %}checked="checked"{% endif %} /> {{ lang('NO') }}</dd>
+++			<dt><label id="top_five_active" for="top_five_active">{L_TF_ACTIVE}</label></dt>
+++			<dd><input type="radio" class="radio" name="top_five_active" value="1" <!-- IF ACTIVE -->checked="checked"<!-- ENDIF -->/> {L_YES} &nbsp;
+++				<input type="radio" class="radio" name="top_five_active" value="0" <!-- IF not ACTIVE -->checked="checked"<!-- ENDIF --> /> {L_NO}</dd>
++ 		</dl>
++ 		<dl>
++-			<dt><label>{{ lang('TF_HOWMANY') }}</label><br />{{ lang('TF_HOWMANY_EXPLAIN') }}</dt>
++-			<dd><input type="number" name="top_five_how_many" size="10" min="5" max="100" value="{{ HOWMANY }}" /></dd>
+++			<dt><label id="top_five_location" for="top_five_location">{L_TF_LOCATION}</label><br />{L_TF_LOCATION_EXPLAIN}</dt>
+++			<dd><input type="radio" class="radio" name="top_five_location" value="1" <!-- IF LOCATION -->checked="checked"<!-- ENDIF -->/> {L_TOP_OF_FORUM} &nbsp;
+++				<input type="radio" class="radio" name="top_five_location" value="0" <!-- IF not LOCATION -->checked="checked"<!-- ENDIF --> /> {L_BOTTOM_OF_FORUM}</dd>
++ 		</dl>
++ 		<dl>
++-			<dt><label>{{ lang('TF_EXCLUDED') ~ lang('COLON') }}</label><br /><span>{{ lang('TF_EXCLUDED_EXPLAIN') }}</span></dt>
++-			<dd>{{ TF_EXCLUDED }}</dd>
+++			<dt><label id="top_five_how_many" for="top_five_how_many">{L_TF_HOWMANY}</label><br />{L_TF_HOWMANY_EXPLAIN}</dt>
+++			<dd><input type="text" name="top_five_how_many" id="top_five_how_many" size="10" value="{HOWMANY}" /></dd>
++ 		</dl>
++ 		<dl>
++-			<dt><label>{{ lang('TF_IGNORE_USERS') }}</label><br />{{ lang('TF_IGNORE_USERS_EXPLAIN') }}</dt>
++-			<dd><input type="radio" class="radio" name="top_five_ignore_inactive_users" value="1" {% if IGNORE_INACTIVE %}checked="checked"{% endif %}/> {{ lang('YES') }} &nbsp;
++-				<input type="radio" class="radio" name="top_five_ignore_inactive_users" value="0" {% if not IGNORE_INACTIVE %}checked="checked"{% endif %} /> {{ lang('NO') }}</dd>
+++			<dt><label id="top_five_ignore_inactive_users" for="top_five_ignore_inactive_users">{L_TF_IGNORE_USERS}</label><br />{L_TF_IGNORE_USERS_EXPLAIN}</dt>
+++			<dd><input type="radio" class="radio" name="top_five_ignore_inactive_users" value="1" <!-- IF IGNORE_INACTIVE -->checked="checked"<!-- ENDIF -->/> {L_YES} &nbsp;
+++				<input type="radio" class="radio" name="top_five_ignore_inactive_users" value="0" <!-- IF not IGNORE_INACTIVE -->checked="checked"<!-- ENDIF --> /> {L_NO}</dd>
++ 		</dl>
++ 		<dl>
++-			<dt><label>{{ lang('TF_IGNORE_FOUNDER') }}</label><br />{{ lang('TF_IGNORE_FOUNDER_EXPLAIN') }}</dt>
++-			<dd><input type="radio" class="radio" name="top_five_ignore_founder" value="1" {% if IGNORE_FOUNDER %}checked="checked"{% endif %}/> {{ lang('YES') }} &nbsp;
++-				<input type="radio" class="radio" name="top_five_ignore_founder" value="0" {% if not IGNORE_FOUNDER %}checked="checked"{% endif %} /> {{ lang('NO') }}</dd>
+++			<dt><label id="top_five_ignore_founder" for="top_five_ignore_founder">{L_TF_IGNORE_FOUNDER}</label><br />{L_TF_IGNORE_FOUNDER_EXPLAIN}</dt>
+++			<dd><input type="radio" class="radio" name="top_five_ignore_founder" value="1" <!-- IF IGNORE_FOUNDER -->checked="checked"<!-- ENDIF -->/> {L_YES} &nbsp; 
+++				<input type="radio" class="radio" name="top_five_ignore_founder" value="0" <!-- IF not IGNORE_FOUNDER -->checked="checked"<!-- ENDIF --> /> {L_NO}</dd>
++ 		</dl>
++ 		<dl>
++-			<dt><label>{{ lang('TF_SHOW_ADMINS_MODS') }}</label><br />{{ lang('TF_SHOW_ADMINS_MODS_EXPLAIN') }}</dt>
++-			<dd><input type="radio" class="radio" name="top_five_show_admins_mods" value="1" {% if SHOW_ADMINS_MODS %}checked="checked"{% endif %}/> {{ lang('YES') }} &nbsp;
++-				<input type="radio" class="radio" name="top_five_show_admins_mods" value="0" {% if not SHOW_ADMINS_MODS %}checked="checked"{% endif %} /> {{ lang('NO') }}</dd>
+++			<dt><label id="top_five_show_admins_mods" for="top_five_show_admins_mods">{L_TF_SHOW_ADMINS_MODS}</label><br />{L_TF_SHOW_ADMINS_MODS_EXPLAIN}</dt>
+++			<dd><input type="radio" class="radio" name="top_five_show_admins_mods" value="1" <!-- IF SHOW_ADMINS_MODS -->checked="checked"<!-- ENDIF -->/> {L_YES} &nbsp;
+++				<input type="radio" class="radio" name="top_five_show_admins_mods" value="0" <!-- IF not SHOW_ADMINS_MODS -->checked="checked"<!-- ENDIF --> /> {L_NO}</dd>
++ 		</dl>
++ 		<p class="submit-buttons">
++-			<input class="button1" type="submit" id="submit" name="submit" value="{{ lang('SUBMIT') }}" />&nbsp;
++-			<input class="button2" type="reset" id="reset" name="reset" value="{{ lang('RESET') }}" />
++-		{{ S_FORM_TOKEN }}
+++			<input class="button1" type="submit" id="submit" name="submit" value="{L_SUBMIT}" />&nbsp;
+++			<input class="button2" type="reset" id="reset" name="reset" value="{L_RESET}" />
+++		{S_FORM_TOKEN}
++ 		</p>
++ 	</fieldset>
++ </form>
++-{% INCLUDE 'overall_footer.html' %}
+++<!-- INCLUDE overall_footer.html -->
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/adm/style/event/acp_ext_details_end.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/adm/style/event/acp_ext_details_end.html"
++deleted file mode 100644
++index 5a3267046..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/adm/style/event/acp_ext_details_end.html"
+++++ /dev/null
++@@ -1,9 +0,0 @@
++-{% if S_BUY_ME_A_BEER_TOPFIVE %}
++-	<fieldset>
++-		<legend>{{ lang('BUY_ME_A_BEER') }}</legend>
++-		<dl>
++-			<dt><label>{{ lang('BUY_ME_A_BEER_SHORT') }}{{ lang('COLON') }}</label><br /><span>{{ lang('BUY_ME_A_BEER_EXPLAIN') }}</span></dt>
++-			<dd><a href="{{ lang('BUY_ME_A_BEER_URL') }}" target="_blank" rel="noreferrer noopener"><img src="{{ lang('PAYPAL_IMAGE_URL') }}" border="0" alt="{{ lang('PAYPAL_ALT') }}" style="cursor:pointer;margin-top:15px;"></a></dd>
++-		</dl>
++-	</fieldset>
++-{% endif %}
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\topfive/composer.json"
++index 531076584..ac1d70338 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/composer.json"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\topfive/composer.json"
++@@ -1,38 +1,36 @@
++ {
++     "name": "rmcgirr83/topfive",
++     "type": "phpbb-extension",
++-    "description": "Displays statistics of the latest new posts, new users and most active users on the forum index page.",
+++    "description": "Displays statistics of the latest new posts, new users and most active users on the boards index page.",
++     "homepage": "https://github.com/RMcGirr83/topfive",
++-    "version": "1.2.8",
++-    "time": "2024-10-26",
+++    "version": "1.0.2",
+++    "time": "2015-05-28",
++     "keywords": [
++         "phpbb",
++         "extension",
++         "top five"
++     ],
++-    "license": "GPL-2.0-only",
+++    "license": "GPL-2.0",
++     "authors": [
++         {
++             "name": "Rich McGirr",
++-            "homepage": "https://paypal.me/rmcgirr83",
+++            "homepage": "https://www.phpbb.com/customise/db/author/rmcgirr83/contributions",
+++            "email": "rmcgirr83@rmcgirr83.org",
++             "role": "Lead Developer"
++         }
++     ],
++     "require": {
++-        "php": ">=7.4",
++-        "phpbb/phpbb": ">=3.3",
++-        "composer/installers": "~1.0.0"
+++        "php": ">=5.3.3"
++     },
++     "extra": {
++-        "display-name": "Top Five Extension",
+++        "display-name": "Top Five",
++         "soft-require": {
++-            "phpbb/phpbb": ">=3.3"
+++            "phpbb/phpbb": ">=3.1.2,<3.2.*@dev"
++         },
++         "version-check": {
++             "host": "www.phpbb.com",
++             "directory": "/customise/db/extension/topfiveext",
++-            "filename": "version_check",
++-            "ssl": true
+++            "filename": "version_check"
++         }
++     }
++ }
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/config/services.yml" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\topfive/config/services.yml"
++index c499f0988..7654a7bd9 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/config/services.yml"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\topfive/config/services.yml"
++@@ -1,20 +1,5 @@
++-imports:
++-    - { resource: topfive_constants.yml }
++-
++ services:
++-    rmcgirr83.topfive.admin.controller:
++-        class: rmcgirr83\topfive\controller\admin_controller
++-        arguments:
++-            - '@cache'
++-            - '@config'
++-            - '@language'
++-            - '@request'
++-            - '@template'
++-            - '%core.root_path%'
++-            - '%core.php_ext%'
++-            - '%topfive_constants%'
++-
++-    rmcgirr83.topfive.topfive:
+++    rmcgirr83.topfive.functions:
++         class: rmcgirr83\topfive\core\topfive
++         arguments:
++             - '@auth'
++@@ -23,25 +8,17 @@ services:
++             - '@content.visibility'
++             - '@dbal.conn'
++             - '@dispatcher'
++-            - '@language'
++             - '@template'
++             - '@user'
++             - '%core.root_path%'
++             - '%core.php_ext%'
++-            - '@?senky.relativedates.listener'
++-            - '@?rmcgirr83.nationalflags.nationalflags'
++ 
++     rmcgirr83.topfive.listener:
++         class: rmcgirr83\topfive\event\listener
++         arguments:
++-            - '@rmcgirr83.topfive.topfive'
+++            - '@rmcgirr83.topfive.functions'
++             - '@config'
++-            - '@language'
++             - '@template'
++             - '@user'
++-            - '@controller.helper'
++-            - '%core.php_ext%'
++-            - '%topfive_constants%'
++-            - '@?phpbb.collapsiblecategories.operator'
++         tags:
++             - { name: event.listener }
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/config/topfive_constants.yml" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/config/topfive_constants.yml"
++deleted file mode 100644
++index b60ea6065..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/config/topfive_constants.yml"
+++++ /dev/null
++@@ -1,6 +0,0 @@
++-parameters:
++-    topfive_constants:
++-        top_of_index: 0
++-        bottom_of_index: 1
++-        top_of_entire_forum: 2
++-        bottom_of_entire_forum: 3
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/controller/admin_controller.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/controller/admin_controller.php"
++deleted file mode 100644
++index 40a3df971..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/controller/admin_controller.php"
+++++ /dev/null
++@@ -1,190 +0,0 @@
++-<?php
++-/**
++-*
++-* Top Five extension for the phpBB Forum Software package.
++-*
++-* @copyright 2016 Rich McGirr (RMcGirr83)
++-* @license GNU General Public License, version 2 (GPL-2.0)
++-*
++-*/
++-
++-namespace rmcgirr83\topfive\controller;
++-
++-use phpbb\cache\service as cache;
++-use phpbb\config\config;
++-use phpbb\language\language;
++-use phpbb\request\request;
++-use phpbb\template\template;
++-
++-class admin_controller
++-{
++-	/** @var cache */
++-	protected $cache;
++-
++-	/** @var config */
++-	protected $config;
++-
++-	/** @var language */
++-	protected $language;
++-
++-	/** @var request */
++-	protected $request;
++-
++-	/** @var template */
++-	protected $template;
++-
++-	/** @var string phpBB root path */
++-	protected $root_path;
++-
++-	/** @var string phpEx */
++-	protected $php_ext;
++-
++-	/* @var array topfive_constants */
++-	protected $topfive_constants;
++-
++-	/** @var string Custom form action */
++-	protected $u_action;
++-
++-	/**
++-	* Constructor
++-	*
++-	* @param cache						$cache				Cache object
++-	* @param config						$config				Config object
++-	* @param language					$language			Language object
++-	* @param request					$request			Request object
++-	* @param template					$template			Template object
++-	* @param string						$root_path			phpBB root path
++-	* @param string						$php_ext			phpEx
++-	* @param array						$topfive_constants	Constants for the extension
++-	* @access public
++-	*/
++-	public function __construct(
++-			cache $cache,
++-			config $config,
++-			language $language,
++-			request $request,
++-			template $template,
++-			string $root_path,
++-			string $php_ext,
++-			array $topfive_constants)
++-	{
++-		$this->cache = $cache;
++-		$this->config = $config;
++-		$this->language = $language;
++-		$this->request = $request;
++-		$this->template = $template;
++-		$this->root_path = $root_path;
++-		$this->php_ext = $php_ext;
++-		$this->topfive_constants = $topfive_constants;
++-	}
++-
++-	public function display_options()
++-	{
++-		$this->language->add_lang('acp_topfive', 'rmcgirr83/topfive');
++-
++-		// Create a form key for preventing CSRF attacks
++-		add_form_key('acp_topfive');
++-
++-		// get the excluded forums
++-		$excluded_forums = explode(',', $this->config['top_five_excluded']);
++-
++-		if ($this->request->is_set_post('submit'))
++-		{
++-			if (!check_form_key('acp_topfive'))
++-			{
++-				trigger_error('FORM_INVALID');
++-			}
++-			if (!function_exists('validate_data'))
++-			{
++-				include($this->root_path . 'includes/functions_user.' . $this->php_ext);
++-			}
++-
++-			$check_row = array('top_five_how_many' => $this->request->variable('top_five_how_many', 0));
++-			$validate_row = array('top_five_how_many' => array('num', false, 5, 100));
++-			$error = validate_data($check_row, $validate_row);
++-			// Replace "error" strings with their real, localised form
++-			$error = array_map(array($this->language, 'lang'), $error);
++-
++-			if (!sizeof($error))
++-			{
++-				$this->set_options();
++-
++-				$this->cache->destroy('_top_five_newest_users');
++-				$this->cache->destroy('_top_five_posters');
++-
++-				trigger_error($this->language->lang('TF_SAVED') . adm_back_link($this->u_action));
++-			}
++-		}
++-
++-		$this->template->assign_vars(array(
++-			'TF_ERROR'			=> isset($error) ? ((sizeof($error)) ? implode('<br />', $error) : '') : '',
++-			'HOWMANY'			=> isset($this->config['top_five_how_many']) ? $this->config['top_five_how_many'] : 0,
++-			'IGNORE_INACTIVE'	=> isset($this->config['top_five_ignore_inactive_users']) ? $this->config['top_five_ignore_inactive_users'] : false,
++-			'IGNORE_FOUNDER'	=> isset($this->config['top_five_ignore_founder']) ? $this->config['top_five_ignore_founder'] : false,
++-			'SHOW_ADMINS_MODS'	=> isset($this->config['top_five_show_admins_mods']) ? $this->config['top_five_show_admins_mods'] : false,
++-			'LOCATION'			=> $this->location($this->config['top_five_location']),
++-			'ACTIVE'			=> isset($this->config['top_five_active']) ? $this->config['top_five_active'] : false,
++-			'TF_EXCLUDED'		=> $this->forum_select($excluded_forums),
++-			'AVATARS'		=> isset($this->config['top_five_avatars']) ? $this->config['top_five_avatars'] : false,
++-
++-			'U_ACTION'			=> $this->u_action,
++-		));
++-	}
++-
++-	protected function set_options()
++-	{
++-		$this->config->set('top_five_how_many', $this->request->variable('top_five_how_many', 0));
++-		$this->config->set('top_five_ignore_inactive_users', $this->request->variable('top_five_ignore_inactive_users', 0));
++-		$this->config->set('top_five_ignore_founder', $this->request->variable('top_five_ignore_founder', 0));
++-		$this->config->set('top_five_show_admins_mods', $this->request->variable('top_five_show_admins_mods', 0));
++-		$this->config->set('top_five_location', $this->request->variable('top_five_location', 0));
++-		$this->config->set('top_five_active', $this->request->variable('top_five_active', 0));
++-
++-		// variable should be '' as it is a string ("1, 2, 3928") here, not an integer.
++-		$forums = $this->request->variable('selectForms',  array(''));
++-		// change the array to a string
++-		$forums  = implode(',', $forums);
++-		$this->config->set('top_five_excluded', $forums);
++-		$this->config->set('top_five_avatars', $this->request->variable('top_five_avatars',0));
++-	}
++-
++-	/**
++-	 * Display a drop down of all forums for selection
++-	 *
++-	 * @return drop down select
++-	 * @access protected
++-	 */
++-	private function forum_select($value)
++-	{
++-		return '<select id="top_five_excluded" name="selectForms[]" multiple="multiple">' . make_forum_select($value, false, true, true) . '</select>';
++-	}
++-
++-	/**
++-	 * Create the selection for the post method
++-	 */
++-	public function location($location = 0)
++-	{
++-		// location options
++-		$location_text = [$this->topfive_constants['top_of_index'] => $this->language->lang('TOP_OF_FORUM'), $this->topfive_constants['bottom_of_index'] => $this->language->lang('BOTTOM_OF_FORUM'), $this->topfive_constants['top_of_entire_forum'] => $this->language->lang('TOP_OF_ENTIRE_FORUM'), $this->topfive_constants['bottom_of_entire_forum'] => $this->language->lang('BOTTOM_OF_ENTIRE_FORUM')];
++-		$location_options = '';
++-		foreach ($location_text as $value => $text)
++-		{
++-			$selected = ($value == $location) ? ' selected="selected"' : '';
++-			$location_options .= "<option value='{$value}'$selected>$text</option>";
++-		}
++-
++-		return $location_options;
++-	}
++-
++-	/**
++-	 * Set page url
++-	 *
++-	 * @param string $u_action Custom form action
++-	 * @return null
++-	 * @access public
++-	 */
++-	public function set_page_url($u_action)
++-	{
++-		$this->u_action = $u_action;
++-	}
++-}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/core/topfive.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\topfive/core/topfive.php"
++index 4facdbedc..3d9f9352e 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/core/topfive.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\topfive/core/topfive.php"
++@@ -11,65 +11,39 @@
++ 
++ namespace rmcgirr83\topfive\core;
++ 
++-use phpbb\auth\auth;
++-use phpbb\config\config;
++-use phpbb\cache\service as cache_service;
++-use phpbb\content_visibility;
++-use phpbb\db\driver\driver_interface;
++-use phpbb\event\dispatcher_interface;
++-use phpbb\language\language;
++-use phpbb\template\template;
++-use phpbb\user;
++-
++ class topfive
++ {
++-	/** @var auth */
+++	/** @var \phpbb\auth\auth */
++ 	protected $auth;
++ 
++-	/** @var config */
+++	/** @var \phpbb\config\config */
++ 	protected $config;
++ 
++-	/** @var cache */
+++	/** @var \phpbb\cache\driver\driver_interface */
++ 	protected $cache;
++ 
++-	/** @var content_visibility */
+++	/** @var \phpbb\content_visibility */
++ 	protected $content_visibility;
++ 
++-	/** @var db */
+++	/** @var \phpbb\db\driver\driver_interface */
++ 	protected $db;
++ 
++-	/** @var dispatcher */
+++	/** @var \phpbb\event\dispatcher_interface */
++ 	protected $dispatcher;
++ 
++-	/** @var language */
++-	protected $language;
++-
++-	/** @var template */
+++	/** @var \phpbb\template\template */
++ 	protected $template;
++ 
++-	/** @var user */
+++	/** @var \phpbb\user */
++ 	protected $user;
++ 
++-	/** @var string phpbb_root_path */
+++	/** @var string phpBB root path */
++ 	protected $phpbb_root_path;
++ 
++-	/** @var string php_ext */
+++	/** @var string PHP extension */
++ 	protected $php_ext;
++ 
++-	public function __construct(
++-		auth $auth,
++-		config $config,
++-		cache_service $cache,
++-		content_visibility $content_visibility,
++-		driver_interface $db,
++-		dispatcher_interface $dispatcher,
++-		language $language,
++-		template $template,
++-		user $user,
++-		string $phpbb_root_path,
++-		string $php_ext,
++-		\senky\relativedates\event\listener $relativedates = null,
++-		\rmcgirr83\nationalflags\core\nationalflags $nationalflags= null)
+++	public function __construct(\phpbb\auth\auth $auth, \phpbb\config\config $config, \phpbb\cache\service $cache, \phpbb\content_visibility $content_visibility, \phpbb\db\driver\driver_interface $db, \phpbb\event\dispatcher_interface $dispatcher, \phpbb\template\template $template, \phpbb\user $user, $phpbb_root_path, $php_ext)
++ 	{
++ 		$this->auth = $auth;
++ 		$this->config = $config;
++@@ -77,27 +51,18 @@ class topfive
++ 		$this->content_visibility = $content_visibility;
++ 		$this->db = $db;
++ 		$this->dispatcher = $dispatcher;
++-		$this->language = $language;
++ 		$this->template = $template;
++ 		$this->user = $user;
++ 		$this->root_path = $phpbb_root_path;
++ 		$this->php_ext = $php_ext;
++-		$this->relativedates = $relativedates;
++-		$this->nationalflags = $nationalflags;
++ 	}
++ 
++-	/**
++-	* Display activity
++-	*
++-	* @param	string	$tpl_loopname	Name of the html file
++-	* @return 	null
++-	* @access 	public
++-	*/
++ 	public function toptopics($tpl_loopname = 'top_five_topic')
++ 	{
+++
++ 		$howmany = $this->howmany();
++ 
++-		$forum_ary = [];
+++		$forum_ary = array();
++ 		$forum_read_ary = $this->auth->acl_getf('f_read');
++ 
++ 		foreach ($forum_read_ary as $forum_id => $allowed)
++@@ -109,220 +74,184 @@ class topfive
++ 		}
++ 		$forum_ary = array_unique($forum_ary);
++ 
++-		// want to exclude some forums
++-		$excluded_forums = explode(',', $this->config['top_five_excluded']);
++-
++-		// now remove those topics from the display per the excluded forums array
++-		$forum_ary = array_diff($forum_ary, $excluded_forums);
++-
++-		if (!sizeof($forum_ary))
+++		if (sizeof($forum_ary))
++ 		{
++-			$this->template->assign_block_vars($tpl_loopname, [
++-				'NO_TOPIC_TITLE'	=> $this->language->lang('NO_TOPIC_EXIST'),
++-			]);
++-
++-			return false;
++-		}
++-
++-		/**
++-		* Select topic_ids
++-		*/
++-		// grab all posts that meet criteria and auths
++-		$sql_array = [
++-			'SELECT'	=> 't.forum_id, t.topic_id, t.topic_type',
++-			'FROM'		=> [TOPICS_TABLE => 't'],
++-			'WHERE'		=> $this->content_visibility->get_forums_visibility_sql('topic', $forum_ary) . ' AND topic_status <> ' . ITEM_MOVED,
++-			'ORDER_BY'	=> 't.topic_last_post_time DESC',
++-		];
++-
++-		$result = $this->db->sql_query_limit($this->db->sql_build_query('SELECT', $sql_array), $howmany);
++-
++-		$forums = $ga_topic_ids = $topic_ids = [];
++-		while ($row = $this->db->sql_fetchrow($result))
++-		{
++-			$topic_ids[] = $row['topic_id'];
++-			if ($row['topic_type'] == POST_GLOBAL)
+++			/**
+++			* Select topic_ids
+++			*/
+++			$sql = 'SELECT forum_id, topic_id, topic_type
+++				FROM ' . TOPICS_TABLE . '
+++				WHERE ' . $this->content_visibility->get_forums_visibility_sql('topic', $forum_ary) . '
+++				AND topic_status <> ' . ITEM_MOVED . '
+++				ORDER BY topic_last_post_time DESC';
+++
+++			$result = $this->db->sql_query_limit($sql, $howmany);
+++			$forums = $ga_topic_ids = $topic_ids = array();
+++			while ($row = $this->db->sql_fetchrow($result))
++ 			{
++-				$ga_topic_ids[] = $row['topic_id'];
+++				$topic_ids[] = $row['topic_id'];
+++				if ($row['topic_type'] == POST_GLOBAL)
+++				{
+++					$ga_topic_ids[] = $row['topic_id'];
+++				}
+++				else
+++				{
+++					$forums[$row['forum_id']][] = $row['topic_id'];
+++				}
++ 			}
++-			else
+++			$this->db->sql_freeresult($result);
+++
+++			// Get topic tracking
+++			$topic_tracking_info = array();
+++			foreach ($forums as $forum_id => $topic_id)
++ 			{
++-				$forums[$row['forum_id']][] = $row['topic_id'];
+++				$topic_tracking_info[$forum_id] = get_complete_topic_tracking($forum_id, $topic_id, $ga_topic_ids);
++ 			}
++-		}
++-		$this->db->sql_freeresult($result);
++ 
++-		// Get topic tracking
++-		$topic_tracking_info = [];
++-		foreach ($forums as $forum_id => $topic_id)
++-		{
++-			$topic_tracking_info[$forum_id] = get_complete_topic_tracking($forum_id, $topic_id, $ga_topic_ids);
++-		}
++-
++-		/*
++-		* must have topic_ids.
++-		* A user can have forums and not have topic_ids before installing this extension
++-		*/
++-		if (!sizeof($topic_ids))
++-		{
++-			$this->template->assign_block_vars($tpl_loopname, [
++-				'NO_TOPIC_TITLE'	=> $this->language->lang('NO_TOPIC_EXIST'),
++-			]);
++-
++-			return false;
++-		}
++-
++-		// grab all posts that meet criteria and auths
++-		$sql_array = [
++-			'SELECT'	=> 'u.user_id, u.username, u.user_colour, u.user_avatar, u.user_avatar_type, u.user_avatar_height, u.user_avatar_width, t.topic_title, t.forum_id, t.topic_id, t.topic_first_post_id, t.topic_last_post_id, t.topic_last_post_time, t.topic_last_poster_name, f.forum_name',
++-			'FROM'		=> [TOPICS_TABLE => 't'],
++-			'LEFT_JOIN'	=> [
++-				[
++-					'FROM'	=> [USERS_TABLE => 'u'],
++-					'ON'	=> 't.topic_last_poster_id = u.user_id',
++-				],
++-				[
++-					'FROM'	=> [FORUMS_TABLE => 'f'],
++-					'ON'	=> 't.forum_id = f.forum_id',
++-				],
++-			],
++-			'WHERE'		=> $this->db->sql_in_set('t.topic_id', $topic_ids),
++-			'ORDER_BY'	=> 't.topic_last_post_time DESC',
++-		];
++-		if ($this->nationalflags !== null)
++-		{
++-			$sql_array['SELECT'].= ', u.user_flag';
++-		}
++-
++-		/**
++-		* Event to modify the SQL query before the topics data is retrieved
++-		*
++-		* @event rmcgirr83.topfive.sql_pull_topics_data
++-		* @var	array	sql_array		The SQL array
++-		* @since 1.0.0
++-		*/
++-		$vars = ['sql_array'];
++-		extract($this->dispatcher->trigger_event('rmcgirr83.topfive.sql_pull_topics_data', compact($vars)));
++-
++-		$result = $this->db->sql_query_limit($this->db->sql_build_query('SELECT', $sql_array), $howmany);
++-
++-		while ($row = $this->db->sql_fetchrow($result))
++-		{
++-			$topic_id = $row['topic_id'];
++-			$forum_id = $row['forum_id'];
++-			$forum_name = $row['forum_name'];
++-
++-			$post_unread = (isset($topic_tracking_info[$forum_id][$topic_id]) && $row['topic_last_post_time'] > $topic_tracking_info[$forum_id][$topic_id]) ? true : false;
++-			$view_topic_url = !empty($post_unread) ? append_sid("{$this->root_path}viewtopic.$this->php_ext", 't=' . $topic_id . '&amp;view=unread') . '#unread' : append_sid("{$this->root_path}viewtopic.$this->php_ext", 't=' . $topic_id);
++-			/** To go to the last post in a topic use the below as the last argument in the above $view_topic_url variable
++-			append_sid("{$this->root_path}viewtopic.$this->php_ext", 'f=' . $row['forum_id'] . '&amp;p=' . $row['topic_last_post_id'] . '#p' . $row['topic_last_post_id'])
++-			**/
++-			$forum_name_url = append_sid("{$this->root_path}viewforum.$this->php_ext", 'f=' . $row['forum_id']);
++-			$topic_title = censor_text($row['topic_title']);
++-			$topic_title = truncate_string($topic_title, 60, 255, false, $this->language->lang('ELLIPSIS'));
++-
++-			$is_guest = ($row['user_id'] == ANONYMOUS) ? true : false;
++-
++-			$user_avatar = phpbb_get_user_avatar($row);
++-			$display_avatar = (!empty($this->config['top_five_avatars']) && $this->user->optionget('viewavatars') && !empty($user_avatar)) ? true : false;
++-
++-			$user_avatar = $display_avatar ? '<span class="topfive-avatar">' . $user_avatar . '</span>&nbsp;' : '';
++-
++-			// relativedates installed?
++-			if ($this->relativedates !== null)
+++			/*
+++			* must have topic_ids.
+++			* A user can have forums and not have topic_ids before installing this extension
+++			*/
+++			if (sizeof($topic_ids))
++ 			{
++-				$last_topic_time = $this->user->format_date($row['topic_last_post_time'], false, false, false);
+++				// grab all posts that meet criteria and auths
+++				$sql_array = array(
+++					'SELECT'	=> 'u.user_id, u.username, u.user_colour, u.user_avatar, u.user_avatar_type, u.user_avatar_width, u.user_avatar_height, t.topic_title, t.forum_id, t.topic_id, t.topic_first_post_id, t.topic_last_post_id, t.topic_last_post_time, t.topic_last_poster_name, f.forum_name',
+++					'FROM'		=> array(TOPICS_TABLE => 't'),
+++					'LEFT_JOIN'	=> array(
+++						array(
+++							'FROM'	=> array(USERS_TABLE => 'u'),
+++							'ON'	=> 't.topic_last_poster_id = u.user_id',
+++						),
+++						array(
+++							'FROM'	=> array(FORUMS_TABLE => 'f'),
+++							'ON'	=> 't.forum_id = f.forum_id',
+++						),
+++					),
+++					'WHERE'		=> $this->db->sql_in_set('t.topic_id', $topic_ids),
+++					'ORDER_BY'	=> 't.topic_last_post_time DESC',
+++				);
+++				/**
+++				* Event to modify the SQL query before the topics data is retrieved
+++				*
+++				* @event rmcgirr83.topfive.sql_pull_topics_data
+++				* @var	array	sql_array		The SQL array
+++				* @since 1.0.0
+++				*/
+++				$vars = array('sql_array');
+++				extract($this->dispatcher->trigger_event('rmcgirr83.topfive.sql_pull_topics_data', compact($vars)));
+++
+++				// cache the query for one minute
+++				$result = $this->db->sql_query_limit($this->db->sql_build_query('SELECT', $sql_array), $howmany, 0, 60);
+++
+++				while ($row = $this->db->sql_fetchrow($result))
+++				{
+++					$topic_id = $row['topic_id'];
+++					$forum_id = $row['forum_id'];
+++					$forum_name = $row['forum_name'];
+++
+++					$post_unread = (isset($topic_tracking_info[$forum_id][$topic_id]) && $row['topic_last_post_time'] > $topic_tracking_info[$forum_id][$topic_id]) ? true : false;
+++					$view_topic_url = append_sid("{$this->phpbb_root_path}viewtopic.$this->php_ext", 'f=' . $row['forum_id'] . '&amp;p=' . $row['topic_last_post_id'] . '#p' . $row['topic_last_post_id']);
+++					$forum_name_url = append_sid("{$this->phpbb_root_path}viewforum.$this->php_ext", 'f=' . $row['forum_id']);
+++					$topic_title = censor_text($row['topic_title']);
+++					if (utf8_strlen($topic_title) >= 60)
+++					{
+++						$topic_title = (utf8_strlen($topic_title) > 60 + 3) ? utf8_substr($topic_title, 0, 60) . '...' : $topic_title;
+++					}
+++					$is_guest = ($row['user_id'] == ANONYMOUS) ? true : false;
+++                    $user_avatar = ($row['user_avatar']) ? get_user_avatar($row['user_avatar'], $row['user_avatar_type'], 50, 50) : '<img src="' . generate_board_url() . '/styles/' . '/FLATBOOTS/' . '/theme/images/no_avatar.gif" height="50" width="50" alt="Default Avatar" />';
+++					
+++					$tpl_ary = array(
+++						'U_TOPIC'			=> $view_topic_url,
+++						'U_FORUM'			=> $forum_name_url,
+++						'TOP5_AVATAR' 	    => $user_avatar,
+++						'S_UNREAD'			=> ($post_unread) ? true : false,
+++						'USERNAME_FULL'		=> ($is_guest || !$this->auth->acl_get('u_viewprofile')) ? $this->user->lang['POST_BY_AUTHOR'] . ' ' . get_username_string('no_profile', $row['user_id'], $row['username'], $row['user_colour'], $row['topic_last_poster_name']) : $this->user->lang['POST_BY_AUTHOR'] . ' ' . get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']),
+++						'LAST_TOPIC_TIME'	=> $this->user->format_date($row['topic_last_post_time']),
+++						'TOPIC_TITLE' 		=> $topic_title,
+++						'FORUM_NAME'		=> $forum_name,
+++					);
+++					/**
+++					* Modify the topic data before it is assigned to the template
+++					*
+++					* @event rmcgirr83.topfive.modify_tpl_ary
+++					* @var	array	row			Array with topic data
+++					* @var	array	tpl_ary		Template block array with topic data
+++					* @since 1.0.0
+++					*/
+++					$vars = array('row', 'tpl_ary');
+++					extract($this->dispatcher->trigger_event('rmcgirr83.topfive.modify_tpl_ary', compact($vars)));
+++
+++					$this->template->assign_block_vars($tpl_loopname, $tpl_ary);
+++				}
+++				$this->db->sql_freeresult($result);
++ 			}
++ 			else
++ 			{
++-				$last_topic_time = $this->user->format_date($row['topic_last_post_time']);
+++				$this->template->assign_block_vars($tpl_loopname, array(
+++					'NO_TOPIC_TITLE'	=> $this->user->lang['NO_TOPIC_EXIST'],
+++				));
++ 			}
++-
++-			$user_flag = '';
++-			// nationalflags installed?
++-			if (!empty($row['user_flag']))
++-			{
++-				$user_flag = $this->nationalflags->get_user_flag($row['user_flag'], 12);
++-			}
++-
++-			$tpl_ary = [
++-				'U_TOPIC'	=> $view_topic_url,
++-				'U_FORUM'	=> $forum_name_url,
++-				'S_UNREAD'	=> ($post_unread) ? true : false,
++-				'USERNAME_FULL'	=> ($is_guest || !$this->auth->acl_get('u_viewprofile')) ? $this->language->lang('BY') . $user_avatar . get_username_string('no_profile', $row['user_id'], $row['username'], $row['user_colour'], $row['topic_last_poster_name']) : $this->language->lang('BY') . $user_avatar . get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']),
++-				'LAST_TOPIC_TIME'	=> $last_topic_time,
++-				'TOPIC_TITLE'	=> $topic_title,
++-				'FORUM_NAME'	=> $forum_name,
++-				'USER_FLAG'	=> !empty($user_flag) ? $user_flag : '',
++-			];
++-
++-			/**
++-			* Modify the topic data before it is assigned to the template
++-			*
++-			* @event rmcgirr83.topfive.modify_tpl_ary
++-			* @var	array	row			Array with topic data
++-			* @var	array	tpl_ary		Template block array with topic data
++-			* @since 1.0.0
++-			*/
++-			$vars = ['row', 'tpl_ary'];
++-			extract($this->dispatcher->trigger_event('rmcgirr83.topfive.modify_tpl_ary', compact($vars)));
++-
++-			$this->template->assign_block_vars($tpl_loopname, $tpl_ary);
++ 		}
++-		$this->db->sql_freeresult($result);
+++		else
+++		{
+++			$this->template->assign_block_vars($tpl_loopname, array(
+++				'NO_TOPIC_TITLE'	=> $this->user->lang['NO_TOPIC_EXIST'],
+++			));
+++		}
++ 	}
++ 
++-	/**
++-	* Get the top posters
++-	*
++-	* @return 	null
++-	* @access 	public
++-	*/
++ 	public function topposters()
++ 	{
++ 		$howmany = $this->howmany();
++ 		$sql_where = $this->ignore_users();
++ 
+++		//set two variables for the sql
+++		$sql_and = $sql_other = '';
+++
++ 		if (($user_posts = $this->cache->get('_top_five_posters')) === false)
++ 		{
++-			$user_posts = [];
++ 
++-			$sql_where .= empty($sql_where) ? 'u.user_posts <> 0' : ' AND u.user_posts <> 0';
+++			$user_posts = $admin_mod_array = array();
+++			// quick check for forum moderators and administrators
+++			// some may not want to show them
+++			$show_admins_mods = $this->config['top_five_show_admins_mods'];
++ 
++-			// do the main sql query
++-			$sql_array = [
++-				'SELECT' => 'u.user_id, u.username, u.user_colour, u.user_posts, u.user_avatar, u.user_avatar_width, u.user_avatar_height, u.user_avatar_type, u.user_lastpost_time',
++-				'FROM' => [USERS_TABLE => 'u'],
++-				'WHERE' => $sql_where,
++-				'ORDER_BY' => 'u.user_lastpost_time DESC, u.user_posts DESC',
++-			];
++-
++-			if ($this->nationalflags !== null)
+++			if (!$show_admins_mods)
++ 			{
++-				$sql_array['SELECT'] .= ', u.user_flag';
+++				// grab all admins
+++				$admin_ary = $this->auth->acl_get_list(false, 'a_', false);
+++				$admin_ary = (!empty($admin_ary[0]['a_'])) ? $admin_ary[0]['a_'] : array();
+++
+++				//grab all mods
+++				$mod_ary = $this->auth->acl_get_list(false,'m_', false);
+++				$mod_ary = (!empty($mod_ary[0]['m_'])) ? $mod_ary[0]['m_'] : array();
+++				$admin_mod_array = array_unique(array_merge($admin_ary, $mod_ary));
+++				if (sizeof($admin_mod_array))
+++				{
+++					$sql_and = empty($sql_where) ? ' WHERE' : ' AND';
+++					$sql_and .= ' ' . $this->db->sql_in_set('user_id', $admin_mod_array, true);
+++				}
++ 			}
++-			$result = $this->db->sql_query_limit($this->db->sql_build_query('SELECT', $sql_array), $howmany);
+++			$sql_other = (empty($sql_and) && empty($sql_where)) ? ' WHERE' : ' AND';
+++			$sql_other .=  ' user_posts <> 0';
++ 
+++			// do the main sql query
+++			$sql = 'SELECT user_id, username, user_colour, user_posts
+++				FROM ' . USERS_TABLE . '
+++				 ' . $sql_where . ' ' . $sql_and . '
+++				' . $sql_other . '
+++				ORDER BY user_posts DESC';
+++
+++			$result = $this->db->sql_query_limit($sql, $howmany);
++ 			while ($row = $this->db->sql_fetchrow($result))
++ 			{
++-				$user_flag = '';
++-				// nationalflags installed?
++-				if (!empty($row['user_flag']))
++-				{
++-					$user_flag = $this->nationalflags->get_user_flag($row['user_flag'], 12);
++-				}
++-				$user_posts[$row['user_id']] = [
+++				$user_posts[$row['user_id']] = array(
++ 					'user_id'      => $row['user_id'],
++ 					'username'      => $row['username'],
++ 					'user_colour'   => $row['user_colour'],
++ 					'user_posts'    => $row['user_posts'],
++-					'user_avatar'	=> $row['user_avatar'],
++-					'user_avatar_width'	=> $row['user_avatar_width'],
++-					'user_avatar_height'	=> $row['user_avatar_height'],
++-					'user_avatar_type'	=> $row['user_avatar_type'],
++-					'user_lastpost_time'	=> $row['user_lastpost_time'],
++-					'user_flag'	=> !empty($user_flag) ? $user_flag : '',
++-				];
+++				);
++ 			}
++ 			$this->db->sql_freeresult($result);
++ 
++@@ -332,81 +261,44 @@ class topfive
++ 
++ 		foreach ($user_posts as $row)
++ 		{
++-			$user_avatar = phpbb_get_user_avatar($row);
++-			$display_avatar = (!empty($this->config['top_five_avatars']) && $this->user->optionget('viewavatars') && !empty($user_avatar)) ? true : false;
++-
++-			$user_avatar = $display_avatar ? '<span class="topfive-avatar">' . $user_avatar . '</span>&nbsp;' : '';
+++			$username_string = ($this->auth->acl_get('u_viewprofile')) ? get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']) : get_username_string('no_profile', $row['user_id'], $row['username'], $row['user_colour']);
++ 
++-			$username_string = ($this->auth->acl_get('u_viewprofile')) ? $user_avatar . get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']) : $user_avatar . get_username_string('no_profile', $row['user_id'], $row['username'], $row['user_colour']);
++-			if ($this->relativedates !== null)
++-			{
++-				$user_lastpost_time = $this->user->format_date($row['user_lastpost_time'], false, false, false);
++-			}
++-			else
++-			{
++-				$user_lastpost_time = $this->user->format_date($row['user_lastpost_time']);
++-			}
++-
++-			$this->template->assign_block_vars('top_five_active',[
++-				'S_SEARCH_ACTION'	=> append_sid("{$this->root_path}search.$this->php_ext", 'author_id=' . $row['user_id'] . '&amp;sr=posts'),
++-				'POSTS'	=> number_format($row['user_posts']),
++-				'USERNAME_FULL'	=> $username_string,
++-				'USER_LASTPOST_TIME'	=> $this->language->lang('USER_LASTPOST_TIME', $user_lastpost_time),
++-				'USER_FLAG'	=> !empty($row['user_flag']) ? $row['user_flag'] : '',
++-			]);
+++			$this->template->assign_block_vars('top_five_active',array(
+++				'S_SEARCH_ACTION'	=> append_sid("{$this->phpbb_root_path}search.$this->php_ext", 'author_id=' . $row['user_id'] . '&amp;sr=posts'),
+++				'POSTS' 			=> number_format($row['user_posts']),
+++				'USERNAME_FULL'		=> $username_string,
+++			));
++ 		}
++ 	}
++ 
++-	/**
++-	* Get the newest members
++-	*
++-	* @return 	null
++-	* @access 	public
++-	*/
++ 	public function newusers()
++ 	{
+++
++ 		$howmany = $this->howmany();
++ 		$sql_where = $this->ignore_users();
++ 
++-		$sql_where .= !empty($sql_where) ? ' AND u.user_inactive_reason = 0' : ' u.user_inactive_reason = 0';
+++		$sql_and = !empty($sql_where) ? ' AND user_inactive_reason = 0' : ' WHERE user_inactive_reason = 0';
++ 		// newest registered users
++ 		if (($newest_users = $this->cache->get('_top_five_newest_users')) === false)
++ 		{
++-			$newest_users = [];
+++			$newest_users = array();
++ 
++ 			// grab most recent registered users
++-			$sql_array = [
++-				'SELECT' => 'u.user_id, u.username, u.user_colour, u.user_regdate, u.user_avatar, u.user_avatar_width, u.user_avatar_height, u.user_avatar_type',
++-				'FROM' => [USERS_TABLE => 'u'],
++-				'WHERE' => $sql_where,
++-				'ORDER_BY' =>  'u.user_regdate DESC',
++-			];
++-			if ($this->nationalflags !== null)
++-			{
++-				$sql_array['SELECT'] .= ', u.user_flag';
++-			}
++-			$result = $this->db->sql_query_limit($this->db->sql_build_query('SELECT', $sql_array), $howmany);
+++			$sql = 'SELECT user_id, username, user_colour, user_regdate
+++				FROM ' . USERS_TABLE . '
+++				' . $sql_where . '
+++				' . $sql_and . '
+++				ORDER BY user_regdate DESC';
+++			$result = $this->db->sql_query_limit($sql, $howmany);
++ 
++ 			while ($row = $this->db->sql_fetchrow($result))
++ 			{
++-				$user_flag = '';
++-				// nationalflags installed?
++-				if (!empty($row['user_flag']))
++-				{
++-					$user_flag = $this->nationalflags->get_user_flag($row['user_flag'], 12);
++-				}
++-
++-				$newest_users[$row['user_id']] = [
+++				$newest_users[$row['user_id']] = array(
++ 					'user_id'				=> $row['user_id'],
++ 					'username'				=> $row['username'],
++ 					'user_colour'			=> $row['user_colour'],
++ 					'user_regdate'			=> $row['user_regdate'],
++-					'user_avatar'			=> $row['user_avatar'],
++-					'user_avatar_width'		=> $row['user_avatar_width'],
++-					'user_avatar_height'	=> $row['user_avatar_height'],
++-					'user_avatar_type'		=> $row['user_avatar_type'],
++-					'user_flag'				=> !empty($user_flag) ? $user_flag : '',
++-				];
+++				);
++ 			}
++ 			$this->db->sql_freeresult($result);
++ 
++@@ -416,27 +308,15 @@ class topfive
++ 
++ 		foreach ($newest_users as $row)
++ 		{
++-			$user_avatar = phpbb_get_user_avatar($row);
++-			$display_avatar = (!empty($this->config['top_five_avatars']) && $this->user->optionget('viewavatars') && !empty($user_avatar)) ? true : false;
++-
++-			$user_avatar = $display_avatar ? '<span class="topfive-avatar">' . $user_avatar . '</span>&nbsp;' : '';
++-
++-			$username_string = ($this->auth->acl_get('u_viewprofile')) ? $user_avatar . get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']) : $user_avatar . get_username_string('no_profile', $row['user_id'], $row['username'], $row['user_colour']);
+++			$username_string = ($this->auth->acl_get('u_viewprofile')) ? get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']) : get_username_string('no_profile', $row['user_id'], $row['username'], $row['user_colour']);
++ 
++-			$this->template->assign_block_vars('top_five_newest',[
+++			$this->template->assign_block_vars('top_five_newest',array(
++ 				'REG_DATE'			=> $this->user->format_date($row['user_regdate']),
++ 				'USERNAME_FULL'		=> $username_string,
++-				'USER_FLAG'			=> !empty($row['user_flag']) ? $row['user_flag'] : '',
++-			]);
+++			));
++ 		}
++ 	}
++ 
++-	/**
++-	* How many to display
++-	*
++-	* @return 	int 	$howmany
++-	* @access 	private
++-	*/
++ 	private function howmany()
++ 	{
++ 		$howmany = $this->config['top_five_how_many'];
++@@ -444,24 +324,18 @@ class topfive
++ 		return (int) $howmany;
++ 	}
++ 
++-	/**
++-	* Ignore users
++-	*
++-	* @return 	string 	$sql_where
++-	* @access 	private
++-	*/
++ 	private function ignore_users()
++ 	{
++ 		// an array of user types we dont' bother with
++-		$ignore_users = $ignore_founders = [];
+++		$ignore_users = $ignore_founders = array();
++ 		if ($this->config['top_five_ignore_inactive_users'])
++ 		{
++-			$ignore_users = [USER_IGNORE, USER_INACTIVE];
+++			$ignore_users = array(USER_IGNORE, USER_INACTIVE);
++ 		}
++ 
++ 		if ($this->config['top_five_ignore_founder'])
++ 		{
++-			$ignore_founders = [USER_FOUNDER];
+++			$ignore_founders = array(USER_FOUNDER);
++ 		}
++ 
++ 		$ignore_users = array_merge($ignore_users, $ignore_founders);
++@@ -470,28 +344,9 @@ class topfive
++ 		$sql_where = '';
++ 		if (sizeof($ignore_users))
++ 		{
++-			$sql_where = $this->db->sql_in_set('u.user_type', $ignore_users, true);
+++			$sql_where = 'WHERE ' . $this->db->sql_in_set('user_type', $ignore_users, true);
++ 		}
++-		$admin_mod_array = [];
++-		// quick check for forum moderators and administrators
++-		// some may not want to show them
++-		$show_admins_mods = $this->config['top_five_show_admins_mods'];
++ 
++-		if (!$show_admins_mods)
++-		{
++-			// grab all admins
++-			$admin_ary = $this->auth->acl_get_list(false, 'a_', false);
++-			$admin_ary = (!empty($admin_ary[0]['a_'])) ? $admin_ary[0]['a_'] : [];
++-
++-			//grab all mods
++-			$mod_ary = $this->auth->acl_get_list(false,'m_', false);
++-			$mod_ary = (!empty($mod_ary[0]['m_'])) ? $mod_ary[0]['m_'] : [];
++-			$admin_mod_array = array_unique(array_merge($admin_ary, $mod_ary));
++-			if (sizeof($admin_mod_array))
++-			{
++-				$sql_where .= empty($sql_where) ? $this->db->sql_in_set('u.user_id', $admin_mod_array, true) : ' AND ' . $this->db->sql_in_set('u.user_id', $admin_mod_array, true);
++-			}
++-		}
++ 		return $sql_where;
++ 	}
++ }
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\topfive/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\topfive/diff_full.tmp"
++new file mode 100644
++index 000000000..7131d19bf
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\topfive/diff_full.tmp"
++@@ -0,0 +1,1183 @@
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/acp/topfive_info.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\topfive/acp/topfive_info.php"
+++index 591b4fa8f..c0f748d31 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/acp/topfive_info.php"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\topfive/acp/topfive_info.php"
+++@@ -19,9 +19,9 @@ class topfive_info
+++ 		return array(
+++ 			'filename'	=> '\rmcgirr83\topfive\acp\topfive_module',
+++ 			'title'		=> 'TF_ACP',
+++-			'version'	=> '1.2.3',
++++			'version'	=> '1.0.0',
+++ 			'modes'		=> array(
+++-				'settings'	=> array('title' => 'TF_CONFIG', 'auth'	=> 'ext_rmcgirr83/topfive && acl_a_extensions' , 'cat'	=> array('TOPFIVE_MOD')),
++++				'settings'	=> array('title' => 'TF_CONFIG', 'auth'	=> 'ext_rmcgirr83/topfive', 'cat'	=> array('TOPFIVE_MOD')),
+++ 			),
+++ 		);
+++ 	}
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/acp/topfive_module.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\topfive/acp/topfive_module.php"
+++index 3cc28d045..c1801a315 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/acp/topfive_module.php"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\topfive/acp/topfive_module.php"
+++@@ -11,21 +11,67 @@ namespace rmcgirr83\topfive\acp;
+++ 
+++ class topfive_module
+++ {
+++-	public $u_action;
++++	var $u_action;
+++ 
+++ 	function main($id, $mode)
+++ 	{
+++-		global $phpbb_container;
++++		global $db, $user, $auth, $template, $cache, $request;
++++		global $config, $phpbb_root_path, $phpbb_admin_path, $phpEx;
+++ 
++++		$this->config = $config;
++++		$this->request = $request;
++++
++++		$user->add_lang('acp/common');
++++		$user->add_lang_ext('rmcgirr83/topfive', 'acp/info_acp_topfive');
+++ 		$this->tpl_name = 'acp_topfive';
+++-		$this->page_title = $phpbb_container->get('language')->lang('TF_ACP');
++++		$this->page_title = $user->lang['TOPFIVE_MOD'];
++++		add_form_key('acp_topfive');
++++
++++		if ($request->is_set_post('submit'))
++++		{
++++			if (!check_form_key('acp_topfive'))
++++			{
++++				trigger_error('FORM_INVALID');
++++			}
++++			if (!function_exists('validate_data'))
++++			{
++++				include($phpbb_root_path . 'includes/functions_user.' . $phpEx);
++++			}
++++
++++			$check_row = array('top_five_how_many' => $request->variable('top_five_how_many', 0));
++++			$validate_row = array('top_five_how_many' => array('num', false, 5, 100));
++++			$error = validate_data($check_row, $validate_row);
++++
++++			// Replace "error" strings with their real, localised form
++++			$error = array_map(array($user, 'lang'), $error);
++++
++++			if (!sizeof($error))
++++			{
++++				$config->set('top_five_how_many', $request->variable('top_five_how_many', 0));
++++				$config->set('top_five_ignore_inactive_users', $request->variable('top_five_ignore_inactive_users', true));
++++				$config->set('top_five_ignore_founder', $request->variable('top_five_ignore_founder', true));
++++				$config->set('top_five_show_admins_mods', $request->variable('top_five_show_admins_mods', true));
++++				$config->set('top_five_location', $request->variable('top_five_location', true));
++++				$config->set('top_five_active', $request->variable('top_five_active', true));
++++
++++				$cache->destroy('_top_five_newest_users');
++++				$cache->destroy('_top_five_posters');
+++ 
+++-		// Get an instance of the admin controller
+++-		$admin_controller = $phpbb_container->get('rmcgirr83.topfive.admin.controller');
++++				trigger_error($user->lang['TF_SAVED'] . adm_back_link($this->u_action));
++++			}
++++		}
+++ 
+++-		// Make the $u_action url available in the admin controller
+++-		$admin_controller->set_page_url($this->u_action);
++++		$template->assign_vars(array(
++++			'TF_ERROR'			=> isset($error) ? ((sizeof($error)) ? implode('<br />', $error) : '') : '',
++++			'HOWMANY'			=> (!empty($this->config['top_five_how_many'])) ? $this->config['top_five_how_many'] : 0,
++++			'IGNORE_INACTIVE'	=> (!empty($this->config['top_five_ignore_inactive_users'])) ? true : false,
++++			'IGNORE_FOUNDER'	=> (!empty($this->config['top_five_ignore_founder'])) ? true : false,
++++			'SHOW_ADMINS_MODS'	=> (!empty($this->config['top_five_show_admins_mods'])) ? true : false,
++++			'LOCATION'			=> (!empty($this->config['top_five_location'])) ? true : false,
++++			'ACTIVE'			=> (!empty($this->config['top_five_active'])) ? true : false,
++++			'TF_VERSION'		=> $this->config['top_five_version'],
+++ 
+++-		$admin_controller->display_options();
++++			'U_ACTION'			=> $this->u_action,
++++		));
+++ 	}
+++ }
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/adm/style/acp_topfive.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\topfive/adm/style/acp_topfive.html"
+++index 48224526d..f799a7138 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/adm/style/acp_topfive.html"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\topfive/adm/style/acp_topfive.html"
+++@@ -1,60 +1,51 @@
+++-{% INCLUDE 'overall_header.html' %}
++++<!-- INCLUDE overall_header.html -->
+++ 
+++-<h1>{{ lang('TF_TITLE') }}</h1>
+++-<fieldset>
+++-	<legend>{{ lang('BUY_ME_A_BEER') }}</legend>
+++-	<dl>
+++-		<dt><label>{{ lang('BUY_ME_A_BEER_SHORT') }}{{ lang('COLON') }}</label><br /><span>{{ lang('BUY_ME_A_BEER_EXPLAIN') }}</span></dt>
+++-		<dd><a href="{{ lang('BUY_ME_A_BEER_URL') }}" target="_blank" rel="noreferrer noopener"><img src="{{ lang('PAYPAL_IMAGE_URL') }}" border="0" alt="{{ lang('PAYPAL_ALT') }}" style="cursor:pointer;margin-top:15px;"></a></dd>
+++-	</dl>
+++-</fieldset>
+++-{% if TF_ERROR %}
+++-	<div class="errorbox"><h3>{{ lang('WARNING') }}</h3>
+++-		<p>{{ TF_ERROR }}</p>
++++<h1>{L_TF_TITLE}</h1>
++++<p>{L_TF_VERSION} {TF_VERSION}</p>
++++
++++<!-- IF TF_ERROR -->
++++	<div class="errorbox"><h3>{L_WARNING}</h3>
++++		<p>{TF_ERROR}</p>
+++ 	</div>
+++-{% endif %}
++++<!-- ENDIF -->
+++ 
+++-<form id="acp_topfive" method="post" action="{{ U_ACTION }}">
++++<form id="acp_topfive" method="post" action="{U_ACTION}">
+++ 	<fieldset>
+++-		<legend>{{ lang('TF_CONFIG') }}</legend>
+++-		<dl>
+++-			<dt><label>{{ lang('TF_LOCATION') ~ lang('COLON') }}</label><br>
+++-			<span>{{ lang('TF_LOCATION_EXPLAIN') }}</span></dt>
+++-			<dd><select name="top_five_location">{{ LOCATION }}</select></dd>
+++-		</dl>
++++		<legend>{L_TF_CONFIG}</legend>
+++ 		<dl>
+++-			<dt><label>{{ lang('TF_AVATARS') }}</label><br />{{ lang('TF_AVATARS_EXPLAIN') }}</dt>
+++-			<dd><input type="radio" class="radio" name="top_five_avatars" value="1" {% if AVATARS %}checked="checked"{% endif %}/> {{ lang('YES') }} &nbsp;
+++-				<input type="radio" class="radio" name="top_five_avatars" value="0" {% if not AVATARS %}checked="checked"{% endif %} /> {{ lang('NO') }}</dd>
++++			<dt><label id="top_five_active" for="top_five_active">{L_TF_ACTIVE}</label></dt>
++++			<dd><input type="radio" class="radio" name="top_five_active" value="1" <!-- IF ACTIVE -->checked="checked"<!-- ENDIF -->/> {L_YES} &nbsp;
++++				<input type="radio" class="radio" name="top_five_active" value="0" <!-- IF not ACTIVE -->checked="checked"<!-- ENDIF --> /> {L_NO}</dd>
+++ 		</dl>
+++ 		<dl>
+++-			<dt><label>{{ lang('TF_HOWMANY') }}</label><br />{{ lang('TF_HOWMANY_EXPLAIN') }}</dt>
+++-			<dd><input type="number" name="top_five_how_many" size="10" min="5" max="100" value="{{ HOWMANY }}" /></dd>
++++			<dt><label id="top_five_location" for="top_five_location">{L_TF_LOCATION}</label><br />{L_TF_LOCATION_EXPLAIN}</dt>
++++			<dd><input type="radio" class="radio" name="top_five_location" value="1" <!-- IF LOCATION -->checked="checked"<!-- ENDIF -->/> {L_TOP_OF_FORUM} &nbsp;
++++				<input type="radio" class="radio" name="top_five_location" value="0" <!-- IF not LOCATION -->checked="checked"<!-- ENDIF --> /> {L_BOTTOM_OF_FORUM}</dd>
+++ 		</dl>
+++ 		<dl>
+++-			<dt><label>{{ lang('TF_EXCLUDED') ~ lang('COLON') }}</label><br /><span>{{ lang('TF_EXCLUDED_EXPLAIN') }}</span></dt>
+++-			<dd>{{ TF_EXCLUDED }}</dd>
++++			<dt><label id="top_five_how_many" for="top_five_how_many">{L_TF_HOWMANY}</label><br />{L_TF_HOWMANY_EXPLAIN}</dt>
++++			<dd><input type="text" name="top_five_how_many" id="top_five_how_many" size="10" value="{HOWMANY}" /></dd>
+++ 		</dl>
+++ 		<dl>
+++-			<dt><label>{{ lang('TF_IGNORE_USERS') }}</label><br />{{ lang('TF_IGNORE_USERS_EXPLAIN') }}</dt>
+++-			<dd><input type="radio" class="radio" name="top_five_ignore_inactive_users" value="1" {% if IGNORE_INACTIVE %}checked="checked"{% endif %}/> {{ lang('YES') }} &nbsp;
+++-				<input type="radio" class="radio" name="top_five_ignore_inactive_users" value="0" {% if not IGNORE_INACTIVE %}checked="checked"{% endif %} /> {{ lang('NO') }}</dd>
++++			<dt><label id="top_five_ignore_inactive_users" for="top_five_ignore_inactive_users">{L_TF_IGNORE_USERS}</label><br />{L_TF_IGNORE_USERS_EXPLAIN}</dt>
++++			<dd><input type="radio" class="radio" name="top_five_ignore_inactive_users" value="1" <!-- IF IGNORE_INACTIVE -->checked="checked"<!-- ENDIF -->/> {L_YES} &nbsp;
++++				<input type="radio" class="radio" name="top_five_ignore_inactive_users" value="0" <!-- IF not IGNORE_INACTIVE -->checked="checked"<!-- ENDIF --> /> {L_NO}</dd>
+++ 		</dl>
+++ 		<dl>
+++-			<dt><label>{{ lang('TF_IGNORE_FOUNDER') }}</label><br />{{ lang('TF_IGNORE_FOUNDER_EXPLAIN') }}</dt>
+++-			<dd><input type="radio" class="radio" name="top_five_ignore_founder" value="1" {% if IGNORE_FOUNDER %}checked="checked"{% endif %}/> {{ lang('YES') }} &nbsp;
+++-				<input type="radio" class="radio" name="top_five_ignore_founder" value="0" {% if not IGNORE_FOUNDER %}checked="checked"{% endif %} /> {{ lang('NO') }}</dd>
++++			<dt><label id="top_five_ignore_founder" for="top_five_ignore_founder">{L_TF_IGNORE_FOUNDER}</label><br />{L_TF_IGNORE_FOUNDER_EXPLAIN}</dt>
++++			<dd><input type="radio" class="radio" name="top_five_ignore_founder" value="1" <!-- IF IGNORE_FOUNDER -->checked="checked"<!-- ENDIF -->/> {L_YES} &nbsp; 
++++				<input type="radio" class="radio" name="top_five_ignore_founder" value="0" <!-- IF not IGNORE_FOUNDER -->checked="checked"<!-- ENDIF --> /> {L_NO}</dd>
+++ 		</dl>
+++ 		<dl>
+++-			<dt><label>{{ lang('TF_SHOW_ADMINS_MODS') }}</label><br />{{ lang('TF_SHOW_ADMINS_MODS_EXPLAIN') }}</dt>
+++-			<dd><input type="radio" class="radio" name="top_five_show_admins_mods" value="1" {% if SHOW_ADMINS_MODS %}checked="checked"{% endif %}/> {{ lang('YES') }} &nbsp;
+++-				<input type="radio" class="radio" name="top_five_show_admins_mods" value="0" {% if not SHOW_ADMINS_MODS %}checked="checked"{% endif %} /> {{ lang('NO') }}</dd>
++++			<dt><label id="top_five_show_admins_mods" for="top_five_show_admins_mods">{L_TF_SHOW_ADMINS_MODS}</label><br />{L_TF_SHOW_ADMINS_MODS_EXPLAIN}</dt>
++++			<dd><input type="radio" class="radio" name="top_five_show_admins_mods" value="1" <!-- IF SHOW_ADMINS_MODS -->checked="checked"<!-- ENDIF -->/> {L_YES} &nbsp;
++++				<input type="radio" class="radio" name="top_five_show_admins_mods" value="0" <!-- IF not SHOW_ADMINS_MODS -->checked="checked"<!-- ENDIF --> /> {L_NO}</dd>
+++ 		</dl>
+++ 		<p class="submit-buttons">
+++-			<input class="button1" type="submit" id="submit" name="submit" value="{{ lang('SUBMIT') }}" />&nbsp;
+++-			<input class="button2" type="reset" id="reset" name="reset" value="{{ lang('RESET') }}" />
+++-		{{ S_FORM_TOKEN }}
++++			<input class="button1" type="submit" id="submit" name="submit" value="{L_SUBMIT}" />&nbsp;
++++			<input class="button2" type="reset" id="reset" name="reset" value="{L_RESET}" />
++++		{S_FORM_TOKEN}
+++ 		</p>
+++ 	</fieldset>
+++ </form>
+++-{% INCLUDE 'overall_footer.html' %}
++++<!-- INCLUDE overall_footer.html -->
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/adm/style/event/acp_ext_details_end.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/adm/style/event/acp_ext_details_end.html"
+++deleted file mode 100644
+++index 5a3267046..000000000
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/adm/style/event/acp_ext_details_end.html"
++++++ /dev/null
+++@@ -1,9 +0,0 @@
+++-{% if S_BUY_ME_A_BEER_TOPFIVE %}
+++-	<fieldset>
+++-		<legend>{{ lang('BUY_ME_A_BEER') }}</legend>
+++-		<dl>
+++-			<dt><label>{{ lang('BUY_ME_A_BEER_SHORT') }}{{ lang('COLON') }}</label><br /><span>{{ lang('BUY_ME_A_BEER_EXPLAIN') }}</span></dt>
+++-			<dd><a href="{{ lang('BUY_ME_A_BEER_URL') }}" target="_blank" rel="noreferrer noopener"><img src="{{ lang('PAYPAL_IMAGE_URL') }}" border="0" alt="{{ lang('PAYPAL_ALT') }}" style="cursor:pointer;margin-top:15px;"></a></dd>
+++-		</dl>
+++-	</fieldset>
+++-{% endif %}
+++\ No newline at end of file
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\topfive/composer.json"
+++index 531076584..ac1d70338 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/composer.json"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\topfive/composer.json"
+++@@ -1,38 +1,36 @@
+++ {
+++     "name": "rmcgirr83/topfive",
+++     "type": "phpbb-extension",
+++-    "description": "Displays statistics of the latest new posts, new users and most active users on the forum index page.",
++++    "description": "Displays statistics of the latest new posts, new users and most active users on the boards index page.",
+++     "homepage": "https://github.com/RMcGirr83/topfive",
+++-    "version": "1.2.8",
+++-    "time": "2024-10-26",
++++    "version": "1.0.2",
++++    "time": "2015-05-28",
+++     "keywords": [
+++         "phpbb",
+++         "extension",
+++         "top five"
+++     ],
+++-    "license": "GPL-2.0-only",
++++    "license": "GPL-2.0",
+++     "authors": [
+++         {
+++             "name": "Rich McGirr",
+++-            "homepage": "https://paypal.me/rmcgirr83",
++++            "homepage": "https://www.phpbb.com/customise/db/author/rmcgirr83/contributions",
++++            "email": "rmcgirr83@rmcgirr83.org",
+++             "role": "Lead Developer"
+++         }
+++     ],
+++     "require": {
+++-        "php": ">=7.4",
+++-        "phpbb/phpbb": ">=3.3",
+++-        "composer/installers": "~1.0.0"
++++        "php": ">=5.3.3"
+++     },
+++     "extra": {
+++-        "display-name": "Top Five Extension",
++++        "display-name": "Top Five",
+++         "soft-require": {
+++-            "phpbb/phpbb": ">=3.3"
++++            "phpbb/phpbb": ">=3.1.2,<3.2.*@dev"
+++         },
+++         "version-check": {
+++             "host": "www.phpbb.com",
+++             "directory": "/customise/db/extension/topfiveext",
+++-            "filename": "version_check",
+++-            "ssl": true
++++            "filename": "version_check"
+++         }
+++     }
+++ }
+++\ No newline at end of file
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/config/services.yml" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\topfive/config/services.yml"
+++index c499f0988..7654a7bd9 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/config/services.yml"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\topfive/config/services.yml"
+++@@ -1,20 +1,5 @@
+++-imports:
+++-    - { resource: topfive_constants.yml }
+++-
+++ services:
+++-    rmcgirr83.topfive.admin.controller:
+++-        class: rmcgirr83\topfive\controller\admin_controller
+++-        arguments:
+++-            - '@cache'
+++-            - '@config'
+++-            - '@language'
+++-            - '@request'
+++-            - '@template'
+++-            - '%core.root_path%'
+++-            - '%core.php_ext%'
+++-            - '%topfive_constants%'
+++-
+++-    rmcgirr83.topfive.topfive:
++++    rmcgirr83.topfive.functions:
+++         class: rmcgirr83\topfive\core\topfive
+++         arguments:
+++             - '@auth'
+++@@ -23,25 +8,17 @@ services:
+++             - '@content.visibility'
+++             - '@dbal.conn'
+++             - '@dispatcher'
+++-            - '@language'
+++             - '@template'
+++             - '@user'
+++             - '%core.root_path%'
+++             - '%core.php_ext%'
+++-            - '@?senky.relativedates.listener'
+++-            - '@?rmcgirr83.nationalflags.nationalflags'
+++ 
+++     rmcgirr83.topfive.listener:
+++         class: rmcgirr83\topfive\event\listener
+++         arguments:
+++-            - '@rmcgirr83.topfive.topfive'
++++            - '@rmcgirr83.topfive.functions'
+++             - '@config'
+++-            - '@language'
+++             - '@template'
+++             - '@user'
+++-            - '@controller.helper'
+++-            - '%core.php_ext%'
+++-            - '%topfive_constants%'
+++-            - '@?phpbb.collapsiblecategories.operator'
+++         tags:
+++             - { name: event.listener }
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/config/topfive_constants.yml" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/config/topfive_constants.yml"
+++deleted file mode 100644
+++index b60ea6065..000000000
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/config/topfive_constants.yml"
++++++ /dev/null
+++@@ -1,6 +0,0 @@
+++-parameters:
+++-    topfive_constants:
+++-        top_of_index: 0
+++-        bottom_of_index: 1
+++-        top_of_entire_forum: 2
+++-        bottom_of_entire_forum: 3
+++\ No newline at end of file
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/controller/admin_controller.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/controller/admin_controller.php"
+++deleted file mode 100644
+++index 40a3df971..000000000
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/controller/admin_controller.php"
++++++ /dev/null
+++@@ -1,190 +0,0 @@
+++-<?php
+++-/**
+++-*
+++-* Top Five extension for the phpBB Forum Software package.
+++-*
+++-* @copyright 2016 Rich McGirr (RMcGirr83)
+++-* @license GNU General Public License, version 2 (GPL-2.0)
+++-*
+++-*/
+++-
+++-namespace rmcgirr83\topfive\controller;
+++-
+++-use phpbb\cache\service as cache;
+++-use phpbb\config\config;
+++-use phpbb\language\language;
+++-use phpbb\request\request;
+++-use phpbb\template\template;
+++-
+++-class admin_controller
+++-{
+++-	/** @var cache */
+++-	protected $cache;
+++-
+++-	/** @var config */
+++-	protected $config;
+++-
+++-	/** @var language */
+++-	protected $language;
+++-
+++-	/** @var request */
+++-	protected $request;
+++-
+++-	/** @var template */
+++-	protected $template;
+++-
+++-	/** @var string phpBB root path */
+++-	protected $root_path;
+++-
+++-	/** @var string phpEx */
+++-	protected $php_ext;
+++-
+++-	/* @var array topfive_constants */
+++-	protected $topfive_constants;
+++-
+++-	/** @var string Custom form action */
+++-	protected $u_action;
+++-
+++-	/**
+++-	* Constructor
+++-	*
+++-	* @param cache						$cache				Cache object
+++-	* @param config						$config				Config object
+++-	* @param language					$language			Language object
+++-	* @param request					$request			Request object
+++-	* @param template					$template			Template object
+++-	* @param string						$root_path			phpBB root path
+++-	* @param string						$php_ext			phpEx
+++-	* @param array						$topfive_constants	Constants for the extension
+++-	* @access public
+++-	*/
+++-	public function __construct(
+++-			cache $cache,
+++-			config $config,
+++-			language $language,
+++-			request $request,
+++-			template $template,
+++-			string $root_path,
+++-			string $php_ext,
+++-			array $topfive_constants)
+++-	{
+++-		$this->cache = $cache;
+++-		$this->config = $config;
+++-		$this->language = $language;
+++-		$this->request = $request;
+++-		$this->template = $template;
+++-		$this->root_path = $root_path;
+++-		$this->php_ext = $php_ext;
+++-		$this->topfive_constants = $topfive_constants;
+++-	}
+++-
+++-	public function display_options()
+++-	{
+++-		$this->language->add_lang('acp_topfive', 'rmcgirr83/topfive');
+++-
+++-		// Create a form key for preventing CSRF attacks
+++-		add_form_key('acp_topfive');
+++-
+++-		// get the excluded forums
+++-		$excluded_forums = explode(',', $this->config['top_five_excluded']);
+++-
+++-		if ($this->request->is_set_post('submit'))
+++-		{
+++-			if (!check_form_key('acp_topfive'))
+++-			{
+++-				trigger_error('FORM_INVALID');
+++-			}
+++-			if (!function_exists('validate_data'))
+++-			{
+++-				include($this->root_path . 'includes/functions_user.' . $this->php_ext);
+++-			}
+++-
+++-			$check_row = array('top_five_how_many' => $this->request->variable('top_five_how_many', 0));
+++-			$validate_row = array('top_five_how_many' => array('num', false, 5, 100));
+++-			$error = validate_data($check_row, $validate_row);
+++-			// Replace "error" strings with their real, localised form
+++-			$error = array_map(array($this->language, 'lang'), $error);
+++-
+++-			if (!sizeof($error))
+++-			{
+++-				$this->set_options();
+++-
+++-				$this->cache->destroy('_top_five_newest_users');
+++-				$this->cache->destroy('_top_five_posters');
+++-
+++-				trigger_error($this->language->lang('TF_SAVED') . adm_back_link($this->u_action));
+++-			}
+++-		}
+++-
+++-		$this->template->assign_vars(array(
+++-			'TF_ERROR'			=> isset($error) ? ((sizeof($error)) ? implode('<br />', $error) : '') : '',
+++-			'HOWMANY'			=> isset($this->config['top_five_how_many']) ? $this->config['top_five_how_many'] : 0,
+++-			'IGNORE_INACTIVE'	=> isset($this->config['top_five_ignore_inactive_users']) ? $this->config['top_five_ignore_inactive_users'] : false,
+++-			'IGNORE_FOUNDER'	=> isset($this->config['top_five_ignore_founder']) ? $this->config['top_five_ignore_founder'] : false,
+++-			'SHOW_ADMINS_MODS'	=> isset($this->config['top_five_show_admins_mods']) ? $this->config['top_five_show_admins_mods'] : false,
+++-			'LOCATION'			=> $this->location($this->config['top_five_location']),
+++-			'ACTIVE'			=> isset($this->config['top_five_active']) ? $this->config['top_five_active'] : false,
+++-			'TF_EXCLUDED'		=> $this->forum_select($excluded_forums),
+++-			'AVATARS'		=> isset($this->config['top_five_avatars']) ? $this->config['top_five_avatars'] : false,
+++-
+++-			'U_ACTION'			=> $this->u_action,
+++-		));
+++-	}
+++-
+++-	protected function set_options()
+++-	{
+++-		$this->config->set('top_five_how_many', $this->request->variable('top_five_how_many', 0));
+++-		$this->config->set('top_five_ignore_inactive_users', $this->request->variable('top_five_ignore_inactive_users', 0));
+++-		$this->config->set('top_five_ignore_founder', $this->request->variable('top_five_ignore_founder', 0));
+++-		$this->config->set('top_five_show_admins_mods', $this->request->variable('top_five_show_admins_mods', 0));
+++-		$this->config->set('top_five_location', $this->request->variable('top_five_location', 0));
+++-		$this->config->set('top_five_active', $this->request->variable('top_five_active', 0));
+++-
+++-		// variable should be '' as it is a string ("1, 2, 3928") here, not an integer.
+++-		$forums = $this->request->variable('selectForms',  array(''));
+++-		// change the array to a string
+++-		$forums  = implode(',', $forums);
+++-		$this->config->set('top_five_excluded', $forums);
+++-		$this->config->set('top_five_avatars', $this->request->variable('top_five_avatars',0));
+++-	}
+++-
+++-	/**
+++-	 * Display a drop down of all forums for selection
+++-	 *
+++-	 * @return drop down select
+++-	 * @access protected
+++-	 */
+++-	private function forum_select($value)
+++-	{
+++-		return '<select id="top_five_excluded" name="selectForms[]" multiple="multiple">' . make_forum_select($value, false, true, true) . '</select>';
+++-	}
+++-
+++-	/**
+++-	 * Create the selection for the post method
+++-	 */
+++-	public function location($location = 0)
+++-	{
+++-		// location options
+++-		$location_text = [$this->topfive_constants['top_of_index'] => $this->language->lang('TOP_OF_FORUM'), $this->topfive_constants['bottom_of_index'] => $this->language->lang('BOTTOM_OF_FORUM'), $this->topfive_constants['top_of_entire_forum'] => $this->language->lang('TOP_OF_ENTIRE_FORUM'), $this->topfive_constants['bottom_of_entire_forum'] => $this->language->lang('BOTTOM_OF_ENTIRE_FORUM')];
+++-		$location_options = '';
+++-		foreach ($location_text as $value => $text)
+++-		{
+++-			$selected = ($value == $location) ? ' selected="selected"' : '';
+++-			$location_options .= "<option value='{$value}'$selected>$text</option>";
+++-		}
+++-
+++-		return $location_options;
+++-	}
+++-
+++-	/**
+++-	 * Set page url
+++-	 *
+++-	 * @param string $u_action Custom form action
+++-	 * @return null
+++-	 * @access public
+++-	 */
+++-	public function set_page_url($u_action)
+++-	{
+++-		$this->u_action = $u_action;
+++-	}
+++-}
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/core/topfive.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\topfive/core/topfive.php"
+++index 4facdbedc..3d9f9352e 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/core/topfive.php"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\topfive/core/topfive.php"
+++@@ -11,65 +11,39 @@
+++ 
+++ namespace rmcgirr83\topfive\core;
+++ 
+++-use phpbb\auth\auth;
+++-use phpbb\config\config;
+++-use phpbb\cache\service as cache_service;
+++-use phpbb\content_visibility;
+++-use phpbb\db\driver\driver_interface;
+++-use phpbb\event\dispatcher_interface;
+++-use phpbb\language\language;
+++-use phpbb\template\template;
+++-use phpbb\user;
+++-
+++ class topfive
+++ {
+++-	/** @var auth */
++++	/** @var \phpbb\auth\auth */
+++ 	protected $auth;
+++ 
+++-	/** @var config */
++++	/** @var \phpbb\config\config */
+++ 	protected $config;
+++ 
+++-	/** @var cache */
++++	/** @var \phpbb\cache\driver\driver_interface */
+++ 	protected $cache;
+++ 
+++-	/** @var content_visibility */
++++	/** @var \phpbb\content_visibility */
+++ 	protected $content_visibility;
+++ 
+++-	/** @var db */
++++	/** @var \phpbb\db\driver\driver_interface */
+++ 	protected $db;
+++ 
+++-	/** @var dispatcher */
++++	/** @var \phpbb\event\dispatcher_interface */
+++ 	protected $dispatcher;
+++ 
+++-	/** @var language */
+++-	protected $language;
+++-
+++-	/** @var template */
++++	/** @var \phpbb\template\template */
+++ 	protected $template;
+++ 
+++-	/** @var user */
++++	/** @var \phpbb\user */
+++ 	protected $user;
+++ 
+++-	/** @var string phpbb_root_path */
++++	/** @var string phpBB root path */
+++ 	protected $phpbb_root_path;
+++ 
+++-	/** @var string php_ext */
++++	/** @var string PHP extension */
+++ 	protected $php_ext;
+++ 
+++-	public function __construct(
+++-		auth $auth,
+++-		config $config,
+++-		cache_service $cache,
+++-		content_visibility $content_visibility,
+++-		driver_interface $db,
+++-		dispatcher_interface $dispatcher,
+++-		language $language,
+++-		template $template,
+++-		user $user,
+++-		string $phpbb_root_path,
+++-		string $php_ext,
+++-		\senky\relativedates\event\listener $relativedates = null,
+++-		\rmcgirr83\nationalflags\core\nationalflags $nationalflags= null)
++++	public function __construct(\phpbb\auth\auth $auth, \phpbb\config\config $config, \phpbb\cache\service $cache, \phpbb\content_visibility $content_visibility, \phpbb\db\driver\driver_interface $db, \phpbb\event\dispatcher_interface $dispatcher, \phpbb\template\template $template, \phpbb\user $user, $phpbb_root_path, $php_ext)
+++ 	{
+++ 		$this->auth = $auth;
+++ 		$this->config = $config;
+++@@ -77,27 +51,18 @@ class topfive
+++ 		$this->content_visibility = $content_visibility;
+++ 		$this->db = $db;
+++ 		$this->dispatcher = $dispatcher;
+++-		$this->language = $language;
+++ 		$this->template = $template;
+++ 		$this->user = $user;
+++ 		$this->root_path = $phpbb_root_path;
+++ 		$this->php_ext = $php_ext;
+++-		$this->relativedates = $relativedates;
+++-		$this->nationalflags = $nationalflags;
+++ 	}
+++ 
+++-	/**
+++-	* Display activity
+++-	*
+++-	* @param	string	$tpl_loopname	Name of the html file
+++-	* @return 	null
+++-	* @access 	public
+++-	*/
+++ 	public function toptopics($tpl_loopname = 'top_five_topic')
+++ 	{
++++
+++ 		$howmany = $this->howmany();
+++ 
+++-		$forum_ary = [];
++++		$forum_ary = array();
+++ 		$forum_read_ary = $this->auth->acl_getf('f_read');
+++ 
+++ 		foreach ($forum_read_ary as $forum_id => $allowed)
+++@@ -109,220 +74,184 @@ class topfive
+++ 		}
+++ 		$forum_ary = array_unique($forum_ary);
+++ 
+++-		// want to exclude some forums
+++-		$excluded_forums = explode(',', $this->config['top_five_excluded']);
+++-
+++-		// now remove those topics from the display per the excluded forums array
+++-		$forum_ary = array_diff($forum_ary, $excluded_forums);
+++-
+++-		if (!sizeof($forum_ary))
++++		if (sizeof($forum_ary))
+++ 		{
+++-			$this->template->assign_block_vars($tpl_loopname, [
+++-				'NO_TOPIC_TITLE'	=> $this->language->lang('NO_TOPIC_EXIST'),
+++-			]);
+++-
+++-			return false;
+++-		}
+++-
+++-		/**
+++-		* Select topic_ids
+++-		*/
+++-		// grab all posts that meet criteria and auths
+++-		$sql_array = [
+++-			'SELECT'	=> 't.forum_id, t.topic_id, t.topic_type',
+++-			'FROM'		=> [TOPICS_TABLE => 't'],
+++-			'WHERE'		=> $this->content_visibility->get_forums_visibility_sql('topic', $forum_ary) . ' AND topic_status <> ' . ITEM_MOVED,
+++-			'ORDER_BY'	=> 't.topic_last_post_time DESC',
+++-		];
+++-
+++-		$result = $this->db->sql_query_limit($this->db->sql_build_query('SELECT', $sql_array), $howmany);
+++-
+++-		$forums = $ga_topic_ids = $topic_ids = [];
+++-		while ($row = $this->db->sql_fetchrow($result))
+++-		{
+++-			$topic_ids[] = $row['topic_id'];
+++-			if ($row['topic_type'] == POST_GLOBAL)
++++			/**
++++			* Select topic_ids
++++			*/
++++			$sql = 'SELECT forum_id, topic_id, topic_type
++++				FROM ' . TOPICS_TABLE . '
++++				WHERE ' . $this->content_visibility->get_forums_visibility_sql('topic', $forum_ary) . '
++++				AND topic_status <> ' . ITEM_MOVED . '
++++				ORDER BY topic_last_post_time DESC';
++++
++++			$result = $this->db->sql_query_limit($sql, $howmany);
++++			$forums = $ga_topic_ids = $topic_ids = array();
++++			while ($row = $this->db->sql_fetchrow($result))
+++ 			{
+++-				$ga_topic_ids[] = $row['topic_id'];
++++				$topic_ids[] = $row['topic_id'];
++++				if ($row['topic_type'] == POST_GLOBAL)
++++				{
++++					$ga_topic_ids[] = $row['topic_id'];
++++				}
++++				else
++++				{
++++					$forums[$row['forum_id']][] = $row['topic_id'];
++++				}
+++ 			}
+++-			else
++++			$this->db->sql_freeresult($result);
++++
++++			// Get topic tracking
++++			$topic_tracking_info = array();
++++			foreach ($forums as $forum_id => $topic_id)
+++ 			{
+++-				$forums[$row['forum_id']][] = $row['topic_id'];
++++				$topic_tracking_info[$forum_id] = get_complete_topic_tracking($forum_id, $topic_id, $ga_topic_ids);
+++ 			}
+++-		}
+++-		$this->db->sql_freeresult($result);
+++ 
+++-		// Get topic tracking
+++-		$topic_tracking_info = [];
+++-		foreach ($forums as $forum_id => $topic_id)
+++-		{
+++-			$topic_tracking_info[$forum_id] = get_complete_topic_tracking($forum_id, $topic_id, $ga_topic_ids);
+++-		}
+++-
+++-		/*
+++-		* must have topic_ids.
+++-		* A user can have forums and not have topic_ids before installing this extension
+++-		*/
+++-		if (!sizeof($topic_ids))
+++-		{
+++-			$this->template->assign_block_vars($tpl_loopname, [
+++-				'NO_TOPIC_TITLE'	=> $this->language->lang('NO_TOPIC_EXIST'),
+++-			]);
+++-
+++-			return false;
+++-		}
+++-
+++-		// grab all posts that meet criteria and auths
+++-		$sql_array = [
+++-			'SELECT'	=> 'u.user_id, u.username, u.user_colour, u.user_avatar, u.user_avatar_type, u.user_avatar_height, u.user_avatar_width, t.topic_title, t.forum_id, t.topic_id, t.topic_first_post_id, t.topic_last_post_id, t.topic_last_post_time, t.topic_last_poster_name, f.forum_name',
+++-			'FROM'		=> [TOPICS_TABLE => 't'],
+++-			'LEFT_JOIN'	=> [
+++-				[
+++-					'FROM'	=> [USERS_TABLE => 'u'],
+++-					'ON'	=> 't.topic_last_poster_id = u.user_id',
+++-				],
+++-				[
+++-					'FROM'	=> [FORUMS_TABLE => 'f'],
+++-					'ON'	=> 't.forum_id = f.forum_id',
+++-				],
+++-			],
+++-			'WHERE'		=> $this->db->sql_in_set('t.topic_id', $topic_ids),
+++-			'ORDER_BY'	=> 't.topic_last_post_time DESC',
+++-		];
+++-		if ($this->nationalflags !== null)
+++-		{
+++-			$sql_array['SELECT'].= ', u.user_flag';
+++-		}
+++-
+++-		/**
+++-		* Event to modify the SQL query before the topics data is retrieved
+++-		*
+++-		* @event rmcgirr83.topfive.sql_pull_topics_data
+++-		* @var	array	sql_array		The SQL array
+++-		* @since 1.0.0
+++-		*/
+++-		$vars = ['sql_array'];
+++-		extract($this->dispatcher->trigger_event('rmcgirr83.topfive.sql_pull_topics_data', compact($vars)));
+++-
+++-		$result = $this->db->sql_query_limit($this->db->sql_build_query('SELECT', $sql_array), $howmany);
+++-
+++-		while ($row = $this->db->sql_fetchrow($result))
+++-		{
+++-			$topic_id = $row['topic_id'];
+++-			$forum_id = $row['forum_id'];
+++-			$forum_name = $row['forum_name'];
+++-
+++-			$post_unread = (isset($topic_tracking_info[$forum_id][$topic_id]) && $row['topic_last_post_time'] > $topic_tracking_info[$forum_id][$topic_id]) ? true : false;
+++-			$view_topic_url = !empty($post_unread) ? append_sid("{$this->root_path}viewtopic.$this->php_ext", 't=' . $topic_id . '&amp;view=unread') . '#unread' : append_sid("{$this->root_path}viewtopic.$this->php_ext", 't=' . $topic_id);
+++-			/** To go to the last post in a topic use the below as the last argument in the above $view_topic_url variable
+++-			append_sid("{$this->root_path}viewtopic.$this->php_ext", 'f=' . $row['forum_id'] . '&amp;p=' . $row['topic_last_post_id'] . '#p' . $row['topic_last_post_id'])
+++-			**/
+++-			$forum_name_url = append_sid("{$this->root_path}viewforum.$this->php_ext", 'f=' . $row['forum_id']);
+++-			$topic_title = censor_text($row['topic_title']);
+++-			$topic_title = truncate_string($topic_title, 60, 255, false, $this->language->lang('ELLIPSIS'));
+++-
+++-			$is_guest = ($row['user_id'] == ANONYMOUS) ? true : false;
+++-
+++-			$user_avatar = phpbb_get_user_avatar($row);
+++-			$display_avatar = (!empty($this->config['top_five_avatars']) && $this->user->optionget('viewavatars') && !empty($user_avatar)) ? true : false;
+++-
+++-			$user_avatar = $display_avatar ? '<span class="topfive-avatar">' . $user_avatar . '</span>&nbsp;' : '';
+++-
+++-			// relativedates installed?
+++-			if ($this->relativedates !== null)
++++			/*
++++			* must have topic_ids.
++++			* A user can have forums and not have topic_ids before installing this extension
++++			*/
++++			if (sizeof($topic_ids))
+++ 			{
+++-				$last_topic_time = $this->user->format_date($row['topic_last_post_time'], false, false, false);
++++				// grab all posts that meet criteria and auths
++++				$sql_array = array(
++++					'SELECT'	=> 'u.user_id, u.username, u.user_colour, u.user_avatar, u.user_avatar_type, u.user_avatar_width, u.user_avatar_height, t.topic_title, t.forum_id, t.topic_id, t.topic_first_post_id, t.topic_last_post_id, t.topic_last_post_time, t.topic_last_poster_name, f.forum_name',
++++					'FROM'		=> array(TOPICS_TABLE => 't'),
++++					'LEFT_JOIN'	=> array(
++++						array(
++++							'FROM'	=> array(USERS_TABLE => 'u'),
++++							'ON'	=> 't.topic_last_poster_id = u.user_id',
++++						),
++++						array(
++++							'FROM'	=> array(FORUMS_TABLE => 'f'),
++++							'ON'	=> 't.forum_id = f.forum_id',
++++						),
++++					),
++++					'WHERE'		=> $this->db->sql_in_set('t.topic_id', $topic_ids),
++++					'ORDER_BY'	=> 't.topic_last_post_time DESC',
++++				);
++++				/**
++++				* Event to modify the SQL query before the topics data is retrieved
++++				*
++++				* @event rmcgirr83.topfive.sql_pull_topics_data
++++				* @var	array	sql_array		The SQL array
++++				* @since 1.0.0
++++				*/
++++				$vars = array('sql_array');
++++				extract($this->dispatcher->trigger_event('rmcgirr83.topfive.sql_pull_topics_data', compact($vars)));
++++
++++				// cache the query for one minute
++++				$result = $this->db->sql_query_limit($this->db->sql_build_query('SELECT', $sql_array), $howmany, 0, 60);
++++
++++				while ($row = $this->db->sql_fetchrow($result))
++++				{
++++					$topic_id = $row['topic_id'];
++++					$forum_id = $row['forum_id'];
++++					$forum_name = $row['forum_name'];
++++
++++					$post_unread = (isset($topic_tracking_info[$forum_id][$topic_id]) && $row['topic_last_post_time'] > $topic_tracking_info[$forum_id][$topic_id]) ? true : false;
++++					$view_topic_url = append_sid("{$this->phpbb_root_path}viewtopic.$this->php_ext", 'f=' . $row['forum_id'] . '&amp;p=' . $row['topic_last_post_id'] . '#p' . $row['topic_last_post_id']);
++++					$forum_name_url = append_sid("{$this->phpbb_root_path}viewforum.$this->php_ext", 'f=' . $row['forum_id']);
++++					$topic_title = censor_text($row['topic_title']);
++++					if (utf8_strlen($topic_title) >= 60)
++++					{
++++						$topic_title = (utf8_strlen($topic_title) > 60 + 3) ? utf8_substr($topic_title, 0, 60) . '...' : $topic_title;
++++					}
++++					$is_guest = ($row['user_id'] == ANONYMOUS) ? true : false;
++++                    $user_avatar = ($row['user_avatar']) ? get_user_avatar($row['user_avatar'], $row['user_avatar_type'], 50, 50) : '<img src="' . generate_board_url() . '/styles/' . '/FLATBOOTS/' . '/theme/images/no_avatar.gif" height="50" width="50" alt="Default Avatar" />';
++++					
++++					$tpl_ary = array(
++++						'U_TOPIC'			=> $view_topic_url,
++++						'U_FORUM'			=> $forum_name_url,
++++						'TOP5_AVATAR' 	    => $user_avatar,
++++						'S_UNREAD'			=> ($post_unread) ? true : false,
++++						'USERNAME_FULL'		=> ($is_guest || !$this->auth->acl_get('u_viewprofile')) ? $this->user->lang['POST_BY_AUTHOR'] . ' ' . get_username_string('no_profile', $row['user_id'], $row['username'], $row['user_colour'], $row['topic_last_poster_name']) : $this->user->lang['POST_BY_AUTHOR'] . ' ' . get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']),
++++						'LAST_TOPIC_TIME'	=> $this->user->format_date($row['topic_last_post_time']),
++++						'TOPIC_TITLE' 		=> $topic_title,
++++						'FORUM_NAME'		=> $forum_name,
++++					);
++++					/**
++++					* Modify the topic data before it is assigned to the template
++++					*
++++					* @event rmcgirr83.topfive.modify_tpl_ary
++++					* @var	array	row			Array with topic data
++++					* @var	array	tpl_ary		Template block array with topic data
++++					* @since 1.0.0
++++					*/
++++					$vars = array('row', 'tpl_ary');
++++					extract($this->dispatcher->trigger_event('rmcgirr83.topfive.modify_tpl_ary', compact($vars)));
++++
++++					$this->template->assign_block_vars($tpl_loopname, $tpl_ary);
++++				}
++++				$this->db->sql_freeresult($result);
+++ 			}
+++ 			else
+++ 			{
+++-				$last_topic_time = $this->user->format_date($row['topic_last_post_time']);
++++				$this->template->assign_block_vars($tpl_loopname, array(
++++					'NO_TOPIC_TITLE'	=> $this->user->lang['NO_TOPIC_EXIST'],
++++				));
+++ 			}
+++-
+++-			$user_flag = '';
+++-			// nationalflags installed?
+++-			if (!empty($row['user_flag']))
+++-			{
+++-				$user_flag = $this->nationalflags->get_user_flag($row['user_flag'], 12);
+++-			}
+++-
+++-			$tpl_ary = [
+++-				'U_TOPIC'	=> $view_topic_url,
+++-				'U_FORUM'	=> $forum_name_url,
+++-				'S_UNREAD'	=> ($post_unread) ? true : false,
+++-				'USERNAME_FULL'	=> ($is_guest || !$this->auth->acl_get('u_viewprofile')) ? $this->language->lang('BY') . $user_avatar . get_username_string('no_profile', $row['user_id'], $row['username'], $row['user_colour'], $row['topic_last_poster_name']) : $this->language->lang('BY') . $user_avatar . get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']),
+++-				'LAST_TOPIC_TIME'	=> $last_topic_time,
+++-				'TOPIC_TITLE'	=> $topic_title,
+++-				'FORUM_NAME'	=> $forum_name,
+++-				'USER_FLAG'	=> !empty($user_flag) ? $user_flag : '',
+++-			];
+++-
+++-			/**
+++-			* Modify the topic data before it is assigned to the template
+++-			*
+++-			* @event rmcgirr83.topfive.modify_tpl_ary
+++-			* @var	array	row			Array with topic data
+++-			* @var	array	tpl_ary		Template block array with topic data
+++-			* @since 1.0.0
+++-			*/
+++-			$vars = ['row', 'tpl_ary'];
+++-			extract($this->dispatcher->trigger_event('rmcgirr83.topfive.modify_tpl_ary', compact($vars)));
+++-
+++-			$this->template->assign_block_vars($tpl_loopname, $tpl_ary);
+++ 		}
+++-		$this->db->sql_freeresult($result);
++++		else
++++		{
++++			$this->template->assign_block_vars($tpl_loopname, array(
++++				'NO_TOPIC_TITLE'	=> $this->user->lang['NO_TOPIC_EXIST'],
++++			));
++++		}
+++ 	}
+++ 
+++-	/**
+++-	* Get the top posters
+++-	*
+++-	* @return 	null
+++-	* @access 	public
+++-	*/
+++ 	public function topposters()
+++ 	{
+++ 		$howmany = $this->howmany();
+++ 		$sql_where = $this->ignore_users();
+++ 
++++		//set two variables for the sql
++++		$sql_and = $sql_other = '';
++++
+++ 		if (($user_posts = $this->cache->get('_top_five_posters')) === false)
+++ 		{
+++-			$user_posts = [];
+++ 
+++-			$sql_where .= empty($sql_where) ? 'u.user_posts <> 0' : ' AND u.user_posts <> 0';
++++			$user_posts = $admin_mod_array = array();
++++			// quick check for forum moderators and administrators
++++			// some may not want to show them
++++			$show_admins_mods = $this->config['top_five_show_admins_mods'];
+++ 
+++-			// do the main sql query
+++-			$sql_array = [
+++-				'SELECT' => 'u.user_id, u.username, u.user_colour, u.user_posts, u.user_avatar, u.user_avatar_width, u.user_avatar_height, u.user_avatar_type, u.user_lastpost_time',
+++-				'FROM' => [USERS_TABLE => 'u'],
+++-				'WHERE' => $sql_where,
+++-				'ORDER_BY' => 'u.user_lastpost_time DESC, u.user_posts DESC',
+++-			];
+++-
+++-			if ($this->nationalflags !== null)
++++			if (!$show_admins_mods)
+++ 			{
+++-				$sql_array['SELECT'] .= ', u.user_flag';
++++				// grab all admins
++++				$admin_ary = $this->auth->acl_get_list(false, 'a_', false);
++++				$admin_ary = (!empty($admin_ary[0]['a_'])) ? $admin_ary[0]['a_'] : array();
++++
++++				//grab all mods
++++				$mod_ary = $this->auth->acl_get_list(false,'m_', false);
++++				$mod_ary = (!empty($mod_ary[0]['m_'])) ? $mod_ary[0]['m_'] : array();
++++				$admin_mod_array = array_unique(array_merge($admin_ary, $mod_ary));
++++				if (sizeof($admin_mod_array))
++++				{
++++					$sql_and = empty($sql_where) ? ' WHERE' : ' AND';
++++					$sql_and .= ' ' . $this->db->sql_in_set('user_id', $admin_mod_array, true);
++++				}
+++ 			}
+++-			$result = $this->db->sql_query_limit($this->db->sql_build_query('SELECT', $sql_array), $howmany);
++++			$sql_other = (empty($sql_and) && empty($sql_where)) ? ' WHERE' : ' AND';
++++			$sql_other .=  ' user_posts <> 0';
+++ 
++++			// do the main sql query
++++			$sql = 'SELECT user_id, username, user_colour, user_posts
++++				FROM ' . USERS_TABLE . '
++++				 ' . $sql_where . ' ' . $sql_and . '
++++				' . $sql_other . '
++++				ORDER BY user_posts DESC';
++++
++++			$result = $this->db->sql_query_limit($sql, $howmany);
+++ 			while ($row = $this->db->sql_fetchrow($result))
+++ 			{
+++-				$user_flag = '';
+++-				// nationalflags installed?
+++-				if (!empty($row['user_flag']))
+++-				{
+++-					$user_flag = $this->nationalflags->get_user_flag($row['user_flag'], 12);
+++-				}
+++-				$user_posts[$row['user_id']] = [
++++				$user_posts[$row['user_id']] = array(
+++ 					'user_id'      => $row['user_id'],
+++ 					'username'      => $row['username'],
+++ 					'user_colour'   => $row['user_colour'],
+++ 					'user_posts'    => $row['user_posts'],
+++-					'user_avatar'	=> $row['user_avatar'],
+++-					'user_avatar_width'	=> $row['user_avatar_width'],
+++-					'user_avatar_height'	=> $row['user_avatar_height'],
+++-					'user_avatar_type'	=> $row['user_avatar_type'],
+++-					'user_lastpost_time'	=> $row['user_lastpost_time'],
+++-					'user_flag'	=> !empty($user_flag) ? $user_flag : '',
+++-				];
++++				);
+++ 			}
+++ 			$this->db->sql_freeresult($result);
+++ 
+++@@ -332,81 +261,44 @@ class topfive
+++ 
+++ 		foreach ($user_posts as $row)
+++ 		{
+++-			$user_avatar = phpbb_get_user_avatar($row);
+++-			$display_avatar = (!empty($this->config['top_five_avatars']) && $this->user->optionget('viewavatars') && !empty($user_avatar)) ? true : false;
+++-
+++-			$user_avatar = $display_avatar ? '<span class="topfive-avatar">' . $user_avatar . '</span>&nbsp;' : '';
++++			$username_string = ($this->auth->acl_get('u_viewprofile')) ? get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']) : get_username_string('no_profile', $row['user_id'], $row['username'], $row['user_colour']);
+++ 
+++-			$username_string = ($this->auth->acl_get('u_viewprofile')) ? $user_avatar . get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']) : $user_avatar . get_username_string('no_profile', $row['user_id'], $row['username'], $row['user_colour']);
+++-			if ($this->relativedates !== null)
+++-			{
+++-				$user_lastpost_time = $this->user->format_date($row['user_lastpost_time'], false, false, false);
+++-			}
+++-			else
+++-			{
+++-				$user_lastpost_time = $this->user->format_date($row['user_lastpost_time']);
+++-			}
+++-
+++-			$this->template->assign_block_vars('top_five_active',[
+++-				'S_SEARCH_ACTION'	=> append_sid("{$this->root_path}search.$this->php_ext", 'author_id=' . $row['user_id'] . '&amp;sr=posts'),
+++-				'POSTS'	=> number_format($row['user_posts']),
+++-				'USERNAME_FULL'	=> $username_string,
+++-				'USER_LASTPOST_TIME'	=> $this->language->lang('USER_LASTPOST_TIME', $user_lastpost_time),
+++-				'USER_FLAG'	=> !empty($row['user_flag']) ? $row['user_flag'] : '',
+++-			]);
++++			$this->template->assign_block_vars('top_five_active',array(
++++				'S_SEARCH_ACTION'	=> append_sid("{$this->phpbb_root_path}search.$this->php_ext", 'author_id=' . $row['user_id'] . '&amp;sr=posts'),
++++				'POSTS' 			=> number_format($row['user_posts']),
++++				'USERNAME_FULL'		=> $username_string,
++++			));
+++ 		}
+++ 	}
+++ 
+++-	/**
+++-	* Get the newest members
+++-	*
+++-	* @return 	null
+++-	* @access 	public
+++-	*/
+++ 	public function newusers()
+++ 	{
++++
+++ 		$howmany = $this->howmany();
+++ 		$sql_where = $this->ignore_users();
+++ 
+++-		$sql_where .= !empty($sql_where) ? ' AND u.user_inactive_reason = 0' : ' u.user_inactive_reason = 0';
++++		$sql_and = !empty($sql_where) ? ' AND user_inactive_reason = 0' : ' WHERE user_inactive_reason = 0';
+++ 		// newest registered users
+++ 		if (($newest_users = $this->cache->get('_top_five_newest_users')) === false)
+++ 		{
+++-			$newest_users = [];
++++			$newest_users = array();
+++ 
+++ 			// grab most recent registered users
+++-			$sql_array = [
+++-				'SELECT' => 'u.user_id, u.username, u.user_colour, u.user_regdate, u.user_avatar, u.user_avatar_width, u.user_avatar_height, u.user_avatar_type',
+++-				'FROM' => [USERS_TABLE => 'u'],
+++-				'WHERE' => $sql_where,
+++-				'ORDER_BY' =>  'u.user_regdate DESC',
+++-			];
+++-			if ($this->nationalflags !== null)
+++-			{
+++-				$sql_array['SELECT'] .= ', u.user_flag';
+++-			}
+++-			$result = $this->db->sql_query_limit($this->db->sql_build_query('SELECT', $sql_array), $howmany);
++++			$sql = 'SELECT user_id, username, user_colour, user_regdate
++++				FROM ' . USERS_TABLE . '
++++				' . $sql_where . '
++++				' . $sql_and . '
++++				ORDER BY user_regdate DESC';
++++			$result = $this->db->sql_query_limit($sql, $howmany);
+++ 
+++ 			while ($row = $this->db->sql_fetchrow($result))
+++ 			{
+++-				$user_flag = '';
+++-				// nationalflags installed?
+++-				if (!empty($row['user_flag']))
+++-				{
+++-					$user_flag = $this->nationalflags->get_user_flag($row['user_flag'], 12);
+++-				}
+++-
+++-				$newest_users[$row['user_id']] = [
++++				$newest_users[$row['user_id']] = array(
+++ 					'user_id'				=> $row['user_id'],
+++ 					'username'				=> $row['username'],
+++ 					'user_colour'			=> $row['user_colour'],
+++ 					'user_regdate'			=> $row['user_regdate'],
+++-					'user_avatar'			=> $row['user_avatar'],
+++-					'user_avatar_width'		=> $row['user_avatar_width'],
+++-					'user_avatar_height'	=> $row['user_avatar_height'],
+++-					'user_avatar_type'		=> $row['user_avatar_type'],
+++-					'user_flag'				=> !empty($user_flag) ? $user_flag : '',
+++-				];
++++				);
+++ 			}
+++ 			$this->db->sql_freeresult($result);
+++ 
+++@@ -416,27 +308,15 @@ class topfive
+++ 
+++ 		foreach ($newest_users as $row)
+++ 		{
+++-			$user_avatar = phpbb_get_user_avatar($row);
+++-			$display_avatar = (!empty($this->config['top_five_avatars']) && $this->user->optionget('viewavatars') && !empty($user_avatar)) ? true : false;
+++-
+++-			$user_avatar = $display_avatar ? '<span class="topfive-avatar">' . $user_avatar . '</span>&nbsp;' : '';
+++-
+++-			$username_string = ($this->auth->acl_get('u_viewprofile')) ? $user_avatar . get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']) : $user_avatar . get_username_string('no_profile', $row['user_id'], $row['username'], $row['user_colour']);
++++			$username_string = ($this->auth->acl_get('u_viewprofile')) ? get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']) : get_username_string('no_profile', $row['user_id'], $row['username'], $row['user_colour']);
+++ 
+++-			$this->template->assign_block_vars('top_five_newest',[
++++			$this->template->assign_block_vars('top_five_newest',array(
+++ 				'REG_DATE'			=> $this->user->format_date($row['user_regdate']),
+++ 				'USERNAME_FULL'		=> $username_string,
+++-				'USER_FLAG'			=> !empty($row['user_flag']) ? $row['user_flag'] : '',
+++-			]);
++++			));
+++ 		}
+++ 	}
+++ 
+++-	/**
+++-	* How many to display
+++-	*
+++-	* @return 	int 	$howmany
+++-	* @access 	private
+++-	*/
+++ 	private function howmany()
+++ 	{
+++ 		$howmany = $this->config['top_five_how_many'];
+++@@ -444,24 +324,18 @@ class topfive
+++ 		return (int) $howmany;
+++ 	}
+++ 
+++-	/**
+++-	* Ignore users
+++-	*
+++-	* @return 	string 	$sql_where
+++-	* @access 	private
+++-	*/
+++ 	private function ignore_users()
+++ 	{
+++ 		// an array of user types we dont' bother with
+++-		$ignore_users = $ignore_founders = [];
++++		$ignore_users = $ignore_founders = array();
+++ 		if ($this->config['top_five_ignore_inactive_users'])
+++ 		{
+++-			$ignore_users = [USER_IGNORE, USER_INACTIVE];
++++			$ignore_users = array(USER_IGNORE, USER_INACTIVE);
+++ 		}
+++ 
+++ 		if ($this->config['top_five_ignore_founder'])
+++ 		{
+++-			$ignore_founders = [USER_FOUNDER];
++++			$ignore_founders = array(USER_FOUNDER);
+++ 		}
+++ 
+++ 		$ignore_users = array_merge($ignore_users, $ignore_founders);
+++@@ -470,28 +344,9 @@ class topfive
+++ 		$sql_where = '';
+++ 		if (sizeof($ignore_users))
+++ 		{
+++-			$sql_where = $this->db->sql_in_set('u.user_type', $ignore_users, true);
++++			$sql_where = 'WHERE ' . $this->db->sql_in_set('user_type', $ignore_users, true);
+++ 		}
+++-		$admin_mod_array = [];
+++-		// quick check for forum moderators and administrators
+++-		// some may not want to show them
+++-		$show_admins_mods = $this->config['top_five_show_admins_mods'];
+++ 
+++-		if (!$show_admins_mods)
+++-		{
+++-			// grab all admins
+++-			$admin_ary = $this->auth->acl_get_list(false, 'a_', false);
+++-			$admin_ary = (!empty($admin_ary[0]['a_'])) ? $admin_ary[0]['a_'] : [];
+++-
+++-			//grab all mods
+++-			$mod_ary = $this->auth->acl_get_list(false,'m_', false);
+++-			$mod_ary = (!empty($mod_ary[0]['m_'])) ? $mod_ary[0]['m_'] : [];
+++-			$admin_mod_array = array_unique(array_merge($admin_ary, $mod_ary));
+++-			if (sizeof
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/event/listener.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\topfive/event/listener.php"
++index c809efb63..5821f4bd5 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/event/listener.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\topfive/event/listener.php"
++@@ -12,13 +12,6 @@ namespace rmcgirr83\topfive\event;
++ /**
++ * @ignore
++ */
++-use rmcgirr83\topfive\core\topfive;
++-use phpbb\config\config;
++-use phpbb\language\language;
++-use phpbb\template\template;
++-use phpbb\user;
++-use phpbb\controller\helper;
++-
++ use Symfony\Component\EventDispatcher\EventSubscriberInterface;
++ 
++ /**
++@@ -26,153 +19,51 @@ use Symfony\Component\EventDispatcher\EventSubscriberInterface;
++ */
++ class listener implements EventSubscriberInterface
++ {
++-	/* @var topfive */
++-	protected $topfive;
+++	/* @var \rmcgirr83\topfive\core\topfive */
+++	protected $functions;
++ 
++-	/** @var config */
+++	/** @var \phpbb\config\config */
++ 	protected $config;
++ 
++-	/** @var language */
++-	protected $language;
++-
++-	/** @var template */
+++	/** @var \phpbb\template\template */
++ 	protected $template;
++ 
++-	/** @var user */
+++	/** @var \phpbb\user */
++ 	protected $user;
++ 
++-	/** @var helper */
++-	protected $helper;
++-
++-	/** @var string php_ext */
++-	protected $php_ext;
++-
++-	/* @var array topfive_constants */
++-	protected $topfive_constants;
++-
++-	public function __construct(
++-		topfive $topfive,
++-		config $config,
++-		language $language,
++-		template $template,
++-		user $user,
++-		helper $helper,
++-		string $php_ext,
++-		array $topfive_constants,
++-		\phpbb\collapsiblecategories\operator\operator $operator = null)
+++	public function __construct(\rmcgirr83\topfive\core\topfive $functions, \phpbb\config\config $config, \phpbb\template\template $template, \phpbb\user $user)
++ 	{
++-		$this->topfive = $topfive;
+++		$this->functions = $functions;
++ 		$this->config = $config;
++-		$this->language = $language;
++ 		$this->template = $template;
++ 		$this->user = $user;
++-		$this->helper = $helper;
++-		$this->php_ext = $php_ext;
++-		$this->topfive_constants = $topfive_constants;
++-		$this->operator = $operator;
++ 	}
++ 
++ 	static public function getSubscribedEvents()
++ 	{
++ 
++-		return [
++-			'core.acp_extensions_run_action_after'	=> 'acp_extensions_run_action_after',
++-			'core.index_modify_page_title'	=> 'index_page',
++-			'core.page_header' => 'entire_forum',
++-		];
++-	}
++-
++-	/* Display additional metdate in extension details
++-	*
++-	* @param $event			event object
++-	* @param return null
++-	* @access public
++-	*/
++-	public function acp_extensions_run_action_after($event)
++-	{
++-		if ($event['ext_name'] == 'rmcgirr83/topfive' && $event['action'] == 'details')
++-		{
++-			$this->language->add_lang('acp_topfive', $event['ext_name']);
++-			$this->template->assign_var('S_BUY_ME_A_BEER_TOPFIVE', true);
++-		}
+++		return array(
+++			'core.page_footer'	=> 'main',
+++		);
++ 	}
++ 
++-	/* Display top five on index page
++-	*
++-	* @param $event			event object
++-	* @param return null
++-	* @access public
++-	*/
++-	public function index_page($event)
+++	public function main($event)
++ 	{
++-		$should_display = in_array((int) $this->config['top_five_location'], [$this->topfive_constants['top_of_index'], $this->topfive_constants['bottom_of_index']]) ? true : false;
++-
++-		if (!$should_display)
+++		if (!$this->config['top_five_active'])
++ 		{
++ 			return;
++ 		}
++ 
++ 		// add lang file
++-		$this->language->add_lang('topfive', 'rmcgirr83/topfive');
+++		$this->user->add_lang_ext('rmcgirr83/topfive', 'topfive');
++ 
++-		$this->topfive->topposters();
++-		$this->topfive->newusers();
++-		$this->topfive->toptopics();
+++		$this->functions->topposters();
+++		$this->functions->newusers();
+++		$this->functions->toptopics();
++ 
++-		if ($this->operator !== null)
++-		{
++-			$fid = 'topfive'; // can be any unique string to identify your extension's collapsible element
++-			$this->template->assign_vars([
++-				'S_TOPFIVE_HIDDEN' => $this->operator->is_collapsed($fid),
++-				'U_TOPFIVE_COLLAPSE_URL' => $this->operator->get_collapsible_link($fid),
++-			]);
++-		}
++-		$this->template->assign_vars([
+++		$this->template->assign_vars(array(
+++			'S_TOPFIVE'	=>	$this->config['top_five_active'],
++ 			'S_TOPFIVE_LOCATION'	=> $this->config['top_five_location'],
++-		]);
++-	}
++-
++-	/* Display top five on every page
++-	*
++-	* @param $event			event object
++-	* @param return null
++-	* @access public
++-	*/
++-	public function entire_forum($event)
++-	{
++-		$should_display = (in_array((int) $this->config['top_five_location'], [$this->topfive_constants['top_of_entire_forum'], $this->topfive_constants['bottom_of_entire_forum']]) && !$this->is_non_content_page($this->user->page['page_name'])) ? true : false;
++-
++-		if (!$should_display)
++-		{
++-			return;
++-		}
++-
++-		// add lang file
++-		$this->language->add_lang('topfive', 'rmcgirr83/topfive');
++-
++-		$this->topfive->topposters();
++-		$this->topfive->newusers();
++-		$this->topfive->toptopics();
++-
++-		$this->template->assign_vars([
++-			'S_TOPFIVE_LOCATION'	=> $this->config['top_five_location']
++-		]);
++-	}
++-
++-	/**
++-	 * Check if the given page name is designated as a non-content page.
++-	 *
++-	 * @param string $page_name
++-	 * @return bool True or false
++-	 */
++-	private function is_non_content_page($page_name)
++-	{
++-		return in_array($page_name, [
++-			'memberlist.' . $this->php_ext,
++-			'posting.' . $this->php_ext,
++-			'viewonline.' . $this->php_ext,
++-			'ucp.' . $this->php_ext,
++-			'mcp.' . $this->php_ext,
++-		]);
+++		));
++ 	}
++ }
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/ext.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\topfive/ext.php"
++index bc8f2d3e7..f51579231 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/ext.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\topfive/ext.php"
++@@ -23,6 +23,6 @@ class ext extends \phpbb\extension\base
++ 	public function is_enableable()
++ 	{
++ 		$config = $this->container->get('config');
++-		return version_compare($config['version'], '3.3', '>=');
+++		return version_compare($config['version'], '3.1.2', '>=');
++ 	}
++ }
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/language/en/acp/info_acp_topfive.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\topfive/language/en/acp/info_acp_topfive.php"
++index 703d7c494..8e22ad810 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/language/en/acp/info_acp_topfive.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\topfive/language/en/acp/info_acp_topfive.php"
++@@ -16,11 +16,32 @@ if (!defined('IN_PHPBB'))
++ 
++ if (empty($lang) || !is_array($lang))
++ {
++-	$lang = [];
+++	$lang = array();
++ }
++ 
++-$lang = array_merge($lang, [
+++$lang = array_merge($lang, array(
++ 	// ACP
++ 	'TF_ACP'		=> 'Top Five Extension',
+++	'TF_ACTIVE'		=> 'Enabled',
+++	'TF_TITLE'		=> 'Top Five Extension Settings',
+++	'TF_VERSION'	=> 'Top Five Version',
+++	'TOPFIVE_MOD'	=> 'Top Five',
++ 	'TF_CONFIG'		=> 'Settings',
++-]);
+++	'TF_SELECT'		=> 'Top Five',
+++	'TF_SAVED'		=> 'Changes Saved',
+++	'TF_HOWMANY'	=> 'How Many',
+++	'TF_HOWMANY_EXPLAIN'	=> 'How many would you like to display...minimum required is 5, maximum is 100',
+++	'TF_IGNORE_USERS'		=> 'Ignore Inactive Users',
+++	'TF_IGNORE_USERS_EXPLAIN'	=> 'Will exclude inactive users from the display in top posters and newest users',
+++	'TF_IGNORE_FOUNDER'		=> 'Ignore Founder(s)',
+++	'TF_IGNORE_FOUNDER_EXPLAIN'	=> 'Will exclude founders from the display in top posters and newest users',
+++	'TF_LOCATION'	=> 'Location on forum',
+++	'TF_LOCATION_EXPLAIN'	=> 'Where do you want the mod to display on the index page',
+++	'TF_SHOW_ADMINS_MODS'	=> 'Include Admins and Mods',
+++	'TF_SHOW_ADMINS_MODS_EXPLAIN'	=> 'Will display admins and mods in top posters',
+++	'TOO_SMALL_TOP_FIVE_HOW_MANY'	=> 'The number to display value is too small.',
+++	'TOO_LARGE_TOP_FIVE_HOW_MANY'	=> 'The number to display value is too large.',
+++	'TOP_OF_FORUM'	=> 'Top of Forum',
+++	'BOTTOM_OF_FORUM'	=> 'Bottom of Forum',
+++
+++));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/language/en/acp_topfive.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/language/en/acp_topfive.php"
++deleted file mode 100644
++index 0ee0f664a..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/language/en/acp_topfive.php"
+++++ /dev/null
++@@ -1,56 +0,0 @@
++-<?php
++-/**
++-*
++-* topfive [English]
++-*
++-* @package language Top Five
++-* @copyright (c) 2014 RMcGirr83
++-* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
++-*
++-*/
++-
++-if (!defined('IN_PHPBB'))
++-{
++-	exit;
++-}
++-
++-if (empty($lang) || !is_array($lang))
++-{
++-	$lang = [];
++-}
++-
++-$lang = array_merge($lang, [
++-	'TF_ACTIVE'		=> 'Enabled',
++-	'TF_AVATARS'	=> 'Avatars',
++-	'TF_AVATARS_EXPLAIN'	=> 'Choose yes or no to display users avatars',
++-	'TF_TITLE'		=> 'Top Five Extension Settings',
++-	'TOPFIVE_MOD'	=> 'Top Five',
++-	'TF_CONFIG'		=> 'Settings',
++-	'TF_SAVED'		=> 'Changes Saved',
++-	'TF_HOWMANY'	=> 'How Many',
++-	'TF_EXCLUDED'	=> 'Excluded forums',
++-	'TF_EXCLUDED_EXPLAIN'	=> 'Use CTRL/CMD and mouse click to choose or unchoose multiple forums<br><em>If you don&#39;t want to exclude a forum, either don&#39;t select any or unselect the ones you have chosen</em>',
++-
++-	'TF_HOWMANY_EXPLAIN'	=> 'How many would you like to display... minimum required is 5, maximum is 100',
++-	'TF_IGNORE_USERS'		=> 'Ignore Inactive Users',
++-	'TF_IGNORE_USERS_EXPLAIN'	=> 'Will exclude inactive users from the display in top posters and newest users',
++-	'TF_IGNORE_FOUNDER'		=> 'Ignore Founder(s)',
++-	'TF_IGNORE_FOUNDER_EXPLAIN'	=> 'Will exclude founders from the display in top posters and newest users',
++-	'TF_LOCATION'	=> 'Location on forum',
++-	'TF_LOCATION_EXPLAIN'	=> 'Where do you want the extension to display on the forum.<br><i>If you choose top or bottom of entire forum, the extension will only display on those pages that are considered content pages.</i>',
++-	'TF_SHOW_ADMINS_MODS'	=> 'Include Admins and Mods',
++-	'TF_SHOW_ADMINS_MODS_EXPLAIN'	=> 'Will display admins and mods in top posters',
++-	'TOO_SMALL_TOP_FIVE_HOW_MANY'	=> 'The number to display value is too small.',
++-	'TOO_LARGE_TOP_FIVE_HOW_MANY'	=> 'The number to display value is too large.',
++-	'TOP_OF_FORUM'	=> 'Top of index page',
++-	'BOTTOM_OF_FORUM'	=> 'Bottom of index page',
++-	'TOP_OF_ENTIRE_FORUM'	=> 'Top of entire forum',
++-	'BOTTOM_OF_ENTIRE_FORUM'	=> 'Bottom of entire forum',
++-	//Donation
++-	'PAYPAL_IMAGE_URL'          => 'https://www.paypalobjects.com/webstatic/en_US/i/btn/png/silver-pill-paypal-26px.png',
++-	'PAYPAL_ALT'                => 'Donate using PayPal',
++-	'BUY_ME_A_BEER_URL'         => 'https://paypal.me/RMcGirr83',
++-	'BUY_ME_A_BEER'				=> 'Buy me a beer for creating this extension',
++-	'BUY_ME_A_BEER_SHORT'		=> 'Make a donation for this extension',
++-	'BUY_ME_A_BEER_EXPLAIN'		=> 'This extension is completely free. It is a project that I spend my time on for the enjoyment and use of the phpBB community. If you enjoy using this extension, or if it has benefited your forum, please consider <a href="https://paypal.me/RMcGirr83" target="_blank" rel="noreferrer noopener">buying me a beer</a>. It would be greatly appreciated. <i class="fa fa-smile-o" style="color:green;font-size:1.5em;" aria-hidden="true"></i>',
++-]);
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/language/en/topfive.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\topfive/language/en/topfive.php"
++index 0a2f6eb0c..ea78eee99 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/language/en/topfive.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\topfive/language/en/topfive.php"
++@@ -17,7 +17,7 @@ if (!defined('IN_PHPBB'))
++ 
++ if (empty($lang) || !is_array($lang))
++ {
++-	$lang = [];
+++	$lang = array();
++ }
++ 
++ // DEVELOPERS PLEASE NOTE
++@@ -32,11 +32,12 @@ if (empty($lang) || !is_array($lang))
++ // equally where a string contains only two placeholders which are used to wrap text
++ // in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
++ 
++-$lang = array_merge($lang, [
+++$lang = array_merge($lang, array(
+++	'TOP_FIVE'			=> 'Top Activity',
++ 	'NEWEST_TOPICS'		=> 'Newest Posts',
++ 	'NO_TOPIC_EXIST'	=> 'No posts exist for viewing',
++ 	'TOP_FIVE_ACTIVE'	=> 'Top Active Users',
++ 	'TOP_FIVE_NEWEST'	=> 'Newest Users',
++-	'BY'                => 'by&nbsp;',
++-	'USER_LASTPOST_TIME'	=> 'Last Post: %s',
++-]);
+++	'IN'                => 'In',
+++	'BY'                => 'by:',
+++));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/migrations/top_five_v111.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/migrations/top_five_v111.php"
++deleted file mode 100644
++index 815c1fdff..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/migrations/top_five_v111.php"
+++++ /dev/null
++@@ -1,25 +0,0 @@
++-<?php
++-/**
++-*
++-* @package Top Five
++-* @copyright (c) 2015 Rich Mcgirr (RMcGirr83)
++-* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
++-*
++-*/
++-
++-namespace rmcgirr83\topfive\migrations;
++-
++-class top_five_v111 extends \phpbb\db\migration\migration
++-{
++-	static public function depends_on()
++-	{
++-		return array('\rmcgirr83\topfive\migrations\top_five_v14');
++-	}
++-
++-	public function update_data()
++-	{
++-		return array(
++-			array('config.add', array('top_five_avatars', 0)),
++-		);
++-	}
++-}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/migrations/top_five_v123.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/migrations/top_five_v123.php"
++deleted file mode 100644
++index 299e61205..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/migrations/top_five_v123.php"
+++++ /dev/null
++@@ -1,34 +0,0 @@
++-<?php
++-/**
++-*
++-* @package Top Five
++-* @copyright (c) 2015 Rich Mcgirr (RMcGirr83)
++-* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
++-*
++-*/
++-
++-namespace rmcgirr83\topfive\migrations;
++-
++-class top_five_v123 extends \phpbb\db\migration\migration
++-{
++-	static public function depends_on()
++-	{
++-		return ['\rmcgirr83\topfive\migrations\top_five_v111'];
++-	}
++-
++-	public function update_data()
++-	{
++-		return [
++-			['module.remove', ['acp', false, 'TF_CONFIG']],
++-			['module.add', [
++-				'acp',
++-				'TF_ACP',
++-				[
++-					'module_basename'	=> '\rmcgirr83\topfive\acp\topfive_module',
++-					'auth'				=> 'ext_rmcgirr83/topfive && acl_a_extensions',
++-					'modes'				=> ['settings'],
++-				],
++-			]],
++-		];
++-	}
++-}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/migrations/top_five_v125.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/migrations/top_five_v125.php"
++deleted file mode 100644
++index 366cfda08..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/migrations/top_five_v125.php"
+++++ /dev/null
++@@ -1,25 +0,0 @@
++-<?php
++-/**
++-*
++-* @package Top Five
++-* @copyright (c) 2015 Rich Mcgirr (RMcGirr83)
++-* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
++-*
++-*/
++-
++-namespace rmcgirr83\topfive\migrations;
++-
++-class top_five_v125 extends \phpbb\db\migration\migration
++-{
++-	static public function depends_on()
++-	{
++-		return ['\rmcgirr83\topfive\migrations\top_five_v123'];
++-	}
++-
++-	public function update_data()
++-	{
++-		return [
++-			['config.update', ['top_five_active', 1]],
++-		];
++-	}
++-}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/migrations/top_five_v126.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/migrations/top_five_v126.php"
++deleted file mode 100644
++index eb030420e..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/migrations/top_five_v126.php"
+++++ /dev/null
++@@ -1,25 +0,0 @@
++-<?php
++-/**
++-*
++-* @package Top Five
++-* @copyright (c) 2024 Rich Mcgirr (RMcGirr83)
++-* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
++-*
++-*/
++-
++-namespace rmcgirr83\topfive\migrations;
++-
++-class top_five_v126 extends \phpbb\db\migration\migration
++-{
++-	static public function depends_on()
++-	{
++-		return ['\rmcgirr83\topfive\migrations\top_five_v125'];
++-	}
++-
++-	public function update_data()
++-	{
++-		return [
++-			['config.remove', ['top_five_active']],
++-		];
++-	}
++-}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/migrations/top_five_v13.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/migrations/top_five_v13.php"
++deleted file mode 100644
++index 302c891ec..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/migrations/top_five_v13.php"
+++++ /dev/null
++@@ -1,31 +0,0 @@
++-<?php
++-/**
++-*
++-* @package Top Five
++-* @copyright (c) 2015 RMcGirr83
++-* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
++-*
++-*/
++-
++-namespace rmcgirr83\topfive\migrations;
++-
++-class top_five_v13 extends \phpbb\db\migration\migration
++-{
++-	public function effectively_installed()
++-	{
++-		return isset($this->config['top_five_version']) && version_compare($this->config['top_five_version'], '1.0.3', '>=');
++-	}
++-
++-	static public function depends_on()
++-	{
++-		return array('\rmcgirr83\topfive\migrations\top_five_v12');
++-	}
++-
++-	public function update_data()
++-	{
++-		return array(
++-			array('config.update', array('top_five_version', '1.0.3')),
++-			array('config.add', array('top_five_excluded', 0)),
++-		);
++-	}
++-}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/migrations/top_five_v14.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/migrations/top_five_v14.php"
++deleted file mode 100644
++index 6973c212b..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/migrations/top_five_v14.php"
+++++ /dev/null
++@@ -1,25 +0,0 @@
++-<?php
++-/**
++-*
++-* @package Top Five
++-* @copyright (c) 2015 Rich Mcgirr (RMcGirr83)
++-* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
++-*
++-*/
++-
++-namespace rmcgirr83\topfive\migrations;
++-
++-class top_five_v14 extends \phpbb\db\migration\migration
++-{
++-	static public function depends_on()
++-	{
++-		return array('\rmcgirr83\topfive\migrations\top_five_v13');
++-	}
++-
++-	public function update_data()
++-	{
++-		return array(
++-			array('config.remove', array('top_five_version')),
++-		);
++-	}
++-}
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\topfive/styles/BBOOTS/template/event/recent_topics_body.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\topfive/styles/BBOOTS/template/event/recent_topics_body.html"
++new file mode 100644
++index 000000000..d9345da55
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\topfive/styles/BBOOTS/template/event/recent_topics_body.html"
++@@ -0,0 +1,3 @@
+++<!-- IF S_TOPFIVE and not S_TOPFIVE_LOCATION -->
+++	<!-- INCLUDE topfive_body.html -->
+++<!-- ENDIF -->
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\topfive/styles/BBOOTS/template/topfive_body.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\topfive/styles/BBOOTS/template/topfive_body.html"
++new file mode 100644
++index 000000000..4139dc116
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\topfive/styles/BBOOTS/template/topfive_body.html"
++@@ -0,0 +1,10 @@
+++<!-- BEGIN top_five_topic -->
+++<div class="recent-topic text-overflow">
+++	<a href="#" class="blogImage" title="">{top_five_topic.TOP5_AVATAR}</a>
+++	<!-- IF top_five_topic.NO_TOPIC_TITLE-->{top_five_topic.NO_TOPIC_TITLE}<!-- ELSE -->
+++	<a href="{top_five_topic.U_TOPIC}" title="{top_five_topic.TOPIC_TITLE}"><i class="fa fa-mail-forward text-muted"></i> {top_five_topic.TOPIC_TITLE}</a>
+++	<p><i class="fa fa-user"></i> {top_five_topic.USERNAME_FULL}</p>
+++	<p><i class="fa fa-clock-o"></i> {top_five_topic.LAST_TOPIC_TIME}</p>
+++	 <!-- ENDIF -->
+++</div>
+++<!-- END top_five_topic -->
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/styles/prosilver/template/event/index_body_forumlist_body_after.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/styles/prosilver/template/event/index_body_forumlist_body_after.html"
++deleted file mode 100644
++index 98c7ad3ae..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/styles/prosilver/template/event/index_body_forumlist_body_after.html"
+++++ /dev/null
++@@ -1,3 +0,0 @@
++-{% if S_TOPFIVE_LOCATION == 1 %}
++-	{% INCLUDE '@rmcgirr83_topfive/topfive_body.html' %}
++-{% endif %}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/styles/prosilver/template/event/index_body_markforums_after.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/styles/prosilver/template/event/index_body_markforums_after.html"
++deleted file mode 100644
++index e4cad34d5..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/styles/prosilver/template/event/index_body_markforums_after.html"
+++++ /dev/null
++@@ -1,3 +0,0 @@
++-{% if S_TOPFIVE_LOCATION == 0 %}
++-	{% INCLUDE '@rmcgirr83_topfive/topfive_body.html' %}
++-{% endif %}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/styles/prosilver/template/event/overall_footer_content_after.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/styles/prosilver/template/event/overall_footer_content_after.html"
++deleted file mode 100644
++index 30126369b..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/styles/prosilver/template/event/overall_footer_content_after.html"
+++++ /dev/null
++@@ -1,3 +0,0 @@
++-{% if S_TOPFIVE_LOCATION == 3 %}
++-	{% INCLUDE '@rmcgirr83_topfive/topfive_body.html' %}
++-{% endif %}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/styles/prosilver/template/event/overall_header_content_before.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/styles/prosilver/template/event/overall_header_content_before.html"
++deleted file mode 100644
++index eae255cdb..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/styles/prosilver/template/event/overall_header_content_before.html"
+++++ /dev/null
++@@ -1,3 +0,0 @@
++-{% if S_TOPFIVE_LOCATION == 2 %}
++-	{% INCLUDE '@rmcgirr83_topfive/topfive_body.html' %}
++-{% endif %}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/styles/prosilver/template/event/overall_header_head_append.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/styles/prosilver/template/event/overall_header_head_append.html"
++deleted file mode 100644
++index 5cb14c0f6..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/styles/prosilver/template/event/overall_header_head_append.html"
+++++ /dev/null
++@@ -1 +0,0 @@
++-{% INCLUDECSS '@rmcgirr83_topfive/topfive.css' %}
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/styles/prosilver/template/topfive_body.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/styles/prosilver/template/topfive_body.html"
++deleted file mode 100644
++index 651faf88f..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/styles/prosilver/template/topfive_body.html"
+++++ /dev/null
++@@ -1,57 +0,0 @@
++-<a class="category{% if S_TOPFIVE_HIDDEN %} hidden-category{% endif %}" style="display: none; height: 0"></a>
++-<div class="forabg" id="top_five">
++-	<div class="inner">
++-	<ul class="topiclist">
++-		<li class="header">
++-			<dl class="row-item">
++-				<dt><div class="list-inner">{{ lang('NEWEST_TOPICS') }}</div></dt>
++-				<dd class="topics tf-active-header">{{ lang('TOP_FIVE_ACTIVE') }}</dd>
++-				<dd class="lastpost"><span>{{ lang('TOP_FIVE_NEWEST') }}</span></dd>
++-			</dl>
++-			{% if U_TOPFIVE_COLLAPSE_URL %}<a href="{{ U_TOPFIVE_COLLAPSE_URL }}" class="collapse-btn collapse-{% if S_TOPFIVE_HIDDEN %}show{% else %}hide{% endif %}" data-hidden="{{ S_TOPFIVE_HIDDEN }}" data-ajax="phpbb_collapse" data-overlay="true" title="{{ lang('COLLAPSIBLE_CATEGORIES_TITLE') }}" style="display: none; line-height: 0;"></a>{% endif %}
++-		</li>
++-	</ul>
++-	<ul class="topiclist forums">
++-		<li class="row">
++-			<dl>
++-				<dt>
++-					<div class="list-inner">
++-						<ul>
++-							{% for top_five_topic in loops.top_five_topic %}
++-								<li class="top_five">
++-									{% if top_five_topic.NO_TOPIC_TITLE%}
++-										{{ top_five_topic.NO_TOPIC_TITLE }}
++-									{% else %}
++-										<a href="{{ top_five_topic.U_TOPIC }}" class="topictitle subforum{% if top_five_topic.S_UNREAD %} unread{% else %} read{% endif %}">
++-											<i class="icon fa-file-o fa-fw {% if top_five_topic.S_UNREAD %} icon-red{% else %} icon-blue{% endif %} icon-md" aria-hidden="true"></i>
++-											{{ top_five_topic.TOPIC_TITLE }}</a><span class="meta">{{ top_five_topic.USERNAME_FULL }} {% if top_five_topic.USER_FLAG %} {{ top_five_topic.USER_FLAG }} {% endif %}&raquo; {{ top_five_topic.LAST_TOPIC_TIME }} &raquo; {{ lang('IN') }}&nbsp;<a href="{{ top_five_topic.U_FORUM }}">{{ top_five_topic.FORUM_NAME }}</a></span>
++-										{% EVENT rmcgirr83_top_five_topiclist_row_append %}
++-									{% endif %}
++-								</li>
++-							{% endfor %}
++-						</ul>
++-					</div>
++-				</dt>
++-				<dd class="topics tf-most-active">
++-					<ul>
++-						{% for top_five_active in loops.top_five_active %}
++-							<li>
++-								<span class="meta">{{ top_five_active.USERNAME_FULL }} {% if top_five_active.USER_FLAG %} {{ top_five_active.USER_FLAG }} {% endif %}<span><br>&nbsp;&nbsp;{{ lang('POSTS') }}{{ lang('COLON') }} <a href="{{ top_five_active.S_SEARCH_ACTION }}" title="{{ top_five_active.USER_LASTPOST_TIME }}">{{ top_five_active.POSTS }}</a></span></span>
++-							</li>
++-						{% endfor %}
++-					</ul>
++-				</dd>
++-				<dd class="lastpost tf-newest"><span>
++-					<ul>
++-						{% for top_five_newest in loops.top_five_newest %}
++-							<li>
++-								<span class="meta">{{ top_five_newest.USERNAME_FULL }}{% if top_five_newest.USER_FLAG %} {{ top_five_newest.USER_FLAG }} {% endif %}<span><br>&nbsp;&nbsp;{{ lang('JOINED') }}{{ lang('COLON') }} {{ top_five_newest.REG_DATE }}</span></span>
++-							</li>
++-						{% endfor %}
++-					</ul>
++-				</span></dd>
++-			</dl>
++-		</li>
++-	</ul>
++-	</div>
++-</div>
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/styles/prosilver/theme/topfive.css" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/styles/prosilver/theme/topfive.css"
++deleted file mode 100644
++index 4d339e5c0..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/styles/prosilver/theme/topfive.css"
+++++ /dev/null
++@@ -1,81 +0,0 @@
++-dd.tf-most-active {
++-	font-size: 1.2em;
++-	line-height: 1.2em;
++-	text-align: left;
++-	width: 185px;
++-}
++-
++-.rtl dd.tf-most-active  {
++-	text-align: right;
++-}
++-
++-dd.tf-newest {
++-	font-size: 1.2em;	
++-	line-height: 1.2em;
++-	text-align: left;
++-}
++-
++-.rtl dd.tf-newest {
++-	text-align: right;
++-}
++-
++-dd.tf-active-header {
++-	width: 185px;
++-	text-align:left;
++-}
++-
++-.rtl dd.tf-active-header {
++-	text-align:right;
++-}
++-
++-#top_five ul {
++-	list-style-type: none;
++-}
++-
++-#top_five li {
++-	padding: 2px 0;
++-}
++-
++-#top_five li:first-child {
++-	padding-top: 0;
++-}
++-
++-#top_five li:last-child {
++-	padding-bottom: 0;
++-}
++-
++-#top_five .meta {
++-	display: block;
++-	padding-left: 8px;
++-}
++-
++-.rtl #top_five {
++-	text-align: right;
++-}
++-
++-.rtl #top_five .meta {
++-	padding-left: 0;
++-	padding-right: 8px;
++-}
++-
++-#top_five ul.topiclist li.row a.subforum {
++-	white-space: normal;
++-}
++-
++-@media only screen and (max-width: 970px) {
++-	#top_five {
++-		display: none;
++-	}
++-}
++-
++-/* Fixes avatar aspect-ratio */
++-#top_five .topfive-avatar img { 
++-	max-height: 20px;
++-    vertical-align: middle;
++-    width: auto;
++-}
++-
++-/* fixes national flags position */
++-.top_five .flag_image {
++-  vertical-align: middle;
++-}
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/styles/scaffoldBB/template/event/index_body_forumlist_body_after.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/styles/scaffoldBB/template/event/index_body_forumlist_body_after.html"
++deleted file mode 100644
++index 98c7ad3ae..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/styles/scaffoldBB/template/event/index_body_forumlist_body_after.html"
+++++ /dev/null
++@@ -1,3 +0,0 @@
++-{% if S_TOPFIVE_LOCATION == 1 %}
++-	{% INCLUDE '@rmcgirr83_topfive/topfive_body.html' %}
++-{% endif %}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/styles/scaffoldBB/template/event/index_body_markforums_after.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/styles/scaffoldBB/template/event/index_body_markforums_after.html"
++deleted file mode 100644
++index e4cad34d5..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/styles/scaffoldBB/template/event/index_body_markforums_after.html"
+++++ /dev/null
++@@ -1,3 +0,0 @@
++-{% if S_TOPFIVE_LOCATION == 0 %}
++-	{% INCLUDE '@rmcgirr83_topfive/topfive_body.html' %}
++-{% endif %}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/styles/scaffoldBB/template/event/overall_footer_page_body_after.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/styles/scaffoldBB/template/event/overall_footer_page_body_after.html"
++deleted file mode 100644
++index 30126369b..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/styles/scaffoldBB/template/event/overall_footer_page_body_after.html"
+++++ /dev/null
++@@ -1,3 +0,0 @@
++-{% if S_TOPFIVE_LOCATION == 3 %}
++-	{% INCLUDE '@rmcgirr83_topfive/topfive_body.html' %}
++-{% endif %}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/styles/scaffoldBB/template/event/overall_header_content_before.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/styles/scaffoldBB/template/event/overall_header_content_before.html"
++deleted file mode 100644
++index eae255cdb..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/styles/scaffoldBB/template/event/overall_header_content_before.html"
+++++ /dev/null
++@@ -1,3 +0,0 @@
++-{% if S_TOPFIVE_LOCATION == 2 %}
++-	{% INCLUDE '@rmcgirr83_topfive/topfive_body.html' %}
++-{% endif %}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/styles/scaffoldBB/template/event/overall_header_head_append.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/styles/scaffoldBB/template/event/overall_header_head_append.html"
++deleted file mode 100644
++index fb88b4a3a..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/styles/scaffoldBB/template/event/overall_header_head_append.html"
+++++ /dev/null
++@@ -1,3 +0,0 @@
++-{% if S_TOPFIVE %}
++-	{% INCLUDECSS '@rmcgirr83_topfive/topfive.css' %}
++-{% endif %}
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/styles/scaffoldBB/template/topfive_body.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/styles/scaffoldBB/template/topfive_body.html"
++deleted file mode 100644
++index 9f9a5f410..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\topfive/styles/scaffoldBB/template/topfive_body.html"
+++++ /dev/null
++@@ -1,45 +0,0 @@
++-<a class="category{% if S_TOPFIVE_HIDDEN %} hidden-category{% endif %}" style="display: none; height: 0"></a>
++-<div class="bg-gradient bg-primary forabg mb-3 rounded-3 py-1 px-2 d-none d-md-block {% if S_TOPFIVE_LOCATION == 3 %}mx-md-3{% endif %}" id="top_five">
++-	<ul class="header row gx-0 list-unstyled my-1">
++-		<li class="col-7 fw-bold text-uppercase text-white text-decoration-none"><div class="list-inner">{{ lang('NEWEST_TOPICS') }}</div></li>
++-		<li class="topics col-2 text-white tf-active-header text-uppercase">{{ lang('TOP_FIVE_ACTIVE') }}</li>
++-		<li class="lastpost col-3 text-white text-uppercase"><span>{{ lang('TOP_FIVE_NEWEST') }}</span></li>
++-	</ul>
++-	{% if U_TOPFIVE_COLLAPSE_URL %}<a href="{{ U_TOPFIVE_COLLAPSE_URL }}" class="collapse-btn " data-hidden="{{ S_TOPFIVE_HIDDEN }}" data-ajax="phpbb_collapse" data-overlay="true" title="{{ lang('COLLAPSIBLE_CATEGORIES_TITLE') }}" style="display: none; line-height: 0;"></a>{% endif %}
++-	<ul class="bg-body topiclist for
\ No newline at end of file
diff --git "[ORIGINAL]/rmcgirr83\\topfive/event/listener.php" "[FORUM_EXT]/rmcgirr83\\topfive/event/listener.php"
--- "[ORIGINAL]/rmcgirr83\\topfive/event/listener.php"
+++ "[FORUM_EXT]/rmcgirr83\\topfive/event/listener.php"
@@ -12,13 +12,6 @@ namespace rmcgirr83\topfive\event;
 /**
 * @ignore
 */
-use rmcgirr83\topfive\core\topfive;
-use phpbb\config\config;
-use phpbb\language\language;
-use phpbb\template\template;
-use phpbb\user;
-use phpbb\controller\helper;
-
 use Symfony\Component\EventDispatcher\EventSubscriberInterface;
 
 /**
@@ -26,153 +19,51 @@ use Symfony\Component\EventDispatcher\EventSubscriberInterface;
 */
 class listener implements EventSubscriberInterface
 {
-	/* @var topfive */
-	protected $topfive;
+	/* @var \rmcgirr83\topfive\core\topfive */
+	protected $functions;
 
-	/** @var config */
+	/** @var \phpbb\config\config */
 	protected $config;
 
-	/** @var language */
-	protected $language;
-
-	/** @var template */
+	/** @var \phpbb\template\template */
 	protected $template;
 
-	/** @var user */
+	/** @var \phpbb\user */
 	protected $user;
 
-	/** @var helper */
-	protected $helper;
-
-	/** @var string php_ext */
-	protected $php_ext;
-
-	/* @var array topfive_constants */
-	protected $topfive_constants;
-
-	public function __construct(
-		topfive $topfive,
-		config $config,
-		language $language,
-		template $template,
-		user $user,
-		helper $helper,
-		string $php_ext,
-		array $topfive_constants,
-		\phpbb\collapsiblecategories\operator\operator $operator = null)
+	public function __construct(\rmcgirr83\topfive\core\topfive $functions, \phpbb\config\config $config, \phpbb\template\template $template, \phpbb\user $user)
 	{
-		$this->topfive = $topfive;
+		$this->functions = $functions;
 		$this->config = $config;
-		$this->language = $language;
 		$this->template = $template;
 		$this->user = $user;
-		$this->helper = $helper;
-		$this->php_ext = $php_ext;
-		$this->topfive_constants = $topfive_constants;
-		$this->operator = $operator;
 	}
 
 	static public function getSubscribedEvents()
 	{
 
-		return [
-			'core.acp_extensions_run_action_after'	=> 'acp_extensions_run_action_after',
-			'core.index_modify_page_title'	=> 'index_page',
-			'core.page_header' => 'entire_forum',
-		];
-	}
-
-	/* Display additional metdate in extension details
-	*
-	* @param $event			event object
-	* @param return null
-	* @access public
-	*/
-	public function acp_extensions_run_action_after($event)
-	{
-		if ($event['ext_name'] == 'rmcgirr83/topfive' && $event['action'] == 'details')
-		{
-			$this->language->add_lang('acp_topfive', $event['ext_name']);
-			$this->template->assign_var('S_BUY_ME_A_BEER_TOPFIVE', true);
-		}
+		return array(
+			'core.page_footer'	=> 'main',
+		);
 	}
 
-	/* Display top five on index page
-	*
-	* @param $event			event object
-	* @param return null
-	* @access public
-	*/
-	public function index_page($event)
+	public function main($event)
 	{
-		$should_display = in_array((int) $this->config['top_five_location'], [$this->topfive_constants['top_of_index'], $this->topfive_constants['bottom_of_index']]) ? true : false;
-
-		if (!$should_display)
+		if (!$this->config['top_five_active'])
 		{
 			return;
 		}
 
 		// add lang file
-		$this->language->add_lang('topfive', 'rmcgirr83/topfive');
+		$this->user->add_lang_ext('rmcgirr83/topfive', 'topfive');
 
-		$this->topfive->topposters();
-		$this->topfive->newusers();
-		$this->topfive->toptopics();
+		$this->functions->topposters();
+		$this->functions->newusers();
+		$this->functions->toptopics();
 
-		if ($this->operator !== null)
-		{
-			$fid = 'topfive'; // can be any unique string to identify your extension's collapsible element
-			$this->template->assign_vars([
-				'S_TOPFIVE_HIDDEN' => $this->operator->is_collapsed($fid),
-				'U_TOPFIVE_COLLAPSE_URL' => $this->operator->get_collapsible_link($fid),
-			]);
-		}
-		$this->template->assign_vars([
+		$this->template->assign_vars(array(
+			'S_TOPFIVE'	=>	$this->config['top_five_active'],
 			'S_TOPFIVE_LOCATION'	=> $this->config['top_five_location'],
-		]);
-	}
-
-	/* Display top five on every page
-	*
-	* @param $event			event object
-	* @param return null
-	* @access public
-	*/
-	public function entire_forum($event)
-	{
-		$should_display = (in_array((int) $this->config['top_five_location'], [$this->topfive_constants['top_of_entire_forum'], $this->topfive_constants['bottom_of_entire_forum']]) && !$this->is_non_content_page($this->user->page['page_name'])) ? true : false;
-
-		if (!$should_display)
-		{
-			return;
-		}
-
-		// add lang file
-		$this->language->add_lang('topfive', 'rmcgirr83/topfive');
-
-		$this->topfive->topposters();
-		$this->topfive->newusers();
-		$this->topfive->toptopics();
-
-		$this->template->assign_vars([
-			'S_TOPFIVE_LOCATION'	=> $this->config['top_five_location']
-		]);
-	}
-
-	/**
-	 * Check if the given page name is designated as a non-content page.
-	 *
-	 * @param string $page_name
-	 * @return bool True or false
-	 */
-	private function is_non_content_page($page_name)
-	{
-		return in_array($page_name, [
-			'memberlist.' . $this->php_ext,
-			'posting.' . $this->php_ext,
-			'viewonline.' . $this->php_ext,
-			'ucp.' . $this->php_ext,
-			'mcp.' . $this->php_ext,
-		]);
+		));
 	}
 }
diff --git "[ORIGINAL]/rmcgirr83\\topfive/ext.php" "[FORUM_EXT]/rmcgirr83\\topfive/ext.php"
--- "[ORIGINAL]/rmcgirr83\\topfive/ext.php"
+++ "[FORUM_EXT]/rmcgirr83\\topfive/ext.php"
@@ -23,6 +23,6 @@ class ext extends \phpbb\extension\base
 	public function is_enableable()
 	{
 		$config = $this->container->get('config');
-		return version_compare($config['version'], '3.3', '>=');
+		return version_compare($config['version'], '3.1.2', '>=');
 	}
 }
diff --git "[ORIGINAL]/rmcgirr83\\topfive/language/en/acp/info_acp_topfive.php" "[FORUM_EXT]/rmcgirr83\\topfive/language/en/acp/info_acp_topfive.php"
--- "[ORIGINAL]/rmcgirr83\\topfive/language/en/acp/info_acp_topfive.php"
+++ "[FORUM_EXT]/rmcgirr83\\topfive/language/en/acp/info_acp_topfive.php"
@@ -16,11 +16,32 @@ if (!defined('IN_PHPBB'))
 
 if (empty($lang) || !is_array($lang))
 {
-	$lang = [];
+	$lang = array();
 }
 
-$lang = array_merge($lang, [
+$lang = array_merge($lang, array(
 	// ACP
 	'TF_ACP'		=> 'Top Five Extension',
+	'TF_ACTIVE'		=> 'Enabled',
+	'TF_TITLE'		=> 'Top Five Extension Settings',
+	'TF_VERSION'	=> 'Top Five Version',
+	'TOPFIVE_MOD'	=> 'Top Five',
 	'TF_CONFIG'		=> 'Settings',
-]);
+	'TF_SELECT'		=> 'Top Five',
+	'TF_SAVED'		=> 'Changes Saved',
+	'TF_HOWMANY'	=> 'How Many',
+	'TF_HOWMANY_EXPLAIN'	=> 'How many would you like to display...minimum required is 5, maximum is 100',
+	'TF_IGNORE_USERS'		=> 'Ignore Inactive Users',
+	'TF_IGNORE_USERS_EXPLAIN'	=> 'Will exclude inactive users from the display in top posters and newest users',
+	'TF_IGNORE_FOUNDER'		=> 'Ignore Founder(s)',
+	'TF_IGNORE_FOUNDER_EXPLAIN'	=> 'Will exclude founders from the display in top posters and newest users',
+	'TF_LOCATION'	=> 'Location on forum',
+	'TF_LOCATION_EXPLAIN'	=> 'Where do you want the mod to display on the index page',
+	'TF_SHOW_ADMINS_MODS'	=> 'Include Admins and Mods',
+	'TF_SHOW_ADMINS_MODS_EXPLAIN'	=> 'Will display admins and mods in top posters',
+	'TOO_SMALL_TOP_FIVE_HOW_MANY'	=> 'The number to display value is too small.',
+	'TOO_LARGE_TOP_FIVE_HOW_MANY'	=> 'The number to display value is too large.',
+	'TOP_OF_FORUM'	=> 'Top of Forum',
+	'BOTTOM_OF_FORUM'	=> 'Bottom of Forum',
+
+));
diff --git "[ORIGINAL]/rmcgirr83\\topfive/language/en/acp_topfive.php" "[ORIGINAL]/rmcgirr83\\topfive/language/en/acp_topfive.php"
deleted file mode 100644
--- "[ORIGINAL]/rmcgirr83\\topfive/language/en/acp_topfive.php"
+++ /dev/null
@@ -1,56 +0,0 @@
-<?php
-/**
-*
-* topfive [English]
-*
-* @package language Top Five
-* @copyright (c) 2014 RMcGirr83
-* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
-*
-*/
-
-if (!defined('IN_PHPBB'))
-{
-	exit;
-}
-
-if (empty($lang) || !is_array($lang))
-{
-	$lang = [];
-}
-
-$lang = array_merge($lang, [
-	'TF_ACTIVE'		=> 'Enabled',
-	'TF_AVATARS'	=> 'Avatars',
-	'TF_AVATARS_EXPLAIN'	=> 'Choose yes or no to display users avatars',
-	'TF_TITLE'		=> 'Top Five Extension Settings',
-	'TOPFIVE_MOD'	=> 'Top Five',
-	'TF_CONFIG'		=> 'Settings',
-	'TF_SAVED'		=> 'Changes Saved',
-	'TF_HOWMANY'	=> 'How Many',
-	'TF_EXCLUDED'	=> 'Excluded forums',
-	'TF_EXCLUDED_EXPLAIN'	=> 'Use CTRL/CMD and mouse click to choose or unchoose multiple forums<br><em>If you don&#39;t want to exclude a forum, either don&#39;t select any or unselect the ones you have chosen</em>',
-
-	'TF_HOWMANY_EXPLAIN'	=> 'How many would you like to display... minimum required is 5, maximum is 100',
-	'TF_IGNORE_USERS'		=> 'Ignore Inactive Users',
-	'TF_IGNORE_USERS_EXPLAIN'	=> 'Will exclude inactive users from the display in top posters and newest users',
-	'TF_IGNORE_FOUNDER'		=> 'Ignore Founder(s)',
-	'TF_IGNORE_FOUNDER_EXPLAIN'	=> 'Will exclude founders from the display in top posters and newest users',
-	'TF_LOCATION'	=> 'Location on forum',
-	'TF_LOCATION_EXPLAIN'	=> 'Where do you want the extension to display on the forum.<br><i>If you choose top or bottom of entire forum, the extension will only display on those pages that are considered content pages.</i>',
-	'TF_SHOW_ADMINS_MODS'	=> 'Include Admins and Mods',
-	'TF_SHOW_ADMINS_MODS_EXPLAIN'	=> 'Will display admins and mods in top posters',
-	'TOO_SMALL_TOP_FIVE_HOW_MANY'	=> 'The number to display value is too small.',
-	'TOO_LARGE_TOP_FIVE_HOW_MANY'	=> 'The number to display value is too large.',
-	'TOP_OF_FORUM'	=> 'Top of index page',
-	'BOTTOM_OF_FORUM'	=> 'Bottom of index page',
-	'TOP_OF_ENTIRE_FORUM'	=> 'Top of entire forum',
-	'BOTTOM_OF_ENTIRE_FORUM'	=> 'Bottom of entire forum',
-	//Donation
-	'PAYPAL_IMAGE_URL'          => 'https://www.paypalobjects.com/webstatic/en_US/i/btn/png/silver-pill-paypal-26px.png',
-	'PAYPAL_ALT'                => 'Donate using PayPal',
-	'BUY_ME_A_BEER_URL'         => 'https://paypal.me/RMcGirr83',
-	'BUY_ME_A_BEER'				=> 'Buy me a beer for creating this extension',
-	'BUY_ME_A_BEER_SHORT'		=> 'Make a donation for this extension',
-	'BUY_ME_A_BEER_EXPLAIN'		=> 'This extension is completely free. It is a project that I spend my time on for the enjoyment and use of the phpBB community. If you enjoy using this extension, or if it has benefited your forum, please consider <a href="https://paypal.me/RMcGirr83" target="_blank" rel="noreferrer noopener">buying me a beer</a>. It would be greatly appreciated. <i class="fa fa-smile-o" style="color:green;font-size:1.5em;" aria-hidden="true"></i>',
-]);
diff --git "[ORIGINAL]/rmcgirr83\\topfive/language/en/topfive.php" "[FORUM_EXT]/rmcgirr83\\topfive/language/en/topfive.php"
--- "[ORIGINAL]/rmcgirr83\\topfive/language/en/topfive.php"
+++ "[FORUM_EXT]/rmcgirr83\\topfive/language/en/topfive.php"
@@ -17,7 +17,7 @@ if (!defined('IN_PHPBB'))
 
 if (empty($lang) || !is_array($lang))
 {
-	$lang = [];
+	$lang = array();
 }
 
 // DEVELOPERS PLEASE NOTE
@@ -32,11 +32,12 @@ if (empty($lang) || !is_array($lang))
 // equally where a string contains only two placeholders which are used to wrap text
 // in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
 
-$lang = array_merge($lang, [
+$lang = array_merge($lang, array(
+	'TOP_FIVE'			=> 'Top Activity',
 	'NEWEST_TOPICS'		=> 'Newest Posts',
 	'NO_TOPIC_EXIST'	=> 'No posts exist for viewing',
 	'TOP_FIVE_ACTIVE'	=> 'Top Active Users',
 	'TOP_FIVE_NEWEST'	=> 'Newest Users',
-	'BY'                => 'by&nbsp;',
-	'USER_LASTPOST_TIME'	=> 'Last Post: %s',
-]);
+	'IN'                => 'In',
+	'BY'                => 'by:',
+));
diff --git "[ORIGINAL]/rmcgirr83\\topfive/migrations/top_five_v111.php" "[ORIGINAL]/rmcgirr83\\topfive/migrations/top_five_v111.php"
deleted file mode 100644
--- "[ORIGINAL]/rmcgirr83\\topfive/migrations/top_five_v111.php"
+++ /dev/null
@@ -1,25 +0,0 @@
-<?php
-/**
-*
-* @package Top Five
-* @copyright (c) 2015 Rich Mcgirr (RMcGirr83)
-* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
-*
-*/
-
-namespace rmcgirr83\topfive\migrations;
-
-class top_five_v111 extends \phpbb\db\migration\migration
-{
-	static public function depends_on()
-	{
-		return array('\rmcgirr83\topfive\migrations\top_five_v14');
-	}
-
-	public function update_data()
-	{
-		return array(
-			array('config.add', array('top_five_avatars', 0)),
-		);
-	}
-}
diff --git "[ORIGINAL]/rmcgirr83\\topfive/migrations/top_five_v123.php" "[ORIGINAL]/rmcgirr83\\topfive/migrations/top_five_v123.php"
deleted file mode 100644
--- "[ORIGINAL]/rmcgirr83\\topfive/migrations/top_five_v123.php"
+++ /dev/null
@@ -1,34 +0,0 @@
-<?php
-/**
-*
-* @package Top Five
-* @copyright (c) 2015 Rich Mcgirr (RMcGirr83)
-* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
-*
-*/
-
-namespace rmcgirr83\topfive\migrations;
-
-class top_five_v123 extends \phpbb\db\migration\migration
-{
-	static public function depends_on()
-	{
-		return ['\rmcgirr83\topfive\migrations\top_five_v111'];
-	}
-
-	public function update_data()
-	{
-		return [
-			['module.remove', ['acp', false, 'TF_CONFIG']],
-			['module.add', [
-				'acp',
-				'TF_ACP',
-				[
-					'module_basename'	=> '\rmcgirr83\topfive\acp\topfive_module',
-					'auth'				=> 'ext_rmcgirr83/topfive && acl_a_extensions',
-					'modes'				=> ['settings'],
-				],
-			]],
-		];
-	}
-}
diff --git "[ORIGINAL]/rmcgirr83\\topfive/migrations/top_five_v125.php" "[ORIGINAL]/rmcgirr83\\topfive/migrations/top_five_v125.php"
deleted file mode 100644
--- "[ORIGINAL]/rmcgirr83\\topfive/migrations/top_five_v125.php"
+++ /dev/null
@@ -1,25 +0,0 @@
-<?php
-/**
-*
-* @package Top Five
-* @copyright (c) 2015 Rich Mcgirr (RMcGirr83)
-* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
-*
-*/
-
-namespace rmcgirr83\topfive\migrations;
-
-class top_five_v125 extends \phpbb\db\migration\migration
-{
-	static public function depends_on()
-	{
-		return ['\rmcgirr83\topfive\migrations\top_five_v123'];
-	}
-
-	public function update_data()
-	{
-		return [
-			['config.update', ['top_five_active', 1]],
-		];
-	}
-}
diff --git "[ORIGINAL]/rmcgirr83\\topfive/migrations/top_five_v126.php" "[ORIGINAL]/rmcgirr83\\topfive/migrations/top_five_v126.php"
deleted file mode 100644
--- "[ORIGINAL]/rmcgirr83\\topfive/migrations/top_five_v126.php"
+++ /dev/null
@@ -1,25 +0,0 @@
-<?php
-/**
-*
-* @package Top Five
-* @copyright (c) 2024 Rich Mcgirr (RMcGirr83)
-* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
-*
-*/
-
-namespace rmcgirr83\topfive\migrations;
-
-class top_five_v126 extends \phpbb\db\migration\migration
-{
-	static public function depends_on()
-	{
-		return ['\rmcgirr83\topfive\migrations\top_five_v125'];
-	}
-
-	public function update_data()
-	{
-		return [
-			['config.remove', ['top_five_active']],
-		];
-	}
-}
diff --git "[ORIGINAL]/rmcgirr83\\topfive/migrations/top_five_v13.php" "[ORIGINAL]/rmcgirr83\\topfive/migrations/top_five_v13.php"
deleted file mode 100644
--- "[ORIGINAL]/rmcgirr83\\topfive/migrations/top_five_v13.php"
+++ /dev/null
@@ -1,31 +0,0 @@
-<?php
-/**
-*
-* @package Top Five
-* @copyright (c) 2015 RMcGirr83
-* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
-*
-*/
-
-namespace rmcgirr83\topfive\migrations;
-
-class top_five_v13 extends \phpbb\db\migration\migration
-{
-	public function effectively_installed()
-	{
-		return isset($this->config['top_five_version']) && version_compare($this->config['top_five_version'], '1.0.3', '>=');
-	}
-
-	static public function depends_on()
-	{
-		return array('\rmcgirr83\topfive\migrations\top_five_v12');
-	}
-
-	public function update_data()
-	{
-		return array(
-			array('config.update', array('top_five_version', '1.0.3')),
-			array('config.add', array('top_five_excluded', 0)),
-		);
-	}
-}
diff --git "[ORIGINAL]/rmcgirr83\\topfive/migrations/top_five_v14.php" "[ORIGINAL]/rmcgirr83\\topfive/migrations/top_five_v14.php"
deleted file mode 100644
--- "[ORIGINAL]/rmcgirr83\\topfive/migrations/top_five_v14.php"
+++ /dev/null
@@ -1,25 +0,0 @@
-<?php
-/**
-*
-* @package Top Five
-* @copyright (c) 2015 Rich Mcgirr (RMcGirr83)
-* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
-*
-*/
-
-namespace rmcgirr83\topfive\migrations;
-
-class top_five_v14 extends \phpbb\db\migration\migration
-{
-	static public function depends_on()
-	{
-		return array('\rmcgirr83\topfive\migrations\top_five_v13');
-	}
-
-	public function update_data()
-	{
-		return array(
-			array('config.remove', array('top_five_version')),
-		);
-	}
-}
diff --git "[FORUM_EXT]/rmcgirr83\\topfive/styles/BBOOTS/template/event/recent_topics_body.html" "[FORUM_EXT]/rmcgirr83\\topfive/styles/BBOOTS/template/event/recent_topics_body.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/rmcgirr83\\topfive/styles/BBOOTS/template/event/recent_topics_body.html"
@@ -0,0 +1,3 @@
+<!-- IF S_TOPFIVE and not S_TOPFIVE_LOCATION -->
+	<!-- INCLUDE topfive_body.html -->
+<!-- ENDIF -->
diff --git "[FORUM_EXT]/rmcgirr83\\topfive/styles/BBOOTS/template/topfive_body.html" "[FORUM_EXT]/rmcgirr83\\topfive/styles/BBOOTS/template/topfive_body.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/rmcgirr83\\topfive/styles/BBOOTS/template/topfive_body.html"
@@ -0,0 +1,10 @@
+<!-- BEGIN top_five_topic -->
+<div class="recent-topic text-overflow">
+	<a href="#" class="blogImage" title="">{top_five_topic.TOP5_AVATAR}</a>
+	<!-- IF top_five_topic.NO_TOPIC_TITLE-->{top_five_topic.NO_TOPIC_TITLE}<!-- ELSE -->
+	<a href="{top_five_topic.U_TOPIC}" title="{top_five_topic.TOPIC_TITLE}"><i class="fa fa-mail-forward text-muted"></i> {top_five_topic.TOPIC_TITLE}</a>
+	<p><i class="fa fa-user"></i> {top_five_topic.USERNAME_FULL}</p>
+	<p><i class="fa fa-clock-o"></i> {top_five_topic.LAST_TOPIC_TIME}</p>
+	 <!-- ENDIF -->
+</div>
+<!-- END top_five_topic -->
\ No newline at end of file
diff --git "[ORIGINAL]/rmcgirr83\\topfive/styles/prosilver/template/event/index_body_forumlist_body_after.html" "[ORIGINAL]/rmcgirr83\\topfive/styles/prosilver/template/event/index_body_forumlist_body_after.html"
deleted file mode 100644
--- "[ORIGINAL]/rmcgirr83\\topfive/styles/prosilver/template/event/index_body_forumlist_body_after.html"
+++ /dev/null
@@ -1,3 +0,0 @@
-{% if S_TOPFIVE_LOCATION == 1 %}
-	{% INCLUDE '@rmcgirr83_topfive/topfive_body.html' %}
-{% endif %}
diff --git "[ORIGINAL]/rmcgirr83\\topfive/styles/prosilver/template/event/index_body_markforums_after.html" "[ORIGINAL]/rmcgirr83\\topfive/styles/prosilver/template/event/index_body_markforums_after.html"
deleted file mode 100644
--- "[ORIGINAL]/rmcgirr83\\topfive/styles/prosilver/template/event/index_body_markforums_after.html"
+++ /dev/null
@@ -1,3 +0,0 @@
-{% if S_TOPFIVE_LOCATION == 0 %}
-	{% INCLUDE '@rmcgirr83_topfive/topfive_body.html' %}
-{% endif %}
diff --git "[ORIGINAL]/rmcgirr83\\topfive/styles/prosilver/template/event/overall_footer_content_after.html" "[ORIGINAL]/rmcgirr83\\topfive/styles/prosilver/template/event/overall_footer_content_after.html"
deleted file mode 100644
--- "[ORIGINAL]/rmcgirr83\\topfive/styles/prosilver/template/event/overall_footer_content_after.html"
+++ /dev/null
@@ -1,3 +0,0 @@
-{% if S_TOPFIVE_LOCATION == 3 %}
-	{% INCLUDE '@rmcgirr83_topfive/topfive_body.html' %}
-{% endif %}
diff --git "[ORIGINAL]/rmcgirr83\\topfive/styles/prosilver/template/event/overall_header_content_before.html" "[ORIGINAL]/rmcgirr83\\topfive/styles/prosilver/template/event/overall_header_content_before.html"
deleted file mode 100644
--- "[ORIGINAL]/rmcgirr83\\topfive/styles/prosilver/template/event/overall_header_content_before.html"
+++ /dev/null
@@ -1,3 +0,0 @@
-{% if S_TOPFIVE_LOCATION == 2 %}
-	{% INCLUDE '@rmcgirr83_topfive/topfive_body.html' %}
-{% endif %}
diff --git "[ORIGINAL]/rmcgirr83\\topfive/styles/prosilver/template/event/overall_header_head_append.html" "[ORIGINAL]/rmcgirr83\\topfive/styles/prosilver/template/event/overall_header_head_append.html"
deleted file mode 100644
--- "[ORIGINAL]/rmcgirr83\\topfive/styles/prosilver/template/event/overall_header_head_append.html"
+++ /dev/null
@@ -1 +0,0 @@
-{% INCLUDECSS '@rmcgirr83_topfive/topfive.css' %}
\ No newline at end of file
diff --git "[ORIGINAL]/rmcgirr83\\topfive/styles/prosilver/template/topfive_body.html" "[ORIGINAL]/rmcgirr83\\topfive/styles/prosilver/template/topfive_body.html"
deleted file mode 100644
--- "[ORIGINAL]/rmcgirr83\\topfive/styles/prosilver/template/topfive_body.html"
+++ /dev/null
@@ -1,57 +0,0 @@
-<a class="category{% if S_TOPFIVE_HIDDEN %} hidden-category{% endif %}" style="display: none; height: 0"></a>
-<div class="forabg" id="top_five">
-	<div class="inner">
-	<ul class="topiclist">
-		<li class="header">
-			<dl class="row-item">
-				<dt><div class="list-inner">{{ lang('NEWEST_TOPICS') }}</div></dt>
-				<dd class="topics tf-active-header">{{ lang('TOP_FIVE_ACTIVE') }}</dd>
-				<dd class="lastpost"><span>{{ lang('TOP_FIVE_NEWEST') }}</span></dd>
-			</dl>
-			{% if U_TOPFIVE_COLLAPSE_URL %}<a href="{{ U_TOPFIVE_COLLAPSE_URL }}" class="collapse-btn collapse-{% if S_TOPFIVE_HIDDEN %}show{% else %}hide{% endif %}" data-hidden="{{ S_TOPFIVE_HIDDEN }}" data-ajax="phpbb_collapse" data-overlay="true" title="{{ lang('COLLAPSIBLE_CATEGORIES_TITLE') }}" style="display: none; line-height: 0;"></a>{% endif %}
-		</li>
-	</ul>
-	<ul class="topiclist forums">
-		<li class="row">
-			<dl>
-				<dt>
-					<div class="list-inner">
-						<ul>
-							{% for top_five_topic in loops.top_five_topic %}
-								<li class="top_five">
-									{% if top_five_topic.NO_TOPIC_TITLE%}
-										{{ top_five_topic.NO_TOPIC_TITLE }}
-									{% else %}
-										<a href="{{ top_five_topic.U_TOPIC }}" class="topictitle subforum{% if top_five_topic.S_UNREAD %} unread{% else %} read{% endif %}">
-											<i class="icon fa-file-o fa-fw {% if top_five_topic.S_UNREAD %} icon-red{% else %} icon-blue{% endif %} icon-md" aria-hidden="true"></i>
-											{{ top_five_topic.TOPIC_TITLE }}</a><span class="meta">{{ top_five_topic.USERNAME_FULL }} {% if top_five_topic.USER_FLAG %} {{ top_five_topic.USER_FLAG }} {% endif %}&raquo; {{ top_five_topic.LAST_TOPIC_TIME }} &raquo; {{ lang('IN') }}&nbsp;<a href="{{ top_five_topic.U_FORUM }}">{{ top_five_topic.FORUM_NAME }}</a></span>
-										{% EVENT rmcgirr83_top_five_topiclist_row_append %}
-									{% endif %}
-								</li>
-							{% endfor %}
-						</ul>
-					</div>
-				</dt>
-				<dd class="topics tf-most-active">
-					<ul>
-						{% for top_five_active in loops.top_five_active %}
-							<li>
-								<span class="meta">{{ top_five_active.USERNAME_FULL }} {% if top_five_active.USER_FLAG %} {{ top_five_active.USER_FLAG }} {% endif %}<span><br>&nbsp;&nbsp;{{ lang('POSTS') }}{{ lang('COLON') }} <a href="{{ top_five_active.S_SEARCH_ACTION }}" title="{{ top_five_active.USER_LASTPOST_TIME }}">{{ top_five_active.POSTS }}</a></span></span>
-							</li>
-						{% endfor %}
-					</ul>
-				</dd>
-				<dd class="lastpost tf-newest"><span>
-					<ul>
-						{% for top_five_newest in loops.top_five_newest %}
-							<li>
-								<span class="meta">{{ top_five_newest.USERNAME_FULL }}{% if top_five_newest.USER_FLAG %} {{ top_five_newest.USER_FLAG }} {% endif %}<span><br>&nbsp;&nbsp;{{ lang('JOINED') }}{{ lang('COLON') }} {{ top_five_newest.REG_DATE }}</span></span>
-							</li>
-						{% endfor %}
-					</ul>
-				</span></dd>
-			</dl>
-		</li>
-	</ul>
-	</div>
-</div>
diff --git "[ORIGINAL]/rmcgirr83\\topfive/styles/prosilver/theme/topfive.css" "[ORIGINAL]/rmcgirr83\\topfive/styles/prosilver/theme/topfive.css"
deleted file mode 100644
--- "[ORIGINAL]/rmcgirr83\\topfive/styles/prosilver/theme/topfive.css"
+++ /dev/null
@@ -1,81 +0,0 @@
-dd.tf-most-active {
-	font-size: 1.2em;
-	line-height: 1.2em;
-	text-align: left;
-	width: 185px;
-}
-
-.rtl dd.tf-most-active  {
-	text-align: right;
-}
-
-dd.tf-newest {
-	font-size: 1.2em;	
-	line-height: 1.2em;
-	text-align: left;
-}
-
-.rtl dd.tf-newest {
-	text-align: right;
-}
-
-dd.tf-active-header {
-	width: 185px;
-	text-align:left;
-}
-
-.rtl dd.tf-active-header {
-	text-align:right;
-}
-
-#top_five ul {
-	list-style-type: none;
-}
-
-#top_five li {
-	padding: 2px 0;
-}
-
-#top_five li:first-child {
-	padding-top: 0;
-}
-
-#top_five li:last-child {
-	padding-bottom: 0;
-}
-
-#top_five .meta {
-	display: block;
-	padding-left: 8px;
-}
-
-.rtl #top_five {
-	text-align: right;
-}
-
-.rtl #top_five .meta {
-	padding-left: 0;
-	padding-right: 8px;
-}
-
-#top_five ul.topiclist li.row a.subforum {
-	white-space: normal;
-}
-
-@media only screen and (max-width: 970px) {
-	#top_five {
-		display: none;
-	}
-}
-
-/* Fixes avatar aspect-ratio */
-#top_five .topfive-avatar img { 
-	max-height: 20px;
-    vertical-align: middle;
-    width: auto;
-}
-
-/* fixes national flags position */
-.top_five .flag_image {
-  vertical-align: middle;
-}
\ No newline at end of file
diff --git "[ORIGINAL]/rmcgirr83\\topfive/styles/scaffoldBB/template/event/index_body_forumlist_body_after.html" "[ORIGINAL]/rmcgirr83\\topfive/styles/scaffoldBB/template/event/index_body_forumlist_body_after.html"
deleted file mode 100644
--- "[ORIGINAL]/rmcgirr83\\topfive/styles/scaffoldBB/template/event/index_body_forumlist_body_after.html"
+++ /dev/null
@@ -1,3 +0,0 @@
-{% if S_TOPFIVE_LOCATION == 1 %}
-	{% INCLUDE '@rmcgirr83_topfive/topfive_body.html' %}
-{% endif %}
diff --git "[ORIGINAL]/rmcgirr83\\topfive/styles/scaffoldBB/template/event/index_body_markforums_after.html" "[ORIGINAL]/rmcgirr83\\topfive/styles/scaffoldBB/template/event/index_body_markforums_after.html"
deleted file mode 100644
--- "[ORIGINAL]/rmcgirr83\\topfive/styles/scaffoldBB/template/event/index_body_markforums_after.html"
+++ /dev/null
@@ -1,3 +0,0 @@
-{% if S_TOPFIVE_LOCATION == 0 %}
-	{% INCLUDE '@rmcgirr83_topfive/topfive_body.html' %}
-{% endif %}
diff --git "[ORIGINAL]/rmcgirr83\\topfive/styles/scaffoldBB/template/event/overall_footer_page_body_after.html" "[ORIGINAL]/rmcgirr83\\topfive/styles/scaffoldBB/template/event/overall_footer_page_body_after.html"
deleted file mode 100644
--- "[ORIGINAL]/rmcgirr83\\topfive/styles/scaffoldBB/template/event/overall_footer_page_body_after.html"
+++ /dev/null
@@ -1,3 +0,0 @@
-{% if S_TOPFIVE_LOCATION == 3 %}
-	{% INCLUDE '@rmcgirr83_topfive/topfive_body.html' %}
-{% endif %}
diff --git "[ORIGINAL]/rmcgirr83\\topfive/styles/scaffoldBB/template/event/overall_header_content_before.html" "[ORIGINAL]/rmcgirr83\\topfive/styles/scaffoldBB/template/event/overall_header_content_before.html"
deleted file mode 100644
--- "[ORIGINAL]/rmcgirr83\\topfive/styles/scaffoldBB/template/event/overall_header_content_before.html"
+++ /dev/null
@@ -1,3 +0,0 @@
-{% if S_TOPFIVE_LOCATION == 2 %}
-	{% INCLUDE '@rmcgirr83_topfive/topfive_body.html' %}
-{% endif %}
diff --git "[ORIGINAL]/rmcgirr83\\topfive/styles/scaffoldBB/template/event/overall_header_head_append.html" "[ORIGINAL]/rmcgirr83\\topfive/styles/scaffoldBB/template/event/overall_header_head_append.html"
deleted file mode 100644
--- "[ORIGINAL]/rmcgirr83\\topfive/styles/scaffoldBB/template/event/overall_header_head_append.html"
+++ /dev/null
@@ -1,3 +0,0 @@
-{% if S_TOPFIVE %}
-	{% INCLUDECSS '@rmcgirr83_topfive/topfive.css' %}
-{% endif %}
\ No newline at end of file
diff --git "[ORIGINAL]/rmcgirr83\\topfive/styles/scaffoldBB/template/topfive_body.html" "[ORIGINAL]/rmcgirr83\\topfive/styles/scaffoldBB/template/topfive_body.html"
deleted file mode 100644
--- "[ORIGINAL]/rmcgirr83\\topfive/styles/scaffoldBB/template/topfive_body.html"
+++ /dev/null
@@ -1,45 +0,0 @@
-<a class="category{% if S_TOPFIVE_HIDDEN %} hidden-category{% endif %}" style="display: none; height: 0"></a>
-<div class="bg-gradient bg-primary forabg mb-3 rounded-3 py-1 px-2 d-none d-md-block {% if S_TOPFIVE_LOCATION == 3 %}mx-md-3{% endif %}" id="top_five">
-	<ul class="header row gx-0 list-unstyled my-1">
-		<li class="col-7 fw-bold text-uppercase text-white text-decoration-none"><div class="list-inner">{{ lang('NEWEST_TOPICS') }}</div></li>
-		<li class="topics col-2 text-white tf-active-header text-uppercase">{{ lang('TOP_FIVE_ACTIVE') }}</li>
-		<li class="lastpost col-3 text-white text-uppercase"><span>{{ lang('TOP_FIVE_NEWEST') }}</span></li>
-	</ul>
-	{% if U_TOPFIVE_COLLAPSE_URL %}<a href="{{ U_TOPFIVE_COLLAPSE_URL }}" class="collapse-btn " data-hidden="{{ S_TOPFIVE_HIDDEN }}" data-ajax="phpbb_collapse" data-overlay="true" title="{{ lang('COLLAPSIBLE_CATEGORIES_TITLE') }}" style="display: none; line-height: 0;"></a>{% endif %}
-	<ul class="bg-body topiclist forums list-unstyled mb-1 row gx-0 p-2">
-		<li class="col-7">
-			<ul class="list-unstyled">
-				{% for top_five_topic in loops.top_five_topic %}
-					<li>
-						{% if top_five_topic.NO_TOPIC_TITLE%}
-							{{ top_five_topic.NO_TOPIC_TITLE }}
-						{% else %}
-							<a href="{{ top_five_topic.U_TOPIC }}" class="text-decoration-none topictitle subforum{% if top_five_topic.S_UNREAD %} unread{% else %} read{% endif %}">
-								<i class="icon fa fa-file-o fa-fw {% if top_five_topic.S_UNREAD %} icon-red{% else %} icon-blue{% endif %} icon-md" aria-hidden="true"></i>
-								{{ top_five_topic.TOPIC_TITLE }}</a><span class="meta d-block ps-2">{{ top_five_topic.USERNAME_FULL }} &raquo; {{ top_five_topic.LAST_TOPIC_TIME }} &raquo; {{ lang('IN') }}&nbsp;<a class="text-decoration-none" href="{{ top_five_topic.U_FORUM }}">{{ top_five_topic.FORUM_NAME }}</a></span>
-							{% EVENT rmcgirr83_top_five_topiclist_row_append %}
-						{% endif %}
-					</li>
-				{% endfor %}
-			</ul>
-		</li>
-		<li class="col-2 topics tf-most-active border-start border-end">
-			<ul class="list-unstyled">
-				{% for top_five_active in loops.top_five_active %}
-					<li>
-						<span class="meta d-block ps-2">{{ top_five_active.USERNAME_FULL }}<span><br />&nbsp;&nbsp;{{ lang('POSTS') }}{{ lang('COLON') }} <a class="text-decoration-none" href="{{ top_five_active.S_SEARCH_ACTION }}">{{ top_five_active.POSTS }}</a></span></span>
-					</li>
-				{% endfor %}
-			</ul>
-		</li>
-		<li class="col-3 lastpost tf-newest">
-			<ul class="list-unstyled">
-				{% for top_five_newest in loops.top_five_newest %}
-					<li>
-						<span class="meta d-block ps-2">{{ top_five_newest.USERNAME_FULL }}<span><br />&nbsp;&nbsp;{{ lang('JOINED') }}{{ lang('COLON') }} {{ top_five_newest.REG_DATE }}</span></span>
-					</li>
-				{% endfor %}
-			</ul>
-		</li>
-	</ul>
-</div>
diff --git "[ORIGINAL]/rmcgirr83\\topfive/styles/scaffoldBB/theme/topfive.css" "[ORIGINAL]/rmcgirr83\\topfive/styles/scaffoldBB/theme/topfive.css"
deleted file mode 100644
--- "[ORIGINAL]/rmcgirr83\\topfive/styles/scaffoldBB/theme/topfive.css"
+++ /dev/null
@@ -1,7 +0,0 @@
-
-/* Fixes avatar aspect-ratio */
-#top_five .topfive-avatar img { 
-	max-height: 20px;
-    vertical-align: middle;
-    width: auto;
-}
\ No newline at end of file
```
