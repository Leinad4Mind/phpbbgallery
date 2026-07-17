Existem diferencas reais no codigo ou texto. Diferencas de formatacao (espacos, tabs) foram ignoradas abaixo.

```diff
diff --git "[FORUM_EXT]/sitesplat\\bboauth/diff_full.tmp" "[FORUM_EXT]/sitesplat\\bboauth/diff_full.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\bboauth/diff_full.tmp"
@@ -0,0 +1,16 @@
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bboauth/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bboauth/diff_full.tmp"
+new file mode 100644
+index 000000000..e69de29bb
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bboauth/event/oauth_reg_listener.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bboauth/event/oauth_reg_listener.php"
+index 8be4152c0..db3353210 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bboauth/event/oauth_reg_listener.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bboauth/event/oauth_reg_listener.php"
+@@ -110,7 +110,7 @@ class oauth_reg_listener implements EventSubscriberInterface
+ 				WHERE session_id = '" . $this->user->data['session_id'] . "'
+ 					AND provider = 'auth.provider.oauth.service." . $this->db->sql_escape($this->login_link_data['oauth_service']) . "'";
+ 		$result = $this->db->sql_query($sql);
+-		$oauth_token = $this->db->sql_fetchfield('oauth_token', $result);
++		$oauth_token = $this->db->sql_fetchfield('oauth_token', false, $result);
+ 		$this->db->sql_freeresult($result);
+ 
+ 		if ($oauth_token)
diff --git "[FORUM_EXT]/sitesplat\\bboauth/diff_nospace.tmp" "[FORUM_EXT]/sitesplat\\bboauth/diff_nospace.tmp"
new file mode 100644
diff --git "[ORIGINAL]/sitesplat\\bboauth/event/oauth_reg_listener.php" "[FORUM_EXT]/sitesplat\\bboauth/event/oauth_reg_listener.php"
--- "[ORIGINAL]/sitesplat\\bboauth/event/oauth_reg_listener.php"
+++ "[FORUM_EXT]/sitesplat\\bboauth/event/oauth_reg_listener.php"
@@ -110,7 +110,7 @@ class oauth_reg_listener implements EventSubscriberInterface
 				WHERE session_id = '" . $this->user->data['session_id'] . "'
 					AND provider = 'auth.provider.oauth.service." . $this->db->sql_escape($this->login_link_data['oauth_service']) . "'";
 		$result = $this->db->sql_query($sql);
-		$oauth_token = $this->db->sql_fetchfield('oauth_token', $result);
+		$oauth_token = $this->db->sql_fetchfield('oauth_token', false, $result);
 		$this->db->sql_freeresult($result);
 
 		if ($oauth_token)
```
