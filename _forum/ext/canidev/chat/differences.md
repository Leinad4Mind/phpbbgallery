Existem diferencas reais no codigo ou texto. Diferencas de formatacao (espacos, tabs) foram ignoradas abaixo.

```diff
diff --git "[ORIGINAL]/canidev\\chat/acp/main_info.php" "[FORUM_EXT]/canidev\\chat/acp/main_info.php"
--- "[ORIGINAL]/canidev\\chat/acp/main_info.php"
+++ "[FORUM_EXT]/canidev\\chat/acp/main_info.php"
@@ -1,9 +1,9 @@
 <?php
 /**
  * @package cBB Chat
- * @version 1.2.7 07/03/2025
+ * @version 1.2.6 01/07/2024
  *
- * @copyright (c) 2025 CaniDev
+ * @copyright (c) 2024 CaniDev
  * @license https://creativecommons.org/licenses/by-nc/4.0/
  */
 
@@ -16,7 +16,7 @@ class main_info
 		return [
 			'filename'	=> '\canidev\chat\acp\main_module',
 			'title'		=> 'ACP_CAT_CHAT',
-			'version'	=> '1.2.7',
+			'version'	=> '1.2.6',
 			'modes'		=> [
 				'config'	=> ['title' => 'ACP_CHAT_CONFIG', 	'auth' => 'ext_canidev/chat && acl_a_chat', 'cat' => ['ACP_CAT_CHAT']],
 				'pages'		=> ['title' => 'ACP_CHAT_PAGES', 	'auth' => 'ext_canidev/chat && acl_a_chat', 'cat' => ['ACP_CAT_CHAT']],
diff --git "[ORIGINAL]/canidev\\chat/acp/main_module.php" "[FORUM_EXT]/canidev\\chat/acp/main_module.php"
--- "[ORIGINAL]/canidev\\chat/acp/main_module.php"
+++ "[FORUM_EXT]/canidev\\chat/acp/main_module.php"
@@ -1,9 +1,9 @@
 <?php
 /**
  * @package cBB Chat
- * @version 1.2.7 07/03/2025
+ * @version 1.2.6 01/07/2024
  *
- * @copyright (c) 2025 CaniDev
+ * @copyright (c) 2024 CaniDev
  * @license https://creativecommons.org/licenses/by-nc/4.0/
  */
 
diff --git "[ORIGINAL]/canidev\\chat/adm/style/acp.css" "[FORUM_EXT]/canidev\\chat/adm/style/acp.css"
--- "[ORIGINAL]/canidev\\chat/adm/style/acp.css"
+++ "[FORUM_EXT]/canidev\\chat/adm/style/acp.css"
@@ -1,7 +1,7 @@
 /*  cBB Chat StyleSheet
     --------------------------------------------------------------
 	Style:	Admin
-	Copyright (c) 2025 CaniDev ( https://www.canidev.com )
+	Copyright (c) 2024 CaniDev ( https://www.canidev.com )
     --------------------------------------------------------------
 */
 
diff --git "[ORIGINAL]/canidev\\chat/adm/style/js/jchat-acp.js" "[FORUM_EXT]/canidev\\chat/adm/style/js/jchat-acp.js"
--- "[ORIGINAL]/canidev\\chat/adm/style/js/jchat-acp.js"
+++ "[FORUM_EXT]/canidev\\chat/adm/style/js/jchat-acp.js"
@@ -1,8 +1,8 @@
 /**
  * @package cBB Chat
- * @version 1.2.7 10/03/2025
+ * @version 1.2.6 01/07/2024
  *
- * @copyright (c) 2025 CaniDev
+ * @copyright (c) 2024 CaniDev
  * @license https://creativecommons.org/licenses/by-nc/4.0/
  */
-((t,e)=>{t("#page_file").change(function(){var e=t(this).val(),i="viewforum"==e||"viewtopic"==e,e="-"==e;t("dl:has(#forum_ids)").objView(i),t("dl:has(#custom_file), dl:has(#page_alias)").objView(e)}).change(),t(".pagerow-input").click(function(){this.focus(),this.select()});var i=t("form:first"),a=!1;t(".sortable-text ul").sortable({update:function(){a||(a=!0,e.request({url:i.attr("action"),data:i.serialize(),onComplete:function(){a=!1}}))}}).disableSelection()})(jQuery,cbbCore);
\ No newline at end of file
+!function(i,e){"use strict";i("#page_file").change(function(){var e=i(this).val(),t="viewforum"==e||"viewtopic"==e,e="-"==e;i("dl:has(#forum_ids)").objView(t),i("dl:has(#custom_file), dl:has(#page_alias)").objView(e)}).change(),i(".pagerow-input").click(function(){this.focus(),this.select()});var t=i("form:first"),a=!1;i(".sortable-text ul").sortable({update:function(){a||(a=!0,e.request({url:t.attr("action"),data:t.serialize(),onComplete:function(){a=!1}}))}}).disableSelection()}(jQuery,cbbCore);
\ No newline at end of file
diff --git "[ORIGINAL]/canidev\\chat/composer.json" "[FORUM_EXT]/canidev\\chat/composer.json"
--- "[ORIGINAL]/canidev\\chat/composer.json"
+++ "[FORUM_EXT]/canidev\\chat/composer.json"
@@ -3,7 +3,7 @@
 	"type": "phpbb-extension",
 	"description": "",
 	"homepage": "https://www.canidev.com",
-	"version": "1.2.7",
+	"version": "1.2.6",
 	"keywords": ["phpbb", "extension", "canidev", "chat"],
 	"license": "CreativeCommons Attribution-NonCommercial v4.0",
 	"authors": [
diff --git "[ORIGINAL]/canidev\\chat/controller/admin_controller_base.php" "[FORUM_EXT]/canidev\\chat/controller/admin_controller_base.php"
--- "[ORIGINAL]/canidev\\chat/controller/admin_controller_base.php"
+++ "[FORUM_EXT]/canidev\\chat/controller/admin_controller_base.php"
@@ -1,9 +1,9 @@
 <?php
 /**
  * @package cBB Chat
- * @version 1.2.7 07/03/2025
+ * @version 1.2.6 01/07/2024
  *
- * @copyright (c) 2025 CaniDev
+ * @copyright (c) 2024 CaniDev
  * @license https://creativecommons.org/licenses/by-nc/4.0/
  */
 
diff --git "[ORIGINAL]/canidev\\chat/controller/admin_controller_config.php" "[FORUM_EXT]/canidev\\chat/controller/admin_controller_config.php"
--- "[ORIGINAL]/canidev\\chat/controller/admin_controller_config.php"
+++ "[FORUM_EXT]/canidev\\chat/controller/admin_controller_config.php"
@@ -1,9 +1,9 @@
 <?php
 /**
  * @package cBB Chat
- * @version 1.2.7 07/03/2025
+ * @version 1.2.6 01/07/2024
  *
- * @copyright (c) 2025 CaniDev
+ * @copyright (c) 2024 CaniDev
  * @license https://creativecommons.org/licenses/by-nc/4.0/
  */
 
diff --git "[ORIGINAL]/canidev\\chat/controller/admin_controller_pages.php" "[FORUM_EXT]/canidev\\chat/controller/admin_controller_pages.php"
--- "[ORIGINAL]/canidev\\chat/controller/admin_controller_pages.php"
+++ "[FORUM_EXT]/canidev\\chat/controller/admin_controller_pages.php"
@@ -1,9 +1,9 @@
 <?php
 /**
  * @package cBB Chat
- * @version 1.2.7 07/03/2025
+ * @version 1.2.6 01/07/2024
  *
- * @copyright (c) 2025 CaniDev
+ * @copyright (c) 2024 CaniDev
  * @license https://creativecommons.org/licenses/by-nc/4.0/
  */
 
diff --git "[ORIGINAL]/canidev\\chat/controller/admin_controller_rooms.php" "[FORUM_EXT]/canidev\\chat/controller/admin_controller_rooms.php"
--- "[ORIGINAL]/canidev\\chat/controller/admin_controller_rooms.php"
+++ "[FORUM_EXT]/canidev\\chat/controller/admin_controller_rooms.php"
@@ -1,9 +1,9 @@
 <?php
 /**
  * @package cBB Chat
- * @version 1.2.7 07/03/2025
+ * @version 1.2.6 01/07/2024
  *
- * @copyright (c) 2025 CaniDev
+ * @copyright (c) 2024 CaniDev
  * @license https://creativecommons.org/licenses/by-nc/4.0/
  */
 
@@ -84,7 +84,7 @@ class admin_controller_rooms extends admin_controller_base
 				
 				$room_auth = @unserialize($room_data['room_data']);
 
-				$room_data['room_groups'] 	= empty($room_auth['groups']) ? '' : $room_auth['groups'];
+				$room_data['room_groups'] 	= $room_auth['groups'];
 				$room_data['room_users']	= (empty($room_auth['users']) ? '' : implode("\n", $room_auth['users']));
 				$room_data['linked_forums']	= (empty($room_auth['linked_forums']) ? [] : $room_auth['linked_forums']);
 				$room_data['linked_groups']	= (empty($room_auth['linked_groups']) ? [] : $room_auth['linked_groups']);
diff --git "[ORIGINAL]/canidev\\chat/controller/admin_controller_texts.php" "[FORUM_EXT]/canidev\\chat/controller/admin_controller_texts.php"
--- "[ORIGINAL]/canidev\\chat/controller/admin_controller_texts.php"
+++ "[FORUM_EXT]/canidev\\chat/controller/admin_controller_texts.php"
@@ -1,9 +1,9 @@
 <?php
 /**
  * @package cBB Chat
- * @version 1.2.7 07/03/2025
+ * @version 1.2.6 01/07/2024
  *
- * @copyright (c) 2025 CaniDev
+ * @copyright (c) 2024 CaniDev
  * @license https://creativecommons.org/licenses/by-nc/4.0/
  */
 
diff --git "[ORIGINAL]/canidev\\chat/controller/main_controller.php" "[FORUM_EXT]/canidev\\chat/controller/main_controller.php"
--- "[ORIGINAL]/canidev\\chat/controller/main_controller.php"
+++ "[FORUM_EXT]/canidev\\chat/controller/main_controller.php"
@@ -1,9 +1,9 @@
 <?php
 /**
  * @package cBB Chat
- * @version 1.2.7 07/03/2025
+ * @version 1.2.6 01/07/2024
  *
- * @copyright (c) 2025 CaniDev
+ * @copyright (c) 2024 CaniDev
  * @license https://creativecommons.org/licenses/by-nc/4.0/
  */
 
diff --git "[ORIGINAL]/canidev\\chat/controller/mcp_controller_config.php" "[FORUM_EXT]/canidev\\chat/controller/mcp_controller_config.php"
--- "[ORIGINAL]/canidev\\chat/controller/mcp_controller_config.php"
+++ "[FORUM_EXT]/canidev\\chat/controller/mcp_controller_config.php"
@@ -1,9 +1,9 @@
 <?php
 /**
  * @package cBB Chat
- * @version 1.2.7 07/03/2025
+ * @version 1.2.6 01/07/2024
  *
- * @copyright (c) 2025 CaniDev
+ * @copyright (c) 2024 CaniDev
  * @license https://creativecommons.org/licenses/by-nc/4.0/
  */
 
diff --git "[ORIGINAL]/canidev\\chat/cron/prune.php" "[FORUM_EXT]/canidev\\chat/cron/prune.php"
--- "[ORIGINAL]/canidev\\chat/cron/prune.php"
+++ "[FORUM_EXT]/canidev\\chat/cron/prune.php"
@@ -1,9 +1,9 @@
 <?php
 /**
  * @package cBB Chat
- * @version 1.2.7 07/03/2025
+ * @version 1.2.6 01/07/2024
  *
- * @copyright (c) 2025 CaniDev
+ * @copyright (c) 2024 CaniDev
  * @license https://creativecommons.org/licenses/by-nc/4.0/
  */
 
diff --git "[FORUM_EXT]/canidev\\chat/diff_full.tmp" "[FORUM_EXT]/canidev\\chat/diff_full.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/canidev\\chat/diff_full.tmp"
@@ -0,0 +1,980 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/acp/main_info.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/acp/main_info.php"
+index d789c1778..9ca4f8bd7 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/acp/main_info.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/acp/main_info.php"
+@@ -1,9 +1,9 @@
+ <?php
+ /**
+  * @package cBB Chat
+- * @version 1.2.7 07/03/2025
++ * @version 1.2.6 01/07/2024
+  *
+- * @copyright (c) 2025 CaniDev
++ * @copyright (c) 2024 CaniDev
+  * @license https://creativecommons.org/licenses/by-nc/4.0/
+  */
+ 
+@@ -16,7 +16,7 @@ class main_info
+ 		return [
+ 			'filename'	=> '\canidev\chat\acp\main_module',
+ 			'title'		=> 'ACP_CAT_CHAT',
+-			'version'	=> '1.2.7',
++			'version'	=> '1.2.6',
+ 			'modes'		=> [
+ 				'config'	=> ['title' => 'ACP_CHAT_CONFIG', 	'auth' => 'ext_canidev/chat && acl_a_chat', 'cat' => ['ACP_CAT_CHAT']],
+ 				'pages'		=> ['title' => 'ACP_CHAT_PAGES', 	'auth' => 'ext_canidev/chat && acl_a_chat', 'cat' => ['ACP_CAT_CHAT']],
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/acp/main_module.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/acp/main_module.php"
+index 13d6c4276..45a417adb 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/acp/main_module.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/acp/main_module.php"
+@@ -1,9 +1,9 @@
+ <?php
+ /**
+  * @package cBB Chat
+- * @version 1.2.7 07/03/2025
++ * @version 1.2.6 01/07/2024
+  *
+- * @copyright (c) 2025 CaniDev
++ * @copyright (c) 2024 CaniDev
+  * @license https://creativecommons.org/licenses/by-nc/4.0/
+  */
+ 
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/adm/style/acp.css" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/adm/style/acp.css"
+index 6896ea983..83f605e8f 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/adm/style/acp.css"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/adm/style/acp.css"
+@@ -1,7 +1,7 @@
+ /*  cBB Chat StyleSheet
+     --------------------------------------------------------------
+ 	Style:	Admin
+-	Copyright (c) 2025 CaniDev ( https://www.canidev.com )
++	Copyright (c) 2024 CaniDev ( https://www.canidev.com )
+     --------------------------------------------------------------
+ */
+ 
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/adm/style/js/jchat-acp.js" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/adm/style/js/jchat-acp.js"
+index 96b9defa6..e68ee4d8d 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/adm/style/js/jchat-acp.js"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/adm/style/js/jchat-acp.js"
+@@ -1,8 +1,8 @@
+ /**
+  * @package cBB Chat
+- * @version 1.2.7 10/03/2025
++ * @version 1.2.6 01/07/2024
+  *
+- * @copyright (c) 2025 CaniDev
++ * @copyright (c) 2024 CaniDev
+  * @license https://creativecommons.org/licenses/by-nc/4.0/
+  */
+-((t,e)=>{t("#page_file").change(function(){var e=t(this).val(),i="viewforum"==e||"viewtopic"==e,e="-"==e;t("dl:has(#forum_ids)").objView(i),t("dl:has(#custom_file), dl:has(#page_alias)").objView(e)}).change(),t(".pagerow-input").click(function(){this.focus(),this.select()});var i=t("form:first"),a=!1;t(".sortable-text ul").sortable({update:function(){a||(a=!0,e.request({url:i.attr("action"),data:i.serialize(),onComplete:function(){a=!1}}))}}).disableSelection()})(jQuery,cbbCore);
+\ No newline at end of file
++!function(i,e){"use strict";i("#page_file").change(function(){var e=i(this).val(),t="viewforum"==e||"viewtopic"==e,e="-"==e;i("dl:has(#forum_ids)").objView(t),i("dl:has(#custom_file), dl:has(#page_alias)").objView(e)}).change(),i(".pagerow-input").click(function(){this.focus(),this.select()});var t=i("form:first"),a=!1;i(".sortable-text ul").sortable({update:function(){a||(a=!0,e.request({url:t.attr("action"),data:t.serialize(),onComplete:function(){a=!1}}))}}).disableSelection()}(jQuery,cbbCore);
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/composer.json"
+index dd67bf684..dfb276799 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/composer.json"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/composer.json"
+@@ -3,7 +3,7 @@
+ 	"type": "phpbb-extension",
+ 	"description": "",
+ 	"homepage": "https://www.canidev.com",
+-	"version": "1.2.7",
++	"version": "1.2.6",
+ 	"keywords": ["phpbb", "extension", "canidev", "chat"],
+ 	"license": "CreativeCommons Attribution-NonCommercial v4.0",
+ 	"authors": [
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/controller/admin_controller_base.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/controller/admin_controller_base.php"
+index 3fb267289..49c832232 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/controller/admin_controller_base.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/controller/admin_controller_base.php"
+@@ -1,9 +1,9 @@
+ <?php
+ /**
+  * @package cBB Chat
+- * @version 1.2.7 07/03/2025
++ * @version 1.2.6 01/07/2024
+  *
+- * @copyright (c) 2025 CaniDev
++ * @copyright (c) 2024 CaniDev
+  * @license https://creativecommons.org/licenses/by-nc/4.0/
+  */
+ 
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/controller/admin_controller_config.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/controller/admin_controller_config.php"
+index 19af9ac74..0682e94e3 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/controller/admin_controller_config.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/controller/admin_controller_config.php"
+@@ -1,9 +1,9 @@
+ <?php
+ /**
+  * @package cBB Chat
+- * @version 1.2.7 07/03/2025
++ * @version 1.2.6 01/07/2024
+  *
+- * @copyright (c) 2025 CaniDev
++ * @copyright (c) 2024 CaniDev
+  * @license https://creativecommons.org/licenses/by-nc/4.0/
+  */
+ 
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/controller/admin_controller_pages.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/controller/admin_controller_pages.php"
+index dd2d10a8e..a9d01f499 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/controller/admin_controller_pages.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/controller/admin_controller_pages.php"
+@@ -1,9 +1,9 @@
+ <?php
+ /**
+  * @package cBB Chat
+- * @version 1.2.7 07/03/2025
++ * @version 1.2.6 01/07/2024
+  *
+- * @copyright (c) 2025 CaniDev
++ * @copyright (c) 2024 CaniDev
+  * @license https://creativecommons.org/licenses/by-nc/4.0/
+  */
+ 
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/controller/admin_controller_rooms.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/controller/admin_controller_rooms.php"
+index 0e45aa137..77817fe91 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/controller/admin_controller_rooms.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/controller/admin_controller_rooms.php"
+@@ -1,9 +1,9 @@
+ <?php
+ /**
+  * @package cBB Chat
+- * @version 1.2.7 07/03/2025
++ * @version 1.2.6 01/07/2024
+  *
+- * @copyright (c) 2025 CaniDev
++ * @copyright (c) 2024 CaniDev
+  * @license https://creativecommons.org/licenses/by-nc/4.0/
+  */
+ 
+@@ -84,7 +84,7 @@ class admin_controller_rooms extends admin_controller_base
+ 				
+ 				$room_auth = @unserialize($room_data['room_data']);
+ 
+-				$room_data['room_groups'] 	= empty($room_auth['groups']) ? '' : $room_auth['groups'];
++				$room_data['room_groups'] 	= $room_auth['groups'];
+ 				$room_data['room_users']	= (empty($room_auth['users']) ? '' : implode("\n", $room_auth['users']));
+ 				$room_data['linked_forums']	= (empty($room_auth['linked_forums']) ? [] : $room_auth['linked_forums']);
+ 				$room_data['linked_groups']	= (empty($room_auth['linked_groups']) ? [] : $room_auth['linked_groups']);
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/controller/admin_controller_texts.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/controller/admin_controller_texts.php"
+index f4150689f..ce07e1979 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/controller/admin_controller_texts.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/controller/admin_controller_texts.php"
+@@ -1,9 +1,9 @@
+ <?php
+ /**
+  * @package cBB Chat
+- * @version 1.2.7 07/03/2025
++ * @version 1.2.6 01/07/2024
+  *
+- * @copyright (c) 2025 CaniDev
++ * @copyright (c) 2024 CaniDev
+  * @license https://creativecommons.org/licenses/by-nc/4.0/
+  */
+ 
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/controller/main_controller.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/controller/main_controller.php"
+index 1a2647700..887ad620e 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/controller/main_controller.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/controller/main_controller.php"
+@@ -1,9 +1,9 @@
+ <?php
+ /**
+  * @package cBB Chat
+- * @version 1.2.7 07/03/2025
++ * @version 1.2.6 01/07/2024
+  *
+- * @copyright (c) 2025 CaniDev
++ * @copyright (c) 2024 CaniDev
+  * @license https://creativecommons.org/licenses/by-nc/4.0/
+  */
+ 
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/controller/mcp_controller_config.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/controller/mcp_controller_config.php"
+index cff15c94b..d800087af 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/controller/mcp_controller_config.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/controller/mcp_controller_config.php"
+@@ -1,9 +1,9 @@
+ <?php
+ /**
+  * @package cBB Chat
+- * @version 1.2.7 07/03/2025
++ * @version 1.2.6 01/07/2024
+  *
+- * @copyright (c) 2025 CaniDev
++ * @copyright (c) 2024 CaniDev
+  * @license https://creativecommons.org/licenses/by-nc/4.0/
+  */
+ 
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/cron/prune.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/cron/prune.php"
+index fee3e3579..6608f9b33 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/cron/prune.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/cron/prune.php"
+@@ -1,9 +1,9 @@
+ <?php
+ /**
+  * @package cBB Chat
+- * @version 1.2.7 07/03/2025
++ * @version 1.2.6 01/07/2024
+  *
+- * @copyright (c) 2025 CaniDev
++ * @copyright (c) 2024 CaniDev
+  * @license https://creativecommons.org/licenses/by-nc/4.0/
+  */
+ 
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/diff_full.tmp"
+new file mode 100644
+index 000000000..039fd3df7
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/diff_full.tmp"
+@@ -0,0 +1,146 @@
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/acp/main_info.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/acp/main_info.php"
++index d789c1778..9ca4f8bd7 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/acp/main_info.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/acp/main_info.php"
++@@ -1,9 +1,9 @@
++ <?php
++ /**
++  * @package cBB Chat
++- * @version 1.2.7 07/03/2025
+++ * @version 1.2.6 01/07/2024
++  *
++- * @copyright (c) 2025 CaniDev
+++ * @copyright (c) 2024 CaniDev
++  * @license https://creativecommons.org/licenses/by-nc/4.0/
++  */
++ 
++@@ -16,7 +16,7 @@ class main_info
++ 		return [
++ 			'filename'	=> '\canidev\chat\acp\main_module',
++ 			'title'		=> 'ACP_CAT_CHAT',
++-			'version'	=> '1.2.7',
+++			'version'	=> '1.2.6',
++ 			'modes'		=> [
++ 				'config'	=> ['title' => 'ACP_CHAT_CONFIG', 	'auth' => 'ext_canidev/chat && acl_a_chat', 'cat' => ['ACP_CAT_CHAT']],
++ 				'pages'		=> ['title' => 'ACP_CHAT_PAGES', 	'auth' => 'ext_canidev/chat && acl_a_chat', 'cat' => ['ACP_CAT_CHAT']],
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/acp/main_module.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/acp/main_module.php"
++index 13d6c4276..45a417adb 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/acp/main_module.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/acp/main_module.php"
++@@ -1,9 +1,9 @@
++ <?php
++ /**
++  * @package cBB Chat
++- * @version 1.2.7 07/03/2025
+++ * @version 1.2.6 01/07/2024
++  *
++- * @copyright (c) 2025 CaniDev
+++ * @copyright (c) 2024 CaniDev
++  * @license https://creativecommons.org/licenses/by-nc/4.0/
++  */
++ 
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/adm/style/acp.css" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/adm/style/acp.css"
++index 6896ea983..83f605e8f 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/adm/style/acp.css"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/adm/style/acp.css"
++@@ -1,7 +1,7 @@
++ /*  cBB Chat StyleSheet
++     --------------------------------------------------------------
++ 	Style:	Admin
++-	Copyright (c) 2025 CaniDev ( https://www.canidev.com )
+++	Copyright (c) 2024 CaniDev ( https://www.canidev.com )
++     --------------------------------------------------------------
++ */
++ 
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/adm/style/js/jchat-acp.js" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/adm/style/js/jchat-acp.js"
++index 96b9defa6..e68ee4d8d 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/adm/style/js/jchat-acp.js"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/adm/style/js/jchat-acp.js"
++@@ -1,8 +1,8 @@
++ /**
++  * @package cBB Chat
++- * @version 1.2.7 10/03/2025
+++ * @version 1.2.6 01/07/2024
++  *
++- * @copyright (c) 2025 CaniDev
+++ * @copyright (c) 2024 CaniDev
++  * @license https://creativecommons.org/licenses/by-nc/4.0/
++  */
++-((t,e)=>{t("#page_file").change(function(){var e=t(this).val(),i="viewforum"==e||"viewtopic"==e,e="-"==e;t("dl:has(#forum_ids)").objView(i),t("dl:has(#custom_file), dl:has(#page_alias)").objView(e)}).change(),t(".pagerow-input").click(function(){this.focus(),this.select()});var i=t("form:first"),a=!1;t(".sortable-text ul").sortable({update:function(){a||(a=!0,e.request({url:i.attr("action"),data:i.serialize(),onComplete:function(){a=!1}}))}}).disableSelection()})(jQuery,cbbCore);
++\ No newline at end of file
+++!function(i,e){"use strict";i("#page_file").change(function(){var e=i(this).val(),t="viewforum"==e||"viewtopic"==e,e="-"==e;i("dl:has(#forum_ids)").objView(t),i("dl:has(#custom_file), dl:has(#page_alias)").objView(e)}).change(),i(".pagerow-input").click(function(){this.focus(),this.select()});var t=i("form:first"),a=!1;i(".sortable-text ul").sortable({update:function(){a||(a=!0,e.request({url:t.attr("action"),data:t.serialize(),onComplete:function(){a=!1}}))}}).disableSelection()}(jQuery,cbbCore);
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/composer.json"
++index dd67bf684..dfb276799 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/composer.json"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/composer.json"
++@@ -3,7 +3,7 @@
++ 	"type": "phpbb-extension",
++ 	"description": "",
++ 	"homepage": "https://www.canidev.com",
++-	"version": "1.2.7",
+++	"version": "1.2.6",
++ 	"keywords": ["phpbb", "extension", "canidev", "chat"],
++ 	"license": "CreativeCommons Attribution-NonCommercial v4.0",
++ 	"authors": [
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/controller/admin_controller_base.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/controller/admin_controller_base.php"
++index 3fb267289..49c832232 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/controller/admin_controller_base.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/controller/admin_controller_base.php"
++@@ -1,9 +1,9 @@
++ <?php
++ /**
++  * @package cBB Chat
++- * @version 1.2.7 07/03/2025
+++ * @version 1.2.6 01/07/2024
++  *
++- * @copyright (c) 2025 CaniDev
+++ * @copyright (c) 2024 CaniDev
++  * @license https://creativecommons.org/licenses/by-nc/4.0/
++  */
++ 
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/controller/admin_controller_config.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/controller/admin_controller_config.php"
++index 19af9ac74..0682e94e3 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/controller/admin_controller_config.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/controller/admin_controller_config.php"
++@@ -1,9 +1,9 @@
++ <?php
++ /**
++  * @package cBB Chat
++- * @version 1.2.7 07/03/2025
+++ * @version 1.2.6 01/07/2024
++  *
++- * @copyright (c) 2025 CaniDev
+++ * @copyright (c) 2024 CaniDev
++  * @license https://creativecommons.org/licenses/by-nc/4.0/
++  */
++ 
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/controller/admin_controller_pages.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/controller/admin_controller_pages.php"
++index dd2d10a8e..a9d01f499 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/controller/admin_controller_pages.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/controller/admin_controller_pages.php"
++@@ -1,9 +1,9 @@
++ <?php
++ /**
++  * @package cBB Chat
++- * @version 1.2.7 07/03/2025
+++ * @version 1.2.6 01/07/2024
++  *
++- * @copyright (c) 2025 CaniDev
+++ * @copyright (c) 2024 CaniDev
++  * @license https://creativecommons.org/licenses/by-nc/4.0/
++  */
++ 
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/controller/admin_controller_rooms.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/controller/admin_controller_rooms.php"
++index 0e45aa137..77817fe91 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/controller/admin_controller_rooms.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/controller/admin_controller_rooms.php"
++@@ -1,9 +1,9 @@
++ <?php
++ /**
++  * @package cBB Chat
++- * @version 1.2.7 07/03/2025
+++ * @version 1.2.6 01/07/2024
++  *
++- * @copyright (c) 2025 CaniDev
+++ * @copyright (c) 2
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/event/listener.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/event/listener.php"
+index a3943ba8c..1acc61ec5 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/event/listener.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/event/listener.php"
+@@ -1,9 +1,9 @@
+ <?php
+ /**
+  * @package cBB Chat
+- * @version 1.2.7 07/03/2025
++ * @version 1.2.6 01/07/2024
+  *
+- * @copyright (c) 2025 CaniDev
++ * @copyright (c) 2024 CaniDev
+  * @license https://creativecommons.org/licenses/by-nc/4.0/
+  */
+ 
+@@ -47,7 +47,7 @@ class listener implements EventSubscriberInterface
+ 	{
+ 		return [
+ 			'core.user_setup'					=> 'load_language',
+-			'core.user_setup_after'				=> ['on_setup_after', -2],
++			'core.user_setup_after'				=> 'on_setup_after',
+ 			'core.session_kill_after'			=> 'on_user_logout',
+ 			'core.page_footer'					=> 'on_footer',
+ 			'core.delete_user_after'			=> 'on_user_delete',
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/ext.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/ext.php"
+index 5d40fd3fd..7162db7dd 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/ext.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/ext.php"
+@@ -1,9 +1,9 @@
+ <?php
+ /**
+  * @package cBB Chat
+- * @version 1.2.7 07/03/2025
++ * @version 1.2.6 01/07/2024
+  *
+- * @copyright (c) 2025 CaniDev
++ * @copyright (c) 2024 CaniDev
+  * @license https://creativecommons.org/licenses/by-nc/4.0/
+  */
+ 
+@@ -12,7 +12,7 @@ namespace canidev\chat;
+ class ext extends \phpbb\extension\base
+ {
+ 	const REQUIRED_PHPBB	= '3.2.0';
+-	const REQUIRED_CORE		= '1.1.10';
++	const REQUIRED_CORE		= '1.1.6';
+ 
+ 	/**
+ 	 * {@inheritDoc}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/language/en/acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/language/en/acp.php"
+index aaf16c342..f891159c6 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/language/en/acp.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/language/en/acp.php"
+@@ -2,9 +2,9 @@
+ /**
+  * [English [En]]
+  * @package cBB Chat
+- * @version 1.2.7 07/03/2025
++ * @version 1.2.6 01/07/2024
+  *
+- * @copyright (c) 2025 CaniDev
++ * @copyright (c) 2024 CaniDev
+  * @license https://creativecommons.org/licenses/by-nc/4.0/
+  */
+ 
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/language/en/info_acp_chat.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/language/en/info_acp_chat.php"
+index 4417e0c3e..5e23be08d 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/language/en/info_acp_chat.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/language/en/info_acp_chat.php"
+@@ -2,9 +2,9 @@
+ /**
+  * [English [En]]
+  * @package cBB Chat
+- * @version 1.2.7 07/03/2025
++ * @version 1.2.6 01/07/2024
+  *
+- * @copyright (c) 2025 CaniDev
++ * @copyright (c) 2024 CaniDev
+  * @license https://creativecommons.org/licenses/by-nc/4.0/
+  */
+ 
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/language/en/info_mcp_chat.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/language/en/info_mcp_chat.php"
+index ea86ca26c..cde907a48 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/language/en/info_mcp_chat.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/language/en/info_mcp_chat.php"
+@@ -2,9 +2,9 @@
+ /**
+  * [English [En]]
+  * @package cBB Chat
+- * @version 1.2.7 07/03/2025
++ * @version 1.2.6 01/07/2024
+  *
+- * @copyright (c) 2025 CaniDev
++ * @copyright (c) 2024 CaniDev
+  * @license https://creativecommons.org/licenses/by-nc/4.0/
+  */
+ 
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/language/en/main.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/language/en/main.php"
+index 9c1339bdc..ddf028bac 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/language/en/main.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/language/en/main.php"
+@@ -2,9 +2,9 @@
+ /**
+  * [English [En]]
+  * @package cBB Chat
+- * @version 1.2.7 07/03/2025
++ * @version 1.2.6 01/07/2024
+  *
+- * @copyright (c) 2025 CaniDev
++ * @copyright (c) 2024 CaniDev
+  * @license https://creativecommons.org/licenses/by-nc/4.0/
+  */
+ 
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/language/en/permissions_chat.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/language/en/permissions_chat.php"
+index 9d86befeb..64e2e9277 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/language/en/permissions_chat.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/language/en/permissions_chat.php"
+@@ -2,9 +2,9 @@
+ /**
+  * [English [En]]
+  * @package cBB Chat
+- * @version 1.2.7 07/03/2025
++ * @version 1.2.6 01/07/2024
+  *
+- * @copyright (c) 2025 CaniDev
++ * @copyright (c) 2024 CaniDev
+  * @license https://creativecommons.org/licenses/by-nc/4.0/
+  */
+ 
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/language/es/acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/language/es/acp.php"
+index 8a116fe62..4e64b2644 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/language/es/acp.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/language/es/acp.php"
+@@ -2,9 +2,9 @@
+ /**
+  * [Spanish [Es]]
+  * @package cBB Chat
+- * @version 1.2.7 07/03/2025
++ * @version 1.2.6 01/07/2024
+  *
+- * @copyright (c) 2025 CaniDev
++ * @copyright (c) 2024 CaniDev
+  * @license https://creativecommons.org/licenses/by-nc/4.0/
+  */
+ 
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/language/es/info_acp_chat.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/language/es/info_acp_chat.php"
+index d7ac7a2ef..5fb9a0237 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/language/es/info_acp_chat.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/language/es/info_acp_chat.php"
+@@ -2,9 +2,9 @@
+ /**
+  * [Spanish [Es]]
+  * @package cBB Chat
+- * @version 1.2.7 07/03/2025
++ * @version 1.2.6 01/07/2024
+  *
+- * @copyright (c) 2025 CaniDev
++ * @copyright (c) 2024 CaniDev
+  * @license https://creativecommons.org/licenses/by-nc/4.0/
+  */
+ 
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/language/es/info_mcp_chat.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/language/es/info_mcp_chat.php"
+index 65933ff92..ec0b36117 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/language/es/info_mcp_chat.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/language/es/info_mcp_chat.php"
+@@ -2,9 +2,9 @@
+ /**
+  * [Spanish [Es]]
+  * @package cBB Chat
+- * @version 1.2.7 07/03/2025
++ * @version 1.2.6 01/07/2024
+  *
+- * @copyright (c) 2025 CaniDev
++ * @copyright (c) 2024 CaniDev
+  * @license https://creativecommons.org/licenses/by-nc/4.0/
+  */
+ 
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/language/es/main.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/language/es/main.php"
+index 91028d26c..a1de87c5f 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/language/es/main.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/language/es/main.php"
+@@ -2,9 +2,9 @@
+ /**
+  * [Spanish [Es]]
+  * @package cBB Chat
+- * @version 1.2.7 07/03/2025
++ * @version 1.2.6 01/07/2024
+  *
+- * @copyright (c) 2025 CaniDev
++ * @copyright (c) 2024 CaniDev
+  * @license https://creativecommons.org/licenses/by-nc/4.0/
+  */
+ 
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/language/es/permissions_chat.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/language/es/permissions_chat.php"
+index 078503bcd..08f7e420b 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/language/es/permissions_chat.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/language/es/permissions_chat.php"
+@@ -2,9 +2,9 @@
+ /**
+  * [Spanish [Es]]
+  * @package cBB Chat
+- * @version 1.2.7 07/03/2025
++ * @version 1.2.6 01/07/2024
+  *
+- * @copyright (c) 2025 CaniDev
++ * @copyright (c) 2024 CaniDev
+  * @license https://creativecommons.org/licenses/by-nc/4.0/
+  */
+ 
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/libraries/action_manager.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/libraries/action_manager.php"
+index 8b299885f..b08d63b59 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/libraries/action_manager.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/libraries/action_manager.php"
+@@ -1,9 +1,9 @@
+ <?php
+ /**
+  * @package cBB Chat
+- * @version 1.2.7 07/03/2025
++ * @version 1.2.6 01/07/2024
+  *
+- * @copyright (c) 2025 CaniDev
++ * @copyright (c) 2024 CaniDev
+  * @license https://creativecommons.org/licenses/by-nc/4.0/
+  */
+ 
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/libraries/chat.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/libraries/chat.php"
+index d6295e372..d4835cc5a 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/libraries/chat.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/libraries/chat.php"
+@@ -1,9 +1,9 @@
+ <?php
+ /**
+  * @package cBB Chat
+- * @version 1.2.7 07/03/2025
++ * @version 1.2.6 01/07/2024
+  *
+- * @copyright (c) 2025 CaniDev
++ * @copyright (c) 2024 CaniDev
+  * @license https://creativecommons.org/licenses/by-nc/4.0/
+  */
+ 
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/libraries/constants.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/libraries/constants.php"
+index 2a61d4905..85cc8a1bb 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/libraries/constants.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/libraries/constants.php"
+@@ -1,9 +1,9 @@
+ <?php
+ /**
+  * @package cBB Chat
+- * @version 1.2.7 07/03/2025
++ * @version 1.2.6 01/07/2024
+  *
+- * @copyright (c) 2025 CaniDev
++ * @copyright (c) 2024 CaniDev
+  * @license https://creativecommons.org/licenses/by-nc/4.0/
+  */
+ 
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/mcp/main_info.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/mcp/main_info.php"
+index 17685b7e6..324fda17f 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/mcp/main_info.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/mcp/main_info.php"
+@@ -1,9 +1,9 @@
+ <?php
+ /**
+  * @package cBB Chat
+- * @version 1.2.7 07/03/2025
++ * @version 1.2.6 01/07/2024
+  *
+- * @copyright (c) 2025 CaniDev
++ * @copyright (c) 2024 CaniDev
+  * @license https://creativecommons.org/licenses/by-nc/4.0/
+  */
+ 
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/mcp/main_module.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/mcp/main_module.php"
+index 058406ae5..c967cef09 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/mcp/main_module.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/mcp/main_module.php"
+@@ -1,9 +1,9 @@
+ <?php
+ /**
+  * @package cBB Chat
+- * @version 1.2.7 07/03/2025
++ * @version 1.2.6 01/07/2024
+  *
+- * @copyright (c) 2025 CaniDev
++ * @copyright (c) 2024 CaniDev
+  * @license https://creativecommons.org/licenses/by-nc/4.0/
+  */
+ 
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/migrations/v110.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/migrations/v110.php"
+index d3e28d64b..3af724375 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/migrations/v110.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/migrations/v110.php"
+@@ -14,7 +14,7 @@ class v110 extends \phpbb\db\migration\migration
+ {
+ 	public function effectively_installed()
+ 	{
+-		return $this->db_tools->sql_table_exists($this->table_prefix . 'chat_messages');
++		return isset($this->config['chat_version']) && version_compare($this->config['chat_version'], '1.1.0', '>=');
+ 	}
+ 
+ 	public function update_schema()
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/migrations/v111.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/migrations/v111.php"
+index ff8ce2c64..a1b9cf86e 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/migrations/v111.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/migrations/v111.php"
+@@ -17,8 +17,7 @@ class v111 extends \phpbb\db\migration\migration
+ 	 */
+ 	public function effectively_installed()
+ 	{
+-		// "chat_version" is deprecated, migration ignored
+-		return true;
++		return isset($this->config['chat_version']) && version_compare($this->config['chat_version'], '1.1.1', '>=');
+ 	}
+ 
+ 	/**
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/migrations/v112.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/migrations/v112.php"
+index 3e7b634b1..7ce5e3b46 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/migrations/v112.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/migrations/v112.php"
+@@ -17,7 +17,7 @@ class v112 extends \phpbb\db\migration\migration
+ 	 */
+ 	public function effectively_installed()
+ 	{
+-		return $this->db_tools->sql_column_exists($this->table_prefix . 'chat_rooms', 'room_autopurge_time');
++		return isset($this->config['chat_version']) && version_compare($this->config['chat_version'], '1.1.2', '>=');
+ 	}
+ 
+ 	/**
+@@ -72,7 +72,7 @@ class v112 extends \phpbb\db\migration\migration
+ 		
+ 		if(!empty($this->config['chat_show_topics']))
+ 		{
+-			$this->config->set('chat_forum_posts', 1);
++			set_config('chat_forum_posts', 1);
+ 		}
+ 	}
+ }
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/migrations/v113.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/migrations/v113.php"
+index a4a795399..622c80679 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/migrations/v113.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/migrations/v113.php"
+@@ -14,7 +14,7 @@ class v113 extends \phpbb\db\migration\migration
+ {
+ 	public function effectively_installed()
+ 	{
+-		return $this->config->offsetExists('chat_purge_mark');
++		return isset($this->config['chat_version']) && version_compare($this->config['chat_version'], '1.1.3', '>=');
+ 	}
+ 
+ 	static public function depends_on()
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/migrations/v120.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/migrations/v120.php"
+index c786bcaae..a397a9228 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/migrations/v120.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/migrations/v120.php"
+@@ -13,7 +13,7 @@ class v120 extends \phpbb\db\migration\migration
+ {
+ 	public function effectively_installed()
+ 	{
+-		return $this->db_tools->sql_column_exists($this->table_prefix . 'chat_users', 'user_groups');
++		return isset($this->config['chat_version']) && version_compare($this->config['chat_version'], '1.2.0', '>=');
+ 	}
+ 
+ 	static public function depends_on()
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/migrations/v121.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/migrations/v121.php"
+index f9c707cc2..b7c4a9f69 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/migrations/v121.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/migrations/v121.php"
+@@ -13,7 +13,7 @@ class v121 extends \phpbb\db\migration\migration
+ {
+ 	public function effectively_installed()
+ 	{
+-		return $this->config->offsetExists('chat_hide_popup');
++		return isset($this->config['chat_version']) && version_compare($this->config['chat_version'], '1.2.1', '>=');
+ 	}
+ 
+ 	static public function depends_on()
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/migrations/v122.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/migrations/v122.php"
+index 1af49052c..d9fb1e6ee 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/migrations/v122.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/migrations/v122.php"
+@@ -13,7 +13,7 @@ class v122 extends \phpbb\db\migration\migration
+ {
+ 	public function effectively_installed()
+ 	{
+-		return $this->config->offsetExists('chat_row_align');
++		return isset($this->config['chat_version']) && version_compare($this->config['chat_version'], '1.2.2', '>=');
+ 	}
+ 
+ 	static public function depends_on()
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/migrations/v123.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/migrations/v123.php"
+index 14e58c591..72c483872 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/migrations/v123.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/migrations/v123.php"
+@@ -16,8 +16,7 @@ class v123 extends \phpbb\db\migration\migration
+ 	 */
+ 	public function effectively_installed()
+ 	{
+-		// "chat_version" is deprecated, migration ignored
+-		return true;
++		return isset($this->config['chat_version']) && version_compare($this->config['chat_version'], '1.2.3', '>=');
+ 	}
+ 
+ 	/**
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/migrations/v124.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/migrations/v124.php"
+index 526ae8d85..04e7819f1 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/migrations/v124.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/migrations/v124.php"
+@@ -16,8 +16,7 @@ class v124 extends \phpbb\db\migration\migration
+ 	 */
+ 	public function effectively_installed()
+ 	{
+-		// "chat_version" is deprecated, migration ignored
+-		return true;
++		return isset($this->config['chat_version']) && version_compare($this->config['chat_version'], '1.2.4', '>=');
+ 	}
+ 
+ 	/**
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/migrations/v125.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/migrations/v125.php"
+index fb2ab31e6..b66d2c46b 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/migrations/v125.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/migrations/v125.php"
+@@ -16,8 +16,7 @@ class v125 extends \phpbb\db\migration\migration
+ 	 */
+ 	public function effectively_installed()
+ 	{
+-		// "chat_version" is deprecated, migration ignored
+-		return true;
++		return isset($this->config['chat_version']) && version_compare($this->config['chat_version'], '1.2.5', '>=');
+ 	}
+ 
+ 	/**
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/migrations/v126.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/migrations/v126.php"
+index 143d90d4d..2557ac4c6 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/migrations/v126.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/migrations/v126.php"
+@@ -16,8 +16,7 @@ class v126 extends \phpbb\db\migration\migration
+ 	 */
+ 	public function effectively_installed()
+ 	{
+-		// "chat_version" is deprecated, migration ignored
+-		return true;
++		return isset($this->config['chat_version']) && version_compare($this->config['chat_version'], '1.2.6', '>=');
+ 	}
+ 
+ 	/**
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/migrations/v127.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/migrations/v127.php"
+deleted file mode 100644
+index 5b1433311..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/migrations/v127.php"
++++ /dev/null
+@@ -1,41 +0,0 @@
+-<?php
+-/**
+- * @package cBB Chat
+- * @version 1.2.7 07/03/2025
+- *
+- * @copyright (c) 2025 CaniDev
+- * @license https://creativecommons.org/licenses/by-nc/4.0/
+- */
+-
+-namespace canidev\chat\migrations;
+-
+-class v127 extends \phpbb\db\migration\migration
+-{
+-	/**
+-	 * {@inheritDoc}
+-	 */
+-	public function effectively_installed()
+-	{
+-		return $this->config->offsetExists('chat_cron_lock') && !$this->config->offsetExists('chat_version');
+-	}
+-
+-	/**
+-	 * {@inheritDoc}
+-	 */
+-	static public function depends_on()
+-	{
+-		return [
+-			'\canidev\chat\migrations\v126',
+-		];
+-	}
+-
+-	/**
+-	 * {@inheritDoc}
+-	 */
+-	public function update_data()
+-	{
+-		return [
+-			['config.remove',	['chat_version']],
+-		];
+-	}
+-}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/styles/all/template/js/jchat-options.js" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/styles/all/template/js/jchat-options.js"
+index cac86630a..e0d76b310 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/styles/all/template/js/jchat-options.js"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/styles/all/template/js/jchat-options.js"
+@@ -1,9 +1,9 @@
+ /**
+  * @package cBB Chat
+  * @style: All
+- * @version 1.2.7 07/03/2025
++ * @version 1.2.5 15/01/2023
+  *
+- * @copyright (c) 2025 CaniDev
++ * @copyright (c) 2023 CaniDev
+  * @license https://creativecommons.org/licenses/by-nc/4.0/
+  */
+ 
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/styles/all/template/js/jchat.min.js" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/styles/all/template/js/jchat.min.js"
+index f7f25e944..7187d636d 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/styles/all/template/js/jchat.min.js"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/styles/all/template/js/jchat.min.js"
+@@ -1,10 +1,10 @@
+ /**
+  * @package cBB Chat
+- * @version 1.2.7 10/03/2025
++ * @version 1.2.6 01/07/2024
+  *
+- * @copyright (c) 2025 CaniDev
++ * @copyright (c) 2024 CaniDev
+  * @license https://creativecommons.org/licenses/by-nc/4.0/
+  */
+-((p,m)=>{var e=null,o=null,f=null,i=!1,n=!1,s=!1,v=0,b=0,g=0,a=0,c=0,r=null,w=[];m.registerService("chat",{activeBox:null,connected:!1,currentRoom:!1,dom:null,method:"append",openRooms:[],tempDom:p("<div />"),editor:null,scrolling:!1,audio:new Audio,options:{autoconnect:!1,defaultRoom:0,direction:"down",floodTime:0,guestRoom:1,height:220,hidePopup:!1,imgSelector:".postimage",maxChars:0,maxRows:25,mode:"chat",noticeTimeout:2e4,page:"",soundPath:null,position:"bottom",refresh:5e3,tipTimeout:15e3},positions:{},tpl:{conversation:'<div class="ic-conversation js-conversation-<%ROOM_ID%>"></div>',sep:'<div class="sep"></div>',tab:'<li id="chat-tab-<%ROOM_ID%>"><%TITLE%> <a href="#" class="tab-close"><i class="fa fa-times-circle" aria-hidden="true"></i></a></li>',userlist:'<ul class="ic-userlist js-userlist-<%ROOM_ID%>"></ul>'},__construct:function(){var e=this;if(this.options.defaultRoom=this.options.defaultRoom||this.options.guestRoom,m.dispatchEvent("chat.beforeInit",this),"archive"===this.options.mode)this.bindRows(),p('[data-action="mark"], [data-action="unmark"]').click(function(t){t.preventDefault();var t="mark"==p(this).data("action"),e=t?"show":"hide",t=(p('input[name^="row_id_list"]').prop("checked",t),p(".chat-row .ic-row-actions").has(".row-id-list"));t[e].call(t)});else{if("up"==this.options.direction&&(this.method="prepend"),this.dom=p("#chat-body"),!(this.dom.length&&this.options.guestRoom&&this.options.height&&this.options.maxRows))return!1;void 0!==window.jchat_style_options&&(this.positions=window.jchat_style_options.positions);var t=!1;if("custom"==this.options.page&&this.positions.chat)t=this.positions.chat;else if("custom"!=this.options.page&&this.options.position){var o={};if(this.positions[this.options.page])o=this.positions[this.options.page];else{if(!this.positions.undefined)return!1;o=this.positions.undefined}t=o[this.options.position]}!1!==t&&(0==p(t[0]).length&&this.positions.undefined&&this.options.position&&(t=this.positions.undefined[this.options.position]),o=p(t[0]),t=t[1],1==(o=1<o.length?p(o[0]):o).length)&&o[t].apply(o,[this.dom]),m.colourIsDark(this.dom.find("#chat-content").css("background-color"),170)&&this.dom.addClass("dark-theme"),this.dom.objView(!0),m.browser.isMobile&&(p("head meta[name=viewport]").remove(),p("head").prepend('<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />')),p("#chat-conversation-container").on("scroll",function(){"up"==e.options.direction&&0<this.scrollTop||"down"==e.options.direction&&this.scrollTop<this.scrollHeight-this.offsetHeight?(e.scrolling=!0,p(".chat-scroll-button").objView(!0)):(e.scrolling=!1,p(".chat-scroll-button").objView(!1))}),p(".chat-scroll-button").addClass(e.options.direction).click(function(t){t.preventDefault(),e.scrollRoom()});t={autoClose:!1,minSize:180,yPosition:"top",wrapper:this.dom,onOpen:function(){e.closeActiveBox(),e.activeBox=this},onClose:function(){e.activeBox=null}},o=(this.dom.find('a[data-action="showbox"]').cbbDropdown(p.extend({},t,{adjustMethod:"resize"})),this.dom.find('a[data-action="color"]').cbbColorPicker(p.extend({},t,{realTimeUpdate:!1,onChange:function(t){e.editor.insertBBcode("color",t),e.options.hidePopup&&e.closeActiveBox()}})),this.dom.find("a[data-action]").filter(function(){return!p(this).data("cbbDropdown")}).click(p.proxy(this,"eventDispatch")),this.bindLinks(this.dom),this.collapsable("init"),1==this.cookie("mute")&&this.player("mute",!0),p("#chat-conversation-container").css("height",this.options.height),p("#chat-right-panel").css("height",this.options.height+p("#chat-tabs").height()),p("#chat-toolbar a").addClass("chat-corner-top chat-corner-bottom"),p(".ic-box").addClass("chat-corner-top"),this.initMessages(),this.status("stop"),m.dispatchEvent("chat.onInit",this),this.cookie("connectStatus"));this.options.autoconnect=1===o||0!==o&&this.options.autoconnect,this.options.autoconnect&&!this.dom.is(".collapsed")?this.connect(!0):this.disconnect()}},connect:function(t){var e=this,o=this.connected?"disconnect":"connect",i=!1;s=1==t,"connect"==o&&this.cookie("auto_away")&&(i={auto_away:this.cookie("auto_away")}),this.send(o,i,function(){s=!1,t||e.cookie("connectStatus","connect"==o?1:0,-1),"connect"==o&&(e.dom.find("#purge-button").removeClass("disabled"),e.traceCheck("start"),m.dispatchEvent("chat.onConnect",!1))})},disconnect:function(t){var e=p("#chat-main-message").clone();this.status("stop"),this.traceCheck("stop"),this.dom.find('[data-action="connect"]').removeClass("connected"),this.dom.find("#purge-button").addClass("disabled"),t&&e.html(t),p("#chat-conversation-container").append(e),e.show(),this.dom.removeAttr("data-active"),m.dispatchEvent("chat.onDisconnect",!1)},closeActiveBox:function(){null!==this.activeBox&&this.activeBox.close()},collapsable:function(t){var e=this.dom.find("#chat-content"),o=e.is(":visible"),i=this.dom.find('[data-action="minimize"]');if("custom"==this.options.page)return i.remove(),!1;switch(t){case"change":n(!o),o?(this.closeActiveBox(),e.slideUp(),o=!1,this.disconnect(),this.cookie("collapsed",1)):(e.slideDown(),this.connect(o=!0),this.cookie("collapsed","",-1));case"init":"init"==t&&(m.intval(this.cookie("collapsed"))||0)&&(n(!1),e.hide(),o=!1),this.dom.toggleClass("collapsed",!o),i.children(".fa").toggleClass("fa-minus",o).toggleClass("fa-plus",!o)}function n(t){var e=i.parent("dt");t?e.removeStyle("margin-bottom"):e.css("margin-bottom",e.css("margin-top"))}},initMessages:function(){var t=p("#chat-notices"),e=p("#chat-tips"),o=t.find(".js-message"),i=e.find(".js-message");function n(t,e,o){var i=t.data("current_text");void 0===i&&(i=-1),e[++i]||(i=0),e.objView(!1),p(e[i]).objView(!0),t.data("current_text",i),1<e.length&&o&&setTimeout(function(){n(t,e,o)},o)}0<o.length&&(t.objView(!0),n(t,o,this.options.noticeTimeout)),0<i.length&&(e.objView(!0),n(e,i,this.options.tipTimeout))},refresh:function(){var t=this.connected?"refresh":"connect";this.status("pause"),this.send(t)},submit:function(){var t=new p.Event("chat.beforeSubmit",{service:this});if(m.dispatchEvent(t),!t.isDefaultPrevented()){var t=this.editor.element.val().replace(/\[\/?[^\]]+\]/g,""),e=new Date;if(!p.trim(t)||null!=f||a&&e.getTime()-a<600)return!1;if(this.options.maxChars)if(m.intval(this.editor.element.next(".chat-editor-counter").children("span").text())<0)return!1;return a=e.getTime(),this.status("pause"),this.send("post",{lastPostTime:v,auto_away:g})}},send:function(r,t,h){var l=this,d={ajaxModule:"chat",action:r};if(this.status("loading"))return"refresh"!=r&&w.push([r,t,h]),!1;-1!=p.inArray(r,["post","connect","disconnect","refresh","pmuser","set_available","set_away","set_busy","set_hidden","set_name"])&&(d=p.extend(d,this.dom.find("form").serializeObject())),this.currentRoom&&(d.room=this.currentRoom),t&&(d=p.extend(d,t)),"refresh"==r&&(3<c&&(d.trace=!0,c=0),c++),d.rooms=this.openRooms;var u=new p.Event("chat.beforeSend",{action:r,service:this,sendData:d});m.dispatchEvent(u),u.isDefaultPrevented()||("trace"!=r&&this.status("load-start"),m.request({showLoading:!1,data:u.sendData,onComplete:function(){l.status("load-end")},onSuccess:function(t){var e=!1,o=new Date;if(l.tempDom.html(t.htmlContent),!t.success)return l.dialog("close"),t.message&&alert(t.message),!1;if(t.dialog)return l.dialog({content:t.htmlContent}),!1;switch(t.action){case"disable":return l.disconnect(),window.location.reload(),!0;case"disconnect":l.disconnect();break;case"exclude":return l.disconnect(t.message),!0;case"login":l.connected=!1,l.dialog({content:t.htmlContent,onOpen:function(e){e.ui.find("input:first").focus(),e.ui.find("input[type=text], input[type=password]").keydown(function(t){if(13==t.which&&p(this).val())return e.ui.find('[value="submit"]').click(),t.preventDefault(),t.stopPropagation(),!1})},onSubmit:function(t){if(!t.username&&!t.username_register)return p(this).find("input[name=username]").addClass("cbb-state-error").focus(),!1;t.submit=1,l.send("connect",t,function(t){t.userLogged&&(l.cookie("connectStatus",1,-1),window.location.reload())})}});break;case"update":l.dom.find("input[name=last_update]").val(t.last_time),l.dom.find("input[name=time_mark]").val(t.timeMark),l.options.floodTime=t.floodTime,t.msg_direction&&t.msg_direction!=l.options.direction&&(l.options.direction=t.msg_direction,l.method="up"==t.msg_direction?"prepend":"append",l.inverseConversations(),e=!0);var i=null!=t.auto_away?t.auto_away:g;i!=g&&(g=i)&&l.cookie("auto_away",g);break;case"banuser":l.closeRoom(t.user_key);case"unbanuser":l.dom.find(".js-user-"+t.user_key).html(l.tempDom.find(".js-userlist li:first").html()),l.bindUserlist(!1,t.user_key);break;case"close_room":l.closeRoom(t.room_key)}switch(r){case"disconnect":l.disconnect();break;case"post":l.editor.element.val(""),l.editor.plugins.chat.updateCharCounter(),l.options.floodTime&&!t.ignoreFloodTime&&(l.editor.element.val(m.lang("CHAT_FLOOD_WAIT")).prop("disabled",!0).addClass("disabled").blur(),f=setTimeout(function(){l.editor.element.val("").prop("disabled",!1).removeClass("disabled").focus(),f=null},l.options.floodTime)),v=o.getTime()/1e3;case"set_available":case"set_away":case"set_busy":case"set_hidden":case"set_name":case"connect":l.connected||p("#chat-conversation-container").html(""),"connect"!=r&&"post"!=r||(l.connected=!0),"connect"==r&&l.dom.find('[data-action="connect"]').addClass("connected"),g=0,l.cookie("auto_away",0,-1);case"move":if("move"==r){if(!u.sendData.submit)break;p("#chat-conversation-container > div").html("")}case"pmuser":case"refresh":l.connected&&(a=l.appendConversationData(r),l.tempDom.html(""),l.currentRoom=l.currentRoom||l.options.defaultRoom,p("#chat-tab-"+l.currentRoom).length||(l.currentRoom=l.options.guestRoom),p("#chat-tab-"+l.currentRoom).hasClass("active")||l.openRoom(l.currentRoom),(a||e)&&(l.bindRows(),a&&"refresh"==r&&l.player("play","add"),l.scrolling||l.scrollRoom(),p("#chat-conversation-container .ic-row-text img").one("load",function(){this.loaded=!0,l.scrolling||l.scrollRoom()}).each(function(){this.complete&&!this.loaded&&p(this).trigger("load")})),l.doQueue(t.queueActions),l.status("resume"),b=o.getTime(),l.cookie("lastcheck",parseInt(b/1e3),365));break;case"quote":l.editor.insertText(t.text);break;case"history":var n=l.dom.find(".js-conversation-"+l.currentRoom),s=n.outerHeight(),a=l.appendConversationData(r);l.tempDom.html(""),a&&(n.data("ignoreLimit",!0),"up"!=l.options.direction&&(a=n.outerHeight(),l.scrollRoom(a-s)),l.bindRows())}var c=new p.Event("chat.afterSend",{action:r,service:this,sendData:d,response:t});m.dispatchEvent(c),"function"!=typeof h||c.isDefaultPrevented()||h.call(!1,t),w.length&&l.send.apply(l,w.shift())}}))},traceCheck:function(t){let e=this;switch(t){case"start":null!==o&&e.traceCheck("stop"),o=setInterval(function(){var t=new Date;b&&t.getTime()>b+1.5*e.options.refresh&&(e.send("trace"),b=t.getTime())},e.options.refresh);break;case"stop":clearInterval(o),o=null}},closeRoom:function(t){if(null==t||t==this.options.guestRoom)return!1;var e;-1!=(e=p.inArray(t,this.openRooms))&&(p("#chat-tab-"+t+", .js-conversation-"+t+", .js-userlist-"+t).remove(),m.dispatchEvent("chat.onCloseRoom",{instance:this,room:t}),this.openRooms.splice(e,1),e=this.currentRoom==t?this.options.guestRoom:this.currentRoom,this.openRoom(e,!0))},openRoom:function(t,e){var o=this.currentRoom,i=p("#chat-tab-"+t);if(-1!=p.inArray(o,self.openRooms)&&!0!==e)return!1;o&&(p(".js-conversation-"+o+", .js-userlist-"+o).hide(),p("#chat-tabs li").removeClass("active before-active after-active"),p("#chat-tabs .tab-close").removeClass("active")),this.currentRoom=t,p(".js-conversation-"+t+", .js-userlist-"+t).show(),i.addClass("active").removeClass("new-msg"),i.prev("li").addClass("before-active"),i.next("li").addClass("after-active"),i.find(".tab-close").addClass("active"),this.dom.attr("data-active",t);var e=p(".js-conversation-"+t).is(".js-public-room")?"removeClass":"addClass",o=this.dom.find("#purge-button"),i=(o[e].call(o,"disabled"),new p.Event("chat.onOpenRoom",{instance:this,room:t,backgroundAction:s}));m.dispatchEvent(i),i.isDefaultPrevented()||(this.scrolling=!1,this.scrollRoom(),s)||m.browser.isMobile||!this.editor||(e=this.editor.element.offset().top-p(window).scrollTop())<p(window).height()&&0<=e&&this.editor.element.focus()},bindLinks:function(t){window.self!=window.top&&t.find("a[href]:not([data-action],[data-code],.ic-row-action-launcher)").off("click.frame").on("click.frame",function(t){t.preventDefault(),window.top.location.href=this.href})},bindTabs:function(){var o=this;p("#chat-tabs").find("li, .tab-close").off(),p("#chat-tabs li").click(function(t){var e=parseInt(p(this).attr("id").replace("chat-tab-",""));o.openRoom(e),t.preventDefault()}),p("#chat-tabs li .tab-close").click(function(t){var e=p(this).parent(),e=parseInt(e.attr("id").replace("chat-tab-",""));o.closeRoom(e),t.preventDefault()}),m.dispatchEvent("chat.onBindTabs",this)},bindRows:function(){var o=this,t=p("#chat-conversation-container .chat-row");t.off().find(".ic-row-action-launcher").cbbDropdown({onCreate:function(){var e=this;e.rowID=e.launcher.closest(".chat-row").data("id"),e.container.find("[data-action]").off("click").click(function(t){t.preventDefault(),t.msgID=e.rowID,o.eventDispatch(t),e.close()})},onOpen:function(){this.launcher.closest(".chat-row").addClass("active"),o.status("pause",!0)},onClose:function(){this.launcher.closest(".chat-row").removeClass("active").children(".chat-row-content").mouseleave(),o.status("resume")}}),m.browser.isMobile?t.find(".ic-row-actions").show():t.filter(":not(.chat-format-bubble)").children(".chat-row-content").hover(function(){p(this).children(".ic-row-actions").show()},function(){p(this).closest(".chat-row").is(".active")||p(this).children(".ic-row-actions").each(function(){if(0<p(this).children(".row-id-list:checked").length)return!0;p(this).hide()})}),p("#chat-conversation-container").find(".history-row a, .chat-quickmention").off("click").click(p.proxy(this,"eventDispatch")),t.cbbImageGallery({imageSelector:"img:not(.emoji, .smilies)"}),o.bindLinks(t),m.dispatchEvent("chat.onBindRows",this)},bindUserlist:function(t,e){var t=e?".js-user-"+e:t?".js-userlist-"+t:".ic-userlist",e=e?p(t):p(t).children("li"),o=this;e.find("a").off("click").click(p.proxy(o,"eventDispatch")),e.children("a").cbbDropdown({dispatchEvent:"contextmenu",showPointer:!1,onCreate:function(){this.container.find("a").click(p.proxy(this,"close"))},onOpen:function(){o.currentMenu=this,o.status("pause",!0)},onClose:function(){o.currentMenu=null,o.status("resume")}}),m.dispatchEvent("chat.onBindUserlist",this)},eventDispatch:function(t){t.preventDefault();var e=p(t.currentTarget),o=e.data("action"),i=t.msgID,n=this;if(e.is(".disabled"))return!1;!i&&e.closest(".chat-row").length&&(i=e.closest(".chat-row").data("id"));t=new p.Event("chat.beforeEventDispatch",{originalEvent:t,action:o,service:this,msgID:i});if(m.dispatchEvent(t),!t.isDefaultPrevented()){switch(o){case"connect":case"refresh":this.closeActiveBox();case"submit":this[o].call(this);break;case"clear":n.send("clear",!1,function(){p(".js-conversation-"+n.currentRoom).html("")});break;case"rules":n.send("rules",!1,function(t){n.dialog({content:t.htmlContent,height:120,width:350})});break;case"sound":this.closeActiveBox(),this.player("mute");break;case"edit":n.send("edit",{id:i},function(t){n.dialog({autoFocus:!0,content:t.htmlContent,width:610,onSubmit:function(t){if((t=p.extend(t,{id:i,submit:1}),n.options.maxChars)&&m.intval(p(this).find(".chat-editor-counter > span").text())<0)return!1;n.send("edit",t,function(t){t.text&&p("#chat-row-"+i).find(".ic-row-text").html(t.text)})}})});break;case"delete":this.send("delete",{id:i},function(){n.player("play","delete"),p("#chat-row-"+i).fadeOut()});break;case"quote":this.send(o,{id:i});break;case"whois":n.send("whois",{id:i},function(t){n.dialog({content:t.htmlContent,width:450,height:150})});break;case"user":window.open(e.attr("href"));break;case"banuser":var s=e.data("user-key");this.send("banuser",{uk:s},function(t){n.dialog({content:t.htmlContent,onOpen:function(e){p("#ban-period").change(function(){var t="0"==p(this).val();e.ui.find("dl:has(#ban-date)").objView(t),t||e.ui.find("#ban-date").val("").removeClass("cbb-state-error")})},onSubmit:function(t){if("0"==t.period&&null==t.date.match(/\d{2}\/\d{2}\/\d{4} \d{2}\:\d{2}\:\d{2}/))return p(this).find("#ban-date").addClass("cbb-state-error").focus(),!1;t=p.extend(t,{uk:s,submit:1}),n.send("banuser",t)}})});break;case"quickmention":var a=(c=e.next(".ic-row-username:first")).children("a");case"mentionuser":(a="mentionuser"==o?(c=this.currentMenu.launcher).children("span"):a).length?n.editor.insertBBcode("color",{defaultAttr:m.rgbToHex(a.css("color")),inner:"[b]@"+a.text()+"[/b]"},FLAG_ADDWHITESPACES|FLAG_CURSORTOEND):n.editor.insertBBcode("b",{inner:"@"+c.text()},FLAG_ADDWHITESPACES|FLAG_CURSORTOEND);break;case"pmuser":s=e.data("user-key");-1==p.inArray(s,this.openRooms)?this.send("pmuser",{uk:s},function(){n.openRoom(s)}):this.openRoom(s);break;case"unbanuser":case"set_available":case"set_away":case"set_busy":case"set_hidden":this.send(o,{uk:e.data("user-key")});break;case"set_name":s=e.data("user-key");this.send("set_name",{uk:s},function(t){n.dialog({autoFocus:!0,content:t.htmlContent,onSubmit:function(t){if(!(t=p.extend(t,{uk:s,submit:1})).username)return p(this).find("input[name=username]").addClass("cbb-state-error").focus(),!1;n.send("set_name",t)}})});break;case"move":this.send("move",{id:i},function(t){n.dialog({content:t.htmlContent,onSubmit:function(t){t=p.extend(t,{id:i,submit:1,last_update:0}),n.send("move",t,function(){})}})});break;case"minimize":this.collapsable("change");break;case"history":var a="up"==this.options.direction?"prev":"next",c=e.parent()[a].call(e.parent(),".chat-row");this.send("history",{last_update:c.data("time")});break;default:window.open(e.attr("href"))}p(this).blur()}},player:function(t,e){if(null===this.options.soundPath)return!1;switch(t){case"mute":n&&!0!==e?!n&&!1!==e||(n=!1,p('a[data-action="sound"]').removeClass("muted"),this.cookie("mute","")):(n=!0,p('a[data-action="sound"]').addClass("muted"),this.cookie("mute",1,180));break;case"play":n||(this.audio.src=this.options.soundPath+e+".mp3",this.audio.play())}},dialog:function(e){var t,o=this;"string"==typeof e?null!==r&&(r.cbbDialog(e),"close"==e)&&(r=null):(t={autoClean:!1,autoFocus:e.autoFocus||!1,destroyOnClose:!0,movable:!1,width:e.width||"auto",height:e.height||"auto",parent:"archive"==this.options.mode?"body":p("#chat-content").is("ul")?"#chat-content > li":"#chat-content",onOpen:function(t){o.status("pause",!0),o.closeActiveBox(),o.bindLinks(p(this)),e.onOpen&&e.onOpen.call(this,t)},onClose:function(){o.status("resume")},onSubmit:e.onSubmit},r=p(e.content).cbbDialog(t))},scrollRoom:function(t){var e=p("#chat-conversation-container")[0];t?e.scrollTop=t:(e.scrollTop="up"==this.options.direction?0:e.scrollHeight,p(".chat-scroll-button").objView(!1))},status:function(t){switch(t){case"load-start":i=!0,p(".ic-loading").show();break;case"load-end":i=!1,p(".ic-loading").hide();break;case"loading":return i;case"stop":p("#chat-conversation-container, #chat-right-panel, #chat-tabs").html(""),this.openRooms=[],this.connected=!1,this.dom.find("input[name=last_update]").val(0),this.dom.find("input[name=time_mark]").val(0);case"pause":clearTimeout(e),e=null,this.status("load-end");break;case"resume":this.connected&&null===e&&(e=setTimeout(p.proxy(this,"refresh"),this.options.refresh))}},cookie:function(t,e,o){t="chat_"+t;if(null==e)return m.cookie.get(t);m.cookie.set(t,e,o)},inverseConversations:function(){p("#chat-conversation-container").children(".ic-conversation").each(function(){var t=p(this).children(".chat-row, .history-row");if(t.length){p(this).html("");for(var e=t.length-1;-1<e;e--)p(this).append(t[e])}})},appendConversationData:function(c){var r=this,h=!1,t=new Date,l=this.cookie("lastcheck")||t.getTime()/1e3;return this.tempDom.find(".room").each(function(){var t=parseInt(p(this).attr("id").replace("room-","")),e=p.trim(p(this).children(".js-conversation").html()),o=p.trim(p(this).children(".js-userlist").html());if(-1==p.inArray(t,r.openRooms)){if("history"==c)return!0;r.openRooms.push(t);var i={ROOM_ID:t,TITLE:p(this).attr("title")};p("#chat-right-panel").append(r.getTpl("userlist",i)),p("#chat-conversation-container").append(r.getTpl("conversation",i)),p("#chat-tabs").append(r.getTpl("tab",i)),p(this).is(".js-public-room")&&(p(".js-conversation-"+t).addClass("js-public-room"),p("#chat-tab-"+t).find(".tab-close").remove()),r.bindTabs()}var n=p(".js-conversation-"+t);if("history"==c)n.children(".history-row").replaceWith(e),h=!!e;else if(e){n[r.method].apply(n,[e]);var s=n.children(".chat-row").length,a="up"==r.options.direction?":last":":first";if(!n.data("ignoreLimit"))for(;s>r.options.maxRows;)n.children(".chat-row"+a).remove(),s--;i="up"==r.options.direction?":first":":last",e=parseInt(n.children(".chat-row"+i).data("time"));t!=r.currentRoom&&("refresh"==c||e&&l<e)&&p("#chat-tab-"+t).addClass("new-msg"),h=!0}o&&(p(".js-userlist-"+t).html(o),r.bindUserlist(t))}),h},doQueue:function(t){if(!t||!t.length)return!1;let e=!1;for(var o of t)switch(o.action){case"delete":p("#chat-row-"+o.msgID).fadeOut();break;case"edit":p("#chat-row-"+o.msgID).find(".ic-row-text").html(o.msgText);break;case"connect":e||(e=!0,this.player("play","connect"));break;case"move":var i=this.dom.find("#chat-row-"+o.msgID),n=m.intval(i.attr("data-time")),s=this.dom.find(".js-conversation-"+o.destKey);if((a=s.children(".chat-row")).length)for(var a=a.get().reverse(),c=0;c<a.length;c++){if(m.intval(p(a[c]).attr("data-time"))<n){p(a[c]).after(i);break}if(c==a.length-1){s.prepend(i);break}}else s.append(i);this.scrolling||this.scrollRoom()}},getTpl:function(t,e){return m.template.parse(this.tpl[t],e)}},!1)})(jQuery,cbbCore),((o,i)=>{cbbEditorWrapper.plugins.chat={init:function(){this.chat=i.getService("chat"),this.chat.editor||(this.chat.editor=this.editor),this.bindInput(),this.updateCharCounter()},bindInput:function(){var t,e=this;e.editor.element.closest("#chat-message").length&&e.editor.element.on("keyup keydown",function(t){if(13==t.which)return"keyup"==t.type&&1!=t.ctrlKey?e.chat.submit():"keydown"==t.type&&1==t.ctrlKey&&e.editor.insertText("\n"),t.preventDefault(),t.stopPropagation(),!1}),e.chat.options.maxChars&&(t=o('<div class="chat-editor-counter"><span></span><svg height="20" width="20"><circle class="mask" cx="50%" cy="50%" r="8" fill="none" stroke-width="1"></circle><circle cx="50%" cy="50%" r="8" fill="none" stroke-width="2"></circle></svg></div>'),e.charCounter={radial:t.find("circle:not(.mask)"),label:t.children("span")},e.charCounter.radial.css({"stroke-dashoffset":50,"stroke-dasharray":50}),e.editor.element.on("input",o.proxy(e,"updateCharCounter")).after(t)),i.dispatchEvent("chat.onBindInput",this)},updateCharCounter:function(){var t,e,o,i;void 0!==this.charCounter&&(e=50-50*(t=this.editor.element.val()).length/this.chat.options.maxChars,o="danger",i="",this.charCounter.radial.css("stroke-dashoffset",Math.max(0,e)),5<e?o="safe":0<=e&&(o="warn"),this.charCounter.radial.get(0).setAttribute("class",o),e<0&&(i=this.chat.options.maxChars-t.length),this.charCounter.label.text(i))},eventCommandExec:function(){this.chat.options.hidePopup&&this.chat.closeActiveBox()},eventTextchange:function(){this.updateCharCounter()}}})(jQuery,cbbCore);
++!function(p,m){"use strict";var e=null,o=null,f=null,i=!1,n=!1,s=!1,v=0,b=0,g=0,a=0,c=0,r=null,w=[];m.registerService("chat",{activeBox:null,connected:!1,currentRoom:!1,dom:null,method:"append",openRooms:[],tempDom:p("<div />"),editor:null,scrolling:!1,audio:new Audio,options:{autoconnect:!1,defaultRoom:0,direction:"down",floodTime:0,guestRoom:1,height:220,hidePopup:!1,imgSelector:".postimage",maxChars:0,maxRows:25,mode:"chat",noticeTimeout:2e4,page:"",soundPath:null,position:"bottom",refresh:5e3,tipTimeout:15e3},positions:{},tpl:{conversation:'<div class="ic-conversation js-conversation-<%ROOM_ID%>"></div>',sep:'<div class="sep"></div>',tab:'<li id="chat-tab-<%ROOM_ID%>"><%TITLE%> <a href="#" class="tab-close"><i class="fa fa-times-circle" aria-hidden="true"></i></a></li>',userlist:'<ul class="ic-userlist js-userlist-<%ROOM_ID%>"></ul>'},__construct:function(){var e=this;if(this.options.defaultRoom=this.options.defaultRoom||this.options.guestRoom,m.dispatchEvent("chat.beforeInit",this),"archive"===this.options.mode)this.bindRows(),p('[data-action="mark"], [data-action="unmark"]').click(function(t){t.preventDefault();var t="mark"==p(this).data("action"),e=t?"show":"hide",t=(p('input[name^="row_id_list"]').prop("checked",t),p(".chat-row .ic-row-actions").has(".row-id-list"));t[e].call(t)});else{if("up"==this.options.direction&&(this.method="prepend"),this.dom=p("#chat-body"),!(this.dom.length&&this.options.guestRoom&&this.options.height&&this.options.maxRows))return!1;void 0!==window.jchat_style_options&&(this.positions=window.jchat_style_options.positions);var t=!1;if("custom"==this.options.page&&this.positions.chat)t=this.positions.chat;else if("custom"!=this.options.page&&this.options.position){var o={};if(this.positions[this.options.page])o=this.positions[this.options.page];else{if(!this.positions.undefined)return!1;o=this.positions.undefined}t=o[this.options.position]}!1!==t&&(0==p(t[0]).length&&this.positions.undefined&&this.options.position&&(t=this.positions.undefined[this.options.position]),o=p(t[0]),t=t[1],1==(o=1<o.length?p(o[0]):o).length)&&o[t].apply(o,[this.dom]),m.colourIsDark(this.dom.find("#chat-content").css("background-color"),170)&&this.dom.addClass("dark-theme"),this.dom.objView(!0),m.browser.isMobile&&(p("head meta[name=viewport]").remove(),p("head").prepend('<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />')),p("#chat-conversation-container").on("scroll",function(){"up"==e.options.direction&&0<this.scrollTop||"down"==e.options.direction&&this.scrollTop<this.scrollHeight-this.offsetHeight?(e.scrolling=!0,p(".chat-scroll-button").objView(!0)):(e.scrolling=!1,p(".chat-scroll-button").objView(!1))}),p(".chat-scroll-button").addClass(e.options.direction).click(function(t){t.preventDefault(),e.scrollRoom()});t={autoClose:!1,minSize:180,yPosition:"top",wrapper:this.dom,onOpen:function(){e.closeActiveBox(),e.activeBox=this},onClose:function(){e.activeBox=null}},o=(this.dom.find('a[data-action="showbox"]').cbbDropdown(p.extend({},t,{adjustMethod:"resize"})),this.dom.find('a[data-action="color"]').cbbColorPicker(p.extend({},t,{realTimeUpdate:!1,onChange:function(t){e.editor.insertBBcode("color",t),e.options.hidePopup&&e.closeActiveBox()}})),this.dom.find("a[data-action]").filter(function(){return!p(this).data("cbbDropdown")}).click(p.proxy(this,"eventDispatch")),this.bindLinks(this.dom),this.collapsable("init"),1==this.cookie("mute")&&this.player("mute",!0),p("#chat-conversation-container").css("height",this.options.height),p("#chat-right-panel").css("height",this.options.height+p("#chat-tabs").height()),p("#chat-toolbar a").addClass("chat-corner-top chat-corner-bottom"),p(".ic-box").addClass("chat-corner-top"),this.initMessages(),this.status("stop"),m.dispatchEvent("chat.onInit",this),this.cookie("connectStatus"));this.options.autoconnect=1===o||0!==o&&this.options.autoconnect,this.options.autoconnect&&!this.dom.is(".collapsed")?this.connect(!0):this.disconnect()}},connect:function(t){var e=this,o=this.connected?"disconnect":"connect",i=!1;s=1==t,"connect"==o&&this.cookie("auto_away")&&(i={auto_away:this.cookie("auto_away")}),this.send(o,i,function(){s=!1,t||e.cookie("connectStatus","connect"==o?1:0,-1),"connect"==o&&(e.dom.find("#purge-button").removeClass("disabled"),e.traceCheck("start"),m.dispatchEvent("chat.onConnect",!1))})},disconnect:function(t){var e=p("#chat-main-message").clone();this.status("stop"),this.traceCheck("stop"),this.dom.find('[data-action="connect"]').removeClass("connected"),this.dom.find("#purge-button").addClass("disabled"),t&&e.html(t),p("#chat-conversation-container").append(e),e.show(),this.dom.removeAttr("data-active"),m.dispatchEvent("chat.onDisconnect",!1)},closeActiveBox:function(){null!==this.activeBox&&this.activeBox.close()},collapsable:function(t){var e=this.dom.find("#chat-content"),o=e.is(":visible"),i=this.dom.find('[data-action="minimize"]');if("custom"==this.options.page)return i.remove(),!1;switch(t){case"change":n(!o),o?(this.closeActiveBox(),e.slideUp(),o=!1,this.disconnect(),this.cookie("collapsed",1)):(e.slideDown(),this.connect(o=!0),this.cookie("collapsed","",-1));case"init":"init"==t&&(m.intval(this.cookie("collapsed"))||0)&&(n(!1),e.hide(),o=!1),this.dom.toggleClass("collapsed",!o),i.children(".fa").toggleClass("fa-minus",o).toggleClass("fa-plus",!o)}function n(t){var e=i.parent("dt");t?e.removeStyle("margin-bottom"):e.css("margin-bottom",e.css("margin-top"))}},initMessages:function(){var t=p("#chat-notices"),e=p("#chat-tips"),o=t.find(".js-message"),i=e.find(".js-message");function n(t,e,o){var i=t.data("current_text");void 0===i&&(i=-1),e[++i]||(i=0),e.objView(!1),p(e[i]).objView(!0),t.data("current_text",i),1<e.length&&o&&setTimeout(function(){n(t,e,o)},o)}0<o.length&&(t.objView(!0),n(t,o,this.options.noticeTimeout)),0<i.length&&(e.objView(!0),n(e,i,this.options.tipTimeout))},refresh:function(){var t=this.connected?"refresh":"connect";this.status("pause"),this.send(t)},submit:function(){var t=new p.Event("chat.beforeSubmit",{service:this});if(m.dispatchEvent(t),!t.isDefaultPrevented()){var t=this.editor.element.val().replace(/\[\/?[^\]]+\]/g,""),e=new Date;if(!p.trim(t)||null!=f||a&&e.getTime()-a<600)return!1;if(this.options.maxChars)if(m.intval(this.editor.element.next(".chat-editor-counter").children("span").text())<0)return!1;return a=e.getTime(),this.status("pause"),this.send("post",{lastPostTime:v,auto_away:g})}},send:function(r,t,h){var l=this,d={ajaxModule:"chat",action:r};if(this.status("loading"))return"refresh"!=r&&w.push([r,t,h]),!1;-1!=p.inArray(r,["post","connect","disconnect","refresh","pmuser","set_available","set_away","set_busy","set_hidden","set_name"])&&(d=p.extend(d,this.dom.find("form").serializeObject())),this.currentRoom&&(d.room=this.currentRoom),t&&(d=p.extend(d,t)),"refresh"==r&&(3<c&&(d.trace=!0,c=0),c++),d.rooms=this.openRooms;var u=new p.Event("chat.beforeSend",{action:r,service:this,sendData:d});m.dispatchEvent(u),u.isDefaultPrevented()||("trace"!=r&&this.status("load-start"),m.request({showLoading:!1,data:u.sendData,onComplete:function(){l.status("load-end")},onSuccess:function(t){var e=!1,o=new Date;if(l.tempDom.html(t.htmlContent),!t.success)return l.dialog("close"),t.message&&alert(t.message),!1;if(t.dialog)return l.dialog({content:t.htmlContent}),!1;switch(t.action){case"disable":return l.disconnect(),window.location.reload(),!0;case"disconnect":l.disconnect();break;case"exclude":return l.disconnect(t.message),!0;case"login":l.connected=!1,l.dialog({content:t.htmlContent,onOpen:function(e){e.ui.find("input:first").focus(),e.ui.find("input[type=text], input[type=password]").keydown(function(t){if(13==t.which&&p(this).val())return e.ui.find('[value="submit"]').click(),t.preventDefault(),t.stopPropagation(),!1})},onSubmit:function(t){if(!t.username&&!t.username_register)return p(this).find("input[name=username]").addClass("cbb-state-error").focus(),!1;t.submit=1,l.send("connect",t,function(t){t.userLogged&&(l.cookie("connectStatus",1,-1),window.location.reload())})}});break;case"update":l.dom.find("input[name=last_update]").val(t.last_time),l.dom.find("input[name=time_mark]").val(t.timeMark),l.options.floodTime=t.floodTime,t.msg_direction&&t.msg_direction!=l.options.direction&&(l.options.direction=t.msg_direction,l.method="up"==t.msg_direction?"prepend":"append",l.inverseConversations(),e=!0);var i=null!=t.auto_away?t.auto_away:g;i!=g&&(g=i)&&l.cookie("auto_away",g);break;case"banuser":l.closeRoom(t.user_key);case"unbanuser":l.dom.find(".js-user-"+t.user_key).html(l.tempDom.find(".js-userlist li:first").html()),l.bindUserlist(!1,t.user_key);break;case"close_room":l.closeRoom(t.room_key)}switch(r){case"disconnect":l.disconnect();break;case"post":l.editor.element.val(""),l.editor.plugins.chat.updateCharCounter(),l.options.floodTime&&!t.ignoreFloodTime&&(l.editor.element.val(m.lang("CHAT_FLOOD_WAIT")).prop("disabled",!0).addClass("disabled").blur(),f=setTimeout(function(){l.editor.element.val("").prop("disabled",!1).removeClass("disabled").focus(),f=null},l.options.floodTime)),v=o.getTime()/1e3;case"set_available":case"set_away":case"set_busy":case"set_hidden":case"set_name":case"connect":l.connected||p("#chat-conversation-container").html(""),"connect"!=r&&"post"!=r||(l.connected=!0),"connect"==r&&l.dom.find('[data-action="connect"]').addClass("connected"),g=0,l.cookie("auto_away",0,-1);case"move":if("move"==r){if(!u.sendData.submit)break;p("#chat-conversation-container > div").html("")}case"pmuser":case"refresh":l.connected&&(a=l.appendConversationData(r),l.tempDom.html(""),l.currentRoom=l.currentRoom||l.options.defaultRoom,p("#chat-tab-"+l.currentRoom).length||(l.currentRoom=l.options.guestRoom),p("#chat-tab-"+l.currentRoom).hasClass("active")||l.openRoom(l.currentRoom),(a||e)&&(l.bindRows(),a&&"refresh"==r&&l.player("play","add"),l.scrolling||l.scrollRoom(),p("#chat-conversation-container .ic-row-text img").one("load",function(){this.loaded=!0,l.scrolling||l.scrollRoom()}).each(function(){this.complete&&!this.loaded&&p(this).trigger("load")})),l.doQueue(t.queueActions),l.status("resume"),b=o.getTime(),l.cookie("lastcheck",parseInt(b/1e3),365));break;case"quote":l.editor.insertText(t.text);break;case"history":var n=l.dom.find(".js-conversation-"+l.currentRoom),s=n.outerHeight(),a=l.appendConversationData(r);l.tempDom.html(""),a&&(n.data("ignoreLimit",!0),"up"!=l.options.direction&&(a=n.outerHeight(),l.scrollRoom(a-s)),l.bindRows())}var c=new p.Event("chat.afterSend",{action:r,service:this,sendData:d,response:t});m.dispatchEvent(c),"function"!=typeof h||c.isDefaultPrevented()||h.call(!1,t),w.length&&l.send.apply(l,w.shift())}}))},traceCheck:function(t){let e=this;switch(t){case"start":null!==o&&e.traceCheck("stop"),o=setInterval(function(){var t=new Date;b&&t.getTime()>b+1.5*e.options.refresh&&(e.send("trace"),b=t.getTime())},e.options.refresh);break;case"stop":clearInterval(o),o=null}},closeRoom:function(t){if(null==t||t==this.options.guestRoom)return!1;var e;-1!=(e=p.inArray(t,this.openRooms))&&(p("#chat-tab-"+t+", .js-conversation-"+t+", .js-userlist-"+t).remove(),m.dispatchEvent("chat.onCloseRoom",{instance:this,room:t}),this.openRooms.splice(e,1),e=this.currentRoom==t?this.options.guestRoom:this.currentRoom,this.openRoom(e,!0))},openRoom:function(t,e){var o=this.currentRoom,i=p("#chat-tab-"+t);if(-1!=p.inArray(o,self.openRooms)&&!0!==e)return!1;o&&(p(".js-conversation-"+o+", .js-userlist-"+o).hide(),p("#chat-tabs li").removeClass("active before-active after-active"),p("#chat-tabs .tab-close").removeClass("active")),this.currentRoom=t,p(".js-conversation-"+t+", .js-userlist-"+t).show(),i.addClass("active").removeClass("new-msg"),i.prev("li").addClass("before-active"),i.next("li").addClass("after-active"),i.find(".tab-close").addClass("active"),this.dom.attr("data-active",t);var e=p(".js-conversation-"+t).is(".js-public-room")?"removeClass":"addClass",o=this.dom.find("#purge-button"),i=(o[e].call(o,"disabled"),new p.Event("chat.onOpenRoom",{instance:this,room:t,backgroundAction:s}));m.dispatchEvent(i),i.isDefaultPrevented()||(this.scrolling=!1,this.scrollRoom(),s)||m.browser.isMobile||!this.editor||(e=this.editor.element.offset().top-p(window).scrollTop())<p(window).height()&&0<=e&&this.editor.element.focus()},bindLinks:function(t){window.self!=window.top&&t.find("a[href]:not([data-action],[data-code],.ic-row-action-launcher)").off("click.frame").on("click.frame",function(t){t.preventDefault(),window.top.location.href=this.href})},bindTabs:function(){var o=this;p("#chat-tabs").find("li, .tab-close").off(),p("#chat-tabs li").click(function(t){var e=parseInt(p(this).attr("id").replace("chat-tab-",""));o.openRoom(e),t.preventDefault()}),p("#chat-tabs li .tab-close").click(function(t){var e=p(this).parent(),e=parseInt(e.attr("id").replace("chat-tab-",""));o.closeRoom(e),t.preventDefault()}),m.dispatchEvent("chat.onBindTabs",this)},bindRows:function(){var o=this,t=p("#chat-conversation-container .chat-row");t.off().find(".ic-row-action-launcher").cbbDropdown({onCreate:function(){var e=this;e.rowID=e.launcher.closest(".chat-row").data("id"),e.container.find("[data-action]").off("click").click(function(t){t.preventDefault(),t.msgID=e.rowID,o.eventDispatch(t),e.close()})},onOpen:function(){this.launcher.closest(".chat-row").addClass("active"),o.status("pause",!0)},onClose:function(){this.launcher.closest(".chat-row").removeClass("active").children(".chat-row-content").mouseleave(),o.status("resume")}}),m.browser.isMobile?t.find(".ic-row-actions").show():t.filter(":not(.chat-format-bubble)").children(".chat-row-content").hover(function(){p(this).children(".ic-row-actions").show()},function(){p(this).closest(".chat-row").is(".active")||p(this).children(".ic-row-actions").each(function(){if(0<p(this).children(".row-id-list:checked").length)return!0;p(this).hide()})}),p("#chat-conversation-container").find(".history-row a, .chat-quickmention").off("click").click(p.proxy(this,"eventDispatch")),t.cbbImageGallery({imageSelector:"img:not(.emoji, .smilies)"}),o.bindLinks(t),m.dispatchEvent("chat.onBindRows",this)},bindUserlist:function(t,e){var t=e?".js-user-"+e:t?".js-userlist-"+t:".ic-userlist",e=e?p(t):p(t).children("li"),o=this;e.find("a").off("click").click(p.proxy(o,"eventDispatch")),e.children("a").cbbDropdown({dispatchEvent:"contextmenu",showPointer:!1,onCreate:function(){this.container.find("a").click(p.proxy(this,"close"))},onOpen:function(){o.currentMenu=this,o.status("pause",!0)},onClose:function(){o.currentMenu=null,o.status("resume")}}),m.dispatchEvent("chat.onBindUserlist",this)},eventDispatch:function(t){t.preventDefault();var e=p(t.currentTarget),o=e.data("action"),i=t.msgID,n=this;if(e.is(".disabled"))return!1;!i&&e.closest(".chat-row").length&&(i=e.closest(".chat-row").data("id"));t=new p.Event("chat.beforeEventDispatch",{originalEvent:t,action:o,service:this,msgID:i});if(m.dispatchEvent(t),!t.isDefaultPrevented()){switch(o){case"connect":case"refresh":this.closeActiveBox();case"submit":this[o].call(this);break;case"clear":n.send("clear",!1,function(){p(".js-conversation-"+n.currentRoom).html("")});break;case"rules":n.send("rules",!1,function(t){n.dialog({content:t.htmlContent,height:120,width:350})});break;case"sound":this.closeActiveBox(),this.player("mute");break;case"edit":n.send("edit",{id:i},function(t){n.dialog({autoFocus:!0,content:t.htmlContent,width:610,onSubmit:function(t){if((t=p.extend(t,{id:i,submit:1}),n.options.maxChars)&&m.intval(p(this).find(".chat-editor-counter > span").text())<0)return!1;n.send("edit",t,function(t){t.text&&p("#chat-row-"+i).find(".ic-row-text").html(t.text)})}})});break;case"delete":this.send("delete",{id:i},function(){n.player("play","delete"),p("#chat-row-"+i).fadeOut()});break;case"quote":this.send(o,{id:i});break;case"whois":n.send("whois",{id:i},function(t){n.dialog({content:t.htmlContent,width:450,height:150})});break;case"user":window.open(e.attr("href"));break;case"banuser":var s=e.data("user-key");this.send("banuser",{uk:s},function(t){n.dialog({content:t.htmlContent,onOpen:function(e){p("#ban-period").change(function(){var t="0"==p(this).val();e.ui.find("dl:has(#ban-date)").objView(t),t||e.ui.find("#ban-date").val("").removeClass("cbb-state-error")})},onSubmit:function(t){if("0"==t.period&&null==t.date.match(/\d{2}\/\d{2}\/\d{4} \d{2}\:\d{2}\:\d{2}/))return p(this).find("#ban-date").addClass("cbb-state-error").focus(),!1;t=p.extend(t,{uk:s,submit:1}),n.send("banuser",t)}})});break;case"quickmention":var a=(c=e.next(".ic-row-username:first")).children("a");case"mentionuser":(a="mentionuser"==o?(c=this.currentMenu.launcher).children("span"):a).length?n.editor.insertBBcode("color",{defaultAttr:m.rgbToHex(a.css("color")),inner:"[b]@"+a.text()+"[/b]"},FLAG_ADDWHITESPACES|FLAG_CURSORTOEND):n.editor.insertBBcode("b",{inner:"@"+c.text()},FLAG_ADDWHITESPACES|FLAG_CURSORTOEND);break;case"pmuser":s=e.data("user-key");-1==p.inArray(s,this.openRooms)?this.send("pmuser",{uk:s},function(){n.openRoom(s)}):this.openRoom(s);break;case"unbanuser":case"set_available":case"set_away":case"set_busy":case"set_hidden":this.send(o,{uk:e.data("user-key")});break;case"set_name":s=e.data("user-key");this.send("set_name",{uk:s},function(t){n.dialog({autoFocus:!0,content:t.htmlContent,onSubmit:function(t){if(!(t=p.extend(t,{uk:s,submit:1})).username)return p(this).find("input[name=username]").addClass("cbb-state-error").focus(),!1;n.send("set_name",t)}})});break;case"move":this.send("move",{id:i},function(t){n.dialog({content:t.htmlContent,onSubmit:function(t){t=p.extend(t,{id:i,submit:1,last_update:0}),n.send("move",t,function(){})}})});break;case"minimize":this.collapsable("change");break;case"history":var a="up"==this.options.direction?"prev":"next",c=e.parent()[a].call(e.parent(),".chat-row");this.send("history",{last_update:c.data("time")});break;default:window.open(e.attr("href"))}p(this).blur()}},player:function(t,e){if(null===this.options.soundPath)return!1;switch(t){case"mute":n&&!0!==e?!n&&!1!==e||(n=!1,p('a[data-action="sound"]').removeClass("muted"),this.cookie("mute","")):(n=!0,p('a[data-action="sound"]').addClass("muted"),this.cookie("mute",1,180));break;case"play":n||(this.audio.src=this.options.soundPath+e+".mp3",this.audio.play())}},dialog:function(e){var t,o=this;"string"==typeof e?null!==r&&(r.cbbDialog(e),"close"==e)&&(r=null):(t={autoClean:!1,autoFocus:e.autoFocus||!1,destroyOnClose:!0,movable:!1,width:e.width||"auto",height:e.height||"auto",parent:"archive"==this.options.mode?"body":p("#chat-content").is("ul")?"#chat-content > li":"#chat-content",onOpen:function(t){o.status("pause",!0),o.closeActiveBox(),o.bindLinks(p(this)),e.onOpen&&e.onOpen.call(this,t)},onClose:function(){o.status("resume")},onSubmit:e.onSubmit},r=p(e.content).cbbDialog(t))},scrollRoom:function(t){var e=p("#chat-conversation-container")[0];t?e.scrollTop=t:(e.scrollTop="up"==this.options.direction?0:e.scrollHeight,p(".chat-scroll-button").objView(!1))},status:function(t){switch(t){case"load-start":i=!0,p(".ic-loading").show();break;case"load-end":i=!1,p(".ic-loading").hide();break;case"loading":return i;case"stop":p("#chat-conversation-container, #chat-right-panel, #chat-tabs").html(""),this.openRooms=[],this.connected=!1,this.dom.find("input[name=last_update]").val(0),this.dom.find("input[name=time_mark]").val(0);case"pause":clearTimeout(e),e=null,this.status("load-end");break;case"resume":this.connected&&null===e&&(e=setTimeout(p.proxy(this,"refresh"),this.options.refresh))}},cookie:function(t,e,o){t="chat_"+t;if(null==e)return m.cookie.get(t);m.cookie.set(t,e,o)},inverseConversations:function(){p("#chat-conversation-container").children(".ic-conversation").each(function(){var t=p(this).children(".chat-row, .history-row");if(t.length){p(this).html("");for(var e=t.length-1;-1<e;e--)p(this).append(t[e])}})},appendConversationData:function(c){var r=this,h=!1,t=new Date,l=this.cookie("lastcheck")||t.getTime()/1e3;return this.tempDom.find(".room").each(function(){var t=parseInt(p(this).attr("id").replace("room-","")),e=p.trim(p(this).children(".js-conversation").html()),o=p.trim(p(this).children(".js-userlist").html());if(-1==p.inArray(t,r.openRooms)){if("history"==c)return!0;r.openRooms.push(t);var i={ROOM_ID:t,TITLE:p(this).attr("title")};p("#chat-right-panel").append(r.getTpl("userlist",i)),p("#chat-conversation-container").append(r.getTpl("conversation",i)),p("#chat-tabs").append(r.getTpl("tab",i)),p(this).is(".js-public-room")&&(p(".js-conversation-"+t).addClass("js-public-room"),p("#chat-tab-"+t).find(".tab-close").remove()),r.bindTabs()}var n=p(".js-conversation-"+t);if("history"==c)n.children(".history-row").replaceWith(e),h=!!e;else if(e){n[r.method].apply(n,[e]);var s=n.children(".chat-row").length,a="up"==r.options.direction?":last":":first";if(!n.data("ignoreLimit"))for(;s>r.options.maxRows;)n.children(".chat-row"+a).remove(),s--;i="up"==r.options.direction?":first":":last",e=parseInt(n.children(".chat-row"+i).data("time"));t!=r.currentRoom&&("refresh"==c||e&&l<e)&&p("#chat-tab-"+t).addClass("new-msg"),h=!0}o&&(p(".js-userlist-"+t).html(o),r.bindUserlist(t))}),h},doQueue:function(t){if(!t||!t.length)return!1;let e=!1;for(var o of t)switch(o.action){case"delete":p("#chat-row-"+o.msgID).fadeOut();break;case"edit":p("#chat-row-"+o.msgID).find(".ic-row-text").html(o.msgText);break;case"connect":e||(e=!0,this.player("play","connect"));break;case"move":var i=this.dom.find("#chat-row-"+o.msgID),n=m.intval(i.attr("data-time")),s=this.dom.find(".js-conversation-"+o.destKey);if((a=s.children(".chat-row")).length)for(var a=a.get().reverse(),c=0;c<a.length;c++){if(m.intval(p(a[c]).attr("data-time"))<n){p(a[c]).after(i);break}if(c==a.length-1){s.prepend(i);break}}else s.append(i);this.scrolling||this.scrollRoom()}},getTpl:function(t,e){return m.template.parse(this.tpl[t],e)}},!1)}(jQuery,cbbCore),function(o,i){"use strict";cbbEditorWrapper.plugins.chat={init:function(){this.chat=i.getService("chat"),this.chat.editor||(this.chat.editor=this.editor),this.bindInput(),this.updateCharCounter()},bindInput:function(){var t,e=this;e.editor.element.closest("#chat-message").length&&e.editor.element.on("keyup keydown",function(t){if(13==t.which)return"keyup"==t.type&&1!=t.ctrlKey?e.chat.submit():"keydown"==t.type&&1==t.ctrlKey&&e.editor.insertText("\n"),t.preventDefault(),t.stopPropagation(),!1}),e.chat.options.maxChars&&(t=o('<div class="chat-editor-counter"><span></span><svg height="20" width="20"><circle class="mask" cx="50%" cy="50%" r="8" fill="none" stroke-width="1"></circle><circle cx="50%" cy="50%" r="8" fill="none" stroke-width="2"></circle></svg></div>'),e.charCounter={radial:t.find("circle:not(.mask)"),label:t.children("span")},e.charCounter.radial.css({"stroke-dashoffset":50,"stroke-dasharray":50}),e.editor.element.on("input",o.proxy(e,"updateCharCounter")).after(t)),i.dispatchEvent("chat.onBindInput",this)},updateCharCounter:function(){var t,e,o,i;void 0!==this.charCounter&&(e=50-50*(t=this.editor.element.val()).length/this.chat.options.maxChars,o="danger",i="",this.charCounter.radial.css("stroke-dashoffset",Math.max(0,e)),5<e?o="safe":0<=e&&(o="warn"),this.charCounter.radial.get(0).setAttribute("class",o),e<0&&(i=this.chat.options.maxChars-t.length),this.charCounter.label.text(i))},eventCommandExec:function(){this.chat.options.hidePopup&&this.chat.closeActiveBox()},eventTextchange:function(){this.updateCharCounter()}}}(jQuery,cbbCore);
+ 
+-((t,o,n)=>{"function"==typeof define&&define.amd?define(["jquery"],function(e){return n(e,t,o),e.mobile}):n(t.jQuery,t,o)})(this,document,function(e,a,K,O){var t;t=function(e){return e.ui=e.ui||{},e.ui.version="1.12.1"},"function"==typeof define&&define.amd?define("jquery-ui/version",["jquery"],t):t(e),t=function(){},"function"==typeof define&&define.amd&&define("core",["./defaults","./data","./helpers"],t),t=function(e){var t={touch:"ontouchend"in K};return e.mobile={},e.mobile.support=e.mobile.support||{},e.extend(e.support,t),e.extend(e.mobile.support,t),e.support},"function"==typeof define&&define.amd?define("support/touch",["jquery","../ns"],t):t(e),t=function(e){return e.extend(e.support,{orientation:"orientation"in a&&"onorientationchange"in a}),e.support},"function"==typeof define&&define.amd?define("support/orientation",["jquery"],t):t(e),t=function(p){var c,e,i="virtualMouseBindings",u="virtualTouchID",l="clientX clientY pageX pageY screenX screenY".split(" "),t="vmouseover vmousedown vmousemove vmouseup vclick vmouseout vmousecancel".split(" "),f="altKey bubbles cancelable ctrlKey currentTarget detail eventPhase metaKey relatedTarget shiftKey target timeStamp view which".split(" "),o=p.event.mouseHooks?p.event.mouseHooks.props:[],h=f.concat(o),a={},n=0,s=0,r=0,v=!1,d=[],m=!1,g=!1,w="addEventListener"in K,T=p(K),y=1,b=0;function D(e){for(;e&&void 0!==e.originalEvent;)e=e.originalEvent;return e}function P(e){for(var t,o,n={};e;){for(o in t=p.data(e,i))t[o]&&(n[o]=n.hasVirtualBinding=!0);e=e.parentNode}return n}function k(){g=!0}function E(){b=0,d.length=0,m=!1,k()}function F(){g=!1}function X(){n&&(clearTimeout(n),n=0)}function Y(){X(),n=setTimeout(function(){n=0,E()},p.vmouse.resetTimerDuration)}function x(e,t,o){var n;return(o&&o[e]||!o&&((e,t)=>{for(var o;e;){if((o=p.data(e,i))&&(!t||o[t]))return e;e=e.parentNode}})(t.target,e))&&(n=((e,t)=>{var o,n,i,a,s,r,c,u=e.type;if((e=p.Event(e)).type=t,o=e.originalEvent,n=f,-1<u.search(/^(mouse|click)/)&&(n=h),o)for(s=n.length;s;)e[i=n[--s]]=o[i];if(-1<u.search(/mouse(down|up)|click/)&&!e.which&&(e.which=1),-1!==u.search(/^touch/)&&(u=(t=D(o)).touches,t=t.changedTouches,a=u&&u.length?u[0]:t&&t.length?t[0]:O))for(r=0,c=l.length;r<c;r++)e[i=l[r]]=a[i];return e})(t,e),p(t.target).trigger(n)),n}function M(e){var t=p.data(e.target,u);"click"===e.type&&"touchstart"===p.data(e.target,"lastTouchType")&&setTimeout(function(){"touchstart"===p.data(e.target,"lastTouchType")&&(E(),delete p.data(e.target).lastTouchType,M(e))},p.vmouse.maximumTimeBetweenTouches),m||b&&b===t||(t=x("v"+e.type,e))&&(t.isDefaultPrevented()&&e.preventDefault(),t.isPropagationStopped()&&e.stopPropagation(),t.isImmediatePropagationStopped())&&e.stopImmediatePropagation()}function I(e){var t,o=D(e).touches;o&&1===o.length&&(t=P(o=e.target),p.data(e.target,"lastTouchType",e.type),t.hasVirtualBinding)&&(b=y++,p.data(o,u,b),X(),F(),v=!1,o=D(e).touches[0],s=o.pageX,r=o.pageY,x("vmouseover",e,t),x("vmousedown",e,t))}function j(e){g||(v||x("vmousecancel",e,P(e.target)),p.data(e.target,"lastTouchType",e.type),v=!0,Y())}function q(e){var t,o,n,i;g||(t=D(e).touches[0],o=v,n=p.vmouse.moveDistanceThreshold,i=P(e.target),p.data(e.target,"lastTouchType",e.type),(v=v||Math.abs(t.pageX-s)>n||Math.abs(t.pageY-r)>n)&&!o&&x("vmousecancel",e,i),x("vmousemove",e,i),Y())}function S(e){var t,o;g||p.data(e.target,"lastTouchType")===O||(k(),delete p.data(e.target).lastTouchType,x("vmouseup",e,t=P(e.target)),v||(o=x("vclick",e,t))&&o.isDefaultPrevented()&&(o=D(e).changedTouches[0],d.push({touchID:b,x:o.clientX,y:o.clientY}),m=!0),x("vmouseout",e,t),v=!1,Y())}function B(e){var t,o=p.data(e,i);if(o)for(t in o)if(o[t])return 1}function L(){}for(p.vmouse={moveDistanceThreshold:10,clickDistanceThreshold:10,resetTimerDuration:1500,maximumTimeBetweenTouches:100},e=0;e<t.length;e++)p.event.special[t[e]]=(o=>{var n=o.substr(1);return{setup:function(){B(this)||p.data(this,i,{}),p.data(this,i)[o]=!0,a[o]=(a[o]||0)+1,1===a[o]&&T.on(n,M),p(this).on(n,L),w&&(a.touchstart=(a.touchstart||0)+1,1===a.touchstart)&&T.on("touchstart",I).on("touchend",S).on("touchmove",q).on("scroll",j)},teardown:function(){--a[o],a[o]||T.off(n,M),w&&(--a.touchstart,a.touchstart||T.off("touchstart",I).off("touchmove",q).off("touchend",S).off("scroll",j));var e=p(this),t=p.data(this,i);t&&(t[o]=!1),e.off(n,L),B(this)||e.removeData(i)}}})(t[e]);w&&K.addEventListener("click",function(e){var t,o,n,i,a,s=d.length,r=e.target;if(s)for(t=e.clientX,o=e.clientY,c=p.vmouse.clickDistanceThreshold,n=r;n;){for(i=0;i<s;i++)if(a=d[i],n===r&&Math.abs(a.x-t)<c&&Math.abs(a.y-o)<c||p.data(n,u)===a.touchID)return e.preventDefault(),void e.stopPropagation();n=n.parentNode}},!0)},"function"==typeof define&&define.amd?define("vmouse",["jquery"],t):t(e),t=function(u){var p=u(K),e=u.mobile.support.touch,o=e?"touchstart":"mousedown",r=e?"touchend":"mouseup",c=e?"touchmove":"mousemove";function l(e,t,o,n){var i=o.type;o.type=t,n?u.event.trigger(o,O,e):u.event.dispatch.call(e,o),o.type=i}return u.each("touchstart touchmove touchend tap taphold swipe swipeleft swiperight".split(" "),function(e,t){u.fn[t]=function(e){return e?this.on(t,e):this.trigger(t)},u.attrFn&&(u.attrFn[t]=!0)}),u.event.special.tap={tapholdThreshold:750,emitTapOnTaphold:!0,setup:function(){var s=this,r=u(s),c=!1;r.on("vmousedown",function(e){if(c=!1,e.which&&1!==e.which)return!0;var t,o,n=e.target;function i(){clearTimeout(t)}function a(){i(),r.off("vclick",o).off("vmouseup",i),p.off("vmousecancel",a)}o=function(e){a(),c||n!==e.target?c&&e.preventDefault():l(s,"tap",e)},r.on("vmouseup",i).on("vclick",o),p.on("vmousecancel",a),t=setTimeout(function(){u.event.special.tap.emitTapOnTaphold||(c=!0),t=0,l(s,"taphold",u.Event("taphold",{target:n}))},u.event.special.tap.tapholdThreshold)})},teardown:function(){u(this).off("vmousedown").off("vclick").off("vmouseup"),p.off("vmousecancel")}},u.event.special.swipe={scrollSupressionThreshold:30,durationThreshold:1e3,horizontalDistanceThreshold:2<=a.devicePixelRatio?15:30,verticalDistanceThreshold:2<=a.devicePixelRatio?15:30,getLocation:function(e){var t=a.pageXOffset,o=a.pageYOffset,n=e.clientX,i=e.clientY;return 0===e.pageY&&Math.floor(i)>Math.floor(e.pageY)||0===e.pageX&&Math.floor(n)>Math.floor(e.pageX)?(n-=t,i-=o):(i<e.pageY-o||n<e.pageX-t)&&(n=e.pageX-t,i=e.pageY-o),{x:n,y:i}},start:function(e){var t=e.originalEvent.touches?e.originalEvent.touches[0]:e,t=u.event.special.swipe.getLocation(t);return{time:(new Date).getTime(),coords:[t.x,t.y],origin:u(e.target)}},stop:function(e){e=e.originalEvent.touches?e.originalEvent.touches[0]:e,e=u.event.special.swipe.getLocation(e);return{time:(new Date).getTime(),coords:[e.x,e.y]}},handleSwipe:function(e,t,o,n){var i;return t.time-e.time<u.event.special.swipe.durationThreshold&&Math.abs(e.coords[0]-t.coords[0])>u.event.special.swipe.horizontalDistanceThreshold&&Math.abs(e.coords[1]-t.coords[1])<u.event.special.swipe.verticalDistanceThreshold&&(i=e.coords[0]>t.coords[0]?"swipeleft":"swiperight",l(o,"swipe",u.Event("swipe",{target:n,swipestart:e,swipestop:t}),!0),l(o,i,u.Event(i,{target:n,swipestart:e,swipestop:t}),!0),!0)},eventInProgress:!1,setup:function(){var a=this,e=u(a),s={},t=u.data(this,"mobile-events");t||u.data(this,"mobile-events",t={length:0}),t.length++,(t.swipe=s).start=function(e){var t,o,n,i;u.event.special.swipe.eventInProgress||(u.event.special.swipe.eventInProgress=!0,o=u.event.special.swipe.start(e),n=e.target,i=!1,s.move=function(e){o&&!e.isDefaultPrevented()&&(t=u.event.special.swipe.stop(e),i||(i=u.event.special.swipe.handleSwipe(o,t,a,n))&&(u.event.special.swipe.eventInProgress=!1),Math.abs(o.coords[0]-t.coords[0])>u.event.special.swipe.scrollSupressionThreshold)&&e.preventDefault()},s.stop=function(){i=!0,u.event.special.swipe.eventInProgress=!1,p.off(c,s.move),s.move=null},p.on(c,s.move).one(r,s.stop))},e.on(o,s.start)},teardown:function(){var e,t=u.data(this,"mobile-events");t&&(e=t.swipe,delete t.swipe,t.length--,0===t.length)&&u.removeData(this,"mobile-events"),e&&(e.start&&u(this).off(o,e.start),e.move&&p.off(c,e.move),e.stop)&&p.off(r,e.stop)}},u.each({taphold:"tap",swipeleft:"swipe.left",swiperight:"swipe.right"},function(e,t){u.event.special[e]={setup:function(){u(this).on(t,u.noop)},teardown:function(){u(this).off(t)}}}),u.event.special},"function"==typeof define&&define.amd?define("events/touch",["jquery","../vmouse","../support/touch"],t):t(e),t=function(s){var r="touchmove scroll";return s.each(["scrollstart","scrollstop"],function(e,t){s.fn[t]=function(e){return e?this.on(t,e):this.trigger(t)},s.attrFn&&(s.attrFn[t]=!0)}),s.event.special.scrollstart={enabled:!0,setup:function(){var n,t,i=this,e=s(i);function o(e,t){var o=e.type;n=t,e.type=n?"scrollstart":"scrollstop",s.event.dispatch.call(i,e),e.type=o}var a=s.event.special.scrollstart.handler=function(e){s.event.special.scrollstart.enabled&&(n||o(e,!0),clearTimeout(t),t=setTimeout(function(){o(e,!1)},50))};e.on(r,a)},teardown:function(){s(this).off(r,s.event.special.scrollstart.handler)}},s.each({scrollstop:"scrollstart"},function(e,t){s.event.special[e]={setup:function(){s(this).on(t,s.noop)},teardown:function(){s(this).off(t)}}}),s.event.special},"function"==typeof define&&define.amd?define("events/scroll",["jquery"],t):t(e)});
+\ No newline at end of file
++!function(t,o,n){"function"==typeof define&&define.amd?define(["jquery"],function(e){return n(e,t,o),e.mobile}):n(t.jQuery,t,o)}(this,document,function(e,a,K,O){var t;t=function(e){return e.ui=e.ui||{},e.ui.version="1.12.1"},"function"==typeof define&&define.amd?define("jquery-ui/version",["jquery"],t):t(e),t=function(){},"function"==typeof define&&define.amd&&define("core",["./defaults","./data","./helpers"],t),t=function(e){var t={touch:"ontouchend"in K};return e.mobile={},e.mobile.support=e.mobile.support||{},e.extend(e.support,t),e.extend(e.mobile.support,t),e.support},"function"==typeof define&&define.amd?define("support/touch",["jquery","../ns"],t):t(e),t=function(e){return e.extend(e.support,{orientation:"orientation"in a&&"onorientationchange"in a}),e.support},"function"==typeof define&&define.amd?define("support/orientation",["jquery"],t):t(e),t=function(p){var c,e,i="virtualMouseBindings",u="virtualTouchID",l="clientX clientY pageX pageY screenX screenY".split(" "),t="vmouseover vmousedown vmousemove vmouseup vclick vmouseout vmousecancel".split(" "),f="altKey bubbles cancelable ctrlKey currentTarget detail eventPhase metaKey relatedTarget shiftKey target timeStamp view which".split(" "),o=p.event.mouseHooks?p.event.mouseHooks.props:[],h=f.concat(o),a={},n=0,s=0,r=0,v=!1,d=[],m=!1,g=!1,w="addEventListener"in K,T=p(K),y=1,b=0;function D(e){for(;e&&void 0!==e.originalEvent;)e=e.originalEvent;return e}function P(e){for(var t,o,n={};e;){for(o in t=p.data(e,i))t[o]&&(n[o]=n.hasVirtualBinding=!0);e=e.parentNode}return n}function k(){g=!0}function E(){b=0,d.length=0,m=!1,k()}function F(){g=!1}function X(){n&&(clearTimeout(n),n=0)}function Y(){X(),n=setTimeout(function(){n=0,E()},p.vmouse.resetTimerDuration)}function x(e,t,o){var n;return(o&&o[e]||!o&&function(e,t){for(var o;e;){if((o=p.data(e,i))&&(!t||o[t]))return e;e=e.parentNode}}(t.target,e))&&(n=function(e,t){var o,n,i,a,s,r,c,u=e.type;if((e=p.Event(e)).type=t,o=e.originalEvent,n=f,-1<u.search(/^(mouse|click)/)&&(n=h),o)for(s=n.length;s;)e[i=n[--s]]=o[i];if(-1<u.search(/mouse(down|up)|click/)&&!e.which&&(e.which=1),-1!==u.search(/^touch/)&&(u=(t=D(o)).touches,t=t.changedTouches,a=u&&u.length?u[0]:t&&t.length?t[0]:O))for(r=0,c=l.length;r<c;r++)e[i=l[r]]=a[i];return e}(t,e),p(t.target).trigger(n)),n}function M(e){var t=p.data(e.target,u);"click"===e.type&&"touchstart"===p.data(e.target,"lastTouchType")&&setTimeout(function(){"touchstart"===p.data(e.target,"lastTouchType")&&(E(),delete p.data(e.target).lastTouchType,M(e))},p.vmouse.maximumTimeBetweenTouches),m||b&&b===t||(t=x("v"+e.type,e))&&(t.isDefaultPrevented()&&e.preventDefault(),t.isPropagationStopped()&&e.stopPropagation(),t.isImmediatePropagationStopped())&&e.stopImmediatePropagation()}function I(e){var t,o=D(e).touches;o&&1===o.length&&(t=P(o=e.target),p.data(e.target,"lastTouchType",e.type),t.hasVirtualBinding)&&(b=y++,p.data(o,u,b),X(),F(),v=!1,o=D(e).touches[0],s=o.pageX,r=o.pageY,x("vmouseover",e,t),x("vmousedown",e,t))}function j(e){g||(v||x("vmousecancel",e,P(e.target)),p.data(e.target,"lastTouchType",e.type),v=!0,Y())}function q(e){var t,o,n,i;g||(t=D(e).touches[0],o=v,n=p.vmouse.moveDistanceThreshold,i=P(e.target),p.data(e.target,"lastTouchType",e.type),(v=v||Math.abs(t.pageX-s)>n||Math.abs(t.pageY-r)>n)&&!o&&x("vmousecancel",e,i),x("vmousemove",e,i),Y())}function S(e){var t,o;g||p.data(e.target,"lastTouchType")===O||(k(),delete p.data(e.target).lastTouchType,x("vmouseup",e,t=P(e.target)),v||(o=x("vclick",e,t))&&o.isDefaultPrevented()&&(o=D(e).changedTouches[0],d.push({touchID:b,x:o.clientX,y:o.clientY}),m=!0),x("vmouseout",e,t),v=!1,Y())}function B(e){var t,o=p.data(e,i);if(o)for(t in o)if(o[t])return 1}function L(){}for(p.vmouse={moveDistanceThreshold:10,clickDistanceThreshold:10,resetTimerDuration:1500,maximumTimeBetweenTouches:100},e=0;e<t.length;e++)p.event.special[t[e]]=function(o){var n=o.substr(1);return{setup:function(){B(this)||p.data(this,i,{}),p.data(this,i)[o]=!0,a[o]=(a[o]||0)+1,1===a[o]&&T.on(n,M),p(this).on(n,L),w&&(a.touchstart=(a.touchstart||0)+1,1===a.touchstart)&&T.on("touchstart",I).on("touchend",S).on("touchmove",q).on("scroll",j)},teardown:function(){--a[o],a[o]||T.off(n,M),w&&(--a.touchstart,a.touchstart||T.off("touchstart",I).off("touchmove",q).off("touchend",S).off("scroll",j));var e=p(this),t=p.data(this,i);t&&(t[o]=!1),e.off(n,L),B(this)||e.removeData(i)}}}(t[e]);w&&K.addEventListener("click",function(e){var t,o,n,i,a,s=d.length,r=e.target;if(s)for(t=e.clientX,o=e.clientY,c=p.vmouse.clickDistanceThreshold,n=r;n;){for(i=0;i<s;i++)if(a=d[i],n===r&&Math.abs(a.x-t)<c&&Math.abs(a.y-o)<c||p.data(n,u)===a.touchID)return e.preventDefault(),void e.stopPropagation();n=n.parentNode}},!0)},"function"==typeof define&&define.amd?define("vmouse",["jquery"],t):t(e),t=function(u){var p=u(K),e=u.mobile.support.touch,o=e?"touchstart":"mousedown",r=e?"touchend":"mouseup",c=e?"touchmove":"mousemove";function l(e,t,o,n){var i=o.type;o.type=t,n?u.event.trigger(o,O,e):u.event.dispatch.call(e,o),o.type=i}return u.each("touchstart touchmove touchend tap taphold swipe swipeleft swiperight".split(" "),function(e,t){u.fn[t]=function(e){return e?this.on(t,e):this.trigger(t)},u.attrFn&&(u.attrFn[t]=!0)}),u.event.special.tap={tapholdThreshold:750,emitTapOnTaphold:!0,setup:function(){var s=this,r=u(s),c=!1;r.on("vmousedown",function(e){if(c=!1,e.which&&1!==e.which)return!0;var t,o,n=e.target;function i(){clearTimeout(t)}function a(){i(),r.off("vclick",o).off("vmouseup",i),p.off("vmousecancel",a)}o=function(e){a(),c||n!==e.target?c&&e.preventDefault():l(s,"tap",e)},r.on("vmouseup",i).on("vclick",o),p.on("vmousecancel",a),t=setTimeout(function(){u.event.special.tap.emitTapOnTaphold||(c=!0),t=0,l(s,"taphold",u.Event("taphold",{target:n}))},u.event.special.tap.tapholdThreshold)})},teardown:function(){u(this).off("vmousedown").off("vclick").off("vmouseup"),p.off("vmousecancel")}},u.event.special.swipe={scrollSupressionThreshold:30,durationThreshold:1e3,horizontalDistanceThreshold:2<=a.devicePixelRatio?15:30,verticalDistanceThreshold:2<=a.devicePixelRatio?15:30,getLocation:function(e){var t=a.pageXOffset,o=a.pageYOffset,n=e.clientX,i=e.clientY;return 0===e.pageY&&Math.floor(i)>Math.floor(e.pageY)||0===e.pageX&&Math.floor(n)>Math.floor(e.pageX)?(n-=t,i-=o):(i<e.pageY-o||n<e.pageX-t)&&(n=e.pageX-t,i=e.pageY-o),{x:n,y:i}},start:function(e){var t=e.originalEvent.touches?e.originalEvent.touches[0]:e,t=u.event.special.swipe.getLocation(t);return{time:(new Date).getTime(),coords:[t.x,t.y],origin:u(e.target)}},stop:function(e){e=e.originalEvent.touches?e.originalEvent.touches[0]:e,e=u.event.special.swipe.getLocation(e);return{time:(new Date).getTime(),coords:[e.x,e.y]}},handleSwipe:function(e,t,o,n){var i;return t.time-e.time<u.event.special.swipe.durationThreshold&&Math.abs(e.coords[0]-t.coords[0])>u.event.special.swipe.horizontalDistanceThreshold&&Math.abs(e.coords[1]-t.coords[1])<u.event.special.swipe.verticalDistanceThreshold&&(i=e.coords[0]>t.coords[0]?"swipeleft":"swiperight",l(o,"swipe",u.Event("swipe",{target:n,swipestart:e,swipestop:t}),!0),l(o,i,u.Event(i,{target:n,swipestart:e,swipestop:t}),!0),!0)},eventInProgress:!1,setup:function(){var a=this,e=u(a),s={},t=u.data(this,"mobile-events");t||u.data(this,"mobile-events",t={length:0}),t.length++,(t.swipe=s).start=function(e){var t,o,n,i;u.event.special.swipe.eventInProgress||(u.event.special.swipe.eventInProgress=!0,o=u.event.special.swipe.start(e),n=e.target,i=!1,s.move=function(e){o&&!e.isDefaultPrevented()&&(t=u.event.special.swipe.stop(e),i||(i=u.event.special.swipe.handleSwipe(o,t,a,n))&&(u.event.special.swipe.eventInProgress=!1),Math.abs(o.coords[0]-t.coords[0])>u.event.special.swipe.scrollSupressionThreshold)&&e.preventDefault()},s.stop=function(){i=!0,u.event.special.swipe.eventInProgress=!1,p.off(c,s.move),s.move=null},p.on(c,s.move).one(r,s.stop))},e.on(o,s.start)},teardown:function(){var e,t=u.data(this,"mobile-events");t&&(e=t.swipe,delete t.swipe,t.length--,0===t.length)&&u.removeData(this,"mobile-events"),e&&(e.start&&u(this).off(o,e.start),e.move&&p.off(c,e.move),e.stop)&&p.off(r,e.stop)}},u.each({taphold:"tap",swipeleft:"swipe.left",swiperight:"swipe.right"},function(e,t){u.event.special[e]={setup:function(){u(this).on(t,u.noop)},teardown:function(){u(this).off(t)}}}),u.event.special},"function"==typeof define&&define.amd?define("events/touch",["jquery","../vmouse","../support/touch"],t):t(e),t=function(s){var r="touchmove scroll";return s.each(["scrollstart","scrollstop"],function(e,t){s.fn[t]=function(e){return e?this.on(t,e):this.trigger(t)},s.attrFn&&(s.attrFn[t]=!0)}),s.event.special.scrollstart={enabled:!0,setup:function(){var n,t,i=this,e=s(i);function o(e,t){var o=e.type;n=t,e.type=n?"scrollstart":"scrollstop",s.event.dispatch.call(i,e),e.type=o}var a=s.event.special.scrollstart.handler=function(e){s.event.special.scrollstart.enabled&&(n||o(e,!0),clearTimeout(t),t=setTimeout(function(){o(e,!1)},50))};e.on(r,a)},teardown:function(){s(this).off(r,s.event.special.scrollstart.handler)}},s.each({scrollstop:"scrollstart"},function(e,t){s.event.special[e]={setup:function(){s(this).on(t,s.noop)},teardown:function(){s(this).off(t)}}}),s.event.special},"function"==typeof define&&define.amd?define("events/scroll",["jquery"],t):t(e)});
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/styles/all/theme/chat.css" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/styles/all/theme/chat.css"
+index 806b78888..8285bc2c4 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/styles/all/theme/chat.css"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/styles/all/theme/chat.css"
+@@ -1,7 +1,7 @@
+ /*  cBB Chat StyleSheet
+     --------------------------------------------------------------
+ 	Style:	All
+-	Copyright (c) 2025 CaniDev ( https://www.canidev.com )
++	Copyright (c) 2024 CaniDev ( https://www.canidev.com )
+     --------------------------------------------------------------
+ */
+ 
+@@ -502,21 +502,23 @@ a.chat-quickmention {
+ }
+ 
+ .chat-editor-counter {
+-	display: flex;
+ 	top: 5px;
+ 	position: absolute;
+ 	right: 5px;
+ }
+ 
+ .chat-editor-counter > svg {
++	margin-bottom: -4px;
+ 	overflow: visible;
+ 	transform: rotate(-90deg);
+ }
+ 
+ .chat-editor-counter > span {
+ 	color: #e0245e;
+-	font-size: 0.8em;
++	font-size: 9px;
+ 	margin: 5px 2px 0 0;
++	display: inline-block;
++    vertical-align: top;
+ }
+ 
+ .chat-editor-counter .safe {
+@@ -663,6 +665,7 @@ ul.topiclist .chat-dialog-fieldset dd {
+ 
+ .chat-message,
+ .chat-tip-message {
++	font-size: 11px;
+ 	margin: 5px 0;
+ }
+ 
+@@ -812,11 +815,6 @@ html.embedmode { height: auto; }
+ 	padding-right: 5px;
+ }
+ 
+-.rtl #chat-message textarea,
+-.rtl .ic-edit-container textarea {
+-	border: none;
+-}
+-
+ .rtl .chat-editor-counter,
+ .rtl .chat-submit-btn {
+ 	left: 5px;
+@@ -971,10 +969,10 @@ html.embedmode { height: auto; }
+ 	box-shadow: 0 0 4px 0px #2e2e2e;
+ }
+ 
+-.medium-dark-theme #chat-content,
+-.medium-dark-theme #chat-content a {
+-	color: #000;
+-}
++/* .medium-dark-theme #chat-content, */
++/* .medium-dark-theme #chat-content a { */
++	/* color: #000; */
++/* } */
+ 
+ /* Responsive Layout
+ ------------------------------- */
diff --git "[FORUM_EXT]/canidev\\chat/diff_nospace.tmp" "[FORUM_EXT]/canidev\\chat/diff_nospace.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/canidev\\chat/diff_nospace.tmp"
@@ -0,0 +1,1133 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/acp/main_info.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/acp/main_info.php"
+index d789c1778..9ca4f8bd7 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/acp/main_info.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/acp/main_info.php"
+@@ -1,9 +1,9 @@
+ <?php
+ /**
+  * @package cBB Chat
+- * @version 1.2.7 07/03/2025
++ * @version 1.2.6 01/07/2024
+  *
+- * @copyright (c) 2025 CaniDev
++ * @copyright (c) 2024 CaniDev
+  * @license https://creativecommons.org/licenses/by-nc/4.0/
+  */
+ 
+@@ -16,7 +16,7 @@ class main_info
+ 		return [
+ 			'filename'	=> '\canidev\chat\acp\main_module',
+ 			'title'		=> 'ACP_CAT_CHAT',
+-			'version'	=> '1.2.7',
++			'version'	=> '1.2.6',
+ 			'modes'		=> [
+ 				'config'	=> ['title' => 'ACP_CHAT_CONFIG', 	'auth' => 'ext_canidev/chat && acl_a_chat', 'cat' => ['ACP_CAT_CHAT']],
+ 				'pages'		=> ['title' => 'ACP_CHAT_PAGES', 	'auth' => 'ext_canidev/chat && acl_a_chat', 'cat' => ['ACP_CAT_CHAT']],
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/acp/main_module.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/acp/main_module.php"
+index 13d6c4276..45a417adb 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/acp/main_module.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/acp/main_module.php"
+@@ -1,9 +1,9 @@
+ <?php
+ /**
+  * @package cBB Chat
+- * @version 1.2.7 07/03/2025
++ * @version 1.2.6 01/07/2024
+  *
+- * @copyright (c) 2025 CaniDev
++ * @copyright (c) 2024 CaniDev
+  * @license https://creativecommons.org/licenses/by-nc/4.0/
+  */
+ 
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/adm/style/acp.css" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/adm/style/acp.css"
+index 6896ea983..83f605e8f 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/adm/style/acp.css"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/adm/style/acp.css"
+@@ -1,7 +1,7 @@
+ /*  cBB Chat StyleSheet
+     --------------------------------------------------------------
+ 	Style:	Admin
+-	Copyright (c) 2025 CaniDev ( https://www.canidev.com )
++	Copyright (c) 2024 CaniDev ( https://www.canidev.com )
+     --------------------------------------------------------------
+ */
+ 
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/adm/style/js/jchat-acp.js" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/adm/style/js/jchat-acp.js"
+index 96b9defa6..e68ee4d8d 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/adm/style/js/jchat-acp.js"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/adm/style/js/jchat-acp.js"
+@@ -1,8 +1,8 @@
+ /**
+  * @package cBB Chat
+- * @version 1.2.7 10/03/2025
++ * @version 1.2.6 01/07/2024
+  *
+- * @copyright (c) 2025 CaniDev
++ * @copyright (c) 2024 CaniDev
+  * @license https://creativecommons.org/licenses/by-nc/4.0/
+  */
+-((t,e)=>{t("#page_file").change(function(){var e=t(this).val(),i="viewforum"==e||"viewtopic"==e,e="-"==e;t("dl:has(#forum_ids)").objView(i),t("dl:has(#custom_file), dl:has(#page_alias)").objView(e)}).change(),t(".pagerow-input").click(function(){this.focus(),this.select()});var i=t("form:first"),a=!1;t(".sortable-text ul").sortable({update:function(){a||(a=!0,e.request({url:i.attr("action"),data:i.serialize(),onComplete:function(){a=!1}}))}}).disableSelection()})(jQuery,cbbCore);
+\ No newline at end of file
++!function(i,e){"use strict";i("#page_file").change(function(){var e=i(this).val(),t="viewforum"==e||"viewtopic"==e,e="-"==e;i("dl:has(#forum_ids)").objView(t),i("dl:has(#custom_file), dl:has(#page_alias)").objView(e)}).change(),i(".pagerow-input").click(function(){this.focus(),this.select()});var t=i("form:first"),a=!1;i(".sortable-text ul").sortable({update:function(){a||(a=!0,e.request({url:t.attr("action"),data:t.serialize(),onComplete:function(){a=!1}}))}}).disableSelection()}(jQuery,cbbCore);
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/composer.json"
+index dd67bf684..dfb276799 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/composer.json"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/composer.json"
+@@ -3,7 +3,7 @@
+ 	"type": "phpbb-extension",
+ 	"description": "",
+ 	"homepage": "https://www.canidev.com",
+-	"version": "1.2.7",
++	"version": "1.2.6",
+ 	"keywords": ["phpbb", "extension", "canidev", "chat"],
+ 	"license": "CreativeCommons Attribution-NonCommercial v4.0",
+ 	"authors": [
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/controller/admin_controller_base.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/controller/admin_controller_base.php"
+index 3fb267289..49c832232 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/controller/admin_controller_base.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/controller/admin_controller_base.php"
+@@ -1,9 +1,9 @@
+ <?php
+ /**
+  * @package cBB Chat
+- * @version 1.2.7 07/03/2025
++ * @version 1.2.6 01/07/2024
+  *
+- * @copyright (c) 2025 CaniDev
++ * @copyright (c) 2024 CaniDev
+  * @license https://creativecommons.org/licenses/by-nc/4.0/
+  */
+ 
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/controller/admin_controller_config.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/controller/admin_controller_config.php"
+index 19af9ac74..0682e94e3 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/controller/admin_controller_config.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/controller/admin_controller_config.php"
+@@ -1,9 +1,9 @@
+ <?php
+ /**
+  * @package cBB Chat
+- * @version 1.2.7 07/03/2025
++ * @version 1.2.6 01/07/2024
+  *
+- * @copyright (c) 2025 CaniDev
++ * @copyright (c) 2024 CaniDev
+  * @license https://creativecommons.org/licenses/by-nc/4.0/
+  */
+ 
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/controller/admin_controller_pages.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/controller/admin_controller_pages.php"
+index dd2d10a8e..a9d01f499 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/controller/admin_controller_pages.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/controller/admin_controller_pages.php"
+@@ -1,9 +1,9 @@
+ <?php
+ /**
+  * @package cBB Chat
+- * @version 1.2.7 07/03/2025
++ * @version 1.2.6 01/07/2024
+  *
+- * @copyright (c) 2025 CaniDev
++ * @copyright (c) 2024 CaniDev
+  * @license https://creativecommons.org/licenses/by-nc/4.0/
+  */
+ 
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/controller/admin_controller_rooms.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/controller/admin_controller_rooms.php"
+index 0e45aa137..77817fe91 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/controller/admin_controller_rooms.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/controller/admin_controller_rooms.php"
+@@ -1,9 +1,9 @@
+ <?php
+ /**
+  * @package cBB Chat
+- * @version 1.2.7 07/03/2025
++ * @version 1.2.6 01/07/2024
+  *
+- * @copyright (c) 2025 CaniDev
++ * @copyright (c) 2024 CaniDev
+  * @license https://creativecommons.org/licenses/by-nc/4.0/
+  */
+ 
+@@ -84,7 +84,7 @@ class admin_controller_rooms extends admin_controller_base
+ 				
+ 				$room_auth = @unserialize($room_data['room_data']);
+ 
+-				$room_data['room_groups'] 	= empty($room_auth['groups']) ? '' : $room_auth['groups'];
++				$room_data['room_groups'] 	= $room_auth['groups'];
+ 				$room_data['room_users']	= (empty($room_auth['users']) ? '' : implode("\n", $room_auth['users']));
+ 				$room_data['linked_forums']	= (empty($room_auth['linked_forums']) ? [] : $room_auth['linked_forums']);
+ 				$room_data['linked_groups']	= (empty($room_auth['linked_groups']) ? [] : $room_auth['linked_groups']);
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/controller/admin_controller_texts.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/controller/admin_controller_texts.php"
+index f4150689f..ce07e1979 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/controller/admin_controller_texts.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/controller/admin_controller_texts.php"
+@@ -1,9 +1,9 @@
+ <?php
+ /**
+  * @package cBB Chat
+- * @version 1.2.7 07/03/2025
++ * @version 1.2.6 01/07/2024
+  *
+- * @copyright (c) 2025 CaniDev
++ * @copyright (c) 2024 CaniDev
+  * @license https://creativecommons.org/licenses/by-nc/4.0/
+  */
+ 
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/controller/main_controller.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/controller/main_controller.php"
+index 1a2647700..887ad620e 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/controller/main_controller.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/controller/main_controller.php"
+@@ -1,9 +1,9 @@
+ <?php
+ /**
+  * @package cBB Chat
+- * @version 1.2.7 07/03/2025
++ * @version 1.2.6 01/07/2024
+  *
+- * @copyright (c) 2025 CaniDev
++ * @copyright (c) 2024 CaniDev
+  * @license https://creativecommons.org/licenses/by-nc/4.0/
+  */
+ 
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/controller/mcp_controller_config.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/controller/mcp_controller_config.php"
+index cff15c94b..d800087af 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/controller/mcp_controller_config.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/controller/mcp_controller_config.php"
+@@ -1,9 +1,9 @@
+ <?php
+ /**
+  * @package cBB Chat
+- * @version 1.2.7 07/03/2025
++ * @version 1.2.6 01/07/2024
+  *
+- * @copyright (c) 2025 CaniDev
++ * @copyright (c) 2024 CaniDev
+  * @license https://creativecommons.org/licenses/by-nc/4.0/
+  */
+ 
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/cron/prune.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/cron/prune.php"
+index fee3e3579..6608f9b33 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/cron/prune.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/cron/prune.php"
+@@ -1,9 +1,9 @@
+ <?php
+ /**
+  * @package cBB Chat
+- * @version 1.2.7 07/03/2025
++ * @version 1.2.6 01/07/2024
+  *
+- * @copyright (c) 2025 CaniDev
++ * @copyright (c) 2024 CaniDev
+  * @license https://creativecommons.org/licenses/by-nc/4.0/
+  */
+ 
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/diff_full.tmp"
+new file mode 100644
+index 000000000..513ceb2be
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/diff_full.tmp"
+@@ -0,0 +1,980 @@
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/acp/main_info.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/acp/main_info.php"
++index d789c1778..9ca4f8bd7 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/acp/main_info.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/acp/main_info.php"
++@@ -1,9 +1,9 @@
++ <?php
++ /**
++  * @package cBB Chat
++- * @version 1.2.7 07/03/2025
+++ * @version 1.2.6 01/07/2024
++  *
++- * @copyright (c) 2025 CaniDev
+++ * @copyright (c) 2024 CaniDev
++  * @license https://creativecommons.org/licenses/by-nc/4.0/
++  */
++ 
++@@ -16,7 +16,7 @@ class main_info
++ 		return [
++ 			'filename'	=> '\canidev\chat\acp\main_module',
++ 			'title'		=> 'ACP_CAT_CHAT',
++-			'version'	=> '1.2.7',
+++			'version'	=> '1.2.6',
++ 			'modes'		=> [
++ 				'config'	=> ['title' => 'ACP_CHAT_CONFIG', 	'auth' => 'ext_canidev/chat && acl_a_chat', 'cat' => ['ACP_CAT_CHAT']],
++ 				'pages'		=> ['title' => 'ACP_CHAT_PAGES', 	'auth' => 'ext_canidev/chat && acl_a_chat', 'cat' => ['ACP_CAT_CHAT']],
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/acp/main_module.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/acp/main_module.php"
++index 13d6c4276..45a417adb 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/acp/main_module.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/acp/main_module.php"
++@@ -1,9 +1,9 @@
++ <?php
++ /**
++  * @package cBB Chat
++- * @version 1.2.7 07/03/2025
+++ * @version 1.2.6 01/07/2024
++  *
++- * @copyright (c) 2025 CaniDev
+++ * @copyright (c) 2024 CaniDev
++  * @license https://creativecommons.org/licenses/by-nc/4.0/
++  */
++ 
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/adm/style/acp.css" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/adm/style/acp.css"
++index 6896ea983..83f605e8f 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/adm/style/acp.css"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/adm/style/acp.css"
++@@ -1,7 +1,7 @@
++ /*  cBB Chat StyleSheet
++     --------------------------------------------------------------
++ 	Style:	Admin
++-	Copyright (c) 2025 CaniDev ( https://www.canidev.com )
+++	Copyright (c) 2024 CaniDev ( https://www.canidev.com )
++     --------------------------------------------------------------
++ */
++ 
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/adm/style/js/jchat-acp.js" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/adm/style/js/jchat-acp.js"
++index 96b9defa6..e68ee4d8d 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/adm/style/js/jchat-acp.js"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/adm/style/js/jchat-acp.js"
++@@ -1,8 +1,8 @@
++ /**
++  * @package cBB Chat
++- * @version 1.2.7 10/03/2025
+++ * @version 1.2.6 01/07/2024
++  *
++- * @copyright (c) 2025 CaniDev
+++ * @copyright (c) 2024 CaniDev
++  * @license https://creativecommons.org/licenses/by-nc/4.0/
++  */
++-((t,e)=>{t("#page_file").change(function(){var e=t(this).val(),i="viewforum"==e||"viewtopic"==e,e="-"==e;t("dl:has(#forum_ids)").objView(i),t("dl:has(#custom_file), dl:has(#page_alias)").objView(e)}).change(),t(".pagerow-input").click(function(){this.focus(),this.select()});var i=t("form:first"),a=!1;t(".sortable-text ul").sortable({update:function(){a||(a=!0,e.request({url:i.attr("action"),data:i.serialize(),onComplete:function(){a=!1}}))}}).disableSelection()})(jQuery,cbbCore);
++\ No newline at end of file
+++!function(i,e){"use strict";i("#page_file").change(function(){var e=i(this).val(),t="viewforum"==e||"viewtopic"==e,e="-"==e;i("dl:has(#forum_ids)").objView(t),i("dl:has(#custom_file), dl:has(#page_alias)").objView(e)}).change(),i(".pagerow-input").click(function(){this.focus(),this.select()});var t=i("form:first"),a=!1;i(".sortable-text ul").sortable({update:function(){a||(a=!0,e.request({url:t.attr("action"),data:t.serialize(),onComplete:function(){a=!1}}))}}).disableSelection()}(jQuery,cbbCore);
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/composer.json"
++index dd67bf684..dfb276799 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/composer.json"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/composer.json"
++@@ -3,7 +3,7 @@
++ 	"type": "phpbb-extension",
++ 	"description": "",
++ 	"homepage": "https://www.canidev.com",
++-	"version": "1.2.7",
+++	"version": "1.2.6",
++ 	"keywords": ["phpbb", "extension", "canidev", "chat"],
++ 	"license": "CreativeCommons Attribution-NonCommercial v4.0",
++ 	"authors": [
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/controller/admin_controller_base.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/controller/admin_controller_base.php"
++index 3fb267289..49c832232 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/controller/admin_controller_base.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/controller/admin_controller_base.php"
++@@ -1,9 +1,9 @@
++ <?php
++ /**
++  * @package cBB Chat
++- * @version 1.2.7 07/03/2025
+++ * @version 1.2.6 01/07/2024
++  *
++- * @copyright (c) 2025 CaniDev
+++ * @copyright (c) 2024 CaniDev
++  * @license https://creativecommons.org/licenses/by-nc/4.0/
++  */
++ 
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/controller/admin_controller_config.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/controller/admin_controller_config.php"
++index 19af9ac74..0682e94e3 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/controller/admin_controller_config.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/controller/admin_controller_config.php"
++@@ -1,9 +1,9 @@
++ <?php
++ /**
++  * @package cBB Chat
++- * @version 1.2.7 07/03/2025
+++ * @version 1.2.6 01/07/2024
++  *
++- * @copyright (c) 2025 CaniDev
+++ * @copyright (c) 2024 CaniDev
++  * @license https://creativecommons.org/licenses/by-nc/4.0/
++  */
++ 
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/controller/admin_controller_pages.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/controller/admin_controller_pages.php"
++index dd2d10a8e..a9d01f499 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/controller/admin_controller_pages.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/controller/admin_controller_pages.php"
++@@ -1,9 +1,9 @@
++ <?php
++ /**
++  * @package cBB Chat
++- * @version 1.2.7 07/03/2025
+++ * @version 1.2.6 01/07/2024
++  *
++- * @copyright (c) 2025 CaniDev
+++ * @copyright (c) 2024 CaniDev
++  * @license https://creativecommons.org/licenses/by-nc/4.0/
++  */
++ 
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/controller/admin_controller_rooms.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/controller/admin_controller_rooms.php"
++index 0e45aa137..77817fe91 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/controller/admin_controller_rooms.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/controller/admin_controller_rooms.php"
++@@ -1,9 +1,9 @@
++ <?php
++ /**
++  * @package cBB Chat
++- * @version 1.2.7 07/03/2025
+++ * @version 1.2.6 01/07/2024
++  *
++- * @copyright (c) 2025 CaniDev
+++ * @copyright (c) 2024 CaniDev
++  * @license https://creativecommons.org/licenses/by-nc/4.0/
++  */
++ 
++@@ -84,7 +84,7 @@ class admin_controller_rooms extends admin_controller_base
++ 				
++ 				$room_auth = @unserialize($room_data['room_data']);
++ 
++-				$room_data['room_groups'] 	= empty($room_auth['groups']) ? '' : $room_auth['groups'];
+++				$room_data['room_groups'] 	= $room_auth['groups'];
++ 				$room_data['room_users']	= (empty($room_auth['users']) ? '' : implode("\n", $room_auth['users']));
++ 				$room_data['linked_forums']	= (empty($room_auth['linked_forums']) ? [] : $room_auth['linked_forums']);
++ 				$room_data['linked_groups']	= (empty($room_auth['linked_groups']) ? [] : $room_auth['linked_groups']);
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/controller/admin_controller_texts.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/controller/admin_controller_texts.php"
++index f4150689f..ce07e1979 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/controller/admin_controller_texts.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/controller/admin_controller_texts.php"
++@@ -1,9 +1,9 @@
++ <?php
++ /**
++  * @package cBB Chat
++- * @version 1.2.7 07/03/2025
+++ * @version 1.2.6 01/07/2024
++  *
++- * @copyright (c) 2025 CaniDev
+++ * @copyright (c) 2024 CaniDev
++  * @license https://creativecommons.org/licenses/by-nc/4.0/
++  */
++ 
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/controller/main_controller.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/controller/main_controller.php"
++index 1a2647700..887ad620e 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/controller/main_controller.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/controller/main_controller.php"
++@@ -1,9 +1,9 @@
++ <?php
++ /**
++  * @package cBB Chat
++- * @version 1.2.7 07/03/2025
+++ * @version 1.2.6 01/07/2024
++  *
++- * @copyright (c) 2025 CaniDev
+++ * @copyright (c) 2024 CaniDev
++  * @license https://creativecommons.org/licenses/by-nc/4.0/
++  */
++ 
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/controller/mcp_controller_config.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/controller/mcp_controller_config.php"
++index cff15c94b..d800087af 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/controller/mcp_controller_config.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/controller/mcp_controller_config.php"
++@@ -1,9 +1,9 @@
++ <?php
++ /**
++  * @package cBB Chat
++- * @version 1.2.7 07/03/2025
+++ * @version 1.2.6 01/07/2024
++  *
++- * @copyright (c) 2025 CaniDev
+++ * @copyright (c) 2024 CaniDev
++  * @license https://creativecommons.org/licenses/by-nc/4.0/
++  */
++ 
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/cron/prune.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/cron/prune.php"
++index fee3e3579..6608f9b33 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/cron/prune.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/cron/prune.php"
++@@ -1,9 +1,9 @@
++ <?php
++ /**
++  * @package cBB Chat
++- * @version 1.2.7 07/03/2025
+++ * @version 1.2.6 01/07/2024
++  *
++- * @copyright (c) 2025 CaniDev
+++ * @copyright (c) 2024 CaniDev
++  * @license https://creativecommons.org/licenses/by-nc/4.0/
++  */
++ 
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/diff_full.tmp"
++new file mode 100644
++index 000000000..039fd3df7
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/diff_full.tmp"
++@@ -0,0 +1,146 @@
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/acp/main_info.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/acp/main_info.php"
+++index d789c1778..9ca4f8bd7 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/acp/main_info.php"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/acp/main_info.php"
+++@@ -1,9 +1,9 @@
+++ <?php
+++ /**
+++  * @package cBB Chat
+++- * @version 1.2.7 07/03/2025
++++ * @version 1.2.6 01/07/2024
+++  *
+++- * @copyright (c) 2025 CaniDev
++++ * @copyright (c) 2024 CaniDev
+++  * @license https://creativecommons.org/licenses/by-nc/4.0/
+++  */
+++ 
+++@@ -16,7 +16,7 @@ class main_info
+++ 		return [
+++ 			'filename'	=> '\canidev\chat\acp\main_module',
+++ 			'title'		=> 'ACP_CAT_CHAT',
+++-			'version'	=> '1.2.7',
++++			'version'	=> '1.2.6',
+++ 			'modes'		=> [
+++ 				'config'	=> ['title' => 'ACP_CHAT_CONFIG', 	'auth' => 'ext_canidev/chat && acl_a_chat', 'cat' => ['ACP_CAT_CHAT']],
+++ 				'pages'		=> ['title' => 'ACP_CHAT_PAGES', 	'auth' => 'ext_canidev/chat && acl_a_chat', 'cat' => ['ACP_CAT_CHAT']],
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/acp/main_module.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/acp/main_module.php"
+++index 13d6c4276..45a417adb 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/acp/main_module.php"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/acp/main_module.php"
+++@@ -1,9 +1,9 @@
+++ <?php
+++ /**
+++  * @package cBB Chat
+++- * @version 1.2.7 07/03/2025
++++ * @version 1.2.6 01/07/2024
+++  *
+++- * @copyright (c) 2025 CaniDev
++++ * @copyright (c) 2024 CaniDev
+++  * @license https://creativecommons.org/licenses/by-nc/4.0/
+++  */
+++ 
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/adm/style/acp.css" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/adm/style/acp.css"
+++index 6896ea983..83f605e8f 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/adm/style/acp.css"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/adm/style/acp.css"
+++@@ -1,7 +1,7 @@
+++ /*  cBB Chat StyleSheet
+++     --------------------------------------------------------------
+++ 	Style:	Admin
+++-	Copyright (c) 2025 CaniDev ( https://www.canidev.com )
++++	Copyright (c) 2024 CaniDev ( https://www.canidev.com )
+++     --------------------------------------------------------------
+++ */
+++ 
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/adm/style/js/jchat-acp.js" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/adm/style/js/jchat-acp.js"
+++index 96b9defa6..e68ee4d8d 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/adm/style/js/jchat-acp.js"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/adm/style/js/jchat-acp.js"
+++@@ -1,8 +1,8 @@
+++ /**
+++  * @package cBB Chat
+++- * @version 1.2.7 10/03/2025
++++ * @version 1.2.6 01/07/2024
+++  *
+++- * @copyright (c) 2025 CaniDev
++++ * @copyright (c) 2024 CaniDev
+++  * @license https://creativecommons.org/licenses/by-nc/4.0/
+++  */
+++-((t,e)=>{t("#page_file").change(function(){var e=t(this).val(),i="viewforum"==e||"viewtopic"==e,e="-"==e;t("dl:has(#forum_ids)").objView(i),t("dl:has(#custom_file), dl:has(#page_alias)").objView(e)}).change(),t(".pagerow-input").click(function(){this.focus(),this.select()});var i=t("form:first"),a=!1;t(".sortable-text ul").sortable({update:function(){a||(a=!0,e.request({url:i.attr("action"),data:i.serialize(),onComplete:function(){a=!1}}))}}).disableSelection()})(jQuery,cbbCore);
+++\ No newline at end of file
++++!function(i,e){"use strict";i("#page_file").change(function(){var e=i(this).val(),t="viewforum"==e||"viewtopic"==e,e="-"==e;i("dl:has(#forum_ids)").objView(t),i("dl:has(#custom_file), dl:has(#page_alias)").objView(e)}).change(),i(".pagerow-input").click(function(){this.focus(),this.select()});var t=i("form:first"),a=!1;i(".sortable-text ul").sortable({update:function(){a||(a=!0,e.request({url:t.attr("action"),data:t.serialize(),onComplete:function(){a=!1}}))}}).disableSelection()}(jQuery,cbbCore);
+++\ No newline at end of file
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/composer.json"
+++index dd67bf684..dfb276799 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/composer.json"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/composer.json"
+++@@ -3,7 +3,7 @@
+++ 	"type": "phpbb-extension",
+++ 	"description": "",
+++ 	"homepage": "https://www.canidev.com",
+++-	"version": "1.2.7",
++++	"version": "1.2.6",
+++ 	"keywords": ["phpbb", "extension", "canidev", "chat"],
+++ 	"license": "CreativeCommons Attribution-NonCommercial v4.0",
+++ 	"authors": [
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/controller/admin_controller_base.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/controller/admin_controller_base.php"
+++index 3fb267289..49c832232 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/controller/admin_controller_base.php"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/controller/admin_controller_base.php"
+++@@ -1,9 +1,9 @@
+++ <?php
+++ /**
+++  * @package cBB Chat
+++- * @version 1.2.7 07/03/2025
++++ * @version 1.2.6 01/07/2024
+++  *
+++- * @copyright (c) 2025 CaniDev
++++ * @copyright (c) 2024 CaniDev
+++  * @license https://creativecommons.org/licenses/by-nc/4.0/
+++  */
+++ 
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/controller/admin_controller_config.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/controller/admin_controller_config.php"
+++index 19af9ac74..0682e94e3 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/controller/admin_controller_config.php"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/controller/admin_controller_config.php"
+++@@ -1,9 +1,9 @@
+++ <?php
+++ /**
+++  * @package cBB Chat
+++- * @version 1.2.7 07/03/2025
++++ * @version 1.2.6 01/07/2024
+++  *
+++- * @copyright (c) 2025 CaniDev
++++ * @copyright (c) 2024 CaniDev
+++  * @license https://creativecommons.org/licenses/by-nc/4.0/
+++  */
+++ 
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/controller/admin_controller_pages.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/controller/admin_controller_pages.php"
+++index dd2d10a8e..a9d01f499 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/controller/admin_controller_pages.php"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/controller/admin_controller_pages.php"
+++@@ -1,9 +1,9 @@
+++ <?php
+++ /**
+++  * @package cBB Chat
+++- * @version 1.2.7 07/03/2025
++++ * @version 1.2.6 01/07/2024
+++  *
+++- * @copyright (c) 2025 CaniDev
++++ * @copyright (c) 2024 CaniDev
+++  * @license https://creativecommons.org/licenses/by-nc/4.0/
+++  */
+++ 
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/controller/admin_controller_rooms.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/controller/admin_controller_rooms.php"
+++index 0e45aa137..77817fe91 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/controller/admin_controller_rooms.php"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/controller/admin_controller_rooms.php"
+++@@ -1,9 +1,9 @@
+++ <?php
+++ /**
+++  * @package cBB Chat
+++- * @version 1.2.7 07/03/2025
++++ * @version 1.2.6 01/07/2024
+++  *
+++- * @copyright (c) 2025 CaniDev
++++ * @copyright (c) 2
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/event/listener.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/event/listener.php"
++index a3943ba8c..1acc61ec5 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/event/listener.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/event/listener.php"
++@@ -1,9 +1,9 @@
++ <?php
++ /**
++  * @package cBB Chat
++- * @version 1.2.7 07/03/2025
+++ * @version 1.2.6 01/07/2024
++  *
++- * @copyright (c) 2025 CaniDev
+++ * @copyright (c) 2024 CaniDev
++  * @license https://creativecommons.org/licenses/by-nc/4.0/
++  */
++ 
++@@ -47,7 +47,7 @@ class listener implements EventSubscriberInterface
++ 	{
++ 		return [
++ 			'core.user_setup'					=> 'load_language',
++-			'core.user_setup_after'				=> ['on_setup_after', -2],
+++			'core.user_setup_after'				=> 'on_setup_after',
++ 			'core.session_kill_after'			=> 'on_user_logout',
++ 			'core.page_footer'					=> 'on_footer',
++ 			'core.delete_user_after'			=> 'on_user_delete',
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/ext.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/ext.php"
++index 5d40fd3fd..7162db7dd 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/ext.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/ext.php"
++@@ -1,9 +1,9 @@
++ <?php
++ /**
++  * @package cBB Chat
++- * @version 1.2.7 07/03/2025
+++ * @version 1.2.6 01/07/2024
++  *
++- * @copyright (c) 2025 CaniDev
+++ * @copyright (c) 2024 CaniDev
++  * @license https://creativecommons.org/licenses/by-nc/4.0/
++  */
++ 
++@@ -12,7 +12,7 @@ namespace canidev\chat;
++ class ext extends \phpbb\extension\base
++ {
++ 	const REQUIRED_PHPBB	= '3.2.0';
++-	const REQUIRED_CORE		= '1.1.10';
+++	const REQUIRED_CORE		= '1.1.6';
++ 
++ 	/**
++ 	 * {@inheritDoc}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/language/en/acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/language/en/acp.php"
++index aaf16c342..f891159c6 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/language/en/acp.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/language/en/acp.php"
++@@ -2,9 +2,9 @@
++ /**
++  * [English [En]]
++  * @package cBB Chat
++- * @version 1.2.7 07/03/2025
+++ * @version 1.2.6 01/07/2024
++  *
++- * @copyright (c) 2025 CaniDev
+++ * @copyright (c) 2024 CaniDev
++  * @license https://creativecommons.org/licenses/by-nc/4.0/
++  */
++ 
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/language/en/info_acp_chat.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/language/en/info_acp_chat.php"
++index 4417e0c3e..5e23be08d 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/language/en/info_acp_chat.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/language/en/info_acp_chat.php"
++@@ -2,9 +2,9 @@
++ /**
++  * [English [En]]
++  * @package cBB Chat
++- * @version 1.2.7 07/03/2025
+++ * @version 1.2.6 01/07/2024
++  *
++- * @copyright (c) 2025 CaniDev
+++ * @copyright (c) 2024 CaniDev
++  * @license https://creativecommons.org/licenses/by-nc/4.0/
++  */
++ 
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/language/en/info_mcp_chat.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/language/en/info_mcp_chat.php"
++index ea86ca26c..cde907a48 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/language/en/info_mcp_chat.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/language/en/info_mcp_chat.php"
++@@ -2,9 +2,9 @@
++ /**
++  * [English [En]]
++  * @package cBB Chat
++- * @version 1.2.7 07/03/2025
+++ * @version 1.2.6 01/07/2024
++  *
++- * @copyright (c) 2025 CaniDev
+++ * @copyright (c) 2024 CaniDev
++  * @license https://creativecommons.org/licenses/by-nc/4.0/
++  */
++ 
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/language/en/main.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/language/en/main.php"
++index 9c1339bdc..ddf028bac 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/language/en/main.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/language/en/main.php"
++@@ -2,9 +2,9 @@
++ /**
++  * [English [En]]
++  * @package cBB Chat
++- * @version 1.2.7 07/03/2025
+++ * @version 1.2.6 01/07/2024
++  *
++- * @copyright (c) 2025 CaniDev
+++ * @copyright (c) 2024 CaniDev
++  * @license https://creativecommons.org/licenses/by-nc/4.0/
++  */
++ 
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/language/en/permissions_chat.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/language/en/permissions_chat.php"
++index 9d86befeb..64e2e9277 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/language/en/permissions_chat.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/language/en/permissions_chat.php"
++@@ -2,9 +2,9 @@
++ /**
++  * [English [En]]
++  * @package cBB Chat
++- * @version 1.2.7 07/03/2025
+++ * @version 1.2.6 01/07/2024
++  *
++- * @copyright (c) 2025 CaniDev
+++ * @copyright (c) 2024 CaniDev
++  * @license https://creativecommons.org/licenses/by-nc/4.0/
++  */
++ 
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/language/es/acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/language/es/acp.php"
++index 8a116fe62..4e64b2644 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/language/es/acp.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/language/es/acp.php"
++@@ -2,9 +2,9 @@
++ /**
++  * [Spanish [Es]]
++  * @package cBB Chat
++- * @version 1.2.7 07/03/2025
+++ * @version 1.2.6 01/07/2024
++  *
++- * @copyright (c) 2025 CaniDev
+++ * @copyright (c) 2024 CaniDev
++  * @license https://creativecommons.org/licenses/by-nc/4.0/
++  */
++ 
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/language/es/info_acp_chat.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/language/es/info_acp_chat.php"
++index d7ac7a2ef..5fb9a0237 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/language/es/info_acp_chat.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/language/es/info_acp_chat.php"
++@@ -2,9 +2,9 @@
++ /**
++  * [Spanish [Es]]
++  * @package cBB Chat
++- * @version 1.2.7 07/03/2025
+++ * @version 1.2.6 01/07/2024
++  *
++- * @copyright (c) 2025 CaniDev
+++ * @copyright (c) 2024 CaniDev
++  * @license https://creativecommons.org/licenses/by-nc/4.0/
++  */
++ 
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/language/es/info_mcp_chat.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/language/es/info_mcp_chat.php"
++index 65933ff92..ec0b36117 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/language/es/info_mcp_chat.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/language/es/info_mcp_chat.php"
++@@ -2,9 +2,9 @@
++ /**
++  * [Spanish [Es]]
++  * @package cBB Chat
++- * @version 1.2.7 07/03/2025
+++ * @version 1.2.6 01/07/2024
++  *
++- * @copyright (c) 2025 CaniDev
+++ * @copyright (c) 2024 CaniDev
++  * @license https://creativecommons.org/licenses/by-nc/4.0/
++  */
++ 
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/language/es/main.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/language/es/main.php"
++index 91028d26c..a1de87c5f 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/language/es/main.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/language/es/main.php"
++@@ -2,9 +2,9 @@
++ /**
++  * [Spanish [Es]]
++  * @package cBB Chat
++- * @version 1.2.7 07/03/2025
+++ * @version 1.2.6 01/07/2024
++  *
++- * @copyright (c) 2025 CaniDev
+++ * @copyright (c) 2024 CaniDev
++  * @license https://creativecommons.org/licenses/by-nc/4.0/
++  */
++ 
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/language/es/permissions_chat.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/language/es/permissions_chat.php"
++index 078503bcd..08f7e420b 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/language/es/permissions_chat.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/language/es/permissions_chat.php"
++@@ -2,9 +2,9 @@
++ /**
++  * [Spanish [Es]]
++  * @package cBB Chat
++- * @version 1.2.7 07/03/2025
+++ * @version 1.2.6 01/07/2024
++  *
++- * @copyright (c) 2025 CaniDev
+++ * @copyright (c) 2024 CaniDev
++  * @license https://creativecommons.org/licenses/by-nc/4.0/
++  */
++ 
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/libraries/action_manager.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/libraries/action_manager.php"
++index 8b299885f..b08d63b59 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/libraries/action_manager.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/libraries/action_manager.php"
++@@ -1,9 +1,9 @@
++ <?php
++ /**
++  * @package cBB Chat
++- * @version 1.2.7 07/03/2025
+++ * @version 1.2.6 01/07/2024
++  *
++- * @copyright (c) 2025 CaniDev
+++ * @copyright (c) 2024 CaniDev
++  * @license https://creativecommons.org/licenses/by-nc/4.0/
++  */
++ 
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/libraries/chat.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/libraries/chat.php"
++index d6295e372..d4835cc5a 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/libraries/chat.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/libraries/chat.php"
++@@ -1,9 +1,9 @@
++ <?php
++ /**
++  * @package cBB Chat
++- * @version 1.2.7 07/03/2025
+++ * @version 1.2.6 01/07/2024
++  *
++- * @copyright (c) 2025 CaniDev
+++ * @copyright (c) 2024 CaniDev
++  * @license https://creativecommons.org/licenses/by-nc/4.0/
++  */
++ 
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/libraries/constants.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/libraries/constants.php"
++index 2a61d4905..85cc8a1bb 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/libraries/constants.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/libraries/constants.php"
++@@ -1,9 +1,9 @@
++ <?php
++ /**
++  * @package cBB Chat
++- * @version 1.2.7 07/03/2025
+++ * @version 1.2.6 01/07/2024
++  *
++- * @copyright (c) 2025 CaniDev
+++ * @copyright (c) 2024 CaniDev
++  * @license https://creativecommons.org/licenses/by-nc/4.0/
++  */
++ 
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/mcp/main_info.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/mcp/main_info.php"
++index 17685b7e6..324fda17f 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/mcp/main_info.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/mcp/main_info.php"
++@@ -1,9 +1,9 @@
++ <?php
++ /**
++  * @package cBB Chat
++- * @version 1.2.7 07/03/2025
+++ * @version 1.2.6 01/07/2024
++  *
++- * @copyright (c) 2025 CaniDev
+++ * @copyright (c) 2024 CaniDev
++  * @license https://creativecommons.org/licenses/by-nc/4.0/
++  */
++ 
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/mcp/main_module.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/mcp/main_module.php"
++index 058406ae5..c967cef09 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/mcp/main_module.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/mcp/main_module.php"
++@@ -1,9 +1,9 @@
++ <?php
++ /**
++  * @package cBB Chat
++- * @version 1.2.7 07/03/2025
+++ * @version 1.2.6 01/07/2024
++  *
++- * @copyright (c) 2025 CaniDev
+++ * @copyright (c) 2024 CaniDev
++  * @license https://creativecommons.org/licenses/by-nc/4.0/
++  */
++ 
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/migrations/v110.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/migrations/v110.php"
++index d3e28d64b..3af724375 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/migrations/v110.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/migrations/v110.php"
++@@ -14,7 +14,7 @@ class v110 extends \phpbb\db\migration\migration
++ {
++ 	public function effectively_installed()
++ 	{
++-		return $this->db_tools->sql_table_exists($this->table_prefix . 'chat_messages');
+++		return isset($this->config['chat_version']) && version_compare($this->config['chat_version'], '1.1.0', '>=');
++ 	}
++ 
++ 	public function update_schema()
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/migrations/v111.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/migrations/v111.php"
++index ff8ce2c64..a1b9cf86e 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/migrations/v111.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/migrations/v111.php"
++@@ -17,8 +17,7 @@ class v111 extends \phpbb\db\migration\migration
++ 	 */
++ 	public function effectively_installed()
++ 	{
++-		// "chat_version" is deprecated, migration ignored
++-		return true;
+++		return isset($this->config['chat_version']) && version_compare($this->config['chat_version'], '1.1.1', '>=');
++ 	}
++ 
++ 	/**
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/migrations/v112.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/migrations/v112.php"
++index 3e7b634b1..7ce5e3b46 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/migrations/v112.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/migrations/v112.php"
++@@ -17,7 +17,7 @@ class v112 extends \phpbb\db\migration\migration
++ 	 */
++ 	public function effectively_installed()
++ 	{
++-		return $this->db_tools->sql_column_exists($this->table_prefix . 'chat_rooms', 'room_autopurge_time');
+++		return isset($this->config['chat_version']) && version_compare($this->config['chat_version'], '1.1.2', '>=');
++ 	}
++ 
++ 	/**
++@@ -72,7 +72,7 @@ class v112 extends \phpbb\db\migration\migration
++ 		
++ 		if(!empty($this->config['chat_show_topics']))
++ 		{
++-			$this->config->set('chat_forum_posts', 1);
+++			set_config('chat_forum_posts', 1);
++ 		}
++ 	}
++ }
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/migrations/v113.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/migrations/v113.php"
++index a4a795399..622c80679 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/migrations/v113.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/migrations/v113.php"
++@@ -14,7 +14,7 @@ class v113 extends \phpbb\db\migration\migration
++ {
++ 	public function effectively_installed()
++ 	{
++-		return $this->config->offsetExists('chat_purge_mark');
+++		return isset($this->config['chat_version']) && version_compare($this->config['chat_version'], '1.1.3', '>=');
++ 	}
++ 
++ 	static public function depends_on()
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/migrations/v120.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/migrations/v120.php"
++index c786bcaae..a397a9228 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/migrations/v120.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/migrations/v120.php"
++@@ -13,7 +13,7 @@ class v120 extends \phpbb\db\migration\migration
++ {
++ 	public function effectively_installed()
++ 	{
++-		return $this->db_tools->sql_column_exists($this->table_prefix . 'chat_users', 'user_groups');
+++		return isset($this->config['chat_version']) && version_compare($this->config['chat_version'], '1.2.0', '>=');
++ 	}
++ 
++ 	static public function depends_on()
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/migrations/v121.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/migrations/v121.php"
++index f9c707cc2..b7c4a9f69 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/migrations/v121.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/migrations/v121.php"
++@@ -13,7 +13,7 @@ class v121 extends \phpbb\db\migration\migration
++ {
++ 	public function effectively_installed()
++ 	{
++-		return $this->config->offsetExists('chat_hide_popup');
+++		return isset($this->config['chat_version']) && version_compare($this->config['chat_version'], '1.2.1', '>=');
++ 	}
++ 
++ 	static public function depends_on()
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/migrations/v122.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/migrations/v122.php"
++index 1af49052c..d9fb1e6ee 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/migrations/v122.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/migrations/v122.php"
++@@ -13,7 +13,7 @@ class v122 extends \phpbb\db\migration\migration
++ {
++ 	public function effectively_installed()
++ 	{
++-		return $this->config->offsetExists('chat_row_align');
+++		return isset($this->config['chat_version']) && version_compare($this->config['chat_version'], '1.2.2', '>=');
++ 	}
++ 
++ 	static public function depends_on()
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/migrations/v123.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/migrations/v123.php"
++index 14e58c591..72c483872 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/migrations/v123.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/migrations/v123.php"
++@@ -16,8 +16,7 @@ class v123 extends \phpbb\db\migration\migration
++ 	 */
++ 	public function effectively_installed()
++ 	{
++-		// "chat_version" is deprecated, migration ignored
++-		return true;
+++		return isset($this->config['chat_version']) && version_compare($this->config['chat_version'], '1.2.3', '>=');
++ 	}
++ 
++ 	/**
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/migrations/v124.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/migrations/v124.php"
++index 526ae8d85..04e7819f1 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/migrations/v124.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/migrations/v124.php"
++@@ -16,8 +16,7 @@ class v124 extends \phpbb\db\migration\migration
++ 	 */
++ 	public function effectively_installed()
++ 	{
++-		// "chat_version" is deprecated, migration ignored
++-		return true;
+++		return isset($this->config['chat_version']) && version_compare($this->config['chat_version'], '1.2.4', '>=');
++ 	}
++ 
++ 	/**
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/migrations/v125.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/migrations/v125.php"
++index fb2ab31e6..b66d2c46b 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/migrations/v125.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/migrations/v125.php"
++@@ -16,8 +16,7 @@ class v125 extends \phpbb\db\migration\migration
++ 	 */
++ 	public function effectively_installed()
++ 	{
++-		// "chat_version" is deprecated, migration ignored
++-		return true;
+++		return isset($this->config['chat_version']) && version_compare($this->config['chat_version'], '1.2.5', '>=');
++ 	}
++ 
++ 	/**
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/migrations/v126.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/migrations/v126.php"
++index 143d90d4d..2557ac4c6 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/migrations/v126.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/migrations/v126.php"
++@@ -16,8 +16,7 @@ class v126 extends \phpbb\db\migration\migration
++ 	 */
++ 	public function effectively_installed()
++ 	{
++-		// "chat_version" is deprecated, migration ignored
++-		return true;
+++		return isset($this->config['chat_version']) && version_compare($this->config['chat_version'], '1.2.6', '>=');
++ 	}
++ 
++ 	/**
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/migrations/v127.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/migrations/v127.php"
++deleted file mode 100644
++index 5b1433311..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/migrations/v127.php"
+++++ /dev/null
++@@ -1,41 +0,0 @@
++-<?php
++-/**
++- * @package cBB Chat
++- * @version 1.2.7 07/03/2025
++- *
++- * @copyright (c) 2025 CaniDev
++- * @license https://creativecommons.org/licenses/by-nc/4.0/
++- */
++-
++-namespace canidev\chat\migrations;
++-
++-class v127 extends \phpbb\db\migration\migration
++-{
++-	/**
++-	 * {@inheritDoc}
++-	 */
++-	public function effectively_installed()
++-	{
++-		return $this->config->offsetExists('chat_cron_lock') && !$this->config->offsetExists('chat_version');
++-	}
++-
++-	/**
++-	 * {@inheritDoc}
++-	 */
++-	static public function depends_on()
++-	{
++-		return [
++-			'\canidev\chat\migrations\v126',
++-		];
++-	}
++-
++-	/**
++-	 * {@inheritDoc}
++-	 */
++-	public function update_data()
++-	{
++-		return [
++-			['config.remove',	['chat_version']],
++-		];
++-	}
++-}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/styles/all/template/js/jchat-options.js" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/styles/all/template/js/jchat-options.js"
++index cac86630a..e0d76b310 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/styles/all/template/js/jchat-options.js"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/styles/all/template/js/jchat-options.js"
++@@ -1,9 +1,9 @@
++ /**
++  * @package cBB Chat
++  * @style: All
++- * @version 1.2.7 07/03/2025
+++ * @version 1.2.5 15/01/2023
++  *
++- * @copyright (c) 2025 CaniDev
+++ * @copyright (c) 2023 CaniDev
++  * @license https://creativecommons.org/licenses/by-nc/4.0/
++  */
++ 
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/styles/all/template/js/jchat.min.js" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/styles/all/template/js/jchat.min.js"
++index f7f25e944..7187d636d 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\chat/styles/all/template/js/jchat.min.js"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\chat/styles/all/template/js/jchat.min.js"
++@@ -1,10 +1,10 @@
++ /**
++  * @package cBB Chat
++- * @version 1.2.7 10/03/2025
+++ * @version 1.2.6 01/07/2024
++  *
++- * @copyright (c) 2025 CaniDev
+++ * @copyright (c) 2024 CaniDev
++  * @license https://creativecommons.org/licenses/by-nc/4.0/
++  */
++-((p,m)=>{var e=null,o=null,f=null,i=!1,n=!1,s=!1,v=0,b=0,g=0,a=0,c=0,r=null,w=[];m.registerService("chat",{activeBox:null,connected:!1,currentRoom:!1,dom:null,method:"append",openRooms:[],tempDom:p("<div />"),editor:null,scrolling:!1,audio:new Audio,options:{autoconnect:!1,defaultRoom:0,direction:"down",floodTime:0,guestRoom:1,height:220,hidePopup:!1,imgSelector:".postimage",maxChars:0,maxRows:25,mode:"chat",noticeTimeout:2e4,page:"",soundPath:null,position:"bottom",refresh:5e3,tipTimeout:15e3},positions:{},tpl:{conversation:'<div class="ic-conversation js-conversation-<%ROOM_ID%>"></div>',sep:'<div class="sep"></div>',tab:'<li id="chat-tab-<%ROOM_ID%>"><%TITLE%> <a href="#" class="tab-close"><i class="fa fa-times-circle" aria-hidden="true"></i></a></li>',userlist:'<ul class="ic-userlist js-userlist-<%ROOM_ID%>"></ul>'},__construct:function(){var e=this;if(this.options.defaultRoom=this.options.defaultRoom||this.options.guestRoom,m.dispatchEvent("chat.beforeInit",this),"archive"===this.options.mode)this.bindRows(),p('[data-action="mark"], [data-action="unmark"]').click(function(t){t.preventDefault();var t="mark"==p(this).data("action"),e=t?"show":"hide",t=(p('input[name^="row_id_list"]').prop("checked",t),p(".chat-row .ic-row-actions").has(".row-id-list"));t[e].call(t)});else{if("up"==this.options.direction&&(this.method="prepend"),this.dom=p("#chat-body"),!(this.dom.length&&this.options.guestRoom&&this.options.height&&this.options.maxRows))return!1;void 0!==window.jchat_style_options&&(this.positions=window.jchat_style_options.positions);var t=!1;if("custom"==this.options.page&&this.positions.chat)t=this.positions.chat;else if("custom"!=this.options.page&&this.options.position){var o={};if(this.positions[this.options.page])o=this.positions[this.options.page];else{if(!this.positions.undefined)return!1;o=this.positions.undefined}t=o[this.options.position]}!1!==t&&(0==p(t[0]).length&&this.positions.undefined&&this.options.position&&(t=this.positions.undefined[this.options.position]),o=p(t[0]),t=t[1],1==(o=1<o.length?p(o[0]):o).length)&&o[t].apply(o,[this.dom]),m.colourIsDark(this.dom.find("#chat-content").css("background-color"),170)&&this.dom.addClass("dark-theme"),this.dom.objView(!0),m.browser.isMobile&&(p("head meta[name=viewport]").remove(),p("head").prepend('<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />')),p("#chat-conversation-container").on("scroll",function(){"up"==e.options.direction&&0<this.scrollTop||"down"==e.options.direction&&this.scrollTop<this.scrollHeight-this.offsetHeight?(e.scrolling=!0,p(".chat-scroll-button").objView(!0)):(e.scrolling=!1,p(".chat-scroll-button").objView(!1))}),p(".chat-scroll-button").addClass(e.options.direction).click(function(t){t.preventDefault(),e.scrollRoom()});t={autoClose:!1,minSize:180,yPosition:"top",wrapper:this.dom,onOpen:function(){e.closeActiveBox(),e.activeBox=this},onClose:function(){e.activeBox=null}},o=(this.dom.find('a[data-action="showbox"]').cbbDropdown(p.extend({},t,{adjustMethod:"resize"})),this.dom.find('a[data-action="color"]').cbbColorPicker(p.extend({},t,{realTimeUpdate:!1,onChange:function(t){e.editor.insertBBcode("color",t),e.options.hidePopup&&e.closeActiveBox()}})),this.dom.find("a[data-action]").filter(function(){return!p(this).data("cbbDropdown")}).click(p.proxy(this,"eventDispatch")),this.bindLinks(this.dom),this.collapsable("init"),1==this.cookie("mute")&&this.player("mute",!0),p("#chat-conversation-container").css("height",this.options.height),p("#chat-right-panel").css("height",this.options.height+p("#chat-tabs").height()),p("#chat-toolbar a").addClass("chat-corner-top chat-corner-bottom"),p(".ic-box").addClass("chat-corner-top"),this.initMessages(),this.status("stop"),m.dispatchEvent("chat.onInit",this),this.cookie("connectStatus"));this.options.autoconnect=1===o||0!==o&&this.options.autoconnect,this.options.autoconnect&&!this.dom.is(".collapsed")?this.connect(!0):this.disconnect()}},connect:function(t){var e=this,o=this.connected?"disconnect":"connect",i=!1;s=1==t,"connect"==o&&this.cookie("auto_away")&&(i={auto_away:this.cookie("auto_away")}),this.send(o,i,function(){s=!1,t||e.cookie("connectStatus","connect"==o?1:0,-1),"connect"==o&&(e.dom.find("#purge-button").removeClass("disabled"),e.traceCheck("start"),m.dispatchEvent("chat.onConnect",!1))})},disconnect:function(t){var e=p("#chat-main-message").clone();this.status("stop"),this.traceCheck("stop"),this.dom.find('[data-action="connect"]').removeClass("connected"),this.dom.find("#purge-button").addClass("disabled"),t&&e.html(t),p("#chat-conversation-container").append(e),e.show(),this.dom.removeAttr("data-active"),m.dispatchEvent("chat.onDisconnect",!1)},closeActiveBox:function(){null!==this.activeBox&&this.activeBox.close()},collapsable:function(t){var e=this.dom.find("#chat-content"),o=e.is(":visible"),i=this.dom.find('[data-action="minimize"]');if("custom"==this.options.page)return i.remove(),!1;switch(t){case"change":n(!o),o?(this.closeActiveBox(),e.slideUp(),o=!1,this.disconnect(),this.cookie("collapsed",1)):(e.slideDown(),this.connect(o=!0),this.cookie("collapsed","",-1));case"init":"init"==t&&(m.intval(this.cookie("collapsed"))||0)&&(n(!1),e.hide(),o=!1),this.dom.toggleClass("collapsed",!o),i.children(".fa").toggleClass("fa-minus",o).toggleClass("fa-plus",!o)}function n(t){var e=i.parent("dt");t?e.removeStyle("margin-bottom"):e.css("margin-bottom",e.css("margin-top"))}},initMessages:function(){var t=p("#chat-notices"),e=p("#chat-tips"),o=t.find(".js-message"),i=e.find(".js-message");function n(t,e,o){var i=t.data("current_text");void 0===i&&(i=-1),e[++i]||(i=0),e.objView(!1),p(e[i]).objView(!0),t.data("current_text",i),1<e.length&&o&&setTimeout(function(){n(t,e,o)},o)}0<o.length&&(t.objView(!0),n(t,o,this.options.noticeTimeout)),0<i.length&&(e.objView(!0),n(e,i,this.options.tipTimeout))},refresh:function(){var t=this.connected?"refresh":"connect";this.status("pause"),this.send(t)},submit:function(){var t=new p.Event("chat.beforeSubmit",{service:this});if(m.dispatchEvent(t),!t.isDefaultPrevented()){var t=this.editor.element.val().replace(/\[\/?[^\]]+\]/g,""),e=new Date;if(!p.trim(t)||null!=f||a&&e.getTime()-a<600)return!1;if(this.options.maxChars)if(m.intval(this.editor.element.next(".chat-editor-counter").children("span").text())<0)return!1;return a=e.getTime(),this.status("pause"),this.send("post",{lastPostTime:v,auto_away:g})}},send:function(r,t,h){var l=this,d={ajaxModule:"chat",action:r};if(this.status("loading"))return"refresh"!=r&&w.push([r,t,h]),!1;-1!=p.inArray(r,["post","connect","disconnect","refresh","pmuser","set_available","set_away","set_busy","set_hidden","set_name"])&&(d=p.extend(d,this.dom.find("form").serializeObject())),this.currentRoom&&(d.room=this.currentRoom),t&&(d=p.extend(d,t)),"refresh"==r&&(3<c&&(d.trace=!0,c=0),c++),d.rooms=this.openRooms;var u=new p.Event("chat.beforeSend",{action:r,service:this,sendData:d});m.dispatchEvent(u),u.isDefaultPrevented()||("trace"!=r&&this.status("load-start"),m.request({showLoading:!1,data:u.sendData,onComplete:function(){l.status("load-end")},onSuccess:function(t){var e=!1,o=new Date;if(l.tempDom.html(t.htmlContent),!t.success)return l.dialog("close"),t.message&&alert(t.message),!1;if(t.dialog)return l.dialog({content:t.htmlContent}),!1;switch(t.action){case"disable":return l.disconnect(),window.location.reload(),!0;case"disconnect":l.disconnect();break;case"exclude":return l.disconnect(t.message),!0;case"login":l.connected=!1,l.dialog({content:t.htmlContent,onOpen:function(e){e.ui.find("input:first").focus(),e.ui.find("input[type=text], input[type=password]").keydown(function(t){if(13==t.which&&p(this).val())return e.ui.find('[value="submit"]').click(),t.preventDefault(),t.stopPropagation(),!1})},onSubmit:function(t){if(!t.username&&!t.username_register)return p(this).find("input[name=username]").addClass("cbb-state-error").focus(),!1;t.submit=1,l.send("connect",t,function(t){t.userLogged&&(l.cookie("connectStatus",1,-1),window.location.reload())})}});break;case"update":l.dom.find("input[name=last_update]").val(t.last_time),l.dom.find("input[name=time_mark]").val(t.timeMark),l.options.floodTime=t.floodTime,t.msg_direction&&t.msg_direction!=l.options.direction&&(l.options.direction=t.msg_direction,l.method="up"==t.msg_direction?"prepend":"append",l.inverseConversations(),e=!0);var i=null!=t.auto_away?t.auto_away:g;i!=g&&(g=i)&&l.cookie("auto_away",g);break;case"banuser":l.closeRoom(t.user_key);case"unbanuser":l.dom.find(".js-user-"+t.user_key).html(l.tempDom.find(".js-userlist li:first").html()),l.bindUserlist(!1,t.user_key);break;case"close_room":l.closeRoom(t.room_key)}switch(r){case"disconnect":l.disconnect();break;case"post":l.editor.element.val(""),l.editor.plugins.chat.updateCharCounter(),l.options.floodTime&&!t.ignoreFloodTime&&(l.editor.element.val(m.lang("CHAT_FLOOD_WAIT")).prop("disabled",!0).addClass("disabled").blur(),f=setTimeout(function(){l.editor.element.val("").prop("disabled",!1).removeClass("disabled").focus(),f=null},l.options.floodTime)),v=o.getTime()/1e3;case"set_available":case"set_away":case"set_busy":case"set_hidden":case"set_name":case"connect":l.connected||p("#chat-conversation-container").html(""),"connect"!=r&&"post"!=r||(l.connected=!0),"connect"==r&&l.dom.find('[data-action="connect"]').addClass("connected"),g=0,l.cookie("auto_away",0,-1);case"move":if("move"==r){if(!u.sendData.submit)break;p("#chat-conversation-container > div").html("")}case"pmuser":case"refresh":l.connected&&(a=l.appendConversationData(r),l.tempDom.html(""),l.currentRoom=l.currentRoom||l.options.defaultRoom,p("#chat-tab-"+l.currentRoom).length||(l.currentRoom=l.options.guestRoom),p("#chat-tab-"+l.currentRoom).hasClass("active")||l.openRoom(l.currentRoom),(a||e)&&(l.bindRows(),a&&"refresh"==r&&l.player("play","add"),l.scrolling||l.scrollRoom(),p("#chat-conversation-container .ic-row-text img").one("load",function(){this.loaded=!0,l.scrolling||l.scrollRoom()}).each(function(){this.complete&&!this.loaded&&p(this).trigger("load")})),l.doQueue(t.queueActions),l.status("resume"),b=o.getTime(),l.cookie("lastcheck",parseInt(b/1e3),365));break;case"quote":l.editor.insertText(t.text);break;case"history":var n=l.dom.find(".js-conversation-"+l.currentRoom),s=n.outerHeight(),a=l.appendConversationData(r);l.tempDom.html(""),a&&(n.data("ignoreLimit",!0),"up"!=l.options.direction&&(a=n.outerHeight(),l.scrollRoom(a-s)),l.bindRows())}var c=new p.Event("chat.afterSend",{action:r,service:this,sendData:d,response:t});m.dispatchEvent(c),"function"!=typeof h||c.isDefaultPrevented()||h.call(!1,t),w.length&&l.send.apply(l,w.shift())}}))},traceCheck:function(t){let e=this;switch(t){case"start":null!==o&&e.traceCheck("stop"),o=setInterval(function(){var t=new Date;b&&t.getTime()>b+1.5*e.options.refresh&&(e.send("trace"),b=t.getTime())},e.options.refresh);break;case"stop":clearInterval(o),o=null}},closeRoom:function(t){if(null==t||t==this.options.guestRoom)return!1;var e;-1!=(e=p.inArray(t,this.openRooms))&&(p("#chat-tab-"+t+", .js-conversation-"+t+", .js-userlist-"+t).remove(),m.dispatchEvent("chat.onCloseRoom",{instance:this,room:t}),this.openRooms.splice(e,1),e=this.currentRoom==t?this.options.guestRoom:this.currentRoom,this.openRoom(e,!0))},openRoom:function(t,e){var o=this.currentRoom,i=p("#chat-tab-"+t);if(-1!=p.inArray(o,self.openRooms)&&!0!==e)return!1;o&&(p(".js-conversation-"+o+", .js-userlist-"+o).hide(),p("#chat-tabs li").removeClass("active before-active after-active"),p("#chat-tabs .tab-close").removeClass("active")),this.currentRoom=t,p(".js-conversation-"+t+", .js-userlist-"+t).show(),i.addClass("active").removeClass("new-msg"),i.prev("li").addClass("before-active"),i.next("li").addClass("after-active"),i.find(".tab-close").addClass("active"),this.dom.attr("data-active",t);var e=p(".js-conversation-"+t).is(".js-public-room")?"removeClass":"addClass",o=this.dom.find("#purge-button"),i=(o[e].call(o,"disabled"),new p.Event("chat.onOpenRoom",{instance:this,room:t,backgroundAction:s}));m.dispatchEvent(i),i.isDefaultPrevented()||(this.scrolling=!1,this.scrollRoom(),s)||m.browser.isMobile||!this.editor||(e=this.editor.element.offset().top-p(window).scrollTop())<p(window).height()&&0<=e&&this.editor.element.focus()},bindLinks:function(t){window.self!=window.top&&t.find("a[href]:not([data-action],[data-code],.ic-row-action-launcher)").off("click.frame").on("click.frame",function(t){t.preventDefault(),window.top.location.href=this.href})},bindTabs:function(){var o=this;p("#chat-tabs").find("li, .tab-close").off(),p("#chat-tabs li").click(function(t){var e=parseInt(p(this).attr("id").replace("chat-tab-",""));o.openRoom(e),t.preventDefault()}),p("#chat-tabs li .tab-close").click(function(t){var e=p(this).parent(),e=parseInt(e.attr("id").replace("chat-tab-",""));o.closeRoom(e),t.preventDefault()}),m.dispatchEvent("chat.onBindTabs",this)},bindRows:function(){var o=this,t=p("#chat-conversation-container .chat-row");t.off().find(".ic-row-action-launcher").cbbDropdown({onCreate:function(){var e=this;e.rowID=e.launcher.closest(".chat-row").data("id"),e.container.find("[data-action]").off("click").click(function(t){t.preventDefault(),t.msgID=e.rowID,o.eventDispatch(t),e.close()})},onOpen:function(){this.launcher.closest(".chat-row").addClass("active"),o.status("pause",!0)},onClose:function(){this.launcher.closest(".chat-row").removeClass("active").children(".chat-row-content").mouseleave(),o.status("resume")}}),m.browser.isMobile?t.find(".ic-row-actions").show():t.filter(":not(.chat-format-bubble)").children(".chat-row-content").hover(function(){p(this).children(".ic-row-actions").show()},function(){p(this).closest(".chat-row").is(".active")||p(this).children(".ic-row-actions").each(function(){if(0<p(this).children(".row-id-list:checked").length)return!0;p(this).hide()})}),p("#chat-conversation-container").find(".history-row a, .chat-quickmention").off("click").click(p.proxy(this,"eventDispatch")),t.cbbImageGallery({imageSelector:"img:not(.emoji, .smilies)"}),o.bindLinks(t),m.dispatchEvent("chat.onBindRows",this)},bindUserlist:function(t,e){var t=e?".js-user-"+e:t?".js-userlist-"+t:".ic-userlist",e=e?p(t):p(t).children("li"),o=this;e.find("a").off("click").click(p.proxy(o,"eventDispatch")),e.children("a").cbbDropdown({dispatchEvent:"contextmenu",showPointer:!1,onCreate:function(){this.container.find("a").click(p.proxy(this,"close"))},onOpen:function(){o.currentMenu=this,o.status("pause",!0)},onClose:function(){o.currentMenu=null,o.status("resume")}}),m.dispatchEvent("chat.onBindUserlist",this)},eventDispatch:function(t){t.preventDefault();var e=p(t.currentTarget),o=e.data("action"),i=t.msgID,n=this;if(e.is(".disabled"))return!1;!i&&e.closest(".chat-row").length&&(i=e.closest(".chat-row").data("id"));t=new p.Event("chat.beforeEventDispatch",{originalEvent:t,action:o,service:this,msgID:i});if(m.dispatchEvent(t),!t.isDefaultPrevented()){switch(o){case"connect":case"refresh":this.closeActiveBox();case"submit":this[o].call(this);break;case"clear":n.send("clear",!1,function(){p(".js-conversation-"+n.currentRoom).html("")});break;case"rules":n.send("rules",!1,function(t){n.dialog({content:t.htmlContent,height:120,width:350})});break;case"sound":this.closeActiveBox(),this.player("mute");break;case"edit":n.send("edit",{id:i},function(t){n.dialog({autoFocus:!0,content:t.htmlContent,width:610,onSubmit:function(t){if((t=p.extend(t,{id:i,submit:1}),n.options.maxChars)&&m.intval(p(this).find(".chat-editor-counter > span").text())<0)return!1;n.send("edit",t,function(t){t.text&&p("#chat-row-"+i).find(".ic-row-text").html(t.text)})}})});break;case"delete":this.send("delete",{id:i},function(){n.player("play","delete"),p("#chat-row-"+i).fadeOut()});break;case"quote":this.send(o,{id:i});break;case"whois":n.send("whois",{id:i},function(t){n.dialog({content:t.htmlContent,width:450,height:150})});break;case"user":window.open(e.attr("href"));break;case"banuser":var s=e.data("user-key");this.send("banuser",{uk:s},function(t){n.dialog({content:t.htmlContent,onOpen:function(e){p("#ban-period").change(function(){var t="0"==p(this).val();e.ui.find("dl:has(#ban-date)").objView(t),t||e.ui.find("#ban-date").val("").removeClass("cbb-state-error")})},onSubmit:function(t){if("0"==t.period&&null==t.date.match(/\d{2}\/\d{2}\/\d{4} \d{2}\:\d{2}\:\d{2}/))return p(this).find("#ban-date").addClass("cbb-state-error").focus(),!1;t=p.extend(t,{uk:s,submit:1}),n.send("banuser",t)}})});break;case"quickmention":var a=(c=e.next(".ic-row-username:first")).children("a");case"mentionuser":(a="mentionuser"==o?(c=this.currentMenu.launcher).children("span"):a).length?n.editor.insertBBcode("color",{defaultAttr:m.rgbToHex(a.css("color")),inner:"[b]@"+a.text()+"[/b]"},FLAG_ADDWHITESPACES|FLAG_CURSORTOEND):n.editor.insertBBcode("b",{inner:"@"+c.text()},FLAG_ADDWHITESPACES|FLAG_CURSORTOEND);break;case"pmuser":s=e.data("user-key");-1==p.inArray(s,this.openRooms)?this.send("pmuser",{uk:s},function(){n.openRoom(s)}):this.openRoom(s);break;case"unbanuser":case"set_available":case"set_away":case"set_busy":case"set_hidden":this.send(o,{uk:e.data("user-key")});break;case"set_name":s=e.data("user-key");this.send("set_name",{uk:s},function(t){n.dialog({autoFocus:!0,content:t.htmlContent,onSubmit:function(t){if(!(t=p.extend(t,{uk:s,submit:1})).username)return p(this).find("input[name=username]").addClass("cbb-state-error").focus(),!1;n.send("set_name",t)}})});break;case"move":this.send("move",{id:i},function(t){n.dialog({content:t.htmlContent,onSubmit:function(t){t=p.extend(t,{id:i,submit:1,last_update:0}),n.send("move",t,function(){})}})});break;case"minimize":this.collapsable("change");break;case"history":var a="up"==this.options.direction?"prev":"next",c=e.parent()[a].call(e.parent(),".chat-row");this.send("history",{last_update:c.data("time")});break;default:window.open(e.attr("href"))}p(this).blur()}},player:function(t,e){if(null===this.options.soundPath)return!1;switch(t){case"mute":n&&!0!==e?!n&&!1!==e||(n=!1,p('a[data-action="sound"]').removeClass("muted"),this.cookie("mute","")):(n=!0,p('a[data-action="sound"]').addClass("muted"),this.cookie("mute",1,180));break;case"play":n||(this.audio.src=this.options.soundPath+e+".mp3",this.audio.play())}},dialog:function(e){var t,o=this;"string"==typeof e?null!==r&&(r.cbbDialog(e),"close"==e)&&(r=null):(t={autoClean:!1,autoFocus:e.autoFocus||!1,destroyOnClose:!0,movable:!1,width:e.width||"auto",height:e.height||"auto",parent:"archive"==this.options.mode?"body":p("#chat-content").is("ul")?"#chat-content > li":"#chat-content",onOpen:function(t){o.status("pause",!0),o.closeActiveBox(),o.bindLinks(p(this)),e.onOpen&&e.onOpen.call(this,t)},onClose:function(){o.status("resume")},onSubmit:e.onSubmit},r=p(e.content).cbbDialog(t))},scrollRoom:function(t){var e=p("#chat-conversation-container")[0];t?e.scrollTop=t:(e.scrollTop="up"==this.options.direction?0:e.scrollHeight,p(".chat-scroll-button").objView(!1))},status:function(t){switch(t){case"load-start":i=!0,p(".ic-loading").show();break;case"load-end":i=!1,p(".ic-loading").hide();break;case"loading":return i;case"stop":p("#chat-conversation-container, #chat-right-panel, #chat-tabs").html(""),this.openRooms=[],this.connected=!1,this.dom.find("input[name=last_update]").val(0),this.dom.find("input[name=time_mark]").val(0);case"pause":clearTimeout(e),e=null,this.status("load-end");break;case"resume":this.connected&&null===e&&(e=setTimeout(p.proxy(this,"refresh"),this.options.refresh))}},cookie:function(t,e,o){t="chat_"+t;if(null==e)return m.cookie.get(t);m.cookie.set(t,e,o)},inverseConversations:function(){p("#chat-conversation-container").children(".ic-conversation").each(function(){var t=p(this).children(".chat-row, .history-row");if(t.length){p(this).html("");for(var e=t.length-1;-1<e;e--)p(this).append(t[e])}})},appendConversationData:function(c){var r=this,h=!1,t=new Date,l=this.cookie("lastcheck")||t.getTime()/1e3;return this.tempDom.find(".room").each(function(){var t=parseInt(p(this).attr("id").replace("room-","")),e=p.trim(p(this).children(".js-conversation").html()),o=p.trim(p(this).children(".js-userlist").html());if(-1==p.inArray(t,r.openRooms)){if("history"==c)return!0;r.openRooms.push(t);var i={ROOM_ID:t,TITLE:p(this).attr("title")};p("#chat-right-panel").append(r.getTpl("userlist",i)),p("#chat-conversation-container").append(r.getTpl("conversation",i)),p("#chat-tabs").append(r.getTpl("tab",i)),p(this).is(".js-public-room")&&(p(".js-conversation-"+t).addClass("js-public-room"),p("#chat-tab-"+t).find(".tab-close").remove()),r.bindTabs()}var n=p(".js-conversation-"+t);if("history"==c)n.children(".history-row").replaceWith(e),h=!!e;else if(e){n[r.method].apply(n,[e]);var s=n.children(".chat-row").length,a="up"==r.options.direction?":last":":first";if(!n.data("ignoreLimit"))for(;s>r.options.maxRows;)n.children(".chat-row"+a).remove(),s--;i="up"==r.options.direction?":first":":last",e=parseInt(n.children(".chat-row"+i).data("time"));t!=r.currentRoom&&("refresh"==c||e&&l<e)&&p("#chat-tab-"+t).addClass("new-msg"),h=!0}o&&(p(".js-userlist-"+t).html(o),r.bindUserlist(t))}),h},doQueue:function(t){if(!t||!t.length)return!1;let e=!1;for(var o of t)switch(o.action){case"delete":p("#chat-row-"+o.msgID).fadeOut();break;case"edit":p("#chat-row-"+o.msgID).find(".ic-row-text").html(o.msgText);break;case"connect":e||(e=!0,this.player("play","connect"));break;case"move":var i=this.dom.find("#chat-row-"+o.msgID),n=m.intval(i.attr("data-time")),s=this.dom.find(".js-conversation-"+o.destKey);if((a=s.children(".chat-row")).length)for(var a=a.get().reverse(),c=0;c<a.length;c++){if(m.intval(p(a[c]).attr("data-time"))<n){p(a[c]).after(i);break}if(c==a.length-1){s.prepend(i);break}}else s.append(i);this.scrolling||this.scrollRoom()}},getTpl:function(t,e){return m.template.parse(this.tpl[t],e)}},!1)})(jQuery,cbbCore),((o,i)=>{cbbEditorWrapper.plugins.chat={init:function(){this.chat=i.getService("chat"),this.chat.editor||(this.chat.editor=this.editor),this.bindInput(),this.updateCharCounter()},bindInput:function(){var t,e=this;e.editor.element.closest("#chat-message").length&&e.editor.element.on("keyup keydown",function(t){if(13==t.which)return"keyup"==t.type&&1!=t.ctrlKey?e.chat.submit():"keydown"==t.type&&1==t.ctrlKey&&e.editor.insertText("\n"),t.preventDefault(),t.stopPropagation(),!1}),e.chat.options.maxChars&&(t=o('<div class="chat-editor-counter"><span></span><svg height="20" width="20"><circle class="mask" cx="50%" cy="50%" r="8" fill="none" stroke-width="1"></circle><circle cx="50%" cy="50%" r="8" fill="none" stroke-width="2"></circle></svg></div>'),e.charCounter={radial:t.find("circle:not(.mask)"),label:t.children("span")},e.charCounter.radial.css({"stroke-dashoffset":50,"stroke-dasharray":50}),e.editor.element.on("input",o.proxy(e,"updateCharCounter")).after(t)),i.dispatchEvent("chat.onBindInput",this)},updateCharCounter:function(){var t,e,o,i;void 0!==this.charCounter&&(e=50-50*(t=this.editor.element.val()).length/this.chat.options.maxChars,o="danger",i="",this.charCounter.radial.css("stroke-dashoffset",Math.max(0,e)),5<e?o="safe":0<=e&&(o="warn"),this.charCounter.radial.get(0).setAttribute("class",o),e<0&&(i=this.chat.options.maxChars-t.length),this.charCounter.label.text(i))},eventCommandExec:function(){this.chat.options.hidePopup&&this.chat.closeActiveBox()},eventTextchange:function(){this.updateCharCounter()}}})(jQuery,cbbCore);
+++!function(p,m){"use strict";var e=null,o=null,f=null,i=!1,n=!1,s=!1,v=0,b=0,g=0,a=0,c=0,r=null,w=[];m.registerService("chat",{activeBox:null,connected:!1,currentRoom:!1,dom:null,method:"append",openRooms:[],tempDom:p("<div />"),editor:null,scrolling:!1,audio:new Audio,options:{autoconnect:!1,defaultRoom:0,direction:"down",floodTime:0,guestRoom:1,height:220,hidePopup:!1,imgSelector:".postimage",maxChars:0,maxRows:25,mode:"chat",noticeTimeout:2e4,page:"",soundPath:null,position:"bottom",refresh:5e3,tipTimeout:15e3},positions:{},tpl:{conversation:'<div class="ic-conversation js-conversation-<%ROOM_ID%>"></div>',sep:'<div class="sep"></div>',tab:'<li id="chat-tab-<%ROOM_ID%>"><%TITLE%> <a href="#" class="tab-close"><i class="fa fa-times-circle" aria-hidden="true"></i></a></li>',userlist:'<ul class="ic-userlist js-userlist-<%ROOM_ID%>"></ul>'},__construct:function(){var e=this;if(this.options.defaultRoom=this.options.defaultRoom||this.options.guestRoom,m.dispatchEvent("chat.beforeInit",this),"archive"===this.options.mode)this.bindRows(),p('[data-action="mark"], [data-action="unmark"]').click(function(t){t.preventDefault();var t="mark"==p(this).data("action"),e=t?"show":"hide",t=(p('input[name^="row_id_list"]').prop("checked",t),p(".chat-row .ic-row-actions").has(".row-id-list"));t[e].call(t)});else{if("up"==this.options.direction&&(this.method="prepend"),this.dom=p("#chat-body"),!(this.dom.length&&this.options.guestRoom&&this.options.height&&this.options.maxRows))return!1;void 0!==window.jchat_style_options&&(this.positions=window.jchat_style_options.positions);var t=!1;if("custom"==this.options.page&&this.positions.chat)t=this.positions.chat;else if("custom"!=this.options.page&&this.options.position){var o={};if(this.positions[this.options.page])o=this.positions[this.options.page];else{if(!this.positions.undefined)return!1;o=this.positions.undefined}t=o[this.options.position]}!1!==t&&(0==p(t[0]).length&&this.positions.undefined&&this.options.position&&(t=this.positions.undefined[this.options.position]),o=p(t[0]),t=t[1],1==(o=1<o.length?p(o[0]):o).length)&&o[t].apply(o,[this.dom]),m.colourIsDark(this.dom.find("#chat-content").css("background-color"),170)&&this.dom.addClass("dark-theme"),this.dom.objView(!0),m.browser.isMobile&&(p("head meta[name=viewport]").remove(),p("head").prepend('<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />')),p("#chat-conversation-container").on("scroll",function(){"up"==e.options.direction&&0<this.scrollTop||"down"==e.options.direction&&this.scrollTop<this.scrollHeight-this.offsetHeight?(e.scrolling=!0,p(".chat-scroll-button").objView(!0)):(e.scrolling=!1,p(".chat-scroll-button").objView(!1))}),p(".chat-scroll-button").addClass(e.options.direction).click(function(t){t.preventDefault(),e.scrollRoom()});t={autoClose:!1,minSize:180,yPosition:"top",wrapper:this.dom,onOpen:function(){e.closeActiveBox(),e.activeBox=this},onClose:function(){e.activeBox=null}},o=(this.dom.find('a[data-action="showbox"]').cbbDropdown(p.extend({},t,{adjustMethod:"resize"})),this.dom.find('a[data-action="color"]').cbbColorPicker(p.extend({},t,{realTimeUpdate:!1,onChange:function(t){e.editor.insertBBcode("color",t),e.options.hidePopup&&e.closeActiveBox()}})),this.dom.find("a[data-action]").filter(function(){return!p(this).data("cbbDropdown")}).click(p.proxy(this,"eventDispatch")),this.bindLinks(this.dom),this.collapsable("init"),1==this.cookie("mute")&&this.player("mute",!0),p("#chat-conversation-container").css("height",this.options.height),p("#chat-right-panel").css("height",this.options.height+p("#chat-tabs").height()),p("#chat-toolbar a").addClass("chat-corner-top chat-corner-bottom"),p(".ic-box").addClass("chat-corner-top"),this.initMessages(),this.status("stop"),m.dispatchEvent("chat.onInit",this),this.cookie("connectStatus"));this.options.autoconnect=1===o||0!==o&&this.options.autoconnect,this.options.autoconnect&&!this.dom.is(".collapsed")?this.connect(!0):this.disconnect()}},connect:function(t){var e=this,o=this.connected?"disconnect":"connect",i=!1;s=1==t,"connect"==o&&this.cookie("auto_away")&&(i={auto_away:this.cookie("auto_away")}),this.send(o,i,function(){s=!1,t||e.cookie("connectStatus","connect"==o?1:0,-1),"connect"==o&&(e.dom.find("#purge-button").removeClass("disabled"),e.traceCheck("start"),m.dispatchEvent("chat.onConnect",!1))})},disconnect:function(t){var e=p("#chat-main-message").clone();this.status("stop"),this.traceCheck("stop"),this.dom.find('[data-action="connect"]').removeClass("connected"),this.dom.find("#purge-button").addClass("disabled"),t&&e.html(t),p("#chat-conversation-container").append(e),e.show(),this.dom.removeAttr("data-active"),m.dispatchEvent("chat.onDisconnect",!1)},closeActiveBox:function(){null!==this.activeBox&&this.activeBox.close()},collapsable:function(t){var e=this.dom.find("#chat-content"),o=e.is(":visible"),i=this.dom.find('[data-action="minimize"]');if("custom"==this.options.page)return i.remove(),!1;switch(t){case"change":n(!o),o?(this.closeActiveBox(),e.slideUp(),o=!1,this.disconnect(),this.cookie("collapsed",1)):(e.slideDown(),this.connect(o=!0),this.cookie("collapsed","",-1));case"init":"init"==t&&(m.intval(this.cookie("collapsed"))||0)&&(n(!1),e.hide(),o=!1),this.dom.toggleClass("collapsed",!o),i.children(".fa").toggleClass("fa-minus",o).toggleClass("fa-plus",!o)}function n(t){var e=i.parent("dt");t?e.removeStyle("margin-bottom"):e.css("margin-bottom",e.css("margin-top"))}},initMessages:function(){var t=p("#chat-notices"),e=p("#chat-tips"),o=t.find(".js-message"),i=e.find(".js-message");function n(t,e,o){var i=t.data("current_text");void 0===i&&(i=-1),e[++i]||(i=0),e.objView(!1),p(e[i]).objView(!0),t.data("current_text",i),1<e.length&&o&&setTimeout(function(){n(t,e,o)},o)}0<o.length&&(t.objView(!0),n(t,o,this.options.noticeTimeout)),0<i.length&&(e.objView(!0),n(e,i,this.options.tipTimeout))},refresh:function(){var t=this.connected?"refresh":"connect";this.status("pause"),this.send(t)},submit:function(){var t=new p.Event("chat.beforeSubmit",{service:this});if(m.dispatchEvent(t),!t.isDefaultPrevented()){var t=this.editor.element.val().replace(/\[\/?[^\]]+\]/g,""),e=new Date;if(!p.trim(t)||null!=f||a&&e.getTime()-a<600)return!1;if(this.options.maxChars)if(m.intval(this.editor.element.next(".chat-editor-counter").children("span").text())<0)return!1;return a=e.getTime(),this.status("pause"),this.send("post",{lastPostTime:v,auto_away:g})}},send:function(r,t,h){var l=this,d={ajaxModule:"chat",action:r};if(this.status("loading"))return"refresh"!=r&&w.push([r,t,h]),!1;-1!=p.inArray(r,["post","connect","disconnect","refresh","pmuser","set_available","set_away","set_busy","set_hidden","set_name"])&&(d=p.extend(d,this.dom.find("form").serializeObject())),this.currentRoom&&(d.room=this.currentRoom),t&&(d=p.extend(d,t)),"refresh"==r&&(3<c&&(d.trace=!0,c=0),c++),d.rooms=this.openRooms;var u=new p.Event("chat.beforeSend",{action:r,service:this,sendData:d});m.dispatchEvent(u),u.isDefaultPrevented()||("trace"!=r&&this.status("load-start"),m.request({showLoading:!1,data:u.sendData,onComplete:function(){l.status("load-end")},onSuccess:function(t){var e=!1,o=new Date;if(l.tempDom.html(t.htmlContent),!t.success)return l.dialog("close"),t.message&&alert(t.message),!1;if(t.dialog)return l.dialog({content:t.htmlContent}),!1;switch(t.action){case"disable":return l.disconnect(),window.location.reload(),!0;case"disconnect":l.disconnect();break;case"exclude":return l.disconnect(t.message),!0;case"login":l.connected=!1,l.dialog({content:t.htmlContent,onOpen:function(e){e.ui.find("input:first").focus(),e.ui.find("input[type=text], input[type=password]").keydown(function(t){if(13==t.which&&p(this).val())return e.ui.find('[value="submit"]').click(),t.preventDefault(),t.stopPropagation(),!1})},onSubmit:function(t){if(!t.username&&!t.username_register)return p(this).find("input[name=username]").addClass("cbb-state-error").focus(),!1;t.submit=1,l.send("connect",t,function(t){t.userLogged&&(l.cookie("connectStatus",1,-1),window.location.reload())})}});break;case"update":l.dom.find("input[name=last_update]").val(t.last_time),l.dom.find("input[name=time_mark]").val(t.timeMark),l.options.floodTime=t.floodTime,t.msg_direction&&t.msg_direction!=l.options.direction&&(l.options.direction=t.msg_direction,l.method="up"==t.msg_direction?"prepend":"append",l.inverseConversations(),e=!0);var i=null!=t.auto_away?t.auto_away:g;i!=g&&(g=i)&&l.cookie("auto_away",g);break;case"banuser":l.closeRoom(t.user_key);case"unbanuser":l.dom.find(".js-user-"+t.user_key).html(l.tempDom.find(".js-userlist li:first").html()),l.bindUserlist(!1,t.user_key);break;case"close_room":l.closeRoom(t.room_key)}switch(r){case"disconnect":l.disconnect();break;case"post":l.editor.element.val(""),l.editor.plugins.chat.updateCharCounter(),l.options.floodTime&&!t.ignoreFloodTime&&(l.editor.element.val(m.lang("CHAT_FLOOD_WAIT")).prop("disabled",!0).addClass("disabled").blur(),f=setTimeout(function(){l.editor.element.val("").prop("disabled",!1).removeClass("disabled").focus(),f=null},l.options.floodTime)),v=o.getTime()/1e3;case"set_available":case"set_away":case"set_busy":case"set_hidden":case"set_name":case"connect":l.connected||p("#chat-conversation-container").html(""),"connect"!=r&&"post"!=r||(l.connected=!0),"connect"==r&&l.dom.find('[data-action="connect"]').addClass("connected"),g=0,l.cookie("auto_away",0,-1);case"move":if("move"==r){if(!u.sendData.submit)break;p("#chat-conversation-container > div").html("")}case"pmuser":case"refresh":l.connected&&(a=l.appendConversationData(r),l.tempDom.html(""),l.currentRoom=l.currentRoom||l.options.defaultRoom,p("#chat-tab-"+l.currentRoom).length||(l.currentRoom=l.options.guestRoom),p("#chat-tab-"+l.currentRoom).hasClass("active")||l.openRoom(l.currentRoom),(a||e)&&(l.bindRows(),a&&"refresh"==r&&l.player("play","add"),l.scrolling||l.scrollRoom(),p("#chat-conversation-container .ic-row-text img").one("load",function(){this.loaded=!0,l.scrolling||l.scrollRoom()}).each(function(){this.complete&&!this.loaded&&p(this).trigger("load")})),l.doQueue(t.queueActions),l.status("resume"),b=o.getTime(),l.cookie("lastcheck",parseInt(b/1e3),365));break;case"quote":l.editor.insertText(t.text);break;case"history":var n=l.dom.find(".js-conversation-"+l.currentRoom),s=n.outerHeight(),a=l.appendConversationData(r);l.tempDom.html(""),a&&(n.data("ignoreLimit",!0),"up"!=l.options.direction&&(a=n.outerHeight(),l.scrollRoom(a-s)),l.bindRows())}var c=new p.Event("chat.afterSend",{action:r,service:this,sendData:d,response:t});m.dispatchEvent(c),"function"!=typeof h||c.isDefaultPrevented()||h.call(!1,t),w.length&&l.send.apply(l,w.shift())}}))},traceCheck:function(t){let e=this;switch(t){case"start":null!==o&&e.traceCheck("stop"),o=setInterval(function(){var t=new Date;b&&t.getTime()>b+1.5*e.options.refresh&&(e.send("trace"),b=t.getTime())},e.options.refresh);break;case"stop":clearInterval(o),o=null}},closeRoom:function(t){if(null==t||t==this.options.guestRoom)return!1;var e;-1!=(e=p.inArray(t,this.openRooms))&&(p("#chat-tab-"+t+", .js-conversation-"+t+", .js-userlist-"+t).remove(),m.dispatchEvent("chat.onCloseRoom",{instance:this,room:t}),this.openRooms.splice(e,1),e=this.currentRoom==t?this.options.guestRoom:this.currentRoom,this.openRoom(e,!0))},openRoom:function(t,e){var o=this.currentRoom,i=p("#chat-tab-"+t);if(-1!=p.inArray(o,self.openRooms)&&!0!==e)return!1;o&&(p(".js-conversation-"+o+", .js-userlist-"+o).hide(),p("#chat-tabs li").removeClass("active before-active after-active"),p("#chat-tabs .tab-close").removeClass("active")),this.currentRoom=t,p(".js-conversation-"+t+", .js-userlist-"+t).show(),i.addClass("active").removeClass("new-msg"),i.prev("li").addClass("before-active"),i.next("li").addClass("after-active"),i.find(".tab-close").addClass("active"),this.dom.attr("data-active",t);var e=p(".js-conversation-"+t).is(".js-public-room")?"removeClass":"addClass",o=this.dom.find("#purge-button"),i=(o[e].call(o,"disabled"),new p.Event("chat.onOpenRoom",{instance:this,room:t,backgroundAction:s}));m.dispatchEvent(i),i.isDefaultPrevented()||(this.scrolling=!1,this.scrollRoom(),s)||m.browser.isMobile||!this.editor||(e=this.editor.element.offset().top-p(window).scrollTop())<p(window).height()&&0<=e&&this.editor.element.focus()},bindLinks:function(t){window.self!=window.top&&t.find("a[href]:not([data-action],[data-code],.ic-row-action-launcher)").off("click.frame").on("click.frame",function(t){t.preventDefault(),window.top.location.href=this.href})},bindTabs:function(){var o=this;p("#chat-tabs").find("li, .tab-close").off(),p("#chat-tabs li").click(function(t){var e=parseInt(p(this).attr("id").replace("chat-tab-",""));o.openRoom(e),t.preventDefault()}),p("#chat-tabs li .tab-close").click(function(t){var e=p(this).parent(),e=parseInt(e.attr("id").replace("chat-tab-",""));o.closeRoom(e),t.preventDefault()}),m.dispatchEvent("chat.onBindTabs",this)},bindRows:function(){var o=this,t=p("#chat-conversation-container .chat-row");t.off().find(".ic-row-action-launcher").cbbDropdown({onCreate:function(){var e=this;e.rowID=e.launcher.closest(".chat-row").data("id"),e.container.find("[data-action]").off("click").click(function(t){t.preventDefault(),t.msgID=e.rowID,o.eventDispatch(t),e.close()})},onOpen:function(){this.launcher.closest(".chat-row").addClass("active"),o.status("pause",!0)},onClose:function(){this.launcher.closest(".chat-row").removeClass("active").children(".chat-row-content").mouseleave(),o.status("resume")}}),m.browser.isMobile?t.find(".ic-row-actions").show():t.filter(":not(.chat-format-bubble)").children(".chat-row-content").hover(function(){p(this).children(".ic-row-actions").show()},function(){p(this).closest(".chat-row").is(".active")||p(this).children(".ic-row-actions").each(function(){if(0<p(this).children(".row-id-list:checked").length)return!0;p(this).hide()})}),p("#chat-conversation-container").find(".history-row a, .chat-quickmention").off("click").click(p.proxy(this,"eventDispatch")),t.cbbImageGallery({imageSelector:"img:not(.emoji, .smilies)"}),o.bindLinks(t),m.dispatchEvent("chat.onBindRows",this)},bindUserlist:function(t,e){var t=e?".js-user-"+e:t?".js-userlist-"+t:".ic-userlist",e=e?p(t):p(t).children("li"),o=this;e.find("a").off("click").click(p.proxy(o,"eventDispatch")),e.children("a").cbbDropdown({dispatchEvent:"contextmenu",showPointer:!1,onCreate:function(){this.container.find("a").click(p.proxy(this,"close"))},onOpen:function(){o.currentMenu=this,o.status("pause",!0)},onClose:function(){o.currentMenu=null,o.status("resume")}}),m.dispatchEvent("chat.onBindUserlist",this)},eventDispatch:function(t){t.preventDefault();var e=p(t.currentTarget),o=e.data("action"),i=t.msgID,n=this;if(e.is(".disabled"))return!1;!i&&e.closest(".chat-row").length&&(i=e.closest(".chat-row").data("id"));t=new p.Event("chat.beforeEventDispatch",{originalEvent:t,action:o,service:this,msgID:i});if(m.dispatchEvent(t),!t.isDefaultPrevented()){switch(o){case"connect":case"refresh":this.closeActiveBox();case"submit":this[o].call(this);break;case"clear":n.send("clear",!1,function(){p(".js-conversation-"+n.currentRoom).html("")});break;case"rules":n.send("rules",!1,function(t){n.dialog({content:t.htmlContent,height:120,width:350})});break;case"sound":this.closeActiveBox(),this.player("mute");break;case"edit":n.send("edit",{id:i},function(t){n.dialog({autoFocus:!0,content:t.htmlContent,width:610,onSubmit:function(t){if((t=p.extend(t,{id:i,submit:1}),n.options.maxChars)&&m.intval(p(this).find(".chat-editor-counter > span").text())<0)return!1;n.send("edit",t,function(t){t.text&&p("#chat-row-"+i).find(".ic-row-text").html(t.text)})}})});break;case"delete":this.send("delete",{id:i},function(){n.player("play","delete"),p("#chat-row-"+i).fadeOut()});break;case"quote":this.send(o,{id:i});break;case"whois":n.send("whois",{id:i},function(t){n.dialog({content:t.htmlContent,width:450,height:150})});break;case"user":window.open(e.attr("href"));break;case"banuser":var s=e.data("user-key");this.send("banuser",{uk:s},function(t){n.dialog({content:t.htmlContent,onOpen:function(e){p("#ban-period").change(function(){var t="0"==p(this).val();e.ui.find("dl:has(#ban-date)").objView(t),t||e.ui.find("#ban-date").val("").removeClass("cbb-state-error")})},onSubmit:function(t){if("0"==t.period&&null==t.date.match(/\d{2}\/\d{2}\/\d{4} \d{2}\:\d{2}\:\d{2}/))return p(this).find("#ban-date").addClass("cbb-state-error").focus(),!1;t=p.extend(t,{uk:s,submit:1}),n.send("banuser",t)}})});break;case"quickmention":var a=(c=e.next(".ic-row-username:first")).children("a");case"mentionuser":(a="mentionuser"==o?(c=this.currentMenu.launcher).children("span"):a).length?n.editor.insertBBcode("color",{defaultAttr:m.rgbToHex(a.css("color")),inner:"[b]@"+a.text()+"[/b]"},FLAG_ADDWHITESPACES|FLAG_CURSORTOEND):n.editor.insertBBcode("b",{inner:"@"+c.text()},FLAG_ADDWHITESPACES|FLAG_CURSORTOEND);break;case"pmuser":s=e.data("user-key");-1==p.inArray(s,this.openRooms)?this.send("pmuser",{uk:s},function(){n.openRoom(s)}):this.openRoom(s);break;case"unbanuser":case"set_available":case"set_away":case"set_busy":case"set_hidden":this.send(o,{uk:e.data("user-key")});break;case"set_name":s=e.data("user-key");this.send("set_name",{uk:s},function(t){n.dialog({autoFocus:!0,content:t.htmlContent,onSubmit:function(t){if(!(t=p.extend(t,{uk:s,submit:1})).username)return p(this).find("input[name=username]").addClass("cbb-state-error").focus(),!1;n.send("set_name",t)}})});break;case"move":this.send("move",{id:i},function(t){n.dialog({content:t.htmlContent,onSubmit:function(t){t=p.extend(t,{id:i,submit:1,last_update:0}),n.send("move",t,function(){})}})});break;case"minimize":this.collapsable("change");break;case"history":var a="up"==this.options.direction?"prev":"next",c=e.parent()[a].call(e.parent(),".chat-row");this.send("history",{last_update:c.data("time")});break;default:window.open(e.attr("href"))}p(this).blur()}},player:function(t,e){if(null===this.options.soundPath)return!1;switch(t){case"mute":n&&!0!==e?!n&&!1!==e||(n=!1,p('a[data-action="sound"]').removeClass("muted"),this.cookie("mute","")):(n=!0,p('a[data-action="sound"]').addClass("muted"),this.cookie("mute",1,180));break;case"play":n||(this.audio.src=this.options.soundPath+e+".mp3",this.audio.play())}},dialog:function(e){var t,o=this;"string"==typeof e?null!==r&&(r.cbbDialog(e),"close"==e)&&(r=null):(t={autoClean:!1,autoFocus:e.autoFocus||!1,destroyOnClose:!0,movable:!1,width:e.width||"auto",height:e.height||"auto",parent:"archive"==this.options.mode?"body":p("#chat-content").is("ul")?"#chat-content > li":"#chat-content",onOpen:function(t){o.status("pause",!0),o.closeActiveBox(),o.bindLinks(p(this)),e.onOpen&&e.onOpen.call(this,t)},onClose:function(){o.status("resume")},onSubmit:e.onSubmit},r=p(e.content).cbbDialog(t))},scrollRoom:function(t){var e=p("#chat-conversation-container")[0];t?e.scrollTop=t:(e.scrollTop="up"==this.options.direction?0:e.scrollHeight,p(".chat-scroll-button").objView(!1))},status:function(t){switch(t){case"load-start":i=!0,p(".ic-loading").show();break;case"load-end":i=!1,p(".ic-loading").hide();break;case"loading":return i;case"stop":p("#chat-conversation-container, #chat-right-panel, #chat-tabs").html(""),this.openRooms=[],this.connected=!1,this.dom.find("input[name=last_update]").val(0),this.dom.find("input[name=time_mark]").val(0);case"pause":clearTimeout(e),e=null,this.status("load-end");break;case"resume":this.connected&&null===e&&(e=setTimeout(p.proxy(this,"refresh"),this.options.refresh))}},cookie:function(t,e,o){t="chat_"+t;if(null==e)return m.cookie.get(t);m.cookie.set(t,e,o)},inverseConversations:function(){p("#chat-conversation-container").children(".ic-conversation").each(function(){var t=p(this).children(".chat-row, .history-row");if(t.length){p(this).html("");for(var e=t.length-1;-1<e;e--)p(this).append(t[e])}})},appendConversationData:function(c){var r=this,h=!1,t=new Date,l=this.cookie("lastcheck")||t.getTime()/1e3;return this.tempDom.find(".room").each(function(){var t=parseInt(p(this).attr("id").replace("room-","")),e=p.trim(p(this).children(".js-conversation").html()),o=p.trim(p(this).children(".js-userlist").html());if(-1==p.inArray(t,r.openRooms)){if("history"==c)return!0;r.openRooms.push(t);var i={ROOM_ID:t,TITLE:p(this).attr("title")};p("#chat-right-panel").append(r.getTpl("userlist",i)),p("#chat-conversation-container").append(r.getTpl("conversation",i)),p("#chat-tabs").append(r.getTpl("tab",i)),p(this).is(".js-public-room")&&(p(".js-conversation-"+t).addClass("js-public-room"),p("#chat-tab-"+t).find(".tab-close").remove()),r.bindTabs()}var n=p(".js-conversation-"+t);if("history"==c)n.children(".history-row").replaceWith(e),h=!!e;else if(e){n[r.method].apply(n,[e]);var s=n.children(".chat-row").length,a="up"==r.options.direction?":last":":first";if(!n.data("ignoreLimit"))for(;s>r.options.maxRows;)n.children(".chat-row"+a).remove(),s--;i="up"==r.options.direction?":first":":last",e=parseInt(n.children(".chat-row"+i).data("time"));t!=r.currentRoom&&("refresh"==c||e&&l<e)&&p("#chat-tab-"+t).addClass("new-msg"),h=!0}o&&(p(".js-userlist-"+t).html(o),r.bindUserlist(t))}),h},doQueue:function(t){if(!t||!t.length)return!1;let e=!1;for(var o of t)switch(o.action){case"delete":p("#chat-row-"+o.msgID).fadeOut();break;case"edit":p("#chat-row-"+o.msgID).find(".ic-row-text").html(o.msgText);break;case"connect":e||(e=!0,this.player("play","connect"));break;case"move":var i=this.dom.find("#chat-row-"+o.msgID),n=m.intval(i.attr("data-time")),s=this.dom.find(".js-conversation-"+o.destKey);if((a=s.children(".chat-row")).length)for(var a=a.get().reverse(),c=0;c<a.length;c++){if(m.intval(p(a[c]).attr("data-time"))<n){p(a[c]).after(i);break}if(c==a.length-1){s.prepend(i);break}}else s.append(i);this.scrolling||this.scrollRoom()}},getTpl:function(t,e){return m.template.parse(this.tpl[t],e)}},!1)}(jQuery,cbbCore),function(o,i){"use strict";cbbEditorWrapper.plugins.chat={init:function(){this.chat=i.getService("chat"),this.chat.editor||(this.chat.editor=this.editor),this.bindInput(),this.updateCharCounter()},bindInput:function(){var t,e=this;e.editor.element.closest("#chat-message").length&&e.editor.element.on("keyup keydown",function(t){if(13==t.which)return"keyup"==t.type&&1!=t.ctrlKey?e.chat.submit():"keydown"==t.type&&1==t.ctrlKey&&e.editor.insertText("\n"),t.preventDefault(),t.stopPropagation(),!1}),e.chat.options.maxChars&&(t=o('<div class="chat-editor-counter"><span></span><svg height="20" width="20"><circle class="mask" cx="50%" cy="50%" r="8" fill="none" stroke-width="1"></circle><circle cx="50%" cy="50%" r="8" fill="none" stroke-width="2"></circle></svg></div>'),e.charCounter={radial:t.find("circle:not(.mask)"),label:t.children("span")},e.charCounter.radial.css({"stroke-dashoffset":50,"stroke-dasharray":50}),e.editor.element.on("input",o.proxy(e,"updateCharCounter")).after(t)),i.dispatchEvent("chat.onBindInput",this)},updateCharCounter:function(){var t,e,o,i;void 0!==this.charCounter&&(e=50-50*(t=this.editor.element.val()).length/this.chat.options.maxChars,o="danger",i="",this.charCounter.radial.css("stroke-dashoffset",Math.max(0,e)),5<e?o="safe":0<=e&&(o="warn"),this.charCounter.radial.get(0).setAttribute("class",o),e<0&&(i=this.chat.options.maxChars-t.length),this.charCounter.label.text(i))},eventCommandExec:function(){this.chat.options.hidePopup&&this.chat.closeActiveBox()},eventTextchange:function(){this.updateCharCounter()}}}(jQuery,cbbCore);
++ 
++-((t,o,n)=>{"function"==typeof define&&define.amd?define(["jquery"],function(e){return n(e,t,o),e.mobile}):n(t.jQuery,t,o)})(this,document,function(e,a,K,O){var t;t=function(e){return e.ui=e.ui||{},e.ui.version="1.12.1"},"function"==typeof define&&define.amd?define("jquery-ui/version",["jquery"],t):t(e),t=function(){},"function"==typeof define&&define.amd&&define("core",["./defaults","./data","./helpers"],t),t=function(e){var t={touch:"ontouchend"in K};return e.mobile={},e.mobile.support=e.mobile.support||{},e.extend(e.support,t),e.extend(e.mobile.support,t),e.support},"function"==typeof define&&define.amd?define("support/touch",["jquery","../ns"],t):t(e),t=function(e){return e.extend(e.support,{orientation:"orientation"in a&&"onorientationchange"in a}),e.support},"function"==typeof define&&define.amd?define("support/orientation",["jquery"],t):t(e),t=function(p){var c,e,i="virtualMouseBindings",u="virtualTouchID",l="clientX clientY pageX pageY screenX screenY".split(" "),t="vmouseover vmousedown vmousemove vmouseup vclick vmouseout vmousecancel".split(" "),f="altKey bubbles cancelable ctrlKey currentTarget detail eventPhase metaKey relatedTarget shiftKey target timeStamp view which".split(" "),o=p.event.mouseHooks?p.event.mouseHooks.props:[],h=f.concat(o),a={},n=0,s=0,r=0,v=!1,d=[],m=!1,g=!1,w="addEventListener"in K,T=p(K),y=1,b=0;function D(e){for(;e&&void 0!==e.originalEvent;)e=e.originalEvent;return e}function P(e){for(var t,o,n={};e;){for(o in t=p.data(e,i))t[o]&&(n[o]=n.hasVirtualBinding=!0);e=e.parentNode}return n}function k(){g=!0}function E(){b=0,d.length=0,m=!1,k()}function F(){g=!1}function X(){n&&(clearTimeout(n),n=0)}function Y(){X(),n=setTimeout(function(){n=0,E()},p.vmouse.resetTimerDuration)}function x(e,t,o){var n;return(o&&o[e]||!o&&((e,t)=>{for(var o;e;){if((o=p.data(e,i))&&(!t||o[t]))return e;e=e.parentNode}})(t.target,e))&&(n=((e,t)=>{var o,n,i,a,s,r,c,u=e.type;if((e=p.Event(e)).type=t,o=e.originalEvent,n=f,-1<u.search(/^(mouse|click)/)&&(n=h),o)for(s=n.length;s;)e[i=n[--s]]=o[i];if(-1<u.search(/mouse(down|up)|click/)&&!e.which&&(e.which=1),-1!==u.search(/^touch/)&&(u=(t=D(o)).touches,t=t.changedTouches,a=u&&u.length?u[0]:t&&t.length?t[0]:O))for(r=0,c=l.length;r<c;r++)e[i=l[r]]=a[i];return e})(t,e),p(t.target).trigger(n)),n}function M(e){var t=p.data(e.target,u);"click"===e.type&&"touchstart"===p.data(e.target,"lastTouchType")&&setTimeout(function(){"touchstart"===p.data(e.target,"lastTouchType")&&(E(),delete p.data(e.target).lastTouchType,M(e))},p.vmouse.maximumTimeBetweenTouches),m||b&&b===t||(t=x("v"+e.type,e))&&(t.isDefaultPrevented()&&e.preventDefault(),t.isPropagationStopped()&&e.stopPropagation(),t.isImmediatePropagationStopped())&&e.stopImmediatePropagation()}function I(e){var t,o=D(e).touches;o&&1===o.length&&(t=P(o=e.target),p.data(e.target,"lastTouchType",e.type),t.hasVirtualBinding)&&(b=y++,p.data(o,u,b),X(),F(),v=!1,o=D(e).touches[0],s=o.pageX,r=o.pageY,x("vmouseover",e,t),x("vmousedown",e,t))}function j(e){g||(v||x("vmousecancel",e,P(e.target)),p.data(e.target,"lastTouchType",e.type),v=!0,Y())}function q(e){var t,o,n,i;g||(t=D(e).touches[0],o=v,n=p.vmouse.moveDistanceThreshold,i=P(e.target),p.data(e.target,"lastTouchType",e.type),(v=v||Math.abs(t.pageX-s)>n||Math.abs(t.pageY-r)>n)&&!o&&x("vmousecancel",e,i),x("vmousemove",e,i),Y())}function S(e){var t,o;g||p.data(e.target,"lastTouchType")===O||(k(),delete p.data(e.target).lastTouchType,x("vmouseup",e,t=P(e.target)),v||(o=x("vclick",e,t))&&o.isDefaultPrevented()&&(o=D(e).changedTouches[0],d.push({touchID:b,x:o.clientX,y:o.clientY}),m=!0),x("vmouseout",e,t),v=!1,Y())}function B(e){var t,o=p.data(e,i);if(o)for(t in o)if(o[t])return 1}function L(){}for(p.vmouse={moveDistanceThreshold:10,clickDistanceThreshold:10,resetTimerDuration:1500,maximumTimeBetweenTouches:100},e=0;e<t.length;e++)p.event.special[t[e]]=(o=>{var n=o.substr(1);return{setup:function(){B(this)||p.data(this,i,{}),p.data(this,i)[o]=!0,a[o]=(a[o]||0)+1,1===a[o]&&T.on(n,M),p(this).on(n,L),w&&(a.touchstart=(a.touchstart||0)+1,1===a.touchstart)&&T.on("touchstart",I).on("touchend",S).on("touchmove",q).on("scroll",j)},teardown:function(){--a[o],a[o]||T.off(n,M),w&&(--a.touchstart,a.touchstart||T.off("touchstart",I).off("touchmove",q).off("touchend",S).off("scroll",j));var e=p(this),t=p.data(this,i);t&&(t[o]=!1),e.off(n,L),B(this)||e.removeData(i)}}})(t[e]);w&&K.addEventListener("click",function(e){var t,o,n,i,a,s=d.length,r=e.target;if(s)for(t=e.clientX,o=e.clientY,c=p.vmouse.clickDistanceThreshold,n=r;n;){for(i=0;i<s;i++)if(a=d[i],n===r&&Math.abs(a.x-t)<c&&Math.abs(a.y-o)<c||p.data(n,u)===a.touchID)return e.preventDefault(),void e.stopPropagation();n=n.parentNode}},!0)},"function"==typeof define&&define.amd?define("vmouse",["jquery"],t):t(e),t=function(u){var p=u(K),e=u.mobile.support.touch,o=e?"touchstart":"mousedown",r=e?"touchend":"mouseup",c=e?"touchmove":"mousemove";function l(e,t,o,n){var i=o.type;o.type=t,n?u.event.trigger(o,O,e):u.event.dispatch.call(e,o),o.type=i}return u.each("touchstart touchmove touchend tap taphold swipe swipeleft swiperight".split(" "),function(e,t){u.fn[t]=function(e){return e?this.on(t,e):this.trigger(t)},u.attrFn&&(u.attrFn[t]=!0)}),u.event.special.tap={tapholdThreshold:750,emitTapOnTaphold:!0,setup:function(){var s=this,r=u(s),c=!1;r.on("vmousedown",function(e){if(c=!1,e.which&&1!==e.which)return!0;var t,o,n=e.target;function i(){clearTimeout(t)}function a(){i(),r.off("vclick",o).off("vmouseup",i),p.off("vmousecancel",a)}o=function(e){a(),c||n!==e.target?c&&e.preventDefault():l(s,"tap",e)},r.on("vmouseup",i).on("vclick",o),p.on("vmousecancel",a),t=setTimeout(function(){u.event.special.tap.emitTapOnTaphold||(c=!0),t=0,l(s,"taphold",u.Event("taphold",{target:n}))},u.event.special.tap.tapholdThreshold)})},teardown:function(){u(this).off("vmousedown").off("vclick").off("vmouseup"),p.off("vmousecancel")}},u.event.special.swipe={scrollSupressionThreshold:30,durationThreshold:1e3,horizontalDistanceThreshold:2<=a.devicePixelRatio?15:30,verticalDistanceThreshold:2<=a.devicePixelRatio?15:30,getLocation:function(e){var t=a.pageXOffset,o=a.pageYOffset,n=e.clientX,i=e.clientY;return 0===e.pageY&&Math.floor(i)>Math.floor(e.pageY)||0===e.pageX&&Math.floor(n)>Math.floor(e.pageX)?(n-=t,i-=o):(i<e.pageY-o||n<e.pageX-t)&&(n=e.pageX-t,i=e.pageY-o),{x:n,y:i}},start:function(e){var t=e.originalEvent.touches?e.originalEvent.touches[0]:e,t=u.event.special.swipe.getLocation(t);return{time:(new Date).getTime(),coords:[t.x,t.y],origin:u(e.target)}},stop:function(e){e=e.originalEvent.touches?e.originalEvent.touches[0]:e,e=u.event.special.swipe.getLocation(e);return{time:(new Date).getTime(),coords:[e.x,e.y]}},handleSwipe:function(e,t,o,n){var i;return t.time-e.time<u.event.special.swipe.durationThreshold&&Math.abs(e.coords[0]-t.coords[0])>u.event.special.swipe.horizontalDistanceThreshold&&Math.abs(e.coords[1]-t.coords[1])<u.event.special.swipe.verticalDistanceThreshold&&(i=e.coords[0]>t.coords[0]?"swipeleft":"swiperight",l(o,"swipe",u.Event("swipe",{target:n,swipestart:e,swipestop:t}),!0),l(o,i,u.Event(i,{target:n,swipestart:e,swipestop:t}),!0),!0)},eventInProgress:!1,setup:function(){var a=this,e=u(a),s={},t=u.data(this,"mobile-events");t||u.data(this,"mobile-events",t={length:0}),t.length++,(t.swipe=s).start=function(e){var t,o,n,i;u.event.special.swipe.eventInProgress||(u.event.special.swipe.eventInProgress=!0,o=u.event.special.swipe.start(e),n=e.target,i=!1,s.move=function(e){o&&!e.isDefaultPrevented()&&(t=u.event.special.swipe.stop(e),i||(i=u.event.special.swipe.handleSwipe(o,t,a,n))&&(u.event.special.swipe.eventInProgress=!1),Math.abs(o.coords[0]-t.coords[0])>u.event.special.swipe.scrollSupressionThreshold)&&e.preventDefault()},s.stop=function(){i=!0,u.event.special.swipe.eventInProgress=!1,p.off(c,s.move),s.move=null},p.on(c,s.move).one(r,s.stop))},e.on(o,s.start)},teardown:function(){var e,t=u.data(this,"mobile-events");t&&(e=t.swipe,delete t.swipe,t.length--,0===t.length)&&u.removeData(this,"mobile-events"),e&&(e.start&&u(this).off(o,e.start),e.move&&p.off(c,e.move),e.stop)&&p.off(r,e.stop)}},u.each({taphold:"tap",swipeleft:"swipe.left",swiperight:"swipe.right"},function(e,t){u.event.special[e]={setup:function(){u(this).on(t,u.noop)},teardown:function(){u(this).off(t)}}}),u.event.special},"function"==typeof define&&define.amd?define("events/touch",["jquery","../vmouse","../support/touch"],t):t(e),t=function(s){var r="touchmove scroll";return s.each(["scrollstart","scrollstop"],function(e,t){s.fn[t]=function(e){return e?this.on(t,e):this.trigger(t)},s.attrFn&&(s.attrFn[t]=!0)}),s.event.special.scrollstart={enabled:!0,setup:function(){var n,t,i=this,e=s(i);function o(e,t){var o=e.type;n=t,e.type=n?"scrollstart":"scrollstop",s.event.dispatch.call(i,e),e.type=o}var a=s.event.special.scrollstart.handler=function(e){s.event.special.scrollstart.enabled&&(n||o(e,!0),clearTimeout(t),t=setTimeout(function(){o(e,!1)},50))};e.on(r,a)},teardown:function(){s(this).off(r,s.event.special.scrollstart.handler)}},s.each({scrollstop:"scrollstart"},function(e,t){s.event.special[e]={setup:function(){s(this).on(t,s.noop)},teardown:function(){s(this).off(t)}}}),s.event.special},"function"==typeof define&&define.amd?define("events/scroll",["jquery"],t):t(e)});
++\ No newline at end of file
+++!function(t,o,n){"function"==typeof define&&define.amd?define(["jquery"],function(e){return n(e,t,o),e.mobile}):n(t.jQuery,t,o)}(this,document,function(e,a,K,O){var t;t=function(e){return e.ui=e.ui||{},e.ui.version="1.12.1"},"function"==typeof define&&define.amd?define("jquery-ui/version",["jquery"],t):t(e),t=function(){},"function"==typeof define&&define.amd&&define("core",["./defaults","./data","./helpers"],t),t=function(e){var t={touch:"ontouchend"in K};return e.mobile={},e.mobile.support=e.mobile.support||{},e.extend(e.support,t),e.extend(e.mobile.support,t),e.support},"function"==typeof define&&define.amd?define("support/touch",["jquery","../ns"],t):t(e),t=function(e){return e.extend(e.support,{orientation:"orientation"in a&&"onorientationchange"in a}),e.support},"function"==typeof define&&define.amd?define("support/orientation",["jquery"],t):t(e),t=function(p){var c,e,i="virtualMouseBindings",u="virtualTouchID",l="clientX clientY pageX pageY screenX screenY".split(" "),t="vmouseover vmousedown vmousemove vmouseup vclick vmouseout vmousecancel".split(" "),f="altKey bubbles cancelable ctrlKey currentTarget detail eventPhase metaKey relatedTarget shiftKey target timeStamp view which".split(" "),o=p.event.mouseHooks?p.event.mouseHooks.props:[],h=f.concat(o),a={},n=0,s=0,r=0,v=!1,d=[],m=!1,g=!1,w="addEventListener"in K,T=p(K),y=1,b=0;function D(e){for(;e&&void 0!==e.originalEvent;)e=e.originalEvent;return e}function P(e){for(var t,o,n={};e;){for(o in t=p.data(e,i))t[o]&&(n[o]=n.hasVirtualBinding=!0);e=e.parentNode}return n}function k(){g=!0}function E(){b=0,d.length=0,m=!1,k()}function F(){g=!1}function X(){n&&(clearTimeout(n),n=0)}function Y(){X(),n=setTimeout(function(){n=0,E()},p.vmouse.resetTimerDuration)}function x(e,t,o){var n;return(o&&o[e]||!o&&function(e,t){for(var o;e;){if((o=p.data(e,i))&&(!t||o[t]))return e;e=e.parentNode}}(t.target,e))&&(n=function(e,t){var o,n,i,a,s,r,c,u=e.type;if((e=p.Event(e)).type=t,o=e.originalEvent,n=f,-1<u.search(/^(mouse|click)/)&&(n=h),o)for(s=n.length;s;)e[i=n[--s]]=o[i];if(-1<u.search(/mouse(down|up)|click/)&&!e.which&&(e.which=1),-1!==u.search(/^touch/)&&(u=(t=D(o)).touches,t=t.changedTouches,a=u&&u.length?u[0]:t&&t.length?t[0]:O))for(r=0,c=l.length;r<c;r++)e[i=l[r]]=a[i];return e}(t,e),p(t.target).trigger(n)),n}function M(e){var t=p.data(e.target,u);"click"===e.type&&"touchstart"===p.data(e.target,"lastTouchType")&&setTimeout(function(){"touchstart"===p.data(e.target,"lastTouchType")&&(E(),delete p.data(e.target).lastTouchType,M(e))},p.vmouse.maximumTimeBetweenTouches),m||b&&b===t||(t=x("v"+e.type,e))&&(t.isDefaultPrevented()&&e.preventDefault(),t.isPropagationStopped()&&e.stopPropagation(),t.isImmediatePropagationStopped())&&e.stopImmediatePropagation()}function I(e){var t,o=D(e).touches;o&&1===o.length&&(t=P(o=e.target),p.data(e.target,"lastTouchType",e.type),t.hasVirtualBinding)&&(b=y++,p.data(o,u,b),X(),F(),v=!1,o=D(e).touches[0],s=o.pageX,r=o.pageY,x("vmouseover",e,t),x("vmousedown",e,t))}function j(e){g||(v||x("vmousecancel",e,P(e.target)),p.data(e.target,"lastTouchType",e.type),v=!0,Y())}function q(e){var t,o,n,i;g||(t=D(e).touches[0],o=v,n=p.vmouse.moveDistanceThreshold,i=P(e.target),p.data(e.target,"lastTouchType",e.type),(v=v||Math.abs(t.pageX-s)>n||Math.abs(t.pageY-r)>n)&&!o&&x("vmousecancel",e,i),x("vmousemove",e,i),Y())}function S(e){var t,o;g||p.data(e.target,"lastTouchType")===O||(k(),delete p.data(e.target).lastTouchType,x("vmouseup",e,t=P(e.target)),v||(o=x("vclick",e,t))&&o.isDefaultPrevented()&&(o=D(e).changedTouches[0],d.push({touchID:b,x:o.clientX,y:o.clientY}),m=!0),x("vmouseout",e,t),v=!1,Y())}function B(e){var t,o=p.data(e,i);if(o)for(t in o)if(o[t])return 1}function L(){}for(p.vmouse={moveDistanceThreshold:10,clickDistanceThreshold:10,resetTimerDuration:1500,maximumTimeBetweenTouches:100},e=0;e<t.length;e++)p.event.special[t[e]]=function(o){var n=o.substr(1);return{setup:function(){B(this)||p.data(this,i,{}),p.data(this,i)[o]=!0,a[o]=(a[o]||0)+1,1===a[o]&&T.on(n,M),p(this).on(n,L),w&&(a.touchstart=(a.touchstart||0)+1,1===a.touchstart)&&T.on("touchstart",I).on("touchend",S).on("touchmove",q).on("scroll",j)},teardown:function(){--a[o],a[o]||T.off(n,M),w&&(--a.touchstart,a.touchstart||T.off("touchstart",I).off("touchmove",q).off("touchend",S).off("scroll",j));var e=p(this),t=p.data(this,i);t&&(t[o]=!1),e.off(n,L),B(this)||e.removeData(i)}}}(t[e]);w&&K.addEventListener("click",function(e){var t,o,n,i,a,s=d.length,r=e.target;if(s)for(t=e.clientX,o=e.clientY,c=p.vmouse.clickDistanceThreshold,n=r;n;){for(i=0;i<s;i++)if(a=d[i],n===r&&Math.abs(a.x-t)<c&&Math.abs(a.y-o)<c||p.data(n,u)===a.touchID)return e.preventDefault(),void e.stopPropagation();n=n.parentNode}},!0)},"function"==typeof define&&define.amd?define("vmouse",["jquery"],t):t(e),t=function(u){var p=u(K),e=u.mobile.support.touch,o=e?"touchstart":"mousedown",r=e?"touchend":"mouseup",c=e?"touchmove":"mousemove";function l(e,t,o,n){var i=o.type;o.type=t,n?u.event.trigger(o,O,e):u.event.dispatch.call(e,o),o.type=i}return u.each("touchstart touchmove touchend tap taphold swipe swipeleft swiperight".split(" "),function(e,t){u.fn[t]=function(e){return e?this.on(t,e):this.trigger(t)},u.attrFn&&(u.attrFn[t]=!0)}),u.event.special.tap={tapholdThreshold:750,emitTapOnTaphold:!0,setup:function(){var s=this,r=u(s),c=!1;r.on("vmousedown",function(e){if(c=!1,e.which&&1!==e.which)return!0;var t,o,n=e.target;function i(){clearTimeout(t)}function a(){i(),r.off("vclick",o).off("vmouseup",i),p.off("vmousecancel",a)}o=function(e){a(),c||n!==e.target?c&&e.preventDefault():l(s,"tap",e)},r.on("vmouseup",i).on("vclick",o),p.on("vmousecancel",a),t=setTimeout(function(){u.event.special.tap.emitTapOnTaphold||(c=!0),t=0,l(s,"taphold",u.Event("taphold",{target:n}))},u.event.special.tap.tapholdThreshold)})},teardown:function(){u(this).off("vmousedown").off("vclick").off("vmouseup"),p.off("vmousecancel")}},u.event.special.swipe={scrollSupressionThreshold:30,durationThreshold:1e3,horizontalDistanceThreshold:2<=a.devicePixelRatio?15:30,verticalDistanceThreshold:2<=a.devicePixelRatio?15:30,getLocation:function(e){var t=a.pageXOffset,o=a.pageYOffset,n=e.clientX,i=e.clientY;return 0===e.pageY&&Math.floor(i)>Math.floor(e.pageY)||0===e.pageX&&Math.floor(n)>Math.floor(e.pageX)?(n-=t,i-=o):(i<e.pageY-o||n<e.pageX-t)&&(n=e.pageX-t,i=e.pageY-o),{x:n,y:i}},start:function(e){var t=e.originalEvent.touches?e.originalEvent.touches[0]:e,t=u.event.special.swipe.getLocation(t);return{time:(new Date).getTime(),coords:[t.x,t.y],origin:u(e.target)}},stop:function(e){e=e.originalEvent.touches?e.originalEvent.touches[0]:e,e=u.event.special.swipe.getLocation(e);return{time:(new Date).getTime(),coords:[e.x,e.y]}},handleSwipe:function(e,t,o,n){var i;return t.time-e.time<u.event.special.swipe.durationThreshold&&Math.abs(e.coords[0]-t.coords[0])>u.event.special.swipe.horizontalDistanceThreshold&&Math.abs(e.coords[1]-t.coords[1])<u.event.special.swipe.verticalDistanceThreshold&&(i=e.coords[0]>t.coords[0]?"swipeleft":"swiperight",l(o,"swipe",u.Event("swipe",{target:n,swipestart:e,swipestop:t}),!0),l(o,i,u.Event(i,{target:n,swipestart:e,swipestop:t}),!0),!0)},eventInProgress:!1,setup:function(){var a=this,e=u(a),s={},t=u.data(this,"mobile-events");t||u.data(this,"mobile-events",t={length:0}),t.length++,(t.swipe=s).start=function(e){var t,o,n,i;u.event.special.swipe.eventInProgress||(u.event.special.swipe.eventInProgress=!0,o=u.event.special.swipe.start(e),n=e.target,i=!1,s.move=function(e){o&&!e.isDefaultPrevented()&&(t=u.event.special.swipe.stop(e),i||(i=u.event.special.swipe.handleSwipe(o,t,a,n))&&(u.event.special.swipe.eventInProgress=!1),Math.abs(o.coords[0]-t.coords[0])>u.event.special.swipe.scrollSupressionThreshold)&&e.preventDefault()},s.stop=function(){i=!0,u.event.special.swipe.eventInProgress=!1,p.off(c,s.move),s.move=null},p.on(c,s.move).one(r,s.stop))},e.on(o,s.start)},teardown:function(){var e,t=u.data(this,"mobile-events");t&&(e=t.swipe,delete t.swipe,t.length--,0===t.length)&&u.removeData(this,"mobile-events"),e&&(e.start&&u(this).off(o,e.start),e.move&&p.
\ No newline at end of file
diff --git "[ORIGINAL]/canidev\\chat/event/listener.php" "[FORUM_EXT]/canidev\\chat/event/listener.php"
--- "[ORIGINAL]/canidev\\chat/event/listener.php"
+++ "[FORUM_EXT]/canidev\\chat/event/listener.php"
@@ -1,9 +1,9 @@
 <?php
 /**
  * @package cBB Chat
- * @version 1.2.7 07/03/2025
+ * @version 1.2.6 01/07/2024
  *
- * @copyright (c) 2025 CaniDev
+ * @copyright (c) 2024 CaniDev
  * @license https://creativecommons.org/licenses/by-nc/4.0/
  */
 
@@ -47,7 +47,7 @@ class listener implements EventSubscriberInterface
 	{
 		return [
 			'core.user_setup'					=> 'load_language',
-			'core.user_setup_after'				=> ['on_setup_after', -2],
+			'core.user_setup_after'				=> 'on_setup_after',
 			'core.session_kill_after'			=> 'on_user_logout',
 			'core.page_footer'					=> 'on_footer',
 			'core.delete_user_after'			=> 'on_user_delete',
diff --git "[ORIGINAL]/canidev\\chat/ext.php" "[FORUM_EXT]/canidev\\chat/ext.php"
--- "[ORIGINAL]/canidev\\chat/ext.php"
+++ "[FORUM_EXT]/canidev\\chat/ext.php"
@@ -1,9 +1,9 @@
 <?php
 /**
  * @package cBB Chat
- * @version 1.2.7 07/03/2025
+ * @version 1.2.6 01/07/2024
  *
- * @copyright (c) 2025 CaniDev
+ * @copyright (c) 2024 CaniDev
  * @license https://creativecommons.org/licenses/by-nc/4.0/
  */
 
@@ -12,7 +12,7 @@ namespace canidev\chat;
 class ext extends \phpbb\extension\base
 {
 	const REQUIRED_PHPBB	= '3.2.0';
-	const REQUIRED_CORE		= '1.1.10';
+	const REQUIRED_CORE		= '1.1.6';
 
 	/**
 	 * {@inheritDoc}
diff --git "[ORIGINAL]/canidev\\chat/language/en/acp.php" "[FORUM_EXT]/canidev\\chat/language/en/acp.php"
--- "[ORIGINAL]/canidev\\chat/language/en/acp.php"
+++ "[FORUM_EXT]/canidev\\chat/language/en/acp.php"
@@ -2,9 +2,9 @@
 /**
  * [English [En]]
  * @package cBB Chat
- * @version 1.2.7 07/03/2025
+ * @version 1.2.6 01/07/2024
  *
- * @copyright (c) 2025 CaniDev
+ * @copyright (c) 2024 CaniDev
  * @license https://creativecommons.org/licenses/by-nc/4.0/
  */
 
diff --git "[ORIGINAL]/canidev\\chat/language/en/info_acp_chat.php" "[FORUM_EXT]/canidev\\chat/language/en/info_acp_chat.php"
--- "[ORIGINAL]/canidev\\chat/language/en/info_acp_chat.php"
+++ "[FORUM_EXT]/canidev\\chat/language/en/info_acp_chat.php"
@@ -2,9 +2,9 @@
 /**
  * [English [En]]
  * @package cBB Chat
- * @version 1.2.7 07/03/2025
+ * @version 1.2.6 01/07/2024
  *
- * @copyright (c) 2025 CaniDev
+ * @copyright (c) 2024 CaniDev
  * @license https://creativecommons.org/licenses/by-nc/4.0/
  */
 
diff --git "[ORIGINAL]/canidev\\chat/language/en/info_mcp_chat.php" "[FORUM_EXT]/canidev\\chat/language/en/info_mcp_chat.php"
--- "[ORIGINAL]/canidev\\chat/language/en/info_mcp_chat.php"
+++ "[FORUM_EXT]/canidev\\chat/language/en/info_mcp_chat.php"
@@ -2,9 +2,9 @@
 /**
  * [English [En]]
  * @package cBB Chat
- * @version 1.2.7 07/03/2025
+ * @version 1.2.6 01/07/2024
  *
- * @copyright (c) 2025 CaniDev
+ * @copyright (c) 2024 CaniDev
  * @license https://creativecommons.org/licenses/by-nc/4.0/
  */
 
diff --git "[ORIGINAL]/canidev\\chat/language/en/main.php" "[FORUM_EXT]/canidev\\chat/language/en/main.php"
--- "[ORIGINAL]/canidev\\chat/language/en/main.php"
+++ "[FORUM_EXT]/canidev\\chat/language/en/main.php"
@@ -2,9 +2,9 @@
 /**
  * [English [En]]
  * @package cBB Chat
- * @version 1.2.7 07/03/2025
+ * @version 1.2.6 01/07/2024
  *
- * @copyright (c) 2025 CaniDev
+ * @copyright (c) 2024 CaniDev
  * @license https://creativecommons.org/licenses/by-nc/4.0/
  */
 
diff --git "[ORIGINAL]/canidev\\chat/language/en/permissions_chat.php" "[FORUM_EXT]/canidev\\chat/language/en/permissions_chat.php"
--- "[ORIGINAL]/canidev\\chat/language/en/permissions_chat.php"
+++ "[FORUM_EXT]/canidev\\chat/language/en/permissions_chat.php"
@@ -2,9 +2,9 @@
 /**
  * [English [En]]
  * @package cBB Chat
- * @version 1.2.7 07/03/2025
+ * @version 1.2.6 01/07/2024
  *
- * @copyright (c) 2025 CaniDev
+ * @copyright (c) 2024 CaniDev
  * @license https://creativecommons.org/licenses/by-nc/4.0/
  */
 
diff --git "[ORIGINAL]/canidev\\chat/language/es/acp.php" "[FORUM_EXT]/canidev\\chat/language/es/acp.php"
--- "[ORIGINAL]/canidev\\chat/language/es/acp.php"
+++ "[FORUM_EXT]/canidev\\chat/language/es/acp.php"
@@ -2,9 +2,9 @@
 /**
  * [Spanish [Es]]
  * @package cBB Chat
- * @version 1.2.7 07/03/2025
+ * @version 1.2.6 01/07/2024
  *
- * @copyright (c) 2025 CaniDev
+ * @copyright (c) 2024 CaniDev
  * @license https://creativecommons.org/licenses/by-nc/4.0/
  */
 
diff --git "[ORIGINAL]/canidev\\chat/language/es/info_acp_chat.php" "[FORUM_EXT]/canidev\\chat/language/es/info_acp_chat.php"
--- "[ORIGINAL]/canidev\\chat/language/es/info_acp_chat.php"
+++ "[FORUM_EXT]/canidev\\chat/language/es/info_acp_chat.php"
@@ -2,9 +2,9 @@
 /**
  * [Spanish [Es]]
  * @package cBB Chat
- * @version 1.2.7 07/03/2025
+ * @version 1.2.6 01/07/2024
  *
- * @copyright (c) 2025 CaniDev
+ * @copyright (c) 2024 CaniDev
  * @license https://creativecommons.org/licenses/by-nc/4.0/
  */
 
diff --git "[ORIGINAL]/canidev\\chat/language/es/info_mcp_chat.php" "[FORUM_EXT]/canidev\\chat/language/es/info_mcp_chat.php"
--- "[ORIGINAL]/canidev\\chat/language/es/info_mcp_chat.php"
+++ "[FORUM_EXT]/canidev\\chat/language/es/info_mcp_chat.php"
@@ -2,9 +2,9 @@
 /**
  * [Spanish [Es]]
  * @package cBB Chat
- * @version 1.2.7 07/03/2025
+ * @version 1.2.6 01/07/2024
  *
- * @copyright (c) 2025 CaniDev
+ * @copyright (c) 2024 CaniDev
  * @license https://creativecommons.org/licenses/by-nc/4.0/
  */
 
diff --git "[ORIGINAL]/canidev\\chat/language/es/main.php" "[FORUM_EXT]/canidev\\chat/language/es/main.php"
--- "[ORIGINAL]/canidev\\chat/language/es/main.php"
+++ "[FORUM_EXT]/canidev\\chat/language/es/main.php"
@@ -2,9 +2,9 @@
 /**
  * [Spanish [Es]]
  * @package cBB Chat
- * @version 1.2.7 07/03/2025
+ * @version 1.2.6 01/07/2024
  *
- * @copyright (c) 2025 CaniDev
+ * @copyright (c) 2024 CaniDev
  * @license https://creativecommons.org/licenses/by-nc/4.0/
  */
 
diff --git "[ORIGINAL]/canidev\\chat/language/es/permissions_chat.php" "[FORUM_EXT]/canidev\\chat/language/es/permissions_chat.php"
--- "[ORIGINAL]/canidev\\chat/language/es/permissions_chat.php"
+++ "[FORUM_EXT]/canidev\\chat/language/es/permissions_chat.php"
@@ -2,9 +2,9 @@
 /**
  * [Spanish [Es]]
  * @package cBB Chat
- * @version 1.2.7 07/03/2025
+ * @version 1.2.6 01/07/2024
  *
- * @copyright (c) 2025 CaniDev
+ * @copyright (c) 2024 CaniDev
  * @license https://creativecommons.org/licenses/by-nc/4.0/
  */
 
diff --git "[ORIGINAL]/canidev\\chat/libraries/action_manager.php" "[FORUM_EXT]/canidev\\chat/libraries/action_manager.php"
--- "[ORIGINAL]/canidev\\chat/libraries/action_manager.php"
+++ "[FORUM_EXT]/canidev\\chat/libraries/action_manager.php"
@@ -1,9 +1,9 @@
 <?php
 /**
  * @package cBB Chat
- * @version 1.2.7 07/03/2025
+ * @version 1.2.6 01/07/2024
  *
- * @copyright (c) 2025 CaniDev
+ * @copyright (c) 2024 CaniDev
  * @license https://creativecommons.org/licenses/by-nc/4.0/
  */
 
diff --git "[ORIGINAL]/canidev\\chat/libraries/chat.php" "[FORUM_EXT]/canidev\\chat/libraries/chat.php"
--- "[ORIGINAL]/canidev\\chat/libraries/chat.php"
+++ "[FORUM_EXT]/canidev\\chat/libraries/chat.php"
@@ -1,9 +1,9 @@
 <?php
 /**
  * @package cBB Chat
- * @version 1.2.7 07/03/2025
+ * @version 1.2.6 01/07/2024
  *
- * @copyright (c) 2025 CaniDev
+ * @copyright (c) 2024 CaniDev
  * @license https://creativecommons.org/licenses/by-nc/4.0/
  */
 
diff --git "[ORIGINAL]/canidev\\chat/libraries/constants.php" "[FORUM_EXT]/canidev\\chat/libraries/constants.php"
--- "[ORIGINAL]/canidev\\chat/libraries/constants.php"
+++ "[FORUM_EXT]/canidev\\chat/libraries/constants.php"
@@ -1,9 +1,9 @@
 <?php
 /**
  * @package cBB Chat
- * @version 1.2.7 07/03/2025
+ * @version 1.2.6 01/07/2024
  *
- * @copyright (c) 2025 CaniDev
+ * @copyright (c) 2024 CaniDev
  * @license https://creativecommons.org/licenses/by-nc/4.0/
  */
 
diff --git "[ORIGINAL]/canidev\\chat/mcp/main_info.php" "[FORUM_EXT]/canidev\\chat/mcp/main_info.php"
--- "[ORIGINAL]/canidev\\chat/mcp/main_info.php"
+++ "[FORUM_EXT]/canidev\\chat/mcp/main_info.php"
@@ -1,9 +1,9 @@
 <?php
 /**
  * @package cBB Chat
- * @version 1.2.7 07/03/2025
+ * @version 1.2.6 01/07/2024
  *
- * @copyright (c) 2025 CaniDev
+ * @copyright (c) 2024 CaniDev
  * @license https://creativecommons.org/licenses/by-nc/4.0/
  */
 
diff --git "[ORIGINAL]/canidev\\chat/mcp/main_module.php" "[FORUM_EXT]/canidev\\chat/mcp/main_module.php"
--- "[ORIGINAL]/canidev\\chat/mcp/main_module.php"
+++ "[FORUM_EXT]/canidev\\chat/mcp/main_module.php"
@@ -1,9 +1,9 @@
 <?php
 /**
  * @package cBB Chat
- * @version 1.2.7 07/03/2025
+ * @version 1.2.6 01/07/2024
  *
- * @copyright (c) 2025 CaniDev
+ * @copyright (c) 2024 CaniDev
  * @license https://creativecommons.org/licenses/by-nc/4.0/
  */
 
diff --git "[ORIGINAL]/canidev\\chat/migrations/v110.php" "[FORUM_EXT]/canidev\\chat/migrations/v110.php"
--- "[ORIGINAL]/canidev\\chat/migrations/v110.php"
+++ "[FORUM_EXT]/canidev\\chat/migrations/v110.php"
@@ -14,7 +14,7 @@ class v110 extends \phpbb\db\migration\migration
 {
 	public function effectively_installed()
 	{
-		return $this->db_tools->sql_table_exists($this->table_prefix . 'chat_messages');
+		return isset($this->config['chat_version']) && version_compare($this->config['chat_version'], '1.1.0', '>=');
 	}
 
 	public function update_schema()
diff --git "[ORIGINAL]/canidev\\chat/migrations/v111.php" "[FORUM_EXT]/canidev\\chat/migrations/v111.php"
--- "[ORIGINAL]/canidev\\chat/migrations/v111.php"
+++ "[FORUM_EXT]/canidev\\chat/migrations/v111.php"
@@ -17,8 +17,7 @@ class v111 extends \phpbb\db\migration\migration
 	 */
 	public function effectively_installed()
 	{
-		// "chat_version" is deprecated, migration ignored
-		return true;
+		return isset($this->config['chat_version']) && version_compare($this->config['chat_version'], '1.1.1', '>=');
 	}
 
 	/**
diff --git "[ORIGINAL]/canidev\\chat/migrations/v112.php" "[FORUM_EXT]/canidev\\chat/migrations/v112.php"
--- "[ORIGINAL]/canidev\\chat/migrations/v112.php"
+++ "[FORUM_EXT]/canidev\\chat/migrations/v112.php"
@@ -17,7 +17,7 @@ class v112 extends \phpbb\db\migration\migration
 	 */
 	public function effectively_installed()
 	{
-		return $this->db_tools->sql_column_exists($this->table_prefix . 'chat_rooms', 'room_autopurge_time');
+		return isset($this->config['chat_version']) && version_compare($this->config['chat_version'], '1.1.2', '>=');
 	}
 
 	/**
@@ -72,7 +72,7 @@ class v112 extends \phpbb\db\migration\migration
 		
 		if(!empty($this->config['chat_show_topics']))
 		{
-			$this->config->set('chat_forum_posts', 1);
+			set_config('chat_forum_posts', 1);
 		}
 	}
 }
diff --git "[ORIGINAL]/canidev\\chat/migrations/v113.php" "[FORUM_EXT]/canidev\\chat/migrations/v113.php"
--- "[ORIGINAL]/canidev\\chat/migrations/v113.php"
+++ "[FORUM_EXT]/canidev\\chat/migrations/v113.php"
@@ -14,7 +14,7 @@ class v113 extends \phpbb\db\migration\migration
 {
 	public function effectively_installed()
 	{
-		return $this->config->offsetExists('chat_purge_mark');
+		return isset($this->config['chat_version']) && version_compare($this->config['chat_version'], '1.1.3', '>=');
 	}
 
 	static public function depends_on()
diff --git "[ORIGINAL]/canidev\\chat/migrations/v120.php" "[FORUM_EXT]/canidev\\chat/migrations/v120.php"
--- "[ORIGINAL]/canidev\\chat/migrations/v120.php"
+++ "[FORUM_EXT]/canidev\\chat/migrations/v120.php"
@@ -13,7 +13,7 @@ class v120 extends \phpbb\db\migration\migration
 {
 	public function effectively_installed()
 	{
-		return $this->db_tools->sql_column_exists($this->table_prefix . 'chat_users', 'user_groups');
+		return isset($this->config['chat_version']) && version_compare($this->config['chat_version'], '1.2.0', '>=');
 	}
 
 	static public function depends_on()
diff --git "[ORIGINAL]/canidev\\chat/migrations/v121.php" "[FORUM_EXT]/canidev\\chat/migrations/v121.php"
--- "[ORIGINAL]/canidev\\chat/migrations/v121.php"
+++ "[FORUM_EXT]/canidev\\chat/migrations/v121.php"
@@ -13,7 +13,7 @@ class v121 extends \phpbb\db\migration\migration
 {
 	public function effectively_installed()
 	{
-		return $this->config->offsetExists('chat_hide_popup');
+		return isset($this->config['chat_version']) && version_compare($this->config['chat_version'], '1.2.1', '>=');
 	}
 
 	static public function depends_on()
diff --git "[ORIGINAL]/canidev\\chat/migrations/v122.php" "[FORUM_EXT]/canidev\\chat/migrations/v122.php"
--- "[ORIGINAL]/canidev\\chat/migrations/v122.php"
+++ "[FORUM_EXT]/canidev\\chat/migrations/v122.php"
@@ -13,7 +13,7 @@ class v122 extends \phpbb\db\migration\migration
 {
 	public function effectively_installed()
 	{
-		return $this->config->offsetExists('chat_row_align');
+		return isset($this->config['chat_version']) && version_compare($this->config['chat_version'], '1.2.2', '>=');
 	}
 
 	static public function depends_on()
diff --git "[ORIGINAL]/canidev\\chat/migrations/v123.php" "[FORUM_EXT]/canidev\\chat/migrations/v123.php"
--- "[ORIGINAL]/canidev\\chat/migrations/v123.php"
+++ "[FORUM_EXT]/canidev\\chat/migrations/v123.php"
@@ -16,8 +16,7 @@ class v123 extends \phpbb\db\migration\migration
 	 */
 	public function effectively_installed()
 	{
-		// "chat_version" is deprecated, migration ignored
-		return true;
+		return isset($this->config['chat_version']) && version_compare($this->config['chat_version'], '1.2.3', '>=');
 	}
 
 	/**
diff --git "[ORIGINAL]/canidev\\chat/migrations/v124.php" "[FORUM_EXT]/canidev\\chat/migrations/v124.php"
--- "[ORIGINAL]/canidev\\chat/migrations/v124.php"
+++ "[FORUM_EXT]/canidev\\chat/migrations/v124.php"
@@ -16,8 +16,7 @@ class v124 extends \phpbb\db\migration\migration
 	 */
 	public function effectively_installed()
 	{
-		// "chat_version" is deprecated, migration ignored
-		return true;
+		return isset($this->config['chat_version']) && version_compare($this->config['chat_version'], '1.2.4', '>=');
 	}
 
 	/**
diff --git "[ORIGINAL]/canidev\\chat/migrations/v125.php" "[FORUM_EXT]/canidev\\chat/migrations/v125.php"
--- "[ORIGINAL]/canidev\\chat/migrations/v125.php"
+++ "[FORUM_EXT]/canidev\\chat/migrations/v125.php"
@@ -16,8 +16,7 @@ class v125 extends \phpbb\db\migration\migration
 	 */
 	public function effectively_installed()
 	{
-		// "chat_version" is deprecated, migration ignored
-		return true;
+		return isset($this->config['chat_version']) && version_compare($this->config['chat_version'], '1.2.5', '>=');
 	}
 
 	/**
diff --git "[ORIGINAL]/canidev\\chat/migrations/v126.php" "[FORUM_EXT]/canidev\\chat/migrations/v126.php"
--- "[ORIGINAL]/canidev\\chat/migrations/v126.php"
+++ "[FORUM_EXT]/canidev\\chat/migrations/v126.php"
@@ -16,8 +16,7 @@ class v126 extends \phpbb\db\migration\migration
 	 */
 	public function effectively_installed()
 	{
-		// "chat_version" is deprecated, migration ignored
-		return true;
+		return isset($this->config['chat_version']) && version_compare($this->config['chat_version'], '1.2.6', '>=');
 	}
 
 	/**
diff --git "[ORIGINAL]/canidev\\chat/migrations/v127.php" "[ORIGINAL]/canidev\\chat/migrations/v127.php"
deleted file mode 100644
--- "[ORIGINAL]/canidev\\chat/migrations/v127.php"
+++ /dev/null
@@ -1,41 +0,0 @@
-<?php
-/**
- * @package cBB Chat
- * @version 1.2.7 07/03/2025
- *
- * @copyright (c) 2025 CaniDev
- * @license https://creativecommons.org/licenses/by-nc/4.0/
- */
-
-namespace canidev\chat\migrations;
-
-class v127 extends \phpbb\db\migration\migration
-{
-	/**
-	 * {@inheritDoc}
-	 */
-	public function effectively_installed()
-	{
-		return $this->config->offsetExists('chat_cron_lock') && !$this->config->offsetExists('chat_version');
-	}
-
-	/**
-	 * {@inheritDoc}
-	 */
-	static public function depends_on()
-	{
-		return [
-			'\canidev\chat\migrations\v126',
-		];
-	}
-
-	/**
-	 * {@inheritDoc}
-	 */
-	public function update_data()
-	{
-		return [
-			['config.remove',	['chat_version']],
-		];
-	}
-}
diff --git "[ORIGINAL]/canidev\\chat/styles/all/template/js/jchat-options.js" "[FORUM_EXT]/canidev\\chat/styles/all/template/js/jchat-options.js"
--- "[ORIGINAL]/canidev\\chat/styles/all/template/js/jchat-options.js"
+++ "[FORUM_EXT]/canidev\\chat/styles/all/template/js/jchat-options.js"
@@ -1,9 +1,9 @@
 /**
  * @package cBB Chat
  * @style: All
- * @version 1.2.7 07/03/2025
+ * @version 1.2.5 15/01/2023
  *
- * @copyright (c) 2025 CaniDev
+ * @copyright (c) 2023 CaniDev
  * @license https://creativecommons.org/licenses/by-nc/4.0/
  */
 
diff --git "[ORIGINAL]/canidev\\chat/styles/all/template/js/jchat.min.js" "[FORUM_EXT]/canidev\\chat/styles/all/template/js/jchat.min.js"
--- "[ORIGINAL]/canidev\\chat/styles/all/template/js/jchat.min.js"
+++ "[FORUM_EXT]/canidev\\chat/styles/all/template/js/jchat.min.js"
@@ -1,10 +1,10 @@
 /**
  * @package cBB Chat
- * @version 1.2.7 10/03/2025
+ * @version 1.2.6 01/07/2024
  *
- * @copyright (c) 2025 CaniDev
+ * @copyright (c) 2024 CaniDev
  * @license https://creativecommons.org/licenses/by-nc/4.0/
  */
-((p,m)=>{var e=null,o=null,f=null,i=!1,n=!1,s=!1,v=0,b=0,g=0,a=0,c=0,r=null,w=[];m.registerService("chat",{activeBox:null,connected:!1,currentRoom:!1,dom:null,method:"append",openRooms:[],tempDom:p("<div />"),editor:null,scrolling:!1,audio:new Audio,options:{autoconnect:!1,defaultRoom:0,direction:"down",floodTime:0,guestRoom:1,height:220,hidePopup:!1,imgSelector:".postimage",maxChars:0,maxRows:25,mode:"chat",noticeTimeout:2e4,page:"",soundPath:null,position:"bottom",refresh:5e3,tipTimeout:15e3},positions:{},tpl:{conversation:'<div class="ic-conversation js-conversation-<%ROOM_ID%>"></div>',sep:'<div class="sep"></div>',tab:'<li id="chat-tab-<%ROOM_ID%>"><%TITLE%> <a href="#" class="tab-close"><i class="fa fa-times-circle" aria-hidden="true"></i></a></li>',userlist:'<ul class="ic-userlist js-userlist-<%ROOM_ID%>"></ul>'},__construct:function(){var e=this;if(this.options.defaultRoom=this.options.defaultRoom||this.options.guestRoom,m.dispatchEvent("chat.beforeInit",this),"archive"===this.options.mode)this.bindRows(),p('[data-action="mark"], [data-action="unmark"]').click(function(t){t.preventDefault();var t="mark"==p(this).data("action"),e=t?"show":"hide",t=(p('input[name^="row_id_list"]').prop("checked",t),p(".chat-row .ic-row-actions").has(".row-id-list"));t[e].call(t)});else{if("up"==this.options.direction&&(this.method="prepend"),this.dom=p("#chat-body"),!(this.dom.length&&this.options.guestRoom&&this.options.height&&this.options.maxRows))return!1;void 0!==window.jchat_style_options&&(this.positions=window.jchat_style_options.positions);var t=!1;if("custom"==this.options.page&&this.positions.chat)t=this.positions.chat;else if("custom"!=this.options.page&&this.options.position){var o={};if(this.positions[this.options.page])o=this.positions[this.options.page];else{if(!this.positions.undefined)return!1;o=this.positions.undefined}t=o[this.options.position]}!1!==t&&(0==p(t[0]).length&&this.positions.undefined&&this.options.position&&(t=this.positions.undefined[this.options.position]),o=p(t[0]),t=t[1],1==(o=1<o.length?p(o[0]):o).length)&&o[t].apply(o,[this.dom]),m.colourIsDark(this.dom.find("#chat-content").css("background-color"),170)&&this.dom.addClass("dark-theme"),this.dom.objView(!0),m.browser.isMobile&&(p("head meta[name=viewport]").remove(),p("head").prepend('<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />')),p("#chat-conversation-container").on("scroll",function(){"up"==e.options.direction&&0<this.scrollTop||"down"==e.options.direction&&this.scrollTop<this.scrollHeight-this.offsetHeight?(e.scrolling=!0,p(".chat-scroll-button").objView(!0)):(e.scrolling=!1,p(".chat-scroll-button").objView(!1))}),p(".chat-scroll-button").addClass(e.options.direction).click(function(t){t.preventDefault(),e.scrollRoom()});t={autoClose:!1,minSize:180,yPosition:"top",wrapper:this.dom,onOpen:function(){e.closeActiveBox(),e.activeBox=this},onClose:function(){e.activeBox=null}},o=(this.dom.find('a[data-action="showbox"]').cbbDropdown(p.extend({},t,{adjustMethod:"resize"})),this.dom.find('a[data-action="color"]').cbbColorPicker(p.extend({},t,{realTimeUpdate:!1,onChange:function(t){e.editor.insertBBcode("color",t),e.options.hidePopup&&e.closeActiveBox()}})),this.dom.find("a[data-action]").filter(function(){return!p(this).data("cbbDropdown")}).click(p.proxy(this,"eventDispatch")),this.bindLinks(this.dom),this.collapsable("init"),1==this.cookie("mute")&&this.player("mute",!0),p("#chat-conversation-container").css("height",this.options.height),p("#chat-right-panel").css("height",this.options.height+p("#chat-tabs").height()),p("#chat-toolbar a").addClass("chat-corner-top chat-corner-bottom"),p(".ic-box").addClass("chat-corner-top"),this.initMessages(),this.status("stop"),m.dispatchEvent("chat.onInit",this),this.cookie("connectStatus"));this.options.autoconnect=1===o||0!==o&&this.options.autoconnect,this.options.autoconnect&&!this.dom.is(".collapsed")?this.connect(!0):this.disconnect()}},connect:function(t){var e=this,o=this.connected?"disconnect":"connect",i=!1;s=1==t,"connect"==o&&this.cookie("auto_away")&&(i={auto_away:this.cookie("auto_away")}),this.send(o,i,function(){s=!1,t||e.cookie("connectStatus","connect"==o?1:0,-1),"connect"==o&&(e.dom.find("#purge-button").removeClass("disabled"),e.traceCheck("start"),m.dispatchEvent("chat.onConnect",!1))})},disconnect:function(t){var e=p("#chat-main-message").clone();this.status("stop"),this.traceCheck("stop"),this.dom.find('[data-action="connect"]').removeClass("connected"),this.dom.find("#purge-button").addClass("disabled"),t&&e.html(t),p("#chat-conversation-container").append(e),e.show(),this.dom.removeAttr("data-active"),m.dispatchEvent("chat.onDisconnect",!1)},closeActiveBox:function(){null!==this.activeBox&&this.activeBox.close()},collapsable:function(t){var e=this.dom.find("#chat-content"),o=e.is(":visible"),i=this.dom.find('[data-action="minimize"]');if("custom"==this.options.page)return i.remove(),!1;switch(t){case"change":n(!o),o?(this.closeActiveBox(),e.slideUp(),o=!1,this.disconnect(),this.cookie("collapsed",1)):(e.slideDown(),this.connect(o=!0),this.cookie("collapsed","",-1));case"init":"init"==t&&(m.intval(this.cookie("collapsed"))||0)&&(n(!1),e.hide(),o=!1),this.dom.toggleClass("collapsed",!o),i.children(".fa").toggleClass("fa-minus",o).toggleClass("fa-plus",!o)}function n(t){var e=i.parent("dt");t?e.removeStyle("margin-bottom"):e.css("margin-bottom",e.css("margin-top"))}},initMessages:function(){var t=p("#chat-notices"),e=p("#chat-tips"),o=t.find(".js-message"),i=e.find(".js-message");function n(t,e,o){var i=t.data("current_text");void 0===i&&(i=-1),e[++i]||(i=0),e.objView(!1),p(e[i]).objView(!0),t.data("current_text",i),1<e.length&&o&&setTimeout(function(){n(t,e,o)},o)}0<o.length&&(t.objView(!0),n(t,o,this.options.noticeTimeout)),0<i.length&&(e.objView(!0),n(e,i,this.options.tipTimeout))},refresh:function(){var t=this.connected?"refresh":"connect";this.status("pause"),this.send(t)},submit:function(){var t=new p.Event("chat.beforeSubmit",{service:this});if(m.dispatchEvent(t),!t.isDefaultPrevented()){var t=this.editor.element.val().replace(/\[\/?[^\]]+\]/g,""),e=new Date;if(!p.trim(t)||null!=f||a&&e.getTime()-a<600)return!1;if(this.options.maxChars)if(m.intval(this.editor.element.next(".chat-editor-counter").children("span").text())<0)return!1;return a=e.getTime(),this.status("pause"),this.send("post",{lastPostTime:v,auto_away:g})}},send:function(r,t,h){var l=this,d={ajaxModule:"chat",action:r};if(this.status("loading"))return"refresh"!=r&&w.push([r,t,h]),!1;-1!=p.inArray(r,["post","connect","disconnect","refresh","pmuser","set_available","set_away","set_busy","set_hidden","set_name"])&&(d=p.extend(d,this.dom.find("form").serializeObject())),this.currentRoom&&(d.room=this.currentRoom),t&&(d=p.extend(d,t)),"refresh"==r&&(3<c&&(d.trace=!0,c=0),c++),d.rooms=this.openRooms;var u=new p.Event("chat.beforeSend",{action:r,service:this,sendData:d});m.dispatchEvent(u),u.isDefaultPrevented()||("trace"!=r&&this.status("load-start"),m.request({showLoading:!1,data:u.sendData,onComplete:function(){l.status("load-end")},onSuccess:function(t){var e=!1,o=new Date;if(l.tempDom.html(t.htmlContent),!t.success)return l.dialog("close"),t.message&&alert(t.message),!1;if(t.dialog)return l.dialog({content:t.htmlContent}),!1;switch(t.action){case"disable":return l.disconnect(),window.location.reload(),!0;case"disconnect":l.disconnect();break;case"exclude":return l.disconnect(t.message),!0;case"login":l.connected=!1,l.dialog({content:t.htmlContent,onOpen:function(e){e.ui.find("input:first").focus(),e.ui.find("input[type=text], input[type=password]").keydown(function(t){if(13==t.which&&p(this).val())return e.ui.find('[value="submit"]').click(),t.preventDefault(),t.stopPropagation(),!1})},onSubmit:function(t){if(!t.username&&!t.username_register)return p(this).find("input[name=username]").addClass("cbb-state-error").focus(),!1;t.submit=1,l.send("connect",t,function(t){t.userLogged&&(l.cookie("connectStatus",1,-1),window.location.reload())})}});break;case"update":l.dom.find("input[name=last_update]").val(t.last_time),l.dom.find("input[name=time_mark]").val(t.timeMark),l.options.floodTime=t.floodTime,t.msg_direction&&t.msg_direction!=l.options.direction&&(l.options.direction=t.msg_direction,l.method="up"==t.msg_direction?"prepend":"append",l.inverseConversations(),e=!0);var i=null!=t.auto_away?t.auto_away:g;i!=g&&(g=i)&&l.cookie("auto_away",g);break;case"banuser":l.closeRoom(t.user_key);case"unbanuser":l.dom.find(".js-user-"+t.user_key).html(l.tempDom.find(".js-userlist li:first").html()),l.bindUserlist(!1,t.user_key);break;case"close_room":l.closeRoom(t.room_key)}switch(r){case"disconnect":l.disconnect();break;case"post":l.editor.element.val(""),l.editor.plugins.chat.updateCharCounter(),l.options.floodTime&&!t.ignoreFloodTime&&(l.editor.element.val(m.lang("CHAT_FLOOD_WAIT")).prop("disabled",!0).addClass("disabled").blur(),f=setTimeout(function(){l.editor.element.val("").prop("disabled",!1).removeClass("disabled").focus(),f=null},l.options.floodTime)),v=o.getTime()/1e3;case"set_available":case"set_away":case"set_busy":case"set_hidden":case"set_name":case"connect":l.connected||p("#chat-conversation-container").html(""),"connect"!=r&&"post"!=r||(l.connected=!0),"connect"==r&&l.dom.find('[data-action="connect"]').addClass("connected"),g=0,l.cookie("auto_away",0,-1);case"move":if("move"==r){if(!u.sendData.submit)break;p("#chat-conversation-container > div").html("")}case"pmuser":case"refresh":l.connected&&(a=l.appendConversationData(r),l.tempDom.html(""),l.currentRoom=l.currentRoom||l.options.defaultRoom,p("#chat-tab-"+l.currentRoom).length||(l.currentRoom=l.options.guestRoom),p("#chat-tab-"+l.currentRoom).hasClass("active")||l.openRoom(l.currentRoom),(a||e)&&(l.bindRows(),a&&"refresh"==r&&l.player("play","add"),l.scrolling||l.scrollRoom(),p("#chat-conversation-container .ic-row-text img").one("load",function(){this.loaded=!0,l.scrolling||l.scrollRoom()}).each(function(){this.complete&&!this.loaded&&p(this).trigger("load")})),l.doQueue(t.queueActions),l.status("resume"),b=o.getTime(),l.cookie("lastcheck",parseInt(b/1e3),365));break;case"quote":l.editor.insertText(t.text);break;case"history":var n=l.dom.find(".js-conversation-"+l.currentRoom),s=n.outerHeight(),a=l.appendConversationData(r);l.tempDom.html(""),a&&(n.data("ignoreLimit",!0),"up"!=l.options.direction&&(a=n.outerHeight(),l.scrollRoom(a-s)),l.bindRows())}var c=new p.Event("chat.afterSend",{action:r,service:this,sendData:d,response:t});m.dispatchEvent(c),"function"!=typeof h||c.isDefaultPrevented()||h.call(!1,t),w.length&&l.send.apply(l,w.shift())}}))},traceCheck:function(t){let e=this;switch(t){case"start":null!==o&&e.traceCheck("stop"),o=setInterval(function(){var t=new Date;b&&t.getTime()>b+1.5*e.options.refresh&&(e.send("trace"),b=t.getTime())},e.options.refresh);break;case"stop":clearInterval(o),o=null}},closeRoom:function(t){if(null==t||t==this.options.guestRoom)return!1;var e;-1!=(e=p.inArray(t,this.openRooms))&&(p("#chat-tab-"+t+", .js-conversation-"+t+", .js-userlist-"+t).remove(),m.dispatchEvent("chat.onCloseRoom",{instance:this,room:t}),this.openRooms.splice(e,1),e=this.currentRoom==t?this.options.guestRoom:this.currentRoom,this.openRoom(e,!0))},openRoom:function(t,e){var o=this.currentRoom,i=p("#chat-tab-"+t);if(-1!=p.inArray(o,self.openRooms)&&!0!==e)return!1;o&&(p(".js-conversation-"+o+", .js-userlist-"+o).hide(),p("#chat-tabs li").removeClass("active before-active after-active"),p("#chat-tabs .tab-close").removeClass("active")),this.currentRoom=t,p(".js-conversation-"+t+", .js-userlist-"+t).show(),i.addClass("active").removeClass("new-msg"),i.prev("li").addClass("before-active"),i.next("li").addClass("after-active"),i.find(".tab-close").addClass("active"),this.dom.attr("data-active",t);var e=p(".js-conversation-"+t).is(".js-public-room")?"removeClass":"addClass",o=this.dom.find("#purge-button"),i=(o[e].call(o,"disabled"),new p.Event("chat.onOpenRoom",{instance:this,room:t,backgroundAction:s}));m.dispatchEvent(i),i.isDefaultPrevented()||(this.scrolling=!1,this.scrollRoom(),s)||m.browser.isMobile||!this.editor||(e=this.editor.element.offset().top-p(window).scrollTop())<p(window).height()&&0<=e&&this.editor.element.focus()},bindLinks:function(t){window.self!=window.top&&t.find("a[href]:not([data-action],[data-code],.ic-row-action-launcher)").off("click.frame").on("click.frame",function(t){t.preventDefault(),window.top.location.href=this.href})},bindTabs:function(){var o=this;p("#chat-tabs").find("li, .tab-close").off(),p("#chat-tabs li").click(function(t){var e=parseInt(p(this).attr("id").replace("chat-tab-",""));o.openRoom(e),t.preventDefault()}),p("#chat-tabs li .tab-close").click(function(t){var e=p(this).parent(),e=parseInt(e.attr("id").replace("chat-tab-",""));o.closeRoom(e),t.preventDefault()}),m.dispatchEvent("chat.onBindTabs",this)},bindRows:function(){var o=this,t=p("#chat-conversation-container .chat-row");t.off().find(".ic-row-action-launcher").cbbDropdown({onCreate:function(){var e=this;e.rowID=e.launcher.closest(".chat-row").data("id"),e.container.find("[data-action]").off("click").click(function(t){t.preventDefault(),t.msgID=e.rowID,o.eventDispatch(t),e.close()})},onOpen:function(){this.launcher.closest(".chat-row").addClass("active"),o.status("pause",!0)},onClose:function(){this.launcher.closest(".chat-row").removeClass("active").children(".chat-row-content").mouseleave(),o.status("resume")}}),m.browser.isMobile?t.find(".ic-row-actions").show():t.filter(":not(.chat-format-bubble)").children(".chat-row-content").hover(function(){p(this).children(".ic-row-actions").show()},function(){p(this).closest(".chat-row").is(".active")||p(this).children(".ic-row-actions").each(function(){if(0<p(this).children(".row-id-list:checked").length)return!0;p(this).hide()})}),p("#chat-conversation-container").find(".history-row a, .chat-quickmention").off("click").click(p.proxy(this,"eventDispatch")),t.cbbImageGallery({imageSelector:"img:not(.emoji, .smilies)"}),o.bindLinks(t),m.dispatchEvent("chat.onBindRows",this)},bindUserlist:function(t,e){var t=e?".js-user-"+e:t?".js-userlist-"+t:".ic-userlist",e=e?p(t):p(t).children("li"),o=this;e.find("a").off("click").click(p.proxy(o,"eventDispatch")),e.children("a").cbbDropdown({dispatchEvent:"contextmenu",showPointer:!1,onCreate:function(){this.container.find("a").click(p.proxy(this,"close"))},onOpen:function(){o.currentMenu=this,o.status("pause",!0)},onClose:function(){o.currentMenu=null,o.status("resume")}}),m.dispatchEvent("chat.onBindUserlist",this)},eventDispatch:function(t){t.preventDefault();var e=p(t.currentTarget),o=e.data("action"),i=t.msgID,n=this;if(e.is(".disabled"))return!1;!i&&e.closest(".chat-row").length&&(i=e.closest(".chat-row").data("id"));t=new p.Event("chat.beforeEventDispatch",{originalEvent:t,action:o,service:this,msgID:i});if(m.dispatchEvent(t),!t.isDefaultPrevented()){switch(o){case"connect":case"refresh":this.closeActiveBox();case"submit":this[o].call(this);break;case"clear":n.send("clear",!1,function(){p(".js-conversation-"+n.currentRoom).html("")});break;case"rules":n.send("rules",!1,function(t){n.dialog({content:t.htmlContent,height:120,width:350})});break;case"sound":this.closeActiveBox(),this.player("mute");break;case"edit":n.send("edit",{id:i},function(t){n.dialog({autoFocus:!0,content:t.htmlContent,width:610,onSubmit:function(t){if((t=p.extend(t,{id:i,submit:1}),n.options.maxChars)&&m.intval(p(this).find(".chat-editor-counter > span").text())<0)return!1;n.send("edit",t,function(t){t.text&&p("#chat-row-"+i).find(".ic-row-text").html(t.text)})}})});break;case"delete":this.send("delete",{id:i},function(){n.player("play","delete"),p("#chat-row-"+i).fadeOut()});break;case"quote":this.send(o,{id:i});break;case"whois":n.send("whois",{id:i},function(t){n.dialog({content:t.htmlContent,width:450,height:150})});break;case"user":window.open(e.attr("href"));break;case"banuser":var s=e.data("user-key");this.send("banuser",{uk:s},function(t){n.dialog({content:t.htmlContent,onOpen:function(e){p("#ban-period").change(function(){var t="0"==p(this).val();e.ui.find("dl:has(#ban-date)").objView(t),t||e.ui.find("#ban-date").val("").removeClass("cbb-state-error")})},onSubmit:function(t){if("0"==t.period&&null==t.date.match(/\d{2}\/\d{2}\/\d{4} \d{2}\:\d{2}\:\d{2}/))return p(this).find("#ban-date").addClass("cbb-state-error").focus(),!1;t=p.extend(t,{uk:s,submit:1}),n.send("banuser",t)}})});break;case"quickmention":var a=(c=e.next(".ic-row-username:first")).children("a");case"mentionuser":(a="mentionuser"==o?(c=this.currentMenu.launcher).children("span"):a).length?n.editor.insertBBcode("color",{defaultAttr:m.rgbToHex(a.css("color")),inner:"[b]@"+a.text()+"[/b]"},FLAG_ADDWHITESPACES|FLAG_CURSORTOEND):n.editor.insertBBcode("b",{inner:"@"+c.text()},FLAG_ADDWHITESPACES|FLAG_CURSORTOEND);break;case"pmuser":s=e.data("user-key");-1==p.inArray(s,this.openRooms)?this.send("pmuser",{uk:s},function(){n.openRoom(s)}):this.openRoom(s);break;case"unbanuser":case"set_available":case"set_away":case"set_busy":case"set_hidden":this.send(o,{uk:e.data("user-key")});break;case"set_name":s=e.data("user-key");this.send("set_name",{uk:s},function(t){n.dialog({autoFocus:!0,content:t.htmlContent,onSubmit:function(t){if(!(t=p.extend(t,{uk:s,submit:1})).username)return p(this).find("input[name=username]").addClass("cbb-state-error").focus(),!1;n.send("set_name",t)}})});break;case"move":this.send("move",{id:i},function(t){n.dialog({content:t.htmlContent,onSubmit:function(t){t=p.extend(t,{id:i,submit:1,last_update:0}),n.send("move",t,function(){})}})});break;case"minimize":this.collapsable("change");break;case"history":var a="up"==this.options.direction?"prev":"next",c=e.parent()[a].call(e.parent(),".chat-row");this.send("history",{last_update:c.data("time")});break;default:window.open(e.attr("href"))}p(this).blur()}},player:function(t,e){if(null===this.options.soundPath)return!1;switch(t){case"mute":n&&!0!==e?!n&&!1!==e||(n=!1,p('a[data-action="sound"]').removeClass("muted"),this.cookie("mute","")):(n=!0,p('a[data-action="sound"]').addClass("muted"),this.cookie("mute",1,180));break;case"play":n||(this.audio.src=this.options.soundPath+e+".mp3",this.audio.play())}},dialog:function(e){var t,o=this;"string"==typeof e?null!==r&&(r.cbbDialog(e),"close"==e)&&(r=null):(t={autoClean:!1,autoFocus:e.autoFocus||!1,destroyOnClose:!0,movable:!1,width:e.width||"auto",height:e.height||"auto",parent:"archive"==this.options.mode?"body":p("#chat-content").is("ul")?"#chat-content > li":"#chat-content",onOpen:function(t){o.status("pause",!0),o.closeActiveBox(),o.bindLinks(p(this)),e.onOpen&&e.onOpen.call(this,t)},onClose:function(){o.status("resume")},onSubmit:e.onSubmit},r=p(e.content).cbbDialog(t))},scrollRoom:function(t){var e=p("#chat-conversation-container")[0];t?e.scrollTop=t:(e.scrollTop="up"==this.options.direction?0:e.scrollHeight,p(".chat-scroll-button").objView(!1))},status:function(t){switch(t){case"load-start":i=!0,p(".ic-loading").show();break;case"load-end":i=!1,p(".ic-loading").hide();break;case"loading":return i;case"stop":p("#chat-conversation-container, #chat-right-panel, #chat-tabs").html(""),this.openRooms=[],this.connected=!1,this.dom.find("input[name=last_update]").val(0),this.dom.find("input[name=time_mark]").val(0);case"pause":clearTimeout(e),e=null,this.status("load-end");break;case"resume":this.connected&&null===e&&(e=setTimeout(p.proxy(this,"refresh"),this.options.refresh))}},cookie:function(t,e,o){t="chat_"+t;if(null==e)return m.cookie.get(t);m.cookie.set(t,e,o)},inverseConversations:function(){p("#chat-conversation-container").children(".ic-conversation").each(function(){var t=p(this).children(".chat-row, .history-row");if(t.length){p(this).html("");for(var e=t.length-1;-1<e;e--)p(this).append(t[e])}})},appendConversationData:function(c){var r=this,h=!1,t=new Date,l=this.cookie("lastcheck")||t.getTime()/1e3;return this.tempDom.find(".room").each(function(){var t=parseInt(p(this).attr("id").replace("room-","")),e=p.trim(p(this).children(".js-conversation").html()),o=p.trim(p(this).children(".js-userlist").html());if(-1==p.inArray(t,r.openRooms)){if("history"==c)return!0;r.openRooms.push(t);var i={ROOM_ID:t,TITLE:p(this).attr("title")};p("#chat-right-panel").append(r.getTpl("userlist",i)),p("#chat-conversation-container").append(r.getTpl("conversation",i)),p("#chat-tabs").append(r.getTpl("tab",i)),p(this).is(".js-public-room")&&(p(".js-conversation-"+t).addClass("js-public-room"),p("#chat-tab-"+t).find(".tab-close").remove()),r.bindTabs()}var n=p(".js-conversation-"+t);if("history"==c)n.children(".history-row").replaceWith(e),h=!!e;else if(e){n[r.method].apply(n,[e]);var s=n.children(".chat-row").length,a="up"==r.options.direction?":last":":first";if(!n.data("ignoreLimit"))for(;s>r.options.maxRows;)n.children(".chat-row"+a).remove(),s--;i="up"==r.options.direction?":first":":last",e=parseInt(n.children(".chat-row"+i).data("time"));t!=r.currentRoom&&("refresh"==c||e&&l<e)&&p("#chat-tab-"+t).addClass("new-msg"),h=!0}o&&(p(".js-userlist-"+t).html(o),r.bindUserlist(t))}),h},doQueue:function(t){if(!t||!t.length)return!1;let e=!1;for(var o of t)switch(o.action){case"delete":p("#chat-row-"+o.msgID).fadeOut();break;case"edit":p("#chat-row-"+o.msgID).find(".ic-row-text").html(o.msgText);break;case"connect":e||(e=!0,this.player("play","connect"));break;case"move":var i=this.dom.find("#chat-row-"+o.msgID),n=m.intval(i.attr("data-time")),s=this.dom.find(".js-conversation-"+o.destKey);if((a=s.children(".chat-row")).length)for(var a=a.get().reverse(),c=0;c<a.length;c++){if(m.intval(p(a[c]).attr("data-time"))<n){p(a[c]).after(i);break}if(c==a.length-1){s.prepend(i);break}}else s.append(i);this.scrolling||this.scrollRoom()}},getTpl:function(t,e){return m.template.parse(this.tpl[t],e)}},!1)})(jQuery,cbbCore),((o,i)=>{cbbEditorWrapper.plugins.chat={init:function(){this.chat=i.getService("chat"),this.chat.editor||(this.chat.editor=this.editor),this.bindInput(),this.updateCharCounter()},bindInput:function(){var t,e=this;e.editor.element.closest("#chat-message").length&&e.editor.element.on("keyup keydown",function(t){if(13==t.which)return"keyup"==t.type&&1!=t.ctrlKey?e.chat.submit():"keydown"==t.type&&1==t.ctrlKey&&e.editor.insertText("\n"),t.preventDefault(),t.stopPropagation(),!1}),e.chat.options.maxChars&&(t=o('<div class="chat-editor-counter"><span></span><svg height="20" width="20"><circle class="mask" cx="50%" cy="50%" r="8" fill="none" stroke-width="1"></circle><circle cx="50%" cy="50%" r="8" fill="none" stroke-width="2"></circle></svg></div>'),e.charCounter={radial:t.find("circle:not(.mask)"),label:t.children("span")},e.charCounter.radial.css({"stroke-dashoffset":50,"stroke-dasharray":50}),e.editor.element.on("input",o.proxy(e,"updateCharCounter")).after(t)),i.dispatchEvent("chat.onBindInput",this)},updateCharCounter:function(){var t,e,o,i;void 0!==this.charCounter&&(e=50-50*(t=this.editor.element.val()).length/this.chat.options.maxChars,o="danger",i="",this.charCounter.radial.css("stroke-dashoffset",Math.max(0,e)),5<e?o="safe":0<=e&&(o="warn"),this.charCounter.radial.get(0).setAttribute("class",o),e<0&&(i=this.chat.options.maxChars-t.length),this.charCounter.label.text(i))},eventCommandExec:function(){this.chat.options.hidePopup&&this.chat.closeActiveBox()},eventTextchange:function(){this.updateCharCounter()}}})(jQuery,cbbCore);
+!function(p,m){"use strict";var e=null,o=null,f=null,i=!1,n=!1,s=!1,v=0,b=0,g=0,a=0,c=0,r=null,w=[];m.registerService("chat",{activeBox:null,connected:!1,currentRoom:!1,dom:null,method:"append",openRooms:[],tempDom:p("<div />"),editor:null,scrolling:!1,audio:new Audio,options:{autoconnect:!1,defaultRoom:0,direction:"down",floodTime:0,guestRoom:1,height:220,hidePopup:!1,imgSelector:".postimage",maxChars:0,maxRows:25,mode:"chat",noticeTimeout:2e4,page:"",soundPath:null,position:"bottom",refresh:5e3,tipTimeout:15e3},positions:{},tpl:{conversation:'<div class="ic-conversation js-conversation-<%ROOM_ID%>"></div>',sep:'<div class="sep"></div>',tab:'<li id="chat-tab-<%ROOM_ID%>"><%TITLE%> <a href="#" class="tab-close"><i class="fa fa-times-circle" aria-hidden="true"></i></a></li>',userlist:'<ul class="ic-userlist js-userlist-<%ROOM_ID%>"></ul>'},__construct:function(){var e=this;if(this.options.defaultRoom=this.options.defaultRoom||this.options.guestRoom,m.dispatchEvent("chat.beforeInit",this),"archive"===this.options.mode)this.bindRows(),p('[data-action="mark"], [data-action="unmark"]').click(function(t){t.preventDefault();var t="mark"==p(this).data("action"),e=t?"show":"hide",t=(p('input[name^="row_id_list"]').prop("checked",t),p(".chat-row .ic-row-actions").has(".row-id-list"));t[e].call(t)});else{if("up"==this.options.direction&&(this.method="prepend"),this.dom=p("#chat-body"),!(this.dom.length&&this.options.guestRoom&&this.options.height&&this.options.maxRows))return!1;void 0!==window.jchat_style_options&&(this.positions=window.jchat_style_options.positions);var t=!1;if("custom"==this.options.page&&this.positions.chat)t=this.positions.chat;else if("custom"!=this.options.page&&this.options.position){var o={};if(this.positions[this.options.page])o=this.positions[this.options.page];else{if(!this.positions.undefined)return!1;o=this.positions.undefined}t=o[this.options.position]}!1!==t&&(0==p(t[0]).length&&this.positions.undefined&&this.options.position&&(t=this.positions.undefined[this.options.position]),o=p(t[0]),t=t[1],1==(o=1<o.length?p(o[0]):o).length)&&o[t].apply(o,[this.dom]),m.colourIsDark(this.dom.find("#chat-content").css("background-color"),170)&&this.dom.addClass("dark-theme"),this.dom.objView(!0),m.browser.isMobile&&(p("head meta[name=viewport]").remove(),p("head").prepend('<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />')),p("#chat-conversation-container").on("scroll",function(){"up"==e.options.direction&&0<this.scrollTop||"down"==e.options.direction&&this.scrollTop<this.scrollHeight-this.offsetHeight?(e.scrolling=!0,p(".chat-scroll-button").objView(!0)):(e.scrolling=!1,p(".chat-scroll-button").objView(!1))}),p(".chat-scroll-button").addClass(e.options.direction).click(function(t){t.preventDefault(),e.scrollRoom()});t={autoClose:!1,minSize:180,yPosition:"top",wrapper:this.dom,onOpen:function(){e.closeActiveBox(),e.activeBox=this},onClose:function(){e.activeBox=null}},o=(this.dom.find('a[data-action="showbox"]').cbbDropdown(p.extend({},t,{adjustMethod:"resize"})),this.dom.find('a[data-action="color"]').cbbColorPicker(p.extend({},t,{realTimeUpdate:!1,onChange:function(t){e.editor.insertBBcode("color",t),e.options.hidePopup&&e.closeActiveBox()}})),this.dom.find("a[data-action]").filter(function(){return!p(this).data("cbbDropdown")}).click(p.proxy(this,"eventDispatch")),this.bindLinks(this.dom),this.collapsable("init"),1==this.cookie("mute")&&this.player("mute",!0),p("#chat-conversation-container").css("height",this.options.height),p("#chat-right-panel").css("height",this.options.height+p("#chat-tabs").height()),p("#chat-toolbar a").addClass("chat-corner-top chat-corner-bottom"),p(".ic-box").addClass("chat-corner-top"),this.initMessages(),this.status("stop"),m.dispatchEvent("chat.onInit",this),this.cookie("connectStatus"));this.options.autoconnect=1===o||0!==o&&this.options.autoconnect,this.options.autoconnect&&!this.dom.is(".collapsed")?this.connect(!0):this.disconnect()}},connect:function(t){var e=this,o=this.connected?"disconnect":"connect",i=!1;s=1==t,"connect"==o&&this.cookie("auto_away")&&(i={auto_away:this.cookie("auto_away")}),this.send(o,i,function(){s=!1,t||e.cookie("connectStatus","connect"==o?1:0,-1),"connect"==o&&(e.dom.find("#purge-button").removeClass("disabled"),e.traceCheck("start"),m.dispatchEvent("chat.onConnect",!1))})},disconnect:function(t){var e=p("#chat-main-message").clone();this.status("stop"),this.traceCheck("stop"),this.dom.find('[data-action="connect"]').removeClass("connected"),this.dom.find("#purge-button").addClass("disabled"),t&&e.html(t),p("#chat-conversation-container").append(e),e.show(),this.dom.removeAttr("data-active"),m.dispatchEvent("chat.onDisconnect",!1)},closeActiveBox:function(){null!==this.activeBox&&this.activeBox.close()},collapsable:function(t){var e=this.dom.find("#chat-content"),o=e.is(":visible"),i=this.dom.find('[data-action="minimize"]');if("custom"==this.options.page)return i.remove(),!1;switch(t){case"change":n(!o),o?(this.closeActiveBox(),e.slideUp(),o=!1,this.disconnect(),this.cookie("collapsed",1)):(e.slideDown(),this.connect(o=!0),this.cookie("collapsed","",-1));case"init":"init"==t&&(m.intval(this.cookie("collapsed"))||0)&&(n(!1),e.hide(),o=!1),this.dom.toggleClass("collapsed",!o),i.children(".fa").toggleClass("fa-minus",o).toggleClass("fa-plus",!o)}function n(t){var e=i.parent("dt");t?e.removeStyle("margin-bottom"):e.css("margin-bottom",e.css("margin-top"))}},initMessages:function(){var t=p("#chat-notices"),e=p("#chat-tips"),o=t.find(".js-message"),i=e.find(".js-message");function n(t,e,o){var i=t.data("current_text");void 0===i&&(i=-1),e[++i]||(i=0),e.objView(!1),p(e[i]).objView(!0),t.data("current_text",i),1<e.length&&o&&setTimeout(function(){n(t,e,o)},o)}0<o.length&&(t.objView(!0),n(t,o,this.options.noticeTimeout)),0<i.length&&(e.objView(!0),n(e,i,this.options.tipTimeout))},refresh:function(){var t=this.connected?"refresh":"connect";this.status("pause"),this.send(t)},submit:function(){var t=new p.Event("chat.beforeSubmit",{service:this});if(m.dispatchEvent(t),!t.isDefaultPrevented()){var t=this.editor.element.val().replace(/\[\/?[^\]]+\]/g,""),e=new Date;if(!p.trim(t)||null!=f||a&&e.getTime()-a<600)return!1;if(this.options.maxChars)if(m.intval(this.editor.element.next(".chat-editor-counter").children("span").text())<0)return!1;return a=e.getTime(),this.status("pause"),this.send("post",{lastPostTime:v,auto_away:g})}},send:function(r,t,h){var l=this,d={ajaxModule:"chat",action:r};if(this.status("loading"))return"refresh"!=r&&w.push([r,t,h]),!1;-1!=p.inArray(r,["post","connect","disconnect","refresh","pmuser","set_available","set_away","set_busy","set_hidden","set_name"])&&(d=p.extend(d,this.dom.find("form").serializeObject())),this.currentRoom&&(d.room=this.currentRoom),t&&(d=p.extend(d,t)),"refresh"==r&&(3<c&&(d.trace=!0,c=0),c++),d.rooms=this.openRooms;var u=new p.Event("chat.beforeSend",{action:r,service:this,sendData:d});m.dispatchEvent(u),u.isDefaultPrevented()||("trace"!=r&&this.status("load-start"),m.request({showLoading:!1,data:u.sendData,onComplete:function(){l.status("load-end")},onSuccess:function(t){var e=!1,o=new Date;if(l.tempDom.html(t.htmlContent),!t.success)return l.dialog("close"),t.message&&alert(t.message),!1;if(t.dialog)return l.dialog({content:t.htmlContent}),!1;switch(t.action){case"disable":return l.disconnect(),window.location.reload(),!0;case"disconnect":l.disconnect();break;case"exclude":return l.disconnect(t.message),!0;case"login":l.connected=!1,l.dialog({content:t.htmlContent,onOpen:function(e){e.ui.find("input:first").focus(),e.ui.find("input[type=text], input[type=password]").keydown(function(t){if(13==t.which&&p(this).val())return e.ui.find('[value="submit"]').click(),t.preventDefault(),t.stopPropagation(),!1})},onSubmit:function(t){if(!t.username&&!t.username_register)return p(this).find("input[name=username]").addClass("cbb-state-error").focus(),!1;t.submit=1,l.send("connect",t,function(t){t.userLogged&&(l.cookie("connectStatus",1,-1),window.location.reload())})}});break;case"update":l.dom.find("input[name=last_update]").val(t.last_time),l.dom.find("input[name=time_mark]").val(t.timeMark),l.options.floodTime=t.floodTime,t.msg_direction&&t.msg_direction!=l.options.direction&&(l.options.direction=t.msg_direction,l.method="up"==t.msg_direction?"prepend":"append",l.inverseConversations(),e=!0);var i=null!=t.auto_away?t.auto_away:g;i!=g&&(g=i)&&l.cookie("auto_away",g);break;case"banuser":l.closeRoom(t.user_key);case"unbanuser":l.dom.find(".js-user-"+t.user_key).html(l.tempDom.find(".js-userlist li:first").html()),l.bindUserlist(!1,t.user_key);break;case"close_room":l.closeRoom(t.room_key)}switch(r){case"disconnect":l.disconnect();break;case"post":l.editor.element.val(""),l.editor.plugins.chat.updateCharCounter(),l.options.floodTime&&!t.ignoreFloodTime&&(l.editor.element.val(m.lang("CHAT_FLOOD_WAIT")).prop("disabled",!0).addClass("disabled").blur(),f=setTimeout(function(){l.editor.element.val("").prop("disabled",!1).removeClass("disabled").focus(),f=null},l.options.floodTime)),v=o.getTime()/1e3;case"set_available":case"set_away":case"set_busy":case"set_hidden":case"set_name":case"connect":l.connected||p("#chat-conversation-container").html(""),"connect"!=r&&"post"!=r||(l.connected=!0),"connect"==r&&l.dom.find('[data-action="connect"]').addClass("connected"),g=0,l.cookie("auto_away",0,-1);case"move":if("move"==r){if(!u.sendData.submit)break;p("#chat-conversation-container > div").html("")}case"pmuser":case"refresh":l.connected&&(a=l.appendConversationData(r),l.tempDom.html(""),l.currentRoom=l.currentRoom||l.options.defaultRoom,p("#chat-tab-"+l.currentRoom).length||(l.currentRoom=l.options.guestRoom),p("#chat-tab-"+l.currentRoom).hasClass("active")||l.openRoom(l.currentRoom),(a||e)&&(l.bindRows(),a&&"refresh"==r&&l.player("play","add"),l.scrolling||l.scrollRoom(),p("#chat-conversation-container .ic-row-text img").one("load",function(){this.loaded=!0,l.scrolling||l.scrollRoom()}).each(function(){this.complete&&!this.loaded&&p(this).trigger("load")})),l.doQueue(t.queueActions),l.status("resume"),b=o.getTime(),l.cookie("lastcheck",parseInt(b/1e3),365));break;case"quote":l.editor.insertText(t.text);break;case"history":var n=l.dom.find(".js-conversation-"+l.currentRoom),s=n.outerHeight(),a=l.appendConversationData(r);l.tempDom.html(""),a&&(n.data("ignoreLimit",!0),"up"!=l.options.direction&&(a=n.outerHeight(),l.scrollRoom(a-s)),l.bindRows())}var c=new p.Event("chat.afterSend",{action:r,service:this,sendData:d,response:t});m.dispatchEvent(c),"function"!=typeof h||c.isDefaultPrevented()||h.call(!1,t),w.length&&l.send.apply(l,w.shift())}}))},traceCheck:function(t){let e=this;switch(t){case"start":null!==o&&e.traceCheck("stop"),o=setInterval(function(){var t=new Date;b&&t.getTime()>b+1.5*e.options.refresh&&(e.send("trace"),b=t.getTime())},e.options.refresh);break;case"stop":clearInterval(o),o=null}},closeRoom:function(t){if(null==t||t==this.options.guestRoom)return!1;var e;-1!=(e=p.inArray(t,this.openRooms))&&(p("#chat-tab-"+t+", .js-conversation-"+t+", .js-userlist-"+t).remove(),m.dispatchEvent("chat.onCloseRoom",{instance:this,room:t}),this.openRooms.splice(e,1),e=this.currentRoom==t?this.options.guestRoom:this.currentRoom,this.openRoom(e,!0))},openRoom:function(t,e){var o=this.currentRoom,i=p("#chat-tab-"+t);if(-1!=p.inArray(o,self.openRooms)&&!0!==e)return!1;o&&(p(".js-conversation-"+o+", .js-userlist-"+o).hide(),p("#chat-tabs li").removeClass("active before-active after-active"),p("#chat-tabs .tab-close").removeClass("active")),this.currentRoom=t,p(".js-conversation-"+t+", .js-userlist-"+t).show(),i.addClass("active").removeClass("new-msg"),i.prev("li").addClass("before-active"),i.next("li").addClass("after-active"),i.find(".tab-close").addClass("active"),this.dom.attr("data-active",t);var e=p(".js-conversation-"+t).is(".js-public-room")?"removeClass":"addClass",o=this.dom.find("#purge-button"),i=(o[e].call(o,"disabled"),new p.Event("chat.onOpenRoom",{instance:this,room:t,backgroundAction:s}));m.dispatchEvent(i),i.isDefaultPrevented()||(this.scrolling=!1,this.scrollRoom(),s)||m.browser.isMobile||!this.editor||(e=this.editor.element.offset().top-p(window).scrollTop())<p(window).height()&&0<=e&&this.editor.element.focus()},bindLinks:function(t){window.self!=window.top&&t.find("a[href]:not([data-action],[data-code],.ic-row-action-launcher)").off("click.frame").on("click.frame",function(t){t.preventDefault(),window.top.location.href=this.href})},bindTabs:function(){var o=this;p("#chat-tabs").find("li, .tab-close").off(),p("#chat-tabs li").click(function(t){var e=parseInt(p(this).attr("id").replace("chat-tab-",""));o.openRoom(e),t.preventDefault()}),p("#chat-tabs li .tab-close").click(function(t){var e=p(this).parent(),e=parseInt(e.attr("id").replace("chat-tab-",""));o.closeRoom(e),t.preventDefault()}),m.dispatchEvent("chat.onBindTabs",this)},bindRows:function(){var o=this,t=p("#chat-conversation-container .chat-row");t.off().find(".ic-row-action-launcher").cbbDropdown({onCreate:function(){var e=this;e.rowID=e.launcher.closest(".chat-row").data("id"),e.container.find("[data-action]").off("click").click(function(t){t.preventDefault(),t.msgID=e.rowID,o.eventDispatch(t),e.close()})},onOpen:function(){this.launcher.closest(".chat-row").addClass("active"),o.status("pause",!0)},onClose:function(){this.launcher.closest(".chat-row").removeClass("active").children(".chat-row-content").mouseleave(),o.status("resume")}}),m.browser.isMobile?t.find(".ic-row-actions").show():t.filter(":not(.chat-format-bubble)").children(".chat-row-content").hover(function(){p(this).children(".ic-row-actions").show()},function(){p(this).closest(".chat-row").is(".active")||p(this).children(".ic-row-actions").each(function(){if(0<p(this).children(".row-id-list:checked").length)return!0;p(this).hide()})}),p("#chat-conversation-container").find(".history-row a, .chat-quickmention").off("click").click(p.proxy(this,"eventDispatch")),t.cbbImageGallery({imageSelector:"img:not(.emoji, .smilies)"}),o.bindLinks(t),m.dispatchEvent("chat.onBindRows",this)},bindUserlist:function(t,e){var t=e?".js-user-"+e:t?".js-userlist-"+t:".ic-userlist",e=e?p(t):p(t).children("li"),o=this;e.find("a").off("click").click(p.proxy(o,"eventDispatch")),e.children("a").cbbDropdown({dispatchEvent:"contextmenu",showPointer:!1,onCreate:function(){this.container.find("a").click(p.proxy(this,"close"))},onOpen:function(){o.currentMenu=this,o.status("pause",!0)},onClose:function(){o.currentMenu=null,o.status("resume")}}),m.dispatchEvent("chat.onBindUserlist",this)},eventDispatch:function(t){t.preventDefault();var e=p(t.currentTarget),o=e.data("action"),i=t.msgID,n=this;if(e.is(".disabled"))return!1;!i&&e.closest(".chat-row").length&&(i=e.closest(".chat-row").data("id"));t=new p.Event("chat.beforeEventDispatch",{originalEvent:t,action:o,service:this,msgID:i});if(m.dispatchEvent(t),!t.isDefaultPrevented()){switch(o){case"connect":case"refresh":this.closeActiveBox();case"submit":this[o].call(this);break;case"clear":n.send("clear",!1,function(){p(".js-conversation-"+n.currentRoom).html("")});break;case"rules":n.send("rules",!1,function(t){n.dialog({content:t.htmlContent,height:120,width:350})});break;case"sound":this.closeActiveBox(),this.player("mute");break;case"edit":n.send("edit",{id:i},function(t){n.dialog({autoFocus:!0,content:t.htmlContent,width:610,onSubmit:function(t){if((t=p.extend(t,{id:i,submit:1}),n.options.maxChars)&&m.intval(p(this).find(".chat-editor-counter > span").text())<0)return!1;n.send("edit",t,function(t){t.text&&p("#chat-row-"+i).find(".ic-row-text").html(t.text)})}})});break;case"delete":this.send("delete",{id:i},function(){n.player("play","delete"),p("#chat-row-"+i).fadeOut()});break;case"quote":this.send(o,{id:i});break;case"whois":n.send("whois",{id:i},function(t){n.dialog({content:t.htmlContent,width:450,height:150})});break;case"user":window.open(e.attr("href"));break;case"banuser":var s=e.data("user-key");this.send("banuser",{uk:s},function(t){n.dialog({content:t.htmlContent,onOpen:function(e){p("#ban-period").change(function(){var t="0"==p(this).val();e.ui.find("dl:has(#ban-date)").objView(t),t||e.ui.find("#ban-date").val("").removeClass("cbb-state-error")})},onSubmit:function(t){if("0"==t.period&&null==t.date.match(/\d{2}\/\d{2}\/\d{4} \d{2}\:\d{2}\:\d{2}/))return p(this).find("#ban-date").addClass("cbb-state-error").focus(),!1;t=p.extend(t,{uk:s,submit:1}),n.send("banuser",t)}})});break;case"quickmention":var a=(c=e.next(".ic-row-username:first")).children("a");case"mentionuser":(a="mentionuser"==o?(c=this.currentMenu.launcher).children("span"):a).length?n.editor.insertBBcode("color",{defaultAttr:m.rgbToHex(a.css("color")),inner:"[b]@"+a.text()+"[/b]"},FLAG_ADDWHITESPACES|FLAG_CURSORTOEND):n.editor.insertBBcode("b",{inner:"@"+c.text()},FLAG_ADDWHITESPACES|FLAG_CURSORTOEND);break;case"pmuser":s=e.data("user-key");-1==p.inArray(s,this.openRooms)?this.send("pmuser",{uk:s},function(){n.openRoom(s)}):this.openRoom(s);break;case"unbanuser":case"set_available":case"set_away":case"set_busy":case"set_hidden":this.send(o,{uk:e.data("user-key")});break;case"set_name":s=e.data("user-key");this.send("set_name",{uk:s},function(t){n.dialog({autoFocus:!0,content:t.htmlContent,onSubmit:function(t){if(!(t=p.extend(t,{uk:s,submit:1})).username)return p(this).find("input[name=username]").addClass("cbb-state-error").focus(),!1;n.send("set_name",t)}})});break;case"move":this.send("move",{id:i},function(t){n.dialog({content:t.htmlContent,onSubmit:function(t){t=p.extend(t,{id:i,submit:1,last_update:0}),n.send("move",t,function(){})}})});break;case"minimize":this.collapsable("change");break;case"history":var a="up"==this.options.direction?"prev":"next",c=e.parent()[a].call(e.parent(),".chat-row");this.send("history",{last_update:c.data("time")});break;default:window.open(e.attr("href"))}p(this).blur()}},player:function(t,e){if(null===this.options.soundPath)return!1;switch(t){case"mute":n&&!0!==e?!n&&!1!==e||(n=!1,p('a[data-action="sound"]').removeClass("muted"),this.cookie("mute","")):(n=!0,p('a[data-action="sound"]').addClass("muted"),this.cookie("mute",1,180));break;case"play":n||(this.audio.src=this.options.soundPath+e+".mp3",this.audio.play())}},dialog:function(e){var t,o=this;"string"==typeof e?null!==r&&(r.cbbDialog(e),"close"==e)&&(r=null):(t={autoClean:!1,autoFocus:e.autoFocus||!1,destroyOnClose:!0,movable:!1,width:e.width||"auto",height:e.height||"auto",parent:"archive"==this.options.mode?"body":p("#chat-content").is("ul")?"#chat-content > li":"#chat-content",onOpen:function(t){o.status("pause",!0),o.closeActiveBox(),o.bindLinks(p(this)),e.onOpen&&e.onOpen.call(this,t)},onClose:function(){o.status("resume")},onSubmit:e.onSubmit},r=p(e.content).cbbDialog(t))},scrollRoom:function(t){var e=p("#chat-conversation-container")[0];t?e.scrollTop=t:(e.scrollTop="up"==this.options.direction?0:e.scrollHeight,p(".chat-scroll-button").objView(!1))},status:function(t){switch(t){case"load-start":i=!0,p(".ic-loading").show();break;case"load-end":i=!1,p(".ic-loading").hide();break;case"loading":return i;case"stop":p("#chat-conversation-container, #chat-right-panel, #chat-tabs").html(""),this.openRooms=[],this.connected=!1,this.dom.find("input[name=last_update]").val(0),this.dom.find("input[name=time_mark]").val(0);case"pause":clearTimeout(e),e=null,this.status("load-end");break;case"resume":this.connected&&null===e&&(e=setTimeout(p.proxy(this,"refresh"),this.options.refresh))}},cookie:function(t,e,o){t="chat_"+t;if(null==e)return m.cookie.get(t);m.cookie.set(t,e,o)},inverseConversations:function(){p("#chat-conversation-container").children(".ic-conversation").each(function(){var t=p(this).children(".chat-row, .history-row");if(t.length){p(this).html("");for(var e=t.length-1;-1<e;e--)p(this).append(t[e])}})},appendConversationData:function(c){var r=this,h=!1,t=new Date,l=this.cookie("lastcheck")||t.getTime()/1e3;return this.tempDom.find(".room").each(function(){var t=parseInt(p(this).attr("id").replace("room-","")),e=p.trim(p(this).children(".js-conversation").html()),o=p.trim(p(this).children(".js-userlist").html());if(-1==p.inArray(t,r.openRooms)){if("history"==c)return!0;r.openRooms.push(t);var i={ROOM_ID:t,TITLE:p(this).attr("title")};p("#chat-right-panel").append(r.getTpl("userlist",i)),p("#chat-conversation-container").append(r.getTpl("conversation",i)),p("#chat-tabs").append(r.getTpl("tab",i)),p(this).is(".js-public-room")&&(p(".js-conversation-"+t).addClass("js-public-room"),p("#chat-tab-"+t).find(".tab-close").remove()),r.bindTabs()}var n=p(".js-conversation-"+t);if("history"==c)n.children(".history-row").replaceWith(e),h=!!e;else if(e){n[r.method].apply(n,[e]);var s=n.children(".chat-row").length,a="up"==r.options.direction?":last":":first";if(!n.data("ignoreLimit"))for(;s>r.options.maxRows;)n.children(".chat-row"+a).remove(),s--;i="up"==r.options.direction?":first":":last",e=parseInt(n.children(".chat-row"+i).data("time"));t!=r.currentRoom&&("refresh"==c||e&&l<e)&&p("#chat-tab-"+t).addClass("new-msg"),h=!0}o&&(p(".js-userlist-"+t).html(o),r.bindUserlist(t))}),h},doQueue:function(t){if(!t||!t.length)return!1;let e=!1;for(var o of t)switch(o.action){case"delete":p("#chat-row-"+o.msgID).fadeOut();break;case"edit":p("#chat-row-"+o.msgID).find(".ic-row-text").html(o.msgText);break;case"connect":e||(e=!0,this.player("play","connect"));break;case"move":var i=this.dom.find("#chat-row-"+o.msgID),n=m.intval(i.attr("data-time")),s=this.dom.find(".js-conversation-"+o.destKey);if((a=s.children(".chat-row")).length)for(var a=a.get().reverse(),c=0;c<a.length;c++){if(m.intval(p(a[c]).attr("data-time"))<n){p(a[c]).after(i);break}if(c==a.length-1){s.prepend(i);break}}else s.append(i);this.scrolling||this.scrollRoom()}},getTpl:function(t,e){return m.template.parse(this.tpl[t],e)}},!1)}(jQuery,cbbCore),function(o,i){"use strict";cbbEditorWrapper.plugins.chat={init:function(){this.chat=i.getService("chat"),this.chat.editor||(this.chat.editor=this.editor),this.bindInput(),this.updateCharCounter()},bindInput:function(){var t,e=this;e.editor.element.closest("#chat-message").length&&e.editor.element.on("keyup keydown",function(t){if(13==t.which)return"keyup"==t.type&&1!=t.ctrlKey?e.chat.submit():"keydown"==t.type&&1==t.ctrlKey&&e.editor.insertText("\n"),t.preventDefault(),t.stopPropagation(),!1}),e.chat.options.maxChars&&(t=o('<div class="chat-editor-counter"><span></span><svg height="20" width="20"><circle class="mask" cx="50%" cy="50%" r="8" fill="none" stroke-width="1"></circle><circle cx="50%" cy="50%" r="8" fill="none" stroke-width="2"></circle></svg></div>'),e.charCounter={radial:t.find("circle:not(.mask)"),label:t.children("span")},e.charCounter.radial.css({"stroke-dashoffset":50,"stroke-dasharray":50}),e.editor.element.on("input",o.proxy(e,"updateCharCounter")).after(t)),i.dispatchEvent("chat.onBindInput",this)},updateCharCounter:function(){var t,e,o,i;void 0!==this.charCounter&&(e=50-50*(t=this.editor.element.val()).length/this.chat.options.maxChars,o="danger",i="",this.charCounter.radial.css("stroke-dashoffset",Math.max(0,e)),5<e?o="safe":0<=e&&(o="warn"),this.charCounter.radial.get(0).setAttribute("class",o),e<0&&(i=this.chat.options.maxChars-t.length),this.charCounter.label.text(i))},eventCommandExec:function(){this.chat.options.hidePopup&&this.chat.closeActiveBox()},eventTextchange:function(){this.updateCharCounter()}}}(jQuery,cbbCore);
 
-((t,o,n)=>{"function"==typeof define&&define.amd?define(["jquery"],function(e){return n(e,t,o),e.mobile}):n(t.jQuery,t,o)})(this,document,function(e,a,K,O){var t;t=function(e){return e.ui=e.ui||{},e.ui.version="1.12.1"},"function"==typeof define&&define.amd?define("jquery-ui/version",["jquery"],t):t(e),t=function(){},"function"==typeof define&&define.amd&&define("core",["./defaults","./data","./helpers"],t),t=function(e){var t={touch:"ontouchend"in K};return e.mobile={},e.mobile.support=e.mobile.support||{},e.extend(e.support,t),e.extend(e.mobile.support,t),e.support},"function"==typeof define&&define.amd?define("support/touch",["jquery","../ns"],t):t(e),t=function(e){return e.extend(e.support,{orientation:"orientation"in a&&"onorientationchange"in a}),e.support},"function"==typeof define&&define.amd?define("support/orientation",["jquery"],t):t(e),t=function(p){var c,e,i="virtualMouseBindings",u="virtualTouchID",l="clientX clientY pageX pageY screenX screenY".split(" "),t="vmouseover vmousedown vmousemove vmouseup vclick vmouseout vmousecancel".split(" "),f="altKey bubbles cancelable ctrlKey currentTarget detail eventPhase metaKey relatedTarget shiftKey target timeStamp view which".split(" "),o=p.event.mouseHooks?p.event.mouseHooks.props:[],h=f.concat(o),a={},n=0,s=0,r=0,v=!1,d=[],m=!1,g=!1,w="addEventListener"in K,T=p(K),y=1,b=0;function D(e){for(;e&&void 0!==e.originalEvent;)e=e.originalEvent;return e}function P(e){for(var t,o,n={};e;){for(o in t=p.data(e,i))t[o]&&(n[o]=n.hasVirtualBinding=!0);e=e.parentNode}return n}function k(){g=!0}function E(){b=0,d.length=0,m=!1,k()}function F(){g=!1}function X(){n&&(clearTimeout(n),n=0)}function Y(){X(),n=setTimeout(function(){n=0,E()},p.vmouse.resetTimerDuration)}function x(e,t,o){var n;return(o&&o[e]||!o&&((e,t)=>{for(var o;e;){if((o=p.data(e,i))&&(!t||o[t]))return e;e=e.parentNode}})(t.target,e))&&(n=((e,t)=>{var o,n,i,a,s,r,c,u=e.type;if((e=p.Event(e)).type=t,o=e.originalEvent,n=f,-1<u.search(/^(mouse|click)/)&&(n=h),o)for(s=n.length;s;)e[i=n[--s]]=o[i];if(-1<u.search(/mouse(down|up)|click/)&&!e.which&&(e.which=1),-1!==u.search(/^touch/)&&(u=(t=D(o)).touches,t=t.changedTouches,a=u&&u.length?u[0]:t&&t.length?t[0]:O))for(r=0,c=l.length;r<c;r++)e[i=l[r]]=a[i];return e})(t,e),p(t.target).trigger(n)),n}function M(e){var t=p.data(e.target,u);"click"===e.type&&"touchstart"===p.data(e.target,"lastTouchType")&&setTimeout(function(){"touchstart"===p.data(e.target,"lastTouchType")&&(E(),delete p.data(e.target).lastTouchType,M(e))},p.vmouse.maximumTimeBetweenTouches),m||b&&b===t||(t=x("v"+e.type,e))&&(t.isDefaultPrevented()&&e.preventDefault(),t.isPropagationStopped()&&e.stopPropagation(),t.isImmediatePropagationStopped())&&e.stopImmediatePropagation()}function I(e){var t,o=D(e).touches;o&&1===o.length&&(t=P(o=e.target),p.data(e.target,"lastTouchType",e.type),t.hasVirtualBinding)&&(b=y++,p.data(o,u,b),X(),F(),v=!1,o=D(e).touches[0],s=o.pageX,r=o.pageY,x("vmouseover",e,t),x("vmousedown",e,t))}function j(e){g||(v||x("vmousecancel",e,P(e.target)),p.data(e.target,"lastTouchType",e.type),v=!0,Y())}function q(e){var t,o,n,i;g||(t=D(e).touches[0],o=v,n=p.vmouse.moveDistanceThreshold,i=P(e.target),p.data(e.target,"lastTouchType",e.type),(v=v||Math.abs(t.pageX-s)>n||Math.abs(t.pageY-r)>n)&&!o&&x("vmousecancel",e,i),x("vmousemove",e,i),Y())}function S(e){var t,o;g||p.data(e.target,"lastTouchType")===O||(k(),delete p.data(e.target).lastTouchType,x("vmouseup",e,t=P(e.target)),v||(o=x("vclick",e,t))&&o.isDefaultPrevented()&&(o=D(e).changedTouches[0],d.push({touchID:b,x:o.clientX,y:o.clientY}),m=!0),x("vmouseout",e,t),v=!1,Y())}function B(e){var t,o=p.data(e,i);if(o)for(t in o)if(o[t])return 1}function L(){}for(p.vmouse={moveDistanceThreshold:10,clickDistanceThreshold:10,resetTimerDuration:1500,maximumTimeBetweenTouches:100},e=0;e<t.length;e++)p.event.special[t[e]]=(o=>{var n=o.substr(1);return{setup:function(){B(this)||p.data(this,i,{}),p.data(this,i)[o]=!0,a[o]=(a[o]||0)+1,1===a[o]&&T.on(n,M),p(this).on(n,L),w&&(a.touchstart=(a.touchstart||0)+1,1===a.touchstart)&&T.on("touchstart",I).on("touchend",S).on("touchmove",q).on("scroll",j)},teardown:function(){--a[o],a[o]||T.off(n,M),w&&(--a.touchstart,a.touchstart||T.off("touchstart",I).off("touchmove",q).off("touchend",S).off("scroll",j));var e=p(this),t=p.data(this,i);t&&(t[o]=!1),e.off(n,L),B(this)||e.removeData(i)}}})(t[e]);w&&K.addEventListener("click",function(e){var t,o,n,i,a,s=d.length,r=e.target;if(s)for(t=e.clientX,o=e.clientY,c=p.vmouse.clickDistanceThreshold,n=r;n;){for(i=0;i<s;i++)if(a=d[i],n===r&&Math.abs(a.x-t)<c&&Math.abs(a.y-o)<c||p.data(n,u)===a.touchID)return e.preventDefault(),void e.stopPropagation();n=n.parentNode}},!0)},"function"==typeof define&&define.amd?define("vmouse",["jquery"],t):t(e),t=function(u){var p=u(K),e=u.mobile.support.touch,o=e?"touchstart":"mousedown",r=e?"touchend":"mouseup",c=e?"touchmove":"mousemove";function l(e,t,o,n){var i=o.type;o.type=t,n?u.event.trigger(o,O,e):u.event.dispatch.call(e,o),o.type=i}return u.each("touchstart touchmove touchend tap taphold swipe swipeleft swiperight".split(" "),function(e,t){u.fn[t]=function(e){return e?this.on(t,e):this.trigger(t)},u.attrFn&&(u.attrFn[t]=!0)}),u.event.special.tap={tapholdThreshold:750,emitTapOnTaphold:!0,setup:function(){var s=this,r=u(s),c=!1;r.on("vmousedown",function(e){if(c=!1,e.which&&1!==e.which)return!0;var t,o,n=e.target;function i(){clearTimeout(t)}function a(){i(),r.off("vclick",o).off("vmouseup",i),p.off("vmousecancel",a)}o=function(e){a(),c||n!==e.target?c&&e.preventDefault():l(s,"tap",e)},r.on("vmouseup",i).on("vclick",o),p.on("vmousecancel",a),t=setTimeout(function(){u.event.special.tap.emitTapOnTaphold||(c=!0),t=0,l(s,"taphold",u.Event("taphold",{target:n}))},u.event.special.tap.tapholdThreshold)})},teardown:function(){u(this).off("vmousedown").off("vclick").off("vmouseup"),p.off("vmousecancel")}},u.event.special.swipe={scrollSupressionThreshold:30,durationThreshold:1e3,horizontalDistanceThreshold:2<=a.devicePixelRatio?15:30,verticalDistanceThreshold:2<=a.devicePixelRatio?15:30,getLocation:function(e){var t=a.pageXOffset,o=a.pageYOffset,n=e.clientX,i=e.clientY;return 0===e.pageY&&Math.floor(i)>Math.floor(e.pageY)||0===e.pageX&&Math.floor(n)>Math.floor(e.pageX)?(n-=t,i-=o):(i<e.pageY-o||n<e.pageX-t)&&(n=e.pageX-t,i=e.pageY-o),{x:n,y:i}},start:function(e){var t=e.originalEvent.touches?e.originalEvent.touches[0]:e,t=u.event.special.swipe.getLocation(t);return{time:(new Date).getTime(),coords:[t.x,t.y],origin:u(e.target)}},stop:function(e){e=e.originalEvent.touches?e.originalEvent.touches[0]:e,e=u.event.special.swipe.getLocation(e);return{time:(new Date).getTime(),coords:[e.x,e.y]}},handleSwipe:function(e,t,o,n){var i;return t.time-e.time<u.event.special.swipe.durationThreshold&&Math.abs(e.coords[0]-t.coords[0])>u.event.special.swipe.horizontalDistanceThreshold&&Math.abs(e.coords[1]-t.coords[1])<u.event.special.swipe.verticalDistanceThreshold&&(i=e.coords[0]>t.coords[0]?"swipeleft":"swiperight",l(o,"swipe",u.Event("swipe",{target:n,swipestart:e,swipestop:t}),!0),l(o,i,u.Event(i,{target:n,swipestart:e,swipestop:t}),!0),!0)},eventInProgress:!1,setup:function(){var a=this,e=u(a),s={},t=u.data(this,"mobile-events");t||u.data(this,"mobile-events",t={length:0}),t.length++,(t.swipe=s).start=function(e){var t,o,n,i;u.event.special.swipe.eventInProgress||(u.event.special.swipe.eventInProgress=!0,o=u.event.special.swipe.start(e),n=e.target,i=!1,s.move=function(e){o&&!e.isDefaultPrevented()&&(t=u.event.special.swipe.stop(e),i||(i=u.event.special.swipe.handleSwipe(o,t,a,n))&&(u.event.special.swipe.eventInProgress=!1),Math.abs(o.coords[0]-t.coords[0])>u.event.special.swipe.scrollSupressionThreshold)&&e.preventDefault()},s.stop=function(){i=!0,u.event.special.swipe.eventInProgress=!1,p.off(c,s.move),s.move=null},p.on(c,s.move).one(r,s.stop))},e.on(o,s.start)},teardown:function(){var e,t=u.data(this,"mobile-events");t&&(e=t.swipe,delete t.swipe,t.length--,0===t.length)&&u.removeData(this,"mobile-events"),e&&(e.start&&u(this).off(o,e.start),e.move&&p.off(c,e.move),e.stop)&&p.off(r,e.stop)}},u.each({taphold:"tap",swipeleft:"swipe.left",swiperight:"swipe.right"},function(e,t){u.event.special[e]={setup:function(){u(this).on(t,u.noop)},teardown:function(){u(this).off(t)}}}),u.event.special},"function"==typeof define&&define.amd?define("events/touch",["jquery","../vmouse","../support/touch"],t):t(e),t=function(s){var r="touchmove scroll";return s.each(["scrollstart","scrollstop"],function(e,t){s.fn[t]=function(e){return e?this.on(t,e):this.trigger(t)},s.attrFn&&(s.attrFn[t]=!0)}),s.event.special.scrollstart={enabled:!0,setup:function(){var n,t,i=this,e=s(i);function o(e,t){var o=e.type;n=t,e.type=n?"scrollstart":"scrollstop",s.event.dispatch.call(i,e),e.type=o}var a=s.event.special.scrollstart.handler=function(e){s.event.special.scrollstart.enabled&&(n||o(e,!0),clearTimeout(t),t=setTimeout(function(){o(e,!1)},50))};e.on(r,a)},teardown:function(){s(this).off(r,s.event.special.scrollstart.handler)}},s.each({scrollstop:"scrollstart"},function(e,t){s.event.special[e]={setup:function(){s(this).on(t,s.noop)},teardown:function(){s(this).off(t)}}}),s.event.special},"function"==typeof define&&define.amd?define("events/scroll",["jquery"],t):t(e)});
\ No newline at end of file
+!function(t,o,n){"function"==typeof define&&define.amd?define(["jquery"],function(e){return n(e,t,o),e.mobile}):n(t.jQuery,t,o)}(this,document,function(e,a,K,O){var t;t=function(e){return e.ui=e.ui||{},e.ui.version="1.12.1"},"function"==typeof define&&define.amd?define("jquery-ui/version",["jquery"],t):t(e),t=function(){},"function"==typeof define&&define.amd&&define("core",["./defaults","./data","./helpers"],t),t=function(e){var t={touch:"ontouchend"in K};return e.mobile={},e.mobile.support=e.mobile.support||{},e.extend(e.support,t),e.extend(e.mobile.support,t),e.support},"function"==typeof define&&define.amd?define("support/touch",["jquery","../ns"],t):t(e),t=function(e){return e.extend(e.support,{orientation:"orientation"in a&&"onorientationchange"in a}),e.support},"function"==typeof define&&define.amd?define("support/orientation",["jquery"],t):t(e),t=function(p){var c,e,i="virtualMouseBindings",u="virtualTouchID",l="clientX clientY pageX pageY screenX screenY".split(" "),t="vmouseover vmousedown vmousemove vmouseup vclick vmouseout vmousecancel".split(" "),f="altKey bubbles cancelable ctrlKey currentTarget detail eventPhase metaKey relatedTarget shiftKey target timeStamp view which".split(" "),o=p.event.mouseHooks?p.event.mouseHooks.props:[],h=f.concat(o),a={},n=0,s=0,r=0,v=!1,d=[],m=!1,g=!1,w="addEventListener"in K,T=p(K),y=1,b=0;function D(e){for(;e&&void 0!==e.originalEvent;)e=e.originalEvent;return e}function P(e){for(var t,o,n={};e;){for(o in t=p.data(e,i))t[o]&&(n[o]=n.hasVirtualBinding=!0);e=e.parentNode}return n}function k(){g=!0}function E(){b=0,d.length=0,m=!1,k()}function F(){g=!1}function X(){n&&(clearTimeout(n),n=0)}function Y(){X(),n=setTimeout(function(){n=0,E()},p.vmouse.resetTimerDuration)}function x(e,t,o){var n;return(o&&o[e]||!o&&function(e,t){for(var o;e;){if((o=p.data(e,i))&&(!t||o[t]))return e;e=e.parentNode}}(t.target,e))&&(n=function(e,t){var o,n,i,a,s,r,c,u=e.type;if((e=p.Event(e)).type=t,o=e.originalEvent,n=f,-1<u.search(/^(mouse|click)/)&&(n=h),o)for(s=n.length;s;)e[i=n[--s]]=o[i];if(-1<u.search(/mouse(down|up)|click/)&&!e.which&&(e.which=1),-1!==u.search(/^touch/)&&(u=(t=D(o)).touches,t=t.changedTouches,a=u&&u.length?u[0]:t&&t.length?t[0]:O))for(r=0,c=l.length;r<c;r++)e[i=l[r]]=a[i];return e}(t,e),p(t.target).trigger(n)),n}function M(e){var t=p.data(e.target,u);"click"===e.type&&"touchstart"===p.data(e.target,"lastTouchType")&&setTimeout(function(){"touchstart"===p.data(e.target,"lastTouchType")&&(E(),delete p.data(e.target).lastTouchType,M(e))},p.vmouse.maximumTimeBetweenTouches),m||b&&b===t||(t=x("v"+e.type,e))&&(t.isDefaultPrevented()&&e.preventDefault(),t.isPropagationStopped()&&e.stopPropagation(),t.isImmediatePropagationStopped())&&e.stopImmediatePropagation()}function I(e){var t,o=D(e).touches;o&&1===o.length&&(t=P(o=e.target),p.data(e.target,"lastTouchType",e.type),t.hasVirtualBinding)&&(b=y++,p.data(o,u,b),X(),F(),v=!1,o=D(e).touches[0],s=o.pageX,r=o.pageY,x("vmouseover",e,t),x("vmousedown",e,t))}function j(e){g||(v||x("vmousecancel",e,P(e.target)),p.data(e.target,"lastTouchType",e.type),v=!0,Y())}function q(e){var t,o,n,i;g||(t=D(e).touches[0],o=v,n=p.vmouse.moveDistanceThreshold,i=P(e.target),p.data(e.target,"lastTouchType",e.type),(v=v||Math.abs(t.pageX-s)>n||Math.abs(t.pageY-r)>n)&&!o&&x("vmousecancel",e,i),x("vmousemove",e,i),Y())}function S(e){var t,o;g||p.data(e.target,"lastTouchType")===O||(k(),delete p.data(e.target).lastTouchType,x("vmouseup",e,t=P(e.target)),v||(o=x("vclick",e,t))&&o.isDefaultPrevented()&&(o=D(e).changedTouches[0],d.push({touchID:b,x:o.clientX,y:o.clientY}),m=!0),x("vmouseout",e,t),v=!1,Y())}function B(e){var t,o=p.data(e,i);if(o)for(t in o)if(o[t])return 1}function L(){}for(p.vmouse={moveDistanceThreshold:10,clickDistanceThreshold:10,resetTimerDuration:1500,maximumTimeBetweenTouches:100},e=0;e<t.length;e++)p.event.special[t[e]]=function(o){var n=o.substr(1);return{setup:function(){B(this)||p.data(this,i,{}),p.data(this,i)[o]=!0,a[o]=(a[o]||0)+1,1===a[o]&&T.on(n,M),p(this).on(n,L),w&&(a.touchstart=(a.touchstart||0)+1,1===a.touchstart)&&T.on("touchstart",I).on("touchend",S).on("touchmove",q).on("scroll",j)},teardown:function(){--a[o],a[o]||T.off(n,M),w&&(--a.touchstart,a.touchstart||T.off("touchstart",I).off("touchmove",q).off("touchend",S).off("scroll",j));var e=p(this),t=p.data(this,i);t&&(t[o]=!1),e.off(n,L),B(this)||e.removeData(i)}}}(t[e]);w&&K.addEventListener("click",function(e){var t,o,n,i,a,s=d.length,r=e.target;if(s)for(t=e.clientX,o=e.clientY,c=p.vmouse.clickDistanceThreshold,n=r;n;){for(i=0;i<s;i++)if(a=d[i],n===r&&Math.abs(a.x-t)<c&&Math.abs(a.y-o)<c||p.data(n,u)===a.touchID)return e.preventDefault(),void e.stopPropagation();n=n.parentNode}},!0)},"function"==typeof define&&define.amd?define("vmouse",["jquery"],t):t(e),t=function(u){var p=u(K),e=u.mobile.support.touch,o=e?"touchstart":"mousedown",r=e?"touchend":"mouseup",c=e?"touchmove":"mousemove";function l(e,t,o,n){var i=o.type;o.type=t,n?u.event.trigger(o,O,e):u.event.dispatch.call(e,o),o.type=i}return u.each("touchstart touchmove touchend tap taphold swipe swipeleft swiperight".split(" "),function(e,t){u.fn[t]=function(e){return e?this.on(t,e):this.trigger(t)},u.attrFn&&(u.attrFn[t]=!0)}),u.event.special.tap={tapholdThreshold:750,emitTapOnTaphold:!0,setup:function(){var s=this,r=u(s),c=!1;r.on("vmousedown",function(e){if(c=!1,e.which&&1!==e.which)return!0;var t,o,n=e.target;function i(){clearTimeout(t)}function a(){i(),r.off("vclick",o).off("vmouseup",i),p.off("vmousecancel",a)}o=function(e){a(),c||n!==e.target?c&&e.preventDefault():l(s,"tap",e)},r.on("vmouseup",i).on("vclick",o),p.on("vmousecancel",a),t=setTimeout(function(){u.event.special.tap.emitTapOnTaphold||(c=!0),t=0,l(s,"taphold",u.Event("taphold",{target:n}))},u.event.special.tap.tapholdThreshold)})},teardown:function(){u(this).off("vmousedown").off("vclick").off("vmouseup"),p.off("vmousecancel")}},u.event.special.swipe={scrollSupressionThreshold:30,durationThreshold:1e3,horizontalDistanceThreshold:2<=a.devicePixelRatio?15:30,verticalDistanceThreshold:2<=a.devicePixelRatio?15:30,getLocation:function(e){var t=a.pageXOffset,o=a.pageYOffset,n=e.clientX,i=e.clientY;return 0===e.pageY&&Math.floor(i)>Math.floor(e.pageY)||0===e.pageX&&Math.floor(n)>Math.floor(e.pageX)?(n-=t,i-=o):(i<e.pageY-o||n<e.pageX-t)&&(n=e.pageX-t,i=e.pageY-o),{x:n,y:i}},start:function(e){var t=e.originalEvent.touches?e.originalEvent.touches[0]:e,t=u.event.special.swipe.getLocation(t);return{time:(new Date).getTime(),coords:[t.x,t.y],origin:u(e.target)}},stop:function(e){e=e.originalEvent.touches?e.originalEvent.touches[0]:e,e=u.event.special.swipe.getLocation(e);return{time:(new Date).getTime(),coords:[e.x,e.y]}},handleSwipe:function(e,t,o,n){var i;return t.time-e.time<u.event.special.swipe.durationThreshold&&Math.abs(e.coords[0]-t.coords[0])>u.event.special.swipe.horizontalDistanceThreshold&&Math.abs(e.coords[1]-t.coords[1])<u.event.special.swipe.verticalDistanceThreshold&&(i=e.coords[0]>t.coords[0]?"swipeleft":"swiperight",l(o,"swipe",u.Event("swipe",{target:n,swipestart:e,swipestop:t}),!0),l(o,i,u.Event(i,{target:n,swipestart:e,swipestop:t}),!0),!0)},eventInProgress:!1,setup:function(){var a=this,e=u(a),s={},t=u.data(this,"mobile-events");t||u.data(this,"mobile-events",t={length:0}),t.length++,(t.swipe=s).start=function(e){var t,o,n,i;u.event.special.swipe.eventInProgress||(u.event.special.swipe.eventInProgress=!0,o=u.event.special.swipe.start(e),n=e.target,i=!1,s.move=function(e){o&&!e.isDefaultPrevented()&&(t=u.event.special.swipe.stop(e),i||(i=u.event.special.swipe.handleSwipe(o,t,a,n))&&(u.event.special.swipe.eventInProgress=!1),Math.abs(o.coords[0]-t.coords[0])>u.event.special.swipe.scrollSupressionThreshold)&&e.preventDefault()},s.stop=function(){i=!0,u.event.special.swipe.eventInProgress=!1,p.off(c,s.move),s.move=null},p.on(c,s.move).one(r,s.stop))},e.on(o,s.start)},teardown:function(){var e,t=u.data(this,"mobile-events");t&&(e=t.swipe,delete t.swipe,t.length--,0===t.length)&&u.removeData(this,"mobile-events"),e&&(e.start&&u(this).off(o,e.start),e.move&&p.off(c,e.move),e.stop)&&p.off(r,e.stop)}},u.each({taphold:"tap",swipeleft:"swipe.left",swiperight:"swipe.right"},function(e,t){u.event.special[e]={setup:function(){u(this).on(t,u.noop)},teardown:function(){u(this).off(t)}}}),u.event.special},"function"==typeof define&&define.amd?define("events/touch",["jquery","../vmouse","../support/touch"],t):t(e),t=function(s){var r="touchmove scroll";return s.each(["scrollstart","scrollstop"],function(e,t){s.fn[t]=function(e){return e?this.on(t,e):this.trigger(t)},s.attrFn&&(s.attrFn[t]=!0)}),s.event.special.scrollstart={enabled:!0,setup:function(){var n,t,i=this,e=s(i);function o(e,t){var o=e.type;n=t,e.type=n?"scrollstart":"scrollstop",s.event.dispatch.call(i,e),e.type=o}var a=s.event.special.scrollstart.handler=function(e){s.event.special.scrollstart.enabled&&(n||o(e,!0),clearTimeout(t),t=setTimeout(function(){o(e,!1)},50))};e.on(r,a)},teardown:function(){s(this).off(r,s.event.special.scrollstart.handler)}},s.each({scrollstop:"scrollstart"},function(e,t){s.event.special[e]={setup:function(){s(this).on(t,s.noop)},teardown:function(){s(this).off(t)}}}),s.event.special},"function"==typeof define&&define.amd?define("events/scroll",["jquery"],t):t(e)});
\ No newline at end of file
diff --git "[ORIGINAL]/canidev\\chat/styles/all/theme/chat.css" "[FORUM_EXT]/canidev\\chat/styles/all/theme/chat.css"
--- "[ORIGINAL]/canidev\\chat/styles/all/theme/chat.css"
+++ "[FORUM_EXT]/canidev\\chat/styles/all/theme/chat.css"
@@ -1,7 +1,7 @@
 /*  cBB Chat StyleSheet
     --------------------------------------------------------------
 	Style:	All
-	Copyright (c) 2025 CaniDev ( https://www.canidev.com )
+	Copyright (c) 2024 CaniDev ( https://www.canidev.com )
     --------------------------------------------------------------
 */
 
@@ -502,21 +502,23 @@ a.chat-quickmention {
 }
 
 .chat-editor-counter {
-	display: flex;
 	top: 5px;
 	position: absolute;
 	right: 5px;
 }
 
 .chat-editor-counter > svg {
+	margin-bottom: -4px;
 	overflow: visible;
 	transform: rotate(-90deg);
 }
 
 .chat-editor-counter > span {
 	color: #e0245e;
-	font-size: 0.8em;
+	font-size: 9px;
 	margin: 5px 2px 0 0;
+	display: inline-block;
+    vertical-align: top;
 }
 
 .chat-editor-counter .safe {
@@ -663,6 +665,7 @@ ul.topiclist .chat-dialog-fieldset dd {
 
 .chat-message,
 .chat-tip-message {
+	font-size: 11px;
 	margin: 5px 0;
 }
 
@@ -812,11 +815,6 @@ html.embedmode { height: auto; }
 	padding-right: 5px;
 }
 
-.rtl #chat-message textarea,
-.rtl .ic-edit-container textarea {
-	border: none;
-}
-
 .rtl .chat-editor-counter,
 .rtl .chat-submit-btn {
 	left: 5px;
@@ -971,10 +969,10 @@ html.embedmode { height: auto; }
 	box-shadow: 0 0 4px 0px #2e2e2e;
 }
 
-.medium-dark-theme #chat-content,
-.medium-dark-theme #chat-content a {
-	color: #000;
-}
+/* .medium-dark-theme #chat-content, */
+/* .medium-dark-theme #chat-content a { */
+	/* color: #000; */
+/* } */
 
 /* Responsive Layout
 ------------------------------- */
```
