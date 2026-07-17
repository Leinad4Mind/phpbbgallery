Existem diferencas reais no codigo ou texto. Diferencas de formatacao (espacos, tabs) foram ignoradas abaixo.

```diff
diff --git "[FORUM_EXT]/devspace\\logsearches/diff_full.tmp" "[FORUM_EXT]/devspace\\logsearches/diff_full.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/devspace\\logsearches/diff_full.tmp"
@@ -0,0 +1,17 @@
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\devspace\\logsearches/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\devspace\\logsearches/diff_full.tmp"
+new file mode 100644
+index 000000000..e69de29bb
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\devspace\\logsearches/event/listener.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\devspace\\logsearches/event/listener.php"
+index c6f3f9635..dd0935a67 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\devspace\\logsearches/event/listener.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\devspace\\logsearches/event/listener.php"
+@@ -146,6 +146,9 @@ class listener implements EventSubscriberInterface
+ 
+ 		$result = $this->db->sql_query($sql);
+ 
++		$forum_ary = [];
++		$forum_id_ary = [];
++
+ 		while ($row = $this->db->sql_fetchrow($result))
+ 		{
+ 			$forum_ary[] = $row;
diff --git "[FORUM_EXT]/devspace\\logsearches/diff_nospace.tmp" "[FORUM_EXT]/devspace\\logsearches/diff_nospace.tmp"
new file mode 100644
diff --git "[ORIGINAL]/devspace\\logsearches/event/listener.php" "[FORUM_EXT]/devspace\\logsearches/event/listener.php"
--- "[ORIGINAL]/devspace\\logsearches/event/listener.php"
+++ "[FORUM_EXT]/devspace\\logsearches/event/listener.php"
@@ -146,6 +146,9 @@ class listener implements EventSubscriberInterface
 
 		$result = $this->db->sql_query($sql);
 
+		$forum_ary = [];
+		$forum_id_ary = [];
+
 		while ($row = $this->db->sql_fetchrow($result))
 		{
 			$forum_ary[] = $row;
```
