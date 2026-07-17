Existem diferencas reais no codigo ou texto. Diferencas de formatacao (espacos, tabs) foram ignoradas abaixo.

```diff
diff --git "[ORIGINAL]/boardtools\\upload/config/services.yml" "[FORUM_EXT]/boardtools\\upload/config/services.yml"
--- "[ORIGINAL]/boardtools\\upload/config/services.yml"
+++ "[FORUM_EXT]/boardtools\\upload/config/services.yml"
@@ -2,6 +2,6 @@ services:
     boardtools.upload.listener:
         class: boardtools\upload\event\listener
         arguments:
-            - @user
+            - '@user'
         tags:
             - { name: event.listener }
diff --git "[FORUM_EXT]/boardtools\\upload/diff_full.tmp" "[FORUM_EXT]/boardtools\\upload/diff_full.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/boardtools\\upload/diff_full.tmp"
@@ -0,0 +1,19 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\boardtools\\upload/config/services.yml" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\boardtools\\upload/config/services.yml"
+index dd67796af..7c331781c 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\boardtools\\upload/config/services.yml"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\boardtools\\upload/config/services.yml"
+@@ -2,6 +2,6 @@ services:
+     boardtools.upload.listener:
+         class: boardtools\upload\event\listener
+         arguments:
+-            - @user
++            - '@user'
+         tags:
+             - { name: event.listener }
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\boardtools\\upload/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\boardtools\\upload/diff_full.tmp"
+new file mode 100644
+index 000000000..e69de29bb
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\boardtools\\upload/LICENSE.txt" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\boardtools\\upload/license.txt"
+similarity index 100%
+rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\boardtools\\upload/LICENSE.txt"
+rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\boardtools\\upload/license.txt"
diff --git "[FORUM_EXT]/boardtools\\upload/diff_nospace.tmp" "[FORUM_EXT]/boardtools\\upload/diff_nospace.tmp"
new file mode 100644
diff --git "[ORIGINAL]/boardtools\\upload/LICENSE.txt" "[FORUM_EXT]/boardtools\\upload/license.txt"
similarity index 100%
rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\boardtools\\upload/LICENSE.txt"
rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\boardtools\\upload/license.txt"
```
