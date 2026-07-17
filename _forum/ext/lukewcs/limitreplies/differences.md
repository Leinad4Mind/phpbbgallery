Existem diferencas reais no codigo ou texto. Diferencas de formatacao (espacos, tabs) foram ignoradas abaixo.

```diff
diff --git "[ORIGINAL]/lukewcs\\limitreplies/adm/style/acp_limitreplies_settings.css" "[FORUM_EXT]/lukewcs\\limitreplies/adm/style/acp_limitreplies_settings.css"
--- "[ORIGINAL]/lukewcs\\limitreplies/adm/style/acp_limitreplies_settings.css"
+++ "[FORUM_EXT]/lukewcs\\limitreplies/adm/style/acp_limitreplies_settings.css"
@@ -1,4 +1,4 @@
-/* GENERAL >>> */
+/* GENERAL */
 
 .limitreplies_footer {
 	margin-top: 1em;
@@ -6,12 +6,9 @@
 	font-size: 0.75em;
 }
 
-/* <<< GENERAL */
+/* SETTINGS */
 
-/* SETTINGS >>> */
-
-fieldset {}
-	& legend {
+fieldset legend {
 	top: 0;
 	margin-left: -11px;
 	padding: 2px 10px;
@@ -21,18 +18,13 @@ fieldset {}
 	background-color: inherit;
 }
 
-	& dt label {
+fieldset dt label {
 	cursor: inherit;
 }
 
-	& p.submit-buttons {
+fieldset p.submit-buttons {
 	margin-top: 0;
 	padding: 0 4px 4px 4px;
-
-		& input:is([type="submit"], [type="reset"], [type="button"]) {
-			padding: 3px 4px;
-		}
-	}
 }
 
 code {
@@ -41,65 +33,61 @@ code {
 	color: black;
 }
 
-.toggle {
-	/* phpBB Kirk Toggles 2.0 - A CSS class that makes it easy to display checkboxes as toggles.
-	   Source     : https://danklammer.com/articles/simple-css-toggle-switch/
-	   Revision by: Kirk (customization and optimization), LukeWCS (optimization) */
-
-	/* Kirk style: */
-	/* --background-transition: ease 0.3s; */
-	/* --background-color-off: #a00; */
-	/* --background-color-on: #3fa651; */
-	/* --slider-transition: all cubic-bezier(0.3, 1.5, 0.7, 1) 0.3s; */
+/*
+* phpBB ACP Toggles - A CSS class that makes it easy to display checkboxes as toggles.
+* Source     : https://danklammer.com/articles/simple-css-toggle-switch/
+* Revision by: Kirk (customization and optimization), LukeWCS (optimization)
+*/
 
+.toggle {
+	-webkit-appearance: none;
+	-moz-appearance: none;
 	appearance: none;
-	position: relative;
 	width: 38px;
 	height: 17px;
+	position: relative;
 	border-radius: 50px;
 	cursor: pointer;
 	font-family: FontAwesome;
-	transition: var(--background-transition, 0.2s);
-
-	&,
-	&:hover,
-	&:focus {
-		background: var(--background-color-off, #ccc);
-		border: none;
-		color: #000;
+	transition: background-color 0.2s;
 }
 
-	&:before {
-		content: "\f00d";
-		justify-content: center;
+.toggle:before {
 	position: absolute;
-		top: 2px;
-		left: 22px;
 	width: 14px;
 	height: 13px;
-		background: #fff;
+	background-color: #ffffff;
+	top: 2px;
 	border-radius: 50%;
 	display: flex;
+	justify-content: center;
 	align-items: center;
-		transition: var(--slider-transition, 0.2s);
+	left: 22px;
+	content: "\f00d";
+	transition: 0.2s;
 }
 
-	&:checked {
-		background: var(--background-color-on, #3b87ab);
-
-		&:before {
-			content: "\f00c";
-			left: 2px;
-		}
+.toggle,
+.toggle:hover,
+.toggle:focus {
+	background-color: #cccccc;
+	border: none;
+	color: #000000;
 }
+
+.toggle:checked {
+	background-color: #3b87ab;
 }
 
-/* <<< SETTINGS */
+.toggle:checked:before {
+	left: 2px;
+	content: "\f00c";
+}
 
-/* RESPONSIVE >>> */
+/* RESPONSIVE */
 
 @media (max-width: 700px) {
-	fieldset legend {
+	legend {
 		margin-left: -6px;
 		padding: 2px 5px;
 	}
@@ -108,5 +96,3 @@ code {
 		margin-top: 0.5em;
 	}
 }
-
-/* <<< RESPONSIVE */
diff --git "[ORIGINAL]/lukewcs\\limitreplies/adm/style/acp_limitreplies_settings.html" "[FORUM_EXT]/lukewcs\\limitreplies/adm/style/acp_limitreplies_settings.html"
--- "[ORIGINAL]/lukewcs\\limitreplies/adm/style/acp_limitreplies_settings.html"
+++ "[FORUM_EXT]/lukewcs\\limitreplies/adm/style/acp_limitreplies_settings.html"
@@ -12,6 +12,8 @@
 
 {% INCLUDE 'overall_header.html' %}
 
+{% set switch_type = TOGGLECTRL_TYPE ?? 'toggle' %}
+
 <a id="maincontent"></a>
 
 <h1>{{ lang('LIMITREPLIES_CONFIG_TITLE') }}</h1>
@@ -29,7 +31,7 @@
 				<span>{{ lang('LIMITREPLIES_ENABLE_EXPLAIN') }}</span>
 			</dt>
 			<dd>
-				{{ _self.switch('limitreplies_switch_enable', LIMITREPLIES_SWITCH_ENABLE) }}
+				{{ _self.switch('limitreplies_switch_enable', LIMITREPLIES_SWITCH_ENABLE, switch_type) }}
 			</dd>
 		</dl>
 
@@ -39,8 +41,8 @@
 				<span>{{ lang('LIMITREPLIES_WAIT_TIME_EXPLAIN') }}</span>
 			</dt>
 			<dd>
-				{{ _self.number('limitreplies_number_wait_time', LIMITREPLIES_NUMBER_WAIT_TIME, 1, 999) }}
-				{{ _self.select('limitreplies_select_time_unit', LIMITREPLIES_SELECT_TIME_UNIT_OPTS) }}
+				{{ _self.number('limitreplies_number_wait_time', LIMITREPLIES_NUMBER_WAIT_TIME, 1, 999999) }}
+				{{ lang('LIMITREPLIES_MINUTES') }}
 			</dd>
 		</dl>
 
@@ -73,17 +75,14 @@
 {% INCLUDE 'overall_footer.html' %}
 
 {% INCLUDECSS '@lukewcs_limitreplies/acp_limitreplies_settings.css' %}
-{% INCLUDEJS '@lukewcs_limitreplies/acp_limitreplies_settings.js' %}
 
-{% macro switch(name, checked = false, type = null) -%}
-	{% set type = type ?? (TOGGLECTRL_TYPE in ['toggle', 'checkbox', 'radio'] ? TOGGLECTRL_TYPE : 'toggle') -%}
-	{% if type in ['toggle', 'checkbox'] -%}
+{% macro switch(name, checked = false, type = 'toggle') -%}
+	{% if type == 'toggle' || type == 'checkbox' -%}
 		<input type="checkbox" class="{{ type }}" name="{{ name }}" value="1"{{ checked ? ' checked' }}>
 	{%- elseif type == 'radio' -%}
 		<label><input type="radio" class="radio" name="{{ name }}" value="1"{{ checked ? ' checked' }}> {{ lang('YES') }}</label>
 		<label><input type="radio" class="radio" name="{{ name }}" value="0"{{ !checked ? ' checked' }}> {{ lang('NO') }}</label>
 	{%- endif %}
-	{#- v1.3.1 #}
 {%- endmacro %}
 
 {% macro number(name, value, min = null, max = null, step = null, placeholder = null) -%}
@@ -110,11 +109,10 @@
 {%- endmacro %}
 
 {% macro notes(notes) %}
-	{% set note_dot = notes|length > 1 ? '&bull; ' %}
 	{% if notes|length %}
 		<div class="successbox notice">
 			{% for note in notes %}
-				<p>{{ note_dot }}{{ note }}</p>
+				<p>{{ note }}</p>
 			{% endfor %}
 		</div>
 	{% endif %}
@@ -125,7 +123,7 @@
 		{{ metadata.ext_name }} {{ metadata.ext_ver }} &copy; {{ metadata.ext_copyright }}
 		{% if metadata.lang_ver is defined %}
 			<br>
-			{{ metadata.lang_desc|e('html') }} {{ metadata.lang_ver|e('html') }} &copy; {{ metadata.lang_author|e('html') }}
+			{{ metadata.lang_desc|e('html') }} {{ metadata.lang_ver|e('html') }} &bull; {{ metadata.lang_author|e('html') }}
 		{% endif %}
 	</p>
 {% endmacro %}
diff --git "[ORIGINAL]/lukewcs\\limitreplies/adm/style/acp_limitreplies_settings.js" "[ORIGINAL]/lukewcs\\limitreplies/adm/style/acp_limitreplies_settings.js"
deleted file mode 100644
--- "[ORIGINAL]/lukewcs\\limitreplies/adm/style/acp_limitreplies_settings.js"
+++ /dev/null
@@ -1,51 +0,0 @@
-/**
-*
-* Limit Multiple Replies. An extension for the phpBB Forum Software package.
-*
-* @copyright (c) 2024, LukeWCS, https://github.com/LukeWCS
-* @license GNU General Public License, version 2 (GPL-2.0-only)
-*
-* Note: This extension is 100% genuine handcraft and consists of selected
-*       natural raw materials. There was no AI involved in making it.
-*
-*/
-
-(function ($) {
-	'use strict';
-
-	const constants = Object.freeze({
-		OpacityEnabled	: '1.0',
-		OpacityDisabled	: '0.35',
-	});
-
-	function setState() {
-		dimOptionGroup('[name="limitreplies_number_wait_time"]', !$('[name="limitreplies_switch_enable"]').prop('checked'));
-		dimOptionGroup('[name="limitreplies_select_hint_mode"]', !$('[name="limitreplies_switch_enable"]').prop('checked'));
-	};
-
-	function dimOptionGroup(selector, dimCondition) {
-		const c = constants;
-
-		$(selector).parents('dl').css('opacity', dimCondition ? c.OpacityDisabled : c.OpacityEnabled);
-	}
-
-	function formReset() {
-		setTimeout(function() {
-			setState();
-		});
-	};
-
-	function disableEnter(e) {
-		if (e.key == 'Enter' && e.target.type != 'textarea') {
-			return false;
-		}
-	};
-
-	$(function() {
-		setState();
-
-		$('#limitreplies_settings')				.on('keypress'	, disableEnter);
-		$('#limitreplies_settings')				.on('reset'		, formReset);
-		$('[name="limitreplies_switch_enable"]').on('change'	, setState);
-	});
-})(jQuery);
diff --git "[ORIGINAL]/lukewcs\\limitreplies/composer.json" "[FORUM_EXT]/lukewcs\\limitreplies/composer.json"
--- "[ORIGINAL]/lukewcs\\limitreplies/composer.json"
+++ "[FORUM_EXT]/lukewcs\\limitreplies/composer.json"
@@ -3,8 +3,8 @@
 	"type": "phpbb-extension",
 	"description": "Forces a waiting period between two posts in a topic if the last post was from the same user. Posts in the topic’s moderation queue are also taken into account.",
 	"homepage": "https://github.com/LukeWCS/limit-multiple-replies",
-	"version": "1.1.1",
-	"time": "2026-06-14",
+	"version": "1.0.2",
+	"time": "2024-12-13",
 	"license": "GPL-2.0-only",
 	"authors": [
         {
@@ -14,12 +14,12 @@
 		}
 	],
 	"require": {
-		"php": ">=8.0.0,<8.6.0@dev",
-        "composer/installers": "^1.0 || ^2.0"
+		"php": ">=7.4.0,<8.5.0@dev",
+        "composer/installers": "~1.0.0"
 	},
 	"extra": {
 		"display-name": "Limit Multiple Replies",
-        "lang-min-ver": "1.1.0",
+        "lang-min-ver": "1.0.0",
 		"soft-require": {
 			"phpbb/phpbb": ">=3.3.2,<3.4.0@dev"
 		},
diff --git "[ORIGINAL]/lukewcs\\limitreplies/controller/acp_limitreplies_controller.php" "[FORUM_EXT]/lukewcs\\limitreplies/controller/acp_limitreplies_controller.php"
--- "[ORIGINAL]/lukewcs\\limitreplies/controller/acp_limitreplies_controller.php"
+++ "[FORUM_EXT]/lukewcs\\limitreplies/controller/acp_limitreplies_controller.php"
@@ -15,17 +15,29 @@ namespace lukewcs\limitreplies\controller;
 
 class acp_limitreplies_controller
 {
+	protected object $language;
+	protected object $template;
+	protected object $config;
+	protected object $request;
+	protected object $ext_manager;
+
+	protected string $u_action;
 	private   array  $metadata;
-	public  string $u_action;
 
 	public function __construct(
-		protected \phpbb\language\language $language,
-		protected \phpbb\template\template $template,
-		protected \phpbb\config\config $config,
-		protected \phpbb\request\request $request,
-		protected \phpbb\extension\manager $ext_manager,
+		\phpbb\language\language $language,
+		\phpbb\template\template $template,
+		\phpbb\config\config $config,
+		\phpbb\request\request $request,
+		\phpbb\extension\manager $ext_manager
 	)
 	{
+		$this->language		= $language;
+		$this->template		= $template;
+		$this->config		= $config;
+		$this->request		= $request;
+		$this->ext_manager	= $ext_manager;
+
 		$this->metadata		= $this->ext_manager->create_extension_metadata_manager('lukewcs/limitreplies')->get_metadata('all');
 	}
 
@@ -44,14 +56,14 @@ class acp_limitreplies_controller
 			}
 
 			$this->config->set('limitreplies_switch_enable'		, $this->request->variable('limitreplies_switch_enable'		, 0));
-			$this->config->set('limitreplies_number_wait_time'	, $this->min_max(1, 999, $this->request->variable('limitreplies_number_wait_time'	, 60)));
-			$this->config->set('limitreplies_select_time_unit'	, $this->request->variable('limitreplies_select_time_unit'							, 'minutes'));
+			$this->config->set('limitreplies_number_wait_time'	, $this->request->variable('limitreplies_number_wait_time'	, 60));
 			$this->config->set('limitreplies_select_hint_mode'	, $this->request->variable('limitreplies_select_hint_mode'	, 1));
 
 			trigger_error($this->language->lang('LIMITREPLIES_MSG_SETTINGS_SAVED') . adm_back_link($this->u_action));
 		}
 
-		if ($lang_outdated_msg = $this->lang_ver_check_msg('LIMITREPLIES_LANG_VER', 'LIMITREPLIES_MSG_LANGUAGEPACK_OUTDATED'))
+		$lang_outdated_msg = $this->lang_ver_check_msg('LIMITREPLIES_LANG_VER', 'LIMITREPLIES_MSG_LANGUAGEPACK_OUTDATED');
+		if ($lang_outdated_msg)
 		{
 			$notes[] = $lang_outdated_msg;
 		}
@@ -61,11 +73,6 @@ class acp_limitreplies_controller
 
 			'LIMITREPLIES_SWITCH_ENABLE'			=> (bool) $this->config['limitreplies_switch_enable'],
 			'LIMITREPLIES_NUMBER_WAIT_TIME'			=> (int) $this->config['limitreplies_number_wait_time'],
-			'LIMITREPLIES_SELECT_TIME_UNIT_OPTS'	=> $this->select_struct($this->config['limitreplies_select_time_unit'], [
-				'LIMITREPLIES_TIME_UNIT_MINUTES'	=> 'minutes',
-				'LIMITREPLIES_TIME_UNIT_HOURS'		=> 'hours',
-				'LIMITREPLIES_TIME_UNIT_DAYS'		=> 'days',
-			]),
 			'LIMITREPLIES_SELECT_HINT_MODE_OPTS'	=> $this->select_struct((int) $this->config['limitreplies_select_hint_mode'], [
 				'LIMITREPLIES_HINT_MODE_ONCLICK'	=> 1,
 				'LIMITREPLIES_HINT_MODE_ALWAYS'		=> 2,
@@ -80,27 +87,6 @@ class acp_limitreplies_controller
 		$this->u_action = $u_action;
 	}
 
-	private function select_struct(array|int|string $cfg_value, array $options): array
-	{
-		$options_tpl = [];
-
-		foreach ($options as $opt_key => $opt_value)
-		{
-			if (!is_array($opt_value))
-			{
-				$opt_value = [$opt_value];
-			}
-			$options_tpl[] = [
-				'label'		=> $opt_key,
-				'value'		=> $opt_value[0],
-				'bold'		=> $opt_value[1] ?? false,
-				'selected'	=> is_array($cfg_value) ? in_array($opt_value[0], $cfg_value) : $opt_value[0] == $cfg_value,
-			];
-		}
-
-		return $options_tpl;
-	}
-
 	private function set_meta_template_vars(string $tpl_prefix, string $copyright): void
 	{
 		$template_vars = [
@@ -118,15 +104,6 @@ class acp_limitreplies_controller
 		$this->template->assign_vars([$tpl_prefix . '_METADATA' => $template_vars]);
 	}
 
-	private function min_max(float|int $min, float|int $max, float|int $value): float|int
-	{
-		return match (true) {
-			$value < $min	=> $min,
-			$value > $max	=> $max,
-			default			=> $value,
-		};
-	}
-
 	/*
 		Determine the version of the language pack with fallback to 0.0.0
 	*/
@@ -160,4 +137,25 @@ class acp_limitreplies_controller
 
 		return $lang_outdated_msg;
 	}
+
+	private function select_struct($cfg_value, array $options): array
+	{
+		$options_tpl = [];
+
+		foreach ($options as $opt_key => $opt_value)
+		{
+			if (!is_array($opt_value))
+			{
+				$opt_value = [$opt_value];
+			}
+			$options_tpl[] = [
+				'label'		=> $opt_key,
+				'value'		=> $opt_value[0],
+				'bold'		=> $opt_value[1] ?? false,
+				'selected'	=> is_array($cfg_value) ? in_array($opt_value[0], $cfg_value) : $opt_value[0] == $cfg_value,
+			];
+		}
+
+		return $options_tpl;
+	}
 }
diff --git "[FORUM_EXT]/lukewcs\\limitreplies/diff_full.tmp" "[FORUM_EXT]/lukewcs\\limitreplies/diff_full.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/lukewcs\\limitreplies/diff_full.tmp"
@@ -0,0 +1,1225 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\limitreplies/adm/style/acp_limitreplies_settings.css" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\limitreplies/adm/style/acp_limitreplies_settings.css"
+index 503e96a9e..8127c3739 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\limitreplies/adm/style/acp_limitreplies_settings.css"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\limitreplies/adm/style/acp_limitreplies_settings.css"
+@@ -1,4 +1,4 @@
+-/* GENERAL >>> */
++/* GENERAL */
+ 
+ .limitreplies_footer {
+ 	margin-top: 1em;
+@@ -6,33 +6,25 @@
+ 	font-size: 0.75em;
+ }
+ 
+-/* <<< GENERAL */
++/* SETTINGS */
+ 
+-/* SETTINGS >>> */
+-
+-fieldset {}
+-	& legend {
+-		top: 0;
+-		margin-left: -11px;
+-		padding: 2px 10px;
+-		border-radius: 5px 5px 0 0;
+-		border-top: inherit;
+-		border-left: inherit;
+-		background-color: inherit;
+-	}
+-
+-	& dt label {
+-		cursor: inherit;
+-	}
++fieldset legend {
++	top: 0;
++	margin-left: -11px;
++	padding: 2px 10px;
++	border-radius: 5px 5px 0 0;
++	border-top: inherit;
++	border-left: inherit;
++	background-color: inherit;
++}
+ 
+-	& p.submit-buttons {
+-		margin-top: 0;
+-		padding: 0 4px 4px 4px;
++fieldset dt label {
++	cursor: inherit;
++}
+ 
+-		& input:is([type="submit"], [type="reset"], [type="button"]) {
+-			padding: 3px 4px;
+-		}
+-	}
++fieldset p.submit-buttons {
++	margin-top: 0;
++	padding: 0 4px 4px 4px;
+ }
+ 
+ code {
+@@ -41,65 +33,61 @@ code {
+ 	color: black;
+ }
+ 
+-.toggle {
+-	/* phpBB Kirk Toggles 2.0 - A CSS class that makes it easy to display checkboxes as toggles.
+-	   Source     : https://danklammer.com/articles/simple-css-toggle-switch/
+-	   Revision by: Kirk (customization and optimization), LukeWCS (optimization) */
+-
+-	/* Kirk style: */
+-	/* --background-transition: ease 0.3s; */
+-	/* --background-color-off: #a00; */
+-	/* --background-color-on: #3fa651; */
+-	/* --slider-transition: all cubic-bezier(0.3, 1.5, 0.7, 1) 0.3s; */
++/*
++* phpBB ACP Toggles - A CSS class that makes it easy to display checkboxes as toggles.
++* Source     : https://danklammer.com/articles/simple-css-toggle-switch/
++* Revision by: Kirk (customization and optimization), LukeWCS (optimization)
++*/
+ 
++.toggle {
++	-webkit-appearance: none;
++	-moz-appearance: none;
+ 	appearance: none;
+-	position: relative;
+ 	width: 38px;
+ 	height: 17px;
++	position: relative;
+ 	border-radius: 50px;
+ 	cursor: pointer;
+ 	font-family: FontAwesome;
+-	transition: var(--background-transition, 0.2s);
+-
+-	&,
+-	&:hover,
+-	&:focus {
+-		background: var(--background-color-off, #ccc);
+-		border: none;
+-		color: #000;
+-	}
++	transition: background-color 0.2s;
++}
+ 
+-	&:before {
+-		content: "\f00d";
+-		justify-content: center;
+-		position: absolute;
+-		top: 2px;
+-		left: 22px;
+-		width: 14px;
+-		height: 13px;
+-		background: #fff;
+-		border-radius: 50%;
+-		display: flex;
+-		align-items: center;
+-		transition: var(--slider-transition, 0.2s);
+-	}
++.toggle:before {
++	position: absolute;
++	width: 14px;
++	height: 13px;
++	background-color: #ffffff;
++	top: 2px;
++	border-radius: 50%;
++	display: flex;
++	justify-content: center;
++	align-items: center;
++	left: 22px;
++	content: "\f00d";
++	transition: 0.2s;
++}
+ 
+-	&:checked {
+-		background: var(--background-color-on, #3b87ab);
++.toggle,
++.toggle:hover,
++.toggle:focus {
++	background-color: #cccccc;
++	border: none;
++	color: #000000;
++}
+ 
+-		&:before {
+-			content: "\f00c";
+-			left: 2px;
+-		}
+-	}
++.toggle:checked {
++	background-color: #3b87ab;
+ }
+ 
+-/* <<< SETTINGS */
++.toggle:checked:before {
++	left: 2px;
++	content: "\f00c";
++}
+ 
+-/* RESPONSIVE >>> */
++/* RESPONSIVE */
+ 
+ @media (max-width: 700px) {
+-	fieldset legend {
++	legend {
+ 		margin-left: -6px;
+ 		padding: 2px 5px;
+ 	}
+@@ -108,5 +96,3 @@ code {
+ 		margin-top: 0.5em;
+ 	}
+ }
+-
+-/* <<< RESPONSIVE */
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\limitreplies/adm/style/acp_limitreplies_settings.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\limitreplies/adm/style/acp_limitreplies_settings.html"
+index 31eca30cb..d89ab32df 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\limitreplies/adm/style/acp_limitreplies_settings.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\limitreplies/adm/style/acp_limitreplies_settings.html"
+@@ -12,6 +12,8 @@
+ 
+ {% INCLUDE 'overall_header.html' %}
+ 
++{% set switch_type = TOGGLECTRL_TYPE ?? 'toggle' %}
++
+ <a id="maincontent"></a>
+ 
+ <h1>{{ lang('LIMITREPLIES_CONFIG_TITLE') }}</h1>
+@@ -29,7 +31,7 @@
+ 				<span>{{ lang('LIMITREPLIES_ENABLE_EXPLAIN') }}</span>
+ 			</dt>
+ 			<dd>
+-				{{ _self.switch('limitreplies_switch_enable', LIMITREPLIES_SWITCH_ENABLE) }}
++				{{ _self.switch('limitreplies_switch_enable', LIMITREPLIES_SWITCH_ENABLE, switch_type) }}
+ 			</dd>
+ 		</dl>
+ 
+@@ -39,8 +41,8 @@
+ 				<span>{{ lang('LIMITREPLIES_WAIT_TIME_EXPLAIN') }}</span>
+ 			</dt>
+ 			<dd>
+-				{{ _self.number('limitreplies_number_wait_time', LIMITREPLIES_NUMBER_WAIT_TIME, 1, 999) }}
+-				{{ _self.select('limitreplies_select_time_unit', LIMITREPLIES_SELECT_TIME_UNIT_OPTS) }}
++				{{ _self.number('limitreplies_number_wait_time', LIMITREPLIES_NUMBER_WAIT_TIME, 1, 999999) }}
++				{{ lang('LIMITREPLIES_MINUTES') }}
+ 			</dd>
+ 		</dl>
+ 
+@@ -73,17 +75,14 @@
+ {% INCLUDE 'overall_footer.html' %}
+ 
+ {% INCLUDECSS '@lukewcs_limitreplies/acp_limitreplies_settings.css' %}
+-{% INCLUDEJS '@lukewcs_limitreplies/acp_limitreplies_settings.js' %}
+ 
+-{% macro switch(name, checked = false, type = null) -%}
+-	{% set type = type ?? (TOGGLECTRL_TYPE in ['toggle', 'checkbox', 'radio'] ? TOGGLECTRL_TYPE : 'toggle') -%}
+-	{% if type in ['toggle', 'checkbox'] -%}
++{% macro switch(name, checked = false, type = 'toggle') -%}
++	{% if type == 'toggle' || type == 'checkbox' -%}
+ 		<input type="checkbox" class="{{ type }}" name="{{ name }}" value="1"{{ checked ? ' checked' }}>
+ 	{%- elseif type == 'radio' -%}
+ 		<label><input type="radio" class="radio" name="{{ name }}" value="1"{{ checked ? ' checked' }}> {{ lang('YES') }}</label>
+ 		<label><input type="radio" class="radio" name="{{ name }}" value="0"{{ !checked ? ' checked' }}> {{ lang('NO') }}</label>
+ 	{%- endif %}
+-	{#- v1.3.1 #}
+ {%- endmacro %}
+ 
+ {% macro number(name, value, min = null, max = null, step = null, placeholder = null) -%}
+@@ -110,22 +109,21 @@
+ {%- endmacro %}
+ 
+ {% macro notes(notes) %}
+-	{% set note_dot = notes|length > 1 ? '&bull; ' %}
+ 	{% if notes|length %}
+ 		<div class="successbox notice">
+ 			{% for note in notes %}
+-				<p>{{ note_dot }}{{ note }}</p>
++				<p>{{ note }}</p>
+ 			{% endfor %}
+ 		</div>
+ 	{% endif %}
+ {% endmacro %}
+ 
+ {% macro footer(metadata) %}
+-	<p class="{{ metadata.class }}">
++	<p class="{{ metadata.class  }}">
+ 		{{ metadata.ext_name }} {{ metadata.ext_ver }} &copy; {{ metadata.ext_copyright }}
+ 		{% if metadata.lang_ver is defined %}
+ 			<br>
+-			{{ metadata.lang_desc|e('html') }} {{ metadata.lang_ver|e('html') }} &copy; {{ metadata.lang_author|e('html') }}
++			{{ metadata.lang_desc|e('html') }} {{ metadata.lang_ver|e('html') }} &bull; {{ metadata.lang_author|e('html') }}
+ 		{% endif %}
+ 	</p>
+ {% endmacro %}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\limitreplies/adm/style/acp_limitreplies_settings.js" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\limitreplies/adm/style/acp_limitreplies_settings.js"
+deleted file mode 100644
+index c42f9deb0..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\limitreplies/adm/style/acp_limitreplies_settings.js"
++++ /dev/null
+@@ -1,51 +0,0 @@
+-/**
+-*
+-* Limit Multiple Replies. An extension for the phpBB Forum Software package.
+-*
+-* @copyright (c) 2024, LukeWCS, https://github.com/LukeWCS
+-* @license GNU General Public License, version 2 (GPL-2.0-only)
+-*
+-* Note: This extension is 100% genuine handcraft and consists of selected
+-*       natural raw materials. There was no AI involved in making it.
+-*
+-*/
+-
+-(function ($) {
+-	'use strict';
+-
+-	const constants = Object.freeze({
+-		OpacityEnabled	: '1.0',
+-		OpacityDisabled	: '0.35',
+-	});
+-
+-	function setState() {
+-		dimOptionGroup('[name="limitreplies_number_wait_time"]', !$('[name="limitreplies_switch_enable"]').prop('checked'));
+-		dimOptionGroup('[name="limitreplies_select_hint_mode"]', !$('[name="limitreplies_switch_enable"]').prop('checked'));
+-	};
+-
+-	function dimOptionGroup(selector, dimCondition) {
+-		const c = constants;
+-
+-		$(selector).parents('dl').css('opacity', dimCondition ? c.OpacityDisabled : c.OpacityEnabled);
+-	}
+-
+-	function formReset() {
+-		setTimeout(function() {
+-			setState();
+-		});
+-	};
+-
+-	function disableEnter(e) {
+-		if (e.key == 'Enter' && e.target.type != 'textarea') {
+-			return false;
+-		}
+-	};
+-
+-	$(function() {
+-		setState();
+-
+-		$('#limitreplies_settings')				.on('keypress'	, disableEnter);
+-		$('#limitreplies_settings')				.on('reset'		, formReset);
+-		$('[name="limitreplies_switch_enable"]').on('change'	, setState);
+-	});
+-})(jQuery);
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\limitreplies/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\limitreplies/composer.json"
+index 63cd7d3bd..4b072e3da 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\limitreplies/composer.json"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\limitreplies/composer.json"
+@@ -3,8 +3,8 @@
+ 	"type": "phpbb-extension",
+ 	"description": "Forces a waiting period between two posts in a topic if the last post was from the same user. Posts in the topic’s moderation queue are also taken into account.",
+ 	"homepage": "https://github.com/LukeWCS/limit-multiple-replies",
+-	"version": "1.1.1",
+-	"time": "2026-06-14",
++	"version": "1.0.2",
++	"time": "2024-12-13",
+ 	"license": "GPL-2.0-only",
+ 	"authors": [
+         {
+@@ -14,12 +14,12 @@
+ 		}
+ 	],
+ 	"require": {
+-		"php": ">=8.0.0,<8.6.0@dev",
+-        "composer/installers": "^1.0 || ^2.0"
++		"php": ">=7.4.0,<8.5.0@dev",
++        "composer/installers": "~1.0.0"
+ 	},
+ 	"extra": {
+ 		"display-name": "Limit Multiple Replies",
+-        "lang-min-ver": "1.1.0",
++        "lang-min-ver": "1.0.0",
+ 		"soft-require": {
+ 			"phpbb/phpbb": ">=3.3.2,<3.4.0@dev"
+ 		},
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\limitreplies/controller/acp_limitreplies_controller.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\limitreplies/controller/acp_limitreplies_controller.php"
+index 1bfe49149..aaa3e1fd5 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\limitreplies/controller/acp_limitreplies_controller.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\limitreplies/controller/acp_limitreplies_controller.php"
+@@ -15,18 +15,30 @@ namespace lukewcs\limitreplies\controller;
+ 
+ class acp_limitreplies_controller
+ {
+-	private array  $metadata;
+-	public  string $u_action;
++	protected object $language;
++	protected object $template;
++	protected object $config;
++	protected object $request;
++	protected object $ext_manager;
++
++	protected string $u_action;
++	private   array  $metadata;
+ 
+ 	public function __construct(
+-		protected \phpbb\language\language $language,
+-		protected \phpbb\template\template $template,
+-		protected \phpbb\config\config $config,
+-		protected \phpbb\request\request $request,
+-		protected \phpbb\extension\manager $ext_manager,
++		\phpbb\language\language $language,
++		\phpbb\template\template $template,
++		\phpbb\config\config $config,
++		\phpbb\request\request $request,
++		\phpbb\extension\manager $ext_manager
+ 	)
+ 	{
+-		$this->metadata = $this->ext_manager->create_extension_metadata_manager('lukewcs/limitreplies')->get_metadata('all');
++		$this->language		= $language;
++		$this->template		= $template;
++		$this->config		= $config;
++		$this->request		= $request;
++		$this->ext_manager	= $ext_manager;
++
++		$this->metadata		= $this->ext_manager->create_extension_metadata_manager('lukewcs/limitreplies')->get_metadata('all');
+ 	}
+ 
+ 	public function module_settings(): void
+@@ -43,15 +55,15 @@ class acp_limitreplies_controller
+ 				trigger_error($this->language->lang('FORM_INVALID') . adm_back_link($this->u_action), E_USER_WARNING);
+ 			}
+ 
+-			$this->config->set('limitreplies_switch_enable'		, $this->request->variable('limitreplies_switch_enable'								, 0));
+-			$this->config->set('limitreplies_number_wait_time'	, $this->min_max(1, 999, $this->request->variable('limitreplies_number_wait_time'	, 60)));
+-			$this->config->set('limitreplies_select_time_unit'	, $this->request->variable('limitreplies_select_time_unit'							, 'minutes'));
+-			$this->config->set('limitreplies_select_hint_mode'	, $this->request->variable('limitreplies_select_hint_mode'							, 1));
++			$this->config->set('limitreplies_switch_enable'		, $this->request->variable('limitreplies_switch_enable'		, 0));
++			$this->config->set('limitreplies_number_wait_time'	, $this->request->variable('limitreplies_number_wait_time'	, 60));
++			$this->config->set('limitreplies_select_hint_mode'	, $this->request->variable('limitreplies_select_hint_mode'	, 1));
+ 
+ 			trigger_error($this->language->lang('LIMITREPLIES_MSG_SETTINGS_SAVED') . adm_back_link($this->u_action));
+ 		}
+ 
+-		if ($lang_outdated_msg = $this->lang_ver_check_msg('LIMITREPLIES_LANG_VER', 'LIMITREPLIES_MSG_LANGUAGEPACK_OUTDATED'))
++		$lang_outdated_msg = $this->lang_ver_check_msg('LIMITREPLIES_LANG_VER', 'LIMITREPLIES_MSG_LANGUAGEPACK_OUTDATED');
++		if ($lang_outdated_msg)
+ 		{
+ 			$notes[] = $lang_outdated_msg;
+ 		}
+@@ -61,11 +73,6 @@ class acp_limitreplies_controller
+ 
+ 			'LIMITREPLIES_SWITCH_ENABLE'			=> (bool) $this->config['limitreplies_switch_enable'],
+ 			'LIMITREPLIES_NUMBER_WAIT_TIME'			=> (int) $this->config['limitreplies_number_wait_time'],
+-			'LIMITREPLIES_SELECT_TIME_UNIT_OPTS'	=> $this->select_struct($this->config['limitreplies_select_time_unit'], [
+-				'LIMITREPLIES_TIME_UNIT_MINUTES'	=> 'minutes',
+-				'LIMITREPLIES_TIME_UNIT_HOURS'		=> 'hours',
+-				'LIMITREPLIES_TIME_UNIT_DAYS'		=> 'days',
+-			]),
+ 			'LIMITREPLIES_SELECT_HINT_MODE_OPTS'	=> $this->select_struct((int) $this->config['limitreplies_select_hint_mode'], [
+ 				'LIMITREPLIES_HINT_MODE_ONCLICK'	=> 1,
+ 				'LIMITREPLIES_HINT_MODE_ALWAYS'		=> 2,
+@@ -80,27 +87,6 @@ class acp_limitreplies_controller
+ 		$this->u_action = $u_action;
+ 	}
+ 
+-	private function select_struct(array|int|string $cfg_value, array $options): array
+-	{
+-		$options_tpl = [];
+-
+-		foreach ($options as $opt_key => $opt_value)
+-		{
+-			if (!is_array($opt_value))
+-			{
+-				$opt_value = [$opt_value];
+-			}
+-			$options_tpl[] = [
+-				'label'		=> $opt_key,
+-				'value'		=> $opt_value[0],
+-				'bold'		=> $opt_value[1] ?? false,
+-				'selected'	=> is_array($cfg_value) ? in_array($opt_value[0], $cfg_value) : $opt_value[0] == $cfg_value,
+-			];
+-		}
+-
+-		return $options_tpl;
+-	}
+-
+ 	private function set_meta_template_vars(string $tpl_prefix, string $copyright): void
+ 	{
+ 		$template_vars = [
+@@ -118,15 +104,6 @@ class acp_limitreplies_controller
+ 		$this->template->assign_vars([$tpl_prefix . '_METADATA' => $template_vars]);
+ 	}
+ 
+-	private function min_max(float|int $min, float|int $max, float|int $value): float|int
+-	{
+-		return match (true) {
+-			$value < $min	=> $min,
+-			$value > $max	=> $max,
+-			default			=> $value,
+-		};
+-	}
+-
+ 	/*
+ 		Determine the version of the language pack with fallback to 0.0.0
+ 	*/
+@@ -160,4 +137,25 @@ class acp_limitreplies_controller
+ 
+ 		return $lang_outdated_msg;
+ 	}
++
++	private function select_struct($cfg_value, array $options): array
++	{
++		$options_tpl = [];
++
++		foreach ($options as $opt_key => $opt_value)
++		{
++			if (!is_array($opt_value))
++			{
++				$opt_value = [$opt_value];
++			}
++			$options_tpl[] = [
++				'label'		=> $opt_key,
++				'value'		=> $opt_value[0],
++				'bold'		=> $opt_value[1] ?? false,
++				'selected'	=> is_array($cfg_value) ? in_array($opt_value[0], $cfg_value) : $opt_value[0] == $cfg_value,
++			];
++		}
++
++		return $options_tpl;
++	}
+ }
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\limitreplies/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\limitreplies/diff_full.tmp"
+new file mode 100644
+index 000000000..59d686c86
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\limitreplies/diff_full.tmp"
+@@ -0,0 +1,381 @@
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\limitreplies/adm/style/acp_limitreplies_settings.css" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\limitreplies/adm/style/acp_limitreplies_settings.css"
++index 503e96a9e..8127c3739 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\limitreplies/adm/style/acp_limitreplies_settings.css"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\limitreplies/adm/style/acp_limitreplies_settings.css"
++@@ -1,4 +1,4 @@
++-/* GENERAL >>> */
+++/* GENERAL */
++ 
++ .limitreplies_footer {
++ 	margin-top: 1em;
++@@ -6,33 +6,25 @@
++ 	font-size: 0.75em;
++ }
++ 
++-/* <<< GENERAL */
+++/* SETTINGS */
++ 
++-/* SETTINGS >>> */
++-
++-fieldset {}
++-	& legend {
++-		top: 0;
++-		margin-left: -11px;
++-		padding: 2px 10px;
++-		border-radius: 5px 5px 0 0;
++-		border-top: inherit;
++-		border-left: inherit;
++-		background-color: inherit;
++-	}
++-
++-	& dt label {
++-		cursor: inherit;
++-	}
+++fieldset legend {
+++	top: 0;
+++	margin-left: -11px;
+++	padding: 2px 10px;
+++	border-radius: 5px 5px 0 0;
+++	border-top: inherit;
+++	border-left: inherit;
+++	background-color: inherit;
+++}
++ 
++-	& p.submit-buttons {
++-		margin-top: 0;
++-		padding: 0 4px 4px 4px;
+++fieldset dt label {
+++	cursor: inherit;
+++}
++ 
++-		& input:is([type="submit"], [type="reset"], [type="button"]) {
++-			padding: 3px 4px;
++-		}
++-	}
+++fieldset p.submit-buttons {
+++	margin-top: 0;
+++	padding: 0 4px 4px 4px;
++ }
++ 
++ code {
++@@ -41,65 +33,61 @@ code {
++ 	color: black;
++ }
++ 
++-.toggle {
++-	/* phpBB Kirk Toggles 2.0 - A CSS class that makes it easy to display checkboxes as toggles.
++-	   Source     : https://danklammer.com/articles/simple-css-toggle-switch/
++-	   Revision by: Kirk (customization and optimization), LukeWCS (optimization) */
++-
++-	/* Kirk style: */
++-	/* --background-transition: ease 0.3s; */
++-	/* --background-color-off: #a00; */
++-	/* --background-color-on: #3fa651; */
++-	/* --slider-transition: all cubic-bezier(0.3, 1.5, 0.7, 1) 0.3s; */
+++/*
+++* phpBB ACP Toggles - A CSS class that makes it easy to display checkboxes as toggles.
+++* Source     : https://danklammer.com/articles/simple-css-toggle-switch/
+++* Revision by: Kirk (customization and optimization), LukeWCS (optimization)
+++*/
++ 
+++.toggle {
+++	-webkit-appearance: none;
+++	-moz-appearance: none;
++ 	appearance: none;
++-	position: relative;
++ 	width: 38px;
++ 	height: 17px;
+++	position: relative;
++ 	border-radius: 50px;
++ 	cursor: pointer;
++ 	font-family: FontAwesome;
++-	transition: var(--background-transition, 0.2s);
++-
++-	&,
++-	&:hover,
++-	&:focus {
++-		background: var(--background-color-off, #ccc);
++-		border: none;
++-		color: #000;
++-	}
+++	transition: background-color 0.2s;
+++}
++ 
++-	&:before {
++-		content: "\f00d";
++-		justify-content: center;
++-		position: absolute;
++-		top: 2px;
++-		left: 22px;
++-		width: 14px;
++-		height: 13px;
++-		background: #fff;
++-		border-radius: 50%;
++-		display: flex;
++-		align-items: center;
++-		transition: var(--slider-transition, 0.2s);
++-	}
+++.toggle:before {
+++	position: absolute;
+++	width: 14px;
+++	height: 13px;
+++	background-color: #ffffff;
+++	top: 2px;
+++	border-radius: 50%;
+++	display: flex;
+++	justify-content: center;
+++	align-items: center;
+++	left: 22px;
+++	content: "\f00d";
+++	transition: 0.2s;
+++}
++ 
++-	&:checked {
++-		background: var(--background-color-on, #3b87ab);
+++.toggle,
+++.toggle:hover,
+++.toggle:focus {
+++	background-color: #cccccc;
+++	border: none;
+++	color: #000000;
+++}
++ 
++-		&:before {
++-			content: "\f00c";
++-			left: 2px;
++-		}
++-	}
+++.toggle:checked {
+++	background-color: #3b87ab;
++ }
++ 
++-/* <<< SETTINGS */
+++.toggle:checked:before {
+++	left: 2px;
+++	content: "\f00c";
+++}
++ 
++-/* RESPONSIVE >>> */
+++/* RESPONSIVE */
++ 
++ @media (max-width: 700px) {
++-	fieldset legend {
+++	legend {
++ 		margin-left: -6px;
++ 		padding: 2px 5px;
++ 	}
++@@ -108,5 +96,3 @@ code {
++ 		margin-top: 0.5em;
++ 	}
++ }
++-
++-/* <<< RESPONSIVE */
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\limitreplies/adm/style/acp_limitreplies_settings.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\limitreplies/adm/style/acp_limitreplies_settings.html"
++index 31eca30cb..d89ab32df 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\limitreplies/adm/style/acp_limitreplies_settings.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\limitreplies/adm/style/acp_limitreplies_settings.html"
++@@ -12,6 +12,8 @@
++ 
++ {% INCLUDE 'overall_header.html' %}
++ 
+++{% set switch_type = TOGGLECTRL_TYPE ?? 'toggle' %}
+++
++ <a id="maincontent"></a>
++ 
++ <h1>{{ lang('LIMITREPLIES_CONFIG_TITLE') }}</h1>
++@@ -29,7 +31,7 @@
++ 				<span>{{ lang('LIMITREPLIES_ENABLE_EXPLAIN') }}</span>
++ 			</dt>
++ 			<dd>
++-				{{ _self.switch('limitreplies_switch_enable', LIMITREPLIES_SWITCH_ENABLE) }}
+++				{{ _self.switch('limitreplies_switch_enable', LIMITREPLIES_SWITCH_ENABLE, switch_type) }}
++ 			</dd>
++ 		</dl>
++ 
++@@ -39,8 +41,8 @@
++ 				<span>{{ lang('LIMITREPLIES_WAIT_TIME_EXPLAIN') }}</span>
++ 			</dt>
++ 			<dd>
++-				{{ _self.number('limitreplies_number_wait_time', LIMITREPLIES_NUMBER_WAIT_TIME, 1, 999) }}
++-				{{ _self.select('limitreplies_select_time_unit', LIMITREPLIES_SELECT_TIME_UNIT_OPTS) }}
+++				{{ _self.number('limitreplies_number_wait_time', LIMITREPLIES_NUMBER_WAIT_TIME, 1, 999999) }}
+++				{{ lang('LIMITREPLIES_MINUTES') }}
++ 			</dd>
++ 		</dl>
++ 
++@@ -73,17 +75,14 @@
++ {% INCLUDE 'overall_footer.html' %}
++ 
++ {% INCLUDECSS '@lukewcs_limitreplies/acp_limitreplies_settings.css' %}
++-{% INCLUDEJS '@lukewcs_limitreplies/acp_limitreplies_settings.js' %}
++ 
++-{% macro switch(name, checked = false, type = null) -%}
++-	{% set type = type ?? (TOGGLECTRL_TYPE in ['toggle', 'checkbox', 'radio'] ? TOGGLECTRL_TYPE : 'toggle') -%}
++-	{% if type in ['toggle', 'checkbox'] -%}
+++{% macro switch(name, checked = false, type = 'toggle') -%}
+++	{% if type == 'toggle' || type == 'checkbox' -%}
++ 		<input type="checkbox" class="{{ type }}" name="{{ name }}" value="1"{{ checked ? ' checked' }}>
++ 	{%- elseif type == 'radio' -%}
++ 		<label><input type="radio" class="radio" name="{{ name }}" value="1"{{ checked ? ' checked' }}> {{ lang('YES') }}</label>
++ 		<label><input type="radio" class="radio" name="{{ name }}" value="0"{{ !checked ? ' checked' }}> {{ lang('NO') }}</label>
++ 	{%- endif %}
++-	{#- v1.3.1 #}
++ {%- endmacro %}
++ 
++ {% macro number(name, value, min = null, max = null, step = null, placeholder = null) -%}
++@@ -110,22 +109,21 @@
++ {%- endmacro %}
++ 
++ {% macro notes(notes) %}
++-	{% set note_dot = notes|length > 1 ? '&bull; ' %}
++ 	{% if notes|length %}
++ 		<div class="successbox notice">
++ 			{% for note in notes %}
++-				<p>{{ note_dot }}{{ note }}</p>
+++				<p>{{ note }}</p>
++ 			{% endfor %}
++ 		</div>
++ 	{% endif %}
++ {% endmacro %}
++ 
++ {% macro footer(metadata) %}
++-	<p class="{{ metadata.class }}">
+++	<p class="{{ metadata.class  }}">
++ 		{{ metadata.ext_name }} {{ metadata.ext_ver }} &copy; {{ metadata.ext_copyright }}
++ 		{% if metadata.lang_ver is defined %}
++ 			<br>
++-			{{ metadata.lang_desc|e('html') }} {{ metadata.lang_ver|e('html') }} &copy; {{ metadata.lang_author|e('html') }}
+++			{{ metadata.lang_desc|e('html') }} {{ metadata.lang_ver|e('html') }} &bull; {{ metadata.lang_author|e('html') }}
++ 		{% endif %}
++ 	</p>
++ {% endmacro %}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\limitreplies/adm/style/acp_limitreplies_settings.js" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\limitreplies/adm/style/acp_limitreplies_settings.js"
++deleted file mode 100644
++index c42f9deb0..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\limitreplies/adm/style/acp_limitreplies_settings.js"
+++++ /dev/null
++@@ -1,51 +0,0 @@
++-/**
++-*
++-* Limit Multiple Replies. An extension for the phpBB Forum Software package.
++-*
++-* @copyright (c) 2024, LukeWCS, https://github.com/LukeWCS
++-* @license GNU General Public License, version 2 (GPL-2.0-only)
++-*
++-* Note: This extension is 100% genuine handcraft and consists of selected
++-*       natural raw materials. There was no AI involved in making it.
++-*
++-*/
++-
++-(function ($) {
++-	'use strict';
++-
++-	const constants = Object.freeze({
++-		OpacityEnabled	: '1.0',
++-		OpacityDisabled	: '0.35',
++-	});
++-
++-	function setState() {
++-		dimOptionGroup('[name="limitreplies_number_wait_time"]', !$('[name="limitreplies_switch_enable"]').prop('checked'));
++-		dimOptionGroup('[name="limitreplies_select_hint_mode"]', !$('[name="limitreplies_switch_enable"]').prop('checked'));
++-	};
++-
++-	function dimOptionGroup(selector, dimCondition) {
++-		const c = constants;
++-
++-		$(selector).parents('dl').css('opacity', dimCondition ? c.OpacityDisabled : c.OpacityEnabled);
++-	}
++-
++-	function formReset() {
++-		setTimeout(function() {
++-			setState();
++-		});
++-	};
++-
++-	function disableEnter(e) {
++-		if (e.key == 'Enter' && e.target.type != 'textarea') {
++-			return false;
++-		}
++-	};
++-
++-	$(function() {
++-		setState();
++-
++-		$('#limitreplies_settings')				.on('keypress'	, disableEnter);
++-		$('#limitreplies_settings')				.on('reset'		, formReset);
++-		$('[name="limitreplies_switch_enable"]').on('change'	, setState);
++-	});
++-})(jQuery);
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\limitreplies/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\limitreplies/composer.json"
++index 63cd7d3bd..4b072e3da 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\limitreplies/composer.json"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\limitreplies/composer.json"
++@@ -3,8 +3,8 @@
++ 	"type": "phpbb-extension",
++ 	"description": "Forces a waiting period between two posts in a topic if the last post was from the same user. Posts in the topic’s moderation queue are also taken into account.",
++ 	"homepage": "https://github.com/LukeWCS/limit-multiple-replies",
++-	"version": "1.1.1",
++-	"time": "2026-06-14",
+++	"version": "1.0.2",
+++	"time": "2024-12-13",
++ 	"license": "GPL-2.0-only",
++ 	"authors": [
++         {
++@@ -14,12 +14,12 @@
++ 		}
++ 	],
++ 	"require": {
++-		"php": ">=8.0.0,<8.6.0@dev",
++-        "composer/installers": "^1.0 || ^2.0"
+++		"php": ">=7.4.0,<8.5.0@dev",
+++        "composer/installers": "~1.0.0"
++ 	},
++ 	"extra": {
++ 		"display-name": "Limit Multiple Replies",
++-        "lang-min-ver": "1.1.0",
+++        "lang-min-ver": "1.0.0",
++ 		"soft-require": {
++ 			"phpbb/phpbb": ">=3.3.2,<3.4.0@dev"
++ 		},
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\limitreplies/controller/acp_limitreplies_controller.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\limitreplies/controller/acp_limitreplies_controller.php"
++index 1bfe49149..aaa3e1fd5 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\limitreplies/controller/acp_limitreplies_controller.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\limitreplies/controller/acp_limitreplies_controller.php"
++@@ -15,18 +15,30 @@ namespace lukewcs\limitreplies\controller;
++ 
++ class acp_limitreplies_controller
++ {
++-	private array  $metadata;
++-	public  string $u_action;
+++	protected object $language;
+++	protected object $template;
+++	protected object $config;
+++	protected object $request;
+++	protected object $ext_manager;
+++
+++	protected string $u_action;
+++	private   array  $metadata;
++ 
++ 	public function __construct(
++-		protected \phpbb\language\language $language,
++-		protected \phpbb\template\template $template,
++-		protected \phpbb\config\config $config,
++-		protected \phpbb\request\request $request,
++-		protected \phpbb\extension\manager $ext_manager,
+++		\phpbb\language\language $language,
+++		\phpbb\template\template $template,
+++		\phpbb\config\config $config,
+++		\phpbb\request\request $request,
+++		\phpbb\extension\manager $ext_manager
++ 	)
++ 	{
++-		$this->metadata = $this->ext_manager->create_extension_metadata_manager('lukewcs/limitreplies')->get_metadata('all');
+++		$this->language		= $language;
+++		$this->template		= $template;
+++		$this->config		= $config;
+++		$this->request		= $request;
+++		$this->ext_manager	= $ext_manager;
+++
+++		$this->metadata		= $this->ext_manager->create_extension_metadata_manager('lukewcs/limitreplies')->get_metadata('all');
++ 	}
++ 
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\limitreplies/event/listener.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\limitreplies/event/listener.php"
+index 3b1b6de76..e06ee4bd0 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\limitreplies/event/listener.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\limitreplies/event/listener.php"
+@@ -17,15 +17,28 @@ use Symfony\Component\EventDispatcher\EventSubscriberInterface;
+ 
+ class listener implements EventSubscriberInterface
+ {
++	protected object $language;
++	protected object $template;
++	protected object $config;
++	protected object $auth;
++	protected object $user;
++	protected object $db;
++
+ 	public function __construct(
+-		protected \phpbb\language\language $language,
+-		protected \phpbb\template\template $template,
+-		protected \phpbb\config\config $config,
+-		protected \phpbb\auth\auth $auth,
+-		protected \phpbb\user $user,
+-		protected \phpbb\db\driver\driver_interface $db,
++		\phpbb\language\language $language,
++		\phpbb\template\template $template,
++		\phpbb\config\config $config,
++		\phpbb\auth\auth $auth,
++		\phpbb\user $user,
++		\phpbb\db\driver\driver_interface $db
+ 	)
+ 	{
++		$this->language	= $language;
++		$this->template	= $template;
++		$this->config	= $config;
++		$this->auth		= $auth;
++		$this->user		= $user;
++		$this->db		= $db;
+ 	}
+ 
+ 	public static function getSubscribedEvents(): array
+@@ -96,7 +109,7 @@ class listener implements EventSubscriberInterface
+ 
+ 	private function get_lock_time(array $topic_data): int
+ 	{
+-		$wait_time			= strtotime($this->config['limitreplies_number_wait_time'] . ' ' . $this->config['limitreplies_select_time_unit'], 0);
++		$wait_time			= $this->config['limitreplies_number_wait_time'] * 60;
+ 		$locked_until_time	= 0;
+ 
+ 		/* Check whether there are posts in the queue of the topic. */
+@@ -126,7 +139,7 @@ class listener implements EventSubscriberInterface
+ 			$locked_until_time = $topic_data['topic_last_post_time'] + $wait_time;
+ 		}
+ 
+-		return ($locked_until_time > time()) ? $locked_until_time : 0;
++		return $locked_until_time > time() ? $locked_until_time : 0;
+ 	}
+ 
+ 	private function create_message(int $locked_until_time): string
+@@ -134,8 +147,7 @@ class listener implements EventSubscriberInterface
+ 		$this->language->add_lang('limitreplies', 'lukewcs/limitreplies');
+ 
+ 		return $this->language->lang('LIMITREPLIES_MSG_REPLY_DENIED',
+-			$this->language->lang('LIMITREPLIES_PLURAL_' . strtoupper($this->config['limitreplies_select_time_unit']),
+-				(int) $this->config['limitreplies_number_wait_time']),
++			$this->language->lang('LIMITREPLIES_MINUTES_PLURAL', (int) $this->config['limitreplies_number_wait_time']),
+ 			$this->user->format_date($locked_until_time)
+ 		);
+ 	}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\limitreplies/ext.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\limitreplies/ext.php"
+index edfbe4efe..8ad4bc449 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\limitreplies/ext.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\limitreplies/ext.php"
+@@ -18,7 +18,7 @@ class ext extends \phpbb\extension\base
+ 	public function is_enableable()
+ 	{
+ 		$valid_phpbb = phpbb_version_compare(PHPBB_VERSION, '3.3.2', '>=') && phpbb_version_compare(PHPBB_VERSION, '3.4.0-dev', '<');
+-		$valid_php = phpbb_version_compare(PHP_VERSION, '8.0.0', '>=') && phpbb_version_compare(PHP_VERSION, '8.6.0-dev', '<');
++		$valid_php = phpbb_version_compare(PHP_VERSION, '7.4.0', '>=') && phpbb_version_compare(PHP_VERSION, '8.5.0-dev', '<');
+ 
+ 		return $valid_phpbb && $valid_php;
+ 	}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\limitreplies/language/de/acp_limitreplies.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\limitreplies/language/de/acp_limitreplies.php"
+index 565916e86..d1fdfa4ac 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\limitreplies/language/de/acp_limitreplies.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\limitreplies/language/de/acp_limitreplies.php"
+@@ -48,9 +48,7 @@ $lang = array_merge($lang, [
+ 	'LIMITREPLIES_ENABLE_EXPLAIN'		=> 'Mit diesem Schalter kannst du die Funktionalität deaktivieren, ohne die Erweiterung komplett deaktivieren zu müssen.',
+ 	'LIMITREPLIES_WAIT_TIME'			=> 'Wartezeit zwischen zwei Beiträgen',
+ 	'LIMITREPLIES_WAIT_TIME_EXPLAIN'	=> 'Hier kannst du festlegen, nach welcher Wartezeit eine erneute Antwort im Thema erlaubt ist, wenn der letzte Beitrag vom selben Benutzer stammt. Dieser Wert wird auch in der Erklärung angezeigt.',
+-	'LIMITREPLIES_TIME_UNIT_MINUTES'	=> 'Minuten',
+-	'LIMITREPLIES_TIME_UNIT_HOURS'		=> 'Stunden',
+-	'LIMITREPLIES_TIME_UNIT_DAYS'		=> 'Tage',
++	'LIMITREPLIES_MINUTES'				=> 'Minuten',
+ 	'LIMITREPLIES_HINT_MODE'			=> 'Erklärung anzeigen',
+ 	'LIMITREPLIES_HINT_MODE_EXPLAIN'	=> 'Hier kann festgelegt werden, auf welche Weise die Erklärung bei aktiver Sperre angezeigt werden soll. Die Option „Bei Klick“ bezieht sich auf die Antworten- und Zitat-Buttons. Bei der Option „Immer“ wird die Erklärung unterhalb der Antworten-Buttons angezeigt.',
+ 	'LIMITREPLIES_HINT_MODE_ONCLICK'	=> 'Bei Klick (als Info-Popup)',
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\limitreplies/language/de/limitreplies.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\limitreplies/language/de/limitreplies.php"
+index 2f413482a..1395d3e2d 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\limitreplies/language/de/limitreplies.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\limitreplies/language/de/limitreplies.php"
+@@ -41,16 +41,8 @@ if (empty($lang) || !is_array($lang))
+ 
+ $lang = array_merge($lang, [
+ 	'LIMITREPLIES_MSG_REPLY_DENIED'	=> 'Solange der letzte Beitrag in diesem Thema von dir stammt und jünger ist als <strong>%1$s</strong>, kannst du erst ab <strong>%2$s</strong> erneut antworten.',
+-	'LIMITREPLIES_PLURAL_MINUTES'	=> [
++	'LIMITREPLIES_MINUTES_PLURAL'	=> [
+ 		1							=> '1 Minute',
+ 		2							=> '%u Minuten',
+ 	],
+-	'LIMITREPLIES_PLURAL_HOURS'		=> [
+-		1							=> '1 Stunde',
+-		2							=> '%u Stunden',
+-	],
+-	'LIMITREPLIES_PLURAL_DAYS'		=> [
+-		1							=> '1 Tag',
+-		2							=> '%u Tage',
+-	],
+ ]);
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\limitreplies/language/de/limitreplies_lang_author.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\limitreplies/language/de/limitreplies_lang_author.php"
+index c97d911e7..e7ef2e143 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\limitreplies/language/de/limitreplies_lang_author.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\limitreplies/language/de/limitreplies_lang_author.php"
+@@ -41,7 +41,7 @@ if (empty($lang) || !is_array($lang))
+ 
+ $lang = array_merge($lang, [
+ 	'LIMITREPLIES_LANG_DESC'					=> 'Deutsch (Du)',
+-	'LIMITREPLIES_LANG_VER'	 					=> '1.1.0',
++	'LIMITREPLIES_LANG_VER'	 					=> '1.0.0',
+ 	'LIMITREPLIES_LANG_AUTHOR'	 				=> 'LukeWCS',
+ 
+ 	'LIMITREPLIES_MSG_LANGUAGEPACK_OUTDATED'	=> 'Hinweis: Das Sprachpaket der Erweiterung <strong>%1$s</strong> ist nicht mehr aktuell. (vorhanden: %2$s / benötigt: %3$s)',
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\limitreplies/language/de_x_sie/acp_limitreplies.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\limitreplies/language/de_x_sie/acp_limitreplies.php"
+index 9fee8bf28..ad7b454ae 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\limitreplies/language/de_x_sie/acp_limitreplies.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\limitreplies/language/de_x_sie/acp_limitreplies.php"
+@@ -48,9 +48,7 @@ $lang = array_merge($lang, [
+ 	'LIMITREPLIES_ENABLE_EXPLAIN'		=> 'Mit diesem Schalter können Sie die Funktionalität deaktivieren, ohne die Erweiterung komplett deaktivieren zu müssen.',
+ 	'LIMITREPLIES_WAIT_TIME'			=> 'Wartezeit zwischen zwei Beiträgen',
+ 	'LIMITREPLIES_WAIT_TIME_EXPLAIN'	=> 'Hier können Sie festlegen, nach welcher Wartezeit eine erneute Antwort im Thema erlaubt ist, wenn der letzte Beitrag vom selben Benutzer stammt. Dieser Wert wird auch in der Erklärung angezeigt.',
+-	'LIMITREPLIES_TIME_UNIT_MINUTES'	=> 'Minuten',
+-	'LIMITREPLIES_TIME_UNIT_HOURS'		=> 'Stunden',
+-	'LIMITREPLIES_TIME_UNIT_DAYS'		=> 'Tage',
++	'LIMITREPLIES_MINUTES'				=> 'Minuten',
+ 	'LIMITREPLIES_HINT_MODE'			=> 'Erklärung anzeigen',
+ 	'LIMITREPLIES_HINT_MODE_EXPLAIN'	=> 'Hier kann festgelegt werden, auf welche Weise die Erklärung bei aktiver Sperre angezeigt werden soll. Die Option „Bei Klick“ bezieht sich auf die Antworten- und Zitat-Buttons. Bei der Option „Immer“ wird die Erklärung unterhalb der Antworten-Buttons angezeigt.',
+ 	'LIMITREPLIES_HINT_MODE_ONCLICK'	=> 'Bei Klick (als Info-Popup)',
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\limitreplies/language/de_x_sie/limitreplies.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\limitreplies/language/de_x_sie/limitreplies.php"
+index 196ea90c1..244e6b2ea 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\limitreplies/language/de_x_sie/limitreplies.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\limitreplies/language/de_x_sie/limitreplies.php"
+@@ -41,16 +41,8 @@ if (empty($lang) || !is_array($lang))
+ 
+ $lang = array_merge($lang, [
+ 	'LIMITREPLIES_MSG_REPLY_DENIED'	=> 'Solange der letzte Beitrag in diesem Thema von Ihnen stammt und jünger ist als <strong>%1$s</strong>, können Sie erst ab <strong>%2$s</strong> erneut antworten.',
+-	'LIMITREPLIES_PLURAL_MINUTES'	=> [
++	'LIMITREPLIES_MINUTES_PLURAL' 	=> [
+ 		1							=> '1 Minute',
+ 		2							=> '%u Minuten',
+ 	],
+-	'LIMITREPLIES_PLURAL_HOURS'		=> [
+-		1							=> '1 Stunde',
+-		2							=> '%u Stunden',
+-	],
+-	'LIMITREPLIES_PLURAL_DAYS'		=> [
+-		1							=> '1 Tag',
+-		2							=> '%u Tage',
+-	],
+ ]);
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\limitreplies/language/de_x_sie/limitreplies_lang_author.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\limitreplies/language/de_x_sie/limitreplies_lang_author.php"
+index e7303f58e..64d0ee896 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\limitreplies/language/de_x_sie/limitreplies_lang_author.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\limitreplies/language/de_x_sie/limitreplies_lang_author.php"
+@@ -41,7 +41,7 @@ if (empty($lang) || !is_array($lang))
+ 
+ $lang = array_merge($lang, [
+ 	'LIMITREPLIES_LANG_DESC'					=> 'Deutsch (Sie)',
+-	'LIMITREPLIES_LANG_VER'		 				=> '1.1.0',
++	'LIMITREPLIES_LANG_VER'		 				=> '1.0.0',
+ 	'LIMITREPLIES_LANG_AUTHOR'	 				=> 'LukeWCS',
+ 
+ 	'LIMITREPLIES_MSG_LANGUAGEPACK_OUTDATED'	=> 'Hinweis: Das Sprachpaket der Erweiterung <strong>%1$s</strong> ist nicht mehr aktuell. (vorhanden: %2$s / benötigt: %3$s)',
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\limitreplies/language/en/acp_limitreplies.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\limitreplies/language/en/acp_limitreplies.php"
+index dad19a978..7e70cdc7a 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\limitreplies/language/en/acp_limitreplies.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\limitreplies/language/en/acp_limitreplies.php"
+@@ -48,9 +48,7 @@ $lang = array_merge($lang, [
+ 	'LIMITREPLIES_ENABLE_EXPLAIN'		=> 'With this switch you can deactivate the functionality without having to deactivate the extension completely.',
+ 	'LIMITREPLIES_WAIT_TIME'			=> 'Waiting period between two posts',
+ 	'LIMITREPLIES_WAIT_TIME_EXPLAIN'	=> 'Here you can specify after which waiting period a new reply is allowed in the topic if the last post was made by the same user. This value is also displayed in the explanation.',
+-	'LIMITREPLIES_TIME_UNIT_MINUTES'	=> 'minutes',
+-	'LIMITREPLIES_TIME_UNIT_HOURS'		=> 'hours',
+-	'LIMITREPLIES_TIME_UNIT_DAYS'		=> 'days',
++	'LIMITREPLIES_MINUTES'				=> 'minutes',
+ 	'LIMITREPLIES_HINT_MODE'			=> 'Show explanation',
+ 	'LIMITREPLIES_HINT_MODE_EXPLAIN'	=> 'Here you can specify how the explanation should be displayed when the lock is active. The “On click” option refers to the reply and quote buttons. With the “Always” option, the explanation is displayed below the reply buttons.',
+ 	'LIMITREPLIES_HINT_MODE_ONCLICK'	=> 'On click (as info popup)',
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\limitreplies/language/en/limitreplies.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\limitreplies/language/en/limitreplies.php"
+index 512130ec8..24abb6433 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\limitreplies/language/en/limitreplies.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\limitreplies/language/en/limitreplies.php"
+@@ -41,16 +41,8 @@ if (empty($lang) || !is_array($lang))
+ 
+ $lang = array_merge($lang, [
+ 	'LIMITREPLIES_MSG_REPLY_DENIED'	=> 'As long as the last post in this topic was from you and is newer than <strong>%1$s</strong>, you can only reply again from <strong>%2$s</strong>.',
+-	'LIMITREPLIES_PLURAL_MINUTES'	=> [
++	'LIMITREPLIES_MINUTES_PLURAL' 	=> [
+ 		1							=> '1 minute',
+ 		2							=> '%u minutes',
+ 	],
+-	'LIMITREPLIES_PLURAL_HOURS'		=> [
+-		1							=> '1 hour',
+-		2							=> '%u hours',
+-	],
+-	'LIMITREPLIES_PLURAL_DAYS'		=> [
+-		1							=> '1 day',
+-		2							=> '%u days',
+-	],
+ ]);
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\limitreplies/language/en/limitreplies_lang_author.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\limitreplies/language/en/limitreplies_lang_author.php"
+index 267c7545b..4025740e7 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\limitreplies/language/en/limitreplies_lang_author.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\limitreplies/language/en/limitreplies_lang_author.php"
+@@ -41,7 +41,7 @@ if (empty($lang) || !is_array($lang))
+ 
+ $lang = array_merge($lang, [
+ 	'LIMITREPLIES_LANG_DESC'					=> 'English',
+-	'LIMITREPLIES_LANG_VER'	 					=> '1.1.0',
++	'LIMITREPLIES_LANG_VER'	 					=> '1.0.0',
+ 	'LIMITREPLIES_LANG_AUTHOR'	 				=> 'LukeWCS',
+ 
+ 	'LIMITREPLIES_MSG_LANGUAGEPACK_OUTDATED'	=> 'Note: The language pack for the <strong>%1$s</strong> extension is no longer up to date. (available: %2$s / required: %3$s)',
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\limitreplies/migrations/v_1_1_0.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\limitreplies/migrations/v_1_1_0.php"
+deleted file mode 100644
+index 5c90bcfa1..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\limitreplies/migrations/v_1_1_0.php"
++++ /dev/null
+@@ -1,29 +0,0 @@
+-<?php
+-/**
+-*
+-* Limit Multiple Replies. An extension for the phpBB Forum Software package.
+-*
+-* @copyright (c) 2024, LukeWCS, https://github.com/LukeWCS
+-* @license GNU General Public License, version 2 (GPL-2.0-only)
+-*
+-* Note: This extension is 100% genuine handcraft and consists of selected
+-*       natural raw materials. There was no AI involved in making it.
+-*
+-*/
+-
+-namespace lukewcs\limitreplies\migrations;
+-
+-class v_1_1_0 extends \phpbb\db\migration\migration
+-{
+-	public static function depends_on()
+-	{
+-		return ['\lukewcs\limitreplies\migrations\v_1_0_0'];
+-	}
+-
+-	public function update_data()
+-	{
+-		return [
+-			['config.add', ['limitreplies_select_time_unit', 'minutes']],
+-		];
+-	}
+-}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\limitreplies/styles/all/template/event/viewtopic_body_footer_before.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\limitreplies/styles/all/template/event/viewtopic_body_footer_before.html"
+index 5726a9fa7..d34e6df69 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\limitreplies/styles/all/template/event/viewtopic_body_footer_before.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\limitreplies/styles/all/template/event/viewtopic_body_footer_before.html"
+@@ -10,11 +10,6 @@
+ *
+ #}
+ 
+-{% set const = {
+-	HINT_MODE_ONCLICK	: 1,
+-	HINT_MODE_ALWAYS	: 2,
+-} %}
+-
+-{% if LIMITREPLIES_SELECT_HINT_MODE == const.HINT_MODE_ALWAYS %}
++{% if (LIMITREPLIES_SELECT_HINT_MODE ?? 0) == 2 %}
+ 	{% INCLUDE '@lukewcs_limitreplies/show_message.html' %}
+ {% endif %}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\limitreplies/styles/all/template/event/viewtopic_body_poll_before.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\limitreplies/styles/all/template/event/viewtopic_body_poll_before.html"
+index b25dd163e..116c3c3c0 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\limitreplies/styles/all/template/event/viewtopic_body_poll_before.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\limitreplies/styles/all/template/event/viewtopic_body_poll_before.html"
+@@ -10,13 +10,10 @@
+ *
+ #}
+ 
+-{% set const = {
+-	HINT_MODE_ONCLICK	: 1,
+-	HINT_MODE_ALWAYS	: 2,
+-} %}
+-
+ {% if LIMITREPLIES_MESSAGE is defined %}
+-	{% if LIMITREPLIES_SELECT_HINT_MODE == const.HINT_MODE_ALWAYS %}
++	{% INCLUDEJS '@lukewcs_limitreplies/limitreplies.js' %}
++	{% INCLUDECSS '@lukewcs_limitreplies/limitreplies.css' %}
++	{% if LIMITREPLIES_SELECT_HINT_MODE == 2 %}
+ 		{% INCLUDE '@lukewcs_limitreplies/show_message.html' %}
+ 	{% endif %}
+ 
+@@ -27,7 +24,4 @@
+ 			HintMode		: {{ LIMITREPLIES_SELECT_HINT_MODE|json_encode }},
+ 		});
+ 	</script>
+-
+-	{% INCLUDEJS '@lukewcs_limitreplies/limitreplies.js' %}
+-	{% INCLUDECSS '@lukewcs_limitreplies/limitreplies.css' %}
+ {% endif %}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\limitreplies/styles/all/template/limitreplies.js" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\limitreplies/styles/all/template/limitreplies.js"
+index d1202408a..97102de2f 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\limitreplies/styles/all/template/limitreplies.js"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\limitreplies/styles/all/template/limitreplies.js"
+@@ -11,21 +11,23 @@
+ */
+ 
+ (function ($) {
+-	'use strict';
+ 
+-	const HintModeOnClick	= 1;
+-	const HintModeAlways	= 2;
++'use strict';
+ 
+-	$(function () {
+-		$('a[href*="mode=quote"],a[href*="mode=reply"]').on('click', function (e) {
+-			e.preventDefault();
+-			if (LimitReplies.HintMode == HintModeOnClick) {
+-				phpbb.alert(LimitReplies.MessageTitle, LimitReplies.MessageText);
+-			}
+-		});
++const HintModeOnClick	= 1;
++const HintModeAlways	= 2;
+ 
+-		if (LimitReplies.HintMode == HintModeAlways) {
+-			$('a[href*="mode=quote"],a[href*="mode=reply"]').addClass('limitreplies_lock');
+-		};
++$(function () {
++	$('a[href*="mode=quote"],a[href*="mode=reply"]').on('click', function (e) {
++		e.preventDefault();
++		if (LimitReplies.HintMode == HintModeOnClick) {
++			phpbb.alert(LimitReplies.MessageTitle, LimitReplies.MessageText);
++		}
+ 	});
++
++	if (LimitReplies.HintMode == HintModeAlways) {
++		$('a[href*="mode=quote"],a[href*="mode=reply"]').addClass('limitreplies_lock');
++	};
++});
++
+ })(jQuery);
diff --git "[FORUM_EXT]/lukewcs\\limitreplies/diff_nospace.tmp" "[FORUM_EXT]/lukewcs\\limitreplies/diff_nospace.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/lukewcs\\limitreplies/diff_nospace.tmp"
@@ -0,0 +1,1647 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\limitreplies/adm/style/acp_limitreplies_settings.css" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\limitreplies/adm/style/acp_limitreplies_settings.css"
+index 503e96a9e..8127c3739 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\limitreplies/adm/style/acp_limitreplies_settings.css"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\limitreplies/adm/style/acp_limitreplies_settings.css"
+@@ -1,4 +1,4 @@
+-/* GENERAL >>> */
++/* GENERAL */
+ 
+ .limitreplies_footer {
+ 	margin-top: 1em;
+@@ -6,12 +6,9 @@
+ 	font-size: 0.75em;
+ }
+ 
+-/* <<< GENERAL */
++/* SETTINGS */
+ 
+-/* SETTINGS >>> */
+-
+-fieldset {}
+-	& legend {
++fieldset legend {
+ 	top: 0;
+ 	margin-left: -11px;
+ 	padding: 2px 10px;
+@@ -21,18 +18,13 @@ fieldset {}
+ 	background-color: inherit;
+ }
+ 
+-	& dt label {
++fieldset dt label {
+ 	cursor: inherit;
+ }
+ 
+-	& p.submit-buttons {
++fieldset p.submit-buttons {
+ 	margin-top: 0;
+ 	padding: 0 4px 4px 4px;
+-
+-		& input:is([type="submit"], [type="reset"], [type="button"]) {
+-			padding: 3px 4px;
+-		}
+-	}
+ }
+ 
+ code {
+@@ -41,65 +33,61 @@ code {
+ 	color: black;
+ }
+ 
+-.toggle {
+-	/* phpBB Kirk Toggles 2.0 - A CSS class that makes it easy to display checkboxes as toggles.
+-	   Source     : https://danklammer.com/articles/simple-css-toggle-switch/
+-	   Revision by: Kirk (customization and optimization), LukeWCS (optimization) */
+-
+-	/* Kirk style: */
+-	/* --background-transition: ease 0.3s; */
+-	/* --background-color-off: #a00; */
+-	/* --background-color-on: #3fa651; */
+-	/* --slider-transition: all cubic-bezier(0.3, 1.5, 0.7, 1) 0.3s; */
++/*
++* phpBB ACP Toggles - A CSS class that makes it easy to display checkboxes as toggles.
++* Source     : https://danklammer.com/articles/simple-css-toggle-switch/
++* Revision by: Kirk (customization and optimization), LukeWCS (optimization)
++*/
+ 
++.toggle {
++	-webkit-appearance: none;
++	-moz-appearance: none;
+ 	appearance: none;
+-	position: relative;
+ 	width: 38px;
+ 	height: 17px;
++	position: relative;
+ 	border-radius: 50px;
+ 	cursor: pointer;
+ 	font-family: FontAwesome;
+-	transition: var(--background-transition, 0.2s);
+-
+-	&,
+-	&:hover,
+-	&:focus {
+-		background: var(--background-color-off, #ccc);
+-		border: none;
+-		color: #000;
++	transition: background-color 0.2s;
+ }
+ 
+-	&:before {
+-		content: "\f00d";
+-		justify-content: center;
++.toggle:before {
+ 	position: absolute;
+-		top: 2px;
+-		left: 22px;
+ 	width: 14px;
+ 	height: 13px;
+-		background: #fff;
++	background-color: #ffffff;
++	top: 2px;
+ 	border-radius: 50%;
+ 	display: flex;
++	justify-content: center;
+ 	align-items: center;
+-		transition: var(--slider-transition, 0.2s);
++	left: 22px;
++	content: "\f00d";
++	transition: 0.2s;
+ }
+ 
+-	&:checked {
+-		background: var(--background-color-on, #3b87ab);
+-
+-		&:before {
+-			content: "\f00c";
+-			left: 2px;
+-		}
++.toggle,
++.toggle:hover,
++.toggle:focus {
++	background-color: #cccccc;
++	border: none;
++	color: #000000;
+ }
++
++.toggle:checked {
++	background-color: #3b87ab;
+ }
+ 
+-/* <<< SETTINGS */
++.toggle:checked:before {
++	left: 2px;
++	content: "\f00c";
++}
+ 
+-/* RESPONSIVE >>> */
++/* RESPONSIVE */
+ 
+ @media (max-width: 700px) {
+-	fieldset legend {
++	legend {
+ 		margin-left: -6px;
+ 		padding: 2px 5px;
+ 	}
+@@ -108,5 +96,3 @@ code {
+ 		margin-top: 0.5em;
+ 	}
+ }
+-
+-/* <<< RESPONSIVE */
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\limitreplies/adm/style/acp_limitreplies_settings.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\limitreplies/adm/style/acp_limitreplies_settings.html"
+index 31eca30cb..d89ab32df 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\limitreplies/adm/style/acp_limitreplies_settings.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\limitreplies/adm/style/acp_limitreplies_settings.html"
+@@ -12,6 +12,8 @@
+ 
+ {% INCLUDE 'overall_header.html' %}
+ 
++{% set switch_type = TOGGLECTRL_TYPE ?? 'toggle' %}
++
+ <a id="maincontent"></a>
+ 
+ <h1>{{ lang('LIMITREPLIES_CONFIG_TITLE') }}</h1>
+@@ -29,7 +31,7 @@
+ 				<span>{{ lang('LIMITREPLIES_ENABLE_EXPLAIN') }}</span>
+ 			</dt>
+ 			<dd>
+-				{{ _self.switch('limitreplies_switch_enable', LIMITREPLIES_SWITCH_ENABLE) }}
++				{{ _self.switch('limitreplies_switch_enable', LIMITREPLIES_SWITCH_ENABLE, switch_type) }}
+ 			</dd>
+ 		</dl>
+ 
+@@ -39,8 +41,8 @@
+ 				<span>{{ lang('LIMITREPLIES_WAIT_TIME_EXPLAIN') }}</span>
+ 			</dt>
+ 			<dd>
+-				{{ _self.number('limitreplies_number_wait_time', LIMITREPLIES_NUMBER_WAIT_TIME, 1, 999) }}
+-				{{ _self.select('limitreplies_select_time_unit', LIMITREPLIES_SELECT_TIME_UNIT_OPTS) }}
++				{{ _self.number('limitreplies_number_wait_time', LIMITREPLIES_NUMBER_WAIT_TIME, 1, 999999) }}
++				{{ lang('LIMITREPLIES_MINUTES') }}
+ 			</dd>
+ 		</dl>
+ 
+@@ -73,17 +75,14 @@
+ {% INCLUDE 'overall_footer.html' %}
+ 
+ {% INCLUDECSS '@lukewcs_limitreplies/acp_limitreplies_settings.css' %}
+-{% INCLUDEJS '@lukewcs_limitreplies/acp_limitreplies_settings.js' %}
+ 
+-{% macro switch(name, checked = false, type = null) -%}
+-	{% set type = type ?? (TOGGLECTRL_TYPE in ['toggle', 'checkbox', 'radio'] ? TOGGLECTRL_TYPE : 'toggle') -%}
+-	{% if type in ['toggle', 'checkbox'] -%}
++{% macro switch(name, checked = false, type = 'toggle') -%}
++	{% if type == 'toggle' || type == 'checkbox' -%}
+ 		<input type="checkbox" class="{{ type }}" name="{{ name }}" value="1"{{ checked ? ' checked' }}>
+ 	{%- elseif type == 'radio' -%}
+ 		<label><input type="radio" class="radio" name="{{ name }}" value="1"{{ checked ? ' checked' }}> {{ lang('YES') }}</label>
+ 		<label><input type="radio" class="radio" name="{{ name }}" value="0"{{ !checked ? ' checked' }}> {{ lang('NO') }}</label>
+ 	{%- endif %}
+-	{#- v1.3.1 #}
+ {%- endmacro %}
+ 
+ {% macro number(name, value, min = null, max = null, step = null, placeholder = null) -%}
+@@ -110,11 +109,10 @@
+ {%- endmacro %}
+ 
+ {% macro notes(notes) %}
+-	{% set note_dot = notes|length > 1 ? '&bull; ' %}
+ 	{% if notes|length %}
+ 		<div class="successbox notice">
+ 			{% for note in notes %}
+-				<p>{{ note_dot }}{{ note }}</p>
++				<p>{{ note }}</p>
+ 			{% endfor %}
+ 		</div>
+ 	{% endif %}
+@@ -125,7 +123,7 @@
+ 		{{ metadata.ext_name }} {{ metadata.ext_ver }} &copy; {{ metadata.ext_copyright }}
+ 		{% if metadata.lang_ver is defined %}
+ 			<br>
+-			{{ metadata.lang_desc|e('html') }} {{ metadata.lang_ver|e('html') }} &copy; {{ metadata.lang_author|e('html') }}
++			{{ metadata.lang_desc|e('html') }} {{ metadata.lang_ver|e('html') }} &bull; {{ metadata.lang_author|e('html') }}
+ 		{% endif %}
+ 	</p>
+ {% endmacro %}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\limitreplies/adm/style/acp_limitreplies_settings.js" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\limitreplies/adm/style/acp_limitreplies_settings.js"
+deleted file mode 100644
+index c42f9deb0..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\limitreplies/adm/style/acp_limitreplies_settings.js"
++++ /dev/null
+@@ -1,51 +0,0 @@
+-/**
+-*
+-* Limit Multiple Replies. An extension for the phpBB Forum Software package.
+-*
+-* @copyright (c) 2024, LukeWCS, https://github.com/LukeWCS
+-* @license GNU General Public License, version 2 (GPL-2.0-only)
+-*
+-* Note: This extension is 100% genuine handcraft and consists of selected
+-*       natural raw materials. There was no AI involved in making it.
+-*
+-*/
+-
+-(function ($) {
+-	'use strict';
+-
+-	const constants = Object.freeze({
+-		OpacityEnabled	: '1.0',
+-		OpacityDisabled	: '0.35',
+-	});
+-
+-	function setState() {
+-		dimOptionGroup('[name="limitreplies_number_wait_time"]', !$('[name="limitreplies_switch_enable"]').prop('checked'));
+-		dimOptionGroup('[name="limitreplies_select_hint_mode"]', !$('[name="limitreplies_switch_enable"]').prop('checked'));
+-	};
+-
+-	function dimOptionGroup(selector, dimCondition) {
+-		const c = constants;
+-
+-		$(selector).parents('dl').css('opacity', dimCondition ? c.OpacityDisabled : c.OpacityEnabled);
+-	}
+-
+-	function formReset() {
+-		setTimeout(function() {
+-			setState();
+-		});
+-	};
+-
+-	function disableEnter(e) {
+-		if (e.key == 'Enter' && e.target.type != 'textarea') {
+-			return false;
+-		}
+-	};
+-
+-	$(function() {
+-		setState();
+-
+-		$('#limitreplies_settings')				.on('keypress'	, disableEnter);
+-		$('#limitreplies_settings')				.on('reset'		, formReset);
+-		$('[name="limitreplies_switch_enable"]').on('change'	, setState);
+-	});
+-})(jQuery);
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\limitreplies/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\limitreplies/composer.json"
+index 63cd7d3bd..4b072e3da 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\limitreplies/composer.json"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\limitreplies/composer.json"
+@@ -3,8 +3,8 @@
+ 	"type": "phpbb-extension",
+ 	"description": "Forces a waiting period between two posts in a topic if the last post was from the same user. Posts in the topic’s moderation queue are also taken into account.",
+ 	"homepage": "https://github.com/LukeWCS/limit-multiple-replies",
+-	"version": "1.1.1",
+-	"time": "2026-06-14",
++	"version": "1.0.2",
++	"time": "2024-12-13",
+ 	"license": "GPL-2.0-only",
+ 	"authors": [
+         {
+@@ -14,12 +14,12 @@
+ 		}
+ 	],
+ 	"require": {
+-		"php": ">=8.0.0,<8.6.0@dev",
+-        "composer/installers": "^1.0 || ^2.0"
++		"php": ">=7.4.0,<8.5.0@dev",
++        "composer/installers": "~1.0.0"
+ 	},
+ 	"extra": {
+ 		"display-name": "Limit Multiple Replies",
+-        "lang-min-ver": "1.1.0",
++        "lang-min-ver": "1.0.0",
+ 		"soft-require": {
+ 			"phpbb/phpbb": ">=3.3.2,<3.4.0@dev"
+ 		},
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\limitreplies/controller/acp_limitreplies_controller.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\limitreplies/controller/acp_limitreplies_controller.php"
+index 1bfe49149..aaa3e1fd5 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\limitreplies/controller/acp_limitreplies_controller.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\limitreplies/controller/acp_limitreplies_controller.php"
+@@ -15,17 +15,29 @@ namespace lukewcs\limitreplies\controller;
+ 
+ class acp_limitreplies_controller
+ {
++	protected object $language;
++	protected object $template;
++	protected object $config;
++	protected object $request;
++	protected object $ext_manager;
++
++	protected string $u_action;
+ 	private   array  $metadata;
+-	public  string $u_action;
+ 
+ 	public function __construct(
+-		protected \phpbb\language\language $language,
+-		protected \phpbb\template\template $template,
+-		protected \phpbb\config\config $config,
+-		protected \phpbb\request\request $request,
+-		protected \phpbb\extension\manager $ext_manager,
++		\phpbb\language\language $language,
++		\phpbb\template\template $template,
++		\phpbb\config\config $config,
++		\phpbb\request\request $request,
++		\phpbb\extension\manager $ext_manager
+ 	)
+ 	{
++		$this->language		= $language;
++		$this->template		= $template;
++		$this->config		= $config;
++		$this->request		= $request;
++		$this->ext_manager	= $ext_manager;
++
+ 		$this->metadata		= $this->ext_manager->create_extension_metadata_manager('lukewcs/limitreplies')->get_metadata('all');
+ 	}
+ 
+@@ -44,14 +56,14 @@ class acp_limitreplies_controller
+ 			}
+ 
+ 			$this->config->set('limitreplies_switch_enable'		, $this->request->variable('limitreplies_switch_enable'		, 0));
+-			$this->config->set('limitreplies_number_wait_time'	, $this->min_max(1, 999, $this->request->variable('limitreplies_number_wait_time'	, 60)));
+-			$this->config->set('limitreplies_select_time_unit'	, $this->request->variable('limitreplies_select_time_unit'							, 'minutes'));
++			$this->config->set('limitreplies_number_wait_time'	, $this->request->variable('limitreplies_number_wait_time'	, 60));
+ 			$this->config->set('limitreplies_select_hint_mode'	, $this->request->variable('limitreplies_select_hint_mode'	, 1));
+ 
+ 			trigger_error($this->language->lang('LIMITREPLIES_MSG_SETTINGS_SAVED') . adm_back_link($this->u_action));
+ 		}
+ 
+-		if ($lang_outdated_msg = $this->lang_ver_check_msg('LIMITREPLIES_LANG_VER', 'LIMITREPLIES_MSG_LANGUAGEPACK_OUTDATED'))
++		$lang_outdated_msg = $this->lang_ver_check_msg('LIMITREPLIES_LANG_VER', 'LIMITREPLIES_MSG_LANGUAGEPACK_OUTDATED');
++		if ($lang_outdated_msg)
+ 		{
+ 			$notes[] = $lang_outdated_msg;
+ 		}
+@@ -61,11 +73,6 @@ class acp_limitreplies_controller
+ 
+ 			'LIMITREPLIES_SWITCH_ENABLE'			=> (bool) $this->config['limitreplies_switch_enable'],
+ 			'LIMITREPLIES_NUMBER_WAIT_TIME'			=> (int) $this->config['limitreplies_number_wait_time'],
+-			'LIMITREPLIES_SELECT_TIME_UNIT_OPTS'	=> $this->select_struct($this->config['limitreplies_select_time_unit'], [
+-				'LIMITREPLIES_TIME_UNIT_MINUTES'	=> 'minutes',
+-				'LIMITREPLIES_TIME_UNIT_HOURS'		=> 'hours',
+-				'LIMITREPLIES_TIME_UNIT_DAYS'		=> 'days',
+-			]),
+ 			'LIMITREPLIES_SELECT_HINT_MODE_OPTS'	=> $this->select_struct((int) $this->config['limitreplies_select_hint_mode'], [
+ 				'LIMITREPLIES_HINT_MODE_ONCLICK'	=> 1,
+ 				'LIMITREPLIES_HINT_MODE_ALWAYS'		=> 2,
+@@ -80,27 +87,6 @@ class acp_limitreplies_controller
+ 		$this->u_action = $u_action;
+ 	}
+ 
+-	private function select_struct(array|int|string $cfg_value, array $options): array
+-	{
+-		$options_tpl = [];
+-
+-		foreach ($options as $opt_key => $opt_value)
+-		{
+-			if (!is_array($opt_value))
+-			{
+-				$opt_value = [$opt_value];
+-			}
+-			$options_tpl[] = [
+-				'label'		=> $opt_key,
+-				'value'		=> $opt_value[0],
+-				'bold'		=> $opt_value[1] ?? false,
+-				'selected'	=> is_array($cfg_value) ? in_array($opt_value[0], $cfg_value) : $opt_value[0] == $cfg_value,
+-			];
+-		}
+-
+-		return $options_tpl;
+-	}
+-
+ 	private function set_meta_template_vars(string $tpl_prefix, string $copyright): void
+ 	{
+ 		$template_vars = [
+@@ -118,15 +104,6 @@ class acp_limitreplies_controller
+ 		$this->template->assign_vars([$tpl_prefix . '_METADATA' => $template_vars]);
+ 	}
+ 
+-	private function min_max(float|int $min, float|int $max, float|int $value): float|int
+-	{
+-		return match (true) {
+-			$value < $min	=> $min,
+-			$value > $max	=> $max,
+-			default			=> $value,
+-		};
+-	}
+-
+ 	/*
+ 		Determine the version of the language pack with fallback to 0.0.0
+ 	*/
+@@ -160,4 +137,25 @@ class acp_limitreplies_controller
+ 
+ 		return $lang_outdated_msg;
+ 	}
++
++	private function select_struct($cfg_value, array $options): array
++	{
++		$options_tpl = [];
++
++		foreach ($options as $opt_key => $opt_value)
++		{
++			if (!is_array($opt_value))
++			{
++				$opt_value = [$opt_value];
++			}
++			$options_tpl[] = [
++				'label'		=> $opt_key,
++				'value'		=> $opt_value[0],
++				'bold'		=> $opt_value[1] ?? false,
++				'selected'	=> is_array($cfg_value) ? in_array($opt_value[0], $cfg_value) : $opt_value[0] == $cfg_value,
++			];
++		}
++
++		return $options_tpl;
++	}
+ }
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\limitreplies/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\limitreplies/diff_full.tmp"
+new file mode 100644
+index 000000000..aadb50ae8
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\limitreplies/diff_full.tmp"
+@@ -0,0 +1,1225 @@
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\limitreplies/adm/style/acp_limitreplies_settings.css" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\limitreplies/adm/style/acp_limitreplies_settings.css"
++index 503e96a9e..8127c3739 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\limitreplies/adm/style/acp_limitreplies_settings.css"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\limitreplies/adm/style/acp_limitreplies_settings.css"
++@@ -1,4 +1,4 @@
++-/* GENERAL >>> */
+++/* GENERAL */
++ 
++ .limitreplies_footer {
++ 	margin-top: 1em;
++@@ -6,33 +6,25 @@
++ 	font-size: 0.75em;
++ }
++ 
++-/* <<< GENERAL */
+++/* SETTINGS */
++ 
++-/* SETTINGS >>> */
++-
++-fieldset {}
++-	& legend {
++-		top: 0;
++-		margin-left: -11px;
++-		padding: 2px 10px;
++-		border-radius: 5px 5px 0 0;
++-		border-top: inherit;
++-		border-left: inherit;
++-		background-color: inherit;
++-	}
++-
++-	& dt label {
++-		cursor: inherit;
++-	}
+++fieldset legend {
+++	top: 0;
+++	margin-left: -11px;
+++	padding: 2px 10px;
+++	border-radius: 5px 5px 0 0;
+++	border-top: inherit;
+++	border-left: inherit;
+++	background-color: inherit;
+++}
++ 
++-	& p.submit-buttons {
++-		margin-top: 0;
++-		padding: 0 4px 4px 4px;
+++fieldset dt label {
+++	cursor: inherit;
+++}
++ 
++-		& input:is([type="submit"], [type="reset"], [type="button"]) {
++-			padding: 3px 4px;
++-		}
++-	}
+++fieldset p.submit-buttons {
+++	margin-top: 0;
+++	padding: 0 4px 4px 4px;
++ }
++ 
++ code {
++@@ -41,65 +33,61 @@ code {
++ 	color: black;
++ }
++ 
++-.toggle {
++-	/* phpBB Kirk Toggles 2.0 - A CSS class that makes it easy to display checkboxes as toggles.
++-	   Source     : https://danklammer.com/articles/simple-css-toggle-switch/
++-	   Revision by: Kirk (customization and optimization), LukeWCS (optimization) */
++-
++-	/* Kirk style: */
++-	/* --background-transition: ease 0.3s; */
++-	/* --background-color-off: #a00; */
++-	/* --background-color-on: #3fa651; */
++-	/* --slider-transition: all cubic-bezier(0.3, 1.5, 0.7, 1) 0.3s; */
+++/*
+++* phpBB ACP Toggles - A CSS class that makes it easy to display checkboxes as toggles.
+++* Source     : https://danklammer.com/articles/simple-css-toggle-switch/
+++* Revision by: Kirk (customization and optimization), LukeWCS (optimization)
+++*/
++ 
+++.toggle {
+++	-webkit-appearance: none;
+++	-moz-appearance: none;
++ 	appearance: none;
++-	position: relative;
++ 	width: 38px;
++ 	height: 17px;
+++	position: relative;
++ 	border-radius: 50px;
++ 	cursor: pointer;
++ 	font-family: FontAwesome;
++-	transition: var(--background-transition, 0.2s);
++-
++-	&,
++-	&:hover,
++-	&:focus {
++-		background: var(--background-color-off, #ccc);
++-		border: none;
++-		color: #000;
++-	}
+++	transition: background-color 0.2s;
+++}
++ 
++-	&:before {
++-		content: "\f00d";
++-		justify-content: center;
++-		position: absolute;
++-		top: 2px;
++-		left: 22px;
++-		width: 14px;
++-		height: 13px;
++-		background: #fff;
++-		border-radius: 50%;
++-		display: flex;
++-		align-items: center;
++-		transition: var(--slider-transition, 0.2s);
++-	}
+++.toggle:before {
+++	position: absolute;
+++	width: 14px;
+++	height: 13px;
+++	background-color: #ffffff;
+++	top: 2px;
+++	border-radius: 50%;
+++	display: flex;
+++	justify-content: center;
+++	align-items: center;
+++	left: 22px;
+++	content: "\f00d";
+++	transition: 0.2s;
+++}
++ 
++-	&:checked {
++-		background: var(--background-color-on, #3b87ab);
+++.toggle,
+++.toggle:hover,
+++.toggle:focus {
+++	background-color: #cccccc;
+++	border: none;
+++	color: #000000;
+++}
++ 
++-		&:before {
++-			content: "\f00c";
++-			left: 2px;
++-		}
++-	}
+++.toggle:checked {
+++	background-color: #3b87ab;
++ }
++ 
++-/* <<< SETTINGS */
+++.toggle:checked:before {
+++	left: 2px;
+++	content: "\f00c";
+++}
++ 
++-/* RESPONSIVE >>> */
+++/* RESPONSIVE */
++ 
++ @media (max-width: 700px) {
++-	fieldset legend {
+++	legend {
++ 		margin-left: -6px;
++ 		padding: 2px 5px;
++ 	}
++@@ -108,5 +96,3 @@ code {
++ 		margin-top: 0.5em;
++ 	}
++ }
++-
++-/* <<< RESPONSIVE */
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\limitreplies/adm/style/acp_limitreplies_settings.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\limitreplies/adm/style/acp_limitreplies_settings.html"
++index 31eca30cb..d89ab32df 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\limitreplies/adm/style/acp_limitreplies_settings.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\limitreplies/adm/style/acp_limitreplies_settings.html"
++@@ -12,6 +12,8 @@
++ 
++ {% INCLUDE 'overall_header.html' %}
++ 
+++{% set switch_type = TOGGLECTRL_TYPE ?? 'toggle' %}
+++
++ <a id="maincontent"></a>
++ 
++ <h1>{{ lang('LIMITREPLIES_CONFIG_TITLE') }}</h1>
++@@ -29,7 +31,7 @@
++ 				<span>{{ lang('LIMITREPLIES_ENABLE_EXPLAIN') }}</span>
++ 			</dt>
++ 			<dd>
++-				{{ _self.switch('limitreplies_switch_enable', LIMITREPLIES_SWITCH_ENABLE) }}
+++				{{ _self.switch('limitreplies_switch_enable', LIMITREPLIES_SWITCH_ENABLE, switch_type) }}
++ 			</dd>
++ 		</dl>
++ 
++@@ -39,8 +41,8 @@
++ 				<span>{{ lang('LIMITREPLIES_WAIT_TIME_EXPLAIN') }}</span>
++ 			</dt>
++ 			<dd>
++-				{{ _self.number('limitreplies_number_wait_time', LIMITREPLIES_NUMBER_WAIT_TIME, 1, 999) }}
++-				{{ _self.select('limitreplies_select_time_unit', LIMITREPLIES_SELECT_TIME_UNIT_OPTS) }}
+++				{{ _self.number('limitreplies_number_wait_time', LIMITREPLIES_NUMBER_WAIT_TIME, 1, 999999) }}
+++				{{ lang('LIMITREPLIES_MINUTES') }}
++ 			</dd>
++ 		</dl>
++ 
++@@ -73,17 +75,14 @@
++ {% INCLUDE 'overall_footer.html' %}
++ 
++ {% INCLUDECSS '@lukewcs_limitreplies/acp_limitreplies_settings.css' %}
++-{% INCLUDEJS '@lukewcs_limitreplies/acp_limitreplies_settings.js' %}
++ 
++-{% macro switch(name, checked = false, type = null) -%}
++-	{% set type = type ?? (TOGGLECTRL_TYPE in ['toggle', 'checkbox', 'radio'] ? TOGGLECTRL_TYPE : 'toggle') -%}
++-	{% if type in ['toggle', 'checkbox'] -%}
+++{% macro switch(name, checked = false, type = 'toggle') -%}
+++	{% if type == 'toggle' || type == 'checkbox' -%}
++ 		<input type="checkbox" class="{{ type }}" name="{{ name }}" value="1"{{ checked ? ' checked' }}>
++ 	{%- elseif type == 'radio' -%}
++ 		<label><input type="radio" class="radio" name="{{ name }}" value="1"{{ checked ? ' checked' }}> {{ lang('YES') }}</label>
++ 		<label><input type="radio" class="radio" name="{{ name }}" value="0"{{ !checked ? ' checked' }}> {{ lang('NO') }}</label>
++ 	{%- endif %}
++-	{#- v1.3.1 #}
++ {%- endmacro %}
++ 
++ {% macro number(name, value, min = null, max = null, step = null, placeholder = null) -%}
++@@ -110,22 +109,21 @@
++ {%- endmacro %}
++ 
++ {% macro notes(notes) %}
++-	{% set note_dot = notes|length > 1 ? '&bull; ' %}
++ 	{% if notes|length %}
++ 		<div class="successbox notice">
++ 			{% for note in notes %}
++-				<p>{{ note_dot }}{{ note }}</p>
+++				<p>{{ note }}</p>
++ 			{% endfor %}
++ 		</div>
++ 	{% endif %}
++ {% endmacro %}
++ 
++ {% macro footer(metadata) %}
++-	<p class="{{ metadata.class }}">
+++	<p class="{{ metadata.class  }}">
++ 		{{ metadata.ext_name }} {{ metadata.ext_ver }} &copy; {{ metadata.ext_copyright }}
++ 		{% if metadata.lang_ver is defined %}
++ 			<br>
++-			{{ metadata.lang_desc|e('html') }} {{ metadata.lang_ver|e('html') }} &copy; {{ metadata.lang_author|e('html') }}
+++			{{ metadata.lang_desc|e('html') }} {{ metadata.lang_ver|e('html') }} &bull; {{ metadata.lang_author|e('html') }}
++ 		{% endif %}
++ 	</p>
++ {% endmacro %}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\limitreplies/adm/style/acp_limitreplies_settings.js" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\limitreplies/adm/style/acp_limitreplies_settings.js"
++deleted file mode 100644
++index c42f9deb0..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\limitreplies/adm/style/acp_limitreplies_settings.js"
+++++ /dev/null
++@@ -1,51 +0,0 @@
++-/**
++-*
++-* Limit Multiple Replies. An extension for the phpBB Forum Software package.
++-*
++-* @copyright (c) 2024, LukeWCS, https://github.com/LukeWCS
++-* @license GNU General Public License, version 2 (GPL-2.0-only)
++-*
++-* Note: This extension is 100% genuine handcraft and consists of selected
++-*       natural raw materials. There was no AI involved in making it.
++-*
++-*/
++-
++-(function ($) {
++-	'use strict';
++-
++-	const constants = Object.freeze({
++-		OpacityEnabled	: '1.0',
++-		OpacityDisabled	: '0.35',
++-	});
++-
++-	function setState() {
++-		dimOptionGroup('[name="limitreplies_number_wait_time"]', !$('[name="limitreplies_switch_enable"]').prop('checked'));
++-		dimOptionGroup('[name="limitreplies_select_hint_mode"]', !$('[name="limitreplies_switch_enable"]').prop('checked'));
++-	};
++-
++-	function dimOptionGroup(selector, dimCondition) {
++-		const c = constants;
++-
++-		$(selector).parents('dl').css('opacity', dimCondition ? c.OpacityDisabled : c.OpacityEnabled);
++-	}
++-
++-	function formReset() {
++-		setTimeout(function() {
++-			setState();
++-		});
++-	};
++-
++-	function disableEnter(e) {
++-		if (e.key == 'Enter' && e.target.type != 'textarea') {
++-			return false;
++-		}
++-	};
++-
++-	$(function() {
++-		setState();
++-
++-		$('#limitreplies_settings')				.on('keypress'	, disableEnter);
++-		$('#limitreplies_settings')				.on('reset'		, formReset);
++-		$('[name="limitreplies_switch_enable"]').on('change'	, setState);
++-	});
++-})(jQuery);
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\limitreplies/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\limitreplies/composer.json"
++index 63cd7d3bd..4b072e3da 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\limitreplies/composer.json"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\limitreplies/composer.json"
++@@ -3,8 +3,8 @@
++ 	"type": "phpbb-extension",
++ 	"description": "Forces a waiting period between two posts in a topic if the last post was from the same user. Posts in the topic’s moderation queue are also taken into account.",
++ 	"homepage": "https://github.com/LukeWCS/limit-multiple-replies",
++-	"version": "1.1.1",
++-	"time": "2026-06-14",
+++	"version": "1.0.2",
+++	"time": "2024-12-13",
++ 	"license": "GPL-2.0-only",
++ 	"authors": [
++         {
++@@ -14,12 +14,12 @@
++ 		}
++ 	],
++ 	"require": {
++-		"php": ">=8.0.0,<8.6.0@dev",
++-        "composer/installers": "^1.0 || ^2.0"
+++		"php": ">=7.4.0,<8.5.0@dev",
+++        "composer/installers": "~1.0.0"
++ 	},
++ 	"extra": {
++ 		"display-name": "Limit Multiple Replies",
++-        "lang-min-ver": "1.1.0",
+++        "lang-min-ver": "1.0.0",
++ 		"soft-require": {
++ 			"phpbb/phpbb": ">=3.3.2,<3.4.0@dev"
++ 		},
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\limitreplies/controller/acp_limitreplies_controller.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\limitreplies/controller/acp_limitreplies_controller.php"
++index 1bfe49149..aaa3e1fd5 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\limitreplies/controller/acp_limitreplies_controller.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\limitreplies/controller/acp_limitreplies_controller.php"
++@@ -15,18 +15,30 @@ namespace lukewcs\limitreplies\controller;
++ 
++ class acp_limitreplies_controller
++ {
++-	private array  $metadata;
++-	public  string $u_action;
+++	protected object $language;
+++	protected object $template;
+++	protected object $config;
+++	protected object $request;
+++	protected object $ext_manager;
+++
+++	protected string $u_action;
+++	private   array  $metadata;
++ 
++ 	public function __construct(
++-		protected \phpbb\language\language $language,
++-		protected \phpbb\template\template $template,
++-		protected \phpbb\config\config $config,
++-		protected \phpbb\request\request $request,
++-		protected \phpbb\extension\manager $ext_manager,
+++		\phpbb\language\language $language,
+++		\phpbb\template\template $template,
+++		\phpbb\config\config $config,
+++		\phpbb\request\request $request,
+++		\phpbb\extension\manager $ext_manager
++ 	)
++ 	{
++-		$this->metadata = $this->ext_manager->create_extension_metadata_manager('lukewcs/limitreplies')->get_metadata('all');
+++		$this->language		= $language;
+++		$this->template		= $template;
+++		$this->config		= $config;
+++		$this->request		= $request;
+++		$this->ext_manager	= $ext_manager;
+++
+++		$this->metadata		= $this->ext_manager->create_extension_metadata_manager('lukewcs/limitreplies')->get_metadata('all');
++ 	}
++ 
++ 	public function module_settings(): void
++@@ -43,15 +55,15 @@ class acp_limitreplies_controller
++ 				trigger_error($this->language->lang('FORM_INVALID') . adm_back_link($this->u_action), E_USER_WARNING);
++ 			}
++ 
++-			$this->config->set('limitreplies_switch_enable'		, $this->request->variable('limitreplies_switch_enable'								, 0));
++-			$this->config->set('limitreplies_number_wait_time'	, $this->min_max(1, 999, $this->request->variable('limitreplies_number_wait_time'	, 60)));
++-			$this->config->set('limitreplies_select_time_unit'	, $this->request->variable('limitreplies_select_time_unit'							, 'minutes'));
++-			$this->config->set('limitreplies_select_hint_mode'	, $this->request->variable('limitreplies_select_hint_mode'							, 1));
+++			$this->config->set('limitreplies_switch_enable'		, $this->request->variable('limitreplies_switch_enable'		, 0));
+++			$this->config->set('limitreplies_number_wait_time'	, $this->request->variable('limitreplies_number_wait_time'	, 60));
+++			$this->config->set('limitreplies_select_hint_mode'	, $this->request->variable('limitreplies_select_hint_mode'	, 1));
++ 
++ 			trigger_error($this->language->lang('LIMITREPLIES_MSG_SETTINGS_SAVED') . adm_back_link($this->u_action));
++ 		}
++ 
++-		if ($lang_outdated_msg = $this->lang_ver_check_msg('LIMITREPLIES_LANG_VER', 'LIMITREPLIES_MSG_LANGUAGEPACK_OUTDATED'))
+++		$lang_outdated_msg = $this->lang_ver_check_msg('LIMITREPLIES_LANG_VER', 'LIMITREPLIES_MSG_LANGUAGEPACK_OUTDATED');
+++		if ($lang_outdated_msg)
++ 		{
++ 			$notes[] = $lang_outdated_msg;
++ 		}
++@@ -61,11 +73,6 @@ class acp_limitreplies_controller
++ 
++ 			'LIMITREPLIES_SWITCH_ENABLE'			=> (bool) $this->config['limitreplies_switch_enable'],
++ 			'LIMITREPLIES_NUMBER_WAIT_TIME'			=> (int) $this->config['limitreplies_number_wait_time'],
++-			'LIMITREPLIES_SELECT_TIME_UNIT_OPTS'	=> $this->select_struct($this->config['limitreplies_select_time_unit'], [
++-				'LIMITREPLIES_TIME_UNIT_MINUTES'	=> 'minutes',
++-				'LIMITREPLIES_TIME_UNIT_HOURS'		=> 'hours',
++-				'LIMITREPLIES_TIME_UNIT_DAYS'		=> 'days',
++-			]),
++ 			'LIMITREPLIES_SELECT_HINT_MODE_OPTS'	=> $this->select_struct((int) $this->config['limitreplies_select_hint_mode'], [
++ 				'LIMITREPLIES_HINT_MODE_ONCLICK'	=> 1,
++ 				'LIMITREPLIES_HINT_MODE_ALWAYS'		=> 2,
++@@ -80,27 +87,6 @@ class acp_limitreplies_controller
++ 		$this->u_action = $u_action;
++ 	}
++ 
++-	private function select_struct(array|int|string $cfg_value, array $options): array
++-	{
++-		$options_tpl = [];
++-
++-		foreach ($options as $opt_key => $opt_value)
++-		{
++-			if (!is_array($opt_value))
++-			{
++-				$opt_value = [$opt_value];
++-			}
++-			$options_tpl[] = [
++-				'label'		=> $opt_key,
++-				'value'		=> $opt_value[0],
++-				'bold'		=> $opt_value[1] ?? false,
++-				'selected'	=> is_array($cfg_value) ? in_array($opt_value[0], $cfg_value) : $opt_value[0] == $cfg_value,
++-			];
++-		}
++-
++-		return $options_tpl;
++-	}
++-
++ 	private function set_meta_template_vars(string $tpl_prefix, string $copyright): void
++ 	{
++ 		$template_vars = [
++@@ -118,15 +104,6 @@ class acp_limitreplies_controller
++ 		$this->template->assign_vars([$tpl_prefix . '_METADATA' => $template_vars]);
++ 	}
++ 
++-	private function min_max(float|int $min, float|int $max, float|int $value): float|int
++-	{
++-		return match (true) {
++-			$value < $min	=> $min,
++-			$value > $max	=> $max,
++-			default			=> $value,
++-		};
++-	}
++-
++ 	/*
++ 		Determine the version of the language pack with fallback to 0.0.0
++ 	*/
++@@ -160,4 +137,25 @@ class acp_limitreplies_controller
++ 
++ 		return $lang_outdated_msg;
++ 	}
+++
+++	private function select_struct($cfg_value, array $options): array
+++	{
+++		$options_tpl = [];
+++
+++		foreach ($options as $opt_key => $opt_value)
+++		{
+++			if (!is_array($opt_value))
+++			{
+++				$opt_value = [$opt_value];
+++			}
+++			$options_tpl[] = [
+++				'label'		=> $opt_key,
+++				'value'		=> $opt_value[0],
+++				'bold'		=> $opt_value[1] ?? false,
+++				'selected'	=> is_array($cfg_value) ? in_array($opt_value[0], $cfg_value) : $opt_value[0] == $cfg_value,
+++			];
+++		}
+++
+++		return $options_tpl;
+++	}
++ }
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\limitreplies/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\limitreplies/diff_full.tmp"
++new file mode 100644
++index 000000000..59d686c86
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\limitreplies/diff_full.tmp"
++@@ -0,0 +1,381 @@
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\limitreplies/adm/style/acp_limitreplies_settings.css" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\limitreplies/adm/style/acp_limitreplies_settings.css"
+++index 503e96a9e..8127c3739 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\limitreplies/adm/style/acp_limitreplies_settings.css"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\limitreplies/adm/style/acp_limitreplies_settings.css"
+++@@ -1,4 +1,4 @@
+++-/* GENERAL >>> */
++++/* GENERAL */
+++ 
+++ .limitreplies_footer {
+++ 	margin-top: 1em;
+++@@ -6,33 +6,25 @@
+++ 	font-size: 0.75em;
+++ }
+++ 
+++-/* <<< GENERAL */
++++/* SETTINGS */
+++ 
+++-/* SETTINGS >>> */
+++-
+++-fieldset {}
+++-	& legend {
+++-		top: 0;
+++-		margin-left: -11px;
+++-		padding: 2px 10px;
+++-		border-radius: 5px 5px 0 0;
+++-		border-top: inherit;
+++-		border-left: inherit;
+++-		background-color: inherit;
+++-	}
+++-
+++-	& dt label {
+++-		cursor: inherit;
+++-	}
++++fieldset legend {
++++	top: 0;
++++	margin-left: -11px;
++++	padding: 2px 10px;
++++	border-radius: 5px 5px 0 0;
++++	border-top: inherit;
++++	border-left: inherit;
++++	background-color: inherit;
++++}
+++ 
+++-	& p.submit-buttons {
+++-		margin-top: 0;
+++-		padding: 0 4px 4px 4px;
++++fieldset dt label {
++++	cursor: inherit;
++++}
+++ 
+++-		& input:is([type="submit"], [type="reset"], [type="button"]) {
+++-			padding: 3px 4px;
+++-		}
+++-	}
++++fieldset p.submit-buttons {
++++	margin-top: 0;
++++	padding: 0 4px 4px 4px;
+++ }
+++ 
+++ code {
+++@@ -41,65 +33,61 @@ code {
+++ 	color: black;
+++ }
+++ 
+++-.toggle {
+++-	/* phpBB Kirk Toggles 2.0 - A CSS class that makes it easy to display checkboxes as toggles.
+++-	   Source     : https://danklammer.com/articles/simple-css-toggle-switch/
+++-	   Revision by: Kirk (customization and optimization), LukeWCS (optimization) */
+++-
+++-	/* Kirk style: */
+++-	/* --background-transition: ease 0.3s; */
+++-	/* --background-color-off: #a00; */
+++-	/* --background-color-on: #3fa651; */
+++-	/* --slider-transition: all cubic-bezier(0.3, 1.5, 0.7, 1) 0.3s; */
++++/*
++++* phpBB ACP Toggles - A CSS class that makes it easy to display checkboxes as toggles.
++++* Source     : https://danklammer.com/articles/simple-css-toggle-switch/
++++* Revision by: Kirk (customization and optimization), LukeWCS (optimization)
++++*/
+++ 
++++.toggle {
++++	-webkit-appearance: none;
++++	-moz-appearance: none;
+++ 	appearance: none;
+++-	position: relative;
+++ 	width: 38px;
+++ 	height: 17px;
++++	position: relative;
+++ 	border-radius: 50px;
+++ 	cursor: pointer;
+++ 	font-family: FontAwesome;
+++-	transition: var(--background-transition, 0.2s);
+++-
+++-	&,
+++-	&:hover,
+++-	&:focus {
+++-		background: var(--background-color-off, #ccc);
+++-		border: none;
+++-		color: #000;
+++-	}
++++	transition: background-color 0.2s;
++++}
+++ 
+++-	&:before {
+++-		content: "\f00d";
+++-		justify-content: center;
+++-		position: absolute;
+++-		top: 2px;
+++-		left: 22px;
+++-		width: 14px;
+++-		height: 13px;
+++-		background: #fff;
+++-		border-radius: 50%;
+++-		display: flex;
+++-		align-items: center;
+++-		transition: var(--slider-transition, 0.2s);
+++-	}
++++.toggle:before {
++++	position: absolute;
++++	width: 14px;
++++	height: 13px;
++++	background-color: #ffffff;
++++	top: 2px;
++++	border-radius: 50%;
++++	display: flex;
++++	justify-content: center;
++++	align-items: center;
++++	left: 22px;
++++	content: "\f00d";
++++	transition: 0.2s;
++++}
+++ 
+++-	&:checked {
+++-		background: var(--background-color-on, #3b87ab);
++++.toggle,
++++.toggle:hover,
++++.toggle:focus {
++++	background-color: #cccccc;
++++	border: none;
++++	color: #000000;
++++}
+++ 
+++-		&:before {
+++-			content: "\f00c";
+++-			left: 2px;
+++-		}
+++-	}
++++.toggle:checked {
++++	background-color: #3b87ab;
+++ }
+++ 
+++-/* <<< SETTINGS */
++++.toggle:checked:before {
++++	left: 2px;
++++	content: "\f00c";
++++}
+++ 
+++-/* RESPONSIVE >>> */
++++/* RESPONSIVE */
+++ 
+++ @media (max-width: 700px) {
+++-	fieldset legend {
++++	legend {
+++ 		margin-left: -6px;
+++ 		padding: 2px 5px;
+++ 	}
+++@@ -108,5 +96,3 @@ code {
+++ 		margin-top: 0.5em;
+++ 	}
+++ }
+++-
+++-/* <<< RESPONSIVE */
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\limitreplies/adm/style/acp_limitreplies_settings.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\limitreplies/adm/style/acp_limitreplies_settings.html"
+++index 31eca30cb..d89ab32df 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\limitreplies/adm/style/acp_limitreplies_settings.html"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\limitreplies/adm/style/acp_limitreplies_settings.html"
+++@@ -12,6 +12,8 @@
+++ 
+++ {% INCLUDE 'overall_header.html' %}
+++ 
++++{% set switch_type = TOGGLECTRL_TYPE ?? 'toggle' %}
++++
+++ <a id="maincontent"></a>
+++ 
+++ <h1>{{ lang('LIMITREPLIES_CONFIG_TITLE') }}</h1>
+++@@ -29,7 +31,7 @@
+++ 				<span>{{ lang('LIMITREPLIES_ENABLE_EXPLAIN') }}</span>
+++ 			</dt>
+++ 			<dd>
+++-				{{ _self.switch('limitreplies_switch_enable', LIMITREPLIES_SWITCH_ENABLE) }}
++++				{{ _self.switch('limitreplies_switch_enable', LIMITREPLIES_SWITCH_ENABLE, switch_type) }}
+++ 			</dd>
+++ 		</dl>
+++ 
+++@@ -39,8 +41,8 @@
+++ 				<span>{{ lang('LIMITREPLIES_WAIT_TIME_EXPLAIN') }}</span>
+++ 			</dt>
+++ 			<dd>
+++-				{{ _self.number('limitreplies_number_wait_time', LIMITREPLIES_NUMBER_WAIT_TIME, 1, 999) }}
+++-				{{ _self.select('limitreplies_select_time_unit', LIMITREPLIES_SELECT_TIME_UNIT_OPTS) }}
++++				{{ _self.number('limitreplies_number_wait_time', LIMITREPLIES_NUMBER_WAIT_TIME, 1, 999999) }}
++++				{{ lang('LIMITREPLIES_MINUTES') }}
+++ 			</dd>
+++ 		</dl>
+++ 
+++@@ -73,17 +75,14 @@
+++ {% INCLUDE 'overall_footer.html' %}
+++ 
+++ {% INCLUDECSS '@lukewcs_limitreplies/acp_limitreplies_settings.css' %}
+++-{% INCLUDEJS '@lukewcs_limitreplies/acp_limitreplies_settings.js' %}
+++ 
+++-{% macro switch(name, checked = false, type = null) -%}
+++-	{% set type = type ?? (TOGGLECTRL_TYPE in ['toggle', 'checkbox', 'radio'] ? TOGGLECTRL_TYPE : 'toggle') -%}
+++-	{% if type in ['toggle', 'checkbox'] -%}
++++{% macro switch(name, checked = false, type = 'toggle') -%}
++++	{% if type == 'toggle' || type == 'checkbox' -%}
+++ 		<input type="checkbox" class="{{ type }}" name="{{ name }}" value="1"{{ checked ? ' checked' }}>
+++ 	{%- elseif type == 'radio' -%}
+++ 		<label><input type="radio" class="radio" name="{{ name }}" value="1"{{ checked ? ' checked' }}> {{ lang('YES') }}</label>
+++ 		<label><input type="radio" class="radio" name="{{ name }}" value="0"{{ !checked ? ' checked' }}> {{ lang('NO') }}</label>
+++ 	{%- endif %}
+++-	{#- v1.3.1 #}
+++ {%- endmacro %}
+++ 
+++ {% macro number(name, value, min = null, max = null, step = null, placeholder = null) -%}
+++@@ -110,22 +109,21 @@
+++ {%- endmacro %}
+++ 
+++ {% macro notes(notes) %}
+++-	{% set note_dot = notes|length > 1 ? '&bull; ' %}
+++ 	{% if notes|length %}
+++ 		<div class="successbox notice">
+++ 			{% for note in notes %}
+++-				<p>{{ note_dot }}{{ note }}</p>
++++				<p>{{ note }}</p>
+++ 			{% endfor %}
+++ 		</div>
+++ 	{% endif %}
+++ {% endmacro %}
+++ 
+++ {% macro footer(metadata) %}
+++-	<p class="{{ metadata.class }}">
++++	<p class="{{ metadata.class  }}">
+++ 		{{ metadata.ext_name }} {{ metadata.ext_ver }} &copy; {{ metadata.ext_copyright }}
+++ 		{% if metadata.lang_ver is defined %}
+++ 			<br>
+++-			{{ metadata.lang_desc|e('html') }} {{ metadata.lang_ver|e('html') }} &copy; {{ metadata.lang_author|e('html') }}
++++			{{ metadata.lang_desc|e('html') }} {{ metadata.lang_ver|e('html') }} &bull; {{ metadata.lang_author|e('html') }}
+++ 		{% endif %}
+++ 	</p>
+++ {% endmacro %}
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\limitreplies/adm/style/acp_limitreplies_settings.js" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\limitreplies/adm/style/acp_limitreplies_settings.js"
+++deleted file mode 100644
+++index c42f9deb0..000000000
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\limitreplies/adm/style/acp_limitreplies_settings.js"
++++++ /dev/null
+++@@ -1,51 +0,0 @@
+++-/**
+++-*
+++-* Limit Multiple Replies. An extension for the phpBB Forum Software package.
+++-*
+++-* @copyright (c) 2024, LukeWCS, https://github.com/LukeWCS
+++-* @license GNU General Public License, version 2 (GPL-2.0-only)
+++-*
+++-* Note: This extension is 100% genuine handcraft and consists of selected
+++-*       natural raw materials. There was no AI involved in making it.
+++-*
+++-*/
+++-
+++-(function ($) {
+++-	'use strict';
+++-
+++-	const constants = Object.freeze({
+++-		OpacityEnabled	: '1.0',
+++-		OpacityDisabled	: '0.35',
+++-	});
+++-
+++-	function setState() {
+++-		dimOptionGroup('[name="limitreplies_number_wait_time"]', !$('[name="limitreplies_switch_enable"]').prop('checked'));
+++-		dimOptionGroup('[name="limitreplies_select_hint_mode"]', !$('[name="limitreplies_switch_enable"]').prop('checked'));
+++-	};
+++-
+++-	function dimOptionGroup(selector, dimCondition) {
+++-		const c = constants;
+++-
+++-		$(selector).parents('dl').css('opacity', dimCondition ? c.OpacityDisabled : c.OpacityEnabled);
+++-	}
+++-
+++-	function formReset() {
+++-		setTimeout(function() {
+++-			setState();
+++-		});
+++-	};
+++-
+++-	function disableEnter(e) {
+++-		if (e.key == 'Enter' && e.target.type != 'textarea') {
+++-			return false;
+++-		}
+++-	};
+++-
+++-	$(function() {
+++-		setState();
+++-
+++-		$('#limitreplies_settings')				.on('keypress'	, disableEnter);
+++-		$('#limitreplies_settings')				.on('reset'		, formReset);
+++-		$('[name="limitreplies_switch_enable"]').on('change'	, setState);
+++-	});
+++-})(jQuery);
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\limitreplies/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\limitreplies/composer.json"
+++index 63cd7d3bd..4b072e3da 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\limitreplies/composer.json"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\limitreplies/composer.json"
+++@@ -3,8 +3,8 @@
+++ 	"type": "phpbb-extension",
+++ 	"description": "Forces a waiting period between two posts in a topic if the last post was from the same user. Posts in the topic’s moderation queue are also taken into account.",
+++ 	"homepage": "https://github.com/LukeWCS/limit-multiple-replies",
+++-	"version": "1.1.1",
+++-	"time": "2026-06-14",
++++	"version": "1.0.2",
++++	"time": "2024-12-13",
+++ 	"license": "GPL-2.0-only",
+++ 	"authors": [
+++         {
+++@@ -14,12 +14,12 @@
+++ 		}
+++ 	],
+++ 	"require": {
+++-		"php": ">=8.0.0,<8.6.0@dev",
+++-        "composer/installers": "^1.0 || ^2.0"
++++		"php": ">=7.4.0,<8.5.0@dev",
++++        "composer/installers": "~1.0.0"
+++ 	},
+++ 	"extra": {
+++ 		"display-name": "Limit Multiple Replies",
+++-        "lang-min-ver": "1.1.0",
++++        "lang-min-ver": "1.0.0",
+++ 		"soft-require": {
+++ 			"phpbb/phpbb": ">=3.3.2,<3.4.0@dev"
+++ 		},
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\limitreplies/controller/acp_limitreplies_controller.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\limitreplies/controller/acp_limitreplies_controller.php"
+++index 1bfe49149..aaa3e1fd5 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\limitreplies/controller/acp_limitreplies_controller.php"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\limitreplies/controller/acp_limitreplies_controller.php"
+++@@ -15,18 +15,30 @@ namespace lukewcs\limitreplies\controller;
+++ 
+++ class acp_limitreplies_controller
+++ {
+++-	private array  $metadata;
+++-	public  string $u_action;
++++	protected object $language;
++++	protected object $template;
++++	protected object $config;
++++	protected object $request;
++++	protected object $ext_manager;
++++
++++	protected string $u_action;
++++	private   array  $metadata;
+++ 
+++ 	public function __construct(
+++-		protected \phpbb\language\language $language,
+++-		protected \phpbb\template\template $template,
+++-		protected \phpbb\config\config $config,
+++-		protected \phpbb\request\request $request,
+++-		protected \phpbb\extension\manager $ext_manager,
++++		\phpbb\language\language $language,
++++		\phpbb\template\template $template,
++++		\phpbb\config\config $config,
++++		\phpbb\request\request $request,
++++		\phpbb\extension\manager $ext_manager
+++ 	)
+++ 	{
+++-		$this->metadata = $this->ext_manager->create_extension_metadata_manager('lukewcs/limitreplies')->get_metadata('all');
++++		$this->language		= $language;
++++		$this->template		= $template;
++++		$this->config		= $config;
++++		$this->request		= $request;
++++		$this->ext_manager	= $ext_manager;
++++
++++		$this->metadata		= $this->ext_manager->create_extension_metadata_manager('lukewcs/limitreplies')->get_metadata('all');
+++ 	}
+++ 
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\limitreplies/event/listener.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\limitreplies/event/listener.php"
++index 3b1b6de76..e06ee4bd0 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\limitreplies/event/listener.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\limitreplies/event/listener.php"
++@@ -17,15 +17,28 @@ use Symfony\Component\EventDispatcher\EventSubscriberInterface;
++ 
++ class listener implements EventSubscriberInterface
++ {
+++	protected object $language;
+++	protected object $template;
+++	protected object $config;
+++	protected object $auth;
+++	protected object $user;
+++	protected object $db;
+++
++ 	public function __construct(
++-		protected \phpbb\language\language $language,
++-		protected \phpbb\template\template $template,
++-		protected \phpbb\config\config $config,
++-		protected \phpbb\auth\auth $auth,
++-		protected \phpbb\user $user,
++-		protected \phpbb\db\driver\driver_interface $db,
+++		\phpbb\language\language $language,
+++		\phpbb\template\template $template,
+++		\phpbb\config\config $config,
+++		\phpbb\auth\auth $auth,
+++		\phpbb\user $user,
+++		\phpbb\db\driver\driver_interface $db
++ 	)
++ 	{
+++		$this->language	= $language;
+++		$this->template	= $template;
+++		$this->config	= $config;
+++		$this->auth		= $auth;
+++		$this->user		= $user;
+++		$this->db		= $db;
++ 	}
++ 
++ 	public static function getSubscribedEvents(): array
++@@ -96,7 +109,7 @@ class listener implements EventSubscriberInterface
++ 
++ 	private function get_lock_time(array $topic_data): int
++ 	{
++-		$wait_time			= strtotime($this->config['limitreplies_number_wait_time'] . ' ' . $this->config['limitreplies_select_time_unit'], 0);
+++		$wait_time			= $this->config['limitreplies_number_wait_time'] * 60;
++ 		$locked_until_time	= 0;
++ 
++ 		/* Check whether there are posts in the queue of the topic. */
++@@ -126,7 +139,7 @@ class listener implements EventSubscriberInterface
++ 			$locked_until_time = $topic_data['topic_last_post_time'] + $wait_time;
++ 		}
++ 
++-		return ($locked_until_time > time()) ? $locked_until_time : 0;
+++		return $locked_until_time > time() ? $locked_until_time : 0;
++ 	}
++ 
++ 	private function create_message(int $locked_until_time): string
++@@ -134,8 +147,7 @@ class listener implements EventSubscriberInterface
++ 		$this->language->add_lang('limitreplies', 'lukewcs/limitreplies');
++ 
++ 		return $this->language->lang('LIMITREPLIES_MSG_REPLY_DENIED',
++-			$this->language->lang('LIMITREPLIES_PLURAL_' . strtoupper($this->config['limitreplies_select_time_unit']),
++-				(int) $this->config['limitreplies_number_wait_time']),
+++			$this->language->lang('LIMITREPLIES_MINUTES_PLURAL', (int) $this->config['limitreplies_number_wait_time']),
++ 			$this->user->format_date($locked_until_time)
++ 		);
++ 	}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\limitreplies/ext.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\limitreplies/ext.php"
++index edfbe4efe..8ad4bc449 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\limitreplies/ext.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\limitreplies/ext.php"
++@@ -18,7 +18,7 @@ class ext extends \phpbb\extension\base
++ 	public function is_enableable()
++ 	{
++ 		$valid_phpbb = phpbb_version_compare(PHPBB_VERSION, '3.3.2', '>=') && phpbb_version_compare(PHPBB_VERSION, '3.4.0-dev', '<');
++-		$valid_php = phpbb_version_compare(PHP_VERSION, '8.0.0', '>=') && phpbb_version_compare(PHP_VERSION, '8.6.0-dev', '<');
+++		$valid_php = phpbb_version_compare(PHP_VERSION, '7.4.0', '>=') && phpbb_version_compare(PHP_VERSION, '8.5.0-dev', '<');
++ 
++ 		return $valid_phpbb && $valid_php;
++ 	}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\limitreplies/language/de/acp_limitreplies.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\limitreplies/language/de/acp_limitreplies.php"
++index 565916e86..d1fdfa4ac 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\limitreplies/language/de/acp_limitreplies.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\limitreplies/language/de/acp_limitreplies.php"
++@@ -48,9 +48,7 @@ $lang = array_merge($lang, [
++ 	'LIMITREPLIES_ENABLE_EXPLAIN'		=> 'Mit diesem Schalter kannst du die Funktionalität deaktivieren, ohne die Erweiterung komplett deaktivieren zu müssen.',
++ 	'LIMITREPLIES_WAIT_TIME'			=> 'Wartezeit zwischen zwei Beiträgen',
++ 	'LIMITREPLIES_WAIT_TIME_EXPLAIN'	=> 'Hier kannst du festlegen, nach welcher Wartezeit eine erneute Antwort im Thema erlaubt ist, wenn der letzte Beitrag vom selben Benutzer stammt. Dieser Wert wird auch in der Erklärung angezeigt.',
++-	'LIMITREPLIES_TIME_UNIT_MINUTES'	=> 'Minuten',
++-	'LIMITREPLIES_TIME_UNIT_HOURS'		=> 'Stunden',
++-	'LIMITREPLIES_TIME_UNIT_DAYS'		=> 'Tage',
+++	'LIMITREPLIES_MINUTES'				=> 'Minuten',
++ 	'LIMITREPLIES_HINT_MODE'			=> 'Erklärung anzeigen',
++ 	'LIMITREPLIES_HINT_MODE_EXPLAIN'	=> 'Hier kann festgelegt werden, auf welche Weise die Erklärung bei aktiver Sperre angezeigt werden soll. Die Option „Bei Klick“ bezieht sich auf die Antworten- und Zitat-Buttons. Bei der Option „Immer“ wird die Erklärung unterhalb der Antworten-Buttons angezeigt.',
++ 	'LIMITREPLIES_HINT_MODE_ONCLICK'	=> 'Bei Klick (als Info-Popup)',
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\limitreplies/language/de/limitreplies.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\limitreplies/language/de/limitreplies.php"
++index 2f413482a..1395d3e2d 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\limitreplies/language/de/limitreplies.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\limitreplies/language/de/limitreplies.php"
++@@ -41,16 +41,8 @@ if (empty($lang) || !is_array($lang))
++ 
++ $lang = array_merge($lang, [
++ 	'LIMITREPLIES_MSG_REPLY_DENIED'	=> 'Solange der letzte Beitrag in diesem Thema von dir stammt und jünger ist als <strong>%1$s</strong>, kannst du erst ab <strong>%2$s</strong> erneut antworten.',
++-	'LIMITREPLIES_PLURAL_MINUTES'	=> [
+++	'LIMITREPLIES_MINUTES_PLURAL'	=> [
++ 		1							=> '1 Minute',
++ 		2							=> '%u Minuten',
++ 	],
++-	'LIMITREPLIES_PLURAL_HOURS'		=> [
++-		1							=> '1 Stunde',
++-		2							=> '%u Stunden',
++-	],
++-	'LIMITREPLIES_PLURAL_DAYS'		=> [
++-		1							=> '1 Tag',
++-		2							=> '%u Tage',
++-	],
++ ]);
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\limitreplies/language/de/limitreplies_lang_author.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\limitreplies/language/de/limitreplies_lang_author.php"
++index c97d911e7..e7ef2e143 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\limitreplies/language/de/limitreplies_lang_author.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\limitreplies/language/de/limitreplies_lang_author.php"
++@@ -41,7 +41,7 @@ if (empty($lang) || !is_array($lang))
++ 
++ $lang = array_merge($lang, [
++ 	'LIMITREPLIES_LANG_DESC'					=> 'Deutsch (Du)',
++-	'LIMITREPLIES_LANG_VER'	 					=> '1.1.0',
+++	'LIMITREPLIES_LANG_VER'	 					=> '1.0.0',
++ 	'LIMITREPLIES_LANG_AUTHOR'	 				=> 'LukeWCS',
++ 
++ 	'LIMITREPLIES_MSG_LANGUAGEPACK_OUTDATED'	=> 'Hinweis: Das Sprachpaket der Erweiterung <strong>%1$s</strong> ist nicht mehr aktuell. (vorhanden: %2$s / benötigt: %3$s)',
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\limitreplies/language/de_x_sie/acp_limitreplies.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\limitreplies/language/de_x_sie/acp_limitreplies.php"
++index 9fee8bf28..ad7b454ae 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\limitreplies/language/de_x_sie/acp_limitreplies.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\limitreplies/language/de_x_sie/acp_limitreplies.php"
++@@ -48,9 +48,7 @@ $lang = array_merge($lang, [
++ 	'LIMITREPLIES_ENABLE_EXPLAIN'		=> 'Mit diesem Schalter können Sie die Funktionalität deaktivieren, ohne die Erweiterung komplett deaktivieren zu müssen.',
++ 	'LIMITREPLIES_WAIT_TIME'			=> 'Wartezeit zwischen zwei Beiträgen',
++ 	'LIMITREPLIES_WAIT_TIME_EXPLAIN'	=> 'Hier können Sie festlegen, nach welcher Wartezeit eine erneute Antwort im Thema erlaubt ist, wenn der letzte Beitrag vom selben Benutzer stammt. Dieser Wert wird auch in der Erklärung angezeigt.',
++-	'LIMITREPLIES_TIME_UNIT_MINUTES'	=> 'Minuten',
++-	'LIMITREPLIES_TIME_UNIT_HOURS'		=> 'Stunden',
++-	'LIMITREPLIES_TIME_UNIT_DAYS'		=> 'Tage',
+++	'LIMITREPLIES_MINUTES'				=> 'Minuten',
++ 	'LIMITREPLIES_HINT_MODE'			=> 'Erklärung anzeigen',
++ 	'LIMITREPLIES_HINT_MODE_EXPLAIN'	=> 'Hier kann festgelegt werden, auf welche Weise die Erklärung bei aktiver Sperre angezeigt werden soll. Die Option „Bei Klick“ bezieht sich auf die Antworten- und Zitat-Buttons. Bei der Option „Immer“ wird die Erklärung unterhalb der Antworten-Buttons angezeigt.',
++ 	'LIMITREPLIES_HINT_MODE_ONCLICK'	=> 'Bei Klick (als Info-Popup)',
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\limitreplies/language/de_x_sie/limitreplies.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\limitreplies/language/de_x_sie/limitreplies.php"
++index 196ea90c1..244e6b2ea 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\limitreplies/language/de_x_sie/limitreplies.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\limitreplies/language/de_x_sie/limitreplies.php"
++@@ -41,16 +41,8 @@ if (empty($lang) || !is_array($lang))
++ 
++ $lang = array_merge($lang, [
++ 	'LIMITREPLIES_MSG_REPLY_DENIED'	=> 'Solange der letzte Beitrag in diesem Thema von Ihnen stammt und jünger ist als <strong>%1$s</strong>, können Sie erst ab <strong>%2$s</strong> erneut antworten.',
++-	'LIMITREPLIES_PLURAL_MINUTES'	=> [
+++	'LIMITREPLIES_MINUTES_PLURAL' 	=> [
++ 		1							=> '1 Minute',
++ 		2							=> '%u Minuten',
++ 	],
++-	'LIMITREPLIES_PLURAL_HOURS'		=> [
++-		1							=> '1 Stunde',
++-		2							=> '%u Stunden',
++-	],
++-	'LIMITREPLIES_PLURAL_DAYS'		=> [
++-		1							=> '1 Tag',
++-		2							=> '%u Tage',
++-	],
++ ]);
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\limitreplies/language/de_x_sie/limitreplies_lang_author.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\limitreplies/language/de_x_sie/limitreplies_lang_author.php"
++index e7303f58e..64d0ee896 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\limitreplies/language/de_x_sie/limitreplies_lang_author.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\limitreplies/language/de_x_sie/limitreplies_lang_author.php"
++@@ -41,7 +41,7 @@ if (empty($lang) || !is_array($lang))
++ 
++ $lang = array_merge($lang, [
++ 	'LIMITREPLIES_LANG_DESC'					=> 'Deutsch (Sie)',
++-	'LIMITREPLIES_LANG_VER'		 				=> '1.1.0',
+++	'LIMITREPLIES_LANG_VER'		 				=> '1.0.0',
++ 	'LIMITREPLIES_LANG_AUTHOR'	 				=> 'LukeWCS',
++ 
++ 	'LIMITREPLIES_MSG_LANGUAGEPACK_OUTDATED'	=> 'Hinweis: Das Sprachpaket der Erweiterung <strong>%1$s</strong> ist nicht mehr aktuell. (vorhanden: %2$s / benötigt: %3$s)',
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\limitreplies/language/en/acp_limitreplies.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\limitreplies/language/en/acp_limitreplies.php"
++index dad19a978..7e70cdc7a 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\limitreplies/language/en/acp_limitreplies.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\limitreplies/language/en/acp_limitreplies.php"
++@@ -48,9 +48,7 @@ $lang = array_merge($lang, [
++ 	'LIMITREPLIES_ENABLE_EXPLAIN'		=> 'With this switch you can deactivate the functionality without having to deactivate the extension completely.',
++ 	'LIMITREPLIES_WAIT_TIME'			=> 'Waiting period between two posts',
++ 	'LIMITREPLIES_WAIT_TIME_EXPLAIN'	=> 'Here you can specify after which waiting period a new reply is allowed in the topic if the last post was made by the same user. This value is also displayed in the explanation.',
++-	'LIMITREPLIES_TIME_UNIT_MINUTES'	=> 'minutes',
++-	'LIMITREPLIES_TIME_UNIT_HOURS'		=> 'hours',
++-	'LIMITREPLIES_TIME_UNIT_DAYS'		=> 'days',
+++	'LIMITREPLIES_MINUTES'				=> 'minutes',
++ 	'LIMITREPLIES_HINT_MODE'			=> 'Show explanation',
++ 	'LIMITREPLIES_HINT_MODE_EXPLAIN'	=> 'Here you can specify how the explanation should be displayed when the lock is active. The “On click” option refers to the reply and quote buttons. With the “Always” option, the explanation is displayed below the reply buttons.',
++ 	'LIMITREPLIES_HINT_MODE_ONCLICK'	=> 'On click (as info popup)',
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\limitreplies/language/en/limitreplies.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\limitreplies/language/en/limitreplies.php"
++index 512130ec8..24abb6433 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\limitreplies/language/en/limitreplies.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\limitreplies/language/en/limitreplies.php"
++@@ -41,16 +41,8 @@ if (empty($lang) || !is_array($lang))
++ 
++ $lang = array_merge($lang, [
++ 	'LIMITREPLIES_MSG_REPLY_DENIED'	=> 'As long as the last post in this topic was from you and is newer than <strong>%1$s</strong>, you can only reply again from <strong>%2$s</strong>.',
++-	'LIMITREPLIES_PLURAL_MINUTES'	=> [
+++	'LIMITREPLIES_MINUTES_PLURAL' 	=> [
++ 		1							=> '1 minute',
++ 		2							=> '%u minutes',
++ 	],
++-	'LIMITREPLIES_PLURAL_HOURS'		=> [
++-		1							=> '1 hour',
++-		2							=> '%u hours',
++-	],
++-	'LIMITREPLIES_PLURAL_DAYS'		=> [
++-		1							=> '1 day',
++-		2							=> '%u days',
++-	],
++ ]);
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\limitreplies/language/en/limitreplies_lang_author.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\limitreplies/language/en/limitreplies_lang_author.php"
++index 267c7545b..4025740e7 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\limitreplies/language/en/limitreplies_lang_author.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\limitreplies/language/en/limitreplies_lang_author.php"
++@@ -41,7 +41,7 @@ if (empty($lang) || !is_array($lang))
++ 
++ $lang = array_merge($lang, [
++ 	'LIMITREPLIES_LANG_DESC'					=> 'English',
++-	'LIMITREPLIES_LANG_VER'	 					=> '1.1.0',
+++	'LIMITREPLIES_LANG_VER'	 					=> '1.0.0',
++ 	'LIMITREPLIES_LANG_AUTHOR'	 				=> 'LukeWCS',
++ 
++ 	'LIMITREPLIES_MSG_LANGUAGEPACK_OUTDATED'	=> 'Note: The language pack for the <strong>%1$s</strong> extension is no longer up to date. (available: %2$s / required: %3$s)',
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\limitreplies/migrations/v_1_1_0.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\limitreplies/migrations/v_1_1_0.php"
++deleted file mode 100644
++index 5c90bcfa1..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\limitreplies/migrations/v_1_1_0.php"
+++++ /dev/null
++@@ -1,29 +0,0 @@
++-<?php
++-/**
++-*
++-* Limit Multiple Replies. An extension for the phpBB Forum Software package.
++-*
++-* @copyright (c) 2024, LukeWCS, https://github.com/LukeWCS
++-* @license GNU General Public License, version 2 (GPL-2.0-only)
++-*
++-* Note: This extension is 100% genuine handcraft and consists of selected
++-*       natural raw materials. There was no AI involved in making it.
++-*
++-*/
++-
++-namespace lukewcs\limitreplies\migrations;
++-
++-class v_1_1_0 extends \phpbb\db\migration\migration
++-{
++-	public static function depends_on()
++-	{
++-		return ['\lukewcs\limitreplies\migrations\v_1_0_0'];
++-	}
++-
++-	public function update_data()
++-	{
++-		return [
++-			['config.add', ['limitreplies_select_time_unit', 'minutes']],
++-		];
++-	}
++-}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\limitreplies/styles/all/template/event/viewtopic_body_footer_before.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\limitreplies/styles/all/template/event/viewtopic_body_footer_before.html"
++index 5726a9fa7..d34e6df69 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\limitreplies/styles/all/template/event/viewtopic_body_footer_before.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\limitreplies/styles/all/template/event/viewtopic_body_footer_before.html"
++@@ -10,11 +10,6 @@
++ *
++ #}
++ 
++-{% set const = {
++-	HINT_MODE_ONCLICK	: 1,
++-	HINT_MODE_ALWAYS	: 2,
++-} %}
++-
++-{% if LIMITREPLIES_SELECT_HINT_MODE == const.HINT_MODE_ALWAYS %}
+++{% if (LIMITREPLIES_SELECT_HINT_MODE ?? 0) == 2 %}
++ 	{% INCLUDE '@lukewcs_limitreplies/show_message.html' %}
++ {% endif %}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\limitreplies/styles/all/template/event/viewtopic_body_poll_before.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\limitreplies/styles/all/template/event/viewtopic_body_poll_before.html"
++index b25dd163e..116c3c3c0 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\limitreplies/styles/all/template/event/viewtopic_body_poll_before.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\limitreplies/styles/all/template/event/viewtopic_body_poll_before.html"
++@@ -10,13 +10,10 @@
++ *
++ #}
++ 
++-{% set const = {
++-	HINT_MODE_ONCLICK	: 1,
++-	HINT_MODE_ALWAYS	: 2,
++-} %}
++-
++ {% if LIMITREPLIES_MESSAGE is defined %}
++-	{% if LIMITREPLIES_SELECT_HINT_MODE == const.HINT_MODE_ALWAYS %}
+++	{% INCLUDEJS '@lukewcs_limitreplies/limitreplies.js' %}
+++	{% INCLUDECSS '@lukewcs_limitreplies/limitreplies.css' %}
+++	{% if LIMITREPLIES_SELECT_HINT_MODE == 2 %}
++ 		{% INCLUDE '@lukewcs_limitreplies/show_message.html' %}
++ 	{% endif %}
++ 
++@@ -27,7 +24,4 @@
++ 			HintMode		: {{ LIMITREPLIES_SELECT_HINT_MODE|json_encode }},
++ 		});
++ 	</script>
++-
++-	{% INCLUDEJS '@lukewcs_limitreplies/limitreplies.js' %}
++-	{% INCLUDECSS '@lukewcs_limitreplies/limitreplies.css' %}
++ {% endif %}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\limitreplies/styles/all/template/limitreplies.js" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\limitreplies/styles/all/template/limitreplies.js"
++index d1202408a..97102de2f 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\limitreplies/styles/all/template/limitreplies.js"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\
\ No newline at end of file
diff --git "[ORIGINAL]/lukewcs\\limitreplies/event/listener.php" "[FORUM_EXT]/lukewcs\\limitreplies/event/listener.php"
--- "[ORIGINAL]/lukewcs\\limitreplies/event/listener.php"
+++ "[FORUM_EXT]/lukewcs\\limitreplies/event/listener.php"
@@ -17,15 +17,28 @@ use Symfony\Component\EventDispatcher\EventSubscriberInterface;
 
 class listener implements EventSubscriberInterface
 {
+	protected object $language;
+	protected object $template;
+	protected object $config;
+	protected object $auth;
+	protected object $user;
+	protected object $db;
+
 	public function __construct(
-		protected \phpbb\language\language $language,
-		protected \phpbb\template\template $template,
-		protected \phpbb\config\config $config,
-		protected \phpbb\auth\auth $auth,
-		protected \phpbb\user $user,
-		protected \phpbb\db\driver\driver_interface $db,
+		\phpbb\language\language $language,
+		\phpbb\template\template $template,
+		\phpbb\config\config $config,
+		\phpbb\auth\auth $auth,
+		\phpbb\user $user,
+		\phpbb\db\driver\driver_interface $db
 	)
 	{
+		$this->language	= $language;
+		$this->template	= $template;
+		$this->config	= $config;
+		$this->auth		= $auth;
+		$this->user		= $user;
+		$this->db		= $db;
 	}
 
 	public static function getSubscribedEvents(): array
@@ -96,7 +109,7 @@ class listener implements EventSubscriberInterface
 
 	private function get_lock_time(array $topic_data): int
 	{
-		$wait_time			= strtotime($this->config['limitreplies_number_wait_time'] . ' ' . $this->config['limitreplies_select_time_unit'], 0);
+		$wait_time			= $this->config['limitreplies_number_wait_time'] * 60;
 		$locked_until_time	= 0;
 
 		/* Check whether there are posts in the queue of the topic. */
@@ -126,7 +139,7 @@ class listener implements EventSubscriberInterface
 			$locked_until_time = $topic_data['topic_last_post_time'] + $wait_time;
 		}
 
-		return ($locked_until_time > time()) ? $locked_until_time : 0;
+		return $locked_until_time > time() ? $locked_until_time : 0;
 	}
 
 	private function create_message(int $locked_until_time): string
@@ -134,8 +147,7 @@ class listener implements EventSubscriberInterface
 		$this->language->add_lang('limitreplies', 'lukewcs/limitreplies');
 
 		return $this->language->lang('LIMITREPLIES_MSG_REPLY_DENIED',
-			$this->language->lang('LIMITREPLIES_PLURAL_' . strtoupper($this->config['limitreplies_select_time_unit']),
-				(int) $this->config['limitreplies_number_wait_time']),
+			$this->language->lang('LIMITREPLIES_MINUTES_PLURAL', (int) $this->config['limitreplies_number_wait_time']),
 			$this->user->format_date($locked_until_time)
 		);
 	}
diff --git "[ORIGINAL]/lukewcs\\limitreplies/ext.php" "[FORUM_EXT]/lukewcs\\limitreplies/ext.php"
--- "[ORIGINAL]/lukewcs\\limitreplies/ext.php"
+++ "[FORUM_EXT]/lukewcs\\limitreplies/ext.php"
@@ -18,7 +18,7 @@ class ext extends \phpbb\extension\base
 	public function is_enableable()
 	{
 		$valid_phpbb = phpbb_version_compare(PHPBB_VERSION, '3.3.2', '>=') && phpbb_version_compare(PHPBB_VERSION, '3.4.0-dev', '<');
-		$valid_php = phpbb_version_compare(PHP_VERSION, '8.0.0', '>=') && phpbb_version_compare(PHP_VERSION, '8.6.0-dev', '<');
+		$valid_php = phpbb_version_compare(PHP_VERSION, '7.4.0', '>=') && phpbb_version_compare(PHP_VERSION, '8.5.0-dev', '<');
 
 		return $valid_phpbb && $valid_php;
 	}
diff --git "[ORIGINAL]/lukewcs\\limitreplies/language/de/acp_limitreplies.php" "[FORUM_EXT]/lukewcs\\limitreplies/language/de/acp_limitreplies.php"
--- "[ORIGINAL]/lukewcs\\limitreplies/language/de/acp_limitreplies.php"
+++ "[FORUM_EXT]/lukewcs\\limitreplies/language/de/acp_limitreplies.php"
@@ -48,9 +48,7 @@ $lang = array_merge($lang, [
 	'LIMITREPLIES_ENABLE_EXPLAIN'		=> 'Mit diesem Schalter kannst du die Funktionalität deaktivieren, ohne die Erweiterung komplett deaktivieren zu müssen.',
 	'LIMITREPLIES_WAIT_TIME'			=> 'Wartezeit zwischen zwei Beiträgen',
 	'LIMITREPLIES_WAIT_TIME_EXPLAIN'	=> 'Hier kannst du festlegen, nach welcher Wartezeit eine erneute Antwort im Thema erlaubt ist, wenn der letzte Beitrag vom selben Benutzer stammt. Dieser Wert wird auch in der Erklärung angezeigt.',
-	'LIMITREPLIES_TIME_UNIT_MINUTES'	=> 'Minuten',
-	'LIMITREPLIES_TIME_UNIT_HOURS'		=> 'Stunden',
-	'LIMITREPLIES_TIME_UNIT_DAYS'		=> 'Tage',
+	'LIMITREPLIES_MINUTES'				=> 'Minuten',
 	'LIMITREPLIES_HINT_MODE'			=> 'Erklärung anzeigen',
 	'LIMITREPLIES_HINT_MODE_EXPLAIN'	=> 'Hier kann festgelegt werden, auf welche Weise die Erklärung bei aktiver Sperre angezeigt werden soll. Die Option „Bei Klick“ bezieht sich auf die Antworten- und Zitat-Buttons. Bei der Option „Immer“ wird die Erklärung unterhalb der Antworten-Buttons angezeigt.',
 	'LIMITREPLIES_HINT_MODE_ONCLICK'	=> 'Bei Klick (als Info-Popup)',
diff --git "[ORIGINAL]/lukewcs\\limitreplies/language/de/limitreplies.php" "[FORUM_EXT]/lukewcs\\limitreplies/language/de/limitreplies.php"
--- "[ORIGINAL]/lukewcs\\limitreplies/language/de/limitreplies.php"
+++ "[FORUM_EXT]/lukewcs\\limitreplies/language/de/limitreplies.php"
@@ -41,16 +41,8 @@ if (empty($lang) || !is_array($lang))
 
 $lang = array_merge($lang, [
 	'LIMITREPLIES_MSG_REPLY_DENIED'	=> 'Solange der letzte Beitrag in diesem Thema von dir stammt und jünger ist als <strong>%1$s</strong>, kannst du erst ab <strong>%2$s</strong> erneut antworten.',
-	'LIMITREPLIES_PLURAL_MINUTES'	=> [
+	'LIMITREPLIES_MINUTES_PLURAL'	=> [
 		1							=> '1 Minute',
 		2							=> '%u Minuten',
 	],
-	'LIMITREPLIES_PLURAL_HOURS'		=> [
-		1							=> '1 Stunde',
-		2							=> '%u Stunden',
-	],
-	'LIMITREPLIES_PLURAL_DAYS'		=> [
-		1							=> '1 Tag',
-		2							=> '%u Tage',
-	],
 ]);
diff --git "[ORIGINAL]/lukewcs\\limitreplies/language/de/limitreplies_lang_author.php" "[FORUM_EXT]/lukewcs\\limitreplies/language/de/limitreplies_lang_author.php"
--- "[ORIGINAL]/lukewcs\\limitreplies/language/de/limitreplies_lang_author.php"
+++ "[FORUM_EXT]/lukewcs\\limitreplies/language/de/limitreplies_lang_author.php"
@@ -41,7 +41,7 @@ if (empty($lang) || !is_array($lang))
 
 $lang = array_merge($lang, [
 	'LIMITREPLIES_LANG_DESC'					=> 'Deutsch (Du)',
-	'LIMITREPLIES_LANG_VER'	 					=> '1.1.0',
+	'LIMITREPLIES_LANG_VER'	 					=> '1.0.0',
 	'LIMITREPLIES_LANG_AUTHOR'	 				=> 'LukeWCS',
 
 	'LIMITREPLIES_MSG_LANGUAGEPACK_OUTDATED'	=> 'Hinweis: Das Sprachpaket der Erweiterung <strong>%1$s</strong> ist nicht mehr aktuell. (vorhanden: %2$s / benötigt: %3$s)',
diff --git "[ORIGINAL]/lukewcs\\limitreplies/language/de_x_sie/acp_limitreplies.php" "[FORUM_EXT]/lukewcs\\limitreplies/language/de_x_sie/acp_limitreplies.php"
--- "[ORIGINAL]/lukewcs\\limitreplies/language/de_x_sie/acp_limitreplies.php"
+++ "[FORUM_EXT]/lukewcs\\limitreplies/language/de_x_sie/acp_limitreplies.php"
@@ -48,9 +48,7 @@ $lang = array_merge($lang, [
 	'LIMITREPLIES_ENABLE_EXPLAIN'		=> 'Mit diesem Schalter können Sie die Funktionalität deaktivieren, ohne die Erweiterung komplett deaktivieren zu müssen.',
 	'LIMITREPLIES_WAIT_TIME'			=> 'Wartezeit zwischen zwei Beiträgen',
 	'LIMITREPLIES_WAIT_TIME_EXPLAIN'	=> 'Hier können Sie festlegen, nach welcher Wartezeit eine erneute Antwort im Thema erlaubt ist, wenn der letzte Beitrag vom selben Benutzer stammt. Dieser Wert wird auch in der Erklärung angezeigt.',
-	'LIMITREPLIES_TIME_UNIT_MINUTES'	=> 'Minuten',
-	'LIMITREPLIES_TIME_UNIT_HOURS'		=> 'Stunden',
-	'LIMITREPLIES_TIME_UNIT_DAYS'		=> 'Tage',
+	'LIMITREPLIES_MINUTES'				=> 'Minuten',
 	'LIMITREPLIES_HINT_MODE'			=> 'Erklärung anzeigen',
 	'LIMITREPLIES_HINT_MODE_EXPLAIN'	=> 'Hier kann festgelegt werden, auf welche Weise die Erklärung bei aktiver Sperre angezeigt werden soll. Die Option „Bei Klick“ bezieht sich auf die Antworten- und Zitat-Buttons. Bei der Option „Immer“ wird die Erklärung unterhalb der Antworten-Buttons angezeigt.',
 	'LIMITREPLIES_HINT_MODE_ONCLICK'	=> 'Bei Klick (als Info-Popup)',
diff --git "[ORIGINAL]/lukewcs\\limitreplies/language/de_x_sie/limitreplies.php" "[FORUM_EXT]/lukewcs\\limitreplies/language/de_x_sie/limitreplies.php"
--- "[ORIGINAL]/lukewcs\\limitreplies/language/de_x_sie/limitreplies.php"
+++ "[FORUM_EXT]/lukewcs\\limitreplies/language/de_x_sie/limitreplies.php"
@@ -41,16 +41,8 @@ if (empty($lang) || !is_array($lang))
 
 $lang = array_merge($lang, [
 	'LIMITREPLIES_MSG_REPLY_DENIED'	=> 'Solange der letzte Beitrag in diesem Thema von Ihnen stammt und jünger ist als <strong>%1$s</strong>, können Sie erst ab <strong>%2$s</strong> erneut antworten.',
-	'LIMITREPLIES_PLURAL_MINUTES'	=> [
+	'LIMITREPLIES_MINUTES_PLURAL' 	=> [
 		1							=> '1 Minute',
 		2							=> '%u Minuten',
 	],
-	'LIMITREPLIES_PLURAL_HOURS'		=> [
-		1							=> '1 Stunde',
-		2							=> '%u Stunden',
-	],
-	'LIMITREPLIES_PLURAL_DAYS'		=> [
-		1							=> '1 Tag',
-		2							=> '%u Tage',
-	],
 ]);
diff --git "[ORIGINAL]/lukewcs\\limitreplies/language/de_x_sie/limitreplies_lang_author.php" "[FORUM_EXT]/lukewcs\\limitreplies/language/de_x_sie/limitreplies_lang_author.php"
--- "[ORIGINAL]/lukewcs\\limitreplies/language/de_x_sie/limitreplies_lang_author.php"
+++ "[FORUM_EXT]/lukewcs\\limitreplies/language/de_x_sie/limitreplies_lang_author.php"
@@ -41,7 +41,7 @@ if (empty($lang) || !is_array($lang))
 
 $lang = array_merge($lang, [
 	'LIMITREPLIES_LANG_DESC'					=> 'Deutsch (Sie)',
-	'LIMITREPLIES_LANG_VER'		 				=> '1.1.0',
+	'LIMITREPLIES_LANG_VER'		 				=> '1.0.0',
 	'LIMITREPLIES_LANG_AUTHOR'	 				=> 'LukeWCS',
 
 	'LIMITREPLIES_MSG_LANGUAGEPACK_OUTDATED'	=> 'Hinweis: Das Sprachpaket der Erweiterung <strong>%1$s</strong> ist nicht mehr aktuell. (vorhanden: %2$s / benötigt: %3$s)',
diff --git "[ORIGINAL]/lukewcs\\limitreplies/language/en/acp_limitreplies.php" "[FORUM_EXT]/lukewcs\\limitreplies/language/en/acp_limitreplies.php"
--- "[ORIGINAL]/lukewcs\\limitreplies/language/en/acp_limitreplies.php"
+++ "[FORUM_EXT]/lukewcs\\limitreplies/language/en/acp_limitreplies.php"
@@ -48,9 +48,7 @@ $lang = array_merge($lang, [
 	'LIMITREPLIES_ENABLE_EXPLAIN'		=> 'With this switch you can deactivate the functionality without having to deactivate the extension completely.',
 	'LIMITREPLIES_WAIT_TIME'			=> 'Waiting period between two posts',
 	'LIMITREPLIES_WAIT_TIME_EXPLAIN'	=> 'Here you can specify after which waiting period a new reply is allowed in the topic if the last post was made by the same user. This value is also displayed in the explanation.',
-	'LIMITREPLIES_TIME_UNIT_MINUTES'	=> 'minutes',
-	'LIMITREPLIES_TIME_UNIT_HOURS'		=> 'hours',
-	'LIMITREPLIES_TIME_UNIT_DAYS'		=> 'days',
+	'LIMITREPLIES_MINUTES'				=> 'minutes',
 	'LIMITREPLIES_HINT_MODE'			=> 'Show explanation',
 	'LIMITREPLIES_HINT_MODE_EXPLAIN'	=> 'Here you can specify how the explanation should be displayed when the lock is active. The “On click” option refers to the reply and quote buttons. With the “Always” option, the explanation is displayed below the reply buttons.',
 	'LIMITREPLIES_HINT_MODE_ONCLICK'	=> 'On click (as info popup)',
diff --git "[ORIGINAL]/lukewcs\\limitreplies/language/en/limitreplies.php" "[FORUM_EXT]/lukewcs\\limitreplies/language/en/limitreplies.php"
--- "[ORIGINAL]/lukewcs\\limitreplies/language/en/limitreplies.php"
+++ "[FORUM_EXT]/lukewcs\\limitreplies/language/en/limitreplies.php"
@@ -41,16 +41,8 @@ if (empty($lang) || !is_array($lang))
 
 $lang = array_merge($lang, [
 	'LIMITREPLIES_MSG_REPLY_DENIED'	=> 'As long as the last post in this topic was from you and is newer than <strong>%1$s</strong>, you can only reply again from <strong>%2$s</strong>.',
-	'LIMITREPLIES_PLURAL_MINUTES'	=> [
+	'LIMITREPLIES_MINUTES_PLURAL' 	=> [
 		1							=> '1 minute',
 		2							=> '%u minutes',
 	],
-	'LIMITREPLIES_PLURAL_HOURS'		=> [
-		1							=> '1 hour',
-		2							=> '%u hours',
-	],
-	'LIMITREPLIES_PLURAL_DAYS'		=> [
-		1							=> '1 day',
-		2							=> '%u days',
-	],
 ]);
diff --git "[ORIGINAL]/lukewcs\\limitreplies/language/en/limitreplies_lang_author.php" "[FORUM_EXT]/lukewcs\\limitreplies/language/en/limitreplies_lang_author.php"
--- "[ORIGINAL]/lukewcs\\limitreplies/language/en/limitreplies_lang_author.php"
+++ "[FORUM_EXT]/lukewcs\\limitreplies/language/en/limitreplies_lang_author.php"
@@ -41,7 +41,7 @@ if (empty($lang) || !is_array($lang))
 
 $lang = array_merge($lang, [
 	'LIMITREPLIES_LANG_DESC'					=> 'English',
-	'LIMITREPLIES_LANG_VER'	 					=> '1.1.0',
+	'LIMITREPLIES_LANG_VER'	 					=> '1.0.0',
 	'LIMITREPLIES_LANG_AUTHOR'	 				=> 'LukeWCS',
 
 	'LIMITREPLIES_MSG_LANGUAGEPACK_OUTDATED'	=> 'Note: The language pack for the <strong>%1$s</strong> extension is no longer up to date. (available: %2$s / required: %3$s)',
diff --git "[ORIGINAL]/lukewcs\\limitreplies/migrations/v_1_1_0.php" "[ORIGINAL]/lukewcs\\limitreplies/migrations/v_1_1_0.php"
deleted file mode 100644
--- "[ORIGINAL]/lukewcs\\limitreplies/migrations/v_1_1_0.php"
+++ /dev/null
@@ -1,29 +0,0 @@
-<?php
-/**
-*
-* Limit Multiple Replies. An extension for the phpBB Forum Software package.
-*
-* @copyright (c) 2024, LukeWCS, https://github.com/LukeWCS
-* @license GNU General Public License, version 2 (GPL-2.0-only)
-*
-* Note: This extension is 100% genuine handcraft and consists of selected
-*       natural raw materials. There was no AI involved in making it.
-*
-*/
-
-namespace lukewcs\limitreplies\migrations;
-
-class v_1_1_0 extends \phpbb\db\migration\migration
-{
-	public static function depends_on()
-	{
-		return ['\lukewcs\limitreplies\migrations\v_1_0_0'];
-	}
-
-	public function update_data()
-	{
-		return [
-			['config.add', ['limitreplies_select_time_unit', 'minutes']],
-		];
-	}
-}
diff --git "[ORIGINAL]/lukewcs\\limitreplies/styles/all/template/event/viewtopic_body_footer_before.html" "[FORUM_EXT]/lukewcs\\limitreplies/styles/all/template/event/viewtopic_body_footer_before.html"
--- "[ORIGINAL]/lukewcs\\limitreplies/styles/all/template/event/viewtopic_body_footer_before.html"
+++ "[FORUM_EXT]/lukewcs\\limitreplies/styles/all/template/event/viewtopic_body_footer_before.html"
@@ -10,11 +10,6 @@
 *
 #}
 
-{% set const = {
-	HINT_MODE_ONCLICK	: 1,
-	HINT_MODE_ALWAYS	: 2,
-} %}
-
-{% if LIMITREPLIES_SELECT_HINT_MODE == const.HINT_MODE_ALWAYS %}
+{% if (LIMITREPLIES_SELECT_HINT_MODE ?? 0) == 2 %}
 	{% INCLUDE '@lukewcs_limitreplies/show_message.html' %}
 {% endif %}
diff --git "[ORIGINAL]/lukewcs\\limitreplies/styles/all/template/event/viewtopic_body_poll_before.html" "[FORUM_EXT]/lukewcs\\limitreplies/styles/all/template/event/viewtopic_body_poll_before.html"
--- "[ORIGINAL]/lukewcs\\limitreplies/styles/all/template/event/viewtopic_body_poll_before.html"
+++ "[FORUM_EXT]/lukewcs\\limitreplies/styles/all/template/event/viewtopic_body_poll_before.html"
@@ -10,13 +10,10 @@
 *
 #}
 
-{% set const = {
-	HINT_MODE_ONCLICK	: 1,
-	HINT_MODE_ALWAYS	: 2,
-} %}
-
 {% if LIMITREPLIES_MESSAGE is defined %}
-	{% if LIMITREPLIES_SELECT_HINT_MODE == const.HINT_MODE_ALWAYS %}
+	{% INCLUDEJS '@lukewcs_limitreplies/limitreplies.js' %}
+	{% INCLUDECSS '@lukewcs_limitreplies/limitreplies.css' %}
+	{% if LIMITREPLIES_SELECT_HINT_MODE == 2 %}
 		{% INCLUDE '@lukewcs_limitreplies/show_message.html' %}
 	{% endif %}
 
@@ -27,7 +24,4 @@
 			HintMode		: {{ LIMITREPLIES_SELECT_HINT_MODE|json_encode }},
 		});
 	</script>
-
-	{% INCLUDEJS '@lukewcs_limitreplies/limitreplies.js' %}
-	{% INCLUDECSS '@lukewcs_limitreplies/limitreplies.css' %}
 {% endif %}
diff --git "[ORIGINAL]/lukewcs\\limitreplies/styles/all/template/limitreplies.js" "[FORUM_EXT]/lukewcs\\limitreplies/styles/all/template/limitreplies.js"
--- "[ORIGINAL]/lukewcs\\limitreplies/styles/all/template/limitreplies.js"
+++ "[FORUM_EXT]/lukewcs\\limitreplies/styles/all/template/limitreplies.js"
@@ -11,6 +11,7 @@
 */
 
 (function ($) {
+
 'use strict';
 
 const HintModeOnClick	= 1;
@@ -28,4 +29,5 @@
 		$('a[href*="mode=quote"],a[href*="mode=reply"]').addClass('limitreplies_lock');
 	};
 });
+
 })(jQuery);
```
