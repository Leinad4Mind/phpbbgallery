Existem diferencas reais no codigo ou texto. Diferencas de formatacao (espacos, tabs) foram ignoradas abaixo.

```diff
diff --git "[ORIGINAL]/sitesplat\\pmnotifications/composer.json" "[FORUM_EXT]/sitesplat\\pmnotifications/composer.json"
--- "[ORIGINAL]/sitesplat\\pmnotifications/composer.json"
+++ "[FORUM_EXT]/sitesplat\\pmnotifications/composer.json"
@@ -24,8 +24,9 @@
 		},
 		"version-check": {
             "host": "sitesplat.com",
-            "directory": "/updatecheck/phpbb31/ext",
-            "filename": "pmnotification.json"
+            "directory": "/updatecheck/phpbb32/ext",
+            "filename": "pmnotification.json",
+			"ssl": true
 		}
 	}
 }
diff --git "[FORUM_EXT]/sitesplat\\pmnotifications/diff_full.tmp" "[FORUM_EXT]/sitesplat\\pmnotifications/diff_full.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\pmnotifications/diff_full.tmp"
@@ -0,0 +1,275 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\pmnotifications/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\pmnotifications/composer.json"
+index 03cd7c9b5..5c19b1412 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\pmnotifications/composer.json"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\pmnotifications/composer.json"
+@@ -24,8 +24,9 @@
+ 		},
+ 		"version-check": {
+             "host": "sitesplat.com",
+-            "directory": "/updatecheck/phpbb31/ext",
+-            "filename": "pmnotification.json"
++            "directory": "/updatecheck/phpbb32/ext",
++            "filename": "pmnotification.json",
++			"ssl": true
+ 		}
+ 	}
+ }
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\pmnotifications/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\pmnotifications/diff_full.tmp"
+new file mode 100644
+index 000000000..e69de29bb
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\pmnotifications/event/listener.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\pmnotifications/event/listener.php"
+index 859f8a3dc..649e044bf 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\pmnotifications/event/listener.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\pmnotifications/event/listener.php"
+@@ -215,8 +215,14 @@ class listener implements EventSubscriberInterface
+ 	public function ucp_pm_view_folder_get_pm_from_template($event)
+ 	{
+ 		$start = $this->request->variable('start', 0);
++		$unread_only = $this->request->variable('unread_only', 0);
+ 		$from_author = $this->request->variable('from_author', 0);
+-		$url_from_author = $sql_from_author = '';
++		$url_from_author = $sql_from_author = $url_unread_only = $sql_unread_only = '';
++		if ($unread_only)
++		{
++			$url_unread_only = '&amp;unread_only=1';
++			$sql_unread_only = ' AND t.pm_unread = 1';
++		}
+ 		if ($from_author)
+ 		{
+ 			$url_from_author = '&amp;from_author=' . $from_author;
+@@ -238,25 +244,27 @@ class listener implements EventSubscriberInterface
+ 				FROM ' . PRIVMSGS_TO_TABLE . ' t, ' . PRIVMSGS_TABLE . ' p
+ 				WHERE t.folder_id = ' . (int) $event['folder_id'] . "
+ 					$sql_from_author
++					$sql_unread_only
+ 					AND t.user_id = {$event['user_id']}
+ 					AND t.msg_id = p.msg_id
+ 					AND p.message_time >= $min_post_time";
+ 			$result = $this->db->sql_query_limit($sql, 1);
+-			$pm_count = (int) $this->db->sql_fetchfield('pm_count', $result);
++			$pm_count = (int) $this->db->sql_fetchfield('pm_count', false, $result);
+ 			$this->db->sql_freeresult($result);
+ 
+ 			$pm_count_changed = true;
+ 		}
+-		else if ($sql_from_author)
++		else if ($sql_from_author || $sql_unread_only)
+ 		{
+ 			$sql = 'SELECT COUNT(t.msg_id) AS pm_count
+ 				FROM ' . PRIVMSGS_TO_TABLE . ' t, ' . PRIVMSGS_TABLE . ' p
+ 				WHERE t.folder_id = ' . (int) $event['folder_id'] . "
+ 					$sql_from_author
++					$sql_unread_only
+ 					AND t.user_id = {$event['user_id']}
+ 					AND t.msg_id = p.msg_id";
+ 			$result = $this->db->sql_query_limit($sql, 1);
+-			$pm_count = (int) $this->db->sql_fetchfield('pm_count', $result);
++			$pm_count = (int) $this->db->sql_fetchfield('pm_count', false, $result);
+ 			$this->db->sql_freeresult($result);
+ 
+ 			$pm_count_changed = true;
+@@ -264,7 +272,7 @@ class listener implements EventSubscriberInterface
+ 
+ 		if ($pm_count_changed)
+ 		{
+-			$base_url = $event['base_url'] . $url_from_author;
++			$base_url = $event['base_url'] . $url_from_author . $url_unread_only;
+ 			$start = $this->pagination->validate_start($start, $this->config['topics_per_page'], $pm_count);
+ 			$this->pagination->generate_template_pagination($base_url, 'pagination', 'start', $pm_count, $this->config['topics_per_page'], $start);
+ 
+@@ -277,13 +285,18 @@ class listener implements EventSubscriberInterface
+ 	public function ucp_pm_view_folder_get_pm_from_sql($event)
+ 	{
+ 		$from_author = $this->request->variable('from_author', 0);
++		$unread_only = $this->request->variable('unread_only', 0);
+ 
++		$sql_ary = $event['sql_ary'];
+ 		if ($from_author)
+ 		{
+-			$sql_ary = $event['sql_ary'];
+ 			$sql_ary['WHERE'] .= ' AND p.author_id = ' . $from_author;
+-			$event['sql_ary'] = $sql_ary;
+ 		}
++		if ($unread_only)
++		{
++			$sql_ary['WHERE'] .= ' AND t.pm_unread = 1';
++		}
++		$event['sql_ary'] = $sql_ary;
+ 	}
+ 
+ 	public function ucp_pm_view_messsage($event)
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\pmnotifications/language/en/common.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\pmnotifications/language/en/common.php"
+index ed661e425..383344e94 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\pmnotifications/language/en/common.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\pmnotifications/language/en/common.php"
+@@ -24,4 +24,5 @@ $lang = array_merge($lang, array(
+ 		1	=> '1 unread PM',
+ 		2	=> '%d unread PMs',
+ 	),
++	'NO_PRIVATE_MESSAGES' => 'No Private Messages'
+ ));
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\pmnotifications/language/pt/common.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\pmnotifications/language/pt/common.php"
+new file mode 100644
+index 000000000..31806466a
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\pmnotifications/language/pt/common.php"
+@@ -0,0 +1,28 @@
++<?php
++/**
++*
++* @package PMnotifications
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
++	'FROM_AUTHOR_PM_LIST'		=> 'MP\'s trocadas com este utilizador',
++	'PM_UNREAD_COUNT'	=> array(
++		0	=> 'Sem MPs por ler. Perfeito!',
++		1	=> '1 MP por ler',
++		2	=> '%d MPs por ler',
++	),
++	'NO_PRIVATE_MESSAGES' => 'Sem Mensagens Privadas'
++));
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\pmnotifications/language/pt/info_acp_pmnotifications.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\pmnotifications/language/pt/info_acp_pmnotifications.php"
+new file mode 100644
+index 000000000..ea17ff4d7
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\pmnotifications/language/pt/info_acp_pmnotifications.php"
+@@ -0,0 +1,25 @@
++<?php
++/**
++*
++* @package PMnotifications
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
++	'ACP_PMNOTIFICATIONS'			=> 'Notificações de MP',
++	'SS_HELPER_NOTY'	            => 'SiteSplat BBcore does not exist!<br />Download the <a href="http://sitesplat.com" target="_blank">BBcore</a> and copy the BBcore folder into your sitesplat extension folder.',
++	'PMNOTIFICATIONS_NOTICE'	    => '<div class="phpinfo"><p>There are no specific settings for this extension. The PM\'s will be automatically separated from the internal phpBB notification system. <br />The filter button is under PM message view.</p></div>',
++));
++
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\pmnotifications/language/pt_preao/common.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\pmnotifications/language/pt_preao/common.php"
+new file mode 100644
+index 000000000..31806466a
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\pmnotifications/language/pt_preao/common.php"
+@@ -0,0 +1,28 @@
++<?php
++/**
++*
++* @package PMnotifications
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
++	'FROM_AUTHOR_PM_LIST'		=> 'MP\'s trocadas com este utilizador',
++	'PM_UNREAD_COUNT'	=> array(
++		0	=> 'Sem MPs por ler. Perfeito!',
++		1	=> '1 MP por ler',
++		2	=> '%d MPs por ler',
++	),
++	'NO_PRIVATE_MESSAGES' => 'Sem Mensagens Privadas'
++));
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\pmnotifications/language/pt_preao/info_acp_pmnotifications.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\pmnotifications/language/pt_preao/info_acp_pmnotifications.php"
+new file mode 100644
+index 000000000..ea17ff4d7
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\pmnotifications/language/pt_preao/info_acp_pmnotifications.php"
+@@ -0,0 +1,25 @@
++<?php
++/**
++*
++* @package PMnotifications
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
++	'ACP_PMNOTIFICATIONS'			=> 'Notificações de MP',
++	'SS_HELPER_NOTY'	            => 'SiteSplat BBcore does not exist!<br />Download the <a href="http://sitesplat.com" target="_blank">BBcore</a> and copy the BBcore folder into your sitesplat extension folder.',
++	'PMNOTIFICATIONS_NOTICE'	    => '<div class="phpinfo"><p>There are no specific settings for this extension. The PM\'s will be automatically separated from the internal phpBB notification system. <br />The filter button is under PM message view.</p></div>',
++));
++
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\pmnotifications/styles/FLATBOOTS/template/event/overall_footer_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\pmnotifications/styles/FLATBOOTS/template/event/overall_footer_after.html"
+index 6ca9485bc..a3a73670f 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\pmnotifications/styles/FLATBOOTS/template/event/overall_footer_after.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\pmnotifications/styles/FLATBOOTS/template/event/overall_footer_after.html"
+@@ -9,6 +9,17 @@ head.ready(function(){
+ 
+ 		e.preventDefault();
+ 	});
++	// Mobile Leinad Code Start
++	// prevent mark all notifications read - this would mark PMs too
++	$('#mark_all_notifications_mobile a').attr('href', '#').removeAttr('data-ajax');
++	// mark all notifications read, custom implementation
++	$(document).on('click', '#mark_all_notifications_mobile a', function(e){
++		$('#notification_list_mobile .icon-mark').click();
++		$('#mark_all_notifications_mobile').remove();
++
++		e.preventDefault();
++	});
++	// Mobile Leinad Code End
+ 
+ 	// This callback will mark a pm notification read
+ 	phpbb.addAjaxCallback('pm.mark_read', function(res) {
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\pmnotifications/styles/FLATBOOTS/template/pms_dropdown.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\pmnotifications/styles/FLATBOOTS/template/pms_dropdown.html"
+index 43124a2cd..3c86da6fa 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\pmnotifications/styles/FLATBOOTS/template/pms_dropdown.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\pmnotifications/styles/FLATBOOTS/template/pms_dropdown.html"
+@@ -8,7 +8,7 @@
+                     <ul class="list-unstyled">
+ 					<!-- IF not .pms -->
+ 						<li class="no_pms no_notifications">
+-						 <div class="noti-bubble alert alert-default">{L_NO} {L_PRIVATE_MESSAGES}</div><i class="fa fa-check"></i>
++						 <div class="noti-bubble alert alert-default">{L_NO_PRIVATE_MESSAGES}</div><i class="fa fa-check"></i>
+ 						</li>
+ 					<!-- ENDIF -->
+ 					<!-- BEGIN pms -->
diff --git "[FORUM_EXT]/sitesplat\\pmnotifications/diff_nospace.tmp" "[FORUM_EXT]/sitesplat\\pmnotifications/diff_nospace.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\pmnotifications/diff_nospace.tmp"
@@ -0,0 +1,271 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\pmnotifications/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\pmnotifications/composer.json"
+index 03cd7c9b5..5c19b1412 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\pmnotifications/composer.json"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\pmnotifications/composer.json"
+@@ -24,8 +24,9 @@
+ 		},
+ 		"version-check": {
+             "host": "sitesplat.com",
+-            "directory": "/updatecheck/phpbb31/ext",
+-            "filename": "pmnotification.json"
++            "directory": "/updatecheck/phpbb32/ext",
++            "filename": "pmnotification.json",
++			"ssl": true
+ 		}
+ 	}
+ }
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\pmnotifications/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\pmnotifications/diff_full.tmp"
+new file mode 100644
+index 000000000..633e262a5
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\pmnotifications/diff_full.tmp"
+@@ -0,0 +1,275 @@
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\pmnotifications/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\pmnotifications/composer.json"
++index 03cd7c9b5..5c19b1412 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\pmnotifications/composer.json"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\pmnotifications/composer.json"
++@@ -24,8 +24,9 @@
++ 		},
++ 		"version-check": {
++             "host": "sitesplat.com",
++-            "directory": "/updatecheck/phpbb31/ext",
++-            "filename": "pmnotification.json"
+++            "directory": "/updatecheck/phpbb32/ext",
+++            "filename": "pmnotification.json",
+++			"ssl": true
++ 		}
++ 	}
++ }
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\pmnotifications/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\pmnotifications/diff_full.tmp"
++new file mode 100644
++index 000000000..e69de29bb
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\pmnotifications/event/listener.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\pmnotifications/event/listener.php"
++index 859f8a3dc..649e044bf 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\pmnotifications/event/listener.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\pmnotifications/event/listener.php"
++@@ -215,8 +215,14 @@ class listener implements EventSubscriberInterface
++ 	public function ucp_pm_view_folder_get_pm_from_template($event)
++ 	{
++ 		$start = $this->request->variable('start', 0);
+++		$unread_only = $this->request->variable('unread_only', 0);
++ 		$from_author = $this->request->variable('from_author', 0);
++-		$url_from_author = $sql_from_author = '';
+++		$url_from_author = $sql_from_author = $url_unread_only = $sql_unread_only = '';
+++		if ($unread_only)
+++		{
+++			$url_unread_only = '&amp;unread_only=1';
+++			$sql_unread_only = ' AND t.pm_unread = 1';
+++		}
++ 		if ($from_author)
++ 		{
++ 			$url_from_author = '&amp;from_author=' . $from_author;
++@@ -238,25 +244,27 @@ class listener implements EventSubscriberInterface
++ 				FROM ' . PRIVMSGS_TO_TABLE . ' t, ' . PRIVMSGS_TABLE . ' p
++ 				WHERE t.folder_id = ' . (int) $event['folder_id'] . "
++ 					$sql_from_author
+++					$sql_unread_only
++ 					AND t.user_id = {$event['user_id']}
++ 					AND t.msg_id = p.msg_id
++ 					AND p.message_time >= $min_post_time";
++ 			$result = $this->db->sql_query_limit($sql, 1);
++-			$pm_count = (int) $this->db->sql_fetchfield('pm_count', $result);
+++			$pm_count = (int) $this->db->sql_fetchfield('pm_count', false, $result);
++ 			$this->db->sql_freeresult($result);
++ 
++ 			$pm_count_changed = true;
++ 		}
++-		else if ($sql_from_author)
+++		else if ($sql_from_author || $sql_unread_only)
++ 		{
++ 			$sql = 'SELECT COUNT(t.msg_id) AS pm_count
++ 				FROM ' . PRIVMSGS_TO_TABLE . ' t, ' . PRIVMSGS_TABLE . ' p
++ 				WHERE t.folder_id = ' . (int) $event['folder_id'] . "
++ 					$sql_from_author
+++					$sql_unread_only
++ 					AND t.user_id = {$event['user_id']}
++ 					AND t.msg_id = p.msg_id";
++ 			$result = $this->db->sql_query_limit($sql, 1);
++-			$pm_count = (int) $this->db->sql_fetchfield('pm_count', $result);
+++			$pm_count = (int) $this->db->sql_fetchfield('pm_count', false, $result);
++ 			$this->db->sql_freeresult($result);
++ 
++ 			$pm_count_changed = true;
++@@ -264,7 +272,7 @@ class listener implements EventSubscriberInterface
++ 
++ 		if ($pm_count_changed)
++ 		{
++-			$base_url = $event['base_url'] . $url_from_author;
+++			$base_url = $event['base_url'] . $url_from_author . $url_unread_only;
++ 			$start = $this->pagination->validate_start($start, $this->config['topics_per_page'], $pm_count);
++ 			$this->pagination->generate_template_pagination($base_url, 'pagination', 'start', $pm_count, $this->config['topics_per_page'], $start);
++ 
++@@ -277,13 +285,18 @@ class listener implements EventSubscriberInterface
++ 	public function ucp_pm_view_folder_get_pm_from_sql($event)
++ 	{
++ 		$from_author = $this->request->variable('from_author', 0);
+++		$unread_only = $this->request->variable('unread_only', 0);
++ 
+++		$sql_ary = $event['sql_ary'];
++ 		if ($from_author)
++ 		{
++-			$sql_ary = $event['sql_ary'];
++ 			$sql_ary['WHERE'] .= ' AND p.author_id = ' . $from_author;
++-			$event['sql_ary'] = $sql_ary;
++ 		}
+++		if ($unread_only)
+++		{
+++			$sql_ary['WHERE'] .= ' AND t.pm_unread = 1';
+++		}
+++		$event['sql_ary'] = $sql_ary;
++ 	}
++ 
++ 	public function ucp_pm_view_messsage($event)
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\pmnotifications/language/en/common.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\pmnotifications/language/en/common.php"
++index ed661e425..383344e94 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\pmnotifications/language/en/common.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\pmnotifications/language/en/common.php"
++@@ -24,4 +24,5 @@ $lang = array_merge($lang, array(
++ 		1	=> '1 unread PM',
++ 		2	=> '%d unread PMs',
++ 	),
+++	'NO_PRIVATE_MESSAGES' => 'No Private Messages'
++ ));
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\pmnotifications/language/pt/common.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\pmnotifications/language/pt/common.php"
++new file mode 100644
++index 000000000..31806466a
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\pmnotifications/language/pt/common.php"
++@@ -0,0 +1,28 @@
+++<?php
+++/**
+++*
+++* @package PMnotifications
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
+++	'FROM_AUTHOR_PM_LIST'		=> 'MP\'s trocadas com este utilizador',
+++	'PM_UNREAD_COUNT'	=> array(
+++		0	=> 'Sem MPs por ler. Perfeito!',
+++		1	=> '1 MP por ler',
+++		2	=> '%d MPs por ler',
+++	),
+++	'NO_PRIVATE_MESSAGES' => 'Sem Mensagens Privadas'
+++));
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\pmnotifications/language/pt/info_acp_pmnotifications.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\pmnotifications/language/pt/info_acp_pmnotifications.php"
++new file mode 100644
++index 000000000..ea17ff4d7
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\pmnotifications/language/pt/info_acp_pmnotifications.php"
++@@ -0,0 +1,25 @@
+++<?php
+++/**
+++*
+++* @package PMnotifications
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
+++	'ACP_PMNOTIFICATIONS'			=> 'Notificações de MP',
+++	'SS_HELPER_NOTY'	            => 'SiteSplat BBcore does not exist!<br />Download the <a href="http://sitesplat.com" target="_blank">BBcore</a> and copy the BBcore folder into your sitesplat extension folder.',
+++	'PMNOTIFICATIONS_NOTICE'	    => '<div class="phpinfo"><p>There are no specific settings for this extension. The PM\'s will be automatically separated from the internal phpBB notification system. <br />The filter button is under PM message view.</p></div>',
+++));
+++
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\pmnotifications/language/pt_preao/common.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\pmnotifications/language/pt_preao/common.php"
++new file mode 100644
++index 000000000..31806466a
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\pmnotifications/language/pt_preao/common.php"
++@@ -0,0 +1,28 @@
+++<?php
+++/**
+++*
+++* @package PMnotifications
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
+++	'FROM_AUTHOR_PM_LIST'		=> 'MP\'s trocadas com este utilizador',
+++	'PM_UNREAD_COUNT'	=> array(
+++		0	=> 'Sem MPs por ler. Perfeito!',
+++		1	=> '1 MP por ler',
+++		2	=> '%d MPs por ler',
+++	),
+++	'NO_PRIVATE_MESSAGES' => 'Sem Mensagens Privadas'
+++));
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\pmnotifications/language/pt_preao/info_acp_pmnotifications.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\pmnotifications/language/pt_preao/info_acp_pmnotifications.php"
++new file mode 100644
++index 000000000..ea17ff4d7
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\pmnotifications/language/pt_preao/info_acp_pmnotifications.php"
++@@ -0,0 +1,25 @@
+++<?php
+++/**
+++*
+++* @package PMnotifications
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
+++	'ACP_PMNOTIFICATIONS'			=> 'Notificações de MP',
+++	'SS_HELPER_NOTY'	            => 'SiteSplat BBcore does not exist!<br />Download the <a href="http://sitesplat.com" target="_blank">BBcore</a> and copy the BBcore folder into your sitesplat extension folder.',
+++	'PMNOTIFICATIONS_NOTICE'	    => '<div class="phpinfo"><p>There are no specific settings for this extension. The PM\'s will be automatically separated from the internal phpBB notification system. <br />The filter button is under PM message view.</p></div>',
+++));
+++
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\pmnotifications/styles/FLATBOOTS/template/event/overall_footer_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\pmnotifications/styles/FLATBOOTS/template/event/overall_footer_after.html"
++index 6ca9485bc..a3a73670f 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\pmnotifications/styles/FLATBOOTS/template/event/overall_footer_after.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\pmnotifications/styles/FLATBOOTS/template/event/overall_footer_after.html"
++@@ -9,6 +9,17 @@ head.ready(function(){
++ 
++ 		e.preventDefault();
++ 	});
+++	// Mobile Leinad Code S
\ No newline at end of file
diff --git "[ORIGINAL]/sitesplat\\pmnotifications/event/listener.php" "[FORUM_EXT]/sitesplat\\pmnotifications/event/listener.php"
--- "[ORIGINAL]/sitesplat\\pmnotifications/event/listener.php"
+++ "[FORUM_EXT]/sitesplat\\pmnotifications/event/listener.php"
@@ -215,8 +215,14 @@ class listener implements EventSubscriberInterface
 	public function ucp_pm_view_folder_get_pm_from_template($event)
 	{
 		$start = $this->request->variable('start', 0);
+		$unread_only = $this->request->variable('unread_only', 0);
 		$from_author = $this->request->variable('from_author', 0);
-		$url_from_author = $sql_from_author = '';
+		$url_from_author = $sql_from_author = $url_unread_only = $sql_unread_only = '';
+		if ($unread_only)
+		{
+			$url_unread_only = '&amp;unread_only=1';
+			$sql_unread_only = ' AND t.pm_unread = 1';
+		}
 		if ($from_author)
 		{
 			$url_from_author = '&amp;from_author=' . $from_author;
@@ -238,25 +244,27 @@ class listener implements EventSubscriberInterface
 				FROM ' . PRIVMSGS_TO_TABLE . ' t, ' . PRIVMSGS_TABLE . ' p
 				WHERE t.folder_id = ' . (int) $event['folder_id'] . "
 					$sql_from_author
+					$sql_unread_only
 					AND t.user_id = {$event['user_id']}
 					AND t.msg_id = p.msg_id
 					AND p.message_time >= $min_post_time";
 			$result = $this->db->sql_query_limit($sql, 1);
-			$pm_count = (int) $this->db->sql_fetchfield('pm_count', $result);
+			$pm_count = (int) $this->db->sql_fetchfield('pm_count', false, $result);
 			$this->db->sql_freeresult($result);
 
 			$pm_count_changed = true;
 		}
-		else if ($sql_from_author)
+		else if ($sql_from_author || $sql_unread_only)
 		{
 			$sql = 'SELECT COUNT(t.msg_id) AS pm_count
 				FROM ' . PRIVMSGS_TO_TABLE . ' t, ' . PRIVMSGS_TABLE . ' p
 				WHERE t.folder_id = ' . (int) $event['folder_id'] . "
 					$sql_from_author
+					$sql_unread_only
 					AND t.user_id = {$event['user_id']}
 					AND t.msg_id = p.msg_id";
 			$result = $this->db->sql_query_limit($sql, 1);
-			$pm_count = (int) $this->db->sql_fetchfield('pm_count', $result);
+			$pm_count = (int) $this->db->sql_fetchfield('pm_count', false, $result);
 			$this->db->sql_freeresult($result);
 
 			$pm_count_changed = true;
@@ -264,7 +272,7 @@ class listener implements EventSubscriberInterface
 
 		if ($pm_count_changed)
 		{
-			$base_url = $event['base_url'] . $url_from_author;
+			$base_url = $event['base_url'] . $url_from_author . $url_unread_only;
 			$start = $this->pagination->validate_start($start, $this->config['topics_per_page'], $pm_count);
 			$this->pagination->generate_template_pagination($base_url, 'pagination', 'start', $pm_count, $this->config['topics_per_page'], $start);
 
@@ -277,13 +285,18 @@ class listener implements EventSubscriberInterface
 	public function ucp_pm_view_folder_get_pm_from_sql($event)
 	{
 		$from_author = $this->request->variable('from_author', 0);
+		$unread_only = $this->request->variable('unread_only', 0);
 
+		$sql_ary = $event['sql_ary'];
 		if ($from_author)
 		{
-			$sql_ary = $event['sql_ary'];
 			$sql_ary['WHERE'] .= ' AND p.author_id = ' . $from_author;
-			$event['sql_ary'] = $sql_ary;
 		}
+		if ($unread_only)
+		{
+			$sql_ary['WHERE'] .= ' AND t.pm_unread = 1';
+		}
+		$event['sql_ary'] = $sql_ary;
 	}
 
 	public function ucp_pm_view_messsage($event)
diff --git "[ORIGINAL]/sitesplat\\pmnotifications/language/en/common.php" "[FORUM_EXT]/sitesplat\\pmnotifications/language/en/common.php"
--- "[ORIGINAL]/sitesplat\\pmnotifications/language/en/common.php"
+++ "[FORUM_EXT]/sitesplat\\pmnotifications/language/en/common.php"
@@ -24,4 +24,5 @@ $lang = array_merge($lang, array(
 		1	=> '1 unread PM',
 		2	=> '%d unread PMs',
 	),
+	'NO_PRIVATE_MESSAGES' => 'No Private Messages'
 ));
diff --git "[FORUM_EXT]/sitesplat\\pmnotifications/language/pt/common.php" "[FORUM_EXT]/sitesplat\\pmnotifications/language/pt/common.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\pmnotifications/language/pt/common.php"
@@ -0,0 +1,28 @@
+<?php
+/**
+*
+* @package PMnotifications
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
+	'FROM_AUTHOR_PM_LIST'		=> 'MP\'s trocadas com este utilizador',
+	'PM_UNREAD_COUNT'	=> array(
+		0	=> 'Sem MPs por ler. Perfeito!',
+		1	=> '1 MP por ler',
+		2	=> '%d MPs por ler',
+	),
+	'NO_PRIVATE_MESSAGES' => 'Sem Mensagens Privadas'
+));
diff --git "[FORUM_EXT]/sitesplat\\pmnotifications/language/pt/info_acp_pmnotifications.php" "[FORUM_EXT]/sitesplat\\pmnotifications/language/pt/info_acp_pmnotifications.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\pmnotifications/language/pt/info_acp_pmnotifications.php"
@@ -0,0 +1,25 @@
+<?php
+/**
+*
+* @package PMnotifications
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
+	'ACP_PMNOTIFICATIONS'			=> 'Notificações de MP',
+	'SS_HELPER_NOTY'	            => 'SiteSplat BBcore does not exist!<br />Download the <a href="http://sitesplat.com" target="_blank">BBcore</a> and copy the BBcore folder into your sitesplat extension folder.',
+	'PMNOTIFICATIONS_NOTICE'	    => '<div class="phpinfo"><p>There are no specific settings for this extension. The PM\'s will be automatically separated from the internal phpBB notification system. <br />The filter button is under PM message view.</p></div>',
+));
+
diff --git "[FORUM_EXT]/sitesplat\\pmnotifications/language/pt_preao/common.php" "[FORUM_EXT]/sitesplat\\pmnotifications/language/pt_preao/common.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\pmnotifications/language/pt_preao/common.php"
@@ -0,0 +1,28 @@
+<?php
+/**
+*
+* @package PMnotifications
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
+	'FROM_AUTHOR_PM_LIST'		=> 'MP\'s trocadas com este utilizador',
+	'PM_UNREAD_COUNT'	=> array(
+		0	=> 'Sem MPs por ler. Perfeito!',
+		1	=> '1 MP por ler',
+		2	=> '%d MPs por ler',
+	),
+	'NO_PRIVATE_MESSAGES' => 'Sem Mensagens Privadas'
+));
diff --git "[FORUM_EXT]/sitesplat\\pmnotifications/language/pt_preao/info_acp_pmnotifications.php" "[FORUM_EXT]/sitesplat\\pmnotifications/language/pt_preao/info_acp_pmnotifications.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\pmnotifications/language/pt_preao/info_acp_pmnotifications.php"
@@ -0,0 +1,25 @@
+<?php
+/**
+*
+* @package PMnotifications
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
+	'ACP_PMNOTIFICATIONS'			=> 'Notificações de MP',
+	'SS_HELPER_NOTY'	            => 'SiteSplat BBcore does not exist!<br />Download the <a href="http://sitesplat.com" target="_blank">BBcore</a> and copy the BBcore folder into your sitesplat extension folder.',
+	'PMNOTIFICATIONS_NOTICE'	    => '<div class="phpinfo"><p>There are no specific settings for this extension. The PM\'s will be automatically separated from the internal phpBB notification system. <br />The filter button is under PM message view.</p></div>',
+));
+
diff --git "[ORIGINAL]/sitesplat\\pmnotifications/styles/FLATBOOTS/template/event/overall_footer_after.html" "[FORUM_EXT]/sitesplat\\pmnotifications/styles/FLATBOOTS/template/event/overall_footer_after.html"
--- "[ORIGINAL]/sitesplat\\pmnotifications/styles/FLATBOOTS/template/event/overall_footer_after.html"
+++ "[FORUM_EXT]/sitesplat\\pmnotifications/styles/FLATBOOTS/template/event/overall_footer_after.html"
@@ -9,6 +9,17 @@ head.ready(function(){
 
 		e.preventDefault();
 	});
+	// Mobile Leinad Code Start
+	// prevent mark all notifications read - this would mark PMs too
+	$('#mark_all_notifications_mobile a').attr('href', '#').removeAttr('data-ajax');
+	// mark all notifications read, custom implementation
+	$(document).on('click', '#mark_all_notifications_mobile a', function(e){
+		$('#notification_list_mobile .icon-mark').click();
+		$('#mark_all_notifications_mobile').remove();
+
+		e.preventDefault();
+	});
+	// Mobile Leinad Code End
 
 	// This callback will mark a pm notification read
 	phpbb.addAjaxCallback('pm.mark_read', function(res) {
diff --git "[ORIGINAL]/sitesplat\\pmnotifications/styles/FLATBOOTS/template/pms_dropdown.html" "[FORUM_EXT]/sitesplat\\pmnotifications/styles/FLATBOOTS/template/pms_dropdown.html"
--- "[ORIGINAL]/sitesplat\\pmnotifications/styles/FLATBOOTS/template/pms_dropdown.html"
+++ "[FORUM_EXT]/sitesplat\\pmnotifications/styles/FLATBOOTS/template/pms_dropdown.html"
@@ -8,7 +8,7 @@
                     <ul class="list-unstyled">
 					<!-- IF not .pms -->
 						<li class="no_pms no_notifications">
-						 <div class="noti-bubble alert alert-default">{L_NO} {L_PRIVATE_MESSAGES}</div><i class="fa fa-check"></i>
+						 <div class="noti-bubble alert alert-default">{L_NO_PRIVATE_MESSAGES}</div><i class="fa fa-check"></i>
 						</li>
 					<!-- ENDIF -->
 					<!-- BEGIN pms -->
```
