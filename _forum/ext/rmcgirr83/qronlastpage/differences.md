Existem diferencas reais no codigo ou texto. Diferencas de formatacao (espacos, tabs) foram ignoradas abaixo.

```diff
diff --git "[ORIGINAL]/rmcgirr83\\qronlastpage/config/services.yml" "[FORUM_EXT]/rmcgirr83\\qronlastpage/config/services.yml"
--- "[ORIGINAL]/rmcgirr83\\qronlastpage/config/services.yml"
+++ "[FORUM_EXT]/rmcgirr83\\qronlastpage/config/services.yml"
@@ -2,9 +2,9 @@ services:
     rmcgirr83.qronlastpage.listener:
         class: rmcgirr83\qronlastpage\event\listener
         arguments:
-            - @auth
-            - @config
-            - @template
-            - @user
+            - '@auth'
+            - '@config'
+            - '@template'
+            - '@user'
         tags:
             - { name: event.listener }
diff --git "[FORUM_EXT]/rmcgirr83\\qronlastpage/diff_full.tmp" "[FORUM_EXT]/rmcgirr83\\qronlastpage/diff_full.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/rmcgirr83\\qronlastpage/diff_full.tmp"
@@ -0,0 +1,36 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\qronlastpage/config/services.yml" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\qronlastpage/config/services.yml"
+index 0346f1976..7d11169f8 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\qronlastpage/config/services.yml"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\qronlastpage/config/services.yml"
+@@ -2,9 +2,9 @@ services:
+     rmcgirr83.qronlastpage.listener:
+         class: rmcgirr83\qronlastpage\event\listener
+         arguments:
+-            - @auth
+-            - @config
+-            - @template
+-            - @user
++            - '@auth'
++            - '@config'
++            - '@template'
++            - '@user'
+         tags:
+             - { name: event.listener }
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\qronlastpage/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\qronlastpage/diff_full.tmp"
+new file mode 100644
+index 000000000..e69de29bb
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\qronlastpage/event/listener.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\qronlastpage/event/listener.php"
+index 5b430f7d6..00da6d360 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\qronlastpage/event/listener.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\qronlastpage/event/listener.php"
+@@ -100,8 +100,9 @@ class listener implements EventSubscriberInterface
+ 		if (!$on_last_page)
+ 		{
+ 			$this->template->assign_vars(array(
+-				'S_QUICK_REPLY'	=> false,
++				'S_NOT_LAST_PAGE'	=> true,
+ 			));
++			
+ 		}
+ 	}
+ }
diff --git "[FORUM_EXT]/rmcgirr83\\qronlastpage/diff_nospace.tmp" "[FORUM_EXT]/rmcgirr83\\qronlastpage/diff_nospace.tmp"
new file mode 100644
diff --git "[ORIGINAL]/rmcgirr83\\qronlastpage/event/listener.php" "[FORUM_EXT]/rmcgirr83\\qronlastpage/event/listener.php"
--- "[ORIGINAL]/rmcgirr83\\qronlastpage/event/listener.php"
+++ "[FORUM_EXT]/rmcgirr83\\qronlastpage/event/listener.php"
@@ -100,8 +100,9 @@ class listener implements EventSubscriberInterface
 		if (!$on_last_page)
 		{
 			$this->template->assign_vars(array(
-				'S_QUICK_REPLY'	=> false,
+				'S_NOT_LAST_PAGE'	=> true,
 			));
+			
 		}
 	}
 }
```
