Existem diferencas reais no codigo ou texto. Diferencas de formatacao (espacos, tabs) foram ignoradas abaixo.

```diff
diff --git "[ORIGINAL]/javiexin\\nndeletepm/composer.json" "[FORUM_EXT]/javiexin\\nndeletepm/composer.json"
--- "[ORIGINAL]/javiexin\\nndeletepm/composer.json"
+++ "[FORUM_EXT]/javiexin\\nndeletepm/composer.json"
@@ -1,9 +1,9 @@
 {
     "name": "javiexin/nndeletepm",
     "type": "phpbb-extension",
-    "description": "When a private message is deleted before being read (ie, in the outbox), it is deleted without notice to others",
-    "version": "1.0.1",
-    "time": "2025-08-16",
+    "description": "When a post is deleted before being sent (ie, in the outbox), it is deleted without notice to others",
+    "version": "1.0.0",
+    "time": "2016-11-18",
     "keywords": [
         "phpbb",
         "extension",
@@ -13,14 +13,10 @@
     ],
     "license": "GPL-2.0",
     "authors": [
-        {
-            "name": "Leinad4Mind",
-            "role": "Developer"
-        },
         {
             "name": "Javier Lopez (javiexin)",
             "email": "javiexin@gmail.com",
-            "role": "Previous Developer (RIP)"
+            "role": "Developer"
         },
         {
             "name": "JimA",
diff --git "[FORUM_EXT]/javiexin\\nndeletepm/diff_full.tmp" "[FORUM_EXT]/javiexin\\nndeletepm/diff_full.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/javiexin\\nndeletepm/diff_full.tmp"
@@ -0,0 +1,107 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\javiexin\\nndeletepm/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\javiexin\\nndeletepm/composer.json"
+index 8c7ab64d0..612efabb6 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\javiexin\\nndeletepm/composer.json"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\javiexin\\nndeletepm/composer.json"
+@@ -1,9 +1,9 @@
+ {
+     "name": "javiexin/nndeletepm",
+     "type": "phpbb-extension",
+-    "description": "When a private message is deleted before being read (ie, in the outbox), it is deleted without notice to others",
+-    "version": "1.0.1",
+-    "time": "2025-08-16",
++    "description": "When a post is deleted before being sent (ie, in the outbox), it is deleted without notice to others",
++    "version": "1.0.0",
++    "time": "2016-11-18",
+     "keywords": [
+         "phpbb",
+         "extension",
+@@ -13,14 +13,10 @@
+     ],
+     "license": "GPL-2.0",
+     "authors": [
+-        {
+-            "name": "Leinad4Mind",
+-            "role": "Developer"
+-        },
+         {
+             "name": "Javier Lopez (javiexin)",
+             "email": "javiexin@gmail.com",
+-            "role": "Previous Developer (RIP)"
++            "role": "Developer"
+         },
+         {
+             "name": "JimA",
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\javiexin\\nndeletepm/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\javiexin\\nndeletepm/diff_full.tmp"
+new file mode 100644
+index 000000000..e69de29bb
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\javiexin\\nndeletepm/event/listener.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\javiexin\\nndeletepm/event/listener.php"
+index cc8fa3ea9..026446bd6 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\javiexin\\nndeletepm/event/listener.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\javiexin\\nndeletepm/event/listener.php"
+@@ -3,7 +3,7 @@
+  *
+  * No notice on unread deleted PMs. An extension for the phpBB Forum Software package.
+  *
+- * @copyright (c) 2016, javiexin | 2025, Leinad4Mind
++ * @copyright (c) 2016, javiexin
+  * @license GNU General Public License, version 2 (GPL-2.0)
+  *
+  */
+@@ -47,9 +47,9 @@ class listener implements EventSubscriberInterface
+ 	 */
+ 	public function delete_pm_before($event)
+ 	{
+-		$user_id = (int) $event['user_id'];
+-		$msg_ids = array_map('intval', $event['msg_ids']);
+-		$folder_id = (int) $event['folder_id'];
++		$user_id = $event['user_id'];
++		$msg_ids = $event['msg_ids'];
++		$folder_id = $event['folder_id'];
+ 
+ 		// Only applies to messages deleted from the outbox
+ 		if ($folder_id !== PRIVMSGS_OUTBOX)
+@@ -60,7 +60,7 @@ class listener implements EventSubscriberInterface
+ 		// Validate that the messages are still pending to be deleted
+ 		$sql = 'SELECT msg_id
+ 			FROM ' . PRIVMSGS_TO_TABLE . '
+-			WHERE ' . $this->db->sql_in_set('msg_id', $msg_ids) . "
++			WHERE ' . $this->db->sql_in_set('msg_id', array_map('intval', $msg_ids)) . "
+ 				AND folder_id = $folder_id
+ 				AND user_id = $user_id";
+ 		$result = $this->db->sql_query($sql);
+@@ -68,7 +68,7 @@ class listener implements EventSubscriberInterface
+ 		$delete_rows = array();
+ 		while ($row = $this->db->sql_fetchrow($result))
+ 		{
+-			$delete_rows[(int) $row['msg_id']] = 1;
++			$delete_rows[$row['msg_id']] = 1;
+ 		}
+ 		$this->db->sql_freeresult($result);
+ 
+@@ -81,8 +81,7 @@ class listener implements EventSubscriberInterface
+ 		$this->db->sql_transaction('begin');
+ 
+ 		// Delete the private message recipients that are pending, but not the sender
+-		$sql = 'SELECT user_id
+-			FROM ' . PRIVMSGS_TO_TABLE . '
++		$sql = 'SELECT user_id FROM ' . PRIVMSGS_TO_TABLE . '
+ 			WHERE author_id = ' . $user_id . '
+ 			AND user_id <> ' . $user_id . '
+ 			AND ' . $this->db->sql_in_set('msg_id', array_keys($delete_rows));
+@@ -93,7 +92,7 @@ class listener implements EventSubscriberInterface
+ 		{
+ 			$sql = 'UPDATE ' . USERS_TABLE . '
+ 				SET user_new_privmsg = user_new_privmsg - 1, user_unread_privmsg = user_unread_privmsg - 1
+-				WHERE user_id = ' . (int) $row['user_id'];
++				WHERE user_id = ' . $row['user_id'];
+ 			$this->db->sql_query($sql);
+ 		}
+ 
+@@ -104,5 +103,7 @@ class listener implements EventSubscriberInterface
+ 		$this->db->sql_query($sql);
+ 
+ 		$this->db->sql_transaction('commit');
++
++		return;
+ 	}
+ }
diff --git "[FORUM_EXT]/javiexin\\nndeletepm/diff_nospace.tmp" "[FORUM_EXT]/javiexin\\nndeletepm/diff_nospace.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/javiexin\\nndeletepm/diff_nospace.tmp"
@@ -0,0 +1,82 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\javiexin\\nndeletepm/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\javiexin\\nndeletepm/composer.json"
+index 8c7ab64d0..612efabb6 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\javiexin\\nndeletepm/composer.json"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\javiexin\\nndeletepm/composer.json"
+@@ -1,9 +1,9 @@
+ {
+     "name": "javiexin/nndeletepm",
+     "type": "phpbb-extension",
+-    "description": "When a private message is deleted before being read (ie, in the outbox), it is deleted without notice to others",
+-    "version": "1.0.1",
+-    "time": "2025-08-16",
++    "description": "When a post is deleted before being sent (ie, in the outbox), it is deleted without notice to others",
++    "version": "1.0.0",
++    "time": "2016-11-18",
+     "keywords": [
+         "phpbb",
+         "extension",
+@@ -13,14 +13,10 @@
+     ],
+     "license": "GPL-2.0",
+     "authors": [
+-        {
+-            "name": "Leinad4Mind",
+-            "role": "Developer"
+-        },
+         {
+             "name": "Javier Lopez (javiexin)",
+             "email": "javiexin@gmail.com",
+-            "role": "Previous Developer (RIP)"
++            "role": "Developer"
+         },
+         {
+             "name": "JimA",
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\javiexin\\nndeletepm/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\javiexin\\nndeletepm/diff_full.tmp"
+new file mode 100644
+index 000000000..e81406c90
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\javiexin\\nndeletepm/diff_full.tmp"
+@@ -0,0 +1,107 @@
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\javiexin\\nndeletepm/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\javiexin\\nndeletepm/composer.json"
++index 8c7ab64d0..612efabb6 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\javiexin\\nndeletepm/composer.json"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\javiexin\\nndeletepm/composer.json"
++@@ -1,9 +1,9 @@
++ {
++     "name": "javiexin/nndeletepm",
++     "type": "phpbb-extension",
++-    "description": "When a private message is deleted before being read (ie, in the outbox), it is deleted without notice to others",
++-    "version": "1.0.1",
++-    "time": "2025-08-16",
+++    "description": "When a post is deleted before being sent (ie, in the outbox), it is deleted without notice to others",
+++    "version": "1.0.0",
+++    "time": "2016-11-18",
++     "keywords": [
++         "phpbb",
++         "extension",
++@@ -13,14 +13,10 @@
++     ],
++     "license": "GPL-2.0",
++     "authors": [
++-        {
++-            "name": "Leinad4Mind",
++-            "role": "Developer"
++-        },
++         {
++             "name": "Javier Lopez (javiexin)",
++             "email": "javiexin@gmail.com",
++-            "role": "Previous Developer (RIP)"
+++            "role": "Developer"
++         },
++         {
++             "name": "JimA",
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\javiexin\\nndeletepm/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\javiexin\\nndeletepm/diff_full.tmp"
++new file mode 100644
++index 000000000..e69de29bb
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\javiexin\\nndeletepm/event/listener.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\javiexin\\nndeletepm/event/listener.php"
++index cc8fa3ea9..026446bd6 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\javiexin\\nndeletepm/event/listener.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\javiexin\\nndeletepm/event/listener.php"
++@@ -3,7 +3,7 @@
++  *
++  * No notice on unread deleted PMs. An extension for the phpBB Forum S
\ No newline at end of file
diff --git "[ORIGINAL]/javiexin\\nndeletepm/event/listener.php" "[FORUM_EXT]/javiexin\\nndeletepm/event/listener.php"
--- "[ORIGINAL]/javiexin\\nndeletepm/event/listener.php"
+++ "[FORUM_EXT]/javiexin\\nndeletepm/event/listener.php"
@@ -3,7 +3,7 @@
  *
  * No notice on unread deleted PMs. An extension for the phpBB Forum Software package.
  *
- * @copyright (c) 2016, javiexin | 2025, Leinad4Mind
+ * @copyright (c) 2016, javiexin
  * @license GNU General Public License, version 2 (GPL-2.0)
  *
  */
@@ -47,9 +47,9 @@ class listener implements EventSubscriberInterface
 	 */
 	public function delete_pm_before($event)
 	{
-		$user_id = (int) $event['user_id'];
-		$msg_ids = array_map('intval', $event['msg_ids']);
-		$folder_id = (int) $event['folder_id'];
+		$user_id = $event['user_id'];
+		$msg_ids = $event['msg_ids'];
+		$folder_id = $event['folder_id'];
 
 		// Only applies to messages deleted from the outbox
 		if ($folder_id !== PRIVMSGS_OUTBOX)
@@ -60,7 +60,7 @@ class listener implements EventSubscriberInterface
 		// Validate that the messages are still pending to be deleted
 		$sql = 'SELECT msg_id
 			FROM ' . PRIVMSGS_TO_TABLE . '
-			WHERE ' . $this->db->sql_in_set('msg_id', $msg_ids) . "
+			WHERE ' . $this->db->sql_in_set('msg_id', array_map('intval', $msg_ids)) . "
 				AND folder_id = $folder_id
 				AND user_id = $user_id";
 		$result = $this->db->sql_query($sql);
@@ -68,7 +68,7 @@ class listener implements EventSubscriberInterface
 		$delete_rows = array();
 		while ($row = $this->db->sql_fetchrow($result))
 		{
-			$delete_rows[(int) $row['msg_id']] = 1;
+			$delete_rows[$row['msg_id']] = 1;
 		}
 		$this->db->sql_freeresult($result);
 
@@ -81,8 +81,7 @@ class listener implements EventSubscriberInterface
 		$this->db->sql_transaction('begin');
 
 		// Delete the private message recipients that are pending, but not the sender
-		$sql = 'SELECT user_id
-			FROM ' . PRIVMSGS_TO_TABLE . '
+		$sql = 'SELECT user_id FROM ' . PRIVMSGS_TO_TABLE . '
 			WHERE author_id = ' . $user_id . '
 			AND user_id <> ' . $user_id . '
 			AND ' . $this->db->sql_in_set('msg_id', array_keys($delete_rows));
@@ -93,7 +92,7 @@ class listener implements EventSubscriberInterface
 		{
 			$sql = 'UPDATE ' . USERS_TABLE . '
 				SET user_new_privmsg = user_new_privmsg - 1, user_unread_privmsg = user_unread_privmsg - 1
-				WHERE user_id = ' . (int) $row['user_id'];
+				WHERE user_id = ' . $row['user_id'];
 			$this->db->sql_query($sql);
 		}
 
@@ -104,5 +103,7 @@ class listener implements EventSubscriberInterface
 		$this->db->sql_query($sql);
 
 		$this->db->sql_transaction('commit');
+
+		return;
 	}
 }
```
