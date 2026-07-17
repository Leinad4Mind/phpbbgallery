Existem diferencas reais no codigo ou texto. Diferencas de formatacao (espacos, tabs) foram ignoradas abaixo.

```diff
diff --git "[ORIGINAL]/leinad4mind\\pmwelcome/core/pmwelcome.php" "[FORUM_EXT]/leinad4mind\\pmwelcome/core/pmwelcome.php"
--- "[ORIGINAL]/leinad4mind\\pmwelcome/core/pmwelcome.php"
+++ "[FORUM_EXT]/leinad4mind\\pmwelcome/core/pmwelcome.php"
@@ -60,7 +60,7 @@ class pmwelcome
 
       $sql = 'SELECT user_id, username, user_colour
 			FROM ' . USERS_TABLE . "
-			WHERE user_id = " . (int) $user_id . ' AND user_type <> ' . USER_IGNORE;
+			WHERE user_id = " . (int) $user_id;
       $result = $this->db->sql_query($sql);
       $sender_info = $this->db->sql_fetchrow($result);
       $this->db->sql_freeresult($result);
diff --git "[FORUM_EXT]/leinad4mind\\pmwelcome/diff_full.tmp" "[FORUM_EXT]/leinad4mind\\pmwelcome/diff_full.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/leinad4mind\\pmwelcome/diff_full.tmp"
@@ -0,0 +1,16 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\pmwelcome/core/pmwelcome.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\pmwelcome/core/pmwelcome.php"
+index c2b3e170d..c1600eec6 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\pmwelcome/core/pmwelcome.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\pmwelcome/core/pmwelcome.php"
+@@ -60,7 +60,7 @@ class pmwelcome
+ 
+       $sql = 'SELECT user_id, username, user_colour
+ 			FROM ' . USERS_TABLE . "
+-			WHERE user_id = " . (int) $user_id . ' AND user_type <> ' . USER_IGNORE;
++			WHERE user_id = " . (int) $user_id;
+       $result = $this->db->sql_query($sql);
+       $sender_info = $this->db->sql_fetchrow($result);
+       $this->db->sql_freeresult($result);
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\pmwelcome/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\pmwelcome/diff_full.tmp"
+new file mode 100644
+index 000000000..e69de29bb
diff --git "[FORUM_EXT]/leinad4mind\\pmwelcome/diff_nospace.tmp" "[FORUM_EXT]/leinad4mind\\pmwelcome/diff_nospace.tmp"
new file mode 100644
```
