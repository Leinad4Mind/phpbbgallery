Existem diferencas reais no codigo ou texto. Diferencas de formatacao (espacos, tabs) foram ignoradas abaixo.

```diff
diff --git "[ORIGINAL]/leinad4mind\\topicstatistics/composer.json" "[FORUM_EXT]/leinad4mind\\topicstatistics/composer.json"
--- "[ORIGINAL]/leinad4mind\\topicstatistics/composer.json"
+++ "[FORUM_EXT]/leinad4mind\\topicstatistics/composer.json"
@@ -5,7 +5,7 @@
     "homepage": "https://leinad4mind.top/forum",
     "version": "1.0.2",
     "time": "2022-05-17",
-    "license": "GPL-2.0",
+    "license": "GPL-2.0-only",
     "authors": [
         {
             "name": "leinad4mind",
diff --git "[FORUM_EXT]/leinad4mind\\topicstatistics/diff_full.tmp" "[FORUM_EXT]/leinad4mind\\topicstatistics/diff_full.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/leinad4mind\\topicstatistics/diff_full.tmp"
@@ -0,0 +1,55 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\topicstatistics/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\topicstatistics/composer.json"
+index e46f04a47..5b688b5c2 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\topicstatistics/composer.json"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\topicstatistics/composer.json"
+@@ -5,7 +5,7 @@
+     "homepage": "https://leinad4mind.top/forum",
+     "version": "1.0.2",
+     "time": "2022-05-17",
+-    "license": "GPL-2.0",
++    "license": "GPL-2.0-only",
+     "authors": [
+         {
+             "name": "leinad4mind",
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\topicstatistics/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\topicstatistics/diff_full.tmp"
+new file mode 100644
+index 000000000..e69de29bb
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\topicstatistics/event/main_listener.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\topicstatistics/event/main_listener.php"
+index 89dd8baf3..49dd4cc59 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\topicstatistics/event/main_listener.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\topicstatistics/event/main_listener.php"
+@@ -371,9 +371,9 @@ class main_listener implements EventSubscriberInterface
+          $this->language->add_lang('acp', 'leinad4mind/topicstatistics');
+ 
+          $config = [
+-            'topics_display_statistics'        => ['lang' => 'TS_TOPICS_ENABLED', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => false],
+             'user_limit'                       => ['lang' => 'TS_USER_LIMIT_MAX', 'validate' => 'int:0:9999', 'type' => 'number:0:9999', 'explain' => true],
+             'user_viewprofile'                 => ['lang' => 'TS_USER_PROFILE_LINK', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => true],
++            'topics_display_statistics'        => ['lang' => 'TS_TOPICS_ENABLED', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => false],
+             'topics_display_visit'             => ['lang' => 'TS_TOPICS_VISIT', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => true],
+             'topics_display_bookmarks'         => ['lang' => 'TS_TOPICS_BOOKMARK', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => true],
+             'topics_display_bookmarks_users'   => ['lang' => 'TS_TOPICS_BOOKMARK_USERS', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => true],
+@@ -393,4 +393,4 @@ class main_listener implements EventSubscriberInterface
+          $event['display_vars'] = $display_vars;
+       }
+    }
+-}
+\ No newline at end of file
++}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\topicstatistics/migrations/m1_initial_data.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\topicstatistics/migrations/m1_initial_data.php"
+index 7505b43f6..9b07197df 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\topicstatistics/migrations/m1_initial_data.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\topicstatistics/migrations/m1_initial_data.php"
+@@ -35,6 +35,7 @@ class m1_initial_data extends migration
+          ['config.add', ['topics_display_bookmarks_users', 1]],
+          ['config.add', ['topics_display_followers', 1]],
+          ['config.add', ['topics_display_followers_users', 1]],
++         ['config.add', ['topics_display_followers_avatars', 1]],
+       ];
+    }
+ }
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\topicstatistics/styles/FLATBOOTS/template/event/viewtopic_body_poll_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\topicstatistics/styles/FLATBOOTS/template/event/viewtopic_body_postrow_before.html"
+similarity index 100%
+rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\topicstatistics/styles/FLATBOOTS/template/event/viewtopic_body_poll_after.html"
+rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\topicstatistics/styles/FLATBOOTS/template/event/viewtopic_body_postrow_before.html"
diff --git "[FORUM_EXT]/leinad4mind\\topicstatistics/diff_nospace.tmp" "[FORUM_EXT]/leinad4mind\\topicstatistics/diff_nospace.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/leinad4mind\\topicstatistics/diff_nospace.tmp"
@@ -0,0 +1,51 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\topicstatistics/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\topicstatistics/composer.json"
+index e46f04a47..5b688b5c2 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\topicstatistics/composer.json"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\topicstatistics/composer.json"
+@@ -5,7 +5,7 @@
+     "homepage": "https://leinad4mind.top/forum",
+     "version": "1.0.2",
+     "time": "2022-05-17",
+-    "license": "GPL-2.0",
++    "license": "GPL-2.0-only",
+     "authors": [
+         {
+             "name": "leinad4mind",
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\topicstatistics/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\topicstatistics/diff_full.tmp"
+new file mode 100644
+index 000000000..d95155c42
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\topicstatistics/diff_full.tmp"
+@@ -0,0 +1,55 @@
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\topicstatistics/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\topicstatistics/composer.json"
++index e46f04a47..5b688b5c2 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\topicstatistics/composer.json"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\topicstatistics/composer.json"
++@@ -5,7 +5,7 @@
++     "homepage": "https://leinad4mind.top/forum",
++     "version": "1.0.2",
++     "time": "2022-05-17",
++-    "license": "GPL-2.0",
+++    "license": "GPL-2.0-only",
++     "authors": [
++         {
++             "name": "leinad4mind",
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\topicstatistics/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\topicstatistics/diff_full.tmp"
++new file mode 100644
++index 000000000..e69de29bb
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\topicstatistics/event/main_listener.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\topicstatistics/event/main_listener.php"
++index 89dd8baf3..49dd4cc59 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\topicstatistics/event/main_listener.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\topicstatistics/event/main_listener.php"
++@@ -371,9 +371,9 @@ class main_listener implements EventSubscriberInterface
++          $this->language->add_lang('acp', 'leinad4mind/topicstatistics');
++ 
++          $config = [
++-            'topics_display_statistics'        => ['lang' => 'TS_TOPICS_ENABLED', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => false],
++             'user_limit'                       => ['lang' => 'TS_USER_LIMIT_MAX', 'validate' => 'int:0:9999', 'type' => 'number:0:9999', 'explain' => true],
++             'user_viewprofile'                 => ['lang' => 'TS_USER_PROFILE_LINK', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => true],
+++            'topics_display_statistics'        => ['lang' => 'TS_TOPICS_ENABLED', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => false],
++             'topics_display_visit'             => ['lang' => 'TS_TOPICS_VISIT', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => true],
++             'topics_display_bookmarks'         => ['lang' => 'TS_TOPICS_BOOKMARK', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => true],
++             'topics_display_bookmarks_users'   => ['lang' => 'TS_TOPICS_BOOKMARK_USERS', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => true],
++@@ -393,4 +393,4 @@ class main_li
\ No newline at end of file
diff --git "[ORIGINAL]/leinad4mind\\topicstatistics/event/main_listener.php" "[FORUM_EXT]/leinad4mind\\topicstatistics/event/main_listener.php"
--- "[ORIGINAL]/leinad4mind\\topicstatistics/event/main_listener.php"
+++ "[FORUM_EXT]/leinad4mind\\topicstatistics/event/main_listener.php"
@@ -371,9 +371,9 @@ class main_listener implements EventSubscriberInterface
          $this->language->add_lang('acp', 'leinad4mind/topicstatistics');
 
          $config = [
-            'topics_display_statistics'        => ['lang' => 'TS_TOPICS_ENABLED', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => false],
             'user_limit'                       => ['lang' => 'TS_USER_LIMIT_MAX', 'validate' => 'int:0:9999', 'type' => 'number:0:9999', 'explain' => true],
             'user_viewprofile'                 => ['lang' => 'TS_USER_PROFILE_LINK', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => true],
+            'topics_display_statistics'        => ['lang' => 'TS_TOPICS_ENABLED', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => false],
             'topics_display_visit'             => ['lang' => 'TS_TOPICS_VISIT', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => true],
             'topics_display_bookmarks'         => ['lang' => 'TS_TOPICS_BOOKMARK', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => true],
             'topics_display_bookmarks_users'   => ['lang' => 'TS_TOPICS_BOOKMARK_USERS', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => true],
diff --git "[ORIGINAL]/leinad4mind\\topicstatistics/migrations/m1_initial_data.php" "[FORUM_EXT]/leinad4mind\\topicstatistics/migrations/m1_initial_data.php"
--- "[ORIGINAL]/leinad4mind\\topicstatistics/migrations/m1_initial_data.php"
+++ "[FORUM_EXT]/leinad4mind\\topicstatistics/migrations/m1_initial_data.php"
@@ -35,6 +35,7 @@ class m1_initial_data extends migration
          ['config.add', ['topics_display_bookmarks_users', 1]],
          ['config.add', ['topics_display_followers', 1]],
          ['config.add', ['topics_display_followers_users', 1]],
+         ['config.add', ['topics_display_followers_avatars', 1]],
       ];
    }
 }
\ No newline at end of file
diff --git "[ORIGINAL]/leinad4mind\\topicstatistics/styles/FLATBOOTS/template/event/viewtopic_body_poll_after.html" "[FORUM_EXT]/leinad4mind\\topicstatistics/styles/FLATBOOTS/template/event/viewtopic_body_postrow_before.html"
similarity index 100%
rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\topicstatistics/styles/FLATBOOTS/template/event/viewtopic_body_poll_after.html"
rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\topicstatistics/styles/FLATBOOTS/template/event/viewtopic_body_postrow_before.html"
```
