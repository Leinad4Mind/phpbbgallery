Existem diferencas reais no codigo ou texto. Diferencas de formatacao (espacos, tabs) foram ignoradas abaixo.

```diff
diff --git "[ORIGINAL]/forumhulp\\statistics/config/tables.yml" "[FORUM_EXT]/forumhulp\\statistics/config/tables.yml"
--- "[ORIGINAL]/forumhulp\\statistics/config/tables.yml"
+++ "[FORUM_EXT]/forumhulp\\statistics/config/tables.yml"
@@ -1,7 +1,7 @@
 parameters:
-    tables.config_table: %core.table_prefix%statistics_config
-    tables.online_table: %core.table_prefix%statistics_online
-    tables.domain_table: %core.table_prefix%statistics_domains
-    tables.se_table: %core.table_prefix%statistics_se
-    tables.archive_table: %core.table_prefix%statistics_archive
-    tables.stats_table: %core.table_prefix%statistics
+    tables.config_table: '%core.table_prefix%statistics_config'
+    tables.online_table: '%core.table_prefix%statistics_online'
+    tables.domain_table: '%core.table_prefix%statistics_domains'
+    tables.se_table: '%core.table_prefix%statistics_se'
+    tables.archive_table: '%core.table_prefix%statistics_archive'
+    tables.stats_table: '%core.table_prefix%statistics'
diff --git "[FORUM_EXT]/forumhulp\\statistics/diff_full.tmp" "[FORUM_EXT]/forumhulp\\statistics/diff_full.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/forumhulp\\statistics/diff_full.tmp"
@@ -0,0 +1,147 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\statistics/config/tables.yml" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\statistics/config/tables.yml"
+index 0c8695e87..00934b2d1 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\statistics/config/tables.yml"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\statistics/config/tables.yml"
+@@ -1,7 +1,7 @@
+ parameters:
+-    tables.config_table: %core.table_prefix%statistics_config
+-    tables.online_table: %core.table_prefix%statistics_online
+-    tables.domain_table: %core.table_prefix%statistics_domains
+-    tables.se_table: %core.table_prefix%statistics_se
+-    tables.archive_table: %core.table_prefix%statistics_archive
+-    tables.stats_table: %core.table_prefix%statistics
++    tables.config_table: '%core.table_prefix%statistics_config'
++    tables.online_table: '%core.table_prefix%statistics_online'
++    tables.domain_table: '%core.table_prefix%statistics_domains'
++    tables.se_table: '%core.table_prefix%statistics_se'
++    tables.archive_table: '%core.table_prefix%statistics_archive'
++    tables.stats_table: '%core.table_prefix%statistics'
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\statistics/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\statistics/diff_full.tmp"
+new file mode 100644
+index 000000000..e69de29bb
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\statistics/vendor/find_os.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\statistics/vendor/find_os.php"
+index 42938aaea..3273f0879 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\statistics/vendor/find_os.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\statistics/vendor/find_os.php"
+@@ -159,6 +159,8 @@ class find_os
+ 	protected function checkPlatform()
+ 	{
+ 		$os_array = array(
++							'/windows nt 12/i'      =>  'Windows 12',
++							'/windows nt 11/i'      =>  'Windows 11',
+ 							'/windows nt 10/i'      =>  'Windows 10',
+ 							'/windows nt 6.3/i'     =>  'Windows 8.1',
+ 							'/windows nt 6.2/i'     =>  'Windows 8',
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\statistics/vendor/stat_functions.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\statistics/vendor/stat_functions.php"
+index 3c5c22259..92e401833 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\statistics/vendor/stat_functions.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\statistics/vendor/stat_functions.php"
+@@ -104,7 +104,7 @@ class stat_functions
+ 				$result = $db->sql_query($sql);
+ 				while ($row = $db->sql_fetchrow($result))
+ 				{
+-					$modules[$row['title']] = $row['title'];			
++					$modules[$row['title']] = $row['title'];
+ 				}
+ 			}
+ 
+@@ -744,29 +744,19 @@ class stat_functions
+ 														$user->format_date($row['lastdate'], 'd m \'y') . ')': '',
+ 									'OVERALLSORT'	=> ($overall) ? '&amp;overall=1' : ''));
+ 
+-		$sql = ($overall) ? 'SELECT  a.name AS uname, a.hits AS total_per_users, u.user_id,
++		$sql = ($overall) ? 'SELECT  a.name AS uname, a.hits AS total_per_users,
+ 				(SELECT  sum(a.hits)
+-				FROM    ' . $tables['archive'] . ' a
+-						LEFT JOIN ' . BOTS_TABLE . ' b
+-							ON a.name = b.bot_name
+-				WHERE  a.cat = 5 AND b.bot_name IS NULL) AS total
+-				FROM    ' . $tables['archive'] . ' a
+-						LEFT JOIN ' . BOTS_TABLE . ' b
+-							ON a.name = b.bot_name
+-						LEFT JOIN ' . USERS_TABLE . ' u ON u.username = a.name
+-				WHERE  a.cat = 5 AND b.bot_name IS not NULL ORDER BY ' . $sql_sort :
++				FROM    ' . $tables['archive'] . ' a, ' . BOTS_TABLE . ' b
++				WHERE  a.name = b.bot_name AND a.cat = 5) AS total
++				FROM    ' . $tables['archive'] . ' a, ' . BOTS_TABLE . ' u
++				WHERE  a.uname = b.bot_name AND a.cat = 5 AND b.bot_name IS not NULL ORDER BY ' . $sql_sort :
+ 
+-				'SELECT  a.uname, COUNT(a.uname) AS total_per_users, u.user_id,
++				'SELECT  a.uname, COUNT(a.uname) AS total_per_users,
+ 				(SELECT  COUNT(a.uname)
+-				FROM    ' . $tables['online'] . ' a
+-						LEFT JOIN ' . BOTS_TABLE . ' b
+-							ON a.uname = b.bot_name
+-				WHERE  b.bot_name IS NULL) as total
+-				FROM    ' . $tables['online'] . ' a
+-						LEFT JOIN ' . BOTS_TABLE . ' b
+-							ON a.uname = b.bot_name
+-						LEFT JOIN ' . USERS_TABLE . ' u ON u.username = a.uname
+-				WHERE  b.bot_name IS not NULL GROUP BY a.uname ORDER BY ' . $sql_sort;
++				FROM    ' . $tables['online'] . ' a, ' . BOTS_TABLE . ' b
++				WHERE  a.uname = b.bot_name) as total
++				FROM    ' . $tables['online'] . ' a, ' . BOTS_TABLE . ' b
++				WHERE  a.uname = b.bot_name GROUP BY a.uname ORDER BY ' . $sql_sort;
+ 
+ 		$result = $db->sql_query_limit($sql, $sconfig['statistics_max_crawl'], $start);
+ 		$counter = 0;
+@@ -1049,27 +1039,17 @@ class stat_functions
+ 
+ 		$sql = ($overall) ? 'SELECT  a.name AS uname, a.hits AS total_per_users, u.user_id,
+ 				a.hits / (SELECT  sum(a.hits)
+-				FROM    ' . $tables['archive'] . ' a
+-						LEFT JOIN ' . BOTS_TABLE . ' b
+-							ON a.name = b.bot_name
+-				WHERE  a.cat = 5 AND b.bot_name IS NULL) AS total
+-				FROM    ' . $tables['archive'] . ' a
+-						LEFT JOIN ' . BOTS_TABLE . ' b
+-							ON a.name = b.bot_name
+-						LEFT JOIN ' . USERS_TABLE . ' u ON u.username = a.name
+-				WHERE  a.cat = 5 AND b.bot_name IS NULL ORDER BY ' . $sql_sort :
++				FROM    ' . $tables['archive'] . ' a, ' . BOTS_TABLE . ' b
++				WHERE  a.name = b.bot_name AND a.cat = 5) AS total
++				FROM    ' . $tables['archive'] . ' a, ' . USERS_TABLE . ' u
++				WHERE  u.username = a.name AND a.cat = 5 AND b.bot_name IS NULL ORDER BY ' . $sql_sort :
+ 
+ 				'SELECT  a.uname, COUNT(a.uname) AS total_per_users, u.user_id,
+-				COUNT(a.uname) / (SELECT  COUNT(a.uname)
+-				FROM    ' . $tables['online'] . ' a
+-						LEFT JOIN ' . BOTS_TABLE . ' b
+-							ON a.uname = b.bot_name
+-				WHERE  b.bot_name IS NULL) as total
+-				FROM    ' . $tables['online'] . ' a
+-						LEFT JOIN ' . BOTS_TABLE . ' b
+-							ON a.uname = b.bot_name
+-						LEFT JOIN ' . USERS_TABLE . ' u ON u.username = a.uname
+-				WHERE  b.bot_name IS NULL GROUP BY a.uname ORDER BY ' . $sql_sort;
++				(SELECT  COUNT(a.uname)
++				FROM    ' . $tables['online'] . ' a, ' . BOTS_TABLE . ' b
++				WHERE  a.uname = b.bot_name) as total
++				FROM    ' . $tables['online'] . ' a, ' . USERS_TABLE . ' u
++				WHERE  u.username = a.uname AND u.user_type != 2 GROUP BY a.uname ORDER BY ' . $sql_sort;
+ 
+ 		$result = $db->sql_query_limit($sql, $sconfig['statistics_max_users'], $start);
+ 		$counter = 0;
+@@ -1083,8 +1063,8 @@ class stat_functions
+ 				'USER_ID'		=> $row['user_id'],
+ 				'MODULECOUNT'	=> self::roundk($row['total_per_users']),
+ 				'TMODULECOUNT'	=> $row['total_per_users'],
+-				'MODULETOTAL'	=> round((($row['total']) * 100), 1) . ' % (' . self::roundk($row['total_per_users']) . ' of ' . self::roundk($row['total'] * 100) . ')',
+-				'TMODULETOTAL'	=> round((($row['total']) * 100), 1) . ' % (' . $row['total_per_users'] . ' of ' . $row['total'] * 100 . ')'
++				'MODULETOTAL'	=> round((($row['total_per_users'] / $row['total']) * 100), 1) . ' % (' . self::roundk($row['total_per_users']) . ' of ' . self::roundk($row['total']) . ')',
++				'TMODULETOTAL'	=> round((($row['total_per_users'] / $row['total']) * 100), 1) . ' % (' . $row['total_per_users'] . ' of ' . $row['total'] . ')'
+ 				)
+ 			);
+ 			$graphstr .= (($graphstr == '') ? '' : ', ') . '[\'' . html_entity_decode($db->sql_escape($row['uname'])) . '\', ' . $row['total_per_users'] . ']';
+@@ -1134,9 +1114,9 @@ class stat_functions
+ 					   (($searchresulttabel) ? ' UNION SELECT "Searchwords" AS name, COUNT(search_key) AS hits FROM ' . $table_prefix . 'searchresults' : '');
+ 		$sql_aray[] = '';
+ 		$sql_aray[] = 'SELECT g.group_name AS name, g.group_type, hits FROM ' . $tables['archive'] . ' LEFT JOIN ' . GROUPS_TABLE . ' g ON g.group_id = name WHERE cat = 10 ORDER BY hits DESC';
+-		$sql_aray[] = (!$phpbb_container->get('ext.manager')->is_enabled('forumhulp/searchresults')) ?
++		$sql_aray[] = (!$searchresulttabel) ?
+ 						'SELECT "<a href=\"https://github.com/ForumHulp/searchresults\" target=\"_blank\">Searchresult extension</a> not enabled" AS name, "" AS hits' :
+-						'SELECT search_keywords AS name, hits FROM ' . $phpbb_container->getParameter('tables.searchresults') . ' ORDER BY hits DESC';
++						'SELECT search_keywords AS name, hits FROM ' . $table_prefix . 'searchresults ORDER BY hits DESC';
+ 		$sql_aray[] = 'SELECT name, hits FROM ' . $tables['archive'] . ' WHERE cat = 9 ORDER BY hits DESC';
+ 
+ 		$pagination = $phpbb_container->get('pagination');
diff --git "[FORUM_EXT]/forumhulp\\statistics/diff_nospace.tmp" "[FORUM_EXT]/forumhulp\\statistics/diff_nospace.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/forumhulp\\statistics/diff_nospace.tmp"
@@ -0,0 +1,139 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\statistics/config/tables.yml" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\statistics/config/tables.yml"
+index 0c8695e87..00934b2d1 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\statistics/config/tables.yml"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\statistics/config/tables.yml"
+@@ -1,7 +1,7 @@
+ parameters:
+-    tables.config_table: %core.table_prefix%statistics_config
+-    tables.online_table: %core.table_prefix%statistics_online
+-    tables.domain_table: %core.table_prefix%statistics_domains
+-    tables.se_table: %core.table_prefix%statistics_se
+-    tables.archive_table: %core.table_prefix%statistics_archive
+-    tables.stats_table: %core.table_prefix%statistics
++    tables.config_table: '%core.table_prefix%statistics_config'
++    tables.online_table: '%core.table_prefix%statistics_online'
++    tables.domain_table: '%core.table_prefix%statistics_domains'
++    tables.se_table: '%core.table_prefix%statistics_se'
++    tables.archive_table: '%core.table_prefix%statistics_archive'
++    tables.stats_table: '%core.table_prefix%statistics'
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\statistics/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\statistics/diff_full.tmp"
+new file mode 100644
+index 000000000..d25fa0d5c
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\statistics/diff_full.tmp"
+@@ -0,0 +1,147 @@
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\statistics/config/tables.yml" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\statistics/config/tables.yml"
++index 0c8695e87..00934b2d1 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\statistics/config/tables.yml"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\statistics/config/tables.yml"
++@@ -1,7 +1,7 @@
++ parameters:
++-    tables.config_table: %core.table_prefix%statistics_config
++-    tables.online_table: %core.table_prefix%statistics_online
++-    tables.domain_table: %core.table_prefix%statistics_domains
++-    tables.se_table: %core.table_prefix%statistics_se
++-    tables.archive_table: %core.table_prefix%statistics_archive
++-    tables.stats_table: %core.table_prefix%statistics
+++    tables.config_table: '%core.table_prefix%statistics_config'
+++    tables.online_table: '%core.table_prefix%statistics_online'
+++    tables.domain_table: '%core.table_prefix%statistics_domains'
+++    tables.se_table: '%core.table_prefix%statistics_se'
+++    tables.archive_table: '%core.table_prefix%statistics_archive'
+++    tables.stats_table: '%core.table_prefix%statistics'
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\statistics/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\statistics/diff_full.tmp"
++new file mode 100644
++index 000000000..e69de29bb
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\statistics/vendor/find_os.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\statistics/vendor/find_os.php"
++index 42938aaea..3273f0879 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\statistics/vendor/find_os.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\statistics/vendor/find_os.php"
++@@ -159,6 +159,8 @@ class find_os
++ 	protected function checkPlatform()
++ 	{
++ 		$os_array = array(
+++							'/windows nt 12/i'      =>  'Windows 12',
+++							'/windows nt 11/i'      =>  'Windows 11',
++ 							'/windows nt 10/i'      =>  'Windows 10',
++ 							'/windows nt 6.3/i'     =>  'Windows 8.1',
++ 							'/windows nt 6.2/i'     =>  'Windows 8',
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\statistics/vendor/stat_functions.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\statistics/vendor/stat_functions.php"
++index 3c5c22259..92e401833 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumhulp\\statistics/vendor/stat_functions.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumhulp\\statistics/vendor/stat_functions.php"
++@@ -104,7 +104,7 @@ class stat_functions
++ 				$result = $db->sql_query($sql);
++ 				while ($row = $db->sql_fetchrow($result))
++ 				{
++-					$modules[$row['title']] = $row['title'];			
+++					$modules[$row['title']] = $row['title'];
++ 				}
++ 			}
++ 
++@@ -744,29 +744,19 @@ class stat_functions
++ 														$user->format_date($row['lastdate'], 'd m \'y') . ')': '',
++ 									'OVERALLSORT'	=> ($overall) ? '&amp;overall=1' : ''));
++ 
++-		$sql = ($overall) ? 'SELECT  a.name AS uname, a.hits AS total_per_users, u.user_id,
+++		$sql = ($overall) ? 'SELECT  a.name AS uname, a.hits AS total_per_users,
++ 				(SELECT  sum(a.hits)
++-				FROM    ' . $tables['archive'] . ' a
++-						LEFT JOIN ' . BOTS_TABLE . ' b
++-							ON a.name = b.bot_name
++-				WHERE  a.cat = 5 AND b.bot_name IS NULL) AS total
++-				FROM    ' . $tables['archive'] . ' a
++-						LEFT JOIN ' . BOTS_TABLE . ' b
++-							ON a.name = b.bot_name
++-						LEFT JOIN ' . USERS_TABLE . ' u ON u.username = a.name
++-				WHERE  a.cat = 5 AND b.bot_name IS not NULL ORDER BY ' . $sql_sort :
+++				FROM    ' . $tables['archive'] . ' a, ' . BOTS_TABLE . ' b
+++				WHERE  a.name = b.bot_name AND a.cat = 5) AS total
+++				FROM    ' . $tables['archive'] . ' a, ' . BOTS_TABLE . ' u
+++				WHERE  a.uname = b.bot_name AND a.cat = 5 AND b.bot_name IS not NULL ORDER BY ' . $sql_sort :
++ 
++-				'SELECT  a.uname, COUNT(a.uname) AS total_per_users, u.user_id,
+++				'SELECT  a.uname, COUNT(a.uname) AS total_per_users,
++ 				(SELECT  COUNT(a.uname)
++-				FROM    ' . $tables['online'] . ' a
++-						LEFT JOIN ' . BOTS_TABLE . ' b
++-							ON a.uname = b.bot_name
++-				WHERE  b.bot_name IS NULL) as total
++-				FROM    ' . $tables['online'] . ' a
++-						LEFT JOIN ' . BOTS_TABLE . ' b
++-							ON a.uname = b.bot_name
++-						LEFT JOIN ' . USERS_TABLE . ' u ON u.username = a.uname
++-				WHERE  b.bot_name IS not NULL GROUP BY a.uname ORDER BY ' . $sql_sort;
+++				FROM    ' . $tables['online'] . ' a, ' . BOTS_TABLE . ' b
+++				WHERE  a.uname = b.bot_name) as total
+++				FROM    ' . $tables['online'] . ' a, ' . BOTS_TABLE . ' b
+++				WHERE  a.uname = b.bot_name GROUP BY a.uname ORDER BY ' . $sql_sort;
++ 
++ 		$result = $db->sql_query_limit($sql, $sconfig['statistics_max_crawl'], $start);
++ 		$counter = 0;
++@@ -1049,27 +1039,17 @@ class stat_functions
++ 
++ 		$sql = ($overall) ? 'SELECT  a.name AS uname, a.hits AS total_per_users, u.user_id,
++ 				a.hits / (SELECT  sum(a.hits)
++-				FROM    ' . $tables['archive'] . ' a
++-						LEFT JOIN ' . BOTS_TABLE . ' b
++-							ON a.name = b.bot_name
++-				WHERE  a.cat = 5 AND b.bot_name IS NULL) AS total
++-				FROM    ' . $tables['archive'] . ' a
++-						LEFT JOIN ' . BOTS_TABLE . ' b
++-							ON a.name = b.bot_name
++-						LEFT JOIN ' . USERS_TABLE . ' u ON u.username = a.name
++-				WHERE  a.cat = 5 AND b.bot_name IS NULL ORDER BY ' . $sql_sort :
+++				FROM    ' . $tables['archive'] . ' a, ' . BOTS_TABLE . ' b
+++				WHERE  a.name = b.bot_name AND a.cat = 5) AS total
+++				FROM    ' . $tables['archive'] . ' a, ' . USERS_TABLE . ' u
+++				WHERE  u.username = a.name AND a.cat = 5 AND b.bot_name IS NULL ORDER BY ' . $sql_sort :
++ 
++ 				'SELECT  a.uname, COUNT(a.uname) AS total_per_users, u.user_id,
++-				COUNT(a.uname) / (SELECT  COUNT(a.uname)
++-				FROM    ' . $tables['online'] . ' a
++-						LEFT JOIN ' . BOTS_TABLE . ' b
++-							ON a.uname = b.bot_name
++-				WHERE  b.bot_name IS NULL) as total
++-				FROM    ' . $tables['online'] . ' a
++-						LEFT JOIN ' . BOTS_TABLE . ' b
++-							ON a.uname = b.bot_name
++-						LEFT JOIN ' 
\ No newline at end of file
diff --git "[ORIGINAL]/forumhulp\\statistics/vendor/find_os.php" "[FORUM_EXT]/forumhulp\\statistics/vendor/find_os.php"
--- "[ORIGINAL]/forumhulp\\statistics/vendor/find_os.php"
+++ "[FORUM_EXT]/forumhulp\\statistics/vendor/find_os.php"
@@ -159,6 +159,8 @@ class find_os
 	protected function checkPlatform()
 	{
 		$os_array = array(
+							'/windows nt 12/i'      =>  'Windows 12',
+							'/windows nt 11/i'      =>  'Windows 11',
 							'/windows nt 10/i'      =>  'Windows 10',
 							'/windows nt 6.3/i'     =>  'Windows 8.1',
 							'/windows nt 6.2/i'     =>  'Windows 8',
diff --git "[ORIGINAL]/forumhulp\\statistics/vendor/stat_functions.php" "[FORUM_EXT]/forumhulp\\statistics/vendor/stat_functions.php"
--- "[ORIGINAL]/forumhulp\\statistics/vendor/stat_functions.php"
+++ "[FORUM_EXT]/forumhulp\\statistics/vendor/stat_functions.php"
@@ -744,29 +744,19 @@ class stat_functions
 														$user->format_date($row['lastdate'], 'd m \'y') . ')': '',
 									'OVERALLSORT'	=> ($overall) ? '&amp;overall=1' : ''));
 
-		$sql = ($overall) ? 'SELECT  a.name AS uname, a.hits AS total_per_users, u.user_id,
+		$sql = ($overall) ? 'SELECT  a.name AS uname, a.hits AS total_per_users,
 				(SELECT  sum(a.hits)
-				FROM    ' . $tables['archive'] . ' a
-						LEFT JOIN ' . BOTS_TABLE . ' b
-							ON a.name = b.bot_name
-				WHERE  a.cat = 5 AND b.bot_name IS NULL) AS total
-				FROM    ' . $tables['archive'] . ' a
-						LEFT JOIN ' . BOTS_TABLE . ' b
-							ON a.name = b.bot_name
-						LEFT JOIN ' . USERS_TABLE . ' u ON u.username = a.name
-				WHERE  a.cat = 5 AND b.bot_name IS not NULL ORDER BY ' . $sql_sort :
+				FROM    ' . $tables['archive'] . ' a, ' . BOTS_TABLE . ' b
+				WHERE  a.name = b.bot_name AND a.cat = 5) AS total
+				FROM    ' . $tables['archive'] . ' a, ' . BOTS_TABLE . ' u
+				WHERE  a.uname = b.bot_name AND a.cat = 5 AND b.bot_name IS not NULL ORDER BY ' . $sql_sort :
 
-				'SELECT  a.uname, COUNT(a.uname) AS total_per_users, u.user_id,
+				'SELECT  a.uname, COUNT(a.uname) AS total_per_users,
 				(SELECT  COUNT(a.uname)
-				FROM    ' . $tables['online'] . ' a
-						LEFT JOIN ' . BOTS_TABLE . ' b
-							ON a.uname = b.bot_name
-				WHERE  b.bot_name IS NULL) as total
-				FROM    ' . $tables['online'] . ' a
-						LEFT JOIN ' . BOTS_TABLE . ' b
-							ON a.uname = b.bot_name
-						LEFT JOIN ' . USERS_TABLE . ' u ON u.username = a.uname
-				WHERE  b.bot_name IS not NULL GROUP BY a.uname ORDER BY ' . $sql_sort;
+				FROM    ' . $tables['online'] . ' a, ' . BOTS_TABLE . ' b
+				WHERE  a.uname = b.bot_name) as total
+				FROM    ' . $tables['online'] . ' a, ' . BOTS_TABLE . ' b
+				WHERE  a.uname = b.bot_name GROUP BY a.uname ORDER BY ' . $sql_sort;
 
 		$result = $db->sql_query_limit($sql, $sconfig['statistics_max_crawl'], $start);
 		$counter = 0;
@@ -1049,27 +1039,17 @@ class stat_functions
 
 		$sql = ($overall) ? 'SELECT  a.name AS uname, a.hits AS total_per_users, u.user_id,
 				a.hits / (SELECT  sum(a.hits)
-				FROM    ' . $tables['archive'] . ' a
-						LEFT JOIN ' . BOTS_TABLE . ' b
-							ON a.name = b.bot_name
-				WHERE  a.cat = 5 AND b.bot_name IS NULL) AS total
-				FROM    ' . $tables['archive'] . ' a
-						LEFT JOIN ' . BOTS_TABLE . ' b
-							ON a.name = b.bot_name
-						LEFT JOIN ' . USERS_TABLE . ' u ON u.username = a.name
-				WHERE  a.cat = 5 AND b.bot_name IS NULL ORDER BY ' . $sql_sort :
+				FROM    ' . $tables['archive'] . ' a, ' . BOTS_TABLE . ' b
+				WHERE  a.name = b.bot_name AND a.cat = 5) AS total
+				FROM    ' . $tables['archive'] . ' a, ' . USERS_TABLE . ' u
+				WHERE  u.username = a.name AND a.cat = 5 AND b.bot_name IS NULL ORDER BY ' . $sql_sort :
 
 				'SELECT  a.uname, COUNT(a.uname) AS total_per_users, u.user_id,
-				COUNT(a.uname) / (SELECT  COUNT(a.uname)
-				FROM    ' . $tables['online'] . ' a
-						LEFT JOIN ' . BOTS_TABLE . ' b
-							ON a.uname = b.bot_name
-				WHERE  b.bot_name IS NULL) as total
-				FROM    ' . $tables['online'] . ' a
-						LEFT JOIN ' . BOTS_TABLE . ' b
-							ON a.uname = b.bot_name
-						LEFT JOIN ' . USERS_TABLE . ' u ON u.username = a.uname
-				WHERE  b.bot_name IS NULL GROUP BY a.uname ORDER BY ' . $sql_sort;
+				(SELECT  COUNT(a.uname)
+				FROM    ' . $tables['online'] . ' a, ' . BOTS_TABLE . ' b
+				WHERE  a.uname = b.bot_name) as total
+				FROM    ' . $tables['online'] . ' a, ' . USERS_TABLE . ' u
+				WHERE  u.username = a.uname AND u.user_type != 2 GROUP BY a.uname ORDER BY ' . $sql_sort;
 
 		$result = $db->sql_query_limit($sql, $sconfig['statistics_max_users'], $start);
 		$counter = 0;
@@ -1083,8 +1063,8 @@ class stat_functions
 				'USER_ID'		=> $row['user_id'],
 				'MODULECOUNT'	=> self::roundk($row['total_per_users']),
 				'TMODULECOUNT'	=> $row['total_per_users'],
-				'MODULETOTAL'	=> round((($row['total']) * 100), 1) . ' % (' . self::roundk($row['total_per_users']) . ' of ' . self::roundk($row['total'] * 100) . ')',
-				'TMODULETOTAL'	=> round((($row['total']) * 100), 1) . ' % (' . $row['total_per_users'] . ' of ' . $row['total'] * 100 . ')'
+				'MODULETOTAL'	=> round((($row['total_per_users'] / $row['total']) * 100), 1) . ' % (' . self::roundk($row['total_per_users']) . ' of ' . self::roundk($row['total']) . ')',
+				'TMODULETOTAL'	=> round((($row['total_per_users'] / $row['total']) * 100), 1) . ' % (' . $row['total_per_users'] . ' of ' . $row['total'] . ')'
 				)
 			);
 			$graphstr .= (($graphstr == '') ? '' : ', ') . '[\'' . html_entity_decode($db->sql_escape($row['uname'])) . '\', ' . $row['total_per_users'] . ']';
@@ -1134,9 +1114,9 @@ class stat_functions
 					   (($searchresulttabel) ? ' UNION SELECT "Searchwords" AS name, COUNT(search_key) AS hits FROM ' . $table_prefix . 'searchresults' : '');
 		$sql_aray[] = '';
 		$sql_aray[] = 'SELECT g.group_name AS name, g.group_type, hits FROM ' . $tables['archive'] . ' LEFT JOIN ' . GROUPS_TABLE . ' g ON g.group_id = name WHERE cat = 10 ORDER BY hits DESC';
-		$sql_aray[] = (!$phpbb_container->get('ext.manager')->is_enabled('forumhulp/searchresults')) ?
+		$sql_aray[] = (!$searchresulttabel) ?
 						'SELECT "<a href=\"https://github.com/ForumHulp/searchresults\" target=\"_blank\">Searchresult extension</a> not enabled" AS name, "" AS hits' :
-						'SELECT search_keywords AS name, hits FROM ' . $phpbb_container->getParameter('tables.searchresults') . ' ORDER BY hits DESC';
+						'SELECT search_keywords AS name, hits FROM ' . $table_prefix . 'searchresults ORDER BY hits DESC';
 		$sql_aray[] = 'SELECT name, hits FROM ' . $tables['archive'] . ' WHERE cat = 9 ORDER BY hits DESC';
 
 		$pagination = $phpbb_container->get('pagination');
```
