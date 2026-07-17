Existem diferencas reais no codigo ou texto. Diferencas de formatacao (espacos, tabs) foram ignoradas abaixo.

```diff
diff --git "[ORIGINAL]/phpbb\\autogroups/CHANGELOG.md" "[FORUM_EXT]/phpbb\\autogroups/CHANGELOG.md"
--- "[ORIGINAL]/phpbb\\autogroups/CHANGELOG.md"
+++ "[FORUM_EXT]/phpbb\\autogroups/CHANGELOG.md"
@@ -1,27 +1,20 @@
 # Changelog
 
-## Version 2.x (for phpBB 3.2.x, 3.3.x and 4.0.x)
+## Version 2.x (for phpBB 3.2.x and 3.3.x)
 
-### 2.0.7 - 2026-03-20
-
-- Allow installations on phpBB4-alpha+ boards via Extension Catalog.
-- Removed old XHTML code.
-- Added Romanian language pack.
-- Updated Dutch language pack.
-
-### 2.0.6 - 2024-01-18
+## 2.0.6 - 2024-01-18
 
 - Fixed PHP warnings that could be caused by a conflict with other extensions.
 - Updated English, French, German and Turkish language packs.
 
-### 2.0.5 - 2022-06-18
+## 2.0.5 - 2022-06-18
 
 - Run membership condition check when a user logs in.
 - Added Portuguese language pack
 
 ### 2.0.4 - 2021-03-12
 
-- Added a new option to exempt members of selected user groups from being affected by an Auto Group rule.
+- Added new option to exempt members of selected user groups from being affected by an Auto Group rule.
 - Fixed potential PHP DEBUG notices.
 - Fixed MSSQL issues with the Warnings and Membership auto group rules.
 - Various minor code and behavior improvements.
@@ -37,7 +30,7 @@
 ### 2.0.2 - 2019-03-27
 
 - Check Membership days after user registrations.
-- Check Post counts after post-approvals.
+- Check Post counts after post approvals.
 - Avoid possible errors with User age due to invalid dates.
 - Added Polish language pack
 - Added Turkish language pack
@@ -56,7 +49,7 @@
 
 ### 1.0.2 - 2016-11-30
 
-- Fixed a new years day bug in the auto group by user age condition
+- Fixed new years day bug in the auto group by user age condition
 - Various code improvements and maintenance
 - Added Croatian language packs
 - Added Chinese language packs
diff --git "[ORIGINAL]/phpbb\\autogroups/adm/style/manage_autogroups.html" "[FORUM_EXT]/phpbb\\autogroups/adm/style/manage_autogroups.html"
--- "[ORIGINAL]/phpbb\\autogroups/adm/style/manage_autogroups.html"
+++ "[FORUM_EXT]/phpbb\\autogroups/adm/style/manage_autogroups.html"
@@ -15,7 +15,7 @@
 		<fieldset>
 			<legend>{{ lang(S_ADD ? 'ACP_AUTOGROUPS_ADD' : 'ACP_AUTOGROUPS_EDIT') }}</legend>
 			<dl>
-				<dt><label for="autogroups_group_id">{{ lang('ACP_AUTOGROUPS_GROUP_NAME') ~ lang('COLON') }}</label><br><span>{{ lang('ACP_AUTOGROUPS_GROUP_NAME_EXPLAIN') }}</span></dt>
+				<dt><label for="autogroups_group_id">{{ lang('ACP_AUTOGROUPS_GROUP_NAME') ~ lang('COLON') }}</label><br /><span>{{ lang('ACP_AUTOGROUPS_GROUP_NAME_EXPLAIN') }}</span></dt>
 				<dd>
 					<select name="autogroups_group_id" id="autogroups_group_id">
 						{% for groups in loops.groups %}
@@ -27,7 +27,7 @@
 				</dd>
 			</dl>
 			<dl>
-				<dt><label for="autogroups_type_id">{{ lang('ACP_AUTOGROUPS_CONDITION_NAME') ~ lang('COLON') }}</label><br><span>{{ lang('ACP_AUTOGROUPS_CONDITION_NAME_EXPLAIN') }}</span></dt>
+				<dt><label for="autogroups_type_id">{{ lang('ACP_AUTOGROUPS_CONDITION_NAME') ~ lang('COLON') }}</label><br /><span>{{ lang('ACP_AUTOGROUPS_CONDITION_NAME_EXPLAIN') }}</span></dt>
 				<dd><select name="autogroups_type_id" id="autogroups_type_id">
 					{% for conditions in loops.conditions %}
 						<option value="{{ conditions.CONDITION_ID }}"{% if conditions.S_SELECTED %} selected="selected"{% endif %}>{{ conditions.CONDITION_NAME }}</option>
@@ -35,25 +35,25 @@
 				</select></dd>
 			</dl>
 			<dl>
-				<dt><label for="autogroups_min_value">{{ lang('ACP_AUTOGROUPS_MIN_VALUE') ~ lang('COLON') }}</label><br><span>{{ lang('ACP_AUTOGROUPS_MIN_VALUE_EXPLAIN') }}</span></dt>
-				<dd><input id="autogroups_min_value" type="number" size="4" name="autogroups_min_value" value="{{ MIN_VALUE }}"></dd>
+				<dt><label for="autogroups_min_value">{{ lang('ACP_AUTOGROUPS_MIN_VALUE') ~ lang('COLON') }}</label><br /><span>{{ lang('ACP_AUTOGROUPS_MIN_VALUE_EXPLAIN') }}</span></dt>
+				<dd><input id="autogroups_min_value" type="number" size="4" name="autogroups_min_value" value="{{ MIN_VALUE }}" /></dd>
 			</dl>
 			<dl>
-				<dt><label for="autogroups_max_value">{{ lang('ACP_AUTOGROUPS_MAX_VALUE') ~ lang('COLON') }}</label><br><span>{{ lang('ACP_AUTOGROUPS_MAX_VALUE_EXPLAIN') }}</span></dt>
-				<dd><input id="autogroups_max_value" type="number" size="4" name="autogroups_max_value" value="{{ MAX_VALUE }}"></dd>
+				<dt><label for="autogroups_max_value">{{ lang('ACP_AUTOGROUPS_MAX_VALUE') ~ lang('COLON') }}</label><br /><span>{{ lang('ACP_AUTOGROUPS_MAX_VALUE_EXPLAIN') }}</span></dt>
+				<dd><input id="autogroups_max_value" type="number" size="4" name="autogroups_max_value" value="{{ MAX_VALUE }}" /></dd>
 			</dl>
 			<dl>
-				<dt><label for="autogroups_default">{{ lang('ACP_AUTOGROUPS_DEFAULT') ~ lang('COLON') }}</label><br><span>{{ lang('ACP_AUTOGROUPS_DEFAULT_EXPLAIN') }} {{ EXEMPT_GROUPS ? lang('ACP_AUTOGROUPS_DEFAULT_EXEMPTION', EXEMPT_GROUPS) : '' }}</span></dt>
-				<dd><label><input type="radio" class="radio" id="autogroups_default" name="autogroups_default" value="1"{% if S_DEFAULT %} checked="checked"{% endif %}> {{ lang('YES') }}</label>
-					<label><input type="radio" class="radio" name="autogroups_default" value="0"{% if not S_DEFAULT %} checked="checked"{% endif %}> {{ lang('NO') }}</label></dd>
+				<dt><label for="autogroups_default">{{ lang('ACP_AUTOGROUPS_DEFAULT') ~ lang('COLON') }}</label><br /><span>{{ lang('ACP_AUTOGROUPS_DEFAULT_EXPLAIN') }} {{ EXEMPT_GROUPS ? lang('ACP_AUTOGROUPS_DEFAULT_EXEMPTION', EXEMPT_GROUPS) : '' }}</span></dt>
+				<dd><label><input type="radio" class="radio" id="autogroups_default" name="autogroups_default" value="1"{% if S_DEFAULT %} checked="checked"{% endif %} /> {{ lang('YES') }}</label>
+					<label><input type="radio" class="radio" name="autogroups_default" value="0"{% if not S_DEFAULT %} checked="checked"{% endif %} /> {{ lang('NO') }}</label></dd>
 			</dl>
 			<dl>
-				<dt><label for="autogroups_notify">{{ lang('ACP_AUTOGROUPS_NOTIFY') ~ lang('COLON') }}</label><br><span>{{ lang('ACP_AUTOGROUPS_NOTIFY_EXPLAIN') }}</span></dt>
-				<dd><label><input type="radio" class="radio" id="autogroups_notify" name="autogroups_notify" value="1"{% if S_NOTIFY %} checked="checked"{% endif %}> {{ lang('YES') }}</label>
-					<label><input type="radio" class="radio" name="autogroups_notify" value="0"{% if not S_NOTIFY %} checked="checked"{% endif %}> {{ lang('NO') }}</label></dd>
+				<dt><label for="autogroups_notify">{{ lang('ACP_AUTOGROUPS_NOTIFY') ~ lang('COLON') }}</label><br /><span>{{ lang('ACP_AUTOGROUPS_NOTIFY_EXPLAIN') }}</span></dt>
+				<dd><label><input type="radio" class="radio" id="autogroups_notify" name="autogroups_notify" value="1"{% if S_NOTIFY %} checked="checked"{% endif %} /> {{ lang('YES') }}</label>
+					<label><input type="radio" class="radio" name="autogroups_notify" value="0"{% if not S_NOTIFY %} checked="checked"{% endif %} /> {{ lang('NO') }}</label></dd>
 			</dl>
 			<dl>
-				<dt><label for="autogroups_excluded_groups">{{ lang('ACP_AUTOGROUPS_EXCLUDE_GROUP') ~ lang('COLON') }}</label><br><span>{{ lang('ACP_AUTOGROUPS_EXCLUDE_GROUP_EXPLAIN') }}</span></dt>
+				<dt><label for="autogroups_excluded_groups">{{ lang('ACP_AUTOGROUPS_EXCLUDE_GROUP') ~ lang('COLON') }}</label><br /><span>{{ lang('ACP_AUTOGROUPS_EXCLUDE_GROUP_EXPLAIN') }}</span></dt>
 				<dd>
 					<select name="autogroups_excluded_groups[]" id="autogroups_excluded_groups" size="10" multiple="multiple">
 						{% for groups in loops.excluded_groups %}
@@ -64,8 +64,8 @@
 			</dl>
 		</fieldset>
 		<p class="submit-buttons">
-			<input class="button1" type="submit" id="submit" name="submit" value="{{ lang('SUBMIT') }}">&nbsp;
-			<input class="button2" type="reset" id="reset" name="reset" value="{{ lang('RESET') }}">
+			<input class="button1" type="submit" id="submit" name="submit" value="{{ lang('SUBMIT') }}" />&nbsp;
+			<input class="button2" type="reset" id="reset" name="reset" value="{{ lang('RESET') }}" />
 			{{ S_FORM_TOKEN }}
 		</p>
 	</form>
@@ -104,8 +104,8 @@
 	</table>
 	<form id="autogroups_add_rule" method="post" action="{{ U_ACTION }}">
 		<fieldset class="quick">
-			<input class="button2" type="submit" name="addrule" value="{{ lang('ACP_AUTOGROUPS_CREATE_RULE') }}">
-			<input type="hidden" name="action" value="add">
+			<input class="button2" type="submit" name="addrule" value="{{ lang('ACP_AUTOGROUPS_CREATE_RULE') }}" />
+			<input type="hidden" name="action" value="add" />
 			{{ S_FORM_TOKEN }}
 		</fieldset>
 	</form>
@@ -113,7 +113,7 @@
 		<fieldset>
 			<legend>{{ lang('GENERAL_OPTIONS') }}</legend>
 			<dl>
-				<dt><label for="group_ids">{{ lang('ACP_AUTOGROUPS_EXEMPT_GROUP') ~ lang('COLON') }}</label><br><span>{{ lang('ACP_AUTOGROUPS_EXEMPT_GROUP_EXPLAIN') }}</span></dt>
+				<dt><label for="group_ids">{{ lang('ACP_AUTOGROUPS_EXEMPT_GROUP') ~ lang('COLON') }}</label><br /><span>{{ lang('ACP_AUTOGROUPS_EXEMPT_GROUP_EXPLAIN') }}</span></dt>
 				<dd>
 					<select name="group_ids[]" id="group_ids" size="10" multiple="multiple">
 						{% for groups in loops.groups %}
@@ -123,7 +123,7 @@
 				</dd>
 			</dl>
 			<p class="quick">
-				<input class="button1" type="submit" id="generalsubmit" name="generalsubmit" value="{{ lang('SUBMIT') }}">
+				<input class="button1" type="submit" id="generalsubmit" name="generalsubmit" value="{{ lang('SUBMIT') }}" />
 			</p>
 		</fieldset>
 	</form>
diff --git "[ORIGINAL]/phpbb\\autogroups/composer.json" "[FORUM_EXT]/phpbb\\autogroups/composer.json"
--- "[ORIGINAL]/phpbb\\autogroups/composer.json"
+++ "[FORUM_EXT]/phpbb\\autogroups/composer.json"
@@ -3,7 +3,7 @@
     "type": "phpbb-extension",
     "description": "An extension that can automate the process of adding and removing users from groups upon reaching specified milestones related to their post count, age, membership, and warnings count.",
     "homepage": "https://www.phpbb.com/customise/db/extension/auto_groups/",
-    "version": "2.0.7",
+    "version": "2.0.6",
     "keywords": [
         "phpbb",
         "extension",
@@ -57,11 +57,11 @@
     ],
     "require": {
         "php": ">=5.5",
-        "composer/installers": "^1.0 || ^2.0",
+        "composer/installers": "~1.0.0",
         "phpbb/phpbb": ">=3.2.0"
     },
     "require-dev": {
-        "phing/phing": "~2.4"
+        "phing/phing": "2.4.*"
     },
     "extra": {
         "display-name": "Auto Groups",
@@ -74,10 +74,5 @@
             "filename": "version_check",
             "ssl": true
         }
-    },
-    "config": {
-        "allow-plugins": {
-            "composer/installers": true
-        }
     }
 }
\ No newline at end of file
diff --git "[FORUM_EXT]/phpbb\\autogroups/diff_full.tmp" "[FORUM_EXT]/phpbb\\autogroups/diff_full.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/phpbb\\autogroups/diff_full.tmp"
@@ -0,0 +1,968 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/CHANGELOG.md" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/CHANGELOG.md"
+index 1c13badcc..cb113957c 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/CHANGELOG.md"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/CHANGELOG.md"
+@@ -1,27 +1,20 @@
+ # Changelog
+ 
+-## Version 2.x (for phpBB 3.2.x, 3.3.x and 4.0.x)
++## Version 2.x (for phpBB 3.2.x and 3.3.x)
+ 
+-### 2.0.7 - 2026-03-20
+-
+-- Allow installations on phpBB4-alpha+ boards via Extension Catalog.
+-- Removed old XHTML code.
+-- Added Romanian language pack.
+-- Updated Dutch language pack.
+-
+-### 2.0.6 - 2024-01-18
++## 2.0.6 - 2024-01-18
+ 
+ - Fixed PHP warnings that could be caused by a conflict with other extensions.
+ - Updated English, French, German and Turkish language packs.
+ 
+-### 2.0.5 - 2022-06-18
++## 2.0.5 - 2022-06-18
+ 
+ - Run membership condition check when a user logs in.
+ - Added Portuguese language pack
+ 
+ ### 2.0.4 - 2021-03-12
+ 
+-- Added a new option to exempt members of selected user groups from being affected by an Auto Group rule.
++- Added new option to exempt members of selected user groups from being affected by an Auto Group rule.
+ - Fixed potential PHP DEBUG notices.
+ - Fixed MSSQL issues with the Warnings and Membership auto group rules.
+ - Various minor code and behavior improvements.
+@@ -37,7 +30,7 @@
+ ### 2.0.2 - 2019-03-27
+ 
+ - Check Membership days after user registrations.
+-- Check Post counts after post-approvals.
++- Check Post counts after post approvals.
+ - Avoid possible errors with User age due to invalid dates.
+ - Added Polish language pack
+ - Added Turkish language pack
+@@ -56,7 +49,7 @@
+ 
+ ### 1.0.2 - 2016-11-30
+ 
+-- Fixed a new years day bug in the auto group by user age condition
++- Fixed new years day bug in the auto group by user age condition
+ - Various code improvements and maintenance
+ - Added Croatian language packs
+ - Added Chinese language packs
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/adm/style/manage_autogroups.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/adm/style/manage_autogroups.html"
+index a7bc931e7..3b3e00852 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/adm/style/manage_autogroups.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/adm/style/manage_autogroups.html"
+@@ -15,7 +15,7 @@
+ 		<fieldset>
+ 			<legend>{{ lang(S_ADD ? 'ACP_AUTOGROUPS_ADD' : 'ACP_AUTOGROUPS_EDIT') }}</legend>
+ 			<dl>
+-				<dt><label for="autogroups_group_id">{{ lang('ACP_AUTOGROUPS_GROUP_NAME') ~ lang('COLON') }}</label><br><span>{{ lang('ACP_AUTOGROUPS_GROUP_NAME_EXPLAIN') }}</span></dt>
++				<dt><label for="autogroups_group_id">{{ lang('ACP_AUTOGROUPS_GROUP_NAME') ~ lang('COLON') }}</label><br /><span>{{ lang('ACP_AUTOGROUPS_GROUP_NAME_EXPLAIN') }}</span></dt>
+ 				<dd>
+ 					<select name="autogroups_group_id" id="autogroups_group_id">
+ 						{% for groups in loops.groups %}
+@@ -27,7 +27,7 @@
+ 				</dd>
+ 			</dl>
+ 			<dl>
+-				<dt><label for="autogroups_type_id">{{ lang('ACP_AUTOGROUPS_CONDITION_NAME') ~ lang('COLON') }}</label><br><span>{{ lang('ACP_AUTOGROUPS_CONDITION_NAME_EXPLAIN') }}</span></dt>
++				<dt><label for="autogroups_type_id">{{ lang('ACP_AUTOGROUPS_CONDITION_NAME') ~ lang('COLON') }}</label><br /><span>{{ lang('ACP_AUTOGROUPS_CONDITION_NAME_EXPLAIN') }}</span></dt>
+ 				<dd><select name="autogroups_type_id" id="autogroups_type_id">
+ 					{% for conditions in loops.conditions %}
+ 						<option value="{{ conditions.CONDITION_ID }}"{% if conditions.S_SELECTED %} selected="selected"{% endif %}>{{ conditions.CONDITION_NAME }}</option>
+@@ -35,25 +35,25 @@
+ 				</select></dd>
+ 			</dl>
+ 			<dl>
+-				<dt><label for="autogroups_min_value">{{ lang('ACP_AUTOGROUPS_MIN_VALUE') ~ lang('COLON') }}</label><br><span>{{ lang('ACP_AUTOGROUPS_MIN_VALUE_EXPLAIN') }}</span></dt>
+-				<dd><input id="autogroups_min_value" type="number" size="4" name="autogroups_min_value" value="{{ MIN_VALUE }}"></dd>
++				<dt><label for="autogroups_min_value">{{ lang('ACP_AUTOGROUPS_MIN_VALUE') ~ lang('COLON') }}</label><br /><span>{{ lang('ACP_AUTOGROUPS_MIN_VALUE_EXPLAIN') }}</span></dt>
++				<dd><input id="autogroups_min_value" type="number" size="4" name="autogroups_min_value" value="{{ MIN_VALUE }}" /></dd>
+ 			</dl>
+ 			<dl>
+-				<dt><label for="autogroups_max_value">{{ lang('ACP_AUTOGROUPS_MAX_VALUE') ~ lang('COLON') }}</label><br><span>{{ lang('ACP_AUTOGROUPS_MAX_VALUE_EXPLAIN') }}</span></dt>
+-				<dd><input id="autogroups_max_value" type="number" size="4" name="autogroups_max_value" value="{{ MAX_VALUE }}"></dd>
++				<dt><label for="autogroups_max_value">{{ lang('ACP_AUTOGROUPS_MAX_VALUE') ~ lang('COLON') }}</label><br /><span>{{ lang('ACP_AUTOGROUPS_MAX_VALUE_EXPLAIN') }}</span></dt>
++				<dd><input id="autogroups_max_value" type="number" size="4" name="autogroups_max_value" value="{{ MAX_VALUE }}" /></dd>
+ 			</dl>
+ 			<dl>
+-				<dt><label for="autogroups_default">{{ lang('ACP_AUTOGROUPS_DEFAULT') ~ lang('COLON') }}</label><br><span>{{ lang('ACP_AUTOGROUPS_DEFAULT_EXPLAIN') }} {{ EXEMPT_GROUPS ? lang('ACP_AUTOGROUPS_DEFAULT_EXEMPTION', EXEMPT_GROUPS) : '' }}</span></dt>
+-				<dd><label><input type="radio" class="radio" id="autogroups_default" name="autogroups_default" value="1"{% if S_DEFAULT %} checked="checked"{% endif %}> {{ lang('YES') }}</label>
+-					<label><input type="radio" class="radio" name="autogroups_default" value="0"{% if not S_DEFAULT %} checked="checked"{% endif %}> {{ lang('NO') }}</label></dd>
++				<dt><label for="autogroups_default">{{ lang('ACP_AUTOGROUPS_DEFAULT') ~ lang('COLON') }}</label><br /><span>{{ lang('ACP_AUTOGROUPS_DEFAULT_EXPLAIN') }} {{ EXEMPT_GROUPS ? lang('ACP_AUTOGROUPS_DEFAULT_EXEMPTION', EXEMPT_GROUPS) : '' }}</span></dt>
++				<dd><label><input type="radio" class="radio" id="autogroups_default" name="autogroups_default" value="1"{% if S_DEFAULT %} checked="checked"{% endif %} /> {{ lang('YES') }}</label>
++					<label><input type="radio" class="radio" name="autogroups_default" value="0"{% if not S_DEFAULT %} checked="checked"{% endif %} /> {{ lang('NO') }}</label></dd>
+ 			</dl>
+ 			<dl>
+-				<dt><label for="autogroups_notify">{{ lang('ACP_AUTOGROUPS_NOTIFY') ~ lang('COLON') }}</label><br><span>{{ lang('ACP_AUTOGROUPS_NOTIFY_EXPLAIN') }}</span></dt>
+-				<dd><label><input type="radio" class="radio" id="autogroups_notify" name="autogroups_notify" value="1"{% if S_NOTIFY %} checked="checked"{% endif %}> {{ lang('YES') }}</label>
+-					<label><input type="radio" class="radio" name="autogroups_notify" value="0"{% if not S_NOTIFY %} checked="checked"{% endif %}> {{ lang('NO') }}</label></dd>
++				<dt><label for="autogroups_notify">{{ lang('ACP_AUTOGROUPS_NOTIFY') ~ lang('COLON') }}</label><br /><span>{{ lang('ACP_AUTOGROUPS_NOTIFY_EXPLAIN') }}</span></dt>
++				<dd><label><input type="radio" class="radio" id="autogroups_notify" name="autogroups_notify" value="1"{% if S_NOTIFY %} checked="checked"{% endif %} /> {{ lang('YES') }}</label>
++					<label><input type="radio" class="radio" name="autogroups_notify" value="0"{% if not S_NOTIFY %} checked="checked"{% endif %} /> {{ lang('NO') }}</label></dd>
+ 			</dl>
+ 			<dl>
+-				<dt><label for="autogroups_excluded_groups">{{ lang('ACP_AUTOGROUPS_EXCLUDE_GROUP') ~ lang('COLON') }}</label><br><span>{{ lang('ACP_AUTOGROUPS_EXCLUDE_GROUP_EXPLAIN') }}</span></dt>
++				<dt><label for="autogroups_excluded_groups">{{ lang('ACP_AUTOGROUPS_EXCLUDE_GROUP') ~ lang('COLON') }}</label><br /><span>{{ lang('ACP_AUTOGROUPS_EXCLUDE_GROUP_EXPLAIN') }}</span></dt>
+ 				<dd>
+ 					<select name="autogroups_excluded_groups[]" id="autogroups_excluded_groups" size="10" multiple="multiple">
+ 						{% for groups in loops.excluded_groups %}
+@@ -64,8 +64,8 @@
+ 			</dl>
+ 		</fieldset>
+ 		<p class="submit-buttons">
+-			<input class="button1" type="submit" id="submit" name="submit" value="{{ lang('SUBMIT') }}">&nbsp;
+-			<input class="button2" type="reset" id="reset" name="reset" value="{{ lang('RESET') }}">
++			<input class="button1" type="submit" id="submit" name="submit" value="{{ lang('SUBMIT') }}" />&nbsp;
++			<input class="button2" type="reset" id="reset" name="reset" value="{{ lang('RESET') }}" />
+ 			{{ S_FORM_TOKEN }}
+ 		</p>
+ 	</form>
+@@ -104,8 +104,8 @@
+ 	</table>
+ 	<form id="autogroups_add_rule" method="post" action="{{ U_ACTION }}">
+ 		<fieldset class="quick">
+-			<input class="button2" type="submit" name="addrule" value="{{ lang('ACP_AUTOGROUPS_CREATE_RULE') }}">
+-			<input type="hidden" name="action" value="add">
++			<input class="button2" type="submit" name="addrule" value="{{ lang('ACP_AUTOGROUPS_CREATE_RULE') }}" />
++			<input type="hidden" name="action" value="add" />
+ 			{{ S_FORM_TOKEN }}
+ 		</fieldset>
+ 	</form>
+@@ -113,7 +113,7 @@
+ 		<fieldset>
+ 			<legend>{{ lang('GENERAL_OPTIONS') }}</legend>
+ 			<dl>
+-				<dt><label for="group_ids">{{ lang('ACP_AUTOGROUPS_EXEMPT_GROUP') ~ lang('COLON') }}</label><br><span>{{ lang('ACP_AUTOGROUPS_EXEMPT_GROUP_EXPLAIN') }}</span></dt>
++				<dt><label for="group_ids">{{ lang('ACP_AUTOGROUPS_EXEMPT_GROUP') ~ lang('COLON') }}</label><br /><span>{{ lang('ACP_AUTOGROUPS_EXEMPT_GROUP_EXPLAIN') }}</span></dt>
+ 				<dd>
+ 					<select name="group_ids[]" id="group_ids" size="10" multiple="multiple">
+ 						{% for groups in loops.groups %}
+@@ -123,7 +123,7 @@
+ 				</dd>
+ 			</dl>
+ 			<p class="quick">
+-				<input class="button1" type="submit" id="generalsubmit" name="generalsubmit" value="{{ lang('SUBMIT') }}">
++				<input class="button1" type="submit" id="generalsubmit" name="generalsubmit" value="{{ lang('SUBMIT') }}" />
+ 			</p>
+ 		</fieldset>
+ 	</form>
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/composer.json"
+index e4b6156a0..c69d15523 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/composer.json"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/composer.json"
+@@ -3,7 +3,7 @@
+     "type": "phpbb-extension",
+     "description": "An extension that can automate the process of adding and removing users from groups upon reaching specified milestones related to their post count, age, membership, and warnings count.",
+     "homepage": "https://www.phpbb.com/customise/db/extension/auto_groups/",
+-    "version": "2.0.7",
++    "version": "2.0.6",
+     "keywords": [
+         "phpbb",
+         "extension",
+@@ -57,11 +57,11 @@
+     ],
+     "require": {
+         "php": ">=5.5",
+-        "composer/installers": "^1.0 || ^2.0",
++        "composer/installers": "~1.0.0",
+         "phpbb/phpbb": ">=3.2.0"
+     },
+     "require-dev": {
+-        "phing/phing": "~2.4"
++        "phing/phing": "2.4.*"
+     },
+     "extra": {
+         "display-name": "Auto Groups",
+@@ -74,10 +74,5 @@
+             "filename": "version_check",
+             "ssl": true
+         }
+-    },
+-    "config": {
+-        "allow-plugins": {
+-            "composer/installers": true
+-        }
+     }
+ }
+\ No newline at end of file
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/diff_full.tmp"
+new file mode 100644
+index 000000000..9e383e84e
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/diff_full.tmp"
+@@ -0,0 +1,118 @@
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/CHANGELOG.md" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/CHANGELOG.md"
++index 1c13badcc..cb113957c 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/CHANGELOG.md"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/CHANGELOG.md"
++@@ -1,27 +1,20 @@
++ # Changelog
++ 
++-## Version 2.x (for phpBB 3.2.x, 3.3.x and 4.0.x)
+++## Version 2.x (for phpBB 3.2.x and 3.3.x)
++ 
++-### 2.0.7 - 2026-03-20
++-
++-- Allow installations on phpBB4-alpha+ boards via Extension Catalog.
++-- Removed old XHTML code.
++-- Added Romanian language pack.
++-- Updated Dutch language pack.
++-
++-### 2.0.6 - 2024-01-18
+++## 2.0.6 - 2024-01-18
++ 
++ - Fixed PHP warnings that could be caused by a conflict with other extensions.
++ - Updated English, French, German and Turkish language packs.
++ 
++-### 2.0.5 - 2022-06-18
+++## 2.0.5 - 2022-06-18
++ 
++ - Run membership condition check when a user logs in.
++ - Added Portuguese language pack
++ 
++ ### 2.0.4 - 2021-03-12
++ 
++-- Added a new option to exempt members of selected user groups from being affected by an Auto Group rule.
+++- Added new option to exempt members of selected user groups from being affected by an Auto Group rule.
++ - Fixed potential PHP DEBUG notices.
++ - Fixed MSSQL issues with the Warnings and Membership auto group rules.
++ - Various minor code and behavior improvements.
++@@ -37,7 +30,7 @@
++ ### 2.0.2 - 2019-03-27
++ 
++ - Check Membership days after user registrations.
++-- Check Post counts after post-approvals.
+++- Check Post counts after post approvals.
++ - Avoid possible errors with User age due to invalid dates.
++ - Added Polish language pack
++ - Added Turkish language pack
++@@ -56,7 +49,7 @@
++ 
++ ### 1.0.2 - 2016-11-30
++ 
++-- Fixed a new years day bug in the auto group by user age condition
+++- Fixed new years day bug in the auto group by user age condition
++ - Various code improvements and maintenance
++ - Added Croatian language packs
++ - Added Chinese language packs
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/adm/style/manage_autogroups.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/adm/style/manage_autogroups.html"
++index a7bc931e7..3b3e00852 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/adm/style/manage_autogroups.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/adm/style/manage_autogroups.html"
++@@ -15,7 +15,7 @@
++ 		<fieldset>
++ 			<legend>{{ lang(S_ADD ? 'ACP_AUTOGROUPS_ADD' : 'ACP_AUTOGROUPS_EDIT') }}</legend>
++ 			<dl>
++-				<dt><label for="autogroups_group_id">{{ lang('ACP_AUTOGROUPS_GROUP_NAME') ~ lang('COLON') }}</label><br><span>{{ lang('ACP_AUTOGROUPS_GROUP_NAME_EXPLAIN') }}</span></dt>
+++				<dt><label for="autogroups_group_id">{{ lang('ACP_AUTOGROUPS_GROUP_NAME') ~ lang('COLON') }}</label><br /><span>{{ lang('ACP_AUTOGROUPS_GROUP_NAME_EXPLAIN') }}</span></dt>
++ 				<dd>
++ 					<select name="autogroups_group_id" id="autogroups_group_id">
++ 						{% for groups in loops.groups %}
++@@ -27,7 +27,7 @@
++ 				</dd>
++ 			</dl>
++ 			<dl>
++-				<dt><label for="autogroups_type_id">{{ lang('ACP_AUTOGROUPS_CONDITION_NAME') ~ lang('COLON') }}</label><br><span>{{ lang('ACP_AUTOGROUPS_CONDITION_NAME_EXPLAIN') }}</span></dt>
+++				<dt><label for="autogroups_type_id">{{ lang('ACP_AUTOGROUPS_CONDITION_NAME') ~ lang('COLON') }}</label><br /><span>{{ lang('ACP_AUTOGROUPS_CONDITION_NAME_EXPLAIN') }}</span></dt>
++ 				<dd><select name="autogroups_type_id" id="autogroups_type_id">
++ 					{% for conditions in loops.conditions %}
++ 						<option value="{{ conditions.CONDITION_ID }}"{% if conditions.S_SELECTED %} selected="selected"{% endif %}>{{ conditions.CONDITION_NAME }}</option>
++@@ -35,25 +35,25 @@
++ 				</select></dd>
++ 			</dl>
++ 			<dl>
++-				<dt><label for="autogroups_min_value">{{ lang('ACP_AUTOGROUPS_MIN_VALUE') ~ lang('COLON') }}</label><br><span>{{ lang('ACP_AUTOGROUPS_MIN_VALUE_EXPLAIN') }}</span></dt>
++-				<dd><input id="autogroups_min_value" type="number" size="4" name="autogroups_min_value" value="{{ MIN_VALUE }}"></dd>
+++				<dt><label for="autogroups_min_value">{{ lang('ACP_AUTOGROUPS_MIN_VALUE') ~ lang('COLON') }}</label><br /><span>{{ lang('ACP_AUTOGROUPS_MIN_VALUE_EXPLAIN') }}</span></dt>
+++				<dd><input id="autogroups_min_value" type="number" size="4" name="autogroups_min_value" value="{{ MIN_VALUE }}" /></dd>
++ 			</dl>
++ 			<dl>
++-				<dt><label for="autogroups_max_value">{{ lang('ACP_AUTOGROUPS_MAX_VALUE') ~ lang('COLON') }}</label><br><span>{{ lang('ACP_AUTOGROUPS_MAX_VALUE_EXPLAIN') }}</span></dt>
++-				<dd><input id="autogroups_max_value" type="number" size="4" name="autogroups_max_value" value="{{ MAX_VALUE }}"></dd>
+++				<dt><label for="autogroups_max_value">{{ lang('ACP_AUTOGROUPS_MAX_VALUE') ~ lang('COLON') }}</label><br /><span>{{ lang('ACP_AUTOGROUPS_MAX_VALUE_EXPLAIN') }}</span></dt>
+++				<dd><input id="autogroups_max_value" type="number" size="4" name="autogroups_max_value" value="{{ MAX_VALUE }}" /></dd>
++ 			</dl>
++ 			<dl>
++-				<dt><label for="autogroups_default">{{ lang('ACP_AUTOGROUPS_DEFAULT') ~ lang('COLON') }}</label><br><span>{{ lang('ACP_AUTOGROUPS_DEFAULT_EXPLAIN') }} {{ EXEMPT_GROUPS ? lang('ACP_AUTOGROUPS_DEFAULT_EXEMPTION', EXEMPT_GROUPS) : '' }}</span></dt>
++-				<dd><label><input type="radio" class="radio" id="autogroups_default" name="autogroups_default" value="1"{% if S_DEFAULT %} checked="checked"{% endif %}> {{ lang('YES') }}</label>
++-					<label><input type="radio" class="radio" name="autogroups_default" value="0"{% if not S_DEFAULT %} checked="checked"{% endif %}> {{ lang('NO') }}</label></dd>
+++				<dt><label for="autogroups_default">{{ lang('ACP_AUTOGROUPS_DEFAULT') ~ lang('COLON') }}</label><br /><span>{{ lang('ACP_AUTOGROUPS_DEFAULT_EXPLAIN') }} {{ EXEMPT_GROUPS ? lang('ACP_AUTOGROUPS_DEFAULT_EXEMPTION', EXEMPT_GROUPS) : '' }}</span></dt>
+++				<dd><label><input type="radio" class="radio" id="autogroups_default" name="autogroups_default" value="1"{% if S_DEFAULT %} checked="checked"{% endif %} /> {{ lang('YES') }}</label>
+++					<label><input type="radio" class="radio" name="autogroups_default" value="0"{% if not S_DEFAULT %} checked="checked"{% endif %} /> {{ lang('NO') }}</label></dd>
++ 			</dl>
++ 			<dl>
++-				<dt><label for="autogroups_notify">{{ lang('ACP_AUTOGROUPS_NOTIFY') ~ lang('COLON') }}</label><br><span>{{ lang('ACP_AUTOGROUPS_NOTIFY_EXPLAIN') }}</span></dt>
++-				<dd><label><input type="radio" class="radio" id="autogroups_notify" name="autogroups_notify" value="1"{% if S_NOTIFY %} checked="checked"{% endif %}> {{ lang('YES') }}</label>
++-					<label><input type="radio" class="radio" name="autogroups_notify" value="0"{% if not S_NOTIFY %} checked="checked"{% endif %}> {{ lang('NO') }}</label></dd>
+++				<dt><label for="autogroups_notify">{{ lang('ACP_AUTOGROUPS_NOTIFY') ~ lang('COLON') }}</label><br /><span>{{ lang('ACP_AUTOGROUPS_NOTIFY_EXPLAIN') }}</span></dt>
+++				<dd><label><input type="radio" class="radio" id="autogroups_notify" name="autogroups_notify" value="1"{% if S_NOTIFY %} checked="checked"{% endif %} /> {{ lang('YES') }}</label>
+++					<label><input type="radio" class="radio" name="autogroups_notify" value="0"{% if not S_NOTIFY %} checked="checked"{% endif %} /> {{ lang('NO') }}</label></dd>
++ 			</dl>
++ 			<dl>
++-				<dt><label for="autogroups_excluded_groups">{{ lang('ACP_AUTOGROUPS_EXCLUDE_GROUP') ~ lang('COLON') }}</label><br><span>{{ lang('ACP_AUTOGROUPS_EXCLUDE_GROUP_EXPLAIN') }}</span></dt>
+++				<dt><label for="autogroups_excluded_groups">{{ lang('ACP_AUTOGROUPS_EXCLUDE_GROUP') ~ lang('COLON') }}</label><br /><span>{{ lang('ACP_AUTOGROUPS_EXCLUDE_GROUP_EXPLAIN') }}</span></dt>
++ 				<dd>
++ 					<select name="autogroups_excluded_groups[]" id="autogroups_excluded_groups" size="10" multiple="multiple">
++ 						{% for groups in loops.excluded_groups %}
++@@ -64,8 +64,8 @@
++ 			</dl>
++ 		</fieldset>
++ 		<p class="submit-buttons">
++-			<input class="button1" type="submit" id="submit" name="submit" value="{{ lang('SUBMIT')
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/ext.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/ext.php"
+index 1b43ce6cc..0ea7e298a 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/ext.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/ext.php"
+@@ -59,7 +59,7 @@ class ext extends \phpbb\extension\base
+ 	 */
+ 	protected function check_php_version()
+ 	{
+-		return PHP_VERSION_ID >= 50500;
++		return phpbb_version_compare(PHP_VERSION, '5.5.0', '>=');
+ 	}
+ 
+ 	/**
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/language/ar/autogroups_acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/language/ar/autogroups_acp.php"
+index 90ded00e8..cb914191f 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/language/ar/autogroups_acp.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/language/ar/autogroups_acp.php"
+@@ -71,7 +71,7 @@ $lang = array_merge($lang, array(
+ 	'ACP_AUTOGROUPS_DELETE_SUCCESS'	=> 'تم حذف المجموعة التلقائية بنجاح.',
+ 	'ACP_AUTOGROUPS_EMPTY'			=> 'لا توجد مجموعات تلقائية.',
+ 	'ACP_AUTOGROUPS_NO_GROUPS'		=> 'لا توجد مجموعات',
+-	'ACP_AUTOGROUPS_INVALID_GROUPS'	=> 'هناك خطأ. لم يتم تحديد مجموعة عضو.<br>يمكن استخدام المجموعات التلقائية فقط مع مجموعات العضو المعروفة , والتي يمكن انشائها بواسطة صفحة إدارة المجموعات.',
++	'ACP_AUTOGROUPS_INVALID_GROUPS'	=> 'هناك خطأ. لم يتم تحديد مجموعة عضو.<br />يمكن استخدام المجموعات التلقائية فقط مع مجموعات العضو المعروفة , والتي يمكن انشائها بواسطة صفحة إدارة المجموعات.',
+ 	'ACP_AUTOGROUPS_INVALID_RANGE'	=> 'هناك خطأ. لا تستطيع ضبط نفس القيمة في الحد الأعلى و الحد الأدني.',
+ 
+ 	// Conditions
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/language/cs/autogroups_acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/language/cs/autogroups_acp.php"
+index f6d540571..9d55ebca4 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/language/cs/autogroups_acp.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/language/cs/autogroups_acp.php"
+@@ -70,7 +70,7 @@ $lang = array_merge($lang, array(
+ 	'ACP_AUTOGROUPS_DELETE_SUCCESS'	=> 'Auto skupina byla úspěšně odstraněna.',
+ 	'ACP_AUTOGROUPS_EMPTY'			=> 'Neexistují žádné auto skupiny.',
+ 	'ACP_AUTOGROUPS_NO_GROUPS'		=> 'K dispozici nejsou žádné skupiny',
+-	'ACP_AUTOGROUPS_INVALID_GROUPS'	=> 'Vyskytla se chyba. Platná skupina uživatelů nebyla vybrána.<br>Auto Skupiny mohou být použity pouze s uživatelsky definovanými skupinami, které mohou být vytvořeny na straně správa skupin.',
++	'ACP_AUTOGROUPS_INVALID_GROUPS'	=> 'Vyskytla se chyba. Platná skupina uživatelů nebyla vybrána.<br />Auto Skupiny mohou být použity pouze s uživatelsky definovanými skupinami, které mohou být vytvořeny na straně správa skupin.',
+ 	'ACP_AUTOGROUPS_INVALID_RANGE'	=> 'Vyskytla se chyba. Minimální a maximální hodnoty nelze nastavit na stejnou hodnotu.',
+ 
+ 	// Conditions
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/language/da/autogroups_acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/language/da/autogroups_acp.php"
+index e571ead7f..712f6d8d5 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/language/da/autogroups_acp.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/language/da/autogroups_acp.php"
+@@ -70,7 +70,7 @@ $lang = array_merge($lang, array(
+ 	'ACP_AUTOGROUPS_DELETE_SUCCESS'	=> 'Autogruppe slettet.',
+ 	'ACP_AUTOGROUPS_EMPTY'			=> 'Der er ingen autogrupper.',
+ 	'ACP_AUTOGROUPS_NO_GROUPS'		=> 'Ingen grupper tilgængelig',
+-	'ACP_AUTOGROUPS_INVALID_GROUPS'	=> 'Der opstod en fejl. Der var ikke valgt nogen gyldig brugergruppe.<br>Autogrupper kan kun bruges med brugerdefinerede grupper, som kan oprettes på Håndter grupper-siden.',
++	'ACP_AUTOGROUPS_INVALID_GROUPS'	=> 'Der opstod en fejl. Der var ikke valgt nogen gyldig brugergruppe.<br />Autogrupper kan kun bruges med brugerdefinerede grupper, som kan oprettes på Håndter grupper-siden.',
+ 	'ACP_AUTOGROUPS_INVALID_RANGE'	=> 'Der opstod en fejl. Minimums- og maksimumsværdier kan ikke sættes til den samme værdi.',
+ 
+ 	// Conditions
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/language/de/autogroups_acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/language/de/autogroups_acp.php"
+index a7c43bc16..59ddcf9f9 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/language/de/autogroups_acp.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/language/de/autogroups_acp.php"
+@@ -70,7 +70,7 @@ $lang = array_merge($lang, array(
+ 	'ACP_AUTOGROUPS_DELETE_SUCCESS'	=> 'Auto-Gruppe erfolgreich gelöscht.',
+ 	'ACP_AUTOGROUPS_EMPTY'			=> 'Es gibt keine Auto-Gruppen.',
+ 	'ACP_AUTOGROUPS_NO_GROUPS'		=> 'Keine Gruppen vorhanden',
+-	'ACP_AUTOGROUPS_INVALID_GROUPS'	=> 'Ein Fehler ist aufgetreten. Es wurde keine gültige Gruppe ausgewählt.<br>Auto Groups kann nur mit benutzerdefinierten Gruppen verwendet werden, welche über die Gruppenverwaltung erstellt werden können.',
++	'ACP_AUTOGROUPS_INVALID_GROUPS'	=> 'Ein Fehler ist aufgetreten. Es wurde keine gültige Gruppe ausgewählt.<br />Auto Groups kann nur mit benutzerdefinierten Gruppen verwendet werden, welche über die Gruppenverwaltung erstellt werden können.',
+ 	'ACP_AUTOGROUPS_INVALID_RANGE'	=> 'Ein Fehler ist aufgetreten. Minimal- und Maximalwerte können nicht auf den gleichen Wert eingestellt werden.',
+ 
+ 	// Conditions
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/language/en/autogroups_acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/language/en/autogroups_acp.php"
+index 3efebd72d..6a1c7be0c 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/language/en/autogroups_acp.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/language/en/autogroups_acp.php"
+@@ -70,7 +70,7 @@ $lang = array_merge($lang, array(
+ 	'ACP_AUTOGROUPS_DELETE_SUCCESS'	=> 'Auto Group successfully deleted.',
+ 	'ACP_AUTOGROUPS_EMPTY'			=> 'There are no auto groups.',
+ 	'ACP_AUTOGROUPS_NO_GROUPS'		=> 'No groups available',
+-	'ACP_AUTOGROUPS_INVALID_GROUPS'	=> 'An error occurred. A valid user group was not selected.<br>Auto Groups can only be used with user defined groups, which can be created on the Manage groups page.',
++	'ACP_AUTOGROUPS_INVALID_GROUPS'	=> 'An error occurred. A valid user group was not selected.<br />Auto Groups can only be used with user defined groups, which can be created on the Manage groups page.',
+ 	'ACP_AUTOGROUPS_INVALID_RANGE'	=> 'An error occurred. Minimum and maximum values can not be set to the same value.',
+ 
+ 	// Conditions
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/language/es/autogroups_acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/language/es/autogroups_acp.php"
+index 95b69614c..0f1364ac6 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/language/es/autogroups_acp.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/language/es/autogroups_acp.php"
+@@ -71,7 +71,7 @@ $lang = array_merge($lang, array(
+ 	'ACP_AUTOGROUPS_DELETE_SUCCESS'	=> 'Auto Grupo borrado correctamente.',
+ 	'ACP_AUTOGROUPS_EMPTY'			=> 'No hay Auto Grupos.',
+ 	'ACP_AUTOGROUPS_NO_GROUPS'		=> 'No hay grupos disponibles',
+-	'ACP_AUTOGROUPS_INVALID_GROUPS'	=> 'Ocurrio un error. Un grupo de usuario válido no fue seleccionado.<br>Auto Grupos sólo se puede utilizar con los grupos definidos por el usuario, estos se pueden crear en la página Administrar grupos.',
++	'ACP_AUTOGROUPS_INVALID_GROUPS'	=> 'Ocurrio un error. Un grupo de usuario válido no fue seleccionado.<br />Auto Grupos sólo se puede utilizar con los grupos definidos por el usuario, estos se pueden crear en la página Administrar grupos.',
+ 	'ACP_AUTOGROUPS_INVALID_RANGE'	=> 'Ocurrio un error. Los valores mínimos y máximos no se pueden establecer con el mismo valor.',
+ 
+ 	// Conditions
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/language/et/autogroups_acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/language/et/autogroups_acp.php"
+index 02337e2d2..c6e655460 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/language/et/autogroups_acp.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/language/et/autogroups_acp.php"
+@@ -71,7 +71,7 @@ $lang = array_merge($lang, array(
+ 	'ACP_AUTOGROUPS_DELETE_SUCCESS'	=> 'Automaatne grupp on edukalt kustutatud.',
+ 	'ACP_AUTOGROUPS_EMPTY'			=> 'Ühtegi automaatset gruppi ei ole.',
+ 	'ACP_AUTOGROUPS_NO_GROUPS'		=> 'Ühtegi gruppi ei ole saadaval.',
+-	'ACP_AUTOGROUPS_INVALID_GROUPS'	=> 'Tekkis viga. Kehtivat kasutajagruppi ei ole valitud.<br>Automaatseid gruppe saab kasutada ainult siis, kui liikmele on määratud grupid, mida saab luua grupide halduse leheküljel.',
++	'ACP_AUTOGROUPS_INVALID_GROUPS'	=> 'Tekkis viga. Kehtivat kasutajagruppi ei ole valitud.<br />Automaatseid gruppe saab kasutada ainult siis, kui liikmele on määratud grupid, mida saab luua grupide halduse leheküljel.',
+ 	'ACP_AUTOGROUPS_INVALID_RANGE'	=> 'Tekkis viga. Minimaalset ja maksimaalset väärtust ei saa seadistada samade väärtustega.',
+ 
+ 	// Conditions
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/language/fr/autogroups_acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/language/fr/autogroups_acp.php"
+index f0d07e2bc..da08a61ec 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/language/fr/autogroups_acp.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/language/fr/autogroups_acp.php"
+@@ -71,7 +71,7 @@ $lang = array_merge($lang, array(
+ 	'ACP_AUTOGROUPS_DELETE_SUCCESS'	=> 'Le groupe automatique a été supprimé avec succès.',
+ 	'ACP_AUTOGROUPS_EMPTY'			=> 'Il n’y a aucun groupe automatique.',
+ 	'ACP_AUTOGROUPS_NO_GROUPS'		=> 'Aucun groupe disponible',
+-	'ACP_AUTOGROUPS_INVALID_GROUPS'	=> 'Une erreur est survenue. Aucun groupe d’utilisateur valide n’a été sélectionné.<br>L’extension Auto Groups fonctionne uniquement avec des groupes d’utilisateurs définis, pouvant être créés depuis la page « Gérer les groupes ».',
++	'ACP_AUTOGROUPS_INVALID_GROUPS'	=> 'Une erreur est survenue. Aucun groupe d’utilisateur valide n’a été sélectionné.<br />L’extension Auto Groups fonctionne uniquement avec des groupes d’utilisateurs définis, pouvant être créés depuis la page « Gérer les groupes ».',
+ 	'ACP_AUTOGROUPS_INVALID_RANGE'	=> 'Une erreur est survenue. La valeur minimale et la valeur maximale ne peuvent être identiques.',
+ 
+ 	// Conditions
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/language/hr/autogroups_acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/language/hr/autogroups_acp.php"
+index 6d3db7d8f..d3b2af62a 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/language/hr/autogroups_acp.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/language/hr/autogroups_acp.php"
+@@ -71,7 +71,7 @@ $lang = array_merge($lang, array(
+ 	'ACP_AUTOGROUPS_DELETE_SUCCESS'	=> 'Automatsko upravljanje izabranom grupom je izbrisano.',
+ 	'ACP_AUTOGROUPS_EMPTY'			=> 'There are no auto groups.',
+ 	'ACP_AUTOGROUPS_NO_GROUPS'		=> 'Nema dostupnih grupa',
+-	'ACP_AUTOGROUPS_INVALID_GROUPS'	=> 'Došlo je do greške: nije izabrana niti jedna grupa.<br>Automatsko upravljanje grupom/ama može se primijeniti samo na korisnički dodane grupe.',
++	'ACP_AUTOGROUPS_INVALID_GROUPS'	=> 'Došlo je do greške: nije izabrana niti jedna grupa.<br />Automatsko upravljanje grupom/ama može se primijeniti samo na korisnički dodane grupe.',
+ 	'ACP_AUTOGROUPS_INVALID_RANGE'	=> 'Došlo je do greške: minimalna i maksimalna vrijednost ne mogu biti postavljene na istu vrijednost.',
+ 
+ 	// Conditions
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/language/hr_x_vi/autogroups_acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/language/hr_x_vi/autogroups_acp.php"
+index bb6c89ba6..e37242340 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/language/hr_x_vi/autogroups_acp.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/language/hr_x_vi/autogroups_acp.php"
+@@ -71,7 +71,7 @@ $lang = array_merge($lang, array(
+ 	'ACP_AUTOGROUPS_DELETE_SUCCESS'	=> 'Automatsko upravljanje izabranom grupom je izbrisano.',
+ 	'ACP_AUTOGROUPS_EMPTY'			=> 'There are no auto groups.',
+ 	'ACP_AUTOGROUPS_NO_GROUPS'		=> 'Nema dostupnih grupa',
+-	'ACP_AUTOGROUPS_INVALID_GROUPS'	=> 'Došlo je do greške: nije izabrana niti jedna grupa.<br>Automatsko upravljanje grupom/ama može se primijeniti samo na korisnički dodane grupe.',
++	'ACP_AUTOGROUPS_INVALID_GROUPS'	=> 'Došlo je do greške: nije izabrana niti jedna grupa.<br />Automatsko upravljanje grupom/ama može se primijeniti samo na korisnički dodane grupe.',
+ 	'ACP_AUTOGROUPS_INVALID_RANGE'	=> 'Došlo je do greške: minimalna i maksimalna vrijednost ne mogu biti postavljene na istu vrijednost.',
+ 
+ 	// Conditions
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/language/it/autogroups_acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/language/it/autogroups_acp.php"
+index bcc4ff9fd..e844104c6 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/language/it/autogroups_acp.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/language/it/autogroups_acp.php"
+@@ -70,7 +70,7 @@ $lang = array_merge($lang, array(
+ 	'ACP_AUTOGROUPS_DELETE_SUCCESS'	=> 'Autogruppo rimosso correttamente.',
+ 	'ACP_AUTOGROUPS_EMPTY'			=> 'Non ci sono autogruppi.',
+ 	'ACP_AUTOGROUPS_NO_GROUPS'		=> 'Non ci sono gruppi a disposizione',
+-	'ACP_AUTOGROUPS_INVALID_GROUPS'	=> 'Si è verificato un errore: non è stato selezionato un gruppo utente valido.<br>Autogruppi può essere usato solo con gruppi utenti, creabili nella pagina Gestisci gruppi.',
++	'ACP_AUTOGROUPS_INVALID_GROUPS'	=> 'Si è verificato un errore: non è stato selezionato un gruppo utente valido.<br />Autogruppi può essere usato solo con gruppi utenti, creabili nella pagina Gestisci gruppi.',
+ 	'ACP_AUTOGROUPS_INVALID_RANGE'	=> 'Si è verificato un errore: il valore minimo e il valore massimo non possono coincidere.',
+ 
+ 	// Conditions
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/language/nl/autogroups_acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/language/nl/autogroups_acp.php"
+index 3ef422463..fdd5251f5 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/language/nl/autogroups_acp.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/language/nl/autogroups_acp.php"
+@@ -39,45 +39,45 @@ if (empty($lang) || !is_array($lang))
+ //
+ 
+ $lang = array_merge($lang, array(
+-	'ACP_AUTOGROUPS_MANAGE'			=> 'Beheer Auto Groepen',
+-	'ACP_AUTOGROUPS_MANAGE_EXPLAIN'	=> 'Met dit formulier kun je Auto Groepconfiguraties toevoegen, bewerken, bekijken en verwijderen.',
+-	'ACP_AUTOGROUPS_ADD'			=> 'Voeg Auto Groepen toe',
+-	'ACP_AUTOGROUPS_EDIT'			=> 'Bewerk Auto Groepen',
++	'ACP_AUTOGROUPS_MANAGE'			=> 'Beheer Automatische Groepen',
++	'ACP_AUTOGROUPS_MANAGE_EXPLAIN'	=> 'Hier kun je automatische groepen aanmaken, bewerken, weergeven en verwijderen.',
++	'ACP_AUTOGROUPS_ADD'			=> 'Voeg automatische groep toe',
++	'ACP_AUTOGROUPS_EDIT'			=> 'Bewerk automatische groep',
+ 
+ 	'ACP_AUTOGROUPS_GROUP_NAME'				=> 'Groep',
+-	'ACP_AUTOGROUPS_GROUP_NAME_EXPLAIN'		=> 'Kies een groep waaraan gebruikers automatisch worden toegevoegd of verwijderd.',
+-	'ACP_AUTOGROUPS_CONDITION_NAME'			=> 'Auto Groep type',
+-	'ACP_AUTOGROUPS_CONDITION_NAME_EXPLAIN'	=> 'Kies het type voorwaarde waarop gebruikers aan deze groep worden toegevoegd of verwijderd.',
++	'ACP_AUTOGROUPS_GROUP_NAME_EXPLAIN'		=> 'Kies een groep waaraan gebruikers automatisch toegevoegd of verwijderd moeten worden.',
++	'ACP_AUTOGROUPS_CONDITION_NAME'			=> 'Type automatische groep',
++	'ACP_AUTOGROUPS_CONDITION_NAME_EXPLAIN'	=> 'Kies het type conditie waarop gebruikers toegevoegd of verwijderd worden aan deze groep.',
+ 	'ACP_AUTOGROUPS_MIN_VALUE'				=> 'Minimale waarde',
+-	'ACP_AUTOGROUPS_MIN_VALUE_EXPLAIN'		=> 'Gebruikers worden aan deze groep toegevoegd als ze de minimale waarde bereiken of overschrijden.',
++	'ACP_AUTOGROUPS_MIN_VALUE_EXPLAIN'		=> 'Gebruikers worden toegevoegd aan deze groep als de minimale waarde wordt overschreden.',
+ 	'ACP_AUTOGROUPS_MAX_VALUE'				=> 'Maximale waarde',
+-	'ACP_AUTOGROUPS_MAX_VALUE_EXPLAIN'		=> 'Gebruikers worden uit deze groep verwijderd als ze de maximale waarde bereiken of overschrijden. Zet dit op 0 als je niet wilt dat gebruikers worden verwijderd.',
+-	'ACP_AUTOGROUPS_DEFAULT'				=> 'Stel standaardgroep in',
+-	'ACP_AUTOGROUPS_DEFAULT_EXPLAIN'		=> 'Maak dit de nieuwe standaardgroep van de gebruiker.',
+-	'ACP_AUTOGROUPS_DEFAULT_EXEMPTION'		=> 'Dit heeft geen effect op gebruikers waarvan de standaardgroep een van de volgende is: %s.',
+-	'ACP_AUTOGROUPS_NOTIFY'					=> 'Meld gebruikers',
+-	'ACP_AUTOGROUPS_NOTIFY_EXPLAIN'			=> 'Stuur een melding naar gebruikers nadat ze automatisch aan deze groep zijn toegevoegd of verwijderd.',
++	'ACP_AUTOGROUPS_MAX_VALUE_EXPLAIN'		=> 'Gebruikers worden verwijderd van deze groep als de maximale waarde wordt overschreden. Laat dit veld leeg om automatisch verwijderen te voorkomen.',
++	'ACP_AUTOGROUPS_DEFAULT'				=> 'Instellen als standaard groep',
++	'ACP_AUTOGROUPS_DEFAULT_EXPLAIN'		=> 'Maak voor deze gebruikers de groep standaard.',
++	'ACP_AUTOGROUPS_DEFAULT_EXEMPTION'		=> 'Dit heeft geen invloed op gebruikers wiens standaardgroep één van de volgende is: %s.',
++	'ACP_AUTOGROUPS_NOTIFY'					=> 'Notificeer gebruikers',
++	'ACP_AUTOGROUPS_NOTIFY_EXPLAIN'			=> 'Stuur een notificatie naar gebruikers als ze automatisch worden toegevoegd of verwijderd van deze groep.',
+ 
+-	'ACP_AUTOGROUPS_EXCLUDED_GROUPS'		=> 'Uitsluitgroepen',
+-	'ACP_AUTOGROUPS_EXCLUDE_GROUP'			=> 'Negeer leden van deze groepen',
+-	'ACP_AUTOGROUPS_EXCLUDE_GROUP_EXPLAIN'	=> 'Leden die tot <em>om het even welke groep</em> in deze lijst behoren, worden genegeerd. Laat dit veld leeg als je deze Auto Groep op <em>alle leden</em> van je forum wilt toepassen. Selecteer meerdere groepen door <samp>CTRL</samp> (of <samp>&#8984;CMD</samp> op Mac) in te houden en de groepen te selecteren.',
+-	'ACP_AUTOGROUPS_INVALID_EXCLUDE_GROUPS'	=> 'Er is een fout opgetreden. De groep voor deze voorwaarde kan niet ook in het veld "uitgesloten groepen" worden geselecteerd.',
+-	'ACP_AUTOGROUPS_EXEMPT_GROUP'			=> 'Stel standaardgroep uitzonderingen in',
+-	'ACP_AUTOGROUPS_EXEMPT_GROUP_EXPLAIN'	=> 'Auto Groepen zullen de <em>standaardgroep</em> van een gebruiker niet veranderen als deze in deze lijst is geselecteerd. Selecteer meerdere groepen door <samp>CTRL</samp> (of <samp>&#8984;CMD</samp> op Mac) in te houden en de groepen te selecteren.',
++	'ACP_AUTOGROUPS_EXCLUDED_GROUPS'		=> 'Excluded groups',
++	'ACP_AUTOGROUPS_EXCLUDE_GROUP'			=> 'Exclude members of these groups',
++	'ACP_AUTOGROUPS_EXCLUDE_GROUP_EXPLAIN'	=> 'Members belonging to <em>any group</em> selected in this list will be ignored. Leave this field blank if you want this Auto Group applied to <em>all members</em> of your board. Select multiple groups by holding <samp>CTRL</samp> (or <samp>&#8984;CMD</samp> on Mac) and selecting the groups.',
++	'ACP_AUTOGROUPS_INVALID_EXCLUDE_GROUPS'	=> 'An error occurred. The group for this condition can not also be selected in the excluded groups field.',
++	'ACP_AUTOGROUPS_EXEMPT_GROUP'			=> 'Instellen standaard groep uitzonderingen',
++	'ACP_AUTOGROUPS_EXEMPT_GROUP_EXPLAIN'	=> 'Automatische groepen zal niet een gebruiker zijn standaard groep veranderen als deze groep geselecteerd is in deze lijst. Selecteer meerdere groepen door <samp>CTRL</samp> (of <samp>&#8984;CMD</samp> op Mac) ingedrukt te houden en de groepen te selecteren.',
+ 
+-	'ACP_AUTOGROUPS_CREATE_RULE'	=> 'Maak nieuwe Auto Groep aan',
+-	'ACP_AUTOGROUPS_SUBMIT_SUCCESS'	=> 'Auto Groep succesvol geconfigureerd.',
+-	'ACP_AUTOGROUPS_DELETE_CONFIRM'	=> 'Weet je zeker dat je deze Auto Groepconfiguratie wilt verwijderen?',
+-	'ACP_AUTOGROUPS_DELETE_SUCCESS'	=> 'Auto Groep succesvol verwijderd.',
+-	'ACP_AUTOGROUPS_EMPTY'			=> 'Er zijn geen auto groepen.',
++	'ACP_AUTOGROUPS_CREATE_RULE'	=> 'Maak nieuwe automatische groep',
++	'ACP_AUTOGROUPS_SUBMIT_SUCCESS'	=> 'Automatische groep succesvol geconfigureerd',
++	'ACP_AUTOGROUPS_DELETE_CONFIRM'	=> 'Weet je zeker dat je deze automatische groep wilt verwijderen?',
++	'ACP_AUTOGROUPS_DELETE_SUCCESS'	=> 'Automatische groep succesvol verwijderd.',
++	'ACP_AUTOGROUPS_EMPTY'			=> 'Er zijn geen automatische groepen.',
+ 	'ACP_AUTOGROUPS_NO_GROUPS'		=> 'Geen groepen beschikbaar',
+-	'ACP_AUTOGROUPS_INVALID_GROUPS'	=> 'Er is een fout opgetreden. Er is geen geldige gebruikersgroep geselecteerd.<br />Auto Groepen kunnen alleen worden gebruikt met door gebruikers gedefinieerde groepen, die aangemaakt kunnen worden op de pagina "Groepen beheren".',
+-	'ACP_AUTOGROUPS_INVALID_RANGE'	=> 'Er is een fout opgetreden. Minimale en maximale waarden kunnen niet op dezelfde waarde worden ingesteld.',
++	'ACP_AUTOGROUPS_INVALID_GROUPS'	=> 'Er is een fout opgetreden. Er is geen geldige groep geselecteerd.<br />Automatische groepen kan alleen worden gebruikt bij door de beheerder aangemaakte groepen, welke kan worden aangemaakt op de “Beheer groepen pagina”.',
++	'ACP_AUTOGROUPS_INVALID_RANGE'	=> 'Er is een fout opgetreden. De minimale en maximale waarde kunnen niet hetzelfde zijn.',
+ 
+ 	// Conditions
+-	'AUTOGROUPS_TYPE_BIRTHDAYS'		=> 'Gebruikersleeftijd',
++	'AUTOGROUPS_TYPE_BIRTHDAYS'		=> 'Leeftijd',
+ 	'AUTOGROUPS_TYPE_LASTVISIT'		=> 'Dagen sinds laatste bezoek',
+-	'AUTOGROUPS_TYPE_MEMBERSHIP'	=> 'Lidmaatschapsdagen',
++	'AUTOGROUPS_TYPE_MEMBERSHIP'	=> 'Aantal dagen lid',
+ 	'AUTOGROUPS_TYPE_POSTS'			=> 'Berichten',
+ 	'AUTOGROUPS_TYPE_WARNINGS'		=> 'Waarschuwingen',
+ ));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/language/nl/autogroups_common.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/language/nl/autogroups_common.php"
+index 72c058fe2..18cabd629 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/language/nl/autogroups_common.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/language/nl/autogroups_common.php"
+@@ -39,7 +39,7 @@ if (empty($lang) || !is_array($lang))
+ //
+ 
+ $lang = array_merge($lang, array(
+-	// Meldingen
+-	'AUTOGROUPS_NOTIFICATION_GROUP_ADDED'	=> '<strong>Groepupdate</strong>: Je bent toegevoegd aan de groep %1$s.',
+-	'AUTOGROUPS_NOTIFICATION_GROUP_REMOVED'	=> '<strong>Groepupdate</strong>: Je bent verwijderd uit de groep %1$s.',
++	// Notifications
++	'AUTOGROUPS_NOTIFICATION_GROUP_ADDED'	=> '<strong>Groepen bijgewerkt</strong>: Je bent toegevoegd aan de groep %1$s.',
++	'AUTOGROUPS_NOTIFICATION_GROUP_REMOVED'	=> '<strong>Groepen bijgewerkt</strong>: Je bent verwijderd van de groep %1$s.',
+ ));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/language/nl/autogroups_install.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/language/nl/autogroups_install.php"
+deleted file mode 100644
+index 22e9038d9..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/language/nl/autogroups_install.php"
++++ /dev/null
+@@ -1,42 +0,0 @@
+-<?php
+-/**
+-*
+-* Auto Groups extension for the phpBB Forum Software package.
+-*
+-* @copyright (c) 2019 phpBB Limited <https://www.phpbb.com>
+-* @license GNU General Public License, version 2 (GPL-2.0)
+-*
+-*/
+-
+-/**
+-* DO NOT CHANGE
+-*/
+-if (!defined('IN_PHPBB'))
+-{
+-	exit;
+-}
+-
+-if (empty($lang) || !is_array($lang))
+-{
+-	$lang = array();
+-}
+-
+-// DEVELOPERS PLEASE NOTE
+-//
+-// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
+-//
+-// Placeholders can now contain order information, e.g. instead of
+-// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
+-// translators to re-order the output of data while ensuring it remains correct
+-//
+-// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
+-// equally where a string contains only two placeholders which are used to wrap text
+-// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
+-//
+-// Some characters you may want to copy&paste:
+-// ’ » “ ” …
+-//
+-
+-$lang = array_merge($lang, array(
+-	'AUTOGROUPS_NOT_ENABLEABLE'	=> 'Auto Groepen konden niet worden ingeschakeld. De minimale vereisten van phpBB 3.2.0 en/of PHP 5.5.0 zijn niet voldaan.',
+-));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/language/nl/info_acp_autogroups.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/language/nl/info_acp_autogroups.php"
+index 2b1a7b8de..b79b84c22 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/language/nl/info_acp_autogroups.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/language/nl/info_acp_autogroups.php"
+@@ -39,10 +39,10 @@ if (empty($lang) || !is_array($lang))
+ //
+ 
+ $lang = array_merge($lang, array(
+-	'ACP_AUTOGROUPS_MANAGE'			=> 'Beheer Auto Groepen',
+-	'AUTOGROUPS_TYPE_NOT_EXIST'		=> 'Het Auto Groep type `%1$s` bestaat niet.',
++	'ACP_AUTOGROUPS_MANAGE'			=> 'Beheer automatische groepen',
++	'AUTOGROUPS_TYPE_NOT_EXIST'		=> 'Automatische groep type `%1$s` bestaat niet.',
+ 
+ 	// Logs
+-	'ACP_AUTOGROUPS_SAVED_LOG'		=> '<strong>Een Auto Groep configuratie is opgeslagen</strong>',
+-	'ACP_AUTOGROUPS_DELETE_LOG'		=> '<strong>Een Auto Groep configuratie is verwijderd</strong>',
++	'ACP_AUTOGROUPS_SAVED_LOG'		=> '<strong>Een automatische groep configuratie is opgeslagen.</strong>',
++	'ACP_AUTOGROUPS_DELETE_LOG'		=> '<strong>Een automatische groep configuratie is verwijderd.</strong>',
+ ));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/language/pl/autogroups_acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/language/pl/autogroups_acp.php"
+index 63e25a065..ea75ab064 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/language/pl/autogroups_acp.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/language/pl/autogroups_acp.php"
+@@ -71,7 +71,7 @@ $lang = array_merge($lang, array(
+ 	'ACP_AUTOGROUPS_DELETE_SUCCESS'	=> 'Usunięto automatyczną grupę.',
+ 	'ACP_AUTOGROUPS_EMPTY'			=> 'Brak automatycznych grup.',
+ 	'ACP_AUTOGROUPS_NO_GROUPS'		=> 'Brak grup',
+-	'ACP_AUTOGROUPS_INVALID_GROUPS'	=> 'Nie wybrano żadnej grupy.<br><br>Automatyczne grupy muszą być połączone z istniejącymi grupami, które można utworzyć na stronie zarządzania grupami.',
++	'ACP_AUTOGROUPS_INVALID_GROUPS'	=> 'Nie wybrano żadnej grupy.<br /><br />Automatyczne grupy muszą być połączone z istniejącymi grupami, które można utworzyć na stronie zarządzania grupami.',
+ 	'ACP_AUTOGROUPS_INVALID_RANGE'	=> 'Minimalna i maksymalna wartość nie może być taka sama.',
+ 
+ 	// Conditions
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/language/pt/autogroups_acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/language/pt/autogroups_acp.php"
+index 1a82226d1..d050051cc 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/language/pt/autogroups_acp.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/language/pt/autogroups_acp.php"
+@@ -70,7 +70,7 @@ $lang = array_merge($lang, array(
+ 	'ACP_AUTOGROUPS_DELETE_SUCCESS'	=> 'Autogrupo excluído com sucesso.',
+ 	'ACP_AUTOGROUPS_EMPTY'			=> 'Não existem Autogrupos.',
+ 	'ACP_AUTOGROUPS_NO_GROUPS'		=> 'Não existem grupos disponíveis',
+-	'ACP_AUTOGROUPS_INVALID_GROUPS'	=> 'Um erro ocorreu. Um grupo de usuários válido não estava selecionado. <br> Autogrupos somente pode ser usado com grupos definidos de usuários, que podem ser criados em na página "Gerenciar grupos".',
++	'ACP_AUTOGROUPS_INVALID_GROUPS'	=> 'Um erro ocorreu. Um grupo de usuários válido não estava selecionado. <br /> Autogrupos somente pode ser usado com grupos definidos de usuários, que podem ser criados em na página "Gerenciar grupos".',
+ 	'ACP_AUTOGROUPS_INVALID_RANGE'	=> 'Um erro ocorreu. Os valores mínimos e máximos não podem ser configurados para o mesmo valor.',
+ 
+ 	// Conditions
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/language/pt_br/autogroups_acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/language/pt_br/autogroups_acp.php"
+index 7bb319540..a08bf9e0a 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/language/pt_br/autogroups_acp.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/language/pt_br/autogroups_acp.php"
+@@ -71,7 +71,7 @@ $lang = array_merge($lang, array(
+ 	'ACP_AUTOGROUPS_DELETE_SUCCESS'	=> 'Autogrupo excluído com sucesso.',
+ 	'ACP_AUTOGROUPS_EMPTY'			=> 'Não existem Autogrupos.',
+ 	'ACP_AUTOGROUPS_NO_GROUPS'		=> 'Não existem grupos disponíveis',
+-	'ACP_AUTOGROUPS_INVALID_GROUPS'	=> 'Um erro ocorreu. Um grupo de usuários válido não estava selecionado. <br> Autogrupos somente pode ser usado com grupos definidos de usuários, que podem ser criados em na página "Gerenciar grupos".',
++	'ACP_AUTOGROUPS_INVALID_GROUPS'	=> 'Um erro ocorreu. Um grupo de usuários válido não estava selecionado. <br /> Autogrupos somente pode ser usado com grupos definidos de usuários, que podem ser criados em na página "Gerenciar grupos".',
+ 	'ACP_AUTOGROUPS_INVALID_RANGE'	=> 'Um erro ocorreu. Os valores mínimos e máximos não podem ser configurados para o mesmo valor.',
+ 
+ 	// Conditions
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/language/ro/autogroups_acp.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/language/ro/autogroups_acp.php"
+deleted file mode 100644
+index 11dbd9571..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/language/ro/autogroups_acp.php"
++++ /dev/null
+@@ -1,83 +0,0 @@
+-<?php
+-/**
+-*
+-* Auto Groups extension for the phpBB Forum Software package.
+-* Romanian translation by iorG19 (https://ioforos.com)
+-*
+-* @copyright (c) 2014 phpBB Limited <https://www.phpbb.com>
+-* @license GNU General Public License, version 2 (GPL-2.0)
+-*
+-*/
+-
+-/**
+-* DO NOT CHANGE
+-*/
+-if (!defined('IN_PHPBB'))
+-{
+-	exit;
+-}
+-
+-if (empty($lang) || !is_array($lang))
+-{
+-	$lang = array();
+-}
+-
+-// DEVELOPERS PLEASE NOTE
+-//
+-// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
+-//
+-// Placeholders can now contain order information, e.g. instead of
+-// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
+-// translators to re-order the output of data while ensuring it remains correct
+-//
+-// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
+-// equally where a string contains only two placeholders which are used to wrap text
+-// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
+-//
+-// Some characters you may want to copy&paste:
+-// ’ » “ ” …
+-//
+-
+-$lang = array_merge($lang, array(
+-	'ACP_AUTOGROUPS_MANAGE'			=> 'Gestionați Grupurile Automate',
+-	'ACP_AUTOGROUPS_MANAGE_EXPLAIN'	=> 'Folosind acest formular puteți adăuga, edita, vizualiza și șterge configurațiile Auto Group.',
+-	'ACP_AUTOGROUPS_ADD'			=> 'Adăugați grupuri automate',
+-	'ACP_AUTOGROUPS_EDIT'			=> 'Editați grupurile automate',
+-
+-	'ACP_AUTOGROUPS_GROUP_NAME'				=> 'Grup',
+-	'ACP_AUTOGROUPS_GROUP_NAME_EXPLAIN'		=> 'Alegeți un grup din care să adăugați/eliminați automat utilizatori.',
+-	'ACP_AUTOGROUPS_CONDITION_NAME'			=> 'Tip de grup automat',
+-	'ACP_AUTOGROUPS_CONDITION_NAME_EXPLAIN'	=> 'Alegeți tipul de condiție în care utilizatorii vor fi adăugați sau eliminați din acest grup.',
+-	'ACP_AUTOGROUPS_MIN_VALUE'				=> 'Valoarea minima',
+-	'ACP_AUTOGROUPS_MIN_VALUE_EXPLAIN'		=> 'Utilizatorii vor fi adăugați în acest grup dacă îndeplinesc sau depășesc valoarea minimă.',
+-	'ACP_AUTOGROUPS_MAX_VALUE'				=> 'Valoarea maximă',
+-	'ACP_AUTOGROUPS_MAX_VALUE_EXPLAIN'		=> 'Utilizatorii vor fi excluși din acest grup dacă îndeplinesc sau depășesc valoarea maximă. Setați acest lucru la 0 dacă nu doriți ca utilizatorii să fie eliminați.',
+-	'ACP_AUTOGROUPS_DEFAULT'				=> 'Setați grupul implicit',
+-	'ACP_AUTOGROUPS_DEFAULT_EXPLAIN'		=> 'Faceți din acesta noul grup implicit al utilizatorului.',
+-	'ACP_AUTOGROUPS_DEFAULT_EXEMPTION'		=> 'Acest lucru nu va afecta utilizatorii al căror grup de utilizatori implicit este unul dintre următoarele: %s.',
+-	'ACP_AUTOGROUPS_NOTIFY'					=> 'Notificați utilizatorii',
+-	'ACP_AUTOGROUPS_NOTIFY_EXPLAIN'			=> 'Trimiteți o notificare utilizatorilor după ce au fost adăugat sau eliminat automat din acest grup.',
+-
+-	'ACP_AUTOGROUPS_EXCLUDED_GROUPS'		=> 'Grupuri excluse',
+-	'ACP_AUTOGROUPS_EXCLUDE_GROUP'			=> 'Excludeți membrii acestor grupuri',
+-	'ACP_AUTOGROUPS_EXCLUDE_GROUP_EXPLAIN'	=> 'Membrii care aparțin <em>orice grup</em> selectat în această listă vor fi ignorați. Lăsați acest câmp necompletat dacă doriți ca acest grup automat să fie aplicat <em>toți membrii</em> ai forumului dvs. Selectați mai multe grupuri ținând apăsat pe <samp>CTRL</samp> (sau <samp>&#8984;CMD</samp> pe Mac) și selectând grupurile.',
+-	'ACP_AUTOGROUPS_INVALID_EXCLUDE_GROUPS'	=> 'A apărut o eroare. Grupul pentru această condiție nu poate fi selectat și în câmpul grupuri excluse.',
+-	'ACP_AUTOGROUPS_EXEMPT_GROUP'			=> 'Setați scutiri implicite de grup',
+-	'ACP_AUTOGROUPS_EXEMPT_GROUP_EXPLAIN'	=> 'Grupurile automate nu vor schimba <em>grupul implicit</em> al unui utilizator dacă este selectat în această listă. Selectați mai multe grupuri ținând apăsat pe <samp>CTRL</samp> (sau <samp>&#8984;CMD</samp> pe Mac) și selectând grupurile.',
+-
+-	'ACP_AUTOGROUPS_CREATE_RULE'	=> 'Creați un nou Grup Automat',
+-	'ACP_AUTOGROUPS_SUBMIT_SUCCESS'	=> 'Grupul automat a fost configurat cu succes.',
+-	'ACP_AUTOGROUPS_DELETE_CONFIRM'	=> 'Sigur doriți să ștergeți această configurație de grup automat?',
+-	'ACP_AUTOGROUPS_DELETE_SUCCESS'	=> 'Grupul automat a fost șters cu succes.',
+-	'ACP_AUTOGROUPS_EMPTY'			=> 'Nu există Grupuri Automate.',
+-	'ACP_AUTOGROUPS_NO_GROUPS'		=> 'Nu există grupuri disponibile',
+-	'ACP_AUTOGROUPS_INVALID_GROUPS'	=> 'A apărut o eroare. Nu a fost selectat un grup de utilizatori valid.<br />Grupurile automate pot fi utilizate numai cu grupuri definite de utilizator, care pot fi create pe pagina Gestionați grupuri.',
+-	'ACP_AUTOGROUPS_INVALID_RANGE'	=> 'A apărut o eroare. Valorile minime și maxime nu pot fi setate la aceeași valoare.',
+-
+-	// Conditions
+-	'AUTOGROUPS_TYPE_BIRTHDAYS'		=> 'Vârsta utilizatorului',
+-	'AUTOGROUPS_TYPE_LASTVISIT'		=> 'Zile de la ultima vizită',
+-	'AUTOGROUPS_TYPE_MEMBERSHIP'	=> 'Zilele de membru',
+-	'AUTOGROUPS_TYPE_POSTS'			=> 'Postări',
+-	'AUTOGROUPS_TYPE_WARNINGS'		=> 'Avertismente',
+-));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/language/ro/autogroups_common.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/language/ro/autogroups_common.php"
+deleted file mode 100644
+index 695d20bf2..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/language/ro/autogroups_common.php"
++++ /dev/null
+@@ -1,45 +0,0 @@
+-<?php
+-/**
+-*
+-* Auto Groups extension for the phpBB Forum Software package.
+-* Romanian translation by iorG19 (https://ioforos.com)
+-*
+-* @copyright (c) 2014 phpBB Limited <https://www.phpbb.com>
+-* @license GNU General Public License, version 2 (GPL-2.0)
+-*
+-*/
+-
+-/**
+-* DO NOT CHANGE
+-*/
+-if (!defined('IN_PHPBB'))
+-{
+-	exit;
+-}
+-
+-if (empty($lang) || !is_array($lang))
+-{
+-	$lang = array();
+-}
+-
+-// DEVELOPERS PLEASE NOTE
+-//
+-// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
+-//
+-// Placeholders can now contain order information, e.g. instead of
+-// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
+-// translators to re-order the output of data while ensuring it remains correct
+-//
+-// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
+-// equally where a string contains only two placeholders which are used to wrap text
+-// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
+-//
+-// Some characters you may want to copy&paste:
+-// ’ » “ ” …
+-//
+-
+-$lang = array_merge($lang, array(
+-	// Notifications
+-	'AUTOGROUPS_NOTIFICATION_GROUP_ADDED'	=> '<strong>Actualizare de grup</strong>: Ați fost adăugat în grupul %1$s.',
+-	'AUTOGROUPS_NOTIFICATION_GROUP_REMOVED'	=> '<strong>Actualizare de grup</strong>: Ați fost exclus din grupul %1$s.',
+-));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/language/ro/autogroups_install.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/language/ro/autogroups_install.php"
+deleted file mode 100644
+index cb0546b5d..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/language/ro/autogroups_install.php"
++++ /dev/null
+@@ -1,43 +0,0 @@
+-<?php
+-/**
+-*
+-* Auto Groups extension for the phpBB Forum Software package.
+-* Romanian translation by iorG19 (https://ioforos.com)
+-*
+-* @copyright (c) 2019 phpBB Limited <https://www.phpbb.com>
+-* @license GNU General Public License, version 2 (GPL-2.0)
+-*
+-*/
+-
+-/**
+-* DO NOT CHANGE
+-*/
+-if (!defined('IN_PHPBB'))
+-{
+-	exit;
+-}
+-
+-if (empty($lang) || !is_array($lang))
+-{
+-	$lang = array();
+-}
+-
+-// DEVELOPERS PLEASE NOTE
+-//
+-// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
+-//
+-// Placeholders can now contain order information, e.g. instead of
+-// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
+-// translators to re-order the output of data while ensuring it remains correct
+-//
+-// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
+-// equally where a string contains only two placeholders which are used to wrap text
+-// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
+-//
+-// Some characters you may want to copy&paste:
+-// ’ » “ ” …
+-//
+-
+-$lang = array_merge($lang, array(
+-	'AUTOGROUPS_NOT_ENABLEABLE'	=> 'Grupurile automate nu au putut fi activate. Cerințele minime ale phpBB 3.2.0 și/sau PHP 5.5.0 nu au fost îndeplinite.',
+-));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/language/ro/info_acp_autogroups.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/language/ro/info_acp_autogroups.php"
+deleted file mode 100644
+index e432e9f21..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/language/ro/info_acp_autogroups.php"
++++ /dev/null
+@@ -1,48 +0,0 @@
+-<?php
+-/**
+-*
+-* Auto Groups extension for the phpBB Forum Software package.
+-* Romanian translation by iorG19 (https://ioforos.com)
+-*
+-* @copyright (c) 2014 phpBB Limited <https://www.phpbb.com>
+-* @license GNU General Public License, version 2 (GPL-2.0)
+-*
+-*/
+-
+-/**
+-* DO NOT CHANGE
+-*/
+-if (!defined('IN_PHPBB'))
+-{
+-	exit;
+-}
+-
+-if (empty($lang) || !is_array($lang))
+-{
+-	$lang = array();
+-}
+-
+-// DEVELOPERS PLEASE NOTE
+-//
+-// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
+-//
+-// Placeholders can now contain order information, e.g. instead of
+-// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
+-// translators to re-order the output of data while ensuring it remains correct
+-//
+-// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
+-// equally where a string contains only two placeholders which are used to wrap text
+-// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
+-//
+-// Some characters you may want to copy&paste:
+-// ’ » “ ” …
+-//
+-
+-$lang = array_merge($lang, array(
+-	'ACP_AUTOGROUPS_MANAGE'			=> 'Gestionați Grupurile Automate',
+-	'AUTOGROUPS_TYPE_NOT_EXIST'		=> 'Tipul Auto Group `%1$s` nu există.',
+-
+-	// Logs
+-	'ACP_AUTOGROUPS_SAVED_LOG'		=> '<strong>O configurație de Grup Automat a fost salvată</strong>',
+-	'ACP_AUTOGROUPS_DELETE_LOG'		=> '<strong>O configurație de Grup Automat a fost ștearsă</strong>',
+-));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/language/ru/autogroups_acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/language/ru/autogroups_acp.php"
+index 51b3bf9c3..98eaa4db8 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/language/ru/autogroups_acp.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/language/ru/autogroups_acp.php"
+@@ -70,7 +70,7 @@ $lang = array_merge($lang, array(
+ 	'ACP_AUTOGROUPS_DELETE_SUCCESS'	=> 'АвтоГруппа успешно удалена.',
+ 	'ACP_AUTOGROUPS_EMPTY'			=> 'Нет АвтоГрупп.',
+ 	'ACP_AUTOGROUPS_NO_GROUPS'		=> 'Нет доступных групп',
+-	'ACP_AUTOGROUPS_INVALID_GROUPS'	=> 'Произошла ошибка. Не выбрана действующая группа пользователей.<br>АвтоГруппы могут использоваться только с определенными группами пользователей, создать которые можно на странице управления группами.',
++	'ACP_AUTOGROUPS_INVALID_GROUPS'	=> 'Произошла ошибка. Не выбрана действующая группа пользователей.<br />АвтоГруппы могут использоваться только с определенными группами пользователей, создать которые можно на странице управления группами.',
+ 	'ACP_AUTOGROUPS_INVALID_RANGE'	=> 'Произошла ошибка. Минимальное и максимальное значения не могут быть установлены на одно и то же значение.',
+ 
+ 	// Conditions
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/language/sk/autogroups_acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/language/sk/autogroups_acp.php"
+index d5796ee92..41b951e12 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/language/sk/autogroups_acp.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/language/sk/autogroups_acp.php"
+@@ -71,7 +71,7 @@ $lang = array_merge($lang, array(
+ 	'ACP_AUTOGROUPS_DELETE_SUCCESS'	=> 'Automatická skupina bola úspešne vymazaná.',
+ 	'ACP_AUTOGROUPS_EMPTY'			=> 'Nie sú zatiaľ žiadne automatické skupiny.',
+ 	'ACP_AUTOGROUPS_NO_GROUPS'		=> 'Nie sú dostupné žiadne skupiny',
+-	'ACP_AUTOGROUPS_INVALID_GROUPS'	=> 'Nastala chyba. Nebola vybraná správna používteľská skupina.<br>Automatické skupiny môžu byť použité iba s používateľskými skupinami, ktoré môžu byť vytvorené na stránke Spravovať skupiny.',
++	'ACP_AUTOGROUPS_INVALID_GROUPS'	=> 'Nastala chyba. Nebola vybraná správna používteľská skupina.<br />Automatické skupiny môžu byť použité iba s používateľskými skupinami, ktoré môžu byť vytvorené na stránke Spravovať skupiny.',
+ 	'ACP_AUTOGROUPS_INVALID_RANGE'	=> 'Nastala chyba. Minimálna a maximálna hodnota nemôžu byť nastavené na rovnakú hodnotu.',
+ 
+ 	// Conditions
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/language/tr/autogroups_acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/language/tr/autogroups_acp.php"
+index df5193e02..c37b13912 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/language/tr/autogroups_acp.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/language/tr/autogroups_acp.php"
+@@ -70,7 +70,7 @@ $lang = array_merge($lang, array(
+ 	'ACP_AUTOGROUPS_DELETE_SUCCESS'	=> 'Otomatik Grup başarıyla silindi.',
+ 	'ACP_AUTOGROUPS_EMPTY'			=> 'Hiç Otomatik Grup yok.',
+ 	'ACP_AUTOGROUPS_NO_GROUPS'		=> 'Grup mevcut değil',
+-	'ACP_AUTOGROUPS_INVALID_GROUPS'	=> 'Bir hata oluştu. Geçerli bir kullanıcı grubu seçilmedi.<br>Otomatik Gruplar yalnızca Grup Yönetimi sayfasında oluşturulabilen kullanıcı tanımlı gruplarla kullanılabilir.',
++	'ACP_AUTOGROUPS_INVALID_GROUPS'	=> 'Bir hata oluştu. Geçerli bir kullanıcı grubu seçilmedi.<br />Otomatik Gruplar yalnızca Grup Yönetimi sayfasında oluşturulabilen kullanıcı tanımlı gruplarla kullanılabilir.',
+ 	'ACP_AUTOGROUPS_INVALID_RANGE'	=> 'Bir hata oluştu. Minimum ve maksimum değerler aynı değer olarak ayarlanamaz.',
+ 
+ 	// Conditions
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/language/zh_cmn_hans/autogroups_acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/language/zh_cmn_hans/autogroups_acp.php"
+index bf540f53e..783cf9ac6 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/language/zh_cmn_hans/autogroups_acp.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/language/zh_cmn_hans/autogroups_acp.php"
+@@ -71,7 +71,7 @@ $lang = array_merge($lang, array(
+ 	'ACP_AUTOGROUPS_DELETE_SUCCESS'	=> '自动分组配置已删除。',
+ 	'ACP_AUTOGROUPS_EMPTY'			=> '没有任何的自动分组设置。',
+ 	'ACP_AUTOGROUPS_NO_GROUPS'		=> '无用户组可以选择',
+-	'ACP_AUTOGROUPS_INVALID_GROUPS'	=> '错误！无效用户组被选中。<br> 自动分组只能应用于用户定义的组，用户定义的组可以在用户组管理界面添加。',
++	'ACP_AUTOGROUPS_INVALID_GROUPS'	=> '错误！无效用户组被选中。<br /> 自动分组只能应用于用户定义的组，用户定义的组可以在用户组管理界面添加。',
+ 	'ACP_AUTOGROUPS_INVALID_RANGE'	=> '错误！最大值不能等于最小值。',
+ 
+ 	// Conditions
diff --git "[FORUM_EXT]/phpbb\\autogroups/diff_nospace.tmp" "[FORUM_EXT]/phpbb\\autogroups/diff_nospace.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/phpbb\\autogroups/diff_nospace.tmp"
@@ -0,0 +1,1163 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/CHANGELOG.md" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/CHANGELOG.md"
+index 1c13badcc..cb113957c 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/CHANGELOG.md"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/CHANGELOG.md"
+@@ -1,27 +1,20 @@
+ # Changelog
+ 
+-## Version 2.x (for phpBB 3.2.x, 3.3.x and 4.0.x)
++## Version 2.x (for phpBB 3.2.x and 3.3.x)
+ 
+-### 2.0.7 - 2026-03-20
+-
+-- Allow installations on phpBB4-alpha+ boards via Extension Catalog.
+-- Removed old XHTML code.
+-- Added Romanian language pack.
+-- Updated Dutch language pack.
+-
+-### 2.0.6 - 2024-01-18
++## 2.0.6 - 2024-01-18
+ 
+ - Fixed PHP warnings that could be caused by a conflict with other extensions.
+ - Updated English, French, German and Turkish language packs.
+ 
+-### 2.0.5 - 2022-06-18
++## 2.0.5 - 2022-06-18
+ 
+ - Run membership condition check when a user logs in.
+ - Added Portuguese language pack
+ 
+ ### 2.0.4 - 2021-03-12
+ 
+-- Added a new option to exempt members of selected user groups from being affected by an Auto Group rule.
++- Added new option to exempt members of selected user groups from being affected by an Auto Group rule.
+ - Fixed potential PHP DEBUG notices.
+ - Fixed MSSQL issues with the Warnings and Membership auto group rules.
+ - Various minor code and behavior improvements.
+@@ -37,7 +30,7 @@
+ ### 2.0.2 - 2019-03-27
+ 
+ - Check Membership days after user registrations.
+-- Check Post counts after post-approvals.
++- Check Post counts after post approvals.
+ - Avoid possible errors with User age due to invalid dates.
+ - Added Polish language pack
+ - Added Turkish language pack
+@@ -56,7 +49,7 @@
+ 
+ ### 1.0.2 - 2016-11-30
+ 
+-- Fixed a new years day bug in the auto group by user age condition
++- Fixed new years day bug in the auto group by user age condition
+ - Various code improvements and maintenance
+ - Added Croatian language packs
+ - Added Chinese language packs
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/adm/style/manage_autogroups.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/adm/style/manage_autogroups.html"
+index a7bc931e7..3b3e00852 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/adm/style/manage_autogroups.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/adm/style/manage_autogroups.html"
+@@ -15,7 +15,7 @@
+ 		<fieldset>
+ 			<legend>{{ lang(S_ADD ? 'ACP_AUTOGROUPS_ADD' : 'ACP_AUTOGROUPS_EDIT') }}</legend>
+ 			<dl>
+-				<dt><label for="autogroups_group_id">{{ lang('ACP_AUTOGROUPS_GROUP_NAME') ~ lang('COLON') }}</label><br><span>{{ lang('ACP_AUTOGROUPS_GROUP_NAME_EXPLAIN') }}</span></dt>
++				<dt><label for="autogroups_group_id">{{ lang('ACP_AUTOGROUPS_GROUP_NAME') ~ lang('COLON') }}</label><br /><span>{{ lang('ACP_AUTOGROUPS_GROUP_NAME_EXPLAIN') }}</span></dt>
+ 				<dd>
+ 					<select name="autogroups_group_id" id="autogroups_group_id">
+ 						{% for groups in loops.groups %}
+@@ -27,7 +27,7 @@
+ 				</dd>
+ 			</dl>
+ 			<dl>
+-				<dt><label for="autogroups_type_id">{{ lang('ACP_AUTOGROUPS_CONDITION_NAME') ~ lang('COLON') }}</label><br><span>{{ lang('ACP_AUTOGROUPS_CONDITION_NAME_EXPLAIN') }}</span></dt>
++				<dt><label for="autogroups_type_id">{{ lang('ACP_AUTOGROUPS_CONDITION_NAME') ~ lang('COLON') }}</label><br /><span>{{ lang('ACP_AUTOGROUPS_CONDITION_NAME_EXPLAIN') }}</span></dt>
+ 				<dd><select name="autogroups_type_id" id="autogroups_type_id">
+ 					{% for conditions in loops.conditions %}
+ 						<option value="{{ conditions.CONDITION_ID }}"{% if conditions.S_SELECTED %} selected="selected"{% endif %}>{{ conditions.CONDITION_NAME }}</option>
+@@ -35,25 +35,25 @@
+ 				</select></dd>
+ 			</dl>
+ 			<dl>
+-				<dt><label for="autogroups_min_value">{{ lang('ACP_AUTOGROUPS_MIN_VALUE') ~ lang('COLON') }}</label><br><span>{{ lang('ACP_AUTOGROUPS_MIN_VALUE_EXPLAIN') }}</span></dt>
+-				<dd><input id="autogroups_min_value" type="number" size="4" name="autogroups_min_value" value="{{ MIN_VALUE }}"></dd>
++				<dt><label for="autogroups_min_value">{{ lang('ACP_AUTOGROUPS_MIN_VALUE') ~ lang('COLON') }}</label><br /><span>{{ lang('ACP_AUTOGROUPS_MIN_VALUE_EXPLAIN') }}</span></dt>
++				<dd><input id="autogroups_min_value" type="number" size="4" name="autogroups_min_value" value="{{ MIN_VALUE }}" /></dd>
+ 			</dl>
+ 			<dl>
+-				<dt><label for="autogroups_max_value">{{ lang('ACP_AUTOGROUPS_MAX_VALUE') ~ lang('COLON') }}</label><br><span>{{ lang('ACP_AUTOGROUPS_MAX_VALUE_EXPLAIN') }}</span></dt>
+-				<dd><input id="autogroups_max_value" type="number" size="4" name="autogroups_max_value" value="{{ MAX_VALUE }}"></dd>
++				<dt><label for="autogroups_max_value">{{ lang('ACP_AUTOGROUPS_MAX_VALUE') ~ lang('COLON') }}</label><br /><span>{{ lang('ACP_AUTOGROUPS_MAX_VALUE_EXPLAIN') }}</span></dt>
++				<dd><input id="autogroups_max_value" type="number" size="4" name="autogroups_max_value" value="{{ MAX_VALUE }}" /></dd>
+ 			</dl>
+ 			<dl>
+-				<dt><label for="autogroups_default">{{ lang('ACP_AUTOGROUPS_DEFAULT') ~ lang('COLON') }}</label><br><span>{{ lang('ACP_AUTOGROUPS_DEFAULT_EXPLAIN') }} {{ EXEMPT_GROUPS ? lang('ACP_AUTOGROUPS_DEFAULT_EXEMPTION', EXEMPT_GROUPS) : '' }}</span></dt>
+-				<dd><label><input type="radio" class="radio" id="autogroups_default" name="autogroups_default" value="1"{% if S_DEFAULT %} checked="checked"{% endif %}> {{ lang('YES') }}</label>
+-					<label><input type="radio" class="radio" name="autogroups_default" value="0"{% if not S_DEFAULT %} checked="checked"{% endif %}> {{ lang('NO') }}</label></dd>
++				<dt><label for="autogroups_default">{{ lang('ACP_AUTOGROUPS_DEFAULT') ~ lang('COLON') }}</label><br /><span>{{ lang('ACP_AUTOGROUPS_DEFAULT_EXPLAIN') }} {{ EXEMPT_GROUPS ? lang('ACP_AUTOGROUPS_DEFAULT_EXEMPTION', EXEMPT_GROUPS) : '' }}</span></dt>
++				<dd><label><input type="radio" class="radio" id="autogroups_default" name="autogroups_default" value="1"{% if S_DEFAULT %} checked="checked"{% endif %} /> {{ lang('YES') }}</label>
++					<label><input type="radio" class="radio" name="autogroups_default" value="0"{% if not S_DEFAULT %} checked="checked"{% endif %} /> {{ lang('NO') }}</label></dd>
+ 			</dl>
+ 			<dl>
+-				<dt><label for="autogroups_notify">{{ lang('ACP_AUTOGROUPS_NOTIFY') ~ lang('COLON') }}</label><br><span>{{ lang('ACP_AUTOGROUPS_NOTIFY_EXPLAIN') }}</span></dt>
+-				<dd><label><input type="radio" class="radio" id="autogroups_notify" name="autogroups_notify" value="1"{% if S_NOTIFY %} checked="checked"{% endif %}> {{ lang('YES') }}</label>
+-					<label><input type="radio" class="radio" name="autogroups_notify" value="0"{% if not S_NOTIFY %} checked="checked"{% endif %}> {{ lang('NO') }}</label></dd>
++				<dt><label for="autogroups_notify">{{ lang('ACP_AUTOGROUPS_NOTIFY') ~ lang('COLON') }}</label><br /><span>{{ lang('ACP_AUTOGROUPS_NOTIFY_EXPLAIN') }}</span></dt>
++				<dd><label><input type="radio" class="radio" id="autogroups_notify" name="autogroups_notify" value="1"{% if S_NOTIFY %} checked="checked"{% endif %} /> {{ lang('YES') }}</label>
++					<label><input type="radio" class="radio" name="autogroups_notify" value="0"{% if not S_NOTIFY %} checked="checked"{% endif %} /> {{ lang('NO') }}</label></dd>
+ 			</dl>
+ 			<dl>
+-				<dt><label for="autogroups_excluded_groups">{{ lang('ACP_AUTOGROUPS_EXCLUDE_GROUP') ~ lang('COLON') }}</label><br><span>{{ lang('ACP_AUTOGROUPS_EXCLUDE_GROUP_EXPLAIN') }}</span></dt>
++				<dt><label for="autogroups_excluded_groups">{{ lang('ACP_AUTOGROUPS_EXCLUDE_GROUP') ~ lang('COLON') }}</label><br /><span>{{ lang('ACP_AUTOGROUPS_EXCLUDE_GROUP_EXPLAIN') }}</span></dt>
+ 				<dd>
+ 					<select name="autogroups_excluded_groups[]" id="autogroups_excluded_groups" size="10" multiple="multiple">
+ 						{% for groups in loops.excluded_groups %}
+@@ -64,8 +64,8 @@
+ 			</dl>
+ 		</fieldset>
+ 		<p class="submit-buttons">
+-			<input class="button1" type="submit" id="submit" name="submit" value="{{ lang('SUBMIT') }}">&nbsp;
+-			<input class="button2" type="reset" id="reset" name="reset" value="{{ lang('RESET') }}">
++			<input class="button1" type="submit" id="submit" name="submit" value="{{ lang('SUBMIT') }}" />&nbsp;
++			<input class="button2" type="reset" id="reset" name="reset" value="{{ lang('RESET') }}" />
+ 			{{ S_FORM_TOKEN }}
+ 		</p>
+ 	</form>
+@@ -104,8 +104,8 @@
+ 	</table>
+ 	<form id="autogroups_add_rule" method="post" action="{{ U_ACTION }}">
+ 		<fieldset class="quick">
+-			<input class="button2" type="submit" name="addrule" value="{{ lang('ACP_AUTOGROUPS_CREATE_RULE') }}">
+-			<input type="hidden" name="action" value="add">
++			<input class="button2" type="submit" name="addrule" value="{{ lang('ACP_AUTOGROUPS_CREATE_RULE') }}" />
++			<input type="hidden" name="action" value="add" />
+ 			{{ S_FORM_TOKEN }}
+ 		</fieldset>
+ 	</form>
+@@ -113,7 +113,7 @@
+ 		<fieldset>
+ 			<legend>{{ lang('GENERAL_OPTIONS') }}</legend>
+ 			<dl>
+-				<dt><label for="group_ids">{{ lang('ACP_AUTOGROUPS_EXEMPT_GROUP') ~ lang('COLON') }}</label><br><span>{{ lang('ACP_AUTOGROUPS_EXEMPT_GROUP_EXPLAIN') }}</span></dt>
++				<dt><label for="group_ids">{{ lang('ACP_AUTOGROUPS_EXEMPT_GROUP') ~ lang('COLON') }}</label><br /><span>{{ lang('ACP_AUTOGROUPS_EXEMPT_GROUP_EXPLAIN') }}</span></dt>
+ 				<dd>
+ 					<select name="group_ids[]" id="group_ids" size="10" multiple="multiple">
+ 						{% for groups in loops.groups %}
+@@ -123,7 +123,7 @@
+ 				</dd>
+ 			</dl>
+ 			<p class="quick">
+-				<input class="button1" type="submit" id="generalsubmit" name="generalsubmit" value="{{ lang('SUBMIT') }}">
++				<input class="button1" type="submit" id="generalsubmit" name="generalsubmit" value="{{ lang('SUBMIT') }}" />
+ 			</p>
+ 		</fieldset>
+ 	</form>
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/composer.json"
+index e4b6156a0..c69d15523 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/composer.json"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/composer.json"
+@@ -3,7 +3,7 @@
+     "type": "phpbb-extension",
+     "description": "An extension that can automate the process of adding and removing users from groups upon reaching specified milestones related to their post count, age, membership, and warnings count.",
+     "homepage": "https://www.phpbb.com/customise/db/extension/auto_groups/",
+-    "version": "2.0.7",
++    "version": "2.0.6",
+     "keywords": [
+         "phpbb",
+         "extension",
+@@ -57,11 +57,11 @@
+     ],
+     "require": {
+         "php": ">=5.5",
+-        "composer/installers": "^1.0 || ^2.0",
++        "composer/installers": "~1.0.0",
+         "phpbb/phpbb": ">=3.2.0"
+     },
+     "require-dev": {
+-        "phing/phing": "~2.4"
++        "phing/phing": "2.4.*"
+     },
+     "extra": {
+         "display-name": "Auto Groups",
+@@ -74,10 +74,5 @@
+             "filename": "version_check",
+             "ssl": true
+         }
+-    },
+-    "config": {
+-        "allow-plugins": {
+-            "composer/installers": true
+-        }
+     }
+ }
+\ No newline at end of file
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/diff_full.tmp"
+new file mode 100644
+index 000000000..9916cce35
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/diff_full.tmp"
+@@ -0,0 +1,968 @@
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/CHANGELOG.md" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/CHANGELOG.md"
++index 1c13badcc..cb113957c 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/CHANGELOG.md"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/CHANGELOG.md"
++@@ -1,27 +1,20 @@
++ # Changelog
++ 
++-## Version 2.x (for phpBB 3.2.x, 3.3.x and 4.0.x)
+++## Version 2.x (for phpBB 3.2.x and 3.3.x)
++ 
++-### 2.0.7 - 2026-03-20
++-
++-- Allow installations on phpBB4-alpha+ boards via Extension Catalog.
++-- Removed old XHTML code.
++-- Added Romanian language pack.
++-- Updated Dutch language pack.
++-
++-### 2.0.6 - 2024-01-18
+++## 2.0.6 - 2024-01-18
++ 
++ - Fixed PHP warnings that could be caused by a conflict with other extensions.
++ - Updated English, French, German and Turkish language packs.
++ 
++-### 2.0.5 - 2022-06-18
+++## 2.0.5 - 2022-06-18
++ 
++ - Run membership condition check when a user logs in.
++ - Added Portuguese language pack
++ 
++ ### 2.0.4 - 2021-03-12
++ 
++-- Added a new option to exempt members of selected user groups from being affected by an Auto Group rule.
+++- Added new option to exempt members of selected user groups from being affected by an Auto Group rule.
++ - Fixed potential PHP DEBUG notices.
++ - Fixed MSSQL issues with the Warnings and Membership auto group rules.
++ - Various minor code and behavior improvements.
++@@ -37,7 +30,7 @@
++ ### 2.0.2 - 2019-03-27
++ 
++ - Check Membership days after user registrations.
++-- Check Post counts after post-approvals.
+++- Check Post counts after post approvals.
++ - Avoid possible errors with User age due to invalid dates.
++ - Added Polish language pack
++ - Added Turkish language pack
++@@ -56,7 +49,7 @@
++ 
++ ### 1.0.2 - 2016-11-30
++ 
++-- Fixed a new years day bug in the auto group by user age condition
+++- Fixed new years day bug in the auto group by user age condition
++ - Various code improvements and maintenance
++ - Added Croatian language packs
++ - Added Chinese language packs
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/adm/style/manage_autogroups.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/adm/style/manage_autogroups.html"
++index a7bc931e7..3b3e00852 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/adm/style/manage_autogroups.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/adm/style/manage_autogroups.html"
++@@ -15,7 +15,7 @@
++ 		<fieldset>
++ 			<legend>{{ lang(S_ADD ? 'ACP_AUTOGROUPS_ADD' : 'ACP_AUTOGROUPS_EDIT') }}</legend>
++ 			<dl>
++-				<dt><label for="autogroups_group_id">{{ lang('ACP_AUTOGROUPS_GROUP_NAME') ~ lang('COLON') }}</label><br><span>{{ lang('ACP_AUTOGROUPS_GROUP_NAME_EXPLAIN') }}</span></dt>
+++				<dt><label for="autogroups_group_id">{{ lang('ACP_AUTOGROUPS_GROUP_NAME') ~ lang('COLON') }}</label><br /><span>{{ lang('ACP_AUTOGROUPS_GROUP_NAME_EXPLAIN') }}</span></dt>
++ 				<dd>
++ 					<select name="autogroups_group_id" id="autogroups_group_id">
++ 						{% for groups in loops.groups %}
++@@ -27,7 +27,7 @@
++ 				</dd>
++ 			</dl>
++ 			<dl>
++-				<dt><label for="autogroups_type_id">{{ lang('ACP_AUTOGROUPS_CONDITION_NAME') ~ lang('COLON') }}</label><br><span>{{ lang('ACP_AUTOGROUPS_CONDITION_NAME_EXPLAIN') }}</span></dt>
+++				<dt><label for="autogroups_type_id">{{ lang('ACP_AUTOGROUPS_CONDITION_NAME') ~ lang('COLON') }}</label><br /><span>{{ lang('ACP_AUTOGROUPS_CONDITION_NAME_EXPLAIN') }}</span></dt>
++ 				<dd><select name="autogroups_type_id" id="autogroups_type_id">
++ 					{% for conditions in loops.conditions %}
++ 						<option value="{{ conditions.CONDITION_ID }}"{% if conditions.S_SELECTED %} selected="selected"{% endif %}>{{ conditions.CONDITION_NAME }}</option>
++@@ -35,25 +35,25 @@
++ 				</select></dd>
++ 			</dl>
++ 			<dl>
++-				<dt><label for="autogroups_min_value">{{ lang('ACP_AUTOGROUPS_MIN_VALUE') ~ lang('COLON') }}</label><br><span>{{ lang('ACP_AUTOGROUPS_MIN_VALUE_EXPLAIN') }}</span></dt>
++-				<dd><input id="autogroups_min_value" type="number" size="4" name="autogroups_min_value" value="{{ MIN_VALUE }}"></dd>
+++				<dt><label for="autogroups_min_value">{{ lang('ACP_AUTOGROUPS_MIN_VALUE') ~ lang('COLON') }}</label><br /><span>{{ lang('ACP_AUTOGROUPS_MIN_VALUE_EXPLAIN') }}</span></dt>
+++				<dd><input id="autogroups_min_value" type="number" size="4" name="autogroups_min_value" value="{{ MIN_VALUE }}" /></dd>
++ 			</dl>
++ 			<dl>
++-				<dt><label for="autogroups_max_value">{{ lang('ACP_AUTOGROUPS_MAX_VALUE') ~ lang('COLON') }}</label><br><span>{{ lang('ACP_AUTOGROUPS_MAX_VALUE_EXPLAIN') }}</span></dt>
++-				<dd><input id="autogroups_max_value" type="number" size="4" name="autogroups_max_value" value="{{ MAX_VALUE }}"></dd>
+++				<dt><label for="autogroups_max_value">{{ lang('ACP_AUTOGROUPS_MAX_VALUE') ~ lang('COLON') }}</label><br /><span>{{ lang('ACP_AUTOGROUPS_MAX_VALUE_EXPLAIN') }}</span></dt>
+++				<dd><input id="autogroups_max_value" type="number" size="4" name="autogroups_max_value" value="{{ MAX_VALUE }}" /></dd>
++ 			</dl>
++ 			<dl>
++-				<dt><label for="autogroups_default">{{ lang('ACP_AUTOGROUPS_DEFAULT') ~ lang('COLON') }}</label><br><span>{{ lang('ACP_AUTOGROUPS_DEFAULT_EXPLAIN') }} {{ EXEMPT_GROUPS ? lang('ACP_AUTOGROUPS_DEFAULT_EXEMPTION', EXEMPT_GROUPS) : '' }}</span></dt>
++-				<dd><label><input type="radio" class="radio" id="autogroups_default" name="autogroups_default" value="1"{% if S_DEFAULT %} checked="checked"{% endif %}> {{ lang('YES') }}</label>
++-					<label><input type="radio" class="radio" name="autogroups_default" value="0"{% if not S_DEFAULT %} checked="checked"{% endif %}> {{ lang('NO') }}</label></dd>
+++				<dt><label for="autogroups_default">{{ lang('ACP_AUTOGROUPS_DEFAULT') ~ lang('COLON') }}</label><br /><span>{{ lang('ACP_AUTOGROUPS_DEFAULT_EXPLAIN') }} {{ EXEMPT_GROUPS ? lang('ACP_AUTOGROUPS_DEFAULT_EXEMPTION', EXEMPT_GROUPS) : '' }}</span></dt>
+++				<dd><label><input type="radio" class="radio" id="autogroups_default" name="autogroups_default" value="1"{% if S_DEFAULT %} checked="checked"{% endif %} /> {{ lang('YES') }}</label>
+++					<label><input type="radio" class="radio" name="autogroups_default" value="0"{% if not S_DEFAULT %} checked="checked"{% endif %} /> {{ lang('NO') }}</label></dd>
++ 			</dl>
++ 			<dl>
++-				<dt><label for="autogroups_notify">{{ lang('ACP_AUTOGROUPS_NOTIFY') ~ lang('COLON') }}</label><br><span>{{ lang('ACP_AUTOGROUPS_NOTIFY_EXPLAIN') }}</span></dt>
++-				<dd><label><input type="radio" class="radio" id="autogroups_notify" name="autogroups_notify" value="1"{% if S_NOTIFY %} checked="checked"{% endif %}> {{ lang('YES') }}</label>
++-					<label><input type="radio" class="radio" name="autogroups_notify" value="0"{% if not S_NOTIFY %} checked="checked"{% endif %}> {{ lang('NO') }}</label></dd>
+++				<dt><label for="autogroups_notify">{{ lang('ACP_AUTOGROUPS_NOTIFY') ~ lang('COLON') }}</label><br /><span>{{ lang('ACP_AUTOGROUPS_NOTIFY_EXPLAIN') }}</span></dt>
+++				<dd><label><input type="radio" class="radio" id="autogroups_notify" name="autogroups_notify" value="1"{% if S_NOTIFY %} checked="checked"{% endif %} /> {{ lang('YES') }}</label>
+++					<label><input type="radio" class="radio" name="autogroups_notify" value="0"{% if not S_NOTIFY %} checked="checked"{% endif %} /> {{ lang('NO') }}</label></dd>
++ 			</dl>
++ 			<dl>
++-				<dt><label for="autogroups_excluded_groups">{{ lang('ACP_AUTOGROUPS_EXCLUDE_GROUP') ~ lang('COLON') }}</label><br><span>{{ lang('ACP_AUTOGROUPS_EXCLUDE_GROUP_EXPLAIN') }}</span></dt>
+++				<dt><label for="autogroups_excluded_groups">{{ lang('ACP_AUTOGROUPS_EXCLUDE_GROUP') ~ lang('COLON') }}</label><br /><span>{{ lang('ACP_AUTOGROUPS_EXCLUDE_GROUP_EXPLAIN') }}</span></dt>
++ 				<dd>
++ 					<select name="autogroups_excluded_groups[]" id="autogroups_excluded_groups" size="10" multiple="multiple">
++ 						{% for groups in loops.excluded_groups %}
++@@ -64,8 +64,8 @@
++ 			</dl>
++ 		</fieldset>
++ 		<p class="submit-buttons">
++-			<input class="button1" type="submit" id="submit" name="submit" value="{{ lang('SUBMIT') }}">&nbsp;
++-			<input class="button2" type="reset" id="reset" name="reset" value="{{ lang('RESET') }}">
+++			<input class="button1" type="submit" id="submit" name="submit" value="{{ lang('SUBMIT') }}" />&nbsp;
+++			<input class="button2" type="reset" id="reset" name="reset" value="{{ lang('RESET') }}" />
++ 			{{ S_FORM_TOKEN }}
++ 		</p>
++ 	</form>
++@@ -104,8 +104,8 @@
++ 	</table>
++ 	<form id="autogroups_add_rule" method="post" action="{{ U_ACTION }}">
++ 		<fieldset class="quick">
++-			<input class="button2" type="submit" name="addrule" value="{{ lang('ACP_AUTOGROUPS_CREATE_RULE') }}">
++-			<input type="hidden" name="action" value="add">
+++			<input class="button2" type="submit" name="addrule" value="{{ lang('ACP_AUTOGROUPS_CREATE_RULE') }}" />
+++			<input type="hidden" name="action" value="add" />
++ 			{{ S_FORM_TOKEN }}
++ 		</fieldset>
++ 	</form>
++@@ -113,7 +113,7 @@
++ 		<fieldset>
++ 			<legend>{{ lang('GENERAL_OPTIONS') }}</legend>
++ 			<dl>
++-				<dt><label for="group_ids">{{ lang('ACP_AUTOGROUPS_EXEMPT_GROUP') ~ lang('COLON') }}</label><br><span>{{ lang('ACP_AUTOGROUPS_EXEMPT_GROUP_EXPLAIN') }}</span></dt>
+++				<dt><label for="group_ids">{{ lang('ACP_AUTOGROUPS_EXEMPT_GROUP') ~ lang('COLON') }}</label><br /><span>{{ lang('ACP_AUTOGROUPS_EXEMPT_GROUP_EXPLAIN') }}</span></dt>
++ 				<dd>
++ 					<select name="group_ids[]" id="group_ids" size="10" multiple="multiple">
++ 						{% for groups in loops.groups %}
++@@ -123,7 +123,7 @@
++ 				</dd>
++ 			</dl>
++ 			<p class="quick">
++-				<input class="button1" type="submit" id="generalsubmit" name="generalsubmit" value="{{ lang('SUBMIT') }}">
+++				<input class="button1" type="submit" id="generalsubmit" name="generalsubmit" value="{{ lang('SUBMIT') }}" />
++ 			</p>
++ 		</fieldset>
++ 	</form>
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/composer.json"
++index e4b6156a0..c69d15523 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/composer.json"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/composer.json"
++@@ -3,7 +3,7 @@
++     "type": "phpbb-extension",
++     "description": "An extension that can automate the process of adding and removing users from groups upon reaching specified milestones related to their post count, age, membership, and warnings count.",
++     "homepage": "https://www.phpbb.com/customise/db/extension/auto_groups/",
++-    "version": "2.0.7",
+++    "version": "2.0.6",
++     "keywords": [
++         "phpbb",
++         "extension",
++@@ -57,11 +57,11 @@
++     ],
++     "require": {
++         "php": ">=5.5",
++-        "composer/installers": "^1.0 || ^2.0",
+++        "composer/installers": "~1.0.0",
++         "phpbb/phpbb": ">=3.2.0"
++     },
++     "require-dev": {
++-        "phing/phing": "~2.4"
+++        "phing/phing": "2.4.*"
++     },
++     "extra": {
++         "display-name": "Auto Groups",
++@@ -74,10 +74,5 @@
++             "filename": "version_check",
++             "ssl": true
++         }
++-    },
++-    "config": {
++-        "allow-plugins": {
++-            "composer/installers": true
++-        }
++     }
++ }
++\ No newline at end of file
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/diff_full.tmp"
++new file mode 100644
++index 000000000..9e383e84e
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/diff_full.tmp"
++@@ -0,0 +1,118 @@
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/CHANGELOG.md" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/CHANGELOG.md"
+++index 1c13badcc..cb113957c 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/CHANGELOG.md"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/CHANGELOG.md"
+++@@ -1,27 +1,20 @@
+++ # Changelog
+++ 
+++-## Version 2.x (for phpBB 3.2.x, 3.3.x and 4.0.x)
++++## Version 2.x (for phpBB 3.2.x and 3.3.x)
+++ 
+++-### 2.0.7 - 2026-03-20
+++-
+++-- Allow installations on phpBB4-alpha+ boards via Extension Catalog.
+++-- Removed old XHTML code.
+++-- Added Romanian language pack.
+++-- Updated Dutch language pack.
+++-
+++-### 2.0.6 - 2024-01-18
++++## 2.0.6 - 2024-01-18
+++ 
+++ - Fixed PHP warnings that could be caused by a conflict with other extensions.
+++ - Updated English, French, German and Turkish language packs.
+++ 
+++-### 2.0.5 - 2022-06-18
++++## 2.0.5 - 2022-06-18
+++ 
+++ - Run membership condition check when a user logs in.
+++ - Added Portuguese language pack
+++ 
+++ ### 2.0.4 - 2021-03-12
+++ 
+++-- Added a new option to exempt members of selected user groups from being affected by an Auto Group rule.
++++- Added new option to exempt members of selected user groups from being affected by an Auto Group rule.
+++ - Fixed potential PHP DEBUG notices.
+++ - Fixed MSSQL issues with the Warnings and Membership auto group rules.
+++ - Various minor code and behavior improvements.
+++@@ -37,7 +30,7 @@
+++ ### 2.0.2 - 2019-03-27
+++ 
+++ - Check Membership days after user registrations.
+++-- Check Post counts after post-approvals.
++++- Check Post counts after post approvals.
+++ - Avoid possible errors with User age due to invalid dates.
+++ - Added Polish language pack
+++ - Added Turkish language pack
+++@@ -56,7 +49,7 @@
+++ 
+++ ### 1.0.2 - 2016-11-30
+++ 
+++-- Fixed a new years day bug in the auto group by user age condition
++++- Fixed new years day bug in the auto group by user age condition
+++ - Various code improvements and maintenance
+++ - Added Croatian language packs
+++ - Added Chinese language packs
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/adm/style/manage_autogroups.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/adm/style/manage_autogroups.html"
+++index a7bc931e7..3b3e00852 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/adm/style/manage_autogroups.html"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/adm/style/manage_autogroups.html"
+++@@ -15,7 +15,7 @@
+++ 		<fieldset>
+++ 			<legend>{{ lang(S_ADD ? 'ACP_AUTOGROUPS_ADD' : 'ACP_AUTOGROUPS_EDIT') }}</legend>
+++ 			<dl>
+++-				<dt><label for="autogroups_group_id">{{ lang('ACP_AUTOGROUPS_GROUP_NAME') ~ lang('COLON') }}</label><br><span>{{ lang('ACP_AUTOGROUPS_GROUP_NAME_EXPLAIN') }}</span></dt>
++++				<dt><label for="autogroups_group_id">{{ lang('ACP_AUTOGROUPS_GROUP_NAME') ~ lang('COLON') }}</label><br /><span>{{ lang('ACP_AUTOGROUPS_GROUP_NAME_EXPLAIN') }}</span></dt>
+++ 				<dd>
+++ 					<select name="autogroups_group_id" id="autogroups_group_id">
+++ 						{% for groups in loops.groups %}
+++@@ -27,7 +27,7 @@
+++ 				</dd>
+++ 			</dl>
+++ 			<dl>
+++-				<dt><label for="autogroups_type_id">{{ lang('ACP_AUTOGROUPS_CONDITION_NAME') ~ lang('COLON') }}</label><br><span>{{ lang('ACP_AUTOGROUPS_CONDITION_NAME_EXPLAIN') }}</span></dt>
++++				<dt><label for="autogroups_type_id">{{ lang('ACP_AUTOGROUPS_CONDITION_NAME') ~ lang('COLON') }}</label><br /><span>{{ lang('ACP_AUTOGROUPS_CONDITION_NAME_EXPLAIN') }}</span></dt>
+++ 				<dd><select name="autogroups_type_id" id="autogroups_type_id">
+++ 					{% for conditions in loops.conditions %}
+++ 						<option value="{{ conditions.CONDITION_ID }}"{% if conditions.S_SELECTED %} selected="selected"{% endif %}>{{ conditions.CONDITION_NAME }}</option>
+++@@ -35,25 +35,25 @@
+++ 				</select></dd>
+++ 			</dl>
+++ 			<dl>
+++-				<dt><label for="autogroups_min_value">{{ lang('ACP_AUTOGROUPS_MIN_VALUE') ~ lang('COLON') }}</label><br><span>{{ lang('ACP_AUTOGROUPS_MIN_VALUE_EXPLAIN') }}</span></dt>
+++-				<dd><input id="autogroups_min_value" type="number" size="4" name="autogroups_min_value" value="{{ MIN_VALUE }}"></dd>
++++				<dt><label for="autogroups_min_value">{{ lang('ACP_AUTOGROUPS_MIN_VALUE') ~ lang('COLON') }}</label><br /><span>{{ lang('ACP_AUTOGROUPS_MIN_VALUE_EXPLAIN') }}</span></dt>
++++				<dd><input id="autogroups_min_value" type="number" size="4" name="autogroups_min_value" value="{{ MIN_VALUE }}" /></dd>
+++ 			</dl>
+++ 			<dl>
+++-				<dt><label for="autogroups_max_value">{{ lang('ACP_AUTOGROUPS_MAX_VALUE') ~ lang('COLON') }}</label><br><span>{{ lang('ACP_AUTOGROUPS_MAX_VALUE_EXPLAIN') }}</span></dt>
+++-				<dd><input id="autogroups_max_value" type="number" size="4" name="autogroups_max_value" value="{{ MAX_VALUE }}"></dd>
++++				<dt><label for="autogroups_max_value">{{ lang('ACP_AUTOGROUPS_MAX_VALUE') ~ lang('COLON') }}</label><br /><span>{{ lang('ACP_AUTOGROUPS_MAX_VALUE_EXPLAIN') }}</span></dt>
++++				<dd><input id="autogroups_max_value" type="number" size="4" name="autogroups_max_value" value="{{ MAX_VALUE }}" /></dd>
+++ 			</dl>
+++ 			<dl>
+++-				<dt><label for="autogroups_default">{{ lang('ACP_AUTOGROUPS_DEFAULT') ~ lang('COLON') }}</label><br><span>{{ lang('ACP_AUTOGROUPS_DEFAULT_EXPLAIN') }} {{ EXEMPT_GROUPS ? lang('ACP_AUTOGROUPS_DEFAULT_EXEMPTION', EXEMPT_GROUPS) : '' }}</span></dt>
+++-				<dd><label><input type="radio" class="radio" id="autogroups_default" name="autogroups_default" value="1"{% if S_DEFAULT %} checked="checked"{% endif %}> {{ lang('YES') }}</label>
+++-					<label><input type="radio" class="radio" name="autogroups_default" value="0"{% if not S_DEFAULT %} checked="checked"{% endif %}> {{ lang('NO') }}</label></dd>
++++				<dt><label for="autogroups_default">{{ lang('ACP_AUTOGROUPS_DEFAULT') ~ lang('COLON') }}</label><br /><span>{{ lang('ACP_AUTOGROUPS_DEFAULT_EXPLAIN') }} {{ EXEMPT_GROUPS ? lang('ACP_AUTOGROUPS_DEFAULT_EXEMPTION', EXEMPT_GROUPS) : '' }}</span></dt>
++++				<dd><label><input type="radio" class="radio" id="autogroups_default" name="autogroups_default" value="1"{% if S_DEFAULT %} checked="checked"{% endif %} /> {{ lang('YES') }}</label>
++++					<label><input type="radio" class="radio" name="autogroups_default" value="0"{% if not S_DEFAULT %} checked="checked"{% endif %} /> {{ lang('NO') }}</label></dd>
+++ 			</dl>
+++ 			<dl>
+++-				<dt><label for="autogroups_notify">{{ lang('ACP_AUTOGROUPS_NOTIFY') ~ lang('COLON') }}</label><br><span>{{ lang('ACP_AUTOGROUPS_NOTIFY_EXPLAIN') }}</span></dt>
+++-				<dd><label><input type="radio" class="radio" id="autogroups_notify" name="autogroups_notify" value="1"{% if S_NOTIFY %} checked="checked"{% endif %}> {{ lang('YES') }}</label>
+++-					<label><input type="radio" class="radio" name="autogroups_notify" value="0"{% if not S_NOTIFY %} checked="checked"{% endif %}> {{ lang('NO') }}</label></dd>
++++				<dt><label for="autogroups_notify">{{ lang('ACP_AUTOGROUPS_NOTIFY') ~ lang('COLON') }}</label><br /><span>{{ lang('ACP_AUTOGROUPS_NOTIFY_EXPLAIN') }}</span></dt>
++++				<dd><label><input type="radio" class="radio" id="autogroups_notify" name="autogroups_notify" value="1"{% if S_NOTIFY %} checked="checked"{% endif %} /> {{ lang('YES') }}</label>
++++					<label><input type="radio" class="radio" name="autogroups_notify" value="0"{% if not S_NOTIFY %} checked="checked"{% endif %} /> {{ lang('NO') }}</label></dd>
+++ 			</dl>
+++ 			<dl>
+++-				<dt><label for="autogroups_excluded_groups">{{ lang('ACP_AUTOGROUPS_EXCLUDE_GROUP') ~ lang('COLON') }}</label><br><span>{{ lang('ACP_AUTOGROUPS_EXCLUDE_GROUP_EXPLAIN') }}</span></dt>
++++				<dt><label for="autogroups_excluded_groups">{{ lang('ACP_AUTOGROUPS_EXCLUDE_GROUP') ~ lang('COLON') }}</label><br /><span>{{ lang('ACP_AUTOGROUPS_EXCLUDE_GROUP_EXPLAIN') }}</span></dt>
+++ 				<dd>
+++ 					<select name="autogroups_excluded_groups[]" id="autogroups_excluded_groups" size="10" multiple="multiple">
+++ 						{% for groups in loops.excluded_groups %}
+++@@ -64,8 +64,8 @@
+++ 			</dl>
+++ 		</fieldset>
+++ 		<p class="submit-buttons">
+++-			<input class="button1" type="submit" id="submit" name="submit" value="{{ lang('SUBMIT')
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/ext.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/ext.php"
++index 1b43ce6cc..0ea7e298a 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/ext.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/ext.php"
++@@ -59,7 +59,7 @@ class ext extends \phpbb\extension\base
++ 	 */
++ 	protected function check_php_version()
++ 	{
++-		return PHP_VERSION_ID >= 50500;
+++		return phpbb_version_compare(PHP_VERSION, '5.5.0', '>=');
++ 	}
++ 
++ 	/**
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/language/ar/autogroups_acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/language/ar/autogroups_acp.php"
++index 90ded00e8..cb914191f 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/language/ar/autogroups_acp.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/language/ar/autogroups_acp.php"
++@@ -71,7 +71,7 @@ $lang = array_merge($lang, array(
++ 	'ACP_AUTOGROUPS_DELETE_SUCCESS'	=> 'تم حذف المجموعة التلقائية بنجاح.',
++ 	'ACP_AUTOGROUPS_EMPTY'			=> 'لا توجد مجموعات تلقائية.',
++ 	'ACP_AUTOGROUPS_NO_GROUPS'		=> 'لا توجد مجموعات',
++-	'ACP_AUTOGROUPS_INVALID_GROUPS'	=> 'هناك خطأ. لم يتم تحديد مجموعة عضو.<br>يمكن استخدام المجموعات التلقائية فقط مع مجموعات العضو المعروفة , والتي يمكن انشائها بواسطة صفحة إدارة المجموعات.',
+++	'ACP_AUTOGROUPS_INVALID_GROUPS'	=> 'هناك خطأ. لم يتم تحديد مجموعة عضو.<br />يمكن استخدام المجموعات التلقائية فقط مع مجموعات العضو المعروفة , والتي يمكن انشائها بواسطة صفحة إدارة المجموعات.',
++ 	'ACP_AUTOGROUPS_INVALID_RANGE'	=> 'هناك خطأ. لا تستطيع ضبط نفس القيمة في الحد الأعلى و الحد الأدني.',
++ 
++ 	// Conditions
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/language/cs/autogroups_acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/language/cs/autogroups_acp.php"
++index f6d540571..9d55ebca4 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/language/cs/autogroups_acp.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/language/cs/autogroups_acp.php"
++@@ -70,7 +70,7 @@ $lang = array_merge($lang, array(
++ 	'ACP_AUTOGROUPS_DELETE_SUCCESS'	=> 'Auto skupina byla úspěšně odstraněna.',
++ 	'ACP_AUTOGROUPS_EMPTY'			=> 'Neexistují žádné auto skupiny.',
++ 	'ACP_AUTOGROUPS_NO_GROUPS'		=> 'K dispozici nejsou žádné skupiny',
++-	'ACP_AUTOGROUPS_INVALID_GROUPS'	=> 'Vyskytla se chyba. Platná skupina uživatelů nebyla vybrána.<br>Auto Skupiny mohou být použity pouze s uživatelsky definovanými skupinami, které mohou být vytvořeny na straně správa skupin.',
+++	'ACP_AUTOGROUPS_INVALID_GROUPS'	=> 'Vyskytla se chyba. Platná skupina uživatelů nebyla vybrána.<br />Auto Skupiny mohou být použity pouze s uživatelsky definovanými skupinami, které mohou být vytvořeny na straně správa skupin.',
++ 	'ACP_AUTOGROUPS_INVALID_RANGE'	=> 'Vyskytla se chyba. Minimální a maximální hodnoty nelze nastavit na stejnou hodnotu.',
++ 
++ 	// Conditions
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/language/da/autogroups_acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/language/da/autogroups_acp.php"
++index e571ead7f..712f6d8d5 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/language/da/autogroups_acp.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/language/da/autogroups_acp.php"
++@@ -70,7 +70,7 @@ $lang = array_merge($lang, array(
++ 	'ACP_AUTOGROUPS_DELETE_SUCCESS'	=> 'Autogruppe slettet.',
++ 	'ACP_AUTOGROUPS_EMPTY'			=> 'Der er ingen autogrupper.',
++ 	'ACP_AUTOGROUPS_NO_GROUPS'		=> 'Ingen grupper tilgængelig',
++-	'ACP_AUTOGROUPS_INVALID_GROUPS'	=> 'Der opstod en fejl. Der var ikke valgt nogen gyldig brugergruppe.<br>Autogrupper kan kun bruges med brugerdefinerede grupper, som kan oprettes på Håndter grupper-siden.',
+++	'ACP_AUTOGROUPS_INVALID_GROUPS'	=> 'Der opstod en fejl. Der var ikke valgt nogen gyldig brugergruppe.<br />Autogrupper kan kun bruges med brugerdefinerede grupper, som kan oprettes på Håndter grupper-siden.',
++ 	'ACP_AUTOGROUPS_INVALID_RANGE'	=> 'Der opstod en fejl. Minimums- og maksimumsværdier kan ikke sættes til den samme værdi.',
++ 
++ 	// Conditions
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/language/de/autogroups_acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/language/de/autogroups_acp.php"
++index a7c43bc16..59ddcf9f9 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/language/de/autogroups_acp.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/language/de/autogroups_acp.php"
++@@ -70,7 +70,7 @@ $lang = array_merge($lang, array(
++ 	'ACP_AUTOGROUPS_DELETE_SUCCESS'	=> 'Auto-Gruppe erfolgreich gelöscht.',
++ 	'ACP_AUTOGROUPS_EMPTY'			=> 'Es gibt keine Auto-Gruppen.',
++ 	'ACP_AUTOGROUPS_NO_GROUPS'		=> 'Keine Gruppen vorhanden',
++-	'ACP_AUTOGROUPS_INVALID_GROUPS'	=> 'Ein Fehler ist aufgetreten. Es wurde keine gültige Gruppe ausgewählt.<br>Auto Groups kann nur mit benutzerdefinierten Gruppen verwendet werden, welche über die Gruppenverwaltung erstellt werden können.',
+++	'ACP_AUTOGROUPS_INVALID_GROUPS'	=> 'Ein Fehler ist aufgetreten. Es wurde keine gültige Gruppe ausgewählt.<br />Auto Groups kann nur mit benutzerdefinierten Gruppen verwendet werden, welche über die Gruppenverwaltung erstellt werden können.',
++ 	'ACP_AUTOGROUPS_INVALID_RANGE'	=> 'Ein Fehler ist aufgetreten. Minimal- und Maximalwerte können nicht auf den gleichen Wert eingestellt werden.',
++ 
++ 	// Conditions
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/language/en/autogroups_acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/language/en/autogroups_acp.php"
++index 3efebd72d..6a1c7be0c 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/language/en/autogroups_acp.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/language/en/autogroups_acp.php"
++@@ -70,7 +70,7 @@ $lang = array_merge($lang, array(
++ 	'ACP_AUTOGROUPS_DELETE_SUCCESS'	=> 'Auto Group successfully deleted.',
++ 	'ACP_AUTOGROUPS_EMPTY'			=> 'There are no auto groups.',
++ 	'ACP_AUTOGROUPS_NO_GROUPS'		=> 'No groups available',
++-	'ACP_AUTOGROUPS_INVALID_GROUPS'	=> 'An error occurred. A valid user group was not selected.<br>Auto Groups can only be used with user defined groups, which can be created on the Manage groups page.',
+++	'ACP_AUTOGROUPS_INVALID_GROUPS'	=> 'An error occurred. A valid user group was not selected.<br />Auto Groups can only be used with user defined groups, which can be created on the Manage groups page.',
++ 	'ACP_AUTOGROUPS_INVALID_RANGE'	=> 'An error occurred. Minimum and maximum values can not be set to the same value.',
++ 
++ 	// Conditions
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/language/es/autogroups_acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/language/es/autogroups_acp.php"
++index 95b69614c..0f1364ac6 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/language/es/autogroups_acp.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/language/es/autogroups_acp.php"
++@@ -71,7 +71,7 @@ $lang = array_merge($lang, array(
++ 	'ACP_AUTOGROUPS_DELETE_SUCCESS'	=> 'Auto Grupo borrado correctamente.',
++ 	'ACP_AUTOGROUPS_EMPTY'			=> 'No hay Auto Grupos.',
++ 	'ACP_AUTOGROUPS_NO_GROUPS'		=> 'No hay grupos disponibles',
++-	'ACP_AUTOGROUPS_INVALID_GROUPS'	=> 'Ocurrio un error. Un grupo de usuario válido no fue seleccionado.<br>Auto Grupos sólo se puede utilizar con los grupos definidos por el usuario, estos se pueden crear en la página Administrar grupos.',
+++	'ACP_AUTOGROUPS_INVALID_GROUPS'	=> 'Ocurrio un error. Un grupo de usuario válido no fue seleccionado.<br />Auto Grupos sólo se puede utilizar con los grupos definidos por el usuario, estos se pueden crear en la página Administrar grupos.',
++ 	'ACP_AUTOGROUPS_INVALID_RANGE'	=> 'Ocurrio un error. Los valores mínimos y máximos no se pueden establecer con el mismo valor.',
++ 
++ 	// Conditions
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/language/et/autogroups_acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/language/et/autogroups_acp.php"
++index 02337e2d2..c6e655460 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/language/et/autogroups_acp.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/language/et/autogroups_acp.php"
++@@ -71,7 +71,7 @@ $lang = array_merge($lang, array(
++ 	'ACP_AUTOGROUPS_DELETE_SUCCESS'	=> 'Automaatne grupp on edukalt kustutatud.',
++ 	'ACP_AUTOGROUPS_EMPTY'			=> 'Ühtegi automaatset gruppi ei ole.',
++ 	'ACP_AUTOGROUPS_NO_GROUPS'		=> 'Ühtegi gruppi ei ole saadaval.',
++-	'ACP_AUTOGROUPS_INVALID_GROUPS'	=> 'Tekkis viga. Kehtivat kasutajagruppi ei ole valitud.<br>Automaatseid gruppe saab kasutada ainult siis, kui liikmele on määratud grupid, mida saab luua grupide halduse leheküljel.',
+++	'ACP_AUTOGROUPS_INVALID_GROUPS'	=> 'Tekkis viga. Kehtivat kasutajagruppi ei ole valitud.<br />Automaatseid gruppe saab kasutada ainult siis, kui liikmele on määratud grupid, mida saab luua grupide halduse leheküljel.',
++ 	'ACP_AUTOGROUPS_INVALID_RANGE'	=> 'Tekkis viga. Minimaalset ja maksimaalset väärtust ei saa seadistada samade väärtustega.',
++ 
++ 	// Conditions
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/language/fr/autogroups_acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/language/fr/autogroups_acp.php"
++index f0d07e2bc..da08a61ec 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/language/fr/autogroups_acp.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/language/fr/autogroups_acp.php"
++@@ -71,7 +71,7 @@ $lang = array_merge($lang, array(
++ 	'ACP_AUTOGROUPS_DELETE_SUCCESS'	=> 'Le groupe automatique a été supprimé avec succès.',
++ 	'ACP_AUTOGROUPS_EMPTY'			=> 'Il n’y a aucun groupe automatique.',
++ 	'ACP_AUTOGROUPS_NO_GROUPS'		=> 'Aucun groupe disponible',
++-	'ACP_AUTOGROUPS_INVALID_GROUPS'	=> 'Une erreur est survenue. Aucun groupe d’utilisateur valide n’a été sélectionné.<br>L’extension Auto Groups fonctionne uniquement avec des groupes d’utilisateurs définis, pouvant être créés depuis la page « Gérer les groupes ».',
+++	'ACP_AUTOGROUPS_INVALID_GROUPS'	=> 'Une erreur est survenue. Aucun groupe d’utilisateur valide n’a été sélectionné.<br />L’extension Auto Groups fonctionne uniquement avec des groupes d’utilisateurs définis, pouvant être créés depuis la page « Gérer les groupes ».',
++ 	'ACP_AUTOGROUPS_INVALID_RANGE'	=> 'Une erreur est survenue. La valeur minimale et la valeur maximale ne peuvent être identiques.',
++ 
++ 	// Conditions
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/language/hr/autogroups_acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/language/hr/autogroups_acp.php"
++index 6d3db7d8f..d3b2af62a 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/language/hr/autogroups_acp.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/language/hr/autogroups_acp.php"
++@@ -71,7 +71,7 @@ $lang = array_merge($lang, array(
++ 	'ACP_AUTOGROUPS_DELETE_SUCCESS'	=> 'Automatsko upravljanje izabranom grupom je izbrisano.',
++ 	'ACP_AUTOGROUPS_EMPTY'			=> 'There are no auto groups.',
++ 	'ACP_AUTOGROUPS_NO_GROUPS'		=> 'Nema dostupnih grupa',
++-	'ACP_AUTOGROUPS_INVALID_GROUPS'	=> 'Došlo je do greške: nije izabrana niti jedna grupa.<br>Automatsko upravljanje grupom/ama može se primijeniti samo na korisnički dodane grupe.',
+++	'ACP_AUTOGROUPS_INVALID_GROUPS'	=> 'Došlo je do greške: nije izabrana niti jedna grupa.<br />Automatsko upravljanje grupom/ama može se primijeniti samo na korisnički dodane grupe.',
++ 	'ACP_AUTOGROUPS_INVALID_RANGE'	=> 'Došlo je do greške: minimalna i maksimalna vrijednost ne mogu biti postavljene na istu vrijednost.',
++ 
++ 	// Conditions
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/language/hr_x_vi/autogroups_acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/language/hr_x_vi/autogroups_acp.php"
++index bb6c89ba6..e37242340 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/language/hr_x_vi/autogroups_acp.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/language/hr_x_vi/autogroups_acp.php"
++@@ -71,7 +71,7 @@ $lang = array_merge($lang, array(
++ 	'ACP_AUTOGROUPS_DELETE_SUCCESS'	=> 'Automatsko upravljanje izabranom grupom je izbrisano.',
++ 	'ACP_AUTOGROUPS_EMPTY'			=> 'There are no auto groups.',
++ 	'ACP_AUTOGROUPS_NO_GROUPS'		=> 'Nema dostupnih grupa',
++-	'ACP_AUTOGROUPS_INVALID_GROUPS'	=> 'Došlo je do greške: nije izabrana niti jedna grupa.<br>Automatsko upravljanje grupom/ama može se primijeniti samo na korisnički dodane grupe.',
+++	'ACP_AUTOGROUPS_INVALID_GROUPS'	=> 'Došlo je do greške: nije izabrana niti jedna grupa.<br />Automatsko upravljanje grupom/ama može se primijeniti samo na korisnički dodane grupe.',
++ 	'ACP_AUTOGROUPS_INVALID_RANGE'	=> 'Došlo je do greške: minimalna i maksimalna vrijednost ne mogu biti postavljene na istu vrijednost.',
++ 
++ 	// Conditions
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/language/it/autogroups_acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/language/it/autogroups_acp.php"
++index bcc4ff9fd..e844104c6 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/language/it/autogroups_acp.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/language/it/autogroups_acp.php"
++@@ -70,7 +70,7 @@ $lang = array_merge($lang, array(
++ 	'ACP_AUTOGROUPS_DELETE_SUCCESS'	=> 'Autogruppo rimosso correttamente.',
++ 	'ACP_AUTOGROUPS_EMPTY'			=> 'Non ci sono autogruppi.',
++ 	'ACP_AUTOGROUPS_NO_GROUPS'		=> 'Non ci sono gruppi a disposizione',
++-	'ACP_AUTOGROUPS_INVALID_GROUPS'	=> 'Si è verificato un errore: non è stato selezionato un gruppo utente valido.<br>Autogruppi può essere usato solo con gruppi utenti, creabili nella pagina Gestisci gruppi.',
+++	'ACP_AUTOGROUPS_INVALID_GROUPS'	=> 'Si è verificato un errore: non è stato selezionato un gruppo utente valido.<br />Autogruppi può essere usato solo con gruppi utenti, creabili nella pagina Gestisci gruppi.',
++ 	'ACP_AUTOGROUPS_INVALID_RANGE'	=> 'Si è verificato un errore: il valore minimo e il valore massimo non possono coincidere.',
++ 
++ 	// Conditions
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/language/nl/autogroups_acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/language/nl/autogroups_acp.php"
++index 3ef422463..fdd5251f5 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/language/nl/autogroups_acp.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/language/nl/autogroups_acp.php"
++@@ -39,45 +39,45 @@ if (empty($lang) || !is_array($lang))
++ //
++ 
++ $lang = array_merge($lang, array(
++-	'ACP_AUTOGROUPS_MANAGE'			=> 'Beheer Auto Groepen',
++-	'ACP_AUTOGROUPS_MANAGE_EXPLAIN'	=> 'Met dit formulier kun je Auto Groepconfiguraties toevoegen, bewerken, bekijken en verwijderen.',
++-	'ACP_AUTOGROUPS_ADD'			=> 'Voeg Auto Groepen toe',
++-	'ACP_AUTOGROUPS_EDIT'			=> 'Bewerk Auto Groepen',
+++	'ACP_AUTOGROUPS_MANAGE'			=> 'Beheer Automatische Groepen',
+++	'ACP_AUTOGROUPS_MANAGE_EXPLAIN'	=> 'Hier kun je automatische groepen aanmaken, bewerken, weergeven en verwijderen.',
+++	'ACP_AUTOGROUPS_ADD'			=> 'Voeg automatische groep toe',
+++	'ACP_AUTOGROUPS_EDIT'			=> 'Bewerk automatische groep',
++ 
++ 	'ACP_AUTOGROUPS_GROUP_NAME'				=> 'Groep',
++-	'ACP_AUTOGROUPS_GROUP_NAME_EXPLAIN'		=> 'Kies een groep waaraan gebruikers automatisch worden toegevoegd of verwijderd.',
++-	'ACP_AUTOGROUPS_CONDITION_NAME'			=> 'Auto Groep type',
++-	'ACP_AUTOGROUPS_CONDITION_NAME_EXPLAIN'	=> 'Kies het type voorwaarde waarop gebruikers aan deze groep worden toegevoegd of verwijderd.',
+++	'ACP_AUTOGROUPS_GROUP_NAME_EXPLAIN'		=> 'Kies een groep waaraan gebruikers automatisch toegevoegd of verwijderd moeten worden.',
+++	'ACP_AUTOGROUPS_CONDITION_NAME'			=> 'Type automatische groep',
+++	'ACP_AUTOGROUPS_CONDITION_NAME_EXPLAIN'	=> 'Kies het type conditie waarop gebruikers toegevoegd of verwijderd worden aan deze groep.',
++ 	'ACP_AUTOGROUPS_MIN_VALUE'				=> 'Minimale waarde',
++-	'ACP_AUTOGROUPS_MIN_VALUE_EXPLAIN'		=> 'Gebruikers worden aan deze groep toegevoegd als ze de minimale waarde bereiken of overschrijden.',
+++	'ACP_AUTOGROUPS_MIN_VALUE_EXPLAIN'		=> 'Gebruikers worden toegevoegd aan deze groep als de minimale waarde wordt overschreden.',
++ 	'ACP_AUTOGROUPS_MAX_VALUE'				=> 'Maximale waarde',
++-	'ACP_AUTOGROUPS_MAX_VALUE_EXPLAIN'		=> 'Gebruikers worden uit deze groep verwijderd als ze de maximale waarde bereiken of overschrijden. Zet dit op 0 als je niet wilt dat gebruikers worden verwijderd.',
++-	'ACP_AUTOGROUPS_DEFAULT'				=> 'Stel standaardgroep in',
++-	'ACP_AUTOGROUPS_DEFAULT_EXPLAIN'		=> 'Maak dit de nieuwe standaardgroep van de gebruiker.',
++-	'ACP_AUTOGROUPS_DEFAULT_EXEMPTION'		=> 'Dit heeft geen effect op gebruikers waarvan de standaardgroep een van de volgende is: %s.',
++-	'ACP_AUTOGROUPS_NOTIFY'					=> 'Meld gebruikers',
++-	'ACP_AUTOGROUPS_NOTIFY_EXPLAIN'			=> 'Stuur een melding naar gebruikers nadat ze automatisch aan deze groep zijn toegevoegd of verwijderd.',
+++	'ACP_AUTOGROUPS_MAX_VALUE_EXPLAIN'		=> 'Gebruikers worden verwijderd van deze groep als de maximale waarde wordt overschreden. Laat dit veld leeg om automatisch verwijderen te voorkomen.',
+++	'ACP_AUTOGROUPS_DEFAULT'				=> 'Instellen als standaard groep',
+++	'ACP_AUTOGROUPS_DEFAULT_EXPLAIN'		=> 'Maak voor deze gebruikers de groep standaard.',
+++	'ACP_AUTOGROUPS_DEFAULT_EXEMPTION'		=> 'Dit heeft geen invloed op gebruikers wiens standaardgroep één van de volgende is: %s.',
+++	'ACP_AUTOGROUPS_NOTIFY'					=> 'Notificeer gebruikers',
+++	'ACP_AUTOGROUPS_NOTIFY_EXPLAIN'			=> 'Stuur een notificatie naar gebruikers als ze automatisch worden toegevoegd of verwijderd van deze groep.',
++ 
++-	'ACP_AUTOGROUPS_EXCLUDED_GROUPS'		=> 'Uitsluitgroepen',
++-	'ACP_AUTOGROUPS_EXCLUDE_GROUP'			=> 'Negeer leden van deze groepen',
++-	'ACP_AUTOGROUPS_EXCLUDE_GROUP_EXPLAIN'	=> 'Leden die tot <em>om het even welke groep</em> in deze lijst behoren, worden genegeerd. Laat dit veld leeg als je deze Auto Groep op <em>alle leden</em> van je forum wilt toepassen. Selecteer meerdere groepen door <samp>CTRL</samp> (of <samp>&#8984;CMD</samp> op Mac) in te houden en de groepen te selecteren.',
++-	'ACP_AUTOGROUPS_INVALID_EXCLUDE_GROUPS'	=> 'Er is een fout opgetreden. De groep voor deze voorwaarde kan niet ook in het veld "uitgesloten groepen" worden geselecteerd.',
++-	'ACP_AUTOGROUPS_EXEMPT_GROUP'			=> 'Stel standaardgroep uitzonderingen in',
++-	'ACP_AUTOGROUPS_EXEMPT_GROUP_EXPLAIN'	=> 'Auto Groepen zullen de <em>standaardgroep</em> van een gebruiker niet veranderen als deze in deze lijst is geselecteerd. Selecteer meerdere groepen door <samp>CTRL</samp> (of <samp>&#8984;CMD</samp> op Mac) in te houden en de groepen te selecteren.',
+++	'ACP_AUTOGROUPS_EXCLUDED_GROUPS'		=> 'Excluded groups',
+++	'ACP_AUTOGROUPS_EXCLUDE_GROUP'			=> 'Exclude members of these groups',
+++	'ACP_AUTOGROUPS_EXCLUDE_GROUP_EXPLAIN'	=> 'Members belonging to <em>any group</em> selected in this list will be ignored. Leave this field blank if you want this Auto Group applied to <em>all members</em> of your board. Select multiple groups by holding <samp>CTRL</samp> (or <samp>&#8984;CMD</samp> on Mac) and selecting the groups.',
+++	'ACP_AUTOGROUPS_INVALID_EXCLUDE_GROUPS'	=> 'An error occurred. The group for this condition can not also be selected in the excluded groups field.',
+++	'ACP_AUTOGROUPS_EXEMPT_GROUP'			=> 'Instellen standaard groep uitzonderingen',
+++	'ACP_AUTOGROUPS_EXEMPT_GROUP_EXPLAIN'	=> 'Automatische groepen zal niet een gebruiker zijn standaard groep veranderen als deze groep geselecteerd is in deze lijst. Selecteer meerdere groepen door <samp>CTRL</samp> (of <samp>&#8984;CMD</samp> op Mac) ingedrukt te houden en de groepen te selecteren.',
++ 
++-	'ACP_AUTOGROUPS_CREATE_RULE'	=> 'Maak nieuwe Auto Groep aan',
++-	'ACP_AUTOGROUPS_SUBMIT_SUCCESS'	=> 'Auto Groep succesvol geconfigureerd.',
++-	'ACP_AUTOGROUPS_DELETE_CONFIRM'	=> 'Weet je zeker dat je deze Auto Groepconfiguratie wilt verwijderen?',
++-	'ACP_AUTOGROUPS_DELETE_SUCCESS'	=> 'Auto Groep succesvol verwijderd.',
++-	'ACP_AUTOGROUPS_EMPTY'			=> 'Er zijn geen auto groepen.',
+++	'ACP_AUTOGROUPS_CREATE_RULE'	=> 'Maak nieuwe automatische groep',
+++	'ACP_AUTOGROUPS_SUBMIT_SUCCESS'	=> 'Automatische groep succesvol geconfigureerd',
+++	'ACP_AUTOGROUPS_DELETE_CONFIRM'	=> 'Weet je zeker dat je deze automatische groep wilt verwijderen?',
+++	'ACP_AUTOGROUPS_DELETE_SUCCESS'	=> 'Automatische groep succesvol verwijderd.',
+++	'ACP_AUTOGROUPS_EMPTY'			=> 'Er zijn geen automatische groepen.',
++ 	'ACP_AUTOGROUPS_NO_GROUPS'		=> 'Geen groepen beschikbaar',
++-	'ACP_AUTOGROUPS_INVALID_GROUPS'	=> 'Er is een fout opgetreden. Er is geen geldige gebruikersgroep geselecteerd.<br />Auto Groepen kunnen alleen worden gebruikt met door gebruikers gedefinieerde groepen, die aangemaakt kunnen worden op de pagina "Groepen beheren".',
++-	'ACP_AUTOGROUPS_INVALID_RANGE'	=> 'Er is een fout opgetreden. Minimale en maximale waarden kunnen niet op dezelfde waarde worden ingesteld.',
+++	'ACP_AUTOGROUPS_INVALID_GROUPS'	=> 'Er is een fout opgetreden. Er is geen geldige groep geselecteerd.<br />Automatische groepen kan alleen worden gebruikt bij door de beheerder aangemaakte groepen, welke kan worden aangemaakt op de “Beheer groepen pagina”.',
+++	'ACP_AUTOGROUPS_INVALID_RANGE'	=> 'Er is een fout opgetreden. De minimale en maximale waarde kunnen niet hetzelfde zijn.',
++ 
++ 	// Conditions
++-	'AUTOGROUPS_TYPE_BIRTHDAYS'		=> 'Gebruikersleeftijd',
+++	'AUTOGROUPS_TYPE_BIRTHDAYS'		=> 'Leeftijd',
++ 	'AUTOGROUPS_TYPE_LASTVISIT'		=> 'Dagen sinds laatste bezoek',
++-	'AUTOGROUPS_TYPE_MEMBERSHIP'	=> 'Lidmaatschapsdagen',
+++	'AUTOGROUPS_TYPE_MEMBERSHIP'	=> 'Aantal dagen lid',
++ 	'AUTOGROUPS_TYPE_POSTS'			=> 'Berichten',
++ 	'AUTOGROUPS_TYPE_WARNINGS'		=> 'Waarschuwingen',
++ ));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/language/nl/autogroups_common.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/language/nl/autogroups_common.php"
++index 72c058fe2..18cabd629 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/language/nl/autogroups_common.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/language/nl/autogroups_common.php"
++@@ -39,7 +39,7 @@ if (empty($lang) || !is_array($lang))
++ //
++ 
++ $lang = array_merge($lang, array(
++-	// Meldingen
++-	'AUTOGROUPS_NOTIFICATION_GROUP_ADDED'	=> '<strong>Groepupdate</strong>: Je bent toegevoegd aan de groep %1$s.',
++-	'AUTOGROUPS_NOTIFICATION_GROUP_REMOVED'	=> '<strong>Groepupdate</strong>: Je bent verwijderd uit de groep %1$s.',
+++	// Notifications
+++	'AUTOGROUPS_NOTIFICATION_GROUP_ADDED'	=> '<strong>Groepen bijgewerkt</strong>: Je bent toegevoegd aan de groep %1$s.',
+++	'AUTOGROUPS_NOTIFICATION_GROUP_REMOVED'	=> '<strong>Groepen bijgewerkt</strong>: Je bent verwijderd van de groep %1$s.',
++ ));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/language/nl/autogroups_install.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/language/nl/autogroups_install.php"
++deleted file mode 100644
++index 22e9038d9..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/language/nl/autogroups_install.php"
+++++ /dev/null
++@@ -1,42 +0,0 @@
++-<?php
++-/**
++-*
++-* Auto Groups extension for the phpBB Forum Software package.
++-*
++-* @copyright (c) 2019 phpBB Limited <https://www.phpbb.com>
++-* @license GNU General Public License, version 2 (GPL-2.0)
++-*
++-*/
++-
++-/**
++-* DO NOT CHANGE
++-*/
++-if (!defined('IN_PHPBB'))
++-{
++-	exit;
++-}
++-
++-if (empty($lang) || !is_array($lang))
++-{
++-	$lang = array();
++-}
++-
++-// DEVELOPERS PLEASE NOTE
++-//
++-// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
++-//
++-// Placeholders can now contain order information, e.g. instead of
++-// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
++-// translators to re-order the output of data while ensuring it remains correct
++-//
++-// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
++-// equally where a string contains only two placeholders which are used to wrap text
++-// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
++-//
++-// Some characters you may want to copy&paste:
++-// ’ » “ ” …
++-//
++-
++-$lang = array_merge($lang, array(
++-	'AUTOGROUPS_NOT_ENABLEABLE'	=> 'Auto Groepen konden niet worden ingeschakeld. De minimale vereisten van phpBB 3.2.0 en/of PHP 5.5.0 zijn niet voldaan.',
++-));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/language/nl/info_acp_autogroups.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/language/nl/info_acp_autogroups.php"
++index 2b1a7b8de..b79b84c22 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/language/nl/info_acp_autogroups.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/language/nl/info_acp_autogroups.php"
++@@ -39,10 +39,10 @@ if (empty($lang) || !is_array($lang))
++ //
++ 
++ $lang = array_merge($lang, array(
++-	'ACP_AUTOGROUPS_MANAGE'			=> 'Beheer Auto Groepen',
++-	'AUTOGROUPS_TYPE_NOT_EXIST'		=> 'Het Auto Groep type `%1$s` bestaat niet.',
+++	'ACP_AUTOGROUPS_MANAGE'			=> 'Beheer automatische groepen',
+++	'AUTOGROUPS_TYPE_NOT_EXIST'		=> 'Automatische groep type `%1$s` bestaat niet.',
++ 
++ 	// Logs
++-	'ACP_AUTOGROUPS_SAVED_LOG'		=> '<strong>Een Auto Groep configuratie is opgeslagen</strong>',
++-	'ACP_AUTOGROUPS_DELETE_LOG'		=> '<strong>Een Auto Groep configuratie is verwijderd</strong>',
+++	'ACP_AUTOGROUPS_SAVED_LOG'		=> '<strong>Een automatische groep configuratie is opgeslagen.</strong>',
+++	'ACP_AUTOGROUPS_DELETE_LOG'		=> '<strong>Een automatische groep configuratie is verwijderd.</strong>',
++ ));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/language/pl/autogroups_acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/language/pl/autogroups_acp.php"
++index 63e25a065..ea75ab064 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/language/pl/autogroups_acp.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/language/pl/autogroups_acp.php"
++@@ -71,7 +71,7 @@ $lang = array_merge($lang, array(
++ 	'ACP_AUTOGROUPS_DELETE_SUCCESS'	=> 'Usunięto automatyczną grupę.',
++ 	'ACP_AUTOGROUPS_EMPTY'			=> 'Brak automatycznych grup.',
++ 	'ACP_AUTOGROUPS_NO_GROUPS'		=> 'Brak grup',
++-	'ACP_AUTOGROUPS_INVALID_GROUPS'	=> 'Nie wybrano żadnej grupy.<br><br>Automatyczne grupy muszą być połączone z istniejącymi grupami, które można utworzyć na stronie zarządzania grupami.',
+++	'ACP_AUTOGROUPS_INVALID_GROUPS'	=> 'Nie wybrano żadnej grupy.<br /><br />Automatyczne grupy muszą być połączone z istniejącymi grupami, które można utworzyć na stronie zarządzania grupami.',
++ 	'ACP_AUTOGROUPS_INVALID_RANGE'	=> 'Minimalna i maksymalna wartość nie może być taka sama.',
++ 
++ 	// Conditions
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/language/pt/autogroups_acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/language/pt/autogroups_acp.php"
++index 1a82226d1..d050051cc 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/language/pt/autogroups_acp.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/language/pt/autogroups_acp.php"
++@@ -70,7 +70,7 @@ $lang = array_merge($lang, array(
++ 	'ACP_AUTOGROUPS_DELETE_SUCCESS'	=> 'Autogrupo excluído com sucesso.',
++ 	'ACP_AUTOGROUPS_EMPTY'			=> 'Não existem Autogrupos.',
++ 	'ACP_AUTOGROUPS_NO_GROUPS'		=> 'Não existem grupos disponíveis',
++-	'ACP_AUTOGROUPS_INVALID_GROUPS'	=> 'Um erro ocorreu. Um grupo de usuários válido não estava selecionado. <br> Autogrupos somente pode ser usado com grupos definidos de usuários, que podem ser criados em na página "Gerenciar grupos".',
+++	'ACP_AUTOGROUPS_INVALID_GROUPS'	=> 'Um erro ocorreu. Um grupo de usuários válido não estava selecionado. <br /> Autogrupos somente pode ser usado com grupos definidos de usuários, que podem ser criados em na página "Gerenciar grupos".',
++ 	'ACP_AUTOGROUPS_INVALID_RANGE'	=> 'Um erro ocorreu. Os valores mínimos e máximos não podem ser configurados para o mesmo valor.',
++ 
++ 	// Conditions
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/language/pt_br/autogroups_acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/language/pt_br/autogroups_acp.php"
++index 7bb319540..a08bf9e0a 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/language/pt_br/autogroups_acp.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/language/pt_br/autogroups_acp.php"
++@@ -71,7 +71,7 @@ $lang = array_merge($lang, array(
++ 	'ACP_AUTOGROUPS_DELETE_SUCCESS'	=> 'Autogrupo excluído com sucesso.',
++ 	'ACP_AUTOGROUPS_EMPTY'			=> 'Não existem Autogrupos.',
++ 	'ACP_AUTOGROUPS_NO_GROUPS'		=> 'Não existem grupos disponíveis',
++-	'ACP_AUTOGROUPS_INVALID_GROUPS'	=> 'Um erro ocorreu. Um grupo de usuários válido não estava selecionado. <br> Autogrupos somente pode ser usado com grupos definidos de usuários, que podem ser criados em na página "Gerenciar grupos".',
+++	'ACP_AUTOGROUPS_INVALID_GROUPS'	=> 'Um erro ocorreu. Um grupo de usuários válido não estava selecionado. <br /> Autogrupos somente pode ser usado com grupos definidos de usuários, que podem ser criados em na página "Gerenciar grupos".',
++ 	'ACP_AUTOGROUPS_INVALID_RANGE'	=> 'Um erro ocorreu. Os valores mínimos e máximos não podem ser configurados para o mesmo valor.',
++ 
++ 	// Conditions
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/language/ro/autogroups_acp.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/language/ro/autogroups_acp.php"
++deleted file mode 100644
++index 11dbd9571..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/language/ro/autogroups_acp.php"
+++++ /dev/null
++@@ -1,83 +0,0 @@
++-<?php
++-/**
++-*
++-* Auto Groups extension for the phpBB Forum Software package.
++-* Romanian translation by iorG19 (https://ioforos.com)
++-*
++-* @copyright (c) 2014 phpBB Limited <https://www.phpbb.com>
++-* @license GNU General Public License, version 2 (GPL-2.0)
++-*
++-*/
++-
++-/**
++-* DO NOT CHANGE
++-*/
++-if (!defined('IN_PHPBB'))
++-{
++-	exit;
++-}
++-
++-if (empty($lang) || !is_array($lang))
++-{
++-	$lang = array();
++-}
++-
++-// DEVELOPERS PLEASE NOTE
++-//
++-// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
++-//
++-// Placeholders can now contain order information, e.g. instead of
++-// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
++-// translators to re-order the output of data while ensuring it remains correct
++-//
++-// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
++-// equally where a string contains only two placeholders which are used to wrap text
++-// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
++-//
++-// Some characters you may want to copy&paste:
++-// ’ » “ ” …
++-//
++-
++-$lang = array_merge($lang, array(
++-	'ACP_AUTOGROUPS_MANAGE'			=> 'Gestionați Grupurile Automate',
++-	'ACP_AUTOGROUPS_MANAGE_EXPLAIN'	=> 'Folosind acest formular puteți adăuga, edita, vizualiza și șterge configurațiile Auto Group.',
++-	'ACP_AUTOGROUPS_ADD'			=> 'Adăugați grupuri automate',
++-	'ACP_AUTOGROUPS_EDIT'			=> 'Editați grupurile automate',
++-
++-	'ACP_AUTOGROUPS_GROUP_NAME'				=> 'Grup',
++-	'ACP_AUTOGROUPS_GROUP_NAME_EXPLAIN'		=> 'Alegeți un grup din care să adăugați/eliminați automat utilizatori.',
++-	'ACP_AUTOGROUPS_CONDITION_NAME'			=> 'Tip de grup automat',
++-	'ACP_AUTOGROUPS_CONDITION_NAME_EXPLAIN'	=> 'Alegeți tipul de condiție în care utilizatorii vor fi adăugați sau eliminați din acest grup.',
++-	'ACP_AUTOGROUPS_MIN_VALUE'				=> 'Valoarea minima',
++-	'ACP_AUTOGROUPS_MIN_VALUE_EXPLAIN'		=> 'Utilizatorii vor fi adăugați în acest grup dacă îndeplinesc sau depășesc valoarea minimă.',
++-	'ACP_AUTOGROUPS_MAX_VALUE'				=> 'Valoarea maximă',
++-	'ACP_AUTOGROUPS_MAX_VALUE_EXPLAIN'		=> 'Utilizatorii vor fi excluși din acest grup dacă îndeplinesc sau depășesc valoarea maximă. Setați acest lucru la 0 dacă nu doriți ca utilizatorii să fie eliminați.',
++-	'ACP_AUTOGROUPS_DEFAULT'				=> 'Setați grupul implicit',
++-	'ACP_AUTOGROUPS_DEFAULT_EXPLAIN'		=> 'Faceți din acesta noul grup implicit al utilizatorului.',
++-	'ACP_AUTOGROUPS_DEFAULT_EXEMPTION'		=> 'Acest lucru nu va afecta utilizatorii al căror grup de utilizatori implicit este unul dintre următoarele: %s.',
++-	'ACP_AUTOGROUPS_NOTIFY'					=> 'Notificați utilizatorii',
++-	'ACP_AUTOGROUPS_NOTIFY_EXPLAIN'			=> 'Trimiteți o notificare utilizatorilor după ce au fost adăugat sau eliminat automat din acest grup.',
++-
++-	'ACP_AUTOGROUPS_EXCLUDED_GROUPS'		=> 'Grupuri excluse',
++-	'ACP_AUTOGROUPS_EXCLUDE_GROUP'			=> 'Excludeți membrii acestor grupuri',
++-	'ACP_AUTOGROUPS_EXCLUDE_GROUP_EXPLAIN'	=> 'Membrii care aparțin <em>orice grup</em> selectat în această listă vor fi ignorați. Lăsați acest câmp necompletat dacă doriți ca acest grup automat să fie aplicat <em>toți membrii</em> ai forumului dvs. Selectați mai multe grupuri ținând apăsat pe <samp>CTRL</samp> (sau <samp>&#8984;CMD</samp> pe Mac) și selectând grupurile.',
++-	'ACP_AUTOGROUPS_INVALID_EXCLUDE_GROUPS'	=> 'A apărut o eroare. Grupul pentru această condiție nu poate fi selectat și în câmpul grupuri excluse.',
++-	'ACP_AUTOGROUPS_EXEMPT_GROUP'			=> 'Setați scutiri implicite de grup',
++-	'ACP_AUTOGROUPS_EXEMPT_GROUP_EXPLAIN'	=> 'Grupurile automate nu vor schimba <em>grupul implicit</em> al unui utilizator dacă este selectat în această listă. Selectați mai multe grupuri ținând apăsat pe <samp>CTRL</samp> (sau <samp>&#8984;CMD</samp> pe Mac) și selectând grupurile.',
++-
++-	'ACP_AUTOGROUPS_CREATE_RULE'	=> 'Creați un nou Grup Automat',
++-	'ACP_AUTOGROUPS_SUBMIT_SUCCESS'	=> 'Grupul automat a fost configurat cu succes.',
++-	'ACP_AUTOGROUPS_DELETE_CONFIRM'	=> 'Sigur doriți să ștergeți această configurație de grup automat?',
++-	'ACP_AUTOGROUPS_DELETE_SUCCESS'	=> 'Grupul automat a fost șters cu succes.',
++-	'ACP_AUTOGROUPS_EMPTY'			=> 'Nu există Grupuri Automate.',
++-	'ACP_AUTOGROUPS_NO_GROUPS'		=> 'Nu există grupuri disponibile',
++-	'ACP_AUTOGROUPS_INVALID_GROUPS'	=> 'A apărut o eroare. Nu a fost selectat un grup de utilizatori valid.<br />Grupurile automate pot fi utilizate numai cu grupuri definite de utilizator, care pot fi create pe pagina Gestionați grupuri.',
++-	'ACP_AUTOGROUPS_INVALID_RANGE'	=> 'A apărut o eroare. Valorile minime și maxime nu pot fi setate la aceeași valoare.',
++-
++-	// Conditions
++-	'AUTOGROUPS_TYPE_BIRTHDAYS'		=> 'Vârsta utilizatorului',
++-	'AUTOGROUPS_TYPE_LASTVISIT'		=> 'Zile de la ultima vizită',
++-	'AUTOGROUPS_TYPE_MEMBERSHIP'	=> 'Zilele de membru',
++-	'AUTOGROUPS_TYPE_POSTS'			=> 'Postări',
++-	'AUTOGROUPS_TYPE_WARNINGS'		=> 'Avertismente',
++-));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/language/ro/autogroups_common.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/language/ro/autogroups_common.php"
++deleted file mode 100644
++index 695d20bf2..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/language/ro/autogroups_common.php"
+++++ /dev/null
++@@ -1,45 +0,0 @@
++-<?php
++-/**
++-*
++-* Auto Groups extension for the phpBB Forum Software package.
++-* Romanian translation by iorG19 (https://ioforos.com)
++-*
++-* @copyright (c) 2014 phpBB Limited <https://www.phpbb.com>
++-* @license GNU General Public License, version 2 (GPL-2.0)
++-*
++-*/
++-
++-/**
++-* DO NOT CHANGE
++-*/
++-if (!defined('IN_PHPBB'))
++-{
++-	exit;
++-}
++-
++-if (empty($lang) || !is_array($lang))
++-{
++-	$lang = array();
++-}
++-
++-// DEVELOPERS PLEASE NOTE
++-//
++-// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
++-//
++-// Placeholders can now contain order information, e.g. instead of
++-// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
++-// translators to re-order the output of data while ensuring it remains correct
++-//
++-// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
++-// equally where a string contains only two placeholders which are used to wrap text
++-// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
++-//
++-// Some characters you may want to copy&paste:
++-// ’ » “ ” …
++-//
++-
++-$lang = array_merge($lang, array(
++-	// Notifications
++-	'AUTOGROUPS_NOTIFICATION_GROUP_ADDED'	=> '<strong>Actualizare de grup</strong>: Ați fost adăugat în grupul %1$s.',
++-	'AUTOGROUPS_NOTIFICATION_GROUP_REMOVED'	=> '<strong>Actualizare de grup</strong>: Ați fost exclus din grupul %1$s.',
++-));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/language/ro/autogroups_install.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/language/ro/autogroups_install.php"
++deleted file mode 100644
++index cb0546b5d..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/language/ro/autogroups_install.php"
+++++ /dev/null
++@@ -1,43 +0,0 @@
++-<?php
++-/**
++-*
++-* Auto Groups extension for the phpBB Forum Software package.
++-* Romanian translation by iorG19 (https://ioforos.com)
++-*
++-* @copyright (c) 2019 phpBB Limited <https://www.phpbb.com>
++-* @license GNU General Public License, version 2 (GPL-2.0)
++-*
++-*/
++-
++-/**
++-* DO NOT CHANGE
++-*/
++-if (!defined('IN_PHPBB'))
++-{
++-	exit;
++-}
++-
++-if (empty($lang) || !is_array($lang))
++-{
++-	$lang = array();
++-}
++-
++-// DEVELOPERS PLEASE NOTE
++-//
++-// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
++-//
++-// Placeholders can now contain order information, e.g. instead of
++-// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
++-// translators to re-order the output of data while ensuring it remains correct
++-//
++-// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
++-// equally where a string contains only two placeholders which are used to wrap text
++-// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
++-//
++-// Some characters you may want to copy&paste:
++-// ’ » “ ” …
++-//
++-
++-$lang = array_merge($lang, array(
++-	'AUTOGROUPS_NOT_ENABLEABLE'	=> 'Grupurile automate nu au putut fi activate. Cerințele minime ale phpBB 3.2.0 și/sau PHP 5.5.0 nu au fost îndeplinite.',
++-));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/language/ro/info_acp_autogroups.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/language/ro/info_acp_autogroups.php"
++deleted file mode 100644
++index e432e9f21..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/language/ro/info_acp_autogroups.php"
+++++ /dev/null
++@@ -1,48 +0,0 @@
++-<?php
++-/**
++-*
++-* Auto Groups extension for the phpBB Forum Software package.
++-* Romanian translation by iorG19 (https://ioforos.com)
++-*
++-* @copyright (c) 2014 phpBB Limited <https://www.phpbb.com>
++-* @license GNU General Public License, version 2 (GPL-2.0)
++-*
++-*/
++-
++-/**
++-* DO NOT CHANGE
++-*/
++-if (!defined('IN_PHPBB'))
++-{
++-	exit;
++-}
++-
++-if (empty($lang) || !is_array($lang))
++-{
++-	$lang = array();
++-}
++-
++-// DEVELOPERS PLEASE NOTE
++-//
++-// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
++-//
++-// Placeholders can now contain order information, e.g. instead of
++-// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
++-// translators to re-order the output of data while ensuring it remains correct
++-//
++-// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
++-// equally where a string contains only two placeholders which are used to wrap text
++-// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
++-//
++-// Some characters you may want to copy&paste:
++-// ’ » “ ” …
++-//
++-
++-$lang = array_merge($lang, array(
++-	'ACP_AUTOGROUPS_MANAGE'			=> 'Gestionați Grupurile Automate',
++-	'AUTOGROUPS_TYPE_NOT_EXIST'		=> 'Tipul Auto Group `%1$s` nu există.',
++-
++-	// Logs
++-	'ACP_AUTOGROUPS_SAVED_LOG'		=> '<strong>O configurație de Grup Automat a fost salvată</strong>',
++-	'ACP_AUTOGROUPS_DELETE_LOG'		=> '<strong>O configurație de Grup Automat a fost ștearsă</strong>',
++-));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/language/ru/autogroups_acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/language/ru/autogroups_acp.php"
++index 51b3bf9c3..98eaa4db8 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/language/ru/autogroups_acp.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/language/ru/autogroups_acp.php"
++@@ -70,7 +70,7 @@ $lang = array_merge($lang, array(
++ 	'ACP_AUTOGROUPS_DELETE_SUCCESS'	=> 'АвтоГруппа успешно удалена.',
++ 	'ACP_AUTOGROUPS_EMPTY'			=> 'Нет АвтоГрупп.',
++ 	'ACP_AUTOGROUPS_NO_GROUPS'		=> 'Нет доступных групп',
++-	'ACP_AUTOGROUPS_INVALID_GROUPS'	=> 'Произошла ошибка. Не выбрана действующая группа пользователей.<br>АвтоГруппы могут использоваться только с определенными группами пользователей, создать которые можно на странице управления группами.',
+++	'ACP_AUTOGROUPS_INVALID_GROUPS'	=> 'Произошла ошибка. Не выбрана действующая группа пользователей.<br />АвтоГруппы могут использоваться только с определенными группами пользователей, создать которые можно на странице управления группами.',
++ 	'ACP_AUTOGROUPS_INVALID_RANGE'	=> 'Произошла ошибка. Минимальное и максимальное значения не могут быть установлены на одно и то же значение.',
++ 
++ 	// Conditions
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/language/sk/autogroups_acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/language/sk/autogroups_acp.php"
++index d5796ee92..41b951e12 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/language/sk/autogroups_acp.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/language/sk/autogroups_acp.php"
++@@ -71,7 +71,7 @@ $lang = array_merge($lang, array(
++ 	'ACP_AUTOGROUPS_DELETE_SUCCESS'	=> 'Automatická skupina bola úspešne vymazaná.',
++ 	'ACP_AUTOGROUPS_EMPTY'			=> 'Nie sú zatiaľ žiadne automatické skupiny.',
++ 	'ACP_AUTOGROUPS_NO_GROUPS'		=> 'Nie sú dostupné žiadne skupiny',
++-	'ACP_AUTOGROUPS_INVALID_GROUPS'	=> 'Nastala chyba. Nebola vybraná správna používteľská skupina.<br>Automatické skupiny môžu byť použité iba s používateľskými skupinami, ktoré môžu byť vytvorené na stránke Spravovať skupiny.',
+++	'ACP_AUTOGROUPS_INVALID_GROUPS'	=> 'Nastala chyba. Nebola vybraná správna používteľská skupina.<br />Automatické skupiny môžu byť použité iba s používateľskými skupinami, ktoré môžu byť vytvorené na stránke Spravovať skupiny.',
++ 	'ACP_AUTOGROUPS_INVALID_RANGE'	=> 'Nastala chyba. Minimálna a maximálna hodnota nemôžu byť nastavené na rovnakú hodnotu.',
++ 
++ 	// Conditions
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/language/tr/autogroups_acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/language/tr/autogroups_acp.php"
++index df5193e02..c37b13912 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/language/tr/autogroups_acp.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/language/tr/autogroups_acp.php"
++@@ -70,7 +70,7 @@ $lang = array_merge($lang, array(
++ 	'ACP_AUTOGROUPS_DELETE_SUCCESS'	=> 'Otomatik Grup başarıyla silindi.',
++ 	'ACP_AUTOGROUPS_EMPTY'			=> 'Hiç Otomatik Grup yok.',
++ 	'ACP_AUTOGROUPS_NO_GROUPS'		=> 'Grup mevcut değil',
++-	'ACP_AUTOGROUPS_INVALID_GROUPS'	=> 'Bir hata oluştu. Geçerli bir kullanıcı grubu seçilmedi.<br>Otomatik Gruplar yalnızca Grup Yönetimi sayfasında oluşturulabilen kullanıcı tanımlı gruplarla kullanılabilir.',
+++	'ACP_AUTOGROUPS_INVALID_GROUPS'	=> 'Bir hata oluştu. Geçerli bir kullanıcı grubu seçilmedi.<br />Otomatik Gruplar yalnızca Grup Yönetimi sayfasında oluşturulabilen kullanıcı tanımlı gruplarla kullanılabilir.',
++ 	'ACP_AUTOGROUPS_INVALID_RANGE'	=> 'Bir hata oluştu. Minimum ve maksimum değerler aynı değer olarak ayarlanamaz.',
++ 
++ 	// Conditions
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/language/zh_cmn_hans/autogroups_acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/language/zh_cmn_hans/autogroups_acp.php"
++index bf540f53e..783cf9ac6 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\phpbb\\autogroups/language/zh_cmn_hans/autogroups_acp.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\autogroups/language/zh_cmn_hans/autogroups_acp.php"
++@@ -71,7 +71,7 @@ $lang = array_merge($lang, array(
++ 	'ACP_AUTOGROUPS_DELETE_SUCCESS'	=> '自动分组配置已删除。',
++ 	'ACP_AUTOGROUPS_EMPTY'			=> '没有任何的自动分组设置。',
++ 	'ACP_AUTOGROUPS_NO_GROUPS'		=> '无用户组可以选择',
++-	'ACP_AUTOGROUPS_INVALID_GROUPS'	=> '错误！无效用户组被选中。<br> 自动分组只能应用于用户定义的组，用户定义的组可以在用户组管理界面添加。',
+++	'ACP_AUTOGROUPS_INVALID_GROUPS'	=> '错误！无效用户组被选中。<b
\ No newline at end of file
diff --git "[ORIGINAL]/phpbb\\autogroups/ext.php" "[FORUM_EXT]/phpbb\\autogroups/ext.php"
--- "[ORIGINAL]/phpbb\\autogroups/ext.php"
+++ "[FORUM_EXT]/phpbb\\autogroups/ext.php"
@@ -59,7 +59,7 @@ class ext extends \phpbb\extension\base
 	 */
 	protected function check_php_version()
 	{
-		return PHP_VERSION_ID >= 50500;
+		return phpbb_version_compare(PHP_VERSION, '5.5.0', '>=');
 	}
 
 	/**
diff --git "[ORIGINAL]/phpbb\\autogroups/language/ar/autogroups_acp.php" "[FORUM_EXT]/phpbb\\autogroups/language/ar/autogroups_acp.php"
--- "[ORIGINAL]/phpbb\\autogroups/language/ar/autogroups_acp.php"
+++ "[FORUM_EXT]/phpbb\\autogroups/language/ar/autogroups_acp.php"
@@ -71,7 +71,7 @@ $lang = array_merge($lang, array(
 	'ACP_AUTOGROUPS_DELETE_SUCCESS'	=> 'تم حذف المجموعة التلقائية بنجاح.',
 	'ACP_AUTOGROUPS_EMPTY'			=> 'لا توجد مجموعات تلقائية.',
 	'ACP_AUTOGROUPS_NO_GROUPS'		=> 'لا توجد مجموعات',
-	'ACP_AUTOGROUPS_INVALID_GROUPS'	=> 'هناك خطأ. لم يتم تحديد مجموعة عضو.<br>يمكن استخدام المجموعات التلقائية فقط مع مجموعات العضو المعروفة , والتي يمكن انشائها بواسطة صفحة إدارة المجموعات.',
+	'ACP_AUTOGROUPS_INVALID_GROUPS'	=> 'هناك خطأ. لم يتم تحديد مجموعة عضو.<br />يمكن استخدام المجموعات التلقائية فقط مع مجموعات العضو المعروفة , والتي يمكن انشائها بواسطة صفحة إدارة المجموعات.',
 	'ACP_AUTOGROUPS_INVALID_RANGE'	=> 'هناك خطأ. لا تستطيع ضبط نفس القيمة في الحد الأعلى و الحد الأدني.',
 
 	// Conditions
diff --git "[ORIGINAL]/phpbb\\autogroups/language/cs/autogroups_acp.php" "[FORUM_EXT]/phpbb\\autogroups/language/cs/autogroups_acp.php"
--- "[ORIGINAL]/phpbb\\autogroups/language/cs/autogroups_acp.php"
+++ "[FORUM_EXT]/phpbb\\autogroups/language/cs/autogroups_acp.php"
@@ -70,7 +70,7 @@ $lang = array_merge($lang, array(
 	'ACP_AUTOGROUPS_DELETE_SUCCESS'	=> 'Auto skupina byla úspěšně odstraněna.',
 	'ACP_AUTOGROUPS_EMPTY'			=> 'Neexistují žádné auto skupiny.',
 	'ACP_AUTOGROUPS_NO_GROUPS'		=> 'K dispozici nejsou žádné skupiny',
-	'ACP_AUTOGROUPS_INVALID_GROUPS'	=> 'Vyskytla se chyba. Platná skupina uživatelů nebyla vybrána.<br>Auto Skupiny mohou být použity pouze s uživatelsky definovanými skupinami, které mohou být vytvořeny na straně správa skupin.',
+	'ACP_AUTOGROUPS_INVALID_GROUPS'	=> 'Vyskytla se chyba. Platná skupina uživatelů nebyla vybrána.<br />Auto Skupiny mohou být použity pouze s uživatelsky definovanými skupinami, které mohou být vytvořeny na straně správa skupin.',
 	'ACP_AUTOGROUPS_INVALID_RANGE'	=> 'Vyskytla se chyba. Minimální a maximální hodnoty nelze nastavit na stejnou hodnotu.',
 
 	// Conditions
diff --git "[ORIGINAL]/phpbb\\autogroups/language/da/autogroups_acp.php" "[FORUM_EXT]/phpbb\\autogroups/language/da/autogroups_acp.php"
--- "[ORIGINAL]/phpbb\\autogroups/language/da/autogroups_acp.php"
+++ "[FORUM_EXT]/phpbb\\autogroups/language/da/autogroups_acp.php"
@@ -70,7 +70,7 @@ $lang = array_merge($lang, array(
 	'ACP_AUTOGROUPS_DELETE_SUCCESS'	=> 'Autogruppe slettet.',
 	'ACP_AUTOGROUPS_EMPTY'			=> 'Der er ingen autogrupper.',
 	'ACP_AUTOGROUPS_NO_GROUPS'		=> 'Ingen grupper tilgængelig',
-	'ACP_AUTOGROUPS_INVALID_GROUPS'	=> 'Der opstod en fejl. Der var ikke valgt nogen gyldig brugergruppe.<br>Autogrupper kan kun bruges med brugerdefinerede grupper, som kan oprettes på Håndter grupper-siden.',
+	'ACP_AUTOGROUPS_INVALID_GROUPS'	=> 'Der opstod en fejl. Der var ikke valgt nogen gyldig brugergruppe.<br />Autogrupper kan kun bruges med brugerdefinerede grupper, som kan oprettes på Håndter grupper-siden.',
 	'ACP_AUTOGROUPS_INVALID_RANGE'	=> 'Der opstod en fejl. Minimums- og maksimumsværdier kan ikke sættes til den samme værdi.',
 
 	// Conditions
diff --git "[ORIGINAL]/phpbb\\autogroups/language/de/autogroups_acp.php" "[FORUM_EXT]/phpbb\\autogroups/language/de/autogroups_acp.php"
--- "[ORIGINAL]/phpbb\\autogroups/language/de/autogroups_acp.php"
+++ "[FORUM_EXT]/phpbb\\autogroups/language/de/autogroups_acp.php"
@@ -70,7 +70,7 @@ $lang = array_merge($lang, array(
 	'ACP_AUTOGROUPS_DELETE_SUCCESS'	=> 'Auto-Gruppe erfolgreich gelöscht.',
 	'ACP_AUTOGROUPS_EMPTY'			=> 'Es gibt keine Auto-Gruppen.',
 	'ACP_AUTOGROUPS_NO_GROUPS'		=> 'Keine Gruppen vorhanden',
-	'ACP_AUTOGROUPS_INVALID_GROUPS'	=> 'Ein Fehler ist aufgetreten. Es wurde keine gültige Gruppe ausgewählt.<br>Auto Groups kann nur mit benutzerdefinierten Gruppen verwendet werden, welche über die Gruppenverwaltung erstellt werden können.',
+	'ACP_AUTOGROUPS_INVALID_GROUPS'	=> 'Ein Fehler ist aufgetreten. Es wurde keine gültige Gruppe ausgewählt.<br />Auto Groups kann nur mit benutzerdefinierten Gruppen verwendet werden, welche über die Gruppenverwaltung erstellt werden können.',
 	'ACP_AUTOGROUPS_INVALID_RANGE'	=> 'Ein Fehler ist aufgetreten. Minimal- und Maximalwerte können nicht auf den gleichen Wert eingestellt werden.',
 
 	// Conditions
diff --git "[ORIGINAL]/phpbb\\autogroups/language/en/autogroups_acp.php" "[FORUM_EXT]/phpbb\\autogroups/language/en/autogroups_acp.php"
--- "[ORIGINAL]/phpbb\\autogroups/language/en/autogroups_acp.php"
+++ "[FORUM_EXT]/phpbb\\autogroups/language/en/autogroups_acp.php"
@@ -70,7 +70,7 @@ $lang = array_merge($lang, array(
 	'ACP_AUTOGROUPS_DELETE_SUCCESS'	=> 'Auto Group successfully deleted.',
 	'ACP_AUTOGROUPS_EMPTY'			=> 'There are no auto groups.',
 	'ACP_AUTOGROUPS_NO_GROUPS'		=> 'No groups available',
-	'ACP_AUTOGROUPS_INVALID_GROUPS'	=> 'An error occurred. A valid user group was not selected.<br>Auto Groups can only be used with user defined groups, which can be created on the Manage groups page.',
+	'ACP_AUTOGROUPS_INVALID_GROUPS'	=> 'An error occurred. A valid user group was not selected.<br />Auto Groups can only be used with user defined groups, which can be created on the Manage groups page.',
 	'ACP_AUTOGROUPS_INVALID_RANGE'	=> 'An error occurred. Minimum and maximum values can not be set to the same value.',
 
 	// Conditions
diff --git "[ORIGINAL]/phpbb\\autogroups/language/es/autogroups_acp.php" "[FORUM_EXT]/phpbb\\autogroups/language/es/autogroups_acp.php"
--- "[ORIGINAL]/phpbb\\autogroups/language/es/autogroups_acp.php"
+++ "[FORUM_EXT]/phpbb\\autogroups/language/es/autogroups_acp.php"
@@ -71,7 +71,7 @@ $lang = array_merge($lang, array(
 	'ACP_AUTOGROUPS_DELETE_SUCCESS'	=> 'Auto Grupo borrado correctamente.',
 	'ACP_AUTOGROUPS_EMPTY'			=> 'No hay Auto Grupos.',
 	'ACP_AUTOGROUPS_NO_GROUPS'		=> 'No hay grupos disponibles',
-	'ACP_AUTOGROUPS_INVALID_GROUPS'	=> 'Ocurrio un error. Un grupo de usuario válido no fue seleccionado.<br>Auto Grupos sólo se puede utilizar con los grupos definidos por el usuario, estos se pueden crear en la página Administrar grupos.',
+	'ACP_AUTOGROUPS_INVALID_GROUPS'	=> 'Ocurrio un error. Un grupo de usuario válido no fue seleccionado.<br />Auto Grupos sólo se puede utilizar con los grupos definidos por el usuario, estos se pueden crear en la página Administrar grupos.',
 	'ACP_AUTOGROUPS_INVALID_RANGE'	=> 'Ocurrio un error. Los valores mínimos y máximos no se pueden establecer con el mismo valor.',
 
 	// Conditions
diff --git "[ORIGINAL]/phpbb\\autogroups/language/et/autogroups_acp.php" "[FORUM_EXT]/phpbb\\autogroups/language/et/autogroups_acp.php"
--- "[ORIGINAL]/phpbb\\autogroups/language/et/autogroups_acp.php"
+++ "[FORUM_EXT]/phpbb\\autogroups/language/et/autogroups_acp.php"
@@ -71,7 +71,7 @@ $lang = array_merge($lang, array(
 	'ACP_AUTOGROUPS_DELETE_SUCCESS'	=> 'Automaatne grupp on edukalt kustutatud.',
 	'ACP_AUTOGROUPS_EMPTY'			=> 'Ühtegi automaatset gruppi ei ole.',
 	'ACP_AUTOGROUPS_NO_GROUPS'		=> 'Ühtegi gruppi ei ole saadaval.',
-	'ACP_AUTOGROUPS_INVALID_GROUPS'	=> 'Tekkis viga. Kehtivat kasutajagruppi ei ole valitud.<br>Automaatseid gruppe saab kasutada ainult siis, kui liikmele on määratud grupid, mida saab luua grupide halduse leheküljel.',
+	'ACP_AUTOGROUPS_INVALID_GROUPS'	=> 'Tekkis viga. Kehtivat kasutajagruppi ei ole valitud.<br />Automaatseid gruppe saab kasutada ainult siis, kui liikmele on määratud grupid, mida saab luua grupide halduse leheküljel.',
 	'ACP_AUTOGROUPS_INVALID_RANGE'	=> 'Tekkis viga. Minimaalset ja maksimaalset väärtust ei saa seadistada samade väärtustega.',
 
 	// Conditions
diff --git "[ORIGINAL]/phpbb\\autogroups/language/fr/autogroups_acp.php" "[FORUM_EXT]/phpbb\\autogroups/language/fr/autogroups_acp.php"
--- "[ORIGINAL]/phpbb\\autogroups/language/fr/autogroups_acp.php"
+++ "[FORUM_EXT]/phpbb\\autogroups/language/fr/autogroups_acp.php"
@@ -71,7 +71,7 @@ $lang = array_merge($lang, array(
 	'ACP_AUTOGROUPS_DELETE_SUCCESS'	=> 'Le groupe automatique a été supprimé avec succès.',
 	'ACP_AUTOGROUPS_EMPTY'			=> 'Il n’y a aucun groupe automatique.',
 	'ACP_AUTOGROUPS_NO_GROUPS'		=> 'Aucun groupe disponible',
-	'ACP_AUTOGROUPS_INVALID_GROUPS'	=> 'Une erreur est survenue. Aucun groupe d’utilisateur valide n’a été sélectionné.<br>L’extension Auto Groups fonctionne uniquement avec des groupes d’utilisateurs définis, pouvant être créés depuis la page « Gérer les groupes ».',
+	'ACP_AUTOGROUPS_INVALID_GROUPS'	=> 'Une erreur est survenue. Aucun groupe d’utilisateur valide n’a été sélectionné.<br />L’extension Auto Groups fonctionne uniquement avec des groupes d’utilisateurs définis, pouvant être créés depuis la page « Gérer les groupes ».',
 	'ACP_AUTOGROUPS_INVALID_RANGE'	=> 'Une erreur est survenue. La valeur minimale et la valeur maximale ne peuvent être identiques.',
 
 	// Conditions
diff --git "[ORIGINAL]/phpbb\\autogroups/language/hr/autogroups_acp.php" "[FORUM_EXT]/phpbb\\autogroups/language/hr/autogroups_acp.php"
--- "[ORIGINAL]/phpbb\\autogroups/language/hr/autogroups_acp.php"
+++ "[FORUM_EXT]/phpbb\\autogroups/language/hr/autogroups_acp.php"
@@ -71,7 +71,7 @@ $lang = array_merge($lang, array(
 	'ACP_AUTOGROUPS_DELETE_SUCCESS'	=> 'Automatsko upravljanje izabranom grupom je izbrisano.',
 	'ACP_AUTOGROUPS_EMPTY'			=> 'There are no auto groups.',
 	'ACP_AUTOGROUPS_NO_GROUPS'		=> 'Nema dostupnih grupa',
-	'ACP_AUTOGROUPS_INVALID_GROUPS'	=> 'Došlo je do greške: nije izabrana niti jedna grupa.<br>Automatsko upravljanje grupom/ama može se primijeniti samo na korisnički dodane grupe.',
+	'ACP_AUTOGROUPS_INVALID_GROUPS'	=> 'Došlo je do greške: nije izabrana niti jedna grupa.<br />Automatsko upravljanje grupom/ama može se primijeniti samo na korisnički dodane grupe.',
 	'ACP_AUTOGROUPS_INVALID_RANGE'	=> 'Došlo je do greške: minimalna i maksimalna vrijednost ne mogu biti postavljene na istu vrijednost.',
 
 	// Conditions
diff --git "[ORIGINAL]/phpbb\\autogroups/language/hr_x_vi/autogroups_acp.php" "[FORUM_EXT]/phpbb\\autogroups/language/hr_x_vi/autogroups_acp.php"
--- "[ORIGINAL]/phpbb\\autogroups/language/hr_x_vi/autogroups_acp.php"
+++ "[FORUM_EXT]/phpbb\\autogroups/language/hr_x_vi/autogroups_acp.php"
@@ -71,7 +71,7 @@ $lang = array_merge($lang, array(
 	'ACP_AUTOGROUPS_DELETE_SUCCESS'	=> 'Automatsko upravljanje izabranom grupom je izbrisano.',
 	'ACP_AUTOGROUPS_EMPTY'			=> 'There are no auto groups.',
 	'ACP_AUTOGROUPS_NO_GROUPS'		=> 'Nema dostupnih grupa',
-	'ACP_AUTOGROUPS_INVALID_GROUPS'	=> 'Došlo je do greške: nije izabrana niti jedna grupa.<br>Automatsko upravljanje grupom/ama može se primijeniti samo na korisnički dodane grupe.',
+	'ACP_AUTOGROUPS_INVALID_GROUPS'	=> 'Došlo je do greške: nije izabrana niti jedna grupa.<br />Automatsko upravljanje grupom/ama može se primijeniti samo na korisnički dodane grupe.',
 	'ACP_AUTOGROUPS_INVALID_RANGE'	=> 'Došlo je do greške: minimalna i maksimalna vrijednost ne mogu biti postavljene na istu vrijednost.',
 
 	// Conditions
diff --git "[ORIGINAL]/phpbb\\autogroups/language/it/autogroups_acp.php" "[FORUM_EXT]/phpbb\\autogroups/language/it/autogroups_acp.php"
--- "[ORIGINAL]/phpbb\\autogroups/language/it/autogroups_acp.php"
+++ "[FORUM_EXT]/phpbb\\autogroups/language/it/autogroups_acp.php"
@@ -70,7 +70,7 @@ $lang = array_merge($lang, array(
 	'ACP_AUTOGROUPS_DELETE_SUCCESS'	=> 'Autogruppo rimosso correttamente.',
 	'ACP_AUTOGROUPS_EMPTY'			=> 'Non ci sono autogruppi.',
 	'ACP_AUTOGROUPS_NO_GROUPS'		=> 'Non ci sono gruppi a disposizione',
-	'ACP_AUTOGROUPS_INVALID_GROUPS'	=> 'Si è verificato un errore: non è stato selezionato un gruppo utente valido.<br>Autogruppi può essere usato solo con gruppi utenti, creabili nella pagina Gestisci gruppi.',
+	'ACP_AUTOGROUPS_INVALID_GROUPS'	=> 'Si è verificato un errore: non è stato selezionato un gruppo utente valido.<br />Autogruppi può essere usato solo con gruppi utenti, creabili nella pagina Gestisci gruppi.',
 	'ACP_AUTOGROUPS_INVALID_RANGE'	=> 'Si è verificato un errore: il valore minimo e il valore massimo non possono coincidere.',
 
 	// Conditions
diff --git "[ORIGINAL]/phpbb\\autogroups/language/nl/autogroups_acp.php" "[FORUM_EXT]/phpbb\\autogroups/language/nl/autogroups_acp.php"
--- "[ORIGINAL]/phpbb\\autogroups/language/nl/autogroups_acp.php"
+++ "[FORUM_EXT]/phpbb\\autogroups/language/nl/autogroups_acp.php"
@@ -39,45 +39,45 @@ if (empty($lang) || !is_array($lang))
 //
 
 $lang = array_merge($lang, array(
-	'ACP_AUTOGROUPS_MANAGE'			=> 'Beheer Auto Groepen',
-	'ACP_AUTOGROUPS_MANAGE_EXPLAIN'	=> 'Met dit formulier kun je Auto Groepconfiguraties toevoegen, bewerken, bekijken en verwijderen.',
-	'ACP_AUTOGROUPS_ADD'			=> 'Voeg Auto Groepen toe',
-	'ACP_AUTOGROUPS_EDIT'			=> 'Bewerk Auto Groepen',
+	'ACP_AUTOGROUPS_MANAGE'			=> 'Beheer Automatische Groepen',
+	'ACP_AUTOGROUPS_MANAGE_EXPLAIN'	=> 'Hier kun je automatische groepen aanmaken, bewerken, weergeven en verwijderen.',
+	'ACP_AUTOGROUPS_ADD'			=> 'Voeg automatische groep toe',
+	'ACP_AUTOGROUPS_EDIT'			=> 'Bewerk automatische groep',
 
 	'ACP_AUTOGROUPS_GROUP_NAME'				=> 'Groep',
-	'ACP_AUTOGROUPS_GROUP_NAME_EXPLAIN'		=> 'Kies een groep waaraan gebruikers automatisch worden toegevoegd of verwijderd.',
-	'ACP_AUTOGROUPS_CONDITION_NAME'			=> 'Auto Groep type',
-	'ACP_AUTOGROUPS_CONDITION_NAME_EXPLAIN'	=> 'Kies het type voorwaarde waarop gebruikers aan deze groep worden toegevoegd of verwijderd.',
+	'ACP_AUTOGROUPS_GROUP_NAME_EXPLAIN'		=> 'Kies een groep waaraan gebruikers automatisch toegevoegd of verwijderd moeten worden.',
+	'ACP_AUTOGROUPS_CONDITION_NAME'			=> 'Type automatische groep',
+	'ACP_AUTOGROUPS_CONDITION_NAME_EXPLAIN'	=> 'Kies het type conditie waarop gebruikers toegevoegd of verwijderd worden aan deze groep.',
 	'ACP_AUTOGROUPS_MIN_VALUE'				=> 'Minimale waarde',
-	'ACP_AUTOGROUPS_MIN_VALUE_EXPLAIN'		=> 'Gebruikers worden aan deze groep toegevoegd als ze de minimale waarde bereiken of overschrijden.',
+	'ACP_AUTOGROUPS_MIN_VALUE_EXPLAIN'		=> 'Gebruikers worden toegevoegd aan deze groep als de minimale waarde wordt overschreden.',
 	'ACP_AUTOGROUPS_MAX_VALUE'				=> 'Maximale waarde',
-	'ACP_AUTOGROUPS_MAX_VALUE_EXPLAIN'		=> 'Gebruikers worden uit deze groep verwijderd als ze de maximale waarde bereiken of overschrijden. Zet dit op 0 als je niet wilt dat gebruikers worden verwijderd.',
-	'ACP_AUTOGROUPS_DEFAULT'				=> 'Stel standaardgroep in',
-	'ACP_AUTOGROUPS_DEFAULT_EXPLAIN'		=> 'Maak dit de nieuwe standaardgroep van de gebruiker.',
-	'ACP_AUTOGROUPS_DEFAULT_EXEMPTION'		=> 'Dit heeft geen effect op gebruikers waarvan de standaardgroep een van de volgende is: %s.',
-	'ACP_AUTOGROUPS_NOTIFY'					=> 'Meld gebruikers',
-	'ACP_AUTOGROUPS_NOTIFY_EXPLAIN'			=> 'Stuur een melding naar gebruikers nadat ze automatisch aan deze groep zijn toegevoegd of verwijderd.',
+	'ACP_AUTOGROUPS_MAX_VALUE_EXPLAIN'		=> 'Gebruikers worden verwijderd van deze groep als de maximale waarde wordt overschreden. Laat dit veld leeg om automatisch verwijderen te voorkomen.',
+	'ACP_AUTOGROUPS_DEFAULT'				=> 'Instellen als standaard groep',
+	'ACP_AUTOGROUPS_DEFAULT_EXPLAIN'		=> 'Maak voor deze gebruikers de groep standaard.',
+	'ACP_AUTOGROUPS_DEFAULT_EXEMPTION'		=> 'Dit heeft geen invloed op gebruikers wiens standaardgroep één van de volgende is: %s.',
+	'ACP_AUTOGROUPS_NOTIFY'					=> 'Notificeer gebruikers',
+	'ACP_AUTOGROUPS_NOTIFY_EXPLAIN'			=> 'Stuur een notificatie naar gebruikers als ze automatisch worden toegevoegd of verwijderd van deze groep.',
 
-	'ACP_AUTOGROUPS_EXCLUDED_GROUPS'		=> 'Uitsluitgroepen',
-	'ACP_AUTOGROUPS_EXCLUDE_GROUP'			=> 'Negeer leden van deze groepen',
-	'ACP_AUTOGROUPS_EXCLUDE_GROUP_EXPLAIN'	=> 'Leden die tot <em>om het even welke groep</em> in deze lijst behoren, worden genegeerd. Laat dit veld leeg als je deze Auto Groep op <em>alle leden</em> van je forum wilt toepassen. Selecteer meerdere groepen door <samp>CTRL</samp> (of <samp>&#8984;CMD</samp> op Mac) in te houden en de groepen te selecteren.',
-	'ACP_AUTOGROUPS_INVALID_EXCLUDE_GROUPS'	=> 'Er is een fout opgetreden. De groep voor deze voorwaarde kan niet ook in het veld "uitgesloten groepen" worden geselecteerd.',
-	'ACP_AUTOGROUPS_EXEMPT_GROUP'			=> 'Stel standaardgroep uitzonderingen in',
-	'ACP_AUTOGROUPS_EXEMPT_GROUP_EXPLAIN'	=> 'Auto Groepen zullen de <em>standaardgroep</em> van een gebruiker niet veranderen als deze in deze lijst is geselecteerd. Selecteer meerdere groepen door <samp>CTRL</samp> (of <samp>&#8984;CMD</samp> op Mac) in te houden en de groepen te selecteren.',
+	'ACP_AUTOGROUPS_EXCLUDED_GROUPS'		=> 'Excluded groups',
+	'ACP_AUTOGROUPS_EXCLUDE_GROUP'			=> 'Exclude members of these groups',
+	'ACP_AUTOGROUPS_EXCLUDE_GROUP_EXPLAIN'	=> 'Members belonging to <em>any group</em> selected in this list will be ignored. Leave this field blank if you want this Auto Group applied to <em>all members</em> of your board. Select multiple groups by holding <samp>CTRL</samp> (or <samp>&#8984;CMD</samp> on Mac) and selecting the groups.',
+	'ACP_AUTOGROUPS_INVALID_EXCLUDE_GROUPS'	=> 'An error occurred. The group for this condition can not also be selected in the excluded groups field.',
+	'ACP_AUTOGROUPS_EXEMPT_GROUP'			=> 'Instellen standaard groep uitzonderingen',
+	'ACP_AUTOGROUPS_EXEMPT_GROUP_EXPLAIN'	=> 'Automatische groepen zal niet een gebruiker zijn standaard groep veranderen als deze groep geselecteerd is in deze lijst. Selecteer meerdere groepen door <samp>CTRL</samp> (of <samp>&#8984;CMD</samp> op Mac) ingedrukt te houden en de groepen te selecteren.',
 
-	'ACP_AUTOGROUPS_CREATE_RULE'	=> 'Maak nieuwe Auto Groep aan',
-	'ACP_AUTOGROUPS_SUBMIT_SUCCESS'	=> 'Auto Groep succesvol geconfigureerd.',
-	'ACP_AUTOGROUPS_DELETE_CONFIRM'	=> 'Weet je zeker dat je deze Auto Groepconfiguratie wilt verwijderen?',
-	'ACP_AUTOGROUPS_DELETE_SUCCESS'	=> 'Auto Groep succesvol verwijderd.',
-	'ACP_AUTOGROUPS_EMPTY'			=> 'Er zijn geen auto groepen.',
+	'ACP_AUTOGROUPS_CREATE_RULE'	=> 'Maak nieuwe automatische groep',
+	'ACP_AUTOGROUPS_SUBMIT_SUCCESS'	=> 'Automatische groep succesvol geconfigureerd',
+	'ACP_AUTOGROUPS_DELETE_CONFIRM'	=> 'Weet je zeker dat je deze automatische groep wilt verwijderen?',
+	'ACP_AUTOGROUPS_DELETE_SUCCESS'	=> 'Automatische groep succesvol verwijderd.',
+	'ACP_AUTOGROUPS_EMPTY'			=> 'Er zijn geen automatische groepen.',
 	'ACP_AUTOGROUPS_NO_GROUPS'		=> 'Geen groepen beschikbaar',
-	'ACP_AUTOGROUPS_INVALID_GROUPS'	=> 'Er is een fout opgetreden. Er is geen geldige gebruikersgroep geselecteerd.<br />Auto Groepen kunnen alleen worden gebruikt met door gebruikers gedefinieerde groepen, die aangemaakt kunnen worden op de pagina "Groepen beheren".',
-	'ACP_AUTOGROUPS_INVALID_RANGE'	=> 'Er is een fout opgetreden. Minimale en maximale waarden kunnen niet op dezelfde waarde worden ingesteld.',
+	'ACP_AUTOGROUPS_INVALID_GROUPS'	=> 'Er is een fout opgetreden. Er is geen geldige groep geselecteerd.<br />Automatische groepen kan alleen worden gebruikt bij door de beheerder aangemaakte groepen, welke kan worden aangemaakt op de “Beheer groepen pagina”.',
+	'ACP_AUTOGROUPS_INVALID_RANGE'	=> 'Er is een fout opgetreden. De minimale en maximale waarde kunnen niet hetzelfde zijn.',
 
 	// Conditions
-	'AUTOGROUPS_TYPE_BIRTHDAYS'		=> 'Gebruikersleeftijd',
+	'AUTOGROUPS_TYPE_BIRTHDAYS'		=> 'Leeftijd',
 	'AUTOGROUPS_TYPE_LASTVISIT'		=> 'Dagen sinds laatste bezoek',
-	'AUTOGROUPS_TYPE_MEMBERSHIP'	=> 'Lidmaatschapsdagen',
+	'AUTOGROUPS_TYPE_MEMBERSHIP'	=> 'Aantal dagen lid',
 	'AUTOGROUPS_TYPE_POSTS'			=> 'Berichten',
 	'AUTOGROUPS_TYPE_WARNINGS'		=> 'Waarschuwingen',
 ));
diff --git "[ORIGINAL]/phpbb\\autogroups/language/nl/autogroups_common.php" "[FORUM_EXT]/phpbb\\autogroups/language/nl/autogroups_common.php"
--- "[ORIGINAL]/phpbb\\autogroups/language/nl/autogroups_common.php"
+++ "[FORUM_EXT]/phpbb\\autogroups/language/nl/autogroups_common.php"
@@ -39,7 +39,7 @@ if (empty($lang) || !is_array($lang))
 //
 
 $lang = array_merge($lang, array(
-	// Meldingen
-	'AUTOGROUPS_NOTIFICATION_GROUP_ADDED'	=> '<strong>Groepupdate</strong>: Je bent toegevoegd aan de groep %1$s.',
-	'AUTOGROUPS_NOTIFICATION_GROUP_REMOVED'	=> '<strong>Groepupdate</strong>: Je bent verwijderd uit de groep %1$s.',
+	// Notifications
+	'AUTOGROUPS_NOTIFICATION_GROUP_ADDED'	=> '<strong>Groepen bijgewerkt</strong>: Je bent toegevoegd aan de groep %1$s.',
+	'AUTOGROUPS_NOTIFICATION_GROUP_REMOVED'	=> '<strong>Groepen bijgewerkt</strong>: Je bent verwijderd van de groep %1$s.',
 ));
diff --git "[ORIGINAL]/phpbb\\autogroups/language/nl/autogroups_install.php" "[ORIGINAL]/phpbb\\autogroups/language/nl/autogroups_install.php"
deleted file mode 100644
--- "[ORIGINAL]/phpbb\\autogroups/language/nl/autogroups_install.php"
+++ /dev/null
@@ -1,42 +0,0 @@
-<?php
-/**
-*
-* Auto Groups extension for the phpBB Forum Software package.
-*
-* @copyright (c) 2019 phpBB Limited <https://www.phpbb.com>
-* @license GNU General Public License, version 2 (GPL-2.0)
-*
-*/
-
-/**
-* DO NOT CHANGE
-*/
-if (!defined('IN_PHPBB'))
-{
-	exit;
-}
-
-if (empty($lang) || !is_array($lang))
-{
-	$lang = array();
-}
-
-// DEVELOPERS PLEASE NOTE
-//
-// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
-//
-// Placeholders can now contain order information, e.g. instead of
-// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
-// translators to re-order the output of data while ensuring it remains correct
-//
-// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
-// equally where a string contains only two placeholders which are used to wrap text
-// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
-//
-// Some characters you may want to copy&paste:
-// ’ » “ ” …
-//
-
-$lang = array_merge($lang, array(
-	'AUTOGROUPS_NOT_ENABLEABLE'	=> 'Auto Groepen konden niet worden ingeschakeld. De minimale vereisten van phpBB 3.2.0 en/of PHP 5.5.0 zijn niet voldaan.',
-));
diff --git "[ORIGINAL]/phpbb\\autogroups/language/nl/info_acp_autogroups.php" "[FORUM_EXT]/phpbb\\autogroups/language/nl/info_acp_autogroups.php"
--- "[ORIGINAL]/phpbb\\autogroups/language/nl/info_acp_autogroups.php"
+++ "[FORUM_EXT]/phpbb\\autogroups/language/nl/info_acp_autogroups.php"
@@ -39,10 +39,10 @@ if (empty($lang) || !is_array($lang))
 //
 
 $lang = array_merge($lang, array(
-	'ACP_AUTOGROUPS_MANAGE'			=> 'Beheer Auto Groepen',
-	'AUTOGROUPS_TYPE_NOT_EXIST'		=> 'Het Auto Groep type `%1$s` bestaat niet.',
+	'ACP_AUTOGROUPS_MANAGE'			=> 'Beheer automatische groepen',
+	'AUTOGROUPS_TYPE_NOT_EXIST'		=> 'Automatische groep type `%1$s` bestaat niet.',
 
 	// Logs
-	'ACP_AUTOGROUPS_SAVED_LOG'		=> '<strong>Een Auto Groep configuratie is opgeslagen</strong>',
-	'ACP_AUTOGROUPS_DELETE_LOG'		=> '<strong>Een Auto Groep configuratie is verwijderd</strong>',
+	'ACP_AUTOGROUPS_SAVED_LOG'		=> '<strong>Een automatische groep configuratie is opgeslagen.</strong>',
+	'ACP_AUTOGROUPS_DELETE_LOG'		=> '<strong>Een automatische groep configuratie is verwijderd.</strong>',
 ));
diff --git "[ORIGINAL]/phpbb\\autogroups/language/pl/autogroups_acp.php" "[FORUM_EXT]/phpbb\\autogroups/language/pl/autogroups_acp.php"
--- "[ORIGINAL]/phpbb\\autogroups/language/pl/autogroups_acp.php"
+++ "[FORUM_EXT]/phpbb\\autogroups/language/pl/autogroups_acp.php"
@@ -71,7 +71,7 @@ $lang = array_merge($lang, array(
 	'ACP_AUTOGROUPS_DELETE_SUCCESS'	=> 'Usunięto automatyczną grupę.',
 	'ACP_AUTOGROUPS_EMPTY'			=> 'Brak automatycznych grup.',
 	'ACP_AUTOGROUPS_NO_GROUPS'		=> 'Brak grup',
-	'ACP_AUTOGROUPS_INVALID_GROUPS'	=> 'Nie wybrano żadnej grupy.<br><br>Automatyczne grupy muszą być połączone z istniejącymi grupami, które można utworzyć na stronie zarządzania grupami.',
+	'ACP_AUTOGROUPS_INVALID_GROUPS'	=> 'Nie wybrano żadnej grupy.<br /><br />Automatyczne grupy muszą być połączone z istniejącymi grupami, które można utworzyć na stronie zarządzania grupami.',
 	'ACP_AUTOGROUPS_INVALID_RANGE'	=> 'Minimalna i maksymalna wartość nie może być taka sama.',
 
 	// Conditions
diff --git "[ORIGINAL]/phpbb\\autogroups/language/pt/autogroups_acp.php" "[FORUM_EXT]/phpbb\\autogroups/language/pt/autogroups_acp.php"
--- "[ORIGINAL]/phpbb\\autogroups/language/pt/autogroups_acp.php"
+++ "[FORUM_EXT]/phpbb\\autogroups/language/pt/autogroups_acp.php"
@@ -70,7 +70,7 @@ $lang = array_merge($lang, array(
 	'ACP_AUTOGROUPS_DELETE_SUCCESS'	=> 'Autogrupo excluído com sucesso.',
 	'ACP_AUTOGROUPS_EMPTY'			=> 'Não existem Autogrupos.',
 	'ACP_AUTOGROUPS_NO_GROUPS'		=> 'Não existem grupos disponíveis',
-	'ACP_AUTOGROUPS_INVALID_GROUPS'	=> 'Um erro ocorreu. Um grupo de usuários válido não estava selecionado. <br> Autogrupos somente pode ser usado com grupos definidos de usuários, que podem ser criados em na página "Gerenciar grupos".',
+	'ACP_AUTOGROUPS_INVALID_GROUPS'	=> 'Um erro ocorreu. Um grupo de usuários válido não estava selecionado. <br /> Autogrupos somente pode ser usado com grupos definidos de usuários, que podem ser criados em na página "Gerenciar grupos".',
 	'ACP_AUTOGROUPS_INVALID_RANGE'	=> 'Um erro ocorreu. Os valores mínimos e máximos não podem ser configurados para o mesmo valor.',
 
 	// Conditions
diff --git "[ORIGINAL]/phpbb\\autogroups/language/pt_br/autogroups_acp.php" "[FORUM_EXT]/phpbb\\autogroups/language/pt_br/autogroups_acp.php"
--- "[ORIGINAL]/phpbb\\autogroups/language/pt_br/autogroups_acp.php"
+++ "[FORUM_EXT]/phpbb\\autogroups/language/pt_br/autogroups_acp.php"
@@ -71,7 +71,7 @@ $lang = array_merge($lang, array(
 	'ACP_AUTOGROUPS_DELETE_SUCCESS'	=> 'Autogrupo excluído com sucesso.',
 	'ACP_AUTOGROUPS_EMPTY'			=> 'Não existem Autogrupos.',
 	'ACP_AUTOGROUPS_NO_GROUPS'		=> 'Não existem grupos disponíveis',
-	'ACP_AUTOGROUPS_INVALID_GROUPS'	=> 'Um erro ocorreu. Um grupo de usuários válido não estava selecionado. <br> Autogrupos somente pode ser usado com grupos definidos de usuários, que podem ser criados em na página "Gerenciar grupos".',
+	'ACP_AUTOGROUPS_INVALID_GROUPS'	=> 'Um erro ocorreu. Um grupo de usuários válido não estava selecionado. <br /> Autogrupos somente pode ser usado com grupos definidos de usuários, que podem ser criados em na página "Gerenciar grupos".',
 	'ACP_AUTOGROUPS_INVALID_RANGE'	=> 'Um erro ocorreu. Os valores mínimos e máximos não podem ser configurados para o mesmo valor.',
 
 	// Conditions
diff --git "[ORIGINAL]/phpbb\\autogroups/language/ro/autogroups_acp.php" "[ORIGINAL]/phpbb\\autogroups/language/ro/autogroups_acp.php"
deleted file mode 100644
--- "[ORIGINAL]/phpbb\\autogroups/language/ro/autogroups_acp.php"
+++ /dev/null
@@ -1,83 +0,0 @@
-<?php
-/**
-*
-* Auto Groups extension for the phpBB Forum Software package.
-* Romanian translation by iorG19 (https://ioforos.com)
-*
-* @copyright (c) 2014 phpBB Limited <https://www.phpbb.com>
-* @license GNU General Public License, version 2 (GPL-2.0)
-*
-*/
-
-/**
-* DO NOT CHANGE
-*/
-if (!defined('IN_PHPBB'))
-{
-	exit;
-}
-
-if (empty($lang) || !is_array($lang))
-{
-	$lang = array();
-}
-
-// DEVELOPERS PLEASE NOTE
-//
-// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
-//
-// Placeholders can now contain order information, e.g. instead of
-// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
-// translators to re-order the output of data while ensuring it remains correct
-//
-// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
-// equally where a string contains only two placeholders which are used to wrap text
-// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
-//
-// Some characters you may want to copy&paste:
-// ’ » “ ” …
-//
-
-$lang = array_merge($lang, array(
-	'ACP_AUTOGROUPS_MANAGE'			=> 'Gestionați Grupurile Automate',
-	'ACP_AUTOGROUPS_MANAGE_EXPLAIN'	=> 'Folosind acest formular puteți adăuga, edita, vizualiza și șterge configurațiile Auto Group.',
-	'ACP_AUTOGROUPS_ADD'			=> 'Adăugați grupuri automate',
-	'ACP_AUTOGROUPS_EDIT'			=> 'Editați grupurile automate',
-
-	'ACP_AUTOGROUPS_GROUP_NAME'				=> 'Grup',
-	'ACP_AUTOGROUPS_GROUP_NAME_EXPLAIN'		=> 'Alegeți un grup din care să adăugați/eliminați automat utilizatori.',
-	'ACP_AUTOGROUPS_CONDITION_NAME'			=> 'Tip de grup automat',
-	'ACP_AUTOGROUPS_CONDITION_NAME_EXPLAIN'	=> 'Alegeți tipul de condiție în care utilizatorii vor fi adăugați sau eliminați din acest grup.',
-	'ACP_AUTOGROUPS_MIN_VALUE'				=> 'Valoarea minima',
-	'ACP_AUTOGROUPS_MIN_VALUE_EXPLAIN'		=> 'Utilizatorii vor fi adăugați în acest grup dacă îndeplinesc sau depășesc valoarea minimă.',
-	'ACP_AUTOGROUPS_MAX_VALUE'				=> 'Valoarea maximă',
-	'ACP_AUTOGROUPS_MAX_VALUE_EXPLAIN'		=> 'Utilizatorii vor fi excluși din acest grup dacă îndeplinesc sau depășesc valoarea maximă. Setați acest lucru la 0 dacă nu doriți ca utilizatorii să fie eliminați.',
-	'ACP_AUTOGROUPS_DEFAULT'				=> 'Setați grupul implicit',
-	'ACP_AUTOGROUPS_DEFAULT_EXPLAIN'		=> 'Faceți din acesta noul grup implicit al utilizatorului.',
-	'ACP_AUTOGROUPS_DEFAULT_EXEMPTION'		=> 'Acest lucru nu va afecta utilizatorii al căror grup de utilizatori implicit este unul dintre următoarele: %s.',
-	'ACP_AUTOGROUPS_NOTIFY'					=> 'Notificați utilizatorii',
-	'ACP_AUTOGROUPS_NOTIFY_EXPLAIN'			=> 'Trimiteți o notificare utilizatorilor după ce au fost adăugat sau eliminat automat din acest grup.',
-
-	'ACP_AUTOGROUPS_EXCLUDED_GROUPS'		=> 'Grupuri excluse',
-	'ACP_AUTOGROUPS_EXCLUDE_GROUP'			=> 'Excludeți membrii acestor grupuri',
-	'ACP_AUTOGROUPS_EXCLUDE_GROUP_EXPLAIN'	=> 'Membrii care aparțin <em>orice grup</em> selectat în această listă vor fi ignorați. Lăsați acest câmp necompletat dacă doriți ca acest grup automat să fie aplicat <em>toți membrii</em> ai forumului dvs. Selectați mai multe grupuri ținând apăsat pe <samp>CTRL</samp> (sau <samp>&#8984;CMD</samp> pe Mac) și selectând grupurile.',
-	'ACP_AUTOGROUPS_INVALID_EXCLUDE_GROUPS'	=> 'A apărut o eroare. Grupul pentru această condiție nu poate fi selectat și în câmpul grupuri excluse.',
-	'ACP_AUTOGROUPS_EXEMPT_GROUP'			=> 'Setați scutiri implicite de grup',
-	'ACP_AUTOGROUPS_EXEMPT_GROUP_EXPLAIN'	=> 'Grupurile automate nu vor schimba <em>grupul implicit</em> al unui utilizator dacă este selectat în această listă. Selectați mai multe grupuri ținând apăsat pe <samp>CTRL</samp> (sau <samp>&#8984;CMD</samp> pe Mac) și selectând grupurile.',
-
-	'ACP_AUTOGROUPS_CREATE_RULE'	=> 'Creați un nou Grup Automat',
-	'ACP_AUTOGROUPS_SUBMIT_SUCCESS'	=> 'Grupul automat a fost configurat cu succes.',
-	'ACP_AUTOGROUPS_DELETE_CONFIRM'	=> 'Sigur doriți să ștergeți această configurație de grup automat?',
-	'ACP_AUTOGROUPS_DELETE_SUCCESS'	=> 'Grupul automat a fost șters cu succes.',
-	'ACP_AUTOGROUPS_EMPTY'			=> 'Nu există Grupuri Automate.',
-	'ACP_AUTOGROUPS_NO_GROUPS'		=> 'Nu există grupuri disponibile',
-	'ACP_AUTOGROUPS_INVALID_GROUPS'	=> 'A apărut o eroare. Nu a fost selectat un grup de utilizatori valid.<br />Grupurile automate pot fi utilizate numai cu grupuri definite de utilizator, care pot fi create pe pagina Gestionați grupuri.',
-	'ACP_AUTOGROUPS_INVALID_RANGE'	=> 'A apărut o eroare. Valorile minime și maxime nu pot fi setate la aceeași valoare.',
-
-	// Conditions
-	'AUTOGROUPS_TYPE_BIRTHDAYS'		=> 'Vârsta utilizatorului',
-	'AUTOGROUPS_TYPE_LASTVISIT'		=> 'Zile de la ultima vizită',
-	'AUTOGROUPS_TYPE_MEMBERSHIP'	=> 'Zilele de membru',
-	'AUTOGROUPS_TYPE_POSTS'			=> 'Postări',
-	'AUTOGROUPS_TYPE_WARNINGS'		=> 'Avertismente',
-));
diff --git "[ORIGINAL]/phpbb\\autogroups/language/ro/autogroups_common.php" "[ORIGINAL]/phpbb\\autogroups/language/ro/autogroups_common.php"
deleted file mode 100644
--- "[ORIGINAL]/phpbb\\autogroups/language/ro/autogroups_common.php"
+++ /dev/null
@@ -1,45 +0,0 @@
-<?php
-/**
-*
-* Auto Groups extension for the phpBB Forum Software package.
-* Romanian translation by iorG19 (https://ioforos.com)
-*
-* @copyright (c) 2014 phpBB Limited <https://www.phpbb.com>
-* @license GNU General Public License, version 2 (GPL-2.0)
-*
-*/
-
-/**
-* DO NOT CHANGE
-*/
-if (!defined('IN_PHPBB'))
-{
-	exit;
-}
-
-if (empty($lang) || !is_array($lang))
-{
-	$lang = array();
-}
-
-// DEVELOPERS PLEASE NOTE
-//
-// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
-//
-// Placeholders can now contain order information, e.g. instead of
-// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
-// translators to re-order the output of data while ensuring it remains correct
-//
-// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
-// equally where a string contains only two placeholders which are used to wrap text
-// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
-//
-// Some characters you may want to copy&paste:
-// ’ » “ ” …
-//
-
-$lang = array_merge($lang, array(
-	// Notifications
-	'AUTOGROUPS_NOTIFICATION_GROUP_ADDED'	=> '<strong>Actualizare de grup</strong>: Ați fost adăugat în grupul %1$s.',
-	'AUTOGROUPS_NOTIFICATION_GROUP_REMOVED'	=> '<strong>Actualizare de grup</strong>: Ați fost exclus din grupul %1$s.',
-));
diff --git "[ORIGINAL]/phpbb\\autogroups/language/ro/autogroups_install.php" "[ORIGINAL]/phpbb\\autogroups/language/ro/autogroups_install.php"
deleted file mode 100644
--- "[ORIGINAL]/phpbb\\autogroups/language/ro/autogroups_install.php"
+++ /dev/null
@@ -1,43 +0,0 @@
-<?php
-/**
-*
-* Auto Groups extension for the phpBB Forum Software package.
-* Romanian translation by iorG19 (https://ioforos.com)
-*
-* @copyright (c) 2019 phpBB Limited <https://www.phpbb.com>
-* @license GNU General Public License, version 2 (GPL-2.0)
-*
-*/
-
-/**
-* DO NOT CHANGE
-*/
-if (!defined('IN_PHPBB'))
-{
-	exit;
-}
-
-if (empty($lang) || !is_array($lang))
-{
-	$lang = array();
-}
-
-// DEVELOPERS PLEASE NOTE
-//
-// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
-//
-// Placeholders can now contain order information, e.g. instead of
-// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
-// translators to re-order the output of data while ensuring it remains correct
-//
-// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
-// equally where a string contains only two placeholders which are used to wrap text
-// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
-//
-// Some characters you may want to copy&paste:
-// ’ » “ ” …
-//
-
-$lang = array_merge($lang, array(
-	'AUTOGROUPS_NOT_ENABLEABLE'	=> 'Grupurile automate nu au putut fi activate. Cerințele minime ale phpBB 3.2.0 și/sau PHP 5.5.0 nu au fost îndeplinite.',
-));
diff --git "[ORIGINAL]/phpbb\\autogroups/language/ro/info_acp_autogroups.php" "[ORIGINAL]/phpbb\\autogroups/language/ro/info_acp_autogroups.php"
deleted file mode 100644
--- "[ORIGINAL]/phpbb\\autogroups/language/ro/info_acp_autogroups.php"
+++ /dev/null
@@ -1,48 +0,0 @@
-<?php
-/**
-*
-* Auto Groups extension for the phpBB Forum Software package.
-* Romanian translation by iorG19 (https://ioforos.com)
-*
-* @copyright (c) 2014 phpBB Limited <https://www.phpbb.com>
-* @license GNU General Public License, version 2 (GPL-2.0)
-*
-*/
-
-/**
-* DO NOT CHANGE
-*/
-if (!defined('IN_PHPBB'))
-{
-	exit;
-}
-
-if (empty($lang) || !is_array($lang))
-{
-	$lang = array();
-}
-
-// DEVELOPERS PLEASE NOTE
-//
-// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
-//
-// Placeholders can now contain order information, e.g. instead of
-// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
-// translators to re-order the output of data while ensuring it remains correct
-//
-// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
-// equally where a string contains only two placeholders which are used to wrap text
-// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
-//
-// Some characters you may want to copy&paste:
-// ’ » “ ” …
-//
-
-$lang = array_merge($lang, array(
-	'ACP_AUTOGROUPS_MANAGE'			=> 'Gestionați Grupurile Automate',
-	'AUTOGROUPS_TYPE_NOT_EXIST'		=> 'Tipul Auto Group `%1$s` nu există.',
-
-	// Logs
-	'ACP_AUTOGROUPS_SAVED_LOG'		=> '<strong>O configurație de Grup Automat a fost salvată</strong>',
-	'ACP_AUTOGROUPS_DELETE_LOG'		=> '<strong>O configurație de Grup Automat a fost ștearsă</strong>',
-));
diff --git "[ORIGINAL]/phpbb\\autogroups/language/ru/autogroups_acp.php" "[FORUM_EXT]/phpbb\\autogroups/language/ru/autogroups_acp.php"
--- "[ORIGINAL]/phpbb\\autogroups/language/ru/autogroups_acp.php"
+++ "[FORUM_EXT]/phpbb\\autogroups/language/ru/autogroups_acp.php"
@@ -70,7 +70,7 @@ $lang = array_merge($lang, array(
 	'ACP_AUTOGROUPS_DELETE_SUCCESS'	=> 'АвтоГруппа успешно удалена.',
 	'ACP_AUTOGROUPS_EMPTY'			=> 'Нет АвтоГрупп.',
 	'ACP_AUTOGROUPS_NO_GROUPS'		=> 'Нет доступных групп',
-	'ACP_AUTOGROUPS_INVALID_GROUPS'	=> 'Произошла ошибка. Не выбрана действующая группа пользователей.<br>АвтоГруппы могут использоваться только с определенными группами пользователей, создать которые можно на странице управления группами.',
+	'ACP_AUTOGROUPS_INVALID_GROUPS'	=> 'Произошла ошибка. Не выбрана действующая группа пользователей.<br />АвтоГруппы могут использоваться только с определенными группами пользователей, создать которые можно на странице управления группами.',
 	'ACP_AUTOGROUPS_INVALID_RANGE'	=> 'Произошла ошибка. Минимальное и максимальное значения не могут быть установлены на одно и то же значение.',
 
 	// Conditions
diff --git "[ORIGINAL]/phpbb\\autogroups/language/sk/autogroups_acp.php" "[FORUM_EXT]/phpbb\\autogroups/language/sk/autogroups_acp.php"
--- "[ORIGINAL]/phpbb\\autogroups/language/sk/autogroups_acp.php"
+++ "[FORUM_EXT]/phpbb\\autogroups/language/sk/autogroups_acp.php"
@@ -71,7 +71,7 @@ $lang = array_merge($lang, array(
 	'ACP_AUTOGROUPS_DELETE_SUCCESS'	=> 'Automatická skupina bola úspešne vymazaná.',
 	'ACP_AUTOGROUPS_EMPTY'			=> 'Nie sú zatiaľ žiadne automatické skupiny.',
 	'ACP_AUTOGROUPS_NO_GROUPS'		=> 'Nie sú dostupné žiadne skupiny',
-	'ACP_AUTOGROUPS_INVALID_GROUPS'	=> 'Nastala chyba. Nebola vybraná správna používteľská skupina.<br>Automatické skupiny môžu byť použité iba s používateľskými skupinami, ktoré môžu byť vytvorené na stránke Spravovať skupiny.',
+	'ACP_AUTOGROUPS_INVALID_GROUPS'	=> 'Nastala chyba. Nebola vybraná správna používteľská skupina.<br />Automatické skupiny môžu byť použité iba s používateľskými skupinami, ktoré môžu byť vytvorené na stránke Spravovať skupiny.',
 	'ACP_AUTOGROUPS_INVALID_RANGE'	=> 'Nastala chyba. Minimálna a maximálna hodnota nemôžu byť nastavené na rovnakú hodnotu.',
 
 	// Conditions
diff --git "[ORIGINAL]/phpbb\\autogroups/language/tr/autogroups_acp.php" "[FORUM_EXT]/phpbb\\autogroups/language/tr/autogroups_acp.php"
--- "[ORIGINAL]/phpbb\\autogroups/language/tr/autogroups_acp.php"
+++ "[FORUM_EXT]/phpbb\\autogroups/language/tr/autogroups_acp.php"
@@ -70,7 +70,7 @@ $lang = array_merge($lang, array(
 	'ACP_AUTOGROUPS_DELETE_SUCCESS'	=> 'Otomatik Grup başarıyla silindi.',
 	'ACP_AUTOGROUPS_EMPTY'			=> 'Hiç Otomatik Grup yok.',
 	'ACP_AUTOGROUPS_NO_GROUPS'		=> 'Grup mevcut değil',
-	'ACP_AUTOGROUPS_INVALID_GROUPS'	=> 'Bir hata oluştu. Geçerli bir kullanıcı grubu seçilmedi.<br>Otomatik Gruplar yalnızca Grup Yönetimi sayfasında oluşturulabilen kullanıcı tanımlı gruplarla kullanılabilir.',
+	'ACP_AUTOGROUPS_INVALID_GROUPS'	=> 'Bir hata oluştu. Geçerli bir kullanıcı grubu seçilmedi.<br />Otomatik Gruplar yalnızca Grup Yönetimi sayfasında oluşturulabilen kullanıcı tanımlı gruplarla kullanılabilir.',
 	'ACP_AUTOGROUPS_INVALID_RANGE'	=> 'Bir hata oluştu. Minimum ve maksimum değerler aynı değer olarak ayarlanamaz.',
 
 	// Conditions
diff --git "[ORIGINAL]/phpbb\\autogroups/language/zh_cmn_hans/autogroups_acp.php" "[FORUM_EXT]/phpbb\\autogroups/language/zh_cmn_hans/autogroups_acp.php"
--- "[ORIGINAL]/phpbb\\autogroups/language/zh_cmn_hans/autogroups_acp.php"
+++ "[FORUM_EXT]/phpbb\\autogroups/language/zh_cmn_hans/autogroups_acp.php"
@@ -71,7 +71,7 @@ $lang = array_merge($lang, array(
 	'ACP_AUTOGROUPS_DELETE_SUCCESS'	=> '自动分组配置已删除。',
 	'ACP_AUTOGROUPS_EMPTY'			=> '没有任何的自动分组设置。',
 	'ACP_AUTOGROUPS_NO_GROUPS'		=> '无用户组可以选择',
-	'ACP_AUTOGROUPS_INVALID_GROUPS'	=> '错误！无效用户组被选中。<br> 自动分组只能应用于用户定义的组，用户定义的组可以在用户组管理界面添加。',
+	'ACP_AUTOGROUPS_INVALID_GROUPS'	=> '错误！无效用户组被选中。<br /> 自动分组只能应用于用户定义的组，用户定义的组可以在用户组管理界面添加。',
 	'ACP_AUTOGROUPS_INVALID_RANGE'	=> '错误！最大值不能等于最小值。',
 
 	// Conditions
```
