Existem diferencas reais no codigo ou texto. Diferencas de formatacao (espacos, tabs) foram ignoradas abaixo.

```diff
diff --git "[ORIGINAL]/forumhulp\\postsstats/config/tables.yml" "[FORUM_EXT]/forumhulp\\postsstats/config/tables.yml"
--- "[ORIGINAL]/forumhulp\\postsstats/config/tables.yml"
+++ "[FORUM_EXT]/forumhulp\\postsstats/config/tables.yml"
@@ -1,3 +1,3 @@
 parameters:
-    tables.poststatconfig_table: %core.table_prefix%postsstat_config
-    tables.poststatdomain_table: %core.table_prefix%postsstat_domains
+    tables.poststatconfig_table: '%core.table_prefix%postsstat_config'
+    tables.poststatdomain_table: '%core.table_prefix%postsstat_domains'
diff --git "[FORUM_EXT]/forumhulp\\postsstats/diff_full.tmp" "[FORUM_EXT]/forumhulp\\postsstats/diff_full.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/forumhulp\\postsstats/diff_full.tmp"
@@ -0,0 +1,13 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\postsstats/config/tables.yml" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\postsstats/config/tables.yml"
+index 9d24afb16..dbd4d4edc 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\postsstats/config/tables.yml"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\postsstats/config/tables.yml"
+@@ -1,3 +1,3 @@
+ parameters:
+-    tables.poststatconfig_table: %core.table_prefix%postsstat_config
+-    tables.poststatdomain_table: %core.table_prefix%postsstat_domains
++    tables.poststatconfig_table: '%core.table_prefix%postsstat_config'
++    tables.poststatdomain_table: '%core.table_prefix%postsstat_domains'
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\postsstats/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\postsstats/diff_full.tmp"
+new file mode 100644
+index 000000000..e69de29bb
diff --git "[FORUM_EXT]/forumhulp\\postsstats/diff_nospace.tmp" "[FORUM_EXT]/forumhulp\\postsstats/diff_nospace.tmp"
new file mode 100644
```
