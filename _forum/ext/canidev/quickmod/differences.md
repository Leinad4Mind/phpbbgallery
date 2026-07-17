Existem diferencas reais no codigo ou texto. Diferencas de formatacao (espacos, tabs) foram ignoradas abaixo.

```diff
diff --git "[FORUM_EXT]/canidev\\quickmod/diff_full.tmp" "[FORUM_EXT]/canidev\\quickmod/diff_full.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/canidev\\quickmod/diff_full.tmp"
@@ -0,0 +1,93 @@
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickmod/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickmod/diff_full.tmp"
+new file mode 100644
+index 000000000..e69de29bb
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickmod/event/listener.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickmod/event/listener.php"
+index c8a23bf70..17a1b3ebb 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickmod/event/listener.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickmod/event/listener.php"
+@@ -132,7 +132,7 @@ class listener implements EventSubscriberInterface
+ 		{
+ 			$topic_row	= $event['tpl_ary'];
+ 			$row		= $event['row'];
+-			
++
+ 			$topic_forum_id	= ($row['forum_id']) ? (int) $row['forum_id'] : $this->quickmod->forum_id;
+ 
+ 			$topic_row['QM_CONTENT'] = $this->quickmod->get_row_content($topic_forum_id, $row['topic_id'], $row['topic_type'], $row['topic_status'], $row['topic_visibility']);
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickmod/styles/BBOOTS/template/components/service_loader.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickmod/styles/BBOOTS/template/components/service_loader.html"
+deleted file mode 100644
+index a244ac90c..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickmod/styles/BBOOTS/template/components/service_loader.html"
++++ /dev/null
+@@ -1,16 +0,0 @@
+-	<script>
+-	// <![CDATA[
+-	head.ready(['cbbcore.min.js', 'jquickmod.min.js'], function () {
+-		cbbCore.initService('quickmod', {
+-			rowSelector	: 'tr:has(".quick_mod_buttons")',
+-			position	: {
+-				default	: ['.panel:has(.footable):last', 'after'],
+-				fixed	: ['.panel:has(.footable):last + div > .pull-left', 'after']
+-			},
+-			layout 		: '{{ S_QM_LAYOUT }}',
+-			titleTag	: 'data-original-title title',
+-			type		: '{{ S_QM_TYPE }}'
+-		});
+-	});
+-	// ]]>
+-	</script>
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickmod/styles/BBOOTS/template/event/overall_header_head_append.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickmod/styles/BBOOTS/template/event/overall_header_head_append.html"
+deleted file mode 100644
+index 03d9a4897..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickmod/styles/BBOOTS/template/event/overall_header_head_append.html"
++++ /dev/null
+@@ -1,5 +0,0 @@
+-{% if S_QUICKMOD_ENABLED and CANIDEV_CORE_STARTED %}
+-	{% include '@canidev_core/event/overall_header_head_append.html' %}
+-
+-	{% INCLUDECSS '@canidev_quickmod/bboots.css' %}
+-{% endif %}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickmod/styles/BBOOTS/theme/bboots.css" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickmod/styles/BBOOTS/theme/bboots.css"
+deleted file mode 100644
+index bce41f0e6..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickmod/styles/BBOOTS/theme/bboots.css"
++++ /dev/null
+@@ -1,36 +0,0 @@
+-/*  cBB QuickMod StyleSheet
+-    --------------------------------------------------------------
+-	Style:	BBOOTS
+-	Copyright (c) 2024 CaniDev ( https://www.canidev.com )
+-    --------------------------------------------------------------
+-*/
+-
+-#qm-main {
+-	font-size: inherit !important;
+-}
+-
+-.qm-layout-default #qm-main {
+-	padding: 5px 10px;
+-}
+-
+-.qm-layout-fixed #qm-main {
+-	margin-left: 5px;
+-	margin-top: 3px;
+-}
+-
+-.qm-layout-default .qm-main-container {
+-	min-height: 38px !important;
+-}
+-
+-.qm-row .footable-first-column,
+-.qm-row .footable-last-column {
+-	position: relative;
+-}
+-
+-.qm-row .desc-wrapper > a {
+-    vertical-align: top;
+-}
+-
+-.cbb-dialog.qm-dialog .cbb-dialog-content {
+-	font-size: 1.2em;
+-}
+\ No newline at end of file
diff --git "[FORUM_EXT]/canidev\\quickmod/diff_nospace.tmp" "[FORUM_EXT]/canidev\\quickmod/diff_nospace.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/canidev\\quickmod/diff_nospace.tmp"
@@ -0,0 +1,73 @@
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickmod/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickmod/diff_full.tmp"
+new file mode 100644
+index 000000000..a454526af
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickmod/diff_full.tmp"
+@@ -0,0 +1,93 @@
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickmod/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickmod/diff_full.tmp"
++new file mode 100644
++index 000000000..e69de29bb
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickmod/event/listener.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickmod/event/listener.php"
++index c8a23bf70..17a1b3ebb 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickmod/event/listener.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickmod/event/listener.php"
++@@ -132,7 +132,7 @@ class listener implements EventSubscriberInterface
++ 		{
++ 			$topic_row	= $event['tpl_ary'];
++ 			$row		= $event['row'];
++-			
+++
++ 			$topic_forum_id	= ($row['forum_id']) ? (int) $row['forum_id'] : $this->quickmod->forum_id;
++ 
++ 			$topic_row['QM_CONTENT'] = $this->quickmod->get_row_content($topic_forum_id, $row['topic_id'], $row['topic_type'], $row['topic_status'], $row['topic_visibility']);
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickmod/styles/BBOOTS/template/components/service_loader.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickmod/styles/BBOOTS/template/components/service_loader.html"
++deleted file mode 100644
++index a244ac90c..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickmod/styles/BBOOTS/template/components/service_loader.html"
+++++ /dev/null
++@@ -1,16 +0,0 @@
++-	<script>
++-	// <![CDATA[
++-	head.ready(['cbbcore.min.js', 'jquickmod.min.js'], function () {
++-		cbbCore.initService('quickmod', {
++-			rowSelector	: 'tr:has(".quick_mod_buttons")',
++-			position	: {
++-				default	: ['.panel:has(.footable):last', 'after'],
++-				fixed	: ['.panel:has(.footable):last + div > .pull-left', 'after']
++-			},
++-			layout 		: '{{ S_QM_LAYOUT }}',
++-			titleTag	: 'data-original-title title',
++-			type		: '{{ S_QM_TYPE }}'
++-		});
++-	});
++-	// ]]>
++-	</script>
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickmod/styles/BBOOTS/template/event/overall_header_head_append.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickmod/styles/BBOOTS/template/event/overall_header_head_append.html"
++deleted file mode 100644
++index 03d9a4897..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickmod/styles/BBOOTS/template/event/overall_header_head_append.html"
+++++ /dev/null
++@@ -1,5 +0,0 @@
++-{% if S_QUICKMOD_ENABLED and CANIDEV_CORE_STARTED %}
++-	{% include '@canidev_core/event/overall_header_head_append.html' %}
++-
++-	{% INCLUDECSS '@canidev_quickmod/bboots.css' %}
++-{% endif %}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickmod/styles/BBOOTS/theme/bboots.css" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickmod/styles/BBOOTS/theme/bboots.css"
++deleted file mode 100644
++index bce41f0e6..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickmod/styles/BBOOTS/theme/bboots.css"
+++++ /dev/null
++@@ -1,36 +0,0 @@
++-/*  cBB QuickMod StyleSheet
++-    --------------------------------------------------------------
++-	Style:	BBOOTS
++-	Copyright (c) 2024 CaniDev ( https://www.canidev.com )
++-    --------------------------------------------------------------
++-*/
++-
++-#qm-main {
++-	font-size: inherit !important;
++-}
++-
\ No newline at end of file
diff --git "[ORIGINAL]/canidev\\quickmod/styles/BBOOTS/template/components/service_loader.html" "[ORIGINAL]/canidev\\quickmod/styles/BBOOTS/template/components/service_loader.html"
deleted file mode 100644
--- "[ORIGINAL]/canidev\\quickmod/styles/BBOOTS/template/components/service_loader.html"
+++ /dev/null
@@ -1,16 +0,0 @@
-	<script>
-	// <![CDATA[
-	head.ready(['cbbcore.min.js', 'jquickmod.min.js'], function () {
-		cbbCore.initService('quickmod', {
-			rowSelector	: 'tr:has(".quick_mod_buttons")',
-			position	: {
-				default	: ['.panel:has(.footable):last', 'after'],
-				fixed	: ['.panel:has(.footable):last + div > .pull-left', 'after']
-			},
-			layout 		: '{{ S_QM_LAYOUT }}',
-			titleTag	: 'data-original-title title',
-			type		: '{{ S_QM_TYPE }}'
-		});
-	});
-	// ]]>
-	</script>
\ No newline at end of file
diff --git "[ORIGINAL]/canidev\\quickmod/styles/BBOOTS/template/event/overall_header_head_append.html" "[ORIGINAL]/canidev\\quickmod/styles/BBOOTS/template/event/overall_header_head_append.html"
deleted file mode 100644
--- "[ORIGINAL]/canidev\\quickmod/styles/BBOOTS/template/event/overall_header_head_append.html"
+++ /dev/null
@@ -1,5 +0,0 @@
-{% if S_QUICKMOD_ENABLED and CANIDEV_CORE_STARTED %}
-	{% include '@canidev_core/event/overall_header_head_append.html' %}
-
-	{% INCLUDECSS '@canidev_quickmod/bboots.css' %}
-{% endif %}
diff --git "[ORIGINAL]/canidev\\quickmod/styles/BBOOTS/theme/bboots.css" "[ORIGINAL]/canidev\\quickmod/styles/BBOOTS/theme/bboots.css"
deleted file mode 100644
--- "[ORIGINAL]/canidev\\quickmod/styles/BBOOTS/theme/bboots.css"
+++ /dev/null
@@ -1,36 +0,0 @@
-/*  cBB QuickMod StyleSheet
-    --------------------------------------------------------------
-	Style:	BBOOTS
-	Copyright (c) 2024 CaniDev ( https://www.canidev.com )
-    --------------------------------------------------------------
-*/
-
-#qm-main {
-	font-size: inherit !important;
-}
-
-.qm-layout-default #qm-main {
-	padding: 5px 10px;
-}
-
-.qm-layout-fixed #qm-main {
-	margin-left: 5px;
-	margin-top: 3px;
-}
-
-.qm-layout-default .qm-main-container {
-	min-height: 38px !important;
-}
-
-.qm-row .footable-first-column,
-.qm-row .footable-last-column {
-	position: relative;
-}
-
-.qm-row .desc-wrapper > a {
-    vertical-align: top;
-}
-
-.cbb-dialog.qm-dialog .cbb-dialog-content {
-	font-size: 1.2em;
-}
\ No newline at end of file
```
