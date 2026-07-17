Existem diferencas reais no codigo ou texto. Diferencas de formatacao (espacos, tabs) foram ignoradas abaixo.

```diff
diff --git "[ORIGINAL]/sitesplat\\newsletter/acp/newsletter_module.php" "[FORUM_EXT]/sitesplat\\newsletter/acp/newsletter_module.php"
--- "[ORIGINAL]/sitesplat\\newsletter/acp/newsletter_module.php"
+++ "[FORUM_EXT]/sitesplat\\newsletter/acp/newsletter_module.php"
@@ -187,21 +187,12 @@ class newsletter_module
 					));
 				}
 
-				$sql = 'SELECT forum_id, forum_name FROM ' . FORUMS_TABLE . ' WHERE forum_type = 1 ORDER BY forum_name';
-				$result = $this->db->sql_query($sql);
 				$forum_ary = json_decode($this->config['newsletter_forums'], true);
-				while ($row = $this->db->sql_fetchrow($result))
-				{
-					$template->assign_block_vars('forumrows', array(
-						'ID'			=> $row['forum_id'],
-						'FORUMNAME'		=> $row['forum_name'],
-						'SELECTED'		=> (in_array($row['forum_id'], $forum_ary)) ? ' selected="selected"' : '',
-					));
-				}
-				$this->db->sql_freeresult($result);
+				$forum_list = make_forum_select($forum_ary, false, true, true);
 
 				$enable_html = $phpbb_container->get('ext.manager')->is_enabled('forumhulp/htmlemail');
 				$template->assign_vars(array(
+					'S_FORUM_LIST'			=> $forum_list,
 					'WARNING_MSG'			=> (sizeof($error)) ? implode('<br />', $error) : '',
 					'U_ACTION'				=> $this->u_action,
 					'S_GROUP_OPTIONS'		=> $select_list,
diff --git "[ORIGINAL]/sitesplat\\newsletter/adm/style/acp_newsletter.html" "[FORUM_EXT]/sitesplat\\newsletter/adm/style/acp_newsletter.html"
--- "[ORIGINAL]/sitesplat\\newsletter/adm/style/acp_newsletter.html"
+++ "[FORUM_EXT]/sitesplat\\newsletter/adm/style/acp_newsletter.html"
@@ -53,9 +53,7 @@
 		 <dl>
             <dt><label for="priority">{L_FORUMS_NEWS_FROM}{L_COLON}</label><br /><span>{L_FORUMS_FROM_EXPLAIN}</span></dt>
             <dd><select size="1" id="forums" name="newsletter_forums[]" multiple style="max-width:200px;max-height:160px;height:160px;">
-            <!-- BEGIN forumrows -->
-            <option value="{forumrows.ID}"{forumrows.SELECTED}>{forumrows.FORUMNAME}</option>
-            <!-- END forumrows -->
+            {S_FORUM_LIST}
             </select></dd>
         </dl>
         <dl>
diff --git "[ORIGINAL]/sitesplat\\newsletter/controller/main_controller.php" "[FORUM_EXT]/sitesplat\\newsletter/controller/main_controller.php"
--- "[ORIGINAL]/sitesplat\\newsletter/controller/main_controller.php"
+++ "[FORUM_EXT]/sitesplat\\newsletter/controller/main_controller.php"
@@ -102,7 +102,7 @@ class main_controller
 					$sql = 'UPDATE ' . USERS_TABLE . ' SET user_allow_massemail = 1 WHERE user_id = ' . $this->user->data['user_id'];
 					$this->db->sql_query($sql);
 
-					$this->template->assign_vars(array('REGISTER' => true, 'BEDANKT' => $this->user->lang['SUBSCRIBED']));
+					$this->template->assign_vars(array('REGISTER' => true, 'THANKS' => $this->user->lang['SUBSCRIBED']));
 				} else
 				{
 					$sql = 'SELECT user_id, user_password FROM ' . USERS_TABLE . $emtype;
@@ -121,10 +121,10 @@ class main_controller
 								$sql = 'UPDATE ' . USERS_TABLE . ' SET user_allow_massemail = 1 WHERE user_id = ' . $userid;
 								$this->db->sql_query($sql);
 
-								$this->template->assign_vars(array('REGISTER' => true, 'BEDANKT' => $this->user->lang['SUBSCRIBED']));
+								$this->template->assign_vars(array('REGISTER' => true, 'THANKS' => $this->user->lang['SUBSCRIBED']));
 							} else
 							{
-								$this->template->assign_vars(array('REGISTER' => true, 'BEDANKT' => $this->user->lang['LOGIN_ERROR_PASSWORD']));
+								$this->template->assign_vars(array('REGISTER' => true, 'THANKS' => $this->user->lang['LOGIN_ERROR_PASSWORD']));
 							}
 						} else
 						{
@@ -186,13 +186,13 @@ class main_controller
 
 								// Replace "error" strings with their real, localised form
 								$error = array_map(array($this->user, 'lang'), $error);
-								$this->template->assign_vars(array('REGISTER' => true, 'BEDANKT' => implode('<br />', $error) ));
+								$this->template->assign_vars(array('REGISTER' => true, 'THANKS' => implode('<br />', $error) ));
 							} else
 							{
 								$user_id = user_add($data);
 								$result = $this->auth->login($uname, $pass);
 
-								$this->template->assign_vars(array('REGISTER' => true, 'BEDANKT' => $this->user->lang['SUBSCRIBED']));
+								$this->template->assign_vars(array('REGISTER' => true, 'THANKS' => $this->user->lang['SUBSCRIBED']));
 							}
 						} else
 						{
@@ -212,7 +212,7 @@ class main_controller
 					$sql = 'UPDATE ' . USERS_TABLE . ' SET user_allow_massemail = 0 WHERE user_id = ' . $this->user->data['user_id'];
 					$this->db->sql_query($sql);
 
-					$this->template->assign_vars(array('REGISTER' => true, 'BEDANKT' => $this->user->lang['UNSUBSCRIBED']));
+					$this->template->assign_vars(array('REGISTER' => true, 'THANKS' => $this->user->lang['UNSUBSCRIBED']));
 				} else
 				{
 					$sql = 'SELECT user_id, username, user_password
@@ -232,10 +232,10 @@ class main_controller
 								$sql = 'UPDATE ' . USERS_TABLE . ' SET user_allow_massemail = 0 WHERE user_id = ' . $userid;
 								$this->db->sql_query($sql);
 
-								$this->template->assign_vars(array('REGISTER' => true, 'BEDANKT' => $this->user->lang['UNSUBSCRIBED']));
+								$this->template->assign_vars(array('REGISTER' => true, 'THANKS' => $this->user->lang['UNSUBSCRIBED']));
 							} else
 							{
-								$this->template->assign_vars(array('REGISTER' => true, 'BEDANKT' => $this->user->lang['LOGIN_ERROR_PASSWORD']));
+								$this->template->assign_vars(array('REGISTER' => true, 'THANKS' => $this->user->lang['LOGIN_ERROR_PASSWORD']));
 							}
 						} else
 						{
@@ -364,15 +364,15 @@ class main_controller
 			$archive_rows = array();
 			foreach ($season as $key => $a)
 			{
-				$sql = 'SELECT id, subject, time as datum FROM ' . $this->newsletter_table . '
-						WHERE display_it = 1 AND time BETWEEN ' . $a['datebegin'] . ' AND ' . $a['dateend'] . ' ORDER BY datum DESC';
+				$sql = 'SELECT id, subject, time as dates FROM ' . $this->newsletter_table . '
+						WHERE display_it = 1 AND time BETWEEN ' . $a['datebegin'] . ' AND ' . $a['dateend'] . ' ORDER BY dates DESC';
 				$result = $this->db->sql_query($sql);
 				while ($row = $this->db->sql_fetchrow($result))
 				{
 					if ($key != $last_mon)
 					{
 						$archive_row = array(
-							'ARCHIVE'	=> $this->user->format_date($row['datum'], 'Y'),
+							'ARCHIVE'	=> $this->user->format_date($row['dates'], 'Y'),
 							'monthrow'	=> array(),
 						);
 						$archive_rows[] = $archive_row;
@@ -381,7 +381,7 @@ class main_controller
 					$archive_row_month = array(
 						'TITLE'			=> $row['subject'],
 						'U_VIEW'		=> $row['id'],
-						'DATE'			=> $this->user->format_date($row['datum'], 'j F Y'),
+						'DATE'			=> $this->user->format_date($row['dates'], 'j F Y'),
 					);
 
 					$archive_rows[sizeof($archive_rows) - 1]['monthrow'][] = $archive_row_month;
@@ -410,13 +410,13 @@ class main_controller
 
 	protected function season($time)
 	{
-		$sql = 'SELECT DISTINCT FROM_UNIXTIME(time, "%Y") AS jaar FROM ' . $this->newsletter_table . ' WHERE display_it = 1 ORDER BY jaar DESC';
+		$sql = 'SELECT DISTINCT FROM_UNIXTIME(time, "%Y") AS years FROM ' . $this->newsletter_table . ' WHERE display_it = 1 ORDER BY years DESC';
 		$result = $this->db->sql_query($sql);
 		$i = 1;
 		$season = array();
 		while ($row = $this->db->sql_fetchrow($result))
 		{
-			$season[$i] = array('datebegin' => strtotime($row['jaar'] . '-01-01 00:00:01'), 'dateend' => strtotime($row['jaar'] . '-12-31 23:59:59'));
+			$season[$i] = array('datebegin' => strtotime($row['years'] . '-01-01 00:00:01'), 'dateend' => strtotime($row['years'] . '-12-31 23:59:59'));
 			$i++;
 		}
 		$result = array();
diff --git "[FORUM_EXT]/sitesplat\\newsletter/diff_full.tmp" "[FORUM_EXT]/sitesplat\\newsletter/diff_full.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\newsletter/diff_full.tmp"
@@ -0,0 +1,3964 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\newsletter/acp/newsletter_module.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/acp/newsletter_module.php"
+index 4d91cc708..bc694dc33 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\newsletter/acp/newsletter_module.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/acp/newsletter_module.php"
+@@ -186,22 +186,13 @@ class newsletter_module
+ 						'LANG'			=> $row['lang_local_name']
+ 					));
+ 				}
+-		
+-				$sql = 'SELECT forum_id, forum_name FROM ' . FORUMS_TABLE . ' WHERE forum_type = 1 ORDER BY forum_name';
+-				$result = $this->db->sql_query($sql);
++
+ 				$forum_ary = json_decode($this->config['newsletter_forums'], true);
+-				while ($row = $this->db->sql_fetchrow($result))
+-				{
+-					$template->assign_block_vars('forumrows', array(
+-						'ID'			=> $row['forum_id'],
+-						'FORUMNAME'		=> $row['forum_name'],
+-						'SELECTED'		=> (in_array($row['forum_id'], $forum_ary)) ? ' selected="selected"' : '',
+-					));
+-				}
+-				$this->db->sql_freeresult($result);
+-		
++				$forum_list = make_forum_select($forum_ary, false, true, true);
++
+ 				$enable_html = $phpbb_container->get('ext.manager')->is_enabled('forumhulp/htmlemail');
+ 				$template->assign_vars(array(
++					'S_FORUM_LIST'			=> $forum_list,
+ 					'WARNING_MSG'			=> (sizeof($error)) ? implode('<br />', $error) : '',
+ 					'U_ACTION'				=> $this->u_action,
+ 					'S_GROUP_OPTIONS'		=> $select_list,
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\newsletter/adm/style/acp_newsletter.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/adm/style/acp_newsletter.html"
+index c2a94d65c..89e58f775 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\newsletter/adm/style/acp_newsletter.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/adm/style/acp_newsletter.html"
+@@ -53,9 +53,7 @@
+ 		 <dl>
+             <dt><label for="priority">{L_FORUMS_NEWS_FROM}{L_COLON}</label><br /><span>{L_FORUMS_FROM_EXPLAIN}</span></dt>
+             <dd><select size="1" id="forums" name="newsletter_forums[]" multiple style="max-width:200px;max-height:160px;height:160px;">
+-            <!-- BEGIN forumrows -->
+-            <option value="{forumrows.ID}"{forumrows.SELECTED}>{forumrows.FORUMNAME}</option>
+-            <!-- END forumrows -->
++            {S_FORUM_LIST}
+             </select></dd>
+         </dl>
+         <dl>
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\newsletter/controller/main_controller.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/controller/main_controller.php"
+index ef6fa0976..843f7ad46 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\newsletter/controller/main_controller.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/controller/main_controller.php"
+@@ -102,7 +102,7 @@ class main_controller
+ 					$sql = 'UPDATE ' . USERS_TABLE . ' SET user_allow_massemail = 1 WHERE user_id = ' . $this->user->data['user_id'];
+ 					$this->db->sql_query($sql);
+ 
+-					$this->template->assign_vars(array('REGISTER' => true, 'BEDANKT' => $this->user->lang['SUBSCRIBED']));
++					$this->template->assign_vars(array('REGISTER' => true, 'THANKS' => $this->user->lang['SUBSCRIBED']));
+ 				} else
+ 				{
+ 					$sql = 'SELECT user_id, user_password FROM ' . USERS_TABLE . $emtype;
+@@ -121,10 +121,10 @@ class main_controller
+ 								$sql = 'UPDATE ' . USERS_TABLE . ' SET user_allow_massemail = 1 WHERE user_id = ' . $userid;
+ 								$this->db->sql_query($sql);
+ 
+-								$this->template->assign_vars(array('REGISTER' => true, 'BEDANKT' => $this->user->lang['SUBSCRIBED']));
++								$this->template->assign_vars(array('REGISTER' => true, 'THANKS' => $this->user->lang['SUBSCRIBED']));
+ 							} else
+ 							{
+-								$this->template->assign_vars(array('REGISTER' => true, 'BEDANKT' => $this->user->lang['LOGIN_ERROR_PASSWORD']));
++								$this->template->assign_vars(array('REGISTER' => true, 'THANKS' => $this->user->lang['LOGIN_ERROR_PASSWORD']));
+ 							}
+ 						} else
+ 						{
+@@ -186,13 +186,13 @@ class main_controller
+ 
+ 								// Replace "error" strings with their real, localised form
+ 								$error = array_map(array($this->user, 'lang'), $error);
+-								$this->template->assign_vars(array('REGISTER' => true, 'BEDANKT' => implode('<br />', $error) ));
++								$this->template->assign_vars(array('REGISTER' => true, 'THANKS' => implode('<br />', $error) ));
+ 							} else
+ 							{
+ 								$user_id = user_add($data);
+ 								$result = $this->auth->login($uname, $pass);
+ 
+-								$this->template->assign_vars(array('REGISTER' => true, 'BEDANKT' => $this->user->lang['SUBSCRIBED']));
++								$this->template->assign_vars(array('REGISTER' => true, 'THANKS' => $this->user->lang['SUBSCRIBED']));
+ 							}
+ 						} else
+ 						{
+@@ -212,7 +212,7 @@ class main_controller
+ 					$sql = 'UPDATE ' . USERS_TABLE . ' SET user_allow_massemail = 0 WHERE user_id = ' . $this->user->data['user_id'];
+ 					$this->db->sql_query($sql);
+ 
+-					$this->template->assign_vars(array('REGISTER' => true, 'BEDANKT' => $this->user->lang['UNSUBSCRIBED']));
++					$this->template->assign_vars(array('REGISTER' => true, 'THANKS' => $this->user->lang['UNSUBSCRIBED']));
+ 				} else
+ 				{
+ 					$sql = 'SELECT user_id, username, user_password
+@@ -232,10 +232,10 @@ class main_controller
+ 								$sql = 'UPDATE ' . USERS_TABLE . ' SET user_allow_massemail = 0 WHERE user_id = ' . $userid;
+ 								$this->db->sql_query($sql);
+ 
+-								$this->template->assign_vars(array('REGISTER' => true, 'BEDANKT' => $this->user->lang['UNSUBSCRIBED']));
++								$this->template->assign_vars(array('REGISTER' => true, 'THANKS' => $this->user->lang['UNSUBSCRIBED']));
+ 							} else
+ 							{
+-								$this->template->assign_vars(array('REGISTER' => true, 'BEDANKT' => $this->user->lang['LOGIN_ERROR_PASSWORD']));
++								$this->template->assign_vars(array('REGISTER' => true, 'THANKS' => $this->user->lang['LOGIN_ERROR_PASSWORD']));
+ 							}
+ 						} else
+ 						{
+@@ -364,15 +364,15 @@ class main_controller
+ 			$archive_rows = array();
+ 			foreach ($season as $key => $a)
+ 			{
+-				$sql = 'SELECT id, subject, time as datum FROM ' . $this->newsletter_table . '
+-						WHERE display_it = 1 AND time BETWEEN ' . $a['datebegin'] . ' AND ' . $a['dateend'] . ' ORDER BY datum DESC';
++				$sql = 'SELECT id, subject, time as dates FROM ' . $this->newsletter_table . '
++						WHERE display_it = 1 AND time BETWEEN ' . $a['datebegin'] . ' AND ' . $a['dateend'] . ' ORDER BY dates DESC';
+ 				$result = $this->db->sql_query($sql);
+ 				while ($row = $this->db->sql_fetchrow($result))
+ 				{
+ 					if ($key != $last_mon)
+ 					{
+ 						$archive_row = array(
+-							'ARCHIVE'	=> $this->user->format_date($row['datum'], 'Y'),
++							'ARCHIVE'	=> $this->user->format_date($row['dates'], 'Y'),
+ 							'monthrow'	=> array(),
+ 						);
+ 						$archive_rows[] = $archive_row;
+@@ -381,7 +381,7 @@ class main_controller
+ 					$archive_row_month = array(
+ 						'TITLE'			=> $row['subject'],
+ 						'U_VIEW'		=> $row['id'],
+-						'DATE'			=> $this->user->format_date($row['datum'], 'j F Y'),
++						'DATE'			=> $this->user->format_date($row['dates'], 'j F Y'),
+ 					);
+ 
+ 					$archive_rows[sizeof($archive_rows) - 1]['monthrow'][] = $archive_row_month;
+@@ -410,13 +410,13 @@ class main_controller
+ 
+ 	protected function season($time)
+ 	{
+-		$sql = 'SELECT DISTINCT FROM_UNIXTIME(time, "%Y") AS jaar FROM ' . $this->newsletter_table . ' WHERE display_it = 1 ORDER BY jaar DESC';
++		$sql = 'SELECT DISTINCT FROM_UNIXTIME(time, "%Y") AS years FROM ' . $this->newsletter_table . ' WHERE display_it = 1 ORDER BY years DESC';
+ 		$result = $this->db->sql_query($sql);
+ 		$i = 1;
+ 		$season = array();
+ 		while ($row = $this->db->sql_fetchrow($result))
+ 		{
+-			$season[$i] = array('datebegin' => strtotime($row['jaar'] . '-01-01 00:00:01'), 'dateend' => strtotime($row['jaar'] . '-12-31 23:59:59'));
++			$season[$i] = array('datebegin' => strtotime($row['years'] . '-01-01 00:00:01'), 'dateend' => strtotime($row['years'] . '-12-31 23:59:59'));
+ 			$i++;
+ 		}
+ 		$result = array();
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/diff_full.tmp"
+new file mode 100644
+index 000000000..081bef4ca
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/diff_full.tmp"
+@@ -0,0 +1,149 @@
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\newsletter/acp/newsletter_module.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/acp/newsletter_module.php"
++index 4d91cc708..bc694dc33 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\newsletter/acp/newsletter_module.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/acp/newsletter_module.php"
++@@ -186,22 +186,13 @@ class newsletter_module
++ 						'LANG'			=> $row['lang_local_name']
++ 					));
++ 				}
++-		
++-				$sql = 'SELECT forum_id, forum_name FROM ' . FORUMS_TABLE . ' WHERE forum_type = 1 ORDER BY forum_name';
++-				$result = $this->db->sql_query($sql);
+++
++ 				$forum_ary = json_decode($this->config['newsletter_forums'], true);
++-				while ($row = $this->db->sql_fetchrow($result))
++-				{
++-					$template->assign_block_vars('forumrows', array(
++-						'ID'			=> $row['forum_id'],
++-						'FORUMNAME'		=> $row['forum_name'],
++-						'SELECTED'		=> (in_array($row['forum_id'], $forum_ary)) ? ' selected="selected"' : '',
++-					));
++-				}
++-				$this->db->sql_freeresult($result);
++-		
+++				$forum_list = make_forum_select($forum_ary, false, true, true);
+++
++ 				$enable_html = $phpbb_container->get('ext.manager')->is_enabled('forumhulp/htmlemail');
++ 				$template->assign_vars(array(
+++					'S_FORUM_LIST'			=> $forum_list,
++ 					'WARNING_MSG'			=> (sizeof($error)) ? implode('<br />', $error) : '',
++ 					'U_ACTION'				=> $this->u_action,
++ 					'S_GROUP_OPTIONS'		=> $select_list,
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\newsletter/adm/style/acp_newsletter.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/adm/style/acp_newsletter.html"
++index c2a94d65c..89e58f775 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\newsletter/adm/style/acp_newsletter.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/adm/style/acp_newsletter.html"
++@@ -53,9 +53,7 @@
++ 		 <dl>
++             <dt><label for="priority">{L_FORUMS_NEWS_FROM}{L_COLON}</label><br /><span>{L_FORUMS_FROM_EXPLAIN}</span></dt>
++             <dd><select size="1" id="forums" name="newsletter_forums[]" multiple style="max-width:200px;max-height:160px;height:160px;">
++-            <!-- BEGIN forumrows -->
++-            <option value="{forumrows.ID}"{forumrows.SELECTED}>{forumrows.FORUMNAME}</option>
++-            <!-- END forumrows -->
+++            {S_FORUM_LIST}
++             </select></dd>
++         </dl>
++         <dl>
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\newsletter/controller/main_controller.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/controller/main_controller.php"
++index ef6fa0976..843f7ad46 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\newsletter/controller/main_controller.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/controller/main_controller.php"
++@@ -102,7 +102,7 @@ class main_controller
++ 					$sql = 'UPDATE ' . USERS_TABLE . ' SET user_allow_massemail = 1 WHERE user_id = ' . $this->user->data['user_id'];
++ 					$this->db->sql_query($sql);
++ 
++-					$this->template->assign_vars(array('REGISTER' => true, 'BEDANKT' => $this->user->lang['SUBSCRIBED']));
+++					$this->template->assign_vars(array('REGISTER' => true, 'THANKS' => $this->user->lang['SUBSCRIBED']));
++ 				} else
++ 				{
++ 					$sql = 'SELECT user_id, user_password FROM ' . USERS_TABLE . $emtype;
++@@ -121,10 +121,10 @@ class main_controller
++ 								$sql = 'UPDATE ' . USERS_TABLE . ' SET user_allow_massemail = 1 WHERE user_id = ' . $userid;
++ 								$this->db->sql_query($sql);
++ 
++-								$this->template->assign_vars(array('REGISTER' => true, 'BEDANKT' => $this->user->lang['SUBSCRIBED']));
+++								$this->template->assign_vars(array('REGISTER' => true, 'THANKS' => $this->user->lang['SUBSCRIBED']));
++ 							} else
++ 							{
++-								$this->template->assign_vars(array('REGISTER' => true, 'BEDANKT' => $this->user->lang['LOGIN_ERROR_PASSWORD']));
+++								$this->template->assign_vars(array('REGISTER' => true, 'THANKS' => $this->user->lang['LOGIN_ERROR_PASSWORD']));
++ 							}
++ 						} else
++ 						{
++@@ -186,13 +186,13 @@ class main_controller
++ 
++ 								// Replace "error" strings with their real, localised form
++ 								$error = array_map(array($this->user, 'lang'), $error);
++-								$this->template->assign_vars(array('REGISTER' => true, 'BEDANKT' => implode('<br />', $error) ));
+++								$this->template->assign_vars(array('REGISTER' => true, 'THANKS' => implode('<br />', $error) ));
++ 							} else
++ 							{
++ 								$user_id = user_add($data);
++ 								$result = $this->auth->login($uname, $pass);
++ 
++-								$this->template->assign_vars(array('REGISTER' => true, 'BEDANKT' => $this->user->lang['SUBSCRIBED']));
+++								$this->template->assign_vars(array('REGISTER' => true, 'THANKS' => $this->user->lang['SUBSCRIBED']));
++ 							}
++ 						} else
++ 						{
++@@ -212,7 +212,7 @@ class main_controller
++ 					$sql = 'UPDATE ' . USERS_TABLE . ' SET user_allow_massemail = 0 WHERE user_id = ' . $this->user->data['user_id'];
++ 					$this->db->sql_query($sql);
++ 
++-					$this->template->assign_vars(array('REGISTER' => true, 'BEDANKT' => $this->user->lang['UNSUBSCRIBED']));
+++					$this->template->assign_vars(array('REGISTER' => true, 'THANKS' => $this->user->lang['UNSUBSCRIBED']));
++ 				} else
++ 				{
++ 					$sql = 'SELECT user_id, username, user_password
++@@ -232,10 +232,10 @@ class main_controller
++ 								$sql = 'UPDATE ' . USERS_TABLE . ' SET user_allow_massemail = 0 WHERE user_id = ' . $userid;
++ 								$this->db->sql_query($sql);
++ 
++-								$this->template->assign_vars(array('REGISTER' => true, 'BEDANKT' => $this->user->lang['UNSUBSCRIBED']));
+++								$this->template->assign_vars(array('REGISTER' => true, 'THANKS' => $this->user->lang['UNSUBSCRIBED']));
++ 							} else
++ 							{
++-								$this->template->assign_vars(array('REGISTER' => true, 'BEDANKT' => $this->user->lang['LOGIN_ERROR_PASSWORD']));
+++								$this->template->assign_vars(array('REGISTER' => true, 'THANKS' => $this->user->lang['LOGIN_ERROR_PASSWORD']));
++ 							}
++ 						} else
++ 						{
++@@ -364,15 +364,15 @@ class main_controller
++ 			$archive_rows = array();
++ 			foreach ($season as $key => $a)
++ 			{
++-				$sql = 'SELECT id, subject, time as datum FROM ' . $this->newsletter_table . '
++-						WHERE display_it = 1 AND time BETWEEN ' . $a['datebegin'] . ' AND ' . $a['dateend'] . ' ORDER BY datum DESC';
+++				$sql = 'SELECT id, subject, time as dates FROM ' . $this->newsletter_table . '
+++						WHERE display_it = 1 AND time BETWEEN ' . $a['datebegin'] . ' AND ' . $a['dateend'] . ' ORDER BY dates DESC';
++ 				$result = $this->db->sql_query($sql);
++ 				while ($row = $this->db->sql_fetchrow($result))
++ 				{
++ 					if ($key != $last_mon)
++ 					{
++ 						$archive_row = array(
++-							'ARCHIVE'	=> $this->user->format_date($row['datum'], 'Y'),
+++							'ARCHIVE'	=> $this->user->format_date($row['dates'], 'Y'),
++ 							'monthrow'	=> array(),
++ 						);
++ 						$archive_rows[] = $archive_row;
++@@ -381,7 +381,7 @@ class main_controller
++ 					$archive_row_month = array(
++ 						'TITLE'			=> $row['subject'],
++ 						'U_VIEW'		=> $row['id'],
++-						'DATE'			=> $this->user->format_date($row['datum'], 'j F Y'),
+++						'DATE'			=> $this->user->format_date($row['dates'], 'j F Y'),
++ 					);
++ 
++ 					$archive_rows[sizeof($archive_rows) - 1]['monthrow'][] = $archive_row_month;
++@@ -410,13 +410,13 @@ class main_controller
++ 
++ 	protected function season($time)
++ 	{
++-		$sql = 'SELECT DISTINCT FROM_UNIXTIME(time, "%Y") AS jaar FROM ' . $this->newsletter_table . ' WHERE display_it = 1 ORDER BY jaar DESC';
+++		$sql = 'SELECT DISTINCT FROM_UNIXTIME(time, "%Y") AS years FROM ' . $this->newsletter_table . ' WHERE display_it = 1 ORDER BY years DESC';
++ 		$result = $this->db->sql_query($sql);
++ 		$i = 1;
++ 		$season = array();
++ 		while ($row = $this->db->sql_fetchrow($result))
++ 	
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\newsletter/helper/helper.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/helper/helper.php"
+index da09f75de..2b5ad55ce 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\newsletter/helper/helper.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/helper/helper.php"
+@@ -136,7 +136,7 @@ class helper
+ 			$messenger->headers('X-AntiAbuse: Username - ' . $this->user->data['username']);
+ 			$messenger->headers('X-AntiAbuse: User IP - ' . $this->user->ip);
+ 			$messenger->assign_vars(array(
+-				'SITE_LOGO_IMG'		=> $server_url . '/ext/sitesplat/newsletter/vendor/assets/images/github-logo.png',
++				'SITE_LOGO_IMG'		=> $server_url . '/ext/sitesplat/newsletter/vendor/assets/images/gold-logo.png',
+ 				'BOARD_URL'			=> $server_url,
+ 				'NEWSLETTER_ONLINE'	=> preg_replace("/$this->php_ext(&amp;|&)+?/", "$this->php_ext?", preg_replace('/(\?)?(&amp;|&)?sid=[a-z0-9]+/', '', 
+ 									   $this->helper->route('sitesplat_newsletter_main_controller', array('route' => 'index.html'), true, '', UrlGeneratorInterface::ABSOLUTE_URL))),
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\newsletter/language/en/email/newsletter_html.txt" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/language/en/email/newsletter_html.txt"
+index 5810c31ab..395fa3f4e 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\newsletter/language/en/email/newsletter_html.txt"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/language/en/email/newsletter_html.txt"
+@@ -1,8 +1,290 @@
+-Subject: Newsletter from "{SITENAME}"
++<!DOCTYPE html>
++<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
+ 
+-{MESSAGE}
++<head>
++  <meta charset="utf-8"> <!-- utf-8 works for most cases -->
++  <meta name="viewport" content="width=device-width"> <!-- Forcing initial-scale shouldn't be necessary -->
++  <meta http-equiv="X-UA-Compatible" content="IE=edge"> <!-- Use the latest (edge) version of IE rendering engine -->
++  <meta name="x-apple-disable-message-reformatting"> <!-- Disable auto-scale in iOS 10 Mail entirely -->
+ 
+-<p>
+-   <a href="{NEWSLETTER_ONLINE}">All newsletter online</a>
+-   <p>Don't want to receive our newsletter anymore? Unsubscribe <a href="{NEWSLETTER_OPTOUT}">here</a></p>
+-</p>
+\ No newline at end of file
++  <!-- Web Font / @font-face : BEGIN -->
++  <!-- NOTE: If web fonts are not required, lines 10 - 27 can be safely removed. -->
++
++  <!-- Desktop Outlook chokes on web font references and defaults to Times New Roman, so we force a safe fallback font. -->
++  <!--[if mso]>
++        <style>
++            * {
++                font-family: sans-serif !important;
++            }
++        </style>
++    <![endif]-->
++
++  <!-- All other clients get the webfont reference; some will render the font and others will silently fail to the fallbacks. More on that here: http://stylecampaign.com/blog/2015/02/webfont-support-in-email/ -->
++  <!--[if !mso]><!-->
++  <!-- insert web font reference, eg: <link href='https://fonts.googleapis.com/css?family=Roboto:400,700' rel='stylesheet' type='text/css'> -->
++  <!--<![endif]-->
++
++  <!-- Web Font / @font-face : END -->
++
++  <!-- CSS Reset : BEGIN -->
++  <style>
++    /* What it does: Remove spaces around the email design added by some email clients. */
++    /* Beware: It can remove the padding / margin and add a background color to the compose a reply window. */
++    html,
++    body {
++      margin: 0 auto !important;
++      padding: 0 !important;
++      height: 100% !important;
++      width: 100% !important;
++    }
++
++    /* What it does: Stops email clients resizing small text. */
++    * {
++      -ms-text-size-adjust: 100%;
++      -webkit-text-size-adjust: 100%;
++    }
++
++    /* What it does: Centers email on Android 4.4 */
++    div[style*="margin: 16px 0"] {
++      margin: 0 !important;
++    }
++
++    /* What it does: Stops Outlook from adding extra spacing to tables. */
++    table,
++    td {
++      mso-table-lspace: 0pt !important;
++      mso-table-rspace: 0pt !important;
++    }
++
++    /* What it does: Fixes webkit padding issue. Fix for Yahoo mail table alignment bug. Applies table-layout to the first 2 tables then removes for anything nested deeper. */
++    table {
++      border-spacing: 0 !important;
++      border-collapse: collapse !important;
++      table-layout: fixed !important;
++      margin: 0 auto !important;
++    }
++
++    table table table {
++      table-layout: auto;
++    }
++
++    /* What it does: Uses a better rendering method when resizing images in IE. */
++    img {
++      -ms-interpolation-mode: bicubic;
++    }
++
++    /* What it does: A work-around for email clients meddling in triggered links. */
++    *[x-apple-data-detectors],
++    /* iOS */
++    .x-gmail-data-detectors,
++    /* Gmail */
++    .x-gmail-data-detectors *,
++    .aBn {
++      border-bottom: 0 !important;
++      cursor: default !important;
++      color: inherit !important;
++      text-decoration: none !important;
++      font-size: inherit !important;
++      font-family: inherit !important;
++      font-weight: inherit !important;
++      line-height: inherit !important;
++    }
++
++    /* What it does: Prevents Gmail from displaying an download button on large, non-linked images. */
++    .a6S {
++      display: none !important;
++      opacity: 0.01 !important;
++    }
++
++    /* If the above doesn't work, add a .g-img class to any image in question. */
++    img.g-img+div {
++      display: none !important;
++    }
++
++    /* What it does: Prevents underlining the button text in Windows 10 */
++    .button-link {
++      text-decoration: none !important;
++    }
++
++    /* What it does: Removes right gutter in Gmail iOS app: https://github.com/TedGoas/Cerberus/issues/89  */
++    /* Create one of these media queries for each additional viewport size you'd like to fix */
++    /* Thanks to Eric Lepetit (@ericlepetitsf) for help troubleshooting */
++    @media only screen and (min-device-width: 375px) and (max-device-width: 413px) {
++
++      /* iPhone 6 and 6+ */
++      .email-container {
++        min-width: 375px !important;
++      }
++    }
++
++    @media screen and (max-width: 480px) {
++
++      /* What it does: Forces Gmail app to display email full width */
++      u~div .email-container {
++        min-width: 100vw;
++        width: 100% !important;
++      }
++    }
++  </style>
++  <!-- CSS Reset : END -->
++
++  <!-- Progressive Enhancements : BEGIN -->
++  <style>
++    /* What it does: Hover styles for buttons */
++    .button-td,
++    .button-a {
++      transition: all 100ms ease-in;
++    }
++
++    .button-td:hover,
++    .button-a:hover {
++      background: #CC9900 !important;
++      border-color: #CC9900 !important;
++    }
++
++    /* Define o estilo dos links */
++    a:link {
++      color: #CC9900;
++      background-color: transparent;
++      text-decoration: none;
++    }
++
++    a:visited {
++      color: #CC9900;
++      background-color: transparent;
++      text-decoration: none;
++    }
++
++    a:hover {
++      color: #CC9900;
++      background-color: transparent;
++      text-decoration: underline;
++    }
++
++    a:active {
++      color: #CC9900;
++      background-color: transparent;
++      text-decoration: underline;
++    }
++
++    /* Media Queries */
++    @media screen and (max-width: 600px) {
++
++      .email-container {
++        width: 100% !important;
++        margin: auto !important;
++      }
++
++      /* What it does: Forces elements to resize to the full width of their container. Useful for resizing images beyond their max-width. */
++      .fluid {
++        max-width: 100% !important;
++        height: auto !important;
++        margin-left: auto !important;
++        margin-right: auto !important;
++      }
++
++      /* What it does: Forces table cells into full-width rows. */
++      .stack-column,
++      .stack-column-center {
++        display: block !important;
++        width: 100% !important;
++        max-width: 100% !important;
++        direction: ltr !important;
++      }
++
++      /* And center justify these ones. */
++      .stack-column-center {
++        text-align: center !important;
++      }
++
++      /* What it does: Generic utility class for centering. Useful for images, buttons, and nested tables. */
++      .center-on-narrow {
++        text-align: center !important;
++        display: block !important;
++        margin-left: auto !important;
++        margin-right: auto !important;
++        float: none !important;
++      }
++
++      table.center-on-narrow {
++        display: inline-block !important;
++      }
++
++      /* What it does: Adjust typography on small screens to improve readability */
++      .email-container p {
++        font-size: 17px !important;
++      }
++    }
++  </style>
++  <!-- Progressive Enhancements : END -->
++
++  <!-- What it does: Makes background images in 72ppi Outlook render at correct size. -->
++  <!--[if gte mso 9]>
++    <xml>
++        <o:OfficeDocumentSettings>
++            <o:AllowPNG/>
++            <o:PixelsPerInch>96</o:PixelsPerInch>
++        </o:OfficeDocumentSettings>
++    </xml>
++    <![endif]-->
++
++</head>
++
++<body width="100%" bgcolor="#222222" style="margin: 0; mso-line-height-rule: exactly;">
++  <center style="width: 100%; background: #fafafa; text-align: left;">
++
++    <!-- Email Header : BEGIN -->
++    <table role="presentation" cellspacing="0" cellpadding="0" border="0" align="center" width="600" style="margin: auto;" class="email-container" bgcolor="#1E1E1E">
++      <tr>
++        <td style="padding: 20px 0; text-align: center">
++          <a href="https://goldtuganime.com" target="_blank"><img src="https://upload.goldtuganime.com/redes-sociais/GTA_Logo_Newsletter.png" width="282" border="0" style="height: auto; font-family: sans-serif; font-size: 15px; line-height: 140%; color: #555555;"></a>
++        </td>
++      </tr>
++    </table>
++    <!-- Email Header : END -->
++
++    {MESSAGE}
++
++    <!-- Email Footer : BEGIN -->
++    <table role="presentation" bgcolor="#1E1E1E" cellspacing="0" cellpadding="0" border="0" align="center" width="100%" style="max-width: 600px; font-family: sans-serif; color: #888888; font-size: 11px; line-height: 140%;">
++      <tr>
++        <td style="padding: 10px 10px; width: 100%; font-family: sans-serif; font-size: 12px; line-height: 140%; text-align: center; color: #888888;" class="x-gmail-data-detectors">
++          <table width="300" border="0" cellspacing="10" cellpadding="10">
++            <tbody>
++              <tr>
++                <td><a href="https://www.facebook.com/goldtuganimeoficial/" target="_blank"><img src="https://upload.goldtuganime.com/redes-sociais/facebook-Y.png" height="24" width="24" class=""></a></td>
++                <td><a href="https://www.instagram.com/goldtuganime/" target="_blank"><img src="https://upload.goldtuganime.com/redes-sociais/instagram-Y.png" height="24" width="24" class=""></a></td>
++                <td><a href="https://discord.gg/Zk8CCZUG/" target="_blank"><img src="https://upload.goldtuganime.com/redes-sociais/discord-Y.png" height="24" width="24" class=""></a></td>
++                <td><a href="https://www.youtube.com/@GoldTugAnimeOFICIAL" target="_blank"><img src="https://upload.goldtuganime.com/redes-sociais/youtube-Y.png" height="24" width="24" class=""></a></td>
++                <td><a href="https://goldtuganime.com" target="_blank"><img src="https://upload.goldtuganime.com/redes-sociais/website-Y.png" height="24" width="24" class=""></a></td>
++              </tr>
++            </tbody>
++          </table>
++        </td>
++      </tr>
++    </table>
++    <table role="presentation" cellspacing="0" cellpadding="0" border="0" align="center" width="100%" style="max-width: 600px; font-family: sans-serif; color: #888888; font-size: 11px; line-height: 140%;">
++      <tr>
++        <td style="padding: 10px 10px; width: 100%; font-family: sans-serif; font-size: 12px; line-height: 140%; text-align: center; color: #888888;" class="x-gmail-data-detectors"><em>Copyright © 2023 | <a href="https://goldtuganime.com" target="_blank">GoldTugAnime</a> | Todos os direitos reservados.</em></td>
++      </tr>
++      <tr>
++        <td>
++          <table width="400" border="0" cellspacing="0" cellpadding="0">
++            <tbody>
++              <tr>
++                <td width="400" height="2" bgcolor="#CC9900" align="center" valign="bottom" style="padding: 0px;"></td>
++              </tr>
++            </tbody>
++          </table>
++        </td>
++      </tr>
++      <tr>
++        <td style="padding: 10px 10px; width: 100%; font-family: sans-serif; font-size: 8px; line-height: 140%; text-align: center; color: #888888;" class="x-gmail-data-detectors">You are receiving this e-mail because you have a subscription in our forum. <a href="{NEWSLETTER_ONLINE}" target="_blank">check here</a> what newsletters you received or remove your e-mail address from our list through the link <a href="{NEWSLETTER_OPTOUT}" target="_blank">remove subscription</a>, in case you want to.
++        </td>
++      </tr>
++    </table>
++    <!-- Email Footer : END -->
++  </center>
++</body>
++
++</html>
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\newsletter/language/en/info_acp_newsletter.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/language/en/info_acp_newsletter.php"
+index ac655a364..cc9168a39 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\newsletter/language/en/info_acp_newsletter.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/language/en/info_acp_newsletter.php"
+@@ -25,7 +25,7 @@ $lang = array_merge($lang, array(
+ 	'SEND_IMMEDIATELY'			=> 'Send immediately',
+ 	'SEND_IMMEDIATELY_EXPLAIN'	=> 'Attempt to send the emails immediately. This depends on the server email configuration parameters',
+ 	'PERIOD'					=> 'Email Overview (or Catch-up) Period',
+-	'PERIOD_EXPLAIN'			=> 'This will send autmatic "Catch-up"  emails to the users that are subscribed. The e-mail will be generated based on the new topics in the forum. The user will receive an email with the purpose of engaging the user\'s interest in the recent board\'s activity. Edit the templates file named newsletter_html.txt for the HTML version and newsletter_txt.txt for the TXT version from:<br /> <code>root\ext\sitesplat\newsletter\language\en\email\</code> <br /> To learn how to send out professional looking HTML emails check out the tutorials over at <a href=" https://sitesplat.com/" target="_blank">sitesplat.com</a> or click the "Tutorials" label above.',
++	'PERIOD_EXPLAIN'			=> 'This will send automatic "Catch-up"  emails to the users that are subscribed. The e-mail will be generated based on the new topics in the forum. The user will receive an email with the purpose of engaging the user\'s interest in the recent board\'s activity. Edit the templates file named newsletter_html.txt for the HTML version and newsletter_txt.txt for the TXT version from:<br /> <code>root\ext\sitesplat\newsletter\language\en\email\</code> <br /> To learn how to send out professional looking HTML emails check out the tutorials over at <a href=" https://sitesplat.com/" target="_blank">sitesplat.com</a> or click the "Tutorials" label above.',
+ 	'WEEKLY'					=> 'Weekly',
+ 	'MONTHLY'					=> 'Monthly',
+ 	'NO_OVERVIEW'				=> 'None',
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\newsletter/language/en/newsletter.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/language/en/newsletter.php"
+index c8d91f647..02aa2312c 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\newsletter/language/en/newsletter.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/language/en/newsletter.php"
+@@ -34,7 +34,7 @@ $lang = array_merge($lang, array(
+ 	'SUBSCRIBE_INFO'			=> 'Our newsletter. Unsubscribed members won\'t receive our periodic News overview anymore.',
+ 	
+ 	'OVERVIEW_ARCHIVE'			=> 'Archive',
+-	'ARCHIEVES'					=> 'Archives',
++	'ARCHIVES'					=> 'Archives',
+ 	'SUBSCRIBED'				=> 'Thanks for subscribing! You will receive our newsletter from today on!',
+ 	'UNSUBSCRIBED'				=> 'Successfully unsubscribed, you won\'t receive our newsletter any longer'
+ ));
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/language/pt/email/index.htm" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/language/pt/email/index.htm"
+new file mode 100644
+index 000000000..ee1f723a7
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/language/pt/email/index.htm"
+@@ -0,0 +1,10 @@
++<html>
++<head>
++<title></title>
++<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
++</head>
++
++<body bgcolor="#FFFFFF" text="#000000">
++
++</body>
++</html>
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/language/pt/email/newsletter_html.txt" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/language/pt/email/newsletter_html.txt"
+new file mode 100644
+index 000000000..f06feec62
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/language/pt/email/newsletter_html.txt"
+@@ -0,0 +1,293 @@
++Subject: {SUBJECT}
++
++<!DOCTYPE html>
++<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
++
++<head>
++  <meta charset="utf-8"> <!-- utf-8 works for most cases -->
++  <meta name="viewport" content="width=device-width"> <!-- Forcing initial-scale shouldn't be necessary -->
++  <meta http-equiv="X-UA-Compatible" content="IE=edge"> <!-- Use the latest (edge) version of IE rendering engine -->
++  <meta name="x-apple-disable-message-reformatting"> <!-- Disable auto-scale in iOS 10 Mail entirely -->
++
++  <!-- Web Font / @font-face : BEGIN -->
++  <!-- NOTE: If web fonts are not required, lines 10 - 27 can be safely removed. -->
++
++  <!-- Desktop Outlook chokes on web font references and defaults to Times New Roman, so we force a safe fallback font. -->
++  <!--[if mso]>
++        <style>
++            * {
++                font-family: sans-serif !important;
++            }
++        </style>
++    <![endif]-->
++
++  <!-- All other clients get the webfont reference; some will render the font and others will silently fail to the fallbacks. More on that here: http://stylecampaign.com/blog/2015/02/webfont-support-in-email/ -->
++  <!--[if !mso]><!-->
++  <!-- insert web font reference, eg: <link href='https://fonts.googleapis.com/css?family=Roboto:400,700' rel='stylesheet' type='text/css'> -->
++  <!--<![endif]-->
++
++  <!-- Web Font / @font-face : END -->
++
++  <!-- CSS Reset : BEGIN -->
++  <style>
++    /* What it does: Remove spaces around the email design added by some email clients. */
++    /* Beware: It can remove the padding / margin and add a background color to the compose a reply window. */
++    html,
++    body {
++      margin: 0 auto !important;
++      padding: 0 !important;
++      height: 100% !important;
++      width: 100% !important;
++    }
++
++    /* What it does: Stops email clients resizing small text. */
++    * {
++      -ms-text-size-adjust: 100%;
++      -webkit-text-size-adjust: 100%;
++    }
++
++    /* What it does: Centers email on Android 4.4 */
++    div[style*="margin: 16px 0"] {
++      margin: 0 !important;
++    }
++
++    /* What it does: Stops Outlook from adding extra spacing to tables. */
++    table,
++    td {
++      mso-table-lspace: 0pt !important;
++      mso-table-rspace: 0pt !important;
++    }
++
++    /* What it does: Fixes webkit padding issue. Fix for Yahoo mail table alignment bug. Applies table-layout to the first 2 tables then removes for anything nested deeper. */
++    table {
++      border-spacing: 0 !important;
++      border-collapse: collapse !important;
++      table-layout: fixed !important;
++      margin: 0 auto !important;
++    }
++
++    table table table {
++      table-layout: auto;
++    }
++
++    /* What it does: Uses a better rendering method when resizing images in IE. */
++    img {
++      -ms-interpolation-mode: bicubic;
++    }
++
++    /* What it does: A work-around for email clients meddling in triggered links. */
++    *[x-apple-data-detectors],
++    /* iOS */
++    .x-gmail-data-detectors,
++    /* Gmail */
++    .x-gmail-data-detectors *,
++    .aBn {
++      border-bottom: 0 !important;
++      cursor: default !important;
++      color: inherit !important;
++      text-decoration: none !important;
++      font-size: inherit !important;
++      font-family: inherit !important;
++      font-weight: inherit !important;
++      line-height: inherit !important;
++    }
++
++    /* What it does: Prevents Gmail from displaying an download button on large, non-linked images. */
++    .a6S {
++      display: none !important;
++      opacity: 0.01 !important;
++    }
++
++    /* If the above doesn't work, add a .g-img class to any image in question. */
++    img.g-img+div {
++      display: none !important;
++    }
++
++    /* What it does: Prevents underlining the button text in Windows 10 */
++    .button-link {
++      text-decoration: none !important;
++    }
++
++    /* What it does: Removes right gutter in Gmail iOS app: https://github.com/TedGoas/Cerberus/issues/89  */
++    /* Create one of these media queries for each additional viewport size you'd like to fix */
++    /* Thanks to Eric Lepetit (@ericlepetitsf) for help troubleshooting */
++    @media only screen and (min-device-width: 375px) and (max-device-width: 413px) {
++
++      /* iPhone 6 and 6+ */
++      .email-container {
++        min-width: 375px !important;
++      }
++    }
++
++    @media screen and (max-width: 480px) {
++
++      /* What it does: Forces Gmail app to display email full width */
++      u~div .email-container {
++        min-width: 100vw;
++        width: 100% !important;
++      }
++    }
++  </style>
++  <!-- CSS Reset : END -->
++
++  <!-- Progressive Enhancements : BEGIN -->
++  <style>
++    /* What it does: Hover styles for buttons */
++    .button-td,
++    .button-a {
++      transition: all 100ms ease-in;
++    }
++
++    .button-td:hover,
++    .button-a:hover {
++      background: #CC9900 !important;
++      border-color: #CC9900 !important;
++    }
++
++    /* Define o estilo dos links */
++    a:link {
++      color: #CC9900;
++      background-color: transparent;
++      text-decoration: none;
++    }
++
++    a:visited {
++      color: #CC9900;
++      background-color: transparent;
++      text-decoration: none;
++    }
++
++    a:hover {
++      color: #CC9900;
++      background-color: transparent;
++      text-decoration: underline;
++    }
++
++    a:active {
++      color: #CC9900;
++      background-color: transparent;
++      text-decoration: underline;
++    }
++
++    /* Media Queries */
++    @media screen and (max-width: 600px) {
++
++      .email-container {
++        width: 100% !important;
++        margin: auto !important;
++      }
++
++      /* What it does: Forces elements to resize to the full width of their container. Useful for resizing images beyond their max-width. */
++      .fluid {
++        max-width: 100% !important;
++        height: auto !important;
++        margin-left: auto !important;
++        margin-right: auto !important;
++      }
++
++      /* What it does: Forces table cells into full-width rows. */
++      .stack-column,
++      .stack-column-center {
++        display: block !important;
++        width: 100% !important;
++        max-width: 100% !important;
++        direction: ltr !important;
++      }
++
++      /* And center justify these ones. */
++      .stack-column-center {
++        text-align: center !important;
++      }
++
++      /* What it does: Generic utility class for centering. Useful for images, buttons, and nested tables. */
++      .center-on-narrow {
++        text-align: center !important;
++        display: block !important;
++        margin-left: auto !important;
++        margin-right: auto !important;
++        float: none !important;
++      }
++
++      table.center-on-narrow {
++        display: inline-block !important;
++      }
++
++      /* What it does: Adjust typography on small screens to improve readability */
++      .email-container p {
++        font-size: 17px !important;
++      }
++    }
++  </style>
++  <!-- Progressive Enhancements : END -->
++
++  <!-- What it does: Makes background images in 72ppi Outlook render at correct size. -->
++  <!--[if gte mso 9]>
++    <xml>
++        <o:OfficeDocumentSettings>
++            <o:AllowPNG/>
++            <o:PixelsPerInch>96</o:PixelsPerInch>
++        </o:OfficeDocumentSettings>
++    </xml>
++    <![endif]-->
++
++</head>
++
++<body width="100%" bgcolor="#222222" style="margin: 0; mso-line-height-rule: exactly;">
++  <center style="width: 100%; background: #fafafa; text-align: left;">
++
++    <!-- Email Header : BEGIN -->
++    <table role="presentation" cellspacing="0" cellpadding="0" border="0" align="center" width="600" style="margin: auto;" class="email-container" bgcolor="#1E1E1E">
++      <tr>
++        <td style="padding: 20px 0; text-align: center">
++          <a href="https://goldtuganime.com" target="_blank"><img src="https://upload.goldtuganime.com/redes-sociais/GTA_Logo_Newsletter.png" width="282" border="0" style="height: auto; font-family: sans-serif; font-size: 15px; line-height: 140%; color: #555555;"></a>
++        </td>
++      </tr>
++    </table>
++    <!-- Email Header : END -->
++
++    {MESSAGE}
++
++    <!-- Email Footer : BEGIN -->
++    <table role="presentation" bgcolor="#1E1E1E" cellspacing="0" cellpadding="0" border="0" align="center" width="100%" style="max-width: 600px; font-family: sans-serif; color: #888888; font-size: 11px; line-height: 140%;">
++      <tr>
++        <td style="padding: 10px 10px; width: 100%; font-family: sans-serif; font-size: 12px; line-height: 140%; text-align: center; color: #888888;" class="x-gmail-data-detectors">
++          <table width="300" border="0" cellspacing="10" cellpadding="10">
++            <tbody>
++              <tr>
++                <td><a href="https://www.facebook.com/goldtuganimeoficial/" target="_blank"><img src="https://upload.goldtuganime.com/redes-sociais/facebook-Y.png" height="24" width="24" class=""></a></td>
++                <td><a href="https://www.instagram.com/goldtuganime/" target="_blank"><img src="https://upload.goldtuganime.com/redes-sociais/instagram-Y.png" height="24" width="24" class=""></a></td>
++                <td><a href="https://discord.gg/Zk8CCZUG/" target="_blank"><img src="https://upload.goldtuganime.com/redes-sociais/discord-Y.png" height="24" width="24" class=""></a></td>
++                <td><a href="https://www.youtube.com/@GoldTugAnimeOFICIAL" target="_blank"><img src="https://upload.goldtuganime.com/redes-sociais/youtube-Y.png" height="24" width="24" class=""></a></td>
++                <td><a href="https://goldtuganime.com" target="_blank"><img src="https://upload.goldtuganime.com/redes-sociais/website-Y.png" height="24" width="24" class=""></a></td>
++              </tr>
++            </tbody>
++          </table>
++
++        </td>
++      </tr>
++    </table>
++    <table role="presentation" cellspacing="0" cellpadding="0" border="0" align="center" width="100%" style="max-width: 600px; font-family: sans-serif; color: #888888; font-size: 11px; line-height: 140%;">
++      <tr>
++        <td style="padding: 10px 10px; width: 100%; font-family: sans-serif; font-size: 12px; line-height: 140%; text-align: center; color: #888888;" class="x-gmail-data-detectors"><em>Copyright © 2023 | <a href="https://goldtuganime.com" target="_blank">GoldTugAnime</a> | Todos os direitos reservados.</em></td>
++      </tr>
++      <tr>
++        <td>
++          <table width="400" border="0" cellspacing="0" cellpadding="0">
++            <tbody>
++              <tr>
++                <td width="400" height="2" bgcolor="#CC9900" align="center" valign="bottom" style="padding: 0px;"></td>
++              </tr>
++            </tbody>
++          </table>
++        </td>
++      </tr>
++      <tr>
++        <td style="padding: 10px 10px; width: 100%; font-family: sans-serif; font-size: 8px; line-height: 140%; text-align: center; color: #888888;" class="x-gmail-data-detectors">Estás a receber este e-mail porque estás inscrito no nosso fórum. <a href="{NEWSLETTER_ONLINE}" target="_blank">Vê aqui</a> que newsletters já recebeste ou remove o teu endereço eletrónico da nossa lista através do link <a href="{NEWSLETTER_OPTOUT}" target="_blank">remover subscrição</a>, caso pretendas.
++        </td>
++      </tr>
++    </table>
++    <!-- Email Footer : END -->
++  </center>
++</body>
++
++</html>
+\ No newline at end of file
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/language/pt/email/newsletter_txt.txt" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/language/pt/email/newsletter_txt.txt"
+new file mode 100644
+index 000000000..0b839ca10
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/language/pt/email/newsletter_txt.txt"
+@@ -0,0 +1,6 @@
++Subject: Newsletter de {SITENAME}
++
++{MESSAGE}
++
++Todas as newsletter: {NEWSLETTER_ONLINE}
++Não desejas continuar a receber a nossa newsletter? Clica aqui: {NEWSLETTER_OPTOUT}
+\ No newline at end of file
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/language/pt/email/newsoverview_html.txt" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/language/pt/email/newsoverview_html.txt"
+new file mode 100644
+index 000000000..bf3ad62ea
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/language/pt/email/newsoverview_html.txt"
+@@ -0,0 +1,961 @@
++Subject: Últimas Novidades "{SITENAME}"
++
++<html xmlns="http://www.w3.org/1999/xhtml" style="margin: 0;padding: 0;">
++<!--<![endif]-->
++
++<head>
++	<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
++	<!--[if !mso]><!-->
++	<meta content="IE=edge" http-equiv="X-UA-Compatible">
++	<!--<![endif]-->
++	<meta content="width=device-width" name="viewport">
++	<style type="text/css">
++		@media only screen and (min-width: 620px) {
++			* [lang=x-wrapper] h1 {
++				font-size: 26px !important;
++				line-height: 34px !important;
++			}
++			* [lang=x-wrapper] h2 {
++				font-size: 20px !important;
++				line-height: 28px !important;
++			}
++			* div [lang=x-size-8] {
++				font-size: 8px !important;
++				line-height: 14px !important;
++			}
++			* div [lang=x-size-9] {
++				font-size: 9px !important;
++				line-height: 16px !important;
++			}
++			* div [lang=x-size-10] {
++				font-size: 10px !important;
++				line-height: 18px !important;
++			}
++			* div [lang=x-size-11] {
++				font-size: 11px !important;
++				line-height: 19px !important;
++			}
++			* div [lang=x-size-12] {
++				font-size: 12px !important;
++				line-height: 19px !important;
++			}
++			* div [lang=x-size-13] {
++				font-size: 13px !important;
++				line-height: 21px !important;
++			}
++			* div [lang=x-size-14] {
++				font-size: 14px !important;
++				line-height: 21px !important;
++			}
++			* div [lang=x-size-15] {
++				font-size: 15px !important;
++				line-height: 23px !important;
++			}
++			* div [lang=x-size-16] {
++				font-size: 16px !important;
++				line-height: 24px !important;
++			}
++			* div [lang=x-size-17] {
++				font-size: 17px !important;
++				line-height: 26px !important;
++			}
++			* div [lang=x-size-18] {
++				font-size: 18px !important;
++				line-height: 26px !important;
++			}
++			* div [lang=x-size-18] {
++				font-size: 18px !important;
++				line-height: 26px !important;
++			}
++			* div [lang=x-size-20] {
++				font-size: 20px !important;
++				line-height: 28px !important;
++			}
++			* div [lang=x-size-22] {
++				font-size: 22px !important;
++				line-height: 31px !important;
++			}
++			* div [lang=x-size-24] {
++				font-size: 24px !important;
++				line-height: 32px !important;
++			}
++			* div [lang=x-size-26] {
++				font-size: 26px !important;
++				line-height: 34px !important;
++			}
++			* div [lang=x-size-28] {
++				font-size: 28px !important;
++				line-height: 36px !important;
++			}
++			* div [lang=x-size-30] {
++				font-size: 30px !important;
++				line-height: 38px !important;
++			}
++			* div [lang=x-size-32] {
++				font-size: 32px !important;
++				line-height: 40px !important;
++			}
++			* div [lang=x-size-34] {
++				font-size: 34px !important;
++				line-height: 43px !important;
++			}
++			* div [lang=x-size-36] {
++				font-size: 36px !important;
++				line-height: 43px !important;
++			}
++			* div [lang=x-size-40] {
++				font-size: 40px !important;
++				line-height: 47px !important;
++			}
++			* div [lang=x-size-44] {
++				font-size: 44px !important;
++				line-height: 50px !important;
++			}
++			* div [lang=x-size-48] {
++				font-size: 48px !important;
++				line-height: 54px !important;
++			}
++			* div [lang=x-size-56] {
++				font-size: 56px !important;
++				line-height: 60px !important;
++			}
++			* div [lang=x-size-64] {
++				font-size: 64px !important;
++				line-height: 63px !important;
++			}
++		}
++	</style>
++	<style type="text/css">
++		body {
++			margin: 0;
++			padding: 0;
++		}
++		
++		table {
++			border-collapse: collapse;
++			table-layout: fixed;
++		}
++		
++		* {
++			line-height: inherit;
++		}
++		
++		[x-apple-data-detectors],
++		[href^="tel"],
++		[href^="sms"] {
++			color: inherit !important;
++			text-decoration: none !important;
++		}
++		
++		.wrapper .footer__share-button a:hover,
++		.wrapper .footer__share-button a:focus {
++			color: #ffffff !important;
++		}
++		
++		.btn a:hover,
++		.btn a:focus,
++		.footer__share-button a:hover,
++		.footer__share-button a:focus,
++		.email-footer__links a:hover,
++		.email-footer__links a:focus {
++			opacity: 0.8;
++		}
++		
++		.ie .btn {
++			width: 100%;
++		}
++		
++		.ie .column,
++		[owa] .column,
++		.ie .gutter,
++		[owa] .gutter {
++			display: table-cell;
++			float: none !important;
++			vertical-align: top;
++		}
++		
++		.ie .preheader,
++		[owa] .preheader,
++		.ie .email-footer,
++		[owa] .email-footer {
++			width: 560px !important;
++		}
++		
++		.ie .snippet,
++		[owa] .snippet,
++		.ie .webversion,
++		[owa] .webversion {
++			width: 280px !important;
++		}
++		
++		.ie .header,
++		[owa] .header,
++		.ie .layout,
++		[owa] .layout,
++		.ie .one-col .column,
++		[owa] .one-col .column {
++			width: 600px !important;
++		}
++		
++		.ie .fixed-width.has-border,
++		[owa] .fixed-width.has-border,
++		.ie .has-gutter.has-border,
++		[owa] .has-gutter.has-border {
++			width: 602px !important;
++		}
++		
++		.ie .two-col .column,
++		[owa] .two-col .column {
++			width: 300px !important;
++		}
++		
++		.ie .three-col .column,
++		[owa] .three-col .column,
++		.ie .narrow,
++		[owa] .narrow {
++			width: 200px !important;
++		}
++		
++		.ie .wide,
++		[owa] .wide {
++			width: 400px !important;
++		}
++		
++		.ie .two-col.has-gutter .column,
++		[owa] .two-col.x_has-gutter .column {
++			width: 290px !important;
++		}
++		
++		.ie .three-col.has-gutter .column,
++		[owa] .three-col.x_has-gutter .column,
++		.ie .has-gutter .narrow,
++		[owa] .has-gutter .narrow {
++			width: 188px !important;
++		}
++		
++		.ie .has-gutter .wide,
++		[owa] .has-gutter .wide {
++			width: 394px !important;
++		}
++		
++		.ie .two-col.has-gutter.has-border .column,
++		[owa] .two-col.x_has-gutter.x_has-border .column {
++			width: 292px !important;
++		}
++		
++		.ie .three-col.has-gutter.has-border .column,
++		[owa] .three-col.x_has-gutter.x_has-border .column,
++		.ie .has-gutter.has-border .narrow,
++		[owa] .has-gutter.x_has-border .narrow {
++			width: 190px !important;
++		}
++		
++		.ie .has-gutter.has-border .wide,
++		[owa] .has-gutter.x_has-border .wide {
++			width: 396px !important;
++		}
++		
++		.ie .fixed-width .layout__inner {
++			border-left: 0 none white !important;
++			border-right: 0 none white !important;
++		}
++		
++		.ie .layout__edges {
++			display: none;
++		}
++		
++		.mso .layout__edges {
++			font-size: 0;
++		}
++		
++		.layout-fixed-width,
++		.mso .layout-full-width {
++			background-color: #ffffff;
++		}
++		
++		@media only screen and (min-width: 620px) {
++			.column,
++			.gutter {
++				display: table-cell;
++				Float: none !important;
++				vertical-align: top;
++			}
++			.preheader,
++			.email-footer {
++				width: 560px !important;
++			}
++			.snippet,
++			.webversion {
++				width: 280px !important;
++			}
++			.header,
++			.layout,
++			.one-col .column {
++				width: 600px !important;
++			}
++			.fixed-width.has-border,
++			.fixed-width.ecxhas-border,
++			.has-gutter.has-border,
++			.has-gutter.ecxhas-border {
++				width: 602px !important;
++			}
++			.two-col .column {
++				width: 300px !important;
++			}
++			.three-col .column,
++			.column.narrow {
++				width: 200px !important;
++			}
++			.column.wide {
++				width: 400px !important;
++			}
++			.two-col.has-gutter .column,
++			.two-col.ecxhas-gutter .column {
++				width: 290px !important;
++			}
++			.three-col.has-gutter .column,
++			.three-col.ecxhas-gutter .column,
++			.has-gutter .narrow {
++				width: 188px !important;
++			}
++			.has-gutter .wide {
++				width: 394px !important;
++			}
++			.two-col.has-gutter.has-border .column,
++			.two-col.ecxhas-gutter.ecxhas-border .column {
++				width: 292px !important;
++			}
++			.three-col.has-gutter.has-border .column,
++			.three-col.ecxhas-gutter.ecxhas-border .column,
++			.has-gutter.has-border .narrow,
++			.has-gutter.ecxhas-border .narrow {
++				width: 190px !important;
++			}
++			.has-gutter.has-border .wide,
++			.has-gutter.ecxhas-border .wide {
++				width: 396px !important;
++			}
++		}
++		
++		@media only screen and (-webkit-min-device-pixel-ratio: 2),
++		only screen and (min--moz-device-pixel-ratio: 2),
++		only screen and (-o-min-device-pixel-ratio: 2/1),
++		only screen and (min-device-pixel-ratio: 2),
++		only screen and (min-resolution: 192dpi),
++		only screen and (min-resolution: 2dppx) {
++			.fblike {
++				background-image: url(https://i3.createsend1.com/static/eb/master/13-the-blueprint-3/images/fblike@2x.png) !important;
++			}
++			.tweet {
++				background-image: url(https://i4.createsend1.com/static/eb/master/13-the-blueprint-3/images/tweet@2x.png) !important;
++			}
++			.linkedinshare {
++				background-image: url(https://i6.createsend1.com/static/eb/master/13-the-blueprint-3/images/lishare@2x.png) !important;
++			}
++			.forwardtoafriend {
++				background-image: url(https://i7.createsend1.com/static/eb/master/13-the-blueprint-3/images/forward@2x.png) !important;
++			}
++		}
++		
++		@media (max-width: 321px) {
++			.fixed-width.has-border .layout__inner {
++				border-width: 1px 0 !important;
++			}
++			.layout,
++			.column {
++				min-width: 320px !important;
++				width: 320px !important;
++			}
++			.border {
++				display: none;
++			}
++		}
++		
++		.mso div {
++			border: 0 none white !important;
++		}
++		
++		.mso .w560 .divider {
++			Margin-left: 260px !important;
++			Margin-right: 260px !important;
++		}
++		
++		.mso .w360 .divider {
++			Margin-left: 160px !important;
++			Margin-right: 160px !important;
++		}
++		
++		.mso .w260 .divider {
++			Margin-left: 110px !important;
++			Margin-right: 110px !important;
++		}
++		
++		.mso .w160 .divider {
++			Margin-left: 60px !important;
++			Margin-right: 60px !important;
++		}
++		
++		.mso .w354 .divider {
++			Margin-left: 157px !important;
++			Margin-right: 157px !important;
++		}
++		
++		.mso .w250 .divider {
++			Margin-left: 105px !important;
++			Margin-right: 105px !important;
++		}
++		
++		.mso .w148 .divider {
++			Margin-left: 54px !important;
++			Margin-right: 54px !important;
++		}
++		
++		.mso .font-avenir,
++		.mso .font-cabin,
++		.mso .font-open-sans,
++		.mso .font-ubuntu {
++			font-family: sans-serif !important;
++		}
++		
++		.mso .font-bitter,
++		.mso .font-merriweather,
++		.mso .font-pt-serif {
++			font-family: Georgia, serif !important;
++		}
++		
++		.mso .font-lato,
++		.mso .font-roboto {
++			font-family: Tahoma, sans-serif !important;
++		}
++		
++		.mso .font-pt-sans {
++			font-family: "Trebuchet MS", sans-serif !important;
++		}
++		
++		.mso .footer__share-button p {
++			margin: 0;
++		}
++		
++		@media only screen and (min-width: 620px) {
++			.wrapper .size-8 {
++				font-size: 8px !important;
++				line-height: 14px !important;
++			}
++			.wrapper .size-9 {
++				font-size: 9px !important;
++				line-height: 16px !important;
++			}
++			.wrapper .size-10 {
++				font-size: 10px !important;
++				line-height: 18px !important;
++			}
++			.wrapper .size-11 {
++				font-size: 11px !important;
++				line-height: 19px !important;
++			}
++			.wrapper .size-12 {
++				font-size: 12px !important;
++				line-height: 19px !important;
++			}
++			.wrapper .size-13 {
++				font-size: 13px !important;
++				line-height: 21px !important;
++			}
++			.wrapper .size-14 {
++				font-size: 14px !important;
++				line-height: 21px !important;
++			}
++			.wrapper .size-15 {
++				font-size: 15px !important;
++				line-height: 23px !important;
++			}
++			.wrapper .size-16 {
++				font-size: 16px !important;
++				line-height: 24px !important;
++			}
++			.wrapper .size-17 {
++				font-size: 17px !important;
++				line-height: 26px !important;
++			}
++			.wrapper .size-18 {
++				font-size: 18px !important;
++				line-height: 26px !important;
++			}
++			.wrapper .size-20 {
++				font-size: 20px !important;
++				line-height: 28px !important;
++			}
++			.wrapper .size-22 {
++				font-size: 22px !important;
++				line-height: 31px !important;
++			}
++			.wrapper .size-24 {
++				font-size: 24px !important;
++				line-height: 32px !important;
++			}
++			.wrapper .size-26 {
++				font-size: 26px !important;
++				line-height: 34px !important;
++			}
++			.wrapper .size-28 {
++				font-size: 28px !important;
++				line-height: 36px !important;
++			}
++			.wrapper .size-30 {
++				font-size: 30px !important;
++				line-height: 38px !important;
++			}
++			.wrapper .size-32 {
++				font-size: 32px !important;
++				line-height: 40px !important;
++			}
++			.wrapper .size-34 {
++				font-size: 34px !important;
++				line-height: 43px !important;
++			}
++			.wrapper .size-36 {
++				font-size: 36px !important;
++				line-height: 43px !important;
++			}
++			.wrapper .size-40 {
++				font-size: 40px !important;
++				line-height: 47px !important;
++			}
++			.wrapper .size-44 {
++				font-size: 44px !important;
++				line-height: 50px !important;
++			}
++			.wrapper .size-48 {
++				font-size: 48px !important;
++				line-height: 54px !important;
++			}
++			.wrapper .size-56 {
++				font-size: 56px !important;
++				line-height: 60px !important;
++			}
++			.wrapper .size-64 {
++				font-size: 64px !important;
++				line-height: 63px !important;
++			}
++		}
++		
++		.mso .size-8,
++		.ie .size-8 {
++			font-size: 8px !important;
++			line-height: 14px !important;
++		}
++		
++		.mso .size-9,
++		.ie .size-9 {
++			font-size: 9px !important;
++			line-height: 16px !important;
++		}
++		
++		.mso .size-10,
++		.ie .size-10 {
++			font-size: 10px !important;
++			line-height: 18px !important;
++		}
++		
++		.mso .size-11,
++		.ie .size-11 {
++			font-size: 11px !important;
++			line-height: 19px !important;
++		}
++		
++		.mso .size-12,
++		.ie .size-12 {
++			font-size: 12px !important;
++			line-height: 19px !important;
++		}
++		
++		.mso .size-13,
++		.ie .size-13 {
++			font-size: 13px !important;
++			line-height: 21px !important;
++		}
++		
++		.mso .size-14,
++		.ie .size-14 {
++			font-size: 14px !important;
++			line-height: 21px !important;
++		}
++		
++		.mso .size-15,
++		.ie .size-15 {
++			font-size: 15px !important;
++			line-height: 23px !important;
++		}
++		
++		.mso .size-16,
++		.ie .size-16 {
++			font-size: 16px !important;
++			line-height: 24px !important;
++		}
++		
++		.mso .size-17,
++		.ie .size-17 {
++			font-size: 17px !important;
++			line-height: 26px !important;
++		}
++		
++		.mso .size-18,
++		.ie .size-18 {
++			font-size: 18px !important;
++			line-height: 26px !important;
++		}
++		
++		.mso .size-20,
++		.ie .size-20 {
++			font-size: 20px !important;
++			line-height: 28px !important;
++		}
++		
++		.mso .size-22,
++		.ie .size-22 {
++			font-size: 22px !important;
++			line-height: 31px !important;
++		}
++		
++		.mso .size-24,
++		.ie .size-24 {
++			font-size: 24px !important;
++			line-height: 32px !important;
++		}
++		
++		.mso .size-26,
++		.ie .size-26 {
++			font-size: 26px !important;
++			line-height: 34px !important;
++		}
++		
++		.mso .size-28,
++		.ie .size-28 {
++			font-size: 28px !important;
++			line-height: 36px !important;
++		}
++		
++		.mso .size-30,
++		.ie .size-30 {
++			font-size: 30px !important;
++			line-height: 38px !important;
++		}
++		
++		.mso .size-32,
++		.ie .size-32 {
++			font-size: 32px !important;
++			line-height: 40px !important;
++		}
++		
++		.mso .size-34,
++		.ie .size-34 {
++			font-size: 34px !important;
++			line-height: 43px !important;
++		}
++		
++		.mso .size-36,
++		.ie .size-36 {
++			font-size: 36px !important;
++			line-height: 43px !important;
++		}
++		
++		.mso .size-40,
++		.ie .size-40 {
++			font-size: 40px !important;
++			line-height: 47px !important;
++		}
++		
++		.mso .size-44,
++		.ie .size-44 {
++			font-size: 44px !important;
++			line-height: 50px !important;
++		}
++		
++		.mso .size-48,
++		.ie .size-48 {
++			font-size: 48px !important;
++			line-height: 54px !important;
++		}
++		
++		.mso .size-56,
++		.ie .size-56 {
++			font-size: 56px !important;
++			line-height: 60px !important;
++		}
++		
++		.mso .size-64,
++		.ie .size-64 {
++			font-size: 64px !important;
++			line-height: 63px !important;
++		}
++		
++		.footer__share-button p {
++			margin: 0;
++		}
++	</style>
++
++	<title>{SITENAME}</title>
++	<!--[if !mso]><!-->
++	<style type="text/css">
++		@import url(https://fonts.googleapis.com/css?family=Bitter:400,700,400italic|Open+Sans:400italic,700italic,700,400);
++	</style>
++	<link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Bitter:400,700,400italic|Open+Sans:400italic,700italic,700,400">
++	<!--<![endif]-->
++	<style type="text/css">
++		body {
++			background-color: #f2f6f7
++		}
++		
++		.mso h1 {}
++		
++		.mso h1 {
++			font-family: Georgia, serif !important
++		}
++		
++		.mso h2 {}
++		
++		.mso h2 {
++			font-family: Georgia, serif !important
++		}
++		
++		.mso h3 {}
++		
++		.mso h3 {
++			font-family: Georgia, serif !important
++		}
++		
++		.mso .column,
++		.mso .column__background td {}
++		
++		.mso .column,
++		.mso .column__background td {
++			font-family: sans-serif !important
++		}
++		
++		.mso .btn a {}
++		
++		.mso .btn a {
++			font-family: sans-serif !important
++		}
++		
++		.mso .webversion,
++		.mso .snippet,
++		.mso .layout-email-footer td,
++		.mso .footer__share-button p {}
++		
++		.mso .webversion,
++		.mso .snippet,
++		.mso .layout-email-footer td,
++		.mso .footer__share-button p {
++			font-family: sans-serif !important
++		}
++		
++		.mso .logo {}
++		
++		.mso .logo {
++			font-family: Tahoma, sans-serif !important
++		}
++		
++		.logo a:hover,
++		.logo a:focus {
++			color: #859bb1 !important
++		}
++		
++		.mso .layout-has-border {
++			border-top: 1px solid #b3cad0;
++			border-bottom: 1px solid #b3cad0
++		}
++		
++		.mso .layout-has-bottom-border {
++			border-bottom: 1px solid #b3cad0
++		}
++		
++		.mso .border,
++		.ie .border {
++			background-color: #b3cad0
++		}
++		
++		@media only screen and (min-width: 620px) {
++			.wrapper h1 {}
++			.wrapper h1 {
++				font-size: 26px !important;
++				line-height: 34px !important
++			}
++			.wrapper h2 {}
++			.wrapper h2 {
++				font-size: 20px !important;
++				line-height: 28px !important
++			}
++			.wrapper h3 {}
++			.column,
++			.column__background td {}
++		}
++		
++		.mso h1,
++		.ie h1 {}
++		
++		.mso h1,
++		.ie h1 {
++			font-size: 26px !important;
++			line-height: 34px !important
++		}
++		
++		.mso h2,
++		.ie h2 {}
++		
++		.mso h2,
++		.ie h2 {
++			font-size: 20px !important;
++			line-height: 28px !important
++		}
++		
++		.mso h3,
++		.ie h3 {}
++		
++		.mso .column,
++		.ie .column,
++		.mso .column__background td,
++		.ie .column__background td {}
++	</style>
++</head>
++<!--[if mso]>
++	<body class="mso">
++<![endif]-->
++<!--[if !mso]><!-->
++
++<body style="margin: 0;padding: 0;-webkit-text-size-adjust: 100%;" class="full-padding">
++	<!--<![endif]-->
++	<div lang="x-wrapper" style="min-width: 320px;background-color: #f2f6f7;" class="wrapper">
++		<div style="Margin: 0 auto;max-width: 560px;min-width: 280px; width: 280px;width: calc(28000% - 173040px);" class="preheader">
++			<div style="border-collapse: collapse;display: table;width: 100%;">
++				<!--[if (mso)|(IE)]><table align="center" class="preheader" cellpadding="0" cellspacing="0"><tr><td style="width: 280px" valign="top"><![endif]-->
++				<div style="Float: left;font-size: 12px;line-height: 19px;max-width: 280px;min-width: 140px; width: 140px;width: calc(14000% - 78120px);padding: 10px 0 5px 0;color: #99b0b8;font-family: &quot;Open Sans&quot;,sans-serif;" class="snippet">
++
++				</div>
++				<!--[if (mso)|(IE)]></td><td style="width: 280px" valign="top"><![endif]-->
++				<div style="Float: left;font-size: 12px;line-height: 19px;max-width: 280px;min-width: 139px; width: 139px;width: calc(14100% - 78680px);padding: 10px 0 5px 0;text-align: right;color: #99b0b8;font-family: &quot;Open Sans&quot;,sans-serif;" class="webversion">
++
++				</div>
++				<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
++			</div>
++		</div>
++		<div id="emb-email-header-container" style="Margin: 0 auto;max-width: 600px;min-width: 320px; width: 320px;width: calc(28000% - 173000px);" class="header">
++			<!--[if (mso)|(IE)]><table align="center" class="header" cellpadding="0" cellspacing="0"><tr><td style="width: 600px"><![endif]-->
++			<div align="center" style="font-size: 26px;line-height: 32px;Margin-top: 6px;Margin-bottom: 20px;color: #c3ced9;font-family: Roboto,Tahoma,sans-serif;Margin-left: 20px;Margin-right: 20px;" class="logo emb-logo-margin-box">
++				<div align="center" id="emb-email-header" style="font-size:0px !important;line-height:0 !important;" class="logo-center">
++					<img width="141" alt="" src="{SITE_LOGO_IMG}" style="height: auto;width: 100%;border: 0;max-width: 141px;">
++				</div>
++			</div>
++			<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
++		</div>
++		<div style="Margin: 0 auto;max-width: 600px;min-width: 320px; width: 320px;width: calc(28000% - 173000px);overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;" class="layout one-col fixed-width">
++			<div emb-background-style="" style="border-collapse: collapse;display: table;width: 100%;background-color: #ffffff;" class="layout__inner">
++				<!--[if (mso)|(IE)]><table align="center" cellpadding="0" cellspacing="0"><tr class="layout-fixed-width" emb-background-style><td style="width: 600px" class="w560"><![endif]-->
++				<div style="text-align: left;color: #808285;font-size: 14px;line-height: 21px;font-family: &quot;Open Sans&quot;,sans-serif;max-width: 600px;min-width: 320px; width: 320px;width: calc(28000% - 167400px);" class="column">
++
++					<div style="Margin-left: 20px;Margin-right: 20px;Margin-top: 24px;">
++						<div style="line-height:10px;font-size:1px">&nbsp;</div>
++					</div>
++
++					<div style="Margin-left: 20px;Margin-right: 20px;">
++						<div style="line-height:5px;font-size:1px">&nbsp;</div>
++					</div>
++
++					<div style="Margin-left: 20px;Margin-right: 20px;">
++						<h1 style="Margin-top: 0;Margin-bottom: 20px;font-style: normal;font-weight: normal;color: #58595b;font-size: 22px;line-height: 31px;font-family: Bitter,Georgia,serif;text-align: center;">Last Topics While You Were Away</h1>
++					</div>
++
++					<div style="Margin-left: 20px;Margin-right: 20px;">
++						<div style="display: block;font-size: 2px;line-height: 2px;Margin-left: auto;Margin-right: auto;width: 40px;background-color: #b3cad0;Margin-bottom: 20px;" class="divider">&nbsp;</div>
++					</div>
++
++					<div style="Margin-left: 20px;Margin-right: 20px;">
++						<p style="Margin-top: 0;Margin-bottom: 20px;text-align: center;">Enquanto estiveste fora a laurear a pevide, houve nova atividade no fórum. Vê a nova tendência. Estamos animados para te ver novamente!</p>
++					    <p style="Margin-top: 10px;Margin-bottom: 20px;text-align: center;">{EMAIL_SIG}</p>
++					</div>
++
++					<div style="Margin-left: 20px;Margin-right: 20px;">
++						<div style="line-height:10px;font-size:1px">&nbsp;</div>
++					</div>
++
++					<div style="Margin-left: 20px;Margin-right: 20px;">
++						<div style="Margin-bottom: 20px;text-align: center;" class="btn btn--flat btn--large">
++							<!--[if !mso]--><a href="{BOARD_URL}" style="border-radius: 4px;display: inline-block;font-size: 14px;font-weight: bold;line-height: 24px;padding: 12px 24px;text-align: center;text-decoration: none !important;transition: opacity 0.1s ease-in;color: #60686b;background-color: #becdd1;font-family: 'Open Sans', sans-serif;"
++							target="_blank">Comunidade GoldTugAnime</a>
++							<!--[endif]-->
++							<!--[if mso]><p style="line-height:0;margin:0;">&nbsp;</p><v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" href="{BOARD_URL}" style="width:167px" arcsize="9%" fillcolor="#BECDD1" stroke="f"><v:textbox style="mso-fit-shape-to-text:t" inset="0px,11px,0px,11px"><center style="font-size:14px;line-height:24px;color:#60686B;font-family:sans-serif;font-weight:bold;mso-line-height-rule:exactly;mso-text-raise:4px">Discussion Board</center></v:textbox></v:roundrect><![endif]-->
++						</div>
++					</div>
++
++					<div style="Margin-left: 20px;Margin-right: 20px;Margin-bottom: 24px;">
++						<div style="line-height:15px;font-size:1px">&nbsp;</div>
++					</div>
++
++				</div>
++				<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
++			</div>
++		</div>
++
++		<div style="line-height:20px;font-size:20px;">&nbsp;</div>
++
++		<div style="Margin: 0 auto;max-width: 600px;min-width: 320px; width: 320px;width: calc(28000% - 173000px);overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;" class="layout one-col fixed-width">
++			<div emb-background-style="" style="border-collapse: collapse;display: table;width: 100%;background-color: #ffffff;" class="layout__inner">
++				<!--[if (mso)|(IE)]><table align="center" cellpadding="0" cellspacing="0"><tr class="layout-fixed-width" emb-background-style><td style="width: 600px" class="w560"><![endif]-->
++				<div style="text-align: left;color: #808285;font-size: 14px;line-height: 21px;font-family: &quot;Open Sans&quot;,sans-serif;max-width: 600px;min-width: 320px; width: 320px;width: calc(28000% - 167400px);" class="column">
++
++					<div style="Margin-left: 20px;Margin-right: 20px;Margin-top: 24px;Margin-bottom: 24px;">
++<!-- BEGIN mailrow -->
++						<p style="Margin-top: 0;Margin-bottom: 0;"><a href="{mailrow.U_TOPIC}" style="text-decoration: underline;transition: opacity 0.1s ease-in;color: #60686b;" target="_blank">{mailrow.TOPIC} em: {mailrow.FORUMS}</a></p>
++<!-- END mailrow -->
++						<p style="Margin-top: 20px;Margin-bottom: 0;">&nbsp;</p>
++					</div>
++
++				</div>
++				<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
++			</div>
++		</div>
++
++		<div style="line-height:20px;font-size:20px;">&nbsp;</div>
++
++		<div style="Margin: 0 auto;max-width: 600px;min-width: 320px; width: 320px;width: calc(28000% - 173000px);overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;" class="layout email-footer">
++			<div style="border-collapse: collapse;display: table;width: 100%;" class="layout__inner">
++				<!--[if (mso)|(IE)]><table align="center" cellpadding="0" cellspacing="0"><tr class="layout-email-footer"><td style="width: 400px;" valign="top" class="w360"><![endif]-->
++				<div style="text-align: left;font-size: 12px;line-height: 19px;color: #99b0b8;font-family: &quot;Open Sans&quot;,sans-serif;Float: left;max-width: 400px;min-width: 320px; width: 320px;width: calc(8000% - 47600px);" class="column wide">
++					<div style="Margin-left: 20px;Margin-right: 20px;Margin-top: 10px;Margin-bottom: 10px;">
++
++						<div>
++
++						</div>
++						<div style="Margin-top: 18px;">
++
++						</div>
++					</div>
++				</div>
++				<!--[if (mso)|(IE)]></td><td style="width: 200px;" valign="top" class="w160"><![endif]-->
++				<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
++			</div>
++		</div>
++		<div style="Margin: 0 auto;max-width: 600px;min-width: 320px; width: 320px;width: calc(28000% - 173000px);overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;" class="layout one-col email-footer">
++			<div style="border-collapse: collapse;display: table;width: 100%;" class="layout__inner">
++				<!--[if (mso)|(IE)]><table align="center" cellpadding="0" cellspacing="0"><tr class="layout-email-footer"><td style="width: 600px;" class="w560"><![endif]-->
++				<div style="text-align: center;font-size: 12px;line-height: 19px;color: #99b0b8;font-family: &quot;Open Sans&quot;,sans-serif;max-width: 600px;min-width: 320px; width: 320px;width: calc(28000% - 167400px);" class="column">
++					<div style="Margin-left: 20px;Margin-right: 20px;Margin-top: 10px;Margin-bottom: 10px;">
++						<div>
++							<span>
++              <a lang="en" href="{U_BOARD}" style="text-decoration: underline;transition: opacity 0.1s ease-in;color: #99b0b8;" target="_blank">Preferências</a>
++              &nbsp;&nbsp;|&nbsp;&nbsp;
++            </span>
++              <a href="{NEWSLETTER_OPTOUT}" style="text-decoration: underline;transition: opacity 0.1s ease-in;color: #99b0b8;" target="_blank">Cancelar Subscrição</a>
++						</div>
++					</div>
++				</div>
++				<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
++			</div>
++		</div>
++		<div style="line-height:40px;font-size:40px;">&nbsp;</div>
++
++	</div>
++
++</body>
++
++</html>
+\ No newline at end of file
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/language/pt/email/newsoverview_txt.txt" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/language/pt/email/newsoverview_txt.txt"
+new file mode 100644
+index 000000000..24fee63c8
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/language/pt/email/newsoverview_txt.txt"
+@@ -0,0 +1,17 @@
++Subject: Latest topic at "{SITENAME}"
++
++{SITENAME}
++
++Latest Topics
++Hi,
++It's time for another newsletter.
++We look forward to see you at {BOARD_URL} again.
++
++Forum				Topic
++<!-- BEGIN mailrow -->
++{mailrow.U_FORUM}				{mailrow.U_TOPIC}
++<!-- END mailrow -->
++
++
++{EMAIL_SIG}
++Don't want to receive our newsletter anymore, click here {NEWSLETTER_OPTOUT}
+\ No newline at end of file
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/language/pt/info_acp_newsletter.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/language/pt/info_acp_newsletter.php"
+new file mode 100644
+index 000000000..cc9168a39
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/language/pt/info_acp_newsletter.php"
+@@ -0,0 +1,181 @@
++<?php
++/**
++*
++* @package BBnewsletter
++* @copyright (c) 2016 SiteSplat All rights reserved
++* @license Proprietary
++*
++*/
++
++if (!defined('IN_PHPBB'))
++{
++	exit;
++}
++
++if (empty($lang) || !is_array($lang))
++{
++	$lang = array();
++}
++
++$lang = array_merge($lang, array(
++	'ACP_NEWSLETTER'			=> 'Newsletter',
++	'ACP_NEWSLETTER_EXPLAIN'	=> 'Setup your Newsletter, several options are available below. Please make sure your mailserver accepts all mails, otherwise it will use phpbb\'s mail settings to send emails in small batches. <br />The weekly and monthly "Catch-up" forum news are sent out by the cron task. Install <a href="https://github.com/ForumHulp/cronstatus" target="_blank">Cronstatus extension</a> and select "Run cron always" in the options to run more often the "Catch-up" News (This is especially useful for small forums). <br />For HTML e-mails install <a href=" https://github.com/ForumHulp/htmlemail" target="_blank">HTML emails Extension</a> which enables the HTML settings.<br />',
++    'FORUMS_NEWS_FROM'		    => 'Newsletter forum source',
++	'FORUMS_FROM_EXPLAIN'		=> 'Select the forums you would like the users to receive the news from',
++	'SEND_IMMEDIATELY'			=> 'Send immediately',
++	'SEND_IMMEDIATELY_EXPLAIN'	=> 'Attempt to send the emails immediately. This depends on the server email configuration parameters',
++	'PERIOD'					=> 'Email Overview (or Catch-up) Period',
++	'PERIOD_EXPLAIN'			=> 'This will send automatic "Catch-up"  emails to the users that are subscribed. The e-mail will be generated based on the new topics in the forum. The user will receive an email with the purpose of engaging the user\'s interest in the recent board\'s activity. Edit the templates file named newsletter_html.txt for the HTML version and newsletter_txt.txt for the TXT version from:<br /> <code>root\ext\sitesplat\newsletter\language\en\email\</code> <br /> To learn how to send out professional looking HTML emails check out the tutorials over at <a href=" https://sitesplat.com/" target="_blank">sitesplat.com</a> or click the "Tutorials" label above.',
++	'WEEKLY'					=> 'Weekly',
++	'MONTHLY'					=> 'Monthly',
++	'NO_OVERVIEW'				=> 'None',
++	'PERIOD_SEND'				=> 'Set period for automatic newsletter',
++	'SEND_TO_GROUP'				=> 'Send to group',
++	'SEND_TO_USERS'				=> 'Send to user(s)',
++	'SEND_TO_USERS_EXPLAIN'		=> 'When using this field it will override the "Send to Group" option above. Each user on a new line',
++	'ALL_USERS'					=> 'All users',
++	'NEW_USER'					=> 'Allow new users',
++	'MAIL_LOW_PRIORITY'			=> 'Low',
++	'MAIL_NORMAL_PRIORITY'		=> 'Normal',
++	'MAIL_HIGH_PRIORITY'		=> 'High',
++	'MAIL_PRIORITY'				=> 'Mail priority',
++	'USE_HTML'					=> 'Use HTML emails',
++	'COMPOSE_HTML'				=> 'Send manually',
++	'COMPOSE_HTML_EXPLAIN'		=> 'If "Send manually" is selected the HTML editor will be available to send custom emails in HTML format',
++	'MASS_MESSAGE'				=> 'Message (Newsletter Body)',
++	'MASS_MESSAGE_EXPLAIN'		=> 'HTML message will be stripped if HTML email Extension is not enabled. To use the HTML editor click on "Tools" then "Source code" and enter the HTML code in the code editor ',
++	'FHHTML_EMAIL_NOT_ENABLED'	=> 'HTML email extension not enabled. Download it from https://github.com/ForumHulp/htmlemail',
++	'FHHTML_EMAIL_DOWNLOAD'	    => 'HTML email Extension not enabled. Download it from <a href="https://github.com/ForumHulp/htmlemail" target="blank">GithHub HTML Email Ext</a>',
++	'LAST_SEND'					=> '<span id="viewsubscribers" class="label label-info" title="View subscribers">%1$s Members</span> subscribed, last letter was sent on <strong class="text-info">%2$s</strong>',
++	'LAST_SEND_LETTERS'			=> 'Last newsletters',
++	'LAST_SEND_EXPLAIN'			=> '**Please note, new registered users are automatically subscribed. (Click "X Members" above to view the users list)',
++	'LAST_NEWSLETTERS_EXPLAIN'	=> '**Please note, the following template visualized on the single emails below does NOT reflect 100% the email that was sent out. This is due to phpBB\'s ACP stylesheet obsolete CSS reset rules. Refer to your email copy or front-end archive for the exact email accuracy.<br /> This is a list with the sole purpose of keeping track of the emails and users in a simple manner.<br />Always save a copy of the composed HTML email before sending it out if you wish to re-use it in the future.',
++	'NEWS_PAGE'					=> 'Visible',
++	'HIDE'						=> 'Hide',
++	'SHOW'						=> 'Show',
++	'DELETE_MAIL_SUCCES'		=> 'Newsletter deleted',
++	'ACP_NEWSOVERVIEW_SEND'		=> 'Newsletter(s) sent successfully',
++	'ACP_NEWSOVERVIEW_SAVED'	=> 'Settings saved successfully',
++	
++	'SITESPLAT_COM'		        => 'https://sitesplat.com',
++	'SITESPLAT_COPY'		    => '&#169; SiteSplat',
++	'LICENSE_INFO'		        => 'Proprietary - SiteSplat All rights reserved',
++	'EXTENSION_DEVELOPER'	    => 'Developer',
++	'ACP_NOTICE_CLOSE'			=> 'Close',
++	'ACP_NEWS_VERSION'          => '1.0.5',
++	'ACP_LOADING'		        => 'Loading... Hold on',
++	'FORUM_CONTENT'		        => 'forum content',
++	'EXT_NEWS_DESCRIPTION_PAGE'	=> 'A Newsletter system with an archive, weekly, monthly and many more options to run your own HTML style newsletter like a pro!',
++	'EXT_NEWS_TASKS_1'			=> 'Newsletter Archive',
++	'EXT_NEWS_TASKS_2'			=> 'Full HTML Enabled',
++	'EXT_NEWS_TASKS_3'			=> 'Synchronization with Cron tasks and compatible with <a href="https://www.phpbb.com/customise/db/extension/cronstatus/">Cron Status</a>',
++	'EXT_NEWS_TASKS_4'			=> 'Scheduled Newsletter',
++	'EXT_NEWS_TASKS_5'			=> 'Checkout the other premium addons on <a href="https://sitesplat.com/phpBB3/marketplace.php">sitesplat.com/marketplace.php</a>',
++	'EXT_NEWS_TASKS_6'			=> 'phpBB 3.2 ready',
++
++	'NEWS_SUBSCRIBERS_INFO'     => 'Subscribers and news info',
++	'NEWS_TRICKS_TITLE'         => 'Tips and Tricks',
++	'ACP_NEWS_TRICK_EXPLAIN'	=> '<p>Does your ISP limit the number of emails you can send each day?</p>
++									<p><strong>Of course they do!</strong>
++									</p>
++									<p>Every outgoing SMTP mail server is guided by a provider’s email policy which includes hourly and/or daily email send limits. This policy will ultimately determine how many emails you can send each day. You can find a list of the hourly and daily send limits for most of the major ISPs, web hosting companies and Free email address providers below.</p>
++									<p><strong><a title="Email sending limits for isp, web hosting and free email providers" href="http://group-mail.com/sending-email/email-sending-limits-for-isp-web-hosting-and-free-email-providers/">Email Sending Limits of ISP, Web Hosting and Free Email Providers</a></strong>
++									</p>
++									<p>If you try to send more email than the hourly or daily email sending limits of your mail server, you will notice errors being returned after the specified quota is met, saying something along the lines of:<em> </em>
++									</p>
++									<blockquote>
++										<p><em>you have reached your daily sending quota</em>…</p>
++									</blockquote>
++									<p>If you surpass the daily <a title="SMTP email sending limits" href="http://group-mail.com/sending-email/email-sending-limits-for-isp-web-hosting-and-free-email-providers/">SMTP email sending limits</a> of your provider, you will generally have to wait 24 hours before you can send more email through that particular server.</p>
++									<p>But, what are the hourly or daily email sending limits for <em>your</em> email server?</p>
++									<ul>
++										<li>The Gmail mail server send limit is approximately 100-150 emails per day when connected to the server from a remote email client. You can send 500 emails each day through the Gmail SMTP server when logged into their web interface.</li>
++										<li>The Comcast mail server limits residential customers to send 1,000 messages per day. Comcast Business customers can send 24,000 emails per day through the Comcast outgoing SMTP mail server.</li>
++										<li>The basic GoDaddy email server limits senders to send&nbsp; only 250 outgoing emails per day, but you can <a title="send more email by adding SMTP relays to your GoDaddy account" href="http://group-mail.com/sending-email/how-to-increase-your-godaddy-email-sending-limits/">send more email by adding SMTP relays to your GoDaddy account</a>
++										</li>
++									</ul>
++									<p>&nbsp;</p>
++									<p>So, what’s a guy to do if he needs to get his monthly email newsletter out to 5,000 eager subscribers but his ISP has a daily send limit of 500 emails per day?</p>
++									<p><strong>What can you do if your mail server has limits that don’t support the size of your mailing list?</strong>
++									</p>
++									<p>If your current outgoing SMTP email server does not support your email list size or sending frequency, you have a variety of options:</p>
++									<p style="padding-left: 30px;">1. Contact the host of your outgoing SMTP mail server(s) and ask if they have a business account that lets you send more emails each day to support your business.</p>
++									<p style="padding-left: 30px;">2. Use GroupMail’s <a title="sending email without an external SMTP mail server" href="http://group-mail.com/sending-email/sending-email-without-an-external-smtp-mail-server/">Direct Send option</a>, which allows you to bypass your external SMTP server altogether and send email directly from your computer to your recipients using GroupMail’s own internal SMTP engine.</p>
++									<p style="padding-left: 30px;">3. Use an outgoing SMTP service like <a title="SMTP2Go outgoing relay pricing" href="http://groupmail.smtp2go.com">SMTP2Go</a> to relay your large email campaigns.</p>
++									<p style="padding-left: 30px;">4. Find a web hosting company who has daily email sending limits that meet your needs.</p>
++									<p style="padding-left: 30px;">5. Setup your own <a href="http://www.msexchange.org/tutorials/MF002.html">MS Exchange Server</a> and configure it for SMTP email delivery.</p>
++									<p>So, while GroupMail allows you to send and manage email lists of an <strong>unlimited</strong> size; the success of email delivery to large groups is ultimately dependent upon the sending limits set forth in the email sending policy of the SMTP mail server you are using.</p>
++									<p><strong>Related articles you might find interesting:</strong>
++									</p>
++									<p><a title="email sending limits of ISPs web hosting and free email providers" href="http://group-mail.com/sending-email/email-sending-limits-for-isp-web-hosting-and-free-email-providers/">Email Sending Limits for ISPs, Web Hosting and Free Email Providers</a>
++									</p>
++									<p><a title="Common email error code descriptions and fixes" href="http://group-mail.com/email-error-codes/common-email-error-codes/">Common Email Error Code Descriptions and Fixes</a>
++									</p>
++									<p><a title="Free Email Newsletter and Marketing Software and Services" href="http://group-mail.com/email-marketing/free-email-newsletter-and-marketing-software-and-services/">Free Email Newsletter and Marketing Software and Services</a>
++									</p>
++									<p><a title="Email Settings for the Most Common Email Server hosts" href="http://group-mail.com/category/email-settings/">Email Settings for the Most Common Email Server Hosts</a>
++									</p>
++									<p><a title="step by step guide for email setup and delivery" href="http://group-mail.com/getting-started-with-groupmail/step-by-step-guide-for-email-setup-and-delivery/">Step-by-Step Guide for Email Setup and Delivery</a>
++									</p>
++									<p>&nbsp;</p>
++									<hr>
++									<p></p>',
++	
++	'EXT_NEWS_TUTORIALS_TITLE'  => 'Tutorials',
++	'EXT_NEWS_TUTORIALS_EXPLAIN'=> '<li><p>Templates</p>
++					<ul>
++					<li><a href="http://htmlemailboilerplate.com/" target="_blank"><strong>HTML Email Boilerplate</strong></a>: A great <strong>starting point</strong> for coding emails.</li>
++					<li><a href="http://www.campaignmonitor.com/templates/" target="_blank"><strong>Campaign Monitor Templates</strong></a>: Template builder + free downloadable templates</li>
++					</ul>
++					</li>
++					
++					<li><p>Tutorials &amp; Guides</p>
++
++					<ul>
++					<li><a href="http://kb.mailchimp.com/article/how-to-code-html-emails" target="_blank"><strong>How To Code HTML Emails (Mailchimp)</strong></a>: How HTML email works, basic concepts, best practices, tips and tricks</li>
++					<li><a href="http://www.smashingmagazine.com/2010/01/19/design-and-build-an-email-newsletter-without-losing-your-mind/" target="_blank"><strong>Design and Build Email Newsletters Without Losing Your Mind (and Soul)</strong></a>:  information you need to plan, design and build an HTML newsletter that renders well</li>
++					<li><a href="http://mailchimp.com/resources/guides/email-marketing-field-guide/html/" target="_blank"><strong>Email Marketing Field Guide (Mailchimp)</strong></a></li>
++					<li><a href="http://mattmedia.net/2007/08/23/8-html-email-tips-i-wish-i-knew-sooner/" target="_blank"><strong>8 HTML Email Tips I Wish I’d Known Sooner</strong></a></li>
++					<li><a href="http://www.campaignmonitor.com/css/" target="_blank"><strong>The Ultimate Guide</a>: From Campaign Monitor</strong></li>
++					<li><a href="http://css-tricks.com/using-css-in-html-emails-the-real-story/" target="_blank"><strong>CSS Tricks: Using CSS in HTML Emails</strong></a>: Some "I told you so"\'s and tips about HTML emails and CSS.</li>
++					</ul>
++					</li>
++					
++					<li><p>Testing</p>
++
++					<ul>
++					<li><a href="http://www.emailonacid.com/" target="_blank"><strong>Email on Acid</strong></a>: Free and paid testing</li>
++					<li><a href="http://litmus.com/" target="_blank"><strong>Litmus</strong></a></li>
++					</ul>
++					</li>
++					
++					<li><p>Other Resources</p>
++
++					<ul>
++					<li><a href="http://www.campaignmonitor.com/resources/will-it-work/email-clients/" target="_blank"><strong>Campaign Monitor\'s Popular E-Mail Clients</strong></a></li>
++					</ul>
++					</li>',
++	
++	
++	'NEWSLETTER_NOTICE'			=> '<div class="phpinfo"><p>The settings for this extension are under <strong>%1$s &#187; %2$s &#187; %3$s</strong>. <br />Please note, at first setup when the period is set (for example weekly) and the format (HTML) the first automatic newsletter overview is sent out immediately right after the settings are saved! <br />This is needed to start the Synchronization. With this in mind, consider using a test board before using the extension to make sure the end result of the newlsetter is the preferred look.</p></div>',
++	'SS_HELPER_NOTY'			=> 'SiteSplat BBcore does not exist!<br />Download the <a href="https://sitesplat.com" target="_blank">BBcore</a> and copy the BBcore folder into your sitesplat extension folder.',
++));
++
++// Description of Donations extension
++$lang = array_merge($lang, array(
++	'DESCRIPTION_PAGE'		=> 'Description',
++	'DESCRIPTION_NOTICE'	=> 'Extension note',
++	'ext_details' => array(
++		'details' => array(
++			'DESCRIPTION_1'	=> 'HTML newsletter',
++			'DESCRIPTION_2'	=> 'Groupselect',
++			'DESCRIPTION_3'	=> 'Weekly / monthly news overview',
++			'DESCRIPTION_4'	=> 'Send immediately or in batch',
++			'DESCRIPTION_5'	=> 'Overview subscribers',
++		),
++		'note' => array(
++			'NOTICE_1'		=> '<a href="https://github.com/ForumHulp/htmlemail" target="_blank">HTML email extension</a> is needed to enable the HTML settings.',
++			'NOTICE_2'		=> 'phpBB 3.2 ready'
++		)
++	)
++));
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/language/pt/newsletter.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/language/pt/newsletter.php"
+new file mode 100644
+index 000000000..02aa2312c
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/language/pt/newsletter.php"
+@@ -0,0 +1,40 @@
++<?php
++/**
++*
++* @package BBnewsletter
++* @copyright (c) 2016 SiteSplat All rights reserved
++* @license Proprietary
++*
++*/
++
++if (!defined('IN_PHPBB'))
++{
++	exit;
++}
++
++if (empty($lang) || !is_array($lang))
++{
++	$lang = array();
++}
++
++$lang = array_merge($lang, array(
++	'NEWSLETTER'				=> 'Newsletter',
++	'OVERVIEW'					=> 'Welcome to our Newsletter! :-) On this page you will find the latest Newsletters as well as the past years archives.',
++
++	'SUBSCRIBE_NO'				=> 'I do NOT want to receive the Newsletter anymore',
++	'SUBSCRIBE_YES'				=> 'Yes I want to receive the Newsletter',
++	'SUBSCRIBE_BTN_NO'			=> 'Cancel',
++	'SUBSCRIBE_BTN_YES'			=> 'Subscribe',
++	'SUBSCRIBE_CONFIRM_NO'		=> 'Please submit to cancel your subscription',
++	'SUBSCRIBE_CONFIRM_YES'		=> 'Please submit to confirm your subscription',
++
++	'SUBSCRIBE_Y_EMAIL'			=> 'Your email',
++	'SUBSCRIBE'					=> 'Subscribe to',
++	'UNSUBSCRIBE'				=> 'Unsubscribe from',
++	'SUBSCRIBE_INFO'			=> 'Our newsletter. Unsubscribed members won\'t receive our periodic News overview anymore.',
++	
++	'OVERVIEW_ARCHIVE'			=> 'Archive',
++	'ARCHIVES'					=> 'Archives',
++	'SUBSCRIBED'				=> 'Thanks for subscribing! You will receive our newsletter from today on!',
++	'UNSUBSCRIBED'				=> 'Successfully unsubscribed, you won\'t receive our newsletter any longer'
++));
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/language/pt_preao/email/index.htm" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/language/pt_preao/email/index.htm"
+new file mode 100644
+index 000000000..ee1f723a7
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/language/pt_preao/email/index.htm"
+@@ -0,0 +1,10 @@
++<html>
++<head>
++<title></title>
++<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
++</head>
++
++<body bgcolor="#FFFFFF" text="#000000">
++
++</body>
++</html>
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/language/pt_preao/email/newsletter_html.txt" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/language/pt_preao/email/newsletter_html.txt"
+new file mode 100644
+index 000000000..127a2a9ec
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/language/pt_preao/email/newsletter_html.txt"
+@@ -0,0 +1,293 @@
++Subject: {SUBJECT}
++
++<!DOCTYPE html>
++<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
++
++<head>
++  <meta charset="utf-8"> <!-- utf-8 works for most cases -->
++  <meta name="viewport" content="width=device-width"> <!-- Forcing initial-scale shouldn't be necessary -->
++  <meta http-equiv="X-UA-Compatible" content="IE=edge"> <!-- Use the latest (edge) version of IE rendering engine -->
++  <meta name="x-apple-disable-message-reformatting"> <!-- Disable auto-scale in iOS 10 Mail entirely -->
++
++  <!-- Web Font / @font-face : BEGIN -->
++  <!-- NOTE: If web fonts are not required, lines 10 - 27 can be safely removed. -->
++
++  <!-- Desktop Outlook chokes on web font references and defaults to Times New Roman, so we force a safe fallback font. -->
++  <!--[if mso]>
++        <style>
++            * {
++                font-family: sans-serif !important;
++            }
++        </style>
++    <![endif]-->
++
++  <!-- All other clients get the webfont reference; some will render the font and others will silently fail to the fallbacks. More on that here: http://stylecampaign.com/blog/2015/02/webfont-support-in-email/ -->
++  <!--[if !mso]><!-->
++  <!-- insert web font reference, eg: <link href='https://fonts.googleapis.com/css?family=Roboto:400,700' rel='stylesheet' type='text/css'> -->
++  <!--<![endif]-->
++
++  <!-- Web Font / @font-face : END -->
++
++  <!-- CSS Reset : BEGIN -->
++  <style>
++    /* What it does: Remove spaces around the email design added by some email clients. */
++    /* Beware: It can remove the padding / margin and add a background color to the compose a reply window. */
++    html,
++    body {
++      margin: 0 auto !important;
++      padding: 0 !important;
++      height: 100% !important;
++      width: 100% !important;
++    }
++
++    /* What it does: Stops email clients resizing small text. */
++    * {
++      -ms-text-size-adjust: 100%;
++      -webkit-text-size-adjust: 100%;
++    }
++
++    /* What it does: Centers email on Android 4.4 */
++    div[style*="margin: 16px 0"] {
++      margin: 0 !important;
++    }
++
++    /* What it does: Stops Outlook from adding extra spacing to tables. */
++    table,
++    td {
++      mso-table-lspace: 0pt !important;
++      mso-table-rspace: 0pt !important;
++    }
++
++    /* What it does: Fixes webkit padding issue. Fix for Yahoo mail table alignment bug. Applies table-layout to the first 2 tables then removes for anything nested deeper. */
++    table {
++      border-spacing: 0 !important;
++      border-collapse: collapse !important;
++      table-layout: fixed !important;
++      margin: 0 auto !important;
++    }
++
++    table table table {
++      table-layout: auto;
++    }
++
++    /* What it does: Uses a better rendering method when resizing images in IE. */
++    img {
++      -ms-interpolation-mode: bicubic;
++    }
++
++    /* What it does: A work-around for email clients meddling in triggered links. */
++    *[x-apple-data-detectors],
++    /* iOS */
++    .x-gmail-data-detectors,
++    /* Gmail */
++    .x-gmail-data-detectors *,
++    .aBn {
++      border-bottom: 0 !important;
++      cursor: default !important;
++      color: inherit !important;
++      text-decoration: none !important;
++      font-size: inherit !important;
++      font-family: inherit !important;
++      font-weight: inherit !important;
++      line-height: inherit !important;
++    }
++
++    /* What it does: Prevents Gmail from displaying an download button on large, non-linked images. */
++    .a6S {
++      display: none !important;
++      opacity: 0.01 !important;
++    }
++
++    /* If the above doesn't work, add a .g-img class to any image in question. */
++    img.g-img+div {
++      display: none !important;
++    }
++
++    /* What it does: Prevents underlining the button text in Windows 10 */
++    .button-link {
++      text-decoration: none !important;
++    }
++
++    /* What it does: Removes right gutter in Gmail iOS app: https://github.com/TedGoas/Cerberus/issues/89  */
++    /* Create one of these media queries for each additional viewport size you'd like to fix */
++    /* Thanks to Eric Lepetit (@ericlepetitsf) for help troubleshooting */
++    @media only screen and (min-device-width: 375px) and (max-device-width: 413px) {
++
++      /* iPhone 6 and 6+ */
++      .email-container {
++        min-width: 375px !important;
++      }
++    }
++
++    @media screen and (max-width: 480px) {
++
++      /* What it does: Forces Gmail app to display email full width */
++      u~div .email-container {
++        min-width: 100vw;
++        width: 100% !important;
++      }
++    }
++  </style>
++  <!-- CSS Reset : END -->
++
++  <!-- Progressive Enhancements : BEGIN -->
++  <style>
++    /* What it does: Hover styles for buttons */
++    .button-td,
++    .button-a {
++      transition: all 100ms ease-in;
++    }
++
++    .button-td:hover,
++    .button-a:hover {
++      background: #CC9900 !important;
++      border-color: #CC9900 !important;
++    }
++
++    /* Define o estilo dos links */
++    a:link {
++      color: #CC9900;
++      background-color: transparent;
++      text-decoration: none;
++    }
++
++    a:visited {
++      color: #CC9900;
++      background-color: transparent;
++      text-decoration: none;
++    }
++
++    a:hover {
++      color: #CC9900;
++      background-color: transparent;
++      text-decoration: underline;
++    }
++
++    a:active {
++      color: #CC9900;
++      background-color: transparent;
++      text-decoration: underline;
++    }
++
++    /* Media Queries */
++    @media screen and (max-width: 600px) {
++
++      .email-container {
++        width: 100% !important;
++        margin: auto !important;
++      }
++
++      /* What it does: Forces elements to resize to the full width of their container. Useful for resizing images beyond their max-width. */
++      .fluid {
++        max-width: 100% !important;
++        height: auto !important;
++        margin-left: auto !important;
++        margin-right: auto !important;
++      }
++
++      /* What it does: Forces table cells into full-width rows. */
++      .stack-column,
++      .stack-column-center {
++        display: block !important;
++        width: 100% !important;
++        max-width: 100% !important;
++        direction: ltr !important;
++      }
++
++      /* And center justify these ones. */
++      .stack-column-center {
++        text-align: center !important;
++      }
++
++      /* What it does: Generic utility class for centering. Useful for images, buttons, and nested tables. */
++      .center-on-narrow {
++        text-align: center !important;
++        display: block !important;
++        margin-left: auto !important;
++        margin-right: auto !important;
++        float: none !important;
++      }
++
++      table.center-on-narrow {
++        display: inline-block !important;
++      }
++
++      /* What it does: Adjust typography on small screens to improve readability */
++      .email-container p {
++        font-size: 17px !important;
++      }
++    }
++  </style>
++  <!-- Progressive Enhancements : END -->
++
++  <!-- What it does: Makes background images in 72ppi Outlook render at correct size. -->
++  <!--[if gte mso 9]>
++    <xml>
++        <o:OfficeDocumentSettings>
++            <o:AllowPNG/>
++            <o:PixelsPerInch>96</o:PixelsPerInch>
++        </o:OfficeDocumentSettings>
++    </xml>
++    <![endif]-->
++
++</head>
++
++<body width="100%" bgcolor="#222222" style="margin: 0; mso-line-height-rule: exactly;">
++  <center style="width: 100%; background: #fafafa; text-align: left;">
++
++    <!-- Email Header : BEGIN -->
++    <table role="presentation" cellspacing="0" cellpadding="0" border="0" align="center" width="600" style="margin: auto;" class="email-container" bgcolor="#1E1E1E">
++      <tr>
++        <td style="padding: 20px 0; text-align: center">
++          <a href="https://goldtuganime.com" target="_blank"><img src="https://upload.goldtuganime.com/redes-sociais/GTA_Logo_Newsletter.png" width="282" border="0" style="height: auto; font-family: sans-serif; font-size: 15px; line-height: 140%; color: #555555;"></a>
++        </td>
++      </tr>
++    </table>
++    <!-- Email Header : END -->
++
++    {MESSAGE}
++
++    <!-- Email Footer : BEGIN -->
++    <table role="presentation" bgcolor="#1E1E1E" cellspacing="0" cellpadding="0" border="0" align="center" width="100%" style="max-width: 600px; font-family: sans-serif; color: #888888; font-size: 11px; line-height: 140%;">
++      <tr>
++        <td style="padding: 10px 10px; width: 100%; font-family: sans-serif; font-size: 12px; line-height: 140%; text-align: center; color: #888888;" class="x-gmail-data-detectors">
++          <table width="300" border="0" cellspacing="10" cellpadding="10">
++            <tbody>
++              <tr>
++                <td><a href="https://www.facebook.com/goldtuganimeoficial/" target="_blank"><img src="https://upload.goldtuganime.com/redes-sociais/facebook-Y.png" height="24" width="24" class=""></a></td>
++                <td><a href="https://www.instagram.com/goldtuganime/" target="_blank"><img src="https://upload.goldtuganime.com/redes-sociais/instagram-Y.png" height="24" width="24" class=""></a></td>
++                <td><a href="https://discord.gg/Zk8CCZUG/" target="_blank"><img src="https://upload.goldtuganime.com/redes-sociais/discord-Y.png" height="24" width="24" class=""></a></td>
++                <td><a href="https://www.youtube.com/@GoldTugAnimeOFICIAL" target="_blank"><img src="https://upload.goldtuganime.com/redes-sociais/youtube-Y.png" height="24" width="24" class=""></a></td>
++                <td><a href="https://goldtuganime.com" target="_blank"><img src="https://upload.goldtuganime.com/redes-sociais/website-Y.png" height="24" width="24" class=""></a></td>
++              </tr>
++            </tbody>
++          </table>
++
++        </td>
++      </tr>
++    </table>
++    <table role="presentation" cellspacing="0" cellpadding="0" border="0" align="center" width="100%" style="max-width: 600px; font-family: sans-serif; color: #888888; font-size: 11px; line-height: 140%;">
++      <tr>
++        <td style="padding: 10px 10px; width: 100%; font-family: sans-serif; font-size: 12px; line-height: 140%; text-align: center; color: #888888;" class="x-gmail-data-detectors"><em>Copyright © 2023 | <a href="https://goldtuganime.com" target="_blank">GoldTugAnime</a> | Todos os direitos reservados.</em></td>
++      </tr>
++      <tr>
++        <td>
++          <table width="400" border="0" cellspacing="0" cellpadding="0">
++            <tbody>
++              <tr>
++                <td width="400" height="2" bgcolor="#CC9900" align="center" valign="bottom" style="padding: 0px;"></td>
++              </tr>
++            </tbody>
++          </table>
++        </td>
++      </tr>
++      <tr>
++        <td style="padding: 10px 10px; width: 100%; font-family: sans-serif; font-size: 8px; line-height: 140%; text-align: center; color: #888888;" class="x-gmail-data-detectors">Estás a receber este e-mail porque estás inscrito no nosso fórum. <a href="{NEWSLETTER_ONLINE}" target="_blank">Vê aqui</a> que newsletters já recebeste ou remove o teu endereço electrónico da nossa lista através do link <a href="{NEWSLETTER_OPTOUT}" target="_blank">remover subscrição</a>, caso pretendas.
++        </td>
++      </tr>
++    </table>
++    <!-- Email Footer : END -->
++  </center>
++</body>
++
++</html>
+\ No newline at end of file
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/language/pt_preao/email/newsletter_txt.txt" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/language/pt_preao/email/newsletter_txt.txt"
+new file mode 100644
+index 000000000..0b839ca10
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/language/pt_preao/email/newsletter_txt.txt"
+@@ -0,0 +1,6 @@
++Subject: Newsletter de {SITENAME}
++
++{MESSAGE}
++
++Todas as newsletter: {NEWSLETTER_ONLINE}
++Não desejas continuar a receber a nossa newsletter? Clica aqui: {NEWSLETTER_OPTOUT}
+\ No newline at end of file
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/language/pt_preao/email/newsoverview_html.txt" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/language/pt_preao/email/newsoverview_html.txt"
+new file mode 100644
+index 000000000..66cf8a5ba
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/language/pt_preao/email/newsoverview_html.txt"
+@@ -0,0 +1,961 @@
++Subject: Últimas Novidades "{SITENAME}"
++
++<html xmlns="http://www.w3.org/1999/xhtml" style="margin: 0;padding: 0;">
++<!--<![endif]-->
++
++<head>
++	<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
++	<!--[if !mso]><!-->
++	<meta content="IE=edge" http-equiv="X-UA-Compatible">
++	<!--<![endif]-->
++	<meta content="width=device-width" name="viewport">
++	<style type="text/css">
++		@media only screen and (min-width: 620px) {
++			* [lang=x-wrapper] h1 {
++				font-size: 26px !important;
++				line-height: 34px !important;
++			}
++			* [lang=x-wrapper] h2 {
++				font-size: 20px !important;
++				line-height: 28px !important;
++			}
++			* div [lang=x-size-8] {
++				font-size: 8px !important;
++				line-height: 14px !important;
++			}
++			* div [lang=x-size-9] {
++				font-size: 9px !important;
++				line-height: 16px !important;
++			}
++			* div [lang=x-size-10] {
++				font-size: 10px !important;
++				line-height: 18px !important;
++			}
++			* div [lang=x-size-11] {
++				font-size: 11px !important;
++				line-height: 19px !important;
++			}
++			* div [lang=x-size-12] {
++				font-size: 12px !important;
++				line-height: 19px !important;
++			}
++			* div [lang=x-size-13] {
++				font-size: 13px !important;
++				line-height: 21px !important;
++			}
++			* div [lang=x-size-14] {
++				font-size: 14px !important;
++				line-height: 21px !important;
++			}
++			* div [lang=x-size-15] {
++				font-size: 15px !important;
++				line-height: 23px !important;
++			}
++			* div [lang=x-size-16] {
++				font-size: 16px !important;
++				line-height: 24px !important;
++			}
++			* div [lang=x-size-17] {
++				font-size: 17px !important;
++				line-height: 26px !important;
++			}
++			* div [lang=x-size-18] {
++				font-size: 18px !important;
++				line-height: 26px !important;
++			}
++			* div [lang=x-size-18] {
++				font-size: 18px !important;
++				line-height: 26px !important;
++			}
++			* div [lang=x-size-20] {
++				font-size: 20px !important;
++				line-height: 28px !important;
++			}
++			* div [lang=x-size-22] {
++				font-size: 22px !important;
++				line-height: 31px !important;
++			}
++			* div [lang=x-size-24] {
++				font-size: 24px !important;
++				line-height: 32px !important;
++			}
++			* div [lang=x-size-26] {
++				font-size: 26px !important;
++				line-height: 34px !important;
++			}
++			* div [lang=x-size-28] {
++				font-size: 28px !important;
++				line-height: 36px !important;
++			}
++			* div [lang=x-size-30] {
++				font-size: 30px !important;
++				line-height: 38px !important;
++			}
++			* div [lang=x-size-32] {
++				font-size: 32px !important;
++				line-height: 40px !important;
++			}
++			* div [lang=x-size-34] {
++				font-size: 34px !important;
++				line-height: 43px !important;
++			}
++			* div [lang=x-size-36] {
++				font-size: 36px !important;
++				line-height: 43px !important;
++			}
++			* div [lang=x-size-40] {
++				font-size: 40px !important;
++				line-height: 47px !important;
++			}
++			* div [lang=x-size-44] {
++				font-size: 44px !important;
++				line-height: 50px !important;
++			}
++			* div [lang=x-size-48] {
++				font-size: 48px !important;
++				line-height: 54px !important;
++			}
++			* div [lang=x-size-56] {
++				font-size: 56px !important;
++				line-height: 60px !important;
++			}
++			* div [lang=x-size-64] {
++				font-size: 64px !important;
++				line-height: 63px !important;
++			}
++		}
++	</style>
++	<style type="text/css">
++		body {
++			margin: 0;
++			padding: 0;
++		}
++		
++		table {
++			border-collapse: collapse;
++			table-layout: fixed;
++		}
++		
++		* {
++			line-height: inherit;
++		}
++		
++		[x-apple-data-detectors],
++		[href^="tel"],
++		[href^="sms"] {
++			color: inherit !important;
++			text-decoration: none !important;
++		}
++		
++		.wrapper .footer__share-button a:hover,
++		.wrapper .footer__share-button a:focus {
++			color: #ffffff !important;
++		}
++		
++		.btn a:hover,
++		.btn a:focus,
++		.footer__share-button a:hover,
++		.footer__share-button a:focus,
++		.email-footer__links a:hover,
++		.email-footer__links a:focus {
++			opacity: 0.8;
++		}
++		
++		.ie .btn {
++			width: 100%;
++		}
++		
++		.ie .column,
++		[owa] .column,
++		.ie .gutter,
++		[owa] .gutter {
++			display: table-cell;
++			float: none !important;
++			vertical-align: top;
++		}
++		
++		.ie .preheader,
++		[owa] .preheader,
++		.ie .email-footer,
++		[owa] .email-footer {
++			width: 560px !important;
++		}
++		
++		.ie .snippet,
++		[owa] .snippet,
++		.ie .webversion,
++		[owa] .webversion {
++			width: 280px !important;
++		}
++		
++		.ie .header,
++		[owa] .header,
++		.ie .layout,
++		[owa] .layout,
++		.ie .one-col .column,
++		[owa] .one-col .column {
++			width: 600px !important;
++		}
++		
++		.ie .fixed-width.has-border,
++		[owa] .fixed-width.has-border,
++		.ie .has-gutter.has-border,
++		[owa] .has-gutter.has-border {
++			width: 602px !important;
++		}
++		
++		.ie .two-col .column,
++		[owa] .two-col .column {
++			width: 300px !important;
++		}
++		
++		.ie .three-col .column,
++		[owa] .three-col .column,
++		.ie .narrow,
++		[owa] .narrow {
++			width: 200px !important;
++		}
++		
++		.ie .wide,
++		[owa] .wide {
++			width: 400px !important;
++		}
++		
++		.ie .two-col.has-gutter .column,
++		[owa] .two-col.x_has-gutter .column {
++			width: 290px !important;
++		}
++		
++		.ie .three-col.has-gutter .column,
++		[owa] .three-col.x_has-gutter .column,
++		.ie .has-gutter .narrow,
++		[owa] .has-gutter .narrow {
++			width: 188px !important;
++		}
++		
++		.ie .has-gutter .wide,
++		[owa] .has-gutter .wide {
++			width: 394px !important;
++		}
++		
++		.ie .two-col.has-gutter.has-border .column,
++		[owa] .two-col.x_has-gutter.x_has-border .column {
++			width: 292px !important;
++		}
++		
++		.ie .three-col.has-gutter.has-border .column,
++		[owa] .three-col.x_has-gutter.x_has-border .column,
++		.ie .has-gutter.has-border .narrow,
++		[owa] .has-gutter.x_has-border .narrow {
++			width: 190px !important;
++		}
++		
++		.ie .has-gutter.has-border .wide,
++		[owa] .has-gutter.x_has-border .wide {
++			width: 396px !important;
++		}
++		
++		.ie .fixed-width .layout__inner {
++			border-left: 0 none white !important;
++			border-right: 0 none white !important;
++		}
++		
++		.ie .layout__edges {
++			display: none;
++		}
++		
++		.mso .layout__edges {
++			font-size: 0;
++		}
++		
++		.layout-fixed-width,
++		.mso .layout-full-width {
++			background-color: #ffffff;
++		}
++		
++		@media only screen and (min-width: 620px) {
++			.column,
++			.gutter {
++				display: table-cell;
++				Float: none !important;
++				vertical-align: top;
++			}
++			.preheader,
++			.email-footer {
++				width: 560px !important;
++			}
++			.snippet,
++			.webversion {
++				width: 280px !important;
++			}
++			.header,
++			.layout,
++			.one-col .column {
++				width: 600px !important;
++			}
++			.fixed-width.has-border,
++			.fixed-width.ecxhas-border,
++			.has-gutter.has-border,
++			.has-gutter.ecxhas-border {
++				width: 602px !important;
++			}
++			.two-col .column {
++				width: 300px !important;
++			}
++			.three-col .column,
++			.column.narrow {
++				width: 200px !important;
++			}
++			.column.wide {
++				width: 400px !important;
++			}
++			.two-col.has-gutter .column,
++			.two-col.ecxhas-gutter .column {
++				width: 290px !important;
++			}
++			.three-col.has-gutter .column,
++			.three-col.ecxhas-gutter .column,
++			.has-gutter .narrow {
++				width: 188px !important;
++			}
++			.has-gutter .wide {
++				width: 394px !important;
++			}
++			.two-col.has-gutter.has-border .column,
++			.two-col.ecxhas-gutter.ecxhas-border .column {
++				width: 292px !important;
++			}
++			.three-col.has-gutter.has-border .column,
++			.three-col.ecxhas-gutter.ecxhas-border .column,
++			.has-gutter.has-border .narrow,
++			.has-gutter.ecxhas-border .narrow {
++				width: 190px !important;
++			}
++			.has-gutter.has-border .wide,
++			.has-gutter.ecxhas-border .wide {
++				width: 396px !important;
++			}
++		}
++		
++		@media only screen and (-webkit-min-device-pixel-ratio: 2),
++		only screen and (min--moz-device-pixel-ratio: 2),
++		only screen and (-o-min-device-pixel-ratio: 2/1),
++		only screen and (min-device-pixel-ratio: 2),
++		only screen and (min-resolution: 192dpi),
++		only screen and (min-resolution: 2dppx) {
++			.fblike {
++				background-image: url(https://i3.createsend1.com/static/eb/master/13-the-blueprint-3/images/fblike@2x.png) !important;
++			}
++			.tweet {
++				background-image: url(https://i4.createsend1.com/static/eb/master/13-the-blueprint-3/images/tweet@2x.png) !important;
++			}
++			.linkedinshare {
++				background-image: url(https://i6.createsend1.com/static/eb/master/13-the-blueprint-3/images/lishare@2x.png) !important;
++			}
++			.forwardtoafriend {
++				background-image: url(https://i7.createsend1.com/static/eb/master/13-the-blueprint-3/images/forward@2x.png) !important;
++			}
++		}
++		
++		@media (max-width: 321px) {
++			.fixed-width.has-border .layout__inner {
++				border-width: 1px 0 !important;
++			}
++			.layout,
++			.column {
++				min-width: 320px !important;
++				width: 320px !important;
++			}
++			.border {
++				display: none;
++			}
++		}
++		
++		.mso div {
++			border: 0 none white !important;
++		}
++		
++		.mso .w560 .divider {
++			Margin-left: 260px !important;
++			Margin-right: 260px !important;
++		}
++		
++		.mso .w360 .divider {
++			Margin-left: 160px !important;
++			Margin-right: 160px !important;
++		}
++		
++		.mso .w260 .divider {
++			Margin-left: 110px !important;
++			Margin-right: 110px !important;
++		}
++		
++		.mso .w160 .divider {
++			Margin-left: 60px !important;
++			Margin-right: 60px !important;
++		}
++		
++		.mso .w354 .divider {
++			Margin-left: 157px !important;
++			Margin-right: 157px !important;
++		}
++		
++		.mso .w250 .divider {
++			Margin-left: 105px !important;
++			Margin-right: 105px !important;
++		}
++		
++		.mso .w148 .divider {
++			Margin-left: 54px !important;
++			Margin-right: 54px !important;
++		}
++		
++		.mso .font-avenir,
++		.mso .font-cabin,
++		.mso .font-open-sans,
++		.mso .font-ubuntu {
++			font-family: sans-serif !important;
++		}
++		
++		.mso .font-bitter,
++		.mso .font-merriweather,
++		.mso .font-pt-serif {
++			font-family: Georgia, serif !important;
++		}
++		
++		.mso .font-lato,
++		.mso .font-roboto {
++			font-family: Tahoma, sans-serif !important;
++		}
++		
++		.mso .font-pt-sans {
++			font-family: "Trebuchet MS", sans-serif !important;
++		}
++		
++		.mso .footer__share-button p {
++			margin: 0;
++		}
++		
++		@media only screen and (min-width: 620px) {
++			.wrapper .size-8 {
++				font-size: 8px !important;
++				line-height: 14px !important;
++			}
++			.wrapper .size-9 {
++				font-size: 9px !important;
++				line-height: 16px !important;
++			}
++			.wrapper .size-10 {
++				font-size: 10px !important;
++				line-height: 18px !important;
++			}
++			.wrapper .size-11 {
++				font-size: 11px !important;
++				line-height: 19px !important;
++			}
++			.wrapper .size-12 {
++				font-size: 12px !important;
++				line-height: 19px !important;
++			}
++			.wrapper .size-13 {
++				font-size: 13px !important;
++				line-height: 21px !important;
++			}
++			.wrapper .size-14 {
++				font-size: 14px !important;
++				line-height: 21px !important;
++			}
++			.wrapper .size-15 {
++				font-size: 15px !important;
++				line-height: 23px !important;
++			}
++			.wrapper .size-16 {
++				font-size: 16px !important;
++				line-height: 24px !important;
++			}
++			.wrapper .size-17 {
++				font-size: 17px !important;
++				line-height: 26px !important;
++			}
++			.wrapper .size-18 {
++				font-size: 18px !important;
++				line-height: 26px !important;
++			}
++			.wrapper .size-20 {
++				font-size: 20px !important;
++				line-height: 28px !important;
++			}
++			.wrapper .size-22 {
++				font-size: 22px !important;
++				line-height: 31px !important;
++			}
++			.wrapper .size-24 {
++				font-size: 24px !important;
++				line-height: 32px !important;
++			}
++			.wrapper .size-26 {
++				font-size: 26px !important;
++				line-height: 34px !important;
++			}
++			.wrapper .size-28 {
++				font-size: 28px !important;
++				line-height: 36px !important;
++			}
++			.wrapper .size-30 {
++				font-size: 30px !important;
++				line-height: 38px !important;
++			}
++			.wrapper .size-32 {
++				font-size: 32px !important;
++				line-height: 40px !important;
++			}
++			.wrapper .size-34 {
++				font-size: 34px !important;
++				line-height: 43px !important;
++			}
++			.wrapper .size-36 {
++				font-size: 36px !important;
++				line-height: 43px !important;
++			}
++			.wrapper .size-40 {
++				font-size: 40px !important;
++				line-height: 47px !important;
++			}
++			.wrapper .size-44 {
++				font-size: 44px !important;
++				line-height: 50px !important;
++			}
++			.wrapper .size-48 {
++				font-size: 48px !important;
++				line-height: 54px !important;
++			}
++			.wrapper .size-56 {
++				font-size: 56px !important;
++				line-height: 60px !important;
++			}
++			.wrapper .size-64 {
++				font-size: 64px !important;
++				line-height: 63px !important;
++			}
++		}
++		
++		.mso .size-8,
++		.ie .size-8 {
++			font-size: 8px !important;
++			line-height: 14px !important;
++		}
++		
++		.mso .size-9,
++		.ie .size-9 {
++			font-size: 9px !important;
++			line-height: 16px !important;
++		}
++		
++		.mso .size-10,
++		.ie .size-10 {
++			font-size: 10px !important;
++			line-height: 18px !important;
++		}
++		
++		.mso .size-11,
++		.ie .size-11 {
++			font-size: 11px !important;
++			line-height: 19px !important;
++		}
++		
++		.mso .size-12,
++		.ie .size-12 {
++			font-size: 12px !important;
++			line-height: 19px !important;
++		}
++		
++		.mso .size-13,
++		.ie .size-13 {
++			font-size: 13px !important;
++			line-height: 21px !important;
++		}
++		
++		.mso .size-14,
++		.ie .size-14 {
++			font-size: 14px !important;
++			line-height: 21px !important;
++		}
++		
++		.mso .size-15,
++		.ie .size-15 {
++			font-size: 15px !important;
++			line-height: 23px !important;
++		}
++		
++		.mso .size-16,
++		.ie .size-16 {
++			font-size: 16px !important;
++			line-height: 24px !important;
++		}
++		
++		.mso .size-17,
++		.ie .size-17 {
++			font-size: 17px !important;
++			line-height: 26px !important;
++		}
++		
++		.mso .size-18,
++		.ie .size-18 {
++			font-size: 18px !important;
++			line-height: 26px !important;
++		}
++		
++		.mso .size-20,
++		.ie .size-20 {
++			font-size: 20px !important;
++			line-height: 28px !important;
++		}
++		
++		.mso .size-22,
++		.ie .size-22 {
++			font-size: 22px !important;
++			line-height: 31px !important;
++		}
++		
++		.mso .size-24,
++		.ie .size-24 {
++			font-size: 24px !important;
++			line-height: 32px !important;
++		}
++		
++		.mso .size-26,
++		.ie .size-26 {
++			font-size: 26px !important;
++			line-height: 34px !important;
++		}
++		
++		.mso .size-28,
++		.ie .size-28 {
++			font-size: 28px !important;
++			line-height: 36px !important;
++		}
++		
++		.mso .size-30,
++		.ie .size-30 {
++			font-size: 30px !important;
++			line-height: 38px !important;
++		}
++		
++		.mso .size-32,
++		.ie .size-32 {
++			font-size: 32px !important;
++			line-height: 40px !important;
++		}
++		
++		.mso .size-34,
++		.ie .size-34 {
++			font-size: 34px !important;
++			line-height: 43px !important;
++		}
++		
++		.mso .size-36,
++		.ie .size-36 {
++			font-size: 36px !important;
++			line-height: 43px !important;
++		}
++		
++		.mso .size-40,
++		.ie .size-40 {
++			font-size: 40px !important;
++			line-height: 47px !important;
++		}
++		
++		.mso .size-44,
++		.ie .size-44 {
++			font-size: 44px !important;
++			line-height: 50px !important;
++		}
++		
++		.mso .size-48,
++		.ie .size-48 {
++			font-size: 48px !important;
++			line-height: 54px !important;
++		}
++		
++		.mso .size-56,
++		.ie .size-56 {
++			font-size: 56px !important;
++			line-height: 60px !important;
++		}
++		
++		.mso .size-64,
++		.ie .size-64 {
++			font-size: 64px !important;
++			line-height: 63px !important;
++		}
++		
++		.footer__share-button p {
++			margin: 0;
++		}
++	</style>
++
++	<title>{SITENAME}</title>
++	<!--[if !mso]><!-->
++	<style type="text/css">
++		@import url(https://fonts.googleapis.com/css?family=Bitter:400,700,400italic|Open+Sans:400italic,700italic,700,400);
++	</style>
++	<link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Bitter:400,700,400italic|Open+Sans:400italic,700italic,700,400">
++	<!--<![endif]-->
++	<style type="text/css">
++		body {
++			background-color: #f2f6f7
++		}
++		
++		.mso h1 {}
++		
++		.mso h1 {
++			font-family: Georgia, serif !important
++		}
++		
++		.mso h2 {}
++		
++		.mso h2 {
++			font-family: Georgia, serif !important
++		}
++		
++		.mso h3 {}
++		
++		.mso h3 {
++			font-family: Georgia, serif !important
++		}
++		
++		.mso .column,
++		.mso .column__background td {}
++		
++		.mso .column,
++		.mso .column__background td {
++			font-family: sans-serif !important
++		}
++		
++		.mso .btn a {}
++		
++		.mso .btn a {
++			font-family: sans-serif !important
++		}
++		
++		.mso .webversion,
++		.mso .snippet,
++		.mso .layout-email-footer td,
++		.mso .footer__share-button p {}
++		
++		.mso .webversion,
++		.mso .snippet,
++		.mso .layout-email-footer td,
++		.mso .footer__share-button p {
++			font-family: sans-serif !important
++		}
++		
++		.mso .logo {}
++		
++		.mso .logo {
++			font-family: Tahoma, sans-serif !important
++		}
++		
++		.logo a:hover,
++		.logo a:focus {
++			color: #859bb1 !important
++		}
++		
++		.mso .layout-has-border {
++			border-top: 1px solid #b3cad0;
++			border-bottom: 1px solid #b3cad0
++		}
++		
++		.mso .layout-has-bottom-border {
++			border-bottom: 1px solid #b3cad0
++		}
++		
++		.mso .border,
++		.ie .border {
++			background-color: #b3cad0
++		}
++		
++		@media only screen and (min-width: 620px) {
++			.wrapper h1 {}
++			.wrapper h1 {
++				font-size: 26px !important;
++				line-height: 34px !important
++			}
++			.wrapper h2 {}
++			.wrapper h2 {
++				font-size: 20px !important;
++				line-height: 28px !important
++			}
++			.wrapper h3 {}
++			.column,
++			.column__background td {}
++		}
++		
++		.mso h1,
++		.ie h1 {}
++		
++		.mso h1,
++		.ie h1 {
++			font-size: 26px !important;
++			line-height: 34px !important
++		}
++		
++		.mso h2,
++		.ie h2 {}
++		
++		.mso h2,
++		.ie h2 {
++			font-size: 20px !important;
++			line-height: 28px !important
++		}
++		
++		.mso h3,
++		.ie h3 {}
++		
++		.mso .column,
++		.ie .column,
++		.mso .column__background td,
++		.ie .column__background td {}
++	</style>
++</head>
++<!--[if mso]>
++	<body class="mso">
++<![endif]-->
++<!--[if !mso]><!-->
++
++<body style="margin: 0;padding: 0;-webkit-text-size-adjust: 100%;" class="full-padding">
++	<!--<![endif]-->
++	<div lang="x-wrapper" style="min-width: 320px;background-color: #f2f6f7;" class="wrapper">
++		<div style="Margin: 0 auto;max-width: 560px;min-width: 280px; width: 280px;width: calc(28000% - 173040px);" class="preheader">
++			<div style="border-collapse: collapse;display: table;width: 100%;">
++				<!--[if (mso)|(IE)]><table align="center" class="preheader" cellpadding="0" cellspacing="0"><tr><td style="width: 280px" valign="top"><![endif]-->
++				<div style="Float: left;font-size: 12px;line-height: 19px;max-width: 280px;min-width: 140px; width: 140px;width: calc(14000% - 78120px);padding: 10px 0 5px 0;color: #99b0b8;font-family: &quot;Open Sans&quot;,sans-serif;" class="snippet">
++
++				</div>
++				<!--[if (mso)|(IE)]></td><td style="width: 280px" valign="top"><![endif]-->
++				<div style="Float: left;font-size: 12px;line-height: 19px;max-width: 280px;min-width: 139px; width: 139px;width: calc(14100% - 78680px);padding: 10px 0 5px 0;text-align: right;color: #99b0b8;font-family: &quot;Open Sans&quot;,sans-serif;" class="webversion">
++
++				</div>
++				<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
++			</div>
++		</div>
++		<div id="emb-email-header-container" style="Margin: 0 auto;max-width: 600px;min-width: 320px; width: 320px;width: calc(28000% - 173000px);" class="header">
++			<!--[if (mso)|(IE)]><table align="center" class="header" cellpadding="0" cellspacing="0"><tr><td style="width: 600px"><![endif]-->
++			<div align="center" style="font-size: 26px;line-height: 32px;Margin-top: 6px;Margin-bottom: 20px;color: #c3ced9;font-family: Roboto,Tahoma,sans-serif;Margin-left: 20px;Margin-right: 20px;" class="logo emb-logo-margin-box">
++				<div align="center" id="emb-email-header" style="font-size:0px !important;line-height:0 !important;" class="logo-center">
++					<img width="141" alt="" src="{SITE_LOGO_IMG}" style="height: auto;width: 100%;border: 0;max-width: 141px;">
++				</div>
++			</div>
++			<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
++		</div>
++		<div style="Margin: 0 auto;max-width: 600px;min-width: 320px; width: 320px;width: calc(28000% - 173000px);overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;" class="layout one-col fixed-width">
++			<div emb-background-style="" style="border-collapse: collapse;display: table;width: 100%;background-color: #ffffff;" class="layout__inner">
++				<!--[if (mso)|(IE)]><table align="center" cellpadding="0" cellspacing="0"><tr class="layout-fixed-width" emb-background-style><td style="width: 600px" class="w560"><![endif]-->
++				<div style="text-align: left;color: #808285;font-size: 14px;line-height: 21px;font-family: &quot;Open Sans&quot;,sans-serif;max-width: 600px;min-width: 320px; width: 320px;width: calc(28000% - 167400px);" class="column">
++
++					<div style="Margin-left: 20px;Margin-right: 20px;Margin-top: 24px;">
++						<div style="line-height:10px;font-size:1px">&nbsp;</div>
++					</div>
++
++					<div style="Margin-left: 20px;Margin-right: 20px;">
++						<div style="line-height:5px;font-size:1px">&nbsp;</div>
++					</div>
++
++					<div style="Margin-left: 20px;Margin-right: 20px;">
++						<h1 style="Margin-top: 0;Margin-bottom: 20px;font-style: normal;font-weight: normal;color: #58595b;font-size: 22px;line-height: 31px;font-family: Bitter,Georgia,serif;text-align: center;">Last Topics While You Were Away</h1>
++					</div>
++
++					<div style="Margin-left: 20px;Margin-right: 20px;">
++						<div style="display: block;font-size: 2px;line-height: 2px;Margin-left: auto;Margin-right: auto;width: 40px;background-color: #b3cad0;Margin-bottom: 20px;" class="divider">&nbsp;</div>
++					</div>
++
++					<div style="Margin-left: 20px;Margin-right: 20px;">
++						<p style="Margin-top: 0;Margin-bottom: 20px;text-align: center;">Enquanto estiveste fora a laurear a pevide, houve nova actividade no fórum. Vê a nova tendência. Estamos animados para te ver novamente!</p>
++					    <p style="Margin-top: 10px;Margin-bottom: 20px;text-align: center;">{EMAIL_SIG}</p>
++					</div>
++
++					<div style="Margin-left: 20px;Margin-right: 20px;">
++						<div style="line-height:10px;font-size:1px">&nbsp;</div>
++					</div>
++
++					<div style="Margin-left: 20px;Margin-right: 20px;">
++						<div style="Margin-bottom: 20px;text-align: center;" class="btn btn--flat btn--large">
++							<!--[if !mso]--><a href="{BOARD_URL}" style="border-radius: 4px;display: inline-block;font-size: 14px;font-weight: bold;line-height: 24px;padding: 12px 24px;text-align: center;text-decoration: none !important;transition: opacity 0.1s ease-in;color: #60686b;background-color: #becdd1;font-family: 'Open Sans', sans-serif;"
++							target="_blank">Comunidade GoldTugAnime</a>
++							<!--[endif]-->
++							<!--[if mso]><p style="line-height:0;margin:0;">&nbsp;</p><v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" href="{BOARD_URL}" style="width:167px" arcsize="9%" fillcolor="#BECDD1" stroke="f"><v:textbox style="mso-fit-shape-to-text:t" inset="0px,11px,0px,11px"><center style="font-size:14px;line-height:24px;color:#60686B;font-family:sans-serif;font-weight:bold;mso-line-height-rule:exactly;mso-text-raise:4px">Discussion Board</center></v:textbox></v:roundrect><![endif]-->
++						</div>
++					</div>
++
++					<div style="Margin-left: 20px;Margin-right: 20px;Margin-bottom: 24px;">
++						<div style="line-height:15px;font-size:1px">&nbsp;</div>
++					</div>
++
++				</div>
++				<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
++			</div>
++		</div>
++
++		<div style="line-height:20px;font-size:20px;">&nbsp;</div>
++
++		<div style="Margin: 0 auto;max-width: 600px;min-width: 320px; width: 320px;width: calc(28000% - 173000px);overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;" class="layout one-col fixed-width">
++			<div emb-background-style="" style="border-collapse: collapse;display: table;width: 100%;background-color: #ffffff;" class="layout__inner">
++				<!--[if (mso)|(IE)]><table align="center" cellpadding="0" cellspacing="0"><tr class="layout-fixed-width" emb-background-style><td style="width: 600px" class="w560"><![endif]-->
++				<div style="text-align: left;color: #808285;font-size: 14px;line-height: 21px;font-family: &quot;Open Sans&quot;,sans-serif;max-width: 600px;min-width: 320px; width: 320px;width: calc(28000% - 167400px);" class="column">
++
++					<div style="Margin-left: 20px;Margin-right: 20px;Margin-top: 24px;Margin-bottom: 24px;">
++<!-- BEGIN mailrow -->
++						<p style="Margin-top: 0;Margin-bottom: 0;"><a href="{mailrow.U_TOPIC}" style="text-decoration: underline;transition: opacity 0.1s ease-in;color: #60686b;" target="_blank">{mailrow.TOPIC} em: {mailrow.FORUMS}</a></p>
++<!-- END mailrow -->
++						<p style="Margin-top: 20px;Margin-bottom: 0;">&nbsp;</p>
++					</div>
++
++				</div>
++				<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
++			</div>
++		</div>
++
++		<div style="line-height:20px;font-size:20px;">&nbsp;</div>
++
++		<div style="Margin: 0 auto;max-width: 600px;min-width: 320px; width: 320px;width: calc(28000% - 173000px);overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;" class="layout email-footer">
++			<div style="border-collapse: collapse;display: table;width: 100%;" class="layout__inner">
++				<!--[if (mso)|(IE)]><table align="center" cellpadding="0" cellspacing="0"><tr class="layout-email-footer"><td style="width: 400px;" valign="top" class="w360"><![endif]-->
++				<div style="text-align: left;font-size: 12px;line-height: 19px;color: #99b0b8;font-family: &quot;Open Sans&quot;,sans-serif;Float: left;max-width: 400px;min-width: 320px; width: 320px;width: calc(8000% - 47600px);" class="column wide">
++					<div style="Margin-left: 20px;Margin-right: 20px;Margin-top: 10px;Margin-bottom: 10px;">
++
++						<div>
++
++						</div>
++						<div style="Margin-top: 18px;">
++
++						</div>
++					</div>
++				</div>
++				<!--[if (mso)|(IE)]></td><td style="width: 200px;" valign="top" class="w160"><![endif]-->
++				<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
++			</div>
++		</div>
++		<div style="Margin: 0 auto;max-width: 600px;min-width: 320px; width: 320px;width: calc(28000% - 173000px);overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;" class="layout one-col email-footer">
++			<div style="border-collapse: collapse;display: table;width: 100%;" class="layout__inner">
++				<!--[if (mso)|(IE)]><table align="center" cellpadding="0" cellspacing="0"><tr class="layout-email-footer"><td style="width: 600px;" class="w560"><![endif]-->
++				<div style="text-align: center;font-size: 12px;line-height: 19px;color: #99b0b8;font-family: &quot;Open Sans&quot;,sans-serif;max-width: 600px;min-width: 320px; width: 320px;width: calc(28000% - 167400px);" class="column">
++					<div style="Margin-left: 20px;Margin-right: 20px;Margin-top: 10px;Margin-bottom: 10px;">
++						<div>
++							<span>
++              <a lang="en" href="{U_BOARD}" style="text-decoration: underline;transition: opacity 0.1s ease-in;color: #99b0b8;" target="_blank">Preferências</a>
++              &nbsp;&nbsp;|&nbsp;&nbsp;
++            </span>
++              <a href="{NEWSLETTER_OPTOUT}" style="text-decoration: underline;transition: opacity 0.1s ease-in;color: #99b0b8;" target="_blank">Cancelar Subscrição</a>
++						</div>
++					</div>
++				</div>
++				<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
++			</div>
++		</div>
++		<div style="line-height:40px;font-size:40px;">&nbsp;</div>
++
++	</div>
++
++</body>
++
++</html>
+\ No newline at end of file
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/language/pt_preao/email/newsoverview_txt.txt" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/language/pt_preao/email/newsoverview_txt.txt"
+new file mode 100644
+index 000000000..24fee63c8
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/language/pt_preao/email/newsoverview_txt.txt"
+@@ -0,0 +1,17 @@
++Subject: Latest topic at "{SITENAME}"
++
++{SITENAME}
++
++Latest Topics
++Hi,
++It's time for another newsletter.
++We look forward to see you at {BOARD_URL} again.
++
++Forum				Topic
++<!-- BEGIN mailrow -->
++{mailrow.U_FORUM}				{mailrow.U_TOPIC}
++<!-- END mailrow -->
++
++
++{EMAIL_SIG}
++Don't want to receive our newsletter anymore, click here {NEWSLETTER_OPTOUT}
+\ No newline at end of file
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/language/pt_preao/info_acp_newsletter.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/language/pt_preao/info_acp_newsletter.php"
+new file mode 100644
+index 000000000..cc9168a39
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/language/pt_preao/info_acp_newsletter.php"
+@@ -0,0 +1,181 @@
++<?php
++/**
++*
++* @package BBnewsletter
++* @copyright (c) 2016 SiteSplat All rights reserved
++* @license Proprietary
++*
++*/
++
++if (!defined('IN_PHPBB'))
++{
++	exit;
++}
++
++if (empty($lang) || !is_array($lang))
++{
++	$lang = array();
++}
++
++$lang = array_merge($lang, array(
++	'ACP_NEWSLETTER'			=> 'Newsletter',
++	'ACP_NEWSLETTER_EXPLAIN'	=> 'Setup your Newsletter, several options are available below. Please make sure your mailserver accepts all mails, otherwise it will use phpbb\'s mail settings to send emails in small batches. <br />The weekly and monthly "Catch-up" forum news are sent out by the cron task. Install <a href="https://github.com/ForumHulp/cronstatus" target="_blank">Cronstatus extension</a> and select "Run cron always" in the options to run more often the "Catch-up" News (This is especially useful for small forums). <br />For HTML e-mails install <a href=" https://github.com/ForumHulp/htmlemail" target="_blank">HTML emails Extension</a> which enables the HTML settings.<br />',
++    'FORUMS_NEWS_FROM'		    => 'Newsletter forum source',
++	'FORUMS_FROM_EXPLAIN'		=> 'Select the forums you would like the users to receive the news from',
++	'SEND_IMMEDIATELY'			=> 'Send immediately',
++	'SEND_IMMEDIATELY_EXPLAIN'	=> 'Attempt to send the emails immediately. This depends on the server email configuration parameters',
++	'PERIOD'					=> 'Email Overview (or Catch-up) Period',
++	'PERIOD_EXPLAIN'			=> 'This will send automatic "Catch-up"  emails to the users that are subscribed. The e-mail will be generated based on the new topics in the forum. The user will receive an email with the purpose of engaging the user\'s interest in the recent board\'s activity. Edit the templates file named newsletter_html.txt for the HTML version and newsletter_txt.txt for the TXT version from:<br /> <code>root\ext\sitesplat\newsletter\language\en\email\</code> <br /> To learn how to send out professional looking HTML emails check out the tutorials over at <a href=" https://sitesplat.com/" target="_blank">sitesplat.com</a> or click the "Tutorials" label above.',
++	'WEEKLY'					=> 'Weekly',
++	'MONTHLY'					=> 'Monthly',
++	'NO_OVERVIEW'				=> 'None',
++	'PERIOD_SEND'				=> 'Set period for automatic newsletter',
++	'SEND_TO_GROUP'				=> 'Send to group',
++	'SEND_TO_USERS'				=> 'Send to user(s)',
++	'SEND_TO_USERS_EXPLAIN'		=> 'When using this field it will override the "Send to Group" option above. Each user on a new line',
++	'ALL_USERS'					=> 'All users',
++	'NEW_USER'					=> 'Allow new users',
++	'MAIL_LOW_PRIORITY'			=> 'Low',
++	'MAIL_NORMAL_PRIORITY'		=> 'Normal',
++	'MAIL_HIGH_PRIORITY'		=> 'High',
++	'MAIL_PRIORITY'				=> 'Mail priority',
++	'USE_HTML'					=> 'Use HTML emails',
++	'COMPOSE_HTML'				=> 'Send manually',
++	'COMPOSE_HTML_EXPLAIN'		=> 'If "Send manually" is selected the HTML editor will be available to send custom emails in HTML format',
++	'MASS_MESSAGE'				=> 'Message (Newsletter Body)',
++	'MASS_MESSAGE_EXPLAIN'		=> 'HTML message will be stripped if HTML email Extension is not enabled. To use the HTML editor click on "Tools" then "Source code" and enter the HTML code in the code editor ',
++	'FHHTML_EMAIL_NOT_ENABLED'	=> 'HTML email extension not enabled. Download it from https://github.com/ForumHulp/htmlemail',
++	'FHHTML_EMAIL_DOWNLOAD'	    => 'HTML email Extension not enabled. Download it from <a href="https://github.com/ForumHulp/htmlemail" target="blank">GithHub HTML Email Ext</a>',
++	'LAST_SEND'					=> '<span id="viewsubscribers" class="label label-info" title="View subscribers">%1$s Members</span> subscribed, last letter was sent on <strong class="text-info">%2$s</strong>',
++	'LAST_SEND_LETTERS'			=> 'Last newsletters',
++	'LAST_SEND_EXPLAIN'			=> '**Please note, new registered users are automatically subscribed. (Click "X Members" above to view the users list)',
++	'LAST_NEWSLETTERS_EXPLAIN'	=> '**Please note, the following template visualized on the single emails below does NOT reflect 100% the email that was sent out. This is due to phpBB\'s ACP stylesheet obsolete CSS reset rules. Refer to your email copy or front-end archive for the exact email accuracy.<br /> This is a list with the sole purpose of keeping track of the emails and users in a simple manner.<br />Always save a copy of the composed HTML email before sending it out if you wish to re-use it in the future.',
++	'NEWS_PAGE'					=> 'Visible',
++	'HIDE'						=> 'Hide',
++	'SHOW'						=> 'Show',
++	'DELETE_MAIL_SUCCES'		=> 'Newsletter deleted',
++	'ACP_NEWSOVERVIEW_SEND'		=> 'Newsletter(s) sent successfully',
++	'ACP_NEWSOVERVIEW_SAVED'	=> 'Settings saved successfully',
++	
++	'SITESPLAT_COM'		        => 'https://sitesplat.com',
++	'SITESPLAT_COPY'		    => '&#169; SiteSplat',
++	'LICENSE_INFO'		        => 'Proprietary - SiteSplat All rights reserved',
++	'EXTENSION_DEVELOPER'	    => 'Developer',
++	'ACP_NOTICE_CLOSE'			=> 'Close',
++	'ACP_NEWS_VERSION'          => '1.0.5',
++	'ACP_LOADING'		        => 'Loading... Hold on',
++	'FORUM_CONTENT'		        => 'forum content',
++	'EXT_NEWS_DESCRIPTION_PAGE'	=> 'A Newsletter system with an archive, weekly, monthly and many more options to run your own HTML style newsletter like a pro!',
++	'EXT_NEWS_TASKS_1'			=> 'Newsletter Archive',
++	'EXT_NEWS_TASKS_2'			=> 'Full HTML Enabled',
++	'EXT_NEWS_TASKS_3'			=> 'Synchronization with Cron tasks and compatible with <a href="https://www.phpbb.com/customise/db/extension/cronstatus/">Cron Status</a>',
++	'EXT_NEWS_TASKS_4'			=> 'Scheduled Newsletter',
++	'EXT_NEWS_TASKS_5'			=> 'Checkout the other premium addons on <a href="https://sitesplat.com/phpBB3/marketplace.php">sitesplat.com/marketplace.php</a>',
++	'EXT_NEWS_TASKS_6'			=> 'phpBB 3.2 ready',
++
++	'NEWS_SUBSCRIBERS_INFO'     => 'Subscribers and news info',
++	'NEWS_TRICKS_TITLE'         => 'Tips and Tricks',
++	'ACP_NEWS_TRICK_EXPLAIN'	=> '<p>Does your ISP limit the number of emails you can send each day?</p>
++									<p><strong>Of course they do!</strong>
++									</p>
++									<p>Every outgoing SMTP mail server is guided by a provider’s email policy which includes hourly and/or daily email send limits. This policy will ultimately determine how many emails you can send each day. You can find a list of the hourly and daily send limits for most of the major ISPs, web hosting companies and Free email address providers below.</p>
++									<p><strong><a title="Email sending limits for isp, web hosting and free email providers" href="http://group-mail.com/sending-email/email-sending-limits-for-isp-web-hosting-and-free-email-providers/">Email Sending Limits of ISP, Web Hosting and Free Email Providers</a></strong>
++									</p>
++									<p>If you try to send more email than the hourly or daily email sending limits of your mail server, you will notice errors being returned after the specified quota is met, saying something along the lines of:<em> </em>
++									</p>
++									<blockquote>
++										<p><em>you have reached your daily sending quota</em>…</p>
++									</blockquote>
++									<p>If you surpass the daily <a title="SMTP email sending limits" href="http://group-mail.com/sending-email/email-sending-limits-for-isp-web-hosting-and-free-email-providers/">SMTP email sending limits</a> of your provider, you will generally have to wait 24 hours before you can send more email through that particular server.</p>
++									<p>But, what are the hourly or daily email sending limits for <em>your</em> email server?</p>
++									<ul>
++										<li>The Gmail mail server send limit is approximately 100-150 emails per day when connected to the server from a remote email client. You can send 500 emails each day through the Gmail SMTP server when logged into their web interface.</li>
++										<li>The Comcast mail server limits residential customers to send 1,000 messages per day. Comcast Business customers can send 24,000 emails per day through the Comcast outgoing SMTP mail server.</li>
++										<li>The basic GoDaddy email server limits senders to send&nbsp; only 250 outgoing emails per day, but you can <a title="send more email by adding SMTP relays to your GoDaddy account" href="http://group-mail.com/sending-email/how-to-increase-your-godaddy-email-sending-limits/">send more email by adding SMTP relays to your GoDaddy account</a>
++										</li>
++									</ul>
++									<p>&nbsp;</p>
++									<p>So, what’s a guy to do if he needs to get his monthly email newsletter out to 5,000 eager subscribers but his ISP has a daily send limit of 500 emails per day?</p>
++									<p><strong>What can you do if your mail server has limits that don’t support the size of your mailing list?</strong>
++									</p>
++									<p>If your current outgoing SMTP email server does not support your email list size or sending frequency, you have a variety of options:</p>
++									<p style="padding-left: 30px;">1. Contact the host of your outgoing SMTP mail server(s) and ask if they have a business account that lets you send more emails each day to support your business.</p>
++									<p style="padding-left: 30px;">2. Use GroupMail’s <a title="sending email without an external SMTP mail server" href="http://group-mail.com/sending-email/sending-email-without-an-external-smtp-mail-server/">Direct Send option</a>, which allows you to bypass your external SMTP server altogether and send email directly from your computer to your recipients using GroupMail’s own internal SMTP engine.</p>
++									<p style="padding-left: 30px;">3. Use an outgoing SMTP service like <a title="SMTP2Go outgoing relay pricing" href="http://groupmail.smtp2go.com">SMTP2Go</a> to relay your large email campaigns.</p>
++									<p style="padding-left: 30px;">4. Find a web hosting company who has daily email sending limits that meet your needs.</p>
++									<p style="padding-left: 30px;">5. Setup your own <a href="http://www.msexchange.org/tutorials/MF002.html">MS Exchange Server</a> and configure it for SMTP email delivery.</p>
++									<p>So, while GroupMail allows you to send and manage email lists of an <strong>unlimited</strong> size; the success of email delivery to large groups is ultimately dependent upon the sending limits set forth in the email sending policy of the SMTP mail server you are using.</p>
++									<p><strong>Related articles you might find interesting:</strong>
++									</p>
++									<p><a title="email sending limits of ISPs web hosting and free email providers" href="http://group-mail.com/sending-email/email-sending-limits-for-isp-web-hosting-and-free-email-providers/">Email Sending Limits for ISPs, Web Hosting and Free Email Providers</a>
++									</p>
++									<p><a title="Common email error code descriptions and fixes" href="http://group-mail.com/email-error-codes/common-email-error-codes/">Common Email Error Code Descriptions and Fixes</a>
++									</p>
++									<p><a title="Free Email Newsletter and Marketing Software and Services" href="http://group-mail.com/email-marketing/free-email-newsletter-and-marketing-software-and-services/">Free Email Newsletter and Marketing Software and Services</a>
++									</p>
++									<p><a title="Email Settings for the Most Common Email Server hosts" href="http://group-mail.com/category/email-settings/">Email Settings for the Most Common Email Server Hosts</a>
++									</p>
++									<p><a title="step by step guide for email setup and delivery" href="http://group-mail.com/getting-started-with-groupmail/step-by-step-guide-for-email-setup-and-delivery/">Step-by-Step Guide for Email Setup and Delivery</a>
++									</p>
++									<p>&nbsp;</p>
++									<hr>
++									<p></p>',
++	
++	'EXT_NEWS_TUTORIALS_TITLE'  => 'Tutorials',
++	'EXT_NEWS_TUTORIALS_EXPLAIN'=> '<li><p>Templates</p>
++					<ul>
++					<li><a href="http://htmlemailboilerplate.com/" target="_blank"><strong>HTML Email Boilerplate</strong></a>: A great <strong>starting point</strong> for coding emails.</li>
++					<li><a href="http://www.campaignmonitor.com/templates/" target="_blank"><strong>Campaign Monitor Templates</strong></a>: Template builder + free downloadable templates</li>
++					</ul>
++					</li>
++					
++					<li><p>Tutorials &amp; Guides</p>
++
++					<ul>
++					<li><a href="http://kb.mailchimp.com/article/how-to-code-html-emails" target="_blank"><strong>How To Code HTML Emails (Mailchimp)</strong></a>: How HTML email works, basic concepts, best practices, tips and tricks</li>
++					<li><a href="http://www.smashingmagazine.com/2010/01/19/design-and-build-an-email-newsletter-without-losing-your-mind/" target="_blank"><strong>Design and Build Email Newsletters Without Losing Your Mind (and Soul)</strong></a>:  information you need to plan, design and build an HTML newsletter that renders well</li>
++					<li><a href="http://mailchimp.com/resources/guides/email-marketing-field-guide/html/" target="_blank"><strong>Email Marketing Field Guide (Mailchimp)</strong></a></li>
++					<li><a href="http://mattmedia.net/2007/08/23/8-html-email-tips-i-wish-i-knew-sooner/" target="_blank"><strong>8 HTML Email Tips I Wish I’d Known Sooner</strong></a></li>
++					<li><a href="http://www.campaignmonitor.com/css/" target="_blank"><strong>The Ultimate Guide</a>: From Campaign Monitor</strong></li>
++					<li><a href="http://css-tricks.com/using-css-in-html-emails-the-real-story/" target="_blank"><strong>CSS Tricks: Using CSS in HTML Emails</strong></a>: Some "I told you so"\'s and tips about HTML emails and CSS.</li>
++					</ul>
++					</li>
++					
++					<li><p>Testing</p>
++
++					<ul>
++					<li><a href="http://www.emailonacid.com/" target="_blank"><strong>Email on Acid</strong></a>: Free and paid testing</li>
++					<li><a href="http://litmus.com/" target="_blank"><strong>Litmus</strong></a></li>
++					</ul>
++					</li>
++					
++					<li><p>Other Resources</p>
++
++					<ul>
++					<li><a href="http://www.campaignmonitor.com/resources/will-it-work/email-clients/" target="_blank"><strong>Campaign Monitor\'s Popular E-Mail Clients</strong></a></li>
++					</ul>
++					</li>',
++	
++	
++	'NEWSLETTER_NOTICE'			=> '<div class="phpinfo"><p>The settings for this extension are under <strong>%1$s &#187; %2$s &#187; %3$s</strong>. <br />Please note, at first setup when the period is set (for example weekly) and the format (HTML) the first automatic newsletter overview is sent out immediately right after the settings are saved! <br />This is needed to start the Synchronization. With this in mind, consider using a test board before using the extension to make sure the end result of the newlsetter is the preferred look.</p></div>',
++	'SS_HELPER_NOTY'			=> 'SiteSplat BBcore does not exist!<br />Download the <a href="https://sitesplat.com" target="_blank">BBcore</a> and copy the BBcore folder into your sitesplat extension folder.',
++));
++
++// Description of Donations extension
++$lang = array_merge($lang, array(
++	'DESCRIPTION_PAGE'		=> 'Description',
++	'DESCRIPTION_NOTICE'	=> 'Extension note',
++	'ext_details' => array(
++		'details' => array(
++			'DESCRIPTION_1'	=> 'HTML newsletter',
++			'DESCRIPTION_2'	=> 'Groupselect',
++			'DESCRIPTION_3'	=> 'Weekly / monthly news overview',
++			'DESCRIPTION_4'	=> 'Send immediately or in batch',
++			'DESCRIPTION_5'	=> 'Overview subscribers',
++		),
++		'note' => array(
++			'NOTICE_1'		=> '<a href="https://github.com/ForumHulp/htmlemail" target="_blank">HTML email extension</a> is needed to enable the HTML settings.',
++			'NOTICE_2'		=> 'phpBB 3.2 ready'
++		)
++	)
++));
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/language/pt_preao/newsletter.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/language/pt_preao/newsletter.php"
+new file mode 100644
+index 000000000..02aa2312c
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/language/pt_preao/newsletter.php"
+@@ -0,0 +1,40 @@
++<?php
++/**
++*
++* @package BBnewsletter
++* @copyright (c) 2016 SiteSplat All rights reserved
++* @license Proprietary
++*
++*/
++
++if (!defined('IN_PHPBB'))
++{
++	exit;
++}
++
++if (empty($lang) || !is_array($lang))
++{
++	$lang = array();
++}
++
++$lang = array_merge($lang, array(
++	'NEWSLETTER'				=> 'Newsletter',
++	'OVERVIEW'					=> 'Welcome to our Newsletter! :-) On this page you will find the latest Newsletters as well as the past years archives.',
++
++	'SUBSCRIBE_NO'				=> 'I do NOT want to receive the Newsletter anymore',
++	'SUBSCRIBE_YES'				=> 'Yes I want to receive the Newsletter',
++	'SUBSCRIBE_BTN_NO'			=> 'Cancel',
++	'SUBSCRIBE_BTN_YES'			=> 'Subscribe',
++	'SUBSCRIBE_CONFIRM_NO'		=> 'Please submit to cancel your subscription',
++	'SUBSCRIBE_CONFIRM_YES'		=> 'Please submit to confirm your subscription',
++
++	'SUBSCRIBE_Y_EMAIL'			=> 'Your email',
++	'SUBSCRIBE'					=> 'Subscribe to',
++	'UNSUBSCRIBE'				=> 'Unsubscribe from',
++	'SUBSCRIBE_INFO'			=> 'Our newsletter. Unsubscribed members won\'t receive our periodic News overview anymore.',
++	
++	'OVERVIEW_ARCHIVE'			=> 'Archive',
++	'ARCHIVES'					=> 'Archives',
++	'SUBSCRIBED'				=> 'Thanks for subscribing! You will receive our newsletter from today on!',
++	'UNSUBSCRIBED'				=> 'Successfully unsubscribed, you won\'t receive our newsletter any longer'
++));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\newsletter/styles/FLATBOOTS/template/newsletter.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/styles/FLATBOOTS/template/newsletter.html"
+index 8d096242e..cf9b91e86 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\newsletter/styles/FLATBOOTS/template/newsletter.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/styles/FLATBOOTS/template/newsletter.html"
+@@ -2,91 +2,97 @@
+ <!-- INCLUDECSS @sitesplat_newsletter/css/newsletter.css -->
+ <!-- INCLUDE overall_header.html -->
+ <!-- ENDIF -->
+- 
+-<!-- IF not S_MAIL_VIEW -->	
+-<div class="side-segment"><h3>{L_NEWSLETTER}</h3></div>
++
++<!-- IF not S_MAIL_VIEW -->
++<div class="side-segment">
++	<h3>{L_NEWSLETTER}</h3>
++</div>
+ <div class="row">
+ 	<div class="col-md-8">
+-	 <div class="panel panel-default">
+-	   <div class="panel-body">
+-        <p>{L_OVERVIEW}</p>
+-        <ul class="mailrow list-unstyled">
+-			<!-- BEGIN mailrow -->
+-			<li><a href="{mailrow.U_VIEW}" data-src="{mailrow.U_VIEW}" data-remote="false" data-toggle="modal" data-target=".modal-news" class="btn btn-default btn-xs modal-news-btn"><i class="fa fa-envelope"></i>&nbsp;{mailrow.SUBJECT}&nbsp;&#45;&nbsp;{mailrow.TIME}</a></li>
+-			<!-- END mailrow -->
+-        </ul>
+-		
+-		<!-- IF S_ARCHIVES --> 
+-          <p><strong>{L_ARCHIEVES}{L_COLON}</strong></p>
+-			<!-- BEGIN archiverow -->
+-				<!-- IF archiverow.S_ROW_COUNT > 0 -->                       
+-				  <a class="inline" data-toggle="collapse" href="#month_{archiverow.S_ROW_COUNT}"><i id="month_image_{archiverow.S_ROW_COUNT}" class="fa <!-- IF archiverow.S_ROW_COUNT >= 0 -->fa-bar-chart-o"<!-- ELSE -->fa-bar-chart"<!-- ENDIF -->></i>&nbsp;{archiverow.ARCHIVE}</a>
+-				   <br />
+-					<div id="month_{archiverow.S_ROW_COUNT}" class="collapse">
+-					 <p>{archiverow.ARCHIVE} {L_OVERVIEW_ARCHIVE} </p>
+-						<ul class="mailrow list-unstyled">
++		<div class="panel panel-default">
++			<div class="panel-body">
++				<p>{L_OVERVIEW}</p>
++				<ul class="mailrow list-unstyled">
++					<!-- BEGIN mailrow -->
++					<li><a href="{mailrow.U_VIEW}" data-src="{mailrow.U_VIEW}" data-remote="false" data-toggle="modal" data-target=".modal-news" class="btn btn-default btn-xs modal-news-btn"><i class="fa fa-envelope"></i>&nbsp;{mailrow.SUBJECT}&nbsp;&#45;&nbsp;{mailrow.TIME}</a></li>
++					<!-- END mailrow -->
++				</ul>
++
++				<!-- IF S_ARCHIVES -->
++				<p><strong>{L_ARCHIVES}{L_COLON}</strong></p>
++				<!-- BEGIN archiverow -->
++				<!-- IF archiverow.S_ROW_COUNT > 0 -->
++				<a class="inline" data-toggle="collapse" href="#month_{archiverow.S_ROW_COUNT}"><i id="month_image_{archiverow.S_ROW_COUNT}" class="fa <!-- IF archiverow.S_ROW_COUNT >= 0 -->fa-bar-chart-o" <!-- ELSE -->fa-bar-chart"<!-- ENDIF -->></i>&nbsp;{archiverow.ARCHIVE}</a>
++				<br />
++				<div id="month_{archiverow.S_ROW_COUNT}" class="collapse">
++					<p>{archiverow.ARCHIVE} {L_OVERVIEW_ARCHIVE} </p>
++					<ul class="mailrow list-unstyled">
+ 						<!-- BEGIN monthrow -->
+-						 <li><a href="index.html?letter={archiverow.monthrow.U_VIEW}" data-src="index.html?letter={archiverow.monthrow.U_VIEW}" data-remote="false" data-toggle="modal" data-target=".modal-arch" class="btn btn-default btn-xs modal-arch-btn"><i class="fa fa-envelope"></i>&nbsp;{archiverow.monthrow.TITLE}&nbsp;&#45;&nbsp;{archiverow.monthrow.DATE}</a></li>
++						<li><a href="index.html?letter={archiverow.monthrow.U_VIEW}" data-src="index.html?letter={archiverow.monthrow.U_VIEW}" data-remote="false" data-toggle="modal" data-target=".modal-arch" class="btn btn-default btn-xs modal-arch-btn"><i class="fa fa-envelope"></i>&nbsp;{archiverow.monthrow.TITLE}&nbsp;&#45;&nbsp;{archiverow.monthrow.DATE}</a></li>
+ 						<!-- END monthrow -->
+-						</ul>
+-					</div>
++					</ul>
++				</div>
++				<!-- ENDIF -->
++				<!-- END archiverow -->
+ 				<!-- ENDIF -->
+-			<!-- END archiverow -->
+-        <!-- ENDIF -->
+-		
+-		</div> 
+-	  </div>	
+-	</div>	
+-	
++
++			</div>
++		</div>
++	</div>
++
+ 	<div class="col-md-4">
+-    <div class="panel panel-default panel-body">
+-		<!-- IF PASS -->
++		<div class="panel panel-default panel-body">
++			<!-- IF PASS -->
+ 			<form id="postform" method="post" action="index.html">
+-			    <fieldset>
+-				 <label class="control-label" for="pass">{L_PASSWORD}{L_COLON}</label>
+-                    <div class="input-subscribe"> 					
+-					 <input class="form-control" type="password" name="password" id="password" size="25" maxlength="100" value="{PASSWORD}">
+-					</div>  
+-					  <input type="hidden" name="username" value="{UNAME}">
+-					  <input type="hidden" name="email" value="{UEMAIL}">
+-					  <input type="hidden" name="action" value="<!-- IF DEREGISTER -->de<!-- ENDIF -->register">
++				<fieldset>
++					<label class="control-label" for="pass">{L_PASSWORD}{L_COLON}</label>
++					<div class="input-subscribe">
++						<input class="form-control" type="password" name="password" id="password" size="25" maxlength="100" value="{PASSWORD}">
++					</div>
++					<input type="hidden" name="username" value="{UNAME}">
++					<input type="hidden" name="email" value="{UEMAIL}">
++					<input type="hidden" name="action" value="<!-- IF DEREGISTER -->de<!-- ENDIF -->register">
+ 					<button type="submit" tabindex="9" name="submit" value="{L_SUBMIT}" class="btn btn-success btn-block" data-loading-text="{L_LOADING}&nbsp;<i class='fa-spin fa fa-spinner fa-lg icon-white'></i>"><i class="fa fa-send"></i> {L_SUBMIT}</button>
+ 				</fieldset>
+ 			</form>
+-			<!-- ELSEIF BEDANKT -->
+-			  <div class="alert alert-success">{BEDANKT}<meta http-equiv="refresh" content="5; URL=index.html" /></div>
++			<!-- ELSEIF THANKS -->
++			<div class="alert alert-success">{THANKS}
++				<meta http-equiv="refresh" content="5; URL=index.html" />
++			</div>
+ 			<!-- ELSE -->
+-            <div class="alert alert-info">
+-			 <p><!-- IF DEREGISTER -->{L_SUBSCRIBE_NO}<!-- ELSE -->{L_SUBSCRIBE_YES}<!-- ENDIF --></p>
+-			 <p>**<!-- IF DEREGISTER -->{L_SUBSCRIBE_CONFIRM_NO}<!-- ELSE -->{L_SUBSCRIBE_CONFIRM_YES}<!-- ENDIF --></p>
++			<div class="alert alert-info">
++				<p><!-- IF DEREGISTER -->{L_SUBSCRIBE_NO}<!-- ELSE -->{L_SUBSCRIBE_YES}<!-- ENDIF --></p>
++				<p>**<!-- IF DEREGISTER -->{L_SUBSCRIBE_CONFIRM_NO}<!-- ELSE -->{L_SUBSCRIBE_CONFIRM_YES}<!-- ENDIF --></p>
+ 			</div>
+ 			{ERROR_MSG}
+ 			<form id="postform" method="post" action="index.html">
+-			<fieldset>
+-		 <!-- <input type="text" class="form-control" name="username" id="username" size="25" value="{USERNAME}" title="{L_USERNAME}"> -->
+-			 <div class="input-subscribe"> 
+-			  <label for="email" class="">{L_SUBSCRIBE_Y_EMAIL}</label>
+-			  <input type="text" class="form-control" name="email" id="email" size="25" maxlength="100" value="{EMAIL}" disabled> 
+-			 </div>
+-			  <button type="submit" tabindex="9" name="submit" value="{L_SUBMIT}" class="btn btn-success btn-block" data-loading-text="{L_LOADING}&nbsp;<i class='fa-spin fa fa-spinner fa-lg icon-white'></i>"><i class="fa fa-send"></i>&nbsp;<!-- IF DEREGISTER -->{L_SUBSCRIBE_BTN_NO}<!-- ELSE -->{L_SUBSCRIBE_BTN_YES}<!-- ENDIF --></button>
+-			  <input type="hidden" name="action" value="<!-- IF DEREGISTER -->de<!-- ENDIF -->register" />
+-			  {S_FORM_TOKEN}
+-			</fieldset>
++				<fieldset>
++					<!-- <input type="text" class="form-control" name="username" id="username" size="25" value="{USERNAME}" title="{L_USERNAME}"> -->
++					<div class="input-subscribe">
++						<label for="email" class="">{L_SUBSCRIBE_Y_EMAIL}</label>
++						<input type="text" class="form-control" name="email" id="email" size="25" maxlength="100" value="{EMAIL}" disabled>
++					</div>
++					<button type="submit" tabindex="9" name="submit" value="{L_SUBMIT}" class="btn btn-success btn-block" data-loading-text="{L_LOADING}&nbsp;<i class='fa-spin fa fa-spinner fa-lg icon-white'></i>"><i class="fa fa-send"></i>&nbsp;<!-- IF DEREGISTER -->{L_SUBSCRIBE_BTN_NO}<!-- ELSE -->{L_SUBSCRIBE_BTN_YES}<!-- ENDIF --></button>
++					<input type="hidden" name="action" value="<!-- IF DEREGISTER -->de<!-- ENDIF -->register" />
++					{S_FORM_TOKEN}
++				</fieldset>
+ 			</form>
+-		<!-- ENDIF -->
++			<!-- ENDIF -->
++		</div>
+ 	</div>
+-    </div>
+-</div>	
+-<!-- ENDIF -->	
++</div>
++<!-- ENDIF -->
+ 
+-    <!-- IF S_MAIL_VIEW -->
+-        <div class="wrap-email">
+-             <div class="pull-left"><h3><a>{MAIL_SUBJECT}</a></h3></div>
+-			 <div class="pull-right">{MAIL_DATE}</div>
+-			  <div class="space10"></div>
+-             <div class="clearfix">{MAIL_MESSAGE}</div>
+-        </div>
+-    <!-- ENDIF -->
++<!-- IF S_MAIL_VIEW -->
++<div class="wrap-email">
++	<div class="pull-left">
++		<h3><a>{MAIL_SUBJECT}</a></h3>
++	</div>
++	<div class="pull-right">{MAIL_DATE}</div>
++	<div class="space10"></div>
++	<div class="clearfix">{MAIL_MESSAGE}</div>
++</div>
++<!-- ENDIF -->
+ 
+ <!-- IF not S_MAIL_VIEW -->
+ <!-- INCLUDEJS @sitesplat_newsletter/js/newsletter.js -->
+@@ -98,9 +104,9 @@
+ 				<h4 class="modal-title" id="myModalLabel">{L_NEWSLETTER}</h4>
+ 			</div>
+ 			<div class="modal-body">
+-			<div class="embed-responsive embed-responsive-16by9">
+-               <iframe class="embed-responsive-item" src="#"></iframe>
+-			</div>	
++				<div class="embed-responsive embed-responsive-16by9">
++					<iframe class="embed-responsive-item" src="#"></iframe>
++				</div>
+ 			</div>
+ 			<div class="modal-footer">
+ 				<button type="button" class="btn btn-primary" data-dismiss="modal" aria-label="Close">{L_CLOSE}</button>
+@@ -116,9 +122,9 @@
+ 				<h4 class="modal-title" id="myModalArch">{L_NEWSLETTER}</h4>
+ 			</div>
+ 			<div class="modal-body">
+-			<div class="embed-responsive embed-responsive-16by9">
+-                <iframe class="embed-responsive-item" src="#"></iframe>
+-			</div>	
++				<div class="embed-responsive embed-responsive-16by9">
++					<iframe class="embed-responsive-item" src="#"></iframe>
++				</div>
+ 			</div>
+ 			<div class="modal-footer">
+ 				<button type="button" class="btn btn-primary" data-dismiss="modal" aria-label="Close">{L_CLOSE}</button>
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\newsletter/vendor/assets/images/github-logo.png" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\newsletter/vendor/assets/images/github-logo.png"
+deleted file mode 100644
+index d3d699e79..000000000
+Binary files "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\newsletter/vendor/assets/images/github-logo.png" and /dev/null differ
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/vendor/assets/images/gold-logo.png" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/vendor/assets/images/gold-logo.png"
+new file mode 100644
+index 000000000..8274b052d
+Binary files /dev/null and "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/vendor/assets/images/gold-logo.png" differ
diff --git "[FORUM_EXT]/sitesplat\\newsletter/diff_nospace.tmp" "[FORUM_EXT]/sitesplat\\newsletter/diff_nospace.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\newsletter/diff_nospace.tmp"
@@ -0,0 +1,4095 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\newsletter/acp/newsletter_module.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/acp/newsletter_module.php"
+index 4d91cc708..bc694dc33 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\newsletter/acp/newsletter_module.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/acp/newsletter_module.php"
+@@ -187,21 +187,12 @@ class newsletter_module
+ 					));
+ 				}
+ 
+-				$sql = 'SELECT forum_id, forum_name FROM ' . FORUMS_TABLE . ' WHERE forum_type = 1 ORDER BY forum_name';
+-				$result = $this->db->sql_query($sql);
+ 				$forum_ary = json_decode($this->config['newsletter_forums'], true);
+-				while ($row = $this->db->sql_fetchrow($result))
+-				{
+-					$template->assign_block_vars('forumrows', array(
+-						'ID'			=> $row['forum_id'],
+-						'FORUMNAME'		=> $row['forum_name'],
+-						'SELECTED'		=> (in_array($row['forum_id'], $forum_ary)) ? ' selected="selected"' : '',
+-					));
+-				}
+-				$this->db->sql_freeresult($result);
++				$forum_list = make_forum_select($forum_ary, false, true, true);
+ 
+ 				$enable_html = $phpbb_container->get('ext.manager')->is_enabled('forumhulp/htmlemail');
+ 				$template->assign_vars(array(
++					'S_FORUM_LIST'			=> $forum_list,
+ 					'WARNING_MSG'			=> (sizeof($error)) ? implode('<br />', $error) : '',
+ 					'U_ACTION'				=> $this->u_action,
+ 					'S_GROUP_OPTIONS'		=> $select_list,
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\newsletter/adm/style/acp_newsletter.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/adm/style/acp_newsletter.html"
+index c2a94d65c..89e58f775 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\newsletter/adm/style/acp_newsletter.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/adm/style/acp_newsletter.html"
+@@ -53,9 +53,7 @@
+ 		 <dl>
+             <dt><label for="priority">{L_FORUMS_NEWS_FROM}{L_COLON}</label><br /><span>{L_FORUMS_FROM_EXPLAIN}</span></dt>
+             <dd><select size="1" id="forums" name="newsletter_forums[]" multiple style="max-width:200px;max-height:160px;height:160px;">
+-            <!-- BEGIN forumrows -->
+-            <option value="{forumrows.ID}"{forumrows.SELECTED}>{forumrows.FORUMNAME}</option>
+-            <!-- END forumrows -->
++            {S_FORUM_LIST}
+             </select></dd>
+         </dl>
+         <dl>
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\newsletter/controller/main_controller.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/controller/main_controller.php"
+index ef6fa0976..843f7ad46 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\newsletter/controller/main_controller.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/controller/main_controller.php"
+@@ -102,7 +102,7 @@ class main_controller
+ 					$sql = 'UPDATE ' . USERS_TABLE . ' SET user_allow_massemail = 1 WHERE user_id = ' . $this->user->data['user_id'];
+ 					$this->db->sql_query($sql);
+ 
+-					$this->template->assign_vars(array('REGISTER' => true, 'BEDANKT' => $this->user->lang['SUBSCRIBED']));
++					$this->template->assign_vars(array('REGISTER' => true, 'THANKS' => $this->user->lang['SUBSCRIBED']));
+ 				} else
+ 				{
+ 					$sql = 'SELECT user_id, user_password FROM ' . USERS_TABLE . $emtype;
+@@ -121,10 +121,10 @@ class main_controller
+ 								$sql = 'UPDATE ' . USERS_TABLE . ' SET user_allow_massemail = 1 WHERE user_id = ' . $userid;
+ 								$this->db->sql_query($sql);
+ 
+-								$this->template->assign_vars(array('REGISTER' => true, 'BEDANKT' => $this->user->lang['SUBSCRIBED']));
++								$this->template->assign_vars(array('REGISTER' => true, 'THANKS' => $this->user->lang['SUBSCRIBED']));
+ 							} else
+ 							{
+-								$this->template->assign_vars(array('REGISTER' => true, 'BEDANKT' => $this->user->lang['LOGIN_ERROR_PASSWORD']));
++								$this->template->assign_vars(array('REGISTER' => true, 'THANKS' => $this->user->lang['LOGIN_ERROR_PASSWORD']));
+ 							}
+ 						} else
+ 						{
+@@ -186,13 +186,13 @@ class main_controller
+ 
+ 								// Replace "error" strings with their real, localised form
+ 								$error = array_map(array($this->user, 'lang'), $error);
+-								$this->template->assign_vars(array('REGISTER' => true, 'BEDANKT' => implode('<br />', $error) ));
++								$this->template->assign_vars(array('REGISTER' => true, 'THANKS' => implode('<br />', $error) ));
+ 							} else
+ 							{
+ 								$user_id = user_add($data);
+ 								$result = $this->auth->login($uname, $pass);
+ 
+-								$this->template->assign_vars(array('REGISTER' => true, 'BEDANKT' => $this->user->lang['SUBSCRIBED']));
++								$this->template->assign_vars(array('REGISTER' => true, 'THANKS' => $this->user->lang['SUBSCRIBED']));
+ 							}
+ 						} else
+ 						{
+@@ -212,7 +212,7 @@ class main_controller
+ 					$sql = 'UPDATE ' . USERS_TABLE . ' SET user_allow_massemail = 0 WHERE user_id = ' . $this->user->data['user_id'];
+ 					$this->db->sql_query($sql);
+ 
+-					$this->template->assign_vars(array('REGISTER' => true, 'BEDANKT' => $this->user->lang['UNSUBSCRIBED']));
++					$this->template->assign_vars(array('REGISTER' => true, 'THANKS' => $this->user->lang['UNSUBSCRIBED']));
+ 				} else
+ 				{
+ 					$sql = 'SELECT user_id, username, user_password
+@@ -232,10 +232,10 @@ class main_controller
+ 								$sql = 'UPDATE ' . USERS_TABLE . ' SET user_allow_massemail = 0 WHERE user_id = ' . $userid;
+ 								$this->db->sql_query($sql);
+ 
+-								$this->template->assign_vars(array('REGISTER' => true, 'BEDANKT' => $this->user->lang['UNSUBSCRIBED']));
++								$this->template->assign_vars(array('REGISTER' => true, 'THANKS' => $this->user->lang['UNSUBSCRIBED']));
+ 							} else
+ 							{
+-								$this->template->assign_vars(array('REGISTER' => true, 'BEDANKT' => $this->user->lang['LOGIN_ERROR_PASSWORD']));
++								$this->template->assign_vars(array('REGISTER' => true, 'THANKS' => $this->user->lang['LOGIN_ERROR_PASSWORD']));
+ 							}
+ 						} else
+ 						{
+@@ -364,15 +364,15 @@ class main_controller
+ 			$archive_rows = array();
+ 			foreach ($season as $key => $a)
+ 			{
+-				$sql = 'SELECT id, subject, time as datum FROM ' . $this->newsletter_table . '
+-						WHERE display_it = 1 AND time BETWEEN ' . $a['datebegin'] . ' AND ' . $a['dateend'] . ' ORDER BY datum DESC';
++				$sql = 'SELECT id, subject, time as dates FROM ' . $this->newsletter_table . '
++						WHERE display_it = 1 AND time BETWEEN ' . $a['datebegin'] . ' AND ' . $a['dateend'] . ' ORDER BY dates DESC';
+ 				$result = $this->db->sql_query($sql);
+ 				while ($row = $this->db->sql_fetchrow($result))
+ 				{
+ 					if ($key != $last_mon)
+ 					{
+ 						$archive_row = array(
+-							'ARCHIVE'	=> $this->user->format_date($row['datum'], 'Y'),
++							'ARCHIVE'	=> $this->user->format_date($row['dates'], 'Y'),
+ 							'monthrow'	=> array(),
+ 						);
+ 						$archive_rows[] = $archive_row;
+@@ -381,7 +381,7 @@ class main_controller
+ 					$archive_row_month = array(
+ 						'TITLE'			=> $row['subject'],
+ 						'U_VIEW'		=> $row['id'],
+-						'DATE'			=> $this->user->format_date($row['datum'], 'j F Y'),
++						'DATE'			=> $this->user->format_date($row['dates'], 'j F Y'),
+ 					);
+ 
+ 					$archive_rows[sizeof($archive_rows) - 1]['monthrow'][] = $archive_row_month;
+@@ -410,13 +410,13 @@ class main_controller
+ 
+ 	protected function season($time)
+ 	{
+-		$sql = 'SELECT DISTINCT FROM_UNIXTIME(time, "%Y") AS jaar FROM ' . $this->newsletter_table . ' WHERE display_it = 1 ORDER BY jaar DESC';
++		$sql = 'SELECT DISTINCT FROM_UNIXTIME(time, "%Y") AS years FROM ' . $this->newsletter_table . ' WHERE display_it = 1 ORDER BY years DESC';
+ 		$result = $this->db->sql_query($sql);
+ 		$i = 1;
+ 		$season = array();
+ 		while ($row = $this->db->sql_fetchrow($result))
+ 		{
+-			$season[$i] = array('datebegin' => strtotime($row['jaar'] . '-01-01 00:00:01'), 'dateend' => strtotime($row['jaar'] . '-12-31 23:59:59'));
++			$season[$i] = array('datebegin' => strtotime($row['years'] . '-01-01 00:00:01'), 'dateend' => strtotime($row['years'] . '-12-31 23:59:59'));
+ 			$i++;
+ 		}
+ 		$result = array();
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/diff_full.tmp"
+new file mode 100644
+index 000000000..9e71eac1f
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/diff_full.tmp"
+@@ -0,0 +1,3964 @@
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\newsletter/acp/newsletter_module.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/acp/newsletter_module.php"
++index 4d91cc708..bc694dc33 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\newsletter/acp/newsletter_module.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/acp/newsletter_module.php"
++@@ -186,22 +186,13 @@ class newsletter_module
++ 						'LANG'			=> $row['lang_local_name']
++ 					));
++ 				}
++-		
++-				$sql = 'SELECT forum_id, forum_name FROM ' . FORUMS_TABLE . ' WHERE forum_type = 1 ORDER BY forum_name';
++-				$result = $this->db->sql_query($sql);
+++
++ 				$forum_ary = json_decode($this->config['newsletter_forums'], true);
++-				while ($row = $this->db->sql_fetchrow($result))
++-				{
++-					$template->assign_block_vars('forumrows', array(
++-						'ID'			=> $row['forum_id'],
++-						'FORUMNAME'		=> $row['forum_name'],
++-						'SELECTED'		=> (in_array($row['forum_id'], $forum_ary)) ? ' selected="selected"' : '',
++-					));
++-				}
++-				$this->db->sql_freeresult($result);
++-		
+++				$forum_list = make_forum_select($forum_ary, false, true, true);
+++
++ 				$enable_html = $phpbb_container->get('ext.manager')->is_enabled('forumhulp/htmlemail');
++ 				$template->assign_vars(array(
+++					'S_FORUM_LIST'			=> $forum_list,
++ 					'WARNING_MSG'			=> (sizeof($error)) ? implode('<br />', $error) : '',
++ 					'U_ACTION'				=> $this->u_action,
++ 					'S_GROUP_OPTIONS'		=> $select_list,
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\newsletter/adm/style/acp_newsletter.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/adm/style/acp_newsletter.html"
++index c2a94d65c..89e58f775 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\newsletter/adm/style/acp_newsletter.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/adm/style/acp_newsletter.html"
++@@ -53,9 +53,7 @@
++ 		 <dl>
++             <dt><label for="priority">{L_FORUMS_NEWS_FROM}{L_COLON}</label><br /><span>{L_FORUMS_FROM_EXPLAIN}</span></dt>
++             <dd><select size="1" id="forums" name="newsletter_forums[]" multiple style="max-width:200px;max-height:160px;height:160px;">
++-            <!-- BEGIN forumrows -->
++-            <option value="{forumrows.ID}"{forumrows.SELECTED}>{forumrows.FORUMNAME}</option>
++-            <!-- END forumrows -->
+++            {S_FORUM_LIST}
++             </select></dd>
++         </dl>
++         <dl>
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\newsletter/controller/main_controller.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/controller/main_controller.php"
++index ef6fa0976..843f7ad46 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\newsletter/controller/main_controller.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/controller/main_controller.php"
++@@ -102,7 +102,7 @@ class main_controller
++ 					$sql = 'UPDATE ' . USERS_TABLE . ' SET user_allow_massemail = 1 WHERE user_id = ' . $this->user->data['user_id'];
++ 					$this->db->sql_query($sql);
++ 
++-					$this->template->assign_vars(array('REGISTER' => true, 'BEDANKT' => $this->user->lang['SUBSCRIBED']));
+++					$this->template->assign_vars(array('REGISTER' => true, 'THANKS' => $this->user->lang['SUBSCRIBED']));
++ 				} else
++ 				{
++ 					$sql = 'SELECT user_id, user_password FROM ' . USERS_TABLE . $emtype;
++@@ -121,10 +121,10 @@ class main_controller
++ 								$sql = 'UPDATE ' . USERS_TABLE . ' SET user_allow_massemail = 1 WHERE user_id = ' . $userid;
++ 								$this->db->sql_query($sql);
++ 
++-								$this->template->assign_vars(array('REGISTER' => true, 'BEDANKT' => $this->user->lang['SUBSCRIBED']));
+++								$this->template->assign_vars(array('REGISTER' => true, 'THANKS' => $this->user->lang['SUBSCRIBED']));
++ 							} else
++ 							{
++-								$this->template->assign_vars(array('REGISTER' => true, 'BEDANKT' => $this->user->lang['LOGIN_ERROR_PASSWORD']));
+++								$this->template->assign_vars(array('REGISTER' => true, 'THANKS' => $this->user->lang['LOGIN_ERROR_PASSWORD']));
++ 							}
++ 						} else
++ 						{
++@@ -186,13 +186,13 @@ class main_controller
++ 
++ 								// Replace "error" strings with their real, localised form
++ 								$error = array_map(array($this->user, 'lang'), $error);
++-								$this->template->assign_vars(array('REGISTER' => true, 'BEDANKT' => implode('<br />', $error) ));
+++								$this->template->assign_vars(array('REGISTER' => true, 'THANKS' => implode('<br />', $error) ));
++ 							} else
++ 							{
++ 								$user_id = user_add($data);
++ 								$result = $this->auth->login($uname, $pass);
++ 
++-								$this->template->assign_vars(array('REGISTER' => true, 'BEDANKT' => $this->user->lang['SUBSCRIBED']));
+++								$this->template->assign_vars(array('REGISTER' => true, 'THANKS' => $this->user->lang['SUBSCRIBED']));
++ 							}
++ 						} else
++ 						{
++@@ -212,7 +212,7 @@ class main_controller
++ 					$sql = 'UPDATE ' . USERS_TABLE . ' SET user_allow_massemail = 0 WHERE user_id = ' . $this->user->data['user_id'];
++ 					$this->db->sql_query($sql);
++ 
++-					$this->template->assign_vars(array('REGISTER' => true, 'BEDANKT' => $this->user->lang['UNSUBSCRIBED']));
+++					$this->template->assign_vars(array('REGISTER' => true, 'THANKS' => $this->user->lang['UNSUBSCRIBED']));
++ 				} else
++ 				{
++ 					$sql = 'SELECT user_id, username, user_password
++@@ -232,10 +232,10 @@ class main_controller
++ 								$sql = 'UPDATE ' . USERS_TABLE . ' SET user_allow_massemail = 0 WHERE user_id = ' . $userid;
++ 								$this->db->sql_query($sql);
++ 
++-								$this->template->assign_vars(array('REGISTER' => true, 'BEDANKT' => $this->user->lang['UNSUBSCRIBED']));
+++								$this->template->assign_vars(array('REGISTER' => true, 'THANKS' => $this->user->lang['UNSUBSCRIBED']));
++ 							} else
++ 							{
++-								$this->template->assign_vars(array('REGISTER' => true, 'BEDANKT' => $this->user->lang['LOGIN_ERROR_PASSWORD']));
+++								$this->template->assign_vars(array('REGISTER' => true, 'THANKS' => $this->user->lang['LOGIN_ERROR_PASSWORD']));
++ 							}
++ 						} else
++ 						{
++@@ -364,15 +364,15 @@ class main_controller
++ 			$archive_rows = array();
++ 			foreach ($season as $key => $a)
++ 			{
++-				$sql = 'SELECT id, subject, time as datum FROM ' . $this->newsletter_table . '
++-						WHERE display_it = 1 AND time BETWEEN ' . $a['datebegin'] . ' AND ' . $a['dateend'] . ' ORDER BY datum DESC';
+++				$sql = 'SELECT id, subject, time as dates FROM ' . $this->newsletter_table . '
+++						WHERE display_it = 1 AND time BETWEEN ' . $a['datebegin'] . ' AND ' . $a['dateend'] . ' ORDER BY dates DESC';
++ 				$result = $this->db->sql_query($sql);
++ 				while ($row = $this->db->sql_fetchrow($result))
++ 				{
++ 					if ($key != $last_mon)
++ 					{
++ 						$archive_row = array(
++-							'ARCHIVE'	=> $this->user->format_date($row['datum'], 'Y'),
+++							'ARCHIVE'	=> $this->user->format_date($row['dates'], 'Y'),
++ 							'monthrow'	=> array(),
++ 						);
++ 						$archive_rows[] = $archive_row;
++@@ -381,7 +381,7 @@ class main_controller
++ 					$archive_row_month = array(
++ 						'TITLE'			=> $row['subject'],
++ 						'U_VIEW'		=> $row['id'],
++-						'DATE'			=> $this->user->format_date($row['datum'], 'j F Y'),
+++						'DATE'			=> $this->user->format_date($row['dates'], 'j F Y'),
++ 					);
++ 
++ 					$archive_rows[sizeof($archive_rows) - 1]['monthrow'][] = $archive_row_month;
++@@ -410,13 +410,13 @@ class main_controller
++ 
++ 	protected function season($time)
++ 	{
++-		$sql = 'SELECT DISTINCT FROM_UNIXTIME(time, "%Y") AS jaar FROM ' . $this->newsletter_table . ' WHERE display_it = 1 ORDER BY jaar DESC';
+++		$sql = 'SELECT DISTINCT FROM_UNIXTIME(time, "%Y") AS years FROM ' . $this->newsletter_table . ' WHERE display_it = 1 ORDER BY years DESC';
++ 		$result = $this->db->sql_query($sql);
++ 		$i = 1;
++ 		$season = array();
++ 		while ($row = $this->db->sql_fetchrow($result))
++ 		{
++-			$season[$i] = array('datebegin' => strtotime($row['jaar'] . '-01-01 00:00:01'), 'dateend' => strtotime($row['jaar'] . '-12-31 23:59:59'));
+++			$season[$i] = array('datebegin' => strtotime($row['years'] . '-01-01 00:00:01'), 'dateend' => strtotime($row['years'] . '-12-31 23:59:59'));
++ 			$i++;
++ 		}
++ 		$result = array();
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/diff_full.tmp"
++new file mode 100644
++index 000000000..081bef4ca
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/diff_full.tmp"
++@@ -0,0 +1,149 @@
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\newsletter/acp/newsletter_module.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/acp/newsletter_module.php"
+++index 4d91cc708..bc694dc33 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\newsletter/acp/newsletter_module.php"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/acp/newsletter_module.php"
+++@@ -186,22 +186,13 @@ class newsletter_module
+++ 						'LANG'			=> $row['lang_local_name']
+++ 					));
+++ 				}
+++-		
+++-				$sql = 'SELECT forum_id, forum_name FROM ' . FORUMS_TABLE . ' WHERE forum_type = 1 ORDER BY forum_name';
+++-				$result = $this->db->sql_query($sql);
++++
+++ 				$forum_ary = json_decode($this->config['newsletter_forums'], true);
+++-				while ($row = $this->db->sql_fetchrow($result))
+++-				{
+++-					$template->assign_block_vars('forumrows', array(
+++-						'ID'			=> $row['forum_id'],
+++-						'FORUMNAME'		=> $row['forum_name'],
+++-						'SELECTED'		=> (in_array($row['forum_id'], $forum_ary)) ? ' selected="selected"' : '',
+++-					));
+++-				}
+++-				$this->db->sql_freeresult($result);
+++-		
++++				$forum_list = make_forum_select($forum_ary, false, true, true);
++++
+++ 				$enable_html = $phpbb_container->get('ext.manager')->is_enabled('forumhulp/htmlemail');
+++ 				$template->assign_vars(array(
++++					'S_FORUM_LIST'			=> $forum_list,
+++ 					'WARNING_MSG'			=> (sizeof($error)) ? implode('<br />', $error) : '',
+++ 					'U_ACTION'				=> $this->u_action,
+++ 					'S_GROUP_OPTIONS'		=> $select_list,
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\newsletter/adm/style/acp_newsletter.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/adm/style/acp_newsletter.html"
+++index c2a94d65c..89e58f775 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\newsletter/adm/style/acp_newsletter.html"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/adm/style/acp_newsletter.html"
+++@@ -53,9 +53,7 @@
+++ 		 <dl>
+++             <dt><label for="priority">{L_FORUMS_NEWS_FROM}{L_COLON}</label><br /><span>{L_FORUMS_FROM_EXPLAIN}</span></dt>
+++             <dd><select size="1" id="forums" name="newsletter_forums[]" multiple style="max-width:200px;max-height:160px;height:160px;">
+++-            <!-- BEGIN forumrows -->
+++-            <option value="{forumrows.ID}"{forumrows.SELECTED}>{forumrows.FORUMNAME}</option>
+++-            <!-- END forumrows -->
++++            {S_FORUM_LIST}
+++             </select></dd>
+++         </dl>
+++         <dl>
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\newsletter/controller/main_controller.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/controller/main_controller.php"
+++index ef6fa0976..843f7ad46 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\newsletter/controller/main_controller.php"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/controller/main_controller.php"
+++@@ -102,7 +102,7 @@ class main_controller
+++ 					$sql = 'UPDATE ' . USERS_TABLE . ' SET user_allow_massemail = 1 WHERE user_id = ' . $this->user->data['user_id'];
+++ 					$this->db->sql_query($sql);
+++ 
+++-					$this->template->assign_vars(array('REGISTER' => true, 'BEDANKT' => $this->user->lang['SUBSCRIBED']));
++++					$this->template->assign_vars(array('REGISTER' => true, 'THANKS' => $this->user->lang['SUBSCRIBED']));
+++ 				} else
+++ 				{
+++ 					$sql = 'SELECT user_id, user_password FROM ' . USERS_TABLE . $emtype;
+++@@ -121,10 +121,10 @@ class main_controller
+++ 								$sql = 'UPDATE ' . USERS_TABLE . ' SET user_allow_massemail = 1 WHERE user_id = ' . $userid;
+++ 								$this->db->sql_query($sql);
+++ 
+++-								$this->template->assign_vars(array('REGISTER' => true, 'BEDANKT' => $this->user->lang['SUBSCRIBED']));
++++								$this->template->assign_vars(array('REGISTER' => true, 'THANKS' => $this->user->lang['SUBSCRIBED']));
+++ 							} else
+++ 							{
+++-								$this->template->assign_vars(array('REGISTER' => true, 'BEDANKT' => $this->user->lang['LOGIN_ERROR_PASSWORD']));
++++								$this->template->assign_vars(array('REGISTER' => true, 'THANKS' => $this->user->lang['LOGIN_ERROR_PASSWORD']));
+++ 							}
+++ 						} else
+++ 						{
+++@@ -186,13 +186,13 @@ class main_controller
+++ 
+++ 								// Replace "error" strings with their real, localised form
+++ 								$error = array_map(array($this->user, 'lang'), $error);
+++-								$this->template->assign_vars(array('REGISTER' => true, 'BEDANKT' => implode('<br />', $error) ));
++++								$this->template->assign_vars(array('REGISTER' => true, 'THANKS' => implode('<br />', $error) ));
+++ 							} else
+++ 							{
+++ 								$user_id = user_add($data);
+++ 								$result = $this->auth->login($uname, $pass);
+++ 
+++-								$this->template->assign_vars(array('REGISTER' => true, 'BEDANKT' => $this->user->lang['SUBSCRIBED']));
++++								$this->template->assign_vars(array('REGISTER' => true, 'THANKS' => $this->user->lang['SUBSCRIBED']));
+++ 							}
+++ 						} else
+++ 						{
+++@@ -212,7 +212,7 @@ class main_controller
+++ 					$sql = 'UPDATE ' . USERS_TABLE . ' SET user_allow_massemail = 0 WHERE user_id = ' . $this->user->data['user_id'];
+++ 					$this->db->sql_query($sql);
+++ 
+++-					$this->template->assign_vars(array('REGISTER' => true, 'BEDANKT' => $this->user->lang['UNSUBSCRIBED']));
++++					$this->template->assign_vars(array('REGISTER' => true, 'THANKS' => $this->user->lang['UNSUBSCRIBED']));
+++ 				} else
+++ 				{
+++ 					$sql = 'SELECT user_id, username, user_password
+++@@ -232,10 +232,10 @@ class main_controller
+++ 								$sql = 'UPDATE ' . USERS_TABLE . ' SET user_allow_massemail = 0 WHERE user_id = ' . $userid;
+++ 								$this->db->sql_query($sql);
+++ 
+++-								$this->template->assign_vars(array('REGISTER' => true, 'BEDANKT' => $this->user->lang['UNSUBSCRIBED']));
++++								$this->template->assign_vars(array('REGISTER' => true, 'THANKS' => $this->user->lang['UNSUBSCRIBED']));
+++ 							} else
+++ 							{
+++-								$this->template->assign_vars(array('REGISTER' => true, 'BEDANKT' => $this->user->lang['LOGIN_ERROR_PASSWORD']));
++++								$this->template->assign_vars(array('REGISTER' => true, 'THANKS' => $this->user->lang['LOGIN_ERROR_PASSWORD']));
+++ 							}
+++ 						} else
+++ 						{
+++@@ -364,15 +364,15 @@ class main_controller
+++ 			$archive_rows = array();
+++ 			foreach ($season as $key => $a)
+++ 			{
+++-				$sql = 'SELECT id, subject, time as datum FROM ' . $this->newsletter_table . '
+++-						WHERE display_it = 1 AND time BETWEEN ' . $a['datebegin'] . ' AND ' . $a['dateend'] . ' ORDER BY datum DESC';
++++				$sql = 'SELECT id, subject, time as dates FROM ' . $this->newsletter_table . '
++++						WHERE display_it = 1 AND time BETWEEN ' . $a['datebegin'] . ' AND ' . $a['dateend'] . ' ORDER BY dates DESC';
+++ 				$result = $this->db->sql_query($sql);
+++ 				while ($row = $this->db->sql_fetchrow($result))
+++ 				{
+++ 					if ($key != $last_mon)
+++ 					{
+++ 						$archive_row = array(
+++-							'ARCHIVE'	=> $this->user->format_date($row['datum'], 'Y'),
++++							'ARCHIVE'	=> $this->user->format_date($row['dates'], 'Y'),
+++ 							'monthrow'	=> array(),
+++ 						);
+++ 						$archive_rows[] = $archive_row;
+++@@ -381,7 +381,7 @@ class main_controller
+++ 					$archive_row_month = array(
+++ 						'TITLE'			=> $row['subject'],
+++ 						'U_VIEW'		=> $row['id'],
+++-						'DATE'			=> $this->user->format_date($row['datum'], 'j F Y'),
++++						'DATE'			=> $this->user->format_date($row['dates'], 'j F Y'),
+++ 					);
+++ 
+++ 					$archive_rows[sizeof($archive_rows) - 1]['monthrow'][] = $archive_row_month;
+++@@ -410,13 +410,13 @@ class main_controller
+++ 
+++ 	protected function season($time)
+++ 	{
+++-		$sql = 'SELECT DISTINCT FROM_UNIXTIME(time, "%Y") AS jaar FROM ' . $this->newsletter_table . ' WHERE display_it = 1 ORDER BY jaar DESC';
++++		$sql = 'SELECT DISTINCT FROM_UNIXTIME(time, "%Y") AS years FROM ' . $this->newsletter_table . ' WHERE display_it = 1 ORDER BY years DESC';
+++ 		$result = $this->db->sql_query($sql);
+++ 		$i = 1;
+++ 		$season = array();
+++ 		while ($row = $this->db->sql_fetchrow($result))
+++ 	
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\newsletter/helper/helper.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/helper/helper.php"
++index da09f75de..2b5ad55ce 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\newsletter/helper/helper.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/helper/helper.php"
++@@ -136,7 +136,7 @@ class helper
++ 			$messenger->headers('X-AntiAbuse: Username - ' . $this->user->data['username']);
++ 			$messenger->headers('X-AntiAbuse: User IP - ' . $this->user->ip);
++ 			$messenger->assign_vars(array(
++-				'SITE_LOGO_IMG'		=> $server_url . '/ext/sitesplat/newsletter/vendor/assets/images/github-logo.png',
+++				'SITE_LOGO_IMG'		=> $server_url . '/ext/sitesplat/newsletter/vendor/assets/images/gold-logo.png',
++ 				'BOARD_URL'			=> $server_url,
++ 				'NEWSLETTER_ONLINE'	=> preg_replace("/$this->php_ext(&amp;|&)+?/", "$this->php_ext?", preg_replace('/(\?)?(&amp;|&)?sid=[a-z0-9]+/', '', 
++ 									   $this->helper->route('sitesplat_newsletter_main_controller', array('route' => 'index.html'), true, '', UrlGeneratorInterface::ABSOLUTE_URL))),
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\newsletter/language/en/email/newsletter_html.txt" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/language/en/email/newsletter_html.txt"
++index 5810c31ab..395fa3f4e 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\newsletter/language/en/email/newsletter_html.txt"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/language/en/email/newsletter_html.txt"
++@@ -1,8 +1,290 @@
++-Subject: Newsletter from "{SITENAME}"
+++<!DOCTYPE html>
+++<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
++ 
++-{MESSAGE}
+++<head>
+++  <meta charset="utf-8"> <!-- utf-8 works for most cases -->
+++  <meta name="viewport" content="width=device-width"> <!-- Forcing initial-scale shouldn't be necessary -->
+++  <meta http-equiv="X-UA-Compatible" content="IE=edge"> <!-- Use the latest (edge) version of IE rendering engine -->
+++  <meta name="x-apple-disable-message-reformatting"> <!-- Disable auto-scale in iOS 10 Mail entirely -->
++ 
++-<p>
++-   <a href="{NEWSLETTER_ONLINE}">All newsletter online</a>
++-   <p>Don't want to receive our newsletter anymore? Unsubscribe <a href="{NEWSLETTER_OPTOUT}">here</a></p>
++-</p>
++\ No newline at end of file
+++  <!-- Web Font / @font-face : BEGIN -->
+++  <!-- NOTE: If web fonts are not required, lines 10 - 27 can be safely removed. -->
+++
+++  <!-- Desktop Outlook chokes on web font references and defaults to Times New Roman, so we force a safe fallback font. -->
+++  <!--[if mso]>
+++        <style>
+++            * {
+++                font-family: sans-serif !important;
+++            }
+++        </style>
+++    <![endif]-->
+++
+++  <!-- All other clients get the webfont reference; some will render the font and others will silently fail to the fallbacks. More on that here: http://stylecampaign.com/blog/2015/02/webfont-support-in-email/ -->
+++  <!--[if !mso]><!-->
+++  <!-- insert web font reference, eg: <link href='https://fonts.googleapis.com/css?family=Roboto:400,700' rel='stylesheet' type='text/css'> -->
+++  <!--<![endif]-->
+++
+++  <!-- Web Font / @font-face : END -->
+++
+++  <!-- CSS Reset : BEGIN -->
+++  <style>
+++    /* What it does: Remove spaces around the email design added by some email clients. */
+++    /* Beware: It can remove the padding / margin and add a background color to the compose a reply window. */
+++    html,
+++    body {
+++      margin: 0 auto !important;
+++      padding: 0 !important;
+++      height: 100% !important;
+++      width: 100% !important;
+++    }
+++
+++    /* What it does: Stops email clients resizing small text. */
+++    * {
+++      -ms-text-size-adjust: 100%;
+++      -webkit-text-size-adjust: 100%;
+++    }
+++
+++    /* What it does: Centers email on Android 4.4 */
+++    div[style*="margin: 16px 0"] {
+++      margin: 0 !important;
+++    }
+++
+++    /* What it does: Stops Outlook from adding extra spacing to tables. */
+++    table,
+++    td {
+++      mso-table-lspace: 0pt !important;
+++      mso-table-rspace: 0pt !important;
+++    }
+++
+++    /* What it does: Fixes webkit padding issue. Fix for Yahoo mail table alignment bug. Applies table-layout to the first 2 tables then removes for anything nested deeper. */
+++    table {
+++      border-spacing: 0 !important;
+++      border-collapse: collapse !important;
+++      table-layout: fixed !important;
+++      margin: 0 auto !important;
+++    }
+++
+++    table table table {
+++      table-layout: auto;
+++    }
+++
+++    /* What it does: Uses a better rendering method when resizing images in IE. */
+++    img {
+++      -ms-interpolation-mode: bicubic;
+++    }
+++
+++    /* What it does: A work-around for email clients meddling in triggered links. */
+++    *[x-apple-data-detectors],
+++    /* iOS */
+++    .x-gmail-data-detectors,
+++    /* Gmail */
+++    .x-gmail-data-detectors *,
+++    .aBn {
+++      border-bottom: 0 !important;
+++      cursor: default !important;
+++      color: inherit !important;
+++      text-decoration: none !important;
+++      font-size: inherit !important;
+++      font-family: inherit !important;
+++      font-weight: inherit !important;
+++      line-height: inherit !important;
+++    }
+++
+++    /* What it does: Prevents Gmail from displaying an download button on large, non-linked images. */
+++    .a6S {
+++      display: none !important;
+++      opacity: 0.01 !important;
+++    }
+++
+++    /* If the above doesn't work, add a .g-img class to any image in question. */
+++    img.g-img+div {
+++      display: none !important;
+++    }
+++
+++    /* What it does: Prevents underlining the button text in Windows 10 */
+++    .button-link {
+++      text-decoration: none !important;
+++    }
+++
+++    /* What it does: Removes right gutter in Gmail iOS app: https://github.com/TedGoas/Cerberus/issues/89  */
+++    /* Create one of these media queries for each additional viewport size you'd like to fix */
+++    /* Thanks to Eric Lepetit (@ericlepetitsf) for help troubleshooting */
+++    @media only screen and (min-device-width: 375px) and (max-device-width: 413px) {
+++
+++      /* iPhone 6 and 6+ */
+++      .email-container {
+++        min-width: 375px !important;
+++      }
+++    }
+++
+++    @media screen and (max-width: 480px) {
+++
+++      /* What it does: Forces Gmail app to display email full width */
+++      u~div .email-container {
+++        min-width: 100vw;
+++        width: 100% !important;
+++      }
+++    }
+++  </style>
+++  <!-- CSS Reset : END -->
+++
+++  <!-- Progressive Enhancements : BEGIN -->
+++  <style>
+++    /* What it does: Hover styles for buttons */
+++    .button-td,
+++    .button-a {
+++      transition: all 100ms ease-in;
+++    }
+++
+++    .button-td:hover,
+++    .button-a:hover {
+++      background: #CC9900 !important;
+++      border-color: #CC9900 !important;
+++    }
+++
+++    /* Define o estilo dos links */
+++    a:link {
+++      color: #CC9900;
+++      background-color: transparent;
+++      text-decoration: none;
+++    }
+++
+++    a:visited {
+++      color: #CC9900;
+++      background-color: transparent;
+++      text-decoration: none;
+++    }
+++
+++    a:hover {
+++      color: #CC9900;
+++      background-color: transparent;
+++      text-decoration: underline;
+++    }
+++
+++    a:active {
+++      color: #CC9900;
+++      background-color: transparent;
+++      text-decoration: underline;
+++    }
+++
+++    /* Media Queries */
+++    @media screen and (max-width: 600px) {
+++
+++      .email-container {
+++        width: 100% !important;
+++        margin: auto !important;
+++      }
+++
+++      /* What it does: Forces elements to resize to the full width of their container. Useful for resizing images beyond their max-width. */
+++      .fluid {
+++        max-width: 100% !important;
+++        height: auto !important;
+++        margin-left: auto !important;
+++        margin-right: auto !important;
+++      }
+++
+++      /* What it does: Forces table cells into full-width rows. */
+++      .stack-column,
+++      .stack-column-center {
+++        display: block !important;
+++        width: 100% !important;
+++        max-width: 100% !important;
+++        direction: ltr !important;
+++      }
+++
+++      /* And center justify these ones. */
+++      .stack-column-center {
+++        text-align: center !important;
+++      }
+++
+++      /* What it does: Generic utility class for centering. Useful for images, buttons, and nested tables. */
+++      .center-on-narrow {
+++        text-align: center !important;
+++        display: block !important;
+++        margin-left: auto !important;
+++        margin-right: auto !important;
+++        float: none !important;
+++      }
+++
+++      table.center-on-narrow {
+++        display: inline-block !important;
+++      }
+++
+++      /* What it does: Adjust typography on small screens to improve readability */
+++      .email-container p {
+++        font-size: 17px !important;
+++      }
+++    }
+++  </style>
+++  <!-- Progressive Enhancements : END -->
+++
+++  <!-- What it does: Makes background images in 72ppi Outlook render at correct size. -->
+++  <!--[if gte mso 9]>
+++    <xml>
+++        <o:OfficeDocumentSettings>
+++            <o:AllowPNG/>
+++            <o:PixelsPerInch>96</o:PixelsPerInch>
+++        </o:OfficeDocumentSettings>
+++    </xml>
+++    <![endif]-->
+++
+++</head>
+++
+++<body width="100%" bgcolor="#222222" style="margin: 0; mso-line-height-rule: exactly;">
+++  <center style="width: 100%; background: #fafafa; text-align: left;">
+++
+++    <!-- Email Header : BEGIN -->
+++    <table role="presentation" cellspacing="0" cellpadding="0" border="0" align="center" width="600" style="margin: auto;" class="email-container" bgcolor="#1E1E1E">
+++      <tr>
+++        <td style="padding: 20px 0; text-align: center">
+++          <a href="https://goldtuganime.com" target="_blank"><img src="https://upload.goldtuganime.com/redes-sociais/GTA_Logo_Newsletter.png" width="282" border="0" style="height: auto; font-family: sans-serif; font-size: 15px; line-height: 140%; color: #555555;"></a>
+++        </td>
+++      </tr>
+++    </table>
+++    <!-- Email Header : END -->
+++
+++    {MESSAGE}
+++
+++    <!-- Email Footer : BEGIN -->
+++    <table role="presentation" bgcolor="#1E1E1E" cellspacing="0" cellpadding="0" border="0" align="center" width="100%" style="max-width: 600px; font-family: sans-serif; color: #888888; font-size: 11px; line-height: 140%;">
+++      <tr>
+++        <td style="padding: 10px 10px; width: 100%; font-family: sans-serif; font-size: 12px; line-height: 140%; text-align: center; color: #888888;" class="x-gmail-data-detectors">
+++          <table width="300" border="0" cellspacing="10" cellpadding="10">
+++            <tbody>
+++              <tr>
+++                <td><a href="https://www.facebook.com/goldtuganimeoficial/" target="_blank"><img src="https://upload.goldtuganime.com/redes-sociais/facebook-Y.png" height="24" width="24" class=""></a></td>
+++                <td><a href="https://www.instagram.com/goldtuganime/" target="_blank"><img src="https://upload.goldtuganime.com/redes-sociais/instagram-Y.png" height="24" width="24" class=""></a></td>
+++                <td><a href="https://discord.gg/Zk8CCZUG/" target="_blank"><img src="https://upload.goldtuganime.com/redes-sociais/discord-Y.png" height="24" width="24" class=""></a></td>
+++                <td><a href="https://www.youtube.com/@GoldTugAnimeOFICIAL" target="_blank"><img src="https://upload.goldtuganime.com/redes-sociais/youtube-Y.png" height="24" width="24" class=""></a></td>
+++                <td><a href="https://goldtuganime.com" target="_blank"><img src="https://upload.goldtuganime.com/redes-sociais/website-Y.png" height="24" width="24" class=""></a></td>
+++              </tr>
+++            </tbody>
+++          </table>
+++        </td>
+++      </tr>
+++    </table>
+++    <table role="presentation" cellspacing="0" cellpadding="0" border="0" align="center" width="100%" style="max-width: 600px; font-family: sans-serif; color: #888888; font-size: 11px; line-height: 140%;">
+++      <tr>
+++        <td style="padding: 10px 10px; width: 100%; font-family: sans-serif; font-size: 12px; line-height: 140%; text-align: center; color: #888888;" class="x-gmail-data-detectors"><em>Copyright © 2023 | <a href="https://goldtuganime.com" target="_blank">GoldTugAnime</a> | Todos os direitos reservados.</em></td>
+++      </tr>
+++      <tr>
+++        <td>
+++          <table width="400" border="0" cellspacing="0" cellpadding="0">
+++            <tbody>
+++              <tr>
+++                <td width="400" height="2" bgcolor="#CC9900" align="center" valign="bottom" style="padding: 0px;"></td>
+++              </tr>
+++            </tbody>
+++          </table>
+++        </td>
+++      </tr>
+++      <tr>
+++        <td style="padding: 10px 10px; width: 100%; font-family: sans-serif; font-size: 8px; line-height: 140%; text-align: center; color: #888888;" class="x-gmail-data-detectors">You are receiving this e-mail because you have a subscription in our forum. <a href="{NEWSLETTER_ONLINE}" target="_blank">check here</a> what newsletters you received or remove your e-mail address from our list through the link <a href="{NEWSLETTER_OPTOUT}" target="_blank">remove subscription</a>, in case you want to.
+++        </td>
+++      </tr>
+++    </table>
+++    <!-- Email Footer : END -->
+++  </center>
+++</body>
+++
+++</html>
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\newsletter/language/en/info_acp_newsletter.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/language/en/info_acp_newsletter.php"
++index ac655a364..cc9168a39 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\newsletter/language/en/info_acp_newsletter.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/language/en/info_acp_newsletter.php"
++@@ -25,7 +25,7 @@ $lang = array_merge($lang, array(
++ 	'SEND_IMMEDIATELY'			=> 'Send immediately',
++ 	'SEND_IMMEDIATELY_EXPLAIN'	=> 'Attempt to send the emails immediately. This depends on the server email configuration parameters',
++ 	'PERIOD'					=> 'Email Overview (or Catch-up) Period',
++-	'PERIOD_EXPLAIN'			=> 'This will send autmatic "Catch-up"  emails to the users that are subscribed. The e-mail will be generated based on the new topics in the forum. The user will receive an email with the purpose of engaging the user\'s interest in the recent board\'s activity. Edit the templates file named newsletter_html.txt for the HTML version and newsletter_txt.txt for the TXT version from:<br /> <code>root\ext\sitesplat\newsletter\language\en\email\</code> <br /> To learn how to send out professional looking HTML emails check out the tutorials over at <a href=" https://sitesplat.com/" target="_blank">sitesplat.com</a> or click the "Tutorials" label above.',
+++	'PERIOD_EXPLAIN'			=> 'This will send automatic "Catch-up"  emails to the users that are subscribed. The e-mail will be generated based on the new topics in the forum. The user will receive an email with the purpose of engaging the user\'s interest in the recent board\'s activity. Edit the templates file named newsletter_html.txt for the HTML version and newsletter_txt.txt for the TXT version from:<br /> <code>root\ext\sitesplat\newsletter\language\en\email\</code> <br /> To learn how to send out professional looking HTML emails check out the tutorials over at <a href=" https://sitesplat.com/" target="_blank">sitesplat.com</a> or click the "Tutorials" label above.',
++ 	'WEEKLY'					=> 'Weekly',
++ 	'MONTHLY'					=> 'Monthly',
++ 	'NO_OVERVIEW'				=> 'None',
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\newsletter/language/en/newsletter.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/language/en/newsletter.php"
++index c8d91f647..02aa2312c 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\newsletter/language/en/newsletter.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/language/en/newsletter.php"
++@@ -34,7 +34,7 @@ $lang = array_merge($lang, array(
++ 	'SUBSCRIBE_INFO'			=> 'Our newsletter. Unsubscribed members won\'t receive our periodic News overview anymore.',
++ 	
++ 	'OVERVIEW_ARCHIVE'			=> 'Archive',
++-	'ARCHIEVES'					=> 'Archives',
+++	'ARCHIVES'					=> 'Archives',
++ 	'SUBSCRIBED'				=> 'Thanks for subscribing! You will receive our newsletter from today on!',
++ 	'UNSUBSCRIBED'				=> 'Successfully unsubscribed, you won\'t receive our newsletter any longer'
++ ));
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/language/pt/email/index.htm" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/language/pt/email/index.htm"
++new file mode 100644
++index 000000000..ee1f723a7
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/language/pt/email/index.htm"
++@@ -0,0 +1,10 @@
+++<html>
+++<head>
+++<title></title>
+++<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
+++</head>
+++
+++<body bgcolor="#FFFFFF" text="#000000">
+++
+++</body>
+++</html>
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/language/pt/email/newsletter_html.txt" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/language/pt/email/newsletter_html.txt"
++new file mode 100644
++index 000000000..f06feec62
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/language/pt/email/newsletter_html.txt"
++@@ -0,0 +1,293 @@
+++Subject: {SUBJECT}
+++
+++<!DOCTYPE html>
+++<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
+++
+++<head>
+++  <meta charset="utf-8"> <!-- utf-8 works for most cases -->
+++  <meta name="viewport" content="width=device-width"> <!-- Forcing initial-scale shouldn't be necessary -->
+++  <meta http-equiv="X-UA-Compatible" content="IE=edge"> <!-- Use the latest (edge) version of IE rendering engine -->
+++  <meta name="x-apple-disable-message-reformatting"> <!-- Disable auto-scale in iOS 10 Mail entirely -->
+++
+++  <!-- Web Font / @font-face : BEGIN -->
+++  <!-- NOTE: If web fonts are not required, lines 10 - 27 can be safely removed. -->
+++
+++  <!-- Desktop Outlook chokes on web font references and defaults to Times New Roman, so we force a safe fallback font. -->
+++  <!--[if mso]>
+++        <style>
+++            * {
+++                font-family: sans-serif !important;
+++            }
+++        </style>
+++    <![endif]-->
+++
+++  <!-- All other clients get the webfont reference; some will render the font and others will silently fail to the fallbacks. More on that here: http://stylecampaign.com/blog/2015/02/webfont-support-in-email/ -->
+++  <!--[if !mso]><!-->
+++  <!-- insert web font reference, eg: <link href='https://fonts.googleapis.com/css?family=Roboto:400,700' rel='stylesheet' type='text/css'> -->
+++  <!--<![endif]-->
+++
+++  <!-- Web Font / @font-face : END -->
+++
+++  <!-- CSS Reset : BEGIN -->
+++  <style>
+++    /* What it does: Remove spaces around the email design added by some email clients. */
+++    /* Beware: It can remove the padding / margin and add a background color to the compose a reply window. */
+++    html,
+++    body {
+++      margin: 0 auto !important;
+++      padding: 0 !important;
+++      height: 100% !important;
+++      width: 100% !important;
+++    }
+++
+++    /* What it does: Stops email clients resizing small text. */
+++    * {
+++      -ms-text-size-adjust: 100%;
+++      -webkit-text-size-adjust: 100%;
+++    }
+++
+++    /* What it does: Centers email on Android 4.4 */
+++    div[style*="margin: 16px 0"] {
+++      margin: 0 !important;
+++    }
+++
+++    /* What it does: Stops Outlook from adding extra spacing to tables. */
+++    table,
+++    td {
+++      mso-table-lspace: 0pt !important;
+++      mso-table-rspace: 0pt !important;
+++    }
+++
+++    /* What it does: Fixes webkit padding issue. Fix for Yahoo mail table alignment bug. Applies table-layout to the first 2 tables then removes for anything nested deeper. */
+++    table {
+++      border-spacing: 0 !important;
+++      border-collapse: collapse !important;
+++      table-layout: fixed !important;
+++      margin: 0 auto !important;
+++    }
+++
+++    table table table {
+++      table-layout: auto;
+++    }
+++
+++    /* What it does: Uses a better rendering method when resizing images in IE. */
+++    img {
+++      -ms-interpolation-mode: bicubic;
+++    }
+++
+++    /* What it does: A work-around for email clients meddling in triggered links. */
+++    *[x-apple-data-detectors],
+++    /* iOS */
+++    .x-gmail-data-detectors,
+++    /* Gmail */
+++    .x-gmail-data-detectors *,
+++    .aBn {
+++      border-bottom: 0 !important;
+++      cursor: default !important;
+++      color: inherit !important;
+++      text-decoration: none !important;
+++      font-size: inherit !important;
+++      font-family: inherit !important;
+++      font-weight: inherit !important;
+++      line-height: inherit !important;
+++    }
+++
+++    /* What it does: Prevents Gmail from displaying an download button on large, non-linked images. */
+++    .a6S {
+++      display: none !important;
+++      opacity: 0.01 !important;
+++    }
+++
+++    /* If the above doesn't work, add a .g-img class to any image in question. */
+++    img.g-img+div {
+++      display: none !important;
+++    }
+++
+++    /* What it does: Prevents underlining the button text in Windows 10 */
+++    .button-link {
+++      text-decoration: none !important;
+++    }
+++
+++    /* What it does: Removes right gutter in Gmail iOS app: https://github.com/TedGoas/Cerberus/issues/89  */
+++    /* Create one of these media queries for each additional viewport size you'd like to fix */
+++    /* Thanks to Eric Lepetit (@ericlepetitsf) for help troubleshooting */
+++    @media only screen and (min-device-width: 375px) and (max-device-width: 413px) {
+++
+++      /* iPhone 6 and 6+ */
+++      .email-container {
+++        min-width: 375px !important;
+++      }
+++    }
+++
+++    @media screen and (max-width: 480px) {
+++
+++      /* What it does: Forces Gmail app to display email full width */
+++      u~div .email-container {
+++        min-width: 100vw;
+++        width: 100% !important;
+++      }
+++    }
+++  </style>
+++  <!-- CSS Reset : END -->
+++
+++  <!-- Progressive Enhancements : BEGIN -->
+++  <style>
+++    /* What it does: Hover styles for buttons */
+++    .button-td,
+++    .button-a {
+++      transition: all 100ms ease-in;
+++    }
+++
+++    .button-td:hover,
+++    .button-a:hover {
+++      background: #CC9900 !important;
+++      border-color: #CC9900 !important;
+++    }
+++
+++    /* Define o estilo dos links */
+++    a:link {
+++      color: #CC9900;
+++      background-color: transparent;
+++      text-decoration: none;
+++    }
+++
+++    a:visited {
+++      color: #CC9900;
+++      background-color: transparent;
+++      text-decoration: none;
+++    }
+++
+++    a:hover {
+++      color: #CC9900;
+++      background-color: transparent;
+++      text-decoration: underline;
+++    }
+++
+++    a:active {
+++      color: #CC9900;
+++      background-color: transparent;
+++      text-decoration: underline;
+++    }
+++
+++    /* Media Queries */
+++    @media screen and (max-width: 600px) {
+++
+++      .email-container {
+++        width: 100% !important;
+++        margin: auto !important;
+++      }
+++
+++      /* What it does: Forces elements to resize to the full width of their container. Useful for resizing images beyond their max-width. */
+++      .fluid {
+++        max-width: 100% !important;
+++        height: auto !important;
+++        margin-left: auto !important;
+++        margin-right: auto !important;
+++      }
+++
+++      /* What it does: Forces table cells into full-width rows. */
+++      .stack-column,
+++      .stack-column-center {
+++        display: block !important;
+++        width: 100% !important;
+++        max-width: 100% !important;
+++        direction: ltr !important;
+++      }
+++
+++      /* And center justify these ones. */
+++      .stack-column-center {
+++        text-align: center !important;
+++      }
+++
+++      /* What it does: Generic utility class for centering. Useful for images, buttons, and nested tables. */
+++      .center-on-narrow {
+++        text-align: center !important;
+++        display: block !important;
+++        margin-left: auto !important;
+++        margin-right: auto !important;
+++        float: none !important;
+++      }
+++
+++      table.center-on-narrow {
+++        display: inline-block !important;
+++      }
+++
+++      /* What it does: Adjust typography on small screens to improve readability */
+++      .email-container p {
+++        font-size: 17px !important;
+++      }
+++    }
+++  </style>
+++  <!-- Progressive Enhancements : END -->
+++
+++  <!-- What it does: Makes background images in 72ppi Outlook render at correct size. -->
+++  <!--[if gte mso 9]>
+++    <xml>
+++        <o:OfficeDocumentSettings>
+++            <o:AllowPNG/>
+++            <o:PixelsPerInch>96</o:PixelsPerInch>
+++        </o:OfficeDocumentSettings>
+++    </xml>
+++    <![endif]-->
+++
+++</head>
+++
+++<body width="100%" bgcolor="#222222" style="margin: 0; mso-line-height-rule: exactly;">
+++  <center style="width: 100%; background: #fafafa; text-align: left;">
+++
+++    <!-- Email Header : BEGIN -->
+++    <table role="presentation" cellspacing="0" cellpadding="0" border="0" align="center" width="600" style="margin: auto;" class="email-container" bgcolor="#1E1E1E">
+++      <tr>
+++        <td style="padding: 20px 0; text-align: center">
+++          <a href="https://goldtuganime.com" target="_blank"><img src="https://upload.goldtuganime.com/redes-sociais/GTA_Logo_Newsletter.png" width="282" border="0" style="height: auto; font-family: sans-serif; font-size: 15px; line-height: 140%; color: #555555;"></a>
+++        </td>
+++      </tr>
+++    </table>
+++    <!-- Email Header : END -->
+++
+++    {MESSAGE}
+++
+++    <!-- Email Footer : BEGIN -->
+++    <table role="presentation" bgcolor="#1E1E1E" cellspacing="0" cellpadding="0" border="0" align="center" width="100%" style="max-width: 600px; font-family: sans-serif; color: #888888; font-size: 11px; line-height: 140%;">
+++      <tr>
+++        <td style="padding: 10px 10px; width: 100%; font-family: sans-serif; font-size: 12px; line-height: 140%; text-align: center; color: #888888;" class="x-gmail-data-detectors">
+++          <table width="300" border="0" cellspacing="10" cellpadding="10">
+++            <tbody>
+++              <tr>
+++                <td><a href="https://www.facebook.com/goldtuganimeoficial/" target="_blank"><img src="https://upload.goldtuganime.com/redes-sociais/facebook-Y.png" height="24" width="24" class=""></a></td>
+++                <td><a href="https://www.instagram.com/goldtuganime/" target="_blank"><img src="https://upload.goldtuganime.com/redes-sociais/instagram-Y.png" height="24" width="24" class=""></a></td>
+++                <td><a href="https://discord.gg/Zk8CCZUG/" target="_blank"><img src="https://upload.goldtuganime.com/redes-sociais/discord-Y.png" height="24" width="24" class=""></a></td>
+++                <td><a href="https://www.youtube.com/@GoldTugAnimeOFICIAL" target="_blank"><img src="https://upload.goldtuganime.com/redes-sociais/youtube-Y.png" height="24" width="24" class=""></a></td>
+++                <td><a href="https://goldtuganime.com" target="_blank"><img src="https://upload.goldtuganime.com/redes-sociais/website-Y.png" height="24" width="24" class=""></a></td>
+++              </tr>
+++            </tbody>
+++          </table>
+++
+++        </td>
+++      </tr>
+++    </table>
+++    <table role="presentation" cellspacing="0" cellpadding="0" border="0" align="center" width="100%" style="max-width: 600px; font-family: sans-serif; color: #888888; font-size: 11px; line-height: 140%;">
+++      <tr>
+++        <td style="padding: 10px 10px; width: 100%; font-family: sans-serif; font-size: 12px; line-height: 140%; text-align: center; color: #888888;" class="x-gmail-data-detectors"><em>Copyright © 2023 | <a href="https://goldtuganime.com" target="_blank">GoldTugAnime</a> | Todos os direitos reservados.</em></td>
+++      </tr>
+++      <tr>
+++        <td>
+++          <table width="400" border="0" cellspacing="0" cellpadding="0">
+++            <tbody>
+++              <tr>
+++                <td width="400" height="2" bgcolor="#CC9900" align="center" valign="bottom" style="padding: 0px;"></td>
+++              </tr>
+++            </tbody>
+++          </table>
+++        </td>
+++      </tr>
+++      <tr>
+++        <td style="padding: 10px 10px; width: 100%; font-family: sans-serif; font-size: 8px; line-height: 140%; text-align: center; color: #888888;" class="x-gmail-data-detectors">Estás a receber este e-mail porque estás inscrito no nosso fórum. <a href="{NEWSLETTER_ONLINE}" target="_blank">Vê aqui</a> que newsletters já recebeste ou remove o teu endereço eletrónico da nossa lista através do link <a href="{NEWSLETTER_OPTOUT}" target="_blank">remover subscrição</a>, caso pretendas.
+++        </td>
+++      </tr>
+++    </table>
+++    <!-- Email Footer : END -->
+++  </center>
+++</body>
+++
+++</html>
++\ No newline at end of file
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/language/pt/email/newsletter_txt.txt" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/language/pt/email/newsletter_txt.txt"
++new file mode 100644
++index 000000000..0b839ca10
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/language/pt/email/newsletter_txt.txt"
++@@ -0,0 +1,6 @@
+++Subject: Newsletter de {SITENAME}
+++
+++{MESSAGE}
+++
+++Todas as newsletter: {NEWSLETTER_ONLINE}
+++Não desejas continuar a receber a nossa newsletter? Clica aqui: {NEWSLETTER_OPTOUT}
++\ No newline at end of file
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/language/pt/email/newsoverview_html.txt" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/language/pt/email/newsoverview_html.txt"
++new file mode 100644
++index 000000000..bf3ad62ea
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/language/pt/email/newsoverview_html.txt"
++@@ -0,0 +1,961 @@
+++Subject: Últimas Novidades "{SITENAME}"
+++
+++<html xmlns="http://www.w3.org/1999/xhtml" style="margin: 0;padding: 0;">
+++<!--<![endif]-->
+++
+++<head>
+++	<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
+++	<!--[if !mso]><!-->
+++	<meta content="IE=edge" http-equiv="X-UA-Compatible">
+++	<!--<![endif]-->
+++	<meta content="width=device-width" name="viewport">
+++	<style type="text/css">
+++		@media only screen and (min-width: 620px) {
+++			* [lang=x-wrapper] h1 {
+++				font-size: 26px !important;
+++				line-height: 34px !important;
+++			}
+++			* [lang=x-wrapper] h2 {
+++				font-size: 20px !important;
+++				line-height: 28px !important;
+++			}
+++			* div [lang=x-size-8] {
+++				font-size: 8px !important;
+++				line-height: 14px !important;
+++			}
+++			* div [lang=x-size-9] {
+++				font-size: 9px !important;
+++				line-height: 16px !important;
+++			}
+++			* div [lang=x-size-10] {
+++				font-size: 10px !important;
+++				line-height: 18px !important;
+++			}
+++			* div [lang=x-size-11] {
+++				font-size: 11px !important;
+++				line-height: 19px !important;
+++			}
+++			* div [lang=x-size-12] {
+++				font-size: 12px !important;
+++				line-height: 19px !important;
+++			}
+++			* div [lang=x-size-13] {
+++				font-size: 13px !important;
+++				line-height: 21px !important;
+++			}
+++			* div [lang=x-size-14] {
+++				font-size: 14px !important;
+++				line-height: 21px !important;
+++			}
+++			* div [lang=x-size-15] {
+++				font-size: 15px !important;
+++				line-height: 23px !important;
+++			}
+++			* div [lang=x-size-16] {
+++				font-size: 16px !important;
+++				line-height: 24px !important;
+++			}
+++			* div [lang=x-size-17] {
+++				font-size: 17px !important;
+++				line-height: 26px !important;
+++			}
+++			* div [lang=x-size-18] {
+++				font-size: 18px !important;
+++				line-height: 26px !important;
+++			}
+++			* div [lang=x-size-18] {
+++				font-size: 18px !important;
+++				line-height: 26px !important;
+++			}
+++			* div [lang=x-size-20] {
+++				font-size: 20px !important;
+++				line-height: 28px !important;
+++			}
+++			* div [lang=x-size-22] {
+++				font-size: 22px !important;
+++				line-height: 31px !important;
+++			}
+++			* div [lang=x-size-24] {
+++				font-size: 24px !important;
+++				line-height: 32px !important;
+++			}
+++			* div [lang=x-size-26] {
+++				font-size: 26px !important;
+++				line-height: 34px !important;
+++			}
+++			* div [lang=x-size-28] {
+++				font-size: 28px !important;
+++				line-height: 36px !important;
+++			}
+++			* div [lang=x-size-30] {
+++				font-size: 30px !important;
+++				line-height: 38px !important;
+++			}
+++			* div [lang=x-size-32] {
+++				font-size: 32px !important;
+++				line-height: 40px !important;
+++			}
+++			* div [lang=x-size-34] {
+++				font-size: 34px !important;
+++				line-height: 43px !important;
+++			}
+++			* div [lang=x-size-36] {
+++				font-size: 36px !important;
+++				line-height: 43px !important;
+++			}
+++			* div [lang=x-size-40] {
+++				font-size: 40px !important;
+++				line-height: 47px !important;
+++			}
+++			* div [lang=x-size-44] {
+++				font-size: 44px !important;
+++				line-height: 50px !important;
+++			}
+++			* div [lang=x-size-48] {
+++				font-size: 48px !important;
+++				line-height: 54px !important;
+++			}
+++			* div [lang=x-size-56] {
+++				font-size: 56px !important;
+++				line-height: 60px !important;
+++			}
+++			* div [lang=x-size-64] {
+++				font-size: 64px !important;
+++				line-height: 63px !important;
+++			}
+++		}
+++	</style>
+++	<style type="text/css">
+++		body {
+++			margin: 0;
+++			padding: 0;
+++		}
+++		
+++		table {
+++			border-collapse: collapse;
+++			table-layout: fixed;
+++		}
+++		
+++		* {
+++			line-height: inherit;
+++		}
+++		
+++		[x-apple-data-detectors],
+++		[href^="tel"],
+++		[href^="sms"] {
+++			color: inherit !important;
+++			text-decoration: none !important;
+++		}
+++		
+++		.wrapper .footer__share-button a:hover,
+++		.wrapper .footer__share-button a:focus {
+++			color: #ffffff !important;
+++		}
+++		
+++		.btn a:hover,
+++		.btn a:focus,
+++		.footer__share-button a:hover,
+++		.footer__share-button a:focus,
+++		.email-footer__links a:hover,
+++		.email-footer__links a:focus {
+++			opacity: 0.8;
+++		}
+++		
+++		.ie .btn {
+++			width: 100%;
+++		}
+++		
+++		.ie .column,
+++		[owa] .column,
+++		.ie .gutter,
+++		[owa] .gutter {
+++			display: table-cell;
+++			float: none !important;
+++			vertical-align: top;
+++		}
+++		
+++		.ie .preheader,
+++		[owa] .preheader,
+++		.ie .email-footer,
+++		[owa] .email-footer {
+++			width: 560px !important;
+++		}
+++		
+++		.ie .snippet,
+++		[owa] .snippet,
+++		.ie .webversion,
+++		[owa] .webversion {
+++			width: 280px !important;
+++		}
+++		
+++		.ie .header,
+++		[owa] .header,
+++		.ie .layout,
+++		[owa] .layout,
+++		.ie .one-col .column,
+++		[owa] .one-col .column {
+++			width: 600px !important;
+++		}
+++		
+++		.ie .fixed-width.has-border,
+++		[owa] .fixed-width.has-border,
+++		.ie .has-gutter.has-border,
+++		[owa] .has-gutter.has-border {
+++			width: 602px !important;
+++		}
+++		
+++		.ie .two-col .column,
+++		[owa] .two-col .column {
+++			width: 300px !important;
+++		}
+++		
+++		.ie .three-col .column,
+++		[owa] .three-col .column,
+++		.ie .narrow,
+++		[owa] .narrow {
+++			width: 200px !important;
+++		}
+++		
+++		.ie .wide,
+++		[owa] .wide {
+++			width: 400px !important;
+++		}
+++		
+++		.ie .two-col.has-gutter .column,
+++		[owa] .two-col.x_has-gutter .column {
+++			width: 290px !important;
+++		}
+++		
+++		.ie .three-col.has-gutter .column,
+++		[owa] .three-col.x_has-gutter .column,
+++		.ie .has-gutter .narrow,
+++		[owa] .has-gutter .narrow {
+++			width: 188px !important;
+++		}
+++		
+++		.ie .has-gutter .wide,
+++		[owa] .has-gutter .wide {
+++			width: 394px !important;
+++		}
+++		
+++		.ie .two-col.has-gutter.has-border .column,
+++		[owa] .two-col.x_has-gutter.x_has-border .column {
+++			width: 292px !important;
+++		}
+++		
+++		.ie .three-col.has-gutter.has-border .column,
+++		[owa] .three-col.x_has-gutter.x_has-border .column,
+++		.ie .has-gutter.has-border .narrow,
+++		[owa] .has-gutter.x_has-border .narrow {
+++			width: 190px !important;
+++		}
+++		
+++		.ie .has-gutter.has-border .wide,
+++		[owa] .has-gutter.x_has-border .wide {
+++			width: 396px !important;
+++		}
+++		
+++		.ie .fixed-width .layout__inner {
+++			border-left: 0 none white !important;
+++			border-right: 0 none white !important;
+++		}
+++		
+++		.ie .layout__edges {
+++			display: none;
+++		}
+++		
+++		.mso .layout__edges {
+++			font-size: 0;
+++		}
+++		
+++		.layout-fixed-width,
+++		.mso .layout-full-width {
+++			background-color: #ffffff;
+++		}
+++		
+++		@media only screen and (min-width: 620px) {
+++			.column,
+++			.gutter {
+++				display: table-cell;
+++				Float: none !important;
+++				vertical-align: top;
+++			}
+++			.preheader,
+++			.email-footer {
+++				width: 560px !important;
+++			}
+++			.snippet,
+++			.webversion {
+++				width: 280px !important;
+++			}
+++			.header,
+++			.layout,
+++			.one-col .column {
+++				width: 600px !important;
+++			}
+++			.fixed-width.has-border,
+++			.fixed-width.ecxhas-border,
+++			.has-gutter.has-border,
+++			.has-gutter.ecxhas-border {
+++				width: 602px !important;
+++			}
+++			.two-col .column {
+++				width: 300px !important;
+++			}
+++			.three-col .column,
+++			.column.narrow {
+++				width: 200px !important;
+++			}
+++			.column.wide {
+++				width: 400px !important;
+++			}
+++			.two-col.has-gutter .column,
+++			.two-col.ecxhas-gutter .column {
+++				width: 290px !important;
+++			}
+++			.three-col.has-gutter .column,
+++			.three-col.ecxhas-gutter .column,
+++			.has-gutter .narrow {
+++				width: 188px !important;
+++			}
+++			.has-gutter .wide {
+++				width: 394px !important;
+++			}
+++			.two-col.has-gutter.has-border .column,
+++			.two-col.ecxhas-gutter.ecxhas-border .column {
+++				width: 292px !important;
+++			}
+++			.three-col.has-gutter.has-border .column,
+++			.three-col.ecxhas-gutter.ecxhas-border .column,
+++			.has-gutter.has-border .narrow,
+++			.has-gutter.ecxhas-border .narrow {
+++				width: 190px !important;
+++			}
+++			.has-gutter.has-border .wide,
+++			.has-gutter.ecxhas-border .wide {
+++				width: 396px !important;
+++			}
+++		}
+++		
+++		@media only screen and (-webkit-min-device-pixel-ratio: 2),
+++		only screen and (min--moz-device-pixel-ratio: 2),
+++		only screen and (-o-min-device-pixel-ratio: 2/1),
+++		only screen and (min-device-pixel-ratio: 2),
+++		only screen and (min-resolution: 192dpi),
+++		only screen and (min-resolution: 2dppx) {
+++			.fblike {
+++				background-image: url(https://i3.createsend1.com/static/eb/master/13-the-blueprint-3/images/fblike@2x.png) !important;
+++			}
+++			.tweet {
+++				background-image: url(https://i4.createsend1.com/static/eb/master/13-the-blueprint-3/images/tweet@2x.png) !important;
+++			}
+++			.linkedinshare {
+++				background-image: url(https://i6.createsend1.com/static/eb/master/13-the-blueprint-3/images/lishare@2x.png) !important;
+++			}
+++			.forwardtoafriend {
+++				background-image: url(https://i7.createsend1.com/static/eb/master/13-the-blueprint-3/images/forward@2x.png) !important;
+++			}
+++		}
+++		
+++		@media (max-width: 321px) {
+++			.fixed-width.has-border .layout__inner {
+++				border-width: 1px 0 !important;
+++			}
+++			.layout,
+++			.column {
+++				min-width: 320px !important;
+++				width: 320px !important;
+++			}
+++			.border {
+++				display: none;
+++			}
+++		}
+++		
+++		.mso div {
+++			border: 0 none white !important;
+++		}
+++		
+++		.mso .w560 .divider {
+++			Margin-left: 260px !important;
+++			Margin-right: 260px !important;
+++		}
+++		
+++		.mso .w360 .divider {
+++			Margin-left: 160px !important;
+++			Margin-right: 160px !important;
+++		}
+++		
+++		.mso .w260 .divider {
+++			Margin-left: 110px !important;
+++			Margin-right: 110px !important;
+++		}
+++		
+++		.mso .w160 .divider {
+++			Margin-left: 60px !important;
+++			Margin-right: 60px !important;
+++		}
+++		
+++		.mso .w354 .divider {
+++			Margin-left: 157px !important;
+++			Margin-right: 157px !important;
+++		}
+++		
+++		.mso .w250 .divider {
+++			Margin-left: 105px !important;
+++			Margin-right: 105px !important;
+++		}
+++		
+++		.mso .w148 .divider {
+++			Margin-left: 54px !important;
+++			Margin-right: 54px !important;
+++		}
+++		
+++		.mso .font-avenir,
+++		.mso .font-cabin,
+++		.mso .font-open-sans,
+++		.mso .font-ubuntu {
+++			font-family: sans-serif !important;
+++		}
+++		
+++		.mso .font-bitter,
+++		.mso .font-merriweather,
+++		.mso .font-pt-serif {
+++			font-family: Georgia, serif !important;
+++		}
+++		
+++		.mso .font-lato,
+++		.mso .font-roboto {
+++			font-family: Tahoma, sans-serif !important;
+++		}
+++		
+++		.mso .font-pt-sans {
+++			font-family: "Trebuchet MS", sans-serif !important;
+++		}
+++		
+++		.mso .footer__share-button p {
+++			margin: 0;
+++		}
+++		
+++		@media only screen and (min-width: 620px) {
+++			.wrapper .size-8 {
+++				font-size: 8px !important;
+++				line-height: 14px !important;
+++			}
+++			.wrapper .size-9 {
+++				font-size: 9px !important;
+++				line-height: 16px !important;
+++			}
+++			.wrapper .size-10 {
+++				font-size: 10px !important;
+++				line-height: 18px !important;
+++			}
+++			.wrapper .size-11 {
+++				font-size: 11px !important;
+++				line-height: 19px !important;
+++			}
+++			.wrapper .size-12 {
+++				font-size: 12px !important;
+++				line-height: 19px !important;
+++			}
+++			.wrapper .size-13 {
+++				font-size: 13px !important;
+++				line-height: 21px !important;
+++			}
+++			.wrapper .size-14 {
+++				font-size: 14px !important;
+++				line-height: 21px !important;
+++			}
+++			.wrapper .size-15 {
+++				font-size: 15px !important;
+++				line-height: 23px !important;
+++			}
+++			.wrapper .size-16 {
+++				font-size: 16px !important;
+++				line-height: 24px !important;
+++			}
+++			.wrapper .size-17 {
+++				font-size: 17px !important;
+++				line-height: 26px !important;
+++			}
+++			.wrapper .size-18 {
+++				font-size: 18px !important;
+++				line-height: 26px !important;
+++			}
+++			.wrapper .size-20 {
+++				font-size: 20px !important;
+++				line-height: 28px !important;
+++			}
+++			.wrapper .size-22 {
+++				font-size: 22px !important;
+++				line-height: 31px !important;
+++			}
+++			.wrapper .size-24 {
+++				font-size: 24px !important;
+++				line-height: 32px !important;
+++			}
+++			.wrapper .size-26 {
+++				font-size: 26px !important;
+++				line-height: 34px !important;
+++			}
+++			.wrapper .size-28 {
+++				font-size: 28px !important;
+++				line-height: 36px !important;
+++			}
+++			.wrapper .size-30 {
+++				font-size: 30px !important;
+++				line-height: 38px !important;
+++			}
+++			.wrapper .size-32 {
+++				font-size: 32px !important;
+++				line-height: 40px !important;
+++			}
+++			.wrapper .size-34 {
+++				font-size: 34px !important;
+++				line-height: 43px !important;
+++			}
+++			.wrapper .size-36 {
+++				font-size: 36px !important;
+++				line-height: 43px !important;
+++			}
+++			.wrapper .size-40 {
+++				font-size: 40px !important;
+++				line-height: 47px !important;
+++			}
+++			.wrapper .size-44 {
+++				font-size: 44px !important;
+++				line-height: 50px !important;
+++			}
+++			.wrapper .size-48 {
+++				font-size: 48px !important;
+++				line-height: 54px !important;
+++			}
+++			.wrapper .size-56 {
+++				font-size: 56px !important;
+++				line-height: 60px !important;
+++			}
+++			.wrapper .size-64 {
+++				font-size: 64px !important;
+++				line-height: 63px !important;
+++			}
+++		}
+++		
+++		.mso .size-8,
+++		.ie .size-8 {
+++			font-size: 8px !important;
+++			line-height: 14px !important;
+++		}
+++		
+++		.mso .size-9,
+++		.ie .size-9 {
+++			font-size: 9px !important;
+++			line-height: 16px !important;
+++		}
+++		
+++		.mso .size-10,
+++		.ie .size-10 {
+++			font-size: 10px !important;
+++			line-height: 18px !important;
+++		}
+++		
+++		.mso .size-11,
+++		.ie .size-11 {
+++			font-size: 11px !important;
+++			line-height: 19px !important;
+++		}
+++		
+++		.mso .size-12,
+++		.ie .size-12 {
+++			font-size: 12px !important;
+++			line-height: 19px !important;
+++		}
+++		
+++		.mso .size-13,
+++		.ie .size-13 {
+++			font-size: 13px !important;
+++			line-height: 21px !important;
+++		}
+++		
+++		.mso .size-14,
+++		.ie .size-14 {
+++			font-size: 14px !important;
+++			line-height: 21px !important;
+++		}
+++		
+++		.mso .size-15,
+++		.ie .size-15 {
+++			font-size: 15px !important;
+++			line-height: 23px !important;
+++		}
+++		
+++		.mso .size-16,
+++		.ie .size-16 {
+++			font-size: 16px !important;
+++			line-height: 24px !important;
+++		}
+++		
+++		.mso .size-17,
+++		.ie .size-17 {
+++			font-size: 17px !important;
+++			line-height: 26px !important;
+++		}
+++		
+++		.mso .size-18,
+++		.ie .size-18 {
+++			font-size: 18px !important;
+++			line-height: 26px !important;
+++		}
+++		
+++		.mso .size-20,
+++		.ie .size-20 {
+++			font-size: 20px !important;
+++			line-height: 28px !important;
+++		}
+++		
+++		.mso .size-22,
+++		.ie .size-22 {
+++			font-size: 22px !important;
+++			line-height: 31px !important;
+++		}
+++		
+++		.mso .size-24,
+++		.ie .size-24 {
+++			font-size: 24px !important;
+++			line-height: 32px !important;
+++		}
+++		
+++		.mso .size-26,
+++		.ie .size-26 {
+++			font-size: 26px !important;
+++			line-height: 34px !important;
+++		}
+++		
+++		.mso .size-28,
+++		.ie .size-28 {
+++			font-size: 28px !important;
+++			line-height: 36px !important;
+++		}
+++		
+++		.mso .size-30,
+++		.ie .size-30 {
+++			font-size: 30px !important;
+++			line-height: 38px !important;
+++		}
+++		
+++		.mso .size-32,
+++		.ie .size-32 {
+++			font-size: 32px !important;
+++			line-height: 40px !important;
+++		}
+++		
+++		.mso .size-34,
+++		.ie .size-34 {
+++			font-size: 34px !important;
+++			line-height: 43px !important;
+++		}
+++		
+++		.mso .size-36,
+++		.ie .size-36 {
+++			font-size: 36px !important;
+++			line-height: 43px !important;
+++		}
+++		
+++		.mso .size-40,
+++		.ie .size-40 {
+++			font-size: 40px !important;
+++			line-height: 47px !important;
+++		}
+++		
+++		.mso .size-44,
+++		.ie .size-44 {
+++			font-size: 44px !important;
+++			line-height: 50px !important;
+++		}
+++		
+++		.mso .size-48,
+++		.ie .size-48 {
+++			font-size: 48px !important;
+++			line-height: 54px !important;
+++		}
+++		
+++		.mso .size-56,
+++		.ie .size-56 {
+++			font-size: 56px !important;
+++			line-height: 60px !important;
+++		}
+++		
+++		.mso .size-64,
+++		.ie .size-64 {
+++			font-size: 64px !important;
+++			line-height: 63px !important;
+++		}
+++		
+++		.footer__share-button p {
+++			margin: 0;
+++		}
+++	</style>
+++
+++	<title>{SITENAME}</title>
+++	<!--[if !mso]><!-->
+++	<style type="text/css">
+++		@import url(https://fonts.googleapis.com/css?family=Bitter:400,700,400italic|Open+Sans:400italic,700italic,700,400);
+++	</style>
+++	<link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Bitter:400,700,400italic|Open+Sans:400italic,700italic,700,400">
+++	<!--<![endif]-->
+++	<style type="text/css">
+++		body {
+++			background-color: #f2f6f7
+++		}
+++		
+++		.mso h1 {}
+++		
+++		.mso h1 {
+++			font-family: Georgia, serif !important
+++		}
+++		
+++		.mso h2 {}
+++		
+++		.mso h2 {
+++			font-family: Georgia, serif !important
+++		}
+++		
+++		.mso h3 {}
+++		
+++		.mso h3 {
+++			font-family: Georgia, serif !important
+++		}
+++		
+++		.mso .column,
+++		.mso .column__background td {}
+++		
+++		.mso .column,
+++		.mso .column__background td {
+++			font-family: sans-serif !important
+++		}
+++		
+++		.mso .btn a {}
+++		
+++		.mso .btn a {
+++			font-family: sans-serif !important
+++		}
+++		
+++		.mso .webversion,
+++		.mso .snippet,
+++		.mso .layout-email-footer td,
+++		.mso .footer__share-button p {}
+++		
+++		.mso .webversion,
+++		.mso .snippet,
+++		.mso .layout-email-footer td,
+++		.mso .footer__share-button p {
+++			font-family: sans-serif !important
+++		}
+++		
+++		.mso .logo {}
+++		
+++		.mso .logo {
+++			font-family: Tahoma, sans-serif !important
+++		}
+++		
+++		.logo a:hover,
+++		.logo a:focus {
+++			color: #859bb1 !important
+++		}
+++		
+++		.mso .layout-has-border {
+++			border-top: 1px solid #b3cad0;
+++			border-bottom: 1px solid #b3cad0
+++		}
+++		
+++		.mso .layout-has-bottom-border {
+++			border-bottom: 1px solid #b3cad0
+++		}
+++		
+++		.mso .border,
+++		.ie .border {
+++			background-color: #b3cad0
+++		}
+++		
+++		@media only screen and (min-width: 620px) {
+++			.wrapper h1 {}
+++			.wrapper h1 {
+++				font-size: 26px !important;
+++				line-height: 34px !important
+++			}
+++			.wrapper h2 {}
+++			.wrapper h2 {
+++				font-size: 20px !important;
+++				line-height: 28px !important
+++			}
+++			.wrapper h3 {}
+++			.column,
+++			.column__background td {}
+++		}
+++		
+++		.mso h1,
+++		.ie h1 {}
+++		
+++		.mso h1,
+++		.ie h1 {
+++			font-size: 26px !important;
+++			line-height: 34px !important
+++		}
+++		
+++		.mso h2,
+++		.ie h2 {}
+++		
+++		.mso h2,
+++		.ie h2 {
+++			font-size: 20px !important;
+++			line-height: 28px !important
+++		}
+++		
+++		.mso h3,
+++		.ie h3 {}
+++		
+++		.mso .column,
+++		.ie .column,
+++		.mso .column__background td,
+++		.ie .column__background td {}
+++	</style>
+++</head>
+++<!--[if mso]>
+++	<body class="mso">
+++<![endif]-->
+++<!--[if !mso]><!-->
+++
+++<body style="margin: 0;padding: 0;-webkit-text-size-adjust: 100%;" class="full-padding">
+++	<!--<![endif]-->
+++	<div lang="x-wrapper" style="min-width: 320px;background-color: #f2f6f7;" class="wrapper">
+++		<div style="Margin: 0 auto;max-width: 560px;min-width: 280px; width: 280px;width: calc(28000% - 173040px);" class="preheader">
+++			<div style="border-collapse: collapse;display: table;width: 100%;">
+++				<!--[if (mso)|(IE)]><table align="center" class="preheader" cellpadding="0" cellspacing="0"><tr><td style="width: 280px" valign="top"><![endif]-->
+++				<div style="Float: left;font-size: 12px;line-height: 19px;max-width: 280px;min-width: 140px; width: 140px;width: calc(14000% - 78120px);padding: 10px 0 5px 0;color: #99b0b8;font-family: &quot;Open Sans&quot;,sans-serif;" class="snippet">
+++
+++				</div>
+++				<!--[if (mso)|(IE)]></td><td style="width: 280px" valign="top"><![endif]-->
+++				<div style="Float: left;font-size: 12px;line-height: 19px;max-width: 280px;min-width: 139px; width: 139px;width: calc(14100% - 78680px);padding: 10px 0 5px 0;text-align: right;color: #99b0b8;font-family: &quot;Open Sans&quot;,sans-serif;" class="webversion">
+++
+++				</div>
+++				<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
+++			</div>
+++		</div>
+++		<div id="emb-email-header-container" style="Margin: 0 auto;max-width: 600px;min-width: 320px; width: 320px;width: calc(28000% - 173000px);" class="header">
+++			<!--[if (mso)|(IE)]><table align="center" class="header" cellpadding="0" cellspacing="0"><tr><td style="width: 600px"><![endif]-->
+++			<div align="center" style="font-size: 26px;line-height: 32px;Margin-top: 6px;Margin-bottom: 20px;color: #c3ced9;font-family: Roboto,Tahoma,sans-serif;Margin-left: 20px;Margin-right: 20px;" class="logo emb-logo-margin-box">
+++				<div align="center" id="emb-email-header" style="font-size:0px !important;line-height:0 !important;" class="logo-center">
+++					<img width="141" alt="" src="{SITE_LOGO_IMG}" style="height: auto;width: 100%;border: 0;max-width: 141px;">
+++				</div>
+++			</div>
+++			<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
+++		</div>
+++		<div style="Margin: 0 auto;max-width: 600px;min-width: 320px; width: 320px;width: calc(28000% - 173000px);overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;" class="layout one-col fixed-width">
+++			<div emb-background-style="" style="border-collapse: collapse;display: table;width: 100%;background-color: #ffffff;" class="layout__inner">
+++				<!--[if (mso)|(IE)]><table align="center" cellpadding="0" cellspacing="0"><tr class="layout-fixed-width" emb-background-style><td style="width: 600px" class="w560"><![endif]-->
+++				<div style="text-align: left;color: #808285;font-size: 14px;line-height: 21px;font-family: &quot;Open Sans&quot;,sans-serif;max-width: 600px;min-width: 320px; width: 320px;width: calc(28000% - 167400px);" class="column">
+++
+++					<div style="Margin-left: 20px;Margin-right: 20px;Margin-top: 24px;">
+++						<div style="line-height:10px;font-size:1px">&nbsp;</div>
+++					</div>
+++
+++					<div style="Margin-left: 20px;Margin-right: 20px;">
+++						<div style="line-height:5px;font-size:1px">&nbsp;</div>
+++					</div>
+++
+++					<div style="Margin-left: 20px;Margin-right: 20px;">
+++						<h1 style="Margin-top: 0;Margin-bottom: 20px;font-style: normal;font-weight: normal;color: #58595b;font-size: 22px;line-height: 31px;font-family: Bitter,Georgia,serif;text-align: center;">Last Topics While You Were Away</h1>
+++					</div>
+++
+++					<div style="Margin-left: 20px;Margin-right: 20px;">
+++						<div style="display: block;font-size: 2px;line-height: 2px;Margin-left: auto;Margin-right: auto;width: 40px;background-color: #b3cad0;Margin-bottom: 20px;" class="divider">&nbsp;</div>
+++					</div>
+++
+++					<div style="Margin-left: 20px;Margin-right: 20px;">
+++						<p style="Margin-top: 0;Margin-bottom: 20px;text-align: center;">Enquanto estiveste fora a laurear a pevide, houve nova atividade no fórum. Vê a nova tendência. Estamos animados para te ver novamente!</p>
+++					    <p style="Margin-top: 10px;Margin-bottom: 20px;text-align: center;">{EMAIL_SIG}</p>
+++					</div>
+++
+++					<div style="Margin-left: 20px;Margin-right: 20px;">
+++						<div style="line-height:10px;font-size:1px">&nbsp;</div>
+++					</div>
+++
+++					<div style="Margin-left: 20px;Margin-right: 20px;">
+++						<div style="Margin-bottom: 20px;text-align: center;" class="btn btn--flat btn--large">
+++							<!--[if !mso]--><a href="{BOARD_URL}" style="border-radius: 4px;display: inline-block;font-size: 14px;font-weight: bold;line-height: 24px;padding: 12px 24px;text-align: center;text-decoration: none !important;transition: opacity 0.1s ease-in;color: #60686b;background-color: #becdd1;font-family: 'Open Sans', sans-serif;"
+++							target="_blank">Comunidade GoldTugAnime</a>
+++							<!--[endif]-->
+++							<!--[if mso]><p style="line-height:0;margin:0;">&nbsp;</p><v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" href="{BOARD_URL}" style="width:167px" arcsize="9%" fillcolor="#BECDD1" stroke="f"><v:textbox style="mso-fit-shape-to-text:t" inset="0px,11px,0px,11px"><center style="font-size:14px;line-height:24px;color:#60686B;font-family:sans-serif;font-weight:bold;mso-line-height-rule:exactly;mso-text-raise:4px">Discussion Board</center></v:textbox></v:roundrect><![endif]-->
+++						</div>
+++					</div>
+++
+++					<div style="Margin-left: 20px;Margin-right: 20px;Margin-bottom: 24px;">
+++						<div style="line-height:15px;font-size:1px">&nbsp;</div>
+++					</div>
+++
+++				</div>
+++				<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
+++			</div>
+++		</div>
+++
+++		<div style="line-height:20px;font-size:20px;">&nbsp;</div>
+++
+++		<div style="Margin: 0 auto;max-width: 600px;min-width: 320px; width: 320px;width: calc(28000% - 173000px);overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;" class="layout one-col fixed-width">
+++			<div emb-background-style="" style="border-collapse: collapse;display: table;width: 100%;background-color: #ffffff;" class="layout__inner">
+++				<!--[if (mso)|(IE)]><table align="center" cellpadding="0" cellspacing="0"><tr class="layout-fixed-width" emb-background-style><td style="width: 600px" class="w560"><![endif]-->
+++				<div style="text-align: left;color: #808285;font-size: 14px;line-height: 21px;font-family: &quot;Open Sans&quot;,sans-serif;max-width: 600px;min-width: 320px; width: 320px;width: calc(28000% - 167400px);" class="column">
+++
+++					<div style="Margin-left: 20px;Margin-right: 20px;Margin-top: 24px;Margin-bottom: 24px;">
+++<!-- BEGIN mailrow -->
+++						<p style="Margin-top: 0;Margin-bottom: 0;"><a href="{mailrow.U_TOPIC}" style="text-decoration: underline;transition: opacity 0.1s ease-in;color: #60686b;" target="_blank">{mailrow.TOPIC} em: {mailrow.FORUMS}</a></p>
+++<!-- END mailrow -->
+++						<p style="Margin-top: 20px;Margin-bottom: 0;">&nbsp;</p>
+++					</div>
+++
+++				</div>
+++				<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
+++			</div>
+++		</div>
+++
+++		<div style="line-height:20px;font-size:20px;">&nbsp;</div>
+++
+++		<div style="Margin: 0 auto;max-width: 600px;min-width: 320px; width: 320px;width: calc(28000% - 173000px);overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;" class="layout email-footer">
+++			<div style="border-collapse: collapse;display: table;width: 100%;" class="layout__inner">
+++				<!--[if (mso)|(IE)]><table align="center" cellpadding="0" cellspacing="0"><tr class="layout-email-footer"><td style="width: 400px;" valign="top" class="w360"><![endif]-->
+++				<div style="text-align: left;font-size: 12px;line-height: 19px;color: #99b0b8;font-family: &quot;Open Sans&quot;,sans-serif;Float: left;max-width: 400px;min-width: 320px; width: 320px;width: calc(8000% - 47600px);" class="column wide">
+++					<div style="Margin-left: 20px;Margin-right: 20px;Margin-top: 10px;Margin-bottom: 10px;">
+++
+++						<div>
+++
+++						</div>
+++						<div style="Margin-top: 18px;">
+++
+++						</div>
+++					</div>
+++				</div>
+++				<!--[if (mso)|(IE)]></td><td style="width: 200px;" valign="top" class="w160"><![endif]-->
+++				<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
+++			</div>
+++		</div>
+++		<div style="Margin: 0 auto;max-width: 600px;min-width: 320px; width: 320px;width: calc(28000% - 173000px);overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;" class="layout one-col email-footer">
+++			<div style="border-collapse: collapse;display: table;width: 100%;" class="layout__inner">
+++				<!--[if (mso)|(IE)]><table align="center" cellpadding="0" cellspacing="0"><tr class="layout-email-footer"><td style="width: 600px;" class="w560"><![endif]-->
+++				<div style="text-align: center;font-size: 12px;line-height: 19px;color: #99b0b8;font-family: &quot;Open Sans&quot;,sans-serif;max-width: 600px;min-width: 320px; width: 320px;width: calc(28000% - 167400px);" class="column">
+++					<div style="Margin-left: 20px;Margin-right: 20px;Margin-top: 10px;Margin-bottom: 10px;">
+++						<div>
+++							<span>
+++              <a lang="en" href="{U_BOARD}" style="text-decoration: underline;transition: opacity 0.1s ease-in;color: #99b0b8;" target="_blank">Preferências</a>
+++              &nbsp;&nbsp;|&nbsp;&nbsp;
+++            </span>
+++              <a href="{NEWSLETTER_OPTOUT}" style="text-decoration: underline;transition: opacity 0.1s ease-in;color: #99b0b8;" target="_blank">Cancelar Subscrição</a>
+++						</div>
+++					</div>
+++				</div>
+++				<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
+++			</div>
+++		</div>
+++		<div style="line-height:40px;font-size:40px;">&nbsp;</div>
+++
+++	</div>
+++
+++</body>
+++
+++</html>
++\ No newline at end of file
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/language/pt/email/newsoverview_txt.txt" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/language/pt/email/newsoverview_txt.txt"
++new file mode 100644
++index 000000000..24fee63c8
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/language/pt/email/newsoverview_txt.txt"
++@@ -0,0 +1,17 @@
+++Subject: Latest topic at "{SITENAME}"
+++
+++{SITENAME}
+++
+++Latest Topics
+++Hi,
+++It's time for another newsletter.
+++We look forward to see you at {BOARD_URL} again.
+++
+++Forum				Topic
+++<!-- BEGIN mailrow -->
+++{mailrow.U_FORUM}				{mailrow.U_TOPIC}
+++<!-- END mailrow -->
+++
+++
+++{EMAIL_SIG}
+++Don't want to receive our newsletter anymore, click here {NEWSLETTER_OPTOUT}
++\ No newline at end of file
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/language/pt/info_acp_newsletter.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/language/pt/info_acp_newsletter.php"
++new file mode 100644
++index 000000000..cc9168a39
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/language/pt/info_acp_newsletter.php"
++@@ -0,0 +1,181 @@
+++<?php
+++/**
+++*
+++* @package BBnewsletter
+++* @copyright (c) 2016 SiteSplat All rights reserved
+++* @license Proprietary
+++*
+++*/
+++
+++if (!defined('IN_PHPBB'))
+++{
+++	exit;
+++}
+++
+++if (empty($lang) || !is_array($lang))
+++{
+++	$lang = array();
+++}
+++
+++$lang = array_merge($lang, array(
+++	'ACP_NEWSLETTER'			=> 'Newsletter',
+++	'ACP_NEWSLETTER_EXPLAIN'	=> 'Setup your Newsletter, several options are available below. Please make sure your mailserver accepts all mails, otherwise it will use phpbb\'s mail settings to send emails in small batches. <br />The weekly and monthly "Catch-up" forum news are sent out by the cron task. Install <a href="https://github.com/ForumHulp/cronstatus" target="_blank">Cronstatus extension</a> and select "Run cron always" in the options to run more often the "Catch-up" News (This is especially useful for small forums). <br />For HTML e-mails install <a href=" https://github.com/ForumHulp/htmlemail" target="_blank">HTML emails Extension</a> which enables the HTML settings.<br />',
+++    'FORUMS_NEWS_FROM'		    => 'Newsletter forum source',
+++	'FORUMS_FROM_EXPLAIN'		=> 'Select the forums you would like the users to receive the news from',
+++	'SEND_IMMEDIATELY'			=> 'Send immediately',
+++	'SEND_IMMEDIATELY_EXPLAIN'	=> 'Attempt to send the emails immediately. This depends on the server email configuration parameters',
+++	'PERIOD'					=> 'Email Overview (or Catch-up) Period',
+++	'PERIOD_EXPLAIN'			=> 'This will send automatic "Catch-up"  emails to the users that are subscribed. The e-mail will be generated based on the new topics in the forum. The user will receive an email with the purpose of engaging the user\'s interest in the recent board\'s activity. Edit the templates file named newsletter_html.txt for the HTML version and newsletter_txt.txt for the TXT version from:<br /> <code>root\ext\sitesplat\newsletter\language\en\email\</code> <br /> To learn how to send out professional looking HTML emails check out the tutorials over at <a href=" https://sitesplat.com/" target="_blank">sitesplat.com</a> or click the "Tutorials" label above.',
+++	'WEEKLY'					=> 'Weekly',
+++	'MONTHLY'					=> 'Monthly',
+++	'NO_OVERVIEW'				=> 'None',
+++	'PERIOD_SEND'				=> 'Set period for automatic newsletter',
+++	'SEND_TO_GROUP'				=> 'Send to group',
+++	'SEND_TO_USERS'				=> 'Send to user(s)',
+++	'SEND_TO_USERS_EXPLAIN'		=> 'When using this field it will override the "Send to Group" option above. Each user on a new line',
+++	'ALL_USERS'					=> 'All users',
+++	'NEW_USER'					=> 'Allow new users',
+++	'MAIL_LOW_PRIORITY'			=> 'Low',
+++	'MAIL_NORMAL_PRIORITY'		=> 'Normal',
+++	'MAIL_HIGH_PRIORITY'		=> 'High',
+++	'MAIL_PRIORITY'				=> 'Mail priority',
+++	'USE_HTML'					=> 'Use HTML emails',
+++	'COMPOSE_HTML'				=> 'Send manually',
+++	'COMPOSE_HTML_EXPLAIN'		=> 'If "Send manually" is selected the HTML editor will be available to send custom emails in HTML format',
+++	'MASS_MESSAGE'				=> 'Message (Newsletter Body)',
+++	'MASS_MESSAGE_EXPLAIN'		=> 'HTML message will be stripped if HTML email Extension is not enabled. To use the HTML editor click on "Tools" then "Source code" and enter the HTML code in the code editor ',
+++	'FHHTML_EMAIL_NOT_ENABLED'	=> 'HTML email extension not enabled. Download it from https://github.com/ForumHulp/htmlemail',
+++	'FHHTML_EMAIL_DOWNLOAD'	    => 'HTML email Extension not enabled. Download it from <a href="https://github.com/ForumHulp/htmlemail" target="blank">GithHub HTML Email Ext</a>',
+++	'LAST_SEND'					=> '<span id="viewsubscribers" class="label label-info" title="View subscribers">%1$s Members</span> subscribed, last letter was sent on <strong class="text-info">%2$s</strong>',
+++	'LAST_SEND_LETTERS'			=> 'Last newsletters',
+++	'LAST_SEND_EXPLAIN'			=> '**Please note, new registered users are automatically subscribed. (Click "X Members" above to view the users list)',
+++	'LAST_NEWSLETTERS_EXPLAIN'	=> '**Please note, the following template visualized on the single emails below does NOT reflect 100% the email that was sent out. This is due to phpBB\'s ACP stylesheet obsolete CSS reset rules. Refer to your email copy or front-end archive for the exact email accuracy.<br /> This is a list with the sole purpose of keeping track of the emails and users in a simple manner.<br />Always save a copy of the composed HTML email before sending it out if you wish to re-use it in the future.',
+++	'NEWS_PAGE'					=> 'Visible',
+++	'HIDE'						=> 'Hide',
+++	'SHOW'						=> 'Show',
+++	'DELETE_MAIL_SUCCES'		=> 'Newsletter deleted',
+++	'ACP_NEWSOVERVIEW_SEND'		=> 'Newsletter(s) sent successfully',
+++	'ACP_NEWSOVERVIEW_SAVED'	=> 'Settings saved successfully',
+++	
+++	'SITESPLAT_COM'		        => 'https://sitesplat.com',
+++	'SITESPLAT_COPY'		    => '&#169; SiteSplat',
+++	'LICENSE_INFO'		        => 'Proprietary - SiteSplat All rights reserved',
+++	'EXTENSION_DEVELOPER'	    => 'Developer',
+++	'ACP_NOTICE_CLOSE'			=> 'Close',
+++	'ACP_NEWS_VERSION'          => '1.0.5',
+++	'ACP_LOADING'		        => 'Loading... Hold on',
+++	'FORUM_CONTENT'		        => 'forum content',
+++	'EXT_NEWS_DESCRIPTION_PAGE'	=> 'A Newsletter system with an archive, weekly, monthly and many more options to run your own HTML style newsletter like a pro!',
+++	'EXT_NEWS_TASKS_1'			=> 'Newsletter Archive',
+++	'EXT_NEWS_TASKS_2'			=> 'Full HTML Enabled',
+++	'EXT_NEWS_TASKS_3'			=> 'Synchronization with Cron tasks and compatible with <a href="https://www.phpbb.com/customise/db/extension/cronstatus/">Cron Status</a>',
+++	'EXT_NEWS_TASKS_4'			=> 'Scheduled Newsletter',
+++	'EXT_NEWS_TASKS_5'			=> 'Checkout the other premium addons on <a href="https://sitesplat.com/phpBB3/marketplace.php">sitesplat.com/marketplace.php</a>',
+++	'EXT_NEWS_TASKS_6'			=> 'phpBB 3.2 ready',
+++
+++	'NEWS_SUBSCRIBERS_INFO'     => 'Subscribers and news info',
+++	'NEWS_TRICKS_TITLE'         => 'Tips and Tricks',
+++	'ACP_NEWS_TRICK_EXPLAIN'	=> '<p>Does your ISP limit the number of emails you can send each day?</p>
+++									<p><strong>Of course they do!</strong>
+++									</p>
+++									<p>Every outgoing SMTP mail server is guided by a provider’s email policy which includes hourly and/or daily email send limits. This policy will ultimately determine how many emails you can send each day. You can find a list of the hourly and daily send limits for most of the major ISPs, web hosting companies and Free email address providers below.</p>
+++									<p><strong><a title="Email sending limits for isp, web hosting and free email providers" href="http://group-mail.com/sending-email/email-sending-limits-for-isp-web-hosting-and-free-email-providers/">Email Sending Limits of ISP, Web Hosting and Free Email Providers</a></strong>
+++									</p>
+++									<p>If you try to send more email than the hourly or daily email sending limits of your mail server, you will notice errors being returned after the specified quota is met, saying something along the lines of:<em> </em>
+++									</p>
+++									<blockquote>
+++										<p><em>you have reached your daily sending quota</em>…</p>
+++									</blockquote>
+++									<p>If you surpass the daily <a title="SMTP email sending limits" href="http://group-mail.com/sending-email/email-sending-limits-for-isp-web-hosting-and-free-email-providers/">SMTP email sending limits</a> of your provider, you will generally have to wait 24 hours before you can send more email through that particular server.</p>
+++									<p>But, what are the hourly or daily email sending limits for <em>your</em> email server?</p>
+++									<ul>
+++										<li>The Gmail mail server send limit is approximately 100-150 emails per day when connected to the server from a remote email client. You can send 500 emails each day through the Gmail SMTP server when logged into their web interface.</li>
+++										<li>The Comcast mail server limits residential customers to send 1,000 messages per day. Comcast Business customers can send 24,000 emails per day through the Comcast outgoing SMTP mail server.</li>
+++										<li>The basic GoDaddy email server limits senders to send&nbsp; only 250 outgoing emails per day, but you can <a title="send more email by adding SMTP relays to your GoDaddy account" href="http://group-mail.com/sending-email/how-to-increase-your-godaddy-email-sending-limits/">send more email by adding SMTP relays to your GoDaddy account</a>
+++										</li>
+++									</ul>
+++									<p>&nbsp;</p>
+++									<p>So, what’s a guy to do if he needs to get his monthly email newsletter out to 5,000 eager subscribers but his ISP has a daily send limit of 500 emails per day?</p>
+++									<p><strong>What can you do if your mail server has limits that don’t support the size of your mailing list?</strong>
+++									</p>
+++									<p>If your current outgoing SMTP email server does not support your email list size or sending frequency, you have a variety of options:</p>
+++									<p style="padding-left: 30px;">1. Contact the host of your outgoing SMTP mail server(s) and ask if they have a business account that lets you send more emails each day to support your business.</p>
+++									<p style="padding-left: 30px;">2. Use GroupMail’s <a title="sending email without an external SMTP mail server" href="http://group-mail.com/sending-email/sending-email-without-an-external-smtp-mail-server/">Direct Send option</a>, which allows you to bypass your external SMTP server altogether and send email directly from your computer to your recipients using GroupMail’s own internal SMTP engine.</p>
+++									<p style="padding-left: 30px;">3. Use an outgoing SMTP service like <a title="SMTP2Go outgoing relay pricing" href="http://groupmail.smtp2go.com">SMTP2Go</a> to relay your large email campaigns.</p>
+++									<p style="padding-left: 30px;">4. Find a web hosting company who has daily email sending limits that meet your needs.</p>
+++									<p style="padding-left: 30px;">5. Setup your own <a href="http://www.msexchange.org/tutorials/MF002.html">MS Exchange Server</a> and configure it for SMTP email delivery.</p>
+++									<p>So, while GroupMail allows you to send and manage email lists of an <strong>unlimited</strong> size; the success of email delivery to large groups is ultimately dependent upon the sending limits set forth in the email sending policy of the SMTP mail server you are using.</p>
+++									<p><strong>Related articles you might find interesting:</strong>
+++									</p>
+++									<p><a title="email sending limits of ISPs web hosting and free email providers" href="http://group-mail.com/sending-email/email-sending-limits-for-isp-web-hosting-and-free-email-providers/">Email Sending Limits for ISPs, Web Hosting and Free Email Providers</a>
+++									</p>
+++									<p><a title="Common email error code descriptions and fixes" href="http://group-mail.com/email-error-codes/common-email-error-codes/">Common Email Error Code Descriptions and Fixes</a>
+++									</p>
+++									<p><a title="Free Email Newsletter and Marketing Software and Services" href="http://group-mail.com/email-marketing/free-email-newsletter-and-marketing-software-and-services/">Free Email Newsletter and Marketing Software and Services</a>
+++									</p>
+++									<p><a title="Email Settings for the Most Common Email Server hosts" href="http://group-mail.com/category/email-settings/">Email Settings for the Most Common Email Server Hosts</a>
+++									</p>
+++									<p><a title="step by step guide for email setup and delivery" href="http://group-mail.com/getting-started-with-groupmail/step-by-step-guide-for-email-setup-and-delivery/">Step-by-Step Guide for Email Setup and Delivery</a>
+++									</p>
+++									<p>&nbsp;</p>
+++									<hr>
+++									<p></p>',
+++	
+++	'EXT_NEWS_TUTORIALS_TITLE'  => 'Tutorials',
+++	'EXT_NEWS_TUTORIALS_EXPLAIN'=> '<li><p>Templates</p>
+++					<ul>
+++					<li><a href="http://htmlemailboilerplate.com/" target="_blank"><strong>HTML Email Boilerplate</strong></a>: A great <strong>starting point</strong> for coding emails.</li>
+++					<li><a href="http://www.campaignmonitor.com/templates/" target="_blank"><strong>Campaign Monitor Templates</strong></a>: Template builder + free downloadable templates</li>
+++					</ul>
+++					</li>
+++					
+++					<li><p>Tutorials &amp; Guides</p>
+++
+++					<ul>
+++					<li><a href="http://kb.mailchimp.com/article/how-to-code-html-emails" target="_blank"><strong>How To Code HTML Emails (Mailchimp)</strong></a>: How HTML email works, basic concepts, best practices, tips and tricks</li>
+++					<li><a href="http://www.smashingmagazine.com/2010/01/19/design-and-build-an-email-newsletter-without-losing-your-mind/" target="_blank"><strong>Design and Build Email Newsletters Without Losing Your Mind (and Soul)</strong></a>:  information you need to plan, design and build an HTML newsletter that renders well</li>
+++					<li><a href="http://mailchimp.com/resources/guides/email-marketing-field-guide/html/" target="_blank"><strong>Email Marketing Field Guide (Mailchimp)</strong></a></li>
+++					<li><a href="http://mattmedia.net/2007/08/23/8-html-email-tips-i-wish-i-knew-sooner/" target="_blank"><strong>8 HTML Email Tips I Wish I’d Known Sooner</strong></a></li>
+++					<li><a href="http://www.campaignmonitor.com/css/" target="_blank"><strong>The Ultimate Guide</a>: From Campaign Monitor</strong></li>
+++					<li><a href="http://css-tricks.com/using-css-in-html-emails-the-real-story/" target="_blank"><strong>CSS Tricks: Using CSS in HTML Emails</strong></a>: Some "I told you so"\'s and tips about HTML emails and CSS.</li>
+++					</ul>
+++					</li>
+++					
+++					<li><p>Testing</p>
+++
+++					<ul>
+++					<li><a href="http://www.emailonacid.com/" target="_blank"><strong>Email on Acid</strong></a>: Free and paid testing</li>
+++					<li><a href="http://litmus.com/" target="_blank"><strong>Litmus</strong></a></li>
+++					</ul>
+++					</li>
+++					
+++					<li><p>Other Resources</p>
+++
+++					<ul>
+++					<li><a href="http://www.campaignmonitor.com/resources/will-it-work/email-clients/" target="_blank"><strong>Campaign Monitor\'s Popular E-Mail Clients</strong></a></li>
+++					</ul>
+++					</li>',
+++	
+++	
+++	'NEWSLETTER_NOTICE'			=> '<div class="phpinfo"><p>The settings for this extension are under <strong>%1$s &#187; %2$s &#187; %3$s</strong>. <br />Please note, at first setup when the period is set (for example weekly) and the format (HTML) the first automatic newsletter overview is sent out immediately right after the settings are saved! <br />This is needed to start the Synchronization. With this in mind, consider using a test board before using the extension to make sure the end result of the newlsetter is the preferred look.</p></div>',
+++	'SS_HELPER_NOTY'			=> 'SiteSplat BBcore does not exist!<br />Download the <a href="https://sitesplat.com" target="_blank">BBcore</a> and copy the BBcore folder into your sitesplat extension folder.',
+++));
+++
+++// Description of Donations extension
+++$lang = array_merge($lang, array(
+++	'DESCRIPTION_PAGE'		=> 'Description',
+++	'DESCRIPTION_NOTICE'	=> 'Extension note',
+++	'ext_details' => array(
+++		'details' => array(
+++			'DESCRIPTION_1'	=> 'HTML newsletter',
+++			'DESCRIPTION_2'	=> 'Groupselect',
+++			'DESCRIPTION_3'	=> 'Weekly / monthly news overview',
+++			'DESCRIPTION_4'	=> 'Send immediately or in batch',
+++			'DESCRIPTION_5'	=> 'Overview subscribers',
+++		),
+++		'note' => array(
+++			'NOTICE_1'		=> '<a href="https://github.com/ForumHulp/htmlemail" target="_blank">HTML email extension</a> is needed to enable the HTML settings.',
+++			'NOTICE_2'		=> 'phpBB 3.2 ready'
+++		)
+++	)
+++));
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/language/pt/newsletter.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/language/pt/newsletter.php"
++new file mode 100644
++index 000000000..02aa2312c
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/language/pt/newsletter.php"
++@@ -0,0 +1,40 @@
+++<?php
+++/**
+++*
+++* @package BBnewsletter
+++* @copyright (c) 2016 SiteSplat All rights reserved
+++* @license Proprietary
+++*
+++*/
+++
+++if (!defined('IN_PHPBB'))
+++{
+++	exit;
+++}
+++
+++if (empty($lang) || !is_array($lang))
+++{
+++	$lang = array();
+++}
+++
+++$lang = array_merge($lang, array(
+++	'NEWSLETTER'				=> 'Newsletter',
+++	'OVERVIEW'					=> 'Welcome to our Newsletter! :-) On this page you will find the latest Newsletters as well as the past years archives.',
+++
+++	'SUBSCRIBE_NO'				=> 'I do NOT want to receive the Newsletter anymore',
+++	'SUBSCRIBE_YES'				=> 'Yes I want to receive the Newsletter',
+++	'SUBSCRIBE_BTN_NO'			=> 'Cancel',
+++	'SUBSCRIBE_BTN_YES'			=> 'Subscribe',
+++	'SUBSCRIBE_CONFIRM_NO'		=> 'Please submit to cancel your subscription',
+++	'SUBSCRIBE_CONFIRM_YES'		=> 'Please submit to confirm your subscription',
+++
+++	'SUBSCRIBE_Y_EMAIL'			=> 'Your email',
+++	'SUBSCRIBE'					=> 'Subscribe to',
+++	'UNSUBSCRIBE'				=> 'Unsubscribe from',
+++	'SUBSCRIBE_INFO'			=> 'Our newsletter. Unsubscribed members won\'t receive our periodic News overview anymore.',
+++	
+++	'OVERVIEW_ARCHIVE'			=> 'Archive',
+++	'ARCHIVES'					=> 'Archives',
+++	'SUBSCRIBED'				=> 'Thanks for subscribing! You will receive our newsletter from today on!',
+++	'UNSUBSCRIBED'				=> 'Successfully unsubscribed, you won\'t receive our newsletter any longer'
+++));
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/language/pt_preao/email/index.htm" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/language/pt_preao/email/index.htm"
++new file mode 100644
++index 000000000..ee1f723a7
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/language/pt_preao/email/index.htm"
++@@ -0,0 +1,10 @@
+++<html>
+++<head>
+++<title></title>
+++<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
+++</head>
+++
+++<body bgcolor="#FFFFFF" text="#000000">
+++
+++</body>
+++</html>
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/language/pt_preao/email/newsletter_html.txt" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/language/pt_preao/email/newsletter_html.txt"
++new file mode 100644
++index 000000000..127a2a9ec
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/language/pt_preao/email/newsletter_html.txt"
++@@ -0,0 +1,293 @@
+++Subject: {SUBJECT}
+++
+++<!DOCTYPE html>
+++<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
+++
+++<head>
+++  <meta charset="utf-8"> <!-- utf-8 works for most cases -->
+++  <meta name="viewport" content="width=device-width"> <!-- Forcing initial-scale shouldn't be necessary -->
+++  <meta http-equiv="X-UA-Compatible" content="IE=edge"> <!-- Use the latest (edge) version of IE rendering engine -->
+++  <meta name="x-apple-disable-message-reformatting"> <!-- Disable auto-scale in iOS 10 Mail entirely -->
+++
+++  <!-- Web Font / @font-face : BEGIN -->
+++  <!-- NOTE: If web fonts are not required, lines 10 - 27 can be safely removed. -->
+++
+++  <!-- Desktop Outlook chokes on web font references and defaults to Times New Roman, so we force a safe fallback font. -->
+++  <!--[if mso]>
+++        <style>
+++            * {
+++                font-family: sans-serif !important;
+++            }
+++        </style>
+++    <![endif]-->
+++
+++  <!-- All other clients get the webfont reference; some will render the font and others will silently fail to the fallbacks. More on that here: http://stylecampaign.com/blog/2015/02/webfont-support-in-email/ -->
+++  <!--[if !mso]><!-->
+++  <!-- insert web font reference, eg: <link href='https://fonts.googleapis.com/css?family=Roboto:400,700' rel='stylesheet' type='text/css'> -->
+++  <!--<![endif]-->
+++
+++  <!-- Web Font / @font-face : END -->
+++
+++  <!-- CSS Reset : BEGIN -->
+++  <style>
+++    /* What it does: Remove spaces around the email design added by some email clients. */
+++    /* Beware: It can remove the padding / margin and add a background color to the compose a reply window. */
+++    html,
+++    body {
+++      margin: 0 auto !important;
+++      padding: 0 !important;
+++      height: 100% !important;
+++      width: 100% !important;
+++    }
+++
+++    /* What it does: Stops email clients resizing small text. */
+++    * {
+++      -ms-text-size-adjust: 100%;
+++      -webkit-text-size-adjust: 100%;
+++    }
+++
+++    /* What it does: Centers email on Android 4.4 */
+++    div[style*="margin: 16px 0"] {
+++      margin: 0 !important;
+++    }
+++
+++    /* What it does: Stops Outlook from adding extra spacing to tables. */
+++    table,
+++    td {
+++      mso-table-lspace: 0pt !important;
+++      mso-table-rspace: 0pt !important;
+++    }
+++
+++    /* What it does: Fixes webkit padding issue. Fix for Yahoo mail table alignment bug. Applies table-layout to the first 2 tables then removes for anything nested deeper. */
+++    table {
+++      border-spacing: 0 !important;
+++      border-collapse: collapse !important;
+++      table-layout: fixed !important;
+++      margin: 0 auto !important;
+++    }
+++
+++    table table table {
+++      table-layout: auto;
+++    }
+++
+++    /* What it does: Uses a better rendering method when resizing images in IE. */
+++    img {
+++      -ms-interpolation-mode: bicubic;
+++    }
+++
+++    /* What it does: A work-around for email clients meddling in triggered links. */
+++    *[x-apple-data-detectors],
+++    /* iOS */
+++    .x-gmail-data-detectors,
+++    /* Gmail */
+++    .x-gmail-data-detectors *,
+++    .aBn {
+++      border-bottom: 0 !important;
+++      cursor: default !important;
+++      color: inherit !important;
+++      text-decoration: none !important;
+++      font-size: inherit !important;
+++      font-family: inherit !important;
+++      font-weight: inherit !important;
+++      line-height: inherit !important;
+++    }
+++
+++    /* What it does: Prevents Gmail from displaying an download button on large, non-linked images. */
+++    .a6S {
+++      display: none !important;
+++      opacity: 0.01 !important;
+++    }
+++
+++    /* If the above doesn't work, add a .g-img class to any image in question. */
+++    img.g-img+div {
+++      display: none !important;
+++    }
+++
+++    /* What it does: Prevents underlining the button text in Windows 10 */
+++    .button-link {
+++      text-decoration: none !important;
+++    }
+++
+++    /* What it does: Removes right gutter in Gmail iOS app: https://github.com/TedGoas/Cerberus/issues/89  */
+++    /* Create one of these media queries for each additional viewport size you'd like to fix */
+++    /* Thanks to Eric Lepetit (@ericlepetitsf) for help troubleshooting */
+++    @media only screen and (min-device-width: 375px) and (max-device-width: 413px) {
+++
+++      /* iPhone 6 and 6+ */
+++      .email-container {
+++        min-width: 375px !important;
+++      }
+++    }
+++
+++    @media screen and (max-width: 480px) {
+++
+++      /* What it does: Forces Gmail app to display email full width */
+++      u~div .email-container {
+++        min-width: 100vw;
+++        width: 100% !important;
+++      }
+++    }
+++  </style>
+++  <!-- CSS Reset : END -->
+++
+++  <!-- Progressive Enhancements : BEGIN -->
+++  <style>
+++    /* What it does: Hover styles for buttons */
+++    .button-td,
+++    .button-a {
+++      transition: all 100ms ease-in;
+++    }
+++
+++    .button-td:hover,
+++    .button-a:hover {
+++      background: #CC9900 !important;
+++      border-color: #CC9900 !important;
+++    }
+++
+++    /* Define o estilo dos links */
+++    a:link {
+++      color: #CC9900;
+++      background-color: transparent;
+++      text-decoration: none;
+++    }
+++
+++    a:visited {
+++      color: #CC9900;
+++      background-color: transparent;
+++      text-decoration: none;
+++    }
+++
+++    a:hover {
+++      color: #CC9900;
+++      background-color: transparent;
+++      text-decoration: underline;
+++    }
+++
+++    a:active {
+++      color: #CC9900;
+++      background-color: transparent;
+++      text-decoration: underline;
+++    }
+++
+++    /* Media Queries */
+++    @media screen and (max-width: 600px) {
+++
+++      .email-container {
+++        width: 100% !important;
+++        margin: auto !important;
+++      }
+++
+++      /* What it does: Forces elements to resize to the full width of their container. Useful for resizing images beyond their max-width. */
+++      .fluid {
+++        max-width: 100% !important;
+++        height: auto !important;
+++        margin-left: auto !important;
+++        margin-right: auto !important;
+++      }
+++
+++      /* What it does: Forces table cells into full-width rows. */
+++      .stack-column,
+++      .stack-column-center {
+++        display: block !important;
+++        width: 100% !important;
+++        max-width: 100% !important;
+++        direction: ltr !important;
+++      }
+++
+++      /* And center justify these ones. */
+++      .stack-column-center {
+++        text-align: center !important;
+++      }
+++
+++      /* What it does: Generic utility class for centering. Useful for images, buttons, and nested tables. */
+++      .center-on-narrow {
+++        text-align: center !important;
+++        display: block !important;
+++        margin-left: auto !important;
+++        margin-right: auto !important;
+++        float: none !important;
+++      }
+++
+++      table.center-on-narrow {
+++        display: inline-block !important;
+++      }
+++
+++      /* What it does: Adjust typography on small screens to improve readability */
+++      .email-container p {
+++        font-size: 17px !important;
+++      }
+++    }
+++  </style>
+++  <!-- Progressive Enhancements : END -->
+++
+++  <!-- What it does: Makes background images in 72ppi Outlook render at correct size. -->
+++  <!--[if gte mso 9]>
+++    <xml>
+++        <o:OfficeDocumentSettings>
+++            <o:AllowPNG/>
+++            <o:PixelsPerInch>96</o:PixelsPerInch>
+++        </o:OfficeDocumentSettings>
+++    </xml>
+++    <![endif]-->
+++
+++</head>
+++
+++<body width="100%" bgcolor="#222222" style="margin: 0; mso-line-height-rule: exactly;">
+++  <center style="width: 100%; background: #fafafa; text-align: left;">
+++
+++    <!-- Email Header : BEGIN -->
+++    <table role="presentation" cellspacing="0" cellpadding="0" border="0" align="center" width="600" style="margin: auto;" class="email-container" bgcolor="#1E1E1E">
+++      <tr>
+++        <td style="padding: 20px 0; text-align: center">
+++          <a href="https://goldtuganime.com" target="_blank"><img src="https://upload.goldtuganime.com/redes-sociais/GTA_Logo_Newsletter.png" width="282" border="0" style="height: auto; font-family: sans-serif; font-size: 15px; line-height: 140%; color: #555555;"></a>
+++        </td>
+++      </tr>
+++    </table>
+++    <!-- Email Header : END -->
+++
+++    {MESSAGE}
+++
+++    <!-- Email Footer : BEGIN -->
+++    <table role="presentation" bgcolor="#1E1E1E" cellspacing="0" cellpadding="0" border="0" align="center" width="100%" style="max-width: 600px; font-family: sans-serif; color: #888888; font-size: 11px; line-height: 140%;">
+++      <tr>
+++        <td style="padding: 10px 10px; width: 100%; font-family: sans-serif; font-size: 12px; line-height: 140%; text-align: center; color: #888888;" class="x-gmail-data-detectors">
+++          <table width="300" border="0" cellspacing="10" cellpadding="10">
+++            <tbody>
+++              <tr>
+++                <td><a href="https://www.facebook.com/goldtuganimeoficial/" target="_blank"><img src="https://upload.goldtuganime.com/redes-sociais/facebook-Y.png" height="24" width="24" class=""></a></td>
+++                <td><a href="https://www.instagram.com/goldtuganime/" target="_blank"><img src="https://upload.goldtuganime.com/redes-sociais/instagram-Y.png" height="24" width="24" class=""></a></td>
+++                <td><a href="https://discord.gg/Zk8CCZUG/" target="_blank"><img src="https://upload.goldtuganime.com/redes-sociais/discord-Y.png" height="24" width="24" class=""></a></td>
+++                <td><a href="https://www.youtube.com/@GoldTugAnimeOFICIAL" target="_blank"><img src="https://upload.goldtuganime.com/redes-sociais/youtube-Y.png" height="24" width="24" class=""></a></td>
+++                <td><a href="https://goldtuganime.com" target="_blank"><img src="https://upload.goldtuganime.com/redes-sociais/website-Y.png" height="24" width="24" class=""></a></td>
+++              </tr>
+++            </tbody>
+++          </table>
+++
+++        </td>
+++      </tr>
+++    </table>
+++    <table role="presentation" cellspacing="0" cellpadding="0" border="0" align="center" width="100%" style="max-width: 600px; font-family: sans-serif; color: #888888; font-size: 11px; line-height: 140%;">
+++      <tr>
+++        <td style="padding: 10px 10px; width: 100%; font-family: sans-serif; font-size: 12px; line-height: 140%; text-align: center; color: #888888;" class="x-gmail-data-detectors"><em>Copyright © 2023 | <a href="https://goldtuganime.com" target="_blank">GoldTugAnime</a> | Todos os direitos reservados.</em></td>
+++      </tr>
+++      <tr>
+++        <td>
+++          <table width="400" border="0" cellspacing="0" cellpadding="0">
+++            <tbody>
+++              <tr>
+++                <td width="400" height="2" bgcolor="#CC9900" align="center" valign="bottom" style="padding: 0px;"></td>
+++              </tr>
+++            </tbody>
+++          </table>
+++        </td>
+++      </tr>
+++      <tr>
+++        <td style="padding: 10px 10px; width: 100%; font-family: sans-serif; font-size: 8px; line-height: 140%; text-align: center; color: #888888;" class="x-gmail-data-detectors">Estás a receber este e-mail porque estás inscrito no nosso fórum. <a href="{NEWSLETTER_ONLINE}" target="_blank">Vê aqui</a> que newsletters já recebeste ou remove o teu endereço electrónico da nossa lista através do link <a href="{NEWSLETTER_OPTOUT}" target="_blank">remover subscrição</a>, caso pretendas.
+++        </td>
+++      </tr>
+++    </table>
+++    <!-- Email Footer : END -->
+++  </center>
+++</body>
+++
+++</html>
++\ No newline at end of file
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/language/pt_preao/email/newsletter_txt.txt" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/language/pt_preao/email/newsletter_txt.txt"
++new file mode 100644
++index 000000000..0b839ca10
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/language/pt_preao/email/newsletter_txt.txt"
++@@ -0,0 +1,6 @@
+++Subject: Newsletter de {SITENAME}
+++
+++{MESSAGE}
+++
+++Todas as newsletter: {NEWSLETTER_ONLINE}
+++Não desejas continuar a receber a nossa newsletter? Clica aqui: {NEWSLETTER_OPTOUT}
++\ No newline at end of file
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/language/pt_preao/email/newsoverview_html.txt" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/language/pt_preao/email/newsoverview_html.txt"
++new file mode 100644
++index 000000000..66cf8a5ba
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/language/pt_preao/email/newsoverview_html.txt"
++@@ -0,0 +1,961 @@
+++Subject: Últimas Novidades "{SITENAME}"
+++
+++<html xmlns="http://www.w3.org/1999/xhtml" style="margin: 0;padding: 0;">
+++<!--<![endif]-->
+++
+++<head>
+++	<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
+++	<!--[if !mso]><!-->
+++	<meta content="IE=edge" http-equiv="X-UA-Compatible">
+++	<!--<![endif]-->
+++	<meta content="width=device-width" name="viewport">
+++	<style type="text/css">
+++		@media only screen and (min-width: 620px) {
+++			* [lang=x-wrapper] h1 {
+++				font-size: 26px !important;
+++				line-height: 34px !important;
+++			}
+++			* [lang=x-wrapper] h2 {
+++				font-size: 20px !important;
+++				line-height: 28px !important;
+++			}
+++			* div [lang=x-size-8] {
+++				font-size: 8px !important;
+++				line-height: 14px !important;
+++			}
+++			* div [lang=x-size-9] {
+++				font-size: 9px !important;
+++				line-height: 16px !important;
+++			}
+++			* div [lang=x-size-10] {
+++				font-size: 10px !important;
+++				line-height: 18px !important;
+++			}
+++			* div [lang=x-size-11] {
+++				font-size: 11px !important;
+++				line-height: 19px !important;
+++			}
+++			* div [lang=x-size-12] {
+++				font-size: 12px !important;
+++				line-height: 19px !important;
+++			}
+++			* div [lang=x-size-13] {
+++				font-size: 13px !important;
+++				line-height: 21px !important;
+++			}
+++			* div [lang=x-size-14] {
+++				font-size: 14px !important;
+++				line-height: 21px !important;
+++			}
+++			* div [lang=x-size-15] {
+++				font-size: 15px !important;
+++				line-height: 23px !important;
+++			}
+++			* div [lang=x-size-16] {
+++				font-size: 16px !important;
+++				line-height: 24px !important;
+++			}
+++			* div [lang=x-size-17] {
+++				font-size: 17px !important;
+++				line-height: 26px !important;
+++			}
+++			* div [lang=x-size-18] {
+++				font-size: 18px !important;
+++				line-height: 26px !important;
+++			}
+++			* div [lang=x-size-18] {
+++				font-size: 18px !important;
+++				line-height: 26px !important;
+++			}
+++			* div [lang=x-size-20] {
+++				font-size: 20px !important;
+++				line-height: 28px !important;
+++			}
+++			* div [lang=x-size-22] {
+++				font-size: 22px !important;
+++				line-height: 31px !important;
+++			}
+++			* div [lang=x-size-24] {
+++				font-size: 24px !important;
+++				line-height: 32px !important;
+++			}
+++			* div [lang=x-size-26] {
+++				font-size: 26px !important;
+++				line-height: 34px !important;
+++			}
+++			* div [lang=x-size-28] {
+++				font-size: 28px !important;
+++				line-height: 36px !important;
+++			}
+++			* div [lang=x-size-30] {
+++				font-size: 30px !important;
+++				line-height: 38px !important;
+++			}
+++			* div [lang=x-size-32] {
+++				font-size: 32px !important;
+++				line-height: 40px !important;
+++			}
+++			* div [lang=x-size-34] {
+++				font-size: 34px !important;
+++				line-height: 43px !important;
+++			}
+++			* div [lang=x-size-36] {
+++				font-size: 36px !important;
+++				line-height: 43px !important;
+++			}
+++			* div [lang=x-size-40] {
+++				font-size: 40px !important;
+++				line-height: 47px !important;
+++			}
+++			* div [lang=x-size-44] {
+++				font-size: 44px !important;
+++				line-height: 50px !important;
+++			}
+++			* div [lang=x-size-48] {
+++				font-size: 48px !important;
+++				line-height: 54px !important;
+++			}
+++			* div [lang=x-size-56] {
+++				font-size: 56px !important;
+++				line-height: 60px !important;
+++			}
+++			* div [lang=x-size-64] {
+++				font-size: 64px !important;
+++				line-height: 63px !important;
+++			}
+++		}
+++	</style>
+++	<style type="text/css">
+++		body {
+++			margin: 0;
+++			padding: 0;
+++		}
+++		
+++		table {
+++			border-collapse: collapse;
+++			table-layout: fixed;
+++		}
+++		
+++		* {
+++			line-height: inherit;
+++		}
+++		
+++		[x-apple-data-detectors],
+++		[href^="tel"],
+++		[href^="sms"] {
+++			color: inherit !important;
+++			text-decoration: none !important;
+++		}
+++		
+++		.wrapper .footer__share-button a:hover,
+++		.wrapper .footer__share-button a:focus {
+++			color: #ffffff !important;
+++		}
+++		
+++		.btn a:hover,
+++		.btn a:focus,
+++		.footer__share-button a:hover,
+++		.footer__share-button a:focus,
+++		.email-footer__links a:hover,
+++		.email-footer__links a:focus {
+++			opacity: 0.8;
+++		}
+++		
+++		.ie .btn {
+++			width: 100%;
+++		}
+++		
+++		.ie .column,
+++		[owa] .column,
+++		.ie .gutter,
+++		[owa] .gutter {
+++			display: table-cell;
+++			float: none !important;
+++			vertical-align: top;
+++		}
+++		
+++		.ie .preheader,
+++		[owa] .preheader,
+++		.ie .email-footer,
+++		[owa] .email-footer {
+++			width: 560px !important;
+++		}
+++		
+++		.ie .snippet,
+++		[owa] .snippet,
+++		.ie .webversion,
+++		[owa] .webversion {
+++			width: 280px !important;
+++		}
+++		
+++		.ie .header,
+++		[owa] .header,
+++		.ie .layout,
+++		[owa] .layout,
+++		.ie .one-col .column,
+++		[owa] .one-col .column {
+++			width: 600px !important;
+++		}
+++		
+++		.ie .fixed-width.has-border,
+++		[owa] .fixed-width.has-border,
+++		.ie .has-gutter.has-border,
+++		[owa] .has-gutter.has-border {
+++			width: 602px !important;
+++		}
+++		
+++		.ie .two-col .column,
+++		[owa] .two-col .column {
+++			width: 300px !important;
+++		}
+++		
+++		.ie .three-col .column,
+++		[owa] .three-col .column,
+++		.ie .narrow,
+++		[owa] .narrow {
+++			width: 200px !important;
+++		}
+++		
+++		.ie .wide,
+++		[owa] .wide {
+++			width: 400px !important;
+++		}
+++		
+++		.ie .two-col.has-gutter .column,
+++		[owa] .two-col.x_has-gutter .column {
+++			width: 290px !important;
+++		}
+++		
+++		.ie .three-col.has-gutter .column,
+++		[owa] .three-col.x_has-gutter .column,
+++		.ie .has-gutter .narrow,
+++		[owa] .has-gutter .narrow {
+++			width: 188px !important;
+++		}
+++		
+++		.ie .has-gutter .wide,
+++		[owa] .has-gutter .wide {
+++			width: 394px !important;
+++		}
+++		
+++		.ie .two-col.has-gutter.has-border .column,
+++		[owa] .two-col.x_has-gutter.x_has-border .column {
+++			width: 292px !important;
+++		}
+++		
+++		.ie .three-col.has-gutter.has-border .column,
+++		[owa] .three-col.x_has-gutter.x_has-border .column,
+++		.ie .has-gutter.has-border .narrow,
+++		[owa] .has-gutter.x_has-border .narrow {
+++			width: 190px !important;
+++		}
+++		
+++		.ie .has-gutter.has-border .wide,
+++		[owa] .has-gutter.x_has-border .wide {
+++			width: 396px !important;
+++		}
+++		
+++		.ie .fixed-width .layout__inner {
+++			border-left: 0 none white !important;
+++			border-right: 0 none white !important;
+++		}
+++		
+++		.ie .layout__edges {
+++			display: none;
+++		}
+++		
+++		.mso .layout__edges {
+++			font-size: 0;
+++		}
+++		
+++		.layout-fixed-width,
+++		.mso .layout-full-width {
+++			background-color: #ffffff;
+++		}
+++		
+++		@media only screen and (min-width: 620px) {
+++			.column,
+++			.gutter {
+++				display: table-cell;
+++				Float: none !important;
+++				vertical-align: top;
+++			}
+++			.preheader,
+++			.email-footer {
+++				width: 560px !important;
+++			}
+++			.snippet,
+++			.webversion {
+++				width: 280px !important;
+++			}
+++			.header,
+++			.layout,
+++			.one-col .column {
+++				width: 600px !important;
+++			}
+++			.fixed-width.has-border,
+++			.fixed-width.ecxhas-border,
+++			.has-gutter.has-border,
+++			.has-gutter.ecxhas-border {
+++				width: 602px !important;
+++			}
+++			.two-col .column {
+++				width: 300px !important;
+++			}
+++			.three-col .column,
+++			.column.narrow {
+++				width: 200px !important;
+++			}
+++			.column.wide {
+++				width: 400px !important;
+++			}
+++			.two-col.has-gutter .column,
+++			.two-col.ecxhas-gutter .column {
+++				width: 290px !important;
+++			}
+++			.three-col.has-gutter .column,
+++			.three-col.ecxhas-gutter .column,
+++			.has-gutter .narrow {
+++				width: 188px !important;
+++			}
+++			.has-gutter .wide {
+++				width: 394px !important;
+++			}
+++			.two-col.has-gutter.has-border .column,
+++			.two-col.ecxhas-gutter.ecxhas-border .column {
+++				width: 292px !important;
+++			}
+++			.three-col.has-gutter.has-border .column,
+++			.three-col.ecxhas-gutter.ecxhas-border .column,
+++			.has-gutter.has-border .narrow,
+++			.has-gutter.ecxhas-border .narrow {
+++				width: 190px !important;
+++			}
+++			.has-gutter.has-border .wide,
+++			.has-gutter.ecxhas-border .wide {
+++				width: 396px !important;
+++			}
+++		}
+++		
+++		@media only screen and (-webkit-min-device-pixel-ratio: 2),
+++		only screen and (min--moz-device-pixel-ratio: 2),
+++		only screen and (-o-min-device-pixel-ratio: 2/1),
+++		only screen and (min-device-pixel-ratio: 2),
+++		only screen and (min-resolution: 192dpi),
+++		only screen and (min-resolution: 2dppx) {
+++			.fblike {
+++				background-image: url(https://i3.createsend1.com/static/eb/master/13-the-blueprint-3/images/fblike@2x.png) !important;
+++			}
+++			.tweet {
+++				background-image: url(https://i4.createsend1.com/static/eb/master/13-the-blueprint-3/images/tweet@2x.png) !important;
+++			}
+++			.linkedinshare {
+++				background-image: url(https://i6.createsend1.com/static/eb/master/13-the-blueprint-3/images/lishare@2x.png) !important;
+++			}
+++			.forwardtoafriend {
+++				background-image: url(https://i7.createsend1.com/static/eb/master/13-the-blueprint-3/images/forward@2x.png) !important;
+++			}
+++		}
+++		
+++		@media (max-width: 321px) {
+++			.fixed-width.has-border .layout__inner {
+++				border-width: 1px 0 !important;
+++			}
+++			.layout,
+++			.column {
+++				min-width: 320px !important;
+++				width: 320px !important;
+++			}
+++			.border {
+++				display: none;
+++			}
+++		}
+++		
+++		.mso div {
+++			border: 0 none white !important;
+++		}
+++		
+++		.mso .w560 .divider {
+++			Margin-left: 260px !important;
+++			Margin-right: 260px !important;
+++		}
+++		
+++		.mso .w360 .divider {
+++			Margin-left: 160px !important;
+++			Margin-right: 160px !important;
+++		}
+++		
+++		.mso .w260 .divider {
+++			Margin-left: 110px !important;
+++			Margin-right: 110px !important;
+++		}
+++		
+++		.mso .w160 .divider {
+++			Margin-left: 60px !important;
+++			Margin-right: 60px !important;
+++		}
+++		
+++		.mso .w354 .divider {
+++			Margin-left: 157px !important;
+++			Margin-right: 157px !important;
+++		}
+++		
+++		.mso .w250 .divider {
+++			Margin-left: 105px !important;
+++			Margin-right: 105px !important;
+++		}
+++		
+++		.mso .w148 .divider {
+++			Margin-left: 54px !important;
+++			Margin-right: 54px !important;
+++		}
+++		
+++		.mso .font-avenir,
+++		.mso .font-cabin,
+++		.mso .font-open-sans,
+++		.mso .font-ubuntu {
+++			font-family: sans-serif !important;
+++		}
+++		
+++		.mso .font-bitter,
+++		.mso .font-merriweather,
+++		.mso .font-pt-serif {
+++			font-family: Georgia, serif !important;
+++		}
+++		
+++		.mso .font-lato,
+++		.mso .font-roboto {
+++			font-family: Tahoma, sans-serif !important;
+++		}
+++		
+++		.mso .font-pt-sans {
+++			font-family: "Trebuchet MS", sans-serif !important;
+++		}
+++		
+++		.mso .footer__share-button p {
+++			margin: 0;
+++		}
+++		
+++		@media only screen and (min-width: 620px) {
+++			.wrapper .size-8 {
+++				font-size: 8px !important;
+++				line-height: 14px !important;
+++			}
+++			.wrapper .size-9 {
+++				font-size: 9px !important;
+++				line-height: 16px !important;
+++			}
+++			.wrapper .size-10 {
+++				font-size: 10px !important;
+++				line-height: 18px !important;
+++			}
+++			.wrapper .size-11 {
+++				font-size: 11px !important;
+++				line-height: 19px !important;
+++			}
+++			.wrapper .size-12 {
+++				font-size: 12px !important;
+++				line-height: 19px !important;
+++			}
+++			.wrapper .size-13 {
+++				font-size: 13px !important;
+++				line-height: 21px !important;
+++			}
+++			.wrapper .size-14 {
+++				font-size: 14px !important;
+++				line-height: 21px !important;
+++			}
+++			.wrapper .size-15 {
+++				font-size: 15px !important;
+++				line-height: 23px !important;
+++			}
+++			.wrapper .size-16 {
+++				font-size: 16px !important;
+++				line-height: 24px !important;
+++			}
+++			.wrapper .size-17 {
+++				font-size: 17px !important;
+++				line-height: 26px !important;
+++			}
+++			.wrapper .size-18 {
+++				font-size: 18px !important;
+++				line-height: 26px !important;
+++			}
+++			.wrapper .size-20 {
+++				font-size: 20px !important;
+++				line-height: 28px !important;
+++			}
+++			.wrapper .size-22 {
+++				font-size: 22px !important;
+++				line-height: 31px !important;
+++			}
+++			.wrapper .size-24 {
+++				font-size: 24px !important;
+++				line-height: 32px !important;
+++			}
+++			.wrapper .size-26 {
+++				font-size: 26px !important;
+++				line-height: 34px !important;
+++			}
+++			.wrapper .size-28 {
+++				font-size: 28px !important;
+++				line-height: 36px !important;
+++			}
+++			.wrapper .size-30 {
+++				font-size: 30px !important;
+++				line-height: 38px !important;
+++			}
+++			.wrapper .size-32 {
+++				font-size: 32px !important;
+++				line-height: 40px !important;
+++			}
+++			.wrapper .size-34 {
+++				font-size: 34px !important;
+++				line-height: 43px !important;
+++			}
+++			.wrapper .size-36 {
+++				font-size: 36px !important;
+++				line-height: 43px !important;
+++			}
+++			.wrapper .size-40 {
+++				font-size: 40px !important;
+++				line-height: 47px !important;
+++			}
+++			.wrapper .size-44 {
+++				font-size: 44px !important;
+++				line-height: 50px !important;
+++			}
+++			.wrapper .size-48 {
+++				font-size: 48px !important;
+++				line-height: 54px !important;
+++			}
+++			.wrapper .size-56 {
+++				font-size: 56px !important;
+++				line-height: 60px !important;
+++			}
+++			.wrapper .size-64 {
+++				font-size: 64px !important;
+++				line-height: 63px !important;
+++			}
+++		}
+++		
+++		.mso .size-8,
+++		.ie .size-8 {
+++			font-size: 8px !important;
+++			line-height: 14px !important;
+++		}
+++		
+++		.mso .size-9,
+++		.ie .size-9 {
+++			font-size: 9px !important;
+++			line-height: 16px !important;
+++		}
+++		
+++		.mso .size-10,
+++		.ie .size-10 {
+++			font-size: 10px !important;
+++			line-height: 18px !important;
+++		}
+++		
+++		.mso .size-11,
+++		.ie .size-11 {
+++			font-size: 11px !important;
+++			line-height: 19px !important;
+++		}
+++		
+++		.mso .size-12,
+++		.ie .size-12 {
+++			font-size: 12px !important;
+++			line-height: 19px !important;
+++		}
+++		
+++		.mso .size-13,
+++		.ie .size-13 {
+++			font-size: 13px !important;
+++			line-height: 21px !important;
+++		}
+++		
+++		.mso .size-14,
+++		.ie .size-14 {
+++			font-size: 14px !important;
+++			line-height: 21px !important;
+++		}
+++		
+++		.mso .size-15,
+++		.ie .size-15 {
+++			font-size: 15px !important;
+++			line-height: 23px !important;
+++		}
+++		
+++		.mso .size-16,
+++		.ie .size-16 {
+++			font-size: 16px !important;
+++			line-height: 24px !important;
+++		}
+++		
+++		.mso .size-17,
+++		.ie .size-17 {
+++			font-size: 17px !important;
+++			line-height: 26px !important;
+++		}
+++		
+++		.mso .size-18,
+++		.ie .size-18 {
+++			font-size: 18px !important;
+++			line-height: 26px !important;
+++		}
+++		
+++		.mso .size-20,
+++		.ie .size-20 {
+++			font-size: 20px !important;
+++			line-height: 28px !important;
+++		}
+++		
+++		.mso .size-22,
+++		.ie .size-22 {
+++			font-size: 22px !important;
+++			line-height: 31px !important;
+++		}
+++		
+++		.mso .size-24,
+++		.ie .size-24 {
+++			font-size: 24px !important;
+++			line-height: 32px !important;
+++		}
+++		
+++		.mso .size-26,
+++		.ie .size-26 {
+++			font-size: 26px !important;
+++			line-height: 34px !important;
+++		}
+++		
+++		.mso .size-28,
+++		.ie .size-28 {
+++			font-size: 28px !important;
+++			line-height: 36px !important;
+++		}
+++		
+++		.mso .size-30,
+++		.ie .size-30 {
+++			font-size: 30px !important;
+++			line-height: 38px !important;
+++		}
+++		
+++		.mso .size-32,
+++		.ie .size-32 {
+++			font-size: 32px !important;
+++			line-height: 40px !important;
+++		}
+++		
+++		.mso .size-34,
+++		.ie .size-34 {
+++			font-size: 34px !important;
+++			line-height: 43px !important;
+++		}
+++		
+++		.mso .size-36,
+++		.ie .size-36 {
+++			font-size: 36px !important;
+++			line-height: 43px !important;
+++		}
+++		
+++		.mso .size-40,
+++		.ie .size-40 {
+++			font-size: 40px !important;
+++			line-height: 47px !important;
+++		}
+++		
+++		.mso .size-44,
+++		.ie .size-44 {
+++			font-size: 44px !important;
+++			line-height: 50px !important;
+++		}
+++		
+++		.mso .size-48,
+++		.ie .size-48 {
+++			font-size: 48px !important;
+++			line-height: 54px !important;
+++		}
+++		
+++		.mso .size-56,
+++		.ie .size-56 {
+++			font-size: 56px !important;
+++			line-height: 60px !important;
+++		}
+++		
+++		.mso .size-64,
+++		.ie .size-64 {
+++			font-size: 64px !important;
+++			line-height: 63px !important;
+++		}
+++		
+++		.footer__share-button p {
+++			margin: 0;
+++		}
+++	</style>
+++
+++	<title>{SITENAME}</title>
+++	<!--[if !mso]><!-->
+++	<style type="text/css">
+++		@import url(https://fonts.googleapis.com/css?family=Bitter:400,700,400italic|Open+Sans:400italic,700italic,700,400);
+++	</style>
+++	<link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Bitter:400,700,400italic|Open+Sans:400italic,700italic,700,400">
+++	<!--<![endif]-->
+++	<style type="text/css">
+++		body {
+++			background-color: #f2f6f7
+++		}
+++		
+++		.mso h1 {}
+++		
+++		.mso h1 {
+++			font-family: Georgia, serif !important
+++		}
+++		
+++		.mso h2 {}
+++		
+++		.mso h2 {
+++			font-family: Georgia, serif !important
+++		}
+++		
+++		.mso h3 {}
+++		
+++		.mso h3 {
+++			font-family: Georgia, serif !important
+++		}
+++		
+++		.mso .column,
+++		.mso .column__background td {}
+++		
+++		.mso .column,
+++		.mso .column__background td {
+++			font-family: sans-serif !important
+++		}
+++		
+++		.mso .btn a {}
+++		
+++		.mso .btn a {
+++			font-family: sans-serif !important
+++		}
+++		
+++		.mso .webversion,
+++		.mso .snippet,
+++		.mso .layout-email-footer td,
+++		.mso .footer__share-button p {}
+++		
+++		.mso .webversion,
+++		.mso .snippet,
+++		.mso .layout-email-footer td,
+++		.mso .footer__share-button p {
+++			font-family: sans-serif !important
+++		}
+++		
+++		.mso .logo {}
+++		
+++		.mso .logo {
+++			font-family: Tahoma, sans-serif !important
+++		}
+++		
+++		.logo a:hover,
+++		.logo a:focus {
+++			color: #859bb1 !important
+++		}
+++		
+++		.mso .layout-has-border {
+++			border-top: 1px solid #b3cad0;
+++			border-bottom: 1px solid #b3cad0
+++		}
+++		
+++		.mso .layout-has-bottom-border {
+++			border-bottom: 1px solid #b3cad0
+++		}
+++		
+++		.mso .border,
+++		.ie .border {
+++			background-color: #b3cad0
+++		}
+++		
+++		@media only screen and (min-width: 620px) {
+++			.wrapper h1 {}
+++			.wrapper h1 {
+++				font-size: 26px !important;
+++				line-height: 34px !important
+++			}
+++			.wrapper h2 {}
+++			.wrapper h2 {
+++				font-size: 20px !important;
+++				line-height: 28px !important
+++			}
+++			.wrapper h3 {}
+++			.column,
+++			.column__background td {}
+++		}
+++		
+++		.mso h1,
+++		.ie h1 {}
+++		
+++		.mso h1,
+++		.ie h1 {
+++			font-size: 26px !important;
+++			line-height: 34px !important
+++		}
+++		
+++		.mso h2,
+++		.ie h2 {}
+++		
+++		.mso h2,
+++		.ie h2 {
+++			font-size: 20px !important;
+++			line-height: 28px !important
+++		}
+++		
+++		.mso h3,
+++		.ie h3 {}
+++		
+++		.mso .column,
+++		.ie .column,
+++		.mso .column__background td,
+++		.ie .column__background td {}
+++	</style>
+++</head>
+++<!--[if mso]>
+++	<body class="mso">
+++<![endif]-->
+++<!--[if !mso]><!-->
+++
+++<body style="margin: 0;padding: 0;-webkit-text-size-adjust: 100%;" class="full-padding">
+++	<!--<![endif]-->
+++	<div lang="x-wrapper" style="min-width: 320px;background-color: #f2f6f7;" class="wrapper">
+++		<div style="Margin: 0 auto;max-width: 560px;min-width: 280px; width: 280px;width: calc(28000% - 173040px);" class="preheader">
+++			<div style="border-collapse: collapse;display: table;width: 100%;">
+++				<!--[if (mso)|(IE)]><table align="center" class="preheader" cellpadding="0" cellspacing="0"><tr><td style="width: 280px" valign="top"><![endif]-->
+++				<div style="Float: left;font-size: 12px;line-height: 19px;max-width: 280px;min-width: 140px; width: 140px;width: calc(14000% - 78120px);padding: 10px 0 5px 0;color: #99b0b8;font-family: &quot;Open Sans&quot;,sans-serif;" class="snippet">
+++
+++				</div>
+++				<!--[if (mso)|(IE)]></td><td style="width: 280px" valign="top"><![endif]-->
+++				<div style="Float: left;font-size: 12px;line-height: 19px;max-width: 280px;min-width: 139px; width: 139px;width: calc(14100% - 78680px);padding: 10px 0 5px 0;text-align: right;color: #99b0b8;font-family: &quot;Open Sans&quot;,sans-serif;" class="webversion">
+++
+++				</div>
+++				<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
+++			</div>
+++		</div>
+++		<div id="emb-email-header-container" style="Margin: 0 auto;max-width: 600px;min-width: 320px; width: 320px;width: calc(28000% - 173000px);" class="header">
+++			<!--[if (mso)|(IE)]><table align="center" class="header" cellpadding="0" cellspacing="0"><tr><td style="width: 600px"><![endif]-->
+++			<div align="center" style="font-size: 26px;line-height: 32px;Margin-top: 6px;Margin-bottom: 20px;color: #c3ced9;font-family: Roboto,Tahoma,sans-serif;Margin-left: 20px;Margin-right: 20px;" class="logo emb-logo-margin-box">
+++				<div align="center" id="emb-email-header" style="font-size:0px !important;line-height:0 !important;" class="logo-center">
+++					<img width="141" alt="" src="{SITE_LOGO_IMG}" style="height: auto;width: 100%;border: 0;max-width: 141px;">
+++				</div>
+++			</div>
+++			<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
+++		</div>
+++		<div style="Margin: 0 auto;max-width: 600px;min-width: 320px; width: 320px;width: calc(28000% - 173000px);overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;" class="layout one-col fixed-width">
+++			<div emb-background-style="" style="border-collapse: collapse;display: table;width: 100%;background-color: #ffffff;" class="layout__inner">
+++				<!--[if (mso)|(IE)]><table align="center" cellpadding="0" cellspacing="0"><tr class="layout-fixed-width" emb-background-style><td style="width: 600px" class="w560"><![endif]-->
+++				<div style="text-align: left;color: #808285;font-size: 14px;line-height: 21px;font-family: &quot;Open Sans&quot;,sans-serif;max-width: 600px;min-width: 320px; width: 320px;width: calc(28000% - 167400px);" class="column">
+++
+++					<div style="Margin-left: 20px;Margin-right: 20px;Margin-top: 24px;">
+++						<div style="line-height:10px;font-size:1px">&nbsp;</div>
+++					</div>
+++
+++					<div style="Margin-left: 20px;Margin-right: 20px;">
+++						<div style="line-height:5px;font-size:1px">&nbsp;</div>
+++					</div>
+++
+++					<div style="Margin-left: 20px;Margin-right: 20px;">
+++						<h1 style="Margin-top: 0;Margin-bottom: 20px;font-style: normal;font-weight: normal;color: #58595b;font-size: 22px;line-height: 31px;font-family: Bitter,Georgia,serif;text-align: center;">Last Topics While You Were Away</h1>
+++					</div>
+++
+++					<div style="Margin-left: 20px;Margin-right: 20px;">
+++						<div style="display: block;font-size: 2px;line-height: 2px;Margin-left: auto;Margin-right: auto;width: 40px;background-color: #b3cad0;Margin-bottom: 20px;" class="divider">&nbsp;</div>
+++					</div>
+++
+++					<div style="Margin-left: 20px;Margin-right: 20px;">
+++						<p style="Margin-top: 0;Margin-bottom: 20px;text-align: center;">Enquanto estiveste fora a laurear a pevide, houve nova actividade no fórum. Vê a nova tendência. Estamos animados para te ver novamente!</p>
+++					    <p style="Margin-top: 10px;Margin-bottom: 20px;text-align: center;">{EMAIL_SIG}</p>
+++					</div>
+++
+++					<div style="Margin-left: 20px;Margin-right: 20px;">
+++						<div style="line-height:10px;font-size:1px">&nbsp;</div>
+++					</div>
+++
+++					<div style="Margin-left: 20px;Margin-right: 20px;">
+++						<div style="Margin-bottom: 20px;text-align: center;" class="btn btn--flat btn--large">
+++							<!--[if !mso]--><a href="{BOARD_URL}" style="border-radius: 4px;display: inline-block;font-size: 14px;font-weight: bold;line-height: 24px;padding: 12px 24px;text-align: center;text-decoration: none !important;transition: opacity 0.1s ease-in;color: #60686b;background-color: #becdd1;font-family: 'Open Sans', sans-serif;"
+++							target="_blank">Comunidade GoldTugAnime</a>
+++							<!--[endif]-->
+++							<!--[if mso]><p style="line-height:0;margin:0;">&nbsp;</p><v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" href="{BOARD_URL}" style="width:167px" arcsize="9%" fillcolor="#BECDD1" stroke="f"><v:textbox style="mso-fit-shape-to-text:t" inset="0px,11px,0px,11px"><center style="font-size:14px;line-height:24px;color:#60686B;font-family:sans-serif;font-weight:bold;mso-line-height-rule:exactly;mso-text-raise:4px">Discussion Board</center></v:textbox></v:roundrect><![endif]-->
+++						</div>
+++					</div>
+++
+++					<div style="Margin-left: 20px;Margin-right: 20px;Margin-bottom: 24px;">
+++						<div style="line-height:15px;font-size:1px">&nbsp;</div>
+++					</div>
+++
+++				</div>
+++				<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
+++			</div>
+++		</div>
+++
+++		<div style="line-height:20px;font-size:20px;">&nbsp;</div>
+++
+++		<div style="Margin: 0 auto;max-width: 600px;min-width: 320px; width: 320px;width: calc(28000% - 173000px);overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;" class="layout one-col fixed-width">
+++			<div emb-background-style="" style="border-collapse: collapse;display: table;width: 100%;background-color: #ffffff;" class="layout__inner">
+++				<!--[if (mso)|(IE)]><table align="center" cellpadding="0" cellspacing="0"><tr class="layout-fixed-width" emb-background-style><td style="width: 600px" class="w560"><![endif]-->
+++				<div style="text-align: left;color: #808285;font-size: 14px;line-height: 21px;font-family: &quot;Open Sans&quot;,sans-serif;max-width: 600px;min-width: 320px; width: 320px;width: calc(28000% - 167400px);" class="column">
+++
+++					<div style="Margin-left: 20px;Margin-right: 20px;Margin-top: 24px;Margin-bottom: 24px;">
+++<!-- BEGIN mailrow -->
+++						<p style="Margin-top: 0;Margin-bottom: 0;"><a href="{mailrow.U_TOPIC}" style="text-decoration: underline;transition: opacity 0.1s ease-in;color: #60686b;" target="_blank">{mailrow.TOPIC} em: {mailrow.FORUMS}</a></p>
+++<!-- END mailrow -->
+++						<p style="Margin-top: 20px;Margin-bottom: 0;">&nbsp;</p>
+++					</div>
+++
+++				</div>
+++				<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
+++			</div>
+++		</div>
+++
+++		<div style="line-height:20px;font-size:20px;">&nbsp;</div>
+++
+++		<div style="Margin: 0 auto;max-width: 600px;min-width: 320px; width: 320px;width: calc(28000% - 173000px);overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;" class="layout email-footer">
+++			<div style="border-collapse: collapse;display: table;width: 100%;" class="layout__inner">
+++				<!--[if (mso)|(IE)]><table align="center" cellpadding="0" cellspacing="0"><tr class="layout-email-footer"><td style="width: 400px;" valign="top" class="w360"><![endif]-->
+++				<div style="text-align: left;font-size: 12px;line-height: 19px;color: #99b0b8;font-family: &quot;Open Sans&quot;,sans-serif;Float: left;max-width: 400px;min-width: 320px; width: 320px;width: calc(8000% - 47600px);" class="column wide">
+++					<div style="Margin-left: 20px;Margin-right: 20px;Margin-top: 10px;Margin-bottom: 10px;">
+++
+++						<div>
+++
+++						</div>
+++						<div style="Margin-top: 18px;">
+++
+++						</div>
+++					</div>
+++				</div>
+++				<!--[if (mso)|(IE)]></td><td style="width: 200px;" valign="top" class="w160"><![endif]-->
+++				<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
+++			</div>
+++		</div>
+++		<div style="Margin: 0 auto;max-width: 600px;min-width: 320px; width: 320px;width: calc(28000% - 173000px);overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;" class="layout one-col email-footer">
+++			<div style="border-collapse: collapse;display: table;width: 100%;" class="layout__inner">
+++				<!--[if (mso)|(IE)]><table align="center" cellpadding="0" cellspacing="0"><tr class="layout-email-footer"><td style="width: 600px;" class="w560"><![endif]-->
+++				<div style="text-align: center;font-size: 12px;line-height: 19px;color: #99b0b8;font-family: &quot;Open Sans&quot;,sans-serif;max-width: 600px;min-width: 320px; width: 320px;width: calc(28000% - 167400px);" class="column">
+++					<div style="Margin-left: 20px;Margin-right: 20px;Margin-top: 10px;Margin-bottom: 10px;">
+++						<div>
+++							<span>
+++              <a lang="en" href="{U_BOARD}" style="text-decoration: underline;transition: opacity 0.1s ease-in;color: #99b0b8;" target="_blank">Preferências</a>
+++              &nbsp;&nbsp;|&nbsp;&nbsp;
+++            </span>
+++              <a href="{NEWSLETTER_OPTOUT}" style="text-decoration: underline;transition: opacity 0.1s ease-in;color: #99b0b8;" target="_blank">Cancelar Subscrição</a>
+++						</div>
+++					</div>
+++				</div>
+++				<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
+++			</div>
+++		</div>
+++		<div style="line-height:40px;font-size:40px;">&nbsp;</div>
+++
+++	</div>
+++
+++</body>
+++
+++</html>
++\ No newline at end of file
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/language/pt_preao/email/newsoverview_txt.txt" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/language/pt_preao/email/newsoverview_txt.txt"
++new file mode 100644
++index 000000000..24fee63c8
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/language/pt_preao/email/newsoverview_txt.txt"
++@@ -0,0 +1,17 @@
+++Subject: Latest topic at "{SITENAME}"
+++
+++{SITENAME}
+++
+++Latest Topics
+++Hi,
+++It's time for another newsletter.
+++We look forward to see you at {BOARD_URL} again.
+++
+++Forum				Topic
+++<!-- BEGIN mailrow -->
+++{mailrow.U_FORUM}				{mailrow.U_TOPIC}
+++<!-- END mailrow -->
+++
+++
+++{EMAIL_SIG}
+++Don't want to receive our newsletter anymore, click here {NEWSLETTER_OPTOUT}
++\ No newline at end of file
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/language/pt_preao/info_acp_newsletter.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/language/pt_preao/info_acp_newsletter.php"
++new file mode 100644
++index 000000000..cc9168a39
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/language/pt_preao/info_acp_newsletter.php"
++@@ -0,0 +1,181 @@
+++<?php
+++/**
+++*
+++* @package BBnewsletter
+++* @copyright (c) 2016 SiteSplat All rights reserved
+++* @license Proprietary
+++*
+++*/
+++
+++if (!defined('IN_PHPBB'))
+++{
+++	exit;
+++}
+++
+++if (empty($lang) || !is_array($lang))
+++{
+++	$lang = array();
+++}
+++
+++$lang = array_merge($lang, array(
+++	'ACP_NEWSLETTER'			=> 'Newsletter',
+++	'ACP_NEWSLETTER_EXPLAIN'	=> 'Setup your Newsletter, several options are available below. Please make sure your mailserver accepts all mails, otherwise it will use phpbb\'s mail settings to send emails in small batches. <br />The weekly and monthly "Catch-up" forum news are sent out by the cron task. Install <a href="https://github.com/ForumHulp/cronstatus" target="_blank">Cronstatus extension</a> and select "Run cron always" in the options to run more often the "Catch-up" News (This is especially useful for small forums). <br />For HTML e-mails install <a href=" https://github.com/ForumHulp/htmlemail" target="_blank">HTML emails Extension</a> which enables the HTML settings.<br />',
+++    'FORUMS_NEWS_FROM'		    => 'Newsletter forum source',
+++	'FORUMS_FROM_EXPLAIN'		=> 'Select the forums you would like the users to receive the news from',
+++	'SEND_IMMEDIATELY'			=> 'Send immediately',
+++	'SEND_IMMEDIATELY_EXPLAIN'	=> 'Attempt to send the emails immediately. This depends on the server email configuration parameters',
+++	'PERIOD'					=> 'Email Overview (or Catch-up) Period',
+++	'PERIOD_EXPLAIN'			=> 'This will send automatic "Catch-up"  emails to the users that are subscribed. The e-mail will be generated based on the new topics in the forum. The user will receive an email with the purpose of engaging the user\'s interest in the recent board\'s activity. Edit the templates file named newsletter_html.txt for the HTML version and newsletter_txt.txt for the TXT version from:<br /> <code>root\ext\sitesplat\newsletter\language\en\email\</code> <br /> To learn how to send out professional looking HTML emails check out the tutorials over at <a href=" https://sitesplat.com/" target="_blank">sitesplat.com</a> or click the "Tutorials" label above.',
+++	'WEEKLY'					=> 'Weekly',
+++	'MONTHLY'					=> 'Monthly',
+++	'NO_OVERVIEW'				=> 'None',
+++	'PERIOD_SEND'				=> 'Set period for automatic newsletter',
+++	'SEND_TO_GROUP'				=> 'Send to group',
+++	'SEND_TO_USERS'				=> 'Send to user(s)',
+++	'SEND_TO_USERS_EXPLAIN'		=> 'When using this field it will override the "Send to Group" option above. Each user on a new line',
+++	'ALL_USERS'					=> 'All users',
+++	'NEW_USER'					=> 'Allow new users',
+++	'MAIL_LOW_PRIORITY'			=> 'Low',
+++	'MAIL_NORMAL_PRIORITY'		=> 'Normal',
+++	'MAIL_HIGH_PRIORITY'		=> 'High',
+++	'MAIL_PRIORITY'				=> 'Mail priority',
+++	'USE_HTML'					=> 'Use HTML emails',
+++	'COMPOSE_HTML'				=> 'Send manually',
+++	'COMPOSE_HTML_EXPLAIN'		=> 'If "Send manually" is selected the HTML editor will be available to send custom emails in HTML format',
+++	'MASS_MESSAGE'				=> 'Message (Newsletter Body)',
+++	'MASS_MESSAGE_EXPLAIN'		=> 'HTML message will be stripped if HTML email Extension is not enabled. To use the HTML editor click on "Tools" then "Source code" and enter the HTML code in the code editor ',
+++	'FHHTML_EMAIL_NOT_ENABLED'	=> 'HTML email extension not enabled. Download it from https://github.com/ForumHulp/htmlemail',
+++	'FHHTML_EMAIL_DOWNLOAD'	    => 'HTML email Extension not enabled. Download it from <a href="https://github.com/ForumHulp/htmlemail" target="blank">GithHub HTML Email Ext</a>',
+++	'LAST_SEND'					=> '<span id="viewsubscribers" class="label label-info" title="View subscribers">%1$s Members</span> subscribed, last letter was sent on <strong class="text-info">%2$s</strong>',
+++	'LAST_SEND_LETTERS'			=> 'Last newsletters',
+++	'LAST_SEND_EXPLAIN'			=> '**Please note, new registered users are automatically subscribed. (Click "X Members" above to view the users list)',
+++	'LAST_NEWSLETTERS_EXPLAIN'	=> '**Please note, the following template visualized on the single emails below does NOT reflect 100% the email that was sent out. This is due to phpBB\'s ACP stylesheet obsolete CSS reset rules. Refer to your email copy or front-end archive for the exact email accuracy.<br /> This is a list with the sole purpose of keeping track of the emails and users in a simple manner.<br />Always save a copy of the composed HTML email before sending it out if you wish to re-use it in the future.',
+++	'NEWS_PAGE'					=> 'Visible',
+++	'HIDE'						=> 'Hide',
+++	'SHOW'						=> 'Show',
+++	'DELETE_MAIL_SUCCES'		=> 'Newsletter deleted',
+++	'ACP_NEWSOVERVIEW_SEND'		=> 'Newsletter(s) sent successfully',
+++	'ACP_NEWSOVERVIEW_SAVED'	=> 'Settings saved successfully',
+++	
+++	'SITESPLAT_COM'		        => 'https://sitesplat.com',
+++	'SITESPLAT_COPY'		    => '&#169; SiteSplat',
+++	'LICENSE_INFO'		        => 'Proprietary - SiteSplat All rights reserved',
+++	'EXTENSION_DEVELOPER'	    => 'Developer',
+++	'ACP_NOTICE_CLOSE'			=> 'Close',
+++	'ACP_NEWS_VERSION'          => '1.0.5',
+++	'ACP_LOADING'		        => 'Loading... Hold on',
+++	'FORUM_CONTENT'		        => 'forum content',
+++	'EXT_NEWS_DESCRIPTION_PAGE'	=> 'A Newsletter system with an archive, weekly, monthly and many more options to run your own HTML style newsletter like a pro!',
+++	'EXT_NEWS_TASKS_1'			=> 'Newsletter Archive',
+++	'EXT_NEWS_TASKS_2'			=> 'Full HTML Enabled',
+++	'EXT_NEWS_TASKS_3'			=> 'Synchronization with Cron tasks and compatible with <a href="https://www.phpbb.com/customise/db/extension/cronstatus/">Cron Status</a>',
+++	'EXT_NEWS_TASKS_4'			=> 'Scheduled Newsletter',
+++	'EXT_NEWS_TASKS_5'			=> 'Checkout the other premium addons on <a href="https://sitesplat.com/phpBB3/marketplace.php">sitesplat.com/marketplace.php</a>',
+++	'EXT_NEWS_TASKS_6'			=> 'phpBB 3.2 ready',
+++
+++	'NEWS_SUBSCRIBERS_INFO'     => 'Subscribers and news info',
+++	'NEWS_TRICKS_TITLE'         => 'Tips and Tricks',
+++	'ACP_NEWS_TRICK_EXPLAIN'	=> '<p>Does your ISP limit the number of emails you can send each day?</p>
+++									<p><strong>Of course they do!</strong>
+++									</p>
+++									<p>Every outgoing SMTP mail server is guided by a provider’s email policy which includes hourly and/or daily email send limits. This policy will ultimately determine how many emails you can send each day. You can find a list of the hourly and daily send limits for most of the major ISPs, web hosting companies and Free email address providers below.</p>
+++									<p><strong><a title="Email sending limits for isp, web hosting and free email providers" href="http://group-mail.com/sending-email/email-sending-limits-for-isp-web-hosting-and-free-email-providers/">Email Sending Limits of ISP, Web Hosting and Free Email Providers</a></strong>
+++									</p>
+++									<p>If you try to send more email than the hourly or daily email sending limits of your mail server, you will notice errors being returned after the specified quota is met, saying something along the lines of:<em> </em>
+++									</p>
+++									<blockquote>
+++										<p><em>you have reached your daily sending quota</em>…</p>
+++									</blockquote>
+++									<p>If you surpass the daily <a title="SMTP email sending limits" href="http://group-mail.com/sending-email/email-sending-limits-for-isp-web-hosting-and-free-email-providers/">SMTP email sending limits</a> of your provider, you will generally have to wait 24 hours before you can send more email through that particular server.</p>
+++									<p>But, what are the hourly or daily email sending limits for <em>your</em> email server?</p>
+++									<ul>
+++										<li>The Gmail mail server send limit is approximately 100-150 emails per day when connected to the server from a remote email client. You can send 500 emails each day through the Gmail SMTP server when logged into their web interface.</li>
+++										<li>The Comcast mail server limits residential customers to send 1,000 messages per day. Comcast Business customers can send 24,000 emails per day through the Comcast outgoing SMTP mail server.</li>
+++										<li>The basic GoDaddy email server limits senders to send&nbsp; only 250 outgoing emails per day, but you can <a title="send more email by adding SMTP relays to your GoDaddy account" href="http://group-mail.com/sending-email/how-to-increase-your-godaddy-email-sending-limits/">send more email by adding SMTP relays to your GoDaddy account</a>
+++										</li>
+++									</ul>
+++									<p>&nbsp;</p>
+++									<p>So, what’s a guy to do if he needs to get his monthly email newsletter out to 5,000 eager subscribers but his ISP has a daily send limit of 500 emails per day?</p>
+++									<p><strong>What can you do if your mail server has limits that don’t support the size of your mailing list?</strong>
+++									</p>
+++									<p>If your current outgoing SMTP email server does not support your email list size or sending frequency, you have a variety of options:</p>
+++									<p style="padding-left: 30px;">1. Contact the host of your outgoing SMTP mail server(s) and ask if they have a business account that lets you send more emails each day to support your business.</p>
+++									<p style="padding-left: 30px;">2. Use GroupMail’s <a title="sending email without an external SMTP mail server" href="http://group-mail.com/sending-email/sending-email-without-an-external-smtp-mail-server/">Direct Send option</a>, which allows you to bypass your external SMTP server altogether and send email directly from your computer to your recipients using GroupMail’s own internal SMTP engine.</p>
+++									<p style="padding-left: 30px;">3. Use an outgoing SMTP service like <a title="SMTP2Go outgoing relay pricing" href="http://groupmail.smtp2go.com">SMTP2Go</a> to relay your large email campaigns.</p>
+++									<p style="padding-left: 30px;">4. Find a web hosting company who has daily email sending limits that meet your needs.</p>
+++									<p style="padding-left: 30px;">5. Setup your own <a href="http://www.msexchange.org/tutorials/MF002.html">MS Exchange Server</a> and configure it for SMTP email delivery.</p>
+++									<p>So, while GroupMail allows you to send and manage email lists of an <strong>unlimited</strong> size; the success of email delivery to large groups is ultimately dependent upon the sending limits set forth in the email sending policy of the SMTP mail server you are using.</p>
+++									<p><strong>Related articles you might find interesting:</strong>
+++									</p>
+++									<p><a title="email sending limits of ISPs web hosting and free email providers" href="http://group-mail.com/sending-email/email-sending-limits-for-isp-web-hosting-and-free-email-providers/">Email Sending Limits for ISPs, Web Hosting and Free Email Providers</a>
+++									</p>
+++									<p><a title="Common email error code descriptions and fixes" href="http://group-mail.com/email-error-codes/common-email-error-codes/">Common Email Error Code Descriptions and Fixes</a>
+++									</p>
+++									<p><a title="Free Email Newsletter and Marketing Software and Services" href="http://group-mail.com/email-marketing/free-email-newsletter-and-marketing-software-and-services/">Free Email Newsletter and Marketing Software and Services</a>
+++									</p>
+++									<p><a title="Email Settings for the Most Common Email Server hosts" href="http://group-mail.com/category/email-settings/">Email Settings for the Most Common Email Server Hosts</a>
+++									</p>
+++									<p><a title="step by step guide for email setup and delivery" href="http://group-mail.com/getting-started-with-groupmail/step-by-step-guide-for-email-setup-and-delivery/">Step-by-Step Guide for Email Setup and Delivery</a>
+++									</p>
+++									<p>&nbsp;</p>
+++									<hr>
+++									<p></p>',
+++	
+++	'EXT_NEWS_TUTORIALS_TITLE'  => 'Tutorials',
+++	'EXT_NEWS_TUTORIALS_EXPLAIN'=> '<li><p>Templates</p>
+++					<ul>
+++					<li><a href="http://htmlemailboilerplate.com/" target="_blank"><strong>HTML Email Boilerplate</strong></a>: A great <strong>starting point</strong> for coding emails.</li>
+++					<li><a href="http://www.campaignmonitor.com/templates/" target="_blank"><strong>Campaign Monitor Templates</strong></a>: Template builder + free downloadable templates</li>
+++					</ul>
+++					</li>
+++					
+++					<li><p>Tutorials &amp; Guides</p>
+++
+++					<ul>
+++					<li><a href="http://kb.mailchimp.com/article/how-to-code-html-emails" target="_blank"><strong>How To Code HTML Emails (Mailchimp)</strong></a>: How HTML email works, basic concepts, best practices, tips and tricks</li>
+++					<li><a href="http://www.smashingmagazine.com/2010/01/19/design-and-build-an-email-newsletter-without-losing-your-mind/" target="_blank"><strong>Design and Build Email Newsletters Without Losing Your Mind (and Soul)</strong></a>:  information you need to plan, design and build an HTML newsletter that renders well</li>
+++					<li><a href="http://mailchimp.com/resources/guides/email-marketing-field-guide/html/" target="_blank"><strong>Email Marketing Field Guide (Mailchimp)</strong></a></li>
+++					<li><a href="http://mattmedia.net/2007/08/23/8-html-email-tips-i-wish-i-knew-sooner/" target="_blank"><strong>8 HTML Email Tips I Wish I’d Known Sooner</strong></a></li>
+++					<li><a href="http://www.campaignmonitor.com/css/" target="_blank"><strong>The Ultimate Guide</a>: From Campaign Monitor</strong></li>
+++					<li><a href="http://css-tricks.com/using-css-in-html-emails-the-real-story/" target="_blank"><strong>CSS Tricks: Using CSS in HTML Emails</strong></a>: Some "I told you so"\'s and tips about HTML emails and CSS.</li>
+++					</ul>
+++					</li>
+++					
+++					<li><p>Testing</p>
+++
+++					<ul>
+++					<li><a href="http://www.emailonacid.com/" target="_blank"><strong>Email on Acid</strong></a>: Free and paid testing</li>
+++					<li><a href="http://litmus.com/" target="_blank"><strong>Litmus</strong></a></li>
+++					</ul>
+++					</li>
+++					
+++					<li><p>Other Resources</p>
+++
+++					<ul>
+++					<li><a href="http://www.campaignmonitor.com/resources/will-it-work/email-clients/" target="_blank"><strong>Campaign Monitor\'s Popular E-Mail Clients</strong></a></li>
+++					</ul>
+++					</li>',
+++	
+++	
+++	'NEWSLETTER_NOTICE'			=> '<div class="phpinfo"><p>The settings for this extension are under <strong>%1$s &#187; %2$s &#187; %3$s</strong>. <br />Please note, at first setup when the period is set (for example weekly) and the format (HTML) the first automatic newsletter overview is sent out immediately right after the settings are saved! <br />This is needed to start the Synchronization. With this in mind, consider using a test board before using the extension to make sure the end result of the newlsetter is the preferred look.</p></div>',
+++	'SS_HELPER_NOTY'			=> 'SiteSplat BBcore does not exist!<br />Download the <a href="https://sitesplat.com" target="_blank">BBcore</a> and copy the BBcore folder into your sitesplat extension folder.',
+++));
+++
+++// Description of Donations extension
+++$lang = array_merge($lang, array(
+++	'DESCRIPTION_PAGE'		=> 'Description',
+++	'DESCRIPTION_NOTICE'	=> 'Extension note',
+++	'ext_details' => array(
+++		'details' => array(
+++			'DESCRIPTION_1'	=> 'HTML newsletter',
+++			'DESCRIPTION_2'	=> 'Groupselect',
+++			'DESCRIPTION_3'	=> 'Weekly / monthly news overview',
+++			'DESCRIPTION_4'	=> 'Send immediately or in batch',
+++			'DESCRIPTION_5'	=> 'Overview subscribers',
+++		),
+++		'note' => array(
+++			'NOTICE_1'		=> '<a href="https://github.com/ForumHulp/htmlemail" target="_blank">HTML email extension</a> is needed to enable the HTML settings.',
+++			'NOTICE_2'		=> 'phpBB 3.2 ready'
+++		)
+++	)
+++));
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/language/pt_preao/newsletter.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/language/pt_preao/newsletter.php"
++new file mode 100644
++index 000000000..02aa2312c
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/language/pt_preao/newsletter.php"
++@@ -0,0 +1,40 @@
+++<?php
+++/**
+++*
+++* @package BBnewsletter
+++* @copyright (c) 2016 SiteSplat All rights reserved
+++* @license Proprietary
+++*
+++*/
+++
+++if (!defined('IN_PHPBB'))
+++{
+++	exit;
+++}
+++
+++if (empty($lang) || !is_array($lang))
+++{
+++	$lang = array();
+++}
+++
+++$lang = array_merge($lang, array(
+++	'NEWSLETTER'				=> 'Newsletter',
+++	'OVERVIEW'					=> 'Welcome to our Newsletter! :-) On this page you will find the latest Newsletters as well as the past years archives.',
+++
+++	'SUBSCRIBE_NO'				=> 'I do NOT want to receive the Newsletter anymore',
+++	'SUBSCRIBE_YES'				=> 'Yes I want to receive the Newsletter',
+++	'SUBSCRIBE_BTN_NO'			=> 'Cancel',
+++	'SUBSCRIBE_BTN_YES'			=> 'Subscribe',
+++	'SUBSCRIBE_CONFIRM_NO'		=> 'Please submit to cancel your subscription',
+++	'SUBSCRIBE_CONFIRM_YES'		=> 'Please submit to confirm your subscription',
+++
+++	'SUBSCRIBE_Y_EMAIL'			=> 'Your email',
+++	'SUBSCRIBE'					=> 'Subscribe to',
+++	'UNSUBSCRIBE'				=> 'Unsubscribe from',
+++	'SUBSCRIBE_INFO'			=> 'Our newsletter. Unsubscribed members won\'t receive our periodic News overview anymore.',
+++	
+++	'OVERVIEW_ARCHIVE'			=> 'Archive',
+++	'ARCHIVES'					=> 'Archives',
+++	'SUBSCRIBED'				=> 'Thanks for subscribing! You will receive our newsletter from today on!',
+++	'UNSUBSCRIBED'				=> 'Successfully unsubscribed, you won\'t receive our newsletter any longer'
+++));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\newsletter/styles/FLATBOOTS/template/newsletter.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/styles/FLATBOOTS/template/newsletter.html"
++index 8d096242e..cf9b91e86 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\newsletter/styles/FLATBOOTS/template/newsletter.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/styles/FLATBOOTS/template/newsletter.html"
++@@ -2,91 +2,97 @@
++ <!-- INCLUDECSS @sitesplat_newsletter/css/newsletter.css -->
++ <!-- INCLUDE overall_header.html -->
++ <!-- ENDIF -->
++- 
++-<!-- IF not S_MAIL_VIEW -->	
++-<div class="side-segment"><h3>{L_NEWSLETTER}</h3></div>
+++
+++<!-- IF not S_MAIL_VIEW -->
+++<div class="side-segment">
+++	<h3>{L_NEWSLETTER}</h3>
+++</div>
++ <div class="row">
++ 	<div class="col-md-8">
++-	 <div class="panel panel-default">
++-	   <div class="panel-body">
++-        <p>{L_OVERVIEW}</p>
++-        <ul class="mailrow list-unstyled">
++-			<!-- BEGIN mailrow -->
++-			<li><a href="{mailrow.U_VIEW}" data-src="{mailrow.U_VIEW}" data-remote="false" data-toggle="modal" data-target=".modal-news" class="btn btn-default btn-xs modal-news-btn"><i class="fa fa-envelope"></i>&nbsp;{mailrow.SUBJECT}&nbsp;&#45;&nbsp;{mailrow.TIME}</a></li>
++-			<!-- END mailrow -->
++-        </ul>
++-		
++-		<!-- IF S_ARCHIVES --> 
++-          <p><strong>{L_ARCHIEVES}{L_COLON}</strong></p>
++-			<!-- BEGIN archiverow -->
++-				<!-- IF archiverow.S_ROW_COUNT > 0 -->                       
++-				  <a class="inline" data-toggle="collapse" href="#month_{archiverow.S_ROW_COUNT}"><i id="month_image_{archiverow.S_ROW_COUNT}" class="fa <!-- IF archiverow.S_ROW_COUNT >= 0 -->fa-bar-chart-o"<!-- ELSE -->fa-bar-chart"<!-- ENDIF -->></i>&nbsp;{archiverow.ARCHIVE}</a>
++-				   <br />
++-					<div id="month_{archiverow.S_ROW_COUNT}" class="collapse">
++-					 <p>{archiverow.ARCHIVE} {L_OVERVIEW_ARCHIVE} </p>
++-						<ul class="mailrow list-unstyled">
+++		<div class="panel panel-default">
+++			<div class="panel-body">
+++				<p>{L_OVERVIEW}</p>
+++				<ul class="mailrow list-unstyled">
+++					<!-- BEGIN mailrow -->
+++					<li><a href="{mailrow.U_VIEW}" data-src="{mailrow.U_VIEW}" data-remote="false" data-toggle="modal" data-target=".modal-news" class="btn btn-default btn-xs modal-news-btn"><i class="fa fa-envelope"></i>&nbsp;{mailrow.SUBJECT}&nbsp;&#45;&nbsp;{mailrow.TIME}</a></li>
+++					<!-- END mailrow -->
+++				</ul>
+++
+++				<!-- IF S_ARCHIVES -->
+++				<p><strong>{L_ARCHIVES}{L_COLON}</strong></p>
+++				<!-- BEGIN archiverow -->
+++				<!-- IF archiverow.S_ROW_COUNT > 0 -->
+++				<a class="inline" data-toggle="collapse" href="#month_{archiverow.S_ROW_COUNT}"><i id="month_image_{archiverow.S_ROW_COUNT}" class="fa <!-- IF archiverow.S_ROW_COUNT >= 0 -->fa-bar-chart-o" <!-- ELSE -->fa-bar-chart"<!-- ENDIF -->></i>&nbsp;{archiverow.ARCHIVE}</a>
+++				<br />
+++				<div id="month_{archiverow.S_ROW_COUNT}" class="collapse">
+++					<p>{archiverow.ARCHIVE} {L_OVERVIEW_ARCHIVE} </p>
+++					<ul class="mailrow list-unstyled">
++ 						<!-- BEGIN monthrow -->
++-						 <li><a href="index.html?letter={archiverow.monthrow.U_VIEW}" data-src="index.html?letter={archiverow.monthrow.U_VIEW}" data-remote="false" data-toggle="modal" data-target=".modal-arch" class="btn btn-default btn-xs modal-arch-btn"><i class="fa fa-envelope"></i>&nbsp;{archiverow.monthrow.TITLE}&nbsp;&#45;&nbsp;{archiverow.monthrow.DATE}</a></li>
+++						<li><a href="index.html?letter={archiverow.monthrow.U_VIEW}" data-src="index.html?letter={archiverow.monthrow.U_VIEW}" data-remote="false" data-toggle="modal" data-target=".modal-arch" class="btn btn-default btn-xs modal-arch-btn"><i class="fa fa-envelope"></i>&nbsp;{archiverow.monthrow.TITLE}&nbsp;&#45;&nbsp;{archiverow.monthrow.DATE}</a></li>
++ 						<!-- END monthrow -->
++-						</ul>
++-					</div>
+++					</ul>
+++				</div>
+++				<!-- ENDIF -->
+++				<!-- END archiverow -->
++ 				<!-- ENDIF -->
++-			<!-- END archiverow -->
++-        <!-- ENDIF -->
++-		
++-		</div> 
++-	  </div>	
++-	</div>	
++-	
+++
+++			</div>
+++		</div>
+++	</div>
+++
++ 	<div class="col-md-4">
++-    <div class="panel panel-default panel-body">
++-		<!-- IF PASS -->
+++		<div class="panel panel-default panel-body">
+++			<!-- IF PASS -->
++ 			<form id="postform" method="post" action="index.html">
++-			    <fieldset>
++-				 <label class="control-label" for="pass">{L_PASSWORD}{L_COLON}</label>
++-                    <div class="input-subscribe"> 					
++-					 <input class="form-control" type="password" name="password" id="password" size="25" maxlength="100" value="{PASSWORD}">
++-					</div>  
++-					  <input type="hidden" name="username" value="{UNAME}">
++-					  <input type="hidden" name="email" value="{UEMAIL}">
++-					  <input type="hidden" name="action" value="<!-- IF DEREGISTER -->de<!-- ENDIF -->register">
+++				<fieldset>
+++					<label class="control-label" for="pass">{L_PASSWORD}{L_COLON}</label>
+++					<div class="input-subscribe">
+++						<input class="form-control" type="password" name="password" id="password" size="25" maxlength="100" value="{PASSWORD}">
+++					</div>
+++					<input type="hidden" name="username" value="{UNAME}">
+++					<input type="hidden" name="email" value="{UEMAIL}">
+++					<input type="hidden" name="action" value="<!-- IF DEREGISTER -->de<!-- ENDIF -->register">
++ 					<button type="submit" tabindex="9" name="submit" value="{L_SUBMIT}" class="btn btn-success btn-block" data-loading-text="{L_LOADING}&nbsp;<i class='fa-spin fa fa-spinner fa-lg icon-white'></i>"><i class="fa fa-send"></i> {L_SUBMIT}</button>
++ 				</fieldset>
++ 			</form>
++-			<!-- ELSEIF BEDANKT -->
++-			  <div class="alert alert-success">{BEDANKT}<meta http-equiv="refresh" content="5; URL=index.html" /></div>
+++			<!-- ELSEIF THANKS -->
+++			<div class="alert alert-success">{THANKS}
+++				<meta http-equiv="refresh" content="5; URL=index.html" />
+++			</div>
++ 			<!-- ELSE -->
++-            <div class="alert alert-info">
++-			 <p><!-- IF DEREGISTER -->{L_SUBSCRIBE_NO}<!-- ELSE -->{L_SUBSCRIBE_YES}<!-- ENDIF --></p>
++-			 <p>**<!-- IF DEREGISTER -->{L_SUBSCRIBE_CONFIRM_NO}<!-- ELSE -->{L_SUBSCRIBE_CONFIRM_YES}<!-- ENDIF --></p>
+++			<div class="alert alert-info">
+++				<p><!-- IF DEREGISTER -->{L_SUBSCRIBE_NO}<!-- ELSE -->{L_SUBSCRIBE_YES}<!-- ENDIF --></p>
+++				<p>**<!-- IF DEREGISTER -->{L_SUBSCRIBE_CONFIRM_NO}<!-- ELSE -->{L_SUBSCRIBE_CONFIRM_YES}<!-- ENDIF --></p>
++ 			</div>
++ 			{ERROR_MSG}
++ 			<form id="postform" method="post" action="index.html">
++-			<fieldset>
++-		 <!-- <input type="text" class="form-control" name="username" id="username" size="25" value="{USERNAME}" title="{L_USERNAME}"> -->
++-			 <div class="input-subscribe"> 
++-			  <label for="email" class="">{L_SUBSCRIBE_Y_EMAIL}</label>
++-			  <input type="text" class="form-control" name="email" id="email" size="25" maxlength="100" value="{EMAIL}" disabled> 
++-			 </div>
++-			  <button type="submit" tabindex="9" name="submit" value="{L_SUBMIT}" class="btn btn-success btn-block" data-loading-text="{L_LOADING}&nbsp;<i class='fa-spin fa fa-spinner fa-lg icon-white'></i>"><i class="fa fa-send"></i>&nbsp;<!-- IF DEREGISTER -->{L_SUBSCRIBE_BTN_NO}<!-- ELSE -->{L_SUBSCRIBE_BTN_YES}<!-- ENDIF --></button>
++-			  <input type="hidden" name="action" value="<!-- IF DEREGISTER -->de<!-- ENDIF -->register" />
++-			  {S_FORM_TOKEN}
++-			</fieldset>
+++				<fieldset>
+++					<!-- <input type="text" class="form-control" name="username" id="username" size="25" value="{USERNAME}" title="{L_USERNAME}"> -->
+++					<div class="input-subscribe">
+++						<label for="email" class="">{L_SUBSCRIBE_Y_EMAIL}</label>
+++						<input type="text" class="form-control" name="email" id="email" size="25" maxlength="100" value="{EMAIL}" disabled>
+++					</div>
+++					<button type="submit" tabindex="9" name="submit" value="{L_SUBMIT}" class="btn btn-success btn-block" data-loading-text="{L_LOADING}&nbsp;<i class='fa-spin fa fa-spinner fa-lg icon-white'></i>"><i class="fa fa-send"></i>&nbsp;<!-- IF DEREGISTER -->{L_SUBSCRIBE_BTN_NO}<!-- ELSE -->{L_SUBSCRIBE_BTN_YES}<!-- ENDIF --></button>
+++					<input type="hidden" name="action" value="<!-- IF DEREGISTER -->de<!-- ENDIF -->register" />
+++					{S_FORM_TOKEN}
+++				</fieldset>
++ 			</form>
++-		<!-- ENDIF -->
+++			<!-- ENDIF -->
+++		</div>
++ 	</div>
++-    </div>
++-</div>	
++-<!-- ENDIF -->	
+++</div>
+++<!-- ENDIF -->
++ 
++-    <!-- IF S_MAIL_VIEW -->
++-        <div class="wrap-email">
++-             <div class="pull-left"><h3><a>{MAIL_SUBJECT}</a></h3></div>
++-			 <div class="pull-right">{MAIL_DATE}</div>
++-			  <div class="space10"></div>
++-             <div class="clearfix">{MAIL_MESSAGE}</div>
++-        </div>
++-    <!-- ENDIF -->
+++<!-- IF S_MAIL_VIEW -->
+++<div class="wrap-email">
+++	<div class="pull-left">
+++		<h3><a>{MAIL_SUBJECT}</a></h3>
+++	</div>
+++	<div class="pull-right">{MAIL_DATE}</div>
+++	<div class="space10"></div>
+++	<div class="clearfix">{MAIL_MESSAGE}</div>
+++</div>
+++<!-- ENDIF -->
++ 
++ <!-- IF not S_MAIL_VIEW -->
++ <!-- INCLUDEJS @sitesplat_newsletter/js/newsletter.js -->
++@@ -98,9 +104,9 @@
++ 				<h4 class="modal-title" id="myModalLabel">{L_NEWSLETTER}</h4>
++ 			</div>
++ 			<div class="modal-body">
++-			<div class="embed-responsive embed-responsive-16by9">
++-               <iframe class="embed-responsive-item" src="#"></iframe>
++-			</div>	
+++				<div class="embed-responsive embed-resp
\ No newline at end of file
diff --git "[ORIGINAL]/sitesplat\\newsletter/helper/helper.php" "[FORUM_EXT]/sitesplat\\newsletter/helper/helper.php"
--- "[ORIGINAL]/sitesplat\\newsletter/helper/helper.php"
+++ "[FORUM_EXT]/sitesplat\\newsletter/helper/helper.php"
@@ -136,7 +136,7 @@ class helper
 			$messenger->headers('X-AntiAbuse: Username - ' . $this->user->data['username']);
 			$messenger->headers('X-AntiAbuse: User IP - ' . $this->user->ip);
 			$messenger->assign_vars(array(
-				'SITE_LOGO_IMG'		=> $server_url . '/ext/sitesplat/newsletter/vendor/assets/images/github-logo.png',
+				'SITE_LOGO_IMG'		=> $server_url . '/ext/sitesplat/newsletter/vendor/assets/images/gold-logo.png',
 				'BOARD_URL'			=> $server_url,
 				'NEWSLETTER_ONLINE'	=> preg_replace("/$this->php_ext(&amp;|&)+?/", "$this->php_ext?", preg_replace('/(\?)?(&amp;|&)?sid=[a-z0-9]+/', '', 
 									   $this->helper->route('sitesplat_newsletter_main_controller', array('route' => 'index.html'), true, '', UrlGeneratorInterface::ABSOLUTE_URL))),
diff --git "[ORIGINAL]/sitesplat\\newsletter/language/en/email/newsletter_html.txt" "[FORUM_EXT]/sitesplat\\newsletter/language/en/email/newsletter_html.txt"
--- "[ORIGINAL]/sitesplat\\newsletter/language/en/email/newsletter_html.txt"
+++ "[FORUM_EXT]/sitesplat\\newsletter/language/en/email/newsletter_html.txt"
@@ -1,8 +1,290 @@
-Subject: Newsletter from "{SITENAME}"
+<!DOCTYPE html>
+<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
+
+<head>
+  <meta charset="utf-8"> <!-- utf-8 works for most cases -->
+  <meta name="viewport" content="width=device-width"> <!-- Forcing initial-scale shouldn't be necessary -->
+  <meta http-equiv="X-UA-Compatible" content="IE=edge"> <!-- Use the latest (edge) version of IE rendering engine -->
+  <meta name="x-apple-disable-message-reformatting"> <!-- Disable auto-scale in iOS 10 Mail entirely -->
+
+  <!-- Web Font / @font-face : BEGIN -->
+  <!-- NOTE: If web fonts are not required, lines 10 - 27 can be safely removed. -->
+
+  <!-- Desktop Outlook chokes on web font references and defaults to Times New Roman, so we force a safe fallback font. -->
+  <!--[if mso]>
+        <style>
+            * {
+                font-family: sans-serif !important;
+            }
+        </style>
+    <![endif]-->
+
+  <!-- All other clients get the webfont reference; some will render the font and others will silently fail to the fallbacks. More on that here: http://stylecampaign.com/blog/2015/02/webfont-support-in-email/ -->
+  <!--[if !mso]><!-->
+  <!-- insert web font reference, eg: <link href='https://fonts.googleapis.com/css?family=Roboto:400,700' rel='stylesheet' type='text/css'> -->
+  <!--<![endif]-->
+
+  <!-- Web Font / @font-face : END -->
+
+  <!-- CSS Reset : BEGIN -->
+  <style>
+    /* What it does: Remove spaces around the email design added by some email clients. */
+    /* Beware: It can remove the padding / margin and add a background color to the compose a reply window. */
+    html,
+    body {
+      margin: 0 auto !important;
+      padding: 0 !important;
+      height: 100% !important;
+      width: 100% !important;
+    }
+
+    /* What it does: Stops email clients resizing small text. */
+    * {
+      -ms-text-size-adjust: 100%;
+      -webkit-text-size-adjust: 100%;
+    }
+
+    /* What it does: Centers email on Android 4.4 */
+    div[style*="margin: 16px 0"] {
+      margin: 0 !important;
+    }
+
+    /* What it does: Stops Outlook from adding extra spacing to tables. */
+    table,
+    td {
+      mso-table-lspace: 0pt !important;
+      mso-table-rspace: 0pt !important;
+    }
+
+    /* What it does: Fixes webkit padding issue. Fix for Yahoo mail table alignment bug. Applies table-layout to the first 2 tables then removes for anything nested deeper. */
+    table {
+      border-spacing: 0 !important;
+      border-collapse: collapse !important;
+      table-layout: fixed !important;
+      margin: 0 auto !important;
+    }
+
+    table table table {
+      table-layout: auto;
+    }
+
+    /* What it does: Uses a better rendering method when resizing images in IE. */
+    img {
+      -ms-interpolation-mode: bicubic;
+    }
+
+    /* What it does: A work-around for email clients meddling in triggered links. */
+    *[x-apple-data-detectors],
+    /* iOS */
+    .x-gmail-data-detectors,
+    /* Gmail */
+    .x-gmail-data-detectors *,
+    .aBn {
+      border-bottom: 0 !important;
+      cursor: default !important;
+      color: inherit !important;
+      text-decoration: none !important;
+      font-size: inherit !important;
+      font-family: inherit !important;
+      font-weight: inherit !important;
+      line-height: inherit !important;
+    }
+
+    /* What it does: Prevents Gmail from displaying an download button on large, non-linked images. */
+    .a6S {
+      display: none !important;
+      opacity: 0.01 !important;
+    }
+
+    /* If the above doesn't work, add a .g-img class to any image in question. */
+    img.g-img+div {
+      display: none !important;
+    }
+
+    /* What it does: Prevents underlining the button text in Windows 10 */
+    .button-link {
+      text-decoration: none !important;
+    }
+
+    /* What it does: Removes right gutter in Gmail iOS app: https://github.com/TedGoas/Cerberus/issues/89  */
+    /* Create one of these media queries for each additional viewport size you'd like to fix */
+    /* Thanks to Eric Lepetit (@ericlepetitsf) for help troubleshooting */
+    @media only screen and (min-device-width: 375px) and (max-device-width: 413px) {
+
+      /* iPhone 6 and 6+ */
+      .email-container {
+        min-width: 375px !important;
+      }
+    }
+
+    @media screen and (max-width: 480px) {
+
+      /* What it does: Forces Gmail app to display email full width */
+      u~div .email-container {
+        min-width: 100vw;
+        width: 100% !important;
+      }
+    }
+  </style>
+  <!-- CSS Reset : END -->
+
+  <!-- Progressive Enhancements : BEGIN -->
+  <style>
+    /* What it does: Hover styles for buttons */
+    .button-td,
+    .button-a {
+      transition: all 100ms ease-in;
+    }
+
+    .button-td:hover,
+    .button-a:hover {
+      background: #CC9900 !important;
+      border-color: #CC9900 !important;
+    }
+
+    /* Define o estilo dos links */
+    a:link {
+      color: #CC9900;
+      background-color: transparent;
+      text-decoration: none;
+    }
+
+    a:visited {
+      color: #CC9900;
+      background-color: transparent;
+      text-decoration: none;
+    }
+
+    a:hover {
+      color: #CC9900;
+      background-color: transparent;
+      text-decoration: underline;
+    }
+
+    a:active {
+      color: #CC9900;
+      background-color: transparent;
+      text-decoration: underline;
+    }
+
+    /* Media Queries */
+    @media screen and (max-width: 600px) {
+
+      .email-container {
+        width: 100% !important;
+        margin: auto !important;
+      }
+
+      /* What it does: Forces elements to resize to the full width of their container. Useful for resizing images beyond their max-width. */
+      .fluid {
+        max-width: 100% !important;
+        height: auto !important;
+        margin-left: auto !important;
+        margin-right: auto !important;
+      }
+
+      /* What it does: Forces table cells into full-width rows. */
+      .stack-column,
+      .stack-column-center {
+        display: block !important;
+        width: 100% !important;
+        max-width: 100% !important;
+        direction: ltr !important;
+      }
+
+      /* And center justify these ones. */
+      .stack-column-center {
+        text-align: center !important;
+      }
+
+      /* What it does: Generic utility class for centering. Useful for images, buttons, and nested tables. */
+      .center-on-narrow {
+        text-align: center !important;
+        display: block !important;
+        margin-left: auto !important;
+        margin-right: auto !important;
+        float: none !important;
+      }
+
+      table.center-on-narrow {
+        display: inline-block !important;
+      }
+
+      /* What it does: Adjust typography on small screens to improve readability */
+      .email-container p {
+        font-size: 17px !important;
+      }
+    }
+  </style>
+  <!-- Progressive Enhancements : END -->
+
+  <!-- What it does: Makes background images in 72ppi Outlook render at correct size. -->
+  <!--[if gte mso 9]>
+    <xml>
+        <o:OfficeDocumentSettings>
+            <o:AllowPNG/>
+            <o:PixelsPerInch>96</o:PixelsPerInch>
+        </o:OfficeDocumentSettings>
+    </xml>
+    <![endif]-->
+
+</head>
+
+<body width="100%" bgcolor="#222222" style="margin: 0; mso-line-height-rule: exactly;">
+  <center style="width: 100%; background: #fafafa; text-align: left;">
+
+    <!-- Email Header : BEGIN -->
+    <table role="presentation" cellspacing="0" cellpadding="0" border="0" align="center" width="600" style="margin: auto;" class="email-container" bgcolor="#1E1E1E">
+      <tr>
+        <td style="padding: 20px 0; text-align: center">
+          <a href="https://goldtuganime.com" target="_blank"><img src="https://upload.goldtuganime.com/redes-sociais/GTA_Logo_Newsletter.png" width="282" border="0" style="height: auto; font-family: sans-serif; font-size: 15px; line-height: 140%; color: #555555;"></a>
+        </td>
+      </tr>
+    </table>
+    <!-- Email Header : END -->
 
     {MESSAGE}
 
-<p>
-   <a href="{NEWSLETTER_ONLINE}">All newsletter online</a>
-   <p>Don't want to receive our newsletter anymore? Unsubscribe <a href="{NEWSLETTER_OPTOUT}">here</a></p>
-</p>
\ No newline at end of file
+    <!-- Email Footer : BEGIN -->
+    <table role="presentation" bgcolor="#1E1E1E" cellspacing="0" cellpadding="0" border="0" align="center" width="100%" style="max-width: 600px; font-family: sans-serif; color: #888888; font-size: 11px; line-height: 140%;">
+      <tr>
+        <td style="padding: 10px 10px; width: 100%; font-family: sans-serif; font-size: 12px; line-height: 140%; text-align: center; color: #888888;" class="x-gmail-data-detectors">
+          <table width="300" border="0" cellspacing="10" cellpadding="10">
+            <tbody>
+              <tr>
+                <td><a href="https://www.facebook.com/goldtuganimeoficial/" target="_blank"><img src="https://upload.goldtuganime.com/redes-sociais/facebook-Y.png" height="24" width="24" class=""></a></td>
+                <td><a href="https://www.instagram.com/goldtuganime/" target="_blank"><img src="https://upload.goldtuganime.com/redes-sociais/instagram-Y.png" height="24" width="24" class=""></a></td>
+                <td><a href="https://discord.gg/Zk8CCZUG/" target="_blank"><img src="https://upload.goldtuganime.com/redes-sociais/discord-Y.png" height="24" width="24" class=""></a></td>
+                <td><a href="https://www.youtube.com/@GoldTugAnimeOFICIAL" target="_blank"><img src="https://upload.goldtuganime.com/redes-sociais/youtube-Y.png" height="24" width="24" class=""></a></td>
+                <td><a href="https://goldtuganime.com" target="_blank"><img src="https://upload.goldtuganime.com/redes-sociais/website-Y.png" height="24" width="24" class=""></a></td>
+              </tr>
+            </tbody>
+          </table>
+        </td>
+      </tr>
+    </table>
+    <table role="presentation" cellspacing="0" cellpadding="0" border="0" align="center" width="100%" style="max-width: 600px; font-family: sans-serif; color: #888888; font-size: 11px; line-height: 140%;">
+      <tr>
+        <td style="padding: 10px 10px; width: 100%; font-family: sans-serif; font-size: 12px; line-height: 140%; text-align: center; color: #888888;" class="x-gmail-data-detectors"><em>Copyright © 2023 | <a href="https://goldtuganime.com" target="_blank">GoldTugAnime</a> | Todos os direitos reservados.</em></td>
+      </tr>
+      <tr>
+        <td>
+          <table width="400" border="0" cellspacing="0" cellpadding="0">
+            <tbody>
+              <tr>
+                <td width="400" height="2" bgcolor="#CC9900" align="center" valign="bottom" style="padding: 0px;"></td>
+              </tr>
+            </tbody>
+          </table>
+        </td>
+      </tr>
+      <tr>
+        <td style="padding: 10px 10px; width: 100%; font-family: sans-serif; font-size: 8px; line-height: 140%; text-align: center; color: #888888;" class="x-gmail-data-detectors">You are receiving this e-mail because you have a subscription in our forum. <a href="{NEWSLETTER_ONLINE}" target="_blank">check here</a> what newsletters you received or remove your e-mail address from our list through the link <a href="{NEWSLETTER_OPTOUT}" target="_blank">remove subscription</a>, in case you want to.
+        </td>
+      </tr>
+    </table>
+    <!-- Email Footer : END -->
+  </center>
+</body>
+
+</html>
\ No newline at end of file
diff --git "[ORIGINAL]/sitesplat\\newsletter/language/en/info_acp_newsletter.php" "[FORUM_EXT]/sitesplat\\newsletter/language/en/info_acp_newsletter.php"
--- "[ORIGINAL]/sitesplat\\newsletter/language/en/info_acp_newsletter.php"
+++ "[FORUM_EXT]/sitesplat\\newsletter/language/en/info_acp_newsletter.php"
@@ -25,7 +25,7 @@ $lang = array_merge($lang, array(
 	'SEND_IMMEDIATELY'			=> 'Send immediately',
 	'SEND_IMMEDIATELY_EXPLAIN'	=> 'Attempt to send the emails immediately. This depends on the server email configuration parameters',
 	'PERIOD'					=> 'Email Overview (or Catch-up) Period',
-	'PERIOD_EXPLAIN'			=> 'This will send autmatic "Catch-up"  emails to the users that are subscribed. The e-mail will be generated based on the new topics in the forum. The user will receive an email with the purpose of engaging the user\'s interest in the recent board\'s activity. Edit the templates file named newsletter_html.txt for the HTML version and newsletter_txt.txt for the TXT version from:<br /> <code>root\ext\sitesplat\newsletter\language\en\email\</code> <br /> To learn how to send out professional looking HTML emails check out the tutorials over at <a href=" https://sitesplat.com/" target="_blank">sitesplat.com</a> or click the "Tutorials" label above.',
+	'PERIOD_EXPLAIN'			=> 'This will send automatic "Catch-up"  emails to the users that are subscribed. The e-mail will be generated based on the new topics in the forum. The user will receive an email with the purpose of engaging the user\'s interest in the recent board\'s activity. Edit the templates file named newsletter_html.txt for the HTML version and newsletter_txt.txt for the TXT version from:<br /> <code>root\ext\sitesplat\newsletter\language\en\email\</code> <br /> To learn how to send out professional looking HTML emails check out the tutorials over at <a href=" https://sitesplat.com/" target="_blank">sitesplat.com</a> or click the "Tutorials" label above.',
 	'WEEKLY'					=> 'Weekly',
 	'MONTHLY'					=> 'Monthly',
 	'NO_OVERVIEW'				=> 'None',
diff --git "[ORIGINAL]/sitesplat\\newsletter/language/en/newsletter.php" "[FORUM_EXT]/sitesplat\\newsletter/language/en/newsletter.php"
--- "[ORIGINAL]/sitesplat\\newsletter/language/en/newsletter.php"
+++ "[FORUM_EXT]/sitesplat\\newsletter/language/en/newsletter.php"
@@ -34,7 +34,7 @@ $lang = array_merge($lang, array(
 	'SUBSCRIBE_INFO'			=> 'Our newsletter. Unsubscribed members won\'t receive our periodic News overview anymore.',
 	
 	'OVERVIEW_ARCHIVE'			=> 'Archive',
-	'ARCHIEVES'					=> 'Archives',
+	'ARCHIVES'					=> 'Archives',
 	'SUBSCRIBED'				=> 'Thanks for subscribing! You will receive our newsletter from today on!',
 	'UNSUBSCRIBED'				=> 'Successfully unsubscribed, you won\'t receive our newsletter any longer'
 ));
diff --git "[FORUM_EXT]/sitesplat\\newsletter/language/pt/email/index.htm" "[FORUM_EXT]/sitesplat\\newsletter/language/pt/email/index.htm"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\newsletter/language/pt/email/index.htm"
@@ -0,0 +1,10 @@
+<html>
+<head>
+<title></title>
+<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
+</head>
+
+<body bgcolor="#FFFFFF" text="#000000">
+
+</body>
+</html>
diff --git "[FORUM_EXT]/sitesplat\\newsletter/language/pt/email/newsletter_html.txt" "[FORUM_EXT]/sitesplat\\newsletter/language/pt/email/newsletter_html.txt"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\newsletter/language/pt/email/newsletter_html.txt"
@@ -0,0 +1,293 @@
+Subject: {SUBJECT}
+
+<!DOCTYPE html>
+<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
+
+<head>
+  <meta charset="utf-8"> <!-- utf-8 works for most cases -->
+  <meta name="viewport" content="width=device-width"> <!-- Forcing initial-scale shouldn't be necessary -->
+  <meta http-equiv="X-UA-Compatible" content="IE=edge"> <!-- Use the latest (edge) version of IE rendering engine -->
+  <meta name="x-apple-disable-message-reformatting"> <!-- Disable auto-scale in iOS 10 Mail entirely -->
+
+  <!-- Web Font / @font-face : BEGIN -->
+  <!-- NOTE: If web fonts are not required, lines 10 - 27 can be safely removed. -->
+
+  <!-- Desktop Outlook chokes on web font references and defaults to Times New Roman, so we force a safe fallback font. -->
+  <!--[if mso]>
+        <style>
+            * {
+                font-family: sans-serif !important;
+            }
+        </style>
+    <![endif]-->
+
+  <!-- All other clients get the webfont reference; some will render the font and others will silently fail to the fallbacks. More on that here: http://stylecampaign.com/blog/2015/02/webfont-support-in-email/ -->
+  <!--[if !mso]><!-->
+  <!-- insert web font reference, eg: <link href='https://fonts.googleapis.com/css?family=Roboto:400,700' rel='stylesheet' type='text/css'> -->
+  <!--<![endif]-->
+
+  <!-- Web Font / @font-face : END -->
+
+  <!-- CSS Reset : BEGIN -->
+  <style>
+    /* What it does: Remove spaces around the email design added by some email clients. */
+    /* Beware: It can remove the padding / margin and add a background color to the compose a reply window. */
+    html,
+    body {
+      margin: 0 auto !important;
+      padding: 0 !important;
+      height: 100% !important;
+      width: 100% !important;
+    }
+
+    /* What it does: Stops email clients resizing small text. */
+    * {
+      -ms-text-size-adjust: 100%;
+      -webkit-text-size-adjust: 100%;
+    }
+
+    /* What it does: Centers email on Android 4.4 */
+    div[style*="margin: 16px 0"] {
+      margin: 0 !important;
+    }
+
+    /* What it does: Stops Outlook from adding extra spacing to tables. */
+    table,
+    td {
+      mso-table-lspace: 0pt !important;
+      mso-table-rspace: 0pt !important;
+    }
+
+    /* What it does: Fixes webkit padding issue. Fix for Yahoo mail table alignment bug. Applies table-layout to the first 2 tables then removes for anything nested deeper. */
+    table {
+      border-spacing: 0 !important;
+      border-collapse: collapse !important;
+      table-layout: fixed !important;
+      margin: 0 auto !important;
+    }
+
+    table table table {
+      table-layout: auto;
+    }
+
+    /* What it does: Uses a better rendering method when resizing images in IE. */
+    img {
+      -ms-interpolation-mode: bicubic;
+    }
+
+    /* What it does: A work-around for email clients meddling in triggered links. */
+    *[x-apple-data-detectors],
+    /* iOS */
+    .x-gmail-data-detectors,
+    /* Gmail */
+    .x-gmail-data-detectors *,
+    .aBn {
+      border-bottom: 0 !important;
+      cursor: default !important;
+      color: inherit !important;
+      text-decoration: none !important;
+      font-size: inherit !important;
+      font-family: inherit !important;
+      font-weight: inherit !important;
+      line-height: inherit !important;
+    }
+
+    /* What it does: Prevents Gmail from displaying an download button on large, non-linked images. */
+    .a6S {
+      display: none !important;
+      opacity: 0.01 !important;
+    }
+
+    /* If the above doesn't work, add a .g-img class to any image in question. */
+    img.g-img+div {
+      display: none !important;
+    }
+
+    /* What it does: Prevents underlining the button text in Windows 10 */
+    .button-link {
+      text-decoration: none !important;
+    }
+
+    /* What it does: Removes right gutter in Gmail iOS app: https://github.com/TedGoas/Cerberus/issues/89  */
+    /* Create one of these media queries for each additional viewport size you'd like to fix */
+    /* Thanks to Eric Lepetit (@ericlepetitsf) for help troubleshooting */
+    @media only screen and (min-device-width: 375px) and (max-device-width: 413px) {
+
+      /* iPhone 6 and 6+ */
+      .email-container {
+        min-width: 375px !important;
+      }
+    }
+
+    @media screen and (max-width: 480px) {
+
+      /* What it does: Forces Gmail app to display email full width */
+      u~div .email-container {
+        min-width: 100vw;
+        width: 100% !important;
+      }
+    }
+  </style>
+  <!-- CSS Reset : END -->
+
+  <!-- Progressive Enhancements : BEGIN -->
+  <style>
+    /* What it does: Hover styles for buttons */
+    .button-td,
+    .button-a {
+      transition: all 100ms ease-in;
+    }
+
+    .button-td:hover,
+    .button-a:hover {
+      background: #CC9900 !important;
+      border-color: #CC9900 !important;
+    }
+
+    /* Define o estilo dos links */
+    a:link {
+      color: #CC9900;
+      background-color: transparent;
+      text-decoration: none;
+    }
+
+    a:visited {
+      color: #CC9900;
+      background-color: transparent;
+      text-decoration: none;
+    }
+
+    a:hover {
+      color: #CC9900;
+      background-color: transparent;
+      text-decoration: underline;
+    }
+
+    a:active {
+      color: #CC9900;
+      background-color: transparent;
+      text-decoration: underline;
+    }
+
+    /* Media Queries */
+    @media screen and (max-width: 600px) {
+
+      .email-container {
+        width: 100% !important;
+        margin: auto !important;
+      }
+
+      /* What it does: Forces elements to resize to the full width of their container. Useful for resizing images beyond their max-width. */
+      .fluid {
+        max-width: 100% !important;
+        height: auto !important;
+        margin-left: auto !important;
+        margin-right: auto !important;
+      }
+
+      /* What it does: Forces table cells into full-width rows. */
+      .stack-column,
+      .stack-column-center {
+        display: block !important;
+        width: 100% !important;
+        max-width: 100% !important;
+        direction: ltr !important;
+      }
+
+      /* And center justify these ones. */
+      .stack-column-center {
+        text-align: center !important;
+      }
+
+      /* What it does: Generic utility class for centering. Useful for images, buttons, and nested tables. */
+      .center-on-narrow {
+        text-align: center !important;
+        display: block !important;
+        margin-left: auto !important;
+        margin-right: auto !important;
+        float: none !important;
+      }
+
+      table.center-on-narrow {
+        display: inline-block !important;
+      }
+
+      /* What it does: Adjust typography on small screens to improve readability */
+      .email-container p {
+        font-size: 17px !important;
+      }
+    }
+  </style>
+  <!-- Progressive Enhancements : END -->
+
+  <!-- What it does: Makes background images in 72ppi Outlook render at correct size. -->
+  <!--[if gte mso 9]>
+    <xml>
+        <o:OfficeDocumentSettings>
+            <o:AllowPNG/>
+            <o:PixelsPerInch>96</o:PixelsPerInch>
+        </o:OfficeDocumentSettings>
+    </xml>
+    <![endif]-->
+
+</head>
+
+<body width="100%" bgcolor="#222222" style="margin: 0; mso-line-height-rule: exactly;">
+  <center style="width: 100%; background: #fafafa; text-align: left;">
+
+    <!-- Email Header : BEGIN -->
+    <table role="presentation" cellspacing="0" cellpadding="0" border="0" align="center" width="600" style="margin: auto;" class="email-container" bgcolor="#1E1E1E">
+      <tr>
+        <td style="padding: 20px 0; text-align: center">
+          <a href="https://goldtuganime.com" target="_blank"><img src="https://upload.goldtuganime.com/redes-sociais/GTA_Logo_Newsletter.png" width="282" border="0" style="height: auto; font-family: sans-serif; font-size: 15px; line-height: 140%; color: #555555;"></a>
+        </td>
+      </tr>
+    </table>
+    <!-- Email Header : END -->
+
+    {MESSAGE}
+
+    <!-- Email Footer : BEGIN -->
+    <table role="presentation" bgcolor="#1E1E1E" cellspacing="0" cellpadding="0" border="0" align="center" width="100%" style="max-width: 600px; font-family: sans-serif; color: #888888; font-size: 11px; line-height: 140%;">
+      <tr>
+        <td style="padding: 10px 10px; width: 100%; font-family: sans-serif; font-size: 12px; line-height: 140%; text-align: center; color: #888888;" class="x-gmail-data-detectors">
+          <table width="300" border="0" cellspacing="10" cellpadding="10">
+            <tbody>
+              <tr>
+                <td><a href="https://www.facebook.com/goldtuganimeoficial/" target="_blank"><img src="https://upload.goldtuganime.com/redes-sociais/facebook-Y.png" height="24" width="24" class=""></a></td>
+                <td><a href="https://www.instagram.com/goldtuganime/" target="_blank"><img src="https://upload.goldtuganime.com/redes-sociais/instagram-Y.png" height="24" width="24" class=""></a></td>
+                <td><a href="https://discord.gg/Zk8CCZUG/" target="_blank"><img src="https://upload.goldtuganime.com/redes-sociais/discord-Y.png" height="24" width="24" class=""></a></td>
+                <td><a href="https://www.youtube.com/@GoldTugAnimeOFICIAL" target="_blank"><img src="https://upload.goldtuganime.com/redes-sociais/youtube-Y.png" height="24" width="24" class=""></a></td>
+                <td><a href="https://goldtuganime.com" target="_blank"><img src="https://upload.goldtuganime.com/redes-sociais/website-Y.png" height="24" width="24" class=""></a></td>
+              </tr>
+            </tbody>
+          </table>
+
+        </td>
+      </tr>
+    </table>
+    <table role="presentation" cellspacing="0" cellpadding="0" border="0" align="center" width="100%" style="max-width: 600px; font-family: sans-serif; color: #888888; font-size: 11px; line-height: 140%;">
+      <tr>
+        <td style="padding: 10px 10px; width: 100%; font-family: sans-serif; font-size: 12px; line-height: 140%; text-align: center; color: #888888;" class="x-gmail-data-detectors"><em>Copyright © 2023 | <a href="https://goldtuganime.com" target="_blank">GoldTugAnime</a> | Todos os direitos reservados.</em></td>
+      </tr>
+      <tr>
+        <td>
+          <table width="400" border="0" cellspacing="0" cellpadding="0">
+            <tbody>
+              <tr>
+                <td width="400" height="2" bgcolor="#CC9900" align="center" valign="bottom" style="padding: 0px;"></td>
+              </tr>
+            </tbody>
+          </table>
+        </td>
+      </tr>
+      <tr>
+        <td style="padding: 10px 10px; width: 100%; font-family: sans-serif; font-size: 8px; line-height: 140%; text-align: center; color: #888888;" class="x-gmail-data-detectors">Estás a receber este e-mail porque estás inscrito no nosso fórum. <a href="{NEWSLETTER_ONLINE}" target="_blank">Vê aqui</a> que newsletters já recebeste ou remove o teu endereço eletrónico da nossa lista através do link <a href="{NEWSLETTER_OPTOUT}" target="_blank">remover subscrição</a>, caso pretendas.
+        </td>
+      </tr>
+    </table>
+    <!-- Email Footer : END -->
+  </center>
+</body>
+
+</html>
\ No newline at end of file
diff --git "[FORUM_EXT]/sitesplat\\newsletter/language/pt/email/newsletter_txt.txt" "[FORUM_EXT]/sitesplat\\newsletter/language/pt/email/newsletter_txt.txt"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\newsletter/language/pt/email/newsletter_txt.txt"
@@ -0,0 +1,6 @@
+Subject: Newsletter de {SITENAME}
+
+{MESSAGE}
+
+Todas as newsletter: {NEWSLETTER_ONLINE}
+Não desejas continuar a receber a nossa newsletter? Clica aqui: {NEWSLETTER_OPTOUT}
\ No newline at end of file
diff --git "[FORUM_EXT]/sitesplat\\newsletter/language/pt/email/newsoverview_html.txt" "[FORUM_EXT]/sitesplat\\newsletter/language/pt/email/newsoverview_html.txt"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\newsletter/language/pt/email/newsoverview_html.txt"
@@ -0,0 +1,961 @@
+Subject: Últimas Novidades "{SITENAME}"
+
+<html xmlns="http://www.w3.org/1999/xhtml" style="margin: 0;padding: 0;">
+<!--<![endif]-->
+
+<head>
+	<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
+	<!--[if !mso]><!-->
+	<meta content="IE=edge" http-equiv="X-UA-Compatible">
+	<!--<![endif]-->
+	<meta content="width=device-width" name="viewport">
+	<style type="text/css">
+		@media only screen and (min-width: 620px) {
+			* [lang=x-wrapper] h1 {
+				font-size: 26px !important;
+				line-height: 34px !important;
+			}
+			* [lang=x-wrapper] h2 {
+				font-size: 20px !important;
+				line-height: 28px !important;
+			}
+			* div [lang=x-size-8] {
+				font-size: 8px !important;
+				line-height: 14px !important;
+			}
+			* div [lang=x-size-9] {
+				font-size: 9px !important;
+				line-height: 16px !important;
+			}
+			* div [lang=x-size-10] {
+				font-size: 10px !important;
+				line-height: 18px !important;
+			}
+			* div [lang=x-size-11] {
+				font-size: 11px !important;
+				line-height: 19px !important;
+			}
+			* div [lang=x-size-12] {
+				font-size: 12px !important;
+				line-height: 19px !important;
+			}
+			* div [lang=x-size-13] {
+				font-size: 13px !important;
+				line-height: 21px !important;
+			}
+			* div [lang=x-size-14] {
+				font-size: 14px !important;
+				line-height: 21px !important;
+			}
+			* div [lang=x-size-15] {
+				font-size: 15px !important;
+				line-height: 23px !important;
+			}
+			* div [lang=x-size-16] {
+				font-size: 16px !important;
+				line-height: 24px !important;
+			}
+			* div [lang=x-size-17] {
+				font-size: 17px !important;
+				line-height: 26px !important;
+			}
+			* div [lang=x-size-18] {
+				font-size: 18px !important;
+				line-height: 26px !important;
+			}
+			* div [lang=x-size-18] {
+				font-size: 18px !important;
+				line-height: 26px !important;
+			}
+			* div [lang=x-size-20] {
+				font-size: 20px !important;
+				line-height: 28px !important;
+			}
+			* div [lang=x-size-22] {
+				font-size: 22px !important;
+				line-height: 31px !important;
+			}
+			* div [lang=x-size-24] {
+				font-size: 24px !important;
+				line-height: 32px !important;
+			}
+			* div [lang=x-size-26] {
+				font-size: 26px !important;
+				line-height: 34px !important;
+			}
+			* div [lang=x-size-28] {
+				font-size: 28px !important;
+				line-height: 36px !important;
+			}
+			* div [lang=x-size-30] {
+				font-size: 30px !important;
+				line-height: 38px !important;
+			}
+			* div [lang=x-size-32] {
+				font-size: 32px !important;
+				line-height: 40px !important;
+			}
+			* div [lang=x-size-34] {
+				font-size: 34px !important;
+				line-height: 43px !important;
+			}
+			* div [lang=x-size-36] {
+				font-size: 36px !important;
+				line-height: 43px !important;
+			}
+			* div [lang=x-size-40] {
+				font-size: 40px !important;
+				line-height: 47px !important;
+			}
+			* div [lang=x-size-44] {
+				font-size: 44px !important;
+				line-height: 50px !important;
+			}
+			* div [lang=x-size-48] {
+				font-size: 48px !important;
+				line-height: 54px !important;
+			}
+			* div [lang=x-size-56] {
+				font-size: 56px !important;
+				line-height: 60px !important;
+			}
+			* div [lang=x-size-64] {
+				font-size: 64px !important;
+				line-height: 63px !important;
+			}
+		}
+	</style>
+	<style type="text/css">
+		body {
+			margin: 0;
+			padding: 0;
+		}
+		
+		table {
+			border-collapse: collapse;
+			table-layout: fixed;
+		}
+		
+		* {
+			line-height: inherit;
+		}
+		
+		[x-apple-data-detectors],
+		[href^="tel"],
+		[href^="sms"] {
+			color: inherit !important;
+			text-decoration: none !important;
+		}
+		
+		.wrapper .footer__share-button a:hover,
+		.wrapper .footer__share-button a:focus {
+			color: #ffffff !important;
+		}
+		
+		.btn a:hover,
+		.btn a:focus,
+		.footer__share-button a:hover,
+		.footer__share-button a:focus,
+		.email-footer__links a:hover,
+		.email-footer__links a:focus {
+			opacity: 0.8;
+		}
+		
+		.ie .btn {
+			width: 100%;
+		}
+		
+		.ie .column,
+		[owa] .column,
+		.ie .gutter,
+		[owa] .gutter {
+			display: table-cell;
+			float: none !important;
+			vertical-align: top;
+		}
+		
+		.ie .preheader,
+		[owa] .preheader,
+		.ie .email-footer,
+		[owa] .email-footer {
+			width: 560px !important;
+		}
+		
+		.ie .snippet,
+		[owa] .snippet,
+		.ie .webversion,
+		[owa] .webversion {
+			width: 280px !important;
+		}
+		
+		.ie .header,
+		[owa] .header,
+		.ie .layout,
+		[owa] .layout,
+		.ie .one-col .column,
+		[owa] .one-col .column {
+			width: 600px !important;
+		}
+		
+		.ie .fixed-width.has-border,
+		[owa] .fixed-width.has-border,
+		.ie .has-gutter.has-border,
+		[owa] .has-gutter.has-border {
+			width: 602px !important;
+		}
+		
+		.ie .two-col .column,
+		[owa] .two-col .column {
+			width: 300px !important;
+		}
+		
+		.ie .three-col .column,
+		[owa] .three-col .column,
+		.ie .narrow,
+		[owa] .narrow {
+			width: 200px !important;
+		}
+		
+		.ie .wide,
+		[owa] .wide {
+			width: 400px !important;
+		}
+		
+		.ie .two-col.has-gutter .column,
+		[owa] .two-col.x_has-gutter .column {
+			width: 290px !important;
+		}
+		
+		.ie .three-col.has-gutter .column,
+		[owa] .three-col.x_has-gutter .column,
+		.ie .has-gutter .narrow,
+		[owa] .has-gutter .narrow {
+			width: 188px !important;
+		}
+		
+		.ie .has-gutter .wide,
+		[owa] .has-gutter .wide {
+			width: 394px !important;
+		}
+		
+		.ie .two-col.has-gutter.has-border .column,
+		[owa] .two-col.x_has-gutter.x_has-border .column {
+			width: 292px !important;
+		}
+		
+		.ie .three-col.has-gutter.has-border .column,
+		[owa] .three-col.x_has-gutter.x_has-border .column,
+		.ie .has-gutter.has-border .narrow,
+		[owa] .has-gutter.x_has-border .narrow {
+			width: 190px !important;
+		}
+		
+		.ie .has-gutter.has-border .wide,
+		[owa] .has-gutter.x_has-border .wide {
+			width: 396px !important;
+		}
+		
+		.ie .fixed-width .layout__inner {
+			border-left: 0 none white !important;
+			border-right: 0 none white !important;
+		}
+		
+		.ie .layout__edges {
+			display: none;
+		}
+		
+		.mso .layout__edges {
+			font-size: 0;
+		}
+		
+		.layout-fixed-width,
+		.mso .layout-full-width {
+			background-color: #ffffff;
+		}
+		
+		@media only screen and (min-width: 620px) {
+			.column,
+			.gutter {
+				display: table-cell;
+				Float: none !important;
+				vertical-align: top;
+			}
+			.preheader,
+			.email-footer {
+				width: 560px !important;
+			}
+			.snippet,
+			.webversion {
+				width: 280px !important;
+			}
+			.header,
+			.layout,
+			.one-col .column {
+				width: 600px !important;
+			}
+			.fixed-width.has-border,
+			.fixed-width.ecxhas-border,
+			.has-gutter.has-border,
+			.has-gutter.ecxhas-border {
+				width: 602px !important;
+			}
+			.two-col .column {
+				width: 300px !important;
+			}
+			.three-col .column,
+			.column.narrow {
+				width: 200px !important;
+			}
+			.column.wide {
+				width: 400px !important;
+			}
+			.two-col.has-gutter .column,
+			.two-col.ecxhas-gutter .column {
+				width: 290px !important;
+			}
+			.three-col.has-gutter .column,
+			.three-col.ecxhas-gutter .column,
+			.has-gutter .narrow {
+				width: 188px !important;
+			}
+			.has-gutter .wide {
+				width: 394px !important;
+			}
+			.two-col.has-gutter.has-border .column,
+			.two-col.ecxhas-gutter.ecxhas-border .column {
+				width: 292px !important;
+			}
+			.three-col.has-gutter.has-border .column,
+			.three-col.ecxhas-gutter.ecxhas-border .column,
+			.has-gutter.has-border .narrow,
+			.has-gutter.ecxhas-border .narrow {
+				width: 190px !important;
+			}
+			.has-gutter.has-border .wide,
+			.has-gutter.ecxhas-border .wide {
+				width: 396px !important;
+			}
+		}
+		
+		@media only screen and (-webkit-min-device-pixel-ratio: 2),
+		only screen and (min--moz-device-pixel-ratio: 2),
+		only screen and (-o-min-device-pixel-ratio: 2/1),
+		only screen and (min-device-pixel-ratio: 2),
+		only screen and (min-resolution: 192dpi),
+		only screen and (min-resolution: 2dppx) {
+			.fblike {
+				background-image: url(https://i3.createsend1.com/static/eb/master/13-the-blueprint-3/images/fblike@2x.png) !important;
+			}
+			.tweet {
+				background-image: url(https://i4.createsend1.com/static/eb/master/13-the-blueprint-3/images/tweet@2x.png) !important;
+			}
+			.linkedinshare {
+				background-image: url(https://i6.createsend1.com/static/eb/master/13-the-blueprint-3/images/lishare@2x.png) !important;
+			}
+			.forwardtoafriend {
+				background-image: url(https://i7.createsend1.com/static/eb/master/13-the-blueprint-3/images/forward@2x.png) !important;
+			}
+		}
+		
+		@media (max-width: 321px) {
+			.fixed-width.has-border .layout__inner {
+				border-width: 1px 0 !important;
+			}
+			.layout,
+			.column {
+				min-width: 320px !important;
+				width: 320px !important;
+			}
+			.border {
+				display: none;
+			}
+		}
+		
+		.mso div {
+			border: 0 none white !important;
+		}
+		
+		.mso .w560 .divider {
+			Margin-left: 260px !important;
+			Margin-right: 260px !important;
+		}
+		
+		.mso .w360 .divider {
+			Margin-left: 160px !important;
+			Margin-right: 160px !important;
+		}
+		
+		.mso .w260 .divider {
+			Margin-left: 110px !important;
+			Margin-right: 110px !important;
+		}
+		
+		.mso .w160 .divider {
+			Margin-left: 60px !important;
+			Margin-right: 60px !important;
+		}
+		
+		.mso .w354 .divider {
+			Margin-left: 157px !important;
+			Margin-right: 157px !important;
+		}
+		
+		.mso .w250 .divider {
+			Margin-left: 105px !important;
+			Margin-right: 105px !important;
+		}
+		
+		.mso .w148 .divider {
+			Margin-left: 54px !important;
+			Margin-right: 54px !important;
+		}
+		
+		.mso .font-avenir,
+		.mso .font-cabin,
+		.mso .font-open-sans,
+		.mso .font-ubuntu {
+			font-family: sans-serif !important;
+		}
+		
+		.mso .font-bitter,
+		.mso .font-merriweather,
+		.mso .font-pt-serif {
+			font-family: Georgia, serif !important;
+		}
+		
+		.mso .font-lato,
+		.mso .font-roboto {
+			font-family: Tahoma, sans-serif !important;
+		}
+		
+		.mso .font-pt-sans {
+			font-family: "Trebuchet MS", sans-serif !important;
+		}
+		
+		.mso .footer__share-button p {
+			margin: 0;
+		}
+		
+		@media only screen and (min-width: 620px) {
+			.wrapper .size-8 {
+				font-size: 8px !important;
+				line-height: 14px !important;
+			}
+			.wrapper .size-9 {
+				font-size: 9px !important;
+				line-height: 16px !important;
+			}
+			.wrapper .size-10 {
+				font-size: 10px !important;
+				line-height: 18px !important;
+			}
+			.wrapper .size-11 {
+				font-size: 11px !important;
+				line-height: 19px !important;
+			}
+			.wrapper .size-12 {
+				font-size: 12px !important;
+				line-height: 19px !important;
+			}
+			.wrapper .size-13 {
+				font-size: 13px !important;
+				line-height: 21px !important;
+			}
+			.wrapper .size-14 {
+				font-size: 14px !important;
+				line-height: 21px !important;
+			}
+			.wrapper .size-15 {
+				font-size: 15px !important;
+				line-height: 23px !important;
+			}
+			.wrapper .size-16 {
+				font-size: 16px !important;
+				line-height: 24px !important;
+			}
+			.wrapper .size-17 {
+				font-size: 17px !important;
+				line-height: 26px !important;
+			}
+			.wrapper .size-18 {
+				font-size: 18px !important;
+				line-height: 26px !important;
+			}
+			.wrapper .size-20 {
+				font-size: 20px !important;
+				line-height: 28px !important;
+			}
+			.wrapper .size-22 {
+				font-size: 22px !important;
+				line-height: 31px !important;
+			}
+			.wrapper .size-24 {
+				font-size: 24px !important;
+				line-height: 32px !important;
+			}
+			.wrapper .size-26 {
+				font-size: 26px !important;
+				line-height: 34px !important;
+			}
+			.wrapper .size-28 {
+				font-size: 28px !important;
+				line-height: 36px !important;
+			}
+			.wrapper .size-30 {
+				font-size: 30px !important;
+				line-height: 38px !important;
+			}
+			.wrapper .size-32 {
+				font-size: 32px !important;
+				line-height: 40px !important;
+			}
+			.wrapper .size-34 {
+				font-size: 34px !important;
+				line-height: 43px !important;
+			}
+			.wrapper .size-36 {
+				font-size: 36px !important;
+				line-height: 43px !important;
+			}
+			.wrapper .size-40 {
+				font-size: 40px !important;
+				line-height: 47px !important;
+			}
+			.wrapper .size-44 {
+				font-size: 44px !important;
+				line-height: 50px !important;
+			}
+			.wrapper .size-48 {
+				font-size: 48px !important;
+				line-height: 54px !important;
+			}
+			.wrapper .size-56 {
+				font-size: 56px !important;
+				line-height: 60px !important;
+			}
+			.wrapper .size-64 {
+				font-size: 64px !important;
+				line-height: 63px !important;
+			}
+		}
+		
+		.mso .size-8,
+		.ie .size-8 {
+			font-size: 8px !important;
+			line-height: 14px !important;
+		}
+		
+		.mso .size-9,
+		.ie .size-9 {
+			font-size: 9px !important;
+			line-height: 16px !important;
+		}
+		
+		.mso .size-10,
+		.ie .size-10 {
+			font-size: 10px !important;
+			line-height: 18px !important;
+		}
+		
+		.mso .size-11,
+		.ie .size-11 {
+			font-size: 11px !important;
+			line-height: 19px !important;
+		}
+		
+		.mso .size-12,
+		.ie .size-12 {
+			font-size: 12px !important;
+			line-height: 19px !important;
+		}
+		
+		.mso .size-13,
+		.ie .size-13 {
+			font-size: 13px !important;
+			line-height: 21px !important;
+		}
+		
+		.mso .size-14,
+		.ie .size-14 {
+			font-size: 14px !important;
+			line-height: 21px !important;
+		}
+		
+		.mso .size-15,
+		.ie .size-15 {
+			font-size: 15px !important;
+			line-height: 23px !important;
+		}
+		
+		.mso .size-16,
+		.ie .size-16 {
+			font-size: 16px !important;
+			line-height: 24px !important;
+		}
+		
+		.mso .size-17,
+		.ie .size-17 {
+			font-size: 17px !important;
+			line-height: 26px !important;
+		}
+		
+		.mso .size-18,
+		.ie .size-18 {
+			font-size: 18px !important;
+			line-height: 26px !important;
+		}
+		
+		.mso .size-20,
+		.ie .size-20 {
+			font-size: 20px !important;
+			line-height: 28px !important;
+		}
+		
+		.mso .size-22,
+		.ie .size-22 {
+			font-size: 22px !important;
+			line-height: 31px !important;
+		}
+		
+		.mso .size-24,
+		.ie .size-24 {
+			font-size: 24px !important;
+			line-height: 32px !important;
+		}
+		
+		.mso .size-26,
+		.ie .size-26 {
+			font-size: 26px !important;
+			line-height: 34px !important;
+		}
+		
+		.mso .size-28,
+		.ie .size-28 {
+			font-size: 28px !important;
+			line-height: 36px !important;
+		}
+		
+		.mso .size-30,
+		.ie .size-30 {
+			font-size: 30px !important;
+			line-height: 38px !important;
+		}
+		
+		.mso .size-32,
+		.ie .size-32 {
+			font-size: 32px !important;
+			line-height: 40px !important;
+		}
+		
+		.mso .size-34,
+		.ie .size-34 {
+			font-size: 34px !important;
+			line-height: 43px !important;
+		}
+		
+		.mso .size-36,
+		.ie .size-36 {
+			font-size: 36px !important;
+			line-height: 43px !important;
+		}
+		
+		.mso .size-40,
+		.ie .size-40 {
+			font-size: 40px !important;
+			line-height: 47px !important;
+		}
+		
+		.mso .size-44,
+		.ie .size-44 {
+			font-size: 44px !important;
+			line-height: 50px !important;
+		}
+		
+		.mso .size-48,
+		.ie .size-48 {
+			font-size: 48px !important;
+			line-height: 54px !important;
+		}
+		
+		.mso .size-56,
+		.ie .size-56 {
+			font-size: 56px !important;
+			line-height: 60px !important;
+		}
+		
+		.mso .size-64,
+		.ie .size-64 {
+			font-size: 64px !important;
+			line-height: 63px !important;
+		}
+		
+		.footer__share-button p {
+			margin: 0;
+		}
+	</style>
+
+	<title>{SITENAME}</title>
+	<!--[if !mso]><!-->
+	<style type="text/css">
+		@import url(https://fonts.googleapis.com/css?family=Bitter:400,700,400italic|Open+Sans:400italic,700italic,700,400);
+	</style>
+	<link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Bitter:400,700,400italic|Open+Sans:400italic,700italic,700,400">
+	<!--<![endif]-->
+	<style type="text/css">
+		body {
+			background-color: #f2f6f7
+		}
+		
+		.mso h1 {}
+		
+		.mso h1 {
+			font-family: Georgia, serif !important
+		}
+		
+		.mso h2 {}
+		
+		.mso h2 {
+			font-family: Georgia, serif !important
+		}
+		
+		.mso h3 {}
+		
+		.mso h3 {
+			font-family: Georgia, serif !important
+		}
+		
+		.mso .column,
+		.mso .column__background td {}
+		
+		.mso .column,
+		.mso .column__background td {
+			font-family: sans-serif !important
+		}
+		
+		.mso .btn a {}
+		
+		.mso .btn a {
+			font-family: sans-serif !important
+		}
+		
+		.mso .webversion,
+		.mso .snippet,
+		.mso .layout-email-footer td,
+		.mso .footer__share-button p {}
+		
+		.mso .webversion,
+		.mso .snippet,
+		.mso .layout-email-footer td,
+		.mso .footer__share-button p {
+			font-family: sans-serif !important
+		}
+		
+		.mso .logo {}
+		
+		.mso .logo {
+			font-family: Tahoma, sans-serif !important
+		}
+		
+		.logo a:hover,
+		.logo a:focus {
+			color: #859bb1 !important
+		}
+		
+		.mso .layout-has-border {
+			border-top: 1px solid #b3cad0;
+			border-bottom: 1px solid #b3cad0
+		}
+		
+		.mso .layout-has-bottom-border {
+			border-bottom: 1px solid #b3cad0
+		}
+		
+		.mso .border,
+		.ie .border {
+			background-color: #b3cad0
+		}
+		
+		@media only screen and (min-width: 620px) {
+			.wrapper h1 {}
+			.wrapper h1 {
+				font-size: 26px !important;
+				line-height: 34px !important
+			}
+			.wrapper h2 {}
+			.wrapper h2 {
+				font-size: 20px !important;
+				line-height: 28px !important
+			}
+			.wrapper h3 {}
+			.column,
+			.column__background td {}
+		}
+		
+		.mso h1,
+		.ie h1 {}
+		
+		.mso h1,
+		.ie h1 {
+			font-size: 26px !important;
+			line-height: 34px !important
+		}
+		
+		.mso h2,
+		.ie h2 {}
+		
+		.mso h2,
+		.ie h2 {
+			font-size: 20px !important;
+			line-height: 28px !important
+		}
+		
+		.mso h3,
+		.ie h3 {}
+		
+		.mso .column,
+		.ie .column,
+		.mso .column__background td,
+		.ie .column__background td {}
+	</style>
+</head>
+<!--[if mso]>
+	<body class="mso">
+<![endif]-->
+<!--[if !mso]><!-->
+
+<body style="margin: 0;padding: 0;-webkit-text-size-adjust: 100%;" class="full-padding">
+	<!--<![endif]-->
+	<div lang="x-wrapper" style="min-width: 320px;background-color: #f2f6f7;" class="wrapper">
+		<div style="Margin: 0 auto;max-width: 560px;min-width: 280px; width: 280px;width: calc(28000% - 173040px);" class="preheader">
+			<div style="border-collapse: collapse;display: table;width: 100%;">
+				<!--[if (mso)|(IE)]><table align="center" class="preheader" cellpadding="0" cellspacing="0"><tr><td style="width: 280px" valign="top"><![endif]-->
+				<div style="Float: left;font-size: 12px;line-height: 19px;max-width: 280px;min-width: 140px; width: 140px;width: calc(14000% - 78120px);padding: 10px 0 5px 0;color: #99b0b8;font-family: &quot;Open Sans&quot;,sans-serif;" class="snippet">
+
+				</div>
+				<!--[if (mso)|(IE)]></td><td style="width: 280px" valign="top"><![endif]-->
+				<div style="Float: left;font-size: 12px;line-height: 19px;max-width: 280px;min-width: 139px; width: 139px;width: calc(14100% - 78680px);padding: 10px 0 5px 0;text-align: right;color: #99b0b8;font-family: &quot;Open Sans&quot;,sans-serif;" class="webversion">
+
+				</div>
+				<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
+			</div>
+		</div>
+		<div id="emb-email-header-container" style="Margin: 0 auto;max-width: 600px;min-width: 320px; width: 320px;width: calc(28000% - 173000px);" class="header">
+			<!--[if (mso)|(IE)]><table align="center" class="header" cellpadding="0" cellspacing="0"><tr><td style="width: 600px"><![endif]-->
+			<div align="center" style="font-size: 26px;line-height: 32px;Margin-top: 6px;Margin-bottom: 20px;color: #c3ced9;font-family: Roboto,Tahoma,sans-serif;Margin-left: 20px;Margin-right: 20px;" class="logo emb-logo-margin-box">
+				<div align="center" id="emb-email-header" style="font-size:0px !important;line-height:0 !important;" class="logo-center">
+					<img width="141" alt="" src="{SITE_LOGO_IMG}" style="height: auto;width: 100%;border: 0;max-width: 141px;">
+				</div>
+			</div>
+			<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
+		</div>
+		<div style="Margin: 0 auto;max-width: 600px;min-width: 320px; width: 320px;width: calc(28000% - 173000px);overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;" class="layout one-col fixed-width">
+			<div emb-background-style="" style="border-collapse: collapse;display: table;width: 100%;background-color: #ffffff;" class="layout__inner">
+				<!--[if (mso)|(IE)]><table align="center" cellpadding="0" cellspacing="0"><tr class="layout-fixed-width" emb-background-style><td style="width: 600px" class="w560"><![endif]-->
+				<div style="text-align: left;color: #808285;font-size: 14px;line-height: 21px;font-family: &quot;Open Sans&quot;,sans-serif;max-width: 600px;min-width: 320px; width: 320px;width: calc(28000% - 167400px);" class="column">
+
+					<div style="Margin-left: 20px;Margin-right: 20px;Margin-top: 24px;">
+						<div style="line-height:10px;font-size:1px">&nbsp;</div>
+					</div>
+
+					<div style="Margin-left: 20px;Margin-right: 20px;">
+						<div style="line-height:5px;font-size:1px">&nbsp;</div>
+					</div>
+
+					<div style="Margin-left: 20px;Margin-right: 20px;">
+						<h1 style="Margin-top: 0;Margin-bottom: 20px;font-style: normal;font-weight: normal;color: #58595b;font-size: 22px;line-height: 31px;font-family: Bitter,Georgia,serif;text-align: center;">Last Topics While You Were Away</h1>
+					</div>
+
+					<div style="Margin-left: 20px;Margin-right: 20px;">
+						<div style="display: block;font-size: 2px;line-height: 2px;Margin-left: auto;Margin-right: auto;width: 40px;background-color: #b3cad0;Margin-bottom: 20px;" class="divider">&nbsp;</div>
+					</div>
+
+					<div style="Margin-left: 20px;Margin-right: 20px;">
+						<p style="Margin-top: 0;Margin-bottom: 20px;text-align: center;">Enquanto estiveste fora a laurear a pevide, houve nova atividade no fórum. Vê a nova tendência. Estamos animados para te ver novamente!</p>
+					    <p style="Margin-top: 10px;Margin-bottom: 20px;text-align: center;">{EMAIL_SIG}</p>
+					</div>
+
+					<div style="Margin-left: 20px;Margin-right: 20px;">
+						<div style="line-height:10px;font-size:1px">&nbsp;</div>
+					</div>
+
+					<div style="Margin-left: 20px;Margin-right: 20px;">
+						<div style="Margin-bottom: 20px;text-align: center;" class="btn btn--flat btn--large">
+							<!--[if !mso]--><a href="{BOARD_URL}" style="border-radius: 4px;display: inline-block;font-size: 14px;font-weight: bold;line-height: 24px;padding: 12px 24px;text-align: center;text-decoration: none !important;transition: opacity 0.1s ease-in;color: #60686b;background-color: #becdd1;font-family: 'Open Sans', sans-serif;"
+							target="_blank">Comunidade GoldTugAnime</a>
+							<!--[endif]-->
+							<!--[if mso]><p style="line-height:0;margin:0;">&nbsp;</p><v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" href="{BOARD_URL}" style="width:167px" arcsize="9%" fillcolor="#BECDD1" stroke="f"><v:textbox style="mso-fit-shape-to-text:t" inset="0px,11px,0px,11px"><center style="font-size:14px;line-height:24px;color:#60686B;font-family:sans-serif;font-weight:bold;mso-line-height-rule:exactly;mso-text-raise:4px">Discussion Board</center></v:textbox></v:roundrect><![endif]-->
+						</div>
+					</div>
+
+					<div style="Margin-left: 20px;Margin-right: 20px;Margin-bottom: 24px;">
+						<div style="line-height:15px;font-size:1px">&nbsp;</div>
+					</div>
+
+				</div>
+				<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
+			</div>
+		</div>
+
+		<div style="line-height:20px;font-size:20px;">&nbsp;</div>
+
+		<div style="Margin: 0 auto;max-width: 600px;min-width: 320px; width: 320px;width: calc(28000% - 173000px);overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;" class="layout one-col fixed-width">
+			<div emb-background-style="" style="border-collapse: collapse;display: table;width: 100%;background-color: #ffffff;" class="layout__inner">
+				<!--[if (mso)|(IE)]><table align="center" cellpadding="0" cellspacing="0"><tr class="layout-fixed-width" emb-background-style><td style="width: 600px" class="w560"><![endif]-->
+				<div style="text-align: left;color: #808285;font-size: 14px;line-height: 21px;font-family: &quot;Open Sans&quot;,sans-serif;max-width: 600px;min-width: 320px; width: 320px;width: calc(28000% - 167400px);" class="column">
+
+					<div style="Margin-left: 20px;Margin-right: 20px;Margin-top: 24px;Margin-bottom: 24px;">
+<!-- BEGIN mailrow -->
+						<p style="Margin-top: 0;Margin-bottom: 0;"><a href="{mailrow.U_TOPIC}" style="text-decoration: underline;transition: opacity 0.1s ease-in;color: #60686b;" target="_blank">{mailrow.TOPIC} em: {mailrow.FORUMS}</a></p>
+<!-- END mailrow -->
+						<p style="Margin-top: 20px;Margin-bottom: 0;">&nbsp;</p>
+					</div>
+
+				</div>
+				<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
+			</div>
+		</div>
+
+		<div style="line-height:20px;font-size:20px;">&nbsp;</div>
+
+		<div style="Margin: 0 auto;max-width: 600px;min-width: 320px; width: 320px;width: calc(28000% - 173000px);overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;" class="layout email-footer">
+			<div style="border-collapse: collapse;display: table;width: 100%;" class="layout__inner">
+				<!--[if (mso)|(IE)]><table align="center" cellpadding="0" cellspacing="0"><tr class="layout-email-footer"><td style="width: 400px;" valign="top" class="w360"><![endif]-->
+				<div style="text-align: left;font-size: 12px;line-height: 19px;color: #99b0b8;font-family: &quot;Open Sans&quot;,sans-serif;Float: left;max-width: 400px;min-width: 320px; width: 320px;width: calc(8000% - 47600px);" class="column wide">
+					<div style="Margin-left: 20px;Margin-right: 20px;Margin-top: 10px;Margin-bottom: 10px;">
+
+						<div>
+
+						</div>
+						<div style="Margin-top: 18px;">
+
+						</div>
+					</div>
+				</div>
+				<!--[if (mso)|(IE)]></td><td style="width: 200px;" valign="top" class="w160"><![endif]-->
+				<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
+			</div>
+		</div>
+		<div style="Margin: 0 auto;max-width: 600px;min-width: 320px; width: 320px;width: calc(28000% - 173000px);overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;" class="layout one-col email-footer">
+			<div style="border-collapse: collapse;display: table;width: 100%;" class="layout__inner">
+				<!--[if (mso)|(IE)]><table align="center" cellpadding="0" cellspacing="0"><tr class="layout-email-footer"><td style="width: 600px;" class="w560"><![endif]-->
+				<div style="text-align: center;font-size: 12px;line-height: 19px;color: #99b0b8;font-family: &quot;Open Sans&quot;,sans-serif;max-width: 600px;min-width: 320px; width: 320px;width: calc(28000% - 167400px);" class="column">
+					<div style="Margin-left: 20px;Margin-right: 20px;Margin-top: 10px;Margin-bottom: 10px;">
+						<div>
+							<span>
+              <a lang="en" href="{U_BOARD}" style="text-decoration: underline;transition: opacity 0.1s ease-in;color: #99b0b8;" target="_blank">Preferências</a>
+              &nbsp;&nbsp;|&nbsp;&nbsp;
+            </span>
+              <a href="{NEWSLETTER_OPTOUT}" style="text-decoration: underline;transition: opacity 0.1s ease-in;color: #99b0b8;" target="_blank">Cancelar Subscrição</a>
+						</div>
+					</div>
+				</div>
+				<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
+			</div>
+		</div>
+		<div style="line-height:40px;font-size:40px;">&nbsp;</div>
+
+	</div>
+
+</body>
+
+</html>
\ No newline at end of file
diff --git "[FORUM_EXT]/sitesplat\\newsletter/language/pt/email/newsoverview_txt.txt" "[FORUM_EXT]/sitesplat\\newsletter/language/pt/email/newsoverview_txt.txt"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\newsletter/language/pt/email/newsoverview_txt.txt"
@@ -0,0 +1,17 @@
+Subject: Latest topic at "{SITENAME}"
+
+{SITENAME}
+
+Latest Topics
+Hi,
+It's time for another newsletter.
+We look forward to see you at {BOARD_URL} again.
+
+Forum				Topic
+<!-- BEGIN mailrow -->
+{mailrow.U_FORUM}				{mailrow.U_TOPIC}
+<!-- END mailrow -->
+
+
+{EMAIL_SIG}
+Don't want to receive our newsletter anymore, click here {NEWSLETTER_OPTOUT}
\ No newline at end of file
diff --git "[FORUM_EXT]/sitesplat\\newsletter/language/pt/info_acp_newsletter.php" "[FORUM_EXT]/sitesplat\\newsletter/language/pt/info_acp_newsletter.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\newsletter/language/pt/info_acp_newsletter.php"
@@ -0,0 +1,181 @@
+<?php
+/**
+*
+* @package BBnewsletter
+* @copyright (c) 2016 SiteSplat All rights reserved
+* @license Proprietary
+*
+*/
+
+if (!defined('IN_PHPBB'))
+{
+	exit;
+}
+
+if (empty($lang) || !is_array($lang))
+{
+	$lang = array();
+}
+
+$lang = array_merge($lang, array(
+	'ACP_NEWSLETTER'			=> 'Newsletter',
+	'ACP_NEWSLETTER_EXPLAIN'	=> 'Setup your Newsletter, several options are available below. Please make sure your mailserver accepts all mails, otherwise it will use phpbb\'s mail settings to send emails in small batches. <br />The weekly and monthly "Catch-up" forum news are sent out by the cron task. Install <a href="https://github.com/ForumHulp/cronstatus" target="_blank">Cronstatus extension</a> and select "Run cron always" in the options to run more often the "Catch-up" News (This is especially useful for small forums). <br />For HTML e-mails install <a href=" https://github.com/ForumHulp/htmlemail" target="_blank">HTML emails Extension</a> which enables the HTML settings.<br />',
+    'FORUMS_NEWS_FROM'		    => 'Newsletter forum source',
+	'FORUMS_FROM_EXPLAIN'		=> 'Select the forums you would like the users to receive the news from',
+	'SEND_IMMEDIATELY'			=> 'Send immediately',
+	'SEND_IMMEDIATELY_EXPLAIN'	=> 'Attempt to send the emails immediately. This depends on the server email configuration parameters',
+	'PERIOD'					=> 'Email Overview (or Catch-up) Period',
+	'PERIOD_EXPLAIN'			=> 'This will send automatic "Catch-up"  emails to the users that are subscribed. The e-mail will be generated based on the new topics in the forum. The user will receive an email with the purpose of engaging the user\'s interest in the recent board\'s activity. Edit the templates file named newsletter_html.txt for the HTML version and newsletter_txt.txt for the TXT version from:<br /> <code>root\ext\sitesplat\newsletter\language\en\email\</code> <br /> To learn how to send out professional looking HTML emails check out the tutorials over at <a href=" https://sitesplat.com/" target="_blank">sitesplat.com</a> or click the "Tutorials" label above.',
+	'WEEKLY'					=> 'Weekly',
+	'MONTHLY'					=> 'Monthly',
+	'NO_OVERVIEW'				=> 'None',
+	'PERIOD_SEND'				=> 'Set period for automatic newsletter',
+	'SEND_TO_GROUP'				=> 'Send to group',
+	'SEND_TO_USERS'				=> 'Send to user(s)',
+	'SEND_TO_USERS_EXPLAIN'		=> 'When using this field it will override the "Send to Group" option above. Each user on a new line',
+	'ALL_USERS'					=> 'All users',
+	'NEW_USER'					=> 'Allow new users',
+	'MAIL_LOW_PRIORITY'			=> 'Low',
+	'MAIL_NORMAL_PRIORITY'		=> 'Normal',
+	'MAIL_HIGH_PRIORITY'		=> 'High',
+	'MAIL_PRIORITY'				=> 'Mail priority',
+	'USE_HTML'					=> 'Use HTML emails',
+	'COMPOSE_HTML'				=> 'Send manually',
+	'COMPOSE_HTML_EXPLAIN'		=> 'If "Send manually" is selected the HTML editor will be available to send custom emails in HTML format',
+	'MASS_MESSAGE'				=> 'Message (Newsletter Body)',
+	'MASS_MESSAGE_EXPLAIN'		=> 'HTML message will be stripped if HTML email Extension is not enabled. To use the HTML editor click on "Tools" then "Source code" and enter the HTML code in the code editor ',
+	'FHHTML_EMAIL_NOT_ENABLED'	=> 'HTML email extension not enabled. Download it from https://github.com/ForumHulp/htmlemail',
+	'FHHTML_EMAIL_DOWNLOAD'	    => 'HTML email Extension not enabled. Download it from <a href="https://github.com/ForumHulp/htmlemail" target="blank">GithHub HTML Email Ext</a>',
+	'LAST_SEND'					=> '<span id="viewsubscribers" class="label label-info" title="View subscribers">%1$s Members</span> subscribed, last letter was sent on <strong class="text-info">%2$s</strong>',
+	'LAST_SEND_LETTERS'			=> 'Last newsletters',
+	'LAST_SEND_EXPLAIN'			=> '**Please note, new registered users are automatically subscribed. (Click "X Members" above to view the users list)',
+	'LAST_NEWSLETTERS_EXPLAIN'	=> '**Please note, the following template visualized on the single emails below does NOT reflect 100% the email that was sent out. This is due to phpBB\'s ACP stylesheet obsolete CSS reset rules. Refer to your email copy or front-end archive for the exact email accuracy.<br /> This is a list with the sole purpose of keeping track of the emails and users in a simple manner.<br />Always save a copy of the composed HTML email before sending it out if you wish to re-use it in the future.',
+	'NEWS_PAGE'					=> 'Visible',
+	'HIDE'						=> 'Hide',
+	'SHOW'						=> 'Show',
+	'DELETE_MAIL_SUCCES'		=> 'Newsletter deleted',
+	'ACP_NEWSOVERVIEW_SEND'		=> 'Newsletter(s) sent successfully',
+	'ACP_NEWSOVERVIEW_SAVED'	=> 'Settings saved successfully',
+	
+	'SITESPLAT_COM'		        => 'https://sitesplat.com',
+	'SITESPLAT_COPY'		    => '&#169; SiteSplat',
+	'LICENSE_INFO'		        => 'Proprietary - SiteSplat All rights reserved',
+	'EXTENSION_DEVELOPER'	    => 'Developer',
+	'ACP_NOTICE_CLOSE'			=> 'Close',
+	'ACP_NEWS_VERSION'          => '1.0.5',
+	'ACP_LOADING'		        => 'Loading... Hold on',
+	'FORUM_CONTENT'		        => 'forum content',
+	'EXT_NEWS_DESCRIPTION_PAGE'	=> 'A Newsletter system with an archive, weekly, monthly and many more options to run your own HTML style newsletter like a pro!',
+	'EXT_NEWS_TASKS_1'			=> 'Newsletter Archive',
+	'EXT_NEWS_TASKS_2'			=> 'Full HTML Enabled',
+	'EXT_NEWS_TASKS_3'			=> 'Synchronization with Cron tasks and compatible with <a href="https://www.phpbb.com/customise/db/extension/cronstatus/">Cron Status</a>',
+	'EXT_NEWS_TASKS_4'			=> 'Scheduled Newsletter',
+	'EXT_NEWS_TASKS_5'			=> 'Checkout the other premium addons on <a href="https://sitesplat.com/phpBB3/marketplace.php">sitesplat.com/marketplace.php</a>',
+	'EXT_NEWS_TASKS_6'			=> 'phpBB 3.2 ready',
+
+	'NEWS_SUBSCRIBERS_INFO'     => 'Subscribers and news info',
+	'NEWS_TRICKS_TITLE'         => 'Tips and Tricks',
+	'ACP_NEWS_TRICK_EXPLAIN'	=> '<p>Does your ISP limit the number of emails you can send each day?</p>
+									<p><strong>Of course they do!</strong>
+									</p>
+									<p>Every outgoing SMTP mail server is guided by a provider’s email policy which includes hourly and/or daily email send limits. This policy will ultimately determine how many emails you can send each day. You can find a list of the hourly and daily send limits for most of the major ISPs, web hosting companies and Free email address providers below.</p>
+									<p><strong><a title="Email sending limits for isp, web hosting and free email providers" href="http://group-mail.com/sending-email/email-sending-limits-for-isp-web-hosting-and-free-email-providers/">Email Sending Limits of ISP, Web Hosting and Free Email Providers</a></strong>
+									</p>
+									<p>If you try to send more email than the hourly or daily email sending limits of your mail server, you will notice errors being returned after the specified quota is met, saying something along the lines of:<em> </em>
+									</p>
+									<blockquote>
+										<p><em>you have reached your daily sending quota</em>…</p>
+									</blockquote>
+									<p>If you surpass the daily <a title="SMTP email sending limits" href="http://group-mail.com/sending-email/email-sending-limits-for-isp-web-hosting-and-free-email-providers/">SMTP email sending limits</a> of your provider, you will generally have to wait 24 hours before you can send more email through that particular server.</p>
+									<p>But, what are the hourly or daily email sending limits for <em>your</em> email server?</p>
+									<ul>
+										<li>The Gmail mail server send limit is approximately 100-150 emails per day when connected to the server from a remote email client. You can send 500 emails each day through the Gmail SMTP server when logged into their web interface.</li>
+										<li>The Comcast mail server limits residential customers to send 1,000 messages per day. Comcast Business customers can send 24,000 emails per day through the Comcast outgoing SMTP mail server.</li>
+										<li>The basic GoDaddy email server limits senders to send&nbsp; only 250 outgoing emails per day, but you can <a title="send more email by adding SMTP relays to your GoDaddy account" href="http://group-mail.com/sending-email/how-to-increase-your-godaddy-email-sending-limits/">send more email by adding SMTP relays to your GoDaddy account</a>
+										</li>
+									</ul>
+									<p>&nbsp;</p>
+									<p>So, what’s a guy to do if he needs to get his monthly email newsletter out to 5,000 eager subscribers but his ISP has a daily send limit of 500 emails per day?</p>
+									<p><strong>What can you do if your mail server has limits that don’t support the size of your mailing list?</strong>
+									</p>
+									<p>If your current outgoing SMTP email server does not support your email list size or sending frequency, you have a variety of options:</p>
+									<p style="padding-left: 30px;">1. Contact the host of your outgoing SMTP mail server(s) and ask if they have a business account that lets you send more emails each day to support your business.</p>
+									<p style="padding-left: 30px;">2. Use GroupMail’s <a title="sending email without an external SMTP mail server" href="http://group-mail.com/sending-email/sending-email-without-an-external-smtp-mail-server/">Direct Send option</a>, which allows you to bypass your external SMTP server altogether and send email directly from your computer to your recipients using GroupMail’s own internal SMTP engine.</p>
+									<p style="padding-left: 30px;">3. Use an outgoing SMTP service like <a title="SMTP2Go outgoing relay pricing" href="http://groupmail.smtp2go.com">SMTP2Go</a> to relay your large email campaigns.</p>
+									<p style="padding-left: 30px;">4. Find a web hosting company who has daily email sending limits that meet your needs.</p>
+									<p style="padding-left: 30px;">5. Setup your own <a href="http://www.msexchange.org/tutorials/MF002.html">MS Exchange Server</a> and configure it for SMTP email delivery.</p>
+									<p>So, while GroupMail allows you to send and manage email lists of an <strong>unlimited</strong> size; the success of email delivery to large groups is ultimately dependent upon the sending limits set forth in the email sending policy of the SMTP mail server you are using.</p>
+									<p><strong>Related articles you might find interesting:</strong>
+									</p>
+									<p><a title="email sending limits of ISPs web hosting and free email providers" href="http://group-mail.com/sending-email/email-sending-limits-for-isp-web-hosting-and-free-email-providers/">Email Sending Limits for ISPs, Web Hosting and Free Email Providers</a>
+									</p>
+									<p><a title="Common email error code descriptions and fixes" href="http://group-mail.com/email-error-codes/common-email-error-codes/">Common Email Error Code Descriptions and Fixes</a>
+									</p>
+									<p><a title="Free Email Newsletter and Marketing Software and Services" href="http://group-mail.com/email-marketing/free-email-newsletter-and-marketing-software-and-services/">Free Email Newsletter and Marketing Software and Services</a>
+									</p>
+									<p><a title="Email Settings for the Most Common Email Server hosts" href="http://group-mail.com/category/email-settings/">Email Settings for the Most Common Email Server Hosts</a>
+									</p>
+									<p><a title="step by step guide for email setup and delivery" href="http://group-mail.com/getting-started-with-groupmail/step-by-step-guide-for-email-setup-and-delivery/">Step-by-Step Guide for Email Setup and Delivery</a>
+									</p>
+									<p>&nbsp;</p>
+									<hr>
+									<p></p>',
+	
+	'EXT_NEWS_TUTORIALS_TITLE'  => 'Tutorials',
+	'EXT_NEWS_TUTORIALS_EXPLAIN'=> '<li><p>Templates</p>
+					<ul>
+					<li><a href="http://htmlemailboilerplate.com/" target="_blank"><strong>HTML Email Boilerplate</strong></a>: A great <strong>starting point</strong> for coding emails.</li>
+					<li><a href="http://www.campaignmonitor.com/templates/" target="_blank"><strong>Campaign Monitor Templates</strong></a>: Template builder + free downloadable templates</li>
+					</ul>
+					</li>
+					
+					<li><p>Tutorials &amp; Guides</p>
+
+					<ul>
+					<li><a href="http://kb.mailchimp.com/article/how-to-code-html-emails" target="_blank"><strong>How To Code HTML Emails (Mailchimp)</strong></a>: How HTML email works, basic concepts, best practices, tips and tricks</li>
+					<li><a href="http://www.smashingmagazine.com/2010/01/19/design-and-build-an-email-newsletter-without-losing-your-mind/" target="_blank"><strong>Design and Build Email Newsletters Without Losing Your Mind (and Soul)</strong></a>:  information you need to plan, design and build an HTML newsletter that renders well</li>
+					<li><a href="http://mailchimp.com/resources/guides/email-marketing-field-guide/html/" target="_blank"><strong>Email Marketing Field Guide (Mailchimp)</strong></a></li>
+					<li><a href="http://mattmedia.net/2007/08/23/8-html-email-tips-i-wish-i-knew-sooner/" target="_blank"><strong>8 HTML Email Tips I Wish I’d Known Sooner</strong></a></li>
+					<li><a href="http://www.campaignmonitor.com/css/" target="_blank"><strong>The Ultimate Guide</a>: From Campaign Monitor</strong></li>
+					<li><a href="http://css-tricks.com/using-css-in-html-emails-the-real-story/" target="_blank"><strong>CSS Tricks: Using CSS in HTML Emails</strong></a>: Some "I told you so"\'s and tips about HTML emails and CSS.</li>
+					</ul>
+					</li>
+					
+					<li><p>Testing</p>
+
+					<ul>
+					<li><a href="http://www.emailonacid.com/" target="_blank"><strong>Email on Acid</strong></a>: Free and paid testing</li>
+					<li><a href="http://litmus.com/" target="_blank"><strong>Litmus</strong></a></li>
+					</ul>
+					</li>
+					
+					<li><p>Other Resources</p>
+
+					<ul>
+					<li><a href="http://www.campaignmonitor.com/resources/will-it-work/email-clients/" target="_blank"><strong>Campaign Monitor\'s Popular E-Mail Clients</strong></a></li>
+					</ul>
+					</li>',
+	
+	
+	'NEWSLETTER_NOTICE'			=> '<div class="phpinfo"><p>The settings for this extension are under <strong>%1$s &#187; %2$s &#187; %3$s</strong>. <br />Please note, at first setup when the period is set (for example weekly) and the format (HTML) the first automatic newsletter overview is sent out immediately right after the settings are saved! <br />This is needed to start the Synchronization. With this in mind, consider using a test board before using the extension to make sure the end result of the newlsetter is the preferred look.</p></div>',
+	'SS_HELPER_NOTY'			=> 'SiteSplat BBcore does not exist!<br />Download the <a href="https://sitesplat.com" target="_blank">BBcore</a> and copy the BBcore folder into your sitesplat extension folder.',
+));
+
+// Description of Donations extension
+$lang = array_merge($lang, array(
+	'DESCRIPTION_PAGE'		=> 'Description',
+	'DESCRIPTION_NOTICE'	=> 'Extension note',
+	'ext_details' => array(
+		'details' => array(
+			'DESCRIPTION_1'	=> 'HTML newsletter',
+			'DESCRIPTION_2'	=> 'Groupselect',
+			'DESCRIPTION_3'	=> 'Weekly / monthly news overview',
+			'DESCRIPTION_4'	=> 'Send immediately or in batch',
+			'DESCRIPTION_5'	=> 'Overview subscribers',
+		),
+		'note' => array(
+			'NOTICE_1'		=> '<a href="https://github.com/ForumHulp/htmlemail" target="_blank">HTML email extension</a> is needed to enable the HTML settings.',
+			'NOTICE_2'		=> 'phpBB 3.2 ready'
+		)
+	)
+));
diff --git "[FORUM_EXT]/sitesplat\\newsletter/language/pt/newsletter.php" "[FORUM_EXT]/sitesplat\\newsletter/language/pt/newsletter.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\newsletter/language/pt/newsletter.php"
@@ -0,0 +1,40 @@
+<?php
+/**
+*
+* @package BBnewsletter
+* @copyright (c) 2016 SiteSplat All rights reserved
+* @license Proprietary
+*
+*/
+
+if (!defined('IN_PHPBB'))
+{
+	exit;
+}
+
+if (empty($lang) || !is_array($lang))
+{
+	$lang = array();
+}
+
+$lang = array_merge($lang, array(
+	'NEWSLETTER'				=> 'Newsletter',
+	'OVERVIEW'					=> 'Welcome to our Newsletter! :-) On this page you will find the latest Newsletters as well as the past years archives.',
+
+	'SUBSCRIBE_NO'				=> 'I do NOT want to receive the Newsletter anymore',
+	'SUBSCRIBE_YES'				=> 'Yes I want to receive the Newsletter',
+	'SUBSCRIBE_BTN_NO'			=> 'Cancel',
+	'SUBSCRIBE_BTN_YES'			=> 'Subscribe',
+	'SUBSCRIBE_CONFIRM_NO'		=> 'Please submit to cancel your subscription',
+	'SUBSCRIBE_CONFIRM_YES'		=> 'Please submit to confirm your subscription',
+
+	'SUBSCRIBE_Y_EMAIL'			=> 'Your email',
+	'SUBSCRIBE'					=> 'Subscribe to',
+	'UNSUBSCRIBE'				=> 'Unsubscribe from',
+	'SUBSCRIBE_INFO'			=> 'Our newsletter. Unsubscribed members won\'t receive our periodic News overview anymore.',
+	
+	'OVERVIEW_ARCHIVE'			=> 'Archive',
+	'ARCHIVES'					=> 'Archives',
+	'SUBSCRIBED'				=> 'Thanks for subscribing! You will receive our newsletter from today on!',
+	'UNSUBSCRIBED'				=> 'Successfully unsubscribed, you won\'t receive our newsletter any longer'
+));
diff --git "[FORUM_EXT]/sitesplat\\newsletter/language/pt_preao/email/index.htm" "[FORUM_EXT]/sitesplat\\newsletter/language/pt_preao/email/index.htm"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\newsletter/language/pt_preao/email/index.htm"
@@ -0,0 +1,10 @@
+<html>
+<head>
+<title></title>
+<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
+</head>
+
+<body bgcolor="#FFFFFF" text="#000000">
+
+</body>
+</html>
diff --git "[FORUM_EXT]/sitesplat\\newsletter/language/pt_preao/email/newsletter_html.txt" "[FORUM_EXT]/sitesplat\\newsletter/language/pt_preao/email/newsletter_html.txt"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\newsletter/language/pt_preao/email/newsletter_html.txt"
@@ -0,0 +1,293 @@
+Subject: {SUBJECT}
+
+<!DOCTYPE html>
+<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
+
+<head>
+  <meta charset="utf-8"> <!-- utf-8 works for most cases -->
+  <meta name="viewport" content="width=device-width"> <!-- Forcing initial-scale shouldn't be necessary -->
+  <meta http-equiv="X-UA-Compatible" content="IE=edge"> <!-- Use the latest (edge) version of IE rendering engine -->
+  <meta name="x-apple-disable-message-reformatting"> <!-- Disable auto-scale in iOS 10 Mail entirely -->
+
+  <!-- Web Font / @font-face : BEGIN -->
+  <!-- NOTE: If web fonts are not required, lines 10 - 27 can be safely removed. -->
+
+  <!-- Desktop Outlook chokes on web font references and defaults to Times New Roman, so we force a safe fallback font. -->
+  <!--[if mso]>
+        <style>
+            * {
+                font-family: sans-serif !important;
+            }
+        </style>
+    <![endif]-->
+
+  <!-- All other clients get the webfont reference; some will render the font and others will silently fail to the fallbacks. More on that here: http://stylecampaign.com/blog/2015/02/webfont-support-in-email/ -->
+  <!--[if !mso]><!-->
+  <!-- insert web font reference, eg: <link href='https://fonts.googleapis.com/css?family=Roboto:400,700' rel='stylesheet' type='text/css'> -->
+  <!--<![endif]-->
+
+  <!-- Web Font / @font-face : END -->
+
+  <!-- CSS Reset : BEGIN -->
+  <style>
+    /* What it does: Remove spaces around the email design added by some email clients. */
+    /* Beware: It can remove the padding / margin and add a background color to the compose a reply window. */
+    html,
+    body {
+      margin: 0 auto !important;
+      padding: 0 !important;
+      height: 100% !important;
+      width: 100% !important;
+    }
+
+    /* What it does: Stops email clients resizing small text. */
+    * {
+      -ms-text-size-adjust: 100%;
+      -webkit-text-size-adjust: 100%;
+    }
+
+    /* What it does: Centers email on Android 4.4 */
+    div[style*="margin: 16px 0"] {
+      margin: 0 !important;
+    }
+
+    /* What it does: Stops Outlook from adding extra spacing to tables. */
+    table,
+    td {
+      mso-table-lspace: 0pt !important;
+      mso-table-rspace: 0pt !important;
+    }
+
+    /* What it does: Fixes webkit padding issue. Fix for Yahoo mail table alignment bug. Applies table-layout to the first 2 tables then removes for anything nested deeper. */
+    table {
+      border-spacing: 0 !important;
+      border-collapse: collapse !important;
+      table-layout: fixed !important;
+      margin: 0 auto !important;
+    }
+
+    table table table {
+      table-layout: auto;
+    }
+
+    /* What it does: Uses a better rendering method when resizing images in IE. */
+    img {
+      -ms-interpolation-mode: bicubic;
+    }
+
+    /* What it does: A work-around for email clients meddling in triggered links. */
+    *[x-apple-data-detectors],
+    /* iOS */
+    .x-gmail-data-detectors,
+    /* Gmail */
+    .x-gmail-data-detectors *,
+    .aBn {
+      border-bottom: 0 !important;
+      cursor: default !important;
+      color: inherit !important;
+      text-decoration: none !important;
+      font-size: inherit !important;
+      font-family: inherit !important;
+      font-weight: inherit !important;
+      line-height: inherit !important;
+    }
+
+    /* What it does: Prevents Gmail from displaying an download button on large, non-linked images. */
+    .a6S {
+      display: none !important;
+      opacity: 0.01 !important;
+    }
+
+    /* If the above doesn't work, add a .g-img class to any image in question. */
+    img.g-img+div {
+      display: none !important;
+    }
+
+    /* What it does: Prevents underlining the button text in Windows 10 */
+    .button-link {
+      text-decoration: none !important;
+    }
+
+    /* What it does: Removes right gutter in Gmail iOS app: https://github.com/TedGoas/Cerberus/issues/89  */
+    /* Create one of these media queries for each additional viewport size you'd like to fix */
+    /* Thanks to Eric Lepetit (@ericlepetitsf) for help troubleshooting */
+    @media only screen and (min-device-width: 375px) and (max-device-width: 413px) {
+
+      /* iPhone 6 and 6+ */
+      .email-container {
+        min-width: 375px !important;
+      }
+    }
+
+    @media screen and (max-width: 480px) {
+
+      /* What it does: Forces Gmail app to display email full width */
+      u~div .email-container {
+        min-width: 100vw;
+        width: 100% !important;
+      }
+    }
+  </style>
+  <!-- CSS Reset : END -->
+
+  <!-- Progressive Enhancements : BEGIN -->
+  <style>
+    /* What it does: Hover styles for buttons */
+    .button-td,
+    .button-a {
+      transition: all 100ms ease-in;
+    }
+
+    .button-td:hover,
+    .button-a:hover {
+      background: #CC9900 !important;
+      border-color: #CC9900 !important;
+    }
+
+    /* Define o estilo dos links */
+    a:link {
+      color: #CC9900;
+      background-color: transparent;
+      text-decoration: none;
+    }
+
+    a:visited {
+      color: #CC9900;
+      background-color: transparent;
+      text-decoration: none;
+    }
+
+    a:hover {
+      color: #CC9900;
+      background-color: transparent;
+      text-decoration: underline;
+    }
+
+    a:active {
+      color: #CC9900;
+      background-color: transparent;
+      text-decoration: underline;
+    }
+
+    /* Media Queries */
+    @media screen and (max-width: 600px) {
+
+      .email-container {
+        width: 100% !important;
+        margin: auto !important;
+      }
+
+      /* What it does: Forces elements to resize to the full width of their container. Useful for resizing images beyond their max-width. */
+      .fluid {
+        max-width: 100% !important;
+        height: auto !important;
+        margin-left: auto !important;
+        margin-right: auto !important;
+      }
+
+      /* What it does: Forces table cells into full-width rows. */
+      .stack-column,
+      .stack-column-center {
+        display: block !important;
+        width: 100% !important;
+        max-width: 100% !important;
+        direction: ltr !important;
+      }
+
+      /* And center justify these ones. */
+      .stack-column-center {
+        text-align: center !important;
+      }
+
+      /* What it does: Generic utility class for centering. Useful for images, buttons, and nested tables. */
+      .center-on-narrow {
+        text-align: center !important;
+        display: block !important;
+        margin-left: auto !important;
+        margin-right: auto !important;
+        float: none !important;
+      }
+
+      table.center-on-narrow {
+        display: inline-block !important;
+      }
+
+      /* What it does: Adjust typography on small screens to improve readability */
+      .email-container p {
+        font-size: 17px !important;
+      }
+    }
+  </style>
+  <!-- Progressive Enhancements : END -->
+
+  <!-- What it does: Makes background images in 72ppi Outlook render at correct size. -->
+  <!--[if gte mso 9]>
+    <xml>
+        <o:OfficeDocumentSettings>
+            <o:AllowPNG/>
+            <o:PixelsPerInch>96</o:PixelsPerInch>
+        </o:OfficeDocumentSettings>
+    </xml>
+    <![endif]-->
+
+</head>
+
+<body width="100%" bgcolor="#222222" style="margin: 0; mso-line-height-rule: exactly;">
+  <center style="width: 100%; background: #fafafa; text-align: left;">
+
+    <!-- Email Header : BEGIN -->
+    <table role="presentation" cellspacing="0" cellpadding="0" border="0" align="center" width="600" style="margin: auto;" class="email-container" bgcolor="#1E1E1E">
+      <tr>
+        <td style="padding: 20px 0; text-align: center">
+          <a href="https://goldtuganime.com" target="_blank"><img src="https://upload.goldtuganime.com/redes-sociais/GTA_Logo_Newsletter.png" width="282" border="0" style="height: auto; font-family: sans-serif; font-size: 15px; line-height: 140%; color: #555555;"></a>
+        </td>
+      </tr>
+    </table>
+    <!-- Email Header : END -->
+
+    {MESSAGE}
+
+    <!-- Email Footer : BEGIN -->
+    <table role="presentation" bgcolor="#1E1E1E" cellspacing="0" cellpadding="0" border="0" align="center" width="100%" style="max-width: 600px; font-family: sans-serif; color: #888888; font-size: 11px; line-height: 140%;">
+      <tr>
+        <td style="padding: 10px 10px; width: 100%; font-family: sans-serif; font-size: 12px; line-height: 140%; text-align: center; color: #888888;" class="x-gmail-data-detectors">
+          <table width="300" border="0" cellspacing="10" cellpadding="10">
+            <tbody>
+              <tr>
+                <td><a href="https://www.facebook.com/goldtuganimeoficial/" target="_blank"><img src="https://upload.goldtuganime.com/redes-sociais/facebook-Y.png" height="24" width="24" class=""></a></td>
+                <td><a href="https://www.instagram.com/goldtuganime/" target="_blank"><img src="https://upload.goldtuganime.com/redes-sociais/instagram-Y.png" height="24" width="24" class=""></a></td>
+                <td><a href="https://discord.gg/Zk8CCZUG/" target="_blank"><img src="https://upload.goldtuganime.com/redes-sociais/discord-Y.png" height="24" width="24" class=""></a></td>
+                <td><a href="https://www.youtube.com/@GoldTugAnimeOFICIAL" target="_blank"><img src="https://upload.goldtuganime.com/redes-sociais/youtube-Y.png" height="24" width="24" class=""></a></td>
+                <td><a href="https://goldtuganime.com" target="_blank"><img src="https://upload.goldtuganime.com/redes-sociais/website-Y.png" height="24" width="24" class=""></a></td>
+              </tr>
+            </tbody>
+          </table>
+
+        </td>
+      </tr>
+    </table>
+    <table role="presentation" cellspacing="0" cellpadding="0" border="0" align="center" width="100%" style="max-width: 600px; font-family: sans-serif; color: #888888; font-size: 11px; line-height: 140%;">
+      <tr>
+        <td style="padding: 10px 10px; width: 100%; font-family: sans-serif; font-size: 12px; line-height: 140%; text-align: center; color: #888888;" class="x-gmail-data-detectors"><em>Copyright © 2023 | <a href="https://goldtuganime.com" target="_blank">GoldTugAnime</a> | Todos os direitos reservados.</em></td>
+      </tr>
+      <tr>
+        <td>
+          <table width="400" border="0" cellspacing="0" cellpadding="0">
+            <tbody>
+              <tr>
+                <td width="400" height="2" bgcolor="#CC9900" align="center" valign="bottom" style="padding: 0px;"></td>
+              </tr>
+            </tbody>
+          </table>
+        </td>
+      </tr>
+      <tr>
+        <td style="padding: 10px 10px; width: 100%; font-family: sans-serif; font-size: 8px; line-height: 140%; text-align: center; color: #888888;" class="x-gmail-data-detectors">Estás a receber este e-mail porque estás inscrito no nosso fórum. <a href="{NEWSLETTER_ONLINE}" target="_blank">Vê aqui</a> que newsletters já recebeste ou remove o teu endereço electrónico da nossa lista através do link <a href="{NEWSLETTER_OPTOUT}" target="_blank">remover subscrição</a>, caso pretendas.
+        </td>
+      </tr>
+    </table>
+    <!-- Email Footer : END -->
+  </center>
+</body>
+
+</html>
\ No newline at end of file
diff --git "[FORUM_EXT]/sitesplat\\newsletter/language/pt_preao/email/newsletter_txt.txt" "[FORUM_EXT]/sitesplat\\newsletter/language/pt_preao/email/newsletter_txt.txt"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\newsletter/language/pt_preao/email/newsletter_txt.txt"
@@ -0,0 +1,6 @@
+Subject: Newsletter de {SITENAME}
+
+{MESSAGE}
+
+Todas as newsletter: {NEWSLETTER_ONLINE}
+Não desejas continuar a receber a nossa newsletter? Clica aqui: {NEWSLETTER_OPTOUT}
\ No newline at end of file
diff --git "[FORUM_EXT]/sitesplat\\newsletter/language/pt_preao/email/newsoverview_html.txt" "[FORUM_EXT]/sitesplat\\newsletter/language/pt_preao/email/newsoverview_html.txt"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\newsletter/language/pt_preao/email/newsoverview_html.txt"
@@ -0,0 +1,961 @@
+Subject: Últimas Novidades "{SITENAME}"
+
+<html xmlns="http://www.w3.org/1999/xhtml" style="margin: 0;padding: 0;">
+<!--<![endif]-->
+
+<head>
+	<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
+	<!--[if !mso]><!-->
+	<meta content="IE=edge" http-equiv="X-UA-Compatible">
+	<!--<![endif]-->
+	<meta content="width=device-width" name="viewport">
+	<style type="text/css">
+		@media only screen and (min-width: 620px) {
+			* [lang=x-wrapper] h1 {
+				font-size: 26px !important;
+				line-height: 34px !important;
+			}
+			* [lang=x-wrapper] h2 {
+				font-size: 20px !important;
+				line-height: 28px !important;
+			}
+			* div [lang=x-size-8] {
+				font-size: 8px !important;
+				line-height: 14px !important;
+			}
+			* div [lang=x-size-9] {
+				font-size: 9px !important;
+				line-height: 16px !important;
+			}
+			* div [lang=x-size-10] {
+				font-size: 10px !important;
+				line-height: 18px !important;
+			}
+			* div [lang=x-size-11] {
+				font-size: 11px !important;
+				line-height: 19px !important;
+			}
+			* div [lang=x-size-12] {
+				font-size: 12px !important;
+				line-height: 19px !important;
+			}
+			* div [lang=x-size-13] {
+				font-size: 13px !important;
+				line-height: 21px !important;
+			}
+			* div [lang=x-size-14] {
+				font-size: 14px !important;
+				line-height: 21px !important;
+			}
+			* div [lang=x-size-15] {
+				font-size: 15px !important;
+				line-height: 23px !important;
+			}
+			* div [lang=x-size-16] {
+				font-size: 16px !important;
+				line-height: 24px !important;
+			}
+			* div [lang=x-size-17] {
+				font-size: 17px !important;
+				line-height: 26px !important;
+			}
+			* div [lang=x-size-18] {
+				font-size: 18px !important;
+				line-height: 26px !important;
+			}
+			* div [lang=x-size-18] {
+				font-size: 18px !important;
+				line-height: 26px !important;
+			}
+			* div [lang=x-size-20] {
+				font-size: 20px !important;
+				line-height: 28px !important;
+			}
+			* div [lang=x-size-22] {
+				font-size: 22px !important;
+				line-height: 31px !important;
+			}
+			* div [lang=x-size-24] {
+				font-size: 24px !important;
+				line-height: 32px !important;
+			}
+			* div [lang=x-size-26] {
+				font-size: 26px !important;
+				line-height: 34px !important;
+			}
+			* div [lang=x-size-28] {
+				font-size: 28px !important;
+				line-height: 36px !important;
+			}
+			* div [lang=x-size-30] {
+				font-size: 30px !important;
+				line-height: 38px !important;
+			}
+			* div [lang=x-size-32] {
+				font-size: 32px !important;
+				line-height: 40px !important;
+			}
+			* div [lang=x-size-34] {
+				font-size: 34px !important;
+				line-height: 43px !important;
+			}
+			* div [lang=x-size-36] {
+				font-size: 36px !important;
+				line-height: 43px !important;
+			}
+			* div [lang=x-size-40] {
+				font-size: 40px !important;
+				line-height: 47px !important;
+			}
+			* div [lang=x-size-44] {
+				font-size: 44px !important;
+				line-height: 50px !important;
+			}
+			* div [lang=x-size-48] {
+				font-size: 48px !important;
+				line-height: 54px !important;
+			}
+			* div [lang=x-size-56] {
+				font-size: 56px !important;
+				line-height: 60px !important;
+			}
+			* div [lang=x-size-64] {
+				font-size: 64px !important;
+				line-height: 63px !important;
+			}
+		}
+	</style>
+	<style type="text/css">
+		body {
+			margin: 0;
+			padding: 0;
+		}
+		
+		table {
+			border-collapse: collapse;
+			table-layout: fixed;
+		}
+		
+		* {
+			line-height: inherit;
+		}
+		
+		[x-apple-data-detectors],
+		[href^="tel"],
+		[href^="sms"] {
+			color: inherit !important;
+			text-decoration: none !important;
+		}
+		
+		.wrapper .footer__share-button a:hover,
+		.wrapper .footer__share-button a:focus {
+			color: #ffffff !important;
+		}
+		
+		.btn a:hover,
+		.btn a:focus,
+		.footer__share-button a:hover,
+		.footer__share-button a:focus,
+		.email-footer__links a:hover,
+		.email-footer__links a:focus {
+			opacity: 0.8;
+		}
+		
+		.ie .btn {
+			width: 100%;
+		}
+		
+		.ie .column,
+		[owa] .column,
+		.ie .gutter,
+		[owa] .gutter {
+			display: table-cell;
+			float: none !important;
+			vertical-align: top;
+		}
+		
+		.ie .preheader,
+		[owa] .preheader,
+		.ie .email-footer,
+		[owa] .email-footer {
+			width: 560px !important;
+		}
+		
+		.ie .snippet,
+		[owa] .snippet,
+		.ie .webversion,
+		[owa] .webversion {
+			width: 280px !important;
+		}
+		
+		.ie .header,
+		[owa] .header,
+		.ie .layout,
+		[owa] .layout,
+		.ie .one-col .column,
+		[owa] .one-col .column {
+			width: 600px !important;
+		}
+		
+		.ie .fixed-width.has-border,
+		[owa] .fixed-width.has-border,
+		.ie .has-gutter.has-border,
+		[owa] .has-gutter.has-border {
+			width: 602px !important;
+		}
+		
+		.ie .two-col .column,
+		[owa] .two-col .column {
+			width: 300px !important;
+		}
+		
+		.ie .three-col .column,
+		[owa] .three-col .column,
+		.ie .narrow,
+		[owa] .narrow {
+			width: 200px !important;
+		}
+		
+		.ie .wide,
+		[owa] .wide {
+			width: 400px !important;
+		}
+		
+		.ie .two-col.has-gutter .column,
+		[owa] .two-col.x_has-gutter .column {
+			width: 290px !important;
+		}
+		
+		.ie .three-col.has-gutter .column,
+		[owa] .three-col.x_has-gutter .column,
+		.ie .has-gutter .narrow,
+		[owa] .has-gutter .narrow {
+			width: 188px !important;
+		}
+		
+		.ie .has-gutter .wide,
+		[owa] .has-gutter .wide {
+			width: 394px !important;
+		}
+		
+		.ie .two-col.has-gutter.has-border .column,
+		[owa] .two-col.x_has-gutter.x_has-border .column {
+			width: 292px !important;
+		}
+		
+		.ie .three-col.has-gutter.has-border .column,
+		[owa] .three-col.x_has-gutter.x_has-border .column,
+		.ie .has-gutter.has-border .narrow,
+		[owa] .has-gutter.x_has-border .narrow {
+			width: 190px !important;
+		}
+		
+		.ie .has-gutter.has-border .wide,
+		[owa] .has-gutter.x_has-border .wide {
+			width: 396px !important;
+		}
+		
+		.ie .fixed-width .layout__inner {
+			border-left: 0 none white !important;
+			border-right: 0 none white !important;
+		}
+		
+		.ie .layout__edges {
+			display: none;
+		}
+		
+		.mso .layout__edges {
+			font-size: 0;
+		}
+		
+		.layout-fixed-width,
+		.mso .layout-full-width {
+			background-color: #ffffff;
+		}
+		
+		@media only screen and (min-width: 620px) {
+			.column,
+			.gutter {
+				display: table-cell;
+				Float: none !important;
+				vertical-align: top;
+			}
+			.preheader,
+			.email-footer {
+				width: 560px !important;
+			}
+			.snippet,
+			.webversion {
+				width: 280px !important;
+			}
+			.header,
+			.layout,
+			.one-col .column {
+				width: 600px !important;
+			}
+			.fixed-width.has-border,
+			.fixed-width.ecxhas-border,
+			.has-gutter.has-border,
+			.has-gutter.ecxhas-border {
+				width: 602px !important;
+			}
+			.two-col .column {
+				width: 300px !important;
+			}
+			.three-col .column,
+			.column.narrow {
+				width: 200px !important;
+			}
+			.column.wide {
+				width: 400px !important;
+			}
+			.two-col.has-gutter .column,
+			.two-col.ecxhas-gutter .column {
+				width: 290px !important;
+			}
+			.three-col.has-gutter .column,
+			.three-col.ecxhas-gutter .column,
+			.has-gutter .narrow {
+				width: 188px !important;
+			}
+			.has-gutter .wide {
+				width: 394px !important;
+			}
+			.two-col.has-gutter.has-border .column,
+			.two-col.ecxhas-gutter.ecxhas-border .column {
+				width: 292px !important;
+			}
+			.three-col.has-gutter.has-border .column,
+			.three-col.ecxhas-gutter.ecxhas-border .column,
+			.has-gutter.has-border .narrow,
+			.has-gutter.ecxhas-border .narrow {
+				width: 190px !important;
+			}
+			.has-gutter.has-border .wide,
+			.has-gutter.ecxhas-border .wide {
+				width: 396px !important;
+			}
+		}
+		
+		@media only screen and (-webkit-min-device-pixel-ratio: 2),
+		only screen and (min--moz-device-pixel-ratio: 2),
+		only screen and (-o-min-device-pixel-ratio: 2/1),
+		only screen and (min-device-pixel-ratio: 2),
+		only screen and (min-resolution: 192dpi),
+		only screen and (min-resolution: 2dppx) {
+			.fblike {
+				background-image: url(https://i3.createsend1.com/static/eb/master/13-the-blueprint-3/images/fblike@2x.png) !important;
+			}
+			.tweet {
+				background-image: url(https://i4.createsend1.com/static/eb/master/13-the-blueprint-3/images/tweet@2x.png) !important;
+			}
+			.linkedinshare {
+				background-image: url(https://i6.createsend1.com/static/eb/master/13-the-blueprint-3/images/lishare@2x.png) !important;
+			}
+			.forwardtoafriend {
+				background-image: url(https://i7.createsend1.com/static/eb/master/13-the-blueprint-3/images/forward@2x.png) !important;
+			}
+		}
+		
+		@media (max-width: 321px) {
+			.fixed-width.has-border .layout__inner {
+				border-width: 1px 0 !important;
+			}
+			.layout,
+			.column {
+				min-width: 320px !important;
+				width: 320px !important;
+			}
+			.border {
+				display: none;
+			}
+		}
+		
+		.mso div {
+			border: 0 none white !important;
+		}
+		
+		.mso .w560 .divider {
+			Margin-left: 260px !important;
+			Margin-right: 260px !important;
+		}
+		
+		.mso .w360 .divider {
+			Margin-left: 160px !important;
+			Margin-right: 160px !important;
+		}
+		
+		.mso .w260 .divider {
+			Margin-left: 110px !important;
+			Margin-right: 110px !important;
+		}
+		
+		.mso .w160 .divider {
+			Margin-left: 60px !important;
+			Margin-right: 60px !important;
+		}
+		
+		.mso .w354 .divider {
+			Margin-left: 157px !important;
+			Margin-right: 157px !important;
+		}
+		
+		.mso .w250 .divider {
+			Margin-left: 105px !important;
+			Margin-right: 105px !important;
+		}
+		
+		.mso .w148 .divider {
+			Margin-left: 54px !important;
+			Margin-right: 54px !important;
+		}
+		
+		.mso .font-avenir,
+		.mso .font-cabin,
+		.mso .font-open-sans,
+		.mso .font-ubuntu {
+			font-family: sans-serif !important;
+		}
+		
+		.mso .font-bitter,
+		.mso .font-merriweather,
+		.mso .font-pt-serif {
+			font-family: Georgia, serif !important;
+		}
+		
+		.mso .font-lato,
+		.mso .font-roboto {
+			font-family: Tahoma, sans-serif !important;
+		}
+		
+		.mso .font-pt-sans {
+			font-family: "Trebuchet MS", sans-serif !important;
+		}
+		
+		.mso .footer__share-button p {
+			margin: 0;
+		}
+		
+		@media only screen and (min-width: 620px) {
+			.wrapper .size-8 {
+				font-size: 8px !important;
+				line-height: 14px !important;
+			}
+			.wrapper .size-9 {
+				font-size: 9px !important;
+				line-height: 16px !important;
+			}
+			.wrapper .size-10 {
+				font-size: 10px !important;
+				line-height: 18px !important;
+			}
+			.wrapper .size-11 {
+				font-size: 11px !important;
+				line-height: 19px !important;
+			}
+			.wrapper .size-12 {
+				font-size: 12px !important;
+				line-height: 19px !important;
+			}
+			.wrapper .size-13 {
+				font-size: 13px !important;
+				line-height: 21px !important;
+			}
+			.wrapper .size-14 {
+				font-size: 14px !important;
+				line-height: 21px !important;
+			}
+			.wrapper .size-15 {
+				font-size: 15px !important;
+				line-height: 23px !important;
+			}
+			.wrapper .size-16 {
+				font-size: 16px !important;
+				line-height: 24px !important;
+			}
+			.wrapper .size-17 {
+				font-size: 17px !important;
+				line-height: 26px !important;
+			}
+			.wrapper .size-18 {
+				font-size: 18px !important;
+				line-height: 26px !important;
+			}
+			.wrapper .size-20 {
+				font-size: 20px !important;
+				line-height: 28px !important;
+			}
+			.wrapper .size-22 {
+				font-size: 22px !important;
+				line-height: 31px !important;
+			}
+			.wrapper .size-24 {
+				font-size: 24px !important;
+				line-height: 32px !important;
+			}
+			.wrapper .size-26 {
+				font-size: 26px !important;
+				line-height: 34px !important;
+			}
+			.wrapper .size-28 {
+				font-size: 28px !important;
+				line-height: 36px !important;
+			}
+			.wrapper .size-30 {
+				font-size: 30px !important;
+				line-height: 38px !important;
+			}
+			.wrapper .size-32 {
+				font-size: 32px !important;
+				line-height: 40px !important;
+			}
+			.wrapper .size-34 {
+				font-size: 34px !important;
+				line-height: 43px !important;
+			}
+			.wrapper .size-36 {
+				font-size: 36px !important;
+				line-height: 43px !important;
+			}
+			.wrapper .size-40 {
+				font-size: 40px !important;
+				line-height: 47px !important;
+			}
+			.wrapper .size-44 {
+				font-size: 44px !important;
+				line-height: 50px !important;
+			}
+			.wrapper .size-48 {
+				font-size: 48px !important;
+				line-height: 54px !important;
+			}
+			.wrapper .size-56 {
+				font-size: 56px !important;
+				line-height: 60px !important;
+			}
+			.wrapper .size-64 {
+				font-size: 64px !important;
+				line-height: 63px !important;
+			}
+		}
+		
+		.mso .size-8,
+		.ie .size-8 {
+			font-size: 8px !important;
+			line-height: 14px !important;
+		}
+		
+		.mso .size-9,
+		.ie .size-9 {
+			font-size: 9px !important;
+			line-height: 16px !important;
+		}
+		
+		.mso .size-10,
+		.ie .size-10 {
+			font-size: 10px !important;
+			line-height: 18px !important;
+		}
+		
+		.mso .size-11,
+		.ie .size-11 {
+			font-size: 11px !important;
+			line-height: 19px !important;
+		}
+		
+		.mso .size-12,
+		.ie .size-12 {
+			font-size: 12px !important;
+			line-height: 19px !important;
+		}
+		
+		.mso .size-13,
+		.ie .size-13 {
+			font-size: 13px !important;
+			line-height: 21px !important;
+		}
+		
+		.mso .size-14,
+		.ie .size-14 {
+			font-size: 14px !important;
+			line-height: 21px !important;
+		}
+		
+		.mso .size-15,
+		.ie .size-15 {
+			font-size: 15px !important;
+			line-height: 23px !important;
+		}
+		
+		.mso .size-16,
+		.ie .size-16 {
+			font-size: 16px !important;
+			line-height: 24px !important;
+		}
+		
+		.mso .size-17,
+		.ie .size-17 {
+			font-size: 17px !important;
+			line-height: 26px !important;
+		}
+		
+		.mso .size-18,
+		.ie .size-18 {
+			font-size: 18px !important;
+			line-height: 26px !important;
+		}
+		
+		.mso .size-20,
+		.ie .size-20 {
+			font-size: 20px !important;
+			line-height: 28px !important;
+		}
+		
+		.mso .size-22,
+		.ie .size-22 {
+			font-size: 22px !important;
+			line-height: 31px !important;
+		}
+		
+		.mso .size-24,
+		.ie .size-24 {
+			font-size: 24px !important;
+			line-height: 32px !important;
+		}
+		
+		.mso .size-26,
+		.ie .size-26 {
+			font-size: 26px !important;
+			line-height: 34px !important;
+		}
+		
+		.mso .size-28,
+		.ie .size-28 {
+			font-size: 28px !important;
+			line-height: 36px !important;
+		}
+		
+		.mso .size-30,
+		.ie .size-30 {
+			font-size: 30px !important;
+			line-height: 38px !important;
+		}
+		
+		.mso .size-32,
+		.ie .size-32 {
+			font-size: 32px !important;
+			line-height: 40px !important;
+		}
+		
+		.mso .size-34,
+		.ie .size-34 {
+			font-size: 34px !important;
+			line-height: 43px !important;
+		}
+		
+		.mso .size-36,
+		.ie .size-36 {
+			font-size: 36px !important;
+			line-height: 43px !important;
+		}
+		
+		.mso .size-40,
+		.ie .size-40 {
+			font-size: 40px !important;
+			line-height: 47px !important;
+		}
+		
+		.mso .size-44,
+		.ie .size-44 {
+			font-size: 44px !important;
+			line-height: 50px !important;
+		}
+		
+		.mso .size-48,
+		.ie .size-48 {
+			font-size: 48px !important;
+			line-height: 54px !important;
+		}
+		
+		.mso .size-56,
+		.ie .size-56 {
+			font-size: 56px !important;
+			line-height: 60px !important;
+		}
+		
+		.mso .size-64,
+		.ie .size-64 {
+			font-size: 64px !important;
+			line-height: 63px !important;
+		}
+		
+		.footer__share-button p {
+			margin: 0;
+		}
+	</style>
+
+	<title>{SITENAME}</title>
+	<!--[if !mso]><!-->
+	<style type="text/css">
+		@import url(https://fonts.googleapis.com/css?family=Bitter:400,700,400italic|Open+Sans:400italic,700italic,700,400);
+	</style>
+	<link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Bitter:400,700,400italic|Open+Sans:400italic,700italic,700,400">
+	<!--<![endif]-->
+	<style type="text/css">
+		body {
+			background-color: #f2f6f7
+		}
+		
+		.mso h1 {}
+		
+		.mso h1 {
+			font-family: Georgia, serif !important
+		}
+		
+		.mso h2 {}
+		
+		.mso h2 {
+			font-family: Georgia, serif !important
+		}
+		
+		.mso h3 {}
+		
+		.mso h3 {
+			font-family: Georgia, serif !important
+		}
+		
+		.mso .column,
+		.mso .column__background td {}
+		
+		.mso .column,
+		.mso .column__background td {
+			font-family: sans-serif !important
+		}
+		
+		.mso .btn a {}
+		
+		.mso .btn a {
+			font-family: sans-serif !important
+		}
+		
+		.mso .webversion,
+		.mso .snippet,
+		.mso .layout-email-footer td,
+		.mso .footer__share-button p {}
+		
+		.mso .webversion,
+		.mso .snippet,
+		.mso .layout-email-footer td,
+		.mso .footer__share-button p {
+			font-family: sans-serif !important
+		}
+		
+		.mso .logo {}
+		
+		.mso .logo {
+			font-family: Tahoma, sans-serif !important
+		}
+		
+		.logo a:hover,
+		.logo a:focus {
+			color: #859bb1 !important
+		}
+		
+		.mso .layout-has-border {
+			border-top: 1px solid #b3cad0;
+			border-bottom: 1px solid #b3cad0
+		}
+		
+		.mso .layout-has-bottom-border {
+			border-bottom: 1px solid #b3cad0
+		}
+		
+		.mso .border,
+		.ie .border {
+			background-color: #b3cad0
+		}
+		
+		@media only screen and (min-width: 620px) {
+			.wrapper h1 {}
+			.wrapper h1 {
+				font-size: 26px !important;
+				line-height: 34px !important
+			}
+			.wrapper h2 {}
+			.wrapper h2 {
+				font-size: 20px !important;
+				line-height: 28px !important
+			}
+			.wrapper h3 {}
+			.column,
+			.column__background td {}
+		}
+		
+		.mso h1,
+		.ie h1 {}
+		
+		.mso h1,
+		.ie h1 {
+			font-size: 26px !important;
+			line-height: 34px !important
+		}
+		
+		.mso h2,
+		.ie h2 {}
+		
+		.mso h2,
+		.ie h2 {
+			font-size: 20px !important;
+			line-height: 28px !important
+		}
+		
+		.mso h3,
+		.ie h3 {}
+		
+		.mso .column,
+		.ie .column,
+		.mso .column__background td,
+		.ie .column__background td {}
+	</style>
+</head>
+<!--[if mso]>
+	<body class="mso">
+<![endif]-->
+<!--[if !mso]><!-->
+
+<body style="margin: 0;padding: 0;-webkit-text-size-adjust: 100%;" class="full-padding">
+	<!--<![endif]-->
+	<div lang="x-wrapper" style="min-width: 320px;background-color: #f2f6f7;" class="wrapper">
+		<div style="Margin: 0 auto;max-width: 560px;min-width: 280px; width: 280px;width: calc(28000% - 173040px);" class="preheader">
+			<div style="border-collapse: collapse;display: table;width: 100%;">
+				<!--[if (mso)|(IE)]><table align="center" class="preheader" cellpadding="0" cellspacing="0"><tr><td style="width: 280px" valign="top"><![endif]-->
+				<div style="Float: left;font-size: 12px;line-height: 19px;max-width: 280px;min-width: 140px; width: 140px;width: calc(14000% - 78120px);padding: 10px 0 5px 0;color: #99b0b8;font-family: &quot;Open Sans&quot;,sans-serif;" class="snippet">
+
+				</div>
+				<!--[if (mso)|(IE)]></td><td style="width: 280px" valign="top"><![endif]-->
+				<div style="Float: left;font-size: 12px;line-height: 19px;max-width: 280px;min-width: 139px; width: 139px;width: calc(14100% - 78680px);padding: 10px 0 5px 0;text-align: right;color: #99b0b8;font-family: &quot;Open Sans&quot;,sans-serif;" class="webversion">
+
+				</div>
+				<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
+			</div>
+		</div>
+		<div id="emb-email-header-container" style="Margin: 0 auto;max-width: 600px;min-width: 320px; width: 320px;width: calc(28000% - 173000px);" class="header">
+			<!--[if (mso)|(IE)]><table align="center" class="header" cellpadding="0" cellspacing="0"><tr><td style="width: 600px"><![endif]-->
+			<div align="center" style="font-size: 26px;line-height: 32px;Margin-top: 6px;Margin-bottom: 20px;color: #c3ced9;font-family: Roboto,Tahoma,sans-serif;Margin-left: 20px;Margin-right: 20px;" class="logo emb-logo-margin-box">
+				<div align="center" id="emb-email-header" style="font-size:0px !important;line-height:0 !important;" class="logo-center">
+					<img width="141" alt="" src="{SITE_LOGO_IMG}" style="height: auto;width: 100%;border: 0;max-width: 141px;">
+				</div>
+			</div>
+			<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
+		</div>
+		<div style="Margin: 0 auto;max-width: 600px;min-width: 320px; width: 320px;width: calc(28000% - 173000px);overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;" class="layout one-col fixed-width">
+			<div emb-background-style="" style="border-collapse: collapse;display: table;width: 100%;background-color: #ffffff;" class="layout__inner">
+				<!--[if (mso)|(IE)]><table align="center" cellpadding="0" cellspacing="0"><tr class="layout-fixed-width" emb-background-style><td style="width: 600px" class="w560"><![endif]-->
+				<div style="text-align: left;color: #808285;font-size: 14px;line-height: 21px;font-family: &quot;Open Sans&quot;,sans-serif;max-width: 600px;min-width: 320px; width: 320px;width: calc(28000% - 167400px);" class="column">
+
+					<div style="Margin-left: 20px;Margin-right: 20px;Margin-top: 24px;">
+						<div style="line-height:10px;font-size:1px">&nbsp;</div>
+					</div>
+
+					<div style="Margin-left: 20px;Margin-right: 20px;">
+						<div style="line-height:5px;font-size:1px">&nbsp;</div>
+					</div>
+
+					<div style="Margin-left: 20px;Margin-right: 20px;">
+						<h1 style="Margin-top: 0;Margin-bottom: 20px;font-style: normal;font-weight: normal;color: #58595b;font-size: 22px;line-height: 31px;font-family: Bitter,Georgia,serif;text-align: center;">Last Topics While You Were Away</h1>
+					</div>
+
+					<div style="Margin-left: 20px;Margin-right: 20px;">
+						<div style="display: block;font-size: 2px;line-height: 2px;Margin-left: auto;Margin-right: auto;width: 40px;background-color: #b3cad0;Margin-bottom: 20px;" class="divider">&nbsp;</div>
+					</div>
+
+					<div style="Margin-left: 20px;Margin-right: 20px;">
+						<p style="Margin-top: 0;Margin-bottom: 20px;text-align: center;">Enquanto estiveste fora a laurear a pevide, houve nova actividade no fórum. Vê a nova tendência. Estamos animados para te ver novamente!</p>
+					    <p style="Margin-top: 10px;Margin-bottom: 20px;text-align: center;">{EMAIL_SIG}</p>
+					</div>
+
+					<div style="Margin-left: 20px;Margin-right: 20px;">
+						<div style="line-height:10px;font-size:1px">&nbsp;</div>
+					</div>
+
+					<div style="Margin-left: 20px;Margin-right: 20px;">
+						<div style="Margin-bottom: 20px;text-align: center;" class="btn btn--flat btn--large">
+							<!--[if !mso]--><a href="{BOARD_URL}" style="border-radius: 4px;display: inline-block;font-size: 14px;font-weight: bold;line-height: 24px;padding: 12px 24px;text-align: center;text-decoration: none !important;transition: opacity 0.1s ease-in;color: #60686b;background-color: #becdd1;font-family: 'Open Sans', sans-serif;"
+							target="_blank">Comunidade GoldTugAnime</a>
+							<!--[endif]-->
+							<!--[if mso]><p style="line-height:0;margin:0;">&nbsp;</p><v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" href="{BOARD_URL}" style="width:167px" arcsize="9%" fillcolor="#BECDD1" stroke="f"><v:textbox style="mso-fit-shape-to-text:t" inset="0px,11px,0px,11px"><center style="font-size:14px;line-height:24px;color:#60686B;font-family:sans-serif;font-weight:bold;mso-line-height-rule:exactly;mso-text-raise:4px">Discussion Board</center></v:textbox></v:roundrect><![endif]-->
+						</div>
+					</div>
+
+					<div style="Margin-left: 20px;Margin-right: 20px;Margin-bottom: 24px;">
+						<div style="line-height:15px;font-size:1px">&nbsp;</div>
+					</div>
+
+				</div>
+				<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
+			</div>
+		</div>
+
+		<div style="line-height:20px;font-size:20px;">&nbsp;</div>
+
+		<div style="Margin: 0 auto;max-width: 600px;min-width: 320px; width: 320px;width: calc(28000% - 173000px);overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;" class="layout one-col fixed-width">
+			<div emb-background-style="" style="border-collapse: collapse;display: table;width: 100%;background-color: #ffffff;" class="layout__inner">
+				<!--[if (mso)|(IE)]><table align="center" cellpadding="0" cellspacing="0"><tr class="layout-fixed-width" emb-background-style><td style="width: 600px" class="w560"><![endif]-->
+				<div style="text-align: left;color: #808285;font-size: 14px;line-height: 21px;font-family: &quot;Open Sans&quot;,sans-serif;max-width: 600px;min-width: 320px; width: 320px;width: calc(28000% - 167400px);" class="column">
+
+					<div style="Margin-left: 20px;Margin-right: 20px;Margin-top: 24px;Margin-bottom: 24px;">
+<!-- BEGIN mailrow -->
+						<p style="Margin-top: 0;Margin-bottom: 0;"><a href="{mailrow.U_TOPIC}" style="text-decoration: underline;transition: opacity 0.1s ease-in;color: #60686b;" target="_blank">{mailrow.TOPIC} em: {mailrow.FORUMS}</a></p>
+<!-- END mailrow -->
+						<p style="Margin-top: 20px;Margin-bottom: 0;">&nbsp;</p>
+					</div>
+
+				</div>
+				<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
+			</div>
+		</div>
+
+		<div style="line-height:20px;font-size:20px;">&nbsp;</div>
+
+		<div style="Margin: 0 auto;max-width: 600px;min-width: 320px; width: 320px;width: calc(28000% - 173000px);overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;" class="layout email-footer">
+			<div style="border-collapse: collapse;display: table;width: 100%;" class="layout__inner">
+				<!--[if (mso)|(IE)]><table align="center" cellpadding="0" cellspacing="0"><tr class="layout-email-footer"><td style="width: 400px;" valign="top" class="w360"><![endif]-->
+				<div style="text-align: left;font-size: 12px;line-height: 19px;color: #99b0b8;font-family: &quot;Open Sans&quot;,sans-serif;Float: left;max-width: 400px;min-width: 320px; width: 320px;width: calc(8000% - 47600px);" class="column wide">
+					<div style="Margin-left: 20px;Margin-right: 20px;Margin-top: 10px;Margin-bottom: 10px;">
+
+						<div>
+
+						</div>
+						<div style="Margin-top: 18px;">
+
+						</div>
+					</div>
+				</div>
+				<!--[if (mso)|(IE)]></td><td style="width: 200px;" valign="top" class="w160"><![endif]-->
+				<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
+			</div>
+		</div>
+		<div style="Margin: 0 auto;max-width: 600px;min-width: 320px; width: 320px;width: calc(28000% - 173000px);overflow-wrap: break-word;word-wrap: break-word;word-break: break-word;" class="layout one-col email-footer">
+			<div style="border-collapse: collapse;display: table;width: 100%;" class="layout__inner">
+				<!--[if (mso)|(IE)]><table align="center" cellpadding="0" cellspacing="0"><tr class="layout-email-footer"><td style="width: 600px;" class="w560"><![endif]-->
+				<div style="text-align: center;font-size: 12px;line-height: 19px;color: #99b0b8;font-family: &quot;Open Sans&quot;,sans-serif;max-width: 600px;min-width: 320px; width: 320px;width: calc(28000% - 167400px);" class="column">
+					<div style="Margin-left: 20px;Margin-right: 20px;Margin-top: 10px;Margin-bottom: 10px;">
+						<div>
+							<span>
+              <a lang="en" href="{U_BOARD}" style="text-decoration: underline;transition: opacity 0.1s ease-in;color: #99b0b8;" target="_blank">Preferências</a>
+              &nbsp;&nbsp;|&nbsp;&nbsp;
+            </span>
+              <a href="{NEWSLETTER_OPTOUT}" style="text-decoration: underline;transition: opacity 0.1s ease-in;color: #99b0b8;" target="_blank">Cancelar Subscrição</a>
+						</div>
+					</div>
+				</div>
+				<!--[if (mso)|(IE)]></td></tr></table><![endif]-->
+			</div>
+		</div>
+		<div style="line-height:40px;font-size:40px;">&nbsp;</div>
+
+	</div>
+
+</body>
+
+</html>
\ No newline at end of file
diff --git "[FORUM_EXT]/sitesplat\\newsletter/language/pt_preao/email/newsoverview_txt.txt" "[FORUM_EXT]/sitesplat\\newsletter/language/pt_preao/email/newsoverview_txt.txt"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\newsletter/language/pt_preao/email/newsoverview_txt.txt"
@@ -0,0 +1,17 @@
+Subject: Latest topic at "{SITENAME}"
+
+{SITENAME}
+
+Latest Topics
+Hi,
+It's time for another newsletter.
+We look forward to see you at {BOARD_URL} again.
+
+Forum				Topic
+<!-- BEGIN mailrow -->
+{mailrow.U_FORUM}				{mailrow.U_TOPIC}
+<!-- END mailrow -->
+
+
+{EMAIL_SIG}
+Don't want to receive our newsletter anymore, click here {NEWSLETTER_OPTOUT}
\ No newline at end of file
diff --git "[FORUM_EXT]/sitesplat\\newsletter/language/pt_preao/info_acp_newsletter.php" "[FORUM_EXT]/sitesplat\\newsletter/language/pt_preao/info_acp_newsletter.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\newsletter/language/pt_preao/info_acp_newsletter.php"
@@ -0,0 +1,181 @@
+<?php
+/**
+*
+* @package BBnewsletter
+* @copyright (c) 2016 SiteSplat All rights reserved
+* @license Proprietary
+*
+*/
+
+if (!defined('IN_PHPBB'))
+{
+	exit;
+}
+
+if (empty($lang) || !is_array($lang))
+{
+	$lang = array();
+}
+
+$lang = array_merge($lang, array(
+	'ACP_NEWSLETTER'			=> 'Newsletter',
+	'ACP_NEWSLETTER_EXPLAIN'	=> 'Setup your Newsletter, several options are available below. Please make sure your mailserver accepts all mails, otherwise it will use phpbb\'s mail settings to send emails in small batches. <br />The weekly and monthly "Catch-up" forum news are sent out by the cron task. Install <a href="https://github.com/ForumHulp/cronstatus" target="_blank">Cronstatus extension</a> and select "Run cron always" in the options to run more often the "Catch-up" News (This is especially useful for small forums). <br />For HTML e-mails install <a href=" https://github.com/ForumHulp/htmlemail" target="_blank">HTML emails Extension</a> which enables the HTML settings.<br />',
+    'FORUMS_NEWS_FROM'		    => 'Newsletter forum source',
+	'FORUMS_FROM_EXPLAIN'		=> 'Select the forums you would like the users to receive the news from',
+	'SEND_IMMEDIATELY'			=> 'Send immediately',
+	'SEND_IMMEDIATELY_EXPLAIN'	=> 'Attempt to send the emails immediately. This depends on the server email configuration parameters',
+	'PERIOD'					=> 'Email Overview (or Catch-up) Period',
+	'PERIOD_EXPLAIN'			=> 'This will send automatic "Catch-up"  emails to the users that are subscribed. The e-mail will be generated based on the new topics in the forum. The user will receive an email with the purpose of engaging the user\'s interest in the recent board\'s activity. Edit the templates file named newsletter_html.txt for the HTML version and newsletter_txt.txt for the TXT version from:<br /> <code>root\ext\sitesplat\newsletter\language\en\email\</code> <br /> To learn how to send out professional looking HTML emails check out the tutorials over at <a href=" https://sitesplat.com/" target="_blank">sitesplat.com</a> or click the "Tutorials" label above.',
+	'WEEKLY'					=> 'Weekly',
+	'MONTHLY'					=> 'Monthly',
+	'NO_OVERVIEW'				=> 'None',
+	'PERIOD_SEND'				=> 'Set period for automatic newsletter',
+	'SEND_TO_GROUP'				=> 'Send to group',
+	'SEND_TO_USERS'				=> 'Send to user(s)',
+	'SEND_TO_USERS_EXPLAIN'		=> 'When using this field it will override the "Send to Group" option above. Each user on a new line',
+	'ALL_USERS'					=> 'All users',
+	'NEW_USER'					=> 'Allow new users',
+	'MAIL_LOW_PRIORITY'			=> 'Low',
+	'MAIL_NORMAL_PRIORITY'		=> 'Normal',
+	'MAIL_HIGH_PRIORITY'		=> 'High',
+	'MAIL_PRIORITY'				=> 'Mail priority',
+	'USE_HTML'					=> 'Use HTML emails',
+	'COMPOSE_HTML'				=> 'Send manually',
+	'COMPOSE_HTML_EXPLAIN'		=> 'If "Send manually" is selected the HTML editor will be available to send custom emails in HTML format',
+	'MASS_MESSAGE'				=> 'Message (Newsletter Body)',
+	'MASS_MESSAGE_EXPLAIN'		=> 'HTML message will be stripped if HTML email Extension is not enabled. To use the HTML editor click on "Tools" then "Source code" and enter the HTML code in the code editor ',
+	'FHHTML_EMAIL_NOT_ENABLED'	=> 'HTML email extension not enabled. Download it from https://github.com/ForumHulp/htmlemail',
+	'FHHTML_EMAIL_DOWNLOAD'	    => 'HTML email Extension not enabled. Download it from <a href="https://github.com/ForumHulp/htmlemail" target="blank">GithHub HTML Email Ext</a>',
+	'LAST_SEND'					=> '<span id="viewsubscribers" class="label label-info" title="View subscribers">%1$s Members</span> subscribed, last letter was sent on <strong class="text-info">%2$s</strong>',
+	'LAST_SEND_LETTERS'			=> 'Last newsletters',
+	'LAST_SEND_EXPLAIN'			=> '**Please note, new registered users are automatically subscribed. (Click "X Members" above to view the users list)',
+	'LAST_NEWSLETTERS_EXPLAIN'	=> '**Please note, the following template visualized on the single emails below does NOT reflect 100% the email that was sent out. This is due to phpBB\'s ACP stylesheet obsolete CSS reset rules. Refer to your email copy or front-end archive for the exact email accuracy.<br /> This is a list with the sole purpose of keeping track of the emails and users in a simple manner.<br />Always save a copy of the composed HTML email before sending it out if you wish to re-use it in the future.',
+	'NEWS_PAGE'					=> 'Visible',
+	'HIDE'						=> 'Hide',
+	'SHOW'						=> 'Show',
+	'DELETE_MAIL_SUCCES'		=> 'Newsletter deleted',
+	'ACP_NEWSOVERVIEW_SEND'		=> 'Newsletter(s) sent successfully',
+	'ACP_NEWSOVERVIEW_SAVED'	=> 'Settings saved successfully',
+	
+	'SITESPLAT_COM'		        => 'https://sitesplat.com',
+	'SITESPLAT_COPY'		    => '&#169; SiteSplat',
+	'LICENSE_INFO'		        => 'Proprietary - SiteSplat All rights reserved',
+	'EXTENSION_DEVELOPER'	    => 'Developer',
+	'ACP_NOTICE_CLOSE'			=> 'Close',
+	'ACP_NEWS_VERSION'          => '1.0.5',
+	'ACP_LOADING'		        => 'Loading... Hold on',
+	'FORUM_CONTENT'		        => 'forum content',
+	'EXT_NEWS_DESCRIPTION_PAGE'	=> 'A Newsletter system with an archive, weekly, monthly and many more options to run your own HTML style newsletter like a pro!',
+	'EXT_NEWS_TASKS_1'			=> 'Newsletter Archive',
+	'EXT_NEWS_TASKS_2'			=> 'Full HTML Enabled',
+	'EXT_NEWS_TASKS_3'			=> 'Synchronization with Cron tasks and compatible with <a href="https://www.phpbb.com/customise/db/extension/cronstatus/">Cron Status</a>',
+	'EXT_NEWS_TASKS_4'			=> 'Scheduled Newsletter',
+	'EXT_NEWS_TASKS_5'			=> 'Checkout the other premium addons on <a href="https://sitesplat.com/phpBB3/marketplace.php">sitesplat.com/marketplace.php</a>',
+	'EXT_NEWS_TASKS_6'			=> 'phpBB 3.2 ready',
+
+	'NEWS_SUBSCRIBERS_INFO'     => 'Subscribers and news info',
+	'NEWS_TRICKS_TITLE'         => 'Tips and Tricks',
+	'ACP_NEWS_TRICK_EXPLAIN'	=> '<p>Does your ISP limit the number of emails you can send each day?</p>
+									<p><strong>Of course they do!</strong>
+									</p>
+									<p>Every outgoing SMTP mail server is guided by a provider’s email policy which includes hourly and/or daily email send limits. This policy will ultimately determine how many emails you can send each day. You can find a list of the hourly and daily send limits for most of the major ISPs, web hosting companies and Free email address providers below.</p>
+									<p><strong><a title="Email sending limits for isp, web hosting and free email providers" href="http://group-mail.com/sending-email/email-sending-limits-for-isp-web-hosting-and-free-email-providers/">Email Sending Limits of ISP, Web Hosting and Free Email Providers</a></strong>
+									</p>
+									<p>If you try to send more email than the hourly or daily email sending limits of your mail server, you will notice errors being returned after the specified quota is met, saying something along the lines of:<em> </em>
+									</p>
+									<blockquote>
+										<p><em>you have reached your daily sending quota</em>…</p>
+									</blockquote>
+									<p>If you surpass the daily <a title="SMTP email sending limits" href="http://group-mail.com/sending-email/email-sending-limits-for-isp-web-hosting-and-free-email-providers/">SMTP email sending limits</a> of your provider, you will generally have to wait 24 hours before you can send more email through that particular server.</p>
+									<p>But, what are the hourly or daily email sending limits for <em>your</em> email server?</p>
+									<ul>
+										<li>The Gmail mail server send limit is approximately 100-150 emails per day when connected to the server from a remote email client. You can send 500 emails each day through the Gmail SMTP server when logged into their web interface.</li>
+										<li>The Comcast mail server limits residential customers to send 1,000 messages per day. Comcast Business customers can send 24,000 emails per day through the Comcast outgoing SMTP mail server.</li>
+										<li>The basic GoDaddy email server limits senders to send&nbsp; only 250 outgoing emails per day, but you can <a title="send more email by adding SMTP relays to your GoDaddy account" href="http://group-mail.com/sending-email/how-to-increase-your-godaddy-email-sending-limits/">send more email by adding SMTP relays to your GoDaddy account</a>
+										</li>
+									</ul>
+									<p>&nbsp;</p>
+									<p>So, what’s a guy to do if he needs to get his monthly email newsletter out to 5,000 eager subscribers but his ISP has a daily send limit of 500 emails per day?</p>
+									<p><strong>What can you do if your mail server has limits that don’t support the size of your mailing list?</strong>
+									</p>
+									<p>If your current outgoing SMTP email server does not support your email list size or sending frequency, you have a variety of options:</p>
+									<p style="padding-left: 30px;">1. Contact the host of your outgoing SMTP mail server(s) and ask if they have a business account that lets you send more emails each day to support your business.</p>
+									<p style="padding-left: 30px;">2. Use GroupMail’s <a title="sending email without an external SMTP mail server" href="http://group-mail.com/sending-email/sending-email-without-an-external-smtp-mail-server/">Direct Send option</a>, which allows you to bypass your external SMTP server altogether and send email directly from your computer to your recipients using GroupMail’s own internal SMTP engine.</p>
+									<p style="padding-left: 30px;">3. Use an outgoing SMTP service like <a title="SMTP2Go outgoing relay pricing" href="http://groupmail.smtp2go.com">SMTP2Go</a> to relay your large email campaigns.</p>
+									<p style="padding-left: 30px;">4. Find a web hosting company who has daily email sending limits that meet your needs.</p>
+									<p style="padding-left: 30px;">5. Setup your own <a href="http://www.msexchange.org/tutorials/MF002.html">MS Exchange Server</a> and configure it for SMTP email delivery.</p>
+									<p>So, while GroupMail allows you to send and manage email lists of an <strong>unlimited</strong> size; the success of email delivery to large groups is ultimately dependent upon the sending limits set forth in the email sending policy of the SMTP mail server you are using.</p>
+									<p><strong>Related articles you might find interesting:</strong>
+									</p>
+									<p><a title="email sending limits of ISPs web hosting and free email providers" href="http://group-mail.com/sending-email/email-sending-limits-for-isp-web-hosting-and-free-email-providers/">Email Sending Limits for ISPs, Web Hosting and Free Email Providers</a>
+									</p>
+									<p><a title="Common email error code descriptions and fixes" href="http://group-mail.com/email-error-codes/common-email-error-codes/">Common Email Error Code Descriptions and Fixes</a>
+									</p>
+									<p><a title="Free Email Newsletter and Marketing Software and Services" href="http://group-mail.com/email-marketing/free-email-newsletter-and-marketing-software-and-services/">Free Email Newsletter and Marketing Software and Services</a>
+									</p>
+									<p><a title="Email Settings for the Most Common Email Server hosts" href="http://group-mail.com/category/email-settings/">Email Settings for the Most Common Email Server Hosts</a>
+									</p>
+									<p><a title="step by step guide for email setup and delivery" href="http://group-mail.com/getting-started-with-groupmail/step-by-step-guide-for-email-setup-and-delivery/">Step-by-Step Guide for Email Setup and Delivery</a>
+									</p>
+									<p>&nbsp;</p>
+									<hr>
+									<p></p>',
+	
+	'EXT_NEWS_TUTORIALS_TITLE'  => 'Tutorials',
+	'EXT_NEWS_TUTORIALS_EXPLAIN'=> '<li><p>Templates</p>
+					<ul>
+					<li><a href="http://htmlemailboilerplate.com/" target="_blank"><strong>HTML Email Boilerplate</strong></a>: A great <strong>starting point</strong> for coding emails.</li>
+					<li><a href="http://www.campaignmonitor.com/templates/" target="_blank"><strong>Campaign Monitor Templates</strong></a>: Template builder + free downloadable templates</li>
+					</ul>
+					</li>
+					
+					<li><p>Tutorials &amp; Guides</p>
+
+					<ul>
+					<li><a href="http://kb.mailchimp.com/article/how-to-code-html-emails" target="_blank"><strong>How To Code HTML Emails (Mailchimp)</strong></a>: How HTML email works, basic concepts, best practices, tips and tricks</li>
+					<li><a href="http://www.smashingmagazine.com/2010/01/19/design-and-build-an-email-newsletter-without-losing-your-mind/" target="_blank"><strong>Design and Build Email Newsletters Without Losing Your Mind (and Soul)</strong></a>:  information you need to plan, design and build an HTML newsletter that renders well</li>
+					<li><a href="http://mailchimp.com/resources/guides/email-marketing-field-guide/html/" target="_blank"><strong>Email Marketing Field Guide (Mailchimp)</strong></a></li>
+					<li><a href="http://mattmedia.net/2007/08/23/8-html-email-tips-i-wish-i-knew-sooner/" target="_blank"><strong>8 HTML Email Tips I Wish I’d Known Sooner</strong></a></li>
+					<li><a href="http://www.campaignmonitor.com/css/" target="_blank"><strong>The Ultimate Guide</a>: From Campaign Monitor</strong></li>
+					<li><a href="http://css-tricks.com/using-css-in-html-emails-the-real-story/" target="_blank"><strong>CSS Tricks: Using CSS in HTML Emails</strong></a>: Some "I told you so"\'s and tips about HTML emails and CSS.</li>
+					</ul>
+					</li>
+					
+					<li><p>Testing</p>
+
+					<ul>
+					<li><a href="http://www.emailonacid.com/" target="_blank"><strong>Email on Acid</strong></a>: Free and paid testing</li>
+					<li><a href="http://litmus.com/" target="_blank"><strong>Litmus</strong></a></li>
+					</ul>
+					</li>
+					
+					<li><p>Other Resources</p>
+
+					<ul>
+					<li><a href="http://www.campaignmonitor.com/resources/will-it-work/email-clients/" target="_blank"><strong>Campaign Monitor\'s Popular E-Mail Clients</strong></a></li>
+					</ul>
+					</li>',
+	
+	
+	'NEWSLETTER_NOTICE'			=> '<div class="phpinfo"><p>The settings for this extension are under <strong>%1$s &#187; %2$s &#187; %3$s</strong>. <br />Please note, at first setup when the period is set (for example weekly) and the format (HTML) the first automatic newsletter overview is sent out immediately right after the settings are saved! <br />This is needed to start the Synchronization. With this in mind, consider using a test board before using the extension to make sure the end result of the newlsetter is the preferred look.</p></div>',
+	'SS_HELPER_NOTY'			=> 'SiteSplat BBcore does not exist!<br />Download the <a href="https://sitesplat.com" target="_blank">BBcore</a> and copy the BBcore folder into your sitesplat extension folder.',
+));
+
+// Description of Donations extension
+$lang = array_merge($lang, array(
+	'DESCRIPTION_PAGE'		=> 'Description',
+	'DESCRIPTION_NOTICE'	=> 'Extension note',
+	'ext_details' => array(
+		'details' => array(
+			'DESCRIPTION_1'	=> 'HTML newsletter',
+			'DESCRIPTION_2'	=> 'Groupselect',
+			'DESCRIPTION_3'	=> 'Weekly / monthly news overview',
+			'DESCRIPTION_4'	=> 'Send immediately or in batch',
+			'DESCRIPTION_5'	=> 'Overview subscribers',
+		),
+		'note' => array(
+			'NOTICE_1'		=> '<a href="https://github.com/ForumHulp/htmlemail" target="_blank">HTML email extension</a> is needed to enable the HTML settings.',
+			'NOTICE_2'		=> 'phpBB 3.2 ready'
+		)
+	)
+));
diff --git "[FORUM_EXT]/sitesplat\\newsletter/language/pt_preao/newsletter.php" "[FORUM_EXT]/sitesplat\\newsletter/language/pt_preao/newsletter.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\newsletter/language/pt_preao/newsletter.php"
@@ -0,0 +1,40 @@
+<?php
+/**
+*
+* @package BBnewsletter
+* @copyright (c) 2016 SiteSplat All rights reserved
+* @license Proprietary
+*
+*/
+
+if (!defined('IN_PHPBB'))
+{
+	exit;
+}
+
+if (empty($lang) || !is_array($lang))
+{
+	$lang = array();
+}
+
+$lang = array_merge($lang, array(
+	'NEWSLETTER'				=> 'Newsletter',
+	'OVERVIEW'					=> 'Welcome to our Newsletter! :-) On this page you will find the latest Newsletters as well as the past years archives.',
+
+	'SUBSCRIBE_NO'				=> 'I do NOT want to receive the Newsletter anymore',
+	'SUBSCRIBE_YES'				=> 'Yes I want to receive the Newsletter',
+	'SUBSCRIBE_BTN_NO'			=> 'Cancel',
+	'SUBSCRIBE_BTN_YES'			=> 'Subscribe',
+	'SUBSCRIBE_CONFIRM_NO'		=> 'Please submit to cancel your subscription',
+	'SUBSCRIBE_CONFIRM_YES'		=> 'Please submit to confirm your subscription',
+
+	'SUBSCRIBE_Y_EMAIL'			=> 'Your email',
+	'SUBSCRIBE'					=> 'Subscribe to',
+	'UNSUBSCRIBE'				=> 'Unsubscribe from',
+	'SUBSCRIBE_INFO'			=> 'Our newsletter. Unsubscribed members won\'t receive our periodic News overview anymore.',
+	
+	'OVERVIEW_ARCHIVE'			=> 'Archive',
+	'ARCHIVES'					=> 'Archives',
+	'SUBSCRIBED'				=> 'Thanks for subscribing! You will receive our newsletter from today on!',
+	'UNSUBSCRIBED'				=> 'Successfully unsubscribed, you won\'t receive our newsletter any longer'
+));
diff --git "[ORIGINAL]/sitesplat\\newsletter/styles/FLATBOOTS/template/newsletter.html" "[FORUM_EXT]/sitesplat\\newsletter/styles/FLATBOOTS/template/newsletter.html"
--- "[ORIGINAL]/sitesplat\\newsletter/styles/FLATBOOTS/template/newsletter.html"
+++ "[FORUM_EXT]/sitesplat\\newsletter/styles/FLATBOOTS/template/newsletter.html"
@@ -4,7 +4,9 @@
 <!-- ENDIF -->
 
 <!-- IF not S_MAIL_VIEW -->
-<div class="side-segment"><h3>{L_NEWSLETTER}</h3></div>
+<div class="side-segment">
+	<h3>{L_NEWSLETTER}</h3>
+</div>
 <div class="row">
 	<div class="col-md-8">
 		<div class="panel panel-default">
@@ -17,7 +19,7 @@
 				</ul>
 
 				<!-- IF S_ARCHIVES -->
-          <p><strong>{L_ARCHIEVES}{L_COLON}</strong></p>
+				<p><strong>{L_ARCHIVES}{L_COLON}</strong></p>
 				<!-- BEGIN archiverow -->
 				<!-- IF archiverow.S_ROW_COUNT > 0 -->
 				<a class="inline" data-toggle="collapse" href="#month_{archiverow.S_ROW_COUNT}"><i id="month_image_{archiverow.S_ROW_COUNT}" class="fa <!-- IF archiverow.S_ROW_COUNT >= 0 -->fa-bar-chart-o" <!-- ELSE -->fa-bar-chart"<!-- ENDIF -->></i>&nbsp;{archiverow.ARCHIVE}</a>
@@ -53,8 +55,10 @@
 					<button type="submit" tabindex="9" name="submit" value="{L_SUBMIT}" class="btn btn-success btn-block" data-loading-text="{L_LOADING}&nbsp;<i class='fa-spin fa fa-spinner fa-lg icon-white'></i>"><i class="fa fa-send"></i> {L_SUBMIT}</button>
 				</fieldset>
 			</form>
-			<!-- ELSEIF BEDANKT -->
-			  <div class="alert alert-success">{BEDANKT}<meta http-equiv="refresh" content="5; URL=index.html" /></div>
+			<!-- ELSEIF THANKS -->
+			<div class="alert alert-success">{THANKS}
+				<meta http-equiv="refresh" content="5; URL=index.html" />
+			</div>
 			<!-- ELSE -->
 			<div class="alert alert-info">
 				<p><!-- IF DEREGISTER -->{L_SUBSCRIBE_NO}<!-- ELSE -->{L_SUBSCRIBE_YES}<!-- ENDIF --></p>
@@ -81,7 +85,9 @@
 
 <!-- IF S_MAIL_VIEW -->
 <div class="wrap-email">
-             <div class="pull-left"><h3><a>{MAIL_SUBJECT}</a></h3></div>
+	<div class="pull-left">
+		<h3><a>{MAIL_SUBJECT}</a></h3>
+	</div>
 	<div class="pull-right">{MAIL_DATE}</div>
 	<div class="space10"></div>
 	<div class="clearfix">{MAIL_MESSAGE}</div>
diff --git "[ORIGINAL]/sitesplat\\newsletter/vendor/assets/images/github-logo.png" "[ORIGINAL]/sitesplat\\newsletter/vendor/assets/images/github-logo.png"
deleted file mode 100644
Binary files "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\newsletter/vendor/assets/images/github-logo.png" and /dev/null differ
diff --git "[FORUM_EXT]/sitesplat\\newsletter/vendor/assets/images/gold-logo.png" "[FORUM_EXT]/sitesplat\\newsletter/vendor/assets/images/gold-logo.png"
new file mode 100644
Binary files /dev/null and "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\newsletter/vendor/assets/images/gold-logo.png" differ
```
