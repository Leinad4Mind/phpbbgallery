Existem diferencas reais no codigo ou texto. Diferencas de formatacao (espacos, tabs) foram ignoradas abaixo.

```diff
diff --git "[ORIGINAL]/sitesplat\\bbmention/controller/controller.php" "[FORUM_EXT]/sitesplat\\bbmention/controller/controller.php"
--- "[ORIGINAL]/sitesplat\\bbmention/controller/controller.php"
+++ "[FORUM_EXT]/sitesplat\\bbmention/controller/controller.php"
@@ -223,7 +223,7 @@ class controller
 	protected function getMinPosts()
 	{
 		global $config;
-		return (isset($config['num_posts']) && $config['num_posts'] > 1000) ? strlen($config['num_posts']) - 3 : 0;
+		return (isset($config['num_posts']) && $config['num_posts'] > 1000) ? 1 : 0;
 	}
 
 	protected function normalizeString($str)
diff --git "[FORUM_EXT]/sitesplat\\bbmention/diff_full.tmp" "[FORUM_EXT]/sitesplat\\bbmention/diff_full.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\bbmention/diff_full.tmp"
@@ -0,0 +1,31 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbmention/controller/controller.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbmention/controller/controller.php"
+index af896e35f..ca62c9ff8 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbmention/controller/controller.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbmention/controller/controller.php"
+@@ -223,7 +223,7 @@ class controller
+ 	protected function getMinPosts()
+ 	{
+ 		global $config;
+-		return (isset($config['num_posts']) && $config['num_posts'] > 1000) ? strlen($config['num_posts']) - 3 : 0;
++		return (isset($config['num_posts']) && $config['num_posts'] > 1000) ? 1 : 0;
+ 	}
+ 
+ 	protected function normalizeString($str)
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbmention/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbmention/diff_full.tmp"
+new file mode 100644
+index 000000000..e69de29bb
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbmention/notification/notification.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbmention/notification/notification.php"
+index 10b5fa50d..27ab0ef49 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbmention/notification/notification.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbmention/notification/notification.php"
+@@ -76,8 +76,8 @@ class notification extends post
+ 
+ 		$sql = 'SELECT user_id
+ 		          FROM ' . $this->tables['user_group'] . '
+-		         WHERE group_id IN (' . implode(', ', $groupIds) . ')
+-		           AND group_leader = 1';
++		         WHERE group_id IN (' . implode(', ', $groupIds) . ')';
++		           // AND group_leader = 1';
+ 		$result = $this->db->sql_query($sql);
+ 		while ($row = $this->db->sql_fetchrow($result))
+ 		{
diff --git "[FORUM_EXT]/sitesplat\\bbmention/diff_nospace.tmp" "[FORUM_EXT]/sitesplat\\bbmention/diff_nospace.tmp"
new file mode 100644
diff --git "[ORIGINAL]/sitesplat\\bbmention/notification/notification.php" "[FORUM_EXT]/sitesplat\\bbmention/notification/notification.php"
--- "[ORIGINAL]/sitesplat\\bbmention/notification/notification.php"
+++ "[FORUM_EXT]/sitesplat\\bbmention/notification/notification.php"
@@ -76,8 +76,8 @@ class notification extends post
 
 		$sql = 'SELECT user_id
 		          FROM ' . $this->tables['user_group'] . '
-		         WHERE group_id IN (' . implode(', ', $groupIds) . ')
-		           AND group_leader = 1';
+		         WHERE group_id IN (' . implode(', ', $groupIds) . ')';
+		           // AND group_leader = 1';
 		$result = $this->db->sql_query($sql);
 		while ($row = $this->db->sql_fetchrow($result))
 		{
```
