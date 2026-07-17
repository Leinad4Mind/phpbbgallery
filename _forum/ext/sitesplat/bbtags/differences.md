Existem diferencas reais no codigo ou texto. Diferencas de formatacao (espacos, tabs) foram ignoradas abaixo.

```diff
diff --git "[ORIGINAL]/sitesplat\\bbtags/composer.json" "[FORUM_EXT]/sitesplat\\bbtags/composer.json"
--- "[ORIGINAL]/sitesplat\\bbtags/composer.json"
+++ "[FORUM_EXT]/sitesplat\\bbtags/composer.json"
@@ -3,7 +3,7 @@
 	"type": "phpbb-extension",
 	"description": "Adds an efficient modern and simple to use Topic Tag system. Comes with the classic Tag Cloud for the WordPress lovers :p",
 	"homepage": "https://sitesplat.com",
-	"version": "1.1.5",
+	"version": "1.1.4",
 	"keywords": ["phpbb", "extension", "premium", "Topic tags", "SiteSplat"],
 	"license": "Proprietary/All rights reserved",
 	"authors": [
@@ -23,7 +23,7 @@
 	"extra": {
 		"display-name": "BBtags",
 		"soft-require": {
-			"phpbb/phpbb": ">=3.1.0,<3.3.*@dev"
+			"phpbb/phpbb": ">=3.1.0,<3.2.*@dev"
 		},
 		"version-check": {
             "host": "sitesplat.com",
diff --git "[FORUM_EXT]/sitesplat\\bbtags/diff_full.tmp" "[FORUM_EXT]/sitesplat\\bbtags/diff_full.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\bbtags/diff_full.tmp"
@@ -0,0 +1,107 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbtags/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbtags/composer.json"
+index 4295789bf..09deacdfc 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbtags/composer.json"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbtags/composer.json"
+@@ -3,7 +3,7 @@
+ 	"type": "phpbb-extension",
+ 	"description": "Adds an efficient modern and simple to use Topic Tag system. Comes with the classic Tag Cloud for the WordPress lovers :p",
+ 	"homepage": "https://sitesplat.com",
+-	"version": "1.1.5",
++	"version": "1.1.4",
+ 	"keywords": ["phpbb", "extension", "premium", "Topic tags", "SiteSplat"],
+ 	"license": "Proprietary/All rights reserved",
+ 	"authors": [
+@@ -23,7 +23,7 @@
+ 	"extra": {
+ 		"display-name": "BBtags",
+ 		"soft-require": {
+-			"phpbb/phpbb": ">=3.1.0,<3.3.*@dev"
++			"phpbb/phpbb": ">=3.1.0,<3.2.*@dev"
+ 		},
+ 		"version-check": {
+             "host": "sitesplat.com",
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbtags/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbtags/diff_full.tmp"
+new file mode 100644
+index 000000000..e69de29bb
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbtags/event/listener.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbtags/event/listener.php"
+index 7eaf8f7b7..5a568756c 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbtags/event/listener.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbtags/event/listener.php"
+@@ -65,7 +65,7 @@ class listener implements EventSubscriberInterface
+ 			'core.page_header_after'				=> 'load_tags',
+ 			'core.posting_modify_template_vars'		=> 'modify_template_vars',
+ 			'core.submit_post_end'					=> 'save_tags',
+-            'core.delete_topics_after_query'		=> 'delete_tags',
++			'core.delete_topics_after_query'		=> 'delete_tags',
+ 			'core.permissions'						=> 'add_permission',
+ 		);
+ 	}
+@@ -87,7 +87,7 @@ class listener implements EventSubscriberInterface
+ 				$this->config['bbtags_on_index'] == 1
+ 				&& substr($this->user->data['session_page'], 0, 6) == 'index.'
+ 			)
+-		) 		        
++		)
+ 		{
+ 			$tags = $this->manager->get_tags(0);
+ 			if ($tags != '')
+@@ -97,11 +97,11 @@ class listener implements EventSubscriberInterface
+ 					$this->assign_tags_to_template('bbtags', explode(',', $tags));
+ 				}
+ 				$this->template->assign_vars(array(
+-					'META'				=> '<meta name="keywords" content="' . $tags . '">',
++					'META_KEYWORDS' => '<meta name="keywords" content="' . $tags . '">',
+ 				));
+ 			}
+ 		}
+-
++		
+ 		$topic_id = $this->request->variable('t', 0);
+ 		if ($topic_id)
+ 		{
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbtags/language/en/info_acp_bbtags.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbtags/language/en/info_acp_bbtags.php"
+index 3455139cb..b86186385 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbtags/language/en/info_acp_bbtags.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbtags/language/en/info_acp_bbtags.php"
+@@ -61,7 +61,7 @@ $lang = array_merge($lang, array(
+ 	'EXTENSION_DEVELOPER'	    		=> 'Developer',
+ 	'ACP_BBTAGS_NOTICE_CLOSE'			=> 'Close',
+ 	
+-	'ACP_BBTAGS_VERSION'				=> '1.1.5',
++	'ACP_BBTAGS_VERSION'				=> '1.1.3',
+     'ACP_LOADING'			    		=> 'Hold On. Loading...',
+ 	
+ ));
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbtags/styles/FLATBOOTS/template/event/overall_header_meta.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbtags/styles/FLATBOOTS/template/event/overall_header_meta.html"
+new file mode 100644
+index 000000000..dec1e6b89
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbtags/styles/FLATBOOTS/template/event/overall_header_meta.html"
+@@ -0,0 +1 @@
++{{ META_KEYWORDS }}
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbtags/styles/FLATBOOTS/template/event/posting_editor_subject_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbtags/styles/FLATBOOTS/template/event/posting_editor_subject_after.html"
+index e4578927f..c88e94df0 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbtags/styles/FLATBOOTS/template/event/posting_editor_subject_after.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbtags/styles/FLATBOOTS/template/event/posting_editor_subject_after.html"
+@@ -2,7 +2,6 @@
+ <script>
+ var maxTags = {BBTAGS_MAXTAGS};
+ var maxLength = {BBTAGS_MAXLENGTH};
+-var bbtagsLangPlaceholder = '{L_BBTAGS_ENTER_TAGS_PLACEHOLDER}';
+ </script>
+ <!-- INCLUDEJS @sitesplat_bbtags/js/jquery.tag-editor.min.js -->
+ <!-- INCLUDEJS @sitesplat_bbtags/js/jquery.caret.min.js -->
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbtags/styles/FLATBOOTS/template/js/bbtags.js" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbtags/styles/FLATBOOTS/template/js/bbtags.js"
+index 4217a975d..b64803b72 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbtags/styles/FLATBOOTS/template/js/bbtags.js"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbtags/styles/FLATBOOTS/template/js/bbtags.js"
+@@ -25,7 +25,7 @@ $(document).on("click", ".open-bbtagsdialog", function () {
+ $('#bbtags').tagEditor({ 
+ 	initialTags: [],
+ 	forceLowercase: true,
+-	placeholder: bbtagsLangPlaceholder,
++	placeholder: 'Enter tags...',
+ 	maxTags: maxTags,
+ 	maxLength: 30,
+ 	 autocomplete: {
diff --git "[FORUM_EXT]/sitesplat\\bbtags/diff_nospace.tmp" "[FORUM_EXT]/sitesplat\\bbtags/diff_nospace.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\bbtags/diff_nospace.tmp"
@@ -0,0 +1,75 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbtags/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbtags/composer.json"
+index 4295789bf..09deacdfc 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbtags/composer.json"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbtags/composer.json"
+@@ -3,7 +3,7 @@
+ 	"type": "phpbb-extension",
+ 	"description": "Adds an efficient modern and simple to use Topic Tag system. Comes with the classic Tag Cloud for the WordPress lovers :p",
+ 	"homepage": "https://sitesplat.com",
+-	"version": "1.1.5",
++	"version": "1.1.4",
+ 	"keywords": ["phpbb", "extension", "premium", "Topic tags", "SiteSplat"],
+ 	"license": "Proprietary/All rights reserved",
+ 	"authors": [
+@@ -23,7 +23,7 @@
+ 	"extra": {
+ 		"display-name": "BBtags",
+ 		"soft-require": {
+-			"phpbb/phpbb": ">=3.1.0,<3.3.*@dev"
++			"phpbb/phpbb": ">=3.1.0,<3.2.*@dev"
+ 		},
+ 		"version-check": {
+             "host": "sitesplat.com",
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbtags/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbtags/diff_full.tmp"
+new file mode 100644
+index 000000000..e7f43ba1a
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbtags/diff_full.tmp"
+@@ -0,0 +1,107 @@
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbtags/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbtags/composer.json"
++index 4295789bf..09deacdfc 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbtags/composer.json"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbtags/composer.json"
++@@ -3,7 +3,7 @@
++ 	"type": "phpbb-extension",
++ 	"description": "Adds an efficient modern and simple to use Topic Tag system. Comes with the classic Tag Cloud for the WordPress lovers :p",
++ 	"homepage": "https://sitesplat.com",
++-	"version": "1.1.5",
+++	"version": "1.1.4",
++ 	"keywords": ["phpbb", "extension", "premium", "Topic tags", "SiteSplat"],
++ 	"license": "Proprietary/All rights reserved",
++ 	"authors": [
++@@ -23,7 +23,7 @@
++ 	"extra": {
++ 		"display-name": "BBtags",
++ 		"soft-require": {
++-			"phpbb/phpbb": ">=3.1.0,<3.3.*@dev"
+++			"phpbb/phpbb": ">=3.1.0,<3.2.*@dev"
++ 		},
++ 		"version-check": {
++             "host": "sitesplat.com",
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbtags/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbtags/diff_full.tmp"
++new file mode 100644
++index 000000000..e69de29bb
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbtags/event/listener.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbtags/event/listener.php"
++index 7eaf8f7b7..5a568756c 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbtags/event/listener.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbtags/event/listener.php"
++@@ -65,7 +65,7 @@ class listener implements EventSubscriberInterface
++ 			'core.page_header_after'				=> 'load_tags',
++ 			'core.posting_modify_template_vars'		=> 'modify_template_vars',
++ 			'core.submit_post_end'					=> 'save_tags',
++-            'core.delete_topics_after_query'		=> 'delete_tags',
+++			'core.delete_topics_after_query'		=> 'delete_tags',
++ 			'core.permissions'						=> 'add_permission',
++ 		);
++ 	}
++@@ -87,7 +87,7 @@ class listener implements EventSubscriberInterface
++ 				$this->config['bbtags_on_index'] == 1
++ 				&& substr($this->user->data['session_page'], 0, 6) == 'index.'
++ 			)
++-		) 		        
+++		)
++ 		{
++ 			$tags = $this->manager->get_tags(0);
++ 			if ($tags != '')
diff --git "[ORIGINAL]/sitesplat\\bbtags/event/listener.php" "[FORUM_EXT]/sitesplat\\bbtags/event/listener.php"
--- "[ORIGINAL]/sitesplat\\bbtags/event/listener.php"
+++ "[FORUM_EXT]/sitesplat\\bbtags/event/listener.php"
@@ -97,7 +97,7 @@ class listener implements EventSubscriberInterface
 					$this->assign_tags_to_template('bbtags', explode(',', $tags));
 				}
 				$this->template->assign_vars(array(
-					'META'				=> '<meta name="keywords" content="' . $tags . '">',
+					'META_KEYWORDS' => '<meta name="keywords" content="' . $tags . '">',
 				));
 			}
 		}
diff --git "[ORIGINAL]/sitesplat\\bbtags/language/en/info_acp_bbtags.php" "[FORUM_EXT]/sitesplat\\bbtags/language/en/info_acp_bbtags.php"
--- "[ORIGINAL]/sitesplat\\bbtags/language/en/info_acp_bbtags.php"
+++ "[FORUM_EXT]/sitesplat\\bbtags/language/en/info_acp_bbtags.php"
@@ -61,7 +61,7 @@ $lang = array_merge($lang, array(
 	'EXTENSION_DEVELOPER'	    		=> 'Developer',
 	'ACP_BBTAGS_NOTICE_CLOSE'			=> 'Close',
 	
-	'ACP_BBTAGS_VERSION'				=> '1.1.5',
+	'ACP_BBTAGS_VERSION'				=> '1.1.3',
     'ACP_LOADING'			    		=> 'Hold On. Loading...',
 	
 ));
diff --git "[FORUM_EXT]/sitesplat\\bbtags/styles/FLATBOOTS/template/event/overall_header_meta.html" "[FORUM_EXT]/sitesplat\\bbtags/styles/FLATBOOTS/template/event/overall_header_meta.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\bbtags/styles/FLATBOOTS/template/event/overall_header_meta.html"
@@ -0,0 +1 @@
+{{ META_KEYWORDS }}
\ No newline at end of file
diff --git "[ORIGINAL]/sitesplat\\bbtags/styles/FLATBOOTS/template/event/posting_editor_subject_after.html" "[FORUM_EXT]/sitesplat\\bbtags/styles/FLATBOOTS/template/event/posting_editor_subject_after.html"
--- "[ORIGINAL]/sitesplat\\bbtags/styles/FLATBOOTS/template/event/posting_editor_subject_after.html"
+++ "[FORUM_EXT]/sitesplat\\bbtags/styles/FLATBOOTS/template/event/posting_editor_subject_after.html"
@@ -2,7 +2,6 @@
 <script>
 var maxTags = {BBTAGS_MAXTAGS};
 var maxLength = {BBTAGS_MAXLENGTH};
-var bbtagsLangPlaceholder = '{L_BBTAGS_ENTER_TAGS_PLACEHOLDER}';
 </script>
 <!-- INCLUDEJS @sitesplat_bbtags/js/jquery.tag-editor.min.js -->
 <!-- INCLUDEJS @sitesplat_bbtags/js/jquery.caret.min.js -->
diff --git "[ORIGINAL]/sitesplat\\bbtags/styles/FLATBOOTS/template/js/bbtags.js" "[FORUM_EXT]/sitesplat\\bbtags/styles/FLATBOOTS/template/js/bbtags.js"
--- "[ORIGINAL]/sitesplat\\bbtags/styles/FLATBOOTS/template/js/bbtags.js"
+++ "[FORUM_EXT]/sitesplat\\bbtags/styles/FLATBOOTS/template/js/bbtags.js"
@@ -25,7 +25,7 @@ $(document).on("click", ".open-bbtagsdialog", function () {
 $('#bbtags').tagEditor({ 
 	initialTags: [],
 	forceLowercase: true,
-	placeholder: bbtagsLangPlaceholder,
+	placeholder: 'Enter tags...',
 	maxTags: maxTags,
 	maxLength: 30,
 	 autocomplete: {
```
