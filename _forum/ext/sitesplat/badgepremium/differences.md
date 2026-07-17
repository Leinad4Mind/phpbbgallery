Existem diferencas reais no codigo ou texto. Diferencas de formatacao (espacos, tabs) foram ignoradas abaixo.

```diff
diff --git "[ORIGINAL]/sitesplat\\badgepremium/conditions/type/bbpoints.php" "[FORUM_EXT]/sitesplat\\badgepremium/conditions/type/bbpoints.php"
--- "[ORIGINAL]/sitesplat\\badgepremium/conditions/type/bbpoints.php"
+++ "[FORUM_EXT]/sitesplat\\badgepremium/conditions/type/bbpoints.php"
@@ -101,6 +101,7 @@ class bbpoints extends \sitesplat\badge\conditions\type\base
 				SELECT poster_id AS user_id, SUM(bbpoints) AS points FROM ' . POSTS_TABLE . ' WHERE post_visibility = 1 GROUP BY poster_id) t1 
 				ON t1.user_id = u.user_id 
 				WHERE ' . $this->db->sql_in_set('u.user_type', array(USER_INACTIVE, USER_IGNORE), true) . '
+				AND u.user_posts >= 1
 				AND ' . $this->db->sql_in_set('u.user_id', $user_ids, $sync, true) . '
 				GROUP BY user_id 
 				ORDER BY bbpoints DESC ';
diff --git "[FORUM_EXT]/sitesplat\\badgepremium/diff_full.tmp" "[FORUM_EXT]/sitesplat\\badgepremium/diff_full.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\badgepremium/diff_full.tmp"
@@ -0,0 +1,123 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\badgepremium/conditions/type/bbpoints.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\badgepremium/conditions/type/bbpoints.php"
+index 7d87fd1e6..c7c747f15 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\badgepremium/conditions/type/bbpoints.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\badgepremium/conditions/type/bbpoints.php"
+@@ -101,6 +101,7 @@ class bbpoints extends \sitesplat\badge\conditions\type\base
+ 				SELECT poster_id AS user_id, SUM(bbpoints) AS points FROM ' . POSTS_TABLE . ' WHERE post_visibility = 1 GROUP BY poster_id) t1 
+ 				ON t1.user_id = u.user_id 
+ 				WHERE ' . $this->db->sql_in_set('u.user_type', array(USER_INACTIVE, USER_IGNORE), true) . '
++				AND u.user_posts >= 1
+ 				AND ' . $this->db->sql_in_set('u.user_id', $user_ids, $sync, true) . '
+ 				GROUP BY user_id 
+ 				ORDER BY bbpoints DESC ';
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\badgepremium/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\badgepremium/diff_full.tmp"
+new file mode 100644
+index 000000000..e69de29bb
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\badgepremium/language/pt/badgepremium.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\badgepremium/language/pt/badgepremium.php"
+new file mode 100644
+index 000000000..ff9508d42
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\badgepremium/language/pt/badgepremium.php"
+@@ -0,0 +1,48 @@
++<?php
++/**
++*
++* BBAwards premium rule PAK.
++* @copyright (c) 2015 SiteSplat <http://www.sitesplat.com>
++* @license SiteSplat 2015 all rights reserved
++*
++**/
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
++	'BADGE_TYPE_BOOKMARKED'			=> 'Favoritos',
++	'BADGE_TYPE_BBPOINTS'			=> 'Pontos',
++	'BADGE_TYPE_CROSS_BADGE'		=> 'Conjuntos',
++	'BADGE_TYPE_POLLS'				=> 'Votações',
++	'BADGE_TYPE_REPORTS'			=> 'Reportar',
++	'BADGE_TYPE_SUBSCRIBED'			=> 'Subscritos',
++	'BADGE_TYPE_TOPICS'				=> 'Tópicos',
++
++	'BADGEAUTO_TYPE_BOOKMARKED'		=> 'Medalha Favoritos',
++	'BADGEAUTO_TYPE_BBPOINTS'		=> 'Medalha Pontos',
++	'BADGEAUTO_TYPE_CROSS_BADGE'	=> 'Medalha Conjuntos',
++	'BADGEAUTO_TYPE_POLLS'			=> 'Medalha Votações',
++	'BADGEAUTO_TYPE_REPORTS'		=> 'Medalha Reportar',
++	'BADGEAUTO_TYPE_SUBSCRIBED'		=> 'Medalha Subscritos',
++	'BADGEAUTO_TYPE_TOPICS'			=> 'Medalha Tópicos',
++
++	'BOOKMARKED_EXPLAIN'			=> 'Award badges to topic-starters whose topic is bookmarked by members',
++	'BBPOINTS_EXPLAIN'				=> 'Award badges to users with BBpoints',
++	'CROSS_BADGE_EXPLAIN'			=> 'Award badges to specific rules',
++	'POLLS_EXPLAIN'					=> 'Award badges to posters who made a poll',
++	'REPORTS_EXPLAIN'				=> 'Award badges to reporters',
++	'SUBSCRIBED_EXPLAIN'			=> 'Award badges to topic-starters who`s topics are subscribed by members',
++	'TOPICS_EXPLAIN'				=> 'Award badges to topic-starters',
++
++	'ACP_BADGE_RULESLIST'			=> 'Rules-list',
++	'ACP_BADGE_RULESLIST_EXPLAIN'	=> 'Select multiple rules by holding CTRL and clicking.',
++	'BADGE_PREMIUM_NOTICE'			=> '<div><p>The Setting for this extension are in <strong>%1$s » %2$s » %3$s</strong>.</p></div>',
++));
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\badgepremium/language/pt_preao/badgepremium.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\badgepremium/language/pt_preao/badgepremium.php"
+new file mode 100644
+index 000000000..ff9508d42
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\badgepremium/language/pt_preao/badgepremium.php"
+@@ -0,0 +1,48 @@
++<?php
++/**
++*
++* BBAwards premium rule PAK.
++* @copyright (c) 2015 SiteSplat <http://www.sitesplat.com>
++* @license SiteSplat 2015 all rights reserved
++*
++**/
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
++	'BADGE_TYPE_BOOKMARKED'			=> 'Favoritos',
++	'BADGE_TYPE_BBPOINTS'			=> 'Pontos',
++	'BADGE_TYPE_CROSS_BADGE'		=> 'Conjuntos',
++	'BADGE_TYPE_POLLS'				=> 'Votações',
++	'BADGE_TYPE_REPORTS'			=> 'Reportar',
++	'BADGE_TYPE_SUBSCRIBED'			=> 'Subscritos',
++	'BADGE_TYPE_TOPICS'				=> 'Tópicos',
++
++	'BADGEAUTO_TYPE_BOOKMARKED'		=> 'Medalha Favoritos',
++	'BADGEAUTO_TYPE_BBPOINTS'		=> 'Medalha Pontos',
++	'BADGEAUTO_TYPE_CROSS_BADGE'	=> 'Medalha Conjuntos',
++	'BADGEAUTO_TYPE_POLLS'			=> 'Medalha Votações',
++	'BADGEAUTO_TYPE_REPORTS'		=> 'Medalha Reportar',
++	'BADGEAUTO_TYPE_SUBSCRIBED'		=> 'Medalha Subscritos',
++	'BADGEAUTO_TYPE_TOPICS'			=> 'Medalha Tópicos',
++
++	'BOOKMARKED_EXPLAIN'			=> 'Award badges to topic-starters whose topic is bookmarked by members',
++	'BBPOINTS_EXPLAIN'				=> 'Award badges to users with BBpoints',
++	'CROSS_BADGE_EXPLAIN'			=> 'Award badges to specific rules',
++	'POLLS_EXPLAIN'					=> 'Award badges to posters who made a poll',
++	'REPORTS_EXPLAIN'				=> 'Award badges to reporters',
++	'SUBSCRIBED_EXPLAIN'			=> 'Award badges to topic-starters who`s topics are subscribed by members',
++	'TOPICS_EXPLAIN'				=> 'Award badges to topic-starters',
++
++	'ACP_BADGE_RULESLIST'			=> 'Rules-list',
++	'ACP_BADGE_RULESLIST_EXPLAIN'	=> 'Select multiple rules by holding CTRL and clicking.',
++	'BADGE_PREMIUM_NOTICE'			=> '<div><p>The Setting for this extension are in <strong>%1$s » %2$s » %3$s</strong>.</p></div>',
++));
diff --git "[FORUM_EXT]/sitesplat\\badgepremium/diff_nospace.tmp" "[FORUM_EXT]/sitesplat\\badgepremium/diff_nospace.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\badgepremium/diff_nospace.tmp"
@@ -0,0 +1,70 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\badgepremium/conditions/type/bbpoints.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\badgepremium/conditions/type/bbpoints.php"
+index 7d87fd1e6..c7c747f15 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\badgepremium/conditions/type/bbpoints.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\badgepremium/conditions/type/bbpoints.php"
+@@ -101,6 +101,7 @@ class bbpoints extends \sitesplat\badge\conditions\type\base
+ 				SELECT poster_id AS user_id, SUM(bbpoints) AS points FROM ' . POSTS_TABLE . ' WHERE post_visibility = 1 GROUP BY poster_id) t1 
+ 				ON t1.user_id = u.user_id 
+ 				WHERE ' . $this->db->sql_in_set('u.user_type', array(USER_INACTIVE, USER_IGNORE), true) . '
++				AND u.user_posts >= 1
+ 				AND ' . $this->db->sql_in_set('u.user_id', $user_ids, $sync, true) . '
+ 				GROUP BY user_id 
+ 				ORDER BY bbpoints DESC ';
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\badgepremium/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\badgepremium/diff_full.tmp"
+new file mode 100644
+index 000000000..49080a71b
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\badgepremium/diff_full.tmp"
+@@ -0,0 +1,123 @@
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\badgepremium/conditions/type/bbpoints.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\badgepremium/conditions/type/bbpoints.php"
++index 7d87fd1e6..c7c747f15 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\badgepremium/conditions/type/bbpoints.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\badgepremium/conditions/type/bbpoints.php"
++@@ -101,6 +101,7 @@ class bbpoints extends \sitesplat\badge\conditions\type\base
++ 				SELECT poster_id AS user_id, SUM(bbpoints) AS points FROM ' . POSTS_TABLE . ' WHERE post_visibility = 1 GROUP BY poster_id) t1 
++ 				ON t1.user_id = u.user_id 
++ 				WHERE ' . $this->db->sql_in_set('u.user_type', array(USER_INACTIVE, USER_IGNORE), true) . '
+++				AND u.user_posts >= 1
++ 				AND ' . $this->db->sql_in_set('u.user_id', $user_ids, $sync, true) . '
++ 				GROUP BY user_id 
++ 				ORDER BY bbpoints DESC ';
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\badgepremium/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\badgepremium/diff_full.tmp"
++new file mode 100644
++index 000000000..e69de29bb
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\badgepremium/language/pt/badgepremium.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\badgepremium/language/pt/badgepremium.php"
++new file mode 100644
++index 000000000..ff9508d42
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\badgepremium/language/pt/badgepremium.php"
++@@ -0,0 +1,48 @@
+++<?php
+++/**
+++*
+++* BBAwards premium rule PAK.
+++* @copyright (c) 2015 SiteSplat <http://www.sitesplat.com>
+++* @license SiteSplat 2015 all rights reserved
+++*
+++**/
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
+++	'BADGE_TYPE_BOOKMARKED'			=> 'Favoritos',
+++	'BADGE_TYPE_BBPOINTS'			=> 'Pontos',
+++	'BADGE_TYPE_CROSS_BADGE'		=> 'Conjuntos',
+++	'BADGE_TYPE_POLLS'				=> 'Votações',
+++	'BADGE_TYPE_REPORTS'			=> 'Reportar',
+++	'BADGE_TYPE_SUBSCRIBED'			=> 'Subscritos',
+++	'BADGE_TYPE_TOPICS'				=> 'Tópicos',
+++
+++	'BADGEAUTO_TYPE_BOOKMARKED'		=> 'Medalha Favoritos',
+++	'BADGEAUTO_TYPE_BBPOINTS'		=> 'Medalha Pontos',
+++	'BADGEAUTO_TYPE_CROSS_BADGE'	=> 'Medalha Conj
\ No newline at end of file
diff --git "[FORUM_EXT]/sitesplat\\badgepremium/language/pt/badgepremium.php" "[FORUM_EXT]/sitesplat\\badgepremium/language/pt/badgepremium.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\badgepremium/language/pt/badgepremium.php"
@@ -0,0 +1,48 @@
+<?php
+/**
+*
+* BBAwards premium rule PAK.
+* @copyright (c) 2015 SiteSplat <http://www.sitesplat.com>
+* @license SiteSplat 2015 all rights reserved
+*
+**/
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
+	'BADGE_TYPE_BOOKMARKED'			=> 'Favoritos',
+	'BADGE_TYPE_BBPOINTS'			=> 'Pontos',
+	'BADGE_TYPE_CROSS_BADGE'		=> 'Conjuntos',
+	'BADGE_TYPE_POLLS'				=> 'Votações',
+	'BADGE_TYPE_REPORTS'			=> 'Reportar',
+	'BADGE_TYPE_SUBSCRIBED'			=> 'Subscritos',
+	'BADGE_TYPE_TOPICS'				=> 'Tópicos',
+
+	'BADGEAUTO_TYPE_BOOKMARKED'		=> 'Medalha Favoritos',
+	'BADGEAUTO_TYPE_BBPOINTS'		=> 'Medalha Pontos',
+	'BADGEAUTO_TYPE_CROSS_BADGE'	=> 'Medalha Conjuntos',
+	'BADGEAUTO_TYPE_POLLS'			=> 'Medalha Votações',
+	'BADGEAUTO_TYPE_REPORTS'		=> 'Medalha Reportar',
+	'BADGEAUTO_TYPE_SUBSCRIBED'		=> 'Medalha Subscritos',
+	'BADGEAUTO_TYPE_TOPICS'			=> 'Medalha Tópicos',
+
+	'BOOKMARKED_EXPLAIN'			=> 'Award badges to topic-starters whose topic is bookmarked by members',
+	'BBPOINTS_EXPLAIN'				=> 'Award badges to users with BBpoints',
+	'CROSS_BADGE_EXPLAIN'			=> 'Award badges to specific rules',
+	'POLLS_EXPLAIN'					=> 'Award badges to posters who made a poll',
+	'REPORTS_EXPLAIN'				=> 'Award badges to reporters',
+	'SUBSCRIBED_EXPLAIN'			=> 'Award badges to topic-starters who`s topics are subscribed by members',
+	'TOPICS_EXPLAIN'				=> 'Award badges to topic-starters',
+
+	'ACP_BADGE_RULESLIST'			=> 'Rules-list',
+	'ACP_BADGE_RULESLIST_EXPLAIN'	=> 'Select multiple rules by holding CTRL and clicking.',
+	'BADGE_PREMIUM_NOTICE'			=> '<div><p>The Setting for this extension are in <strong>%1$s » %2$s » %3$s</strong>.</p></div>',
+));
diff --git "[FORUM_EXT]/sitesplat\\badgepremium/language/pt_preao/badgepremium.php" "[FORUM_EXT]/sitesplat\\badgepremium/language/pt_preao/badgepremium.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\badgepremium/language/pt_preao/badgepremium.php"
@@ -0,0 +1,48 @@
+<?php
+/**
+*
+* BBAwards premium rule PAK.
+* @copyright (c) 2015 SiteSplat <http://www.sitesplat.com>
+* @license SiteSplat 2015 all rights reserved
+*
+**/
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
+	'BADGE_TYPE_BOOKMARKED'			=> 'Favoritos',
+	'BADGE_TYPE_BBPOINTS'			=> 'Pontos',
+	'BADGE_TYPE_CROSS_BADGE'		=> 'Conjuntos',
+	'BADGE_TYPE_POLLS'				=> 'Votações',
+	'BADGE_TYPE_REPORTS'			=> 'Reportar',
+	'BADGE_TYPE_SUBSCRIBED'			=> 'Subscritos',
+	'BADGE_TYPE_TOPICS'				=> 'Tópicos',
+
+	'BADGEAUTO_TYPE_BOOKMARKED'		=> 'Medalha Favoritos',
+	'BADGEAUTO_TYPE_BBPOINTS'		=> 'Medalha Pontos',
+	'BADGEAUTO_TYPE_CROSS_BADGE'	=> 'Medalha Conjuntos',
+	'BADGEAUTO_TYPE_POLLS'			=> 'Medalha Votações',
+	'BADGEAUTO_TYPE_REPORTS'		=> 'Medalha Reportar',
+	'BADGEAUTO_TYPE_SUBSCRIBED'		=> 'Medalha Subscritos',
+	'BADGEAUTO_TYPE_TOPICS'			=> 'Medalha Tópicos',
+
+	'BOOKMARKED_EXPLAIN'			=> 'Award badges to topic-starters whose topic is bookmarked by members',
+	'BBPOINTS_EXPLAIN'				=> 'Award badges to users with BBpoints',
+	'CROSS_BADGE_EXPLAIN'			=> 'Award badges to specific rules',
+	'POLLS_EXPLAIN'					=> 'Award badges to posters who made a poll',
+	'REPORTS_EXPLAIN'				=> 'Award badges to reporters',
+	'SUBSCRIBED_EXPLAIN'			=> 'Award badges to topic-starters who`s topics are subscribed by members',
+	'TOPICS_EXPLAIN'				=> 'Award badges to topic-starters',
+
+	'ACP_BADGE_RULESLIST'			=> 'Rules-list',
+	'ACP_BADGE_RULESLIST_EXPLAIN'	=> 'Select multiple rules by holding CTRL and clicking.',
+	'BADGE_PREMIUM_NOTICE'			=> '<div><p>The Setting for this extension are in <strong>%1$s » %2$s » %3$s</strong>.</p></div>',
+));
```
