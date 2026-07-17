Existem diferencas reais no codigo ou texto. Diferencas de formatacao (espacos, tabs) foram ignoradas abaixo.

```diff
diff --git "[FORUM_EXT]/leinad4mind\\limitperforum/diff_full.tmp" "[FORUM_EXT]/leinad4mind\\limitperforum/diff_full.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/leinad4mind\\limitperforum/diff_full.tmp"
@@ -0,0 +1,368 @@
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\limitperforum/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\limitperforum/diff_full.tmp"
+new file mode 100644
+index 000000000..e69de29bb
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\limitperforum/event/main_listener.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\limitperforum/event/main_listener.php"
+index f0545cf79..5f5fe08c8 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\limitperforum/event/main_listener.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\limitperforum/event/main_listener.php"
+@@ -271,7 +271,7 @@ class main_listener implements EventSubscriberInterface
+ 
+ 		foreach (get_forum_branch((int) $forum_id, 'children') as $subforum)
+ 		{
+-			if ($subforum['parent_id'] == $forum_id)
++			if ($subforum['forum_id'] != 223 & $subforum['parent_id'] == $forum_id)
+ 			{
+ 				$subforum_ids[] = $subforum['forum_id'];
+ 			}
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\limitperforum/language/pt/acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\limitperforum/language/pt/acp.php"
+new file mode 100644
+index 000000000..2b9100b88
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\limitperforum/language/pt/acp.php"
+@@ -0,0 +1,52 @@
++<?php
++
++/**
++ *
++ * Limit Posts and Topics per Forum. An extension for the phpBB Forum Software package.
++ *
++ * @copyright (c) 2019-2020, Leinad4Mind, https://leinad4mind.top/forum
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
++
++$lang = array_merge($lang, [
++	'LIMIT_PER_FORUM'				=> 'Limit Posts per Forum',
++	'FORUM_MAX_POSTS'				=> 'Maximum count of posts per user',
++	'FORUM_MAX_POSTS_SHORT'			=> 'Post limit',
++	'FORUM_MAX_TOPICS'				=> 'Maximum count of topics per user',
++	'FORUM_MAX_TOPICS_SHORT'		=> 'Topic limit',
++	'FORUM_MAX_GROUPS'				=> 'Group limits',
++	'FORUM_MAX_GROUPS_EXPLAIN'		=> 'Group limits override the limits above. Set hours to 0 to disable time limit.',
++	'FORUM_MAX_TOPICS_EXPLAIN'		=> 'Should be lower than the maximum post count unless if it is set to 0',
++	'FORUM_MAX_TOPICS_ERROR'		=> 'The maximum of topic per forums should be lower than the maximum of post per forums',
++	'FORUM_MAX_TP_EXPLAIN'			=> 'Set 0 to disable. Set hours to 0 to disable time limit.',
++	'LIMIT_POSTS_PER_FORUM_TOPICS'	=> 'topics',
++	'LIMIT_POSTS_PER_FORUM_POSTS'	=> 'posts',
++	'LIMIT_POSTS_PER_FORUM_EVERY'	=> 'every',
++	'LIMIT_POSTS_PER_FORUM_HOURS'	=> 'hours',
++]);
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\limitperforum/language/pt/common.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\limitperforum/language/pt/common.php"
+new file mode 100644
+index 000000000..3ee43ebf4
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\limitperforum/language/pt/common.php"
+@@ -0,0 +1,66 @@
++<?php
++
++/**
++ *
++ * Limit Posts per Forum. An extension for the phpBB Forum Software package.
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
++
++$lang = array_merge($lang, [
++	'ERROR_POST_COUNT'			=> [
++		1 => 'Não podes adicionar uma nova mensagem, já atingiste o limite de 1 mensagem permitida neste fórum.',
++		2 => 'Não podes adicionar uma nova mensagem, já atingiste o limite de %1$d mensagens permitidas neste fórum.',
++	],
++	'ERROR_POST_COUNT_TIME'	=> [
++		1 => 'Não podes adicionar uma nova mensagem, já atingiste o limite de 1 mensagem permitida por cada %2$d hora(s) neste fórum.',
++		2 => 'Não podes adicionar uma nova mensagem, já atingiste o limite de %1$d mensagens permitidas por cada %2$d hora(s) neste fórum.',
++	],
++	'ERROR_TOPIC_COUNT'			=> [
++		1 => 'Não podes criar um novo tópico, já atingiste o limite de 1 tópico permitido neste fórum.',
++		2 => 'Não podes criar um novo tópico, já atingiste o limite de %1$d tópicos permitidos neste fórum.',
++	],
++	'ERROR_TOPIC_COUNT_TIME'	=> [
++		1 => 'Não podes criar um novo tópico, já atingiste o limite de 1 tópico permitido por cada %2$d hora(s) neste fórum.',
++		2 => 'Não podes criar um novo tópico, já atingiste o limite de %1$d tópicos permitidos por cada %2$d hora(s) neste fórum.',
++	],
++	'ERROR_POST_REST'			=> [
++		1 => 'Podes adicionar mais <strong class="error">1</strong> nova mensagem neste fórum antes que sejas bloqueado de colocar novas mensagens.',
++		2 => 'Podes adicionar <strong class="error">%1$d</strong> novas mensagens neste fórum antes que sejas bloqueado de colocar novas mensagens.',
++	],
++	'ERROR_TOPIC_REST'			=> [
++		1 => 'Podes adicionar <strong class="error">1</strong> novo tópico neste fórum antes que sejas bloqueado de colocar novos tópicos.',
++		2 => 'Podes adicionar <strong class="error">%1$d</strong> novos tópicos neste fórum antes que sejas bloqueado de colocar novos tópicos.',
++	],
++	'ERROR_POST_TOPIC_REST'		=> 'Podes adicionar <strong class="error">%1$d</strong> novo tópico e <strong class="error">%2$d</strong> nova mensagem neste fórum antes que sejas bloqueado de criar novas mensagens.',
++	'ERROR_POSTS_TOPIC_REST'	=> 'Podes adicionar <strong class="error">%1$d</strong> novo tópico e <strong class="error">%2$d</strong> novas mensagens neste fórum antes que sejas bloqueado de criar novas mensagens.',
++	'ERROR_POST_TOPICS_REST'	=> 'Podes adicionar <strong class="error">%1$d</strong> novos tópicos e <strong class="error">%2$d</strong> nova mensagem neste fórum antes que sejas bloqueado de criar novas mensagens.',
++	'ERROR_POSTS_TOPICS_REST'	=> 'Podes adicionar <strong class="error">%1$s</strong> novos tópicos e <strong class="error">%2$s</strong> novas mensagens neste fórum antes que sejas bloqueado de criar novas mensagens.',
++]);
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\limitperforum/language/pt/info_acp_limitpostsperforum.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\limitperforum/language/pt/info_acp_limitpostsperforum.php"
+new file mode 100644
+index 000000000..876ad2fbe
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\limitperforum/language/pt/info_acp_limitpostsperforum.php"
+@@ -0,0 +1,40 @@
++<?php
++
++/**
++ *
++ * Limit Posts and Topics per Forum. An extension for the phpBB Forum Software package.
++ *
++ * @copyright (c) 2019-2020, Leinad4Mind, https://leinad4mind.top/forum
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
++
++$lang = array_merge($lang, [
++	'ACL_F_POST_LIMIT'	=> 'Can ignore post count limit',
++	'ACL_F_TOPIC_LIMIT'	=> 'Can ignore topic count limit',
++]);
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\limitperforum/language/pt_preao/acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\limitperforum/language/pt_preao/acp.php"
+new file mode 100644
+index 000000000..2b9100b88
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\limitperforum/language/pt_preao/acp.php"
+@@ -0,0 +1,52 @@
++<?php
++
++/**
++ *
++ * Limit Posts and Topics per Forum. An extension for the phpBB Forum Software package.
++ *
++ * @copyright (c) 2019-2020, Leinad4Mind, https://leinad4mind.top/forum
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
++
++$lang = array_merge($lang, [
++	'LIMIT_PER_FORUM'				=> 'Limit Posts per Forum',
++	'FORUM_MAX_POSTS'				=> 'Maximum count of posts per user',
++	'FORUM_MAX_POSTS_SHORT'			=> 'Post limit',
++	'FORUM_MAX_TOPICS'				=> 'Maximum count of topics per user',
++	'FORUM_MAX_TOPICS_SHORT'		=> 'Topic limit',
++	'FORUM_MAX_GROUPS'				=> 'Group limits',
++	'FORUM_MAX_GROUPS_EXPLAIN'		=> 'Group limits override the limits above. Set hours to 0 to disable time limit.',
++	'FORUM_MAX_TOPICS_EXPLAIN'		=> 'Should be lower than the maximum post count unless if it is set to 0',
++	'FORUM_MAX_TOPICS_ERROR'		=> 'The maximum of topic per forums should be lower than the maximum of post per forums',
++	'FORUM_MAX_TP_EXPLAIN'			=> 'Set 0 to disable. Set hours to 0 to disable time limit.',
++	'LIMIT_POSTS_PER_FORUM_TOPICS'	=> 'topics',
++	'LIMIT_POSTS_PER_FORUM_POSTS'	=> 'posts',
++	'LIMIT_POSTS_PER_FORUM_EVERY'	=> 'every',
++	'LIMIT_POSTS_PER_FORUM_HOURS'	=> 'hours',
++]);
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\limitperforum/language/pt_preao/common.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\limitperforum/language/pt_preao/common.php"
+new file mode 100644
+index 000000000..3ee43ebf4
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\limitperforum/language/pt_preao/common.php"
+@@ -0,0 +1,66 @@
++<?php
++
++/**
++ *
++ * Limit Posts per Forum. An extension for the phpBB Forum Software package.
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
++
++$lang = array_merge($lang, [
++	'ERROR_POST_COUNT'			=> [
++		1 => 'Não podes adicionar uma nova mensagem, já atingiste o limite de 1 mensagem permitida neste fórum.',
++		2 => 'Não podes adicionar uma nova mensagem, já atingiste o limite de %1$d mensagens permitidas neste fórum.',
++	],
++	'ERROR_POST_COUNT_TIME'	=> [
++		1 => 'Não podes adicionar uma nova mensagem, já atingiste o limite de 1 mensagem permitida por cada %2$d hora(s) neste fórum.',
++		2 => 'Não podes adicionar uma nova mensagem, já atingiste o limite de %1$d mensagens permitidas por cada %2$d hora(s) neste fórum.',
++	],
++	'ERROR_TOPIC_COUNT'			=> [
++		1 => 'Não podes criar um novo tópico, já atingiste o limite de 1 tópico permitido neste fórum.',
++		2 => 'Não podes criar um novo tópico, já atingiste o limite de %1$d tópicos permitidos neste fórum.',
++	],
++	'ERROR_TOPIC_COUNT_TIME'	=> [
++		1 => 'Não podes criar um novo tópico, já atingiste o limite de 1 tópico permitido por cada %2$d hora(s) neste fórum.',
++		2 => 'Não podes criar um novo tópico, já atingiste o limite de %1$d tópicos permitidos por cada %2$d hora(s) neste fórum.',
++	],
++	'ERROR_POST_REST'			=> [
++		1 => 'Podes adicionar mais <strong class="error">1</strong> nova mensagem neste fórum antes que sejas bloqueado de colocar novas mensagens.',
++		2 => 'Podes adicionar <strong class="error">%1$d</strong> novas mensagens neste fórum antes que sejas bloqueado de colocar novas mensagens.',
++	],
++	'ERROR_TOPIC_REST'			=> [
++		1 => 'Podes adicionar <strong class="error">1</strong> novo tópico neste fórum antes que sejas bloqueado de colocar novos tópicos.',
++		2 => 'Podes adicionar <strong class="error">%1$d</strong> novos tópicos neste fórum antes que sejas bloqueado de colocar novos tópicos.',
++	],
++	'ERROR_POST_TOPIC_REST'		=> 'Podes adicionar <strong class="error">%1$d</strong> novo tópico e <strong class="error">%2$d</strong> nova mensagem neste fórum antes que sejas bloqueado de criar novas mensagens.',
++	'ERROR_POSTS_TOPIC_REST'	=> 'Podes adicionar <strong class="error">%1$d</strong> novo tópico e <strong class="error">%2$d</strong> novas mensagens neste fórum antes que sejas bloqueado de criar novas mensagens.',
++	'ERROR_POST_TOPICS_REST'	=> 'Podes adicionar <strong class="error">%1$d</strong> novos tópicos e <strong class="error">%2$d</strong> nova mensagem neste fórum antes que sejas bloqueado de criar novas mensagens.',
++	'ERROR_POSTS_TOPICS_REST'	=> 'Podes adicionar <strong class="error">%1$s</strong> novos tópicos e <strong class="error">%2$s</strong> novas mensagens neste fórum antes que sejas bloqueado de criar novas mensagens.',
++]);
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\limitperforum/language/pt_preao/info_acp_limitpostsperforum.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\limitperforum/language/pt_preao/info_acp_limitpostsperforum.php"
+new file mode 100644
+index 000000000..876ad2fbe
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\limitperforum/language/pt_preao/info_acp_limitpostsperforum.php"
+@@ -0,0 +1,40 @@
++<?php
++
++/**
++ *
++ * Limit Posts and Topics per Forum. An extension for the phpBB Forum Software package.
++ *
++ * @copyright (c) 2019-2020, Leinad4Mind, https://leinad4mind.top/forum
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
++
++$lang = array_merge($lang, [
++	'ACL_F_POST_LIMIT'	=> 'Can ignore post count limit',
++	'ACL_F_TOPIC_LIMIT'	=> 'Can ignore topic count limit',
++]);
diff --git "[FORUM_EXT]/leinad4mind\\limitperforum/diff_nospace.tmp" "[FORUM_EXT]/leinad4mind\\limitperforum/diff_nospace.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/leinad4mind\\limitperforum/diff_nospace.tmp"
@@ -0,0 +1,325 @@
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\limitperforum/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\limitperforum/diff_full.tmp"
+new file mode 100644
+index 000000000..42dd82fb3
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\limitperforum/diff_full.tmp"
+@@ -0,0 +1,368 @@
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\limitperforum/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\limitperforum/diff_full.tmp"
++new file mode 100644
++index 000000000..e69de29bb
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\limitperforum/event/main_listener.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\limitperforum/event/main_listener.php"
++index f0545cf79..5f5fe08c8 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\limitperforum/event/main_listener.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\limitperforum/event/main_listener.php"
++@@ -271,7 +271,7 @@ class main_listener implements EventSubscriberInterface
++ 
++ 		foreach (get_forum_branch((int) $forum_id, 'children') as $subforum)
++ 		{
++-			if ($subforum['parent_id'] == $forum_id)
+++			if ($subforum['forum_id'] != 223 & $subforum['parent_id'] == $forum_id)
++ 			{
++ 				$subforum_ids[] = $subforum['forum_id'];
++ 			}
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\limitperforum/language/pt/acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\limitperforum/language/pt/acp.php"
++new file mode 100644
++index 000000000..2b9100b88
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\limitperforum/language/pt/acp.php"
++@@ -0,0 +1,52 @@
+++<?php
+++
+++/**
+++ *
+++ * Limit Posts and Topics per Forum. An extension for the phpBB Forum Software package.
+++ *
+++ * @copyright (c) 2019-2020, Leinad4Mind, https://leinad4mind.top/forum
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
+++
+++$lang = array_merge($lang, [
+++	'LIMIT_PER_FORUM'				=> 'Limit Posts per Forum',
+++	'FORUM_MAX_POSTS'				=> 'Maximum count of posts per user',
+++	'FORUM_MAX_POSTS_SHORT'			=> 'Post limit',
+++	'FORUM_MAX_TOPICS'				=> 'Maximum count of topics per user',
+++	'FORUM_MAX_TOPICS_SHORT'		=> 'Topic limit',
+++	'FORUM_MAX_GROUPS'				=> 'Group limits',
+++	'FORUM_MAX_GROUPS_EXPLAIN'		=> 'Group limits override the limits above. Set hours to 0 to disable time limit.',
+++	'FORUM_MAX_TOPICS_EXPLAIN'		=> 'Should be lower than the maximum post count unless if it is set to 0',
+++	'FORUM_MAX_TOPICS_ERROR'		=> 'The maximum of topic per forums should be lower than the maximum of post per forums',
+++	'FORUM_MAX_TP_EXPLAIN'			=> 'Set 0 to disable. Set hours to 0 to disable time limit.',
+++	'LIMIT_POSTS_PER_FORUM_TOPICS'	=> 'topics',
+++	'LIMIT_POSTS_PER_FORUM_POSTS'	=> 'posts',
+++	'LIMIT_POSTS_PER_FORUM_EVERY'	=> 'every',
+++	'LIMIT_POSTS_PER_FORUM_HOURS'	=> 'hours',
+++]);
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\limitperforum/language/pt/common.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\limitperforum/language/pt/common.php"
++new file mode 100644
++index 000000000..3ee43ebf4
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\limitperforum/language/pt/common.php"
++@@ -0,0 +1,66 @@
+++<?php
+++
+++/**
+++ *
+++ * Limit Posts per Forum. An extension for the phpBB Forum Software package.
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
+++
+++$lang = array_merge($lang, [
+++	'ERROR_POST_COUNT'			=> [
+++		1 => 'Não podes adicionar uma nova mensagem, já atingiste o limite de 1 mensagem permitida neste fórum.',
+++		2 => 'Não podes adicionar uma nova mensagem, já atingiste o limite de %1$d mensagens permitidas neste fórum.',
+++	],
+++	'ERROR_POST_COUNT_TIME'	=> [
+++		1 => 'Não podes adicionar uma nova mensagem, já atingiste o limite de 1 mensagem permitida por cada %2$d hora(s) neste fórum.',
+++		2 => 'Não podes adicionar uma nova mensagem, já atingiste o limite de %1$d mensagens permitidas por cada %2$d hora(s) neste fórum.',
+++	],
+++	'ERROR_TOPIC_COUNT'			=> [
+++		1 => 'Não podes criar um novo tópico, já atingiste o limite de 1 tópico permitido neste fórum.',
+++		2 => 'Não podes criar um novo tópico, já atingiste o limite de %1$d tópicos permitidos neste fórum.',
+++	],
+++	'ERROR_TOPIC_COUNT_TIME'	=> [
+++		1 => 'Não podes criar um novo tópico, já atingiste o limite de 1 tópico permitido por cada %2$d hora(s) neste fórum.',
+++		2 => 'Não podes criar um novo tópico, já atingiste o limite de %1$d tópicos permitidos por cada %2$d hora(s) neste fórum.',
+++	],
+++	'ERROR_POST_REST'			=> [
+++		1 => 'Podes adicionar mais <strong class="error">1</strong> nova mensagem neste fórum antes que sejas bloqueado de colocar novas mensagens.',
+++		2 => 'Podes adicionar <strong class="error">%1$d</strong> novas mensagens neste fórum antes que sejas bloqueado de colocar novas mensagens.',
+++	],
+++	'ERROR_TOPIC_REST'			=> [
+++		1 => 'Podes adicionar <strong class="error">1</strong> novo tópico neste fórum antes que sejas bloqueado de colocar novos tópicos.',
+++		2 => 'Podes adicionar <strong class="error">%1$d</strong> novos tópicos neste fórum antes que sejas bloqueado de colocar novos tópicos.',
+++	],
+++	'ERROR_POST_TOPIC_REST'		=> 'Podes adicionar <strong class="error">%1$d</strong> novo tópico e <strong class="error">%2$d</strong> nova mensagem neste fórum antes que sejas bloqueado de criar novas mensagens.',
+++	'ERROR_POSTS_TOPIC_REST'	=> 'Podes adicionar <strong class="error">%1$d</strong> novo tópico e <strong class="error">%2$d</strong> novas mensagens neste fórum antes que sejas bloqueado de criar novas mensagens.',
+++	'ERROR_POST_TOPICS_REST'	=> 'Podes adicionar <strong class="error">%1$d</strong> novos tópicos e <strong class="error">%2$d</strong> nova mensagem neste fórum antes que sejas bloqueado de criar novas mensagens.',
+++	'ERROR_POSTS_TOPICS_REST'	=> 'Podes adicionar <strong class="error">%1$s</strong> novos tópicos e <strong class="error">%2$s</strong> novas mensagens neste fórum antes que sejas bloqueado de criar novas mensagens.',
+++]);
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\limitperforum/language/pt/info_acp_limitpostsperforum.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\limitperforum/language/pt/info_acp_limitpostsperforum.php"
++new file mode 100644
++index 000000000..876ad2fbe
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\limitperforum/language/pt/info_acp_limitpostsperforum.php"
++@@ -0,0 +1,40 @@
+++<?php
+++
+++/**
+++ *
+++ * Limit Posts and Topics per Forum. An extension for the phpBB Forum Software package.
+++ *
+++ * @copyright (c) 2019-2020, Leinad4Mind, https://leinad4mind.top/forum
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
+++
+++$lang = array_merge($lang, [
+++	'ACL_F_POST_LIMIT'	=> 'Can ignore post count limit',
+++	'ACL_F_TOPIC_LIMIT'	=> 'Can ignore topic count limit',
+++]);
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\limitperforum/language/pt_preao/acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\limitperforum/language/pt_preao/acp.php"
++new file mode 100644
++index 000000000..2b9100b88
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\limitperforum/language/pt_preao/acp.php"
++@@ -0,0 +1,52 @@
+++<?php
+++
+++/**
+++ *
+++ * Limit Posts and Topics per Forum. An extension for the phpBB Forum Software package.
+++ *
+++ * @copyright (c) 2019-2020, Leinad4Mind, https://leinad4mind.top/forum
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
+++
+++$lang = array_merge($lang, [
+++	'LIMIT_PER_FORUM'				=> 'Limit Posts per Forum',
+++	'FORUM_MAX_POSTS'				=> 'Maximum count of posts per user',
+++	'FORUM_MAX_POSTS_SHORT'			=> 'Post limit',
+++	'FORUM_MAX_TOPICS'				=> 'Maximum count of topics per user',
+++	'FORUM_MAX_TOPICS_SHORT'		=> 'Topic limit',
+++	'FORUM_MAX_GROUPS'				=> 'Group limits',
+++	'FORUM_MAX_GROUPS_EXPLAIN'		=> 'Group limits override the limits above. Set hours to 0 to disable time limit.',
+++	'FORUM_MAX_TOPICS_EXPLAIN'		=> 'Should be lower than the maximum post count unless if it is set to 0',
+++	'FORUM_MAX_TOPICS_ERROR'		=> 'The maximum of topic per forums should be lower than the maximum of post per forums',
+++	'FORUM_MAX_TP_EXPLAIN'			=> 'Set 0 to disable. Set hours to 0 to disable time limit.',
+++	'LIMIT_POSTS_PER_FORUM_TOPICS'	=> 'topics',
+++	'LIMIT_POSTS_PER_FORUM_POSTS'	=> 'posts',
+++	'LIMIT_POSTS_PER_FORUM_EVERY'	=> 'every',
+++	'LIMIT_POSTS_PER_FORUM_HOURS'	=> 'hours',
+++]);
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\limitperforum/language/pt_preao/common.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\limitperforum/language/pt_preao/common.php"
++new file mode 100644
++index 000000000..3ee43ebf4
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\limitperforum/language/pt_preao/common.php"
++@@ -0,0 +1,66 @@
+++<?php
+++
+++/**
+++ *
+++ * Limit Posts per Forum. An extension for the phpBB Forum Software package.
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
+++
+++$lang = array_merge($lang, [
+++	'ERROR_POST_COUNT'			=> [
+++		1 => 'Não podes adicionar uma nova mensagem, já atingiste o limite de 1 mensagem permitida neste fórum.',
+++		2 => 'Não podes adicionar uma nova mensagem, já atingiste o limite de %1$d mensagens permitidas neste fórum.',
+++	],
+++	'ERROR_POST_COUNT_TIME'	=> [
+++		1 => 'Não podes adicionar uma nova mensagem, já atingiste o limite de 1 mensagem permitida por cada %2$d hora(s) neste fórum.',
+++		2 => 'Não podes adicionar uma nova mensagem, já atingiste o limite de %1$d mensagens permitidas por cada %2$d hora(s) neste fórum.',
+++	],
+++	'ERROR_TOPIC_COUNT'			=> [
+++		1 => 'Não podes criar um novo tópico, já atingiste o limite de 1 tópico permitido neste fórum.',
+++		2 => 'Não podes criar um novo tópico, já atingiste o limite de %1$d tópicos permitidos neste fórum.',
+++	],
+++	'ERROR_TOPIC_COUNT_TIME'	=> [
+++		1 => 'Não podes criar um novo tópico, já atingiste o limite de 1 tópico permitido por cada %2$d hora(s) neste fórum.',
+++		2 => 'Não podes criar um novo tópico, já atingiste o limite de %1$d tópicos permitidos por cada %2$d hora(s) neste fórum.',
+++	],
+++	'ERROR_POST_REST'			=> [
+++		1 => 'Podes adicionar mais <strong class="error">1</strong> nova mensagem neste fórum antes que sejas bloqueado de colocar novas mensagens.',
+++		2 => 'Podes adicionar <strong class="error">%1$d</strong> novas mensagens neste fórum antes que sejas bloqueado de colocar novas mensagens.',
+++	],
+++	'ERROR_TOPIC_REST'			=> [
+++		1 => 'Podes adicionar <strong class="error">1</strong> novo tópico neste fórum antes que sejas bloqueado de colocar novos tópicos.',
+++		2 => 'Podes adicionar <strong class="error">%1$d</strong> novos tópicos neste fórum antes que sejas bloqueado de colocar novos tópicos.',
+++	],
+++	'ERROR_POST_TOPIC_REST'		=> 'Podes adicionar <strong class="error">%1$d</strong> novo tópico e <strong class="error">%2$d</strong> nova mensagem neste fórum antes que sejas bloqueado de criar novas mensagens.',
+++	'ERROR_POSTS_TOPIC_REST'	=> 'Podes adicionar <strong class="error">%1$d</s
\ No newline at end of file
diff --git "[ORIGINAL]/leinad4mind\\limitperforum/event/main_listener.php" "[FORUM_EXT]/leinad4mind\\limitperforum/event/main_listener.php"
--- "[ORIGINAL]/leinad4mind\\limitperforum/event/main_listener.php"
+++ "[FORUM_EXT]/leinad4mind\\limitperforum/event/main_listener.php"
@@ -271,7 +271,7 @@ class main_listener implements EventSubscriberInterface
 
 		foreach (get_forum_branch((int) $forum_id, 'children') as $subforum)
 		{
-			if ($subforum['parent_id'] == $forum_id)
+			if ($subforum['forum_id'] != 223 & $subforum['parent_id'] == $forum_id)
 			{
 				$subforum_ids[] = $subforum['forum_id'];
 			}
diff --git "[FORUM_EXT]/leinad4mind\\limitperforum/language/pt/acp.php" "[FORUM_EXT]/leinad4mind\\limitperforum/language/pt/acp.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/leinad4mind\\limitperforum/language/pt/acp.php"
@@ -0,0 +1,52 @@
+<?php
+
+/**
+ *
+ * Limit Posts and Topics per Forum. An extension for the phpBB Forum Software package.
+ *
+ * @copyright (c) 2019-2020, Leinad4Mind, https://leinad4mind.top/forum
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
+
+$lang = array_merge($lang, [
+	'LIMIT_PER_FORUM'				=> 'Limit Posts per Forum',
+	'FORUM_MAX_POSTS'				=> 'Maximum count of posts per user',
+	'FORUM_MAX_POSTS_SHORT'			=> 'Post limit',
+	'FORUM_MAX_TOPICS'				=> 'Maximum count of topics per user',
+	'FORUM_MAX_TOPICS_SHORT'		=> 'Topic limit',
+	'FORUM_MAX_GROUPS'				=> 'Group limits',
+	'FORUM_MAX_GROUPS_EXPLAIN'		=> 'Group limits override the limits above. Set hours to 0 to disable time limit.',
+	'FORUM_MAX_TOPICS_EXPLAIN'		=> 'Should be lower than the maximum post count unless if it is set to 0',
+	'FORUM_MAX_TOPICS_ERROR'		=> 'The maximum of topic per forums should be lower than the maximum of post per forums',
+	'FORUM_MAX_TP_EXPLAIN'			=> 'Set 0 to disable. Set hours to 0 to disable time limit.',
+	'LIMIT_POSTS_PER_FORUM_TOPICS'	=> 'topics',
+	'LIMIT_POSTS_PER_FORUM_POSTS'	=> 'posts',
+	'LIMIT_POSTS_PER_FORUM_EVERY'	=> 'every',
+	'LIMIT_POSTS_PER_FORUM_HOURS'	=> 'hours',
+]);
diff --git "[FORUM_EXT]/leinad4mind\\limitperforum/language/pt/common.php" "[FORUM_EXT]/leinad4mind\\limitperforum/language/pt/common.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/leinad4mind\\limitperforum/language/pt/common.php"
@@ -0,0 +1,66 @@
+<?php
+
+/**
+ *
+ * Limit Posts per Forum. An extension for the phpBB Forum Software package.
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
+
+$lang = array_merge($lang, [
+	'ERROR_POST_COUNT'			=> [
+		1 => 'Não podes adicionar uma nova mensagem, já atingiste o limite de 1 mensagem permitida neste fórum.',
+		2 => 'Não podes adicionar uma nova mensagem, já atingiste o limite de %1$d mensagens permitidas neste fórum.',
+	],
+	'ERROR_POST_COUNT_TIME'	=> [
+		1 => 'Não podes adicionar uma nova mensagem, já atingiste o limite de 1 mensagem permitida por cada %2$d hora(s) neste fórum.',
+		2 => 'Não podes adicionar uma nova mensagem, já atingiste o limite de %1$d mensagens permitidas por cada %2$d hora(s) neste fórum.',
+	],
+	'ERROR_TOPIC_COUNT'			=> [
+		1 => 'Não podes criar um novo tópico, já atingiste o limite de 1 tópico permitido neste fórum.',
+		2 => 'Não podes criar um novo tópico, já atingiste o limite de %1$d tópicos permitidos neste fórum.',
+	],
+	'ERROR_TOPIC_COUNT_TIME'	=> [
+		1 => 'Não podes criar um novo tópico, já atingiste o limite de 1 tópico permitido por cada %2$d hora(s) neste fórum.',
+		2 => 'Não podes criar um novo tópico, já atingiste o limite de %1$d tópicos permitidos por cada %2$d hora(s) neste fórum.',
+	],
+	'ERROR_POST_REST'			=> [
+		1 => 'Podes adicionar mais <strong class="error">1</strong> nova mensagem neste fórum antes que sejas bloqueado de colocar novas mensagens.',
+		2 => 'Podes adicionar <strong class="error">%1$d</strong> novas mensagens neste fórum antes que sejas bloqueado de colocar novas mensagens.',
+	],
+	'ERROR_TOPIC_REST'			=> [
+		1 => 'Podes adicionar <strong class="error">1</strong> novo tópico neste fórum antes que sejas bloqueado de colocar novos tópicos.',
+		2 => 'Podes adicionar <strong class="error">%1$d</strong> novos tópicos neste fórum antes que sejas bloqueado de colocar novos tópicos.',
+	],
+	'ERROR_POST_TOPIC_REST'		=> 'Podes adicionar <strong class="error">%1$d</strong> novo tópico e <strong class="error">%2$d</strong> nova mensagem neste fórum antes que sejas bloqueado de criar novas mensagens.',
+	'ERROR_POSTS_TOPIC_REST'	=> 'Podes adicionar <strong class="error">%1$d</strong> novo tópico e <strong class="error">%2$d</strong> novas mensagens neste fórum antes que sejas bloqueado de criar novas mensagens.',
+	'ERROR_POST_TOPICS_REST'	=> 'Podes adicionar <strong class="error">%1$d</strong> novos tópicos e <strong class="error">%2$d</strong> nova mensagem neste fórum antes que sejas bloqueado de criar novas mensagens.',
+	'ERROR_POSTS_TOPICS_REST'	=> 'Podes adicionar <strong class="error">%1$s</strong> novos tópicos e <strong class="error">%2$s</strong> novas mensagens neste fórum antes que sejas bloqueado de criar novas mensagens.',
+]);
diff --git "[FORUM_EXT]/leinad4mind\\limitperforum/language/pt/info_acp_limitpostsperforum.php" "[FORUM_EXT]/leinad4mind\\limitperforum/language/pt/info_acp_limitpostsperforum.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/leinad4mind\\limitperforum/language/pt/info_acp_limitpostsperforum.php"
@@ -0,0 +1,40 @@
+<?php
+
+/**
+ *
+ * Limit Posts and Topics per Forum. An extension for the phpBB Forum Software package.
+ *
+ * @copyright (c) 2019-2020, Leinad4Mind, https://leinad4mind.top/forum
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
+
+$lang = array_merge($lang, [
+	'ACL_F_POST_LIMIT'	=> 'Can ignore post count limit',
+	'ACL_F_TOPIC_LIMIT'	=> 'Can ignore topic count limit',
+]);
diff --git "[FORUM_EXT]/leinad4mind\\limitperforum/language/pt_preao/acp.php" "[FORUM_EXT]/leinad4mind\\limitperforum/language/pt_preao/acp.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/leinad4mind\\limitperforum/language/pt_preao/acp.php"
@@ -0,0 +1,52 @@
+<?php
+
+/**
+ *
+ * Limit Posts and Topics per Forum. An extension for the phpBB Forum Software package.
+ *
+ * @copyright (c) 2019-2020, Leinad4Mind, https://leinad4mind.top/forum
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
+
+$lang = array_merge($lang, [
+	'LIMIT_PER_FORUM'				=> 'Limit Posts per Forum',
+	'FORUM_MAX_POSTS'				=> 'Maximum count of posts per user',
+	'FORUM_MAX_POSTS_SHORT'			=> 'Post limit',
+	'FORUM_MAX_TOPICS'				=> 'Maximum count of topics per user',
+	'FORUM_MAX_TOPICS_SHORT'		=> 'Topic limit',
+	'FORUM_MAX_GROUPS'				=> 'Group limits',
+	'FORUM_MAX_GROUPS_EXPLAIN'		=> 'Group limits override the limits above. Set hours to 0 to disable time limit.',
+	'FORUM_MAX_TOPICS_EXPLAIN'		=> 'Should be lower than the maximum post count unless if it is set to 0',
+	'FORUM_MAX_TOPICS_ERROR'		=> 'The maximum of topic per forums should be lower than the maximum of post per forums',
+	'FORUM_MAX_TP_EXPLAIN'			=> 'Set 0 to disable. Set hours to 0 to disable time limit.',
+	'LIMIT_POSTS_PER_FORUM_TOPICS'	=> 'topics',
+	'LIMIT_POSTS_PER_FORUM_POSTS'	=> 'posts',
+	'LIMIT_POSTS_PER_FORUM_EVERY'	=> 'every',
+	'LIMIT_POSTS_PER_FORUM_HOURS'	=> 'hours',
+]);
diff --git "[FORUM_EXT]/leinad4mind\\limitperforum/language/pt_preao/common.php" "[FORUM_EXT]/leinad4mind\\limitperforum/language/pt_preao/common.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/leinad4mind\\limitperforum/language/pt_preao/common.php"
@@ -0,0 +1,66 @@
+<?php
+
+/**
+ *
+ * Limit Posts per Forum. An extension for the phpBB Forum Software package.
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
+
+$lang = array_merge($lang, [
+	'ERROR_POST_COUNT'			=> [
+		1 => 'Não podes adicionar uma nova mensagem, já atingiste o limite de 1 mensagem permitida neste fórum.',
+		2 => 'Não podes adicionar uma nova mensagem, já atingiste o limite de %1$d mensagens permitidas neste fórum.',
+	],
+	'ERROR_POST_COUNT_TIME'	=> [
+		1 => 'Não podes adicionar uma nova mensagem, já atingiste o limite de 1 mensagem permitida por cada %2$d hora(s) neste fórum.',
+		2 => 'Não podes adicionar uma nova mensagem, já atingiste o limite de %1$d mensagens permitidas por cada %2$d hora(s) neste fórum.',
+	],
+	'ERROR_TOPIC_COUNT'			=> [
+		1 => 'Não podes criar um novo tópico, já atingiste o limite de 1 tópico permitido neste fórum.',
+		2 => 'Não podes criar um novo tópico, já atingiste o limite de %1$d tópicos permitidos neste fórum.',
+	],
+	'ERROR_TOPIC_COUNT_TIME'	=> [
+		1 => 'Não podes criar um novo tópico, já atingiste o limite de 1 tópico permitido por cada %2$d hora(s) neste fórum.',
+		2 => 'Não podes criar um novo tópico, já atingiste o limite de %1$d tópicos permitidos por cada %2$d hora(s) neste fórum.',
+	],
+	'ERROR_POST_REST'			=> [
+		1 => 'Podes adicionar mais <strong class="error">1</strong> nova mensagem neste fórum antes que sejas bloqueado de colocar novas mensagens.',
+		2 => 'Podes adicionar <strong class="error">%1$d</strong> novas mensagens neste fórum antes que sejas bloqueado de colocar novas mensagens.',
+	],
+	'ERROR_TOPIC_REST'			=> [
+		1 => 'Podes adicionar <strong class="error">1</strong> novo tópico neste fórum antes que sejas bloqueado de colocar novos tópicos.',
+		2 => 'Podes adicionar <strong class="error">%1$d</strong> novos tópicos neste fórum antes que sejas bloqueado de colocar novos tópicos.',
+	],
+	'ERROR_POST_TOPIC_REST'		=> 'Podes adicionar <strong class="error">%1$d</strong> novo tópico e <strong class="error">%2$d</strong> nova mensagem neste fórum antes que sejas bloqueado de criar novas mensagens.',
+	'ERROR_POSTS_TOPIC_REST'	=> 'Podes adicionar <strong class="error">%1$d</strong> novo tópico e <strong class="error">%2$d</strong> novas mensagens neste fórum antes que sejas bloqueado de criar novas mensagens.',
+	'ERROR_POST_TOPICS_REST'	=> 'Podes adicionar <strong class="error">%1$d</strong> novos tópicos e <strong class="error">%2$d</strong> nova mensagem neste fórum antes que sejas bloqueado de criar novas mensagens.',
+	'ERROR_POSTS_TOPICS_REST'	=> 'Podes adicionar <strong class="error">%1$s</strong> novos tópicos e <strong class="error">%2$s</strong> novas mensagens neste fórum antes que sejas bloqueado de criar novas mensagens.',
+]);
diff --git "[FORUM_EXT]/leinad4mind\\limitperforum/language/pt_preao/info_acp_limitpostsperforum.php" "[FORUM_EXT]/leinad4mind\\limitperforum/language/pt_preao/info_acp_limitpostsperforum.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/leinad4mind\\limitperforum/language/pt_preao/info_acp_limitpostsperforum.php"
@@ -0,0 +1,40 @@
+<?php
+
+/**
+ *
+ * Limit Posts and Topics per Forum. An extension for the phpBB Forum Software package.
+ *
+ * @copyright (c) 2019-2020, Leinad4Mind, https://leinad4mind.top/forum
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
+
+$lang = array_merge($lang, [
+	'ACL_F_POST_LIMIT'	=> 'Can ignore post count limit',
+	'ACL_F_TOPIC_LIMIT'	=> 'Can ignore topic count limit',
+]);
```
