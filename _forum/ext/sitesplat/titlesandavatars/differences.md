Existem diferencas reais no codigo ou texto. Diferencas de formatacao (espacos, tabs) foram ignoradas abaixo.

```diff
diff --git "[FORUM_EXT]/sitesplat\\titlesandavatars/diff_full.tmp" "[FORUM_EXT]/sitesplat\\titlesandavatars/diff_full.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\titlesandavatars/diff_full.tmp"
@@ -0,0 +1,143 @@
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\titlesandavatars/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\titlesandavatars/diff_full.tmp"
+new file mode 100644
+index 000000000..e69de29bb
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\titlesandavatars/event/listener.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\titlesandavatars/event/listener.php"
+index 02aff96f7..943ef7289 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\titlesandavatars/event/listener.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\titlesandavatars/event/listener.php"
+@@ -73,28 +73,31 @@ class listener implements EventSubscriberInterface
+ 			$avatars = array();
+ 			foreach ($rows as $row)
+ 			{
+-				if (preg_match('` href\="(.*?)"`', $user_online_link[intval($row['user_id'])], $matches)) {
+-					if ($row['user_avatar'])
+-					{
+-						$avatar = str_replace(
+-							array('class="avatar"', 'alt='),
+-							array('class="online_img"', 'alt="' . $this->user->lang['USER_AVATAR'] . '" title='),
+-							phpbb_get_user_avatar([
+-								'avatar' => $row['user_avatar'],
+-								'id' => $row['user_id'],
+-								'avatar_type' => $row['user_avatar_type'],
+-								'avatar_width' => $row['user_avatar_width'],
+-								'avatar_height' => $row['user_avatar_height'],
+-							], $row['username'])
+-						);
++				$userId = intval($row['user_id']);
++				if (isset($user_online_link[$userId])) {
++					if (preg_match('` href\="(.*?)"`', $user_online_link[$userId], $matches)) {
++						if ($row['user_avatar'])
++						{
++							$avatar = str_replace(
++								array('class="avatar"', 'alt='),
++								array('class="online_img"', 'alt="' . $this->user->lang['USER_AVATAR'] . '" title='),
++								phpbb_get_user_avatar([
++									'avatar' => $row['user_avatar'],
++									'id' => $row['user_id'],
++									'avatar_type' => $row['user_avatar_type'],
++									'avatar_width' => $row['user_avatar_width'],
++									'avatar_height' => $row['user_avatar_height'],
++								], $row['username'])
++							);
++						}
++						else
++						{
++							$avatar = '<img class="avatar" alt="" title="' .  $row['username'] . '" src="./styles/' . $this->user->style['style_path'] . '/theme/images/no-avatar.png" alt="">';
++						}
++
++//						$avatars[] = '<a href="' . $matches[1] . '">' . $avatar . '</a>';
++						$user_online_link[intval($row['user_id'])] = '<a href="' . $matches[1] . '">' . $avatar . '</a>';
+ 					}
+-					else
+-					{
+-						$avatar = '<img class="avatar" alt="" title="' .  $row['username'] . '" src="./styles/' . $this->user->style['style_path'] . '/theme/images/no-avatar.png" alt="">';
+-					}
+-
+-//					$avatars[] = '<a href="' . $matches[1] . '">' . $avatar . '</a>';
+-					$user_online_link[intval($row['user_id'])] = '<a href="' . $matches[1] . '">' . $avatar . '</a>';
+ 				}
+ 			}
+ 
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\titlesandavatars/styles/FLATBOOTS/template/event/avatars_topicview.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\titlesandavatars/styles/FLATBOOTS/template/event/avatars_topicview.html"
+index 9b6ef735d..2459e90cc 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\titlesandavatars/styles/FLATBOOTS/template/event/avatars_topicview.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\titlesandavatars/styles/FLATBOOTS/template/event/avatars_topicview.html"
+@@ -1,8 +1,8 @@
+-<span class="thread-poster-thumbs <!-- IF SCRIPT_NAME == "viewforum" -->posters-vf<!-- ENDIF --> hidden-xs">
+-		<!-- IF topicrow.TAT_SETTING != 2 -->
+-		<span class="author-wrapper"><!-- IF topicrow.FP_AVATAR -->{topicrow.FP_AVATAR}<!-- ELSE --><img src="{T_THEME_PATH}/images/no_avatar.gif" alt="" /><!-- ENDIF --></span>
++<span class="thread-poster-thumbs<!-- IF SCRIPT_NAME eq 'viewforum' --> posters-vf<!-- ENDIF --> hidden-xs">
++	<!-- IF topicrow.TAT_SETTING != 2 -->
++	<span class="author-wrapper"><!-- IF topicrow.FP_AVATAR -->{topicrow.FP_AVATAR}<!-- ELSE --><img src="{T_THEME_PATH}/images/no-avatar.png" alt="" /><!-- ENDIF --></span>
+ 	<!-- ENDIF -->
+ 	<!-- IF topicrow.TAT_SETTING != 1 -->
+-	<span class="author-wrapper<!-- IF topicrow.TAT_SETTING == 0 -->-thumb<!-- ENDIF -->"><!-- IF topicrow.LP_AVATAR -->{topicrow.LP_AVATAR}<!-- ELSE --><img src="{T_THEME_PATH}/images/no_avatar.gif" alt="" /><!-- ENDIF --></span>
++	<span class="author-wrapper<!-- IF topicrow.TAT_SETTING == 0 -->-thumb<!-- ENDIF -->"><!-- IF topicrow.LP_AVATAR -->{topicrow.LP_AVATAR}<!-- ELSE --><img src="{T_THEME_PATH}/images/no-avatar.png" alt="" /><!-- ENDIF --></span>
+ 	<!-- ENDIF -->
+ </span>
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\titlesandavatars/styles/FLATBOOTS/template/event/memberlist_body_username_prepend.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\titlesandavatars/styles/FLATBOOTS/template/event/memberlist_body_username_prepend.html"
+index ef08bdd18..da6c6a1b6 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\titlesandavatars/styles/FLATBOOTS/template/event/memberlist_body_username_prepend.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\titlesandavatars/styles/FLATBOOTS/template/event/memberlist_body_username_prepend.html"
+@@ -1,3 +1,3 @@
+ <!-- IF MEMBERLIST_AVATAR -->
+-<!-- IF memberrow.AVATAR_IMG --><span class="memberlist-avatar">{memberrow.AVATAR_IMG}</span><!-- ELSE --><span class="memberlist-avatar"><img src="{T_THEME_PATH}/images/no_avatar.gif" alt="" /></span><!-- ENDIF -->
++<!-- IF memberrow.AVATAR_IMG --><span class="memberlist-avatar">{memberrow.AVATAR_IMG}</span><!-- ELSE --><span class="memberlist-avatar"><img src="{T_THEME_PATH}/images/no-avatar.png" alt="" /></span><!-- ENDIF -->
+ <!-- ENDIF -->
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\titlesandavatars/styles/FLATBOOTS/template/event/overall_header_stylesheets_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\titlesandavatars/styles/FLATBOOTS/template/event/overall_header_stylesheets_after.html"
+index 96e09ffd8..89c588c6d 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\titlesandavatars/styles/FLATBOOTS/template/event/overall_header_stylesheets_after.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\titlesandavatars/styles/FLATBOOTS/template/event/overall_header_stylesheets_after.html"
+@@ -1,3 +1,3 @@
+ <!-- IF BB_LOAD_IN_INDEX or BB_LOAD_IN_VIEWFORUM or BB_LOAD_IN_VIEWTOPIC or BB_LOAD_IN_MEMBERLIST -->
+ 	<!-- INCLUDECSS @sitesplat_titlesandavatars/titles_avatars.css -->
+-<!-- ENDIF -->	
+\ No newline at end of file
++<!-- ENDIF -->
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\titlesandavatars/styles/FLATBOOTS/template/event/titles_avatars_forumview.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\titlesandavatars/styles/FLATBOOTS/template/event/titles_avatars_forumview.html"
+index a94b945d3..c7bdc5b5c 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\titlesandavatars/styles/FLATBOOTS/template/event/titles_avatars_forumview.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\titlesandavatars/styles/FLATBOOTS/template/event/titles_avatars_forumview.html"
+@@ -1,10 +1,10 @@
+ <!-- IF forumrow.FORUM_POSTS -->
+ <span class="thread-poster-thumbs hidden-xs">
+ 	<!-- IF forumrow.TAT_SETTING != 2 -->
+-	<span class="author-wrapper"><!-- IF forumrow.FP_AVATAR -->{forumrow.FP_AVATAR}<!-- ELSE --><img src="{T_THEME_PATH}/images/no_avatar.gif" alt="" /><!-- ENDIF --></span>
++	<span class="author-wrapper"><!-- IF forumrow.FP_AVATAR -->{forumrow.FP_AVATAR}<!-- ELSE --><img src="{T_THEME_PATH}/images/no-avatar.png" alt="" /><!-- ENDIF --></span>
+ 	<!-- ENDIF -->
+ 	<!-- IF forumrow.TAT_SETTING != 1 -->
+-	<span class="author-wrapper<!-- IF forumrow.TAT_SETTING == 0 -->-thumb<!-- ENDIF -->"><!-- IF forumrow.LP_AVATAR -->{forumrow.LP_AVATAR}<!-- ELSE --><img src="{T_THEME_PATH}/images/no_avatar.gif" alt="" /><!-- ENDIF --></span>
++	<span class="author-wrapper<!-- IF forumrow.TAT_SETTING == 0 -->-thumb<!-- ENDIF -->"><!-- IF forumrow.LP_AVATAR -->{forumrow.LP_AVATAR}<!-- ELSE --><img src="{T_THEME_PATH}/images/no-avatar.png" alt="" /><!-- ENDIF --></span>
+ 	<!-- ENDIF -->
+ </span>
+ <!-- ENDIF -->
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\titlesandavatars/styles/FLATBOOTS/template/event/viewtopic_first_topic_buttons_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\titlesandavatars/styles/FLATBOOTS/template/event/viewtopic_first_topic_buttons_after.html"
+index f2e0d2601..968c6fd9f 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\titlesandavatars/styles/FLATBOOTS/template/event/viewtopic_first_topic_buttons_after.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\titlesandavatars/styles/FLATBOOTS/template/event/viewtopic_first_topic_buttons_after.html"
+@@ -2,7 +2,7 @@
+ <div class="contributor-avatars pull-right">
+ <ul class="list-unstyled">
+ <!-- BEGIN participants_avatars -->
+-<!-- IF participants_avatars.TOPIC_AVATAR --><li class="shown"><a href="{participants_avatars.URL}" title="{participants_avatars.USERNAME}">{participants_avatars.TOPIC_AVATAR}</a></li><!-- ELSE --><li class="shown"><a href="{participants_avatars.URL}" title="{participants_avatars.USERNAME}"><img src="{T_THEME_PATH}/images/user4.png" alt="" /></a></li><!-- ENDIF -->
++<!-- IF participants_avatars.TOPIC_AVATAR --><li class="shown"><a href="{participants_avatars.URL}" title="{participants_avatars.USERNAME}">{participants_avatars.TOPIC_AVATAR}</a></li><!-- ELSE --><li class="shown"><a href="{participants_avatars.URL}" title="{participants_avatars.USERNAME}"><img src="{T_THEME_PATH}/images/no-avatar.png" alt="" /></a></li><!-- ENDIF -->
+ <!-- END participants_avatars -->
+ <li><a data-toggle="modal" data-id="{PARTICIPANT_TOPIC_ID}" href="#AvatarsDialog" class="open-AvatarsDialog" title="{L_PARTICIPATE_OTHERS}"><i class="fa fa-plus"></i></a></li>
+ </ul>
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\titlesandavatars/styles/FLATBOOTS/theme/titles_avatars.css" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\titlesandavatars/styles/FLATBOOTS/theme/titles_avatars.css"
+index 58c981a70..7f073476c 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\titlesandavatars/styles/FLATBOOTS/theme/titles_avatars.css"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\titlesandavatars/styles/FLATBOOTS/theme/titles_avatars.css"
+@@ -82,7 +82,7 @@
+     float: right;
+     margin-left: 20px;
+     margin-top: 10px;
+-    max-width: 250px;
++    max-width: 300px;
+     position: relative;
+ }
+ 
diff --git "[FORUM_EXT]/sitesplat\\titlesandavatars/diff_nospace.tmp" "[FORUM_EXT]/sitesplat\\titlesandavatars/diff_nospace.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\titlesandavatars/diff_nospace.tmp"
@@ -0,0 +1,108 @@
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\titlesandavatars/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\titlesandavatars/diff_full.tmp"
+new file mode 100644
+index 000000000..809f911d3
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\titlesandavatars/diff_full.tmp"
+@@ -0,0 +1,143 @@
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\titlesandavatars/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\titlesandavatars/diff_full.tmp"
++new file mode 100644
++index 000000000..e69de29bb
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\titlesandavatars/event/listener.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\titlesandavatars/event/listener.php"
++index 02aff96f7..943ef7289 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\titlesandavatars/event/listener.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\titlesandavatars/event/listener.php"
++@@ -73,28 +73,31 @@ class listener implements EventSubscriberInterface
++ 			$avatars = array();
++ 			foreach ($rows as $row)
++ 			{
++-				if (preg_match('` href\="(.*?)"`', $user_online_link[intval($row['user_id'])], $matches)) {
++-					if ($row['user_avatar'])
++-					{
++-						$avatar = str_replace(
++-							array('class="avatar"', 'alt='),
++-							array('class="online_img"', 'alt="' . $this->user->lang['USER_AVATAR'] . '" title='),
++-							phpbb_get_user_avatar([
++-								'avatar' => $row['user_avatar'],
++-								'id' => $row['user_id'],
++-								'avatar_type' => $row['user_avatar_type'],
++-								'avatar_width' => $row['user_avatar_width'],
++-								'avatar_height' => $row['user_avatar_height'],
++-							], $row['username'])
++-						);
+++				$userId = intval($row['user_id']);
+++				if (isset($user_online_link[$userId])) {
+++					if (preg_match('` href\="(.*?)"`', $user_online_link[$userId], $matches)) {
+++						if ($row['user_avatar'])
+++						{
+++							$avatar = str_replace(
+++								array('class="avatar"', 'alt='),
+++								array('class="online_img"', 'alt="' . $this->user->lang['USER_AVATAR'] . '" title='),
+++								phpbb_get_user_avatar([
+++									'avatar' => $row['user_avatar'],
+++									'id' => $row['user_id'],
+++									'avatar_type' => $row['user_avatar_type'],
+++									'avatar_width' => $row['user_avatar_width'],
+++									'avatar_height' => $row['user_avatar_height'],
+++								], $row['username'])
+++							);
+++						}
+++						else
+++						{
+++							$avatar = '<img class="avatar" alt="" title="' .  $row['username'] . '" src="./styles/' . $this->user->style['style_path'] . '/theme/images/no-avatar.png" alt="">';
+++						}
+++
+++//						$avatars[] = '<a href="' . $matches[1] . '">' . $avatar . '</a>';
+++						$user_online_link[intval($row['user_id'])] = '<a href="' . $matches[1] . '">' . $avatar . '</a>';
++ 					}
++-					else
++-					{
++-						$avatar = '<img class="avatar" alt="" title="' .  $row['username'] . '" src="./styles/' . $this->user->style['style_path'] . '/theme/images/no-avatar.png" alt="">';
++-					}
++-
++-//					$avatars[] = '<a href="' . $matches[1] . '">' . $avatar . '</a>';
++-					$user_online_link[intval($row['user_id'])] = '<a href="' . $matches[1] . '">' . $avatar . '</a>';
++ 				}
++ 			}
++ 
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\titlesandavatars/styles/FLATBOOTS/template/event/avatars_topicview.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\titlesandavatars/styles/FLATBOOTS/template/event/avatars_topicview.html"
++index 9b6ef735d..2459e90cc 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\titlesandavatars/styles/FLATBOOTS/template/event/avatars_topicview.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\titlesandavatars/styles/FLATBOOTS/template/event/avatars_topicview.html"
++@@ -1,8 +1,8 @@
++-<span class="thread-poster-thumbs <!-- IF SCRIPT_NAME == "viewforum" -->posters-vf<!-- ENDIF --> hidden-xs">
++-		<!-- IF topicrow.TAT_SETTING != 2 -->
++-		<span class="author-wrapper"><!-- IF topicrow.FP_AVATAR -->{topicrow.FP_AVATAR}<!-- ELSE --><img src="{T_THEME_PATH}/images/no_avatar.gif" alt="" /><!-- ENDIF --></span>
+++<span class="thread-poster-thumbs<!-- IF SCRIPT_NAME eq 'viewforum' --> posters-vf<!-- ENDIF --> hidden-xs">
+++	<!-- IF topicrow.TAT_SETTING != 2 -->
+++	<span class="author-wrapper"><!-- IF topicrow.FP_AVATAR -->{topicrow.FP_AVATAR}<!-- ELSE --><img src="{T_THEME_PATH}/images/no-avatar.png" alt="" /><!-- ENDIF --></span>
++ 	<!-- ENDIF -->
++ 	<!-- IF topicrow.TAT_SETTING != 1 -->
++-	<span class="author-wrapper<!-- IF topicrow.TAT_SETTING == 0 -->-thumb<!-- ENDIF -->"><!-- IF topicrow.LP_AVATAR -->{topicrow.LP_AVATAR}<!-- ELSE --><img src="{T_THEME_PATH}/images/no_avatar.gif" alt="" /><!-- ENDIF --></span>
+++	<span class="author-wrapper<!-- IF topicrow.TAT_SETTING == 0 -->-thumb<!-- ENDIF -->"><!-- IF topicrow.LP_AVATAR -->{topicrow.LP_AVATAR}<!-- ELSE --><img src="{T_THEME_PATH}/images/no-avatar.png" alt="" /><!-- ENDIF --></span>
++ 	<!-- ENDIF -->
++ </span>
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\titlesandavatars/styles/FLATBOOTS/template/event/memberlist_body_username_prepend.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\titlesandavatars/styles/FLATBOOTS/template/event/memberlist_body_username_prepend.html"
++index ef08bdd18..da6c6a1b6 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\titlesandavatars/styles/FLATBOOTS/template/event/memberlist_body_username_prepend.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\titlesandavatars/styles/FLATBOOTS/template/event/memberlist_body_username_prepend.html"
++@@ -1,3 +1,3 @@
++ <!-- IF MEMBERLIST_AVATAR -->
++-<!-- IF memberrow.AVATAR_IMG --><span class="memberlist-avatar">{memberrow.AVATAR_IMG}</span><!-- ELSE --><span class="memberlist-avatar"><img src="{T_THEME_PATH}/images/no_avatar.gif" alt="" /></span><!-- ENDIF -->
+++<!-- IF memberrow.AVATAR_IMG --><span class="memberlist-avatar">{memberrow.AVATAR_IMG}</span><!-- ELSE --><span class="memberlist-avatar"><img src="{T_THEME_PATH}/images/no-avatar.png" alt="" /></span><!-- ENDIF -->
++ <!-- ENDIF -->
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\titlesandavatars/styles/FLATBOOTS/template/event/overall_header_stylesheets_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\titlesandavatars/styles/FLATBOOTS/template/event/overall_header_stylesheets_after.html"
++index 96e09ffd8..89c588c6d 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\titlesandavatars/styles/FLATBOOTS/template/event/overall_header_stylesheets_after.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\titlesandavatars/styles/FLATBOOTS/template/event/overall_header_stylesheets_after.html"
++@@ -1,3 +1,3 @@
++ <!-- IF BB_LOAD_IN_INDEX or BB_LOAD_IN_VIEWFORUM or BB_LOAD_IN_VIEWTOPIC or BB_LOAD_IN_MEMBERLIST -->
++ 	<!-- INCLUDECSS @sitesplat_titlesandavatars/titles_avatars.css -->
++-<!-- ENDIF -->	
++\ No newline at end of file
+++<!-- ENDIF -->
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\titlesandavatars/styles/FLATBOOTS/template/event/titles_avatars_forumview.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\titlesandavatars/styles/FLATBOOTS/template/event/titles_avatars_forumview.html"
++index a94b945d3..c7bdc5b5c 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\titlesandavatar
\ No newline at end of file
diff --git "[ORIGINAL]/sitesplat\\titlesandavatars/event/listener.php" "[FORUM_EXT]/sitesplat\\titlesandavatars/event/listener.php"
--- "[ORIGINAL]/sitesplat\\titlesandavatars/event/listener.php"
+++ "[FORUM_EXT]/sitesplat\\titlesandavatars/event/listener.php"
@@ -73,7 +73,9 @@ class listener implements EventSubscriberInterface
 			$avatars = array();
 			foreach ($rows as $row)
 			{
-				if (preg_match('` href\="(.*?)"`', $user_online_link[intval($row['user_id'])], $matches)) {
+				$userId = intval($row['user_id']);
+				if (isset($user_online_link[$userId])) {
+					if (preg_match('` href\="(.*?)"`', $user_online_link[$userId], $matches)) {
 						if ($row['user_avatar'])
 						{
 							$avatar = str_replace(
@@ -97,6 +99,7 @@ class listener implements EventSubscriberInterface
 						$user_online_link[intval($row['user_id'])] = '<a href="' . $matches[1] . '">' . $avatar . '</a>';
 					}
 				}
+			}
 
 //			$event['online_userlist'] = str_replace($user_online_link, $avatars, $online_userlist);
 			$event['user_online_link'] = $user_online_link;
diff --git "[ORIGINAL]/sitesplat\\titlesandavatars/styles/FLATBOOTS/template/event/avatars_topicview.html" "[FORUM_EXT]/sitesplat\\titlesandavatars/styles/FLATBOOTS/template/event/avatars_topicview.html"
--- "[ORIGINAL]/sitesplat\\titlesandavatars/styles/FLATBOOTS/template/event/avatars_topicview.html"
+++ "[FORUM_EXT]/sitesplat\\titlesandavatars/styles/FLATBOOTS/template/event/avatars_topicview.html"
@@ -1,8 +1,8 @@
-<span class="thread-poster-thumbs <!-- IF SCRIPT_NAME == "viewforum" -->posters-vf<!-- ENDIF --> hidden-xs">
+<span class="thread-poster-thumbs<!-- IF SCRIPT_NAME eq 'viewforum' --> posters-vf<!-- ENDIF --> hidden-xs">
 	<!-- IF topicrow.TAT_SETTING != 2 -->
-		<span class="author-wrapper"><!-- IF topicrow.FP_AVATAR -->{topicrow.FP_AVATAR}<!-- ELSE --><img src="{T_THEME_PATH}/images/no_avatar.gif" alt="" /><!-- ENDIF --></span>
+	<span class="author-wrapper"><!-- IF topicrow.FP_AVATAR -->{topicrow.FP_AVATAR}<!-- ELSE --><img src="{T_THEME_PATH}/images/no-avatar.png" alt="" /><!-- ENDIF --></span>
 	<!-- ENDIF -->
 	<!-- IF topicrow.TAT_SETTING != 1 -->
-	<span class="author-wrapper<!-- IF topicrow.TAT_SETTING == 0 -->-thumb<!-- ENDIF -->"><!-- IF topicrow.LP_AVATAR -->{topicrow.LP_AVATAR}<!-- ELSE --><img src="{T_THEME_PATH}/images/no_avatar.gif" alt="" /><!-- ENDIF --></span>
+	<span class="author-wrapper<!-- IF topicrow.TAT_SETTING == 0 -->-thumb<!-- ENDIF -->"><!-- IF topicrow.LP_AVATAR -->{topicrow.LP_AVATAR}<!-- ELSE --><img src="{T_THEME_PATH}/images/no-avatar.png" alt="" /><!-- ENDIF --></span>
 	<!-- ENDIF -->
 </span>
\ No newline at end of file
diff --git "[ORIGINAL]/sitesplat\\titlesandavatars/styles/FLATBOOTS/template/event/memberlist_body_username_prepend.html" "[FORUM_EXT]/sitesplat\\titlesandavatars/styles/FLATBOOTS/template/event/memberlist_body_username_prepend.html"
--- "[ORIGINAL]/sitesplat\\titlesandavatars/styles/FLATBOOTS/template/event/memberlist_body_username_prepend.html"
+++ "[FORUM_EXT]/sitesplat\\titlesandavatars/styles/FLATBOOTS/template/event/memberlist_body_username_prepend.html"
@@ -1,3 +1,3 @@
 <!-- IF MEMBERLIST_AVATAR -->
-<!-- IF memberrow.AVATAR_IMG --><span class="memberlist-avatar">{memberrow.AVATAR_IMG}</span><!-- ELSE --><span class="memberlist-avatar"><img src="{T_THEME_PATH}/images/no_avatar.gif" alt="" /></span><!-- ENDIF -->
+<!-- IF memberrow.AVATAR_IMG --><span class="memberlist-avatar">{memberrow.AVATAR_IMG}</span><!-- ELSE --><span class="memberlist-avatar"><img src="{T_THEME_PATH}/images/no-avatar.png" alt="" /></span><!-- ENDIF -->
 <!-- ENDIF -->
\ No newline at end of file
diff --git "[ORIGINAL]/sitesplat\\titlesandavatars/styles/FLATBOOTS/template/event/titles_avatars_forumview.html" "[FORUM_EXT]/sitesplat\\titlesandavatars/styles/FLATBOOTS/template/event/titles_avatars_forumview.html"
--- "[ORIGINAL]/sitesplat\\titlesandavatars/styles/FLATBOOTS/template/event/titles_avatars_forumview.html"
+++ "[FORUM_EXT]/sitesplat\\titlesandavatars/styles/FLATBOOTS/template/event/titles_avatars_forumview.html"
@@ -1,10 +1,10 @@
 <!-- IF forumrow.FORUM_POSTS -->
 <span class="thread-poster-thumbs hidden-xs">
 	<!-- IF forumrow.TAT_SETTING != 2 -->
-	<span class="author-wrapper"><!-- IF forumrow.FP_AVATAR -->{forumrow.FP_AVATAR}<!-- ELSE --><img src="{T_THEME_PATH}/images/no_avatar.gif" alt="" /><!-- ENDIF --></span>
+	<span class="author-wrapper"><!-- IF forumrow.FP_AVATAR -->{forumrow.FP_AVATAR}<!-- ELSE --><img src="{T_THEME_PATH}/images/no-avatar.png" alt="" /><!-- ENDIF --></span>
 	<!-- ENDIF -->
 	<!-- IF forumrow.TAT_SETTING != 1 -->
-	<span class="author-wrapper<!-- IF forumrow.TAT_SETTING == 0 -->-thumb<!-- ENDIF -->"><!-- IF forumrow.LP_AVATAR -->{forumrow.LP_AVATAR}<!-- ELSE --><img src="{T_THEME_PATH}/images/no_avatar.gif" alt="" /><!-- ENDIF --></span>
+	<span class="author-wrapper<!-- IF forumrow.TAT_SETTING == 0 -->-thumb<!-- ENDIF -->"><!-- IF forumrow.LP_AVATAR -->{forumrow.LP_AVATAR}<!-- ELSE --><img src="{T_THEME_PATH}/images/no-avatar.png" alt="" /><!-- ENDIF --></span>
 	<!-- ENDIF -->
 </span>
 <!-- ENDIF -->
\ No newline at end of file
diff --git "[ORIGINAL]/sitesplat\\titlesandavatars/styles/FLATBOOTS/template/event/viewtopic_first_topic_buttons_after.html" "[FORUM_EXT]/sitesplat\\titlesandavatars/styles/FLATBOOTS/template/event/viewtopic_first_topic_buttons_after.html"
--- "[ORIGINAL]/sitesplat\\titlesandavatars/styles/FLATBOOTS/template/event/viewtopic_first_topic_buttons_after.html"
+++ "[FORUM_EXT]/sitesplat\\titlesandavatars/styles/FLATBOOTS/template/event/viewtopic_first_topic_buttons_after.html"
@@ -2,7 +2,7 @@
 <div class="contributor-avatars pull-right">
 <ul class="list-unstyled">
 <!-- BEGIN participants_avatars -->
-<!-- IF participants_avatars.TOPIC_AVATAR --><li class="shown"><a href="{participants_avatars.URL}" title="{participants_avatars.USERNAME}">{participants_avatars.TOPIC_AVATAR}</a></li><!-- ELSE --><li class="shown"><a href="{participants_avatars.URL}" title="{participants_avatars.USERNAME}"><img src="{T_THEME_PATH}/images/user4.png" alt="" /></a></li><!-- ENDIF -->
+<!-- IF participants_avatars.TOPIC_AVATAR --><li class="shown"><a href="{participants_avatars.URL}" title="{participants_avatars.USERNAME}">{participants_avatars.TOPIC_AVATAR}</a></li><!-- ELSE --><li class="shown"><a href="{participants_avatars.URL}" title="{participants_avatars.USERNAME}"><img src="{T_THEME_PATH}/images/no-avatar.png" alt="" /></a></li><!-- ENDIF -->
 <!-- END participants_avatars -->
 <li><a data-toggle="modal" data-id="{PARTICIPANT_TOPIC_ID}" href="#AvatarsDialog" class="open-AvatarsDialog" title="{L_PARTICIPATE_OTHERS}"><i class="fa fa-plus"></i></a></li>
 </ul>
diff --git "[ORIGINAL]/sitesplat\\titlesandavatars/styles/FLATBOOTS/theme/titles_avatars.css" "[FORUM_EXT]/sitesplat\\titlesandavatars/styles/FLATBOOTS/theme/titles_avatars.css"
--- "[ORIGINAL]/sitesplat\\titlesandavatars/styles/FLATBOOTS/theme/titles_avatars.css"
+++ "[FORUM_EXT]/sitesplat\\titlesandavatars/styles/FLATBOOTS/theme/titles_avatars.css"
@@ -82,7 +82,7 @@
     float: right;
     margin-left: 20px;
     margin-top: 10px;
-    max-width: 250px;
+    max-width: 300px;
     position: relative;
 }
 
```
