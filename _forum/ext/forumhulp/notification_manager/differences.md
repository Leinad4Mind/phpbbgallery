Existem diferencas reais no codigo ou texto. Diferencas de formatacao (espacos, tabs) foram ignoradas abaixo.

```diff
diff --git "[FORUM_EXT]/forumhulp\\notification_manager/diff_full.tmp" "[FORUM_EXT]/forumhulp\\notification_manager/diff_full.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/forumhulp\\notification_manager/diff_full.tmp"
@@ -0,0 +1,281 @@
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\notification_manager/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\notification_manager/diff_full.tmp"
+new file mode 100644
+index 000000000..e69de29bb
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\notification_manager/language/en/info_ucp_notification_manager.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\notification_manager/language/en/info_ucp_notification_manager.php"
+index e874b926d..7684361a6 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\notification_manager/language/en/info_ucp_notification_manager.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\notification_manager/language/en/info_ucp_notification_manager.php"
+@@ -40,12 +40,22 @@ if (empty($lang) || !is_array($lang))
+ $lang = array_merge(
+ 	$lang, array(
+ 		'UCP_NOTIES'			=> 'Manage notifications',
+-		'UCP_NOTIES_EXPLAIN'	=> 'Managa your notifications',
+-		'MARK_DELETE'			=> 'Mark delete',
+-		'MARK_READ'				=> 'Mark read',
+-		'MARK_UNREAD'			=> 'Mark unread',
+-		'UNMARK_DELETE'			=> 'Unmark delete',
+-		'UNMARK_READ'			=> 'Unmark read',
+-		'UNMARK_UNREAD'			=> 'Unmark unread',
++		'UCP_NOTIES_EXPLAIN'	=> 'Manage your notifications',
++		'MARK_DELETE_SINGLE'	=> 'Mark to delete',
++		'MARK_READ_SINGLE'		=> 'Mark to read',
++		'MARK_UNREAD_SINGLE'	=> 'Mark to unread',
++		'MARK_DELETE'			=> 'Select all to delete',
++		'MARK_READ'				=> 'Select all to read',
++		'MARK_UNREAD'			=> 'Select all to unread',
++		'UNMARK_DELETE'			=> 'Unselect all to delete',
++		'UNMARK_READ'			=> 'Unselect all to read',
++		'UNMARK_UNREAD'			=> 'Unselect all to unread',
++		'MARK_DELETE_SELECTED'		=> 'Delete all marked',
++		'MARK_READ_SELECTED'		=> 'Mark all as read',
++		'MARK_UNREAD_SELECTED'		=> 'Mark all as unread',
++		'UNMARK_DELETE_SELECTED'	=> 'Unmark all to delete',
++		'UNMARK_READ_SELECTED'		=> 'Unmark all as read',
++		'UNMARK_UNREAD_SELECTED'	=> 'Unmark all as unread',
++		'UCP_NOTIES_SUBMIT'			=> 'Submit Selected',
+ 	)
+ );
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\notification_manager/language/pt/info_acp_notification_manager.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\notification_manager/language/pt/info_acp_notification_manager.php"
+new file mode 100644
+index 000000000..265ed3c3d
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\notification_manager/language/pt/info_acp_notification_manager.php"
+@@ -0,0 +1,45 @@
++<?php
++/**
++*
++* Notification_manager for the phpBB Forum Software package.
++*
++* @copyright (c) 2017 ForumHulp.com <http://forumhulp.com>
++* @license Proprietary
++*
++*/
++
++/**
++ * DO NOT CHANGE
++ */
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
++// DEVELOPERS PLEASE NOTE
++//
++// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
++//
++// Placeholders can now contain order information, e.g. instead of
++// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
++// translators to re-order the output of data while ensuring it remains correct
++//
++// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
++// equally where a string contains only two placeholders which are used to wrap text
++// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
++//
++// Some characters you may want to copy&paste:
++// ’ » “ ” …
++//
++
++$lang = array_merge(
++	$lang, array(
++	'FH_HELPER_NOTICE'				=> 'Forumhulp helper application does not exist!<br />Download <a href="https://github.com/ForumHulp/helper" target="_blank">forumhulp/helper</a> and copy the helper folder to your forumhulp extension folder.',
++		'NOTIFICATION_MANAGER_NOTICE'	=> '<div class="phpinfo"><p class="entry">This extension replaces your old notification manager in control panel.</p></div>'
++	)
++);
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\notification_manager/language/pt/info_ucp_notification_manager.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\notification_manager/language/pt/info_ucp_notification_manager.php"
+new file mode 100644
+index 000000000..133d173b8
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\notification_manager/language/pt/info_ucp_notification_manager.php"
+@@ -0,0 +1,61 @@
++<?php
++/**
++*
++* Notification_manager for the phpBB Forum Software package.
++*
++* @copyright (c) 2017 ForumHulp.com <http://forumhulp.com>
++* @license Proprietary
++*
++*/
++
++/**
++ * DO NOT CHANGE
++ */
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
++// DEVELOPERS PLEASE NOTE
++//
++// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
++//
++// Placeholders can now contain order information, e.g. instead of
++// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
++// translators to re-order the output of data while ensuring it remains correct
++//
++// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
++// equally where a string contains only two placeholders which are used to wrap text
++// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
++//
++// Some characters you may want to copy&paste:
++// ’ » “ ” …
++//
++
++$lang = array_merge(
++	$lang, array(
++		'UCP_NOTIES'				=> 'Gerir notificações',
++		'UCP_NOTIES_EXPLAIN'		=> 'Gere as tuas notificações',
++		'MARK_DELETE_SINGLE'		=> 'Marcar para Apagar',
++		'MARK_READ_SINGLE'			=> 'Marcar para Lida',
++		'MARK_UNREAD_SINGLE'		=> 'Marcar para Por Ler',
++		'MARK_DELETE'				=> 'Seleccionar Todas para Apagar',
++		'MARK_READ'					=> 'Seleccionar Todas para Lidas',
++		'MARK_UNREAD'				=> 'Seleccionar Todas para Por Ler',
++		'UNMARK_DELETE'				=> 'Desseleccionar Todas de Apagar',
++		'UNMARK_READ'				=> 'Desseleccionar Todas de Lidas',
++		'UNMARK_UNREAD'				=> 'Desseleccionar Todas de Por Ler',
++		'MARK_DELETE_SELECTED'		=> 'Apagar Marcadas',
++		'MARK_READ_SELECTED'		=> 'Marcar Lidas',
++		'MARK_UNREAD_SELECTED'		=> 'Marcar Por Ler',
++		'UNMARK_DELETE_SELECTED'	=> 'Desmarcar Apagar',
++		'UNMARK_READ_SELECTED'		=> 'Desmarcar Lidas',
++		'UNMARK_UNREAD_SELECTED'	=> 'Desmarcar Por Ler',
++		'UCP_NOTIES_SUBMIT'			=> 'Submeter Seleccionadas',
++	)
++);
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\notification_manager/styles/BBOOTS/template/event/overall_header_head_append.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\notification_manager/styles/FLATBOOTS/template/event/overall_header_head_append.html"
+similarity index 100%
+rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\notification_manager/styles/BBOOTS/template/event/overall_header_head_append.html"
+rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\notification_manager/styles/FLATBOOTS/template/event/overall_header_head_append.html"
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\notification_manager/styles/BBOOTS/template/js/noties.js" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\notification_manager/styles/FLATBOOTS/template/js/noties.js"
+similarity index 100%
+rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\notification_manager/styles/BBOOTS/template/js/noties.js"
+rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\notification_manager/styles/FLATBOOTS/template/js/noties.js"
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\notification_manager/styles/BBOOTS/template/ucp_noties.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\notification_manager/styles/FLATBOOTS/template/ucp_noties.html"
+similarity index 61%
+rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\notification_manager/styles/BBOOTS/template/ucp_noties.html"
+rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\notification_manager/styles/FLATBOOTS/template/ucp_noties.html"
+index 5368b6cc8..30e02ffbe 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\notification_manager/styles/BBOOTS/template/ucp_noties.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\notification_manager/styles/FLATBOOTS/template/ucp_noties.html"
+@@ -69,7 +69,7 @@
+ 				<!-- IF .pagination -->
+ 					<!-- INCLUDE pagination.html -->
+ 				<!-- ELSE -->
+-					<li class="active"><a>{PAGE_NUMBER}</a></li>	
++					<li class="active"><a>{PAGE_NUMBER}</a></li>
+ 				<!-- ENDIF -->
+ 			 </ul>
+ 		   </div>
+@@ -78,25 +78,33 @@
+         
+ 			<div class="clearfix">
+ 				<!-- BEGIN notification_list -->
+-				<div class="media panel panel-default panel-body notification_list">				
++				<div class="media panel panel-default panel-body notification_list">
+ 					<div class="notifications">
+ 							<div class="media-left">
+-							<!-- IF notification_list.AVATAR -->{notification_list.AVATAR}<!-- ELSE --><img class="media-object" src="{T_THEME_PATH}/images/no_avatar.gif" alt="" /><!-- ENDIF -->
++							<!-- IF notification_list.AVATAR -->{notification_list.AVATAR}<!-- ELSE --><img class="media-object" src="{T_THEME_PATH}/images/no-avatar.png" alt="" /><!-- ENDIF -->
+ 							</div>
+-							<div class="media-body <!-- IF notification_list.UNREAD --> noti-unread<!-- ELSE --><!-- ENDIF --><!-- IF notification_list.STYLING --> {notification_list.STYLING}<!-- ENDIF -->">					
++							<div class="media-body <!-- IF notification_list.UNREAD --> noti-unread<!-- ELSE --><!-- ENDIF --><!-- IF notification_list.STYLING --> {notification_list.STYLING}<!-- ENDIF -->">
+ 								<!-- IF notification_list.URL --><a href="<!-- IF notification_list.UNREAD -->{notification_list.U_MARK_READ}<!-- ELSE -->{notification_list.URL}<!-- ENDIF -->"><!-- ENDIF -->
+ 								 <p class="notifications_title">{notification_list.FORMATTED_TITLE}<!-- IF notification_list.REFERENCE --> {notification_list.REFERENCE}<!-- ENDIF --></p>
+-								 <!-- IF notification_list.URL --></a><!-- ENDIF -->				
++								 <!-- IF notification_list.URL --></a><!-- ENDIF -->
+ 								 <!-- IF notification_list.FORUM --><p class="notifications_forum">{notification_list.FORUM}</p><!-- ENDIF -->
+ 								 <!-- IF notification_list.REASON --><p class="notifications_reason">{notification_list.REASON}</p><!-- ENDIF -->
+ 								 <p class="notifications_time">{notification_list.TIME}</p>
+-							 <div class="mark pull-right"><input type="checkbox" name="mark[]" value="{notification_list.NOTIFICATION_ID}" class="dont-style" title="{L_MARK_READ}" <!-- IF not notification_list.UNREAD --> disabled="disabled"<!-- ENDIF --> />
+-                             <input type="checkbox" name="unmark[]" value="{notification_list.NOTIFICATION_ID}" class="dont-style" title="{L_MARK_UNREAD}" <!-- IF  notification_list.UNREAD --> disabled="disabled"<!-- ENDIF --> />
+-                             
+-                             <input type="checkbox" name="delete[]" value="{notification_list.NOTIFICATION_ID}" class="dont-style" title="{L_MARK_DELETE}" <!-- IF notification_list.UNREAD --> disabled="disabled"<!-- ENDIF --> />
+-                             </div>
++
++								<div class="pull-right">
++									 <div class="mark">
++										<!-- IF notification_list.UNREAD --><a class="btn btn-xs" title="{L_MARK_READ_SINGLE}" onclick="$('input[type=submit]').val('{L_UCP_NOTIES_SUBMIT}')"><!-- ENDIF -->
++											<input type="checkbox" name="mark[]" value="{notification_list.NOTIFICATION_ID}" title="{L_MARK_READ_SINGLE}"<!-- IF not notification_list.UNREAD --> disabled="disabled"<!-- ENDIF --> />
++										<!-- IF notification_list.UNREAD --></a><!-- ENDIF -->
++										<!-- IF not notification_list.UNREAD --><a class="btn btn-xs" title="{L_MARK_UNREAD_SINGLE}"onclick="$('input[type=submit]').val('{L_UCP_NOTIES_SUBMIT}')"><!-- ENDIF -->
++											<input type="checkbox" name="unmark[]" value="{notification_list.NOTIFICATION_ID}" title="{L_MARK_UNREAD_SINGLE}"<!-- IF notification_list.UNREAD --> disabled="disabled"<!-- ENDIF --> />
++										<!-- IF not notification_list.UNREAD --></a><!-- ENDIF -->
++										<!-- IF not notification_list.UNREAD --><a class="btn btn-xs" title="{L_MARK_DELETE_SINGLE}" onclick="$('input[type=submit]').val('{L_UCP_NOTIES_SUBMIT}')"><!-- ENDIF -->
++											<input type="checkbox" name="delete[]" value="{notification_list.NOTIFICATION_ID}" title="{L_MARK_DELETE_SINGLE}"<!-- IF notification_list.UNREAD --> disabled="disabled"<!-- ENDIF --> />
++										<!-- IF not notification_list.UNREAD --></a><!-- ENDIF -->
++									</div>
++								</div>
+ 							</div>
+-                         
+ 					</div>
+ 				</div>
+ 				<!-- END notification_list -->
+@@ -104,34 +112,34 @@
+ 			</div>
+ 
+ 		<div class="row">
+-			<div class="col-md-6">
++			<div class="col-md-5">
+ 			<!-- IF .notification_list -->
+ 			<div class="pull-left">
+ 				<input type="hidden" name="form_time" value="{FORM_TIME}" />
+ 				{S_HIDDEN_FIELDS}
+-				 <input type="submit" name="submit" value="{L_MARK_READ}" class="btn btn-default" />
++				 <input type="submit" name="submit" value="{L_UCP_NOTIES_SUBMIT}" class="btn btn-default" />
+ 				<div class="btn-group">
+-				 <a class="btn btn-default" onclick="$('input[name=mark\\[\\]]:not(:disabled)').prop('checked', true); return false;" title="{L_MARK_READ}"><i class="fa fa-check-square-o"></i></a>
+-				 <a class="btn btn-default" onclick="$('input[name=mark\\[\\]]:not(:disabled)').prop('checked', false); return false;" title="{L_UNMARK_READ}"><i class="fa fa-square-o"></i></a>
++				 <a class="btn btn-default" onclick="marklist('ucp', 'mark', true);marklist('ucp', 'unmark', false);marklist('ucp', 'delete', false);$('input[type=submit]').val('{L_MARK_READ_SELECTED}')" title="{L_MARK_READ}"><i class="fa fa-check-square-o"></i></a>
++				 <a class="btn btn-default" onclick="marklist('ucp', 'mark', false);$('input[type=submit]').val('{L_UNMARK_READ_SELECTED}')" title="{L_UNMARK_READ}"><i class="fa fa-square-o"></i></a>
+                  
+-                 <a class="btn btn-default" onclick="$('input[name=unmark\\[\\]]:not(:disabled)').prop('checked', true); return false;" title="{L_MARK_UNREAD}"><i class="fa fa-check-square-o"></i></a>
+-				 <a class="btn btn-default" onclick="$('input[name=unmark\\[\\]]:not(:disabled)').prop('checked', false); return false;" title="{L_UNMARK_UNREAD}"><i class="fa fa-square-o"></i></a>
++                 <a class="btn btn-default" onclick="marklist('ucp', 'unmark', true);marklist('ucp', 'mark', false);marklist('ucp', 'delete', false);$('input[type=submit]').val('{L_MARK_UNREAD_SELECTED}')" title="{L_MARK_UNREAD}"><i class="fa fa-check-square-o"></i></a>
++				 <a class="btn btn-default" onclick="marklist('ucp', 'unmark', false);$('input[type=submit]').val('{L_UNMARK_UNREAD_SELECTED}')" title="{L_UNMARK_UNREAD}"><i class="fa fa-square-o"></i></a>
+                  
+-                 <a class="btn btn-default" onclick="$('input[name=delete\\[\\]]:not(:disabled)').prop('checked', true); return false;" title="{L_MARK_DELETE}"><i class="fa fa-check-square-o"></i></a>
+-				 <a class="btn btn-default" onclick="$('input[name=delete\\[\\]]:not(:disabled)').prop('checked', false); return false;" title="{L_UNMARK_DELETE}"><i class="fa fa-square-o"></i></a>
++                 <a class="btn btn-default" onclick="marklist('ucp', 'delete', true);marklist('ucp', 'mark', false);marklist('ucp', 'unmark', false);$('input[type=submit]').val('{L_MARK_DELETE_SELECTED}')" title="{L_MARK_DELETE}"><i class="fa fa-check-square-o"></i></a>
++				 <a class="btn btn-default" onclick="marklist('ucp', 'delete', false);$('input[type=submit]').val('{L_UNMARK_DELETE_SELECTED}')" title="{L_UNMARK_DELETE}"><i class="fa fa-square-o"></i></a>
+ 				</div>
+ 				{S_FORM_TOKEN}
+ 			</div>
+ 		<!-- ENDIF -->
+ 			</div>
+ 
+-			<div class="col-md-6"> 
++			<div class="col-md-7"> 
+ 			 <ul class="pagination pagination-sm pull-right">
+ 				 <li><a>{L_NOTIFICATIONS}&nbsp;{TOTAL_COUNT}</a></li>
+ 				<!-- IF .pagination -->
+ 					<!-- INCLUDE pagination.html -->
+ 				<!-- ELSE -->
+-					<li class="active"><a>{PAGE_NUMBER}</a></li>	
++					<li class="active"><a>{PAGE_NUMBER}</a></li>
+ 				<!-- ENDIF -->
+ 			 </ul>
+ 		   </div>
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\notification_manager/styles/BBOOTS/theme/noties.css" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\notification_manager/styles/FLATBOOTS/theme/noties.css"
+similarity index 67%
+rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\notification_manager/styles/BBOOTS/theme/noties.css"
+rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\notification_manager/styles/FLATBOOTS/theme/noties.css"
+index 8bdaa3598..5e3e02b46 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\notification_manager/styles/BBOOTS/theme/noties.css"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\notification_manager/styles/FLATBOOTS/theme/noties.css"
+@@ -13,4 +13,3 @@ ul.topiclist.two-columns dt {
+     line-height: 2.2em;
+     font-size: 1.2em;
+ }
+-.dont-style {opacity:1 !important;position:relative !important; float:left;margin-left:10px !important;outline: 1px solid #ccc;}
+\ No newline at end of file
diff --git "[FORUM_EXT]/forumhulp\\notification_manager/diff_nospace.tmp" "[FORUM_EXT]/forumhulp\\notification_manager/diff_nospace.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/forumhulp\\notification_manager/diff_nospace.tmp"
@@ -0,0 +1,253 @@
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\notification_manager/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\notification_manager/diff_full.tmp"
+new file mode 100644
+index 000000000..cbb5b1c6d
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\notification_manager/diff_full.tmp"
+@@ -0,0 +1,281 @@
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\notification_manager/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\notification_manager/diff_full.tmp"
++new file mode 100644
++index 000000000..e69de29bb
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\notification_manager/language/en/info_ucp_notification_manager.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\notification_manager/language/en/info_ucp_notification_manager.php"
++index e874b926d..7684361a6 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\notification_manager/language/en/info_ucp_notification_manager.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\notification_manager/language/en/info_ucp_notification_manager.php"
++@@ -40,12 +40,22 @@ if (empty($lang) || !is_array($lang))
++ $lang = array_merge(
++ 	$lang, array(
++ 		'UCP_NOTIES'			=> 'Manage notifications',
++-		'UCP_NOTIES_EXPLAIN'	=> 'Managa your notifications',
++-		'MARK_DELETE'			=> 'Mark delete',
++-		'MARK_READ'				=> 'Mark read',
++-		'MARK_UNREAD'			=> 'Mark unread',
++-		'UNMARK_DELETE'			=> 'Unmark delete',
++-		'UNMARK_READ'			=> 'Unmark read',
++-		'UNMARK_UNREAD'			=> 'Unmark unread',
+++		'UCP_NOTIES_EXPLAIN'	=> 'Manage your notifications',
+++		'MARK_DELETE_SINGLE'	=> 'Mark to delete',
+++		'MARK_READ_SINGLE'		=> 'Mark to read',
+++		'MARK_UNREAD_SINGLE'	=> 'Mark to unread',
+++		'MARK_DELETE'			=> 'Select all to delete',
+++		'MARK_READ'				=> 'Select all to read',
+++		'MARK_UNREAD'			=> 'Select all to unread',
+++		'UNMARK_DELETE'			=> 'Unselect all to delete',
+++		'UNMARK_READ'			=> 'Unselect all to read',
+++		'UNMARK_UNREAD'			=> 'Unselect all to unread',
+++		'MARK_DELETE_SELECTED'		=> 'Delete all marked',
+++		'MARK_READ_SELECTED'		=> 'Mark all as read',
+++		'MARK_UNREAD_SELECTED'		=> 'Mark all as unread',
+++		'UNMARK_DELETE_SELECTED'	=> 'Unmark all to delete',
+++		'UNMARK_READ_SELECTED'		=> 'Unmark all as read',
+++		'UNMARK_UNREAD_SELECTED'	=> 'Unmark all as unread',
+++		'UCP_NOTIES_SUBMIT'			=> 'Submit Selected',
++ 	)
++ );
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\notification_manager/language/pt/info_acp_notification_manager.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\notification_manager/language/pt/info_acp_notification_manager.php"
++new file mode 100644
++index 000000000..265ed3c3d
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\notification_manager/language/pt/info_acp_notification_manager.php"
++@@ -0,0 +1,45 @@
+++<?php
+++/**
+++*
+++* Notification_manager for the phpBB Forum Software package.
+++*
+++* @copyright (c) 2017 ForumHulp.com <http://forumhulp.com>
+++* @license Proprietary
+++*
+++*/
+++
+++/**
+++ * DO NOT CHANGE
+++ */
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
+++// DEVELOPERS PLEASE NOTE
+++//
+++// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
+++//
+++// Placeholders can now contain order information, e.g. instead of
+++// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
+++// translators to re-order the output of data while ensuring it remains correct
+++//
+++// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
+++// equally where a string contains only two placeholders which are used to wrap text
+++// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
+++//
+++// Some characters you may want to copy&paste:
+++// ’ » “ ” …
+++//
+++
+++$lang = array_merge(
+++	$lang, array(
+++	'FH_HELPER_NOTICE'				=> 'Forumhulp helper application does not exist!<br />Download <a href="https://github.com/ForumHulp/helper" target="_blank">forumhulp/helper</a> and copy the helper folder to your forumhulp extension folder.',
+++		'NOTIFICATION_MANAGER_NOTICE'	=> '<div class="phpinfo"><p class="entry">This extension replaces your old notification manager in control panel.</p></div>'
+++	)
+++);
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\notification_manager/language/pt/info_ucp_notification_manager.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\notification_manager/language/pt/info_ucp_notification_manager.php"
++new file mode 100644
++index 000000000..133d173b8
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\notification_manager/language/pt/info_ucp_notification_manager.php"
++@@ -0,0 +1,61 @@
+++<?php
+++/**
+++*
+++* Notification_manager for the phpBB Forum Software package.
+++*
+++* @copyright (c) 2017 ForumHulp.com <http://forumhulp.com>
+++* @license Proprietary
+++*
+++*/
+++
+++/**
+++ * DO NOT CHANGE
+++ */
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
+++// DEVELOPERS PLEASE NOTE
+++//
+++// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
+++//
+++// Placeholders can now contain order information, e.g. instead of
+++// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
+++// translators to re-order the output of data while ensuring it remains correct
+++//
+++// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
+++// equally where a string contains only two placeholders which are used to wrap text
+++// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
+++//
+++// Some characters you may want to copy&paste:
+++// ’ » “ ” …
+++//
+++
+++$lang = array_merge(
+++	$lang, array(
+++		'UCP_NOTIES'				=> 'Gerir notificações',
+++		'UCP_NOTIES_EXPLAIN'		=> 'Gere as tuas notificações',
+++		'MARK_DELETE_SINGLE'		=> 'Marcar para Apagar',
+++		'MARK_READ_SINGLE'			=> 'Marcar para Lida',
+++		'MARK_UNREAD_SINGLE'		=> 'Marcar para Por Ler',
+++		'MARK_DELETE'				=> 'Seleccionar Todas para Apagar',
+++		'MARK_READ'					=> 'Seleccionar Todas para Lidas',
+++		'MARK_UNREAD'				=> 'Seleccionar Todas para Por Ler',
+++		'UNMARK_DELETE'				=> 'Desseleccionar Todas de Apagar',
+++		'UNMARK_READ'				=> 'Desseleccionar Todas de Lidas',
+++		'UNMARK_UNREAD'				=> 'Desseleccionar Todas de Por Ler',
+++		'MARK_DELETE_SELECTED'		=> 'Apagar Marcadas',
+++		'MARK_READ_SELECTED'		=> 'Marcar Lidas',
+++		'MARK_UNREAD_SELECTED'		=> 'Marcar Por Ler',
+++		'UNMARK_DELETE_SELECTED'	=> 'Desmarcar Apagar',
+++		'UNMARK_READ_SELECTED'		=> 'Desmarcar Lidas',
+++		'UNMARK_UNREAD_SELECTED'	=> 'Desmarcar Por Ler',
+++		'UCP_NOTIES_SUBMIT'			=> 'Submeter Seleccionadas',
+++	)
+++);
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\notification_manager/styles/BBOOTS/template/event/overall_header_head_append.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\notification_manager/styles/FLATBOOTS/template/event/overall_header_head_append.html"
++similarity index 100%
++rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\notification_manager/styles/BBOOTS/template/event/overall_header_head_append.html"
++rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\notification_manager/styles/FLATBOOTS/template/event/overall_header_head_append.html"
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\notification_manager/styles/BBOOTS/template/js/noties.js" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\notification_manager/styles/FLATBOOTS/template/js/noties.js"
++similarity index 100%
++rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\notification_manager/styles/BBOOTS/template/js/noties.js"
++rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\notification_manager/styles/FLATBOOTS/template/js/noties.js"
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\notification_manager/styles/BBOOTS/template/ucp_noties.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\notification_manager/styles/FLATBOOTS/template/ucp_noties.html"
++similarity index 61%
++rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\notification_manager/styles/BBOOTS/template/ucp_noties.html"
++rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\notification_manager/styles/FLATBOOTS/template/ucp_noties.html"
++index 5368b6cc8..30e02ffbe 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\notification_manager/styles/BBOOTS/template/ucp_noties.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\notification_manager/styles/FLATBOOTS/template/ucp_noties.html"
++@@ -69,7 +69,7 @@
++ 				<!-- IF .pagination -->
++ 					<!-- INCLUDE pagination.html -->
++ 				<!-- ELSE -->
++-					<li class="active"><a>{PAGE_NUMBER}</a></li>	
+++					<li class="active"><a>{PAGE_NUMBER}</a></li>
++ 				<!-- ENDIF -->
++ 			 </ul>
++ 		   </div>
++@@ -78,25 +78,33 @@
++         
++ 			<div class="clearfix">
++ 				<!-- BEGIN notification_list -->
++-				<div class="media panel panel-default panel-body notification_list">				
+++				<div class="media panel panel-default panel-body notification_list">
++ 					<div class="notifications">
++ 							<div class="media-left">
++-							<!-- IF notification_list.AVATAR -->{notification_list.AVATAR}<!-- ELSE --><img class="media-object" src="{T_THEME_PATH}/images/no_avatar.gif" alt="" /><!-- ENDIF -->
+++							<!-- IF notification_list.AVATAR -->{notification_list.AVATAR}<!-- ELSE --><img class="media-object" src="{T_THEME_PATH}/images/no-avatar.png" alt="" /><!-- ENDIF -->
++ 							</div>
++-							<div class="media-body <!-- IF notification_list.UNREAD --> noti-unread<!-- ELSE --><!-- ENDIF --><!-- IF notification_list.STYLING --> {notification_list.STYLING}<!-- ENDIF -->">					
+++							<div class="media-body <!-- IF notification_list.UNREAD --> noti-unread<!-- ELSE --><!-- ENDIF --><!-- IF notification_list.STYLING --> {notification_list.STYLING}<!-- ENDIF -->">
++ 								<!-- IF notification_list.URL --><a href="<!-- IF notification_list.UNREAD -->{notification_list.U_MARK_READ}<!-- ELSE -->{notification_list.URL}<!-- ENDIF -->"><!-- ENDIF -->
++ 								 <p class="notifications_title">{notification_list.FORMATTED_TITLE}<!-- IF notification_list.REFERENCE --> {notification_list.REFERENCE}<!-- ENDIF --></p>
++-								 <!-- IF notification_list.URL --></a><!-- ENDIF -->				
+++								 <!-- IF notification_list.URL --></a><!-- ENDIF -->
++ 								 <!-- IF notification_list.FORUM --><p class="notifications_forum">{notification_list.FORUM}</p><!-- ENDIF -->
++ 								 <!-- IF notification_list.REASON --><p class="notifications_reason">{notification_list.REASON}</p><!-- ENDIF -->
++ 								 <p class="notifications_time">{notification_list.TIME}</p>
++-							 <div class="mark pull-right"><input type="checkbox" name="mark[]" value="{notification_list.NOTIFICATION_ID}" class="dont-style" title="{L_MARK_READ}" <!-- IF not notification_list.UNREAD --> disabled="disabled"<!-- ENDIF --> />
++-                             <input type="checkbox" name="unmark[]" value="{notification_list.NOTIFICATION_ID}" class="dont-style" title="{L_MARK_UNREAD}" <!-- IF  notification_list.UNREAD --> disabled="disabled"<!-- ENDIF --> />
++-                             
++-                             <input type="checkbox" name="delete[]" value="{notification_list.NOTIFICATION_ID}" class="dont-style" title="{L_MARK_DELETE}" <!-- IF notification_list.UNREAD --> disabled="disabled"<!-- ENDIF --> />
++-                             </div>
+++
+++								<div class="pull-right">
+++									 <div class="mark">
+++										<!-- IF notification_list.UNREAD --><a class="btn btn-xs" title="{L_MARK_READ_SINGLE}" onclick="$('input[type=submit]').val('{L_UCP_NOTIES_SUBMIT}')"><!-- ENDIF -->
+++											<input type="checkbox" name="mark[]" value="{notification_list.NOTIFICATION_ID}" title="{L_MARK_READ_SINGLE}"<!-- IF not notification_list.UNREAD --> disabled="disabled"<!-- ENDIF --> />
+++										<!-- IF notification_list.UNREAD --></a><!-- ENDIF -->
+++										<!-- IF not notification_list.UNREAD --><a class="btn btn-xs" title="{L_MARK_UNREAD_SINGLE}"onclick="$('input[type=submit]').val('{L_UCP_NOTIES_SUBMIT}')"><!-- ENDIF -->
+++											<input type="checkbox" name="unmark[]" value="{notification_list.NOTIFICATION_ID}" title="{L_MARK_UNREAD_SINGLE}"<!-- IF notification_list.UNREAD --> disabled="disabled"<!-- ENDIF --> />
+++										<!-- IF not notification_list.UNREAD --></a><!-- ENDIF -->
+++										<!-- IF not notification_list.UNREAD --><a class="btn btn-xs" title="{L_MARK_DELETE_SINGLE}" onclick="$('input[type=submit]').val('{L_UCP_NOTIES_SUBMIT}')"><!-- ENDIF -->
+++											<input type="checkbox" name="delete[]" value="{notification_list.NOTIFICATION_ID}" title="{L_MARK_DELETE_SINGLE}"<!-- IF notification_list.UNREAD --> disabled="disabled"<!-- ENDIF --> />
+++										<!-- IF not notification_list.UNREAD --></a><!-- ENDIF -->
+++									</div>
+++								</div>
++ 							</div>
++-                         
++ 					</div>
++ 				</div>
++ 				<!-- END notification_list -->
++@@ -104,34 +112,34 @@
++ 			</div>
++ 
++ 		<div class="row">
++-			<div class="col-md-6">
+++			<div class="col-md-5">
++ 			<!-- IF .notification_list -->
++ 			<div class="pull-left">
++ 				<input type="hidden" name="form_time" value="{FORM_TIME}" />
++ 				{S_HIDDEN_FIELDS}
++-				 <input type="submit" name="submit" value="{L_MARK_READ}" class="btn btn-default" />
+++				 <input type="submit" name="submit" value="{L_UCP_NOTIES_SUBMIT}" class="btn btn-default" />
++ 				<div class="btn-group">
++-				 <a class="btn btn-default" onclick="$('input[name=mark\\[\\]]:not(:disabled)').prop('checked', true); return false;" title="{L_MARK_READ}"><i class="fa fa-check-square-o"></i></a>
++-				 <a class="btn btn-default" onclick="$('input[name=mark\\[\\]]:not(:disabled)').prop('checked', false); return false;" title="{L_UNMARK_READ}"><i class="fa fa-square-o"></i></a>
+++				 <a class="btn btn-default" onclick="marklist('ucp', 'mark', true);marklist('ucp', 'unmark', false);marklist('ucp', 'delete', false);$('input[type=submit]').val('{L_MARK_READ_SELECTED}')" title="{L_MARK_READ}"><i class="fa fa-check-square-o"></i></a>
+++				 <a class="btn btn-default" onclick="marklist('ucp', 'mark', false);$('input[type=submit]').val('{L_UNMARK_READ_SELECTED}')" title="{L_UNMARK_READ}"><i class="fa fa-square-o"></i></a>
++                  
++-                 <a class="btn btn-default" onclick="$('input[name=unmark\\[\\]]:not(:disabled)').prop('checked', true); return false;" title="{L_MARK_UNREAD}"><i class="fa fa-check-square-o"></i></a>
++-				 <a class="btn btn-default" onclick="$('input[name=unmark\\[\\]]:not(:disabled)').prop('checked', false); return false;" title="{L_UNMARK_UNREAD}"><i class="fa fa-square-o"></i></a>
+++                 <a class="btn btn-default" onclick="marklist('ucp', 'unmark', true);marklist('ucp', 'mark', false);marklist('ucp', 'delete', false);$('input[type=submit]').val('{L_MARK_UNREAD_SELECTED}')" title="{L_MARK_UNREAD}"><i class="fa fa-check-square-o"></i></a>
+++				 <a class="btn btn-default" onclick="marklist('ucp', 'unmark', false);$('input[type=submit]').val('{L_UNMARK_UNREAD_SELECTED}')" title="{L_UNMARK_UNREAD}"><i class="fa fa-square-o"></i></a>
++                  
++-                 <a class="btn btn-default" 
\ No newline at end of file
diff --git "[ORIGINAL]/forumhulp\\notification_manager/language/en/info_ucp_notification_manager.php" "[FORUM_EXT]/forumhulp\\notification_manager/language/en/info_ucp_notification_manager.php"
--- "[ORIGINAL]/forumhulp\\notification_manager/language/en/info_ucp_notification_manager.php"
+++ "[FORUM_EXT]/forumhulp\\notification_manager/language/en/info_ucp_notification_manager.php"
@@ -40,12 +40,22 @@ if (empty($lang) || !is_array($lang))
 $lang = array_merge(
 	$lang, array(
 		'UCP_NOTIES'			=> 'Manage notifications',
-		'UCP_NOTIES_EXPLAIN'	=> 'Managa your notifications',
-		'MARK_DELETE'			=> 'Mark delete',
-		'MARK_READ'				=> 'Mark read',
-		'MARK_UNREAD'			=> 'Mark unread',
-		'UNMARK_DELETE'			=> 'Unmark delete',
-		'UNMARK_READ'			=> 'Unmark read',
-		'UNMARK_UNREAD'			=> 'Unmark unread',
+		'UCP_NOTIES_EXPLAIN'	=> 'Manage your notifications',
+		'MARK_DELETE_SINGLE'	=> 'Mark to delete',
+		'MARK_READ_SINGLE'		=> 'Mark to read',
+		'MARK_UNREAD_SINGLE'	=> 'Mark to unread',
+		'MARK_DELETE'			=> 'Select all to delete',
+		'MARK_READ'				=> 'Select all to read',
+		'MARK_UNREAD'			=> 'Select all to unread',
+		'UNMARK_DELETE'			=> 'Unselect all to delete',
+		'UNMARK_READ'			=> 'Unselect all to read',
+		'UNMARK_UNREAD'			=> 'Unselect all to unread',
+		'MARK_DELETE_SELECTED'		=> 'Delete all marked',
+		'MARK_READ_SELECTED'		=> 'Mark all as read',
+		'MARK_UNREAD_SELECTED'		=> 'Mark all as unread',
+		'UNMARK_DELETE_SELECTED'	=> 'Unmark all to delete',
+		'UNMARK_READ_SELECTED'		=> 'Unmark all as read',
+		'UNMARK_UNREAD_SELECTED'	=> 'Unmark all as unread',
+		'UCP_NOTIES_SUBMIT'			=> 'Submit Selected',
 	)
 );
diff --git "[FORUM_EXT]/forumhulp\\notification_manager/language/pt/info_acp_notification_manager.php" "[FORUM_EXT]/forumhulp\\notification_manager/language/pt/info_acp_notification_manager.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/forumhulp\\notification_manager/language/pt/info_acp_notification_manager.php"
@@ -0,0 +1,45 @@
+<?php
+/**
+*
+* Notification_manager for the phpBB Forum Software package.
+*
+* @copyright (c) 2017 ForumHulp.com <http://forumhulp.com>
+* @license Proprietary
+*
+*/
+
+/**
+ * DO NOT CHANGE
+ */
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
+// DEVELOPERS PLEASE NOTE
+//
+// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
+//
+// Placeholders can now contain order information, e.g. instead of
+// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
+// translators to re-order the output of data while ensuring it remains correct
+//
+// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
+// equally where a string contains only two placeholders which are used to wrap text
+// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
+//
+// Some characters you may want to copy&paste:
+// ’ » “ ” …
+//
+
+$lang = array_merge(
+	$lang, array(
+	'FH_HELPER_NOTICE'				=> 'Forumhulp helper application does not exist!<br />Download <a href="https://github.com/ForumHulp/helper" target="_blank">forumhulp/helper</a> and copy the helper folder to your forumhulp extension folder.',
+		'NOTIFICATION_MANAGER_NOTICE'	=> '<div class="phpinfo"><p class="entry">This extension replaces your old notification manager in control panel.</p></div>'
+	)
+);
diff --git "[FORUM_EXT]/forumhulp\\notification_manager/language/pt/info_ucp_notification_manager.php" "[FORUM_EXT]/forumhulp\\notification_manager/language/pt/info_ucp_notification_manager.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/forumhulp\\notification_manager/language/pt/info_ucp_notification_manager.php"
@@ -0,0 +1,61 @@
+<?php
+/**
+*
+* Notification_manager for the phpBB Forum Software package.
+*
+* @copyright (c) 2017 ForumHulp.com <http://forumhulp.com>
+* @license Proprietary
+*
+*/
+
+/**
+ * DO NOT CHANGE
+ */
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
+// DEVELOPERS PLEASE NOTE
+//
+// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
+//
+// Placeholders can now contain order information, e.g. instead of
+// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
+// translators to re-order the output of data while ensuring it remains correct
+//
+// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
+// equally where a string contains only two placeholders which are used to wrap text
+// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
+//
+// Some characters you may want to copy&paste:
+// ’ » “ ” …
+//
+
+$lang = array_merge(
+	$lang, array(
+		'UCP_NOTIES'				=> 'Gerir notificações',
+		'UCP_NOTIES_EXPLAIN'		=> 'Gere as tuas notificações',
+		'MARK_DELETE_SINGLE'		=> 'Marcar para Apagar',
+		'MARK_READ_SINGLE'			=> 'Marcar para Lida',
+		'MARK_UNREAD_SINGLE'		=> 'Marcar para Por Ler',
+		'MARK_DELETE'				=> 'Seleccionar Todas para Apagar',
+		'MARK_READ'					=> 'Seleccionar Todas para Lidas',
+		'MARK_UNREAD'				=> 'Seleccionar Todas para Por Ler',
+		'UNMARK_DELETE'				=> 'Desseleccionar Todas de Apagar',
+		'UNMARK_READ'				=> 'Desseleccionar Todas de Lidas',
+		'UNMARK_UNREAD'				=> 'Desseleccionar Todas de Por Ler',
+		'MARK_DELETE_SELECTED'		=> 'Apagar Marcadas',
+		'MARK_READ_SELECTED'		=> 'Marcar Lidas',
+		'MARK_UNREAD_SELECTED'		=> 'Marcar Por Ler',
+		'UNMARK_DELETE_SELECTED'	=> 'Desmarcar Apagar',
+		'UNMARK_READ_SELECTED'		=> 'Desmarcar Lidas',
+		'UNMARK_UNREAD_SELECTED'	=> 'Desmarcar Por Ler',
+		'UCP_NOTIES_SUBMIT'			=> 'Submeter Seleccionadas',
+	)
+);
diff --git "[ORIGINAL]/forumhulp\\notification_manager/styles/BBOOTS/template/event/overall_header_head_append.html" "[FORUM_EXT]/forumhulp\\notification_manager/styles/FLATBOOTS/template/event/overall_header_head_append.html"
similarity index 100%
rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\notification_manager/styles/BBOOTS/template/event/overall_header_head_append.html"
rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\notification_manager/styles/FLATBOOTS/template/event/overall_header_head_append.html"
diff --git "[ORIGINAL]/forumhulp\\notification_manager/styles/BBOOTS/template/js/noties.js" "[FORUM_EXT]/forumhulp\\notification_manager/styles/FLATBOOTS/template/js/noties.js"
similarity index 100%
rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\notification_manager/styles/BBOOTS/template/js/noties.js"
rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\notification_manager/styles/FLATBOOTS/template/js/noties.js"
diff --git "[ORIGINAL]/forumhulp\\notification_manager/styles/BBOOTS/template/ucp_noties.html" "[FORUM_EXT]/forumhulp\\notification_manager/styles/FLATBOOTS/template/ucp_noties.html"
similarity index 61%
rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\notification_manager/styles/BBOOTS/template/ucp_noties.html"
rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\notification_manager/styles/FLATBOOTS/template/ucp_noties.html"
--- "[ORIGINAL]/forumhulp\\notification_manager/styles/BBOOTS/template/ucp_noties.html"
+++ "[FORUM_EXT]/forumhulp\\notification_manager/styles/FLATBOOTS/template/ucp_noties.html"
@@ -81,7 +81,7 @@
 				<div class="media panel panel-default panel-body notification_list">
 					<div class="notifications">
 							<div class="media-left">
-							<!-- IF notification_list.AVATAR -->{notification_list.AVATAR}<!-- ELSE --><img class="media-object" src="{T_THEME_PATH}/images/no_avatar.gif" alt="" /><!-- ENDIF -->
+							<!-- IF notification_list.AVATAR -->{notification_list.AVATAR}<!-- ELSE --><img class="media-object" src="{T_THEME_PATH}/images/no-avatar.png" alt="" /><!-- ENDIF -->
 							</div>
 							<div class="media-body <!-- IF notification_list.UNREAD --> noti-unread<!-- ELSE --><!-- ENDIF --><!-- IF notification_list.STYLING --> {notification_list.STYLING}<!-- ENDIF -->">
 								<!-- IF notification_list.URL --><a href="<!-- IF notification_list.UNREAD -->{notification_list.U_MARK_READ}<!-- ELSE -->{notification_list.URL}<!-- ENDIF -->"><!-- ENDIF -->
@@ -90,13 +90,21 @@
 								 <!-- IF notification_list.FORUM --><p class="notifications_forum">{notification_list.FORUM}</p><!-- ENDIF -->
 								 <!-- IF notification_list.REASON --><p class="notifications_reason">{notification_list.REASON}</p><!-- ENDIF -->
 								 <p class="notifications_time">{notification_list.TIME}</p>
-							 <div class="mark pull-right"><input type="checkbox" name="mark[]" value="{notification_list.NOTIFICATION_ID}" class="dont-style" title="{L_MARK_READ}" <!-- IF not notification_list.UNREAD --> disabled="disabled"<!-- ENDIF --> />
-                             <input type="checkbox" name="unmark[]" value="{notification_list.NOTIFICATION_ID}" class="dont-style" title="{L_MARK_UNREAD}" <!-- IF  notification_list.UNREAD --> disabled="disabled"<!-- ENDIF --> />
 
-                             <input type="checkbox" name="delete[]" value="{notification_list.NOTIFICATION_ID}" class="dont-style" title="{L_MARK_DELETE}" <!-- IF notification_list.UNREAD --> disabled="disabled"<!-- ENDIF --> />
+								<div class="pull-right">
+									 <div class="mark">
+										<!-- IF notification_list.UNREAD --><a class="btn btn-xs" title="{L_MARK_READ_SINGLE}" onclick="$('input[type=submit]').val('{L_UCP_NOTIES_SUBMIT}')"><!-- ENDIF -->
+											<input type="checkbox" name="mark[]" value="{notification_list.NOTIFICATION_ID}" title="{L_MARK_READ_SINGLE}"<!-- IF not notification_list.UNREAD --> disabled="disabled"<!-- ENDIF --> />
+										<!-- IF notification_list.UNREAD --></a><!-- ENDIF -->
+										<!-- IF not notification_list.UNREAD --><a class="btn btn-xs" title="{L_MARK_UNREAD_SINGLE}"onclick="$('input[type=submit]').val('{L_UCP_NOTIES_SUBMIT}')"><!-- ENDIF -->
+											<input type="checkbox" name="unmark[]" value="{notification_list.NOTIFICATION_ID}" title="{L_MARK_UNREAD_SINGLE}"<!-- IF notification_list.UNREAD --> disabled="disabled"<!-- ENDIF --> />
+										<!-- IF not notification_list.UNREAD --></a><!-- ENDIF -->
+										<!-- IF not notification_list.UNREAD --><a class="btn btn-xs" title="{L_MARK_DELETE_SINGLE}" onclick="$('input[type=submit]').val('{L_UCP_NOTIES_SUBMIT}')"><!-- ENDIF -->
+											<input type="checkbox" name="delete[]" value="{notification_list.NOTIFICATION_ID}" title="{L_MARK_DELETE_SINGLE}"<!-- IF notification_list.UNREAD --> disabled="disabled"<!-- ENDIF --> />
+										<!-- IF not notification_list.UNREAD --></a><!-- ENDIF -->
+									</div>
 								</div>
 							</div>
-                         
 					</div>
 				</div>
 				<!-- END notification_list -->
@@ -104,28 +112,28 @@
 			</div>
 
 		<div class="row">
-			<div class="col-md-6">
+			<div class="col-md-5">
 			<!-- IF .notification_list -->
 			<div class="pull-left">
 				<input type="hidden" name="form_time" value="{FORM_TIME}" />
 				{S_HIDDEN_FIELDS}
-				 <input type="submit" name="submit" value="{L_MARK_READ}" class="btn btn-default" />
+				 <input type="submit" name="submit" value="{L_UCP_NOTIES_SUBMIT}" class="btn btn-default" />
 				<div class="btn-group">
-				 <a class="btn btn-default" onclick="$('input[name=mark\\[\\]]:not(:disabled)').prop('checked', true); return false;" title="{L_MARK_READ}"><i class="fa fa-check-square-o"></i></a>
-				 <a class="btn btn-default" onclick="$('input[name=mark\\[\\]]:not(:disabled)').prop('checked', false); return false;" title="{L_UNMARK_READ}"><i class="fa fa-square-o"></i></a>
+				 <a class="btn btn-default" onclick="marklist('ucp', 'mark', true);marklist('ucp', 'unmark', false);marklist('ucp', 'delete', false);$('input[type=submit]').val('{L_MARK_READ_SELECTED}')" title="{L_MARK_READ}"><i class="fa fa-check-square-o"></i></a>
+				 <a class="btn btn-default" onclick="marklist('ucp', 'mark', false);$('input[type=submit]').val('{L_UNMARK_READ_SELECTED}')" title="{L_UNMARK_READ}"><i class="fa fa-square-o"></i></a>
                  
-                 <a class="btn btn-default" onclick="$('input[name=unmark\\[\\]]:not(:disabled)').prop('checked', true); return false;" title="{L_MARK_UNREAD}"><i class="fa fa-check-square-o"></i></a>
-				 <a class="btn btn-default" onclick="$('input[name=unmark\\[\\]]:not(:disabled)').prop('checked', false); return false;" title="{L_UNMARK_UNREAD}"><i class="fa fa-square-o"></i></a>
+                 <a class="btn btn-default" onclick="marklist('ucp', 'unmark', true);marklist('ucp', 'mark', false);marklist('ucp', 'delete', false);$('input[type=submit]').val('{L_MARK_UNREAD_SELECTED}')" title="{L_MARK_UNREAD}"><i class="fa fa-check-square-o"></i></a>
+				 <a class="btn btn-default" onclick="marklist('ucp', 'unmark', false);$('input[type=submit]').val('{L_UNMARK_UNREAD_SELECTED}')" title="{L_UNMARK_UNREAD}"><i class="fa fa-square-o"></i></a>
                  
-                 <a class="btn btn-default" onclick="$('input[name=delete\\[\\]]:not(:disabled)').prop('checked', true); return false;" title="{L_MARK_DELETE}"><i class="fa fa-check-square-o"></i></a>
-				 <a class="btn btn-default" onclick="$('input[name=delete\\[\\]]:not(:disabled)').prop('checked', false); return false;" title="{L_UNMARK_DELETE}"><i class="fa fa-square-o"></i></a>
+                 <a class="btn btn-default" onclick="marklist('ucp', 'delete', true);marklist('ucp', 'mark', false);marklist('ucp', 'unmark', false);$('input[type=submit]').val('{L_MARK_DELETE_SELECTED}')" title="{L_MARK_DELETE}"><i class="fa fa-check-square-o"></i></a>
+				 <a class="btn btn-default" onclick="marklist('ucp', 'delete', false);$('input[type=submit]').val('{L_UNMARK_DELETE_SELECTED}')" title="{L_UNMARK_DELETE}"><i class="fa fa-square-o"></i></a>
 				</div>
 				{S_FORM_TOKEN}
 			</div>
 		<!-- ENDIF -->
 			</div>
 
-			<div class="col-md-6"> 
+			<div class="col-md-7"> 
 			 <ul class="pagination pagination-sm pull-right">
 				 <li><a>{L_NOTIFICATIONS}&nbsp;{TOTAL_COUNT}</a></li>
 				<!-- IF .pagination -->
diff --git "[ORIGINAL]/forumhulp\\notification_manager/styles/BBOOTS/theme/noties.css" "[FORUM_EXT]/forumhulp\\notification_manager/styles/FLATBOOTS/theme/noties.css"
similarity index 67%
rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\notification_manager/styles/BBOOTS/theme/noties.css"
rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\notification_manager/styles/FLATBOOTS/theme/noties.css"
--- "[ORIGINAL]/forumhulp\\notification_manager/styles/BBOOTS/theme/noties.css"
+++ "[FORUM_EXT]/forumhulp\\notification_manager/styles/FLATBOOTS/theme/noties.css"
@@ -13,4 +13,3 @@ ul.topiclist.two-columns dt {
     line-height: 2.2em;
     font-size: 1.2em;
 }
-.dont-style {opacity:1 !important;position:relative !important; float:left;margin-left:10px !important;outline: 1px solid #ccc;}
\ No newline at end of file
```
