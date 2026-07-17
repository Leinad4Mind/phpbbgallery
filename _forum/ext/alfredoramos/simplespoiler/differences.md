Existem diferencas reais no codigo ou texto. Diferencas de formatacao (espacos, tabs) foram ignoradas abaixo.

```diff
diff --git "[ORIGINAL]/alfredoramos\\simplespoiler/composer.json" "[FORUM_EXT]/alfredoramos\\simplespoiler/composer.json"
--- "[ORIGINAL]/alfredoramos\\simplespoiler/composer.json"
+++ "[FORUM_EXT]/alfredoramos\\simplespoiler/composer.json"
@@ -5,7 +5,13 @@
     "homepage": "https://github.com/AlfredoRamos/phpbb-ext-simple-spoiler",
     "version": "2.3.2",
     "time": "2020-10-12",
-	"keywords": ["phpbb", "extension", "spoiler", "bbcode", "html5"],
+    "keywords": [
+        "phpbb",
+        "extension",
+        "spoiler",
+        "bbcode",
+        "html5"
+    ],
     "license": "GPL-2.0-only",
     "authors": [
         {
@@ -17,7 +23,8 @@
     ],
     "require": {
         "php": "^7.1.3",
-		"composer/installers": "^1.6.0"
+        "composer/installers": "~1.0.0",
+        "phpbb/phpbb": "~3.3.0"
     },
     "require-dev": {
         "phing/phing": "^2.16.0",
@@ -29,9 +36,9 @@
             "phpbb/phpbb": "~3.3.0"
         },
         "version-check": {
-			"host": "alfredoramos.mx",
-			"directory": "/phpbb-extensions/versions",
-			"filename": "simple-spoiler.json",
+            "host": "www.phpbb.com",
+            "directory": "/customise/db/extension/simple_spoiler_bbcode",
+            "filename": "version_check",
             "ssl": true
         }
     }
diff --git "[FORUM_EXT]/alfredoramos\\simplespoiler/styles/BBOOTS/template/abbc3_spoiler_button.html" "[FORUM_EXT]/alfredoramos\\simplespoiler/styles/BBOOTS/template/abbc3_spoiler_button.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/alfredoramos\\simplespoiler/styles/BBOOTS/template/abbc3_spoiler_button.html"
@@ -0,0 +1 @@
+<button type="button" class="bbcode-spoiler abbc3_button{% if SIMPLE_SPOILER_ABBC3_ICON_TYPE %} icon-type-{{ SIMPLE_SPOILER_ABBC3_ICON_TYPE|lower|striptags|escape }}{% endif %}" name="addspoiler" onclick="bbfontstyle('[spoiler]', '[/spoiler]');" title="{{ lang('SPOILER_HELPLINE')|striptags|escape }}" accesskey="e"></button>
diff --git "[FORUM_EXT]/alfredoramos\\simplespoiler/styles/BBOOTS/template/event/ext_quickreply_editor_buttons_custom_tags_before.html" "[FORUM_EXT]/alfredoramos\\simplespoiler/styles/BBOOTS/template/event/ext_quickreply_editor_buttons_custom_tags_before.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/alfredoramos\\simplespoiler/styles/BBOOTS/template/event/ext_quickreply_editor_buttons_custom_tags_before.html"
@@ -0,0 +1 @@
+{% include '@alfredoramos_simplespoiler/spoiler_button.html' ignore missing %}
diff --git "[FORUM_EXT]/alfredoramos\\simplespoiler/styles/BBOOTS/template/event/overall_footer_body_after.html" "[FORUM_EXT]/alfredoramos\\simplespoiler/styles/BBOOTS/template/event/overall_footer_body_after.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/alfredoramos\\simplespoiler/styles/BBOOTS/template/event/overall_footer_body_after.html"
@@ -0,0 +1,12 @@
+{% if not INCLUDED_DETAILS_POLYFILL_JS %}
+{%- if S_ALLOW_CDN -%}
+{% INCLUDEJS 'https://unpkg.com/details-element-polyfill@2.4.0/dist/details-element-polyfill.js' %}
+{%- else -%}
+{% INCLUDEJS '@alfredoramos_simplespoiler/js/details-element-polyfill.min.js' %}
+{%- endif -%}
+{%- set INCLUDED_DETAILS_POLYFILL_JS = true -%}
+{% endif %}
+{% if not INCLUDED_SPOILER_JS %}
+{% INCLUDEJS '@alfredoramos_simplespoiler/js/spoiler.min.js' %}
+{%- set INCLUDED_SPOILER_JS = true -%}
+{% endif %}
diff --git "[FORUM_EXT]/alfredoramos\\simplespoiler/styles/BBOOTS/template/event/overall_header_head_append.html" "[FORUM_EXT]/alfredoramos\\simplespoiler/styles/BBOOTS/template/event/overall_header_head_append.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/alfredoramos\\simplespoiler/styles/BBOOTS/template/event/overall_header_head_append.html"
@@ -0,0 +1,6 @@
+{% if not INCLUDED_SPOILER_CSS %}
+{% INCLUDECSS '@alfredoramos_simplespoiler/css/common.min.css' %}
+{% INCLUDECSS '@alfredoramos_simplespoiler/css/style.min.css' %}
+{% INCLUDECSS '@alfredoramos_simplespoiler/css/colors.min.css' %}
+{%- set INCLUDED_SPOILER_CSS = true -%}
+{% endif %}
diff --git "[FORUM_EXT]/alfredoramos\\simplespoiler/styles/BBOOTS/template/event/posting_editor_buttons_custom_tags_before.html" "[FORUM_EXT]/alfredoramos\\simplespoiler/styles/BBOOTS/template/event/posting_editor_buttons_custom_tags_before.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/alfredoramos\\simplespoiler/styles/BBOOTS/template/event/posting_editor_buttons_custom_tags_before.html"
@@ -0,0 +1 @@
+{% include '@alfredoramos_simplespoiler/spoiler_button.html' ignore missing %}
diff --git "[FORUM_EXT]/alfredoramos\\simplespoiler/styles/BBOOTS/template/event/vse_abbc3_posting_editor_buttons_custom_tags_before.html" "[FORUM_EXT]/alfredoramos\\simplespoiler/styles/BBOOTS/template/event/vse_abbc3_posting_editor_buttons_custom_tags_before.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/alfredoramos\\simplespoiler/styles/BBOOTS/template/event/vse_abbc3_posting_editor_buttons_custom_tags_before.html"
@@ -0,0 +1 @@
+{% include '@alfredoramos_simplespoiler/abbc3_spoiler_button.html' ignore missing %}
diff --git "[FORUM_EXT]/alfredoramos\\simplespoiler/styles/BBOOTS/template/spoiler.xsl" "[FORUM_EXT]/alfredoramos\\simplespoiler/styles/BBOOTS/template/spoiler.xsl"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/alfredoramos\\simplespoiler/styles/BBOOTS/template/spoiler.xsl"
@@ -0,0 +1,20 @@
+<div class="spoiler">
+	<div class="spoiler-header spoiler-trigger">
+		<div class="spoiler-title">
+			<xsl:choose>
+				<xsl:when test="@spoiler">
+					<xsl:value-of select="@spoiler"/>
+				</xsl:when>
+				<xsl:when test="@title">
+					<xsl:value-of select="@title"/>
+				</xsl:when>
+				<xsl:otherwise>{L_SPOILER}</xsl:otherwise>
+			</xsl:choose>
+		</div>
+		<div class="spoiler-status">
+			<i class="fa fa-eye" aria-hidden="true"></i>
+			<span>{L_SPOILER_SHOW}</span>
+		</div>
+	</div>
+	<div class="spoiler-body">{TEXT1}</div>
+</div>
diff --git "[FORUM_EXT]/alfredoramos\\simplespoiler/styles/BBOOTS/template/spoiler_button.html" "[FORUM_EXT]/alfredoramos\\simplespoiler/styles/BBOOTS/template/spoiler_button.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/alfredoramos\\simplespoiler/styles/BBOOTS/template/spoiler_button.html"
@@ -0,0 +1,3 @@
+<button type="button" class="button button-icon-only bbcode-spoiler" name="addspoiler" value="{{ lang('SPOILER')|striptags|escape }}" onclick="bbfontstyle('[spoiler]', '[/spoiler]');" title="{{ lang('SPOILER_HELPLINE')|striptags|escape }}" accesskey="e">
+	<i class="icon fa fa-fw fa-eye-slash" aria-hidden="true"></i>
+</button>
diff --git "[FORUM_EXT]/alfredoramos\\simplespoiler/styles/BBOOTS/theme/css/colors.min.css" "[FORUM_EXT]/alfredoramos\\simplespoiler/styles/BBOOTS/theme/css/colors.min.css"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/alfredoramos\\simplespoiler/styles/BBOOTS/theme/css/colors.min.css"
@@ -0,0 +1,37 @@
+/**
+ * Simple Spoiler extension for phpBB.
+ * @author Alfredo Ramos <alfredo.ramos@yandex.com>
+ * @copyright 2017 Alfredo Ramos
+ * @license GPL-2.0-only
+ */
+
+.spoiler {
+	background-color: #fff;
+	border-color: #ddd;
+}
+
+.spoiler .spoiler-header {
+	background-color: #f3f3f3;
+	color: #333;
+}
+
+.spoiler .spoiler-header .spoiler-status {
+	background-color: #d9534f;
+	color: #fff;
+}
+
+.spoiler .spoiler-body {
+	border-color: #ddd;
+}
+
+.spoiler-show > .spoiler-header .spoiler-status {
+	background-color: #5cb85c;
+}
+
+.bbcode-spoiler {
+	color: transparent;
+}
+
+.bbcode-spoiler::before {
+	color: #8f8f8f;
+}
diff --git "[FORUM_EXT]/alfredoramos\\simplespoiler/styles/BBOOTS/theme/css/style.min.css" "[FORUM_EXT]/alfredoramos\\simplespoiler/styles/BBOOTS/theme/css/style.min.css"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/alfredoramos\\simplespoiler/styles/BBOOTS/theme/css/style.min.css"
@@ -0,0 +1,35 @@
+/**
+ * Simple Spoiler extension for phpBB.
+ * @author Alfredo Ramos <alfredo.ramos@yandex.com>
+ * @copyright 2017 Alfredo Ramos
+ * @license GPL-2.0-only
+ */
+
+.spoiler {
+	border-width: 1px;
+	border-style: solid;
+	border-radius: 3px;
+	margin: 1em 0;
+}
+
+.spoiler .spoiler-header,
+.spoiler .spoiler-body {
+	padding: 3px 5px;
+}
+
+.spoiler .spoiler-header .spoiler-status {
+	border-radius: 3px;
+	margin-left: 3px;
+	font-size: 0.8em;
+	font-weight: bold;
+	text-align: center;
+}
+
+.spoiler .spoiler-header .spoiler-status > .icon {
+	padding: 0 5px;
+}
+
+.spoiler .spoiler-body {
+	border-width: 1px 0 0;
+	border-style: solid;
+}
diff --git "[FORUM_EXT]/alfredoramos\\simplespoiler/styles/BBOOTS/theme/js/spoiler.js" "[FORUM_EXT]/alfredoramos\\simplespoiler/styles/BBOOTS/theme/js/spoiler.js"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/alfredoramos\\simplespoiler/styles/BBOOTS/theme/js/spoiler.js"
@@ -0,0 +1,63 @@
+/**
+ * Spoiler jQuery
+ * https://github.com/AlfredoRamos/snippets/tree/master/javascript/spoiler
+ * @author Alfredo Ramos <alfredo.ramos@yandex.com>
+ * @version 0.4.0
+ * @copyright 2016 Alfredo Ramos
+ * @license GPL-2.0-only
+ */
+head.ready(function () {
+(function($) {
+	'use strict';
+
+	// Ensure settings exist
+	if (typeof window.$spoiler === 'undefined') {
+		var $spoiler = {};
+	} else {
+		$spoiler = window.$spoiler;
+	}
+
+	// Overwrite settings
+	$spoiler = $.extend({
+		lang: {
+			show: 'Show',
+			hide: 'Hide'
+		},
+		selector: '.spoiler'
+	}, $spoiler);
+
+	// Event delegation
+	$('body').on('click', $spoiler.selector + '-trigger', function() {
+		var $elements = {};
+
+		// Spoiler elements relative to the object that triggered the event
+		$elements.wrapper = $(this).parents($spoiler.selector).first();
+		$elements.status = $elements.wrapper
+			.find($spoiler.selector + '-status').first();
+		$elements.body = $elements.wrapper
+			.children($spoiler.selector + '-body').first();
+
+		// Toggle spoiler class
+		$elements.wrapper.toggleClass($spoiler.selector.replace('.','') + '-show');
+
+		// Toggle status icon
+		$elements.status.children('.fa').first().toggleClass(function() {
+			var $iconClass = 'fa-eye';
+			debugger
+
+			if ($elements.body.is(':visible')) {
+				$(this).removeClass($iconClass);
+				return $iconClass + '-slash';
+			} else {
+				$(this).removeClass($iconClass + '-slash');
+				return $iconClass;
+			}
+		});
+
+		// Toggle status text
+		$elements.status.children('span').first().text(
+			$elements.body.is(':visible') ? $spoiler.lang.hide : $spoiler.lang.show
+		);
+	});
+})(jQuery);
+});
\ No newline at end of file
diff --git "[FORUM_EXT]/alfredoramos\\simplespoiler/styles/FLATBOOTS/template/abbc3_spoiler_button.html" "[FORUM_EXT]/alfredoramos\\simplespoiler/styles/FLATBOOTS/template/abbc3_spoiler_button.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/alfredoramos\\simplespoiler/styles/FLATBOOTS/template/abbc3_spoiler_button.html"
@@ -0,0 +1 @@
+<button type="button" class="bbcode-spoiler abbc3_button{% if SIMPLE_SPOILER_ABBC3_ICON_TYPE %} icon-type-{{ SIMPLE_SPOILER_ABBC3_ICON_TYPE|lower|striptags|escape }}{% endif %}" name="addspoiler" onclick="bbfontstyle('[spoiler]', '[/spoiler]');" title="{{ lang('SPOILER_HELPLINE')|striptags|escape }}" accesskey="e"></button>
diff --git "[FORUM_EXT]/alfredoramos\\simplespoiler/styles/FLATBOOTS/template/event/ext_quickreply_editor_buttons_custom_tags_before.html" "[FORUM_EXT]/alfredoramos\\simplespoiler/styles/FLATBOOTS/template/event/ext_quickreply_editor_buttons_custom_tags_before.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/alfredoramos\\simplespoiler/styles/FLATBOOTS/template/event/ext_quickreply_editor_buttons_custom_tags_before.html"
@@ -0,0 +1 @@
+{% include '@alfredoramos_simplespoiler/spoiler_button.html' ignore missing %}
diff --git "[FORUM_EXT]/alfredoramos\\simplespoiler/styles/FLATBOOTS/template/event/overall_footer_body_after.html" "[FORUM_EXT]/alfredoramos\\simplespoiler/styles/FLATBOOTS/template/event/overall_footer_body_after.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/alfredoramos\\simplespoiler/styles/FLATBOOTS/template/event/overall_footer_body_after.html"
@@ -0,0 +1,12 @@
+{% if not INCLUDED_DETAILS_POLYFILL_JS %}
+{%- if S_ALLOW_CDN -%}
+{% INCLUDEJS 'https://unpkg.com/details-element-polyfill@2.4.0/dist/details-element-polyfill.js' %}
+{%- else -%}
+{% INCLUDEJS '@alfredoramos_simplespoiler/js/details-element-polyfill.min.js' %}
+{%- endif -%}
+{%- set INCLUDED_DETAILS_POLYFILL_JS = true -%}
+{% endif %}
+{% if not INCLUDED_SPOILER_JS %}
+{% INCLUDEJS '@alfredoramos_simplespoiler/js/spoiler.min.js' %}
+{%- set INCLUDED_SPOILER_JS = true -%}
+{% endif %}
diff --git "[FORUM_EXT]/alfredoramos\\simplespoiler/styles/FLATBOOTS/template/event/overall_header_head_append.html" "[FORUM_EXT]/alfredoramos\\simplespoiler/styles/FLATBOOTS/template/event/overall_header_head_append.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/alfredoramos\\simplespoiler/styles/FLATBOOTS/template/event/overall_header_head_append.html"
@@ -0,0 +1,6 @@
+{% if not INCLUDED_SPOILER_CSS %}
+{% INCLUDECSS '@alfredoramos_simplespoiler/css/common.min.css' %}
+{% INCLUDECSS '@alfredoramos_simplespoiler/css/style.min.css' %}
+{% INCLUDECSS '@alfredoramos_simplespoiler/css/colors.min.css' %}
+{%- set INCLUDED_SPOILER_CSS = true -%}
+{% endif %}
diff --git "[FORUM_EXT]/alfredoramos\\simplespoiler/styles/FLATBOOTS/template/event/posting_editor_buttons_custom_tags_before.html" "[FORUM_EXT]/alfredoramos\\simplespoiler/styles/FLATBOOTS/template/event/posting_editor_buttons_custom_tags_before.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/alfredoramos\\simplespoiler/styles/FLATBOOTS/template/event/posting_editor_buttons_custom_tags_before.html"
@@ -0,0 +1 @@
+{% include '@alfredoramos_simplespoiler/spoiler_button.html' ignore missing %}
diff --git "[FORUM_EXT]/alfredoramos\\simplespoiler/styles/FLATBOOTS/template/event/vse_abbc3_posting_editor_buttons_custom_tags_before.html" "[FORUM_EXT]/alfredoramos\\simplespoiler/styles/FLATBOOTS/template/event/vse_abbc3_posting_editor_buttons_custom_tags_before.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/alfredoramos\\simplespoiler/styles/FLATBOOTS/template/event/vse_abbc3_posting_editor_buttons_custom_tags_before.html"
@@ -0,0 +1 @@
+{% include '@alfredoramos_simplespoiler/abbc3_spoiler_button.html' ignore missing %}
diff --git "[FORUM_EXT]/alfredoramos\\simplespoiler/styles/FLATBOOTS/template/spoiler.xsl" "[FORUM_EXT]/alfredoramos\\simplespoiler/styles/FLATBOOTS/template/spoiler.xsl"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/alfredoramos\\simplespoiler/styles/FLATBOOTS/template/spoiler.xsl"
@@ -0,0 +1,20 @@
+<div class="spoiler">
+	<div class="spoiler-header spoiler-trigger">
+		<div class="spoiler-title">
+			<xsl:choose>
+				<xsl:when test="@spoiler">
+					<xsl:value-of select="@spoiler"/>
+				</xsl:when>
+				<xsl:when test="@title">
+					<xsl:value-of select="@title"/>
+				</xsl:when>
+				<xsl:otherwise>{L_SPOILER}</xsl:otherwise>
+			</xsl:choose>
+		</div>
+		<div class="spoiler-status">
+			<i class="fa fa-eye" aria-hidden="true"></i>
+			<span>{L_SPOILER_SHOW}</span>
+		</div>
+	</div>
+	<div class="spoiler-body">{TEXT1}</div>
+</div>
diff --git "[FORUM_EXT]/alfredoramos\\simplespoiler/styles/FLATBOOTS/template/spoiler_button.html" "[FORUM_EXT]/alfredoramos\\simplespoiler/styles/FLATBOOTS/template/spoiler_button.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/alfredoramos\\simplespoiler/styles/FLATBOOTS/template/spoiler_button.html"
@@ -0,0 +1,3 @@
+<button type="button" class="button button-icon-only bbcode-spoiler" name="addspoiler" value="{{ lang('SPOILER')|striptags|escape }}" onclick="bbfontstyle('[spoiler]', '[/spoiler]');" title="{{ lang('SPOILER_HELPLINE')|striptags|escape }}" accesskey="e">
+	<i class="icon fa fa-fw fa-eye-slash" aria-hidden="true"></i>
+</button>
diff --git "[FORUM_EXT]/alfredoramos\\simplespoiler/styles/FLATBOOTS/theme/css/colors.bak" "[FORUM_EXT]/alfredoramos\\simplespoiler/styles/FLATBOOTS/theme/css/colors.bak"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/alfredoramos\\simplespoiler/styles/FLATBOOTS/theme/css/colors.bak"
@@ -0,0 +1,37 @@
+/**
+ * Simple Spoiler extension for phpBB.
+ * @author Alfredo Ramos <alfredo.ramos@yandex.com>
+ * @copyright 2017 Alfredo Ramos
+ * @license GPL-2.0-only
+ */
+
+.spoiler {
+	background-color: #fff;
+	border-color: #ddd;
+}
+
+.spoiler .spoiler-header {
+	background-color: #f3f3f3;
+	color: #333;
+}
+
+.spoiler .spoiler-header .spoiler-status {
+	background-color: #d9534f;
+	color: #fff;
+}
+
+.spoiler .spoiler-body {
+	border-color: #ddd;
+}
+
+.spoiler-show > .spoiler-header .spoiler-status {
+	background-color: #5cb85c;
+}
+
+.bbcode-spoiler {
+	color: transparent;
+}
+
+.bbcode-spoiler::before {
+	color: #8f8f8f;
+}
diff --git "[FORUM_EXT]/alfredoramos\\simplespoiler/styles/FLATBOOTS/theme/css/colors.css" "[FORUM_EXT]/alfredoramos\\simplespoiler/styles/FLATBOOTS/theme/css/colors.css"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/alfredoramos\\simplespoiler/styles/FLATBOOTS/theme/css/colors.css"
@@ -0,0 +1 @@
+.spoiler{background-color:#fff;border-color:#ddd}.spoiler .spoiler-header{background-color:#f3f3f3;color:#333}.spoiler .spoiler-header .spoiler-status{background-color:#d9534f;color:#fff}.spoiler .spoiler-body{border-color:#ddd}.spoiler-show > .spoiler-header .spoiler-status{background-color:#5cb85c}.bbcode-spoiler{color:transparent}.bbcode-spoiler::before{color:#8f8f8f}
\ No newline at end of file
diff --git "[FORUM_EXT]/alfredoramos\\simplespoiler/styles/FLATBOOTS/theme/css/colors.min.css" "[FORUM_EXT]/alfredoramos\\simplespoiler/styles/FLATBOOTS/theme/css/colors.min.css"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/alfredoramos\\simplespoiler/styles/FLATBOOTS/theme/css/colors.min.css"
@@ -0,0 +1 @@
+details.spoiler,.spoiler-header{border-color:#ddd}.spoiler-header{background-color:#f3f3f3;color:#333}.spoiler-status{background-color:#d9534f}.spoiler-status,.spoiler-status>.icon{color:#fff}details.spoiler[open]>.spoiler-header>.spoiler-status{background-color:#5cb85c}
diff --git "[FORUM_EXT]/alfredoramos\\simplespoiler/styles/FLATBOOTS/theme/css/style.bak" "[FORUM_EXT]/alfredoramos\\simplespoiler/styles/FLATBOOTS/theme/css/style.bak"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/alfredoramos\\simplespoiler/styles/FLATBOOTS/theme/css/style.bak"
@@ -0,0 +1,38 @@
+/**
+ * Simple Spoiler extension for phpBB.
+ * @author Alfredo Ramos <alfredo.ramos@yandex.com>
+ * @copyright 2017 Alfredo Ramos
+ * @license GPL-2.0-only
+ */
+
+.spoiler {
+	border-width: 1px;
+	border-style: solid;
+	border-radius: 3px;
+	margin: 1em 0;
+	min-width: 150px
+}
+
+.spoiler .spoiler-header,
+.spoiler .spoiler-body {
+	padding: 3px 5px;
+}
+
+.spoiler .spoiler-header .spoiler-status {
+	border-radius: 3px;
+	margin-left: 3px;
+	font-size: 0.8em;
+	font-weight: bold;
+	text-align: center;
+	min-width: 50px;
+	align-self: center;
+}
+
+.spoiler .spoiler-header .spoiler-status > .icon {
+	padding: 0 5px;
+}
+
+.spoiler .spoiler-body {
+	border-width: 1px 0 0;
+	border-style: solid;
+}
diff --git "[FORUM_EXT]/alfredoramos\\simplespoiler/styles/FLATBOOTS/theme/css/style.css" "[FORUM_EXT]/alfredoramos\\simplespoiler/styles/FLATBOOTS/theme/css/style.css"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/alfredoramos\\simplespoiler/styles/FLATBOOTS/theme/css/style.css"
@@ -0,0 +1 @@
+.spoiler{border-width:1px;border-style:solid;border-radius:3px;margin:1em 0;min-width:150px}.spoiler .spoiler-header,.spoiler .spoiler-body{padding:3px 5px}.spoiler .spoiler-header .spoiler-status{border-radius:3px;margin-left:3px;font-size:.8em;font-weight:700;text-align:center;min-width:50px;align-self:center}.spoiler .spoiler-header .spoiler-status > .icon{padding:0 5px}.spoiler .spoiler-body{border-width:1px 0 0;border-style:solid}
\ No newline at end of file
diff --git "[FORUM_EXT]/alfredoramos\\simplespoiler/styles/FLATBOOTS/theme/css/style.min.css" "[FORUM_EXT]/alfredoramos\\simplespoiler/styles/FLATBOOTS/theme/css/style.min.css"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/alfredoramos\\simplespoiler/styles/FLATBOOTS/theme/css/style.min.css"
@@ -0,0 +1 @@
+details.spoiler{border-width:1px;border-style:solid;margin:1em 0}details.spoiler .spoiler:last-child{margin-bottom:5px}details.spoiler,.spoiler-header{padding:3px 5px}.spoiler,.spoiler-status{border-radius:4px}.spoiler-header{margin:-3px -5px}.spoiler[open]>.spoiler-header{margin-bottom:5px;border-width:0 0 1px;border-style:solid}.spoiler-status{padding:1px 4px}.bbcode-spoiler.abbc3_button{background-image:url("../../../all/theme/images/eye-invisible.svg");background-size:contain;background-position:center;background-repeat:no-repeat}.bbcode-spoiler.abbc3_button.icon-type-svg{-webkit-filter:grayscale(1);filter:grayscale(1)}
diff --git "[FORUM_EXT]/alfredoramos\\simplespoiler/styles/FLATBOOTS/theme/js/spoiler.bak" "[FORUM_EXT]/alfredoramos\\simplespoiler/styles/FLATBOOTS/theme/js/spoiler.bak"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/alfredoramos\\simplespoiler/styles/FLATBOOTS/theme/js/spoiler.bak"
@@ -0,0 +1,63 @@
+/**
+ * Spoiler jQuery
+ * https://github.com/AlfredoRamos/snippets/tree/master/javascript/spoiler
+ * @author Alfredo Ramos <alfredo.ramos@yandex.com>
+ * @version 0.4.0
+ * @copyright 2016 Alfredo Ramos
+ * @license GPL-2.0-only
+ */
+head.ready(function () {
+(function($) {
+	'use strict';
+
+	// Ensure settings exist
+	if (typeof window.$spoiler === 'undefined') {
+		var $spoiler = {};
+	} else {
+		$spoiler = window.$spoiler;
+	}
+
+	// Overwrite settings
+	$spoiler = $.extend({
+		lang: {
+			show: 'Show',
+			hide: 'Hide'
+		},
+		selector: '.spoiler'
+	}, $spoiler);
+
+	// Event delegation
+	$('body').on('click', $spoiler.selector + '-trigger', function() {
+		var $elements = {};
+
+		// Spoiler elements relative to the object that triggered the event
+		$elements.wrapper = $(this).parents($spoiler.selector).first();
+		$elements.status = $elements.wrapper
+			.find($spoiler.selector + '-status').first();
+		$elements.body = $elements.wrapper
+			.children($spoiler.selector + '-body').first();
+
+		// Toggle spoiler class
+		$elements.wrapper.toggleClass($spoiler.selector.replace('.','') + '-show');
+
+		// Toggle status icon
+		$elements.status.children('.fa').first().toggleClass(function() {
+			var $iconClass = 'fa-eye';
+			debugger
+
+			if ($elements.body.is(':visible')) {
+				$(this).removeClass($iconClass);
+				return $iconClass + '-slash';
+			} else {
+				$(this).removeClass($iconClass + '-slash');
+				return $iconClass;
+			}
+		});
+
+		// Toggle status text
+		$elements.status.children('span').first().text(
+			$elements.body.is(':visible') ? $spoiler.lang.hide : $spoiler.lang.show
+		);
+	});
+})(jQuery);
+});
\ No newline at end of file
diff --git "[FORUM_EXT]/alfredoramos\\simplespoiler/styles/FLATBOOTS/theme/js/spoiler.js" "[FORUM_EXT]/alfredoramos\\simplespoiler/styles/FLATBOOTS/theme/js/spoiler.js"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/alfredoramos\\simplespoiler/styles/FLATBOOTS/theme/js/spoiler.js"
@@ -0,0 +1 @@
+head.ready(function(){!function(e){"use strict";if(void 0===window.$spoiler)var s={};else s=window.$spoiler;s=e.extend({lang:{show:"Show",hide:"Hide"},selector:".spoiler"},s),e("body").on("click",s.selector+"-trigger",function(){var r={};r.wrapper=e(this).parents(s.selector).first(),r.status=r.wrapper.find(s.selector+"-status").first(),r.body=r.wrapper.children(s.selector+"-body").first(),r.wrapper.toggleClass(s.selector.replace(".","")+"-show"),r.status.children(".fa").first().toggleClass(function(){return r.body.is(":visible")?(e(this).removeClass("fa-eye"),"fa-eye-slash"):(e(this).removeClass("fa-eye-slash"),"fa-eye")}),r.status.children("span").first().text(r.body.is(":visible")?s.lang.hide:s.lang.show)})}(jQuery)});
\ No newline at end of file
diff --git "[ORIGINAL]/alfredoramos\\simplespoiler/styles/all/template/event/overall_footer_body_after.html" "[FORUM_EXT]/alfredoramos\\simplespoiler/styles/all/template/event/overall_footer_body_after.html"
--- "[ORIGINAL]/alfredoramos\\simplespoiler/styles/all/template/event/overall_footer_body_after.html"
+++ "[FORUM_EXT]/alfredoramos\\simplespoiler/styles/all/template/event/overall_footer_body_after.html"
@@ -7,6 +7,6 @@
 {%- set INCLUDED_DETAILS_POLYFILL_JS = true -%}
 {% endif %}
 {% if not INCLUDED_SPOILER_JS %}
-{% INCLUDEJS '@alfredoramos_simplespoiler/js/spoiler.js' %}
+{% INCLUDEJS '@alfredoramos_simplespoiler/js/spoiler.min.js' %}
 {%- set INCLUDED_SPOILER_JS = true -%}
 {% endif %}
diff --git "[ORIGINAL]/alfredoramos\\simplespoiler/styles/all/template/event/overall_header_head_append.html" "[FORUM_EXT]/alfredoramos\\simplespoiler/styles/all/template/event/overall_header_head_append.html"
--- "[ORIGINAL]/alfredoramos\\simplespoiler/styles/all/template/event/overall_header_head_append.html"
+++ "[FORUM_EXT]/alfredoramos\\simplespoiler/styles/all/template/event/overall_header_head_append.html"
@@ -1,6 +1,6 @@
 {% if not INCLUDED_SPOILER_CSS %}
-{% INCLUDECSS '@alfredoramos_simplespoiler/css/common.css' %}
-{% INCLUDECSS '@alfredoramos_simplespoiler/css/style.css' %}
-{% INCLUDECSS '@alfredoramos_simplespoiler/css/colors.css' %}
+{% INCLUDECSS '@alfredoramos_simplespoiler/css/common.min.css' %}
+{% INCLUDECSS '@alfredoramos_simplespoiler/css/style.min.css' %}
+{% INCLUDECSS '@alfredoramos_simplespoiler/css/colors.min.css' %}
 {%- set INCLUDED_SPOILER_CSS = true -%}
 {% endif %}
diff --git "[ORIGINAL]/alfredoramos\\simplespoiler/styles/all/template/spoiler.xsl" "[FORUM_EXT]/alfredoramos\\simplespoiler/styles/all/template/spoiler.xsl"
--- "[ORIGINAL]/alfredoramos\\simplespoiler/styles/all/template/spoiler.xsl"
+++ "[FORUM_EXT]/alfredoramos\\simplespoiler/styles/all/template/spoiler.xsl"
@@ -16,7 +16,7 @@
 			</xsl:choose>
 		</span>
 		<span class="spoiler-status">
-			<i class="icon fa-fw fa-eye" aria-hidden="true"></i>
+			<i class="icon fa fa-fw fa-eye" aria-hidden="true"></i>
 		</span>
 	</summary>
 	<div class="spoiler-body"><xsl:apply-templates/></div>
diff --git "[FORUM_EXT]/alfredoramos\\simplespoiler/styles/all/theme/css/common.min.css" "[FORUM_EXT]/alfredoramos\\simplespoiler/styles/all/theme/css/common.min.css"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/alfredoramos\\simplespoiler/styles/all/theme/css/common.min.css"
@@ -0,0 +1 @@
+.spoiler{overflow:hidden}.spoiler-header{display:-ms-flexbox;display:flex;-ms-flex-wrap:wrap;flex-wrap:wrap;-ms-flex-align:start;align-items:flex-start;-ms-flex-pack:justify;justify-content:space-between;cursor:pointer}.spoiler-title{overflow:hidden;white-space:nowrap;text-overflow:ellipsis;-ms-flex-preferred-size:0;flex-basis:0;-ms-flex-positive:1;flex-grow:1;min-width:0;max-width:100%}.spoiler-status{margin-left:3px;-ms-flex:0 0 auto;flex:0 0 auto;width:auto;max-width:100%;-ms-flex-item-align:end;align-self:flex-end;text-align:center}.faq details.spoiler{max-width:650px}.spoiler-header::before{padding-right:0;font-size:1em}.spoiler-header::before,.spoiler[open]>.spoiler-header::before{content:''}.spoiler-header::-webkit-details-marker{display:none}
diff --git "[FORUM_EXT]/alfredoramos\\simplespoiler/styles/all/theme/js/spoiler.min.js" "[FORUM_EXT]/alfredoramos\\simplespoiler/styles/all/theme/js/spoiler.min.js"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/alfredoramos\\simplespoiler/styles/all/theme/js/spoiler.min.js"
@@ -0,0 +1 @@
+!function(){'use strict';Element.prototype.matches||(Element.prototype.matches=Element.prototype.msMatchesSelector||Element.prototype.webkitMatchesSelector),Element.prototype.closest||(Element.prototype.closest=function(e){let t=this;do{if(t.matches(e))return t;t=t.parentElement||t.parentNode}while(null!==t&&1===t.nodeType);return null}),document.body.addEventListener('click',function(e){if(!e.target.closest('.spoiler-header'))return;let t={container:e.target.closest('.spoiler')};if(!t.container)return;if(t.icon=t.container.querySelector('.spoiler-status > .icon'),!t.icon)return;let o=t.container.hasAttribute('open');t.icon.classList.toggle('fa-eye',o),t.icon.classList.toggle('fa-eye-slash',!o)})}();
diff --git "[ORIGINAL]/alfredoramos\\simplespoiler/styles/prosilver/template/spoiler_button.html" "[FORUM_EXT]/alfredoramos\\simplespoiler/styles/prosilver/template/spoiler_button.html"
--- "[ORIGINAL]/alfredoramos\\simplespoiler/styles/prosilver/template/spoiler_button.html"
+++ "[FORUM_EXT]/alfredoramos\\simplespoiler/styles/prosilver/template/spoiler_button.html"
@@ -1,3 +1,3 @@
 <button type="button" class="button button-icon-only bbcode-spoiler" name="addspoiler" value="{{ lang('SPOILER')|striptags|escape }}" onclick="bbfontstyle('[spoiler]', '[/spoiler]');" title="{{ lang('SPOILER_HELPLINE')|striptags|escape }}" accesskey="e">
-	<i class="icon fa-fw fa-eye-slash" aria-hidden="true"></i>
+	<i class="icon fa fa-fw fa-eye-slash" aria-hidden="true"></i>
 </button>
diff --git "[FORUM_EXT]/alfredoramos\\simplespoiler/styles/prosilver/theme/css/colors.min.css" "[FORUM_EXT]/alfredoramos\\simplespoiler/styles/prosilver/theme/css/colors.min.css"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/alfredoramos\\simplespoiler/styles/prosilver/theme/css/colors.min.css"
@@ -0,0 +1 @@
+details.spoiler{background-color:#fff}details.spoiler,.spoiler-header{border-color:#ddd}.spoiler-header{background-color:#f3f3f3;color:#333}.spoiler-status{background-color:#d9534f}.spoiler-status,.spoiler-status>.icon{color:#fff}details.spoiler[open]>.spoiler-header>.spoiler-status{background-color:#5cb85c}
diff --git "[FORUM_EXT]/alfredoramos\\simplespoiler/styles/prosilver/theme/css/style.min.css" "[FORUM_EXT]/alfredoramos\\simplespoiler/styles/prosilver/theme/css/style.min.css"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/alfredoramos\\simplespoiler/styles/prosilver/theme/css/style.min.css"
@@ -0,0 +1 @@
+details.spoiler{border-width:1px;border-style:solid;margin:1em 0}details.spoiler .spoiler:last-child{margin-bottom:5px}details.spoiler,.spoiler-header{padding:3px 5px}.spoiler,.spoiler-status{border-radius:4px}.spoiler-header{margin:-3px -5px}.spoiler[open]>.spoiler-header{margin-bottom:5px;border-width:0 0 1px;border-style:solid}.spoiler-status{padding:1px 4px}.bbcode-spoiler.abbc3_button{background-image:url("../../../all/theme/images/eye-invisible.svg");background-size:contain;background-position:center;background-repeat:no-repeat}.bbcode-spoiler.abbc3_button.icon-type-svg{-webkit-filter:grayscale(1);filter:grayscale(1)}
```
