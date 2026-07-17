Existem diferencas reais no codigo ou texto. Diferencas de formatacao (espacos, tabs) foram ignoradas abaixo.

```diff
diff --git "[ORIGINAL]/sitesplat\\castle/composer.json" "[FORUM_EXT]/sitesplat\\castle/composer.json"
--- "[ORIGINAL]/sitesplat\\castle/composer.json"
+++ "[FORUM_EXT]/sitesplat\\castle/composer.json"
@@ -26,7 +26,8 @@
 		"version-check": {
             "host": "www.sitesplat.com",
             "directory": "/updatecheck/phpbb32/ext",
-            "filename": "bbcastle.json"
+            "filename": "bbcastle.json",
+			"ssl": true
 		}
     }
 }
diff --git "[FORUM_EXT]/sitesplat\\castle/diff_full.tmp" "[FORUM_EXT]/sitesplat\\castle/diff_full.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\castle/diff_full.tmp"
@@ -0,0 +1,17 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\castle/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\castle/composer.json"
+index 238c0dbdb..4b0458104 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\castle/composer.json"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\castle/composer.json"
+@@ -26,7 +26,8 @@
+ 		"version-check": {
+             "host": "www.sitesplat.com",
+             "directory": "/updatecheck/phpbb32/ext",
+-            "filename": "bbcastle.json"
++            "filename": "bbcastle.json",
++			"ssl": true
+ 		}
+     }
+ }
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\castle/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\castle/diff_full.tmp"
+new file mode 100644
+index 000000000..e69de29bb
diff --git "[FORUM_EXT]/sitesplat\\castle/diff_nospace.tmp" "[FORUM_EXT]/sitesplat\\castle/diff_nospace.tmp"
new file mode 100644
```
