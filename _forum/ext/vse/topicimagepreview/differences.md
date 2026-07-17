Existem diferencas reais no codigo ou texto. Diferencas de formatacao (espacos, tabs) foram ignoradas abaixo.

```diff
diff --git "[ORIGINAL]/vse\\topicimagepreview/composer.json" "[FORUM_EXT]/vse\\topicimagepreview/composer.json"
--- "[ORIGINAL]/vse\\topicimagepreview/composer.json"
+++ "[FORUM_EXT]/vse\\topicimagepreview/composer.json"
@@ -6,30 +6,33 @@
     "version": "1.0.1",
 	"license": "GPL-2.0-only",
     "authors": [
+        {
+			"name": "Leinad4Mind",
+			"homepage": "https://leinad4mind.top/forum",
+			"role": "Developer"
+        },
         {
 			"name": "Matt Friedman",
-            "homepage": "https://imattpro.github.io",
+			"homepage": "https://vsephpbb.github.io",
 			"role": "Developer"
         }
     ],
     "require": {
         "php": ">=5.4",
-        "composer/installers": "~1.0.0",
-        "phpbb/phpbb": ">=3.2.1"
+		"composer/installers": "~1.0"
 	},
 	"require-dev": {
 		"phing/phing": "2.4.*"
 	},
     "extra": {
-        "display-name": "Topic Image Preview",
+        "display-name": "Topic Image Preview - Gallery Edition",
         "soft-require": {
             "phpbb/phpbb": ">=3.2.1"
 		},
 		"version-check": {
 			"host": "www.phpbb.com",
 			"directory": "/customise/db/extension/topic_image_preview",
-            "filename": "version_check",
-            "ssl": true
+			"filename": "version_check"
         }
     }
 }
diff --git "[FORUM_EXT]/vse\\topicimagepreview/diff_full.tmp" "[FORUM_EXT]/vse\\topicimagepreview/diff_full.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/vse\\topicimagepreview/diff_full.tmp"
@@ -0,0 +1,4942 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\topicimagepreview/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/composer.json"
+index 6ecce9b81..29c197426 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\topicimagepreview/composer.json"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/composer.json"
+@@ -4,32 +4,35 @@
+     "description": "Display thumbnail previews of images in a topic when hovering the mouse over the topic.",
+     "homepage": "https://github.com/iMattPro/TopicImagePreview",
+     "version": "1.0.1",
+-    "license": "GPL-2.0-only",
++	"license": "GPL-2.0-only",
+     "authors": [
+         {
+-            "name": "Matt Friedman",
+-            "homepage": "https://imattpro.github.io",
+-            "role": "Developer"
++			"name": "Leinad4Mind",
++			"homepage": "https://leinad4mind.top/forum",
++			"role": "Developer"
++        },
++        {
++			"name": "Matt Friedman",
++			"homepage": "https://vsephpbb.github.io",
++			"role": "Developer"
+         }
+     ],
+     "require": {
+         "php": ">=5.4",
+-        "composer/installers": "~1.0.0",
+-        "phpbb/phpbb": ">=3.2.1"
+-    },
+-    "require-dev": {
+-        "phing/phing": "2.4.*"
+-    },
++		"composer/installers": "~1.0"
++	},
++	"require-dev": {
++		"phing/phing": "2.4.*"
++	},
+     "extra": {
+-        "display-name": "Topic Image Preview",
++        "display-name": "Topic Image Preview - Gallery Edition",
+         "soft-require": {
+             "phpbb/phpbb": ">=3.2.1"
+-        },
+-        "version-check": {
+-            "host": "www.phpbb.com",
+-            "directory": "/customise/db/extension/topic_image_preview",
+-            "filename": "version_check",
+-            "ssl": true
++		},
++		"version-check": {
++			"host": "www.phpbb.com",
++			"directory": "/customise/db/extension/topic_image_preview",
++			"filename": "version_check"
+         }
+     }
+-}
+\ No newline at end of file
++}
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/diff_full.tmp"
+new file mode 100644
+index 000000000..e69de29bb
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\topicimagepreview/event/helper.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/event/helper.php"
+index b676e4583..1b5063e5f 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\topicimagepreview/event/helper.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/event/helper.php"
+@@ -73,7 +73,7 @@ class helper
+ 		if (!$this->user_allowed())
+ 		{
+ 			return;
+-		}
++		} 
+ 
+ 		// Use topic_list from event, otherwise create one based on the rowset
+ 		$topic_list = $event->offsetExists('topic_list') ? $event['topic_list'] : array_keys($event['rowset']);
+@@ -100,14 +100,16 @@ class helper
+ 
+ 		// Send the image string to the template
+ 		$block = $event->offsetExists('topic_row') ? 'topic_row' : 'tpl_ary';
+-		$event[$block] = array_merge($event[$block], ['TOPIC_IMAGES' => $this->extract_images($event['row']['post_text'])]);
++		$event[$block] = array_merge($event[$block], ['TOPIC_IMAGES' => $this->extract_images($event['row']['post_text']), 'TOPIC_IMAGES_SIZE_MIN' => (int) $this->config['vse_tip_dim_min'], 'TOPIC_IMAGES_SIZE_MAX' => (int) $this->config['vse_tip_dim_max']]);
++		
++		
+ 
+ 		$this->preview = true;
+ 	}
+ 
+ 	/**
+ 	 * Run an SQL query on a group of topics, and find the newest (or oldest)
+-	 * post with [IMG] images. Then update the topic's row set array to include
++	 * post with [ALBUM] images. Then update the topic's row set array to include
+ 	 * the post's text in the cases where images were found.
+ 	 *
+ 	 * @param array $topic_list An array of topic ids
+@@ -120,22 +122,26 @@ class helper
+ 	{
+ 		$sql_array = [];
+ 		$direction = $this->config->offsetGet('vse_tip_new') ? 'DESC' : 'ASC';
+-		$like_expression = $this->db->sql_like_expression('<r>' . $this->db->get_any_char() . '<IMG ' . $this->db->get_any_char());
++		$like_expression = $this->db->sql_like_expression('<r>' . $this->db->get_any_char() . '<ALBUM ' . $this->db->get_any_char());
+ 		$is_sqlite3 = $this->db->get_sql_layer() === 'sqlite3';
+ 		$is_mssql = strpos($this->db->get_sql_layer(), 'mssql') === 0;
++		
++
+ 		foreach ($topic_list as $topic_id)
+ 		{
+-			if (!$this->forum_allowed($rowset[$topic_id]['forum_id']))
++			if (!isset($rowset[$topic_id]) || !$this->forum_allowed($rowset[$topic_id]['forum_id']))
+ 			{
+ 				continue;
+ 			}
+ 
++			$first_post_id = (int) $rowset[$topic_id]['topic_first_post_id'];
++
+ 			$stmt = '(SELECT ' . ($is_mssql ? 'TOP 1 ' : '') . 'topic_id, post_text
+ 				FROM ' . POSTS_TABLE . '
+-				WHERE topic_id = ' . (int) $topic_id . '
+-					AND post_visibility = ' . ITEM_APPROVED . '
+-					AND post_text ' . $like_expression . '
+-				ORDER BY post_time ' . $direction . ($is_mssql ? '' : ' LIMIT 1') . ')';
++				WHERE post_text ' . $like_expression . '
++					AND topic_id = ' . (int) $topic_id . '
++					AND post_id = ' . $first_post_id . ')';
++				// ORDER BY post_time ' . $direction . ($is_mssql ? '' : ' LIMIT 1') . ')';
+ 
+ 			// SQLite3 and mssql don't like ORDER BY with UNION ALL, so treat $stmt as derived table
+ 			if ($is_sqlite3 || $is_mssql)
+@@ -174,14 +180,14 @@ class helper
+ 		$dom = new \DOMDocument;
+ 		$dom->loadXML($post);
+ 		$xpath = new \DOMXPath($dom);
+-		foreach ($xpath->query('//IMG[not(ancestor::IMG)]/@src') as $image)
++		foreach ($xpath->query('//ALBUM[not(ancestor::ALBUM)]/@content') as $image)
+ 		{
+ 			$images[] = $image->textContent;
+ 		}
+ 
+-		return array_slice($images, 0, (int) $this->config['vse_tip_num'], true);
++		// Create a string of images
++		return array_slice($images, 0, (int) $this->config['vse_tip_dim_min'], true);
+ 	}
+-
+ 	/**
+ 	 * Is the forum allowed to show topic image previews
+ 	 *
+@@ -202,4 +208,4 @@ class helper
+ 	{
+ 		return (bool) $this->user->data['user_vse_tip'];
+ 	}
+-}
++}
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\topicimagepreview/event/preview.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/event/preview.php"
+index 261da4657..a26c30b84 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\topicimagepreview/event/preview.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/event/preview.php"
+@@ -23,7 +23,7 @@ class preview implements EventSubscriberInterface
+ 	protected $config;
+ 
+ 	/** @var helper */
+-	protected $helper;
++	public $helper;
+ 
+ 	/** @var template */
+ 	protected $template;
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\topicimagepreview/event/settings.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/event/settings.php"
+index 43d35bc60..1da26d96a 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\topicimagepreview/event/settings.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/event/settings.php"
+@@ -102,7 +102,8 @@ class settings implements EventSubscriberInterface
+ 				'legend_vse_tip'	=> 'ACP_TIP_TITLE',
+ 				'vse_tip_new'		=> ['lang' => 'ACP_TIP_DISPLAY_AGE', 'validate' => 'bool', 'type' => 'custom', 'function' => [$this, 'select_vse_tip_new'], 'explain' => true],
+ 				'vse_tip_num'		=> ['lang' => 'ACP_TIP_DISPLAY_NUM', 'validate' => 'int:0:99', 'type' => 'number:0:99', 'explain' => true],
+-				'vse_tip_dim'		=> ['lang' => 'ACP_TIP_DISPLAY_DIM', 'validate' => 'int:0:999', 'type' => 'number:0:999', 'explain' => true, 'append' => ' ' . $this->language->lang('PIXEL')],
++				'vse_tip_dim_min'	=> ['lang' => 'ACP_TIP_DISPLAY_DIM_MIN', 'validate' => 'int:0:999', 'type' => 'number:0:999', 'explain' => true, 'append' => ' ' . $this->language->lang('PIXEL')],
++				'vse_tip_dim_max'	=> ['lang' => 'ACP_TIP_DISPLAY_DIM_MAX', 'validate' => 'int:0:999', 'type' => 'number:0:999', 'explain' => true, 'append' => ' ' . $this->language->lang('PIXEL')],
+ 				'vse_tip_srt'		=> ['lang' => 'ACP_TIP_DISPLAY_SRT', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => false],
+ 			];
+ 
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\topicimagepreview/language/en/tip_acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/language/en/tip_acp.php"
+index 62490107b..5759ad007 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\topicimagepreview/language/en/tip_acp.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/language/en/tip_acp.php"
+@@ -26,7 +26,8 @@ $lang = array_merge($lang, [
+ 	'ACP_TIP_OLDEST_POST'			=> 'Oldest post',
+ 	'ACP_TIP_DISPLAY_NUM'			=> 'Number of images to display',
+ 	'ACP_TIP_DISPLAY_NUM_EXPLAIN'	=> 'Maximum number of images to display in previews. Set to 0 to disable previews.',
+-	'ACP_TIP_DISPLAY_DIM'			=> 'Maximum image size per preview',
++	'ACP_TIP_DISPLAY_DIM_MIN'		=> 'Maximum image size for the small image preview',
++	'ACP_TIP_DISPLAY_DIM_MAX'		=> 'Maximum image size for the big popup image preview',
+ 	'ACP_TIP_DISPLAY_DIM_EXPLAIN'	=> 'Maximum width/height of each image in the preview.',
+ 	'ACP_TIP_DISPLAY_SRT'			=> 'Display in search results topics',
+ 	'ACP_TIP_DISPLAY_PST'			=> 'Display in similar topics',
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\topicimagepreview/language/en/tip_ucp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/language/en/tip_ucp.php"
+index e3919d6ba..f610ddd98 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\topicimagepreview/language/en/tip_ucp.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/language/en/tip_ucp.php"
+@@ -1,38 +1,36 @@
+-<?php
+-/**
+- *
+- * Topic Image Preview. An extension for the phpBB Forum Software package.
+- *
+- * @copyright (c) 2019, Matt Friedman
+- * @license GNU General Public License, version 2 (GPL-2.0)
+- *
+- */
++opentip<?php
++			/**
++			 *
++			 * Topic Image Preview. An extension for the phpBB Forum Software package.
++			 *
++			 * @copyright (c) 2019, Matt Friedman
++			 * @license GNU General Public License, version 2 (GPL-2.0)
++			 *
++			 */
+ 
+-/**
+- * DO NOT CHANGE
+- */
+-if (!defined('IN_PHPBB'))
+-{
+-	exit;
+-}
++			/**
++			 * DO NOT CHANGE
++			 */
++			if (!defined('IN_PHPBB')) {
++				exit;
++			}
+ 
+-if (empty($lang) || !is_array($lang))
+-{
+-	$lang = [];
+-}
++			if (empty($lang) || !is_array($lang)) {
++				$lang = [];
++			}
+ 
+-// DEVELOPERS PLEASE NOTE
+-//
+-// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
+-//
+-// Placeholders can now contain order information, e.g. instead of
+-// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
+-// translators to re-order the output of data while ensuring it remains correct
+-//
+-// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
+-// equally where a string contains only two placeholders which are used to wrap text
+-// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
++			// DEVELOPERS PLEASE NOTE
++			//
++			// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
++			//
++			// Placeholders can now contain order information, e.g. instead of
++			// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
++			// translators to re-order the output of data while ensuring it remains correct
++			//
++			// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
++			// equally where a string contains only two placeholders which are used to wrap text
++			// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
+ 
+-$lang = array_merge($lang, [
+-	'DISPLAY_TOPIC_IMAGE_PREVIEWS'	=> 'Display topic image previews',
+-]);
++			$lang = array_merge($lang, [
++				'DISPLAY_TOPIC_IMAGE_PREVIEWS'	=> 'Display topic image previews',
++			]);
+\ No newline at end of file
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/language/pt/permissions_tip.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/language/pt/permissions_tip.php"
+new file mode 100644
+index 000000000..0c544a024
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/language/pt/permissions_tip.php"
+@@ -0,0 +1,26 @@
++<?php
++/**
++ *
++ * Topic Image Preview. An extension for the phpBB Forum Software package.
++ *
++ * @copyright (c) 2020, Matt Friedman
++ * @license GNU General Public License, version 2 (GPL-2.0)
++ *
++ */
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
++	$lang = array();
++}
++
++$lang = array_merge($lang, array(
++	'ACL_F_VSE_TIP'	=> 'Can see topic image previews',
++));
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/language/pt/tip_acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/language/pt/tip_acp.php"
+new file mode 100644
+index 000000000..f0fe5478c
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/language/pt/tip_acp.php"
+@@ -0,0 +1,34 @@
++<?php
++/**
++ *
++ * Topic Image Preview. An extension for the phpBB Forum Software package.
++ *
++ * @copyright (c) 2017, Matt Friedman
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
++$lang = array_merge($lang, [
++	'ACP_TIP_TITLE'					=> 'Topic Image Preview',
++	'ACP_TIP_DISPLAY_AGE'			=> 'Display images from',
++	'ACP_TIP_DISPLAY_AGE_EXPLAIN'	=> 'Select Newest post to display the most recent images posted. Otherwise, select Oldest post to display the oldest images posted.',
++	'ACP_TIP_NEWEST_POST'			=> 'Newest post',
++	'ACP_TIP_OLDEST_POST'			=> 'Oldest post',
++	'ACP_TIP_DISPLAY_NUM'			=> 'Number of images to display',
++	'ACP_TIP_DISPLAY_NUM_EXPLAIN'	=> 'Maximum number of images to display in previews. Set to 0 to disable previews.',
++	'ACP_TIP_DISPLAY_DIM_MIN'		=> 'Maximum image size for the small image preview',
++	'ACP_TIP_DISPLAY_DIM_MAX'		=> 'Maximum image size for the big popup image preview',
++	'ACP_TIP_DISPLAY_DIM_EXPLAIN'	=> 'Maximum width/height of each image in the preview.',
++	'ACP_TIP_DISPLAY_SRT'			=> 'Display in search results topics',
++	'ACP_TIP_DISPLAY_PST'			=> 'Display in similar topics',
++]);
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/language/pt/tip_install.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/language/pt/tip_install.php"
+new file mode 100644
+index 000000000..4f9c40242
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/language/pt/tip_install.php"
+@@ -0,0 +1,34 @@
++<?php
++/**
++ *
++ * Topic Image Preview. An extension for the phpBB Forum Software package.
++ *
++ * @copyright (c) 2017, Matt Friedman
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
++$lang = array_merge($lang, [
++	'TIP_INSTALL_ERROR'	=> 'phpBB %s or newer is required.',
++]);
++
++// TRANSLATORS CAN IGNORE THIS.
++// Overwrite core error message keys with a more specific message.
++$lang = array_merge($lang, [
++	'EXTENSION_NOT_ENABLEABLE'		=> isset($lang['EXTENSION_NOT_ENABLEABLE']) ?
++		$lang['EXTENSION_NOT_ENABLEABLE'] . '<br />' . sprintf($lang['TIP_INSTALL_ERROR'], \vse\topicimagepreview\ext::PHPBB_MIN_VERSION) :
++		null,
++	'CLI_EXTENSION_ENABLE_FAILURE'	=> isset($lang['CLI_EXTENSION_ENABLE_FAILURE']) ?
++		$lang['CLI_EXTENSION_ENABLE_FAILURE'] . '. ' . sprintf($lang['TIP_INSTALL_ERROR'], \vse\topicimagepreview\ext::PHPBB_MIN_VERSION) :
++		null,
++]);
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/language/pt/tip_ucp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/language/pt/tip_ucp.php"
+new file mode 100644
+index 000000000..32c61dee9
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/language/pt/tip_ucp.php"
+@@ -0,0 +1,38 @@
++<?php
++/**
++ *
++ * Topic Image Preview. An extension for the phpBB Forum Software package.
++ *
++ * @copyright (c) 2019, Matt Friedman
++ * @license GNU General Public License, version 2 (GPL-2.0)
++ *
++ */
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
++
++$lang = array_merge($lang, [
++	'DISPLAY_TOPIC_IMAGE_PREVIEWS'	=> 'Mostrar imagens de tópicos',
++]);
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/language/pt_preao/permissions_tip.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/language/pt_preao/permissions_tip.php"
+new file mode 100644
+index 000000000..0c544a024
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/language/pt_preao/permissions_tip.php"
+@@ -0,0 +1,26 @@
++<?php
++/**
++ *
++ * Topic Image Preview. An extension for the phpBB Forum Software package.
++ *
++ * @copyright (c) 2020, Matt Friedman
++ * @license GNU General Public License, version 2 (GPL-2.0)
++ *
++ */
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
++	$lang = array();
++}
++
++$lang = array_merge($lang, array(
++	'ACL_F_VSE_TIP'	=> 'Can see topic image previews',
++));
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/language/pt_preao/tip_acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/language/pt_preao/tip_acp.php"
+new file mode 100644
+index 000000000..f0fe5478c
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/language/pt_preao/tip_acp.php"
+@@ -0,0 +1,34 @@
++<?php
++/**
++ *
++ * Topic Image Preview. An extension for the phpBB Forum Software package.
++ *
++ * @copyright (c) 2017, Matt Friedman
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
++$lang = array_merge($lang, [
++	'ACP_TIP_TITLE'					=> 'Topic Image Preview',
++	'ACP_TIP_DISPLAY_AGE'			=> 'Display images from',
++	'ACP_TIP_DISPLAY_AGE_EXPLAIN'	=> 'Select Newest post to display the most recent images posted. Otherwise, select Oldest post to display the oldest images posted.',
++	'ACP_TIP_NEWEST_POST'			=> 'Newest post',
++	'ACP_TIP_OLDEST_POST'			=> 'Oldest post',
++	'ACP_TIP_DISPLAY_NUM'			=> 'Number of images to display',
++	'ACP_TIP_DISPLAY_NUM_EXPLAIN'	=> 'Maximum number of images to display in previews. Set to 0 to disable previews.',
++	'ACP_TIP_DISPLAY_DIM_MIN'		=> 'Maximum image size for the small image preview',
++	'ACP_TIP_DISPLAY_DIM_MAX'		=> 'Maximum image size for the big popup image preview',
++	'ACP_TIP_DISPLAY_DIM_EXPLAIN'	=> 'Maximum width/height of each image in the preview.',
++	'ACP_TIP_DISPLAY_SRT'			=> 'Display in search results topics',
++	'ACP_TIP_DISPLAY_PST'			=> 'Display in similar topics',
++]);
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/language/pt_preao/tip_install.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/language/pt_preao/tip_install.php"
+new file mode 100644
+index 000000000..4f9c40242
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/language/pt_preao/tip_install.php"
+@@ -0,0 +1,34 @@
++<?php
++/**
++ *
++ * Topic Image Preview. An extension for the phpBB Forum Software package.
++ *
++ * @copyright (c) 2017, Matt Friedman
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
++$lang = array_merge($lang, [
++	'TIP_INSTALL_ERROR'	=> 'phpBB %s or newer is required.',
++]);
++
++// TRANSLATORS CAN IGNORE THIS.
++// Overwrite core error message keys with a more specific message.
++$lang = array_merge($lang, [
++	'EXTENSION_NOT_ENABLEABLE'		=> isset($lang['EXTENSION_NOT_ENABLEABLE']) ?
++		$lang['EXTENSION_NOT_ENABLEABLE'] . '<br />' . sprintf($lang['TIP_INSTALL_ERROR'], \vse\topicimagepreview\ext::PHPBB_MIN_VERSION) :
++		null,
++	'CLI_EXTENSION_ENABLE_FAILURE'	=> isset($lang['CLI_EXTENSION_ENABLE_FAILURE']) ?
++		$lang['CLI_EXTENSION_ENABLE_FAILURE'] . '. ' . sprintf($lang['TIP_INSTALL_ERROR'], \vse\topicimagepreview\ext::PHPBB_MIN_VERSION) :
++		null,
++]);
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/language/pt_preao/tip_ucp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/language/pt_preao/tip_ucp.php"
+new file mode 100644
+index 000000000..32c61dee9
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/language/pt_preao/tip_ucp.php"
+@@ -0,0 +1,38 @@
++<?php
++/**
++ *
++ * Topic Image Preview. An extension for the phpBB Forum Software package.
++ *
++ * @copyright (c) 2019, Matt Friedman
++ * @license GNU General Public License, version 2 (GPL-2.0)
++ *
++ */
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
++
++$lang = array_merge($lang, [
++	'DISPLAY_TOPIC_IMAGE_PREVIEWS'	=> 'Mostrar imagens de tópicos',
++]);
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\topicimagepreview/migrations/install_tip.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/migrations/install_tip.php"
+index 3fb2fe1b6..d89bc64a5 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\topicimagepreview/migrations/install_tip.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/migrations/install_tip.php"
+@@ -27,7 +27,8 @@ class install_tip extends \phpbb\db\migration\migration
+ 		return [
+ 			['config.add', ['vse_tip_new', 1]],
+ 			['config.add', ['vse_tip_num', 3]],
+-			['config.add', ['vse_tip_dim', 200]],
++			['config.add', ['vse_tip_dim_min', 200]],
++			['config.add', ['vse_tip_dim_max', 500]],
+ 		];
+ 	}
+ }
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/styles/BBOOTS/template/event/overall_footer_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/styles/BBOOTS/template/event/overall_footer_after.html"
+new file mode 100644
+index 000000000..a89927961
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/styles/BBOOTS/template/event/overall_footer_after.html"
+@@ -0,0 +1,9 @@
++{% INCLUDEJS '@vse_topicimagepreview/js/opentip-jquery.min.js' %}
++
++<script>
++head.ready(function () {
++	$(function() {
++		$("[data-ot]").closest("dt").removeAttr("title");
++	});
++});
++</script>
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/styles/BBOOTS/template/event/overall_header_stylesheets_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/styles/BBOOTS/template/event/overall_header_stylesheets_after.html"
+new file mode 100644
+index 000000000..681ce299b
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/styles/BBOOTS/template/event/overall_header_stylesheets_after.html"
+@@ -0,0 +1,5 @@
++{% INCLUDECSS '@vse_topicimagepreview/opentip.css' %}
++
++<style>
++	.opentip-container { max-width: 1000px; white-space: nowrap; }
++</style>
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/styles/BBOOTS/template/event/topiclist_row_prepend.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/styles/BBOOTS/template/event/topiclist_row_prepend.html"
+new file mode 100644
+index 000000000..e19516eed
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/styles/BBOOTS/template/event/topiclist_row_prepend.html"
+@@ -0,0 +1,18 @@
++{# display in view forum #}
++{% if topicrow.TOPIC_IMAGES %}
++	{% set preview = topicrow %}
++{% endif %}
++
++{# display in search results #}
++{% if searchresults.TOPIC_IMAGES %}
++	{% set preview = searchresults %}
++{% endif %}
++
++{# display in Similar Topics extension #}
++{% if similar.TOPIC_IMAGES %}
++	{% set preview = similar %}
++{% endif %}
++
++<span{% if preview.TOPIC_IMAGES_BIG %} data-ot="{{ preview.TOPIC_IMAGES_BIG }}" data-ot-group="topics" data-ot-background="transparent" data-ot-border-width="0" data-ot-border-radius="0"{% endif %}>
++{% if preview.TOPIC_IMAGES %}<div style="float:left;padding-right:10px;">{{ preview.TOPIC_IMAGES }}</div>{% endif %}
++</span>
+\ No newline at end of file
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/styles/BBOOTS/template/event/ucp_prefs_view_radio_buttons_append.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/styles/BBOOTS/template/event/ucp_prefs_view_radio_buttons_append.html"
+new file mode 100644
+index 000000000..9d7eab75d
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/styles/BBOOTS/template/event/ucp_prefs_view_radio_buttons_append.html"
+@@ -0,0 +1,9 @@
++{% if S_VSE_TIP_NUM %}
++	<dl>
++		<dt><label for="user_vse_tip1">{{ lang('DISPLAY_TOPIC_IMAGE_PREVIEWS') ~ lang('COLON') }}</label></dt>
++		<dd>
++			<label for="user_vse_tip1"><input type="radio" name="user_vse_tip" id="user_vse_tip1" value="1"{% if S_VSE_TIP_USER %} checked="checked"{% endif %} /> {{ lang('YES') }}</label>
++			<label for="user_vse_tip0"><input type="radio" name="user_vse_tip" id="user_vse_tip0" value="0"{% if not S_VSE_TIP_USER %} checked="checked"{% endif %} /> {{ lang('NO') }}</label>
++		</dd>
++	</dl>
++{% endif %}
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/styles/BBOOTS/template/js/opentip-jquery.js" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/styles/BBOOTS/template/js/opentip-jquery.js"
+new file mode 100644
+index 000000000..ddfb9a8d9
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/styles/BBOOTS/template/js/opentip-jquery.js"
+@@ -0,0 +1,1794 @@
++// Generated by CoffeeScript 1.4.0
++/*
++#
++# Opentip v2.4.6
++#
++# More info at [www.opentip.org](http://www.opentip.org)
++# 
++# Copyright (c) 2012, Matias Meno  
++# Graphics by Tjandra Mayerhold
++# 
++# Permission is hereby granted, free of charge, to any person obtaining a copy
++# of this software and associated documentation files (the "Software"), to deal
++# in the Software without restriction, including without limitation the rights
++# to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
++# copies of the Software, and to permit persons to whom the Software is
++# furnished to do so, subject to the following conditions:
++# 
++# The above copyright notice and this permission notice shall be included in
++# all copies or substantial portions of the Software.
++# 
++# THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
++# IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
++# FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
++# AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
++# LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
++# OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
++# THE SOFTWARE.
++#
++*/
++head.ready(function () {
++var Opentip, firstAdapter, i, mouseMoved, mousePosition, mousePositionObservers, position, vendors, _i, _len, _ref,
++  __slice = [].slice,
++  __indexOf = [].indexOf || function(item) { for (var i = 0, l = this.length; i < l; i++) { if (i in this && this[i] === item) return i; } return -1; },
++  __hasProp = {}.hasOwnProperty;
++
++Opentip = (function() {
++
++  Opentip.prototype.STICKS_OUT_TOP = 1;
++
++  Opentip.prototype.STICKS_OUT_BOTTOM = 2;
++
++  Opentip.prototype.STICKS_OUT_LEFT = 1;
++
++  Opentip.prototype.STICKS_OUT_RIGHT = 2;
++
++  Opentip.prototype["class"] = {
++    container: "opentip-container",
++    opentip: "opentip",
++    header: "ot-header",
++    content: "ot-content",
++    loadingIndicator: "ot-loading-indicator",
++    close: "ot-close",
++    goingToHide: "ot-going-to-hide",
++    hidden: "ot-hidden",
++    hiding: "ot-hiding",
++    goingToShow: "ot-going-to-show",
++    showing: "ot-showing",
++    visible: "ot-visible",
++    loading: "ot-loading",
++    ajaxError: "ot-ajax-error",
++    fixed: "ot-fixed",
++    showEffectPrefix: "ot-show-effect-",
++    hideEffectPrefix: "ot-hide-effect-",
++    stylePrefix: "style-"
++  };
++
++  function Opentip(element, content, title, options) {
++    var elementsOpentips, hideTrigger, methodToBind, optionSources, prop, styleName, _i, _j, _len, _len1, _ref, _ref1, _ref2, _tmpStyle,
++      _this = this;
++    this.id = ++Opentip.lastId;
++    this.debug("Creating Opentip.");
++    Opentip.tips.push(this);
++    this.adapter = Opentip.adapter;
++    elementsOpentips = this.adapter.data(element, "opentips") || [];
++    elementsOpentips.push(this);
++    this.adapter.data(element, "opentips", elementsOpentips);
++    this.triggerElement = this.adapter.wrap(element);
++    if (this.triggerElement.length > 1) {
++      throw new Error("You can't call Opentip on multiple elements.");
++    }
++    if (this.triggerElement.length < 1) {
++      throw new Error("Invalid element.");
++    }
++    this.loaded = false;
++    this.loading = false;
++    this.visible = false;
++    this.waitingToShow = false;
++    this.waitingToHide = false;
++    this.currentPosition = {
++      left: 0,
++      top: 0
++    };
++    this.dimensions = {
++      width: 100,
++      height: 50
++    };
++    this.content = "";
++    this.redraw = true;
++    this.currentObservers = {
++      showing: false,
++      visible: false,
++      hiding: false,
++      hidden: false
++    };
++    options = this.adapter.clone(options);
++    if (typeof content === "object") {
++      options = content;
++      content = title = void 0;
++    } else if (typeof title === "object") {
++      options = title;
++      title = void 0;
++    }
++    if (title != null) {
++      options.title = title;
++    }
++    if (content != null) {
++      this.setContent(content);
++    }
++    if (options["extends"] == null) {
++      if (options.style != null) {
++        options["extends"] = options.style;
++      } else {
++        options["extends"] = Opentip.defaultStyle;
++      }
++    }
++    optionSources = [options];
++    _tmpStyle = options;
++    while (_tmpStyle["extends"]) {
++      styleName = _tmpStyle["extends"];
++      _tmpStyle = Opentip.styles[styleName];
++      if (_tmpStyle == null) {
++        throw new Error("Invalid style: " + styleName);
++      }
++      optionSources.unshift(_tmpStyle);
++      if (!((_tmpStyle["extends"] != null) || styleName === "standard")) {
++        _tmpStyle["extends"] = "standard";
++      }
++    }
++    options = (_ref = this.adapter).extend.apply(_ref, [{}].concat(__slice.call(optionSources)));
++    options.hideTriggers = (function() {
++      var _i, _len, _ref1, _results;
++      _ref1 = options.hideTriggers;
++      _results = [];
++      for (_i = 0, _len = _ref1.length; _i < _len; _i++) {
++        hideTrigger = _ref1[_i];
++        _results.push(hideTrigger);
++      }
++      return _results;
++    })();
++    if (options.hideTrigger && options.hideTriggers.length === 0) {
++      options.hideTriggers.push(options.hideTrigger);
++    }
++    _ref1 = ["tipJoint", "targetJoint", "stem"];
++    for (_i = 0, _len = _ref1.length; _i < _len; _i++) {
++      prop = _ref1[_i];
++      if (options[prop] && typeof options[prop] === "string") {
++        options[prop] = new Opentip.Joint(options[prop]);
++      }
++    }
++    if (options.ajax && (options.ajax === true || !options.ajax)) {
++      if (this.adapter.tagName(this.triggerElement) === "A") {
++        options.ajax = this.adapter.attr(this.triggerElement, "href");
++      } else {
++        options.ajax = false;
++      }
++    }
++    if (options.showOn === "click" && this.adapter.tagName(this.triggerElement) === "A") {
++      this.adapter.observe(this.triggerElement, "click", function(e) {
++        e.preventDefault();
++        e.stopPropagation();
++        return e.stopped = true;
++      });
++    }
++    if (options.target) {
++      options.fixed = true;
++    }
++    if (options.stem === true) {
++      options.stem = new Opentip.Joint(options.tipJoint);
++    }
++    if (options.target === true) {
++      options.target = this.triggerElement;
++    } else if (options.target) {
++      options.target = this.adapter.wrap(options.target);
++    }
++    this.currentStem = options.stem;
++    if (options.delay == null) {
++      options.delay = options.showOn === "mouseover" ? 0.2 : 0;
++    }
++    if (options.targetJoint == null) {
++      options.targetJoint = new Opentip.Joint(options.tipJoint).flip();
++    }
++    this.showTriggers = [];
++    this.showTriggersWhenVisible = [];
++    this.hideTriggers = [];
++    if (options.showOn && options.showOn !== "creation") {
++      this.showTriggers.push({
++        element: this.triggerElement,
++        event: options.showOn
++      });
++    }
++    if (options.ajaxCache != null) {
++      options.cache = options.ajaxCache;
++      delete options.ajaxCache;
++    }
++    this.options = options;
++    this.bound = {};
++    _ref2 = ["prepareToShow", "prepareToHide", "show", "hide", "reposition"];
++    for (_j = 0, _len1 = _ref2.length; _j < _len1; _j++) {
++      methodToBind = _ref2[_j];
++      this.bound[methodToBind] = (function(methodToBind) {
++        return function() {
++          return _this[methodToBind].apply(_this, arguments);
++        };
++      })(methodToBind);
++    }
++    this.adapter.domReady(function() {
++      _this.activate();
++      if (_this.options.showOn === "creation") {
++        return _this.prepareToShow();
++      }
++    });
++  }
++
++  Opentip.prototype._setup = function() {
++    var hideOn, hideTrigger, hideTriggerElement, i, _i, _j, _len, _len1, _ref, _ref1, _results;
++    this.debug("Setting up the tooltip.");
++    this._buildContainer();
++    this.hideTriggers = [];
++    _ref = this.options.hideTriggers;
++    for (i = _i = 0, _len = _ref.length; _i < _len; i = ++_i) {
++      hideTrigger = _ref[i];
++      hideTriggerElement = null;
++      hideOn = this.options.hideOn instanceof Array ? this.options.hideOn[i] : this.options.hideOn;
++      if (typeof hideTrigger === "string") {
++        switch (hideTrigger) {
++          case "trigger":
++            hideOn = hideOn || "mouseout";
++            hideTriggerElement = this.triggerElement;
++            break;
++          case "tip":
++            hideOn = hideOn || "mouseover";
++            hideTriggerElement = this.container;
++            break;
++          case "target":
++            hideOn = hideOn || "mouseover";
++            hideTriggerElement = this.options.target;
++            break;
++          case "closeButton":
++            break;
++          default:
++            throw new Error("Unknown hide trigger: " + hideTrigger + ".");
++        }
++      } else {
++        hideOn = hideOn || "mouseover";
++        hideTriggerElement = this.adapter.wrap(hideTrigger);
++      }
++      if (hideTriggerElement) {
++        this.hideTriggers.push({
++          element: hideTriggerElement,
++          event: hideOn,
++          original: hideTrigger
++        });
++      }
++    }
++    _ref1 = this.hideTriggers;
++    _results = [];
++    for (_j = 0, _len1 = _ref1.length; _j < _len1; _j++) {
++      hideTrigger = _ref1[_j];
++      _results.push(this.showTriggersWhenVisible.push({
++        element: hideTrigger.element,
++        event: "mouseover"
++      }));
++    }
++    return _results;
++  };
++
++  Opentip.prototype._buildContainer = function() {
++    this.container = this.adapter.create("<div id=\"opentip-" + this.id + "\" class=\"" + this["class"].container + " " + this["class"].hidden + " " + this["class"].stylePrefix + this.options.className + "\"></div>");
++    this.adapter.css(this.container, {
++      position: "absolute"
++    });
++    if (this.options.ajax) {
++      this.adapter.addClass(this.container, this["class"].loading);
++    }
++    if (this.options.fixed) {
++      this.adapter.addClass(this.container, this["class"].fixed);
++    }
++    if (this.options.showEffect) {
++      this.adapter.addClass(this.container, "" + this["class"].showEffectPrefix + this.options.showEffect);
++    }
++    if (this.options.hideEffect) {
++      return this.adapter.addClass(this.container, "" + this["class"].hideEffectPrefix + this.options.hideEffect);
++    }
++  };
++
++  Opentip.prototype._buildElements = function() {
++    var headerElement, titleElement;
++    this.tooltipElement = this.adapter.create("<div class=\"" + this["class"].opentip + "\"><div class=\"" + this["class"].header + "\"></div><div class=\"" + this["class"].content + "\"></div></div>");
++    this.backgroundCanvas = this.adapter.wrap(document.createElement("canvas"));
++    this.adapter.css(this.backgroundCanvas, {
++      position: "absolute"
++    });
++    if (typeof G_vmlCanvasManager !== "undefined" && G_vmlCanvasManager !== null) {
++      G_vmlCanvasManager.initElement(this.adapter.unwrap(this.backgroundCanvas));
++    }
++    headerElement = this.adapter.find(this.tooltipElement, "." + this["class"].header);
++    if (this.options.title) {
++      titleElement = this.adapter.create("<h1></h1>");
++      this.adapter.update(titleElement, this.options.title, this.options.escapeTitle);
++      this.adapter.append(headerElement, titleElement);
++    }
++    if (this.options.ajax && !this.loaded) {
++      this.adapter.append(this.tooltipElement, this.adapter.create("<div class=\"" + this["class"].loadingIndicator + "\"><span>↻</span></div>"));
++    }
++    if (__indexOf.call(this.options.hideTriggers, "closeButton") >= 0) {
++      this.closeButtonElement = this.adapter.create("<a href=\"javascript:undefined;\" class=\"" + this["class"].close + "\"><span>Close</span></a>");
++      this.adapter.append(headerElement, this.closeButtonElement);
++    }
++    this.adapter.append(this.container, this.backgroundCanvas);
++    this.adapter.append(this.container, this.tooltipElement);
++    this.adapter.append(document.body, this.container);
++    this._newContent = true;
++    return this.redraw = true;
++  };
++
++  Opentip.prototype.setContent = function(content) {
++    this.content = content;
++    this._newContent = true;
++    if (typeof this.content === "function") {
++      this._contentFunction = this.content;
++      this.content = "";
++    } else {
++      this._contentFunction = null;
++    }
++    if (this.visible) {
++      return this._updateElementContent();
++    }
++  };
++
++  Opentip.prototype._updateElementContent = function() {
++    var contentDiv;
++    if (this._newContent || (!this.options.cache && this._contentFunction)) {
++      contentDiv = this.adapter.find(this.container, "." + this["class"].content);
++      if (contentDiv != null) {
++        if (this._contentFunction) {
++          this.debug("Executing content function.");
++          this.content = this._contentFunction(this);
++        }
++        this.adapter.update(contentDiv, this.content, this.options.escapeContent);
++      }
++      this._newContent = false;
++    }
++    this._storeAndLockDimensions();
++    return this.reposition();
++  };
++
++  Opentip.prototype._storeAndLockDimensions = function() {
++    var prevDimension;
++    if (!this.container) {
++      return;
++    }
++    prevDimension = this.dimensions;
++    this.adapter.css(this.container, {
++      width: "auto",
++      left: "0px",
++      top: "0px"
++    });
++    this.dimensions = this.adapter.dimensions(this.container);
++    this.dimensions.width += 1;
++    this.adapter.css(this.container, {
++      width: "" + this.dimensions.width + "px",
++      top: "" + this.currentPosition.top + "px",
++      left: "" + this.currentPosition.left + "px"
++    });
++    if (!this._dimensionsEqual(this.dimensions, prevDimension)) {
++      this.redraw = true;
++      return this._draw();
++    }
++  };
++
++  Opentip.prototype.activate = function() {
++    return this._setupObservers("hidden", "hiding");
++  };
++
++  Opentip.prototype.deactivate = function() {
++    this.debug("Deactivating tooltip.");
++    this.hide();
++    return this._setupObservers("-showing", "-visible", "-hidden", "-hiding");
++  };
++
++  Opentip.prototype._setupObservers = function() {
++    var observeOrStop, removeObserver, state, states, trigger, _i, _j, _k, _l, _len, _len1, _len2, _len3, _ref, _ref1, _ref2,
++      _this = this;
++    states = 1 <= arguments.length ? __slice.call(arguments, 0) : [];
++    for (_i = 0, _len = states.length; _i < _len; _i++) {
++      state = states[_i];
++      removeObserver = false;
++      if (state.charAt(0) === "-") {
++        removeObserver = true;
++        state = state.substr(1);
++      }
++      if (this.currentObservers[state] === !removeObserver) {
++        continue;
++      }
++      this.currentObservers[state] = !removeObserver;
++      observeOrStop = function() {
++        var args, _ref, _ref1;
++        args = 1 <= arguments.length ? __slice.call(arguments, 0) : [];
++        if (removeObserver) {
++          return (_ref = _this.adapter).stopObserving.apply(_ref, args);
++        } else {
++          return (_ref1 = _this.adapter).observe.apply(_ref1, args);
++        }
++      };
++      switch (state) {
++        case "showing":
++          _ref = this.hideTriggers;
++          for (_j = 0, _len1 = _ref.length; _j < _len1; _j++) {
++            trigger = _ref[_j];
++            observeOrStop(trigger.element, trigger.event, this.bound.prepareToHide);
++          }
++          observeOrStop((document.onresize != null ? document : window), "resize", this.bound.reposition);
++          observeOrStop(window, "scroll", this.bound.reposition);
++          break;
++        case "visible":
++          _ref1 = this.showTriggersWhenVisible;
++          for (_k = 0, _len2 = _ref1.length; _k < _len2; _k++) {
++            trigger = _ref1[_k];
++            observeOrStop(trigger.element, trigger.event, this.bound.prepareToShow);
++          }
++          break;
++        case "hiding":
++          _ref2 = this.showTriggers;
++          for (_l = 0, _len3 = _ref2.length; _l < _len3; _l++) {
++            trigger = _ref2[_l];
++            observeOrStop(trigger.element, trigger.event, this.bound.prepareToShow);
++          }
++          break;
++        case "hidden":
++          break;
++        default:
++          throw new Error("Unknown state: " + state);
++      }
++    }
++    return null;
++  };
++
++  Opentip.prototype.prepareToShow = function() {
++    this._abortHiding();
++    this._abortShowing();
++    if (this.visible) {
++      return;
++    }
++    this.debug("Showing in " + this.options.delay + "s.");
++    if (this.container == null) {
++      this._setup();
++    }
++    if (this.options.group) {
++      Opentip._abortShowingGroup(this.options.group, this);
++    }
++    this.preparingToShow = true;
++    this._setupObservers("-hidden", "-hiding", "showing");
++    this._followMousePosition();
++    if (this.options.fixed && !this.options.target) {
++      this.initialMousePosition = mousePosition;
++    }
++    this.reposition();
++    return this._showTimeoutId = this.setTimeout(this.bound.show, this.options.delay || 0);
++  };
++
++  Opentip.prototype.show = function() {
++    var _this = this;
++    this._abortHiding();
++    if (this.visible) {
++      return;
++    }
++    this._clearTimeouts();
++    if (!this._triggerElementExists()) {
++      return this.deactivate();
++    }
++    this.debug("Showing now.");
++    if (this.container == null) {
++      this._setup();
++    }
++    if (this.options.group) {
++      Opentip._hideGroup(this.options.group, this);
++    }
++    this.visible = true;
++    this.preparingToShow = false;
++    if (this.tooltipElement == null) {
++      this._buildElements();
++    }
++    this._updateElementContent();
++    if (this.options.ajax && (!this.loaded || !this.options.cache)) {
++      this._loadAjax();
++    }
++    this._searchAndActivateCloseButtons();
++    this._startEnsureTriggerElement();
++    this.adapter.css(this.container, {
++      zIndex: Opentip.lastZIndex++
++    });
++    this._setupObservers("-hidden", "-hiding", "-showing", "-visible", "showing", "visible");
++    if (this.options.fixed && !this.options.target) {
++      this.initialMousePosition = mousePosition;
++    }
++    this.reposition();
++    this.adapter.removeClass(this.container, this["class"].hiding);
++    this.adapter.removeClass(this.container, this["class"].hidden);
++    this.adapter.addClass(this.container, this["class"].goingToShow);
++    this.setCss3Style(this.container, {
++      transitionDuration: "0s"
++    });
++    this.defer(function() {
++      var delay;
++      if (!_this.visible || _this.preparingToHide) {
++        return;
++      }
++      _this.adapter.removeClass(_this.container, _this["class"].goingToShow);
++      _this.adapter.addClass(_this.container, _this["class"].showing);
++      delay = 0;
++      if (_this.options.showEffect && _this.options.showEffectDuration) {
++        delay = _this.options.showEffectDuration;
++      }
++      _this.setCss3Style(_this.container, {
++        transitionDuration: "" + delay + "s"
++      });
++      _this._visibilityStateTimeoutId = _this.setTimeout(function() {
++        _this.adapter.removeClass(_this.container, _this["class"].showing);
++        return _this.adapter.addClass(_this.container, _this["class"].visible);
++      }, delay);
++      return _this._activateFirstInput();
++    });
++    return this._draw();
++  };
++
++  Opentip.prototype._abortShowing = function() {
++    if (this.preparingToShow) {
++      this.debug("Aborting showing.");
++      this._clearTimeouts();
++      this._stopFollowingMousePosition();
++      this.preparingToShow = false;
++      return this._setupObservers("-showing", "-visible", "hiding", "hidden");
++    }
++  };
++
++  Opentip.prototype.prepareToHide = function() {
++    this._abortShowing();
++    this._abortHiding();
++    if (!this.visible) {
++      return;
++    }
++    this.debug("Hiding in " + this.options.hideDelay + "s");
++    this.preparingToHide = true;
++    this._setupObservers("-showing", "visible", "-hidden", "hiding");
++    return this._hideTimeoutId = this.setTimeout(this.bound.hide, this.options.hideDelay);
++  };
++
++  Opentip.prototype.hide = function() {
++    var _this = this;
++    this._abortShowing();
++    if (!this.visible) {
++      return;
++    }
++    this._clearTimeouts();
++    this.debug("Hiding!");
++    this.visible = false;
++    this.preparingToHide = false;
++    this._stopEnsureTriggerElement();
++    this._setupObservers("-showing", "-visible", "-hiding", "-hidden", "hiding", "hidden");
++    if (!this.options.fixed) {
++      this._stopFollowingMousePosition();
++    }
++    if (!this.container) {
++      return;
++    }
++    this.adapter.removeClass(this.container, this["class"].visible);
++    this.adapter.removeClass(this.container, this["class"].showing);
++    this.adapter.addClass(this.container, this["class"].goingToHide);
++    this.setCss3Style(this.container, {
++      transitionDuration: "0s"
++    });
++    return this.defer(function() {
++      var hideDelay;
++      _this.adapter.removeClass(_this.container, _this["class"].goingToHide);
++      _this.adapter.addClass(_this.container, _this["class"].hiding);
++      hideDelay = 0;
++      if (_this.options.hideEffect && _this.options.hideEffectDuration) {
++        hideDelay = _this.options.hideEffectDuration;
++      }
++      _this.setCss3Style(_this.container, {
++        transitionDuration: "" + hideDelay + "s"
++      });
++      return _this._visibilityStateTimeoutId = _this.setTimeout(function() {
++        _this.adapter.removeClass(_this.container, _this["class"].hiding);
++        _this.adapter.addClass(_this.container, _this["class"].hidden);
++        _this.setCss3Style(_this.container, {
++          transitionDuration: "0s"
++        });
++        if (_this.options.removeElementsOnHide) {
++          _this.debug("Removing HTML elements.");
++          _this.adapter.remove(_this.container);
++          delete _this.container;
++          return delete _this.tooltipElement;
++        }
++      }, hideDelay);
++    });
++  };
++
++  Opentip.prototype._abortHiding = function() {
++    if (this.preparingToHide) {
++      this.debug("Aborting hiding.");
++      this._clearTimeouts();
++      this.preparingToHide = false;
++      return this._setupObservers("-hiding", "showing", "visible");
++    }
++  };
++
++  Opentip.prototype.reposition = function() {
++    var position, stem, _ref,
++      _this = this;
++    position = this.getPosition();
++    if (position == null) {
++      return;
++    }
++    stem = this.options.stem;
++    if (this.options.containInViewport) {
++      _ref = this._ensureViewportContainment(position), position = _ref.position, stem = _ref.stem;
++    }
++    if (this._positionsEqual(position, this.currentPosition)) {
++      return;
++    }
++    if (!(!this.options.stem || stem.eql(this.currentStem))) {
++      this.redraw = true;
++    }
++    this.currentPosition = position;
++    this.currentStem = stem;
++    this._draw();
++    this.adapter.css(this.container, {
++      left: "" + position.left + "px",
++      top: "" + position.top + "px"
++    });
++    return this.defer(function() {
++      var rawContainer, redrawFix;
++      rawContainer = _this.adapter.unwrap(_this.container);
++      rawContainer.style.visibility = "hidden";
++      redrawFix = rawContainer.offsetHeight;
++      return rawContainer.style.visibility = "visible";
++    });
++  };
++
++  Opentip.prototype.getPosition = function(tipJoint, targetJoint, stem) {
++    var additionalHorizontal, additionalVertical, offsetDistance, position, stemLength, targetDimensions, targetPosition, unwrappedTarget, _ref;
++    if (!this.container) {
++      return;
++    }
++    if (tipJoint == null) {
++      tipJoint = this.options.tipJoint;
++    }
++    if (targetJoint == null) {
++      targetJoint = this.options.targetJoint;
++    }
++    position = {};
++    if (this.options.target) {
++      targetPosition = this.adapter.offset(this.options.target);
++      targetDimensions = this.adapter.dimensions(this.options.target);
++      position = targetPosition;
++      if (targetJoint.right) {
++        unwrappedTarget = this.adapter.unwrap(this.options.target);
++        if (unwrappedTarget.getBoundingClientRect != null) {
++          position.left = unwrappedTarget.getBoundingClientRect().right + ((_ref = window.pageXOffset) != null ? _ref : document.body.scrollLeft);
++        } else {
++          position.left += targetDimensions.width;
++        }
++      } else if (targetJoint.center) {
++        position.left += Math.round(targetDimensions.width / 2);
++      }
++      if (targetJoint.bottom) {
++        position.top += targetDimensions.height;
++      } else if (targetJoint.middle) {
++        position.top += Math.round(targetDimensions.height / 2);
++      }
++      if (this.options.borderWidth) {
++        if (this.options.tipJoint.left) {
++          position.left += this.options.borderWidth;
++        }
++        if (this.options.tipJoint.right) {
++          position.left -= this.options.borderWidth;
++        }
++        if (this.options.tipJoint.top) {
++          position.top += this.options.borderWidth;
++        } else if (this.options.tipJoint.bottom) {
++          position.top -= this.options.borderWidth;
++        }
++      }
++    } else {
++      if (this.initialMousePosition) {
++        position = {
++          top: this.initialMousePosition.y,
++          left: this.initialMousePosition.x
++        };
++      } else {
++        position = {
++          top: mousePosition.y,
++          left: mousePosition.x
++        };
++      }
++    }
++    if (this.options.autoOffset) {
++      stemLength = this.options.stem ? this.options.stemLength : 0;
++      offsetDistance = stemLength && this.options.fixed ? 2 : 10;
++      additionalHorizontal = tipJoint.middle && !this.options.fixed ? 15 : 0;
++      additionalVertical = tipJoint.center && !this.options.fixed ? 15 : 0;
++      if (tipJoint.right) {
++        position.left -= offsetDistance + additionalHorizontal;
++      } else if (tipJoint.left) {
++        position.left += offsetDistance + additionalHorizontal;
++      }
++      if (tipJoint.bottom) {
++        position.top -= offsetDistance + additionalVertical;
++      } else if (tipJoint.top) {
++        position.top += offsetDistance + additionalVertical;
++      }
++      if (stemLength) {
++        if (stem == null) {
++          stem = this.options.stem;
++        }
++        if (stem.right) {
++          position.left -= stemLength;
++        } else if (stem.left) {
++          position.left += stemLength;
++        }
++        if (stem.bottom) {
++          position.top -= stemLength;
++        } else if (stem.top) {
++          position.top += stemLength;
++        }
++      }
++    }
++    position.left += this.options.offset[0];
++    position.top += this.options.offset[1];
++    if (tipJoint.right) {
++      position.left -= this.dimensions.width;
++    } else if (tipJoint.center) {
++      position.left -= Math.round(this.dimensions.width / 2);
++    }
++    if (tipJoint.bottom) {
++      position.top -= this.dimensions.height;
++    } else if (tipJoint.middle) {
++      position.top -= Math.round(this.dimensions.height / 2);
++    }
++    return position;
++  };
++
++  Opentip.prototype._ensureViewportContainment = function(position) {
++    var needsRepositioning, newSticksOut, originals, revertedX, revertedY, scrollOffset, stem, sticksOut, targetJoint, tipJoint, viewportDimensions, viewportPosition;
++    stem = this.options.stem;
++    originals = {
++      position: position,
++      stem: stem
++    };
++    if (!(this.visible && position)) {
++      return originals;
++    }
++    sticksOut = this._sticksOut(position);
++    if (!(sticksOut[0] || sticksOut[1])) {
++      return originals;
++    }
++    tipJoint = new Opentip.Joint(this.options.tipJoint);
++    if (this.options.targetJoint) {
++      targetJoint = new Opentip.Joint(this.options.targetJoint);
++    }
++    scrollOffset = this.adapter.scrollOffset();
++    viewportDimensions = this.adapter.viewportDimensions();
++    viewportPosition = [position.left - scrollOffset[0], position.top - scrollOffset[1]];
++    needsRepositioning = false;
++    if (viewportDimensions.width >= this.dimensions.width) {
++      if (sticksOut[0]) {
++        needsRepositioning = true;
++        switch (sticksOut[0]) {
++          case this.STICKS_OUT_LEFT:
++            tipJoint.setHorizontal("left");
++            if (this.options.targetJoint) {
++              targetJoint.setHorizontal("right");
++            }
++            break;
++          case this.STICKS_OUT_RIGHT:
++            tipJoint.setHorizontal("right");
++            if (this.options.targetJoint) {
++              targetJoint.setHorizontal("left");
++            }
++        }
++      }
++    }
++    if (viewportDimensions.height >= this.dimensions.height) {
++      if (sticksOut[1]) {
++        needsRepositioning = true;
++        switch (sticksOut[1]) {
++          case this.STICKS_OUT_TOP:
++            tipJoint.setVertical("top");
++            if (this.options.targetJoint) {
++              targetJoint.setVertical("bottom");
++            }
++            break;
++          case this.STICKS_OUT_BOTTOM:
++            tipJoint.setVertical("bottom");
++            if (this.options.targetJoint) {
++              targetJoint.setVertical("top");
++            }
++        }
++      }
++    }
++    if (!needsRepositioning) {
++      return originals;
++    }
++    if (this.options.stem) {
++      stem = tipJoint;
++    }
++    position = this.getPosition(tipJoint, targetJoint, stem);
++    newSticksOut = this._sticksOut(position);
++    revertedX = false;
++    revertedY = false;
++    if (newSticksOut[0] && (newSticksOut[0] !== sticksOut[0])) {
++      revertedX = true;
++      tipJoint.setHorizontal(this.options.tipJoint.horizontal);
++      if (this.options.targetJoint) {
++        targetJoint.setHorizontal(this.options.targetJoint.horizontal);
++      }
++    }
++    if (newSticksOut[1] && (newSticksOut[1] !== sticksOut[1])) {
++      revertedY = true;
++      tipJoint.setVertical(this.options.tipJoint.vertical);
++      if (this.options.targetJoint) {
++        targetJoint.setVertical(this.options.targetJoint.vertical);
++      }
++    }
++    if (revertedX && revertedY) {
++      return originals;
++    }
++    if (revertedX || revertedY) {
++      if (this.options.stem) {
++        stem = tipJoint;
++      }
++      position = this.getPosition(tipJoint, targetJoint, stem);
++    }
++    return {
++      position: position,
++      stem: stem
++    };
++  };
++
++  Opentip.prototype._sticksOut = function(position) {
++    var positionOffset, scrollOffset, sticksOut, viewportDimensions;
++    scrollOffset = this.adapter.scrollOffset();
++    viewportDimensions = this.adapter.viewportDimensions();
++    positionOffset = [position.left - scrollOffset[0], position.top - scrollOffset[1]];
++    sticksOut = [false, false];
++    if (positionOffset[0] < 0) {
++      sticksOut[0] = this.STICKS_OUT_LEFT;
++    } else if (positionOffset[0] + this.dimensions.width > viewportDimensions.width) {
++      sticksOut[0] = this.STICKS_OUT_RIGHT;
++    }
++    if (positionOffset[1] < 0) {
++      sticksOut[1] = this.STICKS_OUT_TOP;
++    } else if (positionOffset[1] + this.dimensions.height > viewportDimensions.height) {
++      sticksOut[1] = this.STICKS_OUT_BOTTOM;
++    }
++    return sticksOut;
++  };
++
++  Opentip.prototype._draw = function() {
++    var backgroundCanvas, bulge, canvasDimensions, canvasPosition, closeButton, closeButtonInner, closeButtonOuter, ctx, drawCorner, drawLine, hb, position, stemBase, stemLength, _i, _len, _ref, _ref1, _ref2,
++      _this = this;
++    if (!(this.backgroundCanvas && this.redraw)) {
++      return;
++    }
++    this.debug("Drawing background.");
++    this.redraw = false;
++    if (this.currentStem) {
++      _ref = ["top", "right", "bottom", "left"];
++      for (_i = 0, _len = _ref.length; _i < _len; _i++) {
++        position = _ref[_i];
++        this.adapter.removeClass(this.container, "stem-" + position);
++      }
++      this.adapter.addClass(this.container, "stem-" + this.currentStem.horizontal);
++      this.adapter.addClass(this.container, "stem-" + this.currentStem.vertical);
++    }
++    closeButtonInner = [0, 0];
++    closeButtonOuter = [0, 0];
++    if (__indexOf.call(this.options.hideTriggers, "closeButton") >= 0) {
++      closeButton = new Opentip.Joint(((_ref1 = this.currentStem) != null ? _ref1.toString() : void 0) === "top right" ? "top left" : "top right");
++      closeButtonInner = [this.options.closeButtonRadius + this.options.closeButtonOffset[0], this.options.closeButtonRadius + this.options.closeButtonOffset[1]];
++      closeButtonOuter = [this.options.closeButtonRadius - this.options.closeButtonOffset[0], this.options.closeButtonRadius - this.options.closeButtonOffset[1]];
++    }
++    canvasDimensions = this.adapter.clone(this.dimensions);
++    canvasPosition = [0, 0];
++    if (this.options.borderWidth) {
++      canvasDimensions.width += this.options.borderWidth * 2;
++      canvasDimensions.height += this.options.borderWidth * 2;
++      canvasPosition[0] -= this.options.borderWidth;
++      canvasPosition[1] -= this.options.borderWidth;
++    }
++    if (this.options.shadow) {
++      canvasDimensions.width += this.options.shadowBlur * 2;
++      canvasDimensions.width += Math.max(0, this.options.shadowOffset[0] - this.options.shadowBlur * 2);
++      canvasDimensions.height += this.options.shadowBlur * 2;
++      canvasDimensions.height += Math.max(0, this.options.shadowOffset[1] - this.options.shadowBlur * 2);
++      canvasPosition[0] -= Math.max(0, this.options.shadowBlur - this.options.shadowOffset[0]);
++      canvasPosition[1] -= Math.max(0, this.options.shadowBlur - this.options.shadowOffset[1]);
++    }
++    bulge = {
++      left: 0,
++      right: 0,
++      top: 0,
++      bottom: 0
++    };
++    if (this.currentStem) {
++      if (this.currentStem.left) {
++        bulge.left = this.options.stemLength;
++      } else if (this.currentStem.right) {
++        bulge.right = this.options.stemLength;
++      }
++      if (this.currentStem.top) {
++        bulge.top = this.options.stemLength;
++      } else if (this.currentStem.bottom) {
++        bulge.bottom = this.options.stemLength;
++      }
++    }
++    if (closeButton) {
++      if (closeButton.left) {
++        bulge.left = Math.max(bulge.left, closeButtonOuter[0]);
++      } else if (closeButton.right) {
++        bulge.right = Math.max(bulge.right, closeButtonOuter[0]);
++      }
++      if (closeButton.top) {
++        bulge.top = Math.max(bulge.top, closeButtonOuter[1]);
++      } else if (closeButton.bottom) {
++        bulge.bottom = Math.max(bulge.bottom, closeButtonOuter[1]);
++      }
++    }
++    canvasDimensions.width += bulge.left + bulge.right;
++    canvasDimensions.height += bulge.top + bulge.bottom;
++    canvasPosition[0] -= bulge.left;
++    canvasPosition[1] -= bulge.top;
++    if (this.currentStem && this.options.borderWidth) {
++      _ref2 = this._getPathStemMeasures(this.options.stemBase, this.options.stemLength, this.options.borderWidth), stemLength = _ref2.stemLength, stemBase = _ref2.stemBase;
++    }
++    backgroundCanvas = this.adapter.unwrap(this.backgroundCanvas);
++    backgroundCanvas.width = canvasDimensions.width;
++    backgroundCanvas.height = canvasDimensions.height;
++    this.adapter.css(this.backgroundCanvas, {
++      width: "" + backgroundCanvas.width + "px",
++      height: "" + backgroundCanvas.height + "px",
++      left: "" + canvasPosition[0] + "px",
++      top: "" + canvasPosition[1] + "px"
++    });
++    ctx = backgroundCanvas.getContext("2d");
++    ctx.setTransform(1, 0, 0, 1, 0, 0);
++    ctx.clearRect(0, 0, backgroundCanvas.width, backgroundCanvas.height);
++    ctx.beginPath();
++    ctx.fillStyle = this._getColor(ctx, this.dimensions, this.options.background, this.options.backgroundGradientHorizontal);
++    ctx.lineJoin = "miter";
++    ctx.miterLimit = 500;
++    hb = this.options.borderWidth / 2;
++    if (this.options.borderWidth) {
++      ctx.strokeStyle = this.options.borderColor;
++      ctx.lineWidth = this.options.borderWidth;
++    } else {
++      stemLength = this.options.stemLength;
++      stemBase = this.options.stemBase;
++    }
++    if (stemBase == null) {
++      stemBase = 0;
++    }
++    drawLine = function(length, stem, first) {
++      if (first) {
++        ctx.moveTo(Math.max(stemBase, _this.options.borderRadius, closeButtonInner[0]) + 1 - hb, -hb);
++      }
++      if (stem) {
++        ctx.lineTo(length / 2 - stemBase / 2, -hb);
++        ctx.lineTo(length / 2, -stemLength - hb);
++        return ctx.lineTo(length / 2 + stemBase / 2, -hb);
++      }
++    };
++    drawCorner = function(stem, closeButton, i) {
++      var angle1, angle2, innerWidth, offset;
++      if (stem) {
++        ctx.lineTo(-stemBase + hb, 0 - hb);
++        ctx.lineTo(stemLength + hb, -stemLength - hb);
++        return ctx.lineTo(hb, stemBase - hb);
++      } else if (closeButton) {
++        offset = _this.options.closeButtonOffset;
++        innerWidth = closeButtonInner[0];
++        if (i % 2 !== 0) {
++          offset = [offset[1], offset[0]];
++          innerWidth = closeButtonInner[1];
++        }
++        angle1 = Math.acos(offset[1] / _this.options.closeButtonRadius);
++        angle2 = Math.acos(offset[0] / _this.options.closeButtonRadius);
++        ctx.lineTo(-innerWidth + hb, -hb);
++        return ctx.arc(hb - offset[0], -hb + offset[1], _this.options.closeButtonRadius, -(Math.PI / 2 + angle1), angle2, false);
++      } else {
++        ctx.lineTo(-_this.options.borderRadius + hb, -hb);
++        return ctx.quadraticCurveTo(hb, -hb, hb, _this.options.borderRadius - hb);
++      }
++    };
++    ctx.translate(-canvasPosition[0], -canvasPosition[1]);
++    ctx.save();
++    (function() {
++      var cornerStem, i, lineLength, lineStem, positionIdx, positionX, positionY, rotation, _j, _ref3, _results;
++      _results = [];
++      for (i = _j = 0, _ref3 = Opentip.positions.length / 2; 0 <= _ref3 ? _j < _ref3 : _j > _ref3; i = 0 <= _ref3 ? ++_j : --_j) {
++        positionIdx = i * 2;
++        positionX = i === 0 || i === 3 ? 0 : _this.dimensions.width;
++        positionY = i < 2 ? 0 : _this.dimensions.height;
++        rotation = (Math.PI / 2) * i;
++        lineLength = i % 2 === 0 ? _this.dimensions.width : _this.dimensions.height;
++        lineStem = new Opentip.Joint(Opentip.positions[positionIdx]);
++        cornerStem = new Opentip.Joint(Opentip.positions[positionIdx + 1]);
++        ctx.save();
++        ctx.translate(positionX, positionY);
++        ctx.rotate(rotation);
++        drawLine(lineLength, lineStem.eql(_this.currentStem), i === 0);
++        ctx.translate(lineLength, 0);
++        drawCorner(cornerStem.eql(_this.currentStem), cornerStem.eql(closeButton), i);
++        _results.push(ctx.restore());
++      }
++      return _results;
++    })();
++    ctx.closePath();
++    ctx.save();
++    if (this.options.shadow) {
++      ctx.shadowColor = this.options.shadowColor;
++      ctx.shadowBlur = this.options.shadowBlur;
++      ctx.shadowOffsetX = this.options.shadowOffset[0];
++      ctx.shadowOffsetY = this.options.shadowOffset[1];
++    }
++    ctx.fill();
++    ctx.restore();
++    if (this.options.borderWidth) {
++      ctx.stroke();
++    }
++    ctx.restore();
++    if (closeButton) {
++      return (function() {
++        var crossCenter, crossHeight, crossWidth, hcs, linkCenter;
++        crossWidth = crossHeight = _this.options.closeButtonRadius * 2;
++        if (closeButton.toString() === "top right") {
++          linkCenter = [_this.dimensions.width - _this.options.closeButtonOffset[0], _this.options.closeButtonOffset[1]];
++          crossCenter = [linkCenter[0] + hb, linkCenter[1] - hb];
++        } else {
++          linkCenter = [_this.options.closeButtonOffset[0], _this.options.closeButtonOffset[1]];
++          crossCenter = [linkCenter[0] - hb, linkCenter[1] - hb];
++        }
++        ctx.translate(crossCenter[0], crossCenter[1]);
++        hcs = _this.options.closeButtonCrossSize / 2;
++        ctx.save();
++        ctx.beginPath();
++        ctx.strokeStyle = _this.options.closeButtonCrossColor;
++        ctx.lineWidth = _this.options.closeButtonCrossLineWidth;
++        ctx.lineCap = "round";
++        ctx.moveTo(-hcs, -hcs);
++        ctx.lineTo(hcs, hcs);
++        ctx.stroke();
++        ctx.beginPath();
++        ctx.moveTo(hcs, -hcs);
++        ctx.lineTo(-hcs, hcs);
++        ctx.stroke();
++        ctx.restore();
++        return _this.adapter.css(_this.closeButtonElement, {
++          left: "" + (linkCenter[0] - hcs - _this.options.closeButtonLinkOverscan) + "px",
++          top: "" + (linkCenter[1] - hcs - _this.options.closeButtonLinkOverscan) + "px",
++          width: "" + (_this.options.closeButtonCrossSize + _this.options.closeButtonLinkOverscan * 2) + "px",
++          height: "" + (_this.options.closeButtonCrossSize + _this.options.closeButtonLinkOverscan * 2) + "px"
++        });
++      })();
++    }
++  };
++
++  Opentip.prototype._getPathStemMeasures = function(outerStemBase, outerStemLength, borderWidth) {
++    var angle, distanceBetweenTips, halfAngle, hb, rhombusSide, stemBase, stemLength;
++    hb = borderWidth / 2;
++    halfAngle = Math.atan((outerStemBase / 2) / outerStemLength);
++    angle = halfAngle * 2;
++    rhombusSide = hb / Math.sin(angle);
++    distanceBetweenTips = 2 * rhombusSide * Math.cos(halfAngle);
++    stemLength = hb + outerStemLength - distanceBetweenTips;
++    if (stemLength < 0) {
++      throw new Error("Sorry but your stemLength / stemBase ratio is strange.");
++    }
++    stemBase = (Math.tan(halfAngle) * stemLength) * 2;
++    return {
++      stemLength: stemLength,
++      stemBase: stemBase
++    };
++  };
++
++  Opentip.prototype._getColor = function(ctx, dimensions, color, horizontal) {
++    var colorStop, gradient, i, _i, _len;
++    if (horizontal == null) {
++      horizontal = false;
++    }
++    if (typeof color === "string") {
++      return color;
++    }
++    if (horizontal) {
++      gradient = ctx.createLinearGradient(0, 0, dimensions.width, 0);
++    } else {
++      gradient = ctx.createLinearGradient(0, 0, 0, dimensions.height);
++    }
++    for (i = _i = 0, _len = color.length; _i < _len; i = ++_i) {
++      colorStop = color[i];
++      gradient.addColorStop(colorStop[0], colorStop[1]);
++    }
++    return gradient;
++  };
++
++  Opentip.prototype._searchAndActivateCloseButtons = function() {
++    var element, _i, _len, _ref;
++    _ref = this.adapter.findAll(this.container, "." + this["class"].close);
++    for (_i = 0, _len = _ref.length; _i < _len; _i++) {
++      element = _ref[_i];
++      this.hideTriggers.push({
++        element: this.adapter.wrap(element),
++        event: "click"
++      });
++    }
++    if (this.currentObservers.showing) {
++      this._setupObservers("-showing", "showing");
++    }
++    if (this.currentObservers.visible) {
++      return this._setupObservers("-visible", "visible");
++    }
++  };
++
++  Opentip.prototype._activateFirstInput = function() {
++    var input;
++    input = this.adapter.unwrap(this.adapter.find(this.container, "input, textarea"));
++    return input != null ? typeof input.focus === "function" ? input.focus() : void 0 : void 0;
++  };
++
++  Opentip.prototype._followMousePosition = function() {
++    if (!this.options.fixed) {
++      return Opentip._observeMousePosition(this.bound.reposition);
++    }
++  };
++
++  Opentip.prototype._stopFollowingMousePosition = function() {
++    if (!this.options.fixed) {
++      return Opentip._stopObservingMousePosition(this.bound.reposition);
++    }
++  };
++
++  Opentip.prototype._clearShowTimeout = function() {
++    return clearTimeout(this._showTimeoutId);
++  };
++
++  Opentip.prototype._clearHideTimeout = function() {
++    return clearTimeout(this._hideTimeoutId);
++  };
++
++  Opentip.prototype._clearTimeouts = function() {
++    clearTimeout(this._visibilityStateTimeoutId);
++    this._clearShowTimeout();
++    return this._clearHideTimeout();
++  };
++
++  Opentip.prototype._triggerElementExists = function() {
++    var el;
++    el = this.adapter.unwrap(this.triggerElement);
++    while (el.parentNode) {
++      if (el.parentNode.tagName === "BODY") {
++        return true;
++      }
++      el = el.parentNode;
++    }
++    return false;
++  };
++
++  Opentip.prototype._loadAjax = function() {
++    var _this = this;
++    if (this.loading) {
++      return;
++    }
++    this.loaded = false;
++    this.loading = true;
++    this.adapter.addClass(this.container, this["class"].loading);
++    this.setContent("");
++    this.debug("Loading content from " + this.options.ajax);
++    return this.adapter.ajax({
++      url: this.options.ajax,
++      method: this.options.ajaxMethod,
++      onSuccess: function(responseText) {
++        _this.debug("Loading successful.");
++        _this.adapter.removeClass(_this.container, _this["class"].loading);
++        return _this.setContent(responseText);
++      },
++      onError: function(error) {
++        var message;
++        message = _this.options.ajaxErrorMessage;
++        _this.debug(message, error);
++        _this.setContent(message);
++        return _this.adapter.addClass(_this.container, _this["class"].ajaxError);
++      },
++      onComplete: function() {
++        _this.adapter.removeClass(_this.container, _this["class"].loading);
++        _this.loading = false;
++        _this.loaded = true;
++        _this._searchAndActivateCloseButtons();
++        _this._activateFirstInput();
++        return _this.reposition();
++      }
++    });
++  };
++
++  Opentip.prototype._ensureTriggerElement = function() {
++    if (!this._triggerElementExists()) {
++      this.deactivate();
++      return this._stopEnsureTriggerElement();
++    }
++  };
++
++  Opentip.prototype._ensureTriggerElementInterval = 1000;
++
++  Opentip.prototype._startEnsureTriggerElement = function() {
++    var _this = this;
++    return this._ensureTriggerElementTimeoutId = setInterval((function() {
++      return _this._ensureTriggerElement();
++    }), this._ensureTriggerElementInterval);
++  };
++
++  Opentip.prototype._stopEnsureTriggerElement = function() {
++    return clearInterval(this._ensureTriggerElementTimeoutId);
++  };
++
++  return Opentip;
++
++})();
++
++vendors = ["khtml", "ms", "o", "moz", "webkit"];
++
++Opentip.prototype.setCss3Style = function(element, styles) {
++  var prop, value, vendor, vendorProp, _results;
++  element = this.adapter.unwrap(element);
++  _results = [];
++  for (prop in styles) {
++    if (!__hasProp.call(styles, prop)) continue;
++    value = styles[prop];
++    if (element.style[prop] != null) {
++      _results.push(element.style[prop] = value);
++    } else {
++      _results.push((function() {
++        var _i, _len, _results1;
++        _results1 = [];
++        for (_i = 0, _len = vendors.length; _i < _len; _i++) {
++          vendor = vendors[_i];
++          vendorProp = "" + (this.ucfirst(vendor)) + (this.ucfirst(prop));
++          if (element.style[vendorProp] != null) {
++            _results1.push(element.style[vendorProp] = value);
++          } else {
++            _results1.push(void 0);
++          }
++        }
++        return _results1;
++      }).call(this));
++    }
++  }
++  return _results;
++};
++
++Opentip.prototype.defer = function(func) {
++  return setTimeout(func, 0);
++};
++
++Opentip.prototype.setTimeout = function(func, seconds) {
++  return setTimeout(func, seconds ? seconds * 1000 : 0);
++};
++
++Opentip.prototype.ucfirst = function(string) {
++  if (string == null) {
++    return "";
++  }
++  return string.charAt(0).toUpperCase() + string.slice(1);
++};
++
++Opentip.prototype.dasherize = function(string) {
++  return string.replace(/([A-Z])/g, function(_, character) {
++    return "-" + (character.toLowerCase());
++  });
++};
++
++mousePositionObservers = [];
++
++mousePosition = {
++  x: 0,
++  y: 0
++};
++
++mouseMoved = function(e) {
++  var observer, _i, _len, _results;
++  mousePosition = Opentip.adapter.mousePosition(e);
++  _results = [];
++  for (_i = 0, _len = mousePositionObservers.length; _i < _len; _i++) {
++    observer = mousePositionObservers[_i];
++    _results.push(observer());
++  }
++  return _results;
++};
++
++Opentip.followMousePosition = function() {
++  return Opentip.adapter.observe(document.body, "mousemove", mouseMoved);
++};
++
++Opentip._observeMousePosition = function(observer) {
++  return mousePositionObservers.push(observer);
++};
++
++Opentip._stopObservingMousePosition = function(removeObserver) {
++  var observer;
++  return mousePositionObservers = (function() {
++    var _i, _len, _results;
++    _results = [];
++    for (_i = 0, _len = mousePositionObservers.length; _i < _len; _i++) {
++      observer = mousePositionObservers[_i];
++      if (observer !== removeObserver) {
++        _results.push(observer);
++      }
++    }
++    return _results;
++  })();
++};
++
++Opentip.Joint = (function() {
++
++  function Joint(pointerString) {
++    if (pointerString == null) {
++      return;
++    }
++    if (pointerString instanceof Opentip.Joint) {
++      pointerString = pointerString.toString();
++    }
++    this.set(pointerString);
++    this;
++
++  }
++
++  Joint.prototype.set = function(string) {
++    string = string.toLowerCase();
++    this.setHorizontal(string);
++    this.setVertical(string);
++    return this;
++  };
++
++  Joint.prototype.setHorizontal = function(string) {
++    var i, valid, _i, _j, _len, _len1, _results;
++    valid = ["left", "center", "right"];
++    for (_i = 0, _len = valid.length; _i < _len; _i++) {
++      i = valid[_i];
++      if (~string.indexOf(i)) {
++        this.horizontal = i.toLowerCase();
++      }
++    }
++    if (this.horizontal == null) {
++      this.horizontal = "center";
++    }
++    _results = [];
++    for (_j = 0, _len1 = valid.length; _j < _len1; _j++) {
++      i = valid[_j];
++      _results.push(this[i] = this.horizontal === i ? i : void 0);
++    }
++    return _results;
++  };
++
++  Joint.prototype.setVertical = function(string) {
++    var i, valid, _i, _j, _len, _len1, _results;
++    valid = ["top", "middle", "bottom"];
++    for (_i = 0, _len = valid.length; _i < _len; _i++) {
++      i = valid[_i];
++      if (~string.indexOf(i)) {
++        this.vertical = i.toLowerCase();
++      }
++    }
++    if (this.vertical == null) {
++      this.vertical = "middle";
++    }
++    _results = [];
++    for (_j = 0, _len1 = valid.length; _j < _len1; _j++) {
++      i = valid[_j];
++      _results.push(this[i] = this.vertical === i ? i : void 0);
++    }
++    return _results;
++  };
++
++  Joint.prototype.eql = function(pointer) {
++    return (pointer != null) && this.horizontal === pointer.horizontal && this.vertical === pointer.vertical;
++  };
++
++  Joint.prototype.flip = function() {
++    var flippedIndex, positionIdx;
++    positionIdx = Opentip.position[this.toString(true)];
++    flippedIndex = (positionIdx + 4) % 8;
++    this.set(Opentip.positions[flippedIndex]);
++    return this;
++  };
++
++  Joint.prototype.toString = function(camelized) {
++    var horizontal, vertical;
++    if (camelized == null) {
++      camelized = false;
++    }
++    vertical = this.vertical === "middle" ? "" : this.vertical;
++    horizontal = this.horizontal === "center" ? "" : this.horizontal;
++    if (vertical && horizontal) {
++      if (camelized) {
++        horizontal = Opentip.prototype.ucfirst(horizontal);
++      } else {
++        horizontal = " " + horizontal;
++      }
++    }
++    return "" + vertical + horizontal;
++  };
++
++  return Joint;
++
++})();
++
++Opentip.prototype._positionsEqual = function(posA, posB) {
++  return (posA != null) && (posB != null) && posA.left === posB.left && posA.top === posB.top;
++};
++
++Opentip.prototype._dimensionsEqual = function(dimA, dimB) {
++  return (dimA != null) && (dimB != null) && dimA.width === dimB.width && dimA.height === dimB.height;
++};
++
++Opentip.prototype.debug = function() {
++  var args;
++  args = 1 <= arguments.length ? __slice.call(arguments, 0) : [];
++  if (Opentip.debug && ((typeof console !== "undefined" && console !== null ? console.debug : void 0) != null)) {
++    args.unshift("#" + this.id + " |");
++    return console.debug.apply(console, args);
++  }
++};
++
++Opentip.findElements = function() {
++  var adapter, content, element, optionName, optionValue, options, _i, _len, _ref, _results;
++  adapter = Opentip.adapter;
++  _ref = adapter.findAll(document.body, "[data-ot]");
++  _results = [];
++  for (_i = 0, _len = _ref.length; _i < _len; _i++) {
++    element = _ref[_i];
++    options = {};
++    content = adapter.data(element, "ot");
++    if (content === "" || content === "true" || content === "yes") {
++      content = adapter.attr(element, "title");
++      adapter.attr(element, "title", "");
++    }
++    content = content || "";
++    for (optionName in Opentip.styles.standard) {
++      optionValue = adapter.data(element, "ot" + (Opentip.prototype.ucfirst(optionName)));
++      if (optionValue != null) {
++        if (optionValue === "yes" || optionValue === "true" || optionValue === "on") {
++          optionValue = true;
++        } else if (optionValue === "no" || optionValue === "false" || optionValue === "off") {
++          optionValue = false;
++        }
++        options[optionName] = optionValue;
++      }
++    }
++    _results.push(new Opentip(element, content, options));
++  }
++  return _results;
++};
++
++Opentip.version = "2.4.6";
++
++Opentip.debug = false;
++
++Opentip.lastId = 0;
++
++Opentip.lastZIndex = 100;
++
++Opentip.tips = [];
++
++Opentip._abortShowingGroup = function(group, originatingOpentip) {
++  var opentip, _i, _len, _ref, _results;
++  _ref = Opentip.tips;
++  _results = [];
++  for (_i = 0, _len = _ref.length; _i < _len; _i++) {
++    opentip = _ref[_i];
++    if (opentip !== originatingOpentip && opentip.options.group === group) {
++      _results.push(opentip._abortShowing());
++    } else {
++      _results.push(void 0);
++    }
++  }
++  return _results;
++};
++
++Opentip._hideGroup = function(group, originatingOpentip) {
++  var opentip, _i, _len, _ref, _results;
++  _ref = Opentip.tips;
++  _results = [];
++  for (_i = 0, _len = _ref.length; _i < _len; _i++) {
++    opentip = _ref[_i];
++    if (opentip !== originatingOpentip && opentip.options.group === group) {
++      _results.push(opentip.hide());
++    } else {
++      _results.push(void 0);
++    }
++  }
++  return _results;
++};
++
++Opentip.adapters = {};
++
++Opentip.adapter = null;
++
++firstAdapter = true;
++
++Opentip.addAdapter = function(adapter) {
++  Opentip.adapters[adapter.name] = adapter;
++  if (firstAdapter) {
++    Opentip.adapter = adapter;
++    adapter.domReady(Opentip.findElements);
++    adapter.domReady(Opentip.followMousePosition);
++    return firstAdapter = false;
++  }
++};
++
++Opentip.positions = ["top", "topRight", "right", "bottomRight", "bottom", "bottomLeft", "left", "topLeft"];
++
++Opentip.position = {};
++
++_ref = Opentip.positions;
++for (i = _i = 0, _len = _ref.length; _i < _len; i = ++_i) {
++  position = _ref[i];
++  Opentip.position[position] = i;
++}
++
++Opentip.styles = {
++  standard: {
++    "extends": null,
++    title: void 0,
++    escapeTitle: true,
++    escapeContent: false,
++    className: "standard",
++    stem: true,
++    delay: null,
++    hideDelay: 0.1,
++    fixed: false,
++    showOn: "mouseover",
++    hideTrigger: "trigger",
++    hideTriggers: [],
++    hideOn: null,
++    removeElementsOnHide: false,
++    offset: [0, 0],
++    containInViewport: true,
++    autoOffset: true,
++    showEffect: "appear",
++    hideEffect: "fade",
++    showEffectDuration: 0.3,
++    hideEffectDuration: 0.2,
++    stemLength: 5,
++    stemBase: 8,
++    tipJoint: "top left",
++    target: null,
++    targetJoint: null,
++    cache: true,
++    ajax: false,
++    ajaxMethod: "GET",
++    ajaxErrorMessage: "There was a problem downloading the content.",
++    group: null,
++    style: null,
++    background: "#fff18f",
++    backgroundGradientHorizontal: false,
++    closeButtonOffset: [5, 5],
++    closeButtonRadius: 7,
++    closeButtonCrossSize: 4,
++    closeButtonCrossColor: "#d2c35b",
++    closeButtonCrossLineWidth: 1.5,
++    closeButtonLinkOverscan: 6,
++    borderRadius: 5,
++    borderWidth: 1,
++    borderColor: "#f2e37b",
++    shadow: true,
++    shadowBlur: 10,
++    shadowOffset: [3, 3],
++    shadowColor: "rgba(0, 0, 0, 0.1)"
++  },
++  glass: {
++    "extends": "standard",
++    className: "glass",
++    background: [[0, "rgba(252, 252, 252, 0.8)"], [0.5, "rgba(255, 255, 255, 0.8)"], [0.5, "rgba(250, 250, 250, 0.9)"], [1, "rgba(245, 245, 245, 0.9)"]],
++    borderColor: "#eee",
++    closeButtonCrossColor: "rgba(0, 0, 0, 0.2)",
++    borderRadius: 15,
++    closeButtonRadius: 10,
++    closeButtonOffset: [8, 8]
++  },
++  dark: {
++    "extends": "standard",
++    className: "dark",
++    borderRadius: 13,
++    borderColor: "#444",
++    closeButtonCrossColor: "rgba(240, 240, 240, 1)",
++    shadowColor: "rgba(0, 0, 0, 0.3)",
++    shadowOffset: [2, 2],
++    background: [[0, "rgba(30, 30, 30, 0.7)"], [0.5, "rgba(30, 30, 30, 0.8)"], [0.5, "rgba(10, 10, 10, 0.8)"], [1, "rgba(10, 10, 10, 0.9)"]]
++  },
++  alert: {
++    "extends": "standard",
++    className: "alert",
++    borderRadius: 1,
++    borderColor: "#AE0D11",
++    closeButtonCrossColor: "rgba(255, 255, 255, 1)",
++    shadowColor: "rgba(0, 0, 0, 0.3)",
++    shadowOffset: [2, 2],
++    background: [[0, "rgba(203, 15, 19, 0.7)"], [0.5, "rgba(203, 15, 19, 0.8)"], [0.5, "rgba(189, 14, 18, 0.8)"], [1, "rgba(179, 14, 17, 0.9)"]]
++  }
++};
++
++Opentip.defaultStyle = "standard";
++
++if (typeof module !== "undefined" && module !== null) {
++  module.exports = Opentip;
++} else {
++  window.Opentip = Opentip;
++}
++
++
++// Generated by CoffeeScript 1.4.0
++var __slice = [].slice;
++
++(function($) {
++  var Adapter;
++  $.fn.opentip = function(content, title, options) {
++    return new Opentip(this, content, title, options);
++  };
++  Adapter = (function() {
++
++    function Adapter() {}
++
++    Adapter.prototype.name = "jquery";
++
++    Adapter.prototype.domReady = function(callback) {
++      return $(callback);
++    };
++
++    Adapter.prototype.create = function(html) {
++      return $(html);
++    };
++
++    Adapter.prototype.wrap = function(element) {
++      element = $(element);
++      if (element.length > 1) {
++        throw new Error("Multiple elements provided.");
++      }
++      return element;
++    };
++
++    Adapter.prototype.unwrap = function(element) {
++      return $(element)[0];
++    };
++
++    Adapter.prototype.tagName = function(element) {
++      return this.unwrap(element).tagName;
++    };
++
++    Adapter.prototype.attr = function() {
++      var args, element, _ref;
++      element = arguments[0], args = 2 <= arguments.length ? __slice.call(arguments, 1) : [];
++      return (_ref = $(element)).attr.apply(_ref, args);
++    };
++
++    Adapter.prototype.data = function() {
++      var args, element, _ref;
++      element = arguments[0], args = 2 <= arguments.length ? __slice.call(arguments, 1) : [];
++      return (_ref = $(element)).data.apply(_ref, args);
++    };
++
++    Adapter.prototype.find = function(element, selector) {
++      return $(element).find(selector).get(0);
++    };
++
++    Adapter.prototype.findAll = function(element, selector) {
++      return $(element).find(selector);
++    };
++
++    Adapter.prototype.update = function(element, content, escape) {
++      element = $(element);
++      if (escape) {
++        return element.text(content);
++      } else {
++        return element.html(content);
++      }
++    };
++
++    Adapter.prototype.append = function(element, child) {
++      return $(element).append(child);
++    };
++
++    Adapter.prototype.remove = function(element) {
++      return $(element).remove();
++    };
++
++    Adapter.prototype.addClass = function(element, className) {
++      return $(element).addClass(className);
++    };
++
++    Adapter.prototype.removeClass = function(element, className) {
++      return $(element).removeClass(className);
++    };
++
++    Adapter.prototype.css = function(element, properties) {
++      return $(element).css(properties);
++    };
++
++    Adapter.prototype.dimensions = function(element) {
++      return {
++        width: $(element).outerWidth(),
++        height: $(element).outerHeight()
++      };
++    };
++
++    Adapter.prototype.scrollOffset = function() {
++      return [window.pageXOffset || document.documentElement.scrollLeft || document.body.scrollLeft, window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop];
++    };
++
++    Adapter.prototype.viewportDimensions = function() {
++      return {
++        width: document.documentElement.clientWidth,
++        height: document.documentElement.clientHeight
++      };
++    };
++
++    Adapter.prototype.mousePosition = function(e) {
++      if (e == null) {
++        return null;
++      }
++      return {
++        x: e.pageX,
++        y: e.pageY
++      };
++    };
++
++    Adapter.prototype.offset = function(element) {
++      var offset;
++      offset = $(element).offset();
++      return {
++        left: offset.left,
++        top: offset.top
++      };
++    };
++
++    Adapter.prototype.observe = function(element, eventName, observer) {
++      return $(element).bind(eventName, observer);
++    };
++
++    Adapter.prototype.stopObserving = function(element, eventName, observer) {
++      return $(element).unbind(eventName, observer);
++    };
++
++    Adapter.prototype.ajax = function(options) {
++      var _ref, _ref1;
++      if (options.url == null) {
++        throw new Error("No url provided");
++      }
++      return $.ajax({
++        url: options.url,
++        type: (_ref = (_ref1 = options.method) != null ? _ref1.toUpperCase() : void 0) != null ? _ref : "GET"
++      }).done(function(content) {
++        return typeof options.onSuccess === "function" ? options.onSuccess(content) : void 0;
++      }).fail(function(request) {
++        return typeof options.onError === "function" ? options.onError("Server responded with status " + request.status) : void 0;
++      }).always(function() {
++        return typeof options.onComplete === "function" ? options.onComplete() : void 0;
++      });
++    };
++
++    Adapter.prototype.clone = function(object) {
++      return $.extend({}, object);
++    };
++
++    Adapter.prototype.extend = function() {
++      var sources, target;
++      target = arguments[0], sources = 2 <= arguments.length ? __slice.call(arguments, 1) : [];
++      return $.extend.apply($, [target].concat(__slice.call(sources)));
++    };
++
++    return Adapter;
++
++  })();
++  return Opentip.addAdapter(new Adapter);
++})(jQuery);
++});
+\ No newline at end of file
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/styles/BBOOTS/template/js/opentip-jquery.min.js" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/styles/BBOOTS/template/js/opentip-jquery.min.js"
+new file mode 100644
+index 000000000..c47ebb565
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/styles/BBOOTS/template/js/opentip-jquery.min.js"
+@@ -0,0 +1,6 @@
++// Opentip v2.4.6
++// Copyright (c) 2009-2012
++// www.opentip.org
++// MIT Licensed
++head.ready(function(){var Opentip,firstAdapter,i,mouseMoved,mousePosition,mousePositionObservers,position,vendors,_i,_len,_ref,__slice=[].slice,__indexOf=[].indexOf||function(t){for(var e=0,i=this.length;i>e;e++)if(e in this&&this[e]===t)return e;return-1},__hasProp={}.hasOwnProperty;for(Opentip=function(){function t(e,i,o,s){var n,r,a,h,p,d,l,u,c,g,f,m,v,b,w=this;if(this.id=++t.lastId,this.debug("Creating Opentip."),t.tips.push(this),this.adapter=t.adapter,n=this.adapter.data(e,"opentips")||[],n.push(this),this.adapter.data(e,"opentips",n),this.triggerElement=this.adapter.wrap(e),this.triggerElement.length>1)throw Error("You can't call Opentip on multiple elements.");if(1>this.triggerElement.length)throw Error("Invalid element.");this.loaded=!1,this.loading=!1,this.visible=!1,this.waitingToShow=!1,this.waitingToHide=!1,this.currentPosition={left:0,top:0},this.dimensions={width:100,height:50},this.content="",this.redraw=!0,this.currentObservers={showing:!1,visible:!1,hiding:!1,hidden:!1},s=this.adapter.clone(s),typeof i=="object"?(s=i,i=o=void 0):typeof o=="object"&&(s=o,o=void 0),o!=null&&(s.title=o),i!=null&&this.setContent(i),s["extends"]==null&&(s["extends"]=s.style!=null?s.style:t.defaultStyle),h=[s],b=s;while(b["extends"]){if(d=b["extends"],b=t.styles[d],b==null)throw Error("Invalid style: "+d);h.unshift(b),b["extends"]==null&&d!=="standard"&&(b["extends"]="standard")}for(s=(f=this.adapter).extend.apply(f,[{}].concat(__slice.call(h))),s.hideTriggers=function(){var t,e,i,o;for(i=s.hideTriggers,o=[],t=0,e=i.length;e>t;t++)r=i[t],o.push(r);return o}(),s.hideTrigger&&s.hideTriggers.length===0&&s.hideTriggers.push(s.hideTrigger),m=["tipJoint","targetJoint","stem"],l=0,c=m.length;c>l;l++)p=m[l],s[p]&&typeof s[p]=="string"&&(s[p]=new t.Joint(s[p]));for(!s.ajax||s.ajax!==!0&&s.ajax||(s.ajax=this.adapter.tagName(this.triggerElement)==="A"?this.adapter.attr(this.triggerElement,"href"):!1),s.showOn==="click"&&this.adapter.tagName(this.triggerElement)==="A"&&this.adapter.observe(this.triggerElement,"click",function(t){return t.preventDefault(),t.stopPropagation(),t.stopped=!0}),s.target&&(s.fixed=!0),s.stem===!0&&(s.stem=new t.Joint(s.tipJoint)),s.target===!0?s.target=this.triggerElement:s.target&&(s.target=this.adapter.wrap(s.target)),this.currentStem=s.stem,s.delay==null&&(s.delay=s.showOn==="mouseover"?.2:0),s.targetJoint==null&&(s.targetJoint=new t.Joint(s.tipJoint).flip()),this.showTriggers=[],this.showTriggersWhenVisible=[],this.hideTriggers=[],s.showOn&&s.showOn!=="creation"&&this.showTriggers.push({element:this.triggerElement,event:s.showOn}),s.ajaxCache!=null&&(s.cache=s.ajaxCache,delete s.ajaxCache),this.options=s,this.bound={},v=["prepareToShow","prepareToHide","show","hide","reposition"],u=0,g=v.length;g>u;u++)a=v[u],this.bound[a]=function(t){return function(){return w[t].apply(w,arguments)}}(a);this.adapter.domReady(function(){return w.activate(),w.options.showOn==="creation"?w.prepareToShow():void 0})}return t.prototype.STICKS_OUT_TOP=1,t.prototype.STICKS_OUT_BOTTOM=2,t.prototype.STICKS_OUT_LEFT=1,t.prototype.STICKS_OUT_RIGHT=2,t.prototype["class"]={container:"opentip-container",opentip:"opentip",header:"ot-header",content:"ot-content",loadingIndicator:"ot-loading-indicator",close:"ot-close",goingToHide:"ot-going-to-hide",hidden:"ot-hidden",hiding:"ot-hiding",goingToShow:"ot-going-to-show",showing:"ot-showing",visible:"ot-visible",loading:"ot-loading",ajaxError:"ot-ajax-error",fixed:"ot-fixed",showEffectPrefix:"ot-show-effect-",hideEffectPrefix:"ot-hide-effect-",stylePrefix:"style-"},t.prototype._setup=function(){var t,e,i,o,s,n,r,a,h,p,d;for(this.debug("Setting up the tooltip."),this._buildContainer(),this.hideTriggers=[],h=this.options.hideTriggers,o=s=0,r=h.length;r>s;o=++s){if(e=h[o],i=null,t=this.options.hideOn instanceof Array?this.options.hideOn[o]:this.options.hideOn,typeof e=="string")switch(e){case"trigger":t=t||"mouseout",i=this.triggerElement;break;case"tip":t=t||"mouseover",i=this.container;break;case"target":t=t||"mouseover",i=this.options.target;break;case"closeButton":break;default:throw Error("Unknown hide trigger: "+e+".")}else t=t||"mouseover",i=this.adapter.wrap(e);i&&this.hideTriggers.push({element:i,event:t,original:e})}for(p=this.hideTriggers,d=[],n=0,a=p.length;a>n;n++)e=p[n],d.push(this.showTriggersWhenVisible.push({element:e.element,event:"mouseover"}));return d},t.prototype._buildContainer=function(){return this.container=this.adapter.create('<div id="opentip-'+this.id+'" class="'+this["class"].container+" "+this["class"].hidden+" "+this["class"].stylePrefix+this.options.className+'"></div>'),this.adapter.css(this.container,{position:"absolute"}),this.options.ajax&&this.adapter.addClass(this.container,this["class"].loading),this.options.fixed&&this.adapter.addClass(this.container,this["class"].fixed),this.options.showEffect&&this.adapter.addClass(this.container,""+this["class"].showEffectPrefix+this.options.showEffect),this.options.hideEffect?this.adapter.addClass(this.container,""+this["class"].hideEffectPrefix+this.options.hideEffect):void 0},t.prototype._buildElements=function(){var t,e;return this.tooltipElement=this.adapter.create('<div class="'+this["class"].opentip+'"><div class="'+this["class"].header+'"></div><div class="'+this["class"].content+'"></div></div>'),this.backgroundCanvas=this.adapter.wrap(document.createElement("canvas")),this.adapter.css(this.backgroundCanvas,{position:"absolute"}),typeof G_vmlCanvasManager!="undefined"&&G_vmlCanvasManager!==null&&G_vmlCanvasManager.initElement(this.adapter.unwrap(this.backgroundCanvas)),t=this.adapter.find(this.tooltipElement,"."+this["class"].header),this.options.title&&(e=this.adapter.create("<h1></h1>"),this.adapter.update(e,this.options.title,this.options.escapeTitle),this.adapter.append(t,e)),this.options.ajax&&!this.loaded&&this.adapter.append(this.tooltipElement,this.adapter.create('<div class="'+this["class"].loadingIndicator+'"><span>↻</span></div>')),__indexOf.call(this.options.hideTriggers,"closeButton")>=0&&(this.closeButtonElement=this.adapter.create('<a href="javascript:undefined;" class="'+this["class"].close+'"><span>Close</span></a>'),this.adapter.append(t,this.closeButtonElement)),this.adapter.append(this.container,this.backgroundCanvas),this.adapter.append(this.container,this.tooltipElement),this.adapter.append(document.body,this.container),this._newContent=!0,this.redraw=!0},t.prototype.setContent=function(t){return this.content=t,this._newContent=!0,typeof this.content=="function"?(this._contentFunction=this.content,this.content=""):this._contentFunction=null,this.visible?this._updateElementContent():void 0},t.prototype._updateElementContent=function(){var t;return(this._newContent||!this.options.cache&&this._contentFunction)&&(t=this.adapter.find(this.container,"."+this["class"].content),t!=null&&(this._contentFunction&&(this.debug("Executing content function."),this.content=this._contentFunction(this)),this.adapter.update(t,this.content,this.options.escapeContent)),this._newContent=!1),this._storeAndLockDimensions(),this.reposition()},t.prototype._storeAndLockDimensions=function(){var t;if(this.container)return t=this.dimensions,this.adapter.css(this.container,{width:"auto",left:"0px",top:"0px"}),this.dimensions=this.adapter.dimensions(this.container),this.dimensions.width+=1,this.adapter.css(this.container,{width:""+this.dimensions.width+"px",top:""+this.currentPosition.top+"px",left:""+this.currentPosition.left+"px"}),this._dimensionsEqual(this.dimensions,t)?void 0:(this.redraw=!0,this._draw())},t.prototype.activate=function(){return this._setupObservers("hidden","hiding")},t.prototype.deactivate=function(){return this.debug("Deactivating tooltip."),this.hide(),this._setupObservers("-showing","-visible","-hidden","-hiding")},t.prototype._setupObservers=function(){var t,e,i,o,s,n,r,a,h,p,d,l,u,c,g,f,m=this;for(o=arguments.length>=1?__slice.call(arguments,0):[],n=0,p=o.length;p>n;n++)if(i=o[n],e=!1,i.charAt(0)==="-"&&(e=!0,i=i.substr(1)),this.currentObservers[i]!==!e)switch(this.currentObservers[i]=!e,t=function(){var t,i,o;return t=arguments.length>=1?__slice.call(arguments,0):[],e?(i=m.adapter).stopObserving.apply(i,t):(o=m.adapter).observe.apply(o,t)},i){case"showing":for(c=this.hideTriggers,r=0,d=c.length;d>r;r++)s=c[r],t(s.element,s.event,this.bound.prepareToHide);t(document.onresize!=null?document:window,"resize",this.bound.reposition),t(window,"scroll",this.bound.reposition);break;case"visible":for(g=this.showTriggersWhenVisible,a=0,l=g.length;l>a;a++)s=g[a],t(s.element,s.event,this.bound.prepareToShow);break;case"hiding":for(f=this.showTriggers,h=0,u=f.length;u>h;h++)s=f[h],t(s.element,s.event,this.bound.prepareToShow);break;case"hidden":break;default:throw Error("Unknown state: "+i)}return null},t.prototype.prepareToShow=function(){return this._abortHiding(),this._abortShowing(),this.visible?void 0:(this.debug("Showing in "+this.options.delay+"s."),this.container==null&&this._setup(),this.options.group&&t._abortShowingGroup(this.options.group,this),this.preparingToShow=!0,this._setupObservers("-hidden","-hiding","showing"),this._followMousePosition(),this.options.fixed&&!this.options.target&&(this.initialMousePosition=mousePosition),this.reposition(),this._showTimeoutId=this.setTimeout(this.bound.show,this.options.delay||0))},t.prototype.show=function(){var e=this;return this._abortHiding(),this.visible?void 0:(this._clearTimeouts(),this._triggerElementExists()?(this.debug("Showing now."),this.container==null&&this._setup(),this.options.group&&t._hideGroup(this.options.group,this),this.visible=!0,this.preparingToShow=!1,this.tooltipElement==null&&this._buildElements(),this._updateElementContent(),!this.options.ajax||this.loaded&&this.options.cache||this._loadAjax(),this._searchAndActivateCloseButtons(),this._startEnsureTriggerElement(),this.adapter.css(this.container,{zIndex:t.lastZIndex++}),this._setupObservers("-hidden","-hiding","-showing","-visible","showing","visible"),this.options.fixed&&!this.options.target&&(this.initialMousePosition=mousePosition),this.reposition(),this.adapter.removeClass(this.container,this["class"].hiding),this.adapter.removeClass(this.container,this["class"].hidden),this.adapter.addClass(this.container,this["class"].goingToShow),this.setCss3Style(this.container,{transitionDuration:"0s"}),this.defer(function(){var t;if(e.visible&&!e.preparingToHide)return e.adapter.removeClass(e.container,e["class"].goingToShow),e.adapter.addClass(e.container,e["class"].showing),t=0,e.options.showEffect&&e.options.showEffectDuration&&(t=e.options.showEffectDuration),e.setCss3Style(e.container,{transitionDuration:""+t+"s"}),e._visibilityStateTimeoutId=e.setTimeout(function(){return e.adapter.removeClass(e.container,e["class"].showing),e.adapter.addClass(e.container,e["class"].visible)},t),e._activateFirstInput()}),this._draw()):this.deactivate())},t.prototype._abortShowing=function(){return this.preparingToShow?(this.debug("Aborting showing."),this._clearTimeouts(),this._stopFollowingMousePosition(),this.preparingToShow=!1,this._setupObservers("-showing","-visible","hiding","hidden")):void 0},t.prototype.prepareToHide=function(){return this._abortShowing(),this._abortHiding(),this.visible?(this.debug("Hiding in "+this.options.hideDelay+"s"),this.preparingToHide=!0,this._setupObservers("-showing","visible","-hidden","hiding"),this._hideTimeoutId=this.setTimeout(this.bound.hide,this.options.hideDelay)):void 0},t.prototype.hide=function(){var t=this;return this._abortShowing(),this.visible&&(this._clearTimeouts(),this.debug("Hiding!"),this.visible=!1,this.preparingToHide=!1,this._stopEnsureTriggerElement(),this._setupObservers("-showing","-visible","-hiding","-hidden","hiding","hidden"),this.options.fixed||this._stopFollowingMousePosition(),this.container)?(this.adapter.removeClass(this.container,this["class"].visible),this.adapter.removeClass(this.container,this["class"].showing),this.adapter.addClass(this.container,this["class"].goingToHide),this.setCss3Style(this.container,{transitionDuration:"0s"}),this.defer(function(){var e;return t.adapter.removeClass(t.container,t["class"].goingToHide),t.adapter.addClass(t.container,t["class"].hiding),e=0,t.options.hideEffect&&t.options.hideEffectDuration&&(e=t.options.hideEffectDuration),t.setCss3Style(t.container,{transitionDuration:""+e+"s"}),t._visibilityStateTimeoutId=t.setTimeout(function(){return t.adapter.removeClass(t.container,t["class"].hiding),t.adapter.addClass(t.container,t["class"].hidden),t.setCss3Style(t.container,{transitionDuration:"0s"}),t.options.removeElementsOnHide?(t.debug("Removing HTML elements."),t.adapter.remove(t.container),delete t.container,delete t.tooltipElement):void 0},e)})):void 0},t.prototype._abortHiding=function(){return this.preparingToHide?(this.debug("Aborting hiding."),this._clearTimeouts(),this.preparingToHide=!1,this._setupObservers("-hiding","showing","visible")):void 0},t.prototype.reposition=function(){var t,e,i,o=this;return t=this.getPosition(),t==null||(e=this.options.stem,this.options.containInViewport&&(i=this._ensureViewportContainment(t),t=i.position,e=i.stem),this._positionsEqual(t,this.currentPosition))?void 0:(this.options.stem&&!e.eql(this.currentStem)&&(this.redraw=!0),this.currentPosition=t,this.currentStem=e,this._draw(),this.adapter.css(this.container,{left:""+t.left+"px",top:""+t.top+"px"}),this.defer(function(){var t,e;return t=o.adapter.unwrap(o.container),t.style.visibility="hidden",e=t.offsetHeight,t.style.visibility="visible"}))},t.prototype.getPosition=function(t,e,i){var o,s,n,r,a,h,p,d,l;if(this.container)return t==null&&(t=this.options.tipJoint),e==null&&(e=this.options.targetJoint),r={},this.options.target?(p=this.adapter.offset(this.options.target),h=this.adapter.dimensions(this.options.target),r=p,e.right?(d=this.adapter.unwrap(this.options.target),d.getBoundingClientRect!=null?r.left=d.getBoundingClientRect().right+((l=window.pageXOffset)!=null?l:document.body.scrollLeft):r.left+=h.width):e.center&&(r.left+=Math.round(h.width/2)),e.bottom?r.top+=h.height:e.middle&&(r.top+=Math.round(h.height/2)),this.options.borderWidth&&(this.options.tipJoint.left&&(r.left+=this.options.borderWidth),this.options.tipJoint.right&&(r.left-=this.options.borderWidth),this.options.tipJoint.top?r.top+=this.options.borderWidth:this.options.tipJoint.bottom&&(r.top-=this.options.borderWidth))):r=this.initialMousePosition?{top:this.initialMousePosition.y,left:this.initialMousePosition.x}:{top:mousePosition.y,left:mousePosition.x},this.options.autoOffset&&(a=this.options.stem?this.options.stemLength:0,n=a&&this.options.fixed?2:10,o=t.middle&&!this.options.fixed?15:0,s=t.center&&!this.options.fixed?15:0,t.right?r.left-=n+o:t.left&&(r.left+=n+o),t.bottom?r.top-=n+s:t.top&&(r.top+=n+s),a&&(i==null&&(i=this.options.stem),i.right?r.left-=a:i.left&&(r.left+=a),i.bottom?r.top-=a:i.top&&(r.top+=a))),r.left+=this.options.offset[0],r.top+=this.options.offset[1],t.right?r.left-=this.dimensions.width:t.center&&(r.left-=Math.round(this.dimensions.width/2)),t.bottom?r.top-=this.dimensions.height:t.middle&&(r.top-=Math.round(this.dimensions.height/2)),r},t.prototype._ensureViewportContainment=function(e){var i,o,s,n,r,a,h,p,d,l,u,c;if(h=this.options.stem,s={position:e,stem:h},!this.visible||!e)return s;if(p=this._sticksOut(e),!p[0]&&!p[1])return s;if(l=new t.Joint(this.options.tipJoint),this.options.targetJoint&&(d=new t.Joint(this.options.targetJoint)),a=this.adapter.scrollOffset(),u=this.adapter.viewportDimensions(),c=[e.left-a[0],e.top-a[1]],i=!1,u.width>=this.dimensions.width&&p[0])switch(i=!0,p[0]){case this.STICKS_OUT_LEFT:l.setHorizontal("left"),this.options.targetJoint&&d.setHorizontal("right");break;case this.STICKS_OUT_RIGHT:l.setHorizontal("right"),this.options.targetJoint&&d.setHorizontal("left")}if(u.height>=this.dimensions.height&&p[1])switch(i=!0,p[1]){case this.STICKS_OUT_TOP:l.setVertical("top"),this.options.targetJoint&&d.setVertical("bottom");break;case this.STICKS_OUT_BOTTOM:l.setVertical("bottom"),this.options.targetJoint&&d.setVertical("top")}return i?(this.options.stem&&(h=l),e=this.getPosition(l,d,h),o=this._sticksOut(e),n=!1,r=!1,o[0]&&o[0]!==p[0]&&(n=!0,l.setHorizontal(this.options.tipJoint.horizontal),this.options.targetJoint&&d.setHorizontal(this.options.targetJoint.horizontal)),o[1]&&o[1]!==p[1]&&(r=!0,l.setVertical(this.options.tipJoint.vertical),this.options.targetJoint&&d.setVertical(this.options.targetJoint.vertical)),n&&r?s:((n||r)&&(this.options.stem&&(h=l),e=this.getPosition(l,d,h)),{position:e,stem:h})):s},t.prototype._sticksOut=function(t){var e,i,o,s;return i=this.adapter.scrollOffset(),s=this.adapter.viewportDimensions(),e=[t.left-i[0],t.top-i[1]],o=[!1,!1],0>e[0]?o[0]=this.STICKS_OUT_LEFT:e[0]+this.dimensions.width>s.width&&(o[0]=this.STICKS_OUT_RIGHT),0>e[1]?o[1]=this.STICKS_OUT_TOP:e[1]+this.dimensions.height>s.height&&(o[1]=this.STICKS_OUT_BOTTOM),o},t.prototype._draw=function(){var e,i,o,s,n,r,a,h,p,d,l,u,c,g,f,m,v,b,w,_=this;if(this.backgroundCanvas&&this.redraw){if(this.debug("Drawing background."),this.redraw=!1,this.currentStem){for(v=["top","right","bottom","left"],f=0,m=v.length;m>f;f++)u=v[f],this.adapter.removeClass(this.container,"stem-"+u);this.adapter.addClass(this.container,"stem-"+this.currentStem.horizontal),this.adapter.addClass(this.container,"stem-"+this.currentStem.vertical)}return r=[0,0],a=[0,0],__indexOf.call(this.options.hideTriggers,"closeButton")>=0&&(n=new t.Joint(((b=this.currentStem)!=null?b+"":void 0)==="top right"?"top left":"top right"),r=[this.options.closeButtonRadius+this.options.closeButtonOffset[0],this.options.closeButtonRadius+this.options.closeButtonOffset[1]],a=[this.options.closeButtonRadius-this.options.closeButtonOffset[0],this.options.closeButtonRadius-this.options.closeButtonOffset[1]]),o=this.adapter.clone(this.dimensions),s=[0,0],this.options.borderWidth&&(o.width+=this.options.borderWidth*2,o.height+=this.options.borderWidth*2,s[0]-=this.options.borderWidth,s[1]-=this.options.borderWidth),this.options.shadow&&(o.width+=this.options.shadowBlur*2,o.width+=Math.max(0,this.options.shadowOffset[0]-this.options.shadowBlur*2),o.height+=this.options.shadowBlur*2,o.height+=Math.max(0,this.options.shadowOffset[1]-this.options.shadowBlur*2),s[0]-=Math.max(0,this.options.shadowBlur-this.options.shadowOffset[0]),s[1]-=Math.max(0,this.options.shadowBlur-this.options.shadowOffset[1])),i={left:0,right:0,top:0,bottom:0},this.currentStem&&(this.currentStem.left?i.left=this.options.stemLength:this.currentStem.right&&(i.right=this.options.stemLength),this.currentStem.top?i.top=this.options.stemLength:this.currentStem.bottom&&(i.bottom=this.options.stemLength)),n&&(n.left?i.left=Math.max(i.left,a[0]):n.right&&(i.right=Math.max(i.right,a[0])),n.top?i.top=Math.max(i.top,a[1]):n.bottom&&(i.bottom=Math.max(i.bottom,a[1]))),o.width+=i.left+i.right,o.height+=i.top+i.bottom,s[0]-=i.left,s[1]-=i.top,this.currentStem&&this.options.borderWidth&&(w=this._getPathStemMeasures(this.options.stemBase,this.options.stemLength,this.options.borderWidth),g=w.stemLength,c=w.stemBase),e=this.adapter.unwrap(this.backgroundCanvas),e.width=o.width,e.height=o.height,this.adapter.css(this.backgroundCanvas,{width:""+e.width+"px",height:""+e.height+"px",left:""+s[0]+"px",top:""+s[1]+"px"}),h=e.getContext("2d"),h.setTransform(1,0,0,1,0,0),h.clearRect(0,0,e.width,e.height),h.beginPath(),h.fillStyle=this._getColor(h,this.dimensions,this.options.background,this.options.backgroundGradientHorizontal),h.lineJoin="miter",h.miterLimit=500,l=this.options.borderWidth/2,this.options.borderWidth?(h.strokeStyle=this.options.borderColor,h.lineWidth=this.options.borderWidth):(g=this.options.stemLength,c=this.options.stemBase),c==null&&(c=0),d=function(t,e,i){return i&&h.moveTo(Math.max(c,_.options.borderRadius,r[0])+1-l,-l),e?(h.lineTo(t/2-c/2,-l),h.lineTo(t/2,-g-l),h.lineTo(t/2+c/2,-l)):void 0},p=function(t,e,i){var o,s,n,a;return t?(h.lineTo(-c+l,0-l),h.lineTo(g+l,-g-l),h.lineTo(l,c-l)):e?(a=_.options.closeButtonOffset,n=r[0],i%2!==0&&(a=[a[1],a[0]],n=r[1]),o=Math.acos(a[1]/_.options.closeButtonRadius),s=Math.acos(a[0]/_.options.closeButtonRadius),h.lineTo(-n+l,-l),h.arc(l-a[0],-l+a[1],_.options.closeButtonRadius,-(Math.PI/2+o),s,!1)):(h.lineTo(-_.options.borderRadius+l,-l),h.quadraticCurveTo(l,-l,l,_.options.borderRadius-l))},h.translate(-s[0],-s[1]),h.save(),function(){var e,i,o,s,r,a,l,u,c,g,f;for(f=[],i=c=0,g=t.positions.length/2;g>=0?g>c:c>g;i=g>=0?++c:--c)r=i*2,a=i===0||i===3?0:_.dimensions.width,l=2>i?0:_.dimensions.height,u=Math.PI/2*i,o=i%2===0?_.dimensions.width:_.dimensions.height,s=new t.Joint(t.positions[r]),e=new t.Joint(t.positions[r+1]),h.save(),h.translate(a,l),h.rotate(u),d(o,s.eql(_.currentStem),i===0),h.translate(o,0),p(e.eql(_.currentStem),e.eql(n),i),f.push(h.restore());return f}(),h.closePath(),h.save(),this.options.shadow&&(h.shadowColor=this.options.shadowColor,h.shadowBlur=this.options.shadowBlur,h.shadowOffsetX=this.options.shadowOffset[0],h.shadowOffsetY=this.options.shadowOffset[1]),h.fill(),h.restore(),this.options.borderWidth&&h.stroke(),h.restore(),n?function(){var t,e,i,o,s;return i=e=_.options.closeButtonRadius*2,n+""=="top right"?(s=[_.dimensions.width-_.options.closeButtonOffset[0],_.options.closeButtonOffset[1]],t=[s[0]+l,s[1]-l]):(s=[_.options.closeButtonOffset[0],_.options.closeButtonOffset[1]],t=[s[0]-l,s[1]-l]),h.translate(t[0],t[1]),o=_.options.closeButtonCrossSize/2,h.save(),h.beginPath(),h.strokeStyle=_.options.closeButtonCrossColor,h.lineWidth=_.options.closeButtonCrossLineWidth,h.lineCap="round",h.moveTo(-o,-o),h.lineTo(o,o),h.stroke(),h.beginPath(),h.moveTo(o,-o),h.lineTo(-o,o),h.stroke(),h.restore(),_.adapter.css(_.closeButtonElement,{left:""+(s[0]-o-_.options.closeButtonLinkOverscan)+"px",top:""+(s[1]-o-_.options.closeButtonLinkOverscan)+"px",width:""+(_.options.closeButtonCrossSize+_.options.closeButtonLinkOverscan*2)+"px",height:""+(_.options.closeButtonCrossSize+_.options.closeButtonLinkOverscan*2)+"px"})}():void 0}},t.prototype._getPathStemMeasures=function(t,e,i){var o,s,n,r,a,h,p;if(r=i/2,n=Math.atan(t/2/e),o=n*2,a=r/Math.sin(o),s=2*a*Math.cos(n),p=r+e-s,0>p)throw Error("Sorry but your stemLength / stemBase ratio is strange.");return h=Math.tan(n)*p*2,{stemLength:p,stemBase:h}},t.prototype._getColor=function(t,e,i,o){var s,n,r,a,h;if(o==null&&(o=!1),typeof i=="string")return i;for(n=o?t.createLinearGradient(0,0,e.width,0):t.createLinearGradient(0,0,0,e.height),r=a=0,h=i.length;h>a;r=++a)s=i[r],n.addColorStop(s[0],s[1]);return n},t.prototype._searchAndActivateCloseButtons=function(){var t,e,i,o;for(o=this.adapter.findAll(this.container,"."+this["class"].close),e=0,i=o.length;i>e;e++)t=o[e],this.hideTriggers.push({element:this.adapter.wrap(t),event:"click"});return this.currentObservers.showing&&this._setupObservers("-showing","showing"),this.currentObservers.visible?this._setupObservers("-visible","visible"):void 0},t.prototype._activateFirstInput=function(){var t;return t=this.adapter.unwrap(this.adapter.find(this.container,"input, textarea")),t!=null?typeof t.focus=="function"?t.focus():void 0:void 0},t.prototype._followMousePosition=function(){return this.options.fixed?void 0:t._observeMousePosition(this.bound.reposition)},t.prototype._stopFollowingMousePosition=function(){return this.options.fixed?void 0:t._stopObservingMousePosition(this.bound.reposition)},t.prototype._clearShowTimeout=function(){return clearTimeout(this._showTimeoutId)},t.prototype._clearHideTimeout=function(){return clearTimeout(this._hideTimeoutId)},t.prototype._clearTimeouts=function(){return clearTimeout(this._visibilityStateTimeoutId),this._clearShowTimeout(),this._clearHideTimeout()},t.prototype._triggerElementExists=function(){var t;t=this.adapter.unwrap(this.triggerElement);while(t.parentNode){if(t.parentNode.tagName==="BODY")return!0;t=t.parentNode}return!1},t.prototype._loadAjax=function(){var t=this;if(!this.loading)return this.loaded=!1,this.loading=!0,this.adapter.addClass(this.container,this["class"].loading),this.setContent(""),this.debug("Loading content from "+this.options.ajax),this.adapter.ajax({url:this.options.ajax,method:this.options.ajaxMethod,onSuccess:function(e){return t.debug("Loading successful."),t.adapter.removeClass(t.container,t["class"].loading),t.setContent(e)},onError:function(e){var i;return i=t.options.ajaxErrorMessage,t.debug(i,e),t.setContent(i),t.adapter.addClass(t.container,t["class"].ajaxError)},onComplete:function(){return t.adapter.removeClass(t.container,t["class"].loading),t.loading=!1,t.loaded=!0,t._searchAndActivateCloseButtons(),t._activateFirstInput(),t.reposition()}})},t.prototype._ensureTriggerElement=function(){return this._triggerElementExists()?void 0:(this.deactivate(),this._stopEnsureTriggerElement())},t.prototype._ensureTriggerElementInterval=1e3,t.prototype._startEnsureTriggerElement=function(){var t=this;return this._ensureTriggerElementTimeoutId=setInterval(function(){return t._ensureTriggerElement()},this._ensureTriggerElementInterval)},t.prototype._stopEnsureTriggerElement=function(){return clearInterval(this._ensureTriggerElementTimeoutId)},t}(),vendors=["khtml","ms","o","moz","webkit"],Opentip.prototype.setCss3Style=function(t,e){var i,o,s,n,r;t=this.adapter.unwrap(t),r=[];for(i in e)__hasProp.call(e,i)&&(o=e[i],t.style[i]!=null?r.push(t.style[i]=o):r.push(function(){var e,r,a;for(a=[],e=0,r=vendors.length;r>e;e++)s=vendors[e],n=""+this.ucfirst(s)+this.ucfirst(i),t.style[n]!=null?a.push(t.style[n]=o):a.push(void 0);return a}.call(this)));return r},Opentip.prototype.defer=function(t){return setTimeout(t,0)},Opentip.prototype.setTimeout=function(t,e){return setTimeout(t,e?e*1e3:0)},Opentip.prototype.ucfirst=function(t){return t==null?"":t.charAt(0).toUpperCase()+t.slice(1)},Opentip.prototype.dasherize=function(t){return t.replace(/([A-Z])/g,function(t,e){return"-"+e.toLowerCase()})},mousePositionObservers=[],mousePosition={x:0,y:0},mouseMoved=function(t){var e,i,o,s;for(mousePosition=Opentip.adapter.mousePosition(t),s=[],i=0,o=mousePositionObservers.length;o>i;i++)e=mousePositionObservers[i],s.push(e());return s},Opentip.followMousePosition=function(){return Opentip.adapter.observe(document.body,"mousemove",mouseMoved)},Opentip._observeMousePosition=function(t){return mousePositionObservers.push(t)},Opentip._stopObservingMousePosition=function(t){var e;return mousePositionObservers=function(){var i,o,s;for(s=[],i=0,o=mousePositionObservers.length;o>i;i++)e=mousePositionObservers[i],e!==t&&s.push(e);return s}()},Opentip.Joint=function(){function t(t){t!=null&&(t instanceof Opentip.Joint&&(t+=""),this.set(t))}return t.prototype.set=function(t){return t=t.toLowerCase(),this.setHorizontal(t),this.setVertical(t),this},t.prototype.setHorizontal=function(t){var e,i,o,s,n,r,a;for(i=["left","center","right"],o=0,n=i.length;n>o;o++)e=i[o],~t.indexOf(e)&&(this.horizontal=e.toLowerCase());for(this.horizontal==null&&(this.horizontal="center"),a=[],s=0,r=i.length;r>s;s++)e=i[s],a.push(this[e]=this.horizontal===e?e:void 0);return a},t.prototype.setVertical=function(t){var e,i,o,s,n,r,a;for(i=["top","middle","bottom"],o=0,n=i.length;n>o;o++)e=i[o],~t.indexOf(e)&&(this.vertical=e.toLowerCase());for(this.vertical==null&&(this.vertical="middle"),a=[],s=0,r=i.length;r>s;s++)e=i[s],a.push(this[e]=this.vertical===e?e:void 0);return a},t.prototype.eql=function(t){return t!=null&&this.horizontal===t.horizontal&&this.vertical===t.vertical},t.prototype.flip=function(){var t,e;return e=Opentip.position[this.toString(!0)],t=(e+4)%8,this.set(Opentip.positions[t]),this},t.prototype.toString=function(t){var e,i;return t==null&&(t=!1),i=this.vertical==="middle"?"":this.vertical,e=this.horizontal==="center"?"":this.horizontal,i&&e&&(e=t?Opentip.prototype.ucfirst(e):" "+e),""+i+e},t}(),Opentip.prototype._positionsEqual=function(t,e){return t!=null&&e!=null&&t.left===e.left&&t.top===e.top},Opentip.prototype._dimensionsEqual=function(t,e){return t!=null&&e!=null&&t.width===e.width&&t.height===e.height},Opentip.prototype.debug=function(){var t;return t=arguments.length>=1?__slice.call(arguments,0):[],Opentip.debug&&(typeof console!="undefined"&&console!==null?console.debug:void 0)!=null?(t.unshift("#"+this.id+" |"),console.debug.apply(console,t)):void 0},Opentip.findElements=function(){var t,e,i,o,s,n,r,a,h,p;for(t=Opentip.adapter,h=t.findAll(document.body,"[data-ot]"),p=[],r=0,a=h.length;a>r;r++){i=h[r],n={},e=t.data(i,"ot"),(e===""||e==="true"||e==="yes")&&(e=t.attr(i,"title"),t.attr(i,"title","")),e=e||"";for(o in Opentip.styles.standard)s=t.data(i,"ot"+Opentip.prototype.ucfirst(o)),s!=null&&(s==="yes"||s==="true"||s==="on"?s=!0:(s==="no"||s==="false"||s==="off")&&(s=!1),n[o]=s);p.push(new Opentip(i,e,n))}return p},Opentip.version="2.4.6",Opentip.debug=!1,Opentip.lastId=0,Opentip.lastZIndex=100,Opentip.tips=[],Opentip._abortShowingGroup=function(t,e){var i,o,s,n,r;for(n=Opentip.tips,r=[],o=0,s=n.length;s>o;o++)i=n[o],i!==e&&i.options.group===t?r.push(i._abortShowing()):r.push(void 0);return r},Opentip._hideGroup=function(t,e){var i,o,s,n,r;for(n=Opentip.tips,r=[],o=0,s=n.length;s>o;o++)i=n[o],i!==e&&i.options.group===t?r.push(i.hide()):r.push(void 0);return r},Opentip.adapters={},Opentip.adapter=null,firstAdapter=!0,Opentip.addAdapter=function(t){return Opentip.adapters[t.name]=t,firstAdapter?(Opentip.adapter=t,t.domReady(Opentip.findElements),t.domReady(Opentip.followMousePosition),firstAdapter=!1):void 0},Opentip.positions=["top","topRight","right","bottomRight","bottom","bottomLeft","left","topLeft"],Opentip.position={},_ref=Opentip.positions,i=_i=0,_len=_ref.length;_len>_i;i=++_i)position=_ref[i],Opentip.position[position]=i;Opentip.styles={standard:{"extends":null,title:void 0,escapeTitle:!0,escapeContent:!1,className:"standard",stem:!0,delay:null,hideDelay:.1,fixed:!1,showOn:"mouseover",hideTrigger:"trigger",hideTriggers:[],hideOn:null,removeElementsOnHide:!1,offset:[0,0],containInViewport:!0,autoOffset:!0,showEffect:"appear",hideEffect:"fade",showEffectDuration:.3,hideEffectDuration:.2,stemLength:5,stemBase:8,tipJoint:"top left",target:null,targetJoint:null,cache:!0,ajax:!1,ajaxMethod:"GET",ajaxErrorMessage:"There was a problem downloading the content.",group:null,style:null,background:"#fff18f",backgroundGradientHorizontal:!1,closeButtonOffset:[5,5],closeButtonRadius:7,closeButtonCrossSize:4,closeButtonCrossColor:"#d2c35b",closeButtonCrossLineWidth:1.5,closeButtonLinkOverscan:6,borderRadius:5,borderWidth:1,borderColor:"#f2e37b",shadow:!0,shadowBlur:10,shadowOffset:[3,3],shadowColor:"rgba(0, 0, 0, 0.1)"},glass:{"extends":"standard",className:"glass",background:[[0,"rgba(252, 252, 252, 0.8)"],[.5,"rgba(255, 255, 255, 0.8)"],[.5,"rgba(250, 250, 250, 0.9)"],[1,"rgba(245, 245, 245, 0.9)"]],borderColor:"#eee",closeButtonCrossColor:"rgba(0, 0, 0, 0.2)",borderRadius:15,closeButtonRadius:10,closeButtonOffset:[8,8]},dark:{"extends":"standard",className:"dark",borderRadius:13,borderColor:"#444",closeButtonCrossColor:"rgba(240, 240, 240, 1)",shadowColor:"rgba(0, 0, 0, 0.3)",shadowOffset:[2,2],background:[[0,"rgba(30, 30, 30, 0.7)"],[.5,"rgba(30, 30, 30, 0.8)"],[.5,"rgba(10, 10, 10, 0.8)"],[1,"rgba(10, 10, 10, 0.9)"]]},alert:{"extends":"standard",className:"alert",borderRadius:1,borderColor:"#AE0D11",closeButtonCrossColor:"rgba(255, 255, 255, 1)",shadowColor:"rgba(0, 0, 0, 0.3)",shadowOffset:[2,2],background:[[0,"rgba(203, 15, 19, 0.7)"],[.5,"rgba(203, 15, 19, 0.8)"],[.5,"rgba(189, 14, 18, 0.8)"],[1,"rgba(179, 14, 17, 0.9)"]]}},Opentip.defaultStyle="standard",typeof module!="undefined"&&module!==null?module.exports=Opentip:window.Opentip=Opentip;var __slice=[].slice;(function(t){var e;return t.fn.opentip=function(t,e,i){return new Opentip(this,t,e,i)},e=function(){function e(){}return e.prototype.name="jquery",e.prototype.domReady=function(e){return t(e)},e.prototype.create=function(e){return t(e)},e.prototype.wrap=function(e){if(e=t(e),e.length>1)throw Error("Multiple elements provided.");return e},e.prototype.unwrap=function(e){return t(e)[0]
++},e.prototype.tagName=function(t){return this.unwrap(t).tagName},e.prototype.attr=function(){var e,i,o;return i=arguments[0],e=arguments.length>=2?__slice.call(arguments,1):[],(o=t(i)).attr.apply(o,e)},e.prototype.data=function(){var e,i,o;return i=arguments[0],e=arguments.length>=2?__slice.call(arguments,1):[],(o=t(i)).data.apply(o,e)},e.prototype.find=function(e,i){return t(e).find(i).get(0)},e.prototype.findAll=function(e,i){return t(e).find(i)},e.prototype.update=function(e,i,o){return e=t(e),o?e.text(i):e.html(i)},e.prototype.append=function(e,i){return t(e).append(i)},e.prototype.remove=function(e){return t(e).remove()},e.prototype.addClass=function(e,i){return t(e).addClass(i)},e.prototype.removeClass=function(e,i){return t(e).removeClass(i)},e.prototype.css=function(e,i){return t(e).css(i)},e.prototype.dimensions=function(e){return{width:t(e).outerWidth(),height:t(e).outerHeight()}},e.prototype.scrollOffset=function(){return[window.pageXOffset||document.documentElement.scrollLeft||document.body.scrollLeft,window.pageYOffset||document.documentElement.scrollTop||document.body.scrollTop]},e.prototype.viewportDimensions=function(){return{width:document.documentElement.clientWidth,height:document.documentElement.clientHeight}},e.prototype.mousePosition=function(t){return t==null?null:{x:t.pageX,y:t.pageY}},e.prototype.offset=function(e){var i;return i=t(e).offset(),{left:i.left,top:i.top}},e.prototype.observe=function(e,i,o){return t(e).bind(i,o)},e.prototype.stopObserving=function(e,i,o){return t(e).unbind(i,o)},e.prototype.ajax=function(e){var i,o;if(e.url==null)throw Error("No url provided");return t.ajax({url:e.url,type:(i=(o=e.method)!=null?o.toUpperCase():void 0)!=null?i:"GET"}).done(function(t){return typeof e.onSuccess=="function"?e.onSuccess(t):void 0}).fail(function(t){return typeof e.onError=="function"?e.onError("Server responded with status "+t.status):void 0}).always(function(){return typeof e.onComplete=="function"?e.onComplete():void 0})},e.prototype.clone=function(e){return t.extend({},e)},e.prototype.extend=function(){var e,i;return i=arguments[0],e=arguments.length>=2?__slice.call(arguments,1):[],t.extend.apply(t,[i].concat(__slice.call(e)))},e}(),Opentip.addAdapter(new e)})(jQuery)});
+\ No newline at end of file
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/styles/BBOOTS/theme/opentip.css" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/styles/BBOOTS/theme/opentip.css"
+new file mode 100644
+index 000000000..5088f37a0
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/styles/BBOOTS/theme/opentip.css"
+@@ -0,0 +1,278 @@
++.opentip-container,
++.opentip-container * {
++  -webkit-box-sizing: border-box;
++  -moz-box-sizing: border-box;
++  box-sizing: border-box;
++}
++.opentip-container {
++  position: absolute;
++  max-width: 300px;
++  z-index: 100;
++  -webkit-transition: -webkit-transform 1s ease-in-out;
++  -moz-transition: -moz-transform 1s ease-in-out;
++  -o-transition: -o-transform 1s ease-in-out;
++  -ms-transition: -ms-transform 1s ease-in-out;
++  transition: transform 1s ease-in-out;
++  pointer-events: none;
++  -webkit-transform: translateX(0) translateY(0);
++  -moz-transform: translateX(0) translateY(0);
++  -o-transform: translateX(0) translateY(0);
++  -ms-transform: translateX(0) translateY(0);
++  transform: translateX(0) translateY(0);
++}
++.opentip-container.ot-fixed.ot-hidden.stem-top.stem-center,
++.opentip-container.ot-fixed.ot-going-to-show.stem-top.stem-center,
++.opentip-container.ot-fixed.ot-hiding.stem-top.stem-center {
++  -webkit-transform: translateY(-5px);
++  -moz-transform: translateY(-5px);
++  -o-transform: translateY(-5px);
++  -ms-transform: translateY(-5px);
++  transform: translateY(-5px);
++}
++.opentip-container.ot-fixed.ot-hidden.stem-top.stem-right,
++.opentip-container.ot-fixed.ot-going-to-show.stem-top.stem-right,
++.opentip-container.ot-fixed.ot-hiding.stem-top.stem-right {
++  -webkit-transform: translateY(-5px) translateX(5px);
++  -moz-transform: translateY(-5px) translateX(5px);
++  -o-transform: translateY(-5px) translateX(5px);
++  -ms-transform: translateY(-5px) translateX(5px);
++  transform: translateY(-5px) translateX(5px);
++}
++.opentip-container.ot-fixed.ot-hidden.stem-middle.stem-right,
++.opentip-container.ot-fixed.ot-going-to-show.stem-middle.stem-right,
++.opentip-container.ot-fixed.ot-hiding.stem-middle.stem-right {
++  -webkit-transform: translateX(5px);
++  -moz-transform: translateX(5px);
++  -o-transform: translateX(5px);
++  -ms-transform: translateX(5px);
++  transform: translateX(5px);
++}
++.opentip-container.ot-fixed.ot-hidden.stem-bottom.stem-right,
++.opentip-container.ot-fixed.ot-going-to-show.stem-bottom.stem-right,
++.opentip-container.ot-fixed.ot-hiding.stem-bottom.stem-right {
++  -webkit-transform: translateY(5px) translateX(5px);
++  -moz-transform: translateY(5px) translateX(5px);
++  -o-transform: translateY(5px) translateX(5px);
++  -ms-transform: translateY(5px) translateX(5px);
++  transform: translateY(5px) translateX(5px);
++}
++.opentip-container.ot-fixed.ot-hidden.stem-bottom.stem-center,
++.opentip-container.ot-fixed.ot-going-to-show.stem-bottom.stem-center,
++.opentip-container.ot-fixed.ot-hiding.stem-bottom.stem-center {
++  -webkit-transform: translateY(5px);
++  -moz-transform: translateY(5px);
++  -o-transform: translateY(5px);
++  -ms-transform: translateY(5px);
++  transform: translateY(5px);
++}
++.opentip-container.ot-fixed.ot-hidden.stem-bottom.stem-left,
++.opentip-container.ot-fixed.ot-going-to-show.stem-bottom.stem-left,
++.opentip-container.ot-fixed.ot-hiding.stem-bottom.stem-left {
++  -webkit-transform: translateY(5px) translateX(-5px);
++  -moz-transform: translateY(5px) translateX(-5px);
++  -o-transform: translateY(5px) translateX(-5px);
++  -ms-transform: translateY(5px) translateX(-5px);
++  transform: translateY(5px) translateX(-5px);
++}
++.opentip-container.ot-fixed.ot-hidden.stem-middle.stem-left,
++.opentip-container.ot-fixed.ot-going-to-show.stem-middle.stem-left,
++.opentip-container.ot-fixed.ot-hiding.stem-middle.stem-left {
++  -webkit-transform: translateX(-5px);
++  -moz-transform: translateX(-5px);
++  -o-transform: translateX(-5px);
++  -ms-transform: translateX(-5px);
++  transform: translateX(-5px);
++}
++.opentip-container.ot-fixed.ot-hidden.stem-top.stem-left,
++.opentip-container.ot-fixed.ot-going-to-show.stem-top.stem-left,
++.opentip-container.ot-fixed.ot-hiding.stem-top.stem-left {
++  -webkit-transform: translateY(-5px) translateX(-5px);
++  -moz-transform: translateY(-5px) translateX(-5px);
++  -o-transform: translateY(-5px) translateX(-5px);
++  -ms-transform: translateY(-5px) translateX(-5px);
++  transform: translateY(-5px) translateX(-5px);
++}
++.opentip-container.ot-fixed .opentip {
++  pointer-events: auto;
++}
++.opentip-container.ot-hidden {
++  display: none;
++}
++.opentip-container .opentip {
++  position: relative;
++  font-size: 13px;
++  line-height: 120%;
++  padding: 9px 14px;
++  color: #4f4b47;
++  text-shadow: -1px -1px 0px rgba(255,255,255,0.2);
++}
++.opentip-container .opentip .header {
++  margin: 0;
++  padding: 0;
++}
++.opentip-container .opentip .ot-close {
++  pointer-events: auto;
++  display: block;
++  position: absolute;
++  top: -12px;
++  left: 60px;
++  color: rgba(0,0,0,0.5);
++  background: rgba(0,0,0,0);
++  text-decoration: none;
++}
++.opentip-container .opentip .ot-close span {
++  display: none;
++}
++.opentip-container .opentip .ot-loading-indicator {
++  display: none;
++}
++.opentip-container.ot-loading .ot-loading-indicator {
++  width: 30px;
++  height: 30px;
++  font-size: 30px;
++  line-height: 30px;
++  font-weight: bold;
++  display: block;
++}
++.opentip-container.ot-loading .ot-loading-indicator span {
++  display: block;
++  -webkit-animation: otloading 2s linear infinite;
++  -moz-animation: otloading 2s linear infinite;
++  -o-animation: otloading 2s linear infinite;
++  -ms-animation: otloading 2s linear infinite;
++  animation: otloading 2s linear infinite;
++  text-align: center;
++}
++.opentip-container.style-dark .opentip,
++.opentip-container.style-alert .opentip {
++  color: #f8f8f8;
++  text-shadow: 1px 1px 0px rgba(0,0,0,0.2);
++}
++.opentip-container.style-glass .opentip {
++  padding: 15px 25px;
++  color: #317cc5;
++  text-shadow: 1px 1px 8px rgba(0,94,153,0.3);
++}
++.opentip-container.ot-hide-effect-fade {
++  -webkit-transition: -webkit-transform 0.5s ease-in-out, opacity 1s ease-in-out;
++  -moz-transition: -moz-transform 0.5s ease-in-out, opacity 1s ease-in-out;
++  -o-transition: -o-transform 0.5s ease-in-out, opacity 1s ease-in-out;
++  -ms-transition: -ms-transform 0.5s ease-in-out, opacity 1s ease-in-out;
++  transition: transform 0.5s ease-in-out, opacity 1s ease-in-out;
++  opacity: 1;
++  -ms-filter: none;
++  filter: none;
++}
++.opentip-container.ot-hide-effect-fade.ot-hiding {
++  opacity: 0;
++  filter: alpha(opacity=0);
++  -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";
++}
++.opentip-container.ot-show-effect-appear.ot-going-to-show,
++.opentip-container.ot-show-effect-appear.ot-showing {
++  -webkit-transition: -webkit-transform 0.5s ease-in-out, opacity 1s ease-in-out;
++  -moz-transition: -moz-transform 0.5s ease-in-out, opacity 1s ease-in-out;
++  -o-transition: -o-transform 0.5s ease-in-out, opacity 1s ease-in-out;
++  -ms-transition: -ms-transform 0.5s ease-in-out, opacity 1s ease-in-out;
++  transition: transform 0.5s ease-in-out, opacity 1s ease-in-out;
++}
++.opentip-container.ot-show-effect-appear.ot-going-to-show {
++  opacity: 0;
++  filter: alpha(opacity=0);
++  -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";
++}
++.opentip-container.ot-show-effect-appear.ot-showing {
++  opacity: 1;
++  -ms-filter: none;
++  filter: none;
++}
++.opentip-container.ot-show-effect-appear.ot-visible {
++  opacity: 1;
++  -ms-filter: none;
++  filter: none;
++}
++@-moz-keyframes otloading {
++  0% {
++    -webkit-transform: rotate(0deg);
++    -moz-transform: rotate(0deg);
++    -o-transform: rotate(0deg);
++    -ms-transform: rotate(0deg);
++    transform: rotate(0deg);
++  }
++
++  100% {
++    -webkit-transform: rotate(360deg);
++    -moz-transform: rotate(360deg);
++    -o-transform: rotate(360deg);
++    -ms-transform: rotate(360deg);
++    transform: rotate(360deg);
++  }
++}
++@-webkit-keyframes otloading {
++  0% {
++    -webkit-transform: rotate(0deg);
++    -moz-transform: rotate(0deg);
++    -o-transform: rotate(0deg);
++    -ms-transform: rotate(0deg);
++    transform: rotate(0deg);
++  }
++
++  100% {
++    -webkit-transform: rotate(360deg);
++    -moz-transform: rotate(360deg);
++    -o-transform: rotate(360deg);
++    -ms-transform: rotate(360deg);
++    transform: rotate(360deg);
++  }
++}
++@-o-keyframes otloading {
++  0% {
++    -webkit-transform: rotate(0deg);
++    -moz-transform: rotate(0deg);
++    -o-transform: rotate(0deg);
++    -ms-transform: rotate(0deg);
++    transform: rotate(0deg);
++  }
++
++  100% {
++    -webkit-transform: rotate(360deg);
++    -moz-transform: rotate(360deg);
++    -o-transform: rotate(360deg);
++    -ms-transform: rotate(360deg);
++    transform: rotate(360deg);
++  }
++}
++@-ms-keyframes otloading {
++  0% {
++    -webkit-transform: rotate(0deg);
++    -moz-transform: rotate(0deg);
++    -o-transform: rotate(0deg);
++    -ms-transform: rotate(0deg);
++    transform: rotate(0deg);
++  }
++
++  100% {
++    -webkit-transform: rotate(360deg);
++    -moz-transform: rotate(360deg);
++    -o-transform: rotate(360deg);
++    -ms-transform: rotate(360deg);
++    transform: rotate(360deg);
++  }
++}
++@keyframes otloading {
++  0% {
++    -webkit-transform: rotate(0deg);
++    -moz-transform: rotate(0deg);
++    -o-transform: rotate(0deg);
++    -ms-transform: rotate(0deg);
++    transform: rotate(0deg);
++  }
++
++  100% {
++    -webkit-transform: rotate(360deg);
++    -moz-transform: rotate(360deg);
++    -o-transform: rotate(360deg);
++    -ms-transform: rotate(360deg);
++    transform: rotate(360deg);
++  }
++}
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/styles/FLATBOOTS/template/event/overall_footer_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/styles/FLATBOOTS/template/event/overall_footer_after.html"
+new file mode 100644
+index 000000000..af2f53c91
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/styles/FLATBOOTS/template/event/overall_footer_after.html"
+@@ -0,0 +1,14 @@
++{% if S_TOPIC_IMAGE_PREVIEW %}
++	{% if not definition.INCLUDED_OPENTIPJS %}
++		{% INCLUDEJS '@vse_topicimagepreview/js/opentip-jquery.min.js' %}
++		{% DEFINE INCLUDED_OPENTIPJS = true %}
++	{% endif %}
++
++	<script>
++		head.ready(function () {
++			$(function() {
++				$("[data-ot]").closest("dt").removeAttr("title");
++			});
++		});
++	</script>
++{% endif %}
+\ No newline at end of file
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/styles/FLATBOOTS/template/event/overall_header_stylesheets_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/styles/FLATBOOTS/template/event/overall_header_stylesheets_after.html"
+new file mode 100644
+index 000000000..082e4a3aa
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/styles/FLATBOOTS/template/event/overall_header_stylesheets_after.html"
+@@ -0,0 +1,14 @@
++{% if S_TOPIC_IMAGE_PREVIEW %}
++	{% INCLUDECSS '@vse_topicimagepreview/opentip.css' %}
++	<style>
++		.opentip-container {
++			max-width: 1000px;
++			white-space: nowrap;
++		}
++		.ot-content > img {
++			max-width: {{ TOPIC_IMAGE_PREVIEW_DIM_MAX }}px;
++			max-height: {{ TOPIC_IMAGE_PREVIEW_DIM_MAX }}px;
++			vertical-align: top;
++		}
++	</style>
++{% endif %}
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/styles/FLATBOOTS/template/event/topiclist_row_prepend.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/styles/FLATBOOTS/template/event/topiclist_row_prepend.html"
+new file mode 100644
+index 000000000..318af77c2
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/styles/FLATBOOTS/template/event/topiclist_row_prepend.html"
+@@ -0,0 +1,23 @@
++{# display in view forum #}
++{% if topicrow.TOPIC_IMAGES %}
++	{% set preview = topicrow %}
++{% endif %}
++
++{# display in search results #}
++{% if searchresults.TOPIC_IMAGES %}
++	{% set preview = searchresults %}
++{% endif %}
++
++{# display in Similar Topics extension #}
++{% if similar.TOPIC_IMAGES %}
++	{% set preview = similar %}
++{% endif %}
++
++<span{% if preview.TOPIC_IMAGES %}
++	data-ot="{% for image in preview.TOPIC_IMAGES %}<img src='/forum/app.php/gallery/image/{{ image }}/source' alt='{{ lang('IMAGE') }}' style='max-width:{preview.TOPIC_IMAGES_SIZE_MAX}px; max-height:{preview.TOPIC_IMAGES_SIZE_MAX}px;'>&nbsp;{% endfor %}"
++	data-ot-group="topics"
++	data-ot-background="transparent"
++	data-ot-border-width="0"
++	data-ot-border-radius="0"{% endif %}>
++{% if preview.TOPIC_IMAGES %}<div style="float:left;padding-right:10px;">{% for image in preview.TOPIC_IMAGES %}<img src="/forum/app.php/gallery/image/{{ image }}/mini" alt="{{ lang('IMAGE') }}" style="max-width:{preview.TOPIC_IMAGES_SIZE_MIN}px; max-height:{preview.TOPIC_IMAGES_SIZE_MIN}px;">&nbsp;{% endfor %}</div>{% endif %}
++</span>
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/styles/FLATBOOTS/template/event/ucp_prefs_view_radio_buttons_append.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/styles/FLATBOOTS/template/event/ucp_prefs_view_radio_buttons_append.html"
+new file mode 100644
+index 000000000..9d7eab75d
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/styles/FLATBOOTS/template/event/ucp_prefs_view_radio_buttons_append.html"
+@@ -0,0 +1,9 @@
++{% if S_VSE_TIP_NUM %}
++	<dl>
++		<dt><label for="user_vse_tip1">{{ lang('DISPLAY_TOPIC_IMAGE_PREVIEWS') ~ lang('COLON') }}</label></dt>
++		<dd>
++			<label for="user_vse_tip1"><input type="radio" name="user_vse_tip" id="user_vse_tip1" value="1"{% if S_VSE_TIP_USER %} checked="checked"{% endif %} /> {{ lang('YES') }}</label>
++			<label for="user_vse_tip0"><input type="radio" name="user_vse_tip" id="user_vse_tip0" value="0"{% if not S_VSE_TIP_USER %} checked="checked"{% endif %} /> {{ lang('NO') }}</label>
++		</dd>
++	</dl>
++{% endif %}
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/styles/FLATBOOTS/template/js/opentip-jquery.js" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/styles/FLATBOOTS/template/js/opentip-jquery.js"
+new file mode 100644
+index 000000000..ddfb9a8d9
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/styles/FLATBOOTS/template/js/opentip-jquery.js"
+@@ -0,0 +1,1794 @@
++// Generated by CoffeeScript 1.4.0
++/*
++#
++# Opentip v2.4.6
++#
++# More info at [www.opentip.org](http://www.opentip.org)
++# 
++# Copyright (c) 2012, Matias Meno  
++# Graphics by Tjandra Mayerhold
++# 
++# Permission is hereby granted, free of charge, to any person obtaining a copy
++# of this software and associated documentation files (the "Software"), to deal
++# in the Software without restriction, including without limitation the rights
++# to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
++# copies of the Software, and to permit persons to whom the Software is
++# furnished to do so, subject to the following conditions:
++# 
++# The above copyright notice and this permission notice shall be included in
++# all copies or substantial portions of the Software.
++# 
++# THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
++# IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
++# FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
++# AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
++# LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
++# OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
++# THE SOFTWARE.
++#
++*/
++head.ready(function () {
++var Opentip, firstAdapter, i, mouseMoved, mousePosition, mousePositionObservers, position, vendors, _i, _len, _ref,
++  __slice = [].slice,
++  __indexOf = [].indexOf || function(item) { for (var i = 0, l = this.length; i < l; i++) { if (i in this && this[i] === item) return i; } return -1; },
++  __hasProp = {}.hasOwnProperty;
++
++Opentip = (function() {
++
++  Opentip.prototype.STICKS_OUT_TOP = 1;
++
++  Opentip.prototype.STICKS_OUT_BOTTOM = 2;
++
++  Opentip.prototype.STICKS_OUT_LEFT = 1;
++
++  Opentip.prototype.STICKS_OUT_RIGHT = 2;
++
++  Opentip.prototype["class"] = {
++    container: "opentip-container",
++    opentip: "opentip",
++    header: "ot-header",
++    content: "ot-content",
++    loadingIndicator: "ot-loading-indicator",
++    close: "ot-close",
++    goingToHide: "ot-going-to-hide",
++    hidden: "ot-hidden",
++    hiding: "ot-hiding",
++    goingToShow: "ot-going-to-show",
++    showing: "ot-showing",
++    visible: "ot-visible",
++    loading: "ot-loading",
++    ajaxError: "ot-ajax-error",
++    fixed: "ot-fixed",
++    showEffectPrefix: "ot-show-effect-",
++    hideEffectPrefix: "ot-hide-effect-",
++    stylePrefix: "style-"
++  };
++
++  function Opentip(element, content, title, options) {
++    var elementsOpentips, hideTrigger, methodToBind, optionSources, prop, styleName, _i, _j, _len, _len1, _ref, _ref1, _ref2, _tmpStyle,
++      _this = this;
++    this.id = ++Opentip.lastId;
++    this.debug("Creating Opentip.");
++    Opentip.tips.push(this);
++    this.adapter = Opentip.adapter;
++    elementsOpentips = this.adapter.data(element, "opentips") || [];
++    elementsOpentips.push(this);
++    this.adapter.data(element, "opentips", elementsOpentips);
++    this.triggerElement = this.adapter.wrap(element);
++    if (this.triggerElement.length > 1) {
++      throw new Error("You can't call Opentip on multiple elements.");
++    }
++    if (this.triggerElement.length < 1) {
++      throw new Error("Invalid element.");
++    }
++    this.loaded = false;
++    this.loading = false;
++    this.visible = false;
++    this.waitingToShow = false;
++    this.waitingToHide = false;
++    this.currentPosition = {
++      left: 0,
++      top: 0
++    };
++    this.dimensions = {
++      width: 100,
++      height: 50
++    };
++    this.content = "";
++    this.redraw = true;
++    this.currentObservers = {
++      showing: false,
++      visible: false,
++      hiding: false,
++      hidden: false
++    };
++    options = this.adapter.clone(options);
++    if (typeof content === "object") {
++      options = content;
++      content = title = void 0;
++    } else if (typeof title === "object") {
++      options = title;
++      title = void 0;
++    }
++    if (title != null) {
++      options.title = title;
++    }
++    if (content != null) {
++      this.setContent(content);
++    }
++    if (options["extends"] == null) {
++      if (options.style != null) {
++        options["extends"] = options.style;
++      } else {
++        options["extends"] = Opentip.defaultStyle;
++      }
++    }
++    optionSources = [options];
++    _tmpStyle = options;
++    while (_tmpStyle["extends"]) {
++      styleName = _tmpStyle["extends"];
++      _tmpStyle = Opentip.styles[styleName];
++      if (_tmpStyle == null) {
++        throw new Error("Invalid style: " + styleName);
++      }
++      optionSources.unshift(_tmpStyle);
++      if (!((_tmpStyle["extends"] != null) || styleName === "standard")) {
++        _tmpStyle["extends"] = "standard";
++      }
++    }
++    options = (_ref = this.adapter).extend.apply(_ref, [{}].concat(__slice.call(optionSources)));
++    options.hideTriggers = (function() {
++      var _i, _len, _ref1, _results;
++      _ref1 = options.hideTriggers;
++      _results = [];
++      for (_i = 0, _len = _ref1.length; _i < _len; _i++) {
++        hideTrigger = _ref1[_i];
++        _results.push(hideTrigger);
++      }
++      return _results;
++    })();
++    if (options.hideTrigger && options.hideTriggers.length === 0) {
++      options.hideTriggers.push(options.hideTrigger);
++    }
++    _ref1 = ["tipJoint", "targetJoint", "stem"];
++    for (_i = 0, _len = _ref1.length; _i < _len; _i++) {
++      prop = _ref1[_i];
++      if (options[prop] && typeof options[prop] === "string") {
++        options[prop] = new Opentip.Joint(options[prop]);
++      }
++    }
++    if (options.ajax && (options.ajax === true || !options.ajax)) {
++      if (this.adapter.tagName(this.triggerElement) === "A") {
++        options.ajax = this.adapter.attr(this.triggerElement, "href");
++      } else {
++        options.ajax = false;
++      }
++    }
++    if (options.showOn === "click" && this.adapter.tagName(this.triggerElement) === "A") {
++      this.adapter.observe(this.triggerElement, "click", function(e) {
++        e.preventDefault();
++        e.stopPropagation();
++        return e.stopped = true;
++      });
++    }
++    if (options.target) {
++      options.fixed = true;
++    }
++    if (options.stem === true) {
++      options.stem = new Opentip.Joint(options.tipJoint);
++    }
++    if (options.target === true) {
++      options.target = this.triggerElement;
++    } else if (options.target) {
++      options.target = this.adapter.wrap(options.target);
++    }
++    this.currentStem = options.stem;
++    if (options.delay == null) {
++      options.delay = options.showOn === "mouseover" ? 0.2 : 0;
++    }
++    if (options.targetJoint == null) {
++      options.targetJoint = new Opentip.Joint(options.tipJoint).flip();
++    }
++    this.showTriggers = [];
++    this.showTriggersWhenVisible = [];
++    this.hideTriggers = [];
++    if (options.showOn && options.showOn !== "creation") {
++      this.showTriggers.push({
++        element: this.triggerElement,
++        event: options.showOn
++      });
++    }
++    if (options.ajaxCache != null) {
++      options.cache = options.ajaxCache;
++      delete options.ajaxCache;
++    }
++    this.options = options;
++    this.bound = {};
++    _ref2 = ["prepareToShow", "prepareToHide", "show", "hide", "reposition"];
++    for (_j = 0, _len1 = _ref2.length; _j < _len1; _j++) {
++      methodToBind = _ref2[_j];
++      this.bound[methodToBind] = (function(methodToBind) {
++        return function() {
++          return _this[methodToBind].apply(_this, arguments);
++        };
++      })(methodToBind);
++    }
++    this.adapter.domReady(function() {
++      _this.activate();
++      if (_this.options.showOn === "creation") {
++        return _this.prepareToShow();
++      }
++    });
++  }
++
++  Opentip.prototype._setup = function() {
++    var hideOn, hideTrigger, hideTriggerElement, i, _i, _j, _len, _len1, _ref, _ref1, _results;
++    this.debug("Setting up the tooltip.");
++    this._buildContainer();
++    this.hideTriggers = [];
++    _ref = this.options.hideTriggers;
++    for (i = _i = 0, _len = _ref.length; _i < _len; i = ++_i) {
++      hideTrigger = _ref[i];
++      hideTriggerElement = null;
++      hideOn = this.options.hideOn instanceof Array ? this.options.hideOn[i] : this.options.hideOn;
++      if (typeof hideTrigger === "string") {
++        switch (hideTrigger) {
++          case "trigger":
++            hideOn = hideOn || "mouseout";
++            hideTriggerElement = this.triggerElement;
++            break;
++          case "tip":
++            hideOn = hideOn || "mouseover";
++            hideTriggerElement = this.container;
++            break;
++          case "target":
++            hideOn = hideOn || "mouseover";
++            hideTriggerElement = this.options.target;
++            break;
++          case "closeButton":
++            break;
++          default:
++            throw new Error("Unknown hide trigger: " + hideTrigger + ".");
++        }
++      } else {
++        hideOn = hideOn || "mouseover";
++        hideTriggerElement = this.adapter.wrap(hideTrigger);
++      }
++      if (hideTriggerElement) {
++        this.hideTriggers.push({
++          element: hideTriggerElement,
++          event: hideOn,
++          original: hideTrigger
++        });
++      }
++    }
++    _ref1 = this.hideTriggers;
++    _results = [];
++    for (_j = 0, _len1 = _ref1.length; _j < _len1; _j++) {
++      hideTrigger = _ref1[_j];
++      _results.push(this.showTriggersWhenVisible.push({
++        element: hideTrigger.element,
++        event: "mouseover"
++      }));
++    }
++    return _results;
++  };
++
++  Opentip.prototype._buildContainer = function() {
++    this.container = this.adapter.create("<div id=\"opentip-" + this.id + "\" class=\"" + this["class"].container + " " + this["class"].hidden + " " + this["class"].stylePrefix + this.options.className + "\"></div>");
++    this.adapter.css(this.container, {
++      position: "absolute"
++    });
++    if (this.options.ajax) {
++      this.adapter.addClass(this.container, this["class"].loading);
++    }
++    if (this.options.fixed) {
++      this.adapter.addClass(this.container, this["class"].fixed);
++    }
++    if (this.options.showEffect) {
++      this.adapter.addClass(this.container, "" + this["class"].showEffectPrefix + this.options.showEffect);
++    }
++    if (this.options.hideEffect) {
++      return this.adapter.addClass(this.container, "" + this["class"].hideEffectPrefix + this.options.hideEffect);
++    }
++  };
++
++  Opentip.prototype._buildElements = function() {
++    var headerElement, titleElement;
++    this.tooltipElement = this.adapter.create("<div class=\"" + this["class"].opentip + "\"><div class=\"" + this["class"].header + "\"></div><div class=\"" + this["class"].content + "\"></div></div>");
++    this.backgroundCanvas = this.adapter.wrap(document.createElement("canvas"));
++    this.adapter.css(this.backgroundCanvas, {
++      position: "absolute"
++    });
++    if (typeof G_vmlCanvasManager !== "undefined" && G_vmlCanvasManager !== null) {
++      G_vmlCanvasManager.initElement(this.adapter.unwrap(this.backgroundCanvas));
++    }
++    headerElement = this.adapter.find(this.tooltipElement, "." + this["class"].header);
++    if (this.options.title) {
++      titleElement = this.adapter.create("<h1></h1>");
++      this.adapter.update(titleElement, this.options.title, this.options.escapeTitle);
++      this.adapter.append(headerElement, titleElement);
++    }
++    if (this.options.ajax && !this.loaded) {
++      this.adapter.append(this.tooltipElement, this.adapter.create("<div class=\"" + this["class"].loadingIndicator + "\"><span>↻</span></div>"));
++    }
++    if (__indexOf.call(this.options.hideTriggers, "closeButton") >= 0) {
++      this.closeButtonElement = this.adapter.create("<a href=\"javascript:undefined;\" class=\"" + this["class"].close + "\"><span>Close</span></a>");
++      this.adapter.append(headerElement, this.closeButtonElement);
++    }
++    this.adapter.append(this.container, this.backgroundCanvas);
++    this.adapter.append(this.container, this.tooltipElement);
++    this.adapter.append(document.body, this.container);
++    this._newContent = true;
++    return this.redraw = true;
++  };
++
++  Opentip.prototype.setContent = function(content) {
++    this.content = content;
++    this._newContent = true;
++    if (typeof this.content === "function") {
++      this._contentFunction = this.content;
++      this.content = "";
++    } else {
++      this._contentFunction = null;
++    }
++    if (this.visible) {
++      return this._updateElementContent();
++    }
++  };
++
++  Opentip.prototype._updateElementContent = function() {
++    var contentDiv;
++    if (this._newContent || (!this.options.cache && this._contentFunction)) {
++      contentDiv = this.adapter.find(this.container, "." + this["class"].content);
++      if (contentDiv != null) {
++        if (this._contentFunction) {
++          this.debug("Executing content function.");
++          this.content = this._contentFunction(this);
++        }
++        this.adapter.update(contentDiv, this.content, this.options.escapeContent);
++      }
++      this._newContent = false;
++    }
++    this._storeAndLockDimensions();
++    return this.reposition();
++  };
++
++  Opentip.prototype._storeAndLockDimensions = function() {
++    var prevDimension;
++    if (!this.container) {
++      return;
++    }
++    prevDimension = this.dimensions;
++    this.adapter.css(this.container, {
++      width: "auto",
++      left: "0px",
++      top: "0px"
++    });
++    this.dimensions = this.adapter.dimensions(this.container);
++    this.dimensions.width += 1;
++    this.adapter.css(this.container, {
++      width: "" + this.dimensions.width + "px",
++      top: "" + this.currentPosition.top + "px",
++      left: "" + this.currentPosition.left + "px"
++    });
++    if (!this._dimensionsEqual(this.dimensions, prevDimension)) {
++      this.redraw = true;
++      return this._draw();
++    }
++  };
++
++  Opentip.prototype.activate = function() {
++    return this._setupObservers("hidden", "hiding");
++  };
++
++  Opentip.prototype.deactivate = function() {
++    this.debug("Deactivating tooltip.");
++    this.hide();
++    return this._setupObservers("-showing", "-visible", "-hidden", "-hiding");
++  };
++
++  Opentip.prototype._setupObservers = function() {
++    var observeOrStop, removeObserver, state, states, trigger, _i, _j, _k, _l, _len, _len1, _len2, _len3, _ref, _ref1, _ref2,
++      _this = this;
++    states = 1 <= arguments.length ? __slice.call(arguments, 0) : [];
++    for (_i = 0, _len = states.length; _i < _len; _i++) {
++      state = states[_i];
++      removeObserver = false;
++      if (state.charAt(0) === "-") {
++        removeObserver = true;
++        state = state.substr(1);
++      }
++      if (this.currentObservers[state] === !removeObserver) {
++        continue;
++      }
++      this.currentObservers[state] = !removeObserver;
++      observeOrStop = function() {
++        var args, _ref, _ref1;
++        args = 1 <= arguments.length ? __slice.call(arguments, 0) : [];
++        if (removeObserver) {
++          return (_ref = _this.adapter).stopObserving.apply(_ref, args);
++        } else {
++          return (_ref1 = _this.adapter).observe.apply(_ref1, args);
++        }
++      };
++      switch (state) {
++        case "showing":
++          _ref = this.hideTriggers;
++          for (_j = 0, _len1 = _ref.length; _j < _len1; _j++) {
++            trigger = _ref[_j];
++            observeOrStop(trigger.element, trigger.event, this.bound.prepareToHide);
++          }
++          observeOrStop((document.onresize != null ? document : window), "resize", this.bound.reposition);
++          observeOrStop(window, "scroll", this.bound.reposition);
++          break;
++        case "visible":
++          _ref1 = this.showTriggersWhenVisible;
++          for (_k = 0, _len2 = _ref1.length; _k < _len2; _k++) {
++            trigger = _ref1[_k];
++            observeOrStop(trigger.element, trigger.event, this.bound.prepareToShow);
++          }
++          break;
++        case "hiding":
++          _ref2 = this.showTriggers;
++          for (_l = 0, _len3 = _ref2.length; _l < _len3; _l++) {
++            trigger = _ref2[_l];
++            observeOrStop(trigger.element, trigger.event, this.bound.prepareToShow);
++          }
++          break;
++        case "hidden":
++          break;
++        default:
++          throw new Error("Unknown state: " + state);
++      }
++    }
++    return null;
++  };
++
++  Opentip.prototype.prepareToShow = function() {
++    this._abortHiding();
++    this._abortShowing();
++    if (this.visible) {
++      return;
++    }
++    this.debug("Showing in " + this.options.delay + "s.");
++    if (this.container == null) {
++      this._setup();
++    }
++    if (this.options.group) {
++      Opentip._abortShowingGroup(this.options.group, this);
++    }
++    this.preparingToShow = true;
++    this._setupObservers("-hidden", "-hiding", "showing");
++    this._followMousePosition();
++    if (this.options.fixed && !this.options.target) {
++      this.initialMousePosition = mousePosition;
++    }
++    this.reposition();
++    return this._showTimeoutId = this.setTimeout(this.bound.show, this.options.delay || 0);
++  };
++
++  Opentip.prototype.show = function() {
++    var _this = this;
++    this._abortHiding();
++    if (this.visible) {
++      return;
++    }
++    this._clearTimeouts();
++    if (!this._triggerElementExists()) {
++      return this.deactivate();
++    }
++    this.debug("Showing now.");
++    if (this.container == null) {
++      this._setup();
++    }
++    if (this.options.group) {
++      Opentip._hideGroup(this.options.group, this);
++    }
++    this.visible = true;
++    this.preparingToShow = false;
++    if (this.tooltipElement == null) {
++      this._buildElements();
++    }
++    this._updateElementContent();
++    if (this.options.ajax && (!this.loaded || !this.options.cache)) {
++      this._loadAjax();
++    }
++    this._searchAndActivateCloseButtons();
++    this._startEnsureTriggerElement();
++    this.adapter.css(this.container, {
++      zIndex: Opentip.lastZIndex++
++    });
++    this._setupObservers("-hidden", "-hiding", "-showing", "-visible", "showing", "visible");
++    if (this.options.fixed && !this.options.target) {
++      this.initialMousePosition = mousePosition;
++    }
++    this.reposition();
++    this.adapter.removeClass(this.container, this["class"].hiding);
++    this.adapter.removeClass(this.container, this["class"].hidden);
++    this.adapter.addClass(this.container, this["class"].goingToShow);
++    this.setCss3Style(this.container, {
++      transitionDuration: "0s"
++    });
++    this.defer(function() {
++      var delay;
++      if (!_this.visible || _this.preparingToHide) {
++        return;
++      }
++      _this.adapter.removeClass(_this.container, _this["class"].goingToShow);
++      _this.adapter.addClass(_this.container, _this["class"].showing);
++      delay = 0;
++      if (_this.options.showEffect && _this.options.showEffectDuration) {
++        delay = _this.options.showEffectDuration;
++      }
++      _this.setCss3Style(_this.container, {
++        transitionDuration: "" + delay + "s"
++      });
++      _this._visibilityStateTimeoutId = _this.setTimeout(function() {
++        _this.adapter.removeClass(_this.container, _this["class"].showing);
++        return _this.adapter.addClass(_this.container, _this["class"].visible);
++      }, delay);
++      return _this._activateFirstInput();
++    });
++    return this._draw();
++  };
++
++  Opentip.prototype._abortShowing = function() {
++    if (this.preparingToShow) {
++      this.debug("Aborting showing.");
++      this._clearTimeouts();
++      this._stopFollowingMousePosition();
++      this.preparingToShow = false;
++      return this._setupObservers("-showing", "-visible", "hiding", "hidden");
++    }
++  };
++
++  Opentip.prototype.prepareToHide = function() {
++    this._abortShowing();
++    this._abortHiding();
++    if (!this.visible) {
++      return;
++    }
++    this.debug("Hiding in " + this.options.hideDelay + "s");
++    this.preparingToHide = true;
++    this._setupObservers("-showing", "visible", "-hidden", "hiding");
++    return this._hideTimeoutId = this.setTimeout(this.bound.hide, this.options.hideDelay);
++  };
++
++  Opentip.prototype.hide = function() {
++    var _this = this;
++    this._abortShowing();
++    if (!this.visible) {
++      return;
++    }
++    this._clearTimeouts();
++    this.debug("Hiding!");
++    this.visible = false;
++    this.preparingToHide = false;
++    this._stopEnsureTriggerElement();
++    this._setupObservers("-showing", "-visible", "-hiding", "-hidden", "hiding", "hidden");
++    if (!this.options.fixed) {
++      this._stopFollowingMousePosition();
++    }
++    if (!this.container) {
++      return;
++    }
++    this.adapter.removeClass(this.container, this["class"].visible);
++    this.adapter.removeClass(this.container, this["class"].showing);
++    this.adapter.addClass(this.container, this["class"].goingToHide);
++    this.setCss3Style(this.container, {
++      transitionDuration: "0s"
++    });
++    return this.defer(function() {
++      var hideDelay;
++      _this.adapter.removeClass(_this.container, _this["class"].goingToHide);
++      _this.adapter.addClass(_this.container, _this["class"].hiding);
++      hideDelay = 0;
++      if (_this.options.hideEffect && _this.options.hideEffectDuration) {
++        hideDelay = _this.options.hideEffectDuration;
++      }
++      _this.setCss3Style(_this.container, {
++        transitionDuration: "" + hideDelay + "s"
++      });
++      return _this._visibilityStateTimeoutId = _this.setTimeout(function() {
++        _this.adapter.removeClass(_this.container, _this["class"].hiding);
++        _this.adapter.addClass(_this.container, _this["class"].hidden);
++        _this.setCss3Style(_this.container, {
++          transitionDuration: "0s"
++        });
++        if (_this.options.removeElementsOnHide) {
++          _this.debug("Removing HTML elements.");
++          _this.adapter.remove(_this.container);
++          delete _this.container;
++          return delete _this.tooltipElement;
++        }
++      }, hideDelay);
++    });
++  };
++
++  Opentip.prototype._abortHiding = function() {
++    if (this.preparingToHide) {
++      this.debug("Aborting hiding.");
++      this._clearTimeouts();
++      this.preparingToHide = false;
++      return this._setupObservers("-hiding", "showing", "visible");
++    }
++  };
++
++  Opentip.prototype.reposition = function() {
++    var position, stem, _ref,
++      _this = this;
++    position = this.getPosition();
++    if (position == null) {
++      return;
++    }
++    stem = this.options.stem;
++    if (this.options.containInViewport) {
++      _ref = this._ensureViewportContainment(position), position = _ref.position, stem = _ref.stem;
++    }
++    if (this._positionsEqual(position, this.currentPosition)) {
++      return;
++    }
++    if (!(!this.options.stem || stem.eql(this.currentStem))) {
++      this.redraw = true;
++    }
++    this.currentPosition = position;
++    this.currentStem = stem;
++    this._draw();
++    this.adapter.css(this.container, {
++      left: "" + position.left + "px",
++      top: "" + position.top + "px"
++    });
++    return this.defer(function() {
++      var rawContainer, redrawFix;
++      rawContainer = _this.adapter.unwrap(_this.container);
++      rawContainer.style.visibility = "hidden";
++      redrawFix = rawContainer.offsetHeight;
++      return rawContainer.style.visibility = "visible";
++    });
++  };
++
++  Opentip.prototype.getPosition = function(tipJoint, targetJoint, stem) {
++    var additionalHorizontal, additionalVertical, offsetDistance, position, stemLength, targetDimensions, targetPosition, unwrappedTarget, _ref;
++    if (!this.container) {
++      return;
++    }
++    if (tipJoint == null) {
++      tipJoint = this.options.tipJoint;
++    }
++    if (targetJoint == null) {
++      targetJoint = this.options.targetJoint;
++    }
++    position = {};
++    if (this.options.target) {
++      targetPosition = this.adapter.offset(this.options.target);
++      targetDimensions = this.adapter.dimensions(this.options.target);
++      position = targetPosition;
++      if (targetJoint.right) {
++        unwrappedTarget = this.adapter.unwrap(this.options.target);
++        if (unwrappedTarget.getBoundingClientRect != null) {
++          position.left = unwrappedTarget.getBoundingClientRect().right + ((_ref = window.pageXOffset) != null ? _ref : document.body.scrollLeft);
++        } else {
++          position.left += targetDimensions.width;
++        }
++      } else if (targetJoint.center) {
++        position.left += Math.round(targetDimensions.width / 2);
++      }
++      if (targetJoint.bottom) {
++        position.top += targetDimensions.height;
++      } else if (targetJoint.middle) {
++        position.top += Math.round(targetDimensions.height / 2);
++      }
++      if (this.options.borderWidth) {
++        if (this.options.tipJoint.left) {
++          position.left += this.options.borderWidth;
++        }
++        if (this.options.tipJoint.right) {
++          position.left -= this.options.borderWidth;
++        }
++        if (this.options.tipJoint.top) {
++          position.top += this.options.borderWidth;
++        } else if (this.options.tipJoint.bottom) {
++          position.top -= this.options.borderWidth;
++        }
++      }
++    } else {
++      if (this.initialMousePosition) {
++        position = {
++          top: this.initialMousePosition.y,
++          left: this.initialMousePosition.x
++        };
++      } else {
++        position = {
++          top: mousePosition.y,
++          left: mousePosition.x
++        };
++      }
++    }
++    if (this.options.autoOffset) {
++      stemLength = this.options.stem ? this.options.stemLength : 0;
++      offsetDistance = stemLength && this.options.fixed ? 2 : 10;
++      additionalHorizontal = tipJoint.middle && !this.options.fixed ? 15 : 0;
++      additionalVertical = tipJoint.center && !this.options.fixed ? 15 : 0;
++      if (tipJoint.right) {
++        position.left -= offsetDistance + additionalHorizontal;
++      } else if (tipJoint.left) {
++        position.left += offsetDistance + additionalHorizontal;
++      }
++      if (tipJoint.bottom) {
++        position.top -= offsetDistance + additionalVertical;
++      } else if (tipJoint.top) {
++        position.top += offsetDistance + additionalVertical;
++      }
++      if (stemLength) {
++        if (stem == null) {
++          stem = this.options.stem;
++        }
++        if (stem.right) {
++          position.left -= stemLength;
++        } else if (stem.left) {
++          position.left += stemLength;
++        }
++        if (stem.bottom) {
++          position.top -= stemLength;
++        } else if (stem.top) {
++          position.top += stemLength;
++        }
++      }
++    }
++    position.left += this.options.offset[0];
++    position.top += this.options.offset[1];
++    if (tipJoint.right) {
++      position.left -= this.dimensions.width;
++    } else if (tipJoint.center) {
++      position.left -= Math.round(this.dimensions.width / 2);
++    }
++    if (tipJoint.bottom) {
++      position.top -= this.dimensions.height;
++    } else if (tipJoint.middle) {
++      position.top -= Math.round(this.dimensions.height / 2);
++    }
++    return position;
++  };
++
++  Opentip.prototype._ensureViewportContainment = function(position) {
++    var needsRepositioning, newSticksOut, originals, revertedX, revertedY, scrollOffset, stem, sticksOut, targetJoint, tipJoint, viewportDimensions, viewportPosition;
++    stem = this.options.stem;
++    originals = {
++      position: position,
++      stem: stem
++    };
++    if (!(this.visible && position)) {
++      return originals;
++    }
++    sticksOut = this._sticksOut(position);
++    if (!(sticksOut[0] || sticksOut[1])) {
++      return originals;
++    }
++    tipJoint = new Opentip.Joint(this.options.tipJoint);
++    if (this.options.targetJoint) {
++      targetJoint = new Opentip.Joint(this.options.targetJoint);
++    }
++    scrollOffset = this.adapter.scrollOffset();
++    viewportDimensions = this.adapter.viewportDimensions();
++    viewportPosition = [position.left - scrollOffset[0], position.top - scrollOffset[1]];
++    needsRepositioning = false;
++    if (viewportDimensions.width >= this.dimensions.width) {
++      if (sticksOut[0]) {
++        needsRepositioning = true;
++        switch (sticksOut[0]) {
++          case this.STICKS_OUT_LEFT:
++            tipJoint.setHorizontal("left");
++            if (this.options.targetJoint) {
++              targetJoint.setHorizontal("right");
++            }
++            break;
++          case this.STICKS_OUT_RIGHT:
++            tipJoint.setHorizontal("right");
++            if (this.options.targetJoint) {
++              targetJoint.setHorizontal("left");
++            }
++        }
++      }
++    }
++    if (viewportDimensions.height >= this.dimensions.height) {
++      if (sticksOut[1]) {
++        needsRepositioning = true;
++        switch (sticksOut[1]) {
++          case this.STICKS_OUT_TOP:
++            tipJoint.setVertical("top");
++            if (this.options.targetJoint) {
++              targetJoint.setVertical("bottom");
++            }
++            break;
++          case this.STICKS_OUT_BOTTOM:
++            tipJoint.setVertical("bottom");
++            if (this.options.targetJoint) {
++              targetJoint.setVertical("top");
++            }
++        }
++      }
++    }
++    if (!needsRepositioning) {
++      return originals;
++    }
++    if (this.options.stem) {
++      stem = tipJoint;
++    }
++    position = this.getPosition(tipJoint, targetJoint, stem);
++    newSticksOut = this._sticksOut(position);
++    revertedX = false;
++    revertedY = false;
++    if (newSticksOut[0] && (newSticksOut[0] !== sticksOut[0])) {
++      revertedX = true;
++      tipJoint.setHorizontal(this.options.tipJoint.horizontal);
++      if (this.options.targetJoint) {
++        targetJoint.setHorizontal(this.options.targetJoint.horizontal);
++      }
++    }
++    if (newSticksOut[1] && (newSticksOut[1] !== sticksOut[1])) {
++      revertedY = true;
++      tipJoint.setVertical(this.options.tipJoint.vertical);
++      if (this.options.targetJoint) {
++        targetJoint.setVertical(this.options.targetJoint.vertical);
++      }
++    }
++    if (revertedX && revertedY) {
++      return originals;
++    }
++    if (revertedX || revertedY) {
++      if (this.options.stem) {
++        stem = tipJoint;
++      }
++      position = this.getPosition(tipJoint, targetJoint, stem);
++    }
++    return {
++      position: position,
++      stem: stem
++    };
++  };
++
++  Opentip.prototype._sticksOut = function(position) {
++    var positionOffset, scrollOffset, sticksOut, viewportDimensions;
++    scrollOffset = this.adapter.scrollOffset();
++    viewportDimensions = this.adapter.viewportDimensions();
++    positionOffset = [position.left - scrollOffset[0], position.top - scrollOffset[1]];
++    sticksOut = [false, false];
++    if (positionOffset[0] < 0) {
++      sticksOut[0] = this.STICKS_OUT_LEFT;
++    } else if (positionOffset[0] + this.dimensions.width > viewportDimensions.width) {
++      sticksOut[0] = this.STICKS_OUT_RIGHT;
++    }
++    if (positionOffset[1] < 0) {
++      sticksOut[1] = this.STICKS_OUT_TOP;
++    } else if (positionOffset[1] + this.dimensions.height > viewportDimensions.height) {
++      sticksOut[1] = this.STICKS_OUT_BOTTOM;
++    }
++    return sticksOut;
++  };
++
++  Opentip.prototype._draw = function() {
++    var backgroundCanvas, bulge, canvasDimensions, canvasPosition, closeButton, closeButtonInner, closeButtonOuter, ctx, drawCorner, drawLine, hb, position, stemBase, stemLength, _i, _len, _ref, _ref1, _ref2,
++      _this = this;
++    if (!(this.backgroundCanvas && this.redraw)) {
++      return;
++    }
++    this.debug("Drawing background.");
++    this.redraw = false;
++    if (this.currentStem) {
++      _ref = ["top", "right", "bottom", "left"];
++      for (_i = 0, _len = _ref.length; _i < _len; _i++) {
++        position = _ref[_i];
++        this.adapter.removeClass(this.container, "stem-" + position);
++      }
++      this.adapter.addClass(this.container, "stem-" + this.currentStem.horizontal);
++      this.adapter.addClass(this.container, "stem-" + this.currentStem.vertical);
++    }
++    closeButtonInner = [0, 0];
++    closeButtonOuter = [0, 0];
++    if (__indexOf.call(this.options.hideTriggers, "closeButton") >= 0) {
++      closeButton = new Opentip.Joint(((_ref1 = this.currentStem) != null ? _ref1.toString() : void 0) === "top right" ? "top left" : "top right");
++      closeButtonInner = [this.options.closeButtonRadius + this.options.closeButtonOffset[0], this.options.closeButtonRadius + this.options.closeButtonOffset[1]];
++      closeButtonOuter = [this.options.closeButtonRadius - this.options.closeButtonOffset[0], this.options.closeButtonRadius - this.options.closeButtonOffset[1]];
++    }
++    canvasDimensions = this.adapter.clone(this.dimensions);
++    canvasPosition = [0, 0];
++    if (this.options.borderWidth) {
++      canvasDimensions.width += this.options.borderWidth * 2;
++      canvasDimensions.height += this.options.borderWidth * 2;
++      canvasPosition[0] -= this.options.borderWidth;
++      canvasPosition[1] -= this.options.borderWidth;
++    }
++    if (this.options.shadow) {
++      canvasDimensions.width += this.options.shadowBlur * 2;
++      canvasDimensions.width += Math.max(0, this.options.shadowOffset[0] - this.options.shadowBlur * 2);
++      canvasDimensions.height += this.options.shadowBlur * 2;
++      canvasDimensions.height += Math.max(0, this.options.shadowOffset[1] - this.options.shadowBlur * 2);
++      canvasPosition[0] -= Math.max(0, this.options.shadowBlur - this.options.shadowOffset[0]);
++      canvasPosition[1] -= Math.max(0, this.options.shadowBlur - this.options.shadowOffset[1]);
++    }
++    bulge = {
++      left: 0,
++      right: 0,
++      top: 0,
++      bottom: 0
++    };
++    if (this.currentStem) {
++      if (this.currentStem.left) {
++        bulge.left = this.options.stemLength;
++      } else if (this.currentStem.right) {
++        bulge.right = this.options.stemLength;
++      }
++      if (this.currentStem.top) {
++        bulge.top = this.options.stemLength;
++      } else if (this.currentStem.bottom) {
++        bulge.bottom = this.options.stemLength;
++      }
++    }
++    if (closeButton) {
++      if (closeButton.left) {
++        bulge.left = Math.max(bulge.left, closeButtonOuter[0]);
++      } else if (closeButton.right) {
++        bulge.right = Math.max(bulge.right, closeButtonOuter[0]);
++      }
++      if (closeButton.top) {
++        bulge.top = Math.max(bulge.top, closeButtonOuter[1]);
++      } else if (closeButton.bottom) {
++        bulge.bottom = Math.max(bulge.bottom, closeButtonOuter[1]);
++      }
++    }
++    canvasDimensions.width += bulge.left + bulge.right;
++    canvasDimensions.height += bulge.top + bulge.bottom;
++    canvasPosition[0] -= bulge.left;
++    canvasPosition[1] -= bulge.top;
++    if (this.currentStem && this.options.borderWidth) {
++      _ref2 = this._getPathStemMeasures(this.options.stemBase, this.options.stemLength, this.options.borderWidth), stemLength = _ref2.stemLength, stemBase = _ref2.stemBase;
++    }
++    backgroundCanvas = this.adapter.unwrap(this.backgroundCanvas);
++    backgroundCanvas.width = canvasDimensions.width;
++    backgroundCanvas.height = canvasDimensions.height;
++    this.adapter.css(this.backgroundCanvas, {
++      width: "" + backgroundCanvas.width + "px",
++      height: "" + backgroundCanvas.height + "px",
++      left: "" + canvasPosition[0] + "px",
++      top: "" + canvasPosition[1] + "px"
++    });
++    ctx = backgroundCanvas.getContext("2d");
++    ctx.setTransform(1, 0, 0, 1, 0, 0);
++    ctx.clearRect(0, 0, backgroundCanvas.width, backgroundCanvas.height);
++    ctx.beginPath();
++    ctx.fillStyle = this._getColor(ctx, this.dimensions, this.options.background, this.options.backgroundGradientHorizontal);
++    ctx.lineJoin = "miter";
++    ctx.miterLimit = 500;
++    hb = this.options.borderWidth / 2;
++    if (this.options.borderWidth) {
++      ctx.strokeStyle = this.options.borderColor;
++      ctx.lineWidth = this.options.borderWidth;
++    } else {
++      stemLength = this.options.stemLength;
++      stemBase = this.options.stemBase;
++    }
++    if (stemBase == null) {
++      stemBase = 0;
++    }
++    drawLine = function(length, stem, first) {
++      if (first) {
++        ctx.moveTo(Math.max(stemBase, _this.options.borderRadius, closeButtonInner[0]) + 1 - hb, -hb);
++      }
++      if (stem) {
++        ctx.lineTo(length / 2 - stemBase / 2, -hb);
++        ctx.lineTo(length / 2, -stemLength - hb);
++        return ctx.lineTo(length / 2 + stemBase / 2, -hb);
++      }
++    };
++    drawCorner = function(stem, closeButton, i) {
++      var angle1, angle2, innerWidth, offset;
++      if (stem) {
++        ctx.lineTo(-stemBase + hb, 0 - hb);
++        ctx.lineTo(stemLength + hb, -stemLength - hb);
++        return ctx.lineTo(hb, stemBase - hb);
++      } else if (closeButton) {
++        offset = _this.options.closeButtonOffset;
++        innerWidth = closeButtonInner[0];
++        if (i % 2 !== 0) {
++          offset = [offset[1], offset[0]];
++          innerWidth = closeButtonInner[1];
++        }
++        angle1 = Math.acos(offset[1] / _this.options.closeButtonRadius);
++        angle2 = Math.acos(offset[0] / _this.options.closeButtonRadius);
++        ctx.lineTo(-innerWidth + hb, -hb);
++        return ctx.arc(hb - offset[0], -hb + offset[1], _this.options.closeButtonRadius, -(Math.PI / 2 + angle1), angle2, false);
++      } else {
++        ctx.lineTo(-_this.options.borderRadius + hb, -hb);
++        return ctx.quadraticCurveTo(hb, -hb, hb, _this.options.borderRadius - hb);
++      }
++    };
++    ctx.translate(-canvasPosition[0], -canvasPosition[1]);
++    ctx.save();
++    (function() {
++      var cornerStem, i, lineLength, lineStem, positionIdx, positionX, positionY, rotation, _j, _ref3, _results;
++      _results = [];
++      for (i = _j = 0, _ref3 = Opentip.positions.length / 2; 0 <= _ref3 ? _j < _ref3 : _j > _ref3; i = 0 <= _ref3 ? ++_j : --_j) {
++        positionIdx = i * 2;
++        positionX = i === 0 || i === 3 ? 0 : _this.dimensions.width;
++        positionY = i < 2 ? 0 : _this.dimensions.height;
++        rotation = (Math.PI / 2) * i;
++        lineLength = i % 2 === 0 ? _this.dimensions.width : _this.dimensions.height;
++        lineStem = new Opentip.Joint(Opentip.positions[positionIdx]);
++        cornerStem = new Opentip.Joint(Opentip.positions[positionIdx + 1]);
++        ctx.save();
++        ctx.translate(positionX, positionY);
++        ctx.rotate(rotation);
++        drawLine(lineLength, lineStem.eql(_this.currentStem), i === 0);
++        ctx.translate(lineLength, 0);
++        drawCorner(cornerStem.eql(_this.currentStem), cornerStem.eql(closeButton), i);
++        _results.push(ctx.restore());
++      }
++      return _results;
++    })();
++    ctx.closePath();
++    ctx.save();
++    if (this.options.shadow) {
++      ctx.shadowColor = this.options.shadowColor;
++      ctx.shadowBlur = this.options.shadowBlur;
++      ctx.shadowOffsetX = this.options.shadowOffset[0];
++      ctx.shadowOffsetY = this.options.shadowOffset[1];
++    }
++    ctx.fill();
++    ctx.restore();
++    if (this.options.borderWidth) {
++      ctx.stroke();
++    }
++    ctx.restore();
++    if (closeButton) {
++      return (function() {
++        var crossCenter, crossHeight, crossWidth, hcs, linkCenter;
++        crossWidth = crossHeight = _this.options.closeButtonRadius * 2;
++        if (closeButton.toString() === "top right") {
++          linkCenter = [_this.dimensions.width - _this.options.closeButtonOffset[0], _this.options.closeButtonOffset[1]];
++          crossCenter = [linkCenter[0] + hb, linkCenter[1] - hb];
++        } else {
++          linkCenter = [_this.options.closeButtonOffset[0], _this.options.closeButtonOffset[1]];
++          crossCenter = [linkCenter[0] - hb, linkCenter[1] - hb];
++        }
++        ctx.translate(crossCenter[0], crossCenter[1]);
++        hcs = _this.options.closeButtonCrossSize / 2;
++        ctx.save();
++        ctx.beginPath();
++        ctx.strokeStyle = _this.options.closeButtonCrossColor;
++        ctx.lineWidth = _this.options.closeButtonCrossLineWidth;
++        ctx.lineCap = "round";
++        ctx.moveTo(-hcs, -hcs);
++        ctx.lineTo(hcs, hcs);
++        ctx.stroke();
++        ctx.beginPath();
++        ctx.moveTo(hcs, -hcs);
++        ctx.lineTo(-hcs, hcs);
++        ctx.stroke();
++        ctx.restore();
++        return _this.adapter.css(_this.closeButtonElement, {
++          left: "" + (linkCenter[0] - hcs - _this.options.closeButtonLinkOverscan) + "px",
++          top: "" + (linkCenter[1] - hcs - _this.options.closeButtonLinkOverscan) + "px",
++          width: "" + (_this.options.closeButtonCrossSize + _this.options.closeButtonLinkOverscan * 2) + "px",
++          height: "" + (_this.options.closeButtonCrossSize + _this.options.closeButtonLinkOverscan * 2) + "px"
++        });
++      })();
++    }
++  };
++
++  Opentip.prototype._getPathStemMeasures = function(outerStemBase, outerStemLength, borderWidth) {
++    var angle, distanceBetweenTips, halfAngle, hb, rhombusSide, stemBase, stemLength;
++    hb = borderWidth / 2;
++    halfAngle = Math.atan((outerStemBase / 2) / outerStemLength);
++    angle = halfAngle * 2;
++    rhombusSide = hb / Math.sin(angle);
++    distanceBetweenTips = 2 * rhombusSide * Math.cos(halfAngle);
++    stemLength = hb + outerStemLength - distanceBetweenTips;
++    if (stemLength < 0) {
++      throw new Error("Sorry but your stemLength / stemBase ratio is strange.");
++    }
++    stemBase = (Math.tan(halfAngle) * stemLength) * 2;
++    return {
++      stemLength: stemLength,
++      stemBase: stemBase
++    };
++  };
++
++  Opentip.prototype._getColor = function(ctx, dimensions, color, horizontal) {
++    var colorStop, gradient, i, _i, _len;
++    if (horizontal == null) {
++      horizontal = false;
++    }
++    if (typeof color === "string") {
++      return color;
++    }
++    if (horizontal) {
++      gradient = ctx.createLinearGradient(0, 0, dimensions.width, 0);
++    } else {
++      gradient = ctx.createLinearGradient(0, 0, 0, dimensions.height);
++    }
++    for (i = _i = 0, _len = color.length; _i < _len; i = ++_i) {
++      colorStop = color[i];
++      gradient.addColorStop(colorStop[0], colorStop[1]);
++    }
++    return gradient;
++  };
++
++  Opentip.prototype._searchAndActivateCloseButtons = function() {
++    var element, _i, _len, _ref;
++    _ref = this.adapter.findAll(this.container, "." + this["class"].close);
++    for (_i = 0, _len = _ref.length; _i < _len; _i++) {
++      element = _ref[_i];
++      this.hideTriggers.push({
++        element: this.adapter.wrap(element),
++        event: "click"
++      });
++    }
++    if (this.currentObservers.showing) {
++      this._setupObservers("-showing", "showing");
++    }
++    if (this.currentObservers.visible) {
++      return this._setupObservers("-visible", "visible");
++    }
++  };
++
++  Opentip.prototype._activateFirstInput = function() {
++    var input;
++    input = this.adapter.unwrap(this.adapter.find(this.container, "input, textarea"));
++    return input != null ? typeof input.focus === "function" ? input.focus() : void 0 : void 0;
++  };
++
++  Opentip.prototype._followMousePosition = function() {
++    if (!this.options.fixed) {
++      return Opentip._observeMousePosition(this.bound.reposition);
++    }
++  };
++
++  Opentip.prototype._stopFollowingMousePosition = function() {
++    if (!this.options.fixed) {
++      return Opentip._stopObservingMousePosition(this.bound.reposition);
++    }
++  };
++
++  Opentip.prototype._clearShowTimeout = function() {
++    return clearTimeout(this._showTimeoutId);
++  };
++
++  Opentip.prototype._clearHideTimeout = function() {
++    return clearTimeout(this._hideTimeoutId);
++  };
++
++  Opentip.prototype._clearTimeouts = function() {
++    clearTimeout(this._visibilityStateTimeoutId);
++    this._clearShowTimeout();
++    return this._clearHideTimeout();
++  };
++
++  Opentip.prototype._triggerElementExists = function() {
++    var el;
++    el = this.adapter.unwrap(this.triggerElement);
++    while (el.parentNode) {
++      if (el.parentNode.tagName === "BODY") {
++        return true;
++      }
++      el = el.parentNode;
++    }
++    return false;
++  };
++
++  Opentip.prototype._loadAjax = function() {
++    var _this = this;
++    if (this.loading) {
++      return;
++    }
++    this.loaded = false;
++    this.loading = true;
++    this.adapter.addClass(this.container, this["class"].loading);
++    this.setContent("");
++    this.debug("Loading content from " + this.options.ajax);
++    return this.adapter.ajax({
++      url: this.options.ajax,
++      method: this.options.ajaxMethod,
++      onSuccess: function(responseText) {
++        _this.debug("Loading successful.");
++        _this.adapter.removeClass(_this.container, _this["class"].loading);
++        return _this.setContent(responseText);
++      },
++      onError: function(error) {
++        var message;
++        message = _this.options.ajaxErrorMessage;
++        _this.debug(message, error);
++        _this.setContent(message);
++        return _this.adapter.addClass(_this.container, _this["class"].ajaxError);
++      },
++      onComplete: function() {
++        _this.adapter.removeClass(_this.container, _this["class"].loading);
++        _this.loading = false;
++        _this.loaded = true;
++        _this._searchAndActivateCloseButtons();
++        _this._activateFirstInput();
++        return _this.reposition();
++      }
++    });
++  };
++
++  Opentip.prototype._ensureTriggerElement = function() {
++    if (!this._triggerElementExists()) {
++      this.deactivate();
++      return this._stopEnsureTriggerElement();
++    }
++  };
++
++  Opentip.prototype._ensureTriggerElementInterval = 1000;
++
++  Opentip.prototype._startEnsureTriggerElement = function() {
++    var _this = this;
++    return this._ensureTriggerElementTimeoutId = setInterval((function() {
++      return _this._ensureTriggerElement();
++    }), this._ensureTriggerElementInterval);
++  };
++
++  Opentip.prototype._stopEnsureTriggerElement = function() {
++    return clearInterval(this._ensureTriggerElementTimeoutId);
++  };
++
++  return Opentip;
++
++})();
++
++vendors = ["khtml", "ms", "o", "moz", "webkit"];
++
++Opentip.prototype.setCss3Style = function(element, styles) {
++  var prop, value, vendor, vendorProp, _results;
++  element = this.adapter.unwrap(element);
++  _results = [];
++  for (prop in styles) {
++    if (!__hasProp.call(styles, prop)) continue;
++    value = styles[prop];
++    if (element.style[prop] != null) {
++      _results.push(element.style[prop] = value);
++    } else {
++      _results.push((function() {
++        var _i, _len, _results1;
++        _results1 = [];
++        for (_i = 0, _len = vendors.length; _i < _len; _i++) {
++          vendor = vendors[_i];
++          vendorProp = "" + (this.ucfirst(vendor)) + (this.ucfirst(prop));
++          if (element.style[vendorProp] != null) {
++            _results1.push(element.style[vendorProp] = value);
++          } else {
++            _results1.push(void 0);
++          }
++        }
++        return _results1;
++      }).call(this));
++    }
++  }
++  return _results;
++};
++
++Opentip.prototype.defer = function(func) {
++  return setTimeout(func, 0);
++};
++
++Opentip.prototype.setTimeout = function(func, seconds) {
++  return setTimeout(func, seconds ? seconds * 1000 : 0);
++};
++
++Opentip.prototype.ucfirst = function(string) {
++  if (string == null) {
++    return "";
++  }
++  return string.charAt(0).toUpperCase() + string.slice(1);
++};
++
++Opentip.prototype.dasherize = function(string) {
++  return string.replace(/([A-Z])/g, function(_, character) {
++    return "-" + (character.toLowerCase());
++  });
++};
++
++mousePositionObservers = [];
++
++mousePosition = {
++  x: 0,
++  y: 0
++};
++
++mouseMoved = function(e) {
++  var observer, _i, _len, _results;
++  mousePosition = Opentip.adapter.mousePosition(e);
++  _results = [];
++  for (_i = 0, _len = mousePositionObservers.length; _i < _len; _i++) {
++    observer = mousePositionObservers[_i];
++    _results.push(observer());
++  }
++  return _results;
++};
++
++Opentip.followMousePosition = function() {
++  return Opentip.adapter.observe(document.body, "mousemove", mouseMoved);
++};
++
++Opentip._observeMousePosition = function(observer) {
++  return mousePositionObservers.push(observer);
++};
++
++Opentip._stopObservingMousePosition = function(removeObserver) {
++  var observer;
++  return mousePositionObservers = (function() {
++    var _i, _len, _results;
++    _results = [];
++    for (_i = 0, _len = mousePositionObservers.length; _i < _len; _i++) {
++      observer = mousePositionObservers[_i];
++      if (observer !== removeObserver) {
++        _results.push(observer);
++      }
++    }
++    return _results;
++  })();
++};
++
++Opentip.Joint = (function() {
++
++  function Joint(pointerString) {
++    if (pointerString == null) {
++      return;
++    }
++    if (pointerString instanceof Opentip.Joint) {
++      pointerString = pointerString.toString();
++    }
++    this.set(pointerString);
++    this;
++
++  }
++
++  Joint.prototype.set = function(string) {
++    string = string.toLowerCase();
++    this.setHorizontal(string);
++    this.setVertical(string);
++    return this;
++  };
++
++  Joint.prototype.setHorizontal = function(string) {
++    var i, valid, _i, _j, _len, _len1, _results;
++    valid = ["left", "center", "right"];
++    for (_i = 0, _len = valid.length; _i < _len; _i++) {
++      i = valid[_i];
++      if (~string.indexOf(i)) {
++        this.horizontal = i.toLowerCase();
++      }
++    }
++    if (this.horizontal == null) {
++      this.horizontal = "center";
++    }
++    _results = [];
++    for (_j = 0, _len1 = valid.length; _j < _len1; _j++) {
++      i = valid[_j];
++      _results.push(this[i] = this.horizontal === i ? i : void 0);
++    }
++    return _results;
++  };
++
++  Joint.prototype.setVertical = function(string) {
++    var i, valid, _i, _j, _len, _len1, _results;
++    valid = ["top", "middle", "bottom"];
++    for (_i = 0, _len = valid.length; _i < _len; _i++) {
++      i = valid[_i];
++      if (~string.indexOf(i)) {
++        this.vertical = i.toLowerCase();
++      }
++    }
++    if (this.vertical == null) {
++      this.vertical = "middle";
++    }
++    _results = [];
++    for (_j = 0, _len1 = valid.length; _j < _len1; _j++) {
++      i = valid[_j];
++      _results.push(this[i] = this.vertical === i ? i : void 0);
++    }
++    return _results;
++  };
++
++  Joint.prototype.eql = function(pointer) {
++    return (pointer != null) && this.horizontal === pointer.horizontal && this.vertical === pointer.vertical;
++  };
++
++  Joint.prototype.flip = function() {
++    var flippedIndex, positionIdx;
++    positionIdx = Opentip.position[this.toString(true)];
++    flippedIndex = (positionIdx + 4) % 8;
++    this.set(Opentip.positions[flippedIndex]);
++    return this;
++  };
++
++  Joint.prototype.toString = function(camelized) {
++    var horizontal, vertical;
++    if (camelized == null) {
++      camelized = false;
++    }
++    vertical = this.vertical === "middle" ? "" : this.vertical;
++    horizontal = this.horizontal === "center" ? "" : this.horizontal;
++    if (vertical && horizontal) {
++      if (camelized) {
++        horizontal = Opentip.prototype.ucfirst(horizontal);
++      } else {
++        horizontal = " " + horizontal;
++      }
++    }
++    return "" + vertical + horizontal;
++  };
++
++  return Joint;
++
++})();
++
++Opentip.prototype._positionsEqual = function(posA, posB) {
++  return (posA != null) && (posB != null) && posA.left === posB.left && posA.top === posB.top;
++};
++
++Opentip.prototype._dimensionsEqual = function(dimA, dimB) {
++  return (dimA != null) && (dimB != null) && dimA.width === dimB.width && dimA.height === dimB.height;
++};
++
++Opentip.prototype.debug = function() {
++  var args;
++  args = 1 <= arguments.length ? __slice.call(arguments, 0) : [];
++  if (Opentip.debug && ((typeof console !== "undefined" && console !== null ? console.debug : void 0) != null)) {
++    args.unshift("#" + this.id + " |");
++    return console.debug.apply(console, args);
++  }
++};
++
++Opentip.findElements = function() {
++  var adapter, content, element, optionName, optionValue, options, _i, _len, _ref, _results;
++  adapter = Opentip.adapter;
++  _ref = adapter.findAll(document.body, "[data-ot]");
++  _results = [];
++  for (_i = 0, _len = _ref.length; _i < _len; _i++) {
++    element = _ref[_i];
++    options = {};
++    content = adapter.data(element, "ot");
++    if (content === "" || content === "true" || content === "yes") {
++      content = adapter.attr(element, "title");
++      adapter.attr(element, "title", "");
++    }
++    content = content || "";
++    for (optionName in Opentip.styles.standard) {
++      optionValue = adapter.data(element, "ot" + (Opentip.prototype.ucfirst(optionName)));
++      if (optionValue != null) {
++        if (optionValue === "yes" || optionValue === "true" || optionValue === "on") {
++          optionValue = true;
++        } else if (optionValue === "no" || optionValue === "false" || optionValue === "off") {
++          optionValue = false;
++        }
++        options[optionName] = optionValue;
++      }
++    }
++    _results.push(new Opentip(element, content, options));
++  }
++  return _results;
++};
++
++Opentip.version = "2.4.6";
++
++Opentip.debug = false;
++
++Opentip.lastId = 0;
++
++Opentip.lastZIndex = 100;
++
++Opentip.tips = [];
++
++Opentip._abortShowingGroup = function(group, originatingOpentip) {
++  var opentip, _i, _len, _ref, _results;
++  _ref = Opentip.tips;
++  _results = [];
++  for (_i = 0, _len = _ref.length; _i < _len; _i++) {
++    opentip = _ref[_i];
++    if (opentip !== originatingOpentip && opentip.options.group === group) {
++      _results.push(opentip._abortShowing());
++    } else {
++      _results.push(void 0);
++    }
++  }
++  return _results;
++};
++
++Opentip._hideGroup = function(group, originatingOpentip) {
++  var opentip, _i, _len, _ref, _results;
++  _ref = Opentip.tips;
++  _results = [];
++  for (_i = 0, _len = _ref.length; _i < _len; _i++) {
++    opentip = _ref[_i];
++    if (opentip !== originatingOpentip && opentip.options.group === group) {
++      _results.push(opentip.hide());
++    } else {
++      _results.push(void 0);
++    }
++  }
++  return _results;
++};
++
++Opentip.adapters = {};
++
++Opentip.adapter = null;
++
++firstAdapter = true;
++
++Opentip.addAdapter = function(adapter) {
++  Opentip.adapters[adapter.name] = adapter;
++  if (firstAdapter) {
++    Opentip.adapter = adapter;
++    adapter.domReady(Opentip.findElements);
++    adapter.domReady(Opentip.followMousePosition);
++    return firstAdapter = false;
++  }
++};
++
++Opentip.positions = ["top", "topRight", "right", "bottomRight", "bottom", "bottomLeft", "left", "topLeft"];
++
++Opentip.position = {};
++
++_ref = Opentip.positions;
++for (i = _i = 0, _len = _ref.length; _i < _len; i = ++_i) {
++  position = _ref[i];
++  Opentip.position[position] = i;
++}
++
++Opentip.styles = {
++  standard: {
++    "extends": null,
++    title: void 0,
++    escapeTitle: true,
++    escapeContent: false,
++    className: "standard",
++    stem: true,
++    delay: null,
++    hideDelay: 0.1,
++    fixed: false,
++    showOn: "mouseover",
++    hideTrigger: "trigger",
++    hideTriggers: [],
++    hideOn: null,
++    removeElementsOnHide: false,
++    offset: [0, 0],
++    containInViewport: true,
++    autoOffset: true,
++    showEffect: "appear",
++    hideEffect: "fade",
++    showEffectDuration: 0.3,
++    hideEffectDuration: 0.2,
++    stemLength: 5,
++    stemBase: 8,
++    tipJoint: "top left",
++    target: null,
++    targetJoint: null,
++    cache: true,
++    ajax: false,
++    ajaxMethod: "GET",
++    ajaxErrorMessage: "There was a problem downloading the content.",
++    group: null,
++    style: null,
++    background: "#fff18f",
++    backgroundGradientHorizontal: false,
++    closeButtonOffset: [5, 5],
++    closeButtonRadius: 7,
++    closeButtonCrossSize: 4,
++    closeButtonCrossColor: "#d2c35b",
++    closeButtonCrossLineWidth: 1.5,
++    closeButtonLinkOverscan: 6,
++    borderRadius: 5,
++    borderWidth: 1,
++    borderColor: "#f2e37b",
++    shadow: true,
++    shadowBlur: 10,
++    shadowOffset: [3, 3],
++    shadowColor: "rgba(0, 0, 0, 0.1)"
++  },
++  glass: {
++    "extends": "standard",
++    className: "glass",
++    background: [[0, "rgba(252, 252, 252, 0.8)"], [0.5, "rgba(255, 255, 255, 0.8)"], [0.5, "rgba(250, 250, 250, 0.9)"], [1, "rgba(245, 245, 245, 0.9)"]],
++    borderColor: "#eee",
++    closeButtonCrossColor: "rgba(0, 0, 0, 0.2)",
++    borderRadius: 15,
++    closeButtonRadius: 10,
++    closeButtonOffset: [8, 8]
++  },
++  dark: {
++    "extends": "standard",
++    className: "dark",
++    borderRadius: 13,
++    borderColor: "#444",
++    closeButtonCrossColor: "rgba(240, 240, 240, 1)",
++    shadowColor: "rgba(0, 0, 0, 0.3)",
++    shadowOffset: [2, 2],
++    background: [[0, "rgba(30, 30, 30, 0.7)"], [0.5, "rgba(30, 30, 30, 0.8)"], [0.5, "rgba(10, 10, 10, 0.8)"], [1, "rgba(10, 10, 10, 0.9)"]]
++  },
++  alert: {
++    "extends": "standard",
++    className: "alert",
++    borderRadius: 1,
++    borderColor: "#AE0D11",
++    closeButtonCrossColor: "rgba(255, 255, 255, 1)",
++    shadowColor: "rgba(0, 0, 0, 0.3)",
++    shadowOffset: [2, 2],
++    background: [[0, "rgba(203, 15, 19, 0.7)"], [0.5, "rgba(203, 15, 19, 0.8)"], [0.5, "rgba(189, 14, 18, 0.8)"], [1, "rgba(179, 14, 17, 0.9)"]]
++  }
++};
++
++Opentip.defaultStyle = "standard";
++
++if (typeof module !== "undefined" && module !== null) {
++  module.exports = Opentip;
++} else {
++  window.Opentip = Opentip;
++}
++
++
++// Generated by CoffeeScript 1.4.0
++var __slice = [].slice;
++
++(function($) {
++  var Adapter;
++  $.fn.opentip = function(content, title, options) {
++    return new Opentip(this, content, title, options);
++  };
++  Adapter = (function() {
++
++    function Adapter() {}
++
++    Adapter.prototype.name = "jquery";
++
++    Adapter.prototype.domReady = function(callback) {
++      return $(callback);
++    };
++
++    Adapter.prototype.create = function(html) {
++      return $(html);
++    };
++
++    Adapter.prototype.wrap = function(element) {
++      element = $(element);
++      if (element.length > 1) {
++        throw new Error("Multiple elements provided.");
++      }
++      return element;
++    };
++
++    Adapter.prototype.unwrap = function(element) {
++      return $(element)[0];
++    };
++
++    Adapter.prototype.tagName = function(element) {
++      return this.unwrap(element).tagName;
++    };
++
++    Adapter.prototype.attr = function() {
++      var args, element, _ref;
++      element = arguments[0], args = 2 <= arguments.length ? __slice.call(arguments, 1) : [];
++      return (_ref = $(element)).attr.apply(_ref, args);
++    };
++
++    Adapter.prototype.data = function() {
++      var args, element, _ref;
++      element = arguments[0], args = 2 <= arguments.length ? __slice.call(arguments, 1) : [];
++      return (_ref = $(element)).data.apply(_ref, args);
++    };
++
++    Adapter.prototype.find = function(element, selector) {
++      return $(element).find(selector).get(0);
++    };
++
++    Adapter.prototype.findAll = function(element, selector) {
++      return $(element).find(selector);
++    };
++
++    Adapter.prototype.update = function(element, content, escape) {
++      element = $(element);
++      if (escape) {
++        return element.text(content);
++      } else {
++        return element.html(content);
++      }
++    };
++
++    Adapter.prototype.append = function(element, child) {
++      return $(element).append(child);
++    };
++
++    Adapter.prototype.remove = function(element) {
++      return $(element).remove();
++    };
++
++    Adapter.prototype.addClass = function(element, className) {
++      return $(element).addClass(className);
++    };
++
++    Adapter.prototype.removeClass = function(element, className) {
++      return $(element).removeClass(className);
++    };
++
++    Adapter.prototype.css = function(element, properties) {
++      return $(element).css(properties);
++    };
++
++    Adapter.prototype.dimensions = function(element) {
++      return {
++        width: $(element).outerWidth(),
++        height: $(element).outerHeight()
++      };
++    };
++
++    Adapter.prototype.scrollOffset = function() {
++      return [window.pageXOffset || document.documentElement.scrollLeft || document.body.scrollLeft, window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop];
++    };
++
++    Adapter.prototype.viewportDimensions = function() {
++      return {
++        width: document.documentElement.clientWidth,
++        height: document.documentElement.clientHeight
++      };
++    };
++
++    Adapter.prototype.mousePosition = function(e) {
++      if (e == null) {
++        return null;
++      }
++      return {
++        x: e.pageX,
++        y: e.pageY
++      };
++    };
++
++    Adapter.prototype.offset = function(element) {
++      var offset;
++      offset = $(element).offset();
++      return {
++        left: offset.left,
++        top: offset.top
++      };
++    };
++
++    Adapter.prototype.observe = function(element, eventName, observer) {
++      return $(element).bind(eventName, observer);
++    };
++
++    Adapter.prototype.stopObserving = function(element, eventName, observer) {
++      return $(element).unbind(eventName, observer);
++    };
++
++    Adapter.prototype.ajax = function(options) {
++      var _ref, _ref1;
++      if (options.url == null) {
++        throw new Error("No url provided");
++      }
++      return $.ajax({
++        url: options.url,
++        type: (_ref = (_ref1 = options.method) != null ? _ref1.toUpperCase() : void 0) != null ? _ref : "GET"
++      }).done(function(content) {
++        return typeof options.onSuccess === "function" ? options.onSuccess(content) : void 0;
++      }).fail(function(request) {
++        return typeof options.onError === "function" ? options.onError("Server responded with status " + request.status) : void 0;
++      }).always(function() {
++        return typeof options.onComplete === "function" ? options.onComplete() : void 0;
++      });
++    };
++
++    Adapter.prototype.clone = function(object) {
++      return $.extend({}, object);
++    };
++
++    Adapter.prototype.extend = function() {
++      var sources, target;
++      target = arguments[0], sources = 2 <= arguments.length ? __slice.call(arguments, 1) : [];
++      return $.extend.apply($, [target].concat(__slice.call(sources)));
++    };
++
++    return Adapter;
++
++  })();
++  return Opentip.addAdapter(new Adapter);
++})(jQuery);
++});
+\ No newline at end of file
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/styles/FLATBOOTS/template/js/opentip-jquery.min.js" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/styles/FLATBOOTS/template/js/opentip-jquery.min.js"
+new file mode 100644
+index 000000000..c47ebb565
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/styles/FLATBOOTS/template/js/opentip-jquery.min.js"
+@@ -0,0 +1,6 @@
++// Opentip v2.4.6
++// Copyright (c) 2009-2012
++// www.opentip.org
++// MIT Licensed
++head.ready(function(){var Opentip,firstAdapter,i,mouseMoved,mousePosition,mousePositionObservers,position,vendors,_i,_len,_ref,__slice=[].slice,__indexOf=[].indexOf||function(t){for(var e=0,i=this.length;i>e;e++)if(e in this&&this[e]===t)return e;return-1},__hasProp={}.hasOwnProperty;for(Opentip=function(){function t(e,i,o,s){var n,r,a,h,p,d,l,u,c,g,f,m,v,b,w=this;if(this.id=++t.lastId,this.debug("Creating Opentip."),t.tips.push(this),this.adapter=t.adapter,n=this.adapter.data(e,"opentips")||[],n.push(this),this.adapter.data(e,"opentips",n),this.triggerElement=this.adapter.wrap(e),this.triggerElement.length>1)throw Error("You can't call Opentip on multiple elements.");if(1>this.triggerElement.length)throw Error("Invalid element.");this.loaded=!1,this.loading=!1,this.visible=!1,this.waitingToShow=!1,this.waitingToHide=!1,this.currentPosition={left:0,top:0},this.dimensions={width:100,height:50},this.content="",this.redraw=!0,this.currentObservers={showing:!1,visible:!1,hiding:!1,hidden:!1},s=this.adapter.clone(s),typeof i=="object"?(s=i,i=o=void 0):typeof o=="object"&&(s=o,o=void 0),o!=null&&(s.title=o),i!=null&&this.setContent(i),s["extends"]==null&&(s["extends"]=s.style!=null?s.style:t.defaultStyle),h=[s],b=s;while(b["extends"]){if(d=b["extends"],b=t.styles[d],b==null)throw Error("Invalid style: "+d);h.unshift(b),b["extends"]==null&&d!=="standard"&&(b["extends"]="standard")}for(s=(f=this.adapter).extend.apply(f,[{}].concat(__slice.call(h))),s.hideTriggers=function(){var t,e,i,o;for(i=s.hideTriggers,o=[],t=0,e=i.length;e>t;t++)r=i[t],o.push(r);return o}(),s.hideTrigger&&s.hideTriggers.length===0&&s.hideTriggers.push(s.hideTrigger),m=["tipJoint","targetJoint","stem"],l=0,c=m.length;c>l;l++)p=m[l],s[p]&&typeof s[p]=="string"&&(s[p]=new t.Joint(s[p]));for(!s.ajax||s.ajax!==!0&&s.ajax||(s.ajax=this.adapter.tagName(this.triggerElement)==="A"?this.adapter.attr(this.triggerElement,"href"):!1),s.showOn==="click"&&this.adapter.tagName(this.triggerElement)==="A"&&this.adapter.observe(this.triggerElement,"click",function(t){return t.preventDefault(),t.stopPropagation(),t.stopped=!0}),s.target&&(s.fixed=!0),s.stem===!0&&(s.stem=new t.Joint(s.tipJoint)),s.target===!0?s.target=this.triggerElement:s.target&&(s.target=this.adapter.wrap(s.target)),this.currentStem=s.stem,s.delay==null&&(s.delay=s.showOn==="mouseover"?.2:0),s.targetJoint==null&&(s.targetJoint=new t.Joint(s.tipJoint).flip()),this.showTriggers=[],this.showTriggersWhenVisible=[],this.hideTriggers=[],s.showOn&&s.showOn!=="creation"&&this.showTriggers.push({element:this.triggerElement,event:s.showOn}),s.ajaxCache!=null&&(s.cache=s.ajaxCache,delete s.ajaxCache),this.options=s,this.bound={},v=["prepareToShow","prepareToHide","show","hide","reposition"],u=0,g=v.length;g>u;u++)a=v[u],this.bound[a]=function(t){return function(){return w[t].apply(w,arguments)}}(a);this.adapter.domReady(function(){return w.activate(),w.options.showOn==="creation"?w.prepareToShow():void 0})}return t.prototype.STICKS_OUT_TOP=1,t.prototype.STICKS_OUT_BOTTOM=2,t.prototype.STICKS_OUT_LEFT=1,t.prototype.STICKS_OUT_RIGHT=2,t.prototype["class"]={container:"opentip-container",opentip:"opentip",header:"ot-header",content:"ot-content",loadingIndicator:"ot-loading-indicator",close:"ot-close",goingToHide:"ot-going-to-hide",hidden:"ot-hidden",hiding:"ot-hiding",goingToShow:"ot-going-to-show",showing:"ot-showing",visible:"ot-visible",loading:"ot-loading",ajaxError:"ot-ajax-error",fixed:"ot-fixed",showEffectPrefix:"ot-show-effect-",hideEffectPrefix:"ot-hide-effect-",stylePrefix:"style-"},t.prototype._setup=function(){var t,e,i,o,s,n,r,a,h,p,d;for(this.debug("Setting up the tooltip."),this._buildContainer(),this.hideTriggers=[],h=this.options.hideTriggers,o=s=0,r=h.length;r>s;o=++s){if(e=h[o],i=null,t=this.options.hideOn instanceof Array?this.options.hideOn[o]:this.options.hideOn,typeof e=="string")switch(e){case"trigger":t=t||"mouseout",i=this.triggerElement;break;case"tip":t=t||"mouseover",i=this.container;break;case"target":t=t||"mouseover",i=this.options.target;break;case"closeButton":break;default:throw Error("Unknown hide trigger: "+e+".")}else t=t||"mouseover",i=this.adapter.wrap(e);i&&this.hideTriggers.push({element:i,event:t,original:e})}for(p=this.hideTriggers,d=[],n=0,a=p.length;a>n;n++)e=p[n],d.push(this.showTriggersWhenVisible.push({element:e.element,event:"mouseover"}));return d},t.prototype._buildContainer=function(){return this.container=this.adapter.create('<div id="opentip-'+this.id+'" class="'+this["class"].container+" "+this["class"].hidden+" "+this["class"].stylePrefix+this.options.className+'"></div>'),this.adapter.css(this.container,{position:"absolute"}),this.options.ajax&&this.adapter.addClass(this.container,this["class"].loading),this.options.fixed&&this.adapter.addClass(this.container,this["class"].fixed),this.options.showEffect&&this.adapter.addClass(this.container,""+this["class"].showEffectPrefix+this.options.showEffect),this.options.hideEffect?this.adapter.addClass(this.container,""+this["class"].hideEffectPrefix+this.options.hideEffect):void 0},t.prototype._buildElements=function(){var t,e;return this.tooltipElement=this.adapter.create('<div class="'+this["class"].opentip+'"><div class="'+this["class"].header+'"></div><div class="'+this["class"].content+'"></div></div>'),this.backgroundCanvas=this.adapter.wrap(document.createElement("canvas")),this.adapter.css(this.backgroundCanvas,{position:"absolute"}),typeof G_vmlCanvasManager!="undefined"&&G_vmlCanvasManager!==null&&G_vmlCanvasManager.initElement(this.adapter.unwrap(this.backgroundCanvas)),t=this.adapter.find(this.tooltipElement,"."+this["class"].header),this.options.title&&(e=this.adapter.create("<h1></h1>"),this.adapter.update(e,this.options.title,this.options.escapeTitle),this.adapter.append(t,e)),this.options.ajax&&!this.loaded&&this.adapter.append(this.tooltipElement,this.adapter.create('<div class="'+this["class"].loadingIndicator+'"><span>↻</span></div>')),__indexOf.call(this.options.hideTriggers,"closeButton")>=0&&(this.closeButtonElement=this.adapter.create('<a href="javascript:undefined;" class="'+this["class"].close+'"><span>Close</span></a>'),this.adapter.append(t,this.closeButtonElement)),this.adapter.append(this.container,this.backgroundCanvas),this.adapter.append(this.container,this.tooltipElement),this.adapter.append(document.body,this.container),this._newContent=!0,this.redraw=!0},t.prototype.setContent=function(t){return this.content=t,this._newContent=!0,typeof this.content=="function"?(this._contentFunction=this.content,this.content=""):this._contentFunction=null,this.visible?this._updateElementContent():void 0},t.prototype._updateElementContent=function(){var t;return(this._newContent||!this.options.cache&&this._contentFunction)&&(t=this.adapter.find(this.container,"."+this["class"].content),t!=null&&(this._contentFunction&&(this.debug("Executing content function."),this.content=this._contentFunction(this)),this.adapter.update(t,this.content,this.options.escapeContent)),this._newContent=!1),this._storeAndLockDimensions(),this.reposition()},t.prototype._storeAndLockDimensions=function(){var t;if(this.container)return t=this.dimensions,this.adapter.css(this.container,{width:"auto",left:"0px",top:"0px"}),this.dimensions=this.adapter.dimensions(this.container),this.dimensions.width+=1,this.adapter.css(this.container,{width:""+this.dimensions.width+"px",top:""+this.currentPosition.top+"px",left:""+this.currentPosition.left+"px"}),this._dimensionsEqual(this.dimensions,t)?void 0:(this.redraw=!0,this._draw())},t.prototype.activate=function(){return this._setupObservers("hidden","hiding")},t.prototype.deactivate=function(){return this.debug("Deactivating tooltip."),this.hide(),this._setupObservers("-showing","-visible","-hidden","-hiding")},t.prototype._setupObservers=function(){var t,e,i,o,s,n,r,a,h,p,d,l,u,c,g,f,m=this;for(o=arguments.length>=1?__slice.call(arguments,0):[],n=0,p=o.length;p>n;n++)if(i=o[n],e=!1,i.charAt(0)==="-"&&(e=!0,i=i.substr(1)),this.currentObservers[i]!==!e)switch(this.currentObservers[i]=!e,t=function(){var t,i,o;return t=arguments.length>=1?__slice.call(arguments,0):[],e?(i=m.adapter).stopObserving.apply(i,t):(o=m.adapter).observe.apply(o,t)},i){case"showing":for(c=this.hideTriggers,r=0,d=c.length;d>r;r++)s=c[r],t(s.element,s.event,this.bound.prepareToHide);t(document.onresize!=null?document:window,"resize",this.bound.reposition),t(window,"scroll",this.bound.reposition);break;case"visible":for(g=this.showTriggersWhenVisible,a=0,l=g.length;l>a;a++)s=g[a],t(s.element,s.event,this.bound.prepareToShow);break;case"hiding":for(f=this.showTriggers,h=0,u=f.length;u>h;h++)s=f[h],t(s.element,s.event,this.bound.prepareToShow);break;case"hidden":break;default:throw Error("Unknown state: "+i)}return null},t.prototype.prepareToShow=function(){return this._abortHiding(),this._abortShowing(),this.visible?void 0:(this.debug("Showing in "+this.options.delay+"s."),this.container==null&&this._setup(),this.options.group&&t._abortShowingGroup(this.options.group,this),this.preparingToShow=!0,this._setupObservers("-hidden","-hiding","showing"),this._followMousePosition(),this.options.fixed&&!this.options.target&&(this.initialMousePosition=mousePosition),this.reposition(),this._showTimeoutId=this.setTimeout(this.bound.show,this.options.delay||0))},t.prototype.show=function(){var e=this;return this._abortHiding(),this.visible?void 0:(this._clearTimeouts(),this._triggerElementExists()?(this.debug("Showing now."),this.container==null&&this._setup(),this.options.group&&t._hideGroup(this.options.group,this),this.visible=!0,this.preparingToShow=!1,this.tooltipElement==null&&this._buildElements(),this._updateElementContent(),!this.options.ajax||this.loaded&&this.options.cache||this._loadAjax(),this._searchAndActivateCloseButtons(),this._startEnsureTriggerElement(),this.adapter.css(this.container,{zIndex:t.lastZIndex++}),this._setupObservers("-hidden","-hiding","-showing","-visible","showing","visible"),this.options.fixed&&!this.options.target&&(this.initialMousePosition=mousePosition),this.reposition(),this.adapter.removeClass(this.container,this["class"].hiding),this.adapter.removeClass(this.container,this["class"].hidden),this.adapter.addClass(this.container,this["class"].goingToShow),this.setCss3Style(this.container,{transitionDuration:"0s"}),this.defer(function(){var t;if(e.visible&&!e.preparingToHide)return e.adapter.removeClass(e.container,e["class"].goingToShow),e.adapter.addClass(e.container,e["class"].showing),t=0,e.options.showEffect&&e.options.showEffectDuration&&(t=e.options.showEffectDuration),e.setCss3Style(e.container,{transitionDuration:""+t+"s"}),e._visibilityStateTimeoutId=e.setTimeout(function(){return e.adapter.removeClass(e.container,e["class"].showing),e.adapter.addClass(e.container,e["class"].visible)},t),e._activateFirstInput()}),this._draw()):this.deactivate())},t.prototype._abortShowing=function(){return this.preparingToShow?(this.debug("Aborting showing."),this._clearTimeouts(),this._stopFollowingMousePosition(),this.preparingToShow=!1,this._setupObservers("-showing","-visible","hiding","hidden")):void 0},t.prototype.prepareToHide=function(){return this._abortShowing(),this._abortHiding(),this.visible?(this.debug("Hiding in "+this.options.hideDelay+"s"),this.preparingToHide=!0,this._setupObservers("-showing","visible","-hidden","hiding"),this._hideTimeoutId=this.setTimeout(this.bound.hide,this.options.hideDelay)):void 0},t.prototype.hide=function(){var t=this;return this._abortShowing(),this.visible&&(this._clearTimeouts(),this.debug("Hiding!"),this.visible=!1,this.preparingToHide=!1,this._stopEnsureTriggerElement(),this._setupObservers("-showing","-visible","-hiding","-hidden","hiding","hidden"),this.options.fixed||this._stopFollowingMousePosition(),this.container)?(this.adapter.removeClass(this.container,this["class"].visible),this.adapter.removeClass(this.container,this["class"].showing),this.adapter.addClass(this.container,this["class"].goingToHide),this.setCss3Style(this.container,{transitionDuration:"0s"}),this.defer(function(){var e;return t.adapter.removeClass(t.container,t["class"].goingToHide),t.adapter.addClass(t.container,t["class"].hiding),e=0,t.options.hideEffect&&t.options.hideEffectDuration&&(e=t.options.hideEffectDuration),t.setCss3Style(t.container,{transitionDuration:""+e+"s"}),t._visibilityStateTimeoutId=t.setTimeout(function(){return t.adapter.removeClass(t.container,t["class"].hiding),t.adapter.addClass(t.container,t["class"].hidden),t.setCss3Style(t.container,{transitionDuration:"0s"}),t.options.removeElementsOnHide?(t.debug("Removing HTML elements."),t.adapter.remove(t.container),delete t.container,delete t.tooltipElement):void 0},e)})):void 0},t.prototype._abortHiding=function(){return this.preparingToHide?(this.debug("Aborting hiding."),this._clearTimeouts(),this.preparingToHide=!1,this._setupObservers("-hiding","showing","visible")):void 0},t.prototype.reposition=function(){var t,e,i,o=this;return t=this.getPosition(),t==null||(e=this.options.stem,this.options.containInViewport&&(i=this._ensureViewportContainment(t),t=i.position,e=i.stem),this._positionsEqual(t,this.currentPosition))?void 0:(this.options.stem&&!e.eql(this.currentStem)&&(this.redraw=!0),this.currentPosition=t,this.currentStem=e,this._draw(),this.adapter.css(this.container,{left:""+t.left+"px",top:""+t.top+"px"}),this.defer(function(){var t,e;return t=o.adapter.unwrap(o.container),t.style.visibility="hidden",e=t.offsetHeight,t.style.visibility="visible"}))},t.prototype.getPosition=function(t,e,i){var o,s,n,r,a,h,p,d,l;if(this.container)return t==null&&(t=this.options.tipJoint),e==null&&(e=this.options.targetJoint),r={},this.options.target?(p=this.adapter.offset(this.options.target),h=this.adapter.dimensions(this.options.target),r=p,e.right?(d=this.adapter.unwrap(this.options.target),d.getBoundingClientRect!=null?r.left=d.getBoundingClientRect().right+((l=window.pageXOffset)!=null?l:document.body.scrollLeft):r.left+=h.width):e.center&&(r.left+=Math.round(h.width/2)),e.bottom?r.top+=h.height:e.middle&&(r.top+=Math.round(h.height/2)),this.options.borderWidth&&(this.options.tipJoint.left&&(r.left+=this.options.borderWidth),this.options.tipJoint.right&&(r.left-=this.options.borderWidth),this.options.tipJoint.top?r.top+=this.options.borderWidth:this.options.tipJoint.bottom&&(r.top-=this.options.borderWidth))):r=this.initialMousePosition?{top:this.initialMousePosition.y,left:this.initialMousePosition.x}:{top:mousePosition.y,left:mousePosition.x},this.options.autoOffset&&(a=this.options.stem?this.options.stemLength:0,n=a&&this.options.fixed?2:10,o=t.middle&&!this.options.fixed?15:0,s=t.center&&!this.options.fixed?15:0,t.right?r.left-=n+o:t.left&&(r.left+=n+o),t.bottom?r.top-=n+s:t.top&&(r.top+=n+s),a&&(i==null&&(i=this.options.stem),i.right?r.left-=a:i.left&&(r.left+=a),i.bottom?r.top-=a:i.top&&(r.top+=a))),r.left+=this.options.offset[0],r.top+=this.options.offset[1],t.right?r.left-=this.dimensions.width:t.center&&(r.left-=Math.round(this.dimensions.width/2)),t.bottom?r.top-=this.dimensions.height:t.middle&&(r.top-=Math.round(this.dimensions.height/2)),r},t.prototype._ensureViewportContainment=function(e){var i,o,s,n,r,a,h,p,d,l,u,c;if(h=this.options.stem,s={position:e,stem:h},!this.visible||!e)return s;if(p=this._sticksOut(e),!p[0]&&!p[1])return s;if(l=new t.Joint(this.options.tipJoint),this.options.targetJoint&&(d=new t.Joint(this.options.targetJoint)),a=this.adapter.scrollOffset(),u=this.adapter.viewportDimensions(),c=[e.left-a[0],e.top-a[1]],i=!1,u.width>=this.dimensions.width&&p[0])switch(i=!0,p[0]){case this.STICKS_OUT_LEFT:l.setHorizontal("left"),this.options.targetJoint&&d.setHorizontal("right");break;case this.STICKS_OUT_RIGHT:l.setHorizontal("right"),this.options.targetJoint&&d.setHorizontal("left")}if(u.height>=this.dimensions.height&&p[1])switch(i=!0,p[1]){case this.STICKS_OUT_TOP:l.setVertical("top"),this.options.targetJoint&&d.setVertical("bottom");break;case this.STICKS_OUT_BOTTOM:l.setVertical("bottom"),this.options.targetJoint&&d.setVertical("top")}return i?(this.options.stem&&(h=l),e=this.getPosition(l,d,h),o=this._sticksOut(e),n=!1,r=!1,o[0]&&o[0]!==p[0]&&(n=!0,l.setHorizontal(this.options.tipJoint.horizontal),this.options.targetJoint&&d.setHorizontal(this.options.targetJoint.horizontal)),o[1]&&o[1]!==p[1]&&(r=!0,l.setVertical(this.options.tipJoint.vertical),this.options.targetJoint&&d.setVertical(this.options.targetJoint.vertical)),n&&r?s:((n||r)&&(this.options.stem&&(h=l),e=this.getPosition(l,d,h)),{position:e,stem:h})):s},t.prototype._sticksOut=function(t){var e,i,o,s;return i=this.adapter.scrollOffset(),s=this.adapter.viewportDimensions(),e=[t.left-i[0],t.top-i[1]],o=[!1,!1],0>e[0]?o[0]=this.STICKS_OUT_LEFT:e[0]+this.dimensions.width>s.width&&(o[0]=this.STICKS_OUT_RIGHT),0>e[1]?o[1]=this.STICKS_OUT_TOP:e[1]+this.dimensions.height>s.height&&(o[1]=this.STICKS_OUT_BOTTOM),o},t.prototype._draw=function(){var e,i,o,s,n,r,a,h,p,d,l,u,c,g,f,m,v,b,w,_=this;if(this.backgroundCanvas&&this.redraw){if(this.debug("Drawing background."),this.redraw=!1,this.currentStem){for(v=["top","right","bottom","left"],f=0,m=v.length;m>f;f++)u=v[f],this.adapter.removeClass(this.container,"stem-"+u);this.adapter.addClass(this.container,"stem-"+this.currentStem.horizontal),this.adapter.addClass(this.container,"stem-"+this.currentStem.vertical)}return r=[0,0],a=[0,0],__indexOf.call(this.options.hideTriggers,"closeButton")>=0&&(n=new t.Joint(((b=this.currentStem)!=null?b+"":void 0)==="top right"?"top left":"top right"),r=[this.options.closeButtonRadius+this.options.closeButtonOffset[0],this.options.closeButtonRadius+this.options.closeButtonOffset[1]],a=[this.options.closeButtonRadius-this.options.closeButtonOffset[0],this.options.closeButtonRadius-this.options.closeButtonOffset[1]]),o=this.adapter.clone(this.dimensions),s=[0,0],this.options.borderWidth&&(o.width+=this.options.borderWidth*2,o.height+=this.options.borderWidth*2,s[0]-=this.options.borderWidth,s[1]-=this.options.borderWidth),this.options.shadow&&(o.width+=this.options.shadowBlur*2,o.width+=Math.max(0,this.options.shadowOffset[0]-this.options.shadowBlur*2),o.height+=this.options.shadowBlur*2,o.height+=Math.max(0,this.options.shadowOffset[1]-this.options.shadowBlur*2),s[0]-=Math.max(0,this.options.shadowBlur-this.options.shadowOffset[0]),s[1]-=Math.max(0,this.options.shadowBlur-this.options.shadowOffset[1])),i={left:0,right:0,top:0,bottom:0},this.currentStem&&(this.currentStem.left?i.left=this.options.stemLength:this.currentStem.right&&(i.right=this.options.stemLength),this.currentStem.top?i.top=this.options.stemLength:this.currentStem.bottom&&(i.bottom=this.options.stemLength)),n&&(n.left?i.left=Math.max(i.left,a[0]):n.right&&(i.right=Math.max(i.right,a[0])),n.top?i.top=Math.max(i.top,a[1]):n.bottom&&(i.bottom=Math.max(i.bottom,a[1]))),o.width+=i.left+i.right,o.height+=i.top+i.bottom,s[0]-=i.left,s[1]-=i.top,this.currentStem&&this.options.borderWidth&&(w=this._getPathStemMeasures(this.options.stemBase,this.options.stemLength,this.options.borderWidth),g=w.stemLength,c=w.stemBase),e=this.adapter.unwrap(this.backgroundCanvas),e.width=o.width,e.height=o.height,this.adapter.css(this.backgroundCanvas,{width:""+e.width+"px",height:""+e.height+"px",left:""+s[0]+"px",top:""+s[1]+"px"}),h=e.getContext("2d"),h.setTransform(1,0,0,1,0,0),h.clearRect(0,0,e.width,e.height),h.beginPath(),h.fillStyle=this._getColor(h,this.dimensions,this.options.background,this.options.backgroundGradientHorizontal),h.lineJoin="miter",h.miterLimit=500,l=this.options.borderWidth/2,this.options.borderWidth?(h.strokeStyle=this.options.borderColor,h.lineWidth=this.options.borderWidth):(g=this.options.stemLength,c=this.options.stemBase),c==null&&(c=0),d=function(t,e,i){return i&&h.moveTo(Math.max(c,_.options.borderRadius,r[0])+1-l,-l),e?(h.lineTo(t/2-c/2,-l),h.lineTo(t/2,-g-l),h.lineTo(t/2+c/2,-l)):void 0},p=function(t,e,i){var o,s,n,a;return t?(h.lineTo(-c+l,0-l),h.lineTo(g+l,-g-l),h.lineTo(l,c-l)):e?(a=_.options.closeButtonOffset,n=r[0],i%2!==0&&(a=[a[1],a[0]],n=r[1]),o=Math.acos(a[1]/_.options.closeButtonRadius),s=Math.acos(a[0]/_.options.closeButtonRadius),h.lineTo(-n+l,-l),h.arc(l-a[0],-l+a[1],_.options.closeButtonRadius,-(Math.PI/2+o),s,!1)):(h.lineTo(-_.options.borderRadius+l,-l),h.quadraticCurveTo(l,-l,l,_.options.borderRadius-l))},h.translate(-s[0],-s[1]),h.save(),function(){var e,i,o,s,r,a,l,u,c,g,f;for(f=[],i=c=0,g=t.positions.length/2;g>=0?g>c:c>g;i=g>=0?++c:--c)r=i*2,a=i===0||i===3?0:_.dimensions.width,l=2>i?0:_.dimensions.height,u=Math.PI/2*i,o=i%2===0?_.dimensions.width:_.dimensions.height,s=new t.Joint(t.positions[r]),e=new t.Joint(t.positions[r+1]),h.save(),h.translate(a,l),h.rotate(u),d(o,s.eql(_.currentStem),i===0),h.translate(o,0),p(e.eql(_.currentStem),e.eql(n),i),f.push(h.restore());return f}(),h.closePath(),h.save(),this.options.shadow&&(h.shadowColor=this.options.shadowColor,h.shadowBlur=this.options.shadowBlur,h.shadowOffsetX=this.options.shadowOffset[0],h.shadowOffsetY=this.options.shadowOffset[1]),h.fill(),h.restore(),this.options.borderWidth&&h.stroke(),h.restore(),n?function(){var t,e,i,o,s;return i=e=_.options.closeButtonRadius*2,n+""=="top right"?(s=[_.dimensions.width-_.options.closeButtonOffset[0],_.options.closeButtonOffset[1]],t=[s[0]+l,s[1]-l]):(s=[_.options.closeButtonOffset[0],_.options.closeButtonOffset[1]],t=[s[0]-l,s[1]-l]),h.translate(t[0],t[1]),o=_.options.closeButtonCrossSize/2,h.save(),h.beginPath(),h.strokeStyle=_.options.closeButtonCrossColor,h.lineWidth=_.options.closeButtonCrossLineWidth,h.lineCap="round",h.moveTo(-o,-o),h.lineTo(o,o),h.stroke(),h.beginPath(),h.moveTo(o,-o),h.lineTo(-o,o),h.stroke(),h.restore(),_.adapter.css(_.closeButtonElement,{left:""+(s[0]-o-_.options.closeButtonLinkOverscan)+"px",top:""+(s[1]-o-_.options.closeButtonLinkOverscan)+"px",width:""+(_.options.closeButtonCrossSize+_.options.closeButtonLinkOverscan*2)+"px",height:""+(_.options.closeButtonCrossSize+_.options.closeButtonLinkOverscan*2)+"px"})}():void 0}},t.prototype._getPathStemMeasures=function(t,e,i){var o,s,n,r,a,h,p;if(r=i/2,n=Math.atan(t/2/e),o=n*2,a=r/Math.sin(o),s=2*a*Math.cos(n),p=r+e-s,0>p)throw Error("Sorry but your stemLength / stemBase ratio is strange.");return h=Math.tan(n)*p*2,{stemLength:p,stemBase:h}},t.prototype._getColor=function(t,e,i,o){var s,n,r,a,h;if(o==null&&(o=!1),typeof i=="string")return i;for(n=o?t.createLinearGradient(0,0,e.width,0):t.createLinearGradient(0,0,0,e.height),r=a=0,h=i.length;h>a;r=++a)s=i[r],n.addColorStop(s[0],s[1]);return n},t.prototype._searchAndActivateCloseButtons=function(){var t,e,i,o;for(o=this.adapter.findAll(this.container,"."+this["class"].close),e=0,i=o.length;i>e;e++)t=o[e],this.hideTriggers.push({element:this.adapter.wrap(t),event:"click"});return this.currentObservers.showing&&this._setupObservers("-showing","showing"),this.currentObservers.visible?this._setupObservers("-visible","visible"):void 0},t.prototype._activateFirstInput=function(){var t;return t=this.adapter.unwrap(this.adapter.find(this.container,"input, textarea")),t!=null?typeof t.focus=="function"?t.focus():void 0:void 0},t.prototype._followMousePosition=function(){return this.options.fixed?void 0:t._observeMousePosition(this.bound.reposition)},t.prototype._stopFollowingMousePosition=function(){return this.options.fixed?void 0:t._stopObservingMousePosition(this.bound.reposition)},t.prototype._clearShowTimeout=function(){return clearTimeout(this._showTimeoutId)},t.prototype._clearHideTimeout=function(){return clearTimeout(this._hideTimeoutId)},t.prototype._clearTimeouts=function(){return clearTimeout(this._visibilityStateTimeoutId),this._clearShowTimeout(),this._clearHideTimeout()},t.prototype._triggerElementExists=function(){var t;t=this.adapter.unwrap(this.triggerElement);while(t.parentNode){if(t.parentNode.tagName==="BODY")return!0;t=t.parentNode}return!1},t.prototype._loadAjax=function(){var t=this;if(!this.loading)return this.loaded=!1,this.loading=!0,this.adapter.addClass(this.container,this["class"].loading),this.setContent(""),this.debug("Loading content from "+this.options.ajax),this.adapter.ajax({url:this.options.ajax,method:this.options.ajaxMethod,onSuccess:function(e){return t.debug("Loading successful."),t.adapter.removeClass(t.container,t["class"].loading),t.setContent(e)},onError:function(e){var i;return i=t.options.ajaxErrorMessage,t.debug(i,e),t.setContent(i),t.adapter.addClass(t.container,t["class"].ajaxError)},onComplete:function(){return t.adapter.removeClass(t.container,t["class"].loading),t.loading=!1,t.loaded=!0,t._searchAndActivateCloseButtons(),t._activateFirstInput(),t.reposition()}})},t.prototype._ensureTriggerElement=function(){return this._triggerElementExists()?void 0:(this.deactivate(),this._stopEnsureTriggerElement())},t.prototype._ensureTriggerElementInterval=1e3,t.prototype._startEnsureTriggerElement=function(){var t=this;return this._ensureTriggerElementTimeoutId=setInterval(function(){return t._ensureTriggerElement()},this._ensureTriggerElementInterval)},t.prototype._stopEnsureTriggerElement=function(){return clearInterval(this._ensureTriggerElementTimeoutId)},t}(),vendors=["khtml","ms","o","moz","webkit"],Opentip.prototype.setCss3Style=function(t,e){var i,o,s,n,r;t=this.adapter.unwrap(t),r=[];for(i in e)__hasProp.call(e,i)&&(o=e[i],t.style[i]!=null?r.push(t.style[i]=o):r.push(function(){var e,r,a;for(a=[],e=0,r=vendors.length;r>e;e++)s=vendors[e],n=""+this.ucfirst(s)+this.ucfirst(i),t.style[n]!=null?a.push(t.style[n]=o):a.push(void 0);return a}.call(this)));return r},Opentip.prototype.defer=function(t){return setTimeout(t,0)},Opentip.prototype.setTimeout=function(t,e){return setTimeout(t,e?e*1e3:0)},Opentip.prototype.ucfirst=function(t){return t==null?"":t.charAt(0).toUpperCase()+t.slice(1)},Opentip.prototype.dasherize=function(t){return t.replace(/([A-Z])/g,function(t,e){return"-"+e.toLowerCase()})},mousePositionObservers=[],mousePosition={x:0,y:0},mouseMoved=function(t){var e,i,o,s;for(mousePosition=Opentip.adapter.mousePosition(t),s=[],i=0,o=mousePositionObservers.length;o>i;i++)e=mousePositionObservers[i],s.push(e());return s},Opentip.followMousePosition=function(){return Opentip.adapter.observe(document.body,"mousemove",mouseMoved)},Opentip._observeMousePosition=function(t){return mousePositionObservers.push(t)},Opentip._stopObservingMousePosition=function(t){var e;return mousePositionObservers=function(){var i,o,s;for(s=[],i=0,o=mousePositionObservers.length;o>i;i++)e=mousePositionObservers[i],e!==t&&s.push(e);return s}()},Opentip.Joint=function(){function t(t){t!=null&&(t instanceof Opentip.Joint&&(t+=""),this.set(t))}return t.prototype.set=function(t){return t=t.toLowerCase(),this.setHorizontal(t),this.setVertical(t),this},t.prototype.setHorizontal=function(t){var e,i,o,s,n,r,a;for(i=["left","center","right"],o=0,n=i.length;n>o;o++)e=i[o],~t.indexOf(e)&&(this.horizontal=e.toLowerCase());for(this.horizontal==null&&(this.horizontal="center"),a=[],s=0,r=i.length;r>s;s++)e=i[s],a.push(this[e]=this.horizontal===e?e:void 0);return a},t.prototype.setVertical=function(t){var e,i,o,s,n,r,a;for(i=["top","middle","bottom"],o=0,n=i.length;n>o;o++)e=i[o],~t.indexOf(e)&&(this.vertical=e.toLowerCase());for(this.vertical==null&&(this.vertical="middle"),a=[],s=0,r=i.length;r>s;s++)e=i[s],a.push(this[e]=this.vertical===e?e:void 0);return a},t.prototype.eql=function(t){return t!=null&&this.horizontal===t.horizontal&&this.vertical===t.vertical},t.prototype.flip=function(){var t,e;return e=Opentip.position[this.toString(!0)],t=(e+4)%8,this.set(Opentip.positions[t]),this},t.prototype.toString=function(t){var e,i;return t==null&&(t=!1),i=this.vertical==="middle"?"":this.vertical,e=this.horizontal==="center"?"":this.horizontal,i&&e&&(e=t?Opentip.prototype.ucfirst(e):" "+e),""+i+e},t}(),Opentip.prototype._positionsEqual=function(t,e){return t!=null&&e!=null&&t.left===e.left&&t.top===e.top},Opentip.prototype._dimensionsEqual=function(t,e){return t!=null&&e!=null&&t.width===e.width&&t.height===e.height},Opentip.prototype.debug=function(){var t;return t=arguments.length>=1?__slice.call(arguments,0):[],Opentip.debug&&(typeof console!="undefined"&&console!==null?console.debug:void 0)!=null?(t.unshift("#"+this.id+" |"),console.debug.apply(console,t)):void 0},Opentip.findElements=function(){var t,e,i,o,s,n,r,a,h,p;for(t=Opentip.adapter,h=t.findAll(document.body,"[data-ot]"),p=[],r=0,a=h.length;a>r;r++){i=h[r],n={},e=t.data(i,"ot"),(e===""||e==="true"||e==="yes")&&(e=t.attr(i,"title"),t.attr(i,"title","")),e=e||"";for(o in Opentip.styles.standard)s=t.data(i,"ot"+Opentip.prototype.ucfirst(o)),s!=null&&(s==="yes"||s==="true"||s==="on"?s=!0:(s==="no"||s==="false"||s==="off")&&(s=!1),n[o]=s);p.push(new Opentip(i,e,n))}return p},Opentip.version="2.4.6",Opentip.debug=!1,Opentip.lastId=0,Opentip.lastZIndex=100,Opentip.tips=[],Opentip._abortShowingGroup=function(t,e){var i,o,s,n,r;for(n=Opentip.tips,r=[],o=0,s=n.length;s>o;o++)i=n[o],i!==e&&i.options.group===t?r.push(i._abortShowing()):r.push(void 0);return r},Opentip._hideGroup=function(t,e){var i,o,s,n,r;for(n=Opentip.tips,r=[],o=0,s=n.length;s>o;o++)i=n[o],i!==e&&i.options.group===t?r.push(i.hide()):r.push(void 0);return r},Opentip.adapters={},Opentip.adapter=null,firstAdapter=!0,Opentip.addAdapter=function(t){return Opentip.adapters[t.name]=t,firstAdapter?(Opentip.adapter=t,t.domReady(Opentip.findElements),t.domReady(Opentip.followMousePosition),firstAdapter=!1):void 0},Opentip.positions=["top","topRight","right","bottomRight","bottom","bottomLeft","left","topLeft"],Opentip.position={},_ref=Opentip.positions,i=_i=0,_len=_ref.length;_len>_i;i=++_i)position=_ref[i],Opentip.position[position]=i;Opentip.styles={standard:{"extends":null,title:void 0,escapeTitle:!0,escapeContent:!1,className:"standard",stem:!0,delay:null,hideDelay:.1,fixed:!1,showOn:"mouseover",hideTrigger:"trigger",hideTriggers:[],hideOn:null,removeElementsOnHide:!1,offset:[0,0],containInViewport:!0,autoOffset:!0,showEffect:"appear",hideEffect:"fade",showEffectDuration:.3,hideEffectDuration:.2,stemLength:5,stemBase:8,tipJoint:"top left",target:null,targetJoint:null,cache:!0,ajax:!1,ajaxMethod:"GET",ajaxErrorMessage:"There was a problem downloading the content.",group:null,style:null,background:"#fff18f",backgroundGradientHorizontal:!1,closeButtonOffset:[5,5],closeButtonRadius:7,closeButtonCrossSize:4,closeButtonCrossColor:"#d2c35b",closeButtonCrossLineWidth:1.5,closeButtonLinkOverscan:6,borderRadius:5,borderWidth:1,borderColor:"#f2e37b",shadow:!0,shadowBlur:10,shadowOffset:[3,3],shadowColor:"rgba(0, 0, 0, 0.1)"},glass:{"extends":"standard",className:"glass",background:[[0,"rgba(252, 252, 252, 0.8)"],[.5,"rgba(255, 255, 255, 0.8)"],[.5,"rgba(250, 250, 250, 0.9)"],[1,"rgba(245, 245, 245, 0.9)"]],borderColor:"#eee",closeButtonCrossColor:"rgba(0, 0, 0, 0.2)",borderRadius:15,closeButtonRadius:10,closeButtonOffset:[8,8]},dark:{"extends":"standard",className:"dark",borderRadius:13,borderColor:"#444",closeButtonCrossColor:"rgba(240, 240, 240, 1)",shadowColor:"rgba(0, 0, 0, 0.3)",shadowOffset:[2,2],background:[[0,"rgba(30, 30, 30, 0.7)"],[.5,"rgba(30, 30, 30, 0.8)"],[.5,"rgba(10, 10, 10, 0.8)"],[1,"rgba(10, 10, 10, 0.9)"]]},alert:{"extends":"standard",className:"alert",borderRadius:1,borderColor:"#AE0D11",closeButtonCrossColor:"rgba(255, 255, 255, 1)",shadowColor:"rgba(0, 0, 0, 0.3)",shadowOffset:[2,2],background:[[0,"rgba(203, 15, 19, 0.7)"],[.5,"rgba(203, 15, 19, 0.8)"],[.5,"rgba(189, 14, 18, 0.8)"],[1,"rgba(179, 14, 17, 0.9)"]]}},Opentip.defaultStyle="standard",typeof module!="undefined"&&module!==null?module.exports=Opentip:window.Opentip=Opentip;var __slice=[].slice;(function(t){var e;return t.fn.opentip=function(t,e,i){return new Opentip(this,t,e,i)},e=function(){function e(){}return e.prototype.name="jquery",e.prototype.domReady=function(e){return t(e)},e.prototype.create=function(e){return t(e)},e.prototype.wrap=function(e){if(e=t(e),e.length>1)throw Error("Multiple elements provided.");return e},e.prototype.unwrap=function(e){return t(e)[0]
++},e.prototype.tagName=function(t){return this.unwrap(t).tagName},e.prototype.attr=function(){var e,i,o;return i=arguments[0],e=arguments.length>=2?__slice.call(arguments,1):[],(o=t(i)).attr.apply(o,e)},e.prototype.data=function(){var e,i,o;return i=arguments[0],e=arguments.length>=2?__slice.call(arguments,1):[],(o=t(i)).data.apply(o,e)},e.prototype.find=function(e,i){return t(e).find(i).get(0)},e.prototype.findAll=function(e,i){return t(e).find(i)},e.prototype.update=function(e,i,o){return e=t(e),o?e.text(i):e.html(i)},e.prototype.append=function(e,i){return t(e).append(i)},e.prototype.remove=function(e){return t(e).remove()},e.prototype.addClass=function(e,i){return t(e).addClass(i)},e.prototype.removeClass=function(e,i){return t(e).removeClass(i)},e.prototype.css=function(e,i){return t(e).css(i)},e.prototype.dimensions=function(e){return{width:t(e).outerWidth(),height:t(e).outerHeight()}},e.prototype.scrollOffset=function(){return[window.pageXOffset||document.documentElement.scrollLeft||document.body.scrollLeft,window.pageYOffset||document.documentElement.scrollTop||document.body.scrollTop]},e.prototype.viewportDimensions=function(){return{width:document.documentElement.clientWidth,height:document.documentElement.clientHeight}},e.prototype.mousePosition=function(t){return t==null?null:{x:t.pageX,y:t.pageY}},e.prototype.offset=function(e){var i;return i=t(e).offset(),{left:i.left,top:i.top}},e.prototype.observe=function(e,i,o){return t(e).bind(i,o)},e.prototype.stopObserving=function(e,i,o){return t(e).unbind(i,o)},e.prototype.ajax=function(e){var i,o;if(e.url==null)throw Error("No url provided");return t.ajax({url:e.url,type:(i=(o=e.method)!=null?o.toUpperCase():void 0)!=null?i:"GET"}).done(function(t){return typeof e.onSuccess=="function"?e.onSuccess(t):void 0}).fail(function(t){return typeof e.onError=="function"?e.onError("Server responded with status "+t.status):void 0}).always(function(){return typeof e.onComplete=="function"?e.onComplete():void 0})},e.prototype.clone=function(e){return t.extend({},e)},e.prototype.extend=function(){var e,i;return i=arguments[0],e=arguments.length>=2?__slice.call(arguments,1):[],t.extend.apply(t,[i].concat(__slice.call(e)))},e}(),Opentip.addAdapter(new e)})(jQuery)});
+\ No newline at end of file
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/styles/FLATBOOTS/theme/opentip.css" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/styles/FLATBOOTS/theme/opentip.css"
+new file mode 100644
+index 000000000..5088f37a0
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/styles/FLATBOOTS/theme/opentip.css"
+@@ -0,0 +1,278 @@
++.opentip-container,
++.opentip-container * {
++  -webkit-box-sizing: border-box;
++  -moz-box-sizing: border-box;
++  box-sizing: border-box;
++}
++.opentip-container {
++  position: absolute;
++  max-width: 300px;
++  z-index: 100;
++  -webkit-transition: -webkit-transform 1s ease-in-out;
++  -moz-transition: -moz-transform 1s ease-in-out;
++  -o-transition: -o-transform 1s ease-in-out;
++  -ms-transition: -ms-transform 1s ease-in-out;
++  transition: transform 1s ease-in-out;
++  pointer-events: none;
++  -webkit-transform: translateX(0) translateY(0);
++  -moz-transform: translateX(0) translateY(0);
++  -o-transform: translateX(0) translateY(0);
++  -ms-transform: translateX(0) translateY(0);
++  transform: translateX(0) translateY(0);
++}
++.opentip-container.ot-fixed.ot-hidden.stem-top.stem-center,
++.opentip-container.ot-fixed.ot-going-to-show.stem-top.stem-center,
++.opentip-container.ot-fixed.ot-hiding.stem-top.stem-center {
++  -webkit-transform: translateY(-5px);
++  -moz-transform: translateY(-5px);
++  -o-transform: translateY(-5px);
++  -ms-transform: translateY(-5px);
++  transform: translateY(-5px);
++}
++.opentip-container.ot-fixed.ot-hidden.stem-top.stem-right,
++.opentip-container.ot-fixed.ot-going-to-show.stem-top.stem-right,
++.opentip-container.ot-fixed.ot-hiding.stem-top.stem-right {
++  -webkit-transform: translateY(-5px) translateX(5px);
++  -moz-transform: translateY(-5px) translateX(5px);
++  -o-transform: translateY(-5px) translateX(5px);
++  -ms-transform: translateY(-5px) translateX(5px);
++  transform: translateY(-5px) translateX(5px);
++}
++.opentip-container.ot-fixed.ot-hidden.stem-middle.stem-right,
++.opentip-container.ot-fixed.ot-going-to-show.stem-middle.stem-right,
++.opentip-container.ot-fixed.ot-hiding.stem-middle.stem-right {
++  -webkit-transform: translateX(5px);
++  -moz-transform: translateX(5px);
++  -o-transform: translateX(5px);
++  -ms-transform: translateX(5px);
++  transform: translateX(5px);
++}
++.opentip-container.ot-fixed.ot-hidden.stem-bottom.stem-right,
++.opentip-container.ot-fixed.ot-going-to-show.stem-bottom.stem-right,
++.opentip-container.ot-fixed.ot-hiding.stem-bottom.stem-right {
++  -webkit-transform: translateY(5px) translateX(5px);
++  -moz-transform: translateY(5px) translateX(5px);
++  -o-transform: translateY(5px) translateX(5px);
++  -ms-transform: translateY(5px) translateX(5px);
++  transform: translateY(5px) translateX(5px);
++}
++.opentip-container.ot-fixed.ot-hidden.stem-bottom.stem-center,
++.opentip-container.ot-fixed.ot-going-to-show.stem-bottom.stem-center,
++.opentip-container.ot-fixed.ot-hiding.stem-bottom.stem-center {
++  -webkit-transform: translateY(5px);
++  -moz-transform: translateY(5px);
++  -o-transform: translateY(5px);
++  -ms-transform: translateY(5px);
++  transform: translateY(5px);
++}
++.opentip-container.ot-fixed.ot-hidden.stem-bottom.stem-left,
++.opentip-container.ot-fixed.ot-going-to-show.stem-bottom.stem-left,
++.opentip-container.ot-fixed.ot-hiding.stem-bottom.stem-left {
++  -webkit-transform: translateY(5px) translateX(-5px);
++  -moz-transform: translateY(5px) translateX(-5px);
++  -o-transform: translateY(5px) translateX(-5px);
++  -ms-transform: translateY(5px) translateX(-5px);
++  transform: translateY(5px) translateX(-5px);
++}
++.opentip-container.ot-fixed.ot-hidden.stem-middle.stem-left,
++.opentip-container.ot-fixed.ot-going-to-show.stem-middle.stem-left,
++.opentip-container.ot-fixed.ot-hiding.stem-middle.stem-left {
++  -webkit-transform: translateX(-5px);
++  -moz-transform: translateX(-5px);
++  -o-transform: translateX(-5px);
++  -ms-transform: translateX(-5px);
++  transform: translateX(-5px);
++}
++.opentip-container.ot-fixed.ot-hidden.stem-top.stem-left,
++.opentip-container.ot-fixed.ot-going-to-show.stem-top.stem-left,
++.opentip-container.ot-fixed.ot-hiding.stem-top.stem-left {
++  -webkit-transform: translateY(-5px) translateX(-5px);
++  -moz-transform: translateY(-5px) translateX(-5px);
++  -o-transform: translateY(-5px) translateX(-5px);
++  -ms-transform: translateY(-5px) translateX(-5px);
++  transform: translateY(-5px) translateX(-5px);
++}
++.opentip-container.ot-fixed .opentip {
++  pointer-events: auto;
++}
++.opentip-container.ot-hidden {
++  display: none;
++}
++.opentip-container .opentip {
++  position: relative;
++  font-size: 13px;
++  line-height: 120%;
++  padding: 9px 14px;
++  color: #4f4b47;
++  text-shadow: -1px -1px 0px rgba(255,255,255,0.2);
++}
++.opentip-container .opentip .header {
++  margin: 0;
++  padding: 0;
++}
++.opentip-container .opentip .ot-close {
++  pointer-events: auto;
++  display: block;
++  position: absolute;
++  top: -12px;
++  left: 60px;
++  color: rgba(0,0,0,0.5);
++  background: rgba(0,0,0,0);
++  text-decoration: none;
++}
++.opentip-container .opentip .ot-close span {
++  display: none;
++}
++.opentip-container .opentip .ot-loading-indicator {
++  display: none;
++}
++.opentip-container.ot-loading .ot-loading-indicator {
++  width: 30px;
++  height: 30px;
++  font-size: 30px;
++  line-height: 30px;
++  font-weight: bold;
++  display: block;
++}
++.opentip-container.ot-loading .ot-loading-indicator span {
++  display: block;
++  -webkit-animation: otloading 2s linear infinite;
++  -moz-animation: otloading 2s linear infinite;
++  -o-animation: otloading 2s linear infinite;
++  -ms-animation: otloading 2s linear infinite;
++  animation: otloading 2s linear infinite;
++  text-align: center;
++}
++.opentip-container.style-dark .opentip,
++.opentip-container.style-alert .opentip {
++  color: #f8f8f8;
++  text-shadow: 1px 1px 0px rgba(0,0,0,0.2);
++}
++.opentip-container.style-glass .opentip {
++  padding: 15px 25px;
++  color: #317cc5;
++  text-shadow: 1px 1px 8px rgba(0,94,153,0.3);
++}
++.opentip-container.ot-hide-effect-fade {
++  -webkit-transition: -webkit-transform 0.5s ease-in-out, opacity 1s ease-in-out;
++  -moz-transition: -moz-transform 0.5s ease-in-out, opacity 1s ease-in-out;
++  -o-transition: -o-transform 0.5s ease-in-out, opacity 1s ease-in-out;
++  -ms-transition: -ms-transform 0.5s ease-in-out, opacity 1s ease-in-out;
++  transition: transform 0.5s ease-in-out, opacity 1s ease-in-out;
++  opacity: 1;
++  -ms-filter: none;
++  filter: none;
++}
++.opentip-container.ot-hide-effect-fade.ot-hiding {
++  opacity: 0;
++  filter: alpha(opacity=0);
++  -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";
++}
++.opentip-container.ot-show-effect-appear.ot-going-to-show,
++.opentip-container.ot-show-effect-appear.ot-showing {
++  -webkit-transition: -webkit-transform 0.5s ease-in-out, opacity 1s ease-in-out;
++  -moz-transition: -moz-transform 0.5s ease-in-out, opacity 1s ease-in-out;
++  -o-transition: -o-transform 0.5s ease-in-out, opacity 1s ease-in-out;
++  -ms-transition: -ms-transform 0.5s ease-in-out, opacity 1s ease-in-out;
++  transition: transform 0.5s ease-in-out, opacity 1s ease-in-out;
++}
++.opentip-container.ot-show-effect-appear.ot-going-to-show {
++  opacity: 0;
++  filter: alpha(opacity=0);
++  -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";
++}
++.opentip-container.ot-show-effect-appear.ot-showing {
++  opacity: 1;
++  -ms-filter: none;
++  filter: none;
++}
++.opentip-container.ot-show-effect-appear.ot-visible {
++  opacity: 1;
++  -ms-filter: none;
++  filter: none;
++}
++@-moz-keyframes otloading {
++  0% {
++    -webkit-transform: rotate(0deg);
++    -moz-transform: rotate(0deg);
++    -o-transform: rotate(0deg);
++    -ms-transform: rotate(0deg);
++    transform: rotate(0deg);
++  }
++
++  100% {
++    -webkit-transform: rotate(360deg);
++    -moz-transform: rotate(360deg);
++    -o-transform: rotate(360deg);
++    -ms-transform: rotate(360deg);
++    transform: rotate(360deg);
++  }
++}
++@-webkit-keyframes otloading {
++  0% {
++    -webkit-transform: rotate(0deg);
++    -moz-transform: rotate(0deg);
++    -o-transform: rotate(0deg);
++    -ms-transform: rotate(0deg);
++    transform: rotate(0deg);
++  }
++
++  100% {
++    -webkit-transform: rotate(360deg);
++    -moz-transform: rotate(360deg);
++    -o-transform: rotate(360deg);
++    -ms-transform: rotate(360deg);
++    transform: rotate(360deg);
++  }
++}
++@-o-keyframes otloading {
++  0% {
++    -webkit-transform: rotate(0deg);
++    -moz-transform: rotate(0deg);
++    -o-transform: rotate(0deg);
++    -ms-transform: rotate(0deg);
++    transform: rotate(0deg);
++  }
++
++  100% {
++    -webkit-transform: rotate(360deg);
++    -moz-transform: rotate(360deg);
++    -o-transform: rotate(360deg);
++    -ms-transform: rotate(360deg);
++    transform: rotate(360deg);
++  }
++}
++@-ms-keyframes otloading {
++  0% {
++    -webkit-transform: rotate(0deg);
++    -moz-transform: rotate(0deg);
++    -o-transform: rotate(0deg);
++    -ms-transform: rotate(0deg);
++    transform: rotate(0deg);
++  }
++
++  100% {
++    -webkit-transform: rotate(360deg);
++    -moz-transform: rotate(360deg);
++    -o-transform: rotate(360deg);
++    -ms-transform: rotate(360deg);
++    transform: rotate(360deg);
++  }
++}
++@keyframes otloading {
++  0% {
++    -webkit-transform: rotate(0deg);
++    -moz-transform: rotate(0deg);
++    -o-transform: rotate(0deg);
++    -ms-transform: rotate(0deg);
++    transform: rotate(0deg);
++  }
++
++  100% {
++    -webkit-transform: rotate(360deg);
++    -moz-transform: rotate(360deg);
++    -o-transform: rotate(360deg);
++    -ms-transform: rotate(360deg);
++    transform: rotate(360deg);
++  }
++}
diff --git "[FORUM_EXT]/vse\\topicimagepreview/diff_nospace.tmp" "[FORUM_EXT]/vse\\topicimagepreview/diff_nospace.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/vse\\topicimagepreview/diff_nospace.tmp"
@@ -0,0 +1,4954 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\topicimagepreview/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/composer.json"
+index 6ecce9b81..29c197426 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\topicimagepreview/composer.json"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/composer.json"
+@@ -6,30 +6,33 @@
+     "version": "1.0.1",
+ 	"license": "GPL-2.0-only",
+     "authors": [
++        {
++			"name": "Leinad4Mind",
++			"homepage": "https://leinad4mind.top/forum",
++			"role": "Developer"
++        },
+         {
+ 			"name": "Matt Friedman",
+-            "homepage": "https://imattpro.github.io",
++			"homepage": "https://vsephpbb.github.io",
+ 			"role": "Developer"
+         }
+     ],
+     "require": {
+         "php": ">=5.4",
+-        "composer/installers": "~1.0.0",
+-        "phpbb/phpbb": ">=3.2.1"
++		"composer/installers": "~1.0"
+ 	},
+ 	"require-dev": {
+ 		"phing/phing": "2.4.*"
+ 	},
+     "extra": {
+-        "display-name": "Topic Image Preview",
++        "display-name": "Topic Image Preview - Gallery Edition",
+         "soft-require": {
+             "phpbb/phpbb": ">=3.2.1"
+ 		},
+ 		"version-check": {
+ 			"host": "www.phpbb.com",
+ 			"directory": "/customise/db/extension/topic_image_preview",
+-            "filename": "version_check",
+-            "ssl": true
++			"filename": "version_check"
+         }
+     }
+ }
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/diff_full.tmp"
+new file mode 100644
+index 000000000..bb162d8b9
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/diff_full.tmp"
+@@ -0,0 +1,4942 @@
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\topicimagepreview/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/composer.json"
++index 6ecce9b81..29c197426 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\topicimagepreview/composer.json"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/composer.json"
++@@ -4,32 +4,35 @@
++     "description": "Display thumbnail previews of images in a topic when hovering the mouse over the topic.",
++     "homepage": "https://github.com/iMattPro/TopicImagePreview",
++     "version": "1.0.1",
++-    "license": "GPL-2.0-only",
+++	"license": "GPL-2.0-only",
++     "authors": [
++         {
++-            "name": "Matt Friedman",
++-            "homepage": "https://imattpro.github.io",
++-            "role": "Developer"
+++			"name": "Leinad4Mind",
+++			"homepage": "https://leinad4mind.top/forum",
+++			"role": "Developer"
+++        },
+++        {
+++			"name": "Matt Friedman",
+++			"homepage": "https://vsephpbb.github.io",
+++			"role": "Developer"
++         }
++     ],
++     "require": {
++         "php": ">=5.4",
++-        "composer/installers": "~1.0.0",
++-        "phpbb/phpbb": ">=3.2.1"
++-    },
++-    "require-dev": {
++-        "phing/phing": "2.4.*"
++-    },
+++		"composer/installers": "~1.0"
+++	},
+++	"require-dev": {
+++		"phing/phing": "2.4.*"
+++	},
++     "extra": {
++-        "display-name": "Topic Image Preview",
+++        "display-name": "Topic Image Preview - Gallery Edition",
++         "soft-require": {
++             "phpbb/phpbb": ">=3.2.1"
++-        },
++-        "version-check": {
++-            "host": "www.phpbb.com",
++-            "directory": "/customise/db/extension/topic_image_preview",
++-            "filename": "version_check",
++-            "ssl": true
+++		},
+++		"version-check": {
+++			"host": "www.phpbb.com",
+++			"directory": "/customise/db/extension/topic_image_preview",
+++			"filename": "version_check"
++         }
++     }
++-}
++\ No newline at end of file
+++}
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/diff_full.tmp"
++new file mode 100644
++index 000000000..e69de29bb
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\topicimagepreview/event/helper.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/event/helper.php"
++index b676e4583..1b5063e5f 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\topicimagepreview/event/helper.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/event/helper.php"
++@@ -73,7 +73,7 @@ class helper
++ 		if (!$this->user_allowed())
++ 		{
++ 			return;
++-		}
+++		} 
++ 
++ 		// Use topic_list from event, otherwise create one based on the rowset
++ 		$topic_list = $event->offsetExists('topic_list') ? $event['topic_list'] : array_keys($event['rowset']);
++@@ -100,14 +100,16 @@ class helper
++ 
++ 		// Send the image string to the template
++ 		$block = $event->offsetExists('topic_row') ? 'topic_row' : 'tpl_ary';
++-		$event[$block] = array_merge($event[$block], ['TOPIC_IMAGES' => $this->extract_images($event['row']['post_text'])]);
+++		$event[$block] = array_merge($event[$block], ['TOPIC_IMAGES' => $this->extract_images($event['row']['post_text']), 'TOPIC_IMAGES_SIZE_MIN' => (int) $this->config['vse_tip_dim_min'], 'TOPIC_IMAGES_SIZE_MAX' => (int) $this->config['vse_tip_dim_max']]);
+++		
+++		
++ 
++ 		$this->preview = true;
++ 	}
++ 
++ 	/**
++ 	 * Run an SQL query on a group of topics, and find the newest (or oldest)
++-	 * post with [IMG] images. Then update the topic's row set array to include
+++	 * post with [ALBUM] images. Then update the topic's row set array to include
++ 	 * the post's text in the cases where images were found.
++ 	 *
++ 	 * @param array $topic_list An array of topic ids
++@@ -120,22 +122,26 @@ class helper
++ 	{
++ 		$sql_array = [];
++ 		$direction = $this->config->offsetGet('vse_tip_new') ? 'DESC' : 'ASC';
++-		$like_expression = $this->db->sql_like_expression('<r>' . $this->db->get_any_char() . '<IMG ' . $this->db->get_any_char());
+++		$like_expression = $this->db->sql_like_expression('<r>' . $this->db->get_any_char() . '<ALBUM ' . $this->db->get_any_char());
++ 		$is_sqlite3 = $this->db->get_sql_layer() === 'sqlite3';
++ 		$is_mssql = strpos($this->db->get_sql_layer(), 'mssql') === 0;
+++		
+++
++ 		foreach ($topic_list as $topic_id)
++ 		{
++-			if (!$this->forum_allowed($rowset[$topic_id]['forum_id']))
+++			if (!isset($rowset[$topic_id]) || !$this->forum_allowed($rowset[$topic_id]['forum_id']))
++ 			{
++ 				continue;
++ 			}
++ 
+++			$first_post_id = (int) $rowset[$topic_id]['topic_first_post_id'];
+++
++ 			$stmt = '(SELECT ' . ($is_mssql ? 'TOP 1 ' : '') . 'topic_id, post_text
++ 				FROM ' . POSTS_TABLE . '
++-				WHERE topic_id = ' . (int) $topic_id . '
++-					AND post_visibility = ' . ITEM_APPROVED . '
++-					AND post_text ' . $like_expression . '
++-				ORDER BY post_time ' . $direction . ($is_mssql ? '' : ' LIMIT 1') . ')';
+++				WHERE post_text ' . $like_expression . '
+++					AND topic_id = ' . (int) $topic_id . '
+++					AND post_id = ' . $first_post_id . ')';
+++				// ORDER BY post_time ' . $direction . ($is_mssql ? '' : ' LIMIT 1') . ')';
++ 
++ 			// SQLite3 and mssql don't like ORDER BY with UNION ALL, so treat $stmt as derived table
++ 			if ($is_sqlite3 || $is_mssql)
++@@ -174,14 +180,14 @@ class helper
++ 		$dom = new \DOMDocument;
++ 		$dom->loadXML($post);
++ 		$xpath = new \DOMXPath($dom);
++-		foreach ($xpath->query('//IMG[not(ancestor::IMG)]/@src') as $image)
+++		foreach ($xpath->query('//ALBUM[not(ancestor::ALBUM)]/@content') as $image)
++ 		{
++ 			$images[] = $image->textContent;
++ 		}
++ 
++-		return array_slice($images, 0, (int) $this->config['vse_tip_num'], true);
+++		// Create a string of images
+++		return array_slice($images, 0, (int) $this->config['vse_tip_dim_min'], true);
++ 	}
++-
++ 	/**
++ 	 * Is the forum allowed to show topic image previews
++ 	 *
++@@ -202,4 +208,4 @@ class helper
++ 	{
++ 		return (bool) $this->user->data['user_vse_tip'];
++ 	}
++-}
+++}
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\topicimagepreview/event/preview.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/event/preview.php"
++index 261da4657..a26c30b84 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\topicimagepreview/event/preview.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/event/preview.php"
++@@ -23,7 +23,7 @@ class preview implements EventSubscriberInterface
++ 	protected $config;
++ 
++ 	/** @var helper */
++-	protected $helper;
+++	public $helper;
++ 
++ 	/** @var template */
++ 	protected $template;
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\topicimagepreview/event/settings.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/event/settings.php"
++index 43d35bc60..1da26d96a 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\topicimagepreview/event/settings.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/event/settings.php"
++@@ -102,7 +102,8 @@ class settings implements EventSubscriberInterface
++ 				'legend_vse_tip'	=> 'ACP_TIP_TITLE',
++ 				'vse_tip_new'		=> ['lang' => 'ACP_TIP_DISPLAY_AGE', 'validate' => 'bool', 'type' => 'custom', 'function' => [$this, 'select_vse_tip_new'], 'explain' => true],
++ 				'vse_tip_num'		=> ['lang' => 'ACP_TIP_DISPLAY_NUM', 'validate' => 'int:0:99', 'type' => 'number:0:99', 'explain' => true],
++-				'vse_tip_dim'		=> ['lang' => 'ACP_TIP_DISPLAY_DIM', 'validate' => 'int:0:999', 'type' => 'number:0:999', 'explain' => true, 'append' => ' ' . $this->language->lang('PIXEL')],
+++				'vse_tip_dim_min'	=> ['lang' => 'ACP_TIP_DISPLAY_DIM_MIN', 'validate' => 'int:0:999', 'type' => 'number:0:999', 'explain' => true, 'append' => ' ' . $this->language->lang('PIXEL')],
+++				'vse_tip_dim_max'	=> ['lang' => 'ACP_TIP_DISPLAY_DIM_MAX', 'validate' => 'int:0:999', 'type' => 'number:0:999', 'explain' => true, 'append' => ' ' . $this->language->lang('PIXEL')],
++ 				'vse_tip_srt'		=> ['lang' => 'ACP_TIP_DISPLAY_SRT', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => false],
++ 			];
++ 
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\topicimagepreview/language/en/tip_acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/language/en/tip_acp.php"
++index 62490107b..5759ad007 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\topicimagepreview/language/en/tip_acp.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/language/en/tip_acp.php"
++@@ -26,7 +26,8 @@ $lang = array_merge($lang, [
++ 	'ACP_TIP_OLDEST_POST'			=> 'Oldest post',
++ 	'ACP_TIP_DISPLAY_NUM'			=> 'Number of images to display',
++ 	'ACP_TIP_DISPLAY_NUM_EXPLAIN'	=> 'Maximum number of images to display in previews. Set to 0 to disable previews.',
++-	'ACP_TIP_DISPLAY_DIM'			=> 'Maximum image size per preview',
+++	'ACP_TIP_DISPLAY_DIM_MIN'		=> 'Maximum image size for the small image preview',
+++	'ACP_TIP_DISPLAY_DIM_MAX'		=> 'Maximum image size for the big popup image preview',
++ 	'ACP_TIP_DISPLAY_DIM_EXPLAIN'	=> 'Maximum width/height of each image in the preview.',
++ 	'ACP_TIP_DISPLAY_SRT'			=> 'Display in search results topics',
++ 	'ACP_TIP_DISPLAY_PST'			=> 'Display in similar topics',
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\topicimagepreview/language/en/tip_ucp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/language/en/tip_ucp.php"
++index e3919d6ba..f610ddd98 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\topicimagepreview/language/en/tip_ucp.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/language/en/tip_ucp.php"
++@@ -1,38 +1,36 @@
++-<?php
++-/**
++- *
++- * Topic Image Preview. An extension for the phpBB Forum Software package.
++- *
++- * @copyright (c) 2019, Matt Friedman
++- * @license GNU General Public License, version 2 (GPL-2.0)
++- *
++- */
+++opentip<?php
+++			/**
+++			 *
+++			 * Topic Image Preview. An extension for the phpBB Forum Software package.
+++			 *
+++			 * @copyright (c) 2019, Matt Friedman
+++			 * @license GNU General Public License, version 2 (GPL-2.0)
+++			 *
+++			 */
++ 
++-/**
++- * DO NOT CHANGE
++- */
++-if (!defined('IN_PHPBB'))
++-{
++-	exit;
++-}
+++			/**
+++			 * DO NOT CHANGE
+++			 */
+++			if (!defined('IN_PHPBB')) {
+++				exit;
+++			}
++ 
++-if (empty($lang) || !is_array($lang))
++-{
++-	$lang = [];
++-}
+++			if (empty($lang) || !is_array($lang)) {
+++				$lang = [];
+++			}
++ 
++-// DEVELOPERS PLEASE NOTE
++-//
++-// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
++-//
++-// Placeholders can now contain order information, e.g. instead of
++-// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
++-// translators to re-order the output of data while ensuring it remains correct
++-//
++-// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
++-// equally where a string contains only two placeholders which are used to wrap text
++-// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
+++			// DEVELOPERS PLEASE NOTE
+++			//
+++			// All language files should use UTF-8 as their encoding and the files must not contain a BOM.
+++			//
+++			// Placeholders can now contain order information, e.g. instead of
+++			// 'Page %s of %s' you can (and should) write 'Page %1$s of %2$s', this allows
+++			// translators to re-order the output of data while ensuring it remains correct
+++			//
+++			// You do not need this where single placeholders are used, e.g. 'Message %d' is fine
+++			// equally where a string contains only two placeholders which are used to wrap text
+++			// in a url you again do not need to specify an order e.g., 'Click %sHERE%s' is fine
++ 
++-$lang = array_merge($lang, [
++-	'DISPLAY_TOPIC_IMAGE_PREVIEWS'	=> 'Display topic image previews',
++-]);
+++			$lang = array_merge($lang, [
+++				'DISPLAY_TOPIC_IMAGE_PREVIEWS'	=> 'Display topic image previews',
+++			]);
++\ No newline at end of file
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/language/pt/permissions_tip.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/language/pt/permissions_tip.php"
++new file mode 100644
++index 000000000..0c544a024
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/language/pt/permissions_tip.php"
++@@ -0,0 +1,26 @@
+++<?php
+++/**
+++ *
+++ * Topic Image Preview. An extension for the phpBB Forum Software package.
+++ *
+++ * @copyright (c) 2020, Matt Friedman
+++ * @license GNU General Public License, version 2 (GPL-2.0)
+++ *
+++ */
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
+++	$lang = array();
+++}
+++
+++$lang = array_merge($lang, array(
+++	'ACL_F_VSE_TIP'	=> 'Can see topic image previews',
+++));
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/language/pt/tip_acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/language/pt/tip_acp.php"
++new file mode 100644
++index 000000000..f0fe5478c
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/language/pt/tip_acp.php"
++@@ -0,0 +1,34 @@
+++<?php
+++/**
+++ *
+++ * Topic Image Preview. An extension for the phpBB Forum Software package.
+++ *
+++ * @copyright (c) 2017, Matt Friedman
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
+++$lang = array_merge($lang, [
+++	'ACP_TIP_TITLE'					=> 'Topic Image Preview',
+++	'ACP_TIP_DISPLAY_AGE'			=> 'Display images from',
+++	'ACP_TIP_DISPLAY_AGE_EXPLAIN'	=> 'Select Newest post to display the most recent images posted. Otherwise, select Oldest post to display the oldest images posted.',
+++	'ACP_TIP_NEWEST_POST'			=> 'Newest post',
+++	'ACP_TIP_OLDEST_POST'			=> 'Oldest post',
+++	'ACP_TIP_DISPLAY_NUM'			=> 'Number of images to display',
+++	'ACP_TIP_DISPLAY_NUM_EXPLAIN'	=> 'Maximum number of images to display in previews. Set to 0 to disable previews.',
+++	'ACP_TIP_DISPLAY_DIM_MIN'		=> 'Maximum image size for the small image preview',
+++	'ACP_TIP_DISPLAY_DIM_MAX'		=> 'Maximum image size for the big popup image preview',
+++	'ACP_TIP_DISPLAY_DIM_EXPLAIN'	=> 'Maximum width/height of each image in the preview.',
+++	'ACP_TIP_DISPLAY_SRT'			=> 'Display in search results topics',
+++	'ACP_TIP_DISPLAY_PST'			=> 'Display in similar topics',
+++]);
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/language/pt/tip_install.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/language/pt/tip_install.php"
++new file mode 100644
++index 000000000..4f9c40242
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/language/pt/tip_install.php"
++@@ -0,0 +1,34 @@
+++<?php
+++/**
+++ *
+++ * Topic Image Preview. An extension for the phpBB Forum Software package.
+++ *
+++ * @copyright (c) 2017, Matt Friedman
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
+++$lang = array_merge($lang, [
+++	'TIP_INSTALL_ERROR'	=> 'phpBB %s or newer is required.',
+++]);
+++
+++// TRANSLATORS CAN IGNORE THIS.
+++// Overwrite core error message keys with a more specific message.
+++$lang = array_merge($lang, [
+++	'EXTENSION_NOT_ENABLEABLE'		=> isset($lang['EXTENSION_NOT_ENABLEABLE']) ?
+++		$lang['EXTENSION_NOT_ENABLEABLE'] . '<br />' . sprintf($lang['TIP_INSTALL_ERROR'], \vse\topicimagepreview\ext::PHPBB_MIN_VERSION) :
+++		null,
+++	'CLI_EXTENSION_ENABLE_FAILURE'	=> isset($lang['CLI_EXTENSION_ENABLE_FAILURE']) ?
+++		$lang['CLI_EXTENSION_ENABLE_FAILURE'] . '. ' . sprintf($lang['TIP_INSTALL_ERROR'], \vse\topicimagepreview\ext::PHPBB_MIN_VERSION) :
+++		null,
+++]);
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/language/pt/tip_ucp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/language/pt/tip_ucp.php"
++new file mode 100644
++index 000000000..32c61dee9
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/language/pt/tip_ucp.php"
++@@ -0,0 +1,38 @@
+++<?php
+++/**
+++ *
+++ * Topic Image Preview. An extension for the phpBB Forum Software package.
+++ *
+++ * @copyright (c) 2019, Matt Friedman
+++ * @license GNU General Public License, version 2 (GPL-2.0)
+++ *
+++ */
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
+++
+++$lang = array_merge($lang, [
+++	'DISPLAY_TOPIC_IMAGE_PREVIEWS'	=> 'Mostrar imagens de tópicos',
+++]);
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/language/pt_preao/permissions_tip.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/language/pt_preao/permissions_tip.php"
++new file mode 100644
++index 000000000..0c544a024
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/language/pt_preao/permissions_tip.php"
++@@ -0,0 +1,26 @@
+++<?php
+++/**
+++ *
+++ * Topic Image Preview. An extension for the phpBB Forum Software package.
+++ *
+++ * @copyright (c) 2020, Matt Friedman
+++ * @license GNU General Public License, version 2 (GPL-2.0)
+++ *
+++ */
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
+++	$lang = array();
+++}
+++
+++$lang = array_merge($lang, array(
+++	'ACL_F_VSE_TIP'	=> 'Can see topic image previews',
+++));
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/language/pt_preao/tip_acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/language/pt_preao/tip_acp.php"
++new file mode 100644
++index 000000000..f0fe5478c
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/language/pt_preao/tip_acp.php"
++@@ -0,0 +1,34 @@
+++<?php
+++/**
+++ *
+++ * Topic Image Preview. An extension for the phpBB Forum Software package.
+++ *
+++ * @copyright (c) 2017, Matt Friedman
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
+++$lang = array_merge($lang, [
+++	'ACP_TIP_TITLE'					=> 'Topic Image Preview',
+++	'ACP_TIP_DISPLAY_AGE'			=> 'Display images from',
+++	'ACP_TIP_DISPLAY_AGE_EXPLAIN'	=> 'Select Newest post to display the most recent images posted. Otherwise, select Oldest post to display the oldest images posted.',
+++	'ACP_TIP_NEWEST_POST'			=> 'Newest post',
+++	'ACP_TIP_OLDEST_POST'			=> 'Oldest post',
+++	'ACP_TIP_DISPLAY_NUM'			=> 'Number of images to display',
+++	'ACP_TIP_DISPLAY_NUM_EXPLAIN'	=> 'Maximum number of images to display in previews. Set to 0 to disable previews.',
+++	'ACP_TIP_DISPLAY_DIM_MIN'		=> 'Maximum image size for the small image preview',
+++	'ACP_TIP_DISPLAY_DIM_MAX'		=> 'Maximum image size for the big popup image preview',
+++	'ACP_TIP_DISPLAY_DIM_EXPLAIN'	=> 'Maximum width/height of each image in the preview.',
+++	'ACP_TIP_DISPLAY_SRT'			=> 'Display in search results topics',
+++	'ACP_TIP_DISPLAY_PST'			=> 'Display in similar topics',
+++]);
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/language/pt_preao/tip_install.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/language/pt_preao/tip_install.php"
++new file mode 100644
++index 000000000..4f9c40242
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/language/pt_preao/tip_install.php"
++@@ -0,0 +1,34 @@
+++<?php
+++/**
+++ *
+++ * Topic Image Preview. An extension for the phpBB Forum Software package.
+++ *
+++ * @copyright (c) 2017, Matt Friedman
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
+++$lang = array_merge($lang, [
+++	'TIP_INSTALL_ERROR'	=> 'phpBB %s or newer is required.',
+++]);
+++
+++// TRANSLATORS CAN IGNORE THIS.
+++// Overwrite core error message keys with a more specific message.
+++$lang = array_merge($lang, [
+++	'EXTENSION_NOT_ENABLEABLE'		=> isset($lang['EXTENSION_NOT_ENABLEABLE']) ?
+++		$lang['EXTENSION_NOT_ENABLEABLE'] . '<br />' . sprintf($lang['TIP_INSTALL_ERROR'], \vse\topicimagepreview\ext::PHPBB_MIN_VERSION) :
+++		null,
+++	'CLI_EXTENSION_ENABLE_FAILURE'	=> isset($lang['CLI_EXTENSION_ENABLE_FAILURE']) ?
+++		$lang['CLI_EXTENSION_ENABLE_FAILURE'] . '. ' . sprintf($lang['TIP_INSTALL_ERROR'], \vse\topicimagepreview\ext::PHPBB_MIN_VERSION) :
+++		null,
+++]);
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/language/pt_preao/tip_ucp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/language/pt_preao/tip_ucp.php"
++new file mode 100644
++index 000000000..32c61dee9
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/language/pt_preao/tip_ucp.php"
++@@ -0,0 +1,38 @@
+++<?php
+++/**
+++ *
+++ * Topic Image Preview. An extension for the phpBB Forum Software package.
+++ *
+++ * @copyright (c) 2019, Matt Friedman
+++ * @license GNU General Public License, version 2 (GPL-2.0)
+++ *
+++ */
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
+++
+++$lang = array_merge($lang, [
+++	'DISPLAY_TOPIC_IMAGE_PREVIEWS'	=> 'Mostrar imagens de tópicos',
+++]);
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\topicimagepreview/migrations/install_tip.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/migrations/install_tip.php"
++index 3fb2fe1b6..d89bc64a5 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\vse\\topicimagepreview/migrations/install_tip.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/migrations/install_tip.php"
++@@ -27,7 +27,8 @@ class install_tip extends \phpbb\db\migration\migration
++ 		return [
++ 			['config.add', ['vse_tip_new', 1]],
++ 			['config.add', ['vse_tip_num', 3]],
++-			['config.add', ['vse_tip_dim', 200]],
+++			['config.add', ['vse_tip_dim_min', 200]],
+++			['config.add', ['vse_tip_dim_max', 500]],
++ 		];
++ 	}
++ }
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/styles/BBOOTS/template/event/overall_footer_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/styles/BBOOTS/template/event/overall_footer_after.html"
++new file mode 100644
++index 000000000..a89927961
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/styles/BBOOTS/template/event/overall_footer_after.html"
++@@ -0,0 +1,9 @@
+++{% INCLUDEJS '@vse_topicimagepreview/js/opentip-jquery.min.js' %}
+++
+++<script>
+++head.ready(function () {
+++	$(function() {
+++		$("[data-ot]").closest("dt").removeAttr("title");
+++	});
+++});
+++</script>
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/styles/BBOOTS/template/event/overall_header_stylesheets_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/styles/BBOOTS/template/event/overall_header_stylesheets_after.html"
++new file mode 100644
++index 000000000..681ce299b
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/styles/BBOOTS/template/event/overall_header_stylesheets_after.html"
++@@ -0,0 +1,5 @@
+++{% INCLUDECSS '@vse_topicimagepreview/opentip.css' %}
+++
+++<style>
+++	.opentip-container { max-width: 1000px; white-space: nowrap; }
+++</style>
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/styles/BBOOTS/template/event/topiclist_row_prepend.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/styles/BBOOTS/template/event/topiclist_row_prepend.html"
++new file mode 100644
++index 000000000..e19516eed
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/styles/BBOOTS/template/event/topiclist_row_prepend.html"
++@@ -0,0 +1,18 @@
+++{# display in view forum #}
+++{% if topicrow.TOPIC_IMAGES %}
+++	{% set preview = topicrow %}
+++{% endif %}
+++
+++{# display in search results #}
+++{% if searchresults.TOPIC_IMAGES %}
+++	{% set preview = searchresults %}
+++{% endif %}
+++
+++{# display in Similar Topics extension #}
+++{% if similar.TOPIC_IMAGES %}
+++	{% set preview = similar %}
+++{% endif %}
+++
+++<span{% if preview.TOPIC_IMAGES_BIG %} data-ot="{{ preview.TOPIC_IMAGES_BIG }}" data-ot-group="topics" data-ot-background="transparent" data-ot-border-width="0" data-ot-border-radius="0"{% endif %}>
+++{% if preview.TOPIC_IMAGES %}<div style="float:left;padding-right:10px;">{{ preview.TOPIC_IMAGES }}</div>{% endif %}
+++</span>
++\ No newline at end of file
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/styles/BBOOTS/template/event/ucp_prefs_view_radio_buttons_append.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/styles/BBOOTS/template/event/ucp_prefs_view_radio_buttons_append.html"
++new file mode 100644
++index 000000000..9d7eab75d
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/styles/BBOOTS/template/event/ucp_prefs_view_radio_buttons_append.html"
++@@ -0,0 +1,9 @@
+++{% if S_VSE_TIP_NUM %}
+++	<dl>
+++		<dt><label for="user_vse_tip1">{{ lang('DISPLAY_TOPIC_IMAGE_PREVIEWS') ~ lang('COLON') }}</label></dt>
+++		<dd>
+++			<label for="user_vse_tip1"><input type="radio" name="user_vse_tip" id="user_vse_tip1" value="1"{% if S_VSE_TIP_USER %} checked="checked"{% endif %} /> {{ lang('YES') }}</label>
+++			<label for="user_vse_tip0"><input type="radio" name="user_vse_tip" id="user_vse_tip0" value="0"{% if not S_VSE_TIP_USER %} checked="checked"{% endif %} /> {{ lang('NO') }}</label>
+++		</dd>
+++	</dl>
+++{% endif %}
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/styles/BBOOTS/template/js/opentip-jquery.js" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/styles/BBOOTS/template/js/opentip-jquery.js"
++new file mode 100644
++index 000000000..ddfb9a8d9
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/styles/BBOOTS/template/js/opentip-jquery.js"
++@@ -0,0 +1,1794 @@
+++// Generated by CoffeeScript 1.4.0
+++/*
+++#
+++# Opentip v2.4.6
+++#
+++# More info at [www.opentip.org](http://www.opentip.org)
+++# 
+++# Copyright (c) 2012, Matias Meno  
+++# Graphics by Tjandra Mayerhold
+++# 
+++# Permission is hereby granted, free of charge, to any person obtaining a copy
+++# of this software and associated documentation files (the "Software"), to deal
+++# in the Software without restriction, including without limitation the rights
+++# to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
+++# copies of the Software, and to permit persons to whom the Software is
+++# furnished to do so, subject to the following conditions:
+++# 
+++# The above copyright notice and this permission notice shall be included in
+++# all copies or substantial portions of the Software.
+++# 
+++# THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
+++# IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
+++# FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
+++# AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
+++# LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
+++# OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
+++# THE SOFTWARE.
+++#
+++*/
+++head.ready(function () {
+++var Opentip, firstAdapter, i, mouseMoved, mousePosition, mousePositionObservers, position, vendors, _i, _len, _ref,
+++  __slice = [].slice,
+++  __indexOf = [].indexOf || function(item) { for (var i = 0, l = this.length; i < l; i++) { if (i in this && this[i] === item) return i; } return -1; },
+++  __hasProp = {}.hasOwnProperty;
+++
+++Opentip = (function() {
+++
+++  Opentip.prototype.STICKS_OUT_TOP = 1;
+++
+++  Opentip.prototype.STICKS_OUT_BOTTOM = 2;
+++
+++  Opentip.prototype.STICKS_OUT_LEFT = 1;
+++
+++  Opentip.prototype.STICKS_OUT_RIGHT = 2;
+++
+++  Opentip.prototype["class"] = {
+++    container: "opentip-container",
+++    opentip: "opentip",
+++    header: "ot-header",
+++    content: "ot-content",
+++    loadingIndicator: "ot-loading-indicator",
+++    close: "ot-close",
+++    goingToHide: "ot-going-to-hide",
+++    hidden: "ot-hidden",
+++    hiding: "ot-hiding",
+++    goingToShow: "ot-going-to-show",
+++    showing: "ot-showing",
+++    visible: "ot-visible",
+++    loading: "ot-loading",
+++    ajaxError: "ot-ajax-error",
+++    fixed: "ot-fixed",
+++    showEffectPrefix: "ot-show-effect-",
+++    hideEffectPrefix: "ot-hide-effect-",
+++    stylePrefix: "style-"
+++  };
+++
+++  function Opentip(element, content, title, options) {
+++    var elementsOpentips, hideTrigger, methodToBind, optionSources, prop, styleName, _i, _j, _len, _len1, _ref, _ref1, _ref2, _tmpStyle,
+++      _this = this;
+++    this.id = ++Opentip.lastId;
+++    this.debug("Creating Opentip.");
+++    Opentip.tips.push(this);
+++    this.adapter = Opentip.adapter;
+++    elementsOpentips = this.adapter.data(element, "opentips") || [];
+++    elementsOpentips.push(this);
+++    this.adapter.data(element, "opentips", elementsOpentips);
+++    this.triggerElement = this.adapter.wrap(element);
+++    if (this.triggerElement.length > 1) {
+++      throw new Error("You can't call Opentip on multiple elements.");
+++    }
+++    if (this.triggerElement.length < 1) {
+++      throw new Error("Invalid element.");
+++    }
+++    this.loaded = false;
+++    this.loading = false;
+++    this.visible = false;
+++    this.waitingToShow = false;
+++    this.waitingToHide = false;
+++    this.currentPosition = {
+++      left: 0,
+++      top: 0
+++    };
+++    this.dimensions = {
+++      width: 100,
+++      height: 50
+++    };
+++    this.content = "";
+++    this.redraw = true;
+++    this.currentObservers = {
+++      showing: false,
+++      visible: false,
+++      hiding: false,
+++      hidden: false
+++    };
+++    options = this.adapter.clone(options);
+++    if (typeof content === "object") {
+++      options = content;
+++      content = title = void 0;
+++    } else if (typeof title === "object") {
+++      options = title;
+++      title = void 0;
+++    }
+++    if (title != null) {
+++      options.title = title;
+++    }
+++    if (content != null) {
+++      this.setContent(content);
+++    }
+++    if (options["extends"] == null) {
+++      if (options.style != null) {
+++        options["extends"] = options.style;
+++      } else {
+++        options["extends"] = Opentip.defaultStyle;
+++      }
+++    }
+++    optionSources = [options];
+++    _tmpStyle = options;
+++    while (_tmpStyle["extends"]) {
+++      styleName = _tmpStyle["extends"];
+++      _tmpStyle = Opentip.styles[styleName];
+++      if (_tmpStyle == null) {
+++        throw new Error("Invalid style: " + styleName);
+++      }
+++      optionSources.unshift(_tmpStyle);
+++      if (!((_tmpStyle["extends"] != null) || styleName === "standard")) {
+++        _tmpStyle["extends"] = "standard";
+++      }
+++    }
+++    options = (_ref = this.adapter).extend.apply(_ref, [{}].concat(__slice.call(optionSources)));
+++    options.hideTriggers = (function() {
+++      var _i, _len, _ref1, _results;
+++      _ref1 = options.hideTriggers;
+++      _results = [];
+++      for (_i = 0, _len = _ref1.length; _i < _len; _i++) {
+++        hideTrigger = _ref1[_i];
+++        _results.push(hideTrigger);
+++      }
+++      return _results;
+++    })();
+++    if (options.hideTrigger && options.hideTriggers.length === 0) {
+++      options.hideTriggers.push(options.hideTrigger);
+++    }
+++    _ref1 = ["tipJoint", "targetJoint", "stem"];
+++    for (_i = 0, _len = _ref1.length; _i < _len; _i++) {
+++      prop = _ref1[_i];
+++      if (options[prop] && typeof options[prop] === "string") {
+++        options[prop] = new Opentip.Joint(options[prop]);
+++      }
+++    }
+++    if (options.ajax && (options.ajax === true || !options.ajax)) {
+++      if (this.adapter.tagName(this.triggerElement) === "A") {
+++        options.ajax = this.adapter.attr(this.triggerElement, "href");
+++      } else {
+++        options.ajax = false;
+++      }
+++    }
+++    if (options.showOn === "click" && this.adapter.tagName(this.triggerElement) === "A") {
+++      this.adapter.observe(this.triggerElement, "click", function(e) {
+++        e.preventDefault();
+++        e.stopPropagation();
+++        return e.stopped = true;
+++      });
+++    }
+++    if (options.target) {
+++      options.fixed = true;
+++    }
+++    if (options.stem === true) {
+++      options.stem = new Opentip.Joint(options.tipJoint);
+++    }
+++    if (options.target === true) {
+++      options.target = this.triggerElement;
+++    } else if (options.target) {
+++      options.target = this.adapter.wrap(options.target);
+++    }
+++    this.currentStem = options.stem;
+++    if (options.delay == null) {
+++      options.delay = options.showOn === "mouseover" ? 0.2 : 0;
+++    }
+++    if (options.targetJoint == null) {
+++      options.targetJoint = new Opentip.Joint(options.tipJoint).flip();
+++    }
+++    this.showTriggers = [];
+++    this.showTriggersWhenVisible = [];
+++    this.hideTriggers = [];
+++    if (options.showOn && options.showOn !== "creation") {
+++      this.showTriggers.push({
+++        element: this.triggerElement,
+++        event: options.showOn
+++      });
+++    }
+++    if (options.ajaxCache != null) {
+++      options.cache = options.ajaxCache;
+++      delete options.ajaxCache;
+++    }
+++    this.options = options;
+++    this.bound = {};
+++    _ref2 = ["prepareToShow", "prepareToHide", "show", "hide", "reposition"];
+++    for (_j = 0, _len1 = _ref2.length; _j < _len1; _j++) {
+++      methodToBind = _ref2[_j];
+++      this.bound[methodToBind] = (function(methodToBind) {
+++        return function() {
+++          return _this[methodToBind].apply(_this, arguments);
+++        };
+++      })(methodToBind);
+++    }
+++    this.adapter.domReady(function() {
+++      _this.activate();
+++      if (_this.options.showOn === "creation") {
+++        return _this.prepareToShow();
+++      }
+++    });
+++  }
+++
+++  Opentip.prototype._setup = function() {
+++    var hideOn, hideTrigger, hideTriggerElement, i, _i, _j, _len, _len1, _ref, _ref1, _results;
+++    this.debug("Setting up the tooltip.");
+++    this._buildContainer();
+++    this.hideTriggers = [];
+++    _ref = this.options.hideTriggers;
+++    for (i = _i = 0, _len = _ref.length; _i < _len; i = ++_i) {
+++      hideTrigger = _ref[i];
+++      hideTriggerElement = null;
+++      hideOn = this.options.hideOn instanceof Array ? this.options.hideOn[i] : this.options.hideOn;
+++      if (typeof hideTrigger === "string") {
+++        switch (hideTrigger) {
+++          case "trigger":
+++            hideOn = hideOn || "mouseout";
+++            hideTriggerElement = this.triggerElement;
+++            break;
+++          case "tip":
+++            hideOn = hideOn || "mouseover";
+++            hideTriggerElement = this.container;
+++            break;
+++          case "target":
+++            hideOn = hideOn || "mouseover";
+++            hideTriggerElement = this.options.target;
+++            break;
+++          case "closeButton":
+++            break;
+++          default:
+++            throw new Error("Unknown hide trigger: " + hideTrigger + ".");
+++        }
+++      } else {
+++        hideOn = hideOn || "mouseover";
+++        hideTriggerElement = this.adapter.wrap(hideTrigger);
+++      }
+++      if (hideTriggerElement) {
+++        this.hideTriggers.push({
+++          element: hideTriggerElement,
+++          event: hideOn,
+++          original: hideTrigger
+++        });
+++      }
+++    }
+++    _ref1 = this.hideTriggers;
+++    _results = [];
+++    for (_j = 0, _len1 = _ref1.length; _j < _len1; _j++) {
+++      hideTrigger = _ref1[_j];
+++      _results.push(this.showTriggersWhenVisible.push({
+++        element: hideTrigger.element,
+++        event: "mouseover"
+++      }));
+++    }
+++    return _results;
+++  };
+++
+++  Opentip.prototype._buildContainer = function() {
+++    this.container = this.adapter.create("<div id=\"opentip-" + this.id + "\" class=\"" + this["class"].container + " " + this["class"].hidden + " " + this["class"].stylePrefix + this.options.className + "\"></div>");
+++    this.adapter.css(this.container, {
+++      position: "absolute"
+++    });
+++    if (this.options.ajax) {
+++      this.adapter.addClass(this.container, this["class"].loading);
+++    }
+++    if (this.options.fixed) {
+++      this.adapter.addClass(this.container, this["class"].fixed);
+++    }
+++    if (this.options.showEffect) {
+++      this.adapter.addClass(this.container, "" + this["class"].showEffectPrefix + this.options.showEffect);
+++    }
+++    if (this.options.hideEffect) {
+++      return this.adapter.addClass(this.container, "" + this["class"].hideEffectPrefix + this.options.hideEffect);
+++    }
+++  };
+++
+++  Opentip.prototype._buildElements = function() {
+++    var headerElement, titleElement;
+++    this.tooltipElement = this.adapter.create("<div class=\"" + this["class"].opentip + "\"><div class=\"" + this["class"].header + "\"></div><div class=\"" + this["class"].content + "\"></div></div>");
+++    this.backgroundCanvas = this.adapter.wrap(document.createElement("canvas"));
+++    this.adapter.css(this.backgroundCanvas, {
+++      position: "absolute"
+++    });
+++    if (typeof G_vmlCanvasManager !== "undefined" && G_vmlCanvasManager !== null) {
+++      G_vmlCanvasManager.initElement(this.adapter.unwrap(this.backgroundCanvas));
+++    }
+++    headerElement = this.adapter.find(this.tooltipElement, "." + this["class"].header);
+++    if (this.options.title) {
+++      titleElement = this.adapter.create("<h1></h1>");
+++      this.adapter.update(titleElement, this.options.title, this.options.escapeTitle);
+++      this.adapter.append(headerElement, titleElement);
+++    }
+++    if (this.options.ajax && !this.loaded) {
+++      this.adapter.append(this.tooltipElement, this.adapter.create("<div class=\"" + this["class"].loadingIndicator + "\"><span>↻</span></div>"));
+++    }
+++    if (__indexOf.call(this.options.hideTriggers, "closeButton") >= 0) {
+++      this.closeButtonElement = this.adapter.create("<a href=\"javascript:undefined;\" class=\"" + this["class"].close + "\"><span>Close</span></a>");
+++      this.adapter.append(headerElement, this.closeButtonElement);
+++    }
+++    this.adapter.append(this.container, this.backgroundCanvas);
+++    this.adapter.append(this.container, this.tooltipElement);
+++    this.adapter.append(document.body, this.container);
+++    this._newContent = true;
+++    return this.redraw = true;
+++  };
+++
+++  Opentip.prototype.setContent = function(content) {
+++    this.content = content;
+++    this._newContent = true;
+++    if (typeof this.content === "function") {
+++      this._contentFunction = this.content;
+++      this.content = "";
+++    } else {
+++      this._contentFunction = null;
+++    }
+++    if (this.visible) {
+++      return this._updateElementContent();
+++    }
+++  };
+++
+++  Opentip.prototype._updateElementContent = function() {
+++    var contentDiv;
+++    if (this._newContent || (!this.options.cache && this._contentFunction)) {
+++      contentDiv = this.adapter.find(this.container, "." + this["class"].content);
+++      if (contentDiv != null) {
+++        if (this._contentFunction) {
+++          this.debug("Executing content function.");
+++          this.content = this._contentFunction(this);
+++        }
+++        this.adapter.update(contentDiv, this.content, this.options.escapeContent);
+++      }
+++      this._newContent = false;
+++    }
+++    this._storeAndLockDimensions();
+++    return this.reposition();
+++  };
+++
+++  Opentip.prototype._storeAndLockDimensions = function() {
+++    var prevDimension;
+++    if (!this.container) {
+++      return;
+++    }
+++    prevDimension = this.dimensions;
+++    this.adapter.css(this.container, {
+++      width: "auto",
+++      left: "0px",
+++      top: "0px"
+++    });
+++    this.dimensions = this.adapter.dimensions(this.container);
+++    this.dimensions.width += 1;
+++    this.adapter.css(this.container, {
+++      width: "" + this.dimensions.width + "px",
+++      top: "" + this.currentPosition.top + "px",
+++      left: "" + this.currentPosition.left + "px"
+++    });
+++    if (!this._dimensionsEqual(this.dimensions, prevDimension)) {
+++      this.redraw = true;
+++      return this._draw();
+++    }
+++  };
+++
+++  Opentip.prototype.activate = function() {
+++    return this._setupObservers("hidden", "hiding");
+++  };
+++
+++  Opentip.prototype.deactivate = function() {
+++    this.debug("Deactivating tooltip.");
+++    this.hide();
+++    return this._setupObservers("-showing", "-visible", "-hidden", "-hiding");
+++  };
+++
+++  Opentip.prototype._setupObservers = function() {
+++    var observeOrStop, removeObserver, state, states, trigger, _i, _j, _k, _l, _len, _len1, _len2, _len3, _ref, _ref1, _ref2,
+++      _this = this;
+++    states = 1 <= arguments.length ? __slice.call(arguments, 0) : [];
+++    for (_i = 0, _len = states.length; _i < _len; _i++) {
+++      state = states[_i];
+++      removeObserver = false;
+++      if (state.charAt(0) === "-") {
+++        removeObserver = true;
+++        state = state.substr(1);
+++      }
+++      if (this.currentObservers[state] === !removeObserver) {
+++        continue;
+++      }
+++      this.currentObservers[state] = !removeObserver;
+++      observeOrStop = function() {
+++        var args, _ref, _ref1;
+++        args = 1 <= arguments.length ? __slice.call(arguments, 0) : [];
+++        if (removeObserver) {
+++          return (_ref = _this.adapter).stopObserving.apply(_ref, args);
+++        } else {
+++          return (_ref1 = _this.adapter).observe.apply(_ref1, args);
+++        }
+++      };
+++      switch (state) {
+++        case "showing":
+++          _ref = this.hideTriggers;
+++          for (_j = 0, _len1 = _ref.length; _j < _len1; _j++) {
+++            trigger = _ref[_j];
+++            observeOrStop(trigger.element, trigger.event, this.bound.prepareToHide);
+++          }
+++          observeOrStop((document.onresize != null ? document : window), "resize", this.bound.reposition);
+++          observeOrStop(window, "scroll", this.bound.reposition);
+++          break;
+++        case "visible":
+++          _ref1 = this.showTriggersWhenVisible;
+++          for (_k = 0, _len2 = _ref1.length; _k < _len2; _k++) {
+++            trigger = _ref1[_k];
+++            observeOrStop(trigger.element, trigger.event, this.bound.prepareToShow);
+++          }
+++          break;
+++        case "hiding":
+++          _ref2 = this.showTriggers;
+++          for (_l = 0, _len3 = _ref2.length; _l < _len3; _l++) {
+++            trigger = _ref2[_l];
+++            observeOrStop(trigger.element, trigger.event, this.bound.prepareToShow);
+++          }
+++          break;
+++        case "hidden":
+++          break;
+++        default:
+++          throw new Error("Unknown state: " + state);
+++      }
+++    }
+++    return null;
+++  };
+++
+++  Opentip.prototype.prepareToShow = function() {
+++    this._abortHiding();
+++    this._abortShowing();
+++    if (this.visible) {
+++      return;
+++    }
+++    this.debug("Showing in " + this.options.delay + "s.");
+++    if (this.container == null) {
+++      this._setup();
+++    }
+++    if (this.options.group) {
+++      Opentip._abortShowingGroup(this.options.group, this);
+++    }
+++    this.preparingToShow = true;
+++    this._setupObservers("-hidden", "-hiding", "showing");
+++    this._followMousePosition();
+++    if (this.options.fixed && !this.options.target) {
+++      this.initialMousePosition = mousePosition;
+++    }
+++    this.reposition();
+++    return this._showTimeoutId = this.setTimeout(this.bound.show, this.options.delay || 0);
+++  };
+++
+++  Opentip.prototype.show = function() {
+++    var _this = this;
+++    this._abortHiding();
+++    if (this.visible) {
+++      return;
+++    }
+++    this._clearTimeouts();
+++    if (!this._triggerElementExists()) {
+++      return this.deactivate();
+++    }
+++    this.debug("Showing now.");
+++    if (this.container == null) {
+++      this._setup();
+++    }
+++    if (this.options.group) {
+++      Opentip._hideGroup(this.options.group, this);
+++    }
+++    this.visible = true;
+++    this.preparingToShow = false;
+++    if (this.tooltipElement == null) {
+++      this._buildElements();
+++    }
+++    this._updateElementContent();
+++    if (this.options.ajax && (!this.loaded || !this.options.cache)) {
+++      this._loadAjax();
+++    }
+++    this._searchAndActivateCloseButtons();
+++    this._startEnsureTriggerElement();
+++    this.adapter.css(this.container, {
+++      zIndex: Opentip.lastZIndex++
+++    });
+++    this._setupObservers("-hidden", "-hiding", "-showing", "-visible", "showing", "visible");
+++    if (this.options.fixed && !this.options.target) {
+++      this.initialMousePosition = mousePosition;
+++    }
+++    this.reposition();
+++    this.adapter.removeClass(this.container, this["class"].hiding);
+++    this.adapter.removeClass(this.container, this["class"].hidden);
+++    this.adapter.addClass(this.container, this["class"].goingToShow);
+++    this.setCss3Style(this.container, {
+++      transitionDuration: "0s"
+++    });
+++    this.defer(function() {
+++      var delay;
+++      if (!_this.visible || _this.preparingToHide) {
+++        return;
+++      }
+++      _this.adapter.removeClass(_this.container, _this["class"].goingToShow);
+++      _this.adapter.addClass(_this.container, _this["class"].showing);
+++      delay = 0;
+++      if (_this.options.showEffect && _this.options.showEffectDuration) {
+++        delay = _this.options.showEffectDuration;
+++      }
+++      _this.setCss3Style(_this.container, {
+++        transitionDuration: "" + delay + "s"
+++      });
+++      _this._visibilityStateTimeoutId = _this.setTimeout(function() {
+++        _this.adapter.removeClass(_this.container, _this["class"].showing);
+++        return _this.adapter.addClass(_this.container, _this["class"].visible);
+++      }, delay);
+++      return _this._activateFirstInput();
+++    });
+++    return this._draw();
+++  };
+++
+++  Opentip.prototype._abortShowing = function() {
+++    if (this.preparingToShow) {
+++      this.debug("Aborting showing.");
+++      this._clearTimeouts();
+++      this._stopFollowingMousePosition();
+++      this.preparingToShow = false;
+++      return this._setupObservers("-showing", "-visible", "hiding", "hidden");
+++    }
+++  };
+++
+++  Opentip.prototype.prepareToHide = function() {
+++    this._abortShowing();
+++    this._abortHiding();
+++    if (!this.visible) {
+++      return;
+++    }
+++    this.debug("Hiding in " + this.options.hideDelay + "s");
+++    this.preparingToHide = true;
+++    this._setupObservers("-showing", "visible", "-hidden", "hiding");
+++    return this._hideTimeoutId = this.setTimeout(this.bound.hide, this.options.hideDelay);
+++  };
+++
+++  Opentip.prototype.hide = function() {
+++    var _this = this;
+++    this._abortShowing();
+++    if (!this.visible) {
+++      return;
+++    }
+++    this._clearTimeouts();
+++    this.debug("Hiding!");
+++    this.visible = false;
+++    this.preparingToHide = false;
+++    this._stopEnsureTriggerElement();
+++    this._setupObservers("-showing", "-visible", "-hiding", "-hidden", "hiding", "hidden");
+++    if (!this.options.fixed) {
+++      this._stopFollowingMousePosition();
+++    }
+++    if (!this.container) {
+++      return;
+++    }
+++    this.adapter.removeClass(this.container, this["class"].visible);
+++    this.adapter.removeClass(this.container, this["class"].showing);
+++    this.adapter.addClass(this.container, this["class"].goingToHide);
+++    this.setCss3Style(this.container, {
+++      transitionDuration: "0s"
+++    });
+++    return this.defer(function() {
+++      var hideDelay;
+++      _this.adapter.removeClass(_this.container, _this["class"].goingToHide);
+++      _this.adapter.addClass(_this.container, _this["class"].hiding);
+++      hideDelay = 0;
+++      if (_this.options.hideEffect && _this.options.hideEffectDuration) {
+++        hideDelay = _this.options.hideEffectDuration;
+++      }
+++      _this.setCss3Style(_this.container, {
+++        transitionDuration: "" + hideDelay + "s"
+++      });
+++      return _this._visibilityStateTimeoutId = _this.setTimeout(function() {
+++        _this.adapter.removeClass(_this.container, _this["class"].hiding);
+++        _this.adapter.addClass(_this.container, _this["class"].hidden);
+++        _this.setCss3Style(_this.container, {
+++          transitionDuration: "0s"
+++        });
+++        if (_this.options.removeElementsOnHide) {
+++          _this.debug("Removing HTML elements.");
+++          _this.adapter.remove(_this.container);
+++          delete _this.container;
+++          return delete _this.tooltipElement;
+++        }
+++      }, hideDelay);
+++    });
+++  };
+++
+++  Opentip.prototype._abortHiding = function() {
+++    if (this.preparingToHide) {
+++      this.debug("Aborting hiding.");
+++      this._clearTimeouts();
+++      this.preparingToHide = false;
+++      return this._setupObservers("-hiding", "showing", "visible");
+++    }
+++  };
+++
+++  Opentip.prototype.reposition = function() {
+++    var position, stem, _ref,
+++      _this = this;
+++    position = this.getPosition();
+++    if (position == null) {
+++      return;
+++    }
+++    stem = this.options.stem;
+++    if (this.options.containInViewport) {
+++      _ref = this._ensureViewportContainment(position), position = _ref.position, stem = _ref.stem;
+++    }
+++    if (this._positionsEqual(position, this.currentPosition)) {
+++      return;
+++    }
+++    if (!(!this.options.stem || stem.eql(this.currentStem))) {
+++      this.redraw = true;
+++    }
+++    this.currentPosition = position;
+++    this.currentStem = stem;
+++    this._draw();
+++    this.adapter.css(this.container, {
+++      left: "" + position.left + "px",
+++      top: "" + position.top + "px"
+++    });
+++    return this.defer(function() {
+++      var rawContainer, redrawFix;
+++      rawContainer = _this.adapter.unwrap(_this.container);
+++      rawContainer.style.visibility = "hidden";
+++      redrawFix = rawContainer.offsetHeight;
+++      return rawContainer.style.visibility = "visible";
+++    });
+++  };
+++
+++  Opentip.prototype.getPosition = function(tipJoint, targetJoint, stem) {
+++    var additionalHorizontal, additionalVertical, offsetDistance, position, stemLength, targetDimensions, targetPosition, unwrappedTarget, _ref;
+++    if (!this.container) {
+++      return;
+++    }
+++    if (tipJoint == null) {
+++      tipJoint = this.options.tipJoint;
+++    }
+++    if (targetJoint == null) {
+++      targetJoint = this.options.targetJoint;
+++    }
+++    position = {};
+++    if (this.options.target) {
+++      targetPosition = this.adapter.offset(this.options.target);
+++      targetDimensions = this.adapter.dimensions(this.options.target);
+++      position = targetPosition;
+++      if (targetJoint.right) {
+++        unwrappedTarget = this.adapter.unwrap(this.options.target);
+++        if (unwrappedTarget.getBoundingClientRect != null) {
+++          position.left = unwrappedTarget.getBoundingClientRect().right + ((_ref = window.pageXOffset) != null ? _ref : document.body.scrollLeft);
+++        } else {
+++          position.left += targetDimensions.width;
+++        }
+++      } else if (targetJoint.center) {
+++        position.left += Math.round(targetDimensions.width / 2);
+++      }
+++      if (targetJoint.bottom) {
+++        position.top += targetDimensions.height;
+++      } else if (targetJoint.middle) {
+++        position.top += Math.round(targetDimensions.height / 2);
+++      }
+++      if (this.options.borderWidth) {
+++        if (this.options.tipJoint.left) {
+++          position.left += this.options.borderWidth;
+++        }
+++        if (this.options.tipJoint.right) {
+++          position.left -= this.options.borderWidth;
+++        }
+++        if (this.options.tipJoint.top) {
+++          position.top += this.options.borderWidth;
+++        } else if (this.options.tipJoint.bottom) {
+++          position.top -= this.options.borderWidth;
+++        }
+++      }
+++    } else {
+++      if (this.initialMousePosition) {
+++        position = {
+++          top: this.initialMousePosition.y,
+++          left: this.initialMousePosition.x
+++        };
+++      } else {
+++        position = {
+++          top: mousePosition.y,
+++          left: mousePosition.x
+++        };
+++      }
+++    }
+++    if (this.options.autoOffset) {
+++      stemLength = this.options.stem ? this.options.stemLength : 0;
+++      offsetDistance = stemLength && this.options.fixed ? 2 : 10;
+++      additionalHorizontal = tipJoint.middle && !this.options.fixed ? 15 : 0;
+++      additionalVertical = tipJoint.center && !this.options.fixed ? 15 : 0;
+++      if (tipJoint.right) {
+++        position.left -= offsetDistance + additionalHorizontal;
+++      } else if (tipJoint.left) {
+++        position.left += offsetDistance + additionalHorizontal;
+++      }
+++      if (tipJoint.bottom) {
+++        position.top -= offsetDistance + additionalVertical;
+++      } else if (tipJoint.top) {
+++        position.top += offsetDistance + additionalVertical;
+++      }
+++      if (stemLength) {
+++        if (stem == null) {
+++          stem = this.options.stem;
+++        }
+++        if (stem.right) {
+++          position.left -= stemLength;
+++        } else if (stem.left) {
+++          position.left += stemLength;
+++        }
+++        if (stem.bottom) {
+++          position.top -= stemLength;
+++        } else if (stem.top) {
+++          position.top += stemLength;
+++        }
+++      }
+++    }
+++    position.left += this.options.offset[0];
+++    position.top += this.options.offset[1];
+++    if (tipJoint.right) {
+++      position.left -= this.dimensions.width;
+++    } else if (tipJoint.center) {
+++      position.left -= Math.round(this.dimensions.width / 2);
+++    }
+++    if (tipJoint.bottom) {
+++      position.top -= this.dimensions.height;
+++    } else if (tipJoint.middle) {
+++      position.top -= Math.round(this.dimensions.height / 2);
+++    }
+++    return position;
+++  };
+++
+++  Opentip.prototype._ensureViewportContainment = function(position) {
+++    var needsRepositioning, newSticksOut, originals, revertedX, revertedY, scrollOffset, stem, sticksOut, targetJoint, tipJoint, viewportDimensions, viewportPosition;
+++    stem = this.options.stem;
+++    originals = {
+++      position: position,
+++      stem: stem
+++    };
+++    if (!(this.visible && position)) {
+++      return originals;
+++    }
+++    sticksOut = this._sticksOut(position);
+++    if (!(sticksOut[0] || sticksOut[1])) {
+++      return originals;
+++    }
+++    tipJoint = new Opentip.Joint(this.options.tipJoint);
+++    if (this.options.targetJoint) {
+++      targetJoint = new Opentip.Joint(this.options.targetJoint);
+++    }
+++    scrollOffset = this.adapter.scrollOffset();
+++    viewportDimensions = this.adapter.viewportDimensions();
+++    viewportPosition = [position.left - scrollOffset[0], position.top - scrollOffset[1]];
+++    needsRepositioning = false;
+++    if (viewportDimensions.width >= this.dimensions.width) {
+++      if (sticksOut[0]) {
+++        needsRepositioning = true;
+++        switch (sticksOut[0]) {
+++          case this.STICKS_OUT_LEFT:
+++            tipJoint.setHorizontal("left");
+++            if (this.options.targetJoint) {
+++              targetJoint.setHorizontal("right");
+++            }
+++            break;
+++          case this.STICKS_OUT_RIGHT:
+++            tipJoint.setHorizontal("right");
+++            if (this.options.targetJoint) {
+++              targetJoint.setHorizontal("left");
+++            }
+++        }
+++      }
+++    }
+++    if (viewportDimensions.height >= this.dimensions.height) {
+++      if (sticksOut[1]) {
+++        needsRepositioning = true;
+++        switch (sticksOut[1]) {
+++          case this.STICKS_OUT_TOP:
+++            tipJoint.setVertical("top");
+++            if (this.options.targetJoint) {
+++              targetJoint.setVertical("bottom");
+++            }
+++            break;
+++          case this.STICKS_OUT_BOTTOM:
+++            tipJoint.setVertical("bottom");
+++            if (this.options.targetJoint) {
+++              targetJoint.setVertical("top");
+++            }
+++        }
+++      }
+++    }
+++    if (!needsRepositioning) {
+++      return originals;
+++    }
+++    if (this.options.stem) {
+++      stem = tipJoint;
+++    }
+++    position = this.getPosition(tipJoint, targetJoint, stem);
+++    newSticksOut = this._sticksOut(position);
+++    revertedX = false;
+++    revertedY = false;
+++    if (newSticksOut[0] && (newSticksOut[0] !== sticksOut[0])) {
+++      revertedX = true;
+++      tipJoint.setHorizontal(this.options.tipJoint.horizontal);
+++      if (this.options.targetJoint) {
+++        targetJoint.setHorizontal(this.options.targetJoint.horizontal);
+++      }
+++    }
+++    if (newSticksOut[1] && (newSticksOut[1] !== sticksOut[1])) {
+++      revertedY = true;
+++      tipJoint.setVertical(this.options.tipJoint.vertical);
+++      if (this.options.targetJoint) {
+++        targetJoint.setVertical(this.options.targetJoint.vertical);
+++      }
+++    }
+++    if (revertedX && revertedY) {
+++      return originals;
+++    }
+++    if (revertedX || revertedY) {
+++      if (this.options.stem) {
+++        stem = tipJoint;
+++      }
+++      position = this.getPosition(tipJoint, targetJoint, stem);
+++    }
+++    return {
+++      position: position,
+++      stem: stem
+++    };
+++  };
+++
+++  Opentip.prototype._sticksOut = function(position) {
+++    var positionOffset, scrollOffset, sticksOut, viewportDimensions;
+++    scrollOffset = this.adapter.scrollOffset();
+++    viewportDimensions = this.adapter.viewportDimensions();
+++    positionOffset = [position.left - scrollOffset[0], position.top - scrollOffset[1]];
+++    sticksOut = [false, false];
+++    if (positionOffset[0] < 0) {
+++      sticksOut[0] = this.STICKS_OUT_LEFT;
+++    } else if (positionOffset[0] + this.dimensions.width > viewportDimensions.width) {
+++      sticksOut[0] = this.STICKS_OUT_RIGHT;
+++    }
+++    if (positionOffset[1] < 0) {
+++      sticksOut[1] = this.STICKS_OUT_TOP;
+++    } else if (positionOffset[1] + this.dimensions.height > viewportDimensions.height) {
+++      sticksOut[1] = this.STICKS_OUT_BOTTOM;
+++    }
+++    return sticksOut;
+++  };
+++
+++  Opentip.prototype._draw = function() {
+++    var backgroundCanvas, bulge, canvasDimensions, canvasPosition, closeButton, closeButtonInner, closeButtonOuter, ctx, drawCorner, drawLine, hb, position, stemBase, stemLength, _i, _len, _ref, _ref1, _ref2,
+++      _this = this;
+++    if (!(this.backgroundCanvas && this.redraw)) {
+++      return;
+++    }
+++    this.debug("Drawing background.");
+++    this.redraw = false;
+++    if (this.currentStem) {
+++      _ref = ["top", "right", "bottom", "left"];
+++      for (_i = 0, _len = _ref.length; _i < _len; _i++) {
+++        position = _ref[_i];
+++        this.adapter.removeClass(this.container, "stem-" + position);
+++      }
+++      this.adapter.addClass(this.container, "stem-" + this.currentStem.horizontal);
+++      this.adapter.addClass(this.container, "stem-" + this.currentStem.vertical);
+++    }
+++    closeButtonInner = [0, 0];
+++    closeButtonOuter = [0, 0];
+++    if (__indexOf.call(this.options.hideTriggers, "closeButton") >= 0) {
+++      closeButton = new Opentip.Joint(((_ref1 = this.currentStem) != null ? _ref1.toString() : void 0) === "top right" ? "top left" : "top right");
+++      closeButtonInner = [this.options.closeButtonRadius + this.options.closeButtonOffset[0], this.options.closeButtonRadius + this.options.closeButtonOffset[1]];
+++      closeButtonOuter = [this.options.closeButtonRadius - this.options.closeButtonOffset[0], this.options.closeButtonRadius - this.options.closeButtonOffset[1]];
+++    }
+++    canvasDimensions = this.adapter.clone(this.dimensions);
+++    canvasPosition = [0, 0];
+++    if (this.options.borderWidth) {
+++      canvasDimensions.width += this.options.borderWidth * 2;
+++      canvasDimensions.height += this.options.borderWidth * 2;
+++      canvasPosition[0] -= this.options.borderWidth;
+++      canvasPosition[1] -= this.options.borderWidth;
+++    }
+++    if (this.options.shadow) {
+++      canvasDimensions.width += this.options.shadowBlur * 2;
+++      canvasDimensions.width += Math.max(0, this.options.shadowOffset[0] - this.options.shadowBlur * 2);
+++      canvasDimensions.height += this.options.shadowBlur * 2;
+++      canvasDimensions.height += Math.max(0, this.options.shadowOffset[1] - this.options.shadowBlur * 2);
+++      canvasPosition[0] -= Math.max(0, this.options.shadowBlur - this.options.shadowOffset[0]);
+++      canvasPosition[1] -= Math.max(0, this.options.shadowBlur - this.options.shadowOffset[1]);
+++    }
+++    bulge = {
+++      left: 0,
+++      right: 0,
+++      top: 0,
+++      bottom: 0
+++    };
+++    if (this.currentStem) {
+++      if (this.currentStem.left) {
+++        bulge.left = this.options.stemLength;
+++      } else if (this.currentStem.right) {
+++        bulge.right = this.options.stemLength;
+++      }
+++      if (this.currentStem.top) {
+++        bulge.top = this.options.stemLength;
+++      } else if (this.currentStem.bottom) {
+++        bulge.bottom = this.options.stemLength;
+++      }
+++    }
+++    if (closeButton) {
+++      if (closeButton.left) {
+++        bulge.left = Math.max(bulge.left, closeButtonOuter[0]);
+++      } else if (closeButton.right) {
+++        bulge.right = Math.max(bulge.right, closeButtonOuter[0]);
+++      }
+++      if (closeButton.top) {
+++        bulge.top = Math.max(bulge.top, closeButtonOuter[1]);
+++      } else if (closeButton.bottom) {
+++        bulge.bottom = Math.max(bulge.bottom, closeButtonOuter[1]);
+++      }
+++    }
+++    canvasDimensions.width += bulge.left + bulge.right;
+++    canvasDimensions.height += bulge.top + bulge.bottom;
+++    canvasPosition[0] -= bulge.left;
+++    canvasPosition[1] -= bulge.top;
+++    if (this.currentStem && this.options.borderWidth) {
+++      _ref2 = this._getPathStemMeasures(this.options.stemBase, this.options.stemLength, this.options.borderWidth), stemLength = _ref2.stemLength, stemBase = _ref2.stemBase;
+++    }
+++    backgroundCanvas = this.adapter.unwrap(this.backgroundCanvas);
+++    backgroundCanvas.width = canvasDimensions.width;
+++    backgroundCanvas.height = canvasDimensions.height;
+++    this.adapter.css(this.backgroundCanvas, {
+++      width: "" + backgroundCanvas.width + "px",
+++      height: "" + backgroundCanvas.height + "px",
+++      left: "" + canvasPosition[0] + "px",
+++      top: "" + canvasPosition[1] + "px"
+++    });
+++    ctx = backgroundCanvas.getContext("2d");
+++    ctx.setTransform(1, 0, 0, 1, 0, 0);
+++    ctx.clearRect(0, 0, backgroundCanvas.width, backgroundCanvas.height);
+++    ctx.beginPath();
+++    ctx.fillStyle = this._getColor(ctx, this.dimensions, this.options.background, this.options.backgroundGradientHorizontal);
+++    ctx.lineJoin = "miter";
+++    ctx.miterLimit = 500;
+++    hb = this.options.borderWidth / 2;
+++    if (this.options.borderWidth) {
+++      ctx.strokeStyle = this.options.borderColor;
+++      ctx.lineWidth = this.options.borderWidth;
+++    } else {
+++      stemLength = this.options.stemLength;
+++      stemBase = this.options.stemBase;
+++    }
+++    if (stemBase == null) {
+++      stemBase = 0;
+++    }
+++    drawLine = function(length, stem, first) {
+++      if (first) {
+++        ctx.moveTo(Math.max(stemBase, _this.options.borderRadius, closeButtonInner[0]) + 1 - hb, -hb);
+++      }
+++      if (stem) {
+++        ctx.lineTo(length / 2 - stemBase / 2, -hb);
+++        ctx.lineTo(length / 2, -stemLength - hb);
+++        return ctx.lineTo(length / 2 + stemBase / 2, -hb);
+++      }
+++    };
+++    drawCorner = function(stem, closeButton, i) {
+++      var angle1, angle2, innerWidth, offset;
+++      if (stem) {
+++        ctx.lineTo(-stemBase + hb, 0 - hb);
+++        ctx.lineTo(stemLength + hb, -stemLength - hb);
+++        return ctx.lineTo(hb, stemBase - hb);
+++      } else if (closeButton) {
+++        offset = _this.options.closeButtonOffset;
+++        innerWidth = closeButtonInner[0];
+++        if (i % 2 !== 0) {
+++          offset = [offset[1], offset[0]];
+++          innerWidth = closeButtonInner[1];
+++        }
+++        angle1 = Math.acos(offset[1] / _this.options.closeButtonRadius);
+++        angle2 = Math.acos(offset[0] / _this.options.closeButtonRadius);
+++        ctx.lineTo(-innerWidth + hb, -hb);
+++        return ctx.arc(hb - offset[0], -hb + offset[1], _this.options.closeButtonRadius, -(Math.PI / 2 + angle1), angle2, false);
+++      } else {
+++        ctx.lineTo(-_this.options.borderRadius + hb, -hb);
+++        return ctx.quadraticCurveTo(hb, -hb, hb, _this.options.borderRadius - hb);
+++      }
+++    };
+++    ctx.translate(-canvasPosition[0], -canvasPosition[1]);
+++    ctx.save();
+++    (function() {
+++      var cornerStem, i, lineLength, lineStem, positionIdx, positionX, positionY, rotation, _j, _ref3, _results;
+++      _results = [];
+++      for (i = _j = 0, _ref3 = Opentip.positions.length / 2; 0 <= _ref3 ? _j < _ref3 : _j > _ref3; i = 0 <= _ref3 ? ++_j : --_j) {
+++        positionIdx = i * 2;
+++        positionX = i === 0 || i === 3 ? 0 : _this.dimensions.width;
+++        positionY = i < 2 ? 0 : _this.dimensions.height;
+++        rotation = (Math.PI / 2) * i;
+++        lineLength = i % 2 === 0 ? _this.dimensions.width : _this.dimensions.height;
+++        lineStem = new Opentip.Joint(Opentip.positions[positionIdx]);
+++        cornerStem = new Opentip.Joint(Opentip.positions[positionIdx + 1]);
+++        ctx.save();
+++        ctx.translate(positionX, positionY);
+++        ctx.rotate(rotation);
+++        drawLine(lineLength, lineStem.eql(_this.currentStem), i === 0);
+++        ctx.translate(lineLength, 0);
+++        drawCorner(cornerStem.eql(_this.currentStem), cornerStem.eql(closeButton), i);
+++        _results.push(ctx.restore());
+++      }
+++      return _results;
+++    })();
+++    ctx.closePath();
+++    ctx.save();
+++    if (this.options.shadow) {
+++      ctx.shadowColor = this.options.shadowColor;
+++      ctx.shadowBlur = this.options.shadowBlur;
+++      ctx.shadowOffsetX = this.options.shadowOffset[0];
+++      ctx.shadowOffsetY = this.options.shadowOffset[1];
+++    }
+++    ctx.fill();
+++    ctx.restore();
+++    if (this.options.borderWidth) {
+++      ctx.stroke();
+++    }
+++    ctx.restore();
+++    if (closeButton) {
+++      return (function() {
+++        var crossCenter, crossHeight, crossWidth, hcs, linkCenter;
+++        crossWidth = crossHeight = _this.options.closeButtonRadius * 2;
+++        if (closeButton.toString() === "top right") {
+++          linkCenter = [_this.dimensions.width - _this.options.closeButtonOffset[0], _this.options.closeButtonOffset[1]];
+++          crossCenter = [linkCenter[0] + hb, linkCenter[1] - hb];
+++        } else {
+++          linkCenter = [_this.options.closeButtonOffset[0], _this.options.closeButtonOffset[1]];
+++          crossCenter = [linkCenter[0] - hb, linkCenter[1] - hb];
+++        }
+++        ctx.translate(crossCenter[0], crossCenter[1]);
+++        hcs = _this.options.closeButtonCrossSize / 2;
+++        ctx.save();
+++        ctx.beginPath();
+++        ctx.strokeStyle = _this.options.closeButtonCrossColor;
+++        ctx.lineWidth = _this.options.closeButtonCrossLineWidth;
+++        ctx.lineCap = "round";
+++        ctx.moveTo(-hcs, -hcs);
+++        ctx.lineTo(hcs, hcs);
+++        ctx.stroke();
+++        ctx.beginPath();
+++        ctx.moveTo(hcs, -hcs);
+++        ctx.lineTo(-hcs, hcs);
+++        ctx.stroke();
+++        ctx.restore();
+++        return _this.adapter.css(_this.closeButtonElement, {
+++          left: "" + (linkCenter[0] - hcs - _this.options.closeButtonLinkOverscan) + "px",
+++          top: "" + (linkCenter[1] - hcs - _this.options.closeButtonLinkOverscan) + "px",
+++          width: "" + (_this.options.closeButtonCrossSize + _this.options.closeButtonLinkOverscan * 2) + "px",
+++          height: "" + (_this.options.closeButtonCrossSize + _this.options.closeButtonLinkOverscan * 2) + "px"
+++        });
+++      })();
+++    }
+++  };
+++
+++  Opentip.prototype._getPathStemMeasures = function(outerStemBase, outerStemLength, borderWidth) {
+++    var angle, distanceBetweenTips, halfAngle, hb, rhombusSide, stemBase, stemLength;
+++    hb = borderWidth / 2;
+++    halfAngle = Math.atan((outerStemBase / 2) / outerStemLength);
+++    angle = halfAngle * 2;
+++    rhombusSide = hb / Math.sin(angle);
+++    distanceBetweenTips = 2 * rhombusSide * Math.cos(halfAngle);
+++    stemLength = hb + outerStemLength - distanceBetweenTips;
+++    if (stemLength < 0) {
+++      throw new Error("Sorry but your stemLength / stemBase ratio is strange.");
+++    }
+++    stemBase = (Math.tan(halfAngle) * stemLength) * 2;
+++    return {
+++      stemLength: stemLength,
+++      stemBase: stemBase
+++    };
+++  };
+++
+++  Opentip.prototype._getColor = function(ctx, dimensions, color, horizontal) {
+++    var colorStop, gradient, i, _i, _len;
+++    if (horizontal == null) {
+++      horizontal = false;
+++    }
+++    if (typeof color === "string") {
+++      return color;
+++    }
+++    if (horizontal) {
+++      gradient = ctx.createLinearGradient(0, 0, dimensions.width, 0);
+++    } else {
+++      gradient = ctx.createLinearGradient(0, 0, 0, dimensions.height);
+++    }
+++    for (i = _i = 0, _len = color.length; _i < _len; i = ++_i) {
+++      colorStop = color[i];
+++      gradient.addColorStop(colorStop[0], colorStop[1]);
+++    }
+++    return gradient;
+++  };
+++
+++  Opentip.prototype._searchAndActivateCloseButtons = function() {
+++    var element, _i, _len, _ref;
+++    _ref = this.adapter.findAll(this.container, "." + this["class"].close);
+++    for (_i = 0, _len = _ref.length; _i < _len; _i++) {
+++      element = _ref[_i];
+++      this.hideTriggers.push({
+++        element: this.adapter.wrap(element),
+++        event: "click"
+++      });
+++    }
+++    if (this.currentObservers.showing) {
+++      this._setupObservers("-showing", "showing");
+++    }
+++    if (this.currentObservers.visible) {
+++      return this._setupObservers("-visible", "visible");
+++    }
+++  };
+++
+++  Opentip.prototype._activateFirstInput = function() {
+++    var input;
+++    input = this.adapter.unwrap(this.adapter.find(this.container, "input, textarea"));
+++    return input != null ? typeof input.focus === "function" ? input.focus() : void 0 : void 0;
+++  };
+++
+++  Opentip.prototype._followMousePosition = function() {
+++    if (!this.options.fixed) {
+++      return Opentip._observeMousePosition(this.bound.reposition);
+++    }
+++  };
+++
+++  Opentip.prototype._stopFollowingMousePosition = function() {
+++    if (!this.options.fixed) {
+++      return Opentip._stopObservingMousePosition(this.bound.reposition);
+++    }
+++  };
+++
+++  Opentip.prototype._clearShowTimeout = function() {
+++    return clearTimeout(this._showTimeoutId);
+++  };
+++
+++  Opentip.prototype._clearHideTimeout = function() {
+++    return clearTimeout(this._hideTimeoutId);
+++  };
+++
+++  Opentip.prototype._clearTimeouts = function() {
+++    clearTimeout(this._visibilityStateTimeoutId);
+++    this._clearShowTimeout();
+++    return this._clearHideTimeout();
+++  };
+++
+++  Opentip.prototype._triggerElementExists = function() {
+++    var el;
+++    el = this.adapter.unwrap(this.triggerElement);
+++    while (el.parentNode) {
+++      if (el.parentNode.tagName === "BODY") {
+++        return true;
+++      }
+++      el = el.parentNode;
+++    }
+++    return false;
+++  };
+++
+++  Opentip.prototype._loadAjax = function() {
+++    var _this = this;
+++    if (this.loading) {
+++      return;
+++    }
+++    this.loaded = false;
+++    this.loading = true;
+++    this.adapter.addClass(this.container, this["class"].loading);
+++    this.setContent("");
+++    this.debug("Loading content from " + this.options.ajax);
+++    return this.adapter.ajax({
+++      url: this.options.ajax,
+++      method: this.options.ajaxMethod,
+++      onSuccess: function(responseText) {
+++        _this.debug("Loading successful.");
+++        _this.adapter.removeClass(_this.container, _this["class"].loading);
+++        return _this.setContent(responseText);
+++      },
+++      onError: function(error) {
+++        var message;
+++        message = _this.options.ajaxErrorMessage;
+++        _this.debug(message, error);
+++        _this.setContent(message);
+++        return _this.adapter.addClass(_this.container, _this["class"].ajaxError);
+++      },
+++      onComplete: function() {
+++        _this.adapter.removeClass(_this.container, _this["class"].loading);
+++        _this.loading = false;
+++        _this.loaded = true;
+++        _this._searchAndActivateCloseButtons();
+++        _this._activateFirstInput();
+++        return _this.reposition();
+++      }
+++    });
+++  };
+++
+++  Opentip.prototype._ensureTriggerElement = function() {
+++    if (!this._triggerElementExists()) {
+++      this.deactivate();
+++      return this._stopEnsureTriggerElement();
+++    }
+++  };
+++
+++  Opentip.prototype._ensureTriggerElementInterval = 1000;
+++
+++  Opentip.prototype._startEnsureTriggerElement = function() {
+++    var _this = this;
+++    return this._ensureTriggerElementTimeoutId = setInterval((function() {
+++      return _this._ensureTriggerElement();
+++    }), this._ensureTriggerElementInterval);
+++  };
+++
+++  Opentip.prototype._stopEnsureTriggerElement = function() {
+++    return clearInterval(this._ensureTriggerElementTimeoutId);
+++  };
+++
+++  return Opentip;
+++
+++})();
+++
+++vendors = ["khtml", "ms", "o", "moz", "webkit"];
+++
+++Opentip.prototype.setCss3Style = function(element, styles) {
+++  var prop, value, vendor, vendorProp, _results;
+++  element = this.adapter.unwrap(element);
+++  _results = [];
+++  for (prop in styles) {
+++    if (!__hasProp.call(styles, prop)) continue;
+++    value = styles[prop];
+++    if (element.style[prop] != null) {
+++      _results.push(element.style[prop] = value);
+++    } else {
+++      _results.push((function() {
+++        var _i, _len, _results1;
+++        _results1 = [];
+++        for (_i = 0, _len = vendors.length; _i < _len; _i++) {
+++          vendor = vendors[_i];
+++          vendorProp = "" + (this.ucfirst(vendor)) + (this.ucfirst(prop));
+++          if (element.style[vendorProp] != null) {
+++            _results1.push(element.style[vendorProp] = value);
+++          } else {
+++            _results1.push(void 0);
+++          }
+++        }
+++        return _results1;
+++      }).call(this));
+++    }
+++  }
+++  return _results;
+++};
+++
+++Opentip.prototype.defer = function(func) {
+++  return setTimeout(func, 0);
+++};
+++
+++Opentip.prototype.setTimeout = function(func, seconds) {
+++  return setTimeout(func, seconds ? seconds * 1000 : 0);
+++};
+++
+++Opentip.prototype.ucfirst = function(string) {
+++  if (string == null) {
+++    return "";
+++  }
+++  return string.charAt(0).toUpperCase() + string.slice(1);
+++};
+++
+++Opentip.prototype.dasherize = function(string) {
+++  return string.replace(/([A-Z])/g, function(_, character) {
+++    return "-" + (character.toLowerCase());
+++  });
+++};
+++
+++mousePositionObservers = [];
+++
+++mousePosition = {
+++  x: 0,
+++  y: 0
+++};
+++
+++mouseMoved = function(e) {
+++  var observer, _i, _len, _results;
+++  mousePosition = Opentip.adapter.mousePosition(e);
+++  _results = [];
+++  for (_i = 0, _len = mousePositionObservers.length; _i < _len; _i++) {
+++    observer = mousePositionObservers[_i];
+++    _results.push(observer());
+++  }
+++  return _results;
+++};
+++
+++Opentip.followMousePosition = function() {
+++  return Opentip.adapter.observe(document.body, "mousemove", mouseMoved);
+++};
+++
+++Opentip._observeMousePosition = function(observer) {
+++  return mousePositionObservers.push(observer);
+++};
+++
+++Opentip._stopObservingMousePosition = function(removeObserver) {
+++  var observer;
+++  return mousePositionObservers = (function() {
+++    var _i, _len, _results;
+++    _results = [];
+++    for (_i = 0, _len = mousePositionObservers.length; _i < _len; _i++) {
+++      observer = mousePositionObservers[_i];
+++      if (observer !== removeObserver) {
+++        _results.push(observer);
+++      }
+++    }
+++    return _results;
+++  })();
+++};
+++
+++Opentip.Joint = (function() {
+++
+++  function Joint(pointerString) {
+++    if (pointerString == null) {
+++      return;
+++    }
+++    if (pointerString instanceof Opentip.Joint) {
+++      pointerString = pointerString.toString();
+++    }
+++    this.set(pointerString);
+++    this;
+++
+++  }
+++
+++  Joint.prototype.set = function(string) {
+++    string = string.toLowerCase();
+++    this.setHorizontal(string);
+++    this.setVertical(string);
+++    return this;
+++  };
+++
+++  Joint.prototype.setHorizontal = function(string) {
+++    var i, valid, _i, _j, _len, _len1, _results;
+++    valid = ["left", "center", "right"];
+++    for (_i = 0, _len = valid.length; _i < _len; _i++) {
+++      i = valid[_i];
+++      if (~string.indexOf(i)) {
+++        this.horizontal = i.toLowerCase();
+++      }
+++    }
+++    if (this.horizontal == null) {
+++      this.horizontal = "center";
+++    }
+++    _results = [];
+++    for (_j = 0, _len1 = valid.length; _j < _len1; _j++) {
+++      i = valid[_j];
+++      _results.push(this[i] = this.horizontal === i ? i : void 0);
+++    }
+++    return _results;
+++  };
+++
+++  Joint.prototype.setVertical = function(string) {
+++    var i, valid, _i, _j, _len, _len1, _results;
+++    valid = ["top", "middle", "bottom"];
+++    for (_i = 0, _len = valid.length; _i < _len; _i++) {
+++      i = valid[_i];
+++      if (~string.indexOf(i)) {
+++        this.vertical = i.toLowerCase();
+++      }
+++    }
+++    if (this.vertical == null) {
+++      this.vertical = "middle";
+++    }
+++    _results = [];
+++    for (_j = 0, _len1 = valid.length; _j < _len1; _j++) {
+++      i = valid[_j];
+++      _results.push(this[i] = this.vertical === i ? i : void 0);
+++    }
+++    return _results;
+++  };
+++
+++  Joint.prototype.eql = function(pointer) {
+++    return (pointer != null) && this.horizontal === pointer.horizontal && this.vertical === pointer.vertical;
+++  };
+++
+++  Joint.prototype.flip = function() {
+++    var flippedIndex, positionIdx;
+++    positionIdx = Opentip.position[this.toString(true)];
+++    flippedIndex = (positionIdx + 4) % 8;
+++    this.set(Opentip.positions[flippedIndex]);
+++    return this;
+++  };
+++
+++  Joint.prototype.toString = function(camelized) {
+++    var horizontal, vertical;
+++    if (camelized == null) {
+++      camelized = false;
+++    }
+++    vertical = this.vertical === "middle" ? "" : this.vertical;
+++    horizontal = this.horizontal === "center" ? "" : this.horizontal;
+++    if (vertical && horizontal) {
+++      if (camelized) {
+++        horizontal = Opentip.prototype.ucfirst(horizontal);
+++      } else {
+++        horizontal = " " + horizontal;
+++      }
+++    }
+++    return "" + vertical + horizontal;
+++  };
+++
+++  return Joint;
+++
+++})();
+++
+++Opentip.prototype._positionsEqual = function(posA, posB) {
+++  return (posA != null) && (posB != null) && posA.left === posB.left && posA.top === posB.top;
+++};
+++
+++Opentip.prototype._dimensionsEqual = function(dimA, dimB) {
+++  return (dimA != null) && (dimB != null) && dimA.width === dimB.width && dimA.height === dimB.height;
+++};
+++
+++Opentip.prototype.debug = function() {
+++  var args;
+++  args = 1 <= arguments.length ? __slice.call(arguments, 0) : [];
+++  if (Opentip.debug && ((typeof console !== "undefined" && console !== null ? console.debug : void 0) != null)) {
+++    args.unshift("#" + this.id + " |");
+++    return console.debug.apply(console, args);
+++  }
+++};
+++
+++Opentip.findElements = function() {
+++  var adapter, content, element, optionName, optionValue, options, _i, _len, _ref, _results;
+++  adapter = Opentip.adapter;
+++  _ref = adapter.findAll(document.body, "[data-ot]");
+++  _results = [];
+++  for (_i = 0, _len = _ref.length; _i < _len; _i++) {
+++    element = _ref[_i];
+++    options = {};
+++    content = adapter.data(element, "ot");
+++    if (content === "" || content === "true" || content === "yes") {
+++      content = adapter.attr(element, "title");
+++      adapter.attr(element, "title", "");
+++    }
+++    content = content || "";
+++    for (optionName in Opentip.styles.standard) {
+++      optionValue = adapter.data(element, "ot" + (Opentip.prototype.ucfirst(optionName)));
+++      if (optionValue != null) {
+++        if (optionValue === "yes" || optionValue === "true" || optionValue === "on") {
+++          optionValue = true;
+++        } else if (optionValue === "no" || optionValue === "false" || optionValue === "off") {
+++          optionValue = false;
+++        }
+++        options[optionName] = optionValue;
+++      }
+++    }
+++    _results.push(new Opentip(element, content, options));
+++  }
+++  return _results;
+++};
+++
+++Opentip.version = "2.4.6";
+++
+++Opentip.debug = false;
+++
+++Opentip.lastId = 0;
+++
+++Opentip.lastZIndex = 100;
+++
+++Opentip.tips = [];
+++
+++Opentip._abortShowingGroup = function(group, originatingOpentip) {
+++  var opentip, _i, _len, _ref, _results;
+++  _ref = Opentip.tips;
+++  _results = [];
+++  for (_i = 0, _len = _ref.length; _i < _len; _i++) {
+++    opentip = _ref[_i];
+++    if (opentip !== originatingOpentip && opentip.options.group === group) {
+++      _results.push(opentip._abortShowing());
+++    } else {
+++      _results.push(void 0);
+++    }
+++  }
+++  return _results;
+++};
+++
+++Opentip._hideGroup = function(group, originatingOpentip) {
+++  var opentip, _i, _len, _ref, _results;
+++  _ref = Opentip.tips;
+++  _results = [];
+++  for (_i = 0, _len = _ref.length; _i < _len; _i++) {
+++    opentip = _ref[_i];
+++    if (opentip !== originatingOpentip && opentip.options.group === group) {
+++      _results.push(opentip.hide());
+++    } else {
+++      _results.push(void 0);
+++    }
+++  }
+++  return _results;
+++};
+++
+++Opentip.adapters = {};
+++
+++Opentip.adapter = null;
+++
+++firstAdapter = true;
+++
+++Opentip.addAdapter = function(adapter) {
+++  Opentip.adapters[adapter.name] = adapter;
+++  if (firstAdapter) {
+++    Opentip.adapter = adapter;
+++    adapter.domReady(Opentip.findElements);
+++    adapter.domReady(Opentip.followMousePosition);
+++    return firstAdapter = false;
+++  }
+++};
+++
+++Opentip.positions = ["top", "topRight", "right", "bottomRight", "bottom", "bottomLeft", "left", "topLeft"];
+++
+++Opentip.position = {};
+++
+++_ref = Opentip.positions;
+++for (i = _i = 0, _len = _ref.length; _i < _len; i = ++_i) {
+++  position = _ref[i];
+++  Opentip.position[position] = i;
+++}
+++
+++Opentip.styles = {
+++  standard: {
+++    "extends": null,
+++    title: void 0,
+++    escapeTitle: true,
+++    escapeContent: false,
+++    className: "standard",
+++    stem: true,
+++    delay: null,
+++    hideDelay: 0.1,
+++    fixed: false,
+++    showOn: "mouseover",
+++    hideTrigger: "trigger",
+++    hideTriggers: [],
+++    hideOn: null,
+++    removeElementsOnHide: false,
+++    offset: [0, 0],
+++    containInViewport: true,
+++    autoOffset: true,
+++    showEffect: "appear",
+++    hideEffect: "fade",
+++    showEffectDuration: 0.3,
+++    hideEffectDuration: 0.2,
+++    stemLength: 5,
+++    stemBase: 8,
+++    tipJoint: "top left",
+++    target: null,
+++    targetJoint: null,
+++    cache: true,
+++    ajax: false,
+++    ajaxMethod: "GET",
+++    ajaxErrorMessage: "There was a problem downloading the content.",
+++    group: null,
+++    style: null,
+++    background: "#fff18f",
+++    backgroundGradientHorizontal: false,
+++    closeButtonOffset: [5, 5],
+++    closeButtonRadius: 7,
+++    closeButtonCrossSize: 4,
+++    closeButtonCrossColor: "#d2c35b",
+++    closeButtonCrossLineWidth: 1.5,
+++    closeButtonLinkOverscan: 6,
+++    borderRadius: 5,
+++    borderWidth: 1,
+++    borderColor: "#f2e37b",
+++    shadow: true,
+++    shadowBlur: 10,
+++    shadowOffset: [3, 3],
+++    shadowColor: "rgba(0, 0, 0, 0.1)"
+++  },
+++  glass: {
+++    "extends": "standard",
+++    className: "glass",
+++    background: [[0, "rgba(252, 252, 252, 0.8)"], [0.5, "rgba(255, 255, 255, 0.8)"], [0.5, "rgba(250, 250, 250, 0.9)"], [1, "rgba(245, 245, 245, 0.9)"]],
+++    borderColor: "#eee",
+++    closeButtonCrossColor: "rgba(0, 0, 0, 0.2)",
+++    borderRadius: 15,
+++    closeButtonRadius: 10,
+++    closeButtonOffset: [8, 8]
+++  },
+++  dark: {
+++    "extends": "standard",
+++    className: "dark",
+++    borderRadius: 13,
+++    borderColor: "#444",
+++    closeButtonCrossColor: "rgba(240, 240, 240, 1)",
+++    shadowColor: "rgba(0, 0, 0, 0.3)",
+++    shadowOffset: [2, 2],
+++    background: [[0, "rgba(30, 30, 30, 0.7)"], [0.5, "rgba(30, 30, 30, 0.8)"], [0.5, "rgba(10, 10, 10, 0.8)"], [1, "rgba(10, 10, 10, 0.9)"]]
+++  },
+++  alert: {
+++    "extends": "standard",
+++    className: "alert",
+++    borderRadius: 1,
+++    borderColor: "#AE0D11",
+++    closeButtonCrossColor: "rgba(255, 255, 255, 1)",
+++    shadowColor: "rgba(0, 0, 0, 0.3)",
+++    shadowOffset: [2, 2],
+++    background: [[0, "rgba(203, 15, 19, 0.7)"], [0.5, "rgba(203, 15, 19, 0.8)"], [0.5, "rgba(189, 14, 18, 0.8)"], [1, "rgba(179, 14, 17, 0.9)"]]
+++  }
+++};
+++
+++Opentip.defaultStyle = "standard";
+++
+++if (typeof module !== "undefined" && module !== null) {
+++  module.exports = Opentip;
+++} else {
+++  window.Opentip = Opentip;
+++}
+++
+++
+++// Generated by CoffeeScript 1.4.0
+++var __slice = [].slice;
+++
+++(function($) {
+++  var Adapter;
+++  $.fn.opentip = function(content, title, options) {
+++    return new Opentip(this, content, title, options);
+++  };
+++  Adapter = (function() {
+++
+++    function Adapter() {}
+++
+++    Adapter.prototype.name = "jquery";
+++
+++    Adapter.prototype.domReady = function(callback) {
+++      return $(callback);
+++    };
+++
+++    Adapter.prototype.create = function(html) {
+++      return $(html);
+++    };
+++
+++    Adapter.prototype.wrap = function(element) {
+++      element = $(element);
+++      if (element.length > 1) {
+++        throw new Error("Multiple elements provided.");
+++      }
+++      return element;
+++    };
+++
+++    Adapter.prototype.unwrap = function(element) {
+++      return $(element)[0];
+++    };
+++
+++    Adapter.prototype.tagName = function(element) {
+++      return this.unwrap(element).tagName;
+++    };
+++
+++    Adapter.prototype.attr = function() {
+++      var args, element, _ref;
+++      element = arguments[0], args = 2 <= arguments.length ? __slice.call(arguments, 1) : [];
+++      return (_ref = $(element)).attr.apply(_ref, args);
+++    };
+++
+++    Adapter.prototype.data = function() {
+++      var args, element, _ref;
+++      element = arguments[0], args = 2 <= arguments.length ? __slice.call(arguments, 1) : [];
+++      return (_ref = $(element)).data.apply(_ref, args);
+++    };
+++
+++    Adapter.prototype.find = function(element, selector) {
+++      return $(element).find(selector).get(0);
+++    };
+++
+++    Adapter.prototype.findAll = function(element, selector) {
+++      return $(element).find(selector);
+++    };
+++
+++    Adapter.prototype.update = function(element, content, escape) {
+++      element = $(element);
+++      if (escape) {
+++        return element.text(content);
+++      } else {
+++        return element.html(content);
+++      }
+++    };
+++
+++    Adapter.prototype.append = function(element, child) {
+++      return $(element).append(child);
+++    };
+++
+++    Adapter.prototype.remove = function(element) {
+++      return $(element).remove();
+++    };
+++
+++    Adapter.prototype.addClass = function(element, className) {
+++      return $(element).addClass(className);
+++    };
+++
+++    Adapter.prototype.removeClass = function(element, className) {
+++      return $(element).removeClass(className);
+++    };
+++
+++    Adapter.prototype.css = function(element, properties) {
+++      return $(element).css(properties);
+++    };
+++
+++    Adapter.prototype.dimensions = function(element) {
+++      return {
+++        width: $(element).outerWidth(),
+++        height: $(element).outerHeight()
+++      };
+++    };
+++
+++    Adapter.prototype.scrollOffset = function() {
+++      return [window.pageXOffset || document.documentElement.scrollLeft || document.body.scrollLeft, window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop];
+++    };
+++
+++    Adapter.prototype.viewportDimensions = function() {
+++      return {
+++        width: document.documentElement.clientWidth,
+++        height: document.documentElement.clientHeight
+++      };
+++    };
+++
+++    Adapter.prototype.mousePosition = function(e) {
+++      if (e == null) {
+++        return null;
+++      }
+++      return {
+++        x: e.pageX,
+++        y: e.pageY
+++      };
+++    };
+++
+++    Adapter.prototype.offset = function(element) {
+++      var offset;
+++      offset = $(element).offset();
+++      return {
+++        left: offset.left,
+++        top: offset.top
+++      };
+++    };
+++
+++    Adapter.prototype.observe = function(element, eventName, observer) {
+++      return $(element).bind(eventName, observer);
+++    };
+++
+++    Adapter.prototype.stopObserving = function(element, eventName, observer) {
+++      return $(element).unbind(eventName, observer);
+++    };
+++
+++    Adapter.prototype.ajax = function(options) {
+++      var _ref, _ref1;
+++      if (options.url == null) {
+++        throw new Error("No url provided");
+++      }
+++      return $.ajax({
+++        url: options.url,
+++        type: (_ref = (_ref1 = options.method) != null ? _ref1.toUpperCase() : void 0) != null ? _ref : "GET"
+++      }).done(function(content) {
+++        return typeof options.onSuccess === "function" ? options.onSuccess(content) : void 0;
+++      }).fail(function(request) {
+++        return typeof options.onError === "function" ? options.onError("Server responded with status " + request.status) : void 0;
+++      }).always(function() {
+++        return typeof options.onComplete === "function" ? options.onComplete() : void 0;
+++      });
+++    };
+++
+++    Adapter.prototype.clone = function(object) {
+++      return $.extend({}, object);
+++    };
+++
+++    Adapter.prototype.extend = function() {
+++      var sources, target;
+++      target = arguments[0], sources = 2 <= arguments.length ? __slice.call(arguments, 1) : [];
+++      return $.extend.apply($, [target].concat(__slice.call(sources)));
+++    };
+++
+++    return Adapter;
+++
+++  })();
+++  return Opentip.addAdapter(new Adapter);
+++})(jQuery);
+++});
++\ No newline at end of file
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/styles/BBOOTS/template/js/opentip-jquery.min.js" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/styles/BBOOTS/template/js/opentip-jquery.min.js"
++new file mode 100644
++index 000000000..c47ebb565
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/styles/BBOOTS/template/js/opentip-jquery.min.js"
++@@ -0,0 +1,6 @@
+++// Opentip v2.4.6
+++// Copyright (c) 2009-2012
+++// www.opentip.org
+++// MIT Licensed
+++head.ready(function(){var Opentip,firstAdapter,i,mouseMoved,mousePosition,mousePositionObservers,position,vendors,_i,_len,_ref,__slice=[].slice,__indexOf=[].indexOf||function(t){for(var e=0,i=this.length;i>e;e++)if(e in this&&this[e]===t)return e;return-1},__hasProp={}.hasOwnProperty;for(Opentip=function(){function t(e,i,o,s){var n,r,a,h,p,d,l,u,c,g,f,m,v,b,w=this;if(this.id=++t.lastId,this.debug("Creating Opentip."),t.tips.push(this),this.adapter=t.adapter,n=this.adapter.data(e,"opentips")||[],n.push(this),this.adapter.data(e,"opentips",n),this.triggerElement=this.adapter.wrap(e),this.triggerElement.length>1)throw Error("You can't call Opentip on multiple elements.");if(1>this.triggerElement.length)throw Error("Invalid element.");this.loaded=!1,this.loading=!1,this.visible=!1,this.waitingToShow=!1,this.waitingToHide=!1,this.currentPosition={left:0,top:0},this.dimensions={width:100,height:50},this.content="",this.redraw=!0,this.currentObservers={showing:!1,visible:!1,hiding:!1,hidden:!1},s=this.adapter.clone(s),typeof i=="object"?(s=i,i=o=void 0):typeof o=="object"&&(s=o,o=void 0),o!=null&&(s.title=o),i!=null&&this.setContent(i),s["extends"]==null&&(s["extends"]=s.style!=null?s.style:t.defaultStyle),h=[s],b=s;while(b["extends"]){if(d=b["extends"],b=t.styles[d],b==null)throw Error("Invalid style: "+d);h.unshift(b),b["extends"]==null&&d!=="standard"&&(b["extends"]="standard")}for(s=(f=this.adapter).extend.apply(f,[{}].concat(__slice.call(h))),s.hideTriggers=function(){var t,e,i,o;for(i=s.hideTriggers,o=[],t=0,e=i.length;e>t;t++)r=i[t],o.push(r);return o}(),s.hideTrigger&&s.hideTriggers.length===0&&s.hideTriggers.push(s.hideTrigger),m=["tipJoint","targetJoint","stem"],l=0,c=m.length;c>l;l++)p=m[l],s[p]&&typeof s[p]=="string"&&(s[p]=new t.Joint(s[p]));for(!s.ajax||s.ajax!==!0&&s.ajax||(s.ajax=this.adapter.tagName(this.triggerElement)==="A"?this.adapter.attr(this.triggerElement,"href"):!1),s.showOn==="click"&&this.adapter.tagName(this.triggerElement)==="A"&&this.adapter.observe(this.triggerElement,"click",function(t){return t.preventDefault(),t.stopPropagation(),t.stopped=!0}),s.target&&(s.fixed=!0),s.stem===!0&&(s.stem=new t.Joint(s.tipJoint)),s.target===!0?s.target=this.triggerElement:s.target&&(s.target=this.adapter.wrap(s.target)),this.currentStem=s.stem,s.delay==null&&(s.delay=s.showOn==="mouseover"?.2:0),s.targetJoint==null&&(s.targetJoint=new t.Joint(s.tipJoint).flip()),this.showTriggers=[],this.showTriggersWhenVisible=[],this.hideTriggers=[],s.showOn&&s.showOn!=="creation"&&this.showTriggers.push({element:this.triggerElement,event:s.showOn}),s.ajaxCache!=null&&(s.cache=s.ajaxCache,delete s.ajaxCache),this.options=s,this.bound={},v=["prepareToShow","prepareToHide","show","hide","reposition"],u=0,g=v.length;g>u;u++)a=v[u],this.bound[a]=function(t){return function(){return w[t].apply(w,arguments)}}(a);this.adapter.domReady(function(){return w.activate(),w.options.showOn==="creation"?w.prepareToShow():void 0})}return t.prototype.STICKS_OUT_TOP=1,t.prototype.STICKS_OUT_BOTTOM=2,t.prototype.STICKS_OUT_LEFT=1,t.prototype.STICKS_OUT_RIGHT=2,t.prototype["class"]={container:"opentip-container",opentip:"opentip",header:"ot-header",content:"ot-content",loadingIndicator:"ot-loading-indicator",close:"ot-close",goingToHide:"ot-going-to-hide",hidden:"ot-hidden",hiding:"ot-hiding",goingToShow:"ot-going-to-show",showing:"ot-showing",visible:"ot-visible",loading:"ot-loading",ajaxError:"ot-ajax-error",fixed:"ot-fixed",showEffectPrefix:"ot-show-effect-",hideEffectPrefix:"ot-hide-effect-",stylePrefix:"style-"},t.prototype._setup=function(){var t,e,i,o,s,n,r,a,h,p,d;for(this.debug("Setting up the tooltip."),this._buildContainer(),this.hideTriggers=[],h=this.options.hideTriggers,o=s=0,r=h.length;r>s;o=++s){if(e=h[o],i=null,t=this.options.hideOn instanceof Array?this.options.hideOn[o]:this.options.hideOn,typeof e=="string")switch(e){case"trigger":t=t||"mouseout",i=this.triggerElement;break;case"tip":t=t||"mouseover",i=this.container;break;case"target":t=t||"mouseover",i=this.options.target;break;case"closeButton":break;default:throw Error("Unknown hide trigger: "+e+".")}else t=t||"mouseover",i=this.adapter.wrap(e);i&&this.hideTriggers.push({element:i,event:t,original:e})}for(p=this.hideTriggers,d=[],n=0,a=p.length;a>n;n++)e=p[n],d.push(this.showTriggersWhenVisible.push({element:e.element,event:"mouseover"}));return d},t.prototype._buildContainer=function(){return this.container=this.adapter.create('<div id="opentip-'+this.id+'" class="'+this["class"].container+" "+this["class"].hidden+" "+this["class"].stylePrefix+this.options.className+'"></div>'),this.adapter.css(this.container,{position:"absolute"}),this.options.ajax&&this.adapter.addClass(this.container,this["class"].loading),this.options.fixed&&this.adapter.addClass(this.container,this["class"].fixed),this.options.showEffect&&this.adapter.addClass(this.container,""+this["class"].showEffectPrefix+this.options.showEffect),this.options.hideEffect?this.adapter.addClass(this.container,""+this["class"].hideEffectPrefix+this.options.hideEffect):void 0},t.prototype._buildElements=function(){var t,e;return this.tooltipElement=this.adapter.create('<div class="'+this["class"].opentip+'"><div class="'+this["class"].header+'"></div><div class="'+this["class"].content+'"></div></div>'),this.backgroundCanvas=this.adapter.wrap(document.createElement("canvas")),this.adapter.css(this.backgroundCanvas,{position:"absolute"}),typeof G_vmlCanvasManager!="undefined"&&G_vmlCanvasManager!==null&&G_vmlCanvasManager.initElement(this.adapter.unwrap(this.backgroundCanvas)),t=this.adapter.find(this.tooltipElement,"."+this["class"].header),this.options.title&&(e=this.adapter.create("<h1></h1>"),this.adapter.update(e,this.options.title,this.options.escapeTitle),this.adapter.append(t,e)),this.options.ajax&&!this.loaded&&this.adapter.append(this.tooltipElement,this.adapter.create('<div class="'+this["class"].loadingIndicator+'"><span>↻</span></div>')),__indexOf.call(this.options.hideTriggers,"closeButton")>=0&&(this.closeButtonElement=this.adapter.create('<a href="javascript:undefined;" class="'+this["class"].close+'"><span>Close</span></a>'),this.adapter.append(t,this.closeButtonElement)),this.adapter.append(this.container,this.backgroundCanvas),this.adapter.append(this.container,this.tooltipElement),this.adapter.append(document.body,this.container),this._newContent=!0,this.redraw=!0},t.prototype.setContent=function(t){return this.content=t,this._newContent=!0,typeof this.content=="function"?(this._contentFunction=this.content,this.content=""):this._contentFunction=null,this.visible?this._updateElementContent():void 0},t.prototype._updateElementContent=function(){var t;return(this._newContent||!this.options.cache&&this._contentFunction)&&(t=this.adapter.find(this.container,"."+this["class"].content),t!=null&&(this._contentFunction&&(this.debug("Executing content function."),this.content=this._contentFunction(this)),this.adapter.update(t,this.content,this.options.escapeContent)),this._newContent=!1),this._storeAndLockDimensions(),this.reposition()},t.prototype._storeAndLockDimensions=function(){var t;if(this.container)return t=this.dimensions,this.adapter.css(this.container,{width:"auto",left:"0px",top:"0px"}),this.dimensions=this.adapter.dimensions(this.container),this.dimensions.width+=1,this.adapter.css(this.container,{width:""+this.dimensions.width+"px",top:""+this.currentPosition.top+"px",left:""+this.currentPosition.left+"px"}),this._dimensionsEqual(this.dimensions,t)?void 0:(this.redraw=!0,this._draw())},t.prototype.activate=function(){return this._setupObservers("hidden","hiding")},t.prototype.deactivate=function(){return this.debug("Deactivating tooltip."),this.hide(),this._setupObservers("-showing","-visible","-hidden","-hiding")},t.prototype._setupObservers=function(){var t,e,i,o,s,n,r,a,h,p,d,l,u,c,g,f,m=this;for(o=arguments.length>=1?__slice.call(arguments,0):[],n=0,p=o.length;p>n;n++)if(i=o[n],e=!1,i.charAt(0)==="-"&&(e=!0,i=i.substr(1)),this.currentObservers[i]!==!e)switch(this.currentObservers[i]=!e,t=function(){var t,i,o;return t=arguments.length>=1?__slice.call(arguments,0):[],e?(i=m.adapter).stopObserving.apply(i,t):(o=m.adapter).observe.apply(o,t)},i){case"showing":for(c=this.hideTriggers,r=0,d=c.length;d>r;r++)s=c[r],t(s.element,s.event,this.bound.prepareToHide);t(document.onresize!=null?document:window,"resize",this.bound.reposition),t(window,"scroll",this.bound.reposition);break;case"visible":for(g=this.showTriggersWhenVisible,a=0,l=g.length;l>a;a++)s=g[a],t(s.element,s.event,this.bound.prepareToShow);break;case"hiding":for(f=this.showTriggers,h=0,u=f.length;u>h;h++)s=f[h],t(s.element,s.event,this.bound.prepareToShow);break;case"hidden":break;default:throw Error("Unknown state: "+i)}return null},t.prototype.prepareToShow=function(){return this._abortHiding(),this._abortShowing(),this.visible?void 0:(this.debug("Showing in "+this.options.delay+"s."),this.container==null&&this._setup(),this.options.group&&t._abortShowingGroup(this.options.group,this),this.preparingToShow=!0,this._setupObservers("-hidden","-hiding","showing"),this._followMousePosition(),this.options.fixed&&!this.options.target&&(this.initialMousePosition=mousePosition),this.reposition(),this._showTimeoutId=this.setTimeout(this.bound.show,this.options.delay||0))},t.prototype.show=function(){var e=this;return this._abortHiding(),this.visible?void 0:(this._clearTimeouts(),this._triggerElementExists()?(this.debug("Showing now."),this.container==null&&this._setup(),this.options.group&&t._hideGroup(this.options.group,this),this.visible=!0,this.preparingToShow=!1,this.tooltipElement==null&&this._buildElements(),this._updateElementContent(),!this.options.ajax||this.loaded&&this.options.cache||this._loadAjax(),this._searchAndActivateCloseButtons(),this._startEnsureTriggerElement(),this.adapter.css(this.container,{zIndex:t.lastZIndex++}),this._setupObservers("-hidden","-hiding","-showing","-visible","showing","visible"),this.options.fixed&&!this.options.target&&(this.initialMousePosition=mousePosition),this.reposition(),this.adapter.removeClass(this.container,this["class"].hiding),this.adapter.removeClass(this.container,this["class"].hidden),this.adapter.addClass(this.container,this["class"].goingToShow),this.setCss3Style(this.container,{transitionDuration:"0s"}),this.defer(function(){var t;if(e.visible&&!e.preparingToHide)return e.adapter.removeClass(e.container,e["class"].goingToShow),e.adapter.addClass(e.container,e["class"].showing),t=0,e.options.showEffect&&e.options.showEffectDuration&&(t=e.options.showEffectDuration),e.setCss3Style(e.container,{transitionDuration:""+t+"s"}),e._visibilityStateTimeoutId=e.setTimeout(function(){return e.adapter.removeClass(e.container,e["class"].showing),e.adapter.addClass(e.container,e["class"].visible)},t),e._activateFirstInput()}),this._draw()):this.deactivate())},t.prototype._abortShowing=function(){return this.preparingToShow?(this.debug("Aborting showing."),this._clearTimeouts(),this._stopFollowingMousePosition(),this.preparingToShow=!1,this._setupObservers("-showing","-visible","hiding","hidden")):void 0},t.prototype.prepareToHide=function(){return this._abortShowing(),this._abortHiding(),this.visible?(this.debug("Hiding in "+this.options.hideDelay+"s"),this.preparingToHide=!0,this._setupObservers("-showing","visible","-hidden","hiding"),this._hideTimeoutId=this.setTimeout(this.bound.hide,this.options.hideDelay)):void 0},t.prototype.hide=function(){var t=this;return this._abortShowing(),this.visible&&(this._clearTimeouts(),this.debug("Hiding!"),this.visible=!1,this.preparingToHide=!1,this._stopEnsureTriggerElement(),this._setupObservers("-showing","-visible","-hiding","-hidden","hiding","hidden"),this.options.fixed||this._stopFollowingMousePosition(),this.container)?(this.adapter.removeClass(this.container,this["class"].visible),this.adapter.removeClass(this.container,this["class"].showing),this.adapter.addClass(this.container,this["class"].goingToHide),this.setCss3Style(this.container,{transitionDuration:"0s"}),this.defer(function(){var e;return t.adapter.removeClass(t.container,t["class"].goingToHide),t.adapter.addClass(t.container,t["class"].hiding),e=0,t.options.hideEffect&&t.options.hideEffectDuration&&(e=t.options.hideEffectDuration),t.setCss3Style(t.container,{transitionDuration:""+e+"s"}),t._visibilityStateTimeoutId=t.setTimeout(function(){return t.adapter.removeClass(t.container,t["class"].hiding),t.adapter.addClass(t.container,t["class"].hidden),t.setCss3Style(t.container,{transitionDuration:"0s"}),t.options.removeElementsOnHide?(t.debug("Removing HTML elements."),t.adapter.remove(t.container),delete t.container,delete t.tooltipElement):void 0},e)})):void 0},t.prototype._abortHiding=function(){return this.preparingToHide?(this.debug("Aborting hiding."),this._clearTimeouts(),this.preparingToHide=!1,this._setupObservers("-hiding","showing","visible")):void 0},t.prototype.reposition=function(){var t,e,i,o=this;return t=this.getPosition(),t==null||(e=this.options.stem,this.options.containInViewport&&(i=this._ensureViewportContainment(t),t=i.position,e=i.stem),this._positionsEqual(t,this.currentPosition))?void 0:(this.options.stem&&!e.eql(this.currentStem)&&(this.redraw=!0),this.currentPosition=t,this.currentStem=e,this._draw(),this.adapter.css(this.container,{left:""+t.left+"px",top:""+t.top+"px"}),this.defer(function(){var t,e;return t=o.adapter.unwrap(o.container),t.style.visibility="hidden",e=t.offsetHeight,t.style.visibility="visible"}))},t.prototype.getPosition=function(t,e,i){var o,s,n,r,a,h,p,d,l;if(this.container)return t==null&&(t=this.options.tipJoint),e==null&&(e=this.options.targetJoint),r={},this.options.target?(p=this.adapter.offset(this.options.target),h=this.adapter.dimensions(this.options.target),r=p,e.right?(d=this.adapter.unwrap(this.options.target),d.getBoundingClientRect!=null?r.left=d.getBoundingClientRect().right+((l=window.pageXOffset)!=null?l:document.body.scrollLeft):r.left+=h.width):e.center&&(r.left+=Math.round(h.width/2)),e.bottom?r.top+=h.height:e.middle&&(r.top+=Math.round(h.height/2)),this.options.borderWidth&&(this.options.tipJoint.left&&(r.left+=this.options.borderWidth),this.options.tipJoint.right&&(r.left-=this.options.borderWidth),this.options.tipJoint.top?r.top+=this.options.borderWidth:this.options.tipJoint.bottom&&(r.top-=this.options.borderWidth))):r=this.initialMousePosition?{top:this.initialMousePosition.y,left:this.initialMousePosition.x}:{top:mousePosition.y,left:mousePosition.x},this.options.autoOffset&&(a=this.options.stem?this.options.stemLength:0,n=a&&this.options.fixed?2:10,o=t.middle&&!this.options.fixed?15:0,s=t.center&&!this.options.fixed?15:0,t.right?r.left-=n+o:t.left&&(r.left+=n+o),t.bottom?r.top-=n+s:t.top&&(r.top+=n+s),a&&(i==null&&(i=this.options.stem),i.right?r.left-=a:i.left&&(r.left+=a),i.bottom?r.top-=a:i.top&&(r.top+=a))),r.left+=this.options.offset[0],r.top+=this.options.offset[1],t.right?r.left-=this.dimensions.width:t.center&&(r.left-=Math.round(this.dimensions.width/2)),t.bottom?r.top-=this.dimensions.height:t.middle&&(r.top-=Math.round(this.dimensions.height/2)),r},t.prototype._ensureViewportContainment=function(e){var i,o,s,n,r,a,h,p,d,l,u,c;if(h=this.options.stem,s={position:e,stem:h},!this.visible||!e)return s;if(p=this._sticksOut(e),!p[0]&&!p[1])return s;if(l=new t.Joint(this.options.tipJoint),this.options.targetJoint&&(d=new t.Joint(this.options.targetJoint)),a=this.adapter.scrollOffset(),u=this.adapter.viewportDimensions(),c=[e.left-a[0],e.top-a[1]],i=!1,u.width>=this.dimensions.width&&p[0])switch(i=!0,p[0]){case this.STICKS_OUT_LEFT:l.setHorizontal("left"),this.options.targetJoint&&d.setHorizontal("right");break;case this.STICKS_OUT_RIGHT:l.setHorizontal("right"),this.options.targetJoint&&d.setHorizontal("left")}if(u.height>=this.dimensions.height&&p[1])switch(i=!0,p[1]){case this.STICKS_OUT_TOP:l.setVertical("top"),this.options.targetJoint&&d.setVertical("bottom");break;case this.STICKS_OUT_BOTTOM:l.setVertical("bottom"),this.options.targetJoint&&d.setVertical("top")}return i?(this.options.stem&&(h=l),e=this.getPosition(l,d,h),o=this._sticksOut(e),n=!1,r=!1,o[0]&&o[0]!==p[0]&&(n=!0,l.setHorizontal(this.options.tipJoint.horizontal),this.options.targetJoint&&d.setHorizontal(this.options.targetJoint.horizontal)),o[1]&&o[1]!==p[1]&&(r=!0,l.setVertical(this.options.tipJoint.vertical),this.options.targetJoint&&d.setVertical(this.options.targetJoint.vertical)),n&&r?s:((n||r)&&(this.options.stem&&(h=l),e=this.getPosition(l,d,h)),{position:e,stem:h})):s},t.prototype._sticksOut=function(t){var e,i,o,s;return i=this.adapter.scrollOffset(),s=this.adapter.viewportDimensions(),e=[t.left-i[0],t.top-i[1]],o=[!1,!1],0>e[0]?o[0]=this.STICKS_OUT_LEFT:e[0]+this.dimensions.width>s.width&&(o[0]=this.STICKS_OUT_RIGHT),0>e[1]?o[1]=this.STICKS_OUT_TOP:e[1]+this.dimensions.height>s.height&&(o[1]=this.STICKS_OUT_BOTTOM),o},t.prototype._draw=function(){var e,i,o,s,n,r,a,h,p,d,l,u,c,g,f,m,v,b,w,_=this;if(this.backgroundCanvas&&this.redraw){if(this.debug("Drawing background."),this.redraw=!1,this.currentStem){for(v=["top","right","bottom","left"],f=0,m=v.length;m>f;f++)u=v[f],this.adapter.removeClass(this.container,"stem-"+u);this.adapter.addClass(this.container,"stem-"+this.currentStem.horizontal),this.adapter.addClass(this.container,"stem-"+this.currentStem.vertical)}return r=[0,0],a=[0,0],__indexOf.call(this.options.hideTriggers,"closeButton")>=0&&(n=new t.Joint(((b=this.currentStem)!=null?b+"":void 0)==="top right"?"top left":"top right"),r=[this.options.closeButtonRadius+this.options.closeButtonOffset[0],this.options.closeButtonRadius+this.options.closeButtonOffset[1]],a=[this.options.closeButtonRadius-this.options.closeButtonOffset[0],this.options.closeButtonRadius-this.options.closeButtonOffset[1]]),o=this.adapter.clone(this.dimensions),s=[0,0],this.options.borderWidth&&(o.width+=this.options.borderWidth*2,o.height+=this.options.borderWidth*2,s[0]-=this.options.borderWidth,s[1]-=this.options.borderWidth),this.options.shadow&&(o.width+=this.options.shadowBlur*2,o.width+=Math.max(0,this.options.shadowOffset[0]-this.options.shadowBlur*2),o.height+=this.options.shadowBlur*2,o.height+=Math.max(0,this.options.shadowOffset[1]-this.options.shadowBlur*2),s[0]-=Math.max(0,this.options.shadowBlur-this.options.shadowOffset[0]),s[1]-=Math.max(0,this.options.shadowBlur-this.options.shadowOffset[1])),i={left:0,right:0,top:0,bottom:0},this.currentStem&&(this.currentStem.left?i.left=this.options.stemLength:this.currentStem.right&&(i.right=this.options.stemLength),this.currentStem.top?i.top=this.options.stemLength:this.currentStem.bottom&&(i.bottom=this.options.stemLength)),n&&(n.left?i.left=Math.max(i.left,a[0]):n.right&&(i.right=Math.max(i.right,a[0])),n.top?i.top=Math.max(i.top,a[1]):n.bottom&&(i.bottom=Math.max(i.bottom,a[1]))),o.width+=i.left+i.right,o.height+=i.top+i.bottom,s[0]-=i.left,s[1]-=i.top,this.currentStem&&this.options.borderWidth&&(w=this._getPathStemMeasures(this.options.stemBase,this.options.stemLength,this.options.borderWidth),g=w.stemLength,c=w.stemBase),e=this.adapter.unwrap(this.backgroundCanvas),e.width=o.width,e.height=o.height,this.adapter.css(this.backgroundCanvas,{width:""+e.width+"px",height:""+e.height+"px",left:""+s[0]+"px",top:""+s[1]+"px"}),h=e.getContext("2d"),h.setTransform(1,0,0,1,0,0),h.clearRect(0,0,e.width,e.height),h.beginPath(),h.fillStyle=this._getColor(h,this.dimensions,this.options.background,this.options.backgroundGradientHorizontal),h.lineJoin="miter",h.miterLimit=500,l=this.options.borderWidth/2,this.options.borderWidth?(h.strokeStyle=this.options.borderColor,h.lineWidth=this.options.borderWidth):(g=this.options.stemLength,c=this.options.stemBase),c==null&&(c=0),d=function(t,e,i){return i&&h.moveTo(Math.max(c,_.options.borderRadius,r[0])+1-l,-l),e?(h.lineTo(t/2-c/2,-l),h.lineTo(t/2,-g-l),h.lineTo(t/2+c/2,-l)):void 0},p=function(t,e,i){var o,s,n,a;return t?(h.lineTo(-c+l,0-l),h.lineTo(g+l,-g-l),h.lineTo(l,c-l)):e?(a=_.options.closeButtonOffset,n=r[0],i%2!==0&&(a=[a[1],a[0]],n=r[1]),o=Math.acos(a[1]/_.options.closeButtonRadius),s=Math.acos(a[0]/_.options.closeButtonRadius),h.lineTo(-n+l,-l),h.arc(l-a[0],-l+a[1],_.options.closeButtonRadius,-(Math.PI/2+o),s,!1)):(h.lineTo(-_.options.borderRadius+l,-l),h.quadraticCurveTo(l,-l,l,_.options.borderRadius-l))},h.translate(-s[0],-s[1]),h.save(),function(){var e,i,o,s,r,a,l,u,c,g,f;for(f=[],i=c=0,g=t.positions.length/2;g>=0?g>c:c>g;i=g>=0?++c:--c)r=i*2,a=i===0||i===3?0:_.dimensions.width,l=2>i?0:_.dimensions.height,u=Math.PI/2*i,o=i%2===0?_.dimensions.width:_.dimensions.height,s=new t.Joint(t.positions[r]),e=new t.Joint(t.positions[r+1]),h.save(),h.translate(a,l),h.rotate(u),d(o,s.eql(_.currentStem),i===0),h.translate(o,0),p(e.eql(_.currentStem),e.eql(n),i),f.push(h.restore());return f}(),h.closePath(),h.save(),this.options.shadow&&(h.shadowColor=this.options.shadowColor,h.shadowBlur=this.options.shadowBlur,h.shadowOffsetX=this.options.shadowOffset[0],h.shadowOffsetY=this.options.shadowOffset[1]),h.fill(),h.restore(),this.options.borderWidth&&h.stroke(),h.restore(),n?function(){var t,e,i,o,s;return i=e=_.options.closeButtonRadius*2,n+""=="top right"?(s=[_.dimensions.width-_.options.closeButtonOffset[0],_.options.closeButtonOffset[1]],t=[s[0]+l,s[1]-l]):(s=[_.options.closeButtonOffset[0],_.options.closeButtonOffset[1]],t=[s[0]-l,s[1]-l]),h.translate(t[0],t[1]),o=_.options.closeButtonCrossSize/2,h.save(),h.beginPath(),h.strokeStyle=_.options.closeButtonCrossColor,h.lineWidth=_.options.closeButtonCrossLineWidth,h.lineCap="round",h.moveTo(-o,-o),h.lineTo(o,o),h.stroke(),h.beginPath(),h.moveTo(o,-o),h.lineTo(-o,o),h.stroke(),h.restore(),_.adapter.css(_.closeButtonElement,{left:""+(s[0]-o-_.options.closeButtonLinkOverscan)+"px",top:""+(s[1]-o-_.options.closeButtonLinkOverscan)+"px",width:""+(_.options.closeButtonCrossSize+_.options.closeButtonLinkOverscan*2)+"px",height:""+(_.options.closeButtonCrossSize+_.options.closeButtonLinkOverscan*2)+"px"})}():void 0}},t.prototype._getPathStemMeasures=function(t,e,i){var o,s,n,r,a,h,p;if(r=i/2,n=Math.atan(t/2/e),o=n*2,a=r/Math.sin(o),s=2*a*Math.cos(n),p=r+e-s,0>p)throw Error("Sorry but your stemLength / stemBase ratio is strange.");return h=Math.tan(n)*p*2,{stemLength:p,stemBase:h}},t.prototype._getColor=function(t,e,i,o){var s,n,r,a,h;if(o==null&&(o=!1),typeof i=="string")return i;for(n=o?t.createLinearGradient(0,0,e.width,0):t.createLinearGradient(0,0,0,e.height),r=a=0,h=i.length;h>a;r=++a)s=i[r],n.addColorStop(s[0],s[1]);return n},t.prototype._searchAndActivateCloseButtons=function(){var t,e,i,o;for(o=this.adapter.findAll(this.container,"."+this["class"].close),e=0,i=o.length;i>e;e++)t=o[e],this.hideTriggers.push({element:this.adapter.wrap(t),event:"click"});return this.currentObservers.showing&&this._setupObservers("-showing","showing"),this.currentObservers.visible?this._setupObservers("-visible","visible"):void 0},t.prototype._activateFirstInput=function(){var t;return t=this.adapter.unwrap(this.adapter.find(this.container,"input, textarea")),t!=null?typeof t.focus=="function"?t.focus():void 0:void 0},t.prototype._followMousePosition=function(){return this.options.fixed?void 0:t._observeMousePosition(this.bound.reposition)},t.prototype._stopFollowingMousePosition=function(){return this.options.fixed?void 0:t._stopObservingMousePosition(this.bound.reposition)},t.prototype._clearShowTimeout=function(){return clearTimeout(this._showTimeoutId)},t.prototype._clearHideTimeout=function(){return clearTimeout(this._hideTimeoutId)},t.prototype._clearTimeouts=function(){return clearTimeout(this._visibilityStateTimeoutId),this._clearShowTimeout(),this._clearHideTimeout()},t.prototype._triggerElementExists=function(){var t;t=this.adapter.unwrap(this.triggerElement);while(t.parentNode){if(t.parentNode.tagName==="BODY")return!0;t=t.parentNode}return!1},t.prototype._loadAjax=function(){var t=this;if(!this.loading)return this.loaded=!1,this.loading=!0,this.adapter.addClass(this.container,this["class"].loading),this.setContent(""),this.debug("Loading content from "+this.options.ajax),this.adapter.ajax({url:this.options.ajax,method:this.options.ajaxMethod,onSuccess:function(e){return t.debug("Loading successful."),t.adapter.removeClass(t.container,t["class"].loading),t.setContent(e)},onError:function(e){var i;return i=t.options.ajaxErrorMessage,t.debug(i,e),t.setContent(i),t.adapter.addClass(t.container,t["class"].ajaxError)},onComplete:function(){return t.adapter.removeClass(t.container,t["class"].loading),t.loading=!1,t.loaded=!0,t._searchAndActivateCloseButtons(),t._activateFirstInput(),t.reposition()}})},t.prototype._ensureTriggerElement=function(){return this._triggerElementExists()?void 0:(this.deactivate(),this._stopEnsureTriggerElement())},t.prototype._ensureTriggerElementInterval=1e3,t.prototype._startEnsureTriggerElement=function(){var t=this;return this._ensureTriggerElementTimeoutId=setInterval(function(){return t._ensureTriggerElement()},this._ensureTriggerElementInterval)},t.prototype._stopEnsureTriggerElement=function(){return clearInterval(this._ensureTriggerElementTimeoutId)},t}(),vendors=["khtml","ms","o","moz","webkit"],Opentip.prototype.setCss3Style=function(t,e){var i,o,s,n,r;t=this.adapter.unwrap(t),r=[];for(i in e)__hasProp.call(e,i)&&(o=e[i],t.style[i]!=null?r.push(t.style[i]=o):r.push(function(){var e,r,a;for(a=[],e=0,r=vendors.length;r>e;e++)s=vendors[e],n=""+this.ucfirst(s)+this.ucfirst(i),t.style[n]!=null?a.push(t.style[n]=o):a.push(void 0);return a}.call(this)));return r},Opentip.prototype.defer=function(t){return setTimeout(t,0)},Opentip.prototype.setTimeout=function(t,e){return setTimeout(t,e?e*1e3:0)},Opentip.prototype.ucfirst=function(t){return t==null?"":t.charAt(0).toUpperCase()+t.slice(1)},Opentip.prototype.dasherize=function(t){return t.replace(/([A-Z])/g,function(t,e){return"-"+e.toLowerCase()})},mousePositionObservers=[],mousePosition={x:0,y:0},mouseMoved=function(t){var e,i,o,s;for(mousePosition=Opentip.adapter.mousePosition(t),s=[],i=0,o=mousePositionObservers.length;o>i;i++)e=mousePositionObservers[i],s.push(e());return s},Opentip.followMousePosition=function(){return Opentip.adapter.observe(document.body,"mousemove",mouseMoved)},Opentip._observeMousePosition=function(t){return mousePositionObservers.push(t)},Opentip._stopObservingMousePosition=function(t){var e;return mousePositionObservers=function(){var i,o,s;for(s=[],i=0,o=mousePositionObservers.length;o>i;i++)e=mousePositionObservers[i],e!==t&&s.push(e);return s}()},Opentip.Joint=function(){function t(t){t!=null&&(t instanceof Opentip.Joint&&(t+=""),this.set(t))}return t.prototype.set=function(t){return t=t.toLowerCase(),this.setHorizontal(t),this.setVertical(t),this},t.prototype.setHorizontal=function(t){var e,i,o,s,n,r,a;for(i=["left","center","right"],o=0,n=i.length;n>o;o++)e=i[o],~t.indexOf(e)&&(this.horizontal=e.toLowerCase());for(this.horizontal==null&&(this.horizontal="center"),a=[],s=0,r=i.length;r>s;s++)e=i[s],a.push(this[e]=this.horizontal===e?e:void 0);return a},t.prototype.setVertical=function(t){var e,i,o,s,n,r,a;for(i=["top","middle","bottom"],o=0,n=i.length;n>o;o++)e=i[o],~t.indexOf(e)&&(this.vertical=e.toLowerCase());for(this.vertical==null&&(this.vertical="middle"),a=[],s=0,r=i.length;r>s;s++)e=i[s],a.push(this[e]=this.vertical===e?e:void 0);return a},t.prototype.eql=function(t){return t!=null&&this.horizontal===t.horizontal&&this.vertical===t.vertical},t.prototype.flip=function(){var t,e;return e=Opentip.position[this.toString(!0)],t=(e+4)%8,this.set(Opentip.positions[t]),this},t.prototype.toString=function(t){var e,i;return t==null&&(t=!1),i=this.vertical==="middle"?"":this.vertical,e=this.horizontal==="center"?"":this.horizontal,i&&e&&(e=t?Opentip.prototype.ucfirst(e):" "+e),""+i+e},t}(),Opentip.prototype._positionsEqual=function(t,e){return t!=null&&e!=null&&t.left===e.left&&t.top===e.top},Opentip.prototype._dimensionsEqual=function(t,e){return t!=null&&e!=null&&t.width===e.width&&t.height===e.height},Opentip.prototype.debug=function(){var t;return t=arguments.length>=1?__slice.call(arguments,0):[],Opentip.debug&&(typeof console!="undefined"&&console!==null?console.debug:void 0)!=null?(t.unshift("#"+this.id+" |"),console.debug.apply(console,t)):void 0},Opentip.findElements=function(){var t,e,i,o,s,n,r,a,h,p;for(t=Opentip.adapter,h=t.findAll(document.body,"[data-ot]"),p=[],r=0,a=h.length;a>r;r++){i=h[r],n={},e=t.data(i,"ot"),(e===""||e==="true"||e==="yes")&&(e=t.attr(i,"title"),t.attr(i,"title","")),e=e||"";for(o in Opentip.styles.standard)s=t.data(i,"ot"+Opentip.prototype.ucfirst(o)),s!=null&&(s==="yes"||s==="true"||s==="on"?s=!0:(s==="no"||s==="false"||s==="off")&&(s=!1),n[o]=s);p.push(new Opentip(i,e,n))}return p},Opentip.version="2.4.6",Opentip.debug=!1,Opentip.lastId=0,Opentip.lastZIndex=100,Opentip.tips=[],Opentip._abortShowingGroup=function(t,e){var i,o,s,n,r;for(n=Opentip.tips,r=[],o=0,s=n.length;s>o;o++)i=n[o],i!==e&&i.options.group===t?r.push(i._abortShowing()):r.push(void 0);return r},Opentip._hideGroup=function(t,e){var i,o,s,n,r;for(n=Opentip.tips,r=[],o=0,s=n.length;s>o;o++)i=n[o],i!==e&&i.options.group===t?r.push(i.hide()):r.push(void 0);return r},Opentip.adapters={},Opentip.adapter=null,firstAdapter=!0,Opentip.addAdapter=function(t){return Opentip.adapters[t.name]=t,firstAdapter?(Opentip.adapter=t,t.domReady(Opentip.findElements),t.domReady(Opentip.followMousePosition),firstAdapter=!1):void 0},Opentip.positions=["top","topRight","right","bottomRight","bottom","bottomLeft","left","topLeft"],Opentip.position={},_ref=Opentip.positions,i=_i=0,_len=_ref.length;_len>_i;i=++_i)position=_ref[i],Opentip.position[position]=i;Opentip.styles={standard:{"extends":null,title:void 0,escapeTitle:!0,escapeContent:!1,className:"standard",stem:!0,delay:null,hideDelay:.1,fixed:!1,showOn:"mouseover",hideTrigger:"trigger",hideTriggers:[],hideOn:null,removeElementsOnHide:!1,offset:[0,0],containInViewport:!0,autoOffset:!0,showEffect:"appear",hideEffect:"fade",showEffectDuration:.3,hideEffectDuration:.2,stemLength:5,stemBase:8,tipJoint:"top left",target:null,targetJoint:null,cache:!0,ajax:!1,ajaxMethod:"GET",ajaxErrorMessage:"There was a problem downloading the content.",group:null,style:null,background:"#fff18f",backgroundGradientHorizontal:!1,closeButtonOffset:[5,5],closeButtonRadius:7,closeButtonCrossSize:4,closeButtonCrossColor:"#d2c35b",closeButtonCrossLineWidth:1.5,closeButtonLinkOverscan:6,borderRadius:5,borderWidth:1,borderColor:"#f2e37b",shadow:!0,shadowBlur:10,shadowOffset:[3,3],shadowColor:"rgba(0, 0, 0, 0.1)"},glass:{"extends":"standard",className:"glass",background:[[0,"rgba(252, 252, 252, 0.8)"],[.5,"rgba(255, 255, 255, 0.8)"],[.5,"rgba(250, 250, 250, 0.9)"],[1,"rgba(245, 245, 245, 0.9)"]],borderColor:"#eee",closeButtonCrossColor:"rgba(0, 0, 0, 0.2)",borderRadius:15,closeButtonRadius:10,closeButtonOffset:[8,8]},dark:{"extends":"standard",className:"dark",borderRadius:13,borderColor:"#444",closeButtonCrossColor:"rgba(240, 240, 240, 1)",shadowColor:"rgba(0, 0, 0, 0.3)",shadowOffset:[2,2],background:[[0,"rgba(30, 30, 30, 0.7)"],[.5,"rgba(30, 30, 30, 0.8)"],[.5,"rgba(10, 10, 10, 0.8)"],[1,"rgba(10, 10, 10, 0.9)"]]},alert:{"extends":"standard",className:"alert",borderRadius:1,borderColor:"#AE0D11",closeButtonCrossColor:"rgba(255, 255, 255, 1)",shadowColor:"rgba(0, 0, 0, 0.3)",shadowOffset:[2,2],background:[[0,"rgba(203, 15, 19, 0.7)"],[.5,"rgba(203, 15, 19, 0.8)"],[.5,"rgba(189, 14, 18, 0.8)"],[1,"rgba(179, 14, 17, 0.9)"]]}},Opentip.defaultStyle="standard",typeof module!="undefined"&&module!==null?module.exports=Opentip:window.Opentip=Opentip;var __slice=[].slice;(function(t){var e;return t.fn.opentip=function(t,e,i){return new Opentip(this,t,e,i)},e=function(){function e(){}return e.prototype.name="jquery",e.prototype.domReady=function(e){return t(e)},e.prototype.create=function(e){return t(e)},e.prototype.wrap=function(e){if(e=t(e),e.length>1)throw Error("Multiple elements provided.");return e},e.prototype.unwrap=function(e){return t(e)[0]
+++},e.prototype.tagName=function(t){return this.unwrap(t).tagName},e.prototype.attr=function(){var e,i,o;return i=arguments[0],e=arguments.length>=2?__slice.call(arguments,1):[],(o=t(i)).attr.apply(o,e)},e.prototype.data=function(){var e,i,o;return i=arguments[0],e=arguments.length>=2?__slice.call(arguments,1):[],(o=t(i)).data.apply(o,e)},e.prototype.find=function(e,i){return t(e).find(i).get(0)},e.prototype.findAll=function(e,i){return t(e).find(i)},e.prototype.update=function(e,i,o){return e=t(e),o?e.text(i):e.html(i)},e.prototype.append=function(e,i){return t(e).append(i)},e.prototype.remove=function(e){return t(e).remove()},e.prototype.addClass=function(e,i){return t(e).addClass(i)},e.prototype.removeClass=function(e,i){return t(e).removeClass(i)},e.prototype.css=function(e,i){return t(e).css(i)},e.prototype.dimensions=function(e){return{width:t(e).outerWidth(),height:t(e).outerHeight()}},e.prototype.scrollOffset=function(){return[window.pageXOffset||document.documentElement.scrollLeft||document.body.scrollLeft,window.pageYOffset||document.documentElement.scrollTop||document.body.scrollTop]},e.prototype.viewportDimensions=function(){return{width:document.documentElement.clientWidth,height:document.documentElement.clientHeight}},e.prototype.mousePosition=function(t){return t==null?null:{x:t.pageX,y:t.pageY}},e.prototype.offset=function(e){var i;return i=t(e).offset(),{left:i.left,top:i.top}},e.prototype.observe=function(e,i,o){return t(e).bind(i,o)},e.prototype.stopObserving=function(e,i,o){return t(e).unbind(i,o)},e.prototype.ajax=function(e){var i,o;if(e.url==null)throw Error("No url provided");return t.ajax({url:e.url,type:(i=(o=e.method)!=null?o.toUpperCase():void 0)!=null?i:"GET"}).done(function(t){return typeof e.onSuccess=="function"?e.onSuccess(t):void 0}).fail(function(t){return typeof e.onError=="function"?e.onError("Server responded with status "+t.status):void 0}).always(function(){return typeof e.onComplete=="function"?e.onComplete():void 0})},e.prototype.clone=function(e){return t.extend({},e)},e.prototype.extend=function(){var e,i;return i=arguments[0],e=arguments.length>=2?__slice.call(arguments,1):[],t.extend.apply(t,[i].concat(__slice.call(e)))},e}(),Opentip.addAdapter(new e)})(jQuery)});
++\ No newline at end of file
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/styles/BBOOTS/theme/opentip.css" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/styles/BBOOTS/theme/opentip.css"
++new file mode 100644
++index 000000000..5088f37a0
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/styles/BBOOTS/theme/opentip.css"
++@@ -0,0 +1,278 @@
+++.opentip-container,
+++.opentip-container * {
+++  -webkit-box-sizing: border-box;
+++  -moz-box-sizing: border-box;
+++  box-sizing: border-box;
+++}
+++.opentip-container {
+++  position: absolute;
+++  max-width: 300px;
+++  z-index: 100;
+++  -webkit-transition: -webkit-transform 1s ease-in-out;
+++  -moz-transition: -moz-transform 1s ease-in-out;
+++  -o-transition: -o-transform 1s ease-in-out;
+++  -ms-transition: -ms-transform 1s ease-in-out;
+++  transition: transform 1s ease-in-out;
+++  pointer-events: none;
+++  -webkit-transform: translateX(0) translateY(0);
+++  -moz-transform: translateX(0) translateY(0);
+++  -o-transform: translateX(0) translateY(0);
+++  -ms-transform: translateX(0) translateY(0);
+++  transform: translateX(0) translateY(0);
+++}
+++.opentip-container.ot-fixed.ot-hidden.stem-top.stem-center,
+++.opentip-container.ot-fixed.ot-going-to-show.stem-top.stem-center,
+++.opentip-container.ot-fixed.ot-hiding.stem-top.stem-center {
+++  -webkit-transform: translateY(-5px);
+++  -moz-transform: translateY(-5px);
+++  -o-transform: translateY(-5px);
+++  -ms-transform: translateY(-5px);
+++  transform: translateY(-5px);
+++}
+++.opentip-container.ot-fixed.ot-hidden.stem-top.stem-right,
+++.opentip-container.ot-fixed.ot-going-to-show.stem-top.stem-right,
+++.opentip-container.ot-fixed.ot-hiding.stem-top.stem-right {
+++  -webkit-transform: translateY(-5px) translateX(5px);
+++  -moz-transform: translateY(-5px) translateX(5px);
+++  -o-transform: translateY(-5px) translateX(5px);
+++  -ms-transform: translateY(-5px) translateX(5px);
+++  transform: translateY(-5px) translateX(5px);
+++}
+++.opentip-container.ot-fixed.ot-hidden.stem-middle.stem-right,
+++.opentip-container.ot-fixed.ot-going-to-show.stem-middle.stem-right,
+++.opentip-container.ot-fixed.ot-hiding.stem-middle.stem-right {
+++  -webkit-transform: translateX(5px);
+++  -moz-transform: translateX(5px);
+++  -o-transform: translateX(5px);
+++  -ms-transform: translateX(5px);
+++  transform: translateX(5px);
+++}
+++.opentip-container.ot-fixed.ot-hidden.stem-bottom.stem-right,
+++.opentip-container.ot-fixed.ot-going-to-show.stem-bottom.stem-right,
+++.opentip-container.ot-fixed.ot-hiding.stem-bottom.stem-right {
+++  -webkit-transform: translateY(5px) translateX(5px);
+++  -moz-transform: translateY(5px) translateX(5px);
+++  -o-transform: translateY(5px) translateX(5px);
+++  -ms-transform: translateY(5px) translateX(5px);
+++  transform: translateY(5px) translateX(5px);
+++}
+++.opentip-container.ot-fixed.ot-hidden.stem-bottom.stem-center,
+++.opentip-container.ot-fixed.ot-going-to-show.stem-bottom.stem-center,
+++.opentip-container.ot-fixed.ot-hiding.stem-bottom.stem-center {
+++  -webkit-transform: translateY(5px);
+++  -moz-transform: translateY(5px);
+++  -o-transform: translateY(5px);
+++  -ms-transform: translateY(5px);
+++  transform: translateY(5px);
+++}
+++.opentip-container.ot-fixed.ot-hidden.stem-bottom.stem-left,
+++.opentip-container.ot-fixed.ot-going-to-show.stem-bottom.stem-left,
+++.opentip-container.ot-fixed.ot-hiding.stem-bottom.stem-left {
+++  -webkit-transform: translateY(5px) translateX(-5px);
+++  -moz-transform: translateY(5px) translateX(-5px);
+++  -o-transform: translateY(5px) translateX(-5px);
+++  -ms-transform: translateY(5px) translateX(-5px);
+++  transform: translateY(5px) translateX(-5px);
+++}
+++.opentip-container.ot-fixed.ot-hidden.stem-middle.stem-left,
+++.opentip-container.ot-fixed.ot-going-to-show.stem-middle.stem-left,
+++.opentip-container.ot-fixed.ot-hiding.stem-middle.stem-left {
+++  -webkit-transform: translateX(-5px);
+++  -moz-transform: translateX(-5px);
+++  -o-transform: translateX(-5px);
+++  -ms-transform: translateX(-5px);
+++  transform: translateX(-5px);
+++}
+++.opentip-container.ot-fixed.ot-hidden.stem-top.stem-left,
+++.opentip-container.ot-fixed.ot-going-to-show.stem-top.stem-left,
+++.opentip-container.ot-fixed.ot-hiding.stem-top.stem-left {
+++  -webkit-transform: translateY(-5px) translateX(-5px);
+++  -moz-transform: translateY(-5px) translateX(-5px);
+++  -o-transform: translateY(-5px) translateX(-5px);
+++  -ms-transform: translateY(-5px) translateX(-5px);
+++  transform: translateY(-5px) translateX(-5px);
+++}
+++.opentip-container.ot-fixed .opentip {
+++  pointer-events: auto;
+++}
+++.opentip-container.ot-hidden {
+++  display: none;
+++}
+++.opentip-container .opentip {
+++  position: relative;
+++  font-size: 13px;
+++  line-height: 120%;
+++  padding: 9px 14px;
+++  color: #4f4b47;
+++  text-shadow: -1px -1px 0px rgba(255,255,255,0.2);
+++}
+++.opentip-container .opentip .header {
+++  margin: 0;
+++  padding: 0;
+++}
+++.opentip-container .opentip .ot-close {
+++  pointer-events: auto;
+++  display: block;
+++  position: absolute;
+++  top: -12px;
+++  left: 60px;
+++  color: rgba(0,0,0,0.5);
+++  background: rgba(0,0,0,0);
+++  text-decoration: none;
+++}
+++.opentip-container .opentip .ot-close span {
+++  display: none;
+++}
+++.opentip-container .opentip .ot-loading-indicator {
+++  display: none;
+++}
+++.opentip-container.ot-loading .ot-loading-indicator {
+++  width: 30px;
+++  height: 30px;
+++  font-size: 30px;
+++  line-height: 30px;
+++  font-weight: bold;
+++  display: block;
+++}
+++.opentip-container.ot-loading .ot-loading-indicator span {
+++  display: block;
+++  -webkit-animation: otloading 2s linear infinite;
+++  -moz-animation: otloading 2s linear infinite;
+++  -o-animation: otloading 2s linear infinite;
+++  -ms-animation: otloading 2s linear infinite;
+++  animation: otloading 2s linear infinite;
+++  text-align: center;
+++}
+++.opentip-container.style-dark .opentip,
+++.opentip-container.style-alert .opentip {
+++  color: #f8f8f8;
+++  text-shadow: 1px 1px 0px rgba(0,0,0,0.2);
+++}
+++.opentip-container.style-glass .opentip {
+++  padding: 15px 25px;
+++  color: #317cc5;
+++  text-shadow: 1px 1px 8px rgba(0,94,153,0.3);
+++}
+++.opentip-container.ot-hide-effect-fade {
+++  -webkit-transition: -webkit-transform 0.5s ease-in-out, opacity 1s ease-in-out;
+++  -moz-transition: -moz-transform 0.5s ease-in-out, opacity 1s ease-in-out;
+++  -o-transition: -o-transform 0.5s ease-in-out, opacity 1s ease-in-out;
+++  -ms-transition: -ms-transform 0.5s ease-in-out, opacity 1s ease-in-out;
+++  transition: transform 0.5s ease-in-out, opacity 1s ease-in-out;
+++  opacity: 1;
+++  -ms-filter: none;
+++  filter: none;
+++}
+++.opentip-container.ot-hide-effect-fade.ot-hiding {
+++  opacity: 0;
+++  filter: alpha(opacity=0);
+++  -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";
+++}
+++.opentip-container.ot-show-effect-appear.ot-going-to-show,
+++.opentip-container.ot-show-effect-appear.ot-showing {
+++  -webkit-transition: -webkit-transform 0.5s ease-in-out, opacity 1s ease-in-out;
+++  -moz-transition: -moz-transform 0.5s ease-in-out, opacity 1s ease-in-out;
+++  -o-transition: -o-transform 0.5s ease-in-out, opacity 1s ease-in-out;
+++  -ms-transition: -ms-transform 0.5s ease-in-out, opacity 1s ease-in-out;
+++  transition: transform 0.5s ease-in-out, opacity 1s ease-in-out;
+++}
+++.opentip-container.ot-show-effect-appear.ot-going-to-show {
+++  opacity: 0;
+++  filter: alpha(opacity=0);
+++  -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";
+++}
+++.opentip-container.ot-show-effect-appear.ot-showing {
+++  opacity: 1;
+++  -ms-filter: none;
+++  filter: none;
+++}
+++.opentip-container.ot-show-effect-appear.ot-visible {
+++  opacity: 1;
+++  -ms-filter: none;
+++  filter: none;
+++}
+++@-moz-keyframes otloading {
+++  0% {
+++    -webkit-transform: rotate(0deg);
+++    -moz-transform: rotate(0deg);
+++    -o-transform: rotate(0deg);
+++    -ms-transform: rotate(0deg);
+++    transform: rotate(0deg);
+++  }
+++
+++  100% {
+++    -webkit-transform: rotate(360deg);
+++    -moz-transform: rotate(360deg);
+++    -o-transform: rotate(360deg);
+++    -ms-transform: rotate(360deg);
+++    transform: rotate(360deg);
+++  }
+++}
+++@-webkit-keyframes otloading {
+++  0% {
+++    -webkit-transform: rotate(0deg);
+++    -moz-transform: rotate(0deg);
+++    -o-transform: rotate(0deg);
+++    -ms-transform: rotate(0deg);
+++    transform: rotate(0deg);
+++  }
+++
+++  100% {
+++    -webkit-transform: rotate(360deg);
+++    -moz-transform: rotate(360deg);
+++    -o-transform: rotate(360deg);
+++    -ms-transform: rotate(360deg);
+++    transform: rotate(360deg);
+++  }
+++}
+++@-o-keyframes otloading {
+++  0% {
+++    -webkit-transform: rotate(0deg);
+++    -moz-transform: rotate(0deg);
+++    -o-transform: rotate(0deg);
+++    -ms-transform: rotate(0deg);
+++    transform: rotate(0deg);
+++  }
+++
+++  100% {
+++    -webkit-transform: rotate(360deg);
+++    -moz-transform: rotate(360deg);
+++    -o-transform: rotate(360deg);
+++    -ms-transform: rotate(360deg);
+++    transform: rotate(360deg);
+++  }
+++}
+++@-ms-keyframes otloading {
+++  0% {
+++    -webkit-transform: rotate(0deg);
+++    -moz-transform: rotate(0deg);
+++    -o-transform: rotate(0deg);
+++    -ms-transform: rotate(0deg);
+++    transform: rotate(0deg);
+++  }
+++
+++  100% {
+++    -webkit-transform: rotate(360deg);
+++    -moz-transform: rotate(360deg);
+++    -o-transform: rotate(360deg);
+++    -ms-transform: rotate(360deg);
+++    transform: rotate(360deg);
+++  }
+++}
+++@keyframes otloading {
+++  0% {
+++    -webkit-transform: rotate(0deg);
+++    -moz-transform: rotate(0deg);
+++    -o-transform: rotate(0deg);
+++    -ms-transform: rotate(0deg);
+++    transform: rotate(0deg);
+++  }
+++
+++  100% {
+++    -webkit-transform: rotate(360deg);
+++    -moz-transform: rotate(360deg);
+++    -o-transform: rotate(360deg);
+++    -ms-transform: rotate(360deg);
+++    transform: rotate(360deg);
+++  }
+++}
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/styles/FLATBOOTS/template/event/overall_footer_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/styles/FLATBOOTS/template/event/overall_footer_after.html"
++new file mode 100644
++index 000000000..af2f53c91
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/styles/FLATBOOTS/template/event/overall_footer_after.html"
++@@ -0,0 +1,14 @@
+++{% if S_TOPIC_IMAGE_PREVIEW %}
+++	{% if not definition.INCLUDED_OPENTIPJS %}
+++		{% INCLUDEJS '@vse_topicimagepreview/js/opentip-jquery.min.js' %}
+++		{% DEFINE INCLUDED_OPENTIPJS = true %}
+++	{% endif %}
+++
+++	<script>
+++		head.ready(function () {
+++			$(function() {
+++				$("[data-ot]").closest("dt").removeAttr("title");
+++			});
+++		});
+++	</script>
+++{% endif %}
++\ No newline at end of file
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/styles/FLATBOOTS/template/event/overall_header_stylesheets_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/styles/FLATBOOTS/template/event/overall_header_stylesheets_after.html"
++new file mode 100644
++index 000000000..082e4a3aa
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/styles/FLATBOOTS/template/event/overall_header_stylesheets_after.html"
++@@ -0,0 +1,14 @@
+++{% if S_TOPIC_IMAGE_PREVIEW %}
+++	{% INCLUDECSS '@vse_topicimagepreview/opentip.css' %}
+++	<style>
+++		.opentip-container {
+++			max-width: 1000px;
+++			white-space: nowrap;
+++		}
+++		.ot-content > img {
+++			max-width: {{ TOPIC_IMAGE_PREVIEW_DIM_MAX }}px;
+++			max-height: {{ TOPIC_IMAGE_PREVIEW_DIM_MAX }}px;
+++			vertical-align: top;
+++		}
+++	</style>
+++{% endif %}
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/styles/FLATBOOTS/template/event/topiclist_row_prepend.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/styles/FLATBOOTS/template/event/topiclist_row_prepend.html"
++new file mode 100644
++index 000000000..318af77c2
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/styles/FLATBOOTS/template/event/topiclist_row_prepend.html"
++@@ -0,0 +1,23 @@
+++{# display in view forum #}
+++{% if topicrow.TOPIC_IMAGES %}
+++	{% set preview = topicrow %}
+++{% endif %}
+++
+++{# display in search results #}
+++{% if searchresults.TOPIC_IMAGES %}
+++	{% set preview = searchresults %}
+++{% endif %}
+++
+++{# display in Similar Topics extension #}
+++{% if similar.TOPIC_IMAGES %}
+++	{% set preview = similar %}
+++{% endif %}
+++
+++<span{% if preview.TOPIC_IMAGES %}
+++	data-ot="{% for image in preview.TOPIC_IMAGES %}<img src='/forum/app.php/gallery/image/{{ image }}/source' alt='{{ lang('IMAGE') }}' style='max-width:{preview.TOPIC_IMAGES_SIZE_MAX}px; max-height:{preview.TOPIC_IMAGES_SIZE_MAX}px;'>&nbsp;{% endfor %}"
+++	data-ot-group="topics"
+++	data-ot-background="transparent"
+++	data-ot-border-width="0"
+++	data-ot-border-radius="0"{% endif %}>
+++{% if preview.TOPIC_IMAGES %}<div style="float:left;padding-right:10px;">{% for image in preview.TOPIC_IMAGES %}<img src="/forum/app.php/gallery/image/{{ image }}/mini" alt="{{ lang('IMAGE') }}" style="max-width:{preview.TOPIC_IMAGES_SIZE_MIN}px; max-height:{preview.TOPIC_IMAGES_SIZE_MIN}px;">&nbsp;{% endfor %}</div>{% endif %}
+++</span>
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/styles/FLATBOOTS/template/event/ucp_prefs_view_radio_buttons_append.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/styles/FLATBOOTS/template/event/ucp_prefs_view_radio_buttons_append.html"
++new file mode 100644
++index 000000000..9d7eab75d
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/styles/FLATBOOTS/template/event/ucp_prefs_view_radio_buttons_append.html"
++@@ -0,0 +1,9 @@
+++{% if S_VSE_TIP_NUM %}
+++	<dl>
+++		<dt><label for="user_vse_tip1">{{ lang('DISPLAY_TOPIC_IMAGE_PREVIEWS') ~ lang('COLON') }}</label></dt>
+++		<dd>
+++			<label for="user_vse_tip1"><input type="radio" name="user_vse_tip" id="user_vse_tip1" value="1"{% if S_VSE_TIP_USER %} checked="checked"{% endif %} /> {{ lang('YES') }}</label>
+++			<label for="user_vse_tip0"><input type="radio" name="user_vse_tip" id="user_vse_tip0" value="0"{% if not S_VSE_TIP_USER %} checked="checked"{% endif %} /> {{ lang('NO') }}</label>
+++		</dd>
+++	</dl>
+++{% endif %}
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/styles/FLATBOOTS/template/js/opentip-jquery.js" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/styles/FLATBOOTS/template/js/opentip-jquery.js"
++new file mode 100644
++index 000000000..ddfb9a8d9
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/styles/FLATBOOTS/template/js/opentip-jquery.js"
++@@ -0,0 +1,1794 @@
+++// Generated by CoffeeScript 1.4.0
+++/*
+++#
+++# Opentip v2.4.6
+++#
+++# More info at [www.opentip.org](http://www.opentip.org)
+++# 
+++# Copyright (c) 2012, Matias Meno  
+++# Graphics by Tjandra Mayerhold
+++# 
+++# Permission is hereby granted, free of charge, to any person obtaining a copy
+++# of this software and associated documentation files (the "Software"), to deal
+++# in the Software without restriction, including without limitation the rights
+++# to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
+++# copies of the Software, and to permit persons to whom the Software is
+++# furnished to do so, subject to the following conditions:
+++# 
+++# The above copyright notice and this permission notice shall be included in
+++# all copies or substantial portions of the Software.
+++# 
+++# THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
+++# IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
+++# FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
+++# AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
+++# LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
+++# OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
+++# THE SOFTWARE.
+++#
+++*/
+++head.ready(function () {
+++var Opentip, firstAdapter, i, mouseMoved, mousePosition, mousePositionObservers, position, vendors, _i, _len, _ref,
+++  __slice = [].slice,
+++  __indexOf = [].indexOf || function(item) { for (var i = 0, l = this.length; i < l; i++) { if (i in this && this[i] === item) return i; } return -1; },
+++  __hasProp = {}.hasOwnProperty;
+++
+++Opentip = (function() {
+++
+++  Opentip.prototype.STICKS_OUT_TOP = 1;
+++
+++  Opentip.prototype.STICKS_OUT_BOTTOM = 2;
+++
+++  Opentip.prototype.STICKS_OUT_LEFT = 1;
+++
+++  Opentip.prototype.STICKS_OUT_RIGHT = 2;
+++
+++  Opentip.prototype["class"] = {
+++    container: "opentip-container",
+++    opentip: "opentip",
+++    header: "ot-header",
+++    content: "ot-content",
+++    loadingIndicator: "ot-loading-indicator",
+++    close: "ot-close",
+++    goingToHide: "ot-going-to-hide",
+++    hidden: "ot-hidden",
+++    hiding: "ot-hiding",
+++    goingToShow: "ot-going-to-show",
+++    showing: "ot-showing",
+++    visible: "ot-visible",
+++    loading: "ot-loading",
+++    ajaxError: "ot-ajax-error",
+++    fixed: "ot-fixed",
+++    showEffectPrefix: "ot-show-effect-",
+++    hideEffectPrefix: "ot-hide-effect-",
+++    stylePrefix: "style-"
+++  };
+++
+++  function Opentip(element, content, title, options) {
+++    var elementsOpentips, hideTrigger, methodToBind, optionSources, prop, styleName, _i, _j, _len, _len1, _ref, _ref1, _ref2, _tmpStyle,
+++      _this = this;
+++    this.id = ++Opentip.lastId;
+++    this.debug("Creating Opentip.");
+++    Opentip.tips.push(this);
+++    this.adapter = Opentip.adapter;
+++    elementsOpentips = this.adapter.data(element, "opentips") || [];
+++    elementsOpentips.push(this);
+++    this.adapter.data(element, "opentips", elementsOpentips);
+++    this.triggerElement = this.adapter.wrap(element);
+++    if (this.triggerElement.length > 1) {
+++      throw new Error("You can't call Opentip on multiple elements.");
+++    }
+++    if (this.triggerElement.length < 1) {
+++      throw new Error("Invalid element.");
+++    }
+++    this.loaded = false;
+++    this.loading = false;
+++    this.visible = false;
+++    this.waitingToShow = false;
+++    this.waitingToHide = false;
+++    this.currentPosition = {
+++      left: 0,
+++      top: 0
+++    };
+++    this.dimensions = {
+++      width: 100,
+++      height: 50
+++    };
+++    this.content = "";
+++    this.redraw = true;
+++    this.currentObservers = {
+++      showing: false,
+++      visible: false,
+++      hiding: false,
+++      hidden: false
+++    };
+++    options = this.adapter.clone(options);
+++    if (typeof content === "object") {
+++      options = content;
+++      content = title = void 0;
+++    } else if (typeof title === "object") {
+++      options = title;
+++      title = void 0;
+++    }
+++    if (title != null) {
+++      options.title = title;
+++    }
+++    if (content != null) {
+++      this.setContent(content);
+++    }
+++    if (options["extends"] == null) {
+++      if (options.style != null) {
+++        options["extends"] = options.style;
+++      } else {
+++        options["extends"] = Opentip.defaultStyle;
+++      }
+++    }
+++    optionSources = [options];
+++    _tmpStyle = options;
+++    while (_tmpStyle["extends"]) {
+++      styleName = _tmpStyle["extends"];
+++      _tmpStyle = Opentip.styles[styleName];
+++      if (_tmpStyle == null) {
+++        throw new Error("Invalid style: " + styleName);
+++      }
+++      optionSources.unshift(_tmpStyle);
+++      if (!((_tmpStyle["extends"] != null) || styleName === "standard")) {
+++        _tmpStyle["extends"] = "standard";
+++      }
+++    }
+++    options = (_ref = this.adapter).extend.apply(_ref, [{}].concat(__slice.call(optionSources)));
+++    options.hideTriggers = (function() {
+++      var _i, _len, _ref1, _results;
+++      _ref1 = options.hideTriggers;
+++      _results = [];
+++      for (_i = 0, _len = _ref1.length; _i < _len; _i++) {
+++        hideTrigger = _ref1[_i];
+++        _results.push(hideTrigger);
+++      }
+++      return _results;
+++    })();
+++    if (options.hideTrigger && options.hideTriggers.length === 0) {
+++      options.hideTriggers.push(options.hideTrigger);
+++    }
+++    _ref1 = ["tipJoint", "targetJoint", "stem"];
+++    for (_i = 0, _len = _ref1.length; _i < _len; _i++) {
+++      prop = _ref1[_i];
+++      if (options[prop] && typeof options[prop] === "string") {
+++        options[prop] = new Opentip.Joint(options[prop]);
+++      }
+++    }
+++    if (options.ajax && (options.ajax === true || !options.ajax)) {
+++      if (this.adapter.tagName(this.triggerElement) === "A") {
+++        options.ajax = this.adapter.attr(this.triggerElement, "href");
+++      } else {
+++        options.ajax = false;
+++      }
+++    }
+++    if (options.showOn === "click" && this.adapter.tagName(this.triggerElement) === "A") {
+++      this.adapter.observe(this.triggerElement, "click", function(e) {
+++        e.preventDefault();
+++        e.stopPropagation();
+++        return e.stopped = true;
+++      });
+++    }
+++    if (options.target) {
+++      options.fixed = true;
+++    }
+++    if (options.stem === true) {
+++      options.stem = new Opentip.Joint(options.tipJoint);
+++    }
+++    if (options.target === true) {
+++      options.target = this.triggerElement;
+++    } else if (options.target) {
+++      options.target = this.adapter.wrap(options.target);
+++    }
+++    this.currentStem = options.stem;
+++    if (options.delay == null) {
+++      options.delay = options.showOn === "mouseover" ? 0.2 : 0;
+++    }
+++    if (options.targetJoint == null) {
+++      options.targetJoint = new Opentip.Joint(options.tipJoint).flip();
+++    }
+++    this.showTriggers = [];
+++    this.showTriggersWhenVisible = [];
+++    this.hideTriggers = [];
+++    if (options.showOn && options.showOn !== "creation") {
+++      this.showTriggers.push({
+++        element: this.triggerElement,
+++        event: options.showOn
+++      });
+++    }
+++    if (options.ajaxCache != null) {
+++      options.cache = options.ajaxCache;
+++      delete options.ajaxCache;
+++    }
+++    this.options = options;
+++    this.bound = {};
+++    _ref2 = ["prepareToShow", "prepareToHide", "show", "hide", "reposition"];
+++    for (_j = 0, _len1 = _ref2.length; _j < _len1; _j++) {
+++      methodToBind = _ref2[_j];
+++      this.bound[methodToBind] = (function(methodToBind) {
+++        return function() {
+++          return _this[methodToBind].apply(_this, arguments);
+++        };
+++      })(methodToBind);
+++    }
+++    this.adapter.domReady(function() {
+++      _this.activate();
+++      if (_this.options.showOn === "creation") {
+++        return _this.prepareToShow();
+++      }
+++    });
+++  }
+++
+++  Opentip.prototype._setup = function() {
+++    var hideOn, hideTrigger, hideTriggerElement, i, _i, _j, _len, _len1, _ref, _ref1, _results;
+++    this.debug("Setting up the tooltip.");
+++    this._buildContainer();
+++    this.hideTriggers = [];
+++    _ref = this.options.hideTriggers;
+++    for (i = _i = 0, _len = _ref.length; _i < _len; i = ++_i) {
+++      hideTrigger = _ref[i];
+++      hideTriggerElement = null;
+++      hideOn = this.options.hideOn instanceof Array ? this.options.hideOn[i] : this.options.hideOn;
+++      if (typeof hideTrigger === "string") {
+++        switch (hideTrigger) {
+++          case "trigger":
+++            hideOn = hideOn || "mouseout";
+++            hideTriggerElement = this.triggerElement;
+++            break;
+++          case "tip":
+++            hideOn = hideOn || "mouseover";
+++            hideTriggerElement = this.container;
+++            break;
+++          case "target":
+++            hideOn = hideOn || "mouseover";
+++            hideTriggerElement = this.options.target;
+++            break;
+++          case "closeButton":
+++            break;
+++          default:
+++            throw new Error("Unknown hide trigger: " + hideTrigger + ".");
+++        }
+++      } else {
+++        hideOn = hideOn || "mouseover";
+++        hideTriggerElement = this.adapter.wrap(hideTrigger);
+++      }
+++      if (hideTriggerElement) {
+++        this.hideTriggers.push({
+++          element: hideTriggerElement,
+++          event: hideOn,
+++          original: hideTrigger
+++        });
+++      }
+++    }
+++    _ref1 = this.hideTriggers;
+++    _results = [];
+++    for (_j = 0, _len1 = _ref1.length; _j < _len1; _j++) {
+++      hideTrigger = _ref1[_j];
+++      _results.push(this.showTriggersWhenVisible.push({
+++        element: hideTrigger.element,
+++        event: "mouseover"
+++      }));
+++    }
+++    return _results;
+++  };
+++
+++  Opentip.prototype._buildContainer = function() {
+++    this.container = this.adapter.create("<div id=\"opentip-" + this.id + "\" class=\"" + this["class"].container + " " + this["class"].hidden + " " + this["class"].stylePrefix + this.options.className + "\"></div>");
+++    this.adapter.css(this.container, {
+++      position: "absolute"
+++    });
+++    if (this.options.ajax) {
+++      this.adapter.addClass(this.container, this["class"].loading);
+++    }
+++    if (this.options.fixed) {
+++      this.adapter.addClass(this.container, this["class"].fixed);
+++    }
+++    if (this.options.showEffect) {
+++      this.adapter.addClass(this.container, "" + this["class"].showEffectPrefix + this.options.showEffect);
+++    }
+++    if (this.options.hideEffect) {
+++      return this.adapter.addClass(this.container, "" + this["class"].hideEffectPrefix + this.options.hideEffect);
+++    }
+++  };
+++
+++  Opentip.prototype._buildElements = function() {
+++    var headerElement, titleElement;
+++    this.tooltipElement = this.adapter.create("<div class=\"" + this["class"].opentip + "\"><div class=\"" + this["class"].header + "\"></div><div class=\"" + this["class"].content + "\"></div></div>");
+++    this.backgroundCanvas = this.adapter.wrap(document.createElement("canvas"));
+++    this.adapter.css(this.backgroundCanvas, {
+++      position: "absolute"
+++    });
+++    if (typeof G_vmlCanvasManager !== "undefined" && G_vmlCanvasManager !== null) {
+++      G_vmlCanvasManager.initElement(this.adapter.unwrap(this.backgroundCanvas));
+++    }
+++    headerElement = this.adapter.find(this.tooltipElement, "." + this["class"].header);
+++    if (this.options.title) {
+++      titleElement = this.adapter.create("<h1></h1>");
+++      this.adapter.update(titleElement, this.options.title, this.options.escapeTitle);
+++      this.adapter.append(headerElement, titleElement);
+++    }
+++    if (this.options.ajax && !this.loaded) {
+++      this.adapter.append(this.tooltipElement, this.adapter.create("<div class=\"" + this["class"].loadingIndicator + "\"><span>↻</span></div>"));
+++    }
+++    if (__indexOf.call(this.options.hideTriggers, "closeButton") >= 0) {
+++      this.closeButtonElement = this.adapter.create("<a href=\"javascript:undefined;\" class=\"" + this["class"].close + "\"><span>Close</span></a>");
+++      this.adapter.append(headerElement, this.closeButtonElement);
+++    }
+++    this.adapter.append(this.container, this.backgroundCanvas);
+++    this.adapter.append(this.container, this.tooltipElement);
+++    this.adapter.append(document.body, this.container);
+++    this._newContent = true;
+++    return this.redraw = true;
+++  };
+++
+++  Opentip.prototype.setContent = function(content) {
+++    this.content = content;
+++    this._newContent = true;
+++    if (typeof this.content === "function") {
+++      this._contentFunction = this.content;
+++      this.content = "";
+++    } else {
+++      this._contentFunction = null;
+++    }
+++    if (this.visible) {
+++      return this._updateElementContent();
+++    }
+++  };
+++
+++  Opentip.prototype._updateElementContent = function() {
+++    var contentDiv;
+++    if (this._newContent || (!this.options.cache && this._contentFunction)) {
+++      contentDiv = this.adapter.find(this.container, "." + this["class"].content);
+++      if (contentDiv != null) {
+++        if (this._contentFunction) {
+++          this.debug("Executing content function.");
+++          this.content = this._contentFunction(this);
+++        }
+++        this.adapter.update(contentDiv, this.content, this.options.escapeContent);
+++      }
+++      this._newContent = false;
+++    }
+++    this._storeAndLockDimensions();
+++    return this.reposition();
+++  };
+++
+++  Opentip.prototype._storeAndLockDimensions = function() {
+++    var prevDimension;
+++    if (!this.container) {
+++      return;
+++    }
+++    prevDimension = this.dimensions;
+++    this.adapter.css(this.container, {
+++      width: "auto",
+++      left: "0px",
+++      top: "0px"
+++    });
+++    this.dimensions = this.adapter.dimensions(this.container);
+++    this.dimensions.width += 1;
+++    this.adapter.css(this.container, {
+++      width: "" + this.dimensions.width + "px",
+++      top: "" + this.currentPosition.top + "px",
+++      left: "" + this.currentPosition.left + "px"
+++    });
+++    if (!this._dimensionsEqual(this.dimensions, prevDimension)) {
+++      this.redraw = true;
+++      return this._draw();
+++    }
+++  };
+++
+++  Opentip.prototype.activate = function() {
+++    return this._setupObservers("hidden", "hiding");
+++  };
+++
+++  Opentip.prototype.deactivate = function() {
+++    this.debug("Deactivating tooltip.");
+++    this.hide();
+++    return this._setupObservers("-showing", "-visible", "-hidden", "-hiding");
+++  };
+++
+++  Opentip.prototype._setupObservers = function() {
+++    var observeOrStop, removeObserver, state, states, trigger, _i, _j, _k, _l, _len, _len1, _len2, _len3, _ref, _ref1, _ref2,
+++      _this = this;
+++    states = 1 <= arguments.length ? __slice.call(arguments, 0) : [];
+++    for (_i = 0, _len = states.length; _i < _len; _i++) {
+++      state = states[_i];
+++      removeObserver = false;
+++      if (state.charAt(0) === "-") {
+++        removeObserver = true;
+++        state = state.substr(1);
+++      }
+++      if (this.currentObservers[state] === !removeObserver) {
+++        continue;
+++      }
+++      this.currentObservers[state] = !removeObserver;
+++      observeOrStop = function() {
+++        var args, _ref, _ref1;
+++        args = 1 <= arguments.length ? __slice.call(arguments, 0) : [];
+++        if (removeObserver) {
+++          return (_ref = _this.adapter).stopObserving.apply(_ref, args);
+++        } else {
+++          return (_ref1 = _this.adapter).observe.apply(_ref1, args);
+++        }
+++      };
+++      switch (state) {
+++        case "showing":
+++          _ref = this.hideTriggers;
+++          for (_j = 0, _len1 = _ref.length; _j < _len1; _j++) {
+++            trigger = _ref[_j];
+++            observeOrStop(trigger.element, trigger.event, this.bound.prepareToHide);
+++          }
+++          observeOrStop((document.onresize != null ? document : window), "resize", this.bound.reposition);
+++          observeOrStop(window, "scroll", this.bound.reposition);
+++          break;
+++        case "visible":
+++          _ref1 = this.showTriggersWhenVisible;
+++          for (_k = 0, _len2 = _ref1.length; _k < _len2; _k++) {
+++            trigger = _ref1[_k];
+++            observeOrStop(trigger.element, trigger.event, this.bound.prepareToShow);
+++          }
+++          break;
+++        case "hiding":
+++          _ref2 = this.showTriggers;
+++          for (_l = 0, _len3 = _ref2.length; _l < _len3; _l++) {
+++            trigger = _ref2[_l];
+++            observeOrStop(trigger.element, trigger.event, this.bound.prepareToShow);
+++          }
+++          break;
+++        case "hidden":
+++          break;
+++        default:
+++          throw new Error("Unknown state: " + state);
+++      }
+++    }
+++    return null;
+++  };
+++
+++  Opentip.prototype.prepareToShow = function() {
+++    this._abortHiding();
+++    this._abortShowing();
+++    if (this.visible) {
+++      return;
+++    }
+++    this.debug("Showing in " + this.options.delay + "s.");
+++    if (this.container == null) {
+++      this._setup();
+++    }
+++    if (this.options.group) {
+++      Opentip._abortShowingGroup(this.options.group, this);
+++    }
+++    this.preparingToShow = true;
+++    this._setupObservers("-hidden", "-hiding", "showing");
+++    this._followMousePosition();
+++    if (this.options.fixed && !this.options.target) {
+++      this.initialMousePosition = mousePosition;
+++    }
+++    this.reposition();
+++    return this._showTimeoutId = this.setTimeout(this.bound.show, this.options.delay || 0);
+++  };
+++
+++  Opentip.prototype.show = function() {
+++    var _this = this;
+++    this._abortHiding();
+++    if (this.visible) {
+++      return;
+++    }
+++    this._clearTimeouts();
+++    if (!this._triggerElementExists()) {
+++      return this.deactivate();
+++    }
+++    this.debug("Showing now.");
+++    if (this.container == null) {
+++      this._setup();
+++    }
+++    if (this.options.group) {
+++      Opentip._hideGroup(this.options.group, this);
+++    }
+++    this.visible = true;
+++    this.preparingToShow = false;
+++    if (this.tooltipElement == null) {
+++      this._buildElements();
+++    }
+++    this._updateElementContent();
+++    if (this.options.ajax && (!this.loaded || !this.options.cache)) {
+++      this._loadAjax();
+++    }
+++    this._searchAndActivateCloseButtons();
+++    this._startEnsureTriggerElement();
+++    this.adapter.css(this.container, {
+++      zIndex: Opentip.lastZIndex++
+++    });
+++    this._setupObservers("-hidden", "-hiding", "-showing", "-visible", "showing", "visible");
+++    if (this.options.fixed && !this.options.target) {
+++      this.initialMousePosition = mousePosition;
+++    }
+++    this.reposition();
+++    this.adapter.removeClass(this.container, this["class"].hiding);
+++    this.adapter.removeClass(this.container, this["class"].hidden);
+++    this.adapter.addClass(this.container, this["class"].goingToShow);
+++    this.setCss3Style(this.container, {
+++      transitionDuration: "0s"
+++    });
+++    this.defer(function() {
+++      var delay;
+++      if (!_this.visible || _this.preparingToHide) {
+++        return;
+++      }
+++      _this.adapter.removeClass(_this.container, _this["class"].goingToShow);
+++      _this.adapter.addClass(_this.container, _this["class"].showing);
+++      delay = 0;
+++      if (_this.options.showEffect && _this.options.showEffectDuration) {
+++        delay = _this.options.showEffectDuration;
+++      }
+++      _this.setCss3Style(_this.container, {
+++        transitionDuration: "" + delay + "s"
+++      });
+++      _this._visibilityStateTimeoutId = _this.setTimeout(function() {
+++        _this.adapter.removeClass(_this.container, _this["class"].showing);
+++        return _this.adapter.addClass(_this.container, _this["class"].visible);
+++      }, delay);
+++      return _this._activateFirstInput();
+++    });
+++    return this._draw();
+++  };
+++
+++  Opentip.prototype._abortShowing = function() {
+++    if (this.preparingToShow) {
+++      this.debug("Aborting showing.");
+++      this._clearTimeouts();
+++      this._stopFollowingMousePosition();
+++      this.preparingToShow = false;
+++      return this._setupObservers("-showing", "-visible", "hiding", "hidden");
+++    }
+++  };
+++
+++  Opentip.prototype.prepareToHide = function() {
+++    this._abortShowing();
+++    this._abortHiding();
+++    if (!this.visible) {
+++      return;
+++    }
+++    this.debug("Hiding in " + this.options.hideDelay + "s");
+++    this.preparingToHide = true;
+++    this._setupObservers("-showing", "visible", "-hidden", "hiding");
+++    return this._hideTimeoutId = this.setTimeout(this.bound.hide, this.options.hideDelay);
+++  };
+++
+++  Opentip.prototype.hide = function() {
+++    var _this = this;
+++    this._abortShowing();
+++    if (!this.visible) {
+++      return;
+++    }
+++    this._clearTimeouts();
+++    this.debug("Hiding!");
+++    this.visible = false;
+++    this.preparingToHide = false;
+++    this._stopEnsureTriggerElement();
+++    this._setupObservers("-showing", "-visible", "-hiding", "-hidden", "hiding", "hidden");
+++    if (!this.options.fixed) {
+++      this._stopFollowingMousePosition();
+++    }
+++    if (!this.container) {
+++      return;
+++    }
+++    this.adapter.removeClass(this.container, this["class"].visible);
+++    this.adapter.removeClass(this.container, this["class"].showing);
+++    this.adapter.addClass(this.container, this["class"].goingToHide);
+++    this.setCss3Style(this.container, {
+++      transitionDuration: "0s"
+++    });
+++    return this.defer(function() {
+++      var hideDelay;
+++      _this.adapter.removeClass(_this.container, _this["class"].goingToHide);
+++      _this.adapter.addClass(_this.container, _this["class"].hiding);
+++      hideDelay = 0;
+++      if (_this.options.hideEffect && _this.options.hideEffectDuration) {
+++        hideDelay = _this.options.hideEffectDuration;
+++      }
+++      _this.setCss3Style(_this.container, {
+++        transitionDuration: "" + hideDelay + "s"
+++      });
+++      return _this._visibilityStateTimeoutId = _this.setTimeout(function() {
+++        _this.adapter.removeClass(_this.container, _this["class"].hiding);
+++        _this.adapter.addClass(_this.container, _this["class"].hidden);
+++        _this.setCss3Style(_this.container, {
+++          transitionDuration: "0s"
+++        });
+++        if (_this.options.removeElementsOnHide) {
+++          _this.debug("Removing HTML elements.");
+++          _this.adapter.remove(_this.container);
+++          delete _this.container;
+++          return delete _this.tooltipElement;
+++        }
+++      }, hideDelay);
+++    });
+++  };
+++
+++  Opentip.prototype._abortHiding = function() {
+++    if (this.preparingToHide) {
+++      this.debug("Aborting hiding.");
+++      this._clearTimeouts();
+++      this.preparingToHide = false;
+++      return this._setupObservers("-hiding", "showing", "visible");
+++    }
+++  };
+++
+++  Opentip.prototype.reposition = function() {
+++    var position, stem, _ref,
+++      _this = this;
+++    position = this.getPosition();
+++    if (position == null) {
+++      return;
+++    }
+++    stem = this.options.stem;
+++    if (this.options.containInViewport) {
+++      _ref = this._ensureViewportContainment(position), position = _ref.position, stem = _ref.stem;
+++    }
+++    if (this._positionsEqual(position, this.currentPosition)) {
+++      return;
+++    }
+++    if (!(!this.options.stem || stem.eql(this.currentStem))) {
+++      this.redraw = true;
+++    }
+++    this.currentPosition = position;
+++    this.currentStem = stem;
+++    this._draw();
+++    this.adapter.css(this.container, {
+++      left: "" + position.left + "px",
+++      top: "" + position.top + "px"
+++    });
+++    return this.defer(function() {
+++      var rawContainer, redrawFix;
+++      rawContainer = _this.adapter.unwrap(_this.container);
+++      rawContainer.style.visibility = "hidden";
+++      redrawFix = rawContainer.offsetHeight;
+++      return rawContainer.style.visibility = "visible";
+++    });
+++  };
+++
+++  Opentip.prototype.getPosition = function(tipJoint, targetJoint, stem) {
+++    var additionalHorizontal, additionalVertical, offsetDistance, position, stemLength, targetDimensions, targetPosition, unwrappedTarget, _ref;
+++    if (!this.container) {
+++      return;
+++    }
+++    if (tipJoint == null) {
+++      tipJoint = this.options.tipJoint;
+++    }
+++    if (targetJoint == null) {
+++      targetJoint = this.options.targetJoint;
+++    }
+++    position = {};
+++    if (this.options.target) {
+++      targetPosition = this.adapter.offset(this.options.target);
+++      targetDimensions = this.adapter.dimensions(this.options.target);
+++      position = targetPosition;
+++      if (targetJoint.right) {
+++        unwrappedTarget = this.adapter.unwrap(this.options.target);
+++        if (unwrappedTarget.getBoundingClientRect != null) {
+++          position.left = unwrappedTarget.getBoundingClientRect().right + ((_ref = window.pageXOffset) != null ? _ref : document.body.scrollLeft);
+++        } else {
+++          position.left += targetDimensions.width;
+++        }
+++      } else if (targetJoint.center) {
+++        position.left += Math.round(targetDimensions.width / 2);
+++      }
+++      if (targetJoint.bottom) {
+++        position.top += targetDimensions.height;
+++      } else if (targetJoint.middle) {
+++        position.top += Math.round(targetDimensions.height / 2);
+++      }
+++      if (this.options.borderWidth) {
+++        if (this.options.tipJoint.left) {
+++          position.left += this.options.borderWidth;
+++        }
+++        if (this.options.tipJoint.right) {
+++          position.left -= this.options.borderWidth;
+++        }
+++        if (this.options.tipJoint.top) {
+++          position.top += this.options.borderWidth;
+++        } else if (this.options.tipJoint.bottom) {
+++          position.top -= this.options.borderWidth;
+++        }
+++      }
+++    } else {
+++      if (this.initialMousePosition) {
+++        position = {
+++          top: this.initialMousePosition.y,
+++          left: this.initialMousePosition.x
+++        };
+++      } else {
+++        position = {
+++          top: mousePosition.y,
+++          left: mousePosition.x
+++        };
+++      }
+++    }
+++    if (this.options.autoOffset) {
+++      stemLength = this.options.stem ? this.options.stemLength : 0;
+++      offsetDistance = stemLength && this.options.fixed ? 2 : 10;
+++      additionalHorizontal = tipJoint.middle && !this.options.fixed ? 15 : 0;
+++      additionalVertical = tipJoint.center && !this.options.fixed ? 15 : 0;
+++      if (tipJoint.right) {
+++        position.left -= offsetDistance + additionalHorizontal;
+++      } else if (tipJoint.left) {
+++        position.left += offsetDistance + additionalHorizontal;
+++      }
+++      if (tipJoint.bottom) {
+++        position.top -= offsetDistance + additionalVertical;
+++      } else if (tipJoint.top) {
+++        position.top += offsetDistance + additionalVertical;
+++      }
+++      if (stemLength) {
+++        if (stem == null) {
+++          stem = this.options.stem;
+++        }
+++        if (stem.right) {
+++          position.left -= stemLength;
+++        } else if (stem.left) {
+++          position.left += stemLength;
+++        }
+++        if (stem.bottom) {
+++          position.top -= stemLength;
+++        } else if (stem.top) {
+++          position.top += stemLength;
+++        }
+++      }
+++    }
+++    position.left += this.options.offset[0];
+++    position.top += this.options.offset[1];
+++    if (tipJoint.right) {
+++      position.left -= this.dimensions.width;
+++    } else if (tipJoint.center) {
+++      position.left -= Math.round(this.dimensions.width / 2);
+++    }
+++    if (tipJoint.bottom) {
+++      position.top -= this.dimensions.height;
+++    } else if (tipJoint.middle) {
+++      position.top -= Math.round(this.dimensions.height / 2);
+++    }
+++    return position;
+++  };
+++
+++  Opentip.prototype._ensureViewportContainment = function(position) {
+++    var needsRepositioning, newSticksOut, originals, revertedX, revertedY, scrollOffset, stem, sticksOut, targetJoint, tipJoint, viewportDimensions, viewportPosition;
+++    stem = this.options.stem;
+++    originals = {
+++      position: position,
+++      stem: stem
+++    };
+++    if (!(this.visible && position)) {
+++      return originals;
+++    }
+++    sticksOut = this._sticksOut(position);
+++    if (!(sticksOut[0] || sticksOut[1])) {
+++      return originals;
+++    }
+++    tipJoint = new Opentip.Joint(this.options.tipJoint);
+++    if (this.options.targetJoint) {
+++      targetJoint = new Opentip.Joint(this.options.targetJoint);
+++    }
+++    scrollOffset = this.adapter.scrollOffset();
+++    viewportDimensions = this.adapter.viewportDimensions();
+++    viewportPosition = [position.left - scrollOffset[0], position.top - scrollOffset[1]];
+++    needsRepositioning = false;
+++    if (viewportDimensions.width >= this.dimensions.width) {
+++      if (sticksOut[0]) {
+++        needsRepositioning = true;
+++        switch (sticksOut[0]) {
+++          case this.STICKS_OUT_LEFT:
+++            tipJoint.setHorizontal("left");
+++            if (this.options.targetJoint) {
+++              targetJoint.setHorizontal("right");
+++            }
+++            break;
+++          case this.STICKS_OUT_RIGHT:
+++            tipJoint.setHorizontal("right");
+++            if (this.options.targetJoint) {
+++              targetJoint.setHorizontal("left");
+++            }
+++        }
+++      }
+++    }
+++    if (viewportDimensions.height >= this.dimensions.height) {
+++      if (sticksOut[1]) {
+++        needsRepositioning = true;
+++        switch (sticksOut[1]) {
+++          case this.STICKS_OUT_TOP:
+++            tipJoint.setVertical("top");
+++            if (this.options.targetJoint) {
+++              targetJoint.setVertical("bottom");
+++            }
+++            break;
+++          case this.STICKS_OUT_BOTTOM:
+++            tipJoint.setVertical("bottom");
+++            if (this.options.targetJoint) {
+++              targetJoint.setVertical("top");
+++            }
+++        }
+++      }
+++    }
+++    if (!needsRepositioning) {
+++      return originals;
+++    }
+++    if (this.options.stem) {
+++      stem = tipJoint;
+++    }
+++    position = this.getPosition(tipJoint, targetJoint, stem);
+++    newSticksOut = this._sticksOut(position);
+++    revertedX = false;
+++    revertedY = false;
+++    if (newSticksOut[0] && (newSticksOut[0] !== sticksOut[0])) {
+++      revertedX = true;
+++      tipJoint.setHorizontal(this.options.tipJoint.horizontal);
+++      if (this.options.targetJoint) {
+++        targetJoint.setHorizontal(this.options.targetJoint.horizontal);
+++      }
+++    }
+++    if (newSticksOut[1] && (newSticksOut[1] !== sticksOut[1])) {
+++      revertedY = true;
+++      tipJoint.setVertical(this.options.tipJoint.vertical);
+++      if (this.options.targetJoint) {
+++        targetJoint.setVertical(this.options.targetJoint.vertical);
+++      }
+++    }
+++    if (revertedX && revertedY) {
+++      return originals;
+++    }
+++    if (revertedX || revertedY) {
+++      if (this.options.stem) {
+++        stem = tipJoint;
+++      }
+++      position = this.getPosition(tipJoint, targetJoint, stem);
+++    }
+++    return {
+++      position: position,
+++      stem: stem
+++    };
+++  };
+++
+++  Opentip.prototype._sticksOut = function(position) {
+++    var positionOffset, scrollOffset, sticksOut, viewportDimensions;
+++    scrollOffset = this.adapter.scrollOffset();
+++    viewportDimensions = this.adapter.viewportDimensions();
+++    positionOffset = [position.left - scrollOffset[0], position.top - scrollOffset[1]];
+++    sticksOut = [false, false];
+++    if (positionOffset[0] < 0) {
+++      sticksOut[0] = this.STICKS_OUT_LEFT;
+++    } else if (positionOffset[0] + this.dimensions.width > viewportDimensions.width) {
+++      sticksOut[0] = this.STICKS_OUT_RIGHT;
+++    }
+++    if (positionOffset[1] < 0) {
+++      sticksOut[1] = this.STICKS_OUT_TOP;
+++    } else if (positionOffset[1] + this.dimensions.height > viewportDimensions.height) {
+++      sticksOut[1] = this.STICKS_OUT_BOTTOM;
+++    }
+++    return sticksOut;
+++  };
+++
+++  Opentip.prototype._draw = function() {
+++    var backgroundCanvas, bulge, canvasDimensions, canvasPosition, closeButton, closeButtonInner, closeButtonOuter, ctx, drawCorner, drawLine, hb, position, stemBase, stemLength, _i, _len, _ref, _ref1, _ref2,
+++      _this = this;
+++    if (!(this.backgroundCanvas && this.redraw)) {
+++      return;
+++    }
+++    this.debug("Drawing background.");
+++    this.redraw = false;
+++    if (this.currentStem) {
+++      _ref = ["top", "right", "bottom", "left"];
+++      for (_i = 0, _len = _ref.length; _i < _len; _i++) {
+++        position = _ref[_i];
+++        this.adapter.removeClass(this.container, "stem-" + position);
+++      }
+++      this.adapter.addClass(this.container, "stem-" + this.currentStem.horizontal);
+++      this.adapter.addClass(this.container, "stem-" + this.currentStem.vertical);
+++    }
+++    closeButtonInner = [0, 0];
+++    closeButtonOuter = [0, 0];
+++    if (__indexOf.call(this.options.hideTriggers, "closeButton") >= 0) {
+++      closeButton = new Opentip.Joint(((_ref1 = this.currentStem) != null ? _ref1.toString() : void 0) === "top right" ? "top left" : "top right");
+++      closeButtonInner = [this.options.closeButtonRadius + this.options.closeButtonOffset[0], this.options.closeButtonRadius + this.options.closeButtonOffset[1]];
+++      closeButtonOuter = [this.options.closeButtonRadius - this.options.closeButtonOffset[0], this.options.closeButtonRadius - this.options.closeButtonOffset[1]];
+++    }
+++    canvasDimensions = this.adapter.clone(this.dimensions);
+++    canvasPosition = [0, 0];
+++    if (this.options.borderWidth) {
+++      canvasDimensions.width += this.options.borderWidth * 2;
+++      canvasDimensions.height += this.options.borderWidth * 2;
+++      canvasPosition[0] -= this.options.borderWidth;
+++      canvasPosition[1] -= this.options.borderWidth;
+++    }
+++    if (this.options.shadow) {
+++      canvasDimensions.width += this.options.shadowBlur * 2;
+++      canvasDimensions.width += Math.max(0, this.options.shadowOffset[0] - this.options.shadowBlur * 2);
+++      canvasDimensions.height += this.options.shadowBlur * 2;
+++      canvasDimensions.height += Math.max(0, this.options.shadowOffset[1] - this.options.shadowBlur * 2);
+++      canvasPosition[0] -= Math.max(0, this.options.shadowBlur - this.options.shadowOffset[0]);
+++      canvasPosition[1] -= Math.max(0, this.options.shadowBlur - this.options.shadowOffset[1]);
+++    }
+++    bulge = {
+++      left: 0,
+++      right: 0,
+++      top: 0,
+++      bottom: 0
+++    };
+++    if (this.currentStem) {
+++      if (this.currentStem.left) {
+++        bulge.left = this.options.stemLength;
+++      } else if (this.currentStem.right) {
+++        bulge.right = this.options.stemLength;
+++      }
+++      if (this.currentStem.top) {
+++        bulge.top = this.options.stemLength;
+++      } else if (this.currentStem.bottom) {
+++        bulge.bottom = this.options.stemLength;
+++      }
+++    }
+++    if (closeButton) {
+++      if (closeButton.left) {
+++        bulge.left = Math.max(bulge.left, closeButtonOuter[0]);
+++      } else if (closeButton.right) {
+++        bulge.right = Math.max(bulge.right, closeButtonOuter[0]);
+++      }
+++      if (closeButton.top) {
+++        bulge.top = Math.max(bulge.top, closeButtonOuter[1]);
+++      } else if (closeButton.bottom) {
+++        bulge.bottom = Math.max(bulge.bottom, closeButtonOuter[1]);
+++      }
+++    }
+++    canvasDimensions.width += bulge.left + bulge.right;
+++    canvasDimensions.height += bulge.top + bulge.bottom;
+++    canvasPosition[0] -= bulge.left;
+++    canvasPosition[1] -= bulge.top;
+++    if (this.currentStem && this.options.borderWidth) {
+++      _ref2 = this._getPathStemMeasures(this.options.stemBase, this.options.stemLength, this.options.borderWidth), stemLength = _ref2.stemLength, stemBase = _ref2.stemBase;
+++    }
+++    backgroundCanvas = this.adapter.unwrap(this.backgroundCanvas);
+++    backgroundCanvas.width = canvasDimensions.width;
+++    backgroundCanvas.height = canvasDimensions.height;
+++    this.adapter.css(this.backgroundCanvas, {
+++      width: "" + backgroundCanvas.width + "px",
+++      height: "" + backgroundCanvas.height + "px",
+++      left: "" + canvasPosition[0] + "px",
+++      top: "" + canvasPosition[1] + "px"
+++    });
+++    ctx = backgroundCanvas.getContext("2d");
+++    ctx.setTransform(1, 0, 0, 1, 0, 0);
+++    ctx.clearRect(0, 0, backgroundCanvas.width, backgroundCanvas.height);
+++    ctx.beginPath();
+++    ctx.fillStyle = this._getColor(ctx, this.dimensions, this.options.background, this.options.backgroundGradientHorizontal);
+++    ctx.lineJoin = "miter";
+++    ctx.miterLimit = 500;
+++    hb = this.options.borderWidth / 2;
+++    if (this.options.borderWidth) {
+++      ctx.strokeStyle = this.options.borderColor;
+++      ctx.lineWidth = this.options.borderWidth;
+++    } else {
+++      stemLength = this.options.stemLength;
+++      stemBase = this.options.stemBase;
+++    }
+++    if (stemBase == null) {
+++      stemBase = 0;
+++    }
+++    drawLine = function(length, stem, first) {
+++      if (first) {
+++        ctx.moveTo(Math.max(stemBase, _this.options.borderRadius, closeButtonInner[0]) + 1 - hb, -hb);
+++      }
+++      if (stem) {
+++        ctx.lineTo(length / 2 - stemBase / 2, -hb);
+++        ctx.lineTo(length / 2, -stemLength - hb);
+++        return ctx.lineTo(length / 2 + stemBase / 2, -hb);
+++      }
+++    };
+++    drawCorner = function(stem, closeButton, i) {
+++      var angle1, angle2, innerWidth, offset;
+++      if (stem) {
+++        ctx.lineTo(-stemBase + hb, 0 - hb);
+++        ctx.lineTo(stemLength + hb, -stemLength - hb);
+++        return ctx.lineTo(hb, stemBase - hb);
+++      } else if (closeButton) {
+++        offset = _this.options.closeButtonOffset;
+++        innerWidth = closeButtonInner[0];
+++        if (i % 2 !== 0) {
+++          offset = [offset[1], offset[0]];
+++          innerWidth = closeButtonInner[1];
+++        }
+++        angle1 = Math.acos(offset[1] / _this.options.closeButtonRadius);
+++        angle2 = Math.acos(offset[0] / _this.options.closeButtonRadius);
+++        ctx.lineTo(-innerWidth + hb, -hb);
+++        return ctx.arc(hb - offset[0], -hb + offset[1], _this.options.closeButtonRadius, -(Math.PI / 2 + angle1), angle2, false);
+++      } else {
+++        ctx.lineTo(-_this.options.borderRadius + hb, -hb);
+++        return ctx.quadraticCurveTo(hb, -hb, hb, _this.options.borderRadius - hb);
+++      }
+++    };
+++    ctx.translate(-canvasPosition[0], -canvasPosition[1]);
+++    ctx.save();
+++    (function() {
+++      var cornerStem, i, lineLength, lineStem, positionIdx, positionX, positionY, rotation, _j, _ref3, _results;
+++      _results = [];
+++      for (i = _j = 0, _ref3 = Opentip.positions.length / 2; 0 <= _ref3 ? _j < _ref3 : _j > _ref3; i = 0 <= _ref3 ? ++_j : --_j) {
+++        positionIdx = i * 2;
+++        positionX = i === 0 || i === 3 ? 0 : _this.dimensions.width;
+++        positionY = i < 2 ? 0 : _this.dimensions.height;
+++        rotation = (Math.PI / 2) * i;
+++        lineLength = i % 2 === 0 ? _this.dimensions.width : _this.dimensions.height;
+++        lineStem = new Opentip.Joint(Opentip.positions[positionIdx]);
+++        cornerStem = new Opentip.Joint(Opentip.positions[positionIdx + 1]);
+++        ctx.save();
+++        ctx.translate(positionX, positionY);
+++        ctx.rotate(rotation);
+++        drawLine(lineLength, lineStem.eql(_this.currentStem), i === 0);
+++        ctx.translate(lineLength, 0);
+++        drawCorner(cornerStem.eql(_this.currentStem), cornerStem.eql(closeButton), i);
+++        _results.push(ctx.restore());
+++      }
+++      return _results;
+++    })();
+++    ctx.closePath();
+++    ctx.save();
+++    if (this.options.shadow) {
+++      ctx.shadowColor = this.options.shadowColor;
+++      ctx.shadowBlur = this.options.shadowBlur;
+++      ctx.shadowOffsetX = this.options.shadowOffset[0];
+++      ctx.shadowOffsetY = this.options.shadowOffset[1];
+++    }
+++    ctx.fill();
+++    ctx.restore();
+++    if (this.options.borderWidth) {
+++      ctx.stroke();
+++    }
+++    ctx.restore();
+++    if (closeButton) {
+++      return (function() {
+++        var crossCenter, crossHeight, crossWidth, hcs, linkCenter;
+++        crossWidth = crossHeight = _this.options.closeButtonRadius * 2;
+++        if (closeButton.toString() === "top right") {
+++          linkCenter = [_this.dimensions.width - _this.options.closeButtonOffset[0], _this.options.closeButtonOffset[1]];
+++          crossCenter = [linkCenter[0] + hb, linkCenter[1] - hb];
+++        } else {
+++          linkCenter = [_this.options.closeButtonOffset[0], _this.options.closeButtonOffset[1]];
+++          crossCenter = [linkCenter[0] - hb, linkCenter[1] - hb];
+++        }
+++        ctx.translate(crossCenter[0], crossCenter[1]);
+++        hcs = _this.options.closeButtonCrossSize / 2;
+++        ctx.save();
+++        ctx.beginPath();
+++        ctx.strokeStyle = _this.options.closeButtonCrossColor;
+++        ctx.lineWidth = _this.options.closeButtonCrossLineWidth;
+++        ctx.lineCap = "round";
+++        ctx.moveTo(-hcs, -hcs);
+++        ctx.lineTo(hcs, hcs);
+++        ctx.stroke();
+++        ctx.beginPath();
+++        ctx.moveTo(hcs, -hcs);
+++        ctx.lineTo(-hcs, hcs);
+++        ctx.stroke();
+++        ctx.restore();
+++        return _this.adapter.css(_this.closeButtonElement, {
+++          left: "" + (linkCenter[0] - hcs - _this.options.closeButtonLinkOverscan) + "px",
+++          top: "" + (linkCenter[1] - hcs - _this.options.closeButtonLinkOverscan) + "px",
+++          width: "" + (_this.options.closeButtonCrossSize + _this.options.closeButtonLinkOverscan * 2) + "px",
+++          height: "" + (_this.options.closeButtonCrossSize + _this.options.closeButtonLinkOverscan * 2) + "px"
+++        });
+++      })();
+++    }
+++  };
+++
+++  Opentip.prototype._getPathStemMeasures = function(outerStemBase, outerStemLength, borderWidth) {
+++    var angle, distanceBetweenTips, halfAngle, hb, rhombusSide, stemBase, stemLength;
+++    hb = borderWidth / 2;
+++    halfAngle = Math.atan((outerStemBase / 2) / outerStemLength);
+++    angle = halfAngle * 2;
+++    rhombusSide = hb / Math.sin(angle);
+++    distanceBetweenTips = 2 * rhombusSide * Math.cos(halfAngle);
+++    stemLength = hb + outerStemLength - distanceBetweenTips;
+++    if (stemLength < 0) {
+++      throw new Error("Sorry but your stemLength / stemBase ratio is strange.");
+++    }
+++    stemBase = (Math.tan(halfAngle) * stemLength) * 2;
+++    return {
+++      stemLength: stemLength,
+++      stemBase: stemBase
+++    };
+++  };
+++
+++  Opentip.prototype._getColor = function(ctx, dimensions, color, horizontal) {
+++    var colorStop, gradient, i, _i, _len;
+++    if (horizontal == null) {
+++      horizontal = false;
+++    }
+++    if (typeof color === "string") {
+++      return color;
+++    }
+++    if (horizontal) {
+++      gradient = ctx.createLinearGradient(0, 0, dimensions.width, 0);
+++    } else {
+++      gradient = ctx.createLinearGradient(0, 0, 0, dimensions.height);
+++    }
+++    for (i = _i = 0, _len = color.length; _i < _len; i = ++_i) {
+++      colorStop = color[i];
+++      gradient.addColorStop(colorStop[0], colorStop[1]);
+++    }
+++    return gradient;
+++  };
+++
+++  Opentip.prototype._searchAndActivateCloseButtons = function() {
+++    var element, _i, _len, _ref;
+++    _ref = this.adapter.findAll(this.container, "." + this["class"].close);
+++    for (_i = 0, _len = _ref.length; _i < _len; _i++) {
+++      element = _ref[_i];
+++      this.hideTriggers.push({
+++        element: this.adapter.wrap(element),
+++        event: "click"
+++      });
+++    }
+++    if (this.currentObservers.showing) {
+++      this._setupObservers("-showing", "showing");
+++    }
+++    if (this.currentObservers.visible) {
+++      return this._setupObservers("-visible", "visible");
+++    }
+++  };
+++
+++  Opentip.prototype._activateFirstInput = function() {
+++    var input;
+++    input = this.adapter.unwrap(this.adapter.find(this.container, "input, textarea"));
+++    return input != null ? typeof input.focus === "function" ? input.focus() : void 0 : void 0;
+++  };
+++
+++  Opentip.prototype._followMousePosition = function() {
+++    if (!this.options.fixed) {
+++      return Opentip._observeMousePosition(this.bound.reposition);
+++    }
+++  };
+++
+++  Opentip.prototype._stopFollowingMousePosition = function() {
+++    if (!this.options.fixed) {
+++      return Opentip._stopObservingMousePosition(this.bound.reposition);
+++    }
+++  };
+++
+++  Opentip.prototype._clearShowTimeout = function() {
+++    return clearTimeout(this._showTimeoutId);
+++  };
+++
+++  Opentip.prototype._clearHideTimeout = function() {
+++    return clearTimeout(this._hideTimeoutId);
+++  };
+++
+++  Opentip.prototype._clearTimeouts = function() {
+++    clearTimeout(this._visibilityStateTimeoutId);
+++    this._clearShowTimeout();
+++    return this._clearHideTimeout();
+++  };
+++
+++  Opentip.prototype._triggerElementExists = function() {
+++    var el;
+++    el = this.adapter.unwrap(this.triggerElement);
+++    while (el.parentNode) {
+++      if (el.parentNode.tagName === "BODY") {
+++        return true;
+++      }
+++      el = el.parentNode;
+++    }
+++    return false;
+++  };
+++
+++  Opentip.prototype._loadAjax = function() {
+++    var _this = this;
+++    if (this.loading) {
+++      return;
+++    }
+++    this.loaded = false;
+++    this.loading = true;
+++    this.adapter.addClass(this.container, this["class"].loading);
+++    this.setContent("");
+++    this.debug("Loading content from " + this.options.ajax);
+++    return this.adapter.ajax({
+++      url: this.options.ajax,
+++      method: this.options.ajaxMethod,
+++      onSuccess: function(responseText) {
+++        _this.debug("Loading successful.");
+++        _this.adapter.removeClass(_this.container, _this["class"].loading);
+++        return _this.setContent(responseText);
+++      },
+++      onError: function(error) {
+++        var message;
+++        message = _this.options.ajaxErrorMessage;
+++        _this.debug(message, error);
+++        _this.setContent(message);
+++        return _this.adapter.addClass(_this.container, _this["class"].ajaxError);
+++      },
+++      onComplete: function() {
+++        _this.adapter.removeClass(_this.container, _this["class"].loading);
+++        _this.loading = false;
+++        _this.loaded = true;
+++        _this._searchAndActivateCloseButtons();
+++        _this._activateFirstInput();
+++        return _this.reposition();
+++      }
+++    });
+++  };
+++
+++  Opentip.prototype._ensureTriggerElement = function() {
+++    if (!this._triggerElementExists()) {
+++      this.deactivate();
+++      return this._stopEnsureTriggerElement();
+++    }
+++  };
+++
+++  Opentip.prototype._ensureTriggerElementInterval = 1000;
+++
+++  Opentip.prototype._startEnsureTriggerElement = function() {
+++    var _this = this;
+++    return this._ensureTriggerElementTimeoutId = setInterval((function() {
+++      return _this._ensureTriggerElement();
+++    }), this._ensureTriggerElementInterval);
+++  };
+++
+++  Opentip.prototype._stopEnsureTriggerElement = function() {
+++    return clearInterval(this._ensureTriggerElementTimeoutId);
+++  };
+++
+++  return Opentip;
+++
+++})();
+++
+++vendors = ["khtml", "ms", "o", "moz", "webkit"];
+++
+++Opentip.prototype.setCss3Style = function(element, styles) {
+++  var prop, value, vendor, vendorProp, _results;
+++  element = this.adapter.unwrap(element);
+++  _results = [];
+++  for (prop in styles) {
+++    if (!__hasProp.call(styles, prop)) continue;
+++    value = styles[prop];
+++    if (element.style[prop] != null) {
+++      _results.push(element.style[prop] = value);
+++    } else {
+++      _results.push((function() {
+++        var _i, _len, _results1;
+++        _results1 = [];
+++        for (_i = 0, _len = vendors.length; _i < _len; _i++) {
+++          vendor = vendors[_i];
+++          vendorProp = "" + (this.ucfirst(vendor)) + (this.ucfirst(prop));
+++          if (element.style[vendorProp] != null) {
+++            _results1.push(element.style[vendorProp] = value);
+++          } else {
+++            _results1.push(void 0);
+++          }
+++        }
+++        return _results1;
+++      }).call(this));
+++    }
+++  }
+++  return _results;
+++};
+++
+++Opentip.prototype.defer = function(func) {
+++  return setTimeout(func, 0);
+++};
+++
+++Opentip.prototype.setTimeout = function(func, seconds) {
+++  return setTimeout(func, seconds ? seconds * 1000 : 0);
+++};
+++
+++Opentip.prototype.ucfirst = function(string) {
+++  if (string == null) {
+++    return "";
+++  }
+++  return string.charAt(0).toUpperCase() + string.slice(1);
+++};
+++
+++Opentip.prototype.dasherize = function(string) {
+++  return string.replace(/([A-Z])/g, function(_, character) {
+++    return "-" + (character.toLowerCase());
+++  });
+++};
+++
+++mousePositionObservers = [];
+++
+++mousePosition = {
+++  x: 0,
+++  y: 0
+++};
+++
+++mouseMoved = function(e) {
+++  var observer, _i, _len, _results;
+++  mousePosition = Opentip.adapter.mousePosition(e);
+++  _results = [];
+++  for (_i = 0, _len = mousePositionObservers.length; _i < _len; _i++) {
+++    observer = mousePositionObservers[_i];
+++    _results.push(observer());
+++  }
+++  return _results;
+++};
+++
+++Opentip.followMousePosition = function() {
+++  return Opentip.adapter.observe(document.body, "mousemove", mouseMoved);
+++};
+++
+++Opentip._observeMousePosition = function(observer) {
+++  return mousePositionObservers.push(observer);
+++};
+++
+++Opentip._stopObservingMousePosition = function(removeObserver) {
+++  var observer;
+++  return mousePositionObservers = (function() {
+++    var _i, _len, _results;
+++    _results = [];
+++    for (_i = 0, _len = mousePositionObservers.length; _i < _len; _i++) {
+++      observer = mousePositionObservers[_i];
+++      if (observer !== removeObserver) {
+++        _results.push(observer);
+++      }
+++    }
+++    return _results;
+++  })();
+++};
+++
+++Opentip.Joint = (function() {
+++
+++  function Joint(pointerString) {
+++    if (pointerString == null) {
+++      return;
+++    }
+++    if (pointerString instanceof Opentip.Joint) {
+++      pointerString = pointerString.toString();
+++    }
+++    this.set(pointerString);
+++    this;
+++
+++  }
+++
+++  Joint.prototype.set = function(string) {
+++    string = string.toLowerCase();
+++    this.setHorizontal(string);
+++    this.setVertical(string);
+++    return this;
+++  };
+++
+++  Joint.prototype.setHorizontal = function(string) {
+++    var i, valid, _i, _j, _len, _len1, _results;
+++    valid = ["left", "center", "right"];
+++    for (_i = 0, _len = valid.length; _i < _len; _i++) {
+++      i = valid[_i];
+++      if (~string.indexOf(i)) {
+++        this.horizontal = i.toLowerCase();
+++      }
+++    }
+++    if (this.horizontal == null) {
+++      this.horizontal = "center";
+++    }
+++    _results = [];
+++    for (_j = 0, _len1 = valid.length; _j < _len1; _j++) {
+++      i = valid[_j];
+++      _results.push(this[i] = this.horizontal === i ? i : void 0);
+++    }
+++    return _results;
+++  };
+++
+++  Joint.prototype.setVertical = function(string) {
+++    var i, valid, _i, _j, _len, _len1, _results;
+++    valid = ["top", "middle", "bottom"];
+++    for (_i = 0, _len = valid.length; _i < _len; _i++) {
+++      i = valid[_i];
+++      if (~string.indexOf(i)) {
+++        this.vertical = i.toLowerCase();
+++      }
+++    }
+++    if (this.vertical == null) {
+++      this.vertical = "middle";
+++    }
+++    _results = [];
+++    for (_j = 0, _len1 = valid.length; _j < _len1; _j++) {
+++      i = valid[_j];
+++      _results.push(this[i] = this.vertical === i ? i : void 0);
+++    }
+++    return _results;
+++  };
+++
+++  Joint.prototype.eql = function(pointer) {
+++    return (pointer != null) && this.horizontal === pointer.horizontal && this.vertical === pointer.vertical;
+++  };
+++
+++  Joint.prototype.flip = function() {
+++    var flippedIndex, positionIdx;
+++    positionIdx = Opentip.position[this.toString(true)];
+++    flippedIndex = (positionIdx + 4) % 8;
+++    this.set(Opentip.positions[flippedIndex]);
+++    return this;
+++  };
+++
+++  Joint.prototype.toString = function(camelized) {
+++    var horizontal, vertical;
+++    if (camelized == null) {
+++      camelized = false;
+++    }
+++    vertical = this.vertical === "middle" ? "" : this.vertical;
+++    horizontal = this.horizontal === "center" ? "" : this.horizontal;
+++    if (vertical && horizontal) {
+++      if (camelized) {
+++        horizontal = Opentip.prototype.ucfirst(horizontal);
+++      } else {
+++        horizontal = " " + horizontal;
+++      }
+++    }
+++    return "" + vertical + horizontal;
+++  };
+++
+++  return Joint;
+++
+++})();
+++
+++Opentip.prototype._positionsEqual = function(posA, posB) {
+++  return (posA != null) && (posB != null) && posA.left === posB.left && posA.top === posB.top;
+++};
+++
+++Opentip.prototype._dimensionsEqual = function(dimA, dimB) {
+++  return (dimA != null) && (dimB != null) && dimA.width === dimB.width && dimA.height === dimB.height;
+++};
+++
+++Opentip.prototype.debug = function() {
+++  var args;
+++  args = 1 <= arguments.length ? __slice.call(arguments, 0) : [];
+++  if (Opentip.debug && ((typeof console !== "undefined" && console !== null ? console.debug : void 0) != null)) {
+++    args.unshift("#" + this.id + " |");
+++    return console.debug.apply(console, args);
+++  }
+++};
+++
+++Opentip.findElements = function() {
+++  var adapter, content, element, optionName, optionValue, options, _i, _len, _ref, _results;
+++  adapter = Opentip.adapter;
+++  _ref = adapter.findAll(document.body, "[data-ot]");
+++  _results = [];
+++  for (_i = 0, _len = _ref.length; _i < _len; _i++) {
+++    element = _ref[_i];
+++    options = {};
+++    content = adapter.data(element, "ot");
+++    if (content === "" || content === "true" || content === "yes") {
+++      content = adapter.attr(element, "title");
+++      adapter.attr(element, "title", "");
+++    }
+++    content = content || "";
+++    for (optionName in Opentip.styles.standard) {
+++      optionValue = adapter.data(element, "ot" + (Opentip.prototype.ucfirst(optionName)));
+++      if (optionValue != null) {
+++        if (optionValue === "yes" || optionValue === "true" || optionValue === "on") {
+++          optionValue = true;
+++        } else if (optionValue === "no" || optionValue === "false" || optionValue === "off") {
+++          optionValue = false;
+++        }
+++        options[optionName] = optionValue;
+++      }
+++    }
+++    _results.push(new Opentip(element, content, options));
+++  }
+++  return _results;
+++};
+++
+++Opentip.version = "2.4.6";
+++
+++Opentip.debug = false;
+++
+++Opentip.lastId = 0;
+++
+++Opentip.lastZIndex = 100;
+++
+++Opentip.tips = [];
+++
+++Opentip._abortShowingGroup = function(group, originatingOpentip) {
+++  var opentip, _i, _len, _ref, _results;
+++  _ref = Opentip.tips;
+++  _results = [];
+++  for (_i = 0, _len = _ref.length; _i < _len; _i++) {
+++    opentip = _ref[_i];
+++    if (opentip !== originatingOpentip && opentip.options.group === group) {
+++      _results.push(opentip._abortShowing());
+++    } else {
+++      _results.push(void 0);
+++    }
+++  }
+++  return _results;
+++};
+++
+++Opentip._hideGroup = function(group, originatingOpentip) {
+++  var opentip, _i, _len, _ref, _results;
+++  _ref = Opentip.tips;
+++  _results = [];
+++  for (_i = 0, _len = _ref.length; _i < _len; _i++) {
+++    opentip = _ref[_i];
+++    if (opentip !== originatingOpentip && opentip.options.group === group) {
+++      _results.push(opentip.hide());
+++    } else {
+++      _results.push(void 0);
+++    }
+++  }
+++  return _results;
+++};
+++
+++Opentip.adapters = {};
+++
+++Opentip.adapter = null;
+++
+++firstAdapter = true;
+++
+++Opentip.addAdapter = function(adapter) {
+++  Opentip.adapters[adapter.name] = adapter;
+++  if (firstAdapter) {
+++    Opentip.adapter = adapter;
+++    adapter.domReady(Opentip.findElements);
+++    adapter.domReady(Opentip.followMousePosition);
+++    return firstAdapter = false;
+++  }
+++};
+++
+++Opentip.positions = ["top", "topRight", "right", "bottomRight", "bottom", "bottomLeft", "left", "topLeft"];
+++
+++Opentip.position = {};
+++
+++_ref = Opentip.positions;
+++for (i = _i = 0, _len = _ref.length; _i < _len; i = ++_i) {
+++  position = _ref[i];
+++  Opentip.position[position] = i;
+++}
+++
+++Opentip.styles = {
+++  standard: {
+++    "extends": null,
+++    title: void 0,
+++    escapeTitle: true,
+++    escapeContent: false,
+++    className: "standard",
+++    stem: true,
+++    delay: null,
+++    hideDelay: 0.1,
+++    fixed: false,
+++    showOn: "mouseover",
+++    hideTrigger: "trigger",
+++    hideTriggers: [],
+++    hideOn: null,
+++    removeElementsOnHide: false,
+++    offset: [0, 0],
+++    containInViewport: true,
+++    autoOffset: true,
+++    showEffect: "appear",
+++    hideEffect: "fade",
+++    showEffectDuration: 0.3,
+++    hideEffectDuration: 0.2,
+++    stemLength: 5,
+++    stemBase: 8,
+++    tipJoint: "top left",
+++    target: null,
+++    targetJoint: null,
+++    cache: true,
+++    ajax: false,
+++    ajaxMethod: "GET",
+++    ajaxErrorMessage: "There was a problem downloading the content.",
+++    group: null,
+++    style: null,
+++    background: "#fff18f",
+++    backgroundGradientHorizontal: false,
+++    closeButtonOffset: [5, 5],
+++    closeButtonRadius: 7,
+++    closeButtonCrossSize: 4,
+++    closeButtonCrossColor: "#d2c35b",
+++    closeButtonCrossLineWidth: 1.5,
+++    closeButtonLinkOverscan: 6,
+++    borderRadius: 5,
+++    borderWidth: 1,
+++    borderColor: "#f2e37b",
+++    shadow: true,
+++    shadowBlur: 10,
+++    shadowOffset: [3, 3],
+++    shadowColor: "rgba(0, 0, 0, 0.1)"
+++  },
+++  glass: {
+++    "extends": "standard",
+++    className: "glass",
+++    background: [[0, "rgba(252, 252, 252, 0.8)"], [0.5, "rgba(255, 255, 255, 0.8)"], [0.5, "rgba(250, 250, 250, 0.9)"], [1, "rgba(245, 245, 245, 0.9)"]],
+++    borderColor: "#eee",
+++    closeButtonCrossColor: "rgba(0, 0, 0, 0.2)",
+++    borderRadius: 15,
+++    closeButtonRadius: 10,
+++    closeButtonOffset: [8, 8]
+++  },
+++  dark: {
+++    "extends": "standard",
+++    className: "dark",
+++    borderRadius: 13,
+++    borderColor: "#444",
+++    closeButtonCrossColor: "rgba(240, 240, 240, 1)",
+++    shadowColor: "rgba(0, 0, 0, 0.3)",
+++    shadowOffset: [2, 2],
+++    background: [[0, "rgba(30, 30, 30, 0.7)"], [0.5, "rgba(30, 30, 30, 0.8)"], [0.5, "rgba(10, 10, 10, 0.8)"], [1, "rgba(10, 10, 10, 0.9)"]]
+++  },
+++  alert: {
+++    "extends": "standard",
+++    className: "alert",
+++    borderRadius: 1,
+++    borderColor: "#AE0D11",
+++    closeButtonCrossColor: "rgba(255, 255, 255, 1)",
+++    shadowColor: "rgba(0, 0, 0, 0.3)",
+++    shadowOffset: [2, 2],
+++    background: [[0, "rgba(203, 15, 19, 0.7)"], [0.5, "rgba(203, 15, 19, 0.8)"], [0.5, "rgba(189, 14, 18, 0.8)"], [1, "rgba(179, 14, 17, 0.9)"]]
+++  }
+++};
+++
+++Opentip.defaultStyle = "standard";
+++
+++if (typeof module !== "undefined" && module !== null) {
+++  module.exports = Opentip;
+++} else {
+++  window.Opentip = Opentip;
+++}
+++
+++
+++// Generated by CoffeeScript 1.4.0
+++var __slice = [].slice;
+++
+++(function($) {
+++  var Adapter;
+++  $.fn.opentip = function(content, title, options) {
+++    return new Opentip(this, content, title, options);
+++  };
+++  Adapter = (function() {
+++
+++    function Adapter() {}
+++
+++    Adapter.prototype.name = "jquery";
+++
+++    Adapter.prototype.domReady = function(callback) {
+++      return $(callback);
+++    };
+++
+++    Adapter.prototype.create = function(html) {
+++      return $(html);
+++    };
+++
+++    Adapter.prototype.wrap = function(element) {
+++      element = $(element);
+++      if (element.length > 1) {
+++        throw new Error("Multiple elements provided.");
+++      }
+++      return element;
+++    };
+++
+++    Adapter.prototype.unwrap = function(element) {
+++      return $(element)[0];
+++    };
+++
+++    Adapter.prototype.tagName = function(element) {
+++      return this.unwrap(element).tagName;
+++    };
+++
+++    Adapter.prototype.attr = function() {
+++      var args, element, _ref;
+++      element = arguments[0], args = 2 <= arguments.length ? __slice.call(arguments, 1) : [];
+++      return (_ref = $(element)).attr.apply(_ref, args);
+++    };
+++
+++    Adapter.prototype.data = function() {
+++      var args, element, _ref;
+++      element = arguments[0], args = 2 <= arguments.length ? __slice.call(arguments, 1) : [];
+++      return (_ref = $(element)).data.apply(_ref, args);
+++    };
+++
+++    Adapter.prototype.find = function(element, selector) {
+++      return $(element).find(selector).get(0);
+++    };
+++
+++    Adapter.prototype.findAll = function(element, selector) {
+++      return $(element).find(selector);
+++    };
+++
+++    Adapter.prototype.update = function(element, content, escape) {
+++      element = $(element);
+++      if (escape) {
+++        return element.text(content);
+++      } else {
+++        return element.html(content);
+++      }
+++    };
+++
+++    Adapter.prototype.append = function(element, child) {
+++      return $(element).append(child);
+++    };
+++
+++    Adapter.prototype.remove = function(element) {
+++      return $(element).remove();
+++    };
+++
+++    Adapter.prototype.addClass = function(element, className) {
+++      return $(element).addClass(className);
+++    };
+++
+++    Adapter.prototype.removeClass = function(element, className) {
+++      return $(element).removeClass(className);
+++    };
+++
+++    Adapter.prototype.css = function(element, properties) {
+++      return $(element).css(properties);
+++    };
+++
+++    Adapter.prototype.dimensions = function(element) {
+++      return {
+++        width: $(element).outerWidth(),
+++        height: $(element).outerHeight()
+++      };
+++    };
+++
+++    Adapter.prototype.scrollOffset = function() {
+++      return [window.pageXOffset || document.documentElement.scrollLeft || document.body.scrollLeft, window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop];
+++    };
+++
+++    Adapter.prototype.viewportDimensions = function() {
+++      return {
+++        width: document.documentElement.clientWidth,
+++        height: document.documentElement.clientHeight
+++      };
+++    };
+++
+++    Adapter.prototype.mousePosition = function(e) {
+++      if (e == null) {
+++        return null;
+++      }
+++      return {
+++        x: e.pageX,
+++        y: e.pageY
+++      };
+++    };
+++
+++    Adapter.prototype.offset = function(element) {
+++      var offset;
+++      offset = $(element).offset();
+++      return {
+++        left: offset.left,
+++        top: offset.top
+++      };
+++    };
+++
+++    Adapter.prototype.observe = function(element, eventName, observer) {
+++      return $(element).bind(eventName, observer);
+++    };
+++
+++    Adapter.prototype.stopObserving = function(element, eventName, observer) {
+++      return $(element).unbind(eventName, observer);
+++    };
+++
+++    Adapter.prototype.ajax = function(options) {
+++      var _ref, _ref1;
+++      if (options.url == null) {
+++        throw new Error("No url provided");
+++      }
+++      return $.ajax({
+++        url: options.url,
+++        type: (_ref = (_ref1 = options.method) != null ? _ref1.toUpperCase() : void 0) != null ? _ref : "GET"
+++      }).done(function(content) {
+++        return typeof options.onSuccess === "function" ? options.onSuccess(content) : void 0;
+++      }).fail(function(request) {
+++        return typeof options.onError === "function" ? options.onError("Server responded with status " + request.status) : void 0;
+++      }).always(function() {
+++        return typeof options.onComplete === "function" ? options.onComplete() : void 0;
+++      });
+++    };
+++
+++    Adapter.prototype.clone = function(object) {
+++      return $.extend({}, object);
+++    };
+++
+++    Adapter.prototype.extend = function() {
+++      var sources, target;
+++      target = arguments[0], sources = 2 <= arguments.length ? __slice.call(arguments, 1) : [];
+++      return $.extend.apply($, [target].concat(__slice.call(sources)));
+++    };
+++
+++    return Adapter;
+++
+++  })();
+++  return Opentip.addAdapter(new Adapter);
+++})(jQuery);
+++});
++\ No newline at end of file
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/styles/FLATBOOTS/template/js/opentip-jquery.min.js" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/styles/FLATBOOTS/template/js/opentip-jquery.min.js"
++new file mode 100644
++index 000000000..c47ebb565
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/styles/FLATBOOTS/template/js/opentip-jquery.min.js"
++@@ -0,0 +1,6 @@
+++// Opentip v2.4.6
+++// Copyright (c) 2009-2012
+++// www.opentip.org
+++// MIT Licensed
+++head.ready(function(){var Opentip,firstAdapter,i,mouseMoved,mousePosition,mousePositionObservers,position,vendors,_i,_len,_ref,__slice=[].slice,__indexOf=[].indexOf||function(t){for(var e=0,i=this.length;i>e;e++)if(e in this&&this[e]===t)return e;return-1},__hasProp={}.hasOwnProperty;for(Opentip=function(){function t(e,i,o,s){var n,r,a,h,p,d,l,u,c,g,f,m,v,b,w=this;if(this.id=++t.lastId,this.debug("Creating Opentip."),t.tips.push(this),this.adapter=t.adapter,n=this.adapter.data(e,"opentips")||[],n.push(this),this.adapter.data(e,"opentips",n),this.triggerElement=this.adapter.wrap(e),this.triggerElement.length>1)throw Error("You can't call Opentip on multiple elements.");if(1>this.triggerElement.length)throw Error("Invalid element.");this.loaded=!1,this.loading=!1,this.visible=!1,this.waitingToShow=!1,this.waitingToHide=!1,this.currentPosition={left:0,top:0},this.dimensions={width:100,height:50},this.content="",this.redraw=!0,this.currentObservers={showing:!1,visible:!1,hiding:!1,hidden:!1},s=this.adapter.clone(s),typeof i=="object"?(s=i,i=o=void 0):typeof o=="object"&&(s=o,o=void 0),o!=null&&(s.title=o),i!=null&&this.setContent(i),s["extends"]==null&&(s["extends"]=s.style!=null?s.style:t.defaultStyle),h=[s],b=s;while(b["extends"]){if(d=b["extends"],b=t.styles[d],b==null)throw Error("Invalid style: "+d);h.unshift(b),b["extends"]==null&&d!=="standard"&&(b["extends"]="standard")}for(s=(f=this.adapter).extend.apply(f,[{}].concat(__slice.call(h))),s.hideTriggers=function(){var t,e,i,o;for(i=s.hideTriggers,o=[],t=0,e=i.length;e>t;t++)r=i[t],o.push(r);return o}(),s.hideTrigger&&s.hideTriggers.length===0&&s.hideTriggers.push(s.hideTrigger),m=["tipJoint","targetJoint","stem"],l=0,c=m.length;c>l;l++)p=m[l],s[p]&&typeof s[p]=="string"&&(s[p]=new t.Joint(s[p]));for(!s.ajax||s.ajax!==!0&&s.ajax||(s.ajax=this.adapter.tagName(this.triggerElement)==="A"?this.adapter.attr(this.triggerElement,"href"):!1),s.showOn==="click"&&this.adapter.tagName(this.triggerElement)==="A"&&this.adapter.observe(this.triggerElement,"click",function(t){return t.preventDefault(),t.stopPropagation(),t.stopped=!0}),s.target&&(s.fixed=!0),s.stem===!0&&(s.stem=new t.Joint(s.tipJoint)),s.target===!0?s.target=this.triggerElement:s.target&&(s.target=this.adapter.wrap(s.target)),this.currentStem=s.stem,s.delay==null&&(s.delay=s.showOn==="mouseover"?.2:0),s.targetJoint==null&&(s.targetJoint=new t.Joint(s.tipJoint).flip()),this.showTriggers=[],this.showTriggersWhenVisible=[],this.hideTriggers=[],s.showOn&&s.showOn!=="creation"&&this.showTriggers.push({element:this.triggerElement,event:s.showOn}),s.ajaxCache!=null&&(s.cache=s.ajaxCache,delete s.ajaxCache),this.options=s,this.bound={},v=["prepareToShow","prepareToHide","show","hide","reposition"],u=0,g=v.length;g>u;u++)a=v[u],this.bound[a]=function(t){return function(){return w[t].apply(w,arguments)}}(a);this.adapter.domReady(function(){return w.activate(),w.options.showOn==="creation"?w.prepareToShow():void 0})}return t.prototype.STICKS_OUT_TOP=1,t.prototype.STICKS_OUT_BOTTOM=2,t.prototype.STICKS_OUT_LEFT=1,t.prototype.STICKS_OUT_RIGHT=2,t.prototype["class"]={container:"opentip-container",opentip:"opentip",header:"ot-header",content:"ot-content",loadingIndicator:"ot-loading-indicator",close:"ot-close",goingToHide:"ot-going-to-hide",hidden:"ot-hidden",hiding:"ot-hiding",goingToShow:"ot-going-to-show",showing:"ot-showing",visible:"ot-visible",loading:"ot-loading",ajaxError:"ot-ajax-error",fixed:"ot-fixed",showEffectPrefix:"ot-show-effect-",hideEffectPrefix:"ot-hide-effect-",stylePrefix:"style-"},t.prototype._setup=function(){var t,e,i,o,s,n,r,a,h,p,d;for(this.debug("Setting up the tooltip."),this._buildContainer(),this.hideTriggers=[],h=this.options.hideTriggers,o=s=0,r=h.length;r>s;o=++s){if(e=h[o],i=null,t=this.options.hideOn instanceof Array?this.options.hideOn[o]:this.options.hideOn,typeof e=="string")switch(e){case"trigger":t=t||"mouseout",i=this.triggerElement;break;case"tip":t=t||"mouseover",i=this.container;break;case"target":t=t||"mouseover",i=this.options.target;break;case"closeButton":break;default:throw Error("Unknown hide trigger: "+e+".")}else t=t||"mouseover",i=this.adapter.wrap(e);i&&this.hideTriggers.push({element:i,event:t,original:e})}for(p=this.hideTriggers,d=[],n=0,a=p.length;a>n;n++)e=p[n],d.push(this.showTriggersWhenVisible.push({element:e.element,event:"mouseover"}));return d},t.prototype._buildContainer=function(){return this.container=this.adapter.create('<div id="opentip-'+this.id+'" class="'+this["class"].container+" "+this["class"].hidden+" "+this["class"].stylePrefix+this.options.className+'"></div>'),this.adapter.css(this.container,{position:"absolute"}),this.options.ajax&&this.adapter.addClass(this.container,this["class"].loading),this.options.fixed&&this.adapter.addClass(this.container,this["class"].fixed),this.options.showEffect&&this.adapter.addClass(this.container,""+this["class"].showEffectPrefix+this.options.showEffect),this.options.hideEffect?this.adapter.addClass(this.container,""+this["class"].hideEffectPrefix+this.options.hideEffect):void 0},t.prototype._buildElements=function(){var t,e;return this.tooltipElement=this.adapter.create('<div class="'+this["class"].opentip+'"><div class="'+this["class"].header+'"></div><div class="'+this["class"].content+'"></div></div>'),this.backgroundCanvas=this.adapter.wrap(document.createElement("canvas")),this.adapter.css(this.backgroundCanvas,{position:"absolute"}),typeof G_vmlCanvasManager!="undefined"&&G_vmlCanvasManager!==null&&G_vmlCanvasManager.initElement(this.adapter.unwrap(this.backgroundCanvas)),t=this.adapter.find(this.tooltipElement,"."+this["class"].header),this.options.title&&(e=this.adapter.create("<h1></h1>"),this.adapter.update(e,this.options.title,this.options.escapeTitle),this.adapter.append(t,e)),this.options.ajax&&!this.loaded&&this.adapter.append(this.tooltipElement,this.adapter.create('<div class="'+this["class"].loadingIndicator+'"><span>↻</span></div>')),__indexOf.call(this.options.hideTriggers,"closeButton")>=0&&(this.closeButtonElement=this.adapter.create('<a href="javascript:undefined;" class="'+this["class"].close+'"><span>Close</span></a>'),this.adapter.append(t,this.closeButtonElement)),this.adapter.append(this.container,this.backgroundCanvas),this.adapter.append(this.container,this.tooltipElement),this.adapter.append(document.body,this.container),this._newContent=!0,this.redraw=!0},t.prototype.setContent=function(t){return this.content=t,this._newContent=!0,typeof this.content=="function"?(this._contentFunction=this.content,this.content=""):this._contentFunction=null,this.visible?this._updateElementContent():void 0},t.prototype._updateElementContent=function(){var t;return(this._newContent||!this.options.cache&&this._contentFunction)&&(t=this.adapter.find(this.container,"."+this["class"].content),t!=null&&(this._contentFunction&&(this.debug("Executing content function."),this.content=this._contentFunction(this)),this.adapter.update(t,this.content,this.options.escapeContent)),this._newContent=!1),this._storeAndLockDimensions(),this.reposition()},t.prototype._storeAndLockDimensions=function(){var t;if(this.container)return t=this.dimensions,this.adapter.css(this.container,{width:"auto",left:"0px",top:"0px"}),this.dimensions=this.adapter.dimensions(this.container),this.dimensions.width+=1,this.adapter.css(this.container,{width:""+this.dimensions.width+"px",top:""+this.currentPosition.top+"px",left:""+this.currentPosition.left+"px"}),this._dimensionsEqual(this.dimensions,t)?void 0:(this.redraw=!0,this._draw())},t.prototype.activate=function(){return this._setupObservers("hidden","hiding")},t.prototype.deactivate=function(){return this.debug("Deactivating tooltip."),this.hide(),this._setupObservers("-showing","-visible","-hidden","-hiding")},t.prototype._setupObservers=function(){var t,e,i,o,s,n,r,a,h,p,d,l,u,c,g,f,m=this;for(o=arguments.length>=1?__slice.call(arguments,0):[],n=0,p=o.length;p>n;n++)if(i=o[n],e=!1,i.charAt(0)==="-"&&(e=!0,i=i.substr(1)),this.currentObservers[i]!==!e)switch(this.currentObservers[i]=!e,t=function(){var t,i,o;return t=arguments.length>=1?__slice.call(arguments,0):[],e?(i=m.adapter).stopObserving.apply(i,t):(o=m.adapter).observe.apply(o,t)},i){case"showing":for(c=this.hideTriggers,r=0,d=c.length;d>r;r++)s=c[r],t(s.element,s.event,this.bound.prepareToHide);t(document.onresize!=null?document:window,"resize",this.bound.reposition),t(window,"scroll",this.bound.reposition);break;case"visible":for(g=this.showTriggersWhenVisible,a=0,l=g.length;l>a;a++)s=g[a],t(s.element,s.event,this.bound.prepareToShow);break;case"hiding":for(f=this.showTriggers,h=0,u=f.length;u>h;h++)s=f[h],t(s.element,s.event,this.bound.prepareToShow);break;case"hidden":break;default:throw Error("Unknown state: "+i)}return null},t.prototype.prepareToShow=function(){return this._abortHiding(),this._abortShowing(),this.visible?void 0:(this.debug("Showing in "+this.options.delay+"s."),this.container==null&&this._setup(),this.options.group&&t._abortShowingGroup(this.options.group,this),this.preparingToShow=!0,this._setupObservers("-hidden","-hiding","showing"),this._followMousePosition(),this.options.fixed&&!this.options.target&&(this.initialMousePosition=mousePosition),this.reposition(),this._showTimeoutId=this.setTimeout(this.bound.show,this.options.delay||0))},t.prototype.show=function(){var e=this;return this._abortHiding(),this.visible?void 0:(this._clearTimeouts(),this._triggerElementExists()?(this.debug("Showing now."),this.container==null&&this._setup(),this.options.group&&t._hideGroup(this.options.group,this),this.visible=!0,this.preparingToShow=!1,this.tooltipElement==null&&this._buildElements(),this._updateElementContent(),!this.options.ajax||this.loaded&&this.options.cache||this._loadAjax(),this._searchAndActivateCloseButtons(),this._startEnsureTriggerElement(),this.adapter.css(this.container,{zIndex:t.lastZIndex++}),this._setupObservers("-hidden","-hiding","-showing","-visible","showing","visible"),this.options.fixed&&!this.options.target&&(this.initialMousePosition=mousePosition),this.reposition(),this.adapter.removeClass(this.container,this["class"].hiding),this.adapter.removeClass(this.container,this["class"].hidden),this.adapter.addClass(this.container,this["class"].goingToShow),this.setCss3Style(this.container,{transitionDuration:"0s"}),this.defer(function(){var t;if(e.visible&&!e.preparingToHide)return e.adapter.removeClass(e.container,e["class"].goingToShow),e.adapter.addClass(e.container,e["class"].showing),t=0,e.options.showEffect&&e.options.showEffectDuration&&(t=e.options.showEffectDuration),e.setCss3Style(e.container,{transitionDuration:""+t+"s"}),e._visibilityStateTimeoutId=e.setTimeout(function(){return e.adapter.removeClass(e.container,e["class"].showing),e.adapter.addClass(e.container,e["class"].visible)},t),e._activateFirstInput()}),this._draw()):this.deactivate())},t.prototype._abortShowing=function(){return this.preparingToShow?(this.debug("Aborting showing."),this._clearTimeouts(),this._stopFollowingMousePosition(),this.preparingToShow=!1,this._setupObservers("-showing","-visible","hiding","hidden")):void 0},t.prototype.prepareToHide=function(){return this._abortShowing(),this._abortHiding(),this.visible?(this.debug("Hiding in "+this.options.hideDelay+"s"),this.preparingToHide=!0,this._setupObservers("-showing","visible","-hidden","hiding"),this._hideTimeoutId=this.setTimeout(this.bound.hide,this.options.hideDelay)):void 0},t.prototype.hide=function(){var t=this;return this._abortShowing(),this.visible&&(this._clearTimeouts(),this.debug("Hiding!"),this.visible=!1,this.preparingToHide=!1,this._stopEnsureTriggerElement(),this._setupObservers("-showing","-visible","-hiding","-hidden","hiding","hidden"),this.options.fixed||this._stopFollowingMousePosition(),this.container)?(this.adapter.removeClass(this.container,this["class"].visible),this.adapter.removeClass(this.container,this["class"].showing),this.adapter.addClass(this.container,this["class"].goingToHide),this.setCss3Style(this.container,{transitionDuration:"0s"}),this.defer(function(){var e;return t.adapter.removeClass(t.container,t["class"].goingToHide),t.adapter.addClass(t.container,t["class"].hiding),e=0,t.options.hideEffect&&t.options.hideEffectDuration&&(e=t.options.hideEffectDuration),t.setCss3Style(t.container,{transitionDuration:""+e+"s"}),t._visibilityStateTimeoutId=t.setTimeout(function(){return t.adapter.removeClass(t.container,t["class"].hiding),t.adapter.addClass(t.container,t["class"].hidden),t.setCss3Style(t.container,{transitionDuration:"0s"}),t.options.removeElementsOnHide?(t.debug("Removing HTML elements."),t.adapter.remove(t.container),delete t.container,delete t.tooltipElement):void 0},e)})):void 0},t.prototype._abortHiding=function(){return this.preparingToHide?(this.debug("Aborting hiding."),this._clearTimeouts(),this.preparingToHide=!1,this._setupObservers("-hiding","showing","visible")):void 0},t.prototype.reposition=function(){var t,e,i,o=this;return t=this.getPosition(),t==null||(e=this.options.stem,this.options.containInViewport&&(i=this._ensureViewportContainment(t),t=i.position,e=i.stem),this._positionsEqual(t,this.currentPosition))?void 0:(this.options.stem&&!e.eql(this.currentStem)&&(this.redraw=!0),this.currentPosition=t,this.currentStem=e,this._draw(),this.adapter.css(this.container,{left:""+t.left+"px",top:""+t.top+"px"}),this.defer(function(){var t,e;return t=o.adapter.unwrap(o.container),t.style.visibility="hidden",e=t.offsetHeight,t.style.visibility="visible"}))},t.prototype.getPosition=function(t,e,i){var o,s,n,r,a,h,p,d,l;if(this.container)return t==null&&(t=this.options.tipJoint),e==null&&(e=this.options.targetJoint),r={},this.options.target?(p=this.adapter.offset(this.options.target),h=this.adapter.dimensions(this.options.target),r=p,e.right?(d=this.adapter.unwrap(this.options.target),d.getBoundingClientRect!=null?r.left=d.getBoundingClientRect().right+((l=window.pageXOffset)!=null?l:document.body.scrollLeft):r.left+=h.width):e.center&&(r.left+=Math.round(h.width/2)),e.bottom?r.top+=h.height:e.middle&&(r.top+=Math.round(h.height/2)),this.options.borderWidth&&(this.options.tipJoint.left&&(r.left+=this.options.borderWidth),this.options.tipJoint.right&&(r.left-=this.options.borderWidth),this.options.tipJoint.top?r.top+=this.options.borderWidth:this.options.tipJoint.bottom&&(r.top-=this.options.borderWidth))):r=this.initialMousePosition?{top:this.initialMousePosition.y,left:this.initialMousePosition.x}:{top:mousePosition.y,left:mousePosition.x},this.options.autoOffset&&(a=this.options.stem?this.options.stemLength:0,n=a&&this.options.fixed?2:10,o=t.middle&&!this.options.fixed?15:0,s=t.center&&!this.options.fixed?15:0,t.right?r.left-=n+o:t.left&&(r.left+=n+o),t.bottom?r.top-=n+s:t.top&&(r.top+=n+s),a&&(i==null&&(i=this.options.stem),i.right?r.left-=a:i.left&&(r.left+=a),i.bottom?r.top-=a:i.top&&(r.top+=a))),r.left+=this.options.offset[0],r.top+=this.options.offset[1],t.right?r.left-=this.dimensions.width:t.center&&(r.left-=Math.round(this.dimensions.width/2)),t.bottom?r.top-=this.dimensions.height:t.middle&&(r.top-=Math.round(this.dimensions.height/2)),r},t.prototype._ensureViewportContainment=function(e){var i,o,s,n,r,a,h,p,d,l,u,c;if(h=this.options.stem,s={position:e,stem:h},!this.visible||!e)return s;if(p=this._sticksOut(e),!p[0]&&!p[1])return s;if(l=new t.Joint(this.options.tipJoint),this.options.targetJoint&&(d=new t.Joint(this.options.targetJoint)),a=this.adapter.scrollOffset(),u=this.adapter.viewportDimensions(),c=[e.left-a[0],e.top-a[1]],i=!1,u.width>=this.dimensions.width&&p[0])switch(i=!0,p[0]){case this.STICKS_OUT_LEFT:l.setHorizontal("left"),this.options.targetJoint&&d.setHorizontal("right");break;case this.STICKS_OUT_RIGHT:l.setHorizontal("right"),this.options.targetJoint&&d.setHorizontal("left")}if(u.height>=this.dimensions.height&&p[1])switch(i=!0,p[1]){case this.STICKS_OUT_TOP:l.setVertical("top"),this.options.targetJoint&&d.setVertical("bottom");break;case this.STICKS_OUT_BOTTOM:l.setVertical("bottom"),this.options.targetJoint&&d.setVertical("top")}return i?(this.options.stem&&(h=l),e=this.getPosition(l,d,h),o=this._sticksOut(e),n=!1,r=!1,o[0]&&o[0]!==p[0]&&(n=!0,l.setHorizontal(this.options.tipJoint.horizontal),this.options.targetJoint&&d.setHorizontal(this.options.targetJoint.horizontal)),o[1]&&o[1]!==p[1]&&(r=!0,l.setVertical(this.options.tipJoint.vertical),this.options.targetJoint&&d.setVertical(this.options.targetJoint.vertical)),n&&r?s:((n||r)&&(this.options.stem&&(h=l),e=this.getPosition(l,d,h)),{position:e,stem:h})):s},t.prototype._sticksOut=function(t){var e,i,o,s;return i=this.adapter.scrollOffset(),s=this.adapter.viewportDimensions(),e=[t.left-i[0],t.top-i[1]],o=[!1,!1],0>e[0]?o[0]=this.STICKS_OUT_LEFT:e[0]+this.dimensions.width>s.width&&(o[0]=this.STICKS_OUT_RIGHT),0>e[1]?o[1]=this.STICKS_OUT_TOP:e[1]+this.dimensions.height>s.height&&(o[1]=this.STICKS_OUT_BOTTOM),o},t.prototype._draw=function(){var e,i,o,s,n,r,a,h,p,d,l,u,c,g,f,m,v,b,w,_=this;if(this.backgroundCanvas&&this.redraw){if(this.debug("Drawing background."),this.redraw=!1,this.currentStem){for(v=["top","right","bottom","left"],f=0,m=v.length;m>f;f++)u=v[f],this.adapter.removeClass(this.container,"stem-"+u);this.adapter.addClass(this.container,"stem-"+this.currentStem.horizontal),this.adapter.addClass(this.container,"stem-"+this.currentStem.vertical)}return r=[0,0],a=[0,0],__indexOf.call(this.options.hideTriggers,"closeButton")>=0&&(n=new t.Joint(((b=this.currentStem)!=null?b+"":void 0)==="top right"?"top left":"top right"),r=[this.options.closeButtonRadius+this.options.closeButtonOffset[0],this.options.closeButtonRadius+this.options.closeButtonOffset[1]],a=[this.options.closeButtonRadius-this.options.closeButtonOffset[0],this.options.closeButtonRadius-this.options.closeButtonOffset[1]]),o=this.adapter.clone(this.dimensions),s=[0,0],this.options.borderWidth&&(o.width+=this.options.borderWidth*2,o.height+=this.options.borderWidth*2,s[0]-=this.options.borderWidth,s[1]-=this.options.borderWidth),this.options.shadow&&(o.width+=this.options.shadowBlur*2,o.width+=Math.max(0,this.options.shadowOffset[0]-this.options.shadowBlur*2),o.height+=this.options.shadowBlur*2,o.height+=Math.max(0,this.options.shadowOffset[1]-this.options.shadowBlur*2),s[0]-=Math.max(0,this.options.shadowBlur-this.options.shadowOffset[0]),s[1]-=Math.max(0,this.options.shadowBlur-this.options.shadowOffset[1])),i={left:0,right:0,top:0,bottom:0},this.currentStem&&(this.currentStem.left?i.left=this.options.stemLength:this.currentStem.right&&(i.right=this.options.stemLength),this.currentStem.top?i.top=this.options.stemLength:this.currentStem.bottom&&(i.bottom=this.options.stemLength)),n&&(n.left?i.left=Math.max(i.left,a[0]):n.right&&(i.right=Math.max(i.right,a[0])),n.top?i.top=Math.max(i.top,a[1]):n.bottom&&(i.bottom=Math.max(i.bottom,a[1]))),o.width+=i.left+i.right,o.height+=i.top+i.bottom,s[0]-=i.left,s[1]-=i.top,this.currentStem&&this.options.borderWidth&&(w=this._getPathStemMeasures(this.options.stemBase,this.options.stemLength,this.options.borderWidth),g=w.stemLength,c=w.stemBase),e=this.adapter.unwrap(this.backgroundCanvas),e.width=o.width,e.height=o.height,this.adapter.css(this.backgroundCanvas,{width:""+e.width+"px",height:""+e.height+"px",left:""+s[0]+"px",top:""+s[1]+"px"}),h=e.getContext("2d"),h.setTransform(1,0,0,1,0,0),h.clearRect(0,0,e.width,e.height),h.beginPath(),h.fillStyle=this._getColor(h,this.dimensions,this.options.background,this.options.backgroundGradientHorizontal),h.lineJoin="miter",h.miterLimit=500,l=this.options.borderWidth/2,this.options.borderWidth?(h.strokeStyle=this.options.borderColor,h.lineWidth=this.options.borderWidth):(g=this.options.stemLength,c=this.options.stemBase),c==null&&(c=0),d=function(t,e,i){return i&&h.moveTo(Math.max(c,_.options.borderRadius,r[0])+1-l,-l),e?(h.lineTo(t/2-c/2,-l),h.lineTo(t/2,-g-l),h.lineTo(t/2+c/2,-l)):void 0},p=function(t,e,i){var o,s,n,a;return t?(h.lineTo(-c+l,0-l),h.lineTo(g+l,-g-l),h.lineTo(l,c-l)):e?(a=_.options.closeButtonOffset,n=r[0],i%2!==0&&(a=[a[1],a[0]],n=r[1]),o=Math.acos(a[1]/_.options.closeButtonRadius),s=Math.acos(a[0]/_.options.closeButtonRadius),h.lineTo(-n+l,-l),h.arc(l-a[0],-l+a[1],_.options.closeButtonRadius,-(Math.PI/2+o),s,!1)):(h.lineTo(-_.options.borderRadius+l,-l),h.quadraticCurveTo(l,-l,l,_.options.borderRadius-l))},h.translate(-s[0],-s[1]),h.save(),function(){var e,i,o,s,r,a,l,u,c,g,f;for(f=[],i=c=0,g=t.positions.length/2;g>=0?g>c:c>g;i=g>=0?++c:--c)r=i*2,a=i===0||i===3?0:_.dimensions.width,l=2>i?0:_.dimensions.height,u=Math.PI/2*i,o=i%2===0?_.dimensions.width:_.dimensions.height,s=new t.Joint(t.positions[r]),e=new t.Joint(t.positions[r+1]),h.save(),h.translate(a,l),h.rotate(u),d(o,s.eql(_.currentStem),i===0),h.translate(o,0),p(e.eql(_.currentStem),e.eql(n),i),f.push(h.restore());return f}(),h.closePath(),h.save(),this.options.shadow&&(h.shadowColor=this.options.shadowColor,h.shadowBlur=this.options.shadowBlur,h.shadowOffsetX=this.options.shadowOffset[0],h.shadowOffsetY=this.options.shadowOffset[1]),h.fill(),h.restore(),this.options.borderWidth&&h.stroke(),h.restore(),n?function(){var t,e,i,o,s;return i=e=_.options.closeButtonRadius*2,n+""=="top right"?(s=[_.dimensions.width-_.options.closeButtonOffset[0],_.options.closeButtonOffset[1]],t=[s[0]+l,s[1]-l]):(s=[_.options.closeButtonOffset[0],_.options.closeButtonOffset[1]],t=[s[0]-l,s[1]-l]),h.translate(t[0],t[1]),o=_.options.closeButtonCrossSize/2,h.save(),h.beginPath(),h.strokeStyle=_.options.closeButtonCrossColor,h.lineWidth=_.options.closeButtonCrossLineWidth,h.lineCap="round",h.moveTo(-o,-o),h.lineTo(o,o),h.stroke(),h.beginPath(),h.moveTo(o,-o),h.lineTo(-o,o),h.stroke(),h.restore(),_.adapter.css(_.closeButtonElement,{left:""+(s[0]-o-_.options.closeButtonLinkOverscan)+"px",top:""+(s[1]-o-_.options.closeButtonLinkOverscan)+"px",width:""+(_.options.closeButtonCrossSize+_.options.closeButtonLinkOverscan*2)+"px",height:""+(_.options.closeButtonCrossSize+_.options.closeButtonLinkOverscan*2)+"px"})}():void 0}},t.prototype._getPathStemMeasures=function(t,e,i){var o,s,n,r,a,h,p;if(r=i/2,n=Math.atan(t/2/e),o=n*2,a=r/Math.sin(o),s=2*a*Math.cos(n),p=r+e-s,0>p)throw Error("Sorry but your stemLength / stemBase ratio is strange.");return h=Math.tan(n)*p*2,{stemLength:p,stemBase:h}},t.prototype._getColor=function(t,e,i,o){var s,n,r,a,h;if(o==null&&(o=!1),typeof i=="string")return i;for(n=o?t.createLinearGradient(0,0,e.width,0):t.createLinearGradient(0,0,0,e.height),r=a=0,h=i.length;h>a;r=++a)s=i[r],n.addColorStop(s[0],s[1]);return n},t.prototype._searchAndActivateCloseButtons=function(){var t,e,i,o;for(o=this.adapter.findAll(this.container,"."+this["class"].close),e=0,i=o.length;i>e;e++)t=o[e],this.hideTriggers.push({element:this.adapter.wrap(t),event:"click"});return this.currentObservers.showing&&this._setupObservers("-showing","showing"),this.currentObservers.visible?this._setupObservers("-visible","visible"):void 0},t.prototype._activateFirstInput=function(){var t;return t=this.adapter.unwrap(this.adapter.find(this.container,"input, textarea")),t!=null?typeof t.focus=="function"?t.focus():void 0:void 0},t.prototype._followMousePosition=function(){return this.options.fixed?void 0:t._observeMousePosition(this.bound.reposition)},t.prototype._stopFollowingMousePosition=function(){return this.options.fixed?void 0:t._stopObservingMousePosition(this.bound.reposition)},t.prototype._clearShowTimeout=function(){return clearTimeout(this._showTimeoutId)},t.prototype._clearHideTimeout=function(){return clearTimeout(this._hideTimeoutId)},t.prototype._clearTimeouts=function(){return clearTimeout(this._visibilityStateTimeoutId),this._clearShowTimeout(),this._clearHideTimeout()},t.prototype._triggerElementExists=function(){var t;t=this.adapter.unwrap(this.triggerElement);while(t.parentNode){if(t.parentNode.tagName==="BODY")return!0;t=t.parentNode}return!1},t.prototype._loadAjax=function(){var t=this;if(!this.loading)return this.loaded=!1,this.loading=!0,this.adapter.addClass(this.container,this["class"].loading),this.setContent(""),this.debug("Loading content from "+this.options.ajax),this.adapter.ajax({url:this.options.ajax,method:this.options.ajaxMethod,onSuccess:function(e){return t.debug("Loading successful."),t.adapter.removeClass(t.container,t["class"].loading),t.setContent(e)},onError:function(e){var i;return i=t.options.ajaxErrorMessage,t.debug(i,e),t.setContent(i),t.adapter.addClass(t.container,t["class"].ajaxError)},onComplete:function(){return t.adapter.removeClass(t.container,t["class"].loading),t.loading=!1,t.loaded=!0,t._searchAndActivateCloseButtons(),t._activateFirstInput(),t.reposition()}})},t.prototype._ensureTriggerElement=function(){return this._triggerElementExists()?void 0:(this.deactivate(),this._stopEnsureTriggerElement())},t.prototype._ensureTriggerElementInterval=1e3,t.prototype._startEnsureTriggerElement=function(){var t=this;return this._ensureTriggerElementTimeoutId=setInterval(function(){return t._ensureTriggerElement()},this._ensureTriggerElementInterval)},t.prototype._stopEnsureTriggerElement=function(){return clearInterval(this._ensureTriggerElementTimeoutId)},t}(),vendors=["khtml","ms","o","moz","webkit"],Opentip.prototype.setCss3Style=function(t,e){var i,o,s,n,r;t=this.adapter.unwrap(t),r=[];for(i in e)__hasProp.call(e,i)&&(o=e[i],t.style[i]!=null?r.push(t.style[i]=o):r.push(function(){var e,r,a;for(a=[],e=0,r=vendors.length;r>e;e++)s=vendors[e],n=""+this.ucfirst(s)+this.ucfirst(i),t.style[n]!=null?a.push(t.style[n]=o):a.push(void 0);return a}.call(this)));return r},Opentip.prototype.defer=function(t){return setTimeout(t,0)},Opentip.prototype.setTimeout=function(t,e){return setTimeout(t,e?e*1e3:0)},Opentip.prototype.ucfirst=function(t){return t==null?"":t.charAt(0).toUpperCase()+t.slice(1)},Opentip.prototype.dasherize=function(t){return t.replace(/([A-Z])/g,function(t,e){return"-"+e.toLowerCase()})},mousePositionObservers=[],mousePosition={x:0,y:0},mouseMoved=function(t){var e,i,o,s;for(mousePosition=Opentip.adapter.mousePosition(t),s=[],i=0,o=mousePositionObservers.length;o>i;i++)e=mousePositionObservers[i],s.push(e());return s},Opentip.followMousePosition=function(){return Opentip.adapter.observe(document.body,"mousemove",mouseMoved)},Opentip._observeMousePosition=function(t){return mousePositionObservers.push(t)},Opentip._stopObservingMousePosition=function(t){var e;return mousePositionObservers=function(){var i,o,s;for(s=[],i=0,o=mousePositionObservers.length;o>i;i++)e=mousePositionObservers[i],e!==t&&s.push(e);return s}()},Opentip.Joint=function(){function t(t){t!=null&&(t instanceof Opentip.Joint&&(t+=""),this.set(t))}return t.prototype.set=function(t){return t=t.toLowerCase(),this.setHorizontal(t),this.setVertical(t),this},t.prototype.setHorizontal=function(t){var e,i,o,s,n,r,a;for(i=["left","center","right"],o=0,n=i.length;n>o;o++)e=i[o],~t.indexOf(e)&&(this.horizontal=e.toLowerCase());for(this.horizontal==null&&(this.horizontal="center"),a=[],s=0,r=i.length;r>s;s++)e=i[s],a.push(this[e]=this.horizontal===e?e:void 0);return a},t.prototype.setVertical=function(t){var e,i,o,s,n,r,a;for(i=["top","middle","bottom"],o=0,n=i.length;n>o;o++)e=i[o],~t.indexOf(e)&&(this.vertical=e.toLowerCase());for(this.vertical==null&&(this.vertical="middle"),a=[],s=0,r=i.length;r>s;s++)e=i[s],a.push(this[e]=this.vertical===e?e:void 0);return a},t.prototype.eql=function(t){return t!=null&&this.horizontal===t.horizontal&&this.vertical===t.vertical},t.prototype.flip=function(){var t,e;return e=Opentip.position[this.toString(!0)],t=(e+4)%8,this.set(Opentip.positions[t]),this},t.prototype.toString=function(t){var e,i;return t==null&&(t=!1),i=this.vertical==="middle"?"":this.vertical,e=this.horizontal==="center"?"":this.horizontal,i&&e&&(e=t?Opentip.prototype.ucfirst(e):" "+e),""+i+e},t}(),Opentip.prototype._positionsEqual=function(t,e){return t!=null&&e!=null&&t.left===e.left&&t.top===e.top},Opentip.prototype._dimensionsEqual=function(t,e){return t!=null&&e!=null&&t.width===e.width&&t.height===e.height},Opentip.prototype.debug=function(){var t;return t=arguments.length>=1?__slice.call(arguments,0):[],Opentip.debug&&(typeof console!="undefined"&&console!==null?console.debug:void 0)!=null?(t.unshift("#"+this.id+" |"),console.debug.apply(console,t)):void 0},Opentip.findElements=function(){var t,e,i,o,s,n,r,a,h,p;for(t=Opentip.adapter,h=t.findAll(document.body,"[data-ot]"),p=[],r=0,a=h.length;a>r;r++){i=h[r],n={},e=t.data(i,"ot"),(e===""||e==="true"||e==="yes")&&(e=t.attr(i,"title"),t.attr(i,"title","")),e=e||"";for(o in Opentip.styles.standard)s=t.data(i,"ot"+Opentip.prototype.ucfirst(o)),s!=null&&(s==="yes"||s==="true"||s==="on"?s=!0:(s==="no"||s==="false"||s==="off")&&(s=!1),n[o]=s);p.push(new Opentip(i,e,n))}return p},Opentip.version="2.4.6",Opentip.debug=!1,Opentip.lastId=0,Opentip.lastZIndex=100,Opentip.tips=[],Opentip._abortShowingGroup=function(t,e){var i,o,s,n,r;for(n=Opentip.tips,r=[],o=0,s=n.length;s>o;o++)i=n[o],i!==e&&i.options.group===t?r.push(i._abortShowing()):r.push(void 0);return r},Opentip._hideGroup=function(t,e){var i,o,s,n,r;for(n=Opentip.tips,r=[],o=0,s=n.length;s>o;o++)i=n[o],i!==e&&i.options.group===t?r.push(i.hide()):r.push(void 0);return r},Opentip.adapters={},Opentip.adapter=null,firstAdapter=!0,Opentip.addAdapter=function(t){return Opentip.adapters[t.name]=t,firstAdapter?(Opentip.adapter=t,t.domReady(Opentip.findElements),t.domReady(Opentip.followMousePosition),firstAdapter=!1):void 0},Opentip.positions=["top","topRight","right","bottomRight","bottom","bottomLeft","left","topLeft"],Opentip.position={},_ref=Opentip.positions,i=_i=0,_len=_ref.length;_len>_i;i=++_i)position=_ref[i],Opentip.position[position]=i;Opentip.styles={standard:{"extends":null,title:void 0,escapeTitle:!0,escapeContent:!1,className:"standard",stem:!0,delay:null,hideDelay:.1,fixed:!1,showOn:"mouseover",hideTrigger:"trigger",hideTriggers:[],hideOn:null,removeElementsOnHide:!1,offset:[0,0],containInViewport:!0,autoOffset:!0,showEffect:"appear",hideEffect:"fade",showEffectDuration:.3,hideEffectDuration:.2,stemLength:5,stemBase:8,tipJoint:"top left",target:null,targetJoint:null,cache:!0,ajax:!1,ajaxMethod:"GET",ajaxErrorMessage:"There was a problem downloading the content.",group:null,style:null,background:"#fff18f",backgroundGradientHorizontal:!1,closeButtonOffset:[5,5],closeButtonRadius:7,closeButtonCrossSize:4,closeButtonCrossColor:"#d2c35b",closeButtonCrossLineWidth:1.5,closeButtonLinkOverscan:6,borderRadius:5,borderWidth:1,borderColor:"#f2e37b",shadow:!0,shadowBlur:10,shadowOffset:[3,3],shadowColor:"rgba(0, 0, 0, 0.1)"},glass:{"extends":"standard",className:"glass",background:[[0,"rgba(252, 252, 252, 0.8)"],[.5,"rgba(255, 255, 255, 0.8)"],[.5,"rgba(250, 250, 250, 0.9)"],[1,"rgba(245, 245, 245, 0.9)"]],borderColor:"#eee",closeButtonCrossColor:"rgba(0, 0, 0, 0.2)",borderRadius:15,closeButtonRadius:10,closeButtonOffset:[8,8]},dark:{"extends":"standard",className:"dark",borderRadius:13,borderColor:"#444",closeButtonCrossColor:"rgba(240, 240, 240, 1)",shadowColor:"rgba(0, 0, 0, 0.3)",shadowOffset:[2,2],background:[[0,"rgba(30, 30, 30, 0.7)"],[.5,"rgba(30, 30, 30, 0.8)"],[.5,"rgba(10, 10, 10, 0.8)"],[1,"rgba(10, 10, 10, 0.9)"]]},alert:{"extends":"standard",className:"alert",borderRadius:1,borderColor:"#AE0D11",closeButtonCrossColor:"rgba(255, 255, 255, 1)",shadowColor:"rgba(0, 0, 0, 0.3)",shadowOffset:[2,2],background:[[0,"rgba(203, 15, 19, 0.7)"],[.5,"rgba(203, 15, 19, 0.8)"],[.5,"rgba(189, 14, 18, 0.8)"],[1,"rgba(179, 14, 17, 0.9)"]]}},Opentip.defaultStyle="standard",typeof module!="undefined"&&module!==null?module.exports=Opentip:window.Opentip=Opentip;var __slice=[].slice;(function(t){var e;return t.fn.opentip=function(t,e,i){return new Opentip(this,t,e,i)},e=function(){function e(){}return e.prototype.name="jquery",e.prototype.domReady=function(e){return t(e)},e.prototype.create=function(e){return t(e)},e.prototype.wrap=function(e){if(e=t(e),e.length>1)throw Error("Multiple elements provided.");return e},e.prototype.unwrap=function(e){return t(e)[0]
+++},e.prototype.tagName=function(t){return this.unwrap(t).tagName},e.prototype.attr=function(){var e,i,o;return i=arguments[0],e=arguments.length>=2?__slice.call(arguments,1):[],(o=t(i)).attr.apply(o,e)},e.prototype.data=function(){var e,i,o;return i=arguments[0],e=arguments.length>=2?__slice.call(arguments,1):[],(o=t(i)).data.apply(o,e)},e.prototype.find=function(e,i){return t(e).find(i).get(0)},e.prototype.findAll=function(e,i){return t(e).find(i)},e.prototype.update=function(e,i,o){return e=t(e),o?e.text(i):e.html(i)},e.prototype.append=function(e,i){return t(e).append(i)},e.prototype.remove=function(e){return t(e).remove()},e.prototype.addClass=function(e,i){return t(e).addClass(i)},e.prototype.removeClass=function(e,i){return t(e).removeClass(i)},e.prototype.css=function(e,i){return t(e).css(i)},e.prototype.dimensions=function(e){return{width:t(e).outerWidth(),height:t(e).outerHeight()}},e.prototype.scrollOffset=function(){return[window.pageXOffset||document.documentElement.scrollLeft||document.body.scrollLeft,window.pageYOffset||document.documentElement.scrollTop||document.body.scrollTop]},e.prototype.viewportDimensions=function(){return{width:document.documentElement.clientWidth,height:document.documentElement.clientHeight}},e.prototype.mousePosition=function(t){return t==null?null:{x:t.pageX,y:t.pageY}},e.prototype.offset=function(e){var i;return i=t(e).offset(),{left:i.left,top:i.top}},e.prototype.observe=function(e,i,o){return t(e).bind(i,o)},e.prototype.stopObserving=function(e,i,o){return t(e).unbind(i,o)},e.prototype.ajax=function(e){var i,o;if(e.url==null)throw Error("No url provided");return t.ajax({url:e.url,type:(i=(o=e.method)!=null?o.toUpperCase():void 0)!=null?i:"GET"}).done(function(t){return typeof e.onSuccess=="function"?e.onSuccess(t):void 0}).fail(function(t){return typeof e.onError=="function"?e.onError("Server responded with status "+t.status):void 0}).always(function(){return typeof e.onComplete=="function"?e.onComplete():void 0})},e.prototype.clone=function(e){return t.extend({},e)},e.prototype.extend=function(){var e,i;return i=arguments[0],e=arguments.length>=2?__slice.call(arguments,1):[],t.extend.apply(t,[i].concat(__slice.call(e)))},e}(),Opentip.addAdapter(new e)})(jQuery)});
++\ No newline at end of file
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/styles/FLATBOOTS/theme/opentip.css" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/styles/FLATBOOTS/theme/opentip.css"
++new file mode 100644
++index 000000000..5088f37a0
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\vse\\topicimagepreview/styles/FLATBOOTS/theme/opentip.css"
++@@ -0,0 +1,278 @@
+++.opentip-container,
+++.opentip-container * {
+++  -webkit-box-sizing: border-box;
+++  -moz-box-sizing: border-box;
+++  box-sizing: border-box;
+++}
+++.opentip-container {
+++  position: absolute;
+++  max-width: 300px;
+++  z-index: 100;
+++  -webkit-transition: -webkit-transform 1s ease-in-out;
+++  -moz-transition: -moz-transform 1s ease-in-out;
+++  -o-transition: -o-transform 1s ease-in-out;
+++  -ms-transition: -ms-transform 1s ease-in-out;
+++  transition: transform 1s ease-in-out;
+++  pointer-events: none;
+++  -webkit-transform: translateX(0) translateY(0);
+++  -moz-transform: translateX(0) translateY(0);
+++  -o-transform: translateX(0) translateY(0);
+++  -ms-transform: translateX(0) translateY(0);
+++  transform: translateX(0) translateY(0);
+++}
+++.opentip-container.ot-fixed.ot-hidden.stem-top.stem-center,
+++.opentip-container.ot-fixed.ot-going-to-show.stem-top.stem-center,
+++.opentip-container.ot-fixed.ot-hiding.stem-top.stem-center {
+++  -webkit-transform: translateY(-5px);
+++  -moz-transform: translateY(-5px);
+++  -o-transform: translateY(-5px);
+++  -ms-transform: translateY(-5px);
+++  transform: translateY(-5px);
+++}
+++.opentip-container.ot-fixed.ot-hidden.stem-top.stem-right,
+++.opentip-container.ot-fixed.ot-going-to-show.stem-top.stem-right,
+++.opentip-container.ot-fixed.ot-hiding.stem-top.stem-right {
+++  -webkit-transform: translateY(-5px) translateX(5px);
+++  -moz-transform: translateY(-5px) translateX(5px);
+++  -o-transform: translateY(-5px) translateX(5px);
+++  -ms-transform: translateY(-5px) translateX(5px);
+++  transform: translateY(-5px) translateX(5px);
+++}
+++.opentip-container.ot-fixed.ot-hidden.stem-middle.stem-right,
+++.opentip-container.ot-fixed.ot-going-to-show.stem-middle.stem-right,
+++.opentip-container.ot-fixed.ot-hiding.stem-middle.stem-right {
+++  -webkit-transform: translateX(5px);
+++  -moz-transform: translateX(5px);
+++  -o-transform: translateX(5px);
+++  -ms-transform: translateX(5px);
+++  transform: translateX(5px);
+++}
+++.opentip-container.ot-fixed.ot-hidden.stem-bottom.stem-right,
+++.opentip-container.ot-fixed.ot-going-to-show.stem-bottom.stem-right,
+++.opentip-container.ot-fixed.ot-hiding.stem-bottom.stem-right {
+++  -webkit-transform: translateY(5px) translateX(5px);
+++  -moz-transform: translateY(5px) translateX(5px);
+++  -o-transform: translateY(5px) translateX(5px);
+++  -ms-transform: translateY(5px) translateX(5px);
+++  transform: translateY(5px) translateX(5px);
+++}
+++.opentip-container.ot-fixed.ot-hidden.stem-bottom.stem-center,
+++.opentip-container.ot-fixed.ot-going-to-show.stem-bottom.stem-center,
+++.opentip-container.ot-fixed.ot-hiding.stem-bottom.stem-center {
+++  -webkit-transform: translateY(5px);
+++  -moz-transform: translateY(5px);
+++  -o-transform: translateY(5px);
+++  -ms-transform: translateY(5px);
+++  transform: translateY(5px);
+++}
+++.opentip-container.ot-fixed.ot-hidden.stem-bottom.stem-left,
+++.opentip-container.ot-fixed.ot-going-to-show.stem-bottom.stem-left,
+++.opentip-container.ot-fixed.ot-hiding.stem-bottom.stem-left {
+++  -webkit-transform: translateY(5px) translateX(-5px);
+++  -moz-transform: translateY(5px) translateX(-5px);
+++  -o-transform: translateY(5px) translateX(-5px);
+++  -ms-transform: translateY(5px) translateX(-5px);
+++  transform: translateY(5px) translateX(-5px);
+++}
+++.opentip-container.ot-fixed.ot-hidden.stem-middle.stem-left,
+++.opentip-container.ot-fixed.ot-going-to-show.stem-middle.stem-left,
+++.opentip-container.ot-fixed.ot-hiding.stem-middle.stem-left {
+++  -webkit-transform: translateX(-5px);
+++  -moz-transform: translateX(-5px);
+++  -o-transform: translateX(-5px);
+++  -ms-transform: translateX(-5px);
+++  transform: translateX(-5px);
+++}
+++.opentip-container.ot-fixed.ot-hidden.stem-top.stem-left,
+++.opentip-container.ot-fixed.ot-going-to-show.stem-top.stem-left,
+++.opentip-container.ot-fixed.ot-hiding.stem-top.stem-left {
+++  -webkit-transform: translateY(-5px) translateX(-5px);
+++  -moz-transform: translateY(-5px) translateX(-5px);
+++  -o-transform: translateY(-5px) translateX(-5px);
+++  -ms-transform: translateY(-5px) translateX(-5px);
+++  transform: translateY(-5px) translateX(-5px);
+++}
+++.opentip-container.ot-fixed .opentip {
+++  pointer-events: auto;
+++}
+++.opentip-container.ot-hidden {
+++  display: none;
+++}
+++.opentip-container .opentip {
+++  position: relative;
+++  font-size: 13px;
+++  line-height: 120%;
+++  padding: 9px 14px;
+++  color: #4f4b47;
+++  text-shadow: -1px -1px 0px rgba(255,255,255,0.2);
+++}
+++.opentip-container .opentip .header {
+++  margin: 0;
+++  padding: 0;
+++}
+++.opentip-container .opentip .ot-close {
+++  pointer-events: auto;
+++  display: block;
+++  position: absolute;
+++  top: -12px;
+++  left: 60px;
+++  color: rgba(0,0,0,0.5);
+++  background: rgba(0,0,0,0);
+++  text-decoration: none;
+++}
+++.opentip-container .opentip .ot-close span {
+++  display: none;
+++}
+++.opentip-container .opentip .ot-loading-indicator {
+++  display: none;
+++}
+++.opentip-container.ot-loading .ot-loading-indicator {
+++  width: 30px;
+++  height: 30px;
+++  font-size: 30px;
+++  line-height: 30px;
+++  font-weight: bold;
+++  display: block;
+++}
+++.opentip-container.ot-loading .ot-loading-indicator span {
+++  display: block;
+++  -webkit-animation: otloading 2s linear infinite;
+++  -moz-animation: otloading 2s linear infinite;
+++  -o-animation: otloading 2s linear infinite;
+++  -ms-animation: otloading 2s linear infinite;
+++  animation: otloading 2s linear infinite;
+++  text-align: center;
+++}
+++.opentip-container.style-dark .opentip,
+++.opentip-container.style-alert .opentip {
+++  color: #f8f8f8;
+++  text-shadow: 1px 1px 0px rgba(0,0,0,0.2);
+++}
+++.opentip-container.style-glass .opentip {
+++  padding: 15px 25px;
+++  color: #317cc5;
+++  text-shadow: 1px 1px 8px rgba(0,94,153,0.3);
+++}
+++.opentip-container.ot-hide-effect-fade {
+++  -webkit-transition: -webkit-transform 0.5s ease-in-out, opacity 1s ease-in-out;
+++  -moz-transition: -moz-transform 0.5s ease-in-out, opacity 1s ease-in-out;
+++  -o-transition: -o-transform 0.5s ease-in-out, opacity 1s ease-in-out;
+++  -ms-transition: -ms-transform 0.5s ease-in-out, opacity 1s ease-in-out;
+++  transition: transform 0.5s ease-in-out, opacity 1s ease-in-out;
+++  opacity: 1;
+++  -ms-filter: none;
+++  filter: none;
+++}
+++.opentip-container.ot-hide-effect-fade.ot-hiding {
+++  opacity: 0;
+++  filter: alpha(opacity=0);
+++  -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";
+++}
+++.opentip-container.ot-show-effect-appear.ot-going-to-show,
+++.opentip-container.ot-show-effect-appear.ot-showing {
+++  -webkit-transition: -webkit-transform 0.5s ease-in-out, opacity 1s ease-in-out;
+++  -moz-transition: -moz-transform 0.5s ease-in-out, opacity 1s ease-in-out;
+++  -o-transition: -o-transform 0.5s ease-in-out, opacity 1s ease-in-out;
+++  -ms-transition: -ms-transform 0.5s ease-in-out, opacity 1s ease-in-out;
+++  transition: transform 0.5s ease-in-out, opacity 1s ease-in-out;
+++}
+++.opentip-container.ot-show-effect-appear.ot-going-to-show {
+++  opacity: 0;
+++  filter: alpha(opacity=0);
+++  -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";
+++}
+++.opentip-container.ot-show-effect-appear.ot-showing {
+++  opacity: 1;
+++  -ms-filter: none;
+++  filter: none;
+++}
+++.opentip-container.ot-show-effect-appear.ot-visible {
+++  opacity: 1;
+++  -ms-filter: none;
+++  filter: none;
+++}
+++@-moz-keyframes otloading {
+++  0% {
+++    -webkit-transform: rotate(0deg);
+++    -moz-transform: rotate(0deg);
+++    -o-transform: rotate(0deg);
+++    -ms-transform: rotate(0deg);
+++    transform: rotate(0deg);
+++  }
+++
+++  100% {
+++    -webkit-transform: rotate(360deg);
+++    -moz-transform: rotate(360deg);
+++    -o-transform: rotate(360deg);
+++    -ms-transform: rotate(360deg);
+++    transform: rotate(360deg);
+++  }
+++}
+++@-webkit-keyframes otloading {
+++  0% {
+++    -webkit-transform: rotate(0deg);
+++    -moz-transform: rotate(0deg);
+++    -o-transform: rotate(0deg);
+++    -ms-transform: rotate(0deg);
+++    transform: rotate(0deg);
+++  }
+++
+++  100% {
+++    -webkit-transform: rotate(360deg);
+++    -moz-transform: rotate(360deg);
+++    -o-transform: rotate(360deg);
+++    -ms-transform: rotate(360deg);
+++    transform: rotate(360deg);
+++  }
+++}
+++@-o-keyframes otloading {
+++  0% {
+++    -webkit-transform: rotate(0deg);
+++    -moz-transform: rotate(0deg);
+++    -o-transform: rotate(0deg);
+++    -ms-transform: rotate(0deg);
+++    transform: rotate(0deg);
+++  }
+++
+++  100% {
+++    -webkit-transform: rotate(360deg);
+++    -moz-transform: rotate(360deg);
+++    
\ No newline at end of file
diff --git "[ORIGINAL]/vse\\topicimagepreview/event/helper.php" "[FORUM_EXT]/vse\\topicimagepreview/event/helper.php"
--- "[ORIGINAL]/vse\\topicimagepreview/event/helper.php"
+++ "[FORUM_EXT]/vse\\topicimagepreview/event/helper.php"
@@ -100,14 +100,16 @@ class helper
 
 		// Send the image string to the template
 		$block = $event->offsetExists('topic_row') ? 'topic_row' : 'tpl_ary';
-		$event[$block] = array_merge($event[$block], ['TOPIC_IMAGES' => $this->extract_images($event['row']['post_text'])]);
+		$event[$block] = array_merge($event[$block], ['TOPIC_IMAGES' => $this->extract_images($event['row']['post_text']), 'TOPIC_IMAGES_SIZE_MIN' => (int) $this->config['vse_tip_dim_min'], 'TOPIC_IMAGES_SIZE_MAX' => (int) $this->config['vse_tip_dim_max']]);
+		
+		
 
 		$this->preview = true;
 	}
 
 	/**
 	 * Run an SQL query on a group of topics, and find the newest (or oldest)
-	 * post with [IMG] images. Then update the topic's row set array to include
+	 * post with [ALBUM] images. Then update the topic's row set array to include
 	 * the post's text in the cases where images were found.
 	 *
 	 * @param array $topic_list An array of topic ids
@@ -120,22 +122,26 @@ class helper
 	{
 		$sql_array = [];
 		$direction = $this->config->offsetGet('vse_tip_new') ? 'DESC' : 'ASC';
-		$like_expression = $this->db->sql_like_expression('<r>' . $this->db->get_any_char() . '<IMG ' . $this->db->get_any_char());
+		$like_expression = $this->db->sql_like_expression('<r>' . $this->db->get_any_char() . '<ALBUM ' . $this->db->get_any_char());
 		$is_sqlite3 = $this->db->get_sql_layer() === 'sqlite3';
 		$is_mssql = strpos($this->db->get_sql_layer(), 'mssql') === 0;
+		
+
 		foreach ($topic_list as $topic_id)
 		{
-			if (!$this->forum_allowed($rowset[$topic_id]['forum_id']))
+			if (!isset($rowset[$topic_id]) || !$this->forum_allowed($rowset[$topic_id]['forum_id']))
 			{
 				continue;
 			}
 
+			$first_post_id = (int) $rowset[$topic_id]['topic_first_post_id'];
+
 			$stmt = '(SELECT ' . ($is_mssql ? 'TOP 1 ' : '') . 'topic_id, post_text
 				FROM ' . POSTS_TABLE . '
-				WHERE topic_id = ' . (int) $topic_id . '
-					AND post_visibility = ' . ITEM_APPROVED . '
-					AND post_text ' . $like_expression . '
-				ORDER BY post_time ' . $direction . ($is_mssql ? '' : ' LIMIT 1') . ')';
+				WHERE post_text ' . $like_expression . '
+					AND topic_id = ' . (int) $topic_id . '
+					AND post_id = ' . $first_post_id . ')';
+				// ORDER BY post_time ' . $direction . ($is_mssql ? '' : ' LIMIT 1') . ')';
 
 			// SQLite3 and mssql don't like ORDER BY with UNION ALL, so treat $stmt as derived table
 			if ($is_sqlite3 || $is_mssql)
@@ -174,14 +180,14 @@ class helper
 		$dom = new \DOMDocument;
 		$dom->loadXML($post);
 		$xpath = new \DOMXPath($dom);
-		foreach ($xpath->query('//IMG[not(ancestor::IMG)]/@src') as $image)
+		foreach ($xpath->query('//ALBUM[not(ancestor::ALBUM)]/@content') as $image)
 		{
 			$images[] = $image->textContent;
 		}
 
-		return array_slice($images, 0, (int) $this->config['vse_tip_num'], true);
+		// Create a string of images
+		return array_slice($images, 0, (int) $this->config['vse_tip_dim_min'], true);
 	}
-
 	/**
 	 * Is the forum allowed to show topic image previews
 	 *
diff --git "[ORIGINAL]/vse\\topicimagepreview/event/preview.php" "[FORUM_EXT]/vse\\topicimagepreview/event/preview.php"
--- "[ORIGINAL]/vse\\topicimagepreview/event/preview.php"
+++ "[FORUM_EXT]/vse\\topicimagepreview/event/preview.php"
@@ -23,7 +23,7 @@ class preview implements EventSubscriberInterface
 	protected $config;
 
 	/** @var helper */
-	protected $helper;
+	public $helper;
 
 	/** @var template */
 	protected $template;
diff --git "[ORIGINAL]/vse\\topicimagepreview/event/settings.php" "[FORUM_EXT]/vse\\topicimagepreview/event/settings.php"
--- "[ORIGINAL]/vse\\topicimagepreview/event/settings.php"
+++ "[FORUM_EXT]/vse\\topicimagepreview/event/settings.php"
@@ -102,7 +102,8 @@ class settings implements EventSubscriberInterface
 				'legend_vse_tip'	=> 'ACP_TIP_TITLE',
 				'vse_tip_new'		=> ['lang' => 'ACP_TIP_DISPLAY_AGE', 'validate' => 'bool', 'type' => 'custom', 'function' => [$this, 'select_vse_tip_new'], 'explain' => true],
 				'vse_tip_num'		=> ['lang' => 'ACP_TIP_DISPLAY_NUM', 'validate' => 'int:0:99', 'type' => 'number:0:99', 'explain' => true],
-				'vse_tip_dim'		=> ['lang' => 'ACP_TIP_DISPLAY_DIM', 'validate' => 'int:0:999', 'type' => 'number:0:999', 'explain' => true, 'append' => ' ' . $this->language->lang('PIXEL')],
+				'vse_tip_dim_min'	=> ['lang' => 'ACP_TIP_DISPLAY_DIM_MIN', 'validate' => 'int:0:999', 'type' => 'number:0:999', 'explain' => true, 'append' => ' ' . $this->language->lang('PIXEL')],
+				'vse_tip_dim_max'	=> ['lang' => 'ACP_TIP_DISPLAY_DIM_MAX', 'validate' => 'int:0:999', 'type' => 'number:0:999', 'explain' => true, 'append' => ' ' . $this->language->lang('PIXEL')],
 				'vse_tip_srt'		=> ['lang' => 'ACP_TIP_DISPLAY_SRT', 'validate' => 'bool', 'type' => 'radio:yes_no', 'explain' => false],
 			];
 
diff --git "[ORIGINAL]/vse\\topicimagepreview/language/en/tip_acp.php" "[FORUM_EXT]/vse\\topicimagepreview/language/en/tip_acp.php"
--- "[ORIGINAL]/vse\\topicimagepreview/language/en/tip_acp.php"
+++ "[FORUM_EXT]/vse\\topicimagepreview/language/en/tip_acp.php"
@@ -26,7 +26,8 @@ $lang = array_merge($lang, [
 	'ACP_TIP_OLDEST_POST'			=> 'Oldest post',
 	'ACP_TIP_DISPLAY_NUM'			=> 'Number of images to display',
 	'ACP_TIP_DISPLAY_NUM_EXPLAIN'	=> 'Maximum number of images to display in previews. Set to 0 to disable previews.',
-	'ACP_TIP_DISPLAY_DIM'			=> 'Maximum image size per preview',
+	'ACP_TIP_DISPLAY_DIM_MIN'		=> 'Maximum image size for the small image preview',
+	'ACP_TIP_DISPLAY_DIM_MAX'		=> 'Maximum image size for the big popup image preview',
 	'ACP_TIP_DISPLAY_DIM_EXPLAIN'	=> 'Maximum width/height of each image in the preview.',
 	'ACP_TIP_DISPLAY_SRT'			=> 'Display in search results topics',
 	'ACP_TIP_DISPLAY_PST'			=> 'Display in similar topics',
diff --git "[ORIGINAL]/vse\\topicimagepreview/language/en/tip_ucp.php" "[FORUM_EXT]/vse\\topicimagepreview/language/en/tip_ucp.php"
--- "[ORIGINAL]/vse\\topicimagepreview/language/en/tip_ucp.php"
+++ "[FORUM_EXT]/vse\\topicimagepreview/language/en/tip_ucp.php"
@@ -1,4 +1,4 @@
-<?php
+opentip<?php
 			/**
 			 *
 			 * Topic Image Preview. An extension for the phpBB Forum Software package.
@@ -11,13 +11,11 @@
 			/**
 			 * DO NOT CHANGE
 			 */
-if (!defined('IN_PHPBB'))
-{
+			if (!defined('IN_PHPBB')) {
 				exit;
 			}
 
-if (empty($lang) || !is_array($lang))
-{
+			if (empty($lang) || !is_array($lang)) {
 				$lang = [];
 			}
 
diff --git "[FORUM_EXT]/vse\\topicimagepreview/language/pt/permissions_tip.php" "[FORUM_EXT]/vse\\topicimagepreview/language/pt/permissions_tip.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/vse\\topicimagepreview/language/pt/permissions_tip.php"
@@ -0,0 +1,26 @@
+<?php
+/**
+ *
+ * Topic Image Preview. An extension for the phpBB Forum Software package.
+ *
+ * @copyright (c) 2020, Matt Friedman
+ * @license GNU General Public License, version 2 (GPL-2.0)
+ *
+ */
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
+	$lang = array();
+}
+
+$lang = array_merge($lang, array(
+	'ACL_F_VSE_TIP'	=> 'Can see topic image previews',
+));
diff --git "[FORUM_EXT]/vse\\topicimagepreview/language/pt/tip_acp.php" "[FORUM_EXT]/vse\\topicimagepreview/language/pt/tip_acp.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/vse\\topicimagepreview/language/pt/tip_acp.php"
@@ -0,0 +1,34 @@
+<?php
+/**
+ *
+ * Topic Image Preview. An extension for the phpBB Forum Software package.
+ *
+ * @copyright (c) 2017, Matt Friedman
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
+$lang = array_merge($lang, [
+	'ACP_TIP_TITLE'					=> 'Topic Image Preview',
+	'ACP_TIP_DISPLAY_AGE'			=> 'Display images from',
+	'ACP_TIP_DISPLAY_AGE_EXPLAIN'	=> 'Select Newest post to display the most recent images posted. Otherwise, select Oldest post to display the oldest images posted.',
+	'ACP_TIP_NEWEST_POST'			=> 'Newest post',
+	'ACP_TIP_OLDEST_POST'			=> 'Oldest post',
+	'ACP_TIP_DISPLAY_NUM'			=> 'Number of images to display',
+	'ACP_TIP_DISPLAY_NUM_EXPLAIN'	=> 'Maximum number of images to display in previews. Set to 0 to disable previews.',
+	'ACP_TIP_DISPLAY_DIM_MIN'		=> 'Maximum image size for the small image preview',
+	'ACP_TIP_DISPLAY_DIM_MAX'		=> 'Maximum image size for the big popup image preview',
+	'ACP_TIP_DISPLAY_DIM_EXPLAIN'	=> 'Maximum width/height of each image in the preview.',
+	'ACP_TIP_DISPLAY_SRT'			=> 'Display in search results topics',
+	'ACP_TIP_DISPLAY_PST'			=> 'Display in similar topics',
+]);
diff --git "[FORUM_EXT]/vse\\topicimagepreview/language/pt/tip_install.php" "[FORUM_EXT]/vse\\topicimagepreview/language/pt/tip_install.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/vse\\topicimagepreview/language/pt/tip_install.php"
@@ -0,0 +1,34 @@
+<?php
+/**
+ *
+ * Topic Image Preview. An extension for the phpBB Forum Software package.
+ *
+ * @copyright (c) 2017, Matt Friedman
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
+$lang = array_merge($lang, [
+	'TIP_INSTALL_ERROR'	=> 'phpBB %s or newer is required.',
+]);
+
+// TRANSLATORS CAN IGNORE THIS.
+// Overwrite core error message keys with a more specific message.
+$lang = array_merge($lang, [
+	'EXTENSION_NOT_ENABLEABLE'		=> isset($lang['EXTENSION_NOT_ENABLEABLE']) ?
+		$lang['EXTENSION_NOT_ENABLEABLE'] . '<br />' . sprintf($lang['TIP_INSTALL_ERROR'], \vse\topicimagepreview\ext::PHPBB_MIN_VERSION) :
+		null,
+	'CLI_EXTENSION_ENABLE_FAILURE'	=> isset($lang['CLI_EXTENSION_ENABLE_FAILURE']) ?
+		$lang['CLI_EXTENSION_ENABLE_FAILURE'] . '. ' . sprintf($lang['TIP_INSTALL_ERROR'], \vse\topicimagepreview\ext::PHPBB_MIN_VERSION) :
+		null,
+]);
diff --git "[FORUM_EXT]/vse\\topicimagepreview/language/pt/tip_ucp.php" "[FORUM_EXT]/vse\\topicimagepreview/language/pt/tip_ucp.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/vse\\topicimagepreview/language/pt/tip_ucp.php"
@@ -0,0 +1,38 @@
+<?php
+/**
+ *
+ * Topic Image Preview. An extension for the phpBB Forum Software package.
+ *
+ * @copyright (c) 2019, Matt Friedman
+ * @license GNU General Public License, version 2 (GPL-2.0)
+ *
+ */
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
+
+$lang = array_merge($lang, [
+	'DISPLAY_TOPIC_IMAGE_PREVIEWS'	=> 'Mostrar imagens de tópicos',
+]);
diff --git "[FORUM_EXT]/vse\\topicimagepreview/language/pt_preao/permissions_tip.php" "[FORUM_EXT]/vse\\topicimagepreview/language/pt_preao/permissions_tip.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/vse\\topicimagepreview/language/pt_preao/permissions_tip.php"
@@ -0,0 +1,26 @@
+<?php
+/**
+ *
+ * Topic Image Preview. An extension for the phpBB Forum Software package.
+ *
+ * @copyright (c) 2020, Matt Friedman
+ * @license GNU General Public License, version 2 (GPL-2.0)
+ *
+ */
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
+	$lang = array();
+}
+
+$lang = array_merge($lang, array(
+	'ACL_F_VSE_TIP'	=> 'Can see topic image previews',
+));
diff --git "[FORUM_EXT]/vse\\topicimagepreview/language/pt_preao/tip_acp.php" "[FORUM_EXT]/vse\\topicimagepreview/language/pt_preao/tip_acp.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/vse\\topicimagepreview/language/pt_preao/tip_acp.php"
@@ -0,0 +1,34 @@
+<?php
+/**
+ *
+ * Topic Image Preview. An extension for the phpBB Forum Software package.
+ *
+ * @copyright (c) 2017, Matt Friedman
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
+$lang = array_merge($lang, [
+	'ACP_TIP_TITLE'					=> 'Topic Image Preview',
+	'ACP_TIP_DISPLAY_AGE'			=> 'Display images from',
+	'ACP_TIP_DISPLAY_AGE_EXPLAIN'	=> 'Select Newest post to display the most recent images posted. Otherwise, select Oldest post to display the oldest images posted.',
+	'ACP_TIP_NEWEST_POST'			=> 'Newest post',
+	'ACP_TIP_OLDEST_POST'			=> 'Oldest post',
+	'ACP_TIP_DISPLAY_NUM'			=> 'Number of images to display',
+	'ACP_TIP_DISPLAY_NUM_EXPLAIN'	=> 'Maximum number of images to display in previews. Set to 0 to disable previews.',
+	'ACP_TIP_DISPLAY_DIM_MIN'		=> 'Maximum image size for the small image preview',
+	'ACP_TIP_DISPLAY_DIM_MAX'		=> 'Maximum image size for the big popup image preview',
+	'ACP_TIP_DISPLAY_DIM_EXPLAIN'	=> 'Maximum width/height of each image in the preview.',
+	'ACP_TIP_DISPLAY_SRT'			=> 'Display in search results topics',
+	'ACP_TIP_DISPLAY_PST'			=> 'Display in similar topics',
+]);
diff --git "[FORUM_EXT]/vse\\topicimagepreview/language/pt_preao/tip_install.php" "[FORUM_EXT]/vse\\topicimagepreview/language/pt_preao/tip_install.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/vse\\topicimagepreview/language/pt_preao/tip_install.php"
@@ -0,0 +1,34 @@
+<?php
+/**
+ *
+ * Topic Image Preview. An extension for the phpBB Forum Software package.
+ *
+ * @copyright (c) 2017, Matt Friedman
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
+$lang = array_merge($lang, [
+	'TIP_INSTALL_ERROR'	=> 'phpBB %s or newer is required.',
+]);
+
+// TRANSLATORS CAN IGNORE THIS.
+// Overwrite core error message keys with a more specific message.
+$lang = array_merge($lang, [
+	'EXTENSION_NOT_ENABLEABLE'		=> isset($lang['EXTENSION_NOT_ENABLEABLE']) ?
+		$lang['EXTENSION_NOT_ENABLEABLE'] . '<br />' . sprintf($lang['TIP_INSTALL_ERROR'], \vse\topicimagepreview\ext::PHPBB_MIN_VERSION) :
+		null,
+	'CLI_EXTENSION_ENABLE_FAILURE'	=> isset($lang['CLI_EXTENSION_ENABLE_FAILURE']) ?
+		$lang['CLI_EXTENSION_ENABLE_FAILURE'] . '. ' . sprintf($lang['TIP_INSTALL_ERROR'], \vse\topicimagepreview\ext::PHPBB_MIN_VERSION) :
+		null,
+]);
diff --git "[FORUM_EXT]/vse\\topicimagepreview/language/pt_preao/tip_ucp.php" "[FORUM_EXT]/vse\\topicimagepreview/language/pt_preao/tip_ucp.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/vse\\topicimagepreview/language/pt_preao/tip_ucp.php"
@@ -0,0 +1,38 @@
+<?php
+/**
+ *
+ * Topic Image Preview. An extension for the phpBB Forum Software package.
+ *
+ * @copyright (c) 2019, Matt Friedman
+ * @license GNU General Public License, version 2 (GPL-2.0)
+ *
+ */
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
+
+$lang = array_merge($lang, [
+	'DISPLAY_TOPIC_IMAGE_PREVIEWS'	=> 'Mostrar imagens de tópicos',
+]);
diff --git "[ORIGINAL]/vse\\topicimagepreview/migrations/install_tip.php" "[FORUM_EXT]/vse\\topicimagepreview/migrations/install_tip.php"
--- "[ORIGINAL]/vse\\topicimagepreview/migrations/install_tip.php"
+++ "[FORUM_EXT]/vse\\topicimagepreview/migrations/install_tip.php"
@@ -27,7 +27,8 @@ class install_tip extends \phpbb\db\migration\migration
 		return [
 			['config.add', ['vse_tip_new', 1]],
 			['config.add', ['vse_tip_num', 3]],
-			['config.add', ['vse_tip_dim', 200]],
+			['config.add', ['vse_tip_dim_min', 200]],
+			['config.add', ['vse_tip_dim_max', 500]],
 		];
 	}
 }
diff --git "[FORUM_EXT]/vse\\topicimagepreview/styles/BBOOTS/template/event/overall_footer_after.html" "[FORUM_EXT]/vse\\topicimagepreview/styles/BBOOTS/template/event/overall_footer_after.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/vse\\topicimagepreview/styles/BBOOTS/template/event/overall_footer_after.html"
@@ -0,0 +1,9 @@
+{% INCLUDEJS '@vse_topicimagepreview/js/opentip-jquery.min.js' %}
+
+<script>
+head.ready(function () {
+	$(function() {
+		$("[data-ot]").closest("dt").removeAttr("title");
+	});
+});
+</script>
diff --git "[FORUM_EXT]/vse\\topicimagepreview/styles/BBOOTS/template/event/overall_header_stylesheets_after.html" "[FORUM_EXT]/vse\\topicimagepreview/styles/BBOOTS/template/event/overall_header_stylesheets_after.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/vse\\topicimagepreview/styles/BBOOTS/template/event/overall_header_stylesheets_after.html"
@@ -0,0 +1,5 @@
+{% INCLUDECSS '@vse_topicimagepreview/opentip.css' %}
+
+<style>
+	.opentip-container { max-width: 1000px; white-space: nowrap; }
+</style>
diff --git "[FORUM_EXT]/vse\\topicimagepreview/styles/BBOOTS/template/event/topiclist_row_prepend.html" "[FORUM_EXT]/vse\\topicimagepreview/styles/BBOOTS/template/event/topiclist_row_prepend.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/vse\\topicimagepreview/styles/BBOOTS/template/event/topiclist_row_prepend.html"
@@ -0,0 +1,18 @@
+{# display in view forum #}
+{% if topicrow.TOPIC_IMAGES %}
+	{% set preview = topicrow %}
+{% endif %}
+
+{# display in search results #}
+{% if searchresults.TOPIC_IMAGES %}
+	{% set preview = searchresults %}
+{% endif %}
+
+{# display in Similar Topics extension #}
+{% if similar.TOPIC_IMAGES %}
+	{% set preview = similar %}
+{% endif %}
+
+<span{% if preview.TOPIC_IMAGES_BIG %} data-ot="{{ preview.TOPIC_IMAGES_BIG }}" data-ot-group="topics" data-ot-background="transparent" data-ot-border-width="0" data-ot-border-radius="0"{% endif %}>
+{% if preview.TOPIC_IMAGES %}<div style="float:left;padding-right:10px;">{{ preview.TOPIC_IMAGES }}</div>{% endif %}
+</span>
\ No newline at end of file
diff --git "[FORUM_EXT]/vse\\topicimagepreview/styles/BBOOTS/template/event/ucp_prefs_view_radio_buttons_append.html" "[FORUM_EXT]/vse\\topicimagepreview/styles/BBOOTS/template/event/ucp_prefs_view_radio_buttons_append.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/vse\\topicimagepreview/styles/BBOOTS/template/event/ucp_prefs_view_radio_buttons_append.html"
@@ -0,0 +1,9 @@
+{% if S_VSE_TIP_NUM %}
+	<dl>
+		<dt><label for="user_vse_tip1">{{ lang('DISPLAY_TOPIC_IMAGE_PREVIEWS') ~ lang('COLON') }}</label></dt>
+		<dd>
+			<label for="user_vse_tip1"><input type="radio" name="user_vse_tip" id="user_vse_tip1" value="1"{% if S_VSE_TIP_USER %} checked="checked"{% endif %} /> {{ lang('YES') }}</label>
+			<label for="user_vse_tip0"><input type="radio" name="user_vse_tip" id="user_vse_tip0" value="0"{% if not S_VSE_TIP_USER %} checked="checked"{% endif %} /> {{ lang('NO') }}</label>
+		</dd>
+	</dl>
+{% endif %}
diff --git "[FORUM_EXT]/vse\\topicimagepreview/styles/BBOOTS/template/js/opentip-jquery.js" "[FORUM_EXT]/vse\\topicimagepreview/styles/BBOOTS/template/js/opentip-jquery.js"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/vse\\topicimagepreview/styles/BBOOTS/template/js/opentip-jquery.js"
@@ -0,0 +1,1794 @@
+// Generated by CoffeeScript 1.4.0
+/*
+#
+# Opentip v2.4.6
+#
+# More info at [www.opentip.org](http://www.opentip.org)
+# 
+# Copyright (c) 2012, Matias Meno  
+# Graphics by Tjandra Mayerhold
+# 
+# Permission is hereby granted, free of charge, to any person obtaining a copy
+# of this software and associated documentation files (the "Software"), to deal
+# in the Software without restriction, including without limitation the rights
+# to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
+# copies of the Software, and to permit persons to whom the Software is
+# furnished to do so, subject to the following conditions:
+# 
+# The above copyright notice and this permission notice shall be included in
+# all copies or substantial portions of the Software.
+# 
+# THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
+# IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
+# FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
+# AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
+# LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
+# OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
+# THE SOFTWARE.
+#
+*/
+head.ready(function () {
+var Opentip, firstAdapter, i, mouseMoved, mousePosition, mousePositionObservers, position, vendors, _i, _len, _ref,
+  __slice = [].slice,
+  __indexOf = [].indexOf || function(item) { for (var i = 0, l = this.length; i < l; i++) { if (i in this && this[i] === item) return i; } return -1; },
+  __hasProp = {}.hasOwnProperty;
+
+Opentip = (function() {
+
+  Opentip.prototype.STICKS_OUT_TOP = 1;
+
+  Opentip.prototype.STICKS_OUT_BOTTOM = 2;
+
+  Opentip.prototype.STICKS_OUT_LEFT = 1;
+
+  Opentip.prototype.STICKS_OUT_RIGHT = 2;
+
+  Opentip.prototype["class"] = {
+    container: "opentip-container",
+    opentip: "opentip",
+    header: "ot-header",
+    content: "ot-content",
+    loadingIndicator: "ot-loading-indicator",
+    close: "ot-close",
+    goingToHide: "ot-going-to-hide",
+    hidden: "ot-hidden",
+    hiding: "ot-hiding",
+    goingToShow: "ot-going-to-show",
+    showing: "ot-showing",
+    visible: "ot-visible",
+    loading: "ot-loading",
+    ajaxError: "ot-ajax-error",
+    fixed: "ot-fixed",
+    showEffectPrefix: "ot-show-effect-",
+    hideEffectPrefix: "ot-hide-effect-",
+    stylePrefix: "style-"
+  };
+
+  function Opentip(element, content, title, options) {
+    var elementsOpentips, hideTrigger, methodToBind, optionSources, prop, styleName, _i, _j, _len, _len1, _ref, _ref1, _ref2, _tmpStyle,
+      _this = this;
+    this.id = ++Opentip.lastId;
+    this.debug("Creating Opentip.");
+    Opentip.tips.push(this);
+    this.adapter = Opentip.adapter;
+    elementsOpentips = this.adapter.data(element, "opentips") || [];
+    elementsOpentips.push(this);
+    this.adapter.data(element, "opentips", elementsOpentips);
+    this.triggerElement = this.adapter.wrap(element);
+    if (this.triggerElement.length > 1) {
+      throw new Error("You can't call Opentip on multiple elements.");
+    }
+    if (this.triggerElement.length < 1) {
+      throw new Error("Invalid element.");
+    }
+    this.loaded = false;
+    this.loading = false;
+    this.visible = false;
+    this.waitingToShow = false;
+    this.waitingToHide = false;
+    this.currentPosition = {
+      left: 0,
+      top: 0
+    };
+    this.dimensions = {
+      width: 100,
+      height: 50
+    };
+    this.content = "";
+    this.redraw = true;
+    this.currentObservers = {
+      showing: false,
+      visible: false,
+      hiding: false,
+      hidden: false
+    };
+    options = this.adapter.clone(options);
+    if (typeof content === "object") {
+      options = content;
+      content = title = void 0;
+    } else if (typeof title === "object") {
+      options = title;
+      title = void 0;
+    }
+    if (title != null) {
+      options.title = title;
+    }
+    if (content != null) {
+      this.setContent(content);
+    }
+    if (options["extends"] == null) {
+      if (options.style != null) {
+        options["extends"] = options.style;
+      } else {
+        options["extends"] = Opentip.defaultStyle;
+      }
+    }
+    optionSources = [options];
+    _tmpStyle = options;
+    while (_tmpStyle["extends"]) {
+      styleName = _tmpStyle["extends"];
+      _tmpStyle = Opentip.styles[styleName];
+      if (_tmpStyle == null) {
+        throw new Error("Invalid style: " + styleName);
+      }
+      optionSources.unshift(_tmpStyle);
+      if (!((_tmpStyle["extends"] != null) || styleName === "standard")) {
+        _tmpStyle["extends"] = "standard";
+      }
+    }
+    options = (_ref = this.adapter).extend.apply(_ref, [{}].concat(__slice.call(optionSources)));
+    options.hideTriggers = (function() {
+      var _i, _len, _ref1, _results;
+      _ref1 = options.hideTriggers;
+      _results = [];
+      for (_i = 0, _len = _ref1.length; _i < _len; _i++) {
+        hideTrigger = _ref1[_i];
+        _results.push(hideTrigger);
+      }
+      return _results;
+    })();
+    if (options.hideTrigger && options.hideTriggers.length === 0) {
+      options.hideTriggers.push(options.hideTrigger);
+    }
+    _ref1 = ["tipJoint", "targetJoint", "stem"];
+    for (_i = 0, _len = _ref1.length; _i < _len; _i++) {
+      prop = _ref1[_i];
+      if (options[prop] && typeof options[prop] === "string") {
+        options[prop] = new Opentip.Joint(options[prop]);
+      }
+    }
+    if (options.ajax && (options.ajax === true || !options.ajax)) {
+      if (this.adapter.tagName(this.triggerElement) === "A") {
+        options.ajax = this.adapter.attr(this.triggerElement, "href");
+      } else {
+        options.ajax = false;
+      }
+    }
+    if (options.showOn === "click" && this.adapter.tagName(this.triggerElement) === "A") {
+      this.adapter.observe(this.triggerElement, "click", function(e) {
+        e.preventDefault();
+        e.stopPropagation();
+        return e.stopped = true;
+      });
+    }
+    if (options.target) {
+      options.fixed = true;
+    }
+    if (options.stem === true) {
+      options.stem = new Opentip.Joint(options.tipJoint);
+    }
+    if (options.target === true) {
+      options.target = this.triggerElement;
+    } else if (options.target) {
+      options.target = this.adapter.wrap(options.target);
+    }
+    this.currentStem = options.stem;
+    if (options.delay == null) {
+      options.delay = options.showOn === "mouseover" ? 0.2 : 0;
+    }
+    if (options.targetJoint == null) {
+      options.targetJoint = new Opentip.Joint(options.tipJoint).flip();
+    }
+    this.showTriggers = [];
+    this.showTriggersWhenVisible = [];
+    this.hideTriggers = [];
+    if (options.showOn && options.showOn !== "creation") {
+      this.showTriggers.push({
+        element: this.triggerElement,
+        event: options.showOn
+      });
+    }
+    if (options.ajaxCache != null) {
+      options.cache = options.ajaxCache;
+      delete options.ajaxCache;
+    }
+    this.options = options;
+    this.bound = {};
+    _ref2 = ["prepareToShow", "prepareToHide", "show", "hide", "reposition"];
+    for (_j = 0, _len1 = _ref2.length; _j < _len1; _j++) {
+      methodToBind = _ref2[_j];
+      this.bound[methodToBind] = (function(methodToBind) {
+        return function() {
+          return _this[methodToBind].apply(_this, arguments);
+        };
+      })(methodToBind);
+    }
+    this.adapter.domReady(function() {
+      _this.activate();
+      if (_this.options.showOn === "creation") {
+        return _this.prepareToShow();
+      }
+    });
+  }
+
+  Opentip.prototype._setup = function() {
+    var hideOn, hideTrigger, hideTriggerElement, i, _i, _j, _len, _len1, _ref, _ref1, _results;
+    this.debug("Setting up the tooltip.");
+    this._buildContainer();
+    this.hideTriggers = [];
+    _ref = this.options.hideTriggers;
+    for (i = _i = 0, _len = _ref.length; _i < _len; i = ++_i) {
+      hideTrigger = _ref[i];
+      hideTriggerElement = null;
+      hideOn = this.options.hideOn instanceof Array ? this.options.hideOn[i] : this.options.hideOn;
+      if (typeof hideTrigger === "string") {
+        switch (hideTrigger) {
+          case "trigger":
+            hideOn = hideOn || "mouseout";
+            hideTriggerElement = this.triggerElement;
+            break;
+          case "tip":
+            hideOn = hideOn || "mouseover";
+            hideTriggerElement = this.container;
+            break;
+          case "target":
+            hideOn = hideOn || "mouseover";
+            hideTriggerElement = this.options.target;
+            break;
+          case "closeButton":
+            break;
+          default:
+            throw new Error("Unknown hide trigger: " + hideTrigger + ".");
+        }
+      } else {
+        hideOn = hideOn || "mouseover";
+        hideTriggerElement = this.adapter.wrap(hideTrigger);
+      }
+      if (hideTriggerElement) {
+        this.hideTriggers.push({
+          element: hideTriggerElement,
+          event: hideOn,
+          original: hideTrigger
+        });
+      }
+    }
+    _ref1 = this.hideTriggers;
+    _results = [];
+    for (_j = 0, _len1 = _ref1.length; _j < _len1; _j++) {
+      hideTrigger = _ref1[_j];
+      _results.push(this.showTriggersWhenVisible.push({
+        element: hideTrigger.element,
+        event: "mouseover"
+      }));
+    }
+    return _results;
+  };
+
+  Opentip.prototype._buildContainer = function() {
+    this.container = this.adapter.create("<div id=\"opentip-" + this.id + "\" class=\"" + this["class"].container + " " + this["class"].hidden + " " + this["class"].stylePrefix + this.options.className + "\"></div>");
+    this.adapter.css(this.container, {
+      position: "absolute"
+    });
+    if (this.options.ajax) {
+      this.adapter.addClass(this.container, this["class"].loading);
+    }
+    if (this.options.fixed) {
+      this.adapter.addClass(this.container, this["class"].fixed);
+    }
+    if (this.options.showEffect) {
+      this.adapter.addClass(this.container, "" + this["class"].showEffectPrefix + this.options.showEffect);
+    }
+    if (this.options.hideEffect) {
+      return this.adapter.addClass(this.container, "" + this["class"].hideEffectPrefix + this.options.hideEffect);
+    }
+  };
+
+  Opentip.prototype._buildElements = function() {
+    var headerElement, titleElement;
+    this.tooltipElement = this.adapter.create("<div class=\"" + this["class"].opentip + "\"><div class=\"" + this["class"].header + "\"></div><div class=\"" + this["class"].content + "\"></div></div>");
+    this.backgroundCanvas = this.adapter.wrap(document.createElement("canvas"));
+    this.adapter.css(this.backgroundCanvas, {
+      position: "absolute"
+    });
+    if (typeof G_vmlCanvasManager !== "undefined" && G_vmlCanvasManager !== null) {
+      G_vmlCanvasManager.initElement(this.adapter.unwrap(this.backgroundCanvas));
+    }
+    headerElement = this.adapter.find(this.tooltipElement, "." + this["class"].header);
+    if (this.options.title) {
+      titleElement = this.adapter.create("<h1></h1>");
+      this.adapter.update(titleElement, this.options.title, this.options.escapeTitle);
+      this.adapter.append(headerElement, titleElement);
+    }
+    if (this.options.ajax && !this.loaded) {
+      this.adapter.append(this.tooltipElement, this.adapter.create("<div class=\"" + this["class"].loadingIndicator + "\"><span>↻</span></div>"));
+    }
+    if (__indexOf.call(this.options.hideTriggers, "closeButton") >= 0) {
+      this.closeButtonElement = this.adapter.create("<a href=\"javascript:undefined;\" class=\"" + this["class"].close + "\"><span>Close</span></a>");
+      this.adapter.append(headerElement, this.closeButtonElement);
+    }
+    this.adapter.append(this.container, this.backgroundCanvas);
+    this.adapter.append(this.container, this.tooltipElement);
+    this.adapter.append(document.body, this.container);
+    this._newContent = true;
+    return this.redraw = true;
+  };
+
+  Opentip.prototype.setContent = function(content) {
+    this.content = content;
+    this._newContent = true;
+    if (typeof this.content === "function") {
+      this._contentFunction = this.content;
+      this.content = "";
+    } else {
+      this._contentFunction = null;
+    }
+    if (this.visible) {
+      return this._updateElementContent();
+    }
+  };
+
+  Opentip.prototype._updateElementContent = function() {
+    var contentDiv;
+    if (this._newContent || (!this.options.cache && this._contentFunction)) {
+      contentDiv = this.adapter.find(this.container, "." + this["class"].content);
+      if (contentDiv != null) {
+        if (this._contentFunction) {
+          this.debug("Executing content function.");
+          this.content = this._contentFunction(this);
+        }
+        this.adapter.update(contentDiv, this.content, this.options.escapeContent);
+      }
+      this._newContent = false;
+    }
+    this._storeAndLockDimensions();
+    return this.reposition();
+  };
+
+  Opentip.prototype._storeAndLockDimensions = function() {
+    var prevDimension;
+    if (!this.container) {
+      return;
+    }
+    prevDimension = this.dimensions;
+    this.adapter.css(this.container, {
+      width: "auto",
+      left: "0px",
+      top: "0px"
+    });
+    this.dimensions = this.adapter.dimensions(this.container);
+    this.dimensions.width += 1;
+    this.adapter.css(this.container, {
+      width: "" + this.dimensions.width + "px",
+      top: "" + this.currentPosition.top + "px",
+      left: "" + this.currentPosition.left + "px"
+    });
+    if (!this._dimensionsEqual(this.dimensions, prevDimension)) {
+      this.redraw = true;
+      return this._draw();
+    }
+  };
+
+  Opentip.prototype.activate = function() {
+    return this._setupObservers("hidden", "hiding");
+  };
+
+  Opentip.prototype.deactivate = function() {
+    this.debug("Deactivating tooltip.");
+    this.hide();
+    return this._setupObservers("-showing", "-visible", "-hidden", "-hiding");
+  };
+
+  Opentip.prototype._setupObservers = function() {
+    var observeOrStop, removeObserver, state, states, trigger, _i, _j, _k, _l, _len, _len1, _len2, _len3, _ref, _ref1, _ref2,
+      _this = this;
+    states = 1 <= arguments.length ? __slice.call(arguments, 0) : [];
+    for (_i = 0, _len = states.length; _i < _len; _i++) {
+      state = states[_i];
+      removeObserver = false;
+      if (state.charAt(0) === "-") {
+        removeObserver = true;
+        state = state.substr(1);
+      }
+      if (this.currentObservers[state] === !removeObserver) {
+        continue;
+      }
+      this.currentObservers[state] = !removeObserver;
+      observeOrStop = function() {
+        var args, _ref, _ref1;
+        args = 1 <= arguments.length ? __slice.call(arguments, 0) : [];
+        if (removeObserver) {
+          return (_ref = _this.adapter).stopObserving.apply(_ref, args);
+        } else {
+          return (_ref1 = _this.adapter).observe.apply(_ref1, args);
+        }
+      };
+      switch (state) {
+        case "showing":
+          _ref = this.hideTriggers;
+          for (_j = 0, _len1 = _ref.length; _j < _len1; _j++) {
+            trigger = _ref[_j];
+            observeOrStop(trigger.element, trigger.event, this.bound.prepareToHide);
+          }
+          observeOrStop((document.onresize != null ? document : window), "resize", this.bound.reposition);
+          observeOrStop(window, "scroll", this.bound.reposition);
+          break;
+        case "visible":
+          _ref1 = this.showTriggersWhenVisible;
+          for (_k = 0, _len2 = _ref1.length; _k < _len2; _k++) {
+            trigger = _ref1[_k];
+            observeOrStop(trigger.element, trigger.event, this.bound.prepareToShow);
+          }
+          break;
+        case "hiding":
+          _ref2 = this.showTriggers;
+          for (_l = 0, _len3 = _ref2.length; _l < _len3; _l++) {
+            trigger = _ref2[_l];
+            observeOrStop(trigger.element, trigger.event, this.bound.prepareToShow);
+          }
+          break;
+        case "hidden":
+          break;
+        default:
+          throw new Error("Unknown state: " + state);
+      }
+    }
+    return null;
+  };
+
+  Opentip.prototype.prepareToShow = function() {
+    this._abortHiding();
+    this._abortShowing();
+    if (this.visible) {
+      return;
+    }
+    this.debug("Showing in " + this.options.delay + "s.");
+    if (this.container == null) {
+      this._setup();
+    }
+    if (this.options.group) {
+      Opentip._abortShowingGroup(this.options.group, this);
+    }
+    this.preparingToShow = true;
+    this._setupObservers("-hidden", "-hiding", "showing");
+    this._followMousePosition();
+    if (this.options.fixed && !this.options.target) {
+      this.initialMousePosition = mousePosition;
+    }
+    this.reposition();
+    return this._showTimeoutId = this.setTimeout(this.bound.show, this.options.delay || 0);
+  };
+
+  Opentip.prototype.show = function() {
+    var _this = this;
+    this._abortHiding();
+    if (this.visible) {
+      return;
+    }
+    this._clearTimeouts();
+    if (!this._triggerElementExists()) {
+      return this.deactivate();
+    }
+    this.debug("Showing now.");
+    if (this.container == null) {
+      this._setup();
+    }
+    if (this.options.group) {
+      Opentip._hideGroup(this.options.group, this);
+    }
+    this.visible = true;
+    this.preparingToShow = false;
+    if (this.tooltipElement == null) {
+      this._buildElements();
+    }
+    this._updateElementContent();
+    if (this.options.ajax && (!this.loaded || !this.options.cache)) {
+      this._loadAjax();
+    }
+    this._searchAndActivateCloseButtons();
+    this._startEnsureTriggerElement();
+    this.adapter.css(this.container, {
+      zIndex: Opentip.lastZIndex++
+    });
+    this._setupObservers("-hidden", "-hiding", "-showing", "-visible", "showing", "visible");
+    if (this.options.fixed && !this.options.target) {
+      this.initialMousePosition = mousePosition;
+    }
+    this.reposition();
+    this.adapter.removeClass(this.container, this["class"].hiding);
+    this.adapter.removeClass(this.container, this["class"].hidden);
+    this.adapter.addClass(this.container, this["class"].goingToShow);
+    this.setCss3Style(this.container, {
+      transitionDuration: "0s"
+    });
+    this.defer(function() {
+      var delay;
+      if (!_this.visible || _this.preparingToHide) {
+        return;
+      }
+      _this.adapter.removeClass(_this.container, _this["class"].goingToShow);
+      _this.adapter.addClass(_this.container, _this["class"].showing);
+      delay = 0;
+      if (_this.options.showEffect && _this.options.showEffectDuration) {
+        delay = _this.options.showEffectDuration;
+      }
+      _this.setCss3Style(_this.container, {
+        transitionDuration: "" + delay + "s"
+      });
+      _this._visibilityStateTimeoutId = _this.setTimeout(function() {
+        _this.adapter.removeClass(_this.container, _this["class"].showing);
+        return _this.adapter.addClass(_this.container, _this["class"].visible);
+      }, delay);
+      return _this._activateFirstInput();
+    });
+    return this._draw();
+  };
+
+  Opentip.prototype._abortShowing = function() {
+    if (this.preparingToShow) {
+      this.debug("Aborting showing.");
+      this._clearTimeouts();
+      this._stopFollowingMousePosition();
+      this.preparingToShow = false;
+      return this._setupObservers("-showing", "-visible", "hiding", "hidden");
+    }
+  };
+
+  Opentip.prototype.prepareToHide = function() {
+    this._abortShowing();
+    this._abortHiding();
+    if (!this.visible) {
+      return;
+    }
+    this.debug("Hiding in " + this.options.hideDelay + "s");
+    this.preparingToHide = true;
+    this._setupObservers("-showing", "visible", "-hidden", "hiding");
+    return this._hideTimeoutId = this.setTimeout(this.bound.hide, this.options.hideDelay);
+  };
+
+  Opentip.prototype.hide = function() {
+    var _this = this;
+    this._abortShowing();
+    if (!this.visible) {
+      return;
+    }
+    this._clearTimeouts();
+    this.debug("Hiding!");
+    this.visible = false;
+    this.preparingToHide = false;
+    this._stopEnsureTriggerElement();
+    this._setupObservers("-showing", "-visible", "-hiding", "-hidden", "hiding", "hidden");
+    if (!this.options.fixed) {
+      this._stopFollowingMousePosition();
+    }
+    if (!this.container) {
+      return;
+    }
+    this.adapter.removeClass(this.container, this["class"].visible);
+    this.adapter.removeClass(this.container, this["class"].showing);
+    this.adapter.addClass(this.container, this["class"].goingToHide);
+    this.setCss3Style(this.container, {
+      transitionDuration: "0s"
+    });
+    return this.defer(function() {
+      var hideDelay;
+      _this.adapter.removeClass(_this.container, _this["class"].goingToHide);
+      _this.adapter.addClass(_this.container, _this["class"].hiding);
+      hideDelay = 0;
+      if (_this.options.hideEffect && _this.options.hideEffectDuration) {
+        hideDelay = _this.options.hideEffectDuration;
+      }
+      _this.setCss3Style(_this.container, {
+        transitionDuration: "" + hideDelay + "s"
+      });
+      return _this._visibilityStateTimeoutId = _this.setTimeout(function() {
+        _this.adapter.removeClass(_this.container, _this["class"].hiding);
+        _this.adapter.addClass(_this.container, _this["class"].hidden);
+        _this.setCss3Style(_this.container, {
+          transitionDuration: "0s"
+        });
+        if (_this.options.removeElementsOnHide) {
+          _this.debug("Removing HTML elements.");
+          _this.adapter.remove(_this.container);
+          delete _this.container;
+          return delete _this.tooltipElement;
+        }
+      }, hideDelay);
+    });
+  };
+
+  Opentip.prototype._abortHiding = function() {
+    if (this.preparingToHide) {
+      this.debug("Aborting hiding.");
+      this._clearTimeouts();
+      this.preparingToHide = false;
+      return this._setupObservers("-hiding", "showing", "visible");
+    }
+  };
+
+  Opentip.prototype.reposition = function() {
+    var position, stem, _ref,
+      _this = this;
+    position = this.getPosition();
+    if (position == null) {
+      return;
+    }
+    stem = this.options.stem;
+    if (this.options.containInViewport) {
+      _ref = this._ensureViewportContainment(position), position = _ref.position, stem = _ref.stem;
+    }
+    if (this._positionsEqual(position, this.currentPosition)) {
+      return;
+    }
+    if (!(!this.options.stem || stem.eql(this.currentStem))) {
+      this.redraw = true;
+    }
+    this.currentPosition = position;
+    this.currentStem = stem;
+    this._draw();
+    this.adapter.css(this.container, {
+      left: "" + position.left + "px",
+      top: "" + position.top + "px"
+    });
+    return this.defer(function() {
+      var rawContainer, redrawFix;
+      rawContainer = _this.adapter.unwrap(_this.container);
+      rawContainer.style.visibility = "hidden";
+      redrawFix = rawContainer.offsetHeight;
+      return rawContainer.style.visibility = "visible";
+    });
+  };
+
+  Opentip.prototype.getPosition = function(tipJoint, targetJoint, stem) {
+    var additionalHorizontal, additionalVertical, offsetDistance, position, stemLength, targetDimensions, targetPosition, unwrappedTarget, _ref;
+    if (!this.container) {
+      return;
+    }
+    if (tipJoint == null) {
+      tipJoint = this.options.tipJoint;
+    }
+    if (targetJoint == null) {
+      targetJoint = this.options.targetJoint;
+    }
+    position = {};
+    if (this.options.target) {
+      targetPosition = this.adapter.offset(this.options.target);
+      targetDimensions = this.adapter.dimensions(this.options.target);
+      position = targetPosition;
+      if (targetJoint.right) {
+        unwrappedTarget = this.adapter.unwrap(this.options.target);
+        if (unwrappedTarget.getBoundingClientRect != null) {
+          position.left = unwrappedTarget.getBoundingClientRect().right + ((_ref = window.pageXOffset) != null ? _ref : document.body.scrollLeft);
+        } else {
+          position.left += targetDimensions.width;
+        }
+      } else if (targetJoint.center) {
+        position.left += Math.round(targetDimensions.width / 2);
+      }
+      if (targetJoint.bottom) {
+        position.top += targetDimensions.height;
+      } else if (targetJoint.middle) {
+        position.top += Math.round(targetDimensions.height / 2);
+      }
+      if (this.options.borderWidth) {
+        if (this.options.tipJoint.left) {
+          position.left += this.options.borderWidth;
+        }
+        if (this.options.tipJoint.right) {
+          position.left -= this.options.borderWidth;
+        }
+        if (this.options.tipJoint.top) {
+          position.top += this.options.borderWidth;
+        } else if (this.options.tipJoint.bottom) {
+          position.top -= this.options.borderWidth;
+        }
+      }
+    } else {
+      if (this.initialMousePosition) {
+        position = {
+          top: this.initialMousePosition.y,
+          left: this.initialMousePosition.x
+        };
+      } else {
+        position = {
+          top: mousePosition.y,
+          left: mousePosition.x
+        };
+      }
+    }
+    if (this.options.autoOffset) {
+      stemLength = this.options.stem ? this.options.stemLength : 0;
+      offsetDistance = stemLength && this.options.fixed ? 2 : 10;
+      additionalHorizontal = tipJoint.middle && !this.options.fixed ? 15 : 0;
+      additionalVertical = tipJoint.center && !this.options.fixed ? 15 : 0;
+      if (tipJoint.right) {
+        position.left -= offsetDistance + additionalHorizontal;
+      } else if (tipJoint.left) {
+        position.left += offsetDistance + additionalHorizontal;
+      }
+      if (tipJoint.bottom) {
+        position.top -= offsetDistance + additionalVertical;
+      } else if (tipJoint.top) {
+        position.top += offsetDistance + additionalVertical;
+      }
+      if (stemLength) {
+        if (stem == null) {
+          stem = this.options.stem;
+        }
+        if (stem.right) {
+          position.left -= stemLength;
+        } else if (stem.left) {
+          position.left += stemLength;
+        }
+        if (stem.bottom) {
+          position.top -= stemLength;
+        } else if (stem.top) {
+          position.top += stemLength;
+        }
+      }
+    }
+    position.left += this.options.offset[0];
+    position.top += this.options.offset[1];
+    if (tipJoint.right) {
+      position.left -= this.dimensions.width;
+    } else if (tipJoint.center) {
+      position.left -= Math.round(this.dimensions.width / 2);
+    }
+    if (tipJoint.bottom) {
+      position.top -= this.dimensions.height;
+    } else if (tipJoint.middle) {
+      position.top -= Math.round(this.dimensions.height / 2);
+    }
+    return position;
+  };
+
+  Opentip.prototype._ensureViewportContainment = function(position) {
+    var needsRepositioning, newSticksOut, originals, revertedX, revertedY, scrollOffset, stem, sticksOut, targetJoint, tipJoint, viewportDimensions, viewportPosition;
+    stem = this.options.stem;
+    originals = {
+      position: position,
+      stem: stem
+    };
+    if (!(this.visible && position)) {
+      return originals;
+    }
+    sticksOut = this._sticksOut(position);
+    if (!(sticksOut[0] || sticksOut[1])) {
+      return originals;
+    }
+    tipJoint = new Opentip.Joint(this.options.tipJoint);
+    if (this.options.targetJoint) {
+      targetJoint = new Opentip.Joint(this.options.targetJoint);
+    }
+    scrollOffset = this.adapter.scrollOffset();
+    viewportDimensions = this.adapter.viewportDimensions();
+    viewportPosition = [position.left - scrollOffset[0], position.top - scrollOffset[1]];
+    needsRepositioning = false;
+    if (viewportDimensions.width >= this.dimensions.width) {
+      if (sticksOut[0]) {
+        needsRepositioning = true;
+        switch (sticksOut[0]) {
+          case this.STICKS_OUT_LEFT:
+            tipJoint.setHorizontal("left");
+            if (this.options.targetJoint) {
+              targetJoint.setHorizontal("right");
+            }
+            break;
+          case this.STICKS_OUT_RIGHT:
+            tipJoint.setHorizontal("right");
+            if (this.options.targetJoint) {
+              targetJoint.setHorizontal("left");
+            }
+        }
+      }
+    }
+    if (viewportDimensions.height >= this.dimensions.height) {
+      if (sticksOut[1]) {
+        needsRepositioning = true;
+        switch (sticksOut[1]) {
+          case this.STICKS_OUT_TOP:
+            tipJoint.setVertical("top");
+            if (this.options.targetJoint) {
+              targetJoint.setVertical("bottom");
+            }
+            break;
+          case this.STICKS_OUT_BOTTOM:
+            tipJoint.setVertical("bottom");
+            if (this.options.targetJoint) {
+              targetJoint.setVertical("top");
+            }
+        }
+      }
+    }
+    if (!needsRepositioning) {
+      return originals;
+    }
+    if (this.options.stem) {
+      stem = tipJoint;
+    }
+    position = this.getPosition(tipJoint, targetJoint, stem);
+    newSticksOut = this._sticksOut(position);
+    revertedX = false;
+    revertedY = false;
+    if (newSticksOut[0] && (newSticksOut[0] !== sticksOut[0])) {
+      revertedX = true;
+      tipJoint.setHorizontal(this.options.tipJoint.horizontal);
+      if (this.options.targetJoint) {
+        targetJoint.setHorizontal(this.options.targetJoint.horizontal);
+      }
+    }
+    if (newSticksOut[1] && (newSticksOut[1] !== sticksOut[1])) {
+      revertedY = true;
+      tipJoint.setVertical(this.options.tipJoint.vertical);
+      if (this.options.targetJoint) {
+        targetJoint.setVertical(this.options.targetJoint.vertical);
+      }
+    }
+    if (revertedX && revertedY) {
+      return originals;
+    }
+    if (revertedX || revertedY) {
+      if (this.options.stem) {
+        stem = tipJoint;
+      }
+      position = this.getPosition(tipJoint, targetJoint, stem);
+    }
+    return {
+      position: position,
+      stem: stem
+    };
+  };
+
+  Opentip.prototype._sticksOut = function(position) {
+    var positionOffset, scrollOffset, sticksOut, viewportDimensions;
+    scrollOffset = this.adapter.scrollOffset();
+    viewportDimensions = this.adapter.viewportDimensions();
+    positionOffset = [position.left - scrollOffset[0], position.top - scrollOffset[1]];
+    sticksOut = [false, false];
+    if (positionOffset[0] < 0) {
+      sticksOut[0] = this.STICKS_OUT_LEFT;
+    } else if (positionOffset[0] + this.dimensions.width > viewportDimensions.width) {
+      sticksOut[0] = this.STICKS_OUT_RIGHT;
+    }
+    if (positionOffset[1] < 0) {
+      sticksOut[1] = this.STICKS_OUT_TOP;
+    } else if (positionOffset[1] + this.dimensions.height > viewportDimensions.height) {
+      sticksOut[1] = this.STICKS_OUT_BOTTOM;
+    }
+    return sticksOut;
+  };
+
+  Opentip.prototype._draw = function() {
+    var backgroundCanvas, bulge, canvasDimensions, canvasPosition, closeButton, closeButtonInner, closeButtonOuter, ctx, drawCorner, drawLine, hb, position, stemBase, stemLength, _i, _len, _ref, _ref1, _ref2,
+      _this = this;
+    if (!(this.backgroundCanvas && this.redraw)) {
+      return;
+    }
+    this.debug("Drawing background.");
+    this.redraw = false;
+    if (this.currentStem) {
+      _ref = ["top", "right", "bottom", "left"];
+      for (_i = 0, _len = _ref.length; _i < _len; _i++) {
+        position = _ref[_i];
+        this.adapter.removeClass(this.container, "stem-" + position);
+      }
+      this.adapter.addClass(this.container, "stem-" + this.currentStem.horizontal);
+      this.adapter.addClass(this.container, "stem-" + this.currentStem.vertical);
+    }
+    closeButtonInner = [0, 0];
+    closeButtonOuter = [0, 0];
+    if (__indexOf.call(this.options.hideTriggers, "closeButton") >= 0) {
+      closeButton = new Opentip.Joint(((_ref1 = this.currentStem) != null ? _ref1.toString() : void 0) === "top right" ? "top left" : "top right");
+      closeButtonInner = [this.options.closeButtonRadius + this.options.closeButtonOffset[0], this.options.closeButtonRadius + this.options.closeButtonOffset[1]];
+      closeButtonOuter = [this.options.closeButtonRadius - this.options.closeButtonOffset[0], this.options.closeButtonRadius - this.options.closeButtonOffset[1]];
+    }
+    canvasDimensions = this.adapter.clone(this.dimensions);
+    canvasPosition = [0, 0];
+    if (this.options.borderWidth) {
+      canvasDimensions.width += this.options.borderWidth * 2;
+      canvasDimensions.height += this.options.borderWidth * 2;
+      canvasPosition[0] -= this.options.borderWidth;
+      canvasPosition[1] -= this.options.borderWidth;
+    }
+    if (this.options.shadow) {
+      canvasDimensions.width += this.options.shadowBlur * 2;
+      canvasDimensions.width += Math.max(0, this.options.shadowOffset[0] - this.options.shadowBlur * 2);
+      canvasDimensions.height += this.options.shadowBlur * 2;
+      canvasDimensions.height += Math.max(0, this.options.shadowOffset[1] - this.options.shadowBlur * 2);
+      canvasPosition[0] -= Math.max(0, this.options.shadowBlur - this.options.shadowOffset[0]);
+      canvasPosition[1] -= Math.max(0, this.options.shadowBlur - this.options.shadowOffset[1]);
+    }
+    bulge = {
+      left: 0,
+      right: 0,
+      top: 0,
+      bottom: 0
+    };
+    if (this.currentStem) {
+      if (this.currentStem.left) {
+        bulge.left = this.options.stemLength;
+      } else if (this.currentStem.right) {
+        bulge.right = this.options.stemLength;
+      }
+      if (this.currentStem.top) {
+        bulge.top = this.options.stemLength;
+      } else if (this.currentStem.bottom) {
+        bulge.bottom = this.options.stemLength;
+      }
+    }
+    if (closeButton) {
+      if (closeButton.left) {
+        bulge.left = Math.max(bulge.left, closeButtonOuter[0]);
+      } else if (closeButton.right) {
+        bulge.right = Math.max(bulge.right, closeButtonOuter[0]);
+      }
+      if (closeButton.top) {
+        bulge.top = Math.max(bulge.top, closeButtonOuter[1]);
+      } else if (closeButton.bottom) {
+        bulge.bottom = Math.max(bulge.bottom, closeButtonOuter[1]);
+      }
+    }
+    canvasDimensions.width += bulge.left + bulge.right;
+    canvasDimensions.height += bulge.top + bulge.bottom;
+    canvasPosition[0] -= bulge.left;
+    canvasPosition[1] -= bulge.top;
+    if (this.currentStem && this.options.borderWidth) {
+      _ref2 = this._getPathStemMeasures(this.options.stemBase, this.options.stemLength, this.options.borderWidth), stemLength = _ref2.stemLength, stemBase = _ref2.stemBase;
+    }
+    backgroundCanvas = this.adapter.unwrap(this.backgroundCanvas);
+    backgroundCanvas.width = canvasDimensions.width;
+    backgroundCanvas.height = canvasDimensions.height;
+    this.adapter.css(this.backgroundCanvas, {
+      width: "" + backgroundCanvas.width + "px",
+      height: "" + backgroundCanvas.height + "px",
+      left: "" + canvasPosition[0] + "px",
+      top: "" + canvasPosition[1] + "px"
+    });
+    ctx = backgroundCanvas.getContext("2d");
+    ctx.setTransform(1, 0, 0, 1, 0, 0);
+    ctx.clearRect(0, 0, backgroundCanvas.width, backgroundCanvas.height);
+    ctx.beginPath();
+    ctx.fillStyle = this._getColor(ctx, this.dimensions, this.options.background, this.options.backgroundGradientHorizontal);
+    ctx.lineJoin = "miter";
+    ctx.miterLimit = 500;
+    hb = this.options.borderWidth / 2;
+    if (this.options.borderWidth) {
+      ctx.strokeStyle = this.options.borderColor;
+      ctx.lineWidth = this.options.borderWidth;
+    } else {
+      stemLength = this.options.stemLength;
+      stemBase = this.options.stemBase;
+    }
+    if (stemBase == null) {
+      stemBase = 0;
+    }
+    drawLine = function(length, stem, first) {
+      if (first) {
+        ctx.moveTo(Math.max(stemBase, _this.options.borderRadius, closeButtonInner[0]) + 1 - hb, -hb);
+      }
+      if (stem) {
+        ctx.lineTo(length / 2 - stemBase / 2, -hb);
+        ctx.lineTo(length / 2, -stemLength - hb);
+        return ctx.lineTo(length / 2 + stemBase / 2, -hb);
+      }
+    };
+    drawCorner = function(stem, closeButton, i) {
+      var angle1, angle2, innerWidth, offset;
+      if (stem) {
+        ctx.lineTo(-stemBase + hb, 0 - hb);
+        ctx.lineTo(stemLength + hb, -stemLength - hb);
+        return ctx.lineTo(hb, stemBase - hb);
+      } else if (closeButton) {
+        offset = _this.options.closeButtonOffset;
+        innerWidth = closeButtonInner[0];
+        if (i % 2 !== 0) {
+          offset = [offset[1], offset[0]];
+          innerWidth = closeButtonInner[1];
+        }
+        angle1 = Math.acos(offset[1] / _this.options.closeButtonRadius);
+        angle2 = Math.acos(offset[0] / _this.options.closeButtonRadius);
+        ctx.lineTo(-innerWidth + hb, -hb);
+        return ctx.arc(hb - offset[0], -hb + offset[1], _this.options.closeButtonRadius, -(Math.PI / 2 + angle1), angle2, false);
+      } else {
+        ctx.lineTo(-_this.options.borderRadius + hb, -hb);
+        return ctx.quadraticCurveTo(hb, -hb, hb, _this.options.borderRadius - hb);
+      }
+    };
+    ctx.translate(-canvasPosition[0], -canvasPosition[1]);
+    ctx.save();
+    (function() {
+      var cornerStem, i, lineLength, lineStem, positionIdx, positionX, positionY, rotation, _j, _ref3, _results;
+      _results = [];
+      for (i = _j = 0, _ref3 = Opentip.positions.length / 2; 0 <= _ref3 ? _j < _ref3 : _j > _ref3; i = 0 <= _ref3 ? ++_j : --_j) {
+        positionIdx = i * 2;
+        positionX = i === 0 || i === 3 ? 0 : _this.dimensions.width;
+        positionY = i < 2 ? 0 : _this.dimensions.height;
+        rotation = (Math.PI / 2) * i;
+        lineLength = i % 2 === 0 ? _this.dimensions.width : _this.dimensions.height;
+        lineStem = new Opentip.Joint(Opentip.positions[positionIdx]);
+        cornerStem = new Opentip.Joint(Opentip.positions[positionIdx + 1]);
+        ctx.save();
+        ctx.translate(positionX, positionY);
+        ctx.rotate(rotation);
+        drawLine(lineLength, lineStem.eql(_this.currentStem), i === 0);
+        ctx.translate(lineLength, 0);
+        drawCorner(cornerStem.eql(_this.currentStem), cornerStem.eql(closeButton), i);
+        _results.push(ctx.restore());
+      }
+      return _results;
+    })();
+    ctx.closePath();
+    ctx.save();
+    if (this.options.shadow) {
+      ctx.shadowColor = this.options.shadowColor;
+      ctx.shadowBlur = this.options.shadowBlur;
+      ctx.shadowOffsetX = this.options.shadowOffset[0];
+      ctx.shadowOffsetY = this.options.shadowOffset[1];
+    }
+    ctx.fill();
+    ctx.restore();
+    if (this.options.borderWidth) {
+      ctx.stroke();
+    }
+    ctx.restore();
+    if (closeButton) {
+      return (function() {
+        var crossCenter, crossHeight, crossWidth, hcs, linkCenter;
+        crossWidth = crossHeight = _this.options.closeButtonRadius * 2;
+        if (closeButton.toString() === "top right") {
+          linkCenter = [_this.dimensions.width - _this.options.closeButtonOffset[0], _this.options.closeButtonOffset[1]];
+          crossCenter = [linkCenter[0] + hb, linkCenter[1] - hb];
+        } else {
+          linkCenter = [_this.options.closeButtonOffset[0], _this.options.closeButtonOffset[1]];
+          crossCenter = [linkCenter[0] - hb, linkCenter[1] - hb];
+        }
+        ctx.translate(crossCenter[0], crossCenter[1]);
+        hcs = _this.options.closeButtonCrossSize / 2;
+        ctx.save();
+        ctx.beginPath();
+        ctx.strokeStyle = _this.options.closeButtonCrossColor;
+        ctx.lineWidth = _this.options.closeButtonCrossLineWidth;
+        ctx.lineCap = "round";
+        ctx.moveTo(-hcs, -hcs);
+        ctx.lineTo(hcs, hcs);
+        ctx.stroke();
+        ctx.beginPath();
+        ctx.moveTo(hcs, -hcs);
+        ctx.lineTo(-hcs, hcs);
+        ctx.stroke();
+        ctx.restore();
+        return _this.adapter.css(_this.closeButtonElement, {
+          left: "" + (linkCenter[0] - hcs - _this.options.closeButtonLinkOverscan) + "px",
+          top: "" + (linkCenter[1] - hcs - _this.options.closeButtonLinkOverscan) + "px",
+          width: "" + (_this.options.closeButtonCrossSize + _this.options.closeButtonLinkOverscan * 2) + "px",
+          height: "" + (_this.options.closeButtonCrossSize + _this.options.closeButtonLinkOverscan * 2) + "px"
+        });
+      })();
+    }
+  };
+
+  Opentip.prototype._getPathStemMeasures = function(outerStemBase, outerStemLength, borderWidth) {
+    var angle, distanceBetweenTips, halfAngle, hb, rhombusSide, stemBase, stemLength;
+    hb = borderWidth / 2;
+    halfAngle = Math.atan((outerStemBase / 2) / outerStemLength);
+    angle = halfAngle * 2;
+    rhombusSide = hb / Math.sin(angle);
+    distanceBetweenTips = 2 * rhombusSide * Math.cos(halfAngle);
+    stemLength = hb + outerStemLength - distanceBetweenTips;
+    if (stemLength < 0) {
+      throw new Error("Sorry but your stemLength / stemBase ratio is strange.");
+    }
+    stemBase = (Math.tan(halfAngle) * stemLength) * 2;
+    return {
+      stemLength: stemLength,
+      stemBase: stemBase
+    };
+  };
+
+  Opentip.prototype._getColor = function(ctx, dimensions, color, horizontal) {
+    var colorStop, gradient, i, _i, _len;
+    if (horizontal == null) {
+      horizontal = false;
+    }
+    if (typeof color === "string") {
+      return color;
+    }
+    if (horizontal) {
+      gradient = ctx.createLinearGradient(0, 0, dimensions.width, 0);
+    } else {
+      gradient = ctx.createLinearGradient(0, 0, 0, dimensions.height);
+    }
+    for (i = _i = 0, _len = color.length; _i < _len; i = ++_i) {
+      colorStop = color[i];
+      gradient.addColorStop(colorStop[0], colorStop[1]);
+    }
+    return gradient;
+  };
+
+  Opentip.prototype._searchAndActivateCloseButtons = function() {
+    var element, _i, _len, _ref;
+    _ref = this.adapter.findAll(this.container, "." + this["class"].close);
+    for (_i = 0, _len = _ref.length; _i < _len; _i++) {
+      element = _ref[_i];
+      this.hideTriggers.push({
+        element: this.adapter.wrap(element),
+        event: "click"
+      });
+    }
+    if (this.currentObservers.showing) {
+      this._setupObservers("-showing", "showing");
+    }
+    if (this.currentObservers.visible) {
+      return this._setupObservers("-visible", "visible");
+    }
+  };
+
+  Opentip.prototype._activateFirstInput = function() {
+    var input;
+    input = this.adapter.unwrap(this.adapter.find(this.container, "input, textarea"));
+    return input != null ? typeof input.focus === "function" ? input.focus() : void 0 : void 0;
+  };
+
+  Opentip.prototype._followMousePosition = function() {
+    if (!this.options.fixed) {
+      return Opentip._observeMousePosition(this.bound.reposition);
+    }
+  };
+
+  Opentip.prototype._stopFollowingMousePosition = function() {
+    if (!this.options.fixed) {
+      return Opentip._stopObservingMousePosition(this.bound.reposition);
+    }
+  };
+
+  Opentip.prototype._clearShowTimeout = function() {
+    return clearTimeout(this._showTimeoutId);
+  };
+
+  Opentip.prototype._clearHideTimeout = function() {
+    return clearTimeout(this._hideTimeoutId);
+  };
+
+  Opentip.prototype._clearTimeouts = function() {
+    clearTimeout(this._visibilityStateTimeoutId);
+    this._clearShowTimeout();
+    return this._clearHideTimeout();
+  };
+
+  Opentip.prototype._triggerElementExists = function() {
+    var el;
+    el = this.adapter.unwrap(this.triggerElement);
+    while (el.parentNode) {
+      if (el.parentNode.tagName === "BODY") {
+        return true;
+      }
+      el = el.parentNode;
+    }
+    return false;
+  };
+
+  Opentip.prototype._loadAjax = function() {
+    var _this = this;
+    if (this.loading) {
+      return;
+    }
+    this.loaded = false;
+    this.loading = true;
+    this.adapter.addClass(this.container, this["class"].loading);
+    this.setContent("");
+    this.debug("Loading content from " + this.options.ajax);
+    return this.adapter.ajax({
+      url: this.options.ajax,
+      method: this.options.ajaxMethod,
+      onSuccess: function(responseText) {
+        _this.debug("Loading successful.");
+        _this.adapter.removeClass(_this.container, _this["class"].loading);
+        return _this.setContent(responseText);
+      },
+      onError: function(error) {
+        var message;
+        message = _this.options.ajaxErrorMessage;
+        _this.debug(message, error);
+        _this.setContent(message);
+        return _this.adapter.addClass(_this.container, _this["class"].ajaxError);
+      },
+      onComplete: function() {
+        _this.adapter.removeClass(_this.container, _this["class"].loading);
+        _this.loading = false;
+        _this.loaded = true;
+        _this._searchAndActivateCloseButtons();
+        _this._activateFirstInput();
+        return _this.reposition();
+      }
+    });
+  };
+
+  Opentip.prototype._ensureTriggerElement = function() {
+    if (!this._triggerElementExists()) {
+      this.deactivate();
+      return this._stopEnsureTriggerElement();
+    }
+  };
+
+  Opentip.prototype._ensureTriggerElementInterval = 1000;
+
+  Opentip.prototype._startEnsureTriggerElement = function() {
+    var _this = this;
+    return this._ensureTriggerElementTimeoutId = setInterval((function() {
+      return _this._ensureTriggerElement();
+    }), this._ensureTriggerElementInterval);
+  };
+
+  Opentip.prototype._stopEnsureTriggerElement = function() {
+    return clearInterval(this._ensureTriggerElementTimeoutId);
+  };
+
+  return Opentip;
+
+})();
+
+vendors = ["khtml", "ms", "o", "moz", "webkit"];
+
+Opentip.prototype.setCss3Style = function(element, styles) {
+  var prop, value, vendor, vendorProp, _results;
+  element = this.adapter.unwrap(element);
+  _results = [];
+  for (prop in styles) {
+    if (!__hasProp.call(styles, prop)) continue;
+    value = styles[prop];
+    if (element.style[prop] != null) {
+      _results.push(element.style[prop] = value);
+    } else {
+      _results.push((function() {
+        var _i, _len, _results1;
+        _results1 = [];
+        for (_i = 0, _len = vendors.length; _i < _len; _i++) {
+          vendor = vendors[_i];
+          vendorProp = "" + (this.ucfirst(vendor)) + (this.ucfirst(prop));
+          if (element.style[vendorProp] != null) {
+            _results1.push(element.style[vendorProp] = value);
+          } else {
+            _results1.push(void 0);
+          }
+        }
+        return _results1;
+      }).call(this));
+    }
+  }
+  return _results;
+};
+
+Opentip.prototype.defer = function(func) {
+  return setTimeout(func, 0);
+};
+
+Opentip.prototype.setTimeout = function(func, seconds) {
+  return setTimeout(func, seconds ? seconds * 1000 : 0);
+};
+
+Opentip.prototype.ucfirst = function(string) {
+  if (string == null) {
+    return "";
+  }
+  return string.charAt(0).toUpperCase() + string.slice(1);
+};
+
+Opentip.prototype.dasherize = function(string) {
+  return string.replace(/([A-Z])/g, function(_, character) {
+    return "-" + (character.toLowerCase());
+  });
+};
+
+mousePositionObservers = [];
+
+mousePosition = {
+  x: 0,
+  y: 0
+};
+
+mouseMoved = function(e) {
+  var observer, _i, _len, _results;
+  mousePosition = Opentip.adapter.mousePosition(e);
+  _results = [];
+  for (_i = 0, _len = mousePositionObservers.length; _i < _len; _i++) {
+    observer = mousePositionObservers[_i];
+    _results.push(observer());
+  }
+  return _results;
+};
+
+Opentip.followMousePosition = function() {
+  return Opentip.adapter.observe(document.body, "mousemove", mouseMoved);
+};
+
+Opentip._observeMousePosition = function(observer) {
+  return mousePositionObservers.push(observer);
+};
+
+Opentip._stopObservingMousePosition = function(removeObserver) {
+  var observer;
+  return mousePositionObservers = (function() {
+    var _i, _len, _results;
+    _results = [];
+    for (_i = 0, _len = mousePositionObservers.length; _i < _len; _i++) {
+      observer = mousePositionObservers[_i];
+      if (observer !== removeObserver) {
+        _results.push(observer);
+      }
+    }
+    return _results;
+  })();
+};
+
+Opentip.Joint = (function() {
+
+  function Joint(pointerString) {
+    if (pointerString == null) {
+      return;
+    }
+    if (pointerString instanceof Opentip.Joint) {
+      pointerString = pointerString.toString();
+    }
+    this.set(pointerString);
+    this;
+
+  }
+
+  Joint.prototype.set = function(string) {
+    string = string.toLowerCase();
+    this.setHorizontal(string);
+    this.setVertical(string);
+    return this;
+  };
+
+  Joint.prototype.setHorizontal = function(string) {
+    var i, valid, _i, _j, _len, _len1, _results;
+    valid = ["left", "center", "right"];
+    for (_i = 0, _len = valid.length; _i < _len; _i++) {
+      i = valid[_i];
+      if (~string.indexOf(i)) {
+        this.horizontal = i.toLowerCase();
+      }
+    }
+    if (this.horizontal == null) {
+      this.horizontal = "center";
+    }
+    _results = [];
+    for (_j = 0, _len1 = valid.length; _j < _len1; _j++) {
+      i = valid[_j];
+      _results.push(this[i] = this.horizontal === i ? i : void 0);
+    }
+    return _results;
+  };
+
+  Joint.prototype.setVertical = function(string) {
+    var i, valid, _i, _j, _len, _len1, _results;
+    valid = ["top", "middle", "bottom"];
+    for (_i = 0, _len = valid.length; _i < _len; _i++) {
+      i = valid[_i];
+      if (~string.indexOf(i)) {
+        this.vertical = i.toLowerCase();
+      }
+    }
+    if (this.vertical == null) {
+      this.vertical = "middle";
+    }
+    _results = [];
+    for (_j = 0, _len1 = valid.length; _j < _len1; _j++) {
+      i = valid[_j];
+      _results.push(this[i] = this.vertical === i ? i : void 0);
+    }
+    return _results;
+  };
+
+  Joint.prototype.eql = function(pointer) {
+    return (pointer != null) && this.horizontal === pointer.horizontal && this.vertical === pointer.vertical;
+  };
+
+  Joint.prototype.flip = function() {
+    var flippedIndex, positionIdx;
+    positionIdx = Opentip.position[this.toString(true)];
+    flippedIndex = (positionIdx + 4) % 8;
+    this.set(Opentip.positions[flippedIndex]);
+    return this;
+  };
+
+  Joint.prototype.toString = function(camelized) {
+    var horizontal, vertical;
+    if (camelized == null) {
+      camelized = false;
+    }
+    vertical = this.vertical === "middle" ? "" : this.vertical;
+    horizontal = this.horizontal === "center" ? "" : this.horizontal;
+    if (vertical && horizontal) {
+      if (camelized) {
+        horizontal = Opentip.prototype.ucfirst(horizontal);
+      } else {
+        horizontal = " " + horizontal;
+      }
+    }
+    return "" + vertical + horizontal;
+  };
+
+  return Joint;
+
+})();
+
+Opentip.prototype._positionsEqual = function(posA, posB) {
+  return (posA != null) && (posB != null) && posA.left === posB.left && posA.top === posB.top;
+};
+
+Opentip.prototype._dimensionsEqual = function(dimA, dimB) {
+  return (dimA != null) && (dimB != null) && dimA.width === dimB.width && dimA.height === dimB.height;
+};
+
+Opentip.prototype.debug = function() {
+  var args;
+  args = 1 <= arguments.length ? __slice.call(arguments, 0) : [];
+  if (Opentip.debug && ((typeof console !== "undefined" && console !== null ? console.debug : void 0) != null)) {
+    args.unshift("#" + this.id + " |");
+    return console.debug.apply(console, args);
+  }
+};
+
+Opentip.findElements = function() {
+  var adapter, content, element, optionName, optionValue, options, _i, _len, _ref, _results;
+  adapter = Opentip.adapter;
+  _ref = adapter.findAll(document.body, "[data-ot]");
+  _results = [];
+  for (_i = 0, _len = _ref.length; _i < _len; _i++) {
+    element = _ref[_i];
+    options = {};
+    content = adapter.data(element, "ot");
+    if (content === "" || content === "true" || content === "yes") {
+      content = adapter.attr(element, "title");
+      adapter.attr(element, "title", "");
+    }
+    content = content || "";
+    for (optionName in Opentip.styles.standard) {
+      optionValue = adapter.data(element, "ot" + (Opentip.prototype.ucfirst(optionName)));
+      if (optionValue != null) {
+        if (optionValue === "yes" || optionValue === "true" || optionValue === "on") {
+          optionValue = true;
+        } else if (optionValue === "no" || optionValue === "false" || optionValue === "off") {
+          optionValue = false;
+        }
+        options[optionName] = optionValue;
+      }
+    }
+    _results.push(new Opentip(element, content, options));
+  }
+  return _results;
+};
+
+Opentip.version = "2.4.6";
+
+Opentip.debug = false;
+
+Opentip.lastId = 0;
+
+Opentip.lastZIndex = 100;
+
+Opentip.tips = [];
+
+Opentip._abortShowingGroup = function(group, originatingOpentip) {
+  var opentip, _i, _len, _ref, _results;
+  _ref = Opentip.tips;
+  _results = [];
+  for (_i = 0, _len = _ref.length; _i < _len; _i++) {
+    opentip = _ref[_i];
+    if (opentip !== originatingOpentip && opentip.options.group === group) {
+      _results.push(opentip._abortShowing());
+    } else {
+      _results.push(void 0);
+    }
+  }
+  return _results;
+};
+
+Opentip._hideGroup = function(group, originatingOpentip) {
+  var opentip, _i, _len, _ref, _results;
+  _ref = Opentip.tips;
+  _results = [];
+  for (_i = 0, _len = _ref.length; _i < _len; _i++) {
+    opentip = _ref[_i];
+    if (opentip !== originatingOpentip && opentip.options.group === group) {
+      _results.push(opentip.hide());
+    } else {
+      _results.push(void 0);
+    }
+  }
+  return _results;
+};
+
+Opentip.adapters = {};
+
+Opentip.adapter = null;
+
+firstAdapter = true;
+
+Opentip.addAdapter = function(adapter) {
+  Opentip.adapters[adapter.name] = adapter;
+  if (firstAdapter) {
+    Opentip.adapter = adapter;
+    adapter.domReady(Opentip.findElements);
+    adapter.domReady(Opentip.followMousePosition);
+    return firstAdapter = false;
+  }
+};
+
+Opentip.positions = ["top", "topRight", "right", "bottomRight", "bottom", "bottomLeft", "left", "topLeft"];
+
+Opentip.position = {};
+
+_ref = Opentip.positions;
+for (i = _i = 0, _len = _ref.length; _i < _len; i = ++_i) {
+  position = _ref[i];
+  Opentip.position[position] = i;
+}
+
+Opentip.styles = {
+  standard: {
+    "extends": null,
+    title: void 0,
+    escapeTitle: true,
+    escapeContent: false,
+    className: "standard",
+    stem: true,
+    delay: null,
+    hideDelay: 0.1,
+    fixed: false,
+    showOn: "mouseover",
+    hideTrigger: "trigger",
+    hideTriggers: [],
+    hideOn: null,
+    removeElementsOnHide: false,
+    offset: [0, 0],
+    containInViewport: true,
+    autoOffset: true,
+    showEffect: "appear",
+    hideEffect: "fade",
+    showEffectDuration: 0.3,
+    hideEffectDuration: 0.2,
+    stemLength: 5,
+    stemBase: 8,
+    tipJoint: "top left",
+    target: null,
+    targetJoint: null,
+    cache: true,
+    ajax: false,
+    ajaxMethod: "GET",
+    ajaxErrorMessage: "There was a problem downloading the content.",
+    group: null,
+    style: null,
+    background: "#fff18f",
+    backgroundGradientHorizontal: false,
+    closeButtonOffset: [5, 5],
+    closeButtonRadius: 7,
+    closeButtonCrossSize: 4,
+    closeButtonCrossColor: "#d2c35b",
+    closeButtonCrossLineWidth: 1.5,
+    closeButtonLinkOverscan: 6,
+    borderRadius: 5,
+    borderWidth: 1,
+    borderColor: "#f2e37b",
+    shadow: true,
+    shadowBlur: 10,
+    shadowOffset: [3, 3],
+    shadowColor: "rgba(0, 0, 0, 0.1)"
+  },
+  glass: {
+    "extends": "standard",
+    className: "glass",
+    background: [[0, "rgba(252, 252, 252, 0.8)"], [0.5, "rgba(255, 255, 255, 0.8)"], [0.5, "rgba(250, 250, 250, 0.9)"], [1, "rgba(245, 245, 245, 0.9)"]],
+    borderColor: "#eee",
+    closeButtonCrossColor: "rgba(0, 0, 0, 0.2)",
+    borderRadius: 15,
+    closeButtonRadius: 10,
+    closeButtonOffset: [8, 8]
+  },
+  dark: {
+    "extends": "standard",
+    className: "dark",
+    borderRadius: 13,
+    borderColor: "#444",
+    closeButtonCrossColor: "rgba(240, 240, 240, 1)",
+    shadowColor: "rgba(0, 0, 0, 0.3)",
+    shadowOffset: [2, 2],
+    background: [[0, "rgba(30, 30, 30, 0.7)"], [0.5, "rgba(30, 30, 30, 0.8)"], [0.5, "rgba(10, 10, 10, 0.8)"], [1, "rgba(10, 10, 10, 0.9)"]]
+  },
+  alert: {
+    "extends": "standard",
+    className: "alert",
+    borderRadius: 1,
+    borderColor: "#AE0D11",
+    closeButtonCrossColor: "rgba(255, 255, 255, 1)",
+    shadowColor: "rgba(0, 0, 0, 0.3)",
+    shadowOffset: [2, 2],
+    background: [[0, "rgba(203, 15, 19, 0.7)"], [0.5, "rgba(203, 15, 19, 0.8)"], [0.5, "rgba(189, 14, 18, 0.8)"], [1, "rgba(179, 14, 17, 0.9)"]]
+  }
+};
+
+Opentip.defaultStyle = "standard";
+
+if (typeof module !== "undefined" && module !== null) {
+  module.exports = Opentip;
+} else {
+  window.Opentip = Opentip;
+}
+
+
+// Generated by CoffeeScript 1.4.0
+var __slice = [].slice;
+
+(function($) {
+  var Adapter;
+  $.fn.opentip = function(content, title, options) {
+    return new Opentip(this, content, title, options);
+  };
+  Adapter = (function() {
+
+    function Adapter() {}
+
+    Adapter.prototype.name = "jquery";
+
+    Adapter.prototype.domReady = function(callback) {
+      return $(callback);
+    };
+
+    Adapter.prototype.create = function(html) {
+      return $(html);
+    };
+
+    Adapter.prototype.wrap = function(element) {
+      element = $(element);
+      if (element.length > 1) {
+        throw new Error("Multiple elements provided.");
+      }
+      return element;
+    };
+
+    Adapter.prototype.unwrap = function(element) {
+      return $(element)[0];
+    };
+
+    Adapter.prototype.tagName = function(element) {
+      return this.unwrap(element).tagName;
+    };
+
+    Adapter.prototype.attr = function() {
+      var args, element, _ref;
+      element = arguments[0], args = 2 <= arguments.length ? __slice.call(arguments, 1) : [];
+      return (_ref = $(element)).attr.apply(_ref, args);
+    };
+
+    Adapter.prototype.data = function() {
+      var args, element, _ref;
+      element = arguments[0], args = 2 <= arguments.length ? __slice.call(arguments, 1) : [];
+      return (_ref = $(element)).data.apply(_ref, args);
+    };
+
+    Adapter.prototype.find = function(element, selector) {
+      return $(element).find(selector).get(0);
+    };
+
+    Adapter.prototype.findAll = function(element, selector) {
+      return $(element).find(selector);
+    };
+
+    Adapter.prototype.update = function(element, content, escape) {
+      element = $(element);
+      if (escape) {
+        return element.text(content);
+      } else {
+        return element.html(content);
+      }
+    };
+
+    Adapter.prototype.append = function(element, child) {
+      return $(element).append(child);
+    };
+
+    Adapter.prototype.remove = function(element) {
+      return $(element).remove();
+    };
+
+    Adapter.prototype.addClass = function(element, className) {
+      return $(element).addClass(className);
+    };
+
+    Adapter.prototype.removeClass = function(element, className) {
+      return $(element).removeClass(className);
+    };
+
+    Adapter.prototype.css = function(element, properties) {
+      return $(element).css(properties);
+    };
+
+    Adapter.prototype.dimensions = function(element) {
+      return {
+        width: $(element).outerWidth(),
+        height: $(element).outerHeight()
+      };
+    };
+
+    Adapter.prototype.scrollOffset = function() {
+      return [window.pageXOffset || document.documentElement.scrollLeft || document.body.scrollLeft, window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop];
+    };
+
+    Adapter.prototype.viewportDimensions = function() {
+      return {
+        width: document.documentElement.clientWidth,
+        height: document.documentElement.clientHeight
+      };
+    };
+
+    Adapter.prototype.mousePosition = function(e) {
+      if (e == null) {
+        return null;
+      }
+      return {
+        x: e.pageX,
+        y: e.pageY
+      };
+    };
+
+    Adapter.prototype.offset = function(element) {
+      var offset;
+      offset = $(element).offset();
+      return {
+        left: offset.left,
+        top: offset.top
+      };
+    };
+
+    Adapter.prototype.observe = function(element, eventName, observer) {
+      return $(element).bind(eventName, observer);
+    };
+
+    Adapter.prototype.stopObserving = function(element, eventName, observer) {
+      return $(element).unbind(eventName, observer);
+    };
+
+    Adapter.prototype.ajax = function(options) {
+      var _ref, _ref1;
+      if (options.url == null) {
+        throw new Error("No url provided");
+      }
+      return $.ajax({
+        url: options.url,
+        type: (_ref = (_ref1 = options.method) != null ? _ref1.toUpperCase() : void 0) != null ? _ref : "GET"
+      }).done(function(content) {
+        return typeof options.onSuccess === "function" ? options.onSuccess(content) : void 0;
+      }).fail(function(request) {
+        return typeof options.onError === "function" ? options.onError("Server responded with status " + request.status) : void 0;
+      }).always(function() {
+        return typeof options.onComplete === "function" ? options.onComplete() : void 0;
+      });
+    };
+
+    Adapter.prototype.clone = function(object) {
+      return $.extend({}, object);
+    };
+
+    Adapter.prototype.extend = function() {
+      var sources, target;
+      target = arguments[0], sources = 2 <= arguments.length ? __slice.call(arguments, 1) : [];
+      return $.extend.apply($, [target].concat(__slice.call(sources)));
+    };
+
+    return Adapter;
+
+  })();
+  return Opentip.addAdapter(new Adapter);
+})(jQuery);
+});
\ No newline at end of file
diff --git "[FORUM_EXT]/vse\\topicimagepreview/styles/BBOOTS/template/js/opentip-jquery.min.js" "[FORUM_EXT]/vse\\topicimagepreview/styles/BBOOTS/template/js/opentip-jquery.min.js"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/vse\\topicimagepreview/styles/BBOOTS/template/js/opentip-jquery.min.js"
@@ -0,0 +1,6 @@
+// Opentip v2.4.6
+// Copyright (c) 2009-2012
+// www.opentip.org
+// MIT Licensed
+head.ready(function(){var Opentip,firstAdapter,i,mouseMoved,mousePosition,mousePositionObservers,position,vendors,_i,_len,_ref,__slice=[].slice,__indexOf=[].indexOf||function(t){for(var e=0,i=this.length;i>e;e++)if(e in this&&this[e]===t)return e;return-1},__hasProp={}.hasOwnProperty;for(Opentip=function(){function t(e,i,o,s){var n,r,a,h,p,d,l,u,c,g,f,m,v,b,w=this;if(this.id=++t.lastId,this.debug("Creating Opentip."),t.tips.push(this),this.adapter=t.adapter,n=this.adapter.data(e,"opentips")||[],n.push(this),this.adapter.data(e,"opentips",n),this.triggerElement=this.adapter.wrap(e),this.triggerElement.length>1)throw Error("You can't call Opentip on multiple elements.");if(1>this.triggerElement.length)throw Error("Invalid element.");this.loaded=!1,this.loading=!1,this.visible=!1,this.waitingToShow=!1,this.waitingToHide=!1,this.currentPosition={left:0,top:0},this.dimensions={width:100,height:50},this.content="",this.redraw=!0,this.currentObservers={showing:!1,visible:!1,hiding:!1,hidden:!1},s=this.adapter.clone(s),typeof i=="object"?(s=i,i=o=void 0):typeof o=="object"&&(s=o,o=void 0),o!=null&&(s.title=o),i!=null&&this.setContent(i),s["extends"]==null&&(s["extends"]=s.style!=null?s.style:t.defaultStyle),h=[s],b=s;while(b["extends"]){if(d=b["extends"],b=t.styles[d],b==null)throw Error("Invalid style: "+d);h.unshift(b),b["extends"]==null&&d!=="standard"&&(b["extends"]="standard")}for(s=(f=this.adapter).extend.apply(f,[{}].concat(__slice.call(h))),s.hideTriggers=function(){var t,e,i,o;for(i=s.hideTriggers,o=[],t=0,e=i.length;e>t;t++)r=i[t],o.push(r);return o}(),s.hideTrigger&&s.hideTriggers.length===0&&s.hideTriggers.push(s.hideTrigger),m=["tipJoint","targetJoint","stem"],l=0,c=m.length;c>l;l++)p=m[l],s[p]&&typeof s[p]=="string"&&(s[p]=new t.Joint(s[p]));for(!s.ajax||s.ajax!==!0&&s.ajax||(s.ajax=this.adapter.tagName(this.triggerElement)==="A"?this.adapter.attr(this.triggerElement,"href"):!1),s.showOn==="click"&&this.adapter.tagName(this.triggerElement)==="A"&&this.adapter.observe(this.triggerElement,"click",function(t){return t.preventDefault(),t.stopPropagation(),t.stopped=!0}),s.target&&(s.fixed=!0),s.stem===!0&&(s.stem=new t.Joint(s.tipJoint)),s.target===!0?s.target=this.triggerElement:s.target&&(s.target=this.adapter.wrap(s.target)),this.currentStem=s.stem,s.delay==null&&(s.delay=s.showOn==="mouseover"?.2:0),s.targetJoint==null&&(s.targetJoint=new t.Joint(s.tipJoint).flip()),this.showTriggers=[],this.showTriggersWhenVisible=[],this.hideTriggers=[],s.showOn&&s.showOn!=="creation"&&this.showTriggers.push({element:this.triggerElement,event:s.showOn}),s.ajaxCache!=null&&(s.cache=s.ajaxCache,delete s.ajaxCache),this.options=s,this.bound={},v=["prepareToShow","prepareToHide","show","hide","reposition"],u=0,g=v.length;g>u;u++)a=v[u],this.bound[a]=function(t){return function(){return w[t].apply(w,arguments)}}(a);this.adapter.domReady(function(){return w.activate(),w.options.showOn==="creation"?w.prepareToShow():void 0})}return t.prototype.STICKS_OUT_TOP=1,t.prototype.STICKS_OUT_BOTTOM=2,t.prototype.STICKS_OUT_LEFT=1,t.prototype.STICKS_OUT_RIGHT=2,t.prototype["class"]={container:"opentip-container",opentip:"opentip",header:"ot-header",content:"ot-content",loadingIndicator:"ot-loading-indicator",close:"ot-close",goingToHide:"ot-going-to-hide",hidden:"ot-hidden",hiding:"ot-hiding",goingToShow:"ot-going-to-show",showing:"ot-showing",visible:"ot-visible",loading:"ot-loading",ajaxError:"ot-ajax-error",fixed:"ot-fixed",showEffectPrefix:"ot-show-effect-",hideEffectPrefix:"ot-hide-effect-",stylePrefix:"style-"},t.prototype._setup=function(){var t,e,i,o,s,n,r,a,h,p,d;for(this.debug("Setting up the tooltip."),this._buildContainer(),this.hideTriggers=[],h=this.options.hideTriggers,o=s=0,r=h.length;r>s;o=++s){if(e=h[o],i=null,t=this.options.hideOn instanceof Array?this.options.hideOn[o]:this.options.hideOn,typeof e=="string")switch(e){case"trigger":t=t||"mouseout",i=this.triggerElement;break;case"tip":t=t||"mouseover",i=this.container;break;case"target":t=t||"mouseover",i=this.options.target;break;case"closeButton":break;default:throw Error("Unknown hide trigger: "+e+".")}else t=t||"mouseover",i=this.adapter.wrap(e);i&&this.hideTriggers.push({element:i,event:t,original:e})}for(p=this.hideTriggers,d=[],n=0,a=p.length;a>n;n++)e=p[n],d.push(this.showTriggersWhenVisible.push({element:e.element,event:"mouseover"}));return d},t.prototype._buildContainer=function(){return this.container=this.adapter.create('<div id="opentip-'+this.id+'" class="'+this["class"].container+" "+this["class"].hidden+" "+this["class"].stylePrefix+this.options.className+'"></div>'),this.adapter.css(this.container,{position:"absolute"}),this.options.ajax&&this.adapter.addClass(this.container,this["class"].loading),this.options.fixed&&this.adapter.addClass(this.container,this["class"].fixed),this.options.showEffect&&this.adapter.addClass(this.container,""+this["class"].showEffectPrefix+this.options.showEffect),this.options.hideEffect?this.adapter.addClass(this.container,""+this["class"].hideEffectPrefix+this.options.hideEffect):void 0},t.prototype._buildElements=function(){var t,e;return this.tooltipElement=this.adapter.create('<div class="'+this["class"].opentip+'"><div class="'+this["class"].header+'"></div><div class="'+this["class"].content+'"></div></div>'),this.backgroundCanvas=this.adapter.wrap(document.createElement("canvas")),this.adapter.css(this.backgroundCanvas,{position:"absolute"}),typeof G_vmlCanvasManager!="undefined"&&G_vmlCanvasManager!==null&&G_vmlCanvasManager.initElement(this.adapter.unwrap(this.backgroundCanvas)),t=this.adapter.find(this.tooltipElement,"."+this["class"].header),this.options.title&&(e=this.adapter.create("<h1></h1>"),this.adapter.update(e,this.options.title,this.options.escapeTitle),this.adapter.append(t,e)),this.options.ajax&&!this.loaded&&this.adapter.append(this.tooltipElement,this.adapter.create('<div class="'+this["class"].loadingIndicator+'"><span>↻</span></div>')),__indexOf.call(this.options.hideTriggers,"closeButton")>=0&&(this.closeButtonElement=this.adapter.create('<a href="javascript:undefined;" class="'+this["class"].close+'"><span>Close</span></a>'),this.adapter.append(t,this.closeButtonElement)),this.adapter.append(this.container,this.backgroundCanvas),this.adapter.append(this.container,this.tooltipElement),this.adapter.append(document.body,this.container),this._newContent=!0,this.redraw=!0},t.prototype.setContent=function(t){return this.content=t,this._newContent=!0,typeof this.content=="function"?(this._contentFunction=this.content,this.content=""):this._contentFunction=null,this.visible?this._updateElementContent():void 0},t.prototype._updateElementContent=function(){var t;return(this._newContent||!this.options.cache&&this._contentFunction)&&(t=this.adapter.find(this.container,"."+this["class"].content),t!=null&&(this._contentFunction&&(this.debug("Executing content function."),this.content=this._contentFunction(this)),this.adapter.update(t,this.content,this.options.escapeContent)),this._newContent=!1),this._storeAndLockDimensions(),this.reposition()},t.prototype._storeAndLockDimensions=function(){var t;if(this.container)return t=this.dimensions,this.adapter.css(this.container,{width:"auto",left:"0px",top:"0px"}),this.dimensions=this.adapter.dimensions(this.container),this.dimensions.width+=1,this.adapter.css(this.container,{width:""+this.dimensions.width+"px",top:""+this.currentPosition.top+"px",left:""+this.currentPosition.left+"px"}),this._dimensionsEqual(this.dimensions,t)?void 0:(this.redraw=!0,this._draw())},t.prototype.activate=function(){return this._setupObservers("hidden","hiding")},t.prototype.deactivate=function(){return this.debug("Deactivating tooltip."),this.hide(),this._setupObservers("-showing","-visible","-hidden","-hiding")},t.prototype._setupObservers=function(){var t,e,i,o,s,n,r,a,h,p,d,l,u,c,g,f,m=this;for(o=arguments.length>=1?__slice.call(arguments,0):[],n=0,p=o.length;p>n;n++)if(i=o[n],e=!1,i.charAt(0)==="-"&&(e=!0,i=i.substr(1)),this.currentObservers[i]!==!e)switch(this.currentObservers[i]=!e,t=function(){var t,i,o;return t=arguments.length>=1?__slice.call(arguments,0):[],e?(i=m.adapter).stopObserving.apply(i,t):(o=m.adapter).observe.apply(o,t)},i){case"showing":for(c=this.hideTriggers,r=0,d=c.length;d>r;r++)s=c[r],t(s.element,s.event,this.bound.prepareToHide);t(document.onresize!=null?document:window,"resize",this.bound.reposition),t(window,"scroll",this.bound.reposition);break;case"visible":for(g=this.showTriggersWhenVisible,a=0,l=g.length;l>a;a++)s=g[a],t(s.element,s.event,this.bound.prepareToShow);break;case"hiding":for(f=this.showTriggers,h=0,u=f.length;u>h;h++)s=f[h],t(s.element,s.event,this.bound.prepareToShow);break;case"hidden":break;default:throw Error("Unknown state: "+i)}return null},t.prototype.prepareToShow=function(){return this._abortHiding(),this._abortShowing(),this.visible?void 0:(this.debug("Showing in "+this.options.delay+"s."),this.container==null&&this._setup(),this.options.group&&t._abortShowingGroup(this.options.group,this),this.preparingToShow=!0,this._setupObservers("-hidden","-hiding","showing"),this._followMousePosition(),this.options.fixed&&!this.options.target&&(this.initialMousePosition=mousePosition),this.reposition(),this._showTimeoutId=this.setTimeout(this.bound.show,this.options.delay||0))},t.prototype.show=function(){var e=this;return this._abortHiding(),this.visible?void 0:(this._clearTimeouts(),this._triggerElementExists()?(this.debug("Showing now."),this.container==null&&this._setup(),this.options.group&&t._hideGroup(this.options.group,this),this.visible=!0,this.preparingToShow=!1,this.tooltipElement==null&&this._buildElements(),this._updateElementContent(),!this.options.ajax||this.loaded&&this.options.cache||this._loadAjax(),this._searchAndActivateCloseButtons(),this._startEnsureTriggerElement(),this.adapter.css(this.container,{zIndex:t.lastZIndex++}),this._setupObservers("-hidden","-hiding","-showing","-visible","showing","visible"),this.options.fixed&&!this.options.target&&(this.initialMousePosition=mousePosition),this.reposition(),this.adapter.removeClass(this.container,this["class"].hiding),this.adapter.removeClass(this.container,this["class"].hidden),this.adapter.addClass(this.container,this["class"].goingToShow),this.setCss3Style(this.container,{transitionDuration:"0s"}),this.defer(function(){var t;if(e.visible&&!e.preparingToHide)return e.adapter.removeClass(e.container,e["class"].goingToShow),e.adapter.addClass(e.container,e["class"].showing),t=0,e.options.showEffect&&e.options.showEffectDuration&&(t=e.options.showEffectDuration),e.setCss3Style(e.container,{transitionDuration:""+t+"s"}),e._visibilityStateTimeoutId=e.setTimeout(function(){return e.adapter.removeClass(e.container,e["class"].showing),e.adapter.addClass(e.container,e["class"].visible)},t),e._activateFirstInput()}),this._draw()):this.deactivate())},t.prototype._abortShowing=function(){return this.preparingToShow?(this.debug("Aborting showing."),this._clearTimeouts(),this._stopFollowingMousePosition(),this.preparingToShow=!1,this._setupObservers("-showing","-visible","hiding","hidden")):void 0},t.prototype.prepareToHide=function(){return this._abortShowing(),this._abortHiding(),this.visible?(this.debug("Hiding in "+this.options.hideDelay+"s"),this.preparingToHide=!0,this._setupObservers("-showing","visible","-hidden","hiding"),this._hideTimeoutId=this.setTimeout(this.bound.hide,this.options.hideDelay)):void 0},t.prototype.hide=function(){var t=this;return this._abortShowing(),this.visible&&(this._clearTimeouts(),this.debug("Hiding!"),this.visible=!1,this.preparingToHide=!1,this._stopEnsureTriggerElement(),this._setupObservers("-showing","-visible","-hiding","-hidden","hiding","hidden"),this.options.fixed||this._stopFollowingMousePosition(),this.container)?(this.adapter.removeClass(this.container,this["class"].visible),this.adapter.removeClass(this.container,this["class"].showing),this.adapter.addClass(this.container,this["class"].goingToHide),this.setCss3Style(this.container,{transitionDuration:"0s"}),this.defer(function(){var e;return t.adapter.removeClass(t.container,t["class"].goingToHide),t.adapter.addClass(t.container,t["class"].hiding),e=0,t.options.hideEffect&&t.options.hideEffectDuration&&(e=t.options.hideEffectDuration),t.setCss3Style(t.container,{transitionDuration:""+e+"s"}),t._visibilityStateTimeoutId=t.setTimeout(function(){return t.adapter.removeClass(t.container,t["class"].hiding),t.adapter.addClass(t.container,t["class"].hidden),t.setCss3Style(t.container,{transitionDuration:"0s"}),t.options.removeElementsOnHide?(t.debug("Removing HTML elements."),t.adapter.remove(t.container),delete t.container,delete t.tooltipElement):void 0},e)})):void 0},t.prototype._abortHiding=function(){return this.preparingToHide?(this.debug("Aborting hiding."),this._clearTimeouts(),this.preparingToHide=!1,this._setupObservers("-hiding","showing","visible")):void 0},t.prototype.reposition=function(){var t,e,i,o=this;return t=this.getPosition(),t==null||(e=this.options.stem,this.options.containInViewport&&(i=this._ensureViewportContainment(t),t=i.position,e=i.stem),this._positionsEqual(t,this.currentPosition))?void 0:(this.options.stem&&!e.eql(this.currentStem)&&(this.redraw=!0),this.currentPosition=t,this.currentStem=e,this._draw(),this.adapter.css(this.container,{left:""+t.left+"px",top:""+t.top+"px"}),this.defer(function(){var t,e;return t=o.adapter.unwrap(o.container),t.style.visibility="hidden",e=t.offsetHeight,t.style.visibility="visible"}))},t.prototype.getPosition=function(t,e,i){var o,s,n,r,a,h,p,d,l;if(this.container)return t==null&&(t=this.options.tipJoint),e==null&&(e=this.options.targetJoint),r={},this.options.target?(p=this.adapter.offset(this.options.target),h=this.adapter.dimensions(this.options.target),r=p,e.right?(d=this.adapter.unwrap(this.options.target),d.getBoundingClientRect!=null?r.left=d.getBoundingClientRect().right+((l=window.pageXOffset)!=null?l:document.body.scrollLeft):r.left+=h.width):e.center&&(r.left+=Math.round(h.width/2)),e.bottom?r.top+=h.height:e.middle&&(r.top+=Math.round(h.height/2)),this.options.borderWidth&&(this.options.tipJoint.left&&(r.left+=this.options.borderWidth),this.options.tipJoint.right&&(r.left-=this.options.borderWidth),this.options.tipJoint.top?r.top+=this.options.borderWidth:this.options.tipJoint.bottom&&(r.top-=this.options.borderWidth))):r=this.initialMousePosition?{top:this.initialMousePosition.y,left:this.initialMousePosition.x}:{top:mousePosition.y,left:mousePosition.x},this.options.autoOffset&&(a=this.options.stem?this.options.stemLength:0,n=a&&this.options.fixed?2:10,o=t.middle&&!this.options.fixed?15:0,s=t.center&&!this.options.fixed?15:0,t.right?r.left-=n+o:t.left&&(r.left+=n+o),t.bottom?r.top-=n+s:t.top&&(r.top+=n+s),a&&(i==null&&(i=this.options.stem),i.right?r.left-=a:i.left&&(r.left+=a),i.bottom?r.top-=a:i.top&&(r.top+=a))),r.left+=this.options.offset[0],r.top+=this.options.offset[1],t.right?r.left-=this.dimensions.width:t.center&&(r.left-=Math.round(this.dimensions.width/2)),t.bottom?r.top-=this.dimensions.height:t.middle&&(r.top-=Math.round(this.dimensions.height/2)),r},t.prototype._ensureViewportContainment=function(e){var i,o,s,n,r,a,h,p,d,l,u,c;if(h=this.options.stem,s={position:e,stem:h},!this.visible||!e)return s;if(p=this._sticksOut(e),!p[0]&&!p[1])return s;if(l=new t.Joint(this.options.tipJoint),this.options.targetJoint&&(d=new t.Joint(this.options.targetJoint)),a=this.adapter.scrollOffset(),u=this.adapter.viewportDimensions(),c=[e.left-a[0],e.top-a[1]],i=!1,u.width>=this.dimensions.width&&p[0])switch(i=!0,p[0]){case this.STICKS_OUT_LEFT:l.setHorizontal("left"),this.options.targetJoint&&d.setHorizontal("right");break;case this.STICKS_OUT_RIGHT:l.setHorizontal("right"),this.options.targetJoint&&d.setHorizontal("left")}if(u.height>=this.dimensions.height&&p[1])switch(i=!0,p[1]){case this.STICKS_OUT_TOP:l.setVertical("top"),this.options.targetJoint&&d.setVertical("bottom");break;case this.STICKS_OUT_BOTTOM:l.setVertical("bottom"),this.options.targetJoint&&d.setVertical("top")}return i?(this.options.stem&&(h=l),e=this.getPosition(l,d,h),o=this._sticksOut(e),n=!1,r=!1,o[0]&&o[0]!==p[0]&&(n=!0,l.setHorizontal(this.options.tipJoint.horizontal),this.options.targetJoint&&d.setHorizontal(this.options.targetJoint.horizontal)),o[1]&&o[1]!==p[1]&&(r=!0,l.setVertical(this.options.tipJoint.vertical),this.options.targetJoint&&d.setVertical(this.options.targetJoint.vertical)),n&&r?s:((n||r)&&(this.options.stem&&(h=l),e=this.getPosition(l,d,h)),{position:e,stem:h})):s},t.prototype._sticksOut=function(t){var e,i,o,s;return i=this.adapter.scrollOffset(),s=this.adapter.viewportDimensions(),e=[t.left-i[0],t.top-i[1]],o=[!1,!1],0>e[0]?o[0]=this.STICKS_OUT_LEFT:e[0]+this.dimensions.width>s.width&&(o[0]=this.STICKS_OUT_RIGHT),0>e[1]?o[1]=this.STICKS_OUT_TOP:e[1]+this.dimensions.height>s.height&&(o[1]=this.STICKS_OUT_BOTTOM),o},t.prototype._draw=function(){var e,i,o,s,n,r,a,h,p,d,l,u,c,g,f,m,v,b,w,_=this;if(this.backgroundCanvas&&this.redraw){if(this.debug("Drawing background."),this.redraw=!1,this.currentStem){for(v=["top","right","bottom","left"],f=0,m=v.length;m>f;f++)u=v[f],this.adapter.removeClass(this.container,"stem-"+u);this.adapter.addClass(this.container,"stem-"+this.currentStem.horizontal),this.adapter.addClass(this.container,"stem-"+this.currentStem.vertical)}return r=[0,0],a=[0,0],__indexOf.call(this.options.hideTriggers,"closeButton")>=0&&(n=new t.Joint(((b=this.currentStem)!=null?b+"":void 0)==="top right"?"top left":"top right"),r=[this.options.closeButtonRadius+this.options.closeButtonOffset[0],this.options.closeButtonRadius+this.options.closeButtonOffset[1]],a=[this.options.closeButtonRadius-this.options.closeButtonOffset[0],this.options.closeButtonRadius-this.options.closeButtonOffset[1]]),o=this.adapter.clone(this.dimensions),s=[0,0],this.options.borderWidth&&(o.width+=this.options.borderWidth*2,o.height+=this.options.borderWidth*2,s[0]-=this.options.borderWidth,s[1]-=this.options.borderWidth),this.options.shadow&&(o.width+=this.options.shadowBlur*2,o.width+=Math.max(0,this.options.shadowOffset[0]-this.options.shadowBlur*2),o.height+=this.options.shadowBlur*2,o.height+=Math.max(0,this.options.shadowOffset[1]-this.options.shadowBlur*2),s[0]-=Math.max(0,this.options.shadowBlur-this.options.shadowOffset[0]),s[1]-=Math.max(0,this.options.shadowBlur-this.options.shadowOffset[1])),i={left:0,right:0,top:0,bottom:0},this.currentStem&&(this.currentStem.left?i.left=this.options.stemLength:this.currentStem.right&&(i.right=this.options.stemLength),this.currentStem.top?i.top=this.options.stemLength:this.currentStem.bottom&&(i.bottom=this.options.stemLength)),n&&(n.left?i.left=Math.max(i.left,a[0]):n.right&&(i.right=Math.max(i.right,a[0])),n.top?i.top=Math.max(i.top,a[1]):n.bottom&&(i.bottom=Math.max(i.bottom,a[1]))),o.width+=i.left+i.right,o.height+=i.top+i.bottom,s[0]-=i.left,s[1]-=i.top,this.currentStem&&this.options.borderWidth&&(w=this._getPathStemMeasures(this.options.stemBase,this.options.stemLength,this.options.borderWidth),g=w.stemLength,c=w.stemBase),e=this.adapter.unwrap(this.backgroundCanvas),e.width=o.width,e.height=o.height,this.adapter.css(this.backgroundCanvas,{width:""+e.width+"px",height:""+e.height+"px",left:""+s[0]+"px",top:""+s[1]+"px"}),h=e.getContext("2d"),h.setTransform(1,0,0,1,0,0),h.clearRect(0,0,e.width,e.height),h.beginPath(),h.fillStyle=this._getColor(h,this.dimensions,this.options.background,this.options.backgroundGradientHorizontal),h.lineJoin="miter",h.miterLimit=500,l=this.options.borderWidth/2,this.options.borderWidth?(h.strokeStyle=this.options.borderColor,h.lineWidth=this.options.borderWidth):(g=this.options.stemLength,c=this.options.stemBase),c==null&&(c=0),d=function(t,e,i){return i&&h.moveTo(Math.max(c,_.options.borderRadius,r[0])+1-l,-l),e?(h.lineTo(t/2-c/2,-l),h.lineTo(t/2,-g-l),h.lineTo(t/2+c/2,-l)):void 0},p=function(t,e,i){var o,s,n,a;return t?(h.lineTo(-c+l,0-l),h.lineTo(g+l,-g-l),h.lineTo(l,c-l)):e?(a=_.options.closeButtonOffset,n=r[0],i%2!==0&&(a=[a[1],a[0]],n=r[1]),o=Math.acos(a[1]/_.options.closeButtonRadius),s=Math.acos(a[0]/_.options.closeButtonRadius),h.lineTo(-n+l,-l),h.arc(l-a[0],-l+a[1],_.options.closeButtonRadius,-(Math.PI/2+o),s,!1)):(h.lineTo(-_.options.borderRadius+l,-l),h.quadraticCurveTo(l,-l,l,_.options.borderRadius-l))},h.translate(-s[0],-s[1]),h.save(),function(){var e,i,o,s,r,a,l,u,c,g,f;for(f=[],i=c=0,g=t.positions.length/2;g>=0?g>c:c>g;i=g>=0?++c:--c)r=i*2,a=i===0||i===3?0:_.dimensions.width,l=2>i?0:_.dimensions.height,u=Math.PI/2*i,o=i%2===0?_.dimensions.width:_.dimensions.height,s=new t.Joint(t.positions[r]),e=new t.Joint(t.positions[r+1]),h.save(),h.translate(a,l),h.rotate(u),d(o,s.eql(_.currentStem),i===0),h.translate(o,0),p(e.eql(_.currentStem),e.eql(n),i),f.push(h.restore());return f}(),h.closePath(),h.save(),this.options.shadow&&(h.shadowColor=this.options.shadowColor,h.shadowBlur=this.options.shadowBlur,h.shadowOffsetX=this.options.shadowOffset[0],h.shadowOffsetY=this.options.shadowOffset[1]),h.fill(),h.restore(),this.options.borderWidth&&h.stroke(),h.restore(),n?function(){var t,e,i,o,s;return i=e=_.options.closeButtonRadius*2,n+""=="top right"?(s=[_.dimensions.width-_.options.closeButtonOffset[0],_.options.closeButtonOffset[1]],t=[s[0]+l,s[1]-l]):(s=[_.options.closeButtonOffset[0],_.options.closeButtonOffset[1]],t=[s[0]-l,s[1]-l]),h.translate(t[0],t[1]),o=_.options.closeButtonCrossSize/2,h.save(),h.beginPath(),h.strokeStyle=_.options.closeButtonCrossColor,h.lineWidth=_.options.closeButtonCrossLineWidth,h.lineCap="round",h.moveTo(-o,-o),h.lineTo(o,o),h.stroke(),h.beginPath(),h.moveTo(o,-o),h.lineTo(-o,o),h.stroke(),h.restore(),_.adapter.css(_.closeButtonElement,{left:""+(s[0]-o-_.options.closeButtonLinkOverscan)+"px",top:""+(s[1]-o-_.options.closeButtonLinkOverscan)+"px",width:""+(_.options.closeButtonCrossSize+_.options.closeButtonLinkOverscan*2)+"px",height:""+(_.options.closeButtonCrossSize+_.options.closeButtonLinkOverscan*2)+"px"})}():void 0}},t.prototype._getPathStemMeasures=function(t,e,i){var o,s,n,r,a,h,p;if(r=i/2,n=Math.atan(t/2/e),o=n*2,a=r/Math.sin(o),s=2*a*Math.cos(n),p=r+e-s,0>p)throw Error("Sorry but your stemLength / stemBase ratio is strange.");return h=Math.tan(n)*p*2,{stemLength:p,stemBase:h}},t.prototype._getColor=function(t,e,i,o){var s,n,r,a,h;if(o==null&&(o=!1),typeof i=="string")return i;for(n=o?t.createLinearGradient(0,0,e.width,0):t.createLinearGradient(0,0,0,e.height),r=a=0,h=i.length;h>a;r=++a)s=i[r],n.addColorStop(s[0],s[1]);return n},t.prototype._searchAndActivateCloseButtons=function(){var t,e,i,o;for(o=this.adapter.findAll(this.container,"."+this["class"].close),e=0,i=o.length;i>e;e++)t=o[e],this.hideTriggers.push({element:this.adapter.wrap(t),event:"click"});return this.currentObservers.showing&&this._setupObservers("-showing","showing"),this.currentObservers.visible?this._setupObservers("-visible","visible"):void 0},t.prototype._activateFirstInput=function(){var t;return t=this.adapter.unwrap(this.adapter.find(this.container,"input, textarea")),t!=null?typeof t.focus=="function"?t.focus():void 0:void 0},t.prototype._followMousePosition=function(){return this.options.fixed?void 0:t._observeMousePosition(this.bound.reposition)},t.prototype._stopFollowingMousePosition=function(){return this.options.fixed?void 0:t._stopObservingMousePosition(this.bound.reposition)},t.prototype._clearShowTimeout=function(){return clearTimeout(this._showTimeoutId)},t.prototype._clearHideTimeout=function(){return clearTimeout(this._hideTimeoutId)},t.prototype._clearTimeouts=function(){return clearTimeout(this._visibilityStateTimeoutId),this._clearShowTimeout(),this._clearHideTimeout()},t.prototype._triggerElementExists=function(){var t;t=this.adapter.unwrap(this.triggerElement);while(t.parentNode){if(t.parentNode.tagName==="BODY")return!0;t=t.parentNode}return!1},t.prototype._loadAjax=function(){var t=this;if(!this.loading)return this.loaded=!1,this.loading=!0,this.adapter.addClass(this.container,this["class"].loading),this.setContent(""),this.debug("Loading content from "+this.options.ajax),this.adapter.ajax({url:this.options.ajax,method:this.options.ajaxMethod,onSuccess:function(e){return t.debug("Loading successful."),t.adapter.removeClass(t.container,t["class"].loading),t.setContent(e)},onError:function(e){var i;return i=t.options.ajaxErrorMessage,t.debug(i,e),t.setContent(i),t.adapter.addClass(t.container,t["class"].ajaxError)},onComplete:function(){return t.adapter.removeClass(t.container,t["class"].loading),t.loading=!1,t.loaded=!0,t._searchAndActivateCloseButtons(),t._activateFirstInput(),t.reposition()}})},t.prototype._ensureTriggerElement=function(){return this._triggerElementExists()?void 0:(this.deactivate(),this._stopEnsureTriggerElement())},t.prototype._ensureTriggerElementInterval=1e3,t.prototype._startEnsureTriggerElement=function(){var t=this;return this._ensureTriggerElementTimeoutId=setInterval(function(){return t._ensureTriggerElement()},this._ensureTriggerElementInterval)},t.prototype._stopEnsureTriggerElement=function(){return clearInterval(this._ensureTriggerElementTimeoutId)},t}(),vendors=["khtml","ms","o","moz","webkit"],Opentip.prototype.setCss3Style=function(t,e){var i,o,s,n,r;t=this.adapter.unwrap(t),r=[];for(i in e)__hasProp.call(e,i)&&(o=e[i],t.style[i]!=null?r.push(t.style[i]=o):r.push(function(){var e,r,a;for(a=[],e=0,r=vendors.length;r>e;e++)s=vendors[e],n=""+this.ucfirst(s)+this.ucfirst(i),t.style[n]!=null?a.push(t.style[n]=o):a.push(void 0);return a}.call(this)));return r},Opentip.prototype.defer=function(t){return setTimeout(t,0)},Opentip.prototype.setTimeout=function(t,e){return setTimeout(t,e?e*1e3:0)},Opentip.prototype.ucfirst=function(t){return t==null?"":t.charAt(0).toUpperCase()+t.slice(1)},Opentip.prototype.dasherize=function(t){return t.replace(/([A-Z])/g,function(t,e){return"-"+e.toLowerCase()})},mousePositionObservers=[],mousePosition={x:0,y:0},mouseMoved=function(t){var e,i,o,s;for(mousePosition=Opentip.adapter.mousePosition(t),s=[],i=0,o=mousePositionObservers.length;o>i;i++)e=mousePositionObservers[i],s.push(e());return s},Opentip.followMousePosition=function(){return Opentip.adapter.observe(document.body,"mousemove",mouseMoved)},Opentip._observeMousePosition=function(t){return mousePositionObservers.push(t)},Opentip._stopObservingMousePosition=function(t){var e;return mousePositionObservers=function(){var i,o,s;for(s=[],i=0,o=mousePositionObservers.length;o>i;i++)e=mousePositionObservers[i],e!==t&&s.push(e);return s}()},Opentip.Joint=function(){function t(t){t!=null&&(t instanceof Opentip.Joint&&(t+=""),this.set(t))}return t.prototype.set=function(t){return t=t.toLowerCase(),this.setHorizontal(t),this.setVertical(t),this},t.prototype.setHorizontal=function(t){var e,i,o,s,n,r,a;for(i=["left","center","right"],o=0,n=i.length;n>o;o++)e=i[o],~t.indexOf(e)&&(this.horizontal=e.toLowerCase());for(this.horizontal==null&&(this.horizontal="center"),a=[],s=0,r=i.length;r>s;s++)e=i[s],a.push(this[e]=this.horizontal===e?e:void 0);return a},t.prototype.setVertical=function(t){var e,i,o,s,n,r,a;for(i=["top","middle","bottom"],o=0,n=i.length;n>o;o++)e=i[o],~t.indexOf(e)&&(this.vertical=e.toLowerCase());for(this.vertical==null&&(this.vertical="middle"),a=[],s=0,r=i.length;r>s;s++)e=i[s],a.push(this[e]=this.vertical===e?e:void 0);return a},t.prototype.eql=function(t){return t!=null&&this.horizontal===t.horizontal&&this.vertical===t.vertical},t.prototype.flip=function(){var t,e;return e=Opentip.position[this.toString(!0)],t=(e+4)%8,this.set(Opentip.positions[t]),this},t.prototype.toString=function(t){var e,i;return t==null&&(t=!1),i=this.vertical==="middle"?"":this.vertical,e=this.horizontal==="center"?"":this.horizontal,i&&e&&(e=t?Opentip.prototype.ucfirst(e):" "+e),""+i+e},t}(),Opentip.prototype._positionsEqual=function(t,e){return t!=null&&e!=null&&t.left===e.left&&t.top===e.top},Opentip.prototype._dimensionsEqual=function(t,e){return t!=null&&e!=null&&t.width===e.width&&t.height===e.height},Opentip.prototype.debug=function(){var t;return t=arguments.length>=1?__slice.call(arguments,0):[],Opentip.debug&&(typeof console!="undefined"&&console!==null?console.debug:void 0)!=null?(t.unshift("#"+this.id+" |"),console.debug.apply(console,t)):void 0},Opentip.findElements=function(){var t,e,i,o,s,n,r,a,h,p;for(t=Opentip.adapter,h=t.findAll(document.body,"[data-ot]"),p=[],r=0,a=h.length;a>r;r++){i=h[r],n={},e=t.data(i,"ot"),(e===""||e==="true"||e==="yes")&&(e=t.attr(i,"title"),t.attr(i,"title","")),e=e||"";for(o in Opentip.styles.standard)s=t.data(i,"ot"+Opentip.prototype.ucfirst(o)),s!=null&&(s==="yes"||s==="true"||s==="on"?s=!0:(s==="no"||s==="false"||s==="off")&&(s=!1),n[o]=s);p.push(new Opentip(i,e,n))}return p},Opentip.version="2.4.6",Opentip.debug=!1,Opentip.lastId=0,Opentip.lastZIndex=100,Opentip.tips=[],Opentip._abortShowingGroup=function(t,e){var i,o,s,n,r;for(n=Opentip.tips,r=[],o=0,s=n.length;s>o;o++)i=n[o],i!==e&&i.options.group===t?r.push(i._abortShowing()):r.push(void 0);return r},Opentip._hideGroup=function(t,e){var i,o,s,n,r;for(n=Opentip.tips,r=[],o=0,s=n.length;s>o;o++)i=n[o],i!==e&&i.options.group===t?r.push(i.hide()):r.push(void 0);return r},Opentip.adapters={},Opentip.adapter=null,firstAdapter=!0,Opentip.addAdapter=function(t){return Opentip.adapters[t.name]=t,firstAdapter?(Opentip.adapter=t,t.domReady(Opentip.findElements),t.domReady(Opentip.followMousePosition),firstAdapter=!1):void 0},Opentip.positions=["top","topRight","right","bottomRight","bottom","bottomLeft","left","topLeft"],Opentip.position={},_ref=Opentip.positions,i=_i=0,_len=_ref.length;_len>_i;i=++_i)position=_ref[i],Opentip.position[position]=i;Opentip.styles={standard:{"extends":null,title:void 0,escapeTitle:!0,escapeContent:!1,className:"standard",stem:!0,delay:null,hideDelay:.1,fixed:!1,showOn:"mouseover",hideTrigger:"trigger",hideTriggers:[],hideOn:null,removeElementsOnHide:!1,offset:[0,0],containInViewport:!0,autoOffset:!0,showEffect:"appear",hideEffect:"fade",showEffectDuration:.3,hideEffectDuration:.2,stemLength:5,stemBase:8,tipJoint:"top left",target:null,targetJoint:null,cache:!0,ajax:!1,ajaxMethod:"GET",ajaxErrorMessage:"There was a problem downloading the content.",group:null,style:null,background:"#fff18f",backgroundGradientHorizontal:!1,closeButtonOffset:[5,5],closeButtonRadius:7,closeButtonCrossSize:4,closeButtonCrossColor:"#d2c35b",closeButtonCrossLineWidth:1.5,closeButtonLinkOverscan:6,borderRadius:5,borderWidth:1,borderColor:"#f2e37b",shadow:!0,shadowBlur:10,shadowOffset:[3,3],shadowColor:"rgba(0, 0, 0, 0.1)"},glass:{"extends":"standard",className:"glass",background:[[0,"rgba(252, 252, 252, 0.8)"],[.5,"rgba(255, 255, 255, 0.8)"],[.5,"rgba(250, 250, 250, 0.9)"],[1,"rgba(245, 245, 245, 0.9)"]],borderColor:"#eee",closeButtonCrossColor:"rgba(0, 0, 0, 0.2)",borderRadius:15,closeButtonRadius:10,closeButtonOffset:[8,8]},dark:{"extends":"standard",className:"dark",borderRadius:13,borderColor:"#444",closeButtonCrossColor:"rgba(240, 240, 240, 1)",shadowColor:"rgba(0, 0, 0, 0.3)",shadowOffset:[2,2],background:[[0,"rgba(30, 30, 30, 0.7)"],[.5,"rgba(30, 30, 30, 0.8)"],[.5,"rgba(10, 10, 10, 0.8)"],[1,"rgba(10, 10, 10, 0.9)"]]},alert:{"extends":"standard",className:"alert",borderRadius:1,borderColor:"#AE0D11",closeButtonCrossColor:"rgba(255, 255, 255, 1)",shadowColor:"rgba(0, 0, 0, 0.3)",shadowOffset:[2,2],background:[[0,"rgba(203, 15, 19, 0.7)"],[.5,"rgba(203, 15, 19, 0.8)"],[.5,"rgba(189, 14, 18, 0.8)"],[1,"rgba(179, 14, 17, 0.9)"]]}},Opentip.defaultStyle="standard",typeof module!="undefined"&&module!==null?module.exports=Opentip:window.Opentip=Opentip;var __slice=[].slice;(function(t){var e;return t.fn.opentip=function(t,e,i){return new Opentip(this,t,e,i)},e=function(){function e(){}return e.prototype.name="jquery",e.prototype.domReady=function(e){return t(e)},e.prototype.create=function(e){return t(e)},e.prototype.wrap=function(e){if(e=t(e),e.length>1)throw Error("Multiple elements provided.");return e},e.prototype.unwrap=function(e){return t(e)[0]
+},e.prototype.tagName=function(t){return this.unwrap(t).tagName},e.prototype.attr=function(){var e,i,o;return i=arguments[0],e=arguments.length>=2?__slice.call(arguments,1):[],(o=t(i)).attr.apply(o,e)},e.prototype.data=function(){var e,i,o;return i=arguments[0],e=arguments.length>=2?__slice.call(arguments,1):[],(o=t(i)).data.apply(o,e)},e.prototype.find=function(e,i){return t(e).find(i).get(0)},e.prototype.findAll=function(e,i){return t(e).find(i)},e.prototype.update=function(e,i,o){return e=t(e),o?e.text(i):e.html(i)},e.prototype.append=function(e,i){return t(e).append(i)},e.prototype.remove=function(e){return t(e).remove()},e.prototype.addClass=function(e,i){return t(e).addClass(i)},e.prototype.removeClass=function(e,i){return t(e).removeClass(i)},e.prototype.css=function(e,i){return t(e).css(i)},e.prototype.dimensions=function(e){return{width:t(e).outerWidth(),height:t(e).outerHeight()}},e.prototype.scrollOffset=function(){return[window.pageXOffset||document.documentElement.scrollLeft||document.body.scrollLeft,window.pageYOffset||document.documentElement.scrollTop||document.body.scrollTop]},e.prototype.viewportDimensions=function(){return{width:document.documentElement.clientWidth,height:document.documentElement.clientHeight}},e.prototype.mousePosition=function(t){return t==null?null:{x:t.pageX,y:t.pageY}},e.prototype.offset=function(e){var i;return i=t(e).offset(),{left:i.left,top:i.top}},e.prototype.observe=function(e,i,o){return t(e).bind(i,o)},e.prototype.stopObserving=function(e,i,o){return t(e).unbind(i,o)},e.prototype.ajax=function(e){var i,o;if(e.url==null)throw Error("No url provided");return t.ajax({url:e.url,type:(i=(o=e.method)!=null?o.toUpperCase():void 0)!=null?i:"GET"}).done(function(t){return typeof e.onSuccess=="function"?e.onSuccess(t):void 0}).fail(function(t){return typeof e.onError=="function"?e.onError("Server responded with status "+t.status):void 0}).always(function(){return typeof e.onComplete=="function"?e.onComplete():void 0})},e.prototype.clone=function(e){return t.extend({},e)},e.prototype.extend=function(){var e,i;return i=arguments[0],e=arguments.length>=2?__slice.call(arguments,1):[],t.extend.apply(t,[i].concat(__slice.call(e)))},e}(),Opentip.addAdapter(new e)})(jQuery)});
\ No newline at end of file
diff --git "[FORUM_EXT]/vse\\topicimagepreview/styles/BBOOTS/theme/opentip.css" "[FORUM_EXT]/vse\\topicimagepreview/styles/BBOOTS/theme/opentip.css"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/vse\\topicimagepreview/styles/BBOOTS/theme/opentip.css"
@@ -0,0 +1,278 @@
+.opentip-container,
+.opentip-container * {
+  -webkit-box-sizing: border-box;
+  -moz-box-sizing: border-box;
+  box-sizing: border-box;
+}
+.opentip-container {
+  position: absolute;
+  max-width: 300px;
+  z-index: 100;
+  -webkit-transition: -webkit-transform 1s ease-in-out;
+  -moz-transition: -moz-transform 1s ease-in-out;
+  -o-transition: -o-transform 1s ease-in-out;
+  -ms-transition: -ms-transform 1s ease-in-out;
+  transition: transform 1s ease-in-out;
+  pointer-events: none;
+  -webkit-transform: translateX(0) translateY(0);
+  -moz-transform: translateX(0) translateY(0);
+  -o-transform: translateX(0) translateY(0);
+  -ms-transform: translateX(0) translateY(0);
+  transform: translateX(0) translateY(0);
+}
+.opentip-container.ot-fixed.ot-hidden.stem-top.stem-center,
+.opentip-container.ot-fixed.ot-going-to-show.stem-top.stem-center,
+.opentip-container.ot-fixed.ot-hiding.stem-top.stem-center {
+  -webkit-transform: translateY(-5px);
+  -moz-transform: translateY(-5px);
+  -o-transform: translateY(-5px);
+  -ms-transform: translateY(-5px);
+  transform: translateY(-5px);
+}
+.opentip-container.ot-fixed.ot-hidden.stem-top.stem-right,
+.opentip-container.ot-fixed.ot-going-to-show.stem-top.stem-right,
+.opentip-container.ot-fixed.ot-hiding.stem-top.stem-right {
+  -webkit-transform: translateY(-5px) translateX(5px);
+  -moz-transform: translateY(-5px) translateX(5px);
+  -o-transform: translateY(-5px) translateX(5px);
+  -ms-transform: translateY(-5px) translateX(5px);
+  transform: translateY(-5px) translateX(5px);
+}
+.opentip-container.ot-fixed.ot-hidden.stem-middle.stem-right,
+.opentip-container.ot-fixed.ot-going-to-show.stem-middle.stem-right,
+.opentip-container.ot-fixed.ot-hiding.stem-middle.stem-right {
+  -webkit-transform: translateX(5px);
+  -moz-transform: translateX(5px);
+  -o-transform: translateX(5px);
+  -ms-transform: translateX(5px);
+  transform: translateX(5px);
+}
+.opentip-container.ot-fixed.ot-hidden.stem-bottom.stem-right,
+.opentip-container.ot-fixed.ot-going-to-show.stem-bottom.stem-right,
+.opentip-container.ot-fixed.ot-hiding.stem-bottom.stem-right {
+  -webkit-transform: translateY(5px) translateX(5px);
+  -moz-transform: translateY(5px) translateX(5px);
+  -o-transform: translateY(5px) translateX(5px);
+  -ms-transform: translateY(5px) translateX(5px);
+  transform: translateY(5px) translateX(5px);
+}
+.opentip-container.ot-fixed.ot-hidden.stem-bottom.stem-center,
+.opentip-container.ot-fixed.ot-going-to-show.stem-bottom.stem-center,
+.opentip-container.ot-fixed.ot-hiding.stem-bottom.stem-center {
+  -webkit-transform: translateY(5px);
+  -moz-transform: translateY(5px);
+  -o-transform: translateY(5px);
+  -ms-transform: translateY(5px);
+  transform: translateY(5px);
+}
+.opentip-container.ot-fixed.ot-hidden.stem-bottom.stem-left,
+.opentip-container.ot-fixed.ot-going-to-show.stem-bottom.stem-left,
+.opentip-container.ot-fixed.ot-hiding.stem-bottom.stem-left {
+  -webkit-transform: translateY(5px) translateX(-5px);
+  -moz-transform: translateY(5px) translateX(-5px);
+  -o-transform: translateY(5px) translateX(-5px);
+  -ms-transform: translateY(5px) translateX(-5px);
+  transform: translateY(5px) translateX(-5px);
+}
+.opentip-container.ot-fixed.ot-hidden.stem-middle.stem-left,
+.opentip-container.ot-fixed.ot-going-to-show.stem-middle.stem-left,
+.opentip-container.ot-fixed.ot-hiding.stem-middle.stem-left {
+  -webkit-transform: translateX(-5px);
+  -moz-transform: translateX(-5px);
+  -o-transform: translateX(-5px);
+  -ms-transform: translateX(-5px);
+  transform: translateX(-5px);
+}
+.opentip-container.ot-fixed.ot-hidden.stem-top.stem-left,
+.opentip-container.ot-fixed.ot-going-to-show.stem-top.stem-left,
+.opentip-container.ot-fixed.ot-hiding.stem-top.stem-left {
+  -webkit-transform: translateY(-5px) translateX(-5px);
+  -moz-transform: translateY(-5px) translateX(-5px);
+  -o-transform: translateY(-5px) translateX(-5px);
+  -ms-transform: translateY(-5px) translateX(-5px);
+  transform: translateY(-5px) translateX(-5px);
+}
+.opentip-container.ot-fixed .opentip {
+  pointer-events: auto;
+}
+.opentip-container.ot-hidden {
+  display: none;
+}
+.opentip-container .opentip {
+  position: relative;
+  font-size: 13px;
+  line-height: 120%;
+  padding: 9px 14px;
+  color: #4f4b47;
+  text-shadow: -1px -1px 0px rgba(255,255,255,0.2);
+}
+.opentip-container .opentip .header {
+  margin: 0;
+  padding: 0;
+}
+.opentip-container .opentip .ot-close {
+  pointer-events: auto;
+  display: block;
+  position: absolute;
+  top: -12px;
+  left: 60px;
+  color: rgba(0,0,0,0.5);
+  background: rgba(0,0,0,0);
+  text-decoration: none;
+}
+.opentip-container .opentip .ot-close span {
+  display: none;
+}
+.opentip-container .opentip .ot-loading-indicator {
+  display: none;
+}
+.opentip-container.ot-loading .ot-loading-indicator {
+  width: 30px;
+  height: 30px;
+  font-size: 30px;
+  line-height: 30px;
+  font-weight: bold;
+  display: block;
+}
+.opentip-container.ot-loading .ot-loading-indicator span {
+  display: block;
+  -webkit-animation: otloading 2s linear infinite;
+  -moz-animation: otloading 2s linear infinite;
+  -o-animation: otloading 2s linear infinite;
+  -ms-animation: otloading 2s linear infinite;
+  animation: otloading 2s linear infinite;
+  text-align: center;
+}
+.opentip-container.style-dark .opentip,
+.opentip-container.style-alert .opentip {
+  color: #f8f8f8;
+  text-shadow: 1px 1px 0px rgba(0,0,0,0.2);
+}
+.opentip-container.style-glass .opentip {
+  padding: 15px 25px;
+  color: #317cc5;
+  text-shadow: 1px 1px 8px rgba(0,94,153,0.3);
+}
+.opentip-container.ot-hide-effect-fade {
+  -webkit-transition: -webkit-transform 0.5s ease-in-out, opacity 1s ease-in-out;
+  -moz-transition: -moz-transform 0.5s ease-in-out, opacity 1s ease-in-out;
+  -o-transition: -o-transform 0.5s ease-in-out, opacity 1s ease-in-out;
+  -ms-transition: -ms-transform 0.5s ease-in-out, opacity 1s ease-in-out;
+  transition: transform 0.5s ease-in-out, opacity 1s ease-in-out;
+  opacity: 1;
+  -ms-filter: none;
+  filter: none;
+}
+.opentip-container.ot-hide-effect-fade.ot-hiding {
+  opacity: 0;
+  filter: alpha(opacity=0);
+  -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";
+}
+.opentip-container.ot-show-effect-appear.ot-going-to-show,
+.opentip-container.ot-show-effect-appear.ot-showing {
+  -webkit-transition: -webkit-transform 0.5s ease-in-out, opacity 1s ease-in-out;
+  -moz-transition: -moz-transform 0.5s ease-in-out, opacity 1s ease-in-out;
+  -o-transition: -o-transform 0.5s ease-in-out, opacity 1s ease-in-out;
+  -ms-transition: -ms-transform 0.5s ease-in-out, opacity 1s ease-in-out;
+  transition: transform 0.5s ease-in-out, opacity 1s ease-in-out;
+}
+.opentip-container.ot-show-effect-appear.ot-going-to-show {
+  opacity: 0;
+  filter: alpha(opacity=0);
+  -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";
+}
+.opentip-container.ot-show-effect-appear.ot-showing {
+  opacity: 1;
+  -ms-filter: none;
+  filter: none;
+}
+.opentip-container.ot-show-effect-appear.ot-visible {
+  opacity: 1;
+  -ms-filter: none;
+  filter: none;
+}
+@-moz-keyframes otloading {
+  0% {
+    -webkit-transform: rotate(0deg);
+    -moz-transform: rotate(0deg);
+    -o-transform: rotate(0deg);
+    -ms-transform: rotate(0deg);
+    transform: rotate(0deg);
+  }
+
+  100% {
+    -webkit-transform: rotate(360deg);
+    -moz-transform: rotate(360deg);
+    -o-transform: rotate(360deg);
+    -ms-transform: rotate(360deg);
+    transform: rotate(360deg);
+  }
+}
+@-webkit-keyframes otloading {
+  0% {
+    -webkit-transform: rotate(0deg);
+    -moz-transform: rotate(0deg);
+    -o-transform: rotate(0deg);
+    -ms-transform: rotate(0deg);
+    transform: rotate(0deg);
+  }
+
+  100% {
+    -webkit-transform: rotate(360deg);
+    -moz-transform: rotate(360deg);
+    -o-transform: rotate(360deg);
+    -ms-transform: rotate(360deg);
+    transform: rotate(360deg);
+  }
+}
+@-o-keyframes otloading {
+  0% {
+    -webkit-transform: rotate(0deg);
+    -moz-transform: rotate(0deg);
+    -o-transform: rotate(0deg);
+    -ms-transform: rotate(0deg);
+    transform: rotate(0deg);
+  }
+
+  100% {
+    -webkit-transform: rotate(360deg);
+    -moz-transform: rotate(360deg);
+    -o-transform: rotate(360deg);
+    -ms-transform: rotate(360deg);
+    transform: rotate(360deg);
+  }
+}
+@-ms-keyframes otloading {
+  0% {
+    -webkit-transform: rotate(0deg);
+    -moz-transform: rotate(0deg);
+    -o-transform: rotate(0deg);
+    -ms-transform: rotate(0deg);
+    transform: rotate(0deg);
+  }
+
+  100% {
+    -webkit-transform: rotate(360deg);
+    -moz-transform: rotate(360deg);
+    -o-transform: rotate(360deg);
+    -ms-transform: rotate(360deg);
+    transform: rotate(360deg);
+  }
+}
+@keyframes otloading {
+  0% {
+    -webkit-transform: rotate(0deg);
+    -moz-transform: rotate(0deg);
+    -o-transform: rotate(0deg);
+    -ms-transform: rotate(0deg);
+    transform: rotate(0deg);
+  }
+
+  100% {
+    -webkit-transform: rotate(360deg);
+    -moz-transform: rotate(360deg);
+    -o-transform: rotate(360deg);
+    -ms-transform: rotate(360deg);
+    transform: rotate(360deg);
+  }
+}
diff --git "[FORUM_EXT]/vse\\topicimagepreview/styles/FLATBOOTS/template/event/overall_footer_after.html" "[FORUM_EXT]/vse\\topicimagepreview/styles/FLATBOOTS/template/event/overall_footer_after.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/vse\\topicimagepreview/styles/FLATBOOTS/template/event/overall_footer_after.html"
@@ -0,0 +1,14 @@
+{% if S_TOPIC_IMAGE_PREVIEW %}
+	{% if not definition.INCLUDED_OPENTIPJS %}
+		{% INCLUDEJS '@vse_topicimagepreview/js/opentip-jquery.min.js' %}
+		{% DEFINE INCLUDED_OPENTIPJS = true %}
+	{% endif %}
+
+	<script>
+		head.ready(function () {
+			$(function() {
+				$("[data-ot]").closest("dt").removeAttr("title");
+			});
+		});
+	</script>
+{% endif %}
\ No newline at end of file
diff --git "[FORUM_EXT]/vse\\topicimagepreview/styles/FLATBOOTS/template/event/overall_header_stylesheets_after.html" "[FORUM_EXT]/vse\\topicimagepreview/styles/FLATBOOTS/template/event/overall_header_stylesheets_after.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/vse\\topicimagepreview/styles/FLATBOOTS/template/event/overall_header_stylesheets_after.html"
@@ -0,0 +1,14 @@
+{% if S_TOPIC_IMAGE_PREVIEW %}
+	{% INCLUDECSS '@vse_topicimagepreview/opentip.css' %}
+	<style>
+		.opentip-container {
+			max-width: 1000px;
+			white-space: nowrap;
+		}
+		.ot-content > img {
+			max-width: {{ TOPIC_IMAGE_PREVIEW_DIM_MAX }}px;
+			max-height: {{ TOPIC_IMAGE_PREVIEW_DIM_MAX }}px;
+			vertical-align: top;
+		}
+	</style>
+{% endif %}
diff --git "[FORUM_EXT]/vse\\topicimagepreview/styles/FLATBOOTS/template/event/topiclist_row_prepend.html" "[FORUM_EXT]/vse\\topicimagepreview/styles/FLATBOOTS/template/event/topiclist_row_prepend.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/vse\\topicimagepreview/styles/FLATBOOTS/template/event/topiclist_row_prepend.html"
@@ -0,0 +1,23 @@
+{# display in view forum #}
+{% if topicrow.TOPIC_IMAGES %}
+	{% set preview = topicrow %}
+{% endif %}
+
+{# display in search results #}
+{% if searchresults.TOPIC_IMAGES %}
+	{% set preview = searchresults %}
+{% endif %}
+
+{# display in Similar Topics extension #}
+{% if similar.TOPIC_IMAGES %}
+	{% set preview = similar %}
+{% endif %}
+
+<span{% if preview.TOPIC_IMAGES %}
+	data-ot="{% for image in preview.TOPIC_IMAGES %}<img src='/forum/app.php/gallery/image/{{ image }}/source' alt='{{ lang('IMAGE') }}' style='max-width:{preview.TOPIC_IMAGES_SIZE_MAX}px; max-height:{preview.TOPIC_IMAGES_SIZE_MAX}px;'>&nbsp;{% endfor %}"
+	data-ot-group="topics"
+	data-ot-background="transparent"
+	data-ot-border-width="0"
+	data-ot-border-radius="0"{% endif %}>
+{% if preview.TOPIC_IMAGES %}<div style="float:left;padding-right:10px;">{% for image in preview.TOPIC_IMAGES %}<img src="/forum/app.php/gallery/image/{{ image }}/mini" alt="{{ lang('IMAGE') }}" style="max-width:{preview.TOPIC_IMAGES_SIZE_MIN}px; max-height:{preview.TOPIC_IMAGES_SIZE_MIN}px;">&nbsp;{% endfor %}</div>{% endif %}
+</span>
diff --git "[FORUM_EXT]/vse\\topicimagepreview/styles/FLATBOOTS/template/event/ucp_prefs_view_radio_buttons_append.html" "[FORUM_EXT]/vse\\topicimagepreview/styles/FLATBOOTS/template/event/ucp_prefs_view_radio_buttons_append.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/vse\\topicimagepreview/styles/FLATBOOTS/template/event/ucp_prefs_view_radio_buttons_append.html"
@@ -0,0 +1,9 @@
+{% if S_VSE_TIP_NUM %}
+	<dl>
+		<dt><label for="user_vse_tip1">{{ lang('DISPLAY_TOPIC_IMAGE_PREVIEWS') ~ lang('COLON') }}</label></dt>
+		<dd>
+			<label for="user_vse_tip1"><input type="radio" name="user_vse_tip" id="user_vse_tip1" value="1"{% if S_VSE_TIP_USER %} checked="checked"{% endif %} /> {{ lang('YES') }}</label>
+			<label for="user_vse_tip0"><input type="radio" name="user_vse_tip" id="user_vse_tip0" value="0"{% if not S_VSE_TIP_USER %} checked="checked"{% endif %} /> {{ lang('NO') }}</label>
+		</dd>
+	</dl>
+{% endif %}
diff --git "[FORUM_EXT]/vse\\topicimagepreview/styles/FLATBOOTS/template/js/opentip-jquery.js" "[FORUM_EXT]/vse\\topicimagepreview/styles/FLATBOOTS/template/js/opentip-jquery.js"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/vse\\topicimagepreview/styles/FLATBOOTS/template/js/opentip-jquery.js"
@@ -0,0 +1,1794 @@
+// Generated by CoffeeScript 1.4.0
+/*
+#
+# Opentip v2.4.6
+#
+# More info at [www.opentip.org](http://www.opentip.org)
+# 
+# Copyright (c) 2012, Matias Meno  
+# Graphics by Tjandra Mayerhold
+# 
+# Permission is hereby granted, free of charge, to any person obtaining a copy
+# of this software and associated documentation files (the "Software"), to deal
+# in the Software without restriction, including without limitation the rights
+# to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
+# copies of the Software, and to permit persons to whom the Software is
+# furnished to do so, subject to the following conditions:
+# 
+# The above copyright notice and this permission notice shall be included in
+# all copies or substantial portions of the Software.
+# 
+# THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
+# IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
+# FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
+# AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
+# LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
+# OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
+# THE SOFTWARE.
+#
+*/
+head.ready(function () {
+var Opentip, firstAdapter, i, mouseMoved, mousePosition, mousePositionObservers, position, vendors, _i, _len, _ref,
+  __slice = [].slice,
+  __indexOf = [].indexOf || function(item) { for (var i = 0, l = this.length; i < l; i++) { if (i in this && this[i] === item) return i; } return -1; },
+  __hasProp = {}.hasOwnProperty;
+
+Opentip = (function() {
+
+  Opentip.prototype.STICKS_OUT_TOP = 1;
+
+  Opentip.prototype.STICKS_OUT_BOTTOM = 2;
+
+  Opentip.prototype.STICKS_OUT_LEFT = 1;
+
+  Opentip.prototype.STICKS_OUT_RIGHT = 2;
+
+  Opentip.prototype["class"] = {
+    container: "opentip-container",
+    opentip: "opentip",
+    header: "ot-header",
+    content: "ot-content",
+    loadingIndicator: "ot-loading-indicator",
+    close: "ot-close",
+    goingToHide: "ot-going-to-hide",
+    hidden: "ot-hidden",
+    hiding: "ot-hiding",
+    goingToShow: "ot-going-to-show",
+    showing: "ot-showing",
+    visible: "ot-visible",
+    loading: "ot-loading",
+    ajaxError: "ot-ajax-error",
+    fixed: "ot-fixed",
+    showEffectPrefix: "ot-show-effect-",
+    hideEffectPrefix: "ot-hide-effect-",
+    stylePrefix: "style-"
+  };
+
+  function Opentip(element, content, title, options) {
+    var elementsOpentips, hideTrigger, methodToBind, optionSources, prop, styleName, _i, _j, _len, _len1, _ref, _ref1, _ref2, _tmpStyle,
+      _this = this;
+    this.id = ++Opentip.lastId;
+    this.debug("Creating Opentip.");
+    Opentip.tips.push(this);
+    this.adapter = Opentip.adapter;
+    elementsOpentips = this.adapter.data(element, "opentips") || [];
+    elementsOpentips.push(this);
+    this.adapter.data(element, "opentips", elementsOpentips);
+    this.triggerElement = this.adapter.wrap(element);
+    if (this.triggerElement.length > 1) {
+      throw new Error("You can't call Opentip on multiple elements.");
+    }
+    if (this.triggerElement.length < 1) {
+      throw new Error("Invalid element.");
+    }
+    this.loaded = false;
+    this.loading = false;
+    this.visible = false;
+    this.waitingToShow = false;
+    this.waitingToHide = false;
+    this.currentPosition = {
+      left: 0,
+      top: 0
+    };
+    this.dimensions = {
+      width: 100,
+      height: 50
+    };
+    this.content = "";
+    this.redraw = true;
+    this.currentObservers = {
+      showing: false,
+      visible: false,
+      hiding: false,
+      hidden: false
+    };
+    options = this.adapter.clone(options);
+    if (typeof content === "object") {
+      options = content;
+      content = title = void 0;
+    } else if (typeof title === "object") {
+      options = title;
+      title = void 0;
+    }
+    if (title != null) {
+      options.title = title;
+    }
+    if (content != null) {
+      this.setContent(content);
+    }
+    if (options["extends"] == null) {
+      if (options.style != null) {
+        options["extends"] = options.style;
+      } else {
+        options["extends"] = Opentip.defaultStyle;
+      }
+    }
+    optionSources = [options];
+    _tmpStyle = options;
+    while (_tmpStyle["extends"]) {
+      styleName = _tmpStyle["extends"];
+      _tmpStyle = Opentip.styles[styleName];
+      if (_tmpStyle == null) {
+        throw new Error("Invalid style: " + styleName);
+      }
+      optionSources.unshift(_tmpStyle);
+      if (!((_tmpStyle["extends"] != null) || styleName === "standard")) {
+        _tmpStyle["extends"] = "standard";
+      }
+    }
+    options = (_ref = this.adapter).extend.apply(_ref, [{}].concat(__slice.call(optionSources)));
+    options.hideTriggers = (function() {
+      var _i, _len, _ref1, _results;
+      _ref1 = options.hideTriggers;
+      _results = [];
+      for (_i = 0, _len = _ref1.length; _i < _len; _i++) {
+        hideTrigger = _ref1[_i];
+        _results.push(hideTrigger);
+      }
+      return _results;
+    })();
+    if (options.hideTrigger && options.hideTriggers.length === 0) {
+      options.hideTriggers.push(options.hideTrigger);
+    }
+    _ref1 = ["tipJoint", "targetJoint", "stem"];
+    for (_i = 0, _len = _ref1.length; _i < _len; _i++) {
+      prop = _ref1[_i];
+      if (options[prop] && typeof options[prop] === "string") {
+        options[prop] = new Opentip.Joint(options[prop]);
+      }
+    }
+    if (options.ajax && (options.ajax === true || !options.ajax)) {
+      if (this.adapter.tagName(this.triggerElement) === "A") {
+        options.ajax = this.adapter.attr(this.triggerElement, "href");
+      } else {
+        options.ajax = false;
+      }
+    }
+    if (options.showOn === "click" && this.adapter.tagName(this.triggerElement) === "A") {
+      this.adapter.observe(this.triggerElement, "click", function(e) {
+        e.preventDefault();
+        e.stopPropagation();
+        return e.stopped = true;
+      });
+    }
+    if (options.target) {
+      options.fixed = true;
+    }
+    if (options.stem === true) {
+      options.stem = new Opentip.Joint(options.tipJoint);
+    }
+    if (options.target === true) {
+      options.target = this.triggerElement;
+    } else if (options.target) {
+      options.target = this.adapter.wrap(options.target);
+    }
+    this.currentStem = options.stem;
+    if (options.delay == null) {
+      options.delay = options.showOn === "mouseover" ? 0.2 : 0;
+    }
+    if (options.targetJoint == null) {
+      options.targetJoint = new Opentip.Joint(options.tipJoint).flip();
+    }
+    this.showTriggers = [];
+    this.showTriggersWhenVisible = [];
+    this.hideTriggers = [];
+    if (options.showOn && options.showOn !== "creation") {
+      this.showTriggers.push({
+        element: this.triggerElement,
+        event: options.showOn
+      });
+    }
+    if (options.ajaxCache != null) {
+      options.cache = options.ajaxCache;
+      delete options.ajaxCache;
+    }
+    this.options = options;
+    this.bound = {};
+    _ref2 = ["prepareToShow", "prepareToHide", "show", "hide", "reposition"];
+    for (_j = 0, _len1 = _ref2.length; _j < _len1; _j++) {
+      methodToBind = _ref2[_j];
+      this.bound[methodToBind] = (function(methodToBind) {
+        return function() {
+          return _this[methodToBind].apply(_this, arguments);
+        };
+      })(methodToBind);
+    }
+    this.adapter.domReady(function() {
+      _this.activate();
+      if (_this.options.showOn === "creation") {
+        return _this.prepareToShow();
+      }
+    });
+  }
+
+  Opentip.prototype._setup = function() {
+    var hideOn, hideTrigger, hideTriggerElement, i, _i, _j, _len, _len1, _ref, _ref1, _results;
+    this.debug("Setting up the tooltip.");
+    this._buildContainer();
+    this.hideTriggers = [];
+    _ref = this.options.hideTriggers;
+    for (i = _i = 0, _len = _ref.length; _i < _len; i = ++_i) {
+      hideTrigger = _ref[i];
+      hideTriggerElement = null;
+      hideOn = this.options.hideOn instanceof Array ? this.options.hideOn[i] : this.options.hideOn;
+      if (typeof hideTrigger === "string") {
+        switch (hideTrigger) {
+          case "trigger":
+            hideOn = hideOn || "mouseout";
+            hideTriggerElement = this.triggerElement;
+            break;
+          case "tip":
+            hideOn = hideOn || "mouseover";
+            hideTriggerElement = this.container;
+            break;
+          case "target":
+            hideOn = hideOn || "mouseover";
+            hideTriggerElement = this.options.target;
+            break;
+          case "closeButton":
+            break;
+          default:
+            throw new Error("Unknown hide trigger: " + hideTrigger + ".");
+        }
+      } else {
+        hideOn = hideOn || "mouseover";
+        hideTriggerElement = this.adapter.wrap(hideTrigger);
+      }
+      if (hideTriggerElement) {
+        this.hideTriggers.push({
+          element: hideTriggerElement,
+          event: hideOn,
+          original: hideTrigger
+        });
+      }
+    }
+    _ref1 = this.hideTriggers;
+    _results = [];
+    for (_j = 0, _len1 = _ref1.length; _j < _len1; _j++) {
+      hideTrigger = _ref1[_j];
+      _results.push(this.showTriggersWhenVisible.push({
+        element: hideTrigger.element,
+        event: "mouseover"
+      }));
+    }
+    return _results;
+  };
+
+  Opentip.prototype._buildContainer = function() {
+    this.container = this.adapter.create("<div id=\"opentip-" + this.id + "\" class=\"" + this["class"].container + " " + this["class"].hidden + " " + this["class"].stylePrefix + this.options.className + "\"></div>");
+    this.adapter.css(this.container, {
+      position: "absolute"
+    });
+    if (this.options.ajax) {
+      this.adapter.addClass(this.container, this["class"].loading);
+    }
+    if (this.options.fixed) {
+      this.adapter.addClass(this.container, this["class"].fixed);
+    }
+    if (this.options.showEffect) {
+      this.adapter.addClass(this.container, "" + this["class"].showEffectPrefix + this.options.showEffect);
+    }
+    if (this.options.hideEffect) {
+      return this.adapter.addClass(this.container, "" + this["class"].hideEffectPrefix + this.options.hideEffect);
+    }
+  };
+
+  Opentip.prototype._buildElements = function() {
+    var headerElement, titleElement;
+    this.tooltipElement = this.adapter.create("<div class=\"" + this["class"].opentip + "\"><div class=\"" + this["class"].header + "\"></div><div class=\"" + this["class"].content + "\"></div></div>");
+    this.backgroundCanvas = this.adapter.wrap(document.createElement("canvas"));
+    this.adapter.css(this.backgroundCanvas, {
+      position: "absolute"
+    });
+    if (typeof G_vmlCanvasManager !== "undefined" && G_vmlCanvasManager !== null) {
+      G_vmlCanvasManager.initElement(this.adapter.unwrap(this.backgroundCanvas));
+    }
+    headerElement = this.adapter.find(this.tooltipElement, "." + this["class"].header);
+    if (this.options.title) {
+      titleElement = this.adapter.create("<h1></h1>");
+      this.adapter.update(titleElement, this.options.title, this.options.escapeTitle);
+      this.adapter.append(headerElement, titleElement);
+    }
+    if (this.options.ajax && !this.loaded) {
+      this.adapter.append(this.tooltipElement, this.adapter.create("<div class=\"" + this["class"].loadingIndicator + "\"><span>↻</span></div>"));
+    }
+    if (__indexOf.call(this.options.hideTriggers, "closeButton") >= 0) {
+      this.closeButtonElement = this.adapter.create("<a href=\"javascript:undefined;\" class=\"" + this["class"].close + "\"><span>Close</span></a>");
+      this.adapter.append(headerElement, this.closeButtonElement);
+    }
+    this.adapter.append(this.container, this.backgroundCanvas);
+    this.adapter.append(this.container, this.tooltipElement);
+    this.adapter.append(document.body, this.container);
+    this._newContent = true;
+    return this.redraw = true;
+  };
+
+  Opentip.prototype.setContent = function(content) {
+    this.content = content;
+    this._newContent = true;
+    if (typeof this.content === "function") {
+      this._contentFunction = this.content;
+      this.content = "";
+    } else {
+      this._contentFunction = null;
+    }
+    if (this.visible) {
+      return this._updateElementContent();
+    }
+  };
+
+  Opentip.prototype._updateElementContent = function() {
+    var contentDiv;
+    if (this._newContent || (!this.options.cache && this._contentFunction)) {
+      contentDiv = this.adapter.find(this.container, "." + this["class"].content);
+      if (contentDiv != null) {
+        if (this._contentFunction) {
+          this.debug("Executing content function.");
+          this.content = this._contentFunction(this);
+        }
+        this.adapter.update(contentDiv, this.content, this.options.escapeContent);
+      }
+      this._newContent = false;
+    }
+    this._storeAndLockDimensions();
+    return this.reposition();
+  };
+
+  Opentip.prototype._storeAndLockDimensions = function() {
+    var prevDimension;
+    if (!this.container) {
+      return;
+    }
+    prevDimension = this.dimensions;
+    this.adapter.css(this.container, {
+      width: "auto",
+      left: "0px",
+      top: "0px"
+    });
+    this.dimensions = this.adapter.dimensions(this.container);
+    this.dimensions.width += 1;
+    this.adapter.css(this.container, {
+      width: "" + this.dimensions.width + "px",
+      top: "" + this.currentPosition.top + "px",
+      left: "" + this.currentPosition.left + "px"
+    });
+    if (!this._dimensionsEqual(this.dimensions, prevDimension)) {
+      this.redraw = true;
+      return this._draw();
+    }
+  };
+
+  Opentip.prototype.activate = function() {
+    return this._setupObservers("hidden", "hiding");
+  };
+
+  Opentip.prototype.deactivate = function() {
+    this.debug("Deactivating tooltip.");
+    this.hide();
+    return this._setupObservers("-showing", "-visible", "-hidden", "-hiding");
+  };
+
+  Opentip.prototype._setupObservers = function() {
+    var observeOrStop, removeObserver, state, states, trigger, _i, _j, _k, _l, _len, _len1, _len2, _len3, _ref, _ref1, _ref2,
+      _this = this;
+    states = 1 <= arguments.length ? __slice.call(arguments, 0) : [];
+    for (_i = 0, _len = states.length; _i < _len; _i++) {
+      state = states[_i];
+      removeObserver = false;
+      if (state.charAt(0) === "-") {
+        removeObserver = true;
+        state = state.substr(1);
+      }
+      if (this.currentObservers[state] === !removeObserver) {
+        continue;
+      }
+      this.currentObservers[state] = !removeObserver;
+      observeOrStop = function() {
+        var args, _ref, _ref1;
+        args = 1 <= arguments.length ? __slice.call(arguments, 0) : [];
+        if (removeObserver) {
+          return (_ref = _this.adapter).stopObserving.apply(_ref, args);
+        } else {
+          return (_ref1 = _this.adapter).observe.apply(_ref1, args);
+        }
+      };
+      switch (state) {
+        case "showing":
+          _ref = this.hideTriggers;
+          for (_j = 0, _len1 = _ref.length; _j < _len1; _j++) {
+            trigger = _ref[_j];
+            observeOrStop(trigger.element, trigger.event, this.bound.prepareToHide);
+          }
+          observeOrStop((document.onresize != null ? document : window), "resize", this.bound.reposition);
+          observeOrStop(window, "scroll", this.bound.reposition);
+          break;
+        case "visible":
+          _ref1 = this.showTriggersWhenVisible;
+          for (_k = 0, _len2 = _ref1.length; _k < _len2; _k++) {
+            trigger = _ref1[_k];
+            observeOrStop(trigger.element, trigger.event, this.bound.prepareToShow);
+          }
+          break;
+        case "hiding":
+          _ref2 = this.showTriggers;
+          for (_l = 0, _len3 = _ref2.length; _l < _len3; _l++) {
+            trigger = _ref2[_l];
+            observeOrStop(trigger.element, trigger.event, this.bound.prepareToShow);
+          }
+          break;
+        case "hidden":
+          break;
+        default:
+          throw new Error("Unknown state: " + state);
+      }
+    }
+    return null;
+  };
+
+  Opentip.prototype.prepareToShow = function() {
+    this._abortHiding();
+    this._abortShowing();
+    if (this.visible) {
+      return;
+    }
+    this.debug("Showing in " + this.options.delay + "s.");
+    if (this.container == null) {
+      this._setup();
+    }
+    if (this.options.group) {
+      Opentip._abortShowingGroup(this.options.group, this);
+    }
+    this.preparingToShow = true;
+    this._setupObservers("-hidden", "-hiding", "showing");
+    this._followMousePosition();
+    if (this.options.fixed && !this.options.target) {
+      this.initialMousePosition = mousePosition;
+    }
+    this.reposition();
+    return this._showTimeoutId = this.setTimeout(this.bound.show, this.options.delay || 0);
+  };
+
+  Opentip.prototype.show = function() {
+    var _this = this;
+    this._abortHiding();
+    if (this.visible) {
+      return;
+    }
+    this._clearTimeouts();
+    if (!this._triggerElementExists()) {
+      return this.deactivate();
+    }
+    this.debug("Showing now.");
+    if (this.container == null) {
+      this._setup();
+    }
+    if (this.options.group) {
+      Opentip._hideGroup(this.options.group, this);
+    }
+    this.visible = true;
+    this.preparingToShow = false;
+    if (this.tooltipElement == null) {
+      this._buildElements();
+    }
+    this._updateElementContent();
+    if (this.options.ajax && (!this.loaded || !this.options.cache)) {
+      this._loadAjax();
+    }
+    this._searchAndActivateCloseButtons();
+    this._startEnsureTriggerElement();
+    this.adapter.css(this.container, {
+      zIndex: Opentip.lastZIndex++
+    });
+    this._setupObservers("-hidden", "-hiding", "-showing", "-visible", "showing", "visible");
+    if (this.options.fixed && !this.options.target) {
+      this.initialMousePosition = mousePosition;
+    }
+    this.reposition();
+    this.adapter.removeClass(this.container, this["class"].hiding);
+    this.adapter.removeClass(this.container, this["class"].hidden);
+    this.adapter.addClass(this.container, this["class"].goingToShow);
+    this.setCss3Style(this.container, {
+      transitionDuration: "0s"
+    });
+    this.defer(function() {
+      var delay;
+      if (!_this.visible || _this.preparingToHide) {
+        return;
+      }
+      _this.adapter.removeClass(_this.container, _this["class"].goingToShow);
+      _this.adapter.addClass(_this.container, _this["class"].showing);
+      delay = 0;
+      if (_this.options.showEffect && _this.options.showEffectDuration) {
+        delay = _this.options.showEffectDuration;
+      }
+      _this.setCss3Style(_this.container, {
+        transitionDuration: "" + delay + "s"
+      });
+      _this._visibilityStateTimeoutId = _this.setTimeout(function() {
+        _this.adapter.removeClass(_this.container, _this["class"].showing);
+        return _this.adapter.addClass(_this.container, _this["class"].visible);
+      }, delay);
+      return _this._activateFirstInput();
+    });
+    return this._draw();
+  };
+
+  Opentip.prototype._abortShowing = function() {
+    if (this.preparingToShow) {
+      this.debug("Aborting showing.");
+      this._clearTimeouts();
+      this._stopFollowingMousePosition();
+      this.preparingToShow = false;
+      return this._setupObservers("-showing", "-visible", "hiding", "hidden");
+    }
+  };
+
+  Opentip.prototype.prepareToHide = function() {
+    this._abortShowing();
+    this._abortHiding();
+    if (!this.visible) {
+      return;
+    }
+    this.debug("Hiding in " + this.options.hideDelay + "s");
+    this.preparingToHide = true;
+    this._setupObservers("-showing", "visible", "-hidden", "hiding");
+    return this._hideTimeoutId = this.setTimeout(this.bound.hide, this.options.hideDelay);
+  };
+
+  Opentip.prototype.hide = function() {
+    var _this = this;
+    this._abortShowing();
+    if (!this.visible) {
+      return;
+    }
+    this._clearTimeouts();
+    this.debug("Hiding!");
+    this.visible = false;
+    this.preparingToHide = false;
+    this._stopEnsureTriggerElement();
+    this._setupObservers("-showing", "-visible", "-hiding", "-hidden", "hiding", "hidden");
+    if (!this.options.fixed) {
+      this._stopFollowingMousePosition();
+    }
+    if (!this.container) {
+      return;
+    }
+    this.adapter.removeClass(this.container, this["class"].visible);
+    this.adapter.removeClass(this.container, this["class"].showing);
+    this.adapter.addClass(this.container, this["class"].goingToHide);
+    this.setCss3Style(this.container, {
+      transitionDuration: "0s"
+    });
+    return this.defer(function() {
+      var hideDelay;
+      _this.adapter.removeClass(_this.container, _this["class"].goingToHide);
+      _this.adapter.addClass(_this.container, _this["class"].hiding);
+      hideDelay = 0;
+      if (_this.options.hideEffect && _this.options.hideEffectDuration) {
+        hideDelay = _this.options.hideEffectDuration;
+      }
+      _this.setCss3Style(_this.container, {
+        transitionDuration: "" + hideDelay + "s"
+      });
+      return _this._visibilityStateTimeoutId = _this.setTimeout(function() {
+        _this.adapter.removeClass(_this.container, _this["class"].hiding);
+        _this.adapter.addClass(_this.container, _this["class"].hidden);
+        _this.setCss3Style(_this.container, {
+          transitionDuration: "0s"
+        });
+        if (_this.options.removeElementsOnHide) {
+          _this.debug("Removing HTML elements.");
+          _this.adapter.remove(_this.container);
+          delete _this.container;
+          return delete _this.tooltipElement;
+        }
+      }, hideDelay);
+    });
+  };
+
+  Opentip.prototype._abortHiding = function() {
+    if (this.preparingToHide) {
+      this.debug("Aborting hiding.");
+      this._clearTimeouts();
+      this.preparingToHide = false;
+      return this._setupObservers("-hiding", "showing", "visible");
+    }
+  };
+
+  Opentip.prototype.reposition = function() {
+    var position, stem, _ref,
+      _this = this;
+    position = this.getPosition();
+    if (position == null) {
+      return;
+    }
+    stem = this.options.stem;
+    if (this.options.containInViewport) {
+      _ref = this._ensureViewportContainment(position), position = _ref.position, stem = _ref.stem;
+    }
+    if (this._positionsEqual(position, this.currentPosition)) {
+      return;
+    }
+    if (!(!this.options.stem || stem.eql(this.currentStem))) {
+      this.redraw = true;
+    }
+    this.currentPosition = position;
+    this.currentStem = stem;
+    this._draw();
+    this.adapter.css(this.container, {
+      left: "" + position.left + "px",
+      top: "" + position.top + "px"
+    });
+    return this.defer(function() {
+      var rawContainer, redrawFix;
+      rawContainer = _this.adapter.unwrap(_this.container);
+      rawContainer.style.visibility = "hidden";
+      redrawFix = rawContainer.offsetHeight;
+      return rawContainer.style.visibility = "visible";
+    });
+  };
+
+  Opentip.prototype.getPosition = function(tipJoint, targetJoint, stem) {
+    var additionalHorizontal, additionalVertical, offsetDistance, position, stemLength, targetDimensions, targetPosition, unwrappedTarget, _ref;
+    if (!this.container) {
+      return;
+    }
+    if (tipJoint == null) {
+      tipJoint = this.options.tipJoint;
+    }
+    if (targetJoint == null) {
+      targetJoint = this.options.targetJoint;
+    }
+    position = {};
+    if (this.options.target) {
+      targetPosition = this.adapter.offset(this.options.target);
+      targetDimensions = this.adapter.dimensions(this.options.target);
+      position = targetPosition;
+      if (targetJoint.right) {
+        unwrappedTarget = this.adapter.unwrap(this.options.target);
+        if (unwrappedTarget.getBoundingClientRect != null) {
+          position.left = unwrappedTarget.getBoundingClientRect().right + ((_ref = window.pageXOffset) != null ? _ref : document.body.scrollLeft);
+        } else {
+          position.left += targetDimensions.width;
+        }
+      } else if (targetJoint.center) {
+        position.left += Math.round(targetDimensions.width / 2);
+      }
+      if (targetJoint.bottom) {
+        position.top += targetDimensions.height;
+      } else if (targetJoint.middle) {
+        position.top += Math.round(targetDimensions.height / 2);
+      }
+      if (this.options.borderWidth) {
+        if (this.options.tipJoint.left) {
+          position.left += this.options.borderWidth;
+        }
+        if (this.options.tipJoint.right) {
+          position.left -= this.options.borderWidth;
+        }
+        if (this.options.tipJoint.top) {
+          position.top += this.options.borderWidth;
+        } else if (this.options.tipJoint.bottom) {
+          position.top -= this.options.borderWidth;
+        }
+      }
+    } else {
+      if (this.initialMousePosition) {
+        position = {
+          top: this.initialMousePosition.y,
+          left: this.initialMousePosition.x
+        };
+      } else {
+        position = {
+          top: mousePosition.y,
+          left: mousePosition.x
+        };
+      }
+    }
+    if (this.options.autoOffset) {
+      stemLength = this.options.stem ? this.options.stemLength : 0;
+      offsetDistance = stemLength && this.options.fixed ? 2 : 10;
+      additionalHorizontal = tipJoint.middle && !this.options.fixed ? 15 : 0;
+      additionalVertical = tipJoint.center && !this.options.fixed ? 15 : 0;
+      if (tipJoint.right) {
+        position.left -= offsetDistance + additionalHorizontal;
+      } else if (tipJoint.left) {
+        position.left += offsetDistance + additionalHorizontal;
+      }
+      if (tipJoint.bottom) {
+        position.top -= offsetDistance + additionalVertical;
+      } else if (tipJoint.top) {
+        position.top += offsetDistance + additionalVertical;
+      }
+      if (stemLength) {
+        if (stem == null) {
+          stem = this.options.stem;
+        }
+        if (stem.right) {
+          position.left -= stemLength;
+        } else if (stem.left) {
+          position.left += stemLength;
+        }
+        if (stem.bottom) {
+          position.top -= stemLength;
+        } else if (stem.top) {
+          position.top += stemLength;
+        }
+      }
+    }
+    position.left += this.options.offset[0];
+    position.top += this.options.offset[1];
+    if (tipJoint.right) {
+      position.left -= this.dimensions.width;
+    } else if (tipJoint.center) {
+      position.left -= Math.round(this.dimensions.width / 2);
+    }
+    if (tipJoint.bottom) {
+      position.top -= this.dimensions.height;
+    } else if (tipJoint.middle) {
+      position.top -= Math.round(this.dimensions.height / 2);
+    }
+    return position;
+  };
+
+  Opentip.prototype._ensureViewportContainment = function(position) {
+    var needsRepositioning, newSticksOut, originals, revertedX, revertedY, scrollOffset, stem, sticksOut, targetJoint, tipJoint, viewportDimensions, viewportPosition;
+    stem = this.options.stem;
+    originals = {
+      position: position,
+      stem: stem
+    };
+    if (!(this.visible && position)) {
+      return originals;
+    }
+    sticksOut = this._sticksOut(position);
+    if (!(sticksOut[0] || sticksOut[1])) {
+      return originals;
+    }
+    tipJoint = new Opentip.Joint(this.options.tipJoint);
+    if (this.options.targetJoint) {
+      targetJoint = new Opentip.Joint(this.options.targetJoint);
+    }
+    scrollOffset = this.adapter.scrollOffset();
+    viewportDimensions = this.adapter.viewportDimensions();
+    viewportPosition = [position.left - scrollOffset[0], position.top - scrollOffset[1]];
+    needsRepositioning = false;
+    if (viewportDimensions.width >= this.dimensions.width) {
+      if (sticksOut[0]) {
+        needsRepositioning = true;
+        switch (sticksOut[0]) {
+          case this.STICKS_OUT_LEFT:
+            tipJoint.setHorizontal("left");
+            if (this.options.targetJoint) {
+              targetJoint.setHorizontal("right");
+            }
+            break;
+          case this.STICKS_OUT_RIGHT:
+            tipJoint.setHorizontal("right");
+            if (this.options.targetJoint) {
+              targetJoint.setHorizontal("left");
+            }
+        }
+      }
+    }
+    if (viewportDimensions.height >= this.dimensions.height) {
+      if (sticksOut[1]) {
+        needsRepositioning = true;
+        switch (sticksOut[1]) {
+          case this.STICKS_OUT_TOP:
+            tipJoint.setVertical("top");
+            if (this.options.targetJoint) {
+              targetJoint.setVertical("bottom");
+            }
+            break;
+          case this.STICKS_OUT_BOTTOM:
+            tipJoint.setVertical("bottom");
+            if (this.options.targetJoint) {
+              targetJoint.setVertical("top");
+            }
+        }
+      }
+    }
+    if (!needsRepositioning) {
+      return originals;
+    }
+    if (this.options.stem) {
+      stem = tipJoint;
+    }
+    position = this.getPosition(tipJoint, targetJoint, stem);
+    newSticksOut = this._sticksOut(position);
+    revertedX = false;
+    revertedY = false;
+    if (newSticksOut[0] && (newSticksOut[0] !== sticksOut[0])) {
+      revertedX = true;
+      tipJoint.setHorizontal(this.options.tipJoint.horizontal);
+      if (this.options.targetJoint) {
+        targetJoint.setHorizontal(this.options.targetJoint.horizontal);
+      }
+    }
+    if (newSticksOut[1] && (newSticksOut[1] !== sticksOut[1])) {
+      revertedY = true;
+      tipJoint.setVertical(this.options.tipJoint.vertical);
+      if (this.options.targetJoint) {
+        targetJoint.setVertical(this.options.targetJoint.vertical);
+      }
+    }
+    if (revertedX && revertedY) {
+      return originals;
+    }
+    if (revertedX || revertedY) {
+      if (this.options.stem) {
+        stem = tipJoint;
+      }
+      position = this.getPosition(tipJoint, targetJoint, stem);
+    }
+    return {
+      position: position,
+      stem: stem
+    };
+  };
+
+  Opentip.prototype._sticksOut = function(position) {
+    var positionOffset, scrollOffset, sticksOut, viewportDimensions;
+    scrollOffset = this.adapter.scrollOffset();
+    viewportDimensions = this.adapter.viewportDimensions();
+    positionOffset = [position.left - scrollOffset[0], position.top - scrollOffset[1]];
+    sticksOut = [false, false];
+    if (positionOffset[0] < 0) {
+      sticksOut[0] = this.STICKS_OUT_LEFT;
+    } else if (positionOffset[0] + this.dimensions.width > viewportDimensions.width) {
+      sticksOut[0] = this.STICKS_OUT_RIGHT;
+    }
+    if (positionOffset[1] < 0) {
+      sticksOut[1] = this.STICKS_OUT_TOP;
+    } else if (positionOffset[1] + this.dimensions.height > viewportDimensions.height) {
+      sticksOut[1] = this.STICKS_OUT_BOTTOM;
+    }
+    return sticksOut;
+  };
+
+  Opentip.prototype._draw = function() {
+    var backgroundCanvas, bulge, canvasDimensions, canvasPosition, closeButton, closeButtonInner, closeButtonOuter, ctx, drawCorner, drawLine, hb, position, stemBase, stemLength, _i, _len, _ref, _ref1, _ref2,
+      _this = this;
+    if (!(this.backgroundCanvas && this.redraw)) {
+      return;
+    }
+    this.debug("Drawing background.");
+    this.redraw = false;
+    if (this.currentStem) {
+      _ref = ["top", "right", "bottom", "left"];
+      for (_i = 0, _len = _ref.length; _i < _len; _i++) {
+        position = _ref[_i];
+        this.adapter.removeClass(this.container, "stem-" + position);
+      }
+      this.adapter.addClass(this.container, "stem-" + this.currentStem.horizontal);
+      this.adapter.addClass(this.container, "stem-" + this.currentStem.vertical);
+    }
+    closeButtonInner = [0, 0];
+    closeButtonOuter = [0, 0];
+    if (__indexOf.call(this.options.hideTriggers, "closeButton") >= 0) {
+      closeButton = new Opentip.Joint(((_ref1 = this.currentStem) != null ? _ref1.toString() : void 0) === "top right" ? "top left" : "top right");
+      closeButtonInner = [this.options.closeButtonRadius + this.options.closeButtonOffset[0], this.options.closeButtonRadius + this.options.closeButtonOffset[1]];
+      closeButtonOuter = [this.options.closeButtonRadius - this.options.closeButtonOffset[0], this.options.closeButtonRadius - this.options.closeButtonOffset[1]];
+    }
+    canvasDimensions = this.adapter.clone(this.dimensions);
+    canvasPosition = [0, 0];
+    if (this.options.borderWidth) {
+      canvasDimensions.width += this.options.borderWidth * 2;
+      canvasDimensions.height += this.options.borderWidth * 2;
+      canvasPosition[0] -= this.options.borderWidth;
+      canvasPosition[1] -= this.options.borderWidth;
+    }
+    if (this.options.shadow) {
+      canvasDimensions.width += this.options.shadowBlur * 2;
+      canvasDimensions.width += Math.max(0, this.options.shadowOffset[0] - this.options.shadowBlur * 2);
+      canvasDimensions.height += this.options.shadowBlur * 2;
+      canvasDimensions.height += Math.max(0, this.options.shadowOffset[1] - this.options.shadowBlur * 2);
+      canvasPosition[0] -= Math.max(0, this.options.shadowBlur - this.options.shadowOffset[0]);
+      canvasPosition[1] -= Math.max(0, this.options.shadowBlur - this.options.shadowOffset[1]);
+    }
+    bulge = {
+      left: 0,
+      right: 0,
+      top: 0,
+      bottom: 0
+    };
+    if (this.currentStem) {
+      if (this.currentStem.left) {
+        bulge.left = this.options.stemLength;
+      } else if (this.currentStem.right) {
+        bulge.right = this.options.stemLength;
+      }
+      if (this.currentStem.top) {
+        bulge.top = this.options.stemLength;
+      } else if (this.currentStem.bottom) {
+        bulge.bottom = this.options.stemLength;
+      }
+    }
+    if (closeButton) {
+      if (closeButton.left) {
+        bulge.left = Math.max(bulge.left, closeButtonOuter[0]);
+      } else if (closeButton.right) {
+        bulge.right = Math.max(bulge.right, closeButtonOuter[0]);
+      }
+      if (closeButton.top) {
+        bulge.top = Math.max(bulge.top, closeButtonOuter[1]);
+      } else if (closeButton.bottom) {
+        bulge.bottom = Math.max(bulge.bottom, closeButtonOuter[1]);
+      }
+    }
+    canvasDimensions.width += bulge.left + bulge.right;
+    canvasDimensions.height += bulge.top + bulge.bottom;
+    canvasPosition[0] -= bulge.left;
+    canvasPosition[1] -= bulge.top;
+    if (this.currentStem && this.options.borderWidth) {
+      _ref2 = this._getPathStemMeasures(this.options.stemBase, this.options.stemLength, this.options.borderWidth), stemLength = _ref2.stemLength, stemBase = _ref2.stemBase;
+    }
+    backgroundCanvas = this.adapter.unwrap(this.backgroundCanvas);
+    backgroundCanvas.width = canvasDimensions.width;
+    backgroundCanvas.height = canvasDimensions.height;
+    this.adapter.css(this.backgroundCanvas, {
+      width: "" + backgroundCanvas.width + "px",
+      height: "" + backgroundCanvas.height + "px",
+      left: "" + canvasPosition[0] + "px",
+      top: "" + canvasPosition[1] + "px"
+    });
+    ctx = backgroundCanvas.getContext("2d");
+    ctx.setTransform(1, 0, 0, 1, 0, 0);
+    ctx.clearRect(0, 0, backgroundCanvas.width, backgroundCanvas.height);
+    ctx.beginPath();
+    ctx.fillStyle = this._getColor(ctx, this.dimensions, this.options.background, this.options.backgroundGradientHorizontal);
+    ctx.lineJoin = "miter";
+    ctx.miterLimit = 500;
+    hb = this.options.borderWidth / 2;
+    if (this.options.borderWidth) {
+      ctx.strokeStyle = this.options.borderColor;
+      ctx.lineWidth = this.options.borderWidth;
+    } else {
+      stemLength = this.options.stemLength;
+      stemBase = this.options.stemBase;
+    }
+    if (stemBase == null) {
+      stemBase = 0;
+    }
+    drawLine = function(length, stem, first) {
+      if (first) {
+        ctx.moveTo(Math.max(stemBase, _this.options.borderRadius, closeButtonInner[0]) + 1 - hb, -hb);
+      }
+      if (stem) {
+        ctx.lineTo(length / 2 - stemBase / 2, -hb);
+        ctx.lineTo(length / 2, -stemLength - hb);
+        return ctx.lineTo(length / 2 + stemBase / 2, -hb);
+      }
+    };
+    drawCorner = function(stem, closeButton, i) {
+      var angle1, angle2, innerWidth, offset;
+      if (stem) {
+        ctx.lineTo(-stemBase + hb, 0 - hb);
+        ctx.lineTo(stemLength + hb, -stemLength - hb);
+        return ctx.lineTo(hb, stemBase - hb);
+      } else if (closeButton) {
+        offset = _this.options.closeButtonOffset;
+        innerWidth = closeButtonInner[0];
+        if (i % 2 !== 0) {
+          offset = [offset[1], offset[0]];
+          innerWidth = closeButtonInner[1];
+        }
+        angle1 = Math.acos(offset[1] / _this.options.closeButtonRadius);
+        angle2 = Math.acos(offset[0] / _this.options.closeButtonRadius);
+        ctx.lineTo(-innerWidth + hb, -hb);
+        return ctx.arc(hb - offset[0], -hb + offset[1], _this.options.closeButtonRadius, -(Math.PI / 2 + angle1), angle2, false);
+      } else {
+        ctx.lineTo(-_this.options.borderRadius + hb, -hb);
+        return ctx.quadraticCurveTo(hb, -hb, hb, _this.options.borderRadius - hb);
+      }
+    };
+    ctx.translate(-canvasPosition[0], -canvasPosition[1]);
+    ctx.save();
+    (function() {
+      var cornerStem, i, lineLength, lineStem, positionIdx, positionX, positionY, rotation, _j, _ref3, _results;
+      _results = [];
+      for (i = _j = 0, _ref3 = Opentip.positions.length / 2; 0 <= _ref3 ? _j < _ref3 : _j > _ref3; i = 0 <= _ref3 ? ++_j : --_j) {
+        positionIdx = i * 2;
+        positionX = i === 0 || i === 3 ? 0 : _this.dimensions.width;
+        positionY = i < 2 ? 0 : _this.dimensions.height;
+        rotation = (Math.PI / 2) * i;
+        lineLength = i % 2 === 0 ? _this.dimensions.width : _this.dimensions.height;
+        lineStem = new Opentip.Joint(Opentip.positions[positionIdx]);
+        cornerStem = new Opentip.Joint(Opentip.positions[positionIdx + 1]);
+        ctx.save();
+        ctx.translate(positionX, positionY);
+        ctx.rotate(rotation);
+        drawLine(lineLength, lineStem.eql(_this.currentStem), i === 0);
+        ctx.translate(lineLength, 0);
+        drawCorner(cornerStem.eql(_this.currentStem), cornerStem.eql(closeButton), i);
+        _results.push(ctx.restore());
+      }
+      return _results;
+    })();
+    ctx.closePath();
+    ctx.save();
+    if (this.options.shadow) {
+      ctx.shadowColor = this.options.shadowColor;
+      ctx.shadowBlur = this.options.shadowBlur;
+      ctx.shadowOffsetX = this.options.shadowOffset[0];
+      ctx.shadowOffsetY = this.options.shadowOffset[1];
+    }
+    ctx.fill();
+    ctx.restore();
+    if (this.options.borderWidth) {
+      ctx.stroke();
+    }
+    ctx.restore();
+    if (closeButton) {
+      return (function() {
+        var crossCenter, crossHeight, crossWidth, hcs, linkCenter;
+        crossWidth = crossHeight = _this.options.closeButtonRadius * 2;
+        if (closeButton.toString() === "top right") {
+          linkCenter = [_this.dimensions.width - _this.options.closeButtonOffset[0], _this.options.closeButtonOffset[1]];
+          crossCenter = [linkCenter[0] + hb, linkCenter[1] - hb];
+        } else {
+          linkCenter = [_this.options.closeButtonOffset[0], _this.options.closeButtonOffset[1]];
+          crossCenter = [linkCenter[0] - hb, linkCenter[1] - hb];
+        }
+        ctx.translate(crossCenter[0], crossCenter[1]);
+        hcs = _this.options.closeButtonCrossSize / 2;
+        ctx.save();
+        ctx.beginPath();
+        ctx.strokeStyle = _this.options.closeButtonCrossColor;
+        ctx.lineWidth = _this.options.closeButtonCrossLineWidth;
+        ctx.lineCap = "round";
+        ctx.moveTo(-hcs, -hcs);
+        ctx.lineTo(hcs, hcs);
+        ctx.stroke();
+        ctx.beginPath();
+        ctx.moveTo(hcs, -hcs);
+        ctx.lineTo(-hcs, hcs);
+        ctx.stroke();
+        ctx.restore();
+        return _this.adapter.css(_this.closeButtonElement, {
+          left: "" + (linkCenter[0] - hcs - _this.options.closeButtonLinkOverscan) + "px",
+          top: "" + (linkCenter[1] - hcs - _this.options.closeButtonLinkOverscan) + "px",
+          width: "" + (_this.options.closeButtonCrossSize + _this.options.closeButtonLinkOverscan * 2) + "px",
+          height: "" + (_this.options.closeButtonCrossSize + _this.options.closeButtonLinkOverscan * 2) + "px"
+        });
+      })();
+    }
+  };
+
+  Opentip.prototype._getPathStemMeasures = function(outerStemBase, outerStemLength, borderWidth) {
+    var angle, distanceBetweenTips, halfAngle, hb, rhombusSide, stemBase, stemLength;
+    hb = borderWidth / 2;
+    halfAngle = Math.atan((outerStemBase / 2) / outerStemLength);
+    angle = halfAngle * 2;
+    rhombusSide = hb / Math.sin(angle);
+    distanceBetweenTips = 2 * rhombusSide * Math.cos(halfAngle);
+    stemLength = hb + outerStemLength - distanceBetweenTips;
+    if (stemLength < 0) {
+      throw new Error("Sorry but your stemLength / stemBase ratio is strange.");
+    }
+    stemBase = (Math.tan(halfAngle) * stemLength) * 2;
+    return {
+      stemLength: stemLength,
+      stemBase: stemBase
+    };
+  };
+
+  Opentip.prototype._getColor = function(ctx, dimensions, color, horizontal) {
+    var colorStop, gradient, i, _i, _len;
+    if (horizontal == null) {
+      horizontal = false;
+    }
+    if (typeof color === "string") {
+      return color;
+    }
+    if (horizontal) {
+      gradient = ctx.createLinearGradient(0, 0, dimensions.width, 0);
+    } else {
+      gradient = ctx.createLinearGradient(0, 0, 0, dimensions.height);
+    }
+    for (i = _i = 0, _len = color.length; _i < _len; i = ++_i) {
+      colorStop = color[i];
+      gradient.addColorStop(colorStop[0], colorStop[1]);
+    }
+    return gradient;
+  };
+
+  Opentip.prototype._searchAndActivateCloseButtons = function() {
+    var element, _i, _len, _ref;
+    _ref = this.adapter.findAll(this.container, "." + this["class"].close);
+    for (_i = 0, _len = _ref.length; _i < _len; _i++) {
+      element = _ref[_i];
+      this.hideTriggers.push({
+        element: this.adapter.wrap(element),
+        event: "click"
+      });
+    }
+    if (this.currentObservers.showing) {
+      this._setupObservers("-showing", "showing");
+    }
+    if (this.currentObservers.visible) {
+      return this._setupObservers("-visible", "visible");
+    }
+  };
+
+  Opentip.prototype._activateFirstInput = function() {
+    var input;
+    input = this.adapter.unwrap(this.adapter.find(this.container, "input, textarea"));
+    return input != null ? typeof input.focus === "function" ? input.focus() : void 0 : void 0;
+  };
+
+  Opentip.prototype._followMousePosition = function() {
+    if (!this.options.fixed) {
+      return Opentip._observeMousePosition(this.bound.reposition);
+    }
+  };
+
+  Opentip.prototype._stopFollowingMousePosition = function() {
+    if (!this.options.fixed) {
+      return Opentip._stopObservingMousePosition(this.bound.reposition);
+    }
+  };
+
+  Opentip.prototype._clearShowTimeout = function() {
+    return clearTimeout(this._showTimeoutId);
+  };
+
+  Opentip.prototype._clearHideTimeout = function() {
+    return clearTimeout(this._hideTimeoutId);
+  };
+
+  Opentip.prototype._clearTimeouts = function() {
+    clearTimeout(this._visibilityStateTimeoutId);
+    this._clearShowTimeout();
+    return this._clearHideTimeout();
+  };
+
+  Opentip.prototype._triggerElementExists = function() {
+    var el;
+    el = this.adapter.unwrap(this.triggerElement);
+    while (el.parentNode) {
+      if (el.parentNode.tagName === "BODY") {
+        return true;
+      }
+      el = el.parentNode;
+    }
+    return false;
+  };
+
+  Opentip.prototype._loadAjax = function() {
+    var _this = this;
+    if (this.loading) {
+      return;
+    }
+    this.loaded = false;
+    this.loading = true;
+    this.adapter.addClass(this.container, this["class"].loading);
+    this.setContent("");
+    this.debug("Loading content from " + this.options.ajax);
+    return this.adapter.ajax({
+      url: this.options.ajax,
+      method: this.options.ajaxMethod,
+      onSuccess: function(responseText) {
+        _this.debug("Loading successful.");
+        _this.adapter.removeClass(_this.container, _this["class"].loading);
+        return _this.setContent(responseText);
+      },
+      onError: function(error) {
+        var message;
+        message = _this.options.ajaxErrorMessage;
+        _this.debug(message, error);
+        _this.setContent(message);
+        return _this.adapter.addClass(_this.container, _this["class"].ajaxError);
+      },
+      onComplete: function() {
+        _this.adapter.removeClass(_this.container, _this["class"].loading);
+        _this.loading = false;
+        _this.loaded = true;
+        _this._searchAndActivateCloseButtons();
+        _this._activateFirstInput();
+        return _this.reposition();
+      }
+    });
+  };
+
+  Opentip.prototype._ensureTriggerElement = function() {
+    if (!this._triggerElementExists()) {
+      this.deactivate();
+      return this._stopEnsureTriggerElement();
+    }
+  };
+
+  Opentip.prototype._ensureTriggerElementInterval = 1000;
+
+  Opentip.prototype._startEnsureTriggerElement = function() {
+    var _this = this;
+    return this._ensureTriggerElementTimeoutId = setInterval((function() {
+      return _this._ensureTriggerElement();
+    }), this._ensureTriggerElementInterval);
+  };
+
+  Opentip.prototype._stopEnsureTriggerElement = function() {
+    return clearInterval(this._ensureTriggerElementTimeoutId);
+  };
+
+  return Opentip;
+
+})();
+
+vendors = ["khtml", "ms", "o", "moz", "webkit"];
+
+Opentip.prototype.setCss3Style = function(element, styles) {
+  var prop, value, vendor, vendorProp, _results;
+  element = this.adapter.unwrap(element);
+  _results = [];
+  for (prop in styles) {
+    if (!__hasProp.call(styles, prop)) continue;
+    value = styles[prop];
+    if (element.style[prop] != null) {
+      _results.push(element.style[prop] = value);
+    } else {
+      _results.push((function() {
+        var _i, _len, _results1;
+        _results1 = [];
+        for (_i = 0, _len = vendors.length; _i < _len; _i++) {
+          vendor = vendors[_i];
+          vendorProp = "" + (this.ucfirst(vendor)) + (this.ucfirst(prop));
+          if (element.style[vendorProp] != null) {
+            _results1.push(element.style[vendorProp] = value);
+          } else {
+            _results1.push(void 0);
+          }
+        }
+        return _results1;
+      }).call(this));
+    }
+  }
+  return _results;
+};
+
+Opentip.prototype.defer = function(func) {
+  return setTimeout(func, 0);
+};
+
+Opentip.prototype.setTimeout = function(func, seconds) {
+  return setTimeout(func, seconds ? seconds * 1000 : 0);
+};
+
+Opentip.prototype.ucfirst = function(string) {
+  if (string == null) {
+    return "";
+  }
+  return string.charAt(0).toUpperCase() + string.slice(1);
+};
+
+Opentip.prototype.dasherize = function(string) {
+  return string.replace(/([A-Z])/g, function(_, character) {
+    return "-" + (character.toLowerCase());
+  });
+};
+
+mousePositionObservers = [];
+
+mousePosition = {
+  x: 0,
+  y: 0
+};
+
+mouseMoved = function(e) {
+  var observer, _i, _len, _results;
+  mousePosition = Opentip.adapter.mousePosition(e);
+  _results = [];
+  for (_i = 0, _len = mousePositionObservers.length; _i < _len; _i++) {
+    observer = mousePositionObservers[_i];
+    _results.push(observer());
+  }
+  return _results;
+};
+
+Opentip.followMousePosition = function() {
+  return Opentip.adapter.observe(document.body, "mousemove", mouseMoved);
+};
+
+Opentip._observeMousePosition = function(observer) {
+  return mousePositionObservers.push(observer);
+};
+
+Opentip._stopObservingMousePosition = function(removeObserver) {
+  var observer;
+  return mousePositionObservers = (function() {
+    var _i, _len, _results;
+    _results = [];
+    for (_i = 0, _len = mousePositionObservers.length; _i < _len; _i++) {
+      observer = mousePositionObservers[_i];
+      if (observer !== removeObserver) {
+        _results.push(observer);
+      }
+    }
+    return _results;
+  })();
+};
+
+Opentip.Joint = (function() {
+
+  function Joint(pointerString) {
+    if (pointerString == null) {
+      return;
+    }
+    if (pointerString instanceof Opentip.Joint) {
+      pointerString = pointerString.toString();
+    }
+    this.set(pointerString);
+    this;
+
+  }
+
+  Joint.prototype.set = function(string) {
+    string = string.toLowerCase();
+    this.setHorizontal(string);
+    this.setVertical(string);
+    return this;
+  };
+
+  Joint.prototype.setHorizontal = function(string) {
+    var i, valid, _i, _j, _len, _len1, _results;
+    valid = ["left", "center", "right"];
+    for (_i = 0, _len = valid.length; _i < _len; _i++) {
+      i = valid[_i];
+      if (~string.indexOf(i)) {
+        this.horizontal = i.toLowerCase();
+      }
+    }
+    if (this.horizontal == null) {
+      this.horizontal = "center";
+    }
+    _results = [];
+    for (_j = 0, _len1 = valid.length; _j < _len1; _j++) {
+      i = valid[_j];
+      _results.push(this[i] = this.horizontal === i ? i : void 0);
+    }
+    return _results;
+  };
+
+  Joint.prototype.setVertical = function(string) {
+    var i, valid, _i, _j, _len, _len1, _results;
+    valid = ["top", "middle", "bottom"];
+    for (_i = 0, _len = valid.length; _i < _len; _i++) {
+      i = valid[_i];
+      if (~string.indexOf(i)) {
+        this.vertical = i.toLowerCase();
+      }
+    }
+    if (this.vertical == null) {
+      this.vertical = "middle";
+    }
+    _results = [];
+    for (_j = 0, _len1 = valid.length; _j < _len1; _j++) {
+      i = valid[_j];
+      _results.push(this[i] = this.vertical === i ? i : void 0);
+    }
+    return _results;
+  };
+
+  Joint.prototype.eql = function(pointer) {
+    return (pointer != null) && this.horizontal === pointer.horizontal && this.vertical === pointer.vertical;
+  };
+
+  Joint.prototype.flip = function() {
+    var flippedIndex, positionIdx;
+    positionIdx = Opentip.position[this.toString(true)];
+    flippedIndex = (positionIdx + 4) % 8;
+    this.set(Opentip.positions[flippedIndex]);
+    return this;
+  };
+
+  Joint.prototype.toString = function(camelized) {
+    var horizontal, vertical;
+    if (camelized == null) {
+      camelized = false;
+    }
+    vertical = this.vertical === "middle" ? "" : this.vertical;
+    horizontal = this.horizontal === "center" ? "" : this.horizontal;
+    if (vertical && horizontal) {
+      if (camelized) {
+        horizontal = Opentip.prototype.ucfirst(horizontal);
+      } else {
+        horizontal = " " + horizontal;
+      }
+    }
+    return "" + vertical + horizontal;
+  };
+
+  return Joint;
+
+})();
+
+Opentip.prototype._positionsEqual = function(posA, posB) {
+  return (posA != null) && (posB != null) && posA.left === posB.left && posA.top === posB.top;
+};
+
+Opentip.prototype._dimensionsEqual = function(dimA, dimB) {
+  return (dimA != null) && (dimB != null) && dimA.width === dimB.width && dimA.height === dimB.height;
+};
+
+Opentip.prototype.debug = function() {
+  var args;
+  args = 1 <= arguments.length ? __slice.call(arguments, 0) : [];
+  if (Opentip.debug && ((typeof console !== "undefined" && console !== null ? console.debug : void 0) != null)) {
+    args.unshift("#" + this.id + " |");
+    return console.debug.apply(console, args);
+  }
+};
+
+Opentip.findElements = function() {
+  var adapter, content, element, optionName, optionValue, options, _i, _len, _ref, _results;
+  adapter = Opentip.adapter;
+  _ref = adapter.findAll(document.body, "[data-ot]");
+  _results = [];
+  for (_i = 0, _len = _ref.length; _i < _len; _i++) {
+    element = _ref[_i];
+    options = {};
+    content = adapter.data(element, "ot");
+    if (content === "" || content === "true" || content === "yes") {
+      content = adapter.attr(element, "title");
+      adapter.attr(element, "title", "");
+    }
+    content = content || "";
+    for (optionName in Opentip.styles.standard) {
+      optionValue = adapter.data(element, "ot" + (Opentip.prototype.ucfirst(optionName)));
+      if (optionValue != null) {
+        if (optionValue === "yes" || optionValue === "true" || optionValue === "on") {
+          optionValue = true;
+        } else if (optionValue === "no" || optionValue === "false" || optionValue === "off") {
+          optionValue = false;
+        }
+        options[optionName] = optionValue;
+      }
+    }
+    _results.push(new Opentip(element, content, options));
+  }
+  return _results;
+};
+
+Opentip.version = "2.4.6";
+
+Opentip.debug = false;
+
+Opentip.lastId = 0;
+
+Opentip.lastZIndex = 100;
+
+Opentip.tips = [];
+
+Opentip._abortShowingGroup = function(group, originatingOpentip) {
+  var opentip, _i, _len, _ref, _results;
+  _ref = Opentip.tips;
+  _results = [];
+  for (_i = 0, _len = _ref.length; _i < _len; _i++) {
+    opentip = _ref[_i];
+    if (opentip !== originatingOpentip && opentip.options.group === group) {
+      _results.push(opentip._abortShowing());
+    } else {
+      _results.push(void 0);
+    }
+  }
+  return _results;
+};
+
+Opentip._hideGroup = function(group, originatingOpentip) {
+  var opentip, _i, _len, _ref, _results;
+  _ref = Opentip.tips;
+  _results = [];
+  for (_i = 0, _len = _ref.length; _i < _len; _i++) {
+    opentip = _ref[_i];
+    if (opentip !== originatingOpentip && opentip.options.group === group) {
+      _results.push(opentip.hide());
+    } else {
+      _results.push(void 0);
+    }
+  }
+  return _results;
+};
+
+Opentip.adapters = {};
+
+Opentip.adapter = null;
+
+firstAdapter = true;
+
+Opentip.addAdapter = function(adapter) {
+  Opentip.adapters[adapter.name] = adapter;
+  if (firstAdapter) {
+    Opentip.adapter = adapter;
+    adapter.domReady(Opentip.findElements);
+    adapter.domReady(Opentip.followMousePosition);
+    return firstAdapter = false;
+  }
+};
+
+Opentip.positions = ["top", "topRight", "right", "bottomRight", "bottom", "bottomLeft", "left", "topLeft"];
+
+Opentip.position = {};
+
+_ref = Opentip.positions;
+for (i = _i = 0, _len = _ref.length; _i < _len; i = ++_i) {
+  position = _ref[i];
+  Opentip.position[position] = i;
+}
+
+Opentip.styles = {
+  standard: {
+    "extends": null,
+    title: void 0,
+    escapeTitle: true,
+    escapeContent: false,
+    className: "standard",
+    stem: true,
+    delay: null,
+    hideDelay: 0.1,
+    fixed: false,
+    showOn: "mouseover",
+    hideTrigger: "trigger",
+    hideTriggers: [],
+    hideOn: null,
+    removeElementsOnHide: false,
+    offset: [0, 0],
+    containInViewport: true,
+    autoOffset: true,
+    showEffect: "appear",
+    hideEffect: "fade",
+    showEffectDuration: 0.3,
+    hideEffectDuration: 0.2,
+    stemLength: 5,
+    stemBase: 8,
+    tipJoint: "top left",
+    target: null,
+    targetJoint: null,
+    cache: true,
+    ajax: false,
+    ajaxMethod: "GET",
+    ajaxErrorMessage: "There was a problem downloading the content.",
+    group: null,
+    style: null,
+    background: "#fff18f",
+    backgroundGradientHorizontal: false,
+    closeButtonOffset: [5, 5],
+    closeButtonRadius: 7,
+    closeButtonCrossSize: 4,
+    closeButtonCrossColor: "#d2c35b",
+    closeButtonCrossLineWidth: 1.5,
+    closeButtonLinkOverscan: 6,
+    borderRadius: 5,
+    borderWidth: 1,
+    borderColor: "#f2e37b",
+    shadow: true,
+    shadowBlur: 10,
+    shadowOffset: [3, 3],
+    shadowColor: "rgba(0, 0, 0, 0.1)"
+  },
+  glass: {
+    "extends": "standard",
+    className: "glass",
+    background: [[0, "rgba(252, 252, 252, 0.8)"], [0.5, "rgba(255, 255, 255, 0.8)"], [0.5, "rgba(250, 250, 250, 0.9)"], [1, "rgba(245, 245, 245, 0.9)"]],
+    borderColor: "#eee",
+    closeButtonCrossColor: "rgba(0, 0, 0, 0.2)",
+    borderRadius: 15,
+    closeButtonRadius: 10,
+    closeButtonOffset: [8, 8]
+  },
+  dark: {
+    "extends": "standard",
+    className: "dark",
+    borderRadius: 13,
+    borderColor: "#444",
+    closeButtonCrossColor: "rgba(240, 240, 240, 1)",
+    shadowColor: "rgba(0, 0, 0, 0.3)",
+    shadowOffset: [2, 2],
+    background: [[0, "rgba(30, 30, 30, 0.7)"], [0.5, "rgba(30, 30, 30, 0.8)"], [0.5, "rgba(10, 10, 10, 0.8)"], [1, "rgba(10, 10, 10, 0.9)"]]
+  },
+  alert: {
+    "extends": "standard",
+    className: "alert",
+    borderRadius: 1,
+    borderColor: "#AE0D11",
+    closeButtonCrossColor: "rgba(255, 255, 255, 1)",
+    shadowColor: "rgba(0, 0, 0, 0.3)",
+    shadowOffset: [2, 2],
+    background: [[0, "rgba(203, 15, 19, 0.7)"], [0.5, "rgba(203, 15, 19, 0.8)"], [0.5, "rgba(189, 14, 18, 0.8)"], [1, "rgba(179, 14, 17, 0.9)"]]
+  }
+};
+
+Opentip.defaultStyle = "standard";
+
+if (typeof module !== "undefined" && module !== null) {
+  module.exports = Opentip;
+} else {
+  window.Opentip = Opentip;
+}
+
+
+// Generated by CoffeeScript 1.4.0
+var __slice = [].slice;
+
+(function($) {
+  var Adapter;
+  $.fn.opentip = function(content, title, options) {
+    return new Opentip(this, content, title, options);
+  };
+  Adapter = (function() {
+
+    function Adapter() {}
+
+    Adapter.prototype.name = "jquery";
+
+    Adapter.prototype.domReady = function(callback) {
+      return $(callback);
+    };
+
+    Adapter.prototype.create = function(html) {
+      return $(html);
+    };
+
+    Adapter.prototype.wrap = function(element) {
+      element = $(element);
+      if (element.length > 1) {
+        throw new Error("Multiple elements provided.");
+      }
+      return element;
+    };
+
+    Adapter.prototype.unwrap = function(element) {
+      return $(element)[0];
+    };
+
+    Adapter.prototype.tagName = function(element) {
+      return this.unwrap(element).tagName;
+    };
+
+    Adapter.prototype.attr = function() {
+      var args, element, _ref;
+      element = arguments[0], args = 2 <= arguments.length ? __slice.call(arguments, 1) : [];
+      return (_ref = $(element)).attr.apply(_ref, args);
+    };
+
+    Adapter.prototype.data = function() {
+      var args, element, _ref;
+      element = arguments[0], args = 2 <= arguments.length ? __slice.call(arguments, 1) : [];
+      return (_ref = $(element)).data.apply(_ref, args);
+    };
+
+    Adapter.prototype.find = function(element, selector) {
+      return $(element).find(selector).get(0);
+    };
+
+    Adapter.prototype.findAll = function(element, selector) {
+      return $(element).find(selector);
+    };
+
+    Adapter.prototype.update = function(element, content, escape) {
+      element = $(element);
+      if (escape) {
+        return element.text(content);
+      } else {
+        return element.html(content);
+      }
+    };
+
+    Adapter.prototype.append = function(element, child) {
+      return $(element).append(child);
+    };
+
+    Adapter.prototype.remove = function(element) {
+      return $(element).remove();
+    };
+
+    Adapter.prototype.addClass = function(element, className) {
+      return $(element).addClass(className);
+    };
+
+    Adapter.prototype.removeClass = function(element, className) {
+      return $(element).removeClass(className);
+    };
+
+    Adapter.prototype.css = function(element, properties) {
+      return $(element).css(properties);
+    };
+
+    Adapter.prototype.dimensions = function(element) {
+      return {
+        width: $(element).outerWidth(),
+        height: $(element).outerHeight()
+      };
+    };
+
+    Adapter.prototype.scrollOffset = function() {
+      return [window.pageXOffset || document.documentElement.scrollLeft || document.body.scrollLeft, window.pageYOffset || document.documentElement.scrollTop || document.body.scrollTop];
+    };
+
+    Adapter.prototype.viewportDimensions = function() {
+      return {
+        width: document.documentElement.clientWidth,
+        height: document.documentElement.clientHeight
+      };
+    };
+
+    Adapter.prototype.mousePosition = function(e) {
+      if (e == null) {
+        return null;
+      }
+      return {
+        x: e.pageX,
+        y: e.pageY
+      };
+    };
+
+    Adapter.prototype.offset = function(element) {
+      var offset;
+      offset = $(element).offset();
+      return {
+        left: offset.left,
+        top: offset.top
+      };
+    };
+
+    Adapter.prototype.observe = function(element, eventName, observer) {
+      return $(element).bind(eventName, observer);
+    };
+
+    Adapter.prototype.stopObserving = function(element, eventName, observer) {
+      return $(element).unbind(eventName, observer);
+    };
+
+    Adapter.prototype.ajax = function(options) {
+      var _ref, _ref1;
+      if (options.url == null) {
+        throw new Error("No url provided");
+      }
+      return $.ajax({
+        url: options.url,
+        type: (_ref = (_ref1 = options.method) != null ? _ref1.toUpperCase() : void 0) != null ? _ref : "GET"
+      }).done(function(content) {
+        return typeof options.onSuccess === "function" ? options.onSuccess(content) : void 0;
+      }).fail(function(request) {
+        return typeof options.onError === "function" ? options.onError("Server responded with status " + request.status) : void 0;
+      }).always(function() {
+        return typeof options.onComplete === "function" ? options.onComplete() : void 0;
+      });
+    };
+
+    Adapter.prototype.clone = function(object) {
+      return $.extend({}, object);
+    };
+
+    Adapter.prototype.extend = function() {
+      var sources, target;
+      target = arguments[0], sources = 2 <= arguments.length ? __slice.call(arguments, 1) : [];
+      return $.extend.apply($, [target].concat(__slice.call(sources)));
+    };
+
+    return Adapter;
+
+  })();
+  return Opentip.addAdapter(new Adapter);
+})(jQuery);
+});
\ No newline at end of file
diff --git "[FORUM_EXT]/vse\\topicimagepreview/styles/FLATBOOTS/template/js/opentip-jquery.min.js" "[FORUM_EXT]/vse\\topicimagepreview/styles/FLATBOOTS/template/js/opentip-jquery.min.js"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/vse\\topicimagepreview/styles/FLATBOOTS/template/js/opentip-jquery.min.js"
@@ -0,0 +1,6 @@
+// Opentip v2.4.6
+// Copyright (c) 2009-2012
+// www.opentip.org
+// MIT Licensed
+head.ready(function(){var Opentip,firstAdapter,i,mouseMoved,mousePosition,mousePositionObservers,position,vendors,_i,_len,_ref,__slice=[].slice,__indexOf=[].indexOf||function(t){for(var e=0,i=this.length;i>e;e++)if(e in this&&this[e]===t)return e;return-1},__hasProp={}.hasOwnProperty;for(Opentip=function(){function t(e,i,o,s){var n,r,a,h,p,d,l,u,c,g,f,m,v,b,w=this;if(this.id=++t.lastId,this.debug("Creating Opentip."),t.tips.push(this),this.adapter=t.adapter,n=this.adapter.data(e,"opentips")||[],n.push(this),this.adapter.data(e,"opentips",n),this.triggerElement=this.adapter.wrap(e),this.triggerElement.length>1)throw Error("You can't call Opentip on multiple elements.");if(1>this.triggerElement.length)throw Error("Invalid element.");this.loaded=!1,this.loading=!1,this.visible=!1,this.waitingToShow=!1,this.waitingToHide=!1,this.currentPosition={left:0,top:0},this.dimensions={width:100,height:50},this.content="",this.redraw=!0,this.currentObservers={showing:!1,visible:!1,hiding:!1,hidden:!1},s=this.adapter.clone(s),typeof i=="object"?(s=i,i=o=void 0):typeof o=="object"&&(s=o,o=void 0),o!=null&&(s.title=o),i!=null&&this.setContent(i),s["extends"]==null&&(s["extends"]=s.style!=null?s.style:t.defaultStyle),h=[s],b=s;while(b["extends"]){if(d=b["extends"],b=t.styles[d],b==null)throw Error("Invalid style: "+d);h.unshift(b),b["extends"]==null&&d!=="standard"&&(b["extends"]="standard")}for(s=(f=this.adapter).extend.apply(f,[{}].concat(__slice.call(h))),s.hideTriggers=function(){var t,e,i,o;for(i=s.hideTriggers,o=[],t=0,e=i.length;e>t;t++)r=i[t],o.push(r);return o}(),s.hideTrigger&&s.hideTriggers.length===0&&s.hideTriggers.push(s.hideTrigger),m=["tipJoint","targetJoint","stem"],l=0,c=m.length;c>l;l++)p=m[l],s[p]&&typeof s[p]=="string"&&(s[p]=new t.Joint(s[p]));for(!s.ajax||s.ajax!==!0&&s.ajax||(s.ajax=this.adapter.tagName(this.triggerElement)==="A"?this.adapter.attr(this.triggerElement,"href"):!1),s.showOn==="click"&&this.adapter.tagName(this.triggerElement)==="A"&&this.adapter.observe(this.triggerElement,"click",function(t){return t.preventDefault(),t.stopPropagation(),t.stopped=!0}),s.target&&(s.fixed=!0),s.stem===!0&&(s.stem=new t.Joint(s.tipJoint)),s.target===!0?s.target=this.triggerElement:s.target&&(s.target=this.adapter.wrap(s.target)),this.currentStem=s.stem,s.delay==null&&(s.delay=s.showOn==="mouseover"?.2:0),s.targetJoint==null&&(s.targetJoint=new t.Joint(s.tipJoint).flip()),this.showTriggers=[],this.showTriggersWhenVisible=[],this.hideTriggers=[],s.showOn&&s.showOn!=="creation"&&this.showTriggers.push({element:this.triggerElement,event:s.showOn}),s.ajaxCache!=null&&(s.cache=s.ajaxCache,delete s.ajaxCache),this.options=s,this.bound={},v=["prepareToShow","prepareToHide","show","hide","reposition"],u=0,g=v.length;g>u;u++)a=v[u],this.bound[a]=function(t){return function(){return w[t].apply(w,arguments)}}(a);this.adapter.domReady(function(){return w.activate(),w.options.showOn==="creation"?w.prepareToShow():void 0})}return t.prototype.STICKS_OUT_TOP=1,t.prototype.STICKS_OUT_BOTTOM=2,t.prototype.STICKS_OUT_LEFT=1,t.prototype.STICKS_OUT_RIGHT=2,t.prototype["class"]={container:"opentip-container",opentip:"opentip",header:"ot-header",content:"ot-content",loadingIndicator:"ot-loading-indicator",close:"ot-close",goingToHide:"ot-going-to-hide",hidden:"ot-hidden",hiding:"ot-hiding",goingToShow:"ot-going-to-show",showing:"ot-showing",visible:"ot-visible",loading:"ot-loading",ajaxError:"ot-ajax-error",fixed:"ot-fixed",showEffectPrefix:"ot-show-effect-",hideEffectPrefix:"ot-hide-effect-",stylePrefix:"style-"},t.prototype._setup=function(){var t,e,i,o,s,n,r,a,h,p,d;for(this.debug("Setting up the tooltip."),this._buildContainer(),this.hideTriggers=[],h=this.options.hideTriggers,o=s=0,r=h.length;r>s;o=++s){if(e=h[o],i=null,t=this.options.hideOn instanceof Array?this.options.hideOn[o]:this.options.hideOn,typeof e=="string")switch(e){case"trigger":t=t||"mouseout",i=this.triggerElement;break;case"tip":t=t||"mouseover",i=this.container;break;case"target":t=t||"mouseover",i=this.options.target;break;case"closeButton":break;default:throw Error("Unknown hide trigger: "+e+".")}else t=t||"mouseover",i=this.adapter.wrap(e);i&&this.hideTriggers.push({element:i,event:t,original:e})}for(p=this.hideTriggers,d=[],n=0,a=p.length;a>n;n++)e=p[n],d.push(this.showTriggersWhenVisible.push({element:e.element,event:"mouseover"}));return d},t.prototype._buildContainer=function(){return this.container=this.adapter.create('<div id="opentip-'+this.id+'" class="'+this["class"].container+" "+this["class"].hidden+" "+this["class"].stylePrefix+this.options.className+'"></div>'),this.adapter.css(this.container,{position:"absolute"}),this.options.ajax&&this.adapter.addClass(this.container,this["class"].loading),this.options.fixed&&this.adapter.addClass(this.container,this["class"].fixed),this.options.showEffect&&this.adapter.addClass(this.container,""+this["class"].showEffectPrefix+this.options.showEffect),this.options.hideEffect?this.adapter.addClass(this.container,""+this["class"].hideEffectPrefix+this.options.hideEffect):void 0},t.prototype._buildElements=function(){var t,e;return this.tooltipElement=this.adapter.create('<div class="'+this["class"].opentip+'"><div class="'+this["class"].header+'"></div><div class="'+this["class"].content+'"></div></div>'),this.backgroundCanvas=this.adapter.wrap(document.createElement("canvas")),this.adapter.css(this.backgroundCanvas,{position:"absolute"}),typeof G_vmlCanvasManager!="undefined"&&G_vmlCanvasManager!==null&&G_vmlCanvasManager.initElement(this.adapter.unwrap(this.backgroundCanvas)),t=this.adapter.find(this.tooltipElement,"."+this["class"].header),this.options.title&&(e=this.adapter.create("<h1></h1>"),this.adapter.update(e,this.options.title,this.options.escapeTitle),this.adapter.append(t,e)),this.options.ajax&&!this.loaded&&this.adapter.append(this.tooltipElement,this.adapter.create('<div class="'+this["class"].loadingIndicator+'"><span>↻</span></div>')),__indexOf.call(this.options.hideTriggers,"closeButton")>=0&&(this.closeButtonElement=this.adapter.create('<a href="javascript:undefined;" class="'+this["class"].close+'"><span>Close</span></a>'),this.adapter.append(t,this.closeButtonElement)),this.adapter.append(this.container,this.backgroundCanvas),this.adapter.append(this.container,this.tooltipElement),this.adapter.append(document.body,this.container),this._newContent=!0,this.redraw=!0},t.prototype.setContent=function(t){return this.content=t,this._newContent=!0,typeof this.content=="function"?(this._contentFunction=this.content,this.content=""):this._contentFunction=null,this.visible?this._updateElementContent():void 0},t.prototype._updateElementContent=function(){var t;return(this._newContent||!this.options.cache&&this._contentFunction)&&(t=this.adapter.find(this.container,"."+this["class"].content),t!=null&&(this._contentFunction&&(this.debug("Executing content function."),this.content=this._contentFunction(this)),this.adapter.update(t,this.content,this.options.escapeContent)),this._newContent=!1),this._storeAndLockDimensions(),this.reposition()},t.prototype._storeAndLockDimensions=function(){var t;if(this.container)return t=this.dimensions,this.adapter.css(this.container,{width:"auto",left:"0px",top:"0px"}),this.dimensions=this.adapter.dimensions(this.container),this.dimensions.width+=1,this.adapter.css(this.container,{width:""+this.dimensions.width+"px",top:""+this.currentPosition.top+"px",left:""+this.currentPosition.left+"px"}),this._dimensionsEqual(this.dimensions,t)?void 0:(this.redraw=!0,this._draw())},t.prototype.activate=function(){return this._setupObservers("hidden","hiding")},t.prototype.deactivate=function(){return this.debug("Deactivating tooltip."),this.hide(),this._setupObservers("-showing","-visible","-hidden","-hiding")},t.prototype._setupObservers=function(){var t,e,i,o,s,n,r,a,h,p,d,l,u,c,g,f,m=this;for(o=arguments.length>=1?__slice.call(arguments,0):[],n=0,p=o.length;p>n;n++)if(i=o[n],e=!1,i.charAt(0)==="-"&&(e=!0,i=i.substr(1)),this.currentObservers[i]!==!e)switch(this.currentObservers[i]=!e,t=function(){var t,i,o;return t=arguments.length>=1?__slice.call(arguments,0):[],e?(i=m.adapter).stopObserving.apply(i,t):(o=m.adapter).observe.apply(o,t)},i){case"showing":for(c=this.hideTriggers,r=0,d=c.length;d>r;r++)s=c[r],t(s.element,s.event,this.bound.prepareToHide);t(document.onresize!=null?document:window,"resize",this.bound.reposition),t(window,"scroll",this.bound.reposition);break;case"visible":for(g=this.showTriggersWhenVisible,a=0,l=g.length;l>a;a++)s=g[a],t(s.element,s.event,this.bound.prepareToShow);break;case"hiding":for(f=this.showTriggers,h=0,u=f.length;u>h;h++)s=f[h],t(s.element,s.event,this.bound.prepareToShow);break;case"hidden":break;default:throw Error("Unknown state: "+i)}return null},t.prototype.prepareToShow=function(){return this._abortHiding(),this._abortShowing(),this.visible?void 0:(this.debug("Showing in "+this.options.delay+"s."),this.container==null&&this._setup(),this.options.group&&t._abortShowingGroup(this.options.group,this),this.preparingToShow=!0,this._setupObservers("-hidden","-hiding","showing"),this._followMousePosition(),this.options.fixed&&!this.options.target&&(this.initialMousePosition=mousePosition),this.reposition(),this._showTimeoutId=this.setTimeout(this.bound.show,this.options.delay||0))},t.prototype.show=function(){var e=this;return this._abortHiding(),this.visible?void 0:(this._clearTimeouts(),this._triggerElementExists()?(this.debug("Showing now."),this.container==null&&this._setup(),this.options.group&&t._hideGroup(this.options.group,this),this.visible=!0,this.preparingToShow=!1,this.tooltipElement==null&&this._buildElements(),this._updateElementContent(),!this.options.ajax||this.loaded&&this.options.cache||this._loadAjax(),this._searchAndActivateCloseButtons(),this._startEnsureTriggerElement(),this.adapter.css(this.container,{zIndex:t.lastZIndex++}),this._setupObservers("-hidden","-hiding","-showing","-visible","showing","visible"),this.options.fixed&&!this.options.target&&(this.initialMousePosition=mousePosition),this.reposition(),this.adapter.removeClass(this.container,this["class"].hiding),this.adapter.removeClass(this.container,this["class"].hidden),this.adapter.addClass(this.container,this["class"].goingToShow),this.setCss3Style(this.container,{transitionDuration:"0s"}),this.defer(function(){var t;if(e.visible&&!e.preparingToHide)return e.adapter.removeClass(e.container,e["class"].goingToShow),e.adapter.addClass(e.container,e["class"].showing),t=0,e.options.showEffect&&e.options.showEffectDuration&&(t=e.options.showEffectDuration),e.setCss3Style(e.container,{transitionDuration:""+t+"s"}),e._visibilityStateTimeoutId=e.setTimeout(function(){return e.adapter.removeClass(e.container,e["class"].showing),e.adapter.addClass(e.container,e["class"].visible)},t),e._activateFirstInput()}),this._draw()):this.deactivate())},t.prototype._abortShowing=function(){return this.preparingToShow?(this.debug("Aborting showing."),this._clearTimeouts(),this._stopFollowingMousePosition(),this.preparingToShow=!1,this._setupObservers("-showing","-visible","hiding","hidden")):void 0},t.prototype.prepareToHide=function(){return this._abortShowing(),this._abortHiding(),this.visible?(this.debug("Hiding in "+this.options.hideDelay+"s"),this.preparingToHide=!0,this._setupObservers("-showing","visible","-hidden","hiding"),this._hideTimeoutId=this.setTimeout(this.bound.hide,this.options.hideDelay)):void 0},t.prototype.hide=function(){var t=this;return this._abortShowing(),this.visible&&(this._clearTimeouts(),this.debug("Hiding!"),this.visible=!1,this.preparingToHide=!1,this._stopEnsureTriggerElement(),this._setupObservers("-showing","-visible","-hiding","-hidden","hiding","hidden"),this.options.fixed||this._stopFollowingMousePosition(),this.container)?(this.adapter.removeClass(this.container,this["class"].visible),this.adapter.removeClass(this.container,this["class"].showing),this.adapter.addClass(this.container,this["class"].goingToHide),this.setCss3Style(this.container,{transitionDuration:"0s"}),this.defer(function(){var e;return t.adapter.removeClass(t.container,t["class"].goingToHide),t.adapter.addClass(t.container,t["class"].hiding),e=0,t.options.hideEffect&&t.options.hideEffectDuration&&(e=t.options.hideEffectDuration),t.setCss3Style(t.container,{transitionDuration:""+e+"s"}),t._visibilityStateTimeoutId=t.setTimeout(function(){return t.adapter.removeClass(t.container,t["class"].hiding),t.adapter.addClass(t.container,t["class"].hidden),t.setCss3Style(t.container,{transitionDuration:"0s"}),t.options.removeElementsOnHide?(t.debug("Removing HTML elements."),t.adapter.remove(t.container),delete t.container,delete t.tooltipElement):void 0},e)})):void 0},t.prototype._abortHiding=function(){return this.preparingToHide?(this.debug("Aborting hiding."),this._clearTimeouts(),this.preparingToHide=!1,this._setupObservers("-hiding","showing","visible")):void 0},t.prototype.reposition=function(){var t,e,i,o=this;return t=this.getPosition(),t==null||(e=this.options.stem,this.options.containInViewport&&(i=this._ensureViewportContainment(t),t=i.position,e=i.stem),this._positionsEqual(t,this.currentPosition))?void 0:(this.options.stem&&!e.eql(this.currentStem)&&(this.redraw=!0),this.currentPosition=t,this.currentStem=e,this._draw(),this.adapter.css(this.container,{left:""+t.left+"px",top:""+t.top+"px"}),this.defer(function(){var t,e;return t=o.adapter.unwrap(o.container),t.style.visibility="hidden",e=t.offsetHeight,t.style.visibility="visible"}))},t.prototype.getPosition=function(t,e,i){var o,s,n,r,a,h,p,d,l;if(this.container)return t==null&&(t=this.options.tipJoint),e==null&&(e=this.options.targetJoint),r={},this.options.target?(p=this.adapter.offset(this.options.target),h=this.adapter.dimensions(this.options.target),r=p,e.right?(d=this.adapter.unwrap(this.options.target),d.getBoundingClientRect!=null?r.left=d.getBoundingClientRect().right+((l=window.pageXOffset)!=null?l:document.body.scrollLeft):r.left+=h.width):e.center&&(r.left+=Math.round(h.width/2)),e.bottom?r.top+=h.height:e.middle&&(r.top+=Math.round(h.height/2)),this.options.borderWidth&&(this.options.tipJoint.left&&(r.left+=this.options.borderWidth),this.options.tipJoint.right&&(r.left-=this.options.borderWidth),this.options.tipJoint.top?r.top+=this.options.borderWidth:this.options.tipJoint.bottom&&(r.top-=this.options.borderWidth))):r=this.initialMousePosition?{top:this.initialMousePosition.y,left:this.initialMousePosition.x}:{top:mousePosition.y,left:mousePosition.x},this.options.autoOffset&&(a=this.options.stem?this.options.stemLength:0,n=a&&this.options.fixed?2:10,o=t.middle&&!this.options.fixed?15:0,s=t.center&&!this.options.fixed?15:0,t.right?r.left-=n+o:t.left&&(r.left+=n+o),t.bottom?r.top-=n+s:t.top&&(r.top+=n+s),a&&(i==null&&(i=this.options.stem),i.right?r.left-=a:i.left&&(r.left+=a),i.bottom?r.top-=a:i.top&&(r.top+=a))),r.left+=this.options.offset[0],r.top+=this.options.offset[1],t.right?r.left-=this.dimensions.width:t.center&&(r.left-=Math.round(this.dimensions.width/2)),t.bottom?r.top-=this.dimensions.height:t.middle&&(r.top-=Math.round(this.dimensions.height/2)),r},t.prototype._ensureViewportContainment=function(e){var i,o,s,n,r,a,h,p,d,l,u,c;if(h=this.options.stem,s={position:e,stem:h},!this.visible||!e)return s;if(p=this._sticksOut(e),!p[0]&&!p[1])return s;if(l=new t.Joint(this.options.tipJoint),this.options.targetJoint&&(d=new t.Joint(this.options.targetJoint)),a=this.adapter.scrollOffset(),u=this.adapter.viewportDimensions(),c=[e.left-a[0],e.top-a[1]],i=!1,u.width>=this.dimensions.width&&p[0])switch(i=!0,p[0]){case this.STICKS_OUT_LEFT:l.setHorizontal("left"),this.options.targetJoint&&d.setHorizontal("right");break;case this.STICKS_OUT_RIGHT:l.setHorizontal("right"),this.options.targetJoint&&d.setHorizontal("left")}if(u.height>=this.dimensions.height&&p[1])switch(i=!0,p[1]){case this.STICKS_OUT_TOP:l.setVertical("top"),this.options.targetJoint&&d.setVertical("bottom");break;case this.STICKS_OUT_BOTTOM:l.setVertical("bottom"),this.options.targetJoint&&d.setVertical("top")}return i?(this.options.stem&&(h=l),e=this.getPosition(l,d,h),o=this._sticksOut(e),n=!1,r=!1,o[0]&&o[0]!==p[0]&&(n=!0,l.setHorizontal(this.options.tipJoint.horizontal),this.options.targetJoint&&d.setHorizontal(this.options.targetJoint.horizontal)),o[1]&&o[1]!==p[1]&&(r=!0,l.setVertical(this.options.tipJoint.vertical),this.options.targetJoint&&d.setVertical(this.options.targetJoint.vertical)),n&&r?s:((n||r)&&(this.options.stem&&(h=l),e=this.getPosition(l,d,h)),{position:e,stem:h})):s},t.prototype._sticksOut=function(t){var e,i,o,s;return i=this.adapter.scrollOffset(),s=this.adapter.viewportDimensions(),e=[t.left-i[0],t.top-i[1]],o=[!1,!1],0>e[0]?o[0]=this.STICKS_OUT_LEFT:e[0]+this.dimensions.width>s.width&&(o[0]=this.STICKS_OUT_RIGHT),0>e[1]?o[1]=this.STICKS_OUT_TOP:e[1]+this.dimensions.height>s.height&&(o[1]=this.STICKS_OUT_BOTTOM),o},t.prototype._draw=function(){var e,i,o,s,n,r,a,h,p,d,l,u,c,g,f,m,v,b,w,_=this;if(this.backgroundCanvas&&this.redraw){if(this.debug("Drawing background."),this.redraw=!1,this.currentStem){for(v=["top","right","bottom","left"],f=0,m=v.length;m>f;f++)u=v[f],this.adapter.removeClass(this.container,"stem-"+u);this.adapter.addClass(this.container,"stem-"+this.currentStem.horizontal),this.adapter.addClass(this.container,"stem-"+this.currentStem.vertical)}return r=[0,0],a=[0,0],__indexOf.call(this.options.hideTriggers,"closeButton")>=0&&(n=new t.Joint(((b=this.currentStem)!=null?b+"":void 0)==="top right"?"top left":"top right"),r=[this.options.closeButtonRadius+this.options.closeButtonOffset[0],this.options.closeButtonRadius+this.options.closeButtonOffset[1]],a=[this.options.closeButtonRadius-this.options.closeButtonOffset[0],this.options.closeButtonRadius-this.options.closeButtonOffset[1]]),o=this.adapter.clone(this.dimensions),s=[0,0],this.options.borderWidth&&(o.width+=this.options.borderWidth*2,o.height+=this.options.borderWidth*2,s[0]-=this.options.borderWidth,s[1]-=this.options.borderWidth),this.options.shadow&&(o.width+=this.options.shadowBlur*2,o.width+=Math.max(0,this.options.shadowOffset[0]-this.options.shadowBlur*2),o.height+=this.options.shadowBlur*2,o.height+=Math.max(0,this.options.shadowOffset[1]-this.options.shadowBlur*2),s[0]-=Math.max(0,this.options.shadowBlur-this.options.shadowOffset[0]),s[1]-=Math.max(0,this.options.shadowBlur-this.options.shadowOffset[1])),i={left:0,right:0,top:0,bottom:0},this.currentStem&&(this.currentStem.left?i.left=this.options.stemLength:this.currentStem.right&&(i.right=this.options.stemLength),this.currentStem.top?i.top=this.options.stemLength:this.currentStem.bottom&&(i.bottom=this.options.stemLength)),n&&(n.left?i.left=Math.max(i.left,a[0]):n.right&&(i.right=Math.max(i.right,a[0])),n.top?i.top=Math.max(i.top,a[1]):n.bottom&&(i.bottom=Math.max(i.bottom,a[1]))),o.width+=i.left+i.right,o.height+=i.top+i.bottom,s[0]-=i.left,s[1]-=i.top,this.currentStem&&this.options.borderWidth&&(w=this._getPathStemMeasures(this.options.stemBase,this.options.stemLength,this.options.borderWidth),g=w.stemLength,c=w.stemBase),e=this.adapter.unwrap(this.backgroundCanvas),e.width=o.width,e.height=o.height,this.adapter.css(this.backgroundCanvas,{width:""+e.width+"px",height:""+e.height+"px",left:""+s[0]+"px",top:""+s[1]+"px"}),h=e.getContext("2d"),h.setTransform(1,0,0,1,0,0),h.clearRect(0,0,e.width,e.height),h.beginPath(),h.fillStyle=this._getColor(h,this.dimensions,this.options.background,this.options.backgroundGradientHorizontal),h.lineJoin="miter",h.miterLimit=500,l=this.options.borderWidth/2,this.options.borderWidth?(h.strokeStyle=this.options.borderColor,h.lineWidth=this.options.borderWidth):(g=this.options.stemLength,c=this.options.stemBase),c==null&&(c=0),d=function(t,e,i){return i&&h.moveTo(Math.max(c,_.options.borderRadius,r[0])+1-l,-l),e?(h.lineTo(t/2-c/2,-l),h.lineTo(t/2,-g-l),h.lineTo(t/2+c/2,-l)):void 0},p=function(t,e,i){var o,s,n,a;return t?(h.lineTo(-c+l,0-l),h.lineTo(g+l,-g-l),h.lineTo(l,c-l)):e?(a=_.options.closeButtonOffset,n=r[0],i%2!==0&&(a=[a[1],a[0]],n=r[1]),o=Math.acos(a[1]/_.options.closeButtonRadius),s=Math.acos(a[0]/_.options.closeButtonRadius),h.lineTo(-n+l,-l),h.arc(l-a[0],-l+a[1],_.options.closeButtonRadius,-(Math.PI/2+o),s,!1)):(h.lineTo(-_.options.borderRadius+l,-l),h.quadraticCurveTo(l,-l,l,_.options.borderRadius-l))},h.translate(-s[0],-s[1]),h.save(),function(){var e,i,o,s,r,a,l,u,c,g,f;for(f=[],i=c=0,g=t.positions.length/2;g>=0?g>c:c>g;i=g>=0?++c:--c)r=i*2,a=i===0||i===3?0:_.dimensions.width,l=2>i?0:_.dimensions.height,u=Math.PI/2*i,o=i%2===0?_.dimensions.width:_.dimensions.height,s=new t.Joint(t.positions[r]),e=new t.Joint(t.positions[r+1]),h.save(),h.translate(a,l),h.rotate(u),d(o,s.eql(_.currentStem),i===0),h.translate(o,0),p(e.eql(_.currentStem),e.eql(n),i),f.push(h.restore());return f}(),h.closePath(),h.save(),this.options.shadow&&(h.shadowColor=this.options.shadowColor,h.shadowBlur=this.options.shadowBlur,h.shadowOffsetX=this.options.shadowOffset[0],h.shadowOffsetY=this.options.shadowOffset[1]),h.fill(),h.restore(),this.options.borderWidth&&h.stroke(),h.restore(),n?function(){var t,e,i,o,s;return i=e=_.options.closeButtonRadius*2,n+""=="top right"?(s=[_.dimensions.width-_.options.closeButtonOffset[0],_.options.closeButtonOffset[1]],t=[s[0]+l,s[1]-l]):(s=[_.options.closeButtonOffset[0],_.options.closeButtonOffset[1]],t=[s[0]-l,s[1]-l]),h.translate(t[0],t[1]),o=_.options.closeButtonCrossSize/2,h.save(),h.beginPath(),h.strokeStyle=_.options.closeButtonCrossColor,h.lineWidth=_.options.closeButtonCrossLineWidth,h.lineCap="round",h.moveTo(-o,-o),h.lineTo(o,o),h.stroke(),h.beginPath(),h.moveTo(o,-o),h.lineTo(-o,o),h.stroke(),h.restore(),_.adapter.css(_.closeButtonElement,{left:""+(s[0]-o-_.options.closeButtonLinkOverscan)+"px",top:""+(s[1]-o-_.options.closeButtonLinkOverscan)+"px",width:""+(_.options.closeButtonCrossSize+_.options.closeButtonLinkOverscan*2)+"px",height:""+(_.options.closeButtonCrossSize+_.options.closeButtonLinkOverscan*2)+"px"})}():void 0}},t.prototype._getPathStemMeasures=function(t,e,i){var o,s,n,r,a,h,p;if(r=i/2,n=Math.atan(t/2/e),o=n*2,a=r/Math.sin(o),s=2*a*Math.cos(n),p=r+e-s,0>p)throw Error("Sorry but your stemLength / stemBase ratio is strange.");return h=Math.tan(n)*p*2,{stemLength:p,stemBase:h}},t.prototype._getColor=function(t,e,i,o){var s,n,r,a,h;if(o==null&&(o=!1),typeof i=="string")return i;for(n=o?t.createLinearGradient(0,0,e.width,0):t.createLinearGradient(0,0,0,e.height),r=a=0,h=i.length;h>a;r=++a)s=i[r],n.addColorStop(s[0],s[1]);return n},t.prototype._searchAndActivateCloseButtons=function(){var t,e,i,o;for(o=this.adapter.findAll(this.container,"."+this["class"].close),e=0,i=o.length;i>e;e++)t=o[e],this.hideTriggers.push({element:this.adapter.wrap(t),event:"click"});return this.currentObservers.showing&&this._setupObservers("-showing","showing"),this.currentObservers.visible?this._setupObservers("-visible","visible"):void 0},t.prototype._activateFirstInput=function(){var t;return t=this.adapter.unwrap(this.adapter.find(this.container,"input, textarea")),t!=null?typeof t.focus=="function"?t.focus():void 0:void 0},t.prototype._followMousePosition=function(){return this.options.fixed?void 0:t._observeMousePosition(this.bound.reposition)},t.prototype._stopFollowingMousePosition=function(){return this.options.fixed?void 0:t._stopObservingMousePosition(this.bound.reposition)},t.prototype._clearShowTimeout=function(){return clearTimeout(this._showTimeoutId)},t.prototype._clearHideTimeout=function(){return clearTimeout(this._hideTimeoutId)},t.prototype._clearTimeouts=function(){return clearTimeout(this._visibilityStateTimeoutId),this._clearShowTimeout(),this._clearHideTimeout()},t.prototype._triggerElementExists=function(){var t;t=this.adapter.unwrap(this.triggerElement);while(t.parentNode){if(t.parentNode.tagName==="BODY")return!0;t=t.parentNode}return!1},t.prototype._loadAjax=function(){var t=this;if(!this.loading)return this.loaded=!1,this.loading=!0,this.adapter.addClass(this.container,this["class"].loading),this.setContent(""),this.debug("Loading content from "+this.options.ajax),this.adapter.ajax({url:this.options.ajax,method:this.options.ajaxMethod,onSuccess:function(e){return t.debug("Loading successful."),t.adapter.removeClass(t.container,t["class"].loading),t.setContent(e)},onError:function(e){var i;return i=t.options.ajaxErrorMessage,t.debug(i,e),t.setContent(i),t.adapter.addClass(t.container,t["class"].ajaxError)},onComplete:function(){return t.adapter.removeClass(t.container,t["class"].loading),t.loading=!1,t.loaded=!0,t._searchAndActivateCloseButtons(),t._activateFirstInput(),t.reposition()}})},t.prototype._ensureTriggerElement=function(){return this._triggerElementExists()?void 0:(this.deactivate(),this._stopEnsureTriggerElement())},t.prototype._ensureTriggerElementInterval=1e3,t.prototype._startEnsureTriggerElement=function(){var t=this;return this._ensureTriggerElementTimeoutId=setInterval(function(){return t._ensureTriggerElement()},this._ensureTriggerElementInterval)},t.prototype._stopEnsureTriggerElement=function(){return clearInterval(this._ensureTriggerElementTimeoutId)},t}(),vendors=["khtml","ms","o","moz","webkit"],Opentip.prototype.setCss3Style=function(t,e){var i,o,s,n,r;t=this.adapter.unwrap(t),r=[];for(i in e)__hasProp.call(e,i)&&(o=e[i],t.style[i]!=null?r.push(t.style[i]=o):r.push(function(){var e,r,a;for(a=[],e=0,r=vendors.length;r>e;e++)s=vendors[e],n=""+this.ucfirst(s)+this.ucfirst(i),t.style[n]!=null?a.push(t.style[n]=o):a.push(void 0);return a}.call(this)));return r},Opentip.prototype.defer=function(t){return setTimeout(t,0)},Opentip.prototype.setTimeout=function(t,e){return setTimeout(t,e?e*1e3:0)},Opentip.prototype.ucfirst=function(t){return t==null?"":t.charAt(0).toUpperCase()+t.slice(1)},Opentip.prototype.dasherize=function(t){return t.replace(/([A-Z])/g,function(t,e){return"-"+e.toLowerCase()})},mousePositionObservers=[],mousePosition={x:0,y:0},mouseMoved=function(t){var e,i,o,s;for(mousePosition=Opentip.adapter.mousePosition(t),s=[],i=0,o=mousePositionObservers.length;o>i;i++)e=mousePositionObservers[i],s.push(e());return s},Opentip.followMousePosition=function(){return Opentip.adapter.observe(document.body,"mousemove",mouseMoved)},Opentip._observeMousePosition=function(t){return mousePositionObservers.push(t)},Opentip._stopObservingMousePosition=function(t){var e;return mousePositionObservers=function(){var i,o,s;for(s=[],i=0,o=mousePositionObservers.length;o>i;i++)e=mousePositionObservers[i],e!==t&&s.push(e);return s}()},Opentip.Joint=function(){function t(t){t!=null&&(t instanceof Opentip.Joint&&(t+=""),this.set(t))}return t.prototype.set=function(t){return t=t.toLowerCase(),this.setHorizontal(t),this.setVertical(t),this},t.prototype.setHorizontal=function(t){var e,i,o,s,n,r,a;for(i=["left","center","right"],o=0,n=i.length;n>o;o++)e=i[o],~t.indexOf(e)&&(this.horizontal=e.toLowerCase());for(this.horizontal==null&&(this.horizontal="center"),a=[],s=0,r=i.length;r>s;s++)e=i[s],a.push(this[e]=this.horizontal===e?e:void 0);return a},t.prototype.setVertical=function(t){var e,i,o,s,n,r,a;for(i=["top","middle","bottom"],o=0,n=i.length;n>o;o++)e=i[o],~t.indexOf(e)&&(this.vertical=e.toLowerCase());for(this.vertical==null&&(this.vertical="middle"),a=[],s=0,r=i.length;r>s;s++)e=i[s],a.push(this[e]=this.vertical===e?e:void 0);return a},t.prototype.eql=function(t){return t!=null&&this.horizontal===t.horizontal&&this.vertical===t.vertical},t.prototype.flip=function(){var t,e;return e=Opentip.position[this.toString(!0)],t=(e+4)%8,this.set(Opentip.positions[t]),this},t.prototype.toString=function(t){var e,i;return t==null&&(t=!1),i=this.vertical==="middle"?"":this.vertical,e=this.horizontal==="center"?"":this.horizontal,i&&e&&(e=t?Opentip.prototype.ucfirst(e):" "+e),""+i+e},t}(),Opentip.prototype._positionsEqual=function(t,e){return t!=null&&e!=null&&t.left===e.left&&t.top===e.top},Opentip.prototype._dimensionsEqual=function(t,e){return t!=null&&e!=null&&t.width===e.width&&t.height===e.height},Opentip.prototype.debug=function(){var t;return t=arguments.length>=1?__slice.call(arguments,0):[],Opentip.debug&&(typeof console!="undefined"&&console!==null?console.debug:void 0)!=null?(t.unshift("#"+this.id+" |"),console.debug.apply(console,t)):void 0},Opentip.findElements=function(){var t,e,i,o,s,n,r,a,h,p;for(t=Opentip.adapter,h=t.findAll(document.body,"[data-ot]"),p=[],r=0,a=h.length;a>r;r++){i=h[r],n={},e=t.data(i,"ot"),(e===""||e==="true"||e==="yes")&&(e=t.attr(i,"title"),t.attr(i,"title","")),e=e||"";for(o in Opentip.styles.standard)s=t.data(i,"ot"+Opentip.prototype.ucfirst(o)),s!=null&&(s==="yes"||s==="true"||s==="on"?s=!0:(s==="no"||s==="false"||s==="off")&&(s=!1),n[o]=s);p.push(new Opentip(i,e,n))}return p},Opentip.version="2.4.6",Opentip.debug=!1,Opentip.lastId=0,Opentip.lastZIndex=100,Opentip.tips=[],Opentip._abortShowingGroup=function(t,e){var i,o,s,n,r;for(n=Opentip.tips,r=[],o=0,s=n.length;s>o;o++)i=n[o],i!==e&&i.options.group===t?r.push(i._abortShowing()):r.push(void 0);return r},Opentip._hideGroup=function(t,e){var i,o,s,n,r;for(n=Opentip.tips,r=[],o=0,s=n.length;s>o;o++)i=n[o],i!==e&&i.options.group===t?r.push(i.hide()):r.push(void 0);return r},Opentip.adapters={},Opentip.adapter=null,firstAdapter=!0,Opentip.addAdapter=function(t){return Opentip.adapters[t.name]=t,firstAdapter?(Opentip.adapter=t,t.domReady(Opentip.findElements),t.domReady(Opentip.followMousePosition),firstAdapter=!1):void 0},Opentip.positions=["top","topRight","right","bottomRight","bottom","bottomLeft","left","topLeft"],Opentip.position={},_ref=Opentip.positions,i=_i=0,_len=_ref.length;_len>_i;i=++_i)position=_ref[i],Opentip.position[position]=i;Opentip.styles={standard:{"extends":null,title:void 0,escapeTitle:!0,escapeContent:!1,className:"standard",stem:!0,delay:null,hideDelay:.1,fixed:!1,showOn:"mouseover",hideTrigger:"trigger",hideTriggers:[],hideOn:null,removeElementsOnHide:!1,offset:[0,0],containInViewport:!0,autoOffset:!0,showEffect:"appear",hideEffect:"fade",showEffectDuration:.3,hideEffectDuration:.2,stemLength:5,stemBase:8,tipJoint:"top left",target:null,targetJoint:null,cache:!0,ajax:!1,ajaxMethod:"GET",ajaxErrorMessage:"There was a problem downloading the content.",group:null,style:null,background:"#fff18f",backgroundGradientHorizontal:!1,closeButtonOffset:[5,5],closeButtonRadius:7,closeButtonCrossSize:4,closeButtonCrossColor:"#d2c35b",closeButtonCrossLineWidth:1.5,closeButtonLinkOverscan:6,borderRadius:5,borderWidth:1,borderColor:"#f2e37b",shadow:!0,shadowBlur:10,shadowOffset:[3,3],shadowColor:"rgba(0, 0, 0, 0.1)"},glass:{"extends":"standard",className:"glass",background:[[0,"rgba(252, 252, 252, 0.8)"],[.5,"rgba(255, 255, 255, 0.8)"],[.5,"rgba(250, 250, 250, 0.9)"],[1,"rgba(245, 245, 245, 0.9)"]],borderColor:"#eee",closeButtonCrossColor:"rgba(0, 0, 0, 0.2)",borderRadius:15,closeButtonRadius:10,closeButtonOffset:[8,8]},dark:{"extends":"standard",className:"dark",borderRadius:13,borderColor:"#444",closeButtonCrossColor:"rgba(240, 240, 240, 1)",shadowColor:"rgba(0, 0, 0, 0.3)",shadowOffset:[2,2],background:[[0,"rgba(30, 30, 30, 0.7)"],[.5,"rgba(30, 30, 30, 0.8)"],[.5,"rgba(10, 10, 10, 0.8)"],[1,"rgba(10, 10, 10, 0.9)"]]},alert:{"extends":"standard",className:"alert",borderRadius:1,borderColor:"#AE0D11",closeButtonCrossColor:"rgba(255, 255, 255, 1)",shadowColor:"rgba(0, 0, 0, 0.3)",shadowOffset:[2,2],background:[[0,"rgba(203, 15, 19, 0.7)"],[.5,"rgba(203, 15, 19, 0.8)"],[.5,"rgba(189, 14, 18, 0.8)"],[1,"rgba(179, 14, 17, 0.9)"]]}},Opentip.defaultStyle="standard",typeof module!="undefined"&&module!==null?module.exports=Opentip:window.Opentip=Opentip;var __slice=[].slice;(function(t){var e;return t.fn.opentip=function(t,e,i){return new Opentip(this,t,e,i)},e=function(){function e(){}return e.prototype.name="jquery",e.prototype.domReady=function(e){return t(e)},e.prototype.create=function(e){return t(e)},e.prototype.wrap=function(e){if(e=t(e),e.length>1)throw Error("Multiple elements provided.");return e},e.prototype.unwrap=function(e){return t(e)[0]
+},e.prototype.tagName=function(t){return this.unwrap(t).tagName},e.prototype.attr=function(){var e,i,o;return i=arguments[0],e=arguments.length>=2?__slice.call(arguments,1):[],(o=t(i)).attr.apply(o,e)},e.prototype.data=function(){var e,i,o;return i=arguments[0],e=arguments.length>=2?__slice.call(arguments,1):[],(o=t(i)).data.apply(o,e)},e.prototype.find=function(e,i){return t(e).find(i).get(0)},e.prototype.findAll=function(e,i){return t(e).find(i)},e.prototype.update=function(e,i,o){return e=t(e),o?e.text(i):e.html(i)},e.prototype.append=function(e,i){return t(e).append(i)},e.prototype.remove=function(e){return t(e).remove()},e.prototype.addClass=function(e,i){return t(e).addClass(i)},e.prototype.removeClass=function(e,i){return t(e).removeClass(i)},e.prototype.css=function(e,i){return t(e).css(i)},e.prototype.dimensions=function(e){return{width:t(e).outerWidth(),height:t(e).outerHeight()}},e.prototype.scrollOffset=function(){return[window.pageXOffset||document.documentElement.scrollLeft||document.body.scrollLeft,window.pageYOffset||document.documentElement.scrollTop||document.body.scrollTop]},e.prototype.viewportDimensions=function(){return{width:document.documentElement.clientWidth,height:document.documentElement.clientHeight}},e.prototype.mousePosition=function(t){return t==null?null:{x:t.pageX,y:t.pageY}},e.prototype.offset=function(e){var i;return i=t(e).offset(),{left:i.left,top:i.top}},e.prototype.observe=function(e,i,o){return t(e).bind(i,o)},e.prototype.stopObserving=function(e,i,o){return t(e).unbind(i,o)},e.prototype.ajax=function(e){var i,o;if(e.url==null)throw Error("No url provided");return t.ajax({url:e.url,type:(i=(o=e.method)!=null?o.toUpperCase():void 0)!=null?i:"GET"}).done(function(t){return typeof e.onSuccess=="function"?e.onSuccess(t):void 0}).fail(function(t){return typeof e.onError=="function"?e.onError("Server responded with status "+t.status):void 0}).always(function(){return typeof e.onComplete=="function"?e.onComplete():void 0})},e.prototype.clone=function(e){return t.extend({},e)},e.prototype.extend=function(){var e,i;return i=arguments[0],e=arguments.length>=2?__slice.call(arguments,1):[],t.extend.apply(t,[i].concat(__slice.call(e)))},e}(),Opentip.addAdapter(new e)})(jQuery)});
\ No newline at end of file
diff --git "[FORUM_EXT]/vse\\topicimagepreview/styles/FLATBOOTS/theme/opentip.css" "[FORUM_EXT]/vse\\topicimagepreview/styles/FLATBOOTS/theme/opentip.css"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/vse\\topicimagepreview/styles/FLATBOOTS/theme/opentip.css"
@@ -0,0 +1,278 @@
+.opentip-container,
+.opentip-container * {
+  -webkit-box-sizing: border-box;
+  -moz-box-sizing: border-box;
+  box-sizing: border-box;
+}
+.opentip-container {
+  position: absolute;
+  max-width: 300px;
+  z-index: 100;
+  -webkit-transition: -webkit-transform 1s ease-in-out;
+  -moz-transition: -moz-transform 1s ease-in-out;
+  -o-transition: -o-transform 1s ease-in-out;
+  -ms-transition: -ms-transform 1s ease-in-out;
+  transition: transform 1s ease-in-out;
+  pointer-events: none;
+  -webkit-transform: translateX(0) translateY(0);
+  -moz-transform: translateX(0) translateY(0);
+  -o-transform: translateX(0) translateY(0);
+  -ms-transform: translateX(0) translateY(0);
+  transform: translateX(0) translateY(0);
+}
+.opentip-container.ot-fixed.ot-hidden.stem-top.stem-center,
+.opentip-container.ot-fixed.ot-going-to-show.stem-top.stem-center,
+.opentip-container.ot-fixed.ot-hiding.stem-top.stem-center {
+  -webkit-transform: translateY(-5px);
+  -moz-transform: translateY(-5px);
+  -o-transform: translateY(-5px);
+  -ms-transform: translateY(-5px);
+  transform: translateY(-5px);
+}
+.opentip-container.ot-fixed.ot-hidden.stem-top.stem-right,
+.opentip-container.ot-fixed.ot-going-to-show.stem-top.stem-right,
+.opentip-container.ot-fixed.ot-hiding.stem-top.stem-right {
+  -webkit-transform: translateY(-5px) translateX(5px);
+  -moz-transform: translateY(-5px) translateX(5px);
+  -o-transform: translateY(-5px) translateX(5px);
+  -ms-transform: translateY(-5px) translateX(5px);
+  transform: translateY(-5px) translateX(5px);
+}
+.opentip-container.ot-fixed.ot-hidden.stem-middle.stem-right,
+.opentip-container.ot-fixed.ot-going-to-show.stem-middle.stem-right,
+.opentip-container.ot-fixed.ot-hiding.stem-middle.stem-right {
+  -webkit-transform: translateX(5px);
+  -moz-transform: translateX(5px);
+  -o-transform: translateX(5px);
+  -ms-transform: translateX(5px);
+  transform: translateX(5px);
+}
+.opentip-container.ot-fixed.ot-hidden.stem-bottom.stem-right,
+.opentip-container.ot-fixed.ot-going-to-show.stem-bottom.stem-right,
+.opentip-container.ot-fixed.ot-hiding.stem-bottom.stem-right {
+  -webkit-transform: translateY(5px) translateX(5px);
+  -moz-transform: translateY(5px) translateX(5px);
+  -o-transform: translateY(5px) translateX(5px);
+  -ms-transform: translateY(5px) translateX(5px);
+  transform: translateY(5px) translateX(5px);
+}
+.opentip-container.ot-fixed.ot-hidden.stem-bottom.stem-center,
+.opentip-container.ot-fixed.ot-going-to-show.stem-bottom.stem-center,
+.opentip-container.ot-fixed.ot-hiding.stem-bottom.stem-center {
+  -webkit-transform: translateY(5px);
+  -moz-transform: translateY(5px);
+  -o-transform: translateY(5px);
+  -ms-transform: translateY(5px);
+  transform: translateY(5px);
+}
+.opentip-container.ot-fixed.ot-hidden.stem-bottom.stem-left,
+.opentip-container.ot-fixed.ot-going-to-show.stem-bottom.stem-left,
+.opentip-container.ot-fixed.ot-hiding.stem-bottom.stem-left {
+  -webkit-transform: translateY(5px) translateX(-5px);
+  -moz-transform: translateY(5px) translateX(-5px);
+  -o-transform: translateY(5px) translateX(-5px);
+  -ms-transform: translateY(5px) translateX(-5px);
+  transform: translateY(5px) translateX(-5px);
+}
+.opentip-container.ot-fixed.ot-hidden.stem-middle.stem-left,
+.opentip-container.ot-fixed.ot-going-to-show.stem-middle.stem-left,
+.opentip-container.ot-fixed.ot-hiding.stem-middle.stem-left {
+  -webkit-transform: translateX(-5px);
+  -moz-transform: translateX(-5px);
+  -o-transform: translateX(-5px);
+  -ms-transform: translateX(-5px);
+  transform: translateX(-5px);
+}
+.opentip-container.ot-fixed.ot-hidden.stem-top.stem-left,
+.opentip-container.ot-fixed.ot-going-to-show.stem-top.stem-left,
+.opentip-container.ot-fixed.ot-hiding.stem-top.stem-left {
+  -webkit-transform: translateY(-5px) translateX(-5px);
+  -moz-transform: translateY(-5px) translateX(-5px);
+  -o-transform: translateY(-5px) translateX(-5px);
+  -ms-transform: translateY(-5px) translateX(-5px);
+  transform: translateY(-5px) translateX(-5px);
+}
+.opentip-container.ot-fixed .opentip {
+  pointer-events: auto;
+}
+.opentip-container.ot-hidden {
+  display: none;
+}
+.opentip-container .opentip {
+  position: relative;
+  font-size: 13px;
+  line-height: 120%;
+  padding: 9px 14px;
+  color: #4f4b47;
+  text-shadow: -1px -1px 0px rgba(255,255,255,0.2);
+}
+.opentip-container .opentip .header {
+  margin: 0;
+  padding: 0;
+}
+.opentip-container .opentip .ot-close {
+  pointer-events: auto;
+  display: block;
+  position: absolute;
+  top: -12px;
+  left: 60px;
+  color: rgba(0,0,0,0.5);
+  background: rgba(0,0,0,0);
+  text-decoration: none;
+}
+.opentip-container .opentip .ot-close span {
+  display: none;
+}
+.opentip-container .opentip .ot-loading-indicator {
+  display: none;
+}
+.opentip-container.ot-loading .ot-loading-indicator {
+  width: 30px;
+  height: 30px;
+  font-size: 30px;
+  line-height: 30px;
+  font-weight: bold;
+  display: block;
+}
+.opentip-container.ot-loading .ot-loading-indicator span {
+  display: block;
+  -webkit-animation: otloading 2s linear infinite;
+  -moz-animation: otloading 2s linear infinite;
+  -o-animation: otloading 2s linear infinite;
+  -ms-animation: otloading 2s linear infinite;
+  animation: otloading 2s linear infinite;
+  text-align: center;
+}
+.opentip-container.style-dark .opentip,
+.opentip-container.style-alert .opentip {
+  color: #f8f8f8;
+  text-shadow: 1px 1px 0px rgba(0,0,0,0.2);
+}
+.opentip-container.style-glass .opentip {
+  padding: 15px 25px;
+  color: #317cc5;
+  text-shadow: 1px 1px 8px rgba(0,94,153,0.3);
+}
+.opentip-container.ot-hide-effect-fade {
+  -webkit-transition: -webkit-transform 0.5s ease-in-out, opacity 1s ease-in-out;
+  -moz-transition: -moz-transform 0.5s ease-in-out, opacity 1s ease-in-out;
+  -o-transition: -o-transform 0.5s ease-in-out, opacity 1s ease-in-out;
+  -ms-transition: -ms-transform 0.5s ease-in-out, opacity 1s ease-in-out;
+  transition: transform 0.5s ease-in-out, opacity 1s ease-in-out;
+  opacity: 1;
+  -ms-filter: none;
+  filter: none;
+}
+.opentip-container.ot-hide-effect-fade.ot-hiding {
+  opacity: 0;
+  filter: alpha(opacity=0);
+  -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";
+}
+.opentip-container.ot-show-effect-appear.ot-going-to-show,
+.opentip-container.ot-show-effect-appear.ot-showing {
+  -webkit-transition: -webkit-transform 0.5s ease-in-out, opacity 1s ease-in-out;
+  -moz-transition: -moz-transform 0.5s ease-in-out, opacity 1s ease-in-out;
+  -o-transition: -o-transform 0.5s ease-in-out, opacity 1s ease-in-out;
+  -ms-transition: -ms-transform 0.5s ease-in-out, opacity 1s ease-in-out;
+  transition: transform 0.5s ease-in-out, opacity 1s ease-in-out;
+}
+.opentip-container.ot-show-effect-appear.ot-going-to-show {
+  opacity: 0;
+  filter: alpha(opacity=0);
+  -ms-filter: "progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";
+}
+.opentip-container.ot-show-effect-appear.ot-showing {
+  opacity: 1;
+  -ms-filter: none;
+  filter: none;
+}
+.opentip-container.ot-show-effect-appear.ot-visible {
+  opacity: 1;
+  -ms-filter: none;
+  filter: none;
+}
+@-moz-keyframes otloading {
+  0% {
+    -webkit-transform: rotate(0deg);
+    -moz-transform: rotate(0deg);
+    -o-transform: rotate(0deg);
+    -ms-transform: rotate(0deg);
+    transform: rotate(0deg);
+  }
+
+  100% {
+    -webkit-transform: rotate(360deg);
+    -moz-transform: rotate(360deg);
+    -o-transform: rotate(360deg);
+    -ms-transform: rotate(360deg);
+    transform: rotate(360deg);
+  }
+}
+@-webkit-keyframes otloading {
+  0% {
+    -webkit-transform: rotate(0deg);
+    -moz-transform: rotate(0deg);
+    -o-transform: rotate(0deg);
+    -ms-transform: rotate(0deg);
+    transform: rotate(0deg);
+  }
+
+  100% {
+    -webkit-transform: rotate(360deg);
+    -moz-transform: rotate(360deg);
+    -o-transform: rotate(360deg);
+    -ms-transform: rotate(360deg);
+    transform: rotate(360deg);
+  }
+}
+@-o-keyframes otloading {
+  0% {
+    -webkit-transform: rotate(0deg);
+    -moz-transform: rotate(0deg);
+    -o-transform: rotate(0deg);
+    -ms-transform: rotate(0deg);
+    transform: rotate(0deg);
+  }
+
+  100% {
+    -webkit-transform: rotate(360deg);
+    -moz-transform: rotate(360deg);
+    -o-transform: rotate(360deg);
+    -ms-transform: rotate(360deg);
+    transform: rotate(360deg);
+  }
+}
+@-ms-keyframes otloading {
+  0% {
+    -webkit-transform: rotate(0deg);
+    -moz-transform: rotate(0deg);
+    -o-transform: rotate(0deg);
+    -ms-transform: rotate(0deg);
+    transform: rotate(0deg);
+  }
+
+  100% {
+    -webkit-transform: rotate(360deg);
+    -moz-transform: rotate(360deg);
+    -o-transform: rotate(360deg);
+    -ms-transform: rotate(360deg);
+    transform: rotate(360deg);
+  }
+}
+@keyframes otloading {
+  0% {
+    -webkit-transform: rotate(0deg);
+    -moz-transform: rotate(0deg);
+    -o-transform: rotate(0deg);
+    -ms-transform: rotate(0deg);
+    transform: rotate(0deg);
+  }
+
+  100% {
+    -webkit-transform: rotate(360deg);
+    -moz-transform: rotate(360deg);
+    -o-transform: rotate(360deg);
+    -ms-transform: rotate(360deg);
+    transform: rotate(360deg);
+  }
+}
```
