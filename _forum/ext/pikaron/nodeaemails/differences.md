Existem diferencas reais no codigo ou texto. Diferencas de formatacao (espacos, tabs) foram ignoradas abaixo.

```diff
diff --git "[ORIGINAL]/pikaron\\nodeaemails/config/services.yml" "[FORUM_EXT]/pikaron\\nodeaemails/config/services.yml"
--- "[ORIGINAL]/pikaron\\nodeaemails/config/services.yml"
+++ "[FORUM_EXT]/pikaron\\nodeaemails/config/services.yml"
@@ -32,5 +32,3 @@ services:
             - [set_name, [pikaron.nodeaemails.cron.task.nodeaemails_cron]]
         tags:
             - { name: cron.task }
\ No newline at end of file
-    _defaults:
-        public: true
\ No newline at end of file
diff --git "[FORUM_EXT]/pikaron\\nodeaemails/diff_full.tmp" "[FORUM_EXT]/pikaron\\nodeaemails/diff_full.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/pikaron\\nodeaemails/diff_full.tmp"
@@ -0,0 +1,17 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\pikaron\\nodeaemails/config/services.yml" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\pikaron\\nodeaemails/config/services.yml"
+index 6d7b5c906..bc067b24d 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\pikaron\\nodeaemails/config/services.yml"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\pikaron\\nodeaemails/config/services.yml"
+@@ -31,6 +31,4 @@ services:
+         calls:
+             - [set_name, [pikaron.nodeaemails.cron.task.nodeaemails_cron]]
+         tags:
+-            - { name: cron.task }
+-    _defaults:
+-        public: true
+\ No newline at end of file
++            - { name: cron.task }
+\ No newline at end of file
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\pikaron\\nodeaemails/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\pikaron\\nodeaemails/diff_full.tmp"
+new file mode 100644
+index 000000000..e69de29bb
diff --git "[FORUM_EXT]/pikaron\\nodeaemails/diff_nospace.tmp" "[FORUM_EXT]/pikaron\\nodeaemails/diff_nospace.tmp"
new file mode 100644
```
