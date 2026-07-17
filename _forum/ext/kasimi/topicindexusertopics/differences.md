Existem diferencas reais no codigo ou texto. Diferencas de formatacao (espacos, tabs) foram ignoradas abaixo.

```diff
diff --git "[ORIGINAL]/kasimi\\topicindexusertopics/composer.json" "[FORUM_EXT]/kasimi\\topicindexusertopics/composer.json"
--- "[ORIGINAL]/kasimi\\topicindexusertopics/composer.json"
+++ "[FORUM_EXT]/kasimi\\topicindexusertopics/composer.json"
@@ -1,7 +1,7 @@
 {
     "name": "kasimi/topicindexusertopics",
     "type": "phpbb-extension",
-    "description": "Display topic attributes from the Quick Title Edition extension in the list of topics displayed by the Topic Index extension.",
+    "description": "Add the ability to list user topics on Topic Index extension.",
     "version": "1.0.1",
     "time": "2018-08-03",
     "license": "GPL-2.0-only",
diff --git "[FORUM_EXT]/kasimi\\topicindexusertopics/diff_full.tmp" "[FORUM_EXT]/kasimi\\topicindexusertopics/diff_full.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/kasimi\\topicindexusertopics/diff_full.tmp"
@@ -0,0 +1,116 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\kasimi\\topicindexusertopics/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\topicindexusertopics/composer.json"
+index fee23a98b..36ee3e78f 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\kasimi\\topicindexusertopics/composer.json"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\topicindexusertopics/composer.json"
+@@ -1,7 +1,7 @@
+ {
+     "name": "kasimi/topicindexusertopics",
+     "type": "phpbb-extension",
+-    "description": "Display topic attributes from the Quick Title Edition extension in the list of topics displayed by the Topic Index extension.",
++    "description": "Add the ability to list user topics on Topic Index extension.",
+     "version": "1.0.1",
+     "time": "2018-08-03",
+     "license": "GPL-2.0-only",
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\topicindexusertopics/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\topicindexusertopics/diff_full.tmp"
+new file mode 100644
+index 000000000..e69de29bb
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\kasimi\\topicindexusertopics/event/main_listener.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\topicindexusertopics/event/main_listener.php"
+index 304b29457..3df61d851 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\kasimi\\topicindexusertopics/event/main_listener.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\topicindexusertopics/event/main_listener.php"
+@@ -120,8 +120,8 @@ class main_listener implements EventSubscriberInterface
+ 			$this->template->assign_vars([
+ 				'S_TOPIC_INDEX_IS_USER_SEARCH'	=> $this->request->variable('user', 0),
+ 				'U_TOPIC_INDEX_USER_TOPICS'		=> $this->controller_helper->route('dmzx_topicindex_controller', [
++					'list' => 69,
+ 					'user' => $event['member']['user_id'],
+-					'list' => 1,
+ 				]),
+ 			]);
+ 		}
+@@ -170,8 +170,8 @@ class main_listener implements EventSubscriberInterface
+ 		{
+ 			$this->template->assign_vars([
+ 				'U_TOPIC_INDEX_USER_TOPICS_SELF' => $this->controller_helper->route('dmzx_topicindex_controller', [
++					'list' => 71,
+ 					'user' => $this->user->data['user_id'],
+-					'list' => 1,
+ 				]),
+ 			]);
+ 		}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\kasimi\\topicindexusertopics/language/pt_br/common.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\topicindexusertopics/language/pt/common.php"
+similarity index 78%
+rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\kasimi\\topicindexusertopics/language/pt_br/common.php"
+rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\topicindexusertopics/language/pt/common.php"
+index 563bdd9f0..dcc4868af 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\kasimi\\topicindexusertopics/language/pt_br/common.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\topicindexusertopics/language/pt/common.php"
+@@ -36,11 +36,11 @@ if (empty($lang) || !is_array($lang))
+ 
+ $lang = array_merge($lang, [
+ 	// On viewprofile
+-	'TOPIC_INDEX_USER_TOPICS'			=> 'Meus Uploads',
+-	'TOPIC_INDEX_USER_TOPICS_VIEW'		=> 'Ver os meus uploads',
+-	'TOPIC_INDEX_TOPICS_SELF'		=> 'Seus Uploads',
++	'TOPIC_INDEX_USER_TOPICS'			=> 'Partilhas',
++	'TOPIC_INDEX_USER_TOPICS_VIEW'		=> 'Ver partilhas do utilizador',
++	'TOPIC_INDEX_TOPICS_SELF'			=> 'Minhas Partilhas',
+ 
+ 	// On topic index page
+-	'TOPIC_INDEX_USER_TOPICS_FILTERING'	=> 'de %1$s',
+-	'TOPIC_INDEX_USER_TOPICS_NO_FILTER' => 'Click to list all.',
++	'TOPIC_INDEX_USER_TOPICS_FILTERING'	=> 'partilhadas por %1$s',
++	'TOPIC_INDEX_USER_TOPICS_NO_FILTER' => 'Clique para listar todos',
+ ]);
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\topicindexusertopics/language/pt_preao/common.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\topicindexusertopics/language/pt_preao/common.php"
+new file mode 100644
+index 000000000..dcc4868af
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\topicindexusertopics/language/pt_preao/common.php"
+@@ -0,0 +1,46 @@
++<?php
++
++/**
++ *
++ * Topic Index - User Topics. An extension for the phpBB Forum Software package.
++ *
++ * @copyright (c) 2018 kasimi - https://kasimi.net
++ * @license GNU General Public License, version 2 (GPL-2.0)
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
++//
++// Some characters for use
++// ’ » “ ” …
++
++$lang = array_merge($lang, [
++	// On viewprofile
++	'TOPIC_INDEX_USER_TOPICS'			=> 'Partilhas',
++	'TOPIC_INDEX_USER_TOPICS_VIEW'		=> 'Ver partilhas do utilizador',
++	'TOPIC_INDEX_TOPICS_SELF'			=> 'Minhas Partilhas',
++
++	// On topic index page
++	'TOPIC_INDEX_USER_TOPICS_FILTERING'	=> 'partilhadas por %1$s',
++	'TOPIC_INDEX_USER_TOPICS_NO_FILTER' => 'Clique para listar todos',
++]);
diff --git "[FORUM_EXT]/kasimi\\topicindexusertopics/diff_nospace.tmp" "[FORUM_EXT]/kasimi\\topicindexusertopics/diff_nospace.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/kasimi\\topicindexusertopics/diff_nospace.tmp"
@@ -0,0 +1,60 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\kasimi\\topicindexusertopics/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\topicindexusertopics/composer.json"
+index fee23a98b..36ee3e78f 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\kasimi\\topicindexusertopics/composer.json"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\topicindexusertopics/composer.json"
+@@ -1,7 +1,7 @@
+ {
+     "name": "kasimi/topicindexusertopics",
+     "type": "phpbb-extension",
+-    "description": "Display topic attributes from the Quick Title Edition extension in the list of topics displayed by the Topic Index extension.",
++    "description": "Add the ability to list user topics on Topic Index extension.",
+     "version": "1.0.1",
+     "time": "2018-08-03",
+     "license": "GPL-2.0-only",
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\topicindexusertopics/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\topicindexusertopics/diff_full.tmp"
+new file mode 100644
+index 000000000..f5d1c19ee
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\topicindexusertopics/diff_full.tmp"
+@@ -0,0 +1,116 @@
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\kasimi\\topicindexusertopics/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\topicindexusertopics/composer.json"
++index fee23a98b..36ee3e78f 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\kasimi\\topicindexusertopics/composer.json"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\topicindexusertopics/composer.json"
++@@ -1,7 +1,7 @@
++ {
++     "name": "kasimi/topicindexusertopics",
++     "type": "phpbb-extension",
++-    "description": "Display topic attributes from the Quick Title Edition extension in the list of topics displayed by the Topic Index extension.",
+++    "description": "Add the ability to list user topics on Topic Index extension.",
++     "version": "1.0.1",
++     "time": "2018-08-03",
++     "license": "GPL-2.0-only",
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\topicindexusertopics/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\topicindexusertopics/diff_full.tmp"
++new file mode 100644
++index 000000000..e69de29bb
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\kasimi\\topicindexusertopics/event/main_listener.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\topicindexusertopics/event/main_listener.php"
++index 304b29457..3df61d851 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\kasimi\\topicindexusertopics/event/main_listener.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\topicindexusertopics/event/main_listener.php"
++@@ -120,8 +120,8 @@ class main_listener implements EventSubscriberInterface
++ 			$this->template->assign_vars([
++ 				'S_TOPIC_INDEX_IS_USER_SEARCH'	=> $this->request->variable('user', 0),
++ 				'U_TOPIC_INDEX_USER_TOPICS'		=> $this->controller_helper->route('dmzx_topicindex_controller', [
+++					'list' => 69,
++ 					'user' => $event['member']['user_id'],
++-					'list' => 1,
++ 				]),
++ 			]);
++ 		}
++@@ -170,8 +170,8 @@ class main_listener implements EventSubscriberInterface
++ 		{
++ 			$this->template->assign_vars([
++ 				'U_TOPIC_INDEX_USER_TOPICS_SELF' => $this->controller_helper->route('dmzx_topicindex_controller', [
+++					'list' => 71,
++ 					'user' => $this->user->data['user_id'],
++-					'list' => 1,
++ 				]),
++ 			]);
++ 		}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\kasimi\\topicindexusertopics/language/pt_br/common.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasim
\ No newline at end of file
diff --git "[ORIGINAL]/kasimi\\topicindexusertopics/event/main_listener.php" "[FORUM_EXT]/kasimi\\topicindexusertopics/event/main_listener.php"
--- "[ORIGINAL]/kasimi\\topicindexusertopics/event/main_listener.php"
+++ "[FORUM_EXT]/kasimi\\topicindexusertopics/event/main_listener.php"
@@ -120,8 +120,8 @@ class main_listener implements EventSubscriberInterface
 			$this->template->assign_vars([
 				'S_TOPIC_INDEX_IS_USER_SEARCH'	=> $this->request->variable('user', 0),
 				'U_TOPIC_INDEX_USER_TOPICS'		=> $this->controller_helper->route('dmzx_topicindex_controller', [
+					'list' => 69,
 					'user' => $event['member']['user_id'],
-					'list' => 1,
 				]),
 			]);
 		}
@@ -170,8 +170,8 @@ class main_listener implements EventSubscriberInterface
 		{
 			$this->template->assign_vars([
 				'U_TOPIC_INDEX_USER_TOPICS_SELF' => $this->controller_helper->route('dmzx_topicindex_controller', [
+					'list' => 71,
 					'user' => $this->user->data['user_id'],
-					'list' => 1,
 				]),
 			]);
 		}
diff --git "[ORIGINAL]/kasimi\\topicindexusertopics/language/pt_br/common.php" "[FORUM_EXT]/kasimi\\topicindexusertopics/language/pt/common.php"
similarity index 78%
rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\kasimi\\topicindexusertopics/language/pt_br/common.php"
rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\kasimi\\topicindexusertopics/language/pt/common.php"
--- "[ORIGINAL]/kasimi\\topicindexusertopics/language/pt_br/common.php"
+++ "[FORUM_EXT]/kasimi\\topicindexusertopics/language/pt/common.php"
@@ -36,11 +36,11 @@ if (empty($lang) || !is_array($lang))
 
 $lang = array_merge($lang, [
 	// On viewprofile
-	'TOPIC_INDEX_USER_TOPICS'			=> 'Meus Uploads',
-	'TOPIC_INDEX_USER_TOPICS_VIEW'		=> 'Ver os meus uploads',
-	'TOPIC_INDEX_TOPICS_SELF'		=> 'Seus Uploads',
+	'TOPIC_INDEX_USER_TOPICS'			=> 'Partilhas',
+	'TOPIC_INDEX_USER_TOPICS_VIEW'		=> 'Ver partilhas do utilizador',
+	'TOPIC_INDEX_TOPICS_SELF'			=> 'Minhas Partilhas',
 
 	// On topic index page
-	'TOPIC_INDEX_USER_TOPICS_FILTERING'	=> 'de %1$s',
-	'TOPIC_INDEX_USER_TOPICS_NO_FILTER' => 'Click to list all.',
+	'TOPIC_INDEX_USER_TOPICS_FILTERING'	=> 'partilhadas por %1$s',
+	'TOPIC_INDEX_USER_TOPICS_NO_FILTER' => 'Clique para listar todos',
 ]);
diff --git "[FORUM_EXT]/kasimi\\topicindexusertopics/language/pt_preao/common.php" "[FORUM_EXT]/kasimi\\topicindexusertopics/language/pt_preao/common.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/kasimi\\topicindexusertopics/language/pt_preao/common.php"
@@ -0,0 +1,46 @@
+<?php
+
+/**
+ *
+ * Topic Index - User Topics. An extension for the phpBB Forum Software package.
+ *
+ * @copyright (c) 2018 kasimi - https://kasimi.net
+ * @license GNU General Public License, version 2 (GPL-2.0)
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
+//
+// Some characters for use
+// ’ » “ ” …
+
+$lang = array_merge($lang, [
+	// On viewprofile
+	'TOPIC_INDEX_USER_TOPICS'			=> 'Partilhas',
+	'TOPIC_INDEX_USER_TOPICS_VIEW'		=> 'Ver partilhas do utilizador',
+	'TOPIC_INDEX_TOPICS_SELF'			=> 'Minhas Partilhas',
+
+	// On topic index page
+	'TOPIC_INDEX_USER_TOPICS_FILTERING'	=> 'partilhadas por %1$s',
+	'TOPIC_INDEX_USER_TOPICS_NO_FILTER' => 'Clique para listar todos',
+]);
```
