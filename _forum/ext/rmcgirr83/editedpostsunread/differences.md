Existem diferencas reais no codigo ou texto. Diferencas de formatacao (espacos, tabs) foram ignoradas abaixo.

```diff
diff --git "[FORUM_EXT]/rmcgirr83\\editedpostsunread/diff_full.tmp" "[FORUM_EXT]/rmcgirr83\\editedpostsunread/diff_full.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/rmcgirr83\\editedpostsunread/diff_full.tmp"
@@ -0,0 +1,31 @@
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\editedpostsunread/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\editedpostsunread/diff_full.tmp"
+new file mode 100644
+index 000000000..e69de29bb
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\editedpostsunread/event/listener.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\editedpostsunread/event/listener.php"
+index 5d132adc3..2f2e300c7 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\editedpostsunread/event/listener.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\editedpostsunread/event/listener.php"
+@@ -47,7 +47,7 @@ class listener implements EventSubscriberInterface
+ 
+ 	public function submit_post_end($event)
+ 	{
+-		if ($event['mode'] == 'edit')
++		if ($event['mode'] == 'edit' && $event['data']['topic_first_post_id'] != $event['data']['post_id'])
+ 		{
+ 			// we need to ensure that what we are resetting is appropriate
+ 			// do we care about when someone edits the first post of a topic?
+@@ -82,7 +82,9 @@ class listener implements EventSubscriberInterface
+ 				}
+ 
+ 				update_post_information('forum', $event['data']['forum_id']);
+-				markread('post', $event['data']['forum_id'], $event['data']['topic_id'], $event['data']['post_time']);
++				if(isset($event['data']['post_time'])) {
++					markread('post', $event['data']['forum_id'], $event['data']['topic_id'], $event['data']['post_time']);
++				}
+ 			}
+ 		}
+ 	}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\editedpostsunread/LICENSE.txt" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\editedpostsunread/license.txt"
+similarity index 100%
+rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\editedpostsunread/LICENSE.txt"
+rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\editedpostsunread/license.txt"
diff --git "[FORUM_EXT]/rmcgirr83\\editedpostsunread/diff_nospace.tmp" "[FORUM_EXT]/rmcgirr83\\editedpostsunread/diff_nospace.tmp"
new file mode 100644
diff --git "[ORIGINAL]/rmcgirr83\\editedpostsunread/event/listener.php" "[FORUM_EXT]/rmcgirr83\\editedpostsunread/event/listener.php"
--- "[ORIGINAL]/rmcgirr83\\editedpostsunread/event/listener.php"
+++ "[FORUM_EXT]/rmcgirr83\\editedpostsunread/event/listener.php"
@@ -47,7 +47,7 @@ class listener implements EventSubscriberInterface
 
 	public function submit_post_end($event)
 	{
-		if ($event['mode'] == 'edit')
+		if ($event['mode'] == 'edit' && $event['data']['topic_first_post_id'] != $event['data']['post_id'])
 		{
 			// we need to ensure that what we are resetting is appropriate
 			// do we care about when someone edits the first post of a topic?
@@ -82,8 +82,10 @@ class listener implements EventSubscriberInterface
 				}
 
 				update_post_information('forum', $event['data']['forum_id']);
+				if(isset($event['data']['post_time'])) {
 					markread('post', $event['data']['forum_id'], $event['data']['topic_id'], $event['data']['post_time']);
 				}
 			}
 		}
 	}
+}
diff --git "[ORIGINAL]/rmcgirr83\\editedpostsunread/LICENSE.txt" "[FORUM_EXT]/rmcgirr83\\editedpostsunread/license.txt"
similarity index 100%
rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\editedpostsunread/LICENSE.txt"
rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\editedpostsunread/license.txt"
```
