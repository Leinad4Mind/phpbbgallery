Existem diferencas reais no codigo ou texto. Diferencas de formatacao (espacos, tabs) foram ignoradas abaixo.

```diff
diff --git "[ORIGINAL]/sitesplat\\cas/composer.json" "[FORUM_EXT]/sitesplat\\cas/composer.json"
--- "[ORIGINAL]/sitesplat\\cas/composer.json"
+++ "[FORUM_EXT]/sitesplat\\cas/composer.json"
@@ -24,7 +24,8 @@
 		"version-check": {
             "host": "sitesplat.com",
             "directory": "/updatecheck/phpbb32/ext",
-            "filename": "cas.json"
+            "filename": "cas.json",
+			"ssl": true
 		}
     }
 }
\ No newline at end of file
diff --git "[FORUM_EXT]/sitesplat\\cas/diff_full.tmp" "[FORUM_EXT]/sitesplat\\cas/diff_full.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\cas/diff_full.tmp"
@@ -0,0 +1,18 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\cas/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\cas/composer.json"
+index 674075baf..5b3ad0da3 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\cas/composer.json"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\cas/composer.json"
+@@ -24,7 +24,8 @@
+ 		"version-check": {
+             "host": "sitesplat.com",
+             "directory": "/updatecheck/phpbb32/ext",
+-            "filename": "cas.json"
++            "filename": "cas.json",
++			"ssl": true
+ 		}
+     }
+ }
+\ No newline at end of file
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\cas/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\cas/diff_full.tmp"
+new file mode 100644
+index 000000000..e69de29bb
diff --git "[FORUM_EXT]/sitesplat\\cas/diff_nospace.tmp" "[FORUM_EXT]/sitesplat\\cas/diff_nospace.tmp"
new file mode 100644
```
