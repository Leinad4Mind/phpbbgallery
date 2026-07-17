Existem diferencas reais no codigo ou texto. Diferencas de formatacao (espacos, tabs) foram ignoradas abaixo.

```diff
diff --git "[FORUM_EXT]/dmzx\\whovisitedthistopic/diff_full.tmp" "[FORUM_EXT]/dmzx\\whovisitedthistopic/diff_full.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/dmzx\\whovisitedthistopic/diff_full.tmp"
@@ -0,0 +1,503 @@
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\whovisitedthistopic/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\whovisitedthistopic/diff_full.tmp"
+new file mode 100644
+index 000000000..e69de29bb
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\whovisitedthistopic/event/listener.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\whovisitedthistopic/event/listener.php"
+index 7ab838766..b8fa67f2c 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\whovisitedthistopic/event/listener.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\whovisitedthistopic/event/listener.php"
+@@ -145,55 +145,21 @@ class listener implements EventSubscriberInterface
+ 		// Add lang file
+ 		$this->user->add_lang_ext('dmzx/whovisitedthistopic', 'common');
+ 
+-		$topic_id = $event['topic_id'];
+-		$user_id = $this->user->data['user_id'];
+-		$value = $this->config['whovisitedthistopic_value'];
++		$topic_id = (int) $event['topic_id'];
++		$user_id = (int) $this->user->data['user_id'];
++		$value = (int) $this->config['whovisitedthistopic_value'];
+ 
+-		if (($this->user->data['user_id'] != ANONYMOUS) && (!$this->user->data['is_bot']) && $this->config['whovisitedthistopic_allow_topics'])
++		if ($user_id !== ANONYMOUS && !$this->user->data['is_bot'] && $this->config['whovisitedthistopic_allow_topics'])
+ 		{
+-			// Get the excluded members arrays
+-			$whovisitedthistopic_members = json_decode($this->config['whovisitedthistopic_members']);
+-
+-			$sql = 'SELECT *
+-				FROM ' . $this->whovisitedthistopic_table . '
+-				WHERE user_id = ' . (int) $user_id . '
+-					AND topic_id = ' . (int) $topic_id;
+-			$result = $this->db->sql_query($sql);
+-
+-			if ($row = $this->db->sql_fetchrow($result))
+-			{
+-				$counter_user = $row['counter_user'] + 1;
+-				$date = time();
+-				$sql_arr = [
+-					'counter_user'	=> (int) $counter_user,
+-					'date'			=> $date
+-				];
+-
+-				$sql_insert = 'UPDATE ' . $this->whovisitedthistopic_table . '
+-					SET	' . $this->db->sql_build_array('UPDATE', $sql_arr) . '
+-					WHERE user_id = ' . (int) $user_id . '
+-						AND topic_id = ' . (int) $topic_id;
+-
+-					if (!empty($whovisitedthistopic_members))
+-					{
+-						$sql_insert .= ' AND ' . $this->db->sql_in_set('user_id', $whovisitedthistopic_members, true);
+-					}
+-				$this->db->sql_query($sql_insert);
+-			}
+-			else
+-			{
+-				$date = time();
+-				$sql_arr = [
+-					'counter_user'	=> 1,
+-					'user_id'		=> (int) $user_id,
+-					'topic_id'		=> (int) $topic_id,
+-					'date'			=> $date
+-				];
+-
+-				$sql_insert = 'INSERT INTO ' . $this->whovisitedthistopic_table . ' ' . $this->db->sql_build_array('INSERT', $sql_arr);
+-				$this->db->sql_query($sql_insert);
+-			}
+-			$this->db->sql_freeresult($result);
++			$date = time();
++
++			// Usa INSERT ON DUPLICATE KEY UPDATE
++			$sql = 'INSERT INTO ' . $this->whovisitedthistopic_table . ' (user_id, topic_id, counter_user, date)
++				VALUES (' . $user_id . ', ' . $topic_id . ', 1, ' . $date . ')
++				ON DUPLICATE KEY UPDATE
++					counter_user = counter_user + 1,
++					date = ' . $date;
++			$this->db->sql_query($sql);
+ 		}
+ 
+ 		if ($this->auth->acl_get('u_whovisitedthistopic') && $this->config['whovisitedthistopic_allow_topics'])
+@@ -201,53 +167,44 @@ class listener implements EventSubscriberInterface
+ 			// Get the excluded members arrays
+ 			$whovisitedthistopic_members = json_decode($this->config['whovisitedthistopic_members']);
+ 
+-			$query = 'SELECT w.user_id, w.topic_id, w.counter_user, w.date, u.username, u.user_colour, u.user_id, u.user_avatar, u.user_avatar_type, u.user_avatar_height, u.user_avatar_width, u.user_type, SUM(w.counter_user) AS total
++			$query = 'SELECT w.user_id, u.username, u.user_colour, u.user_id, u.user_avatar, u.user_avatar_type, u.user_avatar_height, u.user_avatar_width, u.user_type, MAX(w.date) AS last_visit, SUM(w.counter_user) AS total
+ 				FROM ' . $this->whovisitedthistopic_table . ' w, ' . USERS_TABLE . ' u
+-				WHERE w.topic_id = ' . (int) $topic_id . '
+-					AND w.user_id = u.user_id';
++				WHERE w.topic_id = ' . $topic_id . '
++				AND w.user_id = u.user_id';
+ 
+ 			if (!empty($whovisitedthistopic_members))
+ 			{
+ 				$query .= ' AND ' . $this->db->sql_in_set('w.user_id', $whovisitedthistopic_members, true);
+ 			}
+ 
+-			$query .= ' GROUP BY w.user_id';
+-			$query .= ' ORDER BY w.date DESC';
++			$query .= ' GROUP BY w.user_id
++						ORDER BY last_visit DESC';
++
+ 			$row_query = $this->db->sql_query_limit($query, $value);
+ 
+ 			while ($row = $this->db->sql_fetchrow($row_query))
+ 			{
+-				$username = $row['username'];
+-				$user_colour = ($row['user_colour']) ? ' style="color:#' . $row['user_colour'] . '" class="username-coloured"' : '';
+-				$user_id = $row['user_id'];
+-				$date = ($row['date']) ? ' title="' . $this->user->format_date($row['date']) . '" ': '';
+ 				$avatar = phpbb_get_user_avatar($row);
+-
+-				if ($this->auth->acl_get('u_whovisitedthistopic_count'))
+-				{
+-					$visits = (int) $row['total'];
+-				}
+-				else
+-				{
+-					$visits = null;
+-				}
+-
+-				$url = append_sid("{$this->root_path}memberlist.{$this->phpEx}?mode=viewprofile&amp;u={$user_id}");
++				$user_colour = ($row['user_colour']) ? ' style="color:#' . $row['user_colour'] . '" class="username-coloured"' : '';
++				$visits = $this->auth->acl_get('u_whovisitedthistopic_count') ? (int) $row['total'] : null;
++				$date = $row['last_visit'] ? ' title="' . $this->user->format_date($row['last_visit']) . '" ' : '';
++				$url = append_sid("{$this->root_path}memberlist.{$this->phpEx}?mode=viewprofile&amp;u={$row['user_id']}");
+ 
+ 				$this->template->assign_block_vars('whovisitedthistopic', [
+-					'USERNAME'			=> $username,
++					'USERNAME'			=> $row['username'],
+ 					'USERNAME_COLOUR'	=> $user_colour,
+ 					'VISITS'			=> $visits,
+ 					'URL'				=> $url,
+-					'AVATAR'			=> empty($avatar) ? '<img src="' . $this->root_path . 'styles/prosilver/theme/images/no_avatar.gif" width="60px;" height="60px;" alt="" />' : $avatar,
++					'AVATAR'			=> empty($avatar) ? '<img class="img-thumbnail avatar" src="' . $this->root_path . 'styles/FLATBOOTS/theme/images/no-avatar.png" width="60px;" height="60px;" alt="" />' : $avatar,
+ 					'DATE'				=> $date
+ 				]);
+ 			}
+ 			$this->db->sql_freeresult($row_query);
+ 
++			// Total
+ 			$sql = 'SELECT topic_id, SUM(counter_user) AS counter
+ 				FROM ' . $this->whovisitedthistopic_table . '
+-				WHERE topic_id = ' . (int) $topic_id;
++				WHERE topic_id = ' . $topic_id;
+ 			$result = $this->db->sql_query($sql);
+ 			$counter = (int) $this->db->sql_fetchfield('counter');
+ 			$this->db->sql_freeresult($result);
+@@ -272,27 +229,27 @@ class listener implements EventSubscriberInterface
+ 
+ 		if ($this->auth->acl_get('u_whovisitedthistopic_profile') && $this->config['whovisitedthistopic_allow_memberpage'])
+ 		{
+-			// Get the excluded members arrays
+-			$whovisitedthistopic_members_profile = json_decode($this->config['whovisitedthistopic_members_profile']);
+-
+ 			$sql_list = [
+-				'SELECT'	=> 'ft.*, tt.*, wt.*',
+-				'FROM'		=> [
+-					FORUMS_TABLE	=> 'ft',
+-					TOPICS_TABLE	=> 'tt',
+-					$this->whovisitedthistopic_table	=> 'wt',
++				'SELECT'	=> 'ft.forum_id, ft.forum_name,
++								tt.*,
++								wt.date',
++				'FROM' => [
++					$this->whovisitedthistopic_table => 'wt',
++				],
++				'LEFT_JOIN' => [
++					['FROM' => [TOPICS_TABLE => 'tt'], 'ON' => 'wt.topic_id = tt.topic_id'],
++					['FROM' => [FORUMS_TABLE => 'ft'], 'ON' => 'ft.forum_id = tt.forum_id'],
+ 				],
+ 				'WHERE' => 'tt.topic_moved_id = 0
+ 					AND tt.topic_visibility = 1
+-					AND wt.user_id = ' . (int) $user_id . '
+-					AND wt.topic_id = tt.topic_id
+-					AND ft.forum_id = tt.forum_id',
++					AND wt.user_id = ' . (int) $user_id,
+ 				'ORDER_BY'	=> 'wt.date DESC',
+ 			];
+ 
+-			if (!empty($whovisitedthistopic_members_profile))
+-			{
+-				$sql_list['WHERE'] .= ' AND ' . $this->db->sql_in_set('wt.user_id', $whovisitedthistopic_members_profile, true);
++			// Get the excluded members arrays
++			$excluded_ids = json_decode($this->config['whovisitedthistopic_members_profile'], true);
++			if (is_array($excluded_ids) && !empty($excluded_ids)) {
++				$sql_list['WHERE'] .= ' AND ' . $this->db->sql_in_set('wt.user_id', $excluded_ids, true);
+ 			}
+ 
+ 			if ($this->user->data['is_registered'] && $this->config['load_db_lastread'])
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\whovisitedthistopic/language/pt/common.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\whovisitedthistopic/language/pt/common.php"
+new file mode 100644
+index 000000000..1891dbdd3
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\whovisitedthistopic/language/pt/common.php"
+@@ -0,0 +1,42 @@
++<?php
++/**
++*
++* @package phpBB Extension - Who Visited This Topic
++* @copyright (c) 2016 dmzx - https://www.dmzx-web.net
++* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
++*
++*/
++
++/**
++* DO NOT CHANGE
++*/
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
++// ’ « » “ ” …
++//
++
++$lang = array_merge($lang, [
++	'WHOVISITEDTHISTOPIC_TITLE'			=> 'Últimos <strong>%d</strong> Membros que visitaram este Tópico. De um total de <strong>%d</strong> visitas',
++	'WHOVISITEDTHISTOPIC_VISIT_TITLE'	=> 'Últimos <strong>%d</strong> tópicos visitados',
++]);
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\whovisitedthistopic/language/pt/info_acp_whovisitedthistopic.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\whovisitedthistopic/language/pt/info_acp_whovisitedthistopic.php"
+new file mode 100644
+index 000000000..086e73130
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\whovisitedthistopic/language/pt/info_acp_whovisitedthistopic.php"
+@@ -0,0 +1,45 @@
++<?php
++/**
++*
++* @package phpBB Extension - Who Visited This Topic
++* @copyright (c) 2016 dmzx - https://www.dmzx-web.net
++* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
++*
++*/
++
++/**
++* DO NOT CHANGE
++*/
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
++// ’ « » “ ” …
++//
++
++$lang = array_merge($lang, [
++	'ACP_WHOVISITEDTHISTOPIC_TITLE'				=> 'Quem Visitou Este Tópico',
++	'ACP_WHOVISITEDTHISTOPIC_SETTINGS'			=> 'Configurações',
++	'ACP_WHOVISITEDTHISTOPIC_OPTIONS_SAVED'		=> 'As opções de Quem Visitou Este Tópico foram guardadas com sucesso.',
++	// Log entries
++	'LOG_WHOVISITEDTHISTOPIC_UPDATE'			=> '<strong>Configurações de Quem Visitou Este Tópico guardadas com sucesso</strong>',
++]);
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\whovisitedthistopic/language/pt/permissions_whovisitedthistopic.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\whovisitedthistopic/language/pt/permissions_whovisitedthistopic.php"
+new file mode 100644
+index 000000000..a9d5aee52
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\whovisitedthistopic/language/pt/permissions_whovisitedthistopic.php"
+@@ -0,0 +1,44 @@
++<?php
++
++/**
++ *
++ * @package phpBB Extension - Who Visited This Topic
++ * @copyright (c) 2016 dmzx - https://www.dmzx-web.net
++ * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
++ *
++ */
++
++/**
++ * DO NOT CHANGE
++ */
++if (!defined('IN_PHPBB')) {
++	exit;
++}
++
++if (empty($lang) || !is_array($lang)) {
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
++// ’ « » “ ” …
++//
++
++$lang = array_merge($lang, [
++	'WHOVISITEDTHISTOPIC_INDEX'					=> 'Quem Visitou Este Tópico',
++	'ACL_U_WHOVISITEDTHISTOPIC'					=> 'Pode ver Quem Visitou Este Tópico nos tópicos',
++	'ACL_U_WHOVISITEDTHISTOPIC_COUNT'			=> 'Pode ver contador de Quem Visitou Este Tópico nos tópicos',
++	'ACL_U_WHOVISITEDTHISTOPIC_PROFILE'			=> 'Pode ver Quem Visitou Este Tópico no perfil',
++	'ACL_U_WHOVISITEDTHISTOPIC_SHOW_AVATAR'		=> 'Pode ver avatar de Quem Visitou Este Tópico nos tópicos',
++]);
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\whovisitedthistopic/language/pt/whovisitedthistopic_acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\whovisitedthistopic/language/pt/whovisitedthistopic_acp.php"
+new file mode 100644
+index 000000000..b7caa2c93
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\whovisitedthistopic/language/pt/whovisitedthistopic_acp.php"
+@@ -0,0 +1,59 @@
++<?php
++/**
++*
++* @package phpBB Extension - Who Visited This Topic
++* @copyright (c) 2016 dmzx - https://www.dmzx-web.net
++* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
++*
++*/
++
++/**
++* DO NOT CHANGE
++*/
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
++// ’ « » “ ” …
++//
++
++$lang = array_merge($lang, [
++	'WHOVISITEDTHISTOPIC_TOPIC_SETTINGS'				=> 'Enable Who Visited This Topic in topics',
++	'WHOVISITEDTHISTOPIC_TOPIC_SETTINGS_EXPLAIN'		=> 'This will show the Who Visited This Topic in viewtopics.',
++	'WHOVISITEDTHISTOPIC_COUNT_SETTINGS'				=> 'Enable Who Visited This Topic counter topics',
++	'WHOVISITEDTHISTOPIC_COUNT_SETTINGS_EXPLAIN'		=> 'This will show the Who Visited This Topic counter in topics.',
++	'WHOVISITEDTHISTOPIC_SHOW_AVATAR'					=> 'Enable Who Visited This Topic avatars in topics',
++	'WHOVISITEDTHISTOPIC_SHOW_AVATAR_EXPLAIN'			=> 'This will show the Who Visited This Topic avatars in topics.',
++	'WHOVISITEDTHISTOPIC_MEMBERPAGE_SETTINGS'			=> 'Enable Who Visited This Topic in profile',
++	'WHOVISITEDTHISTOPIC_MEMBERPAGE_SETTINGS_EXPLAIN'	=> 'This will show the Who Visited This Topic in profile.',
++	'WHOVISITEDTHISTOPIC_SETTING'						=> 'Set value for Who Visited This Topic in topics',
++	'WHOVISITEDTHISTOPIC_SETTING_EXPLAIN'				=> 'Value adjustable from 2 till 255 members. <em>Default is 10.</em>',
++	'WHOVISITEDTHISTOPIC_VISIT_SETTING'					=> 'Set value for Last Topics Visited in profile',
++	'WHOVISITEDTHISTOPIC_VISIT_SETTING_EXPLAIN'			=> 'Value adjustable from 2 till 255. <em>Default is 10.</em>',
++	'WHOVISITEDTHISTOPIC_DISABLED_TOPIC'				=> 'Disabled set “Enable Who Visited This Topic in topics” to Yes to enter value',
++	'WHOVISITEDTHISTOPIC_DISABLED_MEMBERPAGE'			=> 'Disabled set “Enable Who Visited This Topic in profile” to Yes to enter value',
++	'WHOVISITEDTHISTOPIC_SETTINGS_EXPLAIN'				=> 'Go to the <em><strong>Who Visited This Topic</strong></em> tab in Group permissions section to adjust permissions for each group.',
++	'WHOVISITEDTHISTOPIC_MEMBERS'						=> 'Exclude members in viewtopic',
++	'WHOVISITEDTHISTOPIC_MEMBERS_EXPLAIN'				=> 'Here you can manage the users that you want to exclude (don’t see them) or remove them from the exclude list.<br><strong>Note:</strong> Each user in a new line.',
++	'WHOVISITEDTHISTOPIC_MEMBERS_PROFILE'				=> 'Exclude members in profile view',
++	'WHOVISITEDTHISTOPIC_MEMBERS_PROFILE_EXPLAIN'		=> 'Here you can manage the users that you want to exclude (don’t see them) or remove them from the exclude list.<br><strong>Note:</strong> Each user in a new line.',
++]);
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\whovisitedthistopic/styles/FLATBOOTS/template/event/memberlist_view_contact_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\whovisitedthistopic/styles/FLATBOOTS/template/event/memberlist_view_contact_after.html"
+new file mode 100644
+index 000000000..218108471
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\whovisitedthistopic/styles/FLATBOOTS/template/event/memberlist_view_contact_after.html"
+@@ -0,0 +1,73 @@
++{% if PERMISSION_PROFILE and loops.whovisitedthistopic|length %}
++<div class="panel panel-forum">
++	<div class="panel-heading">
++		{{ WHOVISITEDTHISTOPIC_VISIT_TITLE }}
++	</div>
++	<div class="panel-inner">
++		<table class="footable table table-striped table-primary table-hover">
++			<thead>
++				<tr>
++				<th data-class="expand">{{ lang('TOPICS') }}</th>
++				<th class="posts" data-hide="phone">{{ lang('REPLIES') }}</th>
++				<th class="views" data-hide="phone">{{ lang('VIEWS') }}</th>
++				<th class="lastpost" data-hide="phone">{{ lang('LAST_POST') }}</th>
++				</tr>
++			</thead>
++			<tbody>
++				{% for whovisitedthistopic in loops.whovisitedthistopic %}
++				<tr id="forum-{forumrow.FORUM_ID}" class="topiclist topics">
++						<td title="{forumrow.FORUM_FOLDER_IMG_ALT}">
++							{% if whovisitedthistopic.S_UNREAD_TOPIC and not S_IS_BOT %}
++									<a href="{{ whovisitedthistopic.U_NEWEST_POST }}">
++										<i class="icon fa-file fa-fw icon-red icon-md" aria-hidden="true"></i><span class="sr-only">{{ NEW_POST }}</span>
++									</a>
++									{% endif %}
++									<a href="{{ whovisitedthistopic.U_VIEW_TOPIC }}" class="topictitle">{{ whovisitedthistopic.TOPIC_TITLE }}</a>
++									{% if whovisitedthistopic.S_TOPIC_UNAPPROVED or whovisitedthistopic.S_POSTS_UNAPPROVED %}
++									<a href="{{ whovisitedthistopic.U_MCP_QUEUE }}">
++										<i class="icon fa-question fa-fw icon-blue" aria-hidden="true"></i><span class="sr-only">{{ TOPIC_UNAPPROVED }}</span>
++									</a>
++									{% endif %}
++									{% if whovisitedthistopic.S_TOPIC_REPORTED %}
++									<a href="{{ whovisitedthistopic.U_MCP_REPORT }}">
++										<i class="icon fa-exclamation fa-fw icon-red" aria-hidden="true"></i><span class="sr-only">{{ TOPIC_REPORTED }}</span>
++									</a>
++									{% endif %}
++									<br>
++
++									{% if not S_IS_BOT %}
++									<div class="responsive-show" style="display: none;">
++										{{ lang('LAST_POST') }} {{ lang('POST_BY_AUTHOR') }} {{ whovisitedthistopic.LAST_POST_AUTHOR_FULL }} &laquo; <a href="{{ whovisitedthistopic.U_LAST_POST }}" title="{{ lang('GOTO_LAST_POST') }}">{{ whovisitedthistopic.LAST_POST_TIME }}</a>
++										<br>{{ lang('POSTED') }} {{ lang('IN') }} <a href="{{ whovisitedthistopic.U_VIEW_FORUM }}">{{ whovisitedthistopic.FORUM_TITLE }}</a>
++									</div>
++										{% if whovisitedthistopic.TOPIC_REPLIES %}
++										<span class="responsive-show left-box" style="display: none;">{{ lang('REPLIES') ~ lang('COLON') }} <strong>{{ whovisitedthistopic.TOPIC_REPLIES }}</strong></span>
++										{% endif %}
++									{% endif %}
++
++									<div class="topic-poster responsive-hide left-box">
++										{% if whovisitedthistopic.S_HAS_POLL %}<i class="icon fa-bar-chart fa-fw" aria-hidden="true"></i>{% endif %}
++										{% if whovisitedthistopic.ATTACH_ICON_IMG %}<i class="icon fa-paperclip fa-fw" aria-hidden="true"></i>{% endif %}
++										{{ lang('POST_BY_AUTHOR') }} {{ whovisitedthistopic.TOPIC_AUTHOR_FULL }} &raquo; {{ whovisitedthistopic.FIRST_POST_TIME }} &raquo; {{ lang('IN') }} <a href="{{ whovisitedthistopic.U_VIEW_FORUM }}">{{ whovisitedthistopic.FORUM_TITLE }}</a>
++									</div>
++						</td>
++						<td class="posts">
++							{{ whovisitedthistopic.TOPIC_REPLIES }} <small>{{ lang('REPLIES') }}</small></td>
++						<td class="views">
++							{{ whovisitedthistopic.TOPIC_VIEWS }} <small>{{ lang('VIEWS') }}</small>
++						</td>	
++						<td class="lastpost">
++							<span><small>{{ lang('LAST_POST') }} </small>{{ lang('POST_BY_AUTHOR') }} {{ whovisitedthistopic.LAST_POST_AUTHOR_FULL }}
++									{% if not S_IS_BOT %}
++									<a href="{{ whovisitedthistopic.U_LAST_POST }}" title="{{ lang('GOTO_LAST_POST') }}"><i class="icon fa fa-external-link-square " aria-hidden="true"></i><span class="sr-only">{{ VIEW_LATEST_POST }}</span></a>
++									{% endif %}
++									<br>{{ whovisitedthistopic.LAST_POST_TIME }}
++								</span>
++						</td>
++					</tr>
++					{% endfor %}
++			</tbody>
++		</table>
++	</div>
++</div>
++{% endif %}
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\whovisitedthistopic/styles/FLATBOOTS/template/event/viewtopic_body_footer_before.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\whovisitedthistopic/styles/FLATBOOTS/template/event/viewtopic_body_footer_before.html"
+new file mode 100644
+index 000000000..026368fc6
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\whovisitedthistopic/styles/FLATBOOTS/template/event/viewtopic_body_footer_before.html"
+@@ -0,0 +1,18 @@
++{% if PERMISSION_VIEW %}
++	{% if whovisitedthistopic %}
++		<div class="row">
++			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
++				<div class="panel panel-forum panel-whois">
++					<div class="panel-heading"><i class="fa fa-user"></i>&nbsp;{{ WHOVISITEDTHISTOPIC_TITLE }}</div>
++					<div class="panel-body">
++						<p>
++							{% for whovisitedthistopic in loops.whovisitedthistopic %}
++								{% if PERMISSION_SHOW_AVATAR %}<span class="whovisitedthistopic-avatar">{{ whovisitedthistopic.AVATAR }}</span>{% endif %} <span><a href="{{ whovisitedthistopic.URL }}" {{ whovisitedthistopic.DATE }} {{ whovisitedthistopic.USERNAME_COLOUR }}>{{ whovisitedthistopic.USERNAME }}</a></span>{% if PERMISSION_COUNT %} ({{ whovisitedthistopic.VISITS }}){% endif %}{% if not whovisitedthistopic.S_LAST_ROW %}, {% endif %}
++							{% endfor %}
++						</p>
++					</div>
++				</div>
++			</div>
++		</div>
++	{% endif %}
++{% endif %}
diff --git "[FORUM_EXT]/dmzx\\whovisitedthistopic/diff_nospace.tmp" "[FORUM_EXT]/dmzx\\whovisitedthistopic/diff_nospace.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/dmzx\\whovisitedthistopic/diff_nospace.tmp"
@@ -0,0 +1,496 @@
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\whovisitedthistopic/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\whovisitedthistopic/diff_full.tmp"
+new file mode 100644
+index 000000000..59e31d571
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\whovisitedthistopic/diff_full.tmp"
+@@ -0,0 +1,503 @@
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\whovisitedthistopic/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\whovisitedthistopic/diff_full.tmp"
++new file mode 100644
++index 000000000..e69de29bb
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\whovisitedthistopic/event/listener.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\whovisitedthistopic/event/listener.php"
++index 7ab838766..b8fa67f2c 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\dmzx\\whovisitedthistopic/event/listener.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\whovisitedthistopic/event/listener.php"
++@@ -145,55 +145,21 @@ class listener implements EventSubscriberInterface
++ 		// Add lang file
++ 		$this->user->add_lang_ext('dmzx/whovisitedthistopic', 'common');
++ 
++-		$topic_id = $event['topic_id'];
++-		$user_id = $this->user->data['user_id'];
++-		$value = $this->config['whovisitedthistopic_value'];
+++		$topic_id = (int) $event['topic_id'];
+++		$user_id = (int) $this->user->data['user_id'];
+++		$value = (int) $this->config['whovisitedthistopic_value'];
++ 
++-		if (($this->user->data['user_id'] != ANONYMOUS) && (!$this->user->data['is_bot']) && $this->config['whovisitedthistopic_allow_topics'])
+++		if ($user_id !== ANONYMOUS && !$this->user->data['is_bot'] && $this->config['whovisitedthistopic_allow_topics'])
++ 		{
++-			// Get the excluded members arrays
++-			$whovisitedthistopic_members = json_decode($this->config['whovisitedthistopic_members']);
++-
++-			$sql = 'SELECT *
++-				FROM ' . $this->whovisitedthistopic_table . '
++-				WHERE user_id = ' . (int) $user_id . '
++-					AND topic_id = ' . (int) $topic_id;
++-			$result = $this->db->sql_query($sql);
++-
++-			if ($row = $this->db->sql_fetchrow($result))
++-			{
++-				$counter_user = $row['counter_user'] + 1;
++-				$date = time();
++-				$sql_arr = [
++-					'counter_user'	=> (int) $counter_user,
++-					'date'			=> $date
++-				];
++-
++-				$sql_insert = 'UPDATE ' . $this->whovisitedthistopic_table . '
++-					SET	' . $this->db->sql_build_array('UPDATE', $sql_arr) . '
++-					WHERE user_id = ' . (int) $user_id . '
++-						AND topic_id = ' . (int) $topic_id;
++-
++-					if (!empty($whovisitedthistopic_members))
++-					{
++-						$sql_insert .= ' AND ' . $this->db->sql_in_set('user_id', $whovisitedthistopic_members, true);
++-					}
++-				$this->db->sql_query($sql_insert);
++-			}
++-			else
++-			{
++-				$date = time();
++-				$sql_arr = [
++-					'counter_user'	=> 1,
++-					'user_id'		=> (int) $user_id,
++-					'topic_id'		=> (int) $topic_id,
++-					'date'			=> $date
++-				];
++-
++-				$sql_insert = 'INSERT INTO ' . $this->whovisitedthistopic_table . ' ' . $this->db->sql_build_array('INSERT', $sql_arr);
++-				$this->db->sql_query($sql_insert);
++-			}
++-			$this->db->sql_freeresult($result);
+++			$date = time();
+++
+++			// Usa INSERT ON DUPLICATE KEY UPDATE
+++			$sql = 'INSERT INTO ' . $this->whovisitedthistopic_table . ' (user_id, topic_id, counter_user, date)
+++				VALUES (' . $user_id . ', ' . $topic_id . ', 1, ' . $date . ')
+++				ON DUPLICATE KEY UPDATE
+++					counter_user = counter_user + 1,
+++					date = ' . $date;
+++			$this->db->sql_query($sql);
++ 		}
++ 
++ 		if ($this->auth->acl_get('u_whovisitedthistopic') && $this->config['whovisitedthistopic_allow_topics'])
++@@ -201,53 +167,44 @@ class listener implements EventSubscriberInterface
++ 			// Get the excluded members arrays
++ 			$whovisitedthistopic_members = json_decode($this->config['whovisitedthistopic_members']);
++ 
++-			$query = 'SELECT w.user_id, w.topic_id, w.counter_user, w.date, u.username, u.user_colour, u.user_id, u.user_avatar, u.user_avatar_type, u.user_avatar_height, u.user_avatar_width, u.user_type, SUM(w.counter_user) AS total
+++			$query = 'SELECT w.user_id, u.username, u.user_colour, u.user_id, u.user_avatar, u.user_avatar_type, u.user_avatar_height, u.user_avatar_width, u.user_type, MAX(w.date) AS last_visit, SUM(w.counter_user) AS total
++ 				FROM ' . $this->whovisitedthistopic_table . ' w, ' . USERS_TABLE . ' u
++-				WHERE w.topic_id = ' . (int) $topic_id . '
++-					AND w.user_id = u.user_id';
+++				WHERE w.topic_id = ' . $topic_id . '
+++				AND w.user_id = u.user_id';
++ 
++ 			if (!empty($whovisitedthistopic_members))
++ 			{
++ 				$query .= ' AND ' . $this->db->sql_in_set('w.user_id', $whovisitedthistopic_members, true);
++ 			}
++ 
++-			$query .= ' GROUP BY w.user_id';
++-			$query .= ' ORDER BY w.date DESC';
+++			$query .= ' GROUP BY w.user_id
+++						ORDER BY last_visit DESC';
+++
++ 			$row_query = $this->db->sql_query_limit($query, $value);
++ 
++ 			while ($row = $this->db->sql_fetchrow($row_query))
++ 			{
++-				$username = $row['username'];
++-				$user_colour = ($row['user_colour']) ? ' style="color:#' . $row['user_colour'] . '" class="username-coloured"' : '';
++-				$user_id = $row['user_id'];
++-				$date = ($row['date']) ? ' title="' . $this->user->format_date($row['date']) . '" ': '';
++ 				$avatar = phpbb_get_user_avatar($row);
++-
++-				if ($this->auth->acl_get('u_whovisitedthistopic_count'))
++-				{
++-					$visits = (int) $row['total'];
++-				}
++-				else
++-				{
++-					$visits = null;
++-				}
++-
++-				$url = append_sid("{$this->root_path}memberlist.{$this->phpEx}?mode=viewprofile&amp;u={$user_id}");
+++				$user_colour = ($row['user_colour']) ? ' style="color:#' . $row['user_colour'] . '" class="username-coloured"' : '';
+++				$visits = $this->auth->acl_get('u_whovisitedthistopic_count') ? (int) $row['total'] : null;
+++				$date = $row['last_visit'] ? ' title="' . $this->user->format_date($row['last_visit']) . '" ' : '';
+++				$url = append_sid("{$this->root_path}memberlist.{$this->phpEx}?mode=viewprofile&amp;u={$row['user_id']}");
++ 
++ 				$this->template->assign_block_vars('whovisitedthistopic', [
++-					'USERNAME'			=> $username,
+++					'USERNAME'			=> $row['username'],
++ 					'USERNAME_COLOUR'	=> $user_colour,
++ 					'VISITS'			=> $visits,
++ 					'URL'				=> $url,
++-					'AVATAR'			=> empty($avatar) ? '<img src="' . $this->root_path . 'styles/prosilver/theme/images/no_avatar.gif" width="60px;" height="60px;" alt="" />' : $avatar,
+++					'AVATAR'			=> empty($avatar) ? '<img class="img-thumbnail avatar" src="' . $this->root_path . 'styles/FLATBOOTS/theme/images/no-avatar.png" width="60px;" height="60px;" alt="" />' : $avatar,
++ 					'DATE'				=> $date
++ 				]);
++ 			}
++ 			$this->db->sql_freeresult($row_query);
++ 
+++			// Total
++ 			$sql = 'SELECT topic_id, SUM(counter_user) AS counter
++ 				FROM ' . $this->whovisitedthistopic_table . '
++-				WHERE topic_id = ' . (int) $topic_id;
+++				WHERE topic_id = ' . $topic_id;
++ 			$result = $this->db->sql_query($sql);
++ 			$counter = (int) $this->db->sql_fetchfield('counter');
++ 			$this->db->sql_freeresult($result);
++@@ -272,27 +229,27 @@ class listener implements EventSubscriberInterface
++ 
++ 		if ($this->auth->acl_get('u_whovisitedthistopic_profile') && $this->config['whovisitedthistopic_allow_memberpage'])
++ 		{
++-			// Get the excluded members arrays
++-			$whovisitedthistopic_members_profile = json_decode($this->config['whovisitedthistopic_members_profile']);
++-
++ 			$sql_list = [
++-				'SELECT'	=> 'ft.*, tt.*, wt.*',
++-				'FROM'		=> [
++-					FORUMS_TABLE	=> 'ft',
++-					TOPICS_TABLE	=> 'tt',
++-					$this->whovisitedthistopic_table	=> 'wt',
+++				'SELECT'	=> 'ft.forum_id, ft.forum_name,
+++								tt.*,
+++								wt.date',
+++				'FROM' => [
+++					$this->whovisitedthistopic_table => 'wt',
+++				],
+++				'LEFT_JOIN' => [
+++					['FROM' => [TOPICS_TABLE => 'tt'], 'ON' => 'wt.topic_id = tt.topic_id'],
+++					['FROM' => [FORUMS_TABLE => 'ft'], 'ON' => 'ft.forum_id = tt.forum_id'],
++ 				],
++ 				'WHERE' => 'tt.topic_moved_id = 0
++ 					AND tt.topic_visibility = 1
++-					AND wt.user_id = ' . (int) $user_id . '
++-					AND wt.topic_id = tt.topic_id
++-					AND ft.forum_id = tt.forum_id',
+++					AND wt.user_id = ' . (int) $user_id,
++ 				'ORDER_BY'	=> 'wt.date DESC',
++ 			];
++ 
++-			if (!empty($whovisitedthistopic_members_profile))
++-			{
++-				$sql_list['WHERE'] .= ' AND ' . $this->db->sql_in_set('wt.user_id', $whovisitedthistopic_members_profile, true);
+++			// Get the excluded members arrays
+++			$excluded_ids = json_decode($this->config['whovisitedthistopic_members_profile'], true);
+++			if (is_array($excluded_ids) && !empty($excluded_ids)) {
+++				$sql_list['WHERE'] .= ' AND ' . $this->db->sql_in_set('wt.user_id', $excluded_ids, true);
++ 			}
++ 
++ 			if ($this->user->data['is_registered'] && $this->config['load_db_lastread'])
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\whovisitedthistopic/language/pt/common.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\whovisitedthistopic/language/pt/common.php"
++new file mode 100644
++index 000000000..1891dbdd3
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\whovisitedthistopic/language/pt/common.php"
++@@ -0,0 +1,42 @@
+++<?php
+++/**
+++*
+++* @package phpBB Extension - Who Visited This Topic
+++* @copyright (c) 2016 dmzx - https://www.dmzx-web.net
+++* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+++*
+++*/
+++
+++/**
+++* DO NOT CHANGE
+++*/
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
+++// ’ « » “ ” …
+++//
+++
+++$lang = array_merge($lang, [
+++	'WHOVISITEDTHISTOPIC_TITLE'			=> 'Últimos <strong>%d</strong> Membros que visitaram este Tópico. De um total de <strong>%d</strong> visitas',
+++	'WHOVISITEDTHISTOPIC_VISIT_TITLE'	=> 'Últimos <strong>%d</strong> tópicos visitados',
+++]);
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\whovisitedthistopic/language/pt/info_acp_whovisitedthistopic.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\whovisitedthistopic/language/pt/info_acp_whovisitedthistopic.php"
++new file mode 100644
++index 000000000..086e73130
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\whovisitedthistopic/language/pt/info_acp_whovisitedthistopic.php"
++@@ -0,0 +1,45 @@
+++<?php
+++/**
+++*
+++* @package phpBB Extension - Who Visited This Topic
+++* @copyright (c) 2016 dmzx - https://www.dmzx-web.net
+++* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+++*
+++*/
+++
+++/**
+++* DO NOT CHANGE
+++*/
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
+++// ’ « » “ ” …
+++//
+++
+++$lang = array_merge($lang, [
+++	'ACP_WHOVISITEDTHISTOPIC_TITLE'				=> 'Quem Visitou Este Tópico',
+++	'ACP_WHOVISITEDTHISTOPIC_SETTINGS'			=> 'Configurações',
+++	'ACP_WHOVISITEDTHISTOPIC_OPTIONS_SAVED'		=> 'As opções de Quem Visitou Este Tópico foram guardadas com sucesso.',
+++	// Log entries
+++	'LOG_WHOVISITEDTHISTOPIC_UPDATE'			=> '<strong>Configurações de Quem Visitou Este Tópico guardadas com sucesso</strong>',
+++]);
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\whovisitedthistopic/language/pt/permissions_whovisitedthistopic.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\whovisitedthistopic/language/pt/permissions_whovisitedthistopic.php"
++new file mode 100644
++index 000000000..a9d5aee52
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\whovisitedthistopic/language/pt/permissions_whovisitedthistopic.php"
++@@ -0,0 +1,44 @@
+++<?php
+++
+++/**
+++ *
+++ * @package phpBB Extension - Who Visited This Topic
+++ * @copyright (c) 2016 dmzx - https://www.dmzx-web.net
+++ * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+++ *
+++ */
+++
+++/**
+++ * DO NOT CHANGE
+++ */
+++if (!defined('IN_PHPBB')) {
+++	exit;
+++}
+++
+++if (empty($lang) || !is_array($lang)) {
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
+++// ’ « » “ ” …
+++//
+++
+++$lang = array_merge($lang, [
+++	'WHOVISITEDTHISTOPIC_INDEX'					=> 'Quem Visitou Este Tópico',
+++	'ACL_U_WHOVISITEDTHISTOPIC'					=> 'Pode ver Quem Visitou Este Tópico nos tópicos',
+++	'ACL_U_WHOVISITEDTHISTOPIC_COUNT'			=> 'Pode ver contador de Quem Visitou Este Tópico nos tópicos',
+++	'ACL_U_WHOVISITEDTHISTOPIC_PROFILE'			=> 'Pode ver Quem Visitou Este Tópico no perfil',
+++	'ACL_U_WHOVISITEDTHISTOPIC_SHOW_AVATAR'		=> 'Pode ver avatar de Quem Visitou Este Tópico nos tópicos',
+++]);
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\whovisitedthistopic/language/pt/whovisitedthistopic_acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\whovisitedthistopic/language/pt/whovisitedthistopic_acp.php"
++new file mode 100644
++index 000000000..b7caa2c93
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\whovisitedthistopic/language/pt/whovisitedthistopic_acp.php"
++@@ -0,0 +1,59 @@
+++<?php
+++/**
+++*
+++* @package phpBB Extension - Who Visited This Topic
+++* @copyright (c) 2016 dmzx - https://www.dmzx-web.net
+++* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+++*
+++*/
+++
+++/**
+++* DO NOT CHANGE
+++*/
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
+++// ’ « » “ ” …
+++//
+++
+++$lang = array_merge($lang, [
+++	'WHOVISITEDTHISTOPIC_TOPIC_SETTINGS'				=> 'Enable Who Visited This Topic in topics',
+++	'WHOVISITEDTHISTOPIC_TOPIC_SETTINGS_EXPLAIN'		=> 'This will show the Who Visited This Topic in viewtopics.',
+++	'WHOVISITEDTHISTOPIC_COUNT_SETTINGS'				=> 'Enable Who Visited This Topic counter topics',
+++	'WHOVISITEDTHISTOPIC_COUNT_SETTINGS_EXPLAIN'		=> 'This will show the Who Visited This Topic counter in topics.',
+++	'WHOVISITEDTHISTOPIC_SHOW_AVATAR'					=> 'Enable Who Visited This Topic avatars in topics',
+++	'WHOVISITEDTHISTOPIC_SHOW_AVATAR_EXPLAIN'			=> 'This will show the Who Visited This Topic avatars in topics.',
+++	'WHOVISITEDTHISTOPIC_MEMBERPAGE_SETTINGS'			=> 'Enable Who Visited This Topic in profile',
+++	'WHOVISITEDTHISTOPIC_MEMBERPAGE_SETTINGS_EXPLAIN'	=> 'This will show the Who Visited This Topic in profile.',
+++	'WHOVISITEDTHISTOPIC_SETTING'						=> 'Set value for Who Visited This Topic in topics',
+++	'WHOVISITEDTHISTOPIC_SETTING_EXPLAIN'				=> 'Value adjustable from 2 till 255 members. <em>Default is 10.</em>',
+++	'WHOVISITEDTHISTOPIC_VISIT_SETTING'					=> 'Set value for Last Topics Visited in profile',
+++	'WHOVISITEDTHISTOPIC_VISIT_SETTING_EXPLAIN'			=> 'Value adjustable from 2 till 255. <em>Default is 10.</em>',
+++	'WHOVISITEDTHISTOPIC_DISABLED_TOPIC'				=> 'Disabled set “Enable Who Visited This Topic in topics” to Yes to enter value',
+++	'WHOVISITEDTHISTOPIC_DISABLED_MEMBERPAGE'			=> 'Disabled set “Enable Who Visited This Topic in profile” to Yes to enter value',
+++	'WHOVISITEDTHISTOPIC_SETTINGS_EXPLAIN'				=> 'Go to the <em><strong>Who Visited This Topic</strong></em> tab in Group permissions section to adjust permissions for each group.',
+++	'WHOVISITEDTHISTOPIC_MEMBERS'						=> 'Exclude members in viewtopic',
+++	'WHOVISITEDTHISTOPIC_MEMBERS_EXPLAIN'				=> 'Here you can manage the users that you want to exclude (don’t see them) or remove them from the exclude list.<br><strong>Note:</strong> Each user in a new line.',
+++	'WHOVISITEDTHISTOPIC_MEMBERS_PROFILE'				=> 'Exclude members in profile view',
+++	'WHOVISITEDTHISTOPIC_MEMBERS_PROFILE_EXPLAIN'		=> 'Here you can manage the users that you want to exclude (don’t see them) or remove them from the exclude list.<br><strong>Note:</strong> Each user in a new line.',
+++]);
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\whovisitedthistopic/styles/FLATBOOTS/template/event/memberlist_view_contact_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\whovisitedthistopic/styles/FLATBOOTS/template/event/memberlist_view_contact_after.html"
++new file mode 100644
++index 000000000..218108471
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\whovisitedthistopic/styles/FLATBOOTS/template/event/memberlist_view_contact_after.html"
++@@ -0,0 +1,73 @@
+++{% if PERMISSION_PROFILE and loops.whovisitedthistopic|length %}
+++<div class="panel panel-forum">
+++	<div class="panel-heading">
+++		{{ WHOVISITEDTHISTOPIC_VISIT_TITLE }}
+++	</div>
+++	<div class="panel-inner">
+++		<table class="footable table table-striped table-primary table-hover">
+++			<thead>
+++				<tr>
+++				<th data-class="expand">{{ lang('TOPICS') }}</th>
+++				<th class="posts" data-hide="phone">{{ lang('REPLIES') }}</th>
+++				<th class="views" data-hide="phone">{{ lang('VIEWS') }}</th>
+++				<th class="lastpost" data-hide="phone">{{ lang('LAST_POST') }}</th>
+++				</tr>
+++			</thead>
+++			<tbody>
+++				{% for whovisitedthistopic in loops.whovisitedthistopic %}
+++				<tr id="forum-{forumrow.FORUM_ID}" class="topiclist topics">
+++						<td title="{forumrow.FORUM_FOLDER_IMG_ALT}">
+++							{% if whovisitedthistopic.S_UNREAD_TOPIC and not S_IS_BOT %}
+++									<a href="{{ whovisitedthistopic.U_NEWEST_POST }}">
+++										<i class="icon fa-file fa-fw icon-red icon-md" aria-hidden="true"></i><span class="sr-only">{{ NEW_POST }}</span>
+++									</a>
+++									{% endif %}
+++									<a href="{{ whovisitedthistopic.U_VIEW_TOPIC }}" class="topictitle">{{ whovisitedthistopic.TOPIC_TITLE }}</a>
+++									{% if whovisitedthistopic.S_TOPIC_UNAPPROVED or whovisitedthistopic.S_POSTS_UNAPPROVED %}
+++									<a href="{{ whovisitedthistopic.U_MCP_QUEUE }}">
+++										<i class="icon fa-question fa-fw icon-blue" aria-hidden="true"></i><span class="sr-only">{{ TOPIC_UNAPPROVED }}</span>
+++									</a>
+++									{% endif %}
+++									{% if whovisitedthistopic.S_TOPIC_REPORTED %}
+++									<a href="{{ whovisitedthistopic.U_MCP_REPORT }}">
+++										<i class="icon fa-exclamation fa-fw icon-red" aria-hidden="true"></i><span class="sr-only">{{ TOPIC_REPORTED }}</span>
+++									</a>
+++									{% endif %}
+++									<br>
+++
+++									{% if not S_IS_BOT %}
+++									<div class="responsive-show" style="display: none;">
+++										{{ lang('LAST_POST') }} {{ lang('POST_BY_AUTHOR') }} {{ whovisitedthistopic.LAST_POST_AUTHOR_FULL }} &laquo; <a href="{{ whovisitedthistopic.U_LAST_POST }}" title="{{ lang('GOTO_LAST_POST') }}">{{ whovisitedthistopic.LAST_POST_TIME }}</a>
+++										<br>{{ lang('POSTED') }} {{ lang('IN') }} <a href="{{ whovisitedthistopic.U_VIEW_FORUM }}">{{ whovisitedthistopic.FORUM_TITLE }}</a>
+++									</div>
+++										{% if whovisitedthistopic.TOPIC_REPLIES %}
+++										<span class="responsive-show left-box" style="display: none;">{{ lang('REPLIES') ~ lang('COLON') }} <strong>{{ whovisitedthistopic.TOPIC_REPLIES }}</strong></span>
+++										{% endif %}
+++									{% endif %}
+++
+++									<div class="topic-poster responsive-hide left-box">
+++										{% if whovisitedthistopic.S_HAS_POLL %}<i class="icon fa-bar-chart fa-fw" aria-hidden="true"></i>{% endif %}
+++										{% if whovisitedthistopic.ATTACH_ICON_IMG %}<i class="icon fa-paperclip fa-fw" aria-hidden="true"></i>{% endif %}
+++										{{ lang('POST_BY_AUTHOR') }} {{ whovisitedthistopic.TOPIC_AUTHOR_FULL }} &raquo; {{ whovisitedthistopic.FIRST_POST_TIME }} &raquo; {{ lang('IN') }} <a href="{{ whovisitedthistopic.U_VIEW_FORUM }}">{{ whovisitedthistopic.FORUM_TITLE }}</a>
+++									</div>
+++						</td>
+++						<td class="posts">
+++							{{ whovisitedthistopic.TOPIC_REPLIES }} <small>{{ lang('REPLIES') }}</small></td>
+++						<td class="views">
+++							{{ whovisitedthistopic.TOPIC_VIEWS }} <small>{{ lang('VIEWS') }}</small>
+++						</td>	
+++						<td class="lastpost">
+++							<span><small>{{ lang('LAST_POST') }} </small>{{ lang('POST_BY_AUTHOR') }} {{ whovisitedthistopic.LAST_POST_AUTHOR_FULL }}
+++									{% if not S_IS_BOT %}
+++									<a href="{{ whovisitedthistopic.U_LAST_POST }}" title="{{ lang('GOTO_LAST_POST') }}"><i class="icon fa fa-external-link-square " aria-hidden="true"></i><span class="sr-only">{{ VIEW_LATEST_POST }}</span></a>
+++									{% endif %}
+++									<br>{{ whovisitedthistopic.LAST_POST_TIME }}
+++								</span>
+++						</td>
+++					</tr>
+++					{% endfor %}
+++			</tbody>
+++		</table>
+++	</div>
+++</div>
+++{% endif %}
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\whovisitedthistopic/styles/FLATBOOTS/template/event/viewtopic_body_footer_before.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\whovisitedthistopic/styles/FLATBOOTS/template/event/viewtopic_body_footer_before.html"
++new file mode 100644
++index 000000000..026368fc6
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\dmzx\\whovisitedthistopic/styles/FLATBOOTS/template/event/viewtopic_body_footer_before.html"
++@@ -0,0 +1,18 @@
+++{% if PERMISSION_VIEW %}
+++	{% if whovisitedthistopic %}
+++		<div class="row">
+++			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
+++				<div class="panel panel-forum panel-whois
\ No newline at end of file
diff --git "[ORIGINAL]/dmzx\\whovisitedthistopic/event/listener.php" "[FORUM_EXT]/dmzx\\whovisitedthistopic/event/listener.php"
--- "[ORIGINAL]/dmzx\\whovisitedthistopic/event/listener.php"
+++ "[FORUM_EXT]/dmzx\\whovisitedthistopic/event/listener.php"
@@ -145,55 +145,21 @@ class listener implements EventSubscriberInterface
 		// Add lang file
 		$this->user->add_lang_ext('dmzx/whovisitedthistopic', 'common');
 
-		$topic_id = $event['topic_id'];
-		$user_id = $this->user->data['user_id'];
-		$value = $this->config['whovisitedthistopic_value'];
+		$topic_id = (int) $event['topic_id'];
+		$user_id = (int) $this->user->data['user_id'];
+		$value = (int) $this->config['whovisitedthistopic_value'];
 
-		if (($this->user->data['user_id'] != ANONYMOUS) && (!$this->user->data['is_bot']) && $this->config['whovisitedthistopic_allow_topics'])
+		if ($user_id !== ANONYMOUS && !$this->user->data['is_bot'] && $this->config['whovisitedthistopic_allow_topics'])
 		{
-			// Get the excluded members arrays
-			$whovisitedthistopic_members = json_decode($this->config['whovisitedthistopic_members']);
-
-			$sql = 'SELECT *
-				FROM ' . $this->whovisitedthistopic_table . '
-				WHERE user_id = ' . (int) $user_id . '
-					AND topic_id = ' . (int) $topic_id;
-			$result = $this->db->sql_query($sql);
-
-			if ($row = $this->db->sql_fetchrow($result))
-			{
-				$counter_user = $row['counter_user'] + 1;
 			$date = time();
-				$sql_arr = [
-					'counter_user'	=> (int) $counter_user,
-					'date'			=> $date
-				];
-
-				$sql_insert = 'UPDATE ' . $this->whovisitedthistopic_table . '
-					SET	' . $this->db->sql_build_array('UPDATE', $sql_arr) . '
-					WHERE user_id = ' . (int) $user_id . '
-						AND topic_id = ' . (int) $topic_id;
 
-					if (!empty($whovisitedthistopic_members))
-					{
-						$sql_insert .= ' AND ' . $this->db->sql_in_set('user_id', $whovisitedthistopic_members, true);
-					}
-				$this->db->sql_query($sql_insert);
-			}
-			else
-			{
-				$date = time();
-				$sql_arr = [
-					'counter_user'	=> 1,
-					'user_id'		=> (int) $user_id,
-					'topic_id'		=> (int) $topic_id,
-					'date'			=> $date
-				];
-
-				$sql_insert = 'INSERT INTO ' . $this->whovisitedthistopic_table . ' ' . $this->db->sql_build_array('INSERT', $sql_arr);
-				$this->db->sql_query($sql_insert);
-			}
-			$this->db->sql_freeresult($result);
+			// Usa INSERT ON DUPLICATE KEY UPDATE
+			$sql = 'INSERT INTO ' . $this->whovisitedthistopic_table . ' (user_id, topic_id, counter_user, date)
+				VALUES (' . $user_id . ', ' . $topic_id . ', 1, ' . $date . ')
+				ON DUPLICATE KEY UPDATE
+					counter_user = counter_user + 1,
+					date = ' . $date;
+			$this->db->sql_query($sql);
 		}
 
 		if ($this->auth->acl_get('u_whovisitedthistopic') && $this->config['whovisitedthistopic_allow_topics'])
@@ -201,9 +167,9 @@ class listener implements EventSubscriberInterface
 			// Get the excluded members arrays
 			$whovisitedthistopic_members = json_decode($this->config['whovisitedthistopic_members']);
 
-			$query = 'SELECT w.user_id, w.topic_id, w.counter_user, w.date, u.username, u.user_colour, u.user_id, u.user_avatar, u.user_avatar_type, u.user_avatar_height, u.user_avatar_width, u.user_type, SUM(w.counter_user) AS total
+			$query = 'SELECT w.user_id, u.username, u.user_colour, u.user_id, u.user_avatar, u.user_avatar_type, u.user_avatar_height, u.user_avatar_width, u.user_type, MAX(w.date) AS last_visit, SUM(w.counter_user) AS total
 				FROM ' . $this->whovisitedthistopic_table . ' w, ' . USERS_TABLE . ' u
-				WHERE w.topic_id = ' . (int) $topic_id . '
+				WHERE w.topic_id = ' . $topic_id . '
 				AND w.user_id = u.user_id';
 
 			if (!empty($whovisitedthistopic_members))
@@ -211,43 +177,34 @@ class listener implements EventSubscriberInterface
 				$query .= ' AND ' . $this->db->sql_in_set('w.user_id', $whovisitedthistopic_members, true);
 			}
 
-			$query .= ' GROUP BY w.user_id';
-			$query .= ' ORDER BY w.date DESC';
+			$query .= ' GROUP BY w.user_id
+						ORDER BY last_visit DESC';
+
 			$row_query = $this->db->sql_query_limit($query, $value);
 
 			while ($row = $this->db->sql_fetchrow($row_query))
 			{
-				$username = $row['username'];
-				$user_colour = ($row['user_colour']) ? ' style="color:#' . $row['user_colour'] . '" class="username-coloured"' : '';
-				$user_id = $row['user_id'];
-				$date = ($row['date']) ? ' title="' . $this->user->format_date($row['date']) . '" ': '';
 				$avatar = phpbb_get_user_avatar($row);
-
-				if ($this->auth->acl_get('u_whovisitedthistopic_count'))
-				{
-					$visits = (int) $row['total'];
-				}
-				else
-				{
-					$visits = null;
-				}
-
-				$url = append_sid("{$this->root_path}memberlist.{$this->phpEx}?mode=viewprofile&amp;u={$user_id}");
+				$user_colour = ($row['user_colour']) ? ' style="color:#' . $row['user_colour'] . '" class="username-coloured"' : '';
+				$visits = $this->auth->acl_get('u_whovisitedthistopic_count') ? (int) $row['total'] : null;
+				$date = $row['last_visit'] ? ' title="' . $this->user->format_date($row['last_visit']) . '" ' : '';
+				$url = append_sid("{$this->root_path}memberlist.{$this->phpEx}?mode=viewprofile&amp;u={$row['user_id']}");
 
 				$this->template->assign_block_vars('whovisitedthistopic', [
-					'USERNAME'			=> $username,
+					'USERNAME'			=> $row['username'],
 					'USERNAME_COLOUR'	=> $user_colour,
 					'VISITS'			=> $visits,
 					'URL'				=> $url,
-					'AVATAR'			=> empty($avatar) ? '<img src="' . $this->root_path . 'styles/prosilver/theme/images/no_avatar.gif" width="60px;" height="60px;" alt="" />' : $avatar,
+					'AVATAR'			=> empty($avatar) ? '<img class="img-thumbnail avatar" src="' . $this->root_path . 'styles/FLATBOOTS/theme/images/no-avatar.png" width="60px;" height="60px;" alt="" />' : $avatar,
 					'DATE'				=> $date
 				]);
 			}
 			$this->db->sql_freeresult($row_query);
 
+			// Total
 			$sql = 'SELECT topic_id, SUM(counter_user) AS counter
 				FROM ' . $this->whovisitedthistopic_table . '
-				WHERE topic_id = ' . (int) $topic_id;
+				WHERE topic_id = ' . $topic_id;
 			$result = $this->db->sql_query($sql);
 			$counter = (int) $this->db->sql_fetchfield('counter');
 			$this->db->sql_freeresult($result);
@@ -272,27 +229,27 @@ class listener implements EventSubscriberInterface
 
 		if ($this->auth->acl_get('u_whovisitedthistopic_profile') && $this->config['whovisitedthistopic_allow_memberpage'])
 		{
-			// Get the excluded members arrays
-			$whovisitedthistopic_members_profile = json_decode($this->config['whovisitedthistopic_members_profile']);
-
 			$sql_list = [
-				'SELECT'	=> 'ft.*, tt.*, wt.*',
+				'SELECT'	=> 'ft.forum_id, ft.forum_name,
+								tt.*,
+								wt.date',
 				'FROM' => [
-					FORUMS_TABLE	=> 'ft',
-					TOPICS_TABLE	=> 'tt',
 					$this->whovisitedthistopic_table => 'wt',
 				],
+				'LEFT_JOIN' => [
+					['FROM' => [TOPICS_TABLE => 'tt'], 'ON' => 'wt.topic_id = tt.topic_id'],
+					['FROM' => [FORUMS_TABLE => 'ft'], 'ON' => 'ft.forum_id = tt.forum_id'],
+				],
 				'WHERE' => 'tt.topic_moved_id = 0
 					AND tt.topic_visibility = 1
-					AND wt.user_id = ' . (int) $user_id . '
-					AND wt.topic_id = tt.topic_id
-					AND ft.forum_id = tt.forum_id',
+					AND wt.user_id = ' . (int) $user_id,
 				'ORDER_BY'	=> 'wt.date DESC',
 			];
 
-			if (!empty($whovisitedthistopic_members_profile))
-			{
-				$sql_list['WHERE'] .= ' AND ' . $this->db->sql_in_set('wt.user_id', $whovisitedthistopic_members_profile, true);
+			// Get the excluded members arrays
+			$excluded_ids = json_decode($this->config['whovisitedthistopic_members_profile'], true);
+			if (is_array($excluded_ids) && !empty($excluded_ids)) {
+				$sql_list['WHERE'] .= ' AND ' . $this->db->sql_in_set('wt.user_id', $excluded_ids, true);
 			}
 
 			if ($this->user->data['is_registered'] && $this->config['load_db_lastread'])
diff --git "[FORUM_EXT]/dmzx\\whovisitedthistopic/language/pt/common.php" "[FORUM_EXT]/dmzx\\whovisitedthistopic/language/pt/common.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/dmzx\\whovisitedthistopic/language/pt/common.php"
@@ -0,0 +1,42 @@
+<?php
+/**
+*
+* @package phpBB Extension - Who Visited This Topic
+* @copyright (c) 2016 dmzx - https://www.dmzx-web.net
+* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+*
+*/
+
+/**
+* DO NOT CHANGE
+*/
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
+// ’ « » “ ” …
+//
+
+$lang = array_merge($lang, [
+	'WHOVISITEDTHISTOPIC_TITLE'			=> 'Últimos <strong>%d</strong> Membros que visitaram este Tópico. De um total de <strong>%d</strong> visitas',
+	'WHOVISITEDTHISTOPIC_VISIT_TITLE'	=> 'Últimos <strong>%d</strong> tópicos visitados',
+]);
diff --git "[FORUM_EXT]/dmzx\\whovisitedthistopic/language/pt/info_acp_whovisitedthistopic.php" "[FORUM_EXT]/dmzx\\whovisitedthistopic/language/pt/info_acp_whovisitedthistopic.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/dmzx\\whovisitedthistopic/language/pt/info_acp_whovisitedthistopic.php"
@@ -0,0 +1,45 @@
+<?php
+/**
+*
+* @package phpBB Extension - Who Visited This Topic
+* @copyright (c) 2016 dmzx - https://www.dmzx-web.net
+* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+*
+*/
+
+/**
+* DO NOT CHANGE
+*/
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
+// ’ « » “ ” …
+//
+
+$lang = array_merge($lang, [
+	'ACP_WHOVISITEDTHISTOPIC_TITLE'				=> 'Quem Visitou Este Tópico',
+	'ACP_WHOVISITEDTHISTOPIC_SETTINGS'			=> 'Configurações',
+	'ACP_WHOVISITEDTHISTOPIC_OPTIONS_SAVED'		=> 'As opções de Quem Visitou Este Tópico foram guardadas com sucesso.',
+	// Log entries
+	'LOG_WHOVISITEDTHISTOPIC_UPDATE'			=> '<strong>Configurações de Quem Visitou Este Tópico guardadas com sucesso</strong>',
+]);
diff --git "[FORUM_EXT]/dmzx\\whovisitedthistopic/language/pt/permissions_whovisitedthistopic.php" "[FORUM_EXT]/dmzx\\whovisitedthistopic/language/pt/permissions_whovisitedthistopic.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/dmzx\\whovisitedthistopic/language/pt/permissions_whovisitedthistopic.php"
@@ -0,0 +1,44 @@
+<?php
+
+/**
+ *
+ * @package phpBB Extension - Who Visited This Topic
+ * @copyright (c) 2016 dmzx - https://www.dmzx-web.net
+ * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+ *
+ */
+
+/**
+ * DO NOT CHANGE
+ */
+if (!defined('IN_PHPBB')) {
+	exit;
+}
+
+if (empty($lang) || !is_array($lang)) {
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
+// ’ « » “ ” …
+//
+
+$lang = array_merge($lang, [
+	'WHOVISITEDTHISTOPIC_INDEX'					=> 'Quem Visitou Este Tópico',
+	'ACL_U_WHOVISITEDTHISTOPIC'					=> 'Pode ver Quem Visitou Este Tópico nos tópicos',
+	'ACL_U_WHOVISITEDTHISTOPIC_COUNT'			=> 'Pode ver contador de Quem Visitou Este Tópico nos tópicos',
+	'ACL_U_WHOVISITEDTHISTOPIC_PROFILE'			=> 'Pode ver Quem Visitou Este Tópico no perfil',
+	'ACL_U_WHOVISITEDTHISTOPIC_SHOW_AVATAR'		=> 'Pode ver avatar de Quem Visitou Este Tópico nos tópicos',
+]);
diff --git "[FORUM_EXT]/dmzx\\whovisitedthistopic/language/pt/whovisitedthistopic_acp.php" "[FORUM_EXT]/dmzx\\whovisitedthistopic/language/pt/whovisitedthistopic_acp.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/dmzx\\whovisitedthistopic/language/pt/whovisitedthistopic_acp.php"
@@ -0,0 +1,59 @@
+<?php
+/**
+*
+* @package phpBB Extension - Who Visited This Topic
+* @copyright (c) 2016 dmzx - https://www.dmzx-web.net
+* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+*
+*/
+
+/**
+* DO NOT CHANGE
+*/
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
+// ’ « » “ ” …
+//
+
+$lang = array_merge($lang, [
+	'WHOVISITEDTHISTOPIC_TOPIC_SETTINGS'				=> 'Enable Who Visited This Topic in topics',
+	'WHOVISITEDTHISTOPIC_TOPIC_SETTINGS_EXPLAIN'		=> 'This will show the Who Visited This Topic in viewtopics.',
+	'WHOVISITEDTHISTOPIC_COUNT_SETTINGS'				=> 'Enable Who Visited This Topic counter topics',
+	'WHOVISITEDTHISTOPIC_COUNT_SETTINGS_EXPLAIN'		=> 'This will show the Who Visited This Topic counter in topics.',
+	'WHOVISITEDTHISTOPIC_SHOW_AVATAR'					=> 'Enable Who Visited This Topic avatars in topics',
+	'WHOVISITEDTHISTOPIC_SHOW_AVATAR_EXPLAIN'			=> 'This will show the Who Visited This Topic avatars in topics.',
+	'WHOVISITEDTHISTOPIC_MEMBERPAGE_SETTINGS'			=> 'Enable Who Visited This Topic in profile',
+	'WHOVISITEDTHISTOPIC_MEMBERPAGE_SETTINGS_EXPLAIN'	=> 'This will show the Who Visited This Topic in profile.',
+	'WHOVISITEDTHISTOPIC_SETTING'						=> 'Set value for Who Visited This Topic in topics',
+	'WHOVISITEDTHISTOPIC_SETTING_EXPLAIN'				=> 'Value adjustable from 2 till 255 members. <em>Default is 10.</em>',
+	'WHOVISITEDTHISTOPIC_VISIT_SETTING'					=> 'Set value for Last Topics Visited in profile',
+	'WHOVISITEDTHISTOPIC_VISIT_SETTING_EXPLAIN'			=> 'Value adjustable from 2 till 255. <em>Default is 10.</em>',
+	'WHOVISITEDTHISTOPIC_DISABLED_TOPIC'				=> 'Disabled set “Enable Who Visited This Topic in topics” to Yes to enter value',
+	'WHOVISITEDTHISTOPIC_DISABLED_MEMBERPAGE'			=> 'Disabled set “Enable Who Visited This Topic in profile” to Yes to enter value',
+	'WHOVISITEDTHISTOPIC_SETTINGS_EXPLAIN'				=> 'Go to the <em><strong>Who Visited This Topic</strong></em> tab in Group permissions section to adjust permissions for each group.',
+	'WHOVISITEDTHISTOPIC_MEMBERS'						=> 'Exclude members in viewtopic',
+	'WHOVISITEDTHISTOPIC_MEMBERS_EXPLAIN'				=> 'Here you can manage the users that you want to exclude (don’t see them) or remove them from the exclude list.<br><strong>Note:</strong> Each user in a new line.',
+	'WHOVISITEDTHISTOPIC_MEMBERS_PROFILE'				=> 'Exclude members in profile view',
+	'WHOVISITEDTHISTOPIC_MEMBERS_PROFILE_EXPLAIN'		=> 'Here you can manage the users that you want to exclude (don’t see them) or remove them from the exclude list.<br><strong>Note:</strong> Each user in a new line.',
+]);
diff --git "[FORUM_EXT]/dmzx\\whovisitedthistopic/styles/FLATBOOTS/template/event/memberlist_view_contact_after.html" "[FORUM_EXT]/dmzx\\whovisitedthistopic/styles/FLATBOOTS/template/event/memberlist_view_contact_after.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/dmzx\\whovisitedthistopic/styles/FLATBOOTS/template/event/memberlist_view_contact_after.html"
@@ -0,0 +1,73 @@
+{% if PERMISSION_PROFILE and loops.whovisitedthistopic|length %}
+<div class="panel panel-forum">
+	<div class="panel-heading">
+		{{ WHOVISITEDTHISTOPIC_VISIT_TITLE }}
+	</div>
+	<div class="panel-inner">
+		<table class="footable table table-striped table-primary table-hover">
+			<thead>
+				<tr>
+				<th data-class="expand">{{ lang('TOPICS') }}</th>
+				<th class="posts" data-hide="phone">{{ lang('REPLIES') }}</th>
+				<th class="views" data-hide="phone">{{ lang('VIEWS') }}</th>
+				<th class="lastpost" data-hide="phone">{{ lang('LAST_POST') }}</th>
+				</tr>
+			</thead>
+			<tbody>
+				{% for whovisitedthistopic in loops.whovisitedthistopic %}
+				<tr id="forum-{forumrow.FORUM_ID}" class="topiclist topics">
+						<td title="{forumrow.FORUM_FOLDER_IMG_ALT}">
+							{% if whovisitedthistopic.S_UNREAD_TOPIC and not S_IS_BOT %}
+									<a href="{{ whovisitedthistopic.U_NEWEST_POST }}">
+										<i class="icon fa-file fa-fw icon-red icon-md" aria-hidden="true"></i><span class="sr-only">{{ NEW_POST }}</span>
+									</a>
+									{% endif %}
+									<a href="{{ whovisitedthistopic.U_VIEW_TOPIC }}" class="topictitle">{{ whovisitedthistopic.TOPIC_TITLE }}</a>
+									{% if whovisitedthistopic.S_TOPIC_UNAPPROVED or whovisitedthistopic.S_POSTS_UNAPPROVED %}
+									<a href="{{ whovisitedthistopic.U_MCP_QUEUE }}">
+										<i class="icon fa-question fa-fw icon-blue" aria-hidden="true"></i><span class="sr-only">{{ TOPIC_UNAPPROVED }}</span>
+									</a>
+									{% endif %}
+									{% if whovisitedthistopic.S_TOPIC_REPORTED %}
+									<a href="{{ whovisitedthistopic.U_MCP_REPORT }}">
+										<i class="icon fa-exclamation fa-fw icon-red" aria-hidden="true"></i><span class="sr-only">{{ TOPIC_REPORTED }}</span>
+									</a>
+									{% endif %}
+									<br>
+
+									{% if not S_IS_BOT %}
+									<div class="responsive-show" style="display: none;">
+										{{ lang('LAST_POST') }} {{ lang('POST_BY_AUTHOR') }} {{ whovisitedthistopic.LAST_POST_AUTHOR_FULL }} &laquo; <a href="{{ whovisitedthistopic.U_LAST_POST }}" title="{{ lang('GOTO_LAST_POST') }}">{{ whovisitedthistopic.LAST_POST_TIME }}</a>
+										<br>{{ lang('POSTED') }} {{ lang('IN') }} <a href="{{ whovisitedthistopic.U_VIEW_FORUM }}">{{ whovisitedthistopic.FORUM_TITLE }}</a>
+									</div>
+										{% if whovisitedthistopic.TOPIC_REPLIES %}
+										<span class="responsive-show left-box" style="display: none;">{{ lang('REPLIES') ~ lang('COLON') }} <strong>{{ whovisitedthistopic.TOPIC_REPLIES }}</strong></span>
+										{% endif %}
+									{% endif %}
+
+									<div class="topic-poster responsive-hide left-box">
+										{% if whovisitedthistopic.S_HAS_POLL %}<i class="icon fa-bar-chart fa-fw" aria-hidden="true"></i>{% endif %}
+										{% if whovisitedthistopic.ATTACH_ICON_IMG %}<i class="icon fa-paperclip fa-fw" aria-hidden="true"></i>{% endif %}
+										{{ lang('POST_BY_AUTHOR') }} {{ whovisitedthistopic.TOPIC_AUTHOR_FULL }} &raquo; {{ whovisitedthistopic.FIRST_POST_TIME }} &raquo; {{ lang('IN') }} <a href="{{ whovisitedthistopic.U_VIEW_FORUM }}">{{ whovisitedthistopic.FORUM_TITLE }}</a>
+									</div>
+						</td>
+						<td class="posts">
+							{{ whovisitedthistopic.TOPIC_REPLIES }} <small>{{ lang('REPLIES') }}</small></td>
+						<td class="views">
+							{{ whovisitedthistopic.TOPIC_VIEWS }} <small>{{ lang('VIEWS') }}</small>
+						</td>	
+						<td class="lastpost">
+							<span><small>{{ lang('LAST_POST') }} </small>{{ lang('POST_BY_AUTHOR') }} {{ whovisitedthistopic.LAST_POST_AUTHOR_FULL }}
+									{% if not S_IS_BOT %}
+									<a href="{{ whovisitedthistopic.U_LAST_POST }}" title="{{ lang('GOTO_LAST_POST') }}"><i class="icon fa fa-external-link-square " aria-hidden="true"></i><span class="sr-only">{{ VIEW_LATEST_POST }}</span></a>
+									{% endif %}
+									<br>{{ whovisitedthistopic.LAST_POST_TIME }}
+								</span>
+						</td>
+					</tr>
+					{% endfor %}
+			</tbody>
+		</table>
+	</div>
+</div>
+{% endif %}
diff --git "[FORUM_EXT]/dmzx\\whovisitedthistopic/styles/FLATBOOTS/template/event/viewtopic_body_footer_before.html" "[FORUM_EXT]/dmzx\\whovisitedthistopic/styles/FLATBOOTS/template/event/viewtopic_body_footer_before.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/dmzx\\whovisitedthistopic/styles/FLATBOOTS/template/event/viewtopic_body_footer_before.html"
@@ -0,0 +1,18 @@
+{% if PERMISSION_VIEW %}
+	{% if whovisitedthistopic %}
+		<div class="row">
+			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
+				<div class="panel panel-forum panel-whois">
+					<div class="panel-heading"><i class="fa fa-user"></i>&nbsp;{{ WHOVISITEDTHISTOPIC_TITLE }}</div>
+					<div class="panel-body">
+						<p>
+							{% for whovisitedthistopic in loops.whovisitedthistopic %}
+								{% if PERMISSION_SHOW_AVATAR %}<span class="whovisitedthistopic-avatar">{{ whovisitedthistopic.AVATAR }}</span>{% endif %} <span><a href="{{ whovisitedthistopic.URL }}" {{ whovisitedthistopic.DATE }} {{ whovisitedthistopic.USERNAME_COLOUR }}>{{ whovisitedthistopic.USERNAME }}</a></span>{% if PERMISSION_COUNT %} ({{ whovisitedthistopic.VISITS }}){% endif %}{% if not whovisitedthistopic.S_LAST_ROW %}, {% endif %}
+							{% endfor %}
+						</p>
+					</div>
+				</div>
+			</div>
+		</div>
+	{% endif %}
+{% endif %}
```
