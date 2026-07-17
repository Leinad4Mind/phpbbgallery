Existem diferencas reais no codigo ou texto. Diferencas de formatacao (espacos, tabs) foram ignoradas abaixo.

```diff
diff --git "[FORUM_EXT]/sitesplat\\bbtracking/diff_full.tmp" "[FORUM_EXT]/sitesplat\\bbtracking/diff_full.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\bbtracking/diff_full.tmp"
@@ -0,0 +1,16 @@
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbtracking/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbtracking/diff_full.tmp"
+new file mode 100644
+index 000000000..e69de29bb
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbtracking/event/postrev_listener.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbtracking/event/postrev_listener.php"
+index dccdf6d42..63ffbc029 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbtracking/event/postrev_listener.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbtracking/event/postrev_listener.php"
+@@ -135,7 +135,7 @@ class postrev_listener implements EventSubscriberInterface
+ 		if (!empty($event['post_list']))
+ 		{
+ 			#$sql	= "SELECT post_id FROM {$this->revisions_table} WHERE post_id IN(" . implode(', ', $event['post_list']) . ') GROUP BY post_id';
+-			$sql	= "SELECT post_id FROM {$this->revisions_table} WHERE " . $this->db->sql_in_set('post_id', $event['post_list']) . ' GROUP BY post_id';
++			$sql	= "SELECT DISTINCT post_id FROM {$this->revisions_table} WHERE " . $this->db->sql_in_set('post_id', $event['post_list']);
+ 			$result	= $this->db->sql_query($sql);
+ 			while ($row = $this->db->sql_fetchrow($result))
+ 			{
diff --git "[FORUM_EXT]/sitesplat\\bbtracking/diff_nospace.tmp" "[FORUM_EXT]/sitesplat\\bbtracking/diff_nospace.tmp"
new file mode 100644
diff --git "[ORIGINAL]/sitesplat\\bbtracking/event/postrev_listener.php" "[FORUM_EXT]/sitesplat\\bbtracking/event/postrev_listener.php"
--- "[ORIGINAL]/sitesplat\\bbtracking/event/postrev_listener.php"
+++ "[FORUM_EXT]/sitesplat\\bbtracking/event/postrev_listener.php"
@@ -135,7 +135,7 @@ class postrev_listener implements EventSubscriberInterface
 		if (!empty($event['post_list']))
 		{
 			#$sql	= "SELECT post_id FROM {$this->revisions_table} WHERE post_id IN(" . implode(', ', $event['post_list']) . ') GROUP BY post_id';
-			$sql	= "SELECT post_id FROM {$this->revisions_table} WHERE " . $this->db->sql_in_set('post_id', $event['post_list']) . ' GROUP BY post_id';
+			$sql	= "SELECT DISTINCT post_id FROM {$this->revisions_table} WHERE " . $this->db->sql_in_set('post_id', $event['post_list']);
 			$result	= $this->db->sql_query($sql);
 			while ($row = $this->db->sql_fetchrow($result))
 			{
```
