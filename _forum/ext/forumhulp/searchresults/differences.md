Existem diferencas reais no codigo ou texto. Diferencas de formatacao (espacos, tabs) foram ignoradas abaixo.

```diff
diff --git "[ORIGINAL]/forumhulp\\searchresults/config/services.yml" "[FORUM_EXT]/forumhulp\\searchresults/config/services.yml"
--- "[ORIGINAL]/forumhulp\\searchresults/config/services.yml"
+++ "[FORUM_EXT]/forumhulp\\searchresults/config/services.yml"
@@ -5,14 +5,14 @@ services:
     forumhulp.searchresults.listener:
         class: forumhulp\searchresults\event\listener
         arguments:
-            - @config
-            - @controller.helper
-            - @user
-            - @request
-            - @dbal.conn
-            - @log
-            - %core.root_path%
-            - %core.php_ext%
-            - %tables.searchresults%
+            - '@config'
+            - '@controller.helper'
+            - '@user'
+            - '@request'
+            - '@dbal.conn'
+            - '@log'
+            - '%core.root_path%'
+            - '%core.php_ext%'
+            - '%tables.searchresults%'
         tags:
             - { name: event.listener }
\ No newline at end of file
diff --git "[ORIGINAL]/forumhulp\\searchresults/config/tables.yml" "[FORUM_EXT]/forumhulp\\searchresults/config/tables.yml"
--- "[ORIGINAL]/forumhulp\\searchresults/config/tables.yml"
+++ "[FORUM_EXT]/forumhulp\\searchresults/config/tables.yml"
@@ -1,2 +1,2 @@
 parameters:
-    tables.searchresults: %core.table_prefix%searchresults
+    tables.searchresults: '%core.table_prefix%searchresults'
diff --git "[FORUM_EXT]/forumhulp\\searchresults/diff_full.tmp" "[FORUM_EXT]/forumhulp\\searchresults/diff_full.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/forumhulp\\searchresults/diff_full.tmp"
@@ -0,0 +1,40 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\searchresults/config/services.yml" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\searchresults/config/services.yml"
+index ac6a42924..dfbd1546b 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\searchresults/config/services.yml"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\searchresults/config/services.yml"
+@@ -5,14 +5,14 @@ services:
+     forumhulp.searchresults.listener:
+         class: forumhulp\searchresults\event\listener
+         arguments:
+-            - @config
+-            - @controller.helper
+-            - @user
+-            - @request
+-            - @dbal.conn
+-            - @log
+-            - %core.root_path%
+-            - %core.php_ext%
+-            - %tables.searchresults%
++            - '@config'
++            - '@controller.helper'
++            - '@user'
++            - '@request'
++            - '@dbal.conn'
++            - '@log'
++            - '%core.root_path%'
++            - '%core.php_ext%'
++            - '%tables.searchresults%'
+         tags:
+             - { name: event.listener }
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\searchresults/config/tables.yml" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\searchresults/config/tables.yml"
+index 82f2c5e05..7139355b9 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\searchresults/config/tables.yml"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\searchresults/config/tables.yml"
+@@ -1,2 +1,2 @@
+ parameters:
+-    tables.searchresults: %core.table_prefix%searchresults
++    tables.searchresults: '%core.table_prefix%searchresults'
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\searchresults/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\searchresults/diff_full.tmp"
+new file mode 100644
+index 000000000..e69de29bb
diff --git "[FORUM_EXT]/forumhulp\\searchresults/diff_nospace.tmp" "[FORUM_EXT]/forumhulp\\searchresults/diff_nospace.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/forumhulp\\searchresults/diff_nospace.tmp"
@@ -0,0 +1,76 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\searchresults/config/services.yml" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\searchresults/config/services.yml"
+index ac6a42924..dfbd1546b 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\searchresults/config/services.yml"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\searchresults/config/services.yml"
+@@ -5,14 +5,14 @@ services:
+     forumhulp.searchresults.listener:
+         class: forumhulp\searchresults\event\listener
+         arguments:
+-            - @config
+-            - @controller.helper
+-            - @user
+-            - @request
+-            - @dbal.conn
+-            - @log
+-            - %core.root_path%
+-            - %core.php_ext%
+-            - %tables.searchresults%
++            - '@config'
++            - '@controller.helper'
++            - '@user'
++            - '@request'
++            - '@dbal.conn'
++            - '@log'
++            - '%core.root_path%'
++            - '%core.php_ext%'
++            - '%tables.searchresults%'
+         tags:
+             - { name: event.listener }
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\searchresults/config/tables.yml" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\searchresults/config/tables.yml"
+index 82f2c5e05..7139355b9 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\searchresults/config/tables.yml"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\searchresults/config/tables.yml"
+@@ -1,2 +1,2 @@
+ parameters:
+-    tables.searchresults: %core.table_prefix%searchresults
++    tables.searchresults: '%core.table_prefix%searchresults'
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\searchresults/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\searchresults/diff_full.tmp"
+new file mode 100644
+index 000000000..194f427d8
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\searchresults/diff_full.tmp"
+@@ -0,0 +1,40 @@
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\searchresults/config/services.yml" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\searchresults/config/services.yml"
++index ac6a42924..dfbd1546b 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\searchresults/config/services.yml"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\searchresults/config/services.yml"
++@@ -5,14 +5,14 @@ services:
++     forumhulp.searchresults.listener:
++         class: forumhulp\searchresults\event\listener
++         arguments:
++-            - @config
++-            - @controller.helper
++-            - @user
++-            - @request
++-            - @dbal.conn
++-            - @log
++-            - %core.root_path%
++-            - %core.php_ext%
++-            - %tables.searchresults%
+++            - '@config'
+++            - '@controller.helper'
+++            - '@user'
+++            - '@request'
+++            - '@dbal.conn'
+++            - '@log'
+++            - '%core.root_path%'
+++            - '%core.php_ext%'
+++            - '%tables.searchresults%'
++         tags:
++             - { name: event.listener }
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\searchresults/config/tables.yml" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\searchresults/config/tables.yml"
++index 82f2c5e05..7139355b9 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\searchresults/config/tables.yml"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\
\ No newline at end of file
```
