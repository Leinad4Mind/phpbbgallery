Existem diferencas reais no codigo ou texto. Diferencas de formatacao (espacos, tabs) foram ignoradas abaixo.

```diff
diff --git "[ORIGINAL]/vse\\similartopics/CHANGELOG.md" "[FORUM_EXT]/vse\\similartopics/CHANGELOG.md"
--- "[ORIGINAL]/vse\\similartopics/CHANGELOG.md"
+++ "[FORUM_EXT]/vse\\similartopics/CHANGELOG.md"
@@ -1,18 +1,10 @@
 ## Changelog
 
-### 1.7.0 - 2025-12-16
-
-- NEW FEATURE: Dynamically show similar topics to users as they title their new posts.
-- IMPROVEMENT: Support for MSSQL, SQLite3 and Oracle databases added.
-- IMPROVEMENT: Added stop-word filtering for Postgres databases using the 'simple' dictionary.
-- Added missing stop-word filters (AI-translated) for Hebrew, Persian, Japanese, Swedish and Turkish languages.
-- Fixed and optimized lots of code when processing similar topics.
-
 ### 1.6.0 - 2022-12-17
 
 - Removed support for phpBB 3.1.x.
 - Removed forum "f=" parameters from URLs.
-- Optimized JavaScript and other coding updates.
+- Optimized Javascript and other coding updates.
 - Support added for ScaffoldBB style.
 
 ### 1.5.4 - 2020-12-01
@@ -20,11 +12,11 @@
 - Fix for Postgresql databases where titles with single quotes would fatally error.
 - Enabled AJAX interactions when saving settings in the ACP.
 - Re-wrote the search period explanation in the ACP settings.
-- Switched to using the phpBB finder to locate foreign language ignore words files.
+- Switched to using phpBB finder to locate foreign language ignore words files.
 
 ### 1.5.3 - 2020-01-10
 
-- Compatibility issues with Prosilver styles are addressed.
+- Compatibility issues with Prosilver styles addressed.
 - Installation errors on phpBB 3.3.x will be reported to the user.
 
 ### 1.5.2 - 2019-06-26
@@ -35,18 +27,18 @@
 
 ### 1.5.1 - 2018-06-01
 
-- Fixed an issue where PHP using European decimal notation (comma instead of a period) could cause an SQL error.
-- Minor code fixes based on the phpBB Extension team validation report.
+- Fixed an issue where PHP using European decimal notation (comma instead of period) could cause an SQL error.
+- Minor code fixes based on phpBB Extension team validation report.
 
 ### 1.5.0 - 2018-03-14
 
 - Added support for forums using PostgreSQL databases (with thanks to hubaishan).
 - Fixed a layout bug with the pagination buttons introduced in phpBB 3.2.2.
-- Fixed a potential SQL error bug when installing.
+- Fixed potential SQL error bug when installing.
 
 ### 1.4.3 - 2018-01-03
 
-- Added a new setting: Search Sensitivity. Allows users to adjust the weighting of similar topics matches. This was added because InnoDB, which is now supported, weights results differently than MyISAM. This will allow users with InnoDB tables to improve their similar topics results by lowering the weighting/sensitivity.
+- Added a new setting: Search Sensitivity. Allows users to adjust the weighting of similar topics matches. This was added because InnoDB which is now supported, weights results differently than MyISAM. This will allow users with InnoDB tables to improve their similar topics results by lowering the weighting/sensitivity.
 - Converted all template syntax to Twig format.
 
 ### 1.4.2 - 2017-03-18
diff --git "[ORIGINAL]/vse\\similartopics/acp/controller/similar_topics_admin.php" "[FORUM_EXT]/vse\\similartopics/acp/controller/similar_topics_admin.php"
--- "[ORIGINAL]/vse\\similartopics/acp/controller/similar_topics_admin.php"
+++ "[FORUM_EXT]/vse\\similartopics/acp/controller/similar_topics_admin.php"
@@ -157,7 +157,6 @@ class similar_topics_admin
 
 			// Set basic config settings
 			$this->config->set('similar_topics', $this->request->variable('pst_enable', 0));
-			$this->config->set('similar_topics_dynamic', $this->request->variable('pst_dynamic', 0));
 			$this->config->set('similar_topics_limit', abs($this->request->variable('pst_limit', 0))); // use abs for positive values only
 			$this->config->set('similar_topics_cache', abs($this->request->variable('pst_cache', 0))); // use abs for positive values only
 			$this->config_text_set('similar_topics_words', $this->request->variable('pst_words', '', true));
@@ -209,22 +208,20 @@ class similar_topics_admin
 
 		$this->template->assign_vars(array(
 			'S_PST_ENABLE'    => $this->isset_or_default($this->config['similar_topics'], false),
-			'S_PST_DYNAMIC'   => $this->isset_or_default($this->config['similar_topics_dynamic'], false),
 			'PST_LIMIT'       => $this->isset_or_default($this->config['similar_topics_limit'], ''),
 			'PST_CACHE'       => $this->isset_or_default($this->config['similar_topics_cache'], ''),
 			'PST_SENSE'       => $this->isset_or_default($this->config['similar_topics_sense'], ''),
 			'PST_WORDS'       => $this->isset_or_default($this->config_text_get('similar_topics_words'), ''),
 			'PST_TIME'        => $this->get_pst_time($this->config['similar_topics_time'], $this->config['similar_topics_type']),
-			'PST_SENSITIVITY' => $this->similartopics && $this->similartopics->get_engine() === 'innodb' ? 1 : 5,
 			'S_PST_NO_COMPAT' => $this->similartopics === null || !$this->similartopics->is_fulltext('topic_title'),
 			'U_ACTION'        => $this->u_action,
 		));
 
 		// If postgresql, we need to make an options list of text search names
-		if ($this->similartopics instanceof \vse\similartopics\driver\postgres)
+		if ($this->similartopics && $this->similartopics->get_type() === 'postgres')
 		{
 			$this->language->add_lang('acp/search');
-			foreach ($this->similartopics->get_cfg_name_list() as $row)
+			foreach ($this->get_cfgname_list() as $row)
 			{
 				$this->template->assign_block_vars('postgres_ts_names', array(
 					'NAME'       => $row['ts_name'],
@@ -269,8 +266,6 @@ class similar_topics_admin
 				WHERE forum_id = $forum_id";
 			$this->db->sql_query($sql);
 
-			$this->cache->destroy('sql', FORUMS_TABLE);
-
 			$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'PST_LOG_MSG');
 
 			$this->end('PST_SAVED');
@@ -315,6 +310,22 @@ class similar_topics_admin
 		}
 	}
 
+	/**
+	 * Get list of PostgreSQL text search names
+	 *
+	 * @access protected
+	 * @return array array of text search names
+	 */
+	protected function get_cfgname_list()
+	{
+		$sql = 'SELECT cfgname AS ts_name FROM pg_ts_config';
+		$result = $this->db->sql_query($sql);
+		$ts_options = $this->db->sql_fetchrowset($result);
+		$this->db->sql_freeresult($result);
+
+		return $ts_options;
+	}
+
 	/**
 	 * Get forums list
 	 *
diff --git "[ORIGINAL]/vse\\similartopics/acp/similar_topics_module.php" "[FORUM_EXT]/vse\\similartopics/acp/similar_topics_module.php"
--- "[ORIGINAL]/vse\\similartopics/acp/similar_topics_module.php"
+++ "[FORUM_EXT]/vse\\similartopics/acp/similar_topics_module.php"
@@ -32,7 +32,9 @@ class similar_topics_module
 		global $phpbb_container;
 
 		$this->tpl_name = 'acp_similar_topics';
-		$this->page_title = 'PST_TITLE_ACP';
+
+		$this->page_title = $phpbb_container->get('language')
+			->lang('PST_TITLE_ACP');
 
 		$phpbb_container->get('vse.similartopics.acp.controller')
 			->set_u_action($this->u_action)
diff --git "[ORIGINAL]/vse\\similartopics/adm/style/acp_similar_topics.html" "[FORUM_EXT]/vse\\similartopics/adm/style/acp_similar_topics.html"
--- "[ORIGINAL]/vse\\similartopics/adm/style/acp_similar_topics.html"
+++ "[FORUM_EXT]/vse\\similartopics/adm/style/acp_similar_topics.html"
@@ -20,13 +20,13 @@
 	<fieldset>
 		<legend>{{ lang('PST_ADVANCED_FORUM') }}</legend>
 		<dl>
-			<dt><label for="similar_forums">{{ lang('FORUM') ~ lang('COLON') }} {{ PST_FORUM_NAME }}</label><br><br><span>{{ lang('PST_ADVANCED_EXP', PST_FORUM_NAME) }}</span></dt>
+			<dt><label for="similar_forums">{{ lang('FORUM') ~ lang('COLON') }} {{ PST_FORUM_NAME }}</label><br /><br /><span>{{ lang('PST_ADVANCED_EXP', PST_FORUM_NAME) }}</span></dt>
 			<dd><select id="similar_forums" name="similar_forums_id[]" multiple="multiple" size="10">{{ SIMILAR_FORUMS_OPTIONS }}</select></dd>
 			<dd><a href="#" data-selector="false">{{ lang('PST_DESELECT_ALL') }}</a></dd>
 		</dl>
 		<p class="submit-buttons">
-			<input class="button1" type="submit" id="submit" name="submit" value="{{ lang('SUBMIT') }}">&nbsp;
-			<input class="button2" type="reset" id="reset" name="reset" value="{{ lang('RESET') }}">
+			<input class="button1" type="submit" id="submit" name="submit" value="{{ lang('SUBMIT') }}" />&nbsp;
+			<input class="button2" type="reset" id="reset" name="reset" value="{{ lang('RESET') }}" />
 		</p>
 		{{ S_FORM_TOKEN }}
 	</fieldset>
@@ -47,17 +47,10 @@
 	<fieldset>
 		<legend>{{ lang('PST_LEGEND1') }}</legend>
 		<dl>
-			<dt><label for="pst_enable">{{ lang('PST_ENABLE') ~ lang('COLON') }}</label><br><span>{{ lang('PST_ENABLE_EXPLAIN') }}</span></dt>
+			<dt><label for="pst_enable">{{ lang('PST_ENABLE') ~ lang('COLON') }}</label></dt>
 			<dd>
-				<label><input type="radio" class="radio" id="pst_enable" name="pst_enable" value="1"{% if S_PST_ENABLE %} checked="checked"{% endif %}{% if S_PST_NO_SUPPORT %} disabled="disabled"{% endif %}> {{ lang('YES') }}</label>
-				<label><input type="radio" class="radio" name="pst_enable" value="0"{% if not S_PST_ENABLE %} checked="checked"{% endif %}> {{ lang('NO') }}</label>
-			</dd>
-		</dl>
-		<dl>
-			<dt><label for="pst_dynamic">{{ lang('PST_DYNAMIC') ~ lang('COLON') }}</label><br><span>{{ lang('PST_DYNAMIC_EXPLAIN') }}</span></dt>
-			<dd>
-				<label><input type="radio" class="radio" id="pst_dynamic" name="pst_dynamic" value="1"{% if S_PST_DYNAMIC %} checked="checked"{% endif %}> {{ lang('YES') }}</label>
-				<label><input type="radio" class="radio" name="pst_dynamic" value="0"{% if not S_PST_DYNAMIC %} checked="checked"{% endif %}> {{ lang('NO') }}</label>
+				<label><input type="radio" class="radio" id="pst_enable" name="pst_enable" value="1"{% if S_PST_ENABLE %} checked="checked"{% endif %}{% if S_PST_NO_SUPPORT %} disabled="disabled"{% endif %} /> {{ lang('YES') }}</label>
+				<label><input type="radio" class="radio" name="pst_enable" value="0"{% if not S_PST_ENABLE %} checked="checked"{% endif %} /> {{ lang('NO') }}</label>
 			</dd>
 		</dl>
 	</fieldset>
@@ -65,12 +58,12 @@
 	<fieldset>
 		<legend>{{ lang('PST_LEGEND2') }}</legend>
 		<dl>
-			<dt><label for="pst_limit">{{ lang('PST_LIMIT') ~ lang('COLON') }}</label><br><span>{{ lang('PST_LIMIT_EXPLAIN') }}</span></dt>
-			<dd><input name="pst_limit" id="pst_limit" type="number" min="0" max="999" value="{{ PST_LIMIT }}"></dd>
+			<dt><label for="pst_limit">{{ lang('PST_LIMIT') ~ lang('COLON') }}</label><br /><span>{{ lang('PST_LIMIT_EXPLAIN') }}</span></dt>
+			<dd><input name="pst_limit" id="pst_limit" type="number" min="0" max="999" value="{{ PST_LIMIT }}" /></dd>
 		</dl>
 		<dl>
-			<dt><label for="pst_time">{{ lang('PST_TIME') ~ lang('COLON') }}</label><br><span>{{ lang('PST_TIME_EXPLAIN') }}</span></dt>
-			<dd><input name="pst_time" id="pst_time" type="number" min="0" max="999" value="{{ PST_TIME }}">
+			<dt><label for="pst_time">{{ lang('PST_TIME') ~ lang('COLON') }}</label><br /><span>{{ lang('PST_TIME_EXPLAIN') }}</span></dt>
+			<dd><input name="pst_time" id="pst_time" type="number" min="0" max="999" value="{{ PST_TIME }}" />
 				<label>
 					<select name="pst_time_type">
 						{% for similar_time_options in loops.similar_time_options %}
@@ -81,12 +74,12 @@
 			</dd>
 		</dl>
 		<dl>
-			<dt><label for="pst_cache">{{ lang('PST_CACHE') ~ lang('COLON') }}</label><br><span>{{ lang('PST_CACHE_EXPLAIN') }}</span></dt>
-			<dd><input name="pst_cache" id="pst_cache" type="number" min="0" max="99999999" value="{{ PST_CACHE }}"> {{ lang('SECONDS') }}</dd>
+			<dt><label for="pst_cache">{{ lang('PST_CACHE') ~ lang('COLON') }}</label><br /><span>{{ lang('PST_CACHE_EXPLAIN') }}</span></dt>
+			<dd><input name="pst_cache" id="pst_cache" type="number" min="0" max="99999999" value="{{ PST_CACHE }}" /> {{ lang('SECONDS') }}</dd>
 		</dl>
 		<dl>
-			<dt><label for="pst_sense">{{ lang('PST_SENSE') ~ lang('COLON') }}</label><br><span>{{ lang('PST_SENSE_EXPLAIN', PST_SENSITIVITY) }}</span></dt>
-			<dd><input name="pst_sense" id="pst_sense" type="number" min="1" max="10" value="{{ PST_SENSE }}"></dd>
+			<dt><label for="pst_sense">{{ lang('PST_SENSE') ~ lang('COLON') }}</label><br /><span>{{ lang('PST_SENSE_EXPLAIN') }}</span></dt>
+			<dd><input name="pst_sense" id="pst_sense" type="number" min="1" max="10" value="{{ PST_SENSE }}" /></dd>
 		</dl>
 	</fieldset>
 
@@ -96,7 +89,7 @@
 			<span class="small">{{ lang('PST_FORUM_INFO') }}</span>
 			<div style="overflow: auto; max-height: 300px;">
 				<table class="table1">
-					<colgroup><col class="row1"><col class="row2"><col class="row1"><col class="row2"></colgroup>
+					<colgroup><col class="row1" /><col class="row2" /><col class="row1" /><col class="row2" /></colgroup>
 					<thead>
 						<tr>
 							<th>{{ lang('FORUMS') }}</th>
@@ -111,18 +104,18 @@
 							<td>
 								<strong><a href="{{ forums.U_FORUM }}">{{ forums.FORUM_NAME }}</a></strong>
 							</td>
-							<td style="text-align: center; width: 20%;" title="{{ lang('PST_NOSHOW_TITLE')|e('html_attr') }} {{ forums.FORUM_NAME|e('html_attr') }}">
+							<td style="text-align: center; width: 20%;" title="{{ lang('PST_NOSHOW_TITLE') }} {{ forums.FORUM_NAME }}">
 								<label>
-									<input type="checkbox" class="radio" name="mark_noshow_forum[]" value="{{ forums.FORUM_ID }}" {{ forums.CHECKED_NOSHOW_FORUM }}>
+									<input type="checkbox" class="radio" name="mark_noshow_forum[]" value="{{ forums.FORUM_ID }}" {{ forums.CHECKED_NOSHOW_FORUM }} />
 								</label>
 							</td>
-							<td style="text-align: center; width: 20%;" title="{{ lang('PST_IGNORE_TITLE')|e('html_attr') }} {{ forums.FORUM_NAME|e('html_attr') }}">
+							<td style="text-align: center; width: 20%;" title="{{ lang('PST_IGNORE_TITLE') }} {{ forums.FORUM_NAME }}">
 								<label>
-									<input type="checkbox" class="radio" name="mark_ignore_forum[]" value="{{ forums.FORUM_ID }}" {{ forums.CHECKED_IGNORE_FORUM }}>
+									<input type="checkbox" class="radio" name="mark_ignore_forum[]" value="{{ forums.FORUM_ID }}" {{ forums.CHECKED_IGNORE_FORUM }} />
 								</label>
 							</td>
-							<td style="text-align: center; width: 20%;" title="{{ lang('PST_ADVANCED_TITLE')|e('html_attr') }} {{ forums.FORUM_NAME|e('html_attr') }}">
-							<a href="{{ forums.U_ADVANCED }}">{% if forums.S_IS_ADVANCED %}<strong>{{ lang('PST_ADVANCED') }}</strong>{% else %}{{ lang('PST_STANDARD') }}{% endif %}</a>
+							<td style="text-align: center; width: 20%;" title="{{ lang('PST_ADVANCED_TITLE') }} {{ forums.FORUM_NAME }}">
+							<a href="{{ forums.U_ADVANCED }}">{% if forums.S_IS_ADVANCED %}<strong>{{ lang('PST_ADVANCED') }}</strong>{% else %}{{ lang('PST_STANDARD') }}</a>{% endif %}
 							</td>
 						</tr>
 						{% endfor %}
@@ -135,12 +128,12 @@
 	<fieldset>
 		<legend>{{ lang('PST_LEGEND4') }}</legend>
 		<dl>
-			<dt><label for="pst_words">{{ lang('PST_WORDS') ~ lang('COLON') }}</label><br><span>{{ lang('PST_WORDS_EXPLAIN') }}</span></dt>
+			<dt><label for="pst_words">{{ lang('PST_WORDS') ~ lang('COLON') }}</label><br /><span>{{ lang('PST_WORDS_EXPLAIN') }}</span></dt>
 			<dd><textarea name="pst_words" id="pst_words" rows="5" cols="40">{{ PST_WORDS }}</textarea></dd>
 		</dl>
 		{% if loops.postgres_ts_names %}
 			<dl>
-				<dt><label for="pst_postgres_ts_name">{{ lang('FULLTEXT_POSTGRES_TS_NAME') }}</label><br><span>{{ lang('FULLTEXT_POSTGRES_TS_NAME_EXPLAIN') }}</span></dt>
+				<dt><label for="pst_postgres_ts_name">{{ lang('FULLTEXT_POSTGRES_TS_NAME') }}</label><br /><span>{{ lang('FULLTEXT_POSTGRES_TS_NAME_EXPLAIN') }}</span></dt>
 				<dd>
 					<select name="pst_postgres_ts_name" id="pst_postgres_ts_name">
 						{% for ts_name in loops.postgres_ts_names %}
@@ -155,8 +148,8 @@
 	<fieldset>
 		<legend>{{ lang('ACP_SUBMIT_CHANGES') }}</legend>
 		<p class="submit-buttons">
-			<input class="button1" type="submit" id="submit" name="submit" value="{{ lang('SUBMIT') }}">&nbsp;
-			<input class="button2" type="reset" id="reset" name="reset" value="{{ lang('RESET') }}">
+			<input class="button1" type="submit" id="submit" name="submit" value="{{ lang('SUBMIT') }}" />&nbsp;
+			<input class="button2" type="reset" id="reset" name="reset" value="{{ lang('RESET') }}" />
 		</p>
 		{{ S_FORM_TOKEN }}
 	</fieldset>
diff --git "[ORIGINAL]/vse\\similartopics/composer.json" "[FORUM_EXT]/vse\\similartopics/composer.json"
--- "[ORIGINAL]/vse\\similartopics/composer.json"
+++ "[FORUM_EXT]/vse\\similartopics/composer.json"
@@ -3,7 +3,7 @@
     "type": "phpbb-extension",
     "description": "A phpBB extension that displays a list of similar (related) topics at the bottom of the current topic's page.",
     "homepage": "https://github.com/iMattPro/similartopics",
-    "version": "1.7.0",
+    "version": "1.6.0",
     "keywords": [
         "phpbb",
         "extension",
@@ -20,7 +20,7 @@
     ],
     "require": {
         "php": ">=5.4",
-        "composer/installers": "~1.0",
+        "composer/installers": "~1.0.0",
         "phpbb/phpbb": ">=3.2.1"
     },
     "extra": {
diff --git "[ORIGINAL]/vse\\similartopics/config/routing.yml" "[ORIGINAL]/vse\\similartopics/config/routing.yml"
deleted file mode 100644
--- "[ORIGINAL]/vse\\similartopics/config/routing.yml"
+++ /dev/null
@@ -1,6 +0,0 @@
-vse_similartopics_ajax_search:
-    path: /similartopics/ajax/search
-    defaults: { _controller: vse.similartopics.ajax.controller:search_similar_topics }
-    methods: [GET]
-    requirements:
-        _format: json
diff --git "[ORIGINAL]/vse\\similartopics/config/services.yml" "[FORUM_EXT]/vse\\similartopics/config/services.yml"
--- "[ORIGINAL]/vse\\similartopics/config/services.yml"
+++ "[FORUM_EXT]/vse\\similartopics/config/services.yml"
@@ -8,13 +8,13 @@ services:
             - '@config_text'
             - '@dbal.conn'
             - '@dispatcher'
+            - '@ext.manager'
             - '@language'
             - '@pagination'
             - '@request'
             - '@template'
             - '@user'
             - '@content.visibility'
-            - '@vse.similartopics.stop_word_helper'
             - '@vse.similartopics.driver.manager'
             - '%core.root_path%'
             - '%core.php_ext%'
@@ -23,8 +23,6 @@ services:
         class: vse\similartopics\event\listener
         arguments:
             - '@vse.similartopics.manager'
-            - '@controller.helper'
-            - '@template'
         tags:
             - { name: event.listener }
 
@@ -61,28 +59,13 @@ services:
             - '%core.root_path%'
             - '%core.php_ext%'
 
-    vse.similartopics.stop_word_helper:
-        class: vse\similartopics\core\stop_word_helper
-        public: false
-        arguments:
-            - '@cache.driver'
-            - '@ext.manager'
-            - '@user'
-            - '%core.php_ext%'
-
-    vse.similartopics.ajax.controller:
-        class: vse\similartopics\controller\ajax_controller
-        arguments:
-            - '@request'
-            - '@vse.similartopics.manager'
-
 # ----- Similar topics DB drivers collection -----
     vse.similartopics.driver_collection:
         class: phpbb\di\service_collection
         arguments:
             - '@service_container'
         tags:
-            - { name: service_collection, tag: vse.similartopics.driver }
+            - { name: service_collection, tag: vse.similartopcs.driver }
 
     vse.similartopics.driver.postgres:
         class: vse\similartopics\driver\postgres
@@ -90,50 +73,17 @@ services:
             - '@dbal.conn'
             - '@config'
         tags:
-            - { name: vse.similartopics.driver }
+            - { name: vse.similartopcs.driver }
 
     vse.similartopics.driver.mysqli:
         class: vse\similartopics\driver\mysqli
         arguments:
             - '@dbal.conn'
         tags:
-            - { name: vse.similartopics.driver }
+            - { name: vse.similartopcs.driver }
 
     vse.similartopics.driver.mysql4:
         class: vse\similartopics\driver\mysql4
         parent: vse.similartopics.driver.mysqli
         tags:
-            - { name: vse.similartopics.driver }
-
-    vse.similartopics.driver.sqlite3:
-        class: vse\similartopics\driver\sqlite3
-        arguments:
-            - '@dbal.conn'
-        tags:
-            - { name: vse.similartopics.driver }
-
-    vse.similartopics.driver.mssql:
-        class: vse\similartopics\driver\mssql
-        arguments:
-            - '@dbal.conn'
-        tags:
-            - { name: vse.similartopics.driver }
-
-    vse.similartopics.driver.mssqlnative:
-        class: vse\similartopics\driver\mssqlnative
-        parent: vse.similartopics.driver.mssql
-        tags:
-            - { name: vse.similartopics.driver }
-
-    vse.similartopics.driver.mssql_odbc:
-        class: vse\similartopics\driver\mssql_odbc
-        parent: vse.similartopics.driver.mssql
-        tags:
-            - { name: vse.similartopics.driver }
-
-    vse.similartopics.driver.oracle:
-        class: vse\similartopics\driver\oracle
-        arguments:
-            - '@dbal.conn'
-        tags:
-            - { name: vse.similartopics.driver }
+            - { name: vse.similartopcs.driver }
diff --git "[ORIGINAL]/vse\\similartopics/controller/ajax_controller.php" "[ORIGINAL]/vse\\similartopics/controller/ajax_controller.php"
deleted file mode 100644
--- "[ORIGINAL]/vse\\similartopics/controller/ajax_controller.php"
+++ /dev/null
@@ -1,63 +0,0 @@
-<?php
-/**
- *
- * Precise Similar Topics
- *
- * @copyright (c) 2025 Matt Friedman
- * @license GNU General Public License, version 2 (GPL-2.0)
- *
- */
-
-namespace vse\similartopics\controller;
-
-use phpbb\exception\http_exception;
-use Symfony\Component\HttpFoundation\JsonResponse;
-use phpbb\request\request;
-use vse\similartopics\core\similar_topics;
-
-class ajax_controller
-{
-	/** @var request */
-	protected $request;
-
-	/** @var similar_topics */
-	protected $similar_topics;
-
-	/**
-	 * Constructor
-	 *
-	 * @param request $request
-	 * @param similar_topics $similar_topics
-	 */
-	public function __construct(request $request, similar_topics $similar_topics)
-	{
-		$this->request = $request;
-		$this->similar_topics = $similar_topics;
-	}
-
-	/**
-	 * Handle AJAX request for similar topics search
-	 *
-	 * @return JsonResponse
-	 * @throws http_exception
-	 */
-	public function search_similar_topics()
-	{
-		if (!$this->request->is_ajax())
-		{
-			throw new http_exception(403, 'NO_AUTH_OPERATION');
-		}
-
-		$query = $this->request->variable('q', '', true);
-		$forum_id = $this->request->variable('f', 0);
-
-		if (utf8_strlen($query) < 3 || !$this->similar_topics->is_dynamic_available())
-		{
-			return new JsonResponse(['topics' => []]);
-		}
-
-		$topics = $this->similar_topics->search_similar_topics_ajax($query, $forum_id);
-
-		return new JsonResponse(['topics' => $topics]);
-	}
-}
diff --git "[ORIGINAL]/vse\\similartopics/core/similar_topics.php" "[FORUM_EXT]/vse\\similartopics/core/similar_topics.php"
--- "[ORIGINAL]/vse\\similartopics/core/similar_topics.php"
+++ "[FORUM_EXT]/vse\\similartopics/core/similar_topics.php"
@@ -17,6 +17,7 @@ use phpbb\config\db_text;
 use phpbb\content_visibility;
 use phpbb\db\driver\driver_interface as db;
 use phpbb\event\dispatcher_interface as dispatcher;
+use phpbb\extension\manager as ext_manager;
 use phpbb\language\language;
 use phpbb\pagination;
 use phpbb\request\request;
@@ -45,6 +46,9 @@ class similar_topics
 	/** @var dispatcher */
 	protected $dispatcher;
 
+	/** @var ext_manager */
+	protected $extension_manager;
+
 	/** @var language */
 	protected $language;
 
@@ -63,9 +67,6 @@ class similar_topics
 	/** @var content_visibility */
 	protected $content_visibility;
 
-	/** @var stop_word_helper */
-	protected $stop_word_helper;
-
 	/** @var similartopics_driver */
 	protected $similartopics;
 
@@ -88,18 +89,18 @@ class similar_topics
 	 * @param db_text               $config_text
 	 * @param db                    $db
 	 * @param dispatcher            $dispatcher
+	 * @param ext_manager           $extension_manager
 	 * @param language              $language
 	 * @param pagination            $pagination
 	 * @param request               $request
 	 * @param template              $template
 	 * @param user                  $user
 	 * @param content_visibility    $content_visibility
-	 * @param stop_word_helper      $stop_word_helper
 	 * @param similartopics_manager $similartopics_manager
 	 * @param string                $root_path
 	 * @param string                $php_ext
 	 */
-	public function __construct(auth $auth, cache $cache, config $config, db_text $config_text, db $db, dispatcher $dispatcher, language $language, pagination $pagination, request $request, template $template, user $user, content_visibility $content_visibility, stop_word_helper $stop_word_helper, similartopics_manager $similartopics_manager, $root_path, $php_ext)
+	public function __construct(auth $auth, cache $cache, config $config, db_text $config_text, db $db, dispatcher $dispatcher, ext_manager $extension_manager, language $language, pagination $pagination, request $request, template $template, user $user, content_visibility $content_visibility, similartopics_manager $similartopics_manager, $root_path, $php_ext)
 	{
 		$this->auth = $auth;
 		$this->cache = $cache;
@@ -107,7 +108,7 @@ class similar_topics
 		$this->config_text = $config_text;
 		$this->db = $db;
 		$this->dispatcher = $dispatcher;
-		$this->stop_word_helper = $stop_word_helper;
+		$this->extension_manager = $extension_manager;
 		$this->language = $language;
 		$this->pagination = $pagination;
 		$this->request = $request;
@@ -153,28 +154,6 @@ class similar_topics
 		return !empty($this->user->data['user_similar_topics']) && $this->auth->acl_get('u_similar_topics');
 	}
 
-	/**
-	 * Is dynamic similar topics available?
-	 *
-	 * @access public
-	 * @return bool True if available, false otherwise
-	 */
-	public function is_dynamic_available()
-	{
-		return $this->is_dynamic_enabled() && $this->is_viewable() && $this->similartopics !== null;
-	}
-
-	/**
-	 * Is dynamic similar topics enabled?
-	 *
-	 * @access public
-	 * @return bool True if enabled, false otherwise
-	 */
-	public function is_dynamic_enabled()
-	{
-		return !empty($this->config['similar_topics_dynamic']) && !empty($this->config['similar_topics_limit']);
-	}
-
 	/**
 	 * Get similar topics by matching topic titles
 	 * Loosely based on viewforum.php lines 840-1040
@@ -194,9 +173,7 @@ class similar_topics
 			return;
 		}
 
-		$this->stop_word_helper->set_use_localized($this->get_localized_ignore_words());
-		$this->stop_word_helper->set_additional_ignore_words($this->get_additional_ignore_words());
-		$topic_title = $this->stop_word_helper->clean_text($topic_data['topic_title']);
+		$topic_title = $this->clean_topic_title($topic_data['topic_title']);
 
 		// If the cleaned up topic_title is empty, no need to continue
 		if (empty($topic_title))
@@ -322,7 +299,6 @@ class similar_topics
 				$u_mcp_queue = ($topic_unapproved || $posts_unapproved) ? append_sid("{$this->root_path}mcp.$this->php_ext", 'i=queue&amp;mode=' . ($topic_unapproved ? 'approve_details' : 'unapproved_posts') . "&amp;t=$similar_topic_id", true, $this->user->session_id) : '';
 
 				$base_url = append_sid("{$this->root_path}viewtopic.$this->php_ext", $view_topic_url_params);
-
 				$topic_row = array(
 					'TOPIC_AUTHOR_FULL'			=> get_username_string('full', $row['topic_poster'], $row['topic_first_poster_name'], $row['topic_first_poster_colour']),
 					'FIRST_POST_TIME'			=> $this->user->format_date($row['topic_time']),
@@ -333,6 +309,7 @@ class similar_topics
 
 					'TOPIC_REPLIES'			=> $replies,
 					'TOPIC_VIEWS'			=> $row['topic_views'],
+					'TOPIC_ANSWERED'		=> ($this->extension_manager->is_enabled('kinerity/bestanswer')) && $row['answer_post_id'] ? true : false,
 					'TOPIC_TITLE'			=> censor_text($row['topic_title']),
 					'FORUM_TITLE'			=> $row['forum_name'],
 
@@ -377,7 +354,7 @@ class similar_topics
 			}
 		}
 
-		$this->add_language();
+		$this->language->add_lang('similar_topics', 'vse/similartopics');
 
 		$this->template->assign_vars(array(
 			'NEWEST_POST_IMG'	=> $this->user->img('icon_topic_newest', 'VIEW_NEWEST_POST'),
@@ -388,96 +365,130 @@ class similar_topics
 	}
 
 	/**
-	 * Add lang files for similar topics
+	 * Clean topic title (and if needed, ignore-words)
 	 *
-	 * @return void
+	 * @access public
+	 * @param string $text The topic title
+	 * @return string The topic title
 	 */
-	public function add_language()
+	public function clean_topic_title($text)
 	{
-		$this->language->add_lang('similar_topics', 'vse/similartopics');
+		// Strip quotes, ampersands
+		$text = str_replace(array('&quot;', '&amp;'), '', $text);
+
+		// UTF Emojis
+		$regex_emoticons = '/[\x{1F600}-\x{1F64F}]/u';
+		$text = preg_replace($regex_emoticons, '', $text);
+
+		// Match Miscellaneous Symbols and Pictographs
+		$regex_symbols = '/[\x{1F300}-\x{1F5FF}]/u';
+		$text = preg_replace($regex_symbols, '', $text);
+
+		// Match Transport And Map Symbols
+		$regex_transport = '/[\x{1F680}-\x{1F6FF}]/u';
+		$text = preg_replace($regex_transport, '', $text);
+
+		// Match Miscellaneous Symbols
+		$regex_misc = '/[\x{2600}-\x{26FF}]/u';
+		$text = preg_replace($regex_misc, '', $text);
+
+		// Match Dingbats
+		$regex_dingbats = '/[\x{2700}-\x{27BF}]/u';
+		$text = preg_replace($regex_dingbats, '', $text);
+
+		$regex_bbemoji = '(:([-+_a-z0-9]+):(?!\\w|[^<>]*(?=>|</code>)))';
+		$matches = [];
+		preg_match_all($regex_bbemoji, $text, $matches);
+		foreach ($matches[0] as $emoji) {
+			$text = str_replace($emoji, '', $text);
 		}
 
-	/**
-	 * Check if we should load localized ignore words
-	 *
-	 * @access protected
-	 * @return bool True if non-English language or using a dbms with no stop-words
-	 */
-	protected function get_localized_ignore_words()
+		$text = trim($text);
+
+		if (!$this->english_lang() || $this->get_ignore_words())
 		{
-		return !in_array($this->user->lang_name, ['en', 'en_us'], true) || !$this->similartopics->has_stopword_support();
+			$text = $this->strip_stop_words($text);
+		}
+
+		return $text;
 	}
 
 	/**
-	 * Search for similar topics via AJAX for dynamic suggestions
+	 * Remove any non-english and/or custom defined ignore-words
 	 *
-	 * @param string $query The search query
-	 * @param int $forum_id The forum ID to search from
-	 * @return array Array of similar topics
+	 * @access protected
+	 * @param string $text The topic title
+	 * @return string The topic title
 	 */
-	public function search_similar_topics_ajax($query, $forum_id = 0)
+	protected function strip_stop_words($text)
 	{
-		$this->stop_word_helper->set_use_localized($this->get_localized_ignore_words());
-		$this->stop_word_helper->set_additional_ignore_words($this->get_additional_ignore_words());
-		$cleaned_query = $this->stop_word_helper->clean_text($query);
+		$words = array();
 
-		if (empty($cleaned_query))
+		// If non-English, look for a list of stop-words to be ignored
+		// in either the core or the extension (deprecated from core)
+		if (!$this->english_lang())
 		{
-			return [];
+			$finder = $this->extension_manager->get_finder();
+			$search_ignore_words = $finder
+				->set_extensions(array('vse/similartopics'))
+				->prefix('search_ignore_words')
+				->suffix(".$this->php_ext")
+				->extension_directory("/language/{$this->user->lang_name}")
+				->core_path("language/{$this->user->lang_name}/")
+				->get_files();
+			if (current($search_ignore_words))
+			{
+				include current($search_ignore_words);
+			}
 		}
 
-		$sensitivity = $this->config->offsetExists('similar_topics_sense') ? number_format($this->config['similar_topics_sense'] / 10, 1, '.', '') : '0.5';
-		$sql_array = $this->similartopics->get_query(0, $cleaned_query, $this->config['similar_topics_time'], $sensitivity);
-
-		$similar_topic_forums = null;
-		if ($forum_id > 0)
+		if ($this->get_ignore_words())
 		{
-			$sql = 'SELECT similar_topic_forums
-				FROM ' . FORUMS_TABLE . '
-				WHERE forum_id = ' . (int) $forum_id;
-			$result = $this->db->sql_query($sql, 3600);
-			$similar_topic_forums = $this->db->sql_fetchfield('similar_topic_forums');
-			$this->db->sql_freeresult($result);
+			// Merge any custom defined ignore words from the ACP to the stop-words array
+			$words = array_merge($this->make_word_array($this->get_ignore_words()), $words);
 		}
 
-		$passworded_forums = $this->user->get_passworded_forums();
+		// Remove stop-words from the topic title text
+		$words = array_diff($this->make_word_array($text), $words);
 
-		if (!empty($similar_topic_forums))
-		{
-			$included_forums = array_diff(json_decode($similar_topic_forums, true), $passworded_forums);
-			if (empty($included_forums))
-			{
-				return [];
-			}
-			$sql_array['WHERE'] .= ' AND ' . $this->db->sql_in_set('f.forum_id', $included_forums);
-		}
-		else
-		{
-			if (count($passworded_forums))
-			{
-				$sql_array['WHERE'] .= ' AND ' . $this->db->sql_in_set('f.forum_id', $passworded_forums, true);
-			}
-			$sql_array['WHERE'] .= ' AND f.similar_topics_ignore = 0';
+		// Convert our words array back to a string
+		return implode(' ', $words);
 	}
 
-		$topics = [];
-		$sql = $this->db->sql_build_query('SELECT', $sql_array);
-		$result = $this->db->sql_query_limit($sql, 5);
+	/**
+	 * Helper function to split string into an array of words
+	 *
+	 * @access protected
+	 * @param string $text String of plain text words
+	 * @return array Array of plaintext words
+	 */
+	protected function make_word_array($text)
+	{
+		// Strip out any non-alpha-numeric characters using PCRE regex syntax
+		$text = trim(preg_replace('#[^\p{L}\p{N}]+#u', ' ', $text));
 
-		while ($row = $this->db->sql_fetchrow($result))
+		$words = explode(' ', utf8_strtolower($text));
+		foreach ($words as $key => $word)
 		{
-			if ($this->auth->acl_get('f_read', (int) $row['forum_id']))
+			// Strip words of 2 characters or fewer
+			if (utf8_strlen(trim($word)) < 3)
 			{
-				$topics[] = [
-					'id' => (int) $row['topic_id'],
-					'title' => censor_text($row['topic_title']),
-					'url' => append_sid("{$this->root_path}viewtopic.$this->php_ext", 't=' . $row['topic_id'])
-				];
+				unset($words[$key]);
 			}
 		}
-		$this->db->sql_freeresult($result);
 
-		return $topics;
+		return $words;
+	}
+
+	/**
+	 * Check if English is the current user's language
+	 *
+	 * @access protected
+	 * @return bool True if lang is 'en' or 'en_us', false otherwise
+	 */
+	protected function english_lang()
+	{
+		return ($this->user->lang_name === 'en' || $this->user->lang_name === 'en_us');
 	}
 
 	/**
@@ -486,7 +497,7 @@ class similar_topics
 	 * @access protected
 	 * @return string|null String of ignore words or null if there are none defined
 	 */
-	protected function get_additional_ignore_words()
+	protected function get_ignore_words()
 	{
 		$key = 'similar_topics_words';
 
diff --git "[ORIGINAL]/vse\\similartopics/core/stop_word_helper.php" "[ORIGINAL]/vse\\similartopics/core/stop_word_helper.php"
deleted file mode 100644
--- "[ORIGINAL]/vse\\similartopics/core/stop_word_helper.php"
+++ /dev/null
@@ -1,198 +0,0 @@
-<?php
-/**
- *
- * Precise Similar Topics
- *
- * @copyright (c) 2025 Matt Friedman
- * @license GNU General Public License, version 2 (GPL-2.0)
- *
- */
-
-namespace vse\similartopics\core;
-
-use phpbb\cache\driver\driver_interface as cache_driver;
-use phpbb\extension\manager as ext_manager;
-use phpbb\user;
-
-/**
- * A helper class to clean text and remove stop words (localized and additional)
- * for topic titles or other search-related strings.
- */
-class stop_word_helper
-{
-	/** @var cache_driver */
-	protected $cache;
-
-	/** @var ext_manager */
-	protected $extension_manager;
-
-	/** @var user */
-	protected $user;
-
-	/** @var string */
-	protected $php_ext;
-
-	/** @var array|null Lookup table for fast filtering */
-	protected $ignore_lookup;
-
-	/** @var bool Whether localized ignore words should be loaded */
-	protected $use_localized = false;
-
-	/** @var string Additional ignore words string */
-	protected $additional_ignore = '';
-
-	/** @var bool Whether ignore words need to be reloaded */
-	protected $needs_reload = true;
-
-	/**
-	 * Constructor
-	 *
-	 * @param cache_driver $cache
-	 * @param ext_manager $extension_manager
-	 * @param user $user
-	 * @param string $php_ext
-	 */
-	public function __construct(cache_driver $cache, ext_manager $extension_manager, user $user, $php_ext)
-	{
-		$this->cache = $cache;
-		$this->extension_manager = $extension_manager;
-		$this->user = $user;
-		$this->php_ext = $php_ext;
-	}
-
-	/**
-	 * Set additional ignore words
-	 *
-	 * @param string $words
-	 */
-	public function set_additional_ignore_words($words)
-	{
-		if ($this->additional_ignore !== $words)
-		{
-			$this->additional_ignore = $words;
-			$this->needs_reload = true;
-		}
-	}
-
-	/**
-	 * Set whether to use localized ignore words
-	 *
-	 * @param bool $value
-	 */
-	public function set_use_localized($value)
-	{
-		$value = (bool) $value;
-		if ($this->use_localized !== $value)
-		{
-			$this->use_localized = $value;
-			$this->needs_reload = true;
-		}
-	}
-
-	/**
-	 * Clean text (strip quotes, ampersands, stop words)
-	 *
-	 * @param string $text
-	 * @return string
-	 */
-	public function clean_text($text)
-	{
-		// Strip HTML entities
-		$text = str_replace(['&quot;', '&amp;'], '', $text);
-
-		if ($this->use_localized || !empty($this->additional_ignore))
-		{
-			$this->load_ignore_words();
-			$filtered = array_filter(
-				$this->make_word_array($text, true),
-				[$this, 'filter_ignore_words']
-			);
-			$text = implode(' ', array_unique($filtered));
-		}
-
-		return $text;
-	}
-
-	/**
-	 * Load ignore words into memory and build a lookup table
-	 */
-	protected function load_ignore_words()
-	{
-		if ($this->needs_reload || $this->ignore_lookup === null)
-		{
-			// The cache will be invalidated when language, localized setting, or additional words change
-			$cache_key = '_pst_ignore_' . md5($this->user->lang_name . '|' . (int) $this->use_localized . '|' . $this->additional_ignore);
-			$this->ignore_lookup = $this->cache->get($cache_key);
-
-			if ($this->ignore_lookup === false)
-			{
-				// Load localized ignore words (if needed)
-				$words = $this->use_localized ? $this->load_localized_words() : [];
-
-				// Load additional ignore words (if defined)
-				if (!empty($this->additional_ignore))
-				{
-					$words = array_merge($words, $this->make_word_array($this->additional_ignore));
-				}
-
-				$this->ignore_lookup = array_flip(array_unique($words));
-				$this->cache->put($cache_key, $this->ignore_lookup);
-			}
-
-			$this->needs_reload = false;
-		}
-	}
-
-	/**
-	 * Load localized ignore words
-	 *
-	 * @return array An array of ignore-words from the user's language pack
-	 */
-	protected function load_localized_words()
-	{
-		$words = [];
-		$finder = $this->extension_manager->get_finder();
-		$files = $finder
-			->set_extensions(['vse/similartopics'])
-			->prefix('search_ignore_words')
-			->suffix('.' . $this->php_ext)
-			->extension_directory("/language/{$this->user->lang_name}")
-			->core_path("language/{$this->user->lang_name}/")
-			->get_files();
-
-		if (current($files))
-		{
-			include current($files);
-		}
-
-		return $words;
-	}
-
-	/**
-	 * Split text into a word array
-	 *
-	 * @param string $text A string of text
-	 * @param bool $filter_short Whether to filter out words < 3 characters
-	 * @return array The original string of text, filtered into an array of individual words
-	 */
-	protected function make_word_array($text, $filter_short = false)
-	{
-		$text = trim(preg_replace('#[^\p{L}\p{N}]+#u', ' ', $text));
-		$words = array_filter(explode(' ', utf8_strtolower($text)));
-
-		return $filter_short ? array_filter($words, static function($word) {
-			return utf8_strlen($word) >= 3;
-		}) : $words;
-	}
-
-	/**
-	 * Filter callback for array_filter to exclude stop words
-	 *
-	 * @param string $word Word to check
-	 * @return bool True to keep a word, false to remove it
-	 */
-	protected function filter_ignore_words($word)
-	{
-		return !isset($this->ignore_lookup[$word]);
-	}
-}
diff --git "[FORUM_EXT]/vse\\similartopics/diff_full.tmp" "[FORUM_EXT]/vse\\similartopics/diff_full.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/vse\\similartopics/diff_full.tmp"
@@ -0,0 +1,5844 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/CHANGELOG.md" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/CHANGELOG.md"
+index dcfad82c4..378efc1d0 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/CHANGELOG.md"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/CHANGELOG.md"
+@@ -1,18 +1,10 @@
+ ## Changelog
+ 
+-### 1.7.0 - 2025-12-16
+-
+-- NEW FEATURE: Dynamically show similar topics to users as they title their new posts.
+-- IMPROVEMENT: Support for MSSQL, SQLite3 and Oracle databases added.
+-- IMPROVEMENT: Added stop-word filtering for Postgres databases using the 'simple' dictionary.
+-- Added missing stop-word filters (AI-translated) for Hebrew, Persian, Japanese, Swedish and Turkish languages.
+-- Fixed and optimized lots of code when processing similar topics.
+-
+ ### 1.6.0 - 2022-12-17
+ 
+ - Removed support for phpBB 3.1.x.
+ - Removed forum "f=" parameters from URLs.
+-- Optimized JavaScript and other coding updates.
++- Optimized Javascript and other coding updates.
+ - Support added for ScaffoldBB style.
+ 
+ ### 1.5.4 - 2020-12-01
+@@ -20,11 +12,11 @@
+ - Fix for Postgresql databases where titles with single quotes would fatally error.
+ - Enabled AJAX interactions when saving settings in the ACP.
+ - Re-wrote the search period explanation in the ACP settings.
+-- Switched to using the phpBB finder to locate foreign language ignore words files.
++- Switched to using phpBB finder to locate foreign language ignore words files.
+ 
+ ### 1.5.3 - 2020-01-10
+ 
+-- Compatibility issues with Prosilver styles are addressed.
++- Compatibility issues with Prosilver styles addressed.
+ - Installation errors on phpBB 3.3.x will be reported to the user.
+ 
+ ### 1.5.2 - 2019-06-26
+@@ -35,18 +27,18 @@
+ 
+ ### 1.5.1 - 2018-06-01
+ 
+-- Fixed an issue where PHP using European decimal notation (comma instead of a period) could cause an SQL error.
+-- Minor code fixes based on the phpBB Extension team validation report.
++- Fixed an issue where PHP using European decimal notation (comma instead of period) could cause an SQL error.
++- Minor code fixes based on phpBB Extension team validation report.
+ 
+ ### 1.5.0 - 2018-03-14
+ 
+ - Added support for forums using PostgreSQL databases (with thanks to hubaishan).
+ - Fixed a layout bug with the pagination buttons introduced in phpBB 3.2.2.
+-- Fixed a potential SQL error bug when installing.
++- Fixed potential SQL error bug when installing.
+ 
+ ### 1.4.3 - 2018-01-03
+ 
+-- Added a new setting: Search Sensitivity. Allows users to adjust the weighting of similar topics matches. This was added because InnoDB, which is now supported, weights results differently than MyISAM. This will allow users with InnoDB tables to improve their similar topics results by lowering the weighting/sensitivity.
++- Added a new setting: Search Sensitivity. Allows users to adjust the weighting of similar topics matches. This was added because InnoDB which is now supported, weights results differently than MyISAM. This will allow users with InnoDB tables to improve their similar topics results by lowering the weighting/sensitivity.
+ - Converted all template syntax to Twig format.
+ 
+ ### 1.4.2 - 2017-03-18
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/acp/controller/similar_topics_admin.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/acp/controller/similar_topics_admin.php"
+index 85c505289..4e2b5441e 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/acp/controller/similar_topics_admin.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/acp/controller/similar_topics_admin.php"
+@@ -157,7 +157,6 @@ class similar_topics_admin
+ 
+ 			// Set basic config settings
+ 			$this->config->set('similar_topics', $this->request->variable('pst_enable', 0));
+-			$this->config->set('similar_topics_dynamic', $this->request->variable('pst_dynamic', 0));
+ 			$this->config->set('similar_topics_limit', abs($this->request->variable('pst_limit', 0))); // use abs for positive values only
+ 			$this->config->set('similar_topics_cache', abs($this->request->variable('pst_cache', 0))); // use abs for positive values only
+ 			$this->config_text_set('similar_topics_words', $this->request->variable('pst_words', '', true));
+@@ -209,22 +208,20 @@ class similar_topics_admin
+ 
+ 		$this->template->assign_vars(array(
+ 			'S_PST_ENABLE'    => $this->isset_or_default($this->config['similar_topics'], false),
+-			'S_PST_DYNAMIC'   => $this->isset_or_default($this->config['similar_topics_dynamic'], false),
+ 			'PST_LIMIT'       => $this->isset_or_default($this->config['similar_topics_limit'], ''),
+ 			'PST_CACHE'       => $this->isset_or_default($this->config['similar_topics_cache'], ''),
+ 			'PST_SENSE'       => $this->isset_or_default($this->config['similar_topics_sense'], ''),
+ 			'PST_WORDS'       => $this->isset_or_default($this->config_text_get('similar_topics_words'), ''),
+ 			'PST_TIME'        => $this->get_pst_time($this->config['similar_topics_time'], $this->config['similar_topics_type']),
+-			'PST_SENSITIVITY' => $this->similartopics && $this->similartopics->get_engine() === 'innodb' ? 1 : 5,
+ 			'S_PST_NO_COMPAT' => $this->similartopics === null || !$this->similartopics->is_fulltext('topic_title'),
+ 			'U_ACTION'        => $this->u_action,
+ 		));
+ 
+ 		// If postgresql, we need to make an options list of text search names
+-		if ($this->similartopics instanceof \vse\similartopics\driver\postgres)
++		if ($this->similartopics && $this->similartopics->get_type() === 'postgres')
+ 		{
+ 			$this->language->add_lang('acp/search');
+-			foreach ($this->similartopics->get_cfg_name_list() as $row)
++			foreach ($this->get_cfgname_list() as $row)
+ 			{
+ 				$this->template->assign_block_vars('postgres_ts_names', array(
+ 					'NAME'       => $row['ts_name'],
+@@ -269,8 +266,6 @@ class similar_topics_admin
+ 				WHERE forum_id = $forum_id";
+ 			$this->db->sql_query($sql);
+ 
+-			$this->cache->destroy('sql', FORUMS_TABLE);
+-
+ 			$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'PST_LOG_MSG');
+ 
+ 			$this->end('PST_SAVED');
+@@ -315,6 +310,22 @@ class similar_topics_admin
+ 		}
+ 	}
+ 
++	/**
++	 * Get list of PostgreSQL text search names
++	 *
++	 * @access protected
++	 * @return array array of text search names
++	 */
++	protected function get_cfgname_list()
++	{
++		$sql = 'SELECT cfgname AS ts_name FROM pg_ts_config';
++		$result = $this->db->sql_query($sql);
++		$ts_options = $this->db->sql_fetchrowset($result);
++		$this->db->sql_freeresult($result);
++
++		return $ts_options;
++	}
++
+ 	/**
+ 	 * Get forums list
+ 	 *
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/acp/similar_topics_module.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/acp/similar_topics_module.php"
+index 8e9408fa8..e0a74e17d 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/acp/similar_topics_module.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/acp/similar_topics_module.php"
+@@ -32,7 +32,9 @@ class similar_topics_module
+ 		global $phpbb_container;
+ 
+ 		$this->tpl_name = 'acp_similar_topics';
+-		$this->page_title = 'PST_TITLE_ACP';
++
++		$this->page_title = $phpbb_container->get('language')
++			->lang('PST_TITLE_ACP');
+ 
+ 		$phpbb_container->get('vse.similartopics.acp.controller')
+ 			->set_u_action($this->u_action)
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/adm/style/acp_similar_topics.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/adm/style/acp_similar_topics.html"
+index 8f0c529db..0be73ff9f 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/adm/style/acp_similar_topics.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/adm/style/acp_similar_topics.html"
+@@ -20,13 +20,13 @@
+ 	<fieldset>
+ 		<legend>{{ lang('PST_ADVANCED_FORUM') }}</legend>
+ 		<dl>
+-			<dt><label for="similar_forums">{{ lang('FORUM') ~ lang('COLON') }} {{ PST_FORUM_NAME }}</label><br><br><span>{{ lang('PST_ADVANCED_EXP', PST_FORUM_NAME) }}</span></dt>
++			<dt><label for="similar_forums">{{ lang('FORUM') ~ lang('COLON') }} {{ PST_FORUM_NAME }}</label><br /><br /><span>{{ lang('PST_ADVANCED_EXP', PST_FORUM_NAME) }}</span></dt>
+ 			<dd><select id="similar_forums" name="similar_forums_id[]" multiple="multiple" size="10">{{ SIMILAR_FORUMS_OPTIONS }}</select></dd>
+ 			<dd><a href="#" data-selector="false">{{ lang('PST_DESELECT_ALL') }}</a></dd>
+ 		</dl>
+ 		<p class="submit-buttons">
+-			<input class="button1" type="submit" id="submit" name="submit" value="{{ lang('SUBMIT') }}">&nbsp;
+-			<input class="button2" type="reset" id="reset" name="reset" value="{{ lang('RESET') }}">
++			<input class="button1" type="submit" id="submit" name="submit" value="{{ lang('SUBMIT') }}" />&nbsp;
++			<input class="button2" type="reset" id="reset" name="reset" value="{{ lang('RESET') }}" />
+ 		</p>
+ 		{{ S_FORM_TOKEN }}
+ 	</fieldset>
+@@ -47,17 +47,10 @@
+ 	<fieldset>
+ 		<legend>{{ lang('PST_LEGEND1') }}</legend>
+ 		<dl>
+-			<dt><label for="pst_enable">{{ lang('PST_ENABLE') ~ lang('COLON') }}</label><br><span>{{ lang('PST_ENABLE_EXPLAIN') }}</span></dt>
++			<dt><label for="pst_enable">{{ lang('PST_ENABLE') ~ lang('COLON') }}</label></dt>
+ 			<dd>
+-				<label><input type="radio" class="radio" id="pst_enable" name="pst_enable" value="1"{% if S_PST_ENABLE %} checked="checked"{% endif %}{% if S_PST_NO_SUPPORT %} disabled="disabled"{% endif %}> {{ lang('YES') }}</label>
+-				<label><input type="radio" class="radio" name="pst_enable" value="0"{% if not S_PST_ENABLE %} checked="checked"{% endif %}> {{ lang('NO') }}</label>
+-			</dd>
+-		</dl>
+-		<dl>
+-			<dt><label for="pst_dynamic">{{ lang('PST_DYNAMIC') ~ lang('COLON') }}</label><br><span>{{ lang('PST_DYNAMIC_EXPLAIN') }}</span></dt>
+-			<dd>
+-				<label><input type="radio" class="radio" id="pst_dynamic" name="pst_dynamic" value="1"{% if S_PST_DYNAMIC %} checked="checked"{% endif %}> {{ lang('YES') }}</label>
+-				<label><input type="radio" class="radio" name="pst_dynamic" value="0"{% if not S_PST_DYNAMIC %} checked="checked"{% endif %}> {{ lang('NO') }}</label>
++				<label><input type="radio" class="radio" id="pst_enable" name="pst_enable" value="1"{% if S_PST_ENABLE %} checked="checked"{% endif %}{% if S_PST_NO_SUPPORT %} disabled="disabled"{% endif %} /> {{ lang('YES') }}</label>
++				<label><input type="radio" class="radio" name="pst_enable" value="0"{% if not S_PST_ENABLE %} checked="checked"{% endif %} /> {{ lang('NO') }}</label>
+ 			</dd>
+ 		</dl>
+ 	</fieldset>
+@@ -65,12 +58,12 @@
+ 	<fieldset>
+ 		<legend>{{ lang('PST_LEGEND2') }}</legend>
+ 		<dl>
+-			<dt><label for="pst_limit">{{ lang('PST_LIMIT') ~ lang('COLON') }}</label><br><span>{{ lang('PST_LIMIT_EXPLAIN') }}</span></dt>
+-			<dd><input name="pst_limit" id="pst_limit" type="number" min="0" max="999" value="{{ PST_LIMIT }}"></dd>
++			<dt><label for="pst_limit">{{ lang('PST_LIMIT') ~ lang('COLON') }}</label><br /><span>{{ lang('PST_LIMIT_EXPLAIN') }}</span></dt>
++			<dd><input name="pst_limit" id="pst_limit" type="number" min="0" max="999" value="{{ PST_LIMIT }}" /></dd>
+ 		</dl>
+ 		<dl>
+-			<dt><label for="pst_time">{{ lang('PST_TIME') ~ lang('COLON') }}</label><br><span>{{ lang('PST_TIME_EXPLAIN') }}</span></dt>
+-			<dd><input name="pst_time" id="pst_time" type="number" min="0" max="999" value="{{ PST_TIME }}">
++			<dt><label for="pst_time">{{ lang('PST_TIME') ~ lang('COLON') }}</label><br /><span>{{ lang('PST_TIME_EXPLAIN') }}</span></dt>
++			<dd><input name="pst_time" id="pst_time" type="number" min="0" max="999" value="{{ PST_TIME }}" />
+ 				<label>
+ 					<select name="pst_time_type">
+ 						{% for similar_time_options in loops.similar_time_options %}
+@@ -81,12 +74,12 @@
+ 			</dd>
+ 		</dl>
+ 		<dl>
+-			<dt><label for="pst_cache">{{ lang('PST_CACHE') ~ lang('COLON') }}</label><br><span>{{ lang('PST_CACHE_EXPLAIN') }}</span></dt>
+-			<dd><input name="pst_cache" id="pst_cache" type="number" min="0" max="99999999" value="{{ PST_CACHE }}"> {{ lang('SECONDS') }}</dd>
++			<dt><label for="pst_cache">{{ lang('PST_CACHE') ~ lang('COLON') }}</label><br /><span>{{ lang('PST_CACHE_EXPLAIN') }}</span></dt>
++			<dd><input name="pst_cache" id="pst_cache" type="number" min="0" max="99999999" value="{{ PST_CACHE }}" /> {{ lang('SECONDS') }}</dd>
+ 		</dl>
+ 		<dl>
+-			<dt><label for="pst_sense">{{ lang('PST_SENSE') ~ lang('COLON') }}</label><br><span>{{ lang('PST_SENSE_EXPLAIN', PST_SENSITIVITY) }}</span></dt>
+-			<dd><input name="pst_sense" id="pst_sense" type="number" min="1" max="10" value="{{ PST_SENSE }}"></dd>
++			<dt><label for="pst_sense">{{ lang('PST_SENSE') ~ lang('COLON') }}</label><br /><span>{{ lang('PST_SENSE_EXPLAIN') }}</span></dt>
++			<dd><input name="pst_sense" id="pst_sense" type="number" min="1" max="10" value="{{ PST_SENSE }}" /></dd>
+ 		</dl>
+ 	</fieldset>
+ 
+@@ -96,7 +89,7 @@
+ 			<span class="small">{{ lang('PST_FORUM_INFO') }}</span>
+ 			<div style="overflow: auto; max-height: 300px;">
+ 				<table class="table1">
+-					<colgroup><col class="row1"><col class="row2"><col class="row1"><col class="row2"></colgroup>
++					<colgroup><col class="row1" /><col class="row2" /><col class="row1" /><col class="row2" /></colgroup>
+ 					<thead>
+ 						<tr>
+ 							<th>{{ lang('FORUMS') }}</th>
+@@ -111,18 +104,18 @@
+ 							<td>
+ 								<strong><a href="{{ forums.U_FORUM }}">{{ forums.FORUM_NAME }}</a></strong>
+ 							</td>
+-							<td style="text-align: center; width: 20%;" title="{{ lang('PST_NOSHOW_TITLE')|e('html_attr') }} {{ forums.FORUM_NAME|e('html_attr') }}">
++							<td style="text-align: center; width: 20%;" title="{{ lang('PST_NOSHOW_TITLE') }} {{ forums.FORUM_NAME }}">
+ 								<label>
+-									<input type="checkbox" class="radio" name="mark_noshow_forum[]" value="{{ forums.FORUM_ID }}" {{ forums.CHECKED_NOSHOW_FORUM }}>
++									<input type="checkbox" class="radio" name="mark_noshow_forum[]" value="{{ forums.FORUM_ID }}" {{ forums.CHECKED_NOSHOW_FORUM }} />
+ 								</label>
+ 							</td>
+-							<td style="text-align: center; width: 20%;" title="{{ lang('PST_IGNORE_TITLE')|e('html_attr') }} {{ forums.FORUM_NAME|e('html_attr') }}">
++							<td style="text-align: center; width: 20%;" title="{{ lang('PST_IGNORE_TITLE') }} {{ forums.FORUM_NAME }}">
+ 								<label>
+-									<input type="checkbox" class="radio" name="mark_ignore_forum[]" value="{{ forums.FORUM_ID }}" {{ forums.CHECKED_IGNORE_FORUM }}>
++									<input type="checkbox" class="radio" name="mark_ignore_forum[]" value="{{ forums.FORUM_ID }}" {{ forums.CHECKED_IGNORE_FORUM }} />
+ 								</label>
+ 							</td>
+-							<td style="text-align: center; width: 20%;" title="{{ lang('PST_ADVANCED_TITLE')|e('html_attr') }} {{ forums.FORUM_NAME|e('html_attr') }}">
+-							<a href="{{ forums.U_ADVANCED }}">{% if forums.S_IS_ADVANCED %}<strong>{{ lang('PST_ADVANCED') }}</strong>{% else %}{{ lang('PST_STANDARD') }}{% endif %}</a>
++							<td style="text-align: center; width: 20%;" title="{{ lang('PST_ADVANCED_TITLE') }} {{ forums.FORUM_NAME }}">
++							<a href="{{ forums.U_ADVANCED }}">{% if forums.S_IS_ADVANCED %}<strong>{{ lang('PST_ADVANCED') }}</strong>{% else %}{{ lang('PST_STANDARD') }}</a>{% endif %}
+ 							</td>
+ 						</tr>
+ 						{% endfor %}
+@@ -135,12 +128,12 @@
+ 	<fieldset>
+ 		<legend>{{ lang('PST_LEGEND4') }}</legend>
+ 		<dl>
+-			<dt><label for="pst_words">{{ lang('PST_WORDS') ~ lang('COLON') }}</label><br><span>{{ lang('PST_WORDS_EXPLAIN') }}</span></dt>
++			<dt><label for="pst_words">{{ lang('PST_WORDS') ~ lang('COLON') }}</label><br /><span>{{ lang('PST_WORDS_EXPLAIN') }}</span></dt>
+ 			<dd><textarea name="pst_words" id="pst_words" rows="5" cols="40">{{ PST_WORDS }}</textarea></dd>
+ 		</dl>
+ 		{% if loops.postgres_ts_names %}
+ 			<dl>
+-				<dt><label for="pst_postgres_ts_name">{{ lang('FULLTEXT_POSTGRES_TS_NAME') }}</label><br><span>{{ lang('FULLTEXT_POSTGRES_TS_NAME_EXPLAIN') }}</span></dt>
++				<dt><label for="pst_postgres_ts_name">{{ lang('FULLTEXT_POSTGRES_TS_NAME') }}</label><br /><span>{{ lang('FULLTEXT_POSTGRES_TS_NAME_EXPLAIN') }}</span></dt>
+ 				<dd>
+ 					<select name="pst_postgres_ts_name" id="pst_postgres_ts_name">
+ 						{% for ts_name in loops.postgres_ts_names %}
+@@ -155,8 +148,8 @@
+ 	<fieldset>
+ 		<legend>{{ lang('ACP_SUBMIT_CHANGES') }}</legend>
+ 		<p class="submit-buttons">
+-			<input class="button1" type="submit" id="submit" name="submit" value="{{ lang('SUBMIT') }}">&nbsp;
+-			<input class="button2" type="reset" id="reset" name="reset" value="{{ lang('RESET') }}">
++			<input class="button1" type="submit" id="submit" name="submit" value="{{ lang('SUBMIT') }}" />&nbsp;
++			<input class="button2" type="reset" id="reset" name="reset" value="{{ lang('RESET') }}" />
+ 		</p>
+ 		{{ S_FORM_TOKEN }}
+ 	</fieldset>
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/composer.json"
+index 19c72b2a6..c5613f687 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/composer.json"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/composer.json"
+@@ -3,7 +3,7 @@
+     "type": "phpbb-extension",
+     "description": "A phpBB extension that displays a list of similar (related) topics at the bottom of the current topic's page.",
+     "homepage": "https://github.com/iMattPro/similartopics",
+-    "version": "1.7.0",
++    "version": "1.6.0",
+     "keywords": [
+         "phpbb",
+         "extension",
+@@ -20,7 +20,7 @@
+     ],
+     "require": {
+         "php": ">=5.4",
+-        "composer/installers": "~1.0",
++        "composer/installers": "~1.0.0",
+         "phpbb/phpbb": ">=3.2.1"
+     },
+     "extra": {
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/config/routing.yml" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/config/routing.yml"
+deleted file mode 100644
+index 3a3d08730..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/config/routing.yml"
++++ /dev/null
+@@ -1,6 +0,0 @@
+-vse_similartopics_ajax_search:
+-    path: /similartopics/ajax/search
+-    defaults: { _controller: vse.similartopics.ajax.controller:search_similar_topics }
+-    methods: [GET]
+-    requirements:
+-        _format: json
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/config/services.yml" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/config/services.yml"
+index 9acfe7b01..8d651ffcd 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/config/services.yml"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/config/services.yml"
+@@ -8,13 +8,13 @@ services:
+             - '@config_text'
+             - '@dbal.conn'
+             - '@dispatcher'
++            - '@ext.manager'
+             - '@language'
+             - '@pagination'
+             - '@request'
+             - '@template'
+             - '@user'
+             - '@content.visibility'
+-            - '@vse.similartopics.stop_word_helper'
+             - '@vse.similartopics.driver.manager'
+             - '%core.root_path%'
+             - '%core.php_ext%'
+@@ -23,8 +23,6 @@ services:
+         class: vse\similartopics\event\listener
+         arguments:
+             - '@vse.similartopics.manager'
+-            - '@controller.helper'
+-            - '@template'
+         tags:
+             - { name: event.listener }
+ 
+@@ -61,28 +59,13 @@ services:
+             - '%core.root_path%'
+             - '%core.php_ext%'
+ 
+-    vse.similartopics.stop_word_helper:
+-        class: vse\similartopics\core\stop_word_helper
+-        public: false
+-        arguments:
+-            - '@cache.driver'
+-            - '@ext.manager'
+-            - '@user'
+-            - '%core.php_ext%'
+-
+-    vse.similartopics.ajax.controller:
+-        class: vse\similartopics\controller\ajax_controller
+-        arguments:
+-            - '@request'
+-            - '@vse.similartopics.manager'
+-
+ # ----- Similar topics DB drivers collection -----
+     vse.similartopics.driver_collection:
+         class: phpbb\di\service_collection
+         arguments:
+             - '@service_container'
+         tags:
+-            - { name: service_collection, tag: vse.similartopics.driver }
++            - { name: service_collection, tag: vse.similartopcs.driver }
+ 
+     vse.similartopics.driver.postgres:
+         class: vse\similartopics\driver\postgres
+@@ -90,50 +73,17 @@ services:
+             - '@dbal.conn'
+             - '@config'
+         tags:
+-            - { name: vse.similartopics.driver }
++            - { name: vse.similartopcs.driver }
+ 
+     vse.similartopics.driver.mysqli:
+         class: vse\similartopics\driver\mysqli
+         arguments:
+             - '@dbal.conn'
+         tags:
+-            - { name: vse.similartopics.driver }
++            - { name: vse.similartopcs.driver }
+ 
+     vse.similartopics.driver.mysql4:
+         class: vse\similartopics\driver\mysql4
+         parent: vse.similartopics.driver.mysqli
+         tags:
+-            - { name: vse.similartopics.driver }
+-
+-    vse.similartopics.driver.sqlite3:
+-        class: vse\similartopics\driver\sqlite3
+-        arguments:
+-            - '@dbal.conn'
+-        tags:
+-            - { name: vse.similartopics.driver }
+-
+-    vse.similartopics.driver.mssql:
+-        class: vse\similartopics\driver\mssql
+-        arguments:
+-            - '@dbal.conn'
+-        tags:
+-            - { name: vse.similartopics.driver }
+-
+-    vse.similartopics.driver.mssqlnative:
+-        class: vse\similartopics\driver\mssqlnative
+-        parent: vse.similartopics.driver.mssql
+-        tags:
+-            - { name: vse.similartopics.driver }
+-
+-    vse.similartopics.driver.mssql_odbc:
+-        class: vse\similartopics\driver\mssql_odbc
+-        parent: vse.similartopics.driver.mssql
+-        tags:
+-            - { name: vse.similartopics.driver }
+-
+-    vse.similartopics.driver.oracle:
+-        class: vse\similartopics\driver\oracle
+-        arguments:
+-            - '@dbal.conn'
+-        tags:
+-            - { name: vse.similartopics.driver }
++            - { name: vse.similartopcs.driver }
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/controller/ajax_controller.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/controller/ajax_controller.php"
+deleted file mode 100644
+index d49f853f1..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/controller/ajax_controller.php"
++++ /dev/null
+@@ -1,63 +0,0 @@
+-<?php
+-/**
+- *
+- * Precise Similar Topics
+- *
+- * @copyright (c) 2025 Matt Friedman
+- * @license GNU General Public License, version 2 (GPL-2.0)
+- *
+- */
+-
+-namespace vse\similartopics\controller;
+-
+-use phpbb\exception\http_exception;
+-use Symfony\Component\HttpFoundation\JsonResponse;
+-use phpbb\request\request;
+-use vse\similartopics\core\similar_topics;
+-
+-class ajax_controller
+-{
+-	/** @var request */
+-	protected $request;
+-
+-	/** @var similar_topics */
+-	protected $similar_topics;
+-
+-	/**
+-	 * Constructor
+-	 *
+-	 * @param request $request
+-	 * @param similar_topics $similar_topics
+-	 */
+-	public function __construct(request $request, similar_topics $similar_topics)
+-	{
+-		$this->request = $request;
+-		$this->similar_topics = $similar_topics;
+-	}
+-
+-	/**
+-	 * Handle AJAX request for similar topics search
+-	 *
+-	 * @return JsonResponse
+-	 * @throws http_exception
+-	 */
+-	public function search_similar_topics()
+-	{
+-		if (!$this->request->is_ajax())
+-		{
+-			throw new http_exception(403, 'NO_AUTH_OPERATION');
+-		}
+-
+-		$query = $this->request->variable('q', '', true);
+-		$forum_id = $this->request->variable('f', 0);
+-
+-		if (utf8_strlen($query) < 3 || !$this->similar_topics->is_dynamic_available())
+-		{
+-			return new JsonResponse(['topics' => []]);
+-		}
+-
+-		$topics = $this->similar_topics->search_similar_topics_ajax($query, $forum_id);
+-
+-		return new JsonResponse(['topics' => $topics]);
+-	}
+-}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/core/similar_topics.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/core/similar_topics.php"
+index 72de4b84e..946730c0f 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/core/similar_topics.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/core/similar_topics.php"
+@@ -17,6 +17,7 @@ use phpbb\config\db_text;
+ use phpbb\content_visibility;
+ use phpbb\db\driver\driver_interface as db;
+ use phpbb\event\dispatcher_interface as dispatcher;
++use phpbb\extension\manager as ext_manager;
+ use phpbb\language\language;
+ use phpbb\pagination;
+ use phpbb\request\request;
+@@ -45,6 +46,9 @@ class similar_topics
+ 	/** @var dispatcher */
+ 	protected $dispatcher;
+ 
++	/** @var ext_manager */
++	protected $extension_manager;
++
+ 	/** @var language */
+ 	protected $language;
+ 
+@@ -63,9 +67,6 @@ class similar_topics
+ 	/** @var content_visibility */
+ 	protected $content_visibility;
+ 
+-	/** @var stop_word_helper */
+-	protected $stop_word_helper;
+-
+ 	/** @var similartopics_driver */
+ 	protected $similartopics;
+ 
+@@ -84,22 +85,22 @@ class similar_topics
+ 	 * @access public
+ 	 * @param auth                  $auth
+ 	 * @param cache                 $cache
+-	 * @param config                 $config
++	 * @param config                $config
+ 	 * @param db_text               $config_text
+ 	 * @param db                    $db
+ 	 * @param dispatcher            $dispatcher
++	 * @param ext_manager           $extension_manager
+ 	 * @param language              $language
+ 	 * @param pagination            $pagination
+ 	 * @param request               $request
+ 	 * @param template              $template
+ 	 * @param user                  $user
+ 	 * @param content_visibility    $content_visibility
+-	 * @param stop_word_helper      $stop_word_helper
+ 	 * @param similartopics_manager $similartopics_manager
+ 	 * @param string                $root_path
+ 	 * @param string                $php_ext
+ 	 */
+-	public function __construct(auth $auth, cache $cache, config $config, db_text $config_text, db $db, dispatcher $dispatcher, language $language, pagination $pagination, request $request, template $template, user $user, content_visibility $content_visibility, stop_word_helper $stop_word_helper, similartopics_manager $similartopics_manager, $root_path, $php_ext)
++	public function __construct(auth $auth, cache $cache, config $config, db_text $config_text, db $db, dispatcher $dispatcher, ext_manager $extension_manager, language $language, pagination $pagination, request $request, template $template, user $user, content_visibility $content_visibility, similartopics_manager $similartopics_manager, $root_path, $php_ext)
+ 	{
+ 		$this->auth = $auth;
+ 		$this->cache = $cache;
+@@ -107,7 +108,7 @@ class similar_topics
+ 		$this->config_text = $config_text;
+ 		$this->db = $db;
+ 		$this->dispatcher = $dispatcher;
+-		$this->stop_word_helper = $stop_word_helper;
++		$this->extension_manager = $extension_manager;
+ 		$this->language = $language;
+ 		$this->pagination = $pagination;
+ 		$this->request = $request;
+@@ -153,28 +154,6 @@ class similar_topics
+ 		return !empty($this->user->data['user_similar_topics']) && $this->auth->acl_get('u_similar_topics');
+ 	}
+ 
+-	/**
+-	 * Is dynamic similar topics available?
+-	 *
+-	 * @access public
+-	 * @return bool True if available, false otherwise
+-	 */
+-	public function is_dynamic_available()
+-	{
+-		return $this->is_dynamic_enabled() && $this->is_viewable() && $this->similartopics !== null;
+-	}
+-
+-	/**
+-	 * Is dynamic similar topics enabled?
+-	 *
+-	 * @access public
+-	 * @return bool True if enabled, false otherwise
+-	 */
+-	public function is_dynamic_enabled()
+-	{
+-		return !empty($this->config['similar_topics_dynamic']) && !empty($this->config['similar_topics_limit']);
+-	}
+-
+ 	/**
+ 	 * Get similar topics by matching topic titles
+ 	 * Loosely based on viewforum.php lines 840-1040
+@@ -194,9 +173,7 @@ class similar_topics
+ 			return;
+ 		}
+ 
+-		$this->stop_word_helper->set_use_localized($this->get_localized_ignore_words());
+-		$this->stop_word_helper->set_additional_ignore_words($this->get_additional_ignore_words());
+-		$topic_title = $this->stop_word_helper->clean_text($topic_data['topic_title']);
++		$topic_title = $this->clean_topic_title($topic_data['topic_title']);
+ 
+ 		// If the cleaned up topic_title is empty, no need to continue
+ 		if (empty($topic_title))
+@@ -322,7 +299,6 @@ class similar_topics
+ 				$u_mcp_queue = ($topic_unapproved || $posts_unapproved) ? append_sid("{$this->root_path}mcp.$this->php_ext", 'i=queue&amp;mode=' . ($topic_unapproved ? 'approve_details' : 'unapproved_posts') . "&amp;t=$similar_topic_id", true, $this->user->session_id) : '';
+ 
+ 				$base_url = append_sid("{$this->root_path}viewtopic.$this->php_ext", $view_topic_url_params);
+-
+ 				$topic_row = array(
+ 					'TOPIC_AUTHOR_FULL'			=> get_username_string('full', $row['topic_poster'], $row['topic_first_poster_name'], $row['topic_first_poster_colour']),
+ 					'FIRST_POST_TIME'			=> $this->user->format_date($row['topic_time']),
+@@ -333,6 +309,7 @@ class similar_topics
+ 
+ 					'TOPIC_REPLIES'			=> $replies,
+ 					'TOPIC_VIEWS'			=> $row['topic_views'],
++					'TOPIC_ANSWERED'		=> ($this->extension_manager->is_enabled('kinerity/bestanswer')) && $row['answer_post_id'] ? true : false,
+ 					'TOPIC_TITLE'			=> censor_text($row['topic_title']),
+ 					'FORUM_TITLE'			=> $row['forum_name'],
+ 
+@@ -377,7 +354,7 @@ class similar_topics
+ 			}
+ 		}
+ 
+-		$this->add_language();
++		$this->language->add_lang('similar_topics', 'vse/similartopics');
+ 
+ 		$this->template->assign_vars(array(
+ 			'NEWEST_POST_IMG'	=> $this->user->img('icon_topic_newest', 'VIEW_NEWEST_POST'),
+@@ -388,96 +365,130 @@ class similar_topics
+ 	}
+ 
+ 	/**
+-	 * Add lang files for similar topics
++	 * Clean topic title (and if needed, ignore-words)
+ 	 *
+-	 * @return void
++	 * @access public
++	 * @param string $text The topic title
++	 * @return string The topic title
+ 	 */
+-	public function add_language()
++	public function clean_topic_title($text)
+ 	{
+-		$this->language->add_lang('similar_topics', 'vse/similartopics');
+-	}
++		// Strip quotes, ampersands
++		$text = str_replace(array('&quot;', '&amp;'), '', $text);
++
++		// UTF Emojis
++		$regex_emoticons = '/[\x{1F600}-\x{1F64F}]/u';
++		$text = preg_replace($regex_emoticons, '', $text);
++
++		// Match Miscellaneous Symbols and Pictographs
++		$regex_symbols = '/[\x{1F300}-\x{1F5FF}]/u';
++		$text = preg_replace($regex_symbols, '', $text);
++
++		// Match Transport And Map Symbols
++		$regex_transport = '/[\x{1F680}-\x{1F6FF}]/u';
++		$text = preg_replace($regex_transport, '', $text);
++
++		// Match Miscellaneous Symbols
++		$regex_misc = '/[\x{2600}-\x{26FF}]/u';
++		$text = preg_replace($regex_misc, '', $text);
++
++		// Match Dingbats
++		$regex_dingbats = '/[\x{2700}-\x{27BF}]/u';
++		$text = preg_replace($regex_dingbats, '', $text);
++
++		$regex_bbemoji = '(:([-+_a-z0-9]+):(?!\\w|[^<>]*(?=>|</code>)))';
++		$matches = [];
++		preg_match_all($regex_bbemoji, $text, $matches);
++		foreach ($matches[0] as $emoji) {
++			$text = str_replace($emoji, '', $text);
++		}
+ 
+-	/**
+-	 * Check if we should load localized ignore words
+-	 *
+-	 * @access protected
+-	 * @return bool True if non-English language or using a dbms with no stop-words
+-	 */
+-	protected function get_localized_ignore_words()
+-	{
+-		return !in_array($this->user->lang_name, ['en', 'en_us'], true) || !$this->similartopics->has_stopword_support();
++		$text = trim($text);
++
++		if (!$this->english_lang() || $this->get_ignore_words())
++		{
++			$text = $this->strip_stop_words($text);
++		}
++
++		return $text;
+ 	}
+ 
+ 	/**
+-	 * Search for similar topics via AJAX for dynamic suggestions
++	 * Remove any non-english and/or custom defined ignore-words
+ 	 *
+-	 * @param string $query The search query
+-	 * @param int $forum_id The forum ID to search from
+-	 * @return array Array of similar topics
++	 * @access protected
++	 * @param string $text The topic title
++	 * @return string The topic title
+ 	 */
+-	public function search_similar_topics_ajax($query, $forum_id = 0)
++	protected function strip_stop_words($text)
+ 	{
+-		$this->stop_word_helper->set_use_localized($this->get_localized_ignore_words());
+-		$this->stop_word_helper->set_additional_ignore_words($this->get_additional_ignore_words());
+-		$cleaned_query = $this->stop_word_helper->clean_text($query);
++		$words = array();
+ 
+-		if (empty($cleaned_query))
++		// If non-English, look for a list of stop-words to be ignored
++		// in either the core or the extension (deprecated from core)
++		if (!$this->english_lang())
+ 		{
+-			return [];
++			$finder = $this->extension_manager->get_finder();
++			$search_ignore_words = $finder
++				->set_extensions(array('vse/similartopics'))
++				->prefix('search_ignore_words')
++				->suffix(".$this->php_ext")
++				->extension_directory("/language/{$this->user->lang_name}")
++				->core_path("language/{$this->user->lang_name}/")
++				->get_files();
++			if (current($search_ignore_words))
++			{
++				include current($search_ignore_words);
++			}
+ 		}
+ 
+-		$sensitivity = $this->config->offsetExists('similar_topics_sense') ? number_format($this->config['similar_topics_sense'] / 10, 1, '.', '') : '0.5';
+-		$sql_array = $this->similartopics->get_query(0, $cleaned_query, $this->config['similar_topics_time'], $sensitivity);
+-
+-		$similar_topic_forums = null;
+-		if ($forum_id > 0)
++		if ($this->get_ignore_words())
+ 		{
+-			$sql = 'SELECT similar_topic_forums
+-				FROM ' . FORUMS_TABLE . '
+-				WHERE forum_id = ' . (int) $forum_id;
+-			$result = $this->db->sql_query($sql, 3600);
+-			$similar_topic_forums = $this->db->sql_fetchfield('similar_topic_forums');
+-			$this->db->sql_freeresult($result);
++			// Merge any custom defined ignore words from the ACP to the stop-words array
++			$words = array_merge($this->make_word_array($this->get_ignore_words()), $words);
+ 		}
+ 
+-		$passworded_forums = $this->user->get_passworded_forums();
++		// Remove stop-words from the topic title text
++		$words = array_diff($this->make_word_array($text), $words);
+ 
+-		if (!empty($similar_topic_forums))
+-		{
+-			$included_forums = array_diff(json_decode($similar_topic_forums, true), $passworded_forums);
+-			if (empty($included_forums))
+-			{
+-				return [];
+-			}
+-			$sql_array['WHERE'] .= ' AND ' . $this->db->sql_in_set('f.forum_id', $included_forums);
+-		}
+-		else
+-		{
+-			if (count($passworded_forums))
+-			{
+-				$sql_array['WHERE'] .= ' AND ' . $this->db->sql_in_set('f.forum_id', $passworded_forums, true);
+-			}
+-			$sql_array['WHERE'] .= ' AND f.similar_topics_ignore = 0';
+-		}
++		// Convert our words array back to a string
++		return implode(' ', $words);
++	}
+ 
+-		$topics = [];
+-		$sql = $this->db->sql_build_query('SELECT', $sql_array);
+-		$result = $this->db->sql_query_limit($sql, 5);
++	/**
++	 * Helper function to split string into an array of words
++	 *
++	 * @access protected
++	 * @param string $text String of plain text words
++	 * @return array Array of plaintext words
++	 */
++	protected function make_word_array($text)
++	{
++		// Strip out any non-alpha-numeric characters using PCRE regex syntax
++		$text = trim(preg_replace('#[^\p{L}\p{N}]+#u', ' ', $text));
+ 
+-		while ($row = $this->db->sql_fetchrow($result))
++		$words = explode(' ', utf8_strtolower($text));
++		foreach ($words as $key => $word)
+ 		{
+-			if ($this->auth->acl_get('f_read', (int) $row['forum_id']))
++			// Strip words of 2 characters or fewer
++			if (utf8_strlen(trim($word)) < 3)
+ 			{
+-				$topics[] = [
+-					'id' => (int) $row['topic_id'],
+-					'title' => censor_text($row['topic_title']),
+-					'url' => append_sid("{$this->root_path}viewtopic.$this->php_ext", 't=' . $row['topic_id'])
+-				];
++				unset($words[$key]);
+ 			}
+ 		}
+-		$this->db->sql_freeresult($result);
+ 
+-		return $topics;
++		return $words;
++	}
++
++	/**
++	 * Check if English is the current user's language
++	 *
++	 * @access protected
++	 * @return bool True if lang is 'en' or 'en_us', false otherwise
++	 */
++	protected function english_lang()
++	{
++		return ($this->user->lang_name === 'en' || $this->user->lang_name === 'en_us');
+ 	}
+ 
+ 	/**
+@@ -486,7 +497,7 @@ class similar_topics
+ 	 * @access protected
+ 	 * @return string|null String of ignore words or null if there are none defined
+ 	 */
+-	protected function get_additional_ignore_words()
++	protected function get_ignore_words()
+ 	{
+ 		$key = 'similar_topics_words';
+ 
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/core/stop_word_helper.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/core/stop_word_helper.php"
+deleted file mode 100644
+index 2af488e1a..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/core/stop_word_helper.php"
++++ /dev/null
+@@ -1,198 +0,0 @@
+-<?php
+-/**
+- *
+- * Precise Similar Topics
+- *
+- * @copyright (c) 2025 Matt Friedman
+- * @license GNU General Public License, version 2 (GPL-2.0)
+- *
+- */
+-
+-namespace vse\similartopics\core;
+-
+-use phpbb\cache\driver\driver_interface as cache_driver;
+-use phpbb\extension\manager as ext_manager;
+-use phpbb\user;
+-
+-/**
+- * A helper class to clean text and remove stop words (localized and additional)
+- * for topic titles or other search-related strings.
+- */
+-class stop_word_helper
+-{
+-	/** @var cache_driver */
+-	protected $cache;
+-
+-	/** @var ext_manager */
+-	protected $extension_manager;
+-
+-	/** @var user */
+-	protected $user;
+-
+-	/** @var string */
+-	protected $php_ext;
+-
+-	/** @var array|null Lookup table for fast filtering */
+-	protected $ignore_lookup;
+-
+-	/** @var bool Whether localized ignore words should be loaded */
+-	protected $use_localized = false;
+-
+-	/** @var string Additional ignore words string */
+-	protected $additional_ignore = '';
+-
+-	/** @var bool Whether ignore words need to be reloaded */
+-	protected $needs_reload = true;
+-
+-	/**
+-	 * Constructor
+-	 *
+-	 * @param cache_driver $cache
+-	 * @param ext_manager $extension_manager
+-	 * @param user $user
+-	 * @param string $php_ext
+-	 */
+-	public function __construct(cache_driver $cache, ext_manager $extension_manager, user $user, $php_ext)
+-	{
+-		$this->cache = $cache;
+-		$this->extension_manager = $extension_manager;
+-		$this->user = $user;
+-		$this->php_ext = $php_ext;
+-	}
+-
+-	/**
+-	 * Set additional ignore words
+-	 *
+-	 * @param string $words
+-	 */
+-	public function set_additional_ignore_words($words)
+-	{
+-		if ($this->additional_ignore !== $words)
+-		{
+-			$this->additional_ignore = $words;
+-			$this->needs_reload = true;
+-		}
+-	}
+-
+-	/**
+-	 * Set whether to use localized ignore words
+-	 *
+-	 * @param bool $value
+-	 */
+-	public function set_use_localized($value)
+-	{
+-		$value = (bool) $value;
+-		if ($this->use_localized !== $value)
+-		{
+-			$this->use_localized = $value;
+-			$this->needs_reload = true;
+-		}
+-	}
+-
+-	/**
+-	 * Clean text (strip quotes, ampersands, stop words)
+-	 *
+-	 * @param string $text
+-	 * @return string
+-	 */
+-	public function clean_text($text)
+-	{
+-		// Strip HTML entities
+-		$text = str_replace(['&quot;', '&amp;'], '', $text);
+-
+-		if ($this->use_localized || !empty($this->additional_ignore))
+-		{
+-			$this->load_ignore_words();
+-			$filtered = array_filter(
+-				$this->make_word_array($text, true),
+-				[$this, 'filter_ignore_words']
+-			);
+-			$text = implode(' ', array_unique($filtered));
+-		}
+-
+-		return $text;
+-	}
+-
+-	/**
+-	 * Load ignore words into memory and build a lookup table
+-	 */
+-	protected function load_ignore_words()
+-	{
+-		if ($this->needs_reload || $this->ignore_lookup === null)
+-		{
+-			// The cache will be invalidated when language, localized setting, or additional words change
+-			$cache_key = '_pst_ignore_' . md5($this->user->lang_name . '|' . (int) $this->use_localized . '|' . $this->additional_ignore);
+-			$this->ignore_lookup = $this->cache->get($cache_key);
+-
+-			if ($this->ignore_lookup === false)
+-			{
+-				// Load localized ignore words (if needed)
+-				$words = $this->use_localized ? $this->load_localized_words() : [];
+-
+-				// Load additional ignore words (if defined)
+-				if (!empty($this->additional_ignore))
+-				{
+-					$words = array_merge($words, $this->make_word_array($this->additional_ignore));
+-				}
+-
+-				$this->ignore_lookup = array_flip(array_unique($words));
+-				$this->cache->put($cache_key, $this->ignore_lookup);
+-			}
+-
+-			$this->needs_reload = false;
+-		}
+-	}
+-
+-	/**
+-	 * Load localized ignore words
+-	 *
+-	 * @return array An array of ignore-words from the user's language pack
+-	 */
+-	protected function load_localized_words()
+-	{
+-		$words = [];
+-		$finder = $this->extension_manager->get_finder();
+-		$files = $finder
+-			->set_extensions(['vse/similartopics'])
+-			->prefix('search_ignore_words')
+-			->suffix('.' . $this->php_ext)
+-			->extension_directory("/language/{$this->user->lang_name}")
+-			->core_path("language/{$this->user->lang_name}/")
+-			->get_files();
+-
+-		if (current($files))
+-		{
+-			include current($files);
+-		}
+-
+-		return $words;
+-	}
+-
+-	/**
+-	 * Split text into a word array
+-	 *
+-	 * @param string $text A string of text
+-	 * @param bool $filter_short Whether to filter out words < 3 characters
+-	 * @return array The original string of text, filtered into an array of individual words
+-	 */
+-	protected function make_word_array($text, $filter_short = false)
+-	{
+-		$text = trim(preg_replace('#[^\p{L}\p{N}]+#u', ' ', $text));
+-		$words = array_filter(explode(' ', utf8_strtolower($text)));
+-
+-		return $filter_short ? array_filter($words, static function($word) {
+-			return utf8_strlen($word) >= 3;
+-		}) : $words;
+-	}
+-
+-	/**
+-	 * Filter callback for array_filter to exclude stop words
+-	 *
+-	 * @param string $word Word to check
+-	 * @return bool True to keep a word, false to remove it
+-	 */
+-	protected function filter_ignore_words($word)
+-	{
+-		return !isset($this->ignore_lookup[$word]);
+-	}
+-}
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/diff_full.tmp"
+new file mode 100644
+index 000000000..1c7e2258d
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/diff_full.tmp"
+@@ -0,0 +1,974 @@
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/CHANGELOG.md" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/CHANGELOG.md"
++index dcfad82c4..378efc1d0 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/CHANGELOG.md"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/CHANGELOG.md"
++@@ -1,18 +1,10 @@
++ ## Changelog
++ 
++-### 1.7.0 - 2025-12-16
++-
++-- NEW FEATURE: Dynamically show similar topics to users as they title their new posts.
++-- IMPROVEMENT: Support for MSSQL, SQLite3 and Oracle databases added.
++-- IMPROVEMENT: Added stop-word filtering for Postgres databases using the 'simple' dictionary.
++-- Added missing stop-word filters (AI-translated) for Hebrew, Persian, Japanese, Swedish and Turkish languages.
++-- Fixed and optimized lots of code when processing similar topics.
++-
++ ### 1.6.0 - 2022-12-17
++ 
++ - Removed support for phpBB 3.1.x.
++ - Removed forum "f=" parameters from URLs.
++-- Optimized JavaScript and other coding updates.
+++- Optimized Javascript and other coding updates.
++ - Support added for ScaffoldBB style.
++ 
++ ### 1.5.4 - 2020-12-01
++@@ -20,11 +12,11 @@
++ - Fix for Postgresql databases where titles with single quotes would fatally error.
++ - Enabled AJAX interactions when saving settings in the ACP.
++ - Re-wrote the search period explanation in the ACP settings.
++-- Switched to using the phpBB finder to locate foreign language ignore words files.
+++- Switched to using phpBB finder to locate foreign language ignore words files.
++ 
++ ### 1.5.3 - 2020-01-10
++ 
++-- Compatibility issues with Prosilver styles are addressed.
+++- Compatibility issues with Prosilver styles addressed.
++ - Installation errors on phpBB 3.3.x will be reported to the user.
++ 
++ ### 1.5.2 - 2019-06-26
++@@ -35,18 +27,18 @@
++ 
++ ### 1.5.1 - 2018-06-01
++ 
++-- Fixed an issue where PHP using European decimal notation (comma instead of a period) could cause an SQL error.
++-- Minor code fixes based on the phpBB Extension team validation report.
+++- Fixed an issue where PHP using European decimal notation (comma instead of period) could cause an SQL error.
+++- Minor code fixes based on phpBB Extension team validation report.
++ 
++ ### 1.5.0 - 2018-03-14
++ 
++ - Added support for forums using PostgreSQL databases (with thanks to hubaishan).
++ - Fixed a layout bug with the pagination buttons introduced in phpBB 3.2.2.
++-- Fixed a potential SQL error bug when installing.
+++- Fixed potential SQL error bug when installing.
++ 
++ ### 1.4.3 - 2018-01-03
++ 
++-- Added a new setting: Search Sensitivity. Allows users to adjust the weighting of similar topics matches. This was added because InnoDB, which is now supported, weights results differently than MyISAM. This will allow users with InnoDB tables to improve their similar topics results by lowering the weighting/sensitivity.
+++- Added a new setting: Search Sensitivity. Allows users to adjust the weighting of similar topics matches. This was added because InnoDB which is now supported, weights results differently than MyISAM. This will allow users with InnoDB tables to improve their similar topics results by lowering the weighting/sensitivity.
++ - Converted all template syntax to Twig format.
++ 
++ ### 1.4.2 - 2017-03-18
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/acp/controller/similar_topics_admin.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/acp/controller/similar_topics_admin.php"
++index 85c505289..4e2b5441e 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/acp/controller/similar_topics_admin.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/acp/controller/similar_topics_admin.php"
++@@ -157,7 +157,6 @@ class similar_topics_admin
++ 
++ 			// Set basic config settings
++ 			$this->config->set('similar_topics', $this->request->variable('pst_enable', 0));
++-			$this->config->set('similar_topics_dynamic', $this->request->variable('pst_dynamic', 0));
++ 			$this->config->set('similar_topics_limit', abs($this->request->variable('pst_limit', 0))); // use abs for positive values only
++ 			$this->config->set('similar_topics_cache', abs($this->request->variable('pst_cache', 0))); // use abs for positive values only
++ 			$this->config_text_set('similar_topics_words', $this->request->variable('pst_words', '', true));
++@@ -209,22 +208,20 @@ class similar_topics_admin
++ 
++ 		$this->template->assign_vars(array(
++ 			'S_PST_ENABLE'    => $this->isset_or_default($this->config['similar_topics'], false),
++-			'S_PST_DYNAMIC'   => $this->isset_or_default($this->config['similar_topics_dynamic'], false),
++ 			'PST_LIMIT'       => $this->isset_or_default($this->config['similar_topics_limit'], ''),
++ 			'PST_CACHE'       => $this->isset_or_default($this->config['similar_topics_cache'], ''),
++ 			'PST_SENSE'       => $this->isset_or_default($this->config['similar_topics_sense'], ''),
++ 			'PST_WORDS'       => $this->isset_or_default($this->config_text_get('similar_topics_words'), ''),
++ 			'PST_TIME'        => $this->get_pst_time($this->config['similar_topics_time'], $this->config['similar_topics_type']),
++-			'PST_SENSITIVITY' => $this->similartopics && $this->similartopics->get_engine() === 'innodb' ? 1 : 5,
++ 			'S_PST_NO_COMPAT' => $this->similartopics === null || !$this->similartopics->is_fulltext('topic_title'),
++ 			'U_ACTION'        => $this->u_action,
++ 		));
++ 
++ 		// If postgresql, we need to make an options list of text search names
++-		if ($this->similartopics instanceof \vse\similartopics\driver\postgres)
+++		if ($this->similartopics && $this->similartopics->get_type() === 'postgres')
++ 		{
++ 			$this->language->add_lang('acp/search');
++-			foreach ($this->similartopics->get_cfg_name_list() as $row)
+++			foreach ($this->get_cfgname_list() as $row)
++ 			{
++ 				$this->template->assign_block_vars('postgres_ts_names', array(
++ 					'NAME'       => $row['ts_name'],
++@@ -269,8 +266,6 @@ class similar_topics_admin
++ 				WHERE forum_id = $forum_id";
++ 			$this->db->sql_query($sql);
++ 
++-			$this->cache->destroy('sql', FORUMS_TABLE);
++-
++ 			$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'PST_LOG_MSG');
++ 
++ 			$this->end('PST_SAVED');
++@@ -315,6 +310,22 @@ class similar_topics_admin
++ 		}
++ 	}
++ 
+++	/**
+++	 * Get list of PostgreSQL text search names
+++	 *
+++	 * @access protected
+++	 * @return array array of text search names
+++	 */
+++	protected function get_cfgname_list()
+++	{
+++		$sql = 'SELECT cfgname AS ts_name FROM pg_ts_config';
+++		$result = $this->db->sql_query($sql);
+++		$ts_options = $this->db->sql_fetchrowset($result);
+++		$this->db->sql_freeresult($result);
+++
+++		return $ts_options;
+++	}
+++
++ 	/**
++ 	 * Get forums list
++ 	 *
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/acp/similar_topics_module.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/acp/similar_topics_module.php"
++index 8e9408fa8..e0a74e17d 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/acp/similar_topics_module.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/acp/similar_topics_module.php"
++@@ -32,7 +32,9 @@ class similar_topics_module
++ 		global $phpbb_container;
++ 
++ 		$this->tpl_name = 'acp_similar_topics';
++-		$this->page_title = 'PST_TITLE_ACP';
+++
+++		$this->page_title = $phpbb_container->get('language')
+++			->lang('PST_TITLE_ACP');
++ 
++ 		$phpbb_container->get('vse.similartopics.acp.controller')
++ 			->set_u_action($this->u_action)
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/adm/style/acp_similar_topics.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/adm/style/acp_similar_topics.html"
++index 8f0c529db..0be73ff9f 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/adm/style/acp_similar_topics.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/adm/style/acp_similar_topics.html"
++@@ -20,13 +20,13 @@
++ 	<fieldset>
++ 		<legend>{{ lang('PST_ADVANCED_FORUM') }}</legend>
++ 		<dl>
++-			<dt><label for="similar_forums">{{ lang('FORUM') ~ lang('COLON') }} {{ PST_FORUM_NAME }}</label><br><br><span>{{ lang('PST_ADVANCED_EXP', PST_FORUM_NAME) }}</span></dt>
+++			<dt><label for="similar_forums">{{ lang('FORUM') ~ lang('COLON') }} {{ PST_FORUM_NAME }}</label><br /><br /><span>{{ lang('PST_ADVANCED_EXP', PST_FORUM_NAME) }}</span></dt>
++ 			<dd><select id="similar_forums" name="similar_forums_id[]" multiple="multiple" size="10">{{ SIMILAR_FORUMS_OPTIONS }}</select></dd>
++ 			<dd><a href="#" data-selector="false">{{ lang('PST_DESELECT_ALL') }}</a></dd>
++ 		</dl>
++ 		<p class="submit-buttons">
++-			<input class="button1" type="submit" id="submit" name="submit" value="{{ lang('SUBMIT') }}">&nbsp;
++-			<input class="button2" type="reset" id="reset" name="reset" value="{{ lang('RESET') }}">
+++			<input class="button1" type="submit" id="submit" name="submit" value="{{ lang('SUBMIT') }}" />&nbsp;
+++			<input class="button2" type="reset" id="reset" name="reset" value="{{ lang('RESET') }}" />
++ 		</p>
++ 		{{ S_FORM_TOKEN }}
++ 	</fieldset>
++@@ -47,17 +47,10 @@
++ 	<fieldset>
++ 		<legend>{{ lang('PST_LEGEND1') }}</legend>
++ 		<dl>
++-			<dt><label for="pst_enable">{{ lang('PST_ENABLE') ~ lang('COLON') }}</label><br><span>{{ lang('PST_ENABLE_EXPLAIN') }}</span></dt>
+++			<dt><label for="pst_enable">{{ lang('PST_ENABLE') ~ lang('COLON') }}</label></dt>
++ 			<dd>
++-				<label><input type="radio" class="radio" id="pst_enable" name="pst_enable" value="1"{% if S_PST_ENABLE %} checked="checked"{% endif %}{% if S_PST_NO_SUPPORT %} disabled="disabled"{% endif %}> {{ lang('YES') }}</label>
++-				<label><input type="radio" class="radio" name="pst_enable" value="0"{% if not S_PST_ENABLE %} checked="checked"{% endif %}> {{ lang('NO') }}</label>
++-			</dd>
++-		</dl>
++-		<dl>
++-			<dt><label for="pst_dynamic">{{ lang('PST_DYNAMIC') ~ lang('COLON') }}</label><br><span>{{ lang('PST_DYNAMIC_EXPLAIN') }}</span></dt>
++-			<dd>
++-				<label><input type="radio" class="radio" id="pst_dynamic" name="pst_dynamic" value="1"{% if S_PST_DYNAMIC %} checked="checked"{% endif %}> {{ lang('YES') }}</label>
++-				<label><input type="radio" class="radio" name="pst_dynamic" value="0"{% if not S_PST_DYNAMIC %} checked="checked"{% endif %}> {{ lang('NO') }}</label>
+++				<label><input type="radio" class="radio" id="pst_enable" name="pst_enable" value="1"{% if S_PST_ENABLE %} checked="checked"{% endif %}{% if S_PST_NO_SUPPORT %} disabled="disabled"{% endif %} /> {{ lang('YES') }}</label>
+++				<label><input type="radio" class="radio" name="pst_enable" value="0"{% if not S_PST_ENABLE %} checked="checked"{% endif %} /> {{ lang('NO') }}</label>
++ 			</dd>
++ 		</dl>
++ 	</fieldset>
++@@ -65,12 +58,12 @@
++ 	<fieldset>
++ 		<legend>{{ lang('PST_LEGEND2') }}</legend>
++ 		<dl>
++-			<dt><label for="pst_limit">{{ lang('PST_LIMIT') ~ lang('COLON') }}</label><br><span>{{ lang('PST_LIMIT_EXPLAIN') }}</span></dt>
++-			<dd><input name="pst_limit" id="pst_limit" type="number" min="0" max="999" value="{{ PST_LIMIT }}"></dd>
+++			<dt><label for="pst_limit">{{ lang('PST_LIMIT') ~ lang('COLON') }}</label><br /><span>{{ lang('PST_LIMIT_EXPLAIN') }}</span></dt>
+++			<dd><input name="pst_limit" id="pst_limit" type="number" min="0" max="999" value="{{ PST_LIMIT }}" /></dd>
++ 		</dl>
++ 		<dl>
++-			<dt><label for="pst_time">{{ lang('PST_TIME') ~ lang('COLON') }}</label><br><span>{{ lang('PST_TIME_EXPLAIN') }}</span></dt>
++-			<dd><input name="pst_time" id="pst_time" type="number" min="0" max="999" value="{{ PST_TIME }}">
+++			<dt><label for="pst_time">{{ lang('PST_TIME') ~ lang('COLON') }}</label><br /><span>{{ lang('PST_TIME_EXPLAIN') }}</span></dt>
+++			<dd><input name="pst_time" id="pst_time" type="number" min="0" max="999" value="{{ PST_TIME }}" />
++ 				<label>
++ 					<select name="pst_time_type">
++ 						{% for similar_time_options in loops.similar_time_options %}
++@@ -81,12 +74,12 @@
++ 			</dd>
++ 		</dl>
++ 		<dl>
++-			<dt><label for="pst_cache">{{ lang('PST_CACHE') ~ lang('COLON') }}</label><br><span>{{ lang('PST_CACHE_EXPLAIN') }}</span></dt>
++-			<dd><input name="pst_cache" id="pst_cache" type="number" min="0" max="99999999" value="{{ PST_CACHE }}"> {{ lang('SECONDS') }}</dd>
+++			<dt><label for="pst_cache">{{ lang('PST_CACHE') ~ lang('COLON') }}</label><br /><span>{{ lang('PST_CACHE_EXPLAIN') }}</span></dt>
+++			<dd><input name="pst_cache" id="pst_cache" type="number" min="0" max="99999999" value="{{ PST_CACHE }}" /> {{ lang('SECONDS') }}</dd>
++ 		</dl>
++ 		<dl>
++-			<dt><label for="pst_sense">{{ lang('PST_SENSE') ~ lang('COLON') }}</label><br><span>{{ lang('PST_SENSE_EXPLAIN', PST_SENSITIVITY) }}</span></dt>
++-			<dd><input name="pst_sense" id="pst_sense" type="number" min="1" max="10" value="{{ PST_SENSE }}"></dd>
+++			<dt><label for="pst_sense">{{ lang('PST_SENSE') ~ lang('COLON') }}</label><br /><span>{{ lang('PST_SENSE_EXPLAIN') }}</span></dt>
+++			<dd><input name="pst_sense" id="pst_sense" type="number" min="1" max="10" value="{{ PST_SENSE }}" /></dd>
++ 		</dl>
++ 	</fieldset>
++ 
++@@ -96,7 +89,7 @@
++ 			<span class="small">{{ lang('PST_FORUM_INFO') }}</span>
++ 			<div style="overflow: auto; max-height: 300px;">
++ 				<table class="table1">
++-					<colgroup><col class="row1"><col class="row2"><col class="row1"><col class="row2"></colgroup>
+++					<colgroup><col class="row1" /><col class="row2" /><col class="row1" /><col class="row2" /></colgroup>
++ 					<thead>
++ 						<tr>
++ 							<th>{{ lang('FORUMS') }}</th>
++@@ -111,18 +104,18 @@
++ 							<td>
++ 								<strong><a href="{{ forums.U_FORUM }}">{{ forums.FORUM_NAME }}</a></strong>
++ 							</td>
++-							<td style="text-align: center; width: 20%;" title="{{ lang('PST_NOSHOW_TITLE')|e('html_attr') }} {{ forums.FORUM_NAME|e('html_attr') }}">
+++							<td style="text-align: center; width: 20%;" title="{{ lang('PST_NOSHOW_TITLE') }} {{ forums.FORUM_NAME }}">
++ 								<label>
++-									<input type="checkbox" class="radio" name="mark_noshow_forum[]" value="{{ forums.FORUM_ID }}" {{ forums.CHECKED_NOSHOW_FORUM }}>
+++									<input type="checkbox" class="radio" name="mark_noshow_forum[]" value="{{ forums.FORUM_ID }}" {{ forums.CHECKED_NOSHOW_FORUM }} />
++ 								</label>
++ 							</td>
++-							<td style="text-align: center; width: 20%;" title="{{ lang('PST_IGNORE_TITLE')|e('html_attr') }} {{ forums.FORUM_NAME|e('html_attr') }}">
+++							<td style="text-align: center; width: 20%;" title="{{ lang('PST_IGNORE_TITLE') }} {{ forums.FORUM_NAME }}">
++ 								<label>
++-									<input type="checkbox" class="radio" name="mark_ignore_forum[]" value="{{ forums.FORUM_ID }}" {{ forums.CHECKED_IGNORE_FORUM }}>
+++									<input type="checkbox" class="radio" name="mark_ignore_forum[]" value="{{ forums.FORUM_ID }}" {{ forums.CHECKED_IGNORE_FORUM }} />
++ 								</label>
++ 							</td>
++-							<td style="text-align: center; width: 20%;" title="{{ lang('PST_ADVANCED_TITLE')|e('html_attr') }} {{ forums.FORUM_NAME|e('html_attr') }}">
++-							<a href="{{ forums.U_ADVANCED }}">{% if forums.S_IS_ADVANCED %}<strong>{{ lang('PST_ADVANCED') }}</strong>{% else %}{{ lang('PST_STANDARD') }}{% endif %}</a>
+++							<td style="text-align: center; width: 20%;" title="{{ lang('PST_ADVANCED_TITLE') }} {{ forums.FORUM_NAME }}">
+++							<a href="{{ forums.U_ADVANCED }}">{% if forums.S_IS_ADVANCED %}<strong>{{ lang('PST_ADVANCED') }}</strong>{% else %}{{ lang('PST_STANDARD') }}</a>{% endif %}
++ 							</td>
++ 						</tr>
++ 						{% endfor %}
++@@ -135,12 +128,12 @@
++ 	<fieldset>
++ 		<legend>{{ lang('PST_LEGEND4') }}</legend>
++ 		<dl>
++-			<dt><label for="pst_words">{{ lang('PST_WORDS') ~ lang('COLON') }}</label><br><span>{{ lang('PST_WORDS_EXPLAIN') }}</span></dt>
+++			<dt><label for="pst_words">{{ lang('PST_WORDS') ~ lang('COLON') }}</label><br /><span>{{ lang('PST_WORDS_EXPLAIN') }}</span></dt>
++ 			<dd><textarea name="pst_words" id="pst_words" rows="5" cols="40">{{ PST_WORDS }}</textarea></dd>
++ 		</dl>
++ 		{% if loops.postgres_ts_names %}
++ 			<dl>
++-				<dt><label for="pst_postgres_ts_name">{{ lang('FULLTEXT_POSTGRES_TS_NAME') }}</label><br><span>{{ lang('FULLTEXT_POSTGRES_TS_NAME_EXPLAIN') }}</span></dt>
+++				<dt><label for="pst_postgres_ts_name">{{ lang('FULLTEXT_POSTGRES_TS_NAME') }}</label><br /><span>{{ lang('FULLTEXT_POSTGRES_TS_NAME_EXPLAIN') }}</span></dt>
++ 				<dd>
++ 					<select name="pst_postgres_ts_name" id="pst_postgres_ts_name">
++ 						{% for ts_name in loops.postgres_ts_names %}
++@@ -155,8 +148,8 @@
++ 	<fieldset>
++ 		<legend>{{ lang('ACP_SUBMIT_CHANGES') }}</legend>
++ 		<p class="submit-buttons">
++-			<input class="button1" type="submit" id="submit" name="submit" value="{{ lang('SUBMIT') }}">&nbsp;
++-			<input class="button2" type="reset" id="reset" name="reset" value="{{ lang('RESET') }}">
+++			<input class="button1" type="submit" id="submit" name="submit" value="{{ lang('SUBMIT') }}" />&nbsp;
+++			<input class="button2" type="reset" id="reset" name="reset" value="{{ lang('RESET') }}" />
++ 		</p>
++ 		{{ S_FORM_TOKEN }}
++ 	</fieldset>
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/composer.json"
++index 19c72b2a6..c5613f687 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/composer.json"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/composer.json"
++@@ -3,7 +3,7 @@
++     "type": "phpbb-extension",
++     "description": "A phpBB extension that displays a list of similar (related) topics at the bottom of the current topic's page.",
++     "homepage": "https://github.com/iMattPro/similartopics",
++-    "version": "1.7.0",
+++    "version": "1.6.0",
++     "keywords": [
++         "phpbb",
++         "extension",
++@@ -20,7 +20,7 @@
++     ],
++     "require": {
++         "php": ">=5.4",
++-        "composer/installers": "~1.0",
+++        "composer/installers": "~1.0.0",
++         "phpbb/phpbb": ">=3.2.1"
++     },
++     "extra": {
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/config/routing.yml" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/config/routing.yml"
++deleted file mode 100644
++index 3a3d08730..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/config/routing.yml"
+++++ /dev/null
++@@ -1,6 +0,0 @@
++-vse_similartopics_ajax_search:
++-    path: /similartopics/ajax/search
++-    defaults: { _controller: vse.similartopics.ajax.controller:search_similar_topics }
++-    methods: [GET]
++-    requirements:
++-        _format: json
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/config/services.yml" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/config/services.yml"
++index 9acfe7b01..8d651ffcd 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/config/services.yml"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/config/services.yml"
++@@ -8,13 +8,13 @@ services:
++             - '@config_text'
++             - '@dbal.conn'
++             - '@dispatcher'
+++            - '@ext.manager'
++             - '@language'
++             - '@pagination'
++             - '@request'
++             - '@template'
++             - '@user'
++             - '@content.visibility'
++-            - '@vse.similartopics.stop_word_helper'
++             - '@vse.similartopics.driver.manager'
++             - '%core.root_path%'
++             - '%core.php_ext%'
++@@ -23,8 +23,6 @@ services:
++         class: vse\similartopics\event\listener
++         arguments:
++             - '@vse.similartopics.manager'
++-            - '@controller.helper'
++-            - '@template'
++         tags:
++             - { name: event.listener }
++ 
++@@ -61,28 +59,13 @@ services:
++             - '%core.root_path%'
++             - '%core.php_ext%'
++ 
++-    vse.similartopics.stop_word_helper:
++-        class: vse\similartopics\core\stop_word_helper
++-        public: false
++-        arguments:
++-            - '@cache.driver'
++-            - '@ext.manager'
++-            - '@user'
++-            - '%core.php_ext%'
++-
++-    vse.similartopics.ajax.controller:
++-        class: vse\similartopics\controller\ajax_controller
++-        arguments:
++-            - '@request'
++-            - '@vse.similartopics.manager'
++-
++ # ----- Similar topics DB drivers collection -----
++     vse.similartopics.driver_collection:
++         class: phpbb\di\service_collection
++         arguments:
++             - '@service_container'
++         tags:
++-            - { name: service_collection, tag: vse.similartopics.driver }
+++            - { name: service_collection, tag: vse.similartopcs.driver }
++ 
++     vse.similartopics.driver.postgres:
++         class: vse\similartopics\driver\postgres
++@@ -90,50 +73,17 @@ services:
++             - '@dbal.conn'
++             - '@config'
++         tags:
++-            - { name: vse.similartopics.driver }
+++            - { name: vse.similartopcs.driver }
++ 
++     vse.similartopics.driver.mysqli:
++         class: vse\similartopics\driver\mysqli
++         arguments:
++             - '@dbal.conn'
++         tags:
++-            - { name: vse.similartopics.driver }
+++            - { name: vse.similartopcs.driver }
++ 
++     vse.similartopics.driver.mysql4:
++         class: vse\similartopics\driver\mysql4
++         parent: vse.similartopics.driver.mysqli
++         tags:
++-            - { name: vse.similartopics.driver }
++-
++-    vse.similartopics.driver.sqlite3:
++-        class: vse\similartopics\driver\sqlite3
++-        arguments:
++-            - '@dbal.conn'
++-        tags:
++-            - { name: vse.similartopics.driver }
++-
++-    vse.similartopics.driver.mssql:
++-        class: vse\similartopics\driver\mssql
++-        arguments:
++-            - '@dbal.conn'
++-        tags:
++-            - { name: vse.similartopics.driver }
++-
++-    vse.similartopics.driver.mssqlnative:
++-        class: vse\similartopics\driver\mssqlnative
++-        parent: vse.similartopics.driver.mssql
++-        tags:
++-            - { name: vse.similartopics.driver }
++-
++-    vse.similartopics.driver.mssql_odbc:
++-        class: vse\similartopics\driver\mssql_odbc
++-        parent: vse.similartopics.driver.mssql
++-        tags:
++-            - { name: vse.similartopics.driver }
++-
++-    vse.similartopics.driver.oracle:
++-        class: vse\similartopics\driver\oracle
++-        arguments:
++-            - '@dbal.conn'
++-        tags:
++-            - { name: vse.similartopics.driver }
+++            - { name: vse.similartopcs.driver }
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/controller/ajax_controller.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/controller/ajax_controller.php"
++deleted file mode 100644
++index d49f853f1..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/controller/ajax_controller.php"
+++++ /dev/null
++@@ -1,63 +0,0 @@
++-<?php
++-/**
++- *
++- * Precise Similar Topics
++- *
++- * @copyright (c) 2025 Matt Friedman
++- * @license GNU General Public License, version 2 (GPL-2.0)
++- *
++- */
++-
++-namespace vse\similartopics\controller;
++-
++-use phpbb\exception\http_exception;
++-use Symfony\Component\HttpFoundation\JsonResponse;
++-use phpbb\request\request;
++-use vse\similartopics\core\similar_topics;
++-
++-class ajax_controller
++-{
++-	/** @var request */
++-	protected $request;
++-
++-	/** @var similar_topics */
++-	protected $similar_topics;
++-
++-	/**
++-	 * Constructor
++-	 *
++-	 * @param request $request
++-	 * @param similar_topics $similar_topics
++-	 */
++-	public function __construct(request $request, similar_topics $similar_topics)
++-	{
++-		$this->request = $request;
++-		$this->similar_topics = $similar_topics;
++-	}
++-
++-	/**
++-	 * Handle AJAX request for similar topics search
++-	 *
++-	 * @return JsonResponse
++-	 * @throws http_exception
++-	 */
++-	public function search_similar_topics()
++-	{
++-		if (!$this->request->is_ajax())
++-		{
++-			throw new http_exception(403, 'NO_AUTH_OPERATION');
++-		}
++-
++-		$query = $this->request->variable('q', '', true);
++-		$forum_id = $this->request->variable('f', 0);
++-
++-		if (utf8_strlen($query) < 3 || !$this->similar_topics->is_dynamic_available())
++-		{
++-			return new JsonResponse(['topics' => []]);
++-		}
++-
++-		$topics = $this->similar_topics->search_similar_topics_ajax($query, $forum_id);
++-
++-		return new JsonResponse(['topics' => $topics]);
++-	}
++-}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/core/similar_topics.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/core/similar_topics.php"
++index 72de4b84e..946730c0f 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/core/similar_topics.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/core/similar_topics.php"
++@@ -17,6 +17,7 @@ use phpbb\config\db_text;
++ use phpbb\content_visibility;
++ use phpbb\db\driver\driver_interface as db;
++ use phpbb\event\dispatcher_interface as dispatcher;
+++use phpbb\extension\manager as ext_manager;
++ use phpbb\language\language;
++ use phpbb\pagination;
++ use phpbb\request\request;
++@@ -45,6 +46,9 @@ class similar_topics
++ 	/** @var dispatcher */
++ 	protected $dispatcher;
++ 
+++	/** @var ext_manager */
+++	protected $extension_manager;
+++
++ 	/** @var language */
++ 	protected $language;
++ 
++@@ -63,9 +67,6 @@ class similar_topics
++ 	/** @var content_visibility */
++ 	protected $content_visibility;
++ 
++-	/** @var stop_word_helper */
++-	protected $stop_word_helper;
++-
++ 	/** @var similartopics_driver */
++ 	protected $similartopics;
++ 
++@@ -84,22 +85,22 @@ class similar_topics
++ 	 * @access public
++ 	 * @param auth                  $auth
++ 	 * @param cache                 $cache
++-	 * @param config                 $config
+++	 * @param config                $config
++ 	 * @param db_text               $config_text
++ 	 * @param db                    $db
++ 	 * @param dispatcher            $dispatcher
+++	 * @param ext_manager           $extension_manager
++ 	 * @param language              $language
++ 	 * @param pagination            $pagination
++ 	 * @param request               $request
++ 	 * @param template              $template
++ 	 * @param user                  $user
++ 	 * @param content_visibility    $content_visibility
++-	 * @param stop_word_helper      $stop_word_helper
++ 	 * @param similartopics_manager $similartopics_manager
++ 	 * @param string                $root_path
++ 	 * @param string                $php_ext
++ 	 */
++-	public function __construct(auth $auth, cache $cache, config $config, db_text $config_text, db $db, dispatcher $dispatcher, language $language, pagination $pagination, request $request, template $template, user $user, content_visibility $content_visibility, stop_word_helper $stop_word_helper, similartopics_manager $similartopics_manager, $root_path, $php_ext)
+++	public function __construct(auth $auth, cache $cache, config $config, db_text $config_text, db $db, dispatcher $dispatcher, ext_manager $extension_manager, language $language, pagination $pagination, request $request, template $template, user $user, content_visibility $content_visibility, similartopics_manager $similartopics_manager, $root_path, $php_ext)
++ 	{
++ 		$this->auth = $auth;
++ 		$this->cache = $cache;
++@@ -107,7 +108,7 @@ class similar_topics
++ 		$this->config_text = $config_text;
++ 		$this->db = $db;
++ 		$this->dispatcher = $dispatcher;
++-		$this->stop_word_helper = $stop_word_helper;
+++		$this->extension_manager = $extension_manager;
++ 		$this->language = $language;
++ 		$this->pagination = $pagination;
++ 		$this->request = $request;
++@@ -153,28 +154,6 @@ class similar_topics
++ 		return !empty($this->user->data['user_similar_topics']) && $this->auth->acl_get('u_similar_topics');
++ 	}
++ 
++-	/**
++-	 * Is dynamic similar topics available?
++-	 *
++-	 * @access public
++-	 * @return bool True if available, false otherwise
++-	 */
++-	public function is_dynamic_available()
++-	{
++-		return $this->is_dynamic_enabled() && $this->is_viewable() && $this->similartopics !== null;
++-	}
++-
++-	/**
++-	 * Is dynamic similar topics enabled?
++-	 *
++-	 * @access public
++-	 * @return bool True if enabled, false otherwise
++-	 */
++-	public function is_dynamic_enabled()
++-	{
++-		return !empty($this->config['similar_topics_dynamic']) && !empty($this->config['similar_topics_limit']);
++-	}
++-
++ 	/**
++ 	 * Get similar topics by matching topic titles
++ 	 * Loosely based on viewforum.php lines 840-1040
++@@ -194,9 +173,7 @@ class similar_topics
++ 			return;
++ 		}
++ 
++-		$this->stop_word_helper->set_use_localized($this->get_localized_ignore_words());
++-		$this->stop_word_helper->set_additional_ignore_words($this->get_additional_ignore_words());
++-		$topic_title = $this->stop_word_helper->clean_text($topic_data['topic_title']);
+++		$topic_title = $this->clean_topic_title($topic_data['topic_title']);
++ 
++ 		// If the cleaned up topic_title is empty, no need to continue
++ 		if (empty($topic_title))
++@@ -322,7 +299,6 @@ class similar_topics
++ 				$u_mcp_queue = ($topic_unapproved || $posts_unapproved) ? append_sid("{$this->root_path}mcp.$this->php_ext", 'i=queue&amp;mode=' . ($topic_unapproved ? 'approve_details' : 'unapproved_posts') . "&amp;t=$similar_topic_id", true, $this->user->session_id) : '';
++ 
++ 				$base_url = append_sid("{$this->root_path}viewtopic.$this->php_ext", $view_topic_url_params);
++-
++ 				$topic_row = array(
++ 					'TOPIC_AUTHOR_FULL'			=> get_username_string('full', $row['topic_poster'], $row['topic_first_poster_name'], $row['topic_first_poster_colour']),
++ 					'FIRST_POST_TIME'			=> $this->user->format_date($row['topic_time']),
++@@ -333,6 +309,7 @@ class similar_topics
++ 
++ 					'TOPIC_REPLIES'			=> $replies,
++ 					'TOPIC_VIEWS'			=> $row['topic_views'],
+++					'TOPIC_ANSWERED'		=> ($this->extension_manager->is_enabled('kinerity/bestanswer')) && $row['answer_post_id'] ? true : false,
++ 					'TOPIC_TITLE'			=> censor_text($row['topic_title']),
++ 					'FORUM_TITLE'			=> $row['forum_name'],
++ 
++@@ -377,7 +354,7 @@ class similar_topics
++ 			}
++ 		}
++ 
++-		$this->add_language();
+++		$this->language->add_lang('similar_topics', 'vse/similartopics');
++ 
++ 		$this->template->assign_vars(array(
++ 			'NEWEST_POST_IMG'	=> $this->user->img('icon_topic_newest', 'VIEW_NEWEST_POST'),
++@@ -388,96 +365,130 @@ class similar_topics
++ 	}
++ 
++ 	/**
++-	 * Add lang files for similar topics
+++	 * Clean topic title (and if needed, ignore-words)
++ 	 *
++-	 * @return void
+++	 * @access public
+++	 * @param string $text The topic title
+++	 * @return string The topic title
++ 	 */
++-	public function add_language()
+++	public function clean_topic_title($text)
++ 	{
++-		$this->language->add_lang('similar_topics', 'vse/similartopics');
++-	}
+++		// Strip quotes, ampersands
+++		$text = str_replace(array('&quot;', '&amp;'), '', $text);
+++
+++		// UTF Emojis
+++		$regex_emoticons = '/[\x{1F600}-\x{1F64F}]/u';
+++		$text = preg_replace($regex_emoticons, '', $text);
+++
+++		// Match Miscellaneous Symbols and Pictographs
+++		$regex_symbols = '/[\x{1F300}-\x{1F5FF}]/u';
+++		$text = preg_replace($regex_symbols, '', $text);
+++
+++		// Match Transport And Map Symbols
+++		$regex_transport = '/[\x{1F680}-\x{1F6FF}]/u';
+++		$text = preg_replace($regex_transport, '', $text);
+++
+++		// Match Miscellaneous Symbols
+++		$regex_misc = '/[\x{2600}-\x{26FF}]/u';
+++		$text = preg_replace($regex_misc, '', $text);
+++
+++		// Match Dingbats
+++		$regex_dingbats = '/[\x{2700}-\x{27BF}]/u';
+++		$text = preg_replace($regex_dingbats, '', $text);
+++
+++		$regex_bbemoji = '(:([-+_a-z0-9]+):(?!\\w|[^<>]*(?=>|</code>)))';
+++		$matches = [];
+++		preg_match_all($regex_bbemoji, $text, $matches);
+++		foreach ($matches[0] as $emoji) {
+++			$text = str_replace($emoji, '', $text);
+++		}
++ 
++-	/**
++-	 * Check if we should load localized ignore words
++-	 *
++-	 * @access protected
++-	 * @return bool True if non-English language or using a dbms with no stop-words
++-	 */
++-	protected function get_localized_ignore_words()
++-	{
++-		return !in_array($this->user->lang_name, ['en', 'en_us'], true) || !$this->similartopics->has_stopword_support();
+++		$text = trim($text);
+++
+++		if (!$this->english_lang() || $this->get_ignore_words())
+++		{
+++			$text = $this->strip_stop_words($text);
+++		}
+++
+++		return $text;
++ 	}
++ 
++ 	/**
++-	 * Search for similar topics via AJAX for dynamic suggestions
+++	 * Remove any non-english and/or custom defined ignore-words
++ 	 *
++-	 * @param string $query The search query
++-	 * @param int $forum_id The forum ID to search from
++-	 * @return array Array of similar topics
+++	 * @access protected
+++	 * @param string $text The topic title
+++	 * @return string The topic title
++ 	 */
++-	public function search_similar_topics_ajax($query, $forum_id = 0)
+++	protected function strip_stop_words($text)
++ 	{
++-		$this->stop_word_helper->set_use_localized($this->get_localized_ignore_words());
++-		$this->stop_word_helper->set_additional_ignore_words($this->get_additional_ignore_words());
++-		$cleaned_query = $this->stop_word_helper->clean_text($query);
+++		$words = array();
++ 
++-		if (empty($cleaned_query))
+++		// If non-English, look for a list of stop-words to be ignored
+++		// in either the core or the extension (deprecated from core)
+++		if (!$this->english_lang())
++ 		{
++-			return [];
+++			$finder = $this->extension_manager->get_finder();
+++			$search_ignore_words = $finder
+++				->set_extensions(array('vse/similartopics'))
+++				->prefix('search_ignore_words')
+++				->suffix(".$this->php_ext")
+++				->extension_directory("/language/{$this->user->lang_name}")
+++				->core_path("language/{$this->user->lang_name}/")
+++				->get_files();
+++			if (current($search_ignore_words))
+++			{
+++				include current($search_ignore_words);
+++			}
++ 		}
++ 
++-		$sensitivity = $this->config->offsetExists('similar_topics_sense') ? number_format($this->config['similar_topics_sense'] / 10, 1, '.', '') : '0.5';
++-		$sql_array = $this->similartopics->get_query(0, $cleaned_query, $this->config['similar_topics_time'], $sensitivity);
++-
++-		$similar_topic_forums = null;
++-		if ($forum_id > 0)
+++		if ($this->get_ignore_words())
++ 		{
++-			$sql = 'SELECT similar_topic_forums
++-				FROM ' . FORUMS_TABLE . '
++-				WHERE forum_id = ' . (int) $forum_id;
++-			$result = $this->db->sql_query($sql, 3600);
++-			$similar_topic_forums = $this->db->sql_fetchfield('similar_topic_forums');
++-			$this->db->sql_freeresult($result);
+++			// Merge any custom defined ignore words from the ACP to the stop-words array
+++			$words = array_merge($this->make_word_array($this->get_ignore_words()), $words);
++ 		}
++ 
++-		$passworded_forums = $this->user->get_passworded_forums();
+++		// Remove stop-words from the topic title text
+++		$words = array_diff($this->make_word_array($text), $words);
++ 
++-		if (!empty($similar_topic_forums))
++-		{
++-			$included_forums = array_diff(json_decode($similar_topic_forums, true), $passworded_forums);
++-			if (empty($included_forums))
++-			{
++-				return [];
++-			}
++-			$sql_array['WHERE'] .= ' AND ' . $this->db->sql_in_set('f.forum_id', $included_forums);
++-		}
++-		else
++-		{
++-			if (count($passworded_forums))
++-			{
++-				$sql_array['WHERE'] .= ' AND ' . $this->db->sql_in_set('f.forum_id', $passworded_forums, true);
++-			}
++-			$sql_array['WHERE'] .= ' AND f.similar_topics_ignore = 0';
++-		}
+++		// Convert our words array back to a string
+++		return implode(' ', $words);
+++	}
++ 
++-		$topics = [];
++-		$sql = $this->db->sql_build_query('SELECT', $sql_array);
++-		$result = $this->db->sql_query_limit($sql, 5);
+++	/**
+++	 * Helper function to split string into an array of words
+++	 *
+++	 * @access protected
+++	 * @param string $text String of plain text words
+++	 * @return array Array of plaintext words
+++	 */
+++	protected function make_word_array($text)
+++	{
+++		// Strip out any non-alpha-numeric characters using PCRE regex syntax
+++		$text = trim(preg_replace('#[^\p{L}\p{N}]+#u', ' ', $text));
++ 
++-		while ($row = $this->db->sql_fetchrow($result))
+++		$words = explode(' ', utf8_strtolower($text));
+++		foreach ($words as $key => $word)
++ 		{
++-			if ($this->auth->acl_get('f_read', (int) $row['forum_id']))
+++			// Strip words of 2 characters or fewer
+++			if (utf8_strlen(trim($word)) < 3)
++ 			{
++-				$topics[] = [
++-					'id' => (int) $row['topic_id'],
++-					'title' => censor_text($row['topic_title']),
++-					'url' => append_sid("{$this->root_path}viewtopic.$this->php_ext", 't=' . $row['topic_id'])
++-				];
+++				unset($words[$key]);
++ 			}
++ 		}
++-		$this->db->sql_freeresult($result);
++ 
++-		return $topics;
+++		return $words;
+++	}
+++
+++	/**
+++	 * Check if English is the current user's language
+++	 *
+++	 * @access protected
+++	 * @return bool True if lang is 'en' or 'en_us', false otherwise
+++	 */
+++	protected function english_lang()
+++	{
+++		return ($this->user->lang_name === 'en' || $this->user->lang_name === 'en_us');
++ 	}
++ 
++ 	/**
++@@ -486,7 +497,7 @@ class similar_topics
++ 	 * @access protected
++ 	 * @return string|null String of ignore words or null if there are none defined
++ 	 */
++-	protected function get_additional_ignore_words()
+++	protected function get_ignore_words()
++ 	{
++ 		$key = 'similar_topics_words';
++ 
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/core/stop_word_helper.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/core/stop_word_helper.php"
++deleted file mode 100644
++index 2af488e1a..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/core/stop_word_helper.php"
+++++ /dev/null
++@@ -1,198 +0,0 @@
++-<?php
++-/**
++- *
++- * Precise Similar Topics
++- *
++- * @copyright (c) 2025 Matt Friedman
++- * @license GNU General Public License, version 2 (GPL-2.0)
++- *
++- */
++-
++-namespace vse\similartopics\core;
++-
++-use phpbb\cache\driver\driver_interface as cache_driver;
++-use phpbb\extension\manager as ext_manager;
++-use phpbb\user;
++-
++-/**
++- * A helper class to clean text and remove stop words (localized and additional)
++- * for topic titles or other search-related strings.
++- */
++-class stop_word_helper
++-{
++-	/** @var cache_driver */
++-	protected $cache;
++-
++-	/** @var ext_manager */
++-	protected $extension_manager;
++-
++-	/** @var user */
++-	protected $user;
++-
++-	/** @var string */
++-	protected $php_ext;
++-
++-	/** @var array|null Lookup table for fast filtering */
++-	protected $ignore_lookup;
++-
++-	/** @var bool Whether localized ignore words should be loaded */
++-	protected $use_localized = false;
++-
++-	/** @var string Additional ignore words string */
++-	protected $additional_ignore = '';
++-
++-	/** @var bool Whether ignore words need to be reloaded */
++-	protected $needs_reload = true;
++-
++-	/**
++-	 * Constructor
++-	 *
++-	 * @param cache_driver $cache
++-	 * @param ext_manager $extension_manager
++-	 * @param user $user
++-	 * @param string $php_ext
++-	 */
++-	public function __construct(cache_driver $cache, ext_manager $extension_manager, user $user, $php_ext)
++-	{
++-		$this->cache = $cache;
++-		$this->extension_manager = $extension_manager;
++-		$this->user = $user;
++-		$this->php_ext = $php_ext;
++-	}
++-
++-	/**
++-	 * Set additional ignore words
++-	 *
++-	 * @param string $words
++-	 */
++-	public function set_additional_ignore_words($words)
++-	{
++-		if ($this->additional_ignore !== $words)
++-		{
++-			$this->additional_ignore = $words;
++-			$this->needs_reload = true;
++-		}
++-	}
++-
++-	/**
++-	 * Set whether to use localized ignore words
++-	 *
++-	 * @param bool $value
++-	 */
++-	public function set_use_localized($value)
++-	{
++-		$value = (bool) $value;
++-		if ($this->use_localized !== $value)
++-		{
++-			$this->use_localized = $value;
++-			$this->needs_reload = true;
++-		}
++-	}
++-
++-	/**
++-	 * Clean text (strip quotes, ampersands, stop words)
++-	 *
++-	 * @param string $text
++-	 * @return string
++-	 */
++-	public function clean_text($text)
++-	{
++-		// Strip HTML entities
++-		$text = str_replace(['&quot;', '&amp;'], '', $text);
++-
++-		if ($this->use_localized || !empty($this->additional_ignore))
++-		{
++-			$this->load_ignore_words();
++-			$filtered = array_filter(
++-				$this->make_word_array($text, true),
++-				[$this, 'filter_ignore_words']
++-			);
++-			$text = implode(' ', array_unique($filtered));
++-		}
++-
++-		return $text;
++-	}
++-
++-	/**
++-	 * Load ignore words into memory and build a lookup table
++-	 */
++-	protected function load_ignore_words()
++-	{
++-		if ($this->needs_reload || $this->ignore_lookup === null)
++-		{
++-			// The cache will be invalidated when language, localized setting, or additional words change
++-			$cache_key = '_pst_ignore_' . md5($this->user->lang_name . '|' . (int) $this->use_localized . '|' . $this->additional_ignore);
++-			$this->ignore_lookup = $this->cache->get($cache_key);
++-
++-			if ($this->ignore_lookup === false)
++-			{
++-				// Load localized ignore words (if needed)
++-				$words = $this->use_localized ? $this->load_localized_words() : [];
++-
++-				// Load additional ignore words (if defined)
++-				if (!empty($this->additional_ignore))
++-				{
++-					$words = array_merge($words, $this-
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/driver/driver_interface.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/driver/driver_interface.php"
+index bb56ebfa3..fcd220dcb 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/driver/driver_interface.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/driver/driver_interface.php"
+@@ -82,12 +82,4 @@ interface driver_interface
+ 	 * @return string The storage engine name
+ 	 */
+ 	public function get_engine();
+-
+-	/**
+-	 * Check if the database has built-in stop-word support
+-	 *
+-	 * @access public
+-	 * @return bool True if has stop-word support, false otherwise
+-	 */
+-	public function has_stopword_support();
+ }
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/driver/mssql.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/driver/mssql.php"
+deleted file mode 100644
+index d2556b92d..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/driver/mssql.php"
++++ /dev/null
+@@ -1,199 +0,0 @@
+-<?php
+-/**
+- *
+- * Precise Similar Topics
+- *
+- * @copyright (c) 2025 Matt Friedman
+- * @license GNU General Public License, version 2 (GPL-2.0)
+- *
+- */
+-
+-namespace vse\similartopics\driver;
+-
+-/**
+- * This class handles similar topics queries for MSSQL dbms
+- */
+-class mssql implements driver_interface
+-{
+-	/** @var \phpbb\db\driver\driver_interface */
+-	protected $db;
+-
+-	/**
+-	 * Constructor
+-	 *
+-	 * @param \phpbb\db\driver\driver_interface $db
+-	 */
+-	public function __construct(\phpbb\db\driver\driver_interface $db)
+-	{
+-		$this->db = $db;
+-	}
+-
+-	/**
+-	 * {@inheritdoc}
+-	 */
+-	public function get_name()
+-	{
+-		return 'mssql';
+-	}
+-
+-	/**
+-	 * {@inheritdoc}
+-	 */
+-	public function get_type()
+-	{
+-		return 'mssql';
+-	}
+-
+-	/**
+-	 * {@inheritdoc}
+-	 */
+-	public function get_query($topic_id, $topic_title, $length, $sensitivity)
+-	{
+-		if ($this->is_fulltext('topic_title', TOPICS_TABLE))
+-		{
+-			$search_condition = "CONTAINS(t.topic_title, '" . $this->db->sql_escape(str_replace(' ', ' AND ', $topic_title)) . "')";
+-		}
+-		else
+-		{
+-			$like_conditions = array();
+-			foreach (explode(' ', $topic_title) as $word)
+-			{
+-				$word = trim($word);
+-				if (utf8_strlen($word) > 2)
+-				{
+-					$like_conditions[] = "t.topic_title LIKE '%" . $this->db->sql_escape($word) . "%'";
+-				}
+-			}
+-			$search_condition = !empty($like_conditions)
+-				? '(' . implode(' OR ', $like_conditions) . ')'
+-				: "t.topic_title LIKE '%" . $this->db->sql_escape($topic_title) . "%'";
+-		}
+-
+-		return array(
+-			'SELECT'	=> "f.forum_id, f.forum_name, t.*,
+-				CASE WHEN " . $search_condition . " THEN 1.0 ELSE 0.0 END AS score",
+-			'FROM'		=> array(
+-				TOPICS_TABLE => 't'
+-			),
+-			'LEFT_JOIN'	=> array(
+-				array(
+-					'FROM' => array(FORUMS_TABLE => 'f'),
+-					'ON' => 'f.forum_id = t.forum_id'
+-				)
+-			),
+-			'WHERE'		=> $search_condition . "
+-				AND t.topic_status <> " . ITEM_MOVED . "
+-				AND t.topic_visibility = " . ITEM_APPROVED . "
+-				AND t.topic_time > (DATEDIFF(second, '1970-01-01', GETDATE()) - " . (int) $length . ")
+-				AND t.topic_id <> " . (int) $topic_id,
+-			'ORDER_BY'	=> 'score DESC, t.topic_time DESC',
+-		);
+-	}
+-
+-	/**
+-	 * {@inheritdoc}
+-	 */
+-	public function is_supported()
+-	{
+-		return (strpos($this->db->get_sql_layer(), 'mssql') === 0);
+-	}
+-
+-	/**
+-	 * {@inheritdoc}
+-	 */
+-	public function is_fulltext($column = 'topic_title', $table = TOPICS_TABLE)
+-	{
+-		return in_array($column, $this->get_fulltext_indexes($column, $table), true);
+-	}
+-
+-	/**
+-	 * {@inheritdoc}
+-	 */
+-	public function get_fulltext_indexes($column = 'topic_title', $table = TOPICS_TABLE)
+-	{
+-		$indexes = array();
+-
+-		if (!$this->is_supported())
+-		{
+-			return $indexes;
+-		}
+-
+-		try
+-		{
+-			$sql = "SELECT i.name
+-				FROM sys.fulltext_indexes fi
+-				INNER JOIN sys.indexes i ON fi.object_id = i.object_id AND fi.unique_index_id = i.index_id
+-				INNER JOIN sys.objects o ON fi.object_id = o.object_id
+-				WHERE o.name = '" . $this->db->sql_escape($table) . "'";
+-			$result = $this->db->sql_query($sql);
+-
+-			while ($row = $this->db->sql_fetchrow($result))
+-			{
+-				$indexes[] = $row['name'];
+-			}
+-
+-			$this->db->sql_freeresult($result);
+-		}
+-		catch (\Exception $e)
+-		{
+-			// Full-text search not available
+-		}
+-
+-		return $indexes;
+-	}
+-
+-	/**
+-	 * {@inheritdoc}
+-	 */
+-	public function create_fulltext_index($column = 'topic_title', $table = TOPICS_TABLE)
+-	{
+-		if (!$this->is_supported() || !$this->fulltext_available() || $this->is_fulltext($column, $table))
+-		{
+-			return;
+-		}
+-
+-		// Create fulltext catalog if it doesn't exist
+-		$sql = "IF NOT EXISTS (SELECT * FROM sys.fulltext_catalogs WHERE name = 'phpbb_catalog')
+-			CREATE FULLTEXT CATALOG phpbb_catalog";
+-		$this->db->sql_query($sql);
+-
+-		// Create fulltext index
+-		$sql = "CREATE FULLTEXT INDEX ON " . $this->db->sql_escape($table) . "
+-			(" . $this->db->sql_escape($column) . ")
+-			KEY INDEX PK_" . $this->db->sql_escape($table) . "
+-			ON phpbb_catalog";
+-		$this->db->sql_query($sql);
+-	}
+-
+-	/**
+-	 * {@inheritdoc}
+-	 */
+-	public function get_engine()
+-	{
+-		return '';
+-	}
+-
+-	/**
+-	 * {@inheritdoc}
+-	 */
+-	public function has_stopword_support()
+-	{
+-		return false;
+-	}
+-
+-	protected function fulltext_available()
+-	{
+-		try
+-		{
+-			$sql = "SELECT SERVERPROPERTY('IsFullTextInstalled') AS IsFullTextInstalled";
+-			$result = $this->db->sql_query($sql);
+-			$row = $this->db->sql_fetchrow($result);
+-			$this->db->sql_freeresult($result);
+-			return (bool) $row['IsFullTextInstalled'];
+-		}
+-		catch (\Exception $e)
+-		{
+-			return false;
+-		}
+-	}
+-}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/driver/mssql_odbc.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/driver/mssql_odbc.php"
+deleted file mode 100644
+index c1d8ac99f..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/driver/mssql_odbc.php"
++++ /dev/null
+@@ -1,25 +0,0 @@
+-<?php
+-/**
+- *
+- * Precise Similar Topics
+- *
+- * @copyright (c) 2025 Matt Friedman
+- * @license GNU General Public License, version 2 (GPL-2.0)
+- *
+- */
+-
+-namespace vse\similartopics\driver;
+-
+-/**
+- * This class handles similar topics queries for MSSQL ODBC dbms
+- */
+-class mssql_odbc extends mssql
+-{
+-	/**
+-	 * {@inheritdoc}
+-	 */
+-	public function get_name()
+-	{
+-		return 'mssql_odbc';
+-	}
+-}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/driver/mssqlnative.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/driver/mssqlnative.php"
+deleted file mode 100644
+index f7735953e..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/driver/mssqlnative.php"
++++ /dev/null
+@@ -1,25 +0,0 @@
+-<?php
+-/**
+- *
+- * Precise Similar Topics
+- *
+- * @copyright (c) 2025 Matt Friedman
+- * @license GNU General Public License, version 2 (GPL-2.0)
+- *
+- */
+-
+-namespace vse\similartopics\driver;
+-
+-/**
+- * This class handles similar topics queries for MSSQL Native dbms
+- */
+-class mssqlnative extends mssql
+-{
+-	/**
+-	 * {@inheritdoc}
+-	 */
+-	public function get_name()
+-	{
+-		return 'mssqlnative';
+-	}
+-}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/driver/mysqli.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/driver/mysqli.php"
+index 7f6c1fd6f..35ba9ddc0 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/driver/mysqli.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/driver/mysqli.php"
+@@ -202,15 +202,7 @@ class mysqli implements driver_interface
+ 	 */
+ 	protected function is_mysql()
+ 	{
+-		return strpos($this->db->get_sql_layer(), 'mysql') === 0;
+-	}
+-
+-	/**
+-	 * {@inheritdoc}
+-	 */
+-	public function has_stopword_support()
+-	{
+-		return true;
++		return ($this->db->get_sql_layer() === 'mysql4' || $this->db->get_sql_layer() === 'mysqli');
+ 	}
+ 
+ 	/**
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/driver/oracle.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/driver/oracle.php"
+deleted file mode 100644
+index bc77f0d6d..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/driver/oracle.php"
++++ /dev/null
+@@ -1,200 +0,0 @@
+-<?php
+-/**
+- *
+- * Precise Similar Topics
+- *
+- * @copyright (c) 2025 Matt Friedman
+- * @license GNU General Public License, version 2 (GPL-2.0)
+- *
+- */
+-
+-namespace vse\similartopics\driver;
+-
+-/**
+- * This class handles similar topics queries for Oracle dbms
+- */
+-class oracle implements driver_interface
+-{
+-	/** @var \phpbb\db\driver\driver_interface */
+-	protected $db;
+-
+-	/**
+-	 * Constructor
+-	 *
+-	 * @param \phpbb\db\driver\driver_interface $db
+-	 */
+-	public function __construct(\phpbb\db\driver\driver_interface $db)
+-	{
+-		$this->db = $db;
+-	}
+-
+-	/**
+-	 * {@inheritdoc}
+-	 */
+-	public function get_name()
+-	{
+-		return 'oracle';
+-	}
+-
+-	/**
+-	 * {@inheritdoc}
+-	 */
+-	public function get_type()
+-	{
+-		return 'oracle';
+-	}
+-
+-	/**
+-	 * {@inheritdoc}
+-	 */
+-	public function get_query($topic_id, $topic_title, $length, $sensitivity)
+-	{
+-		// Clean and prepare the search terms for Oracle Text
+-		$search_terms = $this->prepare_search_terms($topic_title);
+-
+-		return array(
+-			'SELECT'	=> "f.forum_id, f.forum_name, t.*,
+-				SCORE(1) AS score",
+-
+-			'FROM'		=> array(
+-				TOPICS_TABLE	=> 't',
+-			),
+-			'LEFT_JOIN'	=> array(
+-				array(
+-					'FROM'	=>	array(FORUMS_TABLE	=> 'f'),
+-					'ON'	=> 'f.forum_id = t.forum_id',
+-				),
+-			),
+-			'WHERE'		=> "CONTAINS(t.topic_title, '" . $this->db->sql_escape($search_terms) . "', 1) > 0
+-				AND SCORE(1) >= " . (float) $sensitivity . '
+-				AND t.topic_status <> ' . ITEM_MOVED . '
+-				AND t.topic_visibility = ' . ITEM_APPROVED . '
+-				AND t.topic_time > (EXTRACT(EPOCH FROM SYSTIMESTAMP) - ' . (int) $length . ')
+-				AND t.topic_id <> ' . (int) $topic_id,
+-		);
+-	}
+-
+-	/**
+-	 * {@inheritdoc}
+-	 */
+-	public function is_supported()
+-	{
+-		return $this->is_oracle();
+-	}
+-
+-	/**
+-	 * {@inheritdoc}
+-	 */
+-	public function is_fulltext($column = 'topic_title', $table = TOPICS_TABLE)
+-	{
+-		return in_array($column, $this->get_fulltext_indexes($column, $table), true);
+-	}
+-
+-	/**
+-	 * {@inheritdoc}
+-	 */
+-	public function get_fulltext_indexes($column = 'topic_title', $table = TOPICS_TABLE)
+-	{
+-		$indexes = array();
+-
+-		if (!$this->is_supported())
+-		{
+-			return $indexes;
+-		}
+-
+-		$sql = "SELECT index_name
+-			FROM user_indexes
+-			WHERE table_name = UPPER('" . $this->db->sql_escape($table) . "')
+-			AND index_type = 'DOMAIN'
+-			AND domidx_opstatus = 'VALID'";
+-		$result = $this->db->sql_query($sql);
+-
+-		while ($row = $this->db->sql_fetchrow($result))
+-		{
+-			// Check if this is a text index on our column
+-			$check_sql = "SELECT column_name
+-				FROM user_ind_columns
+-				WHERE index_name = '" . $this->db->sql_escape($row['index_name']) . "'
+-				AND column_name = UPPER('" . $this->db->sql_escape($column) . "')";
+-			$check_result = $this->db->sql_query($check_sql);
+-
+-			if ($this->db->sql_fetchrow($check_result))
+-			{
+-				$indexes[] = strtolower($column);
+-			}
+-			$this->db->sql_freeresult($check_result);
+-		}
+-
+-		$this->db->sql_freeresult($result);
+-
+-		return $indexes;
+-	}
+-
+-	/**
+-	 * {@inheritdoc}
+-	 */
+-	public function create_fulltext_index($column = 'topic_title', $table = TOPICS_TABLE)
+-	{
+-		if (!$this->is_fulltext($column, $table))
+-		{
+-			$index_name = $table . '_' . $column . '_ctx_idx';
+-
+-			// Create Oracle Text index
+-			$sql = "CREATE INDEX " . $this->db->sql_escape($index_name) . "
+-				ON " . $this->db->sql_escape($table) . " (" . $this->db->sql_escape($column) . ")
+-				INDEXTYPE IS CTXSYS.CONTEXT
+-				PARAMETERS ('STOPLIST CTXSYS.DEFAULT_STOPLIST SYNC (ON COMMIT)')";
+-			$this->db->sql_query($sql);
+-		}
+-	}
+-
+-	/**
+-	 * {@inheritdoc}
+-	 */
+-	public function get_engine()
+-	{
+-		return 'oracle';
+-	}
+-
+-	/**
+-	 * {@inheritdoc}
+-	 */
+-	public function has_stopword_support()
+-	{
+-		return true;
+-	}
+-
+-	/**
+-	 * Check if the database is using Oracle
+-	 *
+-	 * @return bool True if is oracle, false otherwise
+-	 */
+-	protected function is_oracle()
+-	{
+-		return strpos($this->db->get_sql_layer(), 'oracle') === 0;
+-	}
+-
+-	/**
+-	 * Prepare search terms for Oracle Text query
+-	 *
+-	 * @param string $topic_title The topic title to search for
+-	 * @return string Formatted search terms for Oracle Text
+-	 */
+-	protected function prepare_search_terms($topic_title)
+-	{
+-		// Remove special characters and split into words
+-		$words = preg_split('/[^\p{L}\p{N}]+/u', $topic_title, -1, PREG_SPLIT_NO_EMPTY);
+-
+-		// Filter out short words and create OR query
+-		$search_words = array();
+-		foreach ($words as $word)
+-		{
+-			if (utf8_strlen($word) >= 3)
+-			{
+-				$search_words[] = $word;
+-			}
+-		}
+-
+-		return !empty($search_words) ? implode(' OR ', $search_words) : $topic_title;
+-	}
+-}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/driver/postgres.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/driver/postgres.php"
+index 4b23607e5..77bf6486f 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/driver/postgres.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/driver/postgres.php"
+@@ -65,6 +65,7 @@ class postgres implements driver_interface
+ 
+ 		return array(
+ 			'SELECT'	=> "f.forum_id, f.forum_name, t.*, $ts_rank_cd AS score",
++
+ 			'FROM'		=> array(
+ 				TOPICS_TABLE	=> 't',
+ 			),
+@@ -173,29 +174,6 @@ class postgres implements driver_interface
+ 		return '';
+ 	}
+ 
+-	/**
+-	 * {@inheritdoc}
+-	 */
+-	public function has_stopword_support()
+-	{
+-		return !in_array($this->ts_name, ['simple', ''], true);
+-	}
+-
+-	/**
+-	 * Get a list of postgresql text search names
+-	 *
+-	 * @return array array of text search names
+-	 */
+-	public function get_cfg_name_list()
+-	{
+-		$sql = 'SELECT cfgname AS ts_name FROM pg_ts_config';
+-		$result = $this->db->sql_query($sql);
+-		$ts_options = $this->db->sql_fetchrowset($result);
+-		$this->db->sql_freeresult($result);
+-
+-		return $ts_options;
+-	}
+-
+ 	/**
+ 	 * Set the PostgreSQL Text Search name (dictionary)
+ 	 *
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/driver/sqlite3.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/driver/sqlite3.php"
+deleted file mode 100644
+index 3a903236c..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/driver/sqlite3.php"
++++ /dev/null
+@@ -1,185 +0,0 @@
+-<?php
+-/**
+- *
+- * Precise Similar Topics
+- *
+- * @copyright (c) 2025 Matt Friedman
+- * @license GNU General Public License, version 2 (GPL-2.0)
+- *
+- */
+-
+-namespace vse\similartopics\driver;
+-
+-/**
+- * This class handles similar topics queries for SQLite3 dbms
+- */
+-class sqlite3 implements driver_interface
+-{
+-	/** @var \phpbb\db\driver\driver_interface */
+-	protected $db;
+-
+-	/**
+-	 * Constructor
+-	 *
+-	 * @param \phpbb\db\driver\driver_interface $db
+-	 */
+-	public function __construct(\phpbb\db\driver\driver_interface $db)
+-	{
+-		$this->db = $db;
+-	}
+-
+-	/**
+-	 * {@inheritdoc}
+-	 */
+-	public function get_name()
+-	{
+-		return 'sqlite3';
+-	}
+-
+-	/**
+-	 * {@inheritdoc}
+-	 */
+-	public function get_type()
+-	{
+-		return 'sqlite';
+-	}
+-
+-	/**
+-	 * {@inheritdoc}
+-	 */
+-	public function get_query($topic_id, $topic_title, $length, $sensitivity)
+-	{
+-		$words = explode(' ', $topic_title);
+-		$like_conditions = array();
+-
+-		foreach ($words as $word)
+-		{
+-			$like_conditions[] = "t.topic_title LIKE '%" . $this->db->sql_escape(trim($word)) . "%'";
+-		}
+-
+-		$where_condition = '(' . implode(' OR ', $like_conditions) . ')';
+-
+-		return array(
+-			'SELECT'	=> "f.forum_id, f.forum_name, t.*,
+-				CASE WHEN " . $where_condition . " THEN 1.0 ELSE 0.0 END AS score",
+-			'FROM'		=> array(
+-				TOPICS_TABLE	=> 't',
+-			),
+-			'LEFT_JOIN'	=> array(
+-				array(
+-					'FROM'	=>	array(FORUMS_TABLE	=> 'f'),
+-					'ON'	=> 'f.forum_id = t.forum_id',
+-				),
+-			),
+-			'WHERE'		=> $where_condition . "
+-				AND t.topic_status <> " . ITEM_MOVED . "
+-				AND t.topic_visibility = " . ITEM_APPROVED . "
+-				AND t.topic_time > (strftime('%s', 'now') - " . (int) $length . ")
+-				AND t.topic_id <> " . (int) $topic_id,
+-			'ORDER_BY'	=> 'score DESC, t.topic_time DESC',
+-		);
+-	}
+-
+-	/**
+-	 * {@inheritdoc}
+-	 */
+-	public function is_supported()
+-	{
+-		return ($this->db->get_sql_layer() === 'sqlite3');
+-	}
+-
+-	/**
+-	 * {@inheritdoc}
+-	 */
+-	public function is_fulltext($column = 'topic_title', $table = TOPICS_TABLE)
+-	{
+-		// For SQLite, we check if a regular index exists since we use LIKE operations
+-		return $this->index_exists($table, $column);
+-	}
+-
+-	/**
+-	 * {@inheritdoc}
+-	 */
+-	public function get_fulltext_indexes($column = 'topic_title', $table = TOPICS_TABLE)
+-	{
+-		$indexes = array();
+-
+-		if (!$this->is_supported())
+-		{
+-			return $indexes;
+-		}
+-
+-		// Check for FTS virtual tables
+-		$sql = "SELECT name FROM sqlite_master
+-			WHERE type='table' AND name LIKE '" . $this->db->sql_escape($table) . "_fts%'";
+-		$result = $this->db->sql_query($sql);
+-
+-		while ($row = $this->db->sql_fetchrow($result))
+-		{
+-			$indexes[] = $row['name'];
+-		}
+-
+-		$this->db->sql_freeresult($result);
+-
+-		return $indexes;
+-	}
+-
+-	/**
+-	 * {@inheritdoc}
+-	 */
+-	public function create_fulltext_index($column = 'topic_title', $table = TOPICS_TABLE)
+-	{
+-		// SQLite FTS setup is complex and optional for LIKE-based search
+-		// We'll create a simple index to improve LIKE performance
+-		if ($this->index_exists($table, $column))
+-		{
+-			return;
+-		}
+-
+-		$escaped_table = $this->db->sql_escape($table);
+-		$escaped_column = $this->db->sql_escape($column);
+-		$sql = 'CREATE INDEX idx_' . $escaped_table . '_' . $escaped_column . '
+-			ON ' . $escaped_table . ' (' . $escaped_column . ')';
+-		$this->db->sql_query($sql);
+-	}
+-
+-	/**
+-	 * {@inheritdoc}
+-	 */
+-	public function get_engine()
+-	{
+-		return '';
+-	}
+-
+-	/**
+-	 * {@inheritdoc}
+-	 */
+-	public function has_stopword_support()
+-	{
+-		return false;
+-	}
+-
+-	/**
+-	 * Check if index exists
+-	 *
+-	 * @param string $table Name of the table
+-	 * @param string $column Name of the column
+-	 * @return bool True if index exists, false otherwise
+-	 */
+-	protected function index_exists($table, $column)
+-	{
+-		if (!$this->is_supported())
+-		{
+-			return false;
+-		}
+-
+-		$index_name = 'idx_' . $table . '_' . $column;
+-		$sql = "SELECT name FROM sqlite_master
+-			WHERE type='index' AND name = '" . $this->db->sql_escape($index_name) . "'";
+-		$result = $this->db->sql_query($sql);
+-		$exists = (bool) $this->db->sql_fetchrow($result);
+-		$this->db->sql_freeresult($result);
+-
+-		return $exists;
+-	}
+-}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/event/listener.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/event/listener.php"
+index ac521f00f..a13f9a411 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/event/listener.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/event/listener.php"
+@@ -11,8 +11,6 @@
+ namespace vse\similartopics\event;
+ 
+ use Symfony\Component\EventDispatcher\EventSubscriberInterface;
+-use phpbb\controller\helper;
+-use phpbb\template\template;
+ 
+ /**
+  * Event listener
+@@ -22,25 +20,15 @@ class listener implements EventSubscriberInterface
+ 	/** @var \vse\similartopics\core\similar_topics */
+ 	protected $similar_topics;
+ 
+-	/** @var helper */
+-	protected $controller_helper;
+-
+-	/** @var template */
+-	protected $template;
+-
+ 	/**
+ 	 * Constructor
+ 	 *
+ 	 * @access public
+ 	 * @param \vse\similartopics\core\similar_topics $similar_topics
+-	 * @param helper $helper
+-	 * @param template $template
+ 	 */
+-	public function __construct(\vse\similartopics\core\similar_topics $similar_topics, helper $helper, template $template)
++	public function __construct(\vse\similartopics\core\similar_topics $similar_topics)
+ 	{
+ 		$this->similar_topics = $similar_topics;
+-		$this->controller_helper = $helper;
+-		$this->template = $template;
+ 	}
+ 
+ 	/**
+@@ -55,7 +43,6 @@ class listener implements EventSubscriberInterface
+ 		return [
+ 			'core.viewtopic_modify_page_title'		=> 'display_similar_topics',
+ 			'core.permissions'						=> 'add_permissions',
+-			'core.posting_modify_template_vars'		=> 'dynamic_similar_topics',
+ 		];
+ 	}
+ 
+@@ -89,33 +76,4 @@ class listener implements EventSubscriberInterface
+ 			'cat' => 'misc'
+ 		]);
+ 	}
+-
+-	/**
+-	 * Display dynamic similar topics when creating posts
+-	 *
+-	 * @access public
+-	 * @param \phpbb\event\data $event The event object
+-	 */
+-	public function dynamic_similar_topics($event)
+-	{
+-		if ($event['mode'] !== 'post'
+-			|| !empty($event['post_data']['topic_id'])
+-			|| !$this->similar_topics->is_dynamic_available())
+-		{
+-			return;
+-		}
+-
+-		$tpl_ary = [
+-			'S_DYNAMIC_SIMILAR_TOPICS' => true,
+-			'U_PST_AJAX_SEARCH' => $this->controller_helper->route('vse_similartopics_ajax_search'),
+-		];
+-
+-		if ($this->template->retrieve_var('FORUM_ID') === null)
+-		{
+-			$tpl_ary['FORUM_ID'] = isset($event['forum_id']) ? $event['forum_id'] : 0;
+-		}
+-
+-		$this->template->assign_vars($tpl_ary);
+-		$this->similar_topics->add_language();
+-	}
+ }
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/ext.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/ext.php"
+index 2717e9331..7f06e5239 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/ext.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/ext.php"
+@@ -13,13 +13,28 @@ namespace vse\similartopics;
+ class ext extends \phpbb\extension\base
+ {
+ 	/**
+-	 * Extension requires phpBB 3.2.1 or newer.
++	 * Extension requires Mysql or Postgres DBMS and phpBB 3.2.1 or newer.
+ 	 *
+-	 * @return bool
++	 * @return array|bool If phpBB 3.3.x, return message as to why it could not be installed.
++	 *                    Otherwise, just return boolean true/false.
+ 	 */
+ 	public function is_enableable()
+ 	{
+-		return
+-			phpbb_version_compare(PHPBB_VERSION, '3.2.1', '>=');
++		$db = $this->container->get('dbal.conn');
++		$valid_db = in_array($db->get_sql_layer(), array('mysqli', 'mysql4', 'postgres'));
++		$valid_phpBB = phpbb_version_compare(PHPBB_VERSION, '3.2.1', '>=');
++		$enableable = $valid_db && $valid_phpBB;
++
++		// Since showing error messages only works for phpBB 3.3.x, the only message worth showing is
++		// if the DBMS is incompatible. That is, we can't show somebody on phpBB 3.2.x. the message that
++		// their board is too old, so there's no reason to handle invalid phpBB version messages here.
++		if (!$enableable && phpbb_version_compare(PHPBB_VERSION, '3.3.0-b1', '>='))
++		{
++			$lang = $this->container->get('language');
++			$lang->add_lang('acp_similar_topics', 'vse/similartopics');
++			return array($lang->lang('PST_NO_COMPAT'));
++		}
++
++		return $enableable;
+ 	}
+ }
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/ar/acp_similar_topics.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/language/ar/acp_similar_topics.php"
+index 957faedc6..a0cfa1e72 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/ar/acp_similar_topics.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/language/ar/acp_similar_topics.php"
+@@ -43,7 +43,6 @@ $lang = array_merge($lang, array(
+ 	'PST_EXPLAIN'		=> 'سيتم عرض قائمة بمواضيع متشابهة ( لها علاقة ) في أسفل صفحة الموضوع الذي يتم مُشاهدته.',
+ 	'PST_LEGEND1'		=> 'إعدادات عامة',
+ 	'PST_ENABLE'		=> 'إظهار المواضيع المُتشابهه ',
+-	'PST_ENABLE_EXPLAIN'=> 'Show similar topics in topic discussion threads.',
+ 	'PST_LEGEND2'		=> 'إعدادات التحميل',
+ 	'PST_LIMIT'			=> 'عدد المواضيع المُتشابهه ',
+ 	'PST_LIMIT_EXPLAIN'	=> 'تستطيع هنا تحديد عدد المواضيع المُتشابهه التي سيتم عرضها في صفحة المواضيع. العدد الإفتراضي هو 5 مواضيع.',
+@@ -55,10 +54,8 @@ $lang = array_merge($lang, array(
+ 	'PST_DAYS'			=> 'أيام',
+ 	'PST_CACHE'			=> 'فترة الملفات المؤقتة',
+ 	'PST_CACHE_EXPLAIN'	=> 'سيتم حذف الملفات المؤقتة للمواضيع المُتشابهه بعد تحديد الفترة هنا بالثواني. الصفر يعني تعطيل هذا الخيار.',
+-	'PST_DYNAMIC'		=> 'Display dynamic similar topics',
+-	'PST_DYNAMIC_EXPLAIN'=> 'Show similar topics as users type in the topic title field when creating new topics.',
+ 	'PST_SENSE'			=> 'حساسية البحث',
+-	'PST_SENSE_EXPLAIN'	=> 'حدد درجة حساسية البحث من القيمة 1 و 10. استخدم القيمة الأقل إذا لا تشاهد أي نتائج للمواضيع المُتشابهه. الإعدادات الموصى بها : <samp>%d</samp>',
++	'PST_SENSE_EXPLAIN'	=> 'حدد درجة حساسية البحث من القيمة 1 و 10. استخدم القيمة الأقل إذا لا تشاهد أي نتائج للمواضيع المُتشابهه. الإعدادات الموصى بها : استخدم القيمة 1 للجداول “phpbb_topics” في قاعدة البيانات InnoDB; استخدم 5 لقاعدة البيانات MyISAM.',
+ 	'PST_LEGEND3'		=> 'إعدادات المنتدى',
+ 	'PST_NOSHOW_LIST'	=> 'لا تعرض في',
+ 	'PST_NOSHOW_TITLE'	=> 'لا تعرض المواضيع المُتشابهه في',
+@@ -67,14 +64,14 @@ $lang = array_merge($lang, array(
+ 	'PST_STANDARD'		=> 'قياسي',
+ 	'PST_ADVANCED'		=> 'متقدم',
+ 	'PST_ADVANCED_TITLE'=> 'انقر  لضبط الإعدادات المتقدمة لـ',
+-	'PST_ADVANCED_EXP'	=> 'تستطيع من هنا تحديد المنتديات التي تريد جلب المواضيع المُتشابهه منها. المواضيع المُتشابهه الموجودة فقط في المنتديات المُحددة ستظهر في <strong>%s</strong>. <br><br>سيتم جلب المواضيع المُتشابهه من جميع المنتديات في حالة عدم تحديد أي منتدى.<br><br>تحديد أو الغاء التحديد يكون بواسطة الضغط باستمرار على زر الكنترول CTRL والنقر على المنتدى المطلوب.',
++	'PST_ADVANCED_EXP'	=> 'تستطيع من هنا تحديد المنتديات التي تريد جلب المواضيع المُتشابهه منها. المواضيع المُتشابهه الموجودة فقط في المنتديات المُحددة ستظهر في <strong>%s</strong>. <br /><br />سيتم جلب المواضيع المُتشابهه من جميع المنتديات في حالة عدم تحديد أي منتدى.<br /><br />تحديد أو الغاء التحديد يكون بواسطة الضغط باستمرار على زر الكنترول CTRL والنقر على المنتدى المطلوب.',
+ 	'PST_ADVANCED_FORUM'=> 'إعدادات متقدمة للمنتدى',
+ 	'PST_DESELECT_ALL'	=> 'الغاء تحديد الكل',
+ 	'PST_LEGEND4'		=> 'إعدادات اختيارية',
+ 	'PST_WORDS'			=> 'كلمات مُستبعدة',
+ 	'PST_WORDS_EXPLAIN'	=> 'سيتم استبعاد الكلمات التي ستضيفها هنا عند البحث عن المواضيع المُتشابهة. ( ملاحظة : يتم استبعاد الكلمات التي تعتبر شائعة في لغتك بصورة افتراضية ). اعمل مسافة بين كل كلمة وأخرى. هذا الخيار غير دقيق لتطابق الكلمات. الحد الأقصى هو 255 حرف.',
+ 	'PST_SAVED'			=> 'تم تحديث إعدادات المواضيع المُتشابهه',
+-	'PST_FORUM_INFO'	=> '" لا تعرض في " : يعني عدم اظهار المواضيع المُتشابهه في المنتديات المُحددة.<br>" لا تبحث في " : يعني عدم البحث عن المواضيع المُتشابهه في المنتديات المُحددة.',
++	'PST_FORUM_INFO'	=> '" لا تعرض في " : يعني عدم اظهار المواضيع المُتشابهه في المنتديات المُحددة.<br />" لا تبحث في " : يعني عدم البحث عن المواضيع المُتشابهه في المنتديات المُحددة.',
+ 	'PST_NO_COMPAT'		=> 'إضافة "المواضيع المُتشابهه" لا تتوافق مع منتداك. فهي تعمل فقط على قاعدة البيانات MySQL 4 أو MySQL 5 أو PostgreSQL.',
+ 	'PST_ERR_CONFIG'	=> 'أيضا تميزت العديد من المنتديات في قائمة من المنتديات. يرجى المحاولة مرة أخرى مع مجموعة أصغر.',
+ ));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/cs/acp_similar_topics.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/language/cs/acp_similar_topics.php"
+index d80b5ea61..f221da47a 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/cs/acp_similar_topics.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/language/cs/acp_similar_topics.php"
+@@ -42,7 +42,6 @@ $lang = array_merge($lang, array(
+ 	'PST_EXPLAIN'		=> 'Toto rozšíření zobrazí na spodu každého tématu odkazy na několik podobných (souvisejících) témat.',
+ 	'PST_LEGEND1'		=> 'Hlavní nastavení',
+ 	'PST_ENABLE'		=> 'Zobrazit podobná témata',
+-	'PST_ENABLE_EXPLAIN'=> 'Show similar topics in topic discussion threads.',
+ 	'PST_LEGEND2'		=> 'Nastavení zatížení',
+ 	'PST_LIMIT'			=> 'Počet podobných témat',
+ 	'PST_LIMIT_EXPLAIN'	=> 'Zde můžete zvolit počet podobných témat, která se zobrazí. Výchozí nastavení je 5 témat.',
+@@ -54,10 +53,8 @@ $lang = array_merge($lang, array(
+ 	'PST_DAYS'			=> 'Dny',
+ 	'PST_CACHE'			=> 'Životnost cache',
+ 	'PST_CACHE_EXPLAIN'	=> 'Cache podobných témat se vyprázdní po daném čase (v sekundách). Pokud nastavíte na 0, cache bude vypnuta.',
+-	'PST_DYNAMIC'		=> 'Display dynamic similar topics',
+-	'PST_DYNAMIC_EXPLAIN'=> 'Show similar topics as users type in the topic title field when creating new topics.',
+ 	'PST_SENSE'			=> 'Search sensitivity',
+-	'PST_SENSE_EXPLAIN'	=> 'For MySQL or Postgres databases, you can set the search sensitivity to a value between 1 and 10. Use a lower number if you are not seeing any similar topics. Recommended setting: %d',
++	'PST_SENSE_EXPLAIN'	=> 'Set the search sensitivity to a value between 1 and 10. Use a lower number if you are not seeing any similar topics. Recommended settings: For “phpbb_topics” database tables using InnoDB use 1; for MyISAM use 5.',
+ 	'PST_LEGEND3'		=> 'Nastavení fór',
+ 	'PST_NOSHOW_LIST'	=> 'Nezobrazovat',
+ 	'PST_NOSHOW_TITLE'	=> 'Nezobrazovat podobná témata v',
+@@ -66,14 +63,14 @@ $lang = array_merge($lang, array(
+ 	'PST_STANDARD'		=> 'Standartní',
+ 	'PST_ADVANCED'		=> 'Rozšířené',
+ 	'PST_ADVANCED_TITLE'=> 'Kliknutím provedete rozšířená nastavení pro fórum',
+-	'PST_ADVANCED_EXP'	=> 'Zde můžete vybrat pouze určité sekce, ve kterých chcete, aby se podobná témata vyhledávala. Poté budou v sekci <strong>%s</strong> zobrazena pouze podobná témata z těchto vybraných fór.<br><br>Pokud nevyberete žádná fóra, rozšíření bude podobná témata vyhledávat po celém fóru.<br><br>Výběr více fór můžete provést se stisknoutou klávesou <code>CTRL</code> (případně <code>CMD</code> pro Mac).',
++	'PST_ADVANCED_EXP'	=> 'Zde můžete vybrat pouze určité sekce, ve kterých chcete, aby se podobná témata vyhledávala. Poté budou v sekci <strong>%s</strong> zobrazena pouze podobná témata z těchto vybraných fór.<br /><br />Pokud nevyberete žádná fóra, rozšíření bude podobná témata vyhledávat po celém fóru.<br /><br />Výběr více fór můžete provést se stisknoutou klávesou <code>CTRL</code> (případně <code>CMD</code> pro Mac).',
+ 	'PST_ADVANCED_FORUM'=> 'Rozšířené nastavení fóra',
+ 	'PST_DESELECT_ALL'	=> 'Zrušit výběr všech',
+ 	'PST_LEGEND4'		=> 'Volitelná nastavení',
+ 	'PST_WORDS'			=> 'Ignorovaná slova',
+ 	'PST_WORDS_EXPLAIN'	=> 'Zde můžete uvést seznam slov, u kterých si přejete, aby se při vyhledávání podobných témat ignorovala. (Pozn.: Slova, která jsou ve vašem jazyce považována za běžná, uvádět nemusíte (jsou ignorována automaticky). Jednotlivá slova oddělte mezerou. Nezáleží na velikosti písmen.',
+ 	'PST_SAVED'			=> 'Nastavení podobných témat bylo úspěšně změněno',
+-	'PST_FORUM_INFO'	=> '“Nezobrazovat”: Nebude ve vybraných fórech zobrazovat podobná témata.<br>“Nevyhledávat” : Ve vybraných fórech se nebudou vyhledávat podobná témata.',
++	'PST_FORUM_INFO'	=> '“Nezobrazovat”: Nebude ve vybraných fórech zobrazovat podobná témata.<br />“Nevyhledávat” : Ve vybraných fórech se nebudou vyhledávat podobná témata.',
+ 	'PST_NO_COMPAT'		=> 'Podobná témata nejsou kompatibilní s vašim fórem. Jsou vyžadovány technologie MySQL 4 nebo MySQL 5 nebo PostgreSQL.',
+ 	'PST_ERR_CONFIG'	=> 'Z hledání/zobrazení bylo vyřazeno příliš mnoho sekcí. Snižte prosím počet vybraných sekcí.',
+ ));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/de/acp_similar_topics.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/language/de/acp_similar_topics.php"
+index 12b4466c7..0b2b7f4e5 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/de/acp_similar_topics.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/language/de/acp_similar_topics.php"
+@@ -42,7 +42,6 @@ $lang = array_merge($lang, array(
+ 	'PST_EXPLAIN'		=> 'Präzise Vergleichbare Themen zeigt eine Liste von ähnlichen Themen am unteren Rand des aktuellen Themas der Seite.',
+ 	'PST_LEGEND1'		=> 'Allgemeine Einstellungen',
+ 	'PST_ENABLE'		=> 'Aktiviere Vergleichbare Themen',
+-	'PST_ENABLE_EXPLAIN'=> 'Show similar topics in topic discussion threads.',
+ 	'PST_LEGEND2'		=> 'Lade Einstellungen',
+ 	'PST_LIMIT'			=> 'Anzahl der angezeigten Vergleichbaren Themen',
+ 	'PST_LIMIT_EXPLAIN'	=> 'Hier kannst du einstellen, wieviel Vergleichbare Themen angezeigt werden sollen. Standard sind 5 Themen.',
+@@ -54,10 +53,8 @@ $lang = array_merge($lang, array(
+ 	'PST_DAYS'			=> 'Tage',
+ 	'PST_CACHE'			=> 'Zeitraum der Zwischenspeicherung für Vergleichbare Themen',
+ 	'PST_CACHE_EXPLAIN'	=> 'Zwischengespeichterte Vergleichbare Themen werden nach dieser Zeit verfallen. In Sekunden angeben. Auf 0 setzen, wenn du den Zwichenspeicher deaktivieren willst.',
+-	'PST_DYNAMIC'		=> 'Display dynamic similar topics',
+-	'PST_DYNAMIC_EXPLAIN'=> 'Show similar topics as users type in the topic title field when creating new topics.',
+ 	'PST_SENSE'			=> 'Search sensitivity',
+-	'PST_SENSE_EXPLAIN'	=> 'For MySQL or Postgres databases, you can set the search sensitivity to a value between 1 and 10. Use a lower number if you are not seeing any similar topics. Recommended setting: %d',
++	'PST_SENSE_EXPLAIN'	=> 'Set the search sensitivity to a value between 1 and 10. Use a lower number if you are not seeing any similar topics. Recommended settings: For “phpbb_topics” database tables using InnoDB use 1; for MyISAM use 5.',
+ 	'PST_LEGEND3'		=> 'Foren',
+ 	'PST_NOSHOW_LIST'	=> 'Nicht anzeigen in',
+ 	'PST_NOSHOW_TITLE'	=> 'Vergleichbare Themen nicht anzeigen in',
+@@ -66,14 +63,14 @@ $lang = array_merge($lang, array(
+ 	'PST_STANDARD'		=> 'Standard',
+ 	'PST_ADVANCED'		=> 'Erweiterte Einstellungen',
+ 	'PST_ADVANCED_TITLE'=> 'Klicken um erweiterte Einstellungen für Vergleichbare Themen vorzunehmen',
+-	'PST_ADVANCED_EXP'	=> 'Hier kannst du spezifische Foren auswählen aus denen Vergleichbare Themen angezeigt werden sollen. Es werden nur Vergleichbare Themen in Foren, die du die hier einstellst, angezeigt <strong>%s</strong>.<br><br>Wählen keine Foren, wenn Vergleichbare Themen aus allen durchsuchbaren Foren in diesem Forum angezeigt werden sollen.<br><br>Wähle mehrere Foren aus/ab, indem du beim Klicken die <code>Strg</code>-Taste drückst.',
++	'PST_ADVANCED_EXP'	=> 'Hier kannst du spezifische Foren auswählen aus denen Vergleichbare Themen angezeigt werden sollen. Es werden nur Vergleichbare Themen in Foren, die du die hier einstellst, angezeigt <strong>%s</strong>.<br /><br />Wählen keine Foren, wenn Vergleichbare Themen aus allen durchsuchbaren Foren in diesem Forum angezeigt werden sollen.<br /><br />Wähle mehrere Foren aus/ab, indem du beim Klicken die <code>Strg</code>-Taste drückst.',
+ 	'PST_ADVANCED_FORUM'=> 'Erweiterte Foren Einstellungen',
+ 	'PST_DESELECT_ALL'	=> 'Alle abwählen',
+ 	'PST_LEGEND4'		=> 'Optionale Einstellungen',
+ 	'PST_WORDS'			=> 'Spezielle Wörter zu ignorieren',
+ 	'PST_WORDS_EXPLAIN'	=> 'Füge Wörter hinzu, die speziell in deinem Forum häufig vorkommen und deshalb ignoriert werden sollen. (Hinweis: Wörter, die derzeit in deiner Sprache als häufig angesehen werden, werden bereits standardmäßig ignoriert.) Trenne die Worte mit Leerzeichen, Groß-/Kleinschreibung wird ignoriert.',
+ 	'PST_SAVED'			=> 'Einstellungen für Vergleichbare Themen aktualisiert',
+-	'PST_FORUM_INFO'	=> '“Nicht anzeigen in”: Wird die Anzeige von Vergleichbaren Themen in den ausgewählten Foren deaktivieren.<br>“Nicht Suchen Nach in” : Wird die ausgewählten Foren bei der Suche nach Vergleichbaren Themen ignorieren.',
++	'PST_FORUM_INFO'	=> '“Nicht anzeigen in”: Wird die Anzeige von Vergleichbaren Themen in den ausgewählten Foren deaktivieren.<br />“Nicht Suchen Nach in” : Wird die ausgewählten Foren bei der Suche nach Vergleichbaren Themen ignorieren.',
+ 	'PST_NO_COMPAT'		=> 'Vergleichbare Themen werden in diesem Forum nicht funktionieren. Vergleichbare Themen erfordert eine MySQL 4 oder MySQL 5 oder PostgreSQL Datenbank.',
+ 	'PST_ERR_CONFIG'	=> 'Zu viele Foren wurden in die Liste der Foren markiert. Bitte versuchen Sie es mit einer kleineren Auswahl.',
+ ));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/el/acp_similar_topics.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/language/el/acp_similar_topics.php"
+index ebd97602d..7f8ed8260 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/el/acp_similar_topics.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/language/el/acp_similar_topics.php"
+@@ -42,7 +42,6 @@ $lang = array_merge($lang, array(
+ 	'PST_EXPLAIN'		=> 'Εμφανίζει μια λίστα παραπλήσιων (συναφών) θεμάτων στο τέλος της τρέχουσας σελίδας θέματος.',
+ 	'PST_LEGEND1'		=> 'Γενικές ρυθμίσεις',
+ 	'PST_ENABLE'		=> 'Εμφάνιση παραπλήσιων θεμάτων',
+-	'PST_ENABLE_EXPLAIN'=> 'Show similar topics in topic discussion threads.',
+ 	'PST_LEGEND2'		=> 'Ρυθμίσεις εμφάνισης',
+ 	'PST_LIMIT'			=> 'Αριθμός παραπλήσιων θεμάτων που θα εμφανίζονται',
+ 	'PST_LIMIT_EXPLAIN'	=> 'Εδώ μπορείτε να ορίσετε πόσα παραπλήσια θέματα θα εμφανίζονται. Η προεπιλογή είναι 5 θέματα.',
+@@ -54,10 +53,8 @@ $lang = array_merge($lang, array(
+ 	'PST_DAYS'			=> 'Ημέρες',
+ 	'PST_CACHE'			=> 'Μέγεθος μνήμης παραπλήσιων θεμάτων',
+ 	'PST_CACHE_EXPLAIN'	=> 'Η αποθηκευμένη μνήμη παραπλήσιων θεμάτων θα λήξει μετά από αυτό το διάστημα, σε δευτερόλεπτα. Θέστε σε "0" αν θέλετε να απενεργοποιήσετε την αποθηκευμένη μνήμη παραπλήσιων θεμάτων.',
+-	'PST_DYNAMIC'		=> 'Display dynamic similar topics',
+-	'PST_DYNAMIC_EXPLAIN'=> 'Show similar topics as users type in the topic title field when creating new topics.',
+ 	'PST_SENSE'			=> 'Ευαισθησία αναζήτησης',
+-	'PST_SENSE_EXPLAIN'	=> 'Ρυθμίστε την ευαισθησία αναζήτησης σε μια τιμή μεταξύ 1 και 10. Χρησιμοποιήστε μικρότερο αριθμό εάν δεν βλέπετε παρόμοια θέματα. Προτεινόμενες ρυθμίσεις: %d',
++	'PST_SENSE_EXPLAIN'	=> 'Ρυθμίστε την ευαισθησία αναζήτησης σε μια τιμή μεταξύ 1 και 10. Χρησιμοποιήστε μικρότερο αριθμό εάν δεν βλέπετε παρόμοια θέματα. Προτεινόμενες ρυθμίσεις: Για πίνακες βάσης δεδομένων "phpbb_topics" τύπου InnoDB χρησιμοποιείστε 1, για MyISAM χρησιμοποιείστε 5.',
+ 	'PST_LEGEND3'		=> 'Ρυθμίσεις Δημ. Συζήτησης',
+ 	'PST_NOSHOW_LIST'	=> 'Να μην εμφανίζονται σε',
+ 	'PST_NOSHOW_TITLE'	=> 'Να μην εμφανίζονται παραπλήσια θέματα σε',
+@@ -66,14 +63,14 @@ $lang = array_merge($lang, array(
+ 	'PST_STANDARD'		=> 'Τυπικές',
+ 	'PST_ADVANCED'		=> 'Σύνθετες',
+ 	'PST_ADVANCED_TITLE'=> 'Πατήστε για περισσότερες ρυθμίσεις παραπλήσιων θεμάτων στο θέμα',
+-	'PST_ADVANCED_EXP'	=> 'Εδώ μπορείτε να επιλέξετε συγκεκριμένες Δημ. Συζητήσεις από τις οποίες θα τραβήξει παραπλήσια θέματα. Μόνο παραπλήσια θέματα που βρέθηκαν στις Δημ. Συζητήσεις που επιλέγετε εδώ θα εμφανιστούν στην ενότητα <strong>%s</strong>.<br><br>Μην επιλέξετε καμία Δημ. Συζήτηση, αν θέλετε παραπλήσια θέματα από όλες τις Δημ. Συζητήσεις να εμφανίζονται σε αυτή τη Δημ. Συζήτηση.<br><br>Για να επιλέξτε/αποεπιλέξτε πολλές Δ. Συζητήσεις κρατήστε πατημένο το <code>CTRL</code> και κάντε κλικ.',
++	'PST_ADVANCED_EXP'	=> 'Εδώ μπορείτε να επιλέξετε συγκεκριμένες Δημ. Συζητήσεις από τις οποίες θα τραβήξει παραπλήσια θέματα. Μόνο παραπλήσια θέματα που βρέθηκαν στις Δημ. Συζητήσεις που επιλέγετε εδώ θα εμφανιστούν στην ενότητα <strong>%s</strong>.<br /><br />Μην επιλέξετε καμία Δημ. Συζήτηση, αν θέλετε παραπλήσια θέματα από όλες τις Δημ. Συζητήσεις να εμφανίζονται σε αυτή τη Δημ. Συζήτηση.<br /><br />Για να επιλέξτε/αποεπιλέξτε πολλές Δ. Συζητήσεις κρατήστε πατημένο το <code>CTRL</code> και κάντε κλικ.',
+ 	'PST_ADVANCED_FORUM'=> 'Σύνθετες ρυθμίσεις',
+ 	'PST_DESELECT_ALL'	=> 'Αποεπιλογή όλων',
+ 	'PST_LEGEND4'		=> 'Προαιρετκές ρυθμίσεις',
+ 	'PST_WORDS'			=> 'Ειδικές λέξεις για αγνόηση',
+ 	'PST_WORDS_EXPLAIN'	=> 'Προσθέστε ειδικές λέξεις μοναδικές στη Δ. Συζήτησή σας, που θέλετε να αγνοηθούν κατά την εύρεση παραπλήσιων θεμάτων. (Σημείωση: Οι λέξεις που  σήμερα θεωρούνται κοινές στη γλώσσα σας αγνοούνται από προεπιλογή.) Χωρίστε κάθε λέξη με ένα κενό. Με πεζά ή κεφαλαία.',
+ 	'PST_SAVED'			=> 'Οι ρυθμίσεις των Παραπλήσιων Θεμάτων ενημερώθηκαν',
+-	'PST_FORUM_INFO'	=> '"Να μην εμφανίζονται σε": Δεν θα εμφανίζονται παραπλήσια θέματα στις επιλεγμένες Δημ. Συζητήσεις.<br>"Να μην αναζητούνται σε": Δεν θα αναζητούνται παραπλήσια θέματα στις επιλεγμένες Δημ. Συζητήσεις.',
++	'PST_FORUM_INFO'	=> '"Να μην εμφανίζονται σε": Δεν θα εμφανίζονται παραπλήσια θέματα στις επιλεγμένες Δημ. Συζητήσεις.<br />"Να μην αναζητούνται σε": Δεν θα αναζητούνται παραπλήσια θέματα στις επιλεγμένες Δημ. Συζητήσεις.',
+ 	'PST_NO_COMPAT'		=> 'Το "Παραπλήσια Θέματα" δεν είναι συμβατό με τη Δ. Συζήτησή σας. Μπορεί να λειτουργήσει μόνο σε βάσεις δεδομένων με MySQL 4 ή MySQL 5 ή PostgreSQL.',
+ 	'PST_ERR_CONFIG'	=> 'Too many forums were marked in the list of forums. Please try again with a smaller selection.',
+ ));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/en/acp_similar_topics.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/language/en/acp_similar_topics.php"
+index c8fed39b9..2807c9f00 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/en/acp_similar_topics.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/language/en/acp_similar_topics.php"
+@@ -39,25 +39,22 @@ if (empty($lang) || !is_array($lang))
+ 
+ $lang = array_merge($lang, array(
+ 	'PST_TITLE_ACP'		=> 'Precise Similar Topics',
+-	'PST_EXPLAIN'		=> 'Precise Similar Topics displays a list of similar (related) topics. Similar topics can be shown at the bottom of the current topic’s discussion thread and/or when a user is writing a title for a new post.',
++	'PST_EXPLAIN'		=> 'Precise Similar Topics displays a list of similar (related) topics at the bottom of the current topic’s page.',
+ 	'PST_LEGEND1'		=> 'General settings',
+-	'PST_ENABLE'		=> 'Display similar topics',
+-	'PST_ENABLE_EXPLAIN'=> 'Show similar topics in topic discussion threads.',
++	'PST_ENABLE'		=> 'Display Similar Topics',
+ 	'PST_LEGEND2'		=> 'Load settings',
+-	'PST_LIMIT'			=> 'Number of similar topics to display',
++	'PST_LIMIT'			=> 'Number of Similar Topics to display',
+ 	'PST_LIMIT_EXPLAIN'	=> 'Here you can define how many similar topics to display. The default is 5 topics.',
+ 	'PST_TIME'			=> 'Search period',
+-	'PST_TIME_EXPLAIN'	=> 'This option allows you to confine similar topics results to newer topics (and prevent reviving old threads). For example, if set to “30 days” the system will only show similar topics from within the last 30 days. The default is 1 year. Set it to 99 years if you want to effectively disable this feature.',
++	'PST_TIME_EXPLAIN'	=> 'This option allows you to confine Similar Topics results to newer topics (and prevent reviving old threads). For example, if set to “30 days” the system will only show similar topics from within the last 30 days. The default is 1 year. Set it to 99 years if you want to effectively disable this feature.',
+ 	'PST_YEARS'			=> 'Years',
+ 	'PST_MONTHS'		=> 'Months',
+ 	'PST_WEEKS'			=> 'Weeks',
+ 	'PST_DAYS'			=> 'Days',
+-	'PST_CACHE'			=> 'Similar topics cache length',
++	'PST_CACHE'			=> 'Similar Topics cache length',
+ 	'PST_CACHE_EXPLAIN'	=> 'Cached similar topics will expire after this time, in seconds. Set to 0 if you want to disable the similar topics cache.',
+-	'PST_DYNAMIC'		=> 'Display dynamic similar topics',
+-	'PST_DYNAMIC_EXPLAIN'=> 'Show similar topics as users type in the topic title field when creating new topics.',
+ 	'PST_SENSE'			=> 'Search sensitivity',
+-	'PST_SENSE_EXPLAIN'	=> 'For MySQL or Postgres databases, you can set the search sensitivity to a value between 1 and 10. Use a lower number if you are not seeing any similar topics. Recommended setting: %d',
++	'PST_SENSE_EXPLAIN'	=> 'Set the search sensitivity to a value between 1 and 10. Use a lower number if you are not seeing any similar topics. Recommended settings: For “phpbb_topics” database tables using InnoDB use 1; for MyISAM use 5.',
+ 	'PST_LEGEND3'		=> 'Forum settings',
+ 	'PST_NOSHOW_LIST'	=> 'Do Not Display In',
+ 	'PST_NOSHOW_TITLE'	=> 'Do not display similar topics in',
+@@ -66,14 +63,14 @@ $lang = array_merge($lang, array(
+ 	'PST_STANDARD'		=> 'Standard',
+ 	'PST_ADVANCED'		=> 'Advanced',
+ 	'PST_ADVANCED_TITLE'=> 'Click to set up advanced similar topic settings for',
+-	'PST_ADVANCED_EXP'	=> 'Here you can select specific forums to pull similar topics from. Only similar topics found in the forums you select here will be displayed in <strong>%s</strong>.<br><br>Do not select any forums if you want similar topics from all searchable forums to be displayed in this forum.<br><br>Select multiple forums by holding <samp>CTRL</samp> (or <samp>&#8984;CMD</samp> on Mac) and clicking.',
++	'PST_ADVANCED_EXP'	=> 'Here you can select specific forums to pull similar topics from. Only similar topics found in the forums you select here will be displayed in <strong>%s</strong>.<br /><br />Do not select any forums if you want similar topics from all searchable forums to be displayed in this forum.<br /><br />Select multiple forums by holding <samp>CTRL</samp> (or <samp>&#8984;CMD</samp> on Mac) and clicking.',
+ 	'PST_ADVANCED_FORUM'=> 'Advanced forum settings',
+ 	'PST_DESELECT_ALL'	=> 'Deselect all',
+ 	'PST_LEGEND4'		=> 'Optional settings',
+ 	'PST_WORDS'			=> 'Special words to ignore',
+ 	'PST_WORDS_EXPLAIN'	=> 'Add special words unique to your forum that should be ignored when finding similar topics. (Note: Words that are currently regarded as common in your language are already ignored by default.) Separate each word with a space. Case insensitive.',
+-	'PST_SAVED'			=> 'Precise Similar Topics settings updated',
+-	'PST_FORUM_INFO'	=> '“Do Not Display In”: Will not show similar topics in the selected forums.<br>“Do Not Search In” : Will not search for similar topics in the selected forums.',
+-	'PST_NO_COMPAT'		=> 'Precise Similar Topics is not compatible with your forum.',
++	'PST_SAVED'			=> 'Similar Topics settings updated',
++	'PST_FORUM_INFO'	=> '“Do Not Display In”: Will not show similar topics in the selected forums.<br />“Do Not Search In” : Will not search for similar topics in the selected forums.',
++	'PST_NO_COMPAT'		=> 'Similar Topics is not compatible with your forum. Similar Topics will only run on a MySQL or PostgreSQL database.',
+ 	'PST_ERR_CONFIG'	=> 'Too many forums were marked in the list of forums. Please try again with a smaller selection.',
+ ));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/en/search_ignore_words.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/en/search_ignore_words.php"
+deleted file mode 100644
+index 82f50a7d3..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/en/search_ignore_words.php"
++++ /dev/null
+@@ -1,598 +0,0 @@
+-<?php
+-/**
+- *
+- * Precise Similar Topics
+- *
+- * @copyright (c) 2025 Matt Friedman
+- * @license GNU General Public License, version 2 (GPL-2.0)
+- *
+- * This [en] language list of stop words created by Matt Friedman for Similar Topics
+- *
+- */
+-
+-if (!defined('IN_PHPBB'))
+-{
+-	exit;
+-}
+-
+-$words = array(
+-	'a',
+-	'able',
+-	'about',
+-	'above',
+-	'according',
+-	'accordingly',
+-	'across',
+-	'actually',
+-	'afaik',
+-	'after',
+-	'afterwards',
+-	'again',
+-	'against',
+-	'ago',
+-	'aint',
+-	'all',
+-	'allow',
+-	'allows',
+-	'almost',
+-	'alone',
+-	'along',
+-	'alot',
+-	'already',
+-	'also',
+-	'although',
+-	'always',
+-	'am',
+-	'among',
+-	'amongst',
+-	'an',
+-	'and',
+-	'another',
+-	'answer',
+-	'any',
+-	'anybody',
+-	'anybodys',
+-	'anyhow',
+-	'anyone',
+-	'anything',
+-	'anyway',
+-	'anyways',
+-	'anywhere',
+-	'apart',
+-	'appear',
+-	'appreciate',
+-	'appropriate',
+-	'are',
+-	'arent',
+-	'around',
+-	'as',
+-	'aside',
+-	'ask',
+-	'askd',
+-	'asking',
+-	'associated',
+-	'at',
+-	'available',
+-	'away',
+-	'awfully',
+-	'bad',
+-	'be',
+-	'became',
+-	'because',
+-	'become',
+-	'becomes',
+-	'becoming',
+-	'been',
+-	'before',
+-	'beforehand',
+-	'behind',
+-	'being',
+-	'believe',
+-	'below',
+-	'beside',
+-	'besides',
+-	'best',
+-	'better',
+-	'between',
+-	'beyond',
+-	'big',
+-	'both',
+-	'brief',
+-	'btw',
+-	'but',
+-	'by',
+-	'came',
+-	'can',
+-	'cant',
+-	'cannot',
+-	'cause',
+-	'causes',
+-	'certain',
+-	'certainly',
+-	'changes',
+-	'clearly',
+-	'co',
+-	'com',
+-	'come',
+-	'comes',
+-	'concerning',
+-	'consequently',
+-	'consider',
+-	'considering',
+-	'contain',
+-	'containing',
+-	'contains',
+-	'corresponding',
+-	'could',
+-	'couldnt',
+-	'course',
+-	'currently',
+-	'day',
+-	'days',
+-	'definitely',
+-	'described',
+-	'despite',
+-	'did',
+-	'didnt',
+-	'different',
+-	'do',
+-	'does',
+-	'doesnt',
+-	'doing',
+-	'done',
+-	'dont',
+-	'down',
+-	'downwards',
+-	'during',
+-	'each',
+-	'edu',
+-	'eg',
+-	'eight',
+-	'either',
+-	'else',
+-	'elsewhere',
+-	'enough',
+-	'entirely',
+-	'especially',
+-	'et',
+-	'etc',
+-	'even',
+-	'ever',
+-	'every',
+-	'everybody',
+-	'everybodys',
+-	'everyone',
+-	'everything',
+-	'everywhere',
+-	'ex',
+-	'exactly',
+-	'example',
+-	'except',
+-	'far',
+-	'few',
+-	'fifth',
+-	'find',
+-	'first',
+-	'five',
+-	'followed',
+-	'following',
+-	'follows',
+-	'for',
+-	'former',
+-	'formerly',
+-	'forth',
+-	'found',
+-	'four',
+-	'from',
+-	'further',
+-	'furthermore',
+-	'get',
+-	'gets',
+-	'getting',
+-	'given',
+-	'gives',
+-	'go',
+-	'goes',
+-	'going',
+-	'gone',
+-	'good',
+-	'got',
+-	'gotten',
+-	'greetings',
+-	'had',
+-	'hadnt',
+-	'happens',
+-	'hardly',
+-	'has',
+-	'hasnt',
+-	'have',
+-	'havent',
+-	'having',
+-	'he',
+-	'hello',
+-	'help',
+-	'hence',
+-	'her',
+-	'here',
+-	'hereafter',
+-	'hereby',
+-	'herein',
+-	'hereupon',
+-	'hers',
+-	'herself',
+-	'hi',
+-	'him',
+-	'himself',
+-	'his',
+-	'hither',
+-	'hopefully',
+-	'how',
+-	'howbeit',
+-	'however',
+-	'hows',
+-	'href',
+-	'i',
+-	'id',
+-	'ie',
+-	'if',
+-	'ignored',
+-	'iirc',
+-	'immediate',
+-	'in',
+-	'inasmuch',
+-	'inc',
+-	'indeed',
+-	'indicate',
+-	'indicated',
+-	'indicates',
+-	'ini',
+-	'inner',
+-	'insofar',
+-	'instead',
+-	'into',
+-	'inward',
+-	'is',
+-	'isnt',
+-	'it',
+-	'itd',
+-	'itll',
+-	'its',
+-	'itself',
+-	'ive',
+-	'just',
+-	'keep',
+-	'keeps',
+-	'kept',
+-	'know',
+-	'known',
+-	'knows',
+-	'large',
+-	'last',
+-	'lately',
+-	'later',
+-	'latter',
+-	'latterly',
+-	'least',
+-	'less',
+-	'lest',
+-	'let',
+-	'lets',
+-	'like',
+-	'liked',
+-	'likely',
+-	'little',
+-	'look',
+-	'looked',
+-	'looking',
+-	'looks',
+-	'lot',
+-	'ltd',
+-	'mainly',
+-	'many',
+-	'may',
+-	'maybe',
+-	'mean',
+-	'meanwhile',
+-	'me',
+-	'merely',
+-	'might',
+-	'more',
+-	'moreover',
+-	'most',
+-	'mostly',
+-	'much',
+-	'must',
+-	'mustnt',
+-	'my',
+-	'myself',
+-	'name',
+-	'namely',
+-	'nd',
+-	'near',
+-	'nearly',
+-	'necessary',
+-	'need',
+-	'needs',
+-	'never',
+-	'nevertheless',
+-	'new',
+-	'news',
+-	'next',
+-	'nine',
+-	'no',
+-	'nobody',
+-	'non',
+-	'none',
+-	'noone',
+-	'nor',
+-	'normally',
+-	'not',
+-	'nothing',
+-	'novel',
+-	'now',
+-	'nowhere',
+-	'obviously',
+-	'of',
+-	'off',
+-	'often',
+-	'oh',
+-	'ok',
+-	'okay',
+-	'old',
+-	'on',
+-	'once',
+-	'one',
+-	'ones',
+-	'only',
+-	'onto',
+-	'oops',
+-	'or',
+-	'other',
+-	'others',
+-	'otherwise',
+-	'ought',
+-	'our',
+-	'ours',
+-	'ourselves',
+-	'out',
+-	'outside',
+-	'over',
+-	'overall',
+-	'own',
+-	'page',
+-	'particular',
+-	'particularly',
+-	'per',
+-	'perhaps',
+-	'placed',
+-	'please',
+-	'plus',
+-	'possible',
+-	'presumably',
+-	'probably',
+-	'provides',
+-	'put',
+-	'que',
+-	'question',
+-	'questioned',
+-	'questions',
+-	'quite',
+-	'qv',
+-	'quote',
+-	'rather',
+-	'rd',
+-	're',
+-	'really',
+-	'reasonably',
+-	'recent',
+-	'regarding',
+-	'regardless',
+-	'regards',
+-	'relatively',
+-	'respectively',
+-	'right',
+-	'rotf',
+-	'rotflmao',
+-	'said',
+-	'same',
+-	'saw',
+-	'say',
+-	'saying',
+-	'says',
+-	'second',
+-	'secondly',
+-	'see',
+-	'seeing',
+-	'seem',
+-	'seemed',
+-	'seeming',
+-	'seems',
+-	'seen',
+-	'see',
+-	'self',
+-	'selves',
+-	'sensible',
+-	'sent',
+-	'serious',
+-	'seriously',
+-	'seven',
+-	'several',
+-	'shall',
+-	'she',
+-	'should',
+-	'shouldnt',
+-	'since',
+-	'sites',
+-	'six',
+-	'small',
+-	'so',
+-	'some',
+-	'somebody',
+-	'somehow',
+-	'someone',
+-	'something',
+-	'sometime',
+-	'sometimes',
+-	'somewhat',
+-	'somewhere',
+-	'soon',
+-	'sorry',
+-	'specified',
+-	'specify',
+-	'specifying',
+-	'still',
+-	'sub',
+-	'such',
+-	'sup',
+-	'sure',
+-	't',
+-	'take',
+-	'taken',
+-	'tell',
+-	'tends',
+-	'than',
+-	'thank',
+-	'thanks',
+-	'thanx',
+-	'that',
+-	'thatd',
+-	'thats',
+-	'the',
+-	'their',
+-	'theirs',
+-	'them',
+-	'themselves',
+-	'then',
+-	'thence',
+-	'there',
+-	'thereafter',
+-	'thereby',
+-	'therefore',
+-	'therein',
+-	'theres',
+-	'thereupon',
+-	'these',
+-	'they',
+-	'theyd',
+-	'theyll',
+-	'theyre',
+-	'theyve',
+-	'think',
+-	'third',
+-	'this',
+-	'thorough',
+-	'thoroughly',
+-	'those',
+-	'though',
+-	'three',
+-	'through',
+-	'throughout',
+-	'thru',
+-	'thus',
+-	'time',
+-	'times',
+-	'to',
+-	'together',
+-	'too',
+-	'took',
+-	'toward',
+-	'towards',
+-	'tried',
+-	'tries',
+-	'truly',
+-	'try',
+-	'trying',
+-	'twice',
+-	'two',
+-	'un',
+-	'under',
+-	'unfortunately',
+-	'unless',
+-	'unlikely',
+-	'until',
+-	'untrue',
+-	'unto',
+-	'up',
+-	'upon',
+-	'us',
+-	'use',
+-	'used',
+-	'useful',
+-	'users',
+-	'uses',
+-	'using',
+-	'usually',
+-	'value',
+-	'various',
+-	'version',
+-	'very',
+-	'via',
+-	'viz',
+-	'vs',
+-	'want',
+-	'wants',
+-	'was',
+-	'wasnt',
+-	'way',
+-	'we',
+-	'wed',
+-	'well',
+-	'were',
+-	'werent',
+-	'weve',
+-	'welcome',
+-	'went',
+-	'what',
+-	'whats',
+-	'whatever',
+-	'when',
+-	'whence',
+-	'whenever',
+-	'where',
+-	'wheres',
+-	'whereafter',
+-	'whereas',
+-	'whereby',
+-	'wherein',
+-	'whereupon',
+-	'wherever',
+-	'whether',
+-	'which',
+-	'while',
+-	'whither',
+-	'who',
+-	'whos',
+-	'whoever',
+-	'whole',
+-	'whom',
+-	'whose',
+-	'why',
+-	'wide',
+-	'will',
+-	'willing',
+-	'wish',
+-	'with',
+-	'within',
+-	'without',
+-	'wont',
+-	'wonder',
+-	'world',
+-	'worse',
+-	'worst',
+-	'would',
+-	'wouldnt',
+-	'wrote',
+-	'www',
+-	'yes',
+-	'yet',
+-	'ymmv',
+-	'you',
+-	'youd',
+-	'youll',
+-	'your',
+-	'youre',
+-	'yours',
+-	'yourself',
+-	'yourselves',
+-	'zero'
+-);
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/es/acp_similar_topics.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/language/es/acp_similar_topics.php"
+index ce1f32188..0f85f3882 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/es/acp_similar_topics.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/language/es/acp_similar_topics.php"
+@@ -42,7 +42,6 @@ $lang = array_merge($lang, array(
+ 	'PST_EXPLAIN'		=> 'Hilos Parecidos Precisos muestra una lista de temas similares en la parte inferior de la página del tema actual.',
+ 	'PST_LEGEND1'		=> 'Configuración general',
+ 	'PST_ENABLE'		=> 'Habilitar Hilos Parecidos',
+-	'PST_ENABLE_EXPLAIN'=> 'Show similar topics in topic discussion threads.',
+ 	'PST_LEGEND2'		=> 'Cargar configuración',
+ 	'PST_LIMIT'			=> 'Número de Hilos Parecidos que deben mostrarse',
+ 	'PST_LIMIT_EXPLAIN'	=> 'Aquí puedes definir cuántos Hilos (mensajes) Parecidos deben mostrarse. El número por defecto es 5 hilos.',
+@@ -54,10 +53,8 @@ $lang = array_merge($lang, array(
+ 	'PST_DAYS'			=> 'Días',
+ 	'PST_CACHE'			=> 'Longitud de la caché de Hilos Parecidos',
+ 	'PST_CACHE_EXPLAIN'	=> 'La caché de hilos parecidos expirará después del tiempo indicado, en segundos. Ponlo a 0 si quieres deshabilitar la caché de hilos parecidos.',
+-	'PST_DYNAMIC'		=> 'Display dynamic similar topics',
+-	'PST_DYNAMIC_EXPLAIN'=> 'Show similar topics as users type in the topic title field when creating new topics.',
+ 	'PST_SENSE'			=> 'Sensibilidad de búsqueda',
+-	'PST_SENSE_EXPLAIN'	=> 'Establezca la sensibilidad de búsqueda en un valor entre 1 y 10. Use un número menor si no ve ningún tema similar. Ajustes recomendados: %d',
++	'PST_SENSE_EXPLAIN'	=> 'Establezca la sensibilidad de búsqueda en un valor entre 1 y 10. Use un número menor si no ve ningún tema similar. Ajustes recomendados: Para la tabla “phpbb_topics” de la bases de datos usando InnoDB use 1; para MyISAM use 5.',
+ 	'PST_LEGEND3'		=> 'Configuración de foro',
+ 	'PST_NOSHOW_LIST'	=> 'No mostrar en',
+ 	'PST_NOSHOW_TITLE'	=> 'No mostrar hilos parecidos en',
+@@ -66,14 +63,14 @@ $lang = array_merge($lang, array(
+ 	'PST_STANDARD'		=> 'Estándar',
+ 	'PST_ADVANCED'		=> 'Avanzado',
+ 	'PST_ADVANCED_TITLE'=> 'Haz clic para habilitar la configuración avanzada de hilos parecidos para',
+-	'PST_ADVANCED_EXP'	=> 'Aquí puedes seleccionar foros específicos de donde extraer hilos parecidos. Sólo los hilos parecidos que se encuentren en los foros que selecciones aquí se mostrarán en <strong>%s</strong>.<br><br>No selecciones ningún foro si quieres que todos los foros que tengan habilitado la búsqueda en ellos sean mostrados en este foro.<br><br>Seleccione/Deseleccione multiples foros manteniendo pulsada la tecla <code>CTRL</code> y haciendo clic en los foros deseados.',
++	'PST_ADVANCED_EXP'	=> 'Aquí puedes seleccionar foros específicos de donde extraer hilos parecidos. Sólo los hilos parecidos que se encuentren en los foros que selecciones aquí se mostrarán en <strong>%s</strong>.<br /><br />No selecciones ningún foro si quieres que todos los foros que tengan habilitado la búsqueda en ellos sean mostrados en este foro.<br /><br />Seleccione/Deseleccione multiples foros manteniendo pulsada la tecla <code>CTRL</code> y haciendo clic en los foros deseados.',
+ 	'PST_ADVANCED_FORUM'=> 'Configuración avanzada del foro',
+ 	'PST_DESELECT_ALL'	=> 'Deseleccionar todos',
+ 	'PST_LEGEND4'		=> 'Configuración opcional',
+ 	'PST_WORDS'			=> 'Palabras especiales para ignorar',
+ 	'PST_WORDS_EXPLAIN'	=> 'Añadir palabras especiales exclusivas de su foro en el que deben ser ignoradas en hilos parecidos. (Nota: Las palabras comunes en su lengua son ignorados por defecto.) Separe cada palabra con un espacio. Mayúsculas no minúsculas.',
+ 	'PST_SAVED'			=> 'La configuración de Hilos Parecidos ha sido actualizada',
+-	'PST_FORUM_INFO'	=> '“No Mostrar En”: Deshabilitará la visualización de hilos parecidos en el foro seleccionado.<br>“No Buscar En” : Ignorará los foros seleccionados cuando se estén buscando hilos parecidos.',
++	'PST_FORUM_INFO'	=> '“No Mostrar En”: Deshabilitará la visualización de hilos parecidos en el foro seleccionado.<br />“No Buscar En” : Ignorará los foros seleccionados cuando se estén buscando hilos parecidos.',
+ 	'PST_NO_COMPAT'		=> 'Hilos Parecidos no va a funcionar en tu foro. Hilos Parecidos requiere una base de datos MySQL 4 o MySQL 5 o PostgreSQL.',
+ 	'PST_ERR_CONFIG'	=> 'Demasiados foros fueron marcados en la lista de foros. Inténtalo de nuevo con una selección más pequeña.',
+ ));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/fa/acp_similar_topics.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/language/fa/acp_similar_topics.php"
+index 1f11135f2..2e9704801 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/fa/acp_similar_topics.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/language/fa/acp_similar_topics.php"
+@@ -43,7 +43,6 @@ $lang = array_merge($lang, array(
+ 	'PST_EXPLAIN'		=> '"موضوعات مشابه" ابزاریست جهت نمایش ، موضوعات مشابه در قسمت پایین هر موضوع در انجمن ها',
+ 	'PST_LEGEND1'		=> 'تنظیمات کلی',
+ 	'PST_ENABLE'		=> 'نمایش موضوعات مشابه',
+-	'PST_ENABLE_EXPLAIN'=> 'Show similar topics in topic discussion threads.',
+ 	'PST_LEGEND2'		=> 'بارگزاری تنظیمات',
+ 	'PST_LIMIT'			=> 'تعداد موضوعات مشابه جهت نمایش',
+ 	'PST_LIMIT_EXPLAIN'	=> 'در این قسمت شما میتوانید تعیین کنید که چه تعداد موضوع نمایش داده شود. مقدار پیش فرض تعداد 5 است.',
+@@ -55,10 +54,8 @@ $lang = array_merge($lang, array(
+ 	'PST_DAYS'			=> 'روز',
+ 	'PST_CACHE'			=> 'زمان ذخیره سازی کش',
+ 	'PST_CACHE_EXPLAIN'	=> 'کش یا نهان این افزونه بعد از تعیین زمان توسط شما منسوخ خواهد شد ، برای غیر فعال سازی 0 را وارد کنید.',
+-	'PST_DYNAMIC'		=> 'Display dynamic similar topics',
+-	'PST_DYNAMIC_EXPLAIN'=> 'Show similar topics as users type in the topic title field when creating new topics.',
+-	'PST_SENSE'			=> 'حساسیت جستجو',
+-	'PST_SENSE_EXPLAIN'	=> 'حساسیت جستجو را روی مقداری بین 1 تا 10 تنظیم کنید. اگر موضوع مشابهی نمی بینید از عدد کمتری استفاده کنید. تنظیمات پیشنهادی: برای جداول پایگاه داده “phpbb_topics” با استفاده از InnoDB از 1 استفاده کنید. برای MyISAM از 5 استفاده کنید.',
++	'PST_SENSE'			=> 'Search sensitivity',
++	'PST_SENSE_EXPLAIN'	=> 'Set the search sensitivity to a value between 1 and 10. Use a lower number if you are not seeing any similar topics. Recommended settings: For “phpbb_topics” database tables using InnoDB use 1; for MyISAM use 5.',
+ 	'PST_LEGEND3'		=> 'تنظیمات انجمن',
+ 	'PST_NOSHOW_LIST'	=> 'در این بخش نمایش نده',
+ 	'PST_NOSHOW_TITLE'	=> 'موضوعات مشابه را در این انجمن نشان نده',
+@@ -67,14 +64,14 @@ $lang = array_merge($lang, array(
+ 	'PST_STANDARD'		=> 'استاندارد',
+ 	'PST_ADVANCED'		=> 'پیشرفته',
+ 	'PST_ADVANCED_TITLE'=> 'کلیک جهت انجام تنظیمات پیشرفته',
+-	'PST_ADVANCED_EXP'	=> 'در اینجا شما میتوانید انجمن هایی که دوست دارید موضوعات مشابه در آن دیده شوند انتخاب کنید. به یاد داشته باشید که فقط انجمن هایی که شما انتخاب کنید شامل این افزونه خواهد شد.<br>',
++	'PST_ADVANCED_EXP'	=> 'در اینجا شما میتوانید انجمن هایی که دوست دارید موضوعات مشابه در آن دیده شوند انتخاب کنید. به یاد داشته باشید که فقط انجمن هاییی که شما انتخاب میکنید شامل این افزونه خواهد شد.<br />',
+ 	'PST_ADVANCED_FORUM'=> 'تنظیمات پیشرفته انجمن',
+ 	'PST_DESELECT_ALL'	=> 'انتخاب نکردن',
+ 	'PST_LEGEND4'		=> 'تنظیمات',
+ 	'PST_WORDS'			=> 'کلمات سانسور شده',
+-	'PST_WORDS_EXPLAIN'	=> 'کلمات سانسوری که قصد دارید هنگام جستجوی موضوعات مشابه نمایش داده نشوند را وارد کنید. هر کلمه را با space جدا کنید.',
+-	'PST_SAVED'			=> 'تنظیمات موضوعات مشابه بروز رسانی شد',
+-	'PST_FORUM_INFO'	=> 'انتخاب گزنیه"در این بخش نمایش نده" باعث می شود موضوعات مشابه در انجمن انتخابی نمایش داده نشود<br>انتخاب گزینه" جستجوی موضوعات را در این بخش انجام نده" باعث می شود ، جستجو در انجمن انتخابی برای موضوعات مشابه انجام نشود.',
++	'PST_WORDS_EXPLAIN'	=> 'کلمات سانسوی که قصد دارید هنگام جستجوی موضوعات مشابه نمایش داده نشوند را وارد کنید. هر کلمه را با space میتوانید جدا کنید و.',
++	'PST_SAVED'			=> 'تنظیمات موضوعات مشابه به روز رسانی شد',
++	'PST_FORUM_INFO'	=> 'انتخاب گزنیه"در این بخش نمایش نده" باعث می شود موضوعات مشابه در انجمن های انتخابی نمایش داده نشود<br />انتخاب گزینه" جستجوی موضوعات را در این بخش انجام نده" باعث می شود ، جستجو در بخش های انتخابی برای تاپیک های مشابه انجام نشود.',
+ 	'PST_NO_COMPAT'		=> 'افزونه موضوعات مشابه با سیستم انجمن شما سازگار نیست. این سیستم تنها روی دیتابیس های PostgreSQL or MySQL 4 or MySQL 5 کار میکند',
+-	'PST_ERR_CONFIG'	=> 'تعداد انجمن های انتخاب شده بیش از حد می باشد لطفا دوباره با یک انتخاب کوچکتر امتحان کنید.',
++	'PST_ERR_CONFIG'	=> 'بیش از حد بسیاری از انجمن ها در فهرست انجمن ها مشخص شد. لطفا دوباره با یک انتخاب کوچکتر امتحان کنید.',
+ ));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/fa/info_acp_similar_topics.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/language/fa/info_acp_similar_topics.php"
+index 14e3f407b..f5fe9b97c 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/fa/info_acp_similar_topics.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/language/fa/info_acp_similar_topics.php"
+@@ -40,6 +40,6 @@ if (empty($lang) || !is_array($lang))
+ 
+ $lang = array_merge($lang, array(
+ 	'PST_TITLE_ACP'		=> 'موضوعات مشابه',
+-	'PST_SETTINGS'		=> 'تنظیمات',
+-	'PST_LOG_MSG'		=> '<strong>تنظیمات افزونه "موضوعات مشابه" بروز رسانی شد</strong>',
++	'PST_SETTINGS'		=> 'تنظیمات افزونه "موضوعات مشابه"',
++	'PST_LOG_MSG'		=> '<strong>تنظیمات افزونه "موضوعات مشابه" به روز رسانی شد</strong>',
+ ));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/fa/search_ignore_words.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/fa/search_ignore_words.php"
+deleted file mode 100644
+index d8300612d..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/fa/search_ignore_words.php"
++++ /dev/null
+@@ -1,63 +0,0 @@
+-<?php
+-/**
+- *
+- * Precise Similar Topics
+- *
+- * @copyright (c) 2025 Matt Friedman
+- * @license GNU General Public License, version 2 (GPL-2.0)
+- *
+- * This [fa] language list of stop words created by Matt Friedman for Similar Topics
+- *
+- */
+-
+-if (!defined('IN_PHPBB'))
+-{
+-   exit;
+-}
+-
+-$words = array(
+-	'آن',
+-	'آنها',
+-	'اگر',
+-	'از',
+-	'است',
+-	'این',
+-	'اینها',
+-	'با',
+-	'باشد',
+-	'بر',
+-	'برای',
+-	'بعد',
+-	'بود',
+-	'بوده',
+-	'بزرگ',
+-	'تا',
+-	'تمام',
+-	'جدید',
+-	'خوب',
+-	'در',
+-	'روز',
+-	'روزها',
+-	'زمان',
+-	'شد',
+-	'شده',
+-	'شود',
+-	'کار',
+-	'که',
+-	'کرد',
+-	'کرده',
+-	'کند',
+-	'کوچک',
+-	'گفت',
+-	'ما',
+-	'من',
+-	'نیز',
+-	'هم',
+-	'همه',
+-	'هیچ',
+-	'و',
+-	'وقت',
+-	'ولی',
+-	'یا',
+-	'یک',
+-);
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/fr/acp_similar_topics.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/language/fr/acp_similar_topics.php"
+index 4f2b4048e..7da330f61 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/fr/acp_similar_topics.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/language/fr/acp_similar_topics.php"
+@@ -43,7 +43,6 @@ $lang = array_merge($lang, array(
+ 	'PST_EXPLAIN'		=> 'Affiche une liste des sujets similaires au bas de la page du sujet visionné.',
+ 	'PST_LEGEND1'		=> 'Paramètre général',
+ 	'PST_ENABLE'		=> 'Afficher les sujets similaires',
+-	'PST_ENABLE_EXPLAIN'=> 'Show similar topics in topic discussion threads.',
+ 	'PST_LEGEND2'		=> 'Paramètres principaux',
+ 	'PST_LIMIT'			=> 'Nombre du ou des sujets similaires à afficher',
+ 	'PST_LIMIT_EXPLAIN'	=> 'Ici vous pouvez sélectionner le ou les nombres de sujets similaires à afficher. La valeur par défaut est de 5 sujets.',
+@@ -55,10 +54,8 @@ $lang = array_merge($lang, array(
+ 	'PST_DAYS'			=> 'Jour(s)',
+ 	'PST_CACHE'			=> 'Taille du cache des sujets similaires',
+ 	'PST_CACHE_EXPLAIN'	=> 'La mise en cache des sujets similaires expirera après cette période. Paramétrez sur 0 pour désactiver la mise en cache des sujets similaires.',
+-	'PST_DYNAMIC'		=> 'Display dynamic similar topics',
+-	'PST_DYNAMIC_EXPLAIN'=> 'Show similar topics as users type in the topic title field when creating new topics.',
+ 	'PST_SENSE'			=> 'Sensibilité de la recherche',
+-	'PST_SENSE_EXPLAIN'	=> 'Permet de saisir une valeur comprise entre 1 et 10 concernant le degré de sensibilité de la recherche. Utiliser une valeur plus basse si aucun sujet similaire n’est affiché. Paramètres recommandées : %d',
++	'PST_SENSE_EXPLAIN'	=> 'Permet de saisir une valeur comprise entre 1 et 10 concernant le degré de sensibilité de la recherche. Utiliser une valeur plus basse si aucun sujet similaire n’est affiché. Paramètres recommandées : Pour les tables « phpbb_topics » utilisant InnoDB saisir 1 ; pour MyISAM saisir 5.',
+ 	'PST_LEGEND3'		=> 'Paramètres des forums',
+ 	'PST_NOSHOW_LIST'	=> 'Ne pas afficher dans',
+ 	'PST_NOSHOW_TITLE'	=> 'Ne pas afficher les sujets similaires dans le forum :',
+@@ -67,14 +64,14 @@ $lang = array_merge($lang, array(
+ 	'PST_STANDARD'		=> 'Standard',
+ 	'PST_ADVANCED'		=> 'Avancé',
+ 	'PST_ADVANCED_TITLE'=> 'Cliquez ici pour configurer les paramètres avancés du forum :',
+-	'PST_ADVANCED_EXP'	=> 'Ici vous pouvez sélectionner des forums spécifiques dont les sujets similaires proviendront. Seuls les sujets similaires trouvés dans les forums sélectionnés ici seront affichés dans le forum : <strong>%s</strong>.<br><br>Ne sélectionnez aucun forum si vous souhaitez que tous les sujets similaires de tous les forums soient consultables dans ce forum.<br><br>Vous pouvez sélectionner ou désélectionner plusieurs forums en maintenant appuyée la touche <samp>CTRL</samp> (ou <samp>&#8984;CMD</samp> sur Mac) du clavier de votre ordinateur et en cliquant.',
++	'PST_ADVANCED_EXP'	=> 'Ici vous pouvez sélectionner des forums spécifiques dont les sujets similaires proviendront. Seuls les sujets similaires trouvés dans les forums sélectionnés ici seront affichés dans le forum : <strong>%s</strong>.<br /><br />Ne sélectionnez aucun forum si vous souhaitez que tous les sujets similaires de tous les forums soient consultables dans ce forum.<br /><br />Vous pouvez sélectionner ou désélectionner plusieurs forums en maintenant appuyée la touche <samp>CTRL</samp> (ou <samp>&#8984;CMD</samp> sur Mac) du clavier de votre ordinateur et en cliquant.',
+ 	'PST_ADVANCED_FORUM'=> 'Paramètres avancés du forum',
+ 	'PST_DESELECT_ALL'	=> 'Tout désélectionner',
+ 	'PST_LEGEND4'		=> 'Paramètres optionnels',
+ 	'PST_WORDS'			=> 'Mots spécifiques à ignorer',
+ 	'PST_WORDS_EXPLAIN'	=> 'Ajoutez des mots spécifiques à votre forum qui doivent être ignorés lors de la recherche des sujets similaires. (Remarque : Les mots qui sont actuellement considérés comme communs dans votre langue sont déjà ignorés par défaut.) Séparez chaque mot par un espace. Insensible à la casse.',
+ 	'PST_SAVED'			=> 'Les paramètres des sujets similaires ont été mis à jour',
+-	'PST_FORUM_INFO'	=> '« Ne pas afficher dans » : N’affiche pas de sujets similaires dans les forums sélectionnés.<br> « Ne pas rechercher dans » : Ne recherche pas de sujets similaires dans les forums sélectionnés.<br><br>',
++	'PST_FORUM_INFO'	=> '« Ne pas afficher dans » : N’affiche pas de sujets similaires dans les forums sélectionnés.<br /> « Ne pas rechercher dans » : Ne recherche pas de sujets similaires dans les forums sélectionnés.<br /><br />',
+ 	'PST_NO_COMPAT'		=> 'L’extension « Sujets similaires précis » n’est pas compatible avec votre forum. Cette extension fonctionne uniquement avec une base de données MySQL 4 ou 5 ou PostgreSQL.',
+ 	'PST_ERR_CONFIG'	=> 'De trop nombreux forums ont été sélectionnés dans la liste des forums. Veuillez réessayer avec une sélection plus restreinte.',
+ ));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/he/acp_similar_topics.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/language/he/acp_similar_topics.php"
+index bdce3ef66..0599ac9d3 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/he/acp_similar_topics.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/language/he/acp_similar_topics.php"
+@@ -42,7 +42,6 @@ $lang = array_merge($lang, array(
+ 	'PST_EXPLAIN'		=> 'נושאים דומים במדויק מציג רשימת נושאים דומים (קשורים) בחלק התחתון של דף הנושא הנוכחי.',
+ 	'PST_LEGEND1'		=> 'הגדרות כלליות',
+ 	'PST_ENABLE'		=> 'הצג נושאים דומים',
+-	'PST_ENABLE_EXPLAIN'=> 'Show similar topics in topic discussion threads.',
+ 	'PST_LEGEND2'		=> 'טען הגדרות',
+ 	'PST_LIMIT'			=> 'מספר נושאים דומים להצגה',
+ 	'PST_LIMIT_EXPLAIN'	=> 'כאן באפשרותך להגדיר כמה נושאים דומים להציג. ברירת המחדל היא 5 נושאים.',
+@@ -54,10 +53,8 @@ $lang = array_merge($lang, array(
+ 	'PST_DAYS'			=> 'ימים',
+ 	'PST_CACHE'			=> 'אורך מטמון נושאים דומים',
+ 	'PST_CACHE_EXPLAIN'	=> 'מטמון נושאים דומים יפוג לאחר זמן, ערך בשניות. קבע 0 אם אתה רוצה לבטל את מטמון נושאים דומים.',
+-	'PST_DYNAMIC'		=> 'Display dynamic similar topics',
+-	'PST_DYNAMIC_EXPLAIN'=> 'Show similar topics as users type in the topic title field when creating new topics.',
+ 	'PST_SENSE'			=> 'רגישות חיפוש',
+-	'PST_SENSE_EXPLAIN'	=> 'הגדר את רגישות החיפוש לערך בין 1 ל -10. השתמש במספר נמוך יותר אם אינך רואה נושאים דומים. הגדרות מומלצות: <samp>%d</samp>',
++	'PST_SENSE_EXPLAIN'	=> 'הגדר את רגישות החיפוש לערך בין 1 ל -10. השתמש במספר נמוך יותר אם אינך רואה נושאים דומים. הגדרות מומלצות: עבור טבלאות מסד נתונים “phpbb_topics” הפועלים ב- InnoDB השתמש ב- 1; עבור  MyISAM השתמש ב- 5.',
+ 	'PST_LEGEND3'		=> 'הגדרות פורום',
+ 	'PST_NOSHOW_LIST'	=> 'לא להציג ב',
+ 	'PST_NOSHOW_TITLE'	=> 'לא להציג נושאים דומים ב',
+@@ -66,14 +63,14 @@ $lang = array_merge($lang, array(
+ 	'PST_STANDARD'		=> 'תקן',
+ 	'PST_ADVANCED'		=> 'מתקדם',
+ 	'PST_ADVANCED_TITLE'=> 'לחץ כדי להגדיר הגדרות מתקדמות לנושא דומה עבור',
+-	'PST_ADVANCED_EXP'	=> 'כאן ניתן לבחור פורומים ספציפיים כדי למשוך נושאים דומים מ. רק נושאים דומים שנמצאו בפורומים שתבחר כאן יוצגו ב- <strong>%s</strong>. אל תבחר בכל הפורומים, אם אתה רוצה שנושאים דומים מחיפוש בכל הפורומים יוצג בפורום זה.<br><br>בחר במספר פורומים על ידי החזקת מקש <samp>CTRL</samp> (או <samp>&#8984;CMD</samp> ב- MAC) ולחיצה.',
++	'PST_ADVANCED_EXP'	=> 'כאן ניתן לבחור פורומים ספציפיים כדי למשוך נושאים דומים מ. רק נושאים דומים שנמצאו בפורומים שתבחר כאן יוצגו ב- <strong>%s</strong>. אל תבחר בכל הפורומים, אם אתה רוצה שנושאים דומים מחיפוש בכל הפורומים יוצג בפורום זה.<br /><br />בחר במספר פורומים על ידי החזקת מקש <samp>CTRL</samp> (או <samp>&#8984;CMD</samp> ב- MAC) ולחיצה.',
+ 	'PST_ADVANCED_FORUM'=> 'הגדרות פורום מתקדמות',
+ 	'PST_DESELECT_ALL'	=> 'הסר סימון מהכל',
+ 	'PST_LEGEND4'		=> 'הגדרות אופציונליות',
+ 	'PST_WORDS'			=> 'להתעלם ממילים מיוחדות',
+ 	'PST_WORDS_EXPLAIN'	=> 'הוסף מילים מיוחדות וייחודיות בפורום שלך שיש להתעלם מהן בעת מציאת נושאים דומים. (הערה: כברירת מחדל, הוא כבר מתעלם ממילים שנחשבות נפוצות בשפה שלך.) הפרד כל מילה עם רווח. לא תלוי רישיות.',
+ 	'PST_SAVED'			=> 'הגדרות נושאים דומים עודכנו',
+-	'PST_FORUM_INFO'	=> '"לא להציג ב": לא יוצגו נושאים דומים בפורומים שנבחרו.<br>"לא לחפש בתוך": לא יחפש נושאים דומים בפורומים שנבחרו.',
++	'PST_FORUM_INFO'	=> '"לא להציג ב": לא יוצגו נושאים דומים בפורומים שנבחרו.<br />"לא לחפש בתוך": לא יחפש נושאים דומים בפורומים שנבחרו.',
+ 	'PST_NO_COMPAT'		=> 'נושאים דומים אינו תואם את הפורום שלך. נושאים דומים יפעל רק על מסד נתונים MySQL או PostgreSQL.',
+ 	'PST_ERR_CONFIG'	=> 'יותר מדי פורומים סומנו ברשימת הפורומים. נסה שוב עם בחירה קטנה יותר.',
+ ));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/he/search_ignore_words.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/he/search_ignore_words.php"
+deleted file mode 100644
+index 77cee721e..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/he/search_ignore_words.php"
++++ /dev/null
+@@ -1,73 +0,0 @@
+-<?php
+-/**
+- *
+- * Precise Similar Topics
+- *
+- * @copyright (c) 2025 Matt Friedman
+- * @license GNU General Public License, version 2 (GPL-2.0)
+- *
+- * This [he] language list of stop words created by Matt Friedman for Similar Topics
+- *
+- */
+-
+-if (!defined('IN_PHPBB'))
+-{
+-   exit;
+-}
+-
+-$words = array(
+-	'אבל',
+-	'אחד',
+-	'אחר',
+-	'אחרי',
+-	'איך',
+-	'אין',
+-	'אל',
+-	'אם',
+-	'אני',
+-	'אף',
+-	'את',
+-	'אתה',
+-	'אתם',
+-	'בין',
+-	'גדול',
+-	'גם',
+-	'דבר',
+-	'היא',
+-	'היה',
+-	'הם',
+-	'הן',
+-	'הוא',
+-	'זה',
+-	'זו',
+-	'חדש',
+-	'טוב',
+-	'יום',
+-	'ימים',
+-	'יש',
+-	'כאן',
+-	'כבר',
+-	'כי',
+-	'כל',
+-	'כמו',
+-	'כן',
+-	'לא',
+-	'לו',
+-	'לי',
+-	'למה',
+-	'מה',
+-	'מי',
+-	'מן',
+-	'נגד',
+-	'עד',
+-	'על',
+-	'עם',
+-	'פה',
+-	'קטן',
+-	'רב',
+-	'רק',
+-	'שוב',
+-	'של',
+-	'שם',
+-	'תמיד',
+-);
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/hr/acp_similar_topics.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/language/hr/acp_similar_topics.php"
+index e80cc6ee6..0d83bd292 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/hr/acp_similar_topics.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/language/hr/acp_similar_topics.php"
+@@ -43,22 +43,19 @@ $lang = array_merge($lang, array(
+ 	'PST_EXPLAIN'		=> 'Ovdje možeš o[ne]mogućiti prikaz liste sličnih [povezanih] tema na dnu stranice trenutne teme.',
+ 	'PST_LEGEND1'		=> 'Opće postavke',
+ 	'PST_ENABLE'		=> 'Prikaži Slične teme',
+-	'PST_ENABLE_EXPLAIN'=> 'Show similar topics in topic discussion threads.',
+ 	'PST_LEGEND2'		=> 'Osnovne postavke',
+ 	'PST_LIMIT'			=> 'Broj sličnih tema za prikaz',
+ 	'PST_LIMIT_EXPLAIN'	=> 'Određivanje prikaza broja sličnih tema [zadano=5].',
+ 	'PST_TIME'			=> 'Razdoblje pretraživanja',
+-	'PST_TIME_EXPLAIN'	=> 'Određivanje razdoblje pretraživanja broja sličnih tema [zadano=godina].<br>Npr. ukoliko je vrijednost postavljena na 5, sistem će prikaz(iv)ati slične teme unazad 5 dana.',
++	'PST_TIME_EXPLAIN'	=> 'Određivanje razdoblje pretraživanja broja sličnih tema [zadano=godina].<br />Npr. ukoliko je vrijednost postavljena na 5, sistem će prikaz(iv)ati slične teme unazad 5 dana.',
+ 	'PST_YEARS'			=> 'Godina/e',
+ 	'PST_MONTHS'		=> 'Mjesec/a/i',
+ 	'PST_WEEKS'			=> 'Tjedan/na/a',
+ 	'PST_DAYS'			=> 'Dan/a',
+ 	'PST_CACHE'			=> 'Trajanje sličnih tema pohranjenih u priručnu memoriju',
+ 	'PST_CACHE_EXPLAIN'	=> 'Slične teme, pohranjene u priručnu memoriju, bit će izbrisane, iz priručne memorije, po isteku [u sekundama] postavljenog vremena [0=onemogućeno].',
+-	'PST_DYNAMIC'		=> 'Display dynamic similar topics',
+-	'PST_DYNAMIC_EXPLAIN'=> 'Show similar topics as users type in the topic title field when creating new topics.',
+ 	'PST_SENSE'			=> 'Search sensitivity',
+-	'PST_SENSE_EXPLAIN'	=> 'For MySQL or Postgres databases, you can set the search sensitivity to a value between 1 and 10. Use a lower number if you are not seeing any similar topics. Recommended setting: %d',
++	'PST_SENSE_EXPLAIN'	=> 'Set the search sensitivity to a value between 1 and 10. Use a lower number if you are not seeing any similar topics. Recommended settings: For “phpbb_topics” database tables using InnoDB use 1; for MyISAM use 5.',
+ 	'PST_LEGEND3'		=> 'Postavke foruma',
+ 	'PST_NOSHOW_LIST'	=> 'Ne prikazuj u',
+ 	'PST_NOSHOW_TITLE'	=> 'Ne prikazuj slične teme u',
+@@ -67,14 +64,14 @@ $lang = array_merge($lang, array(
+ 	'PST_STANDARD'		=> 'Standardno',
+ 	'PST_ADVANCED'		=> 'Napredno',
+ 	'PST_ADVANCED_TITLE'=> 'Klikni za podešavanje naprednih postavki sličnih tema u/za',
+-	'PST_ADVANCED_EXP'	=> 'Ukoliko želiš da slične teme, iz određenih pretražljivih foruma, budu prikazane na <strong>%s</strong>, označi [odaberi] željene forume.<br><br>Ukoliko želiš da slične teme, iz svih pretražljivih foruma, budu prikazane na forumu, nemoj označiti [odabrati] niti jedan forum.<br><br>Forume možeš (od)označavati korištenjem [pritisnute tipke] <code>CTRL</code> i kliktanjem [mišem].',
++	'PST_ADVANCED_EXP'	=> 'Ukoliko želiš da slične teme, iz određenih pretražljivih foruma, budu prikazane na <strong>%s</strong>, označi [odaberi] željene forume.<br /><br />Ukoliko želiš da slične teme, iz svih pretražljivih foruma, budu prikazane na forumu, nemoj označiti [odabrati] niti jedan forum.<br /><br />Forume možeš (od)označavati korištenjem [pritisnute tipke] <code>CTRL</code> i kliktanjem [mišem].',
+ 	'PST_ADVANCED_FORUM'=> 'Napredne postavke foruma',
+ 	'PST_DESELECT_ALL'	=> 'Odoznači sve',
+ 	'PST_LEGEND4'		=> 'Opcionalne postavke',
+ 	'PST_WORDS'			=> 'Ignorirane riječi',
+-	'PST_WORDS_EXPLAIN'	=> 'Popis riječi koje će biti ignorirane prilikom pronalaženja sličnih tema [zadano su ignorirane riječi koje su navedene ako učestale].<br>Riječi odvoji razmacima. Neosjetljivo na velika/mala slova.',
++	'PST_WORDS_EXPLAIN'	=> 'Popis riječi koje će biti ignorirane prilikom pronalaženja sličnih tema [zadano su ignorirane riječi koje su navedene ako učestale].<br />Riječi odvoji razmacima. Neosjetljivo na velika/mala slova.',
+ 	'PST_SAVED'			=> 'Postavke sličnih tema su ažurirane.',
+-	'PST_FORUM_INFO'	=> '“Ne prikazuj u”: neće prikaz(iv)ati slične teme u odabranim forumima.<br>“Ne pretražuj u”: neće pretraž(iv)ati slične teme u odabranim forumima.',
+-	'PST_NO_COMPAT'		=> 'Slične teme nisu kompatibilne s forumom.<br>Pokreću se samo na/u MySQL 4 ili MySQL 5 ili PostgreSQL bazi podataka.',
++	'PST_FORUM_INFO'	=> '“Ne prikazuj u”: neće prikaz(iv)ati slične teme u odabranim forumima.<br />“Ne pretražuj u”: neće pretraž(iv)ati slične teme u odabranim forumima.',
++	'PST_NO_COMPAT'		=> 'Slične teme nisu kompatibilne s forumom.<br />Pokreću se samo na/u MySQL 4 ili MySQL 5 ili PostgreSQL bazi podataka.',
+ 	'PST_ERR_CONFIG'	=> 'Previše forumi su označeni na popisu foruma. Pokušajte ponovno s manjim izborom.',
+ ));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/it/acp_similar_topics.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/language/it/acp_similar_topics.php"
+index 280a11feb..7a12e83b1 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/it/acp_similar_topics.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/language/it/acp_similar_topics.php"
+@@ -42,7 +42,6 @@ $lang = array_merge($lang, array(
+ 	'PST_EXPLAIN'		=> '“Argomenti simili” mostra un elenco di argomenti simili in fondo alla pagina dell’argomento corrente.',
+ 	'PST_LEGEND1'		=> 'Impostazioni generali',
+ 	'PST_ENABLE'		=> 'Mostra argomenti simili',
+-	'PST_ENABLE_EXPLAIN'=> 'Show similar topics in topic discussion threads.',
+ 	'PST_LEGEND2'		=> 'Impostazioni caricamento',
+ 	'PST_LIMIT'			=> 'Numero argomenti simili da mostrare',
+ 	'PST_LIMIT_EXPLAIN'	=> 'È possibile definire quanti topic simili mostrare; il valore predefinito è 5.',
+@@ -54,10 +53,8 @@ $lang = array_merge($lang, array(
+ 	'PST_DAYS'			=> 'Giorni',
+ 	'PST_CACHE'			=> 'Lunghezza cache',
+ 	'PST_CACHE_EXPLAIN'	=> 'Gli argomenti salvati nella cache saranno rimossi dopo il periodo di tempo (in secondi) specificato. Impostare a 0 per disabilitare la cache di argomenti simili.',
+-	'PST_DYNAMIC'		=> 'Display dynamic similar topics',
+-	'PST_DYNAMIC_EXPLAIN'=> 'Show similar topics as users type in the topic title field when creating new topics.',
+ 	'PST_SENSE'			=> 'Search sensitivity',
+-	'PST_SENSE_EXPLAIN'	=> 'For MySQL or Postgres databases, you can set the search sensitivity to a value between 1 and 10. Use a lower number if you are not seeing any similar topics. Recommended setting: %d',
++	'PST_SENSE_EXPLAIN'	=> 'Set the search sensitivity to a value between 1 and 10. Use a lower number if you are not seeing any similar topics. Recommended settings: For “phpbb_topics” database tables using InnoDB use 1; for MyISAM use 5.',
+ 	'PST_LEGEND3'		=> 'Impostazioni forum',
+ 	'PST_NOSHOW_LIST'	=> 'Non mostrare in',
+ 	'PST_NOSHOW_TITLE'	=> 'Non mostrare argomenti simili in',
+@@ -66,14 +63,14 @@ $lang = array_merge($lang, array(
+ 	'PST_STANDARD'		=> 'Base',
+ 	'PST_ADVANCED'		=> 'Avanzate',
+ 	'PST_ADVANCED_TITLE'=> 'Cliccare per configurare le impostazioni avanzate per',
+-	'PST_ADVANCED_EXP'	=> 'È possibile selezionare i forum in cui cercare argomenti simili. Solo gli argomenti trovati nei forum selezionati saranno mostrati in <strong>%s</strong>.<br><br>Per la ricerca in tutti i forum disponibili, non selezionare alcun forum.<br><br>Per la selezione di più forum, tenere premuto <samp>CTRL</samp> (o <samp>&#8984;CMD</samp> su Mac) e cliccare.',
++	'PST_ADVANCED_EXP'	=> 'È possibile selezionare i forum in cui cercare argomenti simili. Solo gli argomenti trovati nei forum selezionati saranno mostrati in <strong>%s</strong>.<br /><br />Per la ricerca in tutti i forum disponibili, non selezionare alcun forum.<br /><br />Per la selezione di più forum, tenere premuto <samp>CTRL</samp> (o <samp>&#8984;CMD</samp> su Mac) e cliccare.',
+ 	'PST_ADVANCED_FORUM'=> 'Impostazioni avanzate forum',
+ 	'PST_DESELECT_ALL'	=> 'Deseleziona tutti',
+ 	'PST_LEGEND4'		=> 'Impostazioni opzionali',
+ 	'PST_WORDS'			=> 'Termini speciali da ignorare',
+-	'PST_WORDS_EXPLAIN'	=> 'È possibile escludere alcuni termini dalla ricerca di argomenti simili. I termini devono essere separati da uno spazio; non è fatta distinzione tra maiuscole e minuscole.<br><br>Nota: <em>i termini considerati comuni della propria lingua sono ignorati per impostazione predefinita.</em>',
++	'PST_WORDS_EXPLAIN'	=> 'È possibile escludere alcuni termini dalla ricerca di argomenti simili. I termini devono essere separati da uno spazio; non è fatta distinzione tra maiuscole e minuscole.<br /><br />Nota: <em>i termini considerati comuni della propria lingua sono ignorati per impostazione predefinita.</em>',
+ 	'PST_SAVED'			=> 'Impostazioni Argomenti simili aggiornate',
+-	'PST_FORUM_INFO'	=> '“Non mostrare in”: nei forum selezionati, non saranno mostrati gli argomenti simili.<br>“Non cercare in”: nei forum selezionati, non saranno cercati gli argomenti simili.',
++	'PST_FORUM_INFO'	=> '“Non mostrare in”: nei forum selezionati, non saranno mostrati gli argomenti simili.<br />“Non cercare in”: nei forum selezionati, non saranno cercati gli argomenti simili.',
+ 	'PST_NO_COMPAT'		=> '“Argomenti simili” non è compatibile con la propria board: quest’estensione richiede un database MySQL versione 4 o 5 o PostgreSQL.',
+ 	'PST_ERR_CONFIG'	=> 'Troppi forum selezionati in elenco, ridurre la selezione.',
+ ));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/ja/acp_similar_topics.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/language/ja/acp_similar_topics.php"
+index 3cb2c6361..00baf0192 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/ja/acp_similar_topics.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/language/ja/acp_similar_topics.php"
+@@ -42,7 +42,6 @@ $lang = array_merge($lang, array(
+ 	'PST_EXPLAIN'		=> 'Precise Similar Topics（正確な類似トピック）は現在のトピックのページ下部に類似(関連)したトピックの一覧を表示します。',
+ 	'PST_LEGEND1'		=> '一般設定',
+ 	'PST_ENABLE'		=> '類似トピックの表示',
+-	'PST_ENABLE_EXPLAIN'=> 'Show similar topics in topic discussion threads.',
+ 	'PST_LEGEND2'		=> '読み込み設定',
+ 	'PST_LIMIT'			=> '表示する類似トピック数',
+ 	'PST_LIMIT_EXPLAIN'	=> '類似トピックの表示数を定義できます。デフォルトは5トピックです。',
+@@ -54,10 +53,8 @@ $lang = array_merge($lang, array(
+ 	'PST_DAYS'			=> '日間',
+ 	'PST_CACHE'			=> '類似トピックのキャッシュの長さ',
+ 	'PST_CACHE_EXPLAIN'	=> 'キャッシュされた類似トピックはこの時間の後に期限がきれます。類似トピックのキャッシュを無効にしたい場合、0を設定します。',
+-	'PST_DYNAMIC'		=> 'Display dynamic similar topics',
+-	'PST_DYNAMIC_EXPLAIN'=> 'Show similar topics as users type in the topic title field when creating new topics.',
+ 	'PST_SENSE'			=> '検索感度',
+-	'PST_SENSE_EXPLAIN'	=> '検索感度を 1 から 10 の間で設定します。類似トピックが一つも表示されない場合は低い値を使用してください。推奨設定: %d',
++	'PST_SENSE_EXPLAIN'	=> '検索感度を 1 から 10 の間で設定します。類似トピックが一つも表示されない場合は低い値を使用してください。推奨設定: “phpbb_topics” DBテーブルが InnoDB を使用していれば 1 を、MyISAMを使用していれば 5 を設定してください。',
+ 	'PST_LEGEND3'		=> 'フォーラム設定',
+ 	'PST_NOSHOW_LIST'	=> '表示しない',
+ 	'PST_NOSHOW_TITLE'	=> '類似トピックを表示しません',
+@@ -66,14 +63,14 @@ $lang = array_merge($lang, array(
+ 	'PST_STANDARD'		=> '標準',
+ 	'PST_ADVANCED'		=> 'カスタム',
+ 	'PST_ADVANCED_TITLE'=> '次の類似トピックのカスタム設定をするにはクリック:',
+-	'PST_ADVANCED_EXP'	=> 'ここでは類似トピックを取ってくる特定のフォーラムを選択できます。ここで選択したフォーラムで見つかった類似トピックのみ<strong>%s</strong>に表示されます。<br><br>全ての検索可能なフォーラムから類似トピックをこのフォーラムに表示したい場合、どのフォーラムも選択しないでください。<br><br><samp>CTRL</samp> (または MACでは<samp>&#8984;CMD</samp>)を押しながらクリックすることで複数のフォーラムを選択します。',
++	'PST_ADVANCED_EXP'	=> 'ここでは類似トピックを取ってくる特定のフォーラムを選択できます。ここで選択したフォーラムで見つかった類似トピックのみ<strong>%s</strong>に表示されます。<br /><br />全ての検索可能なフォーラムから類似トピックをこのフォーラムに表示したい場合、どのフォーラムも選択しないでください。<br /><br /><samp>CTRL</samp> (または MACでは<samp>&#8984;CMD</samp>)を押しながらクリックすることで複数のフォーラムを選択します。',
+ 	'PST_ADVANCED_FORUM'=> 'カスタムフォーラム設定',
+ 	'PST_DESELECT_ALL'	=> '全ての選択を解除',
+ 	'PST_LEGEND4'		=> 'オプション設定',
+ 	'PST_WORDS'			=> '無視する単語',
+ 	'PST_WORDS_EXPLAIN'	=> '類似トピックを検索する際に無視すべき固有の単語を追加します（注: 現在の言語で共通とみなされている単語は、すでにデフォルトでは無視されます) 。スペースで各単語を区切ります。大文字小文字は区別しません。',
+ 	'PST_SAVED'			=> '類似トピック設定を更新しました',
+-	'PST_FORUM_INFO'	=> '“表示しない”: 選択したフォーラムで類似トピックを表示しません。<br>“検索しない” : 選択したフォーラムで類似トピックを検索しません。',
++	'PST_FORUM_INFO'	=> '“表示しない”: 選択したフォーラムで類似トピックを表示しません。<br />“検索しない” : 選択したフォーラムで類似トピックを検索しません。',
+ 	'PST_NO_COMPAT'		=> '類似トピックはあなたのフォーラムと互換性がありません。類似トピックはMySQL4/5/PostgreSQLのデータベースでのみ実行できます。',
+ 	'PST_ERR_CONFIG'	=> 'あまりにも多くのフォーラムが、フォーラムのリストにマークされています。少ない選択数で再度お試しください。',
+ ));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/ja/search_ignore_words.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/ja/search_ignore_words.php"
+deleted file mode 100644
+index 26caeee97..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/ja/search_ignore_words.php"
++++ /dev/null
+@@ -1,49 +0,0 @@
+-<?php
+-/**
+- *
+- * Precise Similar Topics
+- *
+- * @copyright (c) 2025 Matt Friedman
+- * @license GNU General Public License, version 2 (GPL-2.0)
+- *
+- * This [ja] language list of stop words created by Matt Friedman for Similar Topics
+- *
+- */
+-
+-if (!defined('IN_PHPBB'))
+-{
+-   exit;
+-}
+-
+-$words = array(
+-	'あの',
+-	'ある',
+-	'いる',
+-	'から',
+-	'この',
+-	'その',
+-	'それ',
+-	'だけ',
+-	'です',
+-	'では',
+-	'でも',
+-	'という',
+-	'として',
+-	'なる',
+-	'には',
+-	'また',
+-	'まで',
+-	'もう',
+-	'もの',
+-	'より',
+-	'れる',
+-	'われ',
+-	'を',
+-	'が',
+-	'で',
+-	'と',
+-	'に',
+-	'は',
+-	'も',
+-	'や',
+-);
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/nl/acp_similar_topics.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/language/nl/acp_similar_topics.php"
+index 6591b84d2..7fc7ecdea 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/nl/acp_similar_topics.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/language/nl/acp_similar_topics.php"
+@@ -42,7 +42,6 @@ $lang = array_merge($lang, array(
+ 	'PST_EXPLAIN'		=> 'Precise Similar Topics toont een lijst van soortgelijke onderwerpen aan de onderkant van de pagina van het huidige onderwerpen.',
+ 	'PST_LEGEND1'		=> 'Algemene instellingen',
+ 	'PST_ENABLE'		=> 'Vergelijkbare onderwerpen inschakelen',
+-	'PST_ENABLE_EXPLAIN'=> 'Show similar topics in topic discussion threads.',
+ 	'PST_LEGEND2'		=> 'Laad instellingen',
+ 	'PST_LIMIT'			=> 'Aantal vergelijkbare onderwerpen weer te geven',
+ 	'PST_LIMIT_EXPLAIN'	=> 'Hier kunt u opgeven hoeveel soortgelijke onderwerpen weer te laten geven. Standaard is dit 5 onderwerpen.',
+@@ -54,10 +53,8 @@ $lang = array_merge($lang, array(
+ 	'PST_DAYS'			=> 'Dagen',
+ 	'PST_CACHE'			=> 'Cache lengte vergelijkbare onderwerpen',
+ 	'PST_CACHE_EXPLAIN'	=> 'Cache vergelijkbare onderwerpen verloopt na deze tijd in seconden. Stel in op 0 als u dit wilt uitschakelen.',
+-	'PST_DYNAMIC'		=> 'Display dynamic similar topics',
+-	'PST_DYNAMIC_EXPLAIN'=> 'Show similar topics as users type in the topic title field when creating new topics.',
+ 	'PST_SENSE'			=> 'Search sensitivity',
+-	'PST_SENSE_EXPLAIN'	=> 'For MySQL or Postgres databases, you can set the search sensitivity to a value between 1 and 10. Use a lower number if you are not seeing any similar topics. Recommended setting: %d',
++	'PST_SENSE_EXPLAIN'	=> 'Set the search sensitivity to a value between 1 and 10. Use a lower number if you are not seeing any similar topics. Recommended settings: For “phpbb_topics” database tables using InnoDB use 1; for MyISAM use 5.',
+ 	'PST_LEGEND3'		=> 'Forum instellingen',
+ 	'PST_NOSHOW_LIST'	=> 'Niet weergeven in',
+ 	'PST_NOSHOW_TITLE'	=> 'Vergelijkbare Onderwerpen Niet weergeven in',
+@@ -66,14 +63,14 @@ $lang = array_merge($lang, array(
+ 	'PST_STANDARD'		=> 'Standaard',
+ 	'PST_ADVANCED'		=> 'Geavanceerd',
+ 	'PST_ADVANCED_TITLE'=> 'Klik om Geavanceerde vergelijkbare onderwerpen in te stellen voor',
+-	'PST_ADVANCED_EXP'	=> 'Hier kunt u specifieke forums selecteren om de soortgelijke onderwerpen uit te halen. Alleen vergelijkbare onderwerpen gevonden in de forums die u hier selecteert worden weergegeven in <strong>%s</strong>.<br><br>Selecteer helemaal geen forum als u wilt dat vergelijkbare onderwerpen uit alle doorzoekbare forums worden weergegeven in dit forum.<br><br>Selecteer/Deselecteer meerdere forums door <code>CTRL</code> ingedrukt te houden en forums aan te klikken.',
++	'PST_ADVANCED_EXP'	=> 'Hier kunt u specifieke forums selecteren om de soortgelijke onderwerpen uit te halen. Alleen vergelijkbare onderwerpen gevonden in de forums die u hier selecteert worden weergegeven in <strong>%s</strong>.<br /><br />Selecteer helemaal geen forum als u wilt dat vergelijkbare onderwerpen uit alle doorzoekbare forums worden weergegeven in dit forum.<br /><br />Selecteer/Deselecteer meerdere forums door <code>CTRL</code> ingedrukt te houden en forums aan te klikken.',
+ 	'PST_ADVANCED_FORUM'=> 'Geavanceerd forum instellingen',
+ 	'PST_DESELECT_ALL'	=> 'Selectie opheffen',
+ 	'PST_LEGEND4'		=> 'Optionele instellingen',
+ 	'PST_WORDS'			=> 'Speciale woorden om te negeren',
+ 	'PST_WORDS_EXPLAIN'	=> 'Voeg speciale woorden toe die uniek zijn aan uw forum en moeten genegeerd worden bij het vinden van vergelijkbare onderwerpen. (Opgelet: woorden die momenteel als veelvoorkomend worden beschouwd in uw taal, worden reeds standaard genegeerd.) Scheid elk woord met een spatie. Niet hoofdlettergevoelig.',
+ 	'PST_SAVED'			=> 'Vergelijkbare onderwerpen instellingen bijgewerkt',
+-	'PST_FORUM_INFO'	=> '“Niet weergeven in”: Soortgelijke onderwerpen worden niet weergegeven in de geselecteerde forums.<br>“Niet zoeken in” : Zal niet zoeken in de geselecteerde forums voor vergelijkbare onderwerpen.',
++	'PST_FORUM_INFO'	=> '“Niet weergeven in”: Soortgelijke onderwerpen worden niet weergegeven in de geselecteerde forums.<br />“Niet zoeken in” : Zal niet zoeken in de geselecteerde forums voor vergelijkbare onderwerpen.',
+ 	'PST_NO_COMPAT'		=> 'Vergelijkbare onderwerpen zal niet werken op uw forum. Vergelijkbare onderwerpen vereist een PostgreSQL, MySQL 4 of 5 MySQL database.',
+ 	'PST_ERR_CONFIG'	=> 'Te veel fora werden gemarkeerd in de lijst van forums. Probeer het opnieuw met een kleinere selectie.',
+ ));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/pl/acp_similar_topics.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/language/pl/acp_similar_topics.php"
+index 83fd756d5..b28cc3018 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/pl/acp_similar_topics.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/language/pl/acp_similar_topics.php"
+@@ -43,7 +43,6 @@ $lang = array_merge($lang, array(
+ 	'PST_EXPLAIN'		=> 'Rozszerzenie Precise Similar Topics wyświetla listę podobnych tematów na dole strony bieżącego tematu.',
+ 	'PST_LEGEND1'		=> 'Ustawienia ogólne',
+ 	'PST_ENABLE'		=> 'Włącz podobne tematy',
+-	'PST_ENABLE_EXPLAIN'=> 'Show similar topics in topic discussion threads.',
+ 	'PST_LEGEND2'		=> 'Załaduj ustawienia',
+ 	'PST_LIMIT'			=> 'Liczba wyświetlanych tematów',
+ 	'PST_LIMIT_EXPLAIN'	=> 'Tutaj możesz określić, ile podobnych tematów zostanie wyświetlonych. Domyślnie jest to 5 tematów.',
+@@ -55,10 +54,8 @@ $lang = array_merge($lang, array(
+ 	'PST_DAYS'			=> 'Dzień',
+ 	'PST_CACHE'			=> 'Czas trwania pamięci podręcznej',
+ 	'PST_CACHE_EXPLAIN'	=> 'Pamięć podręczna wygasa po upływie tego czasu, w sekundach. Ustaw na 0, jeśli chcesz wyłączyć pamięć podręczną dla podobnych tematów.',
+-	'PST_DYNAMIC'		=> 'Display dynamic similar topics',
+-	'PST_DYNAMIC_EXPLAIN'=> 'Show similar topics as users type in the topic title field when creating new topics.',
+ 	'PST_SENSE'			=> 'Czułość wyszukiwania',
+-	'PST_SENSE_EXPLAIN'	=> 'Ustaw czułość wyszukiwania na wartość pomiędzy 1 do 10. Użyj niższej liczby, jeśli nie widzisz żadnych podobnych tematów. Zalecane ustawienia: %d',
++	'PST_SENSE_EXPLAIN'	=> 'Ustaw czułość wyszukiwania na wartość pomiędzy 1 do 10. Użyj niższej liczby, jeśli nie widzisz żadnych podobnych tematów. Zalecane ustawienia: Dla tabel bazy danych “phpbb_topics” używających InnoDB użyj 1; dla MyISAM użyj 5.',
+ 	'PST_LEGEND3'		=> 'Ustawienia forum',
+ 	'PST_NOSHOW_LIST'	=> 'Nie wyświetlaj w',
+ 	'PST_NOSHOW_TITLE'	=> 'Nie wyświetlaj podobnych tematów w',
+@@ -67,14 +64,14 @@ $lang = array_merge($lang, array(
+ 	'PST_STANDARD'		=> 'Standard',
+ 	'PST_ADVANCED'		=> 'Zaawansowane',
+ 	'PST_ADVANCED_TITLE'=> 'Kliknij, aby ustawić zaawansowane ustawienia dla',
+-	'PST_ADVANCED_EXP'	=> 'Tutaj możesz wybrać konkretne fora dla wyświetlania podobnych tematów. Tylko podobne tematy znalezione na wybranych forach będą wyświetlane w <strong>%s</strong>.<br><br>Nie należy wybierać żadnych, jeśli chcesz aby podobne tematy były wyszukiwane we wszystkich forach.<br><br>Zaznacz/odznacz wiele działów poprzez przytrzymanie klawisza <code>CTRL</code> i klikanie.',
++	'PST_ADVANCED_EXP'	=> 'Tutaj możesz wybrać konkretne fora dla wyświetlania podobnych tematów. Tylko podobne tematy znalezione na wybranych forach będą wyświetlane w <strong>%s</strong>.<br /><br />Nie należy wybierać żadnych, jeśli chcesz aby podobne tematy były wyszukiwane we wszystkich forach.<br /><br />Zaznacz/odznacz wiele działów poprzez przytrzymanie klawisza <code>CTRL</code> i klikanie.',
+ 	'PST_ADVANCED_FORUM'=> 'Zaawansowane ustawienia forum',
+ 	'PST_DESELECT_ALL'	=> 'Odznacz wszystko',
+ 	'PST_LEGEND4'		=> 'Ustawienia dodatkowe',
+ 	'PST_WORDS'			=> 'Specjalne słowa do zignorowania',
+ 	'PST_WORDS_EXPLAIN'	=> 'Dodaj specjalne unikalne słowa, które powinny być zignorowane podczas wyszukiwania podobnych tematów. (Notka: Słowa, które są obecnie uważane za powszechne w twoim języku, są już domyślnie ignorowane.) Oddziel każde słowo spacją. Bez względu na wielkość liter.',
+ 	'PST_SAVED'			=> 'Zaktualizowano ustawienia podobnych tematów',
+-	'PST_FORUM_INFO'	=> '“Nie wyświetlaj w”: Nie będzie wyświetlać podobnych tematów w wybranych forach.<br>“Nie szukaj w”: Nie będzie wyszukiwać podobnych tematów w wybranych forach.',
++	'PST_FORUM_INFO'	=> '“Nie wyświetlaj w”: Nie będzie wyświetlać podobnych tematów w wybranych forach.<br />“Nie szukaj w”: Nie będzie wyszukiwać podobnych tematów w wybranych forach.',
+ 	'PST_NO_COMPAT'		=> 'Rozszerzenie podobne tematy nie jest kompatybilne z twoim forum. Rozszerzenie podobne tematy będzie działać tylko w bazie danych MySQL lub PostgreSQL.',
+ 	'PST_ERR_CONFIG'	=> 'Zbyt wiele forów zostało oznaczonych na liście forów. Proszę, spróbuj ponownie z mniejszym wyborem.',
+ ));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/pt/acp_similar_topics.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/language/pt/acp_similar_topics.php"
+index 5b0ecd59c..47b3c3ffb 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/pt/acp_similar_topics.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/language/pt/acp_similar_topics.php"
+@@ -43,7 +43,6 @@ $lang = array_merge($lang, array(
+ 	'PST_EXPLAIN'		=> 'Precise Similar Topics apresenta uma lista de temas semelhantes, na parte inferior da página do tópico atual.',
+ 	'PST_LEGEND1'		=> 'Configurações gerais',
+ 	'PST_ENABLE'		=> 'Ativar Tópicos Semelhantes',
+-	'PST_ENABLE_EXPLAIN'=> 'Show similar topics in topic discussion threads.',
+ 	'PST_LEGEND2'		=> 'Carregar configurações',
+ 	'PST_LIMIT'			=> 'Número de Tópicos Semelhantes a exibir',
+ 	'PST_LIMIT_EXPLAIN'	=> 'Indique o número de Tópicos Semelhantes a exibir. O padrão é 5 Tópicos.',
+@@ -55,10 +54,8 @@ $lang = array_merge($lang, array(
+ 	'PST_DAYS'			=> 'Dias',
+ 	'PST_CACHE'			=> 'Duração da Cache de Tópicos Semelhantes',
+ 	'PST_CACHE_EXPLAIN'	=> 'A Cache de Tópicos Semelhantes vai expirar após esse tempo, em segundos. 0 para desativar a Cache de Tópicos Semelhantes.',
+-	'PST_DYNAMIC'		=> 'Display dynamic similar topics',
+-	'PST_DYNAMIC_EXPLAIN'=> 'Show similar topics as users type in the topic title field when creating new topics.',
+ 	'PST_SENSE'			=> 'Search sensitivity',
+-	'PST_SENSE_EXPLAIN'	=> 'For MySQL or Postgres databases, you can set the search sensitivity to a value between 1 and 10. Use a lower number if you are not seeing any similar topics. Recommended setting: %d',
++	'PST_SENSE_EXPLAIN'	=> 'Set the search sensitivity to a value between 1 and 10. Use a lower number if you are not seeing any similar topics. Recommended settings: For “phpbb_topics” database tables using InnoDB use 1; for MyISAM use 5.',
+ 	'PST_LEGEND3'		=> 'Configurações do fórum',
+ 	'PST_NOSHOW_LIST'	=> 'Não exibir em',
+ 	'PST_NOSHOW_TITLE'	=> 'Não exibir Tópicos Semelhantes em',
+@@ -67,14 +64,14 @@ $lang = array_merge($lang, array(
+ 	'PST_STANDARD'		=> 'Norma',
+ 	'PST_ADVANCED'		=> 'Avançado',
+ 	'PST_ADVANCED_TITLE'=> 'Clique para configurar definições avançadas de Tópicos Semelhantes para',
+-	'PST_ADVANCED_EXP'	=> 'Aqui pode selecionar os Fóruns de onde serão extraidos os Tópicos Semelhantes. Apenas Tópicos Semelhantes encontrados nos Fóruns que selecionar aqui serão exibidos em <strong>%s</strong>.<br><br>Não selecione nenhum se deseja Tópicos Semelhantes de todos os Fóruns pesquisáveis a serem exibidos neste Fórum.<br><br>Selecione/Desmarque múltiplos Fóruns clicando <code>CTRL</code> e clicando.',
++	'PST_ADVANCED_EXP'	=> 'Aqui pode selecionar os Fóruns de onde serão extraidos os Tópicos Semelhantes. Apenas Tópicos Semelhantes encontrados nos Fóruns que selecionar aqui serão exibidos em <strong>%s</strong>.<br /><br />Não selecione nenhum se deseja Tópicos Semelhantes de todos os Fóruns pesquisáveis a serem exibidos neste Fórum.<br /><br />Selecione/Desmarque múltiplos Fóruns clicando <code>CTRL</code> e clicando.',
+ 	'PST_ADVANCED_FORUM'=> 'Configurações avançadas de fórum',
+ 	'PST_DESELECT_ALL'	=> 'Desmarcar todos',
+ 	'PST_LEGEND4'		=> 'Configurações opcionais',
+ 	'PST_WORDS'			=> 'Palavras especiais para ignorar',
+ 	'PST_WORDS_EXPLAIN'	=> 'Adicionar palavras especiais exclusivas para o seu fórum que deve ser ignorado em topicos semelhantes. (Nota: Palavras comuns na sua língua são ignorados por padrão.) Separar cada palavra com um espaço. De caso não é sensível.',
+ 	'PST_SAVED'			=> 'As configurações de Tópicos Semelhantes foram atualizadas',
+-	'PST_FORUM_INFO'	=> '<strong>Não exibir em</strong>: Desativa a exibição de Tópicos Semelhantes nos Fóruns selecionados.<br><strong>Não pesquisar em</strong>: Ignora os Fóruns selecionados na pesquisa de Tópicos Semelhantes.',
++	'PST_FORUM_INFO'	=> '<strong>Não exibir em</strong>: Desativa a exibição de Tópicos Semelhantes nos Fóruns selecionados.<br /><strong>Não pesquisar em</strong>: Ignora os Fóruns selecionados na pesquisa de Tópicos Semelhantes.',
+ 	'PST_NO_COMPAT'		=> 'Similar Topics não irá funcionar com seu Fórum. Similar Topics requer uma Base de Dados MySQL 4 ou MySQL 5 ou PostgreSQL.',
+ 	'PST_ERR_CONFIG'	=> 'Too muitos fóruns foram marcados na lista de fóruns. Por favor, tente novamente com uma seleção menor.',
+ ));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/pt_br/acp_similar_topics.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/language/pt_br/acp_similar_topics.php"
+index 80247f16f..72748ae3b 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/pt_br/acp_similar_topics.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/language/pt_br/acp_similar_topics.php"
+@@ -43,7 +43,6 @@ $lang = array_merge($lang, array(
+ 	'PST_EXPLAIN'		=> 'Tópicos Semelhantes apresenta uma lista de tópicos semelhantes, na parte inferior da página do tópico atual.',
+ 	'PST_LEGEND1'		=> 'Configurações gerais',
+ 	'PST_ENABLE'		=> 'Ativar Tópicos Semelhantes',
+-	'PST_ENABLE_EXPLAIN'=> 'Show similar topics in topic discussion threads.',
+ 	'PST_LEGEND2'		=> 'Carregar configurações',
+ 	'PST_LIMIT'			=> 'Número de Tópicos Semelhantes a exibir',
+ 	'PST_LIMIT_EXPLAIN'	=> 'Indique o número de Tópicos Semelhantes a exibir. O padrão é 5 Tópicos.',
+@@ -55,10 +54,8 @@ $lang = array_merge($lang, array(
+ 	'PST_DAYS'			=> 'Dias',
+ 	'PST_CACHE'			=> 'Duração da Cache de Tópicos Semelhantes',
+ 	'PST_CACHE_EXPLAIN'	=> 'A Cache de Tópicos Semelhantes vai expirar após esse tempo, em segundos. 0 para desativar a Cache de Tópicos Semelhantes.',
+-	'PST_DYNAMIC'		=> 'Display dynamic similar topics',
+-	'PST_DYNAMIC_EXPLAIN'=> 'Show similar topics as users type in the topic title field when creating new topics.',
+ 	'PST_SENSE'			=> 'Sensibilidade de pesquisa',
+-	'PST_SENSE_EXPLAIN'	=> 'Defina a sensibilidade da pesquisa para um valor entre 1 e 10. Use um número menor se você não estiver vendo tópicos semelhantes. Configurações recomendadas: %d',
++	'PST_SENSE_EXPLAIN'	=> 'Defina a sensibilidade da pesquisa para um valor entre 1 e 10. Use um número menor se você não estiver vendo tópicos semelhantes. Configurações recomendadas: Para tabelas de banco de dados “phpbb_topics” usando InnoDB use 1; para MyISAM use 5.',
+ 	'PST_LEGEND3'		=> 'Configurações do fórum',
+ 	'PST_NOSHOW_LIST'	=> 'Não exibir em',
+ 	'PST_NOSHOW_TITLE'	=> 'Não exibir Tópicos Semelhantes em',
+@@ -67,14 +64,14 @@ $lang = array_merge($lang, array(
+ 	'PST_STANDARD'		=> 'Norma',
+ 	'PST_ADVANCED'		=> 'Avançado',
+ 	'PST_ADVANCED_TITLE'=> 'Clique para configurar definições avançadas de Tópicos Semelhantes para',
+-	'PST_ADVANCED_EXP'	=> 'Aqui pode selecionar os Fóruns de onde serão extraidos os Tópicos Semelhantes. Apenas Tópicos Semelhantes encontrados nos Fóruns que selecionar aqui serão exibidos em <strong>%s</strong>.<br><br>Não selecione nenhum se deseja Tópicos Semelhantes de todos os Fóruns pesquisáveis a serem exibidos neste Fórum.<br><br>Selecione/Desmarque múltiplos Fóruns clicando <code>CTRL</code> e clicando.',
++	'PST_ADVANCED_EXP'	=> 'Aqui pode selecionar os Fóruns de onde serão extraidos os Tópicos Semelhantes. Apenas Tópicos Semelhantes encontrados nos Fóruns que selecionar aqui serão exibidos em <strong>%s</strong>.<br /><br />Não selecione nenhum se deseja Tópicos Semelhantes de todos os Fóruns pesquisáveis a serem exibidos neste Fórum.<br /><br />Selecione/Desmarque múltiplos Fóruns clicando <code>CTRL</code> e clicando.',
+ 	'PST_ADVANCED_FORUM'=> 'Configurações avançadas de fórum',
+ 	'PST_DESELECT_ALL'	=> 'Desmarcar todos',
+ 	'PST_LEGEND4'		=> 'Configurações opcionais',
+ 	'PST_WORDS'			=> 'Palavras especiais para ignorar',
+ 	'PST_WORDS_EXPLAIN'	=> 'Adicionar palavras especiais exclusivas para o seu fórum que deve ser ignorado em topicos semelhantes. (Nota: Palavras comuns na sua língua são ignorados por padrão.) Separar cada palavra com um espaço. De caso não é sensível.',
+ 	'PST_SAVED'			=> 'As configurações de Tópicos Semelhantes foram atualizadas',
+-	'PST_FORUM_INFO'	=> '<strong>Não exibir em</strong>: Desativa a exibição de Tópicos Semelhantes nos Fóruns selecionados.<br><strong>Não pesquisar em</strong>: Ignora os Fóruns selecionados na pesquisa de Tópicos Semelhantes.',
++	'PST_FORUM_INFO'	=> '<strong>Não exibir em</strong>: Desativa a exibição de Tópicos Semelhantes nos Fóruns selecionados.<br /><strong>Não pesquisar em</strong>: Ignora os Fóruns selecionados na pesquisa de Tópicos Semelhantes.',
+ 	'PST_NO_COMPAT'		=> 'Tópicos Semelhantes não irá funcionar com seu Fórum. Similar Topics requer uma Base de Dados MySQL 4 ou MySQL 5 ou PostgreSQL.',
+ 	'PST_ERR_CONFIG'	=> 'Muitos fóruns foram marcados na lista de fóruns. Por favor, tente novamente com uma seleção menor.',
+ ));
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/language/pt_preao/acp_similar_topics.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/language/pt_preao/acp_similar_topics.php"
+new file mode 100644
+index 000000000..60f5b202b
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/language/pt_preao/acp_similar_topics.php"
+@@ -0,0 +1,76 @@
++<?php
++/**
++*
++* Precise Similar Topics [English]
++*
++* @copyright (c) 2013 Matt Friedman
++* @license GNU General Public License, version 2 (GPL-2.0)
++*
++*/
++
++/**
++* DO NOT CHANGE
++*/
++if (!defined('IN_PHPBB'))
++{
++	exit;
++}
++
++if (empty($lang) || !is_array($lang))
++{
++	$lang = array();
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
++//
++// Some characters you may want to copy&paste:
++// ’ » “ ” …
++//
++
++$lang = array_merge($lang, array(
++	'PST_TITLE_ACP'		=> 'Precise Similar Topics',
++	'PST_EXPLAIN'		=> 'Precise Similar Topics displays a list of similar (related) topics at the bottom of the current topic’s page.',
++	'PST_LEGEND1'		=> 'General settings',
++	'PST_ENABLE'		=> 'Display Similar Topics',
++	'PST_LEGEND2'		=> 'Load settings',
++	'PST_LIMIT'			=> 'Number of Similar Topics to display',
++	'PST_LIMIT_EXPLAIN'	=> 'Here you can define how many similar topics to display. The default is 5 topics.',
++	'PST_TIME'			=> 'Search period',
++	'PST_TIME_EXPLAIN'	=> 'This option allows you to configure the Similar Topics search period. For example, if set to “5 days” the system will only show similar topics from within the last 5 days. The default is 1 year.',
++	'PST_YEARS'			=> 'Years',
++	'PST_MONTHS'		=> 'Months',
++	'PST_WEEKS'			=> 'Weeks',
++	'PST_DAYS'			=> 'Days',
++	'PST_CACHE'			=> 'Similar Topics cache length',
++	'PST_CACHE_EXPLAIN'	=> 'Cached similar topics will expire after this time, in seconds. Set to 0 if you want to disable the similar topics cache.',
++	'PST_SENSE'			=> 'Search sensitivity',
++	'PST_SENSE_EXPLAIN'	=> 'Set the search sensitivity to a value between 1 and 10. Use a lower number if you are not seeing any similar topics. Recommended settings: For “phpbb_topics” database tables using InnoDB use 1; for MyISAM use 5.',
++	'PST_LEGEND3'		=> 'Forum settings',
++	'PST_NOSHOW_LIST'	=> 'Do Not Display In',
++	'PST_NOSHOW_TITLE'	=> 'Do not display similar topics in',
++	'PST_IGNORE_SEARCH'	=> 'Do Not Search In',
++	'PST_IGNORE_TITLE'	=> 'Do not search for similar topics in',
++	'PST_STANDARD'		=> 'Standard',
++	'PST_ADVANCED'		=> 'Advanced',
++	'PST_ADVANCED_TITLE'=> 'Click to set up advanced similar topic settings for',
++	'PST_ADVANCED_EXP'	=> 'Here you can select specific forums to pull similar topics from. Only similar topics found in the forums you select here will be displayed in <strong>%s</strong>.<br /><br />Do not select any forums if you want similar topics from all searchable forums to be displayed in this forum.<br /><br />Select multiple forums by holding <samp>CTRL</samp> (or <samp>&#8984;CMD</samp> on Mac) and clicking.',
++	'PST_ADVANCED_FORUM'=> 'Advanced forum settings',
++	'PST_DESELECT_ALL'	=> 'Deselect all',
++	'PST_LEGEND4'		=> 'Optional settings',
++	'PST_WORDS'			=> 'Special words to ignore',
++	'PST_WORDS_EXPLAIN'	=> 'Add special words unique to your forum that should be ignored when finding similar topics. (Note: Words that are currently regarded as common in your language are already ignored by default.) Separate each word with a space. Case insensitive.',
++	'PST_SAVED'			=> 'Similar Topics settings updated',
++	'PST_FORUM_INFO'	=> '“Do Not Display In”: Will not show similar topics in the selected forums.<br />“Do Not Search In” : Will not search for similar topics in the selected forums.',
++	'PST_NO_COMPAT'		=> 'Similar Topics is not compatible with your forum. Similar Topics will only run on a MySQL or PostgreSQL database.',
++	'PST_ERR_CONFIG'	=> 'Too many forums were marked in the list of forums. Please try again with a smaller selection.',
++));
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/language/pt_preao/info_acp_similar_topics.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/language/pt_preao/info_acp_similar_topics.php"
+new file mode 100644
+index 000000000..258a59e66
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/language/pt_preao/info_acp_similar_topics.php"
+@@ -0,0 +1,44 @@
++<?php
++/**
++*
++* Precise Similar Topics [English]
++*
++* @copyright (c) 2013 Matt Friedman
++* @license GNU General Public License, version 2 (GPL-2.0)
++*
++*/
++
++/**
++* DO NOT CHANGE
++*/
++if (!defined('IN_PHPBB'))
++{
++	exit;
++}
++
++if (empty($lang) || !is_array($lang))
++{
++	$lang = array();
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
++//
++// Some characters you may want to copy&paste:
++// ’ » “ ” …
++//
++
++$lang = array_merge($lang, array(
++	'PST_TITLE_ACP'		=> 'Precise Similar Topics',
++	'PST_SETTINGS'		=> 'Similar topics settings',
++	'PST_LOG_MSG'		=> '<strong>Altered Similar Topics settings</strong>',
++));
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/language/pt_preao/permissions_similar_topics.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/language/pt_preao/permissions_similar_topics.php"
+new file mode 100644
+index 000000000..ac72e9de9
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/language/pt_preao/permissions_similar_topics.php"
+@@ -0,0 +1,50 @@
++<?php
++/**
++*
++* Precise Similar Topics [English]
++*
++* @copyright (c) 2013 Matt Friedman
++* @license GNU General Public License, version 2 (GPL-2.0)
++*
++*/
++
++/**
++* DO NOT CHANGE
++*/
++if (!defined('IN_PHPBB'))
++{
++	exit;
++}
++
++if (empty($lang) || !is_array($lang))
++{
++	$lang = array();
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
++
++/**
++*	EXTENSION-DEVELOPERS PLEASE NOTE
++*
++*	You are able to put your permission sets into your extension.
++*	The permissions logic should be added via the 'core.permissions' event.
++*	You can easily add new permission categories, types and permissions, by
++*	simply merging them into the respective arrays.
++*	The respective language strings should be added into a language file, that
++*	start with 'permissions_', so they are automatically loaded within the ACP.
++*/
++
++// User Permissions
++$lang = array_merge($lang, array(
++	'ACL_U_SIMILARTOPICS'	=> 'Can view similar topics',
++));
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/language/pt_preao/similar_topics.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/language/pt_preao/similar_topics.php"
+new file mode 100644
+index 000000000..906a7944e
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/language/pt_preao/similar_topics.php"
+@@ -0,0 +1,43 @@
++<?php
++/**
++*
++* Precise Similar Topics [English]
++*
++* @copyright (c) 2013 Matt Friedman
++* @license GNU General Public License, version 2 (GPL-2.0)
++*
++*/
++
++/**
++* DO NOT CHANGE
++*/
++if (!defined('IN_PHPBB'))
++{
++	exit;
++}
++
++if (empty($lang) || !is_array($lang))
++{
++	$lang = array();
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
++//
++// Some characters you may want to copy&paste:
++// ’ » “ ” …
++//
++
++$lang = array_merge($lang, array(
++	'SIMILAR_TOPICS'			=> 'Tópicos Semelhantes',
++	'DISPLAY_SIMILAR_TOPICS'	=> 'Exibir tópicos semelhantes',
++));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/ro/acp_similar_topics.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/language/ro/acp_similar_topics.php"
+index 4fb9e1511..afc15a763 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/ro/acp_similar_topics.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/language/ro/acp_similar_topics.php"
+@@ -43,7 +43,6 @@ $lang = array_merge($lang, array(
+ 	'PST_EXPLAIN'		=> 'Subiecte similare precise afișează o listă de subiecte similare în partea de jos a paginii subiect curente.',
+ 	'PST_LEGEND1'		=> 'Setări generale',
+ 	'PST_ENABLE'		=> 'Activaţi subiectele similare',
+-	'PST_ENABLE_EXPLAIN'=> 'Show similar topics in topic discussion threads.',
+ 	'PST_LEGEND2'		=> 'Încarcă setări',
+ 	'PST_LIMIT'			=> 'Numărul de subiecte similare care să fie afişate',
+ 	'PST_LIMIT_EXPLAIN'	=> 'Aici puteţi preciza câte subiecte similare să fie afişate. Implicite sunt 5.',
+@@ -55,10 +54,8 @@ $lang = array_merge($lang, array(
+ 	'PST_DAYS'			=> 'Zile',
+ 	'PST_CACHE'			=> 'Dimeniune cache',
+ 	'PST_CACHE_EXPLAIN'	=> 'Subiectele similare memorate vor expira după acest timp, în secunde. Alegeţi 0 dacă doriţi să dezactivaţi memorarea subiectelor similare.',
+-	'PST_DYNAMIC'		=> 'Display dynamic similar topics',
+-	'PST_DYNAMIC_EXPLAIN'=> 'Show similar topics as users type in the topic title field when creating new topics.',
+ 	'PST_SENSE'			=> 'Search sensitivity',
+-	'PST_SENSE_EXPLAIN'	=> 'For MySQL or Postgres databases, you can set the search sensitivity to a value between 1 and 10. Use a lower number if you are not seeing any similar topics. Recommended setting: %d',
++	'PST_SENSE_EXPLAIN'	=> 'Set the search sensitivity to a value between 1 and 10. Use a lower number if you are not seeing any similar topics. Recommended settings: For “phpbb_topics” database tables using InnoDB use 1; for MyISAM use 5.',
+ 	'PST_LEGEND3'		=> 'Setări forum',
+ 	'PST_NOSHOW_LIST'	=> 'Nu afişa în',
+ 	'PST_NOSHOW_TITLE'	=> 'Nu afişa subiecte similare în',
+@@ -67,14 +64,14 @@ $lang = array_merge($lang, array(
+ 	'PST_STANDARD'		=> 'Standard',
+ 	'PST_ADVANCED'		=> 'Advanced',
+ 	'PST_ADVANCED_TITLE'=> 'Apăsaţi pentru a configura setările avansate ale subiectelor similare pentru',
+-	'PST_ADVANCED_EXP'	=> 'Aici puteţi alege forumuri specifice din care să afişaţi subiecte similare. Numai subiectele similare găsite în forumurile pe care le-aţi ales aici vor fi afişate în <strong>%s</strong>.<br><br>Nu alegeţi orice forumuri dacă doriţi ca toate subiectele similare din toate forumurile ce pot fi căutate să fie afişate în acest forum.<br><br>Selectaţi/Deselectaţi mai multe forumuri ţinând apăsată tasta <code>CTRL</code> şi făcând click.',
++	'PST_ADVANCED_EXP'	=> 'Aici puteţi alege forumuri specifice din care să afişaţi subiecte similare. Numai subiectele similare găsite în forumurile pe care le-aţi ales aici vor fi afişate în <strong>%s</strong>.<br /><br />Nu alegeţi orice forumuri dacă doriţi ca toate subiectele similare din toate forumurile ce pot fi căutate să fie afişate în acest forum.<br /><br />Selectaţi/Deselectaţi mai multe forumuri ţinând apăsată tasta <code>CTRL</code> şi făcând click.',
+ 	'PST_ADVANCED_FORUM'=> 'Setări avansate pe forum pentru',
+ 	'PST_DESELECT_ALL'	=> 'Deselectaţi tot',
+ 	'PST_LEGEND4'		=> 'Setări opţionale',
+ 	'PST_WORDS'			=> 'Cuvinte speciale ignorate',
+ 	'PST_WORDS_EXPLAIN'	=> 'Adăugaţi cuvinte speciale unice care ar trebui ignorate atunci când sunt căutate subiecte similare. (Reţineţi: Cuvintele care sunt cunoscute ca frecvente în limba dumneavoastră sunt implicit ignorate.) Separaţi cuvintele între ele cu un spaţiu. Majusculele sunt nesemnificative.',
+ 	'PST_SAVED'			=> 'Setări actualizate',
+-	'PST_FORUM_INFO'	=> '“Nu afişa în”: Nu va afişa subiectele similare în forumurile alese.<br>“Nu căuta în” : Nu va căuta subiecte similare în forumurile alese.',
++	'PST_FORUM_INFO'	=> '“Nu afişa în”: Nu va afişa subiectele similare în forumurile alese.<br />“Nu căuta în” : Nu va căuta subiecte similare în forumurile alese.',
+ 	'PST_NO_COMPAT'		=> 'MODificarea Subiecte similare nu va funcţiona pe forumul dumneavoastr. MODificarea Subiecte similare necesită o bază de date cu MySQL 4 sau MySQL 5 sau PostgreSQL.',
+ 	'PST_ERR_CONFIG'	=> 'Prea multe forumuri au fost marcate în lista de forumuri. Vă rugăm să încercați din nou, cu o selecție mai mic.',
+ ));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/ru/acp_similar_topics.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/language/ru/acp_similar_topics.php"
+index 5b59297ca..12b8aaf7f 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/ru/acp_similar_topics.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/language/ru/acp_similar_topics.php"
+@@ -42,7 +42,6 @@ $lang = array_merge($lang, array(
+ 	'PST_EXPLAIN'		=> 'Расширение «Похожие темы» отображает список похожих (связанных) тем внизу на странице с сообщениями просматриваемой темы.',
+ 	'PST_LEGEND1'		=> 'Основные настройки',
+ 	'PST_ENABLE'		=> 'Отображать похожие темы',
+-	'PST_ENABLE_EXPLAIN'=> 'Show similar topics in topic discussion threads.',
+ 	'PST_LEGEND2'		=> 'Настройки загрузки',
+ 	'PST_LIMIT'			=> 'Количество похожих тем для отображения',
+ 	'PST_LIMIT_EXPLAIN'	=> 'Здесь можно установить количество тем, которые будут показываться в блоке «Похожие темы». По умолчанию установлено отображение 5 похожих тем.',
+@@ -54,10 +53,8 @@ $lang = array_merge($lang, array(
+ 	'PST_DAYS'			=> 'дней',
+ 	'PST_CACHE'			=> 'Размер кэша для расширения «Похожие темы»',
+ 	'PST_CACHE_EXPLAIN'	=> 'Количество секунд, по прошествии которого очищается кэш расширения «Похожие темы». Установите данную опцию в 0, если хотите полностью отключить кэширование для данного расширения.',
+-	'PST_DYNAMIC'		=> 'Display dynamic similar topics',
+-	'PST_DYNAMIC_EXPLAIN'=> 'Show similar topics as users type in the topic title field when creating new topics.',
+ 	'PST_SENSE'			=> 'Чувствительность поиска',
+-	'PST_SENSE_EXPLAIN'	=> 'Здесь можно установить чувствительность поиска в пределах от 1 до 10. Используйте число меньше установленного, если не отображается ни одна похожая тема. Рекомендуемая настройка: %d',
++	'PST_SENSE_EXPLAIN'	=> 'Здесь можно установить чувствительность поиска в пределах от 1 до 10. Используйте число меньше установленного, если не отображается ни одна похожая тема. Рекомендуемая настройка: если тип таблицы «phpbb_topics» установлен в InnoDB, то установите 1; для типа MyISAM установите 5.',
+ 	'PST_LEGEND3'		=> 'Настройки форума',
+ 	'PST_NOSHOW_LIST'	=> 'Не отображать в',
+ 	'PST_NOSHOW_TITLE'	=> 'Не отображать похожие темы в',
+@@ -66,14 +63,14 @@ $lang = array_merge($lang, array(
+ 	'PST_STANDARD'		=> 'Стандартные',
+ 	'PST_ADVANCED'		=> 'Продвинутые',
+ 	'PST_ADVANCED_TITLE'=> 'Кликните мышкой для того, чтобы открыть продвинутые установки расширения «Похожие темы»',
+-	'PST_ADVANCED_EXP'	=> 'Здесь вы можете указать конкретные разделы форума, откуда брать похожие темы. В блоке «Похожие темы» будут отображаться темы ТОЛЬКО из указанных здесь разделов.<br><br>Если вы не выберете ни один раздел, то поиск похожих тем будет осуществляться по всем разделам форума.<br><br>Можно выбрать несколько разделов с помощью клавиши <samp>CTRL</samp> (либо клавиши <samp>&#8984;CMD</samp> на компьютерах Mac) и левой кнопки мышки.',
++	'PST_ADVANCED_EXP'	=> 'Здесь вы можете указать конкретные разделы форума, откуда брать похожие темы. В блоке «Похожие темы» будут отображаться темы ТОЛЬКО из указанных здесь разделов.<br /><br />Если вы не выберете ни один раздел, то поиск похожих тем будет осуществляться по всем разделам форума.<br /><br />Можно выбрать несколько разделов с помощью клавиши <samp>CTRL</samp> (либо клавиши <samp>&#8984;CMD</samp> на компьютерах Mac) и левой кнопки мышки.',
+ 	'PST_ADVANCED_FORUM'=> 'Продвинутые настройки',
+ 	'PST_DESELECT_ALL'	=> 'Сбросить всё',
+ 	'PST_LEGEND4'		=> 'Необязательные настройки',
+ 	'PST_WORDS'			=> 'Игнорировать отдельные слова',
+ 	'PST_WORDS_EXPLAIN'	=> 'Здесь можно прописать отдельные слова, которые не будут учитываться при поиске похожих тем. (Внимание: некоторые общие слова используемого вами языка уже игнорируются по умолчанию.) Каждое слово отделяется пробелом. Регистр слов не учитывается.',
+ 	'PST_SAVED'			=> 'Настройки расширения «Похожие темы» обновлены',
+-	'PST_FORUM_INFO'	=> '«Не отображать в»: в выбранных здесь разделах блок «Похожие темы» отображаться не будет.<br>«Не осуществлять поиск похожих тем в»: в выбранных здесь разделах поиск похожих тем осуществляться не будет.',
++	'PST_FORUM_INFO'	=> '«Не отображать в»: в выбранных здесь разделах блок «Похожие темы» отображаться не будет.<br />«Не осуществлять поиск похожих тем в»: в выбранных здесь разделах поиск похожих тем осуществляться не будет.',
+ 	'PST_NO_COMPAT'		=> 'Расширение «Похожие темы» не совместимо с вашим форумом. Для использование данного расширения необходимо использование базы данных MySQL или PostgreSQL.',
+ 	'PST_ERR_CONFIG'	=> 'Выбрано слишком много разделов форума. Пожалуйста, укажите меньшее количество разделов.',
+ ));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/sr/acp_similar_topics.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/language/sr/acp_similar_topics.php"
+index 2f49b07ab..e397a8571 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/sr/acp_similar_topics.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/language/sr/acp_similar_topics.php"
+@@ -42,7 +42,6 @@ $lang = array_merge($lang, array(
+ 	'PST_EXPLAIN'		=> 'Precise Similar Topics displays a list of similar (related) topics at the bottom of the current topic’s page.',
+ 	'PST_LEGEND1'		=> 'Generalna podešavanja',
+ 	'PST_ENABLE'		=> 'Uključi Similar Topics',
+-	'PST_ENABLE_EXPLAIN'=> 'Show similar topics in topic discussion threads.',
+ 	'PST_LEGEND2'		=> 'Učitaj podešavanja',
+ 	'PST_LIMIT'			=> 'Broj sličnih tema koje će biti prikazane',
+ 	'PST_LIMIT_EXPLAIN'	=> 'Ovde možete odrediti koliko sličnih tema će biti prikazano. Podrazumevana vrednost je 5.',
+@@ -54,10 +53,8 @@ $lang = array_merge($lang, array(
+ 	'PST_DAYS'			=> 'Dana',
+ 	'PST_CACHE'			=> 'Dužina keša za Similar Topics',
+ 	'PST_CACHE_EXPLAIN'	=> 'Keširane slične teme će da nestanu nakon toliko vremena u sekunadma. Podesite vrednost na 0 ukoliko želite da isključite ovu opciju.',
+-	'PST_DYNAMIC'		=> 'Display dynamic similar topics',
+-	'PST_DYNAMIC_EXPLAIN'=> 'Show similar topics as users type in the topic title field when creating new topics.',
+ 	'PST_SENSE'			=> 'Search sensitivity',
+-	'PST_SENSE_EXPLAIN'	=> 'For MySQL or Postgres databases, you can set the search sensitivity to a value between 1 and 10. Use a lower number if you are not seeing any similar topics. Recommended setting: %d',
++	'PST_SENSE_EXPLAIN'	=> 'Set the search sensitivity to a value between 1 and 10. Use a lower number if you are not seeing any similar topics. Recommended settings: For “phpbb_topics” database tables using InnoDB use 1; for MyISAM use 5.',
+ 	'PST_LEGEND3'		=> 'Podešavanja foruma',
+ 	'PST_NOSHOW_LIST'	=> 'Ne prikazuj u',
+ 	'PST_NOSHOW_TITLE'	=> 'Ne prikazuj slične teme u',
+@@ -66,14 +63,14 @@ $lang = array_merge($lang, array(
+ 	'PST_STANDARD'		=> 'Standard',
+ 	'PST_ADVANCED'		=> 'Napredna podešavanja',
+ 	'PST_ADVANCED_TITLE'=> 'Kliknite ukoliko želite da odredite napredna podešavanja za',
+-	'PST_ADVANCED_EXP'	=> 'Ovde možete odrediti specifične forume iz kojih želite da se pretražuju slične teme. Jedino slične teme koje budu pronađene u forumu će biti prikazane u <strong>%s</strong>.<br><br>Nemojte da selektujete nijedan forum ukoliko želite da se prikazuju slične teme iz svih foruma u kojima je uključena opcija Similar Topics.<br><br>Možete izabrati više foruma tako što držite <code>CTRL</code> i kliknete.',
++	'PST_ADVANCED_EXP'	=> 'Ovde možete odrediti specifične forume iz kojih želite da se pretražuju slične teme. Jedino slične teme koje budu pronađene u forumu će biti prikazane u <strong>%s</strong>.<br /><br />Nemojte da selektujete nijedan forum ukoliko želite da se prikazuju slične teme iz svih foruma u kojima je uključena opcija Similar Topics.<br /><br />Možete izabrati više foruma tako što držite <code>CTRL</code> i kliknete.',
+ 	'PST_ADVANCED_FORUM'=> 'Advanced forum settings',
+ 	'PST_DESELECT_ALL'	=> 'Deselektuj sve',
+ 	'PST_LEGEND4'		=> 'Opciona podešavanja',
+ 	'PST_WORDS'			=> 'Specialne reči za ignorisanje',
+ 	'PST_WORDS_EXPLAIN'	=> 'Dodajte specijalne reči koje su unikatne za vaš forum koje bi trebalo da budu ignorisane kada se pretražuju slične teme. (Napomena: reči koje se inače smatraju za ustaljene će ionako biti ignorisane prilikom pretrage.) Reči razdvojte razmakom. Case insensitive.',
+ 	'PST_SAVED'			=> 'Podešavanja za Similar Topics su ažurirana',
+-	'PST_FORUM_INFO'	=> '"Ne prikazuj u": Neće prikazati slične teme u izabranim forumima.<br>"Ne pretražuj u": Neće pretraživati slične teme u izabranim forumima.',
++	'PST_FORUM_INFO'	=> '"Ne prikazuj u": Neće prikazati slične teme u izabranim forumima.<br />"Ne pretražuj u": Neće pretraživati slične teme u izabranim forumima.',
+ 	'PST_NO_COMPAT'		=> 'Similar Topics ne funkcioniše sa vašim forumom. Similar Topics zahteva MySQL 4 ili MySQL 5 ili PostgreSQL bazu podataka.',
+ 	'PST_ERR_CONFIG'	=> 'Previše forumi su označeni na listi forumima . Pokušajte ponovo sa manjim izborom.',
+ ));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/sv/acp_similar_topics.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/language/sv/acp_similar_topics.php"
+index 84250801e..1e426b274 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/sv/acp_similar_topics.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/language/sv/acp_similar_topics.php"
+@@ -43,7 +43,6 @@ $lang = array_merge($lang, array(
+ 	'PST_EXPLAIN'		=> 'Precise Similar Topics visar en lista över liknande ämnen längst ner i det aktuella ämnet sida.',
+ 	'PST_LEGEND1'		=> 'Generella inställningar',
+ 	'PST_ENABLE'		=> 'Aktivera Similar Topics',
+-	'PST_ENABLE_EXPLAIN'=> 'Show similar topics in topic discussion threads.',
+ 	'PST_LEGEND2'		=> 'Ladda inställningar',
+ 	'PST_LIMIT'			=> 'Antal liknande trådar som ska visas',
+ 	'PST_LIMIT_EXPLAIN'	=> 'Här anger du antalet liknande trådar som skall visas. Förinställt värde är 5 st.',
+@@ -55,10 +54,8 @@ $lang = array_merge($lang, array(
+ 	'PST_DAYS'			=> 'Dagar',
+ 	'PST_CACHE'			=> 'Lagring av liknande trådar',
+ 	'PST_CACHE_EXPLAIN'	=> 'Lagrade trådar upphör efter denna tid, inställt i sekunder. Ange 0 om du vill stänga av lagring av liknande trådar.',
+-	'PST_DYNAMIC'		=> 'Display dynamic similar topics',
+-	'PST_DYNAMIC_EXPLAIN'=> 'Show similar topics as users type in the topic title field when creating new topics.',
+ 	'PST_SENSE'			=> 'Search sensitivity',
+-	'PST_SENSE_EXPLAIN'	=> 'For MySQL or Postgres databases, you can set the search sensitivity to a value between 1 and 10. Use a lower number if you are not seeing any similar topics. Recommended setting: %d',
++	'PST_SENSE_EXPLAIN'	=> 'Set the search sensitivity to a value between 1 and 10. Use a lower number if you are not seeing any similar topics. Recommended settings: For “phpbb_topics” database tables using InnoDB use 1; for MyISAM use 5.',
+ 	'PST_LEGEND3'		=> 'Foruminställningar',
+ 	'PST_NOSHOW_LIST'	=> 'Visa inte i',
+ 	'PST_NOSHOW_TITLE'	=> 'Visa inte liknande trådar i',
+@@ -67,14 +64,14 @@ $lang = array_merge($lang, array(
+ 	'PST_STANDARD'		=> 'Standard',
+ 	'PST_ADVANCED'		=> 'Avancerade',
+ 	'PST_ADVANCED_TITLE'=> 'Klicka för att ställa in avancerade inställningar',
+-	'PST_ADVANCED_EXP'	=> 'Här kan du välja specifika kategorier att hämta liknande trådar från. Endast liknande trådar från de kategorier du väljer här kommer att visas i <strong>%s</strong>.<br><br>Välj inga specifika kategorier om du vill visa liknande trådar från alla kategorier i detta forum.<br><br>Använd t.ex. kombinationen <code>CTRL</code> + musklick för att markera och välja (avvälja) fler än en kategori.',
++	'PST_ADVANCED_EXP'	=> 'Här kan du välja specifika kategorier att hämta liknande trådar från. Endast liknande trådar från de kategorier du väljer här kommer att visas i <strong>%s</strong>.<br /><br />Välj inga specifika kategorier om du vill visa liknande trådar från alla kategorier i detta forum.<br /><br />Använd t.ex. kombinationen <code>CTRL</code> + musklick för att markera och välja (avvälja) fler än en kategori.',
+ 	'PST_ADVANCED_FORUM'=> 'Avancerade foruminställningar',
+ 	'PST_DESELECT_ALL'	=> 'Avmarkera alla',
+ 	'PST_LEGEND4'		=> 'Valfria inställningar',
+ 	'PST_WORDS'			=> 'Särskilda ord som ska ignoreras',
+ 	'PST_WORDS_EXPLAIN'	=> 'Lägg till särskilda ord på forumet som skall ignoreras vid sökningen av liknande trådar. (Obs: Ord som betraktas som vanliga ord är redan undantagna). Separera varje ord med ett mellanslag. Ingen hänsyn tas till versaler eller gemenser.',
+ 	'PST_SAVED'			=> 'Inställningarna har uppdaterats',
+-	'PST_FORUM_INFO'	=> '“Visa inte i” :  Liknande trådar visas inte i valda kategorier.<br>“Sök inte i” :  Sökning efter liknande trådar sker inte i valda kategorier.',
++	'PST_FORUM_INFO'	=> '“Visa inte i” :  Liknande trådar visas inte i valda kategorier.<br />“Sök inte i” :  Sökning efter liknande trådar sker inte i valda kategorier.',
+ 	'PST_NO_COMPAT'		=> 'Similar Topics fungerar inte på ditt forum. Similar Topics kräver MySQL 4 eller MySQL 5 eller PostgreSQL.',
+ 	'PST_ERR_CONFIG'	=> 'Alltför många forum märktes i listan över forum. Försök igen med ett mindre urval.',
+ ));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/sv/search_ignore_words.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/sv/search_ignore_words.php"
+deleted file mode 100644
+index 7a24d356a..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/sv/search_ignore_words.php"
++++ /dev/null
+@@ -1,115 +0,0 @@
+-<?php
+-/**
+- *
+- * Precise Similar Topics
+- *
+- * @copyright (c) 2025 Matt Friedman
+- * @license GNU General Public License, version 2 (GPL-2.0)
+- *
+- * This [sv] language list of stop words created by Matt Friedman for Similar Topics
+- *
+- */
+-
+-if (!defined('IN_PHPBB'))
+-{
+-   exit;
+-}
+-
+-$words = array(
+-	'alla',
+-	'alltid',
+-	'andra',
+-	'att',
+-	'av',
+-	'bara',
+-	'blev',
+-	'bli',
+-	'blir',
+-	'bra',
+-	'dag',
+-	'dagar',
+-	'den',
+-	'denna',
+-	'det',
+-	'detta',
+-	'dig',
+-	'din',
+-	'dina',
+-	'dit',
+-	'du',
+-	'efter',
+-	'eller',
+-	'en',
+-	'ett',
+-	'finns',
+-	'fram',
+-	'från',
+-	'för',
+-	'genom',
+-	'god',
+-	'hade',
+-	'han',
+-	'hans',
+-	'har',
+-	'hem',
+-	'hennes',
+-	'här',
+-	'hör',
+-	'hur',
+-	'inte',
+-	'jag',
+-	'kan',
+-	'kanske',
+-	'kom',
+-	'kommer',
+-	'kring',
+-	'lite',
+-	'man',
+-	'med',
+-	'men',
+-	'mer',
+-	'mycket',
+-	'måste',
+-	'när',
+-	'någon',
+-	'något',
+-	'några',
+-	'och',
+-	'ofta',
+-	'om',
+-	'på',
+-	'redan',
+-	'rätt',
+-	'sade',
+-	'samma',
+-	'sedan',
+-	'ser',
+-	'sig',
+-	'sin',
+-	'sina',
+-	'sitt',
+-	'ska',
+-	'skulle',
+-	'som',
+-	'stor',
+-	'stora',
+-	'säga',
+-	'säger',
+-	'tid',
+-	'till',
+-	'under',
+-	'upp',
+-	'var',
+-	'vara',
+-	'varit',
+-	'varje',
+-	'vem',
+-	'vi',
+-	'vid',
+-	'vill',
+-	'väl',
+-	'än',
+-	'är',
+-	'även',
+-	'över',
+-);
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/tr/acp_similar_topics.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/language/tr/acp_similar_topics.php"
+index 4b945d8c4..924c87538 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/tr/acp_similar_topics.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/language/tr/acp_similar_topics.php"
+@@ -42,7 +42,6 @@ $lang = array_merge($lang, array(
+ 	'PST_EXPLAIN'		=> 'Benzer Konular eklentisi benzer (ilişkili) konuların bir listesini mevcut konu sayfasının altında gösterir.',
+ 	'PST_LEGEND1'		=> 'Genel Ayarlar',
+ 	'PST_ENABLE'		=> 'Benzer Konuları Göster',
+-	'PST_ENABLE_EXPLAIN'=> 'Show similar topics in topic discussion threads.',
+ 	'PST_LEGEND2'		=> 'Yükleme ayarları',
+ 	'PST_LIMIT'			=> 'Gösterilecek Benzer Konu sayısı',
+ 	'PST_LIMIT_EXPLAIN'	=> 'Buradan kaç tane Benzer Konunun gösterileceğini belirleyebilirsiniz. Varsayılan değer 5 konudur.',
+@@ -54,10 +53,8 @@ $lang = array_merge($lang, array(
+ 	'PST_DAYS'			=> 'Gün',
+ 	'PST_CACHE'			=> 'Benzer Konular önbellek uzunluğu',
+ 	'PST_CACHE_EXPLAIN'	=> 'Önbelleklenmiş benzer konuların süresi bu süre sonunda geçecektir, saniye olarak. 0 olarak ayarlarsanız benzer konular önbellekleme özelliğini kapatırsınız.',
+-	'PST_DYNAMIC'		=> 'Display dynamic similar topics',
+-	'PST_DYNAMIC_EXPLAIN'=> 'Show similar topics as users type in the topic title field when creating new topics.',
+-	'PST_SENSE'			=> 'Arama duyarlılığı',
+-	'PST_SENSE_EXPLAIN'	=> 'Arama duyarlılığını 1 ile 10 arasında bir değere ayarlayın. Benzer konular görmüyorsanız daha düşük bir sayı kullanın. Önerilen ayarlar: InnoDB kullanan “phpbb_topics” veritabanı tabloları için 1 kullanın; MyISAM kullanımı için 5.',
++	'PST_SENSE'			=> 'Search sensitivity',
++	'PST_SENSE_EXPLAIN'	=> 'Set the search sensitivity to a value between 1 and 10. Use a lower number if you are not seeing any similar topics. Recommended settings: For “phpbb_topics” database tables using InnoDB use 1; for MyISAM use 5.',
+ 	'PST_LEGEND3'		=> 'Forum ayarları',
+ 	'PST_NOSHOW_LIST'	=> 'Şurada gösterme',
+ 	'PST_NOSHOW_TITLE'	=> 'Benzer Konuları şurada gösterme',
+@@ -66,14 +63,14 @@ $lang = array_merge($lang, array(
+ 	'PST_STANDARD'		=> 'Standart',
+ 	'PST_ADVANCED'		=> 'Gelişmiş',
+ 	'PST_ADVANCED_TITLE'=> 'Gelişmiş benzer konular ayarlarını yüklemek için tıklayın',
+-	'PST_ADVANCED_EXP'	=> 'Buradan benzer konuların seçileceği belirli forumları seçebilirsin. Sadece burada seçtiğiniz forumlardaki benzer konular şurada gösterilir <strong>%s</strong>.<br><br>Tüm aranabilen forumlardan konuların Benzer Konularda gösterilmesini istiyorsanız hiç bir forumu seçmeyin.<br><br><code>CTRL</code>ye basılı tutup çoklu forum Seçimi/Seçimi Kaldırma işlemini yapabilirsiniz.',
++	'PST_ADVANCED_EXP'	=> 'Buradan benzer konuların seçileceği belirli forumları seçebilirsin. Sadece burada seçtiğiniz forumlardaki benzer konular şurada gösterilir <strong>%s</strong>.<br /><br />Tüm aranabilen forumlardan konuların Benzer Konularda gösterilmesini istiyorsanız hiç bir forumu seçmeyin.<br /><br /><code>CTRL</code>ye basılı tutup çoklu forum Seçimi/Seçimi Kaldırma işlemini yapabilirsiniz.',
+ 	'PST_ADVANCED_FORUM'=> 'Gelişmiş forum ayarları',
+ 	'PST_DESELECT_ALL'	=> 'Tümünü kaldır',
+ 	'PST_LEGEND4'		=> 'İsteğe bağlı ayarlar',
+ 	'PST_WORDS'			=> 'Dikkate alınmayacak kelimeler',
+ 	'PST_WORDS_EXPLAIN'	=> 'Benzer konular bulunurken yoksayılacak özel kelimeleri ekle. (Not: Dilinizde sık kullanılan kelimeler zaten varsayılan olarak yoksayılmıştır.) Kelimeleri bir boşluk ile ayır. Büyük-küçük harf duyarlıdır.',
+ 	'PST_SAVED'			=> 'Benzer Konular ayarları güncellendi',
+-	'PST_FORUM_INFO'	=> '“Şurada gösterme”: seçili forumlarda benzer konuları göstermeyecek.<br>“Şurada arama” : Seçili forumlarda benzer konular  için aramayacak.',
++	'PST_FORUM_INFO'	=> '“Şurada gösterme”: seçili forumlarda benzer konuları göstermeyecek.<br />“Şurada arama” : Seçili forumlarda benzer konular  için aramayacak.',
+ 	'PST_NO_COMPAT'		=> 'Benzer Konular forumunuzla uyumlu değil. Benzer Konular sadece MySQL 4 veya MySQL 5 veya PostgreSQL veritabanında çalışır.',
+ 	'PST_ERR_CONFIG'	=> 'Çok fazla forumlar forumlarda listesinde işaretlenmiştir. Küçük bir seçim ile tekrar deneyin.',
+ ));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/tr/search_ignore_words.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/tr/search_ignore_words.php"
+deleted file mode 100644
+index 0a4406e70..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/tr/search_ignore_words.php"
++++ /dev/null
+@@ -1,102 +0,0 @@
+-<?php
+-/**
+- *
+- * Precise Similar Topics
+- *
+- * @copyright (c) 2025 Matt Friedman
+- * @license GNU General Public License, version 2 (GPL-2.0)
+- *
+- * This [tr] language list of stop words created by Matt Friedman for Similar Topics
+- *
+- */
+-
+-if (!defined('IN_PHPBB'))
+-{
+-   exit;
+-}
+-
+-$words = array(
+-	'acaba',
+-	'ama',
+-	'ancak',
+-	'artık',
+-	'aslında',
+-	'ayrıca',
+-	'bana',
+-	'bazen',
+-	'ben',
+-	'beni',
+-	'benim',
+-	'bile',
+-	'bir',
+-	'birçok',
+-	'biri',
+-	'birkaç',
+-	'biz',
+-	'bizi',
+-	'bizim',
+-	'bu',
+-	'buna',
+-	'bunda',
+-	'bundan',
+-	'bunlar',
+-	'bunları',
+-	'bunların',
+-	'bunu',
+-	'bunun',
+-	'büyük',
+-	'çok',
+-	'da',
+-	'daha',
+-	'de',
+-	'değil',
+-	'diye',
+-	'en',
+-	'eve',
+-	'gibi',
+-	'gün',
+-	'günler',
+-	'hep',
+-	'her',
+-	'hiç',
+-	'için',
+-	'ile',
+-	'ise',
+-	'işte',
+-	'kadar',
+-	'kendi',
+-	'ki',
+-	'küçük',
+-	'mı',
+-	'mi',
+-	'mu',
+-	'mü',
+-	'nasıl',
+-	'ne',
+-	'neden',
+-	'nerede',
+-	'niye',
+-	'olan',
+-	'olarak',
+-	'oldu',
+-	'olduğu',
+-	'olmak',
+-	'olması',
+-	'onu',
+-	'onun',
+-	'sadece',
+-	'şey',
+-	'şimdi',
+-	'şu',
+-	'şunu',
+-	'şunun',
+-	'tüm',
+-	'var',
+-	've',
+-	'veya',
+-	'ya',
+-	'yani',
+-	'yapılan',
+-	'yok',
+-	'zaman',
+-);
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/migrations/release_1_7_x/dynamic_similar_topics.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/migrations/release_1_7_x/dynamic_similar_topics.php"
+deleted file mode 100644
+index a17f26fac..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/migrations/release_1_7_x/dynamic_similar_topics.php"
++++ /dev/null
+@@ -1,31 +0,0 @@
+-<?php
+-/**
+- *
+- * Precise Similar Topics
+- *
+- * @copyright (c) 2025 Matt Friedman
+- * @license GNU General Public License, version 2 (GPL-2.0)
+- *
+- */
+-
+-namespace vse\similartopics\migrations\release_1_7_x;
+-
+-class dynamic_similar_topics extends \phpbb\db\migration\migration
+-{
+-	public function effectively_installed()
+-	{
+-		return $this->config->offsetExists('similar_topics_dynamic');
+-	}
+-
+-	public static function depends_on()
+-	{
+-		return ['\vse\similartopics\migrations\release_1_5_x\similar_topic_words'];
+-	}
+-
+-	public function update_data()
+-	{
+-		return [
+-			['config.add', ['similar_topics_dynamic', 0]],
+-		];
+-	}
+-}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/migrations/release_1_7_x/mssql_index.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/migrations/release_1_7_x/mssql_index.php"
+deleted file mode 100644
+index 5fef72be9..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/migrations/release_1_7_x/mssql_index.php"
++++ /dev/null
+@@ -1,87 +0,0 @@
+-<?php
+-/**
+- *
+- * Precise Similar Topics
+- *
+- * @copyright (c) 2025 Matt Friedman
+- * @license GNU General Public License, version 2 (GPL-2.0)
+- *
+- */
+-
+-namespace vse\similartopics\migrations\release_1_7_x;
+-
+-use vse\similartopics\driver\mssql;
+-
+-class mssql_index extends \phpbb\db\migration\migration
+-{
+-	/** @var mssql */
+-	protected $driver;
+-
+-	/**
+-	 * Do not run this migration if the DB is not MSSQL or MSSQL NATIVE
+-	 *
+-	 * @return bool
+-	 */
+-	public function effectively_installed()
+-	{
+-		if (strpos($this->db->get_sql_layer(), 'mssql') === false)
+-		{
+-			return true;
+-		}
+-		return $this->get_driver()->is_fulltext('topic_title', TOPICS_TABLE);
+-	}
+-
+-	public static function depends_on()
+-	{
+-		return ['\vse\similartopics\migrations\release_1_5_x\similar_topic_words'];
+-	}
+-
+-	public function update_data()
+-	{
+-		return [
+-			['if', [
+-				strpos($this->db->get_sql_layer(), 'mssql') === 0,
+-				['custom', [[$this, 'create_mssql_fulltext_index']]],
+-			]],
+-		];
+-	}
+-
+-	public function revert_data()
+-	{
+-		return [
+-			['if', [
+-				strpos($this->db->get_sql_layer(), 'mssql') === 0,
+-				['custom', [[$this, 'drop_mssql_fulltext_index']]],
+-			]],
+-		];
+-	}
+-
+-	/**
+-	 * Create a FULLTEXT index for the topic_title in the topic table
+-	 */
+-	public function create_mssql_fulltext_index()
+-	{
+-		$this->get_driver()->create_fulltext_index('topic_title', TOPICS_TABLE);
+-	}
+-
+-	/**
+-	 * Drop the FULLTEXT index we created from the topic table
+-	 */
+-	public function drop_mssql_fulltext_index()
+-	{
+-		$sql = 'DROP FULLTEXT INDEX ON ' . TOPICS_TABLE;
+-		$this->db->sql_query($sql);
+-	}
+-
+-	/**
+-	 * @return mssql
+-	 */
+-	protected function get_driver()
+-	{
+-		if ($this->driver === null)
+-		{
+-			$this->driver = new mssql($this->db);
+-		}
+-		return $this->driver;
+-	}
+-}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/migrations/release_1_7_x/oracle_index.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/migrations/release_1_7_x/oracle_index.php"
+deleted file mode 100644
+index feb5b7e7d..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/migrations/release_1_7_x/oracle_index.php"
++++ /dev/null
+@@ -1,88 +0,0 @@
+-<?php
+-/**
+- *
+- * Precise Similar Topics
+- *
+- * @copyright (c) 2025 Matt Friedman
+- * @license GNU General Public License, version 2 (GPL-2.0)
+- *
+- */
+-
+-namespace vse\similartopics\migrations\release_1_7_x;
+-
+-use vse\similartopics\driver\oracle;
+-
+-class oracle_index extends \phpbb\db\migration\migration
+-{
+-	/** @var oracle */
+-	protected $driver;
+-
+-	/**
+-	 * Do not run this migration if the DB is not Oracle
+-	 *
+-	 * @return bool
+-	 */
+-	public function effectively_installed()
+-	{
+-		if (strpos($this->db->get_sql_layer(), 'oracle') !== 0)
+-		{
+-			return true;
+-		}
+-		return $this->get_driver()->is_fulltext('topic_title', TOPICS_TABLE);
+-	}
+-
+-	public static function depends_on()
+-	{
+-		return ['\vse\similartopics\migrations\release_1_5_x\similar_topic_words'];
+-	}
+-
+-	public function update_data()
+-	{
+-		return [
+-			['if', [
+-				strpos($this->db->get_sql_layer(), 'oracle') === 0,
+-				['custom', [[$this, 'create_oracle_fulltext_index']]],
+-			]],
+-		];
+-	}
+-
+-	public function revert_data()
+-	{
+-		return [
+-			['if', [
+-				strpos($this->db->get_sql_layer(), 'oracle') === 0,
+-				['custom', [[$this, 'drop_oracle_fulltext_index']]],
+-			]],
+-		];
+-	}
+-
+-	/**
+-	 * Create a FULLTEXT index for the topic_title in the topic table
+-	 */
+-	public function create_oracle_fulltext_index()
+-	{
+-		$this->get_driver()->create_fulltext_index('topic_title', TOPICS_TABLE);
+-	}
+-
+-	/**
+-	 * Drop the FULLTEXT index we created from the topic table
+-	 */
+-	public function drop_oracle_fulltext_index()
+-	{
+-		$index_name = TOPICS_TABLE . '_topic_title_ctx_idx';
+-		$sql = 'DROP INDEX ' . $this->db->sql_escape($index_name);
+-		$this->db->sql_query($sql);
+-	}
+-
+-	/**
+-	 * @return oracle
+-	 */
+-	protected function get_driver()
+-	{
+-		if ($this->driver === null)
+-		{
+-			$this->driver = new oracle($this->db);
+-		}
+-		return $this->driver;
+-	}
+-}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/migrations/release_1_7_x/sqlite3_index.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/migrations/release_1_7_x/sqlite3_index.php"
+deleted file mode 100644
+index 116effec5..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/migrations/release_1_7_x/sqlite3_index.php"
++++ /dev/null
+@@ -1,87 +0,0 @@
+-<?php
+-/**
+- *
+- * Precise Similar Topics
+- *
+- * @copyright (c) 2025 Matt Friedman
+- * @license GNU General Public License, version 2 (GPL-2.0)
+- *
+- */
+-
+-namespace vse\similartopics\migrations\release_1_7_x;
+-
+-use vse\similartopics\driver\sqlite3;
+-
+-class sqlite3_index extends \phpbb\db\migration\migration
+-{
+-	/** @var sqlite3 */
+-	protected $driver;
+-
+-	/**
+-	 * Do not run this migration if the DB is not SQLITE3
+-	 *
+-	 * @return bool
+-	 */
+-	public function effectively_installed()
+-	{
+-		if ($this->db->get_sql_layer() !== 'sqlite3')
+-		{
+-			return true;
+-		}
+-		return $this->get_driver()->is_fulltext('topic_title', TOPICS_TABLE);
+-	}
+-
+-	public static function depends_on()
+-	{
+-		return ['\vse\similartopics\migrations\release_1_5_x\similar_topic_words'];
+-	}
+-
+-	public function update_data()
+-	{
+-		return [
+-			['if', [
+-				$this->db->get_sql_layer() === 'sqlite3',
+-				['custom', [[$this, 'create_sqlite3_index']]],
+-			]],
+-		];
+-	}
+-
+-	public function revert_data()
+-	{
+-		return [
+-			['if', [
+-				$this->db->get_sql_layer() === 'sqlite3',
+-				['custom', [[$this, 'drop_sqlite3_index']]],
+-			]],
+-		];
+-	}
+-
+-	/**
+-	 * Create a FULLTEXT index for the topic_title in the topic table
+-	 */
+-	public function create_sqlite3_index()
+-	{
+-		$this->get_driver()->create_fulltext_index('topic_title', TOPICS_TABLE);
+-	}
+-
+-	/**
+-	 * Drop the FULLTEXT index we created from the topic table
+-	 */
+-	public function drop_sqlite3_index()
+-	{
+-		$sql = 'DROP INDEX IF EXISTS idx_' . TOPICS_TABLE . '_topic_title';
+-		$this->db->sql_query($sql);
+-	}
+-
+-	/**
+-	 * @return sqlite3
+-	 */
+-	protected function get_driver()
+-	{
+-		if ($this->driver === null)
+-		{
+-			$this->driver = new sqlite3($this->db);
+-		}
+-		return $this->driver;
+-	}
+-}
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/styles/BBOOTS/template/event/ucp_prefs_view_radio_buttons_append.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/styles/BBOOTS/template/event/ucp_prefs_view_radio_buttons_append.html"
+new file mode 100644
+index 000000000..c9b59a2a3
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/styles/BBOOTS/template/event/ucp_prefs_view_radio_buttons_append.html"
+@@ -0,0 +1,9 @@
++{% if S_SIMILAR_TOPICS %}
++<div class="control-group">
++	<label class="control-label" for="similar_topics1">{{ lang('DISPLAY_SIMILAR_TOPICS') ~ lang('COLON') }}</label>
++	<div class="controls controls-row">
++	 <div class="radio"><input type="radio" name="similar_topics" id="similar_topics1" value="1"{% if S_DISPLAY_SIMILAR_TOPICS %} checked="checked"{% endif %} /><label for="similar_topics1">{{ lang('YES') }}</label></div>
++	 <div class="radio"><input type="radio" name="similar_topics" id="similar_topics0" value="0"{% if not S_DISPLAY_SIMILAR_TOPICS %} checked="checked"{% endif %} /><label for="similar_topics0">{{ lang('NO') }}</label></div>
++    </div>
++</div>
++{% endif %}
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/styles/BBOOTS/template/event/viewtopic_body_footer_before.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/styles/BBOOTS/template/event/viewtopic_body_footer_before.html"
+new file mode 100644
+index 000000000..b20812f33
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/styles/BBOOTS/template/event/viewtopic_body_footer_before.html"
+@@ -0,0 +1,69 @@
++{% if loops.similar|length %}
++<div class="panel panel-default">
++	<table class="footable table table-striped table-bordered table-white table-primary table-hover">
++	<thead>
++		<tr>
++			<th data-class="expand">{{ lang('SIMILAR_TOPICS') }}</th>
++			<th class="large110" data-hide="phone">{{ lang('TOPICS_POSTS_STATISTICS') }}</th>
++			<th class="large21" data-hide="phone">{{ lang('LAST_POST') }}</th>
++		</tr>
++	</thead>
++	 <tbody>
++	{% for similar in loops.similar %}
++		{% EVENT search_results_topic_before %}
++		<tr>
++			<td>
++				{% if similar.TOPIC_ICON_IMG %}
++				 <i class="topic-icon" style="background-image: url({{ T_ICONS_PATH ~ similar.TOPIC_ICON_IMG }}); background-repeat: no-repeat;" title="{{ similar.TOPIC_FOLDER_IMG_ALT }}"></i>
++				{% endif %}
++				<span class="icon-wrapper">
++			     <i class="row-icon-font icon-moon-default2{% if similar.S_POST_ANNOUNCE %} icon-moon-voice2{% endif %}{% if similar.S_POST_GLOBAL %} icon-moon-podcast2{% endif %}{% if similar.S_POST_STICKY %} icon-moon-pushpin2{% endif %}{% if similar.S_HAS_POLL %} icon-moon-poll{% endif %}{% if similar.S_UNREAD_TOPIC %} forum-unread{% else %} forum-read{% endif %}" title="{{ similar.TOPIC_FOLDER_IMG_ALT }}"></i>
++				</span>
++				<i class="row-icon-font-mini{% if similar.S_TOPIC_LOCKED %} fa fa-lock forumview-lock{% endif %}" title="{{ similar.TOPIC_FOLDER_IMG_ALT }}"></i>
++				<span class="desc-wrapper">
++				{% EVENT topiclist_row_prepend %}
++				{% if similar.S_UNREAD_TOPIC and not S_IS_BOT %}<a href="{{ similar.U_NEWEST_POST }}" title="{{ lang('VIEW_FIRST_UNREAD') }}"><i class="fa fa-asterisk"></i></a>{% endif %}{% EVENT topiclist_row_topic_title_before %}<a href="{{ similar.U_VIEW_TOPIC }}" class="topictitle">{{ similar.TOPIC_TITLE }}</a>
++				{% if similar.ATTACH_ICON_IMG %}<i class="fa fa-paperclip fa-flip-horizontal" title="{{ lang('ATTACH_FORUM') }}"></i>{% endif %}
++			    {% if similar.S_TOPIC_UNAPPROVED or similar.S_POSTS_UNAPPROVED %}<a href="{{ similar.U_MCP_QUEUE }}">{{ similar.UNAPPROVED_IMG }}</a> {% endif %}
++			    {% if similar.S_TOPIC_REPORTED %}<a href="{{ similar.U_MCP_REPORT }}">{{ REPORTED_IMG }}</a>{% endif %}<br />
++				{% EVENT topiclist_row_topic_title_after %}
++			    {% if similar.pagination|length %}
++				    <ul class="pagination pagination-forum pagination-xs pull-right hidden-sm hidden-xs">
++						{% for pagination in similar.pagination %}
++						 {% if pagination.S_IS_PREV %}
++						 {% elseif pagination.S_IS_CURRENT %}<li class="active">{{ pagination.PAGE_NUMBER }}</li>
++						 {% elseif pagination.S_IS_ELLIPSIS %}<li class="ellipsis"><a>{{ lang('ELLIPSIS') }}</a></li>
++						 {% elseif pagination.S_IS_NEXT %}
++						{% else %}
++						 <li><a href="{similar.pagination.PAGE_URL}">{{ pagination.PAGE_NUMBER }}</a></li>
++						{% endif %}
++						{% endfor %}
++					</ul>		
++			    {% endif %}
++				{% EVENT topiclist_row_topic_by_author_before %}
++				{{ lang('POST_BY_AUTHOR') }}&nbsp;{% EVENT search_results_topic_author_username_prepend %}{{ similar.TOPIC_AUTHOR_FULL }}{% EVENT search_results_topic_author_username_append %}&nbsp;
++				<small>&#45;&nbsp;<time datetime="{{ similar.FIRST_POST_TIME_RFC3339 }}">{{ similar.FIRST_POST_TIME }}</time></small>
++				{{ lang('IN') ~ lang('COLON') }}&nbsp;<a href="{{ similar.U_VIEW_FORUM }}">{{ similar.FORUM_TITLE }}</a>
++				{% EVENT topiclist_row_topic_by_author_after %}
++				{% EVENT topiclist_row_append %}
++				</span>
++			</td>
++			<td class="stats-col">
++			 <span class="stats-wrapper">
++			 {{ similar.TOPIC_REPLIES }}&nbsp;{{ lang('REPLIES') }}<br />{{ similar.TOPIC_VIEWS }}&nbsp;{{ lang('VIEWS') }}
++			 </span>
++			</td>
++			<td class="center">
++			 <span class="last-wrapper">
++				{{ lang('POST_BY_AUTHOR') }}&nbsp;{% EVENT search_results_last_post_author_username_prepend %}{{ similar.LAST_POST_AUTHOR_FULL }}{% EVENT search_results_last_post_author_username_append %}
++				{% if not S_IS_BOT %}<a title="{{ lang('FORUMLIST_LASTPOST') }}" href="{{ similar.U_LAST_POST }}"><i class="mobile-post fa fa-sign-out"></i></a>{% endif %}
++				<br /><small><time datetime="{{ similar.LAST_POST_TIME_RFC3339 }}">{{ similar.LAST_POST_TIME }}</time></small>
++			 </span>
++			</td>
++	    </tr>
++		{% EVENT search_results_topic_after %}
++	  {% endfor %}
++	 </tbody>
++	</table>
++</div>
++{% endif %}
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/styles/FLATBOOTS/template/event/ucp_prefs_view_radio_buttons_append.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/styles/FLATBOOTS/template/event/ucp_prefs_view_radio_buttons_append.html"
+new file mode 100644
+index 000000000..c9b59a2a3
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/styles/FLATBOOTS/template/event/ucp_prefs_view_radio_buttons_append.html"
+@@ -0,0 +1,9 @@
++{% if S_SIMILAR_TOPICS %}
++<div class="control-group">
++	<label class="control-label" for="similar_topics1">{{ lang('DISPLAY_SIMILAR_TOPICS') ~ lang('COLON') }}</label>
++	<div class="controls controls-row">
++	 <div class="radio"><input type="radio" name="similar_topics" id="similar_topics1" value="1"{% if S_DISPLAY_SIMILAR_TOPICS %} checked="checked"{% endif %} /><label for="similar_topics1">{{ lang('YES') }}</label></div>
++	 <div class="radio"><input type="radio" name="similar_topics" id="similar_topics0" value="0"{% if not S_DISPLAY_SIMILAR_TOPICS %} checked="checked"{% endif %} /><label for="similar_topics0">{{ lang('NO') }}</label></div>
++    </div>
++</div>
++{% endif %}
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/styles/FLATBOOTS/template/event/viewtopic_body_footer_before.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/styles/FLATBOOTS/template/event/viewtopic_body_footer_before.html"
+new file mode 100644
+index 000000000..e18f8526c
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/styles/FLATBOOTS/template/event/viewtopic_body_footer_before.html"
+@@ -0,0 +1,76 @@
++	{% if loops.similar|length %}
++	<div class="panel panel-forum">
++	<div class="panel-heading">
++	 {{ lang('SIMILAR_TOPICS') }}
++	</div>
++	<div class="panel-inner">
++	<table class="footable table table-striped table-primary table-hover">
++	<thead>
++		<tr>
++			<th data-class="expand">{{ lang('TOPICS') }}</th>
++			<th class="large110" data-hide="phone">{{ lang('TOPICS_POSTS_STATISTICS') }}</th>
++			<th class="large21" data-hide="phone">{{ lang('LAST_POST') }}</th>
++			{% EVENT search_results_topic_header_lastpost_after %}
++		</tr>
++	</thead>
++	<tbody>
++		{% for similar in loops.similar %}
++		{% EVENT search_results_topic_before %}
++		<tr>
++			<td>
++				{% if similar.TOPIC_ICON_IMG %}
++				<i class="topic-icon" style="background-image: url({% if not S_BBEMOJI %}{{ T_ICONS_PATH }}{% endif %}{{ similar.TOPIC_ICON_IMG }}); background-repeat: no-repeat;" title="{{ similar.TOPIC_FOLDER_IMG_ALT }}"></i>
++				{% endif %}
++				<span class="icon-wrapper">
++			    <i class="row-icon-font icon-moon-default2{% if similar.S_POST_ANNOUNCE %} icon-moon-voice2{% endif %}{% if similar.S_POST_GLOBAL %} icon-moon-podcast2{% endif %}{% if similar.S_POST_STICKY %} icon-moon-pushpin2{% endif %}{% if similar.S_HAS_POLL %} icon-moon-poll{% endif %}{% if similar.S_UNREAD_TOPIC %} forum-unread{% else %} forum-read{% endif %}" title="{{ similar.TOPIC_FOLDER_IMG_ALT }}"></i>
++				</span>
++				<i class="row-icon-font-mini{% if similar.S_TOPIC_LOCKED %} icon-moon-lock forumview-lock{% endif %}" title="{{ similar.TOPIC_FOLDER_IMG_ALT }}"></i>
++				<div class="desc-wrapper">
++				{% EVENT topiclist_row_prepend %}
++				{% if similar.S_UNREAD_TOPIC and not S_IS_BOT %}<a href="{{ similar.U_NEWEST_POST }}" title="{{ lang('VIEW_FIRST_UNREAD') }}"><i class="topic-newest fa fa-asterisk"></i></a>{% endif %}{% EVENT topiclist_row_topic_title_before %}<a href="{{ similar.U_VIEW_TOPIC }}" class="topictitle">{{ similar.TOPIC_TITLE }}</a>
++				{% if similar.S_TOPIC_UNAPPROVED or similar.S_POSTS_UNAPPROVED %}<a href="{{ similar.U_MCP_QUEUE }}" title="{{ lang('TOPICS_ROW_NOT_APPROVED') }}">&nbsp;<i class="fa fa-question-circle"></i></a>{% endif %}
++				{% if similar.S_TOPIC_REPORTED %}<a href="{{ similar.U_MCP_REPORT }}" title="{{ lang('TOPICS_ROW_REPORTED') }}">&nbsp;<i class="fa fa-exclamation-circle text-danger"></i></a>{% endif %}
++				{% if similar.pagination|length %}
++					<ul class="pagination pagination-forum pagination-xs pull-right hidden-sm hidden-xs">
++						{% for pagination in similar.pagination %}
++						 {% if pagination.S_IS_PREV %}
++						 {% elseif pagination.S_IS_CURRENT %}<li class="active">{{ pagination.PAGE_NUMBER }}</li>
++						 {% elseif pagination.S_IS_ELLIPSIS %}<li class="ellipsis"><a>{{ lang('ELLIPSIS') }}</a></li>
++						 {% elseif pagination.S_IS_NEXT %}
++						 {% else %}
++						 <li><a href="{{ pagination.PAGE_URL }}">{{ pagination.PAGE_NUMBER }}</a></li>
++						 {% endif %}
++						{% endfor %}
++					</ul>		
++				{% endif %}
++				{% EVENT topiclist_row_topic_title_after %}
++				<br />
++				{% if similar.ATTACH_ICON_IMG %}<i class="fa fa-paperclip fa-flip-horizontal" title="{{ lang('ATTACH_FORUM') }}"></i>{% endif %}
++				{% EVENT topiclist_row_topic_by_author_before %}
++				{{ lang('POST_BY_AUTHOR') }}&nbsp;{% EVENT search_results_topic_author_username_prepend %}{{ similar.TOPIC_AUTHOR_FULL }}{% EVENT search_results_topic_author_username_append %}&nbsp;
++				<small>&#45;&nbsp;<time datetime="{{ similar.FIRST_POST_TIME_RFC3339 }}">{{ similar.FIRST_POST_TIME }}</time>&nbsp;&nbsp;&#45;&nbsp;{{ lang('IN') ~ lang('COLON') }}&nbsp;<a href="{{ similar.U_VIEW_FORUM }}">{{ similar.FORUM_TITLE }}</a></small>
++				{% EVENT topiclist_row_topic_by_author_after %}
++				{% EVENT topiclist_row_append %}
++				</div>
++			</td>
++			<td class="stats-col">
++			 <span class="stats-wrapper">
++			 {{ similar.TOPIC_REPLIES }}&nbsp;{{ lang('REPLIES') }}&nbsp;<br />{{ similar.TOPIC_VIEWS }}&nbsp;{{ lang('VIEWS') }}
++			 </span>
++			</td>
++			<td> 
++			 <span class="last-wrapper text-overflow">
++				{{ lang('POST_BY_AUTHOR') }}&nbsp;{% EVENT search_results_last_post_author_username_prepend %}{{ similar.LAST_POST_AUTHOR_FULL }}{% EVENT search_results_last_post_author_username_append %}
++				{% if not S_IS_BOT %}<a title="{{ lang('FORUMLIST_LASTPOST') }}" href="{{ similar.U_LAST_POST }}"><i class="mobile-post fa fa-sign-out"></i></a>{% endif %}
++				<br /><small><time datetime="{{ similar.LAST_POST_TIME_RFC3339 }}">{{ similar.LAST_POST_TIME }}</time></small>
++			 </span>
++			</td>
++			{% EVENT search_results_topic_row_lastpost_after %}
++		</tr>
++		{% EVENT search_results_topic_after %}
++	{% endfor %}
++	</tbody>
++	</table>
++	</div>
++	</div>
++	{% endif %}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/styles/all/template/event/overall_footer_after.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/styles/all/template/event/overall_footer_after.html"
+deleted file mode 100644
+index 27399ab50..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/styles/all/template/event/overall_footer_after.html"
++++ /dev/null
+@@ -1,144 +0,0 @@
+-{% if S_DYNAMIC_SIMILAR_TOPICS and S_IN_POSTING and not S_EDIT_POST %}
+-{% INCLUDECSS '@vse_similartopics/similar_topics_ajax.css' %}
+-<script>
+-// Dynamic Similar Topics - Real-time search as user types in the subject field
+-(function() {
+-	// State variables: debounce timer, keyboard selection index, cached DOM elements
+-	let searchTimeout, selectedIndex = -1, cachedItems = [];
+-	const dropdown = document.getElementById('similar-topics-dropdown');
+-	const subjectField = document.getElementById('subject');
+-	const listContainer = document.getElementById('similar-topics-list');
+-
+-	if (!subjectField || !dropdown) return;
+-
+-	// Disable browser autocomplete to prevent interference with our dropdown
+-	subjectField.setAttribute('autocomplete', 'off');
+-
+-	// Hide dropdown and reset selection state
+-	function hideDropdown() {
+-		dropdown.style.display = 'none';
+-		selectedIndex = -1;
+-		cachedItems = [];
+-	}
+-
+-	// Position dropdown below the subject field and show it
+-	function showDropdown() {
+-		const rect = subjectField.getBoundingClientRect();
+-		const isRTL = document.documentElement.dir === 'rtl' || document.body.classList.contains('rtl');
+-		
+-		Object.assign(dropdown.style, {
+-			left: isRTL ? 'auto' : rect.left + 'px',
+-			right: 'auto',
+-			top: (rect.bottom + window.scrollY) + 'px',
+-			width: rect.width + 'px',
+-			display: 'block'
+-		});
+-	}
+-
+-	// AJAX search for similar topics (minimum 3 characters)
+-	function searchSimilarTopics(query) {
+-		if (query.length < 3) {
+-			hideDropdown();
+-			return;
+-		}
+-
+-		const xhr = new XMLHttpRequest();
+-		const baseUrl = '{{ U_PST_AJAX_SEARCH|e('js') }}';
+-		const separator = baseUrl.includes('?') ? '&' : '?';
+-		xhr.open('GET', baseUrl + separator + 'q=' + encodeURIComponent(query) + '&f={{ FORUM_ID|e('js') }}');
+-		xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
+-
+-		xhr.onreadystatechange = () => {
+-			if (xhr.readyState === 4 && xhr.status === 200) {
+-				try {
+-					const response = JSON.parse(xhr.responseText);
+-					displayResults(response.topics);
+-				} catch (e) {
+-					hideDropdown();
+-				}
+-			}
+-		};
+-
+-		xhr.send();
+-	}
+-
+-	// Build and display topic results in a dropdown
+-	function displayResults(topics) {
+-		if (!topics || topics.length === 0) return hideDropdown();
+-
+-		listContainer.innerHTML = '';
+-		topics.forEach(topic => {
+-			const item = document.createElement('div');
+-			item.className = 'similar-topic-item';
+-			const link = document.createElement('a');
+-			link.href = topic.url;
+-			link.className = 'similar-topic-title';
+-			link.textContent = topic.title;
+-			link.target = '_blank';
+-			item.appendChild(link);
+-			listContainer.appendChild(item);
+-		});
+-
+-		// Cache items for keyboard navigation performance
+-		cachedItems = listContainer.children;
+-		selectedIndex = -1;
+-		showDropdown();
+-	}
+-
+-	// Update visual selection highlighting for keyboard navigation
+-	function updateSelection() {
+-		for (let i = 0; i < cachedItems.length; i++) {
+-			cachedItems[i].classList.toggle('selected', i === selectedIndex);
+-		}
+-	}
+-
+-	// Open currently selected topic in new tab
+-	function openSelectedTopic() {
+-		if (selectedIndex >= 0 && selectedIndex < cachedItems.length) {
+-			window.open(cachedItems[selectedIndex].querySelector('a').href, '_blank');
+-			hideDropdown();
+-		}
+-	}
+-
+-	// Debounced search on input (300 ms delay)
+-	subjectField.addEventListener('input', () => {
+-		clearTimeout(searchTimeout);
+-		const query = subjectField.value.trim();
+-
+-		searchTimeout = setTimeout(() => {
+-			searchSimilarTopics(query);
+-		}, 300);
+-	});
+-
+-	// Keyboard navigation: Arrow keys to select, Enter to open
+-	subjectField.addEventListener('keydown', (e) => {
+-		if (dropdown.style.display === 'none' || !cachedItems.length) return;
+-
+-		const { key, shiftKey, ctrlKey, altKey, metaKey } = e;
+-		if ((key === 'ArrowDown' || key === 'ArrowUp') && !shiftKey && !ctrlKey && !altKey && !metaKey) {
+-			e.preventDefault();
+-			// Cycle through items (wraps around at ends)
+-			selectedIndex = key === 'ArrowDown'
+-				? (selectedIndex < cachedItems.length - 1 ? selectedIndex + 1 : 0)
+-				: (selectedIndex > 0 ? selectedIndex - 1 : cachedItems.length - 1);
+-			updateSelection();
+-		} else if (key === 'Enter' && selectedIndex >= 0) {
+-			e.preventDefault();
+-			openSelectedTopic();
+-		}
+-	});
+-
+-	// Hide dropdown when the field loses focus (delayed to allow clicks)
+-	subjectField.addEventListener('blur', () => {
+-		setTimeout(hideDropdown, 200);
+-	});
+-
+-	// Hide dropdown when clicking outside
+-	document.addEventListener('click', (e) => {
+-		if (!dropdown.contains(e.target) && e.target !== subjectField) {
+-			hideDropdown();
+-		}
+-	});
+-})();
+-</script>
+-{% endif %}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/styles/all/template/event/posting_editor_subject_append.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/styles/all/template/event/posting_editor_subject_append.html"
+deleted file mode 100644
+index 018f16d8b..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/styles/all/template/event/posting_editor_subject_append.html"
++++ /dev/null
+@@ -1,6 +0,0 @@
+-{% if S_DYNAMIC_SIMILAR_TOPICS and S_IN_POSTING and not S_EDIT_POST %}
+-<div id="similar-topics-dropdown" class="similar-topics-dropdown" style="display: none;">
+-	<div class="similar-topics-header">{{ lang('SIMILAR_TOPICS') }}</div>
+-	<div id="similar-topics-list" class="similar-topics-list"></div>
+-</div>
+-{% endif %}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/styles/all/theme/similar_topics_ajax.css" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/styles/all/theme/similar_topics_ajax.css"
+deleted file mode 100644
+index 453119728..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/styles/all/theme/similar_topics_ajax.css"
++++ /dev/null
+@@ -1,51 +0,0 @@
+-.similar-topics-dropdown {
+-	background: #ffffff;
+-	border: 1px solid #cccccc;
+-	border-radius: 3px;
+-	box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
+-	position: absolute;
+-	z-index: 1000;
+-	min-width: 300px;
+-	max-width: 400px;
+-}
+-
+-.similar-topics-header {
+-	font-size: 11px;
+-	font-weight: bold;
+-	text-transform: uppercase;
+-	background: #f5f5f5;
+-	border-bottom: 1px solid #dddddd;
+-	padding: 8px 12px;
+-}
+-
+-.similar-topics-list {
+-	overflow-y: auto;
+-	max-height: 200px;
+-}
+-
+-.similar-topic-item {
+-	border-bottom: 1px solid #eeeeee;
+-	padding: 8px 12px;
+-	cursor: pointer;
+-	transition: background-color 0.2s;
+-}
+-
+-.similar-topic-item:hover,
+-.similar-topic-item.selected {
+-	background: #f0f0f0;
+-}
+-
+-.similar-topic-item:last-child {
+-	border-bottom: none;
+-}
+-
+-.similar-topic-title {
+-	font-size: 12px;
+-	line-height: 1.3;
+-	text-decoration: none;
+-	color: #105289;
+-}
+-
+-.similar-topic-title:hover {
+-	text-decoration: underline;
+-}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/styles/bb3-mobi/template/event/viewtopic_body_footer_before.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/styles/bb3-mobi/template/event/viewtopic_body_footer_before.html"
+index 2b32e57f5..779cd71d8 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/styles/bb3-mobi/template/event/viewtopic_body_footer_before.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/styles/bb3-mobi/template/event/viewtopic_body_footer_before.html"
+@@ -14,7 +14,7 @@
+ 	<a href="{{ similar.U_MCP_QUEUE }}" class="rightside"><img src="{{ T_THEME_PATH }}/images/icon_topic_unapproved.gif" alt=""/></a>{% endif %}
+ 	{% if similar.S_TOPIC_REPORTED %}
+ 	<a href="{{ similar.U_MCP_REPORT }}" class="rightside"><img src="{{ T_THEME_PATH }}/images/icon_topic_reported.gif" alt=""/></a>{% endif %}
+-	<a href="{{ similar.U_VIEW_TOPIC }}" class="topictitle">{{ similar.TOPIC_TITLE }}</a> <span class="posts">[{% if similar.TOPIC_REPLIES %}{{ similar.TOPIC_REPLIES }}{% else %}1{% endif %}]</span>
++	<a href="{{ similar.U_VIEW_TOPIC }}" class="topictitle">{{ similar.TOPIC_TITLE }}</a> <span class="posts">[{% if similar.REPLIES %}{{ similar.REPLIES }}{% else %}1{% endif %}]</span>
+ 	{% if not S_IS_BOT %}
+ 	<br />{{ similar.LAST_POST_AUTHOR_FULL }} &laquo; <a href="{{ similar.U_LAST_POST }}" title="{{ lang('GOTO_LAST_POST') }}">{{ similar.LAST_POST_TIME }}</a>
+ 	{% endif %}
+@@ -25,7 +25,7 @@
+ 			{% elseif pagination.S_IS_CURRENT %}<span class="active button">{{ pagination.PAGE_NUMBER }}</span>
+ 			{% elseif pagination.S_IS_ELLIPSIS %}<span class="ellipsis button">{{ lang('ELLIPSIS') }}</span>
+ 			{% elseif pagination.S_IS_NEXT %}
+-			{% else %}<a href="{{ pagination.PAGE_URL }}" class="button">{{ pagination.PAGE_NUMBER }}</a>
++			{% else %}<a href="{{ pagination.PAGE_URL }}" class="button">{{ pagination.PAGE_NUMBER }}</a> 
+ 			{% endif %}
+ 		{% endfor %}
+ 	</div>
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/styles/prosilver/template/event/ucp_prefs_view_radio_buttons_append.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/styles/prosilver/template/event/ucp_prefs_view_radio_buttons_append.html"
+index 4267781ab..4b0075748 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/styles/prosilver/template/event/ucp_prefs_view_radio_buttons_append.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/styles/prosilver/template/event/ucp_prefs_view_radio_buttons_append.html"
+@@ -2,8 +2,8 @@
+ 	<dl>
+ 		<dt><label for="similar_topics1">{{ lang('DISPLAY_SIMILAR_TOPICS') ~ lang('COLON') }}</label></dt>
+ 		<dd>
+-			<label for="similar_topics1"><input type="radio" name="similar_topics" id="similar_topics1" value="1"{% if S_DISPLAY_SIMILAR_TOPICS %} checked="checked"{% endif %}> {{ lang('YES') }}</label>
+-			<label for="similar_topics0"><input type="radio" name="similar_topics" id="similar_topics0" value="0"{% if not S_DISPLAY_SIMILAR_TOPICS %} checked="checked"{% endif %}> {{ lang('NO') }}</label>
++			<label for="similar_topics1"><input type="radio" name="similar_topics" id="similar_topics1" value="1"{% if S_DISPLAY_SIMILAR_TOPICS %} checked="checked"{% endif %} /> {{ lang('YES') }}</label>
++			<label for="similar_topics0"><input type="radio" name="similar_topics" id="similar_topics0" value="0"{% if not S_DISPLAY_SIMILAR_TOPICS %} checked="checked"{% endif %} /> {{ lang('NO') }}</label>
+ 		</dd>
+ 	</dl>
+ {% endif %}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/styles/prosilver/template/event/viewtopic_body_footer_before.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/styles/prosilver/template/event/viewtopic_body_footer_before.html"
+index 334f8fdfc..5dcf13ce1 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/styles/prosilver/template/event/viewtopic_body_footer_before.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/styles/prosilver/template/event/viewtopic_body_footer_before.html"
+@@ -40,13 +40,13 @@
+ 											<i class="icon fa-exclamation fa-fw icon-red" aria-hidden="true"></i><span class="sr-only">{{ lang('TOPIC_REPORTED') }}</span>
+ 										</a>
+ 									{% endif %}
+-									<br>
++									<br />
+ 									{% EVENT topiclist_row_topic_title_after %}
+ 
+ 									{% if not S_IS_BOT %}
+ 										<div class="responsive-show" style="display: none;">
+ 											{{ lang('LAST_POST') }} {{ lang('POST_BY_AUTHOR') }} {% EVENT search_results_last_post_author_username_prepend %}{{ similar.LAST_POST_AUTHOR_FULL }}{% EVENT search_results_last_post_author_username_append %} &laquo; <a href="{{ similar.U_LAST_POST }}" title="{{ lang('GOTO_LAST_POST') }}"><time datetime="{{ similar.LAST_POST_TIME_RFC3339 }}">{{ similar.LAST_POST_TIME }}</time></a>
+-											<br>{{ lang('POSTED') }} {{ lang('IN') }} <a href="{{ similar.U_VIEW_FORUM }}">{{ similar.FORUM_TITLE }}</a>
++											<br />{{ lang('POSTED') }} {{ lang('IN') }} <a href="{{ similar.U_VIEW_FORUM }}">{{ similar.FORUM_TITLE }}</a>
+ 										</div>
+ 										{% if similar.TOPIC_REPLIES %}<span class="responsive-show left-box" style="display: none;">{{ lang('REPLIES') ~ lang('COLON') }} <strong>{{ similar.TOPIC_REPLIES }}</strong></span>{% endif %}
+ 									{% endif %}
+@@ -87,7 +87,7 @@
+ 											<i class="icon fa-external-link-square fa-fw icon-lightgray icon-md" aria-hidden="true"></i><span class="sr-only">{{ VIEW_LATEST_POST }}</span>
+ 										</a>
+ 									{% endif %}
+-									<br><time datetime="{{ similar.LAST_POST_TIME_RFC3339 }}">{{ similar.LAST_POST_TIME }}</time>
++									<br /><time datetime="{{ similar.LAST_POST_TIME_RFC3339 }}">{{ similar.LAST_POST_TIME }}</time>
+ 								</span>
+ 							</dd>
+ 							{% EVENT search_results_topic_row_lastpost_after %}
diff --git "[FORUM_EXT]/vse\\similartopics/diff_nospace.tmp" "[FORUM_EXT]/vse\\similartopics/diff_nospace.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/vse\\similartopics/diff_nospace.tmp"
@@ -0,0 +1,6845 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/CHANGELOG.md" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/CHANGELOG.md"
+index dcfad82c4..378efc1d0 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/CHANGELOG.md"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/CHANGELOG.md"
+@@ -1,18 +1,10 @@
+ ## Changelog
+ 
+-### 1.7.0 - 2025-12-16
+-
+-- NEW FEATURE: Dynamically show similar topics to users as they title their new posts.
+-- IMPROVEMENT: Support for MSSQL, SQLite3 and Oracle databases added.
+-- IMPROVEMENT: Added stop-word filtering for Postgres databases using the 'simple' dictionary.
+-- Added missing stop-word filters (AI-translated) for Hebrew, Persian, Japanese, Swedish and Turkish languages.
+-- Fixed and optimized lots of code when processing similar topics.
+-
+ ### 1.6.0 - 2022-12-17
+ 
+ - Removed support for phpBB 3.1.x.
+ - Removed forum "f=" parameters from URLs.
+-- Optimized JavaScript and other coding updates.
++- Optimized Javascript and other coding updates.
+ - Support added for ScaffoldBB style.
+ 
+ ### 1.5.4 - 2020-12-01
+@@ -20,11 +12,11 @@
+ - Fix for Postgresql databases where titles with single quotes would fatally error.
+ - Enabled AJAX interactions when saving settings in the ACP.
+ - Re-wrote the search period explanation in the ACP settings.
+-- Switched to using the phpBB finder to locate foreign language ignore words files.
++- Switched to using phpBB finder to locate foreign language ignore words files.
+ 
+ ### 1.5.3 - 2020-01-10
+ 
+-- Compatibility issues with Prosilver styles are addressed.
++- Compatibility issues with Prosilver styles addressed.
+ - Installation errors on phpBB 3.3.x will be reported to the user.
+ 
+ ### 1.5.2 - 2019-06-26
+@@ -35,18 +27,18 @@
+ 
+ ### 1.5.1 - 2018-06-01
+ 
+-- Fixed an issue where PHP using European decimal notation (comma instead of a period) could cause an SQL error.
+-- Minor code fixes based on the phpBB Extension team validation report.
++- Fixed an issue where PHP using European decimal notation (comma instead of period) could cause an SQL error.
++- Minor code fixes based on phpBB Extension team validation report.
+ 
+ ### 1.5.0 - 2018-03-14
+ 
+ - Added support for forums using PostgreSQL databases (with thanks to hubaishan).
+ - Fixed a layout bug with the pagination buttons introduced in phpBB 3.2.2.
+-- Fixed a potential SQL error bug when installing.
++- Fixed potential SQL error bug when installing.
+ 
+ ### 1.4.3 - 2018-01-03
+ 
+-- Added a new setting: Search Sensitivity. Allows users to adjust the weighting of similar topics matches. This was added because InnoDB, which is now supported, weights results differently than MyISAM. This will allow users with InnoDB tables to improve their similar topics results by lowering the weighting/sensitivity.
++- Added a new setting: Search Sensitivity. Allows users to adjust the weighting of similar topics matches. This was added because InnoDB which is now supported, weights results differently than MyISAM. This will allow users with InnoDB tables to improve their similar topics results by lowering the weighting/sensitivity.
+ - Converted all template syntax to Twig format.
+ 
+ ### 1.4.2 - 2017-03-18
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/acp/controller/similar_topics_admin.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/acp/controller/similar_topics_admin.php"
+index 85c505289..4e2b5441e 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/acp/controller/similar_topics_admin.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/acp/controller/similar_topics_admin.php"
+@@ -157,7 +157,6 @@ class similar_topics_admin
+ 
+ 			// Set basic config settings
+ 			$this->config->set('similar_topics', $this->request->variable('pst_enable', 0));
+-			$this->config->set('similar_topics_dynamic', $this->request->variable('pst_dynamic', 0));
+ 			$this->config->set('similar_topics_limit', abs($this->request->variable('pst_limit', 0))); // use abs for positive values only
+ 			$this->config->set('similar_topics_cache', abs($this->request->variable('pst_cache', 0))); // use abs for positive values only
+ 			$this->config_text_set('similar_topics_words', $this->request->variable('pst_words', '', true));
+@@ -209,22 +208,20 @@ class similar_topics_admin
+ 
+ 		$this->template->assign_vars(array(
+ 			'S_PST_ENABLE'    => $this->isset_or_default($this->config['similar_topics'], false),
+-			'S_PST_DYNAMIC'   => $this->isset_or_default($this->config['similar_topics_dynamic'], false),
+ 			'PST_LIMIT'       => $this->isset_or_default($this->config['similar_topics_limit'], ''),
+ 			'PST_CACHE'       => $this->isset_or_default($this->config['similar_topics_cache'], ''),
+ 			'PST_SENSE'       => $this->isset_or_default($this->config['similar_topics_sense'], ''),
+ 			'PST_WORDS'       => $this->isset_or_default($this->config_text_get('similar_topics_words'), ''),
+ 			'PST_TIME'        => $this->get_pst_time($this->config['similar_topics_time'], $this->config['similar_topics_type']),
+-			'PST_SENSITIVITY' => $this->similartopics && $this->similartopics->get_engine() === 'innodb' ? 1 : 5,
+ 			'S_PST_NO_COMPAT' => $this->similartopics === null || !$this->similartopics->is_fulltext('topic_title'),
+ 			'U_ACTION'        => $this->u_action,
+ 		));
+ 
+ 		// If postgresql, we need to make an options list of text search names
+-		if ($this->similartopics instanceof \vse\similartopics\driver\postgres)
++		if ($this->similartopics && $this->similartopics->get_type() === 'postgres')
+ 		{
+ 			$this->language->add_lang('acp/search');
+-			foreach ($this->similartopics->get_cfg_name_list() as $row)
++			foreach ($this->get_cfgname_list() as $row)
+ 			{
+ 				$this->template->assign_block_vars('postgres_ts_names', array(
+ 					'NAME'       => $row['ts_name'],
+@@ -269,8 +266,6 @@ class similar_topics_admin
+ 				WHERE forum_id = $forum_id";
+ 			$this->db->sql_query($sql);
+ 
+-			$this->cache->destroy('sql', FORUMS_TABLE);
+-
+ 			$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'PST_LOG_MSG');
+ 
+ 			$this->end('PST_SAVED');
+@@ -315,6 +310,22 @@ class similar_topics_admin
+ 		}
+ 	}
+ 
++	/**
++	 * Get list of PostgreSQL text search names
++	 *
++	 * @access protected
++	 * @return array array of text search names
++	 */
++	protected function get_cfgname_list()
++	{
++		$sql = 'SELECT cfgname AS ts_name FROM pg_ts_config';
++		$result = $this->db->sql_query($sql);
++		$ts_options = $this->db->sql_fetchrowset($result);
++		$this->db->sql_freeresult($result);
++
++		return $ts_options;
++	}
++
+ 	/**
+ 	 * Get forums list
+ 	 *
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/acp/similar_topics_module.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/acp/similar_topics_module.php"
+index 8e9408fa8..e0a74e17d 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/acp/similar_topics_module.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/acp/similar_topics_module.php"
+@@ -32,7 +32,9 @@ class similar_topics_module
+ 		global $phpbb_container;
+ 
+ 		$this->tpl_name = 'acp_similar_topics';
+-		$this->page_title = 'PST_TITLE_ACP';
++
++		$this->page_title = $phpbb_container->get('language')
++			->lang('PST_TITLE_ACP');
+ 
+ 		$phpbb_container->get('vse.similartopics.acp.controller')
+ 			->set_u_action($this->u_action)
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/adm/style/acp_similar_topics.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/adm/style/acp_similar_topics.html"
+index 8f0c529db..0be73ff9f 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/adm/style/acp_similar_topics.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/adm/style/acp_similar_topics.html"
+@@ -20,13 +20,13 @@
+ 	<fieldset>
+ 		<legend>{{ lang('PST_ADVANCED_FORUM') }}</legend>
+ 		<dl>
+-			<dt><label for="similar_forums">{{ lang('FORUM') ~ lang('COLON') }} {{ PST_FORUM_NAME }}</label><br><br><span>{{ lang('PST_ADVANCED_EXP', PST_FORUM_NAME) }}</span></dt>
++			<dt><label for="similar_forums">{{ lang('FORUM') ~ lang('COLON') }} {{ PST_FORUM_NAME }}</label><br /><br /><span>{{ lang('PST_ADVANCED_EXP', PST_FORUM_NAME) }}</span></dt>
+ 			<dd><select id="similar_forums" name="similar_forums_id[]" multiple="multiple" size="10">{{ SIMILAR_FORUMS_OPTIONS }}</select></dd>
+ 			<dd><a href="#" data-selector="false">{{ lang('PST_DESELECT_ALL') }}</a></dd>
+ 		</dl>
+ 		<p class="submit-buttons">
+-			<input class="button1" type="submit" id="submit" name="submit" value="{{ lang('SUBMIT') }}">&nbsp;
+-			<input class="button2" type="reset" id="reset" name="reset" value="{{ lang('RESET') }}">
++			<input class="button1" type="submit" id="submit" name="submit" value="{{ lang('SUBMIT') }}" />&nbsp;
++			<input class="button2" type="reset" id="reset" name="reset" value="{{ lang('RESET') }}" />
+ 		</p>
+ 		{{ S_FORM_TOKEN }}
+ 	</fieldset>
+@@ -47,17 +47,10 @@
+ 	<fieldset>
+ 		<legend>{{ lang('PST_LEGEND1') }}</legend>
+ 		<dl>
+-			<dt><label for="pst_enable">{{ lang('PST_ENABLE') ~ lang('COLON') }}</label><br><span>{{ lang('PST_ENABLE_EXPLAIN') }}</span></dt>
++			<dt><label for="pst_enable">{{ lang('PST_ENABLE') ~ lang('COLON') }}</label></dt>
+ 			<dd>
+-				<label><input type="radio" class="radio" id="pst_enable" name="pst_enable" value="1"{% if S_PST_ENABLE %} checked="checked"{% endif %}{% if S_PST_NO_SUPPORT %} disabled="disabled"{% endif %}> {{ lang('YES') }}</label>
+-				<label><input type="radio" class="radio" name="pst_enable" value="0"{% if not S_PST_ENABLE %} checked="checked"{% endif %}> {{ lang('NO') }}</label>
+-			</dd>
+-		</dl>
+-		<dl>
+-			<dt><label for="pst_dynamic">{{ lang('PST_DYNAMIC') ~ lang('COLON') }}</label><br><span>{{ lang('PST_DYNAMIC_EXPLAIN') }}</span></dt>
+-			<dd>
+-				<label><input type="radio" class="radio" id="pst_dynamic" name="pst_dynamic" value="1"{% if S_PST_DYNAMIC %} checked="checked"{% endif %}> {{ lang('YES') }}</label>
+-				<label><input type="radio" class="radio" name="pst_dynamic" value="0"{% if not S_PST_DYNAMIC %} checked="checked"{% endif %}> {{ lang('NO') }}</label>
++				<label><input type="radio" class="radio" id="pst_enable" name="pst_enable" value="1"{% if S_PST_ENABLE %} checked="checked"{% endif %}{% if S_PST_NO_SUPPORT %} disabled="disabled"{% endif %} /> {{ lang('YES') }}</label>
++				<label><input type="radio" class="radio" name="pst_enable" value="0"{% if not S_PST_ENABLE %} checked="checked"{% endif %} /> {{ lang('NO') }}</label>
+ 			</dd>
+ 		</dl>
+ 	</fieldset>
+@@ -65,12 +58,12 @@
+ 	<fieldset>
+ 		<legend>{{ lang('PST_LEGEND2') }}</legend>
+ 		<dl>
+-			<dt><label for="pst_limit">{{ lang('PST_LIMIT') ~ lang('COLON') }}</label><br><span>{{ lang('PST_LIMIT_EXPLAIN') }}</span></dt>
+-			<dd><input name="pst_limit" id="pst_limit" type="number" min="0" max="999" value="{{ PST_LIMIT }}"></dd>
++			<dt><label for="pst_limit">{{ lang('PST_LIMIT') ~ lang('COLON') }}</label><br /><span>{{ lang('PST_LIMIT_EXPLAIN') }}</span></dt>
++			<dd><input name="pst_limit" id="pst_limit" type="number" min="0" max="999" value="{{ PST_LIMIT }}" /></dd>
+ 		</dl>
+ 		<dl>
+-			<dt><label for="pst_time">{{ lang('PST_TIME') ~ lang('COLON') }}</label><br><span>{{ lang('PST_TIME_EXPLAIN') }}</span></dt>
+-			<dd><input name="pst_time" id="pst_time" type="number" min="0" max="999" value="{{ PST_TIME }}">
++			<dt><label for="pst_time">{{ lang('PST_TIME') ~ lang('COLON') }}</label><br /><span>{{ lang('PST_TIME_EXPLAIN') }}</span></dt>
++			<dd><input name="pst_time" id="pst_time" type="number" min="0" max="999" value="{{ PST_TIME }}" />
+ 				<label>
+ 					<select name="pst_time_type">
+ 						{% for similar_time_options in loops.similar_time_options %}
+@@ -81,12 +74,12 @@
+ 			</dd>
+ 		</dl>
+ 		<dl>
+-			<dt><label for="pst_cache">{{ lang('PST_CACHE') ~ lang('COLON') }}</label><br><span>{{ lang('PST_CACHE_EXPLAIN') }}</span></dt>
+-			<dd><input name="pst_cache" id="pst_cache" type="number" min="0" max="99999999" value="{{ PST_CACHE }}"> {{ lang('SECONDS') }}</dd>
++			<dt><label for="pst_cache">{{ lang('PST_CACHE') ~ lang('COLON') }}</label><br /><span>{{ lang('PST_CACHE_EXPLAIN') }}</span></dt>
++			<dd><input name="pst_cache" id="pst_cache" type="number" min="0" max="99999999" value="{{ PST_CACHE }}" /> {{ lang('SECONDS') }}</dd>
+ 		</dl>
+ 		<dl>
+-			<dt><label for="pst_sense">{{ lang('PST_SENSE') ~ lang('COLON') }}</label><br><span>{{ lang('PST_SENSE_EXPLAIN', PST_SENSITIVITY) }}</span></dt>
+-			<dd><input name="pst_sense" id="pst_sense" type="number" min="1" max="10" value="{{ PST_SENSE }}"></dd>
++			<dt><label for="pst_sense">{{ lang('PST_SENSE') ~ lang('COLON') }}</label><br /><span>{{ lang('PST_SENSE_EXPLAIN') }}</span></dt>
++			<dd><input name="pst_sense" id="pst_sense" type="number" min="1" max="10" value="{{ PST_SENSE }}" /></dd>
+ 		</dl>
+ 	</fieldset>
+ 
+@@ -96,7 +89,7 @@
+ 			<span class="small">{{ lang('PST_FORUM_INFO') }}</span>
+ 			<div style="overflow: auto; max-height: 300px;">
+ 				<table class="table1">
+-					<colgroup><col class="row1"><col class="row2"><col class="row1"><col class="row2"></colgroup>
++					<colgroup><col class="row1" /><col class="row2" /><col class="row1" /><col class="row2" /></colgroup>
+ 					<thead>
+ 						<tr>
+ 							<th>{{ lang('FORUMS') }}</th>
+@@ -111,18 +104,18 @@
+ 							<td>
+ 								<strong><a href="{{ forums.U_FORUM }}">{{ forums.FORUM_NAME }}</a></strong>
+ 							</td>
+-							<td style="text-align: center; width: 20%;" title="{{ lang('PST_NOSHOW_TITLE')|e('html_attr') }} {{ forums.FORUM_NAME|e('html_attr') }}">
++							<td style="text-align: center; width: 20%;" title="{{ lang('PST_NOSHOW_TITLE') }} {{ forums.FORUM_NAME }}">
+ 								<label>
+-									<input type="checkbox" class="radio" name="mark_noshow_forum[]" value="{{ forums.FORUM_ID }}" {{ forums.CHECKED_NOSHOW_FORUM }}>
++									<input type="checkbox" class="radio" name="mark_noshow_forum[]" value="{{ forums.FORUM_ID }}" {{ forums.CHECKED_NOSHOW_FORUM }} />
+ 								</label>
+ 							</td>
+-							<td style="text-align: center; width: 20%;" title="{{ lang('PST_IGNORE_TITLE')|e('html_attr') }} {{ forums.FORUM_NAME|e('html_attr') }}">
++							<td style="text-align: center; width: 20%;" title="{{ lang('PST_IGNORE_TITLE') }} {{ forums.FORUM_NAME }}">
+ 								<label>
+-									<input type="checkbox" class="radio" name="mark_ignore_forum[]" value="{{ forums.FORUM_ID }}" {{ forums.CHECKED_IGNORE_FORUM }}>
++									<input type="checkbox" class="radio" name="mark_ignore_forum[]" value="{{ forums.FORUM_ID }}" {{ forums.CHECKED_IGNORE_FORUM }} />
+ 								</label>
+ 							</td>
+-							<td style="text-align: center; width: 20%;" title="{{ lang('PST_ADVANCED_TITLE')|e('html_attr') }} {{ forums.FORUM_NAME|e('html_attr') }}">
+-							<a href="{{ forums.U_ADVANCED }}">{% if forums.S_IS_ADVANCED %}<strong>{{ lang('PST_ADVANCED') }}</strong>{% else %}{{ lang('PST_STANDARD') }}{% endif %}</a>
++							<td style="text-align: center; width: 20%;" title="{{ lang('PST_ADVANCED_TITLE') }} {{ forums.FORUM_NAME }}">
++							<a href="{{ forums.U_ADVANCED }}">{% if forums.S_IS_ADVANCED %}<strong>{{ lang('PST_ADVANCED') }}</strong>{% else %}{{ lang('PST_STANDARD') }}</a>{% endif %}
+ 							</td>
+ 						</tr>
+ 						{% endfor %}
+@@ -135,12 +128,12 @@
+ 	<fieldset>
+ 		<legend>{{ lang('PST_LEGEND4') }}</legend>
+ 		<dl>
+-			<dt><label for="pst_words">{{ lang('PST_WORDS') ~ lang('COLON') }}</label><br><span>{{ lang('PST_WORDS_EXPLAIN') }}</span></dt>
++			<dt><label for="pst_words">{{ lang('PST_WORDS') ~ lang('COLON') }}</label><br /><span>{{ lang('PST_WORDS_EXPLAIN') }}</span></dt>
+ 			<dd><textarea name="pst_words" id="pst_words" rows="5" cols="40">{{ PST_WORDS }}</textarea></dd>
+ 		</dl>
+ 		{% if loops.postgres_ts_names %}
+ 			<dl>
+-				<dt><label for="pst_postgres_ts_name">{{ lang('FULLTEXT_POSTGRES_TS_NAME') }}</label><br><span>{{ lang('FULLTEXT_POSTGRES_TS_NAME_EXPLAIN') }}</span></dt>
++				<dt><label for="pst_postgres_ts_name">{{ lang('FULLTEXT_POSTGRES_TS_NAME') }}</label><br /><span>{{ lang('FULLTEXT_POSTGRES_TS_NAME_EXPLAIN') }}</span></dt>
+ 				<dd>
+ 					<select name="pst_postgres_ts_name" id="pst_postgres_ts_name">
+ 						{% for ts_name in loops.postgres_ts_names %}
+@@ -155,8 +148,8 @@
+ 	<fieldset>
+ 		<legend>{{ lang('ACP_SUBMIT_CHANGES') }}</legend>
+ 		<p class="submit-buttons">
+-			<input class="button1" type="submit" id="submit" name="submit" value="{{ lang('SUBMIT') }}">&nbsp;
+-			<input class="button2" type="reset" id="reset" name="reset" value="{{ lang('RESET') }}">
++			<input class="button1" type="submit" id="submit" name="submit" value="{{ lang('SUBMIT') }}" />&nbsp;
++			<input class="button2" type="reset" id="reset" name="reset" value="{{ lang('RESET') }}" />
+ 		</p>
+ 		{{ S_FORM_TOKEN }}
+ 	</fieldset>
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/composer.json"
+index 19c72b2a6..c5613f687 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/composer.json"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/composer.json"
+@@ -3,7 +3,7 @@
+     "type": "phpbb-extension",
+     "description": "A phpBB extension that displays a list of similar (related) topics at the bottom of the current topic's page.",
+     "homepage": "https://github.com/iMattPro/similartopics",
+-    "version": "1.7.0",
++    "version": "1.6.0",
+     "keywords": [
+         "phpbb",
+         "extension",
+@@ -20,7 +20,7 @@
+     ],
+     "require": {
+         "php": ">=5.4",
+-        "composer/installers": "~1.0",
++        "composer/installers": "~1.0.0",
+         "phpbb/phpbb": ">=3.2.1"
+     },
+     "extra": {
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/config/routing.yml" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/config/routing.yml"
+deleted file mode 100644
+index 3a3d08730..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/config/routing.yml"
++++ /dev/null
+@@ -1,6 +0,0 @@
+-vse_similartopics_ajax_search:
+-    path: /similartopics/ajax/search
+-    defaults: { _controller: vse.similartopics.ajax.controller:search_similar_topics }
+-    methods: [GET]
+-    requirements:
+-        _format: json
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/config/services.yml" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/config/services.yml"
+index 9acfe7b01..8d651ffcd 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/config/services.yml"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/config/services.yml"
+@@ -8,13 +8,13 @@ services:
+             - '@config_text'
+             - '@dbal.conn'
+             - '@dispatcher'
++            - '@ext.manager'
+             - '@language'
+             - '@pagination'
+             - '@request'
+             - '@template'
+             - '@user'
+             - '@content.visibility'
+-            - '@vse.similartopics.stop_word_helper'
+             - '@vse.similartopics.driver.manager'
+             - '%core.root_path%'
+             - '%core.php_ext%'
+@@ -23,8 +23,6 @@ services:
+         class: vse\similartopics\event\listener
+         arguments:
+             - '@vse.similartopics.manager'
+-            - '@controller.helper'
+-            - '@template'
+         tags:
+             - { name: event.listener }
+ 
+@@ -61,28 +59,13 @@ services:
+             - '%core.root_path%'
+             - '%core.php_ext%'
+ 
+-    vse.similartopics.stop_word_helper:
+-        class: vse\similartopics\core\stop_word_helper
+-        public: false
+-        arguments:
+-            - '@cache.driver'
+-            - '@ext.manager'
+-            - '@user'
+-            - '%core.php_ext%'
+-
+-    vse.similartopics.ajax.controller:
+-        class: vse\similartopics\controller\ajax_controller
+-        arguments:
+-            - '@request'
+-            - '@vse.similartopics.manager'
+-
+ # ----- Similar topics DB drivers collection -----
+     vse.similartopics.driver_collection:
+         class: phpbb\di\service_collection
+         arguments:
+             - '@service_container'
+         tags:
+-            - { name: service_collection, tag: vse.similartopics.driver }
++            - { name: service_collection, tag: vse.similartopcs.driver }
+ 
+     vse.similartopics.driver.postgres:
+         class: vse\similartopics\driver\postgres
+@@ -90,50 +73,17 @@ services:
+             - '@dbal.conn'
+             - '@config'
+         tags:
+-            - { name: vse.similartopics.driver }
++            - { name: vse.similartopcs.driver }
+ 
+     vse.similartopics.driver.mysqli:
+         class: vse\similartopics\driver\mysqli
+         arguments:
+             - '@dbal.conn'
+         tags:
+-            - { name: vse.similartopics.driver }
++            - { name: vse.similartopcs.driver }
+ 
+     vse.similartopics.driver.mysql4:
+         class: vse\similartopics\driver\mysql4
+         parent: vse.similartopics.driver.mysqli
+         tags:
+-            - { name: vse.similartopics.driver }
+-
+-    vse.similartopics.driver.sqlite3:
+-        class: vse\similartopics\driver\sqlite3
+-        arguments:
+-            - '@dbal.conn'
+-        tags:
+-            - { name: vse.similartopics.driver }
+-
+-    vse.similartopics.driver.mssql:
+-        class: vse\similartopics\driver\mssql
+-        arguments:
+-            - '@dbal.conn'
+-        tags:
+-            - { name: vse.similartopics.driver }
+-
+-    vse.similartopics.driver.mssqlnative:
+-        class: vse\similartopics\driver\mssqlnative
+-        parent: vse.similartopics.driver.mssql
+-        tags:
+-            - { name: vse.similartopics.driver }
+-
+-    vse.similartopics.driver.mssql_odbc:
+-        class: vse\similartopics\driver\mssql_odbc
+-        parent: vse.similartopics.driver.mssql
+-        tags:
+-            - { name: vse.similartopics.driver }
+-
+-    vse.similartopics.driver.oracle:
+-        class: vse\similartopics\driver\oracle
+-        arguments:
+-            - '@dbal.conn'
+-        tags:
+-            - { name: vse.similartopics.driver }
++            - { name: vse.similartopcs.driver }
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/controller/ajax_controller.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/controller/ajax_controller.php"
+deleted file mode 100644
+index d49f853f1..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/controller/ajax_controller.php"
++++ /dev/null
+@@ -1,63 +0,0 @@
+-<?php
+-/**
+- *
+- * Precise Similar Topics
+- *
+- * @copyright (c) 2025 Matt Friedman
+- * @license GNU General Public License, version 2 (GPL-2.0)
+- *
+- */
+-
+-namespace vse\similartopics\controller;
+-
+-use phpbb\exception\http_exception;
+-use Symfony\Component\HttpFoundation\JsonResponse;
+-use phpbb\request\request;
+-use vse\similartopics\core\similar_topics;
+-
+-class ajax_controller
+-{
+-	/** @var request */
+-	protected $request;
+-
+-	/** @var similar_topics */
+-	protected $similar_topics;
+-
+-	/**
+-	 * Constructor
+-	 *
+-	 * @param request $request
+-	 * @param similar_topics $similar_topics
+-	 */
+-	public function __construct(request $request, similar_topics $similar_topics)
+-	{
+-		$this->request = $request;
+-		$this->similar_topics = $similar_topics;
+-	}
+-
+-	/**
+-	 * Handle AJAX request for similar topics search
+-	 *
+-	 * @return JsonResponse
+-	 * @throws http_exception
+-	 */
+-	public function search_similar_topics()
+-	{
+-		if (!$this->request->is_ajax())
+-		{
+-			throw new http_exception(403, 'NO_AUTH_OPERATION');
+-		}
+-
+-		$query = $this->request->variable('q', '', true);
+-		$forum_id = $this->request->variable('f', 0);
+-
+-		if (utf8_strlen($query) < 3 || !$this->similar_topics->is_dynamic_available())
+-		{
+-			return new JsonResponse(['topics' => []]);
+-		}
+-
+-		$topics = $this->similar_topics->search_similar_topics_ajax($query, $forum_id);
+-
+-		return new JsonResponse(['topics' => $topics]);
+-	}
+-}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/core/similar_topics.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/core/similar_topics.php"
+index 72de4b84e..946730c0f 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/core/similar_topics.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/core/similar_topics.php"
+@@ -17,6 +17,7 @@ use phpbb\config\db_text;
+ use phpbb\content_visibility;
+ use phpbb\db\driver\driver_interface as db;
+ use phpbb\event\dispatcher_interface as dispatcher;
++use phpbb\extension\manager as ext_manager;
+ use phpbb\language\language;
+ use phpbb\pagination;
+ use phpbb\request\request;
+@@ -45,6 +46,9 @@ class similar_topics
+ 	/** @var dispatcher */
+ 	protected $dispatcher;
+ 
++	/** @var ext_manager */
++	protected $extension_manager;
++
+ 	/** @var language */
+ 	protected $language;
+ 
+@@ -63,9 +67,6 @@ class similar_topics
+ 	/** @var content_visibility */
+ 	protected $content_visibility;
+ 
+-	/** @var stop_word_helper */
+-	protected $stop_word_helper;
+-
+ 	/** @var similartopics_driver */
+ 	protected $similartopics;
+ 
+@@ -88,18 +89,18 @@ class similar_topics
+ 	 * @param db_text               $config_text
+ 	 * @param db                    $db
+ 	 * @param dispatcher            $dispatcher
++	 * @param ext_manager           $extension_manager
+ 	 * @param language              $language
+ 	 * @param pagination            $pagination
+ 	 * @param request               $request
+ 	 * @param template              $template
+ 	 * @param user                  $user
+ 	 * @param content_visibility    $content_visibility
+-	 * @param stop_word_helper      $stop_word_helper
+ 	 * @param similartopics_manager $similartopics_manager
+ 	 * @param string                $root_path
+ 	 * @param string                $php_ext
+ 	 */
+-	public function __construct(auth $auth, cache $cache, config $config, db_text $config_text, db $db, dispatcher $dispatcher, language $language, pagination $pagination, request $request, template $template, user $user, content_visibility $content_visibility, stop_word_helper $stop_word_helper, similartopics_manager $similartopics_manager, $root_path, $php_ext)
++	public function __construct(auth $auth, cache $cache, config $config, db_text $config_text, db $db, dispatcher $dispatcher, ext_manager $extension_manager, language $language, pagination $pagination, request $request, template $template, user $user, content_visibility $content_visibility, similartopics_manager $similartopics_manager, $root_path, $php_ext)
+ 	{
+ 		$this->auth = $auth;
+ 		$this->cache = $cache;
+@@ -107,7 +108,7 @@ class similar_topics
+ 		$this->config_text = $config_text;
+ 		$this->db = $db;
+ 		$this->dispatcher = $dispatcher;
+-		$this->stop_word_helper = $stop_word_helper;
++		$this->extension_manager = $extension_manager;
+ 		$this->language = $language;
+ 		$this->pagination = $pagination;
+ 		$this->request = $request;
+@@ -153,28 +154,6 @@ class similar_topics
+ 		return !empty($this->user->data['user_similar_topics']) && $this->auth->acl_get('u_similar_topics');
+ 	}
+ 
+-	/**
+-	 * Is dynamic similar topics available?
+-	 *
+-	 * @access public
+-	 * @return bool True if available, false otherwise
+-	 */
+-	public function is_dynamic_available()
+-	{
+-		return $this->is_dynamic_enabled() && $this->is_viewable() && $this->similartopics !== null;
+-	}
+-
+-	/**
+-	 * Is dynamic similar topics enabled?
+-	 *
+-	 * @access public
+-	 * @return bool True if enabled, false otherwise
+-	 */
+-	public function is_dynamic_enabled()
+-	{
+-		return !empty($this->config['similar_topics_dynamic']) && !empty($this->config['similar_topics_limit']);
+-	}
+-
+ 	/**
+ 	 * Get similar topics by matching topic titles
+ 	 * Loosely based on viewforum.php lines 840-1040
+@@ -194,9 +173,7 @@ class similar_topics
+ 			return;
+ 		}
+ 
+-		$this->stop_word_helper->set_use_localized($this->get_localized_ignore_words());
+-		$this->stop_word_helper->set_additional_ignore_words($this->get_additional_ignore_words());
+-		$topic_title = $this->stop_word_helper->clean_text($topic_data['topic_title']);
++		$topic_title = $this->clean_topic_title($topic_data['topic_title']);
+ 
+ 		// If the cleaned up topic_title is empty, no need to continue
+ 		if (empty($topic_title))
+@@ -322,7 +299,6 @@ class similar_topics
+ 				$u_mcp_queue = ($topic_unapproved || $posts_unapproved) ? append_sid("{$this->root_path}mcp.$this->php_ext", 'i=queue&amp;mode=' . ($topic_unapproved ? 'approve_details' : 'unapproved_posts') . "&amp;t=$similar_topic_id", true, $this->user->session_id) : '';
+ 
+ 				$base_url = append_sid("{$this->root_path}viewtopic.$this->php_ext", $view_topic_url_params);
+-
+ 				$topic_row = array(
+ 					'TOPIC_AUTHOR_FULL'			=> get_username_string('full', $row['topic_poster'], $row['topic_first_poster_name'], $row['topic_first_poster_colour']),
+ 					'FIRST_POST_TIME'			=> $this->user->format_date($row['topic_time']),
+@@ -333,6 +309,7 @@ class similar_topics
+ 
+ 					'TOPIC_REPLIES'			=> $replies,
+ 					'TOPIC_VIEWS'			=> $row['topic_views'],
++					'TOPIC_ANSWERED'		=> ($this->extension_manager->is_enabled('kinerity/bestanswer')) && $row['answer_post_id'] ? true : false,
+ 					'TOPIC_TITLE'			=> censor_text($row['topic_title']),
+ 					'FORUM_TITLE'			=> $row['forum_name'],
+ 
+@@ -377,7 +354,7 @@ class similar_topics
+ 			}
+ 		}
+ 
+-		$this->add_language();
++		$this->language->add_lang('similar_topics', 'vse/similartopics');
+ 
+ 		$this->template->assign_vars(array(
+ 			'NEWEST_POST_IMG'	=> $this->user->img('icon_topic_newest', 'VIEW_NEWEST_POST'),
+@@ -388,96 +365,130 @@ class similar_topics
+ 	}
+ 
+ 	/**
+-	 * Add lang files for similar topics
++	 * Clean topic title (and if needed, ignore-words)
+ 	 *
+-	 * @return void
++	 * @access public
++	 * @param string $text The topic title
++	 * @return string The topic title
+ 	 */
+-	public function add_language()
++	public function clean_topic_title($text)
+ 	{
+-		$this->language->add_lang('similar_topics', 'vse/similartopics');
++		// Strip quotes, ampersands
++		$text = str_replace(array('&quot;', '&amp;'), '', $text);
++
++		// UTF Emojis
++		$regex_emoticons = '/[\x{1F600}-\x{1F64F}]/u';
++		$text = preg_replace($regex_emoticons, '', $text);
++
++		// Match Miscellaneous Symbols and Pictographs
++		$regex_symbols = '/[\x{1F300}-\x{1F5FF}]/u';
++		$text = preg_replace($regex_symbols, '', $text);
++
++		// Match Transport And Map Symbols
++		$regex_transport = '/[\x{1F680}-\x{1F6FF}]/u';
++		$text = preg_replace($regex_transport, '', $text);
++
++		// Match Miscellaneous Symbols
++		$regex_misc = '/[\x{2600}-\x{26FF}]/u';
++		$text = preg_replace($regex_misc, '', $text);
++
++		// Match Dingbats
++		$regex_dingbats = '/[\x{2700}-\x{27BF}]/u';
++		$text = preg_replace($regex_dingbats, '', $text);
++
++		$regex_bbemoji = '(:([-+_a-z0-9]+):(?!\\w|[^<>]*(?=>|</code>)))';
++		$matches = [];
++		preg_match_all($regex_bbemoji, $text, $matches);
++		foreach ($matches[0] as $emoji) {
++			$text = str_replace($emoji, '', $text);
+ 		}
+ 
+-	/**
+-	 * Check if we should load localized ignore words
+-	 *
+-	 * @access protected
+-	 * @return bool True if non-English language or using a dbms with no stop-words
+-	 */
+-	protected function get_localized_ignore_words()
++		$text = trim($text);
++
++		if (!$this->english_lang() || $this->get_ignore_words())
+ 		{
+-		return !in_array($this->user->lang_name, ['en', 'en_us'], true) || !$this->similartopics->has_stopword_support();
++			$text = $this->strip_stop_words($text);
++		}
++
++		return $text;
+ 	}
+ 
+ 	/**
+-	 * Search for similar topics via AJAX for dynamic suggestions
++	 * Remove any non-english and/or custom defined ignore-words
+ 	 *
+-	 * @param string $query The search query
+-	 * @param int $forum_id The forum ID to search from
+-	 * @return array Array of similar topics
++	 * @access protected
++	 * @param string $text The topic title
++	 * @return string The topic title
+ 	 */
+-	public function search_similar_topics_ajax($query, $forum_id = 0)
++	protected function strip_stop_words($text)
+ 	{
+-		$this->stop_word_helper->set_use_localized($this->get_localized_ignore_words());
+-		$this->stop_word_helper->set_additional_ignore_words($this->get_additional_ignore_words());
+-		$cleaned_query = $this->stop_word_helper->clean_text($query);
++		$words = array();
+ 
+-		if (empty($cleaned_query))
++		// If non-English, look for a list of stop-words to be ignored
++		// in either the core or the extension (deprecated from core)
++		if (!$this->english_lang())
+ 		{
+-			return [];
++			$finder = $this->extension_manager->get_finder();
++			$search_ignore_words = $finder
++				->set_extensions(array('vse/similartopics'))
++				->prefix('search_ignore_words')
++				->suffix(".$this->php_ext")
++				->extension_directory("/language/{$this->user->lang_name}")
++				->core_path("language/{$this->user->lang_name}/")
++				->get_files();
++			if (current($search_ignore_words))
++			{
++				include current($search_ignore_words);
++			}
+ 		}
+ 
+-		$sensitivity = $this->config->offsetExists('similar_topics_sense') ? number_format($this->config['similar_topics_sense'] / 10, 1, '.', '') : '0.5';
+-		$sql_array = $this->similartopics->get_query(0, $cleaned_query, $this->config['similar_topics_time'], $sensitivity);
+-
+-		$similar_topic_forums = null;
+-		if ($forum_id > 0)
++		if ($this->get_ignore_words())
+ 		{
+-			$sql = 'SELECT similar_topic_forums
+-				FROM ' . FORUMS_TABLE . '
+-				WHERE forum_id = ' . (int) $forum_id;
+-			$result = $this->db->sql_query($sql, 3600);
+-			$similar_topic_forums = $this->db->sql_fetchfield('similar_topic_forums');
+-			$this->db->sql_freeresult($result);
++			// Merge any custom defined ignore words from the ACP to the stop-words array
++			$words = array_merge($this->make_word_array($this->get_ignore_words()), $words);
+ 		}
+ 
+-		$passworded_forums = $this->user->get_passworded_forums();
++		// Remove stop-words from the topic title text
++		$words = array_diff($this->make_word_array($text), $words);
+ 
+-		if (!empty($similar_topic_forums))
+-		{
+-			$included_forums = array_diff(json_decode($similar_topic_forums, true), $passworded_forums);
+-			if (empty($included_forums))
+-			{
+-				return [];
+-			}
+-			$sql_array['WHERE'] .= ' AND ' . $this->db->sql_in_set('f.forum_id', $included_forums);
+-		}
+-		else
+-		{
+-			if (count($passworded_forums))
+-			{
+-				$sql_array['WHERE'] .= ' AND ' . $this->db->sql_in_set('f.forum_id', $passworded_forums, true);
+-			}
+-			$sql_array['WHERE'] .= ' AND f.similar_topics_ignore = 0';
++		// Convert our words array back to a string
++		return implode(' ', $words);
+ 	}
+ 
+-		$topics = [];
+-		$sql = $this->db->sql_build_query('SELECT', $sql_array);
+-		$result = $this->db->sql_query_limit($sql, 5);
++	/**
++	 * Helper function to split string into an array of words
++	 *
++	 * @access protected
++	 * @param string $text String of plain text words
++	 * @return array Array of plaintext words
++	 */
++	protected function make_word_array($text)
++	{
++		// Strip out any non-alpha-numeric characters using PCRE regex syntax
++		$text = trim(preg_replace('#[^\p{L}\p{N}]+#u', ' ', $text));
+ 
+-		while ($row = $this->db->sql_fetchrow($result))
++		$words = explode(' ', utf8_strtolower($text));
++		foreach ($words as $key => $word)
+ 		{
+-			if ($this->auth->acl_get('f_read', (int) $row['forum_id']))
++			// Strip words of 2 characters or fewer
++			if (utf8_strlen(trim($word)) < 3)
+ 			{
+-				$topics[] = [
+-					'id' => (int) $row['topic_id'],
+-					'title' => censor_text($row['topic_title']),
+-					'url' => append_sid("{$this->root_path}viewtopic.$this->php_ext", 't=' . $row['topic_id'])
+-				];
++				unset($words[$key]);
+ 			}
+ 		}
+-		$this->db->sql_freeresult($result);
+ 
+-		return $topics;
++		return $words;
++	}
++
++	/**
++	 * Check if English is the current user's language
++	 *
++	 * @access protected
++	 * @return bool True if lang is 'en' or 'en_us', false otherwise
++	 */
++	protected function english_lang()
++	{
++		return ($this->user->lang_name === 'en' || $this->user->lang_name === 'en_us');
+ 	}
+ 
+ 	/**
+@@ -486,7 +497,7 @@ class similar_topics
+ 	 * @access protected
+ 	 * @return string|null String of ignore words or null if there are none defined
+ 	 */
+-	protected function get_additional_ignore_words()
++	protected function get_ignore_words()
+ 	{
+ 		$key = 'similar_topics_words';
+ 
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/core/stop_word_helper.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/core/stop_word_helper.php"
+deleted file mode 100644
+index 2af488e1a..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/core/stop_word_helper.php"
++++ /dev/null
+@@ -1,198 +0,0 @@
+-<?php
+-/**
+- *
+- * Precise Similar Topics
+- *
+- * @copyright (c) 2025 Matt Friedman
+- * @license GNU General Public License, version 2 (GPL-2.0)
+- *
+- */
+-
+-namespace vse\similartopics\core;
+-
+-use phpbb\cache\driver\driver_interface as cache_driver;
+-use phpbb\extension\manager as ext_manager;
+-use phpbb\user;
+-
+-/**
+- * A helper class to clean text and remove stop words (localized and additional)
+- * for topic titles or other search-related strings.
+- */
+-class stop_word_helper
+-{
+-	/** @var cache_driver */
+-	protected $cache;
+-
+-	/** @var ext_manager */
+-	protected $extension_manager;
+-
+-	/** @var user */
+-	protected $user;
+-
+-	/** @var string */
+-	protected $php_ext;
+-
+-	/** @var array|null Lookup table for fast filtering */
+-	protected $ignore_lookup;
+-
+-	/** @var bool Whether localized ignore words should be loaded */
+-	protected $use_localized = false;
+-
+-	/** @var string Additional ignore words string */
+-	protected $additional_ignore = '';
+-
+-	/** @var bool Whether ignore words need to be reloaded */
+-	protected $needs_reload = true;
+-
+-	/**
+-	 * Constructor
+-	 *
+-	 * @param cache_driver $cache
+-	 * @param ext_manager $extension_manager
+-	 * @param user $user
+-	 * @param string $php_ext
+-	 */
+-	public function __construct(cache_driver $cache, ext_manager $extension_manager, user $user, $php_ext)
+-	{
+-		$this->cache = $cache;
+-		$this->extension_manager = $extension_manager;
+-		$this->user = $user;
+-		$this->php_ext = $php_ext;
+-	}
+-
+-	/**
+-	 * Set additional ignore words
+-	 *
+-	 * @param string $words
+-	 */
+-	public function set_additional_ignore_words($words)
+-	{
+-		if ($this->additional_ignore !== $words)
+-		{
+-			$this->additional_ignore = $words;
+-			$this->needs_reload = true;
+-		}
+-	}
+-
+-	/**
+-	 * Set whether to use localized ignore words
+-	 *
+-	 * @param bool $value
+-	 */
+-	public function set_use_localized($value)
+-	{
+-		$value = (bool) $value;
+-		if ($this->use_localized !== $value)
+-		{
+-			$this->use_localized = $value;
+-			$this->needs_reload = true;
+-		}
+-	}
+-
+-	/**
+-	 * Clean text (strip quotes, ampersands, stop words)
+-	 *
+-	 * @param string $text
+-	 * @return string
+-	 */
+-	public function clean_text($text)
+-	{
+-		// Strip HTML entities
+-		$text = str_replace(['&quot;', '&amp;'], '', $text);
+-
+-		if ($this->use_localized || !empty($this->additional_ignore))
+-		{
+-			$this->load_ignore_words();
+-			$filtered = array_filter(
+-				$this->make_word_array($text, true),
+-				[$this, 'filter_ignore_words']
+-			);
+-			$text = implode(' ', array_unique($filtered));
+-		}
+-
+-		return $text;
+-	}
+-
+-	/**
+-	 * Load ignore words into memory and build a lookup table
+-	 */
+-	protected function load_ignore_words()
+-	{
+-		if ($this->needs_reload || $this->ignore_lookup === null)
+-		{
+-			// The cache will be invalidated when language, localized setting, or additional words change
+-			$cache_key = '_pst_ignore_' . md5($this->user->lang_name . '|' . (int) $this->use_localized . '|' . $this->additional_ignore);
+-			$this->ignore_lookup = $this->cache->get($cache_key);
+-
+-			if ($this->ignore_lookup === false)
+-			{
+-				// Load localized ignore words (if needed)
+-				$words = $this->use_localized ? $this->load_localized_words() : [];
+-
+-				// Load additional ignore words (if defined)
+-				if (!empty($this->additional_ignore))
+-				{
+-					$words = array_merge($words, $this->make_word_array($this->additional_ignore));
+-				}
+-
+-				$this->ignore_lookup = array_flip(array_unique($words));
+-				$this->cache->put($cache_key, $this->ignore_lookup);
+-			}
+-
+-			$this->needs_reload = false;
+-		}
+-	}
+-
+-	/**
+-	 * Load localized ignore words
+-	 *
+-	 * @return array An array of ignore-words from the user's language pack
+-	 */
+-	protected function load_localized_words()
+-	{
+-		$words = [];
+-		$finder = $this->extension_manager->get_finder();
+-		$files = $finder
+-			->set_extensions(['vse/similartopics'])
+-			->prefix('search_ignore_words')
+-			->suffix('.' . $this->php_ext)
+-			->extension_directory("/language/{$this->user->lang_name}")
+-			->core_path("language/{$this->user->lang_name}/")
+-			->get_files();
+-
+-		if (current($files))
+-		{
+-			include current($files);
+-		}
+-
+-		return $words;
+-	}
+-
+-	/**
+-	 * Split text into a word array
+-	 *
+-	 * @param string $text A string of text
+-	 * @param bool $filter_short Whether to filter out words < 3 characters
+-	 * @return array The original string of text, filtered into an array of individual words
+-	 */
+-	protected function make_word_array($text, $filter_short = false)
+-	{
+-		$text = trim(preg_replace('#[^\p{L}\p{N}]+#u', ' ', $text));
+-		$words = array_filter(explode(' ', utf8_strtolower($text)));
+-
+-		return $filter_short ? array_filter($words, static function($word) {
+-			return utf8_strlen($word) >= 3;
+-		}) : $words;
+-	}
+-
+-	/**
+-	 * Filter callback for array_filter to exclude stop words
+-	 *
+-	 * @param string $word Word to check
+-	 * @return bool True to keep a word, false to remove it
+-	 */
+-	protected function filter_ignore_words($word)
+-	{
+-		return !isset($this->ignore_lookup[$word]);
+-	}
+-}
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/diff_full.tmp"
+new file mode 100644
+index 000000000..f46ca4bf6
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/diff_full.tmp"
+@@ -0,0 +1,5844 @@
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/CHANGELOG.md" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/CHANGELOG.md"
++index dcfad82c4..378efc1d0 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/CHANGELOG.md"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/CHANGELOG.md"
++@@ -1,18 +1,10 @@
++ ## Changelog
++ 
++-### 1.7.0 - 2025-12-16
++-
++-- NEW FEATURE: Dynamically show similar topics to users as they title their new posts.
++-- IMPROVEMENT: Support for MSSQL, SQLite3 and Oracle databases added.
++-- IMPROVEMENT: Added stop-word filtering for Postgres databases using the 'simple' dictionary.
++-- Added missing stop-word filters (AI-translated) for Hebrew, Persian, Japanese, Swedish and Turkish languages.
++-- Fixed and optimized lots of code when processing similar topics.
++-
++ ### 1.6.0 - 2022-12-17
++ 
++ - Removed support for phpBB 3.1.x.
++ - Removed forum "f=" parameters from URLs.
++-- Optimized JavaScript and other coding updates.
+++- Optimized Javascript and other coding updates.
++ - Support added for ScaffoldBB style.
++ 
++ ### 1.5.4 - 2020-12-01
++@@ -20,11 +12,11 @@
++ - Fix for Postgresql databases where titles with single quotes would fatally error.
++ - Enabled AJAX interactions when saving settings in the ACP.
++ - Re-wrote the search period explanation in the ACP settings.
++-- Switched to using the phpBB finder to locate foreign language ignore words files.
+++- Switched to using phpBB finder to locate foreign language ignore words files.
++ 
++ ### 1.5.3 - 2020-01-10
++ 
++-- Compatibility issues with Prosilver styles are addressed.
+++- Compatibility issues with Prosilver styles addressed.
++ - Installation errors on phpBB 3.3.x will be reported to the user.
++ 
++ ### 1.5.2 - 2019-06-26
++@@ -35,18 +27,18 @@
++ 
++ ### 1.5.1 - 2018-06-01
++ 
++-- Fixed an issue where PHP using European decimal notation (comma instead of a period) could cause an SQL error.
++-- Minor code fixes based on the phpBB Extension team validation report.
+++- Fixed an issue where PHP using European decimal notation (comma instead of period) could cause an SQL error.
+++- Minor code fixes based on phpBB Extension team validation report.
++ 
++ ### 1.5.0 - 2018-03-14
++ 
++ - Added support for forums using PostgreSQL databases (with thanks to hubaishan).
++ - Fixed a layout bug with the pagination buttons introduced in phpBB 3.2.2.
++-- Fixed a potential SQL error bug when installing.
+++- Fixed potential SQL error bug when installing.
++ 
++ ### 1.4.3 - 2018-01-03
++ 
++-- Added a new setting: Search Sensitivity. Allows users to adjust the weighting of similar topics matches. This was added because InnoDB, which is now supported, weights results differently than MyISAM. This will allow users with InnoDB tables to improve their similar topics results by lowering the weighting/sensitivity.
+++- Added a new setting: Search Sensitivity. Allows users to adjust the weighting of similar topics matches. This was added because InnoDB which is now supported, weights results differently than MyISAM. This will allow users with InnoDB tables to improve their similar topics results by lowering the weighting/sensitivity.
++ - Converted all template syntax to Twig format.
++ 
++ ### 1.4.2 - 2017-03-18
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/acp/controller/similar_topics_admin.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/acp/controller/similar_topics_admin.php"
++index 85c505289..4e2b5441e 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/acp/controller/similar_topics_admin.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/acp/controller/similar_topics_admin.php"
++@@ -157,7 +157,6 @@ class similar_topics_admin
++ 
++ 			// Set basic config settings
++ 			$this->config->set('similar_topics', $this->request->variable('pst_enable', 0));
++-			$this->config->set('similar_topics_dynamic', $this->request->variable('pst_dynamic', 0));
++ 			$this->config->set('similar_topics_limit', abs($this->request->variable('pst_limit', 0))); // use abs for positive values only
++ 			$this->config->set('similar_topics_cache', abs($this->request->variable('pst_cache', 0))); // use abs for positive values only
++ 			$this->config_text_set('similar_topics_words', $this->request->variable('pst_words', '', true));
++@@ -209,22 +208,20 @@ class similar_topics_admin
++ 
++ 		$this->template->assign_vars(array(
++ 			'S_PST_ENABLE'    => $this->isset_or_default($this->config['similar_topics'], false),
++-			'S_PST_DYNAMIC'   => $this->isset_or_default($this->config['similar_topics_dynamic'], false),
++ 			'PST_LIMIT'       => $this->isset_or_default($this->config['similar_topics_limit'], ''),
++ 			'PST_CACHE'       => $this->isset_or_default($this->config['similar_topics_cache'], ''),
++ 			'PST_SENSE'       => $this->isset_or_default($this->config['similar_topics_sense'], ''),
++ 			'PST_WORDS'       => $this->isset_or_default($this->config_text_get('similar_topics_words'), ''),
++ 			'PST_TIME'        => $this->get_pst_time($this->config['similar_topics_time'], $this->config['similar_topics_type']),
++-			'PST_SENSITIVITY' => $this->similartopics && $this->similartopics->get_engine() === 'innodb' ? 1 : 5,
++ 			'S_PST_NO_COMPAT' => $this->similartopics === null || !$this->similartopics->is_fulltext('topic_title'),
++ 			'U_ACTION'        => $this->u_action,
++ 		));
++ 
++ 		// If postgresql, we need to make an options list of text search names
++-		if ($this->similartopics instanceof \vse\similartopics\driver\postgres)
+++		if ($this->similartopics && $this->similartopics->get_type() === 'postgres')
++ 		{
++ 			$this->language->add_lang('acp/search');
++-			foreach ($this->similartopics->get_cfg_name_list() as $row)
+++			foreach ($this->get_cfgname_list() as $row)
++ 			{
++ 				$this->template->assign_block_vars('postgres_ts_names', array(
++ 					'NAME'       => $row['ts_name'],
++@@ -269,8 +266,6 @@ class similar_topics_admin
++ 				WHERE forum_id = $forum_id";
++ 			$this->db->sql_query($sql);
++ 
++-			$this->cache->destroy('sql', FORUMS_TABLE);
++-
++ 			$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'PST_LOG_MSG');
++ 
++ 			$this->end('PST_SAVED');
++@@ -315,6 +310,22 @@ class similar_topics_admin
++ 		}
++ 	}
++ 
+++	/**
+++	 * Get list of PostgreSQL text search names
+++	 *
+++	 * @access protected
+++	 * @return array array of text search names
+++	 */
+++	protected function get_cfgname_list()
+++	{
+++		$sql = 'SELECT cfgname AS ts_name FROM pg_ts_config';
+++		$result = $this->db->sql_query($sql);
+++		$ts_options = $this->db->sql_fetchrowset($result);
+++		$this->db->sql_freeresult($result);
+++
+++		return $ts_options;
+++	}
+++
++ 	/**
++ 	 * Get forums list
++ 	 *
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/acp/similar_topics_module.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/acp/similar_topics_module.php"
++index 8e9408fa8..e0a74e17d 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/acp/similar_topics_module.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/acp/similar_topics_module.php"
++@@ -32,7 +32,9 @@ class similar_topics_module
++ 		global $phpbb_container;
++ 
++ 		$this->tpl_name = 'acp_similar_topics';
++-		$this->page_title = 'PST_TITLE_ACP';
+++
+++		$this->page_title = $phpbb_container->get('language')
+++			->lang('PST_TITLE_ACP');
++ 
++ 		$phpbb_container->get('vse.similartopics.acp.controller')
++ 			->set_u_action($this->u_action)
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/adm/style/acp_similar_topics.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/adm/style/acp_similar_topics.html"
++index 8f0c529db..0be73ff9f 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/adm/style/acp_similar_topics.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/adm/style/acp_similar_topics.html"
++@@ -20,13 +20,13 @@
++ 	<fieldset>
++ 		<legend>{{ lang('PST_ADVANCED_FORUM') }}</legend>
++ 		<dl>
++-			<dt><label for="similar_forums">{{ lang('FORUM') ~ lang('COLON') }} {{ PST_FORUM_NAME }}</label><br><br><span>{{ lang('PST_ADVANCED_EXP', PST_FORUM_NAME) }}</span></dt>
+++			<dt><label for="similar_forums">{{ lang('FORUM') ~ lang('COLON') }} {{ PST_FORUM_NAME }}</label><br /><br /><span>{{ lang('PST_ADVANCED_EXP', PST_FORUM_NAME) }}</span></dt>
++ 			<dd><select id="similar_forums" name="similar_forums_id[]" multiple="multiple" size="10">{{ SIMILAR_FORUMS_OPTIONS }}</select></dd>
++ 			<dd><a href="#" data-selector="false">{{ lang('PST_DESELECT_ALL') }}</a></dd>
++ 		</dl>
++ 		<p class="submit-buttons">
++-			<input class="button1" type="submit" id="submit" name="submit" value="{{ lang('SUBMIT') }}">&nbsp;
++-			<input class="button2" type="reset" id="reset" name="reset" value="{{ lang('RESET') }}">
+++			<input class="button1" type="submit" id="submit" name="submit" value="{{ lang('SUBMIT') }}" />&nbsp;
+++			<input class="button2" type="reset" id="reset" name="reset" value="{{ lang('RESET') }}" />
++ 		</p>
++ 		{{ S_FORM_TOKEN }}
++ 	</fieldset>
++@@ -47,17 +47,10 @@
++ 	<fieldset>
++ 		<legend>{{ lang('PST_LEGEND1') }}</legend>
++ 		<dl>
++-			<dt><label for="pst_enable">{{ lang('PST_ENABLE') ~ lang('COLON') }}</label><br><span>{{ lang('PST_ENABLE_EXPLAIN') }}</span></dt>
+++			<dt><label for="pst_enable">{{ lang('PST_ENABLE') ~ lang('COLON') }}</label></dt>
++ 			<dd>
++-				<label><input type="radio" class="radio" id="pst_enable" name="pst_enable" value="1"{% if S_PST_ENABLE %} checked="checked"{% endif %}{% if S_PST_NO_SUPPORT %} disabled="disabled"{% endif %}> {{ lang('YES') }}</label>
++-				<label><input type="radio" class="radio" name="pst_enable" value="0"{% if not S_PST_ENABLE %} checked="checked"{% endif %}> {{ lang('NO') }}</label>
++-			</dd>
++-		</dl>
++-		<dl>
++-			<dt><label for="pst_dynamic">{{ lang('PST_DYNAMIC') ~ lang('COLON') }}</label><br><span>{{ lang('PST_DYNAMIC_EXPLAIN') }}</span></dt>
++-			<dd>
++-				<label><input type="radio" class="radio" id="pst_dynamic" name="pst_dynamic" value="1"{% if S_PST_DYNAMIC %} checked="checked"{% endif %}> {{ lang('YES') }}</label>
++-				<label><input type="radio" class="radio" name="pst_dynamic" value="0"{% if not S_PST_DYNAMIC %} checked="checked"{% endif %}> {{ lang('NO') }}</label>
+++				<label><input type="radio" class="radio" id="pst_enable" name="pst_enable" value="1"{% if S_PST_ENABLE %} checked="checked"{% endif %}{% if S_PST_NO_SUPPORT %} disabled="disabled"{% endif %} /> {{ lang('YES') }}</label>
+++				<label><input type="radio" class="radio" name="pst_enable" value="0"{% if not S_PST_ENABLE %} checked="checked"{% endif %} /> {{ lang('NO') }}</label>
++ 			</dd>
++ 		</dl>
++ 	</fieldset>
++@@ -65,12 +58,12 @@
++ 	<fieldset>
++ 		<legend>{{ lang('PST_LEGEND2') }}</legend>
++ 		<dl>
++-			<dt><label for="pst_limit">{{ lang('PST_LIMIT') ~ lang('COLON') }}</label><br><span>{{ lang('PST_LIMIT_EXPLAIN') }}</span></dt>
++-			<dd><input name="pst_limit" id="pst_limit" type="number" min="0" max="999" value="{{ PST_LIMIT }}"></dd>
+++			<dt><label for="pst_limit">{{ lang('PST_LIMIT') ~ lang('COLON') }}</label><br /><span>{{ lang('PST_LIMIT_EXPLAIN') }}</span></dt>
+++			<dd><input name="pst_limit" id="pst_limit" type="number" min="0" max="999" value="{{ PST_LIMIT }}" /></dd>
++ 		</dl>
++ 		<dl>
++-			<dt><label for="pst_time">{{ lang('PST_TIME') ~ lang('COLON') }}</label><br><span>{{ lang('PST_TIME_EXPLAIN') }}</span></dt>
++-			<dd><input name="pst_time" id="pst_time" type="number" min="0" max="999" value="{{ PST_TIME }}">
+++			<dt><label for="pst_time">{{ lang('PST_TIME') ~ lang('COLON') }}</label><br /><span>{{ lang('PST_TIME_EXPLAIN') }}</span></dt>
+++			<dd><input name="pst_time" id="pst_time" type="number" min="0" max="999" value="{{ PST_TIME }}" />
++ 				<label>
++ 					<select name="pst_time_type">
++ 						{% for similar_time_options in loops.similar_time_options %}
++@@ -81,12 +74,12 @@
++ 			</dd>
++ 		</dl>
++ 		<dl>
++-			<dt><label for="pst_cache">{{ lang('PST_CACHE') ~ lang('COLON') }}</label><br><span>{{ lang('PST_CACHE_EXPLAIN') }}</span></dt>
++-			<dd><input name="pst_cache" id="pst_cache" type="number" min="0" max="99999999" value="{{ PST_CACHE }}"> {{ lang('SECONDS') }}</dd>
+++			<dt><label for="pst_cache">{{ lang('PST_CACHE') ~ lang('COLON') }}</label><br /><span>{{ lang('PST_CACHE_EXPLAIN') }}</span></dt>
+++			<dd><input name="pst_cache" id="pst_cache" type="number" min="0" max="99999999" value="{{ PST_CACHE }}" /> {{ lang('SECONDS') }}</dd>
++ 		</dl>
++ 		<dl>
++-			<dt><label for="pst_sense">{{ lang('PST_SENSE') ~ lang('COLON') }}</label><br><span>{{ lang('PST_SENSE_EXPLAIN', PST_SENSITIVITY) }}</span></dt>
++-			<dd><input name="pst_sense" id="pst_sense" type="number" min="1" max="10" value="{{ PST_SENSE }}"></dd>
+++			<dt><label for="pst_sense">{{ lang('PST_SENSE') ~ lang('COLON') }}</label><br /><span>{{ lang('PST_SENSE_EXPLAIN') }}</span></dt>
+++			<dd><input name="pst_sense" id="pst_sense" type="number" min="1" max="10" value="{{ PST_SENSE }}" /></dd>
++ 		</dl>
++ 	</fieldset>
++ 
++@@ -96,7 +89,7 @@
++ 			<span class="small">{{ lang('PST_FORUM_INFO') }}</span>
++ 			<div style="overflow: auto; max-height: 300px;">
++ 				<table class="table1">
++-					<colgroup><col class="row1"><col class="row2"><col class="row1"><col class="row2"></colgroup>
+++					<colgroup><col class="row1" /><col class="row2" /><col class="row1" /><col class="row2" /></colgroup>
++ 					<thead>
++ 						<tr>
++ 							<th>{{ lang('FORUMS') }}</th>
++@@ -111,18 +104,18 @@
++ 							<td>
++ 								<strong><a href="{{ forums.U_FORUM }}">{{ forums.FORUM_NAME }}</a></strong>
++ 							</td>
++-							<td style="text-align: center; width: 20%;" title="{{ lang('PST_NOSHOW_TITLE')|e('html_attr') }} {{ forums.FORUM_NAME|e('html_attr') }}">
+++							<td style="text-align: center; width: 20%;" title="{{ lang('PST_NOSHOW_TITLE') }} {{ forums.FORUM_NAME }}">
++ 								<label>
++-									<input type="checkbox" class="radio" name="mark_noshow_forum[]" value="{{ forums.FORUM_ID }}" {{ forums.CHECKED_NOSHOW_FORUM }}>
+++									<input type="checkbox" class="radio" name="mark_noshow_forum[]" value="{{ forums.FORUM_ID }}" {{ forums.CHECKED_NOSHOW_FORUM }} />
++ 								</label>
++ 							</td>
++-							<td style="text-align: center; width: 20%;" title="{{ lang('PST_IGNORE_TITLE')|e('html_attr') }} {{ forums.FORUM_NAME|e('html_attr') }}">
+++							<td style="text-align: center; width: 20%;" title="{{ lang('PST_IGNORE_TITLE') }} {{ forums.FORUM_NAME }}">
++ 								<label>
++-									<input type="checkbox" class="radio" name="mark_ignore_forum[]" value="{{ forums.FORUM_ID }}" {{ forums.CHECKED_IGNORE_FORUM }}>
+++									<input type="checkbox" class="radio" name="mark_ignore_forum[]" value="{{ forums.FORUM_ID }}" {{ forums.CHECKED_IGNORE_FORUM }} />
++ 								</label>
++ 							</td>
++-							<td style="text-align: center; width: 20%;" title="{{ lang('PST_ADVANCED_TITLE')|e('html_attr') }} {{ forums.FORUM_NAME|e('html_attr') }}">
++-							<a href="{{ forums.U_ADVANCED }}">{% if forums.S_IS_ADVANCED %}<strong>{{ lang('PST_ADVANCED') }}</strong>{% else %}{{ lang('PST_STANDARD') }}{% endif %}</a>
+++							<td style="text-align: center; width: 20%;" title="{{ lang('PST_ADVANCED_TITLE') }} {{ forums.FORUM_NAME }}">
+++							<a href="{{ forums.U_ADVANCED }}">{% if forums.S_IS_ADVANCED %}<strong>{{ lang('PST_ADVANCED') }}</strong>{% else %}{{ lang('PST_STANDARD') }}</a>{% endif %}
++ 							</td>
++ 						</tr>
++ 						{% endfor %}
++@@ -135,12 +128,12 @@
++ 	<fieldset>
++ 		<legend>{{ lang('PST_LEGEND4') }}</legend>
++ 		<dl>
++-			<dt><label for="pst_words">{{ lang('PST_WORDS') ~ lang('COLON') }}</label><br><span>{{ lang('PST_WORDS_EXPLAIN') }}</span></dt>
+++			<dt><label for="pst_words">{{ lang('PST_WORDS') ~ lang('COLON') }}</label><br /><span>{{ lang('PST_WORDS_EXPLAIN') }}</span></dt>
++ 			<dd><textarea name="pst_words" id="pst_words" rows="5" cols="40">{{ PST_WORDS }}</textarea></dd>
++ 		</dl>
++ 		{% if loops.postgres_ts_names %}
++ 			<dl>
++-				<dt><label for="pst_postgres_ts_name">{{ lang('FULLTEXT_POSTGRES_TS_NAME') }}</label><br><span>{{ lang('FULLTEXT_POSTGRES_TS_NAME_EXPLAIN') }}</span></dt>
+++				<dt><label for="pst_postgres_ts_name">{{ lang('FULLTEXT_POSTGRES_TS_NAME') }}</label><br /><span>{{ lang('FULLTEXT_POSTGRES_TS_NAME_EXPLAIN') }}</span></dt>
++ 				<dd>
++ 					<select name="pst_postgres_ts_name" id="pst_postgres_ts_name">
++ 						{% for ts_name in loops.postgres_ts_names %}
++@@ -155,8 +148,8 @@
++ 	<fieldset>
++ 		<legend>{{ lang('ACP_SUBMIT_CHANGES') }}</legend>
++ 		<p class="submit-buttons">
++-			<input class="button1" type="submit" id="submit" name="submit" value="{{ lang('SUBMIT') }}">&nbsp;
++-			<input class="button2" type="reset" id="reset" name="reset" value="{{ lang('RESET') }}">
+++			<input class="button1" type="submit" id="submit" name="submit" value="{{ lang('SUBMIT') }}" />&nbsp;
+++			<input class="button2" type="reset" id="reset" name="reset" value="{{ lang('RESET') }}" />
++ 		</p>
++ 		{{ S_FORM_TOKEN }}
++ 	</fieldset>
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/composer.json"
++index 19c72b2a6..c5613f687 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/composer.json"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/composer.json"
++@@ -3,7 +3,7 @@
++     "type": "phpbb-extension",
++     "description": "A phpBB extension that displays a list of similar (related) topics at the bottom of the current topic's page.",
++     "homepage": "https://github.com/iMattPro/similartopics",
++-    "version": "1.7.0",
+++    "version": "1.6.0",
++     "keywords": [
++         "phpbb",
++         "extension",
++@@ -20,7 +20,7 @@
++     ],
++     "require": {
++         "php": ">=5.4",
++-        "composer/installers": "~1.0",
+++        "composer/installers": "~1.0.0",
++         "phpbb/phpbb": ">=3.2.1"
++     },
++     "extra": {
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/config/routing.yml" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/config/routing.yml"
++deleted file mode 100644
++index 3a3d08730..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/config/routing.yml"
+++++ /dev/null
++@@ -1,6 +0,0 @@
++-vse_similartopics_ajax_search:
++-    path: /similartopics/ajax/search
++-    defaults: { _controller: vse.similartopics.ajax.controller:search_similar_topics }
++-    methods: [GET]
++-    requirements:
++-        _format: json
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/config/services.yml" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/config/services.yml"
++index 9acfe7b01..8d651ffcd 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/config/services.yml"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/config/services.yml"
++@@ -8,13 +8,13 @@ services:
++             - '@config_text'
++             - '@dbal.conn'
++             - '@dispatcher'
+++            - '@ext.manager'
++             - '@language'
++             - '@pagination'
++             - '@request'
++             - '@template'
++             - '@user'
++             - '@content.visibility'
++-            - '@vse.similartopics.stop_word_helper'
++             - '@vse.similartopics.driver.manager'
++             - '%core.root_path%'
++             - '%core.php_ext%'
++@@ -23,8 +23,6 @@ services:
++         class: vse\similartopics\event\listener
++         arguments:
++             - '@vse.similartopics.manager'
++-            - '@controller.helper'
++-            - '@template'
++         tags:
++             - { name: event.listener }
++ 
++@@ -61,28 +59,13 @@ services:
++             - '%core.root_path%'
++             - '%core.php_ext%'
++ 
++-    vse.similartopics.stop_word_helper:
++-        class: vse\similartopics\core\stop_word_helper
++-        public: false
++-        arguments:
++-            - '@cache.driver'
++-            - '@ext.manager'
++-            - '@user'
++-            - '%core.php_ext%'
++-
++-    vse.similartopics.ajax.controller:
++-        class: vse\similartopics\controller\ajax_controller
++-        arguments:
++-            - '@request'
++-            - '@vse.similartopics.manager'
++-
++ # ----- Similar topics DB drivers collection -----
++     vse.similartopics.driver_collection:
++         class: phpbb\di\service_collection
++         arguments:
++             - '@service_container'
++         tags:
++-            - { name: service_collection, tag: vse.similartopics.driver }
+++            - { name: service_collection, tag: vse.similartopcs.driver }
++ 
++     vse.similartopics.driver.postgres:
++         class: vse\similartopics\driver\postgres
++@@ -90,50 +73,17 @@ services:
++             - '@dbal.conn'
++             - '@config'
++         tags:
++-            - { name: vse.similartopics.driver }
+++            - { name: vse.similartopcs.driver }
++ 
++     vse.similartopics.driver.mysqli:
++         class: vse\similartopics\driver\mysqli
++         arguments:
++             - '@dbal.conn'
++         tags:
++-            - { name: vse.similartopics.driver }
+++            - { name: vse.similartopcs.driver }
++ 
++     vse.similartopics.driver.mysql4:
++         class: vse\similartopics\driver\mysql4
++         parent: vse.similartopics.driver.mysqli
++         tags:
++-            - { name: vse.similartopics.driver }
++-
++-    vse.similartopics.driver.sqlite3:
++-        class: vse\similartopics\driver\sqlite3
++-        arguments:
++-            - '@dbal.conn'
++-        tags:
++-            - { name: vse.similartopics.driver }
++-
++-    vse.similartopics.driver.mssql:
++-        class: vse\similartopics\driver\mssql
++-        arguments:
++-            - '@dbal.conn'
++-        tags:
++-            - { name: vse.similartopics.driver }
++-
++-    vse.similartopics.driver.mssqlnative:
++-        class: vse\similartopics\driver\mssqlnative
++-        parent: vse.similartopics.driver.mssql
++-        tags:
++-            - { name: vse.similartopics.driver }
++-
++-    vse.similartopics.driver.mssql_odbc:
++-        class: vse\similartopics\driver\mssql_odbc
++-        parent: vse.similartopics.driver.mssql
++-        tags:
++-            - { name: vse.similartopics.driver }
++-
++-    vse.similartopics.driver.oracle:
++-        class: vse\similartopics\driver\oracle
++-        arguments:
++-            - '@dbal.conn'
++-        tags:
++-            - { name: vse.similartopics.driver }
+++            - { name: vse.similartopcs.driver }
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/controller/ajax_controller.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/controller/ajax_controller.php"
++deleted file mode 100644
++index d49f853f1..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/controller/ajax_controller.php"
+++++ /dev/null
++@@ -1,63 +0,0 @@
++-<?php
++-/**
++- *
++- * Precise Similar Topics
++- *
++- * @copyright (c) 2025 Matt Friedman
++- * @license GNU General Public License, version 2 (GPL-2.0)
++- *
++- */
++-
++-namespace vse\similartopics\controller;
++-
++-use phpbb\exception\http_exception;
++-use Symfony\Component\HttpFoundation\JsonResponse;
++-use phpbb\request\request;
++-use vse\similartopics\core\similar_topics;
++-
++-class ajax_controller
++-{
++-	/** @var request */
++-	protected $request;
++-
++-	/** @var similar_topics */
++-	protected $similar_topics;
++-
++-	/**
++-	 * Constructor
++-	 *
++-	 * @param request $request
++-	 * @param similar_topics $similar_topics
++-	 */
++-	public function __construct(request $request, similar_topics $similar_topics)
++-	{
++-		$this->request = $request;
++-		$this->similar_topics = $similar_topics;
++-	}
++-
++-	/**
++-	 * Handle AJAX request for similar topics search
++-	 *
++-	 * @return JsonResponse
++-	 * @throws http_exception
++-	 */
++-	public function search_similar_topics()
++-	{
++-		if (!$this->request->is_ajax())
++-		{
++-			throw new http_exception(403, 'NO_AUTH_OPERATION');
++-		}
++-
++-		$query = $this->request->variable('q', '', true);
++-		$forum_id = $this->request->variable('f', 0);
++-
++-		if (utf8_strlen($query) < 3 || !$this->similar_topics->is_dynamic_available())
++-		{
++-			return new JsonResponse(['topics' => []]);
++-		}
++-
++-		$topics = $this->similar_topics->search_similar_topics_ajax($query, $forum_id);
++-
++-		return new JsonResponse(['topics' => $topics]);
++-	}
++-}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/core/similar_topics.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/core/similar_topics.php"
++index 72de4b84e..946730c0f 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/core/similar_topics.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/core/similar_topics.php"
++@@ -17,6 +17,7 @@ use phpbb\config\db_text;
++ use phpbb\content_visibility;
++ use phpbb\db\driver\driver_interface as db;
++ use phpbb\event\dispatcher_interface as dispatcher;
+++use phpbb\extension\manager as ext_manager;
++ use phpbb\language\language;
++ use phpbb\pagination;
++ use phpbb\request\request;
++@@ -45,6 +46,9 @@ class similar_topics
++ 	/** @var dispatcher */
++ 	protected $dispatcher;
++ 
+++	/** @var ext_manager */
+++	protected $extension_manager;
+++
++ 	/** @var language */
++ 	protected $language;
++ 
++@@ -63,9 +67,6 @@ class similar_topics
++ 	/** @var content_visibility */
++ 	protected $content_visibility;
++ 
++-	/** @var stop_word_helper */
++-	protected $stop_word_helper;
++-
++ 	/** @var similartopics_driver */
++ 	protected $similartopics;
++ 
++@@ -84,22 +85,22 @@ class similar_topics
++ 	 * @access public
++ 	 * @param auth                  $auth
++ 	 * @param cache                 $cache
++-	 * @param config                 $config
+++	 * @param config                $config
++ 	 * @param db_text               $config_text
++ 	 * @param db                    $db
++ 	 * @param dispatcher            $dispatcher
+++	 * @param ext_manager           $extension_manager
++ 	 * @param language              $language
++ 	 * @param pagination            $pagination
++ 	 * @param request               $request
++ 	 * @param template              $template
++ 	 * @param user                  $user
++ 	 * @param content_visibility    $content_visibility
++-	 * @param stop_word_helper      $stop_word_helper
++ 	 * @param similartopics_manager $similartopics_manager
++ 	 * @param string                $root_path
++ 	 * @param string                $php_ext
++ 	 */
++-	public function __construct(auth $auth, cache $cache, config $config, db_text $config_text, db $db, dispatcher $dispatcher, language $language, pagination $pagination, request $request, template $template, user $user, content_visibility $content_visibility, stop_word_helper $stop_word_helper, similartopics_manager $similartopics_manager, $root_path, $php_ext)
+++	public function __construct(auth $auth, cache $cache, config $config, db_text $config_text, db $db, dispatcher $dispatcher, ext_manager $extension_manager, language $language, pagination $pagination, request $request, template $template, user $user, content_visibility $content_visibility, similartopics_manager $similartopics_manager, $root_path, $php_ext)
++ 	{
++ 		$this->auth = $auth;
++ 		$this->cache = $cache;
++@@ -107,7 +108,7 @@ class similar_topics
++ 		$this->config_text = $config_text;
++ 		$this->db = $db;
++ 		$this->dispatcher = $dispatcher;
++-		$this->stop_word_helper = $stop_word_helper;
+++		$this->extension_manager = $extension_manager;
++ 		$this->language = $language;
++ 		$this->pagination = $pagination;
++ 		$this->request = $request;
++@@ -153,28 +154,6 @@ class similar_topics
++ 		return !empty($this->user->data['user_similar_topics']) && $this->auth->acl_get('u_similar_topics');
++ 	}
++ 
++-	/**
++-	 * Is dynamic similar topics available?
++-	 *
++-	 * @access public
++-	 * @return bool True if available, false otherwise
++-	 */
++-	public function is_dynamic_available()
++-	{
++-		return $this->is_dynamic_enabled() && $this->is_viewable() && $this->similartopics !== null;
++-	}
++-
++-	/**
++-	 * Is dynamic similar topics enabled?
++-	 *
++-	 * @access public
++-	 * @return bool True if enabled, false otherwise
++-	 */
++-	public function is_dynamic_enabled()
++-	{
++-		return !empty($this->config['similar_topics_dynamic']) && !empty($this->config['similar_topics_limit']);
++-	}
++-
++ 	/**
++ 	 * Get similar topics by matching topic titles
++ 	 * Loosely based on viewforum.php lines 840-1040
++@@ -194,9 +173,7 @@ class similar_topics
++ 			return;
++ 		}
++ 
++-		$this->stop_word_helper->set_use_localized($this->get_localized_ignore_words());
++-		$this->stop_word_helper->set_additional_ignore_words($this->get_additional_ignore_words());
++-		$topic_title = $this->stop_word_helper->clean_text($topic_data['topic_title']);
+++		$topic_title = $this->clean_topic_title($topic_data['topic_title']);
++ 
++ 		// If the cleaned up topic_title is empty, no need to continue
++ 		if (empty($topic_title))
++@@ -322,7 +299,6 @@ class similar_topics
++ 				$u_mcp_queue = ($topic_unapproved || $posts_unapproved) ? append_sid("{$this->root_path}mcp.$this->php_ext", 'i=queue&amp;mode=' . ($topic_unapproved ? 'approve_details' : 'unapproved_posts') . "&amp;t=$similar_topic_id", true, $this->user->session_id) : '';
++ 
++ 				$base_url = append_sid("{$this->root_path}viewtopic.$this->php_ext", $view_topic_url_params);
++-
++ 				$topic_row = array(
++ 					'TOPIC_AUTHOR_FULL'			=> get_username_string('full', $row['topic_poster'], $row['topic_first_poster_name'], $row['topic_first_poster_colour']),
++ 					'FIRST_POST_TIME'			=> $this->user->format_date($row['topic_time']),
++@@ -333,6 +309,7 @@ class similar_topics
++ 
++ 					'TOPIC_REPLIES'			=> $replies,
++ 					'TOPIC_VIEWS'			=> $row['topic_views'],
+++					'TOPIC_ANSWERED'		=> ($this->extension_manager->is_enabled('kinerity/bestanswer')) && $row['answer_post_id'] ? true : false,
++ 					'TOPIC_TITLE'			=> censor_text($row['topic_title']),
++ 					'FORUM_TITLE'			=> $row['forum_name'],
++ 
++@@ -377,7 +354,7 @@ class similar_topics
++ 			}
++ 		}
++ 
++-		$this->add_language();
+++		$this->language->add_lang('similar_topics', 'vse/similartopics');
++ 
++ 		$this->template->assign_vars(array(
++ 			'NEWEST_POST_IMG'	=> $this->user->img('icon_topic_newest', 'VIEW_NEWEST_POST'),
++@@ -388,96 +365,130 @@ class similar_topics
++ 	}
++ 
++ 	/**
++-	 * Add lang files for similar topics
+++	 * Clean topic title (and if needed, ignore-words)
++ 	 *
++-	 * @return void
+++	 * @access public
+++	 * @param string $text The topic title
+++	 * @return string The topic title
++ 	 */
++-	public function add_language()
+++	public function clean_topic_title($text)
++ 	{
++-		$this->language->add_lang('similar_topics', 'vse/similartopics');
++-	}
+++		// Strip quotes, ampersands
+++		$text = str_replace(array('&quot;', '&amp;'), '', $text);
+++
+++		// UTF Emojis
+++		$regex_emoticons = '/[\x{1F600}-\x{1F64F}]/u';
+++		$text = preg_replace($regex_emoticons, '', $text);
+++
+++		// Match Miscellaneous Symbols and Pictographs
+++		$regex_symbols = '/[\x{1F300}-\x{1F5FF}]/u';
+++		$text = preg_replace($regex_symbols, '', $text);
+++
+++		// Match Transport And Map Symbols
+++		$regex_transport = '/[\x{1F680}-\x{1F6FF}]/u';
+++		$text = preg_replace($regex_transport, '', $text);
+++
+++		// Match Miscellaneous Symbols
+++		$regex_misc = '/[\x{2600}-\x{26FF}]/u';
+++		$text = preg_replace($regex_misc, '', $text);
+++
+++		// Match Dingbats
+++		$regex_dingbats = '/[\x{2700}-\x{27BF}]/u';
+++		$text = preg_replace($regex_dingbats, '', $text);
+++
+++		$regex_bbemoji = '(:([-+_a-z0-9]+):(?!\\w|[^<>]*(?=>|</code>)))';
+++		$matches = [];
+++		preg_match_all($regex_bbemoji, $text, $matches);
+++		foreach ($matches[0] as $emoji) {
+++			$text = str_replace($emoji, '', $text);
+++		}
++ 
++-	/**
++-	 * Check if we should load localized ignore words
++-	 *
++-	 * @access protected
++-	 * @return bool True if non-English language or using a dbms with no stop-words
++-	 */
++-	protected function get_localized_ignore_words()
++-	{
++-		return !in_array($this->user->lang_name, ['en', 'en_us'], true) || !$this->similartopics->has_stopword_support();
+++		$text = trim($text);
+++
+++		if (!$this->english_lang() || $this->get_ignore_words())
+++		{
+++			$text = $this->strip_stop_words($text);
+++		}
+++
+++		return $text;
++ 	}
++ 
++ 	/**
++-	 * Search for similar topics via AJAX for dynamic suggestions
+++	 * Remove any non-english and/or custom defined ignore-words
++ 	 *
++-	 * @param string $query The search query
++-	 * @param int $forum_id The forum ID to search from
++-	 * @return array Array of similar topics
+++	 * @access protected
+++	 * @param string $text The topic title
+++	 * @return string The topic title
++ 	 */
++-	public function search_similar_topics_ajax($query, $forum_id = 0)
+++	protected function strip_stop_words($text)
++ 	{
++-		$this->stop_word_helper->set_use_localized($this->get_localized_ignore_words());
++-		$this->stop_word_helper->set_additional_ignore_words($this->get_additional_ignore_words());
++-		$cleaned_query = $this->stop_word_helper->clean_text($query);
+++		$words = array();
++ 
++-		if (empty($cleaned_query))
+++		// If non-English, look for a list of stop-words to be ignored
+++		// in either the core or the extension (deprecated from core)
+++		if (!$this->english_lang())
++ 		{
++-			return [];
+++			$finder = $this->extension_manager->get_finder();
+++			$search_ignore_words = $finder
+++				->set_extensions(array('vse/similartopics'))
+++				->prefix('search_ignore_words')
+++				->suffix(".$this->php_ext")
+++				->extension_directory("/language/{$this->user->lang_name}")
+++				->core_path("language/{$this->user->lang_name}/")
+++				->get_files();
+++			if (current($search_ignore_words))
+++			{
+++				include current($search_ignore_words);
+++			}
++ 		}
++ 
++-		$sensitivity = $this->config->offsetExists('similar_topics_sense') ? number_format($this->config['similar_topics_sense'] / 10, 1, '.', '') : '0.5';
++-		$sql_array = $this->similartopics->get_query(0, $cleaned_query, $this->config['similar_topics_time'], $sensitivity);
++-
++-		$similar_topic_forums = null;
++-		if ($forum_id > 0)
+++		if ($this->get_ignore_words())
++ 		{
++-			$sql = 'SELECT similar_topic_forums
++-				FROM ' . FORUMS_TABLE . '
++-				WHERE forum_id = ' . (int) $forum_id;
++-			$result = $this->db->sql_query($sql, 3600);
++-			$similar_topic_forums = $this->db->sql_fetchfield('similar_topic_forums');
++-			$this->db->sql_freeresult($result);
+++			// Merge any custom defined ignore words from the ACP to the stop-words array
+++			$words = array_merge($this->make_word_array($this->get_ignore_words()), $words);
++ 		}
++ 
++-		$passworded_forums = $this->user->get_passworded_forums();
+++		// Remove stop-words from the topic title text
+++		$words = array_diff($this->make_word_array($text), $words);
++ 
++-		if (!empty($similar_topic_forums))
++-		{
++-			$included_forums = array_diff(json_decode($similar_topic_forums, true), $passworded_forums);
++-			if (empty($included_forums))
++-			{
++-				return [];
++-			}
++-			$sql_array['WHERE'] .= ' AND ' . $this->db->sql_in_set('f.forum_id', $included_forums);
++-		}
++-		else
++-		{
++-			if (count($passworded_forums))
++-			{
++-				$sql_array['WHERE'] .= ' AND ' . $this->db->sql_in_set('f.forum_id', $passworded_forums, true);
++-			}
++-			$sql_array['WHERE'] .= ' AND f.similar_topics_ignore = 0';
++-		}
+++		// Convert our words array back to a string
+++		return implode(' ', $words);
+++	}
++ 
++-		$topics = [];
++-		$sql = $this->db->sql_build_query('SELECT', $sql_array);
++-		$result = $this->db->sql_query_limit($sql, 5);
+++	/**
+++	 * Helper function to split string into an array of words
+++	 *
+++	 * @access protected
+++	 * @param string $text String of plain text words
+++	 * @return array Array of plaintext words
+++	 */
+++	protected function make_word_array($text)
+++	{
+++		// Strip out any non-alpha-numeric characters using PCRE regex syntax
+++		$text = trim(preg_replace('#[^\p{L}\p{N}]+#u', ' ', $text));
++ 
++-		while ($row = $this->db->sql_fetchrow($result))
+++		$words = explode(' ', utf8_strtolower($text));
+++		foreach ($words as $key => $word)
++ 		{
++-			if ($this->auth->acl_get('f_read', (int) $row['forum_id']))
+++			// Strip words of 2 characters or fewer
+++			if (utf8_strlen(trim($word)) < 3)
++ 			{
++-				$topics[] = [
++-					'id' => (int) $row['topic_id'],
++-					'title' => censor_text($row['topic_title']),
++-					'url' => append_sid("{$this->root_path}viewtopic.$this->php_ext", 't=' . $row['topic_id'])
++-				];
+++				unset($words[$key]);
++ 			}
++ 		}
++-		$this->db->sql_freeresult($result);
++ 
++-		return $topics;
+++		return $words;
+++	}
+++
+++	/**
+++	 * Check if English is the current user's language
+++	 *
+++	 * @access protected
+++	 * @return bool True if lang is 'en' or 'en_us', false otherwise
+++	 */
+++	protected function english_lang()
+++	{
+++		return ($this->user->lang_name === 'en' || $this->user->lang_name === 'en_us');
++ 	}
++ 
++ 	/**
++@@ -486,7 +497,7 @@ class similar_topics
++ 	 * @access protected
++ 	 * @return string|null String of ignore words or null if there are none defined
++ 	 */
++-	protected function get_additional_ignore_words()
+++	protected function get_ignore_words()
++ 	{
++ 		$key = 'similar_topics_words';
++ 
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/core/stop_word_helper.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/core/stop_word_helper.php"
++deleted file mode 100644
++index 2af488e1a..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/core/stop_word_helper.php"
+++++ /dev/null
++@@ -1,198 +0,0 @@
++-<?php
++-/**
++- *
++- * Precise Similar Topics
++- *
++- * @copyright (c) 2025 Matt Friedman
++- * @license GNU General Public License, version 2 (GPL-2.0)
++- *
++- */
++-
++-namespace vse\similartopics\core;
++-
++-use phpbb\cache\driver\driver_interface as cache_driver;
++-use phpbb\extension\manager as ext_manager;
++-use phpbb\user;
++-
++-/**
++- * A helper class to clean text and remove stop words (localized and additional)
++- * for topic titles or other search-related strings.
++- */
++-class stop_word_helper
++-{
++-	/** @var cache_driver */
++-	protected $cache;
++-
++-	/** @var ext_manager */
++-	protected $extension_manager;
++-
++-	/** @var user */
++-	protected $user;
++-
++-	/** @var string */
++-	protected $php_ext;
++-
++-	/** @var array|null Lookup table for fast filtering */
++-	protected $ignore_lookup;
++-
++-	/** @var bool Whether localized ignore words should be loaded */
++-	protected $use_localized = false;
++-
++-	/** @var string Additional ignore words string */
++-	protected $additional_ignore = '';
++-
++-	/** @var bool Whether ignore words need to be reloaded */
++-	protected $needs_reload = true;
++-
++-	/**
++-	 * Constructor
++-	 *
++-	 * @param cache_driver $cache
++-	 * @param ext_manager $extension_manager
++-	 * @param user $user
++-	 * @param string $php_ext
++-	 */
++-	public function __construct(cache_driver $cache, ext_manager $extension_manager, user $user, $php_ext)
++-	{
++-		$this->cache = $cache;
++-		$this->extension_manager = $extension_manager;
++-		$this->user = $user;
++-		$this->php_ext = $php_ext;
++-	}
++-
++-	/**
++-	 * Set additional ignore words
++-	 *
++-	 * @param string $words
++-	 */
++-	public function set_additional_ignore_words($words)
++-	{
++-		if ($this->additional_ignore !== $words)
++-		{
++-			$this->additional_ignore = $words;
++-			$this->needs_reload = true;
++-		}
++-	}
++-
++-	/**
++-	 * Set whether to use localized ignore words
++-	 *
++-	 * @param bool $value
++-	 */
++-	public function set_use_localized($value)
++-	{
++-		$value = (bool) $value;
++-		if ($this->use_localized !== $value)
++-		{
++-			$this->use_localized = $value;
++-			$this->needs_reload = true;
++-		}
++-	}
++-
++-	/**
++-	 * Clean text (strip quotes, ampersands, stop words)
++-	 *
++-	 * @param string $text
++-	 * @return string
++-	 */
++-	public function clean_text($text)
++-	{
++-		// Strip HTML entities
++-		$text = str_replace(['&quot;', '&amp;'], '', $text);
++-
++-		if ($this->use_localized || !empty($this->additional_ignore))
++-		{
++-			$this->load_ignore_words();
++-			$filtered = array_filter(
++-				$this->make_word_array($text, true),
++-				[$this, 'filter_ignore_words']
++-			);
++-			$text = implode(' ', array_unique($filtered));
++-		}
++-
++-		return $text;
++-	}
++-
++-	/**
++-	 * Load ignore words into memory and build a lookup table
++-	 */
++-	protected function load_ignore_words()
++-	{
++-		if ($this->needs_reload || $this->ignore_lookup === null)
++-		{
++-			// The cache will be invalidated when language, localized setting, or additional words change
++-			$cache_key = '_pst_ignore_' . md5($this->user->lang_name . '|' . (int) $this->use_localized . '|' . $this->additional_ignore);
++-			$this->ignore_lookup = $this->cache->get($cache_key);
++-
++-			if ($this->ignore_lookup === false)
++-			{
++-				// Load localized ignore words (if needed)
++-				$words = $this->use_localized ? $this->load_localized_words() : [];
++-
++-				// Load additional ignore words (if defined)
++-				if (!empty($this->additional_ignore))
++-				{
++-					$words = array_merge($words, $this->make_word_array($this->additional_ignore));
++-				}
++-
++-				$this->ignore_lookup = array_flip(array_unique($words));
++-				$this->cache->put($cache_key, $this->ignore_lookup);
++-			}
++-
++-			$this->needs_reload = false;
++-		}
++-	}
++-
++-	/**
++-	 * Load localized ignore words
++-	 *
++-	 * @return array An array of ignore-words from the user's language pack
++-	 */
++-	protected function load_localized_words()
++-	{
++-		$words = [];
++-		$finder = $this->extension_manager->get_finder();
++-		$files = $finder
++-			->set_extensions(['vse/similartopics'])
++-			->prefix('search_ignore_words')
++-			->suffix('.' . $this->php_ext)
++-			->extension_directory("/language/{$this->user->lang_name}")
++-			->core_path("language/{$this->user->lang_name}/")
++-			->get_files();
++-
++-		if (current($files))
++-		{
++-			include current($files);
++-		}
++-
++-		return $words;
++-	}
++-
++-	/**
++-	 * Split text into a word array
++-	 *
++-	 * @param string $text A string of text
++-	 * @param bool $filter_short Whether to filter out words < 3 characters
++-	 * @return array The original string of text, filtered into an array of individual words
++-	 */
++-	protected function make_word_array($text, $filter_short = false)
++-	{
++-		$text = trim(preg_replace('#[^\p{L}\p{N}]+#u', ' ', $text));
++-		$words = array_filter(explode(' ', utf8_strtolower($text)));
++-
++-		return $filter_short ? array_filter($words, static function($word) {
++-			return utf8_strlen($word) >= 3;
++-		}) : $words;
++-	}
++-
++-	/**
++-	 * Filter callback for array_filter to exclude stop words
++-	 *
++-	 * @param string $word Word to check
++-	 * @return bool True to keep a word, false to remove it
++-	 */
++-	protected function filter_ignore_words($word)
++-	{
++-		return !isset($this->ignore_lookup[$word]);
++-	}
++-}
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/diff_full.tmp"
++new file mode 100644
++index 000000000..1c7e2258d
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/diff_full.tmp"
++@@ -0,0 +1,974 @@
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/CHANGELOG.md" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/CHANGELOG.md"
+++index dcfad82c4..378efc1d0 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/CHANGELOG.md"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/CHANGELOG.md"
+++@@ -1,18 +1,10 @@
+++ ## Changelog
+++ 
+++-### 1.7.0 - 2025-12-16
+++-
+++-- NEW FEATURE: Dynamically show similar topics to users as they title their new posts.
+++-- IMPROVEMENT: Support for MSSQL, SQLite3 and Oracle databases added.
+++-- IMPROVEMENT: Added stop-word filtering for Postgres databases using the 'simple' dictionary.
+++-- Added missing stop-word filters (AI-translated) for Hebrew, Persian, Japanese, Swedish and Turkish languages.
+++-- Fixed and optimized lots of code when processing similar topics.
+++-
+++ ### 1.6.0 - 2022-12-17
+++ 
+++ - Removed support for phpBB 3.1.x.
+++ - Removed forum "f=" parameters from URLs.
+++-- Optimized JavaScript and other coding updates.
++++- Optimized Javascript and other coding updates.
+++ - Support added for ScaffoldBB style.
+++ 
+++ ### 1.5.4 - 2020-12-01
+++@@ -20,11 +12,11 @@
+++ - Fix for Postgresql databases where titles with single quotes would fatally error.
+++ - Enabled AJAX interactions when saving settings in the ACP.
+++ - Re-wrote the search period explanation in the ACP settings.
+++-- Switched to using the phpBB finder to locate foreign language ignore words files.
++++- Switched to using phpBB finder to locate foreign language ignore words files.
+++ 
+++ ### 1.5.3 - 2020-01-10
+++ 
+++-- Compatibility issues with Prosilver styles are addressed.
++++- Compatibility issues with Prosilver styles addressed.
+++ - Installation errors on phpBB 3.3.x will be reported to the user.
+++ 
+++ ### 1.5.2 - 2019-06-26
+++@@ -35,18 +27,18 @@
+++ 
+++ ### 1.5.1 - 2018-06-01
+++ 
+++-- Fixed an issue where PHP using European decimal notation (comma instead of a period) could cause an SQL error.
+++-- Minor code fixes based on the phpBB Extension team validation report.
++++- Fixed an issue where PHP using European decimal notation (comma instead of period) could cause an SQL error.
++++- Minor code fixes based on phpBB Extension team validation report.
+++ 
+++ ### 1.5.0 - 2018-03-14
+++ 
+++ - Added support for forums using PostgreSQL databases (with thanks to hubaishan).
+++ - Fixed a layout bug with the pagination buttons introduced in phpBB 3.2.2.
+++-- Fixed a potential SQL error bug when installing.
++++- Fixed potential SQL error bug when installing.
+++ 
+++ ### 1.4.3 - 2018-01-03
+++ 
+++-- Added a new setting: Search Sensitivity. Allows users to adjust the weighting of similar topics matches. This was added because InnoDB, which is now supported, weights results differently than MyISAM. This will allow users with InnoDB tables to improve their similar topics results by lowering the weighting/sensitivity.
++++- Added a new setting: Search Sensitivity. Allows users to adjust the weighting of similar topics matches. This was added because InnoDB which is now supported, weights results differently than MyISAM. This will allow users with InnoDB tables to improve their similar topics results by lowering the weighting/sensitivity.
+++ - Converted all template syntax to Twig format.
+++ 
+++ ### 1.4.2 - 2017-03-18
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/acp/controller/similar_topics_admin.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/acp/controller/similar_topics_admin.php"
+++index 85c505289..4e2b5441e 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/acp/controller/similar_topics_admin.php"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/acp/controller/similar_topics_admin.php"
+++@@ -157,7 +157,6 @@ class similar_topics_admin
+++ 
+++ 			// Set basic config settings
+++ 			$this->config->set('similar_topics', $this->request->variable('pst_enable', 0));
+++-			$this->config->set('similar_topics_dynamic', $this->request->variable('pst_dynamic', 0));
+++ 			$this->config->set('similar_topics_limit', abs($this->request->variable('pst_limit', 0))); // use abs for positive values only
+++ 			$this->config->set('similar_topics_cache', abs($this->request->variable('pst_cache', 0))); // use abs for positive values only
+++ 			$this->config_text_set('similar_topics_words', $this->request->variable('pst_words', '', true));
+++@@ -209,22 +208,20 @@ class similar_topics_admin
+++ 
+++ 		$this->template->assign_vars(array(
+++ 			'S_PST_ENABLE'    => $this->isset_or_default($this->config['similar_topics'], false),
+++-			'S_PST_DYNAMIC'   => $this->isset_or_default($this->config['similar_topics_dynamic'], false),
+++ 			'PST_LIMIT'       => $this->isset_or_default($this->config['similar_topics_limit'], ''),
+++ 			'PST_CACHE'       => $this->isset_or_default($this->config['similar_topics_cache'], ''),
+++ 			'PST_SENSE'       => $this->isset_or_default($this->config['similar_topics_sense'], ''),
+++ 			'PST_WORDS'       => $this->isset_or_default($this->config_text_get('similar_topics_words'), ''),
+++ 			'PST_TIME'        => $this->get_pst_time($this->config['similar_topics_time'], $this->config['similar_topics_type']),
+++-			'PST_SENSITIVITY' => $this->similartopics && $this->similartopics->get_engine() === 'innodb' ? 1 : 5,
+++ 			'S_PST_NO_COMPAT' => $this->similartopics === null || !$this->similartopics->is_fulltext('topic_title'),
+++ 			'U_ACTION'        => $this->u_action,
+++ 		));
+++ 
+++ 		// If postgresql, we need to make an options list of text search names
+++-		if ($this->similartopics instanceof \vse\similartopics\driver\postgres)
++++		if ($this->similartopics && $this->similartopics->get_type() === 'postgres')
+++ 		{
+++ 			$this->language->add_lang('acp/search');
+++-			foreach ($this->similartopics->get_cfg_name_list() as $row)
++++			foreach ($this->get_cfgname_list() as $row)
+++ 			{
+++ 				$this->template->assign_block_vars('postgres_ts_names', array(
+++ 					'NAME'       => $row['ts_name'],
+++@@ -269,8 +266,6 @@ class similar_topics_admin
+++ 				WHERE forum_id = $forum_id";
+++ 			$this->db->sql_query($sql);
+++ 
+++-			$this->cache->destroy('sql', FORUMS_TABLE);
+++-
+++ 			$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'PST_LOG_MSG');
+++ 
+++ 			$this->end('PST_SAVED');
+++@@ -315,6 +310,22 @@ class similar_topics_admin
+++ 		}
+++ 	}
+++ 
++++	/**
++++	 * Get list of PostgreSQL text search names
++++	 *
++++	 * @access protected
++++	 * @return array array of text search names
++++	 */
++++	protected function get_cfgname_list()
++++	{
++++		$sql = 'SELECT cfgname AS ts_name FROM pg_ts_config';
++++		$result = $this->db->sql_query($sql);
++++		$ts_options = $this->db->sql_fetchrowset($result);
++++		$this->db->sql_freeresult($result);
++++
++++		return $ts_options;
++++	}
++++
+++ 	/**
+++ 	 * Get forums list
+++ 	 *
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/acp/similar_topics_module.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/acp/similar_topics_module.php"
+++index 8e9408fa8..e0a74e17d 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/acp/similar_topics_module.php"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/acp/similar_topics_module.php"
+++@@ -32,7 +32,9 @@ class similar_topics_module
+++ 		global $phpbb_container;
+++ 
+++ 		$this->tpl_name = 'acp_similar_topics';
+++-		$this->page_title = 'PST_TITLE_ACP';
++++
++++		$this->page_title = $phpbb_container->get('language')
++++			->lang('PST_TITLE_ACP');
+++ 
+++ 		$phpbb_container->get('vse.similartopics.acp.controller')
+++ 			->set_u_action($this->u_action)
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/adm/style/acp_similar_topics.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/adm/style/acp_similar_topics.html"
+++index 8f0c529db..0be73ff9f 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/adm/style/acp_similar_topics.html"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/adm/style/acp_similar_topics.html"
+++@@ -20,13 +20,13 @@
+++ 	<fieldset>
+++ 		<legend>{{ lang('PST_ADVANCED_FORUM') }}</legend>
+++ 		<dl>
+++-			<dt><label for="similar_forums">{{ lang('FORUM') ~ lang('COLON') }} {{ PST_FORUM_NAME }}</label><br><br><span>{{ lang('PST_ADVANCED_EXP', PST_FORUM_NAME) }}</span></dt>
++++			<dt><label for="similar_forums">{{ lang('FORUM') ~ lang('COLON') }} {{ PST_FORUM_NAME }}</label><br /><br /><span>{{ lang('PST_ADVANCED_EXP', PST_FORUM_NAME) }}</span></dt>
+++ 			<dd><select id="similar_forums" name="similar_forums_id[]" multiple="multiple" size="10">{{ SIMILAR_FORUMS_OPTIONS }}</select></dd>
+++ 			<dd><a href="#" data-selector="false">{{ lang('PST_DESELECT_ALL') }}</a></dd>
+++ 		</dl>
+++ 		<p class="submit-buttons">
+++-			<input class="button1" type="submit" id="submit" name="submit" value="{{ lang('SUBMIT') }}">&nbsp;
+++-			<input class="button2" type="reset" id="reset" name="reset" value="{{ lang('RESET') }}">
++++			<input class="button1" type="submit" id="submit" name="submit" value="{{ lang('SUBMIT') }}" />&nbsp;
++++			<input class="button2" type="reset" id="reset" name="reset" value="{{ lang('RESET') }}" />
+++ 		</p>
+++ 		{{ S_FORM_TOKEN }}
+++ 	</fieldset>
+++@@ -47,17 +47,10 @@
+++ 	<fieldset>
+++ 		<legend>{{ lang('PST_LEGEND1') }}</legend>
+++ 		<dl>
+++-			<dt><label for="pst_enable">{{ lang('PST_ENABLE') ~ lang('COLON') }}</label><br><span>{{ lang('PST_ENABLE_EXPLAIN') }}</span></dt>
++++			<dt><label for="pst_enable">{{ lang('PST_ENABLE') ~ lang('COLON') }}</label></dt>
+++ 			<dd>
+++-				<label><input type="radio" class="radio" id="pst_enable" name="pst_enable" value="1"{% if S_PST_ENABLE %} checked="checked"{% endif %}{% if S_PST_NO_SUPPORT %} disabled="disabled"{% endif %}> {{ lang('YES') }}</label>
+++-				<label><input type="radio" class="radio" name="pst_enable" value="0"{% if not S_PST_ENABLE %} checked="checked"{% endif %}> {{ lang('NO') }}</label>
+++-			</dd>
+++-		</dl>
+++-		<dl>
+++-			<dt><label for="pst_dynamic">{{ lang('PST_DYNAMIC') ~ lang('COLON') }}</label><br><span>{{ lang('PST_DYNAMIC_EXPLAIN') }}</span></dt>
+++-			<dd>
+++-				<label><input type="radio" class="radio" id="pst_dynamic" name="pst_dynamic" value="1"{% if S_PST_DYNAMIC %} checked="checked"{% endif %}> {{ lang('YES') }}</label>
+++-				<label><input type="radio" class="radio" name="pst_dynamic" value="0"{% if not S_PST_DYNAMIC %} checked="checked"{% endif %}> {{ lang('NO') }}</label>
++++				<label><input type="radio" class="radio" id="pst_enable" name="pst_enable" value="1"{% if S_PST_ENABLE %} checked="checked"{% endif %}{% if S_PST_NO_SUPPORT %} disabled="disabled"{% endif %} /> {{ lang('YES') }}</label>
++++				<label><input type="radio" class="radio" name="pst_enable" value="0"{% if not S_PST_ENABLE %} checked="checked"{% endif %} /> {{ lang('NO') }}</label>
+++ 			</dd>
+++ 		</dl>
+++ 	</fieldset>
+++@@ -65,12 +58,12 @@
+++ 	<fieldset>
+++ 		<legend>{{ lang('PST_LEGEND2') }}</legend>
+++ 		<dl>
+++-			<dt><label for="pst_limit">{{ lang('PST_LIMIT') ~ lang('COLON') }}</label><br><span>{{ lang('PST_LIMIT_EXPLAIN') }}</span></dt>
+++-			<dd><input name="pst_limit" id="pst_limit" type="number" min="0" max="999" value="{{ PST_LIMIT }}"></dd>
++++			<dt><label for="pst_limit">{{ lang('PST_LIMIT') ~ lang('COLON') }}</label><br /><span>{{ lang('PST_LIMIT_EXPLAIN') }}</span></dt>
++++			<dd><input name="pst_limit" id="pst_limit" type="number" min="0" max="999" value="{{ PST_LIMIT }}" /></dd>
+++ 		</dl>
+++ 		<dl>
+++-			<dt><label for="pst_time">{{ lang('PST_TIME') ~ lang('COLON') }}</label><br><span>{{ lang('PST_TIME_EXPLAIN') }}</span></dt>
+++-			<dd><input name="pst_time" id="pst_time" type="number" min="0" max="999" value="{{ PST_TIME }}">
++++			<dt><label for="pst_time">{{ lang('PST_TIME') ~ lang('COLON') }}</label><br /><span>{{ lang('PST_TIME_EXPLAIN') }}</span></dt>
++++			<dd><input name="pst_time" id="pst_time" type="number" min="0" max="999" value="{{ PST_TIME }}" />
+++ 				<label>
+++ 					<select name="pst_time_type">
+++ 						{% for similar_time_options in loops.similar_time_options %}
+++@@ -81,12 +74,12 @@
+++ 			</dd>
+++ 		</dl>
+++ 		<dl>
+++-			<dt><label for="pst_cache">{{ lang('PST_CACHE') ~ lang('COLON') }}</label><br><span>{{ lang('PST_CACHE_EXPLAIN') }}</span></dt>
+++-			<dd><input name="pst_cache" id="pst_cache" type="number" min="0" max="99999999" value="{{ PST_CACHE }}"> {{ lang('SECONDS') }}</dd>
++++			<dt><label for="pst_cache">{{ lang('PST_CACHE') ~ lang('COLON') }}</label><br /><span>{{ lang('PST_CACHE_EXPLAIN') }}</span></dt>
++++			<dd><input name="pst_cache" id="pst_cache" type="number" min="0" max="99999999" value="{{ PST_CACHE }}" /> {{ lang('SECONDS') }}</dd>
+++ 		</dl>
+++ 		<dl>
+++-			<dt><label for="pst_sense">{{ lang('PST_SENSE') ~ lang('COLON') }}</label><br><span>{{ lang('PST_SENSE_EXPLAIN', PST_SENSITIVITY) }}</span></dt>
+++-			<dd><input name="pst_sense" id="pst_sense" type="number" min="1" max="10" value="{{ PST_SENSE }}"></dd>
++++			<dt><label for="pst_sense">{{ lang('PST_SENSE') ~ lang('COLON') }}</label><br /><span>{{ lang('PST_SENSE_EXPLAIN') }}</span></dt>
++++			<dd><input name="pst_sense" id="pst_sense" type="number" min="1" max="10" value="{{ PST_SENSE }}" /></dd>
+++ 		</dl>
+++ 	</fieldset>
+++ 
+++@@ -96,7 +89,7 @@
+++ 			<span class="small">{{ lang('PST_FORUM_INFO') }}</span>
+++ 			<div style="overflow: auto; max-height: 300px;">
+++ 				<table class="table1">
+++-					<colgroup><col class="row1"><col class="row2"><col class="row1"><col class="row2"></colgroup>
++++					<colgroup><col class="row1" /><col class="row2" /><col class="row1" /><col class="row2" /></colgroup>
+++ 					<thead>
+++ 						<tr>
+++ 							<th>{{ lang('FORUMS') }}</th>
+++@@ -111,18 +104,18 @@
+++ 							<td>
+++ 								<strong><a href="{{ forums.U_FORUM }}">{{ forums.FORUM_NAME }}</a></strong>
+++ 							</td>
+++-							<td style="text-align: center; width: 20%;" title="{{ lang('PST_NOSHOW_TITLE')|e('html_attr') }} {{ forums.FORUM_NAME|e('html_attr') }}">
++++							<td style="text-align: center; width: 20%;" title="{{ lang('PST_NOSHOW_TITLE') }} {{ forums.FORUM_NAME }}">
+++ 								<label>
+++-									<input type="checkbox" class="radio" name="mark_noshow_forum[]" value="{{ forums.FORUM_ID }}" {{ forums.CHECKED_NOSHOW_FORUM }}>
++++									<input type="checkbox" class="radio" name="mark_noshow_forum[]" value="{{ forums.FORUM_ID }}" {{ forums.CHECKED_NOSHOW_FORUM }} />
+++ 								</label>
+++ 							</td>
+++-							<td style="text-align: center; width: 20%;" title="{{ lang('PST_IGNORE_TITLE')|e('html_attr') }} {{ forums.FORUM_NAME|e('html_attr') }}">
++++							<td style="text-align: center; width: 20%;" title="{{ lang('PST_IGNORE_TITLE') }} {{ forums.FORUM_NAME }}">
+++ 								<label>
+++-									<input type="checkbox" class="radio" name="mark_ignore_forum[]" value="{{ forums.FORUM_ID }}" {{ forums.CHECKED_IGNORE_FORUM }}>
++++									<input type="checkbox" class="radio" name="mark_ignore_forum[]" value="{{ forums.FORUM_ID }}" {{ forums.CHECKED_IGNORE_FORUM }} />
+++ 								</label>
+++ 							</td>
+++-							<td style="text-align: center; width: 20%;" title="{{ lang('PST_ADVANCED_TITLE')|e('html_attr') }} {{ forums.FORUM_NAME|e('html_attr') }}">
+++-							<a href="{{ forums.U_ADVANCED }}">{% if forums.S_IS_ADVANCED %}<strong>{{ lang('PST_ADVANCED') }}</strong>{% else %}{{ lang('PST_STANDARD') }}{% endif %}</a>
++++							<td style="text-align: center; width: 20%;" title="{{ lang('PST_ADVANCED_TITLE') }} {{ forums.FORUM_NAME }}">
++++							<a href="{{ forums.U_ADVANCED }}">{% if forums.S_IS_ADVANCED %}<strong>{{ lang('PST_ADVANCED') }}</strong>{% else %}{{ lang('PST_STANDARD') }}</a>{% endif %}
+++ 							</td>
+++ 						</tr>
+++ 						{% endfor %}
+++@@ -135,12 +128,12 @@
+++ 	<fieldset>
+++ 		<legend>{{ lang('PST_LEGEND4') }}</legend>
+++ 		<dl>
+++-			<dt><label for="pst_words">{{ lang('PST_WORDS') ~ lang('COLON') }}</label><br><span>{{ lang('PST_WORDS_EXPLAIN') }}</span></dt>
++++			<dt><label for="pst_words">{{ lang('PST_WORDS') ~ lang('COLON') }}</label><br /><span>{{ lang('PST_WORDS_EXPLAIN') }}</span></dt>
+++ 			<dd><textarea name="pst_words" id="pst_words" rows="5" cols="40">{{ PST_WORDS }}</textarea></dd>
+++ 		</dl>
+++ 		{% if loops.postgres_ts_names %}
+++ 			<dl>
+++-				<dt><label for="pst_postgres_ts_name">{{ lang('FULLTEXT_POSTGRES_TS_NAME') }}</label><br><span>{{ lang('FULLTEXT_POSTGRES_TS_NAME_EXPLAIN') }}</span></dt>
++++				<dt><label for="pst_postgres_ts_name">{{ lang('FULLTEXT_POSTGRES_TS_NAME') }}</label><br /><span>{{ lang('FULLTEXT_POSTGRES_TS_NAME_EXPLAIN') }}</span></dt>
+++ 				<dd>
+++ 					<select name="pst_postgres_ts_name" id="pst_postgres_ts_name">
+++ 						{% for ts_name in loops.postgres_ts_names %}
+++@@ -155,8 +148,8 @@
+++ 	<fieldset>
+++ 		<legend>{{ lang('ACP_SUBMIT_CHANGES') }}</legend>
+++ 		<p class="submit-buttons">
+++-			<input class="button1" type="submit" id="submit" name="submit" value="{{ lang('SUBMIT') }}">&nbsp;
+++-			<input class="button2" type="reset" id="reset" name="reset" value="{{ lang('RESET') }}">
++++			<input class="button1" type="submit" id="submit" name="submit" value="{{ lang('SUBMIT') }}" />&nbsp;
++++			<input class="button2" type="reset" id="reset" name="reset" value="{{ lang('RESET') }}" />
+++ 		</p>
+++ 		{{ S_FORM_TOKEN }}
+++ 	</fieldset>
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/composer.json"
+++index 19c72b2a6..c5613f687 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/composer.json"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/composer.json"
+++@@ -3,7 +3,7 @@
+++     "type": "phpbb-extension",
+++     "description": "A phpBB extension that displays a list of similar (related) topics at the bottom of the current topic's page.",
+++     "homepage": "https://github.com/iMattPro/similartopics",
+++-    "version": "1.7.0",
++++    "version": "1.6.0",
+++     "keywords": [
+++         "phpbb",
+++         "extension",
+++@@ -20,7 +20,7 @@
+++     ],
+++     "require": {
+++         "php": ">=5.4",
+++-        "composer/installers": "~1.0",
++++        "composer/installers": "~1.0.0",
+++         "phpbb/phpbb": ">=3.2.1"
+++     },
+++     "extra": {
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/config/routing.yml" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/config/routing.yml"
+++deleted file mode 100644
+++index 3a3d08730..000000000
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/config/routing.yml"
++++++ /dev/null
+++@@ -1,6 +0,0 @@
+++-vse_similartopics_ajax_search:
+++-    path: /similartopics/ajax/search
+++-    defaults: { _controller: vse.similartopics.ajax.controller:search_similar_topics }
+++-    methods: [GET]
+++-    requirements:
+++-        _format: json
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/config/services.yml" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/config/services.yml"
+++index 9acfe7b01..8d651ffcd 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/config/services.yml"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/config/services.yml"
+++@@ -8,13 +8,13 @@ services:
+++             - '@config_text'
+++             - '@dbal.conn'
+++             - '@dispatcher'
++++            - '@ext.manager'
+++             - '@language'
+++             - '@pagination'
+++             - '@request'
+++             - '@template'
+++             - '@user'
+++             - '@content.visibility'
+++-            - '@vse.similartopics.stop_word_helper'
+++             - '@vse.similartopics.driver.manager'
+++             - '%core.root_path%'
+++             - '%core.php_ext%'
+++@@ -23,8 +23,6 @@ services:
+++         class: vse\similartopics\event\listener
+++         arguments:
+++             - '@vse.similartopics.manager'
+++-            - '@controller.helper'
+++-            - '@template'
+++         tags:
+++             - { name: event.listener }
+++ 
+++@@ -61,28 +59,13 @@ services:
+++             - '%core.root_path%'
+++             - '%core.php_ext%'
+++ 
+++-    vse.similartopics.stop_word_helper:
+++-        class: vse\similartopics\core\stop_word_helper
+++-        public: false
+++-        arguments:
+++-            - '@cache.driver'
+++-            - '@ext.manager'
+++-            - '@user'
+++-            - '%core.php_ext%'
+++-
+++-    vse.similartopics.ajax.controller:
+++-        class: vse\similartopics\controller\ajax_controller
+++-        arguments:
+++-            - '@request'
+++-            - '@vse.similartopics.manager'
+++-
+++ # ----- Similar topics DB drivers collection -----
+++     vse.similartopics.driver_collection:
+++         class: phpbb\di\service_collection
+++         arguments:
+++             - '@service_container'
+++         tags:
+++-            - { name: service_collection, tag: vse.similartopics.driver }
++++            - { name: service_collection, tag: vse.similartopcs.driver }
+++ 
+++     vse.similartopics.driver.postgres:
+++         class: vse\similartopics\driver\postgres
+++@@ -90,50 +73,17 @@ services:
+++             - '@dbal.conn'
+++             - '@config'
+++         tags:
+++-            - { name: vse.similartopics.driver }
++++            - { name: vse.similartopcs.driver }
+++ 
+++     vse.similartopics.driver.mysqli:
+++         class: vse\similartopics\driver\mysqli
+++         arguments:
+++             - '@dbal.conn'
+++         tags:
+++-            - { name: vse.similartopics.driver }
++++            - { name: vse.similartopcs.driver }
+++ 
+++     vse.similartopics.driver.mysql4:
+++         class: vse\similartopics\driver\mysql4
+++         parent: vse.similartopics.driver.mysqli
+++         tags:
+++-            - { name: vse.similartopics.driver }
+++-
+++-    vse.similartopics.driver.sqlite3:
+++-        class: vse\similartopics\driver\sqlite3
+++-        arguments:
+++-            - '@dbal.conn'
+++-        tags:
+++-            - { name: vse.similartopics.driver }
+++-
+++-    vse.similartopics.driver.mssql:
+++-        class: vse\similartopics\driver\mssql
+++-        arguments:
+++-            - '@dbal.conn'
+++-        tags:
+++-            - { name: vse.similartopics.driver }
+++-
+++-    vse.similartopics.driver.mssqlnative:
+++-        class: vse\similartopics\driver\mssqlnative
+++-        parent: vse.similartopics.driver.mssql
+++-        tags:
+++-            - { name: vse.similartopics.driver }
+++-
+++-    vse.similartopics.driver.mssql_odbc:
+++-        class: vse\similartopics\driver\mssql_odbc
+++-        parent: vse.similartopics.driver.mssql
+++-        tags:
+++-            - { name: vse.similartopics.driver }
+++-
+++-    vse.similartopics.driver.oracle:
+++-        class: vse\similartopics\driver\oracle
+++-        arguments:
+++-            - '@dbal.conn'
+++-        tags:
+++-            - { name: vse.similartopics.driver }
++++            - { name: vse.similartopcs.driver }
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/controller/ajax_controller.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/controller/ajax_controller.php"
+++deleted file mode 100644
+++index d49f853f1..000000000
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/controller/ajax_controller.php"
++++++ /dev/null
+++@@ -1,63 +0,0 @@
+++-<?php
+++-/**
+++- *
+++- * Precise Similar Topics
+++- *
+++- * @copyright (c) 2025 Matt Friedman
+++- * @license GNU General Public License, version 2 (GPL-2.0)
+++- *
+++- */
+++-
+++-namespace vse\similartopics\controller;
+++-
+++-use phpbb\exception\http_exception;
+++-use Symfony\Component\HttpFoundation\JsonResponse;
+++-use phpbb\request\request;
+++-use vse\similartopics\core\similar_topics;
+++-
+++-class ajax_controller
+++-{
+++-	/** @var request */
+++-	protected $request;
+++-
+++-	/** @var similar_topics */
+++-	protected $similar_topics;
+++-
+++-	/**
+++-	 * Constructor
+++-	 *
+++-	 * @param request $request
+++-	 * @param similar_topics $similar_topics
+++-	 */
+++-	public function __construct(request $request, similar_topics $similar_topics)
+++-	{
+++-		$this->request = $request;
+++-		$this->similar_topics = $similar_topics;
+++-	}
+++-
+++-	/**
+++-	 * Handle AJAX request for similar topics search
+++-	 *
+++-	 * @return JsonResponse
+++-	 * @throws http_exception
+++-	 */
+++-	public function search_similar_topics()
+++-	{
+++-		if (!$this->request->is_ajax())
+++-		{
+++-			throw new http_exception(403, 'NO_AUTH_OPERATION');
+++-		}
+++-
+++-		$query = $this->request->variable('q', '', true);
+++-		$forum_id = $this->request->variable('f', 0);
+++-
+++-		if (utf8_strlen($query) < 3 || !$this->similar_topics->is_dynamic_available())
+++-		{
+++-			return new JsonResponse(['topics' => []]);
+++-		}
+++-
+++-		$topics = $this->similar_topics->search_similar_topics_ajax($query, $forum_id);
+++-
+++-		return new JsonResponse(['topics' => $topics]);
+++-	}
+++-}
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/core/similar_topics.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/core/similar_topics.php"
+++index 72de4b84e..946730c0f 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/core/similar_topics.php"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/core/similar_topics.php"
+++@@ -17,6 +17,7 @@ use phpbb\config\db_text;
+++ use phpbb\content_visibility;
+++ use phpbb\db\driver\driver_interface as db;
+++ use phpbb\event\dispatcher_interface as dispatcher;
++++use phpbb\extension\manager as ext_manager;
+++ use phpbb\language\language;
+++ use phpbb\pagination;
+++ use phpbb\request\request;
+++@@ -45,6 +46,9 @@ class similar_topics
+++ 	/** @var dispatcher */
+++ 	protected $dispatcher;
+++ 
++++	/** @var ext_manager */
++++	protected $extension_manager;
++++
+++ 	/** @var language */
+++ 	protected $language;
+++ 
+++@@ -63,9 +67,6 @@ class similar_topics
+++ 	/** @var content_visibility */
+++ 	protected $content_visibility;
+++ 
+++-	/** @var stop_word_helper */
+++-	protected $stop_word_helper;
+++-
+++ 	/** @var similartopics_driver */
+++ 	protected $similartopics;
+++ 
+++@@ -84,22 +85,22 @@ class similar_topics
+++ 	 * @access public
+++ 	 * @param auth                  $auth
+++ 	 * @param cache                 $cache
+++-	 * @param config                 $config
++++	 * @param config                $config
+++ 	 * @param db_text               $config_text
+++ 	 * @param db                    $db
+++ 	 * @param dispatcher            $dispatcher
++++	 * @param ext_manager           $extension_manager
+++ 	 * @param language              $language
+++ 	 * @param pagination            $pagination
+++ 	 * @param request               $request
+++ 	 * @param template              $template
+++ 	 * @param user                  $user
+++ 	 * @param content_visibility    $content_visibility
+++-	 * @param stop_word_helper      $stop_word_helper
+++ 	 * @param similartopics_manager $similartopics_manager
+++ 	 * @param string                $root_path
+++ 	 * @param string                $php_ext
+++ 	 */
+++-	public function __construct(auth $auth, cache $cache, config $config, db_text $config_text, db $db, dispatcher $dispatcher, language $language, pagination $pagination, request $request, template $template, user $user, content_visibility $content_visibility, stop_word_helper $stop_word_helper, similartopics_manager $similartopics_manager, $root_path, $php_ext)
++++	public function __construct(auth $auth, cache $cache, config $config, db_text $config_text, db $db, dispatcher $dispatcher, ext_manager $extension_manager, language $language, pagination $pagination, request $request, template $template, user $user, content_visibility $content_visibility, similartopics_manager $similartopics_manager, $root_path, $php_ext)
+++ 	{
+++ 		$this->auth = $auth;
+++ 		$this->cache = $cache;
+++@@ -107,7 +108,7 @@ class similar_topics
+++ 		$this->config_text = $config_text;
+++ 		$this->db = $db;
+++ 		$this->dispatcher = $dispatcher;
+++-		$this->stop_word_helper = $stop_word_helper;
++++		$this->extension_manager = $extension_manager;
+++ 		$this->language = $language;
+++ 		$this->pagination = $pagination;
+++ 		$this->request = $request;
+++@@ -153,28 +154,6 @@ class similar_topics
+++ 		return !empty($this->user->data['user_similar_topics']) && $this->auth->acl_get('u_similar_topics');
+++ 	}
+++ 
+++-	/**
+++-	 * Is dynamic similar topics available?
+++-	 *
+++-	 * @access public
+++-	 * @return bool True if available, false otherwise
+++-	 */
+++-	public function is_dynamic_available()
+++-	{
+++-		return $this->is_dynamic_enabled() && $this->is_viewable() && $this->similartopics !== null;
+++-	}
+++-
+++-	/**
+++-	 * Is dynamic similar topics enabled?
+++-	 *
+++-	 * @access public
+++-	 * @return bool True if enabled, false otherwise
+++-	 */
+++-	public function is_dynamic_enabled()
+++-	{
+++-		return !empty($this->config['similar_topics_dynamic']) && !empty($this->config['similar_topics_limit']);
+++-	}
+++-
+++ 	/**
+++ 	 * Get similar topics by matching topic titles
+++ 	 * Loosely based on viewforum.php lines 840-1040
+++@@ -194,9 +173,7 @@ class similar_topics
+++ 			return;
+++ 		}
+++ 
+++-		$this->stop_word_helper->set_use_localized($this->get_localized_ignore_words());
+++-		$this->stop_word_helper->set_additional_ignore_words($this->get_additional_ignore_words());
+++-		$topic_title = $this->stop_word_helper->clean_text($topic_data['topic_title']);
++++		$topic_title = $this->clean_topic_title($topic_data['topic_title']);
+++ 
+++ 		// If the cleaned up topic_title is empty, no need to continue
+++ 		if (empty($topic_title))
+++@@ -322,7 +299,6 @@ class similar_topics
+++ 				$u_mcp_queue = ($topic_unapproved || $posts_unapproved) ? append_sid("{$this->root_path}mcp.$this->php_ext", 'i=queue&amp;mode=' . ($topic_unapproved ? 'approve_details' : 'unapproved_posts') . "&amp;t=$similar_topic_id", true, $this->user->session_id) : '';
+++ 
+++ 				$base_url = append_sid("{$this->root_path}viewtopic.$this->php_ext", $view_topic_url_params);
+++-
+++ 				$topic_row = array(
+++ 					'TOPIC_AUTHOR_FULL'			=> get_username_string('full', $row['topic_poster'], $row['topic_first_poster_name'], $row['topic_first_poster_colour']),
+++ 					'FIRST_POST_TIME'			=> $this->user->format_date($row['topic_time']),
+++@@ -333,6 +309,7 @@ class similar_topics
+++ 
+++ 					'TOPIC_REPLIES'			=> $replies,
+++ 					'TOPIC_VIEWS'			=> $row['topic_views'],
++++					'TOPIC_ANSWERED'		=> ($this->extension_manager->is_enabled('kinerity/bestanswer')) && $row['answer_post_id'] ? true : false,
+++ 					'TOPIC_TITLE'			=> censor_text($row['topic_title']),
+++ 					'FORUM_TITLE'			=> $row['forum_name'],
+++ 
+++@@ -377,7 +354,7 @@ class similar_topics
+++ 			}
+++ 		}
+++ 
+++-		$this->add_language();
++++		$this->language->add_lang('similar_topics', 'vse/similartopics');
+++ 
+++ 		$this->template->assign_vars(array(
+++ 			'NEWEST_POST_IMG'	=> $this->user->img('icon_topic_newest', 'VIEW_NEWEST_POST'),
+++@@ -388,96 +365,130 @@ class similar_topics
+++ 	}
+++ 
+++ 	/**
+++-	 * Add lang files for similar topics
++++	 * Clean topic title (and if needed, ignore-words)
+++ 	 *
+++-	 * @return void
++++	 * @access public
++++	 * @param string $text The topic title
++++	 * @return string The topic title
+++ 	 */
+++-	public function add_language()
++++	public function clean_topic_title($text)
+++ 	{
+++-		$this->language->add_lang('similar_topics', 'vse/similartopics');
+++-	}
++++		// Strip quotes, ampersands
++++		$text = str_replace(array('&quot;', '&amp;'), '', $text);
++++
++++		// UTF Emojis
++++		$regex_emoticons = '/[\x{1F600}-\x{1F64F}]/u';
++++		$text = preg_replace($regex_emoticons, '', $text);
++++
++++		// Match Miscellaneous Symbols and Pictographs
++++		$regex_symbols = '/[\x{1F300}-\x{1F5FF}]/u';
++++		$text = preg_replace($regex_symbols, '', $text);
++++
++++		// Match Transport And Map Symbols
++++		$regex_transport = '/[\x{1F680}-\x{1F6FF}]/u';
++++		$text = preg_replace($regex_transport, '', $text);
++++
++++		// Match Miscellaneous Symbols
++++		$regex_misc = '/[\x{2600}-\x{26FF}]/u';
++++		$text = preg_replace($regex_misc, '', $text);
++++
++++		// Match Dingbats
++++		$regex_dingbats = '/[\x{2700}-\x{27BF}]/u';
++++		$text = preg_replace($regex_dingbats, '', $text);
++++
++++		$regex_bbemoji = '(:([-+_a-z0-9]+):(?!\\w|[^<>]*(?=>|</code>)))';
++++		$matches = [];
++++		preg_match_all($regex_bbemoji, $text, $matches);
++++		foreach ($matches[0] as $emoji) {
++++			$text = str_replace($emoji, '', $text);
++++		}
+++ 
+++-	/**
+++-	 * Check if we should load localized ignore words
+++-	 *
+++-	 * @access protected
+++-	 * @return bool True if non-English language or using a dbms with no stop-words
+++-	 */
+++-	protected function get_localized_ignore_words()
+++-	{
+++-		return !in_array($this->user->lang_name, ['en', 'en_us'], true) || !$this->similartopics->has_stopword_support();
++++		$text = trim($text);
++++
++++		if (!$this->english_lang() || $this->get_ignore_words())
++++		{
++++			$text = $this->strip_stop_words($text);
++++		}
++++
++++		return $text;
+++ 	}
+++ 
+++ 	/**
+++-	 * Search for similar topics via AJAX for dynamic suggestions
++++	 * Remove any non-english and/or custom defined ignore-words
+++ 	 *
+++-	 * @param string $query The search query
+++-	 * @param int $forum_id The forum ID to search from
+++-	 * @return array Array of similar topics
++++	 * @access protected
++++	 * @param string $text The topic title
++++	 * @return string The topic title
+++ 	 */
+++-	public function search_similar_topics_ajax($query, $forum_id = 0)
++++	protected function strip_stop_words($text)
+++ 	{
+++-		$this->stop_word_helper->set_use_localized($this->get_localized_ignore_words());
+++-		$this->stop_word_helper->set_additional_ignore_words($this->get_additional_ignore_words());
+++-		$cleaned_query = $this->stop_word_helper->clean_text($query);
++++		$words = array();
+++ 
+++-		if (empty($cleaned_query))
++++		// If non-English, look for a list of stop-words to be ignored
++++		// in either the core or the extension (deprecated from core)
++++		if (!$this->english_lang())
+++ 		{
+++-			return [];
++++			$finder = $this->extension_manager->get_finder();
++++			$search_ignore_words = $finder
++++				->set_extensions(array('vse/similartopics'))
++++				->prefix('search_ignore_words')
++++				->suffix(".$this->php_ext")
++++				->extension_directory("/language/{$this->user->lang_name}")
++++				->core_path("language/{$this->user->lang_name}/")
++++				->get_files();
++++			if (current($search_ignore_words))
++++			{
++++				include current($search_ignore_words);
++++			}
+++ 		}
+++ 
+++-		$sensitivity = $this->config->offsetExists('similar_topics_sense') ? number_format($this->config['similar_topics_sense'] / 10, 1, '.', '') : '0.5';
+++-		$sql_array = $this->similartopics->get_query(0, $cleaned_query, $this->config['similar_topics_time'], $sensitivity);
+++-
+++-		$similar_topic_forums = null;
+++-		if ($forum_id > 0)
++++		if ($this->get_ignore_words())
+++ 		{
+++-			$sql = 'SELECT similar_topic_forums
+++-				FROM ' . FORUMS_TABLE . '
+++-				WHERE forum_id = ' . (int) $forum_id;
+++-			$result = $this->db->sql_query($sql, 3600);
+++-			$similar_topic_forums = $this->db->sql_fetchfield('similar_topic_forums');
+++-			$this->db->sql_freeresult($result);
++++			// Merge any custom defined ignore words from the ACP to the stop-words array
++++			$words = array_merge($this->make_word_array($this->get_ignore_words()), $words);
+++ 		}
+++ 
+++-		$passworded_forums = $this->user->get_passworded_forums();
++++		// Remove stop-words from the topic title text
++++		$words = array_diff($this->make_word_array($text), $words);
+++ 
+++-		if (!empty($similar_topic_forums))
+++-		{
+++-			$included_forums = array_diff(json_decode($similar_topic_forums, true), $passworded_forums);
+++-			if (empty($included_forums))
+++-			{
+++-				return [];
+++-			}
+++-			$sql_array['WHERE'] .= ' AND ' . $this->db->sql_in_set('f.forum_id', $included_forums);
+++-		}
+++-		else
+++-		{
+++-			if (count($passworded_forums))
+++-			{
+++-				$sql_array['WHERE'] .= ' AND ' . $this->db->sql_in_set('f.forum_id', $passworded_forums, true);
+++-			}
+++-			$sql_array['WHERE'] .= ' AND f.similar_topics_ignore = 0';
+++-		}
++++		// Convert our words array back to a string
++++		return implode(' ', $words);
++++	}
+++ 
+++-		$topics = [];
+++-		$sql = $this->db->sql_build_query('SELECT', $sql_array);
+++-		$result = $this->db->sql_query_limit($sql, 5);
++++	/**
++++	 * Helper function to split string into an array of words
++++	 *
++++	 * @access protected
++++	 * @param string $text String of plain text words
++++	 * @return array Array of plaintext words
++++	 */
++++	protected function make_word_array($text)
++++	{
++++		// Strip out any non-alpha-numeric characters using PCRE regex syntax
++++		$text = trim(preg_replace('#[^\p{L}\p{N}]+#u', ' ', $text));
+++ 
+++-		while ($row = $this->db->sql_fetchrow($result))
++++		$words = explode(' ', utf8_strtolower($text));
++++		foreach ($words as $key => $word)
+++ 		{
+++-			if ($this->auth->acl_get('f_read', (int) $row['forum_id']))
++++			// Strip words of 2 characters or fewer
++++			if (utf8_strlen(trim($word)) < 3)
+++ 			{
+++-				$topics[] = [
+++-					'id' => (int) $row['topic_id'],
+++-					'title' => censor_text($row['topic_title']),
+++-					'url' => append_sid("{$this->root_path}viewtopic.$this->php_ext", 't=' . $row['topic_id'])
+++-				];
++++				unset($words[$key]);
+++ 			}
+++ 		}
+++-		$this->db->sql_freeresult($result);
+++ 
+++-		return $topics;
++++		return $words;
++++	}
++++
++++	/**
++++	 * Check if English is the current user's language
++++	 *
++++	 * @access protected
++++	 * @return bool True if lang is 'en' or 'en_us', false otherwise
++++	 */
++++	protected function english_lang()
++++	{
++++		return ($this->user->lang_name === 'en' || $this->user->lang_name === 'en_us');
+++ 	}
+++ 
+++ 	/**
+++@@ -486,7 +497,7 @@ class similar_topics
+++ 	 * @access protected
+++ 	 * @return string|null String of ignore words or null if there are none defined
+++ 	 */
+++-	protected function get_additional_ignore_words()
++++	protected function get_ignore_words()
+++ 	{
+++ 		$key = 'similar_topics_words';
+++ 
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/core/stop_word_helper.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/core/stop_word_helper.php"
+++deleted file mode 100644
+++index 2af488e1a..000000000
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/core/stop_word_helper.php"
++++++ /dev/null
+++@@ -1,198 +0,0 @@
+++-<?php
+++-/**
+++- *
+++- * Precise Similar Topics
+++- *
+++- * @copyright (c) 2025 Matt Friedman
+++- * @license GNU General Public License, version 2 (GPL-2.0)
+++- *
+++- */
+++-
+++-namespace vse\similartopics\core;
+++-
+++-use phpbb\cache\driver\driver_interface as cache_driver;
+++-use phpbb\extension\manager as ext_manager;
+++-use phpbb\user;
+++-
+++-/**
+++- * A helper class to clean text and remove stop words (localized and additional)
+++- * for topic titles or other search-related strings.
+++- */
+++-class stop_word_helper
+++-{
+++-	/** @var cache_driver */
+++-	protected $cache;
+++-
+++-	/** @var ext_manager */
+++-	protected $extension_manager;
+++-
+++-	/** @var user */
+++-	protected $user;
+++-
+++-	/** @var string */
+++-	protected $php_ext;
+++-
+++-	/** @var array|null Lookup table for fast filtering */
+++-	protected $ignore_lookup;
+++-
+++-	/** @var bool Whether localized ignore words should be loaded */
+++-	protected $use_localized = false;
+++-
+++-	/** @var string Additional ignore words string */
+++-	protected $additional_ignore = '';
+++-
+++-	/** @var bool Whether ignore words need to be reloaded */
+++-	protected $needs_reload = true;
+++-
+++-	/**
+++-	 * Constructor
+++-	 *
+++-	 * @param cache_driver $cache
+++-	 * @param ext_manager $extension_manager
+++-	 * @param user $user
+++-	 * @param string $php_ext
+++-	 */
+++-	public function __construct(cache_driver $cache, ext_manager $extension_manager, user $user, $php_ext)
+++-	{
+++-		$this->cache = $cache;
+++-		$this->extension_manager = $extension_manager;
+++-		$this->user = $user;
+++-		$this->php_ext = $php_ext;
+++-	}
+++-
+++-	/**
+++-	 * Set additional ignore words
+++-	 *
+++-	 * @param string $words
+++-	 */
+++-	public function set_additional_ignore_words($words)
+++-	{
+++-		if ($this->additional_ignore !== $words)
+++-		{
+++-			$this->additional_ignore = $words;
+++-			$this->needs_reload = true;
+++-		}
+++-	}
+++-
+++-	/**
+++-	 * Set whether to use localized ignore words
+++-	 *
+++-	 * @param bool $value
+++-	 */
+++-	public function set_use_localized($value)
+++-	{
+++-		$value = (bool) $value;
+++-		if ($this->use_localized !== $value)
+++-		{
+++-			$this->use_localized = $value;
+++-			$this->needs_reload = true;
+++-		}
+++-	}
+++-
+++-	/**
+++-	 * Clean text (strip quotes, ampersands, stop words)
+++-	 *
+++-	 * @param string $text
+++-	 * @return string
+++-	 */
+++-	public function clean_text($text)
+++-	{
+++-		// Strip HTML entities
+++-		$text = str_replace(['&quot;', '&amp;'], '', $text);
+++-
+++-		if ($this->use_localized || !empty($this->additional_ignore))
+++-		{
+++-			$this->load_ignore_words();
+++-			$filtered = array_filter(
+++-				$this->make_word_array($text, true),
+++-				[$this, 'filter_ignore_words']
+++-			);
+++-			$text = implode(' ', array_unique($filtered));
+++-		}
+++-
+++-		return $text;
+++-	}
+++-
+++-	/**
+++-	 * Load ignore words into memory and build a lookup table
+++-	 */
+++-	protected function load_ignore_words()
+++-	{
+++-		if ($this->needs_reload || $this->ignore_lookup === null)
+++-		{
+++-			// The cache will be invalidated when language, localized setting, or additional words change
+++-			$cache_key = '_pst_ignore_' . md5($this->user->lang_name . '|' . (int) $this->use_localized . '|' . $this->additional_ignore);
+++-			$this->ignore_lookup = $this->cache->get($cache_key);
+++-
+++-			if ($this->ignore_lookup === false)
+++-			{
+++-				// Load localized ignore words (if needed)
+++-				$words = $this->use_localized ? $this->load_localized_words() : [];
+++-
+++-				// Load additional ignore words (if defined)
+++-				if (!empty($this->additional_ignore))
+++-				{
+++-					$words = array_merge($words, $this-
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/driver/driver_interface.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/driver/driver_interface.php"
++index bb56ebfa3..fcd220dcb 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/driver/driver_interface.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/driver/driver_interface.php"
++@@ -82,12 +82,4 @@ interface driver_interface
++ 	 * @return string The storage engine name
++ 	 */
++ 	public function get_engine();
++-
++-	/**
++-	 * Check if the database has built-in stop-word support
++-	 *
++-	 * @access public
++-	 * @return bool True if has stop-word support, false otherwise
++-	 */
++-	public function has_stopword_support();
++ }
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/driver/mssql.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/driver/mssql.php"
++deleted file mode 100644
++index d2556b92d..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/driver/mssql.php"
+++++ /dev/null
++@@ -1,199 +0,0 @@
++-<?php
++-/**
++- *
++- * Precise Similar Topics
++- *
++- * @copyright (c) 2025 Matt Friedman
++- * @license GNU General Public License, version 2 (GPL-2.0)
++- *
++- */
++-
++-namespace vse\similartopics\driver;
++-
++-/**
++- * This class handles similar topics queries for MSSQL dbms
++- */
++-class mssql implements driver_interface
++-{
++-	/** @var \phpbb\db\driver\driver_interface */
++-	protected $db;
++-
++-	/**
++-	 * Constructor
++-	 *
++-	 * @param \phpbb\db\driver\driver_interface $db
++-	 */
++-	public function __construct(\phpbb\db\driver\driver_interface $db)
++-	{
++-		$this->db = $db;
++-	}
++-
++-	/**
++-	 * {@inheritdoc}
++-	 */
++-	public function get_name()
++-	{
++-		return 'mssql';
++-	}
++-
++-	/**
++-	 * {@inheritdoc}
++-	 */
++-	public function get_type()
++-	{
++-		return 'mssql';
++-	}
++-
++-	/**
++-	 * {@inheritdoc}
++-	 */
++-	public function get_query($topic_id, $topic_title, $length, $sensitivity)
++-	{
++-		if ($this->is_fulltext('topic_title', TOPICS_TABLE))
++-		{
++-			$search_condition = "CONTAINS(t.topic_title, '" . $this->db->sql_escape(str_replace(' ', ' AND ', $topic_title)) . "')";
++-		}
++-		else
++-		{
++-			$like_conditions = array();
++-			foreach (explode(' ', $topic_title) as $word)
++-			{
++-				$word = trim($word);
++-				if (utf8_strlen($word) > 2)
++-				{
++-					$like_conditions[] = "t.topic_title LIKE '%" . $this->db->sql_escape($word) . "%'";
++-				}
++-			}
++-			$search_condition = !empty($like_conditions)
++-				? '(' . implode(' OR ', $like_conditions) . ')'
++-				: "t.topic_title LIKE '%" . $this->db->sql_escape($topic_title) . "%'";
++-		}
++-
++-		return array(
++-			'SELECT'	=> "f.forum_id, f.forum_name, t.*,
++-				CASE WHEN " . $search_condition . " THEN 1.0 ELSE 0.0 END AS score",
++-			'FROM'		=> array(
++-				TOPICS_TABLE => 't'
++-			),
++-			'LEFT_JOIN'	=> array(
++-				array(
++-					'FROM' => array(FORUMS_TABLE => 'f'),
++-					'ON' => 'f.forum_id = t.forum_id'
++-				)
++-			),
++-			'WHERE'		=> $search_condition . "
++-				AND t.topic_status <> " . ITEM_MOVED . "
++-				AND t.topic_visibility = " . ITEM_APPROVED . "
++-				AND t.topic_time > (DATEDIFF(second, '1970-01-01', GETDATE()) - " . (int) $length . ")
++-				AND t.topic_id <> " . (int) $topic_id,
++-			'ORDER_BY'	=> 'score DESC, t.topic_time DESC',
++-		);
++-	}
++-
++-	/**
++-	 * {@inheritdoc}
++-	 */
++-	public function is_supported()
++-	{
++-		return (strpos($this->db->get_sql_layer(), 'mssql') === 0);
++-	}
++-
++-	/**
++-	 * {@inheritdoc}
++-	 */
++-	public function is_fulltext($column = 'topic_title', $table = TOPICS_TABLE)
++-	{
++-		return in_array($column, $this->get_fulltext_indexes($column, $table), true);
++-	}
++-
++-	/**
++-	 * {@inheritdoc}
++-	 */
++-	public function get_fulltext_indexes($column = 'topic_title', $table = TOPICS_TABLE)
++-	{
++-		$indexes = array();
++-
++-		if (!$this->is_supported())
++-		{
++-			return $indexes;
++-		}
++-
++-		try
++-		{
++-			$sql = "SELECT i.name
++-				FROM sys.fulltext_indexes fi
++-				INNER JOIN sys.indexes i ON fi.object_id = i.object_id AND fi.unique_index_id = i.index_id
++-				INNER JOIN sys.objects o ON fi.object_id = o.object_id
++-				WHERE o.name = '" . $this->db->sql_escape($table) . "'";
++-			$result = $this->db->sql_query($sql);
++-
++-			while ($row = $this->db->sql_fetchrow($result))
++-			{
++-				$indexes[] = $row['name'];
++-			}
++-
++-			$this->db->sql_freeresult($result);
++-		}
++-		catch (\Exception $e)
++-		{
++-			// Full-text search not available
++-		}
++-
++-		return $indexes;
++-	}
++-
++-	/**
++-	 * {@inheritdoc}
++-	 */
++-	public function create_fulltext_index($column = 'topic_title', $table = TOPICS_TABLE)
++-	{
++-		if (!$this->is_supported() || !$this->fulltext_available() || $this->is_fulltext($column, $table))
++-		{
++-			return;
++-		}
++-
++-		// Create fulltext catalog if it doesn't exist
++-		$sql = "IF NOT EXISTS (SELECT * FROM sys.fulltext_catalogs WHERE name = 'phpbb_catalog')
++-			CREATE FULLTEXT CATALOG phpbb_catalog";
++-		$this->db->sql_query($sql);
++-
++-		// Create fulltext index
++-		$sql = "CREATE FULLTEXT INDEX ON " . $this->db->sql_escape($table) . "
++-			(" . $this->db->sql_escape($column) . ")
++-			KEY INDEX PK_" . $this->db->sql_escape($table) . "
++-			ON phpbb_catalog";
++-		$this->db->sql_query($sql);
++-	}
++-
++-	/**
++-	 * {@inheritdoc}
++-	 */
++-	public function get_engine()
++-	{
++-		return '';
++-	}
++-
++-	/**
++-	 * {@inheritdoc}
++-	 */
++-	public function has_stopword_support()
++-	{
++-		return false;
++-	}
++-
++-	protected function fulltext_available()
++-	{
++-		try
++-		{
++-			$sql = "SELECT SERVERPROPERTY('IsFullTextInstalled') AS IsFullTextInstalled";
++-			$result = $this->db->sql_query($sql);
++-			$row = $this->db->sql_fetchrow($result);
++-			$this->db->sql_freeresult($result);
++-			return (bool) $row['IsFullTextInstalled'];
++-		}
++-		catch (\Exception $e)
++-		{
++-			return false;
++-		}
++-	}
++-}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/driver/mssql_odbc.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/driver/mssql_odbc.php"
++deleted file mode 100644
++index c1d8ac99f..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/driver/mssql_odbc.php"
+++++ /dev/null
++@@ -1,25 +0,0 @@
++-<?php
++-/**
++- *
++- * Precise Similar Topics
++- *
++- * @copyright (c) 2025 Matt Friedman
++- * @license GNU General Public License, version 2 (GPL-2.0)
++- *
++- */
++-
++-namespace vse\similartopics\driver;
++-
++-/**
++- * This class handles similar topics queries for MSSQL ODBC dbms
++- */
++-class mssql_odbc extends mssql
++-{
++-	/**
++-	 * {@inheritdoc}
++-	 */
++-	public function get_name()
++-	{
++-		return 'mssql_odbc';
++-	}
++-}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/driver/mssqlnative.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/driver/mssqlnative.php"
++deleted file mode 100644
++index f7735953e..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/driver/mssqlnative.php"
+++++ /dev/null
++@@ -1,25 +0,0 @@
++-<?php
++-/**
++- *
++- * Precise Similar Topics
++- *
++- * @copyright (c) 2025 Matt Friedman
++- * @license GNU General Public License, version 2 (GPL-2.0)
++- *
++- */
++-
++-namespace vse\similartopics\driver;
++-
++-/**
++- * This class handles similar topics queries for MSSQL Native dbms
++- */
++-class mssqlnative extends mssql
++-{
++-	/**
++-	 * {@inheritdoc}
++-	 */
++-	public function get_name()
++-	{
++-		return 'mssqlnative';
++-	}
++-}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/driver/mysqli.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/driver/mysqli.php"
++index 7f6c1fd6f..35ba9ddc0 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/driver/mysqli.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/driver/mysqli.php"
++@@ -202,15 +202,7 @@ class mysqli implements driver_interface
++ 	 */
++ 	protected function is_mysql()
++ 	{
++-		return strpos($this->db->get_sql_layer(), 'mysql') === 0;
++-	}
++-
++-	/**
++-	 * {@inheritdoc}
++-	 */
++-	public function has_stopword_support()
++-	{
++-		return true;
+++		return ($this->db->get_sql_layer() === 'mysql4' || $this->db->get_sql_layer() === 'mysqli');
++ 	}
++ 
++ 	/**
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/driver/oracle.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/driver/oracle.php"
++deleted file mode 100644
++index bc77f0d6d..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/driver/oracle.php"
+++++ /dev/null
++@@ -1,200 +0,0 @@
++-<?php
++-/**
++- *
++- * Precise Similar Topics
++- *
++- * @copyright (c) 2025 Matt Friedman
++- * @license GNU General Public License, version 2 (GPL-2.0)
++- *
++- */
++-
++-namespace vse\similartopics\driver;
++-
++-/**
++- * This class handles similar topics queries for Oracle dbms
++- */
++-class oracle implements driver_interface
++-{
++-	/** @var \phpbb\db\driver\driver_interface */
++-	protected $db;
++-
++-	/**
++-	 * Constructor
++-	 *
++-	 * @param \phpbb\db\driver\driver_interface $db
++-	 */
++-	public function __construct(\phpbb\db\driver\driver_interface $db)
++-	{
++-		$this->db = $db;
++-	}
++-
++-	/**
++-	 * {@inheritdoc}
++-	 */
++-	public function get_name()
++-	{
++-		return 'oracle';
++-	}
++-
++-	/**
++-	 * {@inheritdoc}
++-	 */
++-	public function get_type()
++-	{
++-		return 'oracle';
++-	}
++-
++-	/**
++-	 * {@inheritdoc}
++-	 */
++-	public function get_query($topic_id, $topic_title, $length, $sensitivity)
++-	{
++-		// Clean and prepare the search terms for Oracle Text
++-		$search_terms = $this->prepare_search_terms($topic_title);
++-
++-		return array(
++-			'SELECT'	=> "f.forum_id, f.forum_name, t.*,
++-				SCORE(1) AS score",
++-
++-			'FROM'		=> array(
++-				TOPICS_TABLE	=> 't',
++-			),
++-			'LEFT_JOIN'	=> array(
++-				array(
++-					'FROM'	=>	array(FORUMS_TABLE	=> 'f'),
++-					'ON'	=> 'f.forum_id = t.forum_id',
++-				),
++-			),
++-			'WHERE'		=> "CONTAINS(t.topic_title, '" . $this->db->sql_escape($search_terms) . "', 1) > 0
++-				AND SCORE(1) >= " . (float) $sensitivity . '
++-				AND t.topic_status <> ' . ITEM_MOVED . '
++-				AND t.topic_visibility = ' . ITEM_APPROVED . '
++-				AND t.topic_time > (EXTRACT(EPOCH FROM SYSTIMESTAMP) - ' . (int) $length . ')
++-				AND t.topic_id <> ' . (int) $topic_id,
++-		);
++-	}
++-
++-	/**
++-	 * {@inheritdoc}
++-	 */
++-	public function is_supported()
++-	{
++-		return $this->is_oracle();
++-	}
++-
++-	/**
++-	 * {@inheritdoc}
++-	 */
++-	public function is_fulltext($column = 'topic_title', $table = TOPICS_TABLE)
++-	{
++-		return in_array($column, $this->get_fulltext_indexes($column, $table), true);
++-	}
++-
++-	/**
++-	 * {@inheritdoc}
++-	 */
++-	public function get_fulltext_indexes($column = 'topic_title', $table = TOPICS_TABLE)
++-	{
++-		$indexes = array();
++-
++-		if (!$this->is_supported())
++-		{
++-			return $indexes;
++-		}
++-
++-		$sql = "SELECT index_name
++-			FROM user_indexes
++-			WHERE table_name = UPPER('" . $this->db->sql_escape($table) . "')
++-			AND index_type = 'DOMAIN'
++-			AND domidx_opstatus = 'VALID'";
++-		$result = $this->db->sql_query($sql);
++-
++-		while ($row = $this->db->sql_fetchrow($result))
++-		{
++-			// Check if this is a text index on our column
++-			$check_sql = "SELECT column_name
++-				FROM user_ind_columns
++-				WHERE index_name = '" . $this->db->sql_escape($row['index_name']) . "'
++-				AND column_name = UPPER('" . $this->db->sql_escape($column) . "')";
++-			$check_result = $this->db->sql_query($check_sql);
++-
++-			if ($this->db->sql_fetchrow($check_result))
++-			{
++-				$indexes[] = strtolower($column);
++-			}
++-			$this->db->sql_freeresult($check_result);
++-		}
++-
++-		$this->db->sql_freeresult($result);
++-
++-		return $indexes;
++-	}
++-
++-	/**
++-	 * {@inheritdoc}
++-	 */
++-	public function create_fulltext_index($column = 'topic_title', $table = TOPICS_TABLE)
++-	{
++-		if (!$this->is_fulltext($column, $table))
++-		{
++-			$index_name = $table . '_' . $column . '_ctx_idx';
++-
++-			// Create Oracle Text index
++-			$sql = "CREATE INDEX " . $this->db->sql_escape($index_name) . "
++-				ON " . $this->db->sql_escape($table) . " (" . $this->db->sql_escape($column) . ")
++-				INDEXTYPE IS CTXSYS.CONTEXT
++-				PARAMETERS ('STOPLIST CTXSYS.DEFAULT_STOPLIST SYNC (ON COMMIT)')";
++-			$this->db->sql_query($sql);
++-		}
++-	}
++-
++-	/**
++-	 * {@inheritdoc}
++-	 */
++-	public function get_engine()
++-	{
++-		return 'oracle';
++-	}
++-
++-	/**
++-	 * {@inheritdoc}
++-	 */
++-	public function has_stopword_support()
++-	{
++-		return true;
++-	}
++-
++-	/**
++-	 * Check if the database is using Oracle
++-	 *
++-	 * @return bool True if is oracle, false otherwise
++-	 */
++-	protected function is_oracle()
++-	{
++-		return strpos($this->db->get_sql_layer(), 'oracle') === 0;
++-	}
++-
++-	/**
++-	 * Prepare search terms for Oracle Text query
++-	 *
++-	 * @param string $topic_title The topic title to search for
++-	 * @return string Formatted search terms for Oracle Text
++-	 */
++-	protected function prepare_search_terms($topic_title)
++-	{
++-		// Remove special characters and split into words
++-		$words = preg_split('/[^\p{L}\p{N}]+/u', $topic_title, -1, PREG_SPLIT_NO_EMPTY);
++-
++-		// Filter out short words and create OR query
++-		$search_words = array();
++-		foreach ($words as $word)
++-		{
++-			if (utf8_strlen($word) >= 3)
++-			{
++-				$search_words[] = $word;
++-			}
++-		}
++-
++-		return !empty($search_words) ? implode(' OR ', $search_words) : $topic_title;
++-	}
++-}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/driver/postgres.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/driver/postgres.php"
++index 4b23607e5..77bf6486f 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/driver/postgres.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/driver/postgres.php"
++@@ -65,6 +65,7 @@ class postgres implements driver_interface
++ 
++ 		return array(
++ 			'SELECT'	=> "f.forum_id, f.forum_name, t.*, $ts_rank_cd AS score",
+++
++ 			'FROM'		=> array(
++ 				TOPICS_TABLE	=> 't',
++ 			),
++@@ -173,29 +174,6 @@ class postgres implements driver_interface
++ 		return '';
++ 	}
++ 
++-	/**
++-	 * {@inheritdoc}
++-	 */
++-	public function has_stopword_support()
++-	{
++-		return !in_array($this->ts_name, ['simple', ''], true);
++-	}
++-
++-	/**
++-	 * Get a list of postgresql text search names
++-	 *
++-	 * @return array array of text search names
++-	 */
++-	public function get_cfg_name_list()
++-	{
++-		$sql = 'SELECT cfgname AS ts_name FROM pg_ts_config';
++-		$result = $this->db->sql_query($sql);
++-		$ts_options = $this->db->sql_fetchrowset($result);
++-		$this->db->sql_freeresult($result);
++-
++-		return $ts_options;
++-	}
++-
++ 	/**
++ 	 * Set the PostgreSQL Text Search name (dictionary)
++ 	 *
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/driver/sqlite3.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/driver/sqlite3.php"
++deleted file mode 100644
++index 3a903236c..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/driver/sqlite3.php"
+++++ /dev/null
++@@ -1,185 +0,0 @@
++-<?php
++-/**
++- *
++- * Precise Similar Topics
++- *
++- * @copyright (c) 2025 Matt Friedman
++- * @license GNU General Public License, version 2 (GPL-2.0)
++- *
++- */
++-
++-namespace vse\similartopics\driver;
++-
++-/**
++- * This class handles similar topics queries for SQLite3 dbms
++- */
++-class sqlite3 implements driver_interface
++-{
++-	/** @var \phpbb\db\driver\driver_interface */
++-	protected $db;
++-
++-	/**
++-	 * Constructor
++-	 *
++-	 * @param \phpbb\db\driver\driver_interface $db
++-	 */
++-	public function __construct(\phpbb\db\driver\driver_interface $db)
++-	{
++-		$this->db = $db;
++-	}
++-
++-	/**
++-	 * {@inheritdoc}
++-	 */
++-	public function get_name()
++-	{
++-		return 'sqlite3';
++-	}
++-
++-	/**
++-	 * {@inheritdoc}
++-	 */
++-	public function get_type()
++-	{
++-		return 'sqlite';
++-	}
++-
++-	/**
++-	 * {@inheritdoc}
++-	 */
++-	public function get_query($topic_id, $topic_title, $length, $sensitivity)
++-	{
++-		$words = explode(' ', $topic_title);
++-		$like_conditions = array();
++-
++-		foreach ($words as $word)
++-		{
++-			$like_conditions[] = "t.topic_title LIKE '%" . $this->db->sql_escape(trim($word)) . "%'";
++-		}
++-
++-		$where_condition = '(' . implode(' OR ', $like_conditions) . ')';
++-
++-		return array(
++-			'SELECT'	=> "f.forum_id, f.forum_name, t.*,
++-				CASE WHEN " . $where_condition . " THEN 1.0 ELSE 0.0 END AS score",
++-			'FROM'		=> array(
++-				TOPICS_TABLE	=> 't',
++-			),
++-			'LEFT_JOIN'	=> array(
++-				array(
++-					'FROM'	=>	array(FORUMS_TABLE	=> 'f'),
++-					'ON'	=> 'f.forum_id = t.forum_id',
++-				),
++-			),
++-			'WHERE'		=> $where_condition . "
++-				AND t.topic_status <> " . ITEM_MOVED . "
++-				AND t.topic_visibility = " . ITEM_APPROVED . "
++-				AND t.topic_time > (strftime('%s', 'now') - " . (int) $length . ")
++-				AND t.topic_id <> " . (int) $topic_id,
++-			'ORDER_BY'	=> 'score DESC, t.topic_time DESC',
++-		);
++-	}
++-
++-	/**
++-	 * {@inheritdoc}
++-	 */
++-	public function is_supported()
++-	{
++-		return ($this->db->get_sql_layer() === 'sqlite3');
++-	}
++-
++-	/**
++-	 * {@inheritdoc}
++-	 */
++-	public function is_fulltext($column = 'topic_title', $table = TOPICS_TABLE)
++-	{
++-		// For SQLite, we check if a regular index exists since we use LIKE operations
++-		return $this->index_exists($table, $column);
++-	}
++-
++-	/**
++-	 * {@inheritdoc}
++-	 */
++-	public function get_fulltext_indexes($column = 'topic_title', $table = TOPICS_TABLE)
++-	{
++-		$indexes = array();
++-
++-		if (!$this->is_supported())
++-		{
++-			return $indexes;
++-		}
++-
++-		// Check for FTS virtual tables
++-		$sql = "SELECT name FROM sqlite_master
++-			WHERE type='table' AND name LIKE '" . $this->db->sql_escape($table) . "_fts%'";
++-		$result = $this->db->sql_query($sql);
++-
++-		while ($row = $this->db->sql_fetchrow($result))
++-		{
++-			$indexes[] = $row['name'];
++-		}
++-
++-		$this->db->sql_freeresult($result);
++-
++-		return $indexes;
++-	}
++-
++-	/**
++-	 * {@inheritdoc}
++-	 */
++-	public function create_fulltext_index($column = 'topic_title', $table = TOPICS_TABLE)
++-	{
++-		// SQLite FTS setup is complex and optional for LIKE-based search
++-		// We'll create a simple index to improve LIKE performance
++-		if ($this->index_exists($table, $column))
++-		{
++-			return;
++-		}
++-
++-		$escaped_table = $this->db->sql_escape($table);
++-		$escaped_column = $this->db->sql_escape($column);
++-		$sql = 'CREATE INDEX idx_' . $escaped_table . '_' . $escaped_column . '
++-			ON ' . $escaped_table . ' (' . $escaped_column . ')';
++-		$this->db->sql_query($sql);
++-	}
++-
++-	/**
++-	 * {@inheritdoc}
++-	 */
++-	public function get_engine()
++-	{
++-		return '';
++-	}
++-
++-	/**
++-	 * {@inheritdoc}
++-	 */
++-	public function has_stopword_support()
++-	{
++-		return false;
++-	}
++-
++-	/**
++-	 * Check if index exists
++-	 *
++-	 * @param string $table Name of the table
++-	 * @param string $column Name of the column
++-	 * @return bool True if index exists, false otherwise
++-	 */
++-	protected function index_exists($table, $column)
++-	{
++-		if (!$this->is_supported())
++-		{
++-			return false;
++-		}
++-
++-		$index_name = 'idx_' . $table . '_' . $column;
++-		$sql = "SELECT name FROM sqlite_master
++-			WHERE type='index' AND name = '" . $this->db->sql_escape($index_name) . "'";
++-		$result = $this->db->sql_query($sql);
++-		$exists = (bool) $this->db->sql_fetchrow($result);
++-		$this->db->sql_freeresult($result);
++-
++-		return $exists;
++-	}
++-}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/event/listener.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/event/listener.php"
++index ac521f00f..a13f9a411 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/event/listener.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/event/listener.php"
++@@ -11,8 +11,6 @@
++ namespace vse\similartopics\event;
++ 
++ use Symfony\Component\EventDispatcher\EventSubscriberInterface;
++-use phpbb\controller\helper;
++-use phpbb\template\template;
++ 
++ /**
++  * Event listener
++@@ -22,25 +20,15 @@ class listener implements EventSubscriberInterface
++ 	/** @var \vse\similartopics\core\similar_topics */
++ 	protected $similar_topics;
++ 
++-	/** @var helper */
++-	protected $controller_helper;
++-
++-	/** @var template */
++-	protected $template;
++-
++ 	/**
++ 	 * Constructor
++ 	 *
++ 	 * @access public
++ 	 * @param \vse\similartopics\core\similar_topics $similar_topics
++-	 * @param helper $helper
++-	 * @param template $template
++ 	 */
++-	public function __construct(\vse\similartopics\core\similar_topics $similar_topics, helper $helper, template $template)
+++	public function __construct(\vse\similartopics\core\similar_topics $similar_topics)
++ 	{
++ 		$this->similar_topics = $similar_topics;
++-		$this->controller_helper = $helper;
++-		$this->template = $template;
++ 	}
++ 
++ 	/**
++@@ -55,7 +43,6 @@ class listener implements EventSubscriberInterface
++ 		return [
++ 			'core.viewtopic_modify_page_title'		=> 'display_similar_topics',
++ 			'core.permissions'						=> 'add_permissions',
++-			'core.posting_modify_template_vars'		=> 'dynamic_similar_topics',
++ 		];
++ 	}
++ 
++@@ -89,33 +76,4 @@ class listener implements EventSubscriberInterface
++ 			'cat' => 'misc'
++ 		]);
++ 	}
++-
++-	/**
++-	 * Display dynamic similar topics when creating posts
++-	 *
++-	 * @access public
++-	 * @param \phpbb\event\data $event The event object
++-	 */
++-	public function dynamic_similar_topics($event)
++-	{
++-		if ($event['mode'] !== 'post'
++-			|| !empty($event['post_data']['topic_id'])
++-			|| !$this->similar_topics->is_dynamic_available())
++-		{
++-			return;
++-		}
++-
++-		$tpl_ary = [
++-			'S_DYNAMIC_SIMILAR_TOPICS' => true,
++-			'U_PST_AJAX_SEARCH' => $this->controller_helper->route('vse_similartopics_ajax_search'),
++-		];
++-
++-		if ($this->template->retrieve_var('FORUM_ID') === null)
++-		{
++-			$tpl_ary['FORUM_ID'] = isset($event['forum_id']) ? $event['forum_id'] : 0;
++-		}
++-
++-		$this->template->assign_vars($tpl_ary);
++-		$this->similar_topics->add_language();
++-	}
++ }
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/ext.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/ext.php"
++index 2717e9331..7f06e5239 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/ext.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/ext.php"
++@@ -13,13 +13,28 @@ namespace vse\similartopics;
++ class ext extends \phpbb\extension\base
++ {
++ 	/**
++-	 * Extension requires phpBB 3.2.1 or newer.
+++	 * Extension requires Mysql or Postgres DBMS and phpBB 3.2.1 or newer.
++ 	 *
++-	 * @return bool
+++	 * @return array|bool If phpBB 3.3.x, return message as to why it could not be installed.
+++	 *                    Otherwise, just return boolean true/false.
++ 	 */
++ 	public function is_enableable()
++ 	{
++-		return
++-			phpbb_version_compare(PHPBB_VERSION, '3.2.1', '>=');
+++		$db = $this->container->get('dbal.conn');
+++		$valid_db = in_array($db->get_sql_layer(), array('mysqli', 'mysql4', 'postgres'));
+++		$valid_phpBB = phpbb_version_compare(PHPBB_VERSION, '3.2.1', '>=');
+++		$enableable = $valid_db && $valid_phpBB;
+++
+++		// Since showing error messages only works for phpBB 3.3.x, the only message worth showing is
+++		// if the DBMS is incompatible. That is, we can't show somebody on phpBB 3.2.x. the message that
+++		// their board is too old, so there's no reason to handle invalid phpBB version messages here.
+++		if (!$enableable && phpbb_version_compare(PHPBB_VERSION, '3.3.0-b1', '>='))
+++		{
+++			$lang = $this->container->get('language');
+++			$lang->add_lang('acp_similar_topics', 'vse/similartopics');
+++			return array($lang->lang('PST_NO_COMPAT'));
+++		}
+++
+++		return $enableable;
++ 	}
++ }
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/ar/acp_similar_topics.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/language/ar/acp_similar_topics.php"
++index 957faedc6..a0cfa1e72 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/ar/acp_similar_topics.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/language/ar/acp_similar_topics.php"
++@@ -43,7 +43,6 @@ $lang = array_merge($lang, array(
++ 	'PST_EXPLAIN'		=> 'سيتم عرض قائمة بمواضيع متشابهة ( لها علاقة ) في أسفل صفحة الموضوع الذي يتم مُشاهدته.',
++ 	'PST_LEGEND1'		=> 'إعدادات عامة',
++ 	'PST_ENABLE'		=> 'إظهار المواضيع المُتشابهه ',
++-	'PST_ENABLE_EXPLAIN'=> 'Show similar topics in topic discussion threads.',
++ 	'PST_LEGEND2'		=> 'إعدادات التحميل',
++ 	'PST_LIMIT'			=> 'عدد المواضيع المُتشابهه ',
++ 	'PST_LIMIT_EXPLAIN'	=> 'تستطيع هنا تحديد عدد المواضيع المُتشابهه التي سيتم عرضها في صفحة المواضيع. العدد الإفتراضي هو 5 مواضيع.',
++@@ -55,10 +54,8 @@ $lang = array_merge($lang, array(
++ 	'PST_DAYS'			=> 'أيام',
++ 	'PST_CACHE'			=> 'فترة الملفات المؤقتة',
++ 	'PST_CACHE_EXPLAIN'	=> 'سيتم حذف الملفات المؤقتة للمواضيع المُتشابهه بعد تحديد الفترة هنا بالثواني. الصفر يعني تعطيل هذا الخيار.',
++-	'PST_DYNAMIC'		=> 'Display dynamic similar topics',
++-	'PST_DYNAMIC_EXPLAIN'=> 'Show similar topics as users type in the topic title field when creating new topics.',
++ 	'PST_SENSE'			=> 'حساسية البحث',
++-	'PST_SENSE_EXPLAIN'	=> 'حدد درجة حساسية البحث من القيمة 1 و 10. استخدم القيمة الأقل إذا لا تشاهد أي نتائج للمواضيع المُتشابهه. الإعدادات الموصى بها : <samp>%d</samp>',
+++	'PST_SENSE_EXPLAIN'	=> 'حدد درجة حساسية البحث من القيمة 1 و 10. استخدم القيمة الأقل إذا لا تشاهد أي نتائج للمواضيع المُتشابهه. الإعدادات الموصى بها : استخدم القيمة 1 للجداول “phpbb_topics” في قاعدة البيانات InnoDB; استخدم 5 لقاعدة البيانات MyISAM.',
++ 	'PST_LEGEND3'		=> 'إعدادات المنتدى',
++ 	'PST_NOSHOW_LIST'	=> 'لا تعرض في',
++ 	'PST_NOSHOW_TITLE'	=> 'لا تعرض المواضيع المُتشابهه في',
++@@ -67,14 +64,14 @@ $lang = array_merge($lang, array(
++ 	'PST_STANDARD'		=> 'قياسي',
++ 	'PST_ADVANCED'		=> 'متقدم',
++ 	'PST_ADVANCED_TITLE'=> 'انقر  لضبط الإعدادات المتقدمة لـ',
++-	'PST_ADVANCED_EXP'	=> 'تستطيع من هنا تحديد المنتديات التي تريد جلب المواضيع المُتشابهه منها. المواضيع المُتشابهه الموجودة فقط في المنتديات المُحددة ستظهر في <strong>%s</strong>. <br><br>سيتم جلب المواضيع المُتشابهه من جميع المنتديات في حالة عدم تحديد أي منتدى.<br><br>تحديد أو الغاء التحديد يكون بواسطة الضغط باستمرار على زر الكنترول CTRL والنقر على المنتدى المطلوب.',
+++	'PST_ADVANCED_EXP'	=> 'تستطيع من هنا تحديد المنتديات التي تريد جلب المواضيع المُتشابهه منها. المواضيع المُتشابهه الموجودة فقط في المنتديات المُحددة ستظهر في <strong>%s</strong>. <br /><br />سيتم جلب المواضيع المُتشابهه من جميع المنتديات في حالة عدم تحديد أي منتدى.<br /><br />تحديد أو الغاء التحديد يكون بواسطة الضغط باستمرار على زر الكنترول CTRL والنقر على المنتدى المطلوب.',
++ 	'PST_ADVANCED_FORUM'=> 'إعدادات متقدمة للمنتدى',
++ 	'PST_DESELECT_ALL'	=> 'الغاء تحديد الكل',
++ 	'PST_LEGEND4'		=> 'إعدادات اختيارية',
++ 	'PST_WORDS'			=> 'كلمات مُستبعدة',
++ 	'PST_WORDS_EXPLAIN'	=> 'سيتم استبعاد الكلمات التي ستضيفها هنا عند البحث عن المواضيع المُتشابهة. ( ملاحظة : يتم استبعاد الكلمات التي تعتبر شائعة في لغتك بصورة افتراضية ). اعمل مسافة بين كل كلمة وأخرى. هذا الخيار غير دقيق لتطابق الكلمات. الحد الأقصى هو 255 حرف.',
++ 	'PST_SAVED'			=> 'تم تحديث إعدادات المواضيع المُتشابهه',
++-	'PST_FORUM_INFO'	=> '" لا تعرض في " : يعني عدم اظهار المواضيع المُتشابهه في المنتديات المُحددة.<br>" لا تبحث في " : يعني عدم البحث عن المواضيع المُتشابهه في المنتديات المُحددة.',
+++	'PST_FORUM_INFO'	=> '" لا تعرض في " : يعني عدم اظهار المواضيع المُتشابهه في المنتديات المُحددة.<br />" لا تبحث في " : يعني عدم البحث عن المواضيع المُتشابهه في المنتديات المُحددة.',
++ 	'PST_NO_COMPAT'		=> 'إضافة "المواضيع المُتشابهه" لا تتوافق مع منتداك. فهي تعمل فقط على قاعدة البيانات MySQL 4 أو MySQL 5 أو PostgreSQL.',
++ 	'PST_ERR_CONFIG'	=> 'أيضا تميزت العديد من المنتديات في قائمة من المنتديات. يرجى المحاولة مرة أخرى مع مجموعة أصغر.',
++ ));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/cs/acp_similar_topics.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/language/cs/acp_similar_topics.php"
++index d80b5ea61..f221da47a 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/cs/acp_similar_topics.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/language/cs/acp_similar_topics.php"
++@@ -42,7 +42,6 @@ $lang = array_merge($lang, array(
++ 	'PST_EXPLAIN'		=> 'Toto rozšíření zobrazí na spodu každého tématu odkazy na několik podobných (souvisejících) témat.',
++ 	'PST_LEGEND1'		=> 'Hlavní nastavení',
++ 	'PST_ENABLE'		=> 'Zobrazit podobná témata',
++-	'PST_ENABLE_EXPLAIN'=> 'Show similar topics in topic discussion threads.',
++ 	'PST_LEGEND2'		=> 'Nastavení zatížení',
++ 	'PST_LIMIT'			=> 'Počet podobných témat',
++ 	'PST_LIMIT_EXPLAIN'	=> 'Zde můžete zvolit počet podobných témat, která se zobrazí. Výchozí nastavení je 5 témat.',
++@@ -54,10 +53,8 @@ $lang = array_merge($lang, array(
++ 	'PST_DAYS'			=> 'Dny',
++ 	'PST_CACHE'			=> 'Životnost cache',
++ 	'PST_CACHE_EXPLAIN'	=> 'Cache podobných témat se vyprázdní po daném čase (v sekundách). Pokud nastavíte na 0, cache bude vypnuta.',
++-	'PST_DYNAMIC'		=> 'Display dynamic similar topics',
++-	'PST_DYNAMIC_EXPLAIN'=> 'Show similar topics as users type in the topic title field when creating new topics.',
++ 	'PST_SENSE'			=> 'Search sensitivity',
++-	'PST_SENSE_EXPLAIN'	=> 'For MySQL or Postgres databases, you can set the search sensitivity to a value between 1 and 10. Use a lower number if you are not seeing any similar topics. Recommended setting: %d',
+++	'PST_SENSE_EXPLAIN'	=> 'Set the search sensitivity to a value between 1 and 10. Use a lower number if you are not seeing any similar topics. Recommended settings: For “phpbb_topics” database tables using InnoDB use 1; for MyISAM use 5.',
++ 	'PST_LEGEND3'		=> 'Nastavení fór',
++ 	'PST_NOSHOW_LIST'	=> 'Nezobrazovat',
++ 	'PST_NOSHOW_TITLE'	=> 'Nezobrazovat podobná témata v',
++@@ -66,14 +63,14 @@ $lang = array_merge($lang, array(
++ 	'PST_STANDARD'		=> 'Standartní',
++ 	'PST_ADVANCED'		=> 'Rozšířené',
++ 	'PST_ADVANCED_TITLE'=> 'Kliknutím provedete rozšířená nastavení pro fórum',
++-	'PST_ADVANCED_EXP'	=> 'Zde můžete vybrat pouze určité sekce, ve kterých chcete, aby se podobná témata vyhledávala. Poté budou v sekci <strong>%s</strong> zobrazena pouze podobná témata z těchto vybraných fór.<br><br>Pokud nevyberete žádná fóra, rozšíření bude podobná témata vyhledávat po celém fóru.<br><br>Výběr více fór můžete provést se stisknoutou klávesou <code>CTRL</code> (případně <code>CMD</code> pro Mac).',
+++	'PST_ADVANCED_EXP'	=> 'Zde můžete vybrat pouze určité sekce, ve kterých chcete, aby se podobná témata vyhledávala. Poté budou v sekci <strong>%s</strong> zobrazena pouze podobná témata z těchto vybraných fór.<br /><br />Pokud nevyberete žádná fóra, rozšíření bude podobná témata vyhledávat po celém fóru.<br /><br />Výběr více fór můžete provést se stisknoutou klávesou <code>CTRL</code> (případně <code>CMD</code> pro Mac).',
++ 	'PST_ADVANCED_FORUM'=> 'Rozšířené nastavení fóra',
++ 	'PST_DESELECT_ALL'	=> 'Zrušit výběr všech',
++ 	'PST_LEGEND4'		=> 'Volitelná nastavení',
++ 	'PST_WORDS'			=> 'Ignorovaná slova',
++ 	'PST_WORDS_EXPLAIN'	=> 'Zde můžete uvést seznam slov, u kterých si přejete, aby se při vyhledávání podobných témat ignorovala. (Pozn.: Slova, která jsou ve vašem jazyce považována za běžná, uvádět nemusíte (jsou ignorována automaticky). Jednotlivá slova oddělte mezerou. Nezáleží na velikosti písmen.',
++ 	'PST_SAVED'			=> 'Nastavení podobných témat bylo úspěšně změněno',
++-	'PST_FORUM_INFO'	=> '“Nezobrazovat”: Nebude ve vybraných fórech zobrazovat podobná témata.<br>“Nevyhledávat” : Ve vybraných fórech se nebudou vyhledávat podobná témata.',
+++	'PST_FORUM_INFO'	=> '“Nezobrazovat”: Nebude ve vybraných fórech zobrazovat podobná témata.<br />“Nevyhledávat” : Ve vybraných fórech se nebudou vyhledávat podobná témata.',
++ 	'PST_NO_COMPAT'		=> 'Podobná témata nejsou kompatibilní s vašim fórem. Jsou vyžadovány technologie MySQL 4 nebo MySQL 5 nebo PostgreSQL.',
++ 	'PST_ERR_CONFIG'	=> 'Z hledání/zobrazení bylo vyřazeno příliš mnoho sekcí. Snižte prosím počet vybraných sekcí.',
++ ));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/de/acp_similar_topics.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/language/de/acp_similar_topics.php"
++index 12b4466c7..0b2b7f4e5 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/de/acp_similar_topics.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/language/de/acp_similar_topics.php"
++@@ -42,7 +42,6 @@ $lang = array_merge($lang, array(
++ 	'PST_EXPLAIN'		=> 'Präzise Vergleichbare Themen zeigt eine Liste von ähnlichen Themen am unteren Rand des aktuellen Themas der Seite.',
++ 	'PST_LEGEND1'		=> 'Allgemeine Einstellungen',
++ 	'PST_ENABLE'		=> 'Aktiviere Vergleichbare Themen',
++-	'PST_ENABLE_EXPLAIN'=> 'Show similar topics in topic discussion threads.',
++ 	'PST_LEGEND2'		=> 'Lade Einstellungen',
++ 	'PST_LIMIT'			=> 'Anzahl der angezeigten Vergleichbaren Themen',
++ 	'PST_LIMIT_EXPLAIN'	=> 'Hier kannst du einstellen, wieviel Vergleichbare Themen angezeigt werden sollen. Standard sind 5 Themen.',
++@@ -54,10 +53,8 @@ $lang = array_merge($lang, array(
++ 	'PST_DAYS'			=> 'Tage',
++ 	'PST_CACHE'			=> 'Zeitraum der Zwischenspeicherung für Vergleichbare Themen',
++ 	'PST_CACHE_EXPLAIN'	=> 'Zwischengespeichterte Vergleichbare Themen werden nach dieser Zeit verfallen. In Sekunden angeben. Auf 0 setzen, wenn du den Zwichenspeicher deaktivieren willst.',
++-	'PST_DYNAMIC'		=> 'Display dynamic similar topics',
++-	'PST_DYNAMIC_EXPLAIN'=> 'Show similar topics as users type in the topic title field when creating new topics.',
++ 	'PST_SENSE'			=> 'Search sensitivity',
++-	'PST_SENSE_EXPLAIN'	=> 'For MySQL or Postgres databases, you can set the search sensitivity to a value between 1 and 10. Use a lower number if you are not seeing any similar topics. Recommended setting: %d',
+++	'PST_SENSE_EXPLAIN'	=> 'Set the search sensitivity to a value between 1 and 10. Use a lower number if you are not seeing any similar topics. Recommended settings: For “phpbb_topics” database tables using InnoDB use 1; for MyISAM use 5.',
++ 	'PST_LEGEND3'		=> 'Foren',
++ 	'PST_NOSHOW_LIST'	=> 'Nicht anzeigen in',
++ 	'PST_NOSHOW_TITLE'	=> 'Vergleichbare Themen nicht anzeigen in',
++@@ -66,14 +63,14 @@ $lang = array_merge($lang, array(
++ 	'PST_STANDARD'		=> 'Standard',
++ 	'PST_ADVANCED'		=> 'Erweiterte Einstellungen',
++ 	'PST_ADVANCED_TITLE'=> 'Klicken um erweiterte Einstellungen für Vergleichbare Themen vorzunehmen',
++-	'PST_ADVANCED_EXP'	=> 'Hier kannst du spezifische Foren auswählen aus denen Vergleichbare Themen angezeigt werden sollen. Es werden nur Vergleichbare Themen in Foren, die du die hier einstellst, angezeigt <strong>%s</strong>.<br><br>Wählen keine Foren, wenn Vergleichbare Themen aus allen durchsuchbaren Foren in diesem Forum angezeigt werden sollen.<br><br>Wähle mehrere Foren aus/ab, indem du beim Klicken die <code>Strg</code>-Taste drückst.',
+++	'PST_ADVANCED_EXP'	=> 'Hier kannst du spezifische Foren auswählen aus denen Vergleichbare Themen angezeigt werden sollen. Es werden nur Vergleichbare Themen in Foren, die du die hier einstellst, angezeigt <strong>%s</strong>.<br /><br />Wählen keine Foren, wenn Vergleichbare Themen aus allen durchsuchbaren Foren in diesem Forum angezeigt werden sollen.<br /><br />Wähle mehrere Foren aus/ab, indem du beim Klicken die <code>Strg</code>-Taste drückst.',
++ 	'PST_ADVANCED_FORUM'=> 'Erweiterte Foren Einstellungen',
++ 	'PST_DESELECT_ALL'	=> 'Alle abwählen',
++ 	'PST_LEGEND4'		=> 'Optionale Einstellungen',
++ 	'PST_WORDS'			=> 'Spezielle Wörter zu ignorieren',
++ 	'PST_WORDS_EXPLAIN'	=> 'Füge Wörter hinzu, die speziell in deinem Forum häufig vorkommen und deshalb ignoriert werden sollen. (Hinweis: Wörter, die derzeit in deiner Sprache als häufig angesehen werden, werden bereits standardmäßig ignoriert.) Trenne die Worte mit Leerzeichen, Groß-/Kleinschreibung wird ignoriert.',
++ 	'PST_SAVED'			=> 'Einstellungen für Vergleichbare Themen aktualisiert',
++-	'PST_FORUM_INFO'	=> '“Nicht anzeigen in”: Wird die Anzeige von Vergleichbaren Themen in den ausgewählten Foren deaktivieren.<br>“Nicht Suchen Nach in” : Wird die ausgewählten Foren bei der Suche nach Vergleichbaren Themen ignorieren.',
+++	'PST_FORUM_INFO'	=> '“Nicht anzeigen in”: Wird die Anzeige von Vergleichbaren Themen in den ausgewählten Foren deaktivieren.<br />“Nicht Suchen Nach in” : Wird die ausgewählten Foren bei der Suche nach Vergleichbaren Themen ignorieren.',
++ 	'PST_NO_COMPAT'		=> 'Vergleichbare Themen werden in diesem Forum nicht funktionieren. Vergleichbare Themen erfordert eine MySQL 4 oder MySQL 5 oder PostgreSQL Datenbank.',
++ 	'PST_ERR_CONFIG'	=> 'Zu viele Foren wurden in die Liste der Foren markiert. Bitte versuchen Sie es mit einer kleineren Auswahl.',
++ ));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/el/acp_similar_topics.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/language/el/acp_similar_topics.php"
++index ebd97602d..7f8ed8260 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/el/acp_similar_topics.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/language/el/acp_similar_topics.php"
++@@ -42,7 +42,6 @@ $lang = array_merge($lang, array(
++ 	'PST_EXPLAIN'		=> 'Εμφανίζει μια λίστα παραπλήσιων (συναφών) θεμάτων στο τέλος της τρέχουσας σελίδας θέματος.',
++ 	'PST_LEGEND1'		=> 'Γενικές ρυθμίσεις',
++ 	'PST_ENABLE'		=> 'Εμφάνιση παραπλήσιων θεμάτων',
++-	'PST_ENABLE_EXPLAIN'=> 'Show similar topics in topic discussion threads.',
++ 	'PST_LEGEND2'		=> 'Ρυθμίσεις εμφάνισης',
++ 	'PST_LIMIT'			=> 'Αριθμός παραπλήσιων θεμάτων που θα εμφανίζονται',
++ 	'PST_LIMIT_EXPLAIN'	=> 'Εδώ μπορείτε να ορίσετε πόσα παραπλήσια θέματα θα εμφανίζονται. Η προεπιλογή είναι 5 θέματα.',
++@@ -54,10 +53,8 @@ $lang = array_merge($lang, array(
++ 	'PST_DAYS'			=> 'Ημέρες',
++ 	'PST_CACHE'			=> 'Μέγεθος μνήμης παραπλήσιων θεμάτων',
++ 	'PST_CACHE_EXPLAIN'	=> 'Η αποθηκευμένη μνήμη παραπλήσιων θεμάτων θα λήξει μετά από αυτό το διάστημα, σε δευτερόλεπτα. Θέστε σε "0" αν θέλετε να απενεργοποιήσετε την αποθηκευμένη μνήμη παραπλήσιων θεμάτων.',
++-	'PST_DYNAMIC'		=> 'Display dynamic similar topics',
++-	'PST_DYNAMIC_EXPLAIN'=> 'Show similar topics as users type in the topic title field when creating new topics.',
++ 	'PST_SENSE'			=> 'Ευαισθησία αναζήτησης',
++-	'PST_SENSE_EXPLAIN'	=> 'Ρυθμίστε την ευαισθησία αναζήτησης σε μια τιμή μεταξύ 1 και 10. Χρησιμοποιήστε μικρότερο αριθμό εάν δεν βλέπετε παρόμοια θέματα. Προτεινόμενες ρυθμίσεις: %d',
+++	'PST_SENSE_EXPLAIN'	=> 'Ρυθμίστε την ευαισθησία αναζήτησης σε μια τιμή μεταξύ 1 και 10. Χρησιμοποιήστε μικρότερο αριθμό εάν δεν βλέπετε παρόμοια θέματα. Προτεινόμενες ρυθμίσεις: Για πίνακες βάσης δεδομένων "phpbb_topics" τύπου InnoDB χρησιμοποιείστε 1, για MyISAM χρησιμοποιείστε 5.',
++ 	'PST_LEGEND3'		=> 'Ρυθμίσεις Δημ. Συζήτησης',
++ 	'PST_NOSHOW_LIST'	=> 'Να μην εμφανίζονται σε',
++ 	'PST_NOSHOW_TITLE'	=> 'Να μην εμφανίζονται παραπλήσια θέματα σε',
++@@ -66,14 +63,14 @@ $lang = array_merge($lang, array(
++ 	'PST_STANDARD'		=> 'Τυπικές',
++ 	'PST_ADVANCED'		=> 'Σύνθετες',
++ 	'PST_ADVANCED_TITLE'=> 'Πατήστε για περισσότερες ρυθμίσεις παραπλήσιων θεμάτων στο θέμα',
++-	'PST_ADVANCED_EXP'	=> 'Εδώ μπορείτε να επιλέξετε συγκεκριμένες Δημ. Συζητήσεις από τις οποίες θα τραβήξει παραπλήσια θέματα. Μόνο παραπλήσια θέματα που βρέθηκαν στις Δημ. Συζητήσεις που επιλέγετε εδώ θα εμφανιστούν στην ενότητα <strong>%s</strong>.<br><br>Μην επιλέξετε καμία Δημ. Συζήτηση, αν θέλετε παραπλήσια θέματα από όλες τις Δημ. Συζητήσεις να εμφανίζονται σε αυτή τη Δημ. Συζήτηση.<br><br>Για να επιλέξτε/αποεπιλέξτε πολλές Δ. Συζητήσεις κρατήστε πατημένο το <code>CTRL</code> και κάντε κλικ.',
+++	'PST_ADVANCED_EXP'	=> 'Εδώ μπορείτε να επιλέξετε συγκεκριμένες Δημ. Συζητήσεις από τις οποίες θα τραβήξει παραπλήσια θέματα. Μόνο παραπλήσια θέματα που βρέθηκαν στις Δημ. Συζητήσεις που επιλέγετε εδώ θα εμφανιστούν στην ενότητα <strong>%s</strong>.<br /><br />Μην επιλέξετε καμία Δημ. Συζήτηση, αν θέλετε παραπλήσια θέματα από όλες τις Δημ. Συζητήσεις να εμφανίζονται σε αυτή τη Δημ. Συζήτηση.<br /><br />Για να επιλέξτε/αποεπιλέξτε πολλές Δ. Συζητήσεις κρατήστε πατημένο το <code>CTRL</code> και κάντε κλικ.',
++ 	'PST_ADVANCED_FORUM'=> 'Σύνθετες ρυθμίσεις',
++ 	'PST_DESELECT_ALL'	=> 'Αποεπιλογή όλων',
++ 	'PST_LEGEND4'		=> 'Προαιρετκές ρυθμίσεις',
++ 	'PST_WORDS'			=> 'Ειδικές λέξεις για αγνόηση',
++ 	'PST_WORDS_EXPLAIN'	=> 'Προσθέστε ειδικές λέξεις μοναδικές στη Δ. Συζήτησή σας, που θέλετε να αγνοηθούν κατά την εύρεση παραπλήσιων θεμάτων. (Σημείωση: Οι λέξεις που  σήμερα θεωρούνται κοινές στη γλώσσα σας αγνοούνται από προεπιλογή.) Χωρίστε κάθε λέξη με ένα κενό. Με πεζά ή κεφαλαία.',
++ 	'PST_SAVED'			=> 'Οι ρυθμίσεις των Παραπλήσιων Θεμάτων ενημερώθηκαν',
++-	'PST_FORUM_INFO'	=> '"Να μην εμφανίζονται σε": Δεν θα εμφανίζονται παραπλήσια θέματα στις επιλεγμένες Δημ. Συζητήσεις.<br>"Να μην αναζητούνται σε": Δεν θα αναζητούνται παραπλήσια θέματα στις επιλεγμένες Δημ. Συζητήσεις.',
+++	'PST_FORUM_INFO'	=> '"Να μην εμφανίζονται σε": Δεν θα εμφανίζονται παραπλήσια θέματα στις επιλεγμένες Δημ. Συζητήσεις.<br />"Να μην αναζητούνται σε": Δεν θα αναζητούνται παραπλήσια θέματα στις επιλεγμένες Δημ. Συζητήσεις.',
++ 	'PST_NO_COMPAT'		=> 'Το "Παραπλήσια Θέματα" δεν είναι συμβατό με τη Δ. Συζήτησή σας. Μπορεί να λειτουργήσει μόνο σε βάσεις δεδομένων με MySQL 4 ή MySQL 5 ή PostgreSQL.',
++ 	'PST_ERR_CONFIG'	=> 'Too many forums were marked in the list of forums. Please try again with a smaller selection.',
++ ));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/en/acp_similar_topics.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/language/en/acp_similar_topics.php"
++index c8fed39b9..2807c9f00 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/en/acp_similar_topics.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/language/en/acp_similar_topics.php"
++@@ -39,25 +39,22 @@ if (empty($lang) || !is_array($lang))
++ 
++ $lang = array_merge($lang, array(
++ 	'PST_TITLE_ACP'		=> 'Precise Similar Topics',
++-	'PST_EXPLAIN'		=> 'Precise Similar Topics displays a list of similar (related) topics. Similar topics can be shown at the bottom of the current topic’s discussion thread and/or when a user is writing a title for a new post.',
+++	'PST_EXPLAIN'		=> 'Precise Similar Topics displays a list of similar (related) topics at the bottom of the current topic’s page.',
++ 	'PST_LEGEND1'		=> 'General settings',
++-	'PST_ENABLE'		=> 'Display similar topics',
++-	'PST_ENABLE_EXPLAIN'=> 'Show similar topics in topic discussion threads.',
+++	'PST_ENABLE'		=> 'Display Similar Topics',
++ 	'PST_LEGEND2'		=> 'Load settings',
++-	'PST_LIMIT'			=> 'Number of similar topics to display',
+++	'PST_LIMIT'			=> 'Number of Similar Topics to display',
++ 	'PST_LIMIT_EXPLAIN'	=> 'Here you can define how many similar topics to display. The default is 5 topics.',
++ 	'PST_TIME'			=> 'Search period',
++-	'PST_TIME_EXPLAIN'	=> 'This option allows you to confine similar topics results to newer topics (and prevent reviving old threads). For example, if set to “30 days” the system will only show similar topics from within the last 30 days. The default is 1 year. Set it to 99 years if you want to effectively disable this feature.',
+++	'PST_TIME_EXPLAIN'	=> 'This option allows you to confine Similar Topics results to newer topics (and prevent reviving old threads). For example, if set to “30 days” the system will only show similar topics from within the last 30 days. The default is 1 year. Set it to 99 years if you want to effectively disable this feature.',
++ 	'PST_YEARS'			=> 'Years',
++ 	'PST_MONTHS'		=> 'Months',
++ 	'PST_WEEKS'			=> 'Weeks',
++ 	'PST_DAYS'			=> 'Days',
++-	'PST_CACHE'			=> 'Similar topics cache length',
+++	'PST_CACHE'			=> 'Similar Topics cache length',
++ 	'PST_CACHE_EXPLAIN'	=> 'Cached similar topics will expire after this time, in seconds. Set to 0 if you want to disable the similar topics cache.',
++-	'PST_DYNAMIC'		=> 'Display dynamic similar topics',
++-	'PST_DYNAMIC_EXPLAIN'=> 'Show similar topics as users type in the topic title field when creating new topics.',
++ 	'PST_SENSE'			=> 'Search sensitivity',
++-	'PST_SENSE_EXPLAIN'	=> 'For MySQL or Postgres databases, you can set the search sensitivity to a value between 1 and 10. Use a lower number if you are not seeing any similar topics. Recommended setting: %d',
+++	'PST_SENSE_EXPLAIN'	=> 'Set the search sensitivity to a value between 1 and 10. Use a lower number if you are not seeing any similar topics. Recommended settings: For “phpbb_topics” database tables using InnoDB use 1; for MyISAM use 5.',
++ 	'PST_LEGEND3'		=> 'Forum settings',
++ 	'PST_NOSHOW_LIST'	=> 'Do Not Display In',
++ 	'PST_NOSHOW_TITLE'	=> 'Do not display similar topics in',
++@@ -66,14 +63,14 @@ $lang = array_merge($lang, array(
++ 	'PST_STANDARD'		=> 'Standard',
++ 	'PST_ADVANCED'		=> 'Advanced',
++ 	'PST_ADVANCED_TITLE'=> 'Click to set up advanced similar topic settings for',
++-	'PST_ADVANCED_EXP'	=> 'Here you can select specific forums to pull similar topics from. Only similar topics found in the forums you select here will be displayed in <strong>%s</strong>.<br><br>Do not select any forums if you want similar topics from all searchable forums to be displayed in this forum.<br><br>Select multiple forums by holding <samp>CTRL</samp> (or <samp>&#8984;CMD</samp> on Mac) and clicking.',
+++	'PST_ADVANCED_EXP'	=> 'Here you can select specific forums to pull similar topics from. Only similar topics found in the forums you select here will be displayed in <strong>%s</strong>.<br /><br />Do not select any forums if you want similar topics from all searchable forums to be displayed in this forum.<br /><br />Select multiple forums by holding <samp>CTRL</samp> (or <samp>&#8984;CMD</samp> on Mac) and clicking.',
++ 	'PST_ADVANCED_FORUM'=> 'Advanced forum settings',
++ 	'PST_DESELECT_ALL'	=> 'Deselect all',
++ 	'PST_LEGEND4'		=> 'Optional settings',
++ 	'PST_WORDS'			=> 'Special words to ignore',
++ 	'PST_WORDS_EXPLAIN'	=> 'Add special words unique to your forum that should be ignored when finding similar topics. (Note: Words that are currently regarded as common in your language are already ignored by default.) Separate each word with a space. Case insensitive.',
++-	'PST_SAVED'			=> 'Precise Similar Topics settings updated',
++-	'PST_FORUM_INFO'	=> '“Do Not Display In”: Will not show similar topics in the selected forums.<br>“Do Not Search In” : Will not search for similar topics in the selected forums.',
++-	'PST_NO_COMPAT'		=> 'Precise Similar Topics is not compatible with your forum.',
+++	'PST_SAVED'			=> 'Similar Topics settings updated',
+++	'PST_FORUM_INFO'	=> '“Do Not Display In”: Will not show similar topics in the selected forums.<br />“Do Not Search In” : Will not search for similar topics in the selected forums.',
+++	'PST_NO_COMPAT'		=> 'Similar Topics is not compatible with your forum. Similar Topics will only run on a MySQL or PostgreSQL database.',
++ 	'PST_ERR_CONFIG'	=> 'Too many forums were marked in the list of forums. Please try again with a smaller selection.',
++ ));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/en/search_ignore_words.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/en/search_ignore_words.php"
++deleted file mode 100644
++index 82f50a7d3..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/en/search_ignore_words.php"
+++++ /dev/null
++@@ -1,598 +0,0 @@
++-<?php
++-/**
++- *
++- * Precise Similar Topics
++- *
++- * @copyright (c) 2025 Matt Friedman
++- * @license GNU General Public License, version 2 (GPL-2.0)
++- *
++- * This [en] language list of stop words created by Matt Friedman for Similar Topics
++- *
++- */
++-
++-if (!defined('IN_PHPBB'))
++-{
++-	exit;
++-}
++-
++-$words = array(
++-	'a',
++-	'able',
++-	'about',
++-	'above',
++-	'according',
++-	'accordingly',
++-	'across',
++-	'actually',
++-	'afaik',
++-	'after',
++-	'afterwards',
++-	'again',
++-	'against',
++-	'ago',
++-	'aint',
++-	'all',
++-	'allow',
++-	'allows',
++-	'almost',
++-	'alone',
++-	'along',
++-	'alot',
++-	'already',
++-	'also',
++-	'although',
++-	'always',
++-	'am',
++-	'among',
++-	'amongst',
++-	'an',
++-	'and',
++-	'another',
++-	'answer',
++-	'any',
++-	'anybody',
++-	'anybodys',
++-	'anyhow',
++-	'anyone',
++-	'anything',
++-	'anyway',
++-	'anyways',
++-	'anywhere',
++-	'apart',
++-	'appear',
++-	'appreciate',
++-	'appropriate',
++-	'are',
++-	'arent',
++-	'around',
++-	'as',
++-	'aside',
++-	'ask',
++-	'askd',
++-	'asking',
++-	'associated',
++-	'at',
++-	'available',
++-	'away',
++-	'awfully',
++-	'bad',
++-	'be',
++-	'became',
++-	'because',
++-	'become',
++-	'becomes',
++-	'becoming',
++-	'been',
++-	'before',
++-	'beforehand',
++-	'behind',
++-	'being',
++-	'believe',
++-	'below',
++-	'beside',
++-	'besides',
++-	'best',
++-	'better',
++-	'between',
++-	'beyond',
++-	'big',
++-	'both',
++-	'brief',
++-	'btw',
++-	'but',
++-	'by',
++-	'came',
++-	'can',
++-	'cant',
++-	'cannot',
++-	'cause',
++-	'causes',
++-	'certain',
++-	'certainly',
++-	'changes',
++-	'clearly',
++-	'co',
++-	'com',
++-	'come',
++-	'comes',
++-	'concerning',
++-	'consequently',
++-	'consider',
++-	'considering',
++-	'contain',
++-	'containing',
++-	'contains',
++-	'corresponding',
++-	'could',
++-	'couldnt',
++-	'course',
++-	'currently',
++-	'day',
++-	'days',
++-	'definitely',
++-	'described',
++-	'despite',
++-	'did',
++-	'didnt',
++-	'different',
++-	'do',
++-	'does',
++-	'doesnt',
++-	'doing',
++-	'done',
++-	'dont',
++-	'down',
++-	'downwards',
++-	'during',
++-	'each',
++-	'edu',
++-	'eg',
++-	'eight',
++-	'either',
++-	'else',
++-	'elsewhere',
++-	'enough',
++-	'entirely',
++-	'especially',
++-	'et',
++-	'etc',
++-	'even',
++-	'ever',
++-	'every',
++-	'everybody',
++-	'everybodys',
++-	'everyone',
++-	'everything',
++-	'everywhere',
++-	'ex',
++-	'exactly',
++-	'example',
++-	'except',
++-	'far',
++-	'few',
++-	'fifth',
++-	'find',
++-	'first',
++-	'five',
++-	'followed',
++-	'following',
++-	'follows',
++-	'for',
++-	'former',
++-	'formerly',
++-	'forth',
++-	'found',
++-	'four',
++-	'from',
++-	'further',
++-	'furthermore',
++-	'get',
++-	'gets',
++-	'getting',
++-	'given',
++-	'gives',
++-	'go',
++-	'goes',
++-	'going',
++-	'gone',
++-	'good',
++-	'got',
++-	'gotten',
++-	'greetings',
++-	'had',
++-	'hadnt',
++-	'happens',
++-	'hardly',
++-	'has',
++-	'hasnt',
++-	'have',
++-	'havent',
++-	'having',
++-	'he',
++-	'hello',
++-	'help',
++-	'hence',
++-	'her',
++-	'here',
++-	'hereafter',
++-	'hereby',
++-	'herein',
++-	'hereupon',
++-	'hers',
++-	'herself',
++-	'hi',
++-	'him',
++-	'himself',
++-	'his',
++-	'hither',
++-	'hopefully',
++-	'how',
++-	'howbeit',
++-	'however',
++-	'hows',
++-	'href',
++-	'i',
++-	'id',
++-	'ie',
++-	'if',
++-	'ignored',
++-	'iirc',
++-	'immediate',
++-	'in',
++-	'inasmuch',
++-	'inc',
++-	'indeed',
++-	'indicate',
++-	'indicated',
++-	'indicates',
++-	'ini',
++-	'inner',
++-	'insofar',
++-	'instead',
++-	'into',
++-	'inward',
++-	'is',
++-	'isnt',
++-	'it',
++-	'itd',
++-	'itll',
++-	'its',
++-	'itself',
++-	'ive',
++-	'just',
++-	'keep',
++-	'keeps',
++-	'kept',
++-	'know',
++-	'known',
++-	'knows',
++-	'large',
++-	'last',
++-	'lately',
++-	'later',
++-	'latter',
++-	'latterly',
++-	'least',
++-	'less',
++-	'lest',
++-	'let',
++-	'lets',
++-	'like',
++-	'liked',
++-	'likely',
++-	'little',
++-	'look',
++-	'looked',
++-	'looking',
++-	'looks',
++-	'lot',
++-	'ltd',
++-	'mainly',
++-	'many',
++-	'may',
++-	'maybe',
++-	'mean',
++-	'meanwhile',
++-	'me',
++-	'merely',
++-	'might',
++-	'more',
++-	'moreover',
++-	'most',
++-	'mostly',
++-	'much',
++-	'must',
++-	'mustnt',
++-	'my',
++-	'myself',
++-	'name',
++-	'namely',
++-	'nd',
++-	'near',
++-	'nearly',
++-	'necessary',
++-	'need',
++-	'needs',
++-	'never',
++-	'nevertheless',
++-	'new',
++-	'news',
++-	'next',
++-	'nine',
++-	'no',
++-	'nobody',
++-	'non',
++-	'none',
++-	'noone',
++-	'nor',
++-	'normally',
++-	'not',
++-	'nothing',
++-	'novel',
++-	'now',
++-	'nowhere',
++-	'obviously',
++-	'of',
++-	'off',
++-	'often',
++-	'oh',
++-	'ok',
++-	'okay',
++-	'old',
++-	'on',
++-	'once',
++-	'one',
++-	'ones',
++-	'only',
++-	'onto',
++-	'oops',
++-	'or',
++-	'other',
++-	'others',
++-	'otherwise',
++-	'ought',
++-	'our',
++-	'ours',
++-	'ourselves',
++-	'out',
++-	'outside',
++-	'over',
++-	'overall',
++-	'own',
++-	'page',
++-	'particular',
++-	'particularly',
++-	'per',
++-	'perhaps',
++-	'placed',
++-	'please',
++-	'plus',
++-	'possible',
++-	'presumably',
++-	'probably',
++-	'provides',
++-	'put',
++-	'que',
++-	'question',
++-	'questioned',
++-	'questions',
++-	'quite',
++-	'qv',
++-	'quote',
++-	'rather',
++-	'rd',
++-	're',
++-	'really',
++-	'reasonably',
++-	'recent',
++-	'regarding',
++-	'regardless',
++-	'regards',
++-	'relatively',
++-	'respectively',
++-	'right',
++-	'rotf',
++-	'rotflmao',
++-	'said',
++-	'same',
++-	'saw',
++-	'say',
++-	'saying',
++-	'says',
++-	'second',
++-	'secondly',
++-	'see',
++-	'seeing',
++-	'seem',
++-	'seemed',
++-	'seeming',
++-	'seems',
++-	'seen',
++-	'see',
++-	'self',
++-	'selves',
++-	'sensible',
++-	'sent',
++-	'serious',
++-	'seriously',
++-	'seven',
++-	'several',
++-	'shall',
++-	'she',
++-	'should',
++-	'shouldnt',
++-	'since',
++-	'sites',
++-	'six',
++-	'small',
++-	'so',
++-	'some',
++-	'somebody',
++-	'somehow',
++-	'someone',
++-	'something',
++-	'sometime',
++-	'sometimes',
++-	'somewhat',
++-	'somewhere',
++-	'soon',
++-	'sorry',
++-	'specified',
++-	'specify',
++-	'specifying',
++-	'still',
++-	'sub',
++-	'such',
++-	'sup',
++-	'sure',
++-	't',
++-	'take',
++-	'taken',
++-	'tell',
++-	'tends',
++-	'than',
++-	'thank',
++-	'thanks',
++-	'thanx',
++-	'that',
++-	'thatd',
++-	'thats',
++-	'the',
++-	'their',
++-	'theirs',
++-	'them',
++-	'themselves',
++-	'then',
++-	'thence',
++-	'there',
++-	'thereafter',
++-	'thereby',
++-	'therefore',
++-	'therein',
++-	'theres',
++-	'thereupon',
++-	'these',
++-	'they',
++-	'theyd',
++-	'theyll',
++-	'theyre',
++-	'theyve',
++-	'think',
++-	'third',
++-	'this',
++-	'thorough',
++-	'thoroughly',
++-	'those',
++-	'though',
++-	'three',
++-	'through',
++-	'throughout',
++-	'thru',
++-	'thus',
++-	'time',
++-	'times',
++-	'to',
++-	'together',
++-	'too',
++-	'took',
++-	'toward',
++-	'towards',
++-	'tried',
++-	'tries',
++-	'truly',
++-	'try',
++-	'trying',
++-	'twice',
++-	'two',
++-	'un',
++-	'under',
++-	'unfortunately',
++-	'unless',
++-	'unlikely',
++-	'until',
++-	'untrue',
++-	'unto',
++-	'up',
++-	'upon',
++-	'us',
++-	'use',
++-	'used',
++-	'useful',
++-	'users',
++-	'uses',
++-	'using',
++-	'usually',
++-	'value',
++-	'various',
++-	'version',
++-	'very',
++-	'via',
++-	'viz',
++-	'vs',
++-	'want',
++-	'wants',
++-	'was',
++-	'wasnt',
++-	'way',
++-	'we',
++-	'wed',
++-	'well',
++-	'were',
++-	'werent',
++-	'weve',
++-	'welcome',
++-	'went',
++-	'what',
++-	'whats',
++-	'whatever',
++-	'when',
++-	'whence',
++-	'whenever',
++-	'where',
++-	'wheres',
++-	'whereafter',
++-	'whereas',
++-	'whereby',
++-	'wherein',
++-	'whereupon',
++-	'wherever',
++-	'whether',
++-	'which',
++-	'while',
++-	'whither',
++-	'who',
++-	'whos',
++-	'whoever',
++-	'whole',
++-	'whom',
++-	'whose',
++-	'why',
++-	'wide',
++-	'will',
++-	'willing',
++-	'wish',
++-	'with',
++-	'within',
++-	'without',
++-	'wont',
++-	'wonder',
++-	'world',
++-	'worse',
++-	'worst',
++-	'would',
++-	'wouldnt',
++-	'wrote',
++-	'www',
++-	'yes',
++-	'yet',
++-	'ymmv',
++-	'you',
++-	'youd',
++-	'youll',
++-	'your',
++-	'youre',
++-	'yours',
++-	'yourself',
++-	'yourselves',
++-	'zero'
++-);
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/es/acp_similar_topics.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/language/es/acp_similar_topics.php"
++index ce1f32188..0f85f3882 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/es/acp_similar_topics.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/language/es/acp_similar_topics.php"
++@@ -42,7 +42,6 @@ $lang = array_merge($lang, array(
++ 	'PST_EXPLAIN'		=> 'Hilos Parecidos Precisos muestra una lista de temas similares en la parte inferior de la página del tema actual.',
++ 	'PST_LEGEND1'		=> 'Configuración general',
++ 	'PST_ENABLE'		=> 'Habilitar Hilos Parecidos',
++-	'PST_ENABLE_EXPLAIN'=> 'Show similar topics in topic discussion threads.',
++ 	'PST_LEGEND2'		=> 'Cargar configuración',
++ 	'PST_LIMIT'			=> 'Número de Hilos Parecidos que deben mostrarse',
++ 	'PST_LIMIT_EXPLAIN'	=> 'Aquí puedes definir cuántos Hilos (mensajes) Parecidos deben mostrarse. El número por defecto es 5 hilos.',
++@@ -54,10 +53,8 @@ $lang = array_merge($lang, array(
++ 	'PST_DAYS'			=> 'Días',
++ 	'PST_CACHE'			=> 'Longitud de la caché de Hilos Parecidos',
++ 	'PST_CACHE_EXPLAIN'	=> 'La caché de hilos parecidos expirará después del tiempo indicado, en segundos. Ponlo a 0 si quieres deshabilitar la caché de hilos parecidos.',
++-	'PST_DYNAMIC'		=> 'Display dynamic similar topics',
++-	'PST_DYNAMIC_EXPLAIN'=> 'Show similar topics as users type in the topic title field when creating new topics.',
++ 	'PST_SENSE'			=> 'Sensibilidad de búsqueda',
++-	'PST_SENSE_EXPLAIN'	=> 'Establezca la sensibilidad de búsqueda en un valor entre 1 y 10. Use un número menor si no ve ningún tema similar. Ajustes recomendados: %d',
+++	'PST_SENSE_EXPLAIN'	=> 'Establezca la sensibilidad de búsqueda en un valor entre 1 y 10. Use un número menor si no ve ningún tema similar. Ajustes recomendados: Para la tabla “phpbb_topics” de la bases de datos usando InnoDB use 1; para MyISAM use 5.',
++ 	'PST_LEGEND3'		=> 'Configuración de foro',
++ 	'PST_NOSHOW_LIST'	=> 'No mostrar en',
++ 	'PST_NOSHOW_TITLE'	=> 'No mostrar hilos parecidos en',
++@@ -66,14 +63,14 @@ $lang = array_merge($lang, array(
++ 	'PST_STANDARD'		=> 'Estándar',
++ 	'PST_ADVANCED'		=> 'Avanzado',
++ 	'PST_ADVANCED_TITLE'=> 'Haz clic para habilitar la configuración avanzada de hilos parecidos para',
++-	'PST_ADVANCED_EXP'	=> 'Aquí puedes seleccionar foros específicos de donde extraer hilos parecidos. Sólo los hilos parecidos que se encuentren en los foros que selecciones aquí se mostrarán en <strong>%s</strong>.<br><br>No selecciones ningún foro si quieres que todos los foros que tengan habilitado la búsqueda en ellos sean mostrados en este foro.<br><br>Seleccione/Deseleccione multiples foros manteniendo pulsada la tecla <code>CTRL</code> y haciendo clic en los foros deseados.',
+++	'PST_ADVANCED_EXP'	=> 'Aquí puedes seleccionar foros específicos de donde extraer hilos parecidos. Sólo los hilos parecidos que se encuentren en los foros que selecciones aquí se mostrarán en <strong>%s</strong>.<br /><br />No selecciones ningún foro si quieres que todos los foros que tengan habilitado la búsqueda en ellos sean mostrados en este foro.<br /><br />Seleccione/Deseleccione multiples foros manteniendo pulsada la tecla <code>CTRL</code> y haciendo clic en los foros deseados.',
++ 	'PST_ADVANCED_FORUM'=> 'Configuración avanzada del foro',
++ 	'PST_DESELECT_ALL'	=> 'Deseleccionar todos',
++ 	'PST_LEGEND4'		=> 'Configuración opcional',
++ 	'PST_WORDS'			=> 'Palabras especiales para ignorar',
++ 	'PST_WORDS_EXPLAIN'	=> 'Añadir palabras especiales exclusivas de su foro en el que deben ser ignoradas en hilos parecidos. (Nota: Las palabras comunes en su lengua son ignorados por defecto.) Separe cada palabra con un espacio. Mayúsculas no minúsculas.',
++ 	'PST_SAVED'			=> 'La configuración de Hilos Parecidos ha sido actualizada',
++-	'PST_FORUM_INFO'	=> '“No Mostrar En”: Deshabilitará la visualización de hilos parecidos en el foro seleccionado.<br>“No Buscar En” : Ignorará los foros seleccionados cuando se estén buscando hilos parecidos.',
+++	'PST_FORUM_INFO'	=> '“No Mostrar En”: Deshabilitará la visualización de hilos parecidos en el foro seleccionado.<br />“No Buscar En” : Ignorará los foros seleccionados cuando se estén buscando hilos parecidos.',
++ 	'PST_NO_COMPAT'		=> 'Hilos Parecidos no va a funcionar en tu foro. Hilos Parecidos requiere una base de datos MySQL 4 o MySQL 5 o PostgreSQL.',
++ 	'PST_ERR_CONFIG'	=> 'Demasiados foros fueron marcados en la lista de foros. Inténtalo de nuevo con una selección más pequeña.',
++ ));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/fa/acp_similar_topics.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/language/fa/acp_similar_topics.php"
++index 1f11135f2..2e9704801 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/fa/acp_similar_topics.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/language/fa/acp_similar_topics.php"
++@@ -43,7 +43,6 @@ $lang = array_merge($lang, array(
++ 	'PST_EXPLAIN'		=> '"موضوعات مشابه" ابزاریست جهت نمایش ، موضوعات مشابه در قسمت پایین هر موضوع در انجمن ها',
++ 	'PST_LEGEND1'		=> 'تنظیمات کلی',
++ 	'PST_ENABLE'		=> 'نمایش موضوعات مشابه',
++-	'PST_ENABLE_EXPLAIN'=> 'Show similar topics in topic discussion threads.',
++ 	'PST_LEGEND2'		=> 'بارگزاری تنظیمات',
++ 	'PST_LIMIT'			=> 'تعداد موضوعات مشابه جهت نمایش',
++ 	'PST_LIMIT_EXPLAIN'	=> 'در این قسمت شما میتوانید تعیین کنید که چه تعداد موضوع نمایش داده شود. مقدار پیش فرض تعداد 5 است.',
++@@ -55,10 +54,8 @@ $lang = array_merge($lang, array(
++ 	'PST_DAYS'			=> 'روز',
++ 	'PST_CACHE'			=> 'زمان ذخیره سازی کش',
++ 	'PST_CACHE_EXPLAIN'	=> 'کش یا نهان این افزونه بعد از تعیین زمان توسط شما منسوخ خواهد شد ، برای غیر فعال سازی 0 را وارد کنید.',
++-	'PST_DYNAMIC'		=> 'Display dynamic similar topics',
++-	'PST_DYNAMIC_EXPLAIN'=> 'Show similar topics as users type in the topic title field when creating new topics.',
++-	'PST_SENSE'			=> 'حساسیت جستجو',
++-	'PST_SENSE_EXPLAIN'	=> 'حساسیت جستجو را روی مقداری بین 1 تا 10 تنظیم کنید. اگر موضوع مشابهی نمی بینید از عدد کمتری استفاده کنید. تنظیمات پیشنهادی: برای جداول پایگاه داده “phpbb_topics” با استفاده از InnoDB از 1 استفاده کنید. برای MyISAM از 5 استفاده کنید.',
+++	'PST_SENSE'			=> 'Search sensitivity',
+++	'PST_SENSE_EXPLAIN'	=> 'Set the search sensitivity to a value between 1 and 10. Use a lower number if you are not seeing any similar topics. Recommended settings: For “phpbb_topics” database tables using InnoDB use 1; for MyISAM use 5.',
++ 	'PST_LEGEND3'		=> 'تنظیمات انجمن',
++ 	'PST_NOSHOW_LIST'	=> 'در این بخش نمایش نده',
++ 	'PST_NOSHOW_TITLE'	=> 'موضوعات مشابه را در این انجمن نشان نده',
++@@ -67,14 +64,14 @@ $lang = array_merge($lang, array(
++ 	'PST_STANDARD'		=> 'استاندارد',
++ 	'PST_ADVANCED'		=> 'پیشرفته',
++ 	'PST_ADVANCED_TITLE'=> 'کلیک جهت انجام تنظیمات پیشرفته',
++-	'PST_ADVANCED_EXP'	=> 'در اینجا شما میتوانید انجمن هایی که دوست دارید موضوعات مشابه در آن دیده شوند انتخاب کنید. به یاد داشته باشید که فقط انجمن هایی که شما انتخاب کنید شامل این افزونه خواهد شد.<br>',
+++	'PST_ADVANCED_EXP'	=> 'در اینجا شما میتوانید انجمن هایی که دوست دارید موضوعات مشابه در آن دیده شوند انتخاب کنید. به یاد داشته باشید که فقط انجمن هاییی که شما انتخاب میکنید شامل این افزونه خواهد شد.<br />',
++ 	'PST_ADVANCED_FORUM'=> 'تنظیمات پیشرفته انجمن',
++ 	'PST_DESELECT_ALL'	=> 'انتخاب نکردن',
++ 	'PST_LEGEND4'		=> 'تنظیمات',
++ 	'PST_WORDS'			=> 'کلمات سانسور شده',
++-	'PST_WORDS_EXPLAIN'	=> 'کلمات سانسوری که قصد دارید هنگام جستجوی موضوعات مشابه نمایش داده نشوند را وارد کنید. هر کلمه را با space جدا کنید.',
++-	'PST_SAVED'			=> 'تنظیمات موضوعات مشابه بروز رسانی شد',
++-	'PST_FORUM_INFO'	=> 'انتخاب گزنیه"در این بخش نمایش نده" باعث می شود موضوعات مشابه در انجمن انتخابی نمایش داده نشود<br>انتخاب گزینه" جستجوی موضوعات را در این بخش انجام نده" باعث می شود ، جستجو در انجمن انتخابی برای موضوعات مشابه انجام نشود.',
+++	'PST_WORDS_EXPLAIN'	=> 'کلمات سانسوی که قصد دارید هنگام جستجوی موضوعات مشابه نمایش داده نشوند را وارد کنید. هر کلمه را با space میتوانید جدا کنید و.',
+++	'PST_SAVED'			=> 'تنظیمات موضوعات مشابه به روز رسانی شد',
+++	'PST_FORUM_INFO'	=> 'انتخاب گزنیه"در این بخش نمایش نده" باعث می شود موضوعات مشابه در انجمن های انتخابی نمایش داده نشود<br />انتخاب گزینه" جستجوی موضوعات را در این بخش انجام نده" باعث می شود ، جستجو در بخش های انتخابی برای تاپیک های مشابه انجام نشود.',
++ 	'PST_NO_COMPAT'		=> 'افزونه موضوعات مشابه با سیستم انجمن شما سازگار نیست. این سیستم تنها روی دیتابیس های PostgreSQL or MySQL 4 or MySQL 5 کار میکند',
++-	'PST_ERR_CONFIG'	=> 'تعداد انجمن های انتخاب شده بیش از حد می باشد لطفا دوباره با یک انتخاب کوچکتر امتحان کنید.',
+++	'PST_ERR_CONFIG'	=> 'بیش از حد بسیاری از انجمن ها در فهرست انجمن ها مشخص شد. لطفا دوباره با یک انتخاب کوچکتر امتحان کنید.',
++ ));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/fa/info_acp_similar_topics.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/language/fa/info_acp_similar_topics.php"
++index 14e3f407b..f5fe9b97c 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/fa/info_acp_similar_topics.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/language/fa/info_acp_similar_topics.php"
++@@ -40,6 +40,6 @@ if (empty($lang) || !is_array($lang))
++ 
++ $lang = array_merge($lang, array(
++ 	'PST_TITLE_ACP'		=> 'موضوعات مشابه',
++-	'PST_SETTINGS'		=> 'تنظیمات',
++-	'PST_LOG_MSG'		=> '<strong>تنظیمات افزونه "موضوعات مشابه" بروز رسانی شد</strong>',
+++	'PST_SETTINGS'		=> 'تنظیمات افزونه "موضوعات مشابه"',
+++	'PST_LOG_MSG'		=> '<strong>تنظیمات افزونه "موضوعات مشابه" به روز رسانی شد</strong>',
++ ));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/fa/search_ignore_words.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/fa/search_ignore_words.php"
++deleted file mode 100644
++index d8300612d..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/fa/search_ignore_words.php"
+++++ /dev/null
++@@ -1,63 +0,0 @@
++-<?php
++-/**
++- *
++- * Precise Similar Topics
++- *
++- * @copyright (c) 2025 Matt Friedman
++- * @license GNU General Public License, version 2 (GPL-2.0)
++- *
++- * This [fa] language list of stop words created by Matt Friedman for Similar Topics
++- *
++- */
++-
++-if (!defined('IN_PHPBB'))
++-{
++-   exit;
++-}
++-
++-$words = array(
++-	'آن',
++-	'آنها',
++-	'اگر',
++-	'از',
++-	'است',
++-	'این',
++-	'اینها',
++-	'با',
++-	'باشد',
++-	'بر',
++-	'برای',
++-	'بعد',
++-	'بود',
++-	'بوده',
++-	'بزرگ',
++-	'تا',
++-	'تمام',
++-	'جدید',
++-	'خوب',
++-	'در',
++-	'روز',
++-	'روزها',
++-	'زمان',
++-	'شد',
++-	'شده',
++-	'شود',
++-	'کار',
++-	'که',
++-	'کرد',
++-	'کرده',
++-	'کند',
++-	'کوچک',
++-	'گفت',
++-	'ما',
++-	'من',
++-	'نیز',
++-	'هم',
++-	'همه',
++-	'هیچ',
++-	'و',
++-	'وقت',
++-	'ولی',
++-	'یا',
++-	'یک',
++-);
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/fr/acp_similar_topics.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/language/fr/acp_similar_topics.php"
++index 4f2b4048e..7da330f61 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/fr/acp_similar_topics.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/language/fr/acp_similar_topics.php"
++@@ -43,7 +43,6 @@ $lang = array_merge($lang, array(
++ 	'PST_EXPLAIN'		=> 'Affiche une liste des sujets similaires au bas de la page du sujet visionné.',
++ 	'PST_LEGEND1'		=> 'Paramètre général',
++ 	'PST_ENABLE'		=> 'Afficher les sujets similaires',
++-	'PST_ENABLE_EXPLAIN'=> 'Show similar topics in topic discussion threads.',
++ 	'PST_LEGEND2'		=> 'Paramètres principaux',
++ 	'PST_LIMIT'			=> 'Nombre du ou des sujets similaires à afficher',
++ 	'PST_LIMIT_EXPLAIN'	=> 'Ici vous pouvez sélectionner le ou les nombres de sujets similaires à afficher. La valeur par défaut est de 5 sujets.',
++@@ -55,10 +54,8 @@ $lang = array_merge($lang, array(
++ 	'PST_DAYS'			=> 'Jour(s)',
++ 	'PST_CACHE'			=> 'Taille du cache des sujets similaires',
++ 	'PST_CACHE_EXPLAIN'	=> 'La mise en cache des sujets similaires expirera après cette période. Paramétrez sur 0 pour désactiver la mise en cache des sujets similaires.',
++-	'PST_DYNAMIC'		=> 'Display dynamic similar topics',
++-	'PST_DYNAMIC_EXPLAIN'=> 'Show similar topics as users type in the topic title field when creating new topics.',
++ 	'PST_SENSE'			=> 'Sensibilité de la recherche',
++-	'PST_SENSE_EXPLAIN'	=> 'Permet de saisir une valeur comprise entre 1 et 10 concernant le degré de sensibilité de la recherche. Utiliser une valeur plus basse si aucun sujet similaire n’est affiché. Paramètres recommandées : %d',
+++	'PST_SENSE_EXPLAIN'	=> 'Permet de saisir une valeur comprise entre 1 et 10 concernant le degré de sensibilité de la recherche. Utiliser une valeur plus basse si aucun sujet similaire n’est affiché. Paramètres recommandées : Pour les tables « phpbb_topics » utilisant InnoDB saisir 1 ; pour MyISAM saisir 5.',
++ 	'PST_LEGEND3'		=> 'Paramètres des forums',
++ 	'PST_NOSHOW_LIST'	=> 'Ne pas afficher dans',
++ 	'PST_NOSHOW_TITLE'	=> 'Ne pas afficher les sujets similaires dans le forum :',
++@@ -67,14 +64,14 @@ $lang = array_merge($lang, array(
++ 	'PST_STANDARD'		=> 'Standard',
++ 	'PST_ADVANCED'		=> 'Avancé',
++ 	'PST_ADVANCED_TITLE'=> 'Cliquez ici pour configurer les paramètres avancés du forum :',
++-	'PST_ADVANCED_EXP'	=> 'Ici vous pouvez sélectionner des forums spécifiques dont les sujets similaires proviendront. Seuls les sujets similaires trouvés dans les forums sélectionnés ici seront affichés dans le forum : <strong>%s</strong>.<br><br>Ne sélectionnez aucun forum si vous souhaitez que tous les sujets similaires de tous les forums soient consultables dans ce forum.<br><br>Vous pouvez sélectionner ou désélectionner plusieurs forums en maintenant appuyée la touche <samp>CTRL</samp> (ou <samp>&#8984;CMD</samp> sur Mac) du clavier de votre ordinateur et en cliquant.',
+++	'PST_ADVANCED_EXP'	=> 'Ici vous pouvez sélectionner des forums spécifiques dont les sujets similaires proviendront. Seuls les sujets similaires trouvés dans les forums sélectionnés ici seront affichés dans le forum : <strong>%s</strong>.<br /><br />Ne sélectionnez aucun forum si vous souhaitez que tous les sujets similaires de tous les forums soient consultables dans ce forum.<br /><br />Vous pouvez sélectionner ou désélectionner plusieurs forums en maintenant appuyée la touche <samp>CTRL</samp> (ou <samp>&#8984;CMD</samp> sur Mac) du clavier de votre ordinateur et en cliquant.',
++ 	'PST_ADVANCED_FORUM'=> 'Paramètres avancés du forum',
++ 	'PST_DESELECT_ALL'	=> 'Tout désélectionner',
++ 	'PST_LEGEND4'		=> 'Paramètres optionnels',
++ 	'PST_WORDS'			=> 'Mots spécifiques à ignorer',
++ 	'PST_WORDS_EXPLAIN'	=> 'Ajoutez des mots spécifiques à votre forum qui doivent être ignorés lors de la recherche des sujets similaires. (Remarque : Les mots qui sont actuellement considérés comme communs dans votre langue sont déjà ignorés par défaut.) Séparez chaque mot par un espace. Insensible à la casse.',
++ 	'PST_SAVED'			=> 'Les paramètres des sujets similaires ont été mis à jour',
++-	'PST_FORUM_INFO'	=> '« Ne pas afficher dans » : N’affiche pas de sujets similaires dans les forums sélectionnés.<br> « Ne pas rechercher dans » : Ne recherche pas de sujets similaires dans les forums sélectionnés.<br><br>',
+++	'PST_FORUM_INFO'	=> '« Ne pas afficher dans » : N’affiche pas de sujets similaires dans les forums sélectionnés.<br /> « Ne pas rechercher dans » : Ne recherche pas de sujets similaires dans les forums sélectionnés.<br /><br />',
++ 	'PST_NO_COMPAT'		=> 'L’extension « Sujets similaires précis » n’est pas compatible avec votre forum. Cette extension fonctionne uniquement avec une base de données MySQL 4 ou 5 ou PostgreSQL.',
++ 	'PST_ERR_CONFIG'	=> 'De trop nombreux forums ont été sélectionnés dans la liste des forums. Veuillez réessayer avec une sélection plus restreinte.',
++ ));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/he/acp_similar_topics.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/language/he/acp_similar_topics.php"
++index bdce3ef66..0599ac9d3 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/he/acp_similar_topics.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/language/he/acp_similar_topics.php"
++@@ -42,7 +42,6 @@ $lang = array_merge($lang, array(
++ 	'PST_EXPLAIN'		=> 'נושאים דומים במדויק מציג רשימת נושאים דומים (קשורים) בחלק התחתון של דף הנושא הנוכחי.',
++ 	'PST_LEGEND1'		=> 'הגדרות כלליות',
++ 	'PST_ENABLE'		=> 'הצג נושאים דומים',
++-	'PST_ENABLE_EXPLAIN'=> 'Show similar topics in topic discussion threads.',
++ 	'PST_LEGEND2'		=> 'טען הגדרות',
++ 	'PST_LIMIT'			=> 'מספר נושאים דומים להצגה',
++ 	'PST_LIMIT_EXPLAIN'	=> 'כאן באפשרותך להגדיר כמה נושאים דומים להציג. ברירת המחדל היא 5 נושאים.',
++@@ -54,10 +53,8 @@ $lang = array_merge($lang, array(
++ 	'PST_DAYS'			=> 'ימים',
++ 	'PST_CACHE'			=> 'אורך מטמון נושאים דומים',
++ 	'PST_CACHE_EXPLAIN'	=> 'מטמון נושאים דומים יפוג לאחר זמן, ערך בשניות. קבע 0 אם אתה רוצה לבטל את מטמון נושאים דומים.',
++-	'PST_DYNAMIC'		=> 'Display dynamic similar topics',
++-	'PST_DYNAMIC_EXPLAIN'=> 'Show similar topics as users type in the topic title field when creating new topics.',
++ 	'PST_SENSE'			=> 'רגישות חיפוש',
++-	'PST_SENSE_EXPLAIN'	=> 'הגדר את רגישות החיפוש לערך בין 1 ל -10. השתמש במספר נמוך יותר אם אינך רואה נושאים דומים. הגדרות מומלצות: <samp>%d</samp>',
+++	'PST_SENSE_EXPLAIN'	=> 'הגדר את רגישות החיפוש לערך בין 1 ל -10. השתמש במספר נמוך יותר אם אינך רואה נושאים דומים. הגדרות מומלצות: עבור טבלאות מסד נתונים “phpbb_topics” הפועלים ב- InnoDB השתמש ב- 1; עבור  MyISAM השתמש ב- 5.',
++ 	'PST_LEGEND3'		=> 'הגדרות פורום',
++ 	'PST_NOSHOW_LIST'	=> 'לא להציג ב',
++ 	'PST_NOSHOW_TITLE'	=> 'לא להציג נושאים דומים ב',
++@@ -66,14 +63,14 @@ $lang = array_merge($lang, array(
++ 	'PST_STANDARD'		=> 'תקן',
++ 	'PST_ADVANCED'		=> 'מתקדם',
++ 	'PST_ADVANCED_TITLE'=> 'לחץ כדי להגדיר הגדרות מתקדמות לנושא דומה עבור',
++-	'PST_ADVANCED_EXP'	=> 'כאן ניתן לבחור פורומים ספציפיים כדי למשוך נושאים דומים מ. רק נושאים דומים שנמצאו בפורומים שתבחר כאן יוצגו ב- <strong>%s</strong>. אל תבחר בכל הפורומים, אם אתה רוצה שנושאים דומים מחיפוש בכל הפורומים יוצג בפורום זה.<br><br>בחר במספר פורומים על ידי החזקת מקש <samp>CTRL</samp> (או <samp>&#8984;CMD</samp> ב- MAC) ולחיצה.',
+++	'PST_ADVANCED_EXP'	=> 'כאן ניתן לבחור פורומים ספציפיים כדי למשוך נושאים דומים מ. רק נושאים דומים שנמצאו בפורומים שתבחר כאן יוצגו ב- <strong>%s</strong>. אל תבחר בכל הפורומים, אם אתה רוצה שנושאים דומים מחיפוש בכל הפורומים יוצג בפורום זה.<br /><br />בחר במספר פורומים על ידי החזקת מקש <samp>CTRL</samp> (או <samp>&#8984;CMD</samp> ב- MAC) ולחיצה.',
++ 	'PST_ADVANCED_FORUM'=> 'הגדרות פורום מתקדמות',
++ 	'PST_DESELECT_ALL'	=> 'הסר סימון מהכל',
++ 	'PST_LEGEND4'		=> 'הגדרות אופציונליות',
++ 	'PST_WORDS'			=> 'להתעלם ממילים מיוחדות',
++ 	'PST_WORDS_EXPLAIN'	=> 'הוסף מילים מיוחדות וייחודיות בפורום שלך שיש להתעלם מהן בעת מציאת נושאים דומים. (הערה: כברירת מחדל, הוא כבר מתעלם ממילים שנחשבות נפוצות בשפה שלך.) הפרד כל מילה עם רווח. לא תלוי רישיות.',
++ 	'PST_SAVED'			=> 'הגדרות נושאים דומים עודכנו',
++-	'PST_FORUM_INFO'	=> '"לא להציג ב": לא יוצגו נושאים דומים בפורומים שנבחרו.<br>"לא לחפש בתוך": לא יחפש נושאים דומים בפורומים שנבחרו.',
+++	'PST_FORUM_INFO'	=> '"לא להציג ב": לא יוצגו נושאים דומים בפורומים שנבחרו.<br />"לא לחפש בתוך": לא יחפש נושאים דומים בפורומים שנבחרו.',
++ 	'PST_NO_COMPAT'		=> 'נושאים דומים אינו תואם את הפורום שלך. נושאים דומים יפעל רק על מסד נתונים MySQL או PostgreSQL.',
++ 	'PST_ERR_CONFIG'	=> 'יותר מדי פורומים סומנו ברשימת הפורומים. נסה שוב עם בחירה קטנה יותר.',
++ ));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/he/search_ignore_words.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/he/search_ignore_words.php"
++deleted file mode 100644
++index 77cee721e..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/he/search_ignore_words.php"
+++++ /dev/null
++@@ -1,73 +0,0 @@
++-<?php
++-/**
++- *
++- * Precise Similar Topics
++- *
++- * @copyright (c) 2025 Matt Friedman
++- * @license GNU General Public License, version 2 (GPL-2.0)
++- *
++- * This [he] language list of stop words created by Matt Friedman for Similar Topics
++- *
++- */
++-
++-if (!defined('IN_PHPBB'))
++-{
++-   exit;
++-}
++-
++-$words = array(
++-	'אבל',
++-	'אחד',
++-	'אחר',
++-	'אחרי',
++-	'איך',
++-	'אין',
++-	'אל',
++-	'אם',
++-	'אני',
++-	'אף',
++-	'את',
++-	'אתה',
++-	'אתם',
++-	'בין',
++-	'גדול',
++-	'גם',
++-	'דבר',
++-	'היא',
++-	'היה',
++-	'הם',
++-	'הן',
++-	'הוא',
++-	'זה',
++-	'זו',
++-	'חדש',
++-	'טוב',
++-	'יום',
++-	'ימים',
++-	'יש',
++-	'כאן',
++-	'כבר',
++-	'כי',
++-	'כל',
++-	'כמו',
++-	'כן',
++-	'לא',
++-	'לו',
++-	'לי',
++-	'למה',
++-	'מה',
++-	'מי',
++-	'מן',
++-	'נגד',
++-	'עד',
++-	'על',
++-	'עם',
++-	'פה',
++-	'קטן',
++-	'רב',
++-	'רק',
++-	'שוב',
++-	'של',
++-	'שם',
++-	'תמיד',
++-);
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/hr/acp_similar_topics.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/language/hr/acp_similar_topics.php"
++index e80cc6ee6..0d83bd292 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/hr/acp_similar_topics.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/language/hr/acp_similar_topics.php"
++@@ -43,22 +43,19 @@ $lang = array_merge($lang, array(
++ 	'PST_EXPLAIN'		=> 'Ovdje možeš o[ne]mogućiti prikaz liste sličnih [povezanih] tema na dnu stranice trenutne teme.',
++ 	'PST_LEGEND1'		=> 'Opće postavke',
++ 	'PST_ENABLE'		=> 'Prikaži Slične teme',
++-	'PST_ENABLE_EXPLAIN'=> 'Show similar topics in topic discussion threads.',
++ 	'PST_LEGEND2'		=> 'Osnovne postavke',
++ 	'PST_LIMIT'			=> 'Broj sličnih tema za prikaz',
++ 	'PST_LIMIT_EXPLAIN'	=> 'Određivanje prikaza broja sličnih tema [zadano=5].',
++ 	'PST_TIME'			=> 'Razdoblje pretraživanja',
++-	'PST_TIME_EXPLAIN'	=> 'Određivanje razdoblje pretraživanja broja sličnih tema [zadano=godina].<br>Npr. ukoliko je vrijednost postavljena na 5, sistem će prikaz(iv)ati slične teme unazad 5 dana.',
+++	'PST_TIME_EXPLAIN'	=> 'Određivanje razdoblje pretraživanja broja sličnih tema [zadano=godina].<br />Npr. ukoliko je vrijednost postavljena na 5, sistem će prikaz(iv)ati slične teme unazad 5 dana.',
++ 	'PST_YEARS'			=> 'Godina/e',
++ 	'PST_MONTHS'		=> 'Mjesec/a/i',
++ 	'PST_WEEKS'			=> 'Tjedan/na/a',
++ 	'PST_DAYS'			=> 'Dan/a',
++ 	'PST_CACHE'			=> 'Trajanje sličnih tema pohranjenih u priručnu memoriju',
++ 	'PST_CACHE_EXPLAIN'	=> 'Slične teme, pohranjene u priručnu memoriju, bit će izbrisane, iz priručne memorije, po isteku [u sekundama] postavljenog vremena [0=onemogućeno].',
++-	'PST_DYNAMIC'		=> 'Display dynamic similar topics',
++-	'PST_DYNAMIC_EXPLAIN'=> 'Show similar topics as users type in the topic title field when creating new topics.',
++ 	'PST_SENSE'			=> 'Search sensitivity',
++-	'PST_SENSE_EXPLAIN'	=> 'For MySQL or Postgres databases, you can set the search sensitivity to a value between 1 and 10. Use a lower number if you are not seeing any similar topics. Recommended setting: %d',
+++	'PST_SENSE_EXPLAIN'	=> 'Set the search sensitivity to a value between 1 and 10. Use a lower number if you are not seeing any similar topics. Recommended settings: For “phpbb_topics” database tables using InnoDB use 1; for MyISAM use 5.',
++ 	'PST_LEGEND3'		=> 'Postavke foruma',
++ 	'PST_NOSHOW_LIST'	=> 'Ne prikazuj u',
++ 	'PST_NOSHOW_TITLE'	=> 'Ne prikazuj slične teme u',
++@@ -67,14 +64,14 @@ $lang = array_merge($lang, array(
++ 	'PST_STANDARD'		=> 'Standardno',
++ 	'PST_ADVANCED'		=> 'Napredno',
++ 	'PST_ADVANCED_TITLE'=> 'Klikni za podešavanje naprednih postavki sličnih tema u/za',
++-	'PST_ADVANCED_EXP'	=> 'Ukoliko želiš da slične teme, iz određenih pretražljivih foruma, budu prikazane na <strong>%s</strong>, označi [odaberi] željene forume.<br><br>Ukoliko želiš da slične teme, iz svih pretražljivih foruma, budu prikazane na forumu, nemoj označiti [odabrati] niti jedan forum.<br><br>Forume možeš (od)označavati korištenjem [pritisnute tipke] <code>CTRL</code> i kliktanjem [mišem].',
+++	'PST_ADVANCED_EXP'	=> 'Ukoliko želiš da slične teme, iz određenih pretražljivih foruma, budu prikazane na <strong>%s</strong>, označi [odaberi] željene forume.<br /><br />Ukoliko želiš da slične teme, iz svih pretražljivih foruma, budu prikazane na forumu, nemoj označiti [odabrati] niti jedan forum.<br /><br />Forume možeš (od)označavati korištenjem [pritisnute tipke] <code>CTRL</code> i kliktanjem [mišem].',
++ 	'PST_ADVANCED_FORUM'=> 'Napredne postavke foruma',
++ 	'PST_DESELECT_ALL'	=> 'Odoznači sve',
++ 	'PST_LEGEND4'		=> 'Opcionalne postavke',
++ 	'PST_WORDS'			=> 'Ignorirane riječi',
++-	'PST_WORDS_EXPLAIN'	=> 'Popis riječi koje će biti ignorirane prilikom pronalaženja sličnih tema [zadano su ignorirane riječi koje su navedene ako učestale].<br>Riječi odvoji razmacima. Neosjetljivo na velika/mala slova.',
+++	'PST_WORDS_EXPLAIN'	=> 'Popis riječi koje će biti ignorirane prilikom pronalaženja sličnih tema [zadano su ignorirane riječi koje su navedene ako učestale].<br />Riječi odvoji razmacima. Neosjetljivo na velika/mala slova.',
++ 	'PST_SAVED'			=> 'Postavke sličnih tema su ažurirane.',
++-	'PST_FORUM_INFO'	=> '“Ne prikazuj u”: neće prikaz(iv)ati slične teme u odabranim forumima.<br>“Ne pretražuj u”: neće pretraž(iv)ati slične teme u odabranim forumima.',
++-	'PST_NO_COMPAT'		=> 'Slične teme nisu kompatibilne s forumom.<br>Pokreću se samo na/u MySQL 4 ili MySQL 5 ili PostgreSQL bazi podataka.',
+++	'PST_FORUM_INFO'	=> '“Ne prikazuj u”: neće prikaz(iv)ati slične teme u odabranim forumima.<br />“Ne pretražuj u”: neće pretraž(iv)ati slične teme u odabranim forumima.',
+++	'PST_NO_COMPAT'		=> 'Slične teme nisu kompatibilne s forumom.<br />Pokreću se samo na/u MySQL 4 ili MySQL 5 ili PostgreSQL bazi podataka.',
++ 	'PST_ERR_CONFIG'	=> 'Previše forumi su označeni na popisu foruma. Pokušajte ponovno s manjim izborom.',
++ ));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/it/acp_similar_topics.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/language/it/acp_similar_topics.php"
++index 280a11feb..7a12e83b1 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/it/acp_similar_topics.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/language/it/acp_similar_topics.php"
++@@ -42,7 +42,6 @@ $lang = array_merge($lang, array(
++ 	'PST_EXPLAIN'		=> '“Argomenti simili” mostra un elenco di argomenti simili in fondo alla pagina dell’argomento corrente.',
++ 	'PST_LEGEND1'		=> 'Impostazioni generali',
++ 	'PST_ENABLE'		=> 'Mostra argomenti simili',
++-	'PST_ENABLE_EXPLAIN'=> 'Show similar topics in topic discussion threads.',
++ 	'PST_LEGEND2'		=> 'Impostazioni caricamento',
++ 	'PST_LIMIT'			=> 'Numero argomenti simili da mostrare',
++ 	'PST_LIMIT_EXPLAIN'	=> 'È possibile definire quanti topic simili mostrare; il valore predefinito è 5.',
++@@ -54,10 +53,8 @@ $lang = array_merge($lang, array(
++ 	'PST_DAYS'			=> 'Giorni',
++ 	'PST_CACHE'			=> 'Lunghezza cache',
++ 	'PST_CACHE_EXPLAIN'	=> 'Gli argomenti salvati nella cache saranno rimossi dopo il periodo di tempo (in secondi) specificato. Impostare a 0 per disabilitare la cache di argomenti simili.',
++-	'PST_DYNAMIC'		=> 'Display dynamic similar topics',
++-	'PST_DYNAMIC_EXPLAIN'=> 'Show similar topics as users type in the topic title field when creating new topics.',
++ 	'PST_SENSE'			=> 'Search sensitivity',
++-	'PST_SENSE_EXPLAIN'	=> 'For MySQL or Postgres databases, you can set the search sensitivity to a value between 1 and 10. Use a lower number if you are not seeing any similar topics. Recommended setting: %d',
+++	'PST_SENSE_EXPLAIN'	=> 'Set the search sensitivity to a value between 1 and 10. Use a lower number if you are not seeing any similar topics. Recommended settings: For “phpbb_topics” database tables using InnoDB use 1; for MyISAM use 5.',
++ 	'PST_LEGEND3'		=> 'Impostazioni forum',
++ 	'PST_NOSHOW_LIST'	=> 'Non mostrare in',
++ 	'PST_NOSHOW_TITLE'	=> 'Non mostrare argomenti simili in',
++@@ -66,14 +63,14 @@ $lang = array_merge($lang, array(
++ 	'PST_STANDARD'		=> 'Base',
++ 	'PST_ADVANCED'		=> 'Avanzate',
++ 	'PST_ADVANCED_TITLE'=> 'Cliccare per configurare le impostazioni avanzate per',
++-	'PST_ADVANCED_EXP'	=> 'È possibile selezionare i forum in cui cercare argomenti simili. Solo gli argomenti trovati nei forum selezionati saranno mostrati in <strong>%s</strong>.<br><br>Per la ricerca in tutti i forum disponibili, non selezionare alcun forum.<br><br>Per la selezione di più forum, tenere premuto <samp>CTRL</samp> (o <samp>&#8984;CMD</samp> su Mac) e cliccare.',
+++	'PST_ADVANCED_EXP'	=> 'È possibile selezionare i forum in cui cercare argomenti simili. Solo gli argomenti trovati nei forum selezionati saranno mostrati in <strong>%s</strong>.<br /><br />Per la ricerca in tutti i forum disponibili, non selezionare alcun forum.<br /><br />Per la selezione di più forum, tenere premuto <samp>CTRL</samp> (o <samp>&#8984;CMD</samp> su Mac) e cliccare.',
++ 	'PST_ADVANCED_FORUM'=> 'Impostazioni avanzate forum',
++ 	'PST_DESELECT_ALL'	=> 'Deseleziona tutti',
++ 	'PST_LEGEND4'		=> 'Impostazioni opzionali',
++ 	'PST_WORDS'			=> 'Termini speciali da ignorare',
++-	'PST_WORDS_EXPLAIN'	=> 'È possibile escludere alcuni termini dalla ricerca di argomenti simili. I termini devono essere separati da uno spazio; non è fatta distinzione tra maiuscole e minuscole.<br><br>Nota: <em>i termini considerati comuni della propria lingua sono ignorati per impostazione predefinita.</em>',
+++	'PST_WORDS_EXPLAIN'	=> 'È possibile escludere alcuni termini dalla ricerca di argomenti simili. I termini devono essere separati da uno spazio; non è fatta distinzione tra maiuscole e minuscole.<br /><br />Nota: <em>i termini considerati comuni della propria lingua sono ignorati per impostazione predefinita.</em>',
++ 	'PST_SAVED'			=> 'Impostazioni Argomenti simili aggiornate',
++-	'PST_FORUM_INFO'	=> '“Non mostrare in”: nei forum selezionati, non saranno mostrati gli argomenti simili.<br>“Non cercare in”: nei forum selezionati, non saranno cercati gli argomenti simili.',
+++	'PST_FORUM_INFO'	=> '“Non mostrare in”: nei forum selezionati, non saranno mostrati gli argomenti simili.<br />“Non cercare in”: nei forum selezionati, non saranno cercati gli argomenti simili.',
++ 	'PST_NO_COMPAT'		=> '“Argomenti simili” non è compatibile con la propria board: quest’estensione richiede un database MySQL versione 4 o 5 o PostgreSQL.',
++ 	'PST_ERR_CONFIG'	=> 'Troppi forum selezionati in elenco, ridurre la selezione.',
++ ));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/ja/acp_similar_topics.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/language/ja/acp_similar_topics.php"
++index 3cb2c6361..00baf0192 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/ja/acp_similar_topics.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/language/ja/acp_similar_topics.php"
++@@ -42,7 +42,6 @@ $lang = array_merge($lang, array(
++ 	'PST_EXPLAIN'		=> 'Precise Similar Topics（正確な類似トピック）は現在のトピックのページ下部に類似(関連)したトピックの一覧を表示します。',
++ 	'PST_LEGEND1'		=> '一般設定',
++ 	'PST_ENABLE'		=> '類似トピックの表示',
++-	'PST_ENABLE_EXPLAIN'=> 'Show similar topics in topic discussion threads.',
++ 	'PST_LEGEND2'		=> '読み込み設定',
++ 	'PST_LIMIT'			=> '表示する類似トピック数',
++ 	'PST_LIMIT_EXPLAIN'	=> '類似トピックの表示数を定義できます。デフォルトは5トピックです。',
++@@ -54,10 +53,8 @@ $lang = array_merge($lang, array(
++ 	'PST_DAYS'			=> '日間',
++ 	'PST_CACHE'			=> '類似トピックのキャッシュの長さ',
++ 	'PST_CACHE_EXPLAIN'	=> 'キャッシュされた類似トピックはこの時間の後に期限がきれます。類似トピックのキャッシュを無効にしたい場合、0を設定します。',
++-	'PST_DYNAMIC'		=> 'Display dynamic similar topics',
++-	'PST_DYNAMIC_EXPLAIN'=> 'Show similar topics as users type in the topic title field when creating new topics.',
++ 	'PST_SENSE'			=> '検索感度',
++-	'PST_SENSE_EXPLAIN'	=> '検索感度を 1 から 10 の間で設定します。類似トピックが一つも表示されない場合は低い値を使用してください。推奨設定: %d',
+++	'PST_SENSE_EXPLAIN'	=> '検索感度を 1 から 10 の間で設定します。類似トピックが一つも表示されない場合は低い値を使用してください。推奨設定: “phpbb_topics” DBテーブルが InnoDB を使用していれば 1 を、MyISAMを使用していれば 5 を設定してください。',
++ 	'PST_LEGEND3'		=> 'フォーラム設定',
++ 	'PST_NOSHOW_LIST'	=> '表示しない',
++ 	'PST_NOSHOW_TITLE'	=> '類似トピックを表示しません',
++@@ -66,14 +63,14 @@ $lang = array_merge($lang, array(
++ 	'PST_STANDARD'		=> '標準',
++ 	'PST_ADVANCED'		=> 'カスタム',
++ 	'PST_ADVANCED_TITLE'=> '次の類似トピックのカスタム設定をするにはクリック:',
++-	'PST_ADVANCED_EXP'	=> 'ここでは類似トピックを取ってくる特定のフォーラムを選択できます。ここで選択したフォーラムで見つかった類似トピックのみ<strong>%s</strong>に表示されます。<br><br>全ての検索可能なフォーラムから類似トピックをこのフォーラムに表示したい場合、どのフォーラムも選択しないでください。<br><br><samp>CTRL</samp> (または MACでは<samp>&#8984;CMD</samp>)を押しながらクリックすることで複数のフォーラムを選択します。',
+++	'PST_ADVANCED_EXP'	=> 'ここでは類似トピックを取ってくる特定のフォーラムを選択できます。ここで選択したフォーラムで見つかった類似トピックのみ<strong>%s</strong>に表示されます。<br /><br />全ての検索可能なフォーラムから類似トピックをこのフォーラムに表示したい場合、どのフォーラムも選択しないでください。<br /><br /><samp>CTRL</samp> (または MACでは<samp>&#8984;CMD</samp>)を押しながらクリックすることで複数のフォーラムを選択します。',
++ 	'PST_ADVANCED_FORUM'=> 'カスタムフォーラム設定',
++ 	'PST_DESELECT_ALL'	=> '全ての選択を解除',
++ 	'PST_LEGEND4'		=> 'オプション設定',
++ 	'PST_WORDS'			=> '無視する単語',
++ 	'PST_WORDS_EXPLAIN'	=> '類似トピックを検索する際に無視すべき固有の単語を追加します（注: 現在の言語で共通とみなされている単語は、すでにデフォルトでは無視されます) 。スペースで各単語を区切ります。大文字小文字は区別しません。',
++ 	'PST_SAVED'			=> '類似トピック設定を更新しました',
++-	'PST_FORUM_INFO'	=> '“表示しない”: 選択したフォーラムで類似トピックを表示しません。<br>“検索しない” : 選択したフォーラムで類似トピックを検索しません。',
+++	'PST_FORUM_INFO'	=> '“表示しない”: 選択したフォーラムで類似トピックを表示しません。<br />“検索しない” : 選択したフォーラムで類似トピックを検索しません。',
++ 	'PST_NO_COMPAT'		=> '類似トピックはあなたのフォーラムと互換性がありません。類似トピックはMySQL4/5/PostgreSQLのデータベースでのみ実行できます。',
++ 	'PST_ERR_CONFIG'	=> 'あまりにも多くのフォーラムが、フォーラムのリストにマークされています。少ない選択数で再度お試しください。',
++ ));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/ja/search_ignore_words.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/ja/search_ignore_words.php"
++deleted file mode 100644
++index 26caeee97..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/ja/search_ignore_words.php"
+++++ /dev/null
++@@ -1,49 +0,0 @@
++-<?php
++-/**
++- *
++- * Precise Similar Topics
++- *
++- * @copyright (c) 2025 Matt Friedman
++- * @license GNU General Public License, version 2 (GPL-2.0)
++- *
++- * This [ja] language list of stop words created by Matt Friedman for Similar Topics
++- *
++- */
++-
++-if (!defined('IN_PHPBB'))
++-{
++-   exit;
++-}
++-
++-$words = array(
++-	'あの',
++-	'ある',
++-	'いる',
++-	'から',
++-	'この',
++-	'その',
++-	'それ',
++-	'だけ',
++-	'です',
++-	'では',
++-	'でも',
++-	'という',
++-	'として',
++-	'なる',
++-	'には',
++-	'また',
++-	'まで',
++-	'もう',
++-	'もの',
++-	'より',
++-	'れる',
++-	'われ',
++-	'を',
++-	'が',
++-	'で',
++-	'と',
++-	'に',
++-	'は',
++-	'も',
++-	'や',
++-);
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/nl/acp_similar_topics.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/language/nl/acp_similar_topics.php"
++index 6591b84d2..7fc7ecdea 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/nl/acp_similar_topics.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/language/nl/acp_similar_topics.php"
++@@ -42,7 +42,6 @@ $lang = array_merge($lang, array(
++ 	'PST_EXPLAIN'		=> 'Precise Similar Topics toont een lijst van soortgelijke onderwerpen aan de onderkant van de pagina van het huidige onderwerpen.',
++ 	'PST_LEGEND1'		=> 'Algemene instellingen',
++ 	'PST_ENABLE'		=> 'Vergelijkbare onderwerpen inschakelen',
++-	'PST_ENABLE_EXPLAIN'=> 'Show similar topics in topic discussion threads.',
++ 	'PST_LEGEND2'		=> 'Laad instellingen',
++ 	'PST_LIMIT'			=> 'Aantal vergelijkbare onderwerpen weer te geven',
++ 	'PST_LIMIT_EXPLAIN'	=> 'Hier kunt u opgeven hoeveel soortgelijke onderwerpen weer te laten geven. Standaard is dit 5 onderwerpen.',
++@@ -54,10 +53,8 @@ $lang = array_merge($lang, array(
++ 	'PST_DAYS'			=> 'Dagen',
++ 	'PST_CACHE'			=> 'Cache lengte vergelijkbare onderwerpen',
++ 	'PST_CACHE_EXPLAIN'	=> 'Cache vergelijkbare onderwerpen verloopt na deze tijd in seconden. Stel in op 0 als u dit wilt uitschakelen.',
++-	'PST_DYNAMIC'		=> 'Display dynamic similar topics',
++-	'PST_DYNAMIC_EXPLAIN'=> 'Show similar topics as users type in the topic title field when creating new topics.',
++ 	'PST_SENSE'			=> 'Search sensitivity',
++-	'PST_SENSE_EXPLAIN'	=> 'For MySQL or Postgres databases, you can set the search sensitivity to a value between 1 and 10. Use a lower number if you are not seeing any similar topics. Recommended setting: %d',
+++	'PST_SENSE_EXPLAIN'	=> 'Set the search sensitivity to a value between 1 and 10. Use a lower number if you are not seeing any similar topics. Recommended settings: For “phpbb_topics” database tables using InnoDB use 1; for MyISAM use 5.',
++ 	'PST_LEGEND3'		=> 'Forum instellingen',
++ 	'PST_NOSHOW_LIST'	=> 'Niet weergeven in',
++ 	'PST_NOSHOW_TITLE'	=> 'Vergelijkbare Onderwerpen Niet weergeven in',
++@@ -66,14 +63,14 @@ $lang = array_merge($lang, array(
++ 	'PST_STANDARD'		=> 'Standaard',
++ 	'PST_ADVANCED'		=> 'Geavanceerd',
++ 	'PST_ADVANCED_TITLE'=> 'Klik om Geavanceerde vergelijkbare onderwerpen in te stellen voor',
++-	'PST_ADVANCED_EXP'	=> 'Hier kunt u specifieke forums selecteren om de soortgelijke onderwerpen uit te halen. Alleen vergelijkbare onderwerpen gevonden in de forums die u hier selecteert worden weergegeven in <strong>%s</strong>.<br><br>Selecteer helemaal geen forum als u wilt dat vergelijkbare onderwerpen uit alle doorzoekbare forums worden weergegeven in dit forum.<br><br>Selecteer/Deselecteer meerdere forums door <code>CTRL</code> ingedrukt te houden en forums aan te klikken.',
+++	'PST_ADVANCED_EXP'	=> 'Hier kunt u specifieke forums selecteren om de soortgelijke onderwerpen uit te halen. Alleen vergelijkbare onderwerpen gevonden in de forums die u hier selecteert worden weergegeven in <strong>%s</strong>.<br /><br />Selecteer helemaal geen forum als u wilt dat vergelijkbare onderwerpen uit alle doorzoekbare forums worden weergegeven in dit forum.<br /><br />Selecteer/Deselecteer meerdere forums door <code>CTRL</code> ingedrukt te houden en forums aan te klikken.',
++ 	'PST_ADVANCED_FORUM'=> 'Geavanceerd forum instellingen',
++ 	'PST_DESELECT_ALL'	=> 'Selectie opheffen',
++ 	'PST_LEGEND4'		=> 'Optionele instellingen',
++ 	'PST_WORDS'			=> 'Speciale woorden om te negeren',
++ 	'PST_WORDS_EXPLAIN'	=> 'Voeg speciale woorden toe die uniek zijn aan uw forum en moeten genegeerd worden bij het vinden van vergelijkbare onderwerpen. (Opgelet: woorden die momenteel als veelvoorkomend worden beschouwd in uw taal, worden reeds standaard genegeerd.) Scheid elk woord met een spatie. Niet hoofdlettergevoelig.',
++ 	'PST_SAVED'			=> 'Vergelijkbare onderwerpen instellingen bijgewerkt',
++-	'PST_FORUM_INFO'	=> '“Niet weergeven in”: Soortgelijke onderwerpen worden niet weergegeven in de geselecteerde forums.<br>“Niet zoeken in” : Zal niet zoeken in de geselecteerde forums voor vergelijkbare onderwerpen.',
+++	'PST_FORUM_INFO'	=> '“Niet weergeven in”: Soortgelijke onderwerpen worden niet weergegeven in de geselecteerde forums.<br />“Niet zoeken in” : Zal niet zoeken in de geselecteerde forums voor vergelijkbare onderwerpen.',
++ 	'PST_NO_COMPAT'		=> 'Vergelijkbare onderwerpen zal niet werken op uw forum. Vergelijkbare onderwerpen vereist een PostgreSQL, MySQL 4 of 5 MySQL database.',
++ 	'PST_ERR_CONFIG'	=> 'Te veel fora werden gemarkeerd in de lijst van forums. Probeer het opnieuw met een kleinere selectie.',
++ ));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/pl/acp_similar_topics.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/language/pl/acp_similar_topics.php"
++index 83fd756d5..b28cc3018 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/pl/acp_similar_topics.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/language/pl/acp_similar_topics.php"
++@@ -43,7 +43,6 @@ $lang = array_merge($lang, array(
++ 	'PST_EXPLAIN'		=> 'Rozszerzenie Precise Similar Topics wyświetla listę podobnych tematów na dole strony bieżącego tematu.',
++ 	'PST_LEGEND1'		=> 'Ustawienia ogólne',
++ 	'PST_ENABLE'		=> 'Włącz podobne tematy',
++-	'PST_ENABLE_EXPLAIN'=> 'Show similar topics in topic discussion threads.',
++ 	'PST_LEGEND2'		=> 'Załaduj ustawienia',
++ 	'PST_LIMIT'			=> 'Liczba wyświetlanych tematów',
++ 	'PST_LIMIT_EXPLAIN'	=> 'Tutaj możesz określić, ile podobnych tematów zostanie wyświetlonych. Domyślnie jest to 5 tematów.',
++@@ -55,10 +54,8 @@ $lang = array_merge($lang, array(
++ 	'PST_DAYS'			=> 'Dzień',
++ 	'PST_CACHE'			=> 'Czas trwania pamięci podręcznej',
++ 	'PST_CACHE_EXPLAIN'	=> 'Pamięć podręczna wygasa po upływie tego czasu, w sekundach. Ustaw na 0, jeśli chcesz wyłączyć pamięć podręczną dla podobnych tematów.',
++-	'PST_DYNAMIC'		=> 'Display dynamic similar topics',
++-	'PST_DYNAMIC_EXPLAIN'=> 'Show similar topics as users type in the topic title field when creating new topics.',
++ 	'PST_SENSE'			=> 'Czułość wyszukiwania',
++-	'PST_SENSE_EXPLAIN'	=> 'Ustaw czułość wyszukiwania na wartość pomiędzy 1 do 10. Użyj niższej liczby, jeśli nie widzisz żadnych podobnych tematów. Zalecane ustawienia: %d',
+++	'PST_SENSE_EXPLAIN'	=> 'Ustaw czułość wyszukiwania na wartość pomiędzy 1 do 10. Użyj niższej liczby, jeśli nie widzisz żadnych podobnych tematów. Zalecane ustawienia: Dla tabel bazy danych “phpbb_topics” używających InnoDB użyj 1; dla MyISAM użyj 5.',
++ 	'PST_LEGEND3'		=> 'Ustawienia forum',
++ 	'PST_NOSHOW_LIST'	=> 'Nie wyświetlaj w',
++ 	'PST_NOSHOW_TITLE'	=> 'Nie wyświetlaj podobnych tematów w',
++@@ -67,14 +64,14 @@ $lang = array_merge($lang, array(
++ 	'PST_STANDARD'		=> 'Standard',
++ 	'PST_ADVANCED'		=> 'Zaawansowane',
++ 	'PST_ADVANCED_TITLE'=> 'Kliknij, aby ustawić zaawansowane ustawienia dla',
++-	'PST_ADVANCED_EXP'	=> 'Tutaj możesz wybrać konkretne fora dla wyświetlania podobnych tematów. Tylko podobne tematy znalezione na wybranych forach będą wyświetlane w <strong>%s</strong>.<br><br>Nie należy wybierać żadnych, jeśli chcesz aby podobne tematy były wyszukiwane we wszystkich forach.<br><br>Zaznacz/odznacz wiele działów poprzez przytrzymanie klawisza <code>CTRL</code> i klikanie.',
+++	'PST_ADVANCED_EXP'	=> 'Tutaj możesz wybrać konkretne fora dla wyświetlania podobnych tematów. Tylko podobne tematy znalezione na wybranych forach będą wyświetlane w <strong>%s</strong>.<br /><br />Nie należy wybierać żadnych, jeśli chcesz aby podobne tematy były wyszukiwane we wszystkich forach.<br /><br />Zaznacz/odznacz wiele działów poprzez przytrzymanie klawisza <code>CTRL</code> i klikanie.',
++ 	'PST_ADVANCED_FORUM'=> 'Zaawansowane ustawienia forum',
++ 	'PST_DESELECT_ALL'	=> 'Odznacz wszystko',
++ 	'PST_LEGEND4'		=> 'Ustawienia dodatkowe',
++ 	'PST_WORDS'			=> 'Specjalne słowa do zignorowania',
++ 	'PST_WORDS_EXPLAIN'	=> 'Dodaj specjalne unikalne słowa, które powinny być zignorowane podczas wyszukiwania podobnych tematów. (Notka: Słowa, które są obecnie uważane za powszechne w twoim języku, są już domyślnie ignorowane.) Oddziel każde słowo spacją. Bez względu na wielkość liter.',
++ 	'PST_SAVED'			=> 'Zaktualizowano ustawienia podobnych tematów',
++-	'PST_FORUM_INFO'	=> '“Nie wyświetlaj w”: Nie będzie wyświetlać podobnych tematów w wybranych forach.<br>“Nie szukaj w”: Nie będzie wyszukiwać podobnych tematów w wybranych forach.',
+++	'PST_FORUM_INFO'	=> '“Nie wyświetlaj w”: Nie będzie wyświetlać podobnych tematów w wybranych forach.<br />“Nie szukaj w”: Nie będzie wyszukiwać podobnych tematów w wybranych forach.',
++ 	'PST_NO_COMPAT'		=> 'Rozszerzenie podobne tematy nie jest kompatybilne z twoim forum. Rozszerzenie podobne tematy będzie działać tylko w bazie danych MySQL lub PostgreSQL.',
++ 	'PST_ERR_CONFIG'	=> 'Zbyt wiele forów zostało oznaczonych na liście forów. Proszę, spróbuj ponownie z mniejszym wyborem.',
++ ));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/pt/acp_similar_topics.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/language/pt/acp_similar_topics.php"
++index 5b0ecd59c..47b3c3ffb 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/pt/acp_similar_topics.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/language/pt/acp_similar_topics.php"
++@@ -43,7 +43,6 @@ $lang = array_merge($lang, array(
++ 	'PST_EXPLAIN'		=> 'Precise Similar Topics apresenta uma lista de temas semelhantes, na parte inferior da página do tópico atual.',
++ 	'PST_LEGEND1'		=> 'Configurações gerais',
++ 	'PST_ENABLE'		=> 'Ativar Tópicos Semelhantes',
++-	'PST_ENABLE_EXPLAIN'=> 'Show similar topics in topic discussion threads.',
++ 	'PST_LEGEND2'		=> 'Carregar configurações',
++ 	'PST_LIMIT'			=> 'Número de Tópicos Semelhantes a exibir',
++ 	'PST_LIMIT_EXPLAIN'	=> 'Indique o número de Tópicos Semelhantes a exibir. O padrão é 5 Tópicos.',
++@@ -55,10 +54,8 @@ $lang = array_merge($lang, array(
++ 	'PST_DAYS'			=> 'Dias',
++ 	'PST_CACHE'			=> 'Duração da Cache de Tópicos Semelhantes',
++ 	'PST_CACHE_EXPLAIN'	=> 'A Cache de Tópicos Semelhantes vai expirar após esse tempo, em segundos. 0 para desativar a Cache de Tópicos Semelhantes.',
++-	'PST_DYNAMIC'		=> 'Display dynamic similar topics',
++-	'PST_DYNAMIC_EXPLAIN'=> 'Show similar topics as users type in the topic title field when creating new topics.',
++ 	'PST_SENSE'			=> 'Search sensitivity',
++-	'PST_SENSE_EXPLAIN'	=> 'For MySQL or Postgres databases, you can set the search sensitivity to a value between 1 and 10. Use a lower number if you are not seeing any similar topics. Recommended setting: %d',
+++	'PST_SENSE_EXPLAIN'	=> 'Set the search sensitivity to a value between 1 and 10. Use a lower number if you are not seeing any similar topics. Recommended settings: For “phpbb_topics” database tables using InnoDB use 1; for MyISAM use 5.',
++ 	'PST_LEGEND3'		=> 'Configurações do fórum',
++ 	'PST_NOSHOW_LIST'	=> 'Não exibir em',
++ 	'PST_NOSHOW_TITLE'	=> 'Não exibir Tópicos Semelhantes em',
++@@ -67,14 +64,14 @@ $lang = array_merge($lang, array(
++ 	'PST_STANDARD'		=> 'Norma',
++ 	'PST_ADVANCED'		=> 'Avançado',
++ 	'PST_ADVANCED_TITLE'=> 'Clique para configurar definições avançadas de Tópicos Semelhantes para',
++-	'PST_ADVANCED_EXP'	=> 'Aqui pode selecionar os Fóruns de onde serão extraidos os Tópicos Semelhantes. Apenas Tópicos Semelhantes encontrados nos Fóruns que selecionar aqui serão exibidos em <strong>%s</strong>.<br><br>Não selecione nenhum se deseja Tópicos Semelhantes de todos os Fóruns pesquisáveis a serem exibidos neste Fórum.<br><br>Selecione/Desmarque múltiplos Fóruns clicando <code>CTRL</code> e clicando.',
+++	'PST_ADVANCED_EXP'	=> 'Aqui pode selecionar os Fóruns de onde serão extraidos os Tópicos Semelhantes. Apenas Tópicos Semelhantes encontrados nos Fóruns que selecionar aqui serão exibidos em <strong>%s</strong>.<br /><br />Não selecione nenhum se deseja Tópicos Semelhantes de todos os Fóruns pesquisáveis a serem exibidos neste Fórum.<br /><br />Selecione/Desmarque múltiplos Fóruns clicando <code>CTRL</code> e clicando.',
++ 	'PST_ADVANCED_FORUM'=> 'Configurações avançadas de fórum',
++ 	'PST_DESELECT_ALL'	=> 'Desmarcar todos',
++ 	'PST_LEGEND4'		=> 'Configurações opcionais',
++ 	'PST_WORDS'			=> 'Palavras especiais para ignorar',
++ 	'PST_WORDS_EXPLAIN'	=> 'Adicionar palavras especiais exclusivas para o seu fórum que deve ser ignorado em topicos semelhantes. (Nota: Palavras comuns na sua língua são ignorados por padrão.) Separar cada palavra com um espaço. De caso não é sensível.',
++ 	'PST_SAVED'			=> 'As configurações de Tópicos Semelhantes foram atualizadas',
++-	'PST_FORUM_INFO'	=> '<strong>Não exibir em</strong>: Desativa a exibição de Tópicos Semelhantes nos Fóruns selecionados.<br><strong>Não pesquisar em</strong>: Ignora os Fóruns selecionados na pesquisa de Tópicos Semelhantes.',
+++	'PST_FORUM_INFO'	=> '<strong>Não exibir em</strong>: Desativa a exibição de Tópicos Semelhantes nos Fóruns selecionados.<br /><strong>Não pesquisar em</strong>: Ignora os Fóruns selecionados na pesquisa de Tópicos Semelhantes.',
++ 	'PST_NO_COMPAT'		=> 'Similar Topics não irá funcionar com seu Fórum. Similar Topics requer uma Base de Dados MySQL 4 ou MySQL 5 ou PostgreSQL.',
++ 	'PST_ERR_CONFIG'	=> 'Too muitos fóruns foram marcados na lista de fóruns. Por favor, tente novamente com uma seleção menor.',
++ ));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/pt_br/acp_similar_topics.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/language/pt_br/acp_similar_topics.php"
++index 80247f16f..72748ae3b 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/pt_br/acp_similar_topics.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/language/pt_br/acp_similar_topics.php"
++@@ -43,7 +43,6 @@ $lang = array_merge($lang, array(
++ 	'PST_EXPLAIN'		=> 'Tópicos Semelhantes apresenta uma lista de tópicos semelhantes, na parte inferior da página do tópico atual.',
++ 	'PST_LEGEND1'		=> 'Configurações gerais',
++ 	'PST_ENABLE'		=> 'Ativar Tópicos Semelhantes',
++-	'PST_ENABLE_EXPLAIN'=> 'Show similar topics in topic discussion threads.',
++ 	'PST_LEGEND2'		=> 'Carregar configurações',
++ 	'PST_LIMIT'			=> 'Número de Tópicos Semelhantes a exibir',
++ 	'PST_LIMIT_EXPLAIN'	=> 'Indique o número de Tópicos Semelhantes a exibir. O padrão é 5 Tópicos.',
++@@ -55,10 +54,8 @@ $lang = array_merge($lang, array(
++ 	'PST_DAYS'			=> 'Dias',
++ 	'PST_CACHE'			=> 'Duração da Cache de Tópicos Semelhantes',
++ 	'PST_CACHE_EXPLAIN'	=> 'A Cache de Tópicos Semelhantes vai expirar após esse tempo, em segundos. 0 para desativar a Cache de Tópicos Semelhantes.',
++-	'PST_DYNAMIC'		=> 'Display dynamic similar topics',
++-	'PST_DYNAMIC_EXPLAIN'=> 'Show similar topics as users type in the topic title field when creating new topics.',
++ 	'PST_SENSE'			=> 'Sensibilidade de pesquisa',
++-	'PST_SENSE_EXPLAIN'	=> 'Defina a sensibilidade da pesquisa para um valor entre 1 e 10. Use um número menor se você não estiver vendo tópicos semelhantes. Configurações recomendadas: %d',
+++	'PST_SENSE_EXPLAIN'	=> 'Defina a sensibilidade da pesquisa para um valor entre 1 e 10. Use um número menor se você não estiver vendo tópicos semelhantes. Configurações recomendadas: Para tabelas de banco de dados “phpbb_topics” usando InnoDB use 1; para MyISAM use 5.',
++ 	'PST_LEGEND3'		=> 'Configurações do fórum',
++ 	'PST_NOSHOW_LIST'	=> 'Não exibir em',
++ 	'PST_NOSHOW_TITLE'	=> 'Não exibir Tópicos Semelhantes em',
++@@ -67,14 +64,14 @@ $lang = array_merge($lang, array(
++ 	'PST_STANDARD'		=> 'Norma',
++ 	'PST_ADVANCED'		=> 'Avançado',
++ 	'PST_ADVANCED_TITLE'=> 'Clique para configurar definições avançadas de Tópicos Semelhantes para',
++-	'PST_ADVANCED_EXP'	=> 'Aqui pode selecionar os Fóruns de onde serão extraidos os Tópicos Semelhantes. Apenas Tópicos Semelhantes encontrados nos Fóruns que selecionar aqui serão exibidos em <strong>%s</strong>.<br><br>Não selecione nenhum se deseja Tópicos Semelhantes de todos os Fóruns pesquisáveis a serem exibidos neste Fórum.<br><br>Selecione/Desmarque múltiplos Fóruns clicando <code>CTRL</code> e clicando.',
+++	'PST_ADVANCED_EXP'	=> 'Aqui pode selecionar os Fóruns de onde serão extraidos os Tópicos Semelhantes. Apenas Tópicos Semelhantes encontrados nos Fóruns que selecionar aqui serão exibidos em <strong>%s</strong>.<br /><br />Não selecione nenhum se deseja Tópicos Semelhantes de todos os Fóruns pesquisáveis a serem exibidos neste Fórum.<br /><br />Selecione/Desmarque múltiplos Fóruns clicando <code>CTRL</code> e clicando.',
++ 	'PST_ADVANCED_FORUM'=> 'Configurações avançadas de fórum',
++ 	'PST_DESELECT_ALL'	=> 'Desmarcar todos',
++ 	'PST_LEGEND4'		=> 'Configurações opcionais',
++ 	'PST_WORDS'			=> 'Palavras especiais para ignorar',
++ 	'PST_WORDS_EXPLAIN'	=> 'Adicionar palavras especiais exclusivas para o seu fórum que deve ser ignorado em topicos semelhantes. (Nota: Palavras comuns na sua língua são ignorados por padrão.) Separar cada palavra com um espaço. De caso não é sensível.',
++ 	'PST_SAVED'			=> 'As configurações de Tópicos Semelhantes foram atualizadas',
++-	'PST_FORUM_INFO'	=> '<strong>Não exibir em</strong>: Desativa a exibição de Tópicos Semelhantes nos Fóruns selecionados.<br><strong>Não pesquisar em</strong>: Ignora os Fóruns selecionados na pesquisa de Tópicos Semelhantes.',
+++	'PST_FORUM_INFO'	=> '<strong>Não exibir em</strong>: Desativa a exibição de Tópicos Semelhantes nos Fóruns selecionados.<br /><strong>Não pesquisar em</strong>: Ignora os Fóruns selecionados na pesquisa de Tópicos Semelhantes.',
++ 	'PST_NO_COMPAT'		=> 'Tópicos Semelhantes não irá funcionar com seu Fórum. Similar Topics requer uma Base de Dados MySQL 4 ou MySQL 5 ou PostgreSQL.',
++ 	'PST_ERR_CONFIG'	=> 'Muitos fóruns foram marcados na lista de fóruns. Por favor, tente novamente com uma seleção menor.',
++ ));
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/language/pt_preao/acp_similar_topics.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/language/pt_preao/acp_similar_topics.php"
++new file mode 100644
++index 000000000..60f5b202b
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/language/pt_preao/acp_similar_topics.php"
++@@ -0,0 +1,76 @@
+++<?php
+++/**
+++*
+++* Precise Similar Topics [English]
+++*
+++* @copyright (c) 2013 Matt Friedman
+++* @license GNU General Public License, version 2 (GPL-2.0)
+++*
+++*/
+++
+++/**
+++* DO NOT CHANGE
+++*/
+++if (!defined('IN_PHPBB'))
+++{
+++	exit;
+++}
+++
+++if (empty($lang) || !is_array($lang))
+++{
+++	$lang = array();
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
+++//
+++// Some characters you may want to copy&paste:
+++// ’ » “ ” …
+++//
+++
+++$lang = array_merge($lang, array(
+++	'PST_TITLE_ACP'		=> 'Precise Similar Topics',
+++	'PST_EXPLAIN'		=> 'Precise Similar Topics displays a list of similar (related) topics at the bottom of the current topic’s page.',
+++	'PST_LEGEND1'		=> 'General settings',
+++	'PST_ENABLE'		=> 'Display Similar Topics',
+++	'PST_LEGEND2'		=> 'Load settings',
+++	'PST_LIMIT'			=> 'Number of Similar Topics to display',
+++	'PST_LIMIT_EXPLAIN'	=> 'Here you can define how many similar topics to display. The default is 5 topics.',
+++	'PST_TIME'			=> 'Search period',
+++	'PST_TIME_EXPLAIN'	=> 'This option allows you to configure the Similar Topics search period. For example, if set to “5 days” the system will only show similar topics from within the last 5 days. The default is 1 year.',
+++	'PST_YEARS'			=> 'Years',
+++	'PST_MONTHS'		=> 'Months',
+++	'PST_WEEKS'			=> 'Weeks',
+++	'PST_DAYS'			=> 'Days',
+++	'PST_CACHE'			=> 'Similar Topics cache length',
+++	'PST_CACHE_EXPLAIN'	=> 'Cached similar topics will expire after this time, in seconds. Set to 0 if you want to disable the similar topics cache.',
+++	'PST_SENSE'			=> 'Search sensitivity',
+++	'PST_SENSE_EXPLAIN'	=> 'Set the search sensitivity to a value between 1 and 10. Use a lower number if you are not seeing any similar topics. Recommended settings: For “phpbb_topics” database tables using InnoDB use 1; for MyISAM use 5.',
+++	'PST_LEGEND3'		=> 'Forum settings',
+++	'PST_NOSHOW_LIST'	=> 'Do Not Display In',
+++	'PST_NOSHOW_TITLE'	=> 'Do not display similar topics in',
+++	'PST_IGNORE_SEARCH'	=> 'Do Not Search In',
+++	'PST_IGNORE_TITLE'	=> 'Do not search for similar topics in',
+++	'PST_STANDARD'		=> 'Standard',
+++	'PST_ADVANCED'		=> 'Advanced',
+++	'PST_ADVANCED_TITLE'=> 'Click to set up advanced similar topic settings for',
+++	'PST_ADVANCED_EXP'	=> 'Here you can select specific forums to pull similar topics from. Only similar topics found in the forums you select here will be displayed in <strong>%s</strong>.<br /><br />Do not select any forums if you want similar topics from all searchable forums to be displayed in this forum.<br /><br />Select multiple forums by holding <samp>CTRL</samp> (or <samp>&#8984;CMD</samp> on Mac) and clicking.',
+++	'PST_ADVANCED_FORUM'=> 'Advanced forum settings',
+++	'PST_DESELECT_ALL'	=> 'Deselect all',
+++	'PST_LEGEND4'		=> 'Optional settings',
+++	'PST_WORDS'			=> 'Special words to ignore',
+++	'PST_WORDS_EXPLAIN'	=> 'Add special words unique to your forum that should be ignored when finding similar topics. (Note: Words that are currently regarded as common in your language are already ignored by default.) Separate each word with a space. Case insensitive.',
+++	'PST_SAVED'			=> 'Similar Topics settings updated',
+++	'PST_FORUM_INFO'	=> '“Do Not Display In”: Will not show similar topics in the selected forums.<br />“Do Not Search In” : Will not search for similar topics in the selected forums.',
+++	'PST_NO_COMPAT'		=> 'Similar Topics is not compatible with your forum. Similar Topics will only run on a MySQL or PostgreSQL database.',
+++	'PST_ERR_CONFIG'	=> 'Too many forums were marked in the list of forums. Please try again with a smaller selection.',
+++));
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/language/pt_preao/info_acp_similar_topics.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/language/pt_preao/info_acp_similar_topics.php"
++new file mode 100644
++index 000000000..258a59e66
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/language/pt_preao/info_acp_similar_topics.php"
++@@ -0,0 +1,44 @@
+++<?php
+++/**
+++*
+++* Precise Similar Topics [English]
+++*
+++* @copyright (c) 2013 Matt Friedman
+++* @license GNU General Public License, version 2 (GPL-2.0)
+++*
+++*/
+++
+++/**
+++* DO NOT CHANGE
+++*/
+++if (!defined('IN_PHPBB'))
+++{
+++	exit;
+++}
+++
+++if (empty($lang) || !is_array($lang))
+++{
+++	$lang = array();
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
+++//
+++// Some characters you may want to copy&paste:
+++// ’ » “ ” …
+++//
+++
+++$lang = array_merge($lang, array(
+++	'PST_TITLE_ACP'		=> 'Precise Similar Topics',
+++	'PST_SETTINGS'		=> 'Similar topics settings',
+++	'PST_LOG_MSG'		=> '<strong>Altered Similar Topics settings</strong>',
+++));
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/language/pt_preao/permissions_similar_topics.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/language/pt_preao/permissions_similar_topics.php"
++new file mode 100644
++index 000000000..ac72e9de9
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/language/pt_preao/permissions_similar_topics.php"
++@@ -0,0 +1,50 @@
+++<?php
+++/**
+++*
+++* Precise Similar Topics [English]
+++*
+++* @copyright (c) 2013 Matt Friedman
+++* @license GNU General Public License, version 2 (GPL-2.0)
+++*
+++*/
+++
+++/**
+++* DO NOT CHANGE
+++*/
+++if (!defined('IN_PHPBB'))
+++{
+++	exit;
+++}
+++
+++if (empty($lang) || !is_array($lang))
+++{
+++	$lang = array();
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
+++
+++/**
+++*	EXTENSION-DEVELOPERS PLEASE NOTE
+++*
+++*	You are able to put your permission sets into your extension.
+++*	The permissions logic should be added via the 'core.permissions' event.
+++*	You can easily add new permission categories, types and permissions, by
+++*	simply merging them into the respective arrays.
+++*	The respective language strings should be added into a language file, that
+++*	start with 'permissions_', so they are automatically loaded within the ACP.
+++*/
+++
+++// User Permissions
+++$lang = array_merge($lang, array(
+++	'ACL_U_SIMILARTOPICS'	=> 'Can view similar topics',
+++));
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/language/pt_preao/similar_topics.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/language/pt_preao/similar_topics.php"
++new file mode 100644
++index 000000000..906a7944e
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/language/pt_preao/similar_topics.php"
++@@ -0,0 +1,43 @@
+++<?php
+++/**
+++*
+++* Precise Similar Topics [English]
+++*
+++* @copyright (c) 2013 Matt Friedman
+++* @license GNU General Public License, version 2 (GPL-2.0)
+++*
+++*/
+++
+++/**
+++* DO NOT CHANGE
+++*/
+++if (!defined('IN_PHPBB'))
+++{
+++	exit;
+++}
+++
+++if (empty($lang) || !is_array($lang))
+++{
+++	$lang = array();
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
+++//
+++// Some characters you may want to copy&paste:
+++// ’ » “ ” …
+++//
+++
+++$lang = array_merge($lang, array(
+++	'SIMILAR_TOPICS'			=> 'Tópicos Semelhantes',
+++	'DISPLAY_SIMILAR_TOPICS'	=> 'Exibir tópicos semelhantes',
+++));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/ro/acp_similar_topics.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/language/ro/acp_similar_topics.php"
++index 4fb9e1511..afc15a763 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/ro/acp_similar_topics.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/language/ro/acp_similar_topics.php"
++@@ -43,7 +43,6 @@ $lang = array_merge($lang, array(
++ 	'PST_EXPLAIN'		=> 'Subiecte similare precise afișează o listă de subiecte similare în partea de jos a paginii subiect curente.',
++ 	'PST_LEGEND1'		=> 'Setări generale',
++ 	'PST_ENABLE'		=> 'Activaţi subiectele similare',
++-	'PST_ENABLE_EXPLAIN'=> 'Show similar topics in topic discussion threads.',
++ 	'PST_LEGEND2'		=> 'Încarcă setări',
++ 	'PST_LIMIT'			=> 'Numărul de subiecte similare care să fie afişate',
++ 	'PST_LIMIT_EXPLAIN'	=> 'Aici puteţi preciza câte subiecte similare să fie afişate. Implicite sunt 5.',
++@@ -55,10 +54,8 @@ $lang = array_merge($lang, array(
++ 	'PST_DAYS'			=> 'Zile',
++ 	'PST_CACHE'			=> 'Dimeniune cache',
++ 	'PST_CACHE_EXPLAIN'	=> 'Subiectele similare memorate vor expira după acest timp, în secunde. Alegeţi 0 dacă doriţi să dezactivaţi memorarea subiectelor similare.',
++-	'PST_DYNAMIC'		=> 'Display dynamic similar topics',
++-	'PST_DYNAMIC_EXPLAIN'=> 'Show similar topics as users type in the topic title field when creating new topics.',
++ 	'PST_SENSE'			=> 'Search sensitivity',
++-	'PST_SENSE_EXPLAIN'	=> 'For MySQL or Postgres databases, you can set the search sensitivity to a value between 1 and 10. Use a lower number if you are not seeing any similar topics. Recommended setting: %d',
+++	'PST_SENSE_EXPLAIN'	=> 'Set the search sensitivity to a value between 1 and 10. Use a lower number if you are not seeing any similar topics. Recommended settings: For “phpbb_topics” database tables using InnoDB use 1; for MyISAM use 5.',
++ 	'PST_LEGEND3'		=> 'Setări forum',
++ 	'PST_NOSHOW_LIST'	=> 'Nu afişa în',
++ 	'PST_NOSHOW_TITLE'	=> 'Nu afişa subiecte similare în',
++@@ -67,14 +64,14 @@ $lang = array_merge($lang, array(
++ 	'PST_STANDARD'		=> 'Standard',
++ 	'PST_ADVANCED'		=> 'Advanced',
++ 	'PST_ADVANCED_TITLE'=> 'Apăsaţi pentru a configura setările avansate ale subiectelor similare pentru',
++-	'PST_ADVANCED_EXP'	=> 'Aici puteţi alege forumuri specifice din care să afişaţi subiecte similare. Numai subiectele similare găsite în forumurile pe care le-aţi ales aici vor fi afişate în <strong>%s</strong>.<br><br>Nu alegeţi orice forumuri dacă doriţi ca toate subiectele similare din toate forumurile ce pot fi căutate să fie afişate în acest forum.<br><br>Selectaţi/Deselectaţi mai multe forumuri ţinând apăsată tasta <code>CTRL</code> şi făcând click.',
+++	'PST_ADVANCED_EXP'	=> 'Aici puteţi alege forumuri specifice din care să afişaţi subiecte similare. Numai subiectele similare găsite în forumurile pe care le-aţi ales aici vor fi afişate în <strong>%s</strong>.<br /><br />Nu alegeţi orice forumuri dacă doriţi ca toate subiectele similare din toate forumurile ce pot fi căutate să fie afişate în acest forum.<br /><br />Selectaţi/Deselectaţi mai multe forumuri ţinând apăsată tasta <code>CTRL</code> şi făcând click.',
++ 	'PST_ADVANCED_FORUM'=> 'Setări avansate pe forum pentru',
++ 	'PST_DESELECT_ALL'	=> 'Deselectaţi tot',
++ 	'PST_LEGEND4'		=> 'Setări opţionale',
++ 	'PST_WORDS'			=> 'Cuvinte speciale ignorate',
++ 	'PST_WORDS_EXPLAIN'	=> 'Adăugaţi cuvinte speciale unice care ar trebui ignorate atunci când sunt căutate subiecte similare. (Reţineţi: Cuvintele care sunt cunoscute ca frecvente în limba dumneavoastră sunt implicit ignorate.) Separaţi cuvintele între ele cu un spaţiu. Majusculele sunt nesemnificative.',
++ 	'PST_SAVED'			=> 'Setări actualizate',
++-	'PST_FORUM_INFO'	=> '“Nu afişa în”: Nu va afişa subiectele similare în forumurile alese.<br>“Nu căuta în” : Nu va căuta subiecte similare în forumurile alese.',
+++	'PST_FORUM_INFO'	=> '“Nu afişa în”: Nu va afişa subiectele similare în forumurile alese.<br />“Nu căuta în” : Nu va căuta subiecte similare în forumurile alese.',
++ 	'PST_NO_COMPAT'		=> 'MODificarea Subiecte similare nu va funcţiona pe forumul dumneavoastr. MODificarea Subiecte similare necesită o bază de date cu MySQL 4 sau MySQL 5 sau PostgreSQL.',
++ 	'PST_ERR_CONFIG'	=> 'Prea multe forumuri au fost marcate în lista de forumuri. Vă rugăm să încercați din nou, cu o selecție mai mic.',
++ ));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/ru/acp_similar_topics.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/language/ru/acp_similar_topics.php"
++index 5b59297ca..12b8aaf7f 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/ru/acp_similar_topics.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/language/ru/acp_similar_topics.php"
++@@ -42,7 +42,6 @@ $lang = array_merge($lang, array(
++ 	'PST_EXPLAIN'		=> 'Расширение «Похожие темы» отображает список похожих (связанных) тем внизу на странице с сообщениями просматриваемой темы.',
++ 	'PST_LEGEND1'		=> 'Основные настройки',
++ 	'PST_ENABLE'		=> 'Отображать похожие темы',
++-	'PST_ENABLE_EXPLAIN'=> 'Show similar topics in topic discussion threads.',
++ 	'PST_LEGEND2'		=> 'Настройки загрузки',
++ 	'PST_LIMIT'			=> 'Количество похожих тем для отображения',
++ 	'PST_LIMIT_EXPLAIN'	=> 'Здесь можно установить количество тем, которые будут показываться в блоке «Похожие темы». По умолчанию установлено отображение 5 похожих тем.',
++@@ -54,10 +53,8 @@ $lang = array_merge($lang, array(
++ 	'PST_DAYS'			=> 'дней',
++ 	'PST_CACHE'			=> 'Размер кэша для расширения «Похожие темы»',
++ 	'PST_CACHE_EXPLAIN'	=> 'Количество секунд, по прошествии которого очищается кэш расширения «Похожие темы». Установите данную опцию в 0, если хотите полностью отключить кэширование для данного расширения.',
++-	'PST_DYNAMIC'		=> 'Display dynamic similar topics',
++-	'PST_DYNAMIC_EXPLAIN'=> 'Show similar topics as users type in the topic title field when creating new topics.',
++ 	'PST_SENSE'			=> 'Чувствительность поиска',
++-	'PST_SENSE_EXPLAIN'	=> 'Здесь можно установить чувствительность поиска в пределах от 1 до 10. Используйте число меньше установленного, если не отображается ни одна похожая тема. Рекомендуемая настройка: %d',
+++	'PST_SENSE_EXPLAIN'	=> 'Здесь можно установить чувствительность поиска в пределах от 1 до 10. Используйте число меньше установленного, если не отображается ни одна похожая тема. Рекомендуемая настройка: если тип таблицы «phpbb_topics» установлен в InnoDB, то установите 1; для типа MyISAM установите 5.',
++ 	'PST_LEGEND3'		=> 'Настройки форума',
++ 	'PST_NOSHOW_LIST'	=> 'Не отображать в',
++ 	'PST_NOSHOW_TITLE'	=> 'Не отображать похожие темы в',
++@@ -66,14 +63,14 @@ $lang = array_merge($lang, array(
++ 	'PST_STANDARD'		=> 'Стандартные',
++ 	'PST_ADVANCED'		=> 'Продвинутые',
++ 	'PST_ADVANCED_TITLE'=> 'Кликните мышкой для того, чтобы открыть продвинутые установки расширения «Похожие темы»',
++-	'PST_ADVANCED_EXP'	=> 'Здесь вы можете указать конкретные разделы форума, откуда брать похожие темы. В блоке «Похожие темы» будут отображаться темы ТОЛЬКО из указанных здесь разделов.<br><br>Если вы не выберете ни один раздел, то поиск похожих тем будет осуществляться по всем разделам форума.<br><br>Можно выбрать несколько разделов с помощью клавиши <samp>CTRL</samp> (либо клавиши <samp>&#8984;CMD</samp> на компьютерах Mac) и левой кнопки мышки.',
+++	'PST_ADVANCED_EXP'	=> 'Здесь вы можете указать конкретные разделы форума, откуда брать похожие темы. В блоке «Похожие темы» будут отображаться темы ТОЛЬКО из указанных здесь разделов.<br /><br />Если вы не выберете ни один раздел, то поиск похожих тем будет осуществляться по всем разделам форума.<br /><br />Можно выбрать несколько разделов с помощью клавиши <samp>CTRL</samp> (либо клавиши <samp>&#8984;CMD</samp> на компьютерах Mac) и левой кнопки мышки.',
++ 	'PST_ADVANCED_FORUM'=> 'Продвинутые настройки',
++ 	'PST_DESELECT_ALL'	=> 'Сбросить всё',
++ 	'PST_LEGEND4'		=> 'Необязательные настройки',
++ 	'PST_WORDS'			=> 'Игнорировать отдельные слова',
++ 	'PST_WORDS_EXPLAIN'	=> 'Здесь можно прописать отдельные слова, которые не будут учитываться при поиске похожих тем. (Внимание: некоторые общие слова используемого вами языка уже игнорируются по умолчанию.) Каждое слово отделяется пробелом. Регистр слов не учитывается.',
++ 	'PST_SAVED'			=> 'Настройки расширения «Похожие темы» обновлены',
++-	'PST_FORUM_INFO'	=> '«Не отображать в»: в выбранных здесь разделах блок «Похожие темы» отображаться не будет.<br>«Не осуществлять поиск похожих тем в»: в выбранных здесь разделах поиск похожих тем осуществляться не будет.',
+++	'PST_FORUM_INFO'	=> '«Не отображать в»: в выбранных здесь разделах блок «Похожие темы» отображаться не будет.<br />«Не осуществлять поиск похожих тем в»: в выбранных здесь разделах поиск похожих тем осуществляться не будет.',
++ 	'PST_NO_COMPAT'		=> 'Расширение «Похожие темы» не совместимо с вашим форумом. Для использование данного расширения необходимо использование базы данных MySQL или PostgreSQL.',
++ 	'PST_ERR_CONFIG'	=> 'Выбрано слишком много разделов форума. Пожалуйста, укажите меньшее количество разделов.',
++ ));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/sr/acp_similar_topics.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/language/sr/acp_similar_topics.php"
++index 2f49b07ab..e397a8571 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/sr/acp_similar_topics.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/language/sr/acp_similar_topics.php"
++@@ -42,7 +42,6 @@ $lang = array_merge($lang, array(
++ 	'PST_EXPLAIN'		=> 'Precise Similar Topics displays a list of similar (related) topics at the bottom of the current topic’s page.',
++ 	'PST_LEGEND1'		=> 'Generalna podešavanja',
++ 	'PST_ENABLE'		=> 'Uključi Similar Topics',
++-	'PST_ENABLE_EXPLAIN'=> 'Show similar topics in topic discussion threads.',
++ 	'PST_LEGEND2'		=> 'Učitaj podešavanja',
++ 	'PST_LIMIT'			=> 'Broj sličnih tema koje će biti prikazane',
++ 	'PST_LIMIT_EXPLAIN'	=> 'Ovde možete odrediti koliko sličnih tema će biti prikazano. Podrazumevana vrednost je 5.',
++@@ -54,10 +53,8 @@ $lang = array_merge($lang, array(
++ 	'PST_DAYS'			=> 'Dana',
++ 	'PST_CACHE'			=> 'Dužina keša za Similar Topics',
++ 	'PST_CACHE_EXPLAIN'	=> 'Keširane slične teme će da nestanu nakon toliko vremena u sekunadma. Podesite vrednost na 0 ukoliko želite da isključite ovu opciju.',
++-	'PST_DYNAMIC'		=> 'Display dynamic similar topics',
++-	'PST_DYNAMIC_EXPLAIN'=> 'Show similar topics as users type in the topic title field when creating new topics.',
++ 	'PST_SENSE'			=> 'Search sensitivity',
++-	'PST_SENSE_EXPLAIN'	=> 'For MySQL or Postgres databases, you can set the search sensitivity to a value between 1 and 10. Use a lower number if you are not seeing any similar topics. Recommended setting: %d',
+++	'PST_SENSE_EXPLAIN'	=> 'Set the search sensitivity to a value between 1 and 10. Use a lower number if you are not seeing any similar topics. Recommended settings: For “phpbb_topics” database tables using InnoDB use 1; for MyISAM use 5.',
++ 	'PST_LEGEND3'		=> 'Podešavanja foruma',
++ 	'PST_NOSHOW_LIST'	=> 'Ne prikazuj u',
++ 	'PST_NOSHOW_TITLE'	=> 'Ne prikazuj slične teme u',
++@@ -66,14 +63,14 @@ $lang = array_merge($lang, array(
++ 	'PST_STANDARD'		=> 'Standard',
++ 	'PST_ADVANCED'		=> 'Napredna podešavanja',
++ 	'PST_ADVANCED_TITLE'=> 'Kliknite ukoliko želite da odredite napredna podešavanja za',
++-	'PST_ADVANCED_EXP'	=> 'Ovde možete odrediti specifične forume iz kojih želite da se pretražuju slične teme. Jedino slične teme koje budu pronađene u forumu će biti prikazane u <strong>%s</strong>.<br><br>Nemojte da selektujete nijedan forum ukoliko želite da se prikazuju slične teme iz svih foruma u kojima je uključena opcija Similar Topics.<br><br>Možete izabrati više foruma tako što držite <code>CTRL</code> i kliknete.',
+++	'PST_ADVANCED_EXP'	=> 'Ovde možete odrediti specifične forume iz kojih želite da se pretražuju slične teme. Jedino slične teme koje budu pronađene u forumu će biti prikazane u <strong>%s</strong>.<br /><br />Nemojte da selektujete nijedan forum ukoliko želite da se prikazuju slične teme iz svih foruma u kojima je uključena opcija Similar Topics.<br /><br />Možete izabrati više foruma tako što držite <code>CTRL</code> i kliknete.',
++ 	'PST_ADVANCED_FORUM'=> 'Advanced forum settings',
++ 	'PST_DESELECT_ALL'	=> 'Deselektuj sve',
++ 	'PST_LEGEND4'		=> 'Opciona podešavanja',
++ 	'PST_WORDS'			=> 'Specialne reči za ignorisanje',
++ 	'PST_WORDS_EXPLAIN'	=> 'Dodajte specijalne reči koje su unikatne za vaš forum koje bi trebalo da budu ignorisane kada se pretražuju slične teme. (Napomena: reči koje se inače smatraju za ustaljene će ionako biti ignorisane prilikom pretrage.) Reči razdvojte razmakom. Case insensitive.',
++ 	'PST_SAVED'			=> 'Podešavanja za Similar Topics su ažurirana',
++-	'PST_FORUM_INFO'	=> '"Ne prikazuj u": Neće prikazati slične teme u izabranim forumima.<br>"Ne pretražuj u": Neće pretraživati slične teme u izabranim forumima.',
+++	'PST_FORUM_INFO'	=> '"Ne prikazuj u": Neće prikazati slične teme u izabranim forumima.<br />"Ne pretražuj u": Neće pretraživati slične teme u izabranim forumima.',
++ 	'PST_NO_COMPAT'		=> 'Similar Topics ne funkcioniše sa vašim forumom. Similar Topics zahteva MySQL 4 ili MySQL 5 ili PostgreSQL bazu podataka.',
++ 	'PST_ERR_CONFIG'	=> 'Previše forumi su označeni na listi forumima . Pokušajte ponovo sa manjim izborom.',
++ ));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/sv/acp_similar_topics.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/language/sv/acp_similar_topics.php"
++index 84250801e..1e426b274 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/sv/acp_similar_topics.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/language/sv/acp_similar_topics.php"
++@@ -43,7 +43,6 @@ $lang = array_merge($lang, array(
++ 	'PST_EXPLAIN'		=> 'Precise Similar Topics visar en lista över liknande ämnen längst ner i det aktuella ämnet sida.',
++ 	'PST_LEGEND1'		=> 'Generella inställningar',
++ 	'PST_ENABLE'		=> 'Aktivera Similar Topics',
++-	'PST_ENABLE_EXPLAIN'=> 'Show similar topics in topic discussion threads.',
++ 	'PST_LEGEND2'		=> 'Ladda inställningar',
++ 	'PST_LIMIT'			=> 'Antal liknande trådar som ska visas',
++ 	'PST_LIMIT_EXPLAIN'	=> 'Här anger du antalet liknande trådar som skall visas. Förinställt värde är 5 st.',
++@@ -55,10 +54,8 @@ $lang = array_merge($lang, array(
++ 	'PST_DAYS'			=> 'Dagar',
++ 	'PST_CACHE'			=> 'Lagring av liknande trådar',
++ 	'PST_CACHE_EXPLAIN'	=> 'Lagrade trådar upphör efter denna tid, inställt i sekunder. Ange 0 om du vill stänga av lagring av liknande trådar.',
++-	'PST_DYNAMIC'		=> 'Display dynamic similar topics',
++-	'PST_DYNAMIC_EXPLAIN'=> 'Show similar topics as users type in the topic title field when creating new topics.',
++ 	'PST_SENSE'			=> 'Search sensitivity',
++-	'PST_SENSE_EXPLAIN'	=> 'For MySQL or Postgres databases, you can set the search sensitivity to a value between 1 and 10. Use a lower number if you are not seeing any similar topics. Recommended setting: %d',
+++	'PST_SENSE_EXPLAIN'	=> 'Set the search sensitivity to a value between 1 and 10. Use a lower number if you are not seeing any similar topics. Recommended settings: For “phpbb_topics” database tables using InnoDB use 1; for MyISAM use 5.',
++ 	'PST_LEGEND3'		=> 'Foruminställningar',
++ 	'PST_NOSHOW_LIST'	=> 'Visa inte i',
++ 	'PST_NOSHOW_TITLE'	=> 'Visa inte liknande trådar i',
++@@ -67,14 +64,14 @@ $lang = array_merge($lang, array(
++ 	'PST_STANDARD'		=> 'Standard',
++ 	'PST_ADVANCED'		=> 'Avancerade',
++ 	'PST_ADVANCED_TITLE'=> 'Klicka för att ställa in avancerade inställningar',
++-	'PST_ADVANCED_EXP'	=> 'Här kan du välja specifika kategorier att hämta liknande trådar från. Endast liknande trådar från de kategorier du väljer här kommer att visas i <strong>%s</strong>.<br><br>Välj inga specifika kategorier om du vill visa liknande trådar från alla kategorier i detta forum.<br><br>Använd t.ex. kombinationen <code>CTRL</code> + musklick för att markera och välja (avvälja) fler än en kategori.',
+++	'PST_ADVANCED_EXP'	=> 'Här kan du välja specifika kategorier att hämta liknande trådar från. Endast liknande trådar från de kategorier du väljer här kommer att visas i <strong>%s</strong>.<br /><br />Välj inga specifika kategorier om du vill visa liknande trådar från alla kategorier i detta forum.<br /><br />Använd t.ex. kombinationen <code>CTRL</code> + musklick för att markera och välja (avvälja) fler än en kategori.',
++ 	'PST_ADVANCED_FORUM'=> 'Avancerade foruminställningar',
++ 	'PST_DESELECT_ALL'	=> 'Avmarkera alla',
++ 	'PST_LEGEND4'		=> 'Valfria inställningar',
++ 	'PST_WORDS'			=> 'Särskilda ord som ska ignoreras',
++ 	'PST_WORDS_EXPLAIN'	=> 'Lägg till särskilda ord på forumet som skall ignoreras vid sökningen av liknande trådar. (Obs: Ord som betraktas som vanliga ord är redan undantagna). Separera varje ord med ett mellanslag. Ingen hänsyn tas till versaler eller gemenser.',
++ 	'PST_SAVED'			=> 'Inställningarna har uppdaterats',
++-	'PST_FORUM_INFO'	=> '“Visa inte i” :  Liknande trådar visas inte i valda kategorier.<br>“Sök inte i” :  Sökning efter liknande trådar sker inte i valda kategorier.',
+++	'PST_FORUM_INFO'	=> '“Visa inte i” :  Liknande trådar visas inte i valda kategorier.<br />“Sök inte i” :  Sökning efter liknande trådar sker inte i valda kategorier.',
++ 	'PST_NO_COMPAT'		=> 'Similar Topics fungerar inte på ditt forum. Similar Topics kräver MySQL 4 eller MySQL 5 eller PostgreSQL.',
++ 	'PST_ERR_CONFIG'	=> 'Alltför många forum märktes i listan över forum. Försök igen med ett mindre urval.',
++ ));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/sv/search_ignore_words.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/sv/search_ignore_words.php"
++deleted file mode 100644
++index 7a24d356a..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/sv/search_ignore_words.php"
+++++ /dev/null
++@@ -1,115 +0,0 @@
++-<?php
++-/**
++- *
++- * Precise Similar Topics
++- *
++- * @copyright (c) 2025 Matt Friedman
++- * @license GNU General Public License, version 2 (GPL-2.0)
++- *
++- * This [sv] language list of stop words created by Matt Friedman for Similar Topics
++- *
++- */
++-
++-if (!defined('IN_PHPBB'))
++-{
++-   exit;
++-}
++-
++-$words = array(
++-	'alla',
++-	'alltid',
++-	'andra',
++-	'att',
++-	'av',
++-	'bara',
++-	'blev',
++-	'bli',
++-	'blir',
++-	'bra',
++-	'dag',
++-	'dagar',
++-	'den',
++-	'denna',
++-	'det',
++-	'detta',
++-	'dig',
++-	'din',
++-	'dina',
++-	'dit',
++-	'du',
++-	'efter',
++-	'eller',
++-	'en',
++-	'ett',
++-	'finns',
++-	'fram',
++-	'från',
++-	'för',
++-	'genom',
++-	'god',
++-	'hade',
++-	'han',
++-	'hans',
++-	'har',
++-	'hem',
++-	'hennes',
++-	'här',
++-	'hör',
++-	'hur',
++-	'inte',
++-	'jag',
++-	'kan',
++-	'kanske',
++-	'kom',
++-	'kommer',
++-	'kring',
++-	'lite',
++-	'man',
++-	'med',
++-	'men',
++-	'mer',
++-	'mycket',
++-	'måste',
++-	'när',
++-	'någon',
++-	'något',
++-	'några',
++-	'och',
++-	'ofta',
++-	'om',
++-	'på',
++-	'redan',
++-	'rätt',
++-	'sade',
++-	'samma',
++-	'sedan',
++-	'ser',
++-	'sig',
++-	'sin',
++-	'sina',
++-	'sitt',
++-	'ska',
++-	'skulle',
++-	'som',
++-	'stor',
++-	'stora',
++-	'säga',
++-	'säger',
++-	'tid',
++-	'till',
++-	'under',
++-	'upp',
++-	'var',
++-	'vara',
++-	'varit',
++-	'varje',
++-	'vem',
++-	'vi',
++-	'vid',
++-	'vill',
++-	'väl',
++-	'än',
++-	'är',
++-	'även',
++-	'över',
++-);
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/tr/acp_similar_topics.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/language/tr/acp_similar_topics.php"
++index 4b945d8c4..924c87538 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/tr/acp_similar_topics.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/language/tr/acp_similar_topics.php"
++@@ -42,7 +42,6 @@ $lang = array_merge($lang, array(
++ 	'PST_EXPLAIN'		=> 'Benzer Konular eklentisi benzer (ilişkili) konuların bir listesini mevcut konu sayfasının altında gösterir.',
++ 	'PST_LEGEND1'		=> 'Genel Ayarlar',
++ 	'PST_ENABLE'		=> 'Benzer Konuları Göster',
++-	'PST_ENABLE_EXPLAIN'=> 'Show similar topics in topic discussion threads.',
++ 	'PST_LEGEND2'		=> 'Yükleme ayarları',
++ 	'PST_LIMIT'			=> 'Gösterilecek Benzer Konu sayısı',
++ 	'PST_LIMIT_EXPLAIN'	=> 'Buradan kaç tane Benzer Konunun gösterileceğini belirleyebilirsiniz. Varsayılan değer 5 konudur.',
++@@ -54,10 +53,8 @@ $lang = array_merge($lang, array(
++ 	'PST_DAYS'			=> 'Gün',
++ 	'PST_CACHE'			=> 'Benzer Konular önbellek uzunluğu',
++ 	'PST_CACHE_EXPLAIN'	=> 'Önbelleklenmiş benzer konuların süresi bu süre sonunda geçecektir, saniye olarak. 0 olarak ayarlarsanız benzer konular önbellekleme özelliğini kapatırsınız.',
++-	'PST_DYNAMIC'		=> 'Display dynamic similar topics',
++-	'PST_DYNAMIC_EXPLAIN'=> 'Show similar topics as users type in the topic title field when creating new topics.',
++-	'PST_SENSE'			=> 'Arama duyarlılığı',
++-	'PST_SENSE_EXPLAIN'	=> 'Arama duyarlılığını 1 ile 10 arasında bir değere ayarlayın. Benzer konular görmüyorsanız daha düşük bir sayı kullanın. Önerilen ayarlar: InnoDB kullanan “phpbb_topics” veritabanı tabloları için 1 kullanın; MyISAM kullanımı için 5.',
+++	'PST_SENSE'			=> 'Search sensitivity',
+++	'PST_SENSE_EXPLAIN'	=> 'Set the search sensitivity to a value between 1 and 10. Use a lower number if you are not seeing any similar topics. Recommended settings: For “phpbb_topics” database tables using InnoDB use 1; for MyISAM use 5.',
++ 	'PST_LEGEND3'		=> 'Forum ayarları',
++ 	'PST_NOSHOW_LIST'	=> 'Şurada gösterme',
++ 	'PST_NOSHOW_TITLE'	=> 'Benzer Konuları şurada gösterme',
++@@ -66,14 +63,14 @@ $lang = array_merge($lang, array(
++ 	'PST_STANDARD'		=> 'Standart',
++ 	'PST_ADVANCED'		=> 'Gelişmiş',
++ 	'PST_ADVANCED_TITLE'=> 'Gelişmiş benzer konular ayarlarını yüklemek için tıklayın',
++-	'PST_ADVANCED_EXP'	=> 'Buradan benzer konuların seçileceği belirli forumları seçebilirsin. Sadece burada seçtiğiniz forumlardaki benzer konular şurada gösterilir <strong>%s</strong>.<br><br>Tüm aranabilen forumlardan konuların Benzer Konularda gösterilmesini istiyorsanız hiç bir forumu seçmeyin.<br><br><code>CTRL</code>ye basılı tutup çoklu forum Seçimi/Seçimi Kaldırma işlemini yapabilirsiniz.',
+++	'PST_ADVANCED_EXP'	=> 'Buradan benzer konuların seçileceği belirli forumları seçebilirsin. Sadece burada seçtiğiniz forumlardaki benzer konular şurada gösterilir <strong>%s</strong>.<br /><br />Tüm aranabilen forumlardan konuların Benzer Konularda gösterilmesini istiyorsanız hiç bir forumu seçmeyin.<br /><br /><code>CTRL</code>ye basılı tutup çoklu forum Seçimi/Seçimi Kaldırma işlemini yapabilirsiniz.',
++ 	'PST_ADVANCED_FORUM'=> 'Gelişmiş forum ayarları',
++ 	'PST_DESELECT_ALL'	=> 'Tümünü kaldır',
++ 	'PST_LEGEND4'		=> 'İsteğe bağlı ayarlar',
++ 	'PST_WORDS'			=> 'Dikkate alınmayacak kelimeler',
++ 	'PST_WORDS_EXPLAIN'	=> 'Benzer konular bulunurken yoksayılacak özel kelimeleri ekle. (Not: Dilinizde sık kullanılan kelimeler zaten varsayılan olarak yoksayılmıştır.) Kelimeleri bir boşluk ile ayır. Büyük-küçük harf duyarlıdır.',
++ 	'PST_SAVED'			=> 'Benzer Konular ayarları güncellendi',
++-	'PST_FORUM_INFO'	=> '“Şurada gösterme”: seçili forumlarda benzer konuları göstermeyecek.<br>“Şurada arama” : Seçili forumlarda benzer konular  için aramayacak.',
+++	'PST_FORUM_INFO'	=> '“Şurada gösterme”: seçili forumlarda benzer konuları göstermeyecek.<br />“Şurada arama” : Seçili forumlarda benzer konular  için aramayacak.',
++ 	'PST_NO_COMPAT'		=> 'Benzer Konular forumunuzla uyumlu değil. Benzer Konular sadece MySQL 4 veya MySQL 5 veya PostgreSQL veritabanında çalışır.',
++ 	'PST_ERR_CONFIG'	=> 'Çok fazla forumlar forumlarda listesinde işaretlenmiştir. Küçük bir seçim ile tekrar deneyin.',
++ ));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/tr/search_ignore_words.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/tr/search_ignore_words.php"
++deleted file mode 100644
++index 0a4406e70..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/language/tr/search_ignore_words.php"
+++++ /dev/null
++@@ -1,102 +0,0 @@
++-<?php
++-/**
++- *
++- * Precise Similar Topics
++- *
++- * @copyright (c) 2025 Matt Friedman
++- * @license GNU General Public License, version 2 (GPL-2.0)
++- *
++- * This [tr] language list of stop words created by Matt Friedman for Similar Topics
++- *
++- */
++-
++-if (!defined('IN_PHPBB'))
++-{
++-   exit;
++-}
++-
++-$words = array(
++-	'acaba',
++-	'ama',
++-	'ancak',
++-	'artık',
++-	'aslında',
++-	'ayrıca',
++-	'bana',
++-	'bazen',
++-	'ben',
++-	'beni',
++-	'benim',
++-	'bile',
++-	'bir',
++-	'birçok',
++-	'biri',
++-	'birkaç',
++-	'biz',
++-	'bizi',
++-	'bizim',
++-	'bu',
++-	'buna',
++-	'bunda',
++-	'bundan',
++-	'bunlar',
++-	'bunları',
++-	'bunların',
++-	'bunu',
++-	'bunun',
++-	'büyük',
++-	'çok',
++-	'da',
++-	'daha',
++-	'de',
++-	'değil',
++-	'diye',
++-	'en',
++-	'eve',
++-	'gibi',
++-	'gün',
++-	'günler',
++-	'hep',
++-	'her',
++-	'hiç',
++-	'için',
++-	'ile',
++-	'ise',
++-	'işte',
++-	'kadar',
++-	'kendi',
++-	'ki',
++-	'küçük',
++-	'mı',
++-	'mi',
++-	'mu',
++-	'mü',
++-	'nasıl',
++-	'ne',
++-	'neden',
++-	'nerede',
++-	'niye',
++-	'olan',
++-	'olarak',
++-	'oldu',
++-	'olduğu',
++-	'olmak',
++-	'olması',
++-	'onu',
++-	'onun',
++-	'sadece',
++-	'şey',
++-	'şimdi',
++-	'şu',
++-	'şunu',
++-	'şunun',
++-	'tüm',
++-	'var',
++-	've',
++-	'veya',
++-	'ya',
++-	'yani',
++-	'yapılan',
++-	'yok',
++-	'zaman',
++-);
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/migrations/release_1_7_x/dynamic_similar_topics.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/migrations/release_1_7_x/dynamic_similar_topics.php"
++deleted file mode 100644
++index a17f26fac..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/migrations/release_1_7_x/dynamic_similar_topics.php"
+++++ /dev/null
++@@ -1,31 +0,0 @@
++-<?php
++-/**
++- *
++- * Precise Similar Topics
++- *
++- * @copyright (c) 2025 Matt Friedman
++- * @license GNU General Public License, version 2 (GPL-2.0)
++- *
++- */
++-
++-namespace vse\similartopics\migrations\release_1_7_x;
++-
++-class dynamic_similar_topics extends \phpbb\db\migration\migration
++-{
++-	public function effectively_installed()
++-	{
++-		return $this->config->offsetExists('similar_topics_dynamic');
++-	}
++-
++-	public static function depends_on()
++-	{
++-		return ['\vse\similartopics\migrations\release_1_5_x\similar_topic_words'];
++-	}
++-
++-	public function update_data()
++-	{
++-		return [
++-			['config.add', ['similar_topics_dynamic', 0]],
++-		];
++-	}
++-}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/migrations/release_1_7_x/mssql_index.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/migrations/release_1_7_x/mssql_index.php"
++deleted file mode 100644
++index 5fef72be9..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/migrations/release_1_7_x/mssql_index.php"
+++++ /dev/null
++@@ -1,87 +0,0 @@
++-<?php
++-/**
++- *
++- * Precise Similar Topics
++- *
++- * @copyright (c) 2025 Matt Friedman
++- * @license GNU General Public License, version 2 (GPL-2.0)
++- *
++- */
++-
++-namespace vse\similartopics\migrations\release_1_7_x;
++-
++-use vse\similartopics\driver\mssql;
++-
++-class mssql_index extends \phpbb\db\migration\migration
++-{
++-	/** @var mssql */
++-	protected $driver;
++-
++-	/**
++-	 * Do not run this migration if the DB is not MSSQL or MSSQL NATIVE
++-	 *
++-	 * @return bool
++-	 */
++-	public function effectively_installed()
++-	{
++-		if (strpos($this->db->get_sql_layer(), 'mssql') === false)
++-		{
++-			return true;
++-		}
++-		return $this->get_driver()->is_fulltext('topic_title', TOPICS_TABLE);
++-	}
++-
++-	public static function depends_on()
++-	{
++-		return ['\vse\similartopics\migrations\release_1_5_x\similar_topic_words'];
++-	}
++-
++-	public function update_data()
++-	{
++-		return [
++-			['if', [
++-				strpos($this->db->get_sql_layer(), 'mssql') === 0,
++-				['custom', [[$this, 'create_mssql_fulltext_index']]],
++-			]],
++-		];
++-	}
++-
++-	public function revert_data()
++-	{
++-		return [
++-			['if', [
++-				strpos($this->db->get_sql_layer(), 'mssql') === 0,
++-				['custom', [[$this, 'drop_mssql_fulltext_index']]],
++-			]],
++-		];
++-	}
++-
++-	/**
++-	 * Create a FULLTEXT index for the topic_title in the topic table
++-	 */
++-	public function create_mssql_fulltext_index()
++-	{
++-		$this->get_driver()->create_fulltext_index('topic_title', TOPICS_TABLE);
++-	}
++-
++-	/**
++-	 * Drop the FULLTEXT index we created from the topic table
++-	 */
++-	public function drop_mssql_fulltext_index()
++-	{
++-		$sql = 'DROP FULLTEXT INDEX ON ' . TOPICS_TABLE;
++-		$this->db->sql_query($sql);
++-	}
++-
++-	/**
++-	 * @return mssql
++-	 */
++-	protected function get_driver()
++-	{
++-		if ($this->driver === null)
++-		{
++-			$this->driver = new mssql($this->db);
++-		}
++-		return $this->driver;
++-	}
++-}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/migrations/release_1_7_x/oracle_index.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/migrations/release_1_7_x/oracle_index.php"
++deleted file mode 100644
++index feb5b7e7d..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/migrations/release_1_7_x/oracle_index.php"
+++++ /dev/null
++@@ -1,88 +0,0 @@
++-<?php
++-/**
++- *
++- * Precise Similar Topics
++- *
++- * @copyright (c) 2025 Matt Friedman
++- * @license GNU General Public License, version 2 (GPL-2.0)
++- *
++- */
++-
++-namespace vse\similartopics\migrations\release_1_7_x;
++-
++-use vse\similartopics\driver\oracle;
++-
++-class oracle_index extends \phpbb\db\migration\migration
++-{
++-	/** @var oracle */
++-	protected $driver;
++-
++-	/**
++-	 * Do not run this migration if the DB is not Oracle
++-	 *
++-	 * @return bool
++-	 */
++-	public function effectively_installed()
++-	{
++-		if (strpos($this->db->get_sql_layer(), 'oracle') !== 0)
++-		{
++-			return true;
++-		}
++-		return $this->get_driver()->is_fulltext('topic_title', TOPICS_TABLE);
++-	}
++-
++-	public static function depends_on()
++-	{
++-		return ['\vse\similartopics\migrations\release_1_5_x\similar_topic_words'];
++-	}
++-
++-	public function update_data()
++-	{
++-		return [
++-			['if', [
++-				strpos($this->db->get_sql_layer(), 'oracle') === 0,
++-				['custom', [[$this, 'create_oracle_fulltext_index']]],
++-			]],
++-		];
++-	}
++-
++-	public function revert_data()
++-	{
++-		return [
++-			['if', [
++-				strpos($this->db->get_sql_layer(), 'oracle') === 0,
++-				['custom', [[$this, 'drop_oracle_fulltext_index']]],
++-			]],
++-		];
++-	}
++-
++-	/**
++-	 * Create a FULLTEXT index for the topic_title in the topic table
++-	 */
++-	public function create_oracle_fulltext_index()
++-	{
++-		$this->get_driver()->create_fulltext_index('topic_title', TOPICS_TABLE);
++-	}
++-
++-	/**
++-	 * Drop the FULLTEXT index we created from the topic table
++-	 */
++-	public function drop_oracle_fulltext_index()
++-	{
++-		$index_name = TOPICS_TABLE . '_topic_title_ctx_idx';
++-		$sql = 'DROP INDEX ' . $this->db->sql_escape($index_name);
++-		$this->db->sql_query($sql);
++-	}
++-
++-	/**
++-	 * @return oracle
++-	 */
++-	protected function get_driver()
++-	{
++-		if ($this->driver === null)
++-		{
++-			$this->driver = new oracle($this->db);
++-		}
++-		return $this->driver;
++-	}
++-}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/migrations/release_1_7_x/sqlite3_index.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/migrations/release_1_7_x/sqlite3_index.php"
++deleted file mode 100644
++index 116effec5..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/migrations/release_1_7_x/sqlite3_index.php"
+++++ /dev/null
++@@ -1,87 +0,0 @@
++-<?php
++-/**
++- *
++- * Precise Similar Topics
++- *
++- * @copyright (c) 2025 Matt Friedman
++- * @license GNU General Public License, version 2 (GPL-2.0)
++- *
++- */
++-
++-namespace vse\similartopics\migrations\release_1_7_x;
++-
++-use vse\similartopics\driver\sqlite3;
++-
++-class sqlite3_index extends \phpbb\db\migration\migration
++-{
++-	/** @var sqlite3 */
++-	protected $driver;
++-
++-	/**
++-	 * Do not run this migration if the DB is not SQLITE3
++-	 *
++-	 * @return bool
++-	 */
++-	public function effectively_installed()
++-	{
++-		if ($this->db->get_sql_layer() !== 'sqlite3')
++-		{
++-			return true;
++-		}
++-		return $this->get_driver()->is_fulltext('topic_title', TOPICS_TABLE);
++-	}
++-
++-	public static function depends_on()
++-	{
++-		return ['\vse\similartopics\migrations\release_1_5_x\similar_topic_words'];
++-	}
++-
++-	public function update_data()
++-	{
++-		return [
++-			['if', [
++-				$this->db->get_sql_layer() === 'sqlite3',
++-				['custom', [[$this, 'create_sqlite3_index']]],
++-			]],
++-		];
++-	}
++-
++-	public function revert_data()
++-	{
++-		return [
++-			['if', [
++-				$this->db->get_sql_layer() === 'sqlite3',
++-				['custom', [[$this, 'drop_sqlite3_index']]],
++-			]],
++-		];
++-	}
++-
++-	/**
++-	 * Create a FULLTEXT index for the topic_title in the topic table
++-	 */
++-	public function create_sqlite3_index()
++-	{
++-		$this->get_driver()->create_fulltext_index('topic_title', TOPICS_TABLE);
++-	}
++-
++-	/**
++-	 * Drop the FULLTEXT index we created from the topic table
++-	 */
++-	public function drop_sqlite3_index()
++-	{
++-		$sql = 'DROP INDEX IF EXISTS idx_' . TOPICS_TABLE . '_topic_title';
++-		$this->db->sql_query($sql);
++-	}
++-
++-	/**
++-	 * @return sqlite3
++-	 */
++-	protected function get_driver()
++-	{
++-		if ($this->driver === null)
++-		{
++-			$this->driver = new sqlite3($this->db);
++-		}
++-		return $this->driver;
++-	}
++-}
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/styles/BBOOTS/template/event/ucp_prefs_view_radio_buttons_append.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/styles/BBOOTS/template/event/ucp_prefs_view_radio_buttons_append.html"
++new file mode 100644
++index 000000000..c9b59a2a3
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/styles/BBOOTS/template/event/ucp_prefs_view_radio_buttons_append.html"
++@@ -0,0 +1,9 @@
+++{% if S_SIMILAR_TOPICS %}
+++<div class="control-group">
+++	<label class="control-label" for="similar_topics1">{{ lang('DISPLAY_SIMILAR_TOPICS') ~ lang('COLON') }}</label>
+++	<div class="controls controls-row">
+++	 <div class="radio"><input type="radio" name="similar_topics" id="similar_topics1" value="1"{% if S_DISPLAY_SIMILAR_TOPICS %} checked="checked"{% endif %} /><label for="similar_topics1">{{ lang('YES') }}</label></div>
+++	 <div class="radio"><input type="radio" name="similar_topics" id="similar_topics0" value="0"{% if not S_DISPLAY_SIMILAR_TOPICS %} checked="checked"{% endif %} /><label for="similar_topics0">{{ lang('NO') }}</label></div>
+++    </div>
+++</div>
+++{% endif %}
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/styles/BBOOTS/template/event/viewtopic_body_footer_before.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/styles/BBOOTS/template/event/viewtopic_body_footer_before.html"
++new file mode 100644
++index 000000000..b20812f33
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/styles/BBOOTS/template/event/viewtopic_body_footer_before.html"
++@@ -0,0 +1,69 @@
+++{% if loops.similar|length %}
+++<div class="panel panel-default">
+++	<table class="footable table table-striped table-bordered table-white table-primary table-hover">
+++	<thead>
+++		<tr>
+++			<th data-class="expand">{{ lang('SIMILAR_TOPICS') }}</th>
+++			<th class="large110" data-hide="phone">{{ lang('TOPICS_POSTS_STATISTICS') }}</th>
+++			<th class="large21" data-hide="phone">{{ lang('LAST_POST') }}</th>
+++		</tr>
+++	</thead>
+++	 <tbody>
+++	{% for similar in loops.similar %}
+++		{% EVENT search_results_topic_before %}
+++		<tr>
+++			<td>
+++				{% if similar.TOPIC_ICON_IMG %}
+++				 <i class="topic-icon" style="background-image: url({{ T_ICONS_PATH ~ similar.TOPIC_ICON_IMG }}); background-repeat: no-repeat;" title="{{ similar.TOPIC_FOLDER_IMG_ALT }}"></i>
+++				{% endif %}
+++				<span class="icon-wrapper">
+++			     <i class="row-icon-font icon-moon-default2{% if similar.S_POST_ANNOUNCE %} icon-moon-voice2{% endif %}{% if similar.S_POST_GLOBAL %} icon-moon-podcast2{% endif %}{% if similar.S_POST_STICKY %} icon-moon-pushpin2{% endif %}{% if similar.S_HAS_POLL %} icon-moon-poll{% endif %}{% if similar.S_UNREAD_TOPIC %} forum-unread{% else %} forum-read{% endif %}" title="{{ similar.TOPIC_FOLDER_IMG_ALT }}"></i>
+++				</span>
+++				<i class="row-icon-font-mini{% if similar.S_TOPIC_LOCKED %} fa fa-lock forumview-lock{% endif %}" title="{{ similar.TOPIC_FOLDER_IMG_ALT }}"></i>
+++				<span class="desc-wrapper">
+++				{% EVENT topiclist_row_prepend %}
+++				{% if similar.S_UNREAD_TOPIC and not S_IS_BOT %}<a href="{{ similar.U_NEWEST_POST }}" title="{{ lang('VIEW_FIRST_UNREAD') }}"><i class="fa fa-asterisk"></i></a>{% endif %}{% EVENT topiclist_row_topic_title_before %}<a href="{{ similar.U_VIEW_TOPIC }}" class="topictitle">{{ similar.TOPIC_TITLE }}</a>
+++				{% if similar.ATTACH_ICON_IMG %}<i class="fa fa-paperclip fa-flip-horizontal" title="{{ lang('ATTACH_FORUM') }}"></i>{% endif %}
+++			    {% if similar.S_TOPIC_UNAPPROVED or similar.S_POSTS_UNAPPROVED %}<a href="{{ similar.U_MCP_QUEUE }}">{{ similar.UNAPPROVED_IMG }}</a> {% endif %}
+++			    {% if similar.S_TOPIC_REPORTED %}<a href="{{ similar.U_MCP_REPORT }}">{{ REPORTED_IMG }}</a>{% endif %}<br />
+++				{% EVENT topiclist_row_topic_title_after %}
+++			    {% if similar.pagination|length %}
+++				    <ul class="pagination pagination-forum pagination-xs pull-right hidden-sm hidden-xs">
+++						{% for pagination in similar.pagination %}
+++						 {% if pagination.S_IS_PREV %}
+++						 {% elseif pagination.S_IS_CURRENT %}<li class="active">{{ pagination.PAGE_NUMBER }}</li>
+++						 {% elseif pagination.S_IS_ELLIPSIS %}<li class="ellipsis"><a>{{ lang('ELLIPSIS') }}</a></li>
+++						 {% elseif pagination.S_IS_NEXT %}
+++						{% else %}
+++						 <li><a href="{similar.pagination.PAGE_URL}">{{ pagination.PAGE_NUMBER }}</a></li>
+++						{% endif %}
+++						{% endfor %}
+++					</ul>		
+++			    {% endif %}
+++				{% EVENT topiclist_row_topic_by_author_before %}
+++				{{ lang('POST_BY_AUTHOR') }}&nbsp;{% EVENT search_results_topic_author_username_prepend %}{{ similar.TOPIC_AUTHOR_FULL }}{% EVENT search_results_topic_author_username_append %}&nbsp;
+++				<small>&#45;&nbsp;<time datetime="{{ similar.FIRST_POST_TIME_RFC3339 }}">{{ similar.FIRST_POST_TIME }}</time></small>
+++				{{ lang('IN') ~ lang('COLON') }}&nbsp;<a href="{{ similar.U_VIEW_FORUM }}">{{ similar.FORUM_TITLE }}</a>
+++				{% EVENT topiclist_row_topic_by_author_after %}
+++				{% EVENT topiclist_row_append %}
+++				</span>
+++			</td>
+++			<td class="stats-col">
+++			 <span class="stats-wrapper">
+++			 {{ similar.TOPIC_REPLIES }}&nbsp;{{ lang('REPLIES') }}<br />{{ similar.TOPIC_VIEWS }}&nbsp;{{ lang('VIEWS') }}
+++			 </span>
+++			</td>
+++			<td class="center">
+++			 <span class="last-wrapper">
+++				{{ lang('POST_BY_AUTHOR') }}&nbsp;{% EVENT search_results_last_post_author_username_prepend %}{{ similar.LAST_POST_AUTHOR_FULL }}{% EVENT search_results_last_post_author_username_append %}
+++				{% if not S_IS_BOT %}<a title="{{ lang('FORUMLIST_LASTPOST') }}" href="{{ similar.U_LAST_POST }}"><i class="mobile-post fa fa-sign-out"></i></a>{% endif %}
+++				<br /><small><time datetime="{{ similar.LAST_POST_TIME_RFC3339 }}">{{ similar.LAST_POST_TIME }}</time></small>
+++			 </span>
+++			</td>
+++	    </tr>
+++		{% EVENT search_results_topic_after %}
+++	  {% endfor %}
+++	 </tbody>
+++	</table>
+++</div>
+++{% endif %}
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/styles/FLATBOOTS/template/event/ucp_prefs_view_radio_buttons_append.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/styles/FLATBOOTS/template/event/ucp_prefs_view_radio_buttons_append.html"
++new file mode 100644
++index 000000000..c9b59a2a3
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/styles/FLATBOOTS/template/event/ucp_prefs_view_radio_buttons_append.html"
++@@ -0,0 +1,9 @@
+++{% if S_SIMILAR_TOPICS %}
+++<div class="control-group">
+++	<label class="control-label" for="similar_topics1">{{ lang('DISPLAY_SIMILAR_TOPICS') ~ lang('COLON') }}</label>
+++	<div class="controls controls-row">
+++	 <div class="radio"><input type="radio" name="similar_topics" id="similar_topics1" value="1"{% if S_DISPLAY_SIMILAR_TOPICS %} checked="checked"{% endif %} /><label for="similar_topics1">{{ lang('YES') }}</label></div>
+++	 <div class="radio"><input type="radio" name="similar_topics" id="similar_topics0" value="0"{% if not S_DISPLAY_SIMILAR_TOPICS %} checked="checked"{% endif %} /><label for="similar_topics0">{{ lang('NO') }}</label></div>
+++    </div>
+++</div>
+++{% endif %}
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/styles/FLATBOOTS/template/event/viewtopic_body_footer_before.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/styles/FLATBOOTS/template/event/viewtopic_body_footer_before.html"
++new file mode 100644
++index 000000000..e18f8526c
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/styles/FLATBOOTS/template/event/viewtopic_body_footer_before.html"
++@@ -0,0 +1,76 @@
+++	{% if loops.similar|length %}
+++	<div class="panel panel-forum">
+++	<div class="panel-heading">
+++	 {{ lang('SIMILAR_TOPICS') }}
+++	</div>
+++	<div class="panel-inner">
+++	<table class="footable table table-striped table-primary table-hover">
+++	<thead>
+++		<tr>
+++			<th data-class="expand">{{ lang('TOPICS') }}</th>
+++			<th class="large110" data-hide="phone">{{ lang('TOPICS_POSTS_STATISTICS') }}</th>
+++			<th class="large21" data-hide="phone">{{ lang('LAST_POST') }}</th>
+++			{% EVENT search_results_topic_header_lastpost_after %}
+++		</tr>
+++	</thead>
+++	<tbody>
+++		{% for similar in loops.similar %}
+++		{% EVENT search_results_topic_before %}
+++		<tr>
+++			<td>
+++				{% if similar.TOPIC_ICON_IMG %}
+++				<i class="topic-icon" style="background-image: url({% if not S_BBEMOJI %}{{ T_ICONS_PATH }}{% endif %}{{ similar.TOPIC_ICON_IMG }}); background-repeat: no-repeat;" title="{{ similar.TOPIC_FOLDER_IMG_ALT }}"></i>
+++				{% endif %}
+++				<span class="icon-wrapper">
+++			    <i class="row-icon-font icon-moon-default2{% if similar.S_POST_ANNOUNCE %} icon-moon-voice2{% endif %}{% if similar.S_POST_GLOBAL %} icon-moon-podcast2{% endif %}{% if similar.S_POST_STICKY %} icon-moon-pushpin2{% endif %}{% if similar.S_HAS_POLL %} icon-moon-poll{% endif %}{% if similar.S_UNREAD_TOPIC %} forum-unread{% else %} forum-read{% endif %}" title="{{ similar.TOPIC_FOLDER_IMG_ALT }}"></i>
+++				</span>
+++				<i class="row-icon-font-mini{% if similar.S_TOPIC_LOCKED %} icon-moon-lock forumview-lock{% endif %}" title="{{ similar.TOPIC_FOLDER_IMG_ALT }}"></i>
+++				<div class="desc-wrapper">
+++				{% EVENT topiclist_row_prepend %}
+++				{% if similar.S_UNREAD_TOPIC and not S_IS_BOT %}<a href="{{ similar.U_NEWEST_POST }}" title="{{ lang('VIEW_FIRST_UNREAD') }}"><i class="topic-newest fa fa-asterisk"></i></a>{% endif %}{% EVENT topiclist_row_topic_title_before %}<a href="{{ similar.U_VIEW_TOPIC }}" class="topictitle">{{ similar.TOPIC_TITLE }}</a>
+++				{% if similar.S_TOPIC_UNAPPROVED or similar.S_POSTS_UNAPPROVED %}<a href="{{ similar.U_MCP_QUEUE }}" title="{{ lang('TOPICS_ROW_NOT_APPROVED') }}">&nbsp;<i class="fa fa-question-circle"></i></a>{% endif %}
+++				{% if similar.S_TOPIC_REPORTED %}<a href="{{ similar.U_MCP_REPORT }}" title="{{ lang('TOPICS_ROW_REPORTED') }}">&nbsp;<i class="fa fa-exclamation-circle text-danger"></i></a>{% endif %}
+++				{% if similar.pagination|length %}
+++					<ul class="pagination pagination-forum pagination-xs pull-right hidden-sm hidden-xs">
+++						{% for pagination in similar.pagination %}
+++						 {% if pagination.S_IS_PREV %}
+++						 {% elseif pagination.S_IS_CURRENT %}<li class="active">{{ pagination.PAGE_NUMBER }}</li>
+++						 {% elseif pagination.S_IS_ELLIPSIS %}<li class="ellipsis"><a>{{ lang('ELLIPSIS') }}</a></li>
+++						 {% elseif pagination.S_IS_NEXT %}
+++						 {% else %}
+++						 <li><a href="{{ pagination.PAGE_URL }}">{{ pagination.PAGE_NUMBER }}</a></li>
+++						 {% endif %}
+++						{% endfor %}
+++					</ul>		
+++				{% endif %}
+++				{% EVENT topiclist_row_topic_title_after %}
+++				<br />
+++				{% if similar.ATTACH_ICON_IMG %}<i class="fa fa-paperclip fa-flip-horizontal" title="{{ lang('ATTACH_FORUM') }}"></i>{% endif %}
+++				{% EVENT topiclist_row_topic_by_author_before %}
+++				{{ lang('POST_BY_AUTHOR') }}&nbsp;{% EVENT search_results_topic_author_username_prepend %}{{ similar.TOPIC_AUTHOR_FULL }}{% EVENT search_results_topic_author_username_append %}&nbsp;
+++				<small>&#45;&nbsp;<time datetime="{{ similar.FIRST_POST_TIME_RFC3339 }}">{{ similar.FIRST_POST_TIME }}</time>&nbsp;&nbsp;&#45;&nbsp;{{ lang('IN') ~ lang('COLON') }}&nbsp;<a href="{{ similar.U_VIEW_FORUM }}">{{ similar.FORUM_TITLE }}</a></small>
+++				{% EVENT topiclist_row_topic_by_author_after %}
+++				{% EVENT topiclist_row_append %}
+++				</div>
+++			</td>
+++			<td class="stats-col">
+++			 <span class="stats-wrapper">
+++			 {{ similar.TOPIC_REPLIES }}&nbsp;{{ lang('REPLIES') }}&nbsp;<br />{{ similar.TOPIC_VIEWS }}&nbsp;{{ lang('VIEWS') }}
+++			 </span>
+++			</td>
+++			<td> 
+++			 <span class="last-wrapper text-overflow">
+++				{{ lang('POST_BY_AUTHOR') }}&nbsp;{% EVENT search_results_last_post_author_username_prepend %}{{ similar.LAST_POST_AUTHOR_FULL }}{% EVENT search_results_last_post_author_username_append %}
+++				{% if not S_IS_BOT %}<a title="{{ lang('FORUMLIST_LASTPOST') }}" href="{{ similar.U_LAST_POST }}"><i class="mobile-post fa fa-sign-out"></i></a>{% endif %}
+++				<br /><small><time datetime="{{ similar.LAST_POST_TIME_RFC3339 }}">{{ similar.LAST_POST_TIME }}</time></small>
+++			 </span>
+++			</td>
+++			{% EVENT search_results_topic_row_lastpost_after %}
+++		</tr>
+++		{% EVENT search_results_topic_after %}
+++	{% endfor %}
+++	</tbody>
+++	</table>
+++	</div>
+++	</div>
+++	{% endif %}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/styles/all/template/event/overall_footer_after.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/styles/all/template/event/overall_footer_after.html"
++deleted file mode 100644
++index 27399ab50..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/styles/all/template/event/overall_footer_after.html"
+++++ /dev/null
++@@ -1,144 +0,0 @@
++-{% if S_DYNAMIC_SIMILAR_TOPICS and S_IN_POSTING and not S_EDIT_POST %}
++-{% INCLUDECSS '@vse_similartopics/similar_topics_ajax.css' %}
++-<script>
++-// Dynamic Similar Topics - Real-time search as user types in the subject field
++-(function() {
++-	// State variables: debounce timer, keyboard selection index, cached DOM elements
++-	let searchTimeout, selectedIndex = -1, cachedItems = [];
++-	const dropdown = document.getElementById('similar-topics-dropdown');
++-	const subjectField = document.getElementById('subject');
++-	const listContainer = document.getElementById('similar-topics-list');
++-
++-	if (!subjectField || !dropdown) return;
++-
++-	// Disable browser autocomplete to prevent interference with our dropdown
++-	subjectField.setAttribute('autocomplete', 'off');
++-
++-	// Hide dropdown and reset selection state
++-	function hideDropdown() {
++-		dropdown.style.display = 'none';
++-		selectedIndex = -1;
++-		cachedItems = [];
++-	}
++-
++-	// Position dropdown below the subject field and show it
++-	function showDropdown() {
++-		const rect = subjectField.getBoundingClientRect();
++-		const isRTL = document.documentElement.dir === 'rtl' || document.body.classList.contains('rtl');
++-		
++-		Object.assign(dropdown.style, {
++-			left: isRTL ? 'auto' : rect.left + 'px',
++-			right: 'auto',
++-			top: (rect.bottom + window.scrollY) + 'px',
++-			width: rect.width + 'px',
++-			display: 'block'
++-		});
++-	}
++-
++-	// AJAX search for similar topics (minimum 3 characters)
++-	function searchSimilarTopics(query) {
++-		if (query.length < 3) {
++-			hideDropdown();
++-			return;
++-		}
++-
++-		const xhr = new XMLHttpRequest();
++-		const baseUrl = '{{ U_PST_AJAX_SEARCH|e('js') }}';
++-		const separator = baseUrl.includes('?') ? '&' : '?';
++-		xhr.open('GET', baseUrl + separator + 'q=' + encodeURIComponent(query) + '&f={{ FORUM_ID|e('js') }}');
++-		xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
++-
++-		xhr.onreadystatechange = () => {
++-			if (xhr.readyState === 4 && xhr.status === 200) {
++-				try {
++-					const response = JSON.parse(xhr.responseText);
++-					displayResults(response.topics);
++-				} catch (e) {
++-					hideDropdown();
++-				}
++-			}
++-		};
++-
++-		xhr.send();
++-	}
++-
++-	// Build and display topic results in a dropdown
++-	function displayResults(topics) {
++-		if (!topics || topics.length === 0) return hideDropdown();
++-
++-		listContainer.innerHTML = '';
++-		topics.forEach(topic => {
++-			const item = document.createElement('div');
++-			item.className = 'similar-topic-item';
++-			const link = document.createElement('a');
++-			link.href = topic.url;
++-			link.className = 'similar-topic-title';
++-			link.textContent = topic.title;
++-			link.target = '_blank';
++-			item.appendChild(link);
++-			listContainer.appendChild(item);
++-		});
++-
++-		// Cache items for keyboard navigation performance
++-		cachedItems = listContainer.children;
++-		selectedIndex = -1;
++-		showDropdown();
++-	}
++-
++-	// Update visual selection highlighting for keyboard navigation
++-	function updateSelection() {
++-		for (let i = 0; i < cachedItems.length; i++) {
++-			cachedItems[i].classList.toggle('selected', i === selectedIndex);
++-		}
++-	}
++-
++-	// Open currently selected topic in new tab
++-	function openSelectedTopic() {
++-		if (selectedIndex >= 0 && selectedIndex < cachedItems.length) {
++-			window.open(cachedItems[selectedIndex].querySelector('a').href, '_blank');
++-			hideDropdown();
++-		}
++-	}
++-
++-	// Debounced search on input (300 ms delay)
++-	subjectField.addEventListener('input', () => {
++-		clearTimeout(searchTimeout);
++-		const query = subjectField.value.trim();
++-
++-		searchTimeout = setTimeout(() => {
++-			searchSimilarTopics(query);
++-		}, 300);
++-	});
++-
++-	// Keyboard navigation: Arrow keys to select, Enter to open
++-	subjectField.addEventListener('keydown', (e) => {
++-		if (dropdown.style.display === 'none' || !cachedItems.length) return;
++-
++-		const { key, shiftKey, ctrlKey, altKey, metaKey } = e;
++-		if ((key === 'ArrowDown' || key === 'ArrowUp') && !shiftKey && !ctrlKey && !altKey && !metaKey) {
++-			e.preventDefault();
++-			// Cycle through items (wraps around at ends)
++-			selectedIndex = key === 'ArrowDown'
++-				? (selectedIndex < cachedItems.length - 1 ? selectedIndex + 1 : 0)
++-				: (selectedIndex > 0 ? selectedIndex - 1 : cachedItems.length - 1);
++-			updateSelection();
++-		} else if (key === 'Enter' && selectedIndex >= 0) {
++-			e.preventDefault();
++-			openSelectedTopic();
++-		}
++-	});
++-
++-	// Hide dropdown when the field loses focus (delayed to allow clicks)
++-	subjectField.addEventListener('blur', () => {
++-		setTimeout(hideDropdown, 200);
++-	});
++-
++-	// Hide dropdown when clicking outside
++-	document.addEventListener('click', (e) => {
++-		if (!dropdown.contains(e.target) && e.target !== subjectField) {
++-			hideDropdown();
++-		}
++-	});
++-})();
++-</script>
++-{% endif %}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/styles/all/template/event/posting_editor_subject_append.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/styles/all/template/event/posting_editor_subject_append.html"
++deleted file mode 100644
++index 018f16d8b..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/styles/all/template/event/posting_editor_subject_append.html"
+++++ /dev/null
++@@ -1,6 +0,0 @@
++-{% if S_DYNAMIC_SIMILAR_TOPICS and S_IN_POSTING and not S_EDIT_POST %}
++-<div id="similar-topics-dropdown" class="similar-topics-dropdown" style="display: none;">
++-	<div class="similar-topics-header">{{ lang('SIMILAR_TOPICS') }}</div>
++-	<div id="similar-topics-list" class="similar-topics-list"></div>
++-</div>
++-{% endif %}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/styles/all/theme/similar_topics_ajax.css" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/styles/all/theme/similar_topics_ajax.css"
++deleted file mode 100644
++index 453119728..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/styles/all/theme/similar_topics_ajax.css"
+++++ /dev/null
++@@ -1,51 +0,0 @@
++-.similar-topics-dropdown {
++-	background: #ffffff;
++-	border: 1px solid #cccccc;
++-	border-radius: 3px;
++-	box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
++-	position: absolute;
++-	z-index: 1000;
++-	min-width: 300px;
++-	max-width: 400px;
++-}
++-
++-.similar-topics-header {
++-	font-size: 11px;
++-	font-weight: bold;
++-	text-transform: uppercase;
++-	background: #f5f5f5;
++-	border-bottom: 1px solid #dddddd;
++-	padding: 8px 12px;
++-}
++-
++-.similar-topics-list {
++-	overflow-y: auto;
++-	max-height: 200px;
++-}
++-
++-.similar-topic-item {
++-	border-bottom: 1px solid #eeeeee;
++-	padding: 8px 12px;
++-	cursor: pointer;
++-	transition: background-color 0.2s;
++-}
++-
++-.similar-topic-item:hover,
++-.similar-topic-item.selected {
++-	background: #f0f0f0;
++-}
++-
++-.similar-topic-item:last-child {
++-	border-bottom: none;
++-}
++-
++-.similar-topic-title {
++-	font-size: 12px;
++-	line-height: 1.3;
++-	text-decoration: none;
++-	color: #105289;
++-}
++-
++-.similar-topic-title:hover {
++-	text-decoration: underline;
++-}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/styles/bb3-mobi/template/event/viewtopic_body_footer_before.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/styles/bb3-mobi/template/event/viewtopic_body_footer_before.html"
++index 2b32e57f5..779cd71d8 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/styles/bb3-mobi/template/event/viewtopic_body_footer_before.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/styles/bb3-mobi/template/event/viewtopic_body_footer_before.html"
++@@ -14,7 +14,7 @@
++ 	<a href="{{ similar.U_MCP_QUEUE }}" class="rightside"><img src="{{ T_THEME_PATH }}/images/icon_topic_unapproved.gif" alt=""/></a>{% endif %}
++ 	{% if similar.S_TOPIC_REPORTED %}
++ 	<a href="{{ similar.U_MCP_REPORT }}" class="rightside"><img src="{{ T_THEME_PATH }}/images/icon_topic_reported.gif" alt=""/></a>{% endif %}
++-	<a href="{{ similar.U_VIEW_TOPIC }}" class="topictitle">{{ similar.TOPIC_TITLE }}</a> <span class="posts">[{% if similar.TOPIC_REPLIES %}{{ similar.TOPIC_REPLIES }}{% else %}1{% endif %}]</span>
+++	<a href="{{ similar.U_VIEW_TOPIC }}" class="topictitle">{{ similar.TOPIC_TITLE }}</a> <span class="posts">[{% if similar.REPLIES %}{{ similar.REPLIES }}{% else %}1{% endif %}]</span>
++ 	{% if not S_IS_BOT %}
++ 	<br />{{ similar.LAST_POST_AUTHOR_FULL }} &laquo; <a href="{{ similar.U_LAST_POST }}" title="{{ lang('GOTO_LAST_POST') }}">{{ similar.LAST_POST_TIME }}</a>
++ 	{% endif %}
++@@ -25,7 +25,7 @@
++ 			{% elseif pagination.S_IS_CURRENT %}<span class="active button">{{ pagination.PAGE_NUMBER }}</span>
++ 			{% elseif pagination.S_IS_ELLIPSIS %}<span class="ellipsis button">{{ lang('ELLIPSIS') }}</span>
++ 			{% elseif pagination.S_IS_NEXT %}
++-			{% else %}<a href="{{ pagination.PAGE_URL }}" class="button">{{ pagination.PAGE_NUMBER }}</a>
+++			{% else %}<a href="{{ pagination.PAGE_URL }}" class="button">{{ pagination.PAGE_NUMBER }}</a> 
++ 			{% endif %}
++ 		{% endfor %}
++ 	</div>
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/styles/prosilver/template/event/ucp_prefs_view_radio_buttons_append.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/styles/prosilver/template/event/ucp_prefs_view_radio_buttons_append.html"
++index 4267781ab..4b0075748 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\similartopics/styles/prosilver/template/event/ucp_prefs_view_radio_buttons_append.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\similartopics/styles/prosilver/template/event/ucp_prefs_view_radio_buttons_append.html"
++@@ -2,8 +2,8 @@
++ 	<dl>
++ 		<dt><label for="similar_topics1">{{ lang('DISPLAY_SIMILAR_TOPICS') ~ lang('COLON') }}</label></dt>
++ 		<dd>
++-			<label for="similar_topics1"><input type="radio" name="similar_topics" id="similar_topics1" value="1"{% if S_DISPLAY_SIMILAR_TOPICS %} checked="checked"{% endif %}> {{ lang('YES') }}</label>
++-			<label for="similar_topics0"><input type="radio" name="similar_topics" id="similar_topics0" value="0"{% if not S_DISPLAY_SIMILAR_TOPICS %} chec
\ No newline at end of file
diff --git "[ORIGINAL]/vse\\similartopics/driver/driver_interface.php" "[FORUM_EXT]/vse\\similartopics/driver/driver_interface.php"
--- "[ORIGINAL]/vse\\similartopics/driver/driver_interface.php"
+++ "[FORUM_EXT]/vse\\similartopics/driver/driver_interface.php"
@@ -82,12 +82,4 @@ interface driver_interface
 	 * @return string The storage engine name
 	 */
 	public function get_engine();
-
-	/**
-	 * Check if the database has built-in stop-word support
-	 *
-	 * @access public
-	 * @return bool True if has stop-word support, false otherwise
-	 */
-	public function has_stopword_support();
 }
diff --git "[ORIGINAL]/vse\\similartopics/driver/mssql.php" "[ORIGINAL]/vse\\similartopics/driver/mssql.php"
deleted file mode 100644
--- "[ORIGINAL]/vse\\similartopics/driver/mssql.php"
+++ /dev/null
@@ -1,199 +0,0 @@
-<?php
-/**
- *
- * Precise Similar Topics
- *
- * @copyright (c) 2025 Matt Friedman
- * @license GNU General Public License, version 2 (GPL-2.0)
- *
- */
-
-namespace vse\similartopics\driver;
-
-/**
- * This class handles similar topics queries for MSSQL dbms
- */
-class mssql implements driver_interface
-{
-	/** @var \phpbb\db\driver\driver_interface */
-	protected $db;
-
-	/**
-	 * Constructor
-	 *
-	 * @param \phpbb\db\driver\driver_interface $db
-	 */
-	public function __construct(\phpbb\db\driver\driver_interface $db)
-	{
-		$this->db = $db;
-	}
-
-	/**
-	 * {@inheritdoc}
-	 */
-	public function get_name()
-	{
-		return 'mssql';
-	}
-
-	/**
-	 * {@inheritdoc}
-	 */
-	public function get_type()
-	{
-		return 'mssql';
-	}
-
-	/**
-	 * {@inheritdoc}
-	 */
-	public function get_query($topic_id, $topic_title, $length, $sensitivity)
-	{
-		if ($this->is_fulltext('topic_title', TOPICS_TABLE))
-		{
-			$search_condition = "CONTAINS(t.topic_title, '" . $this->db->sql_escape(str_replace(' ', ' AND ', $topic_title)) . "')";
-		}
-		else
-		{
-			$like_conditions = array();
-			foreach (explode(' ', $topic_title) as $word)
-			{
-				$word = trim($word);
-				if (utf8_strlen($word) > 2)
-				{
-					$like_conditions[] = "t.topic_title LIKE '%" . $this->db->sql_escape($word) . "%'";
-				}
-			}
-			$search_condition = !empty($like_conditions)
-				? '(' . implode(' OR ', $like_conditions) . ')'
-				: "t.topic_title LIKE '%" . $this->db->sql_escape($topic_title) . "%'";
-		}
-
-		return array(
-			'SELECT'	=> "f.forum_id, f.forum_name, t.*,
-				CASE WHEN " . $search_condition . " THEN 1.0 ELSE 0.0 END AS score",
-			'FROM'		=> array(
-				TOPICS_TABLE => 't'
-			),
-			'LEFT_JOIN'	=> array(
-				array(
-					'FROM' => array(FORUMS_TABLE => 'f'),
-					'ON' => 'f.forum_id = t.forum_id'
-				)
-			),
-			'WHERE'		=> $search_condition . "
-				AND t.topic_status <> " . ITEM_MOVED . "
-				AND t.topic_visibility = " . ITEM_APPROVED . "
-				AND t.topic_time > (DATEDIFF(second, '1970-01-01', GETDATE()) - " . (int) $length . ")
-				AND t.topic_id <> " . (int) $topic_id,
-			'ORDER_BY'	=> 'score DESC, t.topic_time DESC',
-		);
-	}
-
-	/**
-	 * {@inheritdoc}
-	 */
-	public function is_supported()
-	{
-		return (strpos($this->db->get_sql_layer(), 'mssql') === 0);
-	}
-
-	/**
-	 * {@inheritdoc}
-	 */
-	public function is_fulltext($column = 'topic_title', $table = TOPICS_TABLE)
-	{
-		return in_array($column, $this->get_fulltext_indexes($column, $table), true);
-	}
-
-	/**
-	 * {@inheritdoc}
-	 */
-	public function get_fulltext_indexes($column = 'topic_title', $table = TOPICS_TABLE)
-	{
-		$indexes = array();
-
-		if (!$this->is_supported())
-		{
-			return $indexes;
-		}
-
-		try
-		{
-			$sql = "SELECT i.name
-				FROM sys.fulltext_indexes fi
-				INNER JOIN sys.indexes i ON fi.object_id = i.object_id AND fi.unique_index_id = i.index_id
-				INNER JOIN sys.objects o ON fi.object_id = o.object_id
-				WHERE o.name = '" . $this->db->sql_escape($table) . "'";
-			$result = $this->db->sql_query($sql);
-
-			while ($row = $this->db->sql_fetchrow($result))
-			{
-				$indexes[] = $row['name'];
-			}
-
-			$this->db->sql_freeresult($result);
-		}
-		catch (\Exception $e)
-		{
-			// Full-text search not available
-		}
-
-		return $indexes;
-	}
-
-	/**
-	 * {@inheritdoc}
-	 */
-	public function create_fulltext_index($column = 'topic_title', $table = TOPICS_TABLE)
-	{
-		if (!$this->is_supported() || !$this->fulltext_available() || $this->is_fulltext($column, $table))
-		{
-			return;
-		}
-
-		// Create fulltext catalog if it doesn't exist
-		$sql = "IF NOT EXISTS (SELECT * FROM sys.fulltext_catalogs WHERE name = 'phpbb_catalog')
-			CREATE FULLTEXT CATALOG phpbb_catalog";
-		$this->db->sql_query($sql);
-
-		// Create fulltext index
-		$sql = "CREATE FULLTEXT INDEX ON " . $this->db->sql_escape($table) . "
-			(" . $this->db->sql_escape($column) . ")
-			KEY INDEX PK_" . $this->db->sql_escape($table) . "
-			ON phpbb_catalog";
-		$this->db->sql_query($sql);
-	}
-
-	/**
-	 * {@inheritdoc}
-	 */
-	public function get_engine()
-	{
-		return '';
-	}
-
-	/**
-	 * {@inheritdoc}
-	 */
-	public function has_stopword_support()
-	{
-		return false;
-	}
-
-	protected function fulltext_available()
-	{
-		try
-		{
-			$sql = "SELECT SERVERPROPERTY('IsFullTextInstalled') AS IsFullTextInstalled";
-			$result = $this->db->sql_query($sql);
-			$row = $this->db->sql_fetchrow($result);
-			$this->db->sql_freeresult($result);
-			return (bool) $row['IsFullTextInstalled'];
-		}
-		catch (\Exception $e)
-		{
-			return false;
-		}
-	}
-}
diff --git "[ORIGINAL]/vse\\similartopics/driver/mssql_odbc.php" "[ORIGINAL]/vse\\similartopics/driver/mssql_odbc.php"
deleted file mode 100644
--- "[ORIGINAL]/vse\\similartopics/driver/mssql_odbc.php"
+++ /dev/null
@@ -1,25 +0,0 @@
-<?php
-/**
- *
- * Precise Similar Topics
- *
- * @copyright (c) 2025 Matt Friedman
- * @license GNU General Public License, version 2 (GPL-2.0)
- *
- */
-
-namespace vse\similartopics\driver;
-
-/**
- * This class handles similar topics queries for MSSQL ODBC dbms
- */
-class mssql_odbc extends mssql
-{
-	/**
-	 * {@inheritdoc}
-	 */
-	public function get_name()
-	{
-		return 'mssql_odbc';
-	}
-}
diff --git "[ORIGINAL]/vse\\similartopics/driver/mssqlnative.php" "[ORIGINAL]/vse\\similartopics/driver/mssqlnative.php"
deleted file mode 100644
--- "[ORIGINAL]/vse\\similartopics/driver/mssqlnative.php"
+++ /dev/null
@@ -1,25 +0,0 @@
-<?php
-/**
- *
- * Precise Similar Topics
- *
- * @copyright (c) 2025 Matt Friedman
- * @license GNU General Public License, version 2 (GPL-2.0)
- *
- */
-
-namespace vse\similartopics\driver;
-
-/**
- * This class handles similar topics queries for MSSQL Native dbms
- */
-class mssqlnative extends mssql
-{
-	/**
-	 * {@inheritdoc}
-	 */
-	public function get_name()
-	{
-		return 'mssqlnative';
-	}
-}
diff --git "[ORIGINAL]/vse\\similartopics/driver/mysqli.php" "[FORUM_EXT]/vse\\similartopics/driver/mysqli.php"
--- "[ORIGINAL]/vse\\similartopics/driver/mysqli.php"
+++ "[FORUM_EXT]/vse\\similartopics/driver/mysqli.php"
@@ -202,15 +202,7 @@ class mysqli implements driver_interface
 	 */
 	protected function is_mysql()
 	{
-		return strpos($this->db->get_sql_layer(), 'mysql') === 0;
-	}
-
-	/**
-	 * {@inheritdoc}
-	 */
-	public function has_stopword_support()
-	{
-		return true;
+		return ($this->db->get_sql_layer() === 'mysql4' || $this->db->get_sql_layer() === 'mysqli');
 	}
 
 	/**
diff --git "[ORIGINAL]/vse\\similartopics/driver/oracle.php" "[ORIGINAL]/vse\\similartopics/driver/oracle.php"
deleted file mode 100644
--- "[ORIGINAL]/vse\\similartopics/driver/oracle.php"
+++ /dev/null
@@ -1,200 +0,0 @@
-<?php
-/**
- *
- * Precise Similar Topics
- *
- * @copyright (c) 2025 Matt Friedman
- * @license GNU General Public License, version 2 (GPL-2.0)
- *
- */
-
-namespace vse\similartopics\driver;
-
-/**
- * This class handles similar topics queries for Oracle dbms
- */
-class oracle implements driver_interface
-{
-	/** @var \phpbb\db\driver\driver_interface */
-	protected $db;
-
-	/**
-	 * Constructor
-	 *
-	 * @param \phpbb\db\driver\driver_interface $db
-	 */
-	public function __construct(\phpbb\db\driver\driver_interface $db)
-	{
-		$this->db = $db;
-	}
-
-	/**
-	 * {@inheritdoc}
-	 */
-	public function get_name()
-	{
-		return 'oracle';
-	}
-
-	/**
-	 * {@inheritdoc}
-	 */
-	public function get_type()
-	{
-		return 'oracle';
-	}
-
-	/**
-	 * {@inheritdoc}
-	 */
-	public function get_query($topic_id, $topic_title, $length, $sensitivity)
-	{
-		// Clean and prepare the search terms for Oracle Text
-		$search_terms = $this->prepare_search_terms($topic_title);
-
-		return array(
-			'SELECT'	=> "f.forum_id, f.forum_name, t.*,
-				SCORE(1) AS score",
-
-			'FROM'		=> array(
-				TOPICS_TABLE	=> 't',
-			),
-			'LEFT_JOIN'	=> array(
-				array(
-					'FROM'	=>	array(FORUMS_TABLE	=> 'f'),
-					'ON'	=> 'f.forum_id = t.forum_id',
-				),
-			),
-			'WHERE'		=> "CONTAINS(t.topic_title, '" . $this->db->sql_escape($search_terms) . "', 1) > 0
-				AND SCORE(1) >= " . (float) $sensitivity . '
-				AND t.topic_status <> ' . ITEM_MOVED . '
-				AND t.topic_visibility = ' . ITEM_APPROVED . '
-				AND t.topic_time > (EXTRACT(EPOCH FROM SYSTIMESTAMP) - ' . (int) $length . ')
-				AND t.topic_id <> ' . (int) $topic_id,
-		);
-	}
-
-	/**
-	 * {@inheritdoc}
-	 */
-	public function is_supported()
-	{
-		return $this->is_oracle();
-	}
-
-	/**
-	 * {@inheritdoc}
-	 */
-	public function is_fulltext($column = 'topic_title', $table = TOPICS_TABLE)
-	{
-		return in_array($column, $this->get_fulltext_indexes($column, $table), true);
-	}
-
-	/**
-	 * {@inheritdoc}
-	 */
-	public function get_fulltext_indexes($column = 'topic_title', $table = TOPICS_TABLE)
-	{
-		$indexes = array();
-
-		if (!$this->is_supported())
-		{
-			return $indexes;
-		}
-
-		$sql = "SELECT index_name
-			FROM user_indexes
-			WHERE table_name = UPPER('" . $this->db->sql_escape($table) . "')
-			AND index_type = 'DOMAIN'
-			AND domidx_opstatus = 'VALID'";
-		$result = $this->db->sql_query($sql);
-
-		while ($row = $this->db->sql_fetchrow($result))
-		{
-			// Check if this is a text index on our column
-			$check_sql = "SELECT column_name
-				FROM user_ind_columns
-				WHERE index_name = '" . $this->db->sql_escape($row['index_name']) . "'
-				AND column_name = UPPER('" . $this->db->sql_escape($column) . "')";
-			$check_result = $this->db->sql_query($check_sql);
-
-			if ($this->db->sql_fetchrow($check_result))
-			{
-				$indexes[] = strtolower($column);
-			}
-			$this->db->sql_freeresult($check_result);
-		}
-
-		$this->db->sql_freeresult($result);
-
-		return $indexes;
-	}
-
-	/**
-	 * {@inheritdoc}
-	 */
-	public function create_fulltext_index($column = 'topic_title', $table = TOPICS_TABLE)
-	{
-		if (!$this->is_fulltext($column, $table))
-		{
-			$index_name = $table . '_' . $column . '_ctx_idx';
-
-			// Create Oracle Text index
-			$sql = "CREATE INDEX " . $this->db->sql_escape($index_name) . "
-				ON " . $this->db->sql_escape($table) . " (" . $this->db->sql_escape($column) . ")
-				INDEXTYPE IS CTXSYS.CONTEXT
-				PARAMETERS ('STOPLIST CTXSYS.DEFAULT_STOPLIST SYNC (ON COMMIT)')";
-			$this->db->sql_query($sql);
-		}
-	}
-
-	/**
-	 * {@inheritdoc}
-	 */
-	public function get_engine()
-	{
-		return 'oracle';
-	}
-
-	/**
-	 * {@inheritdoc}
-	 */
-	public function has_stopword_support()
-	{
-		return true;
-	}
-
-	/**
-	 * Check if the database is using Oracle
-	 *
-	 * @return bool True if is oracle, false otherwise
-	 */
-	protected function is_oracle()
-	{
-		return strpos($this->db->get_sql_layer(), 'oracle') === 0;
-	}
-
-	/**
-	 * Prepare search terms for Oracle Text query
-	 *
-	 * @param string $topic_title The topic title to search for
-	 * @return string Formatted search terms for Oracle Text
-	 */
-	protected function prepare_search_terms($topic_title)
-	{
-		// Remove special characters and split into words
-		$words = preg_split('/[^\p{L}\p{N}]+/u', $topic_title, -1, PREG_SPLIT_NO_EMPTY);
-
-		// Filter out short words and create OR query
-		$search_words = array();
-		foreach ($words as $word)
-		{
-			if (utf8_strlen($word) >= 3)
-			{
-				$search_words[] = $word;
-			}
-		}
-
-		return !empty($search_words) ? implode(' OR ', $search_words) : $topic_title;
-	}
-}
diff --git "[ORIGINAL]/vse\\similartopics/driver/postgres.php" "[FORUM_EXT]/vse\\similartopics/driver/postgres.php"
--- "[ORIGINAL]/vse\\similartopics/driver/postgres.php"
+++ "[FORUM_EXT]/vse\\similartopics/driver/postgres.php"
@@ -65,6 +65,7 @@ class postgres implements driver_interface
 
 		return array(
 			'SELECT'	=> "f.forum_id, f.forum_name, t.*, $ts_rank_cd AS score",
+
 			'FROM'		=> array(
 				TOPICS_TABLE	=> 't',
 			),
@@ -173,29 +174,6 @@ class postgres implements driver_interface
 		return '';
 	}
 
-	/**
-	 * {@inheritdoc}
-	 */
-	public function has_stopword_support()
-	{
-		return !in_array($this->ts_name, ['simple', ''], true);
-	}
-
-	/**
-	 * Get a list of postgresql text search names
-	 *
-	 * @return array array of text search names
-	 */
-	public function get_cfg_name_list()
-	{
-		$sql = 'SELECT cfgname AS ts_name FROM pg_ts_config';
-		$result = $this->db->sql_query($sql);
-		$ts_options = $this->db->sql_fetchrowset($result);
-		$this->db->sql_freeresult($result);
-
-		return $ts_options;
-	}
-
 	/**
 	 * Set the PostgreSQL Text Search name (dictionary)
 	 *
diff --git "[ORIGINAL]/vse\\similartopics/driver/sqlite3.php" "[ORIGINAL]/vse\\similartopics/driver/sqlite3.php"
deleted file mode 100644
--- "[ORIGINAL]/vse\\similartopics/driver/sqlite3.php"
+++ /dev/null
@@ -1,185 +0,0 @@
-<?php
-/**
- *
- * Precise Similar Topics
- *
- * @copyright (c) 2025 Matt Friedman
- * @license GNU General Public License, version 2 (GPL-2.0)
- *
- */
-
-namespace vse\similartopics\driver;
-
-/**
- * This class handles similar topics queries for SQLite3 dbms
- */
-class sqlite3 implements driver_interface
-{
-	/** @var \phpbb\db\driver\driver_interface */
-	protected $db;
-
-	/**
-	 * Constructor
-	 *
-	 * @param \phpbb\db\driver\driver_interface $db
-	 */
-	public function __construct(\phpbb\db\driver\driver_interface $db)
-	{
-		$this->db = $db;
-	}
-
-	/**
-	 * {@inheritdoc}
-	 */
-	public function get_name()
-	{
-		return 'sqlite3';
-	}
-
-	/**
-	 * {@inheritdoc}
-	 */
-	public function get_type()
-	{
-		return 'sqlite';
-	}
-
-	/**
-	 * {@inheritdoc}
-	 */
-	public function get_query($topic_id, $topic_title, $length, $sensitivity)
-	{
-		$words = explode(' ', $topic_title);
-		$like_conditions = array();
-
-		foreach ($words as $word)
-		{
-			$like_conditions[] = "t.topic_title LIKE '%" . $this->db->sql_escape(trim($word)) . "%'";
-		}
-
-		$where_condition = '(' . implode(' OR ', $like_conditions) . ')';
-
-		return array(
-			'SELECT'	=> "f.forum_id, f.forum_name, t.*,
-				CASE WHEN " . $where_condition . " THEN 1.0 ELSE 0.0 END AS score",
-			'FROM'		=> array(
-				TOPICS_TABLE	=> 't',
-			),
-			'LEFT_JOIN'	=> array(
-				array(
-					'FROM'	=>	array(FORUMS_TABLE	=> 'f'),
-					'ON'	=> 'f.forum_id = t.forum_id',
-				),
-			),
-			'WHERE'		=> $where_condition . "
-				AND t.topic_status <> " . ITEM_MOVED . "
-				AND t.topic_visibility = " . ITEM_APPROVED . "
-				AND t.topic_time > (strftime('%s', 'now') - " . (int) $length . ")
-				AND t.topic_id <> " . (int) $topic_id,
-			'ORDER_BY'	=> 'score DESC, t.topic_time DESC',
-		);
-	}
-
-	/**
-	 * {@inheritdoc}
-	 */
-	public function is_supported()
-	{
-		return ($this->db->get_sql_layer() === 'sqlite3');
-	}
-
-	/**
-	 * {@inheritdoc}
-	 */
-	public function is_fulltext($column = 'topic_title', $table = TOPICS_TABLE)
-	{
-		// For SQLite, we check if a regular index exists since we use LIKE operations
-		return $this->index_exists($table, $column);
-	}
-
-	/**
-	 * {@inheritdoc}
-	 */
-	public function get_fulltext_indexes($column = 'topic_title', $table = TOPICS_TABLE)
-	{
-		$indexes = array();
-
-		if (!$this->is_supported())
-		{
-			return $indexes;
-		}
-
-		// Check for FTS virtual tables
-		$sql = "SELECT name FROM sqlite_master
-			WHERE type='table' AND name LIKE '" . $this->db->sql_escape($table) . "_fts%'";
-		$result = $this->db->sql_query($sql);
-
-		while ($row = $this->db->sql_fetchrow($result))
-		{
-			$indexes[] = $row['name'];
-		}
-
-		$this->db->sql_freeresult($result);
-
-		return $indexes;
-	}
-
-	/**
-	 * {@inheritdoc}
-	 */
-	public function create_fulltext_index($column = 'topic_title', $table = TOPICS_TABLE)
-	{
-		// SQLite FTS setup is complex and optional for LIKE-based search
-		// We'll create a simple index to improve LIKE performance
-		if ($this->index_exists($table, $column))
-		{
-			return;
-		}
-
-		$escaped_table = $this->db->sql_escape($table);
-		$escaped_column = $this->db->sql_escape($column);
-		$sql = 'CREATE INDEX idx_' . $escaped_table . '_' . $escaped_column . '
-			ON ' . $escaped_table . ' (' . $escaped_column . ')';
-		$this->db->sql_query($sql);
-	}
-
-	/**
-	 * {@inheritdoc}
-	 */
-	public function get_engine()
-	{
-		return '';
-	}
-
-	/**
-	 * {@inheritdoc}
-	 */
-	public function has_stopword_support()
-	{
-		return false;
-	}
-
-	/**
-	 * Check if index exists
-	 *
-	 * @param string $table Name of the table
-	 * @param string $column Name of the column
-	 * @return bool True if index exists, false otherwise
-	 */
-	protected function index_exists($table, $column)
-	{
-		if (!$this->is_supported())
-		{
-			return false;
-		}
-
-		$index_name = 'idx_' . $table . '_' . $column;
-		$sql = "SELECT name FROM sqlite_master
-			WHERE type='index' AND name = '" . $this->db->sql_escape($index_name) . "'";
-		$result = $this->db->sql_query($sql);
-		$exists = (bool) $this->db->sql_fetchrow($result);
-		$this->db->sql_freeresult($result);
-
-		return $exists;
-	}
-}
diff --git "[ORIGINAL]/vse\\similartopics/event/listener.php" "[FORUM_EXT]/vse\\similartopics/event/listener.php"
--- "[ORIGINAL]/vse\\similartopics/event/listener.php"
+++ "[FORUM_EXT]/vse\\similartopics/event/listener.php"
@@ -11,8 +11,6 @@
 namespace vse\similartopics\event;
 
 use Symfony\Component\EventDispatcher\EventSubscriberInterface;
-use phpbb\controller\helper;
-use phpbb\template\template;
 
 /**
  * Event listener
@@ -22,25 +20,15 @@ class listener implements EventSubscriberInterface
 	/** @var \vse\similartopics\core\similar_topics */
 	protected $similar_topics;
 
-	/** @var helper */
-	protected $controller_helper;
-
-	/** @var template */
-	protected $template;
-
 	/**
 	 * Constructor
 	 *
 	 * @access public
 	 * @param \vse\similartopics\core\similar_topics $similar_topics
-	 * @param helper $helper
-	 * @param template $template
 	 */
-	public function __construct(\vse\similartopics\core\similar_topics $similar_topics, helper $helper, template $template)
+	public function __construct(\vse\similartopics\core\similar_topics $similar_topics)
 	{
 		$this->similar_topics = $similar_topics;
-		$this->controller_helper = $helper;
-		$this->template = $template;
 	}
 
 	/**
@@ -55,7 +43,6 @@ class listener implements EventSubscriberInterface
 		return [
 			'core.viewtopic_modify_page_title'		=> 'display_similar_topics',
 			'core.permissions'						=> 'add_permissions',
-			'core.posting_modify_template_vars'		=> 'dynamic_similar_topics',
 		];
 	}
 
@@ -89,33 +76,4 @@ class listener implements EventSubscriberInterface
 			'cat' => 'misc'
 		]);
 	}
-
-	/**
-	 * Display dynamic similar topics when creating posts
-	 *
-	 * @access public
-	 * @param \phpbb\event\data $event The event object
-	 */
-	public function dynamic_similar_topics($event)
-	{
-		if ($event['mode'] !== 'post'
-			|| !empty($event['post_data']['topic_id'])
-			|| !$this->similar_topics->is_dynamic_available())
-		{
-			return;
-		}
-
-		$tpl_ary = [
-			'S_DYNAMIC_SIMILAR_TOPICS' => true,
-			'U_PST_AJAX_SEARCH' => $this->controller_helper->route('vse_similartopics_ajax_search'),
-		];
-
-		if ($this->template->retrieve_var('FORUM_ID') === null)
-		{
-			$tpl_ary['FORUM_ID'] = isset($event['forum_id']) ? $event['forum_id'] : 0;
-		}
-
-		$this->template->assign_vars($tpl_ary);
-		$this->similar_topics->add_language();
-	}
 }
diff --git "[ORIGINAL]/vse\\similartopics/ext.php" "[FORUM_EXT]/vse\\similartopics/ext.php"
--- "[ORIGINAL]/vse\\similartopics/ext.php"
+++ "[FORUM_EXT]/vse\\similartopics/ext.php"
@@ -13,13 +13,28 @@ namespace vse\similartopics;
 class ext extends \phpbb\extension\base
 {
 	/**
-	 * Extension requires phpBB 3.2.1 or newer.
+	 * Extension requires Mysql or Postgres DBMS and phpBB 3.2.1 or newer.
 	 *
-	 * @return bool
+	 * @return array|bool If phpBB 3.3.x, return message as to why it could not be installed.
+	 *                    Otherwise, just return boolean true/false.
 	 */
 	public function is_enableable()
 	{
-		return
-			phpbb_version_compare(PHPBB_VERSION, '3.2.1', '>=');
+		$db = $this->container->get('dbal.conn');
+		$valid_db = in_array($db->get_sql_layer(), array('mysqli', 'mysql4', 'postgres'));
+		$valid_phpBB = phpbb_version_compare(PHPBB_VERSION, '3.2.1', '>=');
+		$enableable = $valid_db && $valid_phpBB;
+
+		// Since showing error messages only works for phpBB 3.3.x, the only message worth showing is
+		// if the DBMS is incompatible. That is, we can't show somebody on phpBB 3.2.x. the message that
+		// their board is too old, so there's no reason to handle invalid phpBB version messages here.
+		if (!$enableable && phpbb_version_compare(PHPBB_VERSION, '3.3.0-b1', '>='))
+		{
+			$lang = $this->container->get('language');
+			$lang->add_lang('acp_similar_topics', 'vse/similartopics');
+			return array($lang->lang('PST_NO_COMPAT'));
+		}
+
+		return $enableable;
 	}
 }
diff --git "[ORIGINAL]/vse\\similartopics/language/ar/acp_similar_topics.php" "[FORUM_EXT]/vse\\similartopics/language/ar/acp_similar_topics.php"
--- "[ORIGINAL]/vse\\similartopics/language/ar/acp_similar_topics.php"
+++ "[FORUM_EXT]/vse\\similartopics/language/ar/acp_similar_topics.php"
@@ -43,7 +43,6 @@ $lang = array_merge($lang, array(
 	'PST_EXPLAIN'		=> 'سيتم عرض قائمة بمواضيع متشابهة ( لها علاقة ) في أسفل صفحة الموضوع الذي يتم مُشاهدته.',
 	'PST_LEGEND1'		=> 'إعدادات عامة',
 	'PST_ENABLE'		=> 'إظهار المواضيع المُتشابهه ',
-	'PST_ENABLE_EXPLAIN'=> 'Show similar topics in topic discussion threads.',
 	'PST_LEGEND2'		=> 'إعدادات التحميل',
 	'PST_LIMIT'			=> 'عدد المواضيع المُتشابهه ',
 	'PST_LIMIT_EXPLAIN'	=> 'تستطيع هنا تحديد عدد المواضيع المُتشابهه التي سيتم عرضها في صفحة المواضيع. العدد الإفتراضي هو 5 مواضيع.',
@@ -55,10 +54,8 @@ $lang = array_merge($lang, array(
 	'PST_DAYS'			=> 'أيام',
 	'PST_CACHE'			=> 'فترة الملفات المؤقتة',
 	'PST_CACHE_EXPLAIN'	=> 'سيتم حذف الملفات المؤقتة للمواضيع المُتشابهه بعد تحديد الفترة هنا بالثواني. الصفر يعني تعطيل هذا الخيار.',
-	'PST_DYNAMIC'		=> 'Display dynamic similar topics',
-	'PST_DYNAMIC_EXPLAIN'=> 'Show similar topics as users type in the topic title field when creating new topics.',
 	'PST_SENSE'			=> 'حساسية البحث',
-	'PST_SENSE_EXPLAIN'	=> 'حدد درجة حساسية البحث من القيمة 1 و 10. استخدم القيمة الأقل إذا لا تشاهد أي نتائج للمواضيع المُتشابهه. الإعدادات الموصى بها : <samp>%d</samp>',
+	'PST_SENSE_EXPLAIN'	=> 'حدد درجة حساسية البحث من القيمة 1 و 10. استخدم القيمة الأقل إذا لا تشاهد أي نتائج للمواضيع المُتشابهه. الإعدادات الموصى بها : استخدم القيمة 1 للجداول “phpbb_topics” في قاعدة البيانات InnoDB; استخدم 5 لقاعدة البيانات MyISAM.',
 	'PST_LEGEND3'		=> 'إعدادات المنتدى',
 	'PST_NOSHOW_LIST'	=> 'لا تعرض في',
 	'PST_NOSHOW_TITLE'	=> 'لا تعرض المواضيع المُتشابهه في',
@@ -67,14 +64,14 @@ $lang = array_merge($lang, array(
 	'PST_STANDARD'		=> 'قياسي',
 	'PST_ADVANCED'		=> 'متقدم',
 	'PST_ADVANCED_TITLE'=> 'انقر  لضبط الإعدادات المتقدمة لـ',
-	'PST_ADVANCED_EXP'	=> 'تستطيع من هنا تحديد المنتديات التي تريد جلب المواضيع المُتشابهه منها. المواضيع المُتشابهه الموجودة فقط في المنتديات المُحددة ستظهر في <strong>%s</strong>. <br><br>سيتم جلب المواضيع المُتشابهه من جميع المنتديات في حالة عدم تحديد أي منتدى.<br><br>تحديد أو الغاء التحديد يكون بواسطة الضغط باستمرار على زر الكنترول CTRL والنقر على المنتدى المطلوب.',
+	'PST_ADVANCED_EXP'	=> 'تستطيع من هنا تحديد المنتديات التي تريد جلب المواضيع المُتشابهه منها. المواضيع المُتشابهه الموجودة فقط في المنتديات المُحددة ستظهر في <strong>%s</strong>. <br /><br />سيتم جلب المواضيع المُتشابهه من جميع المنتديات في حالة عدم تحديد أي منتدى.<br /><br />تحديد أو الغاء التحديد يكون بواسطة الضغط باستمرار على زر الكنترول CTRL والنقر على المنتدى المطلوب.',
 	'PST_ADVANCED_FORUM'=> 'إعدادات متقدمة للمنتدى',
 	'PST_DESELECT_ALL'	=> 'الغاء تحديد الكل',
 	'PST_LEGEND4'		=> 'إعدادات اختيارية',
 	'PST_WORDS'			=> 'كلمات مُستبعدة',
 	'PST_WORDS_EXPLAIN'	=> 'سيتم استبعاد الكلمات التي ستضيفها هنا عند البحث عن المواضيع المُتشابهة. ( ملاحظة : يتم استبعاد الكلمات التي تعتبر شائعة في لغتك بصورة افتراضية ). اعمل مسافة بين كل كلمة وأخرى. هذا الخيار غير دقيق لتطابق الكلمات. الحد الأقصى هو 255 حرف.',
 	'PST_SAVED'			=> 'تم تحديث إعدادات المواضيع المُتشابهه',
-	'PST_FORUM_INFO'	=> '" لا تعرض في " : يعني عدم اظهار المواضيع المُتشابهه في المنتديات المُحددة.<br>" لا تبحث في " : يعني عدم البحث عن المواضيع المُتشابهه في المنتديات المُحددة.',
+	'PST_FORUM_INFO'	=> '" لا تعرض في " : يعني عدم اظهار المواضيع المُتشابهه في المنتديات المُحددة.<br />" لا تبحث في " : يعني عدم البحث عن المواضيع المُتشابهه في المنتديات المُحددة.',
 	'PST_NO_COMPAT'		=> 'إضافة "المواضيع المُتشابهه" لا تتوافق مع منتداك. فهي تعمل فقط على قاعدة البيانات MySQL 4 أو MySQL 5 أو PostgreSQL.',
 	'PST_ERR_CONFIG'	=> 'أيضا تميزت العديد من المنتديات في قائمة من المنتديات. يرجى المحاولة مرة أخرى مع مجموعة أصغر.',
 ));
diff --git "[ORIGINAL]/vse\\similartopics/language/cs/acp_similar_topics.php" "[FORUM_EXT]/vse\\similartopics/language/cs/acp_similar_topics.php"
--- "[ORIGINAL]/vse\\similartopics/language/cs/acp_similar_topics.php"
+++ "[FORUM_EXT]/vse\\similartopics/language/cs/acp_similar_topics.php"
@@ -42,7 +42,6 @@ $lang = array_merge($lang, array(
 	'PST_EXPLAIN'		=> 'Toto rozšíření zobrazí na spodu každého tématu odkazy na několik podobných (souvisejících) témat.',
 	'PST_LEGEND1'		=> 'Hlavní nastavení',
 	'PST_ENABLE'		=> 'Zobrazit podobná témata',
-	'PST_ENABLE_EXPLAIN'=> 'Show similar topics in topic discussion threads.',
 	'PST_LEGEND2'		=> 'Nastavení zatížení',
 	'PST_LIMIT'			=> 'Počet podobných témat',
 	'PST_LIMIT_EXPLAIN'	=> 'Zde můžete zvolit počet podobných témat, která se zobrazí. Výchozí nastavení je 5 témat.',
@@ -54,10 +53,8 @@ $lang = array_merge($lang, array(
 	'PST_DAYS'			=> 'Dny',
 	'PST_CACHE'			=> 'Životnost cache',
 	'PST_CACHE_EXPLAIN'	=> 'Cache podobných témat se vyprázdní po daném čase (v sekundách). Pokud nastavíte na 0, cache bude vypnuta.',
-	'PST_DYNAMIC'		=> 'Display dynamic similar topics',
-	'PST_DYNAMIC_EXPLAIN'=> 'Show similar topics as users type in the topic title field when creating new topics.',
 	'PST_SENSE'			=> 'Search sensitivity',
-	'PST_SENSE_EXPLAIN'	=> 'For MySQL or Postgres databases, you can set the search sensitivity to a value between 1 and 10. Use a lower number if you are not seeing any similar topics. Recommended setting: %d',
+	'PST_SENSE_EXPLAIN'	=> 'Set the search sensitivity to a value between 1 and 10. Use a lower number if you are not seeing any similar topics. Recommended settings: For “phpbb_topics” database tables using InnoDB use 1; for MyISAM use 5.',
 	'PST_LEGEND3'		=> 'Nastavení fór',
 	'PST_NOSHOW_LIST'	=> 'Nezobrazovat',
 	'PST_NOSHOW_TITLE'	=> 'Nezobrazovat podobná témata v',
@@ -66,14 +63,14 @@ $lang = array_merge($lang, array(
 	'PST_STANDARD'		=> 'Standartní',
 	'PST_ADVANCED'		=> 'Rozšířené',
 	'PST_ADVANCED_TITLE'=> 'Kliknutím provedete rozšířená nastavení pro fórum',
-	'PST_ADVANCED_EXP'	=> 'Zde můžete vybrat pouze určité sekce, ve kterých chcete, aby se podobná témata vyhledávala. Poté budou v sekci <strong>%s</strong> zobrazena pouze podobná témata z těchto vybraných fór.<br><br>Pokud nevyberete žádná fóra, rozšíření bude podobná témata vyhledávat po celém fóru.<br><br>Výběr více fór můžete provést se stisknoutou klávesou <code>CTRL</code> (případně <code>CMD</code> pro Mac).',
+	'PST_ADVANCED_EXP'	=> 'Zde můžete vybrat pouze určité sekce, ve kterých chcete, aby se podobná témata vyhledávala. Poté budou v sekci <strong>%s</strong> zobrazena pouze podobná témata z těchto vybraných fór.<br /><br />Pokud nevyberete žádná fóra, rozšíření bude podobná témata vyhledávat po celém fóru.<br /><br />Výběr více fór můžete provést se stisknoutou klávesou <code>CTRL</code> (případně <code>CMD</code> pro Mac).',
 	'PST_ADVANCED_FORUM'=> 'Rozšířené nastavení fóra',
 	'PST_DESELECT_ALL'	=> 'Zrušit výběr všech',
 	'PST_LEGEND4'		=> 'Volitelná nastavení',
 	'PST_WORDS'			=> 'Ignorovaná slova',
 	'PST_WORDS_EXPLAIN'	=> 'Zde můžete uvést seznam slov, u kterých si přejete, aby se při vyhledávání podobných témat ignorovala. (Pozn.: Slova, která jsou ve vašem jazyce považována za běžná, uvádět nemusíte (jsou ignorována automaticky). Jednotlivá slova oddělte mezerou. Nezáleží na velikosti písmen.',
 	'PST_SAVED'			=> 'Nastavení podobných témat bylo úspěšně změněno',
-	'PST_FORUM_INFO'	=> '“Nezobrazovat”: Nebude ve vybraných fórech zobrazovat podobná témata.<br>“Nevyhledávat” : Ve vybraných fórech se nebudou vyhledávat podobná témata.',
+	'PST_FORUM_INFO'	=> '“Nezobrazovat”: Nebude ve vybraných fórech zobrazovat podobná témata.<br />“Nevyhledávat” : Ve vybraných fórech se nebudou vyhledávat podobná témata.',
 	'PST_NO_COMPAT'		=> 'Podobná témata nejsou kompatibilní s vašim fórem. Jsou vyžadovány technologie MySQL 4 nebo MySQL 5 nebo PostgreSQL.',
 	'PST_ERR_CONFIG'	=> 'Z hledání/zobrazení bylo vyřazeno příliš mnoho sekcí. Snižte prosím počet vybraných sekcí.',
 ));
diff --git "[ORIGINAL]/vse\\similartopics/language/de/acp_similar_topics.php" "[FORUM_EXT]/vse\\similartopics/language/de/acp_similar_topics.php"
--- "[ORIGINAL]/vse\\similartopics/language/de/acp_similar_topics.php"
+++ "[FORUM_EXT]/vse\\similartopics/language/de/acp_similar_topics.php"
@@ -42,7 +42,6 @@ $lang = array_merge($lang, array(
 	'PST_EXPLAIN'		=> 'Präzise Vergleichbare Themen zeigt eine Liste von ähnlichen Themen am unteren Rand des aktuellen Themas der Seite.',
 	'PST_LEGEND1'		=> 'Allgemeine Einstellungen',
 	'PST_ENABLE'		=> 'Aktiviere Vergleichbare Themen',
-	'PST_ENABLE_EXPLAIN'=> 'Show similar topics in topic discussion threads.',
 	'PST_LEGEND2'		=> 'Lade Einstellungen',
 	'PST_LIMIT'			=> 'Anzahl der angezeigten Vergleichbaren Themen',
 	'PST_LIMIT_EXPLAIN'	=> 'Hier kannst du einstellen, wieviel Vergleichbare Themen angezeigt werden sollen. Standard sind 5 Themen.',
@@ -54,10 +53,8 @@ $lang = array_merge($lang, array(
 	'PST_DAYS'			=> 'Tage',
 	'PST_CACHE'			=> 'Zeitraum der Zwischenspeicherung für Vergleichbare Themen',
 	'PST_CACHE_EXPLAIN'	=> 'Zwischengespeichterte Vergleichbare Themen werden nach dieser Zeit verfallen. In Sekunden angeben. Auf 0 setzen, wenn du den Zwichenspeicher deaktivieren willst.',
-	'PST_DYNAMIC'		=> 'Display dynamic similar topics',
-	'PST_DYNAMIC_EXPLAIN'=> 'Show similar topics as users type in the topic title field when creating new topics.',
 	'PST_SENSE'			=> 'Search sensitivity',
-	'PST_SENSE_EXPLAIN'	=> 'For MySQL or Postgres databases, you can set the search sensitivity to a value between 1 and 10. Use a lower number if you are not seeing any similar topics. Recommended setting: %d',
+	'PST_SENSE_EXPLAIN'	=> 'Set the search sensitivity to a value between 1 and 10. Use a lower number if you are not seeing any similar topics. Recommended settings: For “phpbb_topics” database tables using InnoDB use 1; for MyISAM use 5.',
 	'PST_LEGEND3'		=> 'Foren',
 	'PST_NOSHOW_LIST'	=> 'Nicht anzeigen in',
 	'PST_NOSHOW_TITLE'	=> 'Vergleichbare Themen nicht anzeigen in',
@@ -66,14 +63,14 @@ $lang = array_merge($lang, array(
 	'PST_STANDARD'		=> 'Standard',
 	'PST_ADVANCED'		=> 'Erweiterte Einstellungen',
 	'PST_ADVANCED_TITLE'=> 'Klicken um erweiterte Einstellungen für Vergleichbare Themen vorzunehmen',
-	'PST_ADVANCED_EXP'	=> 'Hier kannst du spezifische Foren auswählen aus denen Vergleichbare Themen angezeigt werden sollen. Es werden nur Vergleichbare Themen in Foren, die du die hier einstellst, angezeigt <strong>%s</strong>.<br><br>Wählen keine Foren, wenn Vergleichbare Themen aus allen durchsuchbaren Foren in diesem Forum angezeigt werden sollen.<br><br>Wähle mehrere Foren aus/ab, indem du beim Klicken die <code>Strg</code>-Taste drückst.',
+	'PST_ADVANCED_EXP'	=> 'Hier kannst du spezifische Foren auswählen aus denen Vergleichbare Themen angezeigt werden sollen. Es werden nur Vergleichbare Themen in Foren, die du die hier einstellst, angezeigt <strong>%s</strong>.<br /><br />Wählen keine Foren, wenn Vergleichbare Themen aus allen durchsuchbaren Foren in diesem Forum angezeigt werden sollen.<br /><br />Wähle mehrere Foren aus/ab, indem du beim Klicken die <code>Strg</code>-Taste drückst.',
 	'PST_ADVANCED_FORUM'=> 'Erweiterte Foren Einstellungen',
 	'PST_DESELECT_ALL'	=> 'Alle abwählen',
 	'PST_LEGEND4'		=> 'Optionale Einstellungen',
 	'PST_WORDS'			=> 'Spezielle Wörter zu ignorieren',
 	'PST_WORDS_EXPLAIN'	=> 'Füge Wörter hinzu, die speziell in deinem Forum häufig vorkommen und deshalb ignoriert werden sollen. (Hinweis: Wörter, die derzeit in deiner Sprache als häufig angesehen werden, werden bereits standardmäßig ignoriert.) Trenne die Worte mit Leerzeichen, Groß-/Kleinschreibung wird ignoriert.',
 	'PST_SAVED'			=> 'Einstellungen für Vergleichbare Themen aktualisiert',
-	'PST_FORUM_INFO'	=> '“Nicht anzeigen in”: Wird die Anzeige von Vergleichbaren Themen in den ausgewählten Foren deaktivieren.<br>“Nicht Suchen Nach in” : Wird die ausgewählten Foren bei der Suche nach Vergleichbaren Themen ignorieren.',
+	'PST_FORUM_INFO'	=> '“Nicht anzeigen in”: Wird die Anzeige von Vergleichbaren Themen in den ausgewählten Foren deaktivieren.<br />“Nicht Suchen Nach in” : Wird die ausgewählten Foren bei der Suche nach Vergleichbaren Themen ignorieren.',
 	'PST_NO_COMPAT'		=> 'Vergleichbare Themen werden in diesem Forum nicht funktionieren. Vergleichbare Themen erfordert eine MySQL 4 oder MySQL 5 oder PostgreSQL Datenbank.',
 	'PST_ERR_CONFIG'	=> 'Zu viele Foren wurden in die Liste der Foren markiert. Bitte versuchen Sie es mit einer kleineren Auswahl.',
 ));
diff --git "[ORIGINAL]/vse\\similartopics/language/el/acp_similar_topics.php" "[FORUM_EXT]/vse\\similartopics/language/el/acp_similar_topics.php"
--- "[ORIGINAL]/vse\\similartopics/language/el/acp_similar_topics.php"
+++ "[FORUM_EXT]/vse\\similartopics/language/el/acp_similar_topics.php"
@@ -42,7 +42,6 @@ $lang = array_merge($lang, array(
 	'PST_EXPLAIN'		=> 'Εμφανίζει μια λίστα παραπλήσιων (συναφών) θεμάτων στο τέλος της τρέχουσας σελίδας θέματος.',
 	'PST_LEGEND1'		=> 'Γενικές ρυθμίσεις',
 	'PST_ENABLE'		=> 'Εμφάνιση παραπλήσιων θεμάτων',
-	'PST_ENABLE_EXPLAIN'=> 'Show similar topics in topic discussion threads.',
 	'PST_LEGEND2'		=> 'Ρυθμίσεις εμφάνισης',
 	'PST_LIMIT'			=> 'Αριθμός παραπλήσιων θεμάτων που θα εμφανίζονται',
 	'PST_LIMIT_EXPLAIN'	=> 'Εδώ μπορείτε να ορίσετε πόσα παραπλήσια θέματα θα εμφανίζονται. Η προεπιλογή είναι 5 θέματα.',
@@ -54,10 +53,8 @@ $lang = array_merge($lang, array(
 	'PST_DAYS'			=> 'Ημέρες',
 	'PST_CACHE'			=> 'Μέγεθος μνήμης παραπλήσιων θεμάτων',
 	'PST_CACHE_EXPLAIN'	=> 'Η αποθηκευμένη μνήμη παραπλήσιων θεμάτων θα λήξει μετά από αυτό το διάστημα, σε δευτερόλεπτα. Θέστε σε "0" αν θέλετε να απενεργοποιήσετε την αποθηκευμένη μνήμη παραπλήσιων θεμάτων.',
-	'PST_DYNAMIC'		=> 'Display dynamic similar topics',
-	'PST_DYNAMIC_EXPLAIN'=> 'Show similar topics as users type in the topic title field when creating new topics.',
 	'PST_SENSE'			=> 'Ευαισθησία αναζήτησης',
-	'PST_SENSE_EXPLAIN'	=> 'Ρυθμίστε την ευαισθησία αναζήτησης σε μια τιμή μεταξύ 1 και 10. Χρησιμοποιήστε μικρότερο αριθμό εάν δεν βλέπετε παρόμοια θέματα. Προτεινόμενες ρυθμίσεις: %d',
+	'PST_SENSE_EXPLAIN'	=> 'Ρυθμίστε την ευαισθησία αναζήτησης σε μια τιμή μεταξύ 1 και 10. Χρησιμοποιήστε μικρότερο αριθμό εάν δεν βλέπετε παρόμοια θέματα. Προτεινόμενες ρυθμίσεις: Για πίνακες βάσης δεδομένων "phpbb_topics" τύπου InnoDB χρησιμοποιείστε 1, για MyISAM χρησιμοποιείστε 5.',
 	'PST_LEGEND3'		=> 'Ρυθμίσεις Δημ. Συζήτησης',
 	'PST_NOSHOW_LIST'	=> 'Να μην εμφανίζονται σε',
 	'PST_NOSHOW_TITLE'	=> 'Να μην εμφανίζονται παραπλήσια θέματα σε',
@@ -66,14 +63,14 @@ $lang = array_merge($lang, array(
 	'PST_STANDARD'		=> 'Τυπικές',
 	'PST_ADVANCED'		=> 'Σύνθετες',
 	'PST_ADVANCED_TITLE'=> 'Πατήστε για περισσότερες ρυθμίσεις παραπλήσιων θεμάτων στο θέμα',
-	'PST_ADVANCED_EXP'	=> 'Εδώ μπορείτε να επιλέξετε συγκεκριμένες Δημ. Συζητήσεις από τις οποίες θα τραβήξει παραπλήσια θέματα. Μόνο παραπλήσια θέματα που βρέθηκαν στις Δημ. Συζητήσεις που επιλέγετε εδώ θα εμφανιστούν στην ενότητα <strong>%s</strong>.<br><br>Μην επιλέξετε καμία Δημ. Συζήτηση, αν θέλετε παραπλήσια θέματα από όλες τις Δημ. Συζητήσεις να εμφανίζονται σε αυτή τη Δημ. Συζήτηση.<br><br>Για να επιλέξτε/αποεπιλέξτε πολλές Δ. Συζητήσεις κρατήστε πατημένο το <code>CTRL</code> και κάντε κλικ.',
+	'PST_ADVANCED_EXP'	=> 'Εδώ μπορείτε να επιλέξετε συγκεκριμένες Δημ. Συζητήσεις από τις οποίες θα τραβήξει παραπλήσια θέματα. Μόνο παραπλήσια θέματα που βρέθηκαν στις Δημ. Συζητήσεις που επιλέγετε εδώ θα εμφανιστούν στην ενότητα <strong>%s</strong>.<br /><br />Μην επιλέξετε καμία Δημ. Συζήτηση, αν θέλετε παραπλήσια θέματα από όλες τις Δημ. Συζητήσεις να εμφανίζονται σε αυτή τη Δημ. Συζήτηση.<br /><br />Για να επιλέξτε/αποεπιλέξτε πολλές Δ. Συζητήσεις κρατήστε πατημένο το <code>CTRL</code> και κάντε κλικ.',
 	'PST_ADVANCED_FORUM'=> 'Σύνθετες ρυθμίσεις',
 	'PST_DESELECT_ALL'	=> 'Αποεπιλογή όλων',
 	'PST_LEGEND4'		=> 'Προαιρετκές ρυθμίσεις',
 	'PST_WORDS'			=> 'Ειδικές λέξεις για αγνόηση',
 	'PST_WORDS_EXPLAIN'	=> 'Προσθέστε ειδικές λέξεις μοναδικές στη Δ. Συζήτησή σας, που θέλετε να αγνοηθούν κατά την εύρεση παραπλήσιων θεμάτων. (Σημείωση: Οι λέξεις που  σήμερα θεωρούνται κοινές στη γλώσσα σας αγνοούνται από προεπιλογή.) Χωρίστε κάθε λέξη με ένα κενό. Με πεζά ή κεφαλαία.',
 	'PST_SAVED'			=> 'Οι ρυθμίσεις των Παραπλήσιων Θεμάτων ενημερώθηκαν',
-	'PST_FORUM_INFO'	=> '"Να μην εμφανίζονται σε": Δεν θα εμφανίζονται παραπλήσια θέματα στις επιλεγμένες Δημ. Συζητήσεις.<br>"Να μην αναζητούνται σε": Δεν θα αναζητούνται παραπλήσια θέματα στις επιλεγμένες Δημ. Συζητήσεις.',
+	'PST_FORUM_INFO'	=> '"Να μην εμφανίζονται σε": Δεν θα εμφανίζονται παραπλήσια θέματα στις επιλεγμένες Δημ. Συζητήσεις.<br />"Να μην αναζητούνται σε": Δεν θα αναζητούνται παραπλήσια θέματα στις επιλεγμένες Δημ. Συζητήσεις.',
 	'PST_NO_COMPAT'		=> 'Το "Παραπλήσια Θέματα" δεν είναι συμβατό με τη Δ. Συζήτησή σας. Μπορεί να λειτουργήσει μόνο σε βάσεις δεδομένων με MySQL 4 ή MySQL 5 ή PostgreSQL.',
 	'PST_ERR_CONFIG'	=> 'Too many forums were marked in the list of forums. Please try again with a smaller selection.',
 ));
diff --git "[ORIGINAL]/vse\\similartopics/language/en/acp_similar_topics.php" "[FORUM_EXT]/vse\\similartopics/language/en/acp_similar_topics.php"
--- "[ORIGINAL]/vse\\similartopics/language/en/acp_similar_topics.php"
+++ "[FORUM_EXT]/vse\\similartopics/language/en/acp_similar_topics.php"
@@ -39,25 +39,22 @@ if (empty($lang) || !is_array($lang))
 
 $lang = array_merge($lang, array(
 	'PST_TITLE_ACP'		=> 'Precise Similar Topics',
-	'PST_EXPLAIN'		=> 'Precise Similar Topics displays a list of similar (related) topics. Similar topics can be shown at the bottom of the current topic’s discussion thread and/or when a user is writing a title for a new post.',
+	'PST_EXPLAIN'		=> 'Precise Similar Topics displays a list of similar (related) topics at the bottom of the current topic’s page.',
 	'PST_LEGEND1'		=> 'General settings',
-	'PST_ENABLE'		=> 'Display similar topics',
-	'PST_ENABLE_EXPLAIN'=> 'Show similar topics in topic discussion threads.',
+	'PST_ENABLE'		=> 'Display Similar Topics',
 	'PST_LEGEND2'		=> 'Load settings',
-	'PST_LIMIT'			=> 'Number of similar topics to display',
+	'PST_LIMIT'			=> 'Number of Similar Topics to display',
 	'PST_LIMIT_EXPLAIN'	=> 'Here you can define how many similar topics to display. The default is 5 topics.',
 	'PST_TIME'			=> 'Search period',
-	'PST_TIME_EXPLAIN'	=> 'This option allows you to confine similar topics results to newer topics (and prevent reviving old threads). For example, if set to “30 days” the system will only show similar topics from within the last 30 days. The default is 1 year. Set it to 99 years if you want to effectively disable this feature.',
+	'PST_TIME_EXPLAIN'	=> 'This option allows you to confine Similar Topics results to newer topics (and prevent reviving old threads). For example, if set to “30 days” the system will only show similar topics from within the last 30 days. The default is 1 year. Set it to 99 years if you want to effectively disable this feature.',
 	'PST_YEARS'			=> 'Years',
 	'PST_MONTHS'		=> 'Months',
 	'PST_WEEKS'			=> 'Weeks',
 	'PST_DAYS'			=> 'Days',
-	'PST_CACHE'			=> 'Similar topics cache length',
+	'PST_CACHE'			=> 'Similar Topics cache length',
 	'PST_CACHE_EXPLAIN'	=> 'Cached similar topics will expire after this time, in seconds. Set to 0 if you want to disable the similar topics cache.',
-	'PST_DYNAMIC'		=> 'Display dynamic similar topics',
-	'PST_DYNAMIC_EXPLAIN'=> 'Show similar topics as users type in the topic title field when creating new topics.',
 	'PST_SENSE'			=> 'Search sensitivity',
-	'PST_SENSE_EXPLAIN'	=> 'For MySQL or Postgres databases, you can set the search sensitivity to a value between 1 and 10. Use a lower number if you are not seeing any similar topics. Recommended setting: %d',
+	'PST_SENSE_EXPLAIN'	=> 'Set the search sensitivity to a value between 1 and 10. Use a lower number if you are not seeing any similar topics. Recommended settings: For “phpbb_topics” database tables using InnoDB use 1; for MyISAM use 5.',
 	'PST_LEGEND3'		=> 'Forum settings',
 	'PST_NOSHOW_LIST'	=> 'Do Not Display In',
 	'PST_NOSHOW_TITLE'	=> 'Do not display similar topics in',
@@ -66,14 +63,14 @@ $lang = array_merge($lang, array(
 	'PST_STANDARD'		=> 'Standard',
 	'PST_ADVANCED'		=> 'Advanced',
 	'PST_ADVANCED_TITLE'=> 'Click to set up advanced similar topic settings for',
-	'PST_ADVANCED_EXP'	=> 'Here you can select specific forums to pull similar topics from. Only similar topics found in the forums you select here will be displayed in <strong>%s</strong>.<br><br>Do not select any forums if you want similar topics from all searchable forums to be displayed in this forum.<br><br>Select multiple forums by holding <samp>CTRL</samp> (or <samp>&#8984;CMD</samp> on Mac) and clicking.',
+	'PST_ADVANCED_EXP'	=> 'Here you can select specific forums to pull similar topics from. Only similar topics found in the forums you select here will be displayed in <strong>%s</strong>.<br /><br />Do not select any forums if you want similar topics from all searchable forums to be displayed in this forum.<br /><br />Select multiple forums by holding <samp>CTRL</samp> (or <samp>&#8984;CMD</samp> on Mac) and clicking.',
 	'PST_ADVANCED_FORUM'=> 'Advanced forum settings',
 	'PST_DESELECT_ALL'	=> 'Deselect all',
 	'PST_LEGEND4'		=> 'Optional settings',
 	'PST_WORDS'			=> 'Special words to ignore',
 	'PST_WORDS_EXPLAIN'	=> 'Add special words unique to your forum that should be ignored when finding similar topics. (Note: Words that are currently regarded as common in your language are already ignored by default.) Separate each word with a space. Case insensitive.',
-	'PST_SAVED'			=> 'Precise Similar Topics settings updated',
-	'PST_FORUM_INFO'	=> '“Do Not Display In”: Will not show similar topics in the selected forums.<br>“Do Not Search In” : Will not search for similar topics in the selected forums.',
-	'PST_NO_COMPAT'		=> 'Precise Similar Topics is not compatible with your forum.',
+	'PST_SAVED'			=> 'Similar Topics settings updated',
+	'PST_FORUM_INFO'	=> '“Do Not Display In”: Will not show similar topics in the selected forums.<br />“Do Not Search In” : Will not search for similar topics in the selected forums.',
+	'PST_NO_COMPAT'		=> 'Similar Topics is not compatible with your forum. Similar Topics will only run on a MySQL or PostgreSQL database.',
 	'PST_ERR_CONFIG'	=> 'Too many forums were marked in the list of forums. Please try again with a smaller selection.',
 ));
diff --git "[ORIGINAL]/vse\\similartopics/language/en/search_ignore_words.php" "[ORIGINAL]/vse\\similartopics/language/en/search_ignore_words.php"
deleted file mode 100644
--- "[ORIGINAL]/vse\\similartopics/language/en/search_ignore_words.php"
+++ /dev/null
@@ -1,598 +0,0 @@
-<?php
-/**
- *
- * Precise Similar Topics
- *
- * @copyright (c) 2025 Matt Friedman
- * @license GNU General Public License, version 2 (GPL-2.0)
- *
- * This [en] language list of stop words created by Matt Friedman for Similar Topics
- *
- */
-
-if (!defined('IN_PHPBB'))
-{
-	exit;
-}
-
-$words = array(
-	'a',
-	'able',
-	'about',
-	'above',
-	'according',
-	'accordingly',
-	'across',
-	'actually',
-	'afaik',
-	'after',
-	'afterwards',
-	'again',
-	'against',
-	'ago',
-	'aint',
-	'all',
-	'allow',
-	'allows',
-	'almost',
-	'alone',
-	'along',
-	'alot',
-	'already',
-	'also',
-	'although',
-	'always',
-	'am',
-	'among',
-	'amongst',
-	'an',
-	'and',
-	'another',
-	'answer',
-	'any',
-	'anybody',
-	'anybodys',
-	'anyhow',
-	'anyone',
-	'anything',
-	'anyway',
-	'anyways',
-	'anywhere',
-	'apart',
-	'appear',
-	'appreciate',
-	'appropriate',
-	'are',
-	'arent',
-	'around',
-	'as',
-	'aside',
-	'ask',
-	'askd',
-	'asking',
-	'associated',
-	'at',
-	'available',
-	'away',
-	'awfully',
-	'bad',
-	'be',
-	'became',
-	'because',
-	'become',
-	'becomes',
-	'becoming',
-	'been',
-	'before',
-	'beforehand',
-	'behind',
-	'being',
-	'believe',
-	'below',
-	'beside',
-	'besides',
-	'best',
-	'better',
-	'between',
-	'beyond',
-	'big',
-	'both',
-	'brief',
-	'btw',
-	'but',
-	'by',
-	'came',
-	'can',
-	'cant',
-	'cannot',
-	'cause',
-	'causes',
-	'certain',
-	'certainly',
-	'changes',
-	'clearly',
-	'co',
-	'com',
-	'come',
-	'comes',
-	'concerning',
-	'consequently',
-	'consider',
-	'considering',
-	'contain',
-	'containing',
-	'contains',
-	'corresponding',
-	'could',
-	'couldnt',
-	'course',
-	'currently',
-	'day',
-	'days',
-	'definitely',
-	'described',
-	'despite',
-	'did',
-	'didnt',
-	'different',
-	'do',
-	'does',
-	'doesnt',
-	'doing',
-	'done',
-	'dont',
-	'down',
-	'downwards',
-	'during',
-	'each',
-	'edu',
-	'eg',
-	'eight',
-	'either',
-	'else',
-	'elsewhere',
-	'enough',
-	'entirely',
-	'especially',
-	'et',
-	'etc',
-	'even',
-	'ever',
-	'every',
-	'everybody',
-	'everybodys',
-	'everyone',
-	'everything',
-	'everywhere',
-	'ex',
-	'exactly',
-	'example',
-	'except',
-	'far',
-	'few',
-	'fifth',
-	'find',
-	'first',
-	'five',
-	'followed',
-	'following',
-	'follows',
-	'for',
-	'former',
-	'formerly',
-	'forth',
-	'found',
-	'four',
-	'from',
-	'further',
-	'furthermore',
-	'get',
-	'gets',
-	'getting',
-	'given',
-	'gives',
-	'go',
-	'goes',
-	'going',
-	'gone',
-	'good',
-	'got',
-	'gotten',
-	'greetings',
-	'had',
-	'hadnt',
-	'happens',
-	'hardly',
-	'has',
-	'hasnt',
-	'have',
-	'havent',
-	'having',
-	'he',
-	'hello',
-	'help',
-	'hence',
-	'her',
-	'here',
-	'hereafter',
-	'hereby',
-	'herein',
-	'hereupon',
-	'hers',
-	'herself',
-	'hi',
-	'him',
-	'himself',
-	'his',
-	'hither',
-	'hopefully',
-	'how',
-	'howbeit',
-	'however',
-	'hows',
-	'href',
-	'i',
-	'id',
-	'ie',
-	'if',
-	'ignored',
-	'iirc',
-	'immediate',
-	'in',
-	'inasmuch',
-	'inc',
-	'indeed',
-	'indicate',
-	'indicated',
-	'indicates',
-	'ini',
-	'inner',
-	'insofar',
-	'instead',
-	'into',
-	'inward',
-	'is',
-	'isnt',
-	'it',
-	'itd',
-	'itll',
-	'its',
-	'itself',
-	'ive',
-	'just',
-	'keep',
-	'keeps',
-	'kept',
-	'know',
-	'known',
-	'knows',
-	'large',
-	'last',
-	'lately',
-	'later',
-	'latter',
-	'latterly',
-	'least',
-	'less',
-	'lest',
-	'let',
-	'lets',
-	'like',
-	'liked',
-	'likely',
-	'little',
-	'look',
-	'looked',
-	'looking',
-	'looks',
-	'lot',
-	'ltd',
-	'mainly',
-	'many',
-	'may',
-	'maybe',
-	'mean',
-	'meanwhile',
-	'me',
-	'merely',
-	'might',
-	'more',
-	'moreover',
-	'most',
-	'mostly',
-	'much',
-	'must',
-	'mustnt',
-	'my',
-	'myself',
-	'name',
-	'namely',
-	'nd',
-	'near',
-	'nearly',
-	'necessary',
-	'need',
-	'needs',
-	'never',
-	'nevertheless',
-	'new',
-	'news',
-	'next',
-	'nine',
-	'no',
-	'nobody',
-	'non',
-	'none',
-	'noone',
-	'nor',
-	'normally',
-	'not',
-	'nothing',
-	'novel',
-	'now',
-	'nowhere',
-	'obviously',
-	'of',
-	'off',
-	'often',
-	'oh',
-	'ok',
-	'okay',
-	'old',
-	'on',
-	'once',
-	'one',
-	'ones',
-	'only',
-	'onto',
-	'oops',
-	'or',
-	'other',
-	'others',
-	'otherwise',
-	'ought',
-	'our',
-	'ours',
-	'ourselves',
-	'out',
-	'outside',
-	'over',
-	'overall',
-	'own',
-	'page',
-	'particular',
-	'particularly',
-	'per',
-	'perhaps',
-	'placed',
-	'please',
-	'plus',
-	'possible',
-	'presumably',
-	'probably',
-	'provides',
-	'put',
-	'que',
-	'question',
-	'questioned',
-	'questions',
-	'quite',
-	'qv',
-	'quote',
-	'rather',
-	'rd',
-	're',
-	'really',
-	'reasonably',
-	'recent',
-	'regarding',
-	'regardless',
-	'regards',
-	'relatively',
-	'respectively',
-	'right',
-	'rotf',
-	'rotflmao',
-	'said',
-	'same',
-	'saw',
-	'say',
-	'saying',
-	'says',
-	'second',
-	'secondly',
-	'see',
-	'seeing',
-	'seem',
-	'seemed',
-	'seeming',
-	'seems',
-	'seen',
-	'see',
-	'self',
-	'selves',
-	'sensible',
-	'sent',
-	'serious',
-	'seriously',
-	'seven',
-	'several',
-	'shall',
-	'she',
-	'should',
-	'shouldnt',
-	'since',
-	'sites',
-	'six',
-	'small',
-	'so',
-	'some',
-	'somebody',
-	'somehow',
-	'someone',
-	'something',
-	'sometime',
-	'sometimes',
-	'somewhat',
-	'somewhere',
-	'soon',
-	'sorry',
-	'specified',
-	'specify',
-	'specifying',
-	'still',
-	'sub',
-	'such',
-	'sup',
-	'sure',
-	't',
-	'take',
-	'taken',
-	'tell',
-	'tends',
-	'than',
-	'thank',
-	'thanks',
-	'thanx',
-	'that',
-	'thatd',
-	'thats',
-	'the',
-	'their',
-	'theirs',
-	'them',
-	'themselves',
-	'then',
-	'thence',
-	'there',
-	'thereafter',
-	'thereby',
-	'therefore',
-	'therein',
-	'theres',
-	'thereupon',
-	'these',
-	'they',
-	'theyd',
-	'theyll',
-	'theyre',
-	'theyve',
-	'think',
-	'third',
-	'this',
-	'thorough',
-	'thoroughly',
-	'those',
-	'though',
-	'three',
-	'through',
-	'throughout',
-	'thru',
-	'thus',
-	'time',
-	'times',
-	'to',
-	'together',
-	'too',
-	'took',
-	'toward',
-	'towards',
-	'tried',
-	'tries',
-	'truly',
-	'try',
-	'trying',
-	'twice',
-	'two',
-	'un',
-	'under',
-	'unfortunately',
-	'unless',
-	'unlikely',
-	'until',
-	'untrue',
-	'unto',
-	'up',
-	'upon',
-	'us',
-	'use',
-	'used',
-	'useful',
-	'users',
-	'uses',
-	'using',
-	'usually',
-	'value',
-	'various',
-	'version',
-	'very',
-	'via',
-	'viz',
-	'vs',
-	'want',
-	'wants',
-	'was',
-	'wasnt',
-	'way',
-	'we',
-	'wed',
-	'well',
-	'were',
-	'werent',
-	'weve',
-	'welcome',
-	'went',
-	'what',
-	'whats',
-	'whatever',
-	'when',
-	'whence',
-	'whenever',
-	'where',
-	'wheres',
-	'whereafter',
-	'whereas',
-	'whereby',
-	'wherein',
-	'whereupon',
-	'wherever',
-	'whether',
-	'which',
-	'while',
-	'whither',
-	'who',
-	'whos',
-	'whoever',
-	'whole',
-	'whom',
-	'whose',
-	'why',
-	'wide',
-	'will',
-	'willing',
-	'wish',
-	'with',
-	'within',
-	'without',
-	'wont',
-	'wonder',
-	'world',
-	'worse',
-	'worst',
-	'would',
-	'wouldnt',
-	'wrote',
-	'www',
-	'yes',
-	'yet',
-	'ymmv',
-	'you',
-	'youd',
-	'youll',
-	'your',
-	'youre',
-	'yours',
-	'yourself',
-	'yourselves',
-	'zero'
-);
diff --git "[ORIGINAL]/vse\\similartopics/language/es/acp_similar_topics.php" "[FORUM_EXT]/vse\\similartopics/language/es/acp_similar_topics.php"
--- "[ORIGINAL]/vse\\similartopics/language/es/acp_similar_topics.php"
+++ "[FORUM_EXT]/vse\\similartopics/language/es/acp_similar_topics.php"
@@ -42,7 +42,6 @@ $lang = array_merge($lang, array(
 	'PST_EXPLAIN'		=> 'Hilos Parecidos Precisos muestra una lista de temas similares en la parte inferior de la página del tema actual.',
 	'PST_LEGEND1'		=> 'Configuración general',
 	'PST_ENABLE'		=> 'Habilitar Hilos Parecidos',
-	'PST_ENABLE_EXPLAIN'=> 'Show similar topics in topic discussion threads.',
 	'PST_LEGEND2'		=> 'Cargar configuración',
 	'PST_LIMIT'			=> 'Número de Hilos Parecidos que deben mostrarse',
 	'PST_LIMIT_EXPLAIN'	=> 'Aquí puedes definir cuántos Hilos (mensajes) Parecidos deben mostrarse. El número por defecto es 5 hilos.',
@@ -54,10 +53,8 @@ $lang = array_merge($lang, array(
 	'PST_DAYS'			=> 'Días',
 	'PST_CACHE'			=> 'Longitud de la caché de Hilos Parecidos',
 	'PST_CACHE_EXPLAIN'	=> 'La caché de hilos parecidos expirará después del tiempo indicado, en segundos. Ponlo a 0 si quieres deshabilitar la caché de hilos parecidos.',
-	'PST_DYNAMIC'		=> 'Display dynamic similar topics',
-	'PST_DYNAMIC_EXPLAIN'=> 'Show similar topics as users type in the topic title field when creating new topics.',
 	'PST_SENSE'			=> 'Sensibilidad de búsqueda',
-	'PST_SENSE_EXPLAIN'	=> 'Establezca la sensibilidad de búsqueda en un valor entre 1 y 10. Use un número menor si no ve ningún tema similar. Ajustes recomendados: %d',
+	'PST_SENSE_EXPLAIN'	=> 'Establezca la sensibilidad de búsqueda en un valor entre 1 y 10. Use un número menor si no ve ningún tema similar. Ajustes recomendados: Para la tabla “phpbb_topics” de la bases de datos usando InnoDB use 1; para MyISAM use 5.',
 	'PST_LEGEND3'		=> 'Configuración de foro',
 	'PST_NOSHOW_LIST'	=> 'No mostrar en',
 	'PST_NOSHOW_TITLE'	=> 'No mostrar hilos parecidos en',
@@ -66,14 +63,14 @@ $lang = array_merge($lang, array(
 	'PST_STANDARD'		=> 'Estándar',
 	'PST_ADVANCED'		=> 'Avanzado',
 	'PST_ADVANCED_TITLE'=> 'Haz clic para habilitar la configuración avanzada de hilos parecidos para',
-	'PST_ADVANCED_EXP'	=> 'Aquí puedes seleccionar foros específicos de donde extraer hilos parecidos. Sólo los hilos parecidos que se encuentren en los foros que selecciones aquí se mostrarán en <strong>%s</strong>.<br><br>No selecciones ningún foro si quieres que todos los foros que tengan habilitado la búsqueda en ellos sean mostrados en este foro.<br><br>Seleccione/Deseleccione multiples foros manteniendo pulsada la tecla <code>CTRL</code> y haciendo clic en los foros deseados.',
+	'PST_ADVANCED_EXP'	=> 'Aquí puedes seleccionar foros específicos de donde extraer hilos parecidos. Sólo los hilos parecidos que se encuentren en los foros que selecciones aquí se mostrarán en <strong>%s</strong>.<br /><br />No selecciones ningún foro si quieres que todos los foros que tengan habilitado la búsqueda en ellos sean mostrados en este foro.<br /><br />Seleccione/Deseleccione multiples foros manteniendo pulsada la tecla <code>CTRL</code> y haciendo clic en los foros deseados.',
 	'PST_ADVANCED_FORUM'=> 'Configuración avanzada del foro',
 	'PST_DESELECT_ALL'	=> 'Deseleccionar todos',
 	'PST_LEGEND4'		=> 'Configuración opcional',
 	'PST_WORDS'			=> 'Palabras especiales para ignorar',
 	'PST_WORDS_EXPLAIN'	=> 'Añadir palabras especiales exclusivas de su foro en el que deben ser ignoradas en hilos parecidos. (Nota: Las palabras comunes en su lengua son ignorados por defecto.) Separe cada palabra con un espacio. Mayúsculas no minúsculas.',
 	'PST_SAVED'			=> 'La configuración de Hilos Parecidos ha sido actualizada',
-	'PST_FORUM_INFO'	=> '“No Mostrar En”: Deshabilitará la visualización de hilos parecidos en el foro seleccionado.<br>“No Buscar En” : Ignorará los foros seleccionados cuando se estén buscando hilos parecidos.',
+	'PST_FORUM_INFO'	=> '“No Mostrar En”: Deshabilitará la visualización de hilos parecidos en el foro seleccionado.<br />“No Buscar En” : Ignorará los foros seleccionados cuando se estén buscando hilos parecidos.',
 	'PST_NO_COMPAT'		=> 'Hilos Parecidos no va a funcionar en tu foro. Hilos Parecidos requiere una base de datos MySQL 4 o MySQL 5 o PostgreSQL.',
 	'PST_ERR_CONFIG'	=> 'Demasiados foros fueron marcados en la lista de foros. Inténtalo de nuevo con una selección más pequeña.',
 ));
diff --git "[ORIGINAL]/vse\\similartopics/language/fa/acp_similar_topics.php" "[FORUM_EXT]/vse\\similartopics/language/fa/acp_similar_topics.php"
--- "[ORIGINAL]/vse\\similartopics/language/fa/acp_similar_topics.php"
+++ "[FORUM_EXT]/vse\\similartopics/language/fa/acp_similar_topics.php"
@@ -43,7 +43,6 @@ $lang = array_merge($lang, array(
 	'PST_EXPLAIN'		=> '"موضوعات مشابه" ابزاریست جهت نمایش ، موضوعات مشابه در قسمت پایین هر موضوع در انجمن ها',
 	'PST_LEGEND1'		=> 'تنظیمات کلی',
 	'PST_ENABLE'		=> 'نمایش موضوعات مشابه',
-	'PST_ENABLE_EXPLAIN'=> 'Show similar topics in topic discussion threads.',
 	'PST_LEGEND2'		=> 'بارگزاری تنظیمات',
 	'PST_LIMIT'			=> 'تعداد موضوعات مشابه جهت نمایش',
 	'PST_LIMIT_EXPLAIN'	=> 'در این قسمت شما میتوانید تعیین کنید که چه تعداد موضوع نمایش داده شود. مقدار پیش فرض تعداد 5 است.',
@@ -55,10 +54,8 @@ $lang = array_merge($lang, array(
 	'PST_DAYS'			=> 'روز',
 	'PST_CACHE'			=> 'زمان ذخیره سازی کش',
 	'PST_CACHE_EXPLAIN'	=> 'کش یا نهان این افزونه بعد از تعیین زمان توسط شما منسوخ خواهد شد ، برای غیر فعال سازی 0 را وارد کنید.',
-	'PST_DYNAMIC'		=> 'Display dynamic similar topics',
-	'PST_DYNAMIC_EXPLAIN'=> 'Show similar topics as users type in the topic title field when creating new topics.',
-	'PST_SENSE'			=> 'حساسیت جستجو',
-	'PST_SENSE_EXPLAIN'	=> 'حساسیت جستجو را روی مقداری بین 1 تا 10 تنظیم کنید. اگر موضوع مشابهی نمی بینید از عدد کمتری استفاده کنید. تنظیمات پیشنهادی: برای جداول پایگاه داده “phpbb_topics” با استفاده از InnoDB از 1 استفاده کنید. برای MyISAM از 5 استفاده کنید.',
+	'PST_SENSE'			=> 'Search sensitivity',
+	'PST_SENSE_EXPLAIN'	=> 'Set the search sensitivity to a value between 1 and 10. Use a lower number if you are not seeing any similar topics. Recommended settings: For “phpbb_topics” database tables using InnoDB use 1; for MyISAM use 5.',
 	'PST_LEGEND3'		=> 'تنظیمات انجمن',
 	'PST_NOSHOW_LIST'	=> 'در این بخش نمایش نده',
 	'PST_NOSHOW_TITLE'	=> 'موضوعات مشابه را در این انجمن نشان نده',
@@ -67,14 +64,14 @@ $lang = array_merge($lang, array(
 	'PST_STANDARD'		=> 'استاندارد',
 	'PST_ADVANCED'		=> 'پیشرفته',
 	'PST_ADVANCED_TITLE'=> 'کلیک جهت انجام تنظیمات پیشرفته',
-	'PST_ADVANCED_EXP'	=> 'در اینجا شما میتوانید انجمن هایی که دوست دارید موضوعات مشابه در آن دیده شوند انتخاب کنید. به یاد داشته باشید که فقط انجمن هایی که شما انتخاب کنید شامل این افزونه خواهد شد.<br>',
+	'PST_ADVANCED_EXP'	=> 'در اینجا شما میتوانید انجمن هایی که دوست دارید موضوعات مشابه در آن دیده شوند انتخاب کنید. به یاد داشته باشید که فقط انجمن هاییی که شما انتخاب میکنید شامل این افزونه خواهد شد.<br />',
 	'PST_ADVANCED_FORUM'=> 'تنظیمات پیشرفته انجمن',
 	'PST_DESELECT_ALL'	=> 'انتخاب نکردن',
 	'PST_LEGEND4'		=> 'تنظیمات',
 	'PST_WORDS'			=> 'کلمات سانسور شده',
-	'PST_WORDS_EXPLAIN'	=> 'کلمات سانسوری که قصد دارید هنگام جستجوی موضوعات مشابه نمایش داده نشوند را وارد کنید. هر کلمه را با space جدا کنید.',
-	'PST_SAVED'			=> 'تنظیمات موضوعات مشابه بروز رسانی شد',
-	'PST_FORUM_INFO'	=> 'انتخاب گزنیه"در این بخش نمایش نده" باعث می شود موضوعات مشابه در انجمن انتخابی نمایش داده نشود<br>انتخاب گزینه" جستجوی موضوعات را در این بخش انجام نده" باعث می شود ، جستجو در انجمن انتخابی برای موضوعات مشابه انجام نشود.',
+	'PST_WORDS_EXPLAIN'	=> 'کلمات سانسوی که قصد دارید هنگام جستجوی موضوعات مشابه نمایش داده نشوند را وارد کنید. هر کلمه را با space میتوانید جدا کنید و.',
+	'PST_SAVED'			=> 'تنظیمات موضوعات مشابه به روز رسانی شد',
+	'PST_FORUM_INFO'	=> 'انتخاب گزنیه"در این بخش نمایش نده" باعث می شود موضوعات مشابه در انجمن های انتخابی نمایش داده نشود<br />انتخاب گزینه" جستجوی موضوعات را در این بخش انجام نده" باعث می شود ، جستجو در بخش های انتخابی برای تاپیک های مشابه انجام نشود.',
 	'PST_NO_COMPAT'		=> 'افزونه موضوعات مشابه با سیستم انجمن شما سازگار نیست. این سیستم تنها روی دیتابیس های PostgreSQL or MySQL 4 or MySQL 5 کار میکند',
-	'PST_ERR_CONFIG'	=> 'تعداد انجمن های انتخاب شده بیش از حد می باشد لطفا دوباره با یک انتخاب کوچکتر امتحان کنید.',
+	'PST_ERR_CONFIG'	=> 'بیش از حد بسیاری از انجمن ها در فهرست انجمن ها مشخص شد. لطفا دوباره با یک انتخاب کوچکتر امتحان کنید.',
 ));
diff --git "[ORIGINAL]/vse\\similartopics/language/fa/info_acp_similar_topics.php" "[FORUM_EXT]/vse\\similartopics/language/fa/info_acp_similar_topics.php"
--- "[ORIGINAL]/vse\\similartopics/language/fa/info_acp_similar_topics.php"
+++ "[FORUM_EXT]/vse\\similartopics/language/fa/info_acp_similar_topics.php"
@@ -40,6 +40,6 @@ if (empty($lang) || !is_array($lang))
 
 $lang = array_merge($lang, array(
 	'PST_TITLE_ACP'		=> 'موضوعات مشابه',
-	'PST_SETTINGS'		=> 'تنظیمات',
-	'PST_LOG_MSG'		=> '<strong>تنظیمات افزونه "موضوعات مشابه" بروز رسانی شد</strong>',
+	'PST_SETTINGS'		=> 'تنظیمات افزونه "موضوعات مشابه"',
+	'PST_LOG_MSG'		=> '<strong>تنظیمات افزونه "موضوعات مشابه" به روز رسانی شد</strong>',
 ));
diff --git "[ORIGINAL]/vse\\similartopics/language/fa/search_ignore_words.php" "[ORIGINAL]/vse\\similartopics/language/fa/search_ignore_words.php"
deleted file mode 100644
--- "[ORIGINAL]/vse\\similartopics/language/fa/search_ignore_words.php"
+++ /dev/null
@@ -1,63 +0,0 @@
-<?php
-/**
- *
- * Precise Similar Topics
- *
- * @copyright (c) 2025 Matt Friedman
- * @license GNU General Public License, version 2 (GPL-2.0)
- *
- * This [fa] language list of stop words created by Matt Friedman for Similar Topics
- *
- */
-
-if (!defined('IN_PHPBB'))
-{
-   exit;
-}
-
-$words = array(
-	'آن',
-	'آنها',
-	'اگر',
-	'از',
-	'است',
-	'این',
-	'اینها',
-	'با',
-	'باشد',
-	'بر',
-	'برای',
-	'بعد',
-	'بود',
-	'بوده',
-	'بزرگ',
-	'تا',
-	'تمام',
-	'جدید',
-	'خوب',
-	'در',
-	'روز',
-	'روزها',
-	'زمان',
-	'شد',
-	'شده',
-	'شود',
-	'کار',
-	'که',
-	'کرد',
-	'کرده',
-	'کند',
-	'کوچک',
-	'گفت',
-	'ما',
-	'من',
-	'نیز',
-	'هم',
-	'همه',
-	'هیچ',
-	'و',
-	'وقت',
-	'ولی',
-	'یا',
-	'یک',
-);
diff --git "[ORIGINAL]/vse\\similartopics/language/fr/acp_similar_topics.php" "[FORUM_EXT]/vse\\similartopics/language/fr/acp_similar_topics.php"
--- "[ORIGINAL]/vse\\similartopics/language/fr/acp_similar_topics.php"
+++ "[FORUM_EXT]/vse\\similartopics/language/fr/acp_similar_topics.php"
@@ -43,7 +43,6 @@ $lang = array_merge($lang, array(
 	'PST_EXPLAIN'		=> 'Affiche une liste des sujets similaires au bas de la page du sujet visionné.',
 	'PST_LEGEND1'		=> 'Paramètre général',
 	'PST_ENABLE'		=> 'Afficher les sujets similaires',
-	'PST_ENABLE_EXPLAIN'=> 'Show similar topics in topic discussion threads.',
 	'PST_LEGEND2'		=> 'Paramètres principaux',
 	'PST_LIMIT'			=> 'Nombre du ou des sujets similaires à afficher',
 	'PST_LIMIT_EXPLAIN'	=> 'Ici vous pouvez sélectionner le ou les nombres de sujets similaires à afficher. La valeur par défaut est de 5 sujets.',
@@ -55,10 +54,8 @@ $lang = array_merge($lang, array(
 	'PST_DAYS'			=> 'Jour(s)',
 	'PST_CACHE'			=> 'Taille du cache des sujets similaires',
 	'PST_CACHE_EXPLAIN'	=> 'La mise en cache des sujets similaires expirera après cette période. Paramétrez sur 0 pour désactiver la mise en cache des sujets similaires.',
-	'PST_DYNAMIC'		=> 'Display dynamic similar topics',
-	'PST_DYNAMIC_EXPLAIN'=> 'Show similar topics as users type in the topic title field when creating new topics.',
 	'PST_SENSE'			=> 'Sensibilité de la recherche',
-	'PST_SENSE_EXPLAIN'	=> 'Permet de saisir une valeur comprise entre 1 et 10 concernant le degré de sensibilité de la recherche. Utiliser une valeur plus basse si aucun sujet similaire n’est affiché. Paramètres recommandées : %d',
+	'PST_SENSE_EXPLAIN'	=> 'Permet de saisir une valeur comprise entre 1 et 10 concernant le degré de sensibilité de la recherche. Utiliser une valeur plus basse si aucun sujet similaire n’est affiché. Paramètres recommandées : Pour les tables « phpbb_topics » utilisant InnoDB saisir 1 ; pour MyISAM saisir 5.',
 	'PST_LEGEND3'		=> 'Paramètres des forums',
 	'PST_NOSHOW_LIST'	=> 'Ne pas afficher dans',
 	'PST_NOSHOW_TITLE'	=> 'Ne pas afficher les sujets similaires dans le forum :',
@@ -67,14 +64,14 @@ $lang = array_merge($lang, array(
 	'PST_STANDARD'		=> 'Standard',
 	'PST_ADVANCED'		=> 'Avancé',
 	'PST_ADVANCED_TITLE'=> 'Cliquez ici pour configurer les paramètres avancés du forum :',
-	'PST_ADVANCED_EXP'	=> 'Ici vous pouvez sélectionner des forums spécifiques dont les sujets similaires proviendront. Seuls les sujets similaires trouvés dans les forums sélectionnés ici seront affichés dans le forum : <strong>%s</strong>.<br><br>Ne sélectionnez aucun forum si vous souhaitez que tous les sujets similaires de tous les forums soient consultables dans ce forum.<br><br>Vous pouvez sélectionner ou désélectionner plusieurs forums en maintenant appuyée la touche <samp>CTRL</samp> (ou <samp>&#8984;CMD</samp> sur Mac) du clavier de votre ordinateur et en cliquant.',
+	'PST_ADVANCED_EXP'	=> 'Ici vous pouvez sélectionner des forums spécifiques dont les sujets similaires proviendront. Seuls les sujets similaires trouvés dans les forums sélectionnés ici seront affichés dans le forum : <strong>%s</strong>.<br /><br />Ne sélectionnez aucun forum si vous souhaitez que tous les sujets similaires de tous les forums soient consultables dans ce forum.<br /><br />Vous pouvez sélectionner ou désélectionner plusieurs forums en maintenant appuyée la touche <samp>CTRL</samp> (ou <samp>&#8984;CMD</samp> sur Mac) du clavier de votre ordinateur et en cliquant.',
 	'PST_ADVANCED_FORUM'=> 'Paramètres avancés du forum',
 	'PST_DESELECT_ALL'	=> 'Tout désélectionner',
 	'PST_LEGEND4'		=> 'Paramètres optionnels',
 	'PST_WORDS'			=> 'Mots spécifiques à ignorer',
 	'PST_WORDS_EXPLAIN'	=> 'Ajoutez des mots spécifiques à votre forum qui doivent être ignorés lors de la recherche des sujets similaires. (Remarque : Les mots qui sont actuellement considérés comme communs dans votre langue sont déjà ignorés par défaut.) Séparez chaque mot par un espace. Insensible à la casse.',
 	'PST_SAVED'			=> 'Les paramètres des sujets similaires ont été mis à jour',
-	'PST_FORUM_INFO'	=> '« Ne pas afficher dans » : N’affiche pas de sujets similaires dans les forums sélectionnés.<br> « Ne pas rechercher dans » : Ne recherche pas de sujets similaires dans les forums sélectionnés.<br><br>',
+	'PST_FORUM_INFO'	=> '« Ne pas afficher dans » : N’affiche pas de sujets similaires dans les forums sélectionnés.<br /> « Ne pas rechercher dans » : Ne recherche pas de sujets similaires dans les forums sélectionnés.<br /><br />',
 	'PST_NO_COMPAT'		=> 'L’extension « Sujets similaires précis » n’est pas compatible avec votre forum. Cette extension fonctionne uniquement avec une base de données MySQL 4 ou 5 ou PostgreSQL.',
 	'PST_ERR_CONFIG'	=> 'De trop nombreux forums ont été sélectionnés dans la liste des forums. Veuillez réessayer avec une sélection plus restreinte.',
 ));
diff --git "[ORIGINAL]/vse\\similartopics/language/he/acp_similar_topics.php" "[FORUM_EXT]/vse\\similartopics/language/he/acp_similar_topics.php"
--- "[ORIGINAL]/vse\\similartopics/language/he/acp_similar_topics.php"
+++ "[FORUM_EXT]/vse\\similartopics/language/he/acp_similar_topics.php"
@@ -42,7 +42,6 @@ $lang = array_merge($lang, array(
 	'PST_EXPLAIN'		=> 'נושאים דומים במדויק מציג רשימת נושאים דומים (קשורים) בחלק התחתון של דף הנושא הנוכחי.',
 	'PST_LEGEND1'		=> 'הגדרות כלליות',
 	'PST_ENABLE'		=> 'הצג נושאים דומים',
-	'PST_ENABLE_EXPLAIN'=> 'Show similar topics in topic discussion threads.',
 	'PST_LEGEND2'		=> 'טען הגדרות',
 	'PST_LIMIT'			=> 'מספר נושאים דומים להצגה',
 	'PST_LIMIT_EXPLAIN'	=> 'כאן באפשרותך להגדיר כמה נושאים דומים להציג. ברירת המחדל היא 5 נושאים.',
@@ -54,10 +53,8 @@ $lang = array_merge($lang, array(
 	'PST_DAYS'			=> 'ימים',
 	'PST_CACHE'			=> 'אורך מטמון נושאים דומים',
 	'PST_CACHE_EXPLAIN'	=> 'מטמון נושאים דומים יפוג לאחר זמן, ערך בשניות. קבע 0 אם אתה רוצה לבטל את מטמון נושאים דומים.',
-	'PST_DYNAMIC'		=> 'Display dynamic similar topics',
-	'PST_DYNAMIC_EXPLAIN'=> 'Show similar topics as users type in the topic title field when creating new topics.',
 	'PST_SENSE'			=> 'רגישות חיפוש',
-	'PST_SENSE_EXPLAIN'	=> 'הגדר את רגישות החיפוש לערך בין 1 ל -10. השתמש במספר נמוך יותר אם אינך רואה נושאים דומים. הגדרות מומלצות: <samp>%d</samp>',
+	'PST_SENSE_EXPLAIN'	=> 'הגדר את רגישות החיפוש לערך בין 1 ל -10. השתמש במספר נמוך יותר אם אינך רואה נושאים דומים. הגדרות מומלצות: עבור טבלאות מסד נתונים “phpbb_topics” הפועלים ב- InnoDB השתמש ב- 1; עבור  MyISAM השתמש ב- 5.',
 	'PST_LEGEND3'		=> 'הגדרות פורום',
 	'PST_NOSHOW_LIST'	=> 'לא להציג ב',
 	'PST_NOSHOW_TITLE'	=> 'לא להציג נושאים דומים ב',
@@ -66,14 +63,14 @@ $lang = array_merge($lang, array(
 	'PST_STANDARD'		=> 'תקן',
 	'PST_ADVANCED'		=> 'מתקדם',
 	'PST_ADVANCED_TITLE'=> 'לחץ כדי להגדיר הגדרות מתקדמות לנושא דומה עבור',
-	'PST_ADVANCED_EXP'	=> 'כאן ניתן לבחור פורומים ספציפיים כדי למשוך נושאים דומים מ. רק נושאים דומים שנמצאו בפורומים שתבחר כאן יוצגו ב- <strong>%s</strong>. אל תבחר בכל הפורומים, אם אתה רוצה שנושאים דומים מחיפוש בכל הפורומים יוצג בפורום זה.<br><br>בחר במספר פורומים על ידי החזקת מקש <samp>CTRL</samp> (או <samp>&#8984;CMD</samp> ב- MAC) ולחיצה.',
+	'PST_ADVANCED_EXP'	=> 'כאן ניתן לבחור פורומים ספציפיים כדי למשוך נושאים דומים מ. רק נושאים דומים שנמצאו בפורומים שתבחר כאן יוצגו ב- <strong>%s</strong>. אל תבחר בכל הפורומים, אם אתה רוצה שנושאים דומים מחיפוש בכל הפורומים יוצג בפורום זה.<br /><br />בחר במספר פורומים על ידי החזקת מקש <samp>CTRL</samp> (או <samp>&#8984;CMD</samp> ב- MAC) ולחיצה.',
 	'PST_ADVANCED_FORUM'=> 'הגדרות פורום מתקדמות',
 	'PST_DESELECT_ALL'	=> 'הסר סימון מהכל',
 	'PST_LEGEND4'		=> 'הגדרות אופציונליות',
 	'PST_WORDS'			=> 'להתעלם ממילים מיוחדות',
 	'PST_WORDS_EXPLAIN'	=> 'הוסף מילים מיוחדות וייחודיות בפורום שלך שיש להתעלם מהן בעת מציאת נושאים דומים. (הערה: כברירת מחדל, הוא כבר מתעלם ממילים שנחשבות נפוצות בשפה שלך.) הפרד כל מילה עם רווח. לא תלוי רישיות.',
 	'PST_SAVED'			=> 'הגדרות נושאים דומים עודכנו',
-	'PST_FORUM_INFO'	=> '"לא להציג ב": לא יוצגו נושאים דומים בפורומים שנבחרו.<br>"לא לחפש בתוך": לא יחפש נושאים דומים בפורומים שנבחרו.',
+	'PST_FORUM_INFO'	=> '"לא להציג ב": לא יוצגו נושאים דומים בפורומים שנבחרו.<br />"לא לחפש בתוך": לא יחפש נושאים דומים בפורומים שנבחרו.',
 	'PST_NO_COMPAT'		=> 'נושאים דומים אינו תואם את הפורום שלך. נושאים דומים יפעל רק על מסד נתונים MySQL או PostgreSQL.',
 	'PST_ERR_CONFIG'	=> 'יותר מדי פורומים סומנו ברשימת הפורומים. נסה שוב עם בחירה קטנה יותר.',
 ));
diff --git "[ORIGINAL]/vse\\similartopics/language/he/search_ignore_words.php" "[ORIGINAL]/vse\\similartopics/language/he/search_ignore_words.php"
deleted file mode 100644
--- "[ORIGINAL]/vse\\similartopics/language/he/search_ignore_words.php"
+++ /dev/null
@@ -1,73 +0,0 @@
-<?php
-/**
- *
- * Precise Similar Topics
- *
- * @copyright (c) 2025 Matt Friedman
- * @license GNU General Public License, version 2 (GPL-2.0)
- *
- * This [he] language list of stop words created by Matt Friedman for Similar Topics
- *
- */
-
-if (!defined('IN_PHPBB'))
-{
-   exit;
-}
-
-$words = array(
-	'אבל',
-	'אחד',
-	'אחר',
-	'אחרי',
-	'איך',
-	'אין',
-	'אל',
-	'אם',
-	'אני',
-	'אף',
-	'את',
-	'אתה',
-	'אתם',
-	'בין',
-	'גדול',
-	'גם',
-	'דבר',
-	'היא',
-	'היה',
-	'הם',
-	'הן',
-	'הוא',
-	'זה',
-	'זו',
-	'חדש',
-	'טוב',
-	'יום',
-	'ימים',
-	'יש',
-	'כאן',
-	'כבר',
-	'כי',
-	'כל',
-	'כמו',
-	'כן',
-	'לא',
-	'לו',
-	'לי',
-	'למה',
-	'מה',
-	'מי',
-	'מן',
-	'נגד',
-	'עד',
-	'על',
-	'עם',
-	'פה',
-	'קטן',
-	'רב',
-	'רק',
-	'שוב',
-	'של',
-	'שם',
-	'תמיד',
-);
diff --git "[ORIGINAL]/vse\\similartopics/language/hr/acp_similar_topics.php" "[FORUM_EXT]/vse\\similartopics/language/hr/acp_similar_topics.php"
--- "[ORIGINAL]/vse\\similartopics/language/hr/acp_similar_topics.php"
+++ "[FORUM_EXT]/vse\\similartopics/language/hr/acp_similar_topics.php"
@@ -43,22 +43,19 @@ $lang = array_merge($lang, array(
 	'PST_EXPLAIN'		=> 'Ovdje možeš o[ne]mogućiti prikaz liste sličnih [povezanih] tema na dnu stranice trenutne teme.',
 	'PST_LEGEND1'		=> 'Opće postavke',
 	'PST_ENABLE'		=> 'Prikaži Slične teme',
-	'PST_ENABLE_EXPLAIN'=> 'Show similar topics in topic discussion threads.',
 	'PST_LEGEND2'		=> 'Osnovne postavke',
 	'PST_LIMIT'			=> 'Broj sličnih tema za prikaz',
 	'PST_LIMIT_EXPLAIN'	=> 'Određivanje prikaza broja sličnih tema [zadano=5].',
 	'PST_TIME'			=> 'Razdoblje pretraživanja',
-	'PST_TIME_EXPLAIN'	=> 'Određivanje razdoblje pretraživanja broja sličnih tema [zadano=godina].<br>Npr. ukoliko je vrijednost postavljena na 5, sistem će prikaz(iv)ati slične teme unazad 5 dana.',
+	'PST_TIME_EXPLAIN'	=> 'Određivanje razdoblje pretraživanja broja sličnih tema [zadano=godina].<br />Npr. ukoliko je vrijednost postavljena na 5, sistem će prikaz(iv)ati slične teme unazad 5 dana.',
 	'PST_YEARS'			=> 'Godina/e',
 	'PST_MONTHS'		=> 'Mjesec/a/i',
 	'PST_WEEKS'			=> 'Tjedan/na/a',
 	'PST_DAYS'			=> 'Dan/a',
 	'PST_CACHE'			=> 'Trajanje sličnih tema pohranjenih u priručnu memoriju',
 	'PST_CACHE_EXPLAIN'	=> 'Slične teme, pohranjene u priručnu memoriju, bit će izbrisane, iz priručne memorije, po isteku [u sekundama] postavljenog vremena [0=onemogućeno].',
-	'PST_DYNAMIC'		=> 'Display dynamic similar topics',
-	'PST_DYNAMIC_EXPLAIN'=> 'Show similar topics as users type in the topic title field when creating new topics.',
 	'PST_SENSE'			=> 'Search sensitivity',
-	'PST_SENSE_EXPLAIN'	=> 'For MySQL or Postgres databases, you can set the search sensitivity to a value between 1 and 10. Use a lower number if you are not seeing any similar topics. Recommended setting: %d',
+	'PST_SENSE_EXPLAIN'	=> 'Set the search sensitivity to a value between 1 and 10. Use a lower number if you are not seeing any similar topics. Recommended settings: For “phpbb_topics” database tables using InnoDB use 1; for MyISAM use 5.',
 	'PST_LEGEND3'		=> 'Postavke foruma',
 	'PST_NOSHOW_LIST'	=> 'Ne prikazuj u',
 	'PST_NOSHOW_TITLE'	=> 'Ne prikazuj slične teme u',
@@ -67,14 +64,14 @@ $lang = array_merge($lang, array(
 	'PST_STANDARD'		=> 'Standardno',
 	'PST_ADVANCED'		=> 'Napredno',
 	'PST_ADVANCED_TITLE'=> 'Klikni za podešavanje naprednih postavki sličnih tema u/za',
-	'PST_ADVANCED_EXP'	=> 'Ukoliko želiš da slične teme, iz određenih pretražljivih foruma, budu prikazane na <strong>%s</strong>, označi [odaberi] željene forume.<br><br>Ukoliko želiš da slične teme, iz svih pretražljivih foruma, budu prikazane na forumu, nemoj označiti [odabrati] niti jedan forum.<br><br>Forume možeš (od)označavati korištenjem [pritisnute tipke] <code>CTRL</code> i kliktanjem [mišem].',
+	'PST_ADVANCED_EXP'	=> 'Ukoliko želiš da slične teme, iz određenih pretražljivih foruma, budu prikazane na <strong>%s</strong>, označi [odaberi] željene forume.<br /><br />Ukoliko želiš da slične teme, iz svih pretražljivih foruma, budu prikazane na forumu, nemoj označiti [odabrati] niti jedan forum.<br /><br />Forume možeš (od)označavati korištenjem [pritisnute tipke] <code>CTRL</code> i kliktanjem [mišem].',
 	'PST_ADVANCED_FORUM'=> 'Napredne postavke foruma',
 	'PST_DESELECT_ALL'	=> 'Odoznači sve',
 	'PST_LEGEND4'		=> 'Opcionalne postavke',
 	'PST_WORDS'			=> 'Ignorirane riječi',
-	'PST_WORDS_EXPLAIN'	=> 'Popis riječi koje će biti ignorirane prilikom pronalaženja sličnih tema [zadano su ignorirane riječi koje su navedene ako učestale].<br>Riječi odvoji razmacima. Neosjetljivo na velika/mala slova.',
+	'PST_WORDS_EXPLAIN'	=> 'Popis riječi koje će biti ignorirane prilikom pronalaženja sličnih tema [zadano su ignorirane riječi koje su navedene ako učestale].<br />Riječi odvoji razmacima. Neosjetljivo na velika/mala slova.',
 	'PST_SAVED'			=> 'Postavke sličnih tema su ažurirane.',
-	'PST_FORUM_INFO'	=> '“Ne prikazuj u”: neće prikaz(iv)ati slične teme u odabranim forumima.<br>“Ne pretražuj u”: neće pretraž(iv)ati slične teme u odabranim forumima.',
-	'PST_NO_COMPAT'		=> 'Slične teme nisu kompatibilne s forumom.<br>Pokreću se samo na/u MySQL 4 ili MySQL 5 ili PostgreSQL bazi podataka.',
+	'PST_FORUM_INFO'	=> '“Ne prikazuj u”: neće prikaz(iv)ati slične teme u odabranim forumima.<br />“Ne pretražuj u”: neće pretraž(iv)ati slične teme u odabranim forumima.',
+	'PST_NO_COMPAT'		=> 'Slične teme nisu kompatibilne s forumom.<br />Pokreću se samo na/u MySQL 4 ili MySQL 5 ili PostgreSQL bazi podataka.',
 	'PST_ERR_CONFIG'	=> 'Previše forumi su označeni na popisu foruma. Pokušajte ponovno s manjim izborom.',
 ));
diff --git "[ORIGINAL]/vse\\similartopics/language/it/acp_similar_topics.php" "[FORUM_EXT]/vse\\similartopics/language/it/acp_similar_topics.php"
--- "[ORIGINAL]/vse\\similartopics/language/it/acp_similar_topics.php"
+++ "[FORUM_EXT]/vse\\similartopics/language/it/acp_similar_topics.php"
@@ -42,7 +42,6 @@ $lang = array_merge($lang, array(
 	'PST_EXPLAIN'		=> '“Argomenti simili” mostra un elenco di argomenti simili in fondo alla pagina dell’argomento corrente.',
 	'PST_LEGEND1'		=> 'Impostazioni generali',
 	'PST_ENABLE'		=> 'Mostra argomenti simili',
-	'PST_ENABLE_EXPLAIN'=> 'Show similar topics in topic discussion threads.',
 	'PST_LEGEND2'		=> 'Impostazioni caricamento',
 	'PST_LIMIT'			=> 'Numero argomenti simili da mostrare',
 	'PST_LIMIT_EXPLAIN'	=> 'È possibile definire quanti topic simili mostrare; il valore predefinito è 5.',
@@ -54,10 +53,8 @@ $lang = array_merge($lang, array(
 	'PST_DAYS'			=> 'Giorni',
 	'PST_CACHE'			=> 'Lunghezza cache',
 	'PST_CACHE_EXPLAIN'	=> 'Gli argomenti salvati nella cache saranno rimossi dopo il periodo di tempo (in secondi) specificato. Impostare a 0 per disabilitare la cache di argomenti simili.',
-	'PST_DYNAMIC'		=> 'Display dynamic similar topics',
-	'PST_DYNAMIC_EXPLAIN'=> 'Show similar topics as users type in the topic title field when creating new topics.',
 	'PST_SENSE'			=> 'Search sensitivity',
-	'PST_SENSE_EXPLAIN'	=> 'For MySQL or Postgres databases, you can set the search sensitivity to a value between 1 and 10. Use a lower number if you are not seeing any similar topics. Recommended setting: %d',
+	'PST_SENSE_EXPLAIN'	=> 'Set the search sensitivity to a value between 1 and 10. Use a lower number if you are not seeing any similar topics. Recommended settings: For “phpbb_topics” database tables using InnoDB use 1; for MyISAM use 5.',
 	'PST_LEGEND3'		=> 'Impostazioni forum',
 	'PST_NOSHOW_LIST'	=> 'Non mostrare in',
 	'PST_NOSHOW_TITLE'	=> 'Non mostrare argomenti simili in',
@@ -66,14 +63,14 @@ $lang = array_merge($lang, array(
 	'PST_STANDARD'		=> 'Base',
 	'PST_ADVANCED'		=> 'Avanzate',
 	'PST_ADVANCED_TITLE'=> 'Cliccare per configurare le impostazioni avanzate per',
-	'PST_ADVANCED_EXP'	=> 'È possibile selezionare i forum in cui cercare argomenti simili. Solo gli argomenti trovati nei forum selezionati saranno mostrati in <strong>%s</strong>.<br><br>Per la ricerca in tutti i forum disponibili, non selezionare alcun forum.<br><br>Per la selezione di più forum, tenere premuto <samp>CTRL</samp> (o <samp>&#8984;CMD</samp> su Mac) e cliccare.',
+	'PST_ADVANCED_EXP'	=> 'È possibile selezionare i forum in cui cercare argomenti simili. Solo gli argomenti trovati nei forum selezionati saranno mostrati in <strong>%s</strong>.<br /><br />Per la ricerca in tutti i forum disponibili, non selezionare alcun forum.<br /><br />Per la selezione di più forum, tenere premuto <samp>CTRL</samp> (o <samp>&#8984;CMD</samp> su Mac) e cliccare.',
 	'PST_ADVANCED_FORUM'=> 'Impostazioni avanzate forum',
 	'PST_DESELECT_ALL'	=> 'Deseleziona tutti',
 	'PST_LEGEND4'		=> 'Impostazioni opzionali',
 	'PST_WORDS'			=> 'Termini speciali da ignorare',
-	'PST_WORDS_EXPLAIN'	=> 'È possibile escludere alcuni termini dalla ricerca di argomenti simili. I termini devono essere separati da uno spazio; non è fatta distinzione tra maiuscole e minuscole.<br><br>Nota: <em>i termini considerati comuni della propria lingua sono ignorati per impostazione predefinita.</em>',
+	'PST_WORDS_EXPLAIN'	=> 'È possibile escludere alcuni termini dalla ricerca di argomenti simili. I termini devono essere separati da uno spazio; non è fatta distinzione tra maiuscole e minuscole.<br /><br />Nota: <em>i termini considerati comuni della propria lingua sono ignorati per impostazione predefinita.</em>',
 	'PST_SAVED'			=> 'Impostazioni Argomenti simili aggiornate',
-	'PST_FORUM_INFO'	=> '“Non mostrare in”: nei forum selezionati, non saranno mostrati gli argomenti simili.<br>“Non cercare in”: nei forum selezionati, non saranno cercati gli argomenti simili.',
+	'PST_FORUM_INFO'	=> '“Non mostrare in”: nei forum selezionati, non saranno mostrati gli argomenti simili.<br />“Non cercare in”: nei forum selezionati, non saranno cercati gli argomenti simili.',
 	'PST_NO_COMPAT'		=> '“Argomenti simili” non è compatibile con la propria board: quest’estensione richiede un database MySQL versione 4 o 5 o PostgreSQL.',
 	'PST_ERR_CONFIG'	=> 'Troppi forum selezionati in elenco, ridurre la selezione.',
 ));
diff --git "[ORIGINAL]/vse\\similartopics/language/ja/acp_similar_topics.php" "[FORUM_EXT]/vse\\similartopics/language/ja/acp_similar_topics.php"
--- "[ORIGINAL]/vse\\similartopics/language/ja/acp_similar_topics.php"
+++ "[FORUM_EXT]/vse\\similartopics/language/ja/acp_similar_topics.php"
@@ -42,7 +42,6 @@ $lang = array_merge($lang, array(
 	'PST_EXPLAIN'		=> 'Precise Similar Topics（正確な類似トピック）は現在のトピックのページ下部に類似(関連)したトピックの一覧を表示します。',
 	'PST_LEGEND1'		=> '一般設定',
 	'PST_ENABLE'		=> '類似トピックの表示',
-	'PST_ENABLE_EXPLAIN'=> 'Show similar topics in topic discussion threads.',
 	'PST_LEGEND2'		=> '読み込み設定',
 	'PST_LIMIT'			=> '表示する類似トピック数',
 	'PST_LIMIT_EXPLAIN'	=> '類似トピックの表示数を定義できます。デフォルトは5トピックです。',
@@ -54,10 +53,8 @@ $lang = array_merge($lang, array(
 	'PST_DAYS'			=> '日間',
 	'PST_CACHE'			=> '類似トピックのキャッシュの長さ',
 	'PST_CACHE_EXPLAIN'	=> 'キャッシュされた類似トピックはこの時間の後に期限がきれます。類似トピックのキャッシュを無効にしたい場合、0を設定します。',
-	'PST_DYNAMIC'		=> 'Display dynamic similar topics',
-	'PST_DYNAMIC_EXPLAIN'=> 'Show similar topics as users type in the topic title field when creating new topics.',
 	'PST_SENSE'			=> '検索感度',
-	'PST_SENSE_EXPLAIN'	=> '検索感度を 1 から 10 の間で設定します。類似トピックが一つも表示されない場合は低い値を使用してください。推奨設定: %d',
+	'PST_SENSE_EXPLAIN'	=> '検索感度を 1 から 10 の間で設定します。類似トピックが一つも表示されない場合は低い値を使用してください。推奨設定: “phpbb_topics” DBテーブルが InnoDB を使用していれば 1 を、MyISAMを使用していれば 5 を設定してください。',
 	'PST_LEGEND3'		=> 'フォーラム設定',
 	'PST_NOSHOW_LIST'	=> '表示しない',
 	'PST_NOSHOW_TITLE'	=> '類似トピックを表示しません',
@@ -66,14 +63,14 @@ $lang = array_merge($lang, array(
 	'PST_STANDARD'		=> '標準',
 	'PST_ADVANCED'		=> 'カスタム',
 	'PST_ADVANCED_TITLE'=> '次の類似トピックのカスタム設定をするにはクリック:',
-	'PST_ADVANCED_EXP'	=> 'ここでは類似トピックを取ってくる特定のフォーラムを選択できます。ここで選択したフォーラムで見つかった類似トピックのみ<strong>%s</strong>に表示されます。<br><br>全ての検索可能なフォーラムから類似トピックをこのフォーラムに表示したい場合、どのフォーラムも選択しないでください。<br><br><samp>CTRL</samp> (または MACでは<samp>&#8984;CMD</samp>)を押しながらクリックすることで複数のフォーラムを選択します。',
+	'PST_ADVANCED_EXP'	=> 'ここでは類似トピックを取ってくる特定のフォーラムを選択できます。ここで選択したフォーラムで見つかった類似トピックのみ<strong>%s</strong>に表示されます。<br /><br />全ての検索可能なフォーラムから類似トピックをこのフォーラムに表示したい場合、どのフォーラムも選択しないでください。<br /><br /><samp>CTRL</samp> (または MACでは<samp>&#8984;CMD</samp>)を押しながらクリックすることで複数のフォーラムを選択します。',
 	'PST_ADVANCED_FORUM'=> 'カスタムフォーラム設定',
 	'PST_DESELECT_ALL'	=> '全ての選択を解除',
 	'PST_LEGEND4'		=> 'オプション設定',
 	'PST_WORDS'			=> '無視する単語',
 	'PST_WORDS_EXPLAIN'	=> '類似トピックを検索する際に無視すべき固有の単語を追加します（注: 現在の言語で共通とみなされている単語は、すでにデフォルトでは無視されます) 。スペースで各単語を区切ります。大文字小文字は区別しません。',
 	'PST_SAVED'			=> '類似トピック設定を更新しました',
-	'PST_FORUM_INFO'	=> '“表示しない”: 選択したフォーラムで類似トピックを表示しません。<br>“検索しない” : 選択したフォーラムで類似トピックを検索しません。',
+	'PST_FORUM_INFO'	=> '“表示しない”: 選択したフォーラムで類似トピックを表示しません。<br />“検索しない” : 選択したフォーラムで類似トピックを検索しません。',
 	'PST_NO_COMPAT'		=> '類似トピックはあなたのフォーラムと互換性がありません。類似トピックはMySQL4/5/PostgreSQLのデータベースでのみ実行できます。',
 	'PST_ERR_CONFIG'	=> 'あまりにも多くのフォーラムが、フォーラムのリストにマークされています。少ない選択数で再度お試しください。',
 ));
diff --git "[ORIGINAL]/vse\\similartopics/language/ja/search_ignore_words.php" "[ORIGINAL]/vse\\similartopics/language/ja/search_ignore_words.php"
deleted file mode 100644
--- "[ORIGINAL]/vse\\similartopics/language/ja/search_ignore_words.php"
+++ /dev/null
@@ -1,49 +0,0 @@
-<?php
-/**
- *
- * Precise Similar Topics
- *
- * @copyright (c) 2025 Matt Friedman
- * @license GNU General Public License, version 2 (GPL-2.0)
- *
- * This [ja] language list of stop words created by Matt Friedman for Similar Topics
- *
- */
-
-if (!defined('IN_PHPBB'))
-{
-   exit;
-}
-
-$words = array(
-	'あの',
-	'ある',
-	'いる',
-	'から',
-	'この',
-	'その',
-	'それ',
-	'だけ',
-	'です',
-	'では',
-	'でも',
-	'という',
-	'として',
-	'なる',
-	'には',
-	'また',
-	'まで',
-	'もう',
-	'もの',
-	'より',
-	'れる',
-	'われ',
-	'を',
-	'が',
-	'で',
-	'と',
-	'に',
-	'は',
-	'も',
-	'や',
-);
diff --git "[ORIGINAL]/vse\\similartopics/language/nl/acp_similar_topics.php" "[FORUM_EXT]/vse\\similartopics/language/nl/acp_similar_topics.php"
--- "[ORIGINAL]/vse\\similartopics/language/nl/acp_similar_topics.php"
+++ "[FORUM_EXT]/vse\\similartopics/language/nl/acp_similar_topics.php"
@@ -42,7 +42,6 @@ $lang = array_merge($lang, array(
 	'PST_EXPLAIN'		=> 'Precise Similar Topics toont een lijst van soortgelijke onderwerpen aan de onderkant van de pagina van het huidige onderwerpen.',
 	'PST_LEGEND1'		=> 'Algemene instellingen',
 	'PST_ENABLE'		=> 'Vergelijkbare onderwerpen inschakelen',
-	'PST_ENABLE_EXPLAIN'=> 'Show similar topics in topic discussion threads.',
 	'PST_LEGEND2'		=> 'Laad instellingen',
 	'PST_LIMIT'			=> 'Aantal vergelijkbare onderwerpen weer te geven',
 	'PST_LIMIT_EXPLAIN'	=> 'Hier kunt u opgeven hoeveel soortgelijke onderwerpen weer te laten geven. Standaard is dit 5 onderwerpen.',
@@ -54,10 +53,8 @@ $lang = array_merge($lang, array(
 	'PST_DAYS'			=> 'Dagen',
 	'PST_CACHE'			=> 'Cache lengte vergelijkbare onderwerpen',
 	'PST_CACHE_EXPLAIN'	=> 'Cache vergelijkbare onderwerpen verloopt na deze tijd in seconden. Stel in op 0 als u dit wilt uitschakelen.',
-	'PST_DYNAMIC'		=> 'Display dynamic similar topics',
-	'PST_DYNAMIC_EXPLAIN'=> 'Show similar topics as users type in the topic title field when creating new topics.',
 	'PST_SENSE'			=> 'Search sensitivity',
-	'PST_SENSE_EXPLAIN'	=> 'For MySQL or Postgres databases, you can set the search sensitivity to a value between 1 and 10. Use a lower number if you are not seeing any similar topics. Recommended setting: %d',
+	'PST_SENSE_EXPLAIN'	=> 'Set the search sensitivity to a value between 1 and 10. Use a lower number if you are not seeing any similar topics. Recommended settings: For “phpbb_topics” database tables using InnoDB use 1; for MyISAM use 5.',
 	'PST_LEGEND3'		=> 'Forum instellingen',
 	'PST_NOSHOW_LIST'	=> 'Niet weergeven in',
 	'PST_NOSHOW_TITLE'	=> 'Vergelijkbare Onderwerpen Niet weergeven in',
@@ -66,14 +63,14 @@ $lang = array_merge($lang, array(
 	'PST_STANDARD'		=> 'Standaard',
 	'PST_ADVANCED'		=> 'Geavanceerd',
 	'PST_ADVANCED_TITLE'=> 'Klik om Geavanceerde vergelijkbare onderwerpen in te stellen voor',
-	'PST_ADVANCED_EXP'	=> 'Hier kunt u specifieke forums selecteren om de soortgelijke onderwerpen uit te halen. Alleen vergelijkbare onderwerpen gevonden in de forums die u hier selecteert worden weergegeven in <strong>%s</strong>.<br><br>Selecteer helemaal geen forum als u wilt dat vergelijkbare onderwerpen uit alle doorzoekbare forums worden weergegeven in dit forum.<br><br>Selecteer/Deselecteer meerdere forums door <code>CTRL</code> ingedrukt te houden en forums aan te klikken.',
+	'PST_ADVANCED_EXP'	=> 'Hier kunt u specifieke forums selecteren om de soortgelijke onderwerpen uit te halen. Alleen vergelijkbare onderwerpen gevonden in de forums die u hier selecteert worden weergegeven in <strong>%s</strong>.<br /><br />Selecteer helemaal geen forum als u wilt dat vergelijkbare onderwerpen uit alle doorzoekbare forums worden weergegeven in dit forum.<br /><br />Selecteer/Deselecteer meerdere forums door <code>CTRL</code> ingedrukt te houden en forums aan te klikken.',
 	'PST_ADVANCED_FORUM'=> 'Geavanceerd forum instellingen',
 	'PST_DESELECT_ALL'	=> 'Selectie opheffen',
 	'PST_LEGEND4'		=> 'Optionele instellingen',
 	'PST_WORDS'			=> 'Speciale woorden om te negeren',
 	'PST_WORDS_EXPLAIN'	=> 'Voeg speciale woorden toe die uniek zijn aan uw forum en moeten genegeerd worden bij het vinden van vergelijkbare onderwerpen. (Opgelet: woorden die momenteel als veelvoorkomend worden beschouwd in uw taal, worden reeds standaard genegeerd.) Scheid elk woord met een spatie. Niet hoofdlettergevoelig.',
 	'PST_SAVED'			=> 'Vergelijkbare onderwerpen instellingen bijgewerkt',
-	'PST_FORUM_INFO'	=> '“Niet weergeven in”: Soortgelijke onderwerpen worden niet weergegeven in de geselecteerde forums.<br>“Niet zoeken in” : Zal niet zoeken in de geselecteerde forums voor vergelijkbare onderwerpen.',
+	'PST_FORUM_INFO'	=> '“Niet weergeven in”: Soortgelijke onderwerpen worden niet weergegeven in de geselecteerde forums.<br />“Niet zoeken in” : Zal niet zoeken in de geselecteerde forums voor vergelijkbare onderwerpen.',
 	'PST_NO_COMPAT'		=> 'Vergelijkbare onderwerpen zal niet werken op uw forum. Vergelijkbare onderwerpen vereist een PostgreSQL, MySQL 4 of 5 MySQL database.',
 	'PST_ERR_CONFIG'	=> 'Te veel fora werden gemarkeerd in de lijst van forums. Probeer het opnieuw met een kleinere selectie.',
 ));
diff --git "[ORIGINAL]/vse\\similartopics/language/pl/acp_similar_topics.php" "[FORUM_EXT]/vse\\similartopics/language/pl/acp_similar_topics.php"
--- "[ORIGINAL]/vse\\similartopics/language/pl/acp_similar_topics.php"
+++ "[FORUM_EXT]/vse\\similartopics/language/pl/acp_similar_topics.php"
@@ -43,7 +43,6 @@ $lang = array_merge($lang, array(
 	'PST_EXPLAIN'		=> 'Rozszerzenie Precise Similar Topics wyświetla listę podobnych tematów na dole strony bieżącego tematu.',
 	'PST_LEGEND1'		=> 'Ustawienia ogólne',
 	'PST_ENABLE'		=> 'Włącz podobne tematy',
-	'PST_ENABLE_EXPLAIN'=> 'Show similar topics in topic discussion threads.',
 	'PST_LEGEND2'		=> 'Załaduj ustawienia',
 	'PST_LIMIT'			=> 'Liczba wyświetlanych tematów',
 	'PST_LIMIT_EXPLAIN'	=> 'Tutaj możesz określić, ile podobnych tematów zostanie wyświetlonych. Domyślnie jest to 5 tematów.',
@@ -55,10 +54,8 @@ $lang = array_merge($lang, array(
 	'PST_DAYS'			=> 'Dzień',
 	'PST_CACHE'			=> 'Czas trwania pamięci podręcznej',
 	'PST_CACHE_EXPLAIN'	=> 'Pamięć podręczna wygasa po upływie tego czasu, w sekundach. Ustaw na 0, jeśli chcesz wyłączyć pamięć podręczną dla podobnych tematów.',
-	'PST_DYNAMIC'		=> 'Display dynamic similar topics',
-	'PST_DYNAMIC_EXPLAIN'=> 'Show similar topics as users type in the topic title field when creating new topics.',
 	'PST_SENSE'			=> 'Czułość wyszukiwania',
-	'PST_SENSE_EXPLAIN'	=> 'Ustaw czułość wyszukiwania na wartość pomiędzy 1 do 10. Użyj niższej liczby, jeśli nie widzisz żadnych podobnych tematów. Zalecane ustawienia: %d',
+	'PST_SENSE_EXPLAIN'	=> 'Ustaw czułość wyszukiwania na wartość pomiędzy 1 do 10. Użyj niższej liczby, jeśli nie widzisz żadnych podobnych tematów. Zalecane ustawienia: Dla tabel bazy danych “phpbb_topics” używających InnoDB użyj 1; dla MyISAM użyj 5.',
 	'PST_LEGEND3'		=> 'Ustawienia forum',
 	'PST_NOSHOW_LIST'	=> 'Nie wyświetlaj w',
 	'PST_NOSHOW_TITLE'	=> 'Nie wyświetlaj podobnych tematów w',
@@ -67,14 +64,14 @@ $lang = array_merge($lang, array(
 	'PST_STANDARD'		=> 'Standard',
 	'PST_ADVANCED'		=> 'Zaawansowane',
 	'PST_ADVANCED_TITLE'=> 'Kliknij, aby ustawić zaawansowane ustawienia dla',
-	'PST_ADVANCED_EXP'	=> 'Tutaj możesz wybrać konkretne fora dla wyświetlania podobnych tematów. Tylko podobne tematy znalezione na wybranych forach będą wyświetlane w <strong>%s</strong>.<br><br>Nie należy wybierać żadnych, jeśli chcesz aby podobne tematy były wyszukiwane we wszystkich forach.<br><br>Zaznacz/odznacz wiele działów poprzez przytrzymanie klawisza <code>CTRL</code> i klikanie.',
+	'PST_ADVANCED_EXP'	=> 'Tutaj możesz wybrać konkretne fora dla wyświetlania podobnych tematów. Tylko podobne tematy znalezione na wybranych forach będą wyświetlane w <strong>%s</strong>.<br /><br />Nie należy wybierać żadnych, jeśli chcesz aby podobne tematy były wyszukiwane we wszystkich forach.<br /><br />Zaznacz/odznacz wiele działów poprzez przytrzymanie klawisza <code>CTRL</code> i klikanie.',
 	'PST_ADVANCED_FORUM'=> 'Zaawansowane ustawienia forum',
 	'PST_DESELECT_ALL'	=> 'Odznacz wszystko',
 	'PST_LEGEND4'		=> 'Ustawienia dodatkowe',
 	'PST_WORDS'			=> 'Specjalne słowa do zignorowania',
 	'PST_WORDS_EXPLAIN'	=> 'Dodaj specjalne unikalne słowa, które powinny być zignorowane podczas wyszukiwania podobnych tematów. (Notka: Słowa, które są obecnie uważane za powszechne w twoim języku, są już domyślnie ignorowane.) Oddziel każde słowo spacją. Bez względu na wielkość liter.',
 	'PST_SAVED'			=> 'Zaktualizowano ustawienia podobnych tematów',
-	'PST_FORUM_INFO'	=> '“Nie wyświetlaj w”: Nie będzie wyświetlać podobnych tematów w wybranych forach.<br>“Nie szukaj w”: Nie będzie wyszukiwać podobnych tematów w wybranych forach.',
+	'PST_FORUM_INFO'	=> '“Nie wyświetlaj w”: Nie będzie wyświetlać podobnych tematów w wybranych forach.<br />“Nie szukaj w”: Nie będzie wyszukiwać podobnych tematów w wybranych forach.',
 	'PST_NO_COMPAT'		=> 'Rozszerzenie podobne tematy nie jest kompatybilne z twoim forum. Rozszerzenie podobne tematy będzie działać tylko w bazie danych MySQL lub PostgreSQL.',
 	'PST_ERR_CONFIG'	=> 'Zbyt wiele forów zostało oznaczonych na liście forów. Proszę, spróbuj ponownie z mniejszym wyborem.',
 ));
diff --git "[ORIGINAL]/vse\\similartopics/language/pt/acp_similar_topics.php" "[FORUM_EXT]/vse\\similartopics/language/pt/acp_similar_topics.php"
--- "[ORIGINAL]/vse\\similartopics/language/pt/acp_similar_topics.php"
+++ "[FORUM_EXT]/vse\\similartopics/language/pt/acp_similar_topics.php"
@@ -43,7 +43,6 @@ $lang = array_merge($lang, array(
 	'PST_EXPLAIN'		=> 'Precise Similar Topics apresenta uma lista de temas semelhantes, na parte inferior da página do tópico atual.',
 	'PST_LEGEND1'		=> 'Configurações gerais',
 	'PST_ENABLE'		=> 'Ativar Tópicos Semelhantes',
-	'PST_ENABLE_EXPLAIN'=> 'Show similar topics in topic discussion threads.',
 	'PST_LEGEND2'		=> 'Carregar configurações',
 	'PST_LIMIT'			=> 'Número de Tópicos Semelhantes a exibir',
 	'PST_LIMIT_EXPLAIN'	=> 'Indique o número de Tópicos Semelhantes a exibir. O padrão é 5 Tópicos.',
@@ -55,10 +54,8 @@ $lang = array_merge($lang, array(
 	'PST_DAYS'			=> 'Dias',
 	'PST_CACHE'			=> 'Duração da Cache de Tópicos Semelhantes',
 	'PST_CACHE_EXPLAIN'	=> 'A Cache de Tópicos Semelhantes vai expirar após esse tempo, em segundos. 0 para desativar a Cache de Tópicos Semelhantes.',
-	'PST_DYNAMIC'		=> 'Display dynamic similar topics',
-	'PST_DYNAMIC_EXPLAIN'=> 'Show similar topics as users type in the topic title field when creating new topics.',
 	'PST_SENSE'			=> 'Search sensitivity',
-	'PST_SENSE_EXPLAIN'	=> 'For MySQL or Postgres databases, you can set the search sensitivity to a value between 1 and 10. Use a lower number if you are not seeing any similar topics. Recommended setting: %d',
+	'PST_SENSE_EXPLAIN'	=> 'Set the search sensitivity to a value between 1 and 10. Use a lower number if you are not seeing any similar topics. Recommended settings: For “phpbb_topics” database tables using InnoDB use 1; for MyISAM use 5.',
 	'PST_LEGEND3'		=> 'Configurações do fórum',
 	'PST_NOSHOW_LIST'	=> 'Não exibir em',
 	'PST_NOSHOW_TITLE'	=> 'Não exibir Tópicos Semelhantes em',
@@ -67,14 +64,14 @@ $lang = array_merge($lang, array(
 	'PST_STANDARD'		=> 'Norma',
 	'PST_ADVANCED'		=> 'Avançado',
 	'PST_ADVANCED_TITLE'=> 'Clique para configurar definições avançadas de Tópicos Semelhantes para',
-	'PST_ADVANCED_EXP'	=> 'Aqui pode selecionar os Fóruns de onde serão extraidos os Tópicos Semelhantes. Apenas Tópicos Semelhantes encontrados nos Fóruns que selecionar aqui serão exibidos em <strong>%s</strong>.<br><br>Não selecione nenhum se deseja Tópicos Semelhantes de todos os Fóruns pesquisáveis a serem exibidos neste Fórum.<br><br>Selecione/Desmarque múltiplos Fóruns clicando <code>CTRL</code> e clicando.',
+	'PST_ADVANCED_EXP'	=> 'Aqui pode selecionar os Fóruns de onde serão extraidos os Tópicos Semelhantes. Apenas Tópicos Semelhantes encontrados nos Fóruns que selecionar aqui serão exibidos em <strong>%s</strong>.<br /><br />Não selecione nenhum se deseja Tópicos Semelhantes de todos os Fóruns pesquisáveis a serem exibidos neste Fórum.<br /><br />Selecione/Desmarque múltiplos Fóruns clicando <code>CTRL</code> e clicando.',
 	'PST_ADVANCED_FORUM'=> 'Configurações avançadas de fórum',
 	'PST_DESELECT_ALL'	=> 'Desmarcar todos',
 	'PST_LEGEND4'		=> 'Configurações opcionais',
 	'PST_WORDS'			=> 'Palavras especiais para ignorar',
 	'PST_WORDS_EXPLAIN'	=> 'Adicionar palavras especiais exclusivas para o seu fórum que deve ser ignorado em topicos semelhantes. (Nota: Palavras comuns na sua língua são ignorados por padrão.) Separar cada palavra com um espaço. De caso não é sensível.',
 	'PST_SAVED'			=> 'As configurações de Tópicos Semelhantes foram atualizadas',
-	'PST_FORUM_INFO'	=> '<strong>Não exibir em</strong>: Desativa a exibição de Tópicos Semelhantes nos Fóruns selecionados.<br><strong>Não pesquisar em</strong>: Ignora os Fóruns selecionados na pesquisa de Tópicos Semelhantes.',
+	'PST_FORUM_INFO'	=> '<strong>Não exibir em</strong>: Desativa a exibição de Tópicos Semelhantes nos Fóruns selecionados.<br /><strong>Não pesquisar em</strong>: Ignora os Fóruns selecionados na pesquisa de Tópicos Semelhantes.',
 	'PST_NO_COMPAT'		=> 'Similar Topics não irá funcionar com seu Fórum. Similar Topics requer uma Base de Dados MySQL 4 ou MySQL 5 ou PostgreSQL.',
 	'PST_ERR_CONFIG'	=> 'Too muitos fóruns foram marcados na lista de fóruns. Por favor, tente novamente com uma seleção menor.',
 ));
diff --git "[ORIGINAL]/vse\\similartopics/language/pt_br/acp_similar_topics.php" "[FORUM_EXT]/vse\\similartopics/language/pt_br/acp_similar_topics.php"
--- "[ORIGINAL]/vse\\similartopics/language/pt_br/acp_similar_topics.php"
+++ "[FORUM_EXT]/vse\\similartopics/language/pt_br/acp_similar_topics.php"
@@ -43,7 +43,6 @@ $lang = array_merge($lang, array(
 	'PST_EXPLAIN'		=> 'Tópicos Semelhantes apresenta uma lista de tópicos semelhantes, na parte inferior da página do tópico atual.',
 	'PST_LEGEND1'		=> 'Configurações gerais',
 	'PST_ENABLE'		=> 'Ativar Tópicos Semelhantes',
-	'PST_ENABLE_EXPLAIN'=> 'Show similar topics in topic discussion threads.',
 	'PST_LEGEND2'		=> 'Carregar configurações',
 	'PST_LIMIT'			=> 'Número de Tópicos Semelhantes a exibir',
 	'PST_LIMIT_EXPLAIN'	=> 'Indique o número de Tópicos Semelhantes a exibir. O padrão é 5 Tópicos.',
@@ -55,10 +54,8 @@ $lang = array_merge($lang, array(
 	'PST_DAYS'			=> 'Dias',
 	'PST_CACHE'			=> 'Duração da Cache de Tópicos Semelhantes',
 	'PST_CACHE_EXPLAIN'	=> 'A Cache de Tópicos Semelhantes vai expirar após esse tempo, em segundos. 0 para desativar a Cache de Tópicos Semelhantes.',
-	'PST_DYNAMIC'		=> 'Display dynamic similar topics',
-	'PST_DYNAMIC_EXPLAIN'=> 'Show similar topics as users type in the topic title field when creating new topics.',
 	'PST_SENSE'			=> 'Sensibilidade de pesquisa',
-	'PST_SENSE_EXPLAIN'	=> 'Defina a sensibilidade da pesquisa para um valor entre 1 e 10. Use um número menor se você não estiver vendo tópicos semelhantes. Configurações recomendadas: %d',
+	'PST_SENSE_EXPLAIN'	=> 'Defina a sensibilidade da pesquisa para um valor entre 1 e 10. Use um número menor se você não estiver vendo tópicos semelhantes. Configurações recomendadas: Para tabelas de banco de dados “phpbb_topics” usando InnoDB use 1; para MyISAM use 5.',
 	'PST_LEGEND3'		=> 'Configurações do fórum',
 	'PST_NOSHOW_LIST'	=> 'Não exibir em',
 	'PST_NOSHOW_TITLE'	=> 'Não exibir Tópicos Semelhantes em',
@@ -67,14 +64,14 @@ $lang = array_merge($lang, array(
 	'PST_STANDARD'		=> 'Norma',
 	'PST_ADVANCED'		=> 'Avançado',
 	'PST_ADVANCED_TITLE'=> 'Clique para configurar definições avançadas de Tópicos Semelhantes para',
-	'PST_ADVANCED_EXP'	=> 'Aqui pode selecionar os Fóruns de onde serão extraidos os Tópicos Semelhantes. Apenas Tópicos Semelhantes encontrados nos Fóruns que selecionar aqui serão exibidos em <strong>%s</strong>.<br><br>Não selecione nenhum se deseja Tópicos Semelhantes de todos os Fóruns pesquisáveis a serem exibidos neste Fórum.<br><br>Selecione/Desmarque múltiplos Fóruns clicando <code>CTRL</code> e clicando.',
+	'PST_ADVANCED_EXP'	=> 'Aqui pode selecionar os Fóruns de onde serão extraidos os Tópicos Semelhantes. Apenas Tópicos Semelhantes encontrados nos Fóruns que selecionar aqui serão exibidos em <strong>%s</strong>.<br /><br />Não selecione nenhum se deseja Tópicos Semelhantes de todos os Fóruns pesquisáveis a serem exibidos neste Fórum.<br /><br />Selecione/Desmarque múltiplos Fóruns clicando <code>CTRL</code> e clicando.',
 	'PST_ADVANCED_FORUM'=> 'Configurações avançadas de fórum',
 	'PST_DESELECT_ALL'	=> 'Desmarcar todos',
 	'PST_LEGEND4'		=> 'Configurações opcionais',
 	'PST_WORDS'			=> 'Palavras especiais para ignorar',
 	'PST_WORDS_EXPLAIN'	=> 'Adicionar palavras especiais exclusivas para o seu fórum que deve ser ignorado em topicos semelhantes. (Nota: Palavras comuns na sua língua são ignorados por padrão.) Separar cada palavra com um espaço. De caso não é sensível.',
 	'PST_SAVED'			=> 'As configurações de Tópicos Semelhantes foram atualizadas',
-	'PST_FORUM_INFO'	=> '<strong>Não exibir em</strong>: Desativa a exibição de Tópicos Semelhantes nos Fóruns selecionados.<br><strong>Não pesquisar em</strong>: Ignora os Fóruns selecionados na pesquisa de Tópicos Semelhantes.',
+	'PST_FORUM_INFO'	=> '<strong>Não exibir em</strong>: Desativa a exibição de Tópicos Semelhantes nos Fóruns selecionados.<br /><strong>Não pesquisar em</strong>: Ignora os Fóruns selecionados na pesquisa de Tópicos Semelhantes.',
 	'PST_NO_COMPAT'		=> 'Tópicos Semelhantes não irá funcionar com seu Fórum. Similar Topics requer uma Base de Dados MySQL 4 ou MySQL 5 ou PostgreSQL.',
 	'PST_ERR_CONFIG'	=> 'Muitos fóruns foram marcados na lista de fóruns. Por favor, tente novamente com uma seleção menor.',
 ));
diff --git "[FORUM_EXT]/vse\\similartopics/language/pt_preao/acp_similar_topics.php" "[FORUM_EXT]/vse\\similartopics/language/pt_preao/acp_similar_topics.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/vse\\similartopics/language/pt_preao/acp_similar_topics.php"
@@ -0,0 +1,76 @@
+<?php
+/**
+*
+* Precise Similar Topics [English]
+*
+* @copyright (c) 2013 Matt Friedman
+* @license GNU General Public License, version 2 (GPL-2.0)
+*
+*/
+
+/**
+* DO NOT CHANGE
+*/
+if (!defined('IN_PHPBB'))
+{
+	exit;
+}
+
+if (empty($lang) || !is_array($lang))
+{
+	$lang = array();
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
+//
+// Some characters you may want to copy&paste:
+// ’ » “ ” …
+//
+
+$lang = array_merge($lang, array(
+	'PST_TITLE_ACP'		=> 'Precise Similar Topics',
+	'PST_EXPLAIN'		=> 'Precise Similar Topics displays a list of similar (related) topics at the bottom of the current topic’s page.',
+	'PST_LEGEND1'		=> 'General settings',
+	'PST_ENABLE'		=> 'Display Similar Topics',
+	'PST_LEGEND2'		=> 'Load settings',
+	'PST_LIMIT'			=> 'Number of Similar Topics to display',
+	'PST_LIMIT_EXPLAIN'	=> 'Here you can define how many similar topics to display. The default is 5 topics.',
+	'PST_TIME'			=> 'Search period',
+	'PST_TIME_EXPLAIN'	=> 'This option allows you to configure the Similar Topics search period. For example, if set to “5 days” the system will only show similar topics from within the last 5 days. The default is 1 year.',
+	'PST_YEARS'			=> 'Years',
+	'PST_MONTHS'		=> 'Months',
+	'PST_WEEKS'			=> 'Weeks',
+	'PST_DAYS'			=> 'Days',
+	'PST_CACHE'			=> 'Similar Topics cache length',
+	'PST_CACHE_EXPLAIN'	=> 'Cached similar topics will expire after this time, in seconds. Set to 0 if you want to disable the similar topics cache.',
+	'PST_SENSE'			=> 'Search sensitivity',
+	'PST_SENSE_EXPLAIN'	=> 'Set the search sensitivity to a value between 1 and 10. Use a lower number if you are not seeing any similar topics. Recommended settings: For “phpbb_topics” database tables using InnoDB use 1; for MyISAM use 5.',
+	'PST_LEGEND3'		=> 'Forum settings',
+	'PST_NOSHOW_LIST'	=> 'Do Not Display In',
+	'PST_NOSHOW_TITLE'	=> 'Do not display similar topics in',
+	'PST_IGNORE_SEARCH'	=> 'Do Not Search In',
+	'PST_IGNORE_TITLE'	=> 'Do not search for similar topics in',
+	'PST_STANDARD'		=> 'Standard',
+	'PST_ADVANCED'		=> 'Advanced',
+	'PST_ADVANCED_TITLE'=> 'Click to set up advanced similar topic settings for',
+	'PST_ADVANCED_EXP'	=> 'Here you can select specific forums to pull similar topics from. Only similar topics found in the forums you select here will be displayed in <strong>%s</strong>.<br /><br />Do not select any forums if you want similar topics from all searchable forums to be displayed in this forum.<br /><br />Select multiple forums by holding <samp>CTRL</samp> (or <samp>&#8984;CMD</samp> on Mac) and clicking.',
+	'PST_ADVANCED_FORUM'=> 'Advanced forum settings',
+	'PST_DESELECT_ALL'	=> 'Deselect all',
+	'PST_LEGEND4'		=> 'Optional settings',
+	'PST_WORDS'			=> 'Special words to ignore',
+	'PST_WORDS_EXPLAIN'	=> 'Add special words unique to your forum that should be ignored when finding similar topics. (Note: Words that are currently regarded as common in your language are already ignored by default.) Separate each word with a space. Case insensitive.',
+	'PST_SAVED'			=> 'Similar Topics settings updated',
+	'PST_FORUM_INFO'	=> '“Do Not Display In”: Will not show similar topics in the selected forums.<br />“Do Not Search In” : Will not search for similar topics in the selected forums.',
+	'PST_NO_COMPAT'		=> 'Similar Topics is not compatible with your forum. Similar Topics will only run on a MySQL or PostgreSQL database.',
+	'PST_ERR_CONFIG'	=> 'Too many forums were marked in the list of forums. Please try again with a smaller selection.',
+));
diff --git "[FORUM_EXT]/vse\\similartopics/language/pt_preao/info_acp_similar_topics.php" "[FORUM_EXT]/vse\\similartopics/language/pt_preao/info_acp_similar_topics.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/vse\\similartopics/language/pt_preao/info_acp_similar_topics.php"
@@ -0,0 +1,44 @@
+<?php
+/**
+*
+* Precise Similar Topics [English]
+*
+* @copyright (c) 2013 Matt Friedman
+* @license GNU General Public License, version 2 (GPL-2.0)
+*
+*/
+
+/**
+* DO NOT CHANGE
+*/
+if (!defined('IN_PHPBB'))
+{
+	exit;
+}
+
+if (empty($lang) || !is_array($lang))
+{
+	$lang = array();
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
+//
+// Some characters you may want to copy&paste:
+// ’ » “ ” …
+//
+
+$lang = array_merge($lang, array(
+	'PST_TITLE_ACP'		=> 'Precise Similar Topics',
+	'PST_SETTINGS'		=> 'Similar topics settings',
+	'PST_LOG_MSG'		=> '<strong>Altered Similar Topics settings</strong>',
+));
diff --git "[FORUM_EXT]/vse\\similartopics/language/pt_preao/permissions_similar_topics.php" "[FORUM_EXT]/vse\\similartopics/language/pt_preao/permissions_similar_topics.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/vse\\similartopics/language/pt_preao/permissions_similar_topics.php"
@@ -0,0 +1,50 @@
+<?php
+/**
+*
+* Precise Similar Topics [English]
+*
+* @copyright (c) 2013 Matt Friedman
+* @license GNU General Public License, version 2 (GPL-2.0)
+*
+*/
+
+/**
+* DO NOT CHANGE
+*/
+if (!defined('IN_PHPBB'))
+{
+	exit;
+}
+
+if (empty($lang) || !is_array($lang))
+{
+	$lang = array();
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
+
+/**
+*	EXTENSION-DEVELOPERS PLEASE NOTE
+*
+*	You are able to put your permission sets into your extension.
+*	The permissions logic should be added via the 'core.permissions' event.
+*	You can easily add new permission categories, types and permissions, by
+*	simply merging them into the respective arrays.
+*	The respective language strings should be added into a language file, that
+*	start with 'permissions_', so they are automatically loaded within the ACP.
+*/
+
+// User Permissions
+$lang = array_merge($lang, array(
+	'ACL_U_SIMILARTOPICS'	=> 'Can view similar topics',
+));
diff --git "[FORUM_EXT]/vse\\similartopics/language/pt_preao/similar_topics.php" "[FORUM_EXT]/vse\\similartopics/language/pt_preao/similar_topics.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/vse\\similartopics/language/pt_preao/similar_topics.php"
@@ -0,0 +1,43 @@
+<?php
+/**
+*
+* Precise Similar Topics [English]
+*
+* @copyright (c) 2013 Matt Friedman
+* @license GNU General Public License, version 2 (GPL-2.0)
+*
+*/
+
+/**
+* DO NOT CHANGE
+*/
+if (!defined('IN_PHPBB'))
+{
+	exit;
+}
+
+if (empty($lang) || !is_array($lang))
+{
+	$lang = array();
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
+//
+// Some characters you may want to copy&paste:
+// ’ » “ ” …
+//
+
+$lang = array_merge($lang, array(
+	'SIMILAR_TOPICS'			=> 'Tópicos Semelhantes',
+	'DISPLAY_SIMILAR_TOPICS'	=> 'Exibir tópicos semelhantes',
+));
diff --git "[ORIGINAL]/vse\\similartopics/language/ro/acp_similar_topics.php" "[FORUM_EXT]/vse\\similartopics/language/ro/acp_similar_topics.php"
--- "[ORIGINAL]/vse\\similartopics/language/ro/acp_similar_topics.php"
+++ "[FORUM_EXT]/vse\\similartopics/language/ro/acp_similar_topics.php"
@@ -43,7 +43,6 @@ $lang = array_merge($lang, array(
 	'PST_EXPLAIN'		=> 'Subiecte similare precise afișează o listă de subiecte similare în partea de jos a paginii subiect curente.',
 	'PST_LEGEND1'		=> 'Setări generale',
 	'PST_ENABLE'		=> 'Activaţi subiectele similare',
-	'PST_ENABLE_EXPLAIN'=> 'Show similar topics in topic discussion threads.',
 	'PST_LEGEND2'		=> 'Încarcă setări',
 	'PST_LIMIT'			=> 'Numărul de subiecte similare care să fie afişate',
 	'PST_LIMIT_EXPLAIN'	=> 'Aici puteţi preciza câte subiecte similare să fie afişate. Implicite sunt 5.',
@@ -55,10 +54,8 @@ $lang = array_merge($lang, array(
 	'PST_DAYS'			=> 'Zile',
 	'PST_CACHE'			=> 'Dimeniune cache',
 	'PST_CACHE_EXPLAIN'	=> 'Subiectele similare memorate vor expira după acest timp, în secunde. Alegeţi 0 dacă doriţi să dezactivaţi memorarea subiectelor similare.',
-	'PST_DYNAMIC'		=> 'Display dynamic similar topics',
-	'PST_DYNAMIC_EXPLAIN'=> 'Show similar topics as users type in the topic title field when creating new topics.',
 	'PST_SENSE'			=> 'Search sensitivity',
-	'PST_SENSE_EXPLAIN'	=> 'For MySQL or Postgres databases, you can set the search sensitivity to a value between 1 and 10. Use a lower number if you are not seeing any similar topics. Recommended setting: %d',
+	'PST_SENSE_EXPLAIN'	=> 'Set the search sensitivity to a value between 1 and 10. Use a lower number if you are not seeing any similar topics. Recommended settings: For “phpbb_topics” database tables using InnoDB use 1; for MyISAM use 5.',
 	'PST_LEGEND3'		=> 'Setări forum',
 	'PST_NOSHOW_LIST'	=> 'Nu afişa în',
 	'PST_NOSHOW_TITLE'	=> 'Nu afişa subiecte similare în',
@@ -67,14 +64,14 @@ $lang = array_merge($lang, array(
 	'PST_STANDARD'		=> 'Standard',
 	'PST_ADVANCED'		=> 'Advanced',
 	'PST_ADVANCED_TITLE'=> 'Apăsaţi pentru a configura setările avansate ale subiectelor similare pentru',
-	'PST_ADVANCED_EXP'	=> 'Aici puteţi alege forumuri specifice din care să afişaţi subiecte similare. Numai subiectele similare găsite în forumurile pe care le-aţi ales aici vor fi afişate în <strong>%s</strong>.<br><br>Nu alegeţi orice forumuri dacă doriţi ca toate subiectele similare din toate forumurile ce pot fi căutate să fie afişate în acest forum.<br><br>Selectaţi/Deselectaţi mai multe forumuri ţinând apăsată tasta <code>CTRL</code> şi făcând click.',
+	'PST_ADVANCED_EXP'	=> 'Aici puteţi alege forumuri specifice din care să afişaţi subiecte similare. Numai subiectele similare găsite în forumurile pe care le-aţi ales aici vor fi afişate în <strong>%s</strong>.<br /><br />Nu alegeţi orice forumuri dacă doriţi ca toate subiectele similare din toate forumurile ce pot fi căutate să fie afişate în acest forum.<br /><br />Selectaţi/Deselectaţi mai multe forumuri ţinând apăsată tasta <code>CTRL</code> şi făcând click.',
 	'PST_ADVANCED_FORUM'=> 'Setări avansate pe forum pentru',
 	'PST_DESELECT_ALL'	=> 'Deselectaţi tot',
 	'PST_LEGEND4'		=> 'Setări opţionale',
 	'PST_WORDS'			=> 'Cuvinte speciale ignorate',
 	'PST_WORDS_EXPLAIN'	=> 'Adăugaţi cuvinte speciale unice care ar trebui ignorate atunci când sunt căutate subiecte similare. (Reţineţi: Cuvintele care sunt cunoscute ca frecvente în limba dumneavoastră sunt implicit ignorate.) Separaţi cuvintele între ele cu un spaţiu. Majusculele sunt nesemnificative.',
 	'PST_SAVED'			=> 'Setări actualizate',
-	'PST_FORUM_INFO'	=> '“Nu afişa în”: Nu va afişa subiectele similare în forumurile alese.<br>“Nu căuta în” : Nu va căuta subiecte similare în forumurile alese.',
+	'PST_FORUM_INFO'	=> '“Nu afişa în”: Nu va afişa subiectele similare în forumurile alese.<br />“Nu căuta în” : Nu va căuta subiecte similare în forumurile alese.',
 	'PST_NO_COMPAT'		=> 'MODificarea Subiecte similare nu va funcţiona pe forumul dumneavoastr. MODificarea Subiecte similare necesită o bază de date cu MySQL 4 sau MySQL 5 sau PostgreSQL.',
 	'PST_ERR_CONFIG'	=> 'Prea multe forumuri au fost marcate în lista de forumuri. Vă rugăm să încercați din nou, cu o selecție mai mic.',
 ));
diff --git "[ORIGINAL]/vse\\similartopics/language/ru/acp_similar_topics.php" "[FORUM_EXT]/vse\\similartopics/language/ru/acp_similar_topics.php"
--- "[ORIGINAL]/vse\\similartopics/language/ru/acp_similar_topics.php"
+++ "[FORUM_EXT]/vse\\similartopics/language/ru/acp_similar_topics.php"
@@ -42,7 +42,6 @@ $lang = array_merge($lang, array(
 	'PST_EXPLAIN'		=> 'Расширение «Похожие темы» отображает список похожих (связанных) тем внизу на странице с сообщениями просматриваемой темы.',
 	'PST_LEGEND1'		=> 'Основные настройки',
 	'PST_ENABLE'		=> 'Отображать похожие темы',
-	'PST_ENABLE_EXPLAIN'=> 'Show similar topics in topic discussion threads.',
 	'PST_LEGEND2'		=> 'Настройки загрузки',
 	'PST_LIMIT'			=> 'Количество похожих тем для отображения',
 	'PST_LIMIT_EXPLAIN'	=> 'Здесь можно установить количество тем, которые будут показываться в блоке «Похожие темы». По умолчанию установлено отображение 5 похожих тем.',
@@ -54,10 +53,8 @@ $lang = array_merge($lang, array(
 	'PST_DAYS'			=> 'дней',
 	'PST_CACHE'			=> 'Размер кэша для расширения «Похожие темы»',
 	'PST_CACHE_EXPLAIN'	=> 'Количество секунд, по прошествии которого очищается кэш расширения «Похожие темы». Установите данную опцию в 0, если хотите полностью отключить кэширование для данного расширения.',
-	'PST_DYNAMIC'		=> 'Display dynamic similar topics',
-	'PST_DYNAMIC_EXPLAIN'=> 'Show similar topics as users type in the topic title field when creating new topics.',
 	'PST_SENSE'			=> 'Чувствительность поиска',
-	'PST_SENSE_EXPLAIN'	=> 'Здесь можно установить чувствительность поиска в пределах от 1 до 10. Используйте число меньше установленного, если не отображается ни одна похожая тема. Рекомендуемая настройка: %d',
+	'PST_SENSE_EXPLAIN'	=> 'Здесь можно установить чувствительность поиска в пределах от 1 до 10. Используйте число меньше установленного, если не отображается ни одна похожая тема. Рекомендуемая настройка: если тип таблицы «phpbb_topics» установлен в InnoDB, то установите 1; для типа MyISAM установите 5.',
 	'PST_LEGEND3'		=> 'Настройки форума',
 	'PST_NOSHOW_LIST'	=> 'Не отображать в',
 	'PST_NOSHOW_TITLE'	=> 'Не отображать похожие темы в',
@@ -66,14 +63,14 @@ $lang = array_merge($lang, array(
 	'PST_STANDARD'		=> 'Стандартные',
 	'PST_ADVANCED'		=> 'Продвинутые',
 	'PST_ADVANCED_TITLE'=> 'Кликните мышкой для того, чтобы открыть продвинутые установки расширения «Похожие темы»',
-	'PST_ADVANCED_EXP'	=> 'Здесь вы можете указать конкретные разделы форума, откуда брать похожие темы. В блоке «Похожие темы» будут отображаться темы ТОЛЬКО из указанных здесь разделов.<br><br>Если вы не выберете ни один раздел, то поиск похожих тем будет осуществляться по всем разделам форума.<br><br>Можно выбрать несколько разделов с помощью клавиши <samp>CTRL</samp> (либо клавиши <samp>&#8984;CMD</samp> на компьютерах Mac) и левой кнопки мышки.',
+	'PST_ADVANCED_EXP'	=> 'Здесь вы можете указать конкретные разделы форума, откуда брать похожие темы. В блоке «Похожие темы» будут отображаться темы ТОЛЬКО из указанных здесь разделов.<br /><br />Если вы не выберете ни один раздел, то поиск похожих тем будет осуществляться по всем разделам форума.<br /><br />Можно выбрать несколько разделов с помощью клавиши <samp>CTRL</samp> (либо клавиши <samp>&#8984;CMD</samp> на компьютерах Mac) и левой кнопки мышки.',
 	'PST_ADVANCED_FORUM'=> 'Продвинутые настройки',
 	'PST_DESELECT_ALL'	=> 'Сбросить всё',
 	'PST_LEGEND4'		=> 'Необязательные настройки',
 	'PST_WORDS'			=> 'Игнорировать отдельные слова',
 	'PST_WORDS_EXPLAIN'	=> 'Здесь можно прописать отдельные слова, которые не будут учитываться при поиске похожих тем. (Внимание: некоторые общие слова используемого вами языка уже игнорируются по умолчанию.) Каждое слово отделяется пробелом. Регистр слов не учитывается.',
 	'PST_SAVED'			=> 'Настройки расширения «Похожие темы» обновлены',
-	'PST_FORUM_INFO'	=> '«Не отображать в»: в выбранных здесь разделах блок «Похожие темы» отображаться не будет.<br>«Не осуществлять поиск похожих тем в»: в выбранных здесь разделах поиск похожих тем осуществляться не будет.',
+	'PST_FORUM_INFO'	=> '«Не отображать в»: в выбранных здесь разделах блок «Похожие темы» отображаться не будет.<br />«Не осуществлять поиск похожих тем в»: в выбранных здесь разделах поиск похожих тем осуществляться не будет.',
 	'PST_NO_COMPAT'		=> 'Расширение «Похожие темы» не совместимо с вашим форумом. Для использование данного расширения необходимо использование базы данных MySQL или PostgreSQL.',
 	'PST_ERR_CONFIG'	=> 'Выбрано слишком много разделов форума. Пожалуйста, укажите меньшее количество разделов.',
 ));
diff --git "[ORIGINAL]/vse\\similartopics/language/sr/acp_similar_topics.php" "[FORUM_EXT]/vse\\similartopics/language/sr/acp_similar_topics.php"
--- "[ORIGINAL]/vse\\similartopics/language/sr/acp_similar_topics.php"
+++ "[FORUM_EXT]/vse\\similartopics/language/sr/acp_similar_topics.php"
@@ -42,7 +42,6 @@ $lang = array_merge($lang, array(
 	'PST_EXPLAIN'		=> 'Precise Similar Topics displays a list of similar (related) topics at the bottom of the current topic’s page.',
 	'PST_LEGEND1'		=> 'Generalna podešavanja',
 	'PST_ENABLE'		=> 'Uključi Similar Topics',
-	'PST_ENABLE_EXPLAIN'=> 'Show similar topics in topic discussion threads.',
 	'PST_LEGEND2'		=> 'Učitaj podešavanja',
 	'PST_LIMIT'			=> 'Broj sličnih tema koje će biti prikazane',
 	'PST_LIMIT_EXPLAIN'	=> 'Ovde možete odrediti koliko sličnih tema će biti prikazano. Podrazumevana vrednost je 5.',
@@ -54,10 +53,8 @@ $lang = array_merge($lang, array(
 	'PST_DAYS'			=> 'Dana',
 	'PST_CACHE'			=> 'Dužina keša za Similar Topics',
 	'PST_CACHE_EXPLAIN'	=> 'Keširane slične teme će da nestanu nakon toliko vremena u sekunadma. Podesite vrednost na 0 ukoliko želite da isključite ovu opciju.',
-	'PST_DYNAMIC'		=> 'Display dynamic similar topics',
-	'PST_DYNAMIC_EXPLAIN'=> 'Show similar topics as users type in the topic title field when creating new topics.',
 	'PST_SENSE'			=> 'Search sensitivity',
-	'PST_SENSE_EXPLAIN'	=> 'For MySQL or Postgres databases, you can set the search sensitivity to a value between 1 and 10. Use a lower number if you are not seeing any similar topics. Recommended setting: %d',
+	'PST_SENSE_EXPLAIN'	=> 'Set the search sensitivity to a value between 1 and 10. Use a lower number if you are not seeing any similar topics. Recommended settings: For “phpbb_topics” database tables using InnoDB use 1; for MyISAM use 5.',
 	'PST_LEGEND3'		=> 'Podešavanja foruma',
 	'PST_NOSHOW_LIST'	=> 'Ne prikazuj u',
 	'PST_NOSHOW_TITLE'	=> 'Ne prikazuj slične teme u',
@@ -66,14 +63,14 @@ $lang = array_merge($lang, array(
 	'PST_STANDARD'		=> 'Standard',
 	'PST_ADVANCED'		=> 'Napredna podešavanja',
 	'PST_ADVANCED_TITLE'=> 'Kliknite ukoliko želite da odredite napredna podešavanja za',
-	'PST_ADVANCED_EXP'	=> 'Ovde možete odrediti specifične forume iz kojih želite da se pretražuju slične teme. Jedino slične teme koje budu pronađene u forumu će biti prikazane u <strong>%s</strong>.<br><br>Nemojte da selektujete nijedan forum ukoliko želite da se prikazuju slične teme iz svih foruma u kojima je uključena opcija Similar Topics.<br><br>Možete izabrati više foruma tako što držite <code>CTRL</code> i kliknete.',
+	'PST_ADVANCED_EXP'	=> 'Ovde možete odrediti specifične forume iz kojih želite da se pretražuju slične teme. Jedino slične teme koje budu pronađene u forumu će biti prikazane u <strong>%s</strong>.<br /><br />Nemojte da selektujete nijedan forum ukoliko želite da se prikazuju slične teme iz svih foruma u kojima je uključena opcija Similar Topics.<br /><br />Možete izabrati više foruma tako što držite <code>CTRL</code> i kliknete.',
 	'PST_ADVANCED_FORUM'=> 'Advanced forum settings',
 	'PST_DESELECT_ALL'	=> 'Deselektuj sve',
 	'PST_LEGEND4'		=> 'Opciona podešavanja',
 	'PST_WORDS'			=> 'Specialne reči za ignorisanje',
 	'PST_WORDS_EXPLAIN'	=> 'Dodajte specijalne reči koje su unikatne za vaš forum koje bi trebalo da budu ignorisane kada se pretražuju slične teme. (Napomena: reči koje se inače smatraju za ustaljene će ionako biti ignorisane prilikom pretrage.) Reči razdvojte razmakom. Case insensitive.',
 	'PST_SAVED'			=> 'Podešavanja za Similar Topics su ažurirana',
-	'PST_FORUM_INFO'	=> '"Ne prikazuj u": Neće prikazati slične teme u izabranim forumima.<br>"Ne pretražuj u": Neće pretraživati slične teme u izabranim forumima.',
+	'PST_FORUM_INFO'	=> '"Ne prikazuj u": Neće prikazati slične teme u izabranim forumima.<br />"Ne pretražuj u": Neće pretraživati slične teme u izabranim forumima.',
 	'PST_NO_COMPAT'		=> 'Similar Topics ne funkcioniše sa vašim forumom. Similar Topics zahteva MySQL 4 ili MySQL 5 ili PostgreSQL bazu podataka.',
 	'PST_ERR_CONFIG'	=> 'Previše forumi su označeni na listi forumima . Pokušajte ponovo sa manjim izborom.',
 ));
diff --git "[ORIGINAL]/vse\\similartopics/language/sv/acp_similar_topics.php" "[FORUM_EXT]/vse\\similartopics/language/sv/acp_similar_topics.php"
--- "[ORIGINAL]/vse\\similartopics/language/sv/acp_similar_topics.php"
+++ "[FORUM_EXT]/vse\\similartopics/language/sv/acp_similar_topics.php"
@@ -43,7 +43,6 @@ $lang = array_merge($lang, array(
 	'PST_EXPLAIN'		=> 'Precise Similar Topics visar en lista över liknande ämnen längst ner i det aktuella ämnet sida.',
 	'PST_LEGEND1'		=> 'Generella inställningar',
 	'PST_ENABLE'		=> 'Aktivera Similar Topics',
-	'PST_ENABLE_EXPLAIN'=> 'Show similar topics in topic discussion threads.',
 	'PST_LEGEND2'		=> 'Ladda inställningar',
 	'PST_LIMIT'			=> 'Antal liknande trådar som ska visas',
 	'PST_LIMIT_EXPLAIN'	=> 'Här anger du antalet liknande trådar som skall visas. Förinställt värde är 5 st.',
@@ -55,10 +54,8 @@ $lang = array_merge($lang, array(
 	'PST_DAYS'			=> 'Dagar',
 	'PST_CACHE'			=> 'Lagring av liknande trådar',
 	'PST_CACHE_EXPLAIN'	=> 'Lagrade trådar upphör efter denna tid, inställt i sekunder. Ange 0 om du vill stänga av lagring av liknande trådar.',
-	'PST_DYNAMIC'		=> 'Display dynamic similar topics',
-	'PST_DYNAMIC_EXPLAIN'=> 'Show similar topics as users type in the topic title field when creating new topics.',
 	'PST_SENSE'			=> 'Search sensitivity',
-	'PST_SENSE_EXPLAIN'	=> 'For MySQL or Postgres databases, you can set the search sensitivity to a value between 1 and 10. Use a lower number if you are not seeing any similar topics. Recommended setting: %d',
+	'PST_SENSE_EXPLAIN'	=> 'Set the search sensitivity to a value between 1 and 10. Use a lower number if you are not seeing any similar topics. Recommended settings: For “phpbb_topics” database tables using InnoDB use 1; for MyISAM use 5.',
 	'PST_LEGEND3'		=> 'Foruminställningar',
 	'PST_NOSHOW_LIST'	=> 'Visa inte i',
 	'PST_NOSHOW_TITLE'	=> 'Visa inte liknande trådar i',
@@ -67,14 +64,14 @@ $lang = array_merge($lang, array(
 	'PST_STANDARD'		=> 'Standard',
 	'PST_ADVANCED'		=> 'Avancerade',
 	'PST_ADVANCED_TITLE'=> 'Klicka för att ställa in avancerade inställningar',
-	'PST_ADVANCED_EXP'	=> 'Här kan du välja specifika kategorier att hämta liknande trådar från. Endast liknande trådar från de kategorier du väljer här kommer att visas i <strong>%s</strong>.<br><br>Välj inga specifika kategorier om du vill visa liknande trådar från alla kategorier i detta forum.<br><br>Använd t.ex. kombinationen <code>CTRL</code> + musklick för att markera och välja (avvälja) fler än en kategori.',
+	'PST_ADVANCED_EXP'	=> 'Här kan du välja specifika kategorier att hämta liknande trådar från. Endast liknande trådar från de kategorier du väljer här kommer att visas i <strong>%s</strong>.<br /><br />Välj inga specifika kategorier om du vill visa liknande trådar från alla kategorier i detta forum.<br /><br />Använd t.ex. kombinationen <code>CTRL</code> + musklick för att markera och välja (avvälja) fler än en kategori.',
 	'PST_ADVANCED_FORUM'=> 'Avancerade foruminställningar',
 	'PST_DESELECT_ALL'	=> 'Avmarkera alla',
 	'PST_LEGEND4'		=> 'Valfria inställningar',
 	'PST_WORDS'			=> 'Särskilda ord som ska ignoreras',
 	'PST_WORDS_EXPLAIN'	=> 'Lägg till särskilda ord på forumet som skall ignoreras vid sökningen av liknande trådar. (Obs: Ord som betraktas som vanliga ord är redan undantagna). Separera varje ord med ett mellanslag. Ingen hänsyn tas till versaler eller gemenser.',
 	'PST_SAVED'			=> 'Inställningarna har uppdaterats',
-	'PST_FORUM_INFO'	=> '“Visa inte i” :  Liknande trådar visas inte i valda kategorier.<br>“Sök inte i” :  Sökning efter liknande trådar sker inte i valda kategorier.',
+	'PST_FORUM_INFO'	=> '“Visa inte i” :  Liknande trådar visas inte i valda kategorier.<br />“Sök inte i” :  Sökning efter liknande trådar sker inte i valda kategorier.',
 	'PST_NO_COMPAT'		=> 'Similar Topics fungerar inte på ditt forum. Similar Topics kräver MySQL 4 eller MySQL 5 eller PostgreSQL.',
 	'PST_ERR_CONFIG'	=> 'Alltför många forum märktes i listan över forum. Försök igen med ett mindre urval.',
 ));
diff --git "[ORIGINAL]/vse\\similartopics/language/sv/search_ignore_words.php" "[ORIGINAL]/vse\\similartopics/language/sv/search_ignore_words.php"
deleted file mode 100644
--- "[ORIGINAL]/vse\\similartopics/language/sv/search_ignore_words.php"
+++ /dev/null
@@ -1,115 +0,0 @@
-<?php
-/**
- *
- * Precise Similar Topics
- *
- * @copyright (c) 2025 Matt Friedman
- * @license GNU General Public License, version 2 (GPL-2.0)
- *
- * This [sv] language list of stop words created by Matt Friedman for Similar Topics
- *
- */
-
-if (!defined('IN_PHPBB'))
-{
-   exit;
-}
-
-$words = array(
-	'alla',
-	'alltid',
-	'andra',
-	'att',
-	'av',
-	'bara',
-	'blev',
-	'bli',
-	'blir',
-	'bra',
-	'dag',
-	'dagar',
-	'den',
-	'denna',
-	'det',
-	'detta',
-	'dig',
-	'din',
-	'dina',
-	'dit',
-	'du',
-	'efter',
-	'eller',
-	'en',
-	'ett',
-	'finns',
-	'fram',
-	'från',
-	'för',
-	'genom',
-	'god',
-	'hade',
-	'han',
-	'hans',
-	'har',
-	'hem',
-	'hennes',
-	'här',
-	'hör',
-	'hur',
-	'inte',
-	'jag',
-	'kan',
-	'kanske',
-	'kom',
-	'kommer',
-	'kring',
-	'lite',
-	'man',
-	'med',
-	'men',
-	'mer',
-	'mycket',
-	'måste',
-	'när',
-	'någon',
-	'något',
-	'några',
-	'och',
-	'ofta',
-	'om',
-	'på',
-	'redan',
-	'rätt',
-	'sade',
-	'samma',
-	'sedan',
-	'ser',
-	'sig',
-	'sin',
-	'sina',
-	'sitt',
-	'ska',
-	'skulle',
-	'som',
-	'stor',
-	'stora',
-	'säga',
-	'säger',
-	'tid',
-	'till',
-	'under',
-	'upp',
-	'var',
-	'vara',
-	'varit',
-	'varje',
-	'vem',
-	'vi',
-	'vid',
-	'vill',
-	'väl',
-	'än',
-	'är',
-	'även',
-	'över',
-);
diff --git "[ORIGINAL]/vse\\similartopics/language/tr/acp_similar_topics.php" "[FORUM_EXT]/vse\\similartopics/language/tr/acp_similar_topics.php"
--- "[ORIGINAL]/vse\\similartopics/language/tr/acp_similar_topics.php"
+++ "[FORUM_EXT]/vse\\similartopics/language/tr/acp_similar_topics.php"
@@ -42,7 +42,6 @@ $lang = array_merge($lang, array(
 	'PST_EXPLAIN'		=> 'Benzer Konular eklentisi benzer (ilişkili) konuların bir listesini mevcut konu sayfasının altında gösterir.',
 	'PST_LEGEND1'		=> 'Genel Ayarlar',
 	'PST_ENABLE'		=> 'Benzer Konuları Göster',
-	'PST_ENABLE_EXPLAIN'=> 'Show similar topics in topic discussion threads.',
 	'PST_LEGEND2'		=> 'Yükleme ayarları',
 	'PST_LIMIT'			=> 'Gösterilecek Benzer Konu sayısı',
 	'PST_LIMIT_EXPLAIN'	=> 'Buradan kaç tane Benzer Konunun gösterileceğini belirleyebilirsiniz. Varsayılan değer 5 konudur.',
@@ -54,10 +53,8 @@ $lang = array_merge($lang, array(
 	'PST_DAYS'			=> 'Gün',
 	'PST_CACHE'			=> 'Benzer Konular önbellek uzunluğu',
 	'PST_CACHE_EXPLAIN'	=> 'Önbelleklenmiş benzer konuların süresi bu süre sonunda geçecektir, saniye olarak. 0 olarak ayarlarsanız benzer konular önbellekleme özelliğini kapatırsınız.',
-	'PST_DYNAMIC'		=> 'Display dynamic similar topics',
-	'PST_DYNAMIC_EXPLAIN'=> 'Show similar topics as users type in the topic title field when creating new topics.',
-	'PST_SENSE'			=> 'Arama duyarlılığı',
-	'PST_SENSE_EXPLAIN'	=> 'Arama duyarlılığını 1 ile 10 arasında bir değere ayarlayın. Benzer konular görmüyorsanız daha düşük bir sayı kullanın. Önerilen ayarlar: InnoDB kullanan “phpbb_topics” veritabanı tabloları için 1 kullanın; MyISAM kullanımı için 5.',
+	'PST_SENSE'			=> 'Search sensitivity',
+	'PST_SENSE_EXPLAIN'	=> 'Set the search sensitivity to a value between 1 and 10. Use a lower number if you are not seeing any similar topics. Recommended settings: For “phpbb_topics” database tables using InnoDB use 1; for MyISAM use 5.',
 	'PST_LEGEND3'		=> 'Forum ayarları',
 	'PST_NOSHOW_LIST'	=> 'Şurada gösterme',
 	'PST_NOSHOW_TITLE'	=> 'Benzer Konuları şurada gösterme',
@@ -66,14 +63,14 @@ $lang = array_merge($lang, array(
 	'PST_STANDARD'		=> 'Standart',
 	'PST_ADVANCED'		=> 'Gelişmiş',
 	'PST_ADVANCED_TITLE'=> 'Gelişmiş benzer konular ayarlarını yüklemek için tıklayın',
-	'PST_ADVANCED_EXP'	=> 'Buradan benzer konuların seçileceği belirli forumları seçebilirsin. Sadece burada seçtiğiniz forumlardaki benzer konular şurada gösterilir <strong>%s</strong>.<br><br>Tüm aranabilen forumlardan konuların Benzer Konularda gösterilmesini istiyorsanız hiç bir forumu seçmeyin.<br><br><code>CTRL</code>ye basılı tutup çoklu forum Seçimi/Seçimi Kaldırma işlemini yapabilirsiniz.',
+	'PST_ADVANCED_EXP'	=> 'Buradan benzer konuların seçileceği belirli forumları seçebilirsin. Sadece burada seçtiğiniz forumlardaki benzer konular şurada gösterilir <strong>%s</strong>.<br /><br />Tüm aranabilen forumlardan konuların Benzer Konularda gösterilmesini istiyorsanız hiç bir forumu seçmeyin.<br /><br /><code>CTRL</code>ye basılı tutup çoklu forum Seçimi/Seçimi Kaldırma işlemini yapabilirsiniz.',
 	'PST_ADVANCED_FORUM'=> 'Gelişmiş forum ayarları',
 	'PST_DESELECT_ALL'	=> 'Tümünü kaldır',
 	'PST_LEGEND4'		=> 'İsteğe bağlı ayarlar',
 	'PST_WORDS'			=> 'Dikkate alınmayacak kelimeler',
 	'PST_WORDS_EXPLAIN'	=> 'Benzer konular bulunurken yoksayılacak özel kelimeleri ekle. (Not: Dilinizde sık kullanılan kelimeler zaten varsayılan olarak yoksayılmıştır.) Kelimeleri bir boşluk ile ayır. Büyük-küçük harf duyarlıdır.',
 	'PST_SAVED'			=> 'Benzer Konular ayarları güncellendi',
-	'PST_FORUM_INFO'	=> '“Şurada gösterme”: seçili forumlarda benzer konuları göstermeyecek.<br>“Şurada arama” : Seçili forumlarda benzer konular  için aramayacak.',
+	'PST_FORUM_INFO'	=> '“Şurada gösterme”: seçili forumlarda benzer konuları göstermeyecek.<br />“Şurada arama” : Seçili forumlarda benzer konular  için aramayacak.',
 	'PST_NO_COMPAT'		=> 'Benzer Konular forumunuzla uyumlu değil. Benzer Konular sadece MySQL 4 veya MySQL 5 veya PostgreSQL veritabanında çalışır.',
 	'PST_ERR_CONFIG'	=> 'Çok fazla forumlar forumlarda listesinde işaretlenmiştir. Küçük bir seçim ile tekrar deneyin.',
 ));
diff --git "[ORIGINAL]/vse\\similartopics/language/tr/search_ignore_words.php" "[ORIGINAL]/vse\\similartopics/language/tr/search_ignore_words.php"
deleted file mode 100644
--- "[ORIGINAL]/vse\\similartopics/language/tr/search_ignore_words.php"
+++ /dev/null
@@ -1,102 +0,0 @@
-<?php
-/**
- *
- * Precise Similar Topics
- *
- * @copyright (c) 2025 Matt Friedman
- * @license GNU General Public License, version 2 (GPL-2.0)
- *
- * This [tr] language list of stop words created by Matt Friedman for Similar Topics
- *
- */
-
-if (!defined('IN_PHPBB'))
-{
-   exit;
-}
-
-$words = array(
-	'acaba',
-	'ama',
-	'ancak',
-	'artık',
-	'aslında',
-	'ayrıca',
-	'bana',
-	'bazen',
-	'ben',
-	'beni',
-	'benim',
-	'bile',
-	'bir',
-	'birçok',
-	'biri',
-	'birkaç',
-	'biz',
-	'bizi',
-	'bizim',
-	'bu',
-	'buna',
-	'bunda',
-	'bundan',
-	'bunlar',
-	'bunları',
-	'bunların',
-	'bunu',
-	'bunun',
-	'büyük',
-	'çok',
-	'da',
-	'daha',
-	'de',
-	'değil',
-	'diye',
-	'en',
-	'eve',
-	'gibi',
-	'gün',
-	'günler',
-	'hep',
-	'her',
-	'hiç',
-	'için',
-	'ile',
-	'ise',
-	'işte',
-	'kadar',
-	'kendi',
-	'ki',
-	'küçük',
-	'mı',
-	'mi',
-	'mu',
-	'mü',
-	'nasıl',
-	'ne',
-	'neden',
-	'nerede',
-	'niye',
-	'olan',
-	'olarak',
-	'oldu',
-	'olduğu',
-	'olmak',
-	'olması',
-	'onu',
-	'onun',
-	'sadece',
-	'şey',
-	'şimdi',
-	'şu',
-	'şunu',
-	'şunun',
-	'tüm',
-	'var',
-	've',
-	'veya',
-	'ya',
-	'yani',
-	'yapılan',
-	'yok',
-	'zaman',
-);
diff --git "[ORIGINAL]/vse\\similartopics/migrations/release_1_7_x/dynamic_similar_topics.php" "[ORIGINAL]/vse\\similartopics/migrations/release_1_7_x/dynamic_similar_topics.php"
deleted file mode 100644
--- "[ORIGINAL]/vse\\similartopics/migrations/release_1_7_x/dynamic_similar_topics.php"
+++ /dev/null
@@ -1,31 +0,0 @@
-<?php
-/**
- *
- * Precise Similar Topics
- *
- * @copyright (c) 2025 Matt Friedman
- * @license GNU General Public License, version 2 (GPL-2.0)
- *
- */
-
-namespace vse\similartopics\migrations\release_1_7_x;
-
-class dynamic_similar_topics extends \phpbb\db\migration\migration
-{
-	public function effectively_installed()
-	{
-		return $this->config->offsetExists('similar_topics_dynamic');
-	}
-
-	public static function depends_on()
-	{
-		return ['\vse\similartopics\migrations\release_1_5_x\similar_topic_words'];
-	}
-
-	public function update_data()
-	{
-		return [
-			['config.add', ['similar_topics_dynamic', 0]],
-		];
-	}
-}
diff --git "[ORIGINAL]/vse\\similartopics/migrations/release_1_7_x/mssql_index.php" "[ORIGINAL]/vse\\similartopics/migrations/release_1_7_x/mssql_index.php"
deleted file mode 100644
--- "[ORIGINAL]/vse\\similartopics/migrations/release_1_7_x/mssql_index.php"
+++ /dev/null
@@ -1,87 +0,0 @@
-<?php
-/**
- *
- * Precise Similar Topics
- *
- * @copyright (c) 2025 Matt Friedman
- * @license GNU General Public License, version 2 (GPL-2.0)
- *
- */
-
-namespace vse\similartopics\migrations\release_1_7_x;
-
-use vse\similartopics\driver\mssql;
-
-class mssql_index extends \phpbb\db\migration\migration
-{
-	/** @var mssql */
-	protected $driver;
-
-	/**
-	 * Do not run this migration if the DB is not MSSQL or MSSQL NATIVE
-	 *
-	 * @return bool
-	 */
-	public function effectively_installed()
-	{
-		if (strpos($this->db->get_sql_layer(), 'mssql') === false)
-		{
-			return true;
-		}
-		return $this->get_driver()->is_fulltext('topic_title', TOPICS_TABLE);
-	}
-
-	public static function depends_on()
-	{
-		return ['\vse\similartopics\migrations\release_1_5_x\similar_topic_words'];
-	}
-
-	public function update_data()
-	{
-		return [
-			['if', [
-				strpos($this->db->get_sql_layer(), 'mssql') === 0,
-				['custom', [[$this, 'create_mssql_fulltext_index']]],
-			]],
-		];
-	}
-
-	public function revert_data()
-	{
-		return [
-			['if', [
-				strpos($this->db->get_sql_layer(), 'mssql') === 0,
-				['custom', [[$this, 'drop_mssql_fulltext_index']]],
-			]],
-		];
-	}
-
-	/**
-	 * Create a FULLTEXT index for the topic_title in the topic table
-	 */
-	public function create_mssql_fulltext_index()
-	{
-		$this->get_driver()->create_fulltext_index('topic_title', TOPICS_TABLE);
-	}
-
-	/**
-	 * Drop the FULLTEXT index we created from the topic table
-	 */
-	public function drop_mssql_fulltext_index()
-	{
-		$sql = 'DROP FULLTEXT INDEX ON ' . TOPICS_TABLE;
-		$this->db->sql_query($sql);
-	}
-
-	/**
-	 * @return mssql
-	 */
-	protected function get_driver()
-	{
-		if ($this->driver === null)
-		{
-			$this->driver = new mssql($this->db);
-		}
-		return $this->driver;
-	}
-}
diff --git "[ORIGINAL]/vse\\similartopics/migrations/release_1_7_x/oracle_index.php" "[ORIGINAL]/vse\\similartopics/migrations/release_1_7_x/oracle_index.php"
deleted file mode 100644
--- "[ORIGINAL]/vse\\similartopics/migrations/release_1_7_x/oracle_index.php"
+++ /dev/null
@@ -1,88 +0,0 @@
-<?php
-/**
- *
- * Precise Similar Topics
- *
- * @copyright (c) 2025 Matt Friedman
- * @license GNU General Public License, version 2 (GPL-2.0)
- *
- */
-
-namespace vse\similartopics\migrations\release_1_7_x;
-
-use vse\similartopics\driver\oracle;
-
-class oracle_index extends \phpbb\db\migration\migration
-{
-	/** @var oracle */
-	protected $driver;
-
-	/**
-	 * Do not run this migration if the DB is not Oracle
-	 *
-	 * @return bool
-	 */
-	public function effectively_installed()
-	{
-		if (strpos($this->db->get_sql_layer(), 'oracle') !== 0)
-		{
-			return true;
-		}
-		return $this->get_driver()->is_fulltext('topic_title', TOPICS_TABLE);
-	}
-
-	public static function depends_on()
-	{
-		return ['\vse\similartopics\migrations\release_1_5_x\similar_topic_words'];
-	}
-
-	public function update_data()
-	{
-		return [
-			['if', [
-				strpos($this->db->get_sql_layer(), 'oracle') === 0,
-				['custom', [[$this, 'create_oracle_fulltext_index']]],
-			]],
-		];
-	}
-
-	public function revert_data()
-	{
-		return [
-			['if', [
-				strpos($this->db->get_sql_layer(), 'oracle') === 0,
-				['custom', [[$this, 'drop_oracle_fulltext_index']]],
-			]],
-		];
-	}
-
-	/**
-	 * Create a FULLTEXT index for the topic_title in the topic table
-	 */
-	public function create_oracle_fulltext_index()
-	{
-		$this->get_driver()->create_fulltext_index('topic_title', TOPICS_TABLE);
-	}
-
-	/**
-	 * Drop the FULLTEXT index we created from the topic table
-	 */
-	public function drop_oracle_fulltext_index()
-	{
-		$index_name = TOPICS_TABLE . '_topic_title_ctx_idx';
-		$sql = 'DROP INDEX ' . $this->db->sql_escape($index_name);
-		$this->db->sql_query($sql);
-	}
-
-	/**
-	 * @return oracle
-	 */
-	protected function get_driver()
-	{
-		if ($this->driver === null)
-		{
-			$this->driver = new oracle($this->db);
-		}
-		return $this->driver;
-	}
-}
diff --git "[ORIGINAL]/vse\\similartopics/migrations/release_1_7_x/sqlite3_index.php" "[ORIGINAL]/vse\\similartopics/migrations/release_1_7_x/sqlite3_index.php"
deleted file mode 100644
--- "[ORIGINAL]/vse\\similartopics/migrations/release_1_7_x/sqlite3_index.php"
+++ /dev/null
@@ -1,87 +0,0 @@
-<?php
-/**
- *
- * Precise Similar Topics
- *
- * @copyright (c) 2025 Matt Friedman
- * @license GNU General Public License, version 2 (GPL-2.0)
- *
- */
-
-namespace vse\similartopics\migrations\release_1_7_x;
-
-use vse\similartopics\driver\sqlite3;
-
-class sqlite3_index extends \phpbb\db\migration\migration
-{
-	/** @var sqlite3 */
-	protected $driver;
-
-	/**
-	 * Do not run this migration if the DB is not SQLITE3
-	 *
-	 * @return bool
-	 */
-	public function effectively_installed()
-	{
-		if ($this->db->get_sql_layer() !== 'sqlite3')
-		{
-			return true;
-		}
-		return $this->get_driver()->is_fulltext('topic_title', TOPICS_TABLE);
-	}
-
-	public static function depends_on()
-	{
-		return ['\vse\similartopics\migrations\release_1_5_x\similar_topic_words'];
-	}
-
-	public function update_data()
-	{
-		return [
-			['if', [
-				$this->db->get_sql_layer() === 'sqlite3',
-				['custom', [[$this, 'create_sqlite3_index']]],
-			]],
-		];
-	}
-
-	public function revert_data()
-	{
-		return [
-			['if', [
-				$this->db->get_sql_layer() === 'sqlite3',
-				['custom', [[$this, 'drop_sqlite3_index']]],
-			]],
-		];
-	}
-
-	/**
-	 * Create a FULLTEXT index for the topic_title in the topic table
-	 */
-	public function create_sqlite3_index()
-	{
-		$this->get_driver()->create_fulltext_index('topic_title', TOPICS_TABLE);
-	}
-
-	/**
-	 * Drop the FULLTEXT index we created from the topic table
-	 */
-	public function drop_sqlite3_index()
-	{
-		$sql = 'DROP INDEX IF EXISTS idx_' . TOPICS_TABLE . '_topic_title';
-		$this->db->sql_query($sql);
-	}
-
-	/**
-	 * @return sqlite3
-	 */
-	protected function get_driver()
-	{
-		if ($this->driver === null)
-		{
-			$this->driver = new sqlite3($this->db);
-		}
-		return $this->driver;
-	}
-}
diff --git "[FORUM_EXT]/vse\\similartopics/styles/BBOOTS/template/event/ucp_prefs_view_radio_buttons_append.html" "[FORUM_EXT]/vse\\similartopics/styles/BBOOTS/template/event/ucp_prefs_view_radio_buttons_append.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/vse\\similartopics/styles/BBOOTS/template/event/ucp_prefs_view_radio_buttons_append.html"
@@ -0,0 +1,9 @@
+{% if S_SIMILAR_TOPICS %}
+<div class="control-group">
+	<label class="control-label" for="similar_topics1">{{ lang('DISPLAY_SIMILAR_TOPICS') ~ lang('COLON') }}</label>
+	<div class="controls controls-row">
+	 <div class="radio"><input type="radio" name="similar_topics" id="similar_topics1" value="1"{% if S_DISPLAY_SIMILAR_TOPICS %} checked="checked"{% endif %} /><label for="similar_topics1">{{ lang('YES') }}</label></div>
+	 <div class="radio"><input type="radio" name="similar_topics" id="similar_topics0" value="0"{% if not S_DISPLAY_SIMILAR_TOPICS %} checked="checked"{% endif %} /><label for="similar_topics0">{{ lang('NO') }}</label></div>
+    </div>
+</div>
+{% endif %}
diff --git "[FORUM_EXT]/vse\\similartopics/styles/BBOOTS/template/event/viewtopic_body_footer_before.html" "[FORUM_EXT]/vse\\similartopics/styles/BBOOTS/template/event/viewtopic_body_footer_before.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/vse\\similartopics/styles/BBOOTS/template/event/viewtopic_body_footer_before.html"
@@ -0,0 +1,69 @@
+{% if loops.similar|length %}
+<div class="panel panel-default">
+	<table class="footable table table-striped table-bordered table-white table-primary table-hover">
+	<thead>
+		<tr>
+			<th data-class="expand">{{ lang('SIMILAR_TOPICS') }}</th>
+			<th class="large110" data-hide="phone">{{ lang('TOPICS_POSTS_STATISTICS') }}</th>
+			<th class="large21" data-hide="phone">{{ lang('LAST_POST') }}</th>
+		</tr>
+	</thead>
+	 <tbody>
+	{% for similar in loops.similar %}
+		{% EVENT search_results_topic_before %}
+		<tr>
+			<td>
+				{% if similar.TOPIC_ICON_IMG %}
+				 <i class="topic-icon" style="background-image: url({{ T_ICONS_PATH ~ similar.TOPIC_ICON_IMG }}); background-repeat: no-repeat;" title="{{ similar.TOPIC_FOLDER_IMG_ALT }}"></i>
+				{% endif %}
+				<span class="icon-wrapper">
+			     <i class="row-icon-font icon-moon-default2{% if similar.S_POST_ANNOUNCE %} icon-moon-voice2{% endif %}{% if similar.S_POST_GLOBAL %} icon-moon-podcast2{% endif %}{% if similar.S_POST_STICKY %} icon-moon-pushpin2{% endif %}{% if similar.S_HAS_POLL %} icon-moon-poll{% endif %}{% if similar.S_UNREAD_TOPIC %} forum-unread{% else %} forum-read{% endif %}" title="{{ similar.TOPIC_FOLDER_IMG_ALT }}"></i>
+				</span>
+				<i class="row-icon-font-mini{% if similar.S_TOPIC_LOCKED %} fa fa-lock forumview-lock{% endif %}" title="{{ similar.TOPIC_FOLDER_IMG_ALT }}"></i>
+				<span class="desc-wrapper">
+				{% EVENT topiclist_row_prepend %}
+				{% if similar.S_UNREAD_TOPIC and not S_IS_BOT %}<a href="{{ similar.U_NEWEST_POST }}" title="{{ lang('VIEW_FIRST_UNREAD') }}"><i class="fa fa-asterisk"></i></a>{% endif %}{% EVENT topiclist_row_topic_title_before %}<a href="{{ similar.U_VIEW_TOPIC }}" class="topictitle">{{ similar.TOPIC_TITLE }}</a>
+				{% if similar.ATTACH_ICON_IMG %}<i class="fa fa-paperclip fa-flip-horizontal" title="{{ lang('ATTACH_FORUM') }}"></i>{% endif %}
+			    {% if similar.S_TOPIC_UNAPPROVED or similar.S_POSTS_UNAPPROVED %}<a href="{{ similar.U_MCP_QUEUE }}">{{ similar.UNAPPROVED_IMG }}</a> {% endif %}
+			    {% if similar.S_TOPIC_REPORTED %}<a href="{{ similar.U_MCP_REPORT }}">{{ REPORTED_IMG }}</a>{% endif %}<br />
+				{% EVENT topiclist_row_topic_title_after %}
+			    {% if similar.pagination|length %}
+				    <ul class="pagination pagination-forum pagination-xs pull-right hidden-sm hidden-xs">
+						{% for pagination in similar.pagination %}
+						 {% if pagination.S_IS_PREV %}
+						 {% elseif pagination.S_IS_CURRENT %}<li class="active">{{ pagination.PAGE_NUMBER }}</li>
+						 {% elseif pagination.S_IS_ELLIPSIS %}<li class="ellipsis"><a>{{ lang('ELLIPSIS') }}</a></li>
+						 {% elseif pagination.S_IS_NEXT %}
+						{% else %}
+						 <li><a href="{similar.pagination.PAGE_URL}">{{ pagination.PAGE_NUMBER }}</a></li>
+						{% endif %}
+						{% endfor %}
+					</ul>		
+			    {% endif %}
+				{% EVENT topiclist_row_topic_by_author_before %}
+				{{ lang('POST_BY_AUTHOR') }}&nbsp;{% EVENT search_results_topic_author_username_prepend %}{{ similar.TOPIC_AUTHOR_FULL }}{% EVENT search_results_topic_author_username_append %}&nbsp;
+				<small>&#45;&nbsp;<time datetime="{{ similar.FIRST_POST_TIME_RFC3339 }}">{{ similar.FIRST_POST_TIME }}</time></small>
+				{{ lang('IN') ~ lang('COLON') }}&nbsp;<a href="{{ similar.U_VIEW_FORUM }}">{{ similar.FORUM_TITLE }}</a>
+				{% EVENT topiclist_row_topic_by_author_after %}
+				{% EVENT topiclist_row_append %}
+				</span>
+			</td>
+			<td class="stats-col">
+			 <span class="stats-wrapper">
+			 {{ similar.TOPIC_REPLIES }}&nbsp;{{ lang('REPLIES') }}<br />{{ similar.TOPIC_VIEWS }}&nbsp;{{ lang('VIEWS') }}
+			 </span>
+			</td>
+			<td class="center">
+			 <span class="last-wrapper">
+				{{ lang('POST_BY_AUTHOR') }}&nbsp;{% EVENT search_results_last_post_author_username_prepend %}{{ similar.LAST_POST_AUTHOR_FULL }}{% EVENT search_results_last_post_author_username_append %}
+				{% if not S_IS_BOT %}<a title="{{ lang('FORUMLIST_LASTPOST') }}" href="{{ similar.U_LAST_POST }}"><i class="mobile-post fa fa-sign-out"></i></a>{% endif %}
+				<br /><small><time datetime="{{ similar.LAST_POST_TIME_RFC3339 }}">{{ similar.LAST_POST_TIME }}</time></small>
+			 </span>
+			</td>
+	    </tr>
+		{% EVENT search_results_topic_after %}
+	  {% endfor %}
+	 </tbody>
+	</table>
+</div>
+{% endif %}
diff --git "[FORUM_EXT]/vse\\similartopics/styles/FLATBOOTS/template/event/ucp_prefs_view_radio_buttons_append.html" "[FORUM_EXT]/vse\\similartopics/styles/FLATBOOTS/template/event/ucp_prefs_view_radio_buttons_append.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/vse\\similartopics/styles/FLATBOOTS/template/event/ucp_prefs_view_radio_buttons_append.html"
@@ -0,0 +1,9 @@
+{% if S_SIMILAR_TOPICS %}
+<div class="control-group">
+	<label class="control-label" for="similar_topics1">{{ lang('DISPLAY_SIMILAR_TOPICS') ~ lang('COLON') }}</label>
+	<div class="controls controls-row">
+	 <div class="radio"><input type="radio" name="similar_topics" id="similar_topics1" value="1"{% if S_DISPLAY_SIMILAR_TOPICS %} checked="checked"{% endif %} /><label for="similar_topics1">{{ lang('YES') }}</label></div>
+	 <div class="radio"><input type="radio" name="similar_topics" id="similar_topics0" value="0"{% if not S_DISPLAY_SIMILAR_TOPICS %} checked="checked"{% endif %} /><label for="similar_topics0">{{ lang('NO') }}</label></div>
+    </div>
+</div>
+{% endif %}
diff --git "[FORUM_EXT]/vse\\similartopics/styles/FLATBOOTS/template/event/viewtopic_body_footer_before.html" "[FORUM_EXT]/vse\\similartopics/styles/FLATBOOTS/template/event/viewtopic_body_footer_before.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/vse\\similartopics/styles/FLATBOOTS/template/event/viewtopic_body_footer_before.html"
@@ -0,0 +1,76 @@
+	{% if loops.similar|length %}
+	<div class="panel panel-forum">
+	<div class="panel-heading">
+	 {{ lang('SIMILAR_TOPICS') }}
+	</div>
+	<div class="panel-inner">
+	<table class="footable table table-striped table-primary table-hover">
+	<thead>
+		<tr>
+			<th data-class="expand">{{ lang('TOPICS') }}</th>
+			<th class="large110" data-hide="phone">{{ lang('TOPICS_POSTS_STATISTICS') }}</th>
+			<th class="large21" data-hide="phone">{{ lang('LAST_POST') }}</th>
+			{% EVENT search_results_topic_header_lastpost_after %}
+		</tr>
+	</thead>
+	<tbody>
+		{% for similar in loops.similar %}
+		{% EVENT search_results_topic_before %}
+		<tr>
+			<td>
+				{% if similar.TOPIC_ICON_IMG %}
+				<i class="topic-icon" style="background-image: url({% if not S_BBEMOJI %}{{ T_ICONS_PATH }}{% endif %}{{ similar.TOPIC_ICON_IMG }}); background-repeat: no-repeat;" title="{{ similar.TOPIC_FOLDER_IMG_ALT }}"></i>
+				{% endif %}
+				<span class="icon-wrapper">
+			    <i class="row-icon-font icon-moon-default2{% if similar.S_POST_ANNOUNCE %} icon-moon-voice2{% endif %}{% if similar.S_POST_GLOBAL %} icon-moon-podcast2{% endif %}{% if similar.S_POST_STICKY %} icon-moon-pushpin2{% endif %}{% if similar.S_HAS_POLL %} icon-moon-poll{% endif %}{% if similar.S_UNREAD_TOPIC %} forum-unread{% else %} forum-read{% endif %}" title="{{ similar.TOPIC_FOLDER_IMG_ALT }}"></i>
+				</span>
+				<i class="row-icon-font-mini{% if similar.S_TOPIC_LOCKED %} icon-moon-lock forumview-lock{% endif %}" title="{{ similar.TOPIC_FOLDER_IMG_ALT }}"></i>
+				<div class="desc-wrapper">
+				{% EVENT topiclist_row_prepend %}
+				{% if similar.S_UNREAD_TOPIC and not S_IS_BOT %}<a href="{{ similar.U_NEWEST_POST }}" title="{{ lang('VIEW_FIRST_UNREAD') }}"><i class="topic-newest fa fa-asterisk"></i></a>{% endif %}{% EVENT topiclist_row_topic_title_before %}<a href="{{ similar.U_VIEW_TOPIC }}" class="topictitle">{{ similar.TOPIC_TITLE }}</a>
+				{% if similar.S_TOPIC_UNAPPROVED or similar.S_POSTS_UNAPPROVED %}<a href="{{ similar.U_MCP_QUEUE }}" title="{{ lang('TOPICS_ROW_NOT_APPROVED') }}">&nbsp;<i class="fa fa-question-circle"></i></a>{% endif %}
+				{% if similar.S_TOPIC_REPORTED %}<a href="{{ similar.U_MCP_REPORT }}" title="{{ lang('TOPICS_ROW_REPORTED') }}">&nbsp;<i class="fa fa-exclamation-circle text-danger"></i></a>{% endif %}
+				{% if similar.pagination|length %}
+					<ul class="pagination pagination-forum pagination-xs pull-right hidden-sm hidden-xs">
+						{% for pagination in similar.pagination %}
+						 {% if pagination.S_IS_PREV %}
+						 {% elseif pagination.S_IS_CURRENT %}<li class="active">{{ pagination.PAGE_NUMBER }}</li>
+						 {% elseif pagination.S_IS_ELLIPSIS %}<li class="ellipsis"><a>{{ lang('ELLIPSIS') }}</a></li>
+						 {% elseif pagination.S_IS_NEXT %}
+						 {% else %}
+						 <li><a href="{{ pagination.PAGE_URL }}">{{ pagination.PAGE_NUMBER }}</a></li>
+						 {% endif %}
+						{% endfor %}
+					</ul>		
+				{% endif %}
+				{% EVENT topiclist_row_topic_title_after %}
+				<br />
+				{% if similar.ATTACH_ICON_IMG %}<i class="fa fa-paperclip fa-flip-horizontal" title="{{ lang('ATTACH_FORUM') }}"></i>{% endif %}
+				{% EVENT topiclist_row_topic_by_author_before %}
+				{{ lang('POST_BY_AUTHOR') }}&nbsp;{% EVENT search_results_topic_author_username_prepend %}{{ similar.TOPIC_AUTHOR_FULL }}{% EVENT search_results_topic_author_username_append %}&nbsp;
+				<small>&#45;&nbsp;<time datetime="{{ similar.FIRST_POST_TIME_RFC3339 }}">{{ similar.FIRST_POST_TIME }}</time>&nbsp;&nbsp;&#45;&nbsp;{{ lang('IN') ~ lang('COLON') }}&nbsp;<a href="{{ similar.U_VIEW_FORUM }}">{{ similar.FORUM_TITLE }}</a></small>
+				{% EVENT topiclist_row_topic_by_author_after %}
+				{% EVENT topiclist_row_append %}
+				</div>
+			</td>
+			<td class="stats-col">
+			 <span class="stats-wrapper">
+			 {{ similar.TOPIC_REPLIES }}&nbsp;{{ lang('REPLIES') }}&nbsp;<br />{{ similar.TOPIC_VIEWS }}&nbsp;{{ lang('VIEWS') }}
+			 </span>
+			</td>
+			<td> 
+			 <span class="last-wrapper text-overflow">
+				{{ lang('POST_BY_AUTHOR') }}&nbsp;{% EVENT search_results_last_post_author_username_prepend %}{{ similar.LAST_POST_AUTHOR_FULL }}{% EVENT search_results_last_post_author_username_append %}
+				{% if not S_IS_BOT %}<a title="{{ lang('FORUMLIST_LASTPOST') }}" href="{{ similar.U_LAST_POST }}"><i class="mobile-post fa fa-sign-out"></i></a>{% endif %}
+				<br /><small><time datetime="{{ similar.LAST_POST_TIME_RFC3339 }}">{{ similar.LAST_POST_TIME }}</time></small>
+			 </span>
+			</td>
+			{% EVENT search_results_topic_row_lastpost_after %}
+		</tr>
+		{% EVENT search_results_topic_after %}
+	{% endfor %}
+	</tbody>
+	</table>
+	</div>
+	</div>
+	{% endif %}
diff --git "[ORIGINAL]/vse\\similartopics/styles/all/template/event/overall_footer_after.html" "[ORIGINAL]/vse\\similartopics/styles/all/template/event/overall_footer_after.html"
deleted file mode 100644
--- "[ORIGINAL]/vse\\similartopics/styles/all/template/event/overall_footer_after.html"
+++ /dev/null
@@ -1,144 +0,0 @@
-{% if S_DYNAMIC_SIMILAR_TOPICS and S_IN_POSTING and not S_EDIT_POST %}
-{% INCLUDECSS '@vse_similartopics/similar_topics_ajax.css' %}
-<script>
-// Dynamic Similar Topics - Real-time search as user types in the subject field
-(function() {
-	// State variables: debounce timer, keyboard selection index, cached DOM elements
-	let searchTimeout, selectedIndex = -1, cachedItems = [];
-	const dropdown = document.getElementById('similar-topics-dropdown');
-	const subjectField = document.getElementById('subject');
-	const listContainer = document.getElementById('similar-topics-list');
-
-	if (!subjectField || !dropdown) return;
-
-	// Disable browser autocomplete to prevent interference with our dropdown
-	subjectField.setAttribute('autocomplete', 'off');
-
-	// Hide dropdown and reset selection state
-	function hideDropdown() {
-		dropdown.style.display = 'none';
-		selectedIndex = -1;
-		cachedItems = [];
-	}
-
-	// Position dropdown below the subject field and show it
-	function showDropdown() {
-		const rect = subjectField.getBoundingClientRect();
-		const isRTL = document.documentElement.dir === 'rtl' || document.body.classList.contains('rtl');
-		
-		Object.assign(dropdown.style, {
-			left: isRTL ? 'auto' : rect.left + 'px',
-			right: 'auto',
-			top: (rect.bottom + window.scrollY) + 'px',
-			width: rect.width + 'px',
-			display: 'block'
-		});
-	}
-
-	// AJAX search for similar topics (minimum 3 characters)
-	function searchSimilarTopics(query) {
-		if (query.length < 3) {
-			hideDropdown();
-			return;
-		}
-
-		const xhr = new XMLHttpRequest();
-		const baseUrl = '{{ U_PST_AJAX_SEARCH|e('js') }}';
-		const separator = baseUrl.includes('?') ? '&' : '?';
-		xhr.open('GET', baseUrl + separator + 'q=' + encodeURIComponent(query) + '&f={{ FORUM_ID|e('js') }}');
-		xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
-
-		xhr.onreadystatechange = () => {
-			if (xhr.readyState === 4 && xhr.status === 200) {
-				try {
-					const response = JSON.parse(xhr.responseText);
-					displayResults(response.topics);
-				} catch (e) {
-					hideDropdown();
-				}
-			}
-		};
-
-		xhr.send();
-	}
-
-	// Build and display topic results in a dropdown
-	function displayResults(topics) {
-		if (!topics || topics.length === 0) return hideDropdown();
-
-		listContainer.innerHTML = '';
-		topics.forEach(topic => {
-			const item = document.createElement('div');
-			item.className = 'similar-topic-item';
-			const link = document.createElement('a');
-			link.href = topic.url;
-			link.className = 'similar-topic-title';
-			link.textContent = topic.title;
-			link.target = '_blank';
-			item.appendChild(link);
-			listContainer.appendChild(item);
-		});
-
-		// Cache items for keyboard navigation performance
-		cachedItems = listContainer.children;
-		selectedIndex = -1;
-		showDropdown();
-	}
-
-	// Update visual selection highlighting for keyboard navigation
-	function updateSelection() {
-		for (let i = 0; i < cachedItems.length; i++) {
-			cachedItems[i].classList.toggle('selected', i === selectedIndex);
-		}
-	}
-
-	// Open currently selected topic in new tab
-	function openSelectedTopic() {
-		if (selectedIndex >= 0 && selectedIndex < cachedItems.length) {
-			window.open(cachedItems[selectedIndex].querySelector('a').href, '_blank');
-			hideDropdown();
-		}
-	}
-
-	// Debounced search on input (300 ms delay)
-	subjectField.addEventListener('input', () => {
-		clearTimeout(searchTimeout);
-		const query = subjectField.value.trim();
-
-		searchTimeout = setTimeout(() => {
-			searchSimilarTopics(query);
-		}, 300);
-	});
-
-	// Keyboard navigation: Arrow keys to select, Enter to open
-	subjectField.addEventListener('keydown', (e) => {
-		if (dropdown.style.display === 'none' || !cachedItems.length) return;
-
-		const { key, shiftKey, ctrlKey, altKey, metaKey } = e;
-		if ((key === 'ArrowDown' || key === 'ArrowUp') && !shiftKey && !ctrlKey && !altKey && !metaKey) {
-			e.preventDefault();
-			// Cycle through items (wraps around at ends)
-			selectedIndex = key === 'ArrowDown'
-				? (selectedIndex < cachedItems.length - 1 ? selectedIndex + 1 : 0)
-				: (selectedIndex > 0 ? selectedIndex - 1 : cachedItems.length - 1);
-			updateSelection();
-		} else if (key === 'Enter' && selectedIndex >= 0) {
-			e.preventDefault();
-			openSelectedTopic();
-		}
-	});
-
-	// Hide dropdown when the field loses focus (delayed to allow clicks)
-	subjectField.addEventListener('blur', () => {
-		setTimeout(hideDropdown, 200);
-	});
-
-	// Hide dropdown when clicking outside
-	document.addEventListener('click', (e) => {
-		if (!dropdown.contains(e.target) && e.target !== subjectField) {
-			hideDropdown();
-		}
-	});
-})();
-</script>
-{% endif %}
diff --git "[ORIGINAL]/vse\\similartopics/styles/all/template/event/posting_editor_subject_append.html" "[ORIGINAL]/vse\\similartopics/styles/all/template/event/posting_editor_subject_append.html"
deleted file mode 100644
--- "[ORIGINAL]/vse\\similartopics/styles/all/template/event/posting_editor_subject_append.html"
+++ /dev/null
@@ -1,6 +0,0 @@
-{% if S_DYNAMIC_SIMILAR_TOPICS and S_IN_POSTING and not S_EDIT_POST %}
-<div id="similar-topics-dropdown" class="similar-topics-dropdown" style="display: none;">
-	<div class="similar-topics-header">{{ lang('SIMILAR_TOPICS') }}</div>
-	<div id="similar-topics-list" class="similar-topics-list"></div>
-</div>
-{% endif %}
diff --git "[ORIGINAL]/vse\\similartopics/styles/all/theme/similar_topics_ajax.css" "[ORIGINAL]/vse\\similartopics/styles/all/theme/similar_topics_ajax.css"
deleted file mode 100644
--- "[ORIGINAL]/vse\\similartopics/styles/all/theme/similar_topics_ajax.css"
+++ /dev/null
@@ -1,51 +0,0 @@
-.similar-topics-dropdown {
-	background: #ffffff;
-	border: 1px solid #cccccc;
-	border-radius: 3px;
-	box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
-	position: absolute;
-	z-index: 1000;
-	min-width: 300px;
-	max-width: 400px;
-}
-
-.similar-topics-header {
-	font-size: 11px;
-	font-weight: bold;
-	text-transform: uppercase;
-	background: #f5f5f5;
-	border-bottom: 1px solid #dddddd;
-	padding: 8px 12px;
-}
-
-.similar-topics-list {
-	overflow-y: auto;
-	max-height: 200px;
-}
-
-.similar-topic-item {
-	border-bottom: 1px solid #eeeeee;
-	padding: 8px 12px;
-	cursor: pointer;
-	transition: background-color 0.2s;
-}
-
-.similar-topic-item:hover,
-.similar-topic-item.selected {
-	background: #f0f0f0;
-}
-
-.similar-topic-item:last-child {
-	border-bottom: none;
-}
-
-.similar-topic-title {
-	font-size: 12px;
-	line-height: 1.3;
-	text-decoration: none;
-	color: #105289;
-}
-
-.similar-topic-title:hover {
-	text-decoration: underline;
-}
diff --git "[ORIGINAL]/vse\\similartopics/styles/bb3-mobi/template/event/viewtopic_body_footer_before.html" "[FORUM_EXT]/vse\\similartopics/styles/bb3-mobi/template/event/viewtopic_body_footer_before.html"
--- "[ORIGINAL]/vse\\similartopics/styles/bb3-mobi/template/event/viewtopic_body_footer_before.html"
+++ "[FORUM_EXT]/vse\\similartopics/styles/bb3-mobi/template/event/viewtopic_body_footer_before.html"
@@ -14,7 +14,7 @@
 	<a href="{{ similar.U_MCP_QUEUE }}" class="rightside"><img src="{{ T_THEME_PATH }}/images/icon_topic_unapproved.gif" alt=""/></a>{% endif %}
 	{% if similar.S_TOPIC_REPORTED %}
 	<a href="{{ similar.U_MCP_REPORT }}" class="rightside"><img src="{{ T_THEME_PATH }}/images/icon_topic_reported.gif" alt=""/></a>{% endif %}
-	<a href="{{ similar.U_VIEW_TOPIC }}" class="topictitle">{{ similar.TOPIC_TITLE }}</a> <span class="posts">[{% if similar.TOPIC_REPLIES %}{{ similar.TOPIC_REPLIES }}{% else %}1{% endif %}]</span>
+	<a href="{{ similar.U_VIEW_TOPIC }}" class="topictitle">{{ similar.TOPIC_TITLE }}</a> <span class="posts">[{% if similar.REPLIES %}{{ similar.REPLIES }}{% else %}1{% endif %}]</span>
 	{% if not S_IS_BOT %}
 	<br />{{ similar.LAST_POST_AUTHOR_FULL }} &laquo; <a href="{{ similar.U_LAST_POST }}" title="{{ lang('GOTO_LAST_POST') }}">{{ similar.LAST_POST_TIME }}</a>
 	{% endif %}
diff --git "[ORIGINAL]/vse\\similartopics/styles/prosilver/template/event/ucp_prefs_view_radio_buttons_append.html" "[FORUM_EXT]/vse\\similartopics/styles/prosilver/template/event/ucp_prefs_view_radio_buttons_append.html"
--- "[ORIGINAL]/vse\\similartopics/styles/prosilver/template/event/ucp_prefs_view_radio_buttons_append.html"
+++ "[FORUM_EXT]/vse\\similartopics/styles/prosilver/template/event/ucp_prefs_view_radio_buttons_append.html"
@@ -2,8 +2,8 @@
 	<dl>
 		<dt><label for="similar_topics1">{{ lang('DISPLAY_SIMILAR_TOPICS') ~ lang('COLON') }}</label></dt>
 		<dd>
-			<label for="similar_topics1"><input type="radio" name="similar_topics" id="similar_topics1" value="1"{% if S_DISPLAY_SIMILAR_TOPICS %} checked="checked"{% endif %}> {{ lang('YES') }}</label>
-			<label for="similar_topics0"><input type="radio" name="similar_topics" id="similar_topics0" value="0"{% if not S_DISPLAY_SIMILAR_TOPICS %} checked="checked"{% endif %}> {{ lang('NO') }}</label>
+			<label for="similar_topics1"><input type="radio" name="similar_topics" id="similar_topics1" value="1"{% if S_DISPLAY_SIMILAR_TOPICS %} checked="checked"{% endif %} /> {{ lang('YES') }}</label>
+			<label for="similar_topics0"><input type="radio" name="similar_topics" id="similar_topics0" value="0"{% if not S_DISPLAY_SIMILAR_TOPICS %} checked="checked"{% endif %} /> {{ lang('NO') }}</label>
 		</dd>
 	</dl>
 {% endif %}
diff --git "[ORIGINAL]/vse\\similartopics/styles/prosilver/template/event/viewtopic_body_footer_before.html" "[FORUM_EXT]/vse\\similartopics/styles/prosilver/template/event/viewtopic_body_footer_before.html"
--- "[ORIGINAL]/vse\\similartopics/styles/prosilver/template/event/viewtopic_body_footer_before.html"
+++ "[FORUM_EXT]/vse\\similartopics/styles/prosilver/template/event/viewtopic_body_footer_before.html"
@@ -40,13 +40,13 @@
 											<i class="icon fa-exclamation fa-fw icon-red" aria-hidden="true"></i><span class="sr-only">{{ lang('TOPIC_REPORTED') }}</span>
 										</a>
 									{% endif %}
-									<br>
+									<br />
 									{% EVENT topiclist_row_topic_title_after %}
 
 									{% if not S_IS_BOT %}
 										<div class="responsive-show" style="display: none;">
 											{{ lang('LAST_POST') }} {{ lang('POST_BY_AUTHOR') }} {% EVENT search_results_last_post_author_username_prepend %}{{ similar.LAST_POST_AUTHOR_FULL }}{% EVENT search_results_last_post_author_username_append %} &laquo; <a href="{{ similar.U_LAST_POST }}" title="{{ lang('GOTO_LAST_POST') }}"><time datetime="{{ similar.LAST_POST_TIME_RFC3339 }}">{{ similar.LAST_POST_TIME }}</time></a>
-											<br>{{ lang('POSTED') }} {{ lang('IN') }} <a href="{{ similar.U_VIEW_FORUM }}">{{ similar.FORUM_TITLE }}</a>
+											<br />{{ lang('POSTED') }} {{ lang('IN') }} <a href="{{ similar.U_VIEW_FORUM }}">{{ similar.FORUM_TITLE }}</a>
 										</div>
 										{% if similar.TOPIC_REPLIES %}<span class="responsive-show left-box" style="display: none;">{{ lang('REPLIES') ~ lang('COLON') }} <strong>{{ similar.TOPIC_REPLIES }}</strong></span>{% endif %}
 									{% endif %}
@@ -87,7 +87,7 @@
 											<i class="icon fa-external-link-square fa-fw icon-lightgray icon-md" aria-hidden="true"></i><span class="sr-only">{{ VIEW_LATEST_POST }}</span>
 										</a>
 									{% endif %}
-									<br><time datetime="{{ similar.LAST_POST_TIME_RFC3339 }}">{{ similar.LAST_POST_TIME }}</time>
+									<br /><time datetime="{{ similar.LAST_POST_TIME_RFC3339 }}">{{ similar.LAST_POST_TIME }}</time>
 								</span>
 							</dd>
 							{% EVENT search_results_topic_row_lastpost_after %}
```
