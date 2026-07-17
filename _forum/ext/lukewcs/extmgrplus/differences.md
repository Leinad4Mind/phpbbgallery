Existem diferencas reais no codigo ou texto. Diferencas de formatacao (espacos, tabs) foram ignoradas abaixo.

```diff
diff --git "[ORIGINAL]/lukewcs\\extmgrplus/acp/settings_module.php" "[FORUM_EXT]/lukewcs\\extmgrplus/acp/settings_module.php"
--- "[ORIGINAL]/lukewcs\\extmgrplus/acp/settings_module.php"
+++ "[FORUM_EXT]/lukewcs\\extmgrplus/acp/settings_module.php"
@@ -15,9 +15,9 @@ namespace lukewcs\extmgrplus\acp;
 
 class settings_module
 {
-	public string $page_title;
-	public string $tpl_name;
-	public string $u_action;
+	public $page_title;
+	public $tpl_name;
+	public $u_action;
 
 	public function main()
 	{
diff --git "[ORIGINAL]/lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus.css" "[FORUM_EXT]/lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus.css"
--- "[ORIGINAL]/lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus.css"
+++ "[FORUM_EXT]/lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus.css"
@@ -1,234 +1,185 @@
-/* GENERAL >>> */
+/* GENERAL */
 
-button[type="submit"]:is([name="confirm"], [name="cancel"]),
-input:is([type="submit"], [type="button"], [type="reset"])[name^="extmgrplus_"] {
-	padding: 3px 4px;
+fieldset {
+	border-radius: 5px;
 }
 
-code {
-	background-color: #dddddd;
-	padding: 0 0.25em;
-	color: black;
+fieldset p.submit-buttons {
+	margin-top: 0;
+	padding: 0 4px 4px 4px;
 }
 
-.emp_inactive {
-	opacity: 0.5;
+fieldset dt label,
+fieldset dd label {
+	cursor: inherit;
 }
 
-.emp_unavailable {
-	opacity: 0.3;
+legend {
+	background: inherit;
+	margin: 2px 0 0 -11px;
+	border-top: inherit;
+	border-left: inherit;
+	border-radius: 5px 5px 0 0;
+	padding: 2px 10px;
+	top: 0;
 }
 
-.errorbox {
-	&.emp_warning {
-		background-color: #ffaa00;
-
-		& :is(a, a:visited) {
-			color: #505050;
+input[type="submit"][name="confirm"],
+input[type="submit"][name^="extmgrplus_"],
+input[type="button"][name^="extmgrplus_"],
+input[type="reset"][name^="extmgrplus_"] {
+	padding: 3px 4px;
 }
 
-		& :is(h3, p, a:hover) {
-			color: #303030;
-		}
+code {
+	background-color: #dddddd;
+	padding: 0 0.25em;
+	color: black;
 }
 
-	&.emp_success_error {
-		background: linear-gradient(#228822, #bc2a4d);
-	}
+.inactive {
+	opacity: 0.5;
 }
 
+/* Footer */
+
 .extmgrplus_footer {
 	margin-top: 1em;
 	text-align: center;
 	font-size: 0.75em;
 }
 
-#confirm {
 /* confirm_box (phpBB)*/
 
-	& h2 {
+#confirm h2 {
 	margin-bottom: 0.25em;
 }
 
-	& :is(.button1, .button2) {
-		color: #000000;
-		background: linear-gradient(to bottom, #d2d2d2 0%, #efefef 100%);
-		border: 1px solid #666666;
-		font-size: 0.85em;
-		font-family: "Lucida Grande", Verdana, Helvetica, Arial, sans-serif;
-		vertical-align: middle;
-
-		&:hover {
-			border: 1px solid #bc2a4d;
-			background: #efefef url("../../../../../adm/images/bg_button.gif") repeat bottom;
-			color: #bc2a4d;
-		}
-	}
-
-	& .button1 {
-		font-weight: bold;
-	}
-}
-
-/* <<< GENERAL */
-
-/* SETTINGS >>> */
-
-fieldset {
-	border-radius: 5px;
-
-	& p.submit-buttons {
-		margin-top: 0;
-		padding: 0 4px 4px 4px;
-	}
-
-	& :is(dt, dd) label {
-		cursor: inherit;
-	}
-
-	& dd a {
-		overflow-wrap: anywhere;
-	}
-}
-
-legend {
-	background: inherit;
-	margin: 2px 0 0 -11px;
-	border-top: inherit;
-	border-left: inherit;
-	border-radius: 5px 5px 0 0;
-	padding: 2px 10px;
-	top: 0;
-
-	& + .legend_explain {
-		width: 45%;
-	}
+/* SETTINGS */
 
-	&.legend_sub {
+legend.legend_sub {
 	border: 0;
 	margin: 1em 0;
 	padding: 0;
 	display: flex;
 	white-space: nowrap;
+}
 
-		&:after {
+legend.legend_sub:after {
 	content: "";
 	border-bottom: 1px solid #cccccc;
 	width: 100%;
 	margin: 0 0 0.5em 1em;
 }
-	}
-}
 
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
+
+.toggle:checked:before {
+	left: 2px;
+	content: "\f00c";
 }
 
-div.lukewcs_confirmbox {
 /* LukeWCSphpBBConfirmBox */
 
+div[id$="_confirmbox"] {
 	max-width: 450px;
 	border: 2px solid skyblue;
 	margin: 0.75em 0.5em;
 	padding: 0.25em 0.5em;
 	border-radius: 5px;
+	-webkit-box-shadow: 2px 2px 10px 1px rgba(121, 162, 179, 0.5);
 	box-shadow: 2px 2px 10px 1px rgba(121, 162, 179, 0.5);
+}
 
-	& h2 {
+div[id$="_confirmbox"] h2 {
 	margin: 0 0 0.25em 0;
 }
 
-	& p:last-of-type {
+div[id$="_confirmbox"] p:nth-of-type(2) {
 	text-align: center;
 	margin: 0;
 	padding: 0 4px 4px 4px;
 }
 
-	& input[type="button"] {
+div[id$="_confirmbox"] input[type="button"] {
 	padding: 3px 4px;
 }
-}
 
-input:is([type="submit"], [type="button"]):disabled,
-input.lukewcs_confirmbox_active {
+input[type="submit"]:disabled,
+input[type="button"]:disabled,
+input.confirmbox_active {
 	opacity: 0.5;
 	cursor: not-allowed;
 }
 
-/* <<< SETTINGS */
-
-/* EXTENSION MANAGER >>> */
+/* EXTENSION MANAGER */
 
 .js_link {
 	color: #105289;
+}
 
-	&:hover {
+.js_link:hover {
 	color: #bc2a4d;
 	text-decoration: underline;
 	cursor: pointer;
 }
 
-	&.disabled,
-	&.disabled:hover {
+.js_link.disabled,
+.js_link.disabled:hover {
 	color: #536482;
 	text-decoration: none;
 	cursor: not-allowed;
 	opacity: 0.5;
 }
-}
 
-table :is(th, td) i.icon,
-fieldset dd i.icon {
-	cursor: help;
+fieldset.quick a i.icon,
+.js_link i.icon {
+	margin: 0 0.3em 0 0;
+	font-size: 1.1em;
 }
 
 div.successbox i.icon,
@@ -241,12 +192,6 @@ div.successbox.notice i.icon {
 	font-size: 1.2em;
 }
 
-fieldset.quick a i.icon,
-.js_link i.icon {
-	margin: 0 0.3em 0 0;
-	font-size: 1.1em;
-}
-
 fieldset.ext_properties i.icon,
 thead th i.icon {
 	font-size: 1.1em;
@@ -255,109 +200,107 @@ thead th i.icon {
 
 fieldset.ext_properties dd {
 	color: inherit;
+}
 
-	& label {
+fieldset.ext_properties dd label {
 	font-size: inherit;
 	font-weight: bold;
+}
 
-		&:hover {
+fieldset.ext_properties dd label:hover {
 	color: inherit;
 }
-	}
 
-	& details {
+fieldset.ext_properties dd details {
 	border: 1px solid #cccccc;
 	border-radius: 3px;
+}
 
-		& summary {
+fieldset.ext_properties dd summary {
 	padding: 0.25em 0.5em;
 	cursor: pointer;
 	-webkit-user-select: none;
-			user-select: none;
+	-moz-user-select: none;
+	-ms-user-select: none;
 }
 
-		& div {
+fieldset.ext_properties dd details div {
 	border-top: 1px solid #cccccc;
 	font-size: inherit;
 	padding: 0.25em 0;
 	margin: 0 0.5em;
 }
-	}
-}
 
-#extmgrplus_list {
-	& input[type="checkbox"]:disabled {
+input[type="checkbox"]:disabled {
 	cursor: not-allowed;
 }
 
-	& input[name$="able_all"] {
-		padding: 1px 3px;
-		font-size: inherit;
+#extmgrplus_list input[name$="able_all"] {
+	padding: 1px 5px;
 }
 
-	& input[type="text"] {
+#extmgrplus_list input[type="text"] {
 	text-align: right;
 	padding: 0 2px;
 	margin: 0 2px;
 	background-color: #f9f9f9;
 }
 
-	& th:nth-of-type(1) {
+#extmgrplus_list th:nth-of-type(1) {
 	width: 1%;
 }
 
-	& th:nth-of-type(3) {
+#extmgrplus_list th:nth-of-type(3) {
 	width: 16%;
 }
 
-	& th:nth-of-type(1n+3) {
+#extmgrplus_list th:nth-of-type(1n+3) {
 	text-align: center;
 }
 
-	& th:nth-of-type(4) {
+#extmgrplus_list th:nth-of-type(4) {
 	width: 1%;
 }
 
-	& th:nth-of-type(5) {
+#extmgrplus_list th:nth-of-type(5) {
 	width: 10%;
 }
 
-	& th:nth-of-type(6) {
+#extmgrplus_list th:nth-of-type(6) {
 	width: 25%;
 }
 
-	& th:nth-of-type(1n+7) {
+#extmgrplus_list th:nth-of-type(1n+7) {
 	width: 1%;
 }
 
-	& td:nth-of-type(3) i.icon {
-		font-size: 1.2em;
+#extmgrplus_list td:nth-of-type(1) i.icon {
+	cursor: help;
 }
 
-	& td:nth-of-type(3) :is(span, strong, i.icon) + :is(strong, i.icon) {
-		margin-left: 0.3em;
+#extmgrplus_list td:nth-of-type(3) i.icon {
+	cursor: help;
+	font-size: 1.2em;
 }
 
-	& td:nth-of-type(3) i.icon:is(.fa-question-circle, .fa-exclamation-triangle) {
+#extmgrplus_list td:nth-of-type(3) i.icon:is(.fa-question-circle, .fa-exclamation-triangle, .fa-refresh) {
 	color: #df950d;
 }
 
-	& td:nth-of-type(1n+3) {
+#extmgrplus_list td:nth-of-type(1n+3) {
 	text-align: center;
 }
 
-	& td:nth-of-type(4) span {
+#extmgrplus_list td:nth-of-type(4) span {
 	cursor: help;
 }
 
-	& td:nth-of-type(7) i.icon {
+#extmgrplus_list td:nth-of-type(7) i.icon {
+	cursor: help;
 	font-size: 1.3em;
 }
-}
-
-/* <<< EXTENSION MANAGER */
 
-/* VERSIONCHECK PROGGRESS >>> */
+/* VERSIONCHECK PROGGRESS */
 
 .progress_container {
 	background-color: #f9f9f9;
@@ -365,14 +308,15 @@ fieldset.ext_properties dd {
 	border-radius: 5px;
 	position: relative;
 	margin: 1em 0 0.25em 0;
+}
 
-	& .progress_bar {
+.progress_bar {
 	background-color: lightgreen;
 	height: 100%;
 	border-radius: 5px;
 }
 
-	& .progress_value {
+.progress_value {
 	color: black;
 	position: absolute;
 	font-size: 0.85em;
@@ -381,13 +325,12 @@ fieldset.ext_properties dd {
 	right: 0;
 }
 
-	& .progress_anim {
+.progress_anim {
 	background-color: lightblue;
 	animation-name: progress_anim_block;
 	animation-timing-function: linear;
 	animation-fill-mode: forwards;
 }
-}
 
 @keyframes progress_anim_block {
 	from {
@@ -399,18 +342,12 @@ fieldset.ext_properties dd {
 	}
 }
 
-/* <<< VERSIONCHECK PROGGRESS */
-
-/* RESPONSIVE >>> */
+/* RESPONSIVE */
 
 @media (max-width: 700px){
 	legend {
 		margin: 2px 0 0 -6px;
 		padding: 2px 5px;
-
-		& + .legend_explain {
-			width: auto;
-		}
 	}
 
 	#extmgrplus_settings dd {
@@ -421,5 +358,3 @@ fieldset.ext_properties dd {
 		padding: 0.5em 0 0 0;
 	}
 }
-
-/* <<< RESPONSIVE */
diff --git "[ORIGINAL]/lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_acp_ext_details.html" "[ORIGINAL]/lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_acp_ext_details.html"
deleted file mode 100644
--- "[ORIGINAL]/lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_acp_ext_details.html"
+++ /dev/null
@@ -1,180 +0,0 @@
-{#
-*
-* Extension Manager Plus. An extension for the phpBB Forum Software package.
-*
-* @copyright (c) 2022, LukeWCS, https://www.wcsaga.org
-* @license GNU General Public License, version 2 (GPL-2.0-only)
-*
-* Note: This extension is 100% genuine handcraft and consists of selected
-*       natural raw materials. There was no AI involved in making it.
-*
-#}
-
-{% import '@lukewcs_extmgrplus/acp_ext_mgr_plus_macros.html' as common %}
-
-{% INCLUDE 'overall_header.html' %}
-
-<a href="{{ U_BACK }}" style="float: {{ S_CONTENT_FLOW_END }};">&laquo; {{ lang('BACK') }}</a>
-
-<h1>{{ lang('EXTENSIONS_ADMIN') }}</h1>
-
-<p>{{ lang('EXTENSIONS_EXPLAIN') }}</p>
-
-{% if S_VERSIONCHECK %}
-	{% if S_VERSIONCHECK_FAIL %}
-		<div class="errorbox notice">
-			<p>{{ lang('VERSIONCHECK_FAIL') }}</p>
-			<p>{{ VERSIONCHECK_FAIL_REASON }}</p>
-			<p><a href="{{ U_VERSIONCHECK_FORCE }}">{{ lang('VERSIONCHECK_FORCE_UPDATE') }}</a></p>
-		</div>
-	{% else %}
-		<div class="{% if S_UP_TO_DATE %}successbox{% else %}errorbox{% endif %}">
-			<p>{{ UP_TO_DATE_MSG }} - <a href="{{ U_VERSIONCHECK_FORCE }}">{{ lang('VERSIONCHECK_FORCE_UPDATE') }}</a></p>
-		</div>
-	{% endif %}
-{% endif %}
-
-{% EVENT acp_ext_details_notice %}
-
-<fieldset>
-	<legend>{{ lang('EXT_DETAILS') }}</legend>
-
-	{% if META_DISPLAY_NAME %}
-		<dl>
-			<dt><label>{{ lang('DISPLAY_NAME') ~ lang('COLON') }}</label></dt>
-			<dd>
-				{{ EXTMGRPLUS_DETAILS.cdb_ext ? {
-					1:	common.icon('fa-database', 'EXTMGRPLUS_TOOLTIP_CDB_EXT'),
-					2:	common.icon('fa-star', 'EXTMGRPLUS_TOOLTIP_CDB_EXT_OFFICIAL'),
-				}[EXTMGRPLUS_DETAILS.cdb_ext] }}
-				<strong id="meta_display_name">{{ META_DISPLAY_NAME }}</strong>
-			</dd>
-		</dl>
-	{% endif %}
-	<dl>
-		<dt><label>{{ lang('CLEAN_NAME') ~ lang('COLON') }}</label></dt>
-		<dd><strong id="meta_name">{{ META_NAME }}</strong></dd>
-	</dl>
-	{% if META_DESCRIPTION %}
-		<dl>
-			<dt><label>{{ lang('DESCRIPTION') ~ lang('COLON') }}</label></dt>
-			<dd><span id="meta_description">{{ META_DESCRIPTION }}</span></dd>
-		</dl>
-	{% endif %}
-	<dl>
-		<dt><label>{{ lang('VERSION') ~ lang('COLON') }}</label></dt>
-		<dd><span id="meta_version">{{ META_VERSION }}</span></dd>
-	</dl>
-	{% if META_HOMEPAGE && META_HOMEPAGE != EXTMGRPLUS_DETAILS.cdb_page %}
-		<dl>
-			<dt><label>{{ lang('HOMEPAGE') ~ lang('COLON') }}</label></dt>
-			<dd><strong id="meta_homepage"><a href="{{ META_HOMEPAGE }}">{{ META_HOMEPAGE }}</a></strong></dd>
-		</dl>
-	{% endif %}
-	{% if EXTMGRPLUS_DETAILS.cdb_page %}
-		<dl>
-			<dt><label>{{ lang('EXTMGRPLUS_DETAILS_CDB_PAGE') ~ lang('COLON') }}</label></dt>
-			<dd><strong><a href="{{ EXTMGRPLUS_DETAILS.cdb_page }}">{{ EXTMGRPLUS_DETAILS.cdb_page }}</a></strong></dd>
-		</dl>
-	{% endif %}
-	{% if EXTMGRPLUS_DETAILS.version_url %}
-		<dl>
-			<dt><label>{{ lang('EXTMGRPLUS_DETAILS_VERSION_URL') ~ lang('COLON') }}</label></dt>
-			<dd><strong><a href="{{ EXTMGRPLUS_DETAILS.version_url }}">{{ EXTMGRPLUS_DETAILS.version_url }}</a></strong></dd>
-		</dl>
-	{% endif %}
-	{% if META_TIME %}
-		<dl>
-			<dt><label>{{ lang('TIME') ~ lang('COLON') }}</label></dt>
-			<dd><span id="meta_time">{{ META_TIME }}</span></dd>
-		</dl>
-	{% endif %}
-	<dl>
-		<dt><label>{{ lang('LICENSE') ~ lang('COLON') }}</label></dt>
-		<dd><span id="meta_license">{{ META_LICENSE }}</span></dd>
-	</dl>
-</fieldset>
-
-{% if S_VERSIONCHECK && !S_UP_TO_DATE %}
-	<fieldset>
-		<legend>{{ lang('LATEST_VERSION') }}</legend>
-
-		{% for updates_available in loops.updates_available %}
-			<fieldset>
-				<dl>
-					<dt><label>{{ lang('VERSION') ~ lang('COLON') }}</label></dt>
-					<dd><strong>{{ updates_available.current }}</strong></dd>
-				</dl>
-				{% if updates_available.download %}
-					<dl>
-						<dt><label>{{ lang('DOWNLOAD_LATEST') }}</label></dt>
-						<dd><strong><a href="{{ updates_available.download }}">{{ lang('DOWNLOAD') }} {{ META_NAME }} {{ LATEST_VERSION }}</a></strong></dd>
-					</dl>
-				{% endif %}
-				{% if updates_available.announcement %}
-					<dl>
-						<dt><label>{{ lang('ANNOUNCEMENT_TOPIC') }}</label></dt>
-						<dd><strong><a href="{{ updates_available.announcement }}">{{ lang('RELEASE_ANNOUNCEMENT') }}</a></strong></dd>
-					</dl>
-				{% endif %}
-			</fieldset>
-		{% endfor %}
-	</fieldset>
-{% endif %}
-
-{% if META_REQUIRE_PHPBB || META_REQUIRE_PHP %}
-	<fieldset>
-		<legend>{{ lang('REQUIREMENTS') }}</legend>
-
-		{% if META_REQUIRE_PHPBB %}
-			<dl{% if META_REQUIRE_PHPBB_FAIL %} class="requirements_not_met"{% endif %}>
-				<dt><label>{{ lang('PHPBB_VERSION') ~ lang('COLON') }}</label></dt>
-				<dd><span id="require_phpbb">{{ META_REQUIRE_PHPBB }}</span></dd>
-			</dl>
-		{% endif %}
-		{% if META_REQUIRE_PHP %}
-			<dl{% if META_REQUIRE_PHP_FAIL %} class="requirements_not_met"{% endif %}>
-				<dt><label>{{ lang('PHP_VERSION') ~ lang('COLON') }}</label></dt>
-				<dd><span id="require_php">{{ META_REQUIRE_PHP }}</span></dd>
-			</dl>
-		{% endif %}
-	</fieldset>
-{% endif %}
-
-<fieldset>
-	<legend>{{ lang('AUTHOR_INFORMATION') }}</legend>
-
-	{% for meta_authors in loops.meta_authors %}
-		<fieldset>
-			<dl>
-				<dt><label>{{ lang('AUTHOR_NAME') ~ lang('COLON') }}</label></dt>
-				<dd><strong>{{ meta_authors.AUTHOR_NAME }}</strong></dd>
-			</dl>
-			{% if meta_authors.AUTHOR_EMAIL %}
-				<dl>
-					<dt><label>{{ lang('AUTHOR_EMAIL') ~ lang('COLON') }}</label></dt>
-					<dd><strong><a href="mailto:{{ meta_authors.AUTHOR_EMAIL }}">{{ meta_authors.AUTHOR_EMAIL }}</a></strong></dd>
-				</dl>
-			{% endif %}
-			{% if meta_authors.AUTHOR_HOMEPAGE %}
-				<dl>
-					<dt><label>{{ lang('AUTHOR_HOMEPAGE') ~ lang('COLON') }}</label></dt>
-					<dd><strong><a href="{{ meta_authors.AUTHOR_HOMEPAGE }}">{{ meta_authors.AUTHOR_HOMEPAGE }}</a></strong></dd>
-				</dl>
-			{% endif %}
-			{% if meta_authors.AUTHOR_ROLE %}
-				<dl>
-					<dt><label>{{ lang('AUTHOR_ROLE') ~ lang('COLON') }}</label></dt>
-					<dd><strong>{{ meta_authors.AUTHOR_ROLE }}</strong></dd>
-				</dl>
-			{% endif %}
-		</fieldset>
-	{% endfor %}
-</fieldset>
-
-{% EVENT acp_ext_details_end %}
-
-{{ common.footer(EXTMGRPLUS_METADATA) }}
-
-{% INCLUDE 'overall_footer.html' %}
-{% INCLUDECSS '@lukewcs_extmgrplus/acp_ext_mgr_plus.css' %}
diff --git "[ORIGINAL]/lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_acp_ext_list.html" "[FORUM_EXT]/lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_acp_ext_list.html"
--- "[ORIGINAL]/lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_acp_ext_list.html"
+++ "[FORUM_EXT]/lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_acp_ext_list.html"
@@ -25,6 +25,8 @@
 	CHECKBOX_LAST	: 2,
 } %}
 
+<a id="maincontent"></a>
+
 <h1>{{ lang('EXTENSIONS_ADMIN') }}</h1>
 
 <p>{{ lang('EXTENSIONS_EXPLAIN') }}</p>
@@ -88,7 +90,7 @@
 		<fieldset class="ext_properties" style="display: none;">
 			<legend>{{ lang('EXTMGRPLUS_SECTION_SETTINGS') }}</legend>
 
-			<dl{{ !EXTMGRPLUS_SWITCH_ORDER_AND_IGNORE ? ' class="emp_inactive"' }}>
+			<dl{{ !EXTMGRPLUS_SWITCH_ORDER_AND_IGNORE ? ' class="inactive"' }}>
 				<dt>
 					<label>{{ lang('EXTMGRPLUS_ORDER', common.icon('fa-sort')) ~ lang('COLON') }}</label><br>
 				</dt>
@@ -104,7 +106,7 @@
 				</dd>
 			</dl>
 
-			<dl{{ !EXTMGRPLUS_SWITCH_ORDER_AND_IGNORE ? ' class="emp_inactive"' }}>
+			<dl{{ !EXTMGRPLUS_SWITCH_ORDER_AND_IGNORE ? ' class="inactive"' }}>
 				<dt>
 					<label>{{ lang('EXTMGRPLUS_IGNORE', common.icon('fa-ban')) ~ lang('COLON') }}</label><br>
 				</dt>
@@ -136,8 +138,8 @@
 		</colgroup>
 		<thead>
 			<tr>
-				<th>
-					{{ common.icon('fa-database', 'EXTMGRPLUS_COL_CDB') }}<span style="display: none;">{{ lang('EXTMGRPLUS_COL_CDB') }}</span>
+				<th title="{{ lang('EXTMGRPLUS_COL_CDB') }}">
+					{{ common.icon('fa-database') }}<span style="display: none;">{{ lang('EXTMGRPLUS_COL_CDB') }}</span>
 				</th>
 				<th>
 					{{ lang('EXTENSION_NAME') }}
@@ -145,8 +147,8 @@
 				<th>
 					{{ lang('CURRENT_VERSION') }}
 				</th>
-				<th{{ !EXTMGRPLUS_SWITCH_MIGRATION_COL ? ' style="display: none;"' }}>
-					{{ common.icon('fa-arrow-up', 'EXTMGRPLUS_COL_MIGRATIONS') }}<span style="display: none;">{{ lang('EXTMGRPLUS_COL_MIGRATIONS') }}</span>
+				<th{{ !EXTMGRPLUS_SWITCH_MIGRATION_COL ? ' style="display: none;"' }} title="{{ lang('EXTMGRPLUS_COL_MIGRATIONS') }}">
+					{{ common.icon('fa-arrow-up') }}<span style="display: none;">{{ lang('EXTMGRPLUS_COL_MIGRATIONS') }}</span>
 				</th>
 				<th>
 					{{ lang('EXTENSION_OPTIONS') }}
@@ -154,14 +156,14 @@
 				<th>
 					{{ lang('EXTENSION_ACTIONS') }}
 				</th>
-				<th>
-					{{ common.icon('fa-check', 'EXTMGRPLUS_COL_SELECT') }}<span style="display: none;">{{ lang('EXTMGRPLUS_COL_SELECT') }}</span>
+				<th title="{{ lang('EXTMGRPLUS_COL_SELECT') }}">
+					{{ common.icon('fa-check') }}<span style="display: none;">{{ lang('EXTMGRPLUS_COL_SELECT') }}</span>
 				</th>
-				<th style="display: none;">
-					{{ common.icon('fa-sort', 'EXTMGRPLUS_COL_ORDER') }}<span style="display: none;">{{ lang('EXTMGRPLUS_COL_ORDER') }}</span>
+				<th title="{{ lang('EXTMGRPLUS_COL_ORDER') }}" style="display: none;">
+					{{ common.icon('fa-sort') }}<span style="display: none;">{{ lang('EXTMGRPLUS_COL_ORDER') }}</span>
 				</th>
-				<th style="display: none;">
-					{{ common.icon('fa-ban', 'EXTMGRPLUS_COL_IGNORE') }}<span style="display: none;">{{ lang('EXTMGRPLUS_COL_IGNORE') }}</span>
+				<th title="{{ lang('EXTMGRPLUS_COL_IGNORE') }}" style="display: none;">
+					{{ common.icon('fa-ban') }}<span style="display: none;">{{ lang('EXTMGRPLUS_COL_IGNORE') }}</span>
 				</th>
 			</tr>
 		</thead>
@@ -207,10 +209,11 @@
 					{% set vc_obj = EXTMGRPLUS_LIST_VERSIONCHECK[ext.NAME] ?? {} %}
 					<tr class="ext_{{ list }} row-highlight">
 						<td>
-							{{ vc_obj.cdb_ext ? {
-								1:	common.icon('fa-database', 'EXTMGRPLUS_TOOLTIP_CDB_EXT'),
-								2:	common.icon('fa-star', 'EXTMGRPLUS_TOOLTIP_CDB_EXT_OFFICIAL'),
-							}[vc_obj.cdb_ext] }}
+							{% apply spaceless %}
+							{% if vc_obj.cdb_ext === true %}
+								<span title="{{ lang('EXTMGRPLUS_TOOLTIP_CDB_EXT')|e('html') }}">{{ common.icon('fa-database') }}</span>
+							{% endif %}
+							{% endapply %}
 						</td>
 						<td>
 							{% apply spaceless %}
@@ -233,14 +236,14 @@
 									<strong class="{{ vc_obj.current == 'NOUPD' ? 'current-ext' : 'outdated-ext' }}">{{ ext.META_VERSION }}</strong>
 								{% endif %}
 								{% if vc_obj.current === false %}
-									{{ common.icon('fa-chain-broken', 'EXTMGRPLUS_TOOLTIP_NO_VERSIONCHECK') }}
+									<span title="{{ lang('EXTMGRPLUS_TOOLTIP_NO_VERSIONCHECK')|e('html') }}">&nbsp;{{ common.icon('fa-chain-broken') }}</span>
 								{% elseif vc_obj.current == 'ERROR' %}
-									{{ common.icon('fa-exclamation-triangle', 'EXTMGRPLUS_TOOLTIP_VERSIONCHECK_ERROR') }}
+									<span title="{{ lang('EXTMGRPLUS_TOOLTIP_VERSIONCHECK_ERROR')|e('html') }}">&nbsp;{{ common.icon('fa-exclamation-triangle') }}</span>
 								{% elseif vc_obj.current is empty %}
-									{{ common.icon('fa-question-circle', 'EXTMGRPLUS_TOOLTIP_VERSIONCHECK_EMPTY') }}
+									<span title="{{ lang('EXTMGRPLUS_TOOLTIP_VERSIONCHECK_EMPTY')|e('html') }}">&nbsp;{{ common.icon('fa-question-circle') }}</span>
 								{% elseif vc_obj.current != 'NOUPD' %}
-									{{ common.icon('fa-exclamation-circle outdated-ext', 'EXTMGRPLUS_TOOLTIP_OUTDATED') }}
-									<strong class="current-ext">({{ vc_obj.current }})</strong>
+									<span title="{{ lang('EXTMGRPLUS_TOOLTIP_OUTDATED')|e('html') }}">&nbsp;{{ common.icon('fa-exclamation-circle outdated-ext') }}</span>
+									<strong class="current-ext">&nbsp;({{ vc_obj.current }})</strong>
 								{% endif %}
 							{% endif %}
 							{% endapply %}
@@ -250,7 +253,7 @@
 							{% if list != 'enabled' && EXTMGRPLUS_SWITCH_MIGRATION_COL %}
 								{% set count = EXTMGRPLUS_LIST_MIGRATIONS[ext.NAME] ?? 0 %}
 								{% if EXTMGRPLUS_LIST_IGNORE[ext.NAME] is defined %}
-									{{ common.icon('fa-ban', 'EXTMGRPLUS_TOOLTIP_IS_IGNORED') }}
+									<span title="{{ lang('EXTMGRPLUS_TOOLTIP_IS_IGNORED')|e('html') }}">{{ common.icon('fa-ban') }}</span>
 								{% elseif count %}
 									<span title="{{ lang('EXTMGRPLUS_TOOLTIP_HAS_MIGRATION')|e('html') }}">{{ count }}</span>
 								{% endif %}
@@ -270,23 +273,15 @@
 								<a href="{{ action.U_ACTION }}"{{ action.L_ACTION_EXPLAIN ? ' title="' ~ action.L_ACTION_EXPLAIN ~ '"' }}>{{ action.L_ACTION }}</a>
 								{{ !loop.last ? '<span>&nbsp;|&nbsp;</span>' }}
 							{% endfor %}
-							{% if list == 'enabled' && EXTMGRPLUS_SWITCH_SETTINGS_LINK %}
-								<span>&nbsp;|&nbsp;</span>
-								{% if EXTMGRPLUS_LIST_MODULES[ext.NAME] is defined %}
-									<a href="{{ EXTMGRPLUS_LIST_MODULES[ext.NAME] }}" title="{{ lang('EXTMGRPLUS_TOOLTIP_SETTINGS') }}">{{ lang('SETTINGS') }}</a>
-								{% else %}
-									<span class="emp_unavailable">{{ lang('SETTINGS') }}</span>
-								{% endif %}
-							{% endif %}
 							{% endapply %}
 						</td>
 						<td>
 							{% apply spaceless %}
 							{% if list != 'not_installed' && ext.NAME is defined && (ext.NAME != 'lukewcs/extmgrplus' || EXTMGRPLUS_SWITCH_SELF_DISABLE) %}
 								{% if EXTMGRPLUS_LIST_IGNORE[ext.NAME] is defined %}
-									{{ common.icon('fa-ban', 'EXTMGRPLUS_TOOLTIP_IS_IGNORED') }}
+									<span title="{{ lang('EXTMGRPLUS_TOOLTIP_IS_IGNORED')|e('html') }}">{{ common.icon('fa-ban') }}
 								{% elseif EXTMGRPLUS_LIST_MIGRATIONS[ext.NAME] is defined && !EXTMGRPLUS_SWITCH_MIGRATIONS %}
-									<input type="checkbox" class="checkbox" title="{{ lang('EXTMGRPLUS_TOOLTIP_IS_LOCKED')|e('html') }}" disabled>
+									<input type="checkbox" name="ext_mark_{{ list }}[]" class="checkbox" title="{{ lang('EXTMGRPLUS_TOOLTIP_IS_LOCKED')|e('html') }}" disabled>
 								{% else %}
 									<input type="checkbox" name="ext_mark_{{ list }}[]" class="checkbox" title="{{ lang('EXTMGRPLUS_TOOLTIP_SELECT')|e('html') }}" value="{{ ext.NAME }}"{{ EXTMGRPLUS_LIST_SELECTED[ext.NAME] is defined ? ' checked' }}>
 								{% endif %}
@@ -296,7 +291,7 @@
 						<td style="display: none;">
 							{% apply spaceless %}
 							{% if ext.NAME is defined && ext.NAME != 'lukewcs/extmgrplus' && EXTMGRPLUS_SWITCH_ORDER_AND_IGNORE %}
-								<input type="text" name="ext_order[{{ ext.NAME }}]" size="2" maxlength="3"{{ EXTMGRPLUS_LIST_IGNORE[ext.NAME] is defined ? ' class="emp_inactive"' }} title="{{ lang('EXTMGRPLUS_TOOLTIP_ORDER')|e('html') }}" value="{{ EXTMGRPLUS_LIST_ORDER[ext.NAME] ?? '' }}" pattern="^\+?[0-9]{1,2}$">
+								<input type="text" name="ext_order[{{ ext.NAME }}]" size="2" maxlength="3"{{ EXTMGRPLUS_LIST_IGNORE[ext.NAME] is defined ? ' class="inactive"' }} title="{{ lang('EXTMGRPLUS_TOOLTIP_ORDER')|e('html') }}" value="{{ EXTMGRPLUS_LIST_ORDER[ext.NAME] ?? '' }}" pattern="^\+?[0-9]{1,2}$">
 							{% endif %}
 							{% endapply %}
 						</td>
@@ -363,7 +358,7 @@
 		</fieldset>
 	{% elseif type == 'save_checkboxes' %}
 		<input type="submit" name="extmgrplus_save_checkboxes" value="save_checkboxes" hidden>
-	{% elseif type ends with 'able_all' %}
+	{% elseif type == 'disable_all' || type == 'enable_all'%}
 		{% set type_upper = type|upper %}
 		<input type="submit" name="extmgrplus_{{ type }}" class="button1" title="{{ lang('EXTMGRPLUS_TOOLTIP_' ~ type_upper)|e('html') }}" value="{{ lang('EXTMGRPLUS_' ~ type_upper) }}"{{ !enabled ? ' disabled' }}>
 	{% endif %}
diff --git "[ORIGINAL]/lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_acp_ext_list.js" "[FORUM_EXT]/lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_acp_ext_list.js"
--- "[ORIGINAL]/lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_acp_ext_list.js"
+++ "[FORUM_EXT]/lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_acp_ext_list.js"
@@ -97,7 +97,7 @@ function setButtonState(e) {
 };
 
 function setInputBoxState(e) {
-	$('input[name="ext_order[' + e.currentTarget.value + ']"]').toggleClass('emp_inactive', e.currentTarget.checked);
+	$('input[name="ext_order[' + e.currentTarget.value + ']"]').toggleClass('inactive', e.currentTarget.checked);
 };
 
 /*
diff --git "[ORIGINAL]/lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_confirm_body.html" "[FORUM_EXT]/lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_confirm_body.html"
--- "[ORIGINAL]/lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_confirm_body.html"
+++ "[FORUM_EXT]/lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_confirm_body.html"
@@ -18,9 +18,7 @@
 
 <p>{{ lang('EXTENSIONS_EXPLAIN') }}</p>
 
-{% if EXTMGRPLUS_ACTION_MODE -%}
 <p>{{ lang('EXTENSION_' ~ EXTMGRPLUS_ACTION_MODE ~ '_EXPLAIN') }}</p>
-{%- endif %}
 
 <form id="confirm" method="post" action="{{ S_CONFIRM_ACTION }}">
 	<fieldset>
@@ -28,15 +26,15 @@
 
 		<p>{{ MESSAGE_TEXT }}</p>
 
-		{% if EXTMGRPLUS_ACTION_MODE == 'DISABLE' && 'lukewcs/extmgrplus' in S_HIDDEN_FIELDS -%}
+		{% if EXTMGRPLUS_SELF_DISABLE %}
 			<p>{{ lang('EXTMGRPLUS_MSG_SELF_DISABLE') }}</p>
-		{%- endif %}
+		{% endif %}
 
 		{{ S_HIDDEN_FIELDS }}
 
 		<fieldset class="submit-buttons">
-			<button type="submit" name="confirm" value="{{ lang('YES') }}" class="button1">{{ lang(EXTMGRPLUS_CONFIRM_YES ?? 'YES') }}</button>
-			<button type="submit" name="cancel" value="{{ lang('NO') }}" class="button2">{{ lang(EXTMGRPLUS_CONFIRM_NO ?? 'NO') }}</button>
+			<input type="submit" name="confirm" value="{{ lang('YES') }}" class="button1">&nbsp;
+			<input type="submit" name="cancel" value="{{ lang('NO') }}" class="button2">
 		</fieldset>
 	</fieldset>
 
diff --git "[ORIGINAL]/lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_macros.html" "[FORUM_EXT]/lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_macros.html"
--- "[ORIGINAL]/lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_macros.html"
+++ "[FORUM_EXT]/lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_macros.html"
@@ -20,11 +20,8 @@
 	{% endif %}
 {% endmacro %}
 
-{% macro icon(classes, title = null, decorative = true) -%}
-	<i class="icon {{ classes }}"{{
-		(title != null ? ' title="' ~ lang(title)|e('html') ~ '"') ~
-		(decorative ? ' aria-hidden="true"')
-	}}></i>
+{% macro icon(classes, decorative = true) -%}
+	<i class="icon {{ classes }}"{{ decorative ? ' aria-hidden="true"' }}></i>
 {%- endmacro %}
 
 {% macro footer(metadata) %}
@@ -32,7 +29,7 @@
 		{{ metadata.ext_name }} {{ metadata.ext_ver }} &copy; {{ metadata.ext_copyright }}
 		{% if metadata.lang_ver is defined %}
 			<br>
-			{{ metadata.lang_desc|e('html') }} {{ metadata.lang_ver|e('html') }} &copy; {{ metadata.lang_author|e('html') }}
+			{{ metadata.lang_desc|e('html') }} {{ metadata.lang_ver|e('html') }} &bull; {{ metadata.lang_author|e('html') }}
 		{% endif %}
 	</p>
 {% endmacro %}
diff --git "[ORIGINAL]/lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_message_body.html" "[FORUM_EXT]/lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_message_body.html"
--- "[ORIGINAL]/lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_message_body.html"
+++ "[FORUM_EXT]/lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_message_body.html"
@@ -22,7 +22,7 @@
 	<p>{{ lang('EXTENSION_' ~ EXTMGRPLUS_ACTION_MODE ~ '_EXPLAIN') }}</p>
 {%- endif %}
 
-<div class="{{ {0: 'successbox', 1: 'errorbox', 2: 'errorbox emp_warning', 3: 'errorbox emp_success_error'}[EXTMGRPLUS_TRIGGER_ERROR] }}">
+<div class="{{ S_USER_NOTICE ? 'successbox' : 'errorbox' }}">
 	<h3>{{ MESSAGE_TITLE }}</h3>
 
 	<p>{{ MESSAGE_TEXT }}</p>
diff --git "[ORIGINAL]/lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_settings.html" "[FORUM_EXT]/lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_settings.html"
--- "[ORIGINAL]/lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_settings.html"
+++ "[FORUM_EXT]/lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_settings.html"
@@ -16,6 +16,8 @@
 
 {% set switch_type = TOGGLECTRL_TYPE ?? 'toggle' %}
 
+<a id="maincontent"></a>
+
 <h1>{{ lang('EXTENSIONS_ADMIN') }}</h1>
 
 <p>{{ lang('EXTENSIONS_EXPLAIN') }}</p>
@@ -92,22 +94,22 @@
 
 		<dl>
 			<dt>
-				<label>{{ lang('EXTMGRPLUS_VC_LIMIT') ~ lang('COLON') }}</label><br>
-				<span>{{ lang('EXTMGRPLUS_VC_LIMIT_EXPLAIN') }}</span>
+				<label>{{ lang('EXTMGRPLUS_INSTRUCTIONS') ~ lang('COLON') }}</label><br>
+				<span>{{ lang('EXTMGRPLUS_INSTRUCTIONS_EXPLAIN') }}</span>
 			</dt>
 			<dd>
-				{{ _self.number('extmgrplus_number_vc_limit', EXTMGRPLUS_NUMBER_VC_LIMIT, 1, 99) }}
-				{{ lang('SECONDS') }}
+				{{ _self.switch('extmgrplus_switch_instructions', EXTMGRPLUS_SWITCH_INSTRUCTIONS, switch_type) }}
 			</dd>
 		</dl>
 
 		<dl>
 			<dt>
-				<label>{{ lang('EXTMGRPLUS_SETTING_LINKS') ~ lang('COLON') }}</label><br>
-				<span>{{ lang('EXTMGRPLUS_SETTING_LINKS_EXPLAIN') }}</span>
+				<label>{{ lang('EXTMGRPLUS_VC_LIMIT') ~ lang('COLON') }}</label><br>
+				<span>{{ lang('EXTMGRPLUS_VC_LIMIT_EXPLAIN') }}</span>
 			</dt>
 			<dd>
-				{{ _self.switch('extmgrplus_switch_settings_link', EXTMGRPLUS_SWITCH_SETTINGS_LINK, switch_type) }}
+				{{ _self.number('extmgrplus_number_vc_limit', EXTMGRPLUS_NUMBER_VC_LIMIT, 1, 99) }}
+				{{ lang('SECONDS') }}
 			</dd>
 		</dl>
 
@@ -124,17 +126,7 @@
 		</dl>
 
 		<legend class="legend_sub">{{ lang('EXTMGRPLUS_SECTION_EXPERT_SETTINGS') }}</legend>
-		<p class="legend_explain">{{ lang('EXTMGRPLUS_EXPERT_SETTINGS_EXPLAIN') }}</p>
-
-		<dl>
-			<dt>
-				<label>{{ lang('EXTMGRPLUS_INSTRUCTIONS') ~ lang('COLON') }}</label><br>
-				<span>{{ lang('EXTMGRPLUS_INSTRUCTIONS_EXPLAIN') }}</span>
-			</dt>
-			<dd>
-				{{ _self.switch('extmgrplus_switch_instructions', EXTMGRPLUS_SWITCH_INSTRUCTIONS, switch_type) }}
-			</dd>
-		</dl>
+		<p>{{ lang('EXTMGRPLUS_EXPERT_SETTINGS_EXPLAIN') }}</p>
 
 		<dl>
 			<dt>
@@ -175,7 +167,7 @@
 				<span>{{ lang('EXTMGRPLUS_DEFAULTS_EXP') }}</span>
 			</dt>
 			<dd>
-				<input type="button" class="button2" name="extmgrplus_defaults" value="{{ lang('EXTMGRPLUS_BUTTON_DEFAULTS') }}">
+				{{ _self.button('extmgrplus_defaults', 'EXTMGRPLUS_BUTTON_DEFAULTS') }}
 			</dd>
 		</dl>
 	</fieldset>
@@ -232,13 +224,17 @@
 	}}>
 {%- endmacro %}
 
+{% macro button(name, lang_var) -%}
+	<input type="button" class="button2" name="{{ name }}" value="{{ lang(lang_var) }}">
+{%- endmacro %}
+
 {% macro confirmbox(name, message, default = false) -%}
-	<div class="lukewcs_confirmbox" data-name="{{ name }}" data-default="{{ default }}" style="display: none;">
+	<div id="{{ name }}_confirmbox" data-default="{{ default }}" style="display: none;">
 		<h2>{{ lang('CONFIRM') }}</h2>
 		<p>{{ message }}</p>
 		<p>
-			<input type="button" class="button1" name="lukewcs_confirmbox_yes" value="{{ lang('YES') }}">&nbsp;
-			<input type="button" class="button2" name="lukewcs_confirmbox_no" value="{{ lang('NO') }}">
+			<input type="button" class="button1" name="{{ name }}_confirm_yes" value="{{ lang('YES') }}">&nbsp;
+			<input type="button" class="button2" name="{{ name }}_confirm_no" value="{{ lang('NO') }}">
 		</p>
 	</div>
 {%- endmacro %}
diff --git "[ORIGINAL]/lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_settings.js" "[FORUM_EXT]/lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_settings.js"
--- "[ORIGINAL]/lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_settings.js"
+++ "[FORUM_EXT]/lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_settings.js"
@@ -11,6 +11,7 @@
 */
 
 (function ($) {
+
 'use strict';
 
 /*
@@ -19,34 +20,28 @@
 
 class LukeWCSphpBBConfirmBox {
 /*
-		* phpBB ConfirmBox class for checkboxes and yes/no radio buttons - v1.5.1
+* phpBB ConfirmBox class for checkboxes and yes/no radio buttons - v1.4.3
 * @copyright (c) 2023, LukeWCS, https://www.wcsaga.org
 * @license GNU General Public License, version 2 (GPL-2.0-only)
 */
-
 	constructor(submitSelector, animDuration = 0) {
 		let _this = this;
 		this.$submitObject	= $(submitSelector);
 		this.$formObject	= this.$submitObject.parents('form');
 		this.animDuration	= animDuration;
 
-			this.$formObject.find('div.lukewcs_confirmbox').each(function () {
-				$('input[name="' + $(this).attr('data-name') + '"]').on('change', _this.#Show);
-				$(this).find('input[type="button"]')				.on('click'	, _this.#Button);
+		this.$formObject.find('div[id$="_confirmbox"]').each(function () {
+			const elementName = this.id.replace('_confirmbox', '');
+
+			$('input[name="' + elementName + '"]')				.on('change'	, _this.#Show);
+			$('input[name^="' + elementName + '_confirm_"]')	.on('click'		, _this.#Button);
 		});
 		this.$formObject										.on('reset'		, _this.HideAll);
 	}
 
-		HideAll = () => {
-			const $elementObject	= this.$formObject.find('input.lukewcs_confirmbox_active');
-			const $confirmBoxObject	= this.$formObject.find('div.lukewcs_confirmbox');
-
-			this.#changeBoxState($elementObject, $confirmBoxObject, false);
-		}
-
 	#Show = (e) => {
 		const $elementObject	= $('input[name="' + e.target.name + '"]');
-			const $confirmBoxObject	= $('div.lukewcs_confirmbox[data-name="' + e.target.name + '"]');
+		const $confirmBoxObject	= $('div[id="' + e.target.name + '_confirmbox"]');
 
 		if ($elementObject.prop('checked') != $confirmBoxObject.attr('data-default')) {
 			this.#changeBoxState($elementObject, $confirmBoxObject, true);
@@ -54,12 +49,12 @@
 	}
 
 	#Button = (e) => {
-			const elementName		= $(e.target).parents('div.lukewcs_confirmbox').attr('data-name');
+		const elementName		= e.target.name.replace(/_confirm_.*/, '');
 		const $elementObject	= $('input[name="' + elementName + '"]');
+		const $confirmBoxObject	= $('div[id="' + elementName + '_confirmbox"]');
 		const elementType		= $elementObject.attr('type');
-			const $confirmBoxObject	= $('div.lukewcs_confirmbox[data-name="' + elementName + '"]');
 
-			if (e.target.name == 'lukewcs_confirmbox_no') {
+		if (e.target.name.endsWith('_confirm_no')) {
 			if (elementType == 'checkbox') {
 				$elementObject.prop('checked', $confirmBoxObject.attr('data-default'));
 			} else if (elementType == 'radio') {
@@ -69,11 +64,18 @@
 		this.#changeBoxState($elementObject, $confirmBoxObject, null);
 	}
 
+	HideAll = () => {
+		const $elementObject	= this.$formObject.find('input.confirmbox_active');
+		const $confirmBoxObject	= this.$formObject.find('div[id$="_confirmbox"]');
+
+		this.#changeBoxState($elementObject, $confirmBoxObject, false);
+	}
+
 	#changeBoxState = ($elementObject, $confirmBoxObject, showBox) => {
 		$elementObject		.prop('disabled', !!showBox);
-			$elementObject		.toggleClass('lukewcs_confirmbox_active', !!showBox);
+		$elementObject		.toggleClass('confirmbox_active', !!showBox);
 		$confirmBoxObject	[showBox ? 'show' : 'hide'](this.animDuration);
-			this.$submitObject	.prop('disabled', showBox ?? this.$formObject.find('input.lukewcs_confirmbox_active').length);
+		this.$submitObject	.prop('disabled', showBox ?? this.$formObject.find('input.confirmbox_active').length);
 	}
 }
 
@@ -102,7 +104,6 @@
 	setSwitch('[name="extmgrplus_switch_order_and_ignore"]',			true);
 	setSwitch('[name="extmgrplus_switch_self_disable"]',				false);
 	setSwitch('[name="extmgrplus_switch_instructions"]',				true);
-		setSwitch('[name="extmgrplus_switch_settings_link"]',				true);
 	$(        '[name="extmgrplus_number_vc_limit"]').prop('value',		15);
 	setSwitch('[name="extmgrplus_switch_migration_col"]',				false);
 	setSwitch('[name="extmgrplus_switch_migrations"]',					false);
@@ -147,4 +148,5 @@
 
 	ConfirmBox = new LukeWCSphpBBConfirmBox('[name="extmgrplus_submit"]', 300);
 });
+
 })(jQuery);
diff --git "[ORIGINAL]/lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_versioncheck.html" "[FORUM_EXT]/lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_versioncheck.html"
--- "[ORIGINAL]/lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_versioncheck.html"
+++ "[FORUM_EXT]/lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_versioncheck.html"
@@ -14,6 +14,8 @@
 
 {% INCLUDE 'overall_header.html' %}
 
+<a id="maincontent"></a>
+
 <h1>{{ lang('EXTENSIONS_ADMIN') }}</h1>
 
 <p>{{ lang('EXTENSIONS_EXPLAIN') }}</p>
diff --git "[FORUM_EXT]/lukewcs\\extmgrplus/adm/style/event/acp_ext_details_end.html" "[FORUM_EXT]/lukewcs\\extmgrplus/adm/style/event/acp_ext_details_end.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/lukewcs\\extmgrplus/adm/style/event/acp_ext_details_end.html"
@@ -0,0 +1,26 @@
+{% import '@lukewcs_extmgrplus/acp_ext_mgr_plus_macros.html' as common %}
+
+
+{% if EXTMGRPLUS_DETAILS|length %}
+	<fieldset>
+		<legend>{{ lang('EXTMGRPLUS_SECTION_DETAILS') }}</legend>
+
+	{% if EXTMGRPLUS_DETAILS.cdb_page %}
+		<dl>
+			<dt><label>{{ lang('EXTMGRPLUS_DETAILS_CDB_PAGE') ~ lang('COLON') }}</label></dt>
+			<dd><strong><a href="{{ EXTMGRPLUS_DETAILS.cdb_page }}">{{ EXTMGRPLUS_DETAILS.cdb_page }}</a></strong></dd>
+		</dl>
+	{% endif %}
+
+	{% if EXTMGRPLUS_DETAILS.version_url %}
+		<dl>
+			<dt><label>{{ lang('EXTMGRPLUS_DETAILS_VERSION_URL') ~ lang('COLON') }}</label></dt>
+			<dd><strong><a href="{{ EXTMGRPLUS_DETAILS.version_url }}">{{ EXTMGRPLUS_DETAILS.version_url }}</a></strong></dd>
+		</dl>
+	{% endif %}
+	</fieldset>
+{% endif %}
+
+{{ common.footer(EXTMGRPLUS_METADATA) }}
+
+{% INCLUDECSS '@lukewcs_extmgrplus/acp_ext_mgr_plus.css' %}
diff --git "[ORIGINAL]/lukewcs\\extmgrplus/composer.json" "[FORUM_EXT]/lukewcs\\extmgrplus/composer.json"
--- "[ORIGINAL]/lukewcs\\extmgrplus/composer.json"
+++ "[FORUM_EXT]/lukewcs\\extmgrplus/composer.json"
@@ -3,8 +3,8 @@
     "type": "phpbb-extension",
     "description": "Adds the option to disable and re-enable all installed extensions at once to the extension management. Individual selections can be made using checkboxes. In addition, sequence groups and dependencies can be defined or extensions can be ignored. The version check is carried out in blocks and provides detailed information. Additional information is displayed in the extension management.",
     "homepage": "https://github.com/LukeWCS/ext-mgr-plus",
-    "version": "3.1.0",
-    "time": "2025-11-01",
+    "version": "3.0.0",
+    "time": "2024-11-28",
     "license": "GPL-2.0-only",
     "authors": [
         {
@@ -19,13 +19,13 @@
         }
     ],
     "require": {
-        "php": ">=8.0.0,<8.5.0@dev",
+        "php": ">=7.4.0,<8.5.0@dev",
         "composer/installers": "~1.0.0",
         "phpbb/phpbb": ">=3.3.8,<3.4.0@dev"
     },
     "extra": {
         "display-name": "Extension Manager Plus",
-        "lang-min-ver": "3.1.0",
+        "lang-min-ver": "3.0.0",
         "soft-require": {
             "phpbb/phpbb": ">=3.3.8,<3.4.0@dev"
         },
diff --git "[ORIGINAL]/lukewcs\\extmgrplus/config/services.yml" "[FORUM_EXT]/lukewcs\\extmgrplus/config/services.yml"
--- "[ORIGINAL]/lukewcs\\extmgrplus/config/services.yml"
+++ "[FORUM_EXT]/lukewcs\\extmgrplus/config/services.yml"
@@ -19,8 +19,9 @@ services:
             - '@language'
             - '@template'
             - '@dbal.conn'
-            - '@path_helper'
             - '%core.table_prefix%'
+            - '%core.root_path%'
+            - '%core.php_ext%'
     lukewcs.extmgrplus.core.common:
         class: lukewcs\extmgrplus\core\ext_mgr_plus_common
         arguments:
diff --git "[ORIGINAL]/lukewcs\\extmgrplus/controller/acp_ext_mgr_plus_controller.php" "[FORUM_EXT]/lukewcs\\extmgrplus/controller/acp_ext_mgr_plus_controller.php"
--- "[ORIGINAL]/lukewcs\\extmgrplus/controller/acp_ext_mgr_plus_controller.php"
+++ "[FORUM_EXT]/lukewcs\\extmgrplus/controller/acp_ext_mgr_plus_controller.php"
@@ -15,16 +15,27 @@ namespace lukewcs\extmgrplus\controller;
 
 class acp_ext_mgr_plus_controller
 {
+	protected object $common;
+	protected object $language;
+	protected object $template;
+	protected object $request;
+	protected object $config;
+
 	protected string $u_action;
 
 	public function __construct(
-		protected object $common,
-		protected \phpbb\language\language $language,
-		protected \phpbb\template\template $template,
-		protected \phpbb\request\request $request,
-		protected \phpbb\config\config $config,
+		$common,
+		\phpbb\language\language $language,
+		\phpbb\template\template $template,
+		\phpbb\request\request $request,
+		\phpbb\config\config $config
 	)
 	{
+		$this->common	= $common;
+		$this->language	= $language;
+		$this->template	= $template;
+		$this->request	= $request;
+		$this->config	= $config;
 	}
 
 	public function module_settings(): void
@@ -54,7 +65,6 @@ class acp_ext_mgr_plus_controller
 			$this->config->set('extmgrplus_switch_order_and_ignore'	, $this->request->variable('extmgrplus_switch_order_and_ignore'	, 0));
 			$this->config->set('extmgrplus_switch_self_disable'		, $this->request->variable('extmgrplus_switch_self_disable'		, 0));
 			$this->config->set('extmgrplus_switch_instructions'		, $this->request->variable('extmgrplus_switch_instructions'		, 0));
-			$this->config->set('extmgrplus_switch_settings_link'	, $this->request->variable('extmgrplus_switch_settings_link'	, 0));
 			$this->config->set('extmgrplus_number_vc_limit'			, $this->request->variable('extmgrplus_number_vc_limit'			, 0));
 			$this->config->set('extmgrplus_switch_migration_col'	, $this->request->variable('extmgrplus_switch_migration_col'	, 0));
 			$this->config->set('extmgrplus_switch_migrations'		, $this->request->variable('extmgrplus_switch_migrations'		, 0));
@@ -77,7 +87,6 @@ class acp_ext_mgr_plus_controller
 			'EXTMGRPLUS_SWITCH_ORDER_AND_IGNORE'		=> (bool) $this->config['extmgrplus_switch_order_and_ignore'],
 			'EXTMGRPLUS_SWITCH_SELF_DISABLE'			=> (bool) $this->config['extmgrplus_switch_self_disable'],
 			'EXTMGRPLUS_SWITCH_INSTRUCTIONS'			=> (bool) $this->config['extmgrplus_switch_instructions'],
-			'EXTMGRPLUS_SWITCH_SETTINGS_LINK'			=> (bool) $this->config['extmgrplus_switch_settings_link'],
 			'EXTMGRPLUS_NUMBER_VC_LIMIT'				=> (int) $this->config['extmgrplus_number_vc_limit'],
 			'EXTMGRPLUS_SWITCH_MIGRATION_COL'			=> (bool) $this->config['extmgrplus_switch_migration_col'],
 			'EXTMGRPLUS_SWITCH_MIGRATIONS'				=> (bool) $this->config['extmgrplus_switch_migrations'],
diff --git "[ORIGINAL]/lukewcs\\extmgrplus/core/ext_mgr_plus.php" "[FORUM_EXT]/lukewcs\\extmgrplus/core/ext_mgr_plus.php"
--- "[ORIGINAL]/lukewcs\\extmgrplus/core/ext_mgr_plus.php"
+++ "[FORUM_EXT]/lukewcs\\extmgrplus/core/ext_mgr_plus.php"
@@ -19,34 +19,55 @@ class ext_mgr_plus
 	protected const  CHECKBOX_ALL	= 1;
 	protected const  CHECKBOX_LAST	= 2;
 
-	protected const  CDB_EXT			= 1;
-	protected const  CDB_EXT_OFFICIAL	= 2;
+	protected object $common;
+	protected object $ext_manager;
+	protected object $cache;
+	protected object $request;
+	protected object $log;
+	protected object $user;
+	protected object $config;
+	protected object $config_text;
+	protected object $language;
+	protected object $template;
+	protected object $db;
+	protected string $table_prefix;
+	protected string $phpbb_root_path;
+	protected string $php_ext;
 
 	protected string $u_action;
 	protected int    $safe_time_limit;
-	protected string $phpbb_root_path;
-	protected string $phpbb_admin_path;
-	protected string $php_ext;
 
 	public function __construct(
-		protected object $common,
-		protected \phpbb\extension\manager $ext_manager,
-		protected \phpbb\cache\driver\driver_interface $cache,
-		protected \phpbb\request\request $request,
-		protected \phpbb\log\log $log,
-		protected \phpbb\user $user,
-		protected \phpbb\config\config $config,
-		protected \phpbb\config\db_text $config_text,
-		protected \phpbb\language\language $language,
-		protected \phpbb\template\template $template,
-		protected \phpbb\db\driver\driver_interface $db,
-		protected \phpbb\path_helper $path_helper,
-		protected string $table_prefix,
+		$common,
+		\phpbb\extension\manager $ext_manager,
+		\phpbb\cache\driver\driver_interface $cache,
+		\phpbb\request\request $request,
+		\phpbb\log\log $log,
+		\phpbb\user $user,
+		\phpbb\config\config $config,
+		\phpbb\config\db_text $config_text,
+		\phpbb\language\language $language,
+		\phpbb\template\template $template,
+		\phpbb\db\driver\driver_interface $db,
+		$table_prefix,
+		$phpbb_root_path,
+		$php_ext
 	)
 	{
-		$this->phpbb_root_path	= $this->path_helper->get_phpbb_root_path();
-		$this->phpbb_admin_path	= $this->phpbb_root_path . $this->path_helper->get_adm_relative_path();
-		$this->php_ext			= $this->path_helper->get_php_ext();
+		$this->common			= $common;
+		$this->ext_manager		= $ext_manager;
+		$this->cache			= $cache;
+		$this->request			= $request;
+		$this->log				= $log;
+		$this->user				= $user;
+		$this->config			= $config;
+		$this->config_text		= $config_text;
+		$this->language			= $language;
+		$this->template			= $template;
+		$this->db				= $db;
+		$this->table_prefix 	= $table_prefix;
+		$this->phpbb_root_path	= $phpbb_root_path;
+		$this->php_ext			= $php_ext;
 	}
 
 	/*
@@ -74,19 +95,17 @@ class ext_mgr_plus
 
 			$this->exts_switch_confirm();
 		}
-		else if ($this->request->is_set_post('extmgrplus_save_ext_properties'))
+		else if ($this->request->is_set_post('extmgrplus_save_ext_properties') && $this->config['extmgrplus_switch_order_and_ignore'])
 		{
 			$this->common->check_form_key_('lukewcs_extmgrplus');
 
-			if ($this->config['extmgrplus_switch_order_and_ignore'])
-			{
 			$order_list = $this->request->variable('ext_order', ['' => '']);
 			$ignore_list = $this->request->variable('ext_ignore', ['']);
+
 			$order_list = preg_grep('/^\+?[0-9]{1,2}$/', $order_list);
 
 			$this->common->config_text_set('extmgrplus_list_order_and_ignore', 'order', count($order_list) ? $order_list : null);
 			$this->common->config_text_set('extmgrplus_list_order_and_ignore', 'ignore', count($ignore_list) ? $ignore_list : null);
-			}
 
 			$this->common->trigger_error_($this->language->lang('EXTMGRPLUS_MSG_EXT_PROPERTIES_SAVED'), E_USER_NOTICE, 'RETURN_TO_EXTENSION_LIST');
 		}
@@ -111,8 +130,6 @@ class ext_mgr_plus
 	{
 		if ($event['action'] == 'details')
 		{
-			$event['tpl_name'] = '@lukewcs_extmgrplus/acp_ext_mgr_plus_acp_ext_details';
-
 			$this->extend_details($event['ext_name']);
 			$this->versioncheck_details($event['ext_name']);
 			return;
@@ -136,7 +153,6 @@ class ext_mgr_plus
 		if ($vc_request)
 		{
 			$event['tpl_name'] = '@lukewcs_extmgrplus/acp_ext_mgr_plus_versioncheck';
-
 			$this->template->assign_vars([
 				'EXTMGRPLUS_VC_DATA'		=> $ext_list_versioncheck['data'],
 				'U_EXTMGRPLUS_VC_CANCEL'	=> $this->u_action,
@@ -165,7 +181,6 @@ class ext_mgr_plus
 		$ext_list_migrations_inactive			= [];
 		$ext_list_order							= [];
 		$ext_list_ignore						= [];
-		$ext_list_modules						= [];
 		$ext_list_enabled_ignored				= [];
 		$ext_list_disabled_ignored				= [];
 		$ext_list_selected						= [];
@@ -184,11 +199,6 @@ class ext_mgr_plus
 			$ext_list_disabled_ignored	= array_intersect_key($ext_list_ignore, $ext_list_disabled);
 		}
 
-		if ($this->config['extmgrplus_switch_settings_link'])
-		{
-			$ext_list_modules = $this->get_module_links();
-		}
-
 		if ($this->config['extmgrplus_switch_migration_col'])
 		{
 			$ext_list_migrations_inactive = $this->get_exts_with_new_migration(array_diff_key($ext_list_available, $ext_list_enabled, $ext_list_ignore));
@@ -204,7 +214,6 @@ class ext_mgr_plus
 		{
 			$ext_list_enabled_ignored['lukewcs/extmgrplus'] = 0;
 		}
-
 		if (!$this->config['extmgrplus_switch_migrations'])
 		{
 			$ext_list_disabled_ignored = array_merge($ext_list_disabled_ignored, $ext_list_migrations_disabled);
@@ -246,7 +255,6 @@ class ext_mgr_plus
 			'EXTMGRPLUS_LIST_IGNORE'				=> $ext_list_ignore,
 			'EXTMGRPLUS_LIST_MIGRATIONS'			=> $ext_list_migrations_inactive,
 			'EXTMGRPLUS_LIST_SELECTED'				=> $ext_list_selected,
-			'EXTMGRPLUS_LIST_MODULES'				=> $ext_list_modules,
 			'EXTMGRPLUS_LIST_VERSIONCHECK'			=> $this->versioncheck_list($ext_list_available, $ext_list_versioncheck),
 
 			'EXTMGRPLUS_COUNT'						=> [
@@ -265,7 +273,6 @@ class ext_mgr_plus
 			'EXTMGRPLUS_SWITCH_ORDER_AND_IGNORE'	=> $this->config['extmgrplus_switch_order_and_ignore'],
 			'EXTMGRPLUS_SWITCH_SELF_DISABLE'		=> $this->config['extmgrplus_switch_self_disable'],
 			'EXTMGRPLUS_SWITCH_INSTRUCTIONS'		=> $this->config['extmgrplus_switch_instructions'],
-			'EXTMGRPLUS_SWITCH_SETTINGS_LINK'		=> $this->config['extmgrplus_switch_settings_link'],
 			'EXTMGRPLUS_SWITCH_MIGRATION_COL'		=> $this->config['extmgrplus_switch_migration_col'],
 			'EXTMGRPLUS_SWITCH_MIGRATIONS'			=> $this->config['extmgrplus_switch_migrations'],
 		]);
@@ -277,7 +284,7 @@ class ext_mgr_plus
 	*/
 	public function change_msg_template(): void
 	{
-		if ($this->template->retrieve_var('EXTMGRPLUS_TRIGGER_ERROR') !== null)
+		if ($this->template->retrieve_var('EXTMGRPLUS_TRIGGER_ERROR'))
 		{
 			$this->template->set_filenames(['body' => '@lukewcs_extmgrplus/acp_ext_mgr_plus_message_body.html']);
 		}
@@ -327,8 +334,7 @@ class ext_mgr_plus
 		{
 			$this->template->assign_vars([
 				'EXTMGRPLUS_ACTION_MODE'	=> 'DISABLE',
-				'EXTMGRPLUS_CONFIRM_YES'	=> 'EXTENSION_DISABLE',
-				'EXTMGRPLUS_CONFIRM_NO'		=> 'CANCEL',
+				'EXTMGRPLUS_SELF_DISABLE'	=> array_search('lukewcs/extmgrplus', $ext_mark_enabled) !== false,
 			]);
 			if (!$this->config['extmgrplus_switch_confirmation'] || confirm_box(true))
 			{
@@ -343,8 +349,6 @@ class ext_mgr_plus
 		{
 			$this->template->assign_vars([
 				'EXTMGRPLUS_ACTION_MODE'	=> 'ENABLE',
-				'EXTMGRPLUS_CONFIRM_YES'	=> 'EXTENSION_ENABLE',
-				'EXTMGRPLUS_CONFIRM_NO'		=> 'CANCEL',
 			]);
 			if (!$this->config['extmgrplus_switch_confirmation'] || confirm_box(true))
 			{
@@ -393,17 +397,17 @@ class ext_mgr_plus
 		{
 			try
 			{
-				$ext_meta = $this->ext_manager->create_extension_metadata_manager($ext_name)->get_metadata('all');
+				$ext_metadata = $this->ext_manager->create_extension_metadata_manager($ext_name)->get_metadata('all');
 			}
 			catch (\RuntimeException $e)
 			{
-				$ext_meta = null;
+				$ext_metadata = null;
 			}
 
-			if (is_array($ext_meta))
+			if (is_array($ext_metadata))
 			{
-				$ext_display_name	= $ext_meta['extra']['display-name'] ?? '';
-				$ext_version		= $ext_meta['version'] ?? '';
+				$ext_display_name	= $ext_metadata['extra']['display-name'] ?? '';
+				$ext_version		= $ext_metadata['version'] ?? '';
 
 				$disable_error = '';
 				if ($this->ext_manager->is_enabled($ext_name))
@@ -436,7 +440,7 @@ class ext_mgr_plus
 				}
 			}
 
-			if ($this->safe_time_limit > 0 && (microtime(true) - $GLOBALS['starttime']) >= $this->safe_time_limit)
+			if ((microtime(true) - $GLOBALS['starttime']) >= $this->safe_time_limit)
 			{
 				$safe_time_exceeded = true;
 				break;
@@ -458,7 +462,7 @@ class ext_mgr_plus
 		}
 		$this->common->trigger_error_(
 			$this->language->lang('EXTMGRPLUS_MSG_DEACTIVATION', $ext_count_success, $ext_count_enabled) . ($msg_failed ?? ''),
-			$this->get_error_level($ext_count_success, $ext_count_enabled, $safe_time_exceeded),
+			(($ext_count_success != $ext_count_enabled || $safe_time_exceeded) ? E_USER_WARNING : E_USER_NOTICE),
 			'RETURN_TO_EXTENSION_LIST'
 		);
 	}
@@ -498,17 +502,17 @@ class ext_mgr_plus
 		{
 			try
 			{
-				$ext_meta = $this->ext_manager->create_extension_metadata_manager($ext_name)->get_metadata('all');
+				$ext_metadata = $this->ext_manager->create_extension_metadata_manager($ext_name)->get_metadata('all');
 			}
 			catch (\RuntimeException $e)
 			{
-				$ext_meta = null;
+				$ext_metadata = null;
 			}
 
-			if (is_array($ext_meta))
+			if (is_array($ext_metadata))
 			{
-				$ext_display_name	= $ext_meta['extra']['display-name'] ?? '';
-				$ext_version		= $ext_meta['version'] ?? '';
+				$ext_display_name	= $ext_metadata['extra']['display-name'] ?? '';
+				$ext_version		= $ext_metadata['version'] ?? '';
 
 				if ($this->ext_manager->is_disabled($ext_name))
 				{
@@ -554,7 +558,7 @@ class ext_mgr_plus
 				}
 			}
 
-			if ($this->safe_time_limit > 0 && (microtime(true) - $GLOBALS['starttime']) >= $this->safe_time_limit)
+			if ((microtime(true) - $GLOBALS['starttime']) >= $this->safe_time_limit)
 			{
 				$safe_time_exceeded = true;
 				break;
@@ -576,7 +580,7 @@ class ext_mgr_plus
 		}
 		$this->common->trigger_error_(
 			$this->language->lang('EXTMGRPLUS_MSG_ACTIVATION', $ext_count_success, $ext_count_disabled) . ($msg_failed ?? ''),
-			$this->get_error_level($ext_count_success, $ext_count_disabled, $safe_time_exceeded),
+			(($ext_count_success != $ext_count_disabled || $safe_time_exceeded) ? E_USER_WARNING : E_USER_NOTICE),
 			'RETURN_TO_EXTENSION_LIST'
 		);
 	}
@@ -588,14 +592,14 @@ class ext_mgr_plus
 	{
 		$msg_failed = '<br><br>' . $this->language->lang($lang_var);
 		$count_failed = 0;
-		foreach ($ext_list as $ext_name => $vars)
+		foreach ($ext_list as $name => $vars)
 		{
 			if (is_array($vars['message']))
 			{
 				$vars['message'] = implode('<br>', $vars['message']);
 			}
 			$count_failed++;
-			$msg_failed .= $this->create_failed_msg($count_failed . '. ' . $vars['display_name'], $vars['ext_version'], $ext_name, $vars['message']);
+			$msg_failed .= $this->create_failed_msg($count_failed . '. ' . $vars['display_name'], $vars['ext_version'], $name, $vars['message']);
 		}
 
 		return $msg_failed;
@@ -606,24 +610,12 @@ class ext_mgr_plus
 	*/
 	private function create_failed_msg(string $display_name, string $ext_version, string $ext_name, string $message): string
 	{
-		return vsprintf('<br><br><strong>%1$s %2$s (%3$s)</strong>%4$s', [
-			1	=> $display_name,
-			2	=> $this->language->lang('EXTMGRPLUS_VERSION_STRING', $ext_version),
-			3	=> $ext_name,
-			4	=> empty($message) ? '' : "<br><br><em>{$message}</em>"
-		]);
-	}
-
-	/*
-		Helper function for trigger_error
-	*/
-	function get_error_level(int $count_success, int $count_total, bool $safe_time_exceeded): int
-	{
-		return match (true) {
-			$count_success == $count_total				=> E_USER_NOTICE,
-			$count_success == 0, $safe_time_exceeded	=> E_USER_WARNING,
-			default										=> E_USER_NOTICE + E_USER_ERROR,
-		};
+		return sprintf('<br><br><strong>%1$s %2$s (%3$s)</strong>%4$s',
+			/* 1 */	$display_name,
+			/* 2 */	$this->language->lang('EXTMGRPLUS_VERSION_STRING', $ext_version),
+			/* 3 */	$ext_name,
+			/* 4 */	empty($message) ? '' : "<br><br><em>{$message}</em>"
+		);
 	}
 
 	/*
@@ -673,48 +665,6 @@ class ext_mgr_plus
 		return count($migration_classes_new);
 	}
 
-	/*
-		Determine all ACP module links of the active extensions
-	*/
-	private function get_module_links(): array
-	{
-		global $module;
-
-		$module_urls = [];
-		$module_tabs = [];
-
-		$modules = array_combine(array_column($module->module_ary, 'id'), $module->module_ary);
-		$get_module_top_cat = function (int $module_id) use ($modules): string
-		{
-			$parent_id = $modules[$module_id]['parent'];
-			while ($parent_id !== 0)
-			{
-				$module_id = $parent_id;
-				$parent_id = $modules[$module_id]['parent'];
-			}
-
-			return $modules[$module_id]['langname'];
-		};
-
-		foreach (array_filter($modules, fn($row): bool => $row['name'] !== '' && $row['display']) as $module_row)
-		{
-			preg_match('/\\\\(.+?)\\\\(.+?)\\\\.*/', $module_row['name'], $matches);
-			$tech_name = (count($matches) === 3) ? $matches[1] . '/' . $matches[2] : false;
-			if ($tech_name !== false)
-			{
-				$module_tab = $get_module_top_cat($module_row['parent']);
-				if (!isset($module_urls[$tech_name]) || ($module_tab === 'ACP_CAT_DOT_MODS' && $module_tabs[$tech_name] !== $module_tab))
-				{
-					$module_name = str_replace('\\', '-', $module_row['name']);
-					$module_urls[$tech_name] = append_sid("{$this->phpbb_admin_path}index.{$this->php_ext}", "i={$module_name}&amp;mode={$module_row['mode']}");
-					$module_tabs[$tech_name] = $module_tab;
-				}
-			}
-		}
-
-		return $module_urls;
-	}
-
 	/*
 		Check if file is a valid migration file
 	*/
@@ -726,14 +676,17 @@ class ext_mgr_plus
 			$file_content = file_get_contents($file);
 			if ($file_content !== false)
 			{
-				return (
+				$check_migration = ((
 						preg_match('/function\s+?(?:depends_on|effectively_installed|update_schema|update_data|revert_data)\s*?\(/', $file_content)
 						&& preg_match('/^\s*?class\s+?' . $file_info['filename'] . '\s+/mi', $file_content)
-				) ? 1 : 0;
+					)
+					? 1
+					: 0
+				);
 			}
 		}
 
-		return -1;
+		return ($check_migration ?? -1);
 	}
 
 	/*
@@ -757,7 +710,7 @@ class ext_mgr_plus
 	/*
 		Preparation to be able to run a version check in blocks
 	*/
-	private function versioncheck_prepare(array|null &$ext_list_vc): void
+	private function versioncheck_prepare(?array &$ext_list_vc): void
 	{
 		$ext_list_all	= $this->ext_manager->all_available();
 		$ext_list_vc	= [
@@ -778,7 +731,6 @@ class ext_mgr_plus
 			}
 			catch (\RuntimeException $e)
 			{
-				$vc_meta = null;
 			}
 
 			if (isset($vc_meta))
@@ -789,7 +741,6 @@ class ext_mgr_plus
 				$this->cache->destroy(str_replace(['/', '\\'], '-', $cache_filename));
 			}
 		}
-
 		$ext_list_vc['data']['count_total']	= count($ext_list_vc) - 1;
 		$this->common->config_text_set('extmgrplus_list_version_check', 'updates', $ext_list_vc);
 	}
@@ -851,8 +802,8 @@ class ext_mgr_plus
 
 		try
 		{
-			$ext_meta = $md_manager->get_metadata('all');
-			if (isset($ext_meta['extra']['version-check']))
+			$ext_metadata = $md_manager->get_metadata('all');
+			if (isset($ext_metadata['extra']['version-check']))
 			{
 				$vc_data = $this->ext_manager->version_check($md_manager, !$read_cache, $read_cache, $this->config['extension_force_unstable'] ? 'unstable' : null);
 				$vc_current = empty($vc_data) ? 'NOUPD' : $vc_data['current'];
@@ -875,7 +826,7 @@ class ext_mgr_plus
 	/*
 		Reads the version check data from the database and removes obsolete entries and generates a list for the template
 	*/
-	private function versioncheck_list(array &$ext_list, array|null &$ext_list_vc): array
+	private function versioncheck_list(array &$ext_list, ?array &$ext_list_vc): array
 	{
 		$ext_list_vc ??= [];
 
@@ -892,17 +843,10 @@ class ext_mgr_plus
 			}
 			if ($this->ext_manager->is_available($ext_name))
 			{
-				try
-				{
-					$ext_meta = $this->ext_manager->create_extension_metadata_manager($ext_name)->get_metadata('all');
-				}
-				catch (\RuntimeException $e)
-				{
-					$ext_meta = null;
-				}
+				$ext_metadata = $this->ext_manager->create_extension_metadata_manager($ext_name)->get_metadata('all');
 
 				$no_ver_flags = $vc_data['current'] == 'NOUPD' || $vc_data['current'] == 'ERROR' || $vc_data['current'] == '';
-				$has_update = !$no_ver_flags && phpbb_version_compare($ext_meta['version'] ?? '0.0.0', $vc_data['current'], '<');
+				$has_update = !$no_ver_flags && phpbb_version_compare($ext_metadata['version'], $vc_data['current'], '<');
 				if ($no_ver_flags || $has_update)
 				{
 					$ext_list_tpl[$ext_name]['current'] = $vc_data['current'];
@@ -943,19 +887,15 @@ class ext_mgr_plus
 		{
 			try
 			{
-				$ext_meta = $this->ext_manager->create_extension_metadata_manager($ext_name)->get_metadata('all');
+				$ext_metadata = $this->ext_manager->create_extension_metadata_manager($ext_name)->get_metadata('all');
 			}
 			catch (\RuntimeException $e)
 			{
-				$ext_meta = null;
 			}
 
-			if (isset($ext_meta['extra']['version-check']))
-			{
-				if (($ext_meta['extra']['version-check']['host'] ?? '') == 'www.phpbb.com')
+			if (isset($ext_metadata['extra']['version-check']))
 			{
-					$ext_list_tpl[$ext_name]['cdb_ext']	= substr($ext_meta['name'], 0, 6) == 'phpbb/' ? self::CDB_EXT_OFFICIAL : self::CDB_EXT;
-				}
+				$ext_list_tpl[$ext_name]['cdb_ext']	= ($ext_metadata['extra']['version-check']['host'] ?? '') == 'www.phpbb.com';
 				$count_total++;
 			}
 			else
@@ -980,16 +920,13 @@ class ext_mgr_plus
 	*/
 	private function extend_details(string $ext_name): void
 	{
-		$ext_meta	= $this->ext_manager->create_extension_metadata_manager($ext_name)->get_metadata('all');
-		$vc_meta	= $ext_meta['extra']['version-check'] ?? null;
+		$vc_meta = $this->ext_manager->create_extension_metadata_manager($ext_name)->get_metadata('all')['extra']['version-check'] ?? null;
 		$details = [];
-
 		if (isset($vc_meta))
 		{
 			if (($vc_meta['host'] ?? '') == 'www.phpbb.com')
 			{
 				$details['cdb_page'] = 'https://www.phpbb.com' . $vc_meta['directory'] . '/';
-				$details['cdb_ext']		= substr($ext_meta['name'], 0, 6) == 'phpbb/' ? self::CDB_EXT_OFFICIAL : self::CDB_EXT;
 			}
 			if ($this->config['extmgrplus_switch_version_url'])
 			{
diff --git "[ORIGINAL]/lukewcs\\extmgrplus/core/ext_mgr_plus_common.php" "[FORUM_EXT]/lukewcs\\extmgrplus/core/ext_mgr_plus_common.php"
--- "[ORIGINAL]/lukewcs\\extmgrplus/core/ext_mgr_plus_common.php"
+++ "[FORUM_EXT]/lukewcs\\extmgrplus/core/ext_mgr_plus_common.php"
@@ -15,17 +15,29 @@ namespace lukewcs\extmgrplus\core;
 
 class ext_mgr_plus_common
 {
+	protected object $config;
+	protected object $config_text;
+	protected object $language;
+	protected object $template;
+	protected object $ext_manager;
+
 	protected array  $metadata;
 	public    string $u_action;
 
 	public function __construct(
-		protected \phpbb\config\config $config,
-		protected \phpbb\config\db_text $config_text,
-		protected \phpbb\language\language $language,
-		protected \phpbb\template\template $template,
-		protected \phpbb\extension\manager $ext_manager,
+		\phpbb\config\config $config,
+		\phpbb\config\db_text $config_text,
+		\phpbb\language\language $language,
+		\phpbb\template\template $template,
+		\phpbb\extension\manager $ext_manager
 	)
 	{
+		$this->config		= $config;
+		$this->config_text	= $config_text;
+		$this->language		= $language;
+		$this->template		= $template;
+		$this->ext_manager	= $ext_manager;
+
 		$this->metadata		= $this->ext_manager->create_extension_metadata_manager('lukewcs/extmgrplus')->get_metadata('all');
 	}
 
@@ -70,7 +82,7 @@ class ext_mgr_plus_common
 			{
 				$lang_outdated_msg = $this->language->lang($lang_outdated_var);
 			}
-			else /* Fallback if the current language package does not yet have the required variable. */
+			else // Fallback if the current language package does not yet have the required variable.
 			{
 				$lang_outdated_msg = 'Note: The language pack for the extension <strong>%1$s</strong> is no longer up-to-date. (installed: %2$s / needed: %3$s)';
 			}
@@ -83,7 +95,7 @@ class ext_mgr_plus_common
 	/*
 		Set a variable/array in a config_text variable container or delete one or all variables/arrays
 	*/
-	public function config_text_set(string $container, string|null $name, $value): void
+	public function config_text_set(string $container, ?string $name, $value): void
 	{
 		if ($this->config_text->get($container) === null)
 		{
@@ -113,7 +125,7 @@ class ext_mgr_plus_common
 	/*
 		Get a variable/array from a config_text variable container
 	*/
-	public function config_text_get(string $container, string|null $name = null)
+	public function config_text_get(string $container, ?string $name = null)
 	{
 		$config_text = $this->config_text->get($container);
 		if ($config_text === null)
@@ -146,30 +158,23 @@ class ext_mgr_plus_common
 	/*
 		Wrapper for trigger_error
 	*/
-	public function trigger_error_(string $message, int $error_level, string|null $back_link_lang_var = null): void
+	public function trigger_error_(string $message, int $error_type, ?string $back_link_lang_var = null): void
 	{
-		if ($error_level == E_USER_NOTICE && $this->config['extmgrplus_switch_auto_redirect'])
+		if ($error_type == E_USER_NOTICE && $this->config['extmgrplus_switch_auto_redirect'])
 		{
 			meta_refresh(1, $this->rotate_get_params($this->u_action));
 			$this->template->assign_var('EXTMGRPLUS_AUTO_REDIRECT', true);
 		}
-
-		$error_type = [
-			E_USER_NOTICE					=> 0, // green box
-			E_USER_WARNING					=> 1, // red box
-			E_USER_NOTICE + E_USER_WARNING	=> 2, // orange box
-			E_USER_NOTICE + E_USER_ERROR	=> 3, // green+red box
-		][$error_level]						?? 2;
-		$this->template->assign_var('EXTMGRPLUS_TRIGGER_ERROR', $error_type);
-		trigger_error($message . $this->back_link($back_link_lang_var), ($error_type > 1) ? E_USER_WARNING : $error_level);
+		$this->template->assign_var('EXTMGRPLUS_TRIGGER_ERROR', true);
+		trigger_error($message . $this->back_link($back_link_lang_var), $error_type);
 	}
 
-	public function back_link(string|null $lang_var = null): string
+	public function back_link(?string $lang_var = null): string
 	{
-		return vsprintf('<br><br><a href="%1$s">%2$s</a>', [
-			1	=> $this->u_action,
-			2	=> $this->language->lang($lang_var ?? 'BACK_TO_PREV')
-		]);
+		return sprintf('<br><br><a href="%1$s">%2$s</a>',
+			/* 1 */ $this->u_action,
+			/* 2 */ $this->language->lang($lang_var ?? 'BACK_TO_PREV')
+		);
 	}
 
 	/*
diff --git "[FORUM_EXT]/lukewcs\\extmgrplus/diff_full.tmp" "[FORUM_EXT]/lukewcs\\extmgrplus/diff_full.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/lukewcs\\extmgrplus/diff_full.tmp"
@@ -0,0 +1,4792 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/acp/settings_module.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/acp/settings_module.php"
+index b9c7958c3..f0be963f2 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/acp/settings_module.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/acp/settings_module.php"
+@@ -15,9 +15,9 @@ namespace lukewcs\extmgrplus\acp;
+ 
+ class settings_module
+ {
+-	public string $page_title;
+-	public string $tpl_name;
+-	public string $u_action;
++	public $page_title;
++	public $tpl_name;
++	public $u_action;
+ 
+ 	public function main()
+ 	{
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus.css" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus.css"
+index d5f7a1824..c632316bb 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus.css"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus.css"
+@@ -1,7 +1,33 @@
+-/* GENERAL >>> */
++/* GENERAL */
+ 
+-button[type="submit"]:is([name="confirm"], [name="cancel"]),
+-input:is([type="submit"], [type="button"], [type="reset"])[name^="extmgrplus_"] {
++fieldset {
++	border-radius: 5px;
++}
++
++fieldset p.submit-buttons {
++	margin-top: 0;
++	padding: 0 4px 4px 4px;
++}
++
++fieldset dt label,
++fieldset dd label {
++	cursor: inherit;
++}
++
++legend {
++	background: inherit;
++	margin: 2px 0 0 -11px;
++	border-top: inherit;
++	border-left: inherit;
++	border-radius: 5px 5px 0 0;
++	padding: 2px 10px;
++	top: 0;
++}
++
++input[type="submit"][name="confirm"],
++input[type="submit"][name^="extmgrplus_"],
++input[type="button"][name^="extmgrplus_"],
++input[type="reset"][name^="extmgrplus_"] {
+ 	padding: 3px 4px;
+ }
+ 
+@@ -11,31 +37,11 @@ code {
+ 	color: black;
+ }
+ 
+-.emp_inactive {
++.inactive {
+ 	opacity: 0.5;
+ }
+ 
+-.emp_unavailable {
+-	opacity: 0.3;
+-}
+-
+-.errorbox {
+-	&.emp_warning {
+-		background-color: #ffaa00;
+-
+-		& :is(a, a:visited) {
+-			color: #505050;
+-		}
+-
+-		& :is(h3, p, a:hover) {
+-			color: #303030;
+-		}
+-	}
+-
+-	&.emp_success_error {
+-		background: linear-gradient(#228822, #bc2a4d);
+-	}
+-}
++/* Footer */
+ 
+ .extmgrplus_footer {
+ 	margin-top: 1em;
+@@ -43,192 +49,137 @@ code {
+ 	font-size: 0.75em;
+ }
+ 
+-#confirm {
+-	/* confirm_box (phpBB) */
+-
+-	& h2 {
+-		margin-bottom: 0.25em;
+-	}
+-
+-	& :is(.button1, .button2) {
+-		color: #000000;
+-		background: linear-gradient(to bottom, #d2d2d2 0%, #efefef 100%);
+-		border: 1px solid #666666;
+-		font-size: 0.85em;
+-		font-family: "Lucida Grande", Verdana, Helvetica, Arial, sans-serif;
+-		vertical-align: middle;
+-
+-		&:hover {
+-			border: 1px solid #bc2a4d;
+-			background: #efefef url("../../../../../adm/images/bg_button.gif") repeat bottom;
+-			color: #bc2a4d;
+-		}
+-	}
++/* confirm_box (phpBB)*/
+ 
+-	& .button1 {
+-		font-weight: bold;
+-	}
++#confirm h2 {
++	margin-bottom: 0.25em;
+ }
+ 
+-/* <<< GENERAL */
+-
+-/* SETTINGS >>> */
+-
+-fieldset {
+-	border-radius: 5px;
+-
+-	& p.submit-buttons {
+-		margin-top: 0;
+-		padding: 0 4px 4px 4px;
+-	}
+-
+-	& :is(dt, dd) label {
+-		cursor: inherit;
+-	}
++/* SETTINGS */
+ 
+-	& dd a {
+-		overflow-wrap: anywhere;
+-	}
++legend.legend_sub {
++	border: 0;
++	margin: 1em 0;
++	padding: 0;
++	display: flex;
++	white-space: nowrap;
+ }
+ 
+-legend {
+-	background: inherit;
+-	margin: 2px 0 0 -11px;
+-	border-top: inherit;
+-	border-left: inherit;
+-	border-radius: 5px 5px 0 0;
+-	padding: 2px 10px;
+-	top: 0;
+-
+-	& + .legend_explain {
+-		width: 45%;
+-	}
+-
+-	&.legend_sub {
+-		border: 0;
+-		margin: 1em 0;
+-		padding: 0;
+-		display: flex;
+-		white-space: nowrap;
+-
+-		&:after {
+-			content: "";
+-			border-bottom: 1px solid #cccccc;
+-			width: 100%;
+-			margin: 0 0 0.5em 1em;
+-		}
+-	}
++legend.legend_sub:after {
++	content: "";
++	border-bottom: 1px solid #cccccc;
++	width: 100%;
++	margin: 0 0 0.5em 1em;
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
+-div.lukewcs_confirmbox {
+-	/* LukeWCSphpBBConfirmBox */
++.toggle:checked:before {
++	left: 2px;
++	content: "\f00c";
++}
++
++/* LukeWCSphpBBConfirmBox */
+ 
++div[id$="_confirmbox"] {
+ 	max-width: 450px;
+ 	border: 2px solid skyblue;
+ 	margin: 0.75em 0.5em;
+ 	padding: 0.25em 0.5em;
+ 	border-radius: 5px;
++	-webkit-box-shadow: 2px 2px 10px 1px rgba(121, 162, 179, 0.5);
+ 	box-shadow: 2px 2px 10px 1px rgba(121, 162, 179, 0.5);
++}
+ 
+-	& h2 {
+-		margin: 0 0 0.25em 0;
+-	}
++div[id$="_confirmbox"] h2 {
++	margin: 0 0 0.25em 0;
++}
+ 
+-	& p:last-of-type {
+-		text-align: center;
+-		margin: 0;
+-		padding: 0 4px 4px 4px;
+-	}
++div[id$="_confirmbox"] p:nth-of-type(2) {
++	text-align: center;
++	margin: 0;
++	padding: 0 4px 4px 4px;
++}
+ 
+-	& input[type="button"] {
+-		padding: 3px 4px;
+-	}
++div[id$="_confirmbox"] input[type="button"] {
++	padding: 3px 4px;
+ }
+ 
+-input:is([type="submit"], [type="button"]):disabled,
+-input.lukewcs_confirmbox_active {
++input[type="submit"]:disabled,
++input[type="button"]:disabled,
++input.confirmbox_active {
+ 	opacity: 0.5;
+ 	cursor: not-allowed;
+ }
+ 
+-/* <<< SETTINGS */
+-
+-/* EXTENSION MANAGER >>> */
++/* EXTENSION MANAGER */
+ 
+ .js_link {
+ 	color: #105289;
++}
+ 
+-	&:hover {
+-		color: #bc2a4d;
+-		text-decoration: underline;
+-		cursor: pointer;
+-	}
++.js_link:hover {
++	color: #bc2a4d;
++	text-decoration: underline;
++	cursor: pointer;
++}
+ 
+-	&.disabled,
+-	&.disabled:hover {
+-		color: #536482;
+-		text-decoration: none;
+-		cursor: not-allowed;
+-		opacity: 0.5;
+-	}
++.js_link.disabled,
++.js_link.disabled:hover {
++	color: #536482;
++	text-decoration: none;
++	cursor: not-allowed;
++	opacity: 0.5;
+ }
+ 
+-table :is(th, td) i.icon,
+-fieldset dd i.icon {
+-	cursor: help;
++fieldset.quick a i.icon,
++.js_link i.icon {
++	margin: 0 0.3em 0 0;
++	font-size: 1.1em;
+ }
+ 
+ div.successbox i.icon,
+@@ -241,12 +192,6 @@ div.successbox.notice i.icon {
+ 	font-size: 1.2em;
+ }
+ 
+-fieldset.quick a i.icon,
+-.js_link i.icon {
+-	margin: 0 0.3em 0 0;
+-	font-size: 1.1em;
+-}
+-
+ fieldset.ext_properties i.icon,
+ thead th i.icon {
+ 	font-size: 1.1em;
+@@ -255,109 +200,107 @@ thead th i.icon {
+ 
+ fieldset.ext_properties dd {
+ 	color: inherit;
++}
+ 
+-	& label {
+-		font-size: inherit;
+-		font-weight: bold;
++fieldset.ext_properties dd label {
++	font-size: inherit;
++	font-weight: bold;
++}
+ 
+-		&:hover {
+-			color: inherit;
+-		}
+-	}
++fieldset.ext_properties dd label:hover {
++	color: inherit;
++}
+ 
+-	& details {
+-		border: 1px solid #cccccc;
+-		border-radius: 3px;
+-
+-		& summary {
+-			padding: 0.25em 0.5em;
+-			cursor: pointer;
+-			-webkit-user-select: none;
+-			user-select: none;
+-		}
+-
+-		& div {
+-			border-top: 1px solid #cccccc;
+-			font-size: inherit;
+-			padding: 0.25em 0;
+-			margin: 0 0.5em;
+-		}
+-	}
++fieldset.ext_properties dd details {
++	border: 1px solid #cccccc;
++	border-radius: 3px;
+ }
+ 
+-#extmgrplus_list {
+-	& input[type="checkbox"]:disabled {
+-		cursor: not-allowed;
+-	}
++fieldset.ext_properties dd summary {
++	padding: 0.25em 0.5em;
++	cursor: pointer;
++	-webkit-user-select: none;
++	-moz-user-select: none;
++	-ms-user-select: none;
++}
+ 
+-	& input[name$="able_all"] {
+-		padding: 1px 3px;
+-		font-size: inherit;
+-	}
++fieldset.ext_properties dd details div {
++	border-top: 1px solid #cccccc;
++	font-size: inherit;
++	padding: 0.25em 0;
++	margin: 0 0.5em;
++}
+ 
+-	& input[type="text"] {
+-		text-align: right;
+-		padding: 0 2px;
+-		margin: 0 2px;
+-		background-color: #f9f9f9;
+-	}
++input[type="checkbox"]:disabled {
++	cursor: not-allowed;
++}
+ 
+-	& th:nth-of-type(1) {
+-		width: 1%;
+-	}
++#extmgrplus_list input[name$="able_all"] {
++	padding: 1px 5px;
++}
+ 
+-	& th:nth-of-type(3) {
+-		width: 16%;
+-	}
++#extmgrplus_list input[type="text"] {
++	text-align: right;
++	padding: 0 2px;
++	margin: 0 2px;
++	background-color: #f9f9f9;
++}
+ 
+-	& th:nth-of-type(1n+3) {
+-		text-align: center;
+-	}
++#extmgrplus_list th:nth-of-type(1) {
++	width: 1%;
++}
+ 
+-	& th:nth-of-type(4) {
+-		width: 1%;
+-	}
++#extmgrplus_list th:nth-of-type(3) {
++	width: 16%;
++}
+ 
+-	& th:nth-of-type(5) {
+-		width: 10%;
+-	}
++#extmgrplus_list th:nth-of-type(1n+3) {
++	text-align: center;
++}
+ 
+-	& th:nth-of-type(6) {
+-		width: 25%;
+-	}
++#extmgrplus_list th:nth-of-type(4) {
++	width: 1%;
++}
+ 
+-	& th:nth-of-type(1n+7) {
+-		width: 1%;
+-	}
++#extmgrplus_list th:nth-of-type(5) {
++	width: 10%;
++}
+ 
+-	& td:nth-of-type(3) i.icon {
+-		font-size: 1.2em;
+-	}
++#extmgrplus_list th:nth-of-type(6) {
++	width: 25%;
++}
+ 
+-	& td:nth-of-type(3) :is(span, strong, i.icon) + :is(strong, i.icon) {
+-		margin-left: 0.3em;
+-	}
++#extmgrplus_list th:nth-of-type(1n+7) {
++	width: 1%;
++}
+ 
+-	& td:nth-of-type(3) i.icon:is(.fa-question-circle, .fa-exclamation-triangle) {
+-		color: #df950d;
+-	}
++#extmgrplus_list td:nth-of-type(1) i.icon {
++	cursor: help;
++}
+ 
+-	& td:nth-of-type(1n+3) {
+-		text-align: center;
+-	}
++#extmgrplus_list td:nth-of-type(3) i.icon {
++	cursor: help;
++	font-size: 1.2em;
++}
+ 
+-	& td:nth-of-type(4) span {
+-		cursor: help;
+-	}
++#extmgrplus_list td:nth-of-type(3) i.icon:is(.fa-question-circle, .fa-exclamation-triangle, .fa-refresh) {
++	color: #df950d;
++}
+ 
+-	& td:nth-of-type(7) i.icon {
+-		font-size: 1.3em;
+-	}
++#extmgrplus_list td:nth-of-type(1n+3) {
++	text-align: center;
++}
++
++#extmgrplus_list td:nth-of-type(4) span {
++	cursor: help;
+ }
+ 
+-/* <<< EXTENSION MANAGER */
++#extmgrplus_list td:nth-of-type(7) i.icon {
++	cursor: help;
++	font-size: 1.3em;
++}
+ 
+-/* VERSIONCHECK PROGGRESS >>> */
++/* VERSIONCHECK PROGGRESS */
+ 
+ .progress_container {
+ 	background-color: #f9f9f9;
+@@ -365,28 +308,28 @@ fieldset.ext_properties dd {
+ 	border-radius: 5px;
+ 	position: relative;
+ 	margin: 1em 0 0.25em 0;
++}
+ 
+-	& .progress_bar {
+-		background-color: lightgreen;
+-		height: 100%;
+-		border-radius: 5px;
+-	}
++.progress_bar {
++	background-color: lightgreen;
++	height: 100%;
++	border-radius: 5px;
++}
+ 
+-	& .progress_value {
+-		color: black;
+-		position: absolute;
+-		font-size: 0.85em;
+-		top: 1px;
+-		left: 0;
+-		right: 0;
+-	}
++.progress_value {
++	color: black;
++	position: absolute;
++	font-size: 0.85em;
++	top: 1px;
++	left: 0;
++	right: 0;
++}
+ 
+-	& .progress_anim {
+-		background-color: lightblue;
+-		animation-name: progress_anim_block;
+-		animation-timing-function: linear;
+-		animation-fill-mode: forwards;
+-	}
++.progress_anim {
++	background-color: lightblue;
++	animation-name: progress_anim_block;
++	animation-timing-function: linear;
++	animation-fill-mode: forwards;
+ }
+ 
+ @keyframes progress_anim_block {
+@@ -399,18 +342,12 @@ fieldset.ext_properties dd {
+ 	}
+ }
+ 
+-/* <<< VERSIONCHECK PROGGRESS */
+-
+-/* RESPONSIVE >>> */
++/* RESPONSIVE */
+ 
+ @media (max-width: 700px){
+ 	legend {
+ 		margin: 2px 0 0 -6px;
+ 		padding: 2px 5px;
+-
+-		& + .legend_explain {
+-			width: auto;
+-		}
+ 	}
+ 
+ 	#extmgrplus_settings dd {
+@@ -421,5 +358,3 @@ fieldset.ext_properties dd {
+ 		padding: 0.5em 0 0 0;
+ 	}
+ }
+-
+-/* <<< RESPONSIVE */
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_acp_ext_details.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_acp_ext_details.html"
+deleted file mode 100644
+index 830d87306..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_acp_ext_details.html"
++++ /dev/null
+@@ -1,180 +0,0 @@
+-{#
+-*
+-* Extension Manager Plus. An extension for the phpBB Forum Software package.
+-*
+-* @copyright (c) 2022, LukeWCS, https://www.wcsaga.org
+-* @license GNU General Public License, version 2 (GPL-2.0-only)
+-*
+-* Note: This extension is 100% genuine handcraft and consists of selected
+-*       natural raw materials. There was no AI involved in making it.
+-*
+-#}
+-
+-{% import '@lukewcs_extmgrplus/acp_ext_mgr_plus_macros.html' as common %}
+-
+-{% INCLUDE 'overall_header.html' %}
+-
+-<a href="{{ U_BACK }}" style="float: {{ S_CONTENT_FLOW_END }};">&laquo; {{ lang('BACK') }}</a>
+-
+-<h1>{{ lang('EXTENSIONS_ADMIN') }}</h1>
+-
+-<p>{{ lang('EXTENSIONS_EXPLAIN') }}</p>
+-
+-{% if S_VERSIONCHECK %}
+-	{% if S_VERSIONCHECK_FAIL %}
+-		<div class="errorbox notice">
+-			<p>{{ lang('VERSIONCHECK_FAIL') }}</p>
+-			<p>{{ VERSIONCHECK_FAIL_REASON }}</p>
+-			<p><a href="{{ U_VERSIONCHECK_FORCE }}">{{ lang('VERSIONCHECK_FORCE_UPDATE') }}</a></p>
+-		</div>
+-	{% else %}
+-		<div class="{% if S_UP_TO_DATE %}successbox{% else %}errorbox{% endif %}">
+-			<p>{{ UP_TO_DATE_MSG }} - <a href="{{ U_VERSIONCHECK_FORCE }}">{{ lang('VERSIONCHECK_FORCE_UPDATE') }}</a></p>
+-		</div>
+-	{% endif %}
+-{% endif %}
+-
+-{% EVENT acp_ext_details_notice %}
+-
+-<fieldset>
+-	<legend>{{ lang('EXT_DETAILS') }}</legend>
+-
+-	{% if META_DISPLAY_NAME %}
+-		<dl>
+-			<dt><label>{{ lang('DISPLAY_NAME') ~ lang('COLON') }}</label></dt>
+-			<dd>
+-				{{ EXTMGRPLUS_DETAILS.cdb_ext ? {
+-					1:	common.icon('fa-database', 'EXTMGRPLUS_TOOLTIP_CDB_EXT'),
+-					2:	common.icon('fa-star', 'EXTMGRPLUS_TOOLTIP_CDB_EXT_OFFICIAL'),
+-				}[EXTMGRPLUS_DETAILS.cdb_ext] }}
+-				<strong id="meta_display_name">{{ META_DISPLAY_NAME }}</strong>
+-			</dd>
+-		</dl>
+-	{% endif %}
+-	<dl>
+-		<dt><label>{{ lang('CLEAN_NAME') ~ lang('COLON') }}</label></dt>
+-		<dd><strong id="meta_name">{{ META_NAME }}</strong></dd>
+-	</dl>
+-	{% if META_DESCRIPTION %}
+-		<dl>
+-			<dt><label>{{ lang('DESCRIPTION') ~ lang('COLON') }}</label></dt>
+-			<dd><span id="meta_description">{{ META_DESCRIPTION }}</span></dd>
+-		</dl>
+-	{% endif %}
+-	<dl>
+-		<dt><label>{{ lang('VERSION') ~ lang('COLON') }}</label></dt>
+-		<dd><span id="meta_version">{{ META_VERSION }}</span></dd>
+-	</dl>
+-	{% if META_HOMEPAGE && META_HOMEPAGE != EXTMGRPLUS_DETAILS.cdb_page %}
+-		<dl>
+-			<dt><label>{{ lang('HOMEPAGE') ~ lang('COLON') }}</label></dt>
+-			<dd><strong id="meta_homepage"><a href="{{ META_HOMEPAGE }}">{{ META_HOMEPAGE }}</a></strong></dd>
+-		</dl>
+-	{% endif %}
+-	{% if EXTMGRPLUS_DETAILS.cdb_page %}
+-		<dl>
+-			<dt><label>{{ lang('EXTMGRPLUS_DETAILS_CDB_PAGE') ~ lang('COLON') }}</label></dt>
+-			<dd><strong><a href="{{ EXTMGRPLUS_DETAILS.cdb_page }}">{{ EXTMGRPLUS_DETAILS.cdb_page }}</a></strong></dd>
+-		</dl>
+-	{% endif %}
+-	{% if EXTMGRPLUS_DETAILS.version_url %}
+-		<dl>
+-			<dt><label>{{ lang('EXTMGRPLUS_DETAILS_VERSION_URL') ~ lang('COLON') }}</label></dt>
+-			<dd><strong><a href="{{ EXTMGRPLUS_DETAILS.version_url }}">{{ EXTMGRPLUS_DETAILS.version_url }}</a></strong></dd>
+-		</dl>
+-	{% endif %}
+-	{% if META_TIME %}
+-		<dl>
+-			<dt><label>{{ lang('TIME') ~ lang('COLON') }}</label></dt>
+-			<dd><span id="meta_time">{{ META_TIME }}</span></dd>
+-		</dl>
+-	{% endif %}
+-	<dl>
+-		<dt><label>{{ lang('LICENSE') ~ lang('COLON') }}</label></dt>
+-		<dd><span id="meta_license">{{ META_LICENSE }}</span></dd>
+-	</dl>
+-</fieldset>
+-
+-{% if S_VERSIONCHECK && !S_UP_TO_DATE %}
+-	<fieldset>
+-		<legend>{{ lang('LATEST_VERSION') }}</legend>
+-
+-		{% for updates_available in loops.updates_available %}
+-			<fieldset>
+-				<dl>
+-					<dt><label>{{ lang('VERSION') ~ lang('COLON') }}</label></dt>
+-					<dd><strong>{{ updates_available.current }}</strong></dd>
+-				</dl>
+-				{% if updates_available.download %}
+-					<dl>
+-						<dt><label>{{ lang('DOWNLOAD_LATEST') }}</label></dt>
+-						<dd><strong><a href="{{ updates_available.download }}">{{ lang('DOWNLOAD') }} {{ META_NAME }} {{ LATEST_VERSION }}</a></strong></dd>
+-					</dl>
+-				{% endif %}
+-				{% if updates_available.announcement %}
+-					<dl>
+-						<dt><label>{{ lang('ANNOUNCEMENT_TOPIC') }}</label></dt>
+-						<dd><strong><a href="{{ updates_available.announcement }}">{{ lang('RELEASE_ANNOUNCEMENT') }}</a></strong></dd>
+-					</dl>
+-				{% endif %}
+-			</fieldset>
+-		{% endfor %}
+-	</fieldset>
+-{% endif %}
+-
+-{% if META_REQUIRE_PHPBB || META_REQUIRE_PHP %}
+-	<fieldset>
+-		<legend>{{ lang('REQUIREMENTS') }}</legend>
+-
+-		{% if META_REQUIRE_PHPBB %}
+-			<dl{% if META_REQUIRE_PHPBB_FAIL %} class="requirements_not_met"{% endif %}>
+-				<dt><label>{{ lang('PHPBB_VERSION') ~ lang('COLON') }}</label></dt>
+-				<dd><span id="require_phpbb">{{ META_REQUIRE_PHPBB }}</span></dd>
+-			</dl>
+-		{% endif %}
+-		{% if META_REQUIRE_PHP %}
+-			<dl{% if META_REQUIRE_PHP_FAIL %} class="requirements_not_met"{% endif %}>
+-				<dt><label>{{ lang('PHP_VERSION') ~ lang('COLON') }}</label></dt>
+-				<dd><span id="require_php">{{ META_REQUIRE_PHP }}</span></dd>
+-			</dl>
+-		{% endif %}
+-	</fieldset>
+-{% endif %}
+-
+-<fieldset>
+-	<legend>{{ lang('AUTHOR_INFORMATION') }}</legend>
+-
+-	{% for meta_authors in loops.meta_authors %}
+-		<fieldset>
+-			<dl>
+-				<dt><label>{{ lang('AUTHOR_NAME') ~ lang('COLON') }}</label></dt>
+-				<dd><strong>{{ meta_authors.AUTHOR_NAME }}</strong></dd>
+-			</dl>
+-			{% if meta_authors.AUTHOR_EMAIL %}
+-				<dl>
+-					<dt><label>{{ lang('AUTHOR_EMAIL') ~ lang('COLON') }}</label></dt>
+-					<dd><strong><a href="mailto:{{ meta_authors.AUTHOR_EMAIL }}">{{ meta_authors.AUTHOR_EMAIL }}</a></strong></dd>
+-				</dl>
+-			{% endif %}
+-			{% if meta_authors.AUTHOR_HOMEPAGE %}
+-				<dl>
+-					<dt><label>{{ lang('AUTHOR_HOMEPAGE') ~ lang('COLON') }}</label></dt>
+-					<dd><strong><a href="{{ meta_authors.AUTHOR_HOMEPAGE }}">{{ meta_authors.AUTHOR_HOMEPAGE }}</a></strong></dd>
+-				</dl>
+-			{% endif %}
+-			{% if meta_authors.AUTHOR_ROLE %}
+-				<dl>
+-					<dt><label>{{ lang('AUTHOR_ROLE') ~ lang('COLON') }}</label></dt>
+-					<dd><strong>{{ meta_authors.AUTHOR_ROLE }}</strong></dd>
+-				</dl>
+-			{% endif %}
+-		</fieldset>
+-	{% endfor %}
+-</fieldset>
+-
+-{% EVENT acp_ext_details_end %}
+-
+-{{ common.footer(EXTMGRPLUS_METADATA) }}
+-
+-{% INCLUDE 'overall_footer.html' %}
+-{% INCLUDECSS '@lukewcs_extmgrplus/acp_ext_mgr_plus.css' %}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_acp_ext_list.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_acp_ext_list.html"
+index ff8f88ca8..14224a0d1 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_acp_ext_list.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_acp_ext_list.html"
+@@ -25,6 +25,8 @@
+ 	CHECKBOX_LAST	: 2,
+ } %}
+ 
++<a id="maincontent"></a>
++
+ <h1>{{ lang('EXTENSIONS_ADMIN') }}</h1>
+ 
+ <p>{{ lang('EXTENSIONS_EXPLAIN') }}</p>
+@@ -88,7 +90,7 @@
+ 		<fieldset class="ext_properties" style="display: none;">
+ 			<legend>{{ lang('EXTMGRPLUS_SECTION_SETTINGS') }}</legend>
+ 
+-			<dl{{ !EXTMGRPLUS_SWITCH_ORDER_AND_IGNORE ? ' class="emp_inactive"' }}>
++			<dl{{ !EXTMGRPLUS_SWITCH_ORDER_AND_IGNORE ? ' class="inactive"' }}>
+ 				<dt>
+ 					<label>{{ lang('EXTMGRPLUS_ORDER', common.icon('fa-sort')) ~ lang('COLON') }}</label><br>
+ 				</dt>
+@@ -104,7 +106,7 @@
+ 				</dd>
+ 			</dl>
+ 
+-			<dl{{ !EXTMGRPLUS_SWITCH_ORDER_AND_IGNORE ? ' class="emp_inactive"' }}>
++			<dl{{ !EXTMGRPLUS_SWITCH_ORDER_AND_IGNORE ? ' class="inactive"' }}>
+ 				<dt>
+ 					<label>{{ lang('EXTMGRPLUS_IGNORE', common.icon('fa-ban')) ~ lang('COLON') }}</label><br>
+ 				</dt>
+@@ -136,8 +138,8 @@
+ 		</colgroup>
+ 		<thead>
+ 			<tr>
+-				<th>
+-					{{ common.icon('fa-database', 'EXTMGRPLUS_COL_CDB') }}<span style="display: none;">{{ lang('EXTMGRPLUS_COL_CDB') }}</span>
++				<th title="{{ lang('EXTMGRPLUS_COL_CDB') }}">
++					{{ common.icon('fa-database') }}<span style="display: none;">{{ lang('EXTMGRPLUS_COL_CDB') }}</span>
+ 				</th>
+ 				<th>
+ 					{{ lang('EXTENSION_NAME') }}
+@@ -145,8 +147,8 @@
+ 				<th>
+ 					{{ lang('CURRENT_VERSION') }}
+ 				</th>
+-				<th{{ !EXTMGRPLUS_SWITCH_MIGRATION_COL ? ' style="display: none;"' }}>
+-					{{ common.icon('fa-arrow-up', 'EXTMGRPLUS_COL_MIGRATIONS') }}<span style="display: none;">{{ lang('EXTMGRPLUS_COL_MIGRATIONS') }}</span>
++				<th{{ !EXTMGRPLUS_SWITCH_MIGRATION_COL ? ' style="display: none;"' }} title="{{ lang('EXTMGRPLUS_COL_MIGRATIONS') }}">
++					{{ common.icon('fa-arrow-up') }}<span style="display: none;">{{ lang('EXTMGRPLUS_COL_MIGRATIONS') }}</span>
+ 				</th>
+ 				<th>
+ 					{{ lang('EXTENSION_OPTIONS') }}
+@@ -154,14 +156,14 @@
+ 				<th>
+ 					{{ lang('EXTENSION_ACTIONS') }}
+ 				</th>
+-				<th>
+-					{{ common.icon('fa-check', 'EXTMGRPLUS_COL_SELECT') }}<span style="display: none;">{{ lang('EXTMGRPLUS_COL_SELECT') }}</span>
++				<th title="{{ lang('EXTMGRPLUS_COL_SELECT') }}">
++					{{ common.icon('fa-check') }}<span style="display: none;">{{ lang('EXTMGRPLUS_COL_SELECT') }}</span>
+ 				</th>
+-				<th style="display: none;">
+-					{{ common.icon('fa-sort', 'EXTMGRPLUS_COL_ORDER') }}<span style="display: none;">{{ lang('EXTMGRPLUS_COL_ORDER') }}</span>
++				<th title="{{ lang('EXTMGRPLUS_COL_ORDER') }}" style="display: none;">
++					{{ common.icon('fa-sort') }}<span style="display: none;">{{ lang('EXTMGRPLUS_COL_ORDER') }}</span>
+ 				</th>
+-				<th style="display: none;">
+-					{{ common.icon('fa-ban', 'EXTMGRPLUS_COL_IGNORE') }}<span style="display: none;">{{ lang('EXTMGRPLUS_COL_IGNORE') }}</span>
++				<th title="{{ lang('EXTMGRPLUS_COL_IGNORE') }}" style="display: none;">
++					{{ common.icon('fa-ban') }}<span style="display: none;">{{ lang('EXTMGRPLUS_COL_IGNORE') }}</span>
+ 				</th>
+ 			</tr>
+ 		</thead>
+@@ -207,10 +209,11 @@
+ 					{% set vc_obj = EXTMGRPLUS_LIST_VERSIONCHECK[ext.NAME] ?? {} %}
+ 					<tr class="ext_{{ list }} row-highlight">
+ 						<td>
+-							{{ vc_obj.cdb_ext ? {
+-								1:	common.icon('fa-database', 'EXTMGRPLUS_TOOLTIP_CDB_EXT'),
+-								2:	common.icon('fa-star', 'EXTMGRPLUS_TOOLTIP_CDB_EXT_OFFICIAL'),
+-							}[vc_obj.cdb_ext] }}
++							{% apply spaceless %}
++							{% if vc_obj.cdb_ext === true %}
++								<span title="{{ lang('EXTMGRPLUS_TOOLTIP_CDB_EXT')|e('html') }}">{{ common.icon('fa-database') }}</span>
++							{% endif %}
++							{% endapply %}
+ 						</td>
+ 						<td>
+ 							{% apply spaceless %}
+@@ -233,14 +236,14 @@
+ 									<strong class="{{ vc_obj.current == 'NOUPD' ? 'current-ext' : 'outdated-ext' }}">{{ ext.META_VERSION }}</strong>
+ 								{% endif %}
+ 								{% if vc_obj.current === false %}
+-									{{ common.icon('fa-chain-broken', 'EXTMGRPLUS_TOOLTIP_NO_VERSIONCHECK') }}
++									<span title="{{ lang('EXTMGRPLUS_TOOLTIP_NO_VERSIONCHECK')|e('html') }}">&nbsp;{{ common.icon('fa-chain-broken') }}</span>
+ 								{% elseif vc_obj.current == 'ERROR' %}
+-									{{ common.icon('fa-exclamation-triangle', 'EXTMGRPLUS_TOOLTIP_VERSIONCHECK_ERROR') }}
++									<span title="{{ lang('EXTMGRPLUS_TOOLTIP_VERSIONCHECK_ERROR')|e('html') }}">&nbsp;{{ common.icon('fa-exclamation-triangle') }}</span>
+ 								{% elseif vc_obj.current is empty %}
+-									{{ common.icon('fa-question-circle', 'EXTMGRPLUS_TOOLTIP_VERSIONCHECK_EMPTY') }}
++									<span title="{{ lang('EXTMGRPLUS_TOOLTIP_VERSIONCHECK_EMPTY')|e('html') }}">&nbsp;{{ common.icon('fa-question-circle') }}</span>
+ 								{% elseif vc_obj.current != 'NOUPD' %}
+-									{{ common.icon('fa-exclamation-circle outdated-ext', 'EXTMGRPLUS_TOOLTIP_OUTDATED') }}
+-									<strong class="current-ext">({{ vc_obj.current }})</strong>
++									<span title="{{ lang('EXTMGRPLUS_TOOLTIP_OUTDATED')|e('html') }}">&nbsp;{{ common.icon('fa-exclamation-circle outdated-ext') }}</span>
++									<strong class="current-ext">&nbsp;({{ vc_obj.current }})</strong>
+ 								{% endif %}
+ 							{% endif %}
+ 							{% endapply %}
+@@ -250,7 +253,7 @@
+ 							{% if list != 'enabled' && EXTMGRPLUS_SWITCH_MIGRATION_COL %}
+ 								{% set count = EXTMGRPLUS_LIST_MIGRATIONS[ext.NAME] ?? 0 %}
+ 								{% if EXTMGRPLUS_LIST_IGNORE[ext.NAME] is defined %}
+-									{{ common.icon('fa-ban', 'EXTMGRPLUS_TOOLTIP_IS_IGNORED') }}
++									<span title="{{ lang('EXTMGRPLUS_TOOLTIP_IS_IGNORED')|e('html') }}">{{ common.icon('fa-ban') }}</span>
+ 								{% elseif count %}
+ 									<span title="{{ lang('EXTMGRPLUS_TOOLTIP_HAS_MIGRATION')|e('html') }}">{{ count }}</span>
+ 								{% endif %}
+@@ -270,23 +273,15 @@
+ 								<a href="{{ action.U_ACTION }}"{{ action.L_ACTION_EXPLAIN ? ' title="' ~ action.L_ACTION_EXPLAIN ~ '"' }}>{{ action.L_ACTION }}</a>
+ 								{{ !loop.last ? '<span>&nbsp;|&nbsp;</span>' }}
+ 							{% endfor %}
+-							{% if list == 'enabled' && EXTMGRPLUS_SWITCH_SETTINGS_LINK %}
+-								<span>&nbsp;|&nbsp;</span>
+-								{% if EXTMGRPLUS_LIST_MODULES[ext.NAME] is defined %}
+-									<a href="{{ EXTMGRPLUS_LIST_MODULES[ext.NAME] }}" title="{{ lang('EXTMGRPLUS_TOOLTIP_SETTINGS') }}">{{ lang('SETTINGS') }}</a>
+-								{% else %}
+-									<span class="emp_unavailable">{{ lang('SETTINGS') }}</span>
+-								{% endif %}
+-							{% endif %}
+ 							{% endapply %}
+ 						</td>
+ 						<td>
+ 							{% apply spaceless %}
+ 							{% if list != 'not_installed' && ext.NAME is defined && (ext.NAME != 'lukewcs/extmgrplus' || EXTMGRPLUS_SWITCH_SELF_DISABLE) %}
+ 								{% if EXTMGRPLUS_LIST_IGNORE[ext.NAME] is defined %}
+-									{{ common.icon('fa-ban', 'EXTMGRPLUS_TOOLTIP_IS_IGNORED') }}
++									<span title="{{ lang('EXTMGRPLUS_TOOLTIP_IS_IGNORED')|e('html') }}">{{ common.icon('fa-ban') }}
+ 								{% elseif EXTMGRPLUS_LIST_MIGRATIONS[ext.NAME] is defined && !EXTMGRPLUS_SWITCH_MIGRATIONS %}
+-									<input type="checkbox" class="checkbox" title="{{ lang('EXTMGRPLUS_TOOLTIP_IS_LOCKED')|e('html') }}" disabled>
++									<input type="checkbox" name="ext_mark_{{ list }}[]" class="checkbox" title="{{ lang('EXTMGRPLUS_TOOLTIP_IS_LOCKED')|e('html') }}" disabled>
+ 								{% else %}
+ 									<input type="checkbox" name="ext_mark_{{ list }}[]" class="checkbox" title="{{ lang('EXTMGRPLUS_TOOLTIP_SELECT')|e('html') }}" value="{{ ext.NAME }}"{{ EXTMGRPLUS_LIST_SELECTED[ext.NAME] is defined ? ' checked' }}>
+ 								{% endif %}
+@@ -296,7 +291,7 @@
+ 						<td style="display: none;">
+ 							{% apply spaceless %}
+ 							{% if ext.NAME is defined && ext.NAME != 'lukewcs/extmgrplus' && EXTMGRPLUS_SWITCH_ORDER_AND_IGNORE %}
+-								<input type="text" name="ext_order[{{ ext.NAME }}]" size="2" maxlength="3"{{ EXTMGRPLUS_LIST_IGNORE[ext.NAME] is defined ? ' class="emp_inactive"' }} title="{{ lang('EXTMGRPLUS_TOOLTIP_ORDER')|e('html') }}" value="{{ EXTMGRPLUS_LIST_ORDER[ext.NAME] ?? '' }}" pattern="^\+?[0-9]{1,2}$">
++								<input type="text" name="ext_order[{{ ext.NAME }}]" size="2" maxlength="3"{{ EXTMGRPLUS_LIST_IGNORE[ext.NAME] is defined ? ' class="inactive"' }} title="{{ lang('EXTMGRPLUS_TOOLTIP_ORDER')|e('html') }}" value="{{ EXTMGRPLUS_LIST_ORDER[ext.NAME] ?? '' }}" pattern="^\+?[0-9]{1,2}$">
+ 							{% endif %}
+ 							{% endapply %}
+ 						</td>
+@@ -363,7 +358,7 @@
+ 		</fieldset>
+ 	{% elseif type == 'save_checkboxes' %}
+ 		<input type="submit" name="extmgrplus_save_checkboxes" value="save_checkboxes" hidden>
+-	{% elseif type ends with 'able_all' %}
++	{% elseif type == 'disable_all' || type == 'enable_all'%}
+ 		{% set type_upper = type|upper %}
+ 		<input type="submit" name="extmgrplus_{{ type }}" class="button1" title="{{ lang('EXTMGRPLUS_TOOLTIP_' ~ type_upper)|e('html') }}" value="{{ lang('EXTMGRPLUS_' ~ type_upper) }}"{{ !enabled ? ' disabled' }}>
+ 	{% endif %}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_acp_ext_list.js" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_acp_ext_list.js"
+index a392d1064..9d39732ed 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_acp_ext_list.js"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_acp_ext_list.js"
+@@ -97,7 +97,7 @@ function setButtonState(e) {
+ };
+ 
+ function setInputBoxState(e) {
+-	$('input[name="ext_order[' + e.currentTarget.value + ']"]').toggleClass('emp_inactive', e.currentTarget.checked);
++	$('input[name="ext_order[' + e.currentTarget.value + ']"]').toggleClass('inactive', e.currentTarget.checked);
+ };
+ 
+ /*
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_confirm_body.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_confirm_body.html"
+index b03d4b2b8..2dae27c43 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_confirm_body.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_confirm_body.html"
+@@ -18,9 +18,7 @@
+ 
+ <p>{{ lang('EXTENSIONS_EXPLAIN') }}</p>
+ 
+-{% if EXTMGRPLUS_ACTION_MODE -%}
+-	<p>{{ lang('EXTENSION_' ~ EXTMGRPLUS_ACTION_MODE ~ '_EXPLAIN') }}</p>
+-{%- endif %}
++<p>{{ lang('EXTENSION_' ~ EXTMGRPLUS_ACTION_MODE ~ '_EXPLAIN') }}</p>
+ 
+ <form id="confirm" method="post" action="{{ S_CONFIRM_ACTION }}">
+ 	<fieldset>
+@@ -28,15 +26,15 @@
+ 
+ 		<p>{{ MESSAGE_TEXT }}</p>
+ 
+-		{% if EXTMGRPLUS_ACTION_MODE == 'DISABLE' && 'lukewcs/extmgrplus' in S_HIDDEN_FIELDS -%}
++		{% if EXTMGRPLUS_SELF_DISABLE %}
+ 			<p>{{ lang('EXTMGRPLUS_MSG_SELF_DISABLE') }}</p>
+-		{%- endif %}
++		{% endif %}
+ 
+ 		{{ S_HIDDEN_FIELDS }}
+ 
+ 		<fieldset class="submit-buttons">
+-			<button type="submit" name="confirm" value="{{ lang('YES') }}" class="button1">{{ lang(EXTMGRPLUS_CONFIRM_YES ?? 'YES') }}</button>
+-			<button type="submit" name="cancel" value="{{ lang('NO') }}" class="button2">{{ lang(EXTMGRPLUS_CONFIRM_NO ?? 'NO') }}</button>
++			<input type="submit" name="confirm" value="{{ lang('YES') }}" class="button1">&nbsp;
++			<input type="submit" name="cancel" value="{{ lang('NO') }}" class="button2">
+ 		</fieldset>
+ 	</fieldset>
+ 
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_macros.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_macros.html"
+index bccefff61..d8a2dc1cb 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_macros.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_macros.html"
+@@ -20,19 +20,16 @@
+ 	{% endif %}
+ {% endmacro %}
+ 
+-{% macro icon(classes, title = null, decorative = true) -%}
+-	<i class="icon {{ classes }}"{{
+-		(title != null ? ' title="' ~ lang(title)|e('html') ~ '"') ~
+-		(decorative ? ' aria-hidden="true"')
+-	}}></i>
++{% macro icon(classes, decorative = true) -%}
++	<i class="icon {{ classes }}"{{ decorative ? ' aria-hidden="true"' }}></i>
+ {%- endmacro %}
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
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_message_body.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_message_body.html"
+index ff0ba456a..857363870 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_message_body.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_message_body.html"
+@@ -22,7 +22,7 @@
+ 	<p>{{ lang('EXTENSION_' ~ EXTMGRPLUS_ACTION_MODE ~ '_EXPLAIN') }}</p>
+ {%- endif %}
+ 
+-<div class="{{ {0: 'successbox', 1: 'errorbox', 2: 'errorbox emp_warning', 3: 'errorbox emp_success_error'}[EXTMGRPLUS_TRIGGER_ERROR] }}">
++<div class="{{ S_USER_NOTICE ? 'successbox' : 'errorbox' }}">
+ 	<h3>{{ MESSAGE_TITLE }}</h3>
+ 
+ 	<p>{{ MESSAGE_TEXT }}</p>
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_settings.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_settings.html"
+index eb13ee558..421c4a386 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_settings.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_settings.html"
+@@ -16,6 +16,8 @@
+ 
+ {% set switch_type = TOGGLECTRL_TYPE ?? 'toggle' %}
+ 
++<a id="maincontent"></a>
++
+ <h1>{{ lang('EXTENSIONS_ADMIN') }}</h1>
+ 
+ <p>{{ lang('EXTENSIONS_EXPLAIN') }}</p>
+@@ -92,22 +94,22 @@
+ 
+ 		<dl>
+ 			<dt>
+-				<label>{{ lang('EXTMGRPLUS_VC_LIMIT') ~ lang('COLON') }}</label><br>
+-				<span>{{ lang('EXTMGRPLUS_VC_LIMIT_EXPLAIN') }}</span>
++				<label>{{ lang('EXTMGRPLUS_INSTRUCTIONS') ~ lang('COLON') }}</label><br>
++				<span>{{ lang('EXTMGRPLUS_INSTRUCTIONS_EXPLAIN') }}</span>
+ 			</dt>
+ 			<dd>
+-				{{ _self.number('extmgrplus_number_vc_limit', EXTMGRPLUS_NUMBER_VC_LIMIT, 1, 99) }}
+-				{{ lang('SECONDS') }}
++				{{ _self.switch('extmgrplus_switch_instructions', EXTMGRPLUS_SWITCH_INSTRUCTIONS, switch_type) }}
+ 			</dd>
+ 		</dl>
+ 
+ 		<dl>
+ 			<dt>
+-				<label>{{ lang('EXTMGRPLUS_SETTING_LINKS') ~ lang('COLON') }}</label><br>
+-				<span>{{ lang('EXTMGRPLUS_SETTING_LINKS_EXPLAIN') }}</span>
++				<label>{{ lang('EXTMGRPLUS_VC_LIMIT') ~ lang('COLON') }}</label><br>
++				<span>{{ lang('EXTMGRPLUS_VC_LIMIT_EXPLAIN') }}</span>
+ 			</dt>
+ 			<dd>
+-				{{ _self.switch('extmgrplus_switch_settings_link', EXTMGRPLUS_SWITCH_SETTINGS_LINK, switch_type) }}
++				{{ _self.number('extmgrplus_number_vc_limit', EXTMGRPLUS_NUMBER_VC_LIMIT, 1, 99) }}
++				{{ lang('SECONDS') }}
+ 			</dd>
+ 		</dl>
+ 
+@@ -124,17 +126,7 @@
+ 		</dl>
+ 
+ 		<legend class="legend_sub">{{ lang('EXTMGRPLUS_SECTION_EXPERT_SETTINGS') }}</legend>
+-		<p class="legend_explain">{{ lang('EXTMGRPLUS_EXPERT_SETTINGS_EXPLAIN') }}</p>
+-
+-		<dl>
+-			<dt>
+-				<label>{{ lang('EXTMGRPLUS_INSTRUCTIONS') ~ lang('COLON') }}</label><br>
+-				<span>{{ lang('EXTMGRPLUS_INSTRUCTIONS_EXPLAIN') }}</span>
+-			</dt>
+-			<dd>
+-				{{ _self.switch('extmgrplus_switch_instructions', EXTMGRPLUS_SWITCH_INSTRUCTIONS, switch_type) }}
+-			</dd>
+-		</dl>
++		<p>{{ lang('EXTMGRPLUS_EXPERT_SETTINGS_EXPLAIN') }}</p>
+ 
+ 		<dl>
+ 			<dt>
+@@ -175,7 +167,7 @@
+ 				<span>{{ lang('EXTMGRPLUS_DEFAULTS_EXP') }}</span>
+ 			</dt>
+ 			<dd>
+-				<input type="button" class="button2" name="extmgrplus_defaults" value="{{ lang('EXTMGRPLUS_BUTTON_DEFAULTS') }}">
++				{{ _self.button('extmgrplus_defaults', 'EXTMGRPLUS_BUTTON_DEFAULTS') }}
+ 			</dd>
+ 		</dl>
+ 	</fieldset>
+@@ -232,13 +224,17 @@
+ 	}}>
+ {%- endmacro %}
+ 
++{% macro button(name, lang_var) -%}
++	<input type="button" class="button2" name="{{ name }}" value="{{ lang(lang_var) }}">
++{%- endmacro %}
++
+ {% macro confirmbox(name, message, default = false) -%}
+-	<div class="lukewcs_confirmbox" data-name="{{ name }}" data-default="{{ default }}" style="display: none;">
++	<div id="{{ name }}_confirmbox" data-default="{{ default }}" style="display: none;">
+ 		<h2>{{ lang('CONFIRM') }}</h2>
+ 		<p>{{ message }}</p>
+ 		<p>
+-			<input type="button" class="button1" name="lukewcs_confirmbox_yes" value="{{ lang('YES') }}">&nbsp;
+-			<input type="button" class="button2" name="lukewcs_confirmbox_no" value="{{ lang('NO') }}">
++			<input type="button" class="button1" name="{{ name }}_confirm_yes" value="{{ lang('YES') }}">&nbsp;
++			<input type="button" class="button2" name="{{ name }}_confirm_no" value="{{ lang('NO') }}">
+ 		</p>
+ 	</div>
+ {%- endmacro %}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_settings.js" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_settings.js"
+index 38cce605c..146ad6c94 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_settings.js"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_settings.js"
+@@ -11,140 +11,142 @@
+ */
+ 
+ (function ($) {
+-	'use strict';
+-
+-	/*
+-		Classes
+-	*/
+-
+-	class LukeWCSphpBBConfirmBox {
+-		/*
+-		* phpBB ConfirmBox class for checkboxes and yes/no radio buttons - v1.5.1
+-		* @copyright (c) 2023, LukeWCS, https://www.wcsaga.org
+-		* @license GNU General Public License, version 2 (GPL-2.0-only)
+-		*/
+-
+-		constructor(submitSelector, animDuration = 0) {
+-			let _this = this;
+-			this.$submitObject	= $(submitSelector);
+-			this.$formObject	= this.$submitObject.parents('form');
+-			this.animDuration	= animDuration;
+-
+-			this.$formObject.find('div.lukewcs_confirmbox').each(function () {
+-				$('input[name="' + $(this).attr('data-name') + '"]').on('change', _this.#Show);
+-				$(this).find('input[type="button"]')				.on('click'	, _this.#Button);
+-			});
+-			this.$formObject										.on('reset'	, _this.HideAll);
+-		}
+ 
+-		HideAll = () => {
+-			const $elementObject	= this.$formObject.find('input.lukewcs_confirmbox_active');
+-			const $confirmBoxObject	= this.$formObject.find('div.lukewcs_confirmbox');
++'use strict';
+ 
+-			this.#changeBoxState($elementObject, $confirmBoxObject, false);
+-		}
++/*
++	Classes
++*/
+ 
+-		#Show = (e) => {
+-			const $elementObject	= $('input[name="' + e.target.name + '"]');
+-			const $confirmBoxObject	= $('div.lukewcs_confirmbox[data-name="' + e.target.name + '"]');
++class LukeWCSphpBBConfirmBox {
++/*
++* phpBB ConfirmBox class for checkboxes and yes/no radio buttons - v1.4.3
++* @copyright (c) 2023, LukeWCS, https://www.wcsaga.org
++* @license GNU General Public License, version 2 (GPL-2.0-only)
++*/
++	constructor(submitSelector, animDuration = 0) {
++		let _this = this;
++		this.$submitObject	= $(submitSelector);
++		this.$formObject	= this.$submitObject.parents('form');
++		this.animDuration	= animDuration;
++
++		this.$formObject.find('div[id$="_confirmbox"]').each(function () {
++			const elementName = this.id.replace('_confirmbox', '');
++
++			$('input[name="' + elementName + '"]')				.on('change'	, _this.#Show);
++			$('input[name^="' + elementName + '_confirm_"]')	.on('click'		, _this.#Button);
++		});
++		this.$formObject										.on('reset'		, _this.HideAll);
++	}
+ 
+-			if ($elementObject.prop('checked') != $confirmBoxObject.attr('data-default')) {
+-				this.#changeBoxState($elementObject, $confirmBoxObject, true);
+-			}
++	#Show = (e) => {
++		const $elementObject	= $('input[name="' + e.target.name + '"]');
++		const $confirmBoxObject	= $('div[id="' + e.target.name + '_confirmbox"]');
++
++		if ($elementObject.prop('checked') != $confirmBoxObject.attr('data-default')) {
++			this.#changeBoxState($elementObject, $confirmBoxObject, true);
+ 		}
++	}
++
++	#Button = (e) => {
++		const elementName		= e.target.name.replace(/_confirm_.*/, '');
++		const $elementObject	= $('input[name="' + elementName + '"]');
++		const $confirmBoxObject	= $('div[id="' + elementName + '_confirmbox"]');
++		const elementType		= $elementObject.attr('type');
+ 
+-		#Button = (e) => {
+-			const elementName		= $(e.target).parents('div.lukewcs_confirmbox').attr('data-name');
+-			const $elementObject	= $('input[name="' + elementName + '"]');
+-			const elementType		= $elementObject.attr('type');
+-			const $confirmBoxObject	= $('div.lukewcs_confirmbox[data-name="' + elementName + '"]');
+-
+-			if (e.target.name == 'lukewcs_confirmbox_no') {
+-				if (elementType == 'checkbox') {
+-					$elementObject.prop('checked', $confirmBoxObject.attr('data-default'));
+-				} else if (elementType == 'radio') {
+-					$elementObject.filter('[value="' + ($confirmBoxObject.attr('data-default') ? '1' : '0') + '"]').prop('checked', true);
+-				}
++		if (e.target.name.endsWith('_confirm_no')) {
++			if (elementType == 'checkbox') {
++				$elementObject.prop('checked', $confirmBoxObject.attr('data-default'));
++			} else if (elementType == 'radio') {
++				$elementObject.filter('[value="' + ($confirmBoxObject.attr('data-default') ? '1' : '0') + '"]').prop('checked', true);
+ 			}
+-			this.#changeBoxState($elementObject, $confirmBoxObject, null);
+ 		}
++		this.#changeBoxState($elementObject, $confirmBoxObject, null);
++	}
+ 
+-		#changeBoxState = ($elementObject, $confirmBoxObject, showBox) => {
+-			$elementObject		.prop('disabled', !!showBox);
+-			$elementObject		.toggleClass('lukewcs_confirmbox_active', !!showBox);
+-			$confirmBoxObject	[showBox ? 'show' : 'hide'](this.animDuration);
+-			this.$submitObject	.prop('disabled', showBox ?? this.$formObject.find('input.lukewcs_confirmbox_active').length);
+-		}
++	HideAll = () => {
++		const $elementObject	= this.$formObject.find('input.confirmbox_active');
++		const $confirmBoxObject	= this.$formObject.find('div[id$="_confirmbox"]');
++
++		this.#changeBoxState($elementObject, $confirmBoxObject, false);
+ 	}
+ 
+-	/*
+-		Declarations
+-	*/
+-
+-	const constants = Object.freeze({
+-		CheckBoxModeOff:	'0',
+-		CheckBoxModeAll:	'1',
+-		CheckBoxModeLast:	'2',
+-	});
+-	let ConfirmBox;
+-
+-	/*
+-		Settings form
+-	*/
+-
+-	function setDefaults() {
+-		const c = constants;
+-
+-		setSwitch('[name="extmgrplus_switch_log"]',							true);
+-		setSwitch('[name="extmgrplus_switch_confirmation"]',				true);
+-		setSwitch('[name="extmgrplus_switch_auto_redirect"]',				false);
+-		$(        '[name="extmgrplus_select_checkbox_mode"]').prop('value',	c.CheckBoxModeAll);
+-		setSwitch('[name="extmgrplus_switch_order_and_ignore"]',			true);
+-		setSwitch('[name="extmgrplus_switch_self_disable"]',				false);
+-		setSwitch('[name="extmgrplus_switch_instructions"]',				true);
+-		setSwitch('[name="extmgrplus_switch_settings_link"]',				true);
+-		$(        '[name="extmgrplus_number_vc_limit"]').prop('value',		15);
+-		setSwitch('[name="extmgrplus_switch_migration_col"]',				false);
+-		setSwitch('[name="extmgrplus_switch_migrations"]',					false);
+-		setSwitch('[name="extmgrplus_switch_version_url"]',					false);
+-
+-		ConfirmBox.HideAll();
+-	};
+-
+-	function setSwitch(selector, checked) {
+-		const $elementObject	= $(selector);
+-		const elementType		= $elementObject.attr('type');
++	#changeBoxState = ($elementObject, $confirmBoxObject, showBox) => {
++		$elementObject		.prop('disabled', !!showBox);
++		$elementObject		.toggleClass('confirmbox_active', !!showBox);
++		$confirmBoxObject	[showBox ? 'show' : 'hide'](this.animDuration);
++		this.$submitObject	.prop('disabled', showBox ?? this.$formObject.find('input.confirmbox_active').length);
++	}
++}
+ 
+-		if (elementType == 'checkbox') {
+-			$elementObject.prop('checked', checked);
+-		} else if (elementType == 'radio') {
+-			$elementObject.filter('[value="' + (checked ? '1' : '0') + '"]').prop('checked', true);
+-		}
+-	};
++/*
++	Declarations
++*/
+ 
+-	function formSubmit() {
+-		$('[name="extmgrplus_save_settings"]').click();
+-	};
++const constants = Object.freeze({
++	CheckBoxModeOff:	'0',
++	CheckBoxModeAll:	'1',
++	CheckBoxModeLast:	'2',
++});
++let ConfirmBox;
+ 
+-	/*
+-		Common
+-	*/
++/*
++	Settings form
++*/
+ 
+-	function disableEnter(e) {
+-		if (e.key == 'Enter' && e.target.type != 'textarea') {
+-			return false;
+-		}
+-	};
++function setDefaults() {
++	const c = constants;
++
++	setSwitch('[name="extmgrplus_switch_log"]',							true);
++	setSwitch('[name="extmgrplus_switch_confirmation"]',				true);
++	setSwitch('[name="extmgrplus_switch_auto_redirect"]',				false);
++	$(        '[name="extmgrplus_select_checkbox_mode"]').prop('value',	c.CheckBoxModeAll);
++	setSwitch('[name="extmgrplus_switch_order_and_ignore"]',			true);
++	setSwitch('[name="extmgrplus_switch_self_disable"]',				false);
++	setSwitch('[name="extmgrplus_switch_instructions"]',				true);
++	$(        '[name="extmgrplus_number_vc_limit"]').prop('value',		15);
++	setSwitch('[name="extmgrplus_switch_migration_col"]',				false);
++	setSwitch('[name="extmgrplus_switch_migrations"]',					false);
++	setSwitch('[name="extmgrplus_switch_version_url"]',					false);
++
++	ConfirmBox.HideAll();
++};
++
++function setSwitch(selector, checked) {
++	const $elementObject	= $(selector);
++	const elementType		= $elementObject.attr('type');
++
++	if (elementType == 'checkbox') {
++		$elementObject.prop('checked', checked);
++	} else if (elementType == 'radio') {
++		$elementObject.filter('[value="' + (checked ? '1' : '0') + '"]').prop('checked', true);
++	}
++};
++
++function formSubmit() {
++	$('[name="extmgrplus_save_settings"]').click();
++};
++
++/*
++	Common
++*/
++
++function disableEnter(e) {
++	if (e.key == 'Enter' && e.target.type != 'textarea') {
++		return false;
++	}
++};
++
++/*
++	Event registration
++*/
+ 
+-	/*
+-		Event registration
+-	*/
++$(function () {
++	$('#extmgrplus_settings')			.on('keypress'	, disableEnter);
++	$('[name="extmgrplus_defaults"]')	.on('click'		, setDefaults);
++	$('[name="extmgrplus_submit"]')		.on('click'		, formSubmit);
+ 
+-	$(function () {
+-		$('#extmgrplus_settings')			.on('keypress'	, disableEnter);
+-		$('[name="extmgrplus_defaults"]')	.on('click'		, setDefaults);
+-		$('[name="extmgrplus_submit"]')		.on('click'		, formSubmit);
++	ConfirmBox = new LukeWCSphpBBConfirmBox('[name="extmgrplus_submit"]', 300);
++});
+ 
+-		ConfirmBox = new LukeWCSphpBBConfirmBox('[name="extmgrplus_submit"]', 300);
+-	});
+ })(jQuery);
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_versioncheck.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_versioncheck.html"
+index 9d6aaf8c4..eb385e167 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_versioncheck.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_versioncheck.html"
+@@ -14,6 +14,8 @@
+ 
+ {% INCLUDE 'overall_header.html' %}
+ 
++<a id="maincontent"></a>
++
+ <h1>{{ lang('EXTENSIONS_ADMIN') }}</h1>
+ 
+ <p>{{ lang('EXTENSIONS_EXPLAIN') }}</p>
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/adm/style/event/acp_ext_details_end.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/adm/style/event/acp_ext_details_end.html"
+new file mode 100644
+index 000000000..13dbd1022
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/adm/style/event/acp_ext_details_end.html"
+@@ -0,0 +1,26 @@
++{% import '@lukewcs_extmgrplus/acp_ext_mgr_plus_macros.html' as common %}
++
++
++{% if EXTMGRPLUS_DETAILS|length %}
++	<fieldset>
++		<legend>{{ lang('EXTMGRPLUS_SECTION_DETAILS') }}</legend>
++
++	{% if EXTMGRPLUS_DETAILS.cdb_page %}
++		<dl>
++			<dt><label>{{ lang('EXTMGRPLUS_DETAILS_CDB_PAGE') ~ lang('COLON') }}</label></dt>
++			<dd><strong><a href="{{ EXTMGRPLUS_DETAILS.cdb_page }}">{{ EXTMGRPLUS_DETAILS.cdb_page }}</a></strong></dd>
++		</dl>
++	{% endif %}
++
++	{% if EXTMGRPLUS_DETAILS.version_url %}
++		<dl>
++			<dt><label>{{ lang('EXTMGRPLUS_DETAILS_VERSION_URL') ~ lang('COLON') }}</label></dt>
++			<dd><strong><a href="{{ EXTMGRPLUS_DETAILS.version_url }}">{{ EXTMGRPLUS_DETAILS.version_url }}</a></strong></dd>
++		</dl>
++	{% endif %}
++	</fieldset>
++{% endif %}
++
++{{ common.footer(EXTMGRPLUS_METADATA) }}
++
++{% INCLUDECSS '@lukewcs_extmgrplus/acp_ext_mgr_plus.css' %}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/composer.json"
+index 42a77c63f..577550354 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/composer.json"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/composer.json"
+@@ -3,8 +3,8 @@
+     "type": "phpbb-extension",
+     "description": "Adds the option to disable and re-enable all installed extensions at once to the extension management. Individual selections can be made using checkboxes. In addition, sequence groups and dependencies can be defined or extensions can be ignored. The version check is carried out in blocks and provides detailed information. Additional information is displayed in the extension management.",
+     "homepage": "https://github.com/LukeWCS/ext-mgr-plus",
+-    "version": "3.1.0",
+-    "time": "2025-11-01",
++    "version": "3.0.0",
++    "time": "2024-11-28",
+     "license": "GPL-2.0-only",
+     "authors": [
+         {
+@@ -19,13 +19,13 @@
+         }
+     ],
+     "require": {
+-        "php": ">=8.0.0,<8.5.0@dev",
++        "php": ">=7.4.0,<8.5.0@dev",
+         "composer/installers": "~1.0.0",
+         "phpbb/phpbb": ">=3.3.8,<3.4.0@dev"
+     },
+     "extra": {
+         "display-name": "Extension Manager Plus",
+-        "lang-min-ver": "3.1.0",
++        "lang-min-ver": "3.0.0",
+         "soft-require": {
+             "phpbb/phpbb": ">=3.3.8,<3.4.0@dev"
+         },
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/config/services.yml" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/config/services.yml"
+index a70d6857b..f5395d02b 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/config/services.yml"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/config/services.yml"
+@@ -19,8 +19,9 @@ services:
+             - '@language'
+             - '@template'
+             - '@dbal.conn'
+-            - '@path_helper'
+             - '%core.table_prefix%'
++            - '%core.root_path%'
++            - '%core.php_ext%'
+     lukewcs.extmgrplus.core.common:
+         class: lukewcs\extmgrplus\core\ext_mgr_plus_common
+         arguments:
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/controller/acp_ext_mgr_plus_controller.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/controller/acp_ext_mgr_plus_controller.php"
+index 2943e9378..0f91e63be 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/controller/acp_ext_mgr_plus_controller.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/controller/acp_ext_mgr_plus_controller.php"
+@@ -15,16 +15,27 @@ namespace lukewcs\extmgrplus\controller;
+ 
+ class acp_ext_mgr_plus_controller
+ {
++	protected object $common;
++	protected object $language;
++	protected object $template;
++	protected object $request;
++	protected object $config;
++
+ 	protected string $u_action;
+ 
+ 	public function __construct(
+-		protected object $common,
+-		protected \phpbb\language\language $language,
+-		protected \phpbb\template\template $template,
+-		protected \phpbb\request\request $request,
+-		protected \phpbb\config\config $config,
++		$common,
++		\phpbb\language\language $language,
++		\phpbb\template\template $template,
++		\phpbb\request\request $request,
++		\phpbb\config\config $config
+ 	)
+ 	{
++		$this->common	= $common;
++		$this->language	= $language;
++		$this->template	= $template;
++		$this->request	= $request;
++		$this->config	= $config;
+ 	}
+ 
+ 	public function module_settings(): void
+@@ -54,7 +65,6 @@ class acp_ext_mgr_plus_controller
+ 			$this->config->set('extmgrplus_switch_order_and_ignore'	, $this->request->variable('extmgrplus_switch_order_and_ignore'	, 0));
+ 			$this->config->set('extmgrplus_switch_self_disable'		, $this->request->variable('extmgrplus_switch_self_disable'		, 0));
+ 			$this->config->set('extmgrplus_switch_instructions'		, $this->request->variable('extmgrplus_switch_instructions'		, 0));
+-			$this->config->set('extmgrplus_switch_settings_link'	, $this->request->variable('extmgrplus_switch_settings_link'	, 0));
+ 			$this->config->set('extmgrplus_number_vc_limit'			, $this->request->variable('extmgrplus_number_vc_limit'			, 0));
+ 			$this->config->set('extmgrplus_switch_migration_col'	, $this->request->variable('extmgrplus_switch_migration_col'	, 0));
+ 			$this->config->set('extmgrplus_switch_migrations'		, $this->request->variable('extmgrplus_switch_migrations'		, 0));
+@@ -77,7 +87,6 @@ class acp_ext_mgr_plus_controller
+ 			'EXTMGRPLUS_SWITCH_ORDER_AND_IGNORE'		=> (bool) $this->config['extmgrplus_switch_order_and_ignore'],
+ 			'EXTMGRPLUS_SWITCH_SELF_DISABLE'			=> (bool) $this->config['extmgrplus_switch_self_disable'],
+ 			'EXTMGRPLUS_SWITCH_INSTRUCTIONS'			=> (bool) $this->config['extmgrplus_switch_instructions'],
+-			'EXTMGRPLUS_SWITCH_SETTINGS_LINK'			=> (bool) $this->config['extmgrplus_switch_settings_link'],
+ 			'EXTMGRPLUS_NUMBER_VC_LIMIT'				=> (int) $this->config['extmgrplus_number_vc_limit'],
+ 			'EXTMGRPLUS_SWITCH_MIGRATION_COL'			=> (bool) $this->config['extmgrplus_switch_migration_col'],
+ 			'EXTMGRPLUS_SWITCH_MIGRATIONS'				=> (bool) $this->config['extmgrplus_switch_migrations'],
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/core/ext_mgr_plus.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/core/ext_mgr_plus.php"
+index ee129cbb4..7bc61a912 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/core/ext_mgr_plus.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/core/ext_mgr_plus.php"
+@@ -19,34 +19,55 @@ class ext_mgr_plus
+ 	protected const  CHECKBOX_ALL	= 1;
+ 	protected const  CHECKBOX_LAST	= 2;
+ 
+-	protected const  CDB_EXT			= 1;
+-	protected const  CDB_EXT_OFFICIAL	= 2;
+-
+-	protected string $u_action;
+-	protected int $safe_time_limit;
++	protected object $common;
++	protected object $ext_manager;
++	protected object $cache;
++	protected object $request;
++	protected object $log;
++	protected object $user;
++	protected object $config;
++	protected object $config_text;
++	protected object $language;
++	protected object $template;
++	protected object $db;
++	protected string $table_prefix;
+ 	protected string $phpbb_root_path;
+-	protected string $phpbb_admin_path;
+ 	protected string $php_ext;
+ 
++	protected string $u_action;
++	protected int    $safe_time_limit;
++
+ 	public function __construct(
+-		protected object $common,
+-		protected \phpbb\extension\manager $ext_manager,
+-		protected \phpbb\cache\driver\driver_interface $cache,
+-		protected \phpbb\request\request $request,
+-		protected \phpbb\log\log $log,
+-		protected \phpbb\user $user,
+-		protected \phpbb\config\config $config,
+-		protected \phpbb\config\db_text $config_text,
+-		protected \phpbb\language\language $language,
+-		protected \phpbb\template\template $template,
+-		protected \phpbb\db\driver\driver_interface $db,
+-		protected \phpbb\path_helper $path_helper,
+-		protected string $table_prefix,
++		$common,
++		\phpbb\extension\manager $ext_manager,
++		\phpbb\cache\driver\driver_interface $cache,
++		\phpbb\request\request $request,
++		\phpbb\log\log $log,
++		\phpbb\user $user,
++		\phpbb\config\config $config,
++		\phpbb\config\db_text $config_text,
++		\phpbb\language\language $language,
++		\phpbb\template\template $template,
++		\phpbb\db\driver\driver_interface $db,
++		$table_prefix,
++		$phpbb_root_path,
++		$php_ext
+ 	)
+ 	{
+-		$this->phpbb_root_path	= $this->path_helper->get_phpbb_root_path();
+-		$this->phpbb_admin_path	= $this->phpbb_root_path . $this->path_helper->get_adm_relative_path();
+-		$this->php_ext			= $this->path_helper->get_php_ext();
++		$this->common			= $common;
++		$this->ext_manager		= $ext_manager;
++		$this->cache			= $cache;
++		$this->request			= $request;
++		$this->log				= $log;
++		$this->user				= $user;
++		$this->config			= $config;
++		$this->config_text		= $config_text;
++		$this->language			= $language;
++		$this->template			= $template;
++		$this->db				= $db;
++		$this->table_prefix 	= $table_prefix;
++		$this->phpbb_root_path	= $phpbb_root_path;
++		$this->php_ext			= $php_ext;
+ 	}
+ 
+ 	/*
+@@ -59,9 +80,9 @@ class ext_mgr_plus
+ 			return;
+ 		}
+ 
+-		$this->u_action			= $event['u_action'];
+-		$this->common->u_action	= $this->u_action;
+-		$this->safe_time_limit	= $event['safe_time_limit'];
++		$this->u_action = $event['u_action'];
++		$this->common->u_action = $this->u_action;
++		$this->safe_time_limit = $event['safe_time_limit'];
+ 
+ 		$this->language->add_lang(['acp_ext_mgr_plus', 'acp_ext_mgr_plus_lang_author'], 'lukewcs/extmgrplus');
+ 		$this->common->set_meta_template_vars('EXTMGRPLUS', 'LukeWCS');
+@@ -74,19 +95,17 @@ class ext_mgr_plus
+ 
+ 			$this->exts_switch_confirm();
+ 		}
+-		else if ($this->request->is_set_post('extmgrplus_save_ext_properties'))
++		else if ($this->request->is_set_post('extmgrplus_save_ext_properties') && $this->config['extmgrplus_switch_order_and_ignore'])
+ 		{
+ 			$this->common->check_form_key_('lukewcs_extmgrplus');
+ 
+-			if ($this->config['extmgrplus_switch_order_and_ignore'])
+-			{
+-				$order_list		= $this->request->variable('ext_order', ['' => '']);
+-				$ignore_list	= $this->request->variable('ext_ignore', ['']);
+-				$order_list		= preg_grep('/^\+?[0-9]{1,2}$/', $order_list);
++			$order_list = $this->request->variable('ext_order', ['' => '']);
++			$ignore_list = $this->request->variable('ext_ignore', ['']);
+ 
+-				$this->common->config_text_set('extmgrplus_list_order_and_ignore', 'order', count($order_list) ? $order_list : null);
+-				$this->common->config_text_set('extmgrplus_list_order_and_ignore', 'ignore', count($ignore_list) ? $ignore_list : null);
+-			}
++			$order_list = preg_grep('/^\+?[0-9]{1,2}$/', $order_list);
++
++			$this->common->config_text_set('extmgrplus_list_order_and_ignore', 'order', count($order_list) ? $order_list : null);
++			$this->common->config_text_set('extmgrplus_list_order_and_ignore', 'ignore', count($ignore_list) ? $ignore_list : null);
+ 
+ 			$this->common->trigger_error_($this->language->lang('EXTMGRPLUS_MSG_EXT_PROPERTIES_SAVED'), E_USER_NOTICE, 'RETURN_TO_EXTENSION_LIST');
+ 		}
+@@ -111,8 +130,6 @@ class ext_mgr_plus
+ 	{
+ 		if ($event['action'] == 'details')
+ 		{
+-			$event['tpl_name'] = '@lukewcs_extmgrplus/acp_ext_mgr_plus_acp_ext_details';
+-
+ 			$this->extend_details($event['ext_name']);
+ 			$this->versioncheck_details($event['ext_name']);
+ 			return;
+@@ -136,7 +153,6 @@ class ext_mgr_plus
+ 		if ($vc_request)
+ 		{
+ 			$event['tpl_name'] = '@lukewcs_extmgrplus/acp_ext_mgr_plus_versioncheck';
+-
+ 			$this->template->assign_vars([
+ 				'EXTMGRPLUS_VC_DATA'		=> $ext_list_versioncheck['data'],
+ 				'U_EXTMGRPLUS_VC_CANCEL'	=> $this->u_action,
+@@ -165,7 +181,6 @@ class ext_mgr_plus
+ 		$ext_list_migrations_inactive			= [];
+ 		$ext_list_order							= [];
+ 		$ext_list_ignore						= [];
+-		$ext_list_modules						= [];
+ 		$ext_list_enabled_ignored				= [];
+ 		$ext_list_disabled_ignored				= [];
+ 		$ext_list_selected						= [];
+@@ -184,11 +199,6 @@ class ext_mgr_plus
+ 			$ext_list_disabled_ignored	= array_intersect_key($ext_list_ignore, $ext_list_disabled);
+ 		}
+ 
+-		if ($this->config['extmgrplus_switch_settings_link'])
+-		{
+-			$ext_list_modules = $this->get_module_links();
+-		}
+-
+ 		if ($this->config['extmgrplus_switch_migration_col'])
+ 		{
+ 			$ext_list_migrations_inactive = $this->get_exts_with_new_migration(array_diff_key($ext_list_available, $ext_list_enabled, $ext_list_ignore));
+@@ -204,7 +214,6 @@ class ext_mgr_plus
+ 		{
+ 			$ext_list_enabled_ignored['lukewcs/extmgrplus'] = 0;
+ 		}
+-
+ 		if (!$this->config['extmgrplus_switch_migrations'])
+ 		{
+ 			$ext_list_disabled_ignored = array_merge($ext_list_disabled_ignored, $ext_list_migrations_disabled);
+@@ -246,7 +255,6 @@ class ext_mgr_plus
+ 			'EXTMGRPLUS_LIST_IGNORE'				=> $ext_list_ignore,
+ 			'EXTMGRPLUS_LIST_MIGRATIONS'			=> $ext_list_migrations_inactive,
+ 			'EXTMGRPLUS_LIST_SELECTED'				=> $ext_list_selected,
+-			'EXTMGRPLUS_LIST_MODULES'				=> $ext_list_modules,
+ 			'EXTMGRPLUS_LIST_VERSIONCHECK'			=> $this->versioncheck_list($ext_list_available, $ext_list_versioncheck),
+ 
+ 			'EXTMGRPLUS_COUNT'						=> [
+@@ -265,7 +273,6 @@ class ext_mgr_plus
+ 			'EXTMGRPLUS_SWITCH_ORDER_AND_IGNORE'	=> $this->config['extmgrplus_switch_order_and_ignore'],
+ 			'EXTMGRPLUS_SWITCH_SELF_DISABLE'		=> $this->config['extmgrplus_switch_self_disable'],
+ 			'EXTMGRPLUS_SWITCH_INSTRUCTIONS'		=> $this->config['extmgrplus_switch_instructions'],
+-			'EXTMGRPLUS_SWITCH_SETTINGS_LINK'		=> $this->config['extmgrplus_switch_settings_link'],
+ 			'EXTMGRPLUS_SWITCH_MIGRATION_COL'		=> $this->config['extmgrplus_switch_migration_col'],
+ 			'EXTMGRPLUS_SWITCH_MIGRATIONS'			=> $this->config['extmgrplus_switch_migrations'],
+ 		]);
+@@ -277,7 +284,7 @@ class ext_mgr_plus
+ 	*/
+ 	public function change_msg_template(): void
+ 	{
+-		if ($this->template->retrieve_var('EXTMGRPLUS_TRIGGER_ERROR') !== null)
++		if ($this->template->retrieve_var('EXTMGRPLUS_TRIGGER_ERROR'))
+ 		{
+ 			$this->template->set_filenames(['body' => '@lukewcs_extmgrplus/acp_ext_mgr_plus_message_body.html']);
+ 		}
+@@ -327,8 +334,7 @@ class ext_mgr_plus
+ 		{
+ 			$this->template->assign_vars([
+ 				'EXTMGRPLUS_ACTION_MODE'	=> 'DISABLE',
+-				'EXTMGRPLUS_CONFIRM_YES'	=> 'EXTENSION_DISABLE',
+-				'EXTMGRPLUS_CONFIRM_NO'		=> 'CANCEL',
++				'EXTMGRPLUS_SELF_DISABLE'	=> array_search('lukewcs/extmgrplus', $ext_mark_enabled) !== false,
+ 			]);
+ 			if (!$this->config['extmgrplus_switch_confirmation'] || confirm_box(true))
+ 			{
+@@ -343,8 +349,6 @@ class ext_mgr_plus
+ 		{
+ 			$this->template->assign_vars([
+ 				'EXTMGRPLUS_ACTION_MODE'	=> 'ENABLE',
+-				'EXTMGRPLUS_CONFIRM_YES'	=> 'EXTENSION_ENABLE',
+-				'EXTMGRPLUS_CONFIRM_NO'		=> 'CANCEL',
+ 			]);
+ 			if (!$this->config['extmgrplus_switch_confirmation'] || confirm_box(true))
+ 			{
+@@ -393,17 +397,17 @@ class ext_mgr_plus
+ 		{
+ 			try
+ 			{
+-				$ext_meta = $this->ext_manager->create_extension_metadata_manager($ext_name)->get_metadata('all');
++				$ext_metadata = $this->ext_manager->create_extension_metadata_manager($ext_name)->get_metadata('all');
+ 			}
+ 			catch (\RuntimeException $e)
+ 			{
+-				$ext_meta = null;
++				$ext_metadata = null;
+ 			}
+ 
+-			if (is_array($ext_meta))
++			if (is_array($ext_metadata))
+ 			{
+-				$ext_display_name	= $ext_meta['extra']['display-name'] ?? '';
+-				$ext_version		= $ext_meta['version'] ?? '';
++				$ext_display_name	= $ext_metadata['extra']['display-name'] ?? '';
++				$ext_version		= $ext_metadata['version'] ?? '';
+ 
+ 				$disable_error = '';
+ 				if ($this->ext_manager->is_enabled($ext_name))
+@@ -436,7 +440,7 @@ class ext_mgr_plus
+ 				}
+ 			}
+ 
+-			if ($this->safe_time_limit > 0 && (microtime(true) - $GLOBALS['starttime']) >= $this->safe_time_limit)
++			if ((microtime(true) - $GLOBALS['starttime']) >= $this->safe_time_limit)
+ 			{
+ 				$safe_time_exceeded = true;
+ 				break;
+@@ -458,7 +462,7 @@ class ext_mgr_plus
+ 		}
+ 		$this->common->trigger_error_(
+ 			$this->language->lang('EXTMGRPLUS_MSG_DEACTIVATION', $ext_count_success, $ext_count_enabled) . ($msg_failed ?? ''),
+-			$this->get_error_level($ext_count_success, $ext_count_enabled, $safe_time_exceeded),
++			(($ext_count_success != $ext_count_enabled || $safe_time_exceeded) ? E_USER_WARNING : E_USER_NOTICE),
+ 			'RETURN_TO_EXTENSION_LIST'
+ 		);
+ 	}
+@@ -498,17 +502,17 @@ class ext_mgr_plus
+ 		{
+ 			try
+ 			{
+-				$ext_meta = $this->ext_manager->create_extension_metadata_manager($ext_name)->get_metadata('all');
++				$ext_metadata = $this->ext_manager->create_extension_metadata_manager($ext_name)->get_metadata('all');
+ 			}
+ 			catch (\RuntimeException $e)
+ 			{
+-				$ext_meta = null;
++				$ext_metadata = null;
+ 			}
+ 
+-			if (is_array($ext_meta))
++			if (is_array($ext_metadata))
+ 			{
+-				$ext_display_name	= $ext_meta['extra']['display-name'] ?? '';
+-				$ext_version		= $ext_meta['version'] ?? '';
++				$ext_display_name	= $ext_metadata['extra']['display-name'] ?? '';
++				$ext_version		= $ext_metadata['version'] ?? '';
+ 
+ 				if ($this->ext_manager->is_disabled($ext_name))
+ 				{
+@@ -554,7 +558,7 @@ class ext_mgr_plus
+ 				}
+ 			}
+ 
+-			if ($this->safe_time_limit > 0 && (microtime(true) - $GLOBALS['starttime']) >= $this->safe_time_limit)
++			if ((microtime(true) - $GLOBALS['starttime']) >= $this->safe_time_limit)
+ 			{
+ 				$safe_time_exceeded = true;
+ 				break;
+@@ -576,7 +580,7 @@ class ext_mgr_plus
+ 		}
+ 		$this->common->trigger_error_(
+ 			$this->language->lang('EXTMGRPLUS_MSG_ACTIVATION', $ext_count_success, $ext_count_disabled) . ($msg_failed ?? ''),
+-			$this->get_error_level($ext_count_success, $ext_count_disabled, $safe_time_exceeded),
++			(($ext_count_success != $ext_count_disabled || $safe_time_exceeded) ? E_USER_WARNING : E_USER_NOTICE),
+ 			'RETURN_TO_EXTENSION_LIST'
+ 		);
+ 	}
+@@ -588,14 +592,14 @@ class ext_mgr_plus
+ 	{
+ 		$msg_failed = '<br><br>' . $this->language->lang($lang_var);
+ 		$count_failed = 0;
+-		foreach ($ext_list as $ext_name => $vars)
++		foreach ($ext_list as $name => $vars)
+ 		{
+ 			if (is_array($vars['message']))
+ 			{
+ 				$vars['message'] = implode('<br>', $vars['message']);
+ 			}
+ 			$count_failed++;
+-			$msg_failed .= $this->create_failed_msg($count_failed . '. ' . $vars['display_name'], $vars['ext_version'], $ext_name, $vars['message']);
++			$msg_failed .= $this->create_failed_msg($count_failed . '. ' . $vars['display_name'], $vars['ext_version'], $name, $vars['message']);
+ 		}
+ 
+ 		return $msg_failed;
+@@ -606,24 +610,12 @@ class ext_mgr_plus
+ 	*/
+ 	private function create_failed_msg(string $display_name, string $ext_version, string $ext_name, string $message): string
+ 	{
+-		return vsprintf('<br><br><strong>%1$s %2$s (%3$s)</strong>%4$s', [
+-			1	=> $display_name,
+-			2	=> $this->language->lang('EXTMGRPLUS_VERSION_STRING', $ext_version),
+-			3	=> $ext_name,
+-			4	=> empty($message) ? '' : "<br><br><em>{$message}</em>"
+-		]);
+-	}
+-
+-	/*
+-		Helper function for trigger_error
+-	*/
+-	function get_error_level(int $count_success, int $count_total, bool $safe_time_exceeded): int
+-	{
+-		return match (true) {
+-			$count_success == $count_total				=> E_USER_NOTICE,
+-			$count_success == 0, $safe_time_exceeded	=> E_USER_WARNING,
+-			default										=> E_USER_NOTICE + E_USER_ERROR,
+-		};
++		return sprintf('<br><br><strong>%1$s %2$s (%3$s)</strong>%4$s',
++			/* 1 */	$display_name,
++			/* 2 */	$this->language->lang('EXTMGRPLUS_VERSION_STRING', $ext_version),
++			/* 3 */	$ext_name,
++			/* 4 */	empty($message) ? '' : "<br><br><em>{$message}</em>"
++		);
+ 	}
+ 
+ 	/*
+@@ -673,48 +665,6 @@ class ext_mgr_plus
+ 		return count($migration_classes_new);
+ 	}
+ 
+-	/*
+-		Determine all ACP module links of the active extensions
+-	*/
+-	private function get_module_links(): array
+-	{
+-		global $module;
+-
+-		$module_urls = [];
+-		$module_tabs = [];
+-
+-		$modules = array_combine(array_column($module->module_ary, 'id'), $module->module_ary);
+-		$get_module_top_cat = function (int $module_id) use ($modules): string
+-		{
+-			$parent_id = $modules[$module_id]['parent'];
+-			while ($parent_id !== 0)
+-			{
+-				$module_id = $parent_id;
+-				$parent_id = $modules[$module_id]['parent'];
+-			}
+-
+-			return $modules[$module_id]['langname'];
+-		};
+-
+-		foreach (array_filter($modules, fn($row): bool => $row['name'] !== '' && $row['display']) as $module_row)
+-		{
+-			preg_match('/\\\\(.+?)\\\\(.+?)\\\\.*/', $module_row['name'], $matches);
+-			$tech_name = (count($matches) === 3) ? $matches[1] . '/' . $matches[2] : false;
+-			if ($tech_name !== false)
+-			{
+-				$module_tab = $get_module_top_cat($module_row['parent']);
+-				if (!isset($module_urls[$tech_name]) || ($module_tab === 'ACP_CAT_DOT_MODS' && $module_tabs[$tech_name] !== $module_tab))
+-				{
+-					$module_name = str_replace('\\', '-', $module_row['name']);
+-					$module_urls[$tech_name] = append_sid("{$this->phpbb_admin_path}index.{$this->php_ext}", "i={$module_name}&amp;mode={$module_row['mode']}");
+-					$module_tabs[$tech_name] = $module_tab;
+-				}
+-			}
+-		}
+-
+-		return $module_urls;
+-	}
+-
+ 	/*
+ 		Check if file is a valid migration file
+ 	*/
+@@ -726,14 +676,17 @@ class ext_mgr_plus
+ 			$file_content = file_get_contents($file);
+ 			if ($file_content !== false)
+ 			{
+-				return (
+-					preg_match('/function\s+?(?:depends_on|effectively_installed|update_schema|update_data|revert_data)\s*?\(/', $file_content)
+-					&& preg_match('/^\s*?class\s+?' . $file_info['filename'] . '\s+/mi', $file_content)
+-				) ? 1 : 0;
++				$check_migration = ((
++						preg_match('/function\s+?(?:depends_on|effectively_installed|update_schema|update_data|revert_data)\s*?\(/', $file_content)
++						&& preg_match('/^\s*?class\s+?' . $file_info['filename'] . '\s+/mi', $file_content)
++					)
++					? 1
++					: 0
++				);
+ 			}
+ 		}
+ 
+-		return -1;
++		return ($check_migration ?? -1);
+ 	}
+ 
+ 	/*
+@@ -757,7 +710,7 @@ class ext_mgr_plus
+ 	/*
+ 		Preparation to be able to run a version check in blocks
+ 	*/
+-	private function versioncheck_prepare(array|null &$ext_list_vc): void
++	private function versioncheck_prepare(?array &$ext_list_vc): void
+ 	{
+ 		$ext_list_all	= $this->ext_manager->all_available();
+ 		$ext_list_vc	= [
+@@ -778,7 +731,6 @@ class ext_mgr_plus
+ 			}
+ 			catch (\RuntimeException $e)
+ 			{
+-				$vc_meta = null;
+ 			}
+ 
+ 			if (isset($vc_meta))
+@@ -789,7 +741,6 @@ class ext_mgr_plus
+ 				$this->cache->destroy(str_replace(['/', '\\'], '-', $cache_filename));
+ 			}
+ 		}
+-
+ 		$ext_list_vc['data']['count_total']	= count($ext_list_vc) - 1;
+ 		$this->common->config_text_set('extmgrplus_list_version_check', 'updates', $ext_list_vc);
+ 	}
+@@ -851,8 +802,8 @@ class ext_mgr_plus
+ 
+ 		try
+ 		{
+-			$ext_meta = $md_manager->get_metadata('all');
+-			if (isset($ext_meta['extra']['version-check']))
++			$ext_metadata = $md_manager->get_metadata('all');
++			if (isset($ext_metadata['extra']['version-check']))
+ 			{
+ 				$vc_data = $this->ext_manager->version_check($md_manager, !$read_cache, $read_cache, $this->config['extension_force_unstable'] ? 'unstable' : null);
+ 				$vc_current = empty($vc_data) ? 'NOUPD' : $vc_data['current'];
+@@ -875,7 +826,7 @@ class ext_mgr_plus
+ 	/*
+ 		Reads the version check data from the database and removes obsolete entries and generates a list for the template
+ 	*/
+-	private function versioncheck_list(array &$ext_list, array|null &$ext_list_vc): array
++	private function versioncheck_list(array &$ext_list, ?array &$ext_list_vc): array
+ 	{
+ 		$ext_list_vc ??= [];
+ 
+@@ -892,17 +843,10 @@ class ext_mgr_plus
+ 			}
+ 			if ($this->ext_manager->is_available($ext_name))
+ 			{
+-				try
+-				{
+-					$ext_meta = $this->ext_manager->create_extension_metadata_manager($ext_name)->get_metadata('all');
+-				}
+-				catch (\RuntimeException $e)
+-				{
+-					$ext_meta = null;
+-				}
++				$ext_metadata = $this->ext_manager->create_extension_metadata_manager($ext_name)->get_metadata('all');
+ 
+ 				$no_ver_flags = $vc_data['current'] == 'NOUPD' || $vc_data['current'] == 'ERROR' || $vc_data['current'] == '';
+-				$has_update = !$no_ver_flags && phpbb_version_compare($ext_meta['version'] ?? '0.0.0', $vc_data['current'], '<');
++				$has_update = !$no_ver_flags && phpbb_version_compare($ext_metadata['version'], $vc_data['current'], '<');
+ 				if ($no_ver_flags || $has_update)
+ 				{
+ 					$ext_list_tpl[$ext_name]['current'] = $vc_data['current'];
+@@ -943,19 +887,15 @@ class ext_mgr_plus
+ 		{
+ 			try
+ 			{
+-				$ext_meta = $this->ext_manager->create_extension_metadata_manager($ext_name)->get_metadata('all');
++				$ext_metadata = $this->ext_manager->create_extension_metadata_manager($ext_name)->get_metadata('all');
+ 			}
+ 			catch (\RuntimeException $e)
+ 			{
+-				$ext_meta = null;
+ 			}
+ 
+-			if (isset($ext_meta['extra']['version-check']))
++			if (isset($ext_metadata['extra']['version-check']))
+ 			{
+-				if (($ext_meta['extra']['version-check']['host'] ?? '') == 'www.phpbb.com')
+-				{
+-					$ext_list_tpl[$ext_name]['cdb_ext']	= substr($ext_meta['name'], 0, 6) == 'phpbb/' ? self::CDB_EXT_OFFICIAL : self::CDB_EXT;
+-				}
++				$ext_list_tpl[$ext_name]['cdb_ext']	= ($ext_metadata['extra']['version-check']['host'] ?? '') == 'www.phpbb.com';
+ 				$count_total++;
+ 			}
+ 			else
+@@ -980,16 +920,13 @@ class ext_mgr_plus
+ 	*/
+ 	private function extend_details(string $ext_name): void
+ 	{
+-		$ext_meta	= $this->ext_manager->create_extension_metadata_manager($ext_name)->get_metadata('all');
+-		$vc_meta	= $ext_meta['extra']['version-check'] ?? null;
+-		$details	= [];
+-
++		$vc_meta = $this->ext_manager->create_extension_metadata_manager($ext_name)->get_metadata('all')['extra']['version-check'] ?? null;
++		$details = [];
+ 		if (isset($vc_meta))
+ 		{
+ 			if (($vc_meta['host'] ?? '') == 'www.phpbb.com')
+ 			{
+-				$details['cdb_page']	= 'https://www.phpbb.com' . $vc_meta['directory'] . '/';
+-				$details['cdb_ext']		= substr($ext_meta['name'], 0, 6) == 'phpbb/' ? self::CDB_EXT_OFFICIAL : self::CDB_EXT;
++				$details['cdb_page'] = 'https://www.phpbb.com' . $vc_meta['directory'] . '/';
+ 			}
+ 			if ($this->config['extmgrplus_switch_version_url'])
+ 			{
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/core/ext_mgr_plus_common.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/core/ext_mgr_plus_common.php"
+index ebb95000f..f56977333 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/core/ext_mgr_plus_common.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/core/ext_mgr_plus_common.php"
+@@ -15,18 +15,30 @@ namespace lukewcs\extmgrplus\core;
+ 
+ class ext_mgr_plus_common
+ {
+-	protected array $metadata;
+-	public string $u_action;
++	protected object $config;
++	protected object $config_text;
++	protected object $language;
++	protected object $template;
++	protected object $ext_manager;
++
++	protected array  $metadata;
++	public    string $u_action;
+ 
+ 	public function __construct(
+-		protected \phpbb\config\config $config,
+-		protected \phpbb\config\db_text $config_text,
+-		protected \phpbb\language\language $language,
+-		protected \phpbb\template\template $template,
+-		protected \phpbb\extension\manager $ext_manager,
++		\phpbb\config\config $config,
++		\phpbb\config\db_text $config_text,
++		\phpbb\language\language $language,
++		\phpbb\template\template $template,
++		\phpbb\extension\manager $ext_manager
+ 	)
+ 	{
+-		$this->metadata = $this->ext_manager->create_extension_metadata_manager('lukewcs/extmgrplus')->get_metadata('all');
++		$this->config		= $config;
++		$this->config_text	= $config_text;
++		$this->language		= $language;
++		$this->template		= $template;
++		$this->ext_manager	= $ext_manager;
++
++		$this->metadata		= $this->ext_manager->create_extension_metadata_manager('lukewcs/extmgrplus')->get_metadata('all');
+ 	}
+ 
+ 	public function set_meta_template_vars(string $tpl_prefix, string $copyright): void
+@@ -70,7 +82,7 @@ class ext_mgr_plus_common
+ 			{
+ 				$lang_outdated_msg = $this->language->lang($lang_outdated_var);
+ 			}
+-			else /* Fallback if the current language package does not yet have the required variable. */
++			else // Fallback if the current language package does not yet have the required variable.
+ 			{
+ 				$lang_outdated_msg = 'Note: The language pack for the extension <strong>%1$s</strong> is no longer up-to-date. (installed: %2$s / needed: %3$s)';
+ 			}
+@@ -83,7 +95,7 @@ class ext_mgr_plus_common
+ 	/*
+ 		Set a variable/array in a config_text variable container or delete one or all variables/arrays
+ 	*/
+-	public function config_text_set(string $container, string|null $name, $value): void
++	public function config_text_set(string $container, ?string $name, $value): void
+ 	{
+ 		if ($this->config_text->get($container) === null)
+ 		{
+@@ -113,7 +125,7 @@ class ext_mgr_plus_common
+ 	/*
+ 		Get a variable/array from a config_text variable container
+ 	*/
+-	public function config_text_get(string $container, string|null $name = null)
++	public function config_text_get(string $container, ?string $name = null)
+ 	{
+ 		$config_text = $this->config_text->get($container);
+ 		if ($config_text === null)
+@@ -146,30 +158,23 @@ class ext_mgr_plus_common
+ 	/*
+ 		Wrapper for trigger_error
+ 	*/
+-	public function trigger_error_(string $message, int $error_level, string|null $back_link_lang_var = null): void
++	public function trigger_error_(string $message, int $error_type, ?string $back_link_lang_var = null): void
+ 	{
+-		if ($error_level == E_USER_NOTICE && $this->config['extmgrplus_switch_auto_redirect'])
++		if ($error_type == E_USER_NOTICE && $this->config['extmgrplus_switch_auto_redirect'])
+ 		{
+ 			meta_refresh(1, $this->rotate_get_params($this->u_action));
+ 			$this->template->assign_var('EXTMGRPLUS_AUTO_REDIRECT', true);
+ 		}
+-
+-		$error_type = [
+-			E_USER_NOTICE					=> 0, // green box
+-			E_USER_WARNING					=> 1, // red box
+-			E_USER_NOTICE + E_USER_WARNING	=> 2, // orange box
+-			E_USER_NOTICE + E_USER_ERROR	=> 3, // green+red box
+-		][$error_level]						?? 2;
+-		$this->template->assign_var('EXTMGRPLUS_TRIGGER_ERROR', $error_type);
+-		trigger_error($message . $this->back_link($back_link_lang_var), ($error_type > 1) ? E_USER_WARNING : $error_level);
++		$this->template->assign_var('EXTMGRPLUS_TRIGGER_ERROR', true);
++		trigger_error($message . $this->back_link($back_link_lang_var), $error_type);
+ 	}
+ 
+-	public function back_link(string|null $lang_var = null): string
++	public function back_link(?string $lang_var = null): string
+ 	{
+-		return vsprintf('<br><br><a href="%1$s">%2$s</a>', [
+-			1	=> $this->u_action,
+-			2	=> $this->language->lang($lang_var ?? 'BACK_TO_PREV')
+-		]);
++		return sprintf('<br><br><a href="%1$s">%2$s</a>',
++			/* 1 */ $this->u_action,
++			/* 2 */ $this->language->lang($lang_var ?? 'BACK_TO_PREV')
++		);
+ 	}
+ 
+ 	/*
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/diff_full.tmp"
+new file mode 100644
+index 000000000..e2eaac475
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/diff_full.tmp"
+@@ -0,0 +1,2172 @@
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/acp/settings_module.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/acp/settings_module.php"
++index b9c7958c3..f0be963f2 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/acp/settings_module.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/acp/settings_module.php"
++@@ -15,9 +15,9 @@ namespace lukewcs\extmgrplus\acp;
++ 
++ class settings_module
++ {
++-	public string $page_title;
++-	public string $tpl_name;
++-	public string $u_action;
+++	public $page_title;
+++	public $tpl_name;
+++	public $u_action;
++ 
++ 	public function main()
++ 	{
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus.css" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus.css"
++index d5f7a1824..c632316bb 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus.css"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus.css"
++@@ -1,7 +1,33 @@
++-/* GENERAL >>> */
+++/* GENERAL */
++ 
++-button[type="submit"]:is([name="confirm"], [name="cancel"]),
++-input:is([type="submit"], [type="button"], [type="reset"])[name^="extmgrplus_"] {
+++fieldset {
+++	border-radius: 5px;
+++}
+++
+++fieldset p.submit-buttons {
+++	margin-top: 0;
+++	padding: 0 4px 4px 4px;
+++}
+++
+++fieldset dt label,
+++fieldset dd label {
+++	cursor: inherit;
+++}
+++
+++legend {
+++	background: inherit;
+++	margin: 2px 0 0 -11px;
+++	border-top: inherit;
+++	border-left: inherit;
+++	border-radius: 5px 5px 0 0;
+++	padding: 2px 10px;
+++	top: 0;
+++}
+++
+++input[type="submit"][name="confirm"],
+++input[type="submit"][name^="extmgrplus_"],
+++input[type="button"][name^="extmgrplus_"],
+++input[type="reset"][name^="extmgrplus_"] {
++ 	padding: 3px 4px;
++ }
++ 
++@@ -11,31 +37,11 @@ code {
++ 	color: black;
++ }
++ 
++-.emp_inactive {
+++.inactive {
++ 	opacity: 0.5;
++ }
++ 
++-.emp_unavailable {
++-	opacity: 0.3;
++-}
++-
++-.errorbox {
++-	&.emp_warning {
++-		background-color: #ffaa00;
++-
++-		& :is(a, a:visited) {
++-			color: #505050;
++-		}
++-
++-		& :is(h3, p, a:hover) {
++-			color: #303030;
++-		}
++-	}
++-
++-	&.emp_success_error {
++-		background: linear-gradient(#228822, #bc2a4d);
++-	}
++-}
+++/* Footer */
++ 
++ .extmgrplus_footer {
++ 	margin-top: 1em;
++@@ -43,192 +49,137 @@ code {
++ 	font-size: 0.75em;
++ }
++ 
++-#confirm {
++-	/* confirm_box (phpBB) */
++-
++-	& h2 {
++-		margin-bottom: 0.25em;
++-	}
++-
++-	& :is(.button1, .button2) {
++-		color: #000000;
++-		background: linear-gradient(to bottom, #d2d2d2 0%, #efefef 100%);
++-		border: 1px solid #666666;
++-		font-size: 0.85em;
++-		font-family: "Lucida Grande", Verdana, Helvetica, Arial, sans-serif;
++-		vertical-align: middle;
++-
++-		&:hover {
++-			border: 1px solid #bc2a4d;
++-			background: #efefef url("../../../../../adm/images/bg_button.gif") repeat bottom;
++-			color: #bc2a4d;
++-		}
++-	}
+++/* confirm_box (phpBB)*/
++ 
++-	& .button1 {
++-		font-weight: bold;
++-	}
+++#confirm h2 {
+++	margin-bottom: 0.25em;
++ }
++ 
++-/* <<< GENERAL */
++-
++-/* SETTINGS >>> */
++-
++-fieldset {
++-	border-radius: 5px;
++-
++-	& p.submit-buttons {
++-		margin-top: 0;
++-		padding: 0 4px 4px 4px;
++-	}
++-
++-	& :is(dt, dd) label {
++-		cursor: inherit;
++-	}
+++/* SETTINGS */
++ 
++-	& dd a {
++-		overflow-wrap: anywhere;
++-	}
+++legend.legend_sub {
+++	border: 0;
+++	margin: 1em 0;
+++	padding: 0;
+++	display: flex;
+++	white-space: nowrap;
++ }
++ 
++-legend {
++-	background: inherit;
++-	margin: 2px 0 0 -11px;
++-	border-top: inherit;
++-	border-left: inherit;
++-	border-radius: 5px 5px 0 0;
++-	padding: 2px 10px;
++-	top: 0;
++-
++-	& + .legend_explain {
++-		width: 45%;
++-	}
++-
++-	&.legend_sub {
++-		border: 0;
++-		margin: 1em 0;
++-		padding: 0;
++-		display: flex;
++-		white-space: nowrap;
++-
++-		&:after {
++-			content: "";
++-			border-bottom: 1px solid #cccccc;
++-			width: 100%;
++-			margin: 0 0 0.5em 1em;
++-		}
++-	}
+++legend.legend_sub:after {
+++	content: "";
+++	border-bottom: 1px solid #cccccc;
+++	width: 100%;
+++	margin: 0 0 0.5em 1em;
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
++-div.lukewcs_confirmbox {
++-	/* LukeWCSphpBBConfirmBox */
+++.toggle:checked:before {
+++	left: 2px;
+++	content: "\f00c";
+++}
+++
+++/* LukeWCSphpBBConfirmBox */
++ 
+++div[id$="_confirmbox"] {
++ 	max-width: 450px;
++ 	border: 2px solid skyblue;
++ 	margin: 0.75em 0.5em;
++ 	padding: 0.25em 0.5em;
++ 	border-radius: 5px;
+++	-webkit-box-shadow: 2px 2px 10px 1px rgba(121, 162, 179, 0.5);
++ 	box-shadow: 2px 2px 10px 1px rgba(121, 162, 179, 0.5);
+++}
++ 
++-	& h2 {
++-		margin: 0 0 0.25em 0;
++-	}
+++div[id$="_confirmbox"] h2 {
+++	margin: 0 0 0.25em 0;
+++}
++ 
++-	& p:last-of-type {
++-		text-align: center;
++-		margin: 0;
++-		padding: 0 4px 4px 4px;
++-	}
+++div[id$="_confirmbox"] p:nth-of-type(2) {
+++	text-align: center;
+++	margin: 0;
+++	padding: 0 4px 4px 4px;
+++}
++ 
++-	& input[type="button"] {
++-		padding: 3px 4px;
++-	}
+++div[id$="_confirmbox"] input[type="button"] {
+++	padding: 3px 4px;
++ }
++ 
++-input:is([type="submit"], [type="button"]):disabled,
++-input.lukewcs_confirmbox_active {
+++input[type="submit"]:disabled,
+++input[type="button"]:disabled,
+++input.confirmbox_active {
++ 	opacity: 0.5;
++ 	cursor: not-allowed;
++ }
++ 
++-/* <<< SETTINGS */
++-
++-/* EXTENSION MANAGER >>> */
+++/* EXTENSION MANAGER */
++ 
++ .js_link {
++ 	color: #105289;
+++}
++ 
++-	&:hover {
++-		color: #bc2a4d;
++-		text-decoration: underline;
++-		cursor: pointer;
++-	}
+++.js_link:hover {
+++	color: #bc2a4d;
+++	text-decoration: underline;
+++	cursor: pointer;
+++}
++ 
++-	&.disabled,
++-	&.disabled:hover {
++-		color: #536482;
++-		text-decoration: none;
++-		cursor: not-allowed;
++-		opacity: 0.5;
++-	}
+++.js_link.disabled,
+++.js_link.disabled:hover {
+++	color: #536482;
+++	text-decoration: none;
+++	cursor: not-allowed;
+++	opacity: 0.5;
++ }
++ 
++-table :is(th, td) i.icon,
++-fieldset dd i.icon {
++-	cursor: help;
+++fieldset.quick a i.icon,
+++.js_link i.icon {
+++	margin: 0 0.3em 0 0;
+++	font-size: 1.1em;
++ }
++ 
++ div.successbox i.icon,
++@@ -241,12 +192,6 @@ div.successbox.notice i.icon {
++ 	font-size: 1.2em;
++ }
++ 
++-fieldset.quick a i.icon,
++-.js_link i.icon {
++-	margin: 0 0.3em 0 0;
++-	font-size: 1.1em;
++-}
++-
++ fieldset.ext_properties i.icon,
++ thead th i.icon {
++ 	font-size: 1.1em;
++@@ -255,109 +200,107 @@ thead th i.icon {
++ 
++ fieldset.ext_properties dd {
++ 	color: inherit;
+++}
++ 
++-	& label {
++-		font-size: inherit;
++-		font-weight: bold;
+++fieldset.ext_properties dd label {
+++	font-size: inherit;
+++	font-weight: bold;
+++}
++ 
++-		&:hover {
++-			color: inherit;
++-		}
++-	}
+++fieldset.ext_properties dd label:hover {
+++	color: inherit;
+++}
++ 
++-	& details {
++-		border: 1px solid #cccccc;
++-		border-radius: 3px;
++-
++-		& summary {
++-			padding: 0.25em 0.5em;
++-			cursor: pointer;
++-			-webkit-user-select: none;
++-			user-select: none;
++-		}
++-
++-		& div {
++-			border-top: 1px solid #cccccc;
++-			font-size: inherit;
++-			padding: 0.25em 0;
++-			margin: 0 0.5em;
++-		}
++-	}
+++fieldset.ext_properties dd details {
+++	border: 1px solid #cccccc;
+++	border-radius: 3px;
++ }
++ 
++-#extmgrplus_list {
++-	& input[type="checkbox"]:disabled {
++-		cursor: not-allowed;
++-	}
+++fieldset.ext_properties dd summary {
+++	padding: 0.25em 0.5em;
+++	cursor: pointer;
+++	-webkit-user-select: none;
+++	-moz-user-select: none;
+++	-ms-user-select: none;
+++}
++ 
++-	& input[name$="able_all"] {
++-		padding: 1px 3px;
++-		font-size: inherit;
++-	}
+++fieldset.ext_properties dd details div {
+++	border-top: 1px solid #cccccc;
+++	font-size: inherit;
+++	padding: 0.25em 0;
+++	margin: 0 0.5em;
+++}
++ 
++-	& input[type="text"] {
++-		text-align: right;
++-		padding: 0 2px;
++-		margin: 0 2px;
++-		background-color: #f9f9f9;
++-	}
+++input[type="checkbox"]:disabled {
+++	cursor: not-allowed;
+++}
++ 
++-	& th:nth-of-type(1) {
++-		width: 1%;
++-	}
+++#extmgrplus_list input[name$="able_all"] {
+++	padding: 1px 5px;
+++}
++ 
++-	& th:nth-of-type(3) {
++-		width: 16%;
++-	}
+++#extmgrplus_list input[type="text"] {
+++	text-align: right;
+++	padding: 0 2px;
+++	margin: 0 2px;
+++	background-color: #f9f9f9;
+++}
++ 
++-	& th:nth-of-type(1n+3) {
++-		text-align: center;
++-	}
+++#extmgrplus_list th:nth-of-type(1) {
+++	width: 1%;
+++}
++ 
++-	& th:nth-of-type(4) {
++-		width: 1%;
++-	}
+++#extmgrplus_list th:nth-of-type(3) {
+++	width: 16%;
+++}
++ 
++-	& th:nth-of-type(5) {
++-		width: 10%;
++-	}
+++#extmgrplus_list th:nth-of-type(1n+3) {
+++	text-align: center;
+++}
++ 
++-	& th:nth-of-type(6) {
++-		width: 25%;
++-	}
+++#extmgrplus_list th:nth-of-type(4) {
+++	width: 1%;
+++}
++ 
++-	& th:nth-of-type(1n+7) {
++-		width: 1%;
++-	}
+++#extmgrplus_list th:nth-of-type(5) {
+++	width: 10%;
+++}
++ 
++-	& td:nth-of-type(3) i.icon {
++-		font-size: 1.2em;
++-	}
+++#extmgrplus_list th:nth-of-type(6) {
+++	width: 25%;
+++}
++ 
++-	& td:nth-of-type(3) :is(span, strong, i.icon) + :is(strong, i.icon) {
++-		margin-left: 0.3em;
++-	}
+++#extmgrplus_list th:nth-of-type(1n+7) {
+++	width: 1%;
+++}
++ 
++-	& td:nth-of-type(3) i.icon:is(.fa-question-circle, .fa-exclamation-triangle) {
++-		color: #df950d;
++-	}
+++#extmgrplus_list td:nth-of-type(1) i.icon {
+++	cursor: help;
+++}
++ 
++-	& td:nth-of-type(1n+3) {
++-		text-align: center;
++-	}
+++#extmgrplus_list td:nth-of-type(3) i.icon {
+++	cursor: help;
+++	font-size: 1.2em;
+++}
++ 
++-	& td:nth-of-type(4) span {
++-		cursor: help;
++-	}
+++#extmgrplus_list td:nth-of-type(3) i.icon:is(.fa-question-circle, .fa-exclamation-triangle, .fa-refresh) {
+++	color: #df950d;
+++}
++ 
++-	& td:nth-of-type(7) i.icon {
++-		font-size: 1.3em;
++-	}
+++#extmgrplus_list td:nth-of-type(1n+3) {
+++	text-align: center;
+++}
+++
+++#extmgrplus_list td:nth-of-type(4) span {
+++	cursor: help;
++ }
++ 
++-/* <<< EXTENSION MANAGER */
+++#extmgrplus_list td:nth-of-type(7) i.icon {
+++	cursor: help;
+++	font-size: 1.3em;
+++}
++ 
++-/* VERSIONCHECK PROGGRESS >>> */
+++/* VERSIONCHECK PROGGRESS */
++ 
++ .progress_container {
++ 	background-color: #f9f9f9;
++@@ -365,28 +308,28 @@ fieldset.ext_properties dd {
++ 	border-radius: 5px;
++ 	position: relative;
++ 	margin: 1em 0 0.25em 0;
+++}
++ 
++-	& .progress_bar {
++-		background-color: lightgreen;
++-		height: 100%;
++-		border-radius: 5px;
++-	}
+++.progress_bar {
+++	background-color: lightgreen;
+++	height: 100%;
+++	border-radius: 5px;
+++}
++ 
++-	& .progress_value {
++-		color: black;
++-		position: absolute;
++-		font-size: 0.85em;
++-		top: 1px;
++-		left: 0;
++-		right: 0;
++-	}
+++.progress_value {
+++	color: black;
+++	position: absolute;
+++	font-size: 0.85em;
+++	top: 1px;
+++	left: 0;
+++	right: 0;
+++}
++ 
++-	& .progress_anim {
++-		background-color: lightblue;
++-		animation-name: progress_anim_block;
++-		animation-timing-function: linear;
++-		animation-fill-mode: forwards;
++-	}
+++.progress_anim {
+++	background-color: lightblue;
+++	animation-name: progress_anim_block;
+++	animation-timing-function: linear;
+++	animation-fill-mode: forwards;
++ }
++ 
++ @keyframes progress_anim_block {
++@@ -399,18 +342,12 @@ fieldset.ext_properties dd {
++ 	}
++ }
++ 
++-/* <<< VERSIONCHECK PROGGRESS */
++-
++-/* RESPONSIVE >>> */
+++/* RESPONSIVE */
++ 
++ @media (max-width: 700px){
++ 	legend {
++ 		margin: 2px 0 0 -6px;
++ 		padding: 2px 5px;
++-
++-		& + .legend_explain {
++-			width: auto;
++-		}
++ 	}
++ 
++ 	#extmgrplus_settings dd {
++@@ -421,5 +358,3 @@ fieldset.ext_properties dd {
++ 		padding: 0.5em 0 0 0;
++ 	}
++ }
++-
++-/* <<< RESPONSIVE */
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_acp_ext_details.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_acp_ext_details.html"
++deleted file mode 100644
++index 830d87306..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_acp_ext_details.html"
+++++ /dev/null
++@@ -1,180 +0,0 @@
++-{#
++-*
++-* Extension Manager Plus. An extension for the phpBB Forum Software package.
++-*
++-* @copyright (c) 2022, LukeWCS, https://www.wcsaga.org
++-* @license GNU General Public License, version 2 (GPL-2.0-only)
++-*
++-* Note: This extension is 100% genuine handcraft and consists of selected
++-*       natural raw materials. There was no AI involved in making it.
++-*
++-#}
++-
++-{% import '@lukewcs_extmgrplus/acp_ext_mgr_plus_macros.html' as common %}
++-
++-{% INCLUDE 'overall_header.html' %}
++-
++-<a href="{{ U_BACK }}" style="float: {{ S_CONTENT_FLOW_END }};">&laquo; {{ lang('BACK') }}</a>
++-
++-<h1>{{ lang('EXTENSIONS_ADMIN') }}</h1>
++-
++-<p>{{ lang('EXTENSIONS_EXPLAIN') }}</p>
++-
++-{% if S_VERSIONCHECK %}
++-	{% if S_VERSIONCHECK_FAIL %}
++-		<div class="errorbox notice">
++-			<p>{{ lang('VERSIONCHECK_FAIL') }}</p>
++-			<p>{{ VERSIONCHECK_FAIL_REASON }}</p>
++-			<p><a href="{{ U_VERSIONCHECK_FORCE }}">{{ lang('VERSIONCHECK_FORCE_UPDATE') }}</a></p>
++-		</div>
++-	{% else %}
++-		<div class="{% if S_UP_TO_DATE %}successbox{% else %}errorbox{% endif %}">
++-			<p>{{ UP_TO_DATE_MSG }} - <a href="{{ U_VERSIONCHECK_FORCE }}">{{ lang('VERSIONCHECK_FORCE_UPDATE') }}</a></p>
++-		</div>
++-	{% endif %}
++-{% endif %}
++-
++-{% EVENT acp_ext_details_notice %}
++-
++-<fieldset>
++-	<legend>{{ lang('EXT_DETAILS') }}</legend>
++-
++-	{% if META_DISPLAY_NAME %}
++-		<dl>
++-			<dt><label>{{ lang('DISPLAY_NAME') ~ lang('COLON') }}</label></dt>
++-			<dd>
++-				{{ EXTMGRPLUS_DETAILS.cdb_ext ? {
++-					1:	common.icon('fa-database', 'EXTMGRPLUS_TOOLTIP_CDB_EXT'),
++-					2:	common.icon('fa-star', 'EXTMGRPLUS_TOOLTIP_CDB_EXT_OFFICIAL'),
++-				}[EXTMGRPLUS_DETAILS.cdb_ext] }}
++-				<strong id="meta_display_name">{{ META_DISPLAY_NAME }}</strong>
++-			</dd>
++-		</dl>
++-	{% endif %}
++-	<dl>
++-		<dt><label>{{ lang('CLEAN_NAME') ~ lang('COLON') }}</label></dt>
++-		<dd><strong id="meta_name">{{ META_NAME }}</strong></dd>
++-	</dl>
++-	{% if META_DESCRIPTION %}
++-		<dl>
++-			<dt><label>{{ lang('DESCRIPTION') ~ lang('COLON') }}</label></dt>
++-			<dd><span id="meta_description">{{ META_DESCRIPTION }}</span></dd>
++-		</dl>
++-	{% endif %}
++-	<dl>
++-		<dt><label>{{ lang('VERSION') ~ lang('COLON') }}</label></dt>
++-		<dd><span id="meta_version">{{ META_VERSION }}</span></dd>
++-	</dl>
++-	{% if META_HOMEPAGE && META_HOMEPAGE != EXTMGRPLUS_DETAILS.cdb_page %}
++-		<dl>
++-			<dt><label>{{ lang('HOMEPAGE') ~ lang('COLON') }}</label></dt>
++-			<dd><strong id="meta_homepage"><a href="{{ META_HOMEPAGE }}">{{ META_HOMEPAGE }}</a></strong></dd>
++-		</dl>
++-	{% endif %}
++-	{% if EXTMGRPLUS_DETAILS.cdb_page %}
++-		<dl>
++-			<dt><label>{{ lang('EXTMGRPLUS_DETAILS_CDB_PAGE') ~ lang('COLON') }}</label></dt>
++-			<dd><strong><a href="{{ EXTMGRPLUS_DETAILS.cdb_page }}">{{ EXTMGRPLUS_DETAILS.cdb_page }}</a></strong></dd>
++-		</dl>
++-	{% endif %}
++-	{% if EXTMGRPLUS_DETAILS.version_url %}
++-		<dl>
++-			<dt><label>{{ lang('EXTMGRPLUS_DETAILS_VERSION_URL') ~ lang('COLON') }}</label></dt>
++-			<dd><strong><a href="{{ EXTMGRPLUS_DETAILS.version_url }}">{{ EXTMGRPLUS_DETAILS.version_url }}</a></strong></dd>
++-		</dl>
++-	{% endif %}
++-	{% if META_TIME %}
++-		<dl>
++-			<dt><label>{{ lang('TIME') ~ lang('COLON') }}</label></dt>
++-			<dd><span id="meta_time">{{ META_TIME }}</span></dd>
++-		</dl>
++-	{% endif %}
++-	<dl>
++-		<dt><label>{{ lang('LICENSE') ~ lang('COLON') }}</label></dt>
++-		<dd><span id="meta_license">{{ META_LICENSE }}</span></dd>
++-	</dl>
++-</fieldset>
++-
++-{% if S_VERSIONCHECK && !S_UP_TO_DATE %}
++-	<fieldset>
++-		<legend>{{ lang('LATEST_VERSION') }}</legend>
++-
++-		{% for updates_available in loops.updates_available %}
++-			<fieldset>
++-				<dl>
++-					<dt><label>{{ lang('VERSION') ~ lang('COLON') }}</label></dt>
++-					<dd><strong>{{ updates_available.current }}</strong></dd>
++-				</dl>
++-				{% if updates_available.download %}
++-					<dl>
++-						<dt><label>{{ lang('DOWNLOAD_LATEST') }}</label></dt>
++-						<dd><strong><a href="{{ updates_available.download }}">{{ lang('DOWNLOAD') }} {{ META_NAME }} {{ LATEST_VERSION }}</a></strong></dd>
++-					</dl>
++-				{% endif %}
++-				{% if updates_available.announcement %}
++-					<dl>
++-						<dt><label>{{ lang('ANNOUNCEMENT_TOPIC') }}</label></dt>
++-						<dd><strong><a href="{{ updates_available.announcement }}">{{ lang('RELEASE_ANNOUNCEMENT') }}</a></strong></dd>
++-					</dl>
++-				{% endif %}
++-			</fieldset>
++-		{% endfor %}
++-	</fieldset>
++-{% endif %}
++-
++-{% if META_REQUIRE_PHPBB || META_REQUIRE_PHP %}
++-	<fieldset>
++-		<legend>{{ lang('REQUIREMENTS') }}</legend>
++-
++-		{% if META_REQUIRE_PHPBB %}
++-			<dl{% if META_REQUIRE_PHPBB_FAIL %} class="requirements_not_met"{% endif %}>
++-				<dt><label>{{ lang('PHPBB_VERSION') ~ lang('COLON') }}</label></dt>
++-				<dd><span id="require_phpbb">{{ META_REQUIRE_PHPBB }}</span></dd>
++-			</dl>
++-		{% endif %}
++-		{% if META_REQUIRE_PHP %}
++-			<dl{% if META_REQUIRE_PHP_FAIL %} class="requirements_not_met"{% endif %}>
++-				<dt><label>{{ lang('PHP_VERSION') ~ lang('COLON') }}</label></dt>
++-				<dd><span id="require_php">{{ META_REQUIRE_PHP }}</span></dd>
++-			</dl>
++-		{% endif %}
++-	</fieldset>
++-{% endif %}
++-
++-<fieldset>
++-	<legend>{{ lang('AUTHOR_INFORMATION') }}</legend>
++-
++-	{% for meta_authors in loops.meta_authors %}
++-		<fieldset>
++-			<dl>
++-				<dt><label>{{ lang('AUTHOR_NAME') ~ lang('COLON') }}</label></dt>
++-				<dd><strong>{{ meta_authors.AUTHOR_NAME }}</strong></dd>
++-			</dl>
++-			{% if meta_authors.AUTHOR_EMAIL %}
++-				<dl>
++-					<dt><label>{{ lang('AUTHOR_EMAIL') ~ lang('COLON') }}</label></dt>
++-					<dd><strong><a href="mailto:{{ meta_authors.AUTHOR_EMAIL }}">{{ meta_authors.AUTHOR_EMAIL }}</a></strong></dd>
++-				</dl>
++-			{% endif %}
++-			{% if meta_authors.AUTHOR_HOMEPAGE %}
++-				<dl>
++-					<dt><label>{{ lang('AUTHOR_HOMEPAGE') ~ lang('COLON') }}</label></dt>
++-					<dd><strong><a href="{{ meta_authors.AUTHOR_HOMEPAGE }}">{{ meta_authors.AUTHOR_HOMEPAGE }}</a></strong></dd>
++-				</dl>
++-			{% endif %}
++-			{% if meta_authors.AUTHOR_ROLE %}
++-				<dl>
++-					<dt><label>{{ lang('AUTHOR_ROLE') ~ lang('COLON') }}</label></dt>
++-					<dd><strong>{{ meta_authors.AUTHOR_ROLE }}</strong></dd>
++-				</dl>
++-			{% endif %}
++-		</fieldset>
++-	{% endfor %}
++-</fieldset>
++-
++-{% EVENT acp_ext_details_end %}
++-
++-{{ common.footer(EXTMGRPLUS_METADATA) }}
++-
++-{% INCLUDE 'overall_footer.html' %}
++-{% INCLUDECSS '@lukewcs_extmgrplus/acp_ext_mgr_plus.css' %}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_acp_ext_list.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_acp_ext_list.html"
++index ff8f88ca8..14224a0d1 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_acp_ext_list.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_acp_ext_list.html"
++@@ -25,6 +25,8 @@
++ 	CHECKBOX_LAST	: 2,
++ } %}
++ 
+++<a id="maincontent"></a>
+++
++ <h1>{{ lang('EXTENSIONS_ADMIN') }}</h1>
++ 
++ <p>{{ lang('EXTENSIONS_EXPLAIN') }}</p>
++@@ -88,7 +90,7 @@
++ 		<fieldset class="ext_properties" style="display: none;">
++ 			<legend>{{ lang('EXTMGRPLUS_SECTION_SETTINGS') }}</legend>
++ 
++-			<dl{{ !EXTMGRPLUS_SWITCH_ORDER_AND_IGNORE ? ' class="emp_inactive"' }}>
+++			<dl{{ !EXTMGRPLUS_SWITCH_ORDER_AND_IGNORE ? ' class="inactive"' }}>
++ 				<dt>
++ 					<label>{{ lang('EXTMGRPLUS_ORDER', common.icon('fa-sort')) ~ lang('COLON') }}</label><br>
++ 				</dt>
++@@ -104,7 +106,7 @@
++ 				</dd>
++ 			</dl>
++ 
++-			<dl{{ !EXTMGRPLUS_SWITCH_ORDER_AND_IGNORE ? ' class="emp_inactive"' }}>
+++			<dl{{ !EXTMGRPLUS_SWITCH_ORDER_AND_IGNORE ? ' class="inactive"' }}>
++ 				<dt>
++ 					<label>{{ lang('EXTMGRPLUS_IGNORE', common.icon('fa-ban')) ~ lang('COLON') }}</label><br>
++ 				</dt>
++@@ -136,8 +138,8 @@
++ 		</colgroup>
++ 		<thead>
++ 			<tr>
++-				<th>
++-					{{ common.icon('fa-database', 'EXTMGRPLUS_COL_CDB') }}<span style="display: none;">{{ lang('EXTMGRPLUS_COL_CDB') }}</span>
+++				<th title="{{ lang('EXTMGRPLUS_COL_CDB') }}">
+++					{{ common.icon('fa-database') }}<span style="display: none;">{{ lang('EXTMGRPLUS_COL_CDB') }}</span>
++ 				</th>
++ 				<th>
++ 					{{ lang('EXTENSION_NAME') }}
++@@ -145,8 +147,8 @@
++ 				<th>
++ 					{{ lang('CURRENT_VERSION') }}
++ 				</th>
++-				<th{{ !EXTMGRPLUS_SWITCH_MIGRATION_COL ? ' style="display: none;"' }}>
++-					{{ common.icon('fa-arrow-up', 'EXTMGRPLUS_COL_MIGRATIONS') }}<span style="display: none;">{{ lang('EXTMGRPLUS_COL_MIGRATIONS') }}</span>
+++				<th{{ !EXTMGRPLUS_SWITCH_MIGRATION_COL ? ' style="display: none;"' }} title="{{ lang('EXTMGRPLUS_COL_MIGRATIONS') }}">
+++					{{ common.icon('fa-arrow-up') }}<span style="display: none;">{{ lang('EXTMGRPLUS_COL_MIGRATIONS') }}</span>
++ 				</th>
++ 				<th>
++ 					{{ lang('EXTENSION_OPTIONS') }}
++@@ -154,14 +156,14 @@
++ 				<th>
++ 					{{ lang('EXTENSION_ACTIONS') }}
++ 				</th>
++-				<th>
++-					{{ common.icon('fa-check', 'EXTMGRPLUS_COL_SELECT') }}<span style="display: none;">{{ lang('EXTMGRPLUS_COL_SELECT') }}</span>
+++				<th title="{{ lang('EXTMGRPLUS_COL_SELECT') }}">
+++					{{ common.icon('fa-check') }}<span style="display: none;">{{ lang('EXTMGRPLUS_COL_SELECT') }}</span>
++ 				</th>
++-				<th style="display: none;">
++-					{{ common.icon('fa-sort', 'EXTMGRPLUS_COL_ORDER') }}<span style="display: none;">{{ lang('EXTMGRPLUS_COL_ORDER') }}</span>
+++				<th title="{{ lang('EXTMGRPLUS_COL_ORDER') }}" style="display: none;">
+++					{{ common.icon('fa-sort') }}<span style="display: none;">{{ lang('EXTMGRPLUS_COL_ORDER') }}</span>
++ 				</th>
++-				<th style="display: none;">
++-					{{ common.icon('fa-ban', 'EXTMGRPLUS_COL_IGNORE') }}<span style="display: none;">{{ lang('EXTMGRPLUS_COL_IGNORE') }}</span>
+++				<th title="{{ lang('EXTMGRPLUS_COL_IGNORE') }}" style="display: none;">
+++					{{ common.icon('fa-ban') }}<span style="display: none;">{{ lang('EXTMGRPLUS_COL_IGNORE') }}</span>
++ 				</th>
++ 			</tr>
++ 		</thead>
++@@ -207,10 +209,11 @@
++ 					{% set vc_obj = EXTMGRPLUS_LIST_VERSIONCHECK[ext.NAME] ?? {} %}
++ 					<tr class="ext_{{ list }} row-highlight">
++ 						<td>
++-							{{ vc_obj.cdb_ext ? {
++-								1:	common.icon('fa-database', 'EXTMGRPLUS_TOOLTIP_CDB_EXT'),
++-								2:	common.icon('fa-star', 'EXTMGRPLUS_TOOLTIP_CDB_EXT_OFFICIAL'),
++-							}[vc_obj.cdb_ext] }}
+++							{% apply spaceless %}
+++							{% if vc_obj.cdb_ext === true %}
+++								<span title="{{ lang('EXTMGRPLUS_TOOLTIP_CDB_EXT')|e('html') }}">{{ common.icon('fa-database') }}</span>
+++							{% endif %}
+++							{% endapply %}
++ 						</td>
++ 						<td>
++ 							{% apply spaceless %}
++@@ -233,14 +236,14 @@
++ 									<strong class="{{ vc_obj.current == 'NOUPD' ? 'current-ext' : 'outdated-ext' }}">{{ ext.META_VERSION }}</strong>
++ 								{% endif %}
++ 								{% if vc_obj.current === false %}
++-									{{ common.icon('fa-chain-broken', 'EXTMGRPLUS_TOOLTIP_NO_VERSIONCHECK') }}
+++									<span title="{{ lang('EXTMGRPLUS_TOOLTIP_NO_VERSIONCHECK')|e('html') }}">&nbsp;{{ common.icon('fa-chain-broken') }}</span>
++ 								{% elseif vc_obj.current == 'ERROR' %}
++-									{{ common.icon('fa-exclamation-triangle', 'EXTMGRPLUS_TOOLTIP_VERSIONCHECK_ERROR') }}
+++									<span title="{{ lang('EXTMGRPLUS_TOOLTIP_VERSIONCHECK_ERROR')|e('html') }}">&nbsp;{{ common.icon('fa-exclamation-triangle') }}</span>
++ 								{% elseif vc_obj.current is empty %}
++-									{{ common.icon('fa-question-circle', 'EXTMGRPLUS_TOOLTIP_VERSIONCHECK_EMPTY') }}
+++									<span title="{{ lang('EXTMGRPLUS_TOOLTIP_VERSIONCHECK_EMPTY')|e('html') }}">&nbsp;{{ common.icon('fa-question-circle') }}</span>
++ 								{% elseif vc_obj.current != 'NOUPD' %}
++-									{{ common.icon('fa-exclamation-circle outdated-ext', 'EXTMGRPLUS_TOOLTIP_OUTDATED') }}
++-									<strong class="current-ext">({{ vc_obj.current }})</strong>
+++									<span title="{{ lang('EXTMGRPLUS_TOOLTIP_OUTDATED')|e('html') }}">&nbsp;{{ common.icon('fa-exclamation-circle outdated-ext') }}</span>
+++									<strong class="current-ext">&nbsp;({{ vc_obj.current }})</strong>
++ 								{% endif %}
++ 							{% endif %}
++ 							{% endapply %}
++@@ -250,7 +253,7 @@
++ 							{% if list != 'enabled' && EXTMGRPLUS_SWITCH_MIGRATION_COL %}
++ 								{% set count = EXTMGRPLUS_LIST_MIGRATIONS[ext.NAME] ?? 0 %}
++ 								{% if EXTMGRPLUS_LIST_IGNORE[ext.NAME] is defined %}
++-									{{ common.icon('fa-ban', 'EXTMGRPLUS_TOOLTIP_IS_IGNORED') }}
+++									<span title="{{ lang('EXTMGRPLUS_TOOLTIP_IS_IGNORED')|e('html') }}">{{ common.icon('fa-ban') }}</span>
++ 								{% elseif count %}
++ 									<span title="{{ lang('EXTMGRPLUS_TOOLTIP_HAS_MIGRATION')|e('html') }}">{{ count }}</span>
++ 								{% endif %}
++@@ -270,23 +273,15 @@
++ 								<a href="{{ action.U_ACTION }}"{{ action.L_ACTION_EXPLAIN ? ' title="' ~ action.L_ACTION_EXPLAIN ~ '"' }}>{{ action.L_ACTION }}</a>
++ 								{{ !loop.last ? '<span>&nbsp;|&nbsp;</span>' }}
++ 							{% endfor %}
++-							{% if list == 'enabled' && EXTMGRPLUS_SWITCH_SETTINGS_LINK %}
++-								<span>&nbsp;|&nbsp;</span>
++-								{% if EXTMGRPLUS_LIST_MODULES[ext.NAME] is defined %}
++-									<a href="{{ EXTMGRPLUS_LIST_MODULES[ext.NAME] }}" title="{{ lang('EXTMGRPLUS_TOOLTIP_SETTINGS') }}">{{ lang('SETTINGS') }}</a>
++-								{% else %}
++-									<span class="emp_unavailable">{{ lang('SETTINGS') }}</span>
++-								{% endif %}
++-							{% endif %}
++ 							{% endapply %}
++ 						</td>
++ 						<td>
++ 							{% apply spaceless %}
++ 							{% if list != 'not_installed' && ext.NAME is defined && (ext.NAME != 'lukewcs/extmgrplus' || EXTMGRPLUS_SWITCH_SELF_DISABLE) %}
++ 								{% if EXTMGRPLUS_LIST_IGNORE[ext.NAME] is defined %}
++-									{{ common.icon('fa-ban', 'EXTMGRPLUS_TOOLTIP_IS_IGNORED') }}
+++									<span title="{{ lang('EXTMGRPLUS_TOOLTIP_IS_IGNORED')|e('html') }}">{{ common.icon('fa-ban') }}
++ 								{% elseif EXTMGRPLUS_LIST_MIGRATIONS[ext.NAME] is defined && !EXTMGRPLUS_SWITCH_MIGRATIONS %}
++-									<input type="checkbox" class="checkbox" title="{{ lang('EXTMGRPLUS_TOOLTIP_IS_LOCKED')|e('html') }}" disabled>
+++									<input type="checkbox" name="ext_mark_{{ list }}[]" class="checkbox" title="{{ lang('EXTMGRPLUS_TOOLTIP_IS_LOCKED')|e('html') }}" disabled>
++ 								{% else %}
++ 									<input type="checkbox" name="ext_mark_{{ list }}[]" class="checkbox" title="{{ lang('EXTMGRPLUS_TOOLTIP_SELECT')|e('html') }}" value="{{ ext.NAME }}"{{ EXTMGRPLUS_LIST_SELECTED[ext.NAME] is defined ? ' checked' }}>
++ 								{% endif %}
++@@ -296,7 +291,7 @@
++ 						<td style="display: none;">
++ 							{% apply spaceless %}
++ 							{% if ext.NAME is defined && ext.NAME != 'lukewcs/extmgrplus' && EXTMGRPLUS_SWITCH_ORDER_AND_IGNORE %}
++-								<input type="text" name="ext_order[{{ ext.NAME }}]" size="2" maxlength="3"{{ EXTMGRPLUS_LIST_IGNORE[ext.NAME] is defined ? ' class="emp_inactive"' }} title="{{ lang('EXTMGRPLUS_TOOLTIP_ORDER')|e('html') }}" value="{{ EXTMGRPLUS_LIST_ORDER[ext.NAME] ?? '' }}" pattern="^\+?[0-9]{1,2}$">
+++								<input type="text" name="ext_order[{{ ext.NAME }}]" size="2" maxlength="3"{{ EXTMGRPLUS_LIST_IGNORE[ext.NAME] is defined ? ' class="inactive"' }} title="{{ lang('EXTMGRPLUS_TOOLTIP_ORDER')|e('html') }}" value="{{ EXTMGRPLUS_LIST_ORDER[ext.NAME] ?? '' }}" pattern="^\+?[0-9]{1,2}$">
++ 							{% endif %}
++ 							{% endapply %}
++ 						</td>
++@@ -363,7 +358,7 @@
++ 		</fieldset>
++ 	{% elseif type == 'save_checkboxes' %}
++ 		<input type="submit" name="extmgrplus_save_checkboxes" value="save_checkboxes" hidden>
++-	{% elseif type ends with 'able_all' %}
+++	{% elseif type == 'disable_all' || type == 'enable_all'%}
++ 		{% set type_upper = type|upper %}
++ 		<input type="submit" name="extmgrplus_{{ type }}" class="button1" title="{{ lang('EXTMGRPLUS_TOOLTIP_' ~ type_upper)|e('html') }}" value="{{ lang('EXTMGRPLUS_' ~ type_upper) }}"{{ !enabled ? ' disabled' }}>
++ 	{% endif %}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_acp_ext_list.js" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_acp_ext_list.js"
++index a392d1064..9d39732ed 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_acp_ext_list.js"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_acp_ext_list.js"
++@@ -97,7 +97,7 @@ function setButtonState(e) {
++ };
++ 
++ function setInputBoxState(e) {
++-	$('input[name="ext_order[' + e.currentTarget.value + ']"]').toggleClass('emp_inactive', e.currentTarget.checked);
+++	$('input[name="ext_order[' + e.currentTarget.value + ']"]').toggleClass('inactive', e.currentTarget.checked);
++ };
++ 
++ /*
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_confirm_body.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_confirm_body.html"
++index b03d4b2b8..2dae27c43 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_confirm_body.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_confirm_body.html"
++@@ -18,9 +18,7 @@
++ 
++ <p>{{ lang('EXTENSIONS_EXPLAIN') }}</p>
++ 
++-{% if EXTMGRPLUS_ACTION_MODE -%}
++-	<p>{{ lang('EXTENSION_' ~ EXTMGRPLUS_ACTION_MODE ~ '_EXPLAIN') }}</p>
++-{%- endif %}
+++<p>{{ lang('EXTENSION_' ~ EXTMGRPLUS_ACTION_MODE ~ '_EXPLAIN') }}</p>
++ 
++ <form id="confirm" method="post" action="{{ S_CONFIRM_ACTION }}">
++ 	<fieldset>
++@@ -28,15 +26,15 @@
++ 
++ 		<p>{{ MESSAGE_TEXT }}</p>
++ 
++-		{% if EXTMGRPLUS_ACTION_MODE == 'DISABLE' && 'lukewcs/extmgrplus' in S_HIDDEN_FIELDS -%}
+++		{% if EXTMGRPLUS_SELF_DISABLE %}
++ 			<p>{{ lang('EXTMGRPLUS_MSG_SELF_DISABLE') }}</p>
++-		{%- endif %}
+++		{% endif %}
++ 
++ 		{{ S_HIDDEN_FIELDS }}
++ 
++ 		<fieldset class="submit-buttons">
++-			<button type="submit" name="confirm" value="{{ lang('YES') }}" class="button1">{{ lang(EXTMGRPLUS_CONFIRM_YES ?? 'YES') }}</button>
++-			<button type="submit" name="cancel" value="{{ lang('NO') }}" class="button2">{{ lang(EXTMGRPLUS_CONFIRM_NO ?? 'NO') }}</button>
+++			<input type="submit" name="confirm" value="{{ lang('YES') }}" class="button1">&nbsp;
+++			<input type="submit" name="cancel" value="{{ lang('NO') }}" class="button2">
++ 		</fieldset>
++ 	</fieldset>
++ 
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_macros.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_macros.html"
++index bccefff61..d8a2dc1cb 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_macros.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_macros.html"
++@@ -20,19 +20,16 @@
++ 	{% endif %}
++ {% endmacro %}
++ 
++-{% macro icon(classes, title = null, decorative = true) -%}
++-	<i class="icon {{ classes }}"{{
++-		(title != null ? ' title="' ~ lang(title)|e('html') ~ '"') ~
++-		(decorative ? ' aria-hidden="true"')
++-	}}></i>
+++{% macro icon(classes, decorative = true) -%}
+++	<i class="icon {{ classes }}"{{ decorative ? ' aria-hidden="true"' }}></i>
++ {%- endmacro %}
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
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_message_body.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_message_body.html"
++index ff0ba456a..857363870 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_message_body.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_message_body.html"
++@@ -22,7 +22,7 @@
++ 	<p>{{ lang('EXTENSION_' ~ EXTMGRPLUS_ACTION_MODE ~ '_EXPLAIN') }}</p>
++ {%- endif %}
++ 
++-<div class="{{ {0: 'successbox', 1: 'errorbox', 2: 'errorbox emp_warning', 3: 'errorbox emp_success_error'}[EXTMGRPLUS_TRIGGER_ERROR] }}">
+++<div class="{{ S_USER_NOTICE ? 'successbox' : 'errorbox' }}">
++ 	<h3>{{ MESSAGE_TITLE }}</h3>
++ 
++ 	<p>{{ MESSAGE_TEXT }}</p>
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_settings.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_settings.html"
++index eb13ee558..421c4a386 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_settings.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_settings.html"
++@@ -16,6 +16,8 @@
++ 
++ {% set switch_type = TOGGLECTRL_TYPE ?? 'toggle' %}
++ 
+++<a id="maincontent"></a>
+++
++ <h1>{{ lang('EXTENSIONS_ADMIN') }}</h1>
++ 
++ <p>{{ lang('EXTENSIONS_EXPLAIN') }}</p>
++@@ -92,22 +94,22 @@
++ 
++ 		<dl>
++ 			<dt>
++-				<label>{{ lang('EXTMGRPLUS_VC_LIMIT') ~ lang('COLON') }}</label><br>
++-				<span>{{ lang('EXTMGRPLUS_VC_LIMIT_EXPLAIN') }}</span>
+++				<label>{{ lang('EXTMGRPLUS_INSTRUCTIONS') ~ lang('COLON') }}</label><br>
+++				<span>{{ lang('EXTMGRPLUS_INSTRUCTIONS_EXPLAIN') }}</span>
++ 			</dt>
++ 			<dd>
++-				{{ _self.number('extmgrplus_number_vc_limit', EXTMGRPLUS_NUMBER_VC_LIMIT, 1, 99) }}
++-				{{ lang('SECONDS') }}
+++				{{ _self.switch('extmgrplus_switch_instructions', EXTMGRPLUS_SWITCH_INSTRUCTIONS, switch_type) }}
++ 			</dd>
++ 		</dl>
++ 
++ 		<dl>
++ 			<dt>
++-				<label>{{ lang('EXTMGRPLUS_SETTING_LINKS') ~ lang('COLON') }}</label><br>
++-				<span>{{ lang('EXTMGRPLUS_SETTING_LINKS_EXPLAIN') }}</span>
+++				<label>{{ lang('EXTMGRPLUS_VC_LIMIT') ~ lang('COLON') }}</label><br>
+++				<span>{{ lang('EXTMGRPLUS_VC_LIMIT_EXPLAIN') }}</span>
++ 			</dt>
++ 			<dd>
++-				{{ _self.switch('extmgrplus_switch_settings_link', EXTMGRPLUS_SWITCH_SETTINGS_LINK, switch_type) }}
+++				{{ _self.number('extmgrplus_number_vc_limit', EXTMGRPLUS_NUMBER_VC_LIMIT, 1, 99) }}
+++				{{ lang('SECONDS') }}
++ 			</dd>
++ 		</dl>
++ 
++@@ -124,17 +126,7 @@
++ 		</dl>
++ 
++ 		<legend class="legend_sub">{{ lang('EXTMGRPLUS_SECTION_EXPERT_SETTINGS') }}</legend>
++-		<p class="legend_explain">{{ lang('EXTMGRPLUS_EXPERT_SETTINGS_EXPLAIN') }}</p>
++-
++-		<dl>
++-			<dt>
++-				<label>{{ lang('EXTMGRPLUS_INSTRUCTIONS') ~ lang('COLON') }}</label><br>
++-				<span>{{ lang('EXTMGRPLUS_INSTRUCTIONS_EXPLAIN') }}</span>
++-			</dt>
++-			<dd>
++-				{{ _self.switch('extmgrplus_switch_instructions', EXTMGRPLUS_SWITCH_INSTRUCTIONS, switch_type) }}
++-			</dd>
++-		</dl>
+++		<p>{{ lang('EXTMGRPLUS_EXPERT_SETTINGS_EXPLAIN') }}</p>
++ 
++ 		<dl>
++ 			<dt>
++@@ -175,7 +167,7 @@
++ 				<span>{{ lang('EXTMGRPLUS_DEFAULTS_EXP') }}</span>
++ 			</dt>
++ 			<dd>
++-				<input type="button" class="button2" name="extmgrplus_defaults" value="{{ lang('EXTMGRPLUS_BUTTON_DEFAULTS') }}">
+++				{{ _self.button('extmgrplus_defaults', 'EXTMGRPLUS_BUTTON_DEFAULTS') }}
++ 			</dd>
++ 		</dl>
++ 	</fieldset>
++@@ -232,13 +224,17 @@
++ 	}}>
++ {%- endmacro %}
++ 
+++{% macro button(name, lang_var) -%}
+++	<input type="button" class="button2" name="{{ name }}" value="{{ lang(lang_var) }}">
+++{%- endmacro %}
+++
++ {% macro confirmbox(name, message, default = false) -%}
++-	<div class="lukewcs_confirmbox" data-name="{{ name }}" data-default="{{ default }}" style="display: none;">
+++	<div id="{{ name }}_confirmbox" data-default="{{ default }}" style="display: none;">
++ 		<h2>{{ lang('CONFIRM') }}</h2>
++ 		<p>{{ message }}</p>
++ 		<p>
++-			<input type="button" class="button1" name="lukewcs_confirmbox_yes" value="{{ lang('YES') }}">&nbsp;
++-			<input type="button" class="button2" name="lukewcs_confirmbox_no" value="{{ lang('NO') }}">
+++			<input type="button" class="button1" name="{{ name }}_confirm_yes" value="{{ lang('YES') }}">&nbsp;
+++			<input type="button" class="button2" name="{{ name }}_confirm_no" value="{{ lang('NO') }}">
++ 		</p>
++ 	</div>
++ {%- endmacro %}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_settings.js" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_settings.js"
++index 38cce605c..146ad6c94 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_settings.js"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_settings.js"
++@@ -11,140 +11,142 @@
++ */
++ 
++ (function ($) {
++-	'use strict';
++-
++-	/*
++-		Classes
++-	*/
++-
++-	class LukeWCSphpBBConfirmBox {
++-		/*
++-		* phpBB ConfirmBox class for checkboxes and yes/no radio buttons - v1.5.1
++-		* @copyright (c) 2023, LukeWCS, https://www.wcsaga.org
++-		* @license GNU General Public License, version 2 (GPL-2.0-only)
++-		*/
++-
++-		constructor(submitSelector, animDuration = 0) {
++-			let _this = this;
++-			this.$submitObject	= $(submitSelector);
++-			this.$formObject	= this.$submitObject.parents('form');
++-			this.animDuration	= animDuration;
++-
++-			this.$formObject.find('div.lukewcs_confirmbox').each(function () {
++-				$('input[name="' + $(this).attr('data-name') + '"]').on('change', _this.#Show);
++-				$(this).find('input[type="button"]')				.on('click'	, _this.#Button);
++-			});
++-			this.$formObject										.on('reset'	, _this.HideAll);
++-		}
++ 
++-		HideAll = () => {
++-			const $elementObject	= this.$formObject.find('input.lukewcs_confirmbox_active');
++-			const $confirmBoxObject	= this.$formObject.find('div.lukewcs_confirmbox');
+++'use strict';
++ 
++-			this.#changeBoxState($elementObject, $confirmBoxObject, false);
++-		}
+++/*
+++	Classes
+++*/
++ 
++-		#Show = (e) => {
++-			const $elementObject	= $('input[name="' + e.target.name + '"]');
++-			const $confirmBoxObject	= $('div.lukewcs_confirmbox[data-name="' + e.target.name + '"]');
+++class LukeWCSphpBBConfirmBox {
+++/*
+++* phpBB ConfirmBox class for checkboxes and yes/no radio buttons - v1.4.3
+++* @copyright (c) 2023, LukeWCS, https://www.wcsaga.org
+++* @license GNU General Public License, version 2 (GPL-2.0-only)
+++*/
+++	constructor(submitSelector, animDuration = 0) {
+++		let _this = this;
+++		this.$submitObject	= $(submitSelector);
+++		this.$formObject	= this.$submitObject.parents('form');
+++		this.animDuration	= animDuration;
+++
+++		this.$formObject.find('div[id$="_confirmbox"]').each(function () {
+++			const elementName = this.id.replace('_confirmbox', '');
+++
+++			$('input[name="' + elementName + '"]')				.on('change'	, _this.#Show);
+++			$('input[name^="' + elementName + '_confirm_"]')	.on('click'		, _this.#Button);
+++		});
+++		this.$formObject										.on('reset'		, _this.HideAll);
+++	}
++ 
++-			if ($elementObject.prop('checked') != $confirmBoxObject.attr('data-default')) {
++-				this.#changeBoxState($elementObject, $confirmBoxObject, true);
++-			}
+++	#Show = (e) => {
+++		const $elementObject	= $('input[name="' + e.target.name + '"]');
+++		const $confirmBoxObject	= $('div[id="' + e.target.name + '_confirmbox"]');
+++
+++		if ($elementObject.prop('checked') != $confirmBoxObject.attr('data-default')) {
+++			this.#changeBoxState($elementObject, $confirmBoxObject, true);
++ 		}
+++	}
+++
+++	#Button = (e) => {
+++		const elementName		= e.target.name.replace(/_confirm_.*/, '');
+++		const $elementObject	= $('input[name="' + elementName + '"]');
+++		const $confirmBoxObject	= $('div[id="' + elementName + '_confirmbox"]');
+++		const elementType		= $elementObject.attr('type');
++ 
++-		#Button = (e) => {
++-			const elementName		= $(e.target).parents('div.lukewcs_confirmbox').attr('data-name');
++-			const $elementObject	= $('input[name="' + elementName + '"]');
++-			const elementType		= $elementObject.attr('type');
++-			const $confirmBoxObject	= $('div.lukewcs_confirmbox[data-name="' + elementName + '"]');
++-
++-			if (e.target.name == 'lukewcs_confirmbox_no') {
++-				if (elementType == 'checkbox') {
++-					$elementObject.prop('checked', $confirmBoxObject.attr('data-default'));
++-				} else if (elementType == 'radio') {
++-					$elementObject.filter('[value="' + ($confirmBoxObject.attr('data-default') ? '1' : '0') + '"]').prop('checked', true);
++-				}
+++		if (e.target.name.endsWith('_confirm_no')) {
+++			if (elementType == 'checkbox') {
+++				$elementObject.prop('checked', $confirmBoxObject.attr('data-default'));
+++			} else if (elementType == 'radio') {
+++				$elementObject.filter('[value="' + ($confirmBoxObject.attr('data-default') ? '1' : '0') + '"]').prop('checked', true);
++ 			}
++-			this.#changeBoxState($elementObject, $confirmBoxObject, null);
++ 		}
+++		this.#changeBoxState($elementObject, $confirmBoxObject, null);
+++	}
++ 
++-		#changeBoxState = ($elementObject, $confirmBoxObject, showBox) => {
++-			$elementObject		.prop('disabled', !!showBox);
++-			$elementObject		.toggleClass('lukewcs_confirmbox_active', !!showBox);
++-			$confirmBoxObject	[showBox ? 'show' : 'hide'](this.animDuration);
++-			this.$submitObject	.prop('disabled', showBox ?? this.$formObject.find('input.lukewcs_confirmbox_active').length);
++-		}
+++	HideAll = () => {
+++		const $elementObject	= this.$formObject.find('input.confirmbox_active');
+++		const $confirmBoxObject	= this.$formObject.find('div[id$="_confirmbox"]');
+++
+++		this.#changeBoxState($elementObject, $confirmBoxObject, false);
++ 	}
++ 
++-	/*
++-		Declarations
++-	*/
++-
++-	const constants = Object.freeze({
++-		CheckBoxModeOff:	'0',
++-		CheckBoxModeAll:	'1',
++-		CheckBoxModeLast:	'2',
++-	});
++-	let ConfirmBox;
++-
++-	/*
++-		Settings form
++-	*/
++-
++-	function setDefaults() {
++-		const c = constants;
++-
++-		setSwitch('[name="extmgrplus_switch_log"]',							true);
++-		setSwitch('[name="extmgrplus_switch_confirmation"]',				true);
++-		setSwitch('[name="extmgrplus_switch_auto_redirect"]',				false);
++-		$(        '[name="extmgrplus_select_checkbox_mode"]').prop('value',	c.CheckBoxModeAll);
++-		setSwitch('[name="extmgrplus_switch_order_and_ignore"]',			true);
++-		setSwitch('[name="extmgrplus_switch_self_disable"]',				false);
++-		setSwitch('[name="extmgrplus_switch_instructions"]',				true);
++-		setSwitch('[name="extmgrplus_switch_settings_link"]',				true);
++-		$(        '[name="extmgrplus_number_vc_limit"]').prop('value',		15);
++-		setSwitch('[name="extmgrplus_switch_migration_col"]',				false);
++-		setSwitch('[name="extmgrplus_switch_migrations"]',					false);
++-		setSwitch('[name="extmgrplus_switch_version_url"]',					false);
++-
++-		ConfirmBox.HideAll();
++-	};
++-
++-	function setSwitch(selector, checked) {
++-		const $elementObject	= $(selector);
++-		const elementType		= $elementObject.attr('type');
+++	#changeBoxState = ($elementObject, $confirmBoxObject, showBox) => {
+++		$elementObject		.prop('disabled', !!showBox);
+++		$elementObject		.toggleClass('confirmbox_active', !!showBox);
+++		$confirmBoxObject	[showBox ? 'show' : 'hide'](this.animDuration);
+++		this.$submitObject	.prop('disabled', showBox ?? this.$formObject.find('input.confirmbox_active').length);
+++	}
+++}
++ 
++-		if (elementType == 'checkbox') {
++-			$elementObject.prop('checked', checked);
++-		} else if (elementType == 'radio') {
++-			$elementObject.filter('[value="' + (checked ? '1' : '0') + '"]').prop('checked', true);
++-		}
++-	};
+++/*
+++	Declarations
+++*/
++ 
++-	function formSubmit() {
++-		$('[name="extmgrplus_save_settings"]').click();
++-	};
+++const constants = Object.freeze({
+++	CheckBoxModeOff:	'0',
+++	CheckBoxModeAll:	'1',
+++	CheckBoxModeLast:	'2',
+++});
+++let ConfirmBox;
++ 
++-	/*
++-		Common
++-	*/
+++/*
+++	Settings form
+++*/
++ 
++-	function disableEnter(e) {
++-		if (e.key == 'Enter' && e.target.type != 'textarea') {
++-			return false;
++-		}
++-	};
+++function setDefaults() {
+++	const c = constants;
+++
+++	setSwitch('[name="extmgrplus_switch_log"]',							true);
+++	setSwitch('[name="extmgrplus_switch_confirmation"]',				true);
+++	setSwitch('[name="extmgrplus_switch_auto_redirect"]',				false);
+++	$(        '[name="extmgrplus_select_checkbox_mode"]').prop('value',	c.CheckBoxModeAll);
+++	setSwitch('[name="extmgrplus_switch_order_and_ignore"]',			true);
+++	setSwitch('[name="extmgrplus_switch_self_disable"]',				false);
+++	setSwitch('[name="extmgrplus_switch_instructions"]',				true);
+++	$(        '[name="extmgrplus_number_vc_limit"]').prop('value',		15);
+++	setSwitch('[name="extmgrplus_switch_migration_col"]',				false);
+++	setSwitch('[name="extmgrplus_switch_migrations"]',					false);
+++	setSwitch('[name="extmgrplus_switch_version_url"]',					false);
+++
+++	ConfirmBox.HideAll();
+++};
+++
+++function setSwitch(selector, checked) {
+++	const $elementObject	= $(selector);
+++	const elementType		= $elementObject.attr('type');
+++
+++	if (elementType == 'checkbox') {
+++		$elementObject.prop('checked', checked);
+++	} else if (elementType == 'radio') {
+++		$elementObject.filter('[value="' + (checked ? '1' : '0') + '"]').prop('checked', true);
+++	}
+++};
+++
+++function formSubmit() {
+++	$('[name="extmgrplus_save_settings"]').click();
+++};
+++
+++/*
+++	Common
+++*/
+++
+++function disableEnter(e) {
+++	if (e.key == 'Enter' && e.target.type != 'textarea') {
+++		return false;
+++	}
+++};
+++
+++/*
+++	Event registration
+++*/
++ 
++-	/*
++-		Event registration
++-	*/
+++$(function () {
+++	$('#extmgrplus_settings')			.on('keypress'	, disableEnter);
+++	$('[name="extmgrplus_defaults"]')	.on('click'		, setDefaults);
+++	$('[name="extmgrplus_submit"]')		.on('click'		, formSubmit);
++ 
++-	$(function () {
++-		$('#extmgrplus_settings')			.on('keypress'	, disableEnter);
++-		$('[name="extmgrplus_defaults"]')	.on('click'		, setDefaults);
++-		$('[name="extmgrplus_submit"]')		.on('click'		, formSubmit);
+++	ConfirmBox = new LukeWCSphpBBConfirmBox('[name="extmgrplus_submit"]', 300);
+++});
++ 
++-		ConfirmBox = new LukeWCSphpBBConfirmBox('[name="extmgrplus_submit"]', 300);
++-	});
++ })(jQuery);
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_versioncheck.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_versioncheck.html"
++index 9d6aaf8c4..eb385e167 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_versioncheck.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_versioncheck.html"
++@@ -14,6 +14,8 @@
++ 
++ {% INCLUDE 'overall_header.html' %}
++ 
+++<a id="maincontent"></a>
+++
++ <h1>{{ lang('EXTENSIONS_ADMIN') }}</h1>
++ 
++ <p>{{ lang('EXTENSIONS_EXPLAIN') }}</p>
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/adm/style/event/acp_ext_details_end.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/adm/style/event/acp_ext_details_end.html"
++new file mode 100644
++index 000000000..13dbd1022
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/adm/style/event/acp_ext_details_end.html"
++@@ -0,0 +1,26 @@
+++{% import '@lukewcs_extmgrplus/acp_ext_mgr_plus_macros.html' as common %}
+++
+++
+++{% if EXTMGRPLUS_DETAILS|length %}
+++	<fieldset>
+++		<legend>{{ lang('EXTMGRPLUS_SECTION_DETAILS') }}</legend>
+++
+++	{% if EXTMGRPLUS_DETAILS.cdb_page %}
+++		<dl>
+++			<dt><label>{{ lang('EXTMGRPLUS_DETAILS_CDB_PAGE') ~ lang('COLON') }}</label></dt>
+++			<dd><strong><a href="{{ EXTMGRPLUS_DETAILS.cdb_page }}">{{ EXTMGRPLUS_DETAILS.cdb_page }}</a></strong></dd>
+++		</dl>
+++	{% endif %}
+++
+++	{% if EXTMGRPLUS_DETAILS.version_url %}
+++		<dl>
+++			<dt><label>{{ lang('EXTMGRPLUS_DETAILS_VERSION_URL') ~ lang('COLON') }}</label></dt>
+++			<dd><strong><a href="{{ EXTMGRPLUS_DETAILS.version_url }}">{{ EXTMGRPLUS_DETAILS.version_url }}</a></strong></dd>
+++		</dl>
+++	{% endif %}
+++	</fieldset>
+++{% endif %}
+++
+++{{ common.footer(EXTMGRPLUS_METADATA) }}
+++
+++{% INCLUDECSS '@lukewcs_extmgrplus/acp_ext_mgr_plus.css' %}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/composer.json"
++index 42a77c63f..577550354 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/composer.json"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/composer.json"
++@@ -3,8 +3,8 @@
++     "type": "phpbb-extension",
++     "description": "Adds the option to disable and re-enable all installed extensions at once to the extension management. Individual selections can be made using checkboxes. In addition, sequence groups and dependencies can be defined or extensions can be ignored. The version check is carried out in blocks and provides detailed information. Additional information is displayed in the extension management.",
++     "homepage": "https://github.com/LukeWCS/ext-mgr-plus",
++-    "version": "3.1.0",
++-    "time": "2025-11-01",
+++    "version": "3.0.0",
+++    "time": "2024-11-28",
++     "license": "GPL-2.0-only",
++     "authors": [
++         {
++@@ -19,13 +19,13 @@
++         }
++     ],
++     "require": {
++-        "php": ">=8.0.0,<8.5.0@dev",
+++        "php": ">=7.4.0,<8.5.0@dev",
++         "composer/installers": "~1.0.0",
++         "phpbb/phpbb": ">=3.3.8,<3.4.0@dev"
++     },
++     "extra": {
++         "display-name": "Extension Manager Plus",
++-        "lang-min-ver": "3.1.0",
+++        "lang-min-ver": "3.0.0",
++         "soft-require": {
++             "phpbb/phpbb": ">=3.3.8,<3.4.0@dev"
++         },
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/config/services.yml" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/config/services.yml"
++index a70d6857b..f5395d02b 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/config/services.yml"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/config/services.yml"
++@@ -19,8 +19,9 @@ services:
++             - '@language'
++             - '@template'
++             - '@dbal.conn'
++-            - '@path_helper'
++             - '%core.table_prefix%'
+++            - '%core.root_path%'
+++            - '%core.php_ext%'
++     lukewcs.extmgrplus.core.common:
++         class: lukewcs\extmgrplus\core\ext_mgr_plus_common
++         arguments:
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/controller/acp_ext_mgr_plus_controller.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/controller/acp_ext_mgr_plus_controller.php"
++index 2943e9378..0f91e63be 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/controller/acp_ext_mgr_plus_controller.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/controller/acp_ext_mgr_plus_controller.php"
++@@ -15,16 +15,27 @@ namespace lukewcs\extmgrplus\controller;
++ 
++ class acp_ext_mgr_plus_controller
++ {
+++	protected object $common;
+++	protected object $language;
+++	protected object $template;
+++	protected object $request;
+++	protected object $config;
+++
++ 	protected string $u_action;
++ 
++ 	public function __construct(
++-		protected object $common,
++-		protected \phpbb\language\language $language,
++-		protected \phpbb\template\template $template,
++-		protected \phpbb\request\request $request,
++-		protected \phpbb\config\config $config,
+++		$common,
+++		\phpbb\language\language $language,
+++		\phpbb\template\template $template,
+++		\phpbb\request\request $request,
+++		\phpbb\config\config $config
++ 	)
++ 	{
+++		$this->common	= $common;
+++		$this->language	= $language;
+++		$this->template	= $template;
+++		$this->request	= $request;
+++		$this->config	= $config;
++ 	}
++ 
++ 	public function module_settings(): void
++@@ -54,7 +65,6 @@ class acp_ext_mgr_plus_controller
++ 			$this->config->set('extmgrplus_switch_order_and_ignore'	, $this->request->variable('extmgrplus_switch_order_and_ignore'	, 0));
++ 			$this->config->set('extmgrplus_switch_self_disable'		, $this->request->variable('extmgrplus_switch_self_disable'		, 0));
++ 			$this->config->set('extmgrplus_switch_instructions'		, $this->request->variable('extmgrplus_switch_instructions'		, 0));
++-			$this->config->set('extmgrplus_switch_settings_link'	, $this->request->variable('extmgrplus_switch_settings_link'	, 0));
++ 			$this->config->set('extmgrplus_number_vc_limit'			, $this->request->variable('extmgrplus_number_vc_limit'			, 0));
++ 			$this->config->set('extmgrplus_switch_migration_col'	, $this->request->variable('extmgrplus_switch_migration_col'	, 0));
++ 			$this->config->set('extmgrplus_switch_migrations'		, $this->request->variable('extmgrplus_switch_migrations'		, 0));
++@@ -77,7 +87,6 @@ class acp_ext_mgr_plus_controller
++ 			'EXTMGRPLUS_SWITCH_ORDER_AND_IGNORE'		=> (bool) $this->config['extmgrplus_switch_order_and_ignore'],
++ 			'EXTMGRPLUS_SWITCH_SELF_DISABLE'			=> (bool) $this->config['extmgrplus_switch_self_disable'],
++ 			'EXTMGRPLUS_SWITCH_INSTRUCTIONS'			=> (bool) $this->config['extmgrplus_switch_instructions'],
++-			'EXTMGRPLUS_SWITCH_SETTINGS_LINK'			=> (bool) $this->config['extmgrplus_switch_settings_link'],
++ 			'EXTMGRPLUS_NUMBER_VC_LIMIT'				=> (int) $this->config['extmgrplus_number_vc_limit'],
++ 			'EXTMGRPLUS_SWITCH_MIGRATION_COL'			=> (bool) $this->config['extmgrplus_switch_migration_col'],
++ 			'EXTMGRPLUS_SWITCH_MIGRATIONS'				=> (bool) $this->config['extmgrplus_switch_migrations'],
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/core/ext_mgr_plus.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/core/ext_mgr_plus.php"
++index ee129cbb4..7bc61a912 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/core/ext_mgr_plus.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/core/ext_mgr_plus.php"
++@@ -19,34 +19,55 @@ class ext_mgr_plus
++ 	protected const  CHECKBOX_ALL	= 1;
++ 	protected const  CHECKBOX_LAST	= 2;
++ 
++-	protected const  CDB_EXT			= 1;
++-	protected const  CDB_EXT_OFFICIAL	= 2;
++-
++-	protected string $u_action;
++-	protected int $safe_time_limit;
+++	protected object $common;
+++	protected object $ext_manager;
+++	protected object $cache;
+++	protected object $request;
+++	protected object $log;
+++	protected object $user;
+++	protected object $config;
+++	protected object $config_text;
+++	protected object $language;
+++	protected object $template;
+++	protected object $db;
+++	protected string $table_prefix;
++ 	protected string $phpbb_root_path;
++-	protected string $phpbb_admin_path;
++ 	protected string $php_ext;
++ 
+++	protected string $u_action;
+++	protected int    $safe_time_limit;
+++
++ 	public function __construct(
++-		protected object $common,
++-		protected \phpbb\extension\manager $ext_manager,
++-		protected \phpbb\cache\driver\driver_interface $cache,
++-		protected \phpbb\request\request $request,
++-		protected \phpbb\log\log $log,
++-		protected \phpbb\user $user,
++-		protected \phpbb\config\config $config,
++-		protected \phpbb\config\db_text $config_text,
++-		protected \phpbb\language\language $language,
++-		protected \phpbb\template\template $template,
++-		protected \phpbb\db\driver\driver_interface $db,
++-		protected \phpbb\path_helper $path_helper,
++-		protected string $table_prefix,
+++		$common,
+++		\phpbb\extension\manager $ext_manager,
+++		\phpbb\cache\driver\driver_interface $cache,
+++		\phpbb\request\request $request,
+++		\phpbb\log\log $log,
+++		\phpbb\user $user,
+++		\phpbb\config\config $config,
+++		\phpbb\config\db_text $config_text,
+++		\phpbb\language\language $language,
+++		\phpbb\template\template $template,
+++		\phpbb\db\driver\driver_interface $db,
+++		$table_prefix,
+++		$phpbb_root_path,
+++		$php_ext
++ 	)
++ 	{
++-		$this->phpbb_root_path	= $this->path_helper->get_phpbb_root_path();
++-		$this->phpbb_admin_path	= $this->phpbb_root_path . $this->path_helper->get_adm_relative_path();
++-		$this->php_ext			= $this->path_helper->get_php_ext();
+++		$this->common			= $common;
+++		$this->ext_manager		= $ext_manager;
+++		$this->cache			= $cache;
+++		$this->request			= $request;
+++		$this->log				= $log;
+++		$this->user				= $user;
+++		$this->config			= $config;
+++		$this->config_text		= $config_text;
+++		$this->language			= $language;
+++		$this->template			= $template;
+++		$this->db				= $db;
+++		$this->table_prefix 	= $table_prefix;
+++		$this->phpbb_root_path	= $phpbb_root_path;
+++		$this->php_ext			= $php_ext;
++ 	}
++ 
++ 	/*
++@@ -59,9 +80,9 @@ class ext_mgr_plus
++ 			return;
++ 		}
++ 
++-		$this->u_action			= $event['u_action'];
++-		$this->common->u_action	= $this->u_action;
++-		$this->safe_time_limit	= $event['safe_time_limit'];
+++		$this->u_action = $event['u_action'];
+++		$this->common->u_action = $this->u_action;
+++		$this->safe_time_limit = $event['safe_time_limit'];
++ 
++ 		$this->language->add_lang(['acp_ext_mgr_plus', 'acp_ext_mgr_plus_lang_author'], 'lukewcs/extmgrplus');
++ 		$this->common->set_meta_template_vars('EXTMGRPLUS', 'LukeWCS');
++@@ -74,19 +95,17 @@ class ext_mgr_plus
++ 
++ 			$this->exts_switch_confirm();
++ 		}
++-		else if ($this->request->is_set_post('extmgrplus_save_ext_properties'))
+++		else if ($this->request->is_set_post('extmgrplus_save_ext_properties') && $this->config['extmgrplus_switch_order_and_ignore'])
++ 		{
++ 			$this->common->check_form_key_('lukewcs_extmgrplus');
++ 
++-			if ($this->config['extmgrplus_switch_order_and_ignore'])
++-			{
++-				$order_list		= $this->request->variable('ext_order', ['' => '']);
++-				$ignore_list	= $this->request->variable('ext_ignore', ['']);
++-				$order_list		= preg_grep('/^\+?[0-9]{1,2}$/', $order_list);
+++			$order_list = $this->request->variable('ext_order', ['' => '']);
+++			$ignore_list = $this->request->variable('ext_ignore', ['']);
++ 
++-				$this->common->config_text_set('extmgrplus_list_order_and_ignore', 'order', count($order_list) ? $order_list : null);
++-				$this->common->config_text_set('extmgrplus_list_order_and_ignore', 'ignore', count($ignore_list) ? $ignore_list : null);
++-			}
+++			$order_list = preg_grep('/^\+?[0-9]{1,2}$/', $order_list);
+++
+++			$this->common->config_text_set('extmgrplus_list_order_and_ignore', 'order', count($order_list) ? $order_list : null);
+++			$this->common->config_text_set('extmgrplus_list_order_and_ignore', 'ignore', count($ignore_list) ? $ignore_list : null);
++ 
++ 			$this->common->trigger_error_($this->language->lang('EXTMGRPLUS_MSG_EXT_PROPERTIES_SAVED'), E_USER_NOTICE, 'RETURN_TO_EXTENSION_LIST');
++ 		}
++@@ -111,8 +130,6 @@ class ext_mgr_plus
++ 	{
++ 		if ($event['action'] == 'details')
++ 		{
++-			$event['tpl_name'] = '@lukewcs_extmgrplus/acp_ext_mgr_plus_acp_ext_details';
++-
++ 			$this->extend_details($event['ext_name']);
++ 			$this->versioncheck_details($event['ext_name']);
++ 			return;
++@@ -136,7 +153,6 @@ class ext_mgr_plus
++ 		if ($vc_request)
++ 		{
++ 			$event['tpl_name'] = '@lukewcs_extmgrplus/acp_ext_mgr_plus_versioncheck';
++-
++ 			$this->template->assign_vars([
++ 				'EXTMGRPLUS_VC_DATA'		=> $ext_list_versioncheck['data'],
++ 				'U_EXTMGRPLUS_VC_CANCEL'	=> $this->u_action,
++@@ -165,7 +181,6 @@ class ext_mgr_plus
++ 		$ext_list_migrations_inactive			= [];
++ 		$ext_list_order							= [];
++ 		$ext_list_ignore						= [];
++-		$ext_list_modules						= [];
++ 		$ext_list_enabled_ignored				= [];
++ 		$ext_list_disabled_ignored				= [];
++ 		$ext_list_selected						= [];
++@@ -184,11 +199,6 @@ class ext_mgr_plus
++ 			$ext_list_disabled_ignored	= array_intersect_key($ext_list_ignore, $ext_list_disabled);
++ 		}
++ 
++-		if ($this->config['extmgrplus_switch_settings_link'])
++-		{
++-			$ext_list_modules = $this->get_module_links();
++-		}
++-
++ 		if ($this->config['extmgrplus_switch_migration_col'])
++ 		{
++ 			$ext_list_migrations_inactive = $this->get_exts_with_new_migration(array_diff_key($ext_list_available, $ext_list_enabled, $ext_list_ignore));
++@@ -204,7 +214,6 @@ class ext_mgr_plus
++ 		{
++ 			$ext_list_enabled_ignored['lukewcs/extmgrplus'] = 0;
++ 		}
++-
++ 		if (!$this->config['extmgrplus_switch_migrations'])
++ 		{
++ 			$ext_list_disabled_ignored = array_merge($ext_list_disabled_ignored, $ext_list_migrations_disabled);
++@@ -246,7 +255,6 @@ class ext_mgr_plus
++ 			'EXTMGRPLUS_LIST_IGNORE'				=> $ext_list_ignore,
++ 			'EXTMGRPLUS_LIST_MIGRATIONS'			=> $ext_list_migrations_inactive,
++ 			'EXTMGRPLUS_LIST_SELECTED'				=> $ext_list_selected,
++-			'EXTMGRPLUS_LIST_MODULES'				=> $ext_list_modules,
++ 			'EXTMGRPLUS_LIST_VERSIONCHECK'			=> $this->versioncheck_list($ext_list_available, $ext_list_versioncheck),
++ 
++ 			'EXTMGRPLUS_COUNT'						=> [
++@@ -265,7 +273,6 @@ class ext_mgr_plus
++ 			'EXTMGRPLUS_SWITCH_ORDER_AND_IGNORE'	=> $this->config['extmgrplus_switch_order_and_ignore'],
++ 			'EXTMGRPLUS_SWITCH_SELF_DISABLE'		=> $this->config['extmgrplus_switch_self_disable'],
++ 			'EXTMGRPLUS_SWITCH_INSTRUCTIONS'		=> $this->config['extmgrplus_switch_instructions'],
++-			'EXTMGRPLUS_SWITCH_SETTINGS_LINK'		=> $this->config['extmgrplus_switch_settings_link'],
++ 			'EXTMGRPLUS_SWITCH_MIGRATION_COL'		=> $this->config['extmgrplus_switch_migration_col'],
++ 			'EXTMGRPLUS_SWITCH_MIGRATIONS'			=> $this->config['extmgrplus_switch_migrations'],
++ 		]);
++@@ -277,7 +284,7 @@ class ext_mgr_plus
++ 	*/
++ 	public function change_msg_template(): void
++ 	{
++-		if ($this->template->retrieve_var('EXTMGRPLUS_TRIGGER_ERROR') !== null)
+++		if ($this->template->retrieve_var('EXTMGRPLUS_TRIGGER_ERROR'))
++ 		{
++ 			$this->template->set_filenames(['body' => '@lukewcs_extmgrplus/acp_ext_mgr_plus_message_body.html']);
++ 		}
++@@ -327,8 +334,7 @@ class ext_mgr_plus
++ 		{
++ 			$this->template->assign_vars([
++ 				'EXTMGRPLUS_ACTION_MODE'	=> 'DISABLE',
++-				'EXTMGRPLUS_CONFIRM_YES'	=> 'EXTENSION_DISABLE',
++-				'EXTMGRPLUS_CONFIRM_NO'		=> 'CANCEL',
+++				'EXTMGRPLUS_SELF_DISABLE'	=> array_search('lukewcs/extmgrplus', $ext_mark_enabled) !== false,
++ 			]);
++ 			if (!$this->config['extmgrplus_switch_confirmation'] || confirm_box(true))
++ 			{
++@@ -343,8 +349,6 @@ class ext_mgr_plus
++ 		{
++ 			$this->template->assign_vars([
++ 				'EXTMGRPLUS_ACTION_MODE'	=> 'ENABLE',
++-				'EXTMGRPLUS_CONFIRM_YES'	=> 'EXTENSION_ENABLE',
++-				'EXTMGRPLUS_CONFIRM_NO'		=> 'CANCEL',
++ 			]);
++ 			if (!$this->config['extmgrplus_switch_confirmation'] || confirm_box(true))
++ 			{
++@@ -393,17 +397,17 @@ class ext_mgr_plus
++ 		{
++ 			try
++ 			{
++-				$ext_meta = $this->ext_manager->create_extension_metadata_manager($ext_name)->get_metadata('all');
+++				$ext_metadata = $this->ext_manager->create_extension_metadata_manager($ext_name)->get_metadata('all');
++ 			}
++ 			catch (\RuntimeException $e)
++ 			{
++-				$ext_meta = null;
+++				$ext_metadata = null;
++ 			}
++ 
++-			if (is_array($ext_meta))
+++			if (is_array($ext_metadata))
++ 			{
++-				$ext_display_name	= $ext_meta['extra']['display-name'] ?? '';
++-				$ext_version		= $ext_meta['version'] ?? '';
+++				$ext_display_name	= $ext_metadata['extra']['display-name'] ?? '';
+++				$ext_version		= $ext_metadata['version'] ?? '';
++ 
++ 				$disable_error = '';
++ 				if ($this->ext_manager->is_enabled($ext_name))
++@@ -436,7 +440,7 @@ class ext_mgr_plus
++ 				}
++ 			}
++ 
++-			if ($this->safe_time_limit > 0 && (microtime(true) - $GLOBALS['starttime']) >= $this->safe_time_limit)
+++			if ((microtime(true) - $GLOBALS['starttime']) >= $this->safe_time_limit)
++ 			{
++ 				$safe_time_exceeded = true;
++ 				break;
++@@ -458,7 +462,7 @@ class ext_mgr_plus
++ 		}
++ 		$this->common->trigger_error_(
++ 			$this->language->lang('EXTMGRPLUS_MSG_DEACTIVATION', $ext_count_success, $ext_count_enabled) . ($msg_failed ?? ''),
++-			$this->get_error_level($ext_count_success, $ext_count_enabled, $safe_time_exceeded),
+++			(($ext_count_success != $ext_count_enabled || $safe_time_exceeded) ? E_USER_WARNING : E_USER_NOTICE),
++ 			'RETURN_TO_EXTENSION_LIST'
++ 		);
++ 	}
++@@ -498,17 +502,17 @@ class ext_mgr_plus
++ 		{
++ 			try
++ 			{
++-				$ext_meta = $this->ext_manager->create_extension_metadata_manager($ext_name)->get_metadata('all');
+++				$ext_metadata = $this->ext_manager->create_extension_metadata_manager($ext_name)->get_metadata('all');
++ 			}
++ 			catch (\RuntimeException $e)
++ 			{
++-				$ext_meta = null;
+++				$ext_metadata = null;
++ 			}
++ 
++-			if (is_array($ext_meta))
+++			if (is_array($ext_metadata))
++ 			{
++-				$ext_display_name	= $ext_meta['extra']['display-name'] ?? '';
++-				$ext_version		= $ext_meta['version'] ?? '';
+++				$ext_display_name	= $ext_metadata['extra']['display-name'] ?? '';
+++				$ext_version		= $ext_metadata['version'] ?? '';
++ 
++ 				if ($this->ext_manager->is_disabled($ext_name))
++ 				{
++@@ -554,7 +558,7 @@ class ext_mgr_plus
++ 				}
++ 			}
++ 
++-			if ($this->safe_time_limit > 0 && (microtime(true) - $GLOBALS['starttime']) >= $this->safe_time_limit)
+++			if ((microtime(true) - $GLOBALS['starttime']) >= $this->safe_time_limit)
++ 			{
++ 				$safe_time_exceeded = true;
++ 				break;
++@@ -576,7 +580,7 @@ class ext_mgr_plus
++ 		}
++ 		$this->common->trigger_error_(
++ 			$this->language->lang('EXTMGRPLUS_MSG_ACTIVATION', $ext_count_success, $ext_count_disabled) . ($msg_failed ?? ''),
++-			$this->get_error_level($ext_count_success, $ext_count_disabled, $safe_time_exceeded),
+++			(($ext_count_success != $ext_count_disabled || $safe_time_exceeded) ? E_USER_WARNING : E_USER_NOTICE),
++ 			'RETURN_TO_EXTENSION_LIST'
++ 		);
++ 	}
++@@ -588,14 +592,14 @@ class ext_mgr_plus
++ 	{
++ 		$msg_failed = '<br><br>' . $this->language->lang($lang_var);
++ 		$count_failed = 0;
++-		foreach ($ext_list as $ext_name => $vars)
+++		foreach ($ext_list as $name => $vars)
++ 		{
++ 			if (is_array($vars['message']))
++ 			{
++ 				$vars['message'] = implode('<br>', $vars['message']);
++ 			}
++ 			$count_failed++;
++-			$msg_failed .= $this->create_failed_msg($count_failed . '. ' . $vars['display_name'], $vars['ext_version'], $ext_name, $vars['message']);
+++			$msg_failed .= $this->create_failed_msg($count_failed . '. ' . $vars['display_name'], $vars['ext_version'], $name, $vars['message']);
++ 		}
++ 
++ 		return $msg_failed;
++@@ -606,24 +610,12 @@ class ext_mgr_plus
++ 	*/
++ 	private function create_failed_msg(string $display_name, string $ext_version, string $ext_name, string $message): string
++ 	{
++-		return vsprintf('<br><br><strong>%1$s %2$s (%3$s)</strong>%4$s', [
++-			1	=> $display_name,
++-			2	=> $this->language->lang('EXTMGRPLUS_VERSION_STRING', $ext_version),
++-			3	=> $ext_name,
++-			4	=> empty($message) ? '' : "<br><br><em>{$message}</em>"
++-		]);
++-	}
++-
++-	/*
++-		Helper function for trigger_error
++-	*/
++-	function get_error_level(int $count_success, int $count_total, bool $safe_time_exceeded): int
++-	{
++-		return match (true) {
++-			$count_success == $count_total				=> E_USER_NOTICE,
++-			$count_success == 0, $safe_time_exceeded	=> E_USER_WARNING,
++-			default										=> E_USER_NOTICE + E_USER_ERROR,
++-		};
+++		return sprintf('<br><br><strong>%1$s %2$s (%3$s)</strong>%4$s',
+++			/* 1 */	$display_name,
+++			/* 2 */	$this->language->lang('EXTMGRPLUS_VERSION_STRING', $ext_version),
+++			/* 3 */	$ext_name,
+++			/* 4 */	empty($message) ? '' : "<br><br><em>{$message}</em>"
+++		);
++ 	}
++ 
++ 	/*
++@@ -673,48 +665,6 @@ class ext_mgr_plus
++ 		return count($migration_classes_new);
++ 	}
++ 
++-	/*
++-		Determine all ACP module links of the active extensions
++-	*/
++-	private function get_module_links(): array
++-	{
++-		global $module;
++-
++-		$module_urls = [];
++-		$module_tabs = [];
++-
++-		$modules = array_combine(array_column($module->module_ary, 'id'), $module->module_ary);
++-		$get_module_top_cat = function (int $module_id) use ($modules): string
++-		{
++-			$parent_id = $modules[$module_id]['parent'];
++-			while ($parent_id !== 0)
++-			{
++-				$module_id = $parent_id;
++-				$parent_id = $modules[$module_id]['parent'];
++-			}
++-
++-			return $modules[$module_id]['langname'];
++-		};
++-
++-		foreach (array_filter($modules, fn($row): bool => $row['name'] !== '' && $row['display']) as $module_row)
++-		{
++-			preg_match('/\\\\(.+?)\\\\(.+?)\\\\.*/', $module_row['name'], $matches);
++-			$tech_name = (count($matches) === 3) ? $matches[1] . '/' . $matches[2] : false;
++-			if ($tech_name !== false)
++-			{
++-				$module_tab = $get_module_top_cat($module_row['parent']);
++-				if (!isset($module_urls[$tech_name]) || ($module_tab === 'ACP_CAT_DOT_MODS' && $module_tabs[$tech_name] !== $module_tab))
++-				{
++-					$module_name = str_replace('\\', '-', $module_row['name']);
++-					$module_urls[$tech_name] = append_sid("{$this->phpbb_admin_path}index.{$this->php_ext}", "i={$module_name}&amp;mode={$module_row['mode']}");
++-					$module_tabs[$tech_name] = $module_tab;
++-				}
++-			}
++-		}
++-
++-		return $module_urls;
++-	}
++-
++ 	/*
++ 		Check if file is a valid migration file
++ 	*/
++@@ -726,14 +676,17 @@ class ext_mgr_plus
++ 			$file_content = file_get_contents($file);
++ 			if ($file_content !== false)
++ 			{
++-				return (
++-					preg_match('/function\s+?(?:depends_on|effectively_installed|update_schema|update_data|revert_data)\s*?\(/', $file_content)
++-					&& preg_match('/^\s*?class\s+?' . $file_info['filename'] . '\s+/mi', $file_content)
++-				) ? 1 : 0;
+++				$check_migration = ((
+++						preg_match('/function\s+?(?:depends_on|effectively_installed|update_schema|update_data|revert_data)\s*?\(/', $file_content)
+++						&& preg_match('/^\s*?class\s+?' . $file_info['filename'] . '\s+/mi', $file_content)
+++					)
+++					? 1
+++					: 0
+++				);
++ 			}
++ 		}
++ 
++-		return -1;
+++		return ($check_migration ?? -1);
++ 	}
++ 
++ 	/*
++@@ -757,7 +710,7 @@ class ext_mgr_plus
++ 	/*
++ 		Preparation to be able to run a version check in blocks
++ 	*/
++-	private function versioncheck_prepare(array|null &$ext_list_vc): void
+++	private function versioncheck_prepare(?array &$ext_list_vc): void
++ 	{
++ 		$ext_list_all	= $this->ext_manager->all_available();
++ 		$ext_list_vc	= [
++@@ -778,7 +731,6 @@ class ext_mgr_plus
++ 			}
++ 			catch (\RuntimeException $e)
++ 			{
++-				$vc_meta = null;
++ 			}
++ 
++ 			if (isset($vc_meta))
++@@ -789,7 +741,6 @@ class ext_mgr_plus
++ 				$this->cache->destroy(str_replace(['/', '\\'], '-', $cache_filename));
++ 			}
++ 		}
++-
++ 		$ext_list_vc['data']['count_total']	= count($ext_list_vc) - 1;
++ 		$this->common->config_text_set('extmgrplus_list_version_check', 'updates', $ext_list_vc);
++ 	}
++@@ -851,8 +802,8 @@ class ext_mgr_plus
++ 
++ 		try
++ 		{
++-			$ext_meta = $md_manager->get_metadata('all');
++-			if (isset($ext_meta['extra']['version-check']))
+++			$ext_metadata = $md_manager->get_metadata('all');
+++			if (isset($ext_metadata['extra']['version-check']))
++ 			{
++ 				$vc_data = $this->ext_manager->version_check($md_manager, !$read_cache, $read_cache, $this->config['extension_force_unstable'] ? 'unstable' : null);
++ 				$vc_current = empty($vc_data) ? 'NOUPD' : $vc_data['current'];
++@@ -875,7 +826,7 @@ class ext_mgr_plus
++ 	/*
++ 		Reads the version check data from the database and removes obsolete entries and generates a list for the template
++ 	*/
++-	private function versioncheck_list(array &$ext_list, array|null &$ext_list_vc): array
+++	private function versioncheck_list(array &$ext_list, ?array &$ext_list_vc): array
++ 	{
++ 		$ext_list_vc ??= [];
++ 
++@@ -892,17 +843,10 @@ class ext_mgr_plus
++ 			}
++ 			if ($this->ext_manager->is_available($ext_name))
++ 			{
++-				try
++-				{
++-					$ext_meta = $this->ext_manager->create_extension_metadata_manager($ext_name)->get_metadata('all');
++-				}
++-				catch (\RuntimeException $e)
++-				{
++-					$ext_meta = null;
++-				}
+++				$ext_metadata = $this->ext_manager->create_extension_metadata_manager($ext_name)->get_metadata('all');
++ 
++ 				$no_ver_flags = $vc_data['current'] == 'NOUPD' || $vc_data['current'] == 'ERROR' || $vc_data['current'] == '';
++-				$has_update = !$no_ver_flags && phpbb_version_compare($ext_meta['version'] ?? '0.0.0', $vc_data['current'], '<');
+++				$has_update = !$no_ver_flags && phpbb_version_compare($ext_metadata['version'], $vc_data['current'], '<');
++ 				if ($no_ver_flags || $has_update)
++ 				{
++ 					$ext_list_tpl[$ext_name]['current'] = $vc_data['current'];
++@@ -943,19 +887,15 @@ class ext_mgr_plus
++ 		{
++ 			try
++ 			{
++-				$ext_meta = $this->ext_manager->create_extension_metadata_manager($ext_name)->get_metadata('all');
+++				$ext_metadata = $this->ext_manager->create_extension_metadata_manager($ext_name)->get_metadata('all');
++ 			}
++ 			catch (\RuntimeException $e)
++ 			{
++-				$ext_meta = null;
++ 			}
++ 
++-			if (isset($ext_meta['extra']['version-check']))
+++			if (isset($ext_metadata['extra']['version-check']))
++ 			{
++-				if (($ext_meta['extra']['version-check']['host'] ?? '') == 'www.phpbb.com')
++-				{
++-					$ext_list_tpl[$ext_name]['cdb_ext']	= substr($ext_meta['name'], 0, 6) == 'phpbb/' ? self::CDB_EXT_OFFICIAL : self::CDB_EXT;
++-				}
+++				$ext_list_tpl[$ext_name]['cdb_ext']	= ($ext_metadata['extra']['version-check']['host'] ?? '') == 'www.phpbb.com';
++ 				$count_total++;
++ 			}
++ 			else
++@@ -980,16 +920,13 @@ class ext_mgr_plus
++ 	*/
++ 	private function extend_details(string $ext_name): void
++ 	{
++-		$ext_meta	= $this->ext_manager->create_extension_metadata_manager($ext_name)->get_metadata('all');
++-		$vc_meta	= $ext_meta['extra']['version-check'] ?? null;
++-		$details	= [];
++-
+++		$vc_meta = $this->ext_manager->create_extension_metadata_manager($ext_name)->get_metadata('all')['extra']['version-check'] ?? null;
+++		$details = [];
++ 		if (isset($vc_meta))
++ 		{
++ 			if (($vc_meta['host'] ?? '') == 'www.phpbb.com')
++ 			{
++-				$details['cdb_page']	= 'https://www.phpbb.com' . $vc_meta['directory'] . '/';
++-				$details['cdb_ext']		= substr($ext_meta['name'], 0, 6) == 'phpbb/' ? self::CDB_EXT_OFFICIAL : self::CDB_EXT;
+++				$details['cdb_page'] = 'https://www.phpbb.com' . $vc_meta['directory'] . '/';
++ 			}
++ 			if ($this->config['extmgrplus_switch_version_url'])
++ 			{
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/core/ext_mgr_plus_common.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/core/ext_mgr_plus_common.php"
++index ebb95000f..f56977333 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/core/ext_mgr_plus_common.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/core/ext_mgr_plus_common.php"
++@@ -15,18 +15,30 @@ namespace lukewcs\extmgrplus\core;
++ 
++ class ext_mgr_plus_common
++ {
++-	protected array $metadata;
++-	public string $u_action;
+++	protected object $config;
+++	protected object $config_text;
+++	protected object $language;
+++	protected object $template;
+++	protected object $ext_manager;
+++
+++	protected array  $metadata;
+++	public    string $u_action;
++ 
++ 	public function __construct(
++-		protected \phpbb\config\config $config,
++-		protected \phpbb\config\db_text $config_text,
++-		protected \phpbb\language\language $language,
++-		protected \phpbb\template\template $template,
++-		protected \phpbb\extension\manager $ext_manager,
+++		\phpbb\config\config $config,
+++		\phpbb\config\db_text $config_text,
+++		\phpbb\language\language $language,
+++		\phpbb\template\template $template,
+++		\phpbb\extension\manager $ext_manager
++ 	)
++ 	{
++-		$this->metadata = $this->ext_manager->create_extension_metadata_manager('lukewcs/extmgrplus')->get_metadata('all');
+++		$this->config		= $config;
+++		$this->config_text	= $config_text;
+++		$this->language		= $language;
+++		$this->template		= $template;
+++		$this->ext_manager	= $ext_manager;
+++
+++		$this->metadata		= $this->ext_manager->create_extension_metadata_manager('lukewcs/extmgrplus')->get_metadata('all');
++ 	}
++ 
++ 	public function set_meta_template_vars(string $tpl_prefix, string $copyright): void
++@@ -70,7 +82,7 @@ class ext_mgr_plus_common
++ 			{
++ 				$lang_outdated_msg = $this->language->lang($lang_outdated_var);
++ 			}
++-			else /* Fallback if the current language package does not yet have the required variable. */
+++			else // Fallback if the current language package does not yet have the required variable.
++ 			{
++ 				$lang_outdated_msg = 'Note: The language pack for the extension <strong>%1$s</strong> is no longer up-to-date. (installed: %2$s / needed: %3$s)';
++ 			}
++@@ -83,7 +95,7 @@ class ext_mgr_plus_common
++ 	/*
++ 		Set a variable/array in a config_text variable container or delete one or all variables/arrays
++ 	*/
++-	public function config_text_set(string $container, string|null $name, $value): void
+++	public function config_text_set(string $container, ?string $name, $value): void
++ 	{
++ 		if ($this->config_text->get($container) === null)
++ 		{
++@@ -113,7 +125,7 @@ class ext_mgr_plus_common
++ 	/*
++ 		Get a variable/array from a config_text variable co
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/event/listener.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/event/listener.php"
+index 6be72ab45..e6ff2a295 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/event/listener.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/event/listener.php"
+@@ -18,9 +18,10 @@ use Symfony\Component\EventDispatcher\EventSubscriberInterface;
+ class listener implements EventSubscriberInterface
+ {
+ 	public function __construct(
+-		protected \lukewcs\extmgrplus\core\ext_mgr_plus $extmgrplus,
++		\lukewcs\extmgrplus\core\ext_mgr_plus $extmgrplus
+ 	)
+ 	{
++		$this->extmgrplus = $extmgrplus;
+ 	}
+ 
+ 	public static function getSubscribedEvents(): array
+@@ -32,12 +33,12 @@ class listener implements EventSubscriberInterface
+ 		];
+ 	}
+ 
+-	public function ext_manager_before(object $event): void
++	public function ext_manager_before($event): void
+ 	{
+ 		$this->extmgrplus->ext_manager_before($event);
+ 	}
+ 
+-	public function ext_manager_after(object $event): void
++	public function ext_manager_after($event): void
+ 	{
+ 		$this->extmgrplus->ext_manager_after($event);
+ 	}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/ext.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/ext.php"
+index b4bb2602c..b05f649b1 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/ext.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/ext.php"
+@@ -18,7 +18,7 @@ class ext extends \phpbb\extension\base
+ 	public function is_enableable()
+ 	{
+ 		$valid_phpbb = phpbb_version_compare(PHPBB_VERSION, '3.3.8', '>=') && phpbb_version_compare(PHPBB_VERSION, '3.4.0-dev', '<');
+-		$valid_php = phpbb_version_compare(PHP_VERSION, '8.0.0', '>=') && phpbb_version_compare(PHP_VERSION, '8.5.0-dev', '<');
++		$valid_php = phpbb_version_compare(PHP_VERSION, '7.4.0', '>=') && phpbb_version_compare(PHP_VERSION, '8.5.0-dev', '<');
+ 
+ 		return ($valid_phpbb && $valid_php);
+ 	}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/language/de/acp_ext_mgr_plus.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/language/de/acp_ext_mgr_plus.php"
+index 817751d59..1e91c7d2f 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/language/de/acp_ext_mgr_plus.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/language/de/acp_ext_mgr_plus.php"
+@@ -45,11 +45,11 @@ $lang = array_merge($lang, [
+ 	'EXTMGRPLUS_COL_WITH_VERSIONCHECK'		=> 'Mit Versionsprüfung',
+ 	'EXTMGRPLUS_COL_LAST_VERSIONCHECK'		=> 'Letzte Versionsprüfung',
+ 	'EXTMGRPLUS_COL_AVAILABLE_UPDATES'		=> 'Verfügbare Updates',
+-	'EXTMGRPLUS_AVAILABLE_EXTENSIONS'		=> [
++	'EXTMGRPLUS_AVAILABLE_EXTENSIONS' => [
+ 		0									=> '%2$u',
+ 		1									=> '%2$u (%1$u ungültige)',
+ 	],
+-	'EXTMGRPLUS_VERSIONCHECK_DATE'			=> [
++	'EXTMGRPLUS_VERSIONCHECK_DATE' => [
+ 		0									=> '%2$s (%3$u Sek.)',
+ 		1									=> '%2$s (%3$u Sek. / %1$u Fehler)',
+ 	],
+@@ -89,22 +89,20 @@ $lang = array_merge($lang, [
+ 	'EXTMGRPLUS_TOOLTIP_SELECT'				=> 'Erweiterung auswählen.',
+ 	'EXTMGRPLUS_TOOLTIP_IS_LOCKED'			=> 'Die Auswahl dieser Erweiterung ist wegen neuer Migrationen gesperrt.',
+ 	// tooltips icons
+-	'EXTMGRPLUS_TOOLTIP_CDB_EXT'			=> 'Das ist eine validierte Erweiterung.',
+-	'EXTMGRPLUS_TOOLTIP_CDB_EXT_OFFICIAL'	=> 'Das ist eine offizielle Erweiterung von phpBB.com.',
++	'EXTMGRPLUS_TOOLTIP_CDB_EXT'			=> 'Diese Erweiterung wurde offiziell validiert.',
+ 	'EXTMGRPLUS_TOOLTIP_OUTDATED'			=> 'Die installierte Version dieser Erweiterung ist veraltet.',
+ 	'EXTMGRPLUS_TOOLTIP_VERSIONCHECK_ERROR'	=> 'Bei der Versionsprüfung ist ein Fehler aufgetreten. Klicke auf „Details“ um mehr zu erfahren.',
+ 	'EXTMGRPLUS_TOOLTIP_VERSIONCHECK_EMPTY'	=> 'Bei dieser Erweiterung wurde keine Versionsprüfung ausgeführt.',
+ 	'EXTMGRPLUS_TOOLTIP_NO_VERSIONCHECK'	=> 'Diese Erweiterung bietet keine Versionsprüfung.',
+ 	'EXTMGRPLUS_TOOLTIP_IS_IGNORED'			=> 'Diese Erweiterung wird von „Extension Manager Plus“ ignoriert.',
+-	'EXTMGRPLUS_TOOLTIP_SETTINGS'			=> 'Das primäre Einstellungsmodul dieser Erweiterung aufrufen.',
+ 
+ 	// misc
+-	'EXTMGRPLUS_EXTENSION_PLURAL'			=> [
++	'EXTMGRPLUS_EXTENSION_PLURAL' => [
+ 		0									=> '0 Erweiterungen',
+ 		1									=> '1 Erweiterung',
+ 		2									=> '%u Erweiterungen',
+ 	],
+-	'EXTMGRPLUS_SECOND_PLURAL'				=> [
++	'EXTMGRPLUS_SECOND_PLURAL' => [
+ 		0									=> '0 Sekunden',
+ 		1									=> '1 Sekunde',
+ 		2									=> '%u Sekunden',
+@@ -112,6 +110,7 @@ $lang = array_merge($lang, [
+ 	'EXTMGRPLUS_SPOILER_LABEL'				=> 'Erklärung',
+ 
+ 	// details
++	'EXTMGRPLUS_SECTION_DETAILS'			=> 'Informationen von Extension Manager Plus',
+ 	'EXTMGRPLUS_DETAILS_CDB_PAGE'			=> 'Seite der phpBB-Erweiterungsdatenbank',
+ 	'EXTMGRPLUS_DETAILS_VERSION_URL'		=> 'Link zur Versionsdatei',
+ 
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/language/de/acp_ext_mgr_plus_lang_author.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/language/de/acp_ext_mgr_plus_lang_author.php"
+index e66fd16d3..83be08800 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/language/de/acp_ext_mgr_plus_lang_author.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/language/de/acp_ext_mgr_plus_lang_author.php"
+@@ -42,7 +42,7 @@ if (empty($lang) || !is_array($lang))
+ $lang = array_merge($lang, [
+ 	// language pack author
+ 	'EXTMGRPLUS_LANG_DESC'					=> 'Deutsch (Du)',
+-	'EXTMGRPLUS_LANG_VER' 					=> '3.1.0',
++	'EXTMGRPLUS_LANG_VER' 					=> '3.0.0',
+ 	'EXTMGRPLUS_LANG_AUTHOR'				=> 'LukeWCS',
+ 
+ 	// messages
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/language/de/acp_ext_mgr_plus_settings.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/language/de/acp_ext_mgr_plus_settings.php"
+index 9d945e260..4d4265507 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/language/de/acp_ext_mgr_plus_settings.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/language/de/acp_ext_mgr_plus_settings.php"
+@@ -55,10 +55,10 @@ $lang = array_merge($lang, [
+ 	'EXTMGRPLUS_CHECKBOX_MODE_LAST'			=> 'Letzten Zustand merken',
+ 	'EXTMGRPLUS_SELF_DISABLE'				=> 'Erlaube Eigendeaktivierung',
+ 	'EXTMGRPLUS_SELF_DISABLE_EXPLAIN'		=> 'Wenn du diese Option aktivierst, dann kann sich „Extension Manager Plus“ bei der Aktion „Ausgewählte deaktivieren“ auch selbst deaktivieren, da diese Erweiterung dann wie jede andere ausgewählt werden kann.',
++	'EXTMGRPLUS_INSTRUCTIONS'				=> 'Anleitungen anzeigen',
++	'EXTMGRPLUS_INSTRUCTIONS_EXPLAIN'		=> 'Mit dieser Option kannst du festlegen, ob die Anleitungen für Installieren, Aktualisieren und Deinstallieren am Ende der Erweiterungen-Liste angezeigt werden sollen.',
+ 	'EXTMGRPLUS_VC_LIMIT'					=> 'Ausführungszeit der Versionsprüfung aufteilen',
+ 	'EXTMGRPLUS_VC_LIMIT_EXPLAIN'			=> 'Die Versionsprüfung wird blockweise ausgeführt und mit diesem Wert kannst du festlegen, wie lange ein einzelner Block der Versionsprüfung maximal dauern darf. Damit wird verhindert, dass Zeitlimits von PHP oder der Datenbank überschritten werden.',
+-	'EXTMGRPLUS_SETTING_LINKS'				=> 'Link zu den Einstellungen erzeugen',
+-	'EXTMGRPLUS_SETTING_LINKS_EXPLAIN'		=> 'Mit dieser Option kannst du festlegen, ob in der Spalte „Vorgänge“ ein Link zum primären Einstellungsmodul (sofern vorhanden) der jeweiligen Erweiterung eingefügt werden soll.',
+ 
+ 	// settings extension properties
+ 	'EXTMGRPLUS_SECTION_EXT_PROPERTIES'		=> 'Eigenschaften der Erweiterungen',
+@@ -67,9 +67,7 @@ $lang = array_merge($lang, [
+ 
+ 	// settings expert
+ 	'EXTMGRPLUS_SECTION_EXPERT_SETTINGS'	=> 'Experten-Einstellungen',
+-	'EXTMGRPLUS_EXPERT_SETTINGS_EXPLAIN'	=> 'Dieser Abschnitt ist unter anderem für Entwickler gedacht; hier können besondere Funktionen und Eigenschaften gesteuert werden. Bei Funktionen die problematisch sein können, muss eine Rückfrage bestätigt werden.',
+-	'EXTMGRPLUS_INSTRUCTIONS'				=> 'Anleitungen anzeigen',
+-	'EXTMGRPLUS_INSTRUCTIONS_EXPLAIN'		=> 'Mit dieser Option kannst du festlegen, ob die Anleitungen für Installieren, Aktualisieren und Deinstallieren am Ende der Erweiterungen-Liste angezeigt werden sollen.',
++	'EXTMGRPLUS_EXPERT_SETTINGS_EXPLAIN'	=> 'In diesem Abschnitt können besondere Funktionen aktiviert werden, die zum Beispiel für Entwickler relevant sind. Bei Funktionen die problematisch sein können, muss eine Rückfrage bestätigt werden.',
+ 	'EXTMGRPLUS_MIGRATION_COL'				=> 'Spalte mit neuen Migrationen anzeigen',
+ 	'EXTMGRPLUS_MIGRATION_COL_EXPLAIN'		=> 'Wenn diese Option aktiviert ist, dann wird eine zusätzliche Spalte angezeigt, in der die Anzahl neuer Migrationen aufgeführt ist. Die Anzahl wird sowohl bei „Deaktivierte Erweiterungen“ als auch bei „Nicht installierte Erweiterungen“ angezeigt.',
+ 	'EXTMGRPLUS_MIGRATIONS'					=> 'Erlaube Erweiterungen mit neuen Migrationen',
+@@ -80,7 +78,7 @@ $lang = array_merge($lang, [
+ 	// settings reset
+ 	'EXTMGRPLUS_SECTION_RESET'				=> 'Zurücksetzen',
+ 	'EXTMGRPLUS_DEFAULTS'					=> 'Einstellungen zurücksetzen',
+-	'EXTMGRPLUS_DEFAULTS_EXP'				=> 'Setzt alle Einstellungen auf den Installationsstandard zurück. Hat keine Auswirkung auf die Spalten von „Eigenschaften der Erweiterungen“.',
++	'EXTMGRPLUS_DEFAULTS_EXP'				=> 'Setzt alle Einstellungen auf den Installationsstandard zurück. (Hat keine Auswirkung auf die Spalten von „Eigenschaften der Erweiterungen“.)',
+ 	'EXTMGRPLUS_BUTTON_DEFAULTS'			=> 'Standard',
+ 
+ 	// messages
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/language/de_x_sie/acp_ext_mgr_plus.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/language/de_x_sie/acp_ext_mgr_plus.php"
+index 1dd219f66..40a173558 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/language/de_x_sie/acp_ext_mgr_plus.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/language/de_x_sie/acp_ext_mgr_plus.php"
+@@ -45,11 +45,11 @@ $lang = array_merge($lang, [
+ 	'EXTMGRPLUS_COL_WITH_VERSIONCHECK'		=> 'Mit Versionsprüfung',
+ 	'EXTMGRPLUS_COL_LAST_VERSIONCHECK'		=> 'Letzte Versionsprüfung',
+ 	'EXTMGRPLUS_COL_AVAILABLE_UPDATES'		=> 'Verfügbare Updates',
+-	'EXTMGRPLUS_AVAILABLE_EXTENSIONS'		=> [
++	'EXTMGRPLUS_AVAILABLE_EXTENSIONS' => [
+ 		0									=> '%2$u',
+ 		1									=> '%2$u (%1$u ungültige)',
+ 	],
+-	'EXTMGRPLUS_VERSIONCHECK_DATE'			=> [
++	'EXTMGRPLUS_VERSIONCHECK_DATE' => [
+ 		0									=> '%2$s (%3$u Sek.)',
+ 		1									=> '%2$s (%3$u Sek. / %1$u Fehler)',
+ 	],
+@@ -66,6 +66,7 @@ $lang = array_merge($lang, [
+ 	'EXTMGRPLUS_DEPENDENCY_EXPLAIN'			=> 'Mit einem vorangestelltem <code>+</code> kann eine Erweiterung mit einer Gruppe verknüpft werden. Hat man zum Beispiel die Erweiterung B die von Erweiterung A abhängig ist, kann man bei A <code>0</code> eintragen und bei B <code>+0</code>. Sind beide Erweiterungen aktiviert, wird beim Auswählen von A auch B ausgewählt. Sind beide Erweiterungen deaktiviert, wird beim Auswählen von B auch A ausgewählt.',
+ 	'EXTMGRPLUS_IGNORE'						=> '%s Ignorieren',
+ 	'EXTMGRPLUS_IGNORE_EXPLAIN'				=> 'In dieser Spalte können Sie festlegen, welche Erweiterungen bei den Aktionen „Ausgewählte aktivieren“ und „Ausgewählte deaktivieren“ ignoriert werden sollen. Ignorierte Erweiterungen können in der Erweiterungen-Liste nicht mehr ausgewählt werden und bei solchen Erweiterungen werden auch keine neuen Migrationen ermittelt und angezeigt. Wenn bei einer ignorierten Erweiterung eine Reihenfolge-Gruppe definiert wurde, dann bleibt diese erhalten, sie hat jedoch keine Bedeutung mehr.',
++	'EXTMGRPLUS_DETAILS_VERSION_URL'		=> 'Link zur Versionsdatei',
+ 
+ 	// ext manager
+ 	'EXTMGRPLUS_COL_CDB'					=> 'Validierte Erweiterung',
+@@ -89,22 +90,20 @@ $lang = array_merge($lang, [
+ 	'EXTMGRPLUS_TOOLTIP_SELECT'				=> 'Erweiterung auswählen.',
+ 	'EXTMGRPLUS_TOOLTIP_IS_LOCKED'			=> 'Die Auswahl dieser Erweiterung ist wegen neuer Migrationen gesperrt.',
+ 	// tooltips icons
+-	'EXTMGRPLUS_TOOLTIP_CDB_EXT'			=> 'Das ist eine validierte Erweiterung.',
+-	'EXTMGRPLUS_TOOLTIP_CDB_EXT_OFFICIAL'	=> 'Das ist eine offizielle Erweiterung von phpBB.com.',
++	'EXTMGRPLUS_TOOLTIP_CDB_EXT'			=> 'Diese Erweiterung wurde offiziell validiert.',
+ 	'EXTMGRPLUS_TOOLTIP_OUTDATED'			=> 'Die installierte Version dieser Erweiterung ist veraltet.',
+ 	'EXTMGRPLUS_TOOLTIP_VERSIONCHECK_ERROR'	=> 'Bei der Versionsprüfung ist ein Fehler aufgetreten. Klicken Sie auf „Details“ um mehr zu erfahren.',
+ 	'EXTMGRPLUS_TOOLTIP_VERSIONCHECK_EMPTY'	=> 'Bei dieser Erweiterung wurde keine Versionsprüfung ausgeführt.',
+ 	'EXTMGRPLUS_TOOLTIP_NO_VERSIONCHECK'	=> 'Diese Erweiterung bietet keine Versionsprüfung.',
+ 	'EXTMGRPLUS_TOOLTIP_IS_IGNORED'			=> 'Diese Erweiterung wird von „Extension Manager Plus“ ignoriert.',
+-	'EXTMGRPLUS_TOOLTIP_SETTINGS'			=> 'Das primäre Einstellungsmodul dieser Erweiterung aufrufen.',
+ 
+ 	// misc
+-	'EXTMGRPLUS_EXTENSION_PLURAL'			=> [
++	'EXTMGRPLUS_EXTENSION_PLURAL' => [
+ 		0									=> '0 Erweiterungen',
+ 		1									=> '1 Erweiterung',
+ 		2									=> '%u Erweiterungen',
+ 	],
+-	'EXTMGRPLUS_SECOND_PLURAL'				=> [
++	'EXTMGRPLUS_SECOND_PLURAL' => [
+ 		0									=> '0 Sekunden',
+ 		1									=> '1 Sekunde',
+ 		2									=> '%u Sekunden',
+@@ -112,8 +111,8 @@ $lang = array_merge($lang, [
+ 	'EXTMGRPLUS_SPOILER_LABEL'				=> 'Erklärung',
+ 
+ 	// details
++	'EXTMGRPLUS_SECTION_DETAILS'			=> 'Informationen von Extension Manager Plus',
+ 	'EXTMGRPLUS_DETAILS_CDB_PAGE'			=> 'Seite der phpBB-Erweiterungsdatenbank',
+-	'EXTMGRPLUS_DETAILS_VERSION_URL'		=> 'Link zur Versionsdatei',
+ 
+ 	// messages
+ 	'EXTMGRPLUS_MSG_CONFIRM_DISABLE'		=> 'Sind Sie sich sicher, dass Sie %s deaktivieren möchten?',
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/language/de_x_sie/acp_ext_mgr_plus_lang_author.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/language/de_x_sie/acp_ext_mgr_plus_lang_author.php"
+index 5268bebf0..bfe96ffad 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/language/de_x_sie/acp_ext_mgr_plus_lang_author.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/language/de_x_sie/acp_ext_mgr_plus_lang_author.php"
+@@ -42,7 +42,7 @@ if (empty($lang) || !is_array($lang))
+ $lang = array_merge($lang, [
+ 	// language pack author
+ 	'EXTMGRPLUS_LANG_DESC'					=> 'Deutsch (Sie)',
+-	'EXTMGRPLUS_LANG_VER'	 				=> '3.1.0',
++	'EXTMGRPLUS_LANG_VER'	 				=> '3.0.0',
+ 	'EXTMGRPLUS_LANG_AUTHOR'	 			=> 'LukeWCS',
+ 
+ 	// messages
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/language/de_x_sie/acp_ext_mgr_plus_settings.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/language/de_x_sie/acp_ext_mgr_plus_settings.php"
+index 5ac4aeaad..65c31075a 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/language/de_x_sie/acp_ext_mgr_plus_settings.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/language/de_x_sie/acp_ext_mgr_plus_settings.php"
+@@ -55,10 +55,10 @@ $lang = array_merge($lang, [
+ 	'EXTMGRPLUS_CHECKBOX_MODE_LAST'			=> 'Letzten Zustand merken',
+ 	'EXTMGRPLUS_SELF_DISABLE'				=> 'Erlaube Eigendeaktivierung',
+ 	'EXTMGRPLUS_SELF_DISABLE_EXPLAIN'		=> 'Wenn Sie diese Option aktivieren, dann kann sich „Extension Manager Plus“ bei der Aktion „Ausgewählte deaktivieren“ auch selbst deaktivieren, da diese Erweiterung dann wie jede andere ausgewählt werden kann.',
++	'EXTMGRPLUS_INSTRUCTIONS'				=> 'Anleitungen anzeigen',
++	'EXTMGRPLUS_INSTRUCTIONS_EXPLAIN'		=> 'Mit dieser Option können Sie festlegen, ob die Anleitungen für Installieren, Aktualisieren und Deinstallieren am Ende der Erweiterungen-Liste angezeigt werden sollen.',
+ 	'EXTMGRPLUS_VC_LIMIT'					=> 'Ausführungszeit der Versionsprüfung aufteilen',
+ 	'EXTMGRPLUS_VC_LIMIT_EXPLAIN'			=> 'Die Versionsprüfung wird blockweise ausgeführt und mit diesem Wert können Sie festlegen, wie lange ein einzelner Block der Versionsprüfung maximal dauern darf. Damit wird verhindert, dass Zeitlimits von PHP oder der Datenbank überschritten werden.',
+-	'EXTMGRPLUS_SETTING_LINKS'				=> 'Link zu den Einstellungen erzeugen',
+-	'EXTMGRPLUS_SETTING_LINKS_EXPLAIN'		=> 'Mit dieser Option können Sie festlegen, ob in der Spalte „Vorgänge“ ein Link zum primären Einstellungsmodul (sofern vorhanden) der jeweiligen Erweiterung eingefügt werden soll.',
+ 
+ 	// settings extension properties
+ 	'EXTMGRPLUS_SECTION_EXT_PROPERTIES'		=> 'Eigenschaften der Erweiterungen',
+@@ -67,9 +67,7 @@ $lang = array_merge($lang, [
+ 
+ 	// settings expert
+ 	'EXTMGRPLUS_SECTION_EXPERT_SETTINGS'	=> 'Experten-Einstellungen',
+-	'EXTMGRPLUS_EXPERT_SETTINGS_EXPLAIN'	=> 'Dieser Abschnitt ist unter anderem für Entwickler gedacht; hier können besondere Funktionen und Eigenschaften gesteuert werden. Bei Funktionen die problematisch sein können, muss eine Rückfrage bestätigt werden.',
+-	'EXTMGRPLUS_INSTRUCTIONS'				=> 'Anleitungen anzeigen',
+-	'EXTMGRPLUS_INSTRUCTIONS_EXPLAIN'		=> 'Mit dieser Option können Sie festlegen, ob die Anleitungen für Installieren, Aktualisieren und Deinstallieren am Ende der Erweiterungen-Liste angezeigt werden sollen.',
++	'EXTMGRPLUS_EXPERT_SETTINGS_EXPLAIN'	=> 'In diesem Abschnitt können besondere Funktionen aktiviert werden, die zum Beispiel für Entwickler relevant sind. Bei Funktionen die problematisch sein können, muss eine Rückfrage bestätigt werden.',
+ 	'EXTMGRPLUS_MIGRATION_COL'				=> 'Spalte mit neuen Migrationen anzeigen',
+ 	'EXTMGRPLUS_MIGRATION_COL_EXPLAIN'		=> 'Wenn diese Option aktiviert ist, dann wird eine zusätzliche Spalte angezeigt, in der die Anzahl neuer Migrationen aufgeführt ist. Die Anzahl wird sowohl bei „Deaktivierte Erweiterungen“ als auch bei „Nicht installierte Erweiterungen“ angezeigt.',
+ 	'EXTMGRPLUS_MIGRATIONS'					=> 'Erlaube Erweiterungen mit neuen Migrationen',
+@@ -80,7 +78,7 @@ $lang = array_merge($lang, [
+ 	// settings reset
+ 	'EXTMGRPLUS_SECTION_RESET'				=> 'Zurücksetzen',
+ 	'EXTMGRPLUS_DEFAULTS'					=> 'Einstellungen zurücksetzen',
+-	'EXTMGRPLUS_DEFAULTS_EXP'				=> 'Setzt alle Einstellungen auf den Installationsstandard zurück. Hat keine Auswirkung auf die Spalten von „Eigenschaften der Erweiterungen“.',
++	'EXTMGRPLUS_DEFAULTS_EXP'				=> 'Setzt alle Einstellungen auf den Installationsstandard zurück. (Hat keine Auswirkung auf die Spalten von „Eigenschaften der Erweiterungen“.)',
+ 	'EXTMGRPLUS_BUTTON_DEFAULTS'			=> 'Standard',
+ 
+ 	// messages
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/language/en/acp_ext_mgr_plus.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/language/en/acp_ext_mgr_plus.php"
+index 3a7b5da69..513e32034 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/language/en/acp_ext_mgr_plus.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/language/en/acp_ext_mgr_plus.php"
+@@ -45,11 +45,11 @@ $lang = array_merge($lang, [
+ 	'EXTMGRPLUS_COL_WITH_VERSIONCHECK'		=> 'With version checking',
+ 	'EXTMGRPLUS_COL_LAST_VERSIONCHECK'		=> 'Last version check',
+ 	'EXTMGRPLUS_COL_AVAILABLE_UPDATES'		=> 'Available updates',
+-	'EXTMGRPLUS_AVAILABLE_EXTENSIONS'		=> [
++	'EXTMGRPLUS_AVAILABLE_EXTENSIONS' => [
+ 		0									=> '%2$u',
+ 		1									=> '%2$u (%1$u invalid)',
+ 	],
+-	'EXTMGRPLUS_VERSIONCHECK_DATE'			=> [
++	'EXTMGRPLUS_VERSIONCHECK_DATE' => [
+ 		0									=> '%2$s (%3$u sec.)',
+ 		1									=> '%2$s (%3$u sec. / %1$u error)',
+ 		2									=> '%2$s (%3$u sec. / %1$u errors)',
+@@ -90,22 +90,20 @@ $lang = array_merge($lang, [
+ 	'EXTMGRPLUS_TOOLTIP_SELECT'				=> 'Select extension.',
+ 	'EXTMGRPLUS_TOOLTIP_IS_LOCKED'			=> 'The selection of this extension is blocked due to new migrations.',
+ 	// tooltips icons
+-	'EXTMGRPLUS_TOOLTIP_CDB_EXT'			=> 'This is a validated extension.',
+-	'EXTMGRPLUS_TOOLTIP_CDB_EXT_OFFICIAL'	=> 'This is an official extension from phpBB.com.',
++	'EXTMGRPLUS_TOOLTIP_CDB_EXT'			=> 'This extension has been officially validated.',
+ 	'EXTMGRPLUS_TOOLTIP_OUTDATED'			=> 'The installed version of this extension is out of date.',
+ 	'EXTMGRPLUS_TOOLTIP_VERSIONCHECK_ERROR'	=> 'An error occurred during the version check. Click on “Details” to find out more.',
+ 	'EXTMGRPLUS_TOOLTIP_VERSIONCHECK_EMPTY'	=> 'No version check was performed for this extension.',
+ 	'EXTMGRPLUS_TOOLTIP_NO_VERSIONCHECK'	=> 'This extension does not provide version checking.',
+ 	'EXTMGRPLUS_TOOLTIP_IS_IGNORED'			=> 'This extension is ignored by “Extension Manager Plus”.',
+-	'EXTMGRPLUS_TOOLTIP_SETTINGS'			=> 'Call the primary settings module of this extension.',
+ 
+ 	// misc
+-	'EXTMGRPLUS_EXTENSION_PLURAL'			=> [
++	'EXTMGRPLUS_EXTENSION_PLURAL' => [
+ 		0									=> '0 extensions',
+ 		1									=> '1 extension',
+ 		2									=> '%u extensions',
+ 	],
+-	'EXTMGRPLUS_SECOND_PLURAL'				=> [
++	'EXTMGRPLUS_SECOND_PLURAL' => [
+ 		0									=> '0 seconds',
+ 		1									=> '1 second',
+ 		2									=> '%u seconds',
+@@ -113,6 +111,7 @@ $lang = array_merge($lang, [
+ 	'EXTMGRPLUS_SPOILER_LABEL'				=> 'Explanation',
+ 
+ 	// details
++	'EXTMGRPLUS_SECTION_DETAILS'			=> 'Information from Extension Manager Plus',
+ 	'EXTMGRPLUS_DETAILS_CDB_PAGE'			=> 'phpBB extension database page',
+ 	'EXTMGRPLUS_DETAILS_VERSION_URL'		=> 'Link to version file',
+ 
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/language/en/acp_ext_mgr_plus_lang_author.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/language/en/acp_ext_mgr_plus_lang_author.php"
+index fcc65c224..fbb6de3a6 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/language/en/acp_ext_mgr_plus_lang_author.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/language/en/acp_ext_mgr_plus_lang_author.php"
+@@ -42,7 +42,7 @@ if (empty($lang) || !is_array($lang))
+ $lang = array_merge($lang, [
+ 	// language pack author
+ 	'EXTMGRPLUS_LANG_DESC'					=> 'English',
+-	'EXTMGRPLUS_LANG_VER' 					=> '3.1.0',
++	'EXTMGRPLUS_LANG_VER' 					=> '3.0.0',
+ 	'EXTMGRPLUS_LANG_AUTHOR'	 			=> 'LukeWCS',
+ 
+ 	// messages
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/language/en/acp_ext_mgr_plus_settings.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/language/en/acp_ext_mgr_plus_settings.php"
+index f7e93fa87..55b6e2b65 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/language/en/acp_ext_mgr_plus_settings.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/language/en/acp_ext_mgr_plus_settings.php"
+@@ -55,10 +55,10 @@ $lang = array_merge($lang, [
+ 	'EXTMGRPLUS_CHECKBOX_MODE_LAST'			=> 'Remember last state',
+ 	'EXTMGRPLUS_SELF_DISABLE'				=> 'Allow self-deactivation',
+ 	'EXTMGRPLUS_SELF_DISABLE_EXPLAIN'		=> 'If you enable this option, then “Extension Manager Plus” can also deactivate itself in the “Disable selected” action, since this extension can then be selected like any other.',
++	'EXTMGRPLUS_INSTRUCTIONS'				=> 'View instructions',
++	'EXTMGRPLUS_INSTRUCTIONS_EXPLAIN'		=> 'This option allows you to choose whether to display the install, update, and uninstall instructions at the end of the extensions list.',
+ 	'EXTMGRPLUS_VC_LIMIT'					=> 'Divide execution time of the version check',
+ 	'EXTMGRPLUS_VC_LIMIT_EXPLAIN'			=> 'The version check is executed in blocks and with this value you can specify the maximum length of a single block of the version check. This prevents PHP or database time limits from being exceeded.',
+-	'EXTMGRPLUS_SETTING_LINKS'				=> 'Create a link to the settings',
+-	'EXTMGRPLUS_SETTING_LINKS_EXPLAIN'		=> 'With this option you can specify whether a link to the primary settings module (if available) of the respective extension should be inserted in the “Actions” column.',
+ 
+ 	// settings extension properties
+ 	'EXTMGRPLUS_SECTION_EXT_PROPERTIES'		=> 'Extension properties',
+@@ -67,9 +67,7 @@ $lang = array_merge($lang, [
+ 
+ 	// settings expert
+ 	'EXTMGRPLUS_SECTION_EXPERT_SETTINGS'	=> 'Expert settings',
+-	'EXTMGRPLUS_EXPERT_SETTINGS_EXPLAIN'	=> 'This section is intended, among other things, for developers; special functions and properties can be controlled here. For functions that may be problematic, a confirmation prompt will be required.',
+-	'EXTMGRPLUS_INSTRUCTIONS'				=> 'View instructions',
+-	'EXTMGRPLUS_INSTRUCTIONS_EXPLAIN'		=> 'This option allows you to choose whether to display the install, update, and uninstall instructions at the end of the extensions list.',
++	'EXTMGRPLUS_EXPERT_SETTINGS_EXPLAIN'	=> 'In this section, special functions can be activated that are relevant for developers, for example. For functions that could be problematic, a query must be confirmed.',
+ 	'EXTMGRPLUS_MIGRATION_COL'				=> 'Show column with new migrations',
+ 	'EXTMGRPLUS_MIGRATION_COL_EXPLAIN'		=> 'If this option is enabled, then an additional column is displayed in which the number of new migrations is listed. The number is displayed for both “Disabled Extensions” and “Not installed extensions”.',
+ 	'EXTMGRPLUS_MIGRATIONS'					=> 'Allow extensions with new migrations',
+@@ -80,7 +78,7 @@ $lang = array_merge($lang, [
+ 	// settings reset
+ 	'EXTMGRPLUS_SECTION_RESET'				=> 'Reset',
+ 	'EXTMGRPLUS_DEFAULTS'					=> 'Reset settings',
+-	'EXTMGRPLUS_DEFAULTS_EXP'				=> 'Resets all settings to the installation default. Has no effect on the “Extension properties” columns.',
++	'EXTMGRPLUS_DEFAULTS_EXP'				=> 'Resets all settings to the installation default. (Has no effect on the “Extension Properties” columns.)',
+ 	'EXTMGRPLUS_BUTTON_DEFAULTS'			=> 'Defaults',
+ 
+ 	// messages
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/migrations/v_3_1_0.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/migrations/v_3_1_0.php"
+deleted file mode 100644
+index 62bfc0f9c..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/migrations/v_3_1_0.php"
++++ /dev/null
+@@ -1,29 +0,0 @@
+-<?php
+-/**
+-*
+-* Extension Manager Plus. An extension for the phpBB Forum Software package.
+-*
+-* @copyright (c) 2022, LukeWCS, https://www.wcsaga.org
+-* @license GNU General Public License, version 2 (GPL-2.0-only)
+-*
+-* Note: This extension is 100% genuine handcraft and consists of selected
+-*       natural raw materials. There was no AI involved in making it.
+-*
+-*/
+-
+-namespace lukewcs\extmgrplus\migrations;
+-
+-class v_3_1_0 extends \phpbb\db\migration\migration
+-{
+-	public static function depends_on()
+-	{
+-		return ['\lukewcs\extmgrplus\migrations\v_3_0_0'];
+-	}
+-
+-	public function update_data()
+-	{
+-		return [
+-			['config.add', ['extmgrplus_switch_settings_link', 1]],
+-		];
+-	}
+-}
diff --git "[FORUM_EXT]/lukewcs\\extmgrplus/diff_nospace.tmp" "[FORUM_EXT]/lukewcs\\extmgrplus/diff_nospace.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/lukewcs\\extmgrplus/diff_nospace.tmp"
@@ -0,0 +1,6676 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/acp/settings_module.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/acp/settings_module.php"
+index b9c7958c3..f0be963f2 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/acp/settings_module.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/acp/settings_module.php"
+@@ -15,9 +15,9 @@ namespace lukewcs\extmgrplus\acp;
+ 
+ class settings_module
+ {
+-	public string $page_title;
+-	public string $tpl_name;
+-	public string $u_action;
++	public $page_title;
++	public $tpl_name;
++	public $u_action;
+ 
+ 	public function main()
+ 	{
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus.css" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus.css"
+index d5f7a1824..c632316bb 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus.css"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus.css"
+@@ -1,234 +1,185 @@
+-/* GENERAL >>> */
++/* GENERAL */
+ 
+-button[type="submit"]:is([name="confirm"], [name="cancel"]),
+-input:is([type="submit"], [type="button"], [type="reset"])[name^="extmgrplus_"] {
+-	padding: 3px 4px;
++fieldset {
++	border-radius: 5px;
+ }
+ 
+-code {
+-	background-color: #dddddd;
+-	padding: 0 0.25em;
+-	color: black;
++fieldset p.submit-buttons {
++	margin-top: 0;
++	padding: 0 4px 4px 4px;
+ }
+ 
+-.emp_inactive {
+-	opacity: 0.5;
++fieldset dt label,
++fieldset dd label {
++	cursor: inherit;
+ }
+ 
+-.emp_unavailable {
+-	opacity: 0.3;
++legend {
++	background: inherit;
++	margin: 2px 0 0 -11px;
++	border-top: inherit;
++	border-left: inherit;
++	border-radius: 5px 5px 0 0;
++	padding: 2px 10px;
++	top: 0;
+ }
+ 
+-.errorbox {
+-	&.emp_warning {
+-		background-color: #ffaa00;
+-
+-		& :is(a, a:visited) {
+-			color: #505050;
++input[type="submit"][name="confirm"],
++input[type="submit"][name^="extmgrplus_"],
++input[type="button"][name^="extmgrplus_"],
++input[type="reset"][name^="extmgrplus_"] {
++	padding: 3px 4px;
+ }
+ 
+-		& :is(h3, p, a:hover) {
+-			color: #303030;
+-		}
++code {
++	background-color: #dddddd;
++	padding: 0 0.25em;
++	color: black;
+ }
+ 
+-	&.emp_success_error {
+-		background: linear-gradient(#228822, #bc2a4d);
+-	}
++.inactive {
++	opacity: 0.5;
+ }
+ 
++/* Footer */
++
+ .extmgrplus_footer {
+ 	margin-top: 1em;
+ 	text-align: center;
+ 	font-size: 0.75em;
+ }
+ 
+-#confirm {
+ /* confirm_box (phpBB)*/
+ 
+-	& h2 {
++#confirm h2 {
+ 	margin-bottom: 0.25em;
+ }
+ 
+-	& :is(.button1, .button2) {
+-		color: #000000;
+-		background: linear-gradient(to bottom, #d2d2d2 0%, #efefef 100%);
+-		border: 1px solid #666666;
+-		font-size: 0.85em;
+-		font-family: "Lucida Grande", Verdana, Helvetica, Arial, sans-serif;
+-		vertical-align: middle;
+-
+-		&:hover {
+-			border: 1px solid #bc2a4d;
+-			background: #efefef url("../../../../../adm/images/bg_button.gif") repeat bottom;
+-			color: #bc2a4d;
+-		}
+-	}
+-
+-	& .button1 {
+-		font-weight: bold;
+-	}
+-}
+-
+-/* <<< GENERAL */
+-
+-/* SETTINGS >>> */
+-
+-fieldset {
+-	border-radius: 5px;
+-
+-	& p.submit-buttons {
+-		margin-top: 0;
+-		padding: 0 4px 4px 4px;
+-	}
+-
+-	& :is(dt, dd) label {
+-		cursor: inherit;
+-	}
+-
+-	& dd a {
+-		overflow-wrap: anywhere;
+-	}
+-}
+-
+-legend {
+-	background: inherit;
+-	margin: 2px 0 0 -11px;
+-	border-top: inherit;
+-	border-left: inherit;
+-	border-radius: 5px 5px 0 0;
+-	padding: 2px 10px;
+-	top: 0;
+-
+-	& + .legend_explain {
+-		width: 45%;
+-	}
++/* SETTINGS */
+ 
+-	&.legend_sub {
++legend.legend_sub {
+ 	border: 0;
+ 	margin: 1em 0;
+ 	padding: 0;
+ 	display: flex;
+ 	white-space: nowrap;
++}
+ 
+-		&:after {
++legend.legend_sub:after {
+ 	content: "";
+ 	border-bottom: 1px solid #cccccc;
+ 	width: 100%;
+ 	margin: 0 0 0.5em 1em;
+ }
+-	}
+-}
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
++
++.toggle:checked:before {
++	left: 2px;
++	content: "\f00c";
+ }
+ 
+-div.lukewcs_confirmbox {
+ /* LukeWCSphpBBConfirmBox */
+ 
++div[id$="_confirmbox"] {
+ 	max-width: 450px;
+ 	border: 2px solid skyblue;
+ 	margin: 0.75em 0.5em;
+ 	padding: 0.25em 0.5em;
+ 	border-radius: 5px;
++	-webkit-box-shadow: 2px 2px 10px 1px rgba(121, 162, 179, 0.5);
+ 	box-shadow: 2px 2px 10px 1px rgba(121, 162, 179, 0.5);
++}
+ 
+-	& h2 {
++div[id$="_confirmbox"] h2 {
+ 	margin: 0 0 0.25em 0;
+ }
+ 
+-	& p:last-of-type {
++div[id$="_confirmbox"] p:nth-of-type(2) {
+ 	text-align: center;
+ 	margin: 0;
+ 	padding: 0 4px 4px 4px;
+ }
+ 
+-	& input[type="button"] {
++div[id$="_confirmbox"] input[type="button"] {
+ 	padding: 3px 4px;
+ }
+-}
+ 
+-input:is([type="submit"], [type="button"]):disabled,
+-input.lukewcs_confirmbox_active {
++input[type="submit"]:disabled,
++input[type="button"]:disabled,
++input.confirmbox_active {
+ 	opacity: 0.5;
+ 	cursor: not-allowed;
+ }
+ 
+-/* <<< SETTINGS */
+-
+-/* EXTENSION MANAGER >>> */
++/* EXTENSION MANAGER */
+ 
+ .js_link {
+ 	color: #105289;
++}
+ 
+-	&:hover {
++.js_link:hover {
+ 	color: #bc2a4d;
+ 	text-decoration: underline;
+ 	cursor: pointer;
+ }
+ 
+-	&.disabled,
+-	&.disabled:hover {
++.js_link.disabled,
++.js_link.disabled:hover {
+ 	color: #536482;
+ 	text-decoration: none;
+ 	cursor: not-allowed;
+ 	opacity: 0.5;
+ }
+-}
+ 
+-table :is(th, td) i.icon,
+-fieldset dd i.icon {
+-	cursor: help;
++fieldset.quick a i.icon,
++.js_link i.icon {
++	margin: 0 0.3em 0 0;
++	font-size: 1.1em;
+ }
+ 
+ div.successbox i.icon,
+@@ -241,12 +192,6 @@ div.successbox.notice i.icon {
+ 	font-size: 1.2em;
+ }
+ 
+-fieldset.quick a i.icon,
+-.js_link i.icon {
+-	margin: 0 0.3em 0 0;
+-	font-size: 1.1em;
+-}
+-
+ fieldset.ext_properties i.icon,
+ thead th i.icon {
+ 	font-size: 1.1em;
+@@ -255,109 +200,107 @@ thead th i.icon {
+ 
+ fieldset.ext_properties dd {
+ 	color: inherit;
++}
+ 
+-	& label {
++fieldset.ext_properties dd label {
+ 	font-size: inherit;
+ 	font-weight: bold;
++}
+ 
+-		&:hover {
++fieldset.ext_properties dd label:hover {
+ 	color: inherit;
+ }
+-	}
+ 
+-	& details {
++fieldset.ext_properties dd details {
+ 	border: 1px solid #cccccc;
+ 	border-radius: 3px;
++}
+ 
+-		& summary {
++fieldset.ext_properties dd summary {
+ 	padding: 0.25em 0.5em;
+ 	cursor: pointer;
+ 	-webkit-user-select: none;
+-			user-select: none;
++	-moz-user-select: none;
++	-ms-user-select: none;
+ }
+ 
+-		& div {
++fieldset.ext_properties dd details div {
+ 	border-top: 1px solid #cccccc;
+ 	font-size: inherit;
+ 	padding: 0.25em 0;
+ 	margin: 0 0.5em;
+ }
+-	}
+-}
+ 
+-#extmgrplus_list {
+-	& input[type="checkbox"]:disabled {
++input[type="checkbox"]:disabled {
+ 	cursor: not-allowed;
+ }
+ 
+-	& input[name$="able_all"] {
+-		padding: 1px 3px;
+-		font-size: inherit;
++#extmgrplus_list input[name$="able_all"] {
++	padding: 1px 5px;
+ }
+ 
+-	& input[type="text"] {
++#extmgrplus_list input[type="text"] {
+ 	text-align: right;
+ 	padding: 0 2px;
+ 	margin: 0 2px;
+ 	background-color: #f9f9f9;
+ }
+ 
+-	& th:nth-of-type(1) {
++#extmgrplus_list th:nth-of-type(1) {
+ 	width: 1%;
+ }
+ 
+-	& th:nth-of-type(3) {
++#extmgrplus_list th:nth-of-type(3) {
+ 	width: 16%;
+ }
+ 
+-	& th:nth-of-type(1n+3) {
++#extmgrplus_list th:nth-of-type(1n+3) {
+ 	text-align: center;
+ }
+ 
+-	& th:nth-of-type(4) {
++#extmgrplus_list th:nth-of-type(4) {
+ 	width: 1%;
+ }
+ 
+-	& th:nth-of-type(5) {
++#extmgrplus_list th:nth-of-type(5) {
+ 	width: 10%;
+ }
+ 
+-	& th:nth-of-type(6) {
++#extmgrplus_list th:nth-of-type(6) {
+ 	width: 25%;
+ }
+ 
+-	& th:nth-of-type(1n+7) {
++#extmgrplus_list th:nth-of-type(1n+7) {
+ 	width: 1%;
+ }
+ 
+-	& td:nth-of-type(3) i.icon {
+-		font-size: 1.2em;
++#extmgrplus_list td:nth-of-type(1) i.icon {
++	cursor: help;
+ }
+ 
+-	& td:nth-of-type(3) :is(span, strong, i.icon) + :is(strong, i.icon) {
+-		margin-left: 0.3em;
++#extmgrplus_list td:nth-of-type(3) i.icon {
++	cursor: help;
++	font-size: 1.2em;
+ }
+ 
+-	& td:nth-of-type(3) i.icon:is(.fa-question-circle, .fa-exclamation-triangle) {
++#extmgrplus_list td:nth-of-type(3) i.icon:is(.fa-question-circle, .fa-exclamation-triangle, .fa-refresh) {
+ 	color: #df950d;
+ }
+ 
+-	& td:nth-of-type(1n+3) {
++#extmgrplus_list td:nth-of-type(1n+3) {
+ 	text-align: center;
+ }
+ 
+-	& td:nth-of-type(4) span {
++#extmgrplus_list td:nth-of-type(4) span {
+ 	cursor: help;
+ }
+ 
+-	& td:nth-of-type(7) i.icon {
++#extmgrplus_list td:nth-of-type(7) i.icon {
++	cursor: help;
+ 	font-size: 1.3em;
+ }
+-}
+-
+-/* <<< EXTENSION MANAGER */
+ 
+-/* VERSIONCHECK PROGGRESS >>> */
++/* VERSIONCHECK PROGGRESS */
+ 
+ .progress_container {
+ 	background-color: #f9f9f9;
+@@ -365,14 +308,15 @@ fieldset.ext_properties dd {
+ 	border-radius: 5px;
+ 	position: relative;
+ 	margin: 1em 0 0.25em 0;
++}
+ 
+-	& .progress_bar {
++.progress_bar {
+ 	background-color: lightgreen;
+ 	height: 100%;
+ 	border-radius: 5px;
+ }
+ 
+-	& .progress_value {
++.progress_value {
+ 	color: black;
+ 	position: absolute;
+ 	font-size: 0.85em;
+@@ -381,13 +325,12 @@ fieldset.ext_properties dd {
+ 	right: 0;
+ }
+ 
+-	& .progress_anim {
++.progress_anim {
+ 	background-color: lightblue;
+ 	animation-name: progress_anim_block;
+ 	animation-timing-function: linear;
+ 	animation-fill-mode: forwards;
+ }
+-}
+ 
+ @keyframes progress_anim_block {
+ 	from {
+@@ -399,18 +342,12 @@ fieldset.ext_properties dd {
+ 	}
+ }
+ 
+-/* <<< VERSIONCHECK PROGGRESS */
+-
+-/* RESPONSIVE >>> */
++/* RESPONSIVE */
+ 
+ @media (max-width: 700px){
+ 	legend {
+ 		margin: 2px 0 0 -6px;
+ 		padding: 2px 5px;
+-
+-		& + .legend_explain {
+-			width: auto;
+-		}
+ 	}
+ 
+ 	#extmgrplus_settings dd {
+@@ -421,5 +358,3 @@ fieldset.ext_properties dd {
+ 		padding: 0.5em 0 0 0;
+ 	}
+ }
+-
+-/* <<< RESPONSIVE */
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_acp_ext_details.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_acp_ext_details.html"
+deleted file mode 100644
+index 830d87306..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_acp_ext_details.html"
++++ /dev/null
+@@ -1,180 +0,0 @@
+-{#
+-*
+-* Extension Manager Plus. An extension for the phpBB Forum Software package.
+-*
+-* @copyright (c) 2022, LukeWCS, https://www.wcsaga.org
+-* @license GNU General Public License, version 2 (GPL-2.0-only)
+-*
+-* Note: This extension is 100% genuine handcraft and consists of selected
+-*       natural raw materials. There was no AI involved in making it.
+-*
+-#}
+-
+-{% import '@lukewcs_extmgrplus/acp_ext_mgr_plus_macros.html' as common %}
+-
+-{% INCLUDE 'overall_header.html' %}
+-
+-<a href="{{ U_BACK }}" style="float: {{ S_CONTENT_FLOW_END }};">&laquo; {{ lang('BACK') }}</a>
+-
+-<h1>{{ lang('EXTENSIONS_ADMIN') }}</h1>
+-
+-<p>{{ lang('EXTENSIONS_EXPLAIN') }}</p>
+-
+-{% if S_VERSIONCHECK %}
+-	{% if S_VERSIONCHECK_FAIL %}
+-		<div class="errorbox notice">
+-			<p>{{ lang('VERSIONCHECK_FAIL') }}</p>
+-			<p>{{ VERSIONCHECK_FAIL_REASON }}</p>
+-			<p><a href="{{ U_VERSIONCHECK_FORCE }}">{{ lang('VERSIONCHECK_FORCE_UPDATE') }}</a></p>
+-		</div>
+-	{% else %}
+-		<div class="{% if S_UP_TO_DATE %}successbox{% else %}errorbox{% endif %}">
+-			<p>{{ UP_TO_DATE_MSG }} - <a href="{{ U_VERSIONCHECK_FORCE }}">{{ lang('VERSIONCHECK_FORCE_UPDATE') }}</a></p>
+-		</div>
+-	{% endif %}
+-{% endif %}
+-
+-{% EVENT acp_ext_details_notice %}
+-
+-<fieldset>
+-	<legend>{{ lang('EXT_DETAILS') }}</legend>
+-
+-	{% if META_DISPLAY_NAME %}
+-		<dl>
+-			<dt><label>{{ lang('DISPLAY_NAME') ~ lang('COLON') }}</label></dt>
+-			<dd>
+-				{{ EXTMGRPLUS_DETAILS.cdb_ext ? {
+-					1:	common.icon('fa-database', 'EXTMGRPLUS_TOOLTIP_CDB_EXT'),
+-					2:	common.icon('fa-star', 'EXTMGRPLUS_TOOLTIP_CDB_EXT_OFFICIAL'),
+-				}[EXTMGRPLUS_DETAILS.cdb_ext] }}
+-				<strong id="meta_display_name">{{ META_DISPLAY_NAME }}</strong>
+-			</dd>
+-		</dl>
+-	{% endif %}
+-	<dl>
+-		<dt><label>{{ lang('CLEAN_NAME') ~ lang('COLON') }}</label></dt>
+-		<dd><strong id="meta_name">{{ META_NAME }}</strong></dd>
+-	</dl>
+-	{% if META_DESCRIPTION %}
+-		<dl>
+-			<dt><label>{{ lang('DESCRIPTION') ~ lang('COLON') }}</label></dt>
+-			<dd><span id="meta_description">{{ META_DESCRIPTION }}</span></dd>
+-		</dl>
+-	{% endif %}
+-	<dl>
+-		<dt><label>{{ lang('VERSION') ~ lang('COLON') }}</label></dt>
+-		<dd><span id="meta_version">{{ META_VERSION }}</span></dd>
+-	</dl>
+-	{% if META_HOMEPAGE && META_HOMEPAGE != EXTMGRPLUS_DETAILS.cdb_page %}
+-		<dl>
+-			<dt><label>{{ lang('HOMEPAGE') ~ lang('COLON') }}</label></dt>
+-			<dd><strong id="meta_homepage"><a href="{{ META_HOMEPAGE }}">{{ META_HOMEPAGE }}</a></strong></dd>
+-		</dl>
+-	{% endif %}
+-	{% if EXTMGRPLUS_DETAILS.cdb_page %}
+-		<dl>
+-			<dt><label>{{ lang('EXTMGRPLUS_DETAILS_CDB_PAGE') ~ lang('COLON') }}</label></dt>
+-			<dd><strong><a href="{{ EXTMGRPLUS_DETAILS.cdb_page }}">{{ EXTMGRPLUS_DETAILS.cdb_page }}</a></strong></dd>
+-		</dl>
+-	{% endif %}
+-	{% if EXTMGRPLUS_DETAILS.version_url %}
+-		<dl>
+-			<dt><label>{{ lang('EXTMGRPLUS_DETAILS_VERSION_URL') ~ lang('COLON') }}</label></dt>
+-			<dd><strong><a href="{{ EXTMGRPLUS_DETAILS.version_url }}">{{ EXTMGRPLUS_DETAILS.version_url }}</a></strong></dd>
+-		</dl>
+-	{% endif %}
+-	{% if META_TIME %}
+-		<dl>
+-			<dt><label>{{ lang('TIME') ~ lang('COLON') }}</label></dt>
+-			<dd><span id="meta_time">{{ META_TIME }}</span></dd>
+-		</dl>
+-	{% endif %}
+-	<dl>
+-		<dt><label>{{ lang('LICENSE') ~ lang('COLON') }}</label></dt>
+-		<dd><span id="meta_license">{{ META_LICENSE }}</span></dd>
+-	</dl>
+-</fieldset>
+-
+-{% if S_VERSIONCHECK && !S_UP_TO_DATE %}
+-	<fieldset>
+-		<legend>{{ lang('LATEST_VERSION') }}</legend>
+-
+-		{% for updates_available in loops.updates_available %}
+-			<fieldset>
+-				<dl>
+-					<dt><label>{{ lang('VERSION') ~ lang('COLON') }}</label></dt>
+-					<dd><strong>{{ updates_available.current }}</strong></dd>
+-				</dl>
+-				{% if updates_available.download %}
+-					<dl>
+-						<dt><label>{{ lang('DOWNLOAD_LATEST') }}</label></dt>
+-						<dd><strong><a href="{{ updates_available.download }}">{{ lang('DOWNLOAD') }} {{ META_NAME }} {{ LATEST_VERSION }}</a></strong></dd>
+-					</dl>
+-				{% endif %}
+-				{% if updates_available.announcement %}
+-					<dl>
+-						<dt><label>{{ lang('ANNOUNCEMENT_TOPIC') }}</label></dt>
+-						<dd><strong><a href="{{ updates_available.announcement }}">{{ lang('RELEASE_ANNOUNCEMENT') }}</a></strong></dd>
+-					</dl>
+-				{% endif %}
+-			</fieldset>
+-		{% endfor %}
+-	</fieldset>
+-{% endif %}
+-
+-{% if META_REQUIRE_PHPBB || META_REQUIRE_PHP %}
+-	<fieldset>
+-		<legend>{{ lang('REQUIREMENTS') }}</legend>
+-
+-		{% if META_REQUIRE_PHPBB %}
+-			<dl{% if META_REQUIRE_PHPBB_FAIL %} class="requirements_not_met"{% endif %}>
+-				<dt><label>{{ lang('PHPBB_VERSION') ~ lang('COLON') }}</label></dt>
+-				<dd><span id="require_phpbb">{{ META_REQUIRE_PHPBB }}</span></dd>
+-			</dl>
+-		{% endif %}
+-		{% if META_REQUIRE_PHP %}
+-			<dl{% if META_REQUIRE_PHP_FAIL %} class="requirements_not_met"{% endif %}>
+-				<dt><label>{{ lang('PHP_VERSION') ~ lang('COLON') }}</label></dt>
+-				<dd><span id="require_php">{{ META_REQUIRE_PHP }}</span></dd>
+-			</dl>
+-		{% endif %}
+-	</fieldset>
+-{% endif %}
+-
+-<fieldset>
+-	<legend>{{ lang('AUTHOR_INFORMATION') }}</legend>
+-
+-	{% for meta_authors in loops.meta_authors %}
+-		<fieldset>
+-			<dl>
+-				<dt><label>{{ lang('AUTHOR_NAME') ~ lang('COLON') }}</label></dt>
+-				<dd><strong>{{ meta_authors.AUTHOR_NAME }}</strong></dd>
+-			</dl>
+-			{% if meta_authors.AUTHOR_EMAIL %}
+-				<dl>
+-					<dt><label>{{ lang('AUTHOR_EMAIL') ~ lang('COLON') }}</label></dt>
+-					<dd><strong><a href="mailto:{{ meta_authors.AUTHOR_EMAIL }}">{{ meta_authors.AUTHOR_EMAIL }}</a></strong></dd>
+-				</dl>
+-			{% endif %}
+-			{% if meta_authors.AUTHOR_HOMEPAGE %}
+-				<dl>
+-					<dt><label>{{ lang('AUTHOR_HOMEPAGE') ~ lang('COLON') }}</label></dt>
+-					<dd><strong><a href="{{ meta_authors.AUTHOR_HOMEPAGE }}">{{ meta_authors.AUTHOR_HOMEPAGE }}</a></strong></dd>
+-				</dl>
+-			{% endif %}
+-			{% if meta_authors.AUTHOR_ROLE %}
+-				<dl>
+-					<dt><label>{{ lang('AUTHOR_ROLE') ~ lang('COLON') }}</label></dt>
+-					<dd><strong>{{ meta_authors.AUTHOR_ROLE }}</strong></dd>
+-				</dl>
+-			{% endif %}
+-		</fieldset>
+-	{% endfor %}
+-</fieldset>
+-
+-{% EVENT acp_ext_details_end %}
+-
+-{{ common.footer(EXTMGRPLUS_METADATA) }}
+-
+-{% INCLUDE 'overall_footer.html' %}
+-{% INCLUDECSS '@lukewcs_extmgrplus/acp_ext_mgr_plus.css' %}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_acp_ext_list.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_acp_ext_list.html"
+index ff8f88ca8..14224a0d1 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_acp_ext_list.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_acp_ext_list.html"
+@@ -25,6 +25,8 @@
+ 	CHECKBOX_LAST	: 2,
+ } %}
+ 
++<a id="maincontent"></a>
++
+ <h1>{{ lang('EXTENSIONS_ADMIN') }}</h1>
+ 
+ <p>{{ lang('EXTENSIONS_EXPLAIN') }}</p>
+@@ -88,7 +90,7 @@
+ 		<fieldset class="ext_properties" style="display: none;">
+ 			<legend>{{ lang('EXTMGRPLUS_SECTION_SETTINGS') }}</legend>
+ 
+-			<dl{{ !EXTMGRPLUS_SWITCH_ORDER_AND_IGNORE ? ' class="emp_inactive"' }}>
++			<dl{{ !EXTMGRPLUS_SWITCH_ORDER_AND_IGNORE ? ' class="inactive"' }}>
+ 				<dt>
+ 					<label>{{ lang('EXTMGRPLUS_ORDER', common.icon('fa-sort')) ~ lang('COLON') }}</label><br>
+ 				</dt>
+@@ -104,7 +106,7 @@
+ 				</dd>
+ 			</dl>
+ 
+-			<dl{{ !EXTMGRPLUS_SWITCH_ORDER_AND_IGNORE ? ' class="emp_inactive"' }}>
++			<dl{{ !EXTMGRPLUS_SWITCH_ORDER_AND_IGNORE ? ' class="inactive"' }}>
+ 				<dt>
+ 					<label>{{ lang('EXTMGRPLUS_IGNORE', common.icon('fa-ban')) ~ lang('COLON') }}</label><br>
+ 				</dt>
+@@ -136,8 +138,8 @@
+ 		</colgroup>
+ 		<thead>
+ 			<tr>
+-				<th>
+-					{{ common.icon('fa-database', 'EXTMGRPLUS_COL_CDB') }}<span style="display: none;">{{ lang('EXTMGRPLUS_COL_CDB') }}</span>
++				<th title="{{ lang('EXTMGRPLUS_COL_CDB') }}">
++					{{ common.icon('fa-database') }}<span style="display: none;">{{ lang('EXTMGRPLUS_COL_CDB') }}</span>
+ 				</th>
+ 				<th>
+ 					{{ lang('EXTENSION_NAME') }}
+@@ -145,8 +147,8 @@
+ 				<th>
+ 					{{ lang('CURRENT_VERSION') }}
+ 				</th>
+-				<th{{ !EXTMGRPLUS_SWITCH_MIGRATION_COL ? ' style="display: none;"' }}>
+-					{{ common.icon('fa-arrow-up', 'EXTMGRPLUS_COL_MIGRATIONS') }}<span style="display: none;">{{ lang('EXTMGRPLUS_COL_MIGRATIONS') }}</span>
++				<th{{ !EXTMGRPLUS_SWITCH_MIGRATION_COL ? ' style="display: none;"' }} title="{{ lang('EXTMGRPLUS_COL_MIGRATIONS') }}">
++					{{ common.icon('fa-arrow-up') }}<span style="display: none;">{{ lang('EXTMGRPLUS_COL_MIGRATIONS') }}</span>
+ 				</th>
+ 				<th>
+ 					{{ lang('EXTENSION_OPTIONS') }}
+@@ -154,14 +156,14 @@
+ 				<th>
+ 					{{ lang('EXTENSION_ACTIONS') }}
+ 				</th>
+-				<th>
+-					{{ common.icon('fa-check', 'EXTMGRPLUS_COL_SELECT') }}<span style="display: none;">{{ lang('EXTMGRPLUS_COL_SELECT') }}</span>
++				<th title="{{ lang('EXTMGRPLUS_COL_SELECT') }}">
++					{{ common.icon('fa-check') }}<span style="display: none;">{{ lang('EXTMGRPLUS_COL_SELECT') }}</span>
+ 				</th>
+-				<th style="display: none;">
+-					{{ common.icon('fa-sort', 'EXTMGRPLUS_COL_ORDER') }}<span style="display: none;">{{ lang('EXTMGRPLUS_COL_ORDER') }}</span>
++				<th title="{{ lang('EXTMGRPLUS_COL_ORDER') }}" style="display: none;">
++					{{ common.icon('fa-sort') }}<span style="display: none;">{{ lang('EXTMGRPLUS_COL_ORDER') }}</span>
+ 				</th>
+-				<th style="display: none;">
+-					{{ common.icon('fa-ban', 'EXTMGRPLUS_COL_IGNORE') }}<span style="display: none;">{{ lang('EXTMGRPLUS_COL_IGNORE') }}</span>
++				<th title="{{ lang('EXTMGRPLUS_COL_IGNORE') }}" style="display: none;">
++					{{ common.icon('fa-ban') }}<span style="display: none;">{{ lang('EXTMGRPLUS_COL_IGNORE') }}</span>
+ 				</th>
+ 			</tr>
+ 		</thead>
+@@ -207,10 +209,11 @@
+ 					{% set vc_obj = EXTMGRPLUS_LIST_VERSIONCHECK[ext.NAME] ?? {} %}
+ 					<tr class="ext_{{ list }} row-highlight">
+ 						<td>
+-							{{ vc_obj.cdb_ext ? {
+-								1:	common.icon('fa-database', 'EXTMGRPLUS_TOOLTIP_CDB_EXT'),
+-								2:	common.icon('fa-star', 'EXTMGRPLUS_TOOLTIP_CDB_EXT_OFFICIAL'),
+-							}[vc_obj.cdb_ext] }}
++							{% apply spaceless %}
++							{% if vc_obj.cdb_ext === true %}
++								<span title="{{ lang('EXTMGRPLUS_TOOLTIP_CDB_EXT')|e('html') }}">{{ common.icon('fa-database') }}</span>
++							{% endif %}
++							{% endapply %}
+ 						</td>
+ 						<td>
+ 							{% apply spaceless %}
+@@ -233,14 +236,14 @@
+ 									<strong class="{{ vc_obj.current == 'NOUPD' ? 'current-ext' : 'outdated-ext' }}">{{ ext.META_VERSION }}</strong>
+ 								{% endif %}
+ 								{% if vc_obj.current === false %}
+-									{{ common.icon('fa-chain-broken', 'EXTMGRPLUS_TOOLTIP_NO_VERSIONCHECK') }}
++									<span title="{{ lang('EXTMGRPLUS_TOOLTIP_NO_VERSIONCHECK')|e('html') }}">&nbsp;{{ common.icon('fa-chain-broken') }}</span>
+ 								{% elseif vc_obj.current == 'ERROR' %}
+-									{{ common.icon('fa-exclamation-triangle', 'EXTMGRPLUS_TOOLTIP_VERSIONCHECK_ERROR') }}
++									<span title="{{ lang('EXTMGRPLUS_TOOLTIP_VERSIONCHECK_ERROR')|e('html') }}">&nbsp;{{ common.icon('fa-exclamation-triangle') }}</span>
+ 								{% elseif vc_obj.current is empty %}
+-									{{ common.icon('fa-question-circle', 'EXTMGRPLUS_TOOLTIP_VERSIONCHECK_EMPTY') }}
++									<span title="{{ lang('EXTMGRPLUS_TOOLTIP_VERSIONCHECK_EMPTY')|e('html') }}">&nbsp;{{ common.icon('fa-question-circle') }}</span>
+ 								{% elseif vc_obj.current != 'NOUPD' %}
+-									{{ common.icon('fa-exclamation-circle outdated-ext', 'EXTMGRPLUS_TOOLTIP_OUTDATED') }}
+-									<strong class="current-ext">({{ vc_obj.current }})</strong>
++									<span title="{{ lang('EXTMGRPLUS_TOOLTIP_OUTDATED')|e('html') }}">&nbsp;{{ common.icon('fa-exclamation-circle outdated-ext') }}</span>
++									<strong class="current-ext">&nbsp;({{ vc_obj.current }})</strong>
+ 								{% endif %}
+ 							{% endif %}
+ 							{% endapply %}
+@@ -250,7 +253,7 @@
+ 							{% if list != 'enabled' && EXTMGRPLUS_SWITCH_MIGRATION_COL %}
+ 								{% set count = EXTMGRPLUS_LIST_MIGRATIONS[ext.NAME] ?? 0 %}
+ 								{% if EXTMGRPLUS_LIST_IGNORE[ext.NAME] is defined %}
+-									{{ common.icon('fa-ban', 'EXTMGRPLUS_TOOLTIP_IS_IGNORED') }}
++									<span title="{{ lang('EXTMGRPLUS_TOOLTIP_IS_IGNORED')|e('html') }}">{{ common.icon('fa-ban') }}</span>
+ 								{% elseif count %}
+ 									<span title="{{ lang('EXTMGRPLUS_TOOLTIP_HAS_MIGRATION')|e('html') }}">{{ count }}</span>
+ 								{% endif %}
+@@ -270,23 +273,15 @@
+ 								<a href="{{ action.U_ACTION }}"{{ action.L_ACTION_EXPLAIN ? ' title="' ~ action.L_ACTION_EXPLAIN ~ '"' }}>{{ action.L_ACTION }}</a>
+ 								{{ !loop.last ? '<span>&nbsp;|&nbsp;</span>' }}
+ 							{% endfor %}
+-							{% if list == 'enabled' && EXTMGRPLUS_SWITCH_SETTINGS_LINK %}
+-								<span>&nbsp;|&nbsp;</span>
+-								{% if EXTMGRPLUS_LIST_MODULES[ext.NAME] is defined %}
+-									<a href="{{ EXTMGRPLUS_LIST_MODULES[ext.NAME] }}" title="{{ lang('EXTMGRPLUS_TOOLTIP_SETTINGS') }}">{{ lang('SETTINGS') }}</a>
+-								{% else %}
+-									<span class="emp_unavailable">{{ lang('SETTINGS') }}</span>
+-								{% endif %}
+-							{% endif %}
+ 							{% endapply %}
+ 						</td>
+ 						<td>
+ 							{% apply spaceless %}
+ 							{% if list != 'not_installed' && ext.NAME is defined && (ext.NAME != 'lukewcs/extmgrplus' || EXTMGRPLUS_SWITCH_SELF_DISABLE) %}
+ 								{% if EXTMGRPLUS_LIST_IGNORE[ext.NAME] is defined %}
+-									{{ common.icon('fa-ban', 'EXTMGRPLUS_TOOLTIP_IS_IGNORED') }}
++									<span title="{{ lang('EXTMGRPLUS_TOOLTIP_IS_IGNORED')|e('html') }}">{{ common.icon('fa-ban') }}
+ 								{% elseif EXTMGRPLUS_LIST_MIGRATIONS[ext.NAME] is defined && !EXTMGRPLUS_SWITCH_MIGRATIONS %}
+-									<input type="checkbox" class="checkbox" title="{{ lang('EXTMGRPLUS_TOOLTIP_IS_LOCKED')|e('html') }}" disabled>
++									<input type="checkbox" name="ext_mark_{{ list }}[]" class="checkbox" title="{{ lang('EXTMGRPLUS_TOOLTIP_IS_LOCKED')|e('html') }}" disabled>
+ 								{% else %}
+ 									<input type="checkbox" name="ext_mark_{{ list }}[]" class="checkbox" title="{{ lang('EXTMGRPLUS_TOOLTIP_SELECT')|e('html') }}" value="{{ ext.NAME }}"{{ EXTMGRPLUS_LIST_SELECTED[ext.NAME] is defined ? ' checked' }}>
+ 								{% endif %}
+@@ -296,7 +291,7 @@
+ 						<td style="display: none;">
+ 							{% apply spaceless %}
+ 							{% if ext.NAME is defined && ext.NAME != 'lukewcs/extmgrplus' && EXTMGRPLUS_SWITCH_ORDER_AND_IGNORE %}
+-								<input type="text" name="ext_order[{{ ext.NAME }}]" size="2" maxlength="3"{{ EXTMGRPLUS_LIST_IGNORE[ext.NAME] is defined ? ' class="emp_inactive"' }} title="{{ lang('EXTMGRPLUS_TOOLTIP_ORDER')|e('html') }}" value="{{ EXTMGRPLUS_LIST_ORDER[ext.NAME] ?? '' }}" pattern="^\+?[0-9]{1,2}$">
++								<input type="text" name="ext_order[{{ ext.NAME }}]" size="2" maxlength="3"{{ EXTMGRPLUS_LIST_IGNORE[ext.NAME] is defined ? ' class="inactive"' }} title="{{ lang('EXTMGRPLUS_TOOLTIP_ORDER')|e('html') }}" value="{{ EXTMGRPLUS_LIST_ORDER[ext.NAME] ?? '' }}" pattern="^\+?[0-9]{1,2}$">
+ 							{% endif %}
+ 							{% endapply %}
+ 						</td>
+@@ -363,7 +358,7 @@
+ 		</fieldset>
+ 	{% elseif type == 'save_checkboxes' %}
+ 		<input type="submit" name="extmgrplus_save_checkboxes" value="save_checkboxes" hidden>
+-	{% elseif type ends with 'able_all' %}
++	{% elseif type == 'disable_all' || type == 'enable_all'%}
+ 		{% set type_upper = type|upper %}
+ 		<input type="submit" name="extmgrplus_{{ type }}" class="button1" title="{{ lang('EXTMGRPLUS_TOOLTIP_' ~ type_upper)|e('html') }}" value="{{ lang('EXTMGRPLUS_' ~ type_upper) }}"{{ !enabled ? ' disabled' }}>
+ 	{% endif %}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_acp_ext_list.js" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_acp_ext_list.js"
+index a392d1064..9d39732ed 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_acp_ext_list.js"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_acp_ext_list.js"
+@@ -97,7 +97,7 @@ function setButtonState(e) {
+ };
+ 
+ function setInputBoxState(e) {
+-	$('input[name="ext_order[' + e.currentTarget.value + ']"]').toggleClass('emp_inactive', e.currentTarget.checked);
++	$('input[name="ext_order[' + e.currentTarget.value + ']"]').toggleClass('inactive', e.currentTarget.checked);
+ };
+ 
+ /*
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_confirm_body.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_confirm_body.html"
+index b03d4b2b8..2dae27c43 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_confirm_body.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_confirm_body.html"
+@@ -18,9 +18,7 @@
+ 
+ <p>{{ lang('EXTENSIONS_EXPLAIN') }}</p>
+ 
+-{% if EXTMGRPLUS_ACTION_MODE -%}
+ <p>{{ lang('EXTENSION_' ~ EXTMGRPLUS_ACTION_MODE ~ '_EXPLAIN') }}</p>
+-{%- endif %}
+ 
+ <form id="confirm" method="post" action="{{ S_CONFIRM_ACTION }}">
+ 	<fieldset>
+@@ -28,15 +26,15 @@
+ 
+ 		<p>{{ MESSAGE_TEXT }}</p>
+ 
+-		{% if EXTMGRPLUS_ACTION_MODE == 'DISABLE' && 'lukewcs/extmgrplus' in S_HIDDEN_FIELDS -%}
++		{% if EXTMGRPLUS_SELF_DISABLE %}
+ 			<p>{{ lang('EXTMGRPLUS_MSG_SELF_DISABLE') }}</p>
+-		{%- endif %}
++		{% endif %}
+ 
+ 		{{ S_HIDDEN_FIELDS }}
+ 
+ 		<fieldset class="submit-buttons">
+-			<button type="submit" name="confirm" value="{{ lang('YES') }}" class="button1">{{ lang(EXTMGRPLUS_CONFIRM_YES ?? 'YES') }}</button>
+-			<button type="submit" name="cancel" value="{{ lang('NO') }}" class="button2">{{ lang(EXTMGRPLUS_CONFIRM_NO ?? 'NO') }}</button>
++			<input type="submit" name="confirm" value="{{ lang('YES') }}" class="button1">&nbsp;
++			<input type="submit" name="cancel" value="{{ lang('NO') }}" class="button2">
+ 		</fieldset>
+ 	</fieldset>
+ 
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_macros.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_macros.html"
+index bccefff61..d8a2dc1cb 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_macros.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_macros.html"
+@@ -20,11 +20,8 @@
+ 	{% endif %}
+ {% endmacro %}
+ 
+-{% macro icon(classes, title = null, decorative = true) -%}
+-	<i class="icon {{ classes }}"{{
+-		(title != null ? ' title="' ~ lang(title)|e('html') ~ '"') ~
+-		(decorative ? ' aria-hidden="true"')
+-	}}></i>
++{% macro icon(classes, decorative = true) -%}
++	<i class="icon {{ classes }}"{{ decorative ? ' aria-hidden="true"' }}></i>
+ {%- endmacro %}
+ 
+ {% macro footer(metadata) %}
+@@ -32,7 +29,7 @@
+ 		{{ metadata.ext_name }} {{ metadata.ext_ver }} &copy; {{ metadata.ext_copyright }}
+ 		{% if metadata.lang_ver is defined %}
+ 			<br>
+-			{{ metadata.lang_desc|e('html') }} {{ metadata.lang_ver|e('html') }} &copy; {{ metadata.lang_author|e('html') }}
++			{{ metadata.lang_desc|e('html') }} {{ metadata.lang_ver|e('html') }} &bull; {{ metadata.lang_author|e('html') }}
+ 		{% endif %}
+ 	</p>
+ {% endmacro %}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_message_body.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_message_body.html"
+index ff0ba456a..857363870 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_message_body.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_message_body.html"
+@@ -22,7 +22,7 @@
+ 	<p>{{ lang('EXTENSION_' ~ EXTMGRPLUS_ACTION_MODE ~ '_EXPLAIN') }}</p>
+ {%- endif %}
+ 
+-<div class="{{ {0: 'successbox', 1: 'errorbox', 2: 'errorbox emp_warning', 3: 'errorbox emp_success_error'}[EXTMGRPLUS_TRIGGER_ERROR] }}">
++<div class="{{ S_USER_NOTICE ? 'successbox' : 'errorbox' }}">
+ 	<h3>{{ MESSAGE_TITLE }}</h3>
+ 
+ 	<p>{{ MESSAGE_TEXT }}</p>
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_settings.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_settings.html"
+index eb13ee558..421c4a386 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_settings.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_settings.html"
+@@ -16,6 +16,8 @@
+ 
+ {% set switch_type = TOGGLECTRL_TYPE ?? 'toggle' %}
+ 
++<a id="maincontent"></a>
++
+ <h1>{{ lang('EXTENSIONS_ADMIN') }}</h1>
+ 
+ <p>{{ lang('EXTENSIONS_EXPLAIN') }}</p>
+@@ -92,22 +94,22 @@
+ 
+ 		<dl>
+ 			<dt>
+-				<label>{{ lang('EXTMGRPLUS_VC_LIMIT') ~ lang('COLON') }}</label><br>
+-				<span>{{ lang('EXTMGRPLUS_VC_LIMIT_EXPLAIN') }}</span>
++				<label>{{ lang('EXTMGRPLUS_INSTRUCTIONS') ~ lang('COLON') }}</label><br>
++				<span>{{ lang('EXTMGRPLUS_INSTRUCTIONS_EXPLAIN') }}</span>
+ 			</dt>
+ 			<dd>
+-				{{ _self.number('extmgrplus_number_vc_limit', EXTMGRPLUS_NUMBER_VC_LIMIT, 1, 99) }}
+-				{{ lang('SECONDS') }}
++				{{ _self.switch('extmgrplus_switch_instructions', EXTMGRPLUS_SWITCH_INSTRUCTIONS, switch_type) }}
+ 			</dd>
+ 		</dl>
+ 
+ 		<dl>
+ 			<dt>
+-				<label>{{ lang('EXTMGRPLUS_SETTING_LINKS') ~ lang('COLON') }}</label><br>
+-				<span>{{ lang('EXTMGRPLUS_SETTING_LINKS_EXPLAIN') }}</span>
++				<label>{{ lang('EXTMGRPLUS_VC_LIMIT') ~ lang('COLON') }}</label><br>
++				<span>{{ lang('EXTMGRPLUS_VC_LIMIT_EXPLAIN') }}</span>
+ 			</dt>
+ 			<dd>
+-				{{ _self.switch('extmgrplus_switch_settings_link', EXTMGRPLUS_SWITCH_SETTINGS_LINK, switch_type) }}
++				{{ _self.number('extmgrplus_number_vc_limit', EXTMGRPLUS_NUMBER_VC_LIMIT, 1, 99) }}
++				{{ lang('SECONDS') }}
+ 			</dd>
+ 		</dl>
+ 
+@@ -124,17 +126,7 @@
+ 		</dl>
+ 
+ 		<legend class="legend_sub">{{ lang('EXTMGRPLUS_SECTION_EXPERT_SETTINGS') }}</legend>
+-		<p class="legend_explain">{{ lang('EXTMGRPLUS_EXPERT_SETTINGS_EXPLAIN') }}</p>
+-
+-		<dl>
+-			<dt>
+-				<label>{{ lang('EXTMGRPLUS_INSTRUCTIONS') ~ lang('COLON') }}</label><br>
+-				<span>{{ lang('EXTMGRPLUS_INSTRUCTIONS_EXPLAIN') }}</span>
+-			</dt>
+-			<dd>
+-				{{ _self.switch('extmgrplus_switch_instructions', EXTMGRPLUS_SWITCH_INSTRUCTIONS, switch_type) }}
+-			</dd>
+-		</dl>
++		<p>{{ lang('EXTMGRPLUS_EXPERT_SETTINGS_EXPLAIN') }}</p>
+ 
+ 		<dl>
+ 			<dt>
+@@ -175,7 +167,7 @@
+ 				<span>{{ lang('EXTMGRPLUS_DEFAULTS_EXP') }}</span>
+ 			</dt>
+ 			<dd>
+-				<input type="button" class="button2" name="extmgrplus_defaults" value="{{ lang('EXTMGRPLUS_BUTTON_DEFAULTS') }}">
++				{{ _self.button('extmgrplus_defaults', 'EXTMGRPLUS_BUTTON_DEFAULTS') }}
+ 			</dd>
+ 		</dl>
+ 	</fieldset>
+@@ -232,13 +224,17 @@
+ 	}}>
+ {%- endmacro %}
+ 
++{% macro button(name, lang_var) -%}
++	<input type="button" class="button2" name="{{ name }}" value="{{ lang(lang_var) }}">
++{%- endmacro %}
++
+ {% macro confirmbox(name, message, default = false) -%}
+-	<div class="lukewcs_confirmbox" data-name="{{ name }}" data-default="{{ default }}" style="display: none;">
++	<div id="{{ name }}_confirmbox" data-default="{{ default }}" style="display: none;">
+ 		<h2>{{ lang('CONFIRM') }}</h2>
+ 		<p>{{ message }}</p>
+ 		<p>
+-			<input type="button" class="button1" name="lukewcs_confirmbox_yes" value="{{ lang('YES') }}">&nbsp;
+-			<input type="button" class="button2" name="lukewcs_confirmbox_no" value="{{ lang('NO') }}">
++			<input type="button" class="button1" name="{{ name }}_confirm_yes" value="{{ lang('YES') }}">&nbsp;
++			<input type="button" class="button2" name="{{ name }}_confirm_no" value="{{ lang('NO') }}">
+ 		</p>
+ 	</div>
+ {%- endmacro %}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_settings.js" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_settings.js"
+index 38cce605c..146ad6c94 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_settings.js"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_settings.js"
+@@ -11,6 +11,7 @@
+ */
+ 
+ (function ($) {
++
+ 'use strict';
+ 
+ /*
+@@ -19,34 +20,28 @@
+ 
+ class LukeWCSphpBBConfirmBox {
+ /*
+-		* phpBB ConfirmBox class for checkboxes and yes/no radio buttons - v1.5.1
++* phpBB ConfirmBox class for checkboxes and yes/no radio buttons - v1.4.3
+ * @copyright (c) 2023, LukeWCS, https://www.wcsaga.org
+ * @license GNU General Public License, version 2 (GPL-2.0-only)
+ */
+-
+ 	constructor(submitSelector, animDuration = 0) {
+ 		let _this = this;
+ 		this.$submitObject	= $(submitSelector);
+ 		this.$formObject	= this.$submitObject.parents('form');
+ 		this.animDuration	= animDuration;
+ 
+-			this.$formObject.find('div.lukewcs_confirmbox').each(function () {
+-				$('input[name="' + $(this).attr('data-name') + '"]').on('change', _this.#Show);
+-				$(this).find('input[type="button"]')				.on('click'	, _this.#Button);
++		this.$formObject.find('div[id$="_confirmbox"]').each(function () {
++			const elementName = this.id.replace('_confirmbox', '');
++
++			$('input[name="' + elementName + '"]')				.on('change'	, _this.#Show);
++			$('input[name^="' + elementName + '_confirm_"]')	.on('click'		, _this.#Button);
+ 		});
+ 		this.$formObject										.on('reset'		, _this.HideAll);
+ 	}
+ 
+-		HideAll = () => {
+-			const $elementObject	= this.$formObject.find('input.lukewcs_confirmbox_active');
+-			const $confirmBoxObject	= this.$formObject.find('div.lukewcs_confirmbox');
+-
+-			this.#changeBoxState($elementObject, $confirmBoxObject, false);
+-		}
+-
+ 	#Show = (e) => {
+ 		const $elementObject	= $('input[name="' + e.target.name + '"]');
+-			const $confirmBoxObject	= $('div.lukewcs_confirmbox[data-name="' + e.target.name + '"]');
++		const $confirmBoxObject	= $('div[id="' + e.target.name + '_confirmbox"]');
+ 
+ 		if ($elementObject.prop('checked') != $confirmBoxObject.attr('data-default')) {
+ 			this.#changeBoxState($elementObject, $confirmBoxObject, true);
+@@ -54,12 +49,12 @@
+ 	}
+ 
+ 	#Button = (e) => {
+-			const elementName		= $(e.target).parents('div.lukewcs_confirmbox').attr('data-name');
++		const elementName		= e.target.name.replace(/_confirm_.*/, '');
+ 		const $elementObject	= $('input[name="' + elementName + '"]');
++		const $confirmBoxObject	= $('div[id="' + elementName + '_confirmbox"]');
+ 		const elementType		= $elementObject.attr('type');
+-			const $confirmBoxObject	= $('div.lukewcs_confirmbox[data-name="' + elementName + '"]');
+ 
+-			if (e.target.name == 'lukewcs_confirmbox_no') {
++		if (e.target.name.endsWith('_confirm_no')) {
+ 			if (elementType == 'checkbox') {
+ 				$elementObject.prop('checked', $confirmBoxObject.attr('data-default'));
+ 			} else if (elementType == 'radio') {
+@@ -69,11 +64,18 @@
+ 		this.#changeBoxState($elementObject, $confirmBoxObject, null);
+ 	}
+ 
++	HideAll = () => {
++		const $elementObject	= this.$formObject.find('input.confirmbox_active');
++		const $confirmBoxObject	= this.$formObject.find('div[id$="_confirmbox"]');
++
++		this.#changeBoxState($elementObject, $confirmBoxObject, false);
++	}
++
+ 	#changeBoxState = ($elementObject, $confirmBoxObject, showBox) => {
+ 		$elementObject		.prop('disabled', !!showBox);
+-			$elementObject		.toggleClass('lukewcs_confirmbox_active', !!showBox);
++		$elementObject		.toggleClass('confirmbox_active', !!showBox);
+ 		$confirmBoxObject	[showBox ? 'show' : 'hide'](this.animDuration);
+-			this.$submitObject	.prop('disabled', showBox ?? this.$formObject.find('input.lukewcs_confirmbox_active').length);
++		this.$submitObject	.prop('disabled', showBox ?? this.$formObject.find('input.confirmbox_active').length);
+ 	}
+ }
+ 
+@@ -102,7 +104,6 @@
+ 	setSwitch('[name="extmgrplus_switch_order_and_ignore"]',			true);
+ 	setSwitch('[name="extmgrplus_switch_self_disable"]',				false);
+ 	setSwitch('[name="extmgrplus_switch_instructions"]',				true);
+-		setSwitch('[name="extmgrplus_switch_settings_link"]',				true);
+ 	$(        '[name="extmgrplus_number_vc_limit"]').prop('value',		15);
+ 	setSwitch('[name="extmgrplus_switch_migration_col"]',				false);
+ 	setSwitch('[name="extmgrplus_switch_migrations"]',					false);
+@@ -147,4 +148,5 @@
+ 
+ 	ConfirmBox = new LukeWCSphpBBConfirmBox('[name="extmgrplus_submit"]', 300);
+ });
++
+ })(jQuery);
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_versioncheck.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_versioncheck.html"
+index 9d6aaf8c4..eb385e167 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_versioncheck.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_versioncheck.html"
+@@ -14,6 +14,8 @@
+ 
+ {% INCLUDE 'overall_header.html' %}
+ 
++<a id="maincontent"></a>
++
+ <h1>{{ lang('EXTENSIONS_ADMIN') }}</h1>
+ 
+ <p>{{ lang('EXTENSIONS_EXPLAIN') }}</p>
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/adm/style/event/acp_ext_details_end.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/adm/style/event/acp_ext_details_end.html"
+new file mode 100644
+index 000000000..13dbd1022
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/adm/style/event/acp_ext_details_end.html"
+@@ -0,0 +1,26 @@
++{% import '@lukewcs_extmgrplus/acp_ext_mgr_plus_macros.html' as common %}
++
++
++{% if EXTMGRPLUS_DETAILS|length %}
++	<fieldset>
++		<legend>{{ lang('EXTMGRPLUS_SECTION_DETAILS') }}</legend>
++
++	{% if EXTMGRPLUS_DETAILS.cdb_page %}
++		<dl>
++			<dt><label>{{ lang('EXTMGRPLUS_DETAILS_CDB_PAGE') ~ lang('COLON') }}</label></dt>
++			<dd><strong><a href="{{ EXTMGRPLUS_DETAILS.cdb_page }}">{{ EXTMGRPLUS_DETAILS.cdb_page }}</a></strong></dd>
++		</dl>
++	{% endif %}
++
++	{% if EXTMGRPLUS_DETAILS.version_url %}
++		<dl>
++			<dt><label>{{ lang('EXTMGRPLUS_DETAILS_VERSION_URL') ~ lang('COLON') }}</label></dt>
++			<dd><strong><a href="{{ EXTMGRPLUS_DETAILS.version_url }}">{{ EXTMGRPLUS_DETAILS.version_url }}</a></strong></dd>
++		</dl>
++	{% endif %}
++	</fieldset>
++{% endif %}
++
++{{ common.footer(EXTMGRPLUS_METADATA) }}
++
++{% INCLUDECSS '@lukewcs_extmgrplus/acp_ext_mgr_plus.css' %}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/composer.json"
+index 42a77c63f..577550354 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/composer.json"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/composer.json"
+@@ -3,8 +3,8 @@
+     "type": "phpbb-extension",
+     "description": "Adds the option to disable and re-enable all installed extensions at once to the extension management. Individual selections can be made using checkboxes. In addition, sequence groups and dependencies can be defined or extensions can be ignored. The version check is carried out in blocks and provides detailed information. Additional information is displayed in the extension management.",
+     "homepage": "https://github.com/LukeWCS/ext-mgr-plus",
+-    "version": "3.1.0",
+-    "time": "2025-11-01",
++    "version": "3.0.0",
++    "time": "2024-11-28",
+     "license": "GPL-2.0-only",
+     "authors": [
+         {
+@@ -19,13 +19,13 @@
+         }
+     ],
+     "require": {
+-        "php": ">=8.0.0,<8.5.0@dev",
++        "php": ">=7.4.0,<8.5.0@dev",
+         "composer/installers": "~1.0.0",
+         "phpbb/phpbb": ">=3.3.8,<3.4.0@dev"
+     },
+     "extra": {
+         "display-name": "Extension Manager Plus",
+-        "lang-min-ver": "3.1.0",
++        "lang-min-ver": "3.0.0",
+         "soft-require": {
+             "phpbb/phpbb": ">=3.3.8,<3.4.0@dev"
+         },
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/config/services.yml" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/config/services.yml"
+index a70d6857b..f5395d02b 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/config/services.yml"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/config/services.yml"
+@@ -19,8 +19,9 @@ services:
+             - '@language'
+             - '@template'
+             - '@dbal.conn'
+-            - '@path_helper'
+             - '%core.table_prefix%'
++            - '%core.root_path%'
++            - '%core.php_ext%'
+     lukewcs.extmgrplus.core.common:
+         class: lukewcs\extmgrplus\core\ext_mgr_plus_common
+         arguments:
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/controller/acp_ext_mgr_plus_controller.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/controller/acp_ext_mgr_plus_controller.php"
+index 2943e9378..0f91e63be 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/controller/acp_ext_mgr_plus_controller.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/controller/acp_ext_mgr_plus_controller.php"
+@@ -15,16 +15,27 @@ namespace lukewcs\extmgrplus\controller;
+ 
+ class acp_ext_mgr_plus_controller
+ {
++	protected object $common;
++	protected object $language;
++	protected object $template;
++	protected object $request;
++	protected object $config;
++
+ 	protected string $u_action;
+ 
+ 	public function __construct(
+-		protected object $common,
+-		protected \phpbb\language\language $language,
+-		protected \phpbb\template\template $template,
+-		protected \phpbb\request\request $request,
+-		protected \phpbb\config\config $config,
++		$common,
++		\phpbb\language\language $language,
++		\phpbb\template\template $template,
++		\phpbb\request\request $request,
++		\phpbb\config\config $config
+ 	)
+ 	{
++		$this->common	= $common;
++		$this->language	= $language;
++		$this->template	= $template;
++		$this->request	= $request;
++		$this->config	= $config;
+ 	}
+ 
+ 	public function module_settings(): void
+@@ -54,7 +65,6 @@ class acp_ext_mgr_plus_controller
+ 			$this->config->set('extmgrplus_switch_order_and_ignore'	, $this->request->variable('extmgrplus_switch_order_and_ignore'	, 0));
+ 			$this->config->set('extmgrplus_switch_self_disable'		, $this->request->variable('extmgrplus_switch_self_disable'		, 0));
+ 			$this->config->set('extmgrplus_switch_instructions'		, $this->request->variable('extmgrplus_switch_instructions'		, 0));
+-			$this->config->set('extmgrplus_switch_settings_link'	, $this->request->variable('extmgrplus_switch_settings_link'	, 0));
+ 			$this->config->set('extmgrplus_number_vc_limit'			, $this->request->variable('extmgrplus_number_vc_limit'			, 0));
+ 			$this->config->set('extmgrplus_switch_migration_col'	, $this->request->variable('extmgrplus_switch_migration_col'	, 0));
+ 			$this->config->set('extmgrplus_switch_migrations'		, $this->request->variable('extmgrplus_switch_migrations'		, 0));
+@@ -77,7 +87,6 @@ class acp_ext_mgr_plus_controller
+ 			'EXTMGRPLUS_SWITCH_ORDER_AND_IGNORE'		=> (bool) $this->config['extmgrplus_switch_order_and_ignore'],
+ 			'EXTMGRPLUS_SWITCH_SELF_DISABLE'			=> (bool) $this->config['extmgrplus_switch_self_disable'],
+ 			'EXTMGRPLUS_SWITCH_INSTRUCTIONS'			=> (bool) $this->config['extmgrplus_switch_instructions'],
+-			'EXTMGRPLUS_SWITCH_SETTINGS_LINK'			=> (bool) $this->config['extmgrplus_switch_settings_link'],
+ 			'EXTMGRPLUS_NUMBER_VC_LIMIT'				=> (int) $this->config['extmgrplus_number_vc_limit'],
+ 			'EXTMGRPLUS_SWITCH_MIGRATION_COL'			=> (bool) $this->config['extmgrplus_switch_migration_col'],
+ 			'EXTMGRPLUS_SWITCH_MIGRATIONS'				=> (bool) $this->config['extmgrplus_switch_migrations'],
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/core/ext_mgr_plus.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/core/ext_mgr_plus.php"
+index ee129cbb4..7bc61a912 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/core/ext_mgr_plus.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/core/ext_mgr_plus.php"
+@@ -19,34 +19,55 @@ class ext_mgr_plus
+ 	protected const  CHECKBOX_ALL	= 1;
+ 	protected const  CHECKBOX_LAST	= 2;
+ 
+-	protected const  CDB_EXT			= 1;
+-	protected const  CDB_EXT_OFFICIAL	= 2;
++	protected object $common;
++	protected object $ext_manager;
++	protected object $cache;
++	protected object $request;
++	protected object $log;
++	protected object $user;
++	protected object $config;
++	protected object $config_text;
++	protected object $language;
++	protected object $template;
++	protected object $db;
++	protected string $table_prefix;
++	protected string $phpbb_root_path;
++	protected string $php_ext;
+ 
+ 	protected string $u_action;
+ 	protected int    $safe_time_limit;
+-	protected string $phpbb_root_path;
+-	protected string $phpbb_admin_path;
+-	protected string $php_ext;
+ 
+ 	public function __construct(
+-		protected object $common,
+-		protected \phpbb\extension\manager $ext_manager,
+-		protected \phpbb\cache\driver\driver_interface $cache,
+-		protected \phpbb\request\request $request,
+-		protected \phpbb\log\log $log,
+-		protected \phpbb\user $user,
+-		protected \phpbb\config\config $config,
+-		protected \phpbb\config\db_text $config_text,
+-		protected \phpbb\language\language $language,
+-		protected \phpbb\template\template $template,
+-		protected \phpbb\db\driver\driver_interface $db,
+-		protected \phpbb\path_helper $path_helper,
+-		protected string $table_prefix,
++		$common,
++		\phpbb\extension\manager $ext_manager,
++		\phpbb\cache\driver\driver_interface $cache,
++		\phpbb\request\request $request,
++		\phpbb\log\log $log,
++		\phpbb\user $user,
++		\phpbb\config\config $config,
++		\phpbb\config\db_text $config_text,
++		\phpbb\language\language $language,
++		\phpbb\template\template $template,
++		\phpbb\db\driver\driver_interface $db,
++		$table_prefix,
++		$phpbb_root_path,
++		$php_ext
+ 	)
+ 	{
+-		$this->phpbb_root_path	= $this->path_helper->get_phpbb_root_path();
+-		$this->phpbb_admin_path	= $this->phpbb_root_path . $this->path_helper->get_adm_relative_path();
+-		$this->php_ext			= $this->path_helper->get_php_ext();
++		$this->common			= $common;
++		$this->ext_manager		= $ext_manager;
++		$this->cache			= $cache;
++		$this->request			= $request;
++		$this->log				= $log;
++		$this->user				= $user;
++		$this->config			= $config;
++		$this->config_text		= $config_text;
++		$this->language			= $language;
++		$this->template			= $template;
++		$this->db				= $db;
++		$this->table_prefix 	= $table_prefix;
++		$this->phpbb_root_path	= $phpbb_root_path;
++		$this->php_ext			= $php_ext;
+ 	}
+ 
+ 	/*
+@@ -74,19 +95,17 @@ class ext_mgr_plus
+ 
+ 			$this->exts_switch_confirm();
+ 		}
+-		else if ($this->request->is_set_post('extmgrplus_save_ext_properties'))
++		else if ($this->request->is_set_post('extmgrplus_save_ext_properties') && $this->config['extmgrplus_switch_order_and_ignore'])
+ 		{
+ 			$this->common->check_form_key_('lukewcs_extmgrplus');
+ 
+-			if ($this->config['extmgrplus_switch_order_and_ignore'])
+-			{
+ 			$order_list = $this->request->variable('ext_order', ['' => '']);
+ 			$ignore_list = $this->request->variable('ext_ignore', ['']);
++
+ 			$order_list = preg_grep('/^\+?[0-9]{1,2}$/', $order_list);
+ 
+ 			$this->common->config_text_set('extmgrplus_list_order_and_ignore', 'order', count($order_list) ? $order_list : null);
+ 			$this->common->config_text_set('extmgrplus_list_order_and_ignore', 'ignore', count($ignore_list) ? $ignore_list : null);
+-			}
+ 
+ 			$this->common->trigger_error_($this->language->lang('EXTMGRPLUS_MSG_EXT_PROPERTIES_SAVED'), E_USER_NOTICE, 'RETURN_TO_EXTENSION_LIST');
+ 		}
+@@ -111,8 +130,6 @@ class ext_mgr_plus
+ 	{
+ 		if ($event['action'] == 'details')
+ 		{
+-			$event['tpl_name'] = '@lukewcs_extmgrplus/acp_ext_mgr_plus_acp_ext_details';
+-
+ 			$this->extend_details($event['ext_name']);
+ 			$this->versioncheck_details($event['ext_name']);
+ 			return;
+@@ -136,7 +153,6 @@ class ext_mgr_plus
+ 		if ($vc_request)
+ 		{
+ 			$event['tpl_name'] = '@lukewcs_extmgrplus/acp_ext_mgr_plus_versioncheck';
+-
+ 			$this->template->assign_vars([
+ 				'EXTMGRPLUS_VC_DATA'		=> $ext_list_versioncheck['data'],
+ 				'U_EXTMGRPLUS_VC_CANCEL'	=> $this->u_action,
+@@ -165,7 +181,6 @@ class ext_mgr_plus
+ 		$ext_list_migrations_inactive			= [];
+ 		$ext_list_order							= [];
+ 		$ext_list_ignore						= [];
+-		$ext_list_modules						= [];
+ 		$ext_list_enabled_ignored				= [];
+ 		$ext_list_disabled_ignored				= [];
+ 		$ext_list_selected						= [];
+@@ -184,11 +199,6 @@ class ext_mgr_plus
+ 			$ext_list_disabled_ignored	= array_intersect_key($ext_list_ignore, $ext_list_disabled);
+ 		}
+ 
+-		if ($this->config['extmgrplus_switch_settings_link'])
+-		{
+-			$ext_list_modules = $this->get_module_links();
+-		}
+-
+ 		if ($this->config['extmgrplus_switch_migration_col'])
+ 		{
+ 			$ext_list_migrations_inactive = $this->get_exts_with_new_migration(array_diff_key($ext_list_available, $ext_list_enabled, $ext_list_ignore));
+@@ -204,7 +214,6 @@ class ext_mgr_plus
+ 		{
+ 			$ext_list_enabled_ignored['lukewcs/extmgrplus'] = 0;
+ 		}
+-
+ 		if (!$this->config['extmgrplus_switch_migrations'])
+ 		{
+ 			$ext_list_disabled_ignored = array_merge($ext_list_disabled_ignored, $ext_list_migrations_disabled);
+@@ -246,7 +255,6 @@ class ext_mgr_plus
+ 			'EXTMGRPLUS_LIST_IGNORE'				=> $ext_list_ignore,
+ 			'EXTMGRPLUS_LIST_MIGRATIONS'			=> $ext_list_migrations_inactive,
+ 			'EXTMGRPLUS_LIST_SELECTED'				=> $ext_list_selected,
+-			'EXTMGRPLUS_LIST_MODULES'				=> $ext_list_modules,
+ 			'EXTMGRPLUS_LIST_VERSIONCHECK'			=> $this->versioncheck_list($ext_list_available, $ext_list_versioncheck),
+ 
+ 			'EXTMGRPLUS_COUNT'						=> [
+@@ -265,7 +273,6 @@ class ext_mgr_plus
+ 			'EXTMGRPLUS_SWITCH_ORDER_AND_IGNORE'	=> $this->config['extmgrplus_switch_order_and_ignore'],
+ 			'EXTMGRPLUS_SWITCH_SELF_DISABLE'		=> $this->config['extmgrplus_switch_self_disable'],
+ 			'EXTMGRPLUS_SWITCH_INSTRUCTIONS'		=> $this->config['extmgrplus_switch_instructions'],
+-			'EXTMGRPLUS_SWITCH_SETTINGS_LINK'		=> $this->config['extmgrplus_switch_settings_link'],
+ 			'EXTMGRPLUS_SWITCH_MIGRATION_COL'		=> $this->config['extmgrplus_switch_migration_col'],
+ 			'EXTMGRPLUS_SWITCH_MIGRATIONS'			=> $this->config['extmgrplus_switch_migrations'],
+ 		]);
+@@ -277,7 +284,7 @@ class ext_mgr_plus
+ 	*/
+ 	public function change_msg_template(): void
+ 	{
+-		if ($this->template->retrieve_var('EXTMGRPLUS_TRIGGER_ERROR') !== null)
++		if ($this->template->retrieve_var('EXTMGRPLUS_TRIGGER_ERROR'))
+ 		{
+ 			$this->template->set_filenames(['body' => '@lukewcs_extmgrplus/acp_ext_mgr_plus_message_body.html']);
+ 		}
+@@ -327,8 +334,7 @@ class ext_mgr_plus
+ 		{
+ 			$this->template->assign_vars([
+ 				'EXTMGRPLUS_ACTION_MODE'	=> 'DISABLE',
+-				'EXTMGRPLUS_CONFIRM_YES'	=> 'EXTENSION_DISABLE',
+-				'EXTMGRPLUS_CONFIRM_NO'		=> 'CANCEL',
++				'EXTMGRPLUS_SELF_DISABLE'	=> array_search('lukewcs/extmgrplus', $ext_mark_enabled) !== false,
+ 			]);
+ 			if (!$this->config['extmgrplus_switch_confirmation'] || confirm_box(true))
+ 			{
+@@ -343,8 +349,6 @@ class ext_mgr_plus
+ 		{
+ 			$this->template->assign_vars([
+ 				'EXTMGRPLUS_ACTION_MODE'	=> 'ENABLE',
+-				'EXTMGRPLUS_CONFIRM_YES'	=> 'EXTENSION_ENABLE',
+-				'EXTMGRPLUS_CONFIRM_NO'		=> 'CANCEL',
+ 			]);
+ 			if (!$this->config['extmgrplus_switch_confirmation'] || confirm_box(true))
+ 			{
+@@ -393,17 +397,17 @@ class ext_mgr_plus
+ 		{
+ 			try
+ 			{
+-				$ext_meta = $this->ext_manager->create_extension_metadata_manager($ext_name)->get_metadata('all');
++				$ext_metadata = $this->ext_manager->create_extension_metadata_manager($ext_name)->get_metadata('all');
+ 			}
+ 			catch (\RuntimeException $e)
+ 			{
+-				$ext_meta = null;
++				$ext_metadata = null;
+ 			}
+ 
+-			if (is_array($ext_meta))
++			if (is_array($ext_metadata))
+ 			{
+-				$ext_display_name	= $ext_meta['extra']['display-name'] ?? '';
+-				$ext_version		= $ext_meta['version'] ?? '';
++				$ext_display_name	= $ext_metadata['extra']['display-name'] ?? '';
++				$ext_version		= $ext_metadata['version'] ?? '';
+ 
+ 				$disable_error = '';
+ 				if ($this->ext_manager->is_enabled($ext_name))
+@@ -436,7 +440,7 @@ class ext_mgr_plus
+ 				}
+ 			}
+ 
+-			if ($this->safe_time_limit > 0 && (microtime(true) - $GLOBALS['starttime']) >= $this->safe_time_limit)
++			if ((microtime(true) - $GLOBALS['starttime']) >= $this->safe_time_limit)
+ 			{
+ 				$safe_time_exceeded = true;
+ 				break;
+@@ -458,7 +462,7 @@ class ext_mgr_plus
+ 		}
+ 		$this->common->trigger_error_(
+ 			$this->language->lang('EXTMGRPLUS_MSG_DEACTIVATION', $ext_count_success, $ext_count_enabled) . ($msg_failed ?? ''),
+-			$this->get_error_level($ext_count_success, $ext_count_enabled, $safe_time_exceeded),
++			(($ext_count_success != $ext_count_enabled || $safe_time_exceeded) ? E_USER_WARNING : E_USER_NOTICE),
+ 			'RETURN_TO_EXTENSION_LIST'
+ 		);
+ 	}
+@@ -498,17 +502,17 @@ class ext_mgr_plus
+ 		{
+ 			try
+ 			{
+-				$ext_meta = $this->ext_manager->create_extension_metadata_manager($ext_name)->get_metadata('all');
++				$ext_metadata = $this->ext_manager->create_extension_metadata_manager($ext_name)->get_metadata('all');
+ 			}
+ 			catch (\RuntimeException $e)
+ 			{
+-				$ext_meta = null;
++				$ext_metadata = null;
+ 			}
+ 
+-			if (is_array($ext_meta))
++			if (is_array($ext_metadata))
+ 			{
+-				$ext_display_name	= $ext_meta['extra']['display-name'] ?? '';
+-				$ext_version		= $ext_meta['version'] ?? '';
++				$ext_display_name	= $ext_metadata['extra']['display-name'] ?? '';
++				$ext_version		= $ext_metadata['version'] ?? '';
+ 
+ 				if ($this->ext_manager->is_disabled($ext_name))
+ 				{
+@@ -554,7 +558,7 @@ class ext_mgr_plus
+ 				}
+ 			}
+ 
+-			if ($this->safe_time_limit > 0 && (microtime(true) - $GLOBALS['starttime']) >= $this->safe_time_limit)
++			if ((microtime(true) - $GLOBALS['starttime']) >= $this->safe_time_limit)
+ 			{
+ 				$safe_time_exceeded = true;
+ 				break;
+@@ -576,7 +580,7 @@ class ext_mgr_plus
+ 		}
+ 		$this->common->trigger_error_(
+ 			$this->language->lang('EXTMGRPLUS_MSG_ACTIVATION', $ext_count_success, $ext_count_disabled) . ($msg_failed ?? ''),
+-			$this->get_error_level($ext_count_success, $ext_count_disabled, $safe_time_exceeded),
++			(($ext_count_success != $ext_count_disabled || $safe_time_exceeded) ? E_USER_WARNING : E_USER_NOTICE),
+ 			'RETURN_TO_EXTENSION_LIST'
+ 		);
+ 	}
+@@ -588,14 +592,14 @@ class ext_mgr_plus
+ 	{
+ 		$msg_failed = '<br><br>' . $this->language->lang($lang_var);
+ 		$count_failed = 0;
+-		foreach ($ext_list as $ext_name => $vars)
++		foreach ($ext_list as $name => $vars)
+ 		{
+ 			if (is_array($vars['message']))
+ 			{
+ 				$vars['message'] = implode('<br>', $vars['message']);
+ 			}
+ 			$count_failed++;
+-			$msg_failed .= $this->create_failed_msg($count_failed . '. ' . $vars['display_name'], $vars['ext_version'], $ext_name, $vars['message']);
++			$msg_failed .= $this->create_failed_msg($count_failed . '. ' . $vars['display_name'], $vars['ext_version'], $name, $vars['message']);
+ 		}
+ 
+ 		return $msg_failed;
+@@ -606,24 +610,12 @@ class ext_mgr_plus
+ 	*/
+ 	private function create_failed_msg(string $display_name, string $ext_version, string $ext_name, string $message): string
+ 	{
+-		return vsprintf('<br><br><strong>%1$s %2$s (%3$s)</strong>%4$s', [
+-			1	=> $display_name,
+-			2	=> $this->language->lang('EXTMGRPLUS_VERSION_STRING', $ext_version),
+-			3	=> $ext_name,
+-			4	=> empty($message) ? '' : "<br><br><em>{$message}</em>"
+-		]);
+-	}
+-
+-	/*
+-		Helper function for trigger_error
+-	*/
+-	function get_error_level(int $count_success, int $count_total, bool $safe_time_exceeded): int
+-	{
+-		return match (true) {
+-			$count_success == $count_total				=> E_USER_NOTICE,
+-			$count_success == 0, $safe_time_exceeded	=> E_USER_WARNING,
+-			default										=> E_USER_NOTICE + E_USER_ERROR,
+-		};
++		return sprintf('<br><br><strong>%1$s %2$s (%3$s)</strong>%4$s',
++			/* 1 */	$display_name,
++			/* 2 */	$this->language->lang('EXTMGRPLUS_VERSION_STRING', $ext_version),
++			/* 3 */	$ext_name,
++			/* 4 */	empty($message) ? '' : "<br><br><em>{$message}</em>"
++		);
+ 	}
+ 
+ 	/*
+@@ -673,48 +665,6 @@ class ext_mgr_plus
+ 		return count($migration_classes_new);
+ 	}
+ 
+-	/*
+-		Determine all ACP module links of the active extensions
+-	*/
+-	private function get_module_links(): array
+-	{
+-		global $module;
+-
+-		$module_urls = [];
+-		$module_tabs = [];
+-
+-		$modules = array_combine(array_column($module->module_ary, 'id'), $module->module_ary);
+-		$get_module_top_cat = function (int $module_id) use ($modules): string
+-		{
+-			$parent_id = $modules[$module_id]['parent'];
+-			while ($parent_id !== 0)
+-			{
+-				$module_id = $parent_id;
+-				$parent_id = $modules[$module_id]['parent'];
+-			}
+-
+-			return $modules[$module_id]['langname'];
+-		};
+-
+-		foreach (array_filter($modules, fn($row): bool => $row['name'] !== '' && $row['display']) as $module_row)
+-		{
+-			preg_match('/\\\\(.+?)\\\\(.+?)\\\\.*/', $module_row['name'], $matches);
+-			$tech_name = (count($matches) === 3) ? $matches[1] . '/' . $matches[2] : false;
+-			if ($tech_name !== false)
+-			{
+-				$module_tab = $get_module_top_cat($module_row['parent']);
+-				if (!isset($module_urls[$tech_name]) || ($module_tab === 'ACP_CAT_DOT_MODS' && $module_tabs[$tech_name] !== $module_tab))
+-				{
+-					$module_name = str_replace('\\', '-', $module_row['name']);
+-					$module_urls[$tech_name] = append_sid("{$this->phpbb_admin_path}index.{$this->php_ext}", "i={$module_name}&amp;mode={$module_row['mode']}");
+-					$module_tabs[$tech_name] = $module_tab;
+-				}
+-			}
+-		}
+-
+-		return $module_urls;
+-	}
+-
+ 	/*
+ 		Check if file is a valid migration file
+ 	*/
+@@ -726,14 +676,17 @@ class ext_mgr_plus
+ 			$file_content = file_get_contents($file);
+ 			if ($file_content !== false)
+ 			{
+-				return (
++				$check_migration = ((
+ 						preg_match('/function\s+?(?:depends_on|effectively_installed|update_schema|update_data|revert_data)\s*?\(/', $file_content)
+ 						&& preg_match('/^\s*?class\s+?' . $file_info['filename'] . '\s+/mi', $file_content)
+-				) ? 1 : 0;
++					)
++					? 1
++					: 0
++				);
+ 			}
+ 		}
+ 
+-		return -1;
++		return ($check_migration ?? -1);
+ 	}
+ 
+ 	/*
+@@ -757,7 +710,7 @@ class ext_mgr_plus
+ 	/*
+ 		Preparation to be able to run a version check in blocks
+ 	*/
+-	private function versioncheck_prepare(array|null &$ext_list_vc): void
++	private function versioncheck_prepare(?array &$ext_list_vc): void
+ 	{
+ 		$ext_list_all	= $this->ext_manager->all_available();
+ 		$ext_list_vc	= [
+@@ -778,7 +731,6 @@ class ext_mgr_plus
+ 			}
+ 			catch (\RuntimeException $e)
+ 			{
+-				$vc_meta = null;
+ 			}
+ 
+ 			if (isset($vc_meta))
+@@ -789,7 +741,6 @@ class ext_mgr_plus
+ 				$this->cache->destroy(str_replace(['/', '\\'], '-', $cache_filename));
+ 			}
+ 		}
+-
+ 		$ext_list_vc['data']['count_total']	= count($ext_list_vc) - 1;
+ 		$this->common->config_text_set('extmgrplus_list_version_check', 'updates', $ext_list_vc);
+ 	}
+@@ -851,8 +802,8 @@ class ext_mgr_plus
+ 
+ 		try
+ 		{
+-			$ext_meta = $md_manager->get_metadata('all');
+-			if (isset($ext_meta['extra']['version-check']))
++			$ext_metadata = $md_manager->get_metadata('all');
++			if (isset($ext_metadata['extra']['version-check']))
+ 			{
+ 				$vc_data = $this->ext_manager->version_check($md_manager, !$read_cache, $read_cache, $this->config['extension_force_unstable'] ? 'unstable' : null);
+ 				$vc_current = empty($vc_data) ? 'NOUPD' : $vc_data['current'];
+@@ -875,7 +826,7 @@ class ext_mgr_plus
+ 	/*
+ 		Reads the version check data from the database and removes obsolete entries and generates a list for the template
+ 	*/
+-	private function versioncheck_list(array &$ext_list, array|null &$ext_list_vc): array
++	private function versioncheck_list(array &$ext_list, ?array &$ext_list_vc): array
+ 	{
+ 		$ext_list_vc ??= [];
+ 
+@@ -892,17 +843,10 @@ class ext_mgr_plus
+ 			}
+ 			if ($this->ext_manager->is_available($ext_name))
+ 			{
+-				try
+-				{
+-					$ext_meta = $this->ext_manager->create_extension_metadata_manager($ext_name)->get_metadata('all');
+-				}
+-				catch (\RuntimeException $e)
+-				{
+-					$ext_meta = null;
+-				}
++				$ext_metadata = $this->ext_manager->create_extension_metadata_manager($ext_name)->get_metadata('all');
+ 
+ 				$no_ver_flags = $vc_data['current'] == 'NOUPD' || $vc_data['current'] == 'ERROR' || $vc_data['current'] == '';
+-				$has_update = !$no_ver_flags && phpbb_version_compare($ext_meta['version'] ?? '0.0.0', $vc_data['current'], '<');
++				$has_update = !$no_ver_flags && phpbb_version_compare($ext_metadata['version'], $vc_data['current'], '<');
+ 				if ($no_ver_flags || $has_update)
+ 				{
+ 					$ext_list_tpl[$ext_name]['current'] = $vc_data['current'];
+@@ -943,19 +887,15 @@ class ext_mgr_plus
+ 		{
+ 			try
+ 			{
+-				$ext_meta = $this->ext_manager->create_extension_metadata_manager($ext_name)->get_metadata('all');
++				$ext_metadata = $this->ext_manager->create_extension_metadata_manager($ext_name)->get_metadata('all');
+ 			}
+ 			catch (\RuntimeException $e)
+ 			{
+-				$ext_meta = null;
+ 			}
+ 
+-			if (isset($ext_meta['extra']['version-check']))
+-			{
+-				if (($ext_meta['extra']['version-check']['host'] ?? '') == 'www.phpbb.com')
++			if (isset($ext_metadata['extra']['version-check']))
+ 			{
+-					$ext_list_tpl[$ext_name]['cdb_ext']	= substr($ext_meta['name'], 0, 6) == 'phpbb/' ? self::CDB_EXT_OFFICIAL : self::CDB_EXT;
+-				}
++				$ext_list_tpl[$ext_name]['cdb_ext']	= ($ext_metadata['extra']['version-check']['host'] ?? '') == 'www.phpbb.com';
+ 				$count_total++;
+ 			}
+ 			else
+@@ -980,16 +920,13 @@ class ext_mgr_plus
+ 	*/
+ 	private function extend_details(string $ext_name): void
+ 	{
+-		$ext_meta	= $this->ext_manager->create_extension_metadata_manager($ext_name)->get_metadata('all');
+-		$vc_meta	= $ext_meta['extra']['version-check'] ?? null;
++		$vc_meta = $this->ext_manager->create_extension_metadata_manager($ext_name)->get_metadata('all')['extra']['version-check'] ?? null;
+ 		$details = [];
+-
+ 		if (isset($vc_meta))
+ 		{
+ 			if (($vc_meta['host'] ?? '') == 'www.phpbb.com')
+ 			{
+ 				$details['cdb_page'] = 'https://www.phpbb.com' . $vc_meta['directory'] . '/';
+-				$details['cdb_ext']		= substr($ext_meta['name'], 0, 6) == 'phpbb/' ? self::CDB_EXT_OFFICIAL : self::CDB_EXT;
+ 			}
+ 			if ($this->config['extmgrplus_switch_version_url'])
+ 			{
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/core/ext_mgr_plus_common.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/core/ext_mgr_plus_common.php"
+index ebb95000f..f56977333 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/core/ext_mgr_plus_common.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/core/ext_mgr_plus_common.php"
+@@ -15,17 +15,29 @@ namespace lukewcs\extmgrplus\core;
+ 
+ class ext_mgr_plus_common
+ {
++	protected object $config;
++	protected object $config_text;
++	protected object $language;
++	protected object $template;
++	protected object $ext_manager;
++
+ 	protected array  $metadata;
+ 	public    string $u_action;
+ 
+ 	public function __construct(
+-		protected \phpbb\config\config $config,
+-		protected \phpbb\config\db_text $config_text,
+-		protected \phpbb\language\language $language,
+-		protected \phpbb\template\template $template,
+-		protected \phpbb\extension\manager $ext_manager,
++		\phpbb\config\config $config,
++		\phpbb\config\db_text $config_text,
++		\phpbb\language\language $language,
++		\phpbb\template\template $template,
++		\phpbb\extension\manager $ext_manager
+ 	)
+ 	{
++		$this->config		= $config;
++		$this->config_text	= $config_text;
++		$this->language		= $language;
++		$this->template		= $template;
++		$this->ext_manager	= $ext_manager;
++
+ 		$this->metadata		= $this->ext_manager->create_extension_metadata_manager('lukewcs/extmgrplus')->get_metadata('all');
+ 	}
+ 
+@@ -70,7 +82,7 @@ class ext_mgr_plus_common
+ 			{
+ 				$lang_outdated_msg = $this->language->lang($lang_outdated_var);
+ 			}
+-			else /* Fallback if the current language package does not yet have the required variable. */
++			else // Fallback if the current language package does not yet have the required variable.
+ 			{
+ 				$lang_outdated_msg = 'Note: The language pack for the extension <strong>%1$s</strong> is no longer up-to-date. (installed: %2$s / needed: %3$s)';
+ 			}
+@@ -83,7 +95,7 @@ class ext_mgr_plus_common
+ 	/*
+ 		Set a variable/array in a config_text variable container or delete one or all variables/arrays
+ 	*/
+-	public function config_text_set(string $container, string|null $name, $value): void
++	public function config_text_set(string $container, ?string $name, $value): void
+ 	{
+ 		if ($this->config_text->get($container) === null)
+ 		{
+@@ -113,7 +125,7 @@ class ext_mgr_plus_common
+ 	/*
+ 		Get a variable/array from a config_text variable container
+ 	*/
+-	public function config_text_get(string $container, string|null $name = null)
++	public function config_text_get(string $container, ?string $name = null)
+ 	{
+ 		$config_text = $this->config_text->get($container);
+ 		if ($config_text === null)
+@@ -146,30 +158,23 @@ class ext_mgr_plus_common
+ 	/*
+ 		Wrapper for trigger_error
+ 	*/
+-	public function trigger_error_(string $message, int $error_level, string|null $back_link_lang_var = null): void
++	public function trigger_error_(string $message, int $error_type, ?string $back_link_lang_var = null): void
+ 	{
+-		if ($error_level == E_USER_NOTICE && $this->config['extmgrplus_switch_auto_redirect'])
++		if ($error_type == E_USER_NOTICE && $this->config['extmgrplus_switch_auto_redirect'])
+ 		{
+ 			meta_refresh(1, $this->rotate_get_params($this->u_action));
+ 			$this->template->assign_var('EXTMGRPLUS_AUTO_REDIRECT', true);
+ 		}
+-
+-		$error_type = [
+-			E_USER_NOTICE					=> 0, // green box
+-			E_USER_WARNING					=> 1, // red box
+-			E_USER_NOTICE + E_USER_WARNING	=> 2, // orange box
+-			E_USER_NOTICE + E_USER_ERROR	=> 3, // green+red box
+-		][$error_level]						?? 2;
+-		$this->template->assign_var('EXTMGRPLUS_TRIGGER_ERROR', $error_type);
+-		trigger_error($message . $this->back_link($back_link_lang_var), ($error_type > 1) ? E_USER_WARNING : $error_level);
++		$this->template->assign_var('EXTMGRPLUS_TRIGGER_ERROR', true);
++		trigger_error($message . $this->back_link($back_link_lang_var), $error_type);
+ 	}
+ 
+-	public function back_link(string|null $lang_var = null): string
++	public function back_link(?string $lang_var = null): string
+ 	{
+-		return vsprintf('<br><br><a href="%1$s">%2$s</a>', [
+-			1	=> $this->u_action,
+-			2	=> $this->language->lang($lang_var ?? 'BACK_TO_PREV')
+-		]);
++		return sprintf('<br><br><a href="%1$s">%2$s</a>',
++			/* 1 */ $this->u_action,
++			/* 2 */ $this->language->lang($lang_var ?? 'BACK_TO_PREV')
++		);
+ 	}
+ 
+ 	/*
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/diff_full.tmp"
+new file mode 100644
+index 000000000..12bd29fc1
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/diff_full.tmp"
+@@ -0,0 +1,4792 @@
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/acp/settings_module.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/acp/settings_module.php"
++index b9c7958c3..f0be963f2 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/acp/settings_module.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/acp/settings_module.php"
++@@ -15,9 +15,9 @@ namespace lukewcs\extmgrplus\acp;
++ 
++ class settings_module
++ {
++-	public string $page_title;
++-	public string $tpl_name;
++-	public string $u_action;
+++	public $page_title;
+++	public $tpl_name;
+++	public $u_action;
++ 
++ 	public function main()
++ 	{
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus.css" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus.css"
++index d5f7a1824..c632316bb 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus.css"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus.css"
++@@ -1,7 +1,33 @@
++-/* GENERAL >>> */
+++/* GENERAL */
++ 
++-button[type="submit"]:is([name="confirm"], [name="cancel"]),
++-input:is([type="submit"], [type="button"], [type="reset"])[name^="extmgrplus_"] {
+++fieldset {
+++	border-radius: 5px;
+++}
+++
+++fieldset p.submit-buttons {
+++	margin-top: 0;
+++	padding: 0 4px 4px 4px;
+++}
+++
+++fieldset dt label,
+++fieldset dd label {
+++	cursor: inherit;
+++}
+++
+++legend {
+++	background: inherit;
+++	margin: 2px 0 0 -11px;
+++	border-top: inherit;
+++	border-left: inherit;
+++	border-radius: 5px 5px 0 0;
+++	padding: 2px 10px;
+++	top: 0;
+++}
+++
+++input[type="submit"][name="confirm"],
+++input[type="submit"][name^="extmgrplus_"],
+++input[type="button"][name^="extmgrplus_"],
+++input[type="reset"][name^="extmgrplus_"] {
++ 	padding: 3px 4px;
++ }
++ 
++@@ -11,31 +37,11 @@ code {
++ 	color: black;
++ }
++ 
++-.emp_inactive {
+++.inactive {
++ 	opacity: 0.5;
++ }
++ 
++-.emp_unavailable {
++-	opacity: 0.3;
++-}
++-
++-.errorbox {
++-	&.emp_warning {
++-		background-color: #ffaa00;
++-
++-		& :is(a, a:visited) {
++-			color: #505050;
++-		}
++-
++-		& :is(h3, p, a:hover) {
++-			color: #303030;
++-		}
++-	}
++-
++-	&.emp_success_error {
++-		background: linear-gradient(#228822, #bc2a4d);
++-	}
++-}
+++/* Footer */
++ 
++ .extmgrplus_footer {
++ 	margin-top: 1em;
++@@ -43,192 +49,137 @@ code {
++ 	font-size: 0.75em;
++ }
++ 
++-#confirm {
++-	/* confirm_box (phpBB) */
++-
++-	& h2 {
++-		margin-bottom: 0.25em;
++-	}
++-
++-	& :is(.button1, .button2) {
++-		color: #000000;
++-		background: linear-gradient(to bottom, #d2d2d2 0%, #efefef 100%);
++-		border: 1px solid #666666;
++-		font-size: 0.85em;
++-		font-family: "Lucida Grande", Verdana, Helvetica, Arial, sans-serif;
++-		vertical-align: middle;
++-
++-		&:hover {
++-			border: 1px solid #bc2a4d;
++-			background: #efefef url("../../../../../adm/images/bg_button.gif") repeat bottom;
++-			color: #bc2a4d;
++-		}
++-	}
+++/* confirm_box (phpBB)*/
++ 
++-	& .button1 {
++-		font-weight: bold;
++-	}
+++#confirm h2 {
+++	margin-bottom: 0.25em;
++ }
++ 
++-/* <<< GENERAL */
++-
++-/* SETTINGS >>> */
++-
++-fieldset {
++-	border-radius: 5px;
++-
++-	& p.submit-buttons {
++-		margin-top: 0;
++-		padding: 0 4px 4px 4px;
++-	}
++-
++-	& :is(dt, dd) label {
++-		cursor: inherit;
++-	}
+++/* SETTINGS */
++ 
++-	& dd a {
++-		overflow-wrap: anywhere;
++-	}
+++legend.legend_sub {
+++	border: 0;
+++	margin: 1em 0;
+++	padding: 0;
+++	display: flex;
+++	white-space: nowrap;
++ }
++ 
++-legend {
++-	background: inherit;
++-	margin: 2px 0 0 -11px;
++-	border-top: inherit;
++-	border-left: inherit;
++-	border-radius: 5px 5px 0 0;
++-	padding: 2px 10px;
++-	top: 0;
++-
++-	& + .legend_explain {
++-		width: 45%;
++-	}
++-
++-	&.legend_sub {
++-		border: 0;
++-		margin: 1em 0;
++-		padding: 0;
++-		display: flex;
++-		white-space: nowrap;
++-
++-		&:after {
++-			content: "";
++-			border-bottom: 1px solid #cccccc;
++-			width: 100%;
++-			margin: 0 0 0.5em 1em;
++-		}
++-	}
+++legend.legend_sub:after {
+++	content: "";
+++	border-bottom: 1px solid #cccccc;
+++	width: 100%;
+++	margin: 0 0 0.5em 1em;
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
++-div.lukewcs_confirmbox {
++-	/* LukeWCSphpBBConfirmBox */
+++.toggle:checked:before {
+++	left: 2px;
+++	content: "\f00c";
+++}
+++
+++/* LukeWCSphpBBConfirmBox */
++ 
+++div[id$="_confirmbox"] {
++ 	max-width: 450px;
++ 	border: 2px solid skyblue;
++ 	margin: 0.75em 0.5em;
++ 	padding: 0.25em 0.5em;
++ 	border-radius: 5px;
+++	-webkit-box-shadow: 2px 2px 10px 1px rgba(121, 162, 179, 0.5);
++ 	box-shadow: 2px 2px 10px 1px rgba(121, 162, 179, 0.5);
+++}
++ 
++-	& h2 {
++-		margin: 0 0 0.25em 0;
++-	}
+++div[id$="_confirmbox"] h2 {
+++	margin: 0 0 0.25em 0;
+++}
++ 
++-	& p:last-of-type {
++-		text-align: center;
++-		margin: 0;
++-		padding: 0 4px 4px 4px;
++-	}
+++div[id$="_confirmbox"] p:nth-of-type(2) {
+++	text-align: center;
+++	margin: 0;
+++	padding: 0 4px 4px 4px;
+++}
++ 
++-	& input[type="button"] {
++-		padding: 3px 4px;
++-	}
+++div[id$="_confirmbox"] input[type="button"] {
+++	padding: 3px 4px;
++ }
++ 
++-input:is([type="submit"], [type="button"]):disabled,
++-input.lukewcs_confirmbox_active {
+++input[type="submit"]:disabled,
+++input[type="button"]:disabled,
+++input.confirmbox_active {
++ 	opacity: 0.5;
++ 	cursor: not-allowed;
++ }
++ 
++-/* <<< SETTINGS */
++-
++-/* EXTENSION MANAGER >>> */
+++/* EXTENSION MANAGER */
++ 
++ .js_link {
++ 	color: #105289;
+++}
++ 
++-	&:hover {
++-		color: #bc2a4d;
++-		text-decoration: underline;
++-		cursor: pointer;
++-	}
+++.js_link:hover {
+++	color: #bc2a4d;
+++	text-decoration: underline;
+++	cursor: pointer;
+++}
++ 
++-	&.disabled,
++-	&.disabled:hover {
++-		color: #536482;
++-		text-decoration: none;
++-		cursor: not-allowed;
++-		opacity: 0.5;
++-	}
+++.js_link.disabled,
+++.js_link.disabled:hover {
+++	color: #536482;
+++	text-decoration: none;
+++	cursor: not-allowed;
+++	opacity: 0.5;
++ }
++ 
++-table :is(th, td) i.icon,
++-fieldset dd i.icon {
++-	cursor: help;
+++fieldset.quick a i.icon,
+++.js_link i.icon {
+++	margin: 0 0.3em 0 0;
+++	font-size: 1.1em;
++ }
++ 
++ div.successbox i.icon,
++@@ -241,12 +192,6 @@ div.successbox.notice i.icon {
++ 	font-size: 1.2em;
++ }
++ 
++-fieldset.quick a i.icon,
++-.js_link i.icon {
++-	margin: 0 0.3em 0 0;
++-	font-size: 1.1em;
++-}
++-
++ fieldset.ext_properties i.icon,
++ thead th i.icon {
++ 	font-size: 1.1em;
++@@ -255,109 +200,107 @@ thead th i.icon {
++ 
++ fieldset.ext_properties dd {
++ 	color: inherit;
+++}
++ 
++-	& label {
++-		font-size: inherit;
++-		font-weight: bold;
+++fieldset.ext_properties dd label {
+++	font-size: inherit;
+++	font-weight: bold;
+++}
++ 
++-		&:hover {
++-			color: inherit;
++-		}
++-	}
+++fieldset.ext_properties dd label:hover {
+++	color: inherit;
+++}
++ 
++-	& details {
++-		border: 1px solid #cccccc;
++-		border-radius: 3px;
++-
++-		& summary {
++-			padding: 0.25em 0.5em;
++-			cursor: pointer;
++-			-webkit-user-select: none;
++-			user-select: none;
++-		}
++-
++-		& div {
++-			border-top: 1px solid #cccccc;
++-			font-size: inherit;
++-			padding: 0.25em 0;
++-			margin: 0 0.5em;
++-		}
++-	}
+++fieldset.ext_properties dd details {
+++	border: 1px solid #cccccc;
+++	border-radius: 3px;
++ }
++ 
++-#extmgrplus_list {
++-	& input[type="checkbox"]:disabled {
++-		cursor: not-allowed;
++-	}
+++fieldset.ext_properties dd summary {
+++	padding: 0.25em 0.5em;
+++	cursor: pointer;
+++	-webkit-user-select: none;
+++	-moz-user-select: none;
+++	-ms-user-select: none;
+++}
++ 
++-	& input[name$="able_all"] {
++-		padding: 1px 3px;
++-		font-size: inherit;
++-	}
+++fieldset.ext_properties dd details div {
+++	border-top: 1px solid #cccccc;
+++	font-size: inherit;
+++	padding: 0.25em 0;
+++	margin: 0 0.5em;
+++}
++ 
++-	& input[type="text"] {
++-		text-align: right;
++-		padding: 0 2px;
++-		margin: 0 2px;
++-		background-color: #f9f9f9;
++-	}
+++input[type="checkbox"]:disabled {
+++	cursor: not-allowed;
+++}
++ 
++-	& th:nth-of-type(1) {
++-		width: 1%;
++-	}
+++#extmgrplus_list input[name$="able_all"] {
+++	padding: 1px 5px;
+++}
++ 
++-	& th:nth-of-type(3) {
++-		width: 16%;
++-	}
+++#extmgrplus_list input[type="text"] {
+++	text-align: right;
+++	padding: 0 2px;
+++	margin: 0 2px;
+++	background-color: #f9f9f9;
+++}
++ 
++-	& th:nth-of-type(1n+3) {
++-		text-align: center;
++-	}
+++#extmgrplus_list th:nth-of-type(1) {
+++	width: 1%;
+++}
++ 
++-	& th:nth-of-type(4) {
++-		width: 1%;
++-	}
+++#extmgrplus_list th:nth-of-type(3) {
+++	width: 16%;
+++}
++ 
++-	& th:nth-of-type(5) {
++-		width: 10%;
++-	}
+++#extmgrplus_list th:nth-of-type(1n+3) {
+++	text-align: center;
+++}
++ 
++-	& th:nth-of-type(6) {
++-		width: 25%;
++-	}
+++#extmgrplus_list th:nth-of-type(4) {
+++	width: 1%;
+++}
++ 
++-	& th:nth-of-type(1n+7) {
++-		width: 1%;
++-	}
+++#extmgrplus_list th:nth-of-type(5) {
+++	width: 10%;
+++}
++ 
++-	& td:nth-of-type(3) i.icon {
++-		font-size: 1.2em;
++-	}
+++#extmgrplus_list th:nth-of-type(6) {
+++	width: 25%;
+++}
++ 
++-	& td:nth-of-type(3) :is(span, strong, i.icon) + :is(strong, i.icon) {
++-		margin-left: 0.3em;
++-	}
+++#extmgrplus_list th:nth-of-type(1n+7) {
+++	width: 1%;
+++}
++ 
++-	& td:nth-of-type(3) i.icon:is(.fa-question-circle, .fa-exclamation-triangle) {
++-		color: #df950d;
++-	}
+++#extmgrplus_list td:nth-of-type(1) i.icon {
+++	cursor: help;
+++}
++ 
++-	& td:nth-of-type(1n+3) {
++-		text-align: center;
++-	}
+++#extmgrplus_list td:nth-of-type(3) i.icon {
+++	cursor: help;
+++	font-size: 1.2em;
+++}
++ 
++-	& td:nth-of-type(4) span {
++-		cursor: help;
++-	}
+++#extmgrplus_list td:nth-of-type(3) i.icon:is(.fa-question-circle, .fa-exclamation-triangle, .fa-refresh) {
+++	color: #df950d;
+++}
++ 
++-	& td:nth-of-type(7) i.icon {
++-		font-size: 1.3em;
++-	}
+++#extmgrplus_list td:nth-of-type(1n+3) {
+++	text-align: center;
+++}
+++
+++#extmgrplus_list td:nth-of-type(4) span {
+++	cursor: help;
++ }
++ 
++-/* <<< EXTENSION MANAGER */
+++#extmgrplus_list td:nth-of-type(7) i.icon {
+++	cursor: help;
+++	font-size: 1.3em;
+++}
++ 
++-/* VERSIONCHECK PROGGRESS >>> */
+++/* VERSIONCHECK PROGGRESS */
++ 
++ .progress_container {
++ 	background-color: #f9f9f9;
++@@ -365,28 +308,28 @@ fieldset.ext_properties dd {
++ 	border-radius: 5px;
++ 	position: relative;
++ 	margin: 1em 0 0.25em 0;
+++}
++ 
++-	& .progress_bar {
++-		background-color: lightgreen;
++-		height: 100%;
++-		border-radius: 5px;
++-	}
+++.progress_bar {
+++	background-color: lightgreen;
+++	height: 100%;
+++	border-radius: 5px;
+++}
++ 
++-	& .progress_value {
++-		color: black;
++-		position: absolute;
++-		font-size: 0.85em;
++-		top: 1px;
++-		left: 0;
++-		right: 0;
++-	}
+++.progress_value {
+++	color: black;
+++	position: absolute;
+++	font-size: 0.85em;
+++	top: 1px;
+++	left: 0;
+++	right: 0;
+++}
++ 
++-	& .progress_anim {
++-		background-color: lightblue;
++-		animation-name: progress_anim_block;
++-		animation-timing-function: linear;
++-		animation-fill-mode: forwards;
++-	}
+++.progress_anim {
+++	background-color: lightblue;
+++	animation-name: progress_anim_block;
+++	animation-timing-function: linear;
+++	animation-fill-mode: forwards;
++ }
++ 
++ @keyframes progress_anim_block {
++@@ -399,18 +342,12 @@ fieldset.ext_properties dd {
++ 	}
++ }
++ 
++-/* <<< VERSIONCHECK PROGGRESS */
++-
++-/* RESPONSIVE >>> */
+++/* RESPONSIVE */
++ 
++ @media (max-width: 700px){
++ 	legend {
++ 		margin: 2px 0 0 -6px;
++ 		padding: 2px 5px;
++-
++-		& + .legend_explain {
++-			width: auto;
++-		}
++ 	}
++ 
++ 	#extmgrplus_settings dd {
++@@ -421,5 +358,3 @@ fieldset.ext_properties dd {
++ 		padding: 0.5em 0 0 0;
++ 	}
++ }
++-
++-/* <<< RESPONSIVE */
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_acp_ext_details.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_acp_ext_details.html"
++deleted file mode 100644
++index 830d87306..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_acp_ext_details.html"
+++++ /dev/null
++@@ -1,180 +0,0 @@
++-{#
++-*
++-* Extension Manager Plus. An extension for the phpBB Forum Software package.
++-*
++-* @copyright (c) 2022, LukeWCS, https://www.wcsaga.org
++-* @license GNU General Public License, version 2 (GPL-2.0-only)
++-*
++-* Note: This extension is 100% genuine handcraft and consists of selected
++-*       natural raw materials. There was no AI involved in making it.
++-*
++-#}
++-
++-{% import '@lukewcs_extmgrplus/acp_ext_mgr_plus_macros.html' as common %}
++-
++-{% INCLUDE 'overall_header.html' %}
++-
++-<a href="{{ U_BACK }}" style="float: {{ S_CONTENT_FLOW_END }};">&laquo; {{ lang('BACK') }}</a>
++-
++-<h1>{{ lang('EXTENSIONS_ADMIN') }}</h1>
++-
++-<p>{{ lang('EXTENSIONS_EXPLAIN') }}</p>
++-
++-{% if S_VERSIONCHECK %}
++-	{% if S_VERSIONCHECK_FAIL %}
++-		<div class="errorbox notice">
++-			<p>{{ lang('VERSIONCHECK_FAIL') }}</p>
++-			<p>{{ VERSIONCHECK_FAIL_REASON }}</p>
++-			<p><a href="{{ U_VERSIONCHECK_FORCE }}">{{ lang('VERSIONCHECK_FORCE_UPDATE') }}</a></p>
++-		</div>
++-	{% else %}
++-		<div class="{% if S_UP_TO_DATE %}successbox{% else %}errorbox{% endif %}">
++-			<p>{{ UP_TO_DATE_MSG }} - <a href="{{ U_VERSIONCHECK_FORCE }}">{{ lang('VERSIONCHECK_FORCE_UPDATE') }}</a></p>
++-		</div>
++-	{% endif %}
++-{% endif %}
++-
++-{% EVENT acp_ext_details_notice %}
++-
++-<fieldset>
++-	<legend>{{ lang('EXT_DETAILS') }}</legend>
++-
++-	{% if META_DISPLAY_NAME %}
++-		<dl>
++-			<dt><label>{{ lang('DISPLAY_NAME') ~ lang('COLON') }}</label></dt>
++-			<dd>
++-				{{ EXTMGRPLUS_DETAILS.cdb_ext ? {
++-					1:	common.icon('fa-database', 'EXTMGRPLUS_TOOLTIP_CDB_EXT'),
++-					2:	common.icon('fa-star', 'EXTMGRPLUS_TOOLTIP_CDB_EXT_OFFICIAL'),
++-				}[EXTMGRPLUS_DETAILS.cdb_ext] }}
++-				<strong id="meta_display_name">{{ META_DISPLAY_NAME }}</strong>
++-			</dd>
++-		</dl>
++-	{% endif %}
++-	<dl>
++-		<dt><label>{{ lang('CLEAN_NAME') ~ lang('COLON') }}</label></dt>
++-		<dd><strong id="meta_name">{{ META_NAME }}</strong></dd>
++-	</dl>
++-	{% if META_DESCRIPTION %}
++-		<dl>
++-			<dt><label>{{ lang('DESCRIPTION') ~ lang('COLON') }}</label></dt>
++-			<dd><span id="meta_description">{{ META_DESCRIPTION }}</span></dd>
++-		</dl>
++-	{% endif %}
++-	<dl>
++-		<dt><label>{{ lang('VERSION') ~ lang('COLON') }}</label></dt>
++-		<dd><span id="meta_version">{{ META_VERSION }}</span></dd>
++-	</dl>
++-	{% if META_HOMEPAGE && META_HOMEPAGE != EXTMGRPLUS_DETAILS.cdb_page %}
++-		<dl>
++-			<dt><label>{{ lang('HOMEPAGE') ~ lang('COLON') }}</label></dt>
++-			<dd><strong id="meta_homepage"><a href="{{ META_HOMEPAGE }}">{{ META_HOMEPAGE }}</a></strong></dd>
++-		</dl>
++-	{% endif %}
++-	{% if EXTMGRPLUS_DETAILS.cdb_page %}
++-		<dl>
++-			<dt><label>{{ lang('EXTMGRPLUS_DETAILS_CDB_PAGE') ~ lang('COLON') }}</label></dt>
++-			<dd><strong><a href="{{ EXTMGRPLUS_DETAILS.cdb_page }}">{{ EXTMGRPLUS_DETAILS.cdb_page }}</a></strong></dd>
++-		</dl>
++-	{% endif %}
++-	{% if EXTMGRPLUS_DETAILS.version_url %}
++-		<dl>
++-			<dt><label>{{ lang('EXTMGRPLUS_DETAILS_VERSION_URL') ~ lang('COLON') }}</label></dt>
++-			<dd><strong><a href="{{ EXTMGRPLUS_DETAILS.version_url }}">{{ EXTMGRPLUS_DETAILS.version_url }}</a></strong></dd>
++-		</dl>
++-	{% endif %}
++-	{% if META_TIME %}
++-		<dl>
++-			<dt><label>{{ lang('TIME') ~ lang('COLON') }}</label></dt>
++-			<dd><span id="meta_time">{{ META_TIME }}</span></dd>
++-		</dl>
++-	{% endif %}
++-	<dl>
++-		<dt><label>{{ lang('LICENSE') ~ lang('COLON') }}</label></dt>
++-		<dd><span id="meta_license">{{ META_LICENSE }}</span></dd>
++-	</dl>
++-</fieldset>
++-
++-{% if S_VERSIONCHECK && !S_UP_TO_DATE %}
++-	<fieldset>
++-		<legend>{{ lang('LATEST_VERSION') }}</legend>
++-
++-		{% for updates_available in loops.updates_available %}
++-			<fieldset>
++-				<dl>
++-					<dt><label>{{ lang('VERSION') ~ lang('COLON') }}</label></dt>
++-					<dd><strong>{{ updates_available.current }}</strong></dd>
++-				</dl>
++-				{% if updates_available.download %}
++-					<dl>
++-						<dt><label>{{ lang('DOWNLOAD_LATEST') }}</label></dt>
++-						<dd><strong><a href="{{ updates_available.download }}">{{ lang('DOWNLOAD') }} {{ META_NAME }} {{ LATEST_VERSION }}</a></strong></dd>
++-					</dl>
++-				{% endif %}
++-				{% if updates_available.announcement %}
++-					<dl>
++-						<dt><label>{{ lang('ANNOUNCEMENT_TOPIC') }}</label></dt>
++-						<dd><strong><a href="{{ updates_available.announcement }}">{{ lang('RELEASE_ANNOUNCEMENT') }}</a></strong></dd>
++-					</dl>
++-				{% endif %}
++-			</fieldset>
++-		{% endfor %}
++-	</fieldset>
++-{% endif %}
++-
++-{% if META_REQUIRE_PHPBB || META_REQUIRE_PHP %}
++-	<fieldset>
++-		<legend>{{ lang('REQUIREMENTS') }}</legend>
++-
++-		{% if META_REQUIRE_PHPBB %}
++-			<dl{% if META_REQUIRE_PHPBB_FAIL %} class="requirements_not_met"{% endif %}>
++-				<dt><label>{{ lang('PHPBB_VERSION') ~ lang('COLON') }}</label></dt>
++-				<dd><span id="require_phpbb">{{ META_REQUIRE_PHPBB }}</span></dd>
++-			</dl>
++-		{% endif %}
++-		{% if META_REQUIRE_PHP %}
++-			<dl{% if META_REQUIRE_PHP_FAIL %} class="requirements_not_met"{% endif %}>
++-				<dt><label>{{ lang('PHP_VERSION') ~ lang('COLON') }}</label></dt>
++-				<dd><span id="require_php">{{ META_REQUIRE_PHP }}</span></dd>
++-			</dl>
++-		{% endif %}
++-	</fieldset>
++-{% endif %}
++-
++-<fieldset>
++-	<legend>{{ lang('AUTHOR_INFORMATION') }}</legend>
++-
++-	{% for meta_authors in loops.meta_authors %}
++-		<fieldset>
++-			<dl>
++-				<dt><label>{{ lang('AUTHOR_NAME') ~ lang('COLON') }}</label></dt>
++-				<dd><strong>{{ meta_authors.AUTHOR_NAME }}</strong></dd>
++-			</dl>
++-			{% if meta_authors.AUTHOR_EMAIL %}
++-				<dl>
++-					<dt><label>{{ lang('AUTHOR_EMAIL') ~ lang('COLON') }}</label></dt>
++-					<dd><strong><a href="mailto:{{ meta_authors.AUTHOR_EMAIL }}">{{ meta_authors.AUTHOR_EMAIL }}</a></strong></dd>
++-				</dl>
++-			{% endif %}
++-			{% if meta_authors.AUTHOR_HOMEPAGE %}
++-				<dl>
++-					<dt><label>{{ lang('AUTHOR_HOMEPAGE') ~ lang('COLON') }}</label></dt>
++-					<dd><strong><a href="{{ meta_authors.AUTHOR_HOMEPAGE }}">{{ meta_authors.AUTHOR_HOMEPAGE }}</a></strong></dd>
++-				</dl>
++-			{% endif %}
++-			{% if meta_authors.AUTHOR_ROLE %}
++-				<dl>
++-					<dt><label>{{ lang('AUTHOR_ROLE') ~ lang('COLON') }}</label></dt>
++-					<dd><strong>{{ meta_authors.AUTHOR_ROLE }}</strong></dd>
++-				</dl>
++-			{% endif %}
++-		</fieldset>
++-	{% endfor %}
++-</fieldset>
++-
++-{% EVENT acp_ext_details_end %}
++-
++-{{ common.footer(EXTMGRPLUS_METADATA) }}
++-
++-{% INCLUDE 'overall_footer.html' %}
++-{% INCLUDECSS '@lukewcs_extmgrplus/acp_ext_mgr_plus.css' %}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_acp_ext_list.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_acp_ext_list.html"
++index ff8f88ca8..14224a0d1 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_acp_ext_list.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_acp_ext_list.html"
++@@ -25,6 +25,8 @@
++ 	CHECKBOX_LAST	: 2,
++ } %}
++ 
+++<a id="maincontent"></a>
+++
++ <h1>{{ lang('EXTENSIONS_ADMIN') }}</h1>
++ 
++ <p>{{ lang('EXTENSIONS_EXPLAIN') }}</p>
++@@ -88,7 +90,7 @@
++ 		<fieldset class="ext_properties" style="display: none;">
++ 			<legend>{{ lang('EXTMGRPLUS_SECTION_SETTINGS') }}</legend>
++ 
++-			<dl{{ !EXTMGRPLUS_SWITCH_ORDER_AND_IGNORE ? ' class="emp_inactive"' }}>
+++			<dl{{ !EXTMGRPLUS_SWITCH_ORDER_AND_IGNORE ? ' class="inactive"' }}>
++ 				<dt>
++ 					<label>{{ lang('EXTMGRPLUS_ORDER', common.icon('fa-sort')) ~ lang('COLON') }}</label><br>
++ 				</dt>
++@@ -104,7 +106,7 @@
++ 				</dd>
++ 			</dl>
++ 
++-			<dl{{ !EXTMGRPLUS_SWITCH_ORDER_AND_IGNORE ? ' class="emp_inactive"' }}>
+++			<dl{{ !EXTMGRPLUS_SWITCH_ORDER_AND_IGNORE ? ' class="inactive"' }}>
++ 				<dt>
++ 					<label>{{ lang('EXTMGRPLUS_IGNORE', common.icon('fa-ban')) ~ lang('COLON') }}</label><br>
++ 				</dt>
++@@ -136,8 +138,8 @@
++ 		</colgroup>
++ 		<thead>
++ 			<tr>
++-				<th>
++-					{{ common.icon('fa-database', 'EXTMGRPLUS_COL_CDB') }}<span style="display: none;">{{ lang('EXTMGRPLUS_COL_CDB') }}</span>
+++				<th title="{{ lang('EXTMGRPLUS_COL_CDB') }}">
+++					{{ common.icon('fa-database') }}<span style="display: none;">{{ lang('EXTMGRPLUS_COL_CDB') }}</span>
++ 				</th>
++ 				<th>
++ 					{{ lang('EXTENSION_NAME') }}
++@@ -145,8 +147,8 @@
++ 				<th>
++ 					{{ lang('CURRENT_VERSION') }}
++ 				</th>
++-				<th{{ !EXTMGRPLUS_SWITCH_MIGRATION_COL ? ' style="display: none;"' }}>
++-					{{ common.icon('fa-arrow-up', 'EXTMGRPLUS_COL_MIGRATIONS') }}<span style="display: none;">{{ lang('EXTMGRPLUS_COL_MIGRATIONS') }}</span>
+++				<th{{ !EXTMGRPLUS_SWITCH_MIGRATION_COL ? ' style="display: none;"' }} title="{{ lang('EXTMGRPLUS_COL_MIGRATIONS') }}">
+++					{{ common.icon('fa-arrow-up') }}<span style="display: none;">{{ lang('EXTMGRPLUS_COL_MIGRATIONS') }}</span>
++ 				</th>
++ 				<th>
++ 					{{ lang('EXTENSION_OPTIONS') }}
++@@ -154,14 +156,14 @@
++ 				<th>
++ 					{{ lang('EXTENSION_ACTIONS') }}
++ 				</th>
++-				<th>
++-					{{ common.icon('fa-check', 'EXTMGRPLUS_COL_SELECT') }}<span style="display: none;">{{ lang('EXTMGRPLUS_COL_SELECT') }}</span>
+++				<th title="{{ lang('EXTMGRPLUS_COL_SELECT') }}">
+++					{{ common.icon('fa-check') }}<span style="display: none;">{{ lang('EXTMGRPLUS_COL_SELECT') }}</span>
++ 				</th>
++-				<th style="display: none;">
++-					{{ common.icon('fa-sort', 'EXTMGRPLUS_COL_ORDER') }}<span style="display: none;">{{ lang('EXTMGRPLUS_COL_ORDER') }}</span>
+++				<th title="{{ lang('EXTMGRPLUS_COL_ORDER') }}" style="display: none;">
+++					{{ common.icon('fa-sort') }}<span style="display: none;">{{ lang('EXTMGRPLUS_COL_ORDER') }}</span>
++ 				</th>
++-				<th style="display: none;">
++-					{{ common.icon('fa-ban', 'EXTMGRPLUS_COL_IGNORE') }}<span style="display: none;">{{ lang('EXTMGRPLUS_COL_IGNORE') }}</span>
+++				<th title="{{ lang('EXTMGRPLUS_COL_IGNORE') }}" style="display: none;">
+++					{{ common.icon('fa-ban') }}<span style="display: none;">{{ lang('EXTMGRPLUS_COL_IGNORE') }}</span>
++ 				</th>
++ 			</tr>
++ 		</thead>
++@@ -207,10 +209,11 @@
++ 					{% set vc_obj = EXTMGRPLUS_LIST_VERSIONCHECK[ext.NAME] ?? {} %}
++ 					<tr class="ext_{{ list }} row-highlight">
++ 						<td>
++-							{{ vc_obj.cdb_ext ? {
++-								1:	common.icon('fa-database', 'EXTMGRPLUS_TOOLTIP_CDB_EXT'),
++-								2:	common.icon('fa-star', 'EXTMGRPLUS_TOOLTIP_CDB_EXT_OFFICIAL'),
++-							}[vc_obj.cdb_ext] }}
+++							{% apply spaceless %}
+++							{% if vc_obj.cdb_ext === true %}
+++								<span title="{{ lang('EXTMGRPLUS_TOOLTIP_CDB_EXT')|e('html') }}">{{ common.icon('fa-database') }}</span>
+++							{% endif %}
+++							{% endapply %}
++ 						</td>
++ 						<td>
++ 							{% apply spaceless %}
++@@ -233,14 +236,14 @@
++ 									<strong class="{{ vc_obj.current == 'NOUPD' ? 'current-ext' : 'outdated-ext' }}">{{ ext.META_VERSION }}</strong>
++ 								{% endif %}
++ 								{% if vc_obj.current === false %}
++-									{{ common.icon('fa-chain-broken', 'EXTMGRPLUS_TOOLTIP_NO_VERSIONCHECK') }}
+++									<span title="{{ lang('EXTMGRPLUS_TOOLTIP_NO_VERSIONCHECK')|e('html') }}">&nbsp;{{ common.icon('fa-chain-broken') }}</span>
++ 								{% elseif vc_obj.current == 'ERROR' %}
++-									{{ common.icon('fa-exclamation-triangle', 'EXTMGRPLUS_TOOLTIP_VERSIONCHECK_ERROR') }}
+++									<span title="{{ lang('EXTMGRPLUS_TOOLTIP_VERSIONCHECK_ERROR')|e('html') }}">&nbsp;{{ common.icon('fa-exclamation-triangle') }}</span>
++ 								{% elseif vc_obj.current is empty %}
++-									{{ common.icon('fa-question-circle', 'EXTMGRPLUS_TOOLTIP_VERSIONCHECK_EMPTY') }}
+++									<span title="{{ lang('EXTMGRPLUS_TOOLTIP_VERSIONCHECK_EMPTY')|e('html') }}">&nbsp;{{ common.icon('fa-question-circle') }}</span>
++ 								{% elseif vc_obj.current != 'NOUPD' %}
++-									{{ common.icon('fa-exclamation-circle outdated-ext', 'EXTMGRPLUS_TOOLTIP_OUTDATED') }}
++-									<strong class="current-ext">({{ vc_obj.current }})</strong>
+++									<span title="{{ lang('EXTMGRPLUS_TOOLTIP_OUTDATED')|e('html') }}">&nbsp;{{ common.icon('fa-exclamation-circle outdated-ext') }}</span>
+++									<strong class="current-ext">&nbsp;({{ vc_obj.current }})</strong>
++ 								{% endif %}
++ 							{% endif %}
++ 							{% endapply %}
++@@ -250,7 +253,7 @@
++ 							{% if list != 'enabled' && EXTMGRPLUS_SWITCH_MIGRATION_COL %}
++ 								{% set count = EXTMGRPLUS_LIST_MIGRATIONS[ext.NAME] ?? 0 %}
++ 								{% if EXTMGRPLUS_LIST_IGNORE[ext.NAME] is defined %}
++-									{{ common.icon('fa-ban', 'EXTMGRPLUS_TOOLTIP_IS_IGNORED') }}
+++									<span title="{{ lang('EXTMGRPLUS_TOOLTIP_IS_IGNORED')|e('html') }}">{{ common.icon('fa-ban') }}</span>
++ 								{% elseif count %}
++ 									<span title="{{ lang('EXTMGRPLUS_TOOLTIP_HAS_MIGRATION')|e('html') }}">{{ count }}</span>
++ 								{% endif %}
++@@ -270,23 +273,15 @@
++ 								<a href="{{ action.U_ACTION }}"{{ action.L_ACTION_EXPLAIN ? ' title="' ~ action.L_ACTION_EXPLAIN ~ '"' }}>{{ action.L_ACTION }}</a>
++ 								{{ !loop.last ? '<span>&nbsp;|&nbsp;</span>' }}
++ 							{% endfor %}
++-							{% if list == 'enabled' && EXTMGRPLUS_SWITCH_SETTINGS_LINK %}
++-								<span>&nbsp;|&nbsp;</span>
++-								{% if EXTMGRPLUS_LIST_MODULES[ext.NAME] is defined %}
++-									<a href="{{ EXTMGRPLUS_LIST_MODULES[ext.NAME] }}" title="{{ lang('EXTMGRPLUS_TOOLTIP_SETTINGS') }}">{{ lang('SETTINGS') }}</a>
++-								{% else %}
++-									<span class="emp_unavailable">{{ lang('SETTINGS') }}</span>
++-								{% endif %}
++-							{% endif %}
++ 							{% endapply %}
++ 						</td>
++ 						<td>
++ 							{% apply spaceless %}
++ 							{% if list != 'not_installed' && ext.NAME is defined && (ext.NAME != 'lukewcs/extmgrplus' || EXTMGRPLUS_SWITCH_SELF_DISABLE) %}
++ 								{% if EXTMGRPLUS_LIST_IGNORE[ext.NAME] is defined %}
++-									{{ common.icon('fa-ban', 'EXTMGRPLUS_TOOLTIP_IS_IGNORED') }}
+++									<span title="{{ lang('EXTMGRPLUS_TOOLTIP_IS_IGNORED')|e('html') }}">{{ common.icon('fa-ban') }}
++ 								{% elseif EXTMGRPLUS_LIST_MIGRATIONS[ext.NAME] is defined && !EXTMGRPLUS_SWITCH_MIGRATIONS %}
++-									<input type="checkbox" class="checkbox" title="{{ lang('EXTMGRPLUS_TOOLTIP_IS_LOCKED')|e('html') }}" disabled>
+++									<input type="checkbox" name="ext_mark_{{ list }}[]" class="checkbox" title="{{ lang('EXTMGRPLUS_TOOLTIP_IS_LOCKED')|e('html') }}" disabled>
++ 								{% else %}
++ 									<input type="checkbox" name="ext_mark_{{ list }}[]" class="checkbox" title="{{ lang('EXTMGRPLUS_TOOLTIP_SELECT')|e('html') }}" value="{{ ext.NAME }}"{{ EXTMGRPLUS_LIST_SELECTED[ext.NAME] is defined ? ' checked' }}>
++ 								{% endif %}
++@@ -296,7 +291,7 @@
++ 						<td style="display: none;">
++ 							{% apply spaceless %}
++ 							{% if ext.NAME is defined && ext.NAME != 'lukewcs/extmgrplus' && EXTMGRPLUS_SWITCH_ORDER_AND_IGNORE %}
++-								<input type="text" name="ext_order[{{ ext.NAME }}]" size="2" maxlength="3"{{ EXTMGRPLUS_LIST_IGNORE[ext.NAME] is defined ? ' class="emp_inactive"' }} title="{{ lang('EXTMGRPLUS_TOOLTIP_ORDER')|e('html') }}" value="{{ EXTMGRPLUS_LIST_ORDER[ext.NAME] ?? '' }}" pattern="^\+?[0-9]{1,2}$">
+++								<input type="text" name="ext_order[{{ ext.NAME }}]" size="2" maxlength="3"{{ EXTMGRPLUS_LIST_IGNORE[ext.NAME] is defined ? ' class="inactive"' }} title="{{ lang('EXTMGRPLUS_TOOLTIP_ORDER')|e('html') }}" value="{{ EXTMGRPLUS_LIST_ORDER[ext.NAME] ?? '' }}" pattern="^\+?[0-9]{1,2}$">
++ 							{% endif %}
++ 							{% endapply %}
++ 						</td>
++@@ -363,7 +358,7 @@
++ 		</fieldset>
++ 	{% elseif type == 'save_checkboxes' %}
++ 		<input type="submit" name="extmgrplus_save_checkboxes" value="save_checkboxes" hidden>
++-	{% elseif type ends with 'able_all' %}
+++	{% elseif type == 'disable_all' || type == 'enable_all'%}
++ 		{% set type_upper = type|upper %}
++ 		<input type="submit" name="extmgrplus_{{ type }}" class="button1" title="{{ lang('EXTMGRPLUS_TOOLTIP_' ~ type_upper)|e('html') }}" value="{{ lang('EXTMGRPLUS_' ~ type_upper) }}"{{ !enabled ? ' disabled' }}>
++ 	{% endif %}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_acp_ext_list.js" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_acp_ext_list.js"
++index a392d1064..9d39732ed 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_acp_ext_list.js"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_acp_ext_list.js"
++@@ -97,7 +97,7 @@ function setButtonState(e) {
++ };
++ 
++ function setInputBoxState(e) {
++-	$('input[name="ext_order[' + e.currentTarget.value + ']"]').toggleClass('emp_inactive', e.currentTarget.checked);
+++	$('input[name="ext_order[' + e.currentTarget.value + ']"]').toggleClass('inactive', e.currentTarget.checked);
++ };
++ 
++ /*
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_confirm_body.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_confirm_body.html"
++index b03d4b2b8..2dae27c43 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_confirm_body.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_confirm_body.html"
++@@ -18,9 +18,7 @@
++ 
++ <p>{{ lang('EXTENSIONS_EXPLAIN') }}</p>
++ 
++-{% if EXTMGRPLUS_ACTION_MODE -%}
++-	<p>{{ lang('EXTENSION_' ~ EXTMGRPLUS_ACTION_MODE ~ '_EXPLAIN') }}</p>
++-{%- endif %}
+++<p>{{ lang('EXTENSION_' ~ EXTMGRPLUS_ACTION_MODE ~ '_EXPLAIN') }}</p>
++ 
++ <form id="confirm" method="post" action="{{ S_CONFIRM_ACTION }}">
++ 	<fieldset>
++@@ -28,15 +26,15 @@
++ 
++ 		<p>{{ MESSAGE_TEXT }}</p>
++ 
++-		{% if EXTMGRPLUS_ACTION_MODE == 'DISABLE' && 'lukewcs/extmgrplus' in S_HIDDEN_FIELDS -%}
+++		{% if EXTMGRPLUS_SELF_DISABLE %}
++ 			<p>{{ lang('EXTMGRPLUS_MSG_SELF_DISABLE') }}</p>
++-		{%- endif %}
+++		{% endif %}
++ 
++ 		{{ S_HIDDEN_FIELDS }}
++ 
++ 		<fieldset class="submit-buttons">
++-			<button type="submit" name="confirm" value="{{ lang('YES') }}" class="button1">{{ lang(EXTMGRPLUS_CONFIRM_YES ?? 'YES') }}</button>
++-			<button type="submit" name="cancel" value="{{ lang('NO') }}" class="button2">{{ lang(EXTMGRPLUS_CONFIRM_NO ?? 'NO') }}</button>
+++			<input type="submit" name="confirm" value="{{ lang('YES') }}" class="button1">&nbsp;
+++			<input type="submit" name="cancel" value="{{ lang('NO') }}" class="button2">
++ 		</fieldset>
++ 	</fieldset>
++ 
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_macros.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_macros.html"
++index bccefff61..d8a2dc1cb 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_macros.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_macros.html"
++@@ -20,19 +20,16 @@
++ 	{% endif %}
++ {% endmacro %}
++ 
++-{% macro icon(classes, title = null, decorative = true) -%}
++-	<i class="icon {{ classes }}"{{
++-		(title != null ? ' title="' ~ lang(title)|e('html') ~ '"') ~
++-		(decorative ? ' aria-hidden="true"')
++-	}}></i>
+++{% macro icon(classes, decorative = true) -%}
+++	<i class="icon {{ classes }}"{{ decorative ? ' aria-hidden="true"' }}></i>
++ {%- endmacro %}
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
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_message_body.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_message_body.html"
++index ff0ba456a..857363870 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_message_body.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_message_body.html"
++@@ -22,7 +22,7 @@
++ 	<p>{{ lang('EXTENSION_' ~ EXTMGRPLUS_ACTION_MODE ~ '_EXPLAIN') }}</p>
++ {%- endif %}
++ 
++-<div class="{{ {0: 'successbox', 1: 'errorbox', 2: 'errorbox emp_warning', 3: 'errorbox emp_success_error'}[EXTMGRPLUS_TRIGGER_ERROR] }}">
+++<div class="{{ S_USER_NOTICE ? 'successbox' : 'errorbox' }}">
++ 	<h3>{{ MESSAGE_TITLE }}</h3>
++ 
++ 	<p>{{ MESSAGE_TEXT }}</p>
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_settings.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_settings.html"
++index eb13ee558..421c4a386 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_settings.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_settings.html"
++@@ -16,6 +16,8 @@
++ 
++ {% set switch_type = TOGGLECTRL_TYPE ?? 'toggle' %}
++ 
+++<a id="maincontent"></a>
+++
++ <h1>{{ lang('EXTENSIONS_ADMIN') }}</h1>
++ 
++ <p>{{ lang('EXTENSIONS_EXPLAIN') }}</p>
++@@ -92,22 +94,22 @@
++ 
++ 		<dl>
++ 			<dt>
++-				<label>{{ lang('EXTMGRPLUS_VC_LIMIT') ~ lang('COLON') }}</label><br>
++-				<span>{{ lang('EXTMGRPLUS_VC_LIMIT_EXPLAIN') }}</span>
+++				<label>{{ lang('EXTMGRPLUS_INSTRUCTIONS') ~ lang('COLON') }}</label><br>
+++				<span>{{ lang('EXTMGRPLUS_INSTRUCTIONS_EXPLAIN') }}</span>
++ 			</dt>
++ 			<dd>
++-				{{ _self.number('extmgrplus_number_vc_limit', EXTMGRPLUS_NUMBER_VC_LIMIT, 1, 99) }}
++-				{{ lang('SECONDS') }}
+++				{{ _self.switch('extmgrplus_switch_instructions', EXTMGRPLUS_SWITCH_INSTRUCTIONS, switch_type) }}
++ 			</dd>
++ 		</dl>
++ 
++ 		<dl>
++ 			<dt>
++-				<label>{{ lang('EXTMGRPLUS_SETTING_LINKS') ~ lang('COLON') }}</label><br>
++-				<span>{{ lang('EXTMGRPLUS_SETTING_LINKS_EXPLAIN') }}</span>
+++				<label>{{ lang('EXTMGRPLUS_VC_LIMIT') ~ lang('COLON') }}</label><br>
+++				<span>{{ lang('EXTMGRPLUS_VC_LIMIT_EXPLAIN') }}</span>
++ 			</dt>
++ 			<dd>
++-				{{ _self.switch('extmgrplus_switch_settings_link', EXTMGRPLUS_SWITCH_SETTINGS_LINK, switch_type) }}
+++				{{ _self.number('extmgrplus_number_vc_limit', EXTMGRPLUS_NUMBER_VC_LIMIT, 1, 99) }}
+++				{{ lang('SECONDS') }}
++ 			</dd>
++ 		</dl>
++ 
++@@ -124,17 +126,7 @@
++ 		</dl>
++ 
++ 		<legend class="legend_sub">{{ lang('EXTMGRPLUS_SECTION_EXPERT_SETTINGS') }}</legend>
++-		<p class="legend_explain">{{ lang('EXTMGRPLUS_EXPERT_SETTINGS_EXPLAIN') }}</p>
++-
++-		<dl>
++-			<dt>
++-				<label>{{ lang('EXTMGRPLUS_INSTRUCTIONS') ~ lang('COLON') }}</label><br>
++-				<span>{{ lang('EXTMGRPLUS_INSTRUCTIONS_EXPLAIN') }}</span>
++-			</dt>
++-			<dd>
++-				{{ _self.switch('extmgrplus_switch_instructions', EXTMGRPLUS_SWITCH_INSTRUCTIONS, switch_type) }}
++-			</dd>
++-		</dl>
+++		<p>{{ lang('EXTMGRPLUS_EXPERT_SETTINGS_EXPLAIN') }}</p>
++ 
++ 		<dl>
++ 			<dt>
++@@ -175,7 +167,7 @@
++ 				<span>{{ lang('EXTMGRPLUS_DEFAULTS_EXP') }}</span>
++ 			</dt>
++ 			<dd>
++-				<input type="button" class="button2" name="extmgrplus_defaults" value="{{ lang('EXTMGRPLUS_BUTTON_DEFAULTS') }}">
+++				{{ _self.button('extmgrplus_defaults', 'EXTMGRPLUS_BUTTON_DEFAULTS') }}
++ 			</dd>
++ 		</dl>
++ 	</fieldset>
++@@ -232,13 +224,17 @@
++ 	}}>
++ {%- endmacro %}
++ 
+++{% macro button(name, lang_var) -%}
+++	<input type="button" class="button2" name="{{ name }}" value="{{ lang(lang_var) }}">
+++{%- endmacro %}
+++
++ {% macro confirmbox(name, message, default = false) -%}
++-	<div class="lukewcs_confirmbox" data-name="{{ name }}" data-default="{{ default }}" style="display: none;">
+++	<div id="{{ name }}_confirmbox" data-default="{{ default }}" style="display: none;">
++ 		<h2>{{ lang('CONFIRM') }}</h2>
++ 		<p>{{ message }}</p>
++ 		<p>
++-			<input type="button" class="button1" name="lukewcs_confirmbox_yes" value="{{ lang('YES') }}">&nbsp;
++-			<input type="button" class="button2" name="lukewcs_confirmbox_no" value="{{ lang('NO') }}">
+++			<input type="button" class="button1" name="{{ name }}_confirm_yes" value="{{ lang('YES') }}">&nbsp;
+++			<input type="button" class="button2" name="{{ name }}_confirm_no" value="{{ lang('NO') }}">
++ 		</p>
++ 	</div>
++ {%- endmacro %}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_settings.js" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_settings.js"
++index 38cce605c..146ad6c94 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_settings.js"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_settings.js"
++@@ -11,140 +11,142 @@
++ */
++ 
++ (function ($) {
++-	'use strict';
++-
++-	/*
++-		Classes
++-	*/
++-
++-	class LukeWCSphpBBConfirmBox {
++-		/*
++-		* phpBB ConfirmBox class for checkboxes and yes/no radio buttons - v1.5.1
++-		* @copyright (c) 2023, LukeWCS, https://www.wcsaga.org
++-		* @license GNU General Public License, version 2 (GPL-2.0-only)
++-		*/
++-
++-		constructor(submitSelector, animDuration = 0) {
++-			let _this = this;
++-			this.$submitObject	= $(submitSelector);
++-			this.$formObject	= this.$submitObject.parents('form');
++-			this.animDuration	= animDuration;
++-
++-			this.$formObject.find('div.lukewcs_confirmbox').each(function () {
++-				$('input[name="' + $(this).attr('data-name') + '"]').on('change', _this.#Show);
++-				$(this).find('input[type="button"]')				.on('click'	, _this.#Button);
++-			});
++-			this.$formObject										.on('reset'	, _this.HideAll);
++-		}
++ 
++-		HideAll = () => {
++-			const $elementObject	= this.$formObject.find('input.lukewcs_confirmbox_active');
++-			const $confirmBoxObject	= this.$formObject.find('div.lukewcs_confirmbox');
+++'use strict';
++ 
++-			this.#changeBoxState($elementObject, $confirmBoxObject, false);
++-		}
+++/*
+++	Classes
+++*/
++ 
++-		#Show = (e) => {
++-			const $elementObject	= $('input[name="' + e.target.name + '"]');
++-			const $confirmBoxObject	= $('div.lukewcs_confirmbox[data-name="' + e.target.name + '"]');
+++class LukeWCSphpBBConfirmBox {
+++/*
+++* phpBB ConfirmBox class for checkboxes and yes/no radio buttons - v1.4.3
+++* @copyright (c) 2023, LukeWCS, https://www.wcsaga.org
+++* @license GNU General Public License, version 2 (GPL-2.0-only)
+++*/
+++	constructor(submitSelector, animDuration = 0) {
+++		let _this = this;
+++		this.$submitObject	= $(submitSelector);
+++		this.$formObject	= this.$submitObject.parents('form');
+++		this.animDuration	= animDuration;
+++
+++		this.$formObject.find('div[id$="_confirmbox"]').each(function () {
+++			const elementName = this.id.replace('_confirmbox', '');
+++
+++			$('input[name="' + elementName + '"]')				.on('change'	, _this.#Show);
+++			$('input[name^="' + elementName + '_confirm_"]')	.on('click'		, _this.#Button);
+++		});
+++		this.$formObject										.on('reset'		, _this.HideAll);
+++	}
++ 
++-			if ($elementObject.prop('checked') != $confirmBoxObject.attr('data-default')) {
++-				this.#changeBoxState($elementObject, $confirmBoxObject, true);
++-			}
+++	#Show = (e) => {
+++		const $elementObject	= $('input[name="' + e.target.name + '"]');
+++		const $confirmBoxObject	= $('div[id="' + e.target.name + '_confirmbox"]');
+++
+++		if ($elementObject.prop('checked') != $confirmBoxObject.attr('data-default')) {
+++			this.#changeBoxState($elementObject, $confirmBoxObject, true);
++ 		}
+++	}
+++
+++	#Button = (e) => {
+++		const elementName		= e.target.name.replace(/_confirm_.*/, '');
+++		const $elementObject	= $('input[name="' + elementName + '"]');
+++		const $confirmBoxObject	= $('div[id="' + elementName + '_confirmbox"]');
+++		const elementType		= $elementObject.attr('type');
++ 
++-		#Button = (e) => {
++-			const elementName		= $(e.target).parents('div.lukewcs_confirmbox').attr('data-name');
++-			const $elementObject	= $('input[name="' + elementName + '"]');
++-			const elementType		= $elementObject.attr('type');
++-			const $confirmBoxObject	= $('div.lukewcs_confirmbox[data-name="' + elementName + '"]');
++-
++-			if (e.target.name == 'lukewcs_confirmbox_no') {
++-				if (elementType == 'checkbox') {
++-					$elementObject.prop('checked', $confirmBoxObject.attr('data-default'));
++-				} else if (elementType == 'radio') {
++-					$elementObject.filter('[value="' + ($confirmBoxObject.attr('data-default') ? '1' : '0') + '"]').prop('checked', true);
++-				}
+++		if (e.target.name.endsWith('_confirm_no')) {
+++			if (elementType == 'checkbox') {
+++				$elementObject.prop('checked', $confirmBoxObject.attr('data-default'));
+++			} else if (elementType == 'radio') {
+++				$elementObject.filter('[value="' + ($confirmBoxObject.attr('data-default') ? '1' : '0') + '"]').prop('checked', true);
++ 			}
++-			this.#changeBoxState($elementObject, $confirmBoxObject, null);
++ 		}
+++		this.#changeBoxState($elementObject, $confirmBoxObject, null);
+++	}
++ 
++-		#changeBoxState = ($elementObject, $confirmBoxObject, showBox) => {
++-			$elementObject		.prop('disabled', !!showBox);
++-			$elementObject		.toggleClass('lukewcs_confirmbox_active', !!showBox);
++-			$confirmBoxObject	[showBox ? 'show' : 'hide'](this.animDuration);
++-			this.$submitObject	.prop('disabled', showBox ?? this.$formObject.find('input.lukewcs_confirmbox_active').length);
++-		}
+++	HideAll = () => {
+++		const $elementObject	= this.$formObject.find('input.confirmbox_active');
+++		const $confirmBoxObject	= this.$formObject.find('div[id$="_confirmbox"]');
+++
+++		this.#changeBoxState($elementObject, $confirmBoxObject, false);
++ 	}
++ 
++-	/*
++-		Declarations
++-	*/
++-
++-	const constants = Object.freeze({
++-		CheckBoxModeOff:	'0',
++-		CheckBoxModeAll:	'1',
++-		CheckBoxModeLast:	'2',
++-	});
++-	let ConfirmBox;
++-
++-	/*
++-		Settings form
++-	*/
++-
++-	function setDefaults() {
++-		const c = constants;
++-
++-		setSwitch('[name="extmgrplus_switch_log"]',							true);
++-		setSwitch('[name="extmgrplus_switch_confirmation"]',				true);
++-		setSwitch('[name="extmgrplus_switch_auto_redirect"]',				false);
++-		$(        '[name="extmgrplus_select_checkbox_mode"]').prop('value',	c.CheckBoxModeAll);
++-		setSwitch('[name="extmgrplus_switch_order_and_ignore"]',			true);
++-		setSwitch('[name="extmgrplus_switch_self_disable"]',				false);
++-		setSwitch('[name="extmgrplus_switch_instructions"]',				true);
++-		setSwitch('[name="extmgrplus_switch_settings_link"]',				true);
++-		$(        '[name="extmgrplus_number_vc_limit"]').prop('value',		15);
++-		setSwitch('[name="extmgrplus_switch_migration_col"]',				false);
++-		setSwitch('[name="extmgrplus_switch_migrations"]',					false);
++-		setSwitch('[name="extmgrplus_switch_version_url"]',					false);
++-
++-		ConfirmBox.HideAll();
++-	};
++-
++-	function setSwitch(selector, checked) {
++-		const $elementObject	= $(selector);
++-		const elementType		= $elementObject.attr('type');
+++	#changeBoxState = ($elementObject, $confirmBoxObject, showBox) => {
+++		$elementObject		.prop('disabled', !!showBox);
+++		$elementObject		.toggleClass('confirmbox_active', !!showBox);
+++		$confirmBoxObject	[showBox ? 'show' : 'hide'](this.animDuration);
+++		this.$submitObject	.prop('disabled', showBox ?? this.$formObject.find('input.confirmbox_active').length);
+++	}
+++}
++ 
++-		if (elementType == 'checkbox') {
++-			$elementObject.prop('checked', checked);
++-		} else if (elementType == 'radio') {
++-			$elementObject.filter('[value="' + (checked ? '1' : '0') + '"]').prop('checked', true);
++-		}
++-	};
+++/*
+++	Declarations
+++*/
++ 
++-	function formSubmit() {
++-		$('[name="extmgrplus_save_settings"]').click();
++-	};
+++const constants = Object.freeze({
+++	CheckBoxModeOff:	'0',
+++	CheckBoxModeAll:	'1',
+++	CheckBoxModeLast:	'2',
+++});
+++let ConfirmBox;
++ 
++-	/*
++-		Common
++-	*/
+++/*
+++	Settings form
+++*/
++ 
++-	function disableEnter(e) {
++-		if (e.key == 'Enter' && e.target.type != 'textarea') {
++-			return false;
++-		}
++-	};
+++function setDefaults() {
+++	const c = constants;
+++
+++	setSwitch('[name="extmgrplus_switch_log"]',							true);
+++	setSwitch('[name="extmgrplus_switch_confirmation"]',				true);
+++	setSwitch('[name="extmgrplus_switch_auto_redirect"]',				false);
+++	$(        '[name="extmgrplus_select_checkbox_mode"]').prop('value',	c.CheckBoxModeAll);
+++	setSwitch('[name="extmgrplus_switch_order_and_ignore"]',			true);
+++	setSwitch('[name="extmgrplus_switch_self_disable"]',				false);
+++	setSwitch('[name="extmgrplus_switch_instructions"]',				true);
+++	$(        '[name="extmgrplus_number_vc_limit"]').prop('value',		15);
+++	setSwitch('[name="extmgrplus_switch_migration_col"]',				false);
+++	setSwitch('[name="extmgrplus_switch_migrations"]',					false);
+++	setSwitch('[name="extmgrplus_switch_version_url"]',					false);
+++
+++	ConfirmBox.HideAll();
+++};
+++
+++function setSwitch(selector, checked) {
+++	const $elementObject	= $(selector);
+++	const elementType		= $elementObject.attr('type');
+++
+++	if (elementType == 'checkbox') {
+++		$elementObject.prop('checked', checked);
+++	} else if (elementType == 'radio') {
+++		$elementObject.filter('[value="' + (checked ? '1' : '0') + '"]').prop('checked', true);
+++	}
+++};
+++
+++function formSubmit() {
+++	$('[name="extmgrplus_save_settings"]').click();
+++};
+++
+++/*
+++	Common
+++*/
+++
+++function disableEnter(e) {
+++	if (e.key == 'Enter' && e.target.type != 'textarea') {
+++		return false;
+++	}
+++};
+++
+++/*
+++	Event registration
+++*/
++ 
++-	/*
++-		Event registration
++-	*/
+++$(function () {
+++	$('#extmgrplus_settings')			.on('keypress'	, disableEnter);
+++	$('[name="extmgrplus_defaults"]')	.on('click'		, setDefaults);
+++	$('[name="extmgrplus_submit"]')		.on('click'		, formSubmit);
++ 
++-	$(function () {
++-		$('#extmgrplus_settings')			.on('keypress'	, disableEnter);
++-		$('[name="extmgrplus_defaults"]')	.on('click'		, setDefaults);
++-		$('[name="extmgrplus_submit"]')		.on('click'		, formSubmit);
+++	ConfirmBox = new LukeWCSphpBBConfirmBox('[name="extmgrplus_submit"]', 300);
+++});
++ 
++-		ConfirmBox = new LukeWCSphpBBConfirmBox('[name="extmgrplus_submit"]', 300);
++-	});
++ })(jQuery);
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_versioncheck.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_versioncheck.html"
++index 9d6aaf8c4..eb385e167 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_versioncheck.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_versioncheck.html"
++@@ -14,6 +14,8 @@
++ 
++ {% INCLUDE 'overall_header.html' %}
++ 
+++<a id="maincontent"></a>
+++
++ <h1>{{ lang('EXTENSIONS_ADMIN') }}</h1>
++ 
++ <p>{{ lang('EXTENSIONS_EXPLAIN') }}</p>
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/adm/style/event/acp_ext_details_end.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/adm/style/event/acp_ext_details_end.html"
++new file mode 100644
++index 000000000..13dbd1022
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/adm/style/event/acp_ext_details_end.html"
++@@ -0,0 +1,26 @@
+++{% import '@lukewcs_extmgrplus/acp_ext_mgr_plus_macros.html' as common %}
+++
+++
+++{% if EXTMGRPLUS_DETAILS|length %}
+++	<fieldset>
+++		<legend>{{ lang('EXTMGRPLUS_SECTION_DETAILS') }}</legend>
+++
+++	{% if EXTMGRPLUS_DETAILS.cdb_page %}
+++		<dl>
+++			<dt><label>{{ lang('EXTMGRPLUS_DETAILS_CDB_PAGE') ~ lang('COLON') }}</label></dt>
+++			<dd><strong><a href="{{ EXTMGRPLUS_DETAILS.cdb_page }}">{{ EXTMGRPLUS_DETAILS.cdb_page }}</a></strong></dd>
+++		</dl>
+++	{% endif %}
+++
+++	{% if EXTMGRPLUS_DETAILS.version_url %}
+++		<dl>
+++			<dt><label>{{ lang('EXTMGRPLUS_DETAILS_VERSION_URL') ~ lang('COLON') }}</label></dt>
+++			<dd><strong><a href="{{ EXTMGRPLUS_DETAILS.version_url }}">{{ EXTMGRPLUS_DETAILS.version_url }}</a></strong></dd>
+++		</dl>
+++	{% endif %}
+++	</fieldset>
+++{% endif %}
+++
+++{{ common.footer(EXTMGRPLUS_METADATA) }}
+++
+++{% INCLUDECSS '@lukewcs_extmgrplus/acp_ext_mgr_plus.css' %}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/composer.json"
++index 42a77c63f..577550354 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/composer.json"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/composer.json"
++@@ -3,8 +3,8 @@
++     "type": "phpbb-extension",
++     "description": "Adds the option to disable and re-enable all installed extensions at once to the extension management. Individual selections can be made using checkboxes. In addition, sequence groups and dependencies can be defined or extensions can be ignored. The version check is carried out in blocks and provides detailed information. Additional information is displayed in the extension management.",
++     "homepage": "https://github.com/LukeWCS/ext-mgr-plus",
++-    "version": "3.1.0",
++-    "time": "2025-11-01",
+++    "version": "3.0.0",
+++    "time": "2024-11-28",
++     "license": "GPL-2.0-only",
++     "authors": [
++         {
++@@ -19,13 +19,13 @@
++         }
++     ],
++     "require": {
++-        "php": ">=8.0.0,<8.5.0@dev",
+++        "php": ">=7.4.0,<8.5.0@dev",
++         "composer/installers": "~1.0.0",
++         "phpbb/phpbb": ">=3.3.8,<3.4.0@dev"
++     },
++     "extra": {
++         "display-name": "Extension Manager Plus",
++-        "lang-min-ver": "3.1.0",
+++        "lang-min-ver": "3.0.0",
++         "soft-require": {
++             "phpbb/phpbb": ">=3.3.8,<3.4.0@dev"
++         },
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/config/services.yml" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/config/services.yml"
++index a70d6857b..f5395d02b 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/config/services.yml"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/config/services.yml"
++@@ -19,8 +19,9 @@ services:
++             - '@language'
++             - '@template'
++             - '@dbal.conn'
++-            - '@path_helper'
++             - '%core.table_prefix%'
+++            - '%core.root_path%'
+++            - '%core.php_ext%'
++     lukewcs.extmgrplus.core.common:
++         class: lukewcs\extmgrplus\core\ext_mgr_plus_common
++         arguments:
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/controller/acp_ext_mgr_plus_controller.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/controller/acp_ext_mgr_plus_controller.php"
++index 2943e9378..0f91e63be 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/controller/acp_ext_mgr_plus_controller.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/controller/acp_ext_mgr_plus_controller.php"
++@@ -15,16 +15,27 @@ namespace lukewcs\extmgrplus\controller;
++ 
++ class acp_ext_mgr_plus_controller
++ {
+++	protected object $common;
+++	protected object $language;
+++	protected object $template;
+++	protected object $request;
+++	protected object $config;
+++
++ 	protected string $u_action;
++ 
++ 	public function __construct(
++-		protected object $common,
++-		protected \phpbb\language\language $language,
++-		protected \phpbb\template\template $template,
++-		protected \phpbb\request\request $request,
++-		protected \phpbb\config\config $config,
+++		$common,
+++		\phpbb\language\language $language,
+++		\phpbb\template\template $template,
+++		\phpbb\request\request $request,
+++		\phpbb\config\config $config
++ 	)
++ 	{
+++		$this->common	= $common;
+++		$this->language	= $language;
+++		$this->template	= $template;
+++		$this->request	= $request;
+++		$this->config	= $config;
++ 	}
++ 
++ 	public function module_settings(): void
++@@ -54,7 +65,6 @@ class acp_ext_mgr_plus_controller
++ 			$this->config->set('extmgrplus_switch_order_and_ignore'	, $this->request->variable('extmgrplus_switch_order_and_ignore'	, 0));
++ 			$this->config->set('extmgrplus_switch_self_disable'		, $this->request->variable('extmgrplus_switch_self_disable'		, 0));
++ 			$this->config->set('extmgrplus_switch_instructions'		, $this->request->variable('extmgrplus_switch_instructions'		, 0));
++-			$this->config->set('extmgrplus_switch_settings_link'	, $this->request->variable('extmgrplus_switch_settings_link'	, 0));
++ 			$this->config->set('extmgrplus_number_vc_limit'			, $this->request->variable('extmgrplus_number_vc_limit'			, 0));
++ 			$this->config->set('extmgrplus_switch_migration_col'	, $this->request->variable('extmgrplus_switch_migration_col'	, 0));
++ 			$this->config->set('extmgrplus_switch_migrations'		, $this->request->variable('extmgrplus_switch_migrations'		, 0));
++@@ -77,7 +87,6 @@ class acp_ext_mgr_plus_controller
++ 			'EXTMGRPLUS_SWITCH_ORDER_AND_IGNORE'		=> (bool) $this->config['extmgrplus_switch_order_and_ignore'],
++ 			'EXTMGRPLUS_SWITCH_SELF_DISABLE'			=> (bool) $this->config['extmgrplus_switch_self_disable'],
++ 			'EXTMGRPLUS_SWITCH_INSTRUCTIONS'			=> (bool) $this->config['extmgrplus_switch_instructions'],
++-			'EXTMGRPLUS_SWITCH_SETTINGS_LINK'			=> (bool) $this->config['extmgrplus_switch_settings_link'],
++ 			'EXTMGRPLUS_NUMBER_VC_LIMIT'				=> (int) $this->config['extmgrplus_number_vc_limit'],
++ 			'EXTMGRPLUS_SWITCH_MIGRATION_COL'			=> (bool) $this->config['extmgrplus_switch_migration_col'],
++ 			'EXTMGRPLUS_SWITCH_MIGRATIONS'				=> (bool) $this->config['extmgrplus_switch_migrations'],
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/core/ext_mgr_plus.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/core/ext_mgr_plus.php"
++index ee129cbb4..7bc61a912 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/core/ext_mgr_plus.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/core/ext_mgr_plus.php"
++@@ -19,34 +19,55 @@ class ext_mgr_plus
++ 	protected const  CHECKBOX_ALL	= 1;
++ 	protected const  CHECKBOX_LAST	= 2;
++ 
++-	protected const  CDB_EXT			= 1;
++-	protected const  CDB_EXT_OFFICIAL	= 2;
++-
++-	protected string $u_action;
++-	protected int $safe_time_limit;
+++	protected object $common;
+++	protected object $ext_manager;
+++	protected object $cache;
+++	protected object $request;
+++	protected object $log;
+++	protected object $user;
+++	protected object $config;
+++	protected object $config_text;
+++	protected object $language;
+++	protected object $template;
+++	protected object $db;
+++	protected string $table_prefix;
++ 	protected string $phpbb_root_path;
++-	protected string $phpbb_admin_path;
++ 	protected string $php_ext;
++ 
+++	protected string $u_action;
+++	protected int    $safe_time_limit;
+++
++ 	public function __construct(
++-		protected object $common,
++-		protected \phpbb\extension\manager $ext_manager,
++-		protected \phpbb\cache\driver\driver_interface $cache,
++-		protected \phpbb\request\request $request,
++-		protected \phpbb\log\log $log,
++-		protected \phpbb\user $user,
++-		protected \phpbb\config\config $config,
++-		protected \phpbb\config\db_text $config_text,
++-		protected \phpbb\language\language $language,
++-		protected \phpbb\template\template $template,
++-		protected \phpbb\db\driver\driver_interface $db,
++-		protected \phpbb\path_helper $path_helper,
++-		protected string $table_prefix,
+++		$common,
+++		\phpbb\extension\manager $ext_manager,
+++		\phpbb\cache\driver\driver_interface $cache,
+++		\phpbb\request\request $request,
+++		\phpbb\log\log $log,
+++		\phpbb\user $user,
+++		\phpbb\config\config $config,
+++		\phpbb\config\db_text $config_text,
+++		\phpbb\language\language $language,
+++		\phpbb\template\template $template,
+++		\phpbb\db\driver\driver_interface $db,
+++		$table_prefix,
+++		$phpbb_root_path,
+++		$php_ext
++ 	)
++ 	{
++-		$this->phpbb_root_path	= $this->path_helper->get_phpbb_root_path();
++-		$this->phpbb_admin_path	= $this->phpbb_root_path . $this->path_helper->get_adm_relative_path();
++-		$this->php_ext			= $this->path_helper->get_php_ext();
+++		$this->common			= $common;
+++		$this->ext_manager		= $ext_manager;
+++		$this->cache			= $cache;
+++		$this->request			= $request;
+++		$this->log				= $log;
+++		$this->user				= $user;
+++		$this->config			= $config;
+++		$this->config_text		= $config_text;
+++		$this->language			= $language;
+++		$this->template			= $template;
+++		$this->db				= $db;
+++		$this->table_prefix 	= $table_prefix;
+++		$this->phpbb_root_path	= $phpbb_root_path;
+++		$this->php_ext			= $php_ext;
++ 	}
++ 
++ 	/*
++@@ -59,9 +80,9 @@ class ext_mgr_plus
++ 			return;
++ 		}
++ 
++-		$this->u_action			= $event['u_action'];
++-		$this->common->u_action	= $this->u_action;
++-		$this->safe_time_limit	= $event['safe_time_limit'];
+++		$this->u_action = $event['u_action'];
+++		$this->common->u_action = $this->u_action;
+++		$this->safe_time_limit = $event['safe_time_limit'];
++ 
++ 		$this->language->add_lang(['acp_ext_mgr_plus', 'acp_ext_mgr_plus_lang_author'], 'lukewcs/extmgrplus');
++ 		$this->common->set_meta_template_vars('EXTMGRPLUS', 'LukeWCS');
++@@ -74,19 +95,17 @@ class ext_mgr_plus
++ 
++ 			$this->exts_switch_confirm();
++ 		}
++-		else if ($this->request->is_set_post('extmgrplus_save_ext_properties'))
+++		else if ($this->request->is_set_post('extmgrplus_save_ext_properties') && $this->config['extmgrplus_switch_order_and_ignore'])
++ 		{
++ 			$this->common->check_form_key_('lukewcs_extmgrplus');
++ 
++-			if ($this->config['extmgrplus_switch_order_and_ignore'])
++-			{
++-				$order_list		= $this->request->variable('ext_order', ['' => '']);
++-				$ignore_list	= $this->request->variable('ext_ignore', ['']);
++-				$order_list		= preg_grep('/^\+?[0-9]{1,2}$/', $order_list);
+++			$order_list = $this->request->variable('ext_order', ['' => '']);
+++			$ignore_list = $this->request->variable('ext_ignore', ['']);
++ 
++-				$this->common->config_text_set('extmgrplus_list_order_and_ignore', 'order', count($order_list) ? $order_list : null);
++-				$this->common->config_text_set('extmgrplus_list_order_and_ignore', 'ignore', count($ignore_list) ? $ignore_list : null);
++-			}
+++			$order_list = preg_grep('/^\+?[0-9]{1,2}$/', $order_list);
+++
+++			$this->common->config_text_set('extmgrplus_list_order_and_ignore', 'order', count($order_list) ? $order_list : null);
+++			$this->common->config_text_set('extmgrplus_list_order_and_ignore', 'ignore', count($ignore_list) ? $ignore_list : null);
++ 
++ 			$this->common->trigger_error_($this->language->lang('EXTMGRPLUS_MSG_EXT_PROPERTIES_SAVED'), E_USER_NOTICE, 'RETURN_TO_EXTENSION_LIST');
++ 		}
++@@ -111,8 +130,6 @@ class ext_mgr_plus
++ 	{
++ 		if ($event['action'] == 'details')
++ 		{
++-			$event['tpl_name'] = '@lukewcs_extmgrplus/acp_ext_mgr_plus_acp_ext_details';
++-
++ 			$this->extend_details($event['ext_name']);
++ 			$this->versioncheck_details($event['ext_name']);
++ 			return;
++@@ -136,7 +153,6 @@ class ext_mgr_plus
++ 		if ($vc_request)
++ 		{
++ 			$event['tpl_name'] = '@lukewcs_extmgrplus/acp_ext_mgr_plus_versioncheck';
++-
++ 			$this->template->assign_vars([
++ 				'EXTMGRPLUS_VC_DATA'		=> $ext_list_versioncheck['data'],
++ 				'U_EXTMGRPLUS_VC_CANCEL'	=> $this->u_action,
++@@ -165,7 +181,6 @@ class ext_mgr_plus
++ 		$ext_list_migrations_inactive			= [];
++ 		$ext_list_order							= [];
++ 		$ext_list_ignore						= [];
++-		$ext_list_modules						= [];
++ 		$ext_list_enabled_ignored				= [];
++ 		$ext_list_disabled_ignored				= [];
++ 		$ext_list_selected						= [];
++@@ -184,11 +199,6 @@ class ext_mgr_plus
++ 			$ext_list_disabled_ignored	= array_intersect_key($ext_list_ignore, $ext_list_disabled);
++ 		}
++ 
++-		if ($this->config['extmgrplus_switch_settings_link'])
++-		{
++-			$ext_list_modules = $this->get_module_links();
++-		}
++-
++ 		if ($this->config['extmgrplus_switch_migration_col'])
++ 		{
++ 			$ext_list_migrations_inactive = $this->get_exts_with_new_migration(array_diff_key($ext_list_available, $ext_list_enabled, $ext_list_ignore));
++@@ -204,7 +214,6 @@ class ext_mgr_plus
++ 		{
++ 			$ext_list_enabled_ignored['lukewcs/extmgrplus'] = 0;
++ 		}
++-
++ 		if (!$this->config['extmgrplus_switch_migrations'])
++ 		{
++ 			$ext_list_disabled_ignored = array_merge($ext_list_disabled_ignored, $ext_list_migrations_disabled);
++@@ -246,7 +255,6 @@ class ext_mgr_plus
++ 			'EXTMGRPLUS_LIST_IGNORE'				=> $ext_list_ignore,
++ 			'EXTMGRPLUS_LIST_MIGRATIONS'			=> $ext_list_migrations_inactive,
++ 			'EXTMGRPLUS_LIST_SELECTED'				=> $ext_list_selected,
++-			'EXTMGRPLUS_LIST_MODULES'				=> $ext_list_modules,
++ 			'EXTMGRPLUS_LIST_VERSIONCHECK'			=> $this->versioncheck_list($ext_list_available, $ext_list_versioncheck),
++ 
++ 			'EXTMGRPLUS_COUNT'						=> [
++@@ -265,7 +273,6 @@ class ext_mgr_plus
++ 			'EXTMGRPLUS_SWITCH_ORDER_AND_IGNORE'	=> $this->config['extmgrplus_switch_order_and_ignore'],
++ 			'EXTMGRPLUS_SWITCH_SELF_DISABLE'		=> $this->config['extmgrplus_switch_self_disable'],
++ 			'EXTMGRPLUS_SWITCH_INSTRUCTIONS'		=> $this->config['extmgrplus_switch_instructions'],
++-			'EXTMGRPLUS_SWITCH_SETTINGS_LINK'		=> $this->config['extmgrplus_switch_settings_link'],
++ 			'EXTMGRPLUS_SWITCH_MIGRATION_COL'		=> $this->config['extmgrplus_switch_migration_col'],
++ 			'EXTMGRPLUS_SWITCH_MIGRATIONS'			=> $this->config['extmgrplus_switch_migrations'],
++ 		]);
++@@ -277,7 +284,7 @@ class ext_mgr_plus
++ 	*/
++ 	public function change_msg_template(): void
++ 	{
++-		if ($this->template->retrieve_var('EXTMGRPLUS_TRIGGER_ERROR') !== null)
+++		if ($this->template->retrieve_var('EXTMGRPLUS_TRIGGER_ERROR'))
++ 		{
++ 			$this->template->set_filenames(['body' => '@lukewcs_extmgrplus/acp_ext_mgr_plus_message_body.html']);
++ 		}
++@@ -327,8 +334,7 @@ class ext_mgr_plus
++ 		{
++ 			$this->template->assign_vars([
++ 				'EXTMGRPLUS_ACTION_MODE'	=> 'DISABLE',
++-				'EXTMGRPLUS_CONFIRM_YES'	=> 'EXTENSION_DISABLE',
++-				'EXTMGRPLUS_CONFIRM_NO'		=> 'CANCEL',
+++				'EXTMGRPLUS_SELF_DISABLE'	=> array_search('lukewcs/extmgrplus', $ext_mark_enabled) !== false,
++ 			]);
++ 			if (!$this->config['extmgrplus_switch_confirmation'] || confirm_box(true))
++ 			{
++@@ -343,8 +349,6 @@ class ext_mgr_plus
++ 		{
++ 			$this->template->assign_vars([
++ 				'EXTMGRPLUS_ACTION_MODE'	=> 'ENABLE',
++-				'EXTMGRPLUS_CONFIRM_YES'	=> 'EXTENSION_ENABLE',
++-				'EXTMGRPLUS_CONFIRM_NO'		=> 'CANCEL',
++ 			]);
++ 			if (!$this->config['extmgrplus_switch_confirmation'] || confirm_box(true))
++ 			{
++@@ -393,17 +397,17 @@ class ext_mgr_plus
++ 		{
++ 			try
++ 			{
++-				$ext_meta = $this->ext_manager->create_extension_metadata_manager($ext_name)->get_metadata('all');
+++				$ext_metadata = $this->ext_manager->create_extension_metadata_manager($ext_name)->get_metadata('all');
++ 			}
++ 			catch (\RuntimeException $e)
++ 			{
++-				$ext_meta = null;
+++				$ext_metadata = null;
++ 			}
++ 
++-			if (is_array($ext_meta))
+++			if (is_array($ext_metadata))
++ 			{
++-				$ext_display_name	= $ext_meta['extra']['display-name'] ?? '';
++-				$ext_version		= $ext_meta['version'] ?? '';
+++				$ext_display_name	= $ext_metadata['extra']['display-name'] ?? '';
+++				$ext_version		= $ext_metadata['version'] ?? '';
++ 
++ 				$disable_error = '';
++ 				if ($this->ext_manager->is_enabled($ext_name))
++@@ -436,7 +440,7 @@ class ext_mgr_plus
++ 				}
++ 			}
++ 
++-			if ($this->safe_time_limit > 0 && (microtime(true) - $GLOBALS['starttime']) >= $this->safe_time_limit)
+++			if ((microtime(true) - $GLOBALS['starttime']) >= $this->safe_time_limit)
++ 			{
++ 				$safe_time_exceeded = true;
++ 				break;
++@@ -458,7 +462,7 @@ class ext_mgr_plus
++ 		}
++ 		$this->common->trigger_error_(
++ 			$this->language->lang('EXTMGRPLUS_MSG_DEACTIVATION', $ext_count_success, $ext_count_enabled) . ($msg_failed ?? ''),
++-			$this->get_error_level($ext_count_success, $ext_count_enabled, $safe_time_exceeded),
+++			(($ext_count_success != $ext_count_enabled || $safe_time_exceeded) ? E_USER_WARNING : E_USER_NOTICE),
++ 			'RETURN_TO_EXTENSION_LIST'
++ 		);
++ 	}
++@@ -498,17 +502,17 @@ class ext_mgr_plus
++ 		{
++ 			try
++ 			{
++-				$ext_meta = $this->ext_manager->create_extension_metadata_manager($ext_name)->get_metadata('all');
+++				$ext_metadata = $this->ext_manager->create_extension_metadata_manager($ext_name)->get_metadata('all');
++ 			}
++ 			catch (\RuntimeException $e)
++ 			{
++-				$ext_meta = null;
+++				$ext_metadata = null;
++ 			}
++ 
++-			if (is_array($ext_meta))
+++			if (is_array($ext_metadata))
++ 			{
++-				$ext_display_name	= $ext_meta['extra']['display-name'] ?? '';
++-				$ext_version		= $ext_meta['version'] ?? '';
+++				$ext_display_name	= $ext_metadata['extra']['display-name'] ?? '';
+++				$ext_version		= $ext_metadata['version'] ?? '';
++ 
++ 				if ($this->ext_manager->is_disabled($ext_name))
++ 				{
++@@ -554,7 +558,7 @@ class ext_mgr_plus
++ 				}
++ 			}
++ 
++-			if ($this->safe_time_limit > 0 && (microtime(true) - $GLOBALS['starttime']) >= $this->safe_time_limit)
+++			if ((microtime(true) - $GLOBALS['starttime']) >= $this->safe_time_limit)
++ 			{
++ 				$safe_time_exceeded = true;
++ 				break;
++@@ -576,7 +580,7 @@ class ext_mgr_plus
++ 		}
++ 		$this->common->trigger_error_(
++ 			$this->language->lang('EXTMGRPLUS_MSG_ACTIVATION', $ext_count_success, $ext_count_disabled) . ($msg_failed ?? ''),
++-			$this->get_error_level($ext_count_success, $ext_count_disabled, $safe_time_exceeded),
+++			(($ext_count_success != $ext_count_disabled || $safe_time_exceeded) ? E_USER_WARNING : E_USER_NOTICE),
++ 			'RETURN_TO_EXTENSION_LIST'
++ 		);
++ 	}
++@@ -588,14 +592,14 @@ class ext_mgr_plus
++ 	{
++ 		$msg_failed = '<br><br>' . $this->language->lang($lang_var);
++ 		$count_failed = 0;
++-		foreach ($ext_list as $ext_name => $vars)
+++		foreach ($ext_list as $name => $vars)
++ 		{
++ 			if (is_array($vars['message']))
++ 			{
++ 				$vars['message'] = implode('<br>', $vars['message']);
++ 			}
++ 			$count_failed++;
++-			$msg_failed .= $this->create_failed_msg($count_failed . '. ' . $vars['display_name'], $vars['ext_version'], $ext_name, $vars['message']);
+++			$msg_failed .= $this->create_failed_msg($count_failed . '. ' . $vars['display_name'], $vars['ext_version'], $name, $vars['message']);
++ 		}
++ 
++ 		return $msg_failed;
++@@ -606,24 +610,12 @@ class ext_mgr_plus
++ 	*/
++ 	private function create_failed_msg(string $display_name, string $ext_version, string $ext_name, string $message): string
++ 	{
++-		return vsprintf('<br><br><strong>%1$s %2$s (%3$s)</strong>%4$s', [
++-			1	=> $display_name,
++-			2	=> $this->language->lang('EXTMGRPLUS_VERSION_STRING', $ext_version),
++-			3	=> $ext_name,
++-			4	=> empty($message) ? '' : "<br><br><em>{$message}</em>"
++-		]);
++-	}
++-
++-	/*
++-		Helper function for trigger_error
++-	*/
++-	function get_error_level(int $count_success, int $count_total, bool $safe_time_exceeded): int
++-	{
++-		return match (true) {
++-			$count_success == $count_total				=> E_USER_NOTICE,
++-			$count_success == 0, $safe_time_exceeded	=> E_USER_WARNING,
++-			default										=> E_USER_NOTICE + E_USER_ERROR,
++-		};
+++		return sprintf('<br><br><strong>%1$s %2$s (%3$s)</strong>%4$s',
+++			/* 1 */	$display_name,
+++			/* 2 */	$this->language->lang('EXTMGRPLUS_VERSION_STRING', $ext_version),
+++			/* 3 */	$ext_name,
+++			/* 4 */	empty($message) ? '' : "<br><br><em>{$message}</em>"
+++		);
++ 	}
++ 
++ 	/*
++@@ -673,48 +665,6 @@ class ext_mgr_plus
++ 		return count($migration_classes_new);
++ 	}
++ 
++-	/*
++-		Determine all ACP module links of the active extensions
++-	*/
++-	private function get_module_links(): array
++-	{
++-		global $module;
++-
++-		$module_urls = [];
++-		$module_tabs = [];
++-
++-		$modules = array_combine(array_column($module->module_ary, 'id'), $module->module_ary);
++-		$get_module_top_cat = function (int $module_id) use ($modules): string
++-		{
++-			$parent_id = $modules[$module_id]['parent'];
++-			while ($parent_id !== 0)
++-			{
++-				$module_id = $parent_id;
++-				$parent_id = $modules[$module_id]['parent'];
++-			}
++-
++-			return $modules[$module_id]['langname'];
++-		};
++-
++-		foreach (array_filter($modules, fn($row): bool => $row['name'] !== '' && $row['display']) as $module_row)
++-		{
++-			preg_match('/\\\\(.+?)\\\\(.+?)\\\\.*/', $module_row['name'], $matches);
++-			$tech_name = (count($matches) === 3) ? $matches[1] . '/' . $matches[2] : false;
++-			if ($tech_name !== false)
++-			{
++-				$module_tab = $get_module_top_cat($module_row['parent']);
++-				if (!isset($module_urls[$tech_name]) || ($module_tab === 'ACP_CAT_DOT_MODS' && $module_tabs[$tech_name] !== $module_tab))
++-				{
++-					$module_name = str_replace('\\', '-', $module_row['name']);
++-					$module_urls[$tech_name] = append_sid("{$this->phpbb_admin_path}index.{$this->php_ext}", "i={$module_name}&amp;mode={$module_row['mode']}");
++-					$module_tabs[$tech_name] = $module_tab;
++-				}
++-			}
++-		}
++-
++-		return $module_urls;
++-	}
++-
++ 	/*
++ 		Check if file is a valid migration file
++ 	*/
++@@ -726,14 +676,17 @@ class ext_mgr_plus
++ 			$file_content = file_get_contents($file);
++ 			if ($file_content !== false)
++ 			{
++-				return (
++-					preg_match('/function\s+?(?:depends_on|effectively_installed|update_schema|update_data|revert_data)\s*?\(/', $file_content)
++-					&& preg_match('/^\s*?class\s+?' . $file_info['filename'] . '\s+/mi', $file_content)
++-				) ? 1 : 0;
+++				$check_migration = ((
+++						preg_match('/function\s+?(?:depends_on|effectively_installed|update_schema|update_data|revert_data)\s*?\(/', $file_content)
+++						&& preg_match('/^\s*?class\s+?' . $file_info['filename'] . '\s+/mi', $file_content)
+++					)
+++					? 1
+++					: 0
+++				);
++ 			}
++ 		}
++ 
++-		return -1;
+++		return ($check_migration ?? -1);
++ 	}
++ 
++ 	/*
++@@ -757,7 +710,7 @@ class ext_mgr_plus
++ 	/*
++ 		Preparation to be able to run a version check in blocks
++ 	*/
++-	private function versioncheck_prepare(array|null &$ext_list_vc): void
+++	private function versioncheck_prepare(?array &$ext_list_vc): void
++ 	{
++ 		$ext_list_all	= $this->ext_manager->all_available();
++ 		$ext_list_vc	= [
++@@ -778,7 +731,6 @@ class ext_mgr_plus
++ 			}
++ 			catch (\RuntimeException $e)
++ 			{
++-				$vc_meta = null;
++ 			}
++ 
++ 			if (isset($vc_meta))
++@@ -789,7 +741,6 @@ class ext_mgr_plus
++ 				$this->cache->destroy(str_replace(['/', '\\'], '-', $cache_filename));
++ 			}
++ 		}
++-
++ 		$ext_list_vc['data']['count_total']	= count($ext_list_vc) - 1;
++ 		$this->common->config_text_set('extmgrplus_list_version_check', 'updates', $ext_list_vc);
++ 	}
++@@ -851,8 +802,8 @@ class ext_mgr_plus
++ 
++ 		try
++ 		{
++-			$ext_meta = $md_manager->get_metadata('all');
++-			if (isset($ext_meta['extra']['version-check']))
+++			$ext_metadata = $md_manager->get_metadata('all');
+++			if (isset($ext_metadata['extra']['version-check']))
++ 			{
++ 				$vc_data = $this->ext_manager->version_check($md_manager, !$read_cache, $read_cache, $this->config['extension_force_unstable'] ? 'unstable' : null);
++ 				$vc_current = empty($vc_data) ? 'NOUPD' : $vc_data['current'];
++@@ -875,7 +826,7 @@ class ext_mgr_plus
++ 	/*
++ 		Reads the version check data from the database and removes obsolete entries and generates a list for the template
++ 	*/
++-	private function versioncheck_list(array &$ext_list, array|null &$ext_list_vc): array
+++	private function versioncheck_list(array &$ext_list, ?array &$ext_list_vc): array
++ 	{
++ 		$ext_list_vc ??= [];
++ 
++@@ -892,17 +843,10 @@ class ext_mgr_plus
++ 			}
++ 			if ($this->ext_manager->is_available($ext_name))
++ 			{
++-				try
++-				{
++-					$ext_meta = $this->ext_manager->create_extension_metadata_manager($ext_name)->get_metadata('all');
++-				}
++-				catch (\RuntimeException $e)
++-				{
++-					$ext_meta = null;
++-				}
+++				$ext_metadata = $this->ext_manager->create_extension_metadata_manager($ext_name)->get_metadata('all');
++ 
++ 				$no_ver_flags = $vc_data['current'] == 'NOUPD' || $vc_data['current'] == 'ERROR' || $vc_data['current'] == '';
++-				$has_update = !$no_ver_flags && phpbb_version_compare($ext_meta['version'] ?? '0.0.0', $vc_data['current'], '<');
+++				$has_update = !$no_ver_flags && phpbb_version_compare($ext_metadata['version'], $vc_data['current'], '<');
++ 				if ($no_ver_flags || $has_update)
++ 				{
++ 					$ext_list_tpl[$ext_name]['current'] = $vc_data['current'];
++@@ -943,19 +887,15 @@ class ext_mgr_plus
++ 		{
++ 			try
++ 			{
++-				$ext_meta = $this->ext_manager->create_extension_metadata_manager($ext_name)->get_metadata('all');
+++				$ext_metadata = $this->ext_manager->create_extension_metadata_manager($ext_name)->get_metadata('all');
++ 			}
++ 			catch (\RuntimeException $e)
++ 			{
++-				$ext_meta = null;
++ 			}
++ 
++-			if (isset($ext_meta['extra']['version-check']))
+++			if (isset($ext_metadata['extra']['version-check']))
++ 			{
++-				if (($ext_meta['extra']['version-check']['host'] ?? '') == 'www.phpbb.com')
++-				{
++-					$ext_list_tpl[$ext_name]['cdb_ext']	= substr($ext_meta['name'], 0, 6) == 'phpbb/' ? self::CDB_EXT_OFFICIAL : self::CDB_EXT;
++-				}
+++				$ext_list_tpl[$ext_name]['cdb_ext']	= ($ext_metadata['extra']['version-check']['host'] ?? '') == 'www.phpbb.com';
++ 				$count_total++;
++ 			}
++ 			else
++@@ -980,16 +920,13 @@ class ext_mgr_plus
++ 	*/
++ 	private function extend_details(string $ext_name): void
++ 	{
++-		$ext_meta	= $this->ext_manager->create_extension_metadata_manager($ext_name)->get_metadata('all');
++-		$vc_meta	= $ext_meta['extra']['version-check'] ?? null;
++-		$details	= [];
++-
+++		$vc_meta = $this->ext_manager->create_extension_metadata_manager($ext_name)->get_metadata('all')['extra']['version-check'] ?? null;
+++		$details = [];
++ 		if (isset($vc_meta))
++ 		{
++ 			if (($vc_meta['host'] ?? '') == 'www.phpbb.com')
++ 			{
++-				$details['cdb_page']	= 'https://www.phpbb.com' . $vc_meta['directory'] . '/';
++-				$details['cdb_ext']		= substr($ext_meta['name'], 0, 6) == 'phpbb/' ? self::CDB_EXT_OFFICIAL : self::CDB_EXT;
+++				$details['cdb_page'] = 'https://www.phpbb.com' . $vc_meta['directory'] . '/';
++ 			}
++ 			if ($this->config['extmgrplus_switch_version_url'])
++ 			{
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/core/ext_mgr_plus_common.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/core/ext_mgr_plus_common.php"
++index ebb95000f..f56977333 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/core/ext_mgr_plus_common.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/core/ext_mgr_plus_common.php"
++@@ -15,18 +15,30 @@ namespace lukewcs\extmgrplus\core;
++ 
++ class ext_mgr_plus_common
++ {
++-	protected array $metadata;
++-	public string $u_action;
+++	protected object $config;
+++	protected object $config_text;
+++	protected object $language;
+++	protected object $template;
+++	protected object $ext_manager;
+++
+++	protected array  $metadata;
+++	public    string $u_action;
++ 
++ 	public function __construct(
++-		protected \phpbb\config\config $config,
++-		protected \phpbb\config\db_text $config_text,
++-		protected \phpbb\language\language $language,
++-		protected \phpbb\template\template $template,
++-		protected \phpbb\extension\manager $ext_manager,
+++		\phpbb\config\config $config,
+++		\phpbb\config\db_text $config_text,
+++		\phpbb\language\language $language,
+++		\phpbb\template\template $template,
+++		\phpbb\extension\manager $ext_manager
++ 	)
++ 	{
++-		$this->metadata = $this->ext_manager->create_extension_metadata_manager('lukewcs/extmgrplus')->get_metadata('all');
+++		$this->config		= $config;
+++		$this->config_text	= $config_text;
+++		$this->language		= $language;
+++		$this->template		= $template;
+++		$this->ext_manager	= $ext_manager;
+++
+++		$this->metadata		= $this->ext_manager->create_extension_metadata_manager('lukewcs/extmgrplus')->get_metadata('all');
++ 	}
++ 
++ 	public function set_meta_template_vars(string $tpl_prefix, string $copyright): void
++@@ -70,7 +82,7 @@ class ext_mgr_plus_common
++ 			{
++ 				$lang_outdated_msg = $this->language->lang($lang_outdated_var);
++ 			}
++-			else /* Fallback if the current language package does not yet have the required variable. */
+++			else // Fallback if the current language package does not yet have the required variable.
++ 			{
++ 				$lang_outdated_msg = 'Note: The language pack for the extension <strong>%1$s</strong> is no longer up-to-date. (installed: %2$s / needed: %3$s)';
++ 			}
++@@ -83,7 +95,7 @@ class ext_mgr_plus_common
++ 	/*
++ 		Set a variable/array in a config_text variable container or delete one or all variables/arrays
++ 	*/
++-	public function config_text_set(string $container, string|null $name, $value): void
+++	public function config_text_set(string $container, ?string $name, $value): void
++ 	{
++ 		if ($this->config_text->get($container) === null)
++ 		{
++@@ -113,7 +125,7 @@ class ext_mgr_plus_common
++ 	/*
++ 		Get a variable/array from a config_text variable container
++ 	*/
++-	public function config_text_get(string $container, string|null $name = null)
+++	public function config_text_get(string $container, ?string $name = null)
++ 	{
++ 		$config_text = $this->config_text->get($container);
++ 		if ($config_text === null)
++@@ -146,30 +158,23 @@ class ext_mgr_plus_common
++ 	/*
++ 		Wrapper for trigger_error
++ 	*/
++-	public function trigger_error_(string $message, int $error_level, string|null $back_link_lang_var = null): void
+++	public function trigger_error_(string $message, int $error_type, ?string $back_link_lang_var = null): void
++ 	{
++-		if ($error_level == E_USER_NOTICE && $this->config['extmgrplus_switch_auto_redirect'])
+++		if ($error_type == E_USER_NOTICE && $this->config['extmgrplus_switch_auto_redirect'])
++ 		{
++ 			meta_refresh(1, $this->rotate_get_params($this->u_action));
++ 			$this->template->assign_var('EXTMGRPLUS_AUTO_REDIRECT', true);
++ 		}
++-
++-		$error_type = [
++-			E_USER_NOTICE					=> 0, // green box
++-			E_USER_WARNING					=> 1, // red box
++-			E_USER_NOTICE + E_USER_WARNING	=> 2, // orange box
++-			E_USER_NOTICE + E_USER_ERROR	=> 3, // green+red box
++-		][$error_level]						?? 2;
++-		$this->template->assign_var('EXTMGRPLUS_TRIGGER_ERROR', $error_type);
++-		trigger_error($message . $this->back_link($back_link_lang_var), ($error_type > 1) ? E_USER_WARNING : $error_level);
+++		$this->template->assign_var('EXTMGRPLUS_TRIGGER_ERROR', true);
+++		trigger_error($message . $this->back_link($back_link_lang_var), $error_type);
++ 	}
++ 
++-	public function back_link(string|null $lang_var = null): string
+++	public function back_link(?string $lang_var = null): string
++ 	{
++-		return vsprintf('<br><br><a href="%1$s">%2$s</a>', [
++-			1	=> $this->u_action,
++-			2	=> $this->language->lang($lang_var ?? 'BACK_TO_PREV')
++-		]);
+++		return sprintf('<br><br><a href="%1$s">%2$s</a>',
+++			/* 1 */ $this->u_action,
+++			/* 2 */ $this->language->lang($lang_var ?? 'BACK_TO_PREV')
+++		);
++ 	}
++ 
++ 	/*
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/diff_full.tmp"
++new file mode 100644
++index 000000000..e2eaac475
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/diff_full.tmp"
++@@ -0,0 +1,2172 @@
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/acp/settings_module.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/acp/settings_module.php"
+++index b9c7958c3..f0be963f2 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/acp/settings_module.php"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/acp/settings_module.php"
+++@@ -15,9 +15,9 @@ namespace lukewcs\extmgrplus\acp;
+++ 
+++ class settings_module
+++ {
+++-	public string $page_title;
+++-	public string $tpl_name;
+++-	public string $u_action;
++++	public $page_title;
++++	public $tpl_name;
++++	public $u_action;
+++ 
+++ 	public function main()
+++ 	{
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus.css" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus.css"
+++index d5f7a1824..c632316bb 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus.css"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus.css"
+++@@ -1,7 +1,33 @@
+++-/* GENERAL >>> */
++++/* GENERAL */
+++ 
+++-button[type="submit"]:is([name="confirm"], [name="cancel"]),
+++-input:is([type="submit"], [type="button"], [type="reset"])[name^="extmgrplus_"] {
++++fieldset {
++++	border-radius: 5px;
++++}
++++
++++fieldset p.submit-buttons {
++++	margin-top: 0;
++++	padding: 0 4px 4px 4px;
++++}
++++
++++fieldset dt label,
++++fieldset dd label {
++++	cursor: inherit;
++++}
++++
++++legend {
++++	background: inherit;
++++	margin: 2px 0 0 -11px;
++++	border-top: inherit;
++++	border-left: inherit;
++++	border-radius: 5px 5px 0 0;
++++	padding: 2px 10px;
++++	top: 0;
++++}
++++
++++input[type="submit"][name="confirm"],
++++input[type="submit"][name^="extmgrplus_"],
++++input[type="button"][name^="extmgrplus_"],
++++input[type="reset"][name^="extmgrplus_"] {
+++ 	padding: 3px 4px;
+++ }
+++ 
+++@@ -11,31 +37,11 @@ code {
+++ 	color: black;
+++ }
+++ 
+++-.emp_inactive {
++++.inactive {
+++ 	opacity: 0.5;
+++ }
+++ 
+++-.emp_unavailable {
+++-	opacity: 0.3;
+++-}
+++-
+++-.errorbox {
+++-	&.emp_warning {
+++-		background-color: #ffaa00;
+++-
+++-		& :is(a, a:visited) {
+++-			color: #505050;
+++-		}
+++-
+++-		& :is(h3, p, a:hover) {
+++-			color: #303030;
+++-		}
+++-	}
+++-
+++-	&.emp_success_error {
+++-		background: linear-gradient(#228822, #bc2a4d);
+++-	}
+++-}
++++/* Footer */
+++ 
+++ .extmgrplus_footer {
+++ 	margin-top: 1em;
+++@@ -43,192 +49,137 @@ code {
+++ 	font-size: 0.75em;
+++ }
+++ 
+++-#confirm {
+++-	/* confirm_box (phpBB) */
+++-
+++-	& h2 {
+++-		margin-bottom: 0.25em;
+++-	}
+++-
+++-	& :is(.button1, .button2) {
+++-		color: #000000;
+++-		background: linear-gradient(to bottom, #d2d2d2 0%, #efefef 100%);
+++-		border: 1px solid #666666;
+++-		font-size: 0.85em;
+++-		font-family: "Lucida Grande", Verdana, Helvetica, Arial, sans-serif;
+++-		vertical-align: middle;
+++-
+++-		&:hover {
+++-			border: 1px solid #bc2a4d;
+++-			background: #efefef url("../../../../../adm/images/bg_button.gif") repeat bottom;
+++-			color: #bc2a4d;
+++-		}
+++-	}
++++/* confirm_box (phpBB)*/
+++ 
+++-	& .button1 {
+++-		font-weight: bold;
+++-	}
++++#confirm h2 {
++++	margin-bottom: 0.25em;
+++ }
+++ 
+++-/* <<< GENERAL */
+++-
+++-/* SETTINGS >>> */
+++-
+++-fieldset {
+++-	border-radius: 5px;
+++-
+++-	& p.submit-buttons {
+++-		margin-top: 0;
+++-		padding: 0 4px 4px 4px;
+++-	}
+++-
+++-	& :is(dt, dd) label {
+++-		cursor: inherit;
+++-	}
++++/* SETTINGS */
+++ 
+++-	& dd a {
+++-		overflow-wrap: anywhere;
+++-	}
++++legend.legend_sub {
++++	border: 0;
++++	margin: 1em 0;
++++	padding: 0;
++++	display: flex;
++++	white-space: nowrap;
+++ }
+++ 
+++-legend {
+++-	background: inherit;
+++-	margin: 2px 0 0 -11px;
+++-	border-top: inherit;
+++-	border-left: inherit;
+++-	border-radius: 5px 5px 0 0;
+++-	padding: 2px 10px;
+++-	top: 0;
+++-
+++-	& + .legend_explain {
+++-		width: 45%;
+++-	}
+++-
+++-	&.legend_sub {
+++-		border: 0;
+++-		margin: 1em 0;
+++-		padding: 0;
+++-		display: flex;
+++-		white-space: nowrap;
+++-
+++-		&:after {
+++-			content: "";
+++-			border-bottom: 1px solid #cccccc;
+++-			width: 100%;
+++-			margin: 0 0 0.5em 1em;
+++-		}
+++-	}
++++legend.legend_sub:after {
++++	content: "";
++++	border-bottom: 1px solid #cccccc;
++++	width: 100%;
++++	margin: 0 0 0.5em 1em;
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
+++-div.lukewcs_confirmbox {
+++-	/* LukeWCSphpBBConfirmBox */
++++.toggle:checked:before {
++++	left: 2px;
++++	content: "\f00c";
++++}
++++
++++/* LukeWCSphpBBConfirmBox */
+++ 
++++div[id$="_confirmbox"] {
+++ 	max-width: 450px;
+++ 	border: 2px solid skyblue;
+++ 	margin: 0.75em 0.5em;
+++ 	padding: 0.25em 0.5em;
+++ 	border-radius: 5px;
++++	-webkit-box-shadow: 2px 2px 10px 1px rgba(121, 162, 179, 0.5);
+++ 	box-shadow: 2px 2px 10px 1px rgba(121, 162, 179, 0.5);
++++}
+++ 
+++-	& h2 {
+++-		margin: 0 0 0.25em 0;
+++-	}
++++div[id$="_confirmbox"] h2 {
++++	margin: 0 0 0.25em 0;
++++}
+++ 
+++-	& p:last-of-type {
+++-		text-align: center;
+++-		margin: 0;
+++-		padding: 0 4px 4px 4px;
+++-	}
++++div[id$="_confirmbox"] p:nth-of-type(2) {
++++	text-align: center;
++++	margin: 0;
++++	padding: 0 4px 4px 4px;
++++}
+++ 
+++-	& input[type="button"] {
+++-		padding: 3px 4px;
+++-	}
++++div[id$="_confirmbox"] input[type="button"] {
++++	padding: 3px 4px;
+++ }
+++ 
+++-input:is([type="submit"], [type="button"]):disabled,
+++-input.lukewcs_confirmbox_active {
++++input[type="submit"]:disabled,
++++input[type="button"]:disabled,
++++input.confirmbox_active {
+++ 	opacity: 0.5;
+++ 	cursor: not-allowed;
+++ }
+++ 
+++-/* <<< SETTINGS */
+++-
+++-/* EXTENSION MANAGER >>> */
++++/* EXTENSION MANAGER */
+++ 
+++ .js_link {
+++ 	color: #105289;
++++}
+++ 
+++-	&:hover {
+++-		color: #bc2a4d;
+++-		text-decoration: underline;
+++-		cursor: pointer;
+++-	}
++++.js_link:hover {
++++	color: #bc2a4d;
++++	text-decoration: underline;
++++	cursor: pointer;
++++}
+++ 
+++-	&.disabled,
+++-	&.disabled:hover {
+++-		color: #536482;
+++-		text-decoration: none;
+++-		cursor: not-allowed;
+++-		opacity: 0.5;
+++-	}
++++.js_link.disabled,
++++.js_link.disabled:hover {
++++	color: #536482;
++++	text-decoration: none;
++++	cursor: not-allowed;
++++	opacity: 0.5;
+++ }
+++ 
+++-table :is(th, td) i.icon,
+++-fieldset dd i.icon {
+++-	cursor: help;
++++fieldset.quick a i.icon,
++++.js_link i.icon {
++++	margin: 0 0.3em 0 0;
++++	font-size: 1.1em;
+++ }
+++ 
+++ div.successbox i.icon,
+++@@ -241,12 +192,6 @@ div.successbox.notice i.icon {
+++ 	font-size: 1.2em;
+++ }
+++ 
+++-fieldset.quick a i.icon,
+++-.js_link i.icon {
+++-	margin: 0 0.3em 0 0;
+++-	font-size: 1.1em;
+++-}
+++-
+++ fieldset.ext_properties i.icon,
+++ thead th i.icon {
+++ 	font-size: 1.1em;
+++@@ -255,109 +200,107 @@ thead th i.icon {
+++ 
+++ fieldset.ext_properties dd {
+++ 	color: inherit;
++++}
+++ 
+++-	& label {
+++-		font-size: inherit;
+++-		font-weight: bold;
++++fieldset.ext_properties dd label {
++++	font-size: inherit;
++++	font-weight: bold;
++++}
+++ 
+++-		&:hover {
+++-			color: inherit;
+++-		}
+++-	}
++++fieldset.ext_properties dd label:hover {
++++	color: inherit;
++++}
+++ 
+++-	& details {
+++-		border: 1px solid #cccccc;
+++-		border-radius: 3px;
+++-
+++-		& summary {
+++-			padding: 0.25em 0.5em;
+++-			cursor: pointer;
+++-			-webkit-user-select: none;
+++-			user-select: none;
+++-		}
+++-
+++-		& div {
+++-			border-top: 1px solid #cccccc;
+++-			font-size: inherit;
+++-			padding: 0.25em 0;
+++-			margin: 0 0.5em;
+++-		}
+++-	}
++++fieldset.ext_properties dd details {
++++	border: 1px solid #cccccc;
++++	border-radius: 3px;
+++ }
+++ 
+++-#extmgrplus_list {
+++-	& input[type="checkbox"]:disabled {
+++-		cursor: not-allowed;
+++-	}
++++fieldset.ext_properties dd summary {
++++	padding: 0.25em 0.5em;
++++	cursor: pointer;
++++	-webkit-user-select: none;
++++	-moz-user-select: none;
++++	-ms-user-select: none;
++++}
+++ 
+++-	& input[name$="able_all"] {
+++-		padding: 1px 3px;
+++-		font-size: inherit;
+++-	}
++++fieldset.ext_properties dd details div {
++++	border-top: 1px solid #cccccc;
++++	font-size: inherit;
++++	padding: 0.25em 0;
++++	margin: 0 0.5em;
++++}
+++ 
+++-	& input[type="text"] {
+++-		text-align: right;
+++-		padding: 0 2px;
+++-		margin: 0 2px;
+++-		background-color: #f9f9f9;
+++-	}
++++input[type="checkbox"]:disabled {
++++	cursor: not-allowed;
++++}
+++ 
+++-	& th:nth-of-type(1) {
+++-		width: 1%;
+++-	}
++++#extmgrplus_list input[name$="able_all"] {
++++	padding: 1px 5px;
++++}
+++ 
+++-	& th:nth-of-type(3) {
+++-		width: 16%;
+++-	}
++++#extmgrplus_list input[type="text"] {
++++	text-align: right;
++++	padding: 0 2px;
++++	margin: 0 2px;
++++	background-color: #f9f9f9;
++++}
+++ 
+++-	& th:nth-of-type(1n+3) {
+++-		text-align: center;
+++-	}
++++#extmgrplus_list th:nth-of-type(1) {
++++	width: 1%;
++++}
+++ 
+++-	& th:nth-of-type(4) {
+++-		width: 1%;
+++-	}
++++#extmgrplus_list th:nth-of-type(3) {
++++	width: 16%;
++++}
+++ 
+++-	& th:nth-of-type(5) {
+++-		width: 10%;
+++-	}
++++#extmgrplus_list th:nth-of-type(1n+3) {
++++	text-align: center;
++++}
+++ 
+++-	& th:nth-of-type(6) {
+++-		width: 25%;
+++-	}
++++#extmgrplus_list th:nth-of-type(4) {
++++	width: 1%;
++++}
+++ 
+++-	& th:nth-of-type(1n+7) {
+++-		width: 1%;
+++-	}
++++#extmgrplus_list th:nth-of-type(5) {
++++	width: 10%;
++++}
+++ 
+++-	& td:nth-of-type(3) i.icon {
+++-		font-size: 1.2em;
+++-	}
++++#extmgrplus_list th:nth-of-type(6) {
++++	width: 25%;
++++}
+++ 
+++-	& td:nth-of-type(3) :is(span, strong, i.icon) + :is(strong, i.icon) {
+++-		margin-left: 0.3em;
+++-	}
++++#extmgrplus_list th:nth-of-type(1n+7) {
++++	width: 1%;
++++}
+++ 
+++-	& td:nth-of-type(3) i.icon:is(.fa-question-circle, .fa-exclamation-triangle) {
+++-		color: #df950d;
+++-	}
++++#extmgrplus_list td:nth-of-type(1) i.icon {
++++	cursor: help;
++++}
+++ 
+++-	& td:nth-of-type(1n+3) {
+++-		text-align: center;
+++-	}
++++#extmgrplus_list td:nth-of-type(3) i.icon {
++++	cursor: help;
++++	font-size: 1.2em;
++++}
+++ 
+++-	& td:nth-of-type(4) span {
+++-		cursor: help;
+++-	}
++++#extmgrplus_list td:nth-of-type(3) i.icon:is(.fa-question-circle, .fa-exclamation-triangle, .fa-refresh) {
++++	color: #df950d;
++++}
+++ 
+++-	& td:nth-of-type(7) i.icon {
+++-		font-size: 1.3em;
+++-	}
++++#extmgrplus_list td:nth-of-type(1n+3) {
++++	text-align: center;
++++}
++++
++++#extmgrplus_list td:nth-of-type(4) span {
++++	cursor: help;
+++ }
+++ 
+++-/* <<< EXTENSION MANAGER */
++++#extmgrplus_list td:nth-of-type(7) i.icon {
++++	cursor: help;
++++	font-size: 1.3em;
++++}
+++ 
+++-/* VERSIONCHECK PROGGRESS >>> */
++++/* VERSIONCHECK PROGGRESS */
+++ 
+++ .progress_container {
+++ 	background-color: #f9f9f9;
+++@@ -365,28 +308,28 @@ fieldset.ext_properties dd {
+++ 	border-radius: 5px;
+++ 	position: relative;
+++ 	margin: 1em 0 0.25em 0;
++++}
+++ 
+++-	& .progress_bar {
+++-		background-color: lightgreen;
+++-		height: 100%;
+++-		border-radius: 5px;
+++-	}
++++.progress_bar {
++++	background-color: lightgreen;
++++	height: 100%;
++++	border-radius: 5px;
++++}
+++ 
+++-	& .progress_value {
+++-		color: black;
+++-		position: absolute;
+++-		font-size: 0.85em;
+++-		top: 1px;
+++-		left: 0;
+++-		right: 0;
+++-	}
++++.progress_value {
++++	color: black;
++++	position: absolute;
++++	font-size: 0.85em;
++++	top: 1px;
++++	left: 0;
++++	right: 0;
++++}
+++ 
+++-	& .progress_anim {
+++-		background-color: lightblue;
+++-		animation-name: progress_anim_block;
+++-		animation-timing-function: linear;
+++-		animation-fill-mode: forwards;
+++-	}
++++.progress_anim {
++++	background-color: lightblue;
++++	animation-name: progress_anim_block;
++++	animation-timing-function: linear;
++++	animation-fill-mode: forwards;
+++ }
+++ 
+++ @keyframes progress_anim_block {
+++@@ -399,18 +342,12 @@ fieldset.ext_properties dd {
+++ 	}
+++ }
+++ 
+++-/* <<< VERSIONCHECK PROGGRESS */
+++-
+++-/* RESPONSIVE >>> */
++++/* RESPONSIVE */
+++ 
+++ @media (max-width: 700px){
+++ 	legend {
+++ 		margin: 2px 0 0 -6px;
+++ 		padding: 2px 5px;
+++-
+++-		& + .legend_explain {
+++-			width: auto;
+++-		}
+++ 	}
+++ 
+++ 	#extmgrplus_settings dd {
+++@@ -421,5 +358,3 @@ fieldset.ext_properties dd {
+++ 		padding: 0.5em 0 0 0;
+++ 	}
+++ }
+++-
+++-/* <<< RESPONSIVE */
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_acp_ext_details.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_acp_ext_details.html"
+++deleted file mode 100644
+++index 830d87306..000000000
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_acp_ext_details.html"
++++++ /dev/null
+++@@ -1,180 +0,0 @@
+++-{#
+++-*
+++-* Extension Manager Plus. An extension for the phpBB Forum Software package.
+++-*
+++-* @copyright (c) 2022, LukeWCS, https://www.wcsaga.org
+++-* @license GNU General Public License, version 2 (GPL-2.0-only)
+++-*
+++-* Note: This extension is 100% genuine handcraft and consists of selected
+++-*       natural raw materials. There was no AI involved in making it.
+++-*
+++-#}
+++-
+++-{% import '@lukewcs_extmgrplus/acp_ext_mgr_plus_macros.html' as common %}
+++-
+++-{% INCLUDE 'overall_header.html' %}
+++-
+++-<a href="{{ U_BACK }}" style="float: {{ S_CONTENT_FLOW_END }};">&laquo; {{ lang('BACK') }}</a>
+++-
+++-<h1>{{ lang('EXTENSIONS_ADMIN') }}</h1>
+++-
+++-<p>{{ lang('EXTENSIONS_EXPLAIN') }}</p>
+++-
+++-{% if S_VERSIONCHECK %}
+++-	{% if S_VERSIONCHECK_FAIL %}
+++-		<div class="errorbox notice">
+++-			<p>{{ lang('VERSIONCHECK_FAIL') }}</p>
+++-			<p>{{ VERSIONCHECK_FAIL_REASON }}</p>
+++-			<p><a href="{{ U_VERSIONCHECK_FORCE }}">{{ lang('VERSIONCHECK_FORCE_UPDATE') }}</a></p>
+++-		</div>
+++-	{% else %}
+++-		<div class="{% if S_UP_TO_DATE %}successbox{% else %}errorbox{% endif %}">
+++-			<p>{{ UP_TO_DATE_MSG }} - <a href="{{ U_VERSIONCHECK_FORCE }}">{{ lang('VERSIONCHECK_FORCE_UPDATE') }}</a></p>
+++-		</div>
+++-	{% endif %}
+++-{% endif %}
+++-
+++-{% EVENT acp_ext_details_notice %}
+++-
+++-<fieldset>
+++-	<legend>{{ lang('EXT_DETAILS') }}</legend>
+++-
+++-	{% if META_DISPLAY_NAME %}
+++-		<dl>
+++-			<dt><label>{{ lang('DISPLAY_NAME') ~ lang('COLON') }}</label></dt>
+++-			<dd>
+++-				{{ EXTMGRPLUS_DETAILS.cdb_ext ? {
+++-					1:	common.icon('fa-database', 'EXTMGRPLUS_TOOLTIP_CDB_EXT'),
+++-					2:	common.icon('fa-star', 'EXTMGRPLUS_TOOLTIP_CDB_EXT_OFFICIAL'),
+++-				}[EXTMGRPLUS_DETAILS.cdb_ext] }}
+++-				<strong id="meta_display_name">{{ META_DISPLAY_NAME }}</strong>
+++-			</dd>
+++-		</dl>
+++-	{% endif %}
+++-	<dl>
+++-		<dt><label>{{ lang('CLEAN_NAME') ~ lang('COLON') }}</label></dt>
+++-		<dd><strong id="meta_name">{{ META_NAME }}</strong></dd>
+++-	</dl>
+++-	{% if META_DESCRIPTION %}
+++-		<dl>
+++-			<dt><label>{{ lang('DESCRIPTION') ~ lang('COLON') }}</label></dt>
+++-			<dd><span id="meta_description">{{ META_DESCRIPTION }}</span></dd>
+++-		</dl>
+++-	{% endif %}
+++-	<dl>
+++-		<dt><label>{{ lang('VERSION') ~ lang('COLON') }}</label></dt>
+++-		<dd><span id="meta_version">{{ META_VERSION }}</span></dd>
+++-	</dl>
+++-	{% if META_HOMEPAGE && META_HOMEPAGE != EXTMGRPLUS_DETAILS.cdb_page %}
+++-		<dl>
+++-			<dt><label>{{ lang('HOMEPAGE') ~ lang('COLON') }}</label></dt>
+++-			<dd><strong id="meta_homepage"><a href="{{ META_HOMEPAGE }}">{{ META_HOMEPAGE }}</a></strong></dd>
+++-		</dl>
+++-	{% endif %}
+++-	{% if EXTMGRPLUS_DETAILS.cdb_page %}
+++-		<dl>
+++-			<dt><label>{{ lang('EXTMGRPLUS_DETAILS_CDB_PAGE') ~ lang('COLON') }}</label></dt>
+++-			<dd><strong><a href="{{ EXTMGRPLUS_DETAILS.cdb_page }}">{{ EXTMGRPLUS_DETAILS.cdb_page }}</a></strong></dd>
+++-		</dl>
+++-	{% endif %}
+++-	{% if EXTMGRPLUS_DETAILS.version_url %}
+++-		<dl>
+++-			<dt><label>{{ lang('EXTMGRPLUS_DETAILS_VERSION_URL') ~ lang('COLON') }}</label></dt>
+++-			<dd><strong><a href="{{ EXTMGRPLUS_DETAILS.version_url }}">{{ EXTMGRPLUS_DETAILS.version_url }}</a></strong></dd>
+++-		</dl>
+++-	{% endif %}
+++-	{% if META_TIME %}
+++-		<dl>
+++-			<dt><label>{{ lang('TIME') ~ lang('COLON') }}</label></dt>
+++-			<dd><span id="meta_time">{{ META_TIME }}</span></dd>
+++-		</dl>
+++-	{% endif %}
+++-	<dl>
+++-		<dt><label>{{ lang('LICENSE') ~ lang('COLON') }}</label></dt>
+++-		<dd><span id="meta_license">{{ META_LICENSE }}</span></dd>
+++-	</dl>
+++-</fieldset>
+++-
+++-{% if S_VERSIONCHECK && !S_UP_TO_DATE %}
+++-	<fieldset>
+++-		<legend>{{ lang('LATEST_VERSION') }}</legend>
+++-
+++-		{% for updates_available in loops.updates_available %}
+++-			<fieldset>
+++-				<dl>
+++-					<dt><label>{{ lang('VERSION') ~ lang('COLON') }}</label></dt>
+++-					<dd><strong>{{ updates_available.current }}</strong></dd>
+++-				</dl>
+++-				{% if updates_available.download %}
+++-					<dl>
+++-						<dt><label>{{ lang('DOWNLOAD_LATEST') }}</label></dt>
+++-						<dd><strong><a href="{{ updates_available.download }}">{{ lang('DOWNLOAD') }} {{ META_NAME }} {{ LATEST_VERSION }}</a></strong></dd>
+++-					</dl>
+++-				{% endif %}
+++-				{% if updates_available.announcement %}
+++-					<dl>
+++-						<dt><label>{{ lang('ANNOUNCEMENT_TOPIC') }}</label></dt>
+++-						<dd><strong><a href="{{ updates_available.announcement }}">{{ lang('RELEASE_ANNOUNCEMENT') }}</a></strong></dd>
+++-					</dl>
+++-				{% endif %}
+++-			</fieldset>
+++-		{% endfor %}
+++-	</fieldset>
+++-{% endif %}
+++-
+++-{% if META_REQUIRE_PHPBB || META_REQUIRE_PHP %}
+++-	<fieldset>
+++-		<legend>{{ lang('REQUIREMENTS') }}</legend>
+++-
+++-		{% if META_REQUIRE_PHPBB %}
+++-			<dl{% if META_REQUIRE_PHPBB_FAIL %} class="requirements_not_met"{% endif %}>
+++-				<dt><label>{{ lang('PHPBB_VERSION') ~ lang('COLON') }}</label></dt>
+++-				<dd><span id="require_phpbb">{{ META_REQUIRE_PHPBB }}</span></dd>
+++-			</dl>
+++-		{% endif %}
+++-		{% if META_REQUIRE_PHP %}
+++-			<dl{% if META_REQUIRE_PHP_FAIL %} class="requirements_not_met"{% endif %}>
+++-				<dt><label>{{ lang('PHP_VERSION') ~ lang('COLON') }}</label></dt>
+++-				<dd><span id="require_php">{{ META_REQUIRE_PHP }}</span></dd>
+++-			</dl>
+++-		{% endif %}
+++-	</fieldset>
+++-{% endif %}
+++-
+++-<fieldset>
+++-	<legend>{{ lang('AUTHOR_INFORMATION') }}</legend>
+++-
+++-	{% for meta_authors in loops.meta_authors %}
+++-		<fieldset>
+++-			<dl>
+++-				<dt><label>{{ lang('AUTHOR_NAME') ~ lang('COLON') }}</label></dt>
+++-				<dd><strong>{{ meta_authors.AUTHOR_NAME }}</strong></dd>
+++-			</dl>
+++-			{% if meta_authors.AUTHOR_EMAIL %}
+++-				<dl>
+++-					<dt><label>{{ lang('AUTHOR_EMAIL') ~ lang('COLON') }}</label></dt>
+++-					<dd><strong><a href="mailto:{{ meta_authors.AUTHOR_EMAIL }}">{{ meta_authors.AUTHOR_EMAIL }}</a></strong></dd>
+++-				</dl>
+++-			{% endif %}
+++-			{% if meta_authors.AUTHOR_HOMEPAGE %}
+++-				<dl>
+++-					<dt><label>{{ lang('AUTHOR_HOMEPAGE') ~ lang('COLON') }}</label></dt>
+++-					<dd><strong><a href="{{ meta_authors.AUTHOR_HOMEPAGE }}">{{ meta_authors.AUTHOR_HOMEPAGE }}</a></strong></dd>
+++-				</dl>
+++-			{% endif %}
+++-			{% if meta_authors.AUTHOR_ROLE %}
+++-				<dl>
+++-					<dt><label>{{ lang('AUTHOR_ROLE') ~ lang('COLON') }}</label></dt>
+++-					<dd><strong>{{ meta_authors.AUTHOR_ROLE }}</strong></dd>
+++-				</dl>
+++-			{% endif %}
+++-		</fieldset>
+++-	{% endfor %}
+++-</fieldset>
+++-
+++-{% EVENT acp_ext_details_end %}
+++-
+++-{{ common.footer(EXTMGRPLUS_METADATA) }}
+++-
+++-{% INCLUDE 'overall_footer.html' %}
+++-{% INCLUDECSS '@lukewcs_extmgrplus/acp_ext_mgr_plus.css' %}
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_acp_ext_list.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_acp_ext_list.html"
+++index ff8f88ca8..14224a0d1 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_acp_ext_list.html"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_acp_ext_list.html"
+++@@ -25,6 +25,8 @@
+++ 	CHECKBOX_LAST	: 2,
+++ } %}
+++ 
++++<a id="maincontent"></a>
++++
+++ <h1>{{ lang('EXTENSIONS_ADMIN') }}</h1>
+++ 
+++ <p>{{ lang('EXTENSIONS_EXPLAIN') }}</p>
+++@@ -88,7 +90,7 @@
+++ 		<fieldset class="ext_properties" style="display: none;">
+++ 			<legend>{{ lang('EXTMGRPLUS_SECTION_SETTINGS') }}</legend>
+++ 
+++-			<dl{{ !EXTMGRPLUS_SWITCH_ORDER_AND_IGNORE ? ' class="emp_inactive"' }}>
++++			<dl{{ !EXTMGRPLUS_SWITCH_ORDER_AND_IGNORE ? ' class="inactive"' }}>
+++ 				<dt>
+++ 					<label>{{ lang('EXTMGRPLUS_ORDER', common.icon('fa-sort')) ~ lang('COLON') }}</label><br>
+++ 				</dt>
+++@@ -104,7 +106,7 @@
+++ 				</dd>
+++ 			</dl>
+++ 
+++-			<dl{{ !EXTMGRPLUS_SWITCH_ORDER_AND_IGNORE ? ' class="emp_inactive"' }}>
++++			<dl{{ !EXTMGRPLUS_SWITCH_ORDER_AND_IGNORE ? ' class="inactive"' }}>
+++ 				<dt>
+++ 					<label>{{ lang('EXTMGRPLUS_IGNORE', common.icon('fa-ban')) ~ lang('COLON') }}</label><br>
+++ 				</dt>
+++@@ -136,8 +138,8 @@
+++ 		</colgroup>
+++ 		<thead>
+++ 			<tr>
+++-				<th>
+++-					{{ common.icon('fa-database', 'EXTMGRPLUS_COL_CDB') }}<span style="display: none;">{{ lang('EXTMGRPLUS_COL_CDB') }}</span>
++++				<th title="{{ lang('EXTMGRPLUS_COL_CDB') }}">
++++					{{ common.icon('fa-database') }}<span style="display: none;">{{ lang('EXTMGRPLUS_COL_CDB') }}</span>
+++ 				</th>
+++ 				<th>
+++ 					{{ lang('EXTENSION_NAME') }}
+++@@ -145,8 +147,8 @@
+++ 				<th>
+++ 					{{ lang('CURRENT_VERSION') }}
+++ 				</th>
+++-				<th{{ !EXTMGRPLUS_SWITCH_MIGRATION_COL ? ' style="display: none;"' }}>
+++-					{{ common.icon('fa-arrow-up', 'EXTMGRPLUS_COL_MIGRATIONS') }}<span style="display: none;">{{ lang('EXTMGRPLUS_COL_MIGRATIONS') }}</span>
++++				<th{{ !EXTMGRPLUS_SWITCH_MIGRATION_COL ? ' style="display: none;"' }} title="{{ lang('EXTMGRPLUS_COL_MIGRATIONS') }}">
++++					{{ common.icon('fa-arrow-up') }}<span style="display: none;">{{ lang('EXTMGRPLUS_COL_MIGRATIONS') }}</span>
+++ 				</th>
+++ 				<th>
+++ 					{{ lang('EXTENSION_OPTIONS') }}
+++@@ -154,14 +156,14 @@
+++ 				<th>
+++ 					{{ lang('EXTENSION_ACTIONS') }}
+++ 				</th>
+++-				<th>
+++-					{{ common.icon('fa-check', 'EXTMGRPLUS_COL_SELECT') }}<span style="display: none;">{{ lang('EXTMGRPLUS_COL_SELECT') }}</span>
++++				<th title="{{ lang('EXTMGRPLUS_COL_SELECT') }}">
++++					{{ common.icon('fa-check') }}<span style="display: none;">{{ lang('EXTMGRPLUS_COL_SELECT') }}</span>
+++ 				</th>
+++-				<th style="display: none;">
+++-					{{ common.icon('fa-sort', 'EXTMGRPLUS_COL_ORDER') }}<span style="display: none;">{{ lang('EXTMGRPLUS_COL_ORDER') }}</span>
++++				<th title="{{ lang('EXTMGRPLUS_COL_ORDER') }}" style="display: none;">
++++					{{ common.icon('fa-sort') }}<span style="display: none;">{{ lang('EXTMGRPLUS_COL_ORDER') }}</span>
+++ 				</th>
+++-				<th style="display: none;">
+++-					{{ common.icon('fa-ban', 'EXTMGRPLUS_COL_IGNORE') }}<span style="display: none;">{{ lang('EXTMGRPLUS_COL_IGNORE') }}</span>
++++				<th title="{{ lang('EXTMGRPLUS_COL_IGNORE') }}" style="display: none;">
++++					{{ common.icon('fa-ban') }}<span style="display: none;">{{ lang('EXTMGRPLUS_COL_IGNORE') }}</span>
+++ 				</th>
+++ 			</tr>
+++ 		</thead>
+++@@ -207,10 +209,11 @@
+++ 					{% set vc_obj = EXTMGRPLUS_LIST_VERSIONCHECK[ext.NAME] ?? {} %}
+++ 					<tr class="ext_{{ list }} row-highlight">
+++ 						<td>
+++-							{{ vc_obj.cdb_ext ? {
+++-								1:	common.icon('fa-database', 'EXTMGRPLUS_TOOLTIP_CDB_EXT'),
+++-								2:	common.icon('fa-star', 'EXTMGRPLUS_TOOLTIP_CDB_EXT_OFFICIAL'),
+++-							}[vc_obj.cdb_ext] }}
++++							{% apply spaceless %}
++++							{% if vc_obj.cdb_ext === true %}
++++								<span title="{{ lang('EXTMGRPLUS_TOOLTIP_CDB_EXT')|e('html') }}">{{ common.icon('fa-database') }}</span>
++++							{% endif %}
++++							{% endapply %}
+++ 						</td>
+++ 						<td>
+++ 							{% apply spaceless %}
+++@@ -233,14 +236,14 @@
+++ 									<strong class="{{ vc_obj.current == 'NOUPD' ? 'current-ext' : 'outdated-ext' }}">{{ ext.META_VERSION }}</strong>
+++ 								{% endif %}
+++ 								{% if vc_obj.current === false %}
+++-									{{ common.icon('fa-chain-broken', 'EXTMGRPLUS_TOOLTIP_NO_VERSIONCHECK') }}
++++									<span title="{{ lang('EXTMGRPLUS_TOOLTIP_NO_VERSIONCHECK')|e('html') }}">&nbsp;{{ common.icon('fa-chain-broken') }}</span>
+++ 								{% elseif vc_obj.current == 'ERROR' %}
+++-									{{ common.icon('fa-exclamation-triangle', 'EXTMGRPLUS_TOOLTIP_VERSIONCHECK_ERROR') }}
++++									<span title="{{ lang('EXTMGRPLUS_TOOLTIP_VERSIONCHECK_ERROR')|e('html') }}">&nbsp;{{ common.icon('fa-exclamation-triangle') }}</span>
+++ 								{% elseif vc_obj.current is empty %}
+++-									{{ common.icon('fa-question-circle', 'EXTMGRPLUS_TOOLTIP_VERSIONCHECK_EMPTY') }}
++++									<span title="{{ lang('EXTMGRPLUS_TOOLTIP_VERSIONCHECK_EMPTY')|e('html') }}">&nbsp;{{ common.icon('fa-question-circle') }}</span>
+++ 								{% elseif vc_obj.current != 'NOUPD' %}
+++-									{{ common.icon('fa-exclamation-circle outdated-ext', 'EXTMGRPLUS_TOOLTIP_OUTDATED') }}
+++-									<strong class="current-ext">({{ vc_obj.current }})</strong>
++++									<span title="{{ lang('EXTMGRPLUS_TOOLTIP_OUTDATED')|e('html') }}">&nbsp;{{ common.icon('fa-exclamation-circle outdated-ext') }}</span>
++++									<strong class="current-ext">&nbsp;({{ vc_obj.current }})</strong>
+++ 								{% endif %}
+++ 							{% endif %}
+++ 							{% endapply %}
+++@@ -250,7 +253,7 @@
+++ 							{% if list != 'enabled' && EXTMGRPLUS_SWITCH_MIGRATION_COL %}
+++ 								{% set count = EXTMGRPLUS_LIST_MIGRATIONS[ext.NAME] ?? 0 %}
+++ 								{% if EXTMGRPLUS_LIST_IGNORE[ext.NAME] is defined %}
+++-									{{ common.icon('fa-ban', 'EXTMGRPLUS_TOOLTIP_IS_IGNORED') }}
++++									<span title="{{ lang('EXTMGRPLUS_TOOLTIP_IS_IGNORED')|e('html') }}">{{ common.icon('fa-ban') }}</span>
+++ 								{% elseif count %}
+++ 									<span title="{{ lang('EXTMGRPLUS_TOOLTIP_HAS_MIGRATION')|e('html') }}">{{ count }}</span>
+++ 								{% endif %}
+++@@ -270,23 +273,15 @@
+++ 								<a href="{{ action.U_ACTION }}"{{ action.L_ACTION_EXPLAIN ? ' title="' ~ action.L_ACTION_EXPLAIN ~ '"' }}>{{ action.L_ACTION }}</a>
+++ 								{{ !loop.last ? '<span>&nbsp;|&nbsp;</span>' }}
+++ 							{% endfor %}
+++-							{% if list == 'enabled' && EXTMGRPLUS_SWITCH_SETTINGS_LINK %}
+++-								<span>&nbsp;|&nbsp;</span>
+++-								{% if EXTMGRPLUS_LIST_MODULES[ext.NAME] is defined %}
+++-									<a href="{{ EXTMGRPLUS_LIST_MODULES[ext.NAME] }}" title="{{ lang('EXTMGRPLUS_TOOLTIP_SETTINGS') }}">{{ lang('SETTINGS') }}</a>
+++-								{% else %}
+++-									<span class="emp_unavailable">{{ lang('SETTINGS') }}</span>
+++-								{% endif %}
+++-							{% endif %}
+++ 							{% endapply %}
+++ 						</td>
+++ 						<td>
+++ 							{% apply spaceless %}
+++ 							{% if list != 'not_installed' && ext.NAME is defined && (ext.NAME != 'lukewcs/extmgrplus' || EXTMGRPLUS_SWITCH_SELF_DISABLE) %}
+++ 								{% if EXTMGRPLUS_LIST_IGNORE[ext.NAME] is defined %}
+++-									{{ common.icon('fa-ban', 'EXTMGRPLUS_TOOLTIP_IS_IGNORED') }}
++++									<span title="{{ lang('EXTMGRPLUS_TOOLTIP_IS_IGNORED')|e('html') }}">{{ common.icon('fa-ban') }}
+++ 								{% elseif EXTMGRPLUS_LIST_MIGRATIONS[ext.NAME] is defined && !EXTMGRPLUS_SWITCH_MIGRATIONS %}
+++-									<input type="checkbox" class="checkbox" title="{{ lang('EXTMGRPLUS_TOOLTIP_IS_LOCKED')|e('html') }}" disabled>
++++									<input type="checkbox" name="ext_mark_{{ list }}[]" class="checkbox" title="{{ lang('EXTMGRPLUS_TOOLTIP_IS_LOCKED')|e('html') }}" disabled>
+++ 								{% else %}
+++ 									<input type="checkbox" name="ext_mark_{{ list }}[]" class="checkbox" title="{{ lang('EXTMGRPLUS_TOOLTIP_SELECT')|e('html') }}" value="{{ ext.NAME }}"{{ EXTMGRPLUS_LIST_SELECTED[ext.NAME] is defined ? ' checked' }}>
+++ 								{% endif %}
+++@@ -296,7 +291,7 @@
+++ 						<td style="display: none;">
+++ 							{% apply spaceless %}
+++ 							{% if ext.NAME is defined && ext.NAME != 'lukewcs/extmgrplus' && EXTMGRPLUS_SWITCH_ORDER_AND_IGNORE %}
+++-								<input type="text" name="ext_order[{{ ext.NAME }}]" size="2" maxlength="3"{{ EXTMGRPLUS_LIST_IGNORE[ext.NAME] is defined ? ' class="emp_inactive"' }} title="{{ lang('EXTMGRPLUS_TOOLTIP_ORDER')|e('html') }}" value="{{ EXTMGRPLUS_LIST_ORDER[ext.NAME] ?? '' }}" pattern="^\+?[0-9]{1,2}$">
++++								<input type="text" name="ext_order[{{ ext.NAME }}]" size="2" maxlength="3"{{ EXTMGRPLUS_LIST_IGNORE[ext.NAME] is defined ? ' class="inactive"' }} title="{{ lang('EXTMGRPLUS_TOOLTIP_ORDER')|e('html') }}" value="{{ EXTMGRPLUS_LIST_ORDER[ext.NAME] ?? '' }}" pattern="^\+?[0-9]{1,2}$">
+++ 							{% endif %}
+++ 							{% endapply %}
+++ 						</td>
+++@@ -363,7 +358,7 @@
+++ 		</fieldset>
+++ 	{% elseif type == 'save_checkboxes' %}
+++ 		<input type="submit" name="extmgrplus_save_checkboxes" value="save_checkboxes" hidden>
+++-	{% elseif type ends with 'able_all' %}
++++	{% elseif type == 'disable_all' || type == 'enable_all'%}
+++ 		{% set type_upper = type|upper %}
+++ 		<input type="submit" name="extmgrplus_{{ type }}" class="button1" title="{{ lang('EXTMGRPLUS_TOOLTIP_' ~ type_upper)|e('html') }}" value="{{ lang('EXTMGRPLUS_' ~ type_upper) }}"{{ !enabled ? ' disabled' }}>
+++ 	{% endif %}
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_acp_ext_list.js" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_acp_ext_list.js"
+++index a392d1064..9d39732ed 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_acp_ext_list.js"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_acp_ext_list.js"
+++@@ -97,7 +97,7 @@ function setButtonState(e) {
+++ };
+++ 
+++ function setInputBoxState(e) {
+++-	$('input[name="ext_order[' + e.currentTarget.value + ']"]').toggleClass('emp_inactive', e.currentTarget.checked);
++++	$('input[name="ext_order[' + e.currentTarget.value + ']"]').toggleClass('inactive', e.currentTarget.checked);
+++ };
+++ 
+++ /*
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_confirm_body.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_confirm_body.html"
+++index b03d4b2b8..2dae27c43 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_confirm_body.html"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_confirm_body.html"
+++@@ -18,9 +18,7 @@
+++ 
+++ <p>{{ lang('EXTENSIONS_EXPLAIN') }}</p>
+++ 
+++-{% if EXTMGRPLUS_ACTION_MODE -%}
+++-	<p>{{ lang('EXTENSION_' ~ EXTMGRPLUS_ACTION_MODE ~ '_EXPLAIN') }}</p>
+++-{%- endif %}
++++<p>{{ lang('EXTENSION_' ~ EXTMGRPLUS_ACTION_MODE ~ '_EXPLAIN') }}</p>
+++ 
+++ <form id="confirm" method="post" action="{{ S_CONFIRM_ACTION }}">
+++ 	<fieldset>
+++@@ -28,15 +26,15 @@
+++ 
+++ 		<p>{{ MESSAGE_TEXT }}</p>
+++ 
+++-		{% if EXTMGRPLUS_ACTION_MODE == 'DISABLE' && 'lukewcs/extmgrplus' in S_HIDDEN_FIELDS -%}
++++		{% if EXTMGRPLUS_SELF_DISABLE %}
+++ 			<p>{{ lang('EXTMGRPLUS_MSG_SELF_DISABLE') }}</p>
+++-		{%- endif %}
++++		{% endif %}
+++ 
+++ 		{{ S_HIDDEN_FIELDS }}
+++ 
+++ 		<fieldset class="submit-buttons">
+++-			<button type="submit" name="confirm" value="{{ lang('YES') }}" class="button1">{{ lang(EXTMGRPLUS_CONFIRM_YES ?? 'YES') }}</button>
+++-			<button type="submit" name="cancel" value="{{ lang('NO') }}" class="button2">{{ lang(EXTMGRPLUS_CONFIRM_NO ?? 'NO') }}</button>
++++			<input type="submit" name="confirm" value="{{ lang('YES') }}" class="button1">&nbsp;
++++			<input type="submit" name="cancel" value="{{ lang('NO') }}" class="button2">
+++ 		</fieldset>
+++ 	</fieldset>
+++ 
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_macros.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_macros.html"
+++index bccefff61..d8a2dc1cb 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_macros.html"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_macros.html"
+++@@ -20,19 +20,16 @@
+++ 	{% endif %}
+++ {% endmacro %}
+++ 
+++-{% macro icon(classes, title = null, decorative = true) -%}
+++-	<i class="icon {{ classes }}"{{
+++-		(title != null ? ' title="' ~ lang(title)|e('html') ~ '"') ~
+++-		(decorative ? ' aria-hidden="true"')
+++-	}}></i>
++++{% macro icon(classes, decorative = true) -%}
++++	<i class="icon {{ classes }}"{{ decorative ? ' aria-hidden="true"' }}></i>
+++ {%- endmacro %}
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
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_message_body.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_message_body.html"
+++index ff0ba456a..857363870 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_message_body.html"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_message_body.html"
+++@@ -22,7 +22,7 @@
+++ 	<p>{{ lang('EXTENSION_' ~ EXTMGRPLUS_ACTION_MODE ~ '_EXPLAIN') }}</p>
+++ {%- endif %}
+++ 
+++-<div class="{{ {0: 'successbox', 1: 'errorbox', 2: 'errorbox emp_warning', 3: 'errorbox emp_success_error'}[EXTMGRPLUS_TRIGGER_ERROR] }}">
++++<div class="{{ S_USER_NOTICE ? 'successbox' : 'errorbox' }}">
+++ 	<h3>{{ MESSAGE_TITLE }}</h3>
+++ 
+++ 	<p>{{ MESSAGE_TEXT }}</p>
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_settings.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_settings.html"
+++index eb13ee558..421c4a386 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_settings.html"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_settings.html"
+++@@ -16,6 +16,8 @@
+++ 
+++ {% set switch_type = TOGGLECTRL_TYPE ?? 'toggle' %}
+++ 
++++<a id="maincontent"></a>
++++
+++ <h1>{{ lang('EXTENSIONS_ADMIN') }}</h1>
+++ 
+++ <p>{{ lang('EXTENSIONS_EXPLAIN') }}</p>
+++@@ -92,22 +94,22 @@
+++ 
+++ 		<dl>
+++ 			<dt>
+++-				<label>{{ lang('EXTMGRPLUS_VC_LIMIT') ~ lang('COLON') }}</label><br>
+++-				<span>{{ lang('EXTMGRPLUS_VC_LIMIT_EXPLAIN') }}</span>
++++				<label>{{ lang('EXTMGRPLUS_INSTRUCTIONS') ~ lang('COLON') }}</label><br>
++++				<span>{{ lang('EXTMGRPLUS_INSTRUCTIONS_EXPLAIN') }}</span>
+++ 			</dt>
+++ 			<dd>
+++-				{{ _self.number('extmgrplus_number_vc_limit', EXTMGRPLUS_NUMBER_VC_LIMIT, 1, 99) }}
+++-				{{ lang('SECONDS') }}
++++				{{ _self.switch('extmgrplus_switch_instructions', EXTMGRPLUS_SWITCH_INSTRUCTIONS, switch_type) }}
+++ 			</dd>
+++ 		</dl>
+++ 
+++ 		<dl>
+++ 			<dt>
+++-				<label>{{ lang('EXTMGRPLUS_SETTING_LINKS') ~ lang('COLON') }}</label><br>
+++-				<span>{{ lang('EXTMGRPLUS_SETTING_LINKS_EXPLAIN') }}</span>
++++				<label>{{ lang('EXTMGRPLUS_VC_LIMIT') ~ lang('COLON') }}</label><br>
++++				<span>{{ lang('EXTMGRPLUS_VC_LIMIT_EXPLAIN') }}</span>
+++ 			</dt>
+++ 			<dd>
+++-				{{ _self.switch('extmgrplus_switch_settings_link', EXTMGRPLUS_SWITCH_SETTINGS_LINK, switch_type) }}
++++				{{ _self.number('extmgrplus_number_vc_limit', EXTMGRPLUS_NUMBER_VC_LIMIT, 1, 99) }}
++++				{{ lang('SECONDS') }}
+++ 			</dd>
+++ 		</dl>
+++ 
+++@@ -124,17 +126,7 @@
+++ 		</dl>
+++ 
+++ 		<legend class="legend_sub">{{ lang('EXTMGRPLUS_SECTION_EXPERT_SETTINGS') }}</legend>
+++-		<p class="legend_explain">{{ lang('EXTMGRPLUS_EXPERT_SETTINGS_EXPLAIN') }}</p>
+++-
+++-		<dl>
+++-			<dt>
+++-				<label>{{ lang('EXTMGRPLUS_INSTRUCTIONS') ~ lang('COLON') }}</label><br>
+++-				<span>{{ lang('EXTMGRPLUS_INSTRUCTIONS_EXPLAIN') }}</span>
+++-			</dt>
+++-			<dd>
+++-				{{ _self.switch('extmgrplus_switch_instructions', EXTMGRPLUS_SWITCH_INSTRUCTIONS, switch_type) }}
+++-			</dd>
+++-		</dl>
++++		<p>{{ lang('EXTMGRPLUS_EXPERT_SETTINGS_EXPLAIN') }}</p>
+++ 
+++ 		<dl>
+++ 			<dt>
+++@@ -175,7 +167,7 @@
+++ 				<span>{{ lang('EXTMGRPLUS_DEFAULTS_EXP') }}</span>
+++ 			</dt>
+++ 			<dd>
+++-				<input type="button" class="button2" name="extmgrplus_defaults" value="{{ lang('EXTMGRPLUS_BUTTON_DEFAULTS') }}">
++++				{{ _self.button('extmgrplus_defaults', 'EXTMGRPLUS_BUTTON_DEFAULTS') }}
+++ 			</dd>
+++ 		</dl>
+++ 	</fieldset>
+++@@ -232,13 +224,17 @@
+++ 	}}>
+++ {%- endmacro %}
+++ 
++++{% macro button(name, lang_var) -%}
++++	<input type="button" class="button2" name="{{ name }}" value="{{ lang(lang_var) }}">
++++{%- endmacro %}
++++
+++ {% macro confirmbox(name, message, default = false) -%}
+++-	<div class="lukewcs_confirmbox" data-name="{{ name }}" data-default="{{ default }}" style="display: none;">
++++	<div id="{{ name }}_confirmbox" data-default="{{ default }}" style="display: none;">
+++ 		<h2>{{ lang('CONFIRM') }}</h2>
+++ 		<p>{{ message }}</p>
+++ 		<p>
+++-			<input type="button" class="button1" name="lukewcs_confirmbox_yes" value="{{ lang('YES') }}">&nbsp;
+++-			<input type="button" class="button2" name="lukewcs_confirmbox_no" value="{{ lang('NO') }}">
++++			<input type="button" class="button1" name="{{ name }}_confirm_yes" value="{{ lang('YES') }}">&nbsp;
++++			<input type="button" class="button2" name="{{ name }}_confirm_no" value="{{ lang('NO') }}">
+++ 		</p>
+++ 	</div>
+++ {%- endmacro %}
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_settings.js" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_settings.js"
+++index 38cce605c..146ad6c94 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_settings.js"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_settings.js"
+++@@ -11,140 +11,142 @@
+++ */
+++ 
+++ (function ($) {
+++-	'use strict';
+++-
+++-	/*
+++-		Classes
+++-	*/
+++-
+++-	class LukeWCSphpBBConfirmBox {
+++-		/*
+++-		* phpBB ConfirmBox class for checkboxes and yes/no radio buttons - v1.5.1
+++-		* @copyright (c) 2023, LukeWCS, https://www.wcsaga.org
+++-		* @license GNU General Public License, version 2 (GPL-2.0-only)
+++-		*/
+++-
+++-		constructor(submitSelector, animDuration = 0) {
+++-			let _this = this;
+++-			this.$submitObject	= $(submitSelector);
+++-			this.$formObject	= this.$submitObject.parents('form');
+++-			this.animDuration	= animDuration;
+++-
+++-			this.$formObject.find('div.lukewcs_confirmbox').each(function () {
+++-				$('input[name="' + $(this).attr('data-name') + '"]').on('change', _this.#Show);
+++-				$(this).find('input[type="button"]')				.on('click'	, _this.#Button);
+++-			});
+++-			this.$formObject										.on('reset'	, _this.HideAll);
+++-		}
+++ 
+++-		HideAll = () => {
+++-			const $elementObject	= this.$formObject.find('input.lukewcs_confirmbox_active');
+++-			const $confirmBoxObject	= this.$formObject.find('div.lukewcs_confirmbox');
++++'use strict';
+++ 
+++-			this.#changeBoxState($elementObject, $confirmBoxObject, false);
+++-		}
++++/*
++++	Classes
++++*/
+++ 
+++-		#Show = (e) => {
+++-			const $elementObject	= $('input[name="' + e.target.name + '"]');
+++-			const $confirmBoxObject	= $('div.lukewcs_confirmbox[data-name="' + e.target.name + '"]');
++++class LukeWCSphpBBConfirmBox {
++++/*
++++* phpBB ConfirmBox class for checkboxes and yes/no radio buttons - v1.4.3
++++* @copyright (c) 2023, LukeWCS, https://www.wcsaga.org
++++* @license GNU General Public License, version 2 (GPL-2.0-only)
++++*/
++++	constructor(submitSelector, animDuration = 0) {
++++		let _this = this;
++++		this.$submitObject	= $(submitSelector);
++++		this.$formObject	= this.$submitObject.parents('form');
++++		this.animDuration	= animDuration;
++++
++++		this.$formObject.find('div[id$="_confirmbox"]').each(function () {
++++			const elementName = this.id.replace('_confirmbox', '');
++++
++++			$('input[name="' + elementName + '"]')				.on('change'	, _this.#Show);
++++			$('input[name^="' + elementName + '_confirm_"]')	.on('click'		, _this.#Button);
++++		});
++++		this.$formObject										.on('reset'		, _this.HideAll);
++++	}
+++ 
+++-			if ($elementObject.prop('checked') != $confirmBoxObject.attr('data-default')) {
+++-				this.#changeBoxState($elementObject, $confirmBoxObject, true);
+++-			}
++++	#Show = (e) => {
++++		const $elementObject	= $('input[name="' + e.target.name + '"]');
++++		const $confirmBoxObject	= $('div[id="' + e.target.name + '_confirmbox"]');
++++
++++		if ($elementObject.prop('checked') != $confirmBoxObject.attr('data-default')) {
++++			this.#changeBoxState($elementObject, $confirmBoxObject, true);
+++ 		}
++++	}
++++
++++	#Button = (e) => {
++++		const elementName		= e.target.name.replace(/_confirm_.*/, '');
++++		const $elementObject	= $('input[name="' + elementName + '"]');
++++		const $confirmBoxObject	= $('div[id="' + elementName + '_confirmbox"]');
++++		const elementType		= $elementObject.attr('type');
+++ 
+++-		#Button = (e) => {
+++-			const elementName		= $(e.target).parents('div.lukewcs_confirmbox').attr('data-name');
+++-			const $elementObject	= $('input[name="' + elementName + '"]');
+++-			const elementType		= $elementObject.attr('type');
+++-			const $confirmBoxObject	= $('div.lukewcs_confirmbox[data-name="' + elementName + '"]');
+++-
+++-			if (e.target.name == 'lukewcs_confirmbox_no') {
+++-				if (elementType == 'checkbox') {
+++-					$elementObject.prop('checked', $confirmBoxObject.attr('data-default'));
+++-				} else if (elementType == 'radio') {
+++-					$elementObject.filter('[value="' + ($confirmBoxObject.attr('data-default') ? '1' : '0') + '"]').prop('checked', true);
+++-				}
++++		if (e.target.name.endsWith('_confirm_no')) {
++++			if (elementType == 'checkbox') {
++++				$elementObject.prop('checked', $confirmBoxObject.attr('data-default'));
++++			} else if (elementType == 'radio') {
++++				$elementObject.filter('[value="' + ($confirmBoxObject.attr('data-default') ? '1' : '0') + '"]').prop('checked', true);
+++ 			}
+++-			this.#changeBoxState($elementObject, $confirmBoxObject, null);
+++ 		}
++++		this.#changeBoxState($elementObject, $confirmBoxObject, null);
++++	}
+++ 
+++-		#changeBoxState = ($elementObject, $confirmBoxObject, showBox) => {
+++-			$elementObject		.prop('disabled', !!showBox);
+++-			$elementObject		.toggleClass('lukewcs_confirmbox_active', !!showBox);
+++-			$confirmBoxObject	[showBox ? 'show' : 'hide'](this.animDuration);
+++-			this.$submitObject	.prop('disabled', showBox ?? this.$formObject.find('input.lukewcs_confirmbox_active').length);
+++-		}
++++	HideAll = () => {
++++		const $elementObject	= this.$formObject.find('input.confirmbox_active');
++++		const $confirmBoxObject	= this.$formObject.find('div[id$="_confirmbox"]');
++++
++++		this.#changeBoxState($elementObject, $confirmBoxObject, false);
+++ 	}
+++ 
+++-	/*
+++-		Declarations
+++-	*/
+++-
+++-	const constants = Object.freeze({
+++-		CheckBoxModeOff:	'0',
+++-		CheckBoxModeAll:	'1',
+++-		CheckBoxModeLast:	'2',
+++-	});
+++-	let ConfirmBox;
+++-
+++-	/*
+++-		Settings form
+++-	*/
+++-
+++-	function setDefaults() {
+++-		const c = constants;
+++-
+++-		setSwitch('[name="extmgrplus_switch_log"]',							true);
+++-		setSwitch('[name="extmgrplus_switch_confirmation"]',				true);
+++-		setSwitch('[name="extmgrplus_switch_auto_redirect"]',				false);
+++-		$(        '[name="extmgrplus_select_checkbox_mode"]').prop('value',	c.CheckBoxModeAll);
+++-		setSwitch('[name="extmgrplus_switch_order_and_ignore"]',			true);
+++-		setSwitch('[name="extmgrplus_switch_self_disable"]',				false);
+++-		setSwitch('[name="extmgrplus_switch_instructions"]',				true);
+++-		setSwitch('[name="extmgrplus_switch_settings_link"]',				true);
+++-		$(        '[name="extmgrplus_number_vc_limit"]').prop('value',		15);
+++-		setSwitch('[name="extmgrplus_switch_migration_col"]',				false);
+++-		setSwitch('[name="extmgrplus_switch_migrations"]',					false);
+++-		setSwitch('[name="extmgrplus_switch_version_url"]',					false);
+++-
+++-		ConfirmBox.HideAll();
+++-	};
+++-
+++-	function setSwitch(selector, checked) {
+++-		const $elementObject	= $(selector);
+++-		const elementType		= $elementObject.attr('type');
++++	#changeBoxState = ($elementObject, $confirmBoxObject, showBox) => {
++++		$elementObject		.prop('disabled', !!showBox);
++++		$elementObject		.toggleClass('confirmbox_active', !!showBox);
++++		$confirmBoxObject	[showBox ? 'show' : 'hide'](this.animDuration);
++++		this.$submitObject	.prop('disabled', showBox ?? this.$formObject.find('input.confirmbox_active').length);
++++	}
++++}
+++ 
+++-		if (elementType == 'checkbox') {
+++-			$elementObject.prop('checked', checked);
+++-		} else if (elementType == 'radio') {
+++-			$elementObject.filter('[value="' + (checked ? '1' : '0') + '"]').prop('checked', true);
+++-		}
+++-	};
++++/*
++++	Declarations
++++*/
+++ 
+++-	function formSubmit() {
+++-		$('[name="extmgrplus_save_settings"]').click();
+++-	};
++++const constants = Object.freeze({
++++	CheckBoxModeOff:	'0',
++++	CheckBoxModeAll:	'1',
++++	CheckBoxModeLast:	'2',
++++});
++++let ConfirmBox;
+++ 
+++-	/*
+++-		Common
+++-	*/
++++/*
++++	Settings form
++++*/
+++ 
+++-	function disableEnter(e) {
+++-		if (e.key == 'Enter' && e.target.type != 'textarea') {
+++-			return false;
+++-		}
+++-	};
++++function setDefaults() {
++++	const c = constants;
++++
++++	setSwitch('[name="extmgrplus_switch_log"]',							true);
++++	setSwitch('[name="extmgrplus_switch_confirmation"]',				true);
++++	setSwitch('[name="extmgrplus_switch_auto_redirect"]',				false);
++++	$(        '[name="extmgrplus_select_checkbox_mode"]').prop('value',	c.CheckBoxModeAll);
++++	setSwitch('[name="extmgrplus_switch_order_and_ignore"]',			true);
++++	setSwitch('[name="extmgrplus_switch_self_disable"]',				false);
++++	setSwitch('[name="extmgrplus_switch_instructions"]',				true);
++++	$(        '[name="extmgrplus_number_vc_limit"]').prop('value',		15);
++++	setSwitch('[name="extmgrplus_switch_migration_col"]',				false);
++++	setSwitch('[name="extmgrplus_switch_migrations"]',					false);
++++	setSwitch('[name="extmgrplus_switch_version_url"]',					false);
++++
++++	ConfirmBox.HideAll();
++++};
++++
++++function setSwitch(selector, checked) {
++++	const $elementObject	= $(selector);
++++	const elementType		= $elementObject.attr('type');
++++
++++	if (elementType == 'checkbox') {
++++		$elementObject.prop('checked', checked);
++++	} else if (elementType == 'radio') {
++++		$elementObject.filter('[value="' + (checked ? '1' : '0') + '"]').prop('checked', true);
++++	}
++++};
++++
++++function formSubmit() {
++++	$('[name="extmgrplus_save_settings"]').click();
++++};
++++
++++/*
++++	Common
++++*/
++++
++++function disableEnter(e) {
++++	if (e.key == 'Enter' && e.target.type != 'textarea') {
++++		return false;
++++	}
++++};
++++
++++/*
++++	Event registration
++++*/
+++ 
+++-	/*
+++-		Event registration
+++-	*/
++++$(function () {
++++	$('#extmgrplus_settings')			.on('keypress'	, disableEnter);
++++	$('[name="extmgrplus_defaults"]')	.on('click'		, setDefaults);
++++	$('[name="extmgrplus_submit"]')		.on('click'		, formSubmit);
+++ 
+++-	$(function () {
+++-		$('#extmgrplus_settings')			.on('keypress'	, disableEnter);
+++-		$('[name="extmgrplus_defaults"]')	.on('click'		, setDefaults);
+++-		$('[name="extmgrplus_submit"]')		.on('click'		, formSubmit);
++++	ConfirmBox = new LukeWCSphpBBConfirmBox('[name="extmgrplus_submit"]', 300);
++++});
+++ 
+++-		ConfirmBox = new LukeWCSphpBBConfirmBox('[name="extmgrplus_submit"]', 300);
+++-	});
+++ })(jQuery);
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_versioncheck.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_versioncheck.html"
+++index 9d6aaf8c4..eb385e167 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_versioncheck.html"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/adm/style/acp_ext_mgr_plus_versioncheck.html"
+++@@ -14,6 +14,8 @@
+++ 
+++ {% INCLUDE 'overall_header.html' %}
+++ 
++++<a id="maincontent"></a>
++++
+++ <h1>{{ lang('EXTENSIONS_ADMIN') }}</h1>
+++ 
+++ <p>{{ lang('EXTENSIONS_EXPLAIN') }}</p>
+++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/adm/style/event/acp_ext_details_end.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/adm/style/event/acp_ext_details_end.html"
+++new file mode 100644
+++index 000000000..13dbd1022
+++--- /dev/null
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/adm/style/event/acp_ext_details_end.html"
+++@@ -0,0 +1,26 @@
++++{% import '@lukewcs_extmgrplus/acp_ext_mgr_plus_macros.html' as common %}
++++
++++
++++{% if EXTMGRPLUS_DETAILS|length %}
++++	<fieldset>
++++		<legend>{{ lang('EXTMGRPLUS_SECTION_DETAILS') }}</legend>
++++
++++	{% if EXTMGRPLUS_DETAILS.cdb_page %}
++++		<dl>
++++			<dt><label>{{ lang('EXTMGRPLUS_DETAILS_CDB_PAGE') ~ lang('COLON') }}</label></dt>
++++			<dd><strong><a href="{{ EXTMGRPLUS_DETAILS.cdb_page }}">{{ EXTMGRPLUS_DETAILS.cdb_page }}</a></strong></dd>
++++		</dl>
++++	{% endif %}
++++
++++	{% if EXTMGRPLUS_DETAILS.version_url %}
++++		<dl>
++++			<dt><label>{{ lang('EXTMGRPLUS_DETAILS_VERSION_URL') ~ lang('COLON') }}</label></dt>
++++			<dd><strong><a href="{{ EXTMGRPLUS_DETAILS.version_url }}">{{ EXTMGRPLUS_DETAILS.version_url }}</a></strong></dd>
++++		</dl>
++++	{% endif %}
++++	</fieldset>
++++{% endif %}
++++
++++{{ common.footer(EXTMGRPLUS_METADATA) }}
++++
++++{% INCLUDECSS '@lukewcs_extmgrplus/acp_ext_mgr_plus.css' %}
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/composer.json"
+++index 42a77c63f..577550354 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/composer.json"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/composer.json"
+++@@ -3,8 +3,8 @@
+++     "type": "phpbb-extension",
+++     "description": "Adds the option to disable and re-enable all installed extensions at once to the extension management. Individual selections can be made using checkboxes. In addition, sequence groups and dependencies can be defined or extensions can be ignored. The version check is carried out in blocks and provides detailed information. Additional information is displayed in the extension management.",
+++     "homepage": "https://github.com/LukeWCS/ext-mgr-plus",
+++-    "version": "3.1.0",
+++-    "time": "2025-11-01",
++++    "version": "3.0.0",
++++    "time": "2024-11-28",
+++     "license": "GPL-2.0-only",
+++     "authors": [
+++         {
+++@@ -19,13 +19,13 @@
+++         }
+++     ],
+++     "require": {
+++-        "php": ">=8.0.0,<8.5.0@dev",
++++        "php": ">=7.4.0,<8.5.0@dev",
+++         "composer/installers": "~1.0.0",
+++         "phpbb/phpbb": ">=3.3.8,<3.4.0@dev"
+++     },
+++     "extra": {
+++         "display-name": "Extension Manager Plus",
+++-        "lang-min-ver": "3.1.0",
++++        "lang-min-ver": "3.0.0",
+++         "soft-require": {
+++             "phpbb/phpbb": ">=3.3.8,<3.4.0@dev"
+++         },
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/config/services.yml" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/config/services.yml"
+++index a70d6857b..f5395d02b 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/config/services.yml"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/config/services.yml"
+++@@ -19,8 +19,9 @@ services:
+++             - '@language'
+++             - '@template'
+++             - '@dbal.conn'
+++-            - '@path_helper'
+++             - '%core.table_prefix%'
++++            - '%core.root_path%'
++++            - '%core.php_ext%'
+++     lukewcs.extmgrplus.core.common:
+++         class: lukewcs\extmgrplus\core\ext_mgr_plus_common
+++         arguments:
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/controller/acp_ext_mgr_plus_controller.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/controller/acp_ext_mgr_plus_controller.php"
+++index 2943e9378..0f91e63be 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/controller/acp_ext_mgr_plus_controller.php"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/controller/acp_ext_mgr_plus_controller.php"
+++@@ -15,16 +15,27 @@ namespace lukewcs\extmgrplus\controller;
+++ 
+++ class acp_ext_mgr_plus_controller
+++ {
++++	protected object $common;
++++	protected object $language;
++++	protected object $template;
++++	protected object $request;
++++	protected object $config;
++++
+++ 	protected string $u_action;
+++ 
+++ 	public function __construct(
+++-		protected object $common,
+++-		protected \phpbb\language\language $language,
+++-		protected \phpbb\template\template $template,
+++-		protected \phpbb\request\request $request,
+++-		protected \phpbb\config\config $config,
++++		$common,
++++		\phpbb\language\language $language,
++++		\phpbb\template\template $template,
++++		\phpbb\request\request $request,
++++		\phpbb\config\config $config
+++ 	)
+++ 	{
++++		$this->common	= $common;
++++		$this->language	= $language;
++++		$this->template	= $template;
++++		$this->request	= $request;
++++		$this->config	= $config;
+++ 	}
+++ 
+++ 	public function module_settings(): void
+++@@ -54,7 +65,6 @@ class acp_ext_mgr_plus_controller
+++ 			$this->config->set('extmgrplus_switch_order_and_ignore'	, $this->request->variable('extmgrplus_switch_order_and_ignore'	, 0));
+++ 			$this->config->set('extmgrplus_switch_self_disable'		, $this->request->variable('extmgrplus_switch_self_disable'		, 0));
+++ 			$this->config->set('extmgrplus_switch_instructions'		, $this->request->variable('extmgrplus_switch_instructions'		, 0));
+++-			$this->config->set('extmgrplus_switch_settings_link'	, $this->request->variable('extmgrplus_switch_settings_link'	, 0));
+++ 			$this->config->set('extmgrplus_number_vc_limit'			, $this->request->variable('extmgrplus_number_vc_limit'			, 0));
+++ 			$this->config->set('extmgrplus_switch_migration_col'	, $this->request->variable('extmgrplus_switch_migration_col'	, 0));
+++ 			$this->config->set('extmgrplus_switch_migrations'		, $this->request->variable('extmgrplus_switch_migrations'		, 0));
+++@@ -77,7 +87,6 @@ class acp_ext_mgr_plus_controller
+++ 			'EXTMGRPLUS_SWITCH_ORDER_AND_IGNORE'		=> (bool) $this->config['extmgrplus_switch_order_and_ignore'],
+++ 			'EXTMGRPLUS_SWITCH_SELF_DISABLE'			=> (bool) $this->config['extmgrplus_switch_self_disable'],
+++ 			'EXTMGRPLUS_SWITCH_INSTRUCTIONS'			=> (bool) $this->config['extmgrplus_switch_instructions'],
+++-			'EXTMGRPLUS_SWITCH_SETTINGS_LINK'			=> (bool) $this->config['extmgrplus_switch_settings_link'],
+++ 			'EXTMGRPLUS_NUMBER_VC_LIMIT'				=> (int) $this->config['extmgrplus_number_vc_limit'],
+++ 			'EXTMGRPLUS_SWITCH_MIGRATION_COL'			=> (bool) $this->config['extmgrplus_switch_migration_col'],
+++ 			'EXTMGRPLUS_SWITCH_MIGRATIONS'				=> (bool) $this->config['extmgrplus_switch_migrations'],
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/core/ext_mgr_plus.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/core/ext_mgr_plus.php"
+++index ee129cbb4..7bc61a912 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/core/ext_mgr_plus.php"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/core/ext_mgr_plus.php"
+++@@ -19,34 +19,55 @@ class ext_mgr_plus
+++ 	protected const  CHECKBOX_ALL	= 1;
+++ 	protected const  CHECKBOX_LAST	= 2;
+++ 
+++-	protected const  CDB_EXT			= 1;
+++-	protected const  CDB_EXT_OFFICIAL	= 2;
+++-
+++-	protected string $u_action;
+++-	protected int $safe_time_limit;
++++	protected object $common;
++++	protected object $ext_manager;
++++	protected object $cache;
++++	protected object $request;
++++	protected object $log;
++++	protected object $user;
++++	protected object $config;
++++	protected object $config_text;
++++	protected object $language;
++++	protected object $template;
++++	protected object $db;
++++	protected string $table_prefix;
+++ 	protected string $phpbb_root_path;
+++-	protected string $phpbb_admin_path;
+++ 	protected string $php_ext;
+++ 
++++	protected string $u_action;
++++	protected int    $safe_time_limit;
++++
+++ 	public function __construct(
+++-		protected object $common,
+++-		protected \phpbb\extension\manager $ext_manager,
+++-		protected \phpbb\cache\driver\driver_interface $cache,
+++-		protected \phpbb\request\request $request,
+++-		protected \phpbb\log\log $log,
+++-		protected \phpbb\user $user,
+++-		protected \phpbb\config\config $config,
+++-		protected \phpbb\config\db_text $config_text,
+++-		protected \phpbb\language\language $language,
+++-		protected \phpbb\template\template $template,
+++-		protected \phpbb\db\driver\driver_interface $db,
+++-		protected \phpbb\path_helper $path_helper,
+++-		protected string $table_prefix,
++++		$common,
++++		\phpbb\extension\manager $ext_manager,
++++		\phpbb\cache\driver\driver_interface $cache,
++++		\phpbb\request\request $request,
++++		\phpbb\log\log $log,
++++		\phpbb\user $user,
++++		\phpbb\config\config $config,
++++		\phpbb\config\db_text $config_text,
++++		\phpbb\language\language $language,
++++		\phpbb\template\template $template,
++++		\phpbb\db\driver\driver_interface $db,
++++		$table_prefix,
++++		$phpbb_root_path,
++++		$php_ext
+++ 	)
+++ 	{
+++-		$this->phpbb_root_path	= $this->path_helper->get_phpbb_root_path();
+++-		$this->phpbb_admin_path	= $this->phpbb_root_path . $this->path_helper->get_adm_relative_path();
+++-		$this->php_ext			= $this->path_helper->get_php_ext();
++++		$this->common			= $common;
++++		$this->ext_manager		= $ext_manager;
++++		$this->cache			= $cache;
++++		$this->request			= $request;
++++		$this->log				= $log;
++++		$this->user				= $user;
++++		$this->config			= $config;
++++		$this->config_text		= $config_text;
++++		$this->language			= $language;
++++		$this->template			= $template;
++++		$this->db				= $db;
++++		$this->table_prefix 	= $table_prefix;
++++		$this->phpbb_root_path	= $phpbb_root_path;
++++		$this->php_ext			= $php_ext;
+++ 	}
+++ 
+++ 	/*
+++@@ -59,9 +80,9 @@ class ext_mgr_plus
+++ 			return;
+++ 		}
+++ 
+++-		$this->u_action			= $event['u_action'];
+++-		$this->common->u_action	= $this->u_action;
+++-		$this->safe_time_limit	= $event['safe_time_limit'];
++++		$this->u_action = $event['u_action'];
++++		$this->common->u_action = $this->u_action;
++++		$this->safe_time_limit = $event['safe_time_limit'];
+++ 
+++ 		$this->language->add_lang(['acp_ext_mgr_plus', 'acp_ext_mgr_plus_lang_author'], 'lukewcs/extmgrplus');
+++ 		$this->common->set_meta_template_vars('EXTMGRPLUS', 'LukeWCS');
+++@@ -74,19 +95,17 @@ class ext_mgr_plus
+++ 
+++ 			$this->exts_switch_confirm();
+++ 		}
+++-		else if ($this->request->is_set_post('extmgrplus_save_ext_properties'))
++++		else if ($this->request->is_set_post('extmgrplus_save_ext_properties') && $this->config['extmgrplus_switch_order_and_ignore'])
+++ 		{
+++ 			$this->common->check_form_key_('lukewcs_extmgrplus');
+++ 
+++-			if ($this->config['extmgrplus_switch_order_and_ignore'])
+++-			{
+++-				$order_list		= $this->request->variable('ext_order', ['' => '']);
+++-				$ignore_list	= $this->request->variable('ext_ignore', ['']);
+++-				$order_list		= preg_grep('/^\+?[0-9]{1,2}$/', $order_list);
++++			$order_list = $this->request->variable('ext_order', ['' => '']);
++++			$ignore_list = $this->request->variable('ext_ignore', ['']);
+++ 
+++-				$this->common->config_text_set('extmgrplus_list_order_and_ignore', 'order', count($order_list) ? $order_list : null);
+++-				$this->common->config_text_set('extmgrplus_list_order_and_ignore', 'ignore', count($ignore_list) ? $ignore_list : null);
+++-			}
++++			$order_list = preg_grep('/^\+?[0-9]{1,2}$/', $order_list);
++++
++++			$this->common->config_text_set('extmgrplus_list_order_and_ignore', 'order', count($order_list) ? $order_list : null);
++++			$this->common->config_text_set('extmgrplus_list_order_and_ignore', 'ignore', count($ignore_list) ? $ignore_list : null);
+++ 
+++ 			$this->common->trigger_error_($this->language->lang('EXTMGRPLUS_MSG_EXT_PROPERTIES_SAVED'), E_USER_NOTICE, 'RETURN_TO_EXTENSION_LIST');
+++ 		}
+++@@ -111,8 +130,6 @@ class ext_mgr_plus
+++ 	{
+++ 		if ($event['action'] == 'details')
+++ 		{
+++-			$event['tpl_name'] = '@lukewcs_extmgrplus/acp_ext_mgr_plus_acp_ext_details';
+++-
+++ 			$this->extend_details($event['ext_name']);
+++ 			$this->versioncheck_details($event['ext_name']);
+++ 			return;
+++@@ -136,7 +153,6 @@ class ext_mgr_plus
+++ 		if ($vc_request)
+++ 		{
+++ 			$event['tpl_name'] = '@lukewcs_extmgrplus/acp_ext_mgr_plus_versioncheck';
+++-
+++ 			$this->template->assign_vars([
+++ 				'EXTMGRPLUS_VC_DATA'		=> $ext_list_versioncheck['data'],
+++ 				'U_EXTMGRPLUS_VC_CANCEL'	=> $this->u_action,
+++@@ -165,7 +181,6 @@ class ext_mgr_plus
+++ 		$ext_list_migrations_inactive			= [];
+++ 		$ext_list_order							= [];
+++ 		$ext_list_ignore						= [];
+++-		$ext_list_modules						= [];
+++ 		$ext_list_enabled_ignored				= [];
+++ 		$ext_list_disabled_ignored				= [];
+++ 		$ext_list_selected						= [];
+++@@ -184,11 +199,6 @@ class ext_mgr_plus
+++ 			$ext_list_disabled_ignored	= array_intersect_key($ext_list_ignore, $ext_list_disabled);
+++ 		}
+++ 
+++-		if ($this->config['extmgrplus_switch_settings_link'])
+++-		{
+++-			$ext_list_modules = $this->get_module_links();
+++-		}
+++-
+++ 		if ($this->config['extmgrplus_switch_migration_col'])
+++ 		{
+++ 			$ext_list_migrations_inactive = $this->get_exts_with_new_migration(array_diff_key($ext_list_available, $ext_list_enabled, $ext_list_ignore));
+++@@ -204,7 +214,6 @@ class ext_mgr_plus
+++ 		{
+++ 			$ext_list_enabled_ignored['lukewcs/extmgrplus'] = 0;
+++ 		}
+++-
+++ 		if (!$this->config['extmgrplus_switch_migrations'])
+++ 		{
+++ 			$ext_list_disabled_ignored = array_merge($ext_list_disabled_ignored, $ext_list_migrations_disabled);
+++@@ -246,7 +255,6 @@ class ext_mgr_plus
+++ 			'EXTMGRPLUS_LIST_IGNORE'				=> $ext_list_ignore,
+++ 			'EXTMGRPLUS_LIST_MIGRATIONS'			=> $ext_list_migrations_inactive,
+++ 			'EXTMGRPLUS_LIST_SELECTED'				=> $ext_list_selected,
+++-			'EXTMGRPLUS_LIST_MODULES'				=> $ext_list_modules,
+++ 			'EXTMGRPLUS_LIST_VERSIONCHECK'			=> $this->versioncheck_list($ext_list_available, $ext_list_versioncheck),
+++ 
+++ 			'EXTMGRPLUS_COUNT'						=> [
+++@@ -265,7 +273,6 @@ class ext_mgr_plus
+++ 			'EXTMGRPLUS_SWITCH_ORDER_AND_IGNORE'	=> $this->config['extmgrplus_switch_order_and_ignore'],
+++ 			'EXTMGRPLUS_SWITCH_SELF_DISABLE'		=> $this->config['extmgrplus_switch_self_disable'],
+++ 			'EXTMGRPLUS_SWITCH_INSTRUCTIONS'		=> $this->config['extmgrplus_switch_instructions'],
+++-			'EXTMGRPLUS_SWITCH_SETTINGS_LINK'		=> $this->config['extmgrplus_switch_settings_link'],
+++ 			'EXTMGRPLUS_SWITCH_MIGRATION_COL'		=> $this->config['extmgrplus_switch_migration_col'],
+++ 			'EXTMGRPLUS_SWITCH_MIGRATIONS'			=> $this->config['extmgrplus_switch_migrations'],
+++ 		]);
+++@@ -277,7 +284,7 @@ class ext_mgr_plus
+++ 	*/
+++ 	public function change_msg_template(): void
+++ 	{
+++-		if ($this->template->retrieve_var('EXTMGRPLUS_TRIGGER_ERROR') !== null)
++++		if ($this->template->retrieve_var('EXTMGRPLUS_TRIGGER_ERROR'))
+++ 		{
+++ 			$this->template->set_filenames(['body' => '@lukewcs_extmgrplus/acp_ext_mgr_plus_message_body.html']);
+++ 		}
+++@@ -327,8 +334,7 @@ class ext_mgr_plus
+++ 		{
+++ 			$this->template->assign_vars([
+++ 				'EXTMGRPLUS_ACTION_MODE'	=> 'DISABLE',
+++-				'EXTMGRPLUS_CONFIRM_YES'	=> 'EXTENSION_DISABLE',
+++-				'EXTMGRPLUS_CONFIRM_NO'		=> 'CANCEL',
++++				'EXTMGRPLUS_SELF_DISABLE'	=> array_search('lukewcs/extmgrplus', $ext_mark_enabled) !== false,
+++ 			]);
+++ 			if (!$this->config['extmgrplus_switch_confirmation'] || confirm_box(true))
+++ 			{
+++@@ -343,8 +349,6 @@ class ext_mgr_plus
+++ 		{
+++ 			$this->template->assign_vars([
+++ 				'EXTMGRPLUS_ACTION_MODE'	=> 'ENABLE',
+++-				'EXTMGRPLUS_CONFIRM_YES'	=> 'EXTENSION_ENABLE',
+++-				'EXTMGRPLUS_CONFIRM_NO'		=> 'CANCEL',
+++ 			]);
+++ 			if (!$this->config['extmgrplus_switch_confirmation'] || confirm_box(true))
+++ 			{
+++@@ -393,17 +397,17 @@ class ext_mgr_plus
+++ 		{
+++ 			try
+++ 			{
+++-				$ext_meta = $this->ext_manager->create_extension_metadata_manager($ext_name)->get_metadata('all');
++++				$ext_metadata = $this->ext_manager->create_extension_metadata_manager($ext_name)->get_metadata('all');
+++ 			}
+++ 			catch (\RuntimeException $e)
+++ 			{
+++-				$ext_meta = null;
++++				$ext_metadata = null;
+++ 			}
+++ 
+++-			if (is_array($ext_meta))
++++			if (is_array($ext_metadata))
+++ 			{
+++-				$ext_display_name	= $ext_meta['extra']['display-name'] ?? '';
+++-				$ext_version		= $ext_meta['version'] ?? '';
++++				$ext_display_name	= $ext_metadata['extra']['display-name'] ?? '';
++++				$ext_version		= $ext_metadata['version'] ?? '';
+++ 
+++ 				$disable_error = '';
+++ 				if ($this->ext_manager->is_enabled($ext_name))
+++@@ -436,7 +440,7 @@ class ext_mgr_plus
+++ 				}
+++ 			}
+++ 
+++-			if ($this->safe_time_limit > 0 && (microtime(true) - $GLOBALS['starttime']) >= $this->safe_time_limit)
++++			if ((microtime(true) - $GLOBALS['starttime']) >= $this->safe_time_limit)
+++ 			{
+++ 				$safe_time_exceeded = true;
+++ 				break;
+++@@ -458,7 +462,7 @@ class ext_mgr_plus
+++ 		}
+++ 		$this->common->trigger_error_(
+++ 			$this->language->lang('EXTMGRPLUS_MSG_DEACTIVATION', $ext_count_success, $ext_count_enabled) . ($msg_failed ?? ''),
+++-			$this->get_error_level($ext_count_success, $ext_count_enabled, $safe_time_exceeded),
++++			(($ext_count_success != $ext_count_enabled || $safe_time_exceeded) ? E_USER_WARNING : E_USER_NOTICE),
+++ 			'RETURN_TO_EXTENSION_LIST'
+++ 		);
+++ 	}
+++@@ -498,17 +502,17 @@ class ext_mgr_plus
+++ 		{
+++ 			try
+++ 			{
+++-				$ext_meta = $this->ext_manager->create_extension_metadata_manager($ext_name)->get_metadata('all');
++++				$ext_metadata = $this->ext_manager->create_extension_metadata_manager($ext_name)->get_metadata('all');
+++ 			}
+++ 			catch (\RuntimeException $e)
+++ 			{
+++-				$ext_meta = null;
++++				$ext_metadata = null;
+++ 			}
+++ 
+++-			if (is_array($ext_meta))
++++			if (is_array($ext_metadata))
+++ 			{
+++-				$ext_display_name	= $ext_meta['extra']['display-name'] ?? '';
+++-				$ext_version		= $ext_meta['version'] ?? '';
++++				$ext_display_name	= $ext_metadata['extra']['display-name'] ?? '';
++++				$ext_version		= $ext_metadata['version'] ?? '';
+++ 
+++ 				if ($this->ext_manager->is_disabled($ext_name))
+++ 				{
+++@@ -554,7 +558,7 @@ class ext_mgr_plus
+++ 				}
+++ 			}
+++ 
+++-			if ($this->safe_time_limit > 0 && (microtime(true) - $GLOBALS['starttime']) >= $this->safe_time_limit)
++++			if ((microtime(true) - $GLOBALS['starttime']) >= $this->safe_time_limit)
+++ 			{
+++ 				$safe_time_exceeded = true;
+++ 				break;
+++@@ -576,7 +580,7 @@ class ext_mgr_plus
+++ 		}
+++ 		$this->common->trigger_error_(
+++ 			$this->language->lang('EXTMGRPLUS_MSG_ACTIVATION', $ext_count_success, $ext_count_disabled) . ($msg_failed ?? ''),
+++-			$this->get_error_level($ext_count_success, $ext_count_disabled, $safe_time_exceeded),
++++			(($ext_count_success != $ext_count_disabled || $safe_time_exceeded) ? E_USER_WARNING : E_USER_NOTICE),
+++ 			'RETURN_TO_EXTENSION_LIST'
+++ 		);
+++ 	}
+++@@ -588,14 +592,14 @@ class ext_mgr_plus
+++ 	{
+++ 		$msg_failed = '<br><br>' . $this->language->lang($lang_var);
+++ 		$count_failed = 0;
+++-		foreach ($ext_list as $ext_name => $vars)
++++		foreach ($ext_list as $name => $vars)
+++ 		{
+++ 			if (is_array($vars['message']))
+++ 			{
+++ 				$vars['message'] = implode('<br>', $vars['message']);
+++ 			}
+++ 			$count_failed++;
+++-			$msg_failed .= $this->create_failed_msg($count_failed . '. ' . $vars['display_name'], $vars['ext_version'], $ext_name, $vars['message']);
++++			$msg_failed .= $this->create_failed_msg($count_failed . '. ' . $vars['display_name'], $vars['ext_version'], $name, $vars['message']);
+++ 		}
+++ 
+++ 		return $msg_failed;
+++@@ -606,24 +610,12 @@ class ext_mgr_plus
+++ 	*/
+++ 	private function create_failed_msg(string $display_name, string $ext_version, string $ext_name, string $message): string
+++ 	{
+++-		return vsprintf('<br><br><strong>%1$s %2$s (%3$s)</strong>%4$s', [
+++-			1	=> $display_name,
+++-			2	=> $this->language->lang('EXTMGRPLUS_VERSION_STRING', $ext_version),
+++-			3	=> $ext_name,
+++-			4	=> empty($message) ? '' : "<br><br><em>{$message}</em>"
+++-		]);
+++-	}
+++-
+++-	/*
+++-		Helper function for trigger_error
+++-	*/
+++-	function get_error_level(int $count_success, int $count_total, bool $safe_time_exceeded): int
+++-	{
+++-		return match (true) {
+++-			$count_success == $count_total				=> E_USER_NOTICE,
+++-			$count_success == 0, $safe_time_exceeded	=> E_USER_WARNING,
+++-			default										=> E_USER_NOTICE + E_USER_ERROR,
+++-		};
++++		return sprintf('<br><br><strong>%1$s %2$s (%3$s)</strong>%4$s',
++++			/* 1 */	$display_name,
++++			/* 2 */	$this->language->lang('EXTMGRPLUS_VERSION_STRING', $ext_version),
++++			/* 3 */	$ext_name,
++++			/* 4 */	empty($message) ? '' : "<br><br><em>{$message}</em>"
++++		);
+++ 	}
+++ 
+++ 	/*
+++@@ -673,48 +665,6 @@ class ext_mgr_plus
+++ 		return count($migration_classes_new);
+++ 	}
+++ 
+++-	/*
+++-		Determine all ACP module links of the active extensions
+++-	*/
+++-	private function get_module_links(): array
+++-	{
+++-		global $module;
+++-
+++-		$module_urls = [];
+++-		$module_tabs = [];
+++-
+++-		$modules = array_combine(array_column($module->module_ary, 'id'), $module->module_ary);
+++-		$get_module_top_cat = function (int $module_id) use ($modules): string
+++-		{
+++-			$parent_id = $modules[$module_id]['parent'];
+++-			while ($parent_id !== 0)
+++-			{
+++-				$module_id = $parent_id;
+++-				$parent_id = $modules[$module_id]['parent'];
+++-			}
+++-
+++-			return $modules[$module_id]['langname'];
+++-		};
+++-
+++-		foreach (array_filter($modules, fn($row): bool => $row['name'] !== '' && $row['display']) as $module_row)
+++-		{
+++-			preg_match('/\\\\(.+?)\\\\(.+?)\\\\.*/', $module_row['name'], $matches);
+++-			$tech_name = (count($matches) === 3) ? $matches[1] . '/' . $matches[2] : false;
+++-			if ($tech_name !== false)
+++-			{
+++-				$module_tab = $get_module_top_cat($module_row['parent']);
+++-				if (!isset($module_urls[$tech_name]) || ($module_tab === 'ACP_CAT_DOT_MODS' && $module_tabs[$tech_name] !== $module_tab))
+++-				{
+++-					$module_name = str_replace('\\', '-', $module_row['name']);
+++-					$module_urls[$tech_name] = append_sid("{$this->phpbb_admin_path}index.{$this->php_ext}", "i={$module_name}&amp;mode={$module_row['mode']}");
+++-					$module_tabs[$tech_name] = $module_tab;
+++-				}
+++-			}
+++-		}
+++-
+++-		return $module_urls;
+++-	}
+++-
+++ 	/*
+++ 		Check if file is a valid migration file
+++ 	*/
+++@@ -726,14 +676,17 @@ class ext_mgr_plus
+++ 			$file_content = file_get_contents($file);
+++ 			if ($file_content !== false)
+++ 			{
+++-				return (
+++-					preg_match('/function\s+?(?:depends_on|effectively_installed|update_schema|update_data|revert_data)\s*?\(/', $file_content)
+++-					&& preg_match('/^\s*?class\s+?' . $file_info['filename'] . '\s+/mi', $file_content)
+++-				) ? 1 : 0;
++++				$check_migration = ((
++++						preg_match('/function\s+?(?:depends_on|effectively_installed|update_schema|update_data|revert_data)\s*?\(/', $file_content)
++++						&& preg_match('/^\s*?class\s+?' . $file_info['filename'] . '\s+/mi', $file_content)
++++					)
++++					? 1
++++					: 0
++++				);
+++ 			}
+++ 		}
+++ 
+++-		return -1;
++++		return ($check_migration ?? -1);
+++ 	}
+++ 
+++ 	/*
+++@@ -757,7 +710,7 @@ class ext_mgr_plus
+++ 	/*
+++ 		Preparation to be able to run a version check in blocks
+++ 	*/
+++-	private function versioncheck_prepare(array|null &$ext_list_vc): void
++++	private function versioncheck_prepare(?array &$ext_list_vc): void
+++ 	{
+++ 		$ext_list_all	= $this->ext_manager->all_available();
+++ 		$ext_list_vc	= [
+++@@ -778,7 +731,6 @@ class ext_mgr_plus
+++ 			}
+++ 			catch (\RuntimeException $e)
+++ 			{
+++-				$vc_meta = null;
+++ 			}
+++ 
+++ 			if (isset($vc_meta))
+++@@ -789,7 +741,6 @@ class ext_mgr_plus
+++ 				$this->cache->destroy(str_replace(['/', '\\'], '-', $cache_filename));
+++ 			}
+++ 		}
+++-
+++ 		$ext_list_vc['data']['count_total']	= count($ext_list_vc) - 1;
+++ 		$this->common->config_text_set('extmgrplus_list_version_check', 'updates', $ext_list_vc);
+++ 	}
+++@@ -851,8 +802,8 @@ class ext_mgr_plus
+++ 
+++ 		try
+++ 		{
+++-			$ext_meta = $md_manager->get_metadata('all');
+++-			if (isset($ext_meta['extra']['version-check']))
++++			$ext_metadata = $md_manager->get_metadata('all');
++++			if (isset($ext_metadata['extra']['version-check']))
+++ 			{
+++ 				$vc_data = $this->ext_manager->version_check($md_manager, !$read_cache, $read_cache, $this->config['extension_force_unstable'] ? 'unstable' : null);
+++ 				$vc_current = empty($vc_data) ? 'NOUPD' : $vc_data['current'];
+++@@ -875,7 +826,7 @@ class ext_mgr_plus
+++ 	/*
+++ 		Reads the version check data from the database and removes obsolete entries and generates a list for the template
+++ 	*/
+++-	private function versioncheck_list(array &$ext_list, array|null &$ext_list_vc): array
++++	private function versioncheck_list(array &$ext_list, ?array &$ext_list_vc): array
+++ 	{
+++ 		$ext_list_vc ??= [];
+++ 
+++@@ -892,17 +843,10 @@ class ext_mgr_plus
+++ 			}
+++ 			if ($this->ext_manager->is_available($ext_name))
+++ 			{
+++-				try
+++-				{
+++-					$ext_meta = $this->ext_manager->create_extension_metadata_manager($ext_name)->get_metadata('all');
+++-				}
+++-				catch (\RuntimeException $e)
+++-				{
+++-					$ext_meta = null;
+++-				}
++++				$ext_metadata = $this->ext_manager->create_extension_metadata_manager($ext_name)->get_metadata('all');
+++ 
+++ 				$no_ver_flags = $vc_data['current'] == 'NOUPD' || $vc_data['current'] == 'ERROR' || $vc_data['current'] == '';
+++-				$has_update = !$no_ver_flags && phpbb_version_compare($ext_meta['version'] ?? '0.0.0', $vc_data['current'], '<');
++++				$has_update = !$no_ver_flags && phpbb_version_compare($ext_metadata['version'], $vc_data['current'], '<');
+++ 				if ($no_ver_flags || $has_update)
+++ 				{
+++ 					$ext_list_tpl[$ext_name]['current'] = $vc_data['current'];
+++@@ -943,19 +887,15 @@ class ext_mgr_plus
+++ 		{
+++ 			try
+++ 			{
+++-				$ext_meta = $this->ext_manager->create_extension_metadata_manager($ext_name)->get_metadata('all');
++++				$ext_metadata = $this->ext_manager->create_extension_metadata_manager($ext_name)->get_metadata('all');
+++ 			}
+++ 			catch (\RuntimeException $e)
+++ 			{
+++-				$ext_meta = null;
+++ 			}
+++ 
+++-			if (isset($ext_meta['extra']['version-check']))
++++			if (isset($ext_metadata['extra']['version-check']))
+++ 			{
+++-				if (($ext_meta['extra']['version-check']['host'] ?? '') == 'www.phpbb.com')
+++-				{
+++-					$ext_list_tpl[$ext_name]['cdb_ext']	= substr($ext_meta['name'], 0, 6) == 'phpbb/' ? self::CDB_EXT_OFFICIAL : self::CDB_EXT;
+++-				}
++++				$ext_list_tpl[$ext_name]['cdb_ext']	= ($ext_metadata['extra']['version-check']['host'] ?? '') == 'www.phpbb.com';
+++ 				$count_total++;
+++ 			}
+++ 			else
+++@@ -980,16 +920,13 @@ class ext_mgr_plus
+++ 	*/
+++ 	private function extend_details(string $ext_name): void
+++ 	{
+++-		$ext_meta	= $this->ext_manager->create_extension_metadata_manager($ext_name)->get_metadata('all');
+++-		$vc_meta	= $ext_meta['extra']['version-check'] ?? null;
+++-		$details	= [];
+++-
++++		$vc_meta = $this->ext_manager->create_extension_metadata_manager($ext_name)->get_metadata('all')['extra']['version-check'] ?? null;
++++		$details = [];
+++ 		if (isset($vc_meta))
+++ 		{
+++ 			if (($vc_meta['host'] ?? '') == 'www.phpbb.com')
+++ 			{
+++-				$details['cdb_page']	= 'https://www.phpbb.com' . $vc_meta['directory'] . '/';
+++-				$details['cdb_ext']		= substr($ext_meta['name'], 0, 6) == 'phpbb/' ? self::CDB_EXT_OFFICIAL : self::CDB_EXT;
++++				$details['cdb_page'] = 'https://www.phpbb.com' . $vc_meta['directory'] . '/';
+++ 			}
+++ 			if ($this->config['extmgrplus_switch_version_url'])
+++ 			{
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/core/ext_mgr_plus_common.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/core/ext_mgr_plus_common.php"
+++index ebb95000f..f56977333 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/core/ext_mgr_plus_common.php"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/core/ext_mgr_plus_common.php"
+++@@ -15,18 +15,30 @@ namespace lukewcs\extmgrplus\core;
+++ 
+++ class ext_mgr_plus_common
+++ {
+++-	protected array $metadata;
+++-	public string $u_action;
++++	protected object $config;
++++	protected object $config_text;
++++	protected object $language;
++++	protected object $template;
++++	protected object $ext_manager;
++++
++++	protected array  $metadata;
++++	public    string $u_action;
+++ 
+++ 	public function __construct(
+++-		protected \phpbb\config\config $config,
+++-		protected \phpbb\config\db_text $config_text,
+++-		protected \phpbb\language\language $language,
+++-		protected \phpbb\template\template $template,
+++-		protected \phpbb\extension\manager $ext_manager,
++++		\phpbb\config\config $config,
++++		\phpbb\config\db_text $config_text,
++++		\phpbb\language\language $language,
++++		\phpbb\template\template $template,
++++		\phpbb\extension\manager $ext_manager
+++ 	)
+++ 	{
+++-		$this->metadata = $this->ext_manager->create_extension_metadata_manager('lukewcs/extmgrplus')->get_metadata('all');
++++		$this->config		= $config;
++++		$this->config_text	= $config_text;
++++		$this->language		= $language;
++++		$this->template		= $template;
++++		$this->ext_manager	= $ext_manager;
++++
++++		$this->metadata		= $this->ext_manager->create_extension_metadata_manager('lukewcs/extmgrplus')->get_metadata('all');
+++ 	}
+++ 
+++ 	public function set_meta_template_vars(string $tpl_prefix, string $copyright): void
+++@@ -70,7 +82,7 @@ class ext_mgr_plus_common
+++ 			{
+++ 				$lang_outdated_msg = $this->language->lang($lang_outdated_var);
+++ 			}
+++-			else /* Fallback if the current language package does not yet have the required variable. */
++++			else // Fallback if the current language package does not yet have the required variable.
+++ 			{
+++ 				$lang_outdated_msg = 'Note: The language pack for the extension <strong>%1$s</strong> is no longer up-to-date. (installed: %2$s / needed: %3$s)';
+++ 			}
+++@@ -83,7 +95,7 @@ class ext_mgr_plus_common
+++ 	/*
+++ 		Set a variable/array in a config_text variable container or delete one or all variables/arrays
+++ 	*/
+++-	public function config_text_set(string $container, string|null $name, $value): void
++++	public function config_text_set(string $container, ?string $name, $value): void
+++ 	{
+++ 		if ($this->config_text->get($container) === null)
+++ 		{
+++@@ -113,7 +125,7 @@ class ext_mgr_plus_common
+++ 	/*
+++ 		Get a variable/array from a config_text variable co
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/event/listener.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/event/listener.php"
++index 6be72ab45..e6ff2a295 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/event/listener.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/event/listener.php"
++@@ -18,9 +18,10 @@ use Symfony\Component\EventDispatcher\EventSubscriberInterface;
++ class listener implements EventSubscriberInterface
++ {
++ 	public function __construct(
++-		protected \lukewcs\extmgrplus\core\ext_mgr_plus $extmgrplus,
+++		\lukewcs\extmgrplus\core\ext_mgr_plus $extmgrplus
++ 	)
++ 	{
+++		$this->extmgrplus = $extmgrplus;
++ 	}
++ 
++ 	public static function getSubscribedEvents(): array
++@@ -32,12 +33,12 @@ class listener implements EventSubscriberInterface
++ 		];
++ 	}
++ 
++-	public function ext_manager_before(object $event): void
+++	public function ext_manager_before($event): void
++ 	{
++ 		$this->extmgrplus->ext_manager_before($event);
++ 	}
++ 
++-	public function ext_manager_after(object $event): void
+++	public function ext_manager_after($event): void
++ 	{
++ 		$this->extmgrplus->ext_manager_after($event);
++ 	}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/ext.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/ext.php"
++index b4bb2602c..b05f649b1 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/ext.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/ext.php"
++@@ -18,7 +18,7 @@ class ext extends \phpbb\extension\base
++ 	public function is_enableable()
++ 	{
++ 		$valid_phpbb = phpbb_version_compare(PHPBB_VERSION, '3.3.8', '>=') && phpbb_version_compare(PHPBB_VERSION, '3.4.0-dev', '<');
++-		$valid_php = phpbb_version_compare(PHP_VERSION, '8.0.0', '>=') && phpbb_version_compare(PHP_VERSION, '8.5.0-dev', '<');
+++		$valid_php = phpbb_version_compare(PHP_VERSION, '7.4.0', '>=') && phpbb_version_compare(PHP_VERSION, '8.5.0-dev', '<');
++ 
++ 		return ($valid_phpbb && $valid_php);
++ 	}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/language/de/acp_ext_mgr_plus.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/language/de/acp_ext_mgr_plus.php"
++index 817751d59..1e91c7d2f 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/language/de/acp_ext_mgr_plus.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/language/de/acp_ext_mgr_plus.php"
++@@ -45,11 +45,11 @@ $lang = array_merge($lang, [
++ 	'EXTMGRPLUS_COL_WITH_VERSIONCHECK'		=> 'Mit Versionsprüfung',
++ 	'EXTMGRPLUS_COL_LAST_VERSIONCHECK'		=> 'Letzte Versionsprüfung',
++ 	'EXTMGRPLUS_COL_AVAILABLE_UPDATES'		=> 'Verfügbare Updates',
++-	'EXTMGRPLUS_AVAILABLE_EXTENSIONS'		=> [
+++	'EXTMGRPLUS_AVAILABLE_EXTENSIONS' => [
++ 		0									=> '%2$u',
++ 		1									=> '%2$u (%1$u ungültige)',
++ 	],
++-	'EXTMGRPLUS_VERSIONCHECK_DATE'			=> [
+++	'EXTMGRPLUS_VERSIONCHECK_DATE' => [
++ 		0									=> '%2$s (%3$u Sek.)',
++ 		1									=> '%2$s (%3$u Sek. / %1$u Fehler)',
++ 	],
++@@ -89,22 +89,20 @@ $lang = array_merge($lang, [
++ 	'EXTMGRPLUS_TOOLTIP_SELECT'				=> 'Erweiterung auswählen.',
++ 	'EXTMGRPLUS_TOOLTIP_IS_LOCKED'			=> 'Die Auswahl dieser Erweiterung ist wegen neuer Migrationen gesperrt.',
++ 	// tooltips icons
++-	'EXTMGRPLUS_TOOLTIP_CDB_EXT'			=> 'Das ist eine validierte Erweiterung.',
++-	'EXTMGRPLUS_TOOLTIP_CDB_EXT_OFFICIAL'	=> 'Das ist eine offizielle Erweiterung von phpBB.com.',
+++	'EXTMGRPLUS_TOOLTIP_CDB_EXT'			=> 'Diese Erweiterung wurde offiziell validiert.',
++ 	'EXTMGRPLUS_TOOLTIP_OUTDATED'			=> 'Die installierte Version dieser Erweiterung ist veraltet.',
++ 	'EXTMGRPLUS_TOOLTIP_VERSIONCHECK_ERROR'	=> 'Bei der Versionsprüfung ist ein Fehler aufgetreten. Klicke auf „Details“ um mehr zu erfahren.',
++ 	'EXTMGRPLUS_TOOLTIP_VERSIONCHECK_EMPTY'	=> 'Bei dieser Erweiterung wurde keine Versionsprüfung ausgeführt.',
++ 	'EXTMGRPLUS_TOOLTIP_NO_VERSIONCHECK'	=> 'Diese Erweiterung bietet keine Versionsprüfung.',
++ 	'EXTMGRPLUS_TOOLTIP_IS_IGNORED'			=> 'Diese Erweiterung wird von „Extension Manager Plus“ ignoriert.',
++-	'EXTMGRPLUS_TOOLTIP_SETTINGS'			=> 'Das primäre Einstellungsmodul dieser Erweiterung aufrufen.',
++ 
++ 	// misc
++-	'EXTMGRPLUS_EXTENSION_PLURAL'			=> [
+++	'EXTMGRPLUS_EXTENSION_PLURAL' => [
++ 		0									=> '0 Erweiterungen',
++ 		1									=> '1 Erweiterung',
++ 		2									=> '%u Erweiterungen',
++ 	],
++-	'EXTMGRPLUS_SECOND_PLURAL'				=> [
+++	'EXTMGRPLUS_SECOND_PLURAL' => [
++ 		0									=> '0 Sekunden',
++ 		1									=> '1 Sekunde',
++ 		2									=> '%u Sekunden',
++@@ -112,6 +110,7 @@ $lang = array_merge($lang, [
++ 	'EXTMGRPLUS_SPOILER_LABEL'				=> 'Erklärung',
++ 
++ 	// details
+++	'EXTMGRPLUS_SECTION_DETAILS'			=> 'Informationen von Extension Manager Plus',
++ 	'EXTMGRPLUS_DETAILS_CDB_PAGE'			=> 'Seite der phpBB-Erweiterungsdatenbank',
++ 	'EXTMGRPLUS_DETAILS_VERSION_URL'		=> 'Link zur Versionsdatei',
++ 
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/language/de/acp_ext_mgr_plus_lang_author.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/language/de/acp_ext_mgr_plus_lang_author.php"
++index e66fd16d3..83be08800 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/language/de/acp_ext_mgr_plus_lang_author.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/language/de/acp_ext_mgr_plus_lang_author.php"
++@@ -42,7 +42,7 @@ if (empty($lang) || !is_array($lang))
++ $lang = array_merge($lang, [
++ 	// language pack author
++ 	'EXTMGRPLUS_LANG_DESC'					=> 'Deutsch (Du)',
++-	'EXTMGRPLUS_LANG_VER' 					=> '3.1.0',
+++	'EXTMGRPLUS_LANG_VER' 					=> '3.0.0',
++ 	'EXTMGRPLUS_LANG_AUTHOR'				=> 'LukeWCS',
++ 
++ 	// messages
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/language/de/acp_ext_mgr_plus_settings.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/language/de/acp_ext_mgr_plus_settings.php"
++index 9d945e260..4d4265507 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/language/de/acp_ext_mgr_plus_settings.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/language/de/acp_ext_mgr_plus_settings.php"
++@@ -55,10 +55,10 @@ $lang = array_merge($lang, [
++ 	'EXTMGRPLUS_CHECKBOX_MODE_LAST'			=> 'Letzten Zustand merken',
++ 	'EXTMGRPLUS_SELF_DISABLE'				=> 'Erlaube Eigendeaktivierung',
++ 	'EXTMGRPLUS_SELF_DISABLE_EXPLAIN'		=> 'Wenn du diese Option aktivierst, dann kann sich „Extension Manager Plus“ bei der Aktion „Ausgewählte deaktivieren“ auch selbst deaktivieren, da diese Erweiterung dann wie jede andere ausgewählt werden kann.',
+++	'EXTMGRPLUS_INSTRUCTIONS'				=> 'Anleitungen anzeigen',
+++	'EXTMGRPLUS_INSTRUCTIONS_EXPLAIN'		=> 'Mit dieser Option kannst du festlegen, ob die Anleitungen für Installieren, Aktualisieren und Deinstallieren am Ende der Erweiterungen-Liste angezeigt werden sollen.',
++ 	'EXTMGRPLUS_VC_LIMIT'					=> 'Ausführungszeit der Versionsprüfung aufteilen',
++ 	'EXTMGRPLUS_VC_LIMIT_EXPLAIN'			=> 'Die Versionsprüfung wird blockweise ausgeführt und mit diesem Wert kannst du festlegen, wie lange ein einzelner Block der Versionsprüfung maximal dauern darf. Damit wird verhindert, dass Zeitlimits von PHP oder der Datenbank überschritten werden.',
++-	'EXTMGRPLUS_SETTING_LINKS'				=> 'Link zu den Einstellungen erzeugen',
++-	'EXTMGRPLUS_SETTING_LINKS_EXPLAIN'		=> 'Mit dieser Option kannst du festlegen, ob in der Spalte „Vorgänge“ ein Link zum primären Einstellungsmodul (sofern vorhanden) der jeweiligen Erweiterung eingefügt werden soll.',
++ 
++ 	// settings extension properties
++ 	'EXTMGRPLUS_SECTION_EXT_PROPERTIES'		=> 'Eigenschaften der Erweiterungen',
++@@ -67,9 +67,7 @@ $lang = array_merge($lang, [
++ 
++ 	// settings expert
++ 	'EXTMGRPLUS_SECTION_EXPERT_SETTINGS'	=> 'Experten-Einstellungen',
++-	'EXTMGRPLUS_EXPERT_SETTINGS_EXPLAIN'	=> 'Dieser Abschnitt ist unter anderem für Entwickler gedacht; hier können besondere Funktionen und Eigenschaften gesteuert werden. Bei Funktionen die problematisch sein können, muss eine Rückfrage bestätigt werden.',
++-	'EXTMGRPLUS_INSTRUCTIONS'				=> 'Anleitungen anzeigen',
++-	'EXTMGRPLUS_INSTRUCTIONS_EXPLAIN'		=> 'Mit dieser Option kannst du festlegen, ob die Anleitungen für Installieren, Aktualisieren und Deinstallieren am Ende der Erweiterungen-Liste angezeigt werden sollen.',
+++	'EXTMGRPLUS_EXPERT_SETTINGS_EXPLAIN'	=> 'In diesem Abschnitt können besondere Funktionen aktiviert werden, die zum Beispiel für Entwickler relevant sind. Bei Funktionen die problematisch sein können, muss eine Rückfrage bestätigt werden.',
++ 	'EXTMGRPLUS_MIGRATION_COL'				=> 'Spalte mit neuen Migrationen anzeigen',
++ 	'EXTMGRPLUS_MIGRATION_COL_EXPLAIN'		=> 'Wenn diese Option aktiviert ist, dann wird eine zusätzliche Spalte angezeigt, in der die Anzahl neuer Migrationen aufgeführt ist. Die Anzahl wird sowohl bei „Deaktivierte Erweiterungen“ als auch bei „Nicht installierte Erweiterungen“ angezeigt.',
++ 	'EXTMGRPLUS_MIGRATIONS'					=> 'Erlaube Erweiterungen mit neuen Migrationen',
++@@ -80,7 +78,7 @@ $lang = array_merge($lang, [
++ 	// settings reset
++ 	'EXTMGRPLUS_SECTION_RESET'				=> 'Zurücksetzen',
++ 	'EXTMGRPLUS_DEFAULTS'					=> 'Einstellungen zurücksetzen',
++-	'EXTMGRPLUS_DEFAULTS_EXP'				=> 'Setzt alle Einstellungen auf den Installationsstandard zurück. Hat keine Auswirkung auf die Spalten von „Eigenschaften der Erweiterungen“.',
+++	'EXTMGRPLUS_DEFAULTS_EXP'				=> 'Setzt alle Einstellungen auf den Installationsstandard zurück. (Hat keine Auswirkung auf die Spalten von „Eigenschaften der Erweiterungen“.)',
++ 	'EXTMGRPLUS_BUTTON_DEFAULTS'			=> 'Standard',
++ 
++ 	// messages
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/language/de_x_sie/acp_ext_mgr_plus.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/language/de_x_sie/acp_ext_mgr_plus.php"
++index 1dd219f66..40a173558 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/language/de_x_sie/acp_ext_mgr_plus.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/language/de_x_sie/acp_ext_mgr_plus.php"
++@@ -45,11 +45,11 @@ $lang = array_merge($lang, [
++ 	'EXTMGRPLUS_COL_WITH_VERSIONCHECK'		=> 'Mit Versionsprüfung',
++ 	'EXTMGRPLUS_COL_LAST_VERSIONCHECK'		=> 'Letzte Versionsprüfung',
++ 	'EXTMGRPLUS_COL_AVAILABLE_UPDATES'		=> 'Verfügbare Updates',
++-	'EXTMGRPLUS_AVAILABLE_EXTENSIONS'		=> [
+++	'EXTMGRPLUS_AVAILABLE_EXTENSIONS' => [
++ 		0									=> '%2$u',
++ 		1									=> '%2$u (%1$u ungültige)',
++ 	],
++-	'EXTMGRPLUS_VERSIONCHECK_DATE'			=> [
+++	'EXTMGRPLUS_VERSIONCHECK_DATE' => [
++ 		0									=> '%2$s (%3$u Sek.)',
++ 		1									=> '%2$s (%3$u Sek. / %1$u Fehler)',
++ 	],
++@@ -66,6 +66,7 @@ $lang = array_merge($lang, [
++ 	'EXTMGRPLUS_DEPENDENCY_EXPLAIN'			=> 'Mit einem vorangestelltem <code>+</code> kann eine Erweiterung mit einer Gruppe verknüpft werden. Hat man zum Beispiel die Erweiterung B die von Erweiterung A abhängig ist, kann man bei A <code>0</code> eintragen und bei B <code>+0</code>. Sind beide Erweiterungen aktiviert, wird beim Auswählen von A auch B ausgewählt. Sind beide Erweiterungen deaktiviert, wird beim Auswählen von B auch A ausgewählt.',
++ 	'EXTMGRPLUS_IGNORE'						=> '%s Ignorieren',
++ 	'EXTMGRPLUS_IGNORE_EXPLAIN'				=> 'In dieser Spalte können Sie festlegen, welche Erweiterungen bei den Aktionen „Ausgewählte aktivieren“ und „Ausgewählte deaktivieren“ ignoriert werden sollen. Ignorierte Erweiterungen können in der Erweiterungen-Liste nicht mehr ausgewählt werden und bei solchen Erweiterungen werden auch keine neuen Migrationen ermittelt und angezeigt. Wenn bei einer ignorierten Erweiterung eine Reihenfolge-Gruppe definiert wurde, dann bleibt diese erhalten, sie hat jedoch keine Bedeutung mehr.',
+++	'EXTMGRPLUS_DETAILS_VERSION_URL'		=> 'Link zur Versionsdatei',
++ 
++ 	// ext manager
++ 	'EXTMGRPLUS_COL_CDB'					=> 'Validierte Erweiterung',
++@@ -89,22 +90,20 @@ $lang = array_merge($lang, [
++ 	'EXTMGRPLUS_TOOLTIP_SELECT'				=> 'Erweiterung auswählen.',
++ 	'EXTMGRPLUS_TOOLTIP_IS_LOCKED'			=> 'Die Auswahl dieser Erweiterung ist wegen neuer Migrationen gesperrt.',
++ 	// tooltips icons
++-	'EXTMGRPLUS_TOOLTIP_CDB_EXT'			=> 'Das ist eine validierte Erweiterung.',
++-	'EXTMGRPLUS_TOOLTIP_CDB_EXT_OFFICIAL'	=> 'Das ist eine offizielle Erweiterung von phpBB.com.',
+++	'EXTMGRPLUS_TOOLTIP_CDB_EXT'			=> 'Diese Erweiterung wurde offiziell validiert.',
++ 	'EXTMGRPLUS_TOOLTIP_OUTDATED'			=> 'Die installierte Version dieser Erweiterung ist veraltet.',
++ 	'EXTMGRPLUS_TOOLTIP_VERSIONCHECK_ERROR'	=> 'Bei der Versionsprüfung ist ein Fehler aufgetreten. Klicken Sie auf „Details“ um mehr zu erfahren.',
++ 	'EXTMGRPLUS_TOOLTIP_VERSIONCHECK_EMPTY'	=> 'Bei dieser Erweiterung wurde keine Versionsprüfung ausgeführt.',
++ 	'EXTMGRPLUS_TOOLTIP_NO_VERSIONCHECK'	=> 'Diese Erweiterung bietet keine Versionsprüfung.',
++ 	'EXTMGRPLUS_TOOLTIP_IS_IGNORED'			=> 'Diese Erweiterung wird von „Extension Manager Plus“ ignoriert.',
++-	'EXTMGRPLUS_TOOLTIP_SETTINGS'			=> 'Das primäre Einstellungsmodul dieser Erweiterung aufrufen.',
++ 
++ 	// misc
++-	'EXTMGRPLUS_EXTENSION_PLURAL'			=> [
+++	'EXTMGRPLUS_EXTENSION_PLURAL' => [
++ 		0									=> '0 Erweiterungen',
++ 		1									=> '1 Erweiterung',
++ 		2									=> '%u Erweiterungen',
++ 	],
++-	'EXTMGRPLUS_SECOND_PLURAL'				=> [
+++	'EXTMGRPLUS_SECOND_PLURAL' => [
++ 		0									=> '0 Sekunden',
++ 		1									=> '1 Sekunde',
++ 		2									=> '%u Sekunden',
++@@ -112,8 +111,8 @@ $lang = array_merge($lang, [
++ 	'EXTMGRPLUS_SPOILER_LABEL'				=> 'Erklärung',
++ 
++ 	// details
+++	'EXTMGRPLUS_SECTION_DETAILS'			=> 'Informationen von Extension Manager Plus',
++ 	'EXTMGRPLUS_DETAILS_CDB_PAGE'			=> 'Seite der phpBB-Erweiterungsdatenbank',
++-	'EXTMGRPLUS_DETAILS_VERSION_URL'		=> 'Link zur Versionsdatei',
++ 
++ 	// messages
++ 	'EXTMGRPLUS_MSG_CONFIRM_DISABLE'		=> 'Sind Sie sich sicher, dass Sie %s deaktivieren möchten?',
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/language/de_x_sie/acp_ext_mgr_plus_lang_author.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/language/de_x_sie/acp_ext_mgr_plus_lang_author.php"
++index 5268bebf0..bfe96ffad 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/language/de_x_sie/acp_ext_mgr_plus_lang_author.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/language/de_x_sie/acp_ext_mgr_plus_lang_author.php"
++@@ -42,7 +42,7 @@ if (empty($lang) || !is_array($lang))
++ $lang = array_merge($lang, [
++ 	// language pack author
++ 	'EXTMGRPLUS_LANG_DESC'					=> 'Deutsch (Sie)',
++-	'EXTMGRPLUS_LANG_VER'	 				=> '3.1.0',
+++	'EXTMGRPLUS_LANG_VER'	 				=> '3.0.0',
++ 	'EXTMGRPLUS_LANG_AUTHOR'	 			=> 'LukeWCS',
++ 
++ 	// messages
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/language/de_x_sie/acp_ext_mgr_plus_settings.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/language/de_x_sie/acp_ext_mgr_plus_settings.php"
++index 5ac4aeaad..65c31075a 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/language/de_x_sie/acp_ext_mgr_plus_settings.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/language/de_x_sie/acp_ext_mgr_plus_settings.php"
++@@ -55,10 +55,10 @@ $lang = array_merge($lang, [
++ 	'EXTMGRPLUS_CHECKBOX_MODE_LAST'			=> 'Letzten Zustand merken',
++ 	'EXTMGRPLUS_SELF_DISABLE'				=> 'Erlaube Eigendeaktivierung',
++ 	'EXTMGRPLUS_SELF_DISABLE_EXPLAIN'		=> 'Wenn Sie diese Option aktivieren, dann kann sich „Extension Manager Plus“ bei der Aktion „Ausgewählte deaktivieren“ auch selbst deaktivieren, da diese Erweiterung dann wie jede andere ausgewählt werden kann.',
+++	'EXTMGRPLUS_INSTRUCTIONS'				=> 'Anleitungen anzeigen',
+++	'EXTMGRPLUS_INSTRUCTIONS_EXPLAIN'		=> 'Mit dieser Option können Sie festlegen, ob die Anleitungen für Installieren, Aktualisieren und Deinstallieren am Ende der Erweiterungen-Liste angezeigt werden sollen.',
++ 	'EXTMGRPLUS_VC_LIMIT'					=> 'Ausführungszeit der Versionsprüfung aufteilen',
++ 	'EXTMGRPLUS_VC_LIMIT_EXPLAIN'			=> 'Die Versionsprüfung wird blockweise ausgeführt und mit diesem Wert können Sie festlegen, wie lange ein einzelner Block der Versionsprüfung maximal dauern darf. Damit wird verhindert, dass Zeitlimits von PHP oder der Datenbank überschritten werden.',
++-	'EXTMGRPLUS_SETTING_LINKS'				=> 'Link zu den Einstellungen erzeugen',
++-	'EXTMGRPLUS_SETTING_LINKS_EXPLAIN'		=> 'Mit dieser Option können Sie festlegen, ob in der Spalte „Vorgänge“ ein Link zum primären Einstellungsmodul (sofern vorhanden) der jeweiligen Erweiterung eingefügt werden soll.',
++ 
++ 	// settings extension properties
++ 	'EXTMGRPLUS_SECTION_EXT_PROPERTIES'		=> 'Eigenschaften der Erweiterungen',
++@@ -67,9 +67,7 @@ $lang = array_merge($lang, [
++ 
++ 	// settings expert
++ 	'EXTMGRPLUS_SECTION_EXPERT_SETTINGS'	=> 'Experten-Einstellungen',
++-	'EXTMGRPLUS_EXPERT_SETTINGS_EXPLAIN'	=> 'Dieser Abschnitt ist unter anderem für Entwickler gedacht; hier können besondere Funktionen und Eigenschaften gesteuert werden. Bei Funktionen die problematisch sein können, muss eine Rückfrage bestätigt werden.',
++-	'EXTMGRPLUS_INSTRUCTIONS'				=> 'Anleitungen anzeigen',
++-	'EXTMGRPLUS_INSTRUCTIONS_EXPLAIN'		=> 'Mit dieser Option können Sie festlegen, ob die Anleitungen für Installieren, Aktualisieren und Deinstallieren am Ende der Erweiterungen-Liste angezeigt werden sollen.',
+++	'EXTMGRPLUS_EXPERT_SETTINGS_EXPLAIN'	=> 'In diesem Abschnitt können besondere Funktionen aktiviert werden, die zum Beispiel für Entwickler relevant sind. Bei Funktionen die problematisch sein können, muss eine Rückfrage bestätigt werden.',
++ 	'EXTMGRPLUS_MIGRATION_COL'				=> 'Spalte mit neuen Migrationen anzeigen',
++ 	'EXTMGRPLUS_MIGRATION_COL_EXPLAIN'		=> 'Wenn diese Option aktiviert ist, dann wird eine zusätzliche Spalte angezeigt, in der die Anzahl neuer Migrationen aufgeführt ist. Die Anzahl wird sowohl bei „Deaktivierte Erweiterungen“ als auch bei „Nicht installierte Erweiterungen“ angezeigt.',
++ 	'EXTMGRPLUS_MIGRATIONS'					=> 'Erlaube Erweiterungen mit neuen Migrationen',
++@@ -80,7 +78,7 @@ $lang = array_merge($lang, [
++ 	// settings reset
++ 	'EXTMGRPLUS_SECTION_RESET'				=> 'Zurücksetzen',
++ 	'EXTMGRPLUS_DEFAULTS'					=> 'Einstellungen zurücksetzen',
++-	'EXTMGRPLUS_DEFAULTS_EXP'				=> 'Setzt alle Einstellungen auf den Installationsstandard zurück. Hat keine Auswirkung auf die Spalten von „Eigenschaften der Erweiterungen“.',
+++	'EXTMGRPLUS_DEFAULTS_EXP'				=> 'Setzt alle Einstellungen auf den Installationsstandard zurück. (Hat keine Auswirkung auf die Spalten von „Eigenschaften der Erweiterungen“.)',
++ 	'EXTMGRPLUS_BUTTON_DEFAULTS'			=> 'Standard',
++ 
++ 	// messages
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/language/en/acp_ext_mgr_plus.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/language/en/acp_ext_mgr_plus.php"
++index 3a7b5da69..513e32034 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/language/en/acp_ext_mgr_plus.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/language/en/acp_ext_mgr_plus.php"
++@@ -45,11 +45,11 @@ $lang = array_merge($lang, [
++ 	'EXTMGRPLUS_COL_WITH_VERSIONCHECK'		=> 'With version checking',
++ 	'EXTMGRPLUS_COL_LAST_VERSIONCHECK'		=> 'Last version check',
++ 	'EXTMGRPLUS_COL_AVAILABLE_UPDATES'		=> 'Available updates',
++-	'EXTMGRPLUS_AVAILABLE_EXTENSIONS'		=> [
+++	'EXTMGRPLUS_AVAILABLE_EXTENSIONS' => [
++ 		0									=> '%2$u',
++ 		1									=> '%2$u (%1$u invalid)',
++ 	],
++-	'EXTMGRPLUS_VERSIONCHECK_DATE'			=> [
+++	'EXTMGRPLUS_VERSIONCHECK_DATE' => [
++ 		0									=> '%2$s (%3$u sec.)',
++ 		1									=> '%2$s (%3$u sec. / %1$u error)',
++ 		2									=> '%2$s (%3$u sec. / %1$u errors)',
++@@ -90,22 +90,20 @@ $lang = array_merge($lang, [
++ 	'EXTMGRPLUS_TOOLTIP_SELECT'				=> 'Select extension.',
++ 	'EXTMGRPLUS_TOOLTIP_IS_LOCKED'			=> 'The selection of this extension is blocked due to new migrations.',
++ 	// tooltips icons
++-	'EXTMGRPLUS_TOOLTIP_CDB_EXT'			=> 'This is a validated extension.',
++-	'EXTMGRPLUS_TOOLTIP_CDB_EXT_OFFICIAL'	=> 'This is an official extension from phpBB.com.',
+++	'EXTMGRPLUS_TOOLTIP_CDB_EXT'			=> 'This extension has been officially validated.',
++ 	'EXTMGRPLUS_TOOLTIP_OUTDATED'			=> 'The installed version of this extension is out of date.',
++ 	'EXTMGRPLUS_TOOLTIP_VERSIONCHECK_ERROR'	=> 'An error occurred during the version check. Click on “Details” to find out more.',
++ 	'EXTMGRPLUS_TOOLTIP_VERSIONCHECK_EMPTY'	=> 'No version check was performed for this extension.',
++ 	'EXTMGRPLUS_TOOLTIP_NO_VERSIONCHECK'	=> 'This extension does not provide version checking.',
++ 	'EXTMGRPLUS_TOOLTIP_IS_IGNORED'			=> 'This extension is ignored by “Extension Manager Plus”.',
++-	'EXTMGRPLUS_TOOLTIP_SETTINGS'			=> 'Call the primary settings module of this extension.',
++ 
++ 	// misc
++-	'EXTMGRPLUS_EXTENSION_PLURAL'			=> [
+++	'EXTMGRPLUS_EXTENSION_PLURAL' => [
++ 		0									=> '0 extensions',
++ 		1									=> '1 extension',
++ 		2									=> '%u extensions',
++ 	],
++-	'EXTMGRPLUS_SECOND_PLURAL'				=> [
+++	'EXTMGRPLUS_SECOND_PLURAL' => [
++ 		0									=> '0 seconds',
++ 		1									=> '1 second',
++ 		2									=> '%u seconds',
++@@ -113,6 +111,7 @@ $lang = array_merge($lang, [
++ 	'EXTMGRPLUS_SPOILER_LABEL'				=> 'Explanation',
++ 
++ 	// details
+++	'EXTMGRPLUS_SECTION_DETAILS'			=> 'Information from Extension Manager Plus',
++ 	'EXTMGRPLUS_DETAILS_CDB_PAGE'			=> 'phpBB extension database page',
++ 	'EXTMGRPLUS_DETAILS_VERSION_URL'		=> 'Link to version file',
++ 
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/language/en/acp_ext_mgr_plus_lang_author.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/language/en/acp_ext_mgr_plus_lang_author.php"
++index fcc65c224..fbb6de3a6 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/language/en/acp_ext_mgr_plus_lang_author.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/language/en/acp_ext_mgr_plus_lang_author.php"
++@@ -42,7 +42,7 @@ if (empty($lang) || !is_array($lang))
++ $lang = array_merge($lang, [
++ 	// language pack author
++ 	'EXTMGRPLUS_LANG_DESC'					=> 'English',
++-	'EXTMGRPLUS_LANG_VER' 					=> '3.1.0',
+++	'EXTMGRPLUS_LANG_VER' 					=> '3.0.0',
++ 	'EXTMGRPLUS_LANG_AUTHOR'	 			=> 'LukeWCS',
++ 
++ 	// messages
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/language/en/acp_ext_mgr_plus_settings.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/language/en/acp_ext_mgr_plus_settings.php"
++index f7e93fa87..55b6e2b65 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lukewcs\\extmgrplus/language/en/acp_ext_mgr_plus_settings.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lukewcs\\extmgrplus/language/en/acp_ext_mgr_plus_settings.php"
++@@ -55,10 +55,10 @@ $lang = array_merge($lang, [
++ 	'EXTMGRPLUS_CHECKBOX_MODE_LAST'			=> 'Remember last state',
++ 	'EXTMGRPLUS_SELF_DISABLE'				=> 'Allow self-deactivation',
++ 	'EXTMGRPLUS_SELF_DISABLE_EXPLAIN'		=> 'If you enable this option, then “Extension Manager Plus” can also deactivate itself in the “Disable selected” action, since this extension can then be selected like any other.',
+++	'EXTMGRPLUS_INSTRUCTIONS'				=> 'View instructions',
+++	'EXTMGRPLUS_INSTRUCTIONS_EXPLAIN'		=> 'This option allows you to choose whether to display the install, update, and uninstall instructions at the end of the extensions list.',
++ 	'EXTMGRPLUS_VC_LIMIT'					=> 'Divide execution time of the version check',
++ 	'EXTMGRPLUS_VC_LIMIT_EXPLAIN'			=> 'The version check is executed in blocks and with this value you can specify the maximum length of a single block of the version check. This prevents PHP or database time limits from being exceeded.',
++-	'EXTMGRPLUS_SETTING_LINKS'				=> 'Create a link to the settings',
++-	'EXTMGRPLUS_SETTING_LINKS_EXPLAIN'		=> 'With this option you can specify whether a link to the primary settings module (if available) of the respective extension should be inserted in the “Actions” column.',
++ 
++ 
\ No newline at end of file
diff --git "[ORIGINAL]/lukewcs\\extmgrplus/event/listener.php" "[FORUM_EXT]/lukewcs\\extmgrplus/event/listener.php"
--- "[ORIGINAL]/lukewcs\\extmgrplus/event/listener.php"
+++ "[FORUM_EXT]/lukewcs\\extmgrplus/event/listener.php"
@@ -18,9 +18,10 @@ use Symfony\Component\EventDispatcher\EventSubscriberInterface;
 class listener implements EventSubscriberInterface
 {
 	public function __construct(
-		protected \lukewcs\extmgrplus\core\ext_mgr_plus $extmgrplus,
+		\lukewcs\extmgrplus\core\ext_mgr_plus $extmgrplus
 	)
 	{
+		$this->extmgrplus = $extmgrplus;
 	}
 
 	public static function getSubscribedEvents(): array
@@ -32,12 +33,12 @@ class listener implements EventSubscriberInterface
 		];
 	}
 
-	public function ext_manager_before(object $event): void
+	public function ext_manager_before($event): void
 	{
 		$this->extmgrplus->ext_manager_before($event);
 	}
 
-	public function ext_manager_after(object $event): void
+	public function ext_manager_after($event): void
 	{
 		$this->extmgrplus->ext_manager_after($event);
 	}
diff --git "[ORIGINAL]/lukewcs\\extmgrplus/ext.php" "[FORUM_EXT]/lukewcs\\extmgrplus/ext.php"
--- "[ORIGINAL]/lukewcs\\extmgrplus/ext.php"
+++ "[FORUM_EXT]/lukewcs\\extmgrplus/ext.php"
@@ -18,7 +18,7 @@ class ext extends \phpbb\extension\base
 	public function is_enableable()
 	{
 		$valid_phpbb = phpbb_version_compare(PHPBB_VERSION, '3.3.8', '>=') && phpbb_version_compare(PHPBB_VERSION, '3.4.0-dev', '<');
-		$valid_php = phpbb_version_compare(PHP_VERSION, '8.0.0', '>=') && phpbb_version_compare(PHP_VERSION, '8.5.0-dev', '<');
+		$valid_php = phpbb_version_compare(PHP_VERSION, '7.4.0', '>=') && phpbb_version_compare(PHP_VERSION, '8.5.0-dev', '<');
 
 		return ($valid_phpbb && $valid_php);
 	}
diff --git "[ORIGINAL]/lukewcs\\extmgrplus/language/de/acp_ext_mgr_plus.php" "[FORUM_EXT]/lukewcs\\extmgrplus/language/de/acp_ext_mgr_plus.php"
--- "[ORIGINAL]/lukewcs\\extmgrplus/language/de/acp_ext_mgr_plus.php"
+++ "[FORUM_EXT]/lukewcs\\extmgrplus/language/de/acp_ext_mgr_plus.php"
@@ -89,14 +89,12 @@ $lang = array_merge($lang, [
 	'EXTMGRPLUS_TOOLTIP_SELECT'				=> 'Erweiterung auswählen.',
 	'EXTMGRPLUS_TOOLTIP_IS_LOCKED'			=> 'Die Auswahl dieser Erweiterung ist wegen neuer Migrationen gesperrt.',
 	// tooltips icons
-	'EXTMGRPLUS_TOOLTIP_CDB_EXT'			=> 'Das ist eine validierte Erweiterung.',
-	'EXTMGRPLUS_TOOLTIP_CDB_EXT_OFFICIAL'	=> 'Das ist eine offizielle Erweiterung von phpBB.com.',
+	'EXTMGRPLUS_TOOLTIP_CDB_EXT'			=> 'Diese Erweiterung wurde offiziell validiert.',
 	'EXTMGRPLUS_TOOLTIP_OUTDATED'			=> 'Die installierte Version dieser Erweiterung ist veraltet.',
 	'EXTMGRPLUS_TOOLTIP_VERSIONCHECK_ERROR'	=> 'Bei der Versionsprüfung ist ein Fehler aufgetreten. Klicke auf „Details“ um mehr zu erfahren.',
 	'EXTMGRPLUS_TOOLTIP_VERSIONCHECK_EMPTY'	=> 'Bei dieser Erweiterung wurde keine Versionsprüfung ausgeführt.',
 	'EXTMGRPLUS_TOOLTIP_NO_VERSIONCHECK'	=> 'Diese Erweiterung bietet keine Versionsprüfung.',
 	'EXTMGRPLUS_TOOLTIP_IS_IGNORED'			=> 'Diese Erweiterung wird von „Extension Manager Plus“ ignoriert.',
-	'EXTMGRPLUS_TOOLTIP_SETTINGS'			=> 'Das primäre Einstellungsmodul dieser Erweiterung aufrufen.',
 
 	// misc
 	'EXTMGRPLUS_EXTENSION_PLURAL' => [
@@ -112,6 +110,7 @@ $lang = array_merge($lang, [
 	'EXTMGRPLUS_SPOILER_LABEL'				=> 'Erklärung',
 
 	// details
+	'EXTMGRPLUS_SECTION_DETAILS'			=> 'Informationen von Extension Manager Plus',
 	'EXTMGRPLUS_DETAILS_CDB_PAGE'			=> 'Seite der phpBB-Erweiterungsdatenbank',
 	'EXTMGRPLUS_DETAILS_VERSION_URL'		=> 'Link zur Versionsdatei',
 
diff --git "[ORIGINAL]/lukewcs\\extmgrplus/language/de/acp_ext_mgr_plus_lang_author.php" "[FORUM_EXT]/lukewcs\\extmgrplus/language/de/acp_ext_mgr_plus_lang_author.php"
--- "[ORIGINAL]/lukewcs\\extmgrplus/language/de/acp_ext_mgr_plus_lang_author.php"
+++ "[FORUM_EXT]/lukewcs\\extmgrplus/language/de/acp_ext_mgr_plus_lang_author.php"
@@ -42,7 +42,7 @@ if (empty($lang) || !is_array($lang))
 $lang = array_merge($lang, [
 	// language pack author
 	'EXTMGRPLUS_LANG_DESC'					=> 'Deutsch (Du)',
-	'EXTMGRPLUS_LANG_VER' 					=> '3.1.0',
+	'EXTMGRPLUS_LANG_VER' 					=> '3.0.0',
 	'EXTMGRPLUS_LANG_AUTHOR'				=> 'LukeWCS',
 
 	// messages
diff --git "[ORIGINAL]/lukewcs\\extmgrplus/language/de/acp_ext_mgr_plus_settings.php" "[FORUM_EXT]/lukewcs\\extmgrplus/language/de/acp_ext_mgr_plus_settings.php"
--- "[ORIGINAL]/lukewcs\\extmgrplus/language/de/acp_ext_mgr_plus_settings.php"
+++ "[FORUM_EXT]/lukewcs\\extmgrplus/language/de/acp_ext_mgr_plus_settings.php"
@@ -55,10 +55,10 @@ $lang = array_merge($lang, [
 	'EXTMGRPLUS_CHECKBOX_MODE_LAST'			=> 'Letzten Zustand merken',
 	'EXTMGRPLUS_SELF_DISABLE'				=> 'Erlaube Eigendeaktivierung',
 	'EXTMGRPLUS_SELF_DISABLE_EXPLAIN'		=> 'Wenn du diese Option aktivierst, dann kann sich „Extension Manager Plus“ bei der Aktion „Ausgewählte deaktivieren“ auch selbst deaktivieren, da diese Erweiterung dann wie jede andere ausgewählt werden kann.',
+	'EXTMGRPLUS_INSTRUCTIONS'				=> 'Anleitungen anzeigen',
+	'EXTMGRPLUS_INSTRUCTIONS_EXPLAIN'		=> 'Mit dieser Option kannst du festlegen, ob die Anleitungen für Installieren, Aktualisieren und Deinstallieren am Ende der Erweiterungen-Liste angezeigt werden sollen.',
 	'EXTMGRPLUS_VC_LIMIT'					=> 'Ausführungszeit der Versionsprüfung aufteilen',
 	'EXTMGRPLUS_VC_LIMIT_EXPLAIN'			=> 'Die Versionsprüfung wird blockweise ausgeführt und mit diesem Wert kannst du festlegen, wie lange ein einzelner Block der Versionsprüfung maximal dauern darf. Damit wird verhindert, dass Zeitlimits von PHP oder der Datenbank überschritten werden.',
-	'EXTMGRPLUS_SETTING_LINKS'				=> 'Link zu den Einstellungen erzeugen',
-	'EXTMGRPLUS_SETTING_LINKS_EXPLAIN'		=> 'Mit dieser Option kannst du festlegen, ob in der Spalte „Vorgänge“ ein Link zum primären Einstellungsmodul (sofern vorhanden) der jeweiligen Erweiterung eingefügt werden soll.',
 
 	// settings extension properties
 	'EXTMGRPLUS_SECTION_EXT_PROPERTIES'		=> 'Eigenschaften der Erweiterungen',
@@ -67,9 +67,7 @@ $lang = array_merge($lang, [
 
 	// settings expert
 	'EXTMGRPLUS_SECTION_EXPERT_SETTINGS'	=> 'Experten-Einstellungen',
-	'EXTMGRPLUS_EXPERT_SETTINGS_EXPLAIN'	=> 'Dieser Abschnitt ist unter anderem für Entwickler gedacht; hier können besondere Funktionen und Eigenschaften gesteuert werden. Bei Funktionen die problematisch sein können, muss eine Rückfrage bestätigt werden.',
-	'EXTMGRPLUS_INSTRUCTIONS'				=> 'Anleitungen anzeigen',
-	'EXTMGRPLUS_INSTRUCTIONS_EXPLAIN'		=> 'Mit dieser Option kannst du festlegen, ob die Anleitungen für Installieren, Aktualisieren und Deinstallieren am Ende der Erweiterungen-Liste angezeigt werden sollen.',
+	'EXTMGRPLUS_EXPERT_SETTINGS_EXPLAIN'	=> 'In diesem Abschnitt können besondere Funktionen aktiviert werden, die zum Beispiel für Entwickler relevant sind. Bei Funktionen die problematisch sein können, muss eine Rückfrage bestätigt werden.',
 	'EXTMGRPLUS_MIGRATION_COL'				=> 'Spalte mit neuen Migrationen anzeigen',
 	'EXTMGRPLUS_MIGRATION_COL_EXPLAIN'		=> 'Wenn diese Option aktiviert ist, dann wird eine zusätzliche Spalte angezeigt, in der die Anzahl neuer Migrationen aufgeführt ist. Die Anzahl wird sowohl bei „Deaktivierte Erweiterungen“ als auch bei „Nicht installierte Erweiterungen“ angezeigt.',
 	'EXTMGRPLUS_MIGRATIONS'					=> 'Erlaube Erweiterungen mit neuen Migrationen',
@@ -80,7 +78,7 @@ $lang = array_merge($lang, [
 	// settings reset
 	'EXTMGRPLUS_SECTION_RESET'				=> 'Zurücksetzen',
 	'EXTMGRPLUS_DEFAULTS'					=> 'Einstellungen zurücksetzen',
-	'EXTMGRPLUS_DEFAULTS_EXP'				=> 'Setzt alle Einstellungen auf den Installationsstandard zurück. Hat keine Auswirkung auf die Spalten von „Eigenschaften der Erweiterungen“.',
+	'EXTMGRPLUS_DEFAULTS_EXP'				=> 'Setzt alle Einstellungen auf den Installationsstandard zurück. (Hat keine Auswirkung auf die Spalten von „Eigenschaften der Erweiterungen“.)',
 	'EXTMGRPLUS_BUTTON_DEFAULTS'			=> 'Standard',
 
 	// messages
diff --git "[ORIGINAL]/lukewcs\\extmgrplus/language/de_x_sie/acp_ext_mgr_plus.php" "[FORUM_EXT]/lukewcs\\extmgrplus/language/de_x_sie/acp_ext_mgr_plus.php"
--- "[ORIGINAL]/lukewcs\\extmgrplus/language/de_x_sie/acp_ext_mgr_plus.php"
+++ "[FORUM_EXT]/lukewcs\\extmgrplus/language/de_x_sie/acp_ext_mgr_plus.php"
@@ -66,6 +66,7 @@ $lang = array_merge($lang, [
 	'EXTMGRPLUS_DEPENDENCY_EXPLAIN'			=> 'Mit einem vorangestelltem <code>+</code> kann eine Erweiterung mit einer Gruppe verknüpft werden. Hat man zum Beispiel die Erweiterung B die von Erweiterung A abhängig ist, kann man bei A <code>0</code> eintragen und bei B <code>+0</code>. Sind beide Erweiterungen aktiviert, wird beim Auswählen von A auch B ausgewählt. Sind beide Erweiterungen deaktiviert, wird beim Auswählen von B auch A ausgewählt.',
 	'EXTMGRPLUS_IGNORE'						=> '%s Ignorieren',
 	'EXTMGRPLUS_IGNORE_EXPLAIN'				=> 'In dieser Spalte können Sie festlegen, welche Erweiterungen bei den Aktionen „Ausgewählte aktivieren“ und „Ausgewählte deaktivieren“ ignoriert werden sollen. Ignorierte Erweiterungen können in der Erweiterungen-Liste nicht mehr ausgewählt werden und bei solchen Erweiterungen werden auch keine neuen Migrationen ermittelt und angezeigt. Wenn bei einer ignorierten Erweiterung eine Reihenfolge-Gruppe definiert wurde, dann bleibt diese erhalten, sie hat jedoch keine Bedeutung mehr.',
+	'EXTMGRPLUS_DETAILS_VERSION_URL'		=> 'Link zur Versionsdatei',
 
 	// ext manager
 	'EXTMGRPLUS_COL_CDB'					=> 'Validierte Erweiterung',
@@ -89,14 +90,12 @@ $lang = array_merge($lang, [
 	'EXTMGRPLUS_TOOLTIP_SELECT'				=> 'Erweiterung auswählen.',
 	'EXTMGRPLUS_TOOLTIP_IS_LOCKED'			=> 'Die Auswahl dieser Erweiterung ist wegen neuer Migrationen gesperrt.',
 	// tooltips icons
-	'EXTMGRPLUS_TOOLTIP_CDB_EXT'			=> 'Das ist eine validierte Erweiterung.',
-	'EXTMGRPLUS_TOOLTIP_CDB_EXT_OFFICIAL'	=> 'Das ist eine offizielle Erweiterung von phpBB.com.',
+	'EXTMGRPLUS_TOOLTIP_CDB_EXT'			=> 'Diese Erweiterung wurde offiziell validiert.',
 	'EXTMGRPLUS_TOOLTIP_OUTDATED'			=> 'Die installierte Version dieser Erweiterung ist veraltet.',
 	'EXTMGRPLUS_TOOLTIP_VERSIONCHECK_ERROR'	=> 'Bei der Versionsprüfung ist ein Fehler aufgetreten. Klicken Sie auf „Details“ um mehr zu erfahren.',
 	'EXTMGRPLUS_TOOLTIP_VERSIONCHECK_EMPTY'	=> 'Bei dieser Erweiterung wurde keine Versionsprüfung ausgeführt.',
 	'EXTMGRPLUS_TOOLTIP_NO_VERSIONCHECK'	=> 'Diese Erweiterung bietet keine Versionsprüfung.',
 	'EXTMGRPLUS_TOOLTIP_IS_IGNORED'			=> 'Diese Erweiterung wird von „Extension Manager Plus“ ignoriert.',
-	'EXTMGRPLUS_TOOLTIP_SETTINGS'			=> 'Das primäre Einstellungsmodul dieser Erweiterung aufrufen.',
 
 	// misc
 	'EXTMGRPLUS_EXTENSION_PLURAL' => [
@@ -112,8 +111,8 @@ $lang = array_merge($lang, [
 	'EXTMGRPLUS_SPOILER_LABEL'				=> 'Erklärung',
 
 	// details
+	'EXTMGRPLUS_SECTION_DETAILS'			=> 'Informationen von Extension Manager Plus',
 	'EXTMGRPLUS_DETAILS_CDB_PAGE'			=> 'Seite der phpBB-Erweiterungsdatenbank',
-	'EXTMGRPLUS_DETAILS_VERSION_URL'		=> 'Link zur Versionsdatei',
 
 	// messages
 	'EXTMGRPLUS_MSG_CONFIRM_DISABLE'		=> 'Sind Sie sich sicher, dass Sie %s deaktivieren möchten?',
diff --git "[ORIGINAL]/lukewcs\\extmgrplus/language/de_x_sie/acp_ext_mgr_plus_lang_author.php" "[FORUM_EXT]/lukewcs\\extmgrplus/language/de_x_sie/acp_ext_mgr_plus_lang_author.php"
--- "[ORIGINAL]/lukewcs\\extmgrplus/language/de_x_sie/acp_ext_mgr_plus_lang_author.php"
+++ "[FORUM_EXT]/lukewcs\\extmgrplus/language/de_x_sie/acp_ext_mgr_plus_lang_author.php"
@@ -42,7 +42,7 @@ if (empty($lang) || !is_array($lang))
 $lang = array_merge($lang, [
 	// language pack author
 	'EXTMGRPLUS_LANG_DESC'					=> 'Deutsch (Sie)',
-	'EXTMGRPLUS_LANG_VER'	 				=> '3.1.0',
+	'EXTMGRPLUS_LANG_VER'	 				=> '3.0.0',
 	'EXTMGRPLUS_LANG_AUTHOR'	 			=> 'LukeWCS',
 
 	// messages
diff --git "[ORIGINAL]/lukewcs\\extmgrplus/language/de_x_sie/acp_ext_mgr_plus_settings.php" "[FORUM_EXT]/lukewcs\\extmgrplus/language/de_x_sie/acp_ext_mgr_plus_settings.php"
--- "[ORIGINAL]/lukewcs\\extmgrplus/language/de_x_sie/acp_ext_mgr_plus_settings.php"
+++ "[FORUM_EXT]/lukewcs\\extmgrplus/language/de_x_sie/acp_ext_mgr_plus_settings.php"
@@ -55,10 +55,10 @@ $lang = array_merge($lang, [
 	'EXTMGRPLUS_CHECKBOX_MODE_LAST'			=> 'Letzten Zustand merken',
 	'EXTMGRPLUS_SELF_DISABLE'				=> 'Erlaube Eigendeaktivierung',
 	'EXTMGRPLUS_SELF_DISABLE_EXPLAIN'		=> 'Wenn Sie diese Option aktivieren, dann kann sich „Extension Manager Plus“ bei der Aktion „Ausgewählte deaktivieren“ auch selbst deaktivieren, da diese Erweiterung dann wie jede andere ausgewählt werden kann.',
+	'EXTMGRPLUS_INSTRUCTIONS'				=> 'Anleitungen anzeigen',
+	'EXTMGRPLUS_INSTRUCTIONS_EXPLAIN'		=> 'Mit dieser Option können Sie festlegen, ob die Anleitungen für Installieren, Aktualisieren und Deinstallieren am Ende der Erweiterungen-Liste angezeigt werden sollen.',
 	'EXTMGRPLUS_VC_LIMIT'					=> 'Ausführungszeit der Versionsprüfung aufteilen',
 	'EXTMGRPLUS_VC_LIMIT_EXPLAIN'			=> 'Die Versionsprüfung wird blockweise ausgeführt und mit diesem Wert können Sie festlegen, wie lange ein einzelner Block der Versionsprüfung maximal dauern darf. Damit wird verhindert, dass Zeitlimits von PHP oder der Datenbank überschritten werden.',
-	'EXTMGRPLUS_SETTING_LINKS'				=> 'Link zu den Einstellungen erzeugen',
-	'EXTMGRPLUS_SETTING_LINKS_EXPLAIN'		=> 'Mit dieser Option können Sie festlegen, ob in der Spalte „Vorgänge“ ein Link zum primären Einstellungsmodul (sofern vorhanden) der jeweiligen Erweiterung eingefügt werden soll.',
 
 	// settings extension properties
 	'EXTMGRPLUS_SECTION_EXT_PROPERTIES'		=> 'Eigenschaften der Erweiterungen',
@@ -67,9 +67,7 @@ $lang = array_merge($lang, [
 
 	// settings expert
 	'EXTMGRPLUS_SECTION_EXPERT_SETTINGS'	=> 'Experten-Einstellungen',
-	'EXTMGRPLUS_EXPERT_SETTINGS_EXPLAIN'	=> 'Dieser Abschnitt ist unter anderem für Entwickler gedacht; hier können besondere Funktionen und Eigenschaften gesteuert werden. Bei Funktionen die problematisch sein können, muss eine Rückfrage bestätigt werden.',
-	'EXTMGRPLUS_INSTRUCTIONS'				=> 'Anleitungen anzeigen',
-	'EXTMGRPLUS_INSTRUCTIONS_EXPLAIN'		=> 'Mit dieser Option können Sie festlegen, ob die Anleitungen für Installieren, Aktualisieren und Deinstallieren am Ende der Erweiterungen-Liste angezeigt werden sollen.',
+	'EXTMGRPLUS_EXPERT_SETTINGS_EXPLAIN'	=> 'In diesem Abschnitt können besondere Funktionen aktiviert werden, die zum Beispiel für Entwickler relevant sind. Bei Funktionen die problematisch sein können, muss eine Rückfrage bestätigt werden.',
 	'EXTMGRPLUS_MIGRATION_COL'				=> 'Spalte mit neuen Migrationen anzeigen',
 	'EXTMGRPLUS_MIGRATION_COL_EXPLAIN'		=> 'Wenn diese Option aktiviert ist, dann wird eine zusätzliche Spalte angezeigt, in der die Anzahl neuer Migrationen aufgeführt ist. Die Anzahl wird sowohl bei „Deaktivierte Erweiterungen“ als auch bei „Nicht installierte Erweiterungen“ angezeigt.',
 	'EXTMGRPLUS_MIGRATIONS'					=> 'Erlaube Erweiterungen mit neuen Migrationen',
@@ -80,7 +78,7 @@ $lang = array_merge($lang, [
 	// settings reset
 	'EXTMGRPLUS_SECTION_RESET'				=> 'Zurücksetzen',
 	'EXTMGRPLUS_DEFAULTS'					=> 'Einstellungen zurücksetzen',
-	'EXTMGRPLUS_DEFAULTS_EXP'				=> 'Setzt alle Einstellungen auf den Installationsstandard zurück. Hat keine Auswirkung auf die Spalten von „Eigenschaften der Erweiterungen“.',
+	'EXTMGRPLUS_DEFAULTS_EXP'				=> 'Setzt alle Einstellungen auf den Installationsstandard zurück. (Hat keine Auswirkung auf die Spalten von „Eigenschaften der Erweiterungen“.)',
 	'EXTMGRPLUS_BUTTON_DEFAULTS'			=> 'Standard',
 
 	// messages
diff --git "[ORIGINAL]/lukewcs\\extmgrplus/language/en/acp_ext_mgr_plus.php" "[FORUM_EXT]/lukewcs\\extmgrplus/language/en/acp_ext_mgr_plus.php"
--- "[ORIGINAL]/lukewcs\\extmgrplus/language/en/acp_ext_mgr_plus.php"
+++ "[FORUM_EXT]/lukewcs\\extmgrplus/language/en/acp_ext_mgr_plus.php"
@@ -90,14 +90,12 @@ $lang = array_merge($lang, [
 	'EXTMGRPLUS_TOOLTIP_SELECT'				=> 'Select extension.',
 	'EXTMGRPLUS_TOOLTIP_IS_LOCKED'			=> 'The selection of this extension is blocked due to new migrations.',
 	// tooltips icons
-	'EXTMGRPLUS_TOOLTIP_CDB_EXT'			=> 'This is a validated extension.',
-	'EXTMGRPLUS_TOOLTIP_CDB_EXT_OFFICIAL'	=> 'This is an official extension from phpBB.com.',
+	'EXTMGRPLUS_TOOLTIP_CDB_EXT'			=> 'This extension has been officially validated.',
 	'EXTMGRPLUS_TOOLTIP_OUTDATED'			=> 'The installed version of this extension is out of date.',
 	'EXTMGRPLUS_TOOLTIP_VERSIONCHECK_ERROR'	=> 'An error occurred during the version check. Click on “Details” to find out more.',
 	'EXTMGRPLUS_TOOLTIP_VERSIONCHECK_EMPTY'	=> 'No version check was performed for this extension.',
 	'EXTMGRPLUS_TOOLTIP_NO_VERSIONCHECK'	=> 'This extension does not provide version checking.',
 	'EXTMGRPLUS_TOOLTIP_IS_IGNORED'			=> 'This extension is ignored by “Extension Manager Plus”.',
-	'EXTMGRPLUS_TOOLTIP_SETTINGS'			=> 'Call the primary settings module of this extension.',
 
 	// misc
 	'EXTMGRPLUS_EXTENSION_PLURAL' => [
@@ -113,6 +111,7 @@ $lang = array_merge($lang, [
 	'EXTMGRPLUS_SPOILER_LABEL'				=> 'Explanation',
 
 	// details
+	'EXTMGRPLUS_SECTION_DETAILS'			=> 'Information from Extension Manager Plus',
 	'EXTMGRPLUS_DETAILS_CDB_PAGE'			=> 'phpBB extension database page',
 	'EXTMGRPLUS_DETAILS_VERSION_URL'		=> 'Link to version file',
 
diff --git "[ORIGINAL]/lukewcs\\extmgrplus/language/en/acp_ext_mgr_plus_lang_author.php" "[FORUM_EXT]/lukewcs\\extmgrplus/language/en/acp_ext_mgr_plus_lang_author.php"
--- "[ORIGINAL]/lukewcs\\extmgrplus/language/en/acp_ext_mgr_plus_lang_author.php"
+++ "[FORUM_EXT]/lukewcs\\extmgrplus/language/en/acp_ext_mgr_plus_lang_author.php"
@@ -42,7 +42,7 @@ if (empty($lang) || !is_array($lang))
 $lang = array_merge($lang, [
 	// language pack author
 	'EXTMGRPLUS_LANG_DESC'					=> 'English',
-	'EXTMGRPLUS_LANG_VER' 					=> '3.1.0',
+	'EXTMGRPLUS_LANG_VER' 					=> '3.0.0',
 	'EXTMGRPLUS_LANG_AUTHOR'	 			=> 'LukeWCS',
 
 	// messages
diff --git "[ORIGINAL]/lukewcs\\extmgrplus/language/en/acp_ext_mgr_plus_settings.php" "[FORUM_EXT]/lukewcs\\extmgrplus/language/en/acp_ext_mgr_plus_settings.php"
--- "[ORIGINAL]/lukewcs\\extmgrplus/language/en/acp_ext_mgr_plus_settings.php"
+++ "[FORUM_EXT]/lukewcs\\extmgrplus/language/en/acp_ext_mgr_plus_settings.php"
@@ -55,10 +55,10 @@ $lang = array_merge($lang, [
 	'EXTMGRPLUS_CHECKBOX_MODE_LAST'			=> 'Remember last state',
 	'EXTMGRPLUS_SELF_DISABLE'				=> 'Allow self-deactivation',
 	'EXTMGRPLUS_SELF_DISABLE_EXPLAIN'		=> 'If you enable this option, then “Extension Manager Plus” can also deactivate itself in the “Disable selected” action, since this extension can then be selected like any other.',
+	'EXTMGRPLUS_INSTRUCTIONS'				=> 'View instructions',
+	'EXTMGRPLUS_INSTRUCTIONS_EXPLAIN'		=> 'This option allows you to choose whether to display the install, update, and uninstall instructions at the end of the extensions list.',
 	'EXTMGRPLUS_VC_LIMIT'					=> 'Divide execution time of the version check',
 	'EXTMGRPLUS_VC_LIMIT_EXPLAIN'			=> 'The version check is executed in blocks and with this value you can specify the maximum length of a single block of the version check. This prevents PHP or database time limits from being exceeded.',
-	'EXTMGRPLUS_SETTING_LINKS'				=> 'Create a link to the settings',
-	'EXTMGRPLUS_SETTING_LINKS_EXPLAIN'		=> 'With this option you can specify whether a link to the primary settings module (if available) of the respective extension should be inserted in the “Actions” column.',
 
 	// settings extension properties
 	'EXTMGRPLUS_SECTION_EXT_PROPERTIES'		=> 'Extension properties',
@@ -67,9 +67,7 @@ $lang = array_merge($lang, [
 
 	// settings expert
 	'EXTMGRPLUS_SECTION_EXPERT_SETTINGS'	=> 'Expert settings',
-	'EXTMGRPLUS_EXPERT_SETTINGS_EXPLAIN'	=> 'This section is intended, among other things, for developers; special functions and properties can be controlled here. For functions that may be problematic, a confirmation prompt will be required.',
-	'EXTMGRPLUS_INSTRUCTIONS'				=> 'View instructions',
-	'EXTMGRPLUS_INSTRUCTIONS_EXPLAIN'		=> 'This option allows you to choose whether to display the install, update, and uninstall instructions at the end of the extensions list.',
+	'EXTMGRPLUS_EXPERT_SETTINGS_EXPLAIN'	=> 'In this section, special functions can be activated that are relevant for developers, for example. For functions that could be problematic, a query must be confirmed.',
 	'EXTMGRPLUS_MIGRATION_COL'				=> 'Show column with new migrations',
 	'EXTMGRPLUS_MIGRATION_COL_EXPLAIN'		=> 'If this option is enabled, then an additional column is displayed in which the number of new migrations is listed. The number is displayed for both “Disabled Extensions” and “Not installed extensions”.',
 	'EXTMGRPLUS_MIGRATIONS'					=> 'Allow extensions with new migrations',
@@ -80,7 +78,7 @@ $lang = array_merge($lang, [
 	// settings reset
 	'EXTMGRPLUS_SECTION_RESET'				=> 'Reset',
 	'EXTMGRPLUS_DEFAULTS'					=> 'Reset settings',
-	'EXTMGRPLUS_DEFAULTS_EXP'				=> 'Resets all settings to the installation default. Has no effect on the “Extension properties” columns.',
+	'EXTMGRPLUS_DEFAULTS_EXP'				=> 'Resets all settings to the installation default. (Has no effect on the “Extension Properties” columns.)',
 	'EXTMGRPLUS_BUTTON_DEFAULTS'			=> 'Defaults',
 
 	// messages
diff --git "[ORIGINAL]/lukewcs\\extmgrplus/migrations/v_3_1_0.php" "[ORIGINAL]/lukewcs\\extmgrplus/migrations/v_3_1_0.php"
deleted file mode 100644
--- "[ORIGINAL]/lukewcs\\extmgrplus/migrations/v_3_1_0.php"
+++ /dev/null
@@ -1,29 +0,0 @@
-<?php
-/**
-*
-* Extension Manager Plus. An extension for the phpBB Forum Software package.
-*
-* @copyright (c) 2022, LukeWCS, https://www.wcsaga.org
-* @license GNU General Public License, version 2 (GPL-2.0-only)
-*
-* Note: This extension is 100% genuine handcraft and consists of selected
-*       natural raw materials. There was no AI involved in making it.
-*
-*/
-
-namespace lukewcs\extmgrplus\migrations;
-
-class v_3_1_0 extends \phpbb\db\migration\migration
-{
-	public static function depends_on()
-	{
-		return ['\lukewcs\extmgrplus\migrations\v_3_0_0'];
-	}
-
-	public function update_data()
-	{
-		return [
-			['config.add', ['extmgrplus_switch_settings_link', 1]],
-		];
-	}
-}
```
