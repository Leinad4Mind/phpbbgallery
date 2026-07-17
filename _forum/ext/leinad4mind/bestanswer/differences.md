Existem diferencas reais no codigo ou texto. Diferencas de formatacao (espacos, tabs) foram ignoradas abaixo.

```diff
diff --git "[ORIGINAL]/leinad4mind\\bestanswer/README.md" "[ORIGINAL]/leinad4mind\\bestanswer/README.md"
deleted file mode 100644
--- "[ORIGINAL]/leinad4mind\\bestanswer/README.md"
+++ /dev/null
@@ -1,11 +0,0 @@
-# Best Answer
-
-## Installation
-
-Copy the extension to phpBB/ext/leinad4mind/bestanswer
-
-Go to "ACP" > "Customise" > "Extensions" and enable the "Best Answer Special Edition" extension.
-
-## License
-
-[GPLv2](license.txt)
diff --git "[ORIGINAL]/leinad4mind\\bestanswer/adm/style/event/acp_forums_normal_settings_append.html" "[FORUM_EXT]/leinad4mind\\bestanswer/adm/style/event/acp_forums_normal_settings_append.html"
--- "[ORIGINAL]/leinad4mind\\bestanswer/adm/style/event/acp_forums_normal_settings_append.html"
+++ "[FORUM_EXT]/leinad4mind\\bestanswer/adm/style/event/acp_forums_normal_settings_append.html"
@@ -1,11 +1,11 @@
 <dl>
-	<dt><label for="enable_answer">{{ lang('ENABLE_ANSWER') ~ lang('COLON') }}</label><br /><span>{{ lang('ENABLE_ANSWER_EXPLAIN') }}</span></dt>
+	<dt><label for="enable_answer">{{ lang('ENABLE_ANSWER') }}{{ lang('COLON') }}</label><br /><span>{{ lang('ENABLE_ANSWER_EXPLAIN') }}</span></dt>
 	<dd><label><input type="radio" class="radio" name="enable_answer" value="1"{% if S_ENABLE_ANSWER %} id="enable_answer" checked="checked"{% endif %} /> {{ lang('YES') }}</label>
 		<label><input type="radio" class="radio" name="enable_answer" value="0"{% if not S_ENABLE_ANSWER %} id="enable_answer" checked="checked"{% endif %} /> {{ lang('NO') }}</label></dd>
 </dl>
 
 <dl>
-	<dt><label for="bbpoints_answer">{{ lang('BBPOINTS_ANSWER') ~ lang('COLON') }}</label><br /><span>{{ lang('BBPOINTS_ANSWER_EXPLAIN') }}</span></dt>
+	<dt><label for="bbpoints_answer">{{ lang('BBPOINTS_ANSWER') }}{{ lang('COLON') }}</label><br /><span>{{ lang('BBPOINTS_ANSWER_EXPLAIN') }}</span></dt>
 	<dd>
 		<label><input type="number" name="bbpoints_answer" value="{S_BBPOINTS_ANSWER}"/></label>
 	</dd>
diff --git "[ORIGINAL]/leinad4mind\\bestanswer/composer.json" "[FORUM_EXT]/leinad4mind\\bestanswer/composer.json"
--- "[ORIGINAL]/leinad4mind\\bestanswer/composer.json"
+++ "[FORUM_EXT]/leinad4mind\\bestanswer/composer.json"
@@ -1,10 +1,10 @@
 {
     "name": "leinad4mind/bestanswer",
     "type": "phpbb-extension",
-    "description": "An extension for phpBB that allows users to mark a post as the 'Best Answer'.",
+    "description": "An extension for phpBB that allows users to mark a post as the best answer.",
     "homepage": "https://leinad4mind.top/forum",
-    "version": "2.1.0",
-    "time": "2025-08-16",
+    "version": "2.0.2",
+    "time": "2021-01-30",
     "keywords": [ "phpbb", "extension", "best", "answer", "leinad4mind", "special" ],
     "license": "GPL-2.0-only",
     "authors": [
@@ -20,18 +20,18 @@
     ],
     "require": {
         "php": ">=5.4.7",
-        "phpbb/phpbb": ">=3.2.0,<4.0.0",
+        "phpbb/phpbb": ">=3.2.0,<3.3.0@dev",
         "composer/installers": "~1.0.0"
     },
     "extra": {
         "display-name": "Best Answer Special Edition",
         "soft-require": {
-            "phpbb/phpbb": ">=3.2.0,<4.0.0"
+            "phpbb/phpbb": ">=3.2.0,<3.3.0@dev"
         },
         "version-check": {
             "host": "leinad4mind.top",
             "directory": "/phpbb/bestanswer_special",
-            "filename": "version_check"
+            "filename": "version_check.json"
         }
     }
 }
\ No newline at end of file
diff --git "[ORIGINAL]/leinad4mind\\bestanswer/controller/main_controller.php" "[FORUM_EXT]/leinad4mind\\bestanswer/controller/main_controller.php"
--- "[ORIGINAL]/leinad4mind\\bestanswer/controller/main_controller.php"
+++ "[FORUM_EXT]/leinad4mind\\bestanswer/controller/main_controller.php"
@@ -4,7 +4,7 @@
  * Best Answer extension for the phpBB Forum Software package.
  *
  * @copyright (c) 2018, kinerity, https://www.layer-3.org/
- * @copyright (c) 2019-2025, Leinad4Mind, https://leinad4mind.top/forum
+ * @copyright (c) 2019-2021, Leinad4Mind, https://leinad4mind.top/forum
  * @license GNU General Public License, version 2 (GPL-2.0)
  *
  */
@@ -51,7 +51,7 @@ class main_controller
 	/* @var string */
 	protected $php_ext;
 
-	/* @var string  */
+	/* @var int bbpoints_table */
 	protected $bbpoints_table;
 	/**
 	 * Constructor
@@ -62,7 +62,7 @@ class main_controller
 	 * @param \phpbb\log\log                      $log
 	 * @param \phpbb\request\request              $request
 	 * @param \phpbb\user                         $user
-	 * @param string                              $bbpoints_table
+	 * @param int								  $bbpoints_table
 	 * @param \phpbb\notification\manager         $notification_manager
 	 * @param string                              $root_path
 	 * @param string                              $php_ext
@@ -99,13 +99,9 @@ class main_controller
 	{
 		$post_id = $this->request->variable('p', 0);
 
-		// Grab all the data necessary for error checking
+		// Query necessary topic data
 		$sql_arr = array(
-			'SELECT'	=> 'f.forum_id, f.enable_answer, f.bbpoints_answer,
-						p.post_id, p.topic_id, p.poster_id, p.post_subject,
-						t.topic_id, t.forum_id, t.topic_title, t.topic_poster, t.topic_status,
-						t.topic_first_post_id, t.answer_post_id, t.answer_user_id,
-						u.user_id, u.username, u.user_colour',
+			'SELECT'	=> 'f.forum_id, f.enable_answer, p.post_id, p.topic_id, p.poster_id, p.post_subject, t.topic_id, t.forum_id, t.topic_title, t.topic_poster, t.topic_status, t.topic_first_post_id, t.answer_post_id, t.answer_user_id, u.user_id, u.username, u.user_colour',
 
 			'FROM'		=> array(
 				FORUMS_TABLE	=> 'f',
@@ -125,17 +121,17 @@ class main_controller
 		// Error checking
 		if (!$topic_data['enable_answer'])
 		{
-			throw new \phpbb\exception\http_exception(404, $this->lang->lang('EXTENSION_NOT_ENABLED')); 
+			throw new \phpbb\exception\http_exception(403, $this->lang->lang('NOT_AUTHORISED'));
 		}
 
-		if ((int) $topic_data['topic_first_post_id'] == (int) $post_id)
+		if (!$this->auth->acl_get('m_mark_answer', (int) $topic_data['forum_id']) && (!$this->auth->acl_get('f_mark_answer', (int) $topic_data['forum_id']) && $topic_data['topic_poster'] != (int) $this->user->data['user_id']))
 		{
-			throw new \phpbb\exception\http_exception(404, $this->lang->lang('TOPIC_FIRST_POST'));
+			throw new \phpbb\exception\http_exception(403, $this->lang->lang('NOT_AUTHORISED'));
 		}
 
-		if (!$this->auth->acl_get('m_mark_answer', (int) $topic_data['forum_id']) && (!$this->auth->acl_get('f_mark_answer', (int) $topic_data['forum_id']) && $topic_data['topic_poster'] != (int) $this->user->data['user_id']))
+		if ((int) $topic_data['topic_first_post_id'] == (int) $post_id)
 		{
-			throw new \phpbb\exception\http_exception(403, $this->lang->lang('NOT_AUTHORISED'));
+			throw new \phpbb\exception\http_exception(404, $this->lang->lang('NOT_AUTHORISED'));
 		}
 
 		if ((int) $topic_data['topic_status'] == ITEM_LOCKED && !$this->auth->acl_get('m_mark_answer', (int) $topic_data['forum_id']))
@@ -166,13 +162,11 @@ class main_controller
 				$post_author = get_username_string('full', (int) $topic_data['user_id'], $topic_data['username'], $topic_data['user_colour']);
 				$this->log->add($log_var, (int) $this->user->data['user_id'], $this->user->data['user_ip'], 'LOG_UNMARK_ANSWER', time(), array($topic_data['post_subject'], $post_author));
 				
-				// Remove BBPoints
-				$reason = $this->db->sql_escape('bestanswer-' . (int) $post_id);
-				$sql = 'DELETE FROM ' . $this->bbpoints_table . '
-					WHERE to_id = ' . (int) $topic_data['user_id'] . '
-					AND reason = "' . $reason . '"';
+				// remove bbpoints
+				$sql = 'DELETE FROM ' . $this->bbpoints_table . ' WHERE
+				to_id=' . (int) $topic_data['user_id'] . ' AND reason="bestanswer-'.$post_id.'"';
 				$this->db->sql_query($sql);
-				$this->log->add($log_var, (int) $topic_data['user_id'], $this->user->data['user_ip'], 'LOG_BBPOINTS_UNMARK_ANSWER', time(), array($topic_data['post_subject'], $post_author));
+				$this->log->add($log_var, (int) $topic_data['user_id'], (int) $this->user->data['user_ip'], 'LOG_BBPOINTS_UNMARK_ANSWER', time(), array($topic_data['post_subject'], $post_author));
 
 				$this->notification_manager->delete_notifications('leinad4mind.bestanswer.notification.type.unmarkanswer', $post_id, $post_id, $topic_data['user_id']);
 				$this->notification_manager->add_notifications('leinad4mind.bestanswer.notification.type.unmarkanswer', [
@@ -230,13 +224,12 @@ class main_controller
 				$post_author = get_username_string('full', (int) $topic_data['user_id'], $topic_data['username'], $topic_data['user_colour']);
 				$this->log->add($log_var, (int) $this->user->data['user_id'], $this->user->data['user_ip'], 'LOG_MARK_ANSWER', time(), array($topic_data['post_subject'], $post_author));
 
-				// Add BBPoints
-				if ((int) $topic_data['bbpoints_answer'] > 0) {
-					$reason = $this->db->sql_escape('bestanswer-' . (int) $post_id);
+				// add bbpoints
+				if ($topic_data['bbpoints_answer'] > 0) {
 					$sql = 'INSERT INTO ' . $this->bbpoints_table . ' (from_id, to_id, bbpoints, reason, timestamp) 
-						VALUES (0, ' . (int) $topic_data['user_id'] . ', ' . (int) $topic_data['bbpoints_answer'] . ', "' . $reason . '", ' . time() . ')';
+						VALUES(0, ' . (int) $topic_data['user_id'] . ', ' . $topic_data['bbpoints_answer'] . ', "bestanswer-'.$post_id.'", ' . time() . ')';
 					$this->db->sql_query($sql);
-					$this->log->add($log_var, (int) $topic_data['user_id'], $this->user->data['user_ip'], 'LOG_BBPOINTS_MARK_ANSWER', time(), array($topic_data['post_subject'], $post_author));				
+					$this->log->add($log_var, (int) $topic_data['user_id'], (int) $this->user->data['user_ip'], 'LOG_BBPOINTS_MARK_ANSWER', time(), array($topic_data['post_subject'], $post_author));				
 				}
 
 				$this->notification_manager->delete_notifications('leinad4mind.bestanswer.notification.type.markanswer', $post_id, $post_id, $topic_data['user_id']);
diff --git "[FORUM_EXT]/leinad4mind\\bestanswer/diff_full.tmp" "[FORUM_EXT]/leinad4mind\\bestanswer/diff_full.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/leinad4mind\\bestanswer/diff_full.tmp"
@@ -0,0 +1,1484 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/README.md" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/README.md"
+deleted file mode 100644
+index 6e49f6ec7..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/README.md"
++++ /dev/null
+@@ -1,11 +0,0 @@
+-# Best Answer
+-
+-## Installation
+-
+-Copy the extension to phpBB/ext/leinad4mind/bestanswer
+-
+-Go to "ACP" > "Customise" > "Extensions" and enable the "Best Answer Special Edition" extension.
+-
+-## License
+-
+-[GPLv2](license.txt)
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/adm/style/event/acp_forums_normal_settings_append.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/adm/style/event/acp_forums_normal_settings_append.html"
+index 706694371..721f353e1 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/adm/style/event/acp_forums_normal_settings_append.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/adm/style/event/acp_forums_normal_settings_append.html"
+@@ -1,11 +1,11 @@
+ <dl>
+-	<dt><label for="enable_answer">{{ lang('ENABLE_ANSWER') ~ lang('COLON') }}</label><br /><span>{{ lang('ENABLE_ANSWER_EXPLAIN') }}</span></dt>
++	<dt><label for="enable_answer">{{ lang('ENABLE_ANSWER') }}{{ lang('COLON') }}</label><br /><span>{{ lang('ENABLE_ANSWER_EXPLAIN') }}</span></dt>
+ 	<dd><label><input type="radio" class="radio" name="enable_answer" value="1"{% if S_ENABLE_ANSWER %} id="enable_answer" checked="checked"{% endif %} /> {{ lang('YES') }}</label>
+ 		<label><input type="radio" class="radio" name="enable_answer" value="0"{% if not S_ENABLE_ANSWER %} id="enable_answer" checked="checked"{% endif %} /> {{ lang('NO') }}</label></dd>
+ </dl>
+ 
+ <dl>
+-	<dt><label for="bbpoints_answer">{{ lang('BBPOINTS_ANSWER') ~ lang('COLON') }}</label><br /><span>{{ lang('BBPOINTS_ANSWER_EXPLAIN') }}</span></dt>
++	<dt><label for="bbpoints_answer">{{ lang('BBPOINTS_ANSWER') }}{{ lang('COLON') }}</label><br /><span>{{ lang('BBPOINTS_ANSWER_EXPLAIN') }}</span></dt>
+ 	<dd>
+ 		<label><input type="number" name="bbpoints_answer" value="{S_BBPOINTS_ANSWER}"/></label>
+ 	</dd>
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/composer.json"
+index 93b532e02..08b0a0dfe 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/composer.json"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/composer.json"
+@@ -1,10 +1,10 @@
+ {
+     "name": "leinad4mind/bestanswer",
+     "type": "phpbb-extension",
+-    "description": "An extension for phpBB that allows users to mark a post as the 'Best Answer'.",
++    "description": "An extension for phpBB that allows users to mark a post as the best answer.",
+     "homepage": "https://leinad4mind.top/forum",
+-    "version": "2.1.0",
+-    "time": "2025-08-16",
++    "version": "2.0.2",
++    "time": "2021-01-30",
+     "keywords": [ "phpbb", "extension", "best", "answer", "leinad4mind", "special" ],
+     "license": "GPL-2.0-only",
+     "authors": [
+@@ -20,18 +20,18 @@
+     ],
+     "require": {
+         "php": ">=5.4.7",
+-        "phpbb/phpbb": ">=3.2.0,<4.0.0",
++        "phpbb/phpbb": ">=3.2.0,<3.3.0@dev",
+         "composer/installers": "~1.0.0"
+     },
+     "extra": {
+         "display-name": "Best Answer Special Edition",
+         "soft-require": {
+-            "phpbb/phpbb": ">=3.2.0,<4.0.0"
++            "phpbb/phpbb": ">=3.2.0,<3.3.0@dev"
+         },
+         "version-check": {
+             "host": "leinad4mind.top",
+             "directory": "/phpbb/bestanswer_special",
+-            "filename": "version_check"
++            "filename": "version_check.json"
+         }
+     }
+ }
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/controller/main_controller.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/controller/main_controller.php"
+index fb2927dd6..3ae8f597a 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/controller/main_controller.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/controller/main_controller.php"
+@@ -4,7 +4,7 @@
+  * Best Answer extension for the phpBB Forum Software package.
+  *
+  * @copyright (c) 2018, kinerity, https://www.layer-3.org/
+- * @copyright (c) 2019-2025, Leinad4Mind, https://leinad4mind.top/forum
++ * @copyright (c) 2019-2021, Leinad4Mind, https://leinad4mind.top/forum
+  * @license GNU General Public License, version 2 (GPL-2.0)
+  *
+  */
+@@ -51,7 +51,7 @@ class main_controller
+ 	/* @var string */
+ 	protected $php_ext;
+ 
+-	/* @var string  */
++	/* @var int bbpoints_table */
+ 	protected $bbpoints_table;
+ 	/**
+ 	 * Constructor
+@@ -62,7 +62,7 @@ class main_controller
+ 	 * @param \phpbb\log\log                      $log
+ 	 * @param \phpbb\request\request              $request
+ 	 * @param \phpbb\user                         $user
+-	 * @param string                              $bbpoints_table
++	 * @param int								  $bbpoints_table
+ 	 * @param \phpbb\notification\manager         $notification_manager
+ 	 * @param string                              $root_path
+ 	 * @param string                              $php_ext
+@@ -99,13 +99,9 @@ class main_controller
+ 	{
+ 		$post_id = $this->request->variable('p', 0);
+ 
+-		// Grab all the data necessary for error checking
++		// Query necessary topic data
+ 		$sql_arr = array(
+-			'SELECT'	=> 'f.forum_id, f.enable_answer, f.bbpoints_answer,
+-						p.post_id, p.topic_id, p.poster_id, p.post_subject,
+-						t.topic_id, t.forum_id, t.topic_title, t.topic_poster, t.topic_status,
+-						t.topic_first_post_id, t.answer_post_id, t.answer_user_id,
+-						u.user_id, u.username, u.user_colour',
++			'SELECT'	=> 'f.forum_id, f.enable_answer, p.post_id, p.topic_id, p.poster_id, p.post_subject, t.topic_id, t.forum_id, t.topic_title, t.topic_poster, t.topic_status, t.topic_first_post_id, t.answer_post_id, t.answer_user_id, u.user_id, u.username, u.user_colour',
+ 
+ 			'FROM'		=> array(
+ 				FORUMS_TABLE	=> 'f',
+@@ -123,14 +119,9 @@ class main_controller
+ 		$this->db->sql_freeresult($result);
+ 
+ 		// Error checking
+-		if (!$topic_data['enable_answer']) 
+-		{ 
+-			throw new \phpbb\exception\http_exception(404, $this->lang->lang('EXTENSION_NOT_ENABLED')); 
+-		}
+-
+-		if ((int) $topic_data['topic_first_post_id'] == (int) $post_id)
++		if (!$topic_data['enable_answer'])
+ 		{
+-			throw new \phpbb\exception\http_exception(404, $this->lang->lang('TOPIC_FIRST_POST'));
++			throw new \phpbb\exception\http_exception(403, $this->lang->lang('NOT_AUTHORISED'));
+ 		}
+ 
+ 		if (!$this->auth->acl_get('m_mark_answer', (int) $topic_data['forum_id']) && (!$this->auth->acl_get('f_mark_answer', (int) $topic_data['forum_id']) && $topic_data['topic_poster'] != (int) $this->user->data['user_id']))
+@@ -138,6 +129,11 @@ class main_controller
+ 			throw new \phpbb\exception\http_exception(403, $this->lang->lang('NOT_AUTHORISED'));
+ 		}
+ 
++		if ((int) $topic_data['topic_first_post_id'] == (int) $post_id)
++		{
++			throw new \phpbb\exception\http_exception(404, $this->lang->lang('NOT_AUTHORISED'));
++		}
++
+ 		if ((int) $topic_data['topic_status'] == ITEM_LOCKED && !$this->auth->acl_get('m_mark_answer', (int) $topic_data['forum_id']))
+ 		{
+ 			throw new \phpbb\exception\http_exception(403, $this->lang->lang('NOT_AUTHORISED'));
+@@ -166,13 +162,11 @@ class main_controller
+ 				$post_author = get_username_string('full', (int) $topic_data['user_id'], $topic_data['username'], $topic_data['user_colour']);
+ 				$this->log->add($log_var, (int) $this->user->data['user_id'], $this->user->data['user_ip'], 'LOG_UNMARK_ANSWER', time(), array($topic_data['post_subject'], $post_author));
+ 				
+-				// Remove BBPoints
+-				$reason = $this->db->sql_escape('bestanswer-' . (int) $post_id);
+-				$sql = 'DELETE FROM ' . $this->bbpoints_table . '
+-					WHERE to_id = ' . (int) $topic_data['user_id'] . '
+-					AND reason = "' . $reason . '"';
++				// remove bbpoints
++				$sql = 'DELETE FROM ' . $this->bbpoints_table . ' WHERE
++				to_id=' . (int) $topic_data['user_id'] . ' AND reason="bestanswer-'.$post_id.'"';
+ 				$this->db->sql_query($sql);
+-				$this->log->add($log_var, (int) $topic_data['user_id'], $this->user->data['user_ip'], 'LOG_BBPOINTS_UNMARK_ANSWER', time(), array($topic_data['post_subject'], $post_author));
++				$this->log->add($log_var, (int) $topic_data['user_id'], (int) $this->user->data['user_ip'], 'LOG_BBPOINTS_UNMARK_ANSWER', time(), array($topic_data['post_subject'], $post_author));
+ 
+ 				$this->notification_manager->delete_notifications('leinad4mind.bestanswer.notification.type.unmarkanswer', $post_id, $post_id, $topic_data['user_id']);
+ 				$this->notification_manager->add_notifications('leinad4mind.bestanswer.notification.type.unmarkanswer', [
+@@ -230,13 +224,12 @@ class main_controller
+ 				$post_author = get_username_string('full', (int) $topic_data['user_id'], $topic_data['username'], $topic_data['user_colour']);
+ 				$this->log->add($log_var, (int) $this->user->data['user_id'], $this->user->data['user_ip'], 'LOG_MARK_ANSWER', time(), array($topic_data['post_subject'], $post_author));
+ 
+-				// Add BBPoints
+-				if ((int) $topic_data['bbpoints_answer'] > 0) {
+-					$reason = $this->db->sql_escape('bestanswer-' . (int) $post_id);
++				// add bbpoints
++				if ($topic_data['bbpoints_answer'] > 0) {
+ 					$sql = 'INSERT INTO ' . $this->bbpoints_table . ' (from_id, to_id, bbpoints, reason, timestamp) 
+-						VALUES (0, ' . (int) $topic_data['user_id'] . ', ' . (int) $topic_data['bbpoints_answer'] . ', "' . $reason . '", ' . time() . ')';
++						VALUES(0, ' . (int) $topic_data['user_id'] . ', ' . $topic_data['bbpoints_answer'] . ', "bestanswer-'.$post_id.'", ' . time() . ')';
+ 					$this->db->sql_query($sql);
+-					$this->log->add($log_var, (int) $topic_data['user_id'], $this->user->data['user_ip'], 'LOG_BBPOINTS_MARK_ANSWER', time(), array($topic_data['post_subject'], $post_author));				
++					$this->log->add($log_var, (int) $topic_data['user_id'], (int) $this->user->data['user_ip'], 'LOG_BBPOINTS_MARK_ANSWER', time(), array($topic_data['post_subject'], $post_author));				
+ 				}
+ 
+ 				$this->notification_manager->delete_notifications('leinad4mind.bestanswer.notification.type.markanswer', $post_id, $post_id, $topic_data['user_id']);
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/diff_full.tmp"
+new file mode 100644
+index 000000000..dcafcb8d7
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/diff_full.tmp"
+@@ -0,0 +1,155 @@
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/README.md" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/README.md"
++deleted file mode 100644
++index 6e49f6ec7..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/README.md"
+++++ /dev/null
++@@ -1,11 +0,0 @@
++-# Best Answer
++-
++-## Installation
++-
++-Copy the extension to phpBB/ext/leinad4mind/bestanswer
++-
++-Go to "ACP" > "Customise" > "Extensions" and enable the "Best Answer Special Edition" extension.
++-
++-## License
++-
++-[GPLv2](license.txt)
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/adm/style/event/acp_forums_normal_settings_append.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/adm/style/event/acp_forums_normal_settings_append.html"
++index 706694371..721f353e1 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/adm/style/event/acp_forums_normal_settings_append.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/adm/style/event/acp_forums_normal_settings_append.html"
++@@ -1,11 +1,11 @@
++ <dl>
++-	<dt><label for="enable_answer">{{ lang('ENABLE_ANSWER') ~ lang('COLON') }}</label><br /><span>{{ lang('ENABLE_ANSWER_EXPLAIN') }}</span></dt>
+++	<dt><label for="enable_answer">{{ lang('ENABLE_ANSWER') }}{{ lang('COLON') }}</label><br /><span>{{ lang('ENABLE_ANSWER_EXPLAIN') }}</span></dt>
++ 	<dd><label><input type="radio" class="radio" name="enable_answer" value="1"{% if S_ENABLE_ANSWER %} id="enable_answer" checked="checked"{% endif %} /> {{ lang('YES') }}</label>
++ 		<label><input type="radio" class="radio" name="enable_answer" value="0"{% if not S_ENABLE_ANSWER %} id="enable_answer" checked="checked"{% endif %} /> {{ lang('NO') }}</label></dd>
++ </dl>
++ 
++ <dl>
++-	<dt><label for="bbpoints_answer">{{ lang('BBPOINTS_ANSWER') ~ lang('COLON') }}</label><br /><span>{{ lang('BBPOINTS_ANSWER_EXPLAIN') }}</span></dt>
+++	<dt><label for="bbpoints_answer">{{ lang('BBPOINTS_ANSWER') }}{{ lang('COLON') }}</label><br /><span>{{ lang('BBPOINTS_ANSWER_EXPLAIN') }}</span></dt>
++ 	<dd>
++ 		<label><input type="number" name="bbpoints_answer" value="{S_BBPOINTS_ANSWER}"/></label>
++ 	</dd>
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/composer.json"
++index 93b532e02..08b0a0dfe 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/composer.json"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/composer.json"
++@@ -1,10 +1,10 @@
++ {
++     "name": "leinad4mind/bestanswer",
++     "type": "phpbb-extension",
++-    "description": "An extension for phpBB that allows users to mark a post as the 'Best Answer'.",
+++    "description": "An extension for phpBB that allows users to mark a post as the best answer.",
++     "homepage": "https://leinad4mind.top/forum",
++-    "version": "2.1.0",
++-    "time": "2025-08-16",
+++    "version": "2.0.2",
+++    "time": "2021-01-30",
++     "keywords": [ "phpbb", "extension", "best", "answer", "leinad4mind", "special" ],
++     "license": "GPL-2.0-only",
++     "authors": [
++@@ -20,18 +20,18 @@
++     ],
++     "require": {
++         "php": ">=5.4.7",
++-        "phpbb/phpbb": ">=3.2.0,<4.0.0",
+++        "phpbb/phpbb": ">=3.2.0,<3.3.0@dev",
++         "composer/installers": "~1.0.0"
++     },
++     "extra": {
++         "display-name": "Best Answer Special Edition",
++         "soft-require": {
++-            "phpbb/phpbb": ">=3.2.0,<4.0.0"
+++            "phpbb/phpbb": ">=3.2.0,<3.3.0@dev"
++         },
++         "version-check": {
++             "host": "leinad4mind.top",
++             "directory": "/phpbb/bestanswer_special",
++-            "filename": "version_check"
+++            "filename": "version_check.json"
++         }
++     }
++ }
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/controller/main_controller.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/controller/main_controller.php"
++index fb2927dd6..3ae8f597a 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/controller/main_controller.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/controller/main_controller.php"
++@@ -4,7 +4,7 @@
++  * Best Answer extension for the phpBB Forum Software package.
++  *
++  * @copyright (c) 2018, kinerity, https://www.layer-3.org/
++- * @copyright (c) 2019-2025, Leinad4Mind, https://leinad4mind.top/forum
+++ * @copyright (c) 2019-2021, Leinad4Mind, https://leinad4mind.top/forum
++  * @license GNU General Public License, version 2 (GPL-2.0)
++  *
++  */
++@@ -51,7 +51,7 @@ class main_controller
++ 	/* @var string */
++ 	protected $php_ext;
++ 
++-	/* @var string  */
+++	/* @var int bbpoints_table */
++ 	protected $bbpoints_table;
++ 	/**
++ 	 * Constructor
++@@ -62,7 +62,7 @@ class main_controller
++ 	 * @param \phpbb\log\log                      $log
++ 	 * @param \phpbb\request\request              $request
++ 	 * @param \phpbb\user                         $user
++-	 * @param string                              $bbpoints_table
+++	 * @param int								  $bbpoints_table
++ 	 * @param \phpbb\notification\manager         $notification_manager
++ 	 * @param string                              $root_path
++ 	 * @param string                              $php_ext
++@@ -99,13 +99,9 @@ class main_controller
++ 	{
++ 		$post_id = $this->request->variable('p', 0);
++ 
++-		// Grab all the data necessary for error checking
+++		// Query necessary topic data
++ 		$sql_arr = array(
++-			'SELECT'	=> 'f.forum_id, f.enable_answer, f.bbpoints_answer,
++-						p.post_id, p.topic_id, p.poster_id, p.post_subject,
++-						t.topic_id, t.forum_id, t.topic_title, t.topic_poster, t.topic_status,
++-						t.topic_first_post_id, t.answer_post_id, t.answer_user_id,
++-						u.user_id, u.username, u.user_colour',
+++			'SELECT'	=> 'f.forum_id, f.enable_answer, p.post_id, p.topic_id, p.poster_id, p.post_subject, t.topic_id, t.forum_id, t.topic_title, t.topic_poster, t.topic_status, t.topic_first_post_id, t.answer_post_id, t.answer_user_id, u.user_id, u.username, u.user_colour',
++ 
++ 			'FROM'		=> array(
++ 				FORUMS_TABLE	=> 'f',
++@@ -123,14 +119,9 @@ class main_controller
++ 		$this->db->sql_freeresult($result);
++ 
++ 		// Error checking
++-		if (!$topic_data['enable_answer']) 
++-		{ 
++-			throw new \phpbb\exception\http_exception(404, $this->lang->lang('EXTENSION_NOT_ENABLED')); 
++-		}
++-
++-		if ((int) $topic_data['topic_first_post_id'] == (int) $post_id)
+++		if (!$topic_data['enable_answer'])
++ 		{
++-			throw new \phpbb\exception\http_exception(404, $this->lang->lang('TOPIC_FIRST_POST'));
+++			throw new \phpbb\exception\http_exception(403, $this->lang->lang('NOT_AUTHORISED'));
++ 		}
++ 
++ 		if (!$this->auth->acl_get('m_mark_answer', (int) $topic_data['forum_id']) && (!$this->auth->acl_get('f_mark_answer', (int) $topic_data['forum_id']) && $topic_data['topic_poster'] != (int) $this->user->data['user_id']))
++@@ -138,6 +129,11 @@ class main_controller
++ 			throw new \phpbb\exception\http_exception(403, $this->lang->lang('NOT_AUTHORISED'));
++ 		}
++ 
+++		if ((int) $topic_data['topic_first_post_id'] == (int) $post_id)
+++		{
+++			throw new \phpbb\exception\http_exception(404, $this->lang->lang('NOT_AUTHORISED'));
+++		}
+++
++ 		if ((int) $topic_data['topic_status'] == ITEM_LOCKED && !$this->auth->acl_get('m_mark_answer', (int) $topic_data['forum_id']))
++ 		{
++ 			throw new \phpbb\exception\http_exception(403, $this->lang->lang('NOT_AUTHORISED'));
++@@ -166,13 +162,11 @@ class main_controller
++ 				$post_author = get_username_string('full', (int) $topic_data['user_id'], $topic_data['username'], $topic_data['user_colour']);
++ 				$this->log->add($log_var, (int) $this->user->data['user_id'], $this->user->data['user_ip'], 'LOG_UNMARK_ANSWER', time(), array($topic_data['post_subject'], $post_author))
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/event/main_listener.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/event/main_listener.php"
+index e009efc64..7b57e088d 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/event/main_listener.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/event/main_listener.php"
+@@ -4,7 +4,7 @@
+  * Best Answer extension for the phpBB Forum Software package.
+  *
+  * @copyright (c) 2018, kinerity, https://www.layer-3.org/
+- * @copyright (c) 2019-2025, Leinad4Mind, https://leinad4mind.top/forum
++ * @copyright (c) 2019-2021, Leinad4Mind, https://leinad4mind.top/forum
+  * @license GNU General Public License, version 2 (GPL-2.0)
+  *
+  */
+@@ -154,7 +154,7 @@ class main_listener implements EventSubscriberInterface
+ 	public function acp_manage_forums_display_form($event)
+ 	{
+ 		$event->update_subarray('template_data', 'S_ENABLE_ANSWER', $event['forum_data']['enable_answer']);
+-		$event->update_subarray('template_data', 'S_BBPOINTS_ANSWER', (int) $event['forum_data']['bbpoints_answer']);
++		$event->update_subarray('template_data', 'S_BBPOINTS_ANSWER', (int)$event['forum_data']['bbpoints_answer']);
+ 	}
+ 
+ 	public function acp_manage_forums_initialise_data($event)
+@@ -184,14 +184,13 @@ class main_listener implements EventSubscriberInterface
+ 			WHERE ' . $this->db->sql_in_set('topic_id', $topic_ids) . '
+ 				AND answer_post_id <> 0';
+ 		$result = $this->db->sql_query($sql);
+-
+ 		while ($row = $this->db->sql_fetchrow($result))
+ 		{
+ 			if (in_array($row['answer_post_id'], $post_ids))
+ 			{
+ 				$answer_post_ids[] = $row['answer_post_id'];
+ 				$answer_user_ids[] = $row['answer_user_id'];
+-				$answer_bbpoints_ids[] = 'bestanswer-' . $row['answer_post_id'];
++				$answer_bbpoints_ids[] = 'bestanswer-'.$row['answer_post_id'];
+ 			}
+ 		}
+ 		$this->db->sql_freeresult($result);
+@@ -201,9 +200,9 @@ class main_listener implements EventSubscriberInterface
+ 			'answer_user_id'	=> 0,
+ 		);
+ 
+-		if (!empty($answer_post_ids))
++		if ($answer_post_ids)
+ 		{
+-			// Remove BBPoints
++			// remove bbpoints
+ 			$sql = 'DELETE FROM ' . $this->bbpoints_table . ' WHERE
+ 			' . $this->db->sql_in_set('to_id', $answer_user_ids) . ' AND '.$this->db->sql_in_set('reason', $answer_bbpoints_ids);
+ 			$this->db->sql_query($sql);
+@@ -213,7 +212,7 @@ class main_listener implements EventSubscriberInterface
+ 			$this->db->sql_query($sql);
+ 		}
+ 
+-		if (!empty($answer_user_ids))
++		if ($answer_user_ids)
+ 		{
+ 			$sql = 'UPDATE ' . USERS_TABLE . '
+ 				SET user_answers = user_answers - 1
+@@ -237,7 +236,7 @@ class main_listener implements EventSubscriberInterface
+ 		}
+ 		$this->db->sql_freeresult($result);
+ 
+-		if (!empty($answer_user_ids))
++		if ($answer_user_ids)
+ 		{
+ 			$sql = 'UPDATE ' . USERS_TABLE . '
+ 				SET user_answers = user_answers - 1
+@@ -271,16 +270,16 @@ class main_listener implements EventSubscriberInterface
+ 	{
+ 		$sql_ary = $event['sql_ary'];
+ 
+-		$sql_ary['SELECT'] .= ', ba_t.answer_post_id';
++		$sql_ary['SELECT'] .= ', a_t.answer_post_id';
+ 
+ 		$sql_ary['LEFT_JOIN'][] = array(
+-			'FROM'	=> array(POSTS_TABLE => 'ba_p'),
+-			'ON'	=> 'f.forum_last_post_id = ba_p.post_id',
++			'FROM'	=> array(POSTS_TABLE => 'a_p'),
++			'ON'	=> 'f.forum_last_post_id = a_p.post_id',
+ 		);
+ 
+ 		$sql_ary['LEFT_JOIN'][] = array(
+-			'FROM'	=> array(TOPICS_TABLE => 'ba_t'),
+-			'ON'	=> 'ba_t.topic_id = ba_p.topic_id',
++			'FROM'	=> array(TOPICS_TABLE => 'a_t'),
++			'ON'	=> 'a_t.topic_id = a_p.topic_id',
+ 		);
+ 
+ 		$event['sql_ary'] = $sql_ary;
+@@ -374,7 +373,7 @@ class main_listener implements EventSubscriberInterface
+ 		$topic_info = $event['topic_info'];
+ 
+ 		// Does the topic have a best answer and is the post the first post in a topic
+-		if (!empty($this->answer) && ($topic_info['topic_first_post_id'] == $row['post_id']))
++		if ($this->answer && ($topic_info['topic_first_post_id'] == $row['post_id']))
+ 		{
+ 			$post_row = array_merge($post_row, array(
+ 				'U_ANSWER'	=> append_sid("{$this->root_path}viewtopic.{$this->php_ext}", 'p=' . (int) $topic_info['answer_post_id'] . '#p' . (int) $topic_info['answer_post_id']),
+@@ -416,7 +415,7 @@ class main_listener implements EventSubscriberInterface
+ 	public function modify_topicrow_tpl_ary($event)
+ 	{
+ 		$block = $event['topic_row'] ? 'topic_row' : 'tpl_ary';
+-		$event[$block] = $this->display_topic_answered($event['row'], $event[$block]);
++		$event[$block] = $this->modify_topicrow_tpl($event['row'], $event[$block]);
+ 	}
+ 
+ 	public function permissions($event)
+@@ -584,7 +583,7 @@ class main_listener implements EventSubscriberInterface
+ 		));
+ 
+ 		// Only add to post_row array if an answer_post_id is supplied and the post_id is the first post in a topic
+-		if (!empty($this->answer) && ($topic_data['topic_first_post_id'] == $row['post_id']))
++		if ($this->answer && ($topic_data['topic_first_post_id'] == $row['post_id']))
+ 		{
+ 			$post_row = array_merge($post_row, array(
+ 				'ANSWER_POST_TEXT'		=> $this->answer['POST_TEXT'],
+@@ -596,7 +595,7 @@ class main_listener implements EventSubscriberInterface
+ 		$event['post_row'] = $post_row;
+ 	}
+ 
+-	private function display_topic_answered($row, $block)
++	private function modify_topicrow_tpl($row, $block)
+ 	{
+ 		$block = array_merge($block, array(
+ 			'S_ANSWERED'	=> $row['answer_post_id'] ? true : false,
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/ext.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/ext.php"
+index 216db0084..d37926a55 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/ext.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/ext.php"
+@@ -4,7 +4,7 @@
+  * Best Answer extension for the phpBB Forum Software package.
+  *
+  * @copyright (c) 2018, kinerity, https://www.layer-3.org/
+- * @copyright (c) 2019-2025, Leinad4Mind, https://leinad4mind.top/forum
++ * @copyright (c) 2019-2021, Leinad4Mind, https://leinad4mind.top/forum
+  * @license GNU General Public License, version 2 (GPL-2.0)
+  *
+  */
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/language/ar/common.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/language/ar/common.php"
+index abe513ecc..b2fe7d96e 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/language/ar/common.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/language/ar/common.php"
+@@ -4,7 +4,7 @@
+  * Best Answer extension for the phpBB Forum Software package.
+  *
+  * @copyright (c) 2018, kinerity, https://www.layer-3.org/
+- * @copyright (c) 2019-2025, Leinad4Mind, https://leinad4mind.top/forum
++ * @copyright (c) 2019-2021, Leinad4Mind, https://leinad4mind.top/forum
+  * @translation (c) 2019 Bassel Taha Alhitary, http://www.alhitary.net
+  * @license GNU General Public License, version 2 (GPL-2.0)
+  * 
+@@ -49,7 +49,8 @@ $lang = array_merge($lang, array(
+ 
+ 	'ENABLE_ANSWER'			=> 'تفعيل “أفضل إجابة”',
+ 	'ENABLE_ANSWER_EXPLAIN'	=> 'عند اختيارك “نعم”, كاتب الموضوع (إذا لديه الترخيص) والمشرفين (بالمنتديات المسموح بها) يستطيعون إضافة علامة “أفضل إجابة” إلى أحد ردود الموضوع',
+-	'EXTENSION_NOT_ENABLED'			=> 'ملحق ”أفضل إجابة“ غير ممكّن في هذا المنتدى.',
++
++	'TO_POST'	=> '<i class="fa fa-eye"></i> الذهاب إلى المشاركة',
+ 
+ 	'LOG_MARK_ANSWER'	=> '<strong>تحديد المشاركة كـ “أفضل إجابة”</strong><br />» %1$s بواسطة %2$s',
+ 	'LOG_UNMARK_ANSWER'	=> '<strong>إلغاء تحديد المشاركة كـ “أفضل إجابة”</strong><br />» %1$s بواسطة %2$s',
+@@ -60,8 +61,6 @@ $lang = array_merge($lang, array(
+ 	'MARK_ANSWER'			=> 'تحديد الإجابة الأفضل',
+ 	'MARK_ANSWER_CONFIRM'	=> 'متأكد أنك تريد تحديد هذه المشاركة كأفضل إجابة؟',
+ 
+-	'TO_POST'	=> '<i class="fa fa-eye"></i> الذهاب إلى المشاركة',
+-	'TOPIC_FIRST_POST'	=> 'لا يمكنك وضع علامة على هذا المنشور كأفضل إجابة لأنه المنشور الأول في الموضوع.', 
+ 	'TOTAL_ANSWERS'	=> 'إجمالي الإجابات',
+ 
+ 	'UNMARK_ANSWER'			=> 'إلغاء تحديد الإجابة الأفضل',
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/language/ar/permissions_bestanswer.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/language/ar/permissions_bestanswer.php"
+index f159c642b..a2aeba17d 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/language/ar/permissions_bestanswer.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/language/ar/permissions_bestanswer.php"
+@@ -4,7 +4,7 @@
+  * Best Answer extension for the phpBB Forum Software package.
+  *
+  * @copyright (c) 2018, kinerity, https://www.layer-3.org/
+- * @copyright (c) 2019-2025, Leinad4Mind, https://leinad4mind.top/forum
++ * @copyright (c) 2019-2021, Leinad4Mind, https://leinad4mind.top/forum
+  * @translation (c) 2019 Bassel Taha Alhitary, http://www.alhitary.net
+  * @license GNU General Public License, version 2 (GPL-2.0)
+  *
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/language/en/common.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/language/en/common.php"
+index fd7ccc867..ba6bb2678 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/language/en/common.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/language/en/common.php"
+@@ -4,7 +4,7 @@
+  * Best Answer extension for the phpBB Forum Software package.
+  *
+  * @copyright (c) 2018, kinerity, https://www.layer-3.org/
+- * @copyright (c) 2019-2025, Leinad4Mind, https://leinad4mind.top/forum
++ * @copyright (c) 2019-2021, Leinad4Mind, https://leinad4mind.top/forum
+  * @license GNU General Public License, version 2 (GPL-2.0)
+  *
+  */
+@@ -43,24 +43,23 @@ $lang = array_merge($lang, array(
+ 	'ANSWERED'		=> 'Answered',
+ 	
+ 	'BEST_ANSWER'	=> 'Best answer',
+-	'BBPOINTS_ANSWER'			=> 'Amount of BBPoints for "Best Answer" post',
+-	'BBPOINTS_ANSWER_EXPLAIN'	=> 'Set the number of BBPoints to be credited to post author when his post in this forum is marked as "Best Answer"',
++	'BBPOINTS_ANSWER'			=> 'Amount of BBpoints for "Best Answer" post',
++	'BBPOINTS_ANSWER_EXPLAIN'	=> 'Set the number of BBpoints to be credited to post author when his post in this forum is marked as "Best Answer"',
+ 
+ 	'ENABLE_ANSWER'			=> 'Enable best answer',
+ 	'ENABLE_ANSWER_EXPLAIN'	=> 'If enabled, the topic starter (if permitted) and moderators (where allowed) will be able to mark a topic reply as the best answer.',
+-	'EXTENSION_NOT_ENABLED'			=> 'The Best Answer extension is not enabled on this forum.',
++
++	'TO_POST'	=> '<i class="fa fa-eye"></i> View Post',
+ 
+ 	'LOG_MARK_ANSWER'	=> '<strong>Marked post as best answer</strong><br />» %1$s by %2$s',
+ 	'LOG_UNMARK_ANSWER'	=> '<strong>Unmarked post as best answer</strong><br />» %1$s by %2$s',
+ 
+-	'LOG_BBPOINTS_MARK_ANSWER'		=> '<strong>Added BBPoints to author for best answer</strong><br />» %1$s by %2$s',
+-	'LOG_BBPOINTS_UNMARK_ANSWER'	=> '<strong>Removed BBPoints of author for best answer</strong><br />» %1$s by %2$s',
++	'LOG_BBPOINTS_MARK_ANSWER'		=> '<strong>Added bbpoints to author for best answer</strong><br />» %1$s by %2$s',
++	'LOG_BBPOINTS_UNMARK_ANSWER'	=> '<strong>Removed bbpoints of author for best answer</strong><br />» %1$s by %2$s',
+ 
+ 	'MARK_ANSWER'			=> 'Mark answer',
+ 	'MARK_ANSWER_CONFIRM'	=> 'Are you sure you want to mark this post as the best answer?',
+ 
+-	'TO_POST'	=> '<i class="fa fa-eye"></i> View Post',
+-	'TOPIC_FIRST_POST'	=> 'You cannot mark this post as the best answer as it is the first post of the topic.',
+ 	'TOTAL_ANSWERS'	=> 'Total answers',
+ 
+ 	'UNMARK_ANSWER'			=> 'Unmark answer',
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/language/en/permissions_bestanswer.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/language/en/permissions_bestanswer.php"
+index dc7241e0f..7211c9aa6 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/language/en/permissions_bestanswer.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/language/en/permissions_bestanswer.php"
+@@ -4,7 +4,7 @@
+  * Best Answer extension for the phpBB Forum Software package.
+  *
+  * @copyright (c) 2018, kinerity, https://www.layer-3.org/
+- * @copyright (c) 2019-2025, Leinad4Mind, https://leinad4mind.top/forum
++ * @copyright (c) 2019-2021, Leinad4Mind, https://leinad4mind.top/forum
+  * @license GNU General Public License, version 2 (GPL-2.0)
+  *
+  */
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/language/fr/common.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/language/fr/common.php"
+index 194219b31..06e119ef7 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/language/fr/common.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/language/fr/common.php"
+@@ -4,7 +4,7 @@
+  * Best Answer extension for the phpBB Forum Software package.
+  *
+  * @copyright (c) 2018, kinerity, https://www.layer-3.org/
+- * @copyright (c) 2019-2025, Leinad4Mind, https://leinad4mind.top/forum
++ * @copyright (c) 2019-2021, Leinad4Mind, https://leinad4mind.top/forum
+  * @translation (c) 2019 Galixte (http://www.galixte.com)
+  * @license GNU General Public License, version 2 (GPL-2.0)
+  *
+@@ -44,24 +44,23 @@ $lang = array_merge($lang, array(
+ 	'ANSWERED'		=> 'Répondue',
+ 	
+ 	'BEST_ANSWER'	=> 'Meilleure réponse',
+-	'BBPOINTS_ANSWER'			=> 'Nombre de BBPoints pour le message "Meilleure réponse"',
+-	'BBPOINTS_ANSWER_EXPLAIN'	=> 'Définissez le nombre de BBpoints à créditer à l’auteur du message lorsque son message dans ce forum est marqué comme "Meilleure réponse"',
++	'BBPOINTS_ANSWER'			=> 'Nombre de BBpoints pour le message "Meilleure réponse"',
++	'BBPOINTS_ANSWER_EXPLAIN'	=> 'Définissez le nombre de BBpoints à créditer à l\'auteur du message lorsque son message dans ce forum est marqué comme "Meilleure réponse"',
+ 
+ 	'ENABLE_ANSWER'			=> 'Activer les réponses les plus pertinentes',
+ 	'ENABLE_ANSWER_EXPLAIN'	=> 'Permet aux auteurs de sujets et aux modérateurs de mettre en avant un message comme étant la réponse la plus pertinente de son sujet.',
+-	'EXTENSION_NOT_ENABLED'			=> 'L’extension « Meilleure réponse » n’est pas activée sur ce forum.',
++
++	'TO_POST'	=> '<i class="fa fa-eye"></i> Se rendre au message',
+ 
+ 	'LOG_MARK_ANSWER'	=> '<strong>Mise en avant effectuée d’un message, comme étant la réponse la plus pertinente de son sujet</strong><br />» %1$s par %2$s',
+ 	'LOG_UNMARK_ANSWER'	=> '<strong>Mise en avant annulée d’un message, comme étant la réponse la plus pertinente de son sujet</strong><br />» %1$s par %2$s',
+ 
+-	'LOG_BBPOINTS_MARK_ANSWER'		=> '<strong>Ajout de BBPoints à l\'auteur pour la réponse la plus pertinente</strong><br />» %1$s par %2$s',
+-	'LOG_BBPOINTS_UNMARK_ANSWER'	=> '<strong>Suppression des BBPoints de l\'auteur pour la réponse la plus pertinente</strong><br />» %1$s par %2$s',
++	'LOG_BBPOINTS_MARK_ANSWER'		=> '<strong>Ajout de bbpoints à l\'auteur pour la réponse la plus pertinente</strong><br />» %1$s par %2$s',
++	'LOG_BBPOINTS_UNMARK_ANSWER'	=> '<strong>Suppression des bbpoints de l\'auteur pour la réponse la plus pertinente</strong><br />» %1$s par %2$s',
+ 
+ 	'MARK_ANSWER'			=> 'Mettre en avant ce message comme réponse la plus pertinente',
+ 	'MARK_ANSWER_CONFIRM'	=> 'Confirmer la mise en avant de ce message en tant que réponse la plus pertinente de son sujet.',
+ 
+-	'TO_POST'	=> '<i class="fa fa-eye"></i> Se rendre au message',
+-	'TOPIC_FIRST_POST'	=> 'Vous ne pouvez pas marquer cette réponse comme meilleure réponse, car il s’agit de la première réponse du sujet.',
+ 	'TOTAL_ANSWERS'	=> 'Réponses pertinentes',
+ 
+ 	'UNMARK_ANSWER'			=> 'Annuler la mise en avant de ce message comme réponse la plus pertinente',
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/language/fr/permissions_bestanswer.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/language/fr/permissions_bestanswer.php"
+index 36652d244..0e70bd06b 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/language/fr/permissions_bestanswer.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/language/fr/permissions_bestanswer.php"
+@@ -4,7 +4,7 @@
+  * Best Answer extension for the phpBB Forum Software package.
+  *
+  * @copyright (c) 2018, kinerity, https://www.layer-3.org/
+- * @copyright (c) 2019-2025, Leinad4Mind, https://leinad4mind.top/forum
++ * @copyright (c) 2019-2021, Leinad4Mind, https://leinad4mind.top/forum
+  * @translation (c) 2019 Galixte (http://www.galixte.com)
+  * @license GNU General Public License, version 2 (GPL-2.0)
+  *
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/language/pt/common.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/language/pt/common.php"
+index 0fc8968c4..95991d9b1 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/language/pt/common.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/language/pt/common.php"
+@@ -4,7 +4,7 @@
+  * Best Answer extension for the phpBB Forum Software package.
+  *
+  * @copyright (c) 2018, kinerity, https://www.layer-3.org/
+- * @copyright (c) 2019-2025, Leinad4Mind, https://leinad4mind.top/forum
++ * @copyright (c) 2019-2021, Leinad4Mind, https://leinad4mind.top/forum
+  * @license GNU General Public License, version 2 (GPL-2.0)
+  *
+  */
+@@ -48,7 +48,8 @@ $lang = array_merge($lang, array(
+ 
+ 	'ENABLE_ANSWER'			=> 'Activar Melhor Resposta',
+ 	'ENABLE_ANSWER_EXPLAIN'	=> 'If enabled, the topic starter (if permitted) and moderators (where allowed) will be able to mark a topic reply as the best answer.',
+-	'EXTENSION_NOT_ENABLED'			=> 'A extensão "Melhor Resposta" não está ativada neste fórum.',
++
++	'TO_POST'	=> '<i class="fa fa-eye"></i> Ver Mensagem',
+ 
+ 	'LOG_MARK_ANSWER'	=> '<strong>Mensagem marcada como Melhor Resposta</strong><br />» %1$s by %2$s',
+ 	'LOG_UNMARK_ANSWER'	=> '<strong>Mensagem deixou de ser a Melhor Resposta</strong><br />» %1$s by %2$s',
+@@ -59,8 +60,6 @@ $lang = array_merge($lang, array(
+ 	'MARK_ANSWER'			=> 'Marcar Melhor Resposta',
+ 	'MARK_ANSWER_CONFIRM'	=> 'Tens a certeza de que queres marcar esta mensagem como sendo a melhor resposta?',
+ 
+-	'TO_POST'	=> '<i class="fa fa-eye"></i> Ver Mensagem',
+-	'TOPIC_FIRST_POST'	=> 'Não é possível marcar esta mensagem como a melhor resposta, pois é a primeira mensagem do tópico.',
+ 	'TOTAL_ANSWERS'	=> 'Respostas totais',
+ 
+ 	'UNMARK_ANSWER'			=> 'Remover Melhor Resposta',
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/language/pt/permissions_bestanswer.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/language/pt/permissions_bestanswer.php"
+index 714c0934f..7a368e3f1 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/language/pt/permissions_bestanswer.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/language/pt/permissions_bestanswer.php"
+@@ -4,7 +4,7 @@
+  * Best Answer extension for the phpBB Forum Software package.
+  *
+  * @copyright (c) 2018, kinerity, https://www.layer-3.org/
+- * @copyright (c) 2019-2025, Leinad4Mind, https://leinad4mind.top/forum
++ * @copyright (c) 2019-2021, Leinad4Mind, https://leinad4mind.top/forum
+  * @license GNU General Public License, version 2 (GPL-2.0)
+  *
+  */
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/language/pt-br/common.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/language/pt-br/common.php"
+deleted file mode 100644
+index 2c5c0d052..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/language/pt-br/common.php"
++++ /dev/null
+@@ -1,73 +0,0 @@
+-<?php
+-/**
+- *
+- * Best Answer extension for the phpBB Forum Software package.
+- *
+- * @copyright (c) 2018, kinerity, https://www.layer-3.org/
+- * @copyright (c) 2019-2025, Leinad4Mind, https://leinad4mind.top/forum
+- * @license GNU General Public License, version 2 (GPL-2.0)
+- *
+- */
+-
+-/**
+- * DO NOT CHANGE
+- */
+-if (!defined('IN_PHPBB'))
+-{
+-	exit;
+-}
+-
+-if (empty($lang) || !is_array($lang))
+-{
+-	$lang = array();
+-}
+-
+-// DEVELOPERS PLEASE NOTE
+-//
+-// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
+-//
+-// Placeholders can now contain order information, e.g. instead of
+-// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
+-// translators to re-order the output of data while ensuring it remains correct
+-//
+-// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
+-// equally where a string contains only two placeholders which are used to wrap text
+-// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
+-//
+-// Some characters you may want to copy&paste:
+-// ’ » “ ” …
+-//
+-
+-$lang = array_merge($lang, array(
+-	'ANSWERS'		=> 'Respostas',
+-	'ANSWERED'		=> 'Respondidas',
+-	
+-	'BEST_ANSWER'	=> 'Melhor resposta',
+-	'BBPOINTS_ANSWER'			=> 'Quantidade de BBpoints para a postagem “Melhor resposta”',
+-	'BBPOINTS_ANSWER_EXPLAIN'	=> 'Defina o número de pontos BB a serem creditados ao autor da postagem quando sua postagem neste fórum for marcada como “Melhor resposta”',
+-
+-	'ENABLE_ANSWER'			=> 'Habilitar melhor resposta',
+-	'ENABLE_ANSWER_EXPLAIN'	=> 'Se ativado, o autor do tópico (se permitido) e os moderadores (onde permitido) poderão marcar uma resposta ao tópico como a melhor resposta.',
+-	'EXTENSION_NOT_ENABLED'			=> 'A extensão Melhor resposta não está ativada neste fórum.',
+-
+-	'LOG_MARK_ANSWER'	=> '<strong>Postagem marcada como melhor resposta</strong><br />» %1$s by %2$s',
+-	'LOG_UNMARK_ANSWER'	=> '<strong>Postagem desmarcada como melhor resposta</strong><br />» %1$s by %2$s',
+-
+-	'LOG_BBPOINTS_MARK_ANSWER'		=> '<strong>Adicionados bbpoints ao autor pela melhor resposta</strong><br />» %1$s by %2$s',
+-	'LOG_BBPOINTS_UNMARK_ANSWER'	=> '<strong>Removidos bbpoints ao autor por perder a melhor resposta</strong><br />» %1$s by %2$s',
+-
+-	'MARK_ANSWER'			=> 'Marcar resposta',
+-	'MARK_ANSWER_CONFIRM'	=> 'Tem certeza de que deseja marcar esta postagem como a melhor resposta?',
+-
+-	'TO_POST'	=> '<i class="fa fa-eye"></i> Ver postagem',
+-	'TOPIC_FIRST_POST'	=> 'Você não pode marcar esta postagem como a melhor resposta, pois é a primeira postagem do tópico.',
+-	'TOTAL_ANSWERS'	=> 'Total de respostas',
+-
+-	'UNMARK_ANSWER'			=> 'Desmarcar resposta',
+-	'UNMARK_ANSWER_CONFIRM'	=> 'Tem certeza de que deseja desmarcar esta postagem como a melhor resposta?',
+-
+-	'MARK_ANSWER_NOTIFICATION'			=> '%1$s marcou sua postagem no tópico “%2$s” como a melhor resposta.',
+-	'UNMARK_ANSWER_NOTIFICATION'		=> '%1$s desmarcou sua postagem no tópico “%2$s” como a melhor resposta.',
+-	'NOTIFICATION_TYPE_MARK_ANSWER'		=> 'Alguém marcou sua resposta no tópico como a melhor resposta',
+-	'NOTIFICATION_TYPE_UNMARK_ANSWER'	=> 'Alguém desmarcou sua resposta no tópico como a melhor resposta',
+-));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/language/pt-br/email/mark_mail.txt" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/language/pt-br/email/mark_mail.txt"
+deleted file mode 100644
+index 4c33d4c60..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/language/pt-br/email/mark_mail.txt"
++++ /dev/null
+@@ -1,10 +0,0 @@
+-Subject: A tua mensagem foi marcada como sendo a melhor resposta
+-
+-Olá,
+-
+-a tua mensagem em "{{ TOPIC_TITLE }}" no "{{ SITENAME }}" foi marcada com sendo a melhor resposta por "{{ USERNAME }}".
+-
+-Para veres a tua mensagem clica no endereço seguinte:
+-{{ U_LINK_TO_TOPIC }}
+-
+-{{ EMAIL_SIG }}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/language/pt-br/email/unmark_mail.txt" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/language/pt-br/email/unmark_mail.txt"
+deleted file mode 100644
+index 62c0e8bf3..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/language/pt-br/email/unmark_mail.txt"
++++ /dev/null
+@@ -1,10 +0,0 @@
+-Subject: A tua mensagem deixou de ser a melhor resposta
+-
+-Olá,
+-
+-Infelizmente a tua mensagem em "{{ TOPIC_TITLE }}" no "{{ SITENAME }}" deixou de ser a melhor resposta.
+-
+-Para veres a tua mensagem clica no endereço seguinte:
+-{{ U_LINK_TO_TOPIC }}
+-
+-{{ EMAIL_SIG }}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/language/pt-br/permissions_bestanswer.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/language/pt-br/permissions_bestanswer.php"
+deleted file mode 100644
+index 714c0934f..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/language/pt-br/permissions_bestanswer.php"
++++ /dev/null
+@@ -1,44 +0,0 @@
+-<?php
+-/**
+- *
+- * Best Answer extension for the phpBB Forum Software package.
+- *
+- * @copyright (c) 2018, kinerity, https://www.layer-3.org/
+- * @copyright (c) 2019-2025, Leinad4Mind, https://leinad4mind.top/forum
+- * @license GNU General Public License, version 2 (GPL-2.0)
+- *
+- */
+-
+-/**
+- * DO NOT CHANGE
+- */
+-if (!defined('IN_PHPBB'))
+-{
+-	exit;
+-}
+-
+-if (empty($lang) || !is_array($lang))
+-{
+-	$lang = array();
+-}
+-
+-// DEVELOPERS PLEASE NOTE
+-//
+-// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
+-//
+-// Placeholders can now contain order information, e.g. instead of
+-// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
+-// translators to re-order the output of data while ensuring it remains correct
+-//
+-// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
+-// equally where a string contains only two placeholders which are used to wrap text
+-// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
+-//
+-// Some characters you may want to copy&paste:
+-// ’ » “ ” …
+-//
+-
+-$lang = array_merge($lang, array(
+-	'ACL_F_MARK_ANSWER' => 'Pode marcar mensagem como melhor resposta',
+-	'ACL_M_MARK_ANSWER' => 'Pode marcar mensagem como melhor resposta',
+-));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/language/pt_preao/common.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/language/pt_preao/common.php"
+index 50e269028..95991d9b1 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/language/pt_preao/common.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/language/pt_preao/common.php"
+@@ -4,7 +4,7 @@
+  * Best Answer extension for the phpBB Forum Software package.
+  *
+  * @copyright (c) 2018, kinerity, https://www.layer-3.org/
+- * @copyright (c) 2019-2025, Leinad4Mind, https://leinad4mind.top/forum
++ * @copyright (c) 2019-2021, Leinad4Mind, https://leinad4mind.top/forum
+  * @license GNU General Public License, version 2 (GPL-2.0)
+  *
+  */
+@@ -48,7 +48,8 @@ $lang = array_merge($lang, array(
+ 
+ 	'ENABLE_ANSWER'			=> 'Activar Melhor Resposta',
+ 	'ENABLE_ANSWER_EXPLAIN'	=> 'If enabled, the topic starter (if permitted) and moderators (where allowed) will be able to mark a topic reply as the best answer.',
+-	'EXTENSION_NOT_ENABLED'			=> 'A extensão "Melhor Resposta" não está activada neste fórum.',
++
++	'TO_POST'	=> '<i class="fa fa-eye"></i> Ver Mensagem',
+ 
+ 	'LOG_MARK_ANSWER'	=> '<strong>Mensagem marcada como Melhor Resposta</strong><br />» %1$s by %2$s',
+ 	'LOG_UNMARK_ANSWER'	=> '<strong>Mensagem deixou de ser a Melhor Resposta</strong><br />» %1$s by %2$s',
+@@ -59,8 +60,6 @@ $lang = array_merge($lang, array(
+ 	'MARK_ANSWER'			=> 'Marcar Melhor Resposta',
+ 	'MARK_ANSWER_CONFIRM'	=> 'Tens a certeza de que queres marcar esta mensagem como sendo a melhor resposta?',
+ 
+-	'TO_POST'	=> '<i class="fa fa-eye"></i> Ver Mensagem',
+-	'TOPIC_FIRST_POST'	=> 'Não é possível marcar esta mensagem como a melhor resposta, pois é a primeira mensagem do tópico.',
+ 	'TOTAL_ANSWERS'	=> 'Respostas totais',
+ 
+ 	'UNMARK_ANSWER'			=> 'Remover Melhor Resposta',
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/language/pt_preao/permissions_bestanswer.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/language/pt_preao/permissions_bestanswer.php"
+index 714c0934f..7a368e3f1 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/language/pt_preao/permissions_bestanswer.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/language/pt_preao/permissions_bestanswer.php"
+@@ -4,7 +4,7 @@
+  * Best Answer extension for the phpBB Forum Software package.
+  *
+  * @copyright (c) 2018, kinerity, https://www.layer-3.org/
+- * @copyright (c) 2019-2025, Leinad4Mind, https://leinad4mind.top/forum
++ * @copyright (c) 2019-2021, Leinad4Mind, https://leinad4mind.top/forum
+  * @license GNU General Public License, version 2 (GPL-2.0)
+  *
+  */
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/language/ru/common.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/language/ru/common.php"
+index f3ffca07b..61ae53f0c 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/language/ru/common.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/language/ru/common.php"
+@@ -4,7 +4,7 @@
+  * Best Answer extension for the phpBB Forum Software package.
+  *
+  * @copyright (c) 2018, kinerity, https://www.layer-3.org/
+- * @copyright (c) 2019-2025, Leinad4Mind, https://leinad4mind.top/forum
++ * @copyright (c) 2019-2021, Leinad4Mind, https://leinad4mind.top/forum
+  * @translation (c) 2019 naoiphoenix
+  * @license GNU General Public License, version 2 (GPL-2.0)
+  *
+@@ -49,19 +49,18 @@ $lang = array_merge($lang, array(
+ 
+ 	'ENABLE_ANSWER'			=> 'Включить лучший ответ',
+ 	'ENABLE_ANSWER_EXPLAIN'	=> 'Если включено, автор темы (если разрешено) и модераторы разделов (где разрешено) будут способны отмечать ответ как лучший.',
+-	'EXTENSION_NOT_ENABLED'			=> 'Расширение «Лучший ответ» не включено на этом форуме.',
++
++	'TO_POST'	=> '<i class="fa fa-eye"></i> Перейти к полному ответу',
+ 
+ 	'LOG_MARK_ANSWER'	=> '<strong>Отмечено лучшим ответом</strong><br />» %1$s пользователем %2$s',
+ 	'LOG_UNMARK_ANSWER'	=> '<strong>Снята отметка лучшего ответа</strong><br />» %1$s пользователем %2$s',
+-	
++
+ 	'LOG_BBPOINTS_MARK_ANSWER'		=> '<strong>Добавлены баллы автору за лучший ответ</strong><br />» %1$s от %2$s',
+ 	'LOG_BBPOINTS_UNMARK_ANSWER'	=> '<strong>Удалите баллы автора для лучшего ответа</strong><br />» %1$s от %2$s',
+-	
++
+ 	'MARK_ANSWER'			=> 'Отметить ответ',
+ 	'MARK_ANSWER_CONFIRM'	=> 'Вы уверены, что хотите отметить этот ответ как лучший?',
+-	
+-	'TO_POST'	=> '<i class="fa fa-eye"></i> Перейти к полному ответу',
+-	'TOPIC_FIRST_POST'	=> 'Вы не можете отметить этот пост как лучший ответ, так как он является первым постом в теме.',
++
+ 	'TOTAL_ANSWERS'	=> 'Всего ответов',
+ 
+ 	'UNMARK_ANSWER'			=> 'Снять отметку',
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/language/ru/permissions_bestanswer.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/language/ru/permissions_bestanswer.php"
+index a1edbb133..d97be6dc5 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/language/ru/permissions_bestanswer.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/language/ru/permissions_bestanswer.php"
+@@ -4,7 +4,7 @@
+  * Best Answer extension for the phpBB Forum Software package.
+  *
+  * @copyright (c) 2018, kinerity, https://www.layer-3.org/
+- * @copyright (c) 2019-2025, Leinad4Mind, https://leinad4mind.top/forum
++ * @copyright (c) 2019-2021, Leinad4Mind, https://leinad4mind.top/forum
+  * @translation (c) 2019 naoiphoenix
+  * @license GNU General Public License, version 2 (GPL-2.0)
+  *
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/license.txt" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/license.txt"
+deleted file mode 100644
+index 30f3d3388..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/license.txt"
++++ /dev/null
+@@ -1,280 +0,0 @@
+-			GNU GENERAL PUBLIC LICENSE
+-		       Version 2, June 1991
+-
+- Copyright (C) 1989, 1991 Free Software Foundation, Inc.
+-                          675 Mass Ave, Cambridge, MA 02139, USA
+- Everyone is permitted to copy and distribute verbatim copies
+- of this license document, but changing it is not allowed.
+-
+-			    Preamble
+-
+-  The licenses for most software are designed to take away your
+-freedom to share and change it.  By contrast, the GNU General Public
+-License is intended to guarantee your freedom to share and change free
+-software--to make sure the software is free for all its users.  This
+-General Public License applies to most of the Free Software
+-Foundation's software and to any other program whose authors commit to
+-using it.  (Some other Free Software Foundation software is covered by
+-the GNU Library General Public License instead.)  You can apply it to
+-your programs, too.
+-
+-  When we speak of free software, we are referring to freedom, not
+-price.  Our General Public Licenses are designed to make sure that you
+-have the freedom to distribute copies of free software (and charge for
+-this service if you wish), that you receive source code or can get it
+-if you want it, that you can change the software or use pieces of it
+-in new free programs; and that you know you can do these things.
+-
+-  To protect your rights, we need to make restrictions that forbid
+-anyone to deny you these rights or to ask you to surrender the rights.
+-These restrictions translate to certain responsibilities for you if you
+-distribute copies of the software, or if you modify it.
+-
+-  For example, if you distribute copies of such a program, whether
+-gratis or for a fee, you must give the recipients all the rights that
+-you have.  You must make sure that they, too, receive or can get the
+-source code.  And you must show them these terms so they know their
+-rights.
+-
+-  We protect your rights with two steps: (1) copyright the software, and
+-(2) offer you this license which gives you legal permission to copy,
+-distribute and/or modify the software.
+-
+-  Also, for each author's protection and ours, we want to make certain
+-that everyone understands that there is no warranty for this free
+-software.  If the software is modified by someone else and passed on, we
+-want its recipients to know that what they have is not the original, so
+-that any problems introduced by others will not reflect on the original
+-authors' reputations.
+-
+-  Finally, any free program is threatened constantly by software
+-patents.  We wish to avoid the danger that redistributors of a free
+-program will individually obtain patent licenses, in effect making the
+-program proprietary.  To prevent this, we have made it clear that any
+-patent must be licensed for everyone's free use or not licensed at all.
+-
+-  The precise terms and conditions for copying, distribution and
+-modification follow.
+-
+-		    GNU GENERAL PUBLIC LICENSE
+-   TERMS AND CONDITIONS FOR COPYING, DISTRIBUTION AND MODIFICATION
+-
+-  0. This License applies to any program or other work which contains
+-a notice placed by the copyright holder saying it may be distributed
+-under the terms of this General Public License.  The "Program", below,
+-refers to any such program or work, and a "work based on the Program"
+-means either the Program or any derivative work under copyright law:
+-that is to say, a work containing the Program or a portion of it,
+-either verbatim or with modifications and/or translated into another
+-language.  (Hereinafter, translation is included without limitation in
+-the term "modification".)  Each licensee is addressed as "you".
+-
+-Activities other than copying, distribution and modification are not
+-covered by this License; they are outside its scope.  The act of
+-running the Program is not restricted, and the output from the Program
+-is covered only if its contents constitute a work based on the
+-Program (independent of having been made by running the Program).
+-Whether that is true depends on what the Program does.
+-
+-  1. You may copy and distribute verbatim copies of the Program's
+-source code as you receive it, in any medium, provided that you
+-conspicuously and appropriately publish on each copy an appropriate
+-copyright notice and disclaimer of warranty; keep intact all the
+-notices that refer to this License and to the absence of any warranty;
+-and give any other recipients of the Program a copy of this License
+-along with the Program.
+-
+-You may charge a fee for the physical act of transferring a copy, and
+-you may at your option offer warranty protection in exchange for a fee.
+-
+-  2. You may modify your copy or copies of the Program or any portion
+-of it, thus forming a work based on the Program, and copy and
+-distribute such modifications or work under the terms of Section 1
+-above, provided that you also meet all of these conditions:
+-
+-    a) You must cause the modified files to carry prominent notices
+-    stating that you changed the files and the date of any change.
+-
+-    b) You must cause any work that you distribute or publish, that in
+-    whole or in part contains or is derived from the Program or any
+-    part thereof, to be licensed as a whole at no charge to all third
+-    parties under the terms of this License.
+-
+-    c) If the modified program normally reads commands interactively
+-    when run, you must cause it, when started running for such
+-    interactive use in the most ordinary way, to print or display an
+-    announcement including an appropriate copyright notice and a
+-    notice that there is no warranty (or else, saying that you provide
+-    a warranty) and that users may redistribute the program under
+-    these conditions, and telling the user how to view a copy of this
+-    License.  (Exception: if the Program itself is interactive but
+-    does not normally print such an announcement, your work based on
+-    the Program is not required to print an announcement.)
+-
+-These requirements apply to the modified work as a whole.  If
+-identifiable sections of that work are not derived from the Program,
+-and can be reasonably considered independent and separate works in
+-themselves, then this License, and its terms, do not apply to those
+-sections when you distribute them as separate works.  But when you
+-distribute the same sections as part of a whole which is a work based
+-on the Program, the distribution of the whole must be on the terms of
+-this License, whose permissions for other licensees extend to the
+-entire whole, and thus to each and every part regardless of who wrote it.
+-
+-Thus, it is not the intent of this section to claim rights or contest
+-your rights to work written entirely by you; rather, the intent is to
+-exercise the right to control the distribution of derivative or
+-collective works based on the Program.
+-
+-In addition, mere aggregation of another work not based on the Program
+-with the Program (or with a work based on the Program) on a volume of
+-a storage or distribution medium does not bring the other work under
+-the scope of this License.
+-
+-  3. You may copy and distribute the Program (or a work based on it,
+-under Section 2) in object code or executable form under the terms of
+-Sections 1 and 2 above provided that you also do one of the following:
+-
+-    a) Accompany it with the complete corresponding machine-readable
+-    source code, which must be distributed under the terms of Sections
+-    1 and 2 above on a medium customarily used for software interchange; or,
+-
+-    b) Accompany it with a written offer, valid for at least three
+-    years, to give any third party, for a charge no more than your
+-    cost of physically performing source distribution, a complete
+-    machine-readable copy of the corresponding source code, to be
+-    distributed under the terms of Sections 1 and 2 above on a medium
+-    customarily used for software interchange; or,
+-
+-    c) Accompany it with the information you received as to the offer
+-    to distribute corresponding source code.  (This alternative is
+-    allowed only for noncommercial distribution and only if you
+-    received the program in object code or executable form with such
+-    an offer, in accord with Subsection b above.)
+-
+-The source code for a work means the preferred form of the work for
+-making modifications to it.  For an executable work, complete source
+-code means all the source code for all modules it contains, plus any
+-associated interface definition files, plus the scripts used to
+-control compilation and installation of the executable.  However, as a
+-special exception, the source code distributed need not include
+-anything that is normally distributed (in either source or binary
+-form) with the major components (compiler, kernel, and so on) of the
+-operating system on which the executable runs, unless that component
+-itself accompanies the executable.
+-
+-If distribution of executable or object code is made by offering
+-access to copy from a designated place, then offering equivalent
+-access to copy the source code from the same place counts as
+-distribution of the source code, even though third parties are not
+-compelled to copy the source along with the object code.
+-
+-  4. You may not copy, modify, sublicense, or distribute the Program
+-except as expressly provided under this License.  Any attempt
+-otherwise to copy, modify, sublicense or distribute the Program is
+-void, and will automatically terminate your rights under this License.
+-However, parties who have received copies, or rights, from you under
+-this License will not have their licenses terminated so long as such
+-parties remain in full compliance.
+-
+-  5. You are not required to accept this License, since you have not
+-signed it.  However, nothing else grants you permission to modify or
+-distribute the Program or its derivative works.  These actions are
+-prohibited by law if you do not accept this License.  Therefore, by
+-modifying or distributing the Program (or any work based on the
+-Program), you indicate your acceptance of this License to do so, and
+-all its terms and conditions for copying, distributing or modifying
+-the Program or works based on it.
+-
+-  6. Each time you redistribute the Program (or any work based on the
+-Program), the recipient automatically receives a license from the
+-original licensor to copy, distribute or modify the Program subject to
+-these terms and conditions.  You may not impose any further
+-restrictions on the recipients' exercise of the rights granted herein.
+-You are not responsible for enforcing compliance by third parties to
+-this License.
+-
+-  7. If, as a consequence of a court judgment or allegation of patent
+-infringement or for any other reason (not limited to patent issues),
+-conditions are imposed on you (whether by court order, agreement or
+-otherwise) that contradict the conditions of this License, they do not
+-excuse you from the conditions of this License.  If you cannot
+-distribute so as to satisfy simultaneously your obligations under this
+-License and any other pertinent obligations, then as a consequence you
+-may not distribute the Program at all.  For example, if a patent
+-license would not permit royalty-free redistribution of the Program by
+-all those who receive copies directly or indirectly through you, then
+-the only way you could satisfy both it and this License would be to
+-refrain entirely from distribution of the Program.
+-
+-If any portion of this section is held invalid or unenforceable under
+-any particular circumstance, the balance of the section is intended to
+-apply and the section as a whole is intended to apply in other
+-circumstances.
+-
+-It is not the purpose of this section to induce you to infringe any
+-patents or other property right claims or to contest validity of any
+-such claims; this section has the sole purpose of protecting the
+-integrity of the free software distribution system, which is
+-implemented by public license practices.  Many people have made
+-generous contributions to the wide range of software distributed
+-through that system in reliance on consistent application of that
+-system; it is up to the author/donor to decide if he or she is willing
+-to distribute software through any other system and a licensee cannot
+-impose that choice.
+-
+-This section is intended to make thoroughly clear what is believed to
+-be a consequence of the rest of this License.
+-
+-  8. If the distribution and/or use of the Program is restricted in
+-certain countries either by patents or by copyrighted interfaces, the
+-original copyright holder who places the Program under this License
+-may add an explicit geographical distribution limitation excluding
+-those countries, so that distribution is permitted only in or among
+-countries not thus excluded.  In such case, this License incorporates
+-the limitation as if written in the body of this License.
+-
+-  9. The Free Software Foundation may publish revised and/or new versions
+-of the General Public License from time to time.  Such new versions will
+-be similar in spirit to the present version, but may differ in detail to
+-address new problems or concerns.
+-
+-Each version is given a distinguishing version number.  If the Program
+-specifies a version number of this License which applies to it and "any
+-later version", you have the option of following the terms and conditions
+-either of that version or of any later version published by the Free
+-Software Foundation.  If the Program does not specify a version number of
+-this License, you may choose any version ever published by the Free Software
+-Foundation.
+-
+-  10. If you wish to incorporate parts of the Program into other free
+-programs whose distribution conditions are different, write to the author
+-to ask for permission.  For software which is copyrighted by the Free
+-Software Foundation, write to the Free Software Foundation; we sometimes
+-make exceptions for this.  Our decision will be guided by the two goals
+-of preserving the free status of all derivatives of our free software and
+-of promoting the sharing and reuse of software generally.
+-
+-			    NO WARRANTY
+-
+-  11. BECAUSE THE PROGRAM IS LICENSED FREE OF CHARGE, THERE IS NO WARRANTY
+-FOR THE PROGRAM, TO THE EXTENT PERMITTED BY APPLICABLE LAW.  EXCEPT WHEN
+-OTHERWISE STATED IN WRITING THE COPYRIGHT HOLDERS AND/OR OTHER PARTIES
+-PROVIDE THE PROGRAM "AS IS" WITHOUT WARRANTY OF ANY KIND, EITHER EXPRESSED
+-OR IMPLIED, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF
+-MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE.  THE ENTIRE RISK AS
+-TO THE QUALITY AND PERFORMANCE OF THE PROGRAM IS WITH YOU.  SHOULD THE
+-PROGRAM PROVE DEFECTIVE, YOU ASSUME THE COST OF ALL NECESSARY SERVICING,
+-REPAIR OR CORRECTION.
+-
+-  12. IN NO EVENT UNLESS REQUIRED BY APPLICABLE LAW OR AGREED TO IN WRITING
+-WILL ANY COPYRIGHT HOLDER, OR ANY OTHER PARTY WHO MAY MODIFY AND/OR
+-REDISTRIBUTE THE PROGRAM AS PERMITTED ABOVE, BE LIABLE TO YOU FOR DAMAGES,
+-INCLUDING ANY GENERAL, SPECIAL, INCIDENTAL OR CONSEQUENTIAL DAMAGES ARISING
+-OUT OF THE USE OR INABILITY TO USE THE PROGRAM (INCLUDING BUT NOT LIMITED
+-TO LOSS OF DATA OR DATA BEING RENDERED INACCURATE OR LOSSES SUSTAINED BY
+-YOU OR THIRD PARTIES OR A FAILURE OF THE PROGRAM TO OPERATE WITH ANY OTHER
+-PROGRAMS), EVEN IF SUCH HOLDER OR OTHER PARTY HAS BEEN ADVISED OF THE
+-POSSIBILITY OF SUCH DAMAGES.
+-
+-		     END OF TERMS AND CONDITIONS
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/migrations/v10x/release_0_0_1.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/migrations/v10x/release_0_0_1.php"
+index abb21c74f..929fb78f7 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/migrations/v10x/release_0_0_1.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/migrations/v10x/release_0_0_1.php"
+@@ -4,7 +4,7 @@
+  * Best Answer extension for the phpBB Forum Software package.
+  *
+  * @copyright (c) 2018, kinerity, https://www.layer-3.org/
+- * @copyright (c) 2019-2025, Leinad4Mind, https://leinad4mind.top/forum
++ * @copyright (c) 2019-2021, Leinad4Mind, https://leinad4mind.top/forum
+  * @license GNU General Public License, version 2 (GPL-2.0)
+  *
+  */
+@@ -18,23 +18,11 @@ class release_0_0_1 extends \phpbb\db\migration\container_aware_migration
+ 		return $this->db_tools->sql_column_exists($this->table_prefix . 'forums', 'enable_answer');
+ 	}
+ 
+-	/**
+-	 * Assign migration file dependencies for this migration
+-	 *
+-	 * @return void
+-	 * @access public
+-	 */
+ 	static public function depends_on()
+ 	{
+ 		return array('\phpbb\db\migration\data\v320\v320');
+ 	}
+ 
+-	/**
+-	 * Add or update schema in the database
+-	 *
+-	 * @return array Array of table schema
+-	 * @access public
+-	 */
+ 	public function update_schema()
+ 	{
+ 		return array(
+@@ -55,12 +43,6 @@ class release_0_0_1 extends \phpbb\db\migration\container_aware_migration
+ 		);
+ 	}
+ 
+-	/**
+-	 * Add or update data in the database
+-	 *
+-	 * @return array Array of table data
+-	 * @access public
+-	 */
+ 	public function update_data()
+ 	{
+ 		$data = array(
+@@ -92,12 +74,6 @@ class release_0_0_1 extends \phpbb\db\migration\container_aware_migration
+ 		return $data;
+ 	}
+ 
+-	/**
+-	 * Drop schema in the database
+-	 *
+-	 * @return array Array of table schema
+-	 * @access public
+-	 */
+ 	public function revert_schema()
+ 	{
+ 		return array(
+@@ -120,9 +96,6 @@ class release_0_0_1 extends \phpbb\db\migration\container_aware_migration
+ 
+ 	/**
+ 	 * Custom function query permission roles
+-	 *
+-	 * @return void
+-	 * @access public
+ 	 */
+ 	private function role_exists($role)
+ 	{
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/migrations/v10x/release_0_1_0.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/migrations/v10x/release_0_1_0.php"
+index 1196663f0..e0f25ed6d 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/migrations/v10x/release_0_1_0.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/migrations/v10x/release_0_1_0.php"
+@@ -3,7 +3,7 @@
+  *
+  * Best Answer extension for the phpBB Forum Software package.
+  *
+- * @copyright (c) 2019-2025, Leinad4Mind, https://leinad4mind.top/forum
++ * @copyright (c) 2019-2021, Leinad4Mind, https://leinad4mind.top/forum
+  * @license GNU General Public License, version 2 (GPL-2.0)
+  *
+  */
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/notification/type/markanswer.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/notification/type/markanswer.php"
+index 8cb1cb7b9..37b9e65f2 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/notification/type/markanswer.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/notification/type/markanswer.php"
+@@ -4,7 +4,7 @@
+  * Best Answer extension for the phpBB Forum Software package.
+  *
+  * @copyright (c) 2018, kinerity, https://www.layer-3.org/
+- * @copyright (c) 2019-2025, Leinad4Mind, https://leinad4mind.top/forum
++ * @copyright (c) 2019-2021, Leinad4Mind, https://leinad4mind.top/forum
+  * @license GNU General Public License, version 2 (GPL-2.0)
+  *
+  */
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/notification/type/unmarkanswer.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/notification/type/unmarkanswer.php"
+index 41784cdcd..55463bab4 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/notification/type/unmarkanswer.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/notification/type/unmarkanswer.php"
+@@ -4,7 +4,7 @@
+  * Best Answer extension for the phpBB Forum Software package.
+  *
+  * @copyright (c) 2018, kinerity, https://www.layer-3.org/
+- * @copyright (c) 2019-2025, Leinad4Mind, https://leinad4mind.top/forum
++ * @copyright (c) 2019-2021, Leinad4Mind, https://leinad4mind.top/forum
+  * @license GNU General Public License, version 2 (GPL-2.0)
+  *
+  */
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/styles/prosilver/template/event/mcp_topic_postrow_attachments_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/styles/prosilver/template/event/mcp_topic_postrow_attachments_after.html"
+index c4ff70abe..ef6990230 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/styles/prosilver/template/event/mcp_topic_postrow_attachments_after.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/styles/prosilver/template/event/mcp_topic_postrow_attachments_after.html"
+@@ -1,5 +1,5 @@
+ {% if postrow.S_FIRST_POST and postrow.ANSWER_POST_ID %}
+-<div class="postbody post_answer{% if S_NIGHTSTAKLER_ENABLED %}-dark{% endif %}"><i class="icon fa-check fa-fw icon-green" aria-hidden="true"></i><span class="author">{{ lang('POST_BY_AUTHOR') }} {{ postrow.ANSWER_USERNAME_FULL }} &raquo; {{ postrow.ANSWER_POST_TIME }}</span>
++<div class="postbody post_answer"><i class="icon fa-check fa-fw icon-green" aria-hidden="true"></i><span class="author">{{ lang('POST_BY_AUTHOR') }} {{ postrow.ANSWER_USERNAME_FULL }} &raquo; {{ postrow.ANSWER_POST_TIME }}</span>
+ <div class="content">{{ postrow.ANSWER_POST_TEXT }}</div>
+ <a href="{{ postrow.U_ANSWER }}">{{ lang('TO_POST') }}</a></div>
+ {% endif %}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/styles/prosilver/template/event/mcp_topic_postrow_post_after.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/styles/prosilver/template/event/mcp_topic_postrow_post_after.html"
+deleted file mode 100644
+index bf9d5b984..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/styles/prosilver/template/event/mcp_topic_postrow_post_after.html"
++++ /dev/null
+@@ -1,3 +0,0 @@
+-{% if postrow.POST_ID == postrow.ANSWER_POST_ID %}
+-	</div>
+-{% endif %} 
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/styles/prosilver/template/event/mcp_topic_postrow_post_before.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/styles/prosilver/template/event/mcp_topic_postrow_post_before.html"
+index 00aaa8735..6d95262ad 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/styles/prosilver/template/event/mcp_topic_postrow_post_before.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/styles/prosilver/template/event/mcp_topic_postrow_post_before.html"
+@@ -1,4 +1,3 @@
+ {% if postrow.POST_ID == postrow.ANSWER_POST_ID %}
+ <div class="answer hidden"></div>
+-	<div class="answer-post{% if S_NIGHTSTAKLER_ENABLED %}-dark{% endif %}">
+ {% endif %}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/styles/prosilver/template/event/memberlist_view_user_statistics_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/styles/prosilver/template/event/memberlist_view_user_statistics_after.html"
+index 6ba4564eb..3d9745583 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/styles/prosilver/template/event/memberlist_view_user_statistics_after.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/styles/prosilver/template/event/memberlist_view_user_statistics_after.html"
+@@ -2,7 +2,7 @@
+ {% INCLUDEJS '@leinad4mind_bestanswer/jxtools.js' %}
+ 
+ <div id="list_inner_hidden_container_1" jxdom-closest="div.column2" jxdom-find="dd:nth-of-type({%if S_WARNINGS %}4{% else %}3{% endif %})" jxdom-action="after" >
+-<dt>{{ lang('TOTAL_ANSWERS') ~ lang('COLON') }}</dt>
++<dt>{{ lang('TOTAL_ANSWERS') }}{{ lang('COLON') }}</dt>
+ <dd>{{ ANSWERS }}</dd>
+ </div>
+ {% endif %}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/styles/prosilver/template/event/search_results_topic_title_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/styles/prosilver/template/event/search_results_topic_title_after.html"
+index 31936188b..44f9c7e60 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/styles/prosilver/template/event/search_results_topic_title_after.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/styles/prosilver/template/event/search_results_topic_title_after.html"
+@@ -4,6 +4,6 @@
+ 		{% DEFINE INCLUDED_JXTOOLSJS = true %}
+ 	{% endif %}
+ <div id="list_inner_hidden_container_1" jxdom-closest="dl.postprofile" jxdom-find="dd:nth-of-type(3)" jxdom-action="replace" >
+-<dd>{{ lang('TOPIC') ~ lang('COLON') }} <i class="icon fa-check fa-fw icon-green" aria-hidden="true"></i> <a href="{{ searchresults.U_VIEW_TOPIC }}">{{ searchresults.TOPIC_TITLE }}</a></dd>
++<dd>{{ lang('TOPIC') }}{{ lang('COLON') }} <i class="icon fa-check fa-fw icon-green" aria-hidden="true"></i> <a href="{{ searchresults.U_VIEW_TOPIC }}">{{ searchresults.TOPIC_TITLE }}</a></dd>
+ </div>
+ {% endif %}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/styles/prosilver/template/event/ucp_pm_viewmessage_custom_fields_before.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/styles/prosilver/template/event/ucp_pm_viewmessage_custom_fields_before.html"
+index cf03487d3..6aff1f63a 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/styles/prosilver/template/event/ucp_pm_viewmessage_custom_fields_before.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/styles/prosilver/template/event/ucp_pm_viewmessage_custom_fields_before.html"
+@@ -2,6 +2,6 @@
+ {% INCLUDEJS '@leinad4mind_bestanswer/jxtools.js' %}
+ 
+ <dd id="list_inner_hidden_container_{{ MESSAGE_ID }}" jxdom-closest="dl.postprofile" jxdom-find="dd.profile-joined" jxdom-action="before" >
+-<div class="profile-answers"><strong>{{ lang('ANSWERS') ~ lang('COLON') }}</strong> {{ AUTHOR_ANSWERS }}</div>
++<div class="profile-answers"><strong>{{ lang('ANSWERS') }}{{ lang('COLON') }}</strong> {{ AUTHOR_ANSWERS }}</div>
+ </dd>
+ {% endif %}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/styles/prosilver/template/event/viewtopic_body_postrow_custom_fields_before.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/styles/prosilver/template/event/viewtopic_body_postrow_custom_fields_before.html"
+index b3003771e..3c4fa7844 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/styles/prosilver/template/event/viewtopic_body_postrow_custom_fields_before.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/styles/prosilver/template/event/viewtopic_body_postrow_custom_fields_before.html"
+@@ -2,6 +2,6 @@
+ {% INCLUDEJS '@leinad4mind_bestanswer/jxtools.js' %}
+ 
+ <dd id="list_inner_hidden_container_{{ postrow.POST_ID }}" jxdom-closest="dl.postprofile" jxdom-find="dd.profile-joined" jxdom-action="before" >
+-<div class="profile-answers"><strong>{{ lang('ANSWERS') ~ lang('COLON') }}</strong> {{ postrow.POSTER_ANSWERS }}</div>
++<div class="profile-answers"><strong>{{ lang('ANSWERS') }}{{ lang('COLON') }}</strong> {{ postrow.POSTER_ANSWERS }}</div>
+ </dd>
+ {% endif %}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/styles/prosilver/template/event/viewtopic_body_postrow_post_after.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/styles/prosilver/template/event/viewtopic_body_postrow_post_after.html"
+deleted file mode 100644
+index 9c1684e7e..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/styles/prosilver/template/event/viewtopic_body_postrow_post_after.html"
++++ /dev/null
+@@ -1,3 +0,0 @@
+-{% if postrow.POST_ID == postrow.ANSWER_POST_ID %}
+-	</div>
+-{% endif %}
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/styles/prosilver/template/event/viewtopic_body_postrow_post_before.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/styles/prosilver/template/event/viewtopic_body_postrow_post_before.html"
+index 00aaa8735..6d95262ad 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/styles/prosilver/template/event/viewtopic_body_postrow_post_before.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/styles/prosilver/template/event/viewtopic_body_postrow_post_before.html"
+@@ -1,4 +1,3 @@
+ {% if postrow.POST_ID == postrow.ANSWER_POST_ID %}
+ <div class="answer hidden"></div>
+-	<div class="answer-post{% if S_NIGHTSTAKLER_ENABLED %}-dark{% endif %}">
+ {% endif %}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/styles/prosilver/template/event/viewtopic_body_postrow_post_notices_before.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/styles/prosilver/template/event/viewtopic_body_postrow_post_notices_before.html"
+index c4ff70abe..ef6990230 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/styles/prosilver/template/event/viewtopic_body_postrow_post_notices_before.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/styles/prosilver/template/event/viewtopic_body_postrow_post_notices_before.html"
+@@ -1,5 +1,5 @@
+ {% if postrow.S_FIRST_POST and postrow.ANSWER_POST_ID %}
+-<div class="postbody post_answer{% if S_NIGHTSTAKLER_ENABLED %}-dark{% endif %}"><i class="icon fa-check fa-fw icon-green" aria-hidden="true"></i><span class="author">{{ lang('POST_BY_AUTHOR') }} {{ postrow.ANSWER_USERNAME_FULL }} &raquo; {{ postrow.ANSWER_POST_TIME }}</span>
++<div class="postbody post_answer"><i class="icon fa-check fa-fw icon-green" aria-hidden="true"></i><span class="author">{{ lang('POST_BY_AUTHOR') }} {{ postrow.ANSWER_USERNAME_FULL }} &raquo; {{ postrow.ANSWER_POST_TIME }}</span>
+ <div class="content">{{ postrow.ANSWER_POST_TEXT }}</div>
+ <a href="{{ postrow.U_ANSWER }}">{{ lang('TO_POST') }}</a></div>
+ {% endif %}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/styles/prosilver/theme/bestanswer.css" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/styles/prosilver/theme/bestanswer.css"
+index d1a2aeb69..c2ace4002 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/styles/prosilver/theme/bestanswer.css"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/styles/prosilver/theme/bestanswer.css"
+@@ -3,7 +3,7 @@
+ 	background-color: #EAF8E2;
+ }
+ 
+-.post_answer, .post_answer-dark {
++.post_answer {
+ 	background-color: #EAF8E2 !important;
+ 	padding: 10px;
+ 	border-radius: 7px;
+@@ -19,14 +19,6 @@
+ 	font-weight: normal;
+ }
+ 
+-.answer-post .panel {
+-	background-color: #eff9e9 !important;
+-}
+-
+-.post_answer-dark, .answer-post-dark .panel {
+-	background-color: #1a3509 !important;
+-}
+-
+ @media (max-width: 700px) {
+ 	div.profile-answers {
+ 		display: none;
diff --git "[FORUM_EXT]/leinad4mind\\bestanswer/diff_nospace.tmp" "[FORUM_EXT]/leinad4mind\\bestanswer/diff_nospace.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/leinad4mind\\bestanswer/diff_nospace.tmp"
@@ -0,0 +1,1640 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/README.md" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/README.md"
+deleted file mode 100644
+index 6e49f6ec7..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/README.md"
++++ /dev/null
+@@ -1,11 +0,0 @@
+-# Best Answer
+-
+-## Installation
+-
+-Copy the extension to phpBB/ext/leinad4mind/bestanswer
+-
+-Go to "ACP" > "Customise" > "Extensions" and enable the "Best Answer Special Edition" extension.
+-
+-## License
+-
+-[GPLv2](license.txt)
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/adm/style/event/acp_forums_normal_settings_append.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/adm/style/event/acp_forums_normal_settings_append.html"
+index 706694371..721f353e1 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/adm/style/event/acp_forums_normal_settings_append.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/adm/style/event/acp_forums_normal_settings_append.html"
+@@ -1,11 +1,11 @@
+ <dl>
+-	<dt><label for="enable_answer">{{ lang('ENABLE_ANSWER') ~ lang('COLON') }}</label><br /><span>{{ lang('ENABLE_ANSWER_EXPLAIN') }}</span></dt>
++	<dt><label for="enable_answer">{{ lang('ENABLE_ANSWER') }}{{ lang('COLON') }}</label><br /><span>{{ lang('ENABLE_ANSWER_EXPLAIN') }}</span></dt>
+ 	<dd><label><input type="radio" class="radio" name="enable_answer" value="1"{% if S_ENABLE_ANSWER %} id="enable_answer" checked="checked"{% endif %} /> {{ lang('YES') }}</label>
+ 		<label><input type="radio" class="radio" name="enable_answer" value="0"{% if not S_ENABLE_ANSWER %} id="enable_answer" checked="checked"{% endif %} /> {{ lang('NO') }}</label></dd>
+ </dl>
+ 
+ <dl>
+-	<dt><label for="bbpoints_answer">{{ lang('BBPOINTS_ANSWER') ~ lang('COLON') }}</label><br /><span>{{ lang('BBPOINTS_ANSWER_EXPLAIN') }}</span></dt>
++	<dt><label for="bbpoints_answer">{{ lang('BBPOINTS_ANSWER') }}{{ lang('COLON') }}</label><br /><span>{{ lang('BBPOINTS_ANSWER_EXPLAIN') }}</span></dt>
+ 	<dd>
+ 		<label><input type="number" name="bbpoints_answer" value="{S_BBPOINTS_ANSWER}"/></label>
+ 	</dd>
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/composer.json"
+index 93b532e02..08b0a0dfe 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/composer.json"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/composer.json"
+@@ -1,10 +1,10 @@
+ {
+     "name": "leinad4mind/bestanswer",
+     "type": "phpbb-extension",
+-    "description": "An extension for phpBB that allows users to mark a post as the 'Best Answer'.",
++    "description": "An extension for phpBB that allows users to mark a post as the best answer.",
+     "homepage": "https://leinad4mind.top/forum",
+-    "version": "2.1.0",
+-    "time": "2025-08-16",
++    "version": "2.0.2",
++    "time": "2021-01-30",
+     "keywords": [ "phpbb", "extension", "best", "answer", "leinad4mind", "special" ],
+     "license": "GPL-2.0-only",
+     "authors": [
+@@ -20,18 +20,18 @@
+     ],
+     "require": {
+         "php": ">=5.4.7",
+-        "phpbb/phpbb": ">=3.2.0,<4.0.0",
++        "phpbb/phpbb": ">=3.2.0,<3.3.0@dev",
+         "composer/installers": "~1.0.0"
+     },
+     "extra": {
+         "display-name": "Best Answer Special Edition",
+         "soft-require": {
+-            "phpbb/phpbb": ">=3.2.0,<4.0.0"
++            "phpbb/phpbb": ">=3.2.0,<3.3.0@dev"
+         },
+         "version-check": {
+             "host": "leinad4mind.top",
+             "directory": "/phpbb/bestanswer_special",
+-            "filename": "version_check"
++            "filename": "version_check.json"
+         }
+     }
+ }
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/controller/main_controller.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/controller/main_controller.php"
+index fb2927dd6..3ae8f597a 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/controller/main_controller.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/controller/main_controller.php"
+@@ -4,7 +4,7 @@
+  * Best Answer extension for the phpBB Forum Software package.
+  *
+  * @copyright (c) 2018, kinerity, https://www.layer-3.org/
+- * @copyright (c) 2019-2025, Leinad4Mind, https://leinad4mind.top/forum
++ * @copyright (c) 2019-2021, Leinad4Mind, https://leinad4mind.top/forum
+  * @license GNU General Public License, version 2 (GPL-2.0)
+  *
+  */
+@@ -51,7 +51,7 @@ class main_controller
+ 	/* @var string */
+ 	protected $php_ext;
+ 
+-	/* @var string  */
++	/* @var int bbpoints_table */
+ 	protected $bbpoints_table;
+ 	/**
+ 	 * Constructor
+@@ -62,7 +62,7 @@ class main_controller
+ 	 * @param \phpbb\log\log                      $log
+ 	 * @param \phpbb\request\request              $request
+ 	 * @param \phpbb\user                         $user
+-	 * @param string                              $bbpoints_table
++	 * @param int								  $bbpoints_table
+ 	 * @param \phpbb\notification\manager         $notification_manager
+ 	 * @param string                              $root_path
+ 	 * @param string                              $php_ext
+@@ -99,13 +99,9 @@ class main_controller
+ 	{
+ 		$post_id = $this->request->variable('p', 0);
+ 
+-		// Grab all the data necessary for error checking
++		// Query necessary topic data
+ 		$sql_arr = array(
+-			'SELECT'	=> 'f.forum_id, f.enable_answer, f.bbpoints_answer,
+-						p.post_id, p.topic_id, p.poster_id, p.post_subject,
+-						t.topic_id, t.forum_id, t.topic_title, t.topic_poster, t.topic_status,
+-						t.topic_first_post_id, t.answer_post_id, t.answer_user_id,
+-						u.user_id, u.username, u.user_colour',
++			'SELECT'	=> 'f.forum_id, f.enable_answer, p.post_id, p.topic_id, p.poster_id, p.post_subject, t.topic_id, t.forum_id, t.topic_title, t.topic_poster, t.topic_status, t.topic_first_post_id, t.answer_post_id, t.answer_user_id, u.user_id, u.username, u.user_colour',
+ 
+ 			'FROM'		=> array(
+ 				FORUMS_TABLE	=> 'f',
+@@ -125,17 +121,17 @@ class main_controller
+ 		// Error checking
+ 		if (!$topic_data['enable_answer'])
+ 		{
+-			throw new \phpbb\exception\http_exception(404, $this->lang->lang('EXTENSION_NOT_ENABLED')); 
++			throw new \phpbb\exception\http_exception(403, $this->lang->lang('NOT_AUTHORISED'));
+ 		}
+ 
+-		if ((int) $topic_data['topic_first_post_id'] == (int) $post_id)
++		if (!$this->auth->acl_get('m_mark_answer', (int) $topic_data['forum_id']) && (!$this->auth->acl_get('f_mark_answer', (int) $topic_data['forum_id']) && $topic_data['topic_poster'] != (int) $this->user->data['user_id']))
+ 		{
+-			throw new \phpbb\exception\http_exception(404, $this->lang->lang('TOPIC_FIRST_POST'));
++			throw new \phpbb\exception\http_exception(403, $this->lang->lang('NOT_AUTHORISED'));
+ 		}
+ 
+-		if (!$this->auth->acl_get('m_mark_answer', (int) $topic_data['forum_id']) && (!$this->auth->acl_get('f_mark_answer', (int) $topic_data['forum_id']) && $topic_data['topic_poster'] != (int) $this->user->data['user_id']))
++		if ((int) $topic_data['topic_first_post_id'] == (int) $post_id)
+ 		{
+-			throw new \phpbb\exception\http_exception(403, $this->lang->lang('NOT_AUTHORISED'));
++			throw new \phpbb\exception\http_exception(404, $this->lang->lang('NOT_AUTHORISED'));
+ 		}
+ 
+ 		if ((int) $topic_data['topic_status'] == ITEM_LOCKED && !$this->auth->acl_get('m_mark_answer', (int) $topic_data['forum_id']))
+@@ -166,13 +162,11 @@ class main_controller
+ 				$post_author = get_username_string('full', (int) $topic_data['user_id'], $topic_data['username'], $topic_data['user_colour']);
+ 				$this->log->add($log_var, (int) $this->user->data['user_id'], $this->user->data['user_ip'], 'LOG_UNMARK_ANSWER', time(), array($topic_data['post_subject'], $post_author));
+ 				
+-				// Remove BBPoints
+-				$reason = $this->db->sql_escape('bestanswer-' . (int) $post_id);
+-				$sql = 'DELETE FROM ' . $this->bbpoints_table . '
+-					WHERE to_id = ' . (int) $topic_data['user_id'] . '
+-					AND reason = "' . $reason . '"';
++				// remove bbpoints
++				$sql = 'DELETE FROM ' . $this->bbpoints_table . ' WHERE
++				to_id=' . (int) $topic_data['user_id'] . ' AND reason="bestanswer-'.$post_id.'"';
+ 				$this->db->sql_query($sql);
+-				$this->log->add($log_var, (int) $topic_data['user_id'], $this->user->data['user_ip'], 'LOG_BBPOINTS_UNMARK_ANSWER', time(), array($topic_data['post_subject'], $post_author));
++				$this->log->add($log_var, (int) $topic_data['user_id'], (int) $this->user->data['user_ip'], 'LOG_BBPOINTS_UNMARK_ANSWER', time(), array($topic_data['post_subject'], $post_author));
+ 
+ 				$this->notification_manager->delete_notifications('leinad4mind.bestanswer.notification.type.unmarkanswer', $post_id, $post_id, $topic_data['user_id']);
+ 				$this->notification_manager->add_notifications('leinad4mind.bestanswer.notification.type.unmarkanswer', [
+@@ -230,13 +224,12 @@ class main_controller
+ 				$post_author = get_username_string('full', (int) $topic_data['user_id'], $topic_data['username'], $topic_data['user_colour']);
+ 				$this->log->add($log_var, (int) $this->user->data['user_id'], $this->user->data['user_ip'], 'LOG_MARK_ANSWER', time(), array($topic_data['post_subject'], $post_author));
+ 
+-				// Add BBPoints
+-				if ((int) $topic_data['bbpoints_answer'] > 0) {
+-					$reason = $this->db->sql_escape('bestanswer-' . (int) $post_id);
++				// add bbpoints
++				if ($topic_data['bbpoints_answer'] > 0) {
+ 					$sql = 'INSERT INTO ' . $this->bbpoints_table . ' (from_id, to_id, bbpoints, reason, timestamp) 
+-						VALUES (0, ' . (int) $topic_data['user_id'] . ', ' . (int) $topic_data['bbpoints_answer'] . ', "' . $reason . '", ' . time() . ')';
++						VALUES(0, ' . (int) $topic_data['user_id'] . ', ' . $topic_data['bbpoints_answer'] . ', "bestanswer-'.$post_id.'", ' . time() . ')';
+ 					$this->db->sql_query($sql);
+-					$this->log->add($log_var, (int) $topic_data['user_id'], $this->user->data['user_ip'], 'LOG_BBPOINTS_MARK_ANSWER', time(), array($topic_data['post_subject'], $post_author));				
++					$this->log->add($log_var, (int) $topic_data['user_id'], (int) $this->user->data['user_ip'], 'LOG_BBPOINTS_MARK_ANSWER', time(), array($topic_data['post_subject'], $post_author));				
+ 				}
+ 
+ 				$this->notification_manager->delete_notifications('leinad4mind.bestanswer.notification.type.markanswer', $post_id, $post_id, $topic_data['user_id']);
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/diff_full.tmp"
+new file mode 100644
+index 000000000..99f2a766d
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/diff_full.tmp"
+@@ -0,0 +1,1484 @@
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/README.md" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/README.md"
++deleted file mode 100644
++index 6e49f6ec7..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/README.md"
+++++ /dev/null
++@@ -1,11 +0,0 @@
++-# Best Answer
++-
++-## Installation
++-
++-Copy the extension to phpBB/ext/leinad4mind/bestanswer
++-
++-Go to "ACP" > "Customise" > "Extensions" and enable the "Best Answer Special Edition" extension.
++-
++-## License
++-
++-[GPLv2](license.txt)
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/adm/style/event/acp_forums_normal_settings_append.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/adm/style/event/acp_forums_normal_settings_append.html"
++index 706694371..721f353e1 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/adm/style/event/acp_forums_normal_settings_append.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/adm/style/event/acp_forums_normal_settings_append.html"
++@@ -1,11 +1,11 @@
++ <dl>
++-	<dt><label for="enable_answer">{{ lang('ENABLE_ANSWER') ~ lang('COLON') }}</label><br /><span>{{ lang('ENABLE_ANSWER_EXPLAIN') }}</span></dt>
+++	<dt><label for="enable_answer">{{ lang('ENABLE_ANSWER') }}{{ lang('COLON') }}</label><br /><span>{{ lang('ENABLE_ANSWER_EXPLAIN') }}</span></dt>
++ 	<dd><label><input type="radio" class="radio" name="enable_answer" value="1"{% if S_ENABLE_ANSWER %} id="enable_answer" checked="checked"{% endif %} /> {{ lang('YES') }}</label>
++ 		<label><input type="radio" class="radio" name="enable_answer" value="0"{% if not S_ENABLE_ANSWER %} id="enable_answer" checked="checked"{% endif %} /> {{ lang('NO') }}</label></dd>
++ </dl>
++ 
++ <dl>
++-	<dt><label for="bbpoints_answer">{{ lang('BBPOINTS_ANSWER') ~ lang('COLON') }}</label><br /><span>{{ lang('BBPOINTS_ANSWER_EXPLAIN') }}</span></dt>
+++	<dt><label for="bbpoints_answer">{{ lang('BBPOINTS_ANSWER') }}{{ lang('COLON') }}</label><br /><span>{{ lang('BBPOINTS_ANSWER_EXPLAIN') }}</span></dt>
++ 	<dd>
++ 		<label><input type="number" name="bbpoints_answer" value="{S_BBPOINTS_ANSWER}"/></label>
++ 	</dd>
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/composer.json"
++index 93b532e02..08b0a0dfe 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/composer.json"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/composer.json"
++@@ -1,10 +1,10 @@
++ {
++     "name": "leinad4mind/bestanswer",
++     "type": "phpbb-extension",
++-    "description": "An extension for phpBB that allows users to mark a post as the 'Best Answer'.",
+++    "description": "An extension for phpBB that allows users to mark a post as the best answer.",
++     "homepage": "https://leinad4mind.top/forum",
++-    "version": "2.1.0",
++-    "time": "2025-08-16",
+++    "version": "2.0.2",
+++    "time": "2021-01-30",
++     "keywords": [ "phpbb", "extension", "best", "answer", "leinad4mind", "special" ],
++     "license": "GPL-2.0-only",
++     "authors": [
++@@ -20,18 +20,18 @@
++     ],
++     "require": {
++         "php": ">=5.4.7",
++-        "phpbb/phpbb": ">=3.2.0,<4.0.0",
+++        "phpbb/phpbb": ">=3.2.0,<3.3.0@dev",
++         "composer/installers": "~1.0.0"
++     },
++     "extra": {
++         "display-name": "Best Answer Special Edition",
++         "soft-require": {
++-            "phpbb/phpbb": ">=3.2.0,<4.0.0"
+++            "phpbb/phpbb": ">=3.2.0,<3.3.0@dev"
++         },
++         "version-check": {
++             "host": "leinad4mind.top",
++             "directory": "/phpbb/bestanswer_special",
++-            "filename": "version_check"
+++            "filename": "version_check.json"
++         }
++     }
++ }
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/controller/main_controller.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/controller/main_controller.php"
++index fb2927dd6..3ae8f597a 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/controller/main_controller.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/controller/main_controller.php"
++@@ -4,7 +4,7 @@
++  * Best Answer extension for the phpBB Forum Software package.
++  *
++  * @copyright (c) 2018, kinerity, https://www.layer-3.org/
++- * @copyright (c) 2019-2025, Leinad4Mind, https://leinad4mind.top/forum
+++ * @copyright (c) 2019-2021, Leinad4Mind, https://leinad4mind.top/forum
++  * @license GNU General Public License, version 2 (GPL-2.0)
++  *
++  */
++@@ -51,7 +51,7 @@ class main_controller
++ 	/* @var string */
++ 	protected $php_ext;
++ 
++-	/* @var string  */
+++	/* @var int bbpoints_table */
++ 	protected $bbpoints_table;
++ 	/**
++ 	 * Constructor
++@@ -62,7 +62,7 @@ class main_controller
++ 	 * @param \phpbb\log\log                      $log
++ 	 * @param \phpbb\request\request              $request
++ 	 * @param \phpbb\user                         $user
++-	 * @param string                              $bbpoints_table
+++	 * @param int								  $bbpoints_table
++ 	 * @param \phpbb\notification\manager         $notification_manager
++ 	 * @param string                              $root_path
++ 	 * @param string                              $php_ext
++@@ -99,13 +99,9 @@ class main_controller
++ 	{
++ 		$post_id = $this->request->variable('p', 0);
++ 
++-		// Grab all the data necessary for error checking
+++		// Query necessary topic data
++ 		$sql_arr = array(
++-			'SELECT'	=> 'f.forum_id, f.enable_answer, f.bbpoints_answer,
++-						p.post_id, p.topic_id, p.poster_id, p.post_subject,
++-						t.topic_id, t.forum_id, t.topic_title, t.topic_poster, t.topic_status,
++-						t.topic_first_post_id, t.answer_post_id, t.answer_user_id,
++-						u.user_id, u.username, u.user_colour',
+++			'SELECT'	=> 'f.forum_id, f.enable_answer, p.post_id, p.topic_id, p.poster_id, p.post_subject, t.topic_id, t.forum_id, t.topic_title, t.topic_poster, t.topic_status, t.topic_first_post_id, t.answer_post_id, t.answer_user_id, u.user_id, u.username, u.user_colour',
++ 
++ 			'FROM'		=> array(
++ 				FORUMS_TABLE	=> 'f',
++@@ -123,14 +119,9 @@ class main_controller
++ 		$this->db->sql_freeresult($result);
++ 
++ 		// Error checking
++-		if (!$topic_data['enable_answer']) 
++-		{ 
++-			throw new \phpbb\exception\http_exception(404, $this->lang->lang('EXTENSION_NOT_ENABLED')); 
++-		}
++-
++-		if ((int) $topic_data['topic_first_post_id'] == (int) $post_id)
+++		if (!$topic_data['enable_answer'])
++ 		{
++-			throw new \phpbb\exception\http_exception(404, $this->lang->lang('TOPIC_FIRST_POST'));
+++			throw new \phpbb\exception\http_exception(403, $this->lang->lang('NOT_AUTHORISED'));
++ 		}
++ 
++ 		if (!$this->auth->acl_get('m_mark_answer', (int) $topic_data['forum_id']) && (!$this->auth->acl_get('f_mark_answer', (int) $topic_data['forum_id']) && $topic_data['topic_poster'] != (int) $this->user->data['user_id']))
++@@ -138,6 +129,11 @@ class main_controller
++ 			throw new \phpbb\exception\http_exception(403, $this->lang->lang('NOT_AUTHORISED'));
++ 		}
++ 
+++		if ((int) $topic_data['topic_first_post_id'] == (int) $post_id)
+++		{
+++			throw new \phpbb\exception\http_exception(404, $this->lang->lang('NOT_AUTHORISED'));
+++		}
+++
++ 		if ((int) $topic_data['topic_status'] == ITEM_LOCKED && !$this->auth->acl_get('m_mark_answer', (int) $topic_data['forum_id']))
++ 		{
++ 			throw new \phpbb\exception\http_exception(403, $this->lang->lang('NOT_AUTHORISED'));
++@@ -166,13 +162,11 @@ class main_controller
++ 				$post_author = get_username_string('full', (int) $topic_data['user_id'], $topic_data['username'], $topic_data['user_colour']);
++ 				$this->log->add($log_var, (int) $this->user->data['user_id'], $this->user->data['user_ip'], 'LOG_UNMARK_ANSWER', time(), array($topic_data['post_subject'], $post_author));
++ 				
++-				// Remove BBPoints
++-				$reason = $this->db->sql_escape('bestanswer-' . (int) $post_id);
++-				$sql = 'DELETE FROM ' . $this->bbpoints_table . '
++-					WHERE to_id = ' . (int) $topic_data['user_id'] . '
++-					AND reason = "' . $reason . '"';
+++				// remove bbpoints
+++				$sql = 'DELETE FROM ' . $this->bbpoints_table . ' WHERE
+++				to_id=' . (int) $topic_data['user_id'] . ' AND reason="bestanswer-'.$post_id.'"';
++ 				$this->db->sql_query($sql);
++-				$this->log->add($log_var, (int) $topic_data['user_id'], $this->user->data['user_ip'], 'LOG_BBPOINTS_UNMARK_ANSWER', time(), array($topic_data['post_subject'], $post_author));
+++				$this->log->add($log_var, (int) $topic_data['user_id'], (int) $this->user->data['user_ip'], 'LOG_BBPOINTS_UNMARK_ANSWER', time(), array($topic_data['post_subject'], $post_author));
++ 
++ 				$this->notification_manager->delete_notifications('leinad4mind.bestanswer.notification.type.unmarkanswer', $post_id, $post_id, $topic_data['user_id']);
++ 				$this->notification_manager->add_notifications('leinad4mind.bestanswer.notification.type.unmarkanswer', [
++@@ -230,13 +224,12 @@ class main_controller
++ 				$post_author = get_username_string('full', (int) $topic_data['user_id'], $topic_data['username'], $topic_data['user_colour']);
++ 				$this->log->add($log_var, (int) $this->user->data['user_id'], $this->user->data['user_ip'], 'LOG_MARK_ANSWER', time(), array($topic_data['post_subject'], $post_author));
++ 
++-				// Add BBPoints
++-				if ((int) $topic_data['bbpoints_answer'] > 0) {
++-					$reason = $this->db->sql_escape('bestanswer-' . (int) $post_id);
+++				// add bbpoints
+++				if ($topic_data['bbpoints_answer'] > 0) {
++ 					$sql = 'INSERT INTO ' . $this->bbpoints_table . ' (from_id, to_id, bbpoints, reason, timestamp) 
++-						VALUES (0, ' . (int) $topic_data['user_id'] . ', ' . (int) $topic_data['bbpoints_answer'] . ', "' . $reason . '", ' . time() . ')';
+++						VALUES(0, ' . (int) $topic_data['user_id'] . ', ' . $topic_data['bbpoints_answer'] . ', "bestanswer-'.$post_id.'", ' . time() . ')';
++ 					$this->db->sql_query($sql);
++-					$this->log->add($log_var, (int) $topic_data['user_id'], $this->user->data['user_ip'], 'LOG_BBPOINTS_MARK_ANSWER', time(), array($topic_data['post_subject'], $post_author));				
+++					$this->log->add($log_var, (int) $topic_data['user_id'], (int) $this->user->data['user_ip'], 'LOG_BBPOINTS_MARK_ANSWER', time(), array($topic_data['post_subject'], $post_author));				
++ 				}
++ 
++ 				$this->notification_manager->delete_notifications('leinad4mind.bestanswer.notification.type.markanswer', $post_id, $post_id, $topic_data['user_id']);
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/diff_full.tmp"
++new file mode 100644
++index 000000000..dcafcb8d7
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/diff_full.tmp"
++@@ -0,0 +1,155 @@
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/README.md" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/README.md"
+++deleted file mode 100644
+++index 6e49f6ec7..000000000
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/README.md"
++++++ /dev/null
+++@@ -1,11 +0,0 @@
+++-# Best Answer
+++-
+++-## Installation
+++-
+++-Copy the extension to phpBB/ext/leinad4mind/bestanswer
+++-
+++-Go to "ACP" > "Customise" > "Extensions" and enable the "Best Answer Special Edition" extension.
+++-
+++-## License
+++-
+++-[GPLv2](license.txt)
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/adm/style/event/acp_forums_normal_settings_append.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/adm/style/event/acp_forums_normal_settings_append.html"
+++index 706694371..721f353e1 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/adm/style/event/acp_forums_normal_settings_append.html"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/adm/style/event/acp_forums_normal_settings_append.html"
+++@@ -1,11 +1,11 @@
+++ <dl>
+++-	<dt><label for="enable_answer">{{ lang('ENABLE_ANSWER') ~ lang('COLON') }}</label><br /><span>{{ lang('ENABLE_ANSWER_EXPLAIN') }}</span></dt>
++++	<dt><label for="enable_answer">{{ lang('ENABLE_ANSWER') }}{{ lang('COLON') }}</label><br /><span>{{ lang('ENABLE_ANSWER_EXPLAIN') }}</span></dt>
+++ 	<dd><label><input type="radio" class="radio" name="enable_answer" value="1"{% if S_ENABLE_ANSWER %} id="enable_answer" checked="checked"{% endif %} /> {{ lang('YES') }}</label>
+++ 		<label><input type="radio" class="radio" name="enable_answer" value="0"{% if not S_ENABLE_ANSWER %} id="enable_answer" checked="checked"{% endif %} /> {{ lang('NO') }}</label></dd>
+++ </dl>
+++ 
+++ <dl>
+++-	<dt><label for="bbpoints_answer">{{ lang('BBPOINTS_ANSWER') ~ lang('COLON') }}</label><br /><span>{{ lang('BBPOINTS_ANSWER_EXPLAIN') }}</span></dt>
++++	<dt><label for="bbpoints_answer">{{ lang('BBPOINTS_ANSWER') }}{{ lang('COLON') }}</label><br /><span>{{ lang('BBPOINTS_ANSWER_EXPLAIN') }}</span></dt>
+++ 	<dd>
+++ 		<label><input type="number" name="bbpoints_answer" value="{S_BBPOINTS_ANSWER}"/></label>
+++ 	</dd>
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/composer.json"
+++index 93b532e02..08b0a0dfe 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/composer.json"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/composer.json"
+++@@ -1,10 +1,10 @@
+++ {
+++     "name": "leinad4mind/bestanswer",
+++     "type": "phpbb-extension",
+++-    "description": "An extension for phpBB that allows users to mark a post as the 'Best Answer'.",
++++    "description": "An extension for phpBB that allows users to mark a post as the best answer.",
+++     "homepage": "https://leinad4mind.top/forum",
+++-    "version": "2.1.0",
+++-    "time": "2025-08-16",
++++    "version": "2.0.2",
++++    "time": "2021-01-30",
+++     "keywords": [ "phpbb", "extension", "best", "answer", "leinad4mind", "special" ],
+++     "license": "GPL-2.0-only",
+++     "authors": [
+++@@ -20,18 +20,18 @@
+++     ],
+++     "require": {
+++         "php": ">=5.4.7",
+++-        "phpbb/phpbb": ">=3.2.0,<4.0.0",
++++        "phpbb/phpbb": ">=3.2.0,<3.3.0@dev",
+++         "composer/installers": "~1.0.0"
+++     },
+++     "extra": {
+++         "display-name": "Best Answer Special Edition",
+++         "soft-require": {
+++-            "phpbb/phpbb": ">=3.2.0,<4.0.0"
++++            "phpbb/phpbb": ">=3.2.0,<3.3.0@dev"
+++         },
+++         "version-check": {
+++             "host": "leinad4mind.top",
+++             "directory": "/phpbb/bestanswer_special",
+++-            "filename": "version_check"
++++            "filename": "version_check.json"
+++         }
+++     }
+++ }
+++\ No newline at end of file
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/controller/main_controller.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/controller/main_controller.php"
+++index fb2927dd6..3ae8f597a 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/controller/main_controller.php"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/controller/main_controller.php"
+++@@ -4,7 +4,7 @@
+++  * Best Answer extension for the phpBB Forum Software package.
+++  *
+++  * @copyright (c) 2018, kinerity, https://www.layer-3.org/
+++- * @copyright (c) 2019-2025, Leinad4Mind, https://leinad4mind.top/forum
++++ * @copyright (c) 2019-2021, Leinad4Mind, https://leinad4mind.top/forum
+++  * @license GNU General Public License, version 2 (GPL-2.0)
+++  *
+++  */
+++@@ -51,7 +51,7 @@ class main_controller
+++ 	/* @var string */
+++ 	protected $php_ext;
+++ 
+++-	/* @var string  */
++++	/* @var int bbpoints_table */
+++ 	protected $bbpoints_table;
+++ 	/**
+++ 	 * Constructor
+++@@ -62,7 +62,7 @@ class main_controller
+++ 	 * @param \phpbb\log\log                      $log
+++ 	 * @param \phpbb\request\request              $request
+++ 	 * @param \phpbb\user                         $user
+++-	 * @param string                              $bbpoints_table
++++	 * @param int								  $bbpoints_table
+++ 	 * @param \phpbb\notification\manager         $notification_manager
+++ 	 * @param string                              $root_path
+++ 	 * @param string                              $php_ext
+++@@ -99,13 +99,9 @@ class main_controller
+++ 	{
+++ 		$post_id = $this->request->variable('p', 0);
+++ 
+++-		// Grab all the data necessary for error checking
++++		// Query necessary topic data
+++ 		$sql_arr = array(
+++-			'SELECT'	=> 'f.forum_id, f.enable_answer, f.bbpoints_answer,
+++-						p.post_id, p.topic_id, p.poster_id, p.post_subject,
+++-						t.topic_id, t.forum_id, t.topic_title, t.topic_poster, t.topic_status,
+++-						t.topic_first_post_id, t.answer_post_id, t.answer_user_id,
+++-						u.user_id, u.username, u.user_colour',
++++			'SELECT'	=> 'f.forum_id, f.enable_answer, p.post_id, p.topic_id, p.poster_id, p.post_subject, t.topic_id, t.forum_id, t.topic_title, t.topic_poster, t.topic_status, t.topic_first_post_id, t.answer_post_id, t.answer_user_id, u.user_id, u.username, u.user_colour',
+++ 
+++ 			'FROM'		=> array(
+++ 				FORUMS_TABLE	=> 'f',
+++@@ -123,14 +119,9 @@ class main_controller
+++ 		$this->db->sql_freeresult($result);
+++ 
+++ 		// Error checking
+++-		if (!$topic_data['enable_answer']) 
+++-		{ 
+++-			throw new \phpbb\exception\http_exception(404, $this->lang->lang('EXTENSION_NOT_ENABLED')); 
+++-		}
+++-
+++-		if ((int) $topic_data['topic_first_post_id'] == (int) $post_id)
++++		if (!$topic_data['enable_answer'])
+++ 		{
+++-			throw new \phpbb\exception\http_exception(404, $this->lang->lang('TOPIC_FIRST_POST'));
++++			throw new \phpbb\exception\http_exception(403, $this->lang->lang('NOT_AUTHORISED'));
+++ 		}
+++ 
+++ 		if (!$this->auth->acl_get('m_mark_answer', (int) $topic_data['forum_id']) && (!$this->auth->acl_get('f_mark_answer', (int) $topic_data['forum_id']) && $topic_data['topic_poster'] != (int) $this->user->data['user_id']))
+++@@ -138,6 +129,11 @@ class main_controller
+++ 			throw new \phpbb\exception\http_exception(403, $this->lang->lang('NOT_AUTHORISED'));
+++ 		}
+++ 
++++		if ((int) $topic_data['topic_first_post_id'] == (int) $post_id)
++++		{
++++			throw new \phpbb\exception\http_exception(404, $this->lang->lang('NOT_AUTHORISED'));
++++		}
++++
+++ 		if ((int) $topic_data['topic_status'] == ITEM_LOCKED && !$this->auth->acl_get('m_mark_answer', (int) $topic_data['forum_id']))
+++ 		{
+++ 			throw new \phpbb\exception\http_exception(403, $this->lang->lang('NOT_AUTHORISED'));
+++@@ -166,13 +162,11 @@ class main_controller
+++ 				$post_author = get_username_string('full', (int) $topic_data['user_id'], $topic_data['username'], $topic_data['user_colour']);
+++ 				$this->log->add($log_var, (int) $this->user->data['user_id'], $this->user->data['user_ip'], 'LOG_UNMARK_ANSWER', time(), array($topic_data['post_subject'], $post_author))
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/event/main_listener.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/event/main_listener.php"
++index e009efc64..7b57e088d 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/event/main_listener.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/event/main_listener.php"
++@@ -4,7 +4,7 @@
++  * Best Answer extension for the phpBB Forum Software package.
++  *
++  * @copyright (c) 2018, kinerity, https://www.layer-3.org/
++- * @copyright (c) 2019-2025, Leinad4Mind, https://leinad4mind.top/forum
+++ * @copyright (c) 2019-2021, Leinad4Mind, https://leinad4mind.top/forum
++  * @license GNU General Public License, version 2 (GPL-2.0)
++  *
++  */
++@@ -154,7 +154,7 @@ class main_listener implements EventSubscriberInterface
++ 	public function acp_manage_forums_display_form($event)
++ 	{
++ 		$event->update_subarray('template_data', 'S_ENABLE_ANSWER', $event['forum_data']['enable_answer']);
++-		$event->update_subarray('template_data', 'S_BBPOINTS_ANSWER', (int) $event['forum_data']['bbpoints_answer']);
+++		$event->update_subarray('template_data', 'S_BBPOINTS_ANSWER', (int)$event['forum_data']['bbpoints_answer']);
++ 	}
++ 
++ 	public function acp_manage_forums_initialise_data($event)
++@@ -184,14 +184,13 @@ class main_listener implements EventSubscriberInterface
++ 			WHERE ' . $this->db->sql_in_set('topic_id', $topic_ids) . '
++ 				AND answer_post_id <> 0';
++ 		$result = $this->db->sql_query($sql);
++-
++ 		while ($row = $this->db->sql_fetchrow($result))
++ 		{
++ 			if (in_array($row['answer_post_id'], $post_ids))
++ 			{
++ 				$answer_post_ids[] = $row['answer_post_id'];
++ 				$answer_user_ids[] = $row['answer_user_id'];
++-				$answer_bbpoints_ids[] = 'bestanswer-' . $row['answer_post_id'];
+++				$answer_bbpoints_ids[] = 'bestanswer-'.$row['answer_post_id'];
++ 			}
++ 		}
++ 		$this->db->sql_freeresult($result);
++@@ -201,9 +200,9 @@ class main_listener implements EventSubscriberInterface
++ 			'answer_user_id'	=> 0,
++ 		);
++ 
++-		if (!empty($answer_post_ids))
+++		if ($answer_post_ids)
++ 		{
++-			// Remove BBPoints
+++			// remove bbpoints
++ 			$sql = 'DELETE FROM ' . $this->bbpoints_table . ' WHERE
++ 			' . $this->db->sql_in_set('to_id', $answer_user_ids) . ' AND '.$this->db->sql_in_set('reason', $answer_bbpoints_ids);
++ 			$this->db->sql_query($sql);
++@@ -213,7 +212,7 @@ class main_listener implements EventSubscriberInterface
++ 			$this->db->sql_query($sql);
++ 		}
++ 
++-		if (!empty($answer_user_ids))
+++		if ($answer_user_ids)
++ 		{
++ 			$sql = 'UPDATE ' . USERS_TABLE . '
++ 				SET user_answers = user_answers - 1
++@@ -237,7 +236,7 @@ class main_listener implements EventSubscriberInterface
++ 		}
++ 		$this->db->sql_freeresult($result);
++ 
++-		if (!empty($answer_user_ids))
+++		if ($answer_user_ids)
++ 		{
++ 			$sql = 'UPDATE ' . USERS_TABLE . '
++ 				SET user_answers = user_answers - 1
++@@ -271,16 +270,16 @@ class main_listener implements EventSubscriberInterface
++ 	{
++ 		$sql_ary = $event['sql_ary'];
++ 
++-		$sql_ary['SELECT'] .= ', ba_t.answer_post_id';
+++		$sql_ary['SELECT'] .= ', a_t.answer_post_id';
++ 
++ 		$sql_ary['LEFT_JOIN'][] = array(
++-			'FROM'	=> array(POSTS_TABLE => 'ba_p'),
++-			'ON'	=> 'f.forum_last_post_id = ba_p.post_id',
+++			'FROM'	=> array(POSTS_TABLE => 'a_p'),
+++			'ON'	=> 'f.forum_last_post_id = a_p.post_id',
++ 		);
++ 
++ 		$sql_ary['LEFT_JOIN'][] = array(
++-			'FROM'	=> array(TOPICS_TABLE => 'ba_t'),
++-			'ON'	=> 'ba_t.topic_id = ba_p.topic_id',
+++			'FROM'	=> array(TOPICS_TABLE => 'a_t'),
+++			'ON'	=> 'a_t.topic_id = a_p.topic_id',
++ 		);
++ 
++ 		$event['sql_ary'] = $sql_ary;
++@@ -374,7 +373,7 @@ class main_listener implements EventSubscriberInterface
++ 		$topic_info = $event['topic_info'];
++ 
++ 		// Does the topic have a best answer and is the post the first post in a topic
++-		if (!empty($this->answer) && ($topic_info['topic_first_post_id'] == $row['post_id']))
+++		if ($this->answer && ($topic_info['topic_first_post_id'] == $row['post_id']))
++ 		{
++ 			$post_row = array_merge($post_row, array(
++ 				'U_ANSWER'	=> append_sid("{$this->root_path}viewtopic.{$this->php_ext}", 'p=' . (int) $topic_info['answer_post_id'] . '#p' . (int) $topic_info['answer_post_id']),
++@@ -416,7 +415,7 @@ class main_listener implements EventSubscriberInterface
++ 	public function modify_topicrow_tpl_ary($event)
++ 	{
++ 		$block = $event['topic_row'] ? 'topic_row' : 'tpl_ary';
++-		$event[$block] = $this->display_topic_answered($event['row'], $event[$block]);
+++		$event[$block] = $this->modify_topicrow_tpl($event['row'], $event[$block]);
++ 	}
++ 
++ 	public function permissions($event)
++@@ -584,7 +583,7 @@ class main_listener implements EventSubscriberInterface
++ 		));
++ 
++ 		// Only add to post_row array if an answer_post_id is supplied and the post_id is the first post in a topic
++-		if (!empty($this->answer) && ($topic_data['topic_first_post_id'] == $row['post_id']))
+++		if ($this->answer && ($topic_data['topic_first_post_id'] == $row['post_id']))
++ 		{
++ 			$post_row = array_merge($post_row, array(
++ 				'ANSWER_POST_TEXT'		=> $this->answer['POST_TEXT'],
++@@ -596,7 +595,7 @@ class main_listener implements EventSubscriberInterface
++ 		$event['post_row'] = $post_row;
++ 	}
++ 
++-	private function display_topic_answered($row, $block)
+++	private function modify_topicrow_tpl($row, $block)
++ 	{
++ 		$block = array_merge($block, array(
++ 			'S_ANSWERED'	=> $row['answer_post_id'] ? true : false,
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/ext.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/ext.php"
++index 216db0084..d37926a55 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/ext.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/ext.php"
++@@ -4,7 +4,7 @@
++  * Best Answer extension for the phpBB Forum Software package.
++  *
++  * @copyright (c) 2018, kinerity, https://www.layer-3.org/
++- * @copyright (c) 2019-2025, Leinad4Mind, https://leinad4mind.top/forum
+++ * @copyright (c) 2019-2021, Leinad4Mind, https://leinad4mind.top/forum
++  * @license GNU General Public License, version 2 (GPL-2.0)
++  *
++  */
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/language/ar/common.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/language/ar/common.php"
++index abe513ecc..b2fe7d96e 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/language/ar/common.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/language/ar/common.php"
++@@ -4,7 +4,7 @@
++  * Best Answer extension for the phpBB Forum Software package.
++  *
++  * @copyright (c) 2018, kinerity, https://www.layer-3.org/
++- * @copyright (c) 2019-2025, Leinad4Mind, https://leinad4mind.top/forum
+++ * @copyright (c) 2019-2021, Leinad4Mind, https://leinad4mind.top/forum
++  * @translation (c) 2019 Bassel Taha Alhitary, http://www.alhitary.net
++  * @license GNU General Public License, version 2 (GPL-2.0)
++  * 
++@@ -49,7 +49,8 @@ $lang = array_merge($lang, array(
++ 
++ 	'ENABLE_ANSWER'			=> 'تفعيل “أفضل إجابة”',
++ 	'ENABLE_ANSWER_EXPLAIN'	=> 'عند اختيارك “نعم”, كاتب الموضوع (إذا لديه الترخيص) والمشرفين (بالمنتديات المسموح بها) يستطيعون إضافة علامة “أفضل إجابة” إلى أحد ردود الموضوع',
++-	'EXTENSION_NOT_ENABLED'			=> 'ملحق ”أفضل إجابة“ غير ممكّن في هذا المنتدى.',
+++
+++	'TO_POST'	=> '<i class="fa fa-eye"></i> الذهاب إلى المشاركة',
++ 
++ 	'LOG_MARK_ANSWER'	=> '<strong>تحديد المشاركة كـ “أفضل إجابة”</strong><br />» %1$s بواسطة %2$s',
++ 	'LOG_UNMARK_ANSWER'	=> '<strong>إلغاء تحديد المشاركة كـ “أفضل إجابة”</strong><br />» %1$s بواسطة %2$s',
++@@ -60,8 +61,6 @@ $lang = array_merge($lang, array(
++ 	'MARK_ANSWER'			=> 'تحديد الإجابة الأفضل',
++ 	'MARK_ANSWER_CONFIRM'	=> 'متأكد أنك تريد تحديد هذه المشاركة كأفضل إجابة؟',
++ 
++-	'TO_POST'	=> '<i class="fa fa-eye"></i> الذهاب إلى المشاركة',
++-	'TOPIC_FIRST_POST'	=> 'لا يمكنك وضع علامة على هذا المنشور كأفضل إجابة لأنه المنشور الأول في الموضوع.', 
++ 	'TOTAL_ANSWERS'	=> 'إجمالي الإجابات',
++ 
++ 	'UNMARK_ANSWER'			=> 'إلغاء تحديد الإجابة الأفضل',
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/language/ar/permissions_bestanswer.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/language/ar/permissions_bestanswer.php"
++index f159c642b..a2aeba17d 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/language/ar/permissions_bestanswer.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/language/ar/permissions_bestanswer.php"
++@@ -4,7 +4,7 @@
++  * Best Answer extension for the phpBB Forum Software package.
++  *
++  * @copyright (c) 2018, kinerity, https://www.layer-3.org/
++- * @copyright (c) 2019-2025, Leinad4Mind, https://leinad4mind.top/forum
+++ * @copyright (c) 2019-2021, Leinad4Mind, https://leinad4mind.top/forum
++  * @translation (c) 2019 Bassel Taha Alhitary, http://www.alhitary.net
++  * @license GNU General Public License, version 2 (GPL-2.0)
++  *
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/language/en/common.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/language/en/common.php"
++index fd7ccc867..ba6bb2678 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/language/en/common.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/language/en/common.php"
++@@ -4,7 +4,7 @@
++  * Best Answer extension for the phpBB Forum Software package.
++  *
++  * @copyright (c) 2018, kinerity, https://www.layer-3.org/
++- * @copyright (c) 2019-2025, Leinad4Mind, https://leinad4mind.top/forum
+++ * @copyright (c) 2019-2021, Leinad4Mind, https://leinad4mind.top/forum
++  * @license GNU General Public License, version 2 (GPL-2.0)
++  *
++  */
++@@ -43,24 +43,23 @@ $lang = array_merge($lang, array(
++ 	'ANSWERED'		=> 'Answered',
++ 	
++ 	'BEST_ANSWER'	=> 'Best answer',
++-	'BBPOINTS_ANSWER'			=> 'Amount of BBPoints for "Best Answer" post',
++-	'BBPOINTS_ANSWER_EXPLAIN'	=> 'Set the number of BBPoints to be credited to post author when his post in this forum is marked as "Best Answer"',
+++	'BBPOINTS_ANSWER'			=> 'Amount of BBpoints for "Best Answer" post',
+++	'BBPOINTS_ANSWER_EXPLAIN'	=> 'Set the number of BBpoints to be credited to post author when his post in this forum is marked as "Best Answer"',
++ 
++ 	'ENABLE_ANSWER'			=> 'Enable best answer',
++ 	'ENABLE_ANSWER_EXPLAIN'	=> 'If enabled, the topic starter (if permitted) and moderators (where allowed) will be able to mark a topic reply as the best answer.',
++-	'EXTENSION_NOT_ENABLED'			=> 'The Best Answer extension is not enabled on this forum.',
+++
+++	'TO_POST'	=> '<i class="fa fa-eye"></i> View Post',
++ 
++ 	'LOG_MARK_ANSWER'	=> '<strong>Marked post as best answer</strong><br />» %1$s by %2$s',
++ 	'LOG_UNMARK_ANSWER'	=> '<strong>Unmarked post as best answer</strong><br />» %1$s by %2$s',
++ 
++-	'LOG_BBPOINTS_MARK_ANSWER'		=> '<strong>Added BBPoints to author for best answer</strong><br />» %1$s by %2$s',
++-	'LOG_BBPOINTS_UNMARK_ANSWER'	=> '<strong>Removed BBPoints of author for best answer</strong><br />» %1$s by %2$s',
+++	'LOG_BBPOINTS_MARK_ANSWER'		=> '<strong>Added bbpoints to author for best answer</strong><br />» %1$s by %2$s',
+++	'LOG_BBPOINTS_UNMARK_ANSWER'	=> '<strong>Removed bbpoints of author for best answer</strong><br />» %1$s by %2$s',
++ 
++ 	'MARK_ANSWER'			=> 'Mark answer',
++ 	'MARK_ANSWER_CONFIRM'	=> 'Are you sure you want to mark this post as the best answer?',
++ 
++-	'TO_POST'	=> '<i class="fa fa-eye"></i> View Post',
++-	'TOPIC_FIRST_POST'	=> 'You cannot mark this post as the best answer as it is the first post of the topic.',
++ 	'TOTAL_ANSWERS'	=> 'Total answers',
++ 
++ 	'UNMARK_ANSWER'			=> 'Unmark answer',
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/language/en/permissions_bestanswer.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/language/en/permissions_bestanswer.php"
++index dc7241e0f..7211c9aa6 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/language/en/permissions_bestanswer.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/language/en/permissions_bestanswer.php"
++@@ -4,7 +4,7 @@
++  * Best Answer extension for the phpBB Forum Software package.
++  *
++  * @copyright (c) 2018, kinerity, https://www.layer-3.org/
++- * @copyright (c) 2019-2025, Leinad4Mind, https://leinad4mind.top/forum
+++ * @copyright (c) 2019-2021, Leinad4Mind, https://leinad4mind.top/forum
++  * @license GNU General Public License, version 2 (GPL-2.0)
++  *
++  */
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/language/fr/common.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/language/fr/common.php"
++index 194219b31..06e119ef7 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/language/fr/common.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/language/fr/common.php"
++@@ -4,7 +4,7 @@
++  * Best Answer extension for the phpBB Forum Software package.
++  *
++  * @copyright (c) 2018, kinerity, https://www.layer-3.org/
++- * @copyright (c) 2019-2025, Leinad4Mind, https://leinad4mind.top/forum
+++ * @copyright (c) 2019-2021, Leinad4Mind, https://leinad4mind.top/forum
++  * @translation (c) 2019 Galixte (http://www.galixte.com)
++  * @license GNU General Public License, version 2 (GPL-2.0)
++  *
++@@ -44,24 +44,23 @@ $lang = array_merge($lang, array(
++ 	'ANSWERED'		=> 'Répondue',
++ 	
++ 	'BEST_ANSWER'	=> 'Meilleure réponse',
++-	'BBPOINTS_ANSWER'			=> 'Nombre de BBPoints pour le message "Meilleure réponse"',
++-	'BBPOINTS_ANSWER_EXPLAIN'	=> 'Définissez le nombre de BBpoints à créditer à l’auteur du message lorsque son message dans ce forum est marqué comme "Meilleure réponse"',
+++	'BBPOINTS_ANSWER'			=> 'Nombre de BBpoints pour le message "Meilleure réponse"',
+++	'BBPOINTS_ANSWER_EXPLAIN'	=> 'Définissez le nombre de BBpoints à créditer à l\'auteur du message lorsque son message dans ce forum est marqué comme "Meilleure réponse"',
++ 
++ 	'ENABLE_ANSWER'			=> 'Activer les réponses les plus pertinentes',
++ 	'ENABLE_ANSWER_EXPLAIN'	=> 'Permet aux auteurs de sujets et aux modérateurs de mettre en avant un message comme étant la réponse la plus pertinente de son sujet.',
++-	'EXTENSION_NOT_ENABLED'			=> 'L’extension « Meilleure réponse » n’est pas activée sur ce forum.',
+++
+++	'TO_POST'	=> '<i class="fa fa-eye"></i> Se rendre au message',
++ 
++ 	'LOG_MARK_ANSWER'	=> '<strong>Mise en avant effectuée d’un message, comme étant la réponse la plus pertinente de son sujet</strong><br />» %1$s par %2$s',
++ 	'LOG_UNMARK_ANSWER'	=> '<strong>Mise en avant annulée d’un message, comme étant la réponse la plus pertinente de son sujet</strong><br />» %1$s par %2$s',
++ 
++-	'LOG_BBPOINTS_MARK_ANSWER'		=> '<strong>Ajout de BBPoints à l\'auteur pour la réponse la plus pertinente</strong><br />» %1$s par %2$s',
++-	'LOG_BBPOINTS_UNMARK_ANSWER'	=> '<strong>Suppression des BBPoints de l\'auteur pour la réponse la plus pertinente</strong><br />» %1$s par %2$s',
+++	'LOG_BBPOINTS_MARK_ANSWER'		=> '<strong>Ajout de bbpoints à l\'auteur pour la réponse la plus pertinente</strong><br />» %1$s par %2$s',
+++	'LOG_BBPOINTS_UNMARK_ANSWER'	=> '<strong>Suppression des bbpoints de l\'auteur pour la réponse la plus pertinente</strong><br />» %1$s par %2$s',
++ 
++ 	'MARK_ANSWER'			=> 'Mettre en avant ce message comme réponse la plus pertinente',
++ 	'MARK_ANSWER_CONFIRM'	=> 'Confirmer la mise en avant de ce message en tant que réponse la plus pertinente de son sujet.',
++ 
++-	'TO_POST'	=> '<i class="fa fa-eye"></i> Se rendre au message',
++-	'TOPIC_FIRST_POST'	=> 'Vous ne pouvez pas marquer cette réponse comme meilleure réponse, car il s’agit de la première réponse du sujet.',
++ 	'TOTAL_ANSWERS'	=> 'Réponses pertinentes',
++ 
++ 	'UNMARK_ANSWER'			=> 'Annuler la mise en avant de ce message comme réponse la plus pertinente',
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/language/fr/permissions_bestanswer.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/language/fr/permissions_bestanswer.php"
++index 36652d244..0e70bd06b 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/language/fr/permissions_bestanswer.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/language/fr/permissions_bestanswer.php"
++@@ -4,7 +4,7 @@
++  * Best Answer extension for the phpBB Forum Software package.
++  *
++  * @copyright (c) 2018, kinerity, https://www.layer-3.org/
++- * @copyright (c) 2019-2025, Leinad4Mind, https://leinad4mind.top/forum
+++ * @copyright (c) 2019-2021, Leinad4Mind, https://leinad4mind.top/forum
++  * @translation (c) 2019 Galixte (http://www.galixte.com)
++  * @license GNU General Public License, version 2 (GPL-2.0)
++  *
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/language/pt/common.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/language/pt/common.php"
++index 0fc8968c4..95991d9b1 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/language/pt/common.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/language/pt/common.php"
++@@ -4,7 +4,7 @@
++  * Best Answer extension for the phpBB Forum Software package.
++  *
++  * @copyright (c) 2018, kinerity, https://www.layer-3.org/
++- * @copyright (c) 2019-2025, Leinad4Mind, https://leinad4mind.top/forum
+++ * @copyright (c) 2019-2021, Leinad4Mind, https://leinad4mind.top/forum
++  * @license GNU General Public License, version 2 (GPL-2.0)
++  *
++  */
++@@ -48,7 +48,8 @@ $lang = array_merge($lang, array(
++ 
++ 	'ENABLE_ANSWER'			=> 'Activar Melhor Resposta',
++ 	'ENABLE_ANSWER_EXPLAIN'	=> 'If enabled, the topic starter (if permitted) and moderators (where allowed) will be able to mark a topic reply as the best answer.',
++-	'EXTENSION_NOT_ENABLED'			=> 'A extensão "Melhor Resposta" não está ativada neste fórum.',
+++
+++	'TO_POST'	=> '<i class="fa fa-eye"></i> Ver Mensagem',
++ 
++ 	'LOG_MARK_ANSWER'	=> '<strong>Mensagem marcada como Melhor Resposta</strong><br />» %1$s by %2$s',
++ 	'LOG_UNMARK_ANSWER'	=> '<strong>Mensagem deixou de ser a Melhor Resposta</strong><br />» %1$s by %2$s',
++@@ -59,8 +60,6 @@ $lang = array_merge($lang, array(
++ 	'MARK_ANSWER'			=> 'Marcar Melhor Resposta',
++ 	'MARK_ANSWER_CONFIRM'	=> 'Tens a certeza de que queres marcar esta mensagem como sendo a melhor resposta?',
++ 
++-	'TO_POST'	=> '<i class="fa fa-eye"></i> Ver Mensagem',
++-	'TOPIC_FIRST_POST'	=> 'Não é possível marcar esta mensagem como a melhor resposta, pois é a primeira mensagem do tópico.',
++ 	'TOTAL_ANSWERS'	=> 'Respostas totais',
++ 
++ 	'UNMARK_ANSWER'			=> 'Remover Melhor Resposta',
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/language/pt/permissions_bestanswer.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/language/pt/permissions_bestanswer.php"
++index 714c0934f..7a368e3f1 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/language/pt/permissions_bestanswer.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/language/pt/permissions_bestanswer.php"
++@@ -4,7 +4,7 @@
++  * Best Answer extension for the phpBB Forum Software package.
++  *
++  * @copyright (c) 2018, kinerity, https://www.layer-3.org/
++- * @copyright (c) 2019-2025, Leinad4Mind, https://leinad4mind.top/forum
+++ * @copyright (c) 2019-2021, Leinad4Mind, https://leinad4mind.top/forum
++  * @license GNU General Public License, version 2 (GPL-2.0)
++  *
++  */
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/language/pt-br/common.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/language/pt-br/common.php"
++deleted file mode 100644
++index 2c5c0d052..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/language/pt-br/common.php"
+++++ /dev/null
++@@ -1,73 +0,0 @@
++-<?php
++-/**
++- *
++- * Best Answer extension for the phpBB Forum Software package.
++- *
++- * @copyright (c) 2018, kinerity, https://www.layer-3.org/
++- * @copyright (c) 2019-2025, Leinad4Mind, https://leinad4mind.top/forum
++- * @license GNU General Public License, version 2 (GPL-2.0)
++- *
++- */
++-
++-/**
++- * DO NOT CHANGE
++- */
++-if (!defined('IN_PHPBB'))
++-{
++-	exit;
++-}
++-
++-if (empty($lang) || !is_array($lang))
++-{
++-	$lang = array();
++-}
++-
++-// DEVELOPERS PLEASE NOTE
++-//
++-// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
++-//
++-// Placeholders can now contain order information, e.g. instead of
++-// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
++-// translators to re-order the output of data while ensuring it remains correct
++-//
++-// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
++-// equally where a string contains only two placeholders which are used to wrap text
++-// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
++-//
++-// Some characters you may want to copy&paste:
++-// ’ » “ ” …
++-//
++-
++-$lang = array_merge($lang, array(
++-	'ANSWERS'		=> 'Respostas',
++-	'ANSWERED'		=> 'Respondidas',
++-	
++-	'BEST_ANSWER'	=> 'Melhor resposta',
++-	'BBPOINTS_ANSWER'			=> 'Quantidade de BBpoints para a postagem “Melhor resposta”',
++-	'BBPOINTS_ANSWER_EXPLAIN'	=> 'Defina o número de pontos BB a serem creditados ao autor da postagem quando sua postagem neste fórum for marcada como “Melhor resposta”',
++-
++-	'ENABLE_ANSWER'			=> 'Habilitar melhor resposta',
++-	'ENABLE_ANSWER_EXPLAIN'	=> 'Se ativado, o autor do tópico (se permitido) e os moderadores (onde permitido) poderão marcar uma resposta ao tópico como a melhor resposta.',
++-	'EXTENSION_NOT_ENABLED'			=> 'A extensão Melhor resposta não está ativada neste fórum.',
++-
++-	'LOG_MARK_ANSWER'	=> '<strong>Postagem marcada como melhor resposta</strong><br />» %1$s by %2$s',
++-	'LOG_UNMARK_ANSWER'	=> '<strong>Postagem desmarcada como melhor resposta</strong><br />» %1$s by %2$s',
++-
++-	'LOG_BBPOINTS_MARK_ANSWER'		=> '<strong>Adicionados bbpoints ao autor pela melhor resposta</strong><br />» %1$s by %2$s',
++-	'LOG_BBPOINTS_UNMARK_ANSWER'	=> '<strong>Removidos bbpoints ao autor por perder a melhor resposta</strong><br />» %1$s by %2$s',
++-
++-	'MARK_ANSWER'			=> 'Marcar resposta',
++-	'MARK_ANSWER_CONFIRM'	=> 'Tem certeza de que deseja marcar esta postagem como a melhor resposta?',
++-
++-	'TO_POST'	=> '<i class="fa fa-eye"></i> Ver postagem',
++-	'TOPIC_FIRST_POST'	=> 'Você não pode marcar esta postagem como a melhor resposta, pois é a primeira postagem do tópico.',
++-	'TOTAL_ANSWERS'	=> 'Total de respostas',
++-
++-	'UNMARK_ANSWER'			=> 'Desmarcar resposta',
++-	'UNMARK_ANSWER_CONFIRM'	=> 'Tem certeza de que deseja desmarcar esta postagem como a melhor resposta?',
++-
++-	'MARK_ANSWER_NOTIFICATION'			=> '%1$s marcou sua postagem no tópico “%2$s” como a melhor resposta.',
++-	'UNMARK_ANSWER_NOTIFICATION'		=> '%1$s desmarcou sua postagem no tópico “%2$s” como a melhor resposta.',
++-	'NOTIFICATION_TYPE_MARK_ANSWER'		=> 'Alguém marcou sua resposta no tópico como a melhor resposta',
++-	'NOTIFICATION_TYPE_UNMARK_ANSWER'	=> 'Alguém desmarcou sua resposta no tópico como a melhor resposta',
++-));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/language/pt-br/email/mark_mail.txt" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/language/pt-br/email/mark_mail.txt"
++deleted file mode 100644
++index 4c33d4c60..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/language/pt-br/email/mark_mail.txt"
+++++ /dev/null
++@@ -1,10 +0,0 @@
++-Subject: A tua mensagem foi marcada como sendo a melhor resposta
++-
++-Olá,
++-
++-a tua mensagem em "{{ TOPIC_TITLE }}" no "{{ SITENAME }}" foi marcada com sendo a melhor resposta por "{{ USERNAME }}".
++-
++-Para veres a tua mensagem clica no endereço seguinte:
++-{{ U_LINK_TO_TOPIC }}
++-
++-{{ EMAIL_SIG }}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/language/pt-br/email/unmark_mail.txt" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/language/pt-br/email/unmark_mail.txt"
++deleted file mode 100644
++index 62c0e8bf3..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/language/pt-br/email/unmark_mail.txt"
+++++ /dev/null
++@@ -1,10 +0,0 @@
++-Subject: A tua mensagem deixou de ser a melhor resposta
++-
++-Olá,
++-
++-Infelizmente a tua mensagem em "{{ TOPIC_TITLE }}" no "{{ SITENAME }}" deixou de ser a melhor resposta.
++-
++-Para veres a tua mensagem clica no endereço seguinte:
++-{{ U_LINK_TO_TOPIC }}
++-
++-{{ EMAIL_SIG }}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/language/pt-br/permissions_bestanswer.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/language/pt-br/permissions_bestanswer.php"
++deleted file mode 100644
++index 714c0934f..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/language/pt-br/permissions_bestanswer.php"
+++++ /dev/null
++@@ -1,44 +0,0 @@
++-<?php
++-/**
++- *
++- * Best Answer extension for the phpBB Forum Software package.
++- *
++- * @copyright (c) 2018, kinerity, https://www.layer-3.org/
++- * @copyright (c) 2019-2025, Leinad4Mind, https://leinad4mind.top/forum
++- * @license GNU General Public License, version 2 (GPL-2.0)
++- *
++- */
++-
++-/**
++- * DO NOT CHANGE
++- */
++-if (!defined('IN_PHPBB'))
++-{
++-	exit;
++-}
++-
++-if (empty($lang) || !is_array($lang))
++-{
++-	$lang = array();
++-}
++-
++-// DEVELOPERS PLEASE NOTE
++-//
++-// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
++-//
++-// Placeholders can now contain order information, e.g. instead of
++-// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
++-// translators to re-order the output of data while ensuring it remains correct
++-//
++-// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
++-// equally where a string contains only two placeholders which are used to wrap text
++-// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
++-//
++-// Some characters you may want to copy&paste:
++-// ’ » “ ” …
++-//
++-
++-$lang = array_merge($lang, array(
++-	'ACL_F_MARK_ANSWER' => 'Pode marcar mensagem como melhor resposta',
++-	'ACL_M_MARK_ANSWER' => 'Pode marcar mensagem como melhor resposta',
++-));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/language/pt_preao/common.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/language/pt_preao/common.php"
++index 50e269028..95991d9b1 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/language/pt_preao/common.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/language/pt_preao/common.php"
++@@ -4,7 +4,7 @@
++  * Best Answer extension for the phpBB Forum Software package.
++  *
++  * @copyright (c) 2018, kinerity, https://www.layer-3.org/
++- * @copyright (c) 2019-2025, Leinad4Mind, https://leinad4mind.top/forum
+++ * @copyright (c) 2019-2021, Leinad4Mind, https://leinad4mind.top/forum
++  * @license GNU General Public License, version 2 (GPL-2.0)
++  *
++  */
++@@ -48,7 +48,8 @@ $lang = array_merge($lang, array(
++ 
++ 	'ENABLE_ANSWER'			=> 'Activar Melhor Resposta',
++ 	'ENABLE_ANSWER_EXPLAIN'	=> 'If enabled, the topic starter (if permitted) and moderators (where allowed) will be able to mark a topic reply as the best answer.',
++-	'EXTENSION_NOT_ENABLED'			=> 'A extensão "Melhor Resposta" não está activada neste fórum.',
+++
+++	'TO_POST'	=> '<i class="fa fa-eye"></i> Ver Mensagem',
++ 
++ 	'LOG_MARK_ANSWER'	=> '<strong>Mensagem marcada como Melhor Resposta</strong><br />» %1$s by %2$s',
++ 	'LOG_UNMARK_ANSWER'	=> '<strong>Mensagem deixou de ser a Melhor Resposta</strong><br />» %1$s by %2$s',
++@@ -59,8 +60,6 @@ $lang = array_merge($lang, array(
++ 	'MARK_ANSWER'			=> 'Marcar Melhor Resposta',
++ 	'MARK_ANSWER_CONFIRM'	=> 'Tens a certeza de que queres marcar esta mensagem como sendo a melhor resposta?',
++ 
++-	'TO_POST'	=> '<i class="fa fa-eye"></i> Ver Mensagem',
++-	'TOPIC_FIRST_POST'	=> 'Não é possível marcar esta mensagem como a melhor resposta, pois é a primeira mensagem do tópico.',
++ 	'TOTAL_ANSWERS'	=> 'Respostas totais',
++ 
++ 	'UNMARK_ANSWER'			=> 'Remover Melhor Resposta',
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/language/pt_preao/permissions_bestanswer.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/language/pt_preao/permissions_bestanswer.php"
++index 714c0934f..7a368e3f1 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/language/pt_preao/permissions_bestanswer.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/language/pt_preao/permissions_bestanswer.php"
++@@ -4,7 +4,7 @@
++  * Best Answer extension for the phpBB Forum Software package.
++  *
++  * @copyright (c) 2018, kinerity, https://www.layer-3.org/
++- * @copyright (c) 2019-2025, Leinad4Mind, https://leinad4mind.top/forum
+++ * @copyright (c) 2019-2021, Leinad4Mind, https://leinad4mind.top/forum
++  * @license GNU General Public License, version 2 (GPL-2.0)
++  *
++  */
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/language/ru/common.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/language/ru/common.php"
++index f3ffca07b..61ae53f0c 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/language/ru/common.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/language/ru/common.php"
++@@ -4,7 +4,7 @@
++  * Best Answer extension for the phpBB Forum Software package.
++  *
++  * @copyright (c) 2018, kinerity, https://www.layer-3.org/
++- * @copyright (c) 2019-2025, Leinad4Mind, https://leinad4mind.top/forum
+++ * @copyright (c) 2019-2021, Leinad4Mind, https://leinad4mind.top/forum
++  * @translation (c) 2019 naoiphoenix
++  * @license GNU General Public License, version 2 (GPL-2.0)
++  *
++@@ -49,19 +49,18 @@ $lang = array_merge($lang, array(
++ 
++ 	'ENABLE_ANSWER'			=> 'Включить лучший ответ',
++ 	'ENABLE_ANSWER_EXPLAIN'	=> 'Если включено, автор темы (если разрешено) и модераторы разделов (где разрешено) будут способны отмечать ответ как лучший.',
++-	'EXTENSION_NOT_ENABLED'			=> 'Расширение «Лучший ответ» не включено на этом форуме.',
+++
+++	'TO_POST'	=> '<i class="fa fa-eye"></i> Перейти к полному ответу',
++ 
++ 	'LOG_MARK_ANSWER'	=> '<strong>Отмечено лучшим ответом</strong><br />» %1$s пользователем %2$s',
++ 	'LOG_UNMARK_ANSWER'	=> '<strong>Снята отметка лучшего ответа</strong><br />» %1$s пользователем %2$s',
++-	
+++
++ 	'LOG_BBPOINTS_MARK_ANSWER'		=> '<strong>Добавлены баллы автору за лучший ответ</strong><br />» %1$s от %2$s',
++ 	'LOG_BBPOINTS_UNMARK_ANSWER'	=> '<strong>Удалите баллы автора для лучшего ответа</strong><br />» %1$s от %2$s',
++-	
+++
++ 	'MARK_ANSWER'			=> 'Отметить ответ',
++ 	'MARK_ANSWER_CONFIRM'	=> 'Вы уверены, что хотите отметить этот ответ как лучший?',
++-	
++-	'TO_POST'	=> '<i class="fa fa-eye"></i> Перейти к полному ответу',
++-	'TOPIC_FIRST_POST'	=> 'Вы не можете отметить этот пост как лучший ответ, так как он является первым постом в теме.',
+++
++ 	'TOTAL_ANSWERS'	=> 'Всего ответов',
++ 
++ 	'UNMARK_ANSWER'			=> 'Снять отметку',
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/language/ru/permissions_bestanswer.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/language/ru/permissions_bestanswer.php"
++index a1edbb133..d97be6dc5 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/language/ru/permissions_bestanswer.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/language/ru/permissions_bestanswer.php"
++@@ -4,7 +4,7 @@
++  * Best Answer extension for the phpBB Forum Software package.
++  *
++  * @copyright (c) 2018, kinerity, https://www.layer-3.org/
++- * @copyright (c) 2019-2025, Leinad4Mind, https://leinad4mind.top/forum
+++ * @copyright (c) 2019-2021, Leinad4Mind, https://leinad4mind.top/forum
++  * @translation (c) 2019 naoiphoenix
++  * @license GNU General Public License, version 2 (GPL-2.0)
++  *
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/license.txt" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/license.txt"
++deleted file mode 100644
++index 30f3d3388..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/license.txt"
+++++ /dev/null
++@@ -1,280 +0,0 @@
++-			GNU GENERAL PUBLIC LICENSE
++-		       Version 2, June 1991
++-
++- Copyright (C) 1989, 1991 Free Software Foundation, Inc.
++-                          675 Mass Ave, Cambridge, MA 02139, USA
++- Everyone is permitted to copy and distribute verbatim copies
++- of this license document, but changing it is not allowed.
++-
++-			    Preamble
++-
++-  The licenses for most software are designed to take away your
++-freedom to share and change it.  By contrast, the GNU General Public
++-License is intended to guarantee your freedom to share and change free
++-software--to make sure the software is free for all its users.  This
++-General Public License applies to most of the Free Software
++-Foundation's software and to any other program whose authors commit to
++-using it.  (Some other Free Software Foundation software is covered by
++-the GNU Library General Public License instead.)  You can apply it to
++-your programs, too.
++-
++-  When we speak of free software, we are referring to freedom, not
++-price.  Our General Public Licenses are designed to make sure that you
++-have the freedom to distribute copies of free software (and charge for
++-this service if you wish), that you receive source code or can get it
++-if you want it, that you can change the software or use pieces of it
++-in new free programs; and that you know you can do these things.
++-
++-  To protect your rights, we need to make restrictions that forbid
++-anyone to deny you these rights or to ask you to surrender the rights.
++-These restrictions translate to certain responsibilities for you if you
++-distribute copies of the software, or if you modify it.
++-
++-  For example, if you distribute copies of such a program, whether
++-gratis or for a fee, you must give the recipients all the rights that
++-you have.  You must make sure that they, too, receive or can get the
++-source code.  And you must show them these terms so they know their
++-rights.
++-
++-  We protect your rights with two steps: (1) copyright the software, and
++-(2) offer you this license which gives you legal permission to copy,
++-distribute and/or modify the software.
++-
++-  Also, for each author's protection and ours, we want to make certain
++-that everyone understands that there is no warranty for this free
++-software.  If the software is modified by someone else and passed on, we
++-want its recipients to know that what they have is not the original, so
++-that any problems introduced by others will not reflect on the original
++-authors' reputations.
++-
++-  Finally, any free program is threatened constantly by software
++-patents.  We wish to avoid the danger that redistributors of a free
++-program will individually obtain patent licenses, in effect making the
++-program proprietary.  To prevent this, we have made it clear that any
++-patent must be licensed for everyone's free use or not licensed at all.
++-
++-  The precise terms and conditions for copying, distribution and
++-modification follow.
++-
++-		    GNU GENERAL PUBLIC LICENSE
++-   TERMS AND CONDITIONS FOR COPYING, DISTRIBUTION AND MODIFICATION
++-
++-  0. This License applies to any program or other work which contains
++-a notice placed by the copyright holder saying it may be distributed
++-under the terms of this General Public License.  The "Program", below,
++-refers to any such program or work, and a "work based on the Program"
++-means either the Program or any derivative work under copyright law:
++-that is to say, a work containing the Program or a portion of it,
++-either verbatim or with modifications and/or translated into another
++-language.  (Hereinafter, translation is included without limitation in
++-the term "modification".)  Each licensee is addressed as "you".
++-
++-Activities other than copying, distribution and modification are not
++-covered by this License; they are outside its scope.  The act of
++-running the Program is not restricted, and the output from the Program
++-is covered only if its contents constitute a work based on the
++-Program (independent of having been made by running the Program).
++-Whether that is true depends on what the Program does.
++-
++-  1. You may copy and distribute verbatim copies of the Program's
++-source code as you receive it, in any medium, provided that you
++-conspicuously and appropriately publish on each copy an appropriate
++-copyright notice and disclaimer of warranty; keep intact all the
++-notices that refer to this License and to the absence of any warranty;
++-and give any other recipients of the Program a copy of this License
++-along with the Program.
++-
++-You may charge a fee for the physical act of transferring a copy, and
++-you may at your option offer warranty protection in exchange for a fee.
++-
++-  2. You may modify your copy or copies of the Program or any portion
++-of it, thus forming a work based on the Program, and copy and
++-distribute such modifications or work under the terms of Section 1
++-above, provided that you also meet all of these conditions:
++-
++-    a) You must cause the modified files to carry prominent notices
++-    stating that you changed the files and the date of any change.
++-
++-    b) You must cause any work that you distribute or publish, that in
++-    whole or in part contains or is derived from the Program or any
++-    part thereof, to be licensed as a whole at no charge to all third
++-    parties under the terms of this License.
++-
++-    c) If the modified program normally reads commands interactively
++-    when run, you must cause it, when started running for such
++-    interactive use in the most ordinary way, to print or display an
++-    announcement including an appropriate copyright notice and a
++-    notice that there is no warranty (or else, saying that you provide
++-    a warranty) and that users may redistribute the program under
++-    these conditions, and telling the user how to view a copy of this
++-    License.  (Exception: if the Program itself is interactive but
++-    does not normally print such an announcement, your work based on
++-    the Program is not required to print an announcement.)
++-
++-These requirements apply to the modified work as a whole.  If
++-identifiable sections of that work are not derived from the Program,
++-and can be reasonably considered independent and separate works in
++-themselves, then this License, and its terms, do not apply to those
++-sections when you distribute them as separate works.  But when you
++-distribute the same sections as part of a whole which is a work based
++-on the Program, the distribution of the whole must be on the terms of
++-this License, whose permissions for other licensees extend to the
++-entire whole, and thus to each and every part regardless of who wrote it.
++-
++-Thus, it is not the intent of this section to claim rights or contest
++-your rights to work written entirely by you; rather, the intent is to
++-exercise the right to control the distribution of derivative or
++-collective works based on the Program.
++-
++-In addition, mere aggregation of another work not based on the Program
++-with the Program (or with a work based on the Program) on a volume of
++-a storage or distribution medium does not bring the other work under
++-the scope of this License.
++-
++-  3. You may copy and distribute the Program (or a work based on it,
++-under Section 2) in object code or executable form under the terms of
++-Sections 1 and 2 above provided that you also do one of the following:
++-
++-    a) Accompany it with the complete corresponding machine-readable
++-    source code, which must be distributed under the terms of Sections
++-    1 and 2 above on a medium customarily used for software interchange; or,
++-
++-    b) Accompany it with a written offer, valid for at least three
++-    years, to give any third party, for a charge no more than your
++-    cost of physically performing source distribution, a complete
++-    machine-readable copy of the corresponding source code, to be
++-    distributed under the terms of Sections 1 and 2 above on a medium
++-    customarily used for software interchange; or,
++-
++-    c) Accompany it with the information you received as to the offer
++-    to distribute corresponding source code.  (This alternative is
++-    allowed only for noncommercial distribution and only if you
++-    received the program in object code or executable form with such
++-    an offer, in accord with Subsection b above.)
++-
++-The source code for a work means the preferred form of the work for
++-making modifications to it.  For an executable work, complete source
++-code means all the source code for all modules it contains, plus any
++-associated interface definition files, plus the scripts used to
++-control compilation and installation of the executable.  However, as a
++-special exception, the source code distributed need not include
++-anything that is normally distributed (in either source or binary
++-form) with the major components (compiler, kernel, and so on) of the
++-operating system on which the executable runs, unless that component
++-itself accompanies the executable.
++-
++-If distribution of executable or object code is made by offering
++-access to copy from a designated place, then offering equivalent
++-access to copy the source code from the same place counts as
++-distribution of the source code, even though third parties are not
++-compelled to copy the source along with the object code.
++-
++-  4. You may not copy, modify, sublicense, or distribute the Program
++-except as expressly provided under this License.  Any attempt
++-otherwise to copy, modify, sublicense or distribute the Program is
++-void, and will automatically terminate your rights under this License.
++-However, parties who have received copies, or rights, from you under
++-this License will not have their licenses terminated so long as such
++-parties remain in full compliance.
++-
++-  5. You are not required to accept this License, since you have not
++-signed it.  However, nothing else grants you permission to modify or
++-distribute the Program or its derivative works.  These actions are
++-prohibited by law if you do not accept this License.  Therefore, by
++-modifying or distributing the Program (or any work based on the
++-Program), you indicate your acceptance of this License to do so, and
++-all its terms and conditions for copying, distributing or modifying
++-the Program or works based on it.
++-
++-  6. Each time you redistribute the Program (or any work based on the
++-Program), the recipient automatically receives a license from the
++-original licensor to copy, distribute or modify the Program subject to
++-these terms and conditions.  You may not impose any further
++-restrictions on the recipients' exercise of the rights granted herein.
++-You are not responsible for enforcing compliance by third parties to
++-this License.
++-
++-  7. If, as a consequence of a court judgment or allegation of patent
++-infringement or for any other reason (not limited to patent issues),
++-conditions are imposed on you (whether by court order, agreement or
++-otherwise) that contradict the conditions of this License, they do not
++-excuse you from the conditions of this License.  If you cannot
++-distribute so as to satisfy simultaneously your obligations under this
++-License and any other pertinent obligations, then as a consequence you
++-may not distribute the Program at all.  For example, if a patent
++-license would not permit royalty-free redistribution of the Program by
++-all those who receive copies directly or indirectly through you, then
++-the only way you could satisfy both it and this License would be to
++-refrain entirely from distribution of the Program.
++-
++-If any portion of this section is held invalid or unenforceable under
++-any particular circumstance, the balance of the section is intended to
++-apply and the section as a whole is intended to apply in other
++-circumstances.
++-
++-It is not the purpose of this section to induce you to infringe any
++-patents or other property right claims or to contest validity of any
++-such claims; this section has the sole purpose of protecting the
++-integrity of the free software distribution system, which is
++-implemented by public license practices.  Many people have made
++-generous contributions to the wide range of software distributed
++-through that system in reliance on consistent application of that
++-system; it is up to the author/donor to decide if he or she is willing
++-to distribute software through any other system and a licensee cannot
++-impose that choice.
++-
++-This section is intended to make thoroughly clear what is believed to
++-be a consequence of the rest of this License.
++-
++-  8. If the distribution and/or use of the Program is restricted in
++-certain countries either by patents or by copyrighted interfaces, the
++-original copyright holder who places the Program under this License
++-may add an explicit geographical distribution limitation excluding
++-those countries, so that distribution is permitted only in or among
++-countries not thus excluded.  In such case, this License incorporates
++-the limitation as if written in the body of this License.
++-
++-  9. The Free Software Foundation may publish revised and/or new versions
++-of the General Public License from time to time.  Such new versions will
++-be similar in spirit to the present version, but may differ in detail to
++-address new problems or concerns.
++-
++-Each version is given a distinguishing version number.  If the Program
++-specifies a version number of this License which applies to it and "any
++-later version", you have the option of following the terms and conditions
++-either of that version or of any later version published by the Free
++-Software Foundation.  If the Program does not specify a version number of
++-this License, you may choose any version ever published by the Free Software
++-Foundation.
++-
++-  10. If you wish to incorporate parts of the Program into other free
++-programs whose distribution conditions are different, write to the author
++-to ask for permission.  For software which is copyrighted by the Free
++-Software Foundation, write to the Free Software Foundation; we sometimes
++-make exceptions for this.  Our decision will be guided by the two goals
++-of preserving the free status of all derivatives of our free software and
++-of promoting the sharing and reuse of software generally.
++-
++-			    NO WARRANTY
++-
++-  11. BECAUSE THE PROGRAM IS LICENSED FREE OF CHARGE, THERE IS NO WARRANTY
++-FOR THE PROGRAM, TO THE EXTENT PERMITTED BY APPLICABLE LAW.  EXCEPT WHEN
++-OTHERWISE STATED IN WRITING THE COPYRIGHT HOLDERS AND/OR OTHER PARTIES
++-PROVIDE THE PROGRAM "AS IS" WITHOUT WARRANTY OF ANY KIND, EITHER EXPRESSED
++-OR IMPLIED, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF
++-MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE.  THE ENTIRE RISK AS
++-TO THE QUALITY AND PERFORMANCE OF THE PROGRAM IS WITH YOU.  SHOULD THE
++-PROGRAM PROVE DEFECTIVE, YOU ASSUME THE COST OF ALL NECESSARY SERVICING,
++-REPAIR OR CORRECTION.
++-
++-  12. IN NO EVENT UNLESS REQUIRED BY APPLICABLE LAW OR AGREED TO IN WRITING
++-WILL ANY COPYRIGHT HOLDER, OR ANY OTHER PARTY WHO MAY MODIFY AND/OR
++-REDISTRIBUTE THE PROGRAM AS PERMITTED ABOVE, BE LIABLE TO YOU FOR DAMAGES,
++-INCLUDING ANY GENERAL, SPECIAL, INCIDENTAL OR CONSEQUENTIAL DAMAGES ARISING
++-OUT OF THE USE OR INABILITY TO USE THE PROGRAM (INCLUDING BUT NOT LIMITED
++-TO LOSS OF DATA OR DATA BEING RENDERED INACCURATE OR LOSSES SUSTAINED BY
++-YOU OR THIRD PARTIES OR A FAILURE OF THE PROGRAM TO OPERATE WITH ANY OTHER
++-PROGRAMS), EVEN IF SUCH HOLDER OR OTHER PARTY HAS BEEN ADVISED OF THE
++-POSSIBILITY OF SUCH DAMAGES.
++-
++-		     END OF TERMS AND CONDITIONS
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/migrations/v10x/release_0_0_1.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/migrations/v10x/release_0_0_1.php"
++index abb21c74f..929fb78f7 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/migrations/v10x/release_0_0_1.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/migrations/v10x/release_0_0_1.php"
++@@ -4,7 +4,7 @@
++  * Best Answer extension for the phpBB Forum Software package.
++  *
++  * @copyright (c) 2018, kinerity, https://www.layer-3.org/
++- * @copyright (c) 2019-2025, Leinad4Mind, https://leinad4mind.top/forum
+++ * @copyright (c) 2019-2021, Leinad4Mind, https://leinad4mind.top/forum
++  * @license GNU General Public License, version 2 (GPL-2.0)
++  *
++  */
++@@ -18,23 +18,11 @@ class release_0_0_1 extends \phpbb\db\migration\container_aware_migration
++ 		return $this->db_tools->sql_column_exists($this->table_prefix . 'forums', 'enable_answer');
++ 	}
++ 
++-	/**
++-	 * Assign migration file dependencies for this migration
++-	 *
++-	 * @return void
++-	 * @access public
++-	 */
++ 	static public function depends_on()
++ 	{
++ 		return array('\phpbb\db\migration\data\v320\v320');
++ 	}
++ 
++-	/**
++-	 * Add or update schema in the database
++-	 *
++-	 * @return array Array of table schema
++-	 * @access public
++-	 */
++ 	public function update_schema()
++ 	{
++ 		return array(
++@@ -55,12 +43,6 @@ class release_0_0_1 extends \phpbb\db\migration\container_aware_migration
++ 		);
++ 	}
++ 
++-	/**
++-	 * Add or update data in the database
++-	 *
++-	 * @return array Array of table data
++-	 * @access public
++-	 */
++ 	public function update_data()
++ 	{
++ 		$data = array(
++@@ -92,12 +74,6 @@ class release_0_0_1 extends \phpbb\db\migration\container_aware_migration
++ 		return $data;
++ 	}
++ 
++-	/**
++-	 * Drop schema in the database
++-	 *
++-	 * @return array Array of table schema
++-	 * @access public
++-	 */
++ 	public function revert_schema()
++ 	{
++ 		return array(
++@@ -120,9 +96,6 @@ class release_0_0_1 extends \phpbb\db\migration\container_aware_migration
++ 
++ 	/**
++ 	 * Custom function query permission roles
++-	 *
++-	 * @return void
++-	 * @access public
++ 	 */
++ 	private function role_exists($role)
++ 	{
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/migrations/v10x/release_0_1_0.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/migrations/v10x/release_0_1_0.php"
++index 1196663f0..e0f25ed6d 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/migrations/v10x/release_0_1_0.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/migrations/v10x/release_0_1_0.php"
++@@ -3,7 +3,7 @@
++  *
++  * Best Answer extension for the phpBB Forum Software package.
++  *
++- * @copyright (c) 2019-2025, Leinad4Mind, https://leinad4mind.top/forum
+++ * @copyright (c) 2019-2021, Leinad4Mind, https://leinad4mind.top/forum
++  * @license GNU General Public License, version 2 (GPL-2.0)
++  *
++  */
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/notification/type/markanswer.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/notification/type/markanswer.php"
++index 8cb1cb7b9..37b9e65f2 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/notification/type/markanswer.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/notification/type/markanswer.php"
++@@ -4,7 +4,7 @@
++  * Best Answer extension for the phpBB Forum Software package.
++  *
++  * @copyright (c) 2018, kinerity, https://www.layer-3.org/
++- * @copyright (c) 2019-2025, Leinad4Mind, https://leinad4mind.top/forum
+++ * @copyright (c) 2019-2021, Leinad4Mind, https://leinad4mind.top/forum
++  * @license GNU General Public License, version 2 (GPL-2.0)
++  *
++  */
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/notification/type/unmarkanswer.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/notification/type/unmarkanswer.php"
++index 41784cdcd..55463bab4 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/notification/type/unmarkanswer.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/notification/type/unmarkanswer.php"
++@@ -4,7 +4,7 @@
++  * Best Answer extension for the phpBB Forum Software package.
++  *
++  * @copyright (c) 2018, kinerity, https://www.layer-3.org/
++- * @copyright (c) 2019-2025, Leinad4Mind, https://leinad4mind.top/forum
+++ * @copyright (c) 2019-2021, Leinad4Mind, https://leinad4mind.top/forum
++  * @license GNU General Public License, version 2 (GPL-2.0)
++  *
++  */
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/styles/prosilver/template/event/mcp_topic_postrow_attachments_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/styles/prosilver/template/event/mcp_topic_postrow_attachments_after.html"
++index c4ff70abe..ef6990230 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/styles/prosilver/template/event/mcp_topic_postrow_attachments_after.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/styles/prosilver/template/event/mcp_topic_postrow_attachments_after.html"
++@@ -1,5 +1,5 @@
++ {% if postrow.S_FIRST_POST and postrow.ANSWER_POST_ID %}
++-<div class="postbody post_answer{% if S_NIGHTSTAKLER_ENABLED %}-dark{% endif %}"><i class="icon fa-check fa-fw icon-green" aria-hidden="true"></i><span class="author">{{ lang('POST_BY_AUTHOR') }} {{ postrow.ANSWER_USERNAME_FULL }} &raquo; {{ postrow.ANSWER_POST_TIME }}</span>
+++<div class="postbody post_answer"><i class="icon fa-check fa-fw icon-green" aria-hidden="true"></i><span class="author">{{ lang('POST_BY_AUTHOR') }} {{ postrow.ANSWER_USERNAME_FULL }} &raquo; {{ postrow.ANSWER_POST_TIME }}</span>
++ <div class="content">{{ postrow.ANSWER_POST_TEXT }}</div>
++ <a href="{{ postrow.U_ANSWER }}">{{ lang('TO_POST') }}</a></div>
++ {% endif %}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/styles/prosilver/template/event/mcp_topic_postrow_post_after.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/styles/prosilver/template/event/mcp_topic_postrow_post_after.html"
++deleted file mode 100644
++index bf9d5b984..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/styles/prosilver/template/event/mcp_topic_postrow_post_after.html"
+++++ /dev/null
++@@ -1,3 +0,0 @@
++-{% if postrow.POST_ID == postrow.ANSWER_POST_ID %}
++-	</div>
++-{% endif %} 
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/styles/prosilver/template/event/mcp_topic_postrow_post_before.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/styles/prosilver/template/event/mcp_topic_postrow_post_before.html"
++index 00aaa8735..6d95262ad 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/styles/prosilver/template/event/mcp_topic_postrow_post_before.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/styles/prosilver/template/event/mcp_topic_postrow_post_before.html"
++@@ -1,4 +1,3 @@
++ {% if postrow.POST_ID == postrow.ANSWER_POST_ID %}
++ <div class="answer hidden"></div>
++-	<div class="answer-post{% if S_NIGHTSTAKLER_ENABLED %}-dark{% endif %}">
++ {% endif %}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/styles/prosilver/template/event/memberlist_view_user_statistics_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/styles/prosilver/template/event/memberlist_view_user_statistics_after.html"
++index 6ba4564eb..3d9745583 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/styles/prosilver/template/event/memberlist_view_user_statistics_after.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/styles/prosilver/template/event/memberlist_view_user_statistics_after.html"
++@@ -2,7 +2,7 @@
++ {% INCLUDEJS '@leinad4mind_bestanswer/jxtools.js' %}
++ 
++ <div id="list_inner_hidden_container_1" jxdom-closest="div.column2" jxdom-find="dd:nth-of-type({%if S_WARNINGS %}4{% else %}3{% endif %})" jxdom-action="after" >
++-<dt>{{ lang('TOTAL_ANSWERS') ~ lang('COLON') }}</dt>
+++<dt>{{ lang('TOTAL_ANSWERS') }}{{ lang('COLON') }}</dt>
++ <dd>{{ ANSWERS }}</dd>
++ </div>
++ {% endif %}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/styles/prosilver/template/event/search_results_topic_title_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/styles/prosilver/template/event/search_results_topic_title_after.html"
++index 31936188b..44f9c7e60 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/styles/prosilver/template/event/search_results_topic_title_after.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/styles/prosilver/template/event/search_results_topic_title_after.html"
++@@ -4,6 +4,6 @@
++ 		{% DEFINE INCLUDED_JXTOOLSJS = true %}
++ 	{% endif %}
++ <div id="list_inner_hidden_container_1" jxdom-closest="dl.postprofile" jxdom-find="dd:nth-of-type(3)" jxdom-action="replace" >
++-<dd>{{ lang('TOPIC') ~ lang('COLON') }} <i class="icon fa-check fa-fw icon-green" aria-hidden="true"></i> <a href="{{ searchresults.U_VIEW_TOPIC }}">{{ searchresults.TOPIC_TITLE }}</a></dd>
+++<dd>{{ lang('TOPIC') }}{{ lang('COLON') }} <i class="icon fa-check fa-fw icon-green" aria-hidden="true"></i> <a href="{{ searchresults.U_VIEW_TOPIC }}">{{ searchresults.TOPIC_TITLE }}</a></dd>
++ </div>
++ {% endif %}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/styles/prosilver/template/event/ucp_pm_viewmessage_custom_fields_before.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/styles/prosilver/template/event/ucp_pm_viewmessage_custom_fields_before.html"
++index cf03487d3..6aff1f63a 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/styles/prosilver/template/event/ucp_pm_viewmessage_custom_fields_before.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/styles/prosilver/template/event/ucp_pm_viewmessage_custom_fields_before.html"
++@@ -2,6 +2,6 @@
++ {% INCLUDEJS '@leinad4mind_bestanswer/jxtools.js' %}
++ 
++ <dd id="list_inner_hidden_container_{{ MESSAGE_ID }}" jxdom-closest="dl.postprofile" jxdom-find="dd.profile-joined" jxdom-action="before" >
++-<div class="profile-answers"><strong>{{ lang('ANSWERS') ~ lang('COLON') }}</strong> {{ AUTHOR_ANSWERS }}</div>
+++<div class="profile-answers"><strong>{{ lang('ANSWERS') }}{{ lang('COLON') }}</strong> {{ AUTHOR_ANSWERS }}</div>
++ </dd>
++ {% endif %}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/styles/prosilver/template/event/viewtopic_body_postrow_custom_fields_before.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/styles/prosilver/template/event/viewtopic_body_postrow_custom_fields_before.html"
++index b3003771e..3c4fa7844 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/styles/prosilver/template/event/viewtopic_body_postrow_custom_fields_before.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/styles/prosilver/template/event/viewtopic_body_postrow_custom_fields_before.html"
++@@ -2,6 +2,6 @@
++ {% INCLUDEJS '@leinad4mind_bestanswer/jxtools.js' %}
++ 
++ <dd id="list_inner_hidden_container_{{ postrow.POST_ID }}" jxdom-closest="dl.postprofile" jxdom-find="dd.profile-joined" jxdom-action="before" >
++-<div class="profile-answers"><strong>{{ lang('ANSWERS') ~ lang('COLON') }}</strong> {{ postrow.POSTER_ANSWERS }}</div>
+++<div class="profile-answers"><strong>{{ lang('ANSWERS') }}{{ lang('COLON') }}</strong> {{ postrow.POSTER_ANSWERS }}</div>
++ </dd>
++ {% endif %}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/styles/prosilver/template/event/viewtopic_body_postrow_post_after.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/styles/prosilver/template/event/viewtopic_body_postrow_post_after.html"
++deleted file mode 100644
++index 9c1684e7e..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/styles/prosilver/template/event/viewtopic_body_postrow_post_after.html"
+++++ /dev/null
++@@ -1,3 +0,0 @@
++-{% if postrow.POST_ID == postrow.ANSWER_POST_ID %}
++-	</div>
++-{% endif %}
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/styles/prosilver/template/event/viewtopic_body_postrow_post_before.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/styles/prosilver/template/event/viewtopic_body_postrow_post_before.html"
++index 00aaa8735..6d95262ad 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/styles/prosilver/template/event/viewtopic_body_postrow_post_before.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/styles/prosilver/template/event/viewtopic_body_postrow_post_before.html"
++@@ -1,4 +1,3 @@
++ {% if postrow.POST_ID == postrow.ANSWER_POST_ID %}
++ <div class="answer hidden"></div>
++-	<div class="answer-post{% if S_NIGHTSTAKLER_ENABLED %}-dark{% endif %}">
++ {% endif %}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/styles/prosilver/template/event/viewtopic_body_postrow_post_notices_before.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/styles/prosilver/template/event/viewtopic_body_postrow_post_notices_before.html"
++index c4ff70abe..ef6990230 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\bestanswer/styles/prosilver/template/event/viewtopic_body_postrow_post_notices_before.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\bestanswer/styles/prosilver/template/event/viewtopic_body_postrow_post_notices_before.html"
++@@ -1,5 +1,5 @@
++ {% if postrow.S_FIRST_POST and postrow.ANSWER_POST_ID %}
++-<div class="postbody post_answer{% if S_NIGHTSTAKLER_ENABLED %}-dark{% endif %}"><i class="icon fa-check fa-fw icon-green" aria-hidden="true"></i><span class="author">{{ lang('POST_BY_AUTHOR') }} {{ postrow.ANSWER_USERNAME_FULL }} &raquo; {{ postrow.ANS
\ No newline at end of file
diff --git "[ORIGINAL]/leinad4mind\\bestanswer/event/main_listener.php" "[FORUM_EXT]/leinad4mind\\bestanswer/event/main_listener.php"
--- "[ORIGINAL]/leinad4mind\\bestanswer/event/main_listener.php"
+++ "[FORUM_EXT]/leinad4mind\\bestanswer/event/main_listener.php"
@@ -4,7 +4,7 @@
  * Best Answer extension for the phpBB Forum Software package.
  *
  * @copyright (c) 2018, kinerity, https://www.layer-3.org/
- * @copyright (c) 2019-2025, Leinad4Mind, https://leinad4mind.top/forum
+ * @copyright (c) 2019-2021, Leinad4Mind, https://leinad4mind.top/forum
  * @license GNU General Public License, version 2 (GPL-2.0)
  *
  */
@@ -184,7 +184,6 @@ class main_listener implements EventSubscriberInterface
 			WHERE ' . $this->db->sql_in_set('topic_id', $topic_ids) . '
 				AND answer_post_id <> 0';
 		$result = $this->db->sql_query($sql);
-
 		while ($row = $this->db->sql_fetchrow($result))
 		{
 			if (in_array($row['answer_post_id'], $post_ids))
@@ -201,9 +200,9 @@ class main_listener implements EventSubscriberInterface
 			'answer_user_id'	=> 0,
 		);
 
-		if (!empty($answer_post_ids))
+		if ($answer_post_ids)
 		{
-			// Remove BBPoints
+			// remove bbpoints
 			$sql = 'DELETE FROM ' . $this->bbpoints_table . ' WHERE
 			' . $this->db->sql_in_set('to_id', $answer_user_ids) . ' AND '.$this->db->sql_in_set('reason', $answer_bbpoints_ids);
 			$this->db->sql_query($sql);
@@ -213,7 +212,7 @@ class main_listener implements EventSubscriberInterface
 			$this->db->sql_query($sql);
 		}
 
-		if (!empty($answer_user_ids))
+		if ($answer_user_ids)
 		{
 			$sql = 'UPDATE ' . USERS_TABLE . '
 				SET user_answers = user_answers - 1
@@ -237,7 +236,7 @@ class main_listener implements EventSubscriberInterface
 		}
 		$this->db->sql_freeresult($result);
 
-		if (!empty($answer_user_ids))
+		if ($answer_user_ids)
 		{
 			$sql = 'UPDATE ' . USERS_TABLE . '
 				SET user_answers = user_answers - 1
@@ -271,16 +270,16 @@ class main_listener implements EventSubscriberInterface
 	{
 		$sql_ary = $event['sql_ary'];
 
-		$sql_ary['SELECT'] .= ', ba_t.answer_post_id';
+		$sql_ary['SELECT'] .= ', a_t.answer_post_id';
 
 		$sql_ary['LEFT_JOIN'][] = array(
-			'FROM'	=> array(POSTS_TABLE => 'ba_p'),
-			'ON'	=> 'f.forum_last_post_id = ba_p.post_id',
+			'FROM'	=> array(POSTS_TABLE => 'a_p'),
+			'ON'	=> 'f.forum_last_post_id = a_p.post_id',
 		);
 
 		$sql_ary['LEFT_JOIN'][] = array(
-			'FROM'	=> array(TOPICS_TABLE => 'ba_t'),
-			'ON'	=> 'ba_t.topic_id = ba_p.topic_id',
+			'FROM'	=> array(TOPICS_TABLE => 'a_t'),
+			'ON'	=> 'a_t.topic_id = a_p.topic_id',
 		);
 
 		$event['sql_ary'] = $sql_ary;
@@ -374,7 +373,7 @@ class main_listener implements EventSubscriberInterface
 		$topic_info = $event['topic_info'];
 
 		// Does the topic have a best answer and is the post the first post in a topic
-		if (!empty($this->answer) && ($topic_info['topic_first_post_id'] == $row['post_id']))
+		if ($this->answer && ($topic_info['topic_first_post_id'] == $row['post_id']))
 		{
 			$post_row = array_merge($post_row, array(
 				'U_ANSWER'	=> append_sid("{$this->root_path}viewtopic.{$this->php_ext}", 'p=' . (int) $topic_info['answer_post_id'] . '#p' . (int) $topic_info['answer_post_id']),
@@ -416,7 +415,7 @@ class main_listener implements EventSubscriberInterface
 	public function modify_topicrow_tpl_ary($event)
 	{
 		$block = $event['topic_row'] ? 'topic_row' : 'tpl_ary';
-		$event[$block] = $this->display_topic_answered($event['row'], $event[$block]);
+		$event[$block] = $this->modify_topicrow_tpl($event['row'], $event[$block]);
 	}
 
 	public function permissions($event)
@@ -584,7 +583,7 @@ class main_listener implements EventSubscriberInterface
 		));
 
 		// Only add to post_row array if an answer_post_id is supplied and the post_id is the first post in a topic
-		if (!empty($this->answer) && ($topic_data['topic_first_post_id'] == $row['post_id']))
+		if ($this->answer && ($topic_data['topic_first_post_id'] == $row['post_id']))
 		{
 			$post_row = array_merge($post_row, array(
 				'ANSWER_POST_TEXT'		=> $this->answer['POST_TEXT'],
@@ -596,7 +595,7 @@ class main_listener implements EventSubscriberInterface
 		$event['post_row'] = $post_row;
 	}
 
-	private function display_topic_answered($row, $block)
+	private function modify_topicrow_tpl($row, $block)
 	{
 		$block = array_merge($block, array(
 			'S_ANSWERED'	=> $row['answer_post_id'] ? true : false,
diff --git "[ORIGINAL]/leinad4mind\\bestanswer/ext.php" "[FORUM_EXT]/leinad4mind\\bestanswer/ext.php"
--- "[ORIGINAL]/leinad4mind\\bestanswer/ext.php"
+++ "[FORUM_EXT]/leinad4mind\\bestanswer/ext.php"
@@ -4,7 +4,7 @@
  * Best Answer extension for the phpBB Forum Software package.
  *
  * @copyright (c) 2018, kinerity, https://www.layer-3.org/
- * @copyright (c) 2019-2025, Leinad4Mind, https://leinad4mind.top/forum
+ * @copyright (c) 2019-2021, Leinad4Mind, https://leinad4mind.top/forum
  * @license GNU General Public License, version 2 (GPL-2.0)
  *
  */
diff --git "[ORIGINAL]/leinad4mind\\bestanswer/language/ar/common.php" "[FORUM_EXT]/leinad4mind\\bestanswer/language/ar/common.php"
--- "[ORIGINAL]/leinad4mind\\bestanswer/language/ar/common.php"
+++ "[FORUM_EXT]/leinad4mind\\bestanswer/language/ar/common.php"
@@ -4,7 +4,7 @@
  * Best Answer extension for the phpBB Forum Software package.
  *
  * @copyright (c) 2018, kinerity, https://www.layer-3.org/
- * @copyright (c) 2019-2025, Leinad4Mind, https://leinad4mind.top/forum
+ * @copyright (c) 2019-2021, Leinad4Mind, https://leinad4mind.top/forum
  * @translation (c) 2019 Bassel Taha Alhitary, http://www.alhitary.net
  * @license GNU General Public License, version 2 (GPL-2.0)
  * 
@@ -49,7 +49,8 @@ $lang = array_merge($lang, array(
 
 	'ENABLE_ANSWER'			=> 'تفعيل “أفضل إجابة”',
 	'ENABLE_ANSWER_EXPLAIN'	=> 'عند اختيارك “نعم”, كاتب الموضوع (إذا لديه الترخيص) والمشرفين (بالمنتديات المسموح بها) يستطيعون إضافة علامة “أفضل إجابة” إلى أحد ردود الموضوع',
-	'EXTENSION_NOT_ENABLED'			=> 'ملحق ”أفضل إجابة“ غير ممكّن في هذا المنتدى.',
+
+	'TO_POST'	=> '<i class="fa fa-eye"></i> الذهاب إلى المشاركة',
 
 	'LOG_MARK_ANSWER'	=> '<strong>تحديد المشاركة كـ “أفضل إجابة”</strong><br />» %1$s بواسطة %2$s',
 	'LOG_UNMARK_ANSWER'	=> '<strong>إلغاء تحديد المشاركة كـ “أفضل إجابة”</strong><br />» %1$s بواسطة %2$s',
@@ -60,8 +61,6 @@ $lang = array_merge($lang, array(
 	'MARK_ANSWER'			=> 'تحديد الإجابة الأفضل',
 	'MARK_ANSWER_CONFIRM'	=> 'متأكد أنك تريد تحديد هذه المشاركة كأفضل إجابة؟',
 
-	'TO_POST'	=> '<i class="fa fa-eye"></i> الذهاب إلى المشاركة',
-	'TOPIC_FIRST_POST'	=> 'لا يمكنك وضع علامة على هذا المنشور كأفضل إجابة لأنه المنشور الأول في الموضوع.', 
 	'TOTAL_ANSWERS'	=> 'إجمالي الإجابات',
 
 	'UNMARK_ANSWER'			=> 'إلغاء تحديد الإجابة الأفضل',
diff --git "[ORIGINAL]/leinad4mind\\bestanswer/language/ar/permissions_bestanswer.php" "[FORUM_EXT]/leinad4mind\\bestanswer/language/ar/permissions_bestanswer.php"
--- "[ORIGINAL]/leinad4mind\\bestanswer/language/ar/permissions_bestanswer.php"
+++ "[FORUM_EXT]/leinad4mind\\bestanswer/language/ar/permissions_bestanswer.php"
@@ -4,7 +4,7 @@
  * Best Answer extension for the phpBB Forum Software package.
  *
  * @copyright (c) 2018, kinerity, https://www.layer-3.org/
- * @copyright (c) 2019-2025, Leinad4Mind, https://leinad4mind.top/forum
+ * @copyright (c) 2019-2021, Leinad4Mind, https://leinad4mind.top/forum
  * @translation (c) 2019 Bassel Taha Alhitary, http://www.alhitary.net
  * @license GNU General Public License, version 2 (GPL-2.0)
  *
diff --git "[ORIGINAL]/leinad4mind\\bestanswer/language/en/common.php" "[FORUM_EXT]/leinad4mind\\bestanswer/language/en/common.php"
--- "[ORIGINAL]/leinad4mind\\bestanswer/language/en/common.php"
+++ "[FORUM_EXT]/leinad4mind\\bestanswer/language/en/common.php"
@@ -4,7 +4,7 @@
  * Best Answer extension for the phpBB Forum Software package.
  *
  * @copyright (c) 2018, kinerity, https://www.layer-3.org/
- * @copyright (c) 2019-2025, Leinad4Mind, https://leinad4mind.top/forum
+ * @copyright (c) 2019-2021, Leinad4Mind, https://leinad4mind.top/forum
  * @license GNU General Public License, version 2 (GPL-2.0)
  *
  */
@@ -43,24 +43,23 @@ $lang = array_merge($lang, array(
 	'ANSWERED'		=> 'Answered',
 	
 	'BEST_ANSWER'	=> 'Best answer',
-	'BBPOINTS_ANSWER'			=> 'Amount of BBPoints for "Best Answer" post',
-	'BBPOINTS_ANSWER_EXPLAIN'	=> 'Set the number of BBPoints to be credited to post author when his post in this forum is marked as "Best Answer"',
+	'BBPOINTS_ANSWER'			=> 'Amount of BBpoints for "Best Answer" post',
+	'BBPOINTS_ANSWER_EXPLAIN'	=> 'Set the number of BBpoints to be credited to post author when his post in this forum is marked as "Best Answer"',
 
 	'ENABLE_ANSWER'			=> 'Enable best answer',
 	'ENABLE_ANSWER_EXPLAIN'	=> 'If enabled, the topic starter (if permitted) and moderators (where allowed) will be able to mark a topic reply as the best answer.',
-	'EXTENSION_NOT_ENABLED'			=> 'The Best Answer extension is not enabled on this forum.',
+
+	'TO_POST'	=> '<i class="fa fa-eye"></i> View Post',
 
 	'LOG_MARK_ANSWER'	=> '<strong>Marked post as best answer</strong><br />» %1$s by %2$s',
 	'LOG_UNMARK_ANSWER'	=> '<strong>Unmarked post as best answer</strong><br />» %1$s by %2$s',
 
-	'LOG_BBPOINTS_MARK_ANSWER'		=> '<strong>Added BBPoints to author for best answer</strong><br />» %1$s by %2$s',
-	'LOG_BBPOINTS_UNMARK_ANSWER'	=> '<strong>Removed BBPoints of author for best answer</strong><br />» %1$s by %2$s',
+	'LOG_BBPOINTS_MARK_ANSWER'		=> '<strong>Added bbpoints to author for best answer</strong><br />» %1$s by %2$s',
+	'LOG_BBPOINTS_UNMARK_ANSWER'	=> '<strong>Removed bbpoints of author for best answer</strong><br />» %1$s by %2$s',
 
 	'MARK_ANSWER'			=> 'Mark answer',
 	'MARK_ANSWER_CONFIRM'	=> 'Are you sure you want to mark this post as the best answer?',
 
-	'TO_POST'	=> '<i class="fa fa-eye"></i> View Post',
-	'TOPIC_FIRST_POST'	=> 'You cannot mark this post as the best answer as it is the first post of the topic.',
 	'TOTAL_ANSWERS'	=> 'Total answers',
 
 	'UNMARK_ANSWER'			=> 'Unmark answer',
diff --git "[ORIGINAL]/leinad4mind\\bestanswer/language/en/permissions_bestanswer.php" "[FORUM_EXT]/leinad4mind\\bestanswer/language/en/permissions_bestanswer.php"
--- "[ORIGINAL]/leinad4mind\\bestanswer/language/en/permissions_bestanswer.php"
+++ "[FORUM_EXT]/leinad4mind\\bestanswer/language/en/permissions_bestanswer.php"
@@ -4,7 +4,7 @@
  * Best Answer extension for the phpBB Forum Software package.
  *
  * @copyright (c) 2018, kinerity, https://www.layer-3.org/
- * @copyright (c) 2019-2025, Leinad4Mind, https://leinad4mind.top/forum
+ * @copyright (c) 2019-2021, Leinad4Mind, https://leinad4mind.top/forum
  * @license GNU General Public License, version 2 (GPL-2.0)
  *
  */
diff --git "[ORIGINAL]/leinad4mind\\bestanswer/language/fr/common.php" "[FORUM_EXT]/leinad4mind\\bestanswer/language/fr/common.php"
--- "[ORIGINAL]/leinad4mind\\bestanswer/language/fr/common.php"
+++ "[FORUM_EXT]/leinad4mind\\bestanswer/language/fr/common.php"
@@ -4,7 +4,7 @@
  * Best Answer extension for the phpBB Forum Software package.
  *
  * @copyright (c) 2018, kinerity, https://www.layer-3.org/
- * @copyright (c) 2019-2025, Leinad4Mind, https://leinad4mind.top/forum
+ * @copyright (c) 2019-2021, Leinad4Mind, https://leinad4mind.top/forum
  * @translation (c) 2019 Galixte (http://www.galixte.com)
  * @license GNU General Public License, version 2 (GPL-2.0)
  *
@@ -44,24 +44,23 @@ $lang = array_merge($lang, array(
 	'ANSWERED'		=> 'Répondue',
 	
 	'BEST_ANSWER'	=> 'Meilleure réponse',
-	'BBPOINTS_ANSWER'			=> 'Nombre de BBPoints pour le message "Meilleure réponse"',
-	'BBPOINTS_ANSWER_EXPLAIN'	=> 'Définissez le nombre de BBpoints à créditer à l’auteur du message lorsque son message dans ce forum est marqué comme "Meilleure réponse"',
+	'BBPOINTS_ANSWER'			=> 'Nombre de BBpoints pour le message "Meilleure réponse"',
+	'BBPOINTS_ANSWER_EXPLAIN'	=> 'Définissez le nombre de BBpoints à créditer à l\'auteur du message lorsque son message dans ce forum est marqué comme "Meilleure réponse"',
 
 	'ENABLE_ANSWER'			=> 'Activer les réponses les plus pertinentes',
 	'ENABLE_ANSWER_EXPLAIN'	=> 'Permet aux auteurs de sujets et aux modérateurs de mettre en avant un message comme étant la réponse la plus pertinente de son sujet.',
-	'EXTENSION_NOT_ENABLED'			=> 'L’extension « Meilleure réponse » n’est pas activée sur ce forum.',
+
+	'TO_POST'	=> '<i class="fa fa-eye"></i> Se rendre au message',
 
 	'LOG_MARK_ANSWER'	=> '<strong>Mise en avant effectuée d’un message, comme étant la réponse la plus pertinente de son sujet</strong><br />» %1$s par %2$s',
 	'LOG_UNMARK_ANSWER'	=> '<strong>Mise en avant annulée d’un message, comme étant la réponse la plus pertinente de son sujet</strong><br />» %1$s par %2$s',
 
-	'LOG_BBPOINTS_MARK_ANSWER'		=> '<strong>Ajout de BBPoints à l\'auteur pour la réponse la plus pertinente</strong><br />» %1$s par %2$s',
-	'LOG_BBPOINTS_UNMARK_ANSWER'	=> '<strong>Suppression des BBPoints de l\'auteur pour la réponse la plus pertinente</strong><br />» %1$s par %2$s',
+	'LOG_BBPOINTS_MARK_ANSWER'		=> '<strong>Ajout de bbpoints à l\'auteur pour la réponse la plus pertinente</strong><br />» %1$s par %2$s',
+	'LOG_BBPOINTS_UNMARK_ANSWER'	=> '<strong>Suppression des bbpoints de l\'auteur pour la réponse la plus pertinente</strong><br />» %1$s par %2$s',
 
 	'MARK_ANSWER'			=> 'Mettre en avant ce message comme réponse la plus pertinente',
 	'MARK_ANSWER_CONFIRM'	=> 'Confirmer la mise en avant de ce message en tant que réponse la plus pertinente de son sujet.',
 
-	'TO_POST'	=> '<i class="fa fa-eye"></i> Se rendre au message',
-	'TOPIC_FIRST_POST'	=> 'Vous ne pouvez pas marquer cette réponse comme meilleure réponse, car il s’agit de la première réponse du sujet.',
 	'TOTAL_ANSWERS'	=> 'Réponses pertinentes',
 
 	'UNMARK_ANSWER'			=> 'Annuler la mise en avant de ce message comme réponse la plus pertinente',
diff --git "[ORIGINAL]/leinad4mind\\bestanswer/language/fr/permissions_bestanswer.php" "[FORUM_EXT]/leinad4mind\\bestanswer/language/fr/permissions_bestanswer.php"
--- "[ORIGINAL]/leinad4mind\\bestanswer/language/fr/permissions_bestanswer.php"
+++ "[FORUM_EXT]/leinad4mind\\bestanswer/language/fr/permissions_bestanswer.php"
@@ -4,7 +4,7 @@
  * Best Answer extension for the phpBB Forum Software package.
  *
  * @copyright (c) 2018, kinerity, https://www.layer-3.org/
- * @copyright (c) 2019-2025, Leinad4Mind, https://leinad4mind.top/forum
+ * @copyright (c) 2019-2021, Leinad4Mind, https://leinad4mind.top/forum
  * @translation (c) 2019 Galixte (http://www.galixte.com)
  * @license GNU General Public License, version 2 (GPL-2.0)
  *
diff --git "[ORIGINAL]/leinad4mind\\bestanswer/language/pt/common.php" "[FORUM_EXT]/leinad4mind\\bestanswer/language/pt/common.php"
--- "[ORIGINAL]/leinad4mind\\bestanswer/language/pt/common.php"
+++ "[FORUM_EXT]/leinad4mind\\bestanswer/language/pt/common.php"
@@ -4,7 +4,7 @@
  * Best Answer extension for the phpBB Forum Software package.
  *
  * @copyright (c) 2018, kinerity, https://www.layer-3.org/
- * @copyright (c) 2019-2025, Leinad4Mind, https://leinad4mind.top/forum
+ * @copyright (c) 2019-2021, Leinad4Mind, https://leinad4mind.top/forum
  * @license GNU General Public License, version 2 (GPL-2.0)
  *
  */
@@ -48,7 +48,8 @@ $lang = array_merge($lang, array(
 
 	'ENABLE_ANSWER'			=> 'Activar Melhor Resposta',
 	'ENABLE_ANSWER_EXPLAIN'	=> 'If enabled, the topic starter (if permitted) and moderators (where allowed) will be able to mark a topic reply as the best answer.',
-	'EXTENSION_NOT_ENABLED'			=> 'A extensão "Melhor Resposta" não está ativada neste fórum.',
+
+	'TO_POST'	=> '<i class="fa fa-eye"></i> Ver Mensagem',
 
 	'LOG_MARK_ANSWER'	=> '<strong>Mensagem marcada como Melhor Resposta</strong><br />» %1$s by %2$s',
 	'LOG_UNMARK_ANSWER'	=> '<strong>Mensagem deixou de ser a Melhor Resposta</strong><br />» %1$s by %2$s',
@@ -59,8 +60,6 @@ $lang = array_merge($lang, array(
 	'MARK_ANSWER'			=> 'Marcar Melhor Resposta',
 	'MARK_ANSWER_CONFIRM'	=> 'Tens a certeza de que queres marcar esta mensagem como sendo a melhor resposta?',
 
-	'TO_POST'	=> '<i class="fa fa-eye"></i> Ver Mensagem',
-	'TOPIC_FIRST_POST'	=> 'Não é possível marcar esta mensagem como a melhor resposta, pois é a primeira mensagem do tópico.',
 	'TOTAL_ANSWERS'	=> 'Respostas totais',
 
 	'UNMARK_ANSWER'			=> 'Remover Melhor Resposta',
diff --git "[ORIGINAL]/leinad4mind\\bestanswer/language/pt/permissions_bestanswer.php" "[FORUM_EXT]/leinad4mind\\bestanswer/language/pt/permissions_bestanswer.php"
--- "[ORIGINAL]/leinad4mind\\bestanswer/language/pt/permissions_bestanswer.php"
+++ "[FORUM_EXT]/leinad4mind\\bestanswer/language/pt/permissions_bestanswer.php"
@@ -4,7 +4,7 @@
  * Best Answer extension for the phpBB Forum Software package.
  *
  * @copyright (c) 2018, kinerity, https://www.layer-3.org/
- * @copyright (c) 2019-2025, Leinad4Mind, https://leinad4mind.top/forum
+ * @copyright (c) 2019-2021, Leinad4Mind, https://leinad4mind.top/forum
  * @license GNU General Public License, version 2 (GPL-2.0)
  *
  */
diff --git "[ORIGINAL]/leinad4mind\\bestanswer/language/pt-br/common.php" "[ORIGINAL]/leinad4mind\\bestanswer/language/pt-br/common.php"
deleted file mode 100644
--- "[ORIGINAL]/leinad4mind\\bestanswer/language/pt-br/common.php"
+++ /dev/null
@@ -1,73 +0,0 @@
-<?php
-/**
- *
- * Best Answer extension for the phpBB Forum Software package.
- *
- * @copyright (c) 2018, kinerity, https://www.layer-3.org/
- * @copyright (c) 2019-2025, Leinad4Mind, https://leinad4mind.top/forum
- * @license GNU General Public License, version 2 (GPL-2.0)
- *
- */
-
-/**
- * DO NOT CHANGE
- */
-if (!defined('IN_PHPBB'))
-{
-	exit;
-}
-
-if (empty($lang) || !is_array($lang))
-{
-	$lang = array();
-}
-
-// DEVELOPERS PLEASE NOTE
-//
-// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
-//
-// Placeholders can now contain order information, e.g. instead of
-// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
-// translators to re-order the output of data while ensuring it remains correct
-//
-// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
-// equally where a string contains only two placeholders which are used to wrap text
-// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
-//
-// Some characters you may want to copy&paste:
-// ’ » “ ” …
-//
-
-$lang = array_merge($lang, array(
-	'ANSWERS'		=> 'Respostas',
-	'ANSWERED'		=> 'Respondidas',
-	
-	'BEST_ANSWER'	=> 'Melhor resposta',
-	'BBPOINTS_ANSWER'			=> 'Quantidade de BBpoints para a postagem “Melhor resposta”',
-	'BBPOINTS_ANSWER_EXPLAIN'	=> 'Defina o número de pontos BB a serem creditados ao autor da postagem quando sua postagem neste fórum for marcada como “Melhor resposta”',
-
-	'ENABLE_ANSWER'			=> 'Habilitar melhor resposta',
-	'ENABLE_ANSWER_EXPLAIN'	=> 'Se ativado, o autor do tópico (se permitido) e os moderadores (onde permitido) poderão marcar uma resposta ao tópico como a melhor resposta.',
-	'EXTENSION_NOT_ENABLED'			=> 'A extensão Melhor resposta não está ativada neste fórum.',
-
-	'LOG_MARK_ANSWER'	=> '<strong>Postagem marcada como melhor resposta</strong><br />» %1$s by %2$s',
-	'LOG_UNMARK_ANSWER'	=> '<strong>Postagem desmarcada como melhor resposta</strong><br />» %1$s by %2$s',
-
-	'LOG_BBPOINTS_MARK_ANSWER'		=> '<strong>Adicionados bbpoints ao autor pela melhor resposta</strong><br />» %1$s by %2$s',
-	'LOG_BBPOINTS_UNMARK_ANSWER'	=> '<strong>Removidos bbpoints ao autor por perder a melhor resposta</strong><br />» %1$s by %2$s',
-
-	'MARK_ANSWER'			=> 'Marcar resposta',
-	'MARK_ANSWER_CONFIRM'	=> 'Tem certeza de que deseja marcar esta postagem como a melhor resposta?',
-
-	'TO_POST'	=> '<i class="fa fa-eye"></i> Ver postagem',
-	'TOPIC_FIRST_POST'	=> 'Você não pode marcar esta postagem como a melhor resposta, pois é a primeira postagem do tópico.',
-	'TOTAL_ANSWERS'	=> 'Total de respostas',
-
-	'UNMARK_ANSWER'			=> 'Desmarcar resposta',
-	'UNMARK_ANSWER_CONFIRM'	=> 'Tem certeza de que deseja desmarcar esta postagem como a melhor resposta?',
-
-	'MARK_ANSWER_NOTIFICATION'			=> '%1$s marcou sua postagem no tópico “%2$s” como a melhor resposta.',
-	'UNMARK_ANSWER_NOTIFICATION'		=> '%1$s desmarcou sua postagem no tópico “%2$s” como a melhor resposta.',
-	'NOTIFICATION_TYPE_MARK_ANSWER'		=> 'Alguém marcou sua resposta no tópico como a melhor resposta',
-	'NOTIFICATION_TYPE_UNMARK_ANSWER'	=> 'Alguém desmarcou sua resposta no tópico como a melhor resposta',
-));
diff --git "[ORIGINAL]/leinad4mind\\bestanswer/language/pt-br/email/mark_mail.txt" "[ORIGINAL]/leinad4mind\\bestanswer/language/pt-br/email/mark_mail.txt"
deleted file mode 100644
--- "[ORIGINAL]/leinad4mind\\bestanswer/language/pt-br/email/mark_mail.txt"
+++ /dev/null
@@ -1,10 +0,0 @@
-Subject: A tua mensagem foi marcada como sendo a melhor resposta
-
-Olá,
-
-a tua mensagem em "{{ TOPIC_TITLE }}" no "{{ SITENAME }}" foi marcada com sendo a melhor resposta por "{{ USERNAME }}".
-
-Para veres a tua mensagem clica no endereço seguinte:
-{{ U_LINK_TO_TOPIC }}
-
-{{ EMAIL_SIG }}
diff --git "[ORIGINAL]/leinad4mind\\bestanswer/language/pt-br/email/unmark_mail.txt" "[ORIGINAL]/leinad4mind\\bestanswer/language/pt-br/email/unmark_mail.txt"
deleted file mode 100644
--- "[ORIGINAL]/leinad4mind\\bestanswer/language/pt-br/email/unmark_mail.txt"
+++ /dev/null
@@ -1,10 +0,0 @@
-Subject: A tua mensagem deixou de ser a melhor resposta
-
-Olá,
-
-Infelizmente a tua mensagem em "{{ TOPIC_TITLE }}" no "{{ SITENAME }}" deixou de ser a melhor resposta.
-
-Para veres a tua mensagem clica no endereço seguinte:
-{{ U_LINK_TO_TOPIC }}
-
-{{ EMAIL_SIG }}
diff --git "[ORIGINAL]/leinad4mind\\bestanswer/language/pt-br/permissions_bestanswer.php" "[ORIGINAL]/leinad4mind\\bestanswer/language/pt-br/permissions_bestanswer.php"
deleted file mode 100644
--- "[ORIGINAL]/leinad4mind\\bestanswer/language/pt-br/permissions_bestanswer.php"
+++ /dev/null
@@ -1,44 +0,0 @@
-<?php
-/**
- *
- * Best Answer extension for the phpBB Forum Software package.
- *
- * @copyright (c) 2018, kinerity, https://www.layer-3.org/
- * @copyright (c) 2019-2025, Leinad4Mind, https://leinad4mind.top/forum
- * @license GNU General Public License, version 2 (GPL-2.0)
- *
- */
-
-/**
- * DO NOT CHANGE
- */
-if (!defined('IN_PHPBB'))
-{
-	exit;
-}
-
-if (empty($lang) || !is_array($lang))
-{
-	$lang = array();
-}
-
-// DEVELOPERS PLEASE NOTE
-//
-// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
-//
-// Placeholders can now contain order information, e.g. instead of
-// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
-// translators to re-order the output of data while ensuring it remains correct
-//
-// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
-// equally where a string contains only two placeholders which are used to wrap text
-// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
-//
-// Some characters you may want to copy&paste:
-// ’ » “ ” …
-//
-
-$lang = array_merge($lang, array(
-	'ACL_F_MARK_ANSWER' => 'Pode marcar mensagem como melhor resposta',
-	'ACL_M_MARK_ANSWER' => 'Pode marcar mensagem como melhor resposta',
-));
diff --git "[ORIGINAL]/leinad4mind\\bestanswer/language/pt_preao/common.php" "[FORUM_EXT]/leinad4mind\\bestanswer/language/pt_preao/common.php"
--- "[ORIGINAL]/leinad4mind\\bestanswer/language/pt_preao/common.php"
+++ "[FORUM_EXT]/leinad4mind\\bestanswer/language/pt_preao/common.php"
@@ -4,7 +4,7 @@
  * Best Answer extension for the phpBB Forum Software package.
  *
  * @copyright (c) 2018, kinerity, https://www.layer-3.org/
- * @copyright (c) 2019-2025, Leinad4Mind, https://leinad4mind.top/forum
+ * @copyright (c) 2019-2021, Leinad4Mind, https://leinad4mind.top/forum
  * @license GNU General Public License, version 2 (GPL-2.0)
  *
  */
@@ -48,7 +48,8 @@ $lang = array_merge($lang, array(
 
 	'ENABLE_ANSWER'			=> 'Activar Melhor Resposta',
 	'ENABLE_ANSWER_EXPLAIN'	=> 'If enabled, the topic starter (if permitted) and moderators (where allowed) will be able to mark a topic reply as the best answer.',
-	'EXTENSION_NOT_ENABLED'			=> 'A extensão "Melhor Resposta" não está activada neste fórum.',
+
+	'TO_POST'	=> '<i class="fa fa-eye"></i> Ver Mensagem',
 
 	'LOG_MARK_ANSWER'	=> '<strong>Mensagem marcada como Melhor Resposta</strong><br />» %1$s by %2$s',
 	'LOG_UNMARK_ANSWER'	=> '<strong>Mensagem deixou de ser a Melhor Resposta</strong><br />» %1$s by %2$s',
@@ -59,8 +60,6 @@ $lang = array_merge($lang, array(
 	'MARK_ANSWER'			=> 'Marcar Melhor Resposta',
 	'MARK_ANSWER_CONFIRM'	=> 'Tens a certeza de que queres marcar esta mensagem como sendo a melhor resposta?',
 
-	'TO_POST'	=> '<i class="fa fa-eye"></i> Ver Mensagem',
-	'TOPIC_FIRST_POST'	=> 'Não é possível marcar esta mensagem como a melhor resposta, pois é a primeira mensagem do tópico.',
 	'TOTAL_ANSWERS'	=> 'Respostas totais',
 
 	'UNMARK_ANSWER'			=> 'Remover Melhor Resposta',
diff --git "[ORIGINAL]/leinad4mind\\bestanswer/language/pt_preao/permissions_bestanswer.php" "[FORUM_EXT]/leinad4mind\\bestanswer/language/pt_preao/permissions_bestanswer.php"
--- "[ORIGINAL]/leinad4mind\\bestanswer/language/pt_preao/permissions_bestanswer.php"
+++ "[FORUM_EXT]/leinad4mind\\bestanswer/language/pt_preao/permissions_bestanswer.php"
@@ -4,7 +4,7 @@
  * Best Answer extension for the phpBB Forum Software package.
  *
  * @copyright (c) 2018, kinerity, https://www.layer-3.org/
- * @copyright (c) 2019-2025, Leinad4Mind, https://leinad4mind.top/forum
+ * @copyright (c) 2019-2021, Leinad4Mind, https://leinad4mind.top/forum
  * @license GNU General Public License, version 2 (GPL-2.0)
  *
  */
diff --git "[ORIGINAL]/leinad4mind\\bestanswer/language/ru/common.php" "[FORUM_EXT]/leinad4mind\\bestanswer/language/ru/common.php"
--- "[ORIGINAL]/leinad4mind\\bestanswer/language/ru/common.php"
+++ "[FORUM_EXT]/leinad4mind\\bestanswer/language/ru/common.php"
@@ -4,7 +4,7 @@
  * Best Answer extension for the phpBB Forum Software package.
  *
  * @copyright (c) 2018, kinerity, https://www.layer-3.org/
- * @copyright (c) 2019-2025, Leinad4Mind, https://leinad4mind.top/forum
+ * @copyright (c) 2019-2021, Leinad4Mind, https://leinad4mind.top/forum
  * @translation (c) 2019 naoiphoenix
  * @license GNU General Public License, version 2 (GPL-2.0)
  *
@@ -49,7 +49,8 @@ $lang = array_merge($lang, array(
 
 	'ENABLE_ANSWER'			=> 'Включить лучший ответ',
 	'ENABLE_ANSWER_EXPLAIN'	=> 'Если включено, автор темы (если разрешено) и модераторы разделов (где разрешено) будут способны отмечать ответ как лучший.',
-	'EXTENSION_NOT_ENABLED'			=> 'Расширение «Лучший ответ» не включено на этом форуме.',
+
+	'TO_POST'	=> '<i class="fa fa-eye"></i> Перейти к полному ответу',
 
 	'LOG_MARK_ANSWER'	=> '<strong>Отмечено лучшим ответом</strong><br />» %1$s пользователем %2$s',
 	'LOG_UNMARK_ANSWER'	=> '<strong>Снята отметка лучшего ответа</strong><br />» %1$s пользователем %2$s',
@@ -60,8 +61,6 @@ $lang = array_merge($lang, array(
 	'MARK_ANSWER'			=> 'Отметить ответ',
 	'MARK_ANSWER_CONFIRM'	=> 'Вы уверены, что хотите отметить этот ответ как лучший?',
 
-	'TO_POST'	=> '<i class="fa fa-eye"></i> Перейти к полному ответу',
-	'TOPIC_FIRST_POST'	=> 'Вы не можете отметить этот пост как лучший ответ, так как он является первым постом в теме.',
 	'TOTAL_ANSWERS'	=> 'Всего ответов',
 
 	'UNMARK_ANSWER'			=> 'Снять отметку',
diff --git "[ORIGINAL]/leinad4mind\\bestanswer/language/ru/permissions_bestanswer.php" "[FORUM_EXT]/leinad4mind\\bestanswer/language/ru/permissions_bestanswer.php"
--- "[ORIGINAL]/leinad4mind\\bestanswer/language/ru/permissions_bestanswer.php"
+++ "[FORUM_EXT]/leinad4mind\\bestanswer/language/ru/permissions_bestanswer.php"
@@ -4,7 +4,7 @@
  * Best Answer extension for the phpBB Forum Software package.
  *
  * @copyright (c) 2018, kinerity, https://www.layer-3.org/
- * @copyright (c) 2019-2025, Leinad4Mind, https://leinad4mind.top/forum
+ * @copyright (c) 2019-2021, Leinad4Mind, https://leinad4mind.top/forum
  * @translation (c) 2019 naoiphoenix
  * @license GNU General Public License, version 2 (GPL-2.0)
  *
diff --git "[ORIGINAL]/leinad4mind\\bestanswer/license.txt" "[ORIGINAL]/leinad4mind\\bestanswer/license.txt"
deleted file mode 100644
--- "[ORIGINAL]/leinad4mind\\bestanswer/license.txt"
+++ /dev/null
@@ -1,280 +0,0 @@
-			GNU GENERAL PUBLIC LICENSE
-		       Version 2, June 1991
-
- Copyright (C) 1989, 1991 Free Software Foundation, Inc.
-                          675 Mass Ave, Cambridge, MA 02139, USA
- Everyone is permitted to copy and distribute verbatim copies
- of this license document, but changing it is not allowed.
-
-			    Preamble
-
-  The licenses for most software are designed to take away your
-freedom to share and change it.  By contrast, the GNU General Public
-License is intended to guarantee your freedom to share and change free
-software--to make sure the software is free for all its users.  This
-General Public License applies to most of the Free Software
-Foundation's software and to any other program whose authors commit to
-using it.  (Some other Free Software Foundation software is covered by
-the GNU Library General Public License instead.)  You can apply it to
-your programs, too.
-
-  When we speak of free software, we are referring to freedom, not
-price.  Our General Public Licenses are designed to make sure that you
-have the freedom to distribute copies of free software (and charge for
-this service if you wish), that you receive source code or can get it
-if you want it, that you can change the software or use pieces of it
-in new free programs; and that you know you can do these things.
-
-  To protect your rights, we need to make restrictions that forbid
-anyone to deny you these rights or to ask you to surrender the rights.
-These restrictions translate to certain responsibilities for you if you
-distribute copies of the software, or if you modify it.
-
-  For example, if you distribute copies of such a program, whether
-gratis or for a fee, you must give the recipients all the rights that
-you have.  You must make sure that they, too, receive or can get the
-source code.  And you must show them these terms so they know their
-rights.
-
-  We protect your rights with two steps: (1) copyright the software, and
-(2) offer you this license which gives you legal permission to copy,
-distribute and/or modify the software.
-
-  Also, for each author's protection and ours, we want to make certain
-that everyone understands that there is no warranty for this free
-software.  If the software is modified by someone else and passed on, we
-want its recipients to know that what they have is not the original, so
-that any problems introduced by others will not reflect on the original
-authors' reputations.
-
-  Finally, any free program is threatened constantly by software
-patents.  We wish to avoid the danger that redistributors of a free
-program will individually obtain patent licenses, in effect making the
-program proprietary.  To prevent this, we have made it clear that any
-patent must be licensed for everyone's free use or not licensed at all.
-
-  The precise terms and conditions for copying, distribution and
-modification follow.
-
-		    GNU GENERAL PUBLIC LICENSE
-   TERMS AND CONDITIONS FOR COPYING, DISTRIBUTION AND MODIFICATION
-
-  0. This License applies to any program or other work which contains
-a notice placed by the copyright holder saying it may be distributed
-under the terms of this General Public License.  The "Program", below,
-refers to any such program or work, and a "work based on the Program"
-means either the Program or any derivative work under copyright law:
-that is to say, a work containing the Program or a portion of it,
-either verbatim or with modifications and/or translated into another
-language.  (Hereinafter, translation is included without limitation in
-the term "modification".)  Each licensee is addressed as "you".
-
-Activities other than copying, distribution and modification are not
-covered by this License; they are outside its scope.  The act of
-running the Program is not restricted, and the output from the Program
-is covered only if its contents constitute a work based on the
-Program (independent of having been made by running the Program).
-Whether that is true depends on what the Program does.
-
-  1. You may copy and distribute verbatim copies of the Program's
-source code as you receive it, in any medium, provided that you
-conspicuously and appropriately publish on each copy an appropriate
-copyright notice and disclaimer of warranty; keep intact all the
-notices that refer to this License and to the absence of any warranty;
-and give any other recipients of the Program a copy of this License
-along with the Program.
-
-You may charge a fee for the physical act of transferring a copy, and
-you may at your option offer warranty protection in exchange for a fee.
-
-  2. You may modify your copy or copies of the Program or any portion
-of it, thus forming a work based on the Program, and copy and
-distribute such modifications or work under the terms of Section 1
-above, provided that you also meet all of these conditions:
-
-    a) You must cause the modified files to carry prominent notices
-    stating that you changed the files and the date of any change.
-
-    b) You must cause any work that you distribute or publish, that in
-    whole or in part contains or is derived from the Program or any
-    part thereof, to be licensed as a whole at no charge to all third
-    parties under the terms of this License.
-
-    c) If the modified program normally reads commands interactively
-    when run, you must cause it, when started running for such
-    interactive use in the most ordinary way, to print or display an
-    announcement including an appropriate copyright notice and a
-    notice that there is no warranty (or else, saying that you provide
-    a warranty) and that users may redistribute the program under
-    these conditions, and telling the user how to view a copy of this
-    License.  (Exception: if the Program itself is interactive but
-    does not normally print such an announcement, your work based on
-    the Program is not required to print an announcement.)
-
-These requirements apply to the modified work as a whole.  If
-identifiable sections of that work are not derived from the Program,
-and can be reasonably considered independent and separate works in
-themselves, then this License, and its terms, do not apply to those
-sections when you distribute them as separate works.  But when you
-distribute the same sections as part of a whole which is a work based
-on the Program, the distribution of the whole must be on the terms of
-this License, whose permissions for other licensees extend to the
-entire whole, and thus to each and every part regardless of who wrote it.
-
-Thus, it is not the intent of this section to claim rights or contest
-your rights to work written entirely by you; rather, the intent is to
-exercise the right to control the distribution of derivative or
-collective works based on the Program.
-
-In addition, mere aggregation of another work not based on the Program
-with the Program (or with a work based on the Program) on a volume of
-a storage or distribution medium does not bring the other work under
-the scope of this License.
-
-  3. You may copy and distribute the Program (or a work based on it,
-under Section 2) in object code or executable form under the terms of
-Sections 1 and 2 above provided that you also do one of the following:
-
-    a) Accompany it with the complete corresponding machine-readable
-    source code, which must be distributed under the terms of Sections
-    1 and 2 above on a medium customarily used for software interchange; or,
-
-    b) Accompany it with a written offer, valid for at least three
-    years, to give any third party, for a charge no more than your
-    cost of physically performing source distribution, a complete
-    machine-readable copy of the corresponding source code, to be
-    distributed under the terms of Sections 1 and 2 above on a medium
-    customarily used for software interchange; or,
-
-    c) Accompany it with the information you received as to the offer
-    to distribute corresponding source code.  (This alternative is
-    allowed only for noncommercial distribution and only if you
-    received the program in object code or executable form with such
-    an offer, in accord with Subsection b above.)
-
-The source code for a work means the preferred form of the work for
-making modifications to it.  For an executable work, complete source
-code means all the source code for all modules it contains, plus any
-associated interface definition files, plus the scripts used to
-control compilation and installation of the executable.  However, as a
-special exception, the source code distributed need not include
-anything that is normally distributed (in either source or binary
-form) with the major components (compiler, kernel, and so on) of the
-operating system on which the executable runs, unless that component
-itself accompanies the executable.
-
-If distribution of executable or object code is made by offering
-access to copy from a designated place, then offering equivalent
-access to copy the source code from the same place counts as
-distribution of the source code, even though third parties are not
-compelled to copy the source along with the object code.
-
-  4. You may not copy, modify, sublicense, or distribute the Program
-except as expressly provided under this License.  Any attempt
-otherwise to copy, modify, sublicense or distribute the Program is
-void, and will automatically terminate your rights under this License.
-However, parties who have received copies, or rights, from you under
-this License will not have their licenses terminated so long as such
-parties remain in full compliance.
-
-  5. You are not required to accept this License, since you have not
-signed it.  However, nothing else grants you permission to modify or
-distribute the Program or its derivative works.  These actions are
-prohibited by law if you do not accept this License.  Therefore, by
-modifying or distributing the Program (or any work based on the
-Program), you indicate your acceptance of this License to do so, and
-all its terms and conditions for copying, distributing or modifying
-the Program or works based on it.
-
-  6. Each time you redistribute the Program (or any work based on the
-Program), the recipient automatically receives a license from the
-original licensor to copy, distribute or modify the Program subject to
-these terms and conditions.  You may not impose any further
-restrictions on the recipients' exercise of the rights granted herein.
-You are not responsible for enforcing compliance by third parties to
-this License.
-
-  7. If, as a consequence of a court judgment or allegation of patent
-infringement or for any other reason (not limited to patent issues),
-conditions are imposed on you (whether by court order, agreement or
-otherwise) that contradict the conditions of this License, they do not
-excuse you from the conditions of this License.  If you cannot
-distribute so as to satisfy simultaneously your obligations under this
-License and any other pertinent obligations, then as a consequence you
-may not distribute the Program at all.  For example, if a patent
-license would not permit royalty-free redistribution of the Program by
-all those who receive copies directly or indirectly through you, then
-the only way you could satisfy both it and this License would be to
-refrain entirely from distribution of the Program.
-
-If any portion of this section is held invalid or unenforceable under
-any particular circumstance, the balance of the section is intended to
-apply and the section as a whole is intended to apply in other
-circumstances.
-
-It is not the purpose of this section to induce you to infringe any
-patents or other property right claims or to contest validity of any
-such claims; this section has the sole purpose of protecting the
-integrity of the free software distribution system, which is
-implemented by public license practices.  Many people have made
-generous contributions to the wide range of software distributed
-through that system in reliance on consistent application of that
-system; it is up to the author/donor to decide if he or she is willing
-to distribute software through any other system and a licensee cannot
-impose that choice.
-
-This section is intended to make thoroughly clear what is believed to
-be a consequence of the rest of this License.
-
-  8. If the distribution and/or use of the Program is restricted in
-certain countries either by patents or by copyrighted interfaces, the
-original copyright holder who places the Program under this License
-may add an explicit geographical distribution limitation excluding
-those countries, so that distribution is permitted only in or among
-countries not thus excluded.  In such case, this License incorporates
-the limitation as if written in the body of this License.
-
-  9. The Free Software Foundation may publish revised and/or new versions
-of the General Public License from time to time.  Such new versions will
-be similar in spirit to the present version, but may differ in detail to
-address new problems or concerns.
-
-Each version is given a distinguishing version number.  If the Program
-specifies a version number of this License which applies to it and "any
-later version", you have the option of following the terms and conditions
-either of that version or of any later version published by the Free
-Software Foundation.  If the Program does not specify a version number of
-this License, you may choose any version ever published by the Free Software
-Foundation.
-
-  10. If you wish to incorporate parts of the Program into other free
-programs whose distribution conditions are different, write to the author
-to ask for permission.  For software which is copyrighted by the Free
-Software Foundation, write to the Free Software Foundation; we sometimes
-make exceptions for this.  Our decision will be guided by the two goals
-of preserving the free status of all derivatives of our free software and
-of promoting the sharing and reuse of software generally.
-
-			    NO WARRANTY
-
-  11. BECAUSE THE PROGRAM IS LICENSED FREE OF CHARGE, THERE IS NO WARRANTY
-FOR THE PROGRAM, TO THE EXTENT PERMITTED BY APPLICABLE LAW.  EXCEPT WHEN
-OTHERWISE STATED IN WRITING THE COPYRIGHT HOLDERS AND/OR OTHER PARTIES
-PROVIDE THE PROGRAM "AS IS" WITHOUT WARRANTY OF ANY KIND, EITHER EXPRESSED
-OR IMPLIED, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF
-MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE.  THE ENTIRE RISK AS
-TO THE QUALITY AND PERFORMANCE OF THE PROGRAM IS WITH YOU.  SHOULD THE
-PROGRAM PROVE DEFECTIVE, YOU ASSUME THE COST OF ALL NECESSARY SERVICING,
-REPAIR OR CORRECTION.
-
-  12. IN NO EVENT UNLESS REQUIRED BY APPLICABLE LAW OR AGREED TO IN WRITING
-WILL ANY COPYRIGHT HOLDER, OR ANY OTHER PARTY WHO MAY MODIFY AND/OR
-REDISTRIBUTE THE PROGRAM AS PERMITTED ABOVE, BE LIABLE TO YOU FOR DAMAGES,
-INCLUDING ANY GENERAL, SPECIAL, INCIDENTAL OR CONSEQUENTIAL DAMAGES ARISING
-OUT OF THE USE OR INABILITY TO USE THE PROGRAM (INCLUDING BUT NOT LIMITED
-TO LOSS OF DATA OR DATA BEING RENDERED INACCURATE OR LOSSES SUSTAINED BY
-YOU OR THIRD PARTIES OR A FAILURE OF THE PROGRAM TO OPERATE WITH ANY OTHER
-PROGRAMS), EVEN IF SUCH HOLDER OR OTHER PARTY HAS BEEN ADVISED OF THE
-POSSIBILITY OF SUCH DAMAGES.
-
-		     END OF TERMS AND CONDITIONS
diff --git "[ORIGINAL]/leinad4mind\\bestanswer/migrations/v10x/release_0_0_1.php" "[FORUM_EXT]/leinad4mind\\bestanswer/migrations/v10x/release_0_0_1.php"
--- "[ORIGINAL]/leinad4mind\\bestanswer/migrations/v10x/release_0_0_1.php"
+++ "[FORUM_EXT]/leinad4mind\\bestanswer/migrations/v10x/release_0_0_1.php"
@@ -4,7 +4,7 @@
  * Best Answer extension for the phpBB Forum Software package.
  *
  * @copyright (c) 2018, kinerity, https://www.layer-3.org/
- * @copyright (c) 2019-2025, Leinad4Mind, https://leinad4mind.top/forum
+ * @copyright (c) 2019-2021, Leinad4Mind, https://leinad4mind.top/forum
  * @license GNU General Public License, version 2 (GPL-2.0)
  *
  */
@@ -18,23 +18,11 @@ class release_0_0_1 extends \phpbb\db\migration\container_aware_migration
 		return $this->db_tools->sql_column_exists($this->table_prefix . 'forums', 'enable_answer');
 	}
 
-	/**
-	 * Assign migration file dependencies for this migration
-	 *
-	 * @return void
-	 * @access public
-	 */
 	static public function depends_on()
 	{
 		return array('\phpbb\db\migration\data\v320\v320');
 	}
 
-	/**
-	 * Add or update schema in the database
-	 *
-	 * @return array Array of table schema
-	 * @access public
-	 */
 	public function update_schema()
 	{
 		return array(
@@ -55,12 +43,6 @@ class release_0_0_1 extends \phpbb\db\migration\container_aware_migration
 		);
 	}
 
-	/**
-	 * Add or update data in the database
-	 *
-	 * @return array Array of table data
-	 * @access public
-	 */
 	public function update_data()
 	{
 		$data = array(
@@ -92,12 +74,6 @@ class release_0_0_1 extends \phpbb\db\migration\container_aware_migration
 		return $data;
 	}
 
-	/**
-	 * Drop schema in the database
-	 *
-	 * @return array Array of table schema
-	 * @access public
-	 */
 	public function revert_schema()
 	{
 		return array(
@@ -120,9 +96,6 @@ class release_0_0_1 extends \phpbb\db\migration\container_aware_migration
 
 	/**
 	 * Custom function query permission roles
-	 *
-	 * @return void
-	 * @access public
 	 */
 	private function role_exists($role)
 	{
diff --git "[ORIGINAL]/leinad4mind\\bestanswer/migrations/v10x/release_0_1_0.php" "[FORUM_EXT]/leinad4mind\\bestanswer/migrations/v10x/release_0_1_0.php"
--- "[ORIGINAL]/leinad4mind\\bestanswer/migrations/v10x/release_0_1_0.php"
+++ "[FORUM_EXT]/leinad4mind\\bestanswer/migrations/v10x/release_0_1_0.php"
@@ -3,7 +3,7 @@
  *
  * Best Answer extension for the phpBB Forum Software package.
  *
- * @copyright (c) 2019-2025, Leinad4Mind, https://leinad4mind.top/forum
+ * @copyright (c) 2019-2021, Leinad4Mind, https://leinad4mind.top/forum
  * @license GNU General Public License, version 2 (GPL-2.0)
  *
  */
diff --git "[ORIGINAL]/leinad4mind\\bestanswer/notification/type/markanswer.php" "[FORUM_EXT]/leinad4mind\\bestanswer/notification/type/markanswer.php"
--- "[ORIGINAL]/leinad4mind\\bestanswer/notification/type/markanswer.php"
+++ "[FORUM_EXT]/leinad4mind\\bestanswer/notification/type/markanswer.php"
@@ -4,7 +4,7 @@
  * Best Answer extension for the phpBB Forum Software package.
  *
  * @copyright (c) 2018, kinerity, https://www.layer-3.org/
- * @copyright (c) 2019-2025, Leinad4Mind, https://leinad4mind.top/forum
+ * @copyright (c) 2019-2021, Leinad4Mind, https://leinad4mind.top/forum
  * @license GNU General Public License, version 2 (GPL-2.0)
  *
  */
diff --git "[ORIGINAL]/leinad4mind\\bestanswer/notification/type/unmarkanswer.php" "[FORUM_EXT]/leinad4mind\\bestanswer/notification/type/unmarkanswer.php"
--- "[ORIGINAL]/leinad4mind\\bestanswer/notification/type/unmarkanswer.php"
+++ "[FORUM_EXT]/leinad4mind\\bestanswer/notification/type/unmarkanswer.php"
@@ -4,7 +4,7 @@
  * Best Answer extension for the phpBB Forum Software package.
  *
  * @copyright (c) 2018, kinerity, https://www.layer-3.org/
- * @copyright (c) 2019-2025, Leinad4Mind, https://leinad4mind.top/forum
+ * @copyright (c) 2019-2021, Leinad4Mind, https://leinad4mind.top/forum
  * @license GNU General Public License, version 2 (GPL-2.0)
  *
  */
diff --git "[ORIGINAL]/leinad4mind\\bestanswer/styles/prosilver/template/event/mcp_topic_postrow_attachments_after.html" "[FORUM_EXT]/leinad4mind\\bestanswer/styles/prosilver/template/event/mcp_topic_postrow_attachments_after.html"
--- "[ORIGINAL]/leinad4mind\\bestanswer/styles/prosilver/template/event/mcp_topic_postrow_attachments_after.html"
+++ "[FORUM_EXT]/leinad4mind\\bestanswer/styles/prosilver/template/event/mcp_topic_postrow_attachments_after.html"
@@ -1,5 +1,5 @@
 {% if postrow.S_FIRST_POST and postrow.ANSWER_POST_ID %}
-<div class="postbody post_answer{% if S_NIGHTSTAKLER_ENABLED %}-dark{% endif %}"><i class="icon fa-check fa-fw icon-green" aria-hidden="true"></i><span class="author">{{ lang('POST_BY_AUTHOR') }} {{ postrow.ANSWER_USERNAME_FULL }} &raquo; {{ postrow.ANSWER_POST_TIME }}</span>
+<div class="postbody post_answer"><i class="icon fa-check fa-fw icon-green" aria-hidden="true"></i><span class="author">{{ lang('POST_BY_AUTHOR') }} {{ postrow.ANSWER_USERNAME_FULL }} &raquo; {{ postrow.ANSWER_POST_TIME }}</span>
 <div class="content">{{ postrow.ANSWER_POST_TEXT }}</div>
 <a href="{{ postrow.U_ANSWER }}">{{ lang('TO_POST') }}</a></div>
 {% endif %}
diff --git "[ORIGINAL]/leinad4mind\\bestanswer/styles/prosilver/template/event/mcp_topic_postrow_post_after.html" "[ORIGINAL]/leinad4mind\\bestanswer/styles/prosilver/template/event/mcp_topic_postrow_post_after.html"
deleted file mode 100644
--- "[ORIGINAL]/leinad4mind\\bestanswer/styles/prosilver/template/event/mcp_topic_postrow_post_after.html"
+++ /dev/null
@@ -1,3 +0,0 @@
-{% if postrow.POST_ID == postrow.ANSWER_POST_ID %}
-	</div>
-{% endif %} 
diff --git "[ORIGINAL]/leinad4mind\\bestanswer/styles/prosilver/template/event/mcp_topic_postrow_post_before.html" "[FORUM_EXT]/leinad4mind\\bestanswer/styles/prosilver/template/event/mcp_topic_postrow_post_before.html"
--- "[ORIGINAL]/leinad4mind\\bestanswer/styles/prosilver/template/event/mcp_topic_postrow_post_before.html"
+++ "[FORUM_EXT]/leinad4mind\\bestanswer/styles/prosilver/template/event/mcp_topic_postrow_post_before.html"
@@ -1,4 +1,3 @@
 {% if postrow.POST_ID == postrow.ANSWER_POST_ID %}
 <div class="answer hidden"></div>
-	<div class="answer-post{% if S_NIGHTSTAKLER_ENABLED %}-dark{% endif %}">
 {% endif %}
diff --git "[ORIGINAL]/leinad4mind\\bestanswer/styles/prosilver/template/event/memberlist_view_user_statistics_after.html" "[FORUM_EXT]/leinad4mind\\bestanswer/styles/prosilver/template/event/memberlist_view_user_statistics_after.html"
--- "[ORIGINAL]/leinad4mind\\bestanswer/styles/prosilver/template/event/memberlist_view_user_statistics_after.html"
+++ "[FORUM_EXT]/leinad4mind\\bestanswer/styles/prosilver/template/event/memberlist_view_user_statistics_after.html"
@@ -2,7 +2,7 @@
 {% INCLUDEJS '@leinad4mind_bestanswer/jxtools.js' %}
 
 <div id="list_inner_hidden_container_1" jxdom-closest="div.column2" jxdom-find="dd:nth-of-type({%if S_WARNINGS %}4{% else %}3{% endif %})" jxdom-action="after" >
-<dt>{{ lang('TOTAL_ANSWERS') ~ lang('COLON') }}</dt>
+<dt>{{ lang('TOTAL_ANSWERS') }}{{ lang('COLON') }}</dt>
 <dd>{{ ANSWERS }}</dd>
 </div>
 {% endif %}
diff --git "[ORIGINAL]/leinad4mind\\bestanswer/styles/prosilver/template/event/search_results_topic_title_after.html" "[FORUM_EXT]/leinad4mind\\bestanswer/styles/prosilver/template/event/search_results_topic_title_after.html"
--- "[ORIGINAL]/leinad4mind\\bestanswer/styles/prosilver/template/event/search_results_topic_title_after.html"
+++ "[FORUM_EXT]/leinad4mind\\bestanswer/styles/prosilver/template/event/search_results_topic_title_after.html"
@@ -4,6 +4,6 @@
 		{% DEFINE INCLUDED_JXTOOLSJS = true %}
 	{% endif %}
 <div id="list_inner_hidden_container_1" jxdom-closest="dl.postprofile" jxdom-find="dd:nth-of-type(3)" jxdom-action="replace" >
-<dd>{{ lang('TOPIC') ~ lang('COLON') }} <i class="icon fa-check fa-fw icon-green" aria-hidden="true"></i> <a href="{{ searchresults.U_VIEW_TOPIC }}">{{ searchresults.TOPIC_TITLE }}</a></dd>
+<dd>{{ lang('TOPIC') }}{{ lang('COLON') }} <i class="icon fa-check fa-fw icon-green" aria-hidden="true"></i> <a href="{{ searchresults.U_VIEW_TOPIC }}">{{ searchresults.TOPIC_TITLE }}</a></dd>
 </div>
 {% endif %}
diff --git "[ORIGINAL]/leinad4mind\\bestanswer/styles/prosilver/template/event/ucp_pm_viewmessage_custom_fields_before.html" "[FORUM_EXT]/leinad4mind\\bestanswer/styles/prosilver/template/event/ucp_pm_viewmessage_custom_fields_before.html"
--- "[ORIGINAL]/leinad4mind\\bestanswer/styles/prosilver/template/event/ucp_pm_viewmessage_custom_fields_before.html"
+++ "[FORUM_EXT]/leinad4mind\\bestanswer/styles/prosilver/template/event/ucp_pm_viewmessage_custom_fields_before.html"
@@ -2,6 +2,6 @@
 {% INCLUDEJS '@leinad4mind_bestanswer/jxtools.js' %}
 
 <dd id="list_inner_hidden_container_{{ MESSAGE_ID }}" jxdom-closest="dl.postprofile" jxdom-find="dd.profile-joined" jxdom-action="before" >
-<div class="profile-answers"><strong>{{ lang('ANSWERS') ~ lang('COLON') }}</strong> {{ AUTHOR_ANSWERS }}</div>
+<div class="profile-answers"><strong>{{ lang('ANSWERS') }}{{ lang('COLON') }}</strong> {{ AUTHOR_ANSWERS }}</div>
 </dd>
 {% endif %}
diff --git "[ORIGINAL]/leinad4mind\\bestanswer/styles/prosilver/template/event/viewtopic_body_postrow_custom_fields_before.html" "[FORUM_EXT]/leinad4mind\\bestanswer/styles/prosilver/template/event/viewtopic_body_postrow_custom_fields_before.html"
--- "[ORIGINAL]/leinad4mind\\bestanswer/styles/prosilver/template/event/viewtopic_body_postrow_custom_fields_before.html"
+++ "[FORUM_EXT]/leinad4mind\\bestanswer/styles/prosilver/template/event/viewtopic_body_postrow_custom_fields_before.html"
@@ -2,6 +2,6 @@
 {% INCLUDEJS '@leinad4mind_bestanswer/jxtools.js' %}
 
 <dd id="list_inner_hidden_container_{{ postrow.POST_ID }}" jxdom-closest="dl.postprofile" jxdom-find="dd.profile-joined" jxdom-action="before" >
-<div class="profile-answers"><strong>{{ lang('ANSWERS') ~ lang('COLON') }}</strong> {{ postrow.POSTER_ANSWERS }}</div>
+<div class="profile-answers"><strong>{{ lang('ANSWERS') }}{{ lang('COLON') }}</strong> {{ postrow.POSTER_ANSWERS }}</div>
 </dd>
 {% endif %}
diff --git "[ORIGINAL]/leinad4mind\\bestanswer/styles/prosilver/template/event/viewtopic_body_postrow_post_after.html" "[ORIGINAL]/leinad4mind\\bestanswer/styles/prosilver/template/event/viewtopic_body_postrow_post_after.html"
deleted file mode 100644
--- "[ORIGINAL]/leinad4mind\\bestanswer/styles/prosilver/template/event/viewtopic_body_postrow_post_after.html"
+++ /dev/null
@@ -1,3 +0,0 @@
-{% if postrow.POST_ID == postrow.ANSWER_POST_ID %}
-	</div>
-{% endif %}
\ No newline at end of file
diff --git "[ORIGINAL]/leinad4mind\\bestanswer/styles/prosilver/template/event/viewtopic_body_postrow_post_before.html" "[FORUM_EXT]/leinad4mind\\bestanswer/styles/prosilver/template/event/viewtopic_body_postrow_post_before.html"
--- "[ORIGINAL]/leinad4mind\\bestanswer/styles/prosilver/template/event/viewtopic_body_postrow_post_before.html"
+++ "[FORUM_EXT]/leinad4mind\\bestanswer/styles/prosilver/template/event/viewtopic_body_postrow_post_before.html"
@@ -1,4 +1,3 @@
 {% if postrow.POST_ID == postrow.ANSWER_POST_ID %}
 <div class="answer hidden"></div>
-	<div class="answer-post{% if S_NIGHTSTAKLER_ENABLED %}-dark{% endif %}">
 {% endif %}
diff --git "[ORIGINAL]/leinad4mind\\bestanswer/styles/prosilver/template/event/viewtopic_body_postrow_post_notices_before.html" "[FORUM_EXT]/leinad4mind\\bestanswer/styles/prosilver/template/event/viewtopic_body_postrow_post_notices_before.html"
--- "[ORIGINAL]/leinad4mind\\bestanswer/styles/prosilver/template/event/viewtopic_body_postrow_post_notices_before.html"
+++ "[FORUM_EXT]/leinad4mind\\bestanswer/styles/prosilver/template/event/viewtopic_body_postrow_post_notices_before.html"
@@ -1,5 +1,5 @@
 {% if postrow.S_FIRST_POST and postrow.ANSWER_POST_ID %}
-<div class="postbody post_answer{% if S_NIGHTSTAKLER_ENABLED %}-dark{% endif %}"><i class="icon fa-check fa-fw icon-green" aria-hidden="true"></i><span class="author">{{ lang('POST_BY_AUTHOR') }} {{ postrow.ANSWER_USERNAME_FULL }} &raquo; {{ postrow.ANSWER_POST_TIME }}</span>
+<div class="postbody post_answer"><i class="icon fa-check fa-fw icon-green" aria-hidden="true"></i><span class="author">{{ lang('POST_BY_AUTHOR') }} {{ postrow.ANSWER_USERNAME_FULL }} &raquo; {{ postrow.ANSWER_POST_TIME }}</span>
 <div class="content">{{ postrow.ANSWER_POST_TEXT }}</div>
 <a href="{{ postrow.U_ANSWER }}">{{ lang('TO_POST') }}</a></div>
 {% endif %}
diff --git "[ORIGINAL]/leinad4mind\\bestanswer/styles/prosilver/theme/bestanswer.css" "[FORUM_EXT]/leinad4mind\\bestanswer/styles/prosilver/theme/bestanswer.css"
--- "[ORIGINAL]/leinad4mind\\bestanswer/styles/prosilver/theme/bestanswer.css"
+++ "[FORUM_EXT]/leinad4mind\\bestanswer/styles/prosilver/theme/bestanswer.css"
@@ -3,7 +3,7 @@
 	background-color: #EAF8E2;
 }
 
-.post_answer, .post_answer-dark {
+.post_answer {
 	background-color: #EAF8E2 !important;
 	padding: 10px;
 	border-radius: 7px;
@@ -19,14 +19,6 @@
 	font-weight: normal;
 }
 
-.answer-post .panel {
-	background-color: #eff9e9 !important;
-}
-
-.post_answer-dark, .answer-post-dark .panel {
-	background-color: #1a3509 !important;
-}
-
 @media (max-width: 700px) {
 	div.profile-answers {
 		display: none;
```
