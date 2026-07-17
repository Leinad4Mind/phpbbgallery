Existem diferencas reais no codigo ou texto. Diferencas de formatacao (espacos, tabs) foram ignoradas abaixo.

```diff
diff --git "[ORIGINAL]/sitesplat\\flatbootsminicms/composer.json" "[FORUM_EXT]/sitesplat\\flatbootsminicms/composer.json"
--- "[ORIGINAL]/sitesplat\\flatbootsminicms/composer.json"
+++ "[FORUM_EXT]/sitesplat\\flatbootsminicms/composer.json"
@@ -17,7 +17,7 @@
 		"php": ">=5.4"
 	},
 	"extra": {
-		"display-name": "FLATBOOTS Mini CMS",
+		"display-name": "FLATBOOTS Mini CMS - Mod",
 		"soft-require": {
 			"phpbb/phpbb": ">=3.1.5"
 		},
diff --git "[FORUM_EXT]/sitesplat\\flatbootsminicms/diff_full.tmp" "[FORUM_EXT]/sitesplat\\flatbootsminicms/diff_full.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\flatbootsminicms/diff_full.tmp"
@@ -0,0 +1,170 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\flatbootsminicms/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\flatbootsminicms/composer.json"
+index 4b8f21091..a89ae57bf 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\flatbootsminicms/composer.json"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\flatbootsminicms/composer.json"
+@@ -17,7 +17,7 @@
+ 		"php": ">=5.4"
+ 	},
+ 	"extra": {
+-		"display-name": "FLATBOOTS Mini CMS",
++		"display-name": "FLATBOOTS Mini CMS - Mod",
+ 		"soft-require": {
+ 			"phpbb/phpbb": ">=3.1.5"
+ 		},
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\flatbootsminicms/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\flatbootsminicms/diff_full.tmp"
+new file mode 100644
+index 000000000..e69de29bb
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\flatbootsminicms/event/listener.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\flatbootsminicms/event/listener.php"
+index fd3231f68..8655d345b 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\flatbootsminicms/event/listener.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\flatbootsminicms/event/listener.php"
+@@ -273,7 +273,7 @@ class listener implements EventSubscriberInterface
+ 			);
+ 			$result = $this->db->sql_query($this->db->sql_build_query('SELECT', $sql_ary));
+ 			while ($row = $this->db->sql_fetchrow($result)) {
+-				if (($row['button_only_registered'] && $this->user->data['user_id'] == ANONYMOUS) || ($row['button_only_guest'] && $this->user->data['user_id'] != ANONYMOUS))
++				if (($row['button_only_registered'] && $user->data['user_id'] == ANONYMOUS) || ($row['button_only_guest'] && $user->data['user_id'] != ANONYMOUS))
+ 				{
+ 					continue;
+ 				}
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\flatbootsminicms/images/logo/logotipo_v4.png" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\flatbootsminicms/images/logo/logotipo_v4.png"
+new file mode 100644
+index 000000000..8274b052d
+Binary files /dev/null and "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\flatbootsminicms/images/logo/logotipo_v4.png" differ
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\flatbootsminicms/styles/FLATBOOTS/template/event/flatboots_navigation_instead.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\flatbootsminicms/styles/FLATBOOTS/template/event/flatboots_navigation_instead.html"
+index 292b677fd..6bd70c078 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\flatbootsminicms/styles/FLATBOOTS/template/event/flatboots_navigation_instead.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\flatbootsminicms/styles/FLATBOOTS/template/event/flatboots_navigation_instead.html"
+@@ -16,8 +16,10 @@
+ 				   <!-- EVENT overall_header_mobile_navigation_append -->
+ 				   <li><a title="" href="{U_UCP_PROFILE_SETTINGS}"><i class="fa fa-cog"></i>&nbsp;{L_UCP_PROFILE_SETTINGS}</a></li>
+ 	               <!-- IF U_ACP --><li><a title="" href="{U_ACP}"><i class="fa fa-user-md"></i>&nbsp;{L_ADMIN_PANEL_GENERAL}</a></li><!-- ENDIF -->
+-	               <!-- IF U_MCP --><li><a href="{U_MCP}"><i class="fa fa-legal"></i>&nbsp;{L_MODERATOR_PANEL_GENERAL}</a></li><!-- ENDIF -->
+-				   <!-- IF S_REGISTERED_USER and not (U_ACP or U_MCP) --><li><a href="{U_PROFILE}"><i class="fa fa-user"></i>&nbsp;{L_USER_PANEL}</a></li><!-- ENDIF -->
++	               <!-- IF U_MCP --><li><a href="{U_MCP}"><i class="fa fa-legal"></i>&nbsp;{L_MODERATOR_PANEL_GENERAL}</a></li><!-- ELSEIF U_MCP_HELP -->
++				   <li><a href="{U_MCP_HELP}"><i class="fa fa-legal"></i>&nbsp;{L_MODERATOR_PANEL_GENERAL}</a></li>
++				   <!-- ENDIF -->
++				   <!-- IF S_REGISTERED_USER --><li><a href="{U_PROFILE}"><i class="fa fa-user"></i>&nbsp;{L_USER_PANEL}</a></li><!-- ENDIF -->
+ 				   <!-- IF U_RESTORE_PERMISSIONS --><li><a href="{U_RESTORE_PERMISSIONS}"><i class="fa fa-random"></i>&nbsp;{L_RESTORE_PERMISSIONS}</a></li><!-- ENDIF -->
+ 				  <li><a title="" href="{U_LOGIN_LOGOUT}"><i class="fa fa-power-off"></i>&nbsp;{L_LOGOUT}</a></li>
+ 				  <!-- EVENT overall_header_mobile_navigation_ending -->
+@@ -54,7 +56,7 @@
+        <span class="dropdown-arrow"></span>
+         <ul class="dropdown-menu">
+ 			<!-- EVENT overall_header_navigation_prepend -->
+-			 <li><a href="{U_FAQ}"><i class="fa fa-question-circle"></i>{L_FAQ}</a></li>
++			<!-- <li><a href="{U_FAQ}"><i class="fa fa-question-circle"></i>{L_FAQ}</a></li> -->
+ 			<!-- EVENT overall_header_navigation_append -->
+         </ul>
+     </li>
+@@ -80,13 +82,13 @@
+ 	<div class="user-login hidden-xs">
+ 		<ul class="nav navbar-nav navbar-right navbar-nav-fancy">
+ 		<!-- EVENT navigation_controls_before -->
+-		<li><a class="btn-search" href="javascript:void(0)"><i class="fa fa-lightbulb-o"></i></a></li>
++		<li><a class="btn-search" href="javascript:void(0)"><i class="fa fa-search"></i></a></li>
+ 		<!-- EVENT navigation_controls_after -->
+ 		<!-- IF S_NOTIFICATIONS_DISPLAY -->	
+ 		    <li class="dropdown dropdown-avatar dropdown-notification">
+ 			  <a id="notification_list_button" href="javascript:void(0)" data-toggle="dropdown"><i class="fa fa-bell"></i><!-- IF .notifications and NOTIFICATIONS_COUNT --><em class="notifications badge badge-danger">{NOTIFICATIONS_COUNT}</em><!-- ENDIF --></a>
+                 <ul class="dropdown-menu user-login-drop arrow-up">
+-                 <li><a href="{U_VIEW_ALL_NOTIFICATIONS}" class="notification-heading">{L_NOTIFICATIONS}</a></li>
++                 <li><a href="/forum/ucp.php?i=-forumhulp-notification_manager-ucp-noties_module&mode=noties" class="notification-heading btn btn-default btn-sm">{L_NOTIFICATIONS}</a></li>
+                    <!-- INCLUDE notification_dropdown.html -->
+                 </ul>
+             </li>
+@@ -94,7 +96,7 @@
+ 			
+ 			<li class="dropdown dropdown-avatar">
+ 			  <a href="javascript:void(0)" data-toggle="dropdown">
+-			   <!-- IF CURRENT_USER_AVATAR -->{CURRENT_USER_AVATAR}&nbsp;<!-- ELSE --><img src="{T_THEME_PATH}/images/user4.png" alt="No avatar"><!-- ENDIF -->&nbsp;<span>{L_WELCOME_INDEX}&#44;&nbsp;{CURRENT_USERNAME_SIMPLE}<i class="caret"></i></span>
++			   <!-- IF CURRENT_USER_AVATAR -->{CURRENT_USER_AVATAR}&nbsp;<!-- ELSE --><img src="{T_THEME_PATH}/images/user.png" alt="No avatar"><!-- ENDIF -->&nbsp;<span>{L_WELCOME_INDEX}&#44;&nbsp;{CURRENT_USERNAME_SIMPLE}<i class="caret"></i></span>
+ 			  </a>
+                 <!-- IF S_USER_NEW_PRIVMSG --><em class="notifications-pm badge badge-warning">{PM_NEW_COUNT_BADGE}</em><!-- ELSEIF S_USER_UNREAD_PRIVMSG --><em class="notifications-pm badge badge-success">{PRIVATE_MESSAGE_COUNT}</em><!-- ENDIF -->                   
+ 				   <ul class="dropdown-menu user-login-drop arrow-up">
+@@ -104,7 +106,7 @@
+                               <div class="navbar-content navbar-avatar">
+                                     <div class="row">
+                                         <div class="col-md-5 col-xs-5">
+-                                          <!-- IF CURRENT_USER_AVATAR -->{CURRENT_USER_AVATAR}<!-- ELSE --><img src="{T_THEME_PATH}/images/user4.png" alt="No avatar"><!-- ENDIF -->
++                                          <!-- IF CURRENT_USER_AVATAR -->{CURRENT_USER_AVATAR}<!-- ELSE --><img src="{T_THEME_PATH}/images/user.png" alt="No avatar"><!-- ENDIF -->
+                                             <p class="text-center"><a href="{U_UCP_PROFILE_AVATAR}">
+                                                 <small>{L_CHANGE_AVATAR}</small>
+                                             </a></p>
+@@ -112,20 +114,40 @@
+                                         <div class="col-md-7 col-xs-7"><span>{CURRENT_USERNAME_FULL}</span>
+                                             <p class="text-muted small">{USER_EMAIL_MENU}</p>
+                                              <!-- IF U_ACP --><a class="btn btn-info btn-sm btn-block" href="{U_ACP}"><i class="fa fa-user-md"></i>&nbsp;{L_ADMIN_PANEL_GENERAL}</a><!-- ENDIF -->
+-	                                         <!-- IF U_MCP --><a class="btn btn-warning btn-sm btn-block" href="{U_MCP}"><i class="fa fa-legal"></i>&nbsp;{L_MODERATOR_PANEL_GENERAL}</a><!-- ENDIF -->
+-                                             <!-- IF S_REGISTERED_USER and not (U_ACP or U_MCP) --><a class="btn btn-success btn-sm btn-block" href="{U_PROFILE}"><i class="fa fa-user"></i>&nbsp;{L_USER_PANEL}</a><!-- ENDIF -->
++	                                         <!-- IF U_MCP and SCRIPT_NAME neq 'mcp' --><a class="btn btn-warning btn-sm btn-block" href="{U_MCP}"><i class="fa fa-legal"></i>&nbsp;{L_MODERATOR_PANEL_GENERAL}</a><!-- ENDIF -->
++                                             <!-- IF S_REGISTERED_USER and SCRIPT_NAME neq 'ucp' --><a class="btn btn-success btn-sm btn-block" href="{U_PROFILE}"><i class="fa fa-user"></i>&nbsp;{L_USER_PANEL}</a><!-- ENDIF -->
++											 <!-- EVENT navbar_header_profile_list_after -->
++											 <!-- IF .accountswitch -->
++												<div class="navbar-footer">
++													<div class="navbar-footer-content">
++														<div class="row">
++															<!-- IF U_RESTORE_PERMISSIONS -->
++															<div class="col-md-6 col-xs-6"><a class="btn btn-warning btn-sm" href="{U_RESTORE_PERMISSIONS}"><i class="fa fa-random"></i>&nbsp;{L_RESTORE_PERMISSIONS}</a></div>
++															<!-- ELSE -->
++															<div class="col-md-6 col-xs-6"><a class="btn btn-default btn-sm" href="{U_UCP_PROFILE_SETTINGS}"><i class="fa fa-key"></i>&nbsp;{L_CHANGE_PASSWORD}</a></div>
++															<!-- ENDIF -->
++															<div class="col-md-6 col-xs-6"><a class="btn btn-default btn-sm pull-right" href="{U_LOGIN_LOGOUT}"><i class="fa fa-sign-out"></i>&nbsp;{L_LOGOUT}</a></div>
++														</div>
++													</div>
++											   </div>
++											 <!-- ENDIF -->
+ 										</div>
+                                     </div>
+ 							  </div>
+-							  <!-- EVENT navbar_header_profile_list_after -->
++							<!-- IF not .accountswitch -->
+ 							  <div class="navbar-footer">
+                                     <div class="navbar-footer-content">
+                                         <div class="row">
+-                                            <div class="col-md-6 col-xs-6"><a class="btn btn-default btn-sm" href="{U_UCP_PROFILE_SETTINGS}">{L_CHANGE_PASSWORD}</a></div>
+-                                            <div class="col-md-6 col-xs-6"><a class="btn btn-default btn-sm pull-right" href="{U_LOGIN_LOGOUT}">{L_LOGOUT}</a></div>
++                                            <!-- IF U_RESTORE_PERMISSIONS -->
++                                            <div class="col-md-6 col-xs-6"><a class="btn btn-warning btn-sm" href="{U_RESTORE_PERMISSIONS}"><i class="fa fa-random"></i>&nbsp;{L_RESTORE_PERMISSIONS}</a></div>
++                                            <!-- ELSE -->
++                                            <div class="col-md-6 col-xs-6"><a class="btn btn-default btn-sm" href="{U_UCP_PROFILE_SETTINGS}"><i class="fa fa-key"></i>&nbsp;{L_CHANGE_PASSWORD}</a></div>
++                                            <!-- ENDIF -->
++                                            <div class="col-md-6 col-xs-6"><a class="btn btn-default btn-sm pull-right" href="{U_LOGIN_LOGOUT}"><i class="fa fa-sign-out"></i>&nbsp;{L_LOGOUT}</a></div>
+                                         </div>
+                                     </div>
+                                </div>
++							<!-- ENDIF -->
+ 							</div>
+                         </li>
+                     </ul>
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\flatbootsminicms/styles/FLATBOOTS/template/event/prefooter_instead.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\flatbootsminicms/styles/FLATBOOTS/template/event/prefooter_instead.html"
+index dc8756002..7842abc2d 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\flatbootsminicms/styles/FLATBOOTS/template/event/prefooter_instead.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\flatbootsminicms/styles/FLATBOOTS/template/event/prefooter_instead.html"
+@@ -3,21 +3,21 @@
+ 		<div class="container center">
+ 			<div class="row">
+ 				<div class="col-sm-5 twitter">
+-					<div class="thumb"><i class="fa fa-paw"></i></div>
++					<div class="thumb"><img src="{T_THEME_PATH}/images/simbologold.svg" alt="S&iacute;mbolo Gold"></div>
+ 					<div class="text">
+ 						<h3>{ABOUT_US_TITLE}</h3>
+ 						<p>{ABOUT_US}</p>
+ 					</div>
+ 				</div>
+ 				<div class="col-sm-5 col-sm-offset-2 twitter">
+-					<div class="thumb"><i class="fa fa-twitter"></i></div>
++					<div class="thumb"><i class="fa fa-instagram"></i></div>
+ 					<div class="text">
+-						<h3><a href="https://twitter.com/{TWITTER_SCREEN_NAME}">{L_JOIN_US_TWITTER}&nbsp;<small>@{TWITTER_SCREEN_NAME}</small></a></h3>
++						<h3><a href="https://www.instagram.com/{TWITTER_SCREEN_NAME}">{L_JOIN_US_TWITTER}&nbsp;<small>@{TWITTER_SCREEN_NAME}</small></a></h3>
+ 						 <div id="twitter-feed"></div>
+ 					</div>
+ 				</div>
+ 			</div>
+ 		</div>
+-		 <div class="section-bg"></div>
++		<!--<div class="section-bg"></div>-->
+ 	</section>
+ <!-- ENDIF -->
+\ No newline at end of file
diff --git "[FORUM_EXT]/sitesplat\\flatbootsminicms/diff_nospace.tmp" "[FORUM_EXT]/sitesplat\\flatbootsminicms/diff_nospace.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\flatbootsminicms/diff_nospace.tmp"
@@ -0,0 +1,146 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\flatbootsminicms/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\flatbootsminicms/composer.json"
+index 4b8f21091..a89ae57bf 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\flatbootsminicms/composer.json"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\flatbootsminicms/composer.json"
+@@ -17,7 +17,7 @@
+ 		"php": ">=5.4"
+ 	},
+ 	"extra": {
+-		"display-name": "FLATBOOTS Mini CMS",
++		"display-name": "FLATBOOTS Mini CMS - Mod",
+ 		"soft-require": {
+ 			"phpbb/phpbb": ">=3.1.5"
+ 		},
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\flatbootsminicms/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\flatbootsminicms/diff_full.tmp"
+new file mode 100644
+index 000000000..65c23a6e1
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\flatbootsminicms/diff_full.tmp"
+@@ -0,0 +1,170 @@
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\flatbootsminicms/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\flatbootsminicms/composer.json"
++index 4b8f21091..a89ae57bf 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\flatbootsminicms/composer.json"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\flatbootsminicms/composer.json"
++@@ -17,7 +17,7 @@
++ 		"php": ">=5.4"
++ 	},
++ 	"extra": {
++-		"display-name": "FLATBOOTS Mini CMS",
+++		"display-name": "FLATBOOTS Mini CMS - Mod",
++ 		"soft-require": {
++ 			"phpbb/phpbb": ">=3.1.5"
++ 		},
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\flatbootsminicms/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\flatbootsminicms/diff_full.tmp"
++new file mode 100644
++index 000000000..e69de29bb
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\flatbootsminicms/event/listener.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\flatbootsminicms/event/listener.php"
++index fd3231f68..8655d345b 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\flatbootsminicms/event/listener.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\flatbootsminicms/event/listener.php"
++@@ -273,7 +273,7 @@ class listener implements EventSubscriberInterface
++ 			);
++ 			$result = $this->db->sql_query($this->db->sql_build_query('SELECT', $sql_ary));
++ 			while ($row = $this->db->sql_fetchrow($result)) {
++-				if (($row['button_only_registered'] && $this->user->data['user_id'] == ANONYMOUS) || ($row['button_only_guest'] && $this->user->data['user_id'] != ANONYMOUS))
+++				if (($row['button_only_registered'] && $user->data['user_id'] == ANONYMOUS) || ($row['button_only_guest'] && $user->data['user_id'] != ANONYMOUS))
++ 				{
++ 					continue;
++ 				}
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\flatbootsminicms/images/logo/logotipo_v4.png" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\flatbootsminicms/images/logo/logotipo_v4.png"
++new file mode 100644
++index 000000000..8274b052d
++Binary files /dev/null and "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\flatbootsminicms/images/logo/logotipo_v4.png" differ
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\flatbootsminicms/styles/FLATBOOTS/template/event/flatboots_navigation_instead.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\flatbootsminicms/styles/FLATBOOTS/template/event/flatboots_navigation_instead.html"
++index 292b677fd..6bd70c078 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\flatbootsminicms/styles/FLATBOOTS/template/event/flatboots_navigation_instead.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\flatbootsminicms/styles/FLATBOOTS/template/event/flatboots_navigation_instead.html"
++@@ -16,8 +16,10 @@
++ 				   <!-- EVENT overall_header_mobile_navigation_append -->
++ 				   <li><a title="" href="{U_UCP_PROFILE_SETTINGS}"><i class="fa fa-cog"></i>&nbsp;{L_UCP_PROFILE_SETTINGS}</a></li>
++ 	               <!-- IF U_ACP --><li><a title="" href="{U_ACP}"><i class="fa fa-user-md"></i>&nbsp;{L_ADMIN_PANEL_GENERAL}</a></li><!-- ENDIF -->
++-	               <!-- IF U_MCP --><li><a href="{U_MCP}"><i class="fa fa-legal"></i>&nbsp;{L_MODERATOR_PANEL_GENERAL}</a></li><!-- ENDIF -->
++-				   <!-- IF S_REGISTERED_USER and not (U_ACP or U_MCP) --><li><a href="{U_PROFILE}"><i class="fa fa-user"></i>&nbsp;{L_USER_PANEL}</a></li><!-- ENDIF -->
+++	               <!-- IF U_MCP --><li><a href="{U_MCP}"><i class="fa fa-legal"></i>&nbsp;{L_MODERATOR_PANEL_GENERAL}</a></li><!-- ELSEIF U_MCP_HELP -->
+++				   <li><a href="{U_MCP_HELP}"><i class="fa fa-legal"></i>&nbsp;{L_MODERATOR_PANEL_GENERAL}</a></li>
+++				   <!-- ENDIF -->
+++				   <!-- IF S_REGISTERED_USER --><li><a href="{U_PROFILE}"><i class="fa fa-user"></i>&nbsp;{L_USER_PANEL}</a></li><!-- ENDIF -->
++ 				   <!-- IF U_RESTORE_PERMISSIONS --><li><a href="{U_RESTORE_PERMISSIONS}"><i class="fa fa-random"></i>&nbsp;{L_RESTORE_PERMISSIONS}</a></li><!-- ENDIF -->
++ 				  <li><a title="" href="{U_LOGIN_LOGOUT}"><i class="fa fa-power-off"></i>&nbsp;{L_LOGOUT}</a></li>
++ 				  <!-- EVENT overall_header_mobile_navigation_ending -->
++@@ -54,7 +56,7 @@
++        <span class="dropdown-arrow"></span>
++         <ul class="dropdown-menu">
++ 			<!-- EVENT overall_header_navigation_prepend -->
++-			 <li><a href="{U_FAQ}"><i class="fa fa-question-circle"></i>{L_FAQ}</a></li>
+++			<!-- <li><a href="{U_FAQ}"><i class="fa fa-question-circle"></i>{L_FAQ}</a></li> -->
++ 			<!-- EVENT overall_header_navigation_append -->
++         </ul>
++     </li>
++@@ -80,13 +82,13 @@
++ 	<div class="user-login hidden-xs">
++ 		<ul class="nav navbar-nav navbar-right navbar-nav-fancy">
++ 		<!-- EVENT navigation_controls_before -->
++-		<li><a class="btn-search" href="javascript:void(0)"><i class="fa fa-lightbulb-o"></i></a></li>
+++		<li><a class="btn-search" href="javascript:void(0)"><i class="fa fa-search"></i></a></li>
++ 		<!-- EVENT navigation_controls_after -->
++ 		<!-- IF S_NOTIFICATIONS_DISPLAY -->	
++ 		    <li class="dropdown dropdown-avatar dropdown-notification">
++ 			  <a id="notification_list_button" href="javascript:void(0)" data-toggle="dropdown"><i class="fa fa-bell"></i><!-- IF .notifications and NOTIFICATIONS_COUNT --><em class="notifications badge badge-danger">{NOTIFICATIONS_COUNT}</em><!-- ENDIF --></a>
++                 <ul class="dropdown-menu user-login-drop arrow-up">
++-                 <li><a href="{U_VIEW_ALL_NOTIFICATIONS}" class="notification-heading">{L_NOTIFICATIONS}</a></li>
+++                 <li><a href="/forum/ucp.php?i=-forumhulp-notification_manager-ucp-noties_module&mode=noties" class="notification-heading btn btn-default btn-sm">{L_NOTIFICATIONS}</a></li>
++                    <!-- INCLUDE notification_dropdown.html -->
++                 </ul>
++             </li>
++@@ -94,7 +96,7 @@
++ 			
++ 			<li class="dropdown dropdown-avatar">
++ 			  <a href="javascript:void(0)" data-toggle="dropdown">
++-			   <!-- IF CURRENT_USER_AVATAR -->{CURRENT_USER_AVATAR}&nbsp;<!-- ELSE --><img src="{T_THEME_PATH}/images/user4.png" alt="No avatar"><!-- ENDIF -->&nbsp;<span>{L_WELCOME_INDEX}&#44;&nbsp;{CURRENT_USERNAME_SIMPLE}<i class="caret"></i></span>
+++			   <!-- IF CURRENT_USER_AVATAR -->{CURRENT_USER_AVATAR}&nbsp;<!-- ELSE --><img src="{T_THEME_PATH}/images/user.png" alt="No avatar"><!-- ENDIF -->&nbsp;<span>{L_WELCOME_INDEX}&#44;&nbsp;{CURRENT_USERNAME_SIMPLE}<i class="caret"></i></span>
++ 			  </a>
++                 <!-- IF S_USER_NEW_PRIVMSG --><em class="notifications-pm badge badge-warning">{PM_NEW_COUNT_BADGE}</em><!-- ELSEIF S_USER_UNREAD_PRIVMSG --><em class="notifications-pm badge badge-success">{PRIVATE_MESSAGE_COUNT}</em><!-- ENDIF -->                   
++ 				   <ul class="dropdown-menu user-login-drop arrow-up">
++@@ -104,7 +106,7 @@
++                               <div class="navbar-content navbar-avatar">
++                                     <div class="row">
++                                         <div class="col-md-5 col-xs-5">
++-                                          <!-- IF CURRENT_USER_AVATAR -->{CURRENT_USER_AVATAR}<!-- ELSE --><img src="{T_THEME_PATH}/images/user4.png" alt="No avatar"><!-- ENDIF -->
+++                                          <!-- IF CURRENT_USER_AVATAR -->{CURRENT_USER_AVATAR}<!-- ELSE --><img src="{T_THEME_PATH}/images/user.png" alt="No avatar"><!-- ENDIF -->
++                                             <p class="text-center"><a href="{U_UCP_PROFILE_AVATAR}">
++                                                 <small>{L_CHANGE_AVATAR}</small>
++                                             </a></p>
++@@ -112,20 +114,40 @@
++                                         <div class="col-md-7 col-xs-7"><span>{CURRENT_USERNAME_FULL}</span>
++                                             <p class="text-muted small">{USER_EMAIL_MENU}</p>
++                                              <!-- IF U_ACP --><a class="btn btn-info btn-sm btn-block" href="{U_ACP}"><i class="fa fa-user-md"></i>&nbsp;{L_ADMIN_PANEL_GENERAL}</a><!-- ENDIF -->
++-	                                         <!-- IF U_MCP --><a class="btn btn-warning btn-sm btn-block" href="{U_MCP}"><i class="fa fa-legal"></i>&nbsp;{L_MODERATOR_PANEL_GENERAL}</a><!-- ENDIF -->
++-                                             <!-- IF S_REGISTERED_USER and not (U_ACP or U_MCP) --><a class="btn btn-success btn-sm btn-block" href="{U_PROFILE}"><i class="fa fa-user"></i>&nbsp;{L_USER_PANEL}</a><!-- ENDIF -->
+++	                                         <!-- IF U_MCP and SCRIPT_NAME neq 'mcp' --><a class="btn btn-warning btn-sm btn-block" href="{U_MCP}"><i class="fa fa-legal"></i>&nbsp;{L_MODERATOR_PANEL_GENERAL}</a><!-- ENDIF -->
+++                                             <!-- IF S_REGISTERED_USER and SCRIPT_NAME neq 'ucp' --><a class="btn btn-success btn-sm btn-block" href="{U_PROFILE}"><i class="fa fa-user"></i>&nbsp;{L_USER_PANEL}</a><!-- ENDIF -->
+++											 <!-- EVENT navbar_header_profile_list_after -->
+++											 <!-- IF .accountswitch -->
+++												<div class="navbar-footer">
+++													<div class="navbar-footer-content">
+++														<div class="row">
+++															<!-- IF U_RESTORE_PERMISSIONS -->
+++															<div class="col-md-6 col-xs-6"><a class="btn btn-warning btn-sm" href="{U_RESTORE_PERMISSIONS}"><i class="fa fa-random"></i>&nbsp;{L_RESTORE_PERMISSIONS}</a></div>
+++															<!-- ELSE -->
+++															<div class="col-md-6 col-xs-6"><a class="btn btn-default btn-sm" href="{U_UCP_PROFILE_SETTINGS}"><i class="fa fa-key"></i>&nbsp;{L_CHANGE_PASSWORD}</a></div>
+++															<!-- ENDIF -->
+++															<div class="col-md-6 col-xs-6"><a class="btn btn-default btn-sm pull-right" href="{U_LOGIN_LOGOUT}"><i class="fa fa-sign-out"></i>&nbsp;{L_LOGOUT}</a></div>
+++														</div>
+++													</div>
+++											   </div>
+++											 <!-- ENDIF -->
++ 										</div>
++                                     </div>
++ 							  </div>
++-							  <!-- EVENT navbar_header_profile_list_after -->
+++							<!-- IF not .accountswitch -->
++ 							  <div class="navbar-footer">
++                                     <div class="navbar-footer-content">
++                                         <div class="row">
++-                                            <div class="col-md-6 col-xs-6"><a class="btn btn-default btn-sm" href="{U_UCP_PROFILE_SETTINGS}">{L_CHANGE_PASSWORD}</a></div>
++-                                            <div class="col-md-6 col-xs-6"><a class="btn btn-default btn-sm pull-right" href="{U_LOGIN_LOGOUT}">{L_LOGOUT}</a></div>
+++  
\ No newline at end of file
diff --git "[ORIGINAL]/sitesplat\\flatbootsminicms/event/listener.php" "[FORUM_EXT]/sitesplat\\flatbootsminicms/event/listener.php"
--- "[ORIGINAL]/sitesplat\\flatbootsminicms/event/listener.php"
+++ "[FORUM_EXT]/sitesplat\\flatbootsminicms/event/listener.php"
@@ -273,7 +273,7 @@ class listener implements EventSubscriberInterface
 			);
 			$result = $this->db->sql_query($this->db->sql_build_query('SELECT', $sql_ary));
 			while ($row = $this->db->sql_fetchrow($result)) {
-				if (($row['button_only_registered'] && $this->user->data['user_id'] == ANONYMOUS) || ($row['button_only_guest'] && $this->user->data['user_id'] != ANONYMOUS))
+				if (($row['button_only_registered'] && $user->data['user_id'] == ANONYMOUS) || ($row['button_only_guest'] && $user->data['user_id'] != ANONYMOUS))
 				{
 					continue;
 				}
diff --git "[FORUM_EXT]/sitesplat\\flatbootsminicms/images/logo/logotipo_v4.png" "[FORUM_EXT]/sitesplat\\flatbootsminicms/images/logo/logotipo_v4.png"
new file mode 100644
Binary files /dev/null and "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\flatbootsminicms/images/logo/logotipo_v4.png" differ
diff --git "[ORIGINAL]/sitesplat\\flatbootsminicms/styles/FLATBOOTS/template/event/flatboots_navigation_instead.html" "[FORUM_EXT]/sitesplat\\flatbootsminicms/styles/FLATBOOTS/template/event/flatboots_navigation_instead.html"
--- "[ORIGINAL]/sitesplat\\flatbootsminicms/styles/FLATBOOTS/template/event/flatboots_navigation_instead.html"
+++ "[FORUM_EXT]/sitesplat\\flatbootsminicms/styles/FLATBOOTS/template/event/flatboots_navigation_instead.html"
@@ -16,8 +16,10 @@
 				   <!-- EVENT overall_header_mobile_navigation_append -->
 				   <li><a title="" href="{U_UCP_PROFILE_SETTINGS}"><i class="fa fa-cog"></i>&nbsp;{L_UCP_PROFILE_SETTINGS}</a></li>
 	               <!-- IF U_ACP --><li><a title="" href="{U_ACP}"><i class="fa fa-user-md"></i>&nbsp;{L_ADMIN_PANEL_GENERAL}</a></li><!-- ENDIF -->
-	               <!-- IF U_MCP --><li><a href="{U_MCP}"><i class="fa fa-legal"></i>&nbsp;{L_MODERATOR_PANEL_GENERAL}</a></li><!-- ENDIF -->
-				   <!-- IF S_REGISTERED_USER and not (U_ACP or U_MCP) --><li><a href="{U_PROFILE}"><i class="fa fa-user"></i>&nbsp;{L_USER_PANEL}</a></li><!-- ENDIF -->
+	               <!-- IF U_MCP --><li><a href="{U_MCP}"><i class="fa fa-legal"></i>&nbsp;{L_MODERATOR_PANEL_GENERAL}</a></li><!-- ELSEIF U_MCP_HELP -->
+				   <li><a href="{U_MCP_HELP}"><i class="fa fa-legal"></i>&nbsp;{L_MODERATOR_PANEL_GENERAL}</a></li>
+				   <!-- ENDIF -->
+				   <!-- IF S_REGISTERED_USER --><li><a href="{U_PROFILE}"><i class="fa fa-user"></i>&nbsp;{L_USER_PANEL}</a></li><!-- ENDIF -->
 				   <!-- IF U_RESTORE_PERMISSIONS --><li><a href="{U_RESTORE_PERMISSIONS}"><i class="fa fa-random"></i>&nbsp;{L_RESTORE_PERMISSIONS}</a></li><!-- ENDIF -->
 				  <li><a title="" href="{U_LOGIN_LOGOUT}"><i class="fa fa-power-off"></i>&nbsp;{L_LOGOUT}</a></li>
 				  <!-- EVENT overall_header_mobile_navigation_ending -->
@@ -54,7 +56,7 @@
        <span class="dropdown-arrow"></span>
         <ul class="dropdown-menu">
 			<!-- EVENT overall_header_navigation_prepend -->
-			 <li><a href="{U_FAQ}"><i class="fa fa-question-circle"></i>{L_FAQ}</a></li>
+			<!-- <li><a href="{U_FAQ}"><i class="fa fa-question-circle"></i>{L_FAQ}</a></li> -->
 			<!-- EVENT overall_header_navigation_append -->
         </ul>
     </li>
@@ -80,13 +82,13 @@
 	<div class="user-login hidden-xs">
 		<ul class="nav navbar-nav navbar-right navbar-nav-fancy">
 		<!-- EVENT navigation_controls_before -->
-		<li><a class="btn-search" href="javascript:void(0)"><i class="fa fa-lightbulb-o"></i></a></li>
+		<li><a class="btn-search" href="javascript:void(0)"><i class="fa fa-search"></i></a></li>
 		<!-- EVENT navigation_controls_after -->
 		<!-- IF S_NOTIFICATIONS_DISPLAY -->	
 		    <li class="dropdown dropdown-avatar dropdown-notification">
 			  <a id="notification_list_button" href="javascript:void(0)" data-toggle="dropdown"><i class="fa fa-bell"></i><!-- IF .notifications and NOTIFICATIONS_COUNT --><em class="notifications badge badge-danger">{NOTIFICATIONS_COUNT}</em><!-- ENDIF --></a>
                 <ul class="dropdown-menu user-login-drop arrow-up">
-                 <li><a href="{U_VIEW_ALL_NOTIFICATIONS}" class="notification-heading">{L_NOTIFICATIONS}</a></li>
+                 <li><a href="/forum/ucp.php?i=-forumhulp-notification_manager-ucp-noties_module&mode=noties" class="notification-heading btn btn-default btn-sm">{L_NOTIFICATIONS}</a></li>
                    <!-- INCLUDE notification_dropdown.html -->
                 </ul>
             </li>
@@ -94,7 +96,7 @@
 			
 			<li class="dropdown dropdown-avatar">
 			  <a href="javascript:void(0)" data-toggle="dropdown">
-			   <!-- IF CURRENT_USER_AVATAR -->{CURRENT_USER_AVATAR}&nbsp;<!-- ELSE --><img src="{T_THEME_PATH}/images/user4.png" alt="No avatar"><!-- ENDIF -->&nbsp;<span>{L_WELCOME_INDEX}&#44;&nbsp;{CURRENT_USERNAME_SIMPLE}<i class="caret"></i></span>
+			   <!-- IF CURRENT_USER_AVATAR -->{CURRENT_USER_AVATAR}&nbsp;<!-- ELSE --><img src="{T_THEME_PATH}/images/user.png" alt="No avatar"><!-- ENDIF -->&nbsp;<span>{L_WELCOME_INDEX}&#44;&nbsp;{CURRENT_USERNAME_SIMPLE}<i class="caret"></i></span>
 			  </a>
                 <!-- IF S_USER_NEW_PRIVMSG --><em class="notifications-pm badge badge-warning">{PM_NEW_COUNT_BADGE}</em><!-- ELSEIF S_USER_UNREAD_PRIVMSG --><em class="notifications-pm badge badge-success">{PRIVATE_MESSAGE_COUNT}</em><!-- ENDIF -->                   
 				   <ul class="dropdown-menu user-login-drop arrow-up">
@@ -104,7 +106,7 @@
                               <div class="navbar-content navbar-avatar">
                                     <div class="row">
                                         <div class="col-md-5 col-xs-5">
-                                          <!-- IF CURRENT_USER_AVATAR -->{CURRENT_USER_AVATAR}<!-- ELSE --><img src="{T_THEME_PATH}/images/user4.png" alt="No avatar"><!-- ENDIF -->
+                                          <!-- IF CURRENT_USER_AVATAR -->{CURRENT_USER_AVATAR}<!-- ELSE --><img src="{T_THEME_PATH}/images/user.png" alt="No avatar"><!-- ENDIF -->
                                             <p class="text-center"><a href="{U_UCP_PROFILE_AVATAR}">
                                                 <small>{L_CHANGE_AVATAR}</small>
                                             </a></p>
@@ -112,20 +114,40 @@
                                         <div class="col-md-7 col-xs-7"><span>{CURRENT_USERNAME_FULL}</span>
                                             <p class="text-muted small">{USER_EMAIL_MENU}</p>
                                              <!-- IF U_ACP --><a class="btn btn-info btn-sm btn-block" href="{U_ACP}"><i class="fa fa-user-md"></i>&nbsp;{L_ADMIN_PANEL_GENERAL}</a><!-- ENDIF -->
-	                                         <!-- IF U_MCP --><a class="btn btn-warning btn-sm btn-block" href="{U_MCP}"><i class="fa fa-legal"></i>&nbsp;{L_MODERATOR_PANEL_GENERAL}</a><!-- ENDIF -->
-                                             <!-- IF S_REGISTERED_USER and not (U_ACP or U_MCP) --><a class="btn btn-success btn-sm btn-block" href="{U_PROFILE}"><i class="fa fa-user"></i>&nbsp;{L_USER_PANEL}</a><!-- ENDIF -->
+	                                         <!-- IF U_MCP and SCRIPT_NAME neq 'mcp' --><a class="btn btn-warning btn-sm btn-block" href="{U_MCP}"><i class="fa fa-legal"></i>&nbsp;{L_MODERATOR_PANEL_GENERAL}</a><!-- ENDIF -->
+                                             <!-- IF S_REGISTERED_USER and SCRIPT_NAME neq 'ucp' --><a class="btn btn-success btn-sm btn-block" href="{U_PROFILE}"><i class="fa fa-user"></i>&nbsp;{L_USER_PANEL}</a><!-- ENDIF -->
+											 <!-- EVENT navbar_header_profile_list_after -->
+											 <!-- IF .accountswitch -->
+												<div class="navbar-footer">
+													<div class="navbar-footer-content">
+														<div class="row">
+															<!-- IF U_RESTORE_PERMISSIONS -->
+															<div class="col-md-6 col-xs-6"><a class="btn btn-warning btn-sm" href="{U_RESTORE_PERMISSIONS}"><i class="fa fa-random"></i>&nbsp;{L_RESTORE_PERMISSIONS}</a></div>
+															<!-- ELSE -->
+															<div class="col-md-6 col-xs-6"><a class="btn btn-default btn-sm" href="{U_UCP_PROFILE_SETTINGS}"><i class="fa fa-key"></i>&nbsp;{L_CHANGE_PASSWORD}</a></div>
+															<!-- ENDIF -->
+															<div class="col-md-6 col-xs-6"><a class="btn btn-default btn-sm pull-right" href="{U_LOGIN_LOGOUT}"><i class="fa fa-sign-out"></i>&nbsp;{L_LOGOUT}</a></div>
 														</div>
 													</div>
 											   </div>
-							  <!-- EVENT navbar_header_profile_list_after -->
+											 <!-- ENDIF -->
+										</div>
+                                    </div>
+							  </div>
+							<!-- IF not .accountswitch -->
 							  <div class="navbar-footer">
                                     <div class="navbar-footer-content">
                                         <div class="row">
-                                            <div class="col-md-6 col-xs-6"><a class="btn btn-default btn-sm" href="{U_UCP_PROFILE_SETTINGS}">{L_CHANGE_PASSWORD}</a></div>
-                                            <div class="col-md-6 col-xs-6"><a class="btn btn-default btn-sm pull-right" href="{U_LOGIN_LOGOUT}">{L_LOGOUT}</a></div>
+                                            <!-- IF U_RESTORE_PERMISSIONS -->
+                                            <div class="col-md-6 col-xs-6"><a class="btn btn-warning btn-sm" href="{U_RESTORE_PERMISSIONS}"><i class="fa fa-random"></i>&nbsp;{L_RESTORE_PERMISSIONS}</a></div>
+                                            <!-- ELSE -->
+                                            <div class="col-md-6 col-xs-6"><a class="btn btn-default btn-sm" href="{U_UCP_PROFILE_SETTINGS}"><i class="fa fa-key"></i>&nbsp;{L_CHANGE_PASSWORD}</a></div>
+                                            <!-- ENDIF -->
+                                            <div class="col-md-6 col-xs-6"><a class="btn btn-default btn-sm pull-right" href="{U_LOGIN_LOGOUT}"><i class="fa fa-sign-out"></i>&nbsp;{L_LOGOUT}</a></div>
                                         </div>
                                     </div>
                                </div>
+							<!-- ENDIF -->
 							</div>
                         </li>
                     </ul>
diff --git "[ORIGINAL]/sitesplat\\flatbootsminicms/styles/FLATBOOTS/template/event/prefooter_instead.html" "[FORUM_EXT]/sitesplat\\flatbootsminicms/styles/FLATBOOTS/template/event/prefooter_instead.html"
--- "[ORIGINAL]/sitesplat\\flatbootsminicms/styles/FLATBOOTS/template/event/prefooter_instead.html"
+++ "[FORUM_EXT]/sitesplat\\flatbootsminicms/styles/FLATBOOTS/template/event/prefooter_instead.html"
@@ -3,21 +3,21 @@
 		<div class="container center">
 			<div class="row">
 				<div class="col-sm-5 twitter">
-					<div class="thumb"><i class="fa fa-paw"></i></div>
+					<div class="thumb"><img src="{T_THEME_PATH}/images/simbologold.svg" alt="S&iacute;mbolo Gold"></div>
 					<div class="text">
 						<h3>{ABOUT_US_TITLE}</h3>
 						<p>{ABOUT_US}</p>
 					</div>
 				</div>
 				<div class="col-sm-5 col-sm-offset-2 twitter">
-					<div class="thumb"><i class="fa fa-twitter"></i></div>
+					<div class="thumb"><i class="fa fa-instagram"></i></div>
 					<div class="text">
-						<h3><a href="https://twitter.com/{TWITTER_SCREEN_NAME}">{L_JOIN_US_TWITTER}&nbsp;<small>@{TWITTER_SCREEN_NAME}</small></a></h3>
+						<h3><a href="https://www.instagram.com/{TWITTER_SCREEN_NAME}">{L_JOIN_US_TWITTER}&nbsp;<small>@{TWITTER_SCREEN_NAME}</small></a></h3>
 						 <div id="twitter-feed"></div>
 					</div>
 				</div>
 			</div>
 		</div>
-		 <div class="section-bg"></div>
+		<!--<div class="section-bg"></div>-->
 	</section>
 <!-- ENDIF -->
\ No newline at end of file
```
