Existem diferencas reais no codigo ou texto. Diferencas de formatacao (espacos, tabs) foram ignoradas abaixo.

```diff
diff --git "[FORUM_EXT]/senky\\timetoread/diff_full.tmp" "[FORUM_EXT]/senky\\timetoread/diff_full.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/senky\\timetoread/diff_full.tmp"
@@ -0,0 +1,87 @@
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\senky\\timetoread/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\senky\\timetoread/diff_full.tmp"
+new file mode 100644
+index 000000000..e69de29bb
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\senky\\timetoread/language/pt/common.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\senky\\timetoread/language/pt/common.php"
+new file mode 100644
+index 000000000..a2140cce4
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\senky\\timetoread/language/pt/common.php"
+@@ -0,0 +1,29 @@
++<?php
++/**
++ *
++ * This file is part of the phpBB Forum Software package.
++ *
++ * @copyright (c) phpBB Limited <https://www.phpbb.com>
++ * @license GNU General Public License, version 2 (GPL-2.0)
++ *
++ * For full copyright and license information, please see
++ * the docs/CREDITS.txt file.
++ *
++ */
++
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
++$lang = array_merge($lang, array(
++	'TIME_TO_READ'	=> array(
++		1 => '1 min de leitura',
++		2 => '%d min de leitura'
++	),
++));
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\senky\\timetoread/language/pt_preao/common.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\senky\\timetoread/language/pt_preao/common.php"
+new file mode 100644
+index 000000000..a2140cce4
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\senky\\timetoread/language/pt_preao/common.php"
+@@ -0,0 +1,29 @@
++<?php
++/**
++ *
++ * This file is part of the phpBB Forum Software package.
++ *
++ * @copyright (c) phpBB Limited <https://www.phpbb.com>
++ * @license GNU General Public License, version 2 (GPL-2.0)
++ *
++ * For full copyright and license information, please see
++ * the docs/CREDITS.txt file.
++ *
++ */
++
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
++$lang = array_merge($lang, array(
++	'TIME_TO_READ'	=> array(
++		1 => '1 min de leitura',
++		2 => '%d min de leitura'
++	),
++));
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\senky\\timetoread/styles/FLATBOOTS/template/event/topiclist_row_append.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\senky\\timetoread/styles/FLATBOOTS/template/event/topiclist_row_append.html"
+new file mode 100644
+index 000000000..d6959f39c
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\senky\\timetoread/styles/FLATBOOTS/template/event/topiclist_row_append.html"
+@@ -0,0 +1 @@
++<span>&nbsp;&raquo; {{ topicrow.TIME_TO_READ }}</span>
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\senky\\timetoread/styles/prosilver/template/event/topiclist_row_append.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\senky\\timetoread/styles/prosilver/template/event/topiclist_row_append.html"
+deleted file mode 100644
+index 0f1147fd6..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\senky\\timetoread/styles/prosilver/template/event/topiclist_row_append.html"
++++ /dev/null
+@@ -1 +0,0 @@
+-<div>&nbsp;&raquo; {{ topicrow.TIME_TO_READ }}</div>
diff --git "[FORUM_EXT]/senky\\timetoread/diff_nospace.tmp" "[FORUM_EXT]/senky\\timetoread/diff_nospace.tmp"
new file mode 100644
diff --git "[FORUM_EXT]/senky\\timetoread/language/pt/common.php" "[FORUM_EXT]/senky\\timetoread/language/pt/common.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/senky\\timetoread/language/pt/common.php"
@@ -0,0 +1,29 @@
+<?php
+/**
+ *
+ * This file is part of the phpBB Forum Software package.
+ *
+ * @copyright (c) phpBB Limited <https://www.phpbb.com>
+ * @license GNU General Public License, version 2 (GPL-2.0)
+ *
+ * For full copyright and license information, please see
+ * the docs/CREDITS.txt file.
+ *
+ */
+
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
+$lang = array_merge($lang, array(
+	'TIME_TO_READ'	=> array(
+		1 => '1 min de leitura',
+		2 => '%d min de leitura'
+	),
+));
diff --git "[FORUM_EXT]/senky\\timetoread/language/pt_preao/common.php" "[FORUM_EXT]/senky\\timetoread/language/pt_preao/common.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/senky\\timetoread/language/pt_preao/common.php"
@@ -0,0 +1,29 @@
+<?php
+/**
+ *
+ * This file is part of the phpBB Forum Software package.
+ *
+ * @copyright (c) phpBB Limited <https://www.phpbb.com>
+ * @license GNU General Public License, version 2 (GPL-2.0)
+ *
+ * For full copyright and license information, please see
+ * the docs/CREDITS.txt file.
+ *
+ */
+
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
+$lang = array_merge($lang, array(
+	'TIME_TO_READ'	=> array(
+		1 => '1 min de leitura',
+		2 => '%d min de leitura'
+	),
+));
diff --git "[FORUM_EXT]/senky\\timetoread/styles/FLATBOOTS/template/event/topiclist_row_append.html" "[FORUM_EXT]/senky\\timetoread/styles/FLATBOOTS/template/event/topiclist_row_append.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/senky\\timetoread/styles/FLATBOOTS/template/event/topiclist_row_append.html"
@@ -0,0 +1 @@
+<span>&nbsp;&raquo; {{ topicrow.TIME_TO_READ }}</span>
diff --git "[ORIGINAL]/senky\\timetoread/styles/prosilver/template/event/topiclist_row_append.html" "[ORIGINAL]/senky\\timetoread/styles/prosilver/template/event/topiclist_row_append.html"
deleted file mode 100644
--- "[ORIGINAL]/senky\\timetoread/styles/prosilver/template/event/topiclist_row_append.html"
+++ /dev/null
@@ -1 +0,0 @@
-<div>&nbsp;&raquo; {{ topicrow.TIME_TO_READ }}</div>
```
