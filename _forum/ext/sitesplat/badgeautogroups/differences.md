Existem diferencas reais no codigo ou texto. Diferencas de formatacao (espacos, tabs) foram ignoradas abaixo.

```diff
diff --git "[ORIGINAL]/sitesplat\\badgeautogroups/composer.json" "[FORUM_EXT]/sitesplat\\badgeautogroups/composer.json"
--- "[ORIGINAL]/sitesplat\\badgeautogroups/composer.json"
+++ "[FORUM_EXT]/sitesplat\\badgeautogroups/composer.json"
@@ -28,7 +28,8 @@
        "version-check": {
             "host": "www.sitesplat.com",
             "directory": "/updatecheck/phpbb32/ext",
-            "filename": "bbawards_autogroup.json"
+            "filename": "bbawards_autogroup.json",
+			"ssl": true
 		}
     }
 }
diff --git "[FORUM_EXT]/sitesplat\\badgeautogroups/diff_full.tmp" "[FORUM_EXT]/sitesplat\\badgeautogroups/diff_full.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\badgeautogroups/diff_full.tmp"
@@ -0,0 +1,17 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\badgeautogroups/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\badgeautogroups/composer.json"
+index 93f85576a..c7ee7f097 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\badgeautogroups/composer.json"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\badgeautogroups/composer.json"
+@@ -28,7 +28,8 @@
+        "version-check": {
+             "host": "www.sitesplat.com",
+             "directory": "/updatecheck/phpbb32/ext",
+-            "filename": "bbawards_autogroup.json"
++            "filename": "bbawards_autogroup.json",
++			"ssl": true
+ 		}
+     }
+ }
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\badgeautogroups/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\badgeautogroups/diff_full.tmp"
+new file mode 100644
+index 000000000..e69de29bb
diff --git "[FORUM_EXT]/sitesplat\\badgeautogroups/diff_nospace.tmp" "[FORUM_EXT]/sitesplat\\badgeautogroups/diff_nospace.tmp"
new file mode 100644
```
