Existem diferencas reais no codigo ou texto. Diferencas de formatacao (espacos, tabs) foram ignoradas abaixo.

```diff
diff --git "[ORIGINAL]/leinad4mind\\likepoints/adm/style/event/acp_forums_normal_settings_append.html" "[FORUM_EXT]/leinad4mind\\likepoints/adm/style/event/acp_forums_normal_settings_append.html"
--- "[ORIGINAL]/leinad4mind\\likepoints/adm/style/event/acp_forums_normal_settings_append.html"
+++ "[FORUM_EXT]/leinad4mind\\likepoints/adm/style/event/acp_forums_normal_settings_append.html"
@@ -1,6 +1,6 @@
 <dl>
   <dt>
-    <label for="per_likes_enabled">{{ lang('PER_LIKES_ENABLE') ~ lang('COLON') }}</label>
+    <label for="per_likes_enabled">{{ lang('PER_LIKES_ENABLE') }}{{ lang('COLON') }}</label>
   </dt>
   <dd>
     <label><input type="radio" class="radio" name="per_likes_enabled" value="1" {% if S_ENABLE_LIKES %} id="per_likes_enabled" checked="checked" {% endif %}/>
@@ -12,7 +12,7 @@
 
 <dl>
   <dt>
-    <label for="contributors_enabled">{{ lang('CONTRIBUTORS_ENABLE') ~ lang('COLON') }}</label>
+    <label for="contributors_enabled">{{ lang('CONTRIBUTORS_ENABLE') }}{{ lang('COLON') }}</label>
   </dt>
   <dd>
     <label><input type="radio" class="radio" name="contributors_enabled" value="1" {% if S_ENABLE_CONTRIBUTORS %} id="contributors_enabled" checked="checked" {% endif %}/>
@@ -24,9 +24,9 @@
 
 <dl>
   <dt>
-    <label for="per_likes_amount">{{ lang('PER_LIKES_AMOUNT') ~ lang('COLON') }}</label>
+    <label for="per_likes_amount">{{ lang('PER_LIKES_AMOUNT') }}{{ lang('COLON') }}</label>
   </dt>
   <dd>
-    <label><input type="number" name="per_likes_amount" value="{{ PERLIKES_AMOUNT }}" min="0" max="9999"></label>
+    <label><input type="number" name="per_likes_amount" value="{{ PERLIKES_AMOUNT }}" min="0" max="99999"></label>
   </dd>
 </dl>
diff --git "[ORIGINAL]/leinad4mind\\likepoints/adm/style/event/sitesplat_bbpoints_acp_after_manage_bbpoints_points_registration_field.html" "[FORUM_EXT]/leinad4mind\\likepoints/adm/style/event/sitesplat_bbpoints_acp_after_manage_bbpoints_points_registration_field.html"
--- "[ORIGINAL]/leinad4mind\\likepoints/adm/style/event/sitesplat_bbpoints_acp_after_manage_bbpoints_points_registration_field.html"
+++ "[FORUM_EXT]/leinad4mind\\likepoints/adm/style/event/sitesplat_bbpoints_acp_after_manage_bbpoints_points_registration_field.html"
@@ -1,8 +1,8 @@
 <dl>
-  <dt><label for="per_likes">{L_ACP_POINTS}{L_COLON}</label><br /><span>{L_ACP_POINTS_PERLIKES_EXPLAIN}</span></dt>
+  <dt><label for="per_likes">{L_ACP_POINTS}{L_COLON}</label><br /><span>{L_ACP_POINTS_PER_LIKES_EXPLAIN}</span></dt>
   <dd>
     <div style="float:left;width:100%;font-size:0.85em">
-      {L_POINTS_PERLIKES}
+      {L_ACP_POINTS_PER_LIKES}
     </div>
   </dd>
   <dd>
diff --git "[ORIGINAL]/leinad4mind\\likepoints/adm/style/event/sitesplat_bbpoints_acp_after_manage_bbpoints_points_sync_points_field.html" "[FORUM_EXT]/leinad4mind\\likepoints/adm/style/event/sitesplat_bbpoints_acp_after_manage_bbpoints_points_sync_points_field.html"
--- "[ORIGINAL]/leinad4mind\\likepoints/adm/style/event/sitesplat_bbpoints_acp_after_manage_bbpoints_points_sync_points_field.html"
+++ "[FORUM_EXT]/leinad4mind\\likepoints/adm/style/event/sitesplat_bbpoints_acp_after_manage_bbpoints_points_sync_points_field.html"
@@ -17,9 +17,9 @@
       </div>
     </div>
     <br/>
-    <div id="sync_like_points-processing" style="display: none;">Processing ...</div>
+    <div id="sync_like_points-processing" style="display: none;">{L_SYNC_LIKE_POINTS_PROCESSING}</div>
     <br/>
-    <div id="sync_like_points-summary" style="display: none;">Total posts:
+    <div id="sync_like_points-summary" style="display: none;">{L_SYNC_LIKE_POINTS_TOTAL_POSTS}{L_COLON}
       <span id="total-posts"></span></div>
   </dd>
 </dl>
diff --git "[ORIGINAL]/leinad4mind\\likepoints/composer.json" "[FORUM_EXT]/leinad4mind\\likepoints/composer.json"
--- "[ORIGINAL]/leinad4mind\\likepoints/composer.json"
+++ "[FORUM_EXT]/leinad4mind\\likepoints/composer.json"
@@ -2,14 +2,12 @@
     "name": "leinad4mind/likepoints",
     "type": "phpbb-extension",
     "description": "Bridge between the BBPoints and LikeDD extensions",
-    "homepage": "https://leinad4mind.top/forum/",
-    "version": "2.1.0",
-    "time": "2025-08-16",
+    "version": "2.0.0",
+    "time": "2022-05-25",
     "license": "Proprietary",
     "authors": [
         {
             "name": "Leinad4Mind",
-            "homepage": "https://leinad4mind.top/forum",
             "role": "Developer"
         }
     ],
@@ -21,12 +19,6 @@
         "display-name": "Bridge BBPoints and LikeDD",
         "soft-require": {
             "phpbb/phpbb": ">=3.3.4"
-        },
-        "version-check": {
-            "host": "leinad4mind.top",
-            "directory": "/phpbb/likepoints",
-            "filename": "version_check.json",
-            "ssl": true
         }
     }
 }
diff --git "[ORIGINAL]/leinad4mind\\likepoints/controller/admin_controller.php" "[FORUM_EXT]/leinad4mind\\likepoints/controller/admin_controller.php"
--- "[ORIGINAL]/leinad4mind\\likepoints/controller/admin_controller.php"
+++ "[FORUM_EXT]/leinad4mind\\likepoints/controller/admin_controller.php"
@@ -4,7 +4,7 @@
  *
  * LikePoints extension for the phpBB Forum Software package.
  *
- * @copyright (c) 2022-2025 Leinad4Mind All rights reserved
+ * @copyright (c) 2022 Leinad4Mind All rights reserved
  * @license Proprietary
  *
  */
@@ -54,9 +54,8 @@ class admin_controller
   public function get_default_likepoint_amount()
   {
     $sql = "SELECT config_value FROM $this->config_table WHERE config_name = 'bbpoints_settings' LIMIT 1";
-    $result = $this->db->sql_query($sql);
-    $config = $this->db->sql_fetchfield('config_value', $result);
-    $this->db->sql_freeresult($result);
+    $this->db->sql_query($sql);
+    $config  = $this->db->sql_fetchfield('config_value');
     $config = json_decode($config, true);
     return (int) ($config['per_likes'] ?? 10);
   }
@@ -187,7 +186,7 @@ class admin_controller
 
   protected function get_contributors($post_id)
   {
-    $sql = 'SELECT contributors FROM ' . POSTS_TABLE . ' WHERE post_id = ' . (int) $post_id . ' LIMIT 1';
+    $sql = 'SELECT contributors FROM ' . POSTS_TABLE . ' WHERE post_id = ' . $post_id . ' LIMIT 1';
     $this->db->sql_query($sql);
     $contributors = $this->db->sql_fetchfield('contributors');
     if ($contributors === '') {
diff --git "[ORIGINAL]/leinad4mind\\likepoints/controller/main.php" "[FORUM_EXT]/leinad4mind\\likepoints/controller/main.php"
--- "[ORIGINAL]/leinad4mind\\likepoints/controller/main.php"
+++ "[FORUM_EXT]/leinad4mind\\likepoints/controller/main.php"
@@ -4,7 +4,7 @@
  *
  * LikePoints extension for the phpBB Forum Software package.
  *
- * @copyright (c) 2022-2025 Leinad4Mind All rights reserved
+ * @copyright (c) 2022 Leinad4Mind All rights reserved
  * @license Proprietary
  *
  */
@@ -49,33 +49,31 @@ class main
    {
       if ($this->request->is_ajax()) {
          $json_response = new json_response();
-         $term = $this->request->variable('term', '');
+         $term = $this->request->variable('term', '', true);
          $term = strtolower(trim($term));
          if (empty($term)) {
             $json_response->send([]);
             return;
          }
          $mode = $this->request->variable('mode', 'post');
-         $post_id = (int) $this->request->variable('p', '');
-         $topic_id = (int) $this->request->variable('topic_id', '');
+         $post_id = $this->request->variable('p', '');
+         $topic_id = $this->request->variable('topic_id', '');
 
-         $predicate = ' AND u.username_clean ' . $this->db->sql_like_expression($term . $this->db->get_any_char());
+         $like = $this->db->sql_like_expression($this->db->sql_escape($term) . $this->db->get_any_char());
+
+         $predicate = ' AND u.username_clean ' . $like;
          if (($mode == 'edit' || $mode == 'reply') && empty($topic_id)) {
             $sql = 'SELECT topic_id FROM ' . $this->posts_table . ' WHERE post_id = ' . $post_id;
             $result = $this->db->sql_query($sql);
             $row = $this->db->sql_fetchrow($result);
-            $topic_id = $row['topic_id'] ?? 0;
+            $topic_id = $row['topic_id'];
          }
          if (!empty($topic_id)) {
-            $sql = 'SELECT poster_id FROM ' . $this->posts_table . ' WHERE topic_id = ' . $topic_id;
-            $result = $this->db->sql_query($sql);
-            $poster_ids = [];
-            while ($row = $this->db->sql_fetchrow($result)) {
-               $poster_ids[] = $row['poster_id'];
-            }
-            if (!empty($poster_ids)) {
-               $predicate .= ' AND u.user_id NOT IN(' . implode(',', array_map('intval', $poster_ids)) . ')';
-            }
+            $sql = 'SELECT poster_id FROM ' . $this->posts_table . ' WHERE topic_id = ' . $topic_id . ' ORDER BY post_time ASC';
+            $result = $this->db->sql_query_limit($sql, 1);
+            $row = $this->db->sql_fetchrow($result);
+            $author_id = (int) $row['poster_id'];
+            $predicate .= ' AND u.user_id != ' . $author_id;
          }
 
          $sql = 'SELECT DISTINCT(u.username), u.user_id, user_avatar, user_avatar_type, user_avatar_width, user_avatar_height
@@ -84,7 +82,6 @@ class main
                ORDER BY u.user_posts DESC';
          $result = $this->db->sql_query_limit($sql, 10);
          $usernames = [];
-         $style_path = $this->user->style['style_path'] ?? 'prosilver';
          while ($row = $this->db->sql_fetchrow($result)) {
             $usernames[] = [
                $row['username'],
@@ -98,7 +95,7 @@ class main
                   )
                ) . ' ' . $row['username'] . '</div>' :
                   '<div class="nemtion"><img src="' .
-                  generate_board_url() . '/styles/' . $style_path . '/theme/images/no-avatar.png'
+                  generate_board_url() . '/styles/' . $this->user->style['style_path'] . '/theme/images/no-avatar.png'
                   . '"> ' . $row['username'] . '</div>',
             ];
          }
diff --git "[FORUM_EXT]/leinad4mind\\likepoints/diff_full.tmp" "[FORUM_EXT]/leinad4mind\\likepoints/diff_full.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/leinad4mind\\likepoints/diff_full.tmp"
@@ -0,0 +1,1054 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\likepoints/adm/style/event/acp_forums_normal_settings_append.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/adm/style/event/acp_forums_normal_settings_append.html"
+index df5159f7d..0a9302ef2 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\likepoints/adm/style/event/acp_forums_normal_settings_append.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/adm/style/event/acp_forums_normal_settings_append.html"
+@@ -1,6 +1,6 @@
+ <dl>
+   <dt>
+-    <label for="per_likes_enabled">{{ lang('PER_LIKES_ENABLE') ~ lang('COLON') }}</label>
++    <label for="per_likes_enabled">{{ lang('PER_LIKES_ENABLE') }}{{ lang('COLON') }}</label>
+   </dt>
+   <dd>
+     <label><input type="radio" class="radio" name="per_likes_enabled" value="1" {% if S_ENABLE_LIKES %} id="per_likes_enabled" checked="checked" {% endif %}/>
+@@ -12,7 +12,7 @@
+ 
+ <dl>
+   <dt>
+-    <label for="contributors_enabled">{{ lang('CONTRIBUTORS_ENABLE') ~ lang('COLON') }}</label>
++    <label for="contributors_enabled">{{ lang('CONTRIBUTORS_ENABLE') }}{{ lang('COLON') }}</label>
+   </dt>
+   <dd>
+     <label><input type="radio" class="radio" name="contributors_enabled" value="1" {% if S_ENABLE_CONTRIBUTORS %} id="contributors_enabled" checked="checked" {% endif %}/>
+@@ -24,9 +24,9 @@
+ 
+ <dl>
+   <dt>
+-    <label for="per_likes_amount">{{ lang('PER_LIKES_AMOUNT') ~ lang('COLON') }}</label>
++    <label for="per_likes_amount">{{ lang('PER_LIKES_AMOUNT') }}{{ lang('COLON') }}</label>
+   </dt>
+   <dd>
+-    <label><input type="number" name="per_likes_amount" value="{{ PERLIKES_AMOUNT }}" min="0" max="9999"></label>
++    <label><input type="number" name="per_likes_amount" value="{{ PERLIKES_AMOUNT }}" min="0" max="99999"></label>
+   </dd>
+ </dl>
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\likepoints/adm/style/event/sitesplat_bbpoints_acp_after_manage_bbpoints_points_registration_field.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/adm/style/event/sitesplat_bbpoints_acp_after_manage_bbpoints_points_registration_field.html"
+index d1d8a6abc..807f614b2 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\likepoints/adm/style/event/sitesplat_bbpoints_acp_after_manage_bbpoints_points_registration_field.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/adm/style/event/sitesplat_bbpoints_acp_after_manage_bbpoints_points_registration_field.html"
+@@ -1,8 +1,8 @@
+ <dl>
+-  <dt><label for="per_likes">{L_ACP_POINTS}{L_COLON}</label><br /><span>{L_ACP_POINTS_PERLIKES_EXPLAIN}</span></dt>
++  <dt><label for="per_likes">{L_ACP_POINTS}{L_COLON}</label><br /><span>{L_ACP_POINTS_PER_LIKES_EXPLAIN}</span></dt>
+   <dd>
+     <div style="float:left;width:100%;font-size:0.85em">
+-      {L_POINTS_PERLIKES}
++      {L_ACP_POINTS_PER_LIKES}
+     </div>
+   </dd>
+   <dd>
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\likepoints/adm/style/event/sitesplat_bbpoints_acp_after_manage_bbpoints_points_sync_points_field.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/adm/style/event/sitesplat_bbpoints_acp_after_manage_bbpoints_points_sync_points_field.html"
+index eccc0daf3..52b8a6baf 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\likepoints/adm/style/event/sitesplat_bbpoints_acp_after_manage_bbpoints_points_sync_points_field.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/adm/style/event/sitesplat_bbpoints_acp_after_manage_bbpoints_points_sync_points_field.html"
+@@ -17,9 +17,9 @@
+       </div>
+     </div>
+     <br/>
+-    <div id="sync_like_points-processing" style="display: none;">Processing ...</div>
++    <div id="sync_like_points-processing" style="display: none;">{L_SYNC_LIKE_POINTS_PROCESSING}</div>
+     <br/>
+-    <div id="sync_like_points-summary" style="display: none;">Total posts:
++    <div id="sync_like_points-summary" style="display: none;">{L_SYNC_LIKE_POINTS_TOTAL_POSTS}{L_COLON}
+       <span id="total-posts"></span></div>
+   </dd>
+ </dl>
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\likepoints/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/composer.json"
+index fbc821998..fac083642 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\likepoints/composer.json"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/composer.json"
+@@ -2,14 +2,12 @@
+     "name": "leinad4mind/likepoints",
+     "type": "phpbb-extension",
+     "description": "Bridge between the BBPoints and LikeDD extensions",
+-    "homepage": "https://leinad4mind.top/forum/",
+-    "version": "2.1.0",
+-    "time": "2025-08-16",
++    "version": "2.0.0",
++    "time": "2022-05-25",
+     "license": "Proprietary",
+     "authors": [
+         {
+             "name": "Leinad4Mind",
+-            "homepage": "https://leinad4mind.top/forum",
+             "role": "Developer"
+         }
+     ],
+@@ -21,12 +19,6 @@
+         "display-name": "Bridge BBPoints and LikeDD",
+         "soft-require": {
+             "phpbb/phpbb": ">=3.3.4"
+-        },
+-        "version-check": {
+-            "host": "leinad4mind.top",
+-            "directory": "/phpbb/likepoints",
+-            "filename": "version_check.json",
+-            "ssl": true
+         }
+     }
+ }
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\likepoints/controller/admin_controller.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/controller/admin_controller.php"
+index cea87e5c5..07ae97e1d 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\likepoints/controller/admin_controller.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/controller/admin_controller.php"
+@@ -4,7 +4,7 @@
+  *
+  * LikePoints extension for the phpBB Forum Software package.
+  *
+- * @copyright (c) 2022-2025 Leinad4Mind All rights reserved
++ * @copyright (c) 2022 Leinad4Mind All rights reserved
+  * @license Proprietary
+  *
+  */
+@@ -54,9 +54,8 @@ class admin_controller
+   public function get_default_likepoint_amount()
+   {
+     $sql = "SELECT config_value FROM $this->config_table WHERE config_name = 'bbpoints_settings' LIMIT 1";
+-    $result = $this->db->sql_query($sql);
+-    $config = $this->db->sql_fetchfield('config_value', $result);
+-    $this->db->sql_freeresult($result);
++    $this->db->sql_query($sql);
++    $config  = $this->db->sql_fetchfield('config_value');
+     $config = json_decode($config, true);
+     return (int) ($config['per_likes'] ?? 10);
+   }
+@@ -187,7 +186,7 @@ class admin_controller
+ 
+   protected function get_contributors($post_id)
+   {
+-    $sql = 'SELECT contributors FROM ' . POSTS_TABLE . ' WHERE post_id = ' . (int) $post_id . ' LIMIT 1';
++    $sql = 'SELECT contributors FROM ' . POSTS_TABLE . ' WHERE post_id = ' . $post_id . ' LIMIT 1';
+     $this->db->sql_query($sql);
+     $contributors = $this->db->sql_fetchfield('contributors');
+     if ($contributors === '') {
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\likepoints/controller/main.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/controller/main.php"
+index 4a947ec97..670c0696d 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\likepoints/controller/main.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/controller/main.php"
+@@ -4,7 +4,7 @@
+  *
+  * LikePoints extension for the phpBB Forum Software package.
+  *
+- * @copyright (c) 2022-2025 Leinad4Mind All rights reserved
++ * @copyright (c) 2022 Leinad4Mind All rights reserved
+  * @license Proprietary
+  *
+  */
+@@ -49,42 +49,39 @@ class main
+    {
+       if ($this->request->is_ajax()) {
+          $json_response = new json_response();
+-         $term = $this->request->variable('term', '');
++         $term = $this->request->variable('term', '', true);
+          $term = strtolower(trim($term));
+          if (empty($term)) {
+             $json_response->send([]);
+             return;
+          }
+          $mode = $this->request->variable('mode', 'post');
+-         $post_id = (int) $this->request->variable('p', '');
+-         $topic_id = (int) $this->request->variable('topic_id', '');
++         $post_id = $this->request->variable('p', '');
++         $topic_id = $this->request->variable('topic_id', '');
+ 
+-         $predicate = ' AND u.username_clean ' . $this->db->sql_like_expression($term . $this->db->get_any_char());
++         $like = $this->db->sql_like_expression($this->db->sql_escape($term) . $this->db->get_any_char());
++
++         $predicate = ' AND u.username_clean ' . $like;
+          if (($mode == 'edit' || $mode == 'reply') && empty($topic_id)) {
+             $sql = 'SELECT topic_id FROM ' . $this->posts_table . ' WHERE post_id = ' . $post_id;
+             $result = $this->db->sql_query($sql);
+             $row = $this->db->sql_fetchrow($result);
+-            $topic_id = $row['topic_id'] ?? 0;
++            $topic_id = $row['topic_id'];
+          }
+          if (!empty($topic_id)) {
+-            $sql = 'SELECT poster_id FROM ' . $this->posts_table . ' WHERE topic_id = ' . $topic_id;
+-            $result = $this->db->sql_query($sql);
+-            $poster_ids = [];
+-            while ($row = $this->db->sql_fetchrow($result)) {
+-               $poster_ids[] = $row['poster_id'];
+-            }
+-            if (!empty($poster_ids)) {
+-               $predicate .= ' AND u.user_id NOT IN(' . implode(',', array_map('intval', $poster_ids)) . ')';
+-            }
++            $sql = 'SELECT poster_id FROM ' . $this->posts_table . ' WHERE topic_id = ' . $topic_id . ' ORDER BY post_time ASC';
++            $result = $this->db->sql_query_limit($sql, 1);
++            $row = $this->db->sql_fetchrow($result);
++            $author_id = (int) $row['poster_id'];
++            $predicate .= ' AND u.user_id != ' . $author_id;
+          }
+ 
+          $sql = 'SELECT DISTINCT(u.username), u.user_id, user_avatar, user_avatar_type, user_avatar_width, user_avatar_height
+-				FROM ' . $this->users_table . ' u
+-				WHERE u.user_type IN (' . USER_NORMAL . ', ' . USER_FOUNDER . ')' . $predicate . '
+-				ORDER BY u.user_posts DESC';
++               FROM ' . $this->users_table . ' u
++               WHERE u.user_type IN (' . USER_NORMAL . ', ' . USER_FOUNDER . ')' . $predicate . '
++               ORDER BY u.user_posts DESC';
+          $result = $this->db->sql_query_limit($sql, 10);
+          $usernames = [];
+-         $style_path = $this->user->style['style_path'] ?? 'prosilver';
+          while ($row = $this->db->sql_fetchrow($result)) {
+             $usernames[] = [
+                $row['username'],
+@@ -98,7 +95,7 @@ class main
+                   )
+                ) . ' ' . $row['username'] . '</div>' :
+                   '<div class="nemtion"><img src="' .
+-                  generate_board_url() . '/styles/' . $style_path . '/theme/images/no-avatar.png'
++                  generate_board_url() . '/styles/' . $this->user->style['style_path'] . '/theme/images/no-avatar.png'
+                   . '"> ' . $row['username'] . '</div>',
+             ];
+          }
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/diff_full.tmp"
+new file mode 100644
+index 000000000..187811642
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/diff_full.tmp"
+@@ -0,0 +1,141 @@
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\likepoints/adm/style/event/acp_forums_normal_settings_append.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/adm/style/event/acp_forums_normal_settings_append.html"
++index df5159f7d..0a9302ef2 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\likepoints/adm/style/event/acp_forums_normal_settings_append.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/adm/style/event/acp_forums_normal_settings_append.html"
++@@ -1,6 +1,6 @@
++ <dl>
++   <dt>
++-    <label for="per_likes_enabled">{{ lang('PER_LIKES_ENABLE') ~ lang('COLON') }}</label>
+++    <label for="per_likes_enabled">{{ lang('PER_LIKES_ENABLE') }}{{ lang('COLON') }}</label>
++   </dt>
++   <dd>
++     <label><input type="radio" class="radio" name="per_likes_enabled" value="1" {% if S_ENABLE_LIKES %} id="per_likes_enabled" checked="checked" {% endif %}/>
++@@ -12,7 +12,7 @@
++ 
++ <dl>
++   <dt>
++-    <label for="contributors_enabled">{{ lang('CONTRIBUTORS_ENABLE') ~ lang('COLON') }}</label>
+++    <label for="contributors_enabled">{{ lang('CONTRIBUTORS_ENABLE') }}{{ lang('COLON') }}</label>
++   </dt>
++   <dd>
++     <label><input type="radio" class="radio" name="contributors_enabled" value="1" {% if S_ENABLE_CONTRIBUTORS %} id="contributors_enabled" checked="checked" {% endif %}/>
++@@ -24,9 +24,9 @@
++ 
++ <dl>
++   <dt>
++-    <label for="per_likes_amount">{{ lang('PER_LIKES_AMOUNT') ~ lang('COLON') }}</label>
+++    <label for="per_likes_amount">{{ lang('PER_LIKES_AMOUNT') }}{{ lang('COLON') }}</label>
++   </dt>
++   <dd>
++-    <label><input type="number" name="per_likes_amount" value="{{ PERLIKES_AMOUNT }}" min="0" max="9999"></label>
+++    <label><input type="number" name="per_likes_amount" value="{{ PERLIKES_AMOUNT }}" min="0" max="99999"></label>
++   </dd>
++ </dl>
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\likepoints/adm/style/event/sitesplat_bbpoints_acp_after_manage_bbpoints_points_registration_field.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/adm/style/event/sitesplat_bbpoints_acp_after_manage_bbpoints_points_registration_field.html"
++index d1d8a6abc..807f614b2 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\likepoints/adm/style/event/sitesplat_bbpoints_acp_after_manage_bbpoints_points_registration_field.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/adm/style/event/sitesplat_bbpoints_acp_after_manage_bbpoints_points_registration_field.html"
++@@ -1,8 +1,8 @@
++ <dl>
++-  <dt><label for="per_likes">{L_ACP_POINTS}{L_COLON}</label><br /><span>{L_ACP_POINTS_PERLIKES_EXPLAIN}</span></dt>
+++  <dt><label for="per_likes">{L_ACP_POINTS}{L_COLON}</label><br /><span>{L_ACP_POINTS_PER_LIKES_EXPLAIN}</span></dt>
++   <dd>
++     <div style="float:left;width:100%;font-size:0.85em">
++-      {L_POINTS_PERLIKES}
+++      {L_ACP_POINTS_PER_LIKES}
++     </div>
++   </dd>
++   <dd>
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\likepoints/adm/style/event/sitesplat_bbpoints_acp_after_manage_bbpoints_points_sync_points_field.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/adm/style/event/sitesplat_bbpoints_acp_after_manage_bbpoints_points_sync_points_field.html"
++index eccc0daf3..52b8a6baf 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\likepoints/adm/style/event/sitesplat_bbpoints_acp_after_manage_bbpoints_points_sync_points_field.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/adm/style/event/sitesplat_bbpoints_acp_after_manage_bbpoints_points_sync_points_field.html"
++@@ -17,9 +17,9 @@
++       </div>
++     </div>
++     <br/>
++-    <div id="sync_like_points-processing" style="display: none;">Processing ...</div>
+++    <div id="sync_like_points-processing" style="display: none;">{L_SYNC_LIKE_POINTS_PROCESSING}</div>
++     <br/>
++-    <div id="sync_like_points-summary" style="display: none;">Total posts:
+++    <div id="sync_like_points-summary" style="display: none;">{L_SYNC_LIKE_POINTS_TOTAL_POSTS}{L_COLON}
++       <span id="total-posts"></span></div>
++   </dd>
++ </dl>
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\likepoints/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/composer.json"
++index fbc821998..fac083642 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\likepoints/composer.json"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/composer.json"
++@@ -2,14 +2,12 @@
++     "name": "leinad4mind/likepoints",
++     "type": "phpbb-extension",
++     "description": "Bridge between the BBPoints and LikeDD extensions",
++-    "homepage": "https://leinad4mind.top/forum/",
++-    "version": "2.1.0",
++-    "time": "2025-08-16",
+++    "version": "2.0.0",
+++    "time": "2022-05-25",
++     "license": "Proprietary",
++     "authors": [
++         {
++             "name": "Leinad4Mind",
++-            "homepage": "https://leinad4mind.top/forum",
++             "role": "Developer"
++         }
++     ],
++@@ -21,12 +19,6 @@
++         "display-name": "Bridge BBPoints and LikeDD",
++         "soft-require": {
++             "phpbb/phpbb": ">=3.3.4"
++-        },
++-        "version-check": {
++-            "host": "leinad4mind.top",
++-            "directory": "/phpbb/likepoints",
++-            "filename": "version_check.json",
++-            "ssl": true
++         }
++     }
++ }
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\likepoints/controller/admin_controller.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/controller/admin_controller.php"
++index cea87e5c5..07ae97e1d 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\likepoints/controller/admin_controller.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/controller/admin_controller.php"
++@@ -4,7 +4,7 @@
++  *
++  * LikePoints extension for the phpBB Forum Software package.
++  *
++- * @copyright (c) 2022-2025 Leinad4Mind All rights reserved
+++ * @copyright (c) 2022 Leinad4Mind All rights reserved
++  * @license Proprietary
++  *
++  */
++@@ -54,9 +54,8 @@ class admin_controller
++   public function get_default_likepoint_amount()
++   {
++     $sql = "SELECT config_value FROM $this->config_table WHERE config_name = 'bbpoints_settings' LIMIT 1";
++-    $result = $this->db->sql_query($sql);
++-    $config = $this->db->sql_fetchfield('config_value', $result);
++-    $this->db->sql_freeresult($result);
+++    $this->db->sql_query($sql);
+++    $config  = $this->db->sql_fetchfield('config_value');
++     $config = json_decode($config, true);
++     return (int) ($config['per_likes'] ?? 10);
++   }
++@@ -187,7 +186,7 @@ class admin_controller
++ 
++   protected function get_contributors($post_id)
++   {
++-    $sql = 'SELECT contributors FROM ' . POSTS_TABLE . ' WHERE post_id = ' . (int) $post_id . ' LIMIT 1';
+++    $sql = 'SELECT contributors FROM ' . POSTS_TABLE . ' WHERE post_id = ' . $post_id . ' LIMIT 1';
++     $this->db->sql_query($sql);
++     $contributors = $this->db->sql_fetchfield('contributors');
++     if ($contributors === '') {
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\likepoints/controller/main.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/controller/main.php"
++index 4a947ec97..670c0696d 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\likepoints/controller/main.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/controller/main.php"
++@@ -4,7 +4,7 @@
++  *
++  * LikePoints extension for the phpBB Forum Software package.
++  *
++- * @copyright (c) 2022-
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\likepoints/event/admin_listener.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/event/admin_listener.php"
+index e5b92c412..a8b20207b 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\likepoints/event/admin_listener.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/event/admin_listener.php"
+@@ -4,7 +4,7 @@
+  *
+  * LikePoints extension for the phpBB Forum Software package.
+  *
+- * @copyright (c) 2022-2025 Leinad4Mind All rights reserved
++ * @copyright (c) 2022 Leinad4Mind All rights reserved
+  * @license Proprietary
+  *
+  */
+@@ -57,7 +57,7 @@ class admin_listener implements EventSubscriberInterface
+       $this->helper   = $helper;
+       $this->config = $config;
+       $this->config_table = $config_table;
+-      $this->bbpoints_config = !empty($this->config['bbpoints_settings']) ? json_decode($this->config['bbpoints_settings'], true) : [];
++      $this->bbpoints_config = json_decode($this->config['bbpoints_settings'], true);
+    }
+ 
+    /**
+@@ -123,13 +123,13 @@ class admin_listener implements EventSubscriberInterface
+     */
+    public function acp_manage_forums_display_form($event)
+    {
++      //$this->user->add_lang_ext('leinad4mind/likepoints', 'info_acp_likepoints');
+       $this->language->add_lang('info_acp_likepoints', 'leinad4mind/likepoints');
+       $row = null;
+       if ($event['action'] !== 'add') {
+-         $sql = 'SELECT per_likes_amount FROM ' . FORUMS_TABLE . ' WHERE forum_id = ' . (int) $event['forum_data']['forum_id'] . ' and per_likes_enabled = 1';
++         $sql = 'SELECT per_likes_amount FROM ' . FORUMS_TABLE . ' WHERE forum_id = ' . $event['forum_data']['forum_id'] . ' and per_likes_enabled = 1';
+          $result = $this->db->sql_query($sql);
+          $row = $this->db->sql_fetchrow($result);
+-         $this->db->sql_freeresult($result);
+       }
+ 
+       $this->template->assign_vars(array(
+@@ -152,20 +152,19 @@ class admin_listener implements EventSubscriberInterface
+       $contributors_enabled = $this->request->variable('contributors_enabled', 0);
+       $amount = $this->request->variable('per_likes_amount', $this->get_default_likepoint_amount());
+       $sql = 'UPDATE ' . FORUMS_TABLE . '
+-            SET per_likes_enabled = ' . (int) $per_likes_enabled . ',
+-                contributors_enabled = ' . (int) $contributors_enabled . ',
+-                per_likes_amount = ' . (int) $amount . '
+-            WHERE forum_id = ' . (int) $event['forum_data']['forum_id'];
++				SET per_likes_enabled = ' . $per_likes_enabled . ',
++            contributors_enabled = ' . $contributors_enabled . ',
++					per_likes_amount = ' . $amount . '
++				WHERE forum_id = ' . $event['forum_data']['forum_id'];
+       $this->db->sql_query($sql);
+    }
+ 
+    public function get_default_likepoint_amount()
+    {
+       $sql = "SELECT config_value FROM $this->config_table WHERE config_name = 'bbpoints_settings' LIMIT 1";
+-      $result = $this->db->sql_query($sql);
+-      $config = $this->db->sql_fetchfield('config_value', false, $result);
+-      $this->db->sql_freeresult($result);
++      $this->db->sql_query($sql);
++      $config  = $this->db->sql_fetchfield('config_value');
+       $config = json_decode($config, true);
+-      return isset($config['per_likes']) ? (int) $config['per_likes'] : 10;
++      return (int) ($config['per_likes'] ?? 10);
+    }
+ }
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\likepoints/event/listener.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/event/listener.php"
+index 4438610d7..379ef098e 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\likepoints/event/listener.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/event/listener.php"
+@@ -4,7 +4,7 @@
+  *
+  * LikePoints extension for the phpBB Forum Software package.
+  *
+- * @copyright (c) 2022-2025 Leinad4Mind All rights reserved
++ * @copyright (c) 2022 Leinad4Mind All rights reserved
+  * @license Proprietary
+  *
+  */
+@@ -84,16 +84,12 @@ class listener implements EventSubscriberInterface
+     */
+    public function display_viewtopic_contributors($event): void
+    {
+-      
+       $sql = 'SELECT contributors_enabled FROM ' . FORUMS_TABLE . ' WHERE forum_id = ' . $event['row']['forum_id'];
+-      $result = $this->db->sql_query($sql);
+-      $contributors_enabled = (bool) $this->db->sql_fetchfield('contributors_enabled', $result);
+-      $this->db->sql_freeresult($result);
+-
++      $this->db->sql_query($sql);
++      $contributors_enabled  = $this->db->sql_fetchfield('contributors_enabled');
+       $event['post_row'] = array_merge($event['post_row'], array(
+-         'S_ENABLE_CONTRIBUTORS' => true,
++         'S_ENABLE_CONTRIBUTORS' => $contributors_enabled,
+       ));
+-
+       if (!$contributors_enabled) {
+          return;
+       }
+@@ -103,16 +99,14 @@ class listener implements EventSubscriberInterface
+          $event['post_row'] = array_merge($event['post_row'], array(
+             'S_ENABLE_CONTRIBUTORS' => false,
+          ));
+-         return;
+       }
+ 
+       $contrs = '';
+       foreach ($contributors as $u) {
+          $user_id = (int) $u;
+          $sql = 'SELECT username FROM ' . USERS_TABLE . ' WHERE user_id = ' . $user_id . ' LIMIT 1';
+-         $result = $this->db->sql_query($sql);
+-         $username = $this->db->sql_fetchfield('username', $result);
+-         $this->db->sql_freeresult($result); 
++         $this->db->sql_query($sql);
++         $username = $this->db->sql_fetchfield('username');
+          $contrs .= '<a href="' . append_sid('memberlist.php?mode=viewprofile&u=' . $user_id) . '">' . $username . '</a>, ';
+       }
+ 
+@@ -184,7 +178,7 @@ class listener implements EventSubscriberInterface
+          return;
+       }
+ 
+-      if ($liked_post_id > 0 && $user_points <= $amount) {
++      if ($liked_post_id > 0 && $user_points < $amount) {
+          $message = $this->language->lang_array('LOG_TRANSFER_POINTS_NOT_ENOUGH', [
+             $amount, $user_id
+          ]);
+@@ -219,19 +213,17 @@ class listener implements EventSubscriberInterface
+    {
+       // Get the current user's points, calculated only from public posts
+       $sql = 'SELECT user_id, SUM(points) as total FROM (
+-      SELECT poster_id AS user_id, SUM(bbpoints) AS points FROM ' . POSTS_TABLE . ' WHERE post_visibility = 1 AND poster_id = ' . (int) $user_id . ' GROUP BY poster_id
++      SELECT poster_id AS user_id, SUM(bbpoints) AS points FROM ' . POSTS_TABLE . ' WHERE post_visibility = 1 AND poster_id = ' . $user_id . ' GROUP BY poster_id
+       UNION ALL
+-      SELECT topic_poster AS user_id, SUM(bbpoints) AS points FROM ' . TOPICS_TABLE . ' WHERE topic_poster = ' . (int) $user_id . ' GROUP BY topic_poster
++      SELECT topic_poster AS user_id, SUM(bbpoints) AS points FROM ' . TOPICS_TABLE . ' WHERE topic_poster = ' . $user_id . ' GROUP BY topic_poster
+       UNION ALL
+-      SELECT to_id AS user_id, SUM(bbpoints) AS points FROM ' . $this->bbpoints_table . ' WHERE to_id = ' . (int) $user_id . ' GROUP BY to_id
++      SELECT to_id AS user_id, SUM(bbpoints) AS points FROM ' . $this->bbpoints_table . ' WHERE to_id = ' . $user_id . ' GROUP BY to_id
+       UNION ALL
+-      SELECT from_id AS user_id, SUM(- bbpoints) AS points FROM ' . $this->bbpoints_table . ' WHERE from_id = ' . (int) $user_id . ' GROUP BY from_id
++      SELECT from_id AS user_id, SUM(- bbpoints) AS points FROM ' . $this->bbpoints_table . ' WHERE from_id = ' . $user_id . ' GROUP BY from_id
+             ) t1 GROUP BY user_id';
+-      $result = $this->db->sql_query($sql);
+-      $user_points = (int) $this->db->sql_fetchfield('total', $result);
+-      $this->db->sql_freeresult($result);
+-
+-      return $user_points;
++      $this->db->sql_query($sql);
++      $user_points  = $this->db->sql_fetchfield('total');
++      return (int) $user_points;
+    }
+ 
+    protected function transfer_points(int $from_id, int $to_id, int $topic_id, int $post_id, int $points = 0, string $reason = ''): void
+@@ -271,9 +263,8 @@ class listener implements EventSubscriberInterface
+          return;
+       }
+       $sql = 'SELECT bbpoints FROM ' . $this->bbpoints_table . ' WHERE from_id = ' . $from_id . ' AND to_id = ' . $to_id . ' AND topic_id = ' . $topic_id . ' LIMIT 1';
+-      $result = $this->db->sql_query($sql);
+-      $likepoints = (int) $this->db->sql_fetchfield('bbpoints', $result);
+-      $this->db->sql_freeresult($result);
++      $this->db->sql_query($sql);
++      $likepoints = (int) $this->db->sql_fetchfield('bbpoints');
+       if ($likepoints === $points) {
+          // We can undo the operation instead of transferring the points back and forth.
+          $sql = 'DELETE FROM ' . $this->bbpoints_table . ' WHERE from_id = ' . $from_id . ' AND to_id = ' . $to_id . ' AND topic_id = ' . $topic_id . ' AND bbpoints = ' . $points . ' LIMIT 1';
+@@ -297,13 +288,9 @@ class listener implements EventSubscriberInterface
+       if (!$post_id) {
+          return 0;
+       }
+-
+       $sql = 'SELECT poster_id FROM ' . POSTS_TABLE . ' WHERE post_id = ' . $post_id . ' LIMIT 1';
+-      $result = $this->db->sql_query($sql);
+-      $poster_id = (int) $this->db->sql_fetchfield('poster_id', $result);
+-      $this->db->sql_freeresult($result);
+-
+-      return $poster_id;
++      $this->db->sql_query($sql);
++      return (int) $this->db->sql_fetchfield('poster_id');
+    }
+ 
+    protected function get_amount(int $post_id): int
+@@ -329,7 +316,8 @@ class listener implements EventSubscriberInterface
+ 
+    public function update_contributors($event)
+    {
+-      $post_id = (int) $event['post_id'];
++      $post_id = (int) ($event['data']['post_id'] ?? $event['post_id']);
++
+       if (!$post_id) {
+          return;
+       }
+@@ -337,12 +325,12 @@ class listener implements EventSubscriberInterface
+          // this is only a preview
+          return;
+       }
+-      $contributors = $this->request->variable('contributors', '');
++      $contributors = $this->request->variable('contributors', '', true);
+       $sql = 'SELECT contributors_enabled FROM ' . FORUMS_TABLE . ' WHERE forum_id = (
+          SELECT forum_id FROM ' . POSTS_TABLE . ' WHERE post_id = ' . $post_id . ')';
+-      $result = $this->db->sql_query($sql);
+-      $contributors_enabled  = $this->db->sql_fetchfield('contributors_enabled', $result);
+-      $this->db->sql_freeresult($result);
++      $this->db->sql_query($sql);
++      $contributors_enabled  = $this->db->sql_fetchfield('contributors_enabled');
++
+       if (!$contributors_enabled) {
+          return;
+       }
+@@ -359,9 +347,8 @@ class listener implements EventSubscriberInterface
+             continue;
+          }
+          $sql = 'SELECT user_id FROM ' . USERS_TABLE . ' WHERE username_clean = \'' . $this->db->sql_escape(strtolower($username)) . '\' LIMIT 1';
+-         $result = $this->db->sql_query($sql);
+-         $user_id = (int) $this->db->sql_fetchfield('user_id', $result);
+-         $this->db->sql_freeresult($result);
++         $this->db->sql_query($sql);
++         $user_id = (int) $this->db->sql_fetchfield('user_id');
+          if ($user_id > 0) {
+             $value[] = $user_id;
+          }
+@@ -376,22 +363,21 @@ class listener implements EventSubscriberInterface
+    protected function get_contributors($post_id)
+    {
+       $sql = 'SELECT contributors_enabled FROM ' . FORUMS_TABLE . ' INNER JOIN ' . POSTS_TABLE . ' ON ' . POSTS_TABLE . '.forum_id = ' . FORUMS_TABLE . '.forum_id WHERE ' . POSTS_TABLE . '.post_id = ' . $post_id . ' LIMIT 1';
+-      $result = $this->db->sql_query($sql);
+-      $row = $this->db->sql_fetchrow($result);
+-      $this->db->sql_freeresult($result);
++      $this->db->sql_query($sql);
++      $row = $this->db->sql_fetchrow();
+       $enabled = isset($row['contributors_enabled']) ? $row['contributors_enabled'] : false;
+       if (!$enabled) {
+          return [];
+       }
+ 
+       $sql = 'SELECT contributors FROM ' . POSTS_TABLE . ' WHERE post_id = ' . $post_id . ' LIMIT 1';
+-      $result = $this->db->sql_query($sql);
+-      $contributors = $this->db->sql_fetchfield('contributors', $result);
+-      $this->db->sql_freeresult($result);
++      $this->db->sql_query($sql);
++      $contributors = $this->db->sql_fetchfield('contributors');
+       if ($contributors === '') {
+          return [];
+       }
+       $contributors = explode(',', $contributors);
++      // $contributors = array_map('intval', $contributors);
+       return $contributors;
+    }
+ 
+@@ -405,14 +391,23 @@ class listener implements EventSubscriberInterface
+          return;
+       }
+       $post_id = (int) $event['post_id'];
++      $forum_id = (int) $event['forum_id'];
++      // $topic_first_post_id = (int) $event['post_data']['topic_first_post_id'];
++      // Check if 'topic_first_post_id' key exists in the $event['post_data'] array
++      $topic_first_post_id = isset($event['post_data']['topic_first_post_id']) ? (int) $event['post_data']['topic_first_post_id'] : 0;
+ 
+-      $sql = 'SELECT contributors_enabled FROM ' . FORUMS_TABLE . ' WHERE forum_id = (
++
++      if ($post_id) {
++         $sql = 'SELECT contributors_enabled FROM ' . FORUMS_TABLE . ' WHERE forum_id = (
+          SELECT forum_id FROM ' . POSTS_TABLE . ' WHERE post_id = ' . $post_id . ')';
+-      $result = $this->db->sql_query($sql);
+-      $contributors_enabled  = $this->db->sql_fetchfield('contributors_enabled', $result);
+-      $this->db->sql_freeresult($result);
++      } else {
++         $sql = 'SELECT contributors_enabled FROM ' . FORUMS_TABLE . ' WHERE forum_id = ' . $forum_id;
++      }
++      $this->db->sql_query($sql);
++      $contributors_enabled  = $this->db->sql_fetchfield('contributors_enabled');
++
+       $this->template->assign_vars(array(
+-         'S_ENABLE_CONTRIBUTORS' => $contributors_enabled ? true : false,
++         'S_ENABLE_CONTRIBUTORS' => $contributors_enabled ? ($topic_first_post_id == $post_id || $event['mode'] == 'post') : false,
+       ));
+ 
+       if (!$contributors_enabled) {
+@@ -424,9 +419,8 @@ class listener implements EventSubscriberInterface
+       foreach ($contributors as $u) {
+          $user_id = (int) $u;
+          $sql = 'SELECT username FROM ' . USERS_TABLE . ' WHERE user_id = ' . $user_id . ' LIMIT 1';
+-         $result = $this->db->sql_query($sql);
+-         $username = $this->db->sql_fetchfield('username', $result);
+-         $this->db->sql_freeresult($result);
++         $this->db->sql_query($sql);
++         $username = $this->db->sql_fetchfield('username');
+          $a[] = $username;
+       }
+       $this->template->assign_vars(array(
+@@ -437,19 +431,15 @@ class listener implements EventSubscriberInterface
+    public function get_topic_id($post_id)
+    {
+       $sql = 'SELECT topic_id FROM ' . POSTS_TABLE . ' WHERE post_id = ' . $post_id . ' LIMIT 1';
+-      $result = $this->db->sql_query($sql);
+-      $topic_id = (int) $this->db->sql_fetchfield('topic_id', $result);
+-      $this->db->sql_freeresult($result);
+-      return $topic_id;
++      $this->db->sql_query($sql);
++      return (int) $this->db->sql_fetchfield('topic_id');
+    }
+ 
+    public function is_unlike($post_id, $user_id)
+    {
+       $sql = 'SELECT COUNT(*) AS count FROM ' . $this->bblikes_table . ' WHERE post_id = ' . $post_id . ' AND user_id = ' . $user_id;
+-      $result = $this->db->sql_query($sql);
+-      $count = (int) $this->db->sql_fetchfield('count', $result);
+-      $this->db->sql_freeresult($result);
+-
++      $this->db->sql_query($sql);
++      $count = (int) $this->db->sql_fetchfield('count');
+       // As we're running this on 'core.submit_likedd_end' event, the existence of a like
+       // means it was a new like and non-existence means the like was removed.
+       return ($count === 0);
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\likepoints/language/en/common.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/language/en/common.php"
+index f61b7cbff..f8bf14e6f 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\likepoints/language/en/common.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/language/en/common.php"
+@@ -4,7 +4,7 @@
+  *
+  * LikePoints extension for the phpBB Forum Software package.
+  *
+- * @copyright (c) 2022-2025 Leinad4Mind All rights reserved
++ * @copyright (c) 2022 Leinad4Mind All rights reserved
+  * @license Proprietary
+  *
+  */
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\likepoints/language/en/info_acp_likepoints.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/language/en/info_acp_likepoints.php"
+index 5be342dff..39d5950c2 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\likepoints/language/en/info_acp_likepoints.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/language/en/info_acp_likepoints.php"
+@@ -4,7 +4,7 @@
+  *
+  * LikePoints extension for the phpBB Forum Software package.
+  *
+- * @copyright (c) 2022-2025 Leinad4Mind All rights reserved
++ * @copyright (c) 2022 Leinad4Mind All rights reserved
+  * @license Proprietary
+  *
+  */
+@@ -23,7 +23,11 @@ if (!isset($lang) || !is_array($lang)) {
+ $lang = array_merge($lang, [
+    'PER_LIKES_ENABLE' => 'Enable transfer of BBPoints for likes',
+    'PER_LIKES_AMOUNT' => 'Amount of BBPoints transferred on liking the post',
++   'ACP_POINTS_PER_LIKES' => 'Points per likes',
++   'ACP_POINTS_PER_LIKES_EXPLAIN' => 'Set the default amount of points transferred on liking posts. Set to 0 to switch off.',
+    'CONTRIBUTORS_ENABLE' => 'Enable contributors',
+    'SYNC_LIKE_POINTS' => 'Sync like points',
+    'SYNC_LIKE_POINTS_EXPLAIN' => 'Calculates all the points for likes set above for all the users.<br>It can take several minutes and it depends on how many users, posts and likes your board hosts.<br>Do NOT interrput the process once started.',
++   'SYNC_LIKE_POINTS_PROCESSING' => 'Processing...',
++   'SYNC_LIKE_POINTS_TOTAL_POSTS' => 'Total posts',
+ ]);
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/language/pt/common.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/language/pt/common.php"
+new file mode 100644
+index 000000000..75afec1db
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/language/pt/common.php"
+@@ -0,0 +1,37 @@
++<?php
++
++/**
++ *
++ * LikePoints extension for the phpBB Forum Software package.
++ *
++ * @copyright (c) 2022 Leinad4Mind All rights reserved
++ * @license Proprietary
++ *
++ */
++
++/**
++ * DO NOT CHANGE
++ */
++if (!defined('IN_PHPBB')) {
++   exit;
++}
++
++if (!isset($lang) || !is_array($lang)) {
++   $lang = [];
++}
++
++$lang = array_merge($lang, [
++   'CONTRIBUTOR_LABEL' => 'Colaboradores',
++   'LOG_TRANSFER_POINTS' => 'Transferring %d BBPoints to user %d',
++   'LOG_TRANSFER_POINTS_NOT_ENOUGH' => 'Tried to transfer %d BBPoints to user %d, but did not have enough on balance',
++   'LOG_UNLIKE_TRANSFER_POINTS_NOT_ENOUGH' => 'Tried to transfer %d BBPoints back from user %d to user %d after a unlike, but they did not have enough on balance',
++   'LOG_LIKE_TRANSFER_ABORTED' => 'Like action taken back. %d BBPoints returned to user %d from user %d',
++   'REASON_LIKE' => 'LIKE: Awarded %d points for getting a like from %d.',
++   'REASON_UNLIKE' => 'UNLIKE: Taken %d points for getting a unlike from %d.',
++   'REASON_LIKE_CONTRIBUTOR' => 'CONTRIBUTOR LIKE: Awarded %d points for getting a like from %d as contributors from the poster.',
++   'REASON_UNLIKE_CONTRIBUTOR' => 'CONTRIBUTOR UNLIKE: Taken %d points for removing a like from %d as contributors from the poster.',
++   'ENTER_TAGS_PLACEHOLDER' => 'Introduza nomes de utilizadores',
++   'CONTRIBUTED' => 'contribuiu',
++   'CONTRIBUTEDS' => 'contribuíram',
++   'NOT_ENOUGH_BALANCE_LIKE' => 'Não tens pontos suficientes para agradecer :(<br>Participa e ajuda a comunidade de forma a obteres mais pontos!',
++]);
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/language/pt/info_acp_likepoints.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/language/pt/info_acp_likepoints.php"
+new file mode 100644
+index 000000000..39d5950c2
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/language/pt/info_acp_likepoints.php"
+@@ -0,0 +1,33 @@
++<?php
++
++/**
++ *
++ * LikePoints extension for the phpBB Forum Software package.
++ *
++ * @copyright (c) 2022 Leinad4Mind All rights reserved
++ * @license Proprietary
++ *
++ */
++
++/**
++ * DO NOT CHANGE
++ */
++if (!defined('IN_PHPBB')) {
++   exit;
++}
++
++if (!isset($lang) || !is_array($lang)) {
++   $lang = [];
++}
++
++$lang = array_merge($lang, [
++   'PER_LIKES_ENABLE' => 'Enable transfer of BBPoints for likes',
++   'PER_LIKES_AMOUNT' => 'Amount of BBPoints transferred on liking the post',
++   'ACP_POINTS_PER_LIKES' => 'Points per likes',
++   'ACP_POINTS_PER_LIKES_EXPLAIN' => 'Set the default amount of points transferred on liking posts. Set to 0 to switch off.',
++   'CONTRIBUTORS_ENABLE' => 'Enable contributors',
++   'SYNC_LIKE_POINTS' => 'Sync like points',
++   'SYNC_LIKE_POINTS_EXPLAIN' => 'Calculates all the points for likes set above for all the users.<br>It can take several minutes and it depends on how many users, posts and likes your board hosts.<br>Do NOT interrput the process once started.',
++   'SYNC_LIKE_POINTS_PROCESSING' => 'Processing...',
++   'SYNC_LIKE_POINTS_TOTAL_POSTS' => 'Total posts',
++]);
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/language/pt-preao/common.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/language/pt-preao/common.php"
+new file mode 100644
+index 000000000..75afec1db
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/language/pt-preao/common.php"
+@@ -0,0 +1,37 @@
++<?php
++
++/**
++ *
++ * LikePoints extension for the phpBB Forum Software package.
++ *
++ * @copyright (c) 2022 Leinad4Mind All rights reserved
++ * @license Proprietary
++ *
++ */
++
++/**
++ * DO NOT CHANGE
++ */
++if (!defined('IN_PHPBB')) {
++   exit;
++}
++
++if (!isset($lang) || !is_array($lang)) {
++   $lang = [];
++}
++
++$lang = array_merge($lang, [
++   'CONTRIBUTOR_LABEL' => 'Colaboradores',
++   'LOG_TRANSFER_POINTS' => 'Transferring %d BBPoints to user %d',
++   'LOG_TRANSFER_POINTS_NOT_ENOUGH' => 'Tried to transfer %d BBPoints to user %d, but did not have enough on balance',
++   'LOG_UNLIKE_TRANSFER_POINTS_NOT_ENOUGH' => 'Tried to transfer %d BBPoints back from user %d to user %d after a unlike, but they did not have enough on balance',
++   'LOG_LIKE_TRANSFER_ABORTED' => 'Like action taken back. %d BBPoints returned to user %d from user %d',
++   'REASON_LIKE' => 'LIKE: Awarded %d points for getting a like from %d.',
++   'REASON_UNLIKE' => 'UNLIKE: Taken %d points for getting a unlike from %d.',
++   'REASON_LIKE_CONTRIBUTOR' => 'CONTRIBUTOR LIKE: Awarded %d points for getting a like from %d as contributors from the poster.',
++   'REASON_UNLIKE_CONTRIBUTOR' => 'CONTRIBUTOR UNLIKE: Taken %d points for removing a like from %d as contributors from the poster.',
++   'ENTER_TAGS_PLACEHOLDER' => 'Introduza nomes de utilizadores',
++   'CONTRIBUTED' => 'contribuiu',
++   'CONTRIBUTEDS' => 'contribuíram',
++   'NOT_ENOUGH_BALANCE_LIKE' => 'Não tens pontos suficientes para agradecer :(<br>Participa e ajuda a comunidade de forma a obteres mais pontos!',
++]);
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/language/pt-preao/info_acp_likepoints.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/language/pt-preao/info_acp_likepoints.php"
+new file mode 100644
+index 000000000..39d5950c2
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/language/pt-preao/info_acp_likepoints.php"
+@@ -0,0 +1,33 @@
++<?php
++
++/**
++ *
++ * LikePoints extension for the phpBB Forum Software package.
++ *
++ * @copyright (c) 2022 Leinad4Mind All rights reserved
++ * @license Proprietary
++ *
++ */
++
++/**
++ * DO NOT CHANGE
++ */
++if (!defined('IN_PHPBB')) {
++   exit;
++}
++
++if (!isset($lang) || !is_array($lang)) {
++   $lang = [];
++}
++
++$lang = array_merge($lang, [
++   'PER_LIKES_ENABLE' => 'Enable transfer of BBPoints for likes',
++   'PER_LIKES_AMOUNT' => 'Amount of BBPoints transferred on liking the post',
++   'ACP_POINTS_PER_LIKES' => 'Points per likes',
++   'ACP_POINTS_PER_LIKES_EXPLAIN' => 'Set the default amount of points transferred on liking posts. Set to 0 to switch off.',
++   'CONTRIBUTORS_ENABLE' => 'Enable contributors',
++   'SYNC_LIKE_POINTS' => 'Sync like points',
++   'SYNC_LIKE_POINTS_EXPLAIN' => 'Calculates all the points for likes set above for all the users.<br>It can take several minutes and it depends on how many users, posts and likes your board hosts.<br>Do NOT interrput the process once started.',
++   'SYNC_LIKE_POINTS_PROCESSING' => 'Processing...',
++   'SYNC_LIKE_POINTS_TOTAL_POSTS' => 'Total posts',
++]);
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\likepoints/migrations/m1_initial_install.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/migrations/m1_initial_install.php"
+index a188f2936..5f174ae7a 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\likepoints/migrations/m1_initial_install.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/migrations/m1_initial_install.php"
+@@ -4,7 +4,7 @@
+  *
+  * LikePoints extension for the phpBB Forum Software package.
+  *
+- * @copyright (c) 2022-2025 Leinad4Mind All rights reserved
++ * @copyright (c) 2022 Leinad4Mind All rights reserved
+  * @license Proprietary
+  *
+  */
+@@ -16,47 +16,22 @@ namespace leinad4mind\likepoints\migrations;
+  */
+ class m1_initial_install extends \phpbb\db\migration\migration
+ {
+-    /**
+-     * Schema changes to apply when installing the extension.
+-     */
+-    public function update_schema()
+-    {
+-        return array(
+-            'add_columns' => array(
+-                $this->table_prefix . 'forums' => array(
+-                    'per_likes_enabled'    => array('BOOL', 1),
+-                    'contributors_enabled' => array('BOOL', 1),
+-                    'per_likes_amount'     => array('UINT:2', 10),
+-                ),
+-                $this->table_prefix . 'posts' => array(
+-                    'contributors' => array('VCHAR:255', ''),
+-                ),
+-                $this->table_prefix . 'bbpoints' => array(
+-                    'post_id' => array('INT:11', 0),
+-                ),
++   public function update_schema()
++   {
++      return array(
++         'add_columns'   => array(
++            $this->table_prefix . 'forums'   => array(
++               'per_likes_enabled'   => array('BOOL', 1),
++               'contributors_enabled'   => array('BOOL', 1),
++               'per_likes_amount'   => array('UINT:2', 10),
+             ),
+-        );
+-    }
+-
+-    /**
+-     * Schema changes to revert when uninstalling the extension.
+-     */
+-    public function revert_schema()
+-    {
+-        return array(
+-            'drop_columns' => array(
+-                $this->table_prefix . 'forums' => array(
+-                    'per_likes_enabled',
+-                    'contributors_enabled',
+-                    'per_likes_amount',
+-                ),
+-                $this->table_prefix . 'posts' => array(
+-                    'contributors',
+-                ),
+-                $this->table_prefix . 'bbpoints' => array(
+-                    'post_id',
+-                ),
++            $this->table_prefix . 'posts'   => array(
++               'contributors'   => array('VCHAR:255', ''),
++            ),
++            $this->table_prefix . 'bbpoints'      => array(
++               'post_id'   => array('INT:11', '0'),
+             ),
+-        );
+-    }
+-}
++         )
++      );
++   }
++}
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\likepoints/migrations/m2_add_bbpoints_index.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\likepoints/migrations/m2_add_bbpoints_index.php"
+deleted file mode 100644
+index 983ddecfd..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\likepoints/migrations/m2_add_bbpoints_index.php"
++++ /dev/null
+@@ -1,49 +0,0 @@
+-<?php
+-
+-/**
+- *
+- * LikePoints extension for the phpBB Forum Software package.
+- *
+- * @copyright (c) 2022-2025 Leinad4Mind All rights reserved
+- * @license Proprietary
+- *
+- */
+-
+-namespace leinad4mind\likepoints\migrations;
+-
+-class m2_add_bbpoints_index extends \phpbb\db\migration\migration
+-{
+-    public static function depends_on()
+-    {
+-        return array('\leinad4mind\likepoints\migrations\m1_initial_install');
+-    }
+-
+-    public function update_schema()
+-    {
+-        return array(
+-            'add_indexes' => array(
+-                $this->table_prefix . 'bbpoints' => array(
+-                    'post_id_idx' => array('post_id'),
+-                ),
+-                $this->table_prefix . 'posts' => array(
+-                    'contributors_index' => array('contributors'),
+-                ),
+-                $this->table_prefix . 'forums' => array(
+-                    'per_likes_enabled_index' => array('per_likes_enabled'),
+-                    'contributors_enabled_index' => array('contributors_enabled'),
+-                ),
+-            ),
+-        );
+-    }
+-
+-    public function revert_schema()
+-    {
+-        return array(
+-            'drop_indexes' => array(
+-                $this->table_prefix . 'bbpoints' => array('post_id_idx'),
+-                $this->table_prefix . 'posts' => array('contributors_index'),
+-                $this->table_prefix . 'forums' => array('per_likes_enabled_index', 'contributors_enabled_index'),
+-            ),
+-        );
+-    }
+-}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\likepoints/styles/all/template/event/posting_editor_subject_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/styles/all/template/event/ss_posting_editor_subject_after.html"
+similarity index 55%
+rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\likepoints/styles/all/template/event/posting_editor_subject_after.html"
+rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/styles/all/template/event/ss_posting_editor_subject_after.html"
+index 7217b6027..996c010bb 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\likepoints/styles/all/template/event/posting_editor_subject_after.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/styles/all/template/event/ss_posting_editor_subject_after.html"
+@@ -5,25 +5,24 @@
+     var lptagsLangPlaceholder = '{{ lang('ENTER_TAGS_PLACEHOLDER') }}';
+   </script>
+ 
+-  <!-- IF not $INCLUDED_LPTAGS_TEXTCOMPLETEJS -->
+-  <!-- IF not BBTAGS_SHOW_FIELD-->
+-  {% INCLUDEJS '@leinad4mind_likepoints/js/jquery.tag-editor.min.js' %}
+-  {% INCLUDEJS '@leinad4mind_likepoints/js/jquery.caret.min.js' %}
+-  {% INCLUDEJS '@leinad4mind_likepoints/js/jquery-ui.min.js' %}
+-  <!-- INCLUDECSS @leinad4mind_likepoints/jquery.tag-editor.min.css -->
+-  <!-- ENDIF -->
+-  {% INCLUDEJS '@leinad4mind_likepoints/js/lptags.min.js' %}
++  {% if not INCLUDED_LPTAGS_TEXTCOMPLETEJS %}
++	{% if not BBTAGS_SHOW_FIELD %}
++		{% INCLUDEJS '@leinad4mind_likepoints/js/jquery.tag-editor.min.js' %}
++		{% INCLUDEJS '@leinad4mind_likepoints/js/jquery.caret.min.js' %}
++		{% INCLUDEJS '@leinad4mind_likepoints/js/jquery-ui.min.js' %}
++		{% INCLUDECSS '@leinad4mind_likepoints/jquery.tag-editor.min.css' %}
++	{% endif %}
++	{% INCLUDEJS '@leinad4mind_likepoints/js/lptags.min.js' %}
+ 
+-  <!-- DEFINE $INCLUDED_LPTAGS_TEXTCOMPLETEJS = true -->
+-  <!-- ENDIF -->
++	{% DEFINE INCLUDED_LPTAGS_TEXTCOMPLETEJS = true %}
++  {% endif %}
+ 
+   <div class="control-group contributors-box">
+-    <label class="control-label" for="contributors">{{ lang('CONTRIBUTOR_LABEL') ~ lang('COLON') }}</label>
++    <label class="control-label" for="contributors">{{ lang('CONTRIBUTOR_LABEL') }}{{ lang('COLON') }}</label>
+     <div class="row">
+       <div class="col-xs-12 col-lg-8">
+         <input type="text" class="form-control input-sm" autocomplete="off" name="contributors" id="contributors" maxlength="255" value="{{ CONTRIBUTOR }}" placeholder="{{ lang('ENTER_TAGS_PLACEHOLDER') }}">
+       </div>
+     </div>
+-
+   </div>
+ {% endif %}
diff --git "[FORUM_EXT]/leinad4mind\\likepoints/diff_nospace.tmp" "[FORUM_EXT]/leinad4mind\\likepoints/diff_nospace.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/leinad4mind\\likepoints/diff_nospace.tmp"
@@ -0,0 +1,1238 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\likepoints/adm/style/event/acp_forums_normal_settings_append.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/adm/style/event/acp_forums_normal_settings_append.html"
+index df5159f7d..0a9302ef2 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\likepoints/adm/style/event/acp_forums_normal_settings_append.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/adm/style/event/acp_forums_normal_settings_append.html"
+@@ -1,6 +1,6 @@
+ <dl>
+   <dt>
+-    <label for="per_likes_enabled">{{ lang('PER_LIKES_ENABLE') ~ lang('COLON') }}</label>
++    <label for="per_likes_enabled">{{ lang('PER_LIKES_ENABLE') }}{{ lang('COLON') }}</label>
+   </dt>
+   <dd>
+     <label><input type="radio" class="radio" name="per_likes_enabled" value="1" {% if S_ENABLE_LIKES %} id="per_likes_enabled" checked="checked" {% endif %}/>
+@@ -12,7 +12,7 @@
+ 
+ <dl>
+   <dt>
+-    <label for="contributors_enabled">{{ lang('CONTRIBUTORS_ENABLE') ~ lang('COLON') }}</label>
++    <label for="contributors_enabled">{{ lang('CONTRIBUTORS_ENABLE') }}{{ lang('COLON') }}</label>
+   </dt>
+   <dd>
+     <label><input type="radio" class="radio" name="contributors_enabled" value="1" {% if S_ENABLE_CONTRIBUTORS %} id="contributors_enabled" checked="checked" {% endif %}/>
+@@ -24,9 +24,9 @@
+ 
+ <dl>
+   <dt>
+-    <label for="per_likes_amount">{{ lang('PER_LIKES_AMOUNT') ~ lang('COLON') }}</label>
++    <label for="per_likes_amount">{{ lang('PER_LIKES_AMOUNT') }}{{ lang('COLON') }}</label>
+   </dt>
+   <dd>
+-    <label><input type="number" name="per_likes_amount" value="{{ PERLIKES_AMOUNT }}" min="0" max="9999"></label>
++    <label><input type="number" name="per_likes_amount" value="{{ PERLIKES_AMOUNT }}" min="0" max="99999"></label>
+   </dd>
+ </dl>
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\likepoints/adm/style/event/sitesplat_bbpoints_acp_after_manage_bbpoints_points_registration_field.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/adm/style/event/sitesplat_bbpoints_acp_after_manage_bbpoints_points_registration_field.html"
+index d1d8a6abc..807f614b2 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\likepoints/adm/style/event/sitesplat_bbpoints_acp_after_manage_bbpoints_points_registration_field.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/adm/style/event/sitesplat_bbpoints_acp_after_manage_bbpoints_points_registration_field.html"
+@@ -1,8 +1,8 @@
+ <dl>
+-  <dt><label for="per_likes">{L_ACP_POINTS}{L_COLON}</label><br /><span>{L_ACP_POINTS_PERLIKES_EXPLAIN}</span></dt>
++  <dt><label for="per_likes">{L_ACP_POINTS}{L_COLON}</label><br /><span>{L_ACP_POINTS_PER_LIKES_EXPLAIN}</span></dt>
+   <dd>
+     <div style="float:left;width:100%;font-size:0.85em">
+-      {L_POINTS_PERLIKES}
++      {L_ACP_POINTS_PER_LIKES}
+     </div>
+   </dd>
+   <dd>
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\likepoints/adm/style/event/sitesplat_bbpoints_acp_after_manage_bbpoints_points_sync_points_field.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/adm/style/event/sitesplat_bbpoints_acp_after_manage_bbpoints_points_sync_points_field.html"
+index eccc0daf3..52b8a6baf 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\likepoints/adm/style/event/sitesplat_bbpoints_acp_after_manage_bbpoints_points_sync_points_field.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/adm/style/event/sitesplat_bbpoints_acp_after_manage_bbpoints_points_sync_points_field.html"
+@@ -17,9 +17,9 @@
+       </div>
+     </div>
+     <br/>
+-    <div id="sync_like_points-processing" style="display: none;">Processing ...</div>
++    <div id="sync_like_points-processing" style="display: none;">{L_SYNC_LIKE_POINTS_PROCESSING}</div>
+     <br/>
+-    <div id="sync_like_points-summary" style="display: none;">Total posts:
++    <div id="sync_like_points-summary" style="display: none;">{L_SYNC_LIKE_POINTS_TOTAL_POSTS}{L_COLON}
+       <span id="total-posts"></span></div>
+   </dd>
+ </dl>
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\likepoints/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/composer.json"
+index fbc821998..fac083642 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\likepoints/composer.json"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/composer.json"
+@@ -2,14 +2,12 @@
+     "name": "leinad4mind/likepoints",
+     "type": "phpbb-extension",
+     "description": "Bridge between the BBPoints and LikeDD extensions",
+-    "homepage": "https://leinad4mind.top/forum/",
+-    "version": "2.1.0",
+-    "time": "2025-08-16",
++    "version": "2.0.0",
++    "time": "2022-05-25",
+     "license": "Proprietary",
+     "authors": [
+         {
+             "name": "Leinad4Mind",
+-            "homepage": "https://leinad4mind.top/forum",
+             "role": "Developer"
+         }
+     ],
+@@ -21,12 +19,6 @@
+         "display-name": "Bridge BBPoints and LikeDD",
+         "soft-require": {
+             "phpbb/phpbb": ">=3.3.4"
+-        },
+-        "version-check": {
+-            "host": "leinad4mind.top",
+-            "directory": "/phpbb/likepoints",
+-            "filename": "version_check.json",
+-            "ssl": true
+         }
+     }
+ }
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\likepoints/controller/admin_controller.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/controller/admin_controller.php"
+index cea87e5c5..07ae97e1d 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\likepoints/controller/admin_controller.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/controller/admin_controller.php"
+@@ -4,7 +4,7 @@
+  *
+  * LikePoints extension for the phpBB Forum Software package.
+  *
+- * @copyright (c) 2022-2025 Leinad4Mind All rights reserved
++ * @copyright (c) 2022 Leinad4Mind All rights reserved
+  * @license Proprietary
+  *
+  */
+@@ -54,9 +54,8 @@ class admin_controller
+   public function get_default_likepoint_amount()
+   {
+     $sql = "SELECT config_value FROM $this->config_table WHERE config_name = 'bbpoints_settings' LIMIT 1";
+-    $result = $this->db->sql_query($sql);
+-    $config = $this->db->sql_fetchfield('config_value', $result);
+-    $this->db->sql_freeresult($result);
++    $this->db->sql_query($sql);
++    $config  = $this->db->sql_fetchfield('config_value');
+     $config = json_decode($config, true);
+     return (int) ($config['per_likes'] ?? 10);
+   }
+@@ -187,7 +186,7 @@ class admin_controller
+ 
+   protected function get_contributors($post_id)
+   {
+-    $sql = 'SELECT contributors FROM ' . POSTS_TABLE . ' WHERE post_id = ' . (int) $post_id . ' LIMIT 1';
++    $sql = 'SELECT contributors FROM ' . POSTS_TABLE . ' WHERE post_id = ' . $post_id . ' LIMIT 1';
+     $this->db->sql_query($sql);
+     $contributors = $this->db->sql_fetchfield('contributors');
+     if ($contributors === '') {
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\likepoints/controller/main.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/controller/main.php"
+index 4a947ec97..670c0696d 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\likepoints/controller/main.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/controller/main.php"
+@@ -4,7 +4,7 @@
+  *
+  * LikePoints extension for the phpBB Forum Software package.
+  *
+- * @copyright (c) 2022-2025 Leinad4Mind All rights reserved
++ * @copyright (c) 2022 Leinad4Mind All rights reserved
+  * @license Proprietary
+  *
+  */
+@@ -49,33 +49,31 @@ class main
+    {
+       if ($this->request->is_ajax()) {
+          $json_response = new json_response();
+-         $term = $this->request->variable('term', '');
++         $term = $this->request->variable('term', '', true);
+          $term = strtolower(trim($term));
+          if (empty($term)) {
+             $json_response->send([]);
+             return;
+          }
+          $mode = $this->request->variable('mode', 'post');
+-         $post_id = (int) $this->request->variable('p', '');
+-         $topic_id = (int) $this->request->variable('topic_id', '');
++         $post_id = $this->request->variable('p', '');
++         $topic_id = $this->request->variable('topic_id', '');
+ 
+-         $predicate = ' AND u.username_clean ' . $this->db->sql_like_expression($term . $this->db->get_any_char());
++         $like = $this->db->sql_like_expression($this->db->sql_escape($term) . $this->db->get_any_char());
++
++         $predicate = ' AND u.username_clean ' . $like;
+          if (($mode == 'edit' || $mode == 'reply') && empty($topic_id)) {
+             $sql = 'SELECT topic_id FROM ' . $this->posts_table . ' WHERE post_id = ' . $post_id;
+             $result = $this->db->sql_query($sql);
+             $row = $this->db->sql_fetchrow($result);
+-            $topic_id = $row['topic_id'] ?? 0;
++            $topic_id = $row['topic_id'];
+          }
+          if (!empty($topic_id)) {
+-            $sql = 'SELECT poster_id FROM ' . $this->posts_table . ' WHERE topic_id = ' . $topic_id;
+-            $result = $this->db->sql_query($sql);
+-            $poster_ids = [];
+-            while ($row = $this->db->sql_fetchrow($result)) {
+-               $poster_ids[] = $row['poster_id'];
+-            }
+-            if (!empty($poster_ids)) {
+-               $predicate .= ' AND u.user_id NOT IN(' . implode(',', array_map('intval', $poster_ids)) . ')';
+-            }
++            $sql = 'SELECT poster_id FROM ' . $this->posts_table . ' WHERE topic_id = ' . $topic_id . ' ORDER BY post_time ASC';
++            $result = $this->db->sql_query_limit($sql, 1);
++            $row = $this->db->sql_fetchrow($result);
++            $author_id = (int) $row['poster_id'];
++            $predicate .= ' AND u.user_id != ' . $author_id;
+          }
+ 
+          $sql = 'SELECT DISTINCT(u.username), u.user_id, user_avatar, user_avatar_type, user_avatar_width, user_avatar_height
+@@ -84,7 +82,6 @@ class main
+                ORDER BY u.user_posts DESC';
+          $result = $this->db->sql_query_limit($sql, 10);
+          $usernames = [];
+-         $style_path = $this->user->style['style_path'] ?? 'prosilver';
+          while ($row = $this->db->sql_fetchrow($result)) {
+             $usernames[] = [
+                $row['username'],
+@@ -98,7 +95,7 @@ class main
+                   )
+                ) . ' ' . $row['username'] . '</div>' :
+                   '<div class="nemtion"><img src="' .
+-                  generate_board_url() . '/styles/' . $style_path . '/theme/images/no-avatar.png'
++                  generate_board_url() . '/styles/' . $this->user->style['style_path'] . '/theme/images/no-avatar.png'
+                   . '"> ' . $row['username'] . '</div>',
+             ];
+          }
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/diff_full.tmp"
+new file mode 100644
+index 000000000..cc137413a
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/diff_full.tmp"
+@@ -0,0 +1,1054 @@
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\likepoints/adm/style/event/acp_forums_normal_settings_append.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/adm/style/event/acp_forums_normal_settings_append.html"
++index df5159f7d..0a9302ef2 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\likepoints/adm/style/event/acp_forums_normal_settings_append.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/adm/style/event/acp_forums_normal_settings_append.html"
++@@ -1,6 +1,6 @@
++ <dl>
++   <dt>
++-    <label for="per_likes_enabled">{{ lang('PER_LIKES_ENABLE') ~ lang('COLON') }}</label>
+++    <label for="per_likes_enabled">{{ lang('PER_LIKES_ENABLE') }}{{ lang('COLON') }}</label>
++   </dt>
++   <dd>
++     <label><input type="radio" class="radio" name="per_likes_enabled" value="1" {% if S_ENABLE_LIKES %} id="per_likes_enabled" checked="checked" {% endif %}/>
++@@ -12,7 +12,7 @@
++ 
++ <dl>
++   <dt>
++-    <label for="contributors_enabled">{{ lang('CONTRIBUTORS_ENABLE') ~ lang('COLON') }}</label>
+++    <label for="contributors_enabled">{{ lang('CONTRIBUTORS_ENABLE') }}{{ lang('COLON') }}</label>
++   </dt>
++   <dd>
++     <label><input type="radio" class="radio" name="contributors_enabled" value="1" {% if S_ENABLE_CONTRIBUTORS %} id="contributors_enabled" checked="checked" {% endif %}/>
++@@ -24,9 +24,9 @@
++ 
++ <dl>
++   <dt>
++-    <label for="per_likes_amount">{{ lang('PER_LIKES_AMOUNT') ~ lang('COLON') }}</label>
+++    <label for="per_likes_amount">{{ lang('PER_LIKES_AMOUNT') }}{{ lang('COLON') }}</label>
++   </dt>
++   <dd>
++-    <label><input type="number" name="per_likes_amount" value="{{ PERLIKES_AMOUNT }}" min="0" max="9999"></label>
+++    <label><input type="number" name="per_likes_amount" value="{{ PERLIKES_AMOUNT }}" min="0" max="99999"></label>
++   </dd>
++ </dl>
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\likepoints/adm/style/event/sitesplat_bbpoints_acp_after_manage_bbpoints_points_registration_field.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/adm/style/event/sitesplat_bbpoints_acp_after_manage_bbpoints_points_registration_field.html"
++index d1d8a6abc..807f614b2 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\likepoints/adm/style/event/sitesplat_bbpoints_acp_after_manage_bbpoints_points_registration_field.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/adm/style/event/sitesplat_bbpoints_acp_after_manage_bbpoints_points_registration_field.html"
++@@ -1,8 +1,8 @@
++ <dl>
++-  <dt><label for="per_likes">{L_ACP_POINTS}{L_COLON}</label><br /><span>{L_ACP_POINTS_PERLIKES_EXPLAIN}</span></dt>
+++  <dt><label for="per_likes">{L_ACP_POINTS}{L_COLON}</label><br /><span>{L_ACP_POINTS_PER_LIKES_EXPLAIN}</span></dt>
++   <dd>
++     <div style="float:left;width:100%;font-size:0.85em">
++-      {L_POINTS_PERLIKES}
+++      {L_ACP_POINTS_PER_LIKES}
++     </div>
++   </dd>
++   <dd>
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\likepoints/adm/style/event/sitesplat_bbpoints_acp_after_manage_bbpoints_points_sync_points_field.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/adm/style/event/sitesplat_bbpoints_acp_after_manage_bbpoints_points_sync_points_field.html"
++index eccc0daf3..52b8a6baf 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\likepoints/adm/style/event/sitesplat_bbpoints_acp_after_manage_bbpoints_points_sync_points_field.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/adm/style/event/sitesplat_bbpoints_acp_after_manage_bbpoints_points_sync_points_field.html"
++@@ -17,9 +17,9 @@
++       </div>
++     </div>
++     <br/>
++-    <div id="sync_like_points-processing" style="display: none;">Processing ...</div>
+++    <div id="sync_like_points-processing" style="display: none;">{L_SYNC_LIKE_POINTS_PROCESSING}</div>
++     <br/>
++-    <div id="sync_like_points-summary" style="display: none;">Total posts:
+++    <div id="sync_like_points-summary" style="display: none;">{L_SYNC_LIKE_POINTS_TOTAL_POSTS}{L_COLON}
++       <span id="total-posts"></span></div>
++   </dd>
++ </dl>
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\likepoints/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/composer.json"
++index fbc821998..fac083642 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\likepoints/composer.json"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/composer.json"
++@@ -2,14 +2,12 @@
++     "name": "leinad4mind/likepoints",
++     "type": "phpbb-extension",
++     "description": "Bridge between the BBPoints and LikeDD extensions",
++-    "homepage": "https://leinad4mind.top/forum/",
++-    "version": "2.1.0",
++-    "time": "2025-08-16",
+++    "version": "2.0.0",
+++    "time": "2022-05-25",
++     "license": "Proprietary",
++     "authors": [
++         {
++             "name": "Leinad4Mind",
++-            "homepage": "https://leinad4mind.top/forum",
++             "role": "Developer"
++         }
++     ],
++@@ -21,12 +19,6 @@
++         "display-name": "Bridge BBPoints and LikeDD",
++         "soft-require": {
++             "phpbb/phpbb": ">=3.3.4"
++-        },
++-        "version-check": {
++-            "host": "leinad4mind.top",
++-            "directory": "/phpbb/likepoints",
++-            "filename": "version_check.json",
++-            "ssl": true
++         }
++     }
++ }
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\likepoints/controller/admin_controller.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/controller/admin_controller.php"
++index cea87e5c5..07ae97e1d 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\likepoints/controller/admin_controller.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/controller/admin_controller.php"
++@@ -4,7 +4,7 @@
++  *
++  * LikePoints extension for the phpBB Forum Software package.
++  *
++- * @copyright (c) 2022-2025 Leinad4Mind All rights reserved
+++ * @copyright (c) 2022 Leinad4Mind All rights reserved
++  * @license Proprietary
++  *
++  */
++@@ -54,9 +54,8 @@ class admin_controller
++   public function get_default_likepoint_amount()
++   {
++     $sql = "SELECT config_value FROM $this->config_table WHERE config_name = 'bbpoints_settings' LIMIT 1";
++-    $result = $this->db->sql_query($sql);
++-    $config = $this->db->sql_fetchfield('config_value', $result);
++-    $this->db->sql_freeresult($result);
+++    $this->db->sql_query($sql);
+++    $config  = $this->db->sql_fetchfield('config_value');
++     $config = json_decode($config, true);
++     return (int) ($config['per_likes'] ?? 10);
++   }
++@@ -187,7 +186,7 @@ class admin_controller
++ 
++   protected function get_contributors($post_id)
++   {
++-    $sql = 'SELECT contributors FROM ' . POSTS_TABLE . ' WHERE post_id = ' . (int) $post_id . ' LIMIT 1';
+++    $sql = 'SELECT contributors FROM ' . POSTS_TABLE . ' WHERE post_id = ' . $post_id . ' LIMIT 1';
++     $this->db->sql_query($sql);
++     $contributors = $this->db->sql_fetchfield('contributors');
++     if ($contributors === '') {
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\likepoints/controller/main.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/controller/main.php"
++index 4a947ec97..670c0696d 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\likepoints/controller/main.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/controller/main.php"
++@@ -4,7 +4,7 @@
++  *
++  * LikePoints extension for the phpBB Forum Software package.
++  *
++- * @copyright (c) 2022-2025 Leinad4Mind All rights reserved
+++ * @copyright (c) 2022 Leinad4Mind All rights reserved
++  * @license Proprietary
++  *
++  */
++@@ -49,42 +49,39 @@ class main
++    {
++       if ($this->request->is_ajax()) {
++          $json_response = new json_response();
++-         $term = $this->request->variable('term', '');
+++         $term = $this->request->variable('term', '', true);
++          $term = strtolower(trim($term));
++          if (empty($term)) {
++             $json_response->send([]);
++             return;
++          }
++          $mode = $this->request->variable('mode', 'post');
++-         $post_id = (int) $this->request->variable('p', '');
++-         $topic_id = (int) $this->request->variable('topic_id', '');
+++         $post_id = $this->request->variable('p', '');
+++         $topic_id = $this->request->variable('topic_id', '');
++ 
++-         $predicate = ' AND u.username_clean ' . $this->db->sql_like_expression($term . $this->db->get_any_char());
+++         $like = $this->db->sql_like_expression($this->db->sql_escape($term) . $this->db->get_any_char());
+++
+++         $predicate = ' AND u.username_clean ' . $like;
++          if (($mode == 'edit' || $mode == 'reply') && empty($topic_id)) {
++             $sql = 'SELECT topic_id FROM ' . $this->posts_table . ' WHERE post_id = ' . $post_id;
++             $result = $this->db->sql_query($sql);
++             $row = $this->db->sql_fetchrow($result);
++-            $topic_id = $row['topic_id'] ?? 0;
+++            $topic_id = $row['topic_id'];
++          }
++          if (!empty($topic_id)) {
++-            $sql = 'SELECT poster_id FROM ' . $this->posts_table . ' WHERE topic_id = ' . $topic_id;
++-            $result = $this->db->sql_query($sql);
++-            $poster_ids = [];
++-            while ($row = $this->db->sql_fetchrow($result)) {
++-               $poster_ids[] = $row['poster_id'];
++-            }
++-            if (!empty($poster_ids)) {
++-               $predicate .= ' AND u.user_id NOT IN(' . implode(',', array_map('intval', $poster_ids)) . ')';
++-            }
+++            $sql = 'SELECT poster_id FROM ' . $this->posts_table . ' WHERE topic_id = ' . $topic_id . ' ORDER BY post_time ASC';
+++            $result = $this->db->sql_query_limit($sql, 1);
+++            $row = $this->db->sql_fetchrow($result);
+++            $author_id = (int) $row['poster_id'];
+++            $predicate .= ' AND u.user_id != ' . $author_id;
++          }
++ 
++          $sql = 'SELECT DISTINCT(u.username), u.user_id, user_avatar, user_avatar_type, user_avatar_width, user_avatar_height
++-				FROM ' . $this->users_table . ' u
++-				WHERE u.user_type IN (' . USER_NORMAL . ', ' . USER_FOUNDER . ')' . $predicate . '
++-				ORDER BY u.user_posts DESC';
+++               FROM ' . $this->users_table . ' u
+++               WHERE u.user_type IN (' . USER_NORMAL . ', ' . USER_FOUNDER . ')' . $predicate . '
+++               ORDER BY u.user_posts DESC';
++          $result = $this->db->sql_query_limit($sql, 10);
++          $usernames = [];
++-         $style_path = $this->user->style['style_path'] ?? 'prosilver';
++          while ($row = $this->db->sql_fetchrow($result)) {
++             $usernames[] = [
++                $row['username'],
++@@ -98,7 +95,7 @@ class main
++                   )
++                ) . ' ' . $row['username'] . '</div>' :
++                   '<div class="nemtion"><img src="' .
++-                  generate_board_url() . '/styles/' . $style_path . '/theme/images/no-avatar.png'
+++                  generate_board_url() . '/styles/' . $this->user->style['style_path'] . '/theme/images/no-avatar.png'
++                   . '"> ' . $row['username'] . '</div>',
++             ];
++          }
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/diff_full.tmp"
++new file mode 100644
++index 000000000..187811642
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/diff_full.tmp"
++@@ -0,0 +1,141 @@
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\likepoints/adm/style/event/acp_forums_normal_settings_append.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/adm/style/event/acp_forums_normal_settings_append.html"
+++index df5159f7d..0a9302ef2 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\likepoints/adm/style/event/acp_forums_normal_settings_append.html"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/adm/style/event/acp_forums_normal_settings_append.html"
+++@@ -1,6 +1,6 @@
+++ <dl>
+++   <dt>
+++-    <label for="per_likes_enabled">{{ lang('PER_LIKES_ENABLE') ~ lang('COLON') }}</label>
++++    <label for="per_likes_enabled">{{ lang('PER_LIKES_ENABLE') }}{{ lang('COLON') }}</label>
+++   </dt>
+++   <dd>
+++     <label><input type="radio" class="radio" name="per_likes_enabled" value="1" {% if S_ENABLE_LIKES %} id="per_likes_enabled" checked="checked" {% endif %}/>
+++@@ -12,7 +12,7 @@
+++ 
+++ <dl>
+++   <dt>
+++-    <label for="contributors_enabled">{{ lang('CONTRIBUTORS_ENABLE') ~ lang('COLON') }}</label>
++++    <label for="contributors_enabled">{{ lang('CONTRIBUTORS_ENABLE') }}{{ lang('COLON') }}</label>
+++   </dt>
+++   <dd>
+++     <label><input type="radio" class="radio" name="contributors_enabled" value="1" {% if S_ENABLE_CONTRIBUTORS %} id="contributors_enabled" checked="checked" {% endif %}/>
+++@@ -24,9 +24,9 @@
+++ 
+++ <dl>
+++   <dt>
+++-    <label for="per_likes_amount">{{ lang('PER_LIKES_AMOUNT') ~ lang('COLON') }}</label>
++++    <label for="per_likes_amount">{{ lang('PER_LIKES_AMOUNT') }}{{ lang('COLON') }}</label>
+++   </dt>
+++   <dd>
+++-    <label><input type="number" name="per_likes_amount" value="{{ PERLIKES_AMOUNT }}" min="0" max="9999"></label>
++++    <label><input type="number" name="per_likes_amount" value="{{ PERLIKES_AMOUNT }}" min="0" max="99999"></label>
+++   </dd>
+++ </dl>
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\likepoints/adm/style/event/sitesplat_bbpoints_acp_after_manage_bbpoints_points_registration_field.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/adm/style/event/sitesplat_bbpoints_acp_after_manage_bbpoints_points_registration_field.html"
+++index d1d8a6abc..807f614b2 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\likepoints/adm/style/event/sitesplat_bbpoints_acp_after_manage_bbpoints_points_registration_field.html"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/adm/style/event/sitesplat_bbpoints_acp_after_manage_bbpoints_points_registration_field.html"
+++@@ -1,8 +1,8 @@
+++ <dl>
+++-  <dt><label for="per_likes">{L_ACP_POINTS}{L_COLON}</label><br /><span>{L_ACP_POINTS_PERLIKES_EXPLAIN}</span></dt>
++++  <dt><label for="per_likes">{L_ACP_POINTS}{L_COLON}</label><br /><span>{L_ACP_POINTS_PER_LIKES_EXPLAIN}</span></dt>
+++   <dd>
+++     <div style="float:left;width:100%;font-size:0.85em">
+++-      {L_POINTS_PERLIKES}
++++      {L_ACP_POINTS_PER_LIKES}
+++     </div>
+++   </dd>
+++   <dd>
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\likepoints/adm/style/event/sitesplat_bbpoints_acp_after_manage_bbpoints_points_sync_points_field.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/adm/style/event/sitesplat_bbpoints_acp_after_manage_bbpoints_points_sync_points_field.html"
+++index eccc0daf3..52b8a6baf 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\likepoints/adm/style/event/sitesplat_bbpoints_acp_after_manage_bbpoints_points_sync_points_field.html"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/adm/style/event/sitesplat_bbpoints_acp_after_manage_bbpoints_points_sync_points_field.html"
+++@@ -17,9 +17,9 @@
+++       </div>
+++     </div>
+++     <br/>
+++-    <div id="sync_like_points-processing" style="display: none;">Processing ...</div>
++++    <div id="sync_like_points-processing" style="display: none;">{L_SYNC_LIKE_POINTS_PROCESSING}</div>
+++     <br/>
+++-    <div id="sync_like_points-summary" style="display: none;">Total posts:
++++    <div id="sync_like_points-summary" style="display: none;">{L_SYNC_LIKE_POINTS_TOTAL_POSTS}{L_COLON}
+++       <span id="total-posts"></span></div>
+++   </dd>
+++ </dl>
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\likepoints/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/composer.json"
+++index fbc821998..fac083642 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\likepoints/composer.json"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/composer.json"
+++@@ -2,14 +2,12 @@
+++     "name": "leinad4mind/likepoints",
+++     "type": "phpbb-extension",
+++     "description": "Bridge between the BBPoints and LikeDD extensions",
+++-    "homepage": "https://leinad4mind.top/forum/",
+++-    "version": "2.1.0",
+++-    "time": "2025-08-16",
++++    "version": "2.0.0",
++++    "time": "2022-05-25",
+++     "license": "Proprietary",
+++     "authors": [
+++         {
+++             "name": "Leinad4Mind",
+++-            "homepage": "https://leinad4mind.top/forum",
+++             "role": "Developer"
+++         }
+++     ],
+++@@ -21,12 +19,6 @@
+++         "display-name": "Bridge BBPoints and LikeDD",
+++         "soft-require": {
+++             "phpbb/phpbb": ">=3.3.4"
+++-        },
+++-        "version-check": {
+++-            "host": "leinad4mind.top",
+++-            "directory": "/phpbb/likepoints",
+++-            "filename": "version_check.json",
+++-            "ssl": true
+++         }
+++     }
+++ }
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\likepoints/controller/admin_controller.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/controller/admin_controller.php"
+++index cea87e5c5..07ae97e1d 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\likepoints/controller/admin_controller.php"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/controller/admin_controller.php"
+++@@ -4,7 +4,7 @@
+++  *
+++  * LikePoints extension for the phpBB Forum Software package.
+++  *
+++- * @copyright (c) 2022-2025 Leinad4Mind All rights reserved
++++ * @copyright (c) 2022 Leinad4Mind All rights reserved
+++  * @license Proprietary
+++  *
+++  */
+++@@ -54,9 +54,8 @@ class admin_controller
+++   public function get_default_likepoint_amount()
+++   {
+++     $sql = "SELECT config_value FROM $this->config_table WHERE config_name = 'bbpoints_settings' LIMIT 1";
+++-    $result = $this->db->sql_query($sql);
+++-    $config = $this->db->sql_fetchfield('config_value', $result);
+++-    $this->db->sql_freeresult($result);
++++    $this->db->sql_query($sql);
++++    $config  = $this->db->sql_fetchfield('config_value');
+++     $config = json_decode($config, true);
+++     return (int) ($config['per_likes'] ?? 10);
+++   }
+++@@ -187,7 +186,7 @@ class admin_controller
+++ 
+++   protected function get_contributors($post_id)
+++   {
+++-    $sql = 'SELECT contributors FROM ' . POSTS_TABLE . ' WHERE post_id = ' . (int) $post_id . ' LIMIT 1';
++++    $sql = 'SELECT contributors FROM ' . POSTS_TABLE . ' WHERE post_id = ' . $post_id . ' LIMIT 1';
+++     $this->db->sql_query($sql);
+++     $contributors = $this->db->sql_fetchfield('contributors');
+++     if ($contributors === '') {
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\likepoints/controller/main.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/controller/main.php"
+++index 4a947ec97..670c0696d 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\likepoints/controller/main.php"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/controller/main.php"
+++@@ -4,7 +4,7 @@
+++  *
+++  * LikePoints extension for the phpBB Forum Software package.
+++  *
+++- * @copyright (c) 2022-
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\likepoints/event/admin_listener.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/event/admin_listener.php"
++index e5b92c412..a8b20207b 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\likepoints/event/admin_listener.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/event/admin_listener.php"
++@@ -4,7 +4,7 @@
++  *
++  * LikePoints extension for the phpBB Forum Software package.
++  *
++- * @copyright (c) 2022-2025 Leinad4Mind All rights reserved
+++ * @copyright (c) 2022 Leinad4Mind All rights reserved
++  * @license Proprietary
++  *
++  */
++@@ -57,7 +57,7 @@ class admin_listener implements EventSubscriberInterface
++       $this->helper   = $helper;
++       $this->config = $config;
++       $this->config_table = $config_table;
++-      $this->bbpoints_config = !empty($this->config['bbpoints_settings']) ? json_decode($this->config['bbpoints_settings'], true) : [];
+++      $this->bbpoints_config = json_decode($this->config['bbpoints_settings'], true);
++    }
++ 
++    /**
++@@ -123,13 +123,13 @@ class admin_listener implements EventSubscriberInterface
++     */
++    public function acp_manage_forums_display_form($event)
++    {
+++      //$this->user->add_lang_ext('leinad4mind/likepoints', 'info_acp_likepoints');
++       $this->language->add_lang('info_acp_likepoints', 'leinad4mind/likepoints');
++       $row = null;
++       if ($event['action'] !== 'add') {
++-         $sql = 'SELECT per_likes_amount FROM ' . FORUMS_TABLE . ' WHERE forum_id = ' . (int) $event['forum_data']['forum_id'] . ' and per_likes_enabled = 1';
+++         $sql = 'SELECT per_likes_amount FROM ' . FORUMS_TABLE . ' WHERE forum_id = ' . $event['forum_data']['forum_id'] . ' and per_likes_enabled = 1';
++          $result = $this->db->sql_query($sql);
++          $row = $this->db->sql_fetchrow($result);
++-         $this->db->sql_freeresult($result);
++       }
++ 
++       $this->template->assign_vars(array(
++@@ -152,20 +152,19 @@ class admin_listener implements EventSubscriberInterface
++       $contributors_enabled = $this->request->variable('contributors_enabled', 0);
++       $amount = $this->request->variable('per_likes_amount', $this->get_default_likepoint_amount());
++       $sql = 'UPDATE ' . FORUMS_TABLE . '
++-            SET per_likes_enabled = ' . (int) $per_likes_enabled . ',
++-                contributors_enabled = ' . (int) $contributors_enabled . ',
++-                per_likes_amount = ' . (int) $amount . '
++-            WHERE forum_id = ' . (int) $event['forum_data']['forum_id'];
+++				SET per_likes_enabled = ' . $per_likes_enabled . ',
+++            contributors_enabled = ' . $contributors_enabled . ',
+++					per_likes_amount = ' . $amount . '
+++				WHERE forum_id = ' . $event['forum_data']['forum_id'];
++       $this->db->sql_query($sql);
++    }
++ 
++    public function get_default_likepoint_amount()
++    {
++       $sql = "SELECT config_value FROM $this->config_table WHERE config_name = 'bbpoints_settings' LIMIT 1";
++-      $result = $this->db->sql_query($sql);
++-      $config = $this->db->sql_fetchfield('config_value', false, $result);
++-      $this->db->sql_freeresult($result);
+++      $this->db->sql_query($sql);
+++      $config  = $this->db->sql_fetchfield('config_value');
++       $config = json_decode($config, true);
++-      return isset($config['per_likes']) ? (int) $config['per_likes'] : 10;
+++      return (int) ($config['per_likes'] ?? 10);
++    }
++ }
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\likepoints/event/listener.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/event/listener.php"
++index 4438610d7..379ef098e 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\likepoints/event/listener.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/event/listener.php"
++@@ -4,7 +4,7 @@
++  *
++  * LikePoints extension for the phpBB Forum Software package.
++  *
++- * @copyright (c) 2022-2025 Leinad4Mind All rights reserved
+++ * @copyright (c) 2022 Leinad4Mind All rights reserved
++  * @license Proprietary
++  *
++  */
++@@ -84,16 +84,12 @@ class listener implements EventSubscriberInterface
++     */
++    public function display_viewtopic_contributors($event): void
++    {
++-      
++       $sql = 'SELECT contributors_enabled FROM ' . FORUMS_TABLE . ' WHERE forum_id = ' . $event['row']['forum_id'];
++-      $result = $this->db->sql_query($sql);
++-      $contributors_enabled = (bool) $this->db->sql_fetchfield('contributors_enabled', $result);
++-      $this->db->sql_freeresult($result);
++-
+++      $this->db->sql_query($sql);
+++      $contributors_enabled  = $this->db->sql_fetchfield('contributors_enabled');
++       $event['post_row'] = array_merge($event['post_row'], array(
++-         'S_ENABLE_CONTRIBUTORS' => true,
+++         'S_ENABLE_CONTRIBUTORS' => $contributors_enabled,
++       ));
++-
++       if (!$contributors_enabled) {
++          return;
++       }
++@@ -103,16 +99,14 @@ class listener implements EventSubscriberInterface
++          $event['post_row'] = array_merge($event['post_row'], array(
++             'S_ENABLE_CONTRIBUTORS' => false,
++          ));
++-         return;
++       }
++ 
++       $contrs = '';
++       foreach ($contributors as $u) {
++          $user_id = (int) $u;
++          $sql = 'SELECT username FROM ' . USERS_TABLE . ' WHERE user_id = ' . $user_id . ' LIMIT 1';
++-         $result = $this->db->sql_query($sql);
++-         $username = $this->db->sql_fetchfield('username', $result);
++-         $this->db->sql_freeresult($result); 
+++         $this->db->sql_query($sql);
+++         $username = $this->db->sql_fetchfield('username');
++          $contrs .= '<a href="' . append_sid('memberlist.php?mode=viewprofile&u=' . $user_id) . '">' . $username . '</a>, ';
++       }
++ 
++@@ -184,7 +178,7 @@ class listener implements EventSubscriberInterface
++          return;
++       }
++ 
++-      if ($liked_post_id > 0 && $user_points <= $amount) {
+++      if ($liked_post_id > 0 && $user_points < $amount) {
++          $message = $this->language->lang_array('LOG_TRANSFER_POINTS_NOT_ENOUGH', [
++             $amount, $user_id
++          ]);
++@@ -219,19 +213,17 @@ class listener implements EventSubscriberInterface
++    {
++       // Get the current user's points, calculated only from public posts
++       $sql = 'SELECT user_id, SUM(points) as total FROM (
++-      SELECT poster_id AS user_id, SUM(bbpoints) AS points FROM ' . POSTS_TABLE . ' WHERE post_visibility = 1 AND poster_id = ' . (int) $user_id . ' GROUP BY poster_id
+++      SELECT poster_id AS user_id, SUM(bbpoints) AS points FROM ' . POSTS_TABLE . ' WHERE post_visibility = 1 AND poster_id = ' . $user_id . ' GROUP BY poster_id
++       UNION ALL
++-      SELECT topic_poster AS user_id, SUM(bbpoints) AS points FROM ' . TOPICS_TABLE . ' WHERE topic_poster = ' . (int) $user_id . ' GROUP BY topic_poster
+++      SELECT topic_poster AS user_id, SUM(bbpoints) AS points FROM ' . TOPICS_TABLE . ' WHERE topic_poster = ' . $user_id . ' GROUP BY topic_poster
++       UNION ALL
++-      SELECT to_id AS user_id, SUM(bbpoints) AS points FROM ' . $this->bbpoints_table . ' WHERE to_id = ' . (int) $user_id . ' GROUP BY to_id
+++      SELECT to_id AS user_id, SUM(bbpoints) AS points FROM ' . $this->bbpoints_table . ' WHERE to_id = ' . $user_id . ' GROUP BY to_id
++       UNION ALL
++-      SELECT from_id AS user_id, SUM(- bbpoints) AS points FROM ' . $this->bbpoints_table . ' WHERE from_id = ' . (int) $user_id . ' GROUP BY from_id
+++      SELECT from_id AS user_id, SUM(- bbpoints) AS points FROM ' . $this->bbpoints_table . ' WHERE from_id = ' . $user_id . ' GROUP BY from_id
++             ) t1 GROUP BY user_id';
++-      $result = $this->db->sql_query($sql);
++-      $user_points = (int) $this->db->sql_fetchfield('total', $result);
++-      $this->db->sql_freeresult($result);
++-
++-      return $user_points;
+++      $this->db->sql_query($sql);
+++      $user_points  = $this->db->sql_fetchfield('total');
+++      return (int) $user_points;
++    }
++ 
++    protected function transfer_points(int $from_id, int $to_id, int $topic_id, int $post_id, int $points = 0, string $reason = ''): void
++@@ -271,9 +263,8 @@ class listener implements EventSubscriberInterface
++          return;
++       }
++       $sql = 'SELECT bbpoints FROM ' . $this->bbpoints_table . ' WHERE from_id = ' . $from_id . ' AND to_id = ' . $to_id . ' AND topic_id = ' . $topic_id . ' LIMIT 1';
++-      $result = $this->db->sql_query($sql);
++-      $likepoints = (int) $this->db->sql_fetchfield('bbpoints', $result);
++-      $this->db->sql_freeresult($result);
+++      $this->db->sql_query($sql);
+++      $likepoints = (int) $this->db->sql_fetchfield('bbpoints');
++       if ($likepoints === $points) {
++          // We can undo the operation instead of transferring the points back and forth.
++          $sql = 'DELETE FROM ' . $this->bbpoints_table . ' WHERE from_id = ' . $from_id . ' AND to_id = ' . $to_id . ' AND topic_id = ' . $topic_id . ' AND bbpoints = ' . $points . ' LIMIT 1';
++@@ -297,13 +288,9 @@ class listener implements EventSubscriberInterface
++       if (!$post_id) {
++          return 0;
++       }
++-
++       $sql = 'SELECT poster_id FROM ' . POSTS_TABLE . ' WHERE post_id = ' . $post_id . ' LIMIT 1';
++-      $result = $this->db->sql_query($sql);
++-      $poster_id = (int) $this->db->sql_fetchfield('poster_id', $result);
++-      $this->db->sql_freeresult($result);
++-
++-      return $poster_id;
+++      $this->db->sql_query($sql);
+++      return (int) $this->db->sql_fetchfield('poster_id');
++    }
++ 
++    protected function get_amount(int $post_id): int
++@@ -329,7 +316,8 @@ class listener implements EventSubscriberInterface
++ 
++    public function update_contributors($event)
++    {
++-      $post_id = (int) $event['post_id'];
+++      $post_id = (int) ($event['data']['post_id'] ?? $event['post_id']);
+++
++       if (!$post_id) {
++          return;
++       }
++@@ -337,12 +325,12 @@ class listener implements EventSubscriberInterface
++          // this is only a preview
++          return;
++       }
++-      $contributors = $this->request->variable('contributors', '');
+++      $contributors = $this->request->variable('contributors', '', true);
++       $sql = 'SELECT contributors_enabled FROM ' . FORUMS_TABLE . ' WHERE forum_id = (
++          SELECT forum_id FROM ' . POSTS_TABLE . ' WHERE post_id = ' . $post_id . ')';
++-      $result = $this->db->sql_query($sql);
++-      $contributors_enabled  = $this->db->sql_fetchfield('contributors_enabled', $result);
++-      $this->db->sql_freeresult($result);
+++      $this->db->sql_query($sql);
+++      $contributors_enabled  = $this->db->sql_fetchfield('contributors_enabled');
+++
++       if (!$contributors_enabled) {
++          return;
++       }
++@@ -359,9 +347,8 @@ class listener implements EventSubscriberInterface
++             continue;
++          }
++          $sql = 'SELECT user_id FROM ' . USERS_TABLE . ' WHERE username_clean = \'' . $this->db->sql_escape(strtolower($username)) . '\' LIMIT 1';
++-         $result = $this->db->sql_query($sql);
++-         $user_id = (int) $this->db->sql_fetchfield('user_id', $result);
++-         $this->db->sql_freeresult($result);
+++         $this->db->sql_query($sql);
+++         $user_id = (int) $this->db->sql_fetchfield('user_id');
++          if ($user_id > 0) {
++             $value[] = $user_id;
++          }
++@@ -376,22 +363,21 @@ class listener implements EventSubscriberInterface
++    protected function get_contributors($post_id)
++    {
++       $sql = 'SELECT contributors_enabled FROM ' . FORUMS_TABLE . ' INNER JOIN ' . POSTS_TABLE . ' ON ' . POSTS_TABLE . '.forum_id = ' . FORUMS_TABLE . '.forum_id WHERE ' . POSTS_TABLE . '.post_id = ' . $post_id . ' LIMIT 1';
++-      $result = $this->db->sql_query($sql);
++-      $row = $this->db->sql_fetchrow($result);
++-      $this->db->sql_freeresult($result);
+++      $this->db->sql_query($sql);
+++      $row = $this->db->sql_fetchrow();
++       $enabled = isset($row['contributors_enabled']) ? $row['contributors_enabled'] : false;
++       if (!$enabled) {
++          return [];
++       }
++ 
++       $sql = 'SELECT contributors FROM ' . POSTS_TABLE . ' WHERE post_id = ' . $post_id . ' LIMIT 1';
++-      $result = $this->db->sql_query($sql);
++-      $contributors = $this->db->sql_fetchfield('contributors', $result);
++-      $this->db->sql_freeresult($result);
+++      $this->db->sql_query($sql);
+++      $contributors = $this->db->sql_fetchfield('contributors');
++       if ($contributors === '') {
++          return [];
++       }
++       $contributors = explode(',', $contributors);
+++      // $contributors = array_map('intval', $contributors);
++       return $contributors;
++    }
++ 
++@@ -405,14 +391,23 @@ class listener implements EventSubscriberInterface
++          return;
++       }
++       $post_id = (int) $event['post_id'];
+++      $forum_id = (int) $event['forum_id'];
+++      // $topic_first_post_id = (int) $event['post_data']['topic_first_post_id'];
+++      // Check if 'topic_first_post_id' key exists in the $event['post_data'] array
+++      $topic_first_post_id = isset($event['post_data']['topic_first_post_id']) ? (int) $event['post_data']['topic_first_post_id'] : 0;
++ 
++-      $sql = 'SELECT contributors_enabled FROM ' . FORUMS_TABLE . ' WHERE forum_id = (
+++
+++      if ($post_id) {
+++         $sql = 'SELECT contributors_enabled FROM ' . FORUMS_TABLE . ' WHERE forum_id = (
++          SELECT forum_id FROM ' . POSTS_TABLE . ' WHERE post_id = ' . $post_id . ')';
++-      $result = $this->db->sql_query($sql);
++-      $contributors_enabled  = $this->db->sql_fetchfield('contributors_enabled', $result);
++-      $this->db->sql_freeresult($result);
+++      } else {
+++         $sql = 'SELECT contributors_enabled FROM ' . FORUMS_TABLE . ' WHERE forum_id = ' . $forum_id;
+++      }
+++      $this->db->sql_query($sql);
+++      $contributors_enabled  = $this->db->sql_fetchfield('contributors_enabled');
+++
++       $this->template->assign_vars(array(
++-         'S_ENABLE_CONTRIBUTORS' => $contributors_enabled ? true : false,
+++         'S_ENABLE_CONTRIBUTORS' => $contributors_enabled ? ($topic_first_post_id == $post_id || $event['mode'] == 'post') : false,
++       ));
++ 
++       if (!$contributors_enabled) {
++@@ -424,9 +419,8 @@ class listener implements EventSubscriberInterface
++       foreach ($contributors as $u) {
++          $user_id = (int) $u;
++          $sql = 'SELECT username FROM ' . USERS_TABLE . ' WHERE user_id = ' . $user_id . ' LIMIT 1';
++-         $result = $this->db->sql_query($sql);
++-         $username = $this->db->sql_fetchfield('username', $result);
++-         $this->db->sql_freeresult($result);
+++         $this->db->sql_query($sql);
+++         $username = $this->db->sql_fetchfield('username');
++          $a[] = $username;
++       }
++       $this->template->assign_vars(array(
++@@ -437,19 +431,15 @@ class listener implements EventSubscriberInterface
++    public function get_topic_id($post_id)
++    {
++       $sql = 'SELECT topic_id FROM ' . POSTS_TABLE . ' WHERE post_id = ' . $post_id . ' LIMIT 1';
++-      $result = $this->db->sql_query($sql);
++-      $topic_id = (int) $this->db->sql_fetchfield('topic_id', $result);
++-      $this->db->sql_freeresult($result);
++-      return $topic_id;
+++      $this->db->sql_query($sql);
+++      return (int) $this->db->sql_fetchfield('topic_id');
++    }
++ 
++    public function is_unlike($post_id, $user_id)
++    {
++       $sql = 'SELECT COUNT(*) AS count FROM ' . $this->bblikes_table . ' WHERE post_id = ' . $post_id . ' AND user_id = ' . $user_id;
++-      $result = $this->db->sql_query($sql);
++-      $count = (int) $this->db->sql_fetchfield('count', $result);
++-      $this->db->sql_freeresult($result);
++-
+++      $this->db->sql_query($sql);
+++      $count = (int) $this->db->sql_fetchfield('count');
++       // As we're running this on 'core.submit_likedd_end' event, the existence of a like
++       // means it was a new like and non-existence means the like was removed.
++       return ($count === 0);
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\likepoints/language/en/common.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/language/en/common.php"
++index f61b7cbff..f8bf14e6f 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\likepoints/language/en/common.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/language/en/common.php"
++@@ -4,7 +4,7 @@
++  *
++  * LikePoints extension for the phpBB Forum Software package.
++  *
++- * @copyright (c) 2022-2025 Leinad4Mind All rights reserved
+++ * @copyright (c) 2022 Leinad4Mind All rights reserved
++  * @license Proprietary
++  *
++  */
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\likepoints/language/en/info_acp_likepoints.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/language/en/info_acp_likepoints.php"
++index 5be342dff..39d5950c2 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\likepoints/language/en/info_acp_likepoints.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/language/en/info_acp_likepoints.php"
++@@ -4,7 +4,7 @@
++  *
++  * LikePoints extension for the phpBB Forum Software package.
++  *
++- * @copyright (c) 2022-2025 Leinad4Mind All rights reserved
+++ * @copyright (c) 2022 Leinad4Mind All rights reserved
++  * @license Proprietary
++  *
++  */
++@@ -23,7 +23,11 @@ if (!isset($lang) || !is_array($lang)) {
++ $lang = array_merge($lang, [
++    'PER_LIKES_ENABLE' => 'Enable transfer of BBPoints for likes',
++    'PER_LIKES_AMOUNT' => 'Amount of BBPoints transferred on liking the post',
+++   'ACP_POINTS_PER_LIKES' => 'Points per likes',
+++   'ACP_POINTS_PER_LIKES_EXPLAIN' => 'Set the default amount of points transferred on liking posts. Set to 0 to switch off.',
++    'CONTRIBUTORS_ENABLE' => 'Enable contributors',
++    'SYNC_LIKE_POINTS' => 'Sync like points',
++    'SYNC_LIKE_POINTS_EXPLAIN' => 'Calculates all the points for likes set above for all the users.<br>It can take several minutes and it depends on how many users, posts and likes your board hosts.<br>Do NOT interrput the process once started.',
+++   'SYNC_LIKE_POINTS_PROCESSING' => 'Processing...',
+++   'SYNC_LIKE_POINTS_TOTAL_POSTS' => 'Total posts',
++ ]);
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/language/pt/common.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/language/pt/common.php"
++new file mode 100644
++index 000000000..75afec1db
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/language/pt/common.php"
++@@ -0,0 +1,37 @@
+++<?php
+++
+++/**
+++ *
+++ * LikePoints extension for the phpBB Forum Software package.
+++ *
+++ * @copyright (c) 2022 Leinad4Mind All rights reserved
+++ * @license Proprietary
+++ *
+++ */
+++
+++/**
+++ * DO NOT CHANGE
+++ */
+++if (!defined('IN_PHPBB')) {
+++   exit;
+++}
+++
+++if (!isset($lang) || !is_array($lang)) {
+++   $lang = [];
+++}
+++
+++$lang = array_merge($lang, [
+++   'CONTRIBUTOR_LABEL' => 'Colaboradores',
+++   'LOG_TRANSFER_POINTS' => 'Transferring %d BBPoints to user %d',
+++   'LOG_TRANSFER_POINTS_NOT_ENOUGH' => 'Tried to transfer %d BBPoints to user %d, but did not have enough on balance',
+++   'LOG_UNLIKE_TRANSFER_POINTS_NOT_ENOUGH' => 'Tried to transfer %d BBPoints back from user %d to user %d after a unlike, but they did not have enough on balance',
+++   'LOG_LIKE_TRANSFER_ABORTED' => 'Like action taken back. %d BBPoints returned to user %d from user %d',
+++   'REASON_LIKE' => 'LIKE: Awarded %d points for getting a like from %d.',
+++   'REASON_UNLIKE' => 'UNLIKE: Taken %d points for getting a unlike from %d.',
+++   'REASON_LIKE_CONTRIBUTOR' => 'CONTRIBUTOR LIKE: Awarded %d points for getting a like from %d as contributors from the poster.',
+++   'REASON_UNLIKE_CONTRIBUTOR' => 'CONTRIBUTOR UNLIKE: Taken %d points for removing a like from %d as contributors from the poster.',
+++   'ENTER_TAGS_PLACEHOLDER' => 'Introduza nomes de utilizadores',
+++   'CONTRIBUTED' => 'contribuiu',
+++   'CONTRIBUTEDS' => 'contribuíram',
+++   'NOT_ENOUGH_BALANCE_LIKE' => 'Não tens pontos suficientes para agradecer :(<br>Participa e ajuda a comunidade de forma a obteres mais pontos!',
+++]);
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/language/pt/info_acp_likepoints.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/language/pt/info_acp_likepoints.php"
++new file mode 100644
++index 000000000..39d5950c2
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/language/pt/info_acp_likepoints.php"
++@@ -0,0 +1,33 @@
+++<?php
+++
+++/**
+++ *
+++ * LikePoints extension for the phpBB Forum Software package.
+++ *
+++ * @copyright (c) 2022 Leinad4Mind All rights reserved
+++ * @license Proprietary
+++ *
+++ */
+++
+++/**
+++ * DO NOT CHANGE
+++ */
+++if (!defined('IN_PHPBB')) {
+++   exit;
+++}
+++
+++if (!isset($lang) || !is_array($lang)) {
+++   $lang = [];
+++}
+++
+++$lang = array_merge($lang, [
+++   'PER_LIKES_ENABLE' => 'Enable transfer of BBPoints for likes',
+++   'PER_LIKES_AMOUNT' => 'Amount of BBPoints transferred on liking the post',
+++   'ACP_POINTS_PER_LIKES' => 'Points per likes',
+++   'ACP_POINTS_PER_LIKES_EXPLAIN' => 'Set the default amount of points transferred on liking posts. Set to 0 to switch off.',
+++   'CONTRIBUTORS_ENABLE' => 'Enable contributors',
+++   'SYNC_LIKE_POINTS' => 'Sync like points',
+++   'SYNC_LIKE_POINTS_EXPLAIN' => 'Calculates all the points for likes set above for all the users.<br>It can take several minutes and it depends on how many users, posts and likes your board hosts.<br>Do NOT interrput the process once started.',
+++   'SYNC_LIKE_POINTS_PROCESSING' => 'Processing...',
+++   'SYNC_LIKE_POINTS_TOTAL_POSTS' => 'Total posts',
+++]);
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/language/pt-preao/common.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/language/pt-preao/common.php"
++new file mode 100644
++index 000000000..75afec1db
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/language/pt-preao/common.php"
++@@ -0,0 +1,37 @@
+++<?php
+++
+++/**
+++ *
+++ * LikePoints extension for the phpBB Forum Software package.
+++ *
+++ * @copyright (c) 2022 Leinad4Mind All rights reserved
+++ * @license Proprietary
+++ *
+++ */
+++
+++/**
+++ * DO NOT CHANGE
+++ */
+++if (!defined('IN_PHPBB')) {
+++   exit;
+++}
+++
+++if (!isset($lang) || !is_array($lang)) {
+++   $lang = [];
+++}
+++
+++$lang = array_merge($lang, [
+++   'CONTRIBUTOR_LABEL' => 'Colaboradores',
+++   'LOG_TRANSFER_POINTS' => 'Transferring %d BBPoints to user %d',
+++   'LOG_TRANSFER_POINTS_NOT_ENOUGH' => 'Tried to transfer %d BBPoints to user %d, but did not have enough on balance',
+++   'LOG_UNLIKE_TRANSFER_POINTS_NOT_ENOUGH' => 'Tried to transfer %d BBPoints back from user %d to user %d after a unlike, but they did not have enough on balance',
+++   'LOG_LIKE_TRANSFER_ABORTED' => 'Like action taken back. %d BBPoints returned to user %d from user %d',
+++   'REASON_LIKE' => 'LIKE: Awarded %d points for getting a like from %d.',
+++   'REASON_UNLIKE' => 'UNLIKE: Taken %d points for getting a unlike from %d.',
+++   'REASON_LIKE_CONTRIBUTOR' => 'CONTRIBUTOR LIKE: Awarded %d points for getting a like from %d as contributors from the poster.',
+++   'REASON_UNLIKE_CONTRIBUTOR' => 'CONTRIBUTOR UNLIKE: Taken %d points for removing a like from %d as contributors from the poster.',
+++   'ENTER_TAGS_PLACEHOLDER' => 'Introduza nomes de utilizadores',
+++   'CONTRIBUTED' => 'contribuiu',
+++   'CONTRIBUTEDS' => 'contribuíram',
+++   'NOT_ENOUGH_BALANCE_LIKE' => 'Não tens pontos suficientes para agradecer :(<br>Participa e ajuda a comunidade de forma a obteres mais pontos!',
+++]);
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/language/pt-preao/info_acp_likepoints.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/language/pt-preao/info_acp_likepoints.php"
++new file mode 100644
++index 000000000..39d5950c2
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/language/pt-preao/info_acp_likepoints.php"
++@@ -0,0 +1,33 @@
+++<?php
+++
+++/**
+++ *
+++ * LikePoints extension for the phpBB Forum Software package.
+++ *
+++ * @copyright (c) 2022 Leinad4Mind All rights reserved
+++ * @license Proprietary
+++ *
+++ */
+++
+++/**
+++ * DO NOT CHANGE
+++ */
+++if (!defined('IN_PHPBB')) {
+++   exit;
+++}
+++
+++if (!isset($lang) || !is_array($lang)) {
+++   $lang = [];
+++}
+++
+++$lang = array_merge($lang, [
+++   'PER_LIKES_ENABLE' => 'Enable transfer of BBPoints for likes',
+++   'PER_LIKES_AMOUNT' => 'Amount of BBPoints transferred on liking the post',
+++   'ACP_POINTS_PER_LIKES' => 'Points per likes',
+++   'ACP_POINTS_PER_LIKES_EXPLAIN' => 'Set the default amount of points transferred on liking posts. Set to 0 to switch off.',
+++   'CONTRIBUTORS_ENABLE' => 'Enable contributors',
+++   'SYNC_LIKE_POINTS' => 'Sync like points',
+++   'SYNC_LIKE_POINTS_EXPLAIN' => 'Calculates all the points for likes set above for all the users.<br>It can take several minutes and it depends on how many users, posts and likes your board hosts.<br>Do NOT interrput the process once started.',
+++   'SYNC_LIKE_POINTS_PROCESSING' => 'Processing...',
+++   'SYNC_LIKE_POINTS_TOTAL_POSTS' => 'Total posts',
+++]);
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\likepoints/migrations/m1_initial_install.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/migrations/m1_initial_install.php"
++index a188f2936..5f174ae7a 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\likepoints/migrations/m1_initial_install.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/migrations/m1_initial_install.php"
++@@ -4,7 +4,7 @@
++  *
++  * LikePoints extension for the phpBB Forum Software package.
++  *
++- * @copyright (c) 2022-2025 Leinad4Mind All rights reserved
+++ * @copyright (c) 2022 Leinad4Mind All rights reserved
++  * @license Proprietary
++  *
++  */
++@@ -16,47 +16,22 @@ namespace leinad4mind\likepoints\migrations;
++  */
++ class m1_initial_install extends \phpbb\db\migration\migration
++ {
++-    /**
++-     * Schema changes to apply when installing the extension.
++-     */
++-    public function update_schema()
++-    {
++-        return array(
++-            'add_columns' => array(
++-                $this->table_prefix . 'forums' => array(
++-                    'per_likes_enabled'    => array('BOOL', 1),
++-                    'contributors_enabled' => array('BOOL', 1),
++-                    'per_likes_amount'     => array('UINT:2', 10),
++-                ),
++-                $this->table_prefix . 'posts' => array(
++-                    'contributors' => array('VCHAR:255', ''),
++-                ),
++-                $this->table_prefix . 'bbpoints' => array(
++-                    'post_id' => array('INT:11', 0),
++-                ),
+++   public function update_schema()
+++   {
+++      return array(
+++         'add_columns'   => array(
+++            $this->table_prefix . 'forums'   => array(
+++               'per_likes_enabled'   => array('BOOL', 1),
+++               'contributors_enabled'   => array('BOOL', 1),
+++               'per_likes_amount'   => array('UINT:2', 10),
++             ),
++-        );
++-    }
++-
++-    /**
++-     * Schema changes to revert when uninstalling the extension.
++-     */
++-    public function revert_schema()
++-    {
++-        return array(
++-            'drop_columns' => array(
++-                $this->table_prefix . 'forums' => array(
++-                    'per_likes_enabled',
++-                    'contributors_enabled',
++-                    'per_likes_amount',
++-                ),
++-                $this->table_prefix . 'posts' => array(
++-                    'contributors',
++-                ),
++-                $this->table_prefix . 'bbpoints' => array(
++-                    'post_id',
++-                ),
+++            $this->table_prefix . 'posts'   => array(
+++               'contributors'   => array('VCHAR:255', ''),
+++            ),
+++            $this->table_prefix . 'bbpoints'      => array(
+++               'post_id'   => array('INT:11', '0'),
++             ),
++-        );
++-    }
++-}
+++         )
+++      );
+++   }
+++}
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\likepoints/migrations/m2_add_bbpoints_index.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\likepoints/migrations/m2_add_bbpoints_index.php"
++deleted file mode 100644
++index 983ddecfd..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\likepoints/migrations/m2_add_bbpoints_index.php"
+++++ /dev/null
++@@ -1,49 +0,0 @@
++-<?php
++-
++-/**
++- *
++- * LikePoints extension for the phpBB Forum Software package.
++- *
++- * @copyright (c) 2022-2025 Leinad4Mind All rights reserved
++- * @license Proprietary
++- *
++- */
++-
++-namespace leinad4mind\likepoints\migrations;
++-
++-class m2_add_bbpoints_index extends \phpbb\db\migration\migration
++-{
++-    public static function depends_on()
++-    {
++-        return array('\leinad4mind\likepoints\migrations\m1_initial_install');
++-    }
++-
++-    public function update_schema()
++-    {
++-        return array(
++-            'add_indexes' => array(
++-                $this->table_prefix . 'bbpoints' => array(
++-                    'post_id_idx' => array('post_id'),
++-                ),
++-                $this->table_prefix . 'posts' => array(
++-                    'contributors_index' => array('contributors'),
++-                ),
++-                $this->table_prefix . 'forums' => array(
++-                    'per_likes_enabled_index' => array('per_likes_enabled'),
++-                    'contributors_enabled_index' => array('contributors_enabled'),
++-                ),
++-            ),
++-        );
++-    }
++-
++-    public function revert_schema()
++-    {
++-        return array(
++-            'drop_indexes' => array(
++-                $this->table_prefix . 'bbpoints' => array('post_id_idx'),
++-                $this->table_prefix . 'posts' => array('contributors_index'),
++-                $this->table_prefix . 'forums' => array('per_likes_enabled_index', 'contributors_enabled_index'),
++-            ),
++-        );
++-    }
++-}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\likepoints/styles/all/template/event/posting_editor_subject_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/styles/all/template/event/ss_posting_editor_subject_after.html"
++similarity index 55%
++rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\likepoints/styles/all/template/event/posting_editor_subject_after.html"
++rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/styles/all/template/event/ss_posting_editor_subject_after.html"
++index 7217b6027..996c010bb 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\likepoints/styles/all/template/event/posting_editor_subject_after.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/styles/all/template/event/ss_posting_editor_subject_after.html"
++@@ -5,25 +5,24 @@
++     var lptagsLangPlaceholder = '{{ lang('ENTER_TAGS_PLACEHOLDER') }}';
++   </script>
++ 
++-  <!-- IF not $INCLUDED_LPTAGS_TEXTCOMPLETEJS -->
++-  <!-- IF not BBTAGS_SHOW_FIELD-->
++-  {%
\ No newline at end of file
diff --git "[ORIGINAL]/leinad4mind\\likepoints/event/admin_listener.php" "[FORUM_EXT]/leinad4mind\\likepoints/event/admin_listener.php"
--- "[ORIGINAL]/leinad4mind\\likepoints/event/admin_listener.php"
+++ "[FORUM_EXT]/leinad4mind\\likepoints/event/admin_listener.php"
@@ -4,7 +4,7 @@
  *
  * LikePoints extension for the phpBB Forum Software package.
  *
- * @copyright (c) 2022-2025 Leinad4Mind All rights reserved
+ * @copyright (c) 2022 Leinad4Mind All rights reserved
  * @license Proprietary
  *
  */
@@ -57,7 +57,7 @@ class admin_listener implements EventSubscriberInterface
       $this->helper   = $helper;
       $this->config = $config;
       $this->config_table = $config_table;
-      $this->bbpoints_config = !empty($this->config['bbpoints_settings']) ? json_decode($this->config['bbpoints_settings'], true) : [];
+      $this->bbpoints_config = json_decode($this->config['bbpoints_settings'], true);
    }
 
    /**
@@ -123,13 +123,13 @@ class admin_listener implements EventSubscriberInterface
     */
    public function acp_manage_forums_display_form($event)
    {
+      //$this->user->add_lang_ext('leinad4mind/likepoints', 'info_acp_likepoints');
       $this->language->add_lang('info_acp_likepoints', 'leinad4mind/likepoints');
       $row = null;
       if ($event['action'] !== 'add') {
-         $sql = 'SELECT per_likes_amount FROM ' . FORUMS_TABLE . ' WHERE forum_id = ' . (int) $event['forum_data']['forum_id'] . ' and per_likes_enabled = 1';
+         $sql = 'SELECT per_likes_amount FROM ' . FORUMS_TABLE . ' WHERE forum_id = ' . $event['forum_data']['forum_id'] . ' and per_likes_enabled = 1';
          $result = $this->db->sql_query($sql);
          $row = $this->db->sql_fetchrow($result);
-         $this->db->sql_freeresult($result);
       }
 
       $this->template->assign_vars(array(
@@ -152,20 +152,19 @@ class admin_listener implements EventSubscriberInterface
       $contributors_enabled = $this->request->variable('contributors_enabled', 0);
       $amount = $this->request->variable('per_likes_amount', $this->get_default_likepoint_amount());
       $sql = 'UPDATE ' . FORUMS_TABLE . '
-            SET per_likes_enabled = ' . (int) $per_likes_enabled . ',
-                contributors_enabled = ' . (int) $contributors_enabled . ',
-                per_likes_amount = ' . (int) $amount . '
-            WHERE forum_id = ' . (int) $event['forum_data']['forum_id'];
+				SET per_likes_enabled = ' . $per_likes_enabled . ',
+            contributors_enabled = ' . $contributors_enabled . ',
+					per_likes_amount = ' . $amount . '
+				WHERE forum_id = ' . $event['forum_data']['forum_id'];
       $this->db->sql_query($sql);
    }
 
    public function get_default_likepoint_amount()
    {
       $sql = "SELECT config_value FROM $this->config_table WHERE config_name = 'bbpoints_settings' LIMIT 1";
-      $result = $this->db->sql_query($sql);
-      $config = $this->db->sql_fetchfield('config_value', false, $result);
-      $this->db->sql_freeresult($result);
+      $this->db->sql_query($sql);
+      $config  = $this->db->sql_fetchfield('config_value');
       $config = json_decode($config, true);
-      return isset($config['per_likes']) ? (int) $config['per_likes'] : 10;
+      return (int) ($config['per_likes'] ?? 10);
    }
 }
diff --git "[ORIGINAL]/leinad4mind\\likepoints/event/listener.php" "[FORUM_EXT]/leinad4mind\\likepoints/event/listener.php"
--- "[ORIGINAL]/leinad4mind\\likepoints/event/listener.php"
+++ "[FORUM_EXT]/leinad4mind\\likepoints/event/listener.php"
@@ -4,7 +4,7 @@
  *
  * LikePoints extension for the phpBB Forum Software package.
  *
- * @copyright (c) 2022-2025 Leinad4Mind All rights reserved
+ * @copyright (c) 2022 Leinad4Mind All rights reserved
  * @license Proprietary
  *
  */
@@ -84,16 +84,12 @@ class listener implements EventSubscriberInterface
     */
    public function display_viewtopic_contributors($event): void
    {
-      
       $sql = 'SELECT contributors_enabled FROM ' . FORUMS_TABLE . ' WHERE forum_id = ' . $event['row']['forum_id'];
-      $result = $this->db->sql_query($sql);
-      $contributors_enabled = (bool) $this->db->sql_fetchfield('contributors_enabled', $result);
-      $this->db->sql_freeresult($result);
-
+      $this->db->sql_query($sql);
+      $contributors_enabled  = $this->db->sql_fetchfield('contributors_enabled');
       $event['post_row'] = array_merge($event['post_row'], array(
-         'S_ENABLE_CONTRIBUTORS' => true,
+         'S_ENABLE_CONTRIBUTORS' => $contributors_enabled,
       ));
-
       if (!$contributors_enabled) {
          return;
       }
@@ -103,16 +99,14 @@ class listener implements EventSubscriberInterface
          $event['post_row'] = array_merge($event['post_row'], array(
             'S_ENABLE_CONTRIBUTORS' => false,
          ));
-         return;
       }
 
       $contrs = '';
       foreach ($contributors as $u) {
          $user_id = (int) $u;
          $sql = 'SELECT username FROM ' . USERS_TABLE . ' WHERE user_id = ' . $user_id . ' LIMIT 1';
-         $result = $this->db->sql_query($sql);
-         $username = $this->db->sql_fetchfield('username', $result);
-         $this->db->sql_freeresult($result); 
+         $this->db->sql_query($sql);
+         $username = $this->db->sql_fetchfield('username');
          $contrs .= '<a href="' . append_sid('memberlist.php?mode=viewprofile&u=' . $user_id) . '">' . $username . '</a>, ';
       }
 
@@ -184,7 +178,7 @@ class listener implements EventSubscriberInterface
          return;
       }
 
-      if ($liked_post_id > 0 && $user_points <= $amount) {
+      if ($liked_post_id > 0 && $user_points < $amount) {
          $message = $this->language->lang_array('LOG_TRANSFER_POINTS_NOT_ENOUGH', [
             $amount, $user_id
          ]);
@@ -219,19 +213,17 @@ class listener implements EventSubscriberInterface
    {
       // Get the current user's points, calculated only from public posts
       $sql = 'SELECT user_id, SUM(points) as total FROM (
-      SELECT poster_id AS user_id, SUM(bbpoints) AS points FROM ' . POSTS_TABLE . ' WHERE post_visibility = 1 AND poster_id = ' . (int) $user_id . ' GROUP BY poster_id
+      SELECT poster_id AS user_id, SUM(bbpoints) AS points FROM ' . POSTS_TABLE . ' WHERE post_visibility = 1 AND poster_id = ' . $user_id . ' GROUP BY poster_id
       UNION ALL
-      SELECT topic_poster AS user_id, SUM(bbpoints) AS points FROM ' . TOPICS_TABLE . ' WHERE topic_poster = ' . (int) $user_id . ' GROUP BY topic_poster
+      SELECT topic_poster AS user_id, SUM(bbpoints) AS points FROM ' . TOPICS_TABLE . ' WHERE topic_poster = ' . $user_id . ' GROUP BY topic_poster
       UNION ALL
-      SELECT to_id AS user_id, SUM(bbpoints) AS points FROM ' . $this->bbpoints_table . ' WHERE to_id = ' . (int) $user_id . ' GROUP BY to_id
+      SELECT to_id AS user_id, SUM(bbpoints) AS points FROM ' . $this->bbpoints_table . ' WHERE to_id = ' . $user_id . ' GROUP BY to_id
       UNION ALL
-      SELECT from_id AS user_id, SUM(- bbpoints) AS points FROM ' . $this->bbpoints_table . ' WHERE from_id = ' . (int) $user_id . ' GROUP BY from_id
+      SELECT from_id AS user_id, SUM(- bbpoints) AS points FROM ' . $this->bbpoints_table . ' WHERE from_id = ' . $user_id . ' GROUP BY from_id
             ) t1 GROUP BY user_id';
-      $result = $this->db->sql_query($sql);
-      $user_points = (int) $this->db->sql_fetchfield('total', $result);
-      $this->db->sql_freeresult($result);
-
-      return $user_points;
+      $this->db->sql_query($sql);
+      $user_points  = $this->db->sql_fetchfield('total');
+      return (int) $user_points;
    }
 
    protected function transfer_points(int $from_id, int $to_id, int $topic_id, int $post_id, int $points = 0, string $reason = ''): void
@@ -271,9 +263,8 @@ class listener implements EventSubscriberInterface
          return;
       }
       $sql = 'SELECT bbpoints FROM ' . $this->bbpoints_table . ' WHERE from_id = ' . $from_id . ' AND to_id = ' . $to_id . ' AND topic_id = ' . $topic_id . ' LIMIT 1';
-      $result = $this->db->sql_query($sql);
-      $likepoints = (int) $this->db->sql_fetchfield('bbpoints', $result);
-      $this->db->sql_freeresult($result);
+      $this->db->sql_query($sql);
+      $likepoints = (int) $this->db->sql_fetchfield('bbpoints');
       if ($likepoints === $points) {
          // We can undo the operation instead of transferring the points back and forth.
          $sql = 'DELETE FROM ' . $this->bbpoints_table . ' WHERE from_id = ' . $from_id . ' AND to_id = ' . $to_id . ' AND topic_id = ' . $topic_id . ' AND bbpoints = ' . $points . ' LIMIT 1';
@@ -297,13 +288,9 @@ class listener implements EventSubscriberInterface
       if (!$post_id) {
          return 0;
       }
-
       $sql = 'SELECT poster_id FROM ' . POSTS_TABLE . ' WHERE post_id = ' . $post_id . ' LIMIT 1';
-      $result = $this->db->sql_query($sql);
-      $poster_id = (int) $this->db->sql_fetchfield('poster_id', $result);
-      $this->db->sql_freeresult($result);
-
-      return $poster_id;
+      $this->db->sql_query($sql);
+      return (int) $this->db->sql_fetchfield('poster_id');
    }
 
    protected function get_amount(int $post_id): int
@@ -329,7 +316,8 @@ class listener implements EventSubscriberInterface
 
    public function update_contributors($event)
    {
-      $post_id = (int) $event['post_id'];
+      $post_id = (int) ($event['data']['post_id'] ?? $event['post_id']);
+
       if (!$post_id) {
          return;
       }
@@ -337,12 +325,12 @@ class listener implements EventSubscriberInterface
          // this is only a preview
          return;
       }
-      $contributors = $this->request->variable('contributors', '');
+      $contributors = $this->request->variable('contributors', '', true);
       $sql = 'SELECT contributors_enabled FROM ' . FORUMS_TABLE . ' WHERE forum_id = (
          SELECT forum_id FROM ' . POSTS_TABLE . ' WHERE post_id = ' . $post_id . ')';
-      $result = $this->db->sql_query($sql);
-      $contributors_enabled  = $this->db->sql_fetchfield('contributors_enabled', $result);
-      $this->db->sql_freeresult($result);
+      $this->db->sql_query($sql);
+      $contributors_enabled  = $this->db->sql_fetchfield('contributors_enabled');
+
       if (!$contributors_enabled) {
          return;
       }
@@ -359,9 +347,8 @@ class listener implements EventSubscriberInterface
             continue;
          }
          $sql = 'SELECT user_id FROM ' . USERS_TABLE . ' WHERE username_clean = \'' . $this->db->sql_escape(strtolower($username)) . '\' LIMIT 1';
-         $result = $this->db->sql_query($sql);
-         $user_id = (int) $this->db->sql_fetchfield('user_id', $result);
-         $this->db->sql_freeresult($result);
+         $this->db->sql_query($sql);
+         $user_id = (int) $this->db->sql_fetchfield('user_id');
          if ($user_id > 0) {
             $value[] = $user_id;
          }
@@ -376,22 +363,21 @@ class listener implements EventSubscriberInterface
    protected function get_contributors($post_id)
    {
       $sql = 'SELECT contributors_enabled FROM ' . FORUMS_TABLE . ' INNER JOIN ' . POSTS_TABLE . ' ON ' . POSTS_TABLE . '.forum_id = ' . FORUMS_TABLE . '.forum_id WHERE ' . POSTS_TABLE . '.post_id = ' . $post_id . ' LIMIT 1';
-      $result = $this->db->sql_query($sql);
-      $row = $this->db->sql_fetchrow($result);
-      $this->db->sql_freeresult($result);
+      $this->db->sql_query($sql);
+      $row = $this->db->sql_fetchrow();
       $enabled = isset($row['contributors_enabled']) ? $row['contributors_enabled'] : false;
       if (!$enabled) {
          return [];
       }
 
       $sql = 'SELECT contributors FROM ' . POSTS_TABLE . ' WHERE post_id = ' . $post_id . ' LIMIT 1';
-      $result = $this->db->sql_query($sql);
-      $contributors = $this->db->sql_fetchfield('contributors', $result);
-      $this->db->sql_freeresult($result);
+      $this->db->sql_query($sql);
+      $contributors = $this->db->sql_fetchfield('contributors');
       if ($contributors === '') {
          return [];
       }
       $contributors = explode(',', $contributors);
+      // $contributors = array_map('intval', $contributors);
       return $contributors;
    }
 
@@ -405,14 +391,23 @@ class listener implements EventSubscriberInterface
          return;
       }
       $post_id = (int) $event['post_id'];
+      $forum_id = (int) $event['forum_id'];
+      // $topic_first_post_id = (int) $event['post_data']['topic_first_post_id'];
+      // Check if 'topic_first_post_id' key exists in the $event['post_data'] array
+      $topic_first_post_id = isset($event['post_data']['topic_first_post_id']) ? (int) $event['post_data']['topic_first_post_id'] : 0;
+
 
+      if ($post_id) {
          $sql = 'SELECT contributors_enabled FROM ' . FORUMS_TABLE . ' WHERE forum_id = (
          SELECT forum_id FROM ' . POSTS_TABLE . ' WHERE post_id = ' . $post_id . ')';
-      $result = $this->db->sql_query($sql);
-      $contributors_enabled  = $this->db->sql_fetchfield('contributors_enabled', $result);
-      $this->db->sql_freeresult($result);
+      } else {
+         $sql = 'SELECT contributors_enabled FROM ' . FORUMS_TABLE . ' WHERE forum_id = ' . $forum_id;
+      }
+      $this->db->sql_query($sql);
+      $contributors_enabled  = $this->db->sql_fetchfield('contributors_enabled');
+
       $this->template->assign_vars(array(
-         'S_ENABLE_CONTRIBUTORS' => $contributors_enabled ? true : false,
+         'S_ENABLE_CONTRIBUTORS' => $contributors_enabled ? ($topic_first_post_id == $post_id || $event['mode'] == 'post') : false,
       ));
 
       if (!$contributors_enabled) {
@@ -424,9 +419,8 @@ class listener implements EventSubscriberInterface
       foreach ($contributors as $u) {
          $user_id = (int) $u;
          $sql = 'SELECT username FROM ' . USERS_TABLE . ' WHERE user_id = ' . $user_id . ' LIMIT 1';
-         $result = $this->db->sql_query($sql);
-         $username = $this->db->sql_fetchfield('username', $result);
-         $this->db->sql_freeresult($result);
+         $this->db->sql_query($sql);
+         $username = $this->db->sql_fetchfield('username');
          $a[] = $username;
       }
       $this->template->assign_vars(array(
@@ -437,19 +431,15 @@ class listener implements EventSubscriberInterface
    public function get_topic_id($post_id)
    {
       $sql = 'SELECT topic_id FROM ' . POSTS_TABLE . ' WHERE post_id = ' . $post_id . ' LIMIT 1';
-      $result = $this->db->sql_query($sql);
-      $topic_id = (int) $this->db->sql_fetchfield('topic_id', $result);
-      $this->db->sql_freeresult($result);
-      return $topic_id;
+      $this->db->sql_query($sql);
+      return (int) $this->db->sql_fetchfield('topic_id');
    }
 
    public function is_unlike($post_id, $user_id)
    {
       $sql = 'SELECT COUNT(*) AS count FROM ' . $this->bblikes_table . ' WHERE post_id = ' . $post_id . ' AND user_id = ' . $user_id;
-      $result = $this->db->sql_query($sql);
-      $count = (int) $this->db->sql_fetchfield('count', $result);
-      $this->db->sql_freeresult($result);
-
+      $this->db->sql_query($sql);
+      $count = (int) $this->db->sql_fetchfield('count');
       // As we're running this on 'core.submit_likedd_end' event, the existence of a like
       // means it was a new like and non-existence means the like was removed.
       return ($count === 0);
diff --git "[ORIGINAL]/leinad4mind\\likepoints/language/en/common.php" "[FORUM_EXT]/leinad4mind\\likepoints/language/en/common.php"
--- "[ORIGINAL]/leinad4mind\\likepoints/language/en/common.php"
+++ "[FORUM_EXT]/leinad4mind\\likepoints/language/en/common.php"
@@ -4,7 +4,7 @@
  *
  * LikePoints extension for the phpBB Forum Software package.
  *
- * @copyright (c) 2022-2025 Leinad4Mind All rights reserved
+ * @copyright (c) 2022 Leinad4Mind All rights reserved
  * @license Proprietary
  *
  */
diff --git "[ORIGINAL]/leinad4mind\\likepoints/language/en/info_acp_likepoints.php" "[FORUM_EXT]/leinad4mind\\likepoints/language/en/info_acp_likepoints.php"
--- "[ORIGINAL]/leinad4mind\\likepoints/language/en/info_acp_likepoints.php"
+++ "[FORUM_EXT]/leinad4mind\\likepoints/language/en/info_acp_likepoints.php"
@@ -4,7 +4,7 @@
  *
  * LikePoints extension for the phpBB Forum Software package.
  *
- * @copyright (c) 2022-2025 Leinad4Mind All rights reserved
+ * @copyright (c) 2022 Leinad4Mind All rights reserved
  * @license Proprietary
  *
  */
@@ -23,7 +23,11 @@ if (!isset($lang) || !is_array($lang)) {
 $lang = array_merge($lang, [
    'PER_LIKES_ENABLE' => 'Enable transfer of BBPoints for likes',
    'PER_LIKES_AMOUNT' => 'Amount of BBPoints transferred on liking the post',
+   'ACP_POINTS_PER_LIKES' => 'Points per likes',
+   'ACP_POINTS_PER_LIKES_EXPLAIN' => 'Set the default amount of points transferred on liking posts. Set to 0 to switch off.',
    'CONTRIBUTORS_ENABLE' => 'Enable contributors',
    'SYNC_LIKE_POINTS' => 'Sync like points',
    'SYNC_LIKE_POINTS_EXPLAIN' => 'Calculates all the points for likes set above for all the users.<br>It can take several minutes and it depends on how many users, posts and likes your board hosts.<br>Do NOT interrput the process once started.',
+   'SYNC_LIKE_POINTS_PROCESSING' => 'Processing...',
+   'SYNC_LIKE_POINTS_TOTAL_POSTS' => 'Total posts',
 ]);
diff --git "[FORUM_EXT]/leinad4mind\\likepoints/language/pt/common.php" "[FORUM_EXT]/leinad4mind\\likepoints/language/pt/common.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/leinad4mind\\likepoints/language/pt/common.php"
@@ -0,0 +1,37 @@
+<?php
+
+/**
+ *
+ * LikePoints extension for the phpBB Forum Software package.
+ *
+ * @copyright (c) 2022 Leinad4Mind All rights reserved
+ * @license Proprietary
+ *
+ */
+
+/**
+ * DO NOT CHANGE
+ */
+if (!defined('IN_PHPBB')) {
+   exit;
+}
+
+if (!isset($lang) || !is_array($lang)) {
+   $lang = [];
+}
+
+$lang = array_merge($lang, [
+   'CONTRIBUTOR_LABEL' => 'Colaboradores',
+   'LOG_TRANSFER_POINTS' => 'Transferring %d BBPoints to user %d',
+   'LOG_TRANSFER_POINTS_NOT_ENOUGH' => 'Tried to transfer %d BBPoints to user %d, but did not have enough on balance',
+   'LOG_UNLIKE_TRANSFER_POINTS_NOT_ENOUGH' => 'Tried to transfer %d BBPoints back from user %d to user %d after a unlike, but they did not have enough on balance',
+   'LOG_LIKE_TRANSFER_ABORTED' => 'Like action taken back. %d BBPoints returned to user %d from user %d',
+   'REASON_LIKE' => 'LIKE: Awarded %d points for getting a like from %d.',
+   'REASON_UNLIKE' => 'UNLIKE: Taken %d points for getting a unlike from %d.',
+   'REASON_LIKE_CONTRIBUTOR' => 'CONTRIBUTOR LIKE: Awarded %d points for getting a like from %d as contributors from the poster.',
+   'REASON_UNLIKE_CONTRIBUTOR' => 'CONTRIBUTOR UNLIKE: Taken %d points for removing a like from %d as contributors from the poster.',
+   'ENTER_TAGS_PLACEHOLDER' => 'Introduza nomes de utilizadores',
+   'CONTRIBUTED' => 'contribuiu',
+   'CONTRIBUTEDS' => 'contribuíram',
+   'NOT_ENOUGH_BALANCE_LIKE' => 'Não tens pontos suficientes para agradecer :(<br>Participa e ajuda a comunidade de forma a obteres mais pontos!',
+]);
diff --git "[FORUM_EXT]/leinad4mind\\likepoints/language/pt/info_acp_likepoints.php" "[FORUM_EXT]/leinad4mind\\likepoints/language/pt/info_acp_likepoints.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/leinad4mind\\likepoints/language/pt/info_acp_likepoints.php"
@@ -0,0 +1,33 @@
+<?php
+
+/**
+ *
+ * LikePoints extension for the phpBB Forum Software package.
+ *
+ * @copyright (c) 2022 Leinad4Mind All rights reserved
+ * @license Proprietary
+ *
+ */
+
+/**
+ * DO NOT CHANGE
+ */
+if (!defined('IN_PHPBB')) {
+   exit;
+}
+
+if (!isset($lang) || !is_array($lang)) {
+   $lang = [];
+}
+
+$lang = array_merge($lang, [
+   'PER_LIKES_ENABLE' => 'Enable transfer of BBPoints for likes',
+   'PER_LIKES_AMOUNT' => 'Amount of BBPoints transferred on liking the post',
+   'ACP_POINTS_PER_LIKES' => 'Points per likes',
+   'ACP_POINTS_PER_LIKES_EXPLAIN' => 'Set the default amount of points transferred on liking posts. Set to 0 to switch off.',
+   'CONTRIBUTORS_ENABLE' => 'Enable contributors',
+   'SYNC_LIKE_POINTS' => 'Sync like points',
+   'SYNC_LIKE_POINTS_EXPLAIN' => 'Calculates all the points for likes set above for all the users.<br>It can take several minutes and it depends on how many users, posts and likes your board hosts.<br>Do NOT interrput the process once started.',
+   'SYNC_LIKE_POINTS_PROCESSING' => 'Processing...',
+   'SYNC_LIKE_POINTS_TOTAL_POSTS' => 'Total posts',
+]);
diff --git "[FORUM_EXT]/leinad4mind\\likepoints/language/pt-preao/common.php" "[FORUM_EXT]/leinad4mind\\likepoints/language/pt-preao/common.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/leinad4mind\\likepoints/language/pt-preao/common.php"
@@ -0,0 +1,37 @@
+<?php
+
+/**
+ *
+ * LikePoints extension for the phpBB Forum Software package.
+ *
+ * @copyright (c) 2022 Leinad4Mind All rights reserved
+ * @license Proprietary
+ *
+ */
+
+/**
+ * DO NOT CHANGE
+ */
+if (!defined('IN_PHPBB')) {
+   exit;
+}
+
+if (!isset($lang) || !is_array($lang)) {
+   $lang = [];
+}
+
+$lang = array_merge($lang, [
+   'CONTRIBUTOR_LABEL' => 'Colaboradores',
+   'LOG_TRANSFER_POINTS' => 'Transferring %d BBPoints to user %d',
+   'LOG_TRANSFER_POINTS_NOT_ENOUGH' => 'Tried to transfer %d BBPoints to user %d, but did not have enough on balance',
+   'LOG_UNLIKE_TRANSFER_POINTS_NOT_ENOUGH' => 'Tried to transfer %d BBPoints back from user %d to user %d after a unlike, but they did not have enough on balance',
+   'LOG_LIKE_TRANSFER_ABORTED' => 'Like action taken back. %d BBPoints returned to user %d from user %d',
+   'REASON_LIKE' => 'LIKE: Awarded %d points for getting a like from %d.',
+   'REASON_UNLIKE' => 'UNLIKE: Taken %d points for getting a unlike from %d.',
+   'REASON_LIKE_CONTRIBUTOR' => 'CONTRIBUTOR LIKE: Awarded %d points for getting a like from %d as contributors from the poster.',
+   'REASON_UNLIKE_CONTRIBUTOR' => 'CONTRIBUTOR UNLIKE: Taken %d points for removing a like from %d as contributors from the poster.',
+   'ENTER_TAGS_PLACEHOLDER' => 'Introduza nomes de utilizadores',
+   'CONTRIBUTED' => 'contribuiu',
+   'CONTRIBUTEDS' => 'contribuíram',
+   'NOT_ENOUGH_BALANCE_LIKE' => 'Não tens pontos suficientes para agradecer :(<br>Participa e ajuda a comunidade de forma a obteres mais pontos!',
+]);
diff --git "[FORUM_EXT]/leinad4mind\\likepoints/language/pt-preao/info_acp_likepoints.php" "[FORUM_EXT]/leinad4mind\\likepoints/language/pt-preao/info_acp_likepoints.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/leinad4mind\\likepoints/language/pt-preao/info_acp_likepoints.php"
@@ -0,0 +1,33 @@
+<?php
+
+/**
+ *
+ * LikePoints extension for the phpBB Forum Software package.
+ *
+ * @copyright (c) 2022 Leinad4Mind All rights reserved
+ * @license Proprietary
+ *
+ */
+
+/**
+ * DO NOT CHANGE
+ */
+if (!defined('IN_PHPBB')) {
+   exit;
+}
+
+if (!isset($lang) || !is_array($lang)) {
+   $lang = [];
+}
+
+$lang = array_merge($lang, [
+   'PER_LIKES_ENABLE' => 'Enable transfer of BBPoints for likes',
+   'PER_LIKES_AMOUNT' => 'Amount of BBPoints transferred on liking the post',
+   'ACP_POINTS_PER_LIKES' => 'Points per likes',
+   'ACP_POINTS_PER_LIKES_EXPLAIN' => 'Set the default amount of points transferred on liking posts. Set to 0 to switch off.',
+   'CONTRIBUTORS_ENABLE' => 'Enable contributors',
+   'SYNC_LIKE_POINTS' => 'Sync like points',
+   'SYNC_LIKE_POINTS_EXPLAIN' => 'Calculates all the points for likes set above for all the users.<br>It can take several minutes and it depends on how many users, posts and likes your board hosts.<br>Do NOT interrput the process once started.',
+   'SYNC_LIKE_POINTS_PROCESSING' => 'Processing...',
+   'SYNC_LIKE_POINTS_TOTAL_POSTS' => 'Total posts',
+]);
diff --git "[ORIGINAL]/leinad4mind\\likepoints/migrations/m1_initial_install.php" "[FORUM_EXT]/leinad4mind\\likepoints/migrations/m1_initial_install.php"
--- "[ORIGINAL]/leinad4mind\\likepoints/migrations/m1_initial_install.php"
+++ "[FORUM_EXT]/leinad4mind\\likepoints/migrations/m1_initial_install.php"
@@ -4,7 +4,7 @@
  *
  * LikePoints extension for the phpBB Forum Software package.
  *
- * @copyright (c) 2022-2025 Leinad4Mind All rights reserved
+ * @copyright (c) 2022 Leinad4Mind All rights reserved
  * @license Proprietary
  *
  */
@@ -16,9 +16,6 @@ namespace leinad4mind\likepoints\migrations;
  */
 class m1_initial_install extends \phpbb\db\migration\migration
 {
-    /**
-     * Schema changes to apply when installing the extension.
-     */
    public function update_schema()
    {
       return array(
@@ -32,31 +29,9 @@ class m1_initial_install extends \phpbb\db\migration\migration
                'contributors'   => array('VCHAR:255', ''),
             ),
             $this->table_prefix . 'bbpoints'      => array(
-                    'post_id' => array('INT:11', 0),
-                ),
-            ),
-        );
-    }
-
-    /**
-     * Schema changes to revert when uninstalling the extension.
-     */
-    public function revert_schema()
-    {
-        return array(
-            'drop_columns' => array(
-                $this->table_prefix . 'forums' => array(
-                    'per_likes_enabled',
-                    'contributors_enabled',
-                    'per_likes_amount',
-                ),
-                $this->table_prefix . 'posts' => array(
-                    'contributors',
-                ),
-                $this->table_prefix . 'bbpoints' => array(
-                    'post_id',
-                ),
+               'post_id'   => array('INT:11', '0'),
             ),
+         )
       );
    }
 }
\ No newline at end of file
diff --git "[ORIGINAL]/leinad4mind\\likepoints/migrations/m2_add_bbpoints_index.php" "[ORIGINAL]/leinad4mind\\likepoints/migrations/m2_add_bbpoints_index.php"
deleted file mode 100644
--- "[ORIGINAL]/leinad4mind\\likepoints/migrations/m2_add_bbpoints_index.php"
+++ /dev/null
@@ -1,49 +0,0 @@
-<?php
-
-/**
- *
- * LikePoints extension for the phpBB Forum Software package.
- *
- * @copyright (c) 2022-2025 Leinad4Mind All rights reserved
- * @license Proprietary
- *
- */
-
-namespace leinad4mind\likepoints\migrations;
-
-class m2_add_bbpoints_index extends \phpbb\db\migration\migration
-{
-    public static function depends_on()
-    {
-        return array('\leinad4mind\likepoints\migrations\m1_initial_install');
-    }
-
-    public function update_schema()
-    {
-        return array(
-            'add_indexes' => array(
-                $this->table_prefix . 'bbpoints' => array(
-                    'post_id_idx' => array('post_id'),
-                ),
-                $this->table_prefix . 'posts' => array(
-                    'contributors_index' => array('contributors'),
-                ),
-                $this->table_prefix . 'forums' => array(
-                    'per_likes_enabled_index' => array('per_likes_enabled'),
-                    'contributors_enabled_index' => array('contributors_enabled'),
-                ),
-            ),
-        );
-    }
-
-    public function revert_schema()
-    {
-        return array(
-            'drop_indexes' => array(
-                $this->table_prefix . 'bbpoints' => array('post_id_idx'),
-                $this->table_prefix . 'posts' => array('contributors_index'),
-                $this->table_prefix . 'forums' => array('per_likes_enabled_index', 'contributors_enabled_index'),
-            ),
-        );
-    }
-}
diff --git "[ORIGINAL]/leinad4mind\\likepoints/styles/all/template/event/posting_editor_subject_after.html" "[FORUM_EXT]/leinad4mind\\likepoints/styles/all/template/event/ss_posting_editor_subject_after.html"
similarity index 55%
rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\likepoints/styles/all/template/event/posting_editor_subject_after.html"
rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\likepoints/styles/all/template/event/ss_posting_editor_subject_after.html"
--- "[ORIGINAL]/leinad4mind\\likepoints/styles/all/template/event/posting_editor_subject_after.html"
+++ "[FORUM_EXT]/leinad4mind\\likepoints/styles/all/template/event/ss_posting_editor_subject_after.html"
@@ -5,25 +5,24 @@
     var lptagsLangPlaceholder = '{{ lang('ENTER_TAGS_PLACEHOLDER') }}';
   </script>
 
-  <!-- IF not $INCLUDED_LPTAGS_TEXTCOMPLETEJS -->
-  <!-- IF not BBTAGS_SHOW_FIELD-->
+  {% if not INCLUDED_LPTAGS_TEXTCOMPLETEJS %}
+	{% if not BBTAGS_SHOW_FIELD %}
 		{% INCLUDEJS '@leinad4mind_likepoints/js/jquery.tag-editor.min.js' %}
 		{% INCLUDEJS '@leinad4mind_likepoints/js/jquery.caret.min.js' %}
 		{% INCLUDEJS '@leinad4mind_likepoints/js/jquery-ui.min.js' %}
-  <!-- INCLUDECSS @leinad4mind_likepoints/jquery.tag-editor.min.css -->
-  <!-- ENDIF -->
+		{% INCLUDECSS '@leinad4mind_likepoints/jquery.tag-editor.min.css' %}
+	{% endif %}
 	{% INCLUDEJS '@leinad4mind_likepoints/js/lptags.min.js' %}
 
-  <!-- DEFINE $INCLUDED_LPTAGS_TEXTCOMPLETEJS = true -->
-  <!-- ENDIF -->
+	{% DEFINE INCLUDED_LPTAGS_TEXTCOMPLETEJS = true %}
+  {% endif %}
 
   <div class="control-group contributors-box">
-    <label class="control-label" for="contributors">{{ lang('CONTRIBUTOR_LABEL') ~ lang('COLON') }}</label>
+    <label class="control-label" for="contributors">{{ lang('CONTRIBUTOR_LABEL') }}{{ lang('COLON') }}</label>
     <div class="row">
       <div class="col-xs-12 col-lg-8">
         <input type="text" class="form-control input-sm" autocomplete="off" name="contributors" id="contributors" maxlength="255" value="{{ CONTRIBUTOR }}" placeholder="{{ lang('ENTER_TAGS_PLACEHOLDER') }}">
       </div>
     </div>
-
   </div>
 {% endif %}
```
