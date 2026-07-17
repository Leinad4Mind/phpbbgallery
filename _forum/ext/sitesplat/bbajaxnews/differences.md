Existem diferencas reais no codigo ou texto. Diferencas de formatacao (espacos, tabs) foram ignoradas abaixo.

```diff
diff --git "[ORIGINAL]/sitesplat\\bbajaxnews/ajaxnews/type/random_poll.php" "[FORUM_EXT]/sitesplat\\bbajaxnews/ajaxnews/type/random_poll.php"
--- "[ORIGINAL]/sitesplat\\bbajaxnews/ajaxnews/type/random_poll.php"
+++ "[FORUM_EXT]/sitesplat\\bbajaxnews/ajaxnews/type/random_poll.php"
@@ -39,7 +39,7 @@ class random_poll extends base
 
 		$sql = 'SELECT t.topic_id, t.poll_title FROM ' . $this->topics_table . ' t
 			WHERE ' . $this->db->sql_in_set('t.forum_id', $forums) . '
-			AND t.poll_start <> 0
+			AND t.poll_start > (' . time() . ' - 31556926)
 			AND (t.poll_length = 0 OR t.poll_start + t.poll_length > ' . time() . ')
 			AND t.topic_poster <> ' . $this->user->data['user_id'] . '
 			AND t.topic_status NOT IN (1, 2)
diff --git "[FORUM_EXT]/sitesplat\\bbajaxnews/diff_full.tmp" "[FORUM_EXT]/sitesplat\\bbajaxnews/diff_full.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\bbajaxnews/diff_full.tmp"
@@ -0,0 +1,16 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbajaxnews/ajaxnews/type/random_poll.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbajaxnews/ajaxnews/type/random_poll.php"
+index 99d5e5bf2..8ca310e13 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbajaxnews/ajaxnews/type/random_poll.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbajaxnews/ajaxnews/type/random_poll.php"
+@@ -39,7 +39,7 @@ class random_poll extends base
+ 
+ 		$sql = 'SELECT t.topic_id, t.poll_title FROM ' . $this->topics_table . ' t
+ 			WHERE ' . $this->db->sql_in_set('t.forum_id', $forums) . '
+-			AND t.poll_start <> 0
++			AND t.poll_start > (' . time() . ' - 31556926)
+ 			AND (t.poll_length = 0 OR t.poll_start + t.poll_length > ' . time() . ')
+ 			AND t.topic_poster <> ' . $this->user->data['user_id'] . '
+ 			AND t.topic_status NOT IN (1, 2)
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbajaxnews/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbajaxnews/diff_full.tmp"
+new file mode 100644
+index 000000000..e69de29bb
diff --git "[FORUM_EXT]/sitesplat\\bbajaxnews/diff_nospace.tmp" "[FORUM_EXT]/sitesplat\\bbajaxnews/diff_nospace.tmp"
new file mode 100644
```
