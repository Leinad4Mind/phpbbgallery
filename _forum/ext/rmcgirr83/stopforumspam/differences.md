Existem diferencas reais no codigo ou texto. Diferencas de formatacao (espacos, tabs) foram ignoradas abaixo.

```diff
diff --git "[ORIGINAL]/rmcgirr83\\stopforumspam/composer.json" "[FORUM_EXT]/rmcgirr83\\stopforumspam/composer.json"
--- "[ORIGINAL]/rmcgirr83\\stopforumspam/composer.json"
+++ "[FORUM_EXT]/rmcgirr83\\stopforumspam/composer.json"
@@ -3,8 +3,8 @@
     "type": "phpbb-extension",
     "description": "Queries the stop forum spam database on registration and posting.  Extension settings are found under the extension tab of the forum. This extension requires at least phpBB version 3.3.",
     "homepage": "https://github.com/rmcgirr83/stopforumspam",
-    "version": "1.4.8",
-    "time": "2025-04-27",
+    "version": "1.4.6",
+    "time": "2024-02-16",
     "license": "GPL-2.0-only",
     "authors": [
         {
diff --git "[ORIGINAL]/rmcgirr83\\stopforumspam/controller/admin_controller.php" "[FORUM_EXT]/rmcgirr83\\stopforumspam/controller/admin_controller.php"
--- "[ORIGINAL]/rmcgirr83\\stopforumspam/controller/admin_controller.php"
+++ "[FORUM_EXT]/rmcgirr83\\stopforumspam/controller/admin_controller.php"
@@ -367,6 +367,7 @@ class admin_controller implements admin_interface
 
 		$json_response = new json_response;
 		$json_response->send($data);
+
 	}
 
 	/**
diff --git "[ORIGINAL]/rmcgirr83\\stopforumspam/core/reporttosfs.php" "[FORUM_EXT]/rmcgirr83\\stopforumspam/core/reporttosfs.php"
--- "[ORIGINAL]/rmcgirr83\\stopforumspam/core/reporttosfs.php"
+++ "[FORUM_EXT]/rmcgirr83\\stopforumspam/core/reporttosfs.php"
@@ -129,7 +129,7 @@ class reporttosfs
 			throw new http_exception(403, 'POST_NOT_EXIST');
 		}
 
-		$sql = 'SELECT p.*, u.username, u.user_email
+		$sql = 'SELECT p.sfs_reported, p.poster_ip, p.topic_id, p.forum_id, u.username, u.user_email
 			FROM ' . POSTS_TABLE . ' p
 			LEFT JOIN ' . USERS_TABLE . ' u on p.poster_id = u.user_id
 			WHERE p.post_id = ' . (int) $postid . ' AND p.poster_id = ' . (int) $posterid;
@@ -143,18 +143,11 @@ class reporttosfs
 			throw new http_exception(403, 'INFO_NOT_FOUND');
 		}
 
-		if (!function_exists('generate_text_for_display'))
-		{
-			include($this->root_path . 'includes/functions_privmsgs.' . $this->php_ext);
-		}
 		$username = $row['username'];
 		$userip = $row['poster_ip'];
 		$useremail = $row['user_email'];
 		$forumid = (int) $row['forum_id'];
 		$topicid = (int) $row['topic_id'];
-		$parse_flags = ($row['bbcode_bitfield'] ? OPTION_FLAG_BBCODE : 0);
-		$parse_flags |= ($row['enable_smilies'] ? OPTION_FLAG_SMILIES : 0);
-		$evidence = generate_text_for_display($row['post_text'], $row['bbcode_uid'], $row['bbcode_bitfield'], $parse_flags, true);
 		$sfs_reported = (int) $row['sfs_reported'];
 
 		$admins_mods = $this->sfsgroups->getadminsmods($forumid);
@@ -190,7 +183,7 @@ class reporttosfs
 
 		if (confirm_box(true))
 		{
-			$response = $this->sfsapi->sfsapi('add', $username, $userip, $useremail, $evidence, $this->config['sfs_api_key']);
+			$response = $this->sfsapi->sfsapi('add', $username, $userip, $useremail, $this->config['sfs_api_key']);
 
 			$json_decode = json_decode($response, true);
 			// ajax stuffs
diff --git "[ORIGINAL]/rmcgirr83\\stopforumspam/core/sfsapi.php" "[FORUM_EXT]/rmcgirr83\\stopforumspam/core/sfsapi.php"
--- "[ORIGINAL]/rmcgirr83\\stopforumspam/core/sfsapi.php"
+++ "[FORUM_EXT]/rmcgirr83\\stopforumspam/core/sfsapi.php"
@@ -63,7 +63,7 @@ class sfsapi
 	* @param	$apikey			the api key of the forum
 	* @return 	bool|string		return true on success or false on failure or string on curl error
 	*/
-	public function sfsapi($type, $username, $userip, $useremail, $evidence = '', $apikey = '')
+	public function sfsapi($type, $username, $userip, $useremail, $apikey = '')
 	{
 		// We'll use curl..most servers have it installed as default
 		if (!function_exists('curl_init'))
@@ -83,7 +83,6 @@ class sfsapi
 				'username' => $username,
 				'ip' => $userip,
 				'email' => $useremail,
-				'evidence' => $evidence,
 				'api_key' => $apikey
 			];
 
@@ -129,7 +128,6 @@ class sfsapi
 		{
 			return json_encode($error_message);
 		}
-
 		// if nothing is returned (SFS is down)
 		if ($httpcode != 200)
 		{
diff --git "[FORUM_EXT]/rmcgirr83\\stopforumspam/diff_full.tmp" "[FORUM_EXT]/rmcgirr83\\stopforumspam/diff_full.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/rmcgirr83\\stopforumspam/diff_full.tmp"
@@ -0,0 +1,558 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\stopforumspam/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\stopforumspam/composer.json"
+index bb4a255b0..8356eb025 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\stopforumspam/composer.json"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\stopforumspam/composer.json"
+@@ -3,8 +3,8 @@
+     "type": "phpbb-extension",
+     "description": "Queries the stop forum spam database on registration and posting.  Extension settings are found under the extension tab of the forum. This extension requires at least phpBB version 3.3.",
+     "homepage": "https://github.com/rmcgirr83/stopforumspam",
+-    "version": "1.4.8",
+-    "time": "2025-04-27",
++    "version": "1.4.6",
++    "time": "2024-02-16",
+     "license": "GPL-2.0-only",
+     "authors": [
+         {
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\stopforumspam/controller/admin_controller.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\stopforumspam/controller/admin_controller.php"
+index 420f3ae0f..ca1b28706 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\stopforumspam/controller/admin_controller.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\stopforumspam/controller/admin_controller.php"
+@@ -367,6 +367,7 @@ class admin_controller implements admin_interface
+ 
+ 		$json_response = new json_response;
+ 		$json_response->send($data);
++
+ 	}
+ 
+ 	/**
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\stopforumspam/core/reporttosfs.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\stopforumspam/core/reporttosfs.php"
+index ad31c1613..11ae558ea 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\stopforumspam/core/reporttosfs.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\stopforumspam/core/reporttosfs.php"
+@@ -129,7 +129,7 @@ class reporttosfs
+ 			throw new http_exception(403, 'POST_NOT_EXIST');
+ 		}
+ 
+-		$sql = 'SELECT p.*, u.username, u.user_email
++		$sql = 'SELECT p.sfs_reported, p.poster_ip, p.topic_id, p.forum_id, u.username, u.user_email
+ 			FROM ' . POSTS_TABLE . ' p
+ 			LEFT JOIN ' . USERS_TABLE . ' u on p.poster_id = u.user_id
+ 			WHERE p.post_id = ' . (int) $postid . ' AND p.poster_id = ' . (int) $posterid;
+@@ -143,18 +143,11 @@ class reporttosfs
+ 			throw new http_exception(403, 'INFO_NOT_FOUND');
+ 		}
+ 
+-		if (!function_exists('generate_text_for_display'))
+-		{
+-			include($this->root_path . 'includes/functions_privmsgs.' . $this->php_ext);
+-		}
+ 		$username = $row['username'];
+ 		$userip = $row['poster_ip'];
+ 		$useremail = $row['user_email'];
+ 		$forumid = (int) $row['forum_id'];
+ 		$topicid = (int) $row['topic_id'];
+-		$parse_flags = ($row['bbcode_bitfield'] ? OPTION_FLAG_BBCODE : 0);
+-		$parse_flags |= ($row['enable_smilies'] ? OPTION_FLAG_SMILIES : 0);
+-		$evidence = generate_text_for_display($row['post_text'], $row['bbcode_uid'], $row['bbcode_bitfield'], $parse_flags, true);
+ 		$sfs_reported = (int) $row['sfs_reported'];
+ 
+ 		$admins_mods = $this->sfsgroups->getadminsmods($forumid);
+@@ -190,7 +183,7 @@ class reporttosfs
+ 
+ 		if (confirm_box(true))
+ 		{
+-			$response = $this->sfsapi->sfsapi('add', $username, $userip, $useremail, $evidence, $this->config['sfs_api_key']);
++			$response = $this->sfsapi->sfsapi('add', $username, $userip, $useremail, $this->config['sfs_api_key']);
+ 
+ 			$json_decode = json_decode($response, true);
+ 			// ajax stuffs
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\stopforumspam/core/sfsapi.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\stopforumspam/core/sfsapi.php"
+index 2d478bec6..51a988d2f 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\stopforumspam/core/sfsapi.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\stopforumspam/core/sfsapi.php"
+@@ -63,7 +63,7 @@ class sfsapi
+ 	* @param	$apikey			the api key of the forum
+ 	* @return 	bool|string		return true on success or false on failure or string on curl error
+ 	*/
+-	public function sfsapi($type, $username, $userip, $useremail, $evidence = '', $apikey = '')
++	public function sfsapi($type, $username, $userip, $useremail, $apikey = '')
+ 	{
+ 		// We'll use curl..most servers have it installed as default
+ 		if (!function_exists('curl_init'))
+@@ -83,7 +83,6 @@ class sfsapi
+ 				'username' => $username,
+ 				'ip' => $userip,
+ 				'email' => $useremail,
+-				'evidence' => $evidence,
+ 				'api_key' => $apikey
+ 			];
+ 
+@@ -129,7 +128,6 @@ class sfsapi
+ 		{
+ 			return json_encode($error_message);
+ 		}
+-
+ 		// if nothing is returned (SFS is down)
+ 		if ($httpcode != 200)
+ 		{
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\stopforumspam/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\stopforumspam/diff_full.tmp"
+new file mode 100644
+index 000000000..5f3338f45
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\stopforumspam/diff_full.tmp"
+@@ -0,0 +1,71 @@
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\stopforumspam/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\stopforumspam/composer.json"
++index bb4a255b0..8356eb025 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\stopforumspam/composer.json"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\stopforumspam/composer.json"
++@@ -3,8 +3,8 @@
++     "type": "phpbb-extension",
++     "description": "Queries the stop forum spam database on registration and posting.  Extension settings are found under the extension tab of the forum. This extension requires at least phpBB version 3.3.",
++     "homepage": "https://github.com/rmcgirr83/stopforumspam",
++-    "version": "1.4.8",
++-    "time": "2025-04-27",
+++    "version": "1.4.6",
+++    "time": "2024-02-16",
++     "license": "GPL-2.0-only",
++     "authors": [
++         {
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\stopforumspam/controller/admin_controller.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\stopforumspam/controller/admin_controller.php"
++index 420f3ae0f..ca1b28706 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\stopforumspam/controller/admin_controller.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\stopforumspam/controller/admin_controller.php"
++@@ -367,6 +367,7 @@ class admin_controller implements admin_interface
++ 
++ 		$json_response = new json_response;
++ 		$json_response->send($data);
+++
++ 	}
++ 
++ 	/**
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\stopforumspam/core/reporttosfs.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\stopforumspam/core/reporttosfs.php"
++index ad31c1613..11ae558ea 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\stopforumspam/core/reporttosfs.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\stopforumspam/core/reporttosfs.php"
++@@ -129,7 +129,7 @@ class reporttosfs
++ 			throw new http_exception(403, 'POST_NOT_EXIST');
++ 		}
++ 
++-		$sql = 'SELECT p.*, u.username, u.user_email
+++		$sql = 'SELECT p.sfs_reported, p.poster_ip, p.topic_id, p.forum_id, u.username, u.user_email
++ 			FROM ' . POSTS_TABLE . ' p
++ 			LEFT JOIN ' . USERS_TABLE . ' u on p.poster_id = u.user_id
++ 			WHERE p.post_id = ' . (int) $postid . ' AND p.poster_id = ' . (int) $posterid;
++@@ -143,18 +143,11 @@ class reporttosfs
++ 			throw new http_exception(403, 'INFO_NOT_FOUND');
++ 		}
++ 
++-		if (!function_exists('generate_text_for_display'))
++-		{
++-			include($this->root_path . 'includes/functions_privmsgs.' . $this->php_ext);
++-		}
++ 		$username = $row['username'];
++ 		$userip = $row['poster_ip'];
++ 		$useremail = $row['user_email'];
++ 		$forumid = (int) $row['forum_id'];
++ 		$topicid = (int) $row['topic_id'];
++-		$parse_flags = ($row['bbcode_bitfield'] ? OPTION_FLAG_BBCODE : 0);
++-		$parse_flags |= ($row['enable_smilies'] ? OPTION_FLAG_SMILIES : 0);
++-		$evidence = generate_text_for_display($row['post_text'], $row['bbcode_uid'], $row['bbcode_bitfield'], $parse_flags, true);
++ 		$sfs_reported = (int) $row['sfs_reported'];
++ 
++ 		$admins_mods = $this->sfsgroups->getadminsmods($forumid);
++@@ -190,7 +183,7 @@ class reporttosfs
++ 
++ 		if (confirm_box(true))
++ 		{
++-			$response = $this->sfsapi->sfsapi('add', $username, $userip, $useremail, $evidence, $this->config['sfs_api_key']);
+++			$response = $this->sfsapi->sfsapi('add', $username, $userip, $useremail, $this->config['sfs_api_key']);
++ 
++ 			$json_decode = json_decode($response, true);
++ 			// ajax stuffs
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\stopforumspam/core/sfsapi.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\stopforumspam/core/sfsapi.php"
++index 2d478bec6..51a988d2f 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\stopforumspam/event/main_listener.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\stopforumspam/event/main_listener.php"
+index 8059cc3a7..e4bb38d0d 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\stopforumspam/event/main_listener.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\stopforumspam/event/main_listener.php"
+@@ -121,8 +121,6 @@ class main_listener implements EventSubscriberInterface
+ 			'core.ucp_pm_view_message'				=> 'ucp_pm_view_message',
+ 			// Custom events for integration with Contact Admin Extension
+ 			'rmcgirr83.contactadmin.modify_data_and_error'	=> 'user_sfs_validate_registration',
+-			// phpBB default contact us page
+-			'core.message_admin_form_submit_before'	=> 'message_admin_form_submit_before',
+ 		];
+ 	}
+ 
+@@ -422,53 +420,6 @@ class main_listener implements EventSubscriberInterface
+ 		}
+ 	}
+ 
+-	/*
+-	* message_admin_form_submit_before
+-	*
+-	* @param	$event	the event object
+-	* @return 	null
+-	* @access	public
+-	*/
+-	public function message_admin_form_submit_before($event)
+-	{
+-		if ($this->config['allow_sfs'] == false)
+-		{
+-			return false;
+-		}
+-
+-		$errors = $event['errors'];
+-
+-		// validate the user ip
+-		$userip_error = $this->validate_ip($this->user->ip);
+-		if ($userip_error)
+-		{
+-			$errors[] = $userip_error;
+-		}
+-
+-		/* On registration and only when all errors have cleared
+-		 * do not want the admin message area to fill up
+-		*/
+-		if (!sizeof($errors))
+-		{
+-			$check = $this->stopforumspam_check($this->request->variable('name', '', true), $this->user->ip, $this->request->variable('email', ''));
+-
+-			if ($check)
+-			{
+-				if ($this->config['sfs_down'] && $check === 'sfs_down')
+-				{
+-					return;
+-				}
+-				$errors[] = $this->show_message($check);
+-				// now ban the spammer by IP
+-				if (is_int($check) && $this->config['sfs_ban_ip'])
+-				{
+-					$this->sfsapi->sfs_ban('ip', $this->user->ip, (int) $check);
+-				}
+-			}
+-		}
+-		$event['errors'] = $errors;
+-	}
+-
+ 	/*
+ 	* show_message
+ 	* @param 	string	$check 		the type of check we are, uhmmm, checking
+@@ -518,7 +469,6 @@ class main_listener implements EventSubscriberInterface
+ 
+ 		// Query the SFS database and pull the data into script
+ 		$json = $this->sfsapi->sfsapi('query', $username, $ip, $email);
+-
+ 		$json_decode = json_decode($json, true);
+ 
+ 		// If there is a curl error as set in sfs_api, log the error
+@@ -557,7 +507,7 @@ class main_listener implements EventSubscriberInterface
+ 			{
+ 				if ($sfs_log_message)
+ 				{
+-					$this->log_message($username, $ip, 'LOG_SFS_MESSAGE', $email, $username_freq, $ip_freq, $email_freq);
++					$this->log_message('user', $username, $ip, 'LOG_SFS_MESSAGE', $email, $username_freq, $ip_freq, $email_freq);
+ 				}
+ 				//user is a spammer
+ 				return $spam_score;
+@@ -573,11 +523,11 @@ class main_listener implements EventSubscriberInterface
+ 			{
+ 				if ($this->config['sfs_down'])
+ 				{
+-					$this->log->add('admin', $username, $ip, 'LOG_SFS_DOWN_USER_ALLOWED', $email);
++					$this->log_message('admin', $username, $ip, 'LOG_SFS_DOWN_USER_ALLOWED', $email);
+ 				}
+ 				else
+ 				{
+-					$this->log->add('admin', $username, $ip, 'LOG_SFS_DOWN', $email);
++					$this->log_message('admin', $username, $ip, 'LOG_SFS_DOWN', $email);
+ 				}
+ 			}
+ 			return 'sfs_down';
+@@ -586,6 +536,7 @@ class main_listener implements EventSubscriberInterface
+ 
+ 	/*
+ 	* log_message	function used in this class to inject messages into the logs
++	* @param 	string	$mode 		the mode that we are doing for the log either admin or user
+ 	* @param	string	$username	the users name
+ 	* @param	string	$ip			the users ip
+ 	* @param	string	$message	the message we are injecting
+@@ -593,51 +544,51 @@ class main_listener implements EventSubscriberInterface
+ 	* @return 	void
+ 	* @access	private
+ 	*/
+-	private function log_message($username, $ip, $message, $email, $username_score = 0, $ip_score = 0, $email_score = 0)
++	private function log_message($mode, $username, $ip, $message, $email, $username_score = 0, $ip_score = 0, $email_score = 0)
+ 	{
+ 
+ 		$sfs_ip = $this->language->lang('SFS_IP_STOPPED', $ip);
+ 		$sfs_username = $this->language->lang('SFS_USERNAME_STOPPED', $username);
+ 		$sfs_email = $this->language->lang('SFS_EMAIL_STOPPED', $email);
+ 
+-		if ($this->config['sfs_by_name'] == false)
++		if ($mode === 'admin')
+ 		{
+-			$username_score = $this->language->lang('SFS_NOT_CHECKED');
++			$this->log->add('admin', $this->user->data['user_id'], $ip, $message, false, [$sfs_username, $sfs_ip, $sfs_email]);
+ 		}
+ 		else
+ 		{
+-			$username_score = $this->language->lang('SFS_FREQUENCY', $username_score);
+-		}
++			if ($this->config['sfs_by_name'] == false)
++			{
++				$username_score = $this->language->lang('SFS_NOT_CHECKED');
++			}
++			else
++			{
++				$username_score = $this->language->lang('SFS_FREQUENCY', $username_score);
++			}
+ 
+-		if ($this->config['sfs_by_email'] == false)
+-		{
+-			$email_score = $this->language->lang('SFS_NOT_CHECKED');
+-		}
+-		else
+-		{
+-			if ($email_score == (int) 255)
++			if ($this->config['sfs_by_email'] == false)
+ 			{
+-				$email_score = $this->language->lang('SFS_MARKED_TOXIC');
++				$email_score = $this->language->lang('SFS_NOT_CHECKED');
+ 			}
+ 			else
+ 			{
+ 				$email_score = $this->language->lang('SFS_FREQUENCY', $email_score);
+ 			}
+-		}
+ 
+-		if ($this->config['sfs_by_ip'] == false)
+-		{
+-			$ip_score = $this->language->lang('SFS_NOT_CHECKED');
+-		}
+-		else
+-		{
+-			$ip_score = $this->language->lang('SFS_FREQUENCY', $ip_score);
+-		}
+-		$sfs_ip .= $ip_score;
+-		$sfs_username .= $username_score;
+-		$sfs_email .= $email_score;
++			if ($this->config['sfs_by_ip'] == false)
++			{
++				$ip_score = $this->language->lang('SFS_NOT_CHECKED');
++			}
++			else
++			{
++				$ip_score = $this->language->lang('SFS_FREQUENCY', $ip_score);
++			}
++			$sfs_ip .= $ip_score;
++			$sfs_username .= $username_score;
++			$sfs_email .= $email_score;
+ 
+-		$this->log->add('user', $this->user->data['user_id'], $ip, $message, false, ['reportee_id' => $this->user->data['user_id'], $sfs_username, $sfs_ip, $sfs_email]);
++			$this->log->add('user', $this->user->data['user_id'], $ip, $message, false, ['reportee_id' => $this->user->data['user_id'], $sfs_username, $sfs_ip, $sfs_email]);
++		}
+ 	}
+ 
+ 	/*
+@@ -648,7 +599,7 @@ class main_listener implements EventSubscriberInterface
+ 	*/
+ 	private function validate_email($email)
+ 	{
+-		$error = validate_user_email($email);
++		$error = phpbb_validate_email($email);
+ 
+ 		return $error;
+ 	}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\stopforumspam/ext.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\stopforumspam/ext.php"
+index 096ad2140..d1510b9af 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\stopforumspam/ext.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\stopforumspam/ext.php"
+@@ -19,6 +19,7 @@ class ext extends \phpbb\extension\base
+ {
+ 	/** @var string Require phpBB 3.3.0 */
+ 	const PHPBB_MIN_VERSION = '3.3.0';
++
+ 	/**
+ 	* Enable extension if phpBB version requirement is met
+ 	*
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\stopforumspam/language/en/stopforumspam.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\stopforumspam/language/en/stopforumspam.php"
+index d66af058c..b72f16f1d 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\stopforumspam/language/en/stopforumspam.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\stopforumspam/language/en/stopforumspam.php"
+@@ -46,6 +46,9 @@ $lang = array_merge($lang, [
+ 	'PM_NOT_EXIST'	=> 'PM doesn’t exist',
+ 	'SFS_ANONYMIZED_IP'	=> 'The IP of the user has been anonymized, set to 127.0.0.1, probably due to an extension.',
+ 	'SFS_MISSING_DATA'	=> 'Not all information is provided to report to Stop Forum Spam.',
++	'SFS_IP_STOPPED'	=> '<a target="_blank" title="Check IP at StopForumSpam.com (opens in a new window)" href="http://www.stopforumspam.com/ipcheck/%1$s" rel="noreferrer noopener">%1$s</a>',
++	'SFS_USERNAME_STOPPED'	=> '<a target="_blank" title="Check Username at StopForumSpam.com (opens in a new window)" href="http://www.stopforumspam.com/search/?q=%1$s" rel="noreferrer noopener">%1$s</a>',
++	'SFS_EMAIL_STOPPED'	=> '<a target="_blank" title="Check Email at StopForumSpam.com (opens in a new window)" href="http://www.stopforumspam.com/search/?q=%1$s" rel="noreferrer noopener">%1$s</a>',
+ 	'SFS_FREQUENCY'	=> ' » found in sfs database %d times',
+ 	'SFS_IP_STOPPED'	=> '<a target="_blank" title="Check IP at StopForumSpam.com (opens in a new window)" href="http://www.stopforumspam.com/ipcheck/%1$s" rel="noreferrer noopener">%1$s</a>',
+ 	'SFS_USERNAME_STOPPED'	=> '<a target="_blank" title="Check Username at StopForumSpam.com (opens in a new window)" href="http://www.stopforumspam.com/search/?q=%1$s" rel="noreferrer noopener">%1$s</a>',
+@@ -55,7 +58,6 @@ $lang = array_merge($lang, [
+ 		1 => 'Found in the Stop Forum Spam database once',
+ 		2 => 'Found in the Stop Forum Spam database %d times',
+ 	],
+-	'SFS_MARKED_TOXIC'	=> ' » Email domain marked as TOXIC',
+ 	'SFS_USER_BANNED'	=> 'Banned due to a post on the forum',
+ 	'SFS_REPORTED'		=> 'Post has already been reported',
+ 	'SFS_PM_REPORTED'	=> 'PM has already been reported',
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\stopforumspam/styles/BBOOTS/template/event/overall_footer_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\stopforumspam/styles/BBOOTS/template/event/overall_footer_after.html"
+new file mode 100644
+index 000000000..8812ab7a4
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\stopforumspam/styles/BBOOTS/template/event/overall_footer_after.html"
+@@ -0,0 +1,16 @@
++<script>
++head.ready(function () {
++(function($) {  // Avoid conflicts with other libraries
++
++'use strict';
++	
++	phpbb.addAjaxCallback('reporttosfs', function(data) {
++		if (data.postid !== "undefined") {
++			$('#sfs' + data.postid).hide();
++			phpbb.closeDarkenWrapper(5000);
++		}
++	});
++
++})(jQuery);
++});
++</script>
+\ No newline at end of file
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\stopforumspam/styles/BBOOTS/template/event/posting_editor_subject_before.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\stopforumspam/styles/BBOOTS/template/event/posting_editor_subject_before.html"
+new file mode 100644
+index 000000000..192084a6f
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\stopforumspam/styles/BBOOTS/template/event/posting_editor_subject_before.html"
+@@ -0,0 +1,6 @@
++<!-- IF SFS -->
++<div class="control-group">	
++	<label class="control-label" for="email">{L_EMAIL_ADDRESS}{L_COLON}</label>
++	<input type="email" tabindex="2" name="email" id="email" size="25" maxlength="100" value="{EMAIL}" class="form-control" title="{L_EMAIL_ADDRESS}" />
++</div>	
++<!-- ENDIF -->
+\ No newline at end of file
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\stopforumspam/styles/BBOOTS/template/event/ucp_pm_viewmessage_post_buttons_before.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\stopforumspam/styles/BBOOTS/template/event/ucp_pm_viewmessage_post_buttons_before.html"
+new file mode 100644
+index 000000000..e604e0a8e
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\stopforumspam/styles/BBOOTS/template/event/ucp_pm_viewmessage_post_buttons_before.html"
+@@ -0,0 +1,5 @@
++{% if SFS_LINK %}
++	<li id="sfs{{ MESSAGE_ID }}">
++		{{ SFS_LINK }}
++	</li>
++{% endif %}
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\stopforumspam/styles/BBOOTS/template/event/viewtopic_body_post_buttons_list_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\stopforumspam/styles/BBOOTS/template/event/viewtopic_body_post_buttons_list_after.html"
+new file mode 100644
+index 000000000..daca14b7f
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\stopforumspam/styles/BBOOTS/template/event/viewtopic_body_post_buttons_list_after.html"
+@@ -0,0 +1,3 @@
++<!-- IF postrow.SFS_LINK -->
++	<li id="sfs{postrow.POST_ID}">{postrow.SFS_LINK}</li>
++<!-- ENDIF -->
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\stopforumspam/styles/FLATBOOTS/template/event/overall_footer_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\stopforumspam/styles/FLATBOOTS/template/event/overall_footer_after.html"
+new file mode 100644
+index 000000000..8812ab7a4
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\stopforumspam/styles/FLATBOOTS/template/event/overall_footer_after.html"
+@@ -0,0 +1,16 @@
++<script>
++head.ready(function () {
++(function($) {  // Avoid conflicts with other libraries
++
++'use strict';
++	
++	phpbb.addAjaxCallback('reporttosfs', function(data) {
++		if (data.postid !== "undefined") {
++			$('#sfs' + data.postid).hide();
++			phpbb.closeDarkenWrapper(5000);
++		}
++	});
++
++})(jQuery);
++});
++</script>
+\ No newline at end of file
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\stopforumspam/styles/FLATBOOTS/template/event/posting_editor_subject_before.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\stopforumspam/styles/FLATBOOTS/template/event/posting_editor_subject_before.html"
+new file mode 100644
+index 000000000..d937eb793
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\stopforumspam/styles/FLATBOOTS/template/event/posting_editor_subject_before.html"
+@@ -0,0 +1,6 @@
++{% if SFS %}
++<div class="control-group">	
++	<label class="control-label" for="email">{{ lang('EMAIL_ADDRESS') }}{{ lang('COLON') }}</label>
++	<input type="email" tabindex="2" name="email" id="email" size="25" maxlength="100" value="{{ EMAIL }}" class="form-control" title="{{ lang('EMAIL_ADDRESS') }}" />
++</div>	
++{% endif %}
+\ No newline at end of file
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\stopforumspam/styles/FLATBOOTS/template/event/ucp_pm_viewmessage_post_buttons_before.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\stopforumspam/styles/FLATBOOTS/template/event/ucp_pm_viewmessage_post_buttons_before.html"
+new file mode 100644
+index 000000000..e604e0a8e
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\stopforumspam/styles/FLATBOOTS/template/event/ucp_pm_viewmessage_post_buttons_before.html"
+@@ -0,0 +1,5 @@
++{% if SFS_LINK %}
++	<li id="sfs{{ MESSAGE_ID }}">
++		{{ SFS_LINK }}
++	</li>
++{% endif %}
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\stopforumspam/styles/FLATBOOTS/template/event/viewtopic_body_post_buttons_list_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\stopforumspam/styles/FLATBOOTS/template/event/viewtopic_body_post_buttons_list_after.html"
+new file mode 100644
+index 000000000..e0f89be3e
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\stopforumspam/styles/FLATBOOTS/template/event/viewtopic_body_post_buttons_list_after.html"
+@@ -0,0 +1,9 @@
++{% if postrow.SFS_LINK %}
++	<li id="sfs{{ postrow.POST_ID }}">
++		<a href="{{ postrow.SFS_LINK }}" title="{{ lang('REPORT_TO_SFS') }}" data-ajax="reporttosfs" class="button button-icon-only">
++			<i class="fa fa-exchange" aria-hidden="true"></i>
++			<span class="sr-only">{{ lang('BUTTON_SFS') }}</span>
++		</a>
++	</li>
++{% endif %}
++
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\stopforumspam/styles/scaffoldBB/template/event/posting_editor_subject_before.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\stopforumspam/styles/scaffoldBB/template/event/posting_editor_subject_before.html"
+deleted file mode 100644
+index fad37cfc1..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\stopforumspam/styles/scaffoldBB/template/event/posting_editor_subject_before.html"
++++ /dev/null
+@@ -1,6 +0,0 @@
+-{% if SFS %}
+-	<dl class="row gx-0 mb-1">
+-		<dt class="col-md-2 mb-1"><label for="email">{{ lang('EMAIL_ADDRESS') }}{{ lang('COLON') }}</label></dt>
+-		<dd class="col-md-auto mb-1"><input type="email" tabindex="2" name="email" id="email" size="25" maxlength="100" value="{{ EMAIL }}" class="inputbox autowidth form-control form-control-sm" title="{{ lang('EMAIL_ADDRESS') }}" /></dd>
+-	</dl>
+-{% endif %}
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\stopforumspam/styles/scaffoldBB/template/event/ucp_pm_viewmessage_post_buttons_before.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\stopforumspam/styles/scaffoldBB/template/event/ucp_pm_viewmessage_post_buttons_before.html"
+deleted file mode 100644
+index c950f55d7..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\stopforumspam/styles/scaffoldBB/template/event/ucp_pm_viewmessage_post_buttons_before.html"
++++ /dev/null
+@@ -1,5 +0,0 @@
+-{% if S_SFS %}
+-	<li id="sfs{{ MESSAGE_ID }}">
+-		<a href="{{ U_SFS }}" title="{{ lang('REPORT_TO_SFS') }}" data-ajax="reporttosfs" class="bg-gradient btn btn-secondary btn-sm button button-icon-only rounded-3"><i class="icon fa fa-exchange fa-fw" aria-hidden="true"></i><span class="visually-hidden">{{ lang('REPORT_TO_SFS') }}</span></a>
+-	</li>
+-{% endif %}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\stopforumspam/styles/scaffoldBB/template/event/viewtopic_body_post_buttons_before.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\stopforumspam/styles/scaffoldBB/template/event/viewtopic_body_post_buttons_before.html"
+deleted file mode 100644
+index 68b80bcb4..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\stopforumspam/styles/scaffoldBB/template/event/viewtopic_body_post_buttons_before.html"
++++ /dev/null
+@@ -1,8 +0,0 @@
+-{% if postrow.S_SFS %}
+-	<li id="sfs{{ postrow.POST_ID }}">
+-		<a href="{{ postrow.U_SFS }}" title="{{ lang('REPORT_TO_SFS') }}" data-ajax="reporttosfs" class="bg-gradient btn-secondary btn btn-sm button button-icon-only rounded-3 shadow-sm">
+-			<i class="icon fa fa-exchange fa-fw" aria-hidden="true"></i>
+-			<span class="visually-hidden">{{ lang('BUTTON_SFS') }}</span>
+-		</a>
+-	</li>
+-{% endif %}
diff --git "[FORUM_EXT]/rmcgirr83\\stopforumspam/diff_nospace.tmp" "[FORUM_EXT]/rmcgirr83\\stopforumspam/diff_nospace.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/rmcgirr83\\stopforumspam/diff_nospace.tmp"
@@ -0,0 +1,632 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\stopforumspam/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\stopforumspam/composer.json"
+index bb4a255b0..8356eb025 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\stopforumspam/composer.json"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\stopforumspam/composer.json"
+@@ -3,8 +3,8 @@
+     "type": "phpbb-extension",
+     "description": "Queries the stop forum spam database on registration and posting.  Extension settings are found under the extension tab of the forum. This extension requires at least phpBB version 3.3.",
+     "homepage": "https://github.com/rmcgirr83/stopforumspam",
+-    "version": "1.4.8",
+-    "time": "2025-04-27",
++    "version": "1.4.6",
++    "time": "2024-02-16",
+     "license": "GPL-2.0-only",
+     "authors": [
+         {
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\stopforumspam/controller/admin_controller.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\stopforumspam/controller/admin_controller.php"
+index 420f3ae0f..ca1b28706 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\stopforumspam/controller/admin_controller.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\stopforumspam/controller/admin_controller.php"
+@@ -367,6 +367,7 @@ class admin_controller implements admin_interface
+ 
+ 		$json_response = new json_response;
+ 		$json_response->send($data);
++
+ 	}
+ 
+ 	/**
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\stopforumspam/core/reporttosfs.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\stopforumspam/core/reporttosfs.php"
+index ad31c1613..11ae558ea 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\stopforumspam/core/reporttosfs.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\stopforumspam/core/reporttosfs.php"
+@@ -129,7 +129,7 @@ class reporttosfs
+ 			throw new http_exception(403, 'POST_NOT_EXIST');
+ 		}
+ 
+-		$sql = 'SELECT p.*, u.username, u.user_email
++		$sql = 'SELECT p.sfs_reported, p.poster_ip, p.topic_id, p.forum_id, u.username, u.user_email
+ 			FROM ' . POSTS_TABLE . ' p
+ 			LEFT JOIN ' . USERS_TABLE . ' u on p.poster_id = u.user_id
+ 			WHERE p.post_id = ' . (int) $postid . ' AND p.poster_id = ' . (int) $posterid;
+@@ -143,18 +143,11 @@ class reporttosfs
+ 			throw new http_exception(403, 'INFO_NOT_FOUND');
+ 		}
+ 
+-		if (!function_exists('generate_text_for_display'))
+-		{
+-			include($this->root_path . 'includes/functions_privmsgs.' . $this->php_ext);
+-		}
+ 		$username = $row['username'];
+ 		$userip = $row['poster_ip'];
+ 		$useremail = $row['user_email'];
+ 		$forumid = (int) $row['forum_id'];
+ 		$topicid = (int) $row['topic_id'];
+-		$parse_flags = ($row['bbcode_bitfield'] ? OPTION_FLAG_BBCODE : 0);
+-		$parse_flags |= ($row['enable_smilies'] ? OPTION_FLAG_SMILIES : 0);
+-		$evidence = generate_text_for_display($row['post_text'], $row['bbcode_uid'], $row['bbcode_bitfield'], $parse_flags, true);
+ 		$sfs_reported = (int) $row['sfs_reported'];
+ 
+ 		$admins_mods = $this->sfsgroups->getadminsmods($forumid);
+@@ -190,7 +183,7 @@ class reporttosfs
+ 
+ 		if (confirm_box(true))
+ 		{
+-			$response = $this->sfsapi->sfsapi('add', $username, $userip, $useremail, $evidence, $this->config['sfs_api_key']);
++			$response = $this->sfsapi->sfsapi('add', $username, $userip, $useremail, $this->config['sfs_api_key']);
+ 
+ 			$json_decode = json_decode($response, true);
+ 			// ajax stuffs
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\stopforumspam/core/sfsapi.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\stopforumspam/core/sfsapi.php"
+index 2d478bec6..51a988d2f 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\stopforumspam/core/sfsapi.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\stopforumspam/core/sfsapi.php"
+@@ -63,7 +63,7 @@ class sfsapi
+ 	* @param	$apikey			the api key of the forum
+ 	* @return 	bool|string		return true on success or false on failure or string on curl error
+ 	*/
+-	public function sfsapi($type, $username, $userip, $useremail, $evidence = '', $apikey = '')
++	public function sfsapi($type, $username, $userip, $useremail, $apikey = '')
+ 	{
+ 		// We'll use curl..most servers have it installed as default
+ 		if (!function_exists('curl_init'))
+@@ -83,7 +83,6 @@ class sfsapi
+ 				'username' => $username,
+ 				'ip' => $userip,
+ 				'email' => $useremail,
+-				'evidence' => $evidence,
+ 				'api_key' => $apikey
+ 			];
+ 
+@@ -129,7 +128,6 @@ class sfsapi
+ 		{
+ 			return json_encode($error_message);
+ 		}
+-
+ 		// if nothing is returned (SFS is down)
+ 		if ($httpcode != 200)
+ 		{
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\stopforumspam/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\stopforumspam/diff_full.tmp"
+new file mode 100644
+index 000000000..30f1f5747
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\stopforumspam/diff_full.tmp"
+@@ -0,0 +1,558 @@
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\stopforumspam/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\stopforumspam/composer.json"
++index bb4a255b0..8356eb025 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\stopforumspam/composer.json"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\stopforumspam/composer.json"
++@@ -3,8 +3,8 @@
++     "type": "phpbb-extension",
++     "description": "Queries the stop forum spam database on registration and posting.  Extension settings are found under the extension tab of the forum. This extension requires at least phpBB version 3.3.",
++     "homepage": "https://github.com/rmcgirr83/stopforumspam",
++-    "version": "1.4.8",
++-    "time": "2025-04-27",
+++    "version": "1.4.6",
+++    "time": "2024-02-16",
++     "license": "GPL-2.0-only",
++     "authors": [
++         {
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\stopforumspam/controller/admin_controller.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\stopforumspam/controller/admin_controller.php"
++index 420f3ae0f..ca1b28706 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\stopforumspam/controller/admin_controller.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\stopforumspam/controller/admin_controller.php"
++@@ -367,6 +367,7 @@ class admin_controller implements admin_interface
++ 
++ 		$json_response = new json_response;
++ 		$json_response->send($data);
+++
++ 	}
++ 
++ 	/**
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\stopforumspam/core/reporttosfs.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\stopforumspam/core/reporttosfs.php"
++index ad31c1613..11ae558ea 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\stopforumspam/core/reporttosfs.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\stopforumspam/core/reporttosfs.php"
++@@ -129,7 +129,7 @@ class reporttosfs
++ 			throw new http_exception(403, 'POST_NOT_EXIST');
++ 		}
++ 
++-		$sql = 'SELECT p.*, u.username, u.user_email
+++		$sql = 'SELECT p.sfs_reported, p.poster_ip, p.topic_id, p.forum_id, u.username, u.user_email
++ 			FROM ' . POSTS_TABLE . ' p
++ 			LEFT JOIN ' . USERS_TABLE . ' u on p.poster_id = u.user_id
++ 			WHERE p.post_id = ' . (int) $postid . ' AND p.poster_id = ' . (int) $posterid;
++@@ -143,18 +143,11 @@ class reporttosfs
++ 			throw new http_exception(403, 'INFO_NOT_FOUND');
++ 		}
++ 
++-		if (!function_exists('generate_text_for_display'))
++-		{
++-			include($this->root_path . 'includes/functions_privmsgs.' . $this->php_ext);
++-		}
++ 		$username = $row['username'];
++ 		$userip = $row['poster_ip'];
++ 		$useremail = $row['user_email'];
++ 		$forumid = (int) $row['forum_id'];
++ 		$topicid = (int) $row['topic_id'];
++-		$parse_flags = ($row['bbcode_bitfield'] ? OPTION_FLAG_BBCODE : 0);
++-		$parse_flags |= ($row['enable_smilies'] ? OPTION_FLAG_SMILIES : 0);
++-		$evidence = generate_text_for_display($row['post_text'], $row['bbcode_uid'], $row['bbcode_bitfield'], $parse_flags, true);
++ 		$sfs_reported = (int) $row['sfs_reported'];
++ 
++ 		$admins_mods = $this->sfsgroups->getadminsmods($forumid);
++@@ -190,7 +183,7 @@ class reporttosfs
++ 
++ 		if (confirm_box(true))
++ 		{
++-			$response = $this->sfsapi->sfsapi('add', $username, $userip, $useremail, $evidence, $this->config['sfs_api_key']);
+++			$response = $this->sfsapi->sfsapi('add', $username, $userip, $useremail, $this->config['sfs_api_key']);
++ 
++ 			$json_decode = json_decode($response, true);
++ 			// ajax stuffs
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\stopforumspam/core/sfsapi.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\stopforumspam/core/sfsapi.php"
++index 2d478bec6..51a988d2f 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\stopforumspam/core/sfsapi.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\stopforumspam/core/sfsapi.php"
++@@ -63,7 +63,7 @@ class sfsapi
++ 	* @param	$apikey			the api key of the forum
++ 	* @return 	bool|string		return true on success or false on failure or string on curl error
++ 	*/
++-	public function sfsapi($type, $username, $userip, $useremail, $evidence = '', $apikey = '')
+++	public function sfsapi($type, $username, $userip, $useremail, $apikey = '')
++ 	{
++ 		// We'll use curl..most servers have it installed as default
++ 		if (!function_exists('curl_init'))
++@@ -83,7 +83,6 @@ class sfsapi
++ 				'username' => $username,
++ 				'ip' => $userip,
++ 				'email' => $useremail,
++-				'evidence' => $evidence,
++ 				'api_key' => $apikey
++ 			];
++ 
++@@ -129,7 +128,6 @@ class sfsapi
++ 		{
++ 			return json_encode($error_message);
++ 		}
++-
++ 		// if nothing is returned (SFS is down)
++ 		if ($httpcode != 200)
++ 		{
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\stopforumspam/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\stopforumspam/diff_full.tmp"
++new file mode 100644
++index 000000000..5f3338f45
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\stopforumspam/diff_full.tmp"
++@@ -0,0 +1,71 @@
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\stopforumspam/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\stopforumspam/composer.json"
+++index bb4a255b0..8356eb025 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\stopforumspam/composer.json"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\stopforumspam/composer.json"
+++@@ -3,8 +3,8 @@
+++     "type": "phpbb-extension",
+++     "description": "Queries the stop forum spam database on registration and posting.  Extension settings are found under the extension tab of the forum. This extension requires at least phpBB version 3.3.",
+++     "homepage": "https://github.com/rmcgirr83/stopforumspam",
+++-    "version": "1.4.8",
+++-    "time": "2025-04-27",
++++    "version": "1.4.6",
++++    "time": "2024-02-16",
+++     "license": "GPL-2.0-only",
+++     "authors": [
+++         {
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\stopforumspam/controller/admin_controller.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\stopforumspam/controller/admin_controller.php"
+++index 420f3ae0f..ca1b28706 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\stopforumspam/controller/admin_controller.php"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\stopforumspam/controller/admin_controller.php"
+++@@ -367,6 +367,7 @@ class admin_controller implements admin_interface
+++ 
+++ 		$json_response = new json_response;
+++ 		$json_response->send($data);
++++
+++ 	}
+++ 
+++ 	/**
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\stopforumspam/core/reporttosfs.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\stopforumspam/core/reporttosfs.php"
+++index ad31c1613..11ae558ea 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\stopforumspam/core/reporttosfs.php"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\stopforumspam/core/reporttosfs.php"
+++@@ -129,7 +129,7 @@ class reporttosfs
+++ 			throw new http_exception(403, 'POST_NOT_EXIST');
+++ 		}
+++ 
+++-		$sql = 'SELECT p.*, u.username, u.user_email
++++		$sql = 'SELECT p.sfs_reported, p.poster_ip, p.topic_id, p.forum_id, u.username, u.user_email
+++ 			FROM ' . POSTS_TABLE . ' p
+++ 			LEFT JOIN ' . USERS_TABLE . ' u on p.poster_id = u.user_id
+++ 			WHERE p.post_id = ' . (int) $postid . ' AND p.poster_id = ' . (int) $posterid;
+++@@ -143,18 +143,11 @@ class reporttosfs
+++ 			throw new http_exception(403, 'INFO_NOT_FOUND');
+++ 		}
+++ 
+++-		if (!function_exists('generate_text_for_display'))
+++-		{
+++-			include($this->root_path . 'includes/functions_privmsgs.' . $this->php_ext);
+++-		}
+++ 		$username = $row['username'];
+++ 		$userip = $row['poster_ip'];
+++ 		$useremail = $row['user_email'];
+++ 		$forumid = (int) $row['forum_id'];
+++ 		$topicid = (int) $row['topic_id'];
+++-		$parse_flags = ($row['bbcode_bitfield'] ? OPTION_FLAG_BBCODE : 0);
+++-		$parse_flags |= ($row['enable_smilies'] ? OPTION_FLAG_SMILIES : 0);
+++-		$evidence = generate_text_for_display($row['post_text'], $row['bbcode_uid'], $row['bbcode_bitfield'], $parse_flags, true);
+++ 		$sfs_reported = (int) $row['sfs_reported'];
+++ 
+++ 		$admins_mods = $this->sfsgroups->getadminsmods($forumid);
+++@@ -190,7 +183,7 @@ class reporttosfs
+++ 
+++ 		if (confirm_box(true))
+++ 		{
+++-			$response = $this->sfsapi->sfsapi('add', $username, $userip, $useremail, $evidence, $this->config['sfs_api_key']);
++++			$response = $this->sfsapi->sfsapi('add', $username, $userip, $useremail, $this->config['sfs_api_key']);
+++ 
+++ 			$json_decode = json_decode($response, true);
+++ 			// ajax stuffs
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\stopforumspam/core/sfsapi.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\stopforumspam/core/sfsapi.php"
+++index 2d478bec6..51a988d2f 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\stopforumspam/event/main_listener.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\stopforumspam/event/main_listener.php"
++index 8059cc3a7..e4bb38d0d 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\stopforumspam/event/main_listener.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\stopforumspam/event/main_listener.php"
++@@ -121,8 +121,6 @@ class main_listener implements EventSubscriberInterface
++ 			'core.ucp_pm_view_message'				=> 'ucp_pm_view_message',
++ 			// Custom events for integration with Contact Admin Extension
++ 			'rmcgirr83.contactadmin.modify_data_and_error'	=> 'user_sfs_validate_registration',
++-			// phpBB default contact us page
++-			'core.message_admin_form_submit_before'	=> 'message_admin_form_submit_before',
++ 		];
++ 	}
++ 
++@@ -422,53 +420,6 @@ class main_listener implements EventSubscriberInterface
++ 		}
++ 	}
++ 
++-	/*
++-	* message_admin_form_submit_before
++-	*
++-	* @param	$event	the event object
++-	* @return 	null
++-	* @access	public
++-	*/
++-	public function message_admin_form_submit_before($event)
++-	{
++-		if ($this->config['allow_sfs'] == false)
++-		{
++-			return false;
++-		}
++-
++-		$errors = $event['errors'];
++-
++-		// validate the user ip
++-		$userip_error = $this->validate_ip($this->user->ip);
++-		if ($userip_error)
++-		{
++-			$errors[] = $userip_error;
++-		}
++-
++-		/* On registration and only when all errors have cleared
++-		 * do not want the admin message area to fill up
++-		*/
++-		if (!sizeof($errors))
++-		{
++-			$check = $this->stopforumspam_check($this->request->variable('name', '', true), $this->user->ip, $this->request->variable('email', ''));
++-
++-			if ($check)
++-			{
++-				if ($this->config['sfs_down'] && $check === 'sfs_down')
++-				{
++-					return;
++-				}
++-				$errors[] = $this->show_message($check);
++-				// now ban the spammer by IP
++-				if (is_int($check) && $this->config['sfs_ban_ip'])
++-				{
++-					$this->sfsapi->sfs_ban('ip', $this->user->ip, (int) $check);
++-				}
++-			}
++-		}
++-		$event['errors'] = $errors;
++-	}
++-
++ 	/*
++ 	* show_message
++ 	* @param 	string	$check 		the type of check we are, uhmmm, checking
++@@ -518,7 +469,6 @@ class main_listener implements EventSubscriberInterface
++ 
++ 		// Query the SFS database and pull the data into script
++ 		$json = $this->sfsapi->sfsapi('query', $username, $ip, $email);
++-
++ 		$json_decode = json_decode($json, true);
++ 
++ 		// If there is a curl error as set in sfs_api, log the error
++@@ -557,7 +507,7 @@ class main_listener implements EventSubscriberInterface
++ 			{
++ 				if ($sfs_log_message)
++ 				{
++-					$this->log_message($username, $ip, 'LOG_SFS_MESSAGE', $email, $username_freq, $ip_freq, $email_freq);
+++					$this->log_message('user', $username, $ip, 'LOG_SFS_MESSAGE', $email, $username_freq, $ip_freq, $email_freq);
++ 				}
++ 				//user is a spammer
++ 				return $spam_score;
++@@ -573,11 +523,11 @@ class main_listener implements EventSubscriberInterface
++ 			{
++ 				if ($this->config['sfs_down'])
++ 				{
++-					$this->log->add('admin', $username, $ip, 'LOG_SFS_DOWN_USER_ALLOWED', $email);
+++					$this->log_message('admin', $username, $ip, 'LOG_SFS_DOWN_USER_ALLOWED', $email);
++ 				}
++ 				else
++ 				{
++-					$this->log->add('admin', $username, $ip, 'LOG_SFS_DOWN', $email);
+++					$this->log_message('admin', $username, $ip, 'LOG_SFS_DOWN', $email);
++ 				}
++ 			}
++ 			return 'sfs_down';
++@@ -586,6 +536,7 @@ class main_listener implements EventSubscriberInterface
++ 
++ 	/*
++ 	* log_message	function used in this class to inject messages into the logs
+++	* @param 	string	$mode 		the mode that we are doing for the log either admin or user
++ 	* @param	string	$username	the users name
++ 	* @param	string	$ip			the users ip
++ 	* @param	string	$message	the message we are injecting
++@@ -593,51 +544,51 @@ class main_listener implements EventSubscriberInterface
++ 	* @return 	void
++ 	* @access	private
++ 	*/
++-	private function log_message($username, $ip, $message, $email, $username_score = 0, $ip_score = 0, $email_score = 0)
+++	private function log_message($mode, $username, $ip, $message, $email, $username_score = 0, $ip_score = 0, $email_score = 0)
++ 	{
++ 
++ 		$sfs_ip = $this->language->lang('SFS_IP_STOPPED', $ip);
++ 		$sfs_username = $this->language->lang('SFS_USERNAME_STOPPED', $username);
++ 		$sfs_email = $this->language->lang('SFS_EMAIL_STOPPED', $email);
++ 
++-		if ($this->config['sfs_by_name'] == false)
+++		if ($mode === 'admin')
++ 		{
++-			$username_score = $this->language->lang('SFS_NOT_CHECKED');
+++			$this->log->add('admin', $this->user->data['user_id'], $ip, $message, false, [$sfs_username, $sfs_ip, $sfs_email]);
++ 		}
++ 		else
++ 		{
++-			$username_score = $this->language->lang('SFS_FREQUENCY', $username_score);
++-		}
+++			if ($this->config['sfs_by_name'] == false)
+++			{
+++				$username_score = $this->language->lang('SFS_NOT_CHECKED');
+++			}
+++			else
+++			{
+++				$username_score = $this->language->lang('SFS_FREQUENCY', $username_score);
+++			}
++ 
++-		if ($this->config['sfs_by_email'] == false)
++-		{
++-			$email_score = $this->language->lang('SFS_NOT_CHECKED');
++-		}
++-		else
++-		{
++-			if ($email_score == (int) 255)
+++			if ($this->config['sfs_by_email'] == false)
++ 			{
++-				$email_score = $this->language->lang('SFS_MARKED_TOXIC');
+++				$email_score = $this->language->lang('SFS_NOT_CHECKED');
++ 			}
++ 			else
++ 			{
++ 				$email_score = $this->language->lang('SFS_FREQUENCY', $email_score);
++ 			}
++-		}
++ 
++-		if ($this->config['sfs_by_ip'] == false)
++-		{
++-			$ip_score = $this->language->lang('SFS_NOT_CHECKED');
++-		}
++-		else
++-		{
++-			$ip_score = $this->language->lang('SFS_FREQUENCY', $ip_score);
++-		}
++-		$sfs_ip .= $ip_score;
++-		$sfs_username .= $username_score;
++-		$sfs_email .= $email_score;
+++			if ($this->config['sfs_by_ip'] == false)
+++			{
+++				$ip_score = $this->language->lang('SFS_NOT_CHECKED');
+++			}
+++			else
+++			{
+++				$ip_score = $this->language->lang('SFS_FREQUENCY', $ip_score);
+++			}
+++			$sfs_ip .= $ip_score;
+++			$sfs_username .= $username_score;
+++			$sfs_email .= $email_score;
++ 
++-		$this->log->add('user', $this->user->data['user_id'], $ip, $message, false, ['reportee_id' => $this->user->data['user_id'], $sfs_username, $sfs_ip, $sfs_email]);
+++			$this->log->add('user', $this->user->data['user_id'], $ip, $message, false, ['reportee_id' => $this->user->data['user_id'], $sfs_username, $sfs_ip, $sfs_email]);
+++		}
++ 	}
++ 
++ 	/*
++@@ -648,7 +599,7 @@ class main_listener implements EventSubscriberInterface
++ 	*/
++ 	private function validate_email($email)
++ 	{
++-		$error = validate_user_email($email);
+++		$error = phpbb_validate_email($email);
++ 
++ 		return $error;
++ 	}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\stopforumspam/ext.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\stopforumspam/ext.php"
++index 096ad2140..d1510b9af 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\stopforumspam/ext.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\stopforumspam/ext.php"
++@@ -19,6 +19,7 @@ class ext extends \phpbb\extension\base
++ {
++ 	/** @var string Require phpBB 3.3.0 */
++ 	const PHPBB_MIN_VERSION = '3.3.0';
+++
++ 	/**
++ 	* Enable extension if phpBB version requirement is met
++ 	*
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\stopforumspam/language/en/stopforumspam.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\stopforumspam/language/en/stopforumspam.php"
++index d66af058c..b72f16f1d 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\stopforumspam/language/en/stopforumspam.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\stopforumspam/language/en/stopforumspam.php"
++@@ -46,6 +46,9 @@ $lang = array_merge($lang, [
++ 	'PM_NOT_EXIST'	=> 'PM doesn’t exist',
++ 	'SFS_ANONYMIZED_IP'	=> 'The IP of the user has been anonymized, set to 127.0.0.1, probably due to an extension.',
++ 	'SFS_MISSING_DATA'	=> 'Not all information is provided to report to Stop Forum Spam.',
+++	'SFS_IP_STOPPED'	=> '<a target="_blank" title="Check IP at StopForumSpam.com (opens in a new window)" href="http://www.stopforumspam.com/ipcheck/%1$s" rel="noreferrer noopener">%1$s</a>',
+++	'SFS_USERNAME_STOPPED'	=> '<a target="_blank" title="Check Username at StopForumSpam.com (opens in a new window)" href="http://www.stopforumspam.com/search/?q=%1$s" rel="noreferrer noopener">%1$s</a>',
+++	'SFS_EMAIL_STOPPED'	=> '<a target="_blank" title="Check Email at StopForumSpam.com (opens in a new window)" href="http://www.stopforumspam.com/search/?q=%1$s" rel="noreferrer noopener">%1$s</a>',
++ 	'SFS_FREQUENCY'	=> ' » found in sfs database %d times',
++ 	'SFS_IP_STOPPED'	=> '<a target="_blank" title="Check IP at StopForumSpam.com (opens in a new window)" href="http://www.stopforumspam.com/ipcheck/%1$s" rel="noreferrer noopener">%1$s</a>',
++ 	'SFS_USERNAME_STOPPED'	=> '<a target="_blank" title="Check Username at StopForumSpam.com (opens in a new window)" href="http://www.stopforumspam.com/search/?q=%1$s" rel="noreferrer noopener">%1$s</a>',
++@@ -55,7 +58,6 @@ $lang = array_merge($lang, [
++ 		1 => 'Found in the Stop Forum Spam database once',
++ 		2 => 'Found in the Stop Forum Spam database %d times',
++ 	],
++-	'SFS_MARKED_TOXIC'	=> ' » Email domain marked as TOXIC',
++ 	'SFS_USER_BANNED'	=> 'Banned due to a post on the forum',
++ 	'SFS_REPORTED'		=> 'Post has already been reported',
++ 	'SFS_PM_REPORTED'	=> 'PM has already been reported',
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\stopforumspam/styles/BBOOTS/template/event/overall_footer_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\stopforumspam/styles/BBOOTS/template/event/overall_footer_after.html"
++new file mode 100644
++index 000000000..8812ab7a4
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\stopforumspam/styles/BBOOTS/template/event/overall_footer_after.html"
++@@ -0,0 +1,16 @@
+++<script>
+++head.ready(function () {
+++(function($) {  // Avoid conflicts with other libraries
+++
+++'use strict';
+++	
+++	phpbb.addAjaxCallback('reporttosfs', function(data) {
+++		if (data.postid !== "undefined") {
+++			$('#sfs' + data.postid).hide();
+++			phpbb.closeDarkenWrapper(5000);
+++		}
+++	});
+++
+++})(jQuery);
+++});
+++</script>
++\ No newline at end of file
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\stopforumspam/styles/BBOOTS/template/event/posting_editor_subject_before.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\stopforumspam/styles/BBOOTS/template/event/posting_editor_subject_before.html"
++new file mode 100644
++index 000000000..192084a6f
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\stopforumspam/styles/BBOOTS/template/event/posting_editor_subject_before.html"
++@@ -0,0 +1,6 @@
+++<!-- IF SFS -->
+++<div class="control-group">	
+++	<label class="control-label" for="email">{L_EMAIL_ADDRESS}{L_COLON}</label>
+++	<input type="email" tabindex="2" name="email" id="email" size="25" maxlength="100" value="{EMAIL}" class="form-control" title="{L_EMAIL_ADDRESS}" />
+++</div>	
+++<!-- ENDIF -->
++\ No newline at end of file
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\stopforumspam/styles/BBOOTS/template/event/ucp_pm_viewmessage_post_buttons_before.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\stopforumspam/styles/BBOOTS/template/event/ucp_pm_viewmessage_post_buttons_before.html"
++new file mode 100644
++index 000000000..e604e0a8e
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\stopforumspam/styles/BBOOTS/template/event/ucp_pm_viewmessage_post_buttons_before.html"
++@@ -0,0 +1,5 @@
+++{% if SFS_LINK %}
+++	<li id="sfs{{ MESSAGE_ID }}">
+++		{{ SFS_LINK }}
+++	</li>
+++{% endif %}
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\stopforumspam/styles/BBOOTS/template/event/viewtopic_body_post_buttons_list_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\stopforumspam/styles/BBOOTS/template/event/viewtopic_body_post_buttons_list_after.html"
++new file mode 100644
++index 000000000..daca14b7f
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\stopforumspam/styles/BBOOTS/template/event/viewtopic_body_post_buttons_list_after.html"
++@@ -0,0 +1,3 @@
+++<!-- IF postrow.SFS_LINK -->
+++	<li id="sfs{postrow.POST_ID}">{postrow.SFS_LINK}</li>
+++<!-- ENDIF -->
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\stopforumspam/styles/FLATBOOTS/template/event/overall_footer_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\stopforumspam/styles/FLATBOOTS/template/event/overall_footer_after.html"
++new file mode 100644
++index 000000000..8812ab7a4
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\stopforumspam/styles/FLATBOOTS/template/event/overall_footer_after.html"
++@@ -0,0 +1,16 @@
+++<script>
+++head.ready(function () {
+++(function($) {  // Avoid conflicts with other libraries
+++
+++'use strict';
+++	
+++	phpbb.addAjaxCallback('reporttosfs', function(data) {
+++		if (data.postid !== "undefined") {
+++			$('#sfs' + data.postid).hide();
+++			phpbb.closeDarkenWrapper(5000);
+++		}
+++	});
+++
+++})(jQuery);
+++});
+++</script>
++\ No newline at end of file
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\stopforumspam/styles/FLATBOOTS/template/event/posting_editor_subject_before.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\stopforumspam/styles/FLATBOOTS/template/event/posting_editor_subject_before.html"
++new file mode 100644
++index 000000000..d937eb793
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\stopforumspam/styles/FLATBOOTS/template/event/posting_editor_subject_before.html"
++@@ -0,0 +1,6 @@
+++{% if SFS %}
+++<div class="control-group">	
+++	<label class="control-label" for="email">{{ lang('EMAIL_ADDRESS') }}{{ lang('COLON') }}</label>
+++	<input type="email" tabindex="2" name="email" id="email" size="25" maxlength="100" value="{{ EMAIL }}" class="form-control" title="{{ lang('EMAIL_ADDRESS') }}" />
+++</div>	
+++{% endif %}
++\ No newline at end of file
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\stopforumspam/styles/FLATBOOTS/template/event/ucp_pm_viewmessage_post_buttons_before.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\stopforumspam/styles/FLATBOOTS/template/event/ucp_pm_viewmessage_post_buttons_before.html"
++new file mode 100644
++index 000000000..e604e0a8e
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\stopforumspam/styles/FLATBOOTS/template/event/ucp_pm_viewmessage_post_buttons_before.html"
++@@ -0,0 +1,5 @@
+++{% if SFS_LINK %}
+++	<li id="sfs{{ MESSAGE_ID }}">
+++		{{ SFS_LINK }}
+++	</li>
+++{% endif %}
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\stopforumspam/styles/FLATBOOTS/template/event/viewtopic_body_post_buttons_list_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\stopforumspam/styles/FLATBOOTS/template/event/viewtopic_body_post_buttons_list_after.html"
++new file mode 100644
++index 000000000..e0f89be3e
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\rmcgirr83\\stopforumspam/styles/FLATBOOTS/template/event/viewtopic_body_post_buttons_list_after.html"
++@@ -0,0 +1,9 @@
+++{% if postrow.SFS_LINK %}
+++	<li id="sfs{{ postrow.POST_ID }}">
+++		<a href="{{ postrow.SFS_LINK }}" title="{{ lang('REPORT_TO_SFS') }}" data-ajax="reporttosfs" class="button button-icon-only">
+++			<i class="fa fa-exchange" aria-hidden="true"></i>
+++			<span class="sr-only">{{ lang('BUTTON_SFS') }}</span>
+++		</a>
+++	</li>
+++{% endif %}
+++
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\stopforumspam/styles/scaffoldBB/template/event/posting_editor_subject_before.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\stopforumspam/styles/scaffoldBB/template/event/posting_editor_subject_before.html"
++deleted file mode 100644
++index fad37cfc1..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\rmcgirr83\\stopforumspam/styles/scaffoldBB/template/event/posting_editor_subject_before.html"
+++++ /dev/null
++@@ -1,6 +0,0 @@
++-{% if SFS %}
++-	<dl class="row gx-0 mb-1">
++-		<dt class="col-md-2 mb-
\ No newline at end of file
diff --git "[ORIGINAL]/rmcgirr83\\stopforumspam/event/main_listener.php" "[FORUM_EXT]/rmcgirr83\\stopforumspam/event/main_listener.php"
--- "[ORIGINAL]/rmcgirr83\\stopforumspam/event/main_listener.php"
+++ "[FORUM_EXT]/rmcgirr83\\stopforumspam/event/main_listener.php"
@@ -121,8 +121,6 @@ class main_listener implements EventSubscriberInterface
 			'core.ucp_pm_view_message'				=> 'ucp_pm_view_message',
 			// Custom events for integration with Contact Admin Extension
 			'rmcgirr83.contactadmin.modify_data_and_error'	=> 'user_sfs_validate_registration',
-			// phpBB default contact us page
-			'core.message_admin_form_submit_before'	=> 'message_admin_form_submit_before',
 		];
 	}
 
@@ -422,53 +420,6 @@ class main_listener implements EventSubscriberInterface
 		}
 	}
 
-	/*
-	* message_admin_form_submit_before
-	*
-	* @param	$event	the event object
-	* @return 	null
-	* @access	public
-	*/
-	public function message_admin_form_submit_before($event)
-	{
-		if ($this->config['allow_sfs'] == false)
-		{
-			return false;
-		}
-
-		$errors = $event['errors'];
-
-		// validate the user ip
-		$userip_error = $this->validate_ip($this->user->ip);
-		if ($userip_error)
-		{
-			$errors[] = $userip_error;
-		}
-
-		/* On registration and only when all errors have cleared
-		 * do not want the admin message area to fill up
-		*/
-		if (!sizeof($errors))
-		{
-			$check = $this->stopforumspam_check($this->request->variable('name', '', true), $this->user->ip, $this->request->variable('email', ''));
-
-			if ($check)
-			{
-				if ($this->config['sfs_down'] && $check === 'sfs_down')
-				{
-					return;
-				}
-				$errors[] = $this->show_message($check);
-				// now ban the spammer by IP
-				if (is_int($check) && $this->config['sfs_ban_ip'])
-				{
-					$this->sfsapi->sfs_ban('ip', $this->user->ip, (int) $check);
-				}
-			}
-		}
-		$event['errors'] = $errors;
-	}
-
 	/*
 	* show_message
 	* @param 	string	$check 		the type of check we are, uhmmm, checking
@@ -518,7 +469,6 @@ class main_listener implements EventSubscriberInterface
 
 		// Query the SFS database and pull the data into script
 		$json = $this->sfsapi->sfsapi('query', $username, $ip, $email);
-
 		$json_decode = json_decode($json, true);
 
 		// If there is a curl error as set in sfs_api, log the error
@@ -557,7 +507,7 @@ class main_listener implements EventSubscriberInterface
 			{
 				if ($sfs_log_message)
 				{
-					$this->log_message($username, $ip, 'LOG_SFS_MESSAGE', $email, $username_freq, $ip_freq, $email_freq);
+					$this->log_message('user', $username, $ip, 'LOG_SFS_MESSAGE', $email, $username_freq, $ip_freq, $email_freq);
 				}
 				//user is a spammer
 				return $spam_score;
@@ -573,11 +523,11 @@ class main_listener implements EventSubscriberInterface
 			{
 				if ($this->config['sfs_down'])
 				{
-					$this->log->add('admin', $username, $ip, 'LOG_SFS_DOWN_USER_ALLOWED', $email);
+					$this->log_message('admin', $username, $ip, 'LOG_SFS_DOWN_USER_ALLOWED', $email);
 				}
 				else
 				{
-					$this->log->add('admin', $username, $ip, 'LOG_SFS_DOWN', $email);
+					$this->log_message('admin', $username, $ip, 'LOG_SFS_DOWN', $email);
 				}
 			}
 			return 'sfs_down';
@@ -586,6 +536,7 @@ class main_listener implements EventSubscriberInterface
 
 	/*
 	* log_message	function used in this class to inject messages into the logs
+	* @param 	string	$mode 		the mode that we are doing for the log either admin or user
 	* @param	string	$username	the users name
 	* @param	string	$ip			the users ip
 	* @param	string	$message	the message we are injecting
@@ -593,13 +544,19 @@ class main_listener implements EventSubscriberInterface
 	* @return 	void
 	* @access	private
 	*/
-	private function log_message($username, $ip, $message, $email, $username_score = 0, $ip_score = 0, $email_score = 0)
+	private function log_message($mode, $username, $ip, $message, $email, $username_score = 0, $ip_score = 0, $email_score = 0)
 	{
 
 		$sfs_ip = $this->language->lang('SFS_IP_STOPPED', $ip);
 		$sfs_username = $this->language->lang('SFS_USERNAME_STOPPED', $username);
 		$sfs_email = $this->language->lang('SFS_EMAIL_STOPPED', $email);
 
+		if ($mode === 'admin')
+		{
+			$this->log->add('admin', $this->user->data['user_id'], $ip, $message, false, [$sfs_username, $sfs_ip, $sfs_email]);
+		}
+		else
+		{
 			if ($this->config['sfs_by_name'] == false)
 			{
 				$username_score = $this->language->lang('SFS_NOT_CHECKED');
@@ -614,16 +571,9 @@ class main_listener implements EventSubscriberInterface
 				$email_score = $this->language->lang('SFS_NOT_CHECKED');
 			}
 			else
-		{
-			if ($email_score == (int) 255)
-			{
-				$email_score = $this->language->lang('SFS_MARKED_TOXIC');
-			}
-			else
 			{
 				$email_score = $this->language->lang('SFS_FREQUENCY', $email_score);
 			}
-		}
 
 			if ($this->config['sfs_by_ip'] == false)
 			{
@@ -639,6 +589,7 @@ class main_listener implements EventSubscriberInterface
 
 			$this->log->add('user', $this->user->data['user_id'], $ip, $message, false, ['reportee_id' => $this->user->data['user_id'], $sfs_username, $sfs_ip, $sfs_email]);
 		}
+	}
 
 	/*
 	* validate_email	function used in this class to validate a guest posters email address
@@ -648,7 +599,7 @@ class main_listener implements EventSubscriberInterface
 	*/
 	private function validate_email($email)
 	{
-		$error = validate_user_email($email);
+		$error = phpbb_validate_email($email);
 
 		return $error;
 	}
diff --git "[ORIGINAL]/rmcgirr83\\stopforumspam/ext.php" "[FORUM_EXT]/rmcgirr83\\stopforumspam/ext.php"
--- "[ORIGINAL]/rmcgirr83\\stopforumspam/ext.php"
+++ "[FORUM_EXT]/rmcgirr83\\stopforumspam/ext.php"
@@ -19,6 +19,7 @@ class ext extends \phpbb\extension\base
 {
 	/** @var string Require phpBB 3.3.0 */
 	const PHPBB_MIN_VERSION = '3.3.0';
+
 	/**
 	* Enable extension if phpBB version requirement is met
 	*
diff --git "[ORIGINAL]/rmcgirr83\\stopforumspam/language/en/stopforumspam.php" "[FORUM_EXT]/rmcgirr83\\stopforumspam/language/en/stopforumspam.php"
--- "[ORIGINAL]/rmcgirr83\\stopforumspam/language/en/stopforumspam.php"
+++ "[FORUM_EXT]/rmcgirr83\\stopforumspam/language/en/stopforumspam.php"
@@ -46,6 +46,9 @@ $lang = array_merge($lang, [
 	'PM_NOT_EXIST'	=> 'PM doesn’t exist',
 	'SFS_ANONYMIZED_IP'	=> 'The IP of the user has been anonymized, set to 127.0.0.1, probably due to an extension.',
 	'SFS_MISSING_DATA'	=> 'Not all information is provided to report to Stop Forum Spam.',
+	'SFS_IP_STOPPED'	=> '<a target="_blank" title="Check IP at StopForumSpam.com (opens in a new window)" href="http://www.stopforumspam.com/ipcheck/%1$s" rel="noreferrer noopener">%1$s</a>',
+	'SFS_USERNAME_STOPPED'	=> '<a target="_blank" title="Check Username at StopForumSpam.com (opens in a new window)" href="http://www.stopforumspam.com/search/?q=%1$s" rel="noreferrer noopener">%1$s</a>',
+	'SFS_EMAIL_STOPPED'	=> '<a target="_blank" title="Check Email at StopForumSpam.com (opens in a new window)" href="http://www.stopforumspam.com/search/?q=%1$s" rel="noreferrer noopener">%1$s</a>',
 	'SFS_FREQUENCY'	=> ' » found in sfs database %d times',
 	'SFS_IP_STOPPED'	=> '<a target="_blank" title="Check IP at StopForumSpam.com (opens in a new window)" href="http://www.stopforumspam.com/ipcheck/%1$s" rel="noreferrer noopener">%1$s</a>',
 	'SFS_USERNAME_STOPPED'	=> '<a target="_blank" title="Check Username at StopForumSpam.com (opens in a new window)" href="http://www.stopforumspam.com/search/?q=%1$s" rel="noreferrer noopener">%1$s</a>',
@@ -55,7 +58,6 @@ $lang = array_merge($lang, [
 		1 => 'Found in the Stop Forum Spam database once',
 		2 => 'Found in the Stop Forum Spam database %d times',
 	],
-	'SFS_MARKED_TOXIC'	=> ' » Email domain marked as TOXIC',
 	'SFS_USER_BANNED'	=> 'Banned due to a post on the forum',
 	'SFS_REPORTED'		=> 'Post has already been reported',
 	'SFS_PM_REPORTED'	=> 'PM has already been reported',
diff --git "[FORUM_EXT]/rmcgirr83\\stopforumspam/styles/BBOOTS/template/event/overall_footer_after.html" "[FORUM_EXT]/rmcgirr83\\stopforumspam/styles/BBOOTS/template/event/overall_footer_after.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/rmcgirr83\\stopforumspam/styles/BBOOTS/template/event/overall_footer_after.html"
@@ -0,0 +1,16 @@
+<script>
+head.ready(function () {
+(function($) {  // Avoid conflicts with other libraries
+
+'use strict';
+	
+	phpbb.addAjaxCallback('reporttosfs', function(data) {
+		if (data.postid !== "undefined") {
+			$('#sfs' + data.postid).hide();
+			phpbb.closeDarkenWrapper(5000);
+		}
+	});
+
+})(jQuery);
+});
+</script>
\ No newline at end of file
diff --git "[FORUM_EXT]/rmcgirr83\\stopforumspam/styles/BBOOTS/template/event/posting_editor_subject_before.html" "[FORUM_EXT]/rmcgirr83\\stopforumspam/styles/BBOOTS/template/event/posting_editor_subject_before.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/rmcgirr83\\stopforumspam/styles/BBOOTS/template/event/posting_editor_subject_before.html"
@@ -0,0 +1,6 @@
+<!-- IF SFS -->
+<div class="control-group">	
+	<label class="control-label" for="email">{L_EMAIL_ADDRESS}{L_COLON}</label>
+	<input type="email" tabindex="2" name="email" id="email" size="25" maxlength="100" value="{EMAIL}" class="form-control" title="{L_EMAIL_ADDRESS}" />
+</div>	
+<!-- ENDIF -->
\ No newline at end of file
diff --git "[FORUM_EXT]/rmcgirr83\\stopforumspam/styles/BBOOTS/template/event/ucp_pm_viewmessage_post_buttons_before.html" "[FORUM_EXT]/rmcgirr83\\stopforumspam/styles/BBOOTS/template/event/ucp_pm_viewmessage_post_buttons_before.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/rmcgirr83\\stopforumspam/styles/BBOOTS/template/event/ucp_pm_viewmessage_post_buttons_before.html"
@@ -0,0 +1,5 @@
+{% if SFS_LINK %}
+	<li id="sfs{{ MESSAGE_ID }}">
+		{{ SFS_LINK }}
+	</li>
+{% endif %}
diff --git "[FORUM_EXT]/rmcgirr83\\stopforumspam/styles/BBOOTS/template/event/viewtopic_body_post_buttons_list_after.html" "[FORUM_EXT]/rmcgirr83\\stopforumspam/styles/BBOOTS/template/event/viewtopic_body_post_buttons_list_after.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/rmcgirr83\\stopforumspam/styles/BBOOTS/template/event/viewtopic_body_post_buttons_list_after.html"
@@ -0,0 +1,3 @@
+<!-- IF postrow.SFS_LINK -->
+	<li id="sfs{postrow.POST_ID}">{postrow.SFS_LINK}</li>
+<!-- ENDIF -->
diff --git "[FORUM_EXT]/rmcgirr83\\stopforumspam/styles/FLATBOOTS/template/event/overall_footer_after.html" "[FORUM_EXT]/rmcgirr83\\stopforumspam/styles/FLATBOOTS/template/event/overall_footer_after.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/rmcgirr83\\stopforumspam/styles/FLATBOOTS/template/event/overall_footer_after.html"
@@ -0,0 +1,16 @@
+<script>
+head.ready(function () {
+(function($) {  // Avoid conflicts with other libraries
+
+'use strict';
+	
+	phpbb.addAjaxCallback('reporttosfs', function(data) {
+		if (data.postid !== "undefined") {
+			$('#sfs' + data.postid).hide();
+			phpbb.closeDarkenWrapper(5000);
+		}
+	});
+
+})(jQuery);
+});
+</script>
\ No newline at end of file
diff --git "[FORUM_EXT]/rmcgirr83\\stopforumspam/styles/FLATBOOTS/template/event/posting_editor_subject_before.html" "[FORUM_EXT]/rmcgirr83\\stopforumspam/styles/FLATBOOTS/template/event/posting_editor_subject_before.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/rmcgirr83\\stopforumspam/styles/FLATBOOTS/template/event/posting_editor_subject_before.html"
@@ -0,0 +1,6 @@
+{% if SFS %}
+<div class="control-group">	
+	<label class="control-label" for="email">{{ lang('EMAIL_ADDRESS') }}{{ lang('COLON') }}</label>
+	<input type="email" tabindex="2" name="email" id="email" size="25" maxlength="100" value="{{ EMAIL }}" class="form-control" title="{{ lang('EMAIL_ADDRESS') }}" />
+</div>	
+{% endif %}
\ No newline at end of file
diff --git "[FORUM_EXT]/rmcgirr83\\stopforumspam/styles/FLATBOOTS/template/event/ucp_pm_viewmessage_post_buttons_before.html" "[FORUM_EXT]/rmcgirr83\\stopforumspam/styles/FLATBOOTS/template/event/ucp_pm_viewmessage_post_buttons_before.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/rmcgirr83\\stopforumspam/styles/FLATBOOTS/template/event/ucp_pm_viewmessage_post_buttons_before.html"
@@ -0,0 +1,5 @@
+{% if SFS_LINK %}
+	<li id="sfs{{ MESSAGE_ID }}">
+		{{ SFS_LINK }}
+	</li>
+{% endif %}
diff --git "[FORUM_EXT]/rmcgirr83\\stopforumspam/styles/FLATBOOTS/template/event/viewtopic_body_post_buttons_list_after.html" "[FORUM_EXT]/rmcgirr83\\stopforumspam/styles/FLATBOOTS/template/event/viewtopic_body_post_buttons_list_after.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/rmcgirr83\\stopforumspam/styles/FLATBOOTS/template/event/viewtopic_body_post_buttons_list_after.html"
@@ -0,0 +1,9 @@
+{% if postrow.SFS_LINK %}
+	<li id="sfs{{ postrow.POST_ID }}">
+		<a href="{{ postrow.SFS_LINK }}" title="{{ lang('REPORT_TO_SFS') }}" data-ajax="reporttosfs" class="button button-icon-only">
+			<i class="fa fa-exchange" aria-hidden="true"></i>
+			<span class="sr-only">{{ lang('BUTTON_SFS') }}</span>
+		</a>
+	</li>
+{% endif %}
+
diff --git "[ORIGINAL]/rmcgirr83\\stopforumspam/styles/scaffoldBB/template/event/posting_editor_subject_before.html" "[ORIGINAL]/rmcgirr83\\stopforumspam/styles/scaffoldBB/template/event/posting_editor_subject_before.html"
deleted file mode 100644
--- "[ORIGINAL]/rmcgirr83\\stopforumspam/styles/scaffoldBB/template/event/posting_editor_subject_before.html"
+++ /dev/null
@@ -1,6 +0,0 @@
-{% if SFS %}
-	<dl class="row gx-0 mb-1">
-		<dt class="col-md-2 mb-1"><label for="email">{{ lang('EMAIL_ADDRESS') }}{{ lang('COLON') }}</label></dt>
-		<dd class="col-md-auto mb-1"><input type="email" tabindex="2" name="email" id="email" size="25" maxlength="100" value="{{ EMAIL }}" class="inputbox autowidth form-control form-control-sm" title="{{ lang('EMAIL_ADDRESS') }}" /></dd>
-	</dl>
-{% endif %}
\ No newline at end of file
diff --git "[ORIGINAL]/rmcgirr83\\stopforumspam/styles/scaffoldBB/template/event/ucp_pm_viewmessage_post_buttons_before.html" "[ORIGINAL]/rmcgirr83\\stopforumspam/styles/scaffoldBB/template/event/ucp_pm_viewmessage_post_buttons_before.html"
deleted file mode 100644
--- "[ORIGINAL]/rmcgirr83\\stopforumspam/styles/scaffoldBB/template/event/ucp_pm_viewmessage_post_buttons_before.html"
+++ /dev/null
@@ -1,5 +0,0 @@
-{% if S_SFS %}
-	<li id="sfs{{ MESSAGE_ID }}">
-		<a href="{{ U_SFS }}" title="{{ lang('REPORT_TO_SFS') }}" data-ajax="reporttosfs" class="bg-gradient btn btn-secondary btn-sm button button-icon-only rounded-3"><i class="icon fa fa-exchange fa-fw" aria-hidden="true"></i><span class="visually-hidden">{{ lang('REPORT_TO_SFS') }}</span></a>
-	</li>
-{% endif %}
diff --git "[ORIGINAL]/rmcgirr83\\stopforumspam/styles/scaffoldBB/template/event/viewtopic_body_post_buttons_before.html" "[ORIGINAL]/rmcgirr83\\stopforumspam/styles/scaffoldBB/template/event/viewtopic_body_post_buttons_before.html"
deleted file mode 100644
--- "[ORIGINAL]/rmcgirr83\\stopforumspam/styles/scaffoldBB/template/event/viewtopic_body_post_buttons_before.html"
+++ /dev/null
@@ -1,8 +0,0 @@
-{% if postrow.S_SFS %}
-	<li id="sfs{{ postrow.POST_ID }}">
-		<a href="{{ postrow.U_SFS }}" title="{{ lang('REPORT_TO_SFS') }}" data-ajax="reporttosfs" class="bg-gradient btn-secondary btn btn-sm button button-icon-only rounded-3 shadow-sm">
-			<i class="icon fa fa-exchange fa-fw" aria-hidden="true"></i>
-			<span class="visually-hidden">{{ lang('BUTTON_SFS') }}</span>
-		</a>
-	</li>
-{% endif %}
```
