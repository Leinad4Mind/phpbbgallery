Existem diferencas reais no codigo ou texto. Diferencas de formatacao (espacos, tabs) foram ignoradas abaixo.

```diff
diff --git "[ORIGINAL]/sitesplat\\accountswitch/controller/controller.php" "[FORUM_EXT]/sitesplat\\accountswitch/controller/controller.php"
--- "[ORIGINAL]/sitesplat\\accountswitch/controller/controller.php"
+++ "[FORUM_EXT]/sitesplat\\accountswitch/controller/controller.php"
@@ -39,8 +39,6 @@ class controller
 	* @access public
 	*/
 	public function usr_switch($route)
-	{
-		if ($this->config['allow_emailreuse'])
 	{
 			$route = preg_replace('/\\.[^.\\s]{3,4}$/', '', $route);
 			$emtype = empty($this->user->data['user_email_hash']) ? 'user_email' : 'user_email_hash';
@@ -86,4 +84,3 @@ class controller
 			}
 	}
 }
-}
diff --git "[FORUM_EXT]/sitesplat\\accountswitch/diff_full.tmp" "[FORUM_EXT]/sitesplat\\accountswitch/diff_full.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\accountswitch/diff_full.tmp"
@@ -0,0 +1,48 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\accountswitch/controller/controller.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\accountswitch/controller/controller.php"
+index 0ce5f3291..4897f3d18 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\accountswitch/controller/controller.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\accountswitch/controller/controller.php"
+@@ -40,8 +40,6 @@ class controller
+ 	*/
+ 	public function usr_switch($route)
+ 	{
+-		if ($this->config['allow_emailreuse'])
+-		{
+ 			$route = preg_replace('/\\.[^.\\s]{3,4}$/', '', $route);
+ 			$emtype = empty($this->user->data['user_email_hash']) ? 'user_email' : 'user_email_hash';
+ 
+@@ -84,6 +82,5 @@ class controller
+ 					));
+ 				}
+ 			}
+-		}
+ 	}
+ }
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\accountswitch/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\accountswitch/diff_full.tmp"
+new file mode 100644
+index 000000000..e69de29bb
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\accountswitch/event/listener.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\accountswitch/event/listener.php"
+index 5a5cc53b5..f9cd45a0f 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\accountswitch/event/listener.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\accountswitch/event/listener.php"
+@@ -56,8 +56,6 @@ class listener implements EventSubscriberInterface
+ 	
+ 	public function user_setup($event)
+ 	{
+-		if ($this->config['allow_emailreuse'])
+-		{
+ 			$email_eq = empty($this->user->data['user_email_hash']) ? "user_email = '{$this->user->data['user_email']}'" : "user_email_hash = {$this->user->data['user_email_hash']}";
+ 
+ 			$sql = 'SELECT user_id, username, user_avatar, user_avatar_type, user_avatar_width, user_avatar_height FROM ' . USERS_TABLE . " 
+@@ -81,7 +79,6 @@ class listener implements EventSubscriberInterface
+ 										  '<img class="online_img" src="' . $this->board_url . 'styles/prosilver/theme/images/no_avatar.gif" alt="' .  $row['username'] . '">')
+ 				));
+ 			}
+-		}
+ 	}
+ 
+ 	public function load_profile($event)
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\accountswitch/styles/FLATBOOTS/template/event/viewtopic_body_postrow_custom_fields_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\accountswitch/styles/FLATBOOTS/template/event/viewtopic_body_postrow_custom_fields_after.bak"
+similarity index 100%
+rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\accountswitch/styles/FLATBOOTS/template/event/viewtopic_body_postrow_custom_fields_after.html"
+rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\accountswitch/styles/FLATBOOTS/template/event/viewtopic_body_postrow_custom_fields_after.bak"
diff --git "[FORUM_EXT]/sitesplat\\accountswitch/diff_nospace.tmp" "[FORUM_EXT]/sitesplat\\accountswitch/diff_nospace.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\accountswitch/diff_nospace.tmp"
@@ -0,0 +1,69 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\accountswitch/controller/controller.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\accountswitch/controller/controller.php"
+index 0ce5f3291..4897f3d18 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\accountswitch/controller/controller.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\accountswitch/controller/controller.php"
+@@ -39,8 +39,6 @@ class controller
+ 	* @access public
+ 	*/
+ 	public function usr_switch($route)
+-	{
+-		if ($this->config['allow_emailreuse'])
+ 	{
+ 			$route = preg_replace('/\\.[^.\\s]{3,4}$/', '', $route);
+ 			$emtype = empty($this->user->data['user_email_hash']) ? 'user_email' : 'user_email_hash';
+@@ -86,4 +84,3 @@ class controller
+ 			}
+ 	}
+ }
+-}
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\accountswitch/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\accountswitch/diff_full.tmp"
+new file mode 100644
+index 000000000..ad3669d00
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\accountswitch/diff_full.tmp"
+@@ -0,0 +1,48 @@
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\accountswitch/controller/controller.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\accountswitch/controller/controller.php"
++index 0ce5f3291..4897f3d18 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\accountswitch/controller/controller.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\accountswitch/controller/controller.php"
++@@ -40,8 +40,6 @@ class controller
++ 	*/
++ 	public function usr_switch($route)
++ 	{
++-		if ($this->config['allow_emailreuse'])
++-		{
++ 			$route = preg_replace('/\\.[^.\\s]{3,4}$/', '', $route);
++ 			$emtype = empty($this->user->data['user_email_hash']) ? 'user_email' : 'user_email_hash';
++ 
++@@ -84,6 +82,5 @@ class controller
++ 					));
++ 				}
++ 			}
++-		}
++ 	}
++ }
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\accountswitch/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\accountswitch/diff_full.tmp"
++new file mode 100644
++index 000000000..e69de29bb
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\accountswitch/event/listener.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\accountswitch/event/listener.php"
++index 5a5cc53b5..f9cd45a0f 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\accountswitch/event/listener.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\accountswitch/event/listener.php"
++@@ -56,8 +56,6 @@ class listener implements EventSubscriberInterface
++ 	
++ 	public function user_setup($event)
++ 	{
++-		if ($this->config['allow_emailreuse'])
++-		{
++ 			$email_eq = empty($this->user->data['user_email_hash']) ? "user_email = '{$this->user->data['user_email']}'" : "user_email_hash = {$this->user->data['user_email_hash']}";
++ 
++ 			$sql = 'SELECT user_id, username, user_avatar, user_avatar_type, user_avatar_width, user_avatar_height FROM ' . USERS_TABLE . " 
++@@ -81,7 +79,6 @@ class listener implements EventSubscriberInterface
++ 										  '<img class="online_img" src="' . $this->board_url . 'styles/prosilver/theme/images/no_avatar.gif" alt="' .  $row['username'] . '">')
++ 				));
++ 			}
++-		}
++ 	}
++ 
++ 	public function load_profile($event)
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\accountswitch/styles/FLATBOOTS/template/event/viewtopic_body_postrow_custom_fields_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\accountswitch/styles/FL
\ No newline at end of file
diff --git "[ORIGINAL]/sitesplat\\accountswitch/event/listener.php" "[FORUM_EXT]/sitesplat\\accountswitch/event/listener.php"
--- "[ORIGINAL]/sitesplat\\accountswitch/event/listener.php"
+++ "[FORUM_EXT]/sitesplat\\accountswitch/event/listener.php"
@@ -55,8 +55,6 @@ class listener implements EventSubscriberInterface
 	}
 	
 	public function user_setup($event)
-	{
-		if ($this->config['allow_emailreuse'])
 	{
 			$email_eq = empty($this->user->data['user_email_hash']) ? "user_email = '{$this->user->data['user_email']}'" : "user_email_hash = {$this->user->data['user_email_hash']}";
 
@@ -82,7 +80,6 @@ class listener implements EventSubscriberInterface
 				));
 			}
 	}
-	}
 
 	public function load_profile($event)
 	{
diff --git "[ORIGINAL]/sitesplat\\accountswitch/styles/FLATBOOTS/template/event/viewtopic_body_postrow_custom_fields_after.html" "[FORUM_EXT]/sitesplat\\accountswitch/styles/FLATBOOTS/template/event/viewtopic_body_postrow_custom_fields_after.bak"
similarity index 100%
rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\accountswitch/styles/FLATBOOTS/template/event/viewtopic_body_postrow_custom_fields_after.html"
rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\accountswitch/styles/FLATBOOTS/template/event/viewtopic_body_postrow_custom_fields_after.bak"
```
