Existem diferencas reais no codigo ou texto. Diferencas de formatacao (espacos, tabs) foram ignoradas abaixo.

```diff
diff --git "[FORUM_EXT]/leinad4mind\\specialtopicmove/diff_full.tmp" "[FORUM_EXT]/leinad4mind\\specialtopicmove/diff_full.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/leinad4mind\\specialtopicmove/diff_full.tmp"
@@ -0,0 +1,502 @@
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialtopicmove/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialtopicmove/diff_full.tmp"
+new file mode 100644
+index 000000000..e69de29bb
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialtopicmove/event/main_listener.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialtopicmove/event/main_listener.php"
+index 68b49aa10..d7551f16a 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialtopicmove/event/main_listener.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialtopicmove/event/main_listener.php"
+@@ -206,8 +206,8 @@ class main_listener implements EventSubscriberInterface
+ 					$acl[$topic_data[$topic_id]['topic_poster']] = $auth;
+ 				}
+ 
+-				if ($acl[$topic_data[$topic_id]['topic_poster']]->acl_get('f_list', $event['forum_id']))
+-				{
++				// if ($acl[$topic_data[$topic_id]['topic_poster']]->acl_get('f_list', $event['forum_id']))
++				// {
+ 					$this->notification_manager->add_notifications('leinad4mind.specialtopicmove.notification.type.topic_moved', [
+ 						'topic_id'		=> $topic_id,
+ 						'forum_id'		=> $event['forum_id'],
+@@ -215,7 +215,7 @@ class main_listener implements EventSubscriberInterface
+ 						'topic_mover'	=> $this->user->data['user_id'],
+ 						'reason'		=> $reason,
+ 					]);
+-				}
++				// }
+ 			}
+ 		}
+ 	}
+@@ -357,8 +357,13 @@ class main_listener implements EventSubscriberInterface
+ 			$row = $this->db->sql_fetchrow($result);
+ 			$this->db->sql_freeresult($result);
+ 
++			$forum_name = '';
++			if (!empty($row) && is_array($row) && isset($row['forum_name'])) {
++				$forum_name = $row['forum_name'];
++			}
++
+ 			$this->forums[$forum_id] = [
+-				'forum_name'	=> $row['forum_name'],
++				'forum_name'	=> $forum_name,
+ 			];
+ 		}
+ 
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialtopicmove/language/en/acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialtopicmove/language/en/acp.php"
+index 43e1e5bb2..a41e8c49a 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialtopicmove/language/en/acp.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialtopicmove/language/en/acp.php"
+@@ -2,9 +2,9 @@
+ 
+ /**
+  *
+- * Special Topic Move. An extension for the phpBB Forum Software package.
++ * Prime Topic Move. An extension for the phpBB Forum Software package.
+  *
+- * @copyright (c) 2019, Leinad4Mind, https://leinad4mind.top/forum
++ * @copyright (c) 2019, kasimi, https://kasimi.net
+  * @license GNU General Public License, version 2 (GPL-2.0)
+  *
+  */
+@@ -38,9 +38,9 @@ if (empty($lang) || !is_array($lang))
+ $lang = array_merge($lang, [
+ 	'SPECIAL_TOPIC_MOVED_DISPLAY'			=> 'Display details about moved topics',
+ 	'SPECIAL_TOPIC_MOVED_DISPLAY_EXPLAIN'	=> 'Determines where the details of a moved topic will be displayed.',
+-	'SPECIAL_TOPIC_MOVED_DISPLAY_NEVER'		=> 'Don’t show details about the move',
+-	'SPECIAL_TOPIC_MOVED_DISPLAY_FIRST'		=> 'Show on first post of the thread',
+-	'SPECIAL_TOPIC_MOVED_DISPLAY_LAST'		=> 'Show on last post of the thread',
+-	'SPECIAL_TOPIC_MOVED_DISPLAY_MOVED'		=> 'Show on last post at time of move',
++	'SPECIAL_TOPIC_MOVED_DISPLAY_NEVER'	=> 'Don’t show details about the move',
++	'SPECIAL_TOPIC_MOVED_DISPLAY_FIRST'	=> 'Show on first post of the thread',
++	'SPECIAL_TOPIC_MOVED_DISPLAY_LAST'	=> 'Show on last post of the thread',
++	'SPECIAL_TOPIC_MOVED_DISPLAY_MOVED'	=> 'Show on last post at time of move',
+ 	'SPECIAL_TOPIC_MOVED_DISPLAY_SHADOW'	=> 'Show with shadow link in forum list',
+ ]);
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialtopicmove/language/en/common.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialtopicmove/language/en/common.php"
+index 11a532360..1407d2771 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialtopicmove/language/en/common.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialtopicmove/language/en/common.php"
+@@ -2,9 +2,9 @@
+ 
+ /**
+  *
+- * Special Topic Move. An extension for the phpBB Forum Software package.
++ * Prime Topic Move. An extension for the phpBB Forum Software package.
+  *
+- * @copyright (c) 2019, Leinad4Mind, https://leinad4mind.top/forum
++ * @copyright (c) 2019, kasimi, https://kasimi.net
+  * @license GNU General Public License, version 2 (GPL-2.0)
+  *
+  */
+@@ -41,13 +41,14 @@ $lang = array_merge($lang, [
+ 		2 => 'Please enter a reason for moving these topics',
+ 	],
+ 	'SPECIAL_TOPIC_MOVED_MESSAGE'				=> 'This topic was moved',
+-	'SPECIAL_TOPIC_MOVED_FROM'					=> 'from <strong>%s</strong>',
++	'SPECIAL_TOPIC_MOVED_FROM'				=> 'from <strong>%s</strong>',
+ 	'SPECIAL_TOPIC_MOVED_TO'					=> 'to <strong>%s</strong>',
+ 	'SPECIAL_TOPIC_MOVED_BY'					=> 'by %s',
+ 	'SPECIAL_TOPIC_MOVED_ON'					=> 'on %s.',
+ 	'SPECIAL_TOPIC_MOVED_NO_USER'				=> 'a nonexistent user',
+-	'SPECIAL_TOPIC_MOVED_UNDO'					=> 'Move this topic back.',
++	'SPECIAL_TOPIC_MOVED_UNDO'				=> 'Move this topic back.',
+ 
+-	'SPECIAL_TOPIC_MOVED_NOTIFICATION'			=> 'Someone moves your topic.',
++	'SPECIAL_TOPIC_MOVED_NOTIFICATION'		=> 'Someone moves your topic.',
+ 	'SPECIAL_TOPIC_MOVED_NOTIFICATION_TITLE'	=> 'Your topic “%1$s” was <strong>moved</strong> by %2$s to “%3$s”.',
++
+ ]);
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialtopicmove/language/en/email/topic_moved.txt" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialtopicmove/language/en/email/topic_moved.txt"
+new file mode 100644
+index 000000000..7c795ae8f
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialtopicmove/language/en/email/topic_moved.txt"
+@@ -0,0 +1,17 @@
++Subject: Topic moved - "{{ TOPIC_TITLE }}"
++
++Hello {{ USERNAME }},
++
++
++You are receiving this notification because your topic "{{ TOPIC_TITLE }}" was moved by "{{ TOPIC_MOVER }}" to "{{ FORUM_NAME }}".
++{% if REASON %}
++Reason:
++
++{{ REASON }}
++{% endif %}
++
++If you no longer wish to receive emails when your topics are moved, please update your notification settings here:
++
++{{ U_NOTIFICATION_SETTINGS }}
++
++{{ EMAIL_SIG }}
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialtopicmove/language/pt/acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialtopicmove/language/pt/acp.php"
+new file mode 100644
+index 000000000..43e1e5bb2
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialtopicmove/language/pt/acp.php"
+@@ -0,0 +1,46 @@
++<?php
++
++/**
++ *
++ * Special Topic Move. An extension for the phpBB Forum Software package.
++ *
++ * @copyright (c) 2019, Leinad4Mind, https://leinad4mind.top/forum
++ * @license GNU General Public License, version 2 (GPL-2.0)
++ *
++ */
++
++if (!defined('IN_PHPBB'))
++{
++	exit;
++}
++
++if (empty($lang) || !is_array($lang))
++{
++	$lang = [];
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
++$lang = array_merge($lang, [
++	'SPECIAL_TOPIC_MOVED_DISPLAY'			=> 'Display details about moved topics',
++	'SPECIAL_TOPIC_MOVED_DISPLAY_EXPLAIN'	=> 'Determines where the details of a moved topic will be displayed.',
++	'SPECIAL_TOPIC_MOVED_DISPLAY_NEVER'		=> 'Don’t show details about the move',
++	'SPECIAL_TOPIC_MOVED_DISPLAY_FIRST'		=> 'Show on first post of the thread',
++	'SPECIAL_TOPIC_MOVED_DISPLAY_LAST'		=> 'Show on last post of the thread',
++	'SPECIAL_TOPIC_MOVED_DISPLAY_MOVED'		=> 'Show on last post at time of move',
++	'SPECIAL_TOPIC_MOVED_DISPLAY_SHADOW'	=> 'Show with shadow link in forum list',
++]);
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialtopicmove/language/pt/common.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialtopicmove/language/pt/common.php"
+new file mode 100644
+index 000000000..9612a52c8
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialtopicmove/language/pt/common.php"
+@@ -0,0 +1,53 @@
++<?php
++
++/**
++ *
++ * Special Topic Move. An extension for the phpBB Forum Software package.
++ *
++ * @copyright (c) 2019, Leinad4Mind, https://leinad4mind.top/forum
++ * @license GNU General Public License, version 2 (GPL-2.0)
++ *
++ */
++
++if (!defined('IN_PHPBB'))
++{
++	exit;
++}
++
++if (empty($lang) || !is_array($lang))
++{
++	$lang = [];
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
++$lang = array_merge($lang, [
++	'SPECIAL_TOPIC_MOVE_ENTER_REASON'			=> [
++		1 => 'Por favor, escreve um motivo para mover este tópico',
++		2 => 'Por favor, escreve um motivo para mover estes tópicos',
++	],
++	'SPECIAL_TOPIC_MOVED_MESSAGE'				=> 'Este tópico foi movido',
++	'SPECIAL_TOPIC_MOVED_FROM'					=> 'de <strong>%s</strong>',
++	'SPECIAL_TOPIC_MOVED_TO'					=> 'para <strong>%s</strong>',
++	'SPECIAL_TOPIC_MOVED_BY'					=> 'por %s',
++	'SPECIAL_TOPIC_MOVED_ON'					=> 'em %s.',
++	'SPECIAL_TOPIC_MOVED_NO_USER'				=> 'desconhecido',
++	'SPECIAL_TOPIC_MOVED_UNDO'					=> 'Mover este tópico de volta.',
++
++	'SPECIAL_TOPIC_MOVED_NOTIFICATION'			=> 'Quando alguém move um tópico teu.',
++	'SPECIAL_TOPIC_MOVED_NOTIFICATION_TITLE'	=> 'O teu tópico “%1$s” foi <strong>movido</strong> por %2$s para “%3$s”.',
++]);
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialtopicmove/language/pt/email/topic_moved.txt" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialtopicmove/language/pt/email/topic_moved.txt"
+new file mode 100644
+index 000000000..2d8fdf880
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialtopicmove/language/pt/email/topic_moved.txt"
+@@ -0,0 +1,17 @@
++Subject: Tópico movido - "{{ TOPIC_TITLE }}"
++
++Olá, {{ USERNAME }},
++
++
++Estás a receber esta notificação para avisar de que o teu tópico "{{ TOPIC_TITLE }}" foi movido por "{{ TOPIC_MOVER }}" para "{{ FORUM_NAME }}".
++{% if REASON %}
++Motivo:
++
++{{ REASON }}
++{% endif %}
++
++Caso não desejes receber mais e-mails relacionados com tópicos movidos, por favor, corrige as tuas notificações aqui:
++
++{{ U_NOTIFICATION_SETTINGS }}
++
++{{ EMAIL_SIG }}
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialtopicmove/language/pt_preao/acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialtopicmove/language/pt_preao/acp.php"
+new file mode 100644
+index 000000000..a41e8c49a
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialtopicmove/language/pt_preao/acp.php"
+@@ -0,0 +1,46 @@
++<?php
++
++/**
++ *
++ * Prime Topic Move. An extension for the phpBB Forum Software package.
++ *
++ * @copyright (c) 2019, kasimi, https://kasimi.net
++ * @license GNU General Public License, version 2 (GPL-2.0)
++ *
++ */
++
++if (!defined('IN_PHPBB'))
++{
++	exit;
++}
++
++if (empty($lang) || !is_array($lang))
++{
++	$lang = [];
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
++$lang = array_merge($lang, [
++	'SPECIAL_TOPIC_MOVED_DISPLAY'			=> 'Display details about moved topics',
++	'SPECIAL_TOPIC_MOVED_DISPLAY_EXPLAIN'	=> 'Determines where the details of a moved topic will be displayed.',
++	'SPECIAL_TOPIC_MOVED_DISPLAY_NEVER'	=> 'Don’t show details about the move',
++	'SPECIAL_TOPIC_MOVED_DISPLAY_FIRST'	=> 'Show on first post of the thread',
++	'SPECIAL_TOPIC_MOVED_DISPLAY_LAST'	=> 'Show on last post of the thread',
++	'SPECIAL_TOPIC_MOVED_DISPLAY_MOVED'	=> 'Show on last post at time of move',
++	'SPECIAL_TOPIC_MOVED_DISPLAY_SHADOW'	=> 'Show with shadow link in forum list',
++]);
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialtopicmove/language/pt_preao/common.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialtopicmove/language/pt_preao/common.php"
+new file mode 100644
+index 000000000..44c5db403
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialtopicmove/language/pt_preao/common.php"
+@@ -0,0 +1,54 @@
++<?php
++
++/**
++ *
++ * Prime Topic Move. An extension for the phpBB Forum Software package.
++ *
++ * @copyright (c) 2019, kasimi, https://kasimi.net
++ * @license GNU General Public License, version 2 (GPL-2.0)
++ *
++ */
++
++if (!defined('IN_PHPBB'))
++{
++	exit;
++}
++
++if (empty($lang) || !is_array($lang))
++{
++	$lang = [];
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
++$lang = array_merge($lang, [
++	'SPECIAL_TOPIC_MOVE_ENTER_REASON'			=> [
++		1 => 'Por favor, escreve um motivo para mover este tópico',
++		2 => 'Por favor, escreve um motivo para mover estes tópicos',
++	],
++	'SPECIAL_TOPIC_MOVED_MESSAGE'				=> 'Este tópico foi movido',
++	'SPECIAL_TOPIC_MOVED_FROM'					=> 'de <strong>%s</strong>',
++	'SPECIAL_TOPIC_MOVED_TO'					=> 'para <strong>%s</strong>',
++	'SPECIAL_TOPIC_MOVED_BY'					=> 'por %s',
++	'SPECIAL_TOPIC_MOVED_ON'					=> 'em %s.',
++	'SPECIAL_TOPIC_MOVED_NO_USER'				=> 'desconhecido',
++	'SPECIAL_TOPIC_MOVED_UNDO'					=> 'Mover este tópico de volta.',
++
++	'SPECIAL_TOPIC_MOVED_NOTIFICATION'			=> 'Quando alguém move um tópico teu.',
++	'SPECIAL_TOPIC_MOVED_NOTIFICATION_TITLE'	=> 'O teu tópico “%1$s” foi <strong>movido</strong> por %2$s para “%3$s”.',
++]);
++
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialtopicmove/language/pt_preao/email/topic_moved.txt" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialtopicmove/language/pt_preao/email/topic_moved.txt"
+new file mode 100644
+index 000000000..2d8fdf880
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialtopicmove/language/pt_preao/email/topic_moved.txt"
+@@ -0,0 +1,17 @@
++Subject: Tópico movido - "{{ TOPIC_TITLE }}"
++
++Olá, {{ USERNAME }},
++
++
++Estás a receber esta notificação para avisar de que o teu tópico "{{ TOPIC_TITLE }}" foi movido por "{{ TOPIC_MOVER }}" para "{{ FORUM_NAME }}".
++{% if REASON %}
++Motivo:
++
++{{ REASON }}
++{% endif %}
++
++Caso não desejes receber mais e-mails relacionados com tópicos movidos, por favor, corrige as tuas notificações aqui:
++
++{{ U_NOTIFICATION_SETTINGS }}
++
++{{ EMAIL_SIG }}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialtopicmove/notification/topic_moved.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialtopicmove/notification/topic_moved.php"
+index 95325052c..e5fc0a522 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialtopicmove/notification/topic_moved.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialtopicmove/notification/topic_moved.php"
+@@ -111,7 +111,7 @@ class topic_moved extends base
+ 			't' => $this->get_data('topic_id'),
+ 		];
+ 
+-		$script_php = 'viewtopic' . $this->php_ext;
++		$script_php = 'viewtopic.' . $this->php_ext;
+ 
+ 		if ($reference_type == UrlGeneratorInterface::ABSOLUTE_URL)
+ 		{
+@@ -165,7 +165,7 @@ class topic_moved extends base
+ 		}
+ 
+ 		$topic_id = $this->get_data('topic_id');
+-		$topic_data = phpbb_get_topic_data([$topic_id], 'f_list');
++		$topic_data = phpbb_get_topic_data([$topic_id], false);
+ 		return isset($topic_data[$topic_id]) ? $topic_data[$topic_id]['topic_title'] : '';
+ 	}
+ 
+@@ -183,7 +183,7 @@ class topic_moved extends base
+ 		}
+ 
+ 		$forum_id = $this->get_data('forum_id');
+-		$forum_info = phpbb_get_forum_data([$forum_id]);
++		$forum_info = phpbb_get_forum_data([$forum_id], false);
+ 		return isset($forum_info[$forum_id]) ? $forum_info[$forum_id]['forum_name'] : '';
+ 	}
+ }
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialtopicmove/styles/FLATBOOTS/template/event/mcp_move_destination_forum_before.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialtopicmove/styles/FLATBOOTS/template/event/mcp_move_destination_forum_before.html"
+new file mode 100644
+index 000000000..cb897e8ad
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialtopicmove/styles/FLATBOOTS/template/event/mcp_move_destination_forum_before.html"
+@@ -0,0 +1,3 @@
++{% if TOPIC_MOVED_MODE == 'reason' %}
++	{% include '@leinad4mind_specialtopicmove/special_topic_move_reason.html' %}
++{% endif %}
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialtopicmove/styles/FLATBOOTS/template/event/mcp_topic_postrow_attachments_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialtopicmove/styles/FLATBOOTS/template/event/mcp_topic_postrow_attachments_after.html"
+new file mode 100644
+index 000000000..6dbf06c45
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialtopicmove/styles/FLATBOOTS/template/event/mcp_topic_postrow_attachments_after.html"
+@@ -0,0 +1,3 @@
++{% if postrow.TOPIC_MOVED_MODE == 'topic' %}
++	{% include '@leinad4mind_specialtopicmove/special_topic_move_topic.html' %}
++{% endif %}
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialtopicmove/styles/FLATBOOTS/template/event/topiclist_row_topic_by_author_before.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialtopicmove/styles/FLATBOOTS/template/event/topiclist_row_topic_by_author_before.html"
+new file mode 100644
+index 000000000..4d5c67efe
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialtopicmove/styles/FLATBOOTS/template/event/topiclist_row_topic_by_author_before.html"
+@@ -0,0 +1,3 @@
++{% if topicrow.TOPIC_MOVED_MODE == 'forum' %}
++	{% include '@leinad4mind_specialtopicmove/special_topic_move_forum.html' %}
++{% endif %}
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialtopicmove/styles/FLATBOOTS/template/event/viewtopic_body_postrow_post_notices_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialtopicmove/styles/FLATBOOTS/template/event/viewtopic_body_postrow_post_notices_after.html"
+new file mode 100644
+index 000000000..6dbf06c45
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialtopicmove/styles/FLATBOOTS/template/event/viewtopic_body_postrow_post_notices_after.html"
+@@ -0,0 +1,3 @@
++{% if postrow.TOPIC_MOVED_MODE == 'topic' %}
++	{% include '@leinad4mind_specialtopicmove/special_topic_move_topic.html' %}
++{% endif %}
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialtopicmove/styles/FLATBOOTS/template/special_topic_move_forum.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialtopicmove/styles/FLATBOOTS/template/special_topic_move_forum.html"
+new file mode 100644
+index 000000000..c4e8c466f
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialtopicmove/styles/FLATBOOTS/template/special_topic_move_forum.html"
+@@ -0,0 +1,8 @@
++<span>
++	{{ topicrow.TOPIC_MOVED_MESSAGE }} {{ topicrow.TOPIC_MOVED_TO }} {{ topicrow.TOPIC_MOVED_ON }}
++	{% if topicrow.TOPIC_MOVED_REASON %}
++		<br>
++		<span><strong>{{ lang('REASON') ~ lang('COLON') }}</strong> <em>{{ topicrow.TOPIC_MOVED_REASON }}</em></span>
++	{% endif %}
++	<br>
++</span>
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialtopicmove/styles/FLATBOOTS/template/special_topic_move_reason.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialtopicmove/styles/FLATBOOTS/template/special_topic_move_reason.html"
+new file mode 100644
+index 000000000..33876235a
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialtopicmove/styles/FLATBOOTS/template/special_topic_move_reason.html"
+@@ -0,0 +1,4 @@
++<dl class="fields2">
++	<dt><label for="moved_reason">{{ lang('SPECIAL_TOPIC_MOVE_ENTER_REASON', SPECIAL_TOPIC_MOVE_TOPIC_COUNT) ~ lang('COLON') }}</label></dt>
++	<dd><input type="text" class="inputbox autowidth" name="moved_reason" id="moved_reason" size="50" maxlength="100" value=""></dd>
++</dl>
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialtopicmove/styles/FLATBOOTS/template/special_topic_move_topic.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialtopicmove/styles/FLATBOOTS/template/special_topic_move_topic.html"
+new file mode 100644
+index 000000000..6d791d45c
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialtopicmove/styles/FLATBOOTS/template/special_topic_move_topic.html"
+@@ -0,0 +1,7 @@
++<div class="notice text-muted">
++	<small>{{ postrow.TOPIC_MOVED_MESSAGE }} {{ postrow.TOPIC_MOVED_FROM }} {{ postrow.TOPIC_MOVED_BY }} {{ postrow.TOPIC_MOVED_ON }} {{ postrow.TOPIC_MOVED_UNDO }}</small>
++	{% if postrow.TOPIC_MOVED_REASON %}
++		<br>
++		<small><strong>{{ lang('REASON') ~ lang('COLON') }}</strong> <em>{{ postrow.TOPIC_MOVED_REASON }}</em></small>
++	{% endif %}
++</div>
diff --git "[FORUM_EXT]/leinad4mind\\specialtopicmove/diff_nospace.tmp" "[FORUM_EXT]/leinad4mind\\specialtopicmove/diff_nospace.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/leinad4mind\\specialtopicmove/diff_nospace.tmp"
@@ -0,0 +1,493 @@
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialtopicmove/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialtopicmove/diff_full.tmp"
+new file mode 100644
+index 000000000..5ff1c0a2e
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialtopicmove/diff_full.tmp"
+@@ -0,0 +1,502 @@
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialtopicmove/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialtopicmove/diff_full.tmp"
++new file mode 100644
++index 000000000..e69de29bb
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialtopicmove/event/main_listener.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialtopicmove/event/main_listener.php"
++index 68b49aa10..d7551f16a 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialtopicmove/event/main_listener.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialtopicmove/event/main_listener.php"
++@@ -206,8 +206,8 @@ class main_listener implements EventSubscriberInterface
++ 					$acl[$topic_data[$topic_id]['topic_poster']] = $auth;
++ 				}
++ 
++-				if ($acl[$topic_data[$topic_id]['topic_poster']]->acl_get('f_list', $event['forum_id']))
++-				{
+++				// if ($acl[$topic_data[$topic_id]['topic_poster']]->acl_get('f_list', $event['forum_id']))
+++				// {
++ 					$this->notification_manager->add_notifications('leinad4mind.specialtopicmove.notification.type.topic_moved', [
++ 						'topic_id'		=> $topic_id,
++ 						'forum_id'		=> $event['forum_id'],
++@@ -215,7 +215,7 @@ class main_listener implements EventSubscriberInterface
++ 						'topic_mover'	=> $this->user->data['user_id'],
++ 						'reason'		=> $reason,
++ 					]);
++-				}
+++				// }
++ 			}
++ 		}
++ 	}
++@@ -357,8 +357,13 @@ class main_listener implements EventSubscriberInterface
++ 			$row = $this->db->sql_fetchrow($result);
++ 			$this->db->sql_freeresult($result);
++ 
+++			$forum_name = '';
+++			if (!empty($row) && is_array($row) && isset($row['forum_name'])) {
+++				$forum_name = $row['forum_name'];
+++			}
+++
++ 			$this->forums[$forum_id] = [
++-				'forum_name'	=> $row['forum_name'],
+++				'forum_name'	=> $forum_name,
++ 			];
++ 		}
++ 
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialtopicmove/language/en/acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialtopicmove/language/en/acp.php"
++index 43e1e5bb2..a41e8c49a 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialtopicmove/language/en/acp.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialtopicmove/language/en/acp.php"
++@@ -2,9 +2,9 @@
++ 
++ /**
++  *
++- * Special Topic Move. An extension for the phpBB Forum Software package.
+++ * Prime Topic Move. An extension for the phpBB Forum Software package.
++  *
++- * @copyright (c) 2019, Leinad4Mind, https://leinad4mind.top/forum
+++ * @copyright (c) 2019, kasimi, https://kasimi.net
++  * @license GNU General Public License, version 2 (GPL-2.0)
++  *
++  */
++@@ -38,9 +38,9 @@ if (empty($lang) || !is_array($lang))
++ $lang = array_merge($lang, [
++ 	'SPECIAL_TOPIC_MOVED_DISPLAY'			=> 'Display details about moved topics',
++ 	'SPECIAL_TOPIC_MOVED_DISPLAY_EXPLAIN'	=> 'Determines where the details of a moved topic will be displayed.',
++-	'SPECIAL_TOPIC_MOVED_DISPLAY_NEVER'		=> 'Don’t show details about the move',
++-	'SPECIAL_TOPIC_MOVED_DISPLAY_FIRST'		=> 'Show on first post of the thread',
++-	'SPECIAL_TOPIC_MOVED_DISPLAY_LAST'		=> 'Show on last post of the thread',
++-	'SPECIAL_TOPIC_MOVED_DISPLAY_MOVED'		=> 'Show on last post at time of move',
+++	'SPECIAL_TOPIC_MOVED_DISPLAY_NEVER'	=> 'Don’t show details about the move',
+++	'SPECIAL_TOPIC_MOVED_DISPLAY_FIRST'	=> 'Show on first post of the thread',
+++	'SPECIAL_TOPIC_MOVED_DISPLAY_LAST'	=> 'Show on last post of the thread',
+++	'SPECIAL_TOPIC_MOVED_DISPLAY_MOVED'	=> 'Show on last post at time of move',
++ 	'SPECIAL_TOPIC_MOVED_DISPLAY_SHADOW'	=> 'Show with shadow link in forum list',
++ ]);
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialtopicmove/language/en/common.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialtopicmove/language/en/common.php"
++index 11a532360..1407d2771 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialtopicmove/language/en/common.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialtopicmove/language/en/common.php"
++@@ -2,9 +2,9 @@
++ 
++ /**
++  *
++- * Special Topic Move. An extension for the phpBB Forum Software package.
+++ * Prime Topic Move. An extension for the phpBB Forum Software package.
++  *
++- * @copyright (c) 2019, Leinad4Mind, https://leinad4mind.top/forum
+++ * @copyright (c) 2019, kasimi, https://kasimi.net
++  * @license GNU General Public License, version 2 (GPL-2.0)
++  *
++  */
++@@ -41,13 +41,14 @@ $lang = array_merge($lang, [
++ 		2 => 'Please enter a reason for moving these topics',
++ 	],
++ 	'SPECIAL_TOPIC_MOVED_MESSAGE'				=> 'This topic was moved',
++-	'SPECIAL_TOPIC_MOVED_FROM'					=> 'from <strong>%s</strong>',
+++	'SPECIAL_TOPIC_MOVED_FROM'				=> 'from <strong>%s</strong>',
++ 	'SPECIAL_TOPIC_MOVED_TO'					=> 'to <strong>%s</strong>',
++ 	'SPECIAL_TOPIC_MOVED_BY'					=> 'by %s',
++ 	'SPECIAL_TOPIC_MOVED_ON'					=> 'on %s.',
++ 	'SPECIAL_TOPIC_MOVED_NO_USER'				=> 'a nonexistent user',
++-	'SPECIAL_TOPIC_MOVED_UNDO'					=> 'Move this topic back.',
+++	'SPECIAL_TOPIC_MOVED_UNDO'				=> 'Move this topic back.',
++ 
++-	'SPECIAL_TOPIC_MOVED_NOTIFICATION'			=> 'Someone moves your topic.',
+++	'SPECIAL_TOPIC_MOVED_NOTIFICATION'		=> 'Someone moves your topic.',
++ 	'SPECIAL_TOPIC_MOVED_NOTIFICATION_TITLE'	=> 'Your topic “%1$s” was <strong>moved</strong> by %2$s to “%3$s”.',
+++
++ ]);
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialtopicmove/language/en/email/topic_moved.txt" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialtopicmove/language/en/email/topic_moved.txt"
++new file mode 100644
++index 000000000..7c795ae8f
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialtopicmove/language/en/email/topic_moved.txt"
++@@ -0,0 +1,17 @@
+++Subject: Topic moved - "{{ TOPIC_TITLE }}"
+++
+++Hello {{ USERNAME }},
+++
+++
+++You are receiving this notification because your topic "{{ TOPIC_TITLE }}" was moved by "{{ TOPIC_MOVER }}" to "{{ FORUM_NAME }}".
+++{% if REASON %}
+++Reason:
+++
+++{{ REASON }}
+++{% endif %}
+++
+++If you no longer wish to receive emails when your topics are moved, please update your notification settings here:
+++
+++{{ U_NOTIFICATION_SETTINGS }}
+++
+++{{ EMAIL_SIG }}
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialtopicmove/language/pt/acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialtopicmove/language/pt/acp.php"
++new file mode 100644
++index 000000000..43e1e5bb2
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialtopicmove/language/pt/acp.php"
++@@ -0,0 +1,46 @@
+++<?php
+++
+++/**
+++ *
+++ * Special Topic Move. An extension for the phpBB Forum Software package.
+++ *
+++ * @copyright (c) 2019, Leinad4Mind, https://leinad4mind.top/forum
+++ * @license GNU General Public License, version 2 (GPL-2.0)
+++ *
+++ */
+++
+++if (!defined('IN_PHPBB'))
+++{
+++	exit;
+++}
+++
+++if (empty($lang) || !is_array($lang))
+++{
+++	$lang = [];
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
+++$lang = array_merge($lang, [
+++	'SPECIAL_TOPIC_MOVED_DISPLAY'			=> 'Display details about moved topics',
+++	'SPECIAL_TOPIC_MOVED_DISPLAY_EXPLAIN'	=> 'Determines where the details of a moved topic will be displayed.',
+++	'SPECIAL_TOPIC_MOVED_DISPLAY_NEVER'		=> 'Don’t show details about the move',
+++	'SPECIAL_TOPIC_MOVED_DISPLAY_FIRST'		=> 'Show on first post of the thread',
+++	'SPECIAL_TOPIC_MOVED_DISPLAY_LAST'		=> 'Show on last post of the thread',
+++	'SPECIAL_TOPIC_MOVED_DISPLAY_MOVED'		=> 'Show on last post at time of move',
+++	'SPECIAL_TOPIC_MOVED_DISPLAY_SHADOW'	=> 'Show with shadow link in forum list',
+++]);
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialtopicmove/language/pt/common.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialtopicmove/language/pt/common.php"
++new file mode 100644
++index 000000000..9612a52c8
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialtopicmove/language/pt/common.php"
++@@ -0,0 +1,53 @@
+++<?php
+++
+++/**
+++ *
+++ * Special Topic Move. An extension for the phpBB Forum Software package.
+++ *
+++ * @copyright (c) 2019, Leinad4Mind, https://leinad4mind.top/forum
+++ * @license GNU General Public License, version 2 (GPL-2.0)
+++ *
+++ */
+++
+++if (!defined('IN_PHPBB'))
+++{
+++	exit;
+++}
+++
+++if (empty($lang) || !is_array($lang))
+++{
+++	$lang = [];
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
+++$lang = array_merge($lang, [
+++	'SPECIAL_TOPIC_MOVE_ENTER_REASON'			=> [
+++		1 => 'Por favor, escreve um motivo para mover este tópico',
+++		2 => 'Por favor, escreve um motivo para mover estes tópicos',
+++	],
+++	'SPECIAL_TOPIC_MOVED_MESSAGE'				=> 'Este tópico foi movido',
+++	'SPECIAL_TOPIC_MOVED_FROM'					=> 'de <strong>%s</strong>',
+++	'SPECIAL_TOPIC_MOVED_TO'					=> 'para <strong>%s</strong>',
+++	'SPECIAL_TOPIC_MOVED_BY'					=> 'por %s',
+++	'SPECIAL_TOPIC_MOVED_ON'					=> 'em %s.',
+++	'SPECIAL_TOPIC_MOVED_NO_USER'				=> 'desconhecido',
+++	'SPECIAL_TOPIC_MOVED_UNDO'					=> 'Mover este tópico de volta.',
+++
+++	'SPECIAL_TOPIC_MOVED_NOTIFICATION'			=> 'Quando alguém move um tópico teu.',
+++	'SPECIAL_TOPIC_MOVED_NOTIFICATION_TITLE'	=> 'O teu tópico “%1$s” foi <strong>movido</strong> por %2$s para “%3$s”.',
+++]);
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialtopicmove/language/pt/email/topic_moved.txt" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialtopicmove/language/pt/email/topic_moved.txt"
++new file mode 100644
++index 000000000..2d8fdf880
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialtopicmove/language/pt/email/topic_moved.txt"
++@@ -0,0 +1,17 @@
+++Subject: Tópico movido - "{{ TOPIC_TITLE }}"
+++
+++Olá, {{ USERNAME }},
+++
+++
+++Estás a receber esta notificação para avisar de que o teu tópico "{{ TOPIC_TITLE }}" foi movido por "{{ TOPIC_MOVER }}" para "{{ FORUM_NAME }}".
+++{% if REASON %}
+++Motivo:
+++
+++{{ REASON }}
+++{% endif %}
+++
+++Caso não desejes receber mais e-mails relacionados com tópicos movidos, por favor, corrige as tuas notificações aqui:
+++
+++{{ U_NOTIFICATION_SETTINGS }}
+++
+++{{ EMAIL_SIG }}
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialtopicmove/language/pt_preao/acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialtopicmove/language/pt_preao/acp.php"
++new file mode 100644
++index 000000000..a41e8c49a
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialtopicmove/language/pt_preao/acp.php"
++@@ -0,0 +1,46 @@
+++<?php
+++
+++/**
+++ *
+++ * Prime Topic Move. An extension for the phpBB Forum Software package.
+++ *
+++ * @copyright (c) 2019, kasimi, https://kasimi.net
+++ * @license GNU General Public License, version 2 (GPL-2.0)
+++ *
+++ */
+++
+++if (!defined('IN_PHPBB'))
+++{
+++	exit;
+++}
+++
+++if (empty($lang) || !is_array($lang))
+++{
+++	$lang = [];
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
+++$lang = array_merge($lang, [
+++	'SPECIAL_TOPIC_MOVED_DISPLAY'			=> 'Display details about moved topics',
+++	'SPECIAL_TOPIC_MOVED_DISPLAY_EXPLAIN'	=> 'Determines where the details of a moved topic will be displayed.',
+++	'SPECIAL_TOPIC_MOVED_DISPLAY_NEVER'	=> 'Don’t show details about the move',
+++	'SPECIAL_TOPIC_MOVED_DISPLAY_FIRST'	=> 'Show on first post of the thread',
+++	'SPECIAL_TOPIC_MOVED_DISPLAY_LAST'	=> 'Show on last post of the thread',
+++	'SPECIAL_TOPIC_MOVED_DISPLAY_MOVED'	=> 'Show on last post at time of move',
+++	'SPECIAL_TOPIC_MOVED_DISPLAY_SHADOW'	=> 'Show with shadow link in forum list',
+++]);
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialtopicmove/language/pt_preao/common.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialtopicmove/language/pt_preao/common.php"
++new file mode 100644
++index 000000000..44c5db403
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialtopicmove/language/pt_preao/common.php"
++@@ -0,0 +1,54 @@
+++<?php
+++
+++/**
+++ *
+++ * Prime Topic Move. An extension for the phpBB Forum Software package.
+++ *
+++ * @copyright (c) 2019, kasimi, https://kasimi.net
+++ * @license GNU General Public License, version 2 (GPL-2.0)
+++ *
+++ */
+++
+++if (!defined('IN_PHPBB'))
+++{
+++	exit;
+++}
+++
+++if (empty($lang) || !is_array($lang))
+++{
+++	$lang = [];
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
+++$lang = array_merge($lang, [
+++	'SPECIAL_TOPIC_MOVE_ENTER_REASON'			=> [
+++		1 => 'Por favor, escreve um motivo para mover este tópico',
+++		2 => 'Por favor, escreve um motivo para mover estes tópicos',
+++	],
+++	'SPECIAL_TOPIC_MOVED_MESSAGE'				=> 'Este tópico foi movido',
+++	'SPECIAL_TOPIC_MOVED_FROM'					=> 'de <strong>%s</strong>',
+++	'SPECIAL_TOPIC_MOVED_TO'					=> 'para <strong>%s</strong>',
+++	'SPECIAL_TOPIC_MOVED_BY'					=> 'por %s',
+++	'SPECIAL_TOPIC_MOVED_ON'					=> 'em %s.',
+++	'SPECIAL_TOPIC_MOVED_NO_USER'				=> 'desconhecido',
+++	'SPECIAL_TOPIC_MOVED_UNDO'					=> 'Mover este tópico de volta.',
+++
+++	'SPECIAL_TOPIC_MOVED_NOTIFICATION'			=> 'Quando alguém move um tópico teu.',
+++	'SPECIAL_TOPIC_MOVED_NOTIFICATION_TITLE'	=> 'O teu tópico “%1$s” foi <strong>movido</strong> por %2$s para “%3$s”.',
+++]);
+++
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialtopicmove/language/pt_preao/email/topic_moved.txt" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialtopicmove/language/pt_preao/email/topic_moved.txt"
++new file mode 100644
++index 000000000..2d8fdf880
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialtopicmove/language/pt_preao/email/topic_moved.txt"
++@@ -0,0 +1,17 @@
+++Subject: Tópico movido - "{{ TOPIC_TITLE }}"
+++
+++Olá, {{ USERNAME }},
+++
+++
+++Estás a receber esta notificação para avisar de que o teu tópico "{{ TOPIC_TITLE }}" foi movido por "{{ TOPIC_MOVER }}" para "{{ FORUM_NAME }}".
+++{% if REASON %}
+++Motivo:
+++
+++{{ REASON }}
+++{% endif %}
+++
+++Caso não desejes receber mais e-mails relacionados com tópicos movidos, por favor, corrige as tuas notificações aqui:
+++
+++{{ U_NOTIFICATION_SETTINGS }}
+++
+++{{ EMAIL_SIG }}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialtopicmove/notification/topic_moved.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialtopicmove/notification/topic_moved.php"
++index 95325052c..e5fc0a522 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\specialtopicmove/notification/topic_moved.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialtopicmove/notification/topic_moved.php"
++@@ -111,7 +111,7 @@ class topic_moved extends base
++ 			't' => $this->get_data('topic_id'),
++ 		];
++ 
++-		$script_php = 'viewtopic' . $this->php_ext;
+++		$script_php = 'viewtopic.' . $this->php_ext;
++ 
++ 		if ($reference_type == UrlGeneratorInterface::ABSOLUTE_URL)
++ 		{
++@@ -165,7 +165,7 @@ class topic_moved extends base
++ 		}
++ 
++ 		$topic_id = $this->get_data('topic_id');
++-		$topic_data = phpbb_get_topic_data([$topic_id], 'f_list');
+++		$topic_data = phpbb_get_topic_data([$topic_id], false);
++ 		return isset($topic_data[$topic_id]) ? $topic_data[$topic_id]['topic_title'] : '';
++ 	}
++ 
++@@ -183,7 +183,7 @@ class topic_moved extends base
++ 		}
++ 
++ 		$forum_id = $this->get_data('forum_id');
++-		$forum_info = phpbb_get_forum_data([$forum_id]);
+++		$forum_info = phpbb_get_forum_data([$forum_id], false);
++ 		return isset($forum_info[$forum_id]) ? $forum_info[$forum_id]['forum_name'] : '';
++ 	}
++ }
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialtopicmove/styles/FLATBOOTS/template/event/mcp_move_destination_forum_before.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialtopicmove/styles/FLATBOOTS/template/event/mcp_move_destination_forum_before.html"
++new file mode 100644
++index 000000000..cb897e8ad
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialtopicmove/styles/FLATBOOTS/template/event/mcp_move_destination_forum_before.html"
++@@ -0,0 +1,3 @@
+++{% if TOPIC_MOVED_MODE == 'reason' %}
+++	{% include '@leinad4mind_specialtopicmove/special_topic_move_reason.html' %}
+++{% endif %}
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialtopicmove/styles/FLATBOOTS/template/event/mcp_topic_postrow_attachments_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialtopicmove/styles/FLATBOOTS/template/event/mcp_topic_postrow_attachments_after.html"
++new file mode 100644
++index 000000000..6dbf06c45
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialtopicmove/styles/FLATBOOTS/template/event/mcp_topic_postrow_attachments_after.html"
++@@ -0,0 +1,3 @@
+++{% if postrow.TOPIC_MOVED_MODE == 'topic' %}
+++	{% include '@leinad4mind_specialtopicmove/special_topic_move_topic.html' %}
+++{% endif %}
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialtopicmove/styles/FLATBOOTS/template/event/topiclist_row_topic_by_author_before.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialtopicmove/styles/FLATBOOTS/template/event/topiclist_row_topic_by_author_before.html"
++new file mode 100644
++index 000000000..4d5c67efe
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialtopicmove/styles/FLATBOOTS/template/event/topiclist_row_topic_by_author_before.html"
++@@ -0,0 +1,3 @@
+++{% if topicrow.TOPIC_MOVED_MODE == 'forum' %}
+++	{% include '@leinad4mind_specialtopicmove/special_topic_move_forum.html' %}
+++{% endif %}
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialtopicmove/styles/FLATBOOTS/template/event/viewtopic_body_postrow_post_notices_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialtopicmove/styles/FLATBOOTS/template/event/viewtopic_body_postrow_post_notices_after.html"
++new file mode 100644
++index 000000000..6dbf06c45
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialtopicmove/styles/FLATBOOTS/template/event/viewtopic_body_postrow_post_notices_after.html"
++@@ -0,0 +1,3 @@
+++{% if postrow.TOPIC_MOVED_MODE == 'topic' %}
+++	{% include '@leinad4mind_specialtopicmove/special_topic_move_topic.html' %}
+++{% endif %}
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialtopicmove/styles/FLATBOOTS/template/special_topic_move_forum.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialtopicmove/styles/FLATBOOTS/template/special_topic_move_forum.html"
++new file mode 100644
++index 000000000..c4e8c466f
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialtopicmove/styles/FLATBOOTS/template/special_topic_move_forum.html"
++@@ -0,0 +1,8 @@
+++<span>
+++	{{ topicrow.TOPIC_MOVED_MESSAGE }} {{ topicrow.TOPIC_MOVED_TO }} {{ topicrow.TOPIC_MOVED_ON }}
+++	{% if topicrow.TOPIC_MOVED_REASON %}
+++		<br>
+++		<span><strong>{{ lang('REASON') ~ lang('COLON') }}</strong> <em>{{ topicrow.TOPIC_MOVED_REASON }}</em></span>
+++	{% endif %}
+++	<br>
+++</span>
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialtopicmove/styles/FLATBOOTS/template/special_topic_move_reason.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialtopicmove/styles/FLATBOOTS/template/special_topic_move_reason.html"
++new file mode 100644
++index 000000000..33876235a
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\specialtopicmove/styles/FLATBOOTS/template/special_topic_move_reason.html"
++@@ -0,0 +1,4 @@
+++<dl class="fields2">
+++	<dt><label for="moved_reason">{{ lang('SPECIAL
\ No newline at end of file
diff --git "[ORIGINAL]/leinad4mind\\specialtopicmove/event/main_listener.php" "[FORUM_EXT]/leinad4mind\\specialtopicmove/event/main_listener.php"
--- "[ORIGINAL]/leinad4mind\\specialtopicmove/event/main_listener.php"
+++ "[FORUM_EXT]/leinad4mind\\specialtopicmove/event/main_listener.php"
@@ -206,8 +206,8 @@ class main_listener implements EventSubscriberInterface
 					$acl[$topic_data[$topic_id]['topic_poster']] = $auth;
 				}
 
-				if ($acl[$topic_data[$topic_id]['topic_poster']]->acl_get('f_list', $event['forum_id']))
-				{
+				// if ($acl[$topic_data[$topic_id]['topic_poster']]->acl_get('f_list', $event['forum_id']))
+				// {
 					$this->notification_manager->add_notifications('leinad4mind.specialtopicmove.notification.type.topic_moved', [
 						'topic_id'		=> $topic_id,
 						'forum_id'		=> $event['forum_id'],
@@ -215,7 +215,7 @@ class main_listener implements EventSubscriberInterface
 						'topic_mover'	=> $this->user->data['user_id'],
 						'reason'		=> $reason,
 					]);
-				}
+				// }
 			}
 		}
 	}
@@ -357,8 +357,13 @@ class main_listener implements EventSubscriberInterface
 			$row = $this->db->sql_fetchrow($result);
 			$this->db->sql_freeresult($result);
 
+			$forum_name = '';
+			if (!empty($row) && is_array($row) && isset($row['forum_name'])) {
+				$forum_name = $row['forum_name'];
+			}
+
 			$this->forums[$forum_id] = [
-				'forum_name'	=> $row['forum_name'],
+				'forum_name'	=> $forum_name,
 			];
 		}
 
diff --git "[ORIGINAL]/leinad4mind\\specialtopicmove/language/en/acp.php" "[FORUM_EXT]/leinad4mind\\specialtopicmove/language/en/acp.php"
--- "[ORIGINAL]/leinad4mind\\specialtopicmove/language/en/acp.php"
+++ "[FORUM_EXT]/leinad4mind\\specialtopicmove/language/en/acp.php"
@@ -2,9 +2,9 @@
 
 /**
  *
- * Special Topic Move. An extension for the phpBB Forum Software package.
+ * Prime Topic Move. An extension for the phpBB Forum Software package.
  *
- * @copyright (c) 2019, Leinad4Mind, https://leinad4mind.top/forum
+ * @copyright (c) 2019, kasimi, https://kasimi.net
  * @license GNU General Public License, version 2 (GPL-2.0)
  *
  */
diff --git "[ORIGINAL]/leinad4mind\\specialtopicmove/language/en/common.php" "[FORUM_EXT]/leinad4mind\\specialtopicmove/language/en/common.php"
--- "[ORIGINAL]/leinad4mind\\specialtopicmove/language/en/common.php"
+++ "[FORUM_EXT]/leinad4mind\\specialtopicmove/language/en/common.php"
@@ -2,9 +2,9 @@
 
 /**
  *
- * Special Topic Move. An extension for the phpBB Forum Software package.
+ * Prime Topic Move. An extension for the phpBB Forum Software package.
  *
- * @copyright (c) 2019, Leinad4Mind, https://leinad4mind.top/forum
+ * @copyright (c) 2019, kasimi, https://kasimi.net
  * @license GNU General Public License, version 2 (GPL-2.0)
  *
  */
@@ -50,4 +50,5 @@ $lang = array_merge($lang, [
 
 	'SPECIAL_TOPIC_MOVED_NOTIFICATION'		=> 'Someone moves your topic.',
 	'SPECIAL_TOPIC_MOVED_NOTIFICATION_TITLE'	=> 'Your topic “%1$s” was <strong>moved</strong> by %2$s to “%3$s”.',
+
 ]);
diff --git "[FORUM_EXT]/leinad4mind\\specialtopicmove/language/en/email/topic_moved.txt" "[FORUM_EXT]/leinad4mind\\specialtopicmove/language/en/email/topic_moved.txt"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/leinad4mind\\specialtopicmove/language/en/email/topic_moved.txt"
@@ -0,0 +1,17 @@
+Subject: Topic moved - "{{ TOPIC_TITLE }}"
+
+Hello {{ USERNAME }},
+
+
+You are receiving this notification because your topic "{{ TOPIC_TITLE }}" was moved by "{{ TOPIC_MOVER }}" to "{{ FORUM_NAME }}".
+{% if REASON %}
+Reason:
+
+{{ REASON }}
+{% endif %}
+
+If you no longer wish to receive emails when your topics are moved, please update your notification settings here:
+
+{{ U_NOTIFICATION_SETTINGS }}
+
+{{ EMAIL_SIG }}
diff --git "[FORUM_EXT]/leinad4mind\\specialtopicmove/language/pt/acp.php" "[FORUM_EXT]/leinad4mind\\specialtopicmove/language/pt/acp.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/leinad4mind\\specialtopicmove/language/pt/acp.php"
@@ -0,0 +1,46 @@
+<?php
+
+/**
+ *
+ * Special Topic Move. An extension for the phpBB Forum Software package.
+ *
+ * @copyright (c) 2019, Leinad4Mind, https://leinad4mind.top/forum
+ * @license GNU General Public License, version 2 (GPL-2.0)
+ *
+ */
+
+if (!defined('IN_PHPBB'))
+{
+	exit;
+}
+
+if (empty($lang) || !is_array($lang))
+{
+	$lang = [];
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
+$lang = array_merge($lang, [
+	'SPECIAL_TOPIC_MOVED_DISPLAY'			=> 'Display details about moved topics',
+	'SPECIAL_TOPIC_MOVED_DISPLAY_EXPLAIN'	=> 'Determines where the details of a moved topic will be displayed.',
+	'SPECIAL_TOPIC_MOVED_DISPLAY_NEVER'		=> 'Don’t show details about the move',
+	'SPECIAL_TOPIC_MOVED_DISPLAY_FIRST'		=> 'Show on first post of the thread',
+	'SPECIAL_TOPIC_MOVED_DISPLAY_LAST'		=> 'Show on last post of the thread',
+	'SPECIAL_TOPIC_MOVED_DISPLAY_MOVED'		=> 'Show on last post at time of move',
+	'SPECIAL_TOPIC_MOVED_DISPLAY_SHADOW'	=> 'Show with shadow link in forum list',
+]);
diff --git "[FORUM_EXT]/leinad4mind\\specialtopicmove/language/pt/common.php" "[FORUM_EXT]/leinad4mind\\specialtopicmove/language/pt/common.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/leinad4mind\\specialtopicmove/language/pt/common.php"
@@ -0,0 +1,53 @@
+<?php
+
+/**
+ *
+ * Special Topic Move. An extension for the phpBB Forum Software package.
+ *
+ * @copyright (c) 2019, Leinad4Mind, https://leinad4mind.top/forum
+ * @license GNU General Public License, version 2 (GPL-2.0)
+ *
+ */
+
+if (!defined('IN_PHPBB'))
+{
+	exit;
+}
+
+if (empty($lang) || !is_array($lang))
+{
+	$lang = [];
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
+$lang = array_merge($lang, [
+	'SPECIAL_TOPIC_MOVE_ENTER_REASON'			=> [
+		1 => 'Por favor, escreve um motivo para mover este tópico',
+		2 => 'Por favor, escreve um motivo para mover estes tópicos',
+	],
+	'SPECIAL_TOPIC_MOVED_MESSAGE'				=> 'Este tópico foi movido',
+	'SPECIAL_TOPIC_MOVED_FROM'					=> 'de <strong>%s</strong>',
+	'SPECIAL_TOPIC_MOVED_TO'					=> 'para <strong>%s</strong>',
+	'SPECIAL_TOPIC_MOVED_BY'					=> 'por %s',
+	'SPECIAL_TOPIC_MOVED_ON'					=> 'em %s.',
+	'SPECIAL_TOPIC_MOVED_NO_USER'				=> 'desconhecido',
+	'SPECIAL_TOPIC_MOVED_UNDO'					=> 'Mover este tópico de volta.',
+
+	'SPECIAL_TOPIC_MOVED_NOTIFICATION'			=> 'Quando alguém move um tópico teu.',
+	'SPECIAL_TOPIC_MOVED_NOTIFICATION_TITLE'	=> 'O teu tópico “%1$s” foi <strong>movido</strong> por %2$s para “%3$s”.',
+]);
diff --git "[FORUM_EXT]/leinad4mind\\specialtopicmove/language/pt/email/topic_moved.txt" "[FORUM_EXT]/leinad4mind\\specialtopicmove/language/pt/email/topic_moved.txt"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/leinad4mind\\specialtopicmove/language/pt/email/topic_moved.txt"
@@ -0,0 +1,17 @@
+Subject: Tópico movido - "{{ TOPIC_TITLE }}"
+
+Olá, {{ USERNAME }},
+
+
+Estás a receber esta notificação para avisar de que o teu tópico "{{ TOPIC_TITLE }}" foi movido por "{{ TOPIC_MOVER }}" para "{{ FORUM_NAME }}".
+{% if REASON %}
+Motivo:
+
+{{ REASON }}
+{% endif %}
+
+Caso não desejes receber mais e-mails relacionados com tópicos movidos, por favor, corrige as tuas notificações aqui:
+
+{{ U_NOTIFICATION_SETTINGS }}
+
+{{ EMAIL_SIG }}
diff --git "[FORUM_EXT]/leinad4mind\\specialtopicmove/language/pt_preao/acp.php" "[FORUM_EXT]/leinad4mind\\specialtopicmove/language/pt_preao/acp.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/leinad4mind\\specialtopicmove/language/pt_preao/acp.php"
@@ -0,0 +1,46 @@
+<?php
+
+/**
+ *
+ * Prime Topic Move. An extension for the phpBB Forum Software package.
+ *
+ * @copyright (c) 2019, kasimi, https://kasimi.net
+ * @license GNU General Public License, version 2 (GPL-2.0)
+ *
+ */
+
+if (!defined('IN_PHPBB'))
+{
+	exit;
+}
+
+if (empty($lang) || !is_array($lang))
+{
+	$lang = [];
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
+$lang = array_merge($lang, [
+	'SPECIAL_TOPIC_MOVED_DISPLAY'			=> 'Display details about moved topics',
+	'SPECIAL_TOPIC_MOVED_DISPLAY_EXPLAIN'	=> 'Determines where the details of a moved topic will be displayed.',
+	'SPECIAL_TOPIC_MOVED_DISPLAY_NEVER'	=> 'Don’t show details about the move',
+	'SPECIAL_TOPIC_MOVED_DISPLAY_FIRST'	=> 'Show on first post of the thread',
+	'SPECIAL_TOPIC_MOVED_DISPLAY_LAST'	=> 'Show on last post of the thread',
+	'SPECIAL_TOPIC_MOVED_DISPLAY_MOVED'	=> 'Show on last post at time of move',
+	'SPECIAL_TOPIC_MOVED_DISPLAY_SHADOW'	=> 'Show with shadow link in forum list',
+]);
diff --git "[FORUM_EXT]/leinad4mind\\specialtopicmove/language/pt_preao/common.php" "[FORUM_EXT]/leinad4mind\\specialtopicmove/language/pt_preao/common.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/leinad4mind\\specialtopicmove/language/pt_preao/common.php"
@@ -0,0 +1,54 @@
+<?php
+
+/**
+ *
+ * Prime Topic Move. An extension for the phpBB Forum Software package.
+ *
+ * @copyright (c) 2019, kasimi, https://kasimi.net
+ * @license GNU General Public License, version 2 (GPL-2.0)
+ *
+ */
+
+if (!defined('IN_PHPBB'))
+{
+	exit;
+}
+
+if (empty($lang) || !is_array($lang))
+{
+	$lang = [];
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
+$lang = array_merge($lang, [
+	'SPECIAL_TOPIC_MOVE_ENTER_REASON'			=> [
+		1 => 'Por favor, escreve um motivo para mover este tópico',
+		2 => 'Por favor, escreve um motivo para mover estes tópicos',
+	],
+	'SPECIAL_TOPIC_MOVED_MESSAGE'				=> 'Este tópico foi movido',
+	'SPECIAL_TOPIC_MOVED_FROM'					=> 'de <strong>%s</strong>',
+	'SPECIAL_TOPIC_MOVED_TO'					=> 'para <strong>%s</strong>',
+	'SPECIAL_TOPIC_MOVED_BY'					=> 'por %s',
+	'SPECIAL_TOPIC_MOVED_ON'					=> 'em %s.',
+	'SPECIAL_TOPIC_MOVED_NO_USER'				=> 'desconhecido',
+	'SPECIAL_TOPIC_MOVED_UNDO'					=> 'Mover este tópico de volta.',
+
+	'SPECIAL_TOPIC_MOVED_NOTIFICATION'			=> 'Quando alguém move um tópico teu.',
+	'SPECIAL_TOPIC_MOVED_NOTIFICATION_TITLE'	=> 'O teu tópico “%1$s” foi <strong>movido</strong> por %2$s para “%3$s”.',
+]);
+
diff --git "[FORUM_EXT]/leinad4mind\\specialtopicmove/language/pt_preao/email/topic_moved.txt" "[FORUM_EXT]/leinad4mind\\specialtopicmove/language/pt_preao/email/topic_moved.txt"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/leinad4mind\\specialtopicmove/language/pt_preao/email/topic_moved.txt"
@@ -0,0 +1,17 @@
+Subject: Tópico movido - "{{ TOPIC_TITLE }}"
+
+Olá, {{ USERNAME }},
+
+
+Estás a receber esta notificação para avisar de que o teu tópico "{{ TOPIC_TITLE }}" foi movido por "{{ TOPIC_MOVER }}" para "{{ FORUM_NAME }}".
+{% if REASON %}
+Motivo:
+
+{{ REASON }}
+{% endif %}
+
+Caso não desejes receber mais e-mails relacionados com tópicos movidos, por favor, corrige as tuas notificações aqui:
+
+{{ U_NOTIFICATION_SETTINGS }}
+
+{{ EMAIL_SIG }}
diff --git "[ORIGINAL]/leinad4mind\\specialtopicmove/notification/topic_moved.php" "[FORUM_EXT]/leinad4mind\\specialtopicmove/notification/topic_moved.php"
--- "[ORIGINAL]/leinad4mind\\specialtopicmove/notification/topic_moved.php"
+++ "[FORUM_EXT]/leinad4mind\\specialtopicmove/notification/topic_moved.php"
@@ -111,7 +111,7 @@ class topic_moved extends base
 			't' => $this->get_data('topic_id'),
 		];
 
-		$script_php = 'viewtopic' . $this->php_ext;
+		$script_php = 'viewtopic.' . $this->php_ext;
 
 		if ($reference_type == UrlGeneratorInterface::ABSOLUTE_URL)
 		{
@@ -165,7 +165,7 @@ class topic_moved extends base
 		}
 
 		$topic_id = $this->get_data('topic_id');
-		$topic_data = phpbb_get_topic_data([$topic_id], 'f_list');
+		$topic_data = phpbb_get_topic_data([$topic_id], false);
 		return isset($topic_data[$topic_id]) ? $topic_data[$topic_id]['topic_title'] : '';
 	}
 
@@ -183,7 +183,7 @@ class topic_moved extends base
 		}
 
 		$forum_id = $this->get_data('forum_id');
-		$forum_info = phpbb_get_forum_data([$forum_id]);
+		$forum_info = phpbb_get_forum_data([$forum_id], false);
 		return isset($forum_info[$forum_id]) ? $forum_info[$forum_id]['forum_name'] : '';
 	}
 }
diff --git "[FORUM_EXT]/leinad4mind\\specialtopicmove/styles/FLATBOOTS/template/event/mcp_move_destination_forum_before.html" "[FORUM_EXT]/leinad4mind\\specialtopicmove/styles/FLATBOOTS/template/event/mcp_move_destination_forum_before.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/leinad4mind\\specialtopicmove/styles/FLATBOOTS/template/event/mcp_move_destination_forum_before.html"
@@ -0,0 +1,3 @@
+{% if TOPIC_MOVED_MODE == 'reason' %}
+	{% include '@leinad4mind_specialtopicmove/special_topic_move_reason.html' %}
+{% endif %}
diff --git "[FORUM_EXT]/leinad4mind\\specialtopicmove/styles/FLATBOOTS/template/event/mcp_topic_postrow_attachments_after.html" "[FORUM_EXT]/leinad4mind\\specialtopicmove/styles/FLATBOOTS/template/event/mcp_topic_postrow_attachments_after.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/leinad4mind\\specialtopicmove/styles/FLATBOOTS/template/event/mcp_topic_postrow_attachments_after.html"
@@ -0,0 +1,3 @@
+{% if postrow.TOPIC_MOVED_MODE == 'topic' %}
+	{% include '@leinad4mind_specialtopicmove/special_topic_move_topic.html' %}
+{% endif %}
diff --git "[FORUM_EXT]/leinad4mind\\specialtopicmove/styles/FLATBOOTS/template/event/topiclist_row_topic_by_author_before.html" "[FORUM_EXT]/leinad4mind\\specialtopicmove/styles/FLATBOOTS/template/event/topiclist_row_topic_by_author_before.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/leinad4mind\\specialtopicmove/styles/FLATBOOTS/template/event/topiclist_row_topic_by_author_before.html"
@@ -0,0 +1,3 @@
+{% if topicrow.TOPIC_MOVED_MODE == 'forum' %}
+	{% include '@leinad4mind_specialtopicmove/special_topic_move_forum.html' %}
+{% endif %}
diff --git "[FORUM_EXT]/leinad4mind\\specialtopicmove/styles/FLATBOOTS/template/event/viewtopic_body_postrow_post_notices_after.html" "[FORUM_EXT]/leinad4mind\\specialtopicmove/styles/FLATBOOTS/template/event/viewtopic_body_postrow_post_notices_after.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/leinad4mind\\specialtopicmove/styles/FLATBOOTS/template/event/viewtopic_body_postrow_post_notices_after.html"
@@ -0,0 +1,3 @@
+{% if postrow.TOPIC_MOVED_MODE == 'topic' %}
+	{% include '@leinad4mind_specialtopicmove/special_topic_move_topic.html' %}
+{% endif %}
diff --git "[FORUM_EXT]/leinad4mind\\specialtopicmove/styles/FLATBOOTS/template/special_topic_move_forum.html" "[FORUM_EXT]/leinad4mind\\specialtopicmove/styles/FLATBOOTS/template/special_topic_move_forum.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/leinad4mind\\specialtopicmove/styles/FLATBOOTS/template/special_topic_move_forum.html"
@@ -0,0 +1,8 @@
+<span>
+	{{ topicrow.TOPIC_MOVED_MESSAGE }} {{ topicrow.TOPIC_MOVED_TO }} {{ topicrow.TOPIC_MOVED_ON }}
+	{% if topicrow.TOPIC_MOVED_REASON %}
+		<br>
+		<span><strong>{{ lang('REASON') ~ lang('COLON') }}</strong> <em>{{ topicrow.TOPIC_MOVED_REASON }}</em></span>
+	{% endif %}
+	<br>
+</span>
diff --git "[FORUM_EXT]/leinad4mind\\specialtopicmove/styles/FLATBOOTS/template/special_topic_move_reason.html" "[FORUM_EXT]/leinad4mind\\specialtopicmove/styles/FLATBOOTS/template/special_topic_move_reason.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/leinad4mind\\specialtopicmove/styles/FLATBOOTS/template/special_topic_move_reason.html"
@@ -0,0 +1,4 @@
+<dl class="fields2">
+	<dt><label for="moved_reason">{{ lang('SPECIAL_TOPIC_MOVE_ENTER_REASON', SPECIAL_TOPIC_MOVE_TOPIC_COUNT) ~ lang('COLON') }}</label></dt>
+	<dd><input type="text" class="inputbox autowidth" name="moved_reason" id="moved_reason" size="50" maxlength="100" value=""></dd>
+</dl>
diff --git "[FORUM_EXT]/leinad4mind\\specialtopicmove/styles/FLATBOOTS/template/special_topic_move_topic.html" "[FORUM_EXT]/leinad4mind\\specialtopicmove/styles/FLATBOOTS/template/special_topic_move_topic.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/leinad4mind\\specialtopicmove/styles/FLATBOOTS/template/special_topic_move_topic.html"
@@ -0,0 +1,7 @@
+<div class="notice text-muted">
+	<small>{{ postrow.TOPIC_MOVED_MESSAGE }} {{ postrow.TOPIC_MOVED_FROM }} {{ postrow.TOPIC_MOVED_BY }} {{ postrow.TOPIC_MOVED_ON }} {{ postrow.TOPIC_MOVED_UNDO }}</small>
+	{% if postrow.TOPIC_MOVED_REASON %}
+		<br>
+		<small><strong>{{ lang('REASON') ~ lang('COLON') }}</strong> <em>{{ postrow.TOPIC_MOVED_REASON }}</em></small>
+	{% endif %}
+</div>
```
