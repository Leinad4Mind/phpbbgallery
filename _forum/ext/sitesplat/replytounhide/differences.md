Existem diferencas reais no codigo ou texto. Diferencas de formatacao (espacos, tabs) foram ignoradas abaixo.

```diff
diff --git "[ORIGINAL]/sitesplat\\replytounhide/composer.json" "[FORUM_EXT]/sitesplat\\replytounhide/composer.json"
--- "[ORIGINAL]/sitesplat\\replytounhide/composer.json"
+++ "[FORUM_EXT]/sitesplat\\replytounhide/composer.json"
@@ -2,10 +2,10 @@
     "name": "sitesplat/replytounhide",
     "type": "phpbb-extension",
     "description": "Hides the content places within the hide bbcode for guests and also for registered users who have not replied to that topic yet",
-	"homepage": "https://sitesplat.com",
+	"homepage": "http://sitesplat.com",
     "version": "1.0.1",
     "keywords": ["phpbb", "posts", "extension"],
-    "license": "Proprietary/All rights reserved",
+    "license": "@license Proprietary",
     "authors": [
         {
 			"name": "SiteSplat",
@@ -22,13 +22,12 @@
     "extra": {
         "display-name": "ReplyToUnhide",
         "soft-require": {
-            "phpbb/phpbb": ">=3.2.0,<3.3.0@dev"
+            "phpbb/phpbb": "3.1.6"
         },
 		"version-check": {
-            "host": "sitesplat.com",
-            "directory": "/updatecheck/phpbb32/ext",
-            "filename": "replytounhide.json",
-			"ssl": true
+            "host": "www.sitesplat.com",
+            "directory": "/updatecheck/phpbb31/ext",
+            "filename": "replytounhide.json"
 		}
     }
 }
diff --git "[ORIGINAL]/sitesplat\\replytounhide/config/services.yml" "[FORUM_EXT]/sitesplat\\replytounhide/config/services.yml"
--- "[ORIGINAL]/sitesplat\\replytounhide/config/services.yml"
+++ "[FORUM_EXT]/sitesplat\\replytounhide/config/services.yml"
@@ -1,8 +1,12 @@
+imports:
+    - { resource: tables.yml }
+
 services:
     sitesplat.replytounhide.bbcodes_parser:
         class: sitesplat\replytounhide\core\bbcodes_parser
         arguments:
             - '@user'
+            - '@auth'
 
     sitesplat.replytounhide.acp_manager:
         class: sitesplat\replytounhide\core\acp_manager
@@ -17,8 +21,10 @@ services:
             - '@sitesplat.replytounhide.bbcodes_parser'
             - '@controller.helper'
             - '@template'
+            - '@auth'
             - '@user'
             - '@dbal.conn'
+            - '%sitesplat.replytounhide.table.likes%'
             - ext/sitesplat/replytounhide/
         tags:
             - { name: event.listener }
diff --git "[FORUM_EXT]/sitesplat\\replytounhide/config/tables.yml" "[FORUM_EXT]/sitesplat\\replytounhide/config/tables.yml"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\replytounhide/config/tables.yml"
@@ -0,0 +1,2 @@
+parameters:
+    sitesplat.replytounhide.table.likes: '%core.table_prefix%likes'
\ No newline at end of file
diff --git "[ORIGINAL]/sitesplat\\replytounhide/core/acp_manager.php" "[FORUM_EXT]/sitesplat\\replytounhide/core/acp_manager.php"
--- "[ORIGINAL]/sitesplat\\replytounhide/core/acp_manager.php"
+++ "[FORUM_EXT]/sitesplat\\replytounhide/core/acp_manager.php"
@@ -1,7 +1,7 @@
 <?php
 /**
  *
- * @package ReplyToUnihde
+ * @package ReplyToUnhide
  * @copyright (c) 2016 SiteSplat <http://sitesplat.com>
  * @license Proprietary
  *
diff --git "[ORIGINAL]/sitesplat\\replytounhide/core/bbcodes_installer.php" "[FORUM_EXT]/sitesplat\\replytounhide/core/bbcodes_installer.php"
--- "[ORIGINAL]/sitesplat\\replytounhide/core/bbcodes_installer.php"
+++ "[FORUM_EXT]/sitesplat\\replytounhide/core/bbcodes_installer.php"
@@ -1,7 +1,7 @@
 <?php
 /**
  *
- * @package ReplyToUnihde
+ * @package ReplyToUnhide
  * @copyright (c) 2016 SiteSplat <http://sitesplat.com>
  * @license Proprietary
  *
diff --git "[ORIGINAL]/sitesplat\\replytounhide/core/bbcodes_migration_base.php" "[FORUM_EXT]/sitesplat\\replytounhide/core/bbcodes_migration_base.php"
--- "[ORIGINAL]/sitesplat\\replytounhide/core/bbcodes_migration_base.php"
+++ "[FORUM_EXT]/sitesplat\\replytounhide/core/bbcodes_migration_base.php"
@@ -1,7 +1,7 @@
 <?php
 /**
  *
- * @package ReplyToUnihde
+ * @package ReplyToUnhide
  * @copyright (c) 2016 SiteSplat <http://sitesplat.com>
  * @license Proprietary
  *
diff --git "[ORIGINAL]/sitesplat\\replytounhide/core/bbcodes_parser.php" "[FORUM_EXT]/sitesplat\\replytounhide/core/bbcodes_parser.php"
--- "[ORIGINAL]/sitesplat\\replytounhide/core/bbcodes_parser.php"
+++ "[FORUM_EXT]/sitesplat\\replytounhide/core/bbcodes_parser.php"
@@ -1,8 +1,8 @@
 <?php
 /**
  *
- * @package ReplyToUnihde
- * @copyright (c) 2016 SiteSplat <https://sitesplat.com>
+ * @package ReplyToUnhide
+ * @copyright (c) 2016 SiteSplat <http://sitesplat.com>
  * @license Proprietary
  *
  */
@@ -10,6 +10,7 @@
 namespace sitesplat\replytounhide\core;
 
 use phpbb\user;
+use phpbb\auth\auth;
 use sitesplat\replytounhide\ext;
 
 /**
@@ -18,13 +19,15 @@ use sitesplat\replytounhide\ext;
 class bbcodes_parser
 {
 	protected $user;
+	protected $auth;
 
 	/**
 	 * Constructor
 	 */
-	public function __construct(user $user)
+	public function __construct(user $user, auth $auth)
 	{
 		$this->user = $user;
+		$this->auth = $auth;
 		$this->replied = 0;
 	}
 
@@ -47,27 +50,38 @@ class bbcodes_parser
 		return $text;
 	}
 
+	/**
+	 * Check if admin or moderador or special groups
+	 */
+	public function skip_check()
+	{
+		if ($this->auth->acl_get('a_') || $this->auth->acl_get('m_'))
+		{
+			$this->replied = 1;
+		}
+	}
+
 	/**
 	 * Convert Hide BBCode into its final appearance
 	 */
 	protected function hidden_pass($matches)
 	{
-		if ((!$this->replied && strpos($this->user->data['session_page'], 'mcp') === false) || $this->user->data['user_id'] == ANONYMOUS || $this->user->data['is_bot'])
+		// If moderator or admin, skip check, auto unhide
+		$this->skip_check();
+
+		if (!$this->replied || $this->user->data['user_id'] == ANONYMOUS || $this->user->data['is_bot'])
 		{
 			$replacements = array(
 				$this->user->lang('HIDE_ON'),
 				$this->user->lang('HIDE_EXPLAIN'),
 				'hidebox_hidden',
 			);
-		} else
+			return vsprintf('<div class="hidebox %3$s"><div class="hidebox_title %3$s">%1$s</div><div class="%3$s">%2$s</div></div>', $replacements);
+		}
+		else
 		{
-			$replacements = array(
-				$this->user->lang('HIDE_OFF'),
-				$matches[1],
-				'hidebox_visible',
-			);
+			$replacements = array($matches[1]);
+			return vsprintf('%1$s', $replacements);
 		}
-
-		return vsprintf('<div class="hidebox %3$s"><div class="hidebox_title %3$s">%1$s</div><div class="%3$s">%2$s</div></div>', $replacements);
 	}
 }
diff --git "[FORUM_EXT]/sitesplat\\replytounhide/diff_full.tmp" "[FORUM_EXT]/sitesplat\\replytounhide/diff_full.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\replytounhide/diff_full.tmp"
@@ -0,0 +1,802 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\replytounhide/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/composer.json"
+index 04ffe45cc..576442360 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\replytounhide/composer.json"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/composer.json"
+@@ -2,10 +2,10 @@
+     "name": "sitesplat/replytounhide",
+     "type": "phpbb-extension",
+     "description": "Hides the content places within the hide bbcode for guests and also for registered users who have not replied to that topic yet",
+-	"homepage": "https://sitesplat.com",
++	"homepage": "http://sitesplat.com",
+     "version": "1.0.1",
+     "keywords": ["phpbb", "posts", "extension"],
+-    "license": "Proprietary/All rights reserved",
++    "license": "@license Proprietary",
+     "authors": [
+         {
+ 			"name": "SiteSplat",
+@@ -22,13 +22,12 @@
+     "extra": {
+         "display-name": "ReplyToUnhide",
+         "soft-require": {
+-            "phpbb/phpbb": ">=3.2.0,<3.3.0@dev"
++            "phpbb/phpbb": "3.1.6"
+         },
+ 		"version-check": {
+-            "host": "sitesplat.com",
+-            "directory": "/updatecheck/phpbb32/ext",
+-            "filename": "replytounhide.json",
+-			"ssl": true
++            "host": "www.sitesplat.com",
++            "directory": "/updatecheck/phpbb31/ext",
++            "filename": "replytounhide.json"
+ 		}
+     }
+ }
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\replytounhide/config/services.yml" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/config/services.yml"
+index d45b38a81..1a17f5a0f 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\replytounhide/config/services.yml"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/config/services.yml"
+@@ -1,8 +1,12 @@
++imports:
++    - { resource: tables.yml }
++
+ services:
+     sitesplat.replytounhide.bbcodes_parser:
+         class: sitesplat\replytounhide\core\bbcodes_parser
+         arguments:
+             - '@user'
++            - '@auth'
+ 
+     sitesplat.replytounhide.acp_manager:
+         class: sitesplat\replytounhide\core\acp_manager
+@@ -17,8 +21,10 @@ services:
+             - '@sitesplat.replytounhide.bbcodes_parser'
+             - '@controller.helper'
+             - '@template'
++            - '@auth'
+             - '@user'
+             - '@dbal.conn'
++            - '%sitesplat.replytounhide.table.likes%'
+             - ext/sitesplat/replytounhide/
+         tags:
+             - { name: event.listener }
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/config/tables.yml" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/config/tables.yml"
+new file mode 100644
+index 000000000..6f6dde136
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/config/tables.yml"
+@@ -0,0 +1,2 @@
++parameters:
++    sitesplat.replytounhide.table.likes: '%core.table_prefix%likes'
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\replytounhide/core/acp_manager.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/core/acp_manager.php"
+index 40b9c33b6..56fb149ed 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\replytounhide/core/acp_manager.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/core/acp_manager.php"
+@@ -1,7 +1,7 @@
+ <?php
+ /**
+  *
+- * @package ReplyToUnihde
++ * @package ReplyToUnhide
+  * @copyright (c) 2016 SiteSplat <http://sitesplat.com>
+  * @license Proprietary
+  *
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\replytounhide/core/bbcodes_installer.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/core/bbcodes_installer.php"
+index a22537a97..e8dcfa6fc 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\replytounhide/core/bbcodes_installer.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/core/bbcodes_installer.php"
+@@ -1,7 +1,7 @@
+ <?php
+ /**
+  *
+- * @package ReplyToUnihde
++ * @package ReplyToUnhide
+  * @copyright (c) 2016 SiteSplat <http://sitesplat.com>
+  * @license Proprietary
+  *
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\replytounhide/core/bbcodes_migration_base.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/core/bbcodes_migration_base.php"
+index a8ea323d9..3f31f60d1 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\replytounhide/core/bbcodes_migration_base.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/core/bbcodes_migration_base.php"
+@@ -1,7 +1,7 @@
+ <?php
+ /**
+  *
+- * @package ReplyToUnihde
++ * @package ReplyToUnhide
+  * @copyright (c) 2016 SiteSplat <http://sitesplat.com>
+  * @license Proprietary
+  *
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\replytounhide/core/bbcodes_parser.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/core/bbcodes_parser.php"
+index 0bf901208..50d4d4129 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\replytounhide/core/bbcodes_parser.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/core/bbcodes_parser.php"
+@@ -1,8 +1,8 @@
+ <?php
+ /**
+  *
+- * @package ReplyToUnihde
+- * @copyright (c) 2016 SiteSplat <https://sitesplat.com>
++ * @package ReplyToUnhide
++ * @copyright (c) 2016 SiteSplat <http://sitesplat.com>
+  * @license Proprietary
+  *
+  */
+@@ -10,6 +10,7 @@
+ namespace sitesplat\replytounhide\core;
+ 
+ use phpbb\user;
++use phpbb\auth\auth;
+ use sitesplat\replytounhide\ext;
+ 
+ /**
+@@ -18,13 +19,15 @@ use sitesplat\replytounhide\ext;
+ class bbcodes_parser
+ {
+ 	protected $user;
++	protected $auth;
+ 
+ 	/**
+ 	 * Constructor
+ 	 */
+-	public function __construct(user $user)
++	public function __construct(user $user, auth $auth)
+ 	{
+ 		$this->user = $user;
++		$this->auth = $auth;
+ 		$this->replied = 0;
+ 	}
+ 
+@@ -47,27 +50,38 @@ class bbcodes_parser
+ 		return $text;
+ 	}
+ 
++	/**
++	 * Check if admin or moderador or special groups
++	 */
++	public function skip_check()
++	{
++		if ($this->auth->acl_get('a_') || $this->auth->acl_get('m_'))
++		{
++			$this->replied = 1;
++		}
++	}
++
+ 	/**
+ 	 * Convert Hide BBCode into its final appearance
+ 	 */
+ 	protected function hidden_pass($matches)
+ 	{
+-		if ((!$this->replied && strpos($this->user->data['session_page'], 'mcp') === false) || $this->user->data['user_id'] == ANONYMOUS || $this->user->data['is_bot'])
++		// If moderator or admin, skip check, auto unhide
++		$this->skip_check();
++
++		if (!$this->replied || $this->user->data['user_id'] == ANONYMOUS || $this->user->data['is_bot'])
+ 		{
+ 			$replacements = array(
+ 				$this->user->lang('HIDE_ON'),
+ 				$this->user->lang('HIDE_EXPLAIN'),
+ 				'hidebox_hidden',
+ 			);
+-		} else
++			return vsprintf('<div class="hidebox %3$s"><div class="hidebox_title %3$s">%1$s</div><div class="%3$s">%2$s</div></div>', $replacements);
++		}
++		else
+ 		{
+-			$replacements = array(
+-				$this->user->lang('HIDE_OFF'),
+-				$matches[1],
+-				'hidebox_visible',
+-			);
++			$replacements = array($matches[1]);
++			return vsprintf('%1$s', $replacements);
+ 		}
+-
+-		return vsprintf('<div class="hidebox %3$s"><div class="hidebox_title %3$s">%1$s</div><div class="%3$s">%2$s</div></div>', $replacements);
+ 	}
+ }
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/diff_full.tmp"
+new file mode 100644
+index 000000000..f05f500c5
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/diff_full.tmp"
+@@ -0,0 +1,86 @@
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\replytounhide/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/composer.json"
++index 04ffe45cc..576442360 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\replytounhide/composer.json"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/composer.json"
++@@ -2,10 +2,10 @@
++     "name": "sitesplat/replytounhide",
++     "type": "phpbb-extension",
++     "description": "Hides the content places within the hide bbcode for guests and also for registered users who have not replied to that topic yet",
++-	"homepage": "https://sitesplat.com",
+++	"homepage": "http://sitesplat.com",
++     "version": "1.0.1",
++     "keywords": ["phpbb", "posts", "extension"],
++-    "license": "Proprietary/All rights reserved",
+++    "license": "@license Proprietary",
++     "authors": [
++         {
++ 			"name": "SiteSplat",
++@@ -22,13 +22,12 @@
++     "extra": {
++         "display-name": "ReplyToUnhide",
++         "soft-require": {
++-            "phpbb/phpbb": ">=3.2.0,<3.3.0@dev"
+++            "phpbb/phpbb": "3.1.6"
++         },
++ 		"version-check": {
++-            "host": "sitesplat.com",
++-            "directory": "/updatecheck/phpbb32/ext",
++-            "filename": "replytounhide.json",
++-			"ssl": true
+++            "host": "www.sitesplat.com",
+++            "directory": "/updatecheck/phpbb31/ext",
+++            "filename": "replytounhide.json"
++ 		}
++     }
++ }
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\replytounhide/config/services.yml" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/config/services.yml"
++index d45b38a81..1a17f5a0f 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\replytounhide/config/services.yml"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/config/services.yml"
++@@ -1,8 +1,12 @@
+++imports:
+++    - { resource: tables.yml }
+++
++ services:
++     sitesplat.replytounhide.bbcodes_parser:
++         class: sitesplat\replytounhide\core\bbcodes_parser
++         arguments:
++             - '@user'
+++            - '@auth'
++ 
++     sitesplat.replytounhide.acp_manager:
++         class: sitesplat\replytounhide\core\acp_manager
++@@ -17,8 +21,10 @@ services:
++             - '@sitesplat.replytounhide.bbcodes_parser'
++             - '@controller.helper'
++             - '@template'
+++            - '@auth'
++             - '@user'
++             - '@dbal.conn'
+++            - '%sitesplat.replytounhide.table.likes%'
++             - ext/sitesplat/replytounhide/
++         tags:
++             - { name: event.listener }
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/config/tables.yml" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/config/tables.yml"
++new file mode 100644
++index 000000000..6f6dde136
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/config/tables.yml"
++@@ -0,0 +1,2 @@
+++parameters:
+++    sitesplat.replytounhide.table.likes: '%core.table_prefix%likes'
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\replytounhide/core/acp_manager.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/core/acp_manager.php"
++index 40b9c33b6..56fb149ed 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\replytounhide/core/acp_manager.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/core/acp_manager.php"
++@@ -1,7 +1,7 @@
++ <?php
++ /**
++  *
++- * @package ReplyToUnihde
+++ * @package ReplyToUnhide
++  * @copyright (c) 2016 SiteSplat <http://sitesplat.com>
++  * @license Proprietary
++  *
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\replytounhide/event/listener.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/event/listener.php"
+index 097e8bc1c..843794f4b 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\replytounhide/event/listener.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/event/listener.php"
+@@ -1,7 +1,7 @@
+ <?php
+ /**
+  *
+- * @package ReplyToUnihde
++ * @package ReplyToUnhide
+  * @copyright (c) 2016 SiteSplat <http://sitesplat.com>
+  * @license Proprietary
+  *
+@@ -11,6 +11,7 @@ namespace sitesplat\replytounhide\event;
+ 
+ use phpbb\controller\helper;
+ use phpbb\template\template;
++use phpbb\auth\auth;
+ use phpbb\user;
+ use phpbb\db\driver\driver_interface;
+ use Symfony\Component\EventDispatcher\EventSubscriberInterface;
+@@ -25,21 +26,25 @@ class listener implements EventSubscriberInterface
+ 	protected $bbcodes_parser;
+ 	protected $helper;
+ 	protected $template;
++	protected $auth;
+ 	protected $user;
+ 	protected $db;
++	protected $table_likes;
+ 	protected $ext_root_path;
+ 
+ 	/**
+ 	 * Constructor
+ 	 *
+ 	 */
+-	public function __construct(bbcodes_parser $bbcodes_parser, helper $helper, template $template, user $user, driver_interface $db, $ext_root_path)
++	public function __construct(bbcodes_parser $bbcodes_parser, helper $helper, template $template, auth $auth, user $user, driver_interface $db, $table_likes, $ext_root_path)
+ 	{
+ 		$this->bbcodes_parser = $bbcodes_parser;
+ 		$this->helper = $helper;
+ 		$this->template = $template;
++		$this->auth = $auth;
+ 		$this->user = $user;
+ 		$this->db = $db;
++		$this->table_likes = $table_likes;
+ 		$this->ext_root_path = $ext_root_path;
+ 	}
+ 
+@@ -54,12 +59,12 @@ class listener implements EventSubscriberInterface
+ 			// functions_content events
+ 			'core.modify_text_for_display_before'			=> 'parse_bbcodes_before',
+ 			'core.modify_text_for_display_after'			=> 'parse_bbcodes_after',
+-			'core.viewtopic_modify_post_data'				=> 'hide_attachment',
+-			'core.mcp_topic_modify_post_data'				=> 'in_mcp',
+-			
++
+ 			// functions_display events
+-			'core.viewtopic_assign_template_vars_before'	=> 'find_replies',
+-			'core.bbtranslate_translate_vars_before'		=> 'find_replies',
++			'core.viewtopic_assign_template_vars_before'	=> 'find_replies_for_topic',
++			'core.bbtranslate_translate_vars_before'		=> 'find_replies_for_topic',
++			'core.posting_modify_message_text'				=> 'find_replies_for_post',
++
+ 			'core.posting_modify_template_vars'				=> 'delete_hidden',
+ 			'core.topic_review_modify_row'					=> 'delete_hidden_review',
+ 
+@@ -82,41 +87,81 @@ class listener implements EventSubscriberInterface
+ 	}
+ 
+ 	/**
+-	 * MCP settings
++	 * Check if can skip
+ 	 */
+-	public function in_mcp($event)
++	public function check_can_skip($event, $type = 'topic')
+ 	{
+-		$this->bbcodes_parser->replied = 1;
++		$idAdmin = (bool) $this->auth->acl_get('a_');
++		$isModerator = (bool) $this->auth->acl_get('m_', $event['forum_id']);
++		$isSpecialGroup = ($this->user->data['group_id'] == 18 && in_array($event['forum_id'], array(127, 128, 129, 130, 131, 132, 175, 198)));
++		$isPoster = (
++			(int) $this->user->data['user_id'] === (
++				$type === 'topic'
++					? (int) (
++						isset($event['topic_data'])
++							? $event['topic_data']['topic_poster']
++							: $event['row']['poster_id']
++					)
++					: (int) $event['post_data']['poster_id']
++			)
++		);
++
++		if ($isSpecialGroup || $idAdmin || $isModerator || $isPoster) {
++			$this->bbcodes_parser->replied = 1;
++			return true;
++		}
++
++		return false;
+ 	}
+-	
++
+ 	/**
+-	 * Hide attachement
++	 * Find post_id of post
+ 	 */
+-	public function hide_attachment($event)
++	public function find_replies_for_topic($event)
+ 	{
+-		if (!$this->bbcodes_parser->replied)
+-		{
+-			$attach = $event['has_approved_attachments'];
+-			
+-			$attach = false;
+-			$event['has_approved_attachments'] = $attach;
+-			
+-			$attachments = $event['attachments'];
+-			$attachments = array();
+-			$event['attachments'] = $attachments;
++		$this->find_replies($event, 'topic');
++	}
++
++	/**
++	 * Find post_id of post
++	 */
++	public function find_replies_for_post($event)
++	{
++		$this->find_replies($event, 'post');
++	}
++
++	/**
++	 * Find post_id of topic or preview
++	 */
++	public function find_replies($event, $type = 'topic')
++	{
++		if (!$this->check_can_skip($event, $type) && $this->user->data['user_id'] != ANONYMOUS) {
++			$post_id = $this->determine_post_id($event, $type);
++
++			//Replies
++			//$sql = 'SELECT COUNT(post_id) AS replied FROM ' . POSTS_TABLE . ' WHERE topic_id = ' . $event['topic_id'] . ' AND poster_id = ' . $this->user->data['user_id'];
++			//Thanks For Posts
++			//$sql = 'SELECT COUNT(post_id) AS replied FROM ' . $this->table_thanks . ' WHERE post_id = ' . $post_id . ' AND user_id = ' . $this->user->data['user_id'];
++			//Like BB
++			$sql = 'SELECT COUNT(post_id) AS replied FROM ' . $this->table_likes . ' WHERE post_id = ' . $post_id . ' AND user_id = ' . $this->user->data['user_id'];
++
++			$result = $this->db->sql_query($sql);
++			$this->bbcodes_parser->replied = $this->db->sql_fetchfield('replied');
+ 		}
+ 	}
+-	
++
+ 	/**
+-	 * Find topic_id of topic
++	 * Determine post_id based on event data
+ 	 */
+-	public function find_replies($event)
++	protected function determine_post_id($event, $type = 'topic')
+ 	{
+-		$sql = 'SELECT COUNT(post_id) AS replied 
+-				FROM ' . POSTS_TABLE . ' 
+-				WHERE post_visibility = 1 AND topic_id = ' . $event['topic_id'] . ' AND poster_id = ' . $this->user->data['user_id'];
+-		$result = $this->db->sql_query($sql);
+-		$this->bbcodes_parser->replied = $this->db->sql_fetchfield('replied');
++		if (empty($event[$type . '_data']['topic_first_post_id'])) {
++			if (empty($event['post_data']['topic_first_post_id'])) {
++				return $event['topic_id'];
++			}
++			return $event['post_data']['topic_first_post_id'];
++		}
++		return $event[$type . '_data']['topic_first_post_id'];
+ 	}
+ 
+ 	/**
+@@ -128,11 +173,7 @@ class listener implements EventSubscriberInterface
+ 		{
+ 			(!$this->bbcodes_parser->replied) ? $this->find_replies($event) : null;
+ 			$post_row  = $event['post_row'];
+-			$post_row['DECODED_MESSAGE'] = preg_replace('!\[hide\](.*?)\[/hide\]!is', '', $post_row['DECODED_MESSAGE']);
+-	
+-	//		$post_row['DECODED_MESSAGE'] = preg_replace_callback('!\[hide\](.*?)\[/hide\]!is', function ($matches) {return strtolower($matches[0]);}, $post_row['DECODED_MESSAGE']);	
+-	//		$post_row['DECODED_MESSAGE'] = preg_replace_callback('![hide](.*?)[/hide]!is', function ($match) { return ''; }, $post_row['DECODED_MESSAGE']);
+-			
++			$post_row['DECODED_MESSAGE'] = preg_replace('!\[hide\](.*?)\[/hide\]!is', '- Conteúdo Protegido -', $post_row['DECODED_MESSAGE']);
+ 			$event['post_row'] = $post_row;
+ 		}
+ 	}
+@@ -142,15 +183,10 @@ class listener implements EventSubscriberInterface
+ 	 */
+ 	public function delete_hidden($event)
+ 	{
+-		if ($event['mode'] == 'quote')
++		if ($event['mode'] == 'quote' && !$this->check_can_skip($event, 'post'))
+ 		{
+ 			$page_data  = $event['page_data'];
+-
+-			$page_data['MESSAGE'] = preg_replace('!\[hide\](.*?)\[/hide\]!is', '', $page_data['MESSAGE']);
+-
+-		//	$page_data['MESSAGE'] = preg_replace_callback('!\[hide\](.*?)\[/hide\]!is', function ($matches) {return strtolower($matches[0]);}, $page_data['MESSAGE']);
+-		//	$page_data['MESSAGE'] = preg_replace_callback('![hide](.*?)[/hide]!is', function ($match) { return ''; }, $page_data['MESSAGE']);
+-		
++			$page_data['MESSAGE'] = preg_replace('!\[hide\](.*?)\[/hide\]!is', '- Conteúdo Protegido -', $page_data['MESSAGE']);
+ 			$event['page_data'] = $page_data;
+ 		}
+ 	}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\replytounhide/ext.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/ext.php"
+index 170239971..7dbc59291 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\replytounhide/ext.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/ext.php"
+@@ -1,7 +1,7 @@
+ <?php
+ /**
+  *
+- * @package ReplyToUnihde
++ * @package ReplyToUnhide
+  * @copyright (c) 2016 SiteSplat <http://sitesplat.com>
+  * @license Proprietary
+  *
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\replytounhide/language/en/info_acp_replytounhide.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/language/en/info_acp_replytounhide.php"
+index f6ed27628..f0f921996 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\replytounhide/language/en/info_acp_replytounhide.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/language/en/info_acp_replytounhide.php"
+@@ -1,7 +1,7 @@
+ <?php
+ /**
+  *
+- * @package ReplyToUnihde
++ * @package ReplyToUnhide
+  * @copyright (c) 2016 SiteSplat <http://sitesplat.com>
+  * @license Proprietary
+  *
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\replytounhide/language/en/replytounhide.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/language/en/replytounhide.php"
+index 66eb07b6f..98b327e11 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\replytounhide/language/en/replytounhide.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/language/en/replytounhide.php"
+@@ -1,7 +1,7 @@
+ <?php
+ /**
+ *
+- * @package ReplyToUnihde
++ * @package ReplyToUnhide
+  * @copyright (c) 2016 SiteSplat <http://sitesplat.com>
+  * @license Proprietary
+ *
+@@ -24,6 +24,6 @@ $lang = array_merge($lang, array(
+ 	// Hide BBCode
+ 	'HIDE_ON'		=> 'Hidden Content',
+ 	'HIDE_OFF'		=> 'Hidden Content (for members only)',
+-	'HIDE_EXPLAIN'	=> 'This board requires you to be registered, logged-in and to reply first to view the hidden content...',
++	'HIDE_EXPLAIN'	=> 'This board requires you to be registered, logged-in and to like topic to view the hidden content...',
+ 	'HIDE_HELPLINE'	=> '[hide]{TEXT}[/hide]'
+ ));
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/language/pt/info_acp_replytounhide.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/language/pt/info_acp_replytounhide.php"
+new file mode 100644
+index 000000000..f0f921996
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/language/pt/info_acp_replytounhide.php"
+@@ -0,0 +1,38 @@
++<?php
++/**
++ *
++ * @package ReplyToUnhide
++ * @copyright (c) 2016 SiteSplat <http://sitesplat.com>
++ * @license Proprietary
++ *
++ */
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
++$lang = array_merge($lang, array(
++    'REPLYTOUNHIDE_NOTICE'		=> '<div class="phpinfo"><p>There are no setting for this extenion. The BBcode HIDE is available to be used in posting page.</p></div>',
++	'SS_HELPER_NOTICE'			=> 'The BBcore extension does not exist!<br />Download the <a href="http://sitesplat.com">BBcore</a> and copy the folder into your sitesplat extension folder.',
++));
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/language/pt/replytounhide.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/language/pt/replytounhide.php"
+new file mode 100644
+index 000000000..7a143a773
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/language/pt/replytounhide.php"
+@@ -0,0 +1,29 @@
++<?php
++/**
++*
++ * @package ReplyToUnhide
++ * @copyright (c) 2016 SiteSplat <http://sitesplat.com>
++ * @license Proprietary
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
++$lang = array_merge($lang, array(
++	// Hide BBCode
++	'HIDE_ON'		=> 'Conteúdo Oculto',
++	'HIDE_OFF'		=> 'Conteúdo Oculto (Apenas para membros)',
++	'HIDE_EXPLAIN'	=> 'Precisas de <strong>agradecer</strong> o tópico para poderes visualizar o conteúdo.<br><br>Se estiver difícil... Procura por um botão como este: <a href="#thanks_button"><span class="btn-primary btn-sm">&nbsp;<i class="fa fa-thumbs-up"></i><strong>&nbsp;Agradecer</strong></span></a> Acreditamos em ti! Tu consegues encontrá-lo!',
++	'HIDE_HELPLINE'	=> '[hide]{TEXT}[/hide]'
++));
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/language/pt_preao/info_acp_replytounhide.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/language/pt_preao/info_acp_replytounhide.php"
+new file mode 100644
+index 000000000..f0f921996
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/language/pt_preao/info_acp_replytounhide.php"
+@@ -0,0 +1,38 @@
++<?php
++/**
++ *
++ * @package ReplyToUnhide
++ * @copyright (c) 2016 SiteSplat <http://sitesplat.com>
++ * @license Proprietary
++ *
++ */
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
++$lang = array_merge($lang, array(
++    'REPLYTOUNHIDE_NOTICE'		=> '<div class="phpinfo"><p>There are no setting for this extenion. The BBcode HIDE is available to be used in posting page.</p></div>',
++	'SS_HELPER_NOTICE'			=> 'The BBcore extension does not exist!<br />Download the <a href="http://sitesplat.com">BBcore</a> and copy the folder into your sitesplat extension folder.',
++));
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/language/pt_preao/replytounhide.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/language/pt_preao/replytounhide.php"
+new file mode 100644
+index 000000000..21209f562
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/language/pt_preao/replytounhide.php"
+@@ -0,0 +1,29 @@
++<?php
++/**
++*
++ * @package ReplyToUnhide
++ * @copyright (c) 2016 SiteSplat <http://sitesplat.com>
++ * @license Proprietary
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
++$lang = array_merge($lang, array(
++	// Hide BBCode
++	'HIDE_ON'		=> 'Conteúdo Oculto',
++	'HIDE_OFF'		=> 'Conteúdo Oculto (Apenas para membros)',
++	'HIDE_EXPLAIN'	=> 'Precisas de <strong>agradecer</strong> o tópico para poderes visualizar o conteúdo.<br><br>Se estiver difícil... Procura por um botão como este: <span class="btn-primary btn-sm">&nbsp;<i class="fa fa-thumbs-up"></i><strong>&nbsp;Agradecer</strong></span> Acreditamos em ti! Tu consegues encontrá-lo!',
++	'HIDE_HELPLINE'	=> '[hide]{TEXT}[/hide]'
++));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\replytounhide/migrations/v31x/m1_initial_data.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/migrations/v31x/m1_initial_data.php"
+index 54a21e9ae..acf27fb85 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\replytounhide/migrations/v31x/m1_initial_data.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/migrations/v31x/m1_initial_data.php"
+@@ -1,7 +1,7 @@
+ <?php
+ /**
+  *
+- * @package ReplyToUnihde
++ * @package ReplyToUnhide
+  * @copyright (c) 2016 SiteSplat <http://sitesplat.com>
+  * @license Proprietary
+  *
+@@ -39,8 +39,7 @@ class m1_initial_data extends \sitesplat\replytounhide\core\bbcodes_migration_ba
+ 		'hide' => [
+ 			'bbcode_helpline'	=> 'HIDE_HELPLINE',
+ 			'bbcode_match'		=> '[hide]{TEXT}[/hide]',
+-			'bbcode_tpl'		=> '<!-- BBCODE_HIDE -->{TEXT}<!-- BBCODE_HIDE -->',
+-            'display_on_posting'=> 0
++			'bbcode_tpl'		=> '<!-- BBCODE_HIDE -->{TEXT}<!-- BBCODE_HIDE -->'
+ 		]
+ 	];
+ }
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/styles/FLATBOOTS/theme/replytounhide.css" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/styles/FLATBOOTS/theme/replytounhide.css"
+new file mode 100644
+index 000000000..0475a5ad8
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/styles/FLATBOOTS/theme/replytounhide.css"
+@@ -0,0 +1,28 @@
++/* [hidden] hide BBCode */
++.hidebox {
++	position: relative;
++	margin: 5px 0;
++	font-weight: normal;
++	padding: 39px 19px 14px;
++	background-color: #c5e3bf;
++	border: 1px solid #72B173;
++	border-radius: 4px;
++}
++.hidebox_title {
++	position: absolute;
++	top: -1px;
++	left: -1px;
++	font-weight: bold;
++	font-size: 12px;
++	color: #2f4f2f;
++	padding: 5px 12px;
++	border: 1px solid #72B173;
++	border-radius: 4px 0 4px 0;
++}
++.hidebox_hidden {
++	background-color: #f2dede;
++	border-color: #ebccd1;
++	color: #80001c;
++}
++
++.hidebox_visible { color: #2f4f2f }
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\replytounhide/styles/FLATBOOTS/theme/replytounhide.min.css" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/styles/FLATBOOTS/theme/replytounhide.min.css"
+index 0475a5ad8..8eff2047f 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\replytounhide/styles/FLATBOOTS/theme/replytounhide.min.css"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/styles/FLATBOOTS/theme/replytounhide.min.css"
+@@ -1,28 +1 @@
+-/* [hidden] hide BBCode */
+-.hidebox {
+-	position: relative;
+-	margin: 5px 0;
+-	font-weight: normal;
+-	padding: 39px 19px 14px;
+-	background-color: #c5e3bf;
+-	border: 1px solid #72B173;
+-	border-radius: 4px;
+-}
+-.hidebox_title {
+-	position: absolute;
+-	top: -1px;
+-	left: -1px;
+-	font-weight: bold;
+-	font-size: 12px;
+-	color: #2f4f2f;
+-	padding: 5px 12px;
+-	border: 1px solid #72B173;
+-	border-radius: 4px 0 4px 0;
+-}
+-.hidebox_hidden {
+-	background-color: #f2dede;
+-	border-color: #ebccd1;
+-	color: #80001c;
+-}
+-
+-.hidebox_visible { color: #2f4f2f }
++.hidebox{position:relative;margin:5px 0;font-weight:400;padding:39px 19px 14px;background-color:#c5e3bf;border:1px solid #72B173;border-radius:4px}.hidebox_title{position:absolute;top:-1px;left:-1px;font-weight:700;font-size:12px;color:#2f4f2f;padding:5px 12px;border:1px solid #72B173;border-radius:4px 0 4px 0}.hidebox_hidden{background-color:#f2dede;border-color:#ebccd1;color:#80001c}.hidebox_visible{color:#2f4f2f}
+\ No newline at end of file
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/todo" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/todo"
+new file mode 100644
+index 000000000..07e9a720d
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/todo"
+@@ -0,0 +1,3 @@
++-group permission
++-issue with full post preview ?
++-check it with BBpreview
+\ No newline at end of file
diff --git "[FORUM_EXT]/sitesplat\\replytounhide/diff_nospace.tmp" "[FORUM_EXT]/sitesplat\\replytounhide/diff_nospace.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\replytounhide/diff_nospace.tmp"
@@ -0,0 +1,963 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\replytounhide/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/composer.json"
+index 04ffe45cc..576442360 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\replytounhide/composer.json"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/composer.json"
+@@ -2,10 +2,10 @@
+     "name": "sitesplat/replytounhide",
+     "type": "phpbb-extension",
+     "description": "Hides the content places within the hide bbcode for guests and also for registered users who have not replied to that topic yet",
+-	"homepage": "https://sitesplat.com",
++	"homepage": "http://sitesplat.com",
+     "version": "1.0.1",
+     "keywords": ["phpbb", "posts", "extension"],
+-    "license": "Proprietary/All rights reserved",
++    "license": "@license Proprietary",
+     "authors": [
+         {
+ 			"name": "SiteSplat",
+@@ -22,13 +22,12 @@
+     "extra": {
+         "display-name": "ReplyToUnhide",
+         "soft-require": {
+-            "phpbb/phpbb": ">=3.2.0,<3.3.0@dev"
++            "phpbb/phpbb": "3.1.6"
+         },
+ 		"version-check": {
+-            "host": "sitesplat.com",
+-            "directory": "/updatecheck/phpbb32/ext",
+-            "filename": "replytounhide.json",
+-			"ssl": true
++            "host": "www.sitesplat.com",
++            "directory": "/updatecheck/phpbb31/ext",
++            "filename": "replytounhide.json"
+ 		}
+     }
+ }
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\replytounhide/config/services.yml" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/config/services.yml"
+index d45b38a81..1a17f5a0f 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\replytounhide/config/services.yml"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/config/services.yml"
+@@ -1,8 +1,12 @@
++imports:
++    - { resource: tables.yml }
++
+ services:
+     sitesplat.replytounhide.bbcodes_parser:
+         class: sitesplat\replytounhide\core\bbcodes_parser
+         arguments:
+             - '@user'
++            - '@auth'
+ 
+     sitesplat.replytounhide.acp_manager:
+         class: sitesplat\replytounhide\core\acp_manager
+@@ -17,8 +21,10 @@ services:
+             - '@sitesplat.replytounhide.bbcodes_parser'
+             - '@controller.helper'
+             - '@template'
++            - '@auth'
+             - '@user'
+             - '@dbal.conn'
++            - '%sitesplat.replytounhide.table.likes%'
+             - ext/sitesplat/replytounhide/
+         tags:
+             - { name: event.listener }
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/config/tables.yml" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/config/tables.yml"
+new file mode 100644
+index 000000000..6f6dde136
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/config/tables.yml"
+@@ -0,0 +1,2 @@
++parameters:
++    sitesplat.replytounhide.table.likes: '%core.table_prefix%likes'
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\replytounhide/core/acp_manager.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/core/acp_manager.php"
+index 40b9c33b6..56fb149ed 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\replytounhide/core/acp_manager.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/core/acp_manager.php"
+@@ -1,7 +1,7 @@
+ <?php
+ /**
+  *
+- * @package ReplyToUnihde
++ * @package ReplyToUnhide
+  * @copyright (c) 2016 SiteSplat <http://sitesplat.com>
+  * @license Proprietary
+  *
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\replytounhide/core/bbcodes_installer.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/core/bbcodes_installer.php"
+index a22537a97..e8dcfa6fc 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\replytounhide/core/bbcodes_installer.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/core/bbcodes_installer.php"
+@@ -1,7 +1,7 @@
+ <?php
+ /**
+  *
+- * @package ReplyToUnihde
++ * @package ReplyToUnhide
+  * @copyright (c) 2016 SiteSplat <http://sitesplat.com>
+  * @license Proprietary
+  *
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\replytounhide/core/bbcodes_migration_base.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/core/bbcodes_migration_base.php"
+index a8ea323d9..3f31f60d1 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\replytounhide/core/bbcodes_migration_base.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/core/bbcodes_migration_base.php"
+@@ -1,7 +1,7 @@
+ <?php
+ /**
+  *
+- * @package ReplyToUnihde
++ * @package ReplyToUnhide
+  * @copyright (c) 2016 SiteSplat <http://sitesplat.com>
+  * @license Proprietary
+  *
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\replytounhide/core/bbcodes_parser.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/core/bbcodes_parser.php"
+index 0bf901208..50d4d4129 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\replytounhide/core/bbcodes_parser.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/core/bbcodes_parser.php"
+@@ -1,8 +1,8 @@
+ <?php
+ /**
+  *
+- * @package ReplyToUnihde
+- * @copyright (c) 2016 SiteSplat <https://sitesplat.com>
++ * @package ReplyToUnhide
++ * @copyright (c) 2016 SiteSplat <http://sitesplat.com>
+  * @license Proprietary
+  *
+  */
+@@ -10,6 +10,7 @@
+ namespace sitesplat\replytounhide\core;
+ 
+ use phpbb\user;
++use phpbb\auth\auth;
+ use sitesplat\replytounhide\ext;
+ 
+ /**
+@@ -18,13 +19,15 @@ use sitesplat\replytounhide\ext;
+ class bbcodes_parser
+ {
+ 	protected $user;
++	protected $auth;
+ 
+ 	/**
+ 	 * Constructor
+ 	 */
+-	public function __construct(user $user)
++	public function __construct(user $user, auth $auth)
+ 	{
+ 		$this->user = $user;
++		$this->auth = $auth;
+ 		$this->replied = 0;
+ 	}
+ 
+@@ -47,27 +50,38 @@ class bbcodes_parser
+ 		return $text;
+ 	}
+ 
++	/**
++	 * Check if admin or moderador or special groups
++	 */
++	public function skip_check()
++	{
++		if ($this->auth->acl_get('a_') || $this->auth->acl_get('m_'))
++		{
++			$this->replied = 1;
++		}
++	}
++
+ 	/**
+ 	 * Convert Hide BBCode into its final appearance
+ 	 */
+ 	protected function hidden_pass($matches)
+ 	{
+-		if ((!$this->replied && strpos($this->user->data['session_page'], 'mcp') === false) || $this->user->data['user_id'] == ANONYMOUS || $this->user->data['is_bot'])
++		// If moderator or admin, skip check, auto unhide
++		$this->skip_check();
++
++		if (!$this->replied || $this->user->data['user_id'] == ANONYMOUS || $this->user->data['is_bot'])
+ 		{
+ 			$replacements = array(
+ 				$this->user->lang('HIDE_ON'),
+ 				$this->user->lang('HIDE_EXPLAIN'),
+ 				'hidebox_hidden',
+ 			);
+-		} else
++			return vsprintf('<div class="hidebox %3$s"><div class="hidebox_title %3$s">%1$s</div><div class="%3$s">%2$s</div></div>', $replacements);
++		}
++		else
+ 		{
+-			$replacements = array(
+-				$this->user->lang('HIDE_OFF'),
+-				$matches[1],
+-				'hidebox_visible',
+-			);
++			$replacements = array($matches[1]);
++			return vsprintf('%1$s', $replacements);
+ 		}
+-
+-		return vsprintf('<div class="hidebox %3$s"><div class="hidebox_title %3$s">%1$s</div><div class="%3$s">%2$s</div></div>', $replacements);
+ 	}
+ }
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/diff_full.tmp"
+new file mode 100644
+index 000000000..e38ed1076
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/diff_full.tmp"
+@@ -0,0 +1,802 @@
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\replytounhide/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/composer.json"
++index 04ffe45cc..576442360 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\replytounhide/composer.json"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/composer.json"
++@@ -2,10 +2,10 @@
++     "name": "sitesplat/replytounhide",
++     "type": "phpbb-extension",
++     "description": "Hides the content places within the hide bbcode for guests and also for registered users who have not replied to that topic yet",
++-	"homepage": "https://sitesplat.com",
+++	"homepage": "http://sitesplat.com",
++     "version": "1.0.1",
++     "keywords": ["phpbb", "posts", "extension"],
++-    "license": "Proprietary/All rights reserved",
+++    "license": "@license Proprietary",
++     "authors": [
++         {
++ 			"name": "SiteSplat",
++@@ -22,13 +22,12 @@
++     "extra": {
++         "display-name": "ReplyToUnhide",
++         "soft-require": {
++-            "phpbb/phpbb": ">=3.2.0,<3.3.0@dev"
+++            "phpbb/phpbb": "3.1.6"
++         },
++ 		"version-check": {
++-            "host": "sitesplat.com",
++-            "directory": "/updatecheck/phpbb32/ext",
++-            "filename": "replytounhide.json",
++-			"ssl": true
+++            "host": "www.sitesplat.com",
+++            "directory": "/updatecheck/phpbb31/ext",
+++            "filename": "replytounhide.json"
++ 		}
++     }
++ }
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\replytounhide/config/services.yml" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/config/services.yml"
++index d45b38a81..1a17f5a0f 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\replytounhide/config/services.yml"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/config/services.yml"
++@@ -1,8 +1,12 @@
+++imports:
+++    - { resource: tables.yml }
+++
++ services:
++     sitesplat.replytounhide.bbcodes_parser:
++         class: sitesplat\replytounhide\core\bbcodes_parser
++         arguments:
++             - '@user'
+++            - '@auth'
++ 
++     sitesplat.replytounhide.acp_manager:
++         class: sitesplat\replytounhide\core\acp_manager
++@@ -17,8 +21,10 @@ services:
++             - '@sitesplat.replytounhide.bbcodes_parser'
++             - '@controller.helper'
++             - '@template'
+++            - '@auth'
++             - '@user'
++             - '@dbal.conn'
+++            - '%sitesplat.replytounhide.table.likes%'
++             - ext/sitesplat/replytounhide/
++         tags:
++             - { name: event.listener }
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/config/tables.yml" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/config/tables.yml"
++new file mode 100644
++index 000000000..6f6dde136
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/config/tables.yml"
++@@ -0,0 +1,2 @@
+++parameters:
+++    sitesplat.replytounhide.table.likes: '%core.table_prefix%likes'
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\replytounhide/core/acp_manager.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/core/acp_manager.php"
++index 40b9c33b6..56fb149ed 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\replytounhide/core/acp_manager.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/core/acp_manager.php"
++@@ -1,7 +1,7 @@
++ <?php
++ /**
++  *
++- * @package ReplyToUnihde
+++ * @package ReplyToUnhide
++  * @copyright (c) 2016 SiteSplat <http://sitesplat.com>
++  * @license Proprietary
++  *
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\replytounhide/core/bbcodes_installer.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/core/bbcodes_installer.php"
++index a22537a97..e8dcfa6fc 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\replytounhide/core/bbcodes_installer.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/core/bbcodes_installer.php"
++@@ -1,7 +1,7 @@
++ <?php
++ /**
++  *
++- * @package ReplyToUnihde
+++ * @package ReplyToUnhide
++  * @copyright (c) 2016 SiteSplat <http://sitesplat.com>
++  * @license Proprietary
++  *
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\replytounhide/core/bbcodes_migration_base.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/core/bbcodes_migration_base.php"
++index a8ea323d9..3f31f60d1 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\replytounhide/core/bbcodes_migration_base.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/core/bbcodes_migration_base.php"
++@@ -1,7 +1,7 @@
++ <?php
++ /**
++  *
++- * @package ReplyToUnihde
+++ * @package ReplyToUnhide
++  * @copyright (c) 2016 SiteSplat <http://sitesplat.com>
++  * @license Proprietary
++  *
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\replytounhide/core/bbcodes_parser.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/core/bbcodes_parser.php"
++index 0bf901208..50d4d4129 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\replytounhide/core/bbcodes_parser.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/core/bbcodes_parser.php"
++@@ -1,8 +1,8 @@
++ <?php
++ /**
++  *
++- * @package ReplyToUnihde
++- * @copyright (c) 2016 SiteSplat <https://sitesplat.com>
+++ * @package ReplyToUnhide
+++ * @copyright (c) 2016 SiteSplat <http://sitesplat.com>
++  * @license Proprietary
++  *
++  */
++@@ -10,6 +10,7 @@
++ namespace sitesplat\replytounhide\core;
++ 
++ use phpbb\user;
+++use phpbb\auth\auth;
++ use sitesplat\replytounhide\ext;
++ 
++ /**
++@@ -18,13 +19,15 @@ use sitesplat\replytounhide\ext;
++ class bbcodes_parser
++ {
++ 	protected $user;
+++	protected $auth;
++ 
++ 	/**
++ 	 * Constructor
++ 	 */
++-	public function __construct(user $user)
+++	public function __construct(user $user, auth $auth)
++ 	{
++ 		$this->user = $user;
+++		$this->auth = $auth;
++ 		$this->replied = 0;
++ 	}
++ 
++@@ -47,27 +50,38 @@ class bbcodes_parser
++ 		return $text;
++ 	}
++ 
+++	/**
+++	 * Check if admin or moderador or special groups
+++	 */
+++	public function skip_check()
+++	{
+++		if ($this->auth->acl_get('a_') || $this->auth->acl_get('m_'))
+++		{
+++			$this->replied = 1;
+++		}
+++	}
+++
++ 	/**
++ 	 * Convert Hide BBCode into its final appearance
++ 	 */
++ 	protected function hidden_pass($matches)
++ 	{
++-		if ((!$this->replied && strpos($this->user->data['session_page'], 'mcp') === false) || $this->user->data['user_id'] == ANONYMOUS || $this->user->data['is_bot'])
+++		// If moderator or admin, skip check, auto unhide
+++		$this->skip_check();
+++
+++		if (!$this->replied || $this->user->data['user_id'] == ANONYMOUS || $this->user->data['is_bot'])
++ 		{
++ 			$replacements = array(
++ 				$this->user->lang('HIDE_ON'),
++ 				$this->user->lang('HIDE_EXPLAIN'),
++ 				'hidebox_hidden',
++ 			);
++-		} else
+++			return vsprintf('<div class="hidebox %3$s"><div class="hidebox_title %3$s">%1$s</div><div class="%3$s">%2$s</div></div>', $replacements);
+++		}
+++		else
++ 		{
++-			$replacements = array(
++-				$this->user->lang('HIDE_OFF'),
++-				$matches[1],
++-				'hidebox_visible',
++-			);
+++			$replacements = array($matches[1]);
+++			return vsprintf('%1$s', $replacements);
++ 		}
++-
++-		return vsprintf('<div class="hidebox %3$s"><div class="hidebox_title %3$s">%1$s</div><div class="%3$s">%2$s</div></div>', $replacements);
++ 	}
++ }
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/diff_full.tmp"
++new file mode 100644
++index 000000000..f05f500c5
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/diff_full.tmp"
++@@ -0,0 +1,86 @@
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\replytounhide/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/composer.json"
+++index 04ffe45cc..576442360 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\replytounhide/composer.json"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/composer.json"
+++@@ -2,10 +2,10 @@
+++     "name": "sitesplat/replytounhide",
+++     "type": "phpbb-extension",
+++     "description": "Hides the content places within the hide bbcode for guests and also for registered users who have not replied to that topic yet",
+++-	"homepage": "https://sitesplat.com",
++++	"homepage": "http://sitesplat.com",
+++     "version": "1.0.1",
+++     "keywords": ["phpbb", "posts", "extension"],
+++-    "license": "Proprietary/All rights reserved",
++++    "license": "@license Proprietary",
+++     "authors": [
+++         {
+++ 			"name": "SiteSplat",
+++@@ -22,13 +22,12 @@
+++     "extra": {
+++         "display-name": "ReplyToUnhide",
+++         "soft-require": {
+++-            "phpbb/phpbb": ">=3.2.0,<3.3.0@dev"
++++            "phpbb/phpbb": "3.1.6"
+++         },
+++ 		"version-check": {
+++-            "host": "sitesplat.com",
+++-            "directory": "/updatecheck/phpbb32/ext",
+++-            "filename": "replytounhide.json",
+++-			"ssl": true
++++            "host": "www.sitesplat.com",
++++            "directory": "/updatecheck/phpbb31/ext",
++++            "filename": "replytounhide.json"
+++ 		}
+++     }
+++ }
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\replytounhide/config/services.yml" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/config/services.yml"
+++index d45b38a81..1a17f5a0f 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\replytounhide/config/services.yml"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/config/services.yml"
+++@@ -1,8 +1,12 @@
++++imports:
++++    - { resource: tables.yml }
++++
+++ services:
+++     sitesplat.replytounhide.bbcodes_parser:
+++         class: sitesplat\replytounhide\core\bbcodes_parser
+++         arguments:
+++             - '@user'
++++            - '@auth'
+++ 
+++     sitesplat.replytounhide.acp_manager:
+++         class: sitesplat\replytounhide\core\acp_manager
+++@@ -17,8 +21,10 @@ services:
+++             - '@sitesplat.replytounhide.bbcodes_parser'
+++             - '@controller.helper'
+++             - '@template'
++++            - '@auth'
+++             - '@user'
+++             - '@dbal.conn'
++++            - '%sitesplat.replytounhide.table.likes%'
+++             - ext/sitesplat/replytounhide/
+++         tags:
+++             - { name: event.listener }
+++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/config/tables.yml" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/config/tables.yml"
+++new file mode 100644
+++index 000000000..6f6dde136
+++--- /dev/null
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/config/tables.yml"
+++@@ -0,0 +1,2 @@
++++parameters:
++++    sitesplat.replytounhide.table.likes: '%core.table_prefix%likes'
+++\ No newline at end of file
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\replytounhide/core/acp_manager.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/core/acp_manager.php"
+++index 40b9c33b6..56fb149ed 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\replytounhide/core/acp_manager.php"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/core/acp_manager.php"
+++@@ -1,7 +1,7 @@
+++ <?php
+++ /**
+++  *
+++- * @package ReplyToUnihde
++++ * @package ReplyToUnhide
+++  * @copyright (c) 2016 SiteSplat <http://sitesplat.com>
+++  * @license Proprietary
+++  *
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\replytounhide/event/listener.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/event/listener.php"
++index 097e8bc1c..843794f4b 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\replytounhide/event/listener.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/event/listener.php"
++@@ -1,7 +1,7 @@
++ <?php
++ /**
++  *
++- * @package ReplyToUnihde
+++ * @package ReplyToUnhide
++  * @copyright (c) 2016 SiteSplat <http://sitesplat.com>
++  * @license Proprietary
++  *
++@@ -11,6 +11,7 @@ namespace sitesplat\replytounhide\event;
++ 
++ use phpbb\controller\helper;
++ use phpbb\template\template;
+++use phpbb\auth\auth;
++ use phpbb\user;
++ use phpbb\db\driver\driver_interface;
++ use Symfony\Component\EventDispatcher\EventSubscriberInterface;
++@@ -25,21 +26,25 @@ class listener implements EventSubscriberInterface
++ 	protected $bbcodes_parser;
++ 	protected $helper;
++ 	protected $template;
+++	protected $auth;
++ 	protected $user;
++ 	protected $db;
+++	protected $table_likes;
++ 	protected $ext_root_path;
++ 
++ 	/**
++ 	 * Constructor
++ 	 *
++ 	 */
++-	public function __construct(bbcodes_parser $bbcodes_parser, helper $helper, template $template, user $user, driver_interface $db, $ext_root_path)
+++	public function __construct(bbcodes_parser $bbcodes_parser, helper $helper, template $template, auth $auth, user $user, driver_interface $db, $table_likes, $ext_root_path)
++ 	{
++ 		$this->bbcodes_parser = $bbcodes_parser;
++ 		$this->helper = $helper;
++ 		$this->template = $template;
+++		$this->auth = $auth;
++ 		$this->user = $user;
++ 		$this->db = $db;
+++		$this->table_likes = $table_likes;
++ 		$this->ext_root_path = $ext_root_path;
++ 	}
++ 
++@@ -54,12 +59,12 @@ class listener implements EventSubscriberInterface
++ 			// functions_content events
++ 			'core.modify_text_for_display_before'			=> 'parse_bbcodes_before',
++ 			'core.modify_text_for_display_after'			=> 'parse_bbcodes_after',
++-			'core.viewtopic_modify_post_data'				=> 'hide_attachment',
++-			'core.mcp_topic_modify_post_data'				=> 'in_mcp',
++-			
+++
++ 			// functions_display events
++-			'core.viewtopic_assign_template_vars_before'	=> 'find_replies',
++-			'core.bbtranslate_translate_vars_before'		=> 'find_replies',
+++			'core.viewtopic_assign_template_vars_before'	=> 'find_replies_for_topic',
+++			'core.bbtranslate_translate_vars_before'		=> 'find_replies_for_topic',
+++			'core.posting_modify_message_text'				=> 'find_replies_for_post',
+++
++ 			'core.posting_modify_template_vars'				=> 'delete_hidden',
++ 			'core.topic_review_modify_row'					=> 'delete_hidden_review',
++ 
++@@ -82,41 +87,81 @@ class listener implements EventSubscriberInterface
++ 	}
++ 
++ 	/**
++-	 * MCP settings
+++	 * Check if can skip
++ 	 */
++-	public function in_mcp($event)
+++	public function check_can_skip($event, $type = 'topic')
++ 	{
++-		$this->bbcodes_parser->replied = 1;
+++		$idAdmin = (bool) $this->auth->acl_get('a_');
+++		$isModerator = (bool) $this->auth->acl_get('m_', $event['forum_id']);
+++		$isSpecialGroup = ($this->user->data['group_id'] == 18 && in_array($event['forum_id'], array(127, 128, 129, 130, 131, 132, 175, 198)));
+++		$isPoster = (
+++			(int) $this->user->data['user_id'] === (
+++				$type === 'topic'
+++					? (int) (
+++						isset($event['topic_data'])
+++							? $event['topic_data']['topic_poster']
+++							: $event['row']['poster_id']
+++					)
+++					: (int) $event['post_data']['poster_id']
+++			)
+++		);
+++
+++		if ($isSpecialGroup || $idAdmin || $isModerator || $isPoster) {
+++			$this->bbcodes_parser->replied = 1;
+++			return true;
+++		}
+++
+++		return false;
++ 	}
++-	
+++
++ 	/**
++-	 * Hide attachement
+++	 * Find post_id of post
++ 	 */
++-	public function hide_attachment($event)
+++	public function find_replies_for_topic($event)
++ 	{
++-		if (!$this->bbcodes_parser->replied)
++-		{
++-			$attach = $event['has_approved_attachments'];
++-			
++-			$attach = false;
++-			$event['has_approved_attachments'] = $attach;
++-			
++-			$attachments = $event['attachments'];
++-			$attachments = array();
++-			$event['attachments'] = $attachments;
+++		$this->find_replies($event, 'topic');
+++	}
+++
+++	/**
+++	 * Find post_id of post
+++	 */
+++	public function find_replies_for_post($event)
+++	{
+++		$this->find_replies($event, 'post');
+++	}
+++
+++	/**
+++	 * Find post_id of topic or preview
+++	 */
+++	public function find_replies($event, $type = 'topic')
+++	{
+++		if (!$this->check_can_skip($event, $type) && $this->user->data['user_id'] != ANONYMOUS) {
+++			$post_id = $this->determine_post_id($event, $type);
+++
+++			//Replies
+++			//$sql = 'SELECT COUNT(post_id) AS replied FROM ' . POSTS_TABLE . ' WHERE topic_id = ' . $event['topic_id'] . ' AND poster_id = ' . $this->user->data['user_id'];
+++			//Thanks For Posts
+++			//$sql = 'SELECT COUNT(post_id) AS replied FROM ' . $this->table_thanks . ' WHERE post_id = ' . $post_id . ' AND user_id = ' . $this->user->data['user_id'];
+++			//Like BB
+++			$sql = 'SELECT COUNT(post_id) AS replied FROM ' . $this->table_likes . ' WHERE post_id = ' . $post_id . ' AND user_id = ' . $this->user->data['user_id'];
+++
+++			$result = $this->db->sql_query($sql);
+++			$this->bbcodes_parser->replied = $this->db->sql_fetchfield('replied');
++ 		}
++ 	}
++-	
+++
++ 	/**
++-	 * Find topic_id of topic
+++	 * Determine post_id based on event data
++ 	 */
++-	public function find_replies($event)
+++	protected function determine_post_id($event, $type = 'topic')
++ 	{
++-		$sql = 'SELECT COUNT(post_id) AS replied 
++-				FROM ' . POSTS_TABLE . ' 
++-				WHERE post_visibility = 1 AND topic_id = ' . $event['topic_id'] . ' AND poster_id = ' . $this->user->data['user_id'];
++-		$result = $this->db->sql_query($sql);
++-		$this->bbcodes_parser->replied = $this->db->sql_fetchfield('replied');
+++		if (empty($event[$type . '_data']['topic_first_post_id'])) {
+++			if (empty($event['post_data']['topic_first_post_id'])) {
+++				return $event['topic_id'];
+++			}
+++			return $event['post_data']['topic_first_post_id'];
+++		}
+++		return $event[$type . '_data']['topic_first_post_id'];
++ 	}
++ 
++ 	/**
++@@ -128,11 +173,7 @@ class listener implements EventSubscriberInterface
++ 		{
++ 			(!$this->bbcodes_parser->replied) ? $this->find_replies($event) : null;
++ 			$post_row  = $event['post_row'];
++-			$post_row['DECODED_MESSAGE'] = preg_replace('!\[hide\](.*?)\[/hide\]!is', '', $post_row['DECODED_MESSAGE']);
++-	
++-	//		$post_row['DECODED_MESSAGE'] = preg_replace_callback('!\[hide\](.*?)\[/hide\]!is', function ($matches) {return strtolower($matches[0]);}, $post_row['DECODED_MESSAGE']);	
++-	//		$post_row['DECODED_MESSAGE'] = preg_replace_callback('![hide](.*?)[/hide]!is', function ($match) { return ''; }, $post_row['DECODED_MESSAGE']);
++-			
+++			$post_row['DECODED_MESSAGE'] = preg_replace('!\[hide\](.*?)\[/hide\]!is', '- Conteúdo Protegido -', $post_row['DECODED_MESSAGE']);
++ 			$event['post_row'] = $post_row;
++ 		}
++ 	}
++@@ -142,15 +183,10 @@ class listener implements EventSubscriberInterface
++ 	 */
++ 	public function delete_hidden($event)
++ 	{
++-		if ($event['mode'] == 'quote')
+++		if ($event['mode'] == 'quote' && !$this->check_can_skip($event, 'post'))
++ 		{
++ 			$page_data  = $event['page_data'];
++-
++-			$page_data['MESSAGE'] = preg_replace('!\[hide\](.*?)\[/hide\]!is', '', $page_data['MESSAGE']);
++-
++-		//	$page_data['MESSAGE'] = preg_replace_callback('!\[hide\](.*?)\[/hide\]!is', function ($matches) {return strtolower($matches[0]);}, $page_data['MESSAGE']);
++-		//	$page_data['MESSAGE'] = preg_replace_callback('![hide](.*?)[/hide]!is', function ($match) { return ''; }, $page_data['MESSAGE']);
++-		
+++			$page_data['MESSAGE'] = preg_replace('!\[hide\](.*?)\[/hide\]!is', '- Conteúdo Protegido -', $page_data['MESSAGE']);
++ 			$event['page_data'] = $page_data;
++ 		}
++ 	}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\replytounhide/ext.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/ext.php"
++index 170239971..7dbc59291 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\replytounhide/ext.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/ext.php"
++@@ -1,7 +1,7 @@
++ <?php
++ /**
++  *
++- * @package ReplyToUnihde
+++ * @package ReplyToUnhide
++  * @copyright (c) 2016 SiteSplat <http://sitesplat.com>
++  * @license Proprietary
++  *
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\replytounhide/language/en/info_acp_replytounhide.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/language/en/info_acp_replytounhide.php"
++index f6ed27628..f0f921996 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\replytounhide/language/en/info_acp_replytounhide.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/language/en/info_acp_replytounhide.php"
++@@ -1,7 +1,7 @@
++ <?php
++ /**
++  *
++- * @package ReplyToUnihde
+++ * @package ReplyToUnhide
++  * @copyright (c) 2016 SiteSplat <http://sitesplat.com>
++  * @license Proprietary
++  *
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\replytounhide/language/en/replytounhide.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/language/en/replytounhide.php"
++index 66eb07b6f..98b327e11 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\replytounhide/language/en/replytounhide.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/language/en/replytounhide.php"
++@@ -1,7 +1,7 @@
++ <?php
++ /**
++ *
++- * @package ReplyToUnihde
+++ * @package ReplyToUnhide
++  * @copyright (c) 2016 SiteSplat <http://sitesplat.com>
++  * @license Proprietary
++ *
++@@ -24,6 +24,6 @@ $lang = array_merge($lang, array(
++ 	// Hide BBCode
++ 	'HIDE_ON'		=> 'Hidden Content',
++ 	'HIDE_OFF'		=> 'Hidden Content (for members only)',
++-	'HIDE_EXPLAIN'	=> 'This board requires you to be registered, logged-in and to reply first to view the hidden content...',
+++	'HIDE_EXPLAIN'	=> 'This board requires you to be registered, logged-in and to like topic to view the hidden content...',
++ 	'HIDE_HELPLINE'	=> '[hide]{TEXT}[/hide]'
++ ));
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/language/pt/info_acp_replytounhide.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/language/pt/info_acp_replytounhide.php"
++new file mode 100644
++index 000000000..f0f921996
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/language/pt/info_acp_replytounhide.php"
++@@ -0,0 +1,38 @@
+++<?php
+++/**
+++ *
+++ * @package ReplyToUnhide
+++ * @copyright (c) 2016 SiteSplat <http://sitesplat.com>
+++ * @license Proprietary
+++ *
+++ */
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
+++$lang = array_merge($lang, array(
+++    'REPLYTOUNHIDE_NOTICE'		=> '<div class="phpinfo"><p>There are no setting for this extenion. The BBcode HIDE is available to be used in posting page.</p></div>',
+++	'SS_HELPER_NOTICE'			=> 'The BBcore extension does not exist!<br />Download the <a href="http://sitesplat.com">BBcore</a> and copy the folder into your sitesplat extension folder.',
+++));
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/language/pt/replytounhide.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/language/pt/replytounhide.php"
++new file mode 100644
++index 000000000..7a143a773
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/language/pt/replytounhide.php"
++@@ -0,0 +1,29 @@
+++<?php
+++/**
+++*
+++ * @package ReplyToUnhide
+++ * @copyright (c) 2016 SiteSplat <http://sitesplat.com>
+++ * @license Proprietary
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
+++$lang = array_merge($lang, array(
+++	// Hide BBCode
+++	'HIDE_ON'		=> 'Conteúdo Oculto',
+++	'HIDE_OFF'		=> 'Conteúdo Oculto (Apenas para membros)',
+++	'HIDE_EXPLAIN'	=> 'Precisas de <strong>agradecer</strong> o tópico para poderes visualizar o conteúdo.<br><br>Se estiver difícil... Procura por um botão como este: <a href="#thanks_button"><span class="btn-primary btn-sm">&nbsp;<i class="fa fa-thumbs-up"></i><strong>&nbsp;Agradecer</strong></span></a> Acreditamos em ti! Tu consegues encontrá-lo!',
+++	'HIDE_HELPLINE'	=> '[hide]{TEXT}[/hide]'
+++));
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/language/pt_preao/info_acp_replytounhide.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/language/pt_preao/info_acp_replytounhide.php"
++new file mode 100644
++index 000000000..f0f921996
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/language/pt_preao/info_acp_replytounhide.php"
++@@ -0,0 +1,38 @@
+++<?php
+++/**
+++ *
+++ * @package ReplyToUnhide
+++ * @copyright (c) 2016 SiteSplat <http://sitesplat.com>
+++ * @license Proprietary
+++ *
+++ */
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
+++$lang = array_merge($lang, array(
+++    'REPLYTOUNHIDE_NOTICE'		=> '<div class="phpinfo"><p>There are no setting for this extenion. The BBcode HIDE is available to be used in posting page.</p></div>',
+++	'SS_HELPER_NOTICE'			=> 'The BBcore extension does not exist!<br />Download the <a href="http://sitesplat.com">BBcore</a> and copy the folder into your sitesplat extension folder.',
+++));
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/language/pt_preao/replytounhide.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/language/pt_preao/replytounhide.php"
++new file mode 100644
++index 000000000..21209f562
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/language/pt_preao/replytounhide.php"
++@@ -0,0 +1,29 @@
+++<?php
+++/**
+++*
+++ * @package ReplyToUnhide
+++ * @copyright (c) 2016 SiteSplat <http://sitesplat.com>
+++ * @license Proprietary
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
+++$lang = array_merge($lang, array(
+++	// Hide BBCode
+++	'HIDE_ON'		=> 'Conteúdo Oculto',
+++	'HIDE_OFF'		=> 'Conteúdo Oculto (Apenas para membros)',
+++	'HIDE_EXPLAIN'	=> 'Precisas de <strong>agradecer</strong> o tópico para poderes visualizar o conteúdo.<br><br>Se estiver difícil... Procura por um botão como este: <span class="btn-primary btn-sm">&nbsp;<i class="fa fa-thumbs-up"></i><strong>&nbsp;Agradecer</strong></span> Acreditamos em ti! Tu consegues encontrá-lo!',
+++	'HIDE_HELPLINE'	=> '[hide]{TEXT}[/hide]'
+++));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\replytounhide/migrations/v31x/m1_initial_data.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/migrations/v31x/m1_initial_data.php"
++index 54a21e9ae..acf27fb85 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\replytounhide/migrations/v31x/m1_initial_data.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/migrations/v31x/m1_initial_data.php"
++@@ -1,7 +1,7 @@
++ <?php
++ /**
++  *
++- * @package ReplyToUnihde
+++ * @package ReplyToUnhide
++  * @copyright (c) 2016 SiteSplat <http://sitesplat.com>
++  * @license Proprietary
++  *
++@@ -39,8 +39,7 @@ class m1_initial_data extends \sitesplat\replytounhide\core\bbcodes_migration_ba
++ 		'hide' => [
++ 			'bbcode_helpline'	=> 'HIDE_HELPLINE',
++ 			'bbcode_match'		=> '[hide]{TEXT}[/hide]',
++-			'bbcode_tpl'		=> '<!-- BBCODE_HIDE -->{TEXT}<!-- BBCODE_HIDE -->',
++-            'display_on_posting'=> 0
+++			'bbcode_tpl'		=> '<!-- BBCODE_HIDE -->{TEXT}<!-- BBCODE_HIDE -->'
++ 		]
++ 	];
++ }
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/styles/FLATBOOTS/theme/replytounhide.css" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/styles/FLATBOOTS/theme/replytounhide.css"
++new file mode 100644
++index 000000000..0475a5ad8
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounhide/styles/FLATBOOTS/theme/replytounhide.css"
++@@ -0,0 +1,28 @@
+++/* [hidden] hide BBCode */
+++.hidebox {
+++	position: relative;
+++	margin: 5px 0;
+++	font-weight: normal;
+++	padding: 39px 19px 14px;
+++	background-color: #c5e3bf;
+++	border: 1px solid #72B173;
+++	border-radius: 4px;
+++}
+++.hidebox_title {
+++	position: absolute;
+++	top: -1px;
+++	left: -1px;
+++	font-weight: bold;
+++	font-size: 12px;
+++	color: #2f4f2f;
+++	padding: 5px 12px;
+++	border: 1px solid #72B173;
+++	border-radius: 4px 0 4px 0;
+++}
+++.hidebox_hidden {
+++	background-color: #f2dede;
+++	border-color: #ebccd1;
+++	color: #80001c;
+++}
+++
+++.hidebox_visible { color: #2f4f2f }
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\replytounhide/styles/FLATBOOTS/theme/replytounhide.min.css" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\replytounh
\ No newline at end of file
diff --git "[ORIGINAL]/sitesplat\\replytounhide/event/listener.php" "[FORUM_EXT]/sitesplat\\replytounhide/event/listener.php"
--- "[ORIGINAL]/sitesplat\\replytounhide/event/listener.php"
+++ "[FORUM_EXT]/sitesplat\\replytounhide/event/listener.php"
@@ -1,7 +1,7 @@
 <?php
 /**
  *
- * @package ReplyToUnihde
+ * @package ReplyToUnhide
  * @copyright (c) 2016 SiteSplat <http://sitesplat.com>
  * @license Proprietary
  *
@@ -11,6 +11,7 @@ namespace sitesplat\replytounhide\event;
 
 use phpbb\controller\helper;
 use phpbb\template\template;
+use phpbb\auth\auth;
 use phpbb\user;
 use phpbb\db\driver\driver_interface;
 use Symfony\Component\EventDispatcher\EventSubscriberInterface;
@@ -25,21 +26,25 @@ class listener implements EventSubscriberInterface
 	protected $bbcodes_parser;
 	protected $helper;
 	protected $template;
+	protected $auth;
 	protected $user;
 	protected $db;
+	protected $table_likes;
 	protected $ext_root_path;
 
 	/**
 	 * Constructor
 	 *
 	 */
-	public function __construct(bbcodes_parser $bbcodes_parser, helper $helper, template $template, user $user, driver_interface $db, $ext_root_path)
+	public function __construct(bbcodes_parser $bbcodes_parser, helper $helper, template $template, auth $auth, user $user, driver_interface $db, $table_likes, $ext_root_path)
 	{
 		$this->bbcodes_parser = $bbcodes_parser;
 		$this->helper = $helper;
 		$this->template = $template;
+		$this->auth = $auth;
 		$this->user = $user;
 		$this->db = $db;
+		$this->table_likes = $table_likes;
 		$this->ext_root_path = $ext_root_path;
 	}
 
@@ -54,12 +59,12 @@ class listener implements EventSubscriberInterface
 			// functions_content events
 			'core.modify_text_for_display_before'			=> 'parse_bbcodes_before',
 			'core.modify_text_for_display_after'			=> 'parse_bbcodes_after',
-			'core.viewtopic_modify_post_data'				=> 'hide_attachment',
-			'core.mcp_topic_modify_post_data'				=> 'in_mcp',
 
 			// functions_display events
-			'core.viewtopic_assign_template_vars_before'	=> 'find_replies',
-			'core.bbtranslate_translate_vars_before'		=> 'find_replies',
+			'core.viewtopic_assign_template_vars_before'	=> 'find_replies_for_topic',
+			'core.bbtranslate_translate_vars_before'		=> 'find_replies_for_topic',
+			'core.posting_modify_message_text'				=> 'find_replies_for_post',
+
 			'core.posting_modify_template_vars'				=> 'delete_hidden',
 			'core.topic_review_modify_row'					=> 'delete_hidden_review',
 
@@ -82,41 +87,81 @@ class listener implements EventSubscriberInterface
 	}
 
 	/**
-	 * MCP settings
+	 * Check if can skip
 	 */
-	public function in_mcp($event)
+	public function check_can_skip($event, $type = 'topic')
 	{
+		$idAdmin = (bool) $this->auth->acl_get('a_');
+		$isModerator = (bool) $this->auth->acl_get('m_', $event['forum_id']);
+		$isSpecialGroup = ($this->user->data['group_id'] == 18 && in_array($event['forum_id'], array(127, 128, 129, 130, 131, 132, 175, 198)));
+		$isPoster = (
+			(int) $this->user->data['user_id'] === (
+				$type === 'topic'
+					? (int) (
+						isset($event['topic_data'])
+							? $event['topic_data']['topic_poster']
+							: $event['row']['poster_id']
+					)
+					: (int) $event['post_data']['poster_id']
+			)
+		);
+
+		if ($isSpecialGroup || $idAdmin || $isModerator || $isPoster) {
 			$this->bbcodes_parser->replied = 1;
+			return true;
+		}
+
+		return false;
 	}
 
 	/**
-	 * Hide attachement
+	 * Find post_id of post
 	 */
-	public function hide_attachment($event)
+	public function find_replies_for_topic($event)
 	{
-		if (!$this->bbcodes_parser->replied)
+		$this->find_replies($event, 'topic');
+	}
+
+	/**
+	 * Find post_id of post
+	 */
+	public function find_replies_for_post($event)
 	{
-			$attach = $event['has_approved_attachments'];
+		$this->find_replies($event, 'post');
+	}
 
-			$attach = false;
-			$event['has_approved_attachments'] = $attach;
+	/**
+	 * Find post_id of topic or preview
+	 */
+	public function find_replies($event, $type = 'topic')
+	{
+		if (!$this->check_can_skip($event, $type) && $this->user->data['user_id'] != ANONYMOUS) {
+			$post_id = $this->determine_post_id($event, $type);
 
-			$attachments = $event['attachments'];
-			$attachments = array();
-			$event['attachments'] = $attachments;
+			//Replies
+			//$sql = 'SELECT COUNT(post_id) AS replied FROM ' . POSTS_TABLE . ' WHERE topic_id = ' . $event['topic_id'] . ' AND poster_id = ' . $this->user->data['user_id'];
+			//Thanks For Posts
+			//$sql = 'SELECT COUNT(post_id) AS replied FROM ' . $this->table_thanks . ' WHERE post_id = ' . $post_id . ' AND user_id = ' . $this->user->data['user_id'];
+			//Like BB
+			$sql = 'SELECT COUNT(post_id) AS replied FROM ' . $this->table_likes . ' WHERE post_id = ' . $post_id . ' AND user_id = ' . $this->user->data['user_id'];
+
+			$result = $this->db->sql_query($sql);
+			$this->bbcodes_parser->replied = $this->db->sql_fetchfield('replied');
 		}
 	}
 
 	/**
-	 * Find topic_id of topic
+	 * Determine post_id based on event data
 	 */
-	public function find_replies($event)
+	protected function determine_post_id($event, $type = 'topic')
 	{
-		$sql = 'SELECT COUNT(post_id) AS replied 
-				FROM ' . POSTS_TABLE . ' 
-				WHERE post_visibility = 1 AND topic_id = ' . $event['topic_id'] . ' AND poster_id = ' . $this->user->data['user_id'];
-		$result = $this->db->sql_query($sql);
-		$this->bbcodes_parser->replied = $this->db->sql_fetchfield('replied');
+		if (empty($event[$type . '_data']['topic_first_post_id'])) {
+			if (empty($event['post_data']['topic_first_post_id'])) {
+				return $event['topic_id'];
+			}
+			return $event['post_data']['topic_first_post_id'];
+		}
+		return $event[$type . '_data']['topic_first_post_id'];
 	}
 
 	/**
@@ -128,11 +173,7 @@ class listener implements EventSubscriberInterface
 		{
 			(!$this->bbcodes_parser->replied) ? $this->find_replies($event) : null;
 			$post_row  = $event['post_row'];
-			$post_row['DECODED_MESSAGE'] = preg_replace('!\[hide\](.*?)\[/hide\]!is', '', $post_row['DECODED_MESSAGE']);
-	
-	//		$post_row['DECODED_MESSAGE'] = preg_replace_callback('!\[hide\](.*?)\[/hide\]!is', function ($matches) {return strtolower($matches[0]);}, $post_row['DECODED_MESSAGE']);	
-	//		$post_row['DECODED_MESSAGE'] = preg_replace_callback('![hide](.*?)[/hide]!is', function ($match) { return ''; }, $post_row['DECODED_MESSAGE']);
-			
+			$post_row['DECODED_MESSAGE'] = preg_replace('!\[hide\](.*?)\[/hide\]!is', '- Conteúdo Protegido -', $post_row['DECODED_MESSAGE']);
 			$event['post_row'] = $post_row;
 		}
 	}
@@ -142,15 +183,10 @@ class listener implements EventSubscriberInterface
 	 */
 	public function delete_hidden($event)
 	{
-		if ($event['mode'] == 'quote')
+		if ($event['mode'] == 'quote' && !$this->check_can_skip($event, 'post'))
 		{
 			$page_data  = $event['page_data'];
-
-			$page_data['MESSAGE'] = preg_replace('!\[hide\](.*?)\[/hide\]!is', '', $page_data['MESSAGE']);
-
-		//	$page_data['MESSAGE'] = preg_replace_callback('!\[hide\](.*?)\[/hide\]!is', function ($matches) {return strtolower($matches[0]);}, $page_data['MESSAGE']);
-		//	$page_data['MESSAGE'] = preg_replace_callback('![hide](.*?)[/hide]!is', function ($match) { return ''; }, $page_data['MESSAGE']);
-		
+			$page_data['MESSAGE'] = preg_replace('!\[hide\](.*?)\[/hide\]!is', '- Conteúdo Protegido -', $page_data['MESSAGE']);
 			$event['page_data'] = $page_data;
 		}
 	}
diff --git "[ORIGINAL]/sitesplat\\replytounhide/ext.php" "[FORUM_EXT]/sitesplat\\replytounhide/ext.php"
--- "[ORIGINAL]/sitesplat\\replytounhide/ext.php"
+++ "[FORUM_EXT]/sitesplat\\replytounhide/ext.php"
@@ -1,7 +1,7 @@
 <?php
 /**
  *
- * @package ReplyToUnihde
+ * @package ReplyToUnhide
  * @copyright (c) 2016 SiteSplat <http://sitesplat.com>
  * @license Proprietary
  *
diff --git "[ORIGINAL]/sitesplat\\replytounhide/language/en/info_acp_replytounhide.php" "[FORUM_EXT]/sitesplat\\replytounhide/language/en/info_acp_replytounhide.php"
--- "[ORIGINAL]/sitesplat\\replytounhide/language/en/info_acp_replytounhide.php"
+++ "[FORUM_EXT]/sitesplat\\replytounhide/language/en/info_acp_replytounhide.php"
@@ -1,7 +1,7 @@
 <?php
 /**
  *
- * @package ReplyToUnihde
+ * @package ReplyToUnhide
  * @copyright (c) 2016 SiteSplat <http://sitesplat.com>
  * @license Proprietary
  *
diff --git "[ORIGINAL]/sitesplat\\replytounhide/language/en/replytounhide.php" "[FORUM_EXT]/sitesplat\\replytounhide/language/en/replytounhide.php"
--- "[ORIGINAL]/sitesplat\\replytounhide/language/en/replytounhide.php"
+++ "[FORUM_EXT]/sitesplat\\replytounhide/language/en/replytounhide.php"
@@ -1,7 +1,7 @@
 <?php
 /**
 *
- * @package ReplyToUnihde
+ * @package ReplyToUnhide
  * @copyright (c) 2016 SiteSplat <http://sitesplat.com>
  * @license Proprietary
 *
@@ -24,6 +24,6 @@ $lang = array_merge($lang, array(
 	// Hide BBCode
 	'HIDE_ON'		=> 'Hidden Content',
 	'HIDE_OFF'		=> 'Hidden Content (for members only)',
-	'HIDE_EXPLAIN'	=> 'This board requires you to be registered, logged-in and to reply first to view the hidden content...',
+	'HIDE_EXPLAIN'	=> 'This board requires you to be registered, logged-in and to like topic to view the hidden content...',
 	'HIDE_HELPLINE'	=> '[hide]{TEXT}[/hide]'
 ));
diff --git "[FORUM_EXT]/sitesplat\\replytounhide/language/pt/info_acp_replytounhide.php" "[FORUM_EXT]/sitesplat\\replytounhide/language/pt/info_acp_replytounhide.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\replytounhide/language/pt/info_acp_replytounhide.php"
@@ -0,0 +1,38 @@
+<?php
+/**
+ *
+ * @package ReplyToUnhide
+ * @copyright (c) 2016 SiteSplat <http://sitesplat.com>
+ * @license Proprietary
+ *
+ */
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
+$lang = array_merge($lang, array(
+    'REPLYTOUNHIDE_NOTICE'		=> '<div class="phpinfo"><p>There are no setting for this extenion. The BBcode HIDE is available to be used in posting page.</p></div>',
+	'SS_HELPER_NOTICE'			=> 'The BBcore extension does not exist!<br />Download the <a href="http://sitesplat.com">BBcore</a> and copy the folder into your sitesplat extension folder.',
+));
diff --git "[FORUM_EXT]/sitesplat\\replytounhide/language/pt/replytounhide.php" "[FORUM_EXT]/sitesplat\\replytounhide/language/pt/replytounhide.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\replytounhide/language/pt/replytounhide.php"
@@ -0,0 +1,29 @@
+<?php
+/**
+*
+ * @package ReplyToUnhide
+ * @copyright (c) 2016 SiteSplat <http://sitesplat.com>
+ * @license Proprietary
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
+$lang = array_merge($lang, array(
+	// Hide BBCode
+	'HIDE_ON'		=> 'Conteúdo Oculto',
+	'HIDE_OFF'		=> 'Conteúdo Oculto (Apenas para membros)',
+	'HIDE_EXPLAIN'	=> 'Precisas de <strong>agradecer</strong> o tópico para poderes visualizar o conteúdo.<br><br>Se estiver difícil... Procura por um botão como este: <a href="#thanks_button"><span class="btn-primary btn-sm">&nbsp;<i class="fa fa-thumbs-up"></i><strong>&nbsp;Agradecer</strong></span></a> Acreditamos em ti! Tu consegues encontrá-lo!',
+	'HIDE_HELPLINE'	=> '[hide]{TEXT}[/hide]'
+));
diff --git "[FORUM_EXT]/sitesplat\\replytounhide/language/pt_preao/info_acp_replytounhide.php" "[FORUM_EXT]/sitesplat\\replytounhide/language/pt_preao/info_acp_replytounhide.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\replytounhide/language/pt_preao/info_acp_replytounhide.php"
@@ -0,0 +1,38 @@
+<?php
+/**
+ *
+ * @package ReplyToUnhide
+ * @copyright (c) 2016 SiteSplat <http://sitesplat.com>
+ * @license Proprietary
+ *
+ */
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
+$lang = array_merge($lang, array(
+    'REPLYTOUNHIDE_NOTICE'		=> '<div class="phpinfo"><p>There are no setting for this extenion. The BBcode HIDE is available to be used in posting page.</p></div>',
+	'SS_HELPER_NOTICE'			=> 'The BBcore extension does not exist!<br />Download the <a href="http://sitesplat.com">BBcore</a> and copy the folder into your sitesplat extension folder.',
+));
diff --git "[FORUM_EXT]/sitesplat\\replytounhide/language/pt_preao/replytounhide.php" "[FORUM_EXT]/sitesplat\\replytounhide/language/pt_preao/replytounhide.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\replytounhide/language/pt_preao/replytounhide.php"
@@ -0,0 +1,29 @@
+<?php
+/**
+*
+ * @package ReplyToUnhide
+ * @copyright (c) 2016 SiteSplat <http://sitesplat.com>
+ * @license Proprietary
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
+$lang = array_merge($lang, array(
+	// Hide BBCode
+	'HIDE_ON'		=> 'Conteúdo Oculto',
+	'HIDE_OFF'		=> 'Conteúdo Oculto (Apenas para membros)',
+	'HIDE_EXPLAIN'	=> 'Precisas de <strong>agradecer</strong> o tópico para poderes visualizar o conteúdo.<br><br>Se estiver difícil... Procura por um botão como este: <span class="btn-primary btn-sm">&nbsp;<i class="fa fa-thumbs-up"></i><strong>&nbsp;Agradecer</strong></span> Acreditamos em ti! Tu consegues encontrá-lo!',
+	'HIDE_HELPLINE'	=> '[hide]{TEXT}[/hide]'
+));
diff --git "[ORIGINAL]/sitesplat\\replytounhide/migrations/v31x/m1_initial_data.php" "[FORUM_EXT]/sitesplat\\replytounhide/migrations/v31x/m1_initial_data.php"
--- "[ORIGINAL]/sitesplat\\replytounhide/migrations/v31x/m1_initial_data.php"
+++ "[FORUM_EXT]/sitesplat\\replytounhide/migrations/v31x/m1_initial_data.php"
@@ -1,7 +1,7 @@
 <?php
 /**
  *
- * @package ReplyToUnihde
+ * @package ReplyToUnhide
  * @copyright (c) 2016 SiteSplat <http://sitesplat.com>
  * @license Proprietary
  *
@@ -39,8 +39,7 @@ class m1_initial_data extends \sitesplat\replytounhide\core\bbcodes_migration_ba
 		'hide' => [
 			'bbcode_helpline'	=> 'HIDE_HELPLINE',
 			'bbcode_match'		=> '[hide]{TEXT}[/hide]',
-			'bbcode_tpl'		=> '<!-- BBCODE_HIDE -->{TEXT}<!-- BBCODE_HIDE -->',
-            'display_on_posting'=> 0
+			'bbcode_tpl'		=> '<!-- BBCODE_HIDE -->{TEXT}<!-- BBCODE_HIDE -->'
 		]
 	];
 }
diff --git "[FORUM_EXT]/sitesplat\\replytounhide/styles/FLATBOOTS/theme/replytounhide.css" "[FORUM_EXT]/sitesplat\\replytounhide/styles/FLATBOOTS/theme/replytounhide.css"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\replytounhide/styles/FLATBOOTS/theme/replytounhide.css"
@@ -0,0 +1,28 @@
+/* [hidden] hide BBCode */
+.hidebox {
+	position: relative;
+	margin: 5px 0;
+	font-weight: normal;
+	padding: 39px 19px 14px;
+	background-color: #c5e3bf;
+	border: 1px solid #72B173;
+	border-radius: 4px;
+}
+.hidebox_title {
+	position: absolute;
+	top: -1px;
+	left: -1px;
+	font-weight: bold;
+	font-size: 12px;
+	color: #2f4f2f;
+	padding: 5px 12px;
+	border: 1px solid #72B173;
+	border-radius: 4px 0 4px 0;
+}
+.hidebox_hidden {
+	background-color: #f2dede;
+	border-color: #ebccd1;
+	color: #80001c;
+}
+
+.hidebox_visible { color: #2f4f2f }
diff --git "[ORIGINAL]/sitesplat\\replytounhide/styles/FLATBOOTS/theme/replytounhide.min.css" "[FORUM_EXT]/sitesplat\\replytounhide/styles/FLATBOOTS/theme/replytounhide.min.css"
--- "[ORIGINAL]/sitesplat\\replytounhide/styles/FLATBOOTS/theme/replytounhide.min.css"
+++ "[FORUM_EXT]/sitesplat\\replytounhide/styles/FLATBOOTS/theme/replytounhide.min.css"
@@ -1,28 +1 @@
-/* [hidden] hide BBCode */
-.hidebox {
-	position: relative;
-	margin: 5px 0;
-	font-weight: normal;
-	padding: 39px 19px 14px;
-	background-color: #c5e3bf;
-	border: 1px solid #72B173;
-	border-radius: 4px;
-}
-.hidebox_title {
-	position: absolute;
-	top: -1px;
-	left: -1px;
-	font-weight: bold;
-	font-size: 12px;
-	color: #2f4f2f;
-	padding: 5px 12px;
-	border: 1px solid #72B173;
-	border-radius: 4px 0 4px 0;
-}
-.hidebox_hidden {
-	background-color: #f2dede;
-	border-color: #ebccd1;
-	color: #80001c;
-}
-
-.hidebox_visible { color: #2f4f2f }
+.hidebox{position:relative;margin:5px 0;font-weight:400;padding:39px 19px 14px;background-color:#c5e3bf;border:1px solid #72B173;border-radius:4px}.hidebox_title{position:absolute;top:-1px;left:-1px;font-weight:700;font-size:12px;color:#2f4f2f;padding:5px 12px;border:1px solid #72B173;border-radius:4px 0 4px 0}.hidebox_hidden{background-color:#f2dede;border-color:#ebccd1;color:#80001c}.hidebox_visible{color:#2f4f2f}
\ No newline at end of file
diff --git "[FORUM_EXT]/sitesplat\\replytounhide/todo" "[FORUM_EXT]/sitesplat\\replytounhide/todo"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\replytounhide/todo"
@@ -0,0 +1,3 @@
+-group permission
+-issue with full post preview ?
+-check it with BBpreview
\ No newline at end of file
```
