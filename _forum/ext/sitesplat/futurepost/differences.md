Existem diferencas reais no codigo ou texto. Diferencas de formatacao (espacos, tabs) foram ignoradas abaixo.

```diff
diff --git "[ORIGINAL]/sitesplat\\futurepost/cron/task/core/future_posts.php" "[FORUM_EXT]/sitesplat\\futurepost/cron/task/core/future_posts.php"
--- "[ORIGINAL]/sitesplat\\futurepost/cron/task/core/future_posts.php"
+++ "[FORUM_EXT]/sitesplat\\futurepost/cron/task/core/future_posts.php"
@@ -44,7 +44,7 @@ class future_posts extends \phpbb\cron\task\base
 
 		$sql = 'SELECT post_id
 			FROM ' . POSTS_TABLE . '
-			WHERE post_visibility = ' . ITEM_UNAPPROVED . '
+			WHERE (post_visibility = ' . ITEM_UNAPPROVED . ' OR post_visibility = ' . ITEM_REAPPROVE . ')
 				AND post_future = 1
 				AND post_time < ' . $this->now;
 		$result = $this->db->sql_query($sql);
@@ -168,6 +168,6 @@ class future_posts extends \phpbb\cron\task\base
 
 	public function should_run()
 	{
-		return $this->config['future_posts_last_gc'] < $this->now - 300; // every 5 minutes
+		return $this->config['future_posts_last_gc'] < $this->now - 60; // every minute
 	}
 }
diff --git "[FORUM_EXT]/sitesplat\\futurepost/diff_full.tmp" "[FORUM_EXT]/sitesplat\\futurepost/diff_full.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\futurepost/diff_full.tmp"
@@ -0,0 +1,104 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\futurepost/cron/task/core/future_posts.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\futurepost/cron/task/core/future_posts.php"
+index f448ed93a..d8ec91818 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\futurepost/cron/task/core/future_posts.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\futurepost/cron/task/core/future_posts.php"
+@@ -44,7 +44,7 @@ class future_posts extends \phpbb\cron\task\base
+ 
+ 		$sql = 'SELECT post_id
+ 			FROM ' . POSTS_TABLE . '
+-			WHERE post_visibility = ' . ITEM_UNAPPROVED . '
++			WHERE (post_visibility = ' . ITEM_UNAPPROVED . ' OR post_visibility = ' . ITEM_REAPPROVE . ')
+ 				AND post_future = 1
+ 				AND post_time < ' . $this->now;
+ 		$result = $this->db->sql_query($sql);
+@@ -168,6 +168,6 @@ class future_posts extends \phpbb\cron\task\base
+ 
+ 	public function should_run()
+ 	{
+-		return $this->config['future_posts_last_gc'] < $this->now - 300; // every 5 minutes
++		return $this->config['future_posts_last_gc'] < $this->now - 60; // every minute
+ 	}
+ }
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\futurepost/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\futurepost/diff_full.tmp"
+new file mode 100644
+index 000000000..e69de29bb
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\futurepost/event/listener.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\futurepost/event/listener.php"
+index adfee62f6..f4e4f8f73 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\futurepost/event/listener.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\futurepost/event/listener.php"
+@@ -107,7 +107,7 @@ class listener implements \Symfony\Component\EventDispatcher\EventSubscriberInte
+ 			(
+ 				$event['post_data']['post_time'] > $this->now ||
+ 				$event['mode'] == 'post' ||
+-				($event['mode'] == 'edit' && $event['post_data']['post_visibility'] == ITEM_UNAPPROVED)
++				($event['mode'] == 'edit' && ($event['post_data']['post_visibility'] == ITEM_UNAPPROVED || $event['post_data']['post_visibility'] == ITEM_REAPPROVE))
+ 			)
+ 		)
+ 		{
+@@ -115,7 +115,7 @@ class listener implements \Symfony\Component\EventDispatcher\EventSubscriberInte
+ 
+ 			$event['page_data'] += [
+ 				'S_FUTURE_DATE'	=> $event['post_data']['post_time'] > $this->now,
+-				'D_FUTURE_DATE'	=> ($event['post_data']['post_time'] ?: $this->now + 7200) * 1000,
++				'D_FUTURE_DATE'	=> ($event['post_data']['post_time'] ?: $this->now + 300) * 1000,
+ 				'UU_DATEFORMAT'	=> str_replace(array('g','a','jS','|'), array('h','K','J',''), $this->user->data['user_dateformat']),
+ 			];
+ 		}
+@@ -177,7 +177,7 @@ class listener implements \Symfony\Component\EventDispatcher\EventSubscriberInte
+ 
+ 	public function display_future_status($event)
+ 	{
+-		if ($event['row']['post_future'] && $event['row']['topic_time'] > $this->now - 300) {
++		if ($event['row']['post_future'] && $event['row']['topic_time'] > $this->now - 60) {
+ 			$this->user->add_lang_ext('sitesplat/futurepost', 'futurepost');
+ 
+ 			$event['topic_row'] += [
+@@ -189,7 +189,7 @@ class listener implements \Symfony\Component\EventDispatcher\EventSubscriberInte
+ 	public function mcp_list($event)
+ 	{
+ 		$sql_ary = $event['sql_ary'];
+-		$sql_ary['WHERE'] .= ' AND p.post_time <= ' . ($this->now + 300);
++		$sql_ary['WHERE'] .= ' AND p.post_time <= ' . ($this->now + 60);
+ 		$event['sql_ary'] = $sql_ary;
+ 	}
+ 
+@@ -202,7 +202,7 @@ class listener implements \Symfony\Component\EventDispatcher\EventSubscriberInte
+ 
+ 		$sql = 'SELECT post_id
+ 			FROM ' . $this->posts_table . '
+-			WHERE post_time <= ' . ($this->now + 300) . '
++			WHERE post_time <= ' . ($this->now + 60) . '
+ 				AND ' . $this->db->sql_in_set('post_id', $event['post_list']);
+ 		$result = $this->db->sql_query($sql);
+ 		$post_ids = array_column($this->db->sql_fetchrowset($result), 'post_id');
+@@ -212,7 +212,7 @@ class listener implements \Symfony\Component\EventDispatcher\EventSubscriberInte
+ 
+ 	public function mcp_forum($event)
+ 	{
+-		$event['sql'] = str_replace('WHERE', 'WHERE t.topic_time <= ' . ($this->now + 300) . ' AND', $event['sql']);
++		$event['sql'] = str_replace('WHERE', 'WHERE t.topic_time <= ' . ($this->now + 60) . ' AND', $event['sql']);
+ 	}
+ 
+ 	public function mcp_topic($event)
+@@ -226,10 +226,10 @@ class listener implements \Symfony\Component\EventDispatcher\EventSubscriberInte
+ 			FROM ' . $this->topics_table . '
+ 			WHERE topic_id = ' . (int) $event['topic_id'];
+ 		$result = $this->db->sql_query($sql);
+-		$topic_time = $this->db->sql_fetchfield('topic_time', $result);
++		$topic_time = $this->db->sql_fetchfield('topic_time', false, $result);
+ 		$this->db->sql_freeresult($result);
+ 
+-		if ($topic_time > $this->now - 300)
++		if ($topic_time > $this->now - 60)
+ 		{
+ 			$event['module']->set_display('main', 'topic_view', false);
+ 			$event['module']->set_display('logs', 'topic_logs', false);
+@@ -238,7 +238,7 @@ class listener implements \Symfony\Component\EventDispatcher\EventSubscriberInte
+ 
+ 	public function mcp_queue_topics($event)
+ 	{
+-		$event['sql'] = str_replace('WHERE', 'WHERE t.topic_time <= ' . ($this->now + 300) . ' AND', $event['sql']);
++		$event['sql'] = str_replace('WHERE', 'WHERE t.topic_time <= ' . ($this->now + 60) . ' AND', $event['sql']);
+ 		$this->user->add_lang_ext('sitesplat/futurepost', 'futurepost');
+ 	}
+ }
diff --git "[FORUM_EXT]/sitesplat\\futurepost/diff_nospace.tmp" "[FORUM_EXT]/sitesplat\\futurepost/diff_nospace.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\futurepost/diff_nospace.tmp"
@@ -0,0 +1,61 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\futurepost/cron/task/core/future_posts.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\futurepost/cron/task/core/future_posts.php"
+index f448ed93a..d8ec91818 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\futurepost/cron/task/core/future_posts.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\futurepost/cron/task/core/future_posts.php"
+@@ -44,7 +44,7 @@ class future_posts extends \phpbb\cron\task\base
+ 
+ 		$sql = 'SELECT post_id
+ 			FROM ' . POSTS_TABLE . '
+-			WHERE post_visibility = ' . ITEM_UNAPPROVED . '
++			WHERE (post_visibility = ' . ITEM_UNAPPROVED . ' OR post_visibility = ' . ITEM_REAPPROVE . ')
+ 				AND post_future = 1
+ 				AND post_time < ' . $this->now;
+ 		$result = $this->db->sql_query($sql);
+@@ -168,6 +168,6 @@ class future_posts extends \phpbb\cron\task\base
+ 
+ 	public function should_run()
+ 	{
+-		return $this->config['future_posts_last_gc'] < $this->now - 300; // every 5 minutes
++		return $this->config['future_posts_last_gc'] < $this->now - 60; // every minute
+ 	}
+ }
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\futurepost/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\futurepost/diff_full.tmp"
+new file mode 100644
+index 000000000..7b53a3890
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\futurepost/diff_full.tmp"
+@@ -0,0 +1,104 @@
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\futurepost/cron/task/core/future_posts.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\futurepost/cron/task/core/future_posts.php"
++index f448ed93a..d8ec91818 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\futurepost/cron/task/core/future_posts.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\futurepost/cron/task/core/future_posts.php"
++@@ -44,7 +44,7 @@ class future_posts extends \phpbb\cron\task\base
++ 
++ 		$sql = 'SELECT post_id
++ 			FROM ' . POSTS_TABLE . '
++-			WHERE post_visibility = ' . ITEM_UNAPPROVED . '
+++			WHERE (post_visibility = ' . ITEM_UNAPPROVED . ' OR post_visibility = ' . ITEM_REAPPROVE . ')
++ 				AND post_future = 1
++ 				AND post_time < ' . $this->now;
++ 		$result = $this->db->sql_query($sql);
++@@ -168,6 +168,6 @@ class future_posts extends \phpbb\cron\task\base
++ 
++ 	public function should_run()
++ 	{
++-		return $this->config['future_posts_last_gc'] < $this->now - 300; // every 5 minutes
+++		return $this->config['future_posts_last_gc'] < $this->now - 60; // every minute
++ 	}
++ }
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\futurepost/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\futurepost/diff_full.tmp"
++new file mode 100644
++index 000000000..e69de29bb
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\futurepost/event/listener.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\futurepost/event/listener.php"
++index adfee62f6..f4e4f8f73 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\futurepost/event/listener.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\futurepost/event/listener.php"
++@@ -107,7 +107,7 @@ class listener implements \Symfony\Component\EventDispatcher\EventSubscriberInte
++ 			(
++ 				$event['post_data']['post_time'] > $this->now ||
++ 				$event['mode'] == 'post' ||
++-				($event['mode'] == 'edit' && $event['post_data']['post_visibility'] == ITEM_UNAPPROVED)
+++				($event['mode'] == 'edit' && ($event['post_data']['post_visibility'] == ITEM_UNAPPROVED || $event['post_data']['post_visibility'] == ITEM_REAPPROVE
\ No newline at end of file
diff --git "[ORIGINAL]/sitesplat\\futurepost/event/listener.php" "[FORUM_EXT]/sitesplat\\futurepost/event/listener.php"
--- "[ORIGINAL]/sitesplat\\futurepost/event/listener.php"
+++ "[FORUM_EXT]/sitesplat\\futurepost/event/listener.php"
@@ -107,7 +107,7 @@ class listener implements \Symfony\Component\EventDispatcher\EventSubscriberInte
 			(
 				$event['post_data']['post_time'] > $this->now ||
 				$event['mode'] == 'post' ||
-				($event['mode'] == 'edit' && $event['post_data']['post_visibility'] == ITEM_UNAPPROVED)
+				($event['mode'] == 'edit' && ($event['post_data']['post_visibility'] == ITEM_UNAPPROVED || $event['post_data']['post_visibility'] == ITEM_REAPPROVE))
 			)
 		)
 		{
@@ -115,7 +115,7 @@ class listener implements \Symfony\Component\EventDispatcher\EventSubscriberInte
 
 			$event['page_data'] += [
 				'S_FUTURE_DATE'	=> $event['post_data']['post_time'] > $this->now,
-				'D_FUTURE_DATE'	=> ($event['post_data']['post_time'] ?: $this->now + 7200) * 1000,
+				'D_FUTURE_DATE'	=> ($event['post_data']['post_time'] ?: $this->now + 300) * 1000,
 				'UU_DATEFORMAT'	=> str_replace(array('g','a','jS','|'), array('h','K','J',''), $this->user->data['user_dateformat']),
 			];
 		}
@@ -177,7 +177,7 @@ class listener implements \Symfony\Component\EventDispatcher\EventSubscriberInte
 
 	public function display_future_status($event)
 	{
-		if ($event['row']['post_future'] && $event['row']['topic_time'] > $this->now - 300) {
+		if ($event['row']['post_future'] && $event['row']['topic_time'] > $this->now - 60) {
 			$this->user->add_lang_ext('sitesplat/futurepost', 'futurepost');
 
 			$event['topic_row'] += [
@@ -189,7 +189,7 @@ class listener implements \Symfony\Component\EventDispatcher\EventSubscriberInte
 	public function mcp_list($event)
 	{
 		$sql_ary = $event['sql_ary'];
-		$sql_ary['WHERE'] .= ' AND p.post_time <= ' . ($this->now + 300);
+		$sql_ary['WHERE'] .= ' AND p.post_time <= ' . ($this->now + 60);
 		$event['sql_ary'] = $sql_ary;
 	}
 
@@ -202,7 +202,7 @@ class listener implements \Symfony\Component\EventDispatcher\EventSubscriberInte
 
 		$sql = 'SELECT post_id
 			FROM ' . $this->posts_table . '
-			WHERE post_time <= ' . ($this->now + 300) . '
+			WHERE post_time <= ' . ($this->now + 60) . '
 				AND ' . $this->db->sql_in_set('post_id', $event['post_list']);
 		$result = $this->db->sql_query($sql);
 		$post_ids = array_column($this->db->sql_fetchrowset($result), 'post_id');
@@ -212,7 +212,7 @@ class listener implements \Symfony\Component\EventDispatcher\EventSubscriberInte
 
 	public function mcp_forum($event)
 	{
-		$event['sql'] = str_replace('WHERE', 'WHERE t.topic_time <= ' . ($this->now + 300) . ' AND', $event['sql']);
+		$event['sql'] = str_replace('WHERE', 'WHERE t.topic_time <= ' . ($this->now + 60) . ' AND', $event['sql']);
 	}
 
 	public function mcp_topic($event)
@@ -226,10 +226,10 @@ class listener implements \Symfony\Component\EventDispatcher\EventSubscriberInte
 			FROM ' . $this->topics_table . '
 			WHERE topic_id = ' . (int) $event['topic_id'];
 		$result = $this->db->sql_query($sql);
-		$topic_time = $this->db->sql_fetchfield('topic_time', $result);
+		$topic_time = $this->db->sql_fetchfield('topic_time', false, $result);
 		$this->db->sql_freeresult($result);
 
-		if ($topic_time > $this->now - 300)
+		if ($topic_time > $this->now - 60)
 		{
 			$event['module']->set_display('main', 'topic_view', false);
 			$event['module']->set_display('logs', 'topic_logs', false);
@@ -238,7 +238,7 @@ class listener implements \Symfony\Component\EventDispatcher\EventSubscriberInte
 
 	public function mcp_queue_topics($event)
 	{
-		$event['sql'] = str_replace('WHERE', 'WHERE t.topic_time <= ' . ($this->now + 300) . ' AND', $event['sql']);
+		$event['sql'] = str_replace('WHERE', 'WHERE t.topic_time <= ' . ($this->now + 60) . ' AND', $event['sql']);
 		$this->user->add_lang_ext('sitesplat/futurepost', 'futurepost');
 	}
 }
```
