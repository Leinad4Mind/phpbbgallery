Existem diferencas reais no codigo ou texto. Diferencas de formatacao (espacos, tabs) foram ignoradas abaixo.

```diff
diff --git "[ORIGINAL]/canidev\\quickquote/acp/config_info.php" "[FORUM_EXT]/canidev\\quickquote/acp/config_info.php"
--- "[ORIGINAL]/canidev\\quickquote/acp/config_info.php"
+++ "[FORUM_EXT]/canidev\\quickquote/acp/config_info.php"
@@ -1,9 +1,9 @@
 <?php
 /**
  * @package cBB Quickquote
- * @version 1.0.5 08/04/2025
+ * @version 1.0.4 01/06/2024
  *
- * @copyright (c) 2025 CaniDev
+ * @copyright (c) 2024 CaniDev
  * @license https://creativecommons.org/licenses/by-nc/4.0/
  */
 
@@ -16,7 +16,7 @@ class config_info
 		return [
 			'filename'	=> '\canidev\quickquote\acp\config_module',
 			'title'		=> 'ACP_CAT_QUICKQUOTE',
-			'version'	=> '1.0.5',
+			'version'	=> '1.0.4',
 			'modes'		=> [
 				'config'	=> ['title' => 'ACP_QUICKQUOTE_CONFIG',		'auth' => 'ext_canidev/quickquote && acl_a_board', 'cat' => ['ACP_CAT_QUICKQUOTE']],
 			],
diff --git "[ORIGINAL]/canidev\\quickquote/acp/config_module.php" "[FORUM_EXT]/canidev\\quickquote/acp/config_module.php"
--- "[ORIGINAL]/canidev\\quickquote/acp/config_module.php"
+++ "[FORUM_EXT]/canidev\\quickquote/acp/config_module.php"
@@ -1,9 +1,9 @@
 <?php
 /**
  * @package cBB QuickQuote
- * @version 1.0.5 08/04/2025
+ * @version 1.0.4 01/06/2024
  *
- * @copyright (c) 2025 CaniDev
+ * @copyright (c) 2024 CaniDev
  * @license https://creativecommons.org/licenses/by-nc/4.0/
  */
 
diff --git "[ORIGINAL]/canidev\\quickquote/adm/style/event/acp_overall_footer_after.html" "[FORUM_EXT]/canidev\\quickquote/adm/style/event/acp_overall_footer_after.html"
--- "[ORIGINAL]/canidev\\quickquote/adm/style/event/acp_overall_footer_after.html"
+++ "[FORUM_EXT]/canidev\\quickquote/adm/style/event/acp_overall_footer_after.html"
@@ -1,3 +1,3 @@
-{% if IN_EXT_QUICKQUOTE and CANIDEV_CORE_STARTED %}
+{% if QUICKQUOTE_IN_ADMIN and CANIDEV_CORE_STARTED %}
 	{% include '@canidev_core/event/acp_overall_footer_after.html' %}
 {% endif %}
\ No newline at end of file
diff --git "[ORIGINAL]/canidev\\quickquote/adm/style/event/acp_overall_header_head_append.html" "[FORUM_EXT]/canidev\\quickquote/adm/style/event/acp_overall_header_head_append.html"
--- "[ORIGINAL]/canidev\\quickquote/adm/style/event/acp_overall_header_head_append.html"
+++ "[FORUM_EXT]/canidev\\quickquote/adm/style/event/acp_overall_header_head_append.html"
@@ -1,3 +1,3 @@
-{% if IN_EXT_QUICKQUOTE and CANIDEV_CORE_STARTED %}
+{% if QUICKQUOTE_IN_ADMIN and CANIDEV_CORE_STARTED %}
 	{% include '@canidev_core/event/overall_header_head_append.html' %}
 {% endif %}
\ No newline at end of file
diff --git "[ORIGINAL]/canidev\\quickquote/composer.json" "[FORUM_EXT]/canidev\\quickquote/composer.json"
--- "[ORIGINAL]/canidev\\quickquote/composer.json"
+++ "[FORUM_EXT]/canidev\\quickquote/composer.json"
@@ -3,8 +3,7 @@
 	"type": "phpbb-extension",
 	"description": "",
 	"homepage": "https://www.canidev.com",
-	"version": "1.0.5",
-	"time": "2025-04-08",
+	"version": "1.0.4",
 	"keywords": ["phpbb", "extension", "canidev", "quotes"],
 	"license": "CreativeCommons Attribution-NonCommercial v4.0",
 	"authors": [
diff --git "[ORIGINAL]/canidev\\quickquote/controller/admin_controller_config.php" "[FORUM_EXT]/canidev\\quickquote/controller/admin_controller_config.php"
--- "[ORIGINAL]/canidev\\quickquote/controller/admin_controller_config.php"
+++ "[FORUM_EXT]/canidev\\quickquote/controller/admin_controller_config.php"
@@ -1,9 +1,9 @@
 <?php
 /**
  * @package cBB Quickquote
- * @version 1.0.5 08/04/2025
+ * @version 1.0.4 01/06/2024
  *
- * @copyright (c) 2025 CaniDev
+ * @copyright (c) 2024 CaniDev
  * @license https://creativecommons.org/licenses/by-nc/4.0/
  */
 
@@ -68,7 +68,7 @@ class admin_controller_config extends \canidev\core\controller\acp
 		if($submit)
 		{
 			$cfg_array = $this->request->variable('config', ['' => '']);
-			$cfg_array['quickquote_groups'] = $this->tools->groups_select_submit('quickquote_groups');
+			$cfg_array['quickquote_groups'] = ($this->request->is_set_post('all_groups_quickquote_groups')) ? 'all' : $this->request->variable('quickquote_groups', [0]);
 
 			// We validate the complete config if whished
 			validate_config_vars($display_vars, $cfg_array, $error);
@@ -92,7 +92,7 @@ class admin_controller_config extends \canidev\core\controller\acp
 		$this->new_config = $cfg_array;
 
 		// Do not write values if there is an error
-		if(count($error))
+		if(sizeof($error))
 		{
 			$submit = false;
 		}
@@ -107,7 +107,8 @@ class admin_controller_config extends \canidev\core\controller\acp
 
 			if($submit)
 			{
-				$this->config->set($config_name, $this->new_config[$config_name]);
+				$value = is_array($this->new_config[$config_name]) ? implode(',', $this->new_config[$config_name]) : $this->new_config[$config_name];
+				$this->config->set($config_name, $value);
 			}
 		}
 
@@ -117,7 +118,8 @@ class admin_controller_config extends \canidev\core\controller\acp
 		}
 		
 		$this->template->assign_vars([
-			'S_ERROR'				=> count($error) > 0,
+			'QUICKQUOTE_IN_ADMIN'	=> true,
+			'S_ERROR'				=> (sizeof($error)) ? true : false,
 			'ERROR_MSG'				=> implode('<br />', $error),
 		]);
 
diff --git "[FORUM_EXT]/canidev\\quickquote/diff_full.tmp" "[FORUM_EXT]/canidev\\quickquote/diff_full.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/canidev\\quickquote/diff_full.tmp"
@@ -0,0 +1,564 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickquote/acp/config_info.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickquote/acp/config_info.php"
+index 5b2d695b0..bbe64e71b 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickquote/acp/config_info.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickquote/acp/config_info.php"
+@@ -1,9 +1,9 @@
+ <?php
+ /**
+  * @package cBB Quickquote
+- * @version 1.0.5 08/04/2025
++ * @version 1.0.4 01/06/2024
+  *
+- * @copyright (c) 2025 CaniDev
++ * @copyright (c) 2024 CaniDev
+  * @license https://creativecommons.org/licenses/by-nc/4.0/
+  */
+ 
+@@ -16,7 +16,7 @@ class config_info
+ 		return [
+ 			'filename'	=> '\canidev\quickquote\acp\config_module',
+ 			'title'		=> 'ACP_CAT_QUICKQUOTE',
+-			'version'	=> '1.0.5',
++			'version'	=> '1.0.4',
+ 			'modes'		=> [
+ 				'config'	=> ['title' => 'ACP_QUICKQUOTE_CONFIG',		'auth' => 'ext_canidev/quickquote && acl_a_board', 'cat' => ['ACP_CAT_QUICKQUOTE']],
+ 			],
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickquote/acp/config_module.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickquote/acp/config_module.php"
+index 419266075..32f29fe53 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickquote/acp/config_module.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickquote/acp/config_module.php"
+@@ -1,9 +1,9 @@
+ <?php
+ /**
+  * @package cBB QuickQuote
+- * @version 1.0.5 08/04/2025
++ * @version 1.0.4 01/06/2024
+  *
+- * @copyright (c) 2025 CaniDev
++ * @copyright (c) 2024 CaniDev
+  * @license https://creativecommons.org/licenses/by-nc/4.0/
+  */
+ 
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickquote/adm/style/event/acp_overall_footer_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickquote/adm/style/event/acp_overall_footer_after.html"
+index f30a3f112..a266179f5 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickquote/adm/style/event/acp_overall_footer_after.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickquote/adm/style/event/acp_overall_footer_after.html"
+@@ -1,3 +1,3 @@
+-{% if IN_EXT_QUICKQUOTE and CANIDEV_CORE_STARTED %}
++{% if QUICKQUOTE_IN_ADMIN and CANIDEV_CORE_STARTED %}
+ 	{% include '@canidev_core/event/acp_overall_footer_after.html' %}
+ {% endif %}
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickquote/adm/style/event/acp_overall_header_head_append.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickquote/adm/style/event/acp_overall_header_head_append.html"
+index 173d4d230..6e95f0980 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickquote/adm/style/event/acp_overall_header_head_append.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickquote/adm/style/event/acp_overall_header_head_append.html"
+@@ -1,3 +1,3 @@
+-{% if IN_EXT_QUICKQUOTE and CANIDEV_CORE_STARTED %}
++{% if QUICKQUOTE_IN_ADMIN and CANIDEV_CORE_STARTED %}
+ 	{% include '@canidev_core/event/overall_header_head_append.html' %}
+ {% endif %}
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickquote/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickquote/composer.json"
+index 508890c17..b9ed46cc1 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickquote/composer.json"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickquote/composer.json"
+@@ -3,8 +3,7 @@
+ 	"type": "phpbb-extension",
+ 	"description": "",
+ 	"homepage": "https://www.canidev.com",
+-	"version": "1.0.5",
+-	"time": "2025-04-08",
++	"version": "1.0.4",
+ 	"keywords": ["phpbb", "extension", "canidev", "quotes"],
+ 	"license": "CreativeCommons Attribution-NonCommercial v4.0",
+ 	"authors": [
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickquote/controller/admin_controller_config.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickquote/controller/admin_controller_config.php"
+index 752784a7b..c5919c00a 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickquote/controller/admin_controller_config.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickquote/controller/admin_controller_config.php"
+@@ -1,9 +1,9 @@
+ <?php
+ /**
+  * @package cBB Quickquote
+- * @version 1.0.5 08/04/2025
++ * @version 1.0.4 01/06/2024
+  *
+- * @copyright (c) 2025 CaniDev
++ * @copyright (c) 2024 CaniDev
+  * @license https://creativecommons.org/licenses/by-nc/4.0/
+  */
+ 
+@@ -68,7 +68,7 @@ class admin_controller_config extends \canidev\core\controller\acp
+ 		if($submit)
+ 		{
+ 			$cfg_array = $this->request->variable('config', ['' => '']);
+-			$cfg_array['quickquote_groups'] = $this->tools->groups_select_submit('quickquote_groups');
++			$cfg_array['quickquote_groups'] = ($this->request->is_set_post('all_groups_quickquote_groups')) ? 'all' : $this->request->variable('quickquote_groups', [0]);
+ 
+ 			// We validate the complete config if whished
+ 			validate_config_vars($display_vars, $cfg_array, $error);
+@@ -92,7 +92,7 @@ class admin_controller_config extends \canidev\core\controller\acp
+ 		$this->new_config = $cfg_array;
+ 
+ 		// Do not write values if there is an error
+-		if(count($error))
++		if(sizeof($error))
+ 		{
+ 			$submit = false;
+ 		}
+@@ -107,7 +107,8 @@ class admin_controller_config extends \canidev\core\controller\acp
+ 
+ 			if($submit)
+ 			{
+-				$this->config->set($config_name, $this->new_config[$config_name]);
++				$value = is_array($this->new_config[$config_name]) ? implode(',', $this->new_config[$config_name]) : $this->new_config[$config_name];
++				$this->config->set($config_name, $value);
+ 			}
+ 		}
+ 
+@@ -117,7 +118,8 @@ class admin_controller_config extends \canidev\core\controller\acp
+ 		}
+ 		
+ 		$this->template->assign_vars([
+-			'S_ERROR'				=> count($error) > 0,
++			'QUICKQUOTE_IN_ADMIN'	=> true,
++			'S_ERROR'				=> (sizeof($error)) ? true : false,
+ 			'ERROR_MSG'				=> implode('<br />', $error),
+ 		]);
+ 
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickquote/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickquote/diff_full.tmp"
+new file mode 100644
+index 000000000..a9cf3f675
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickquote/diff_full.tmp"
+@@ -0,0 +1,69 @@
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickquote/acp/config_info.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickquote/acp/config_info.php"
++index 5b2d695b0..bbe64e71b 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickquote/acp/config_info.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickquote/acp/config_info.php"
++@@ -1,9 +1,9 @@
++ <?php
++ /**
++  * @package cBB Quickquote
++- * @version 1.0.5 08/04/2025
+++ * @version 1.0.4 01/06/2024
++  *
++- * @copyright (c) 2025 CaniDev
+++ * @copyright (c) 2024 CaniDev
++  * @license https://creativecommons.org/licenses/by-nc/4.0/
++  */
++ 
++@@ -16,7 +16,7 @@ class config_info
++ 		return [
++ 			'filename'	=> '\canidev\quickquote\acp\config_module',
++ 			'title'		=> 'ACP_CAT_QUICKQUOTE',
++-			'version'	=> '1.0.5',
+++			'version'	=> '1.0.4',
++ 			'modes'		=> [
++ 				'config'	=> ['title' => 'ACP_QUICKQUOTE_CONFIG',		'auth' => 'ext_canidev/quickquote && acl_a_board', 'cat' => ['ACP_CAT_QUICKQUOTE']],
++ 			],
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickquote/acp/config_module.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickquote/acp/config_module.php"
++index 419266075..32f29fe53 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickquote/acp/config_module.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickquote/acp/config_module.php"
++@@ -1,9 +1,9 @@
++ <?php
++ /**
++  * @package cBB QuickQuote
++- * @version 1.0.5 08/04/2025
+++ * @version 1.0.4 01/06/2024
++  *
++- * @copyright (c) 2025 CaniDev
+++ * @copyright (c) 2024 CaniDev
++  * @license https://creativecommons.org/licenses/by-nc/4.0/
++  */
++ 
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickquote/adm/style/event/acp_overall_footer_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickquote/adm/style/event/acp_overall_footer_after.html"
++index f30a3f112..a266179f5 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickquote/adm/style/event/acp_overall_footer_after.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickquote/adm/style/event/acp_overall_footer_after.html"
++@@ -1,3 +1,3 @@
++-{% if IN_EXT_QUICKQUOTE and CANIDEV_CORE_STARTED %}
+++{% if QUICKQUOTE_IN_ADMIN and CANIDEV_CORE_STARTED %}
++ 	{% include '@canidev_core/event/acp_overall_footer_after.html' %}
++ {% endif %}
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickquote/adm/style/event/acp_overall_header_head_append.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickquote/adm/style/event/acp_overall_header_head_append.html"
++index 173d4d230..6e95f0980 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickquote/adm/style/event/acp_overall_header_head_append.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickquote/adm/style/event/acp_overall_header_head_append.html"
++@@ -1,3 +1,3 @@
++-{% if IN_EXT_QUICKQUOTE and CANIDEV_CORE_STARTED %}
+++{% if QUICKQUOTE_IN_ADMIN and CANIDEV_CORE_STARTED %}
++ 	{% include '@canidev_core/event/overall_header_head_append.html' %}
++ {% endif %}
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickquote/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickquote/composer.json"
++index 508890c17..b9ed46cc1 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickquote/composer.json"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickquote/composer.json"
++@@ -3,8 +3,7 @@
++ 	"type": "phpbb-extension",
++ 	"description": "",
++ 	"homepage": "https://ww
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickquote/event/listener.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickquote/event/listener.php"
+index 7278468ab..7d5f1373b 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickquote/event/listener.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickquote/event/listener.php"
+@@ -1,9 +1,9 @@
+ <?php
+ /**
+  * @package cBB Quickquote
+- * @version 1.0.5 08/04/2025
++ * @version 1.0.4 01/06/2024
+  *
+- * @copyright (c) 2025 CaniDev
++ * @copyright (c) 2024 CaniDev
+  * @license https://creativecommons.org/licenses/by-nc/4.0/
+  */
+ 
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickquote/ext.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickquote/ext.php"
+index 9a9ce33aa..555d5c57b 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickquote/ext.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickquote/ext.php"
+@@ -1,9 +1,9 @@
+ <?php
+ /**
+  * @package cBB Quickquote
+- * @version 1.0.5 08/04/2025
++ * @version 1.0.4 01/06/2024
+  *
+- * @copyright (c) 2025 CaniDev
++ * @copyright (c) 2024 CaniDev
+  * @license https://creativecommons.org/licenses/by-nc/4.0/
+  */
+ 
+@@ -12,7 +12,7 @@ namespace canidev\quickquote;
+ class ext extends \phpbb\extension\base
+ {
+ 	const REQUIRED_PHPBB	= '3.2.0';
+-	const REQUIRED_CORE		= '1.1.10';
++	const REQUIRED_CORE		= '1.1.4';
+ 
+ 	/**
+ 	 * {@inheritDoc}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickquote/language/en/frontend.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickquote/language/en/frontend.php"
+index e87d9f66e..9b6f2b1e5 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickquote/language/en/frontend.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickquote/language/en/frontend.php"
+@@ -2,9 +2,9 @@
+ /**
+  * [English [En]]
+  * @package cBB QuickQuote
+- * @version 1.0.5 08/04/2025
++ * @version 1.0.4 01/06/2024
+  *
+- * @copyright (c) 2025 CaniDev
++ * @copyright (c) 2024 CaniDev
+  * @license https://creativecommons.org/licenses/by-nc/4.0/
+  */
+ 
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickquote/language/en/info_acp_quickquote.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickquote/language/en/info_acp_quickquote.php"
+index 2a6aadbb1..6a18bca31 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickquote/language/en/info_acp_quickquote.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickquote/language/en/info_acp_quickquote.php"
+@@ -2,9 +2,9 @@
+ /**
+  * [English [En]]
+  * @package cBB QuickQuote
+- * @version 1.0.5 08/04/2025
++ * @version 1.0.4 01/06/2024
+  *
+- * @copyright (c) 2025 CaniDev
++ * @copyright (c) 2024 CaniDev
+  * @license https://creativecommons.org/licenses/by-nc/4.0/
+  */
+ 
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickquote/language/es/frontend.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickquote/language/es/frontend.php"
+index 6d322dc45..8be6b29e4 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickquote/language/es/frontend.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickquote/language/es/frontend.php"
+@@ -2,9 +2,9 @@
+ /**
+  * [Spanish [Es]]
+  * @package cBB QuickQuote
+- * @version 1.0.5 08/04/2025
++ * @version 1.0.4 01/06/2024
+  *
+- * @copyright (c) 2025 CaniDev
++ * @copyright (c) 2024 CaniDev
+  * @license https://creativecommons.org/licenses/by-nc/4.0/
+  */
+ 
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickquote/language/es/info_acp_quickquote.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickquote/language/es/info_acp_quickquote.php"
+index 6afb2975a..eb22aa2c7 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickquote/language/es/info_acp_quickquote.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickquote/language/es/info_acp_quickquote.php"
+@@ -2,9 +2,9 @@
+ /**
+  * [Spanish [Es]]
+  * @package cBB QuickQuote
+- * @version 1.0.5 08/04/2025
++ * @version 1.0.4 01/06/2024
+  *
+- * @copyright (c) 2025 CaniDev
++ * @copyright (c) 2024 CaniDev
+  * @license https://creativecommons.org/licenses/by-nc/4.0/
+  */
+ 
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickquote/styles/BBOOTS/template/event/overall_footer_body_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickquote/styles/BBOOTS/template/event/overall_footer_body_after.html"
+index c8f711fb9..d0722b652 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickquote/styles/BBOOTS/template/event/overall_footer_body_after.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickquote/styles/BBOOTS/template/event/overall_footer_body_after.html"
+@@ -1,21 +1,21 @@
+ {% if QQ_ENABLED %}
+-	<template id="quickquote-tooltip">
++	<script type="text/html" id="tpl-quickquote-tooltip">
+ 		<div class="quickquote-tooltip">
+ 			<a href="#" data-action="quote"><i class="fa fa-plus"></i> {{ lang('QQ_SAVE_QUOTE') }}</a>
+ 			<span class="tooltip-sep">|</span>
+ 			<a href="#" data-action="reply"><i class="fa fa-reply"></i> {{ lang('QQ_REPLY') }}</a>
+ 		</div>
+-	</template>
++	</script>
+ 
+-	<template id="quickquote-floatbtn">
+-		<a href="#" class="quickquote-floatbtn btn btn-default" data-text="{{ lang('QUOTES') }}"></a>
+-	</template>
++	<script type="text/html" id="tpl-quickquote-floatbtn">
++	<a href="#" class="quickquote-floatbtn btn btn-default" data-text="{{ lang('QUOTES') }}"></a>
++	</script>
+ 
+-	<template id="quickquote-inlinebtn">
++	<script type="text/html" id="tpl-quickquote-inlinebtn">
+ 		<button type="button" class="btn btn-default" value="1" data-text="{{ lang('QQ_INSERT_QUOTES') }}"></button>
+-	</template>
++	</script>
+ 
+-	<template id="quickquote-dialog">
++	<script type="text/html" id="tpl-quickquote-dialog">
+ 		<div class="qq-dialog" title="{{ lang('QUOTES') }}">
+ 			<div class="cbb-dialog-content dialog-content">
+ 				<ul class="js-quickquote-list">
+@@ -41,13 +41,13 @@
+ 				</div>
+ 			</div>
+ 		</div>
+-	</template>
++	</script>
+ 
+ 	<script>
+-	head.ready(['cbbcore.min.js', 'quickquote.min.js'], function() {
++	head.ready(['cbbcore.min.js', 'quickquote.min.js'], function () {
+ 		cbbCore.initService('quickquote', {
+ 			btnTarget		: {% if QQ_FLOAT_BTN %}'body'{% else %}'#qr_postform .form-group:has(.btn), #postform .form-actions'{% endif %},
+-			target			: 'article .content, .pm .content, .block-postbody',
++			target			: 'article .content, .pm .content',
+ 			editors			: {
+ 				phpbb: '#qr_postform textarea[name], #postform textarea[name]'
+ 			},
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickquote/styles/FLATBOOTS/template/event/overall_footer_body_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickquote/styles/FLATBOOTS/template/event/overall_footer_body_after.html"
+index c8f711fb9..d0722b652 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickquote/styles/FLATBOOTS/template/event/overall_footer_body_after.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickquote/styles/FLATBOOTS/template/event/overall_footer_body_after.html"
+@@ -1,21 +1,21 @@
+ {% if QQ_ENABLED %}
+-	<template id="quickquote-tooltip">
++	<script type="text/html" id="tpl-quickquote-tooltip">
+ 		<div class="quickquote-tooltip">
+ 			<a href="#" data-action="quote"><i class="fa fa-plus"></i> {{ lang('QQ_SAVE_QUOTE') }}</a>
+ 			<span class="tooltip-sep">|</span>
+ 			<a href="#" data-action="reply"><i class="fa fa-reply"></i> {{ lang('QQ_REPLY') }}</a>
+ 		</div>
+-	</template>
++	</script>
+ 
+-	<template id="quickquote-floatbtn">
+-		<a href="#" class="quickquote-floatbtn btn btn-default" data-text="{{ lang('QUOTES') }}"></a>
+-	</template>
++	<script type="text/html" id="tpl-quickquote-floatbtn">
++	<a href="#" class="quickquote-floatbtn btn btn-default" data-text="{{ lang('QUOTES') }}"></a>
++	</script>
+ 
+-	<template id="quickquote-inlinebtn">
++	<script type="text/html" id="tpl-quickquote-inlinebtn">
+ 		<button type="button" class="btn btn-default" value="1" data-text="{{ lang('QQ_INSERT_QUOTES') }}"></button>
+-	</template>
++	</script>
+ 
+-	<template id="quickquote-dialog">
++	<script type="text/html" id="tpl-quickquote-dialog">
+ 		<div class="qq-dialog" title="{{ lang('QUOTES') }}">
+ 			<div class="cbb-dialog-content dialog-content">
+ 				<ul class="js-quickquote-list">
+@@ -41,13 +41,13 @@
+ 				</div>
+ 			</div>
+ 		</div>
+-	</template>
++	</script>
+ 
+ 	<script>
+-	head.ready(['cbbcore.min.js', 'quickquote.min.js'], function() {
++	head.ready(['cbbcore.min.js', 'quickquote.min.js'], function () {
+ 		cbbCore.initService('quickquote', {
+ 			btnTarget		: {% if QQ_FLOAT_BTN %}'body'{% else %}'#qr_postform .form-group:has(.btn), #postform .form-actions'{% endif %},
+-			target			: 'article .content, .pm .content, .block-postbody',
++			target			: 'article .content, .pm .content',
+ 			editors			: {
+ 				phpbb: '#qr_postform textarea[name], #postform textarea[name]'
+ 			},
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickquote/styles/all/template/event/overall_footer_body_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickquote/styles/all/template/event/overall_footer_body_after.html"
+index ac19e9a03..dddd9f9c1 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickquote/styles/all/template/event/overall_footer_body_after.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickquote/styles/all/template/event/overall_footer_body_after.html"
+@@ -1,21 +1,21 @@
+ {% if QQ_ENABLED %}
+-	<template id="quickquote-tooltip">
++	<script type="text/html" id="tpl-quickquote-tooltip">
+ 		<div class="quickquote-tooltip">
+ 			<a href="#" data-action="quote"><i class="fa fa-plus"></i>{{ lang('QQ_SAVE_QUOTE') }}</a>
+ 			<span class="tooltip-sep">|</span>
+ 			<a href="#" data-action="reply"><i class="fa fa-reply"></i>{{ lang('QQ_REPLY') }}</a>
+ 		</div>
+-	</template>
++	</script>
+ 
+-	<template id="quickquote-floatbtn">
+-		<a href="#" class="quickquote-floatbtn button" data-text="{{ lang('QUOTES') }}"></a>
+-	</template>
++	<script type="text/html" id="tpl-quickquote-floatbtn">
++	<a href="#" class="quickquote-floatbtn button" data-text="{{ lang('QUOTES') }}"></a>
++	</script>
+ 
+-	<template id="quickquote-inlinebtn">
+-		<input type="button" class="button1 quickquote-inlinebtn" data-text="{{ lang('QQ_INSERT_QUOTES') }}" />
+-	</template>
++	<script type="text/html" id="tpl-quickquote-inlinebtn">
++	<input type="button" class="button1 quickquote-inlinebtn" data-text="{{ lang('QQ_INSERT_QUOTES') }}" />
++	</script>
+ 
+-	<template id="quickquote-dialog">
++	<script type="text/html" id="tpl-quickquote-dialog">
+ 		<div class="qq-dialog" title="{{ lang('QUOTES') }}">
+ 			<div class="cbb-dialog-content dialog-content">
+ 				<ul class="js-quickquote-list">
+@@ -41,7 +41,7 @@
+ 				</div>
+ 			</div>
+ 		</div>
+-	</template>
++	</script>
+ 
+ 	<script>
+ 	(function($) {
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickquote/styles/all/template/quickquote.min.js" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickquote/styles/all/template/quickquote.min.js"
+index 34f91c61c..05647e644 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickquote/styles/all/template/quickquote.min.js"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickquote/styles/all/template/quickquote.min.js"
+@@ -1,8 +1,8 @@
+ /**
+  * @package cBB QuickQuote
+- * @version 1.0.5 08/04/2025
++ * @version 1.0.4 01/06/2024
+  *
+- * @copyright (c) 2025 CaniDev
++ * @copyright (c) 2024 CaniDev
+  * @license https://creativecommons.org/licenses/by-nc/4.0/
+  */
+-((h,c,u,s)=>{var d="quickquote_reply",p="quickquote_ary";c.registerService("quickquote",{options:{btnTarget:"body",editors:{},replyURL:"",replyOverwrite:!1,target:null},bbcodes:{b:{elem:'span[style="font-weight: bold"]',replacement:"[b]{html}[/b]"},i:{elem:'span[style="font-style: italic"]',replacement:"[i]{html}[/i]"},u:{elem:'span[style="text-decoration: underline"]',replacement:"[u]{html}[/u]"},code:{elem:"div.codebox",replacement:function(){return"[code]"+h(this).find("code").html()+"[/code]"}},quote:{elem:"blockquote",replacement:function(){var t=h(this).find("cite"),e="";return t.length&&(e='="'+t.text().replace("&nbsp;"," ").split(/\s/)[0]+'"',t.remove()),"[quote"+e+"]"+(h(this).children("div").length?h(this).children("div"):h(this)).html()+"[/quote]"}},url:{elem:"a[href]",replacement:function(){var t=h(this).html(),e=h(this).attr("href");return t==e?"[url]"+e+"[/url]":"[url="+e+"]"+t+"[/url]"}},img:{elem:"img[src]",replacement:function(){return h(this).hasClass("smilies")?h(this).attr("alt"):"[img]"+h(this).attr("src")+"[/img]"}},ul:{elem:"ul",replacement:"[list]{html}[/list]"},ol:{elem:"ol",replacement:"[list=1]{html}[/list]"},li:{elem:"li",replacement:"[*]{html}\n"},color:{elem:'span[style^="color"]',replacement:"[color={css:color}]{html}[/color]"},size:{elem:'span[style^="font-size"]',replacement:function(){return"[size="+h(this).css("font-size").replace("%","")+"]"+h(this).html()+"[/size]"}}},$editors:{def:"",length:0},$target:h([]),$dialog:null,$btn:null,isMouseDown:!1,stopPropagation:!1,mouseOffset:null,processing:!1,timeout:null,tooltip:null,__construct:function(){var i,t;u.getSelection&&((i=this).$target=h(this.options.target),this.options.replyOverwrite=!!+this.options.replyOverwrite,c.dispatchEvent("quickquote.beforeInit",this),h.each(this.options.editors,function(t,e){e=h(e);e.length&&(i.$editors[t]=e,i.$editors.length++,i.$editors.def&&"phpbb"!=t||(i.$editors.def=t))}),this.$editors.phpbb&&c.storage.get(d)&&(this.insert(c.storage.get(d),"phpbb",!0),c.storage.remove(d)),this.$target.length||this.$editors.length||this.options.replyURL||(this.options.btnTarget=!1),this.options.btnTarget&&(t=parseInt(h("body").css("font-size")),this.$btn=c.template.get("body"==this.options.btnTarget?"quickquote-floatbtn":"quickquote-inlinebtn",!1,!0),(!t||t<12)&&this.$btn.addClass("min-font-size"),this.$btn.appendTo(this.options.btnTarget),this.$btn.click(function(t){t.preventDefault(),i.initDialog(i.$editors.def)}),this.adjustButtons()),this.$target.length&&(this.$target.on("mousedown.qq",h.proxy(this,"mouseDown")),h(s).on({"selectionchange.qq":h.proxy(this,"selectionChange"),"mouseup.qq":h.proxy(this,"mouseUp")})),h(u).on("resize.quickquote",function(){null!=i.tooltip&&i.handleSelection()}),c.dispatchEvent("quickquote.onInit",this))},initDialog:function(e){this.$dialog=c.template.get("quickquote-dialog",!1,!0);var t=this.$dialog.find(".js-quickquote-list"),i=t.html(),o=this;t.hide(),this.adjustButtons([]),this.$dialog.data("quoteData",{storeData:c.storage.get(p)||[],rowStr:i,list:t}).cbbDialog({destroyOnClose:!0,movable:!1,height:300,width:700,onOpen:function(){h(this).find("a[data-action]").click(function(t){return t.preventDefault(),o.dialogTrigger(this,e)}),o.dataToDialog(e),o.$editors.length||o.options.replyURL||h(this).find('[data-action="insertAll"], [data-action="insertSelected"]').hide(),t.show()},onClose:function(){o.$dialog=null,o.adjustButtons(),c.dispatchEvent("quickquote.onCloseDialog",this)}}),c.dispatchEvent("quickquote.onInitDialog",this)},dataToDialog:function(e){var i=this,o=this.$dialog.data("quoteData");o.list.html(""),h.each(o.storeData,function(t,e){e.id=t,o.list.append(c.template.parse(o.rowStr,e))}),o.list.find("a[data-action]").click(function(t){return t.preventDefault(),i.dialogTrigger(this,e)}),o.list.find('input[type="checkbox"]').change(function(t){t.preventDefault(),o.list.find('input[type="checkbox"]:checked').length?(h(".js-btn-marked").objView(!0),h(".js-btn-all").objView(!1)):(h(".js-btn-marked").objView(!1),h(".js-btn-all").objView(!0))}).change(),this.$editors.length||this.options.replyURL||o.list.find('[data-action="insert"]').hide()},dialogTrigger:function(t,e){var i=h(t).attr("data-action"),o=null,n=this,s=this.$dialog.data("quoteData");switch("insert"!=i&&"remove"!=i||(o=parseInt(h(t).siblings("input").val())),i){case"insert":case"insertAll":case"insertSelected":var l=[];if(null!==o?l.push(s.storeData[o]):"insertSelected"==i?s.list.find('input[type="checkbox"]:checked').each(function(){l.push(s.storeData[this.value])}):h.each(s.storeData,function(t,e){l.push(e)}),n.$editors[e])n.insert(l,e);else{if(n.$editors.length||!n.options.replyURL)break;c.storage.set(d,l),u.location.href=n.options.replyURL}case"remove":case"removeAll":case"removeSelected":var a=h.extend([],s.storeData),r=[];null!==o?r.push(o):"removeSelected"==i||"insertSelected"==i?s.list.find('input[type="checkbox"]:checked').each(function(){r.push(parseInt(this.value)),s.list.children().has('input[value="'+this.value+'"]').fadeOut()}):(s.storeData=[],s.list.children().fadeOut()),r.length&&(s.storeData=[],h.each(a,function(t,e){-1==h.inArray(t,r)&&s.storeData.push(e)}))}s.storeData.length||(s.storeData=null),c.storage.set(p,s.storeData),s.storeData?n.dataToDialog(e):n.$dialog.cbbDialog("close")},buildQuote:function(t,e){var i="[quote]";return t.username&&(i='[quote="<%username%>"',i=(i+=t.post?" post_id=<%post%>":"")+(t.time?" time=<%time%> user_id=<%user%>":"")+"]"),c.template.parse(i,t)+this.htmlToBBcode(t.text,e)+"[/quote]"},insert:function(t,e,i){var o="";t=h.isArray(t)?t:[t];for(var n,s,l,a=0;a<t.length;a++)o+=this.buildQuote(t[a],e)+"\n";this.$editors[e][0]._sceditor?(!0===i&&this.$editors[e][0]._sceditor.val(""),this.$editors[e][0]._sceditor.insert(o).focus(),s=this.$editors[e][0]._sceditor.getRangeHelper(),n=h(s.parentNode()).closest("blockquote").get(0),(l=s.selectedRange()).setStartAfter(n),l.collapse(!0),s.selectRange(l)):(!0===i&&this.$editors[e].val(""),n=this.$editors[e].val(),s=this.$editors[e].cbbCaret(),l=n.substring(0,s.start),i=n.substring(s.end,n.length),this.$editors[e].val(n=l+(o+="\n")+i).cbbCaret(l.length+o.length).focus())},mouseDown:function(t){this.isMouseDown=!0,this.stopPropagation=0<h(t.target).closest("a").length},mouseUp:function(t){this.isMouseDown&&(this.isMouseDown=!1,this.trigger(),this.mouseOffset={x:t.clientX,y:t.clientY})},selectionChange:function(){this.isMouseDown||this.trigger()},trigger:function(){this.timeout||this.processing||(this.timeout=setTimeout(h.proxy(this,"handleSelection"),100))},handleSelection:function(){this.processing=!0,this.timeout=null;var t=u.getSelection(),e=this.stopPropagation?null:this.getValidSelectionContainer(t),i=(e?this.showQuoteButton(e,t):this.hideQuoteButton(),this);setTimeout(function(){i.processing=!1,i.mouseOffset=null},0)},getValidSelectionContainer:function(t){return!t.isCollapsed&&t.rangeCount&&(t=t.getRangeAt(0),h.trim(t.toString()).length||t.cloneContents().querySelectorAll("img").length)&&(t=h(t.commonAncestorContainer).closest(this.options.target)).length?t:null},showQuoteButton:function(t,e){var i=e.getRangeAt(0).cloneRange(),o=i.getBoundingClientRect?i.getBoundingClientRect():null,n=h(s).scrollTop(),e=(null!=this.tooltip&&this.hideQuoteButton(),this.createButton(t,i),this.tooltip.data("quote",{text:this.getSelectionHtml(e),container:t,target:"phpbb"}),i={left:o.left+o.width/2,top:o.top+o.height+n+5},null!==this.mouseOffset&&i.left>this.mouseOffset.x&&(i.left=this.mouseOffset.x),{left:i.left-this.tooltip.outerWidth()/2,top:i.top});e.left=Math.max(0,e.left),e.left+this.tooltip.outerWidth()>h(u).width()&&(e.left=h(u).width()<this.tooltip.outerWidth()),e.top+this.tooltip.outerHeight()>h(u).height()+n&&(e.top=o.top-this.tooltip.outerHeight()+n-5),this.tooltip.css(e).show(),c.dispatchEvent("quickquote.onShowTooltip",this)},createButton:function(l,a){var r=this,t=parseInt(h("body").css("font-size"));r.tooltip=c.template.get("quickquote-tooltip",null,!0),(!t||t<11)&&r.tooltip.addClass("min-font-size"),r.tooltip.appendTo("body").find("a").click(function(t){t.preventDefault();var e={action:h(this).attr("data-action"),container:l,data:r.tooltip.data("quote"),currentTarget:a.commonAncestorContainer};switch(e.data.postInfo=l.children(".js-qq-post-info:first"),(e=c.dispatchEvent("quickquote.onTooltipAction",e)).action){case"quote":case"reply":var i,o=h("<div />").append(e.data.text),n=r.$editors[e.data.target];try{i=JSON.parse(e.data.postInfo.text())}catch(t){i={}}if(r.repaseCode(o),i.text=o.html(),"reply"==e.action){if(n){r.insert(i,e.data.target,r.options.replyOverwrite);break}"phpbb"==e.data.target&&r.options.replyURL&&(c.storage.set(d,i),u.location.href=r.options.replyURL)}else{o=c.storage.get(p)||[];o.push(i),c.storage.set(p,o),r.adjustButtons(o)}}var s=u.getSelection();s.isCollapsed||(s.collapse(s.getRangeAt(0).commonAncestorContainer,0),r.hideQuoteButton())})},adjustButtons:function(t){var e,i;return(t=void 0===t?c.storage.get(p)||[]:t).length?(null!==this.$btn&&(e=this.$btn.attr("data-text")+" ("+t.length+")",i=this.$btn.is("input")?"val":"html",this.$btn[i].call(this.$btn,e),this.$btn.show()),c.dispatchEvent("quickquote.onShowBtn",{quickquote:this,storedData:t}),!0):(null!==this.$btn&&this.$btn.hide(),c.dispatchEvent("quickquote.onHideBtn",[this,t]),!1)},hideQuoteButton:function(){this.tooltip&&(this.tooltip.fadeOut("fast",function(){h(this).remove()}),this.tooltip=null)},getSelectionHtml:function(t){let e=s.createElement("div"),i,o;for(i=0,o=t.rangeCount;i<o;i++)e.appendChild(t.getRangeAt(i).cloneContents());return h(e).find("[data-decoded]").each(function(){h(this).replaceWith(h(this).attr("data-decoded"))}),e.innerHTML},htmlToBBcode:function(t,e){var i=h("<div />").append(t.replace(/<br>\n/g,"<br>"));return this.repaseCode(i),e&&this.$editors[e]&&this.$editors[e][0]._sceditor?this.$editors[e][0]._sceditor.toBBCode(i.html()):(h.each(this.bbcodes,function(t,e){i.find(e.elem).each(function(){var o=h(this),t="function"==typeof e.replacement?e.replacement.apply(o):e.replacement.replace("{html}",o.html()).replace("{text}",o.text()).replace(/\{(attr|css):([\d\w]+)\}/,function(t,e,i){return"css"==e?c.rgbToHex(o[e].apply(o,[i])):o[e].apply(o,[i])});o.replaceWith(t)})}),i.find("br").replaceWith("\n"),i.text())},repaseCode:function(t){var e,i=t.children("li");i.length&&((e=h("<ul />")).append(i.clone()),i.filter(":first").before(e),i.remove()),t.find(".js-qq-post-info, .cbb-helper-hidden").remove()}},!1)})(jQuery,cbbCore,window,document);
+\ No newline at end of file
++!function(h,c,u,s){"use strict";var d="quickquote_reply",p="quickquote_ary";c.registerService("quickquote",{options:{btnTarget:"body",editors:{},replyURL:"",replyOverwrite:!1,target:null},bbcodes:{b:{elem:'span[style="font-weight: bold"]',replacement:"[b]{html}[/b]"},i:{elem:'span[style="font-style: italic"]',replacement:"[i]{html}[/i]"},u:{elem:'span[style="text-decoration: underline"]',replacement:"[u]{html}[/u]"},code:{elem:"div.codebox",replacement:function(){return"[code]"+h(this).find("code").html()+"[/code]"}},quote:{elem:"blockquote",replacement:function(){var t=h(this).find("cite"),e="";return t.length&&(e='="'+t.text().replace("&nbsp;"," ").split(/\s/)[0]+'"',t.remove()),"[quote"+e+"]"+(h(this).children("div").length?h(this).children("div"):h(this)).html()+"[/quote]"}},url:{elem:"a[href]",replacement:function(){var t=h(this).html(),e=h(this).attr("href");return t==e?"[url]"+e+"[/url]":"[url="+e+"]"+t+"[/url]"}},img:{elem:"img[src]",replacement:function(){return h(this).hasClass("smilies")?h(this).attr("alt"):"[img]"+h(this).attr("src")+"[/img]"}},ul:{elem:"ul",replacement:"[list]{html}[/list]"},ol:{elem:"ol",replacement:"[list=1]{html}[/list]"},li:{elem:"li",replacement:"[*]{html}\n"},color:{elem:'span[style^="color"]',replacement:"[color={css:color}]{html}[/color]"},size:{elem:'span[style^="font-size"]',replacement:function(){return"[size="+h(this).css("font-size").replace("%","")+"]"+h(this).html()+"[/size]"}}},$editors:{def:"",length:0},$target:h([]),$dialog:null,$btn:null,isMouseDown:!1,stopPropagation:!1,mouseOffset:null,processing:!1,timeout:null,tooltip:null,__construct:function(){var i,t;u.getSelection&&((i=this).$target=h(this.options.target),this.options.replyOverwrite=!!+this.options.replyOverwrite,c.dispatchEvent("quickquote.beforeInit",this),h.each(this.options.editors,function(t,e){e=h(e);e.length&&(i.$editors[t]=e,i.$editors.length++,i.$editors.def&&"phpbb"!=t||(i.$editors.def=t))}),this.$editors.phpbb&&c.storage.get(d)&&(this.insert(c.storage.get(d),"phpbb",!0),c.storage.remove(d)),this.$target.length||this.$editors.length||this.options.replyURL||(this.options.btnTarget=!1),this.options.btnTarget&&(t=parseInt(h("body").css("font-size")),this.$btn=c.template.get("body"==this.options.btnTarget?"quickquote-floatbtn":"quickquote-inlinebtn",!1,!0),(!t||t<12)&&this.$btn.addClass("min-font-size"),this.$btn.appendTo(this.options.btnTarget),this.$btn.click(function(t){t.preventDefault(),i.initDialog(i.$editors.def)}),this.adjustButtons()),this.$target.length&&(this.$target.on("mousedown.qq",h.proxy(this,"mouseDown")),h(s).on({"selectionchange.qq":h.proxy(this,"selectionChange"),"mouseup.qq":h.proxy(this,"mouseUp")})),h(u).on("resize.quickquote",function(){null!=i.tooltip&&i.handleSelection()}),c.dispatchEvent("quickquote.onInit",this))},initDialog:function(e){this.$dialog=c.template.get("quickquote-dialog",!1,!0);var t=this.$dialog.find(".js-quickquote-list"),i=t.html(),o=this;t.hide(),this.adjustButtons([]),this.$dialog.data("quoteData",{storeData:c.storage.get(p)||[],rowStr:i,list:t}).cbbDialog({destroyOnClose:!0,movable:!1,height:300,width:700,onOpen:function(){h(this).find("a[data-action]").click(function(t){return t.preventDefault(),o.dialogTrigger(this,e)}),o.dataToDialog(e),o.$editors.length||o.options.replyURL||h(this).find('[data-action="insertAll"], [data-action="insertSelected"]').hide(),t.show()},onClose:function(){o.$dialog=null,o.adjustButtons(),c.dispatchEvent("quickquote.onCloseDialog",this)}}),c.dispatchEvent("quickquote.onInitDialog",this)},dataToDialog:function(e){var i=this,o=this.$dialog.data("quoteData");o.list.html(""),h.each(o.storeData,function(t,e){e.id=t,o.list.append(c.template.parse(o.rowStr,e))}),o.list.find("a[data-action]").click(function(t){return t.preventDefault(),i.dialogTrigger(this,e)}),o.list.find('input[type="checkbox"]').change(function(t){t.preventDefault(),o.list.find('input[type="checkbox"]:checked').length?(h(".js-btn-marked").objView(!0),h(".js-btn-all").objView(!1)):(h(".js-btn-marked").objView(!1),h(".js-btn-all").objView(!0))}).change(),this.$editors.length||this.options.replyURL||o.list.find('[data-action="insert"]').hide()},dialogTrigger:function(t,e){var i=h(t).attr("data-action"),o=null,n=this,s=this.$dialog.data("quoteData");switch("insert"!=i&&"remove"!=i||(o=parseInt(h(t).siblings("input").val())),i){case"insert":case"insertAll":case"insertSelected":var l=[];if(null!==o?l.push(s.storeData[o]):"insertSelected"==i?s.list.find('input[type="checkbox"]:checked').each(function(){l.push(s.storeData[this.value])}):h.each(s.storeData,function(t,e){l.push(e)}),n.$editors[e])n.insert(l,e);else{if(n.$editors.length||!n.options.replyURL)break;c.storage.set(d,l),u.location.href=n.options.replyURL}case"remove":case"removeAll":case"removeSelected":var a=h.extend([],s.storeData),r=[];null!==o?r.push(o):"removeSelected"==i||"insertSelected"==i?s.list.find('input[type="checkbox"]:checked').each(function(){r.push(parseInt(this.value)),s.list.children().has('input[value="'+this.value+'"]').fadeOut()}):(s.storeData=[],s.list.children().fadeOut()),r.length&&(s.storeData=[],h.each(a,function(t,e){-1==h.inArray(t,r)&&s.storeData.push(e)}))}s.storeData.length||(s.storeData=null),c.storage.set(p,s.storeData),s.storeData?n.dataToDialog(e):n.$dialog.cbbDialog("close")},buildQuote:function(t,e){var i="[quote]";return t.username&&(i='[quote="<%username%>"',i=(i+=t.post?" post_id=<%post%>":"")+(t.time?" time=<%time%> user_id=<%user%>":"")+"]"),c.template.parse(i,t)+this.htmlToBBcode(t.text,e)+"[/quote]"},insert:function(t,e,i){var o="";t=h.isArray(t)?t:[t];for(var n,s,l,a=0;a<t.length;a++)o+=this.buildQuote(t[a],e)+"\n";this.$editors[e][0]._sceditor?(!0===i&&this.$editors[e][0]._sceditor.val(""),this.$editors[e][0]._sceditor.insert(o).focus(),s=this.$editors[e][0]._sceditor.getRangeHelper(),n=h(s.parentNode()).closest("blockquote").get(0),(l=s.selectedRange()).setStartAfter(n),l.collapse(!0),s.selectRange(l)):(!0===i&&this.$editors[e].val(""),n=this.$editors[e].val(),s=this.$editors[e].cbbCaret(),l=n.substring(0,s.start),i=n.substring(s.end,n.length),this.$editors[e].val(n=l+(o+="\n")+i).cbbCaret(l.length+o.length).focus())},mouseDown:function(t){this.isMouseDown=!0,this.stopPropagation=0<h(t.target).closest("a").length},mouseUp:function(t){this.isMouseDown&&(this.isMouseDown=!1,this.trigger(),this.mouseOffset={x:t.clientX,y:t.clientY})},selectionChange:function(){this.isMouseDown||this.trigger()},trigger:function(){this.timeout||this.processing||(this.timeout=setTimeout(h.proxy(this,"handleSelection"),100))},handleSelection:function(){this.processing=!0,this.timeout=null;var t=u.getSelection(),e=this.stopPropagation?null:this.getValidSelectionContainer(t),i=(e?this.showQuoteButton(e,t):this.hideQuoteButton(),this);setTimeout(function(){i.processing=!1,i.mouseOffset=null},0)},getValidSelectionContainer:function(t){return!t.isCollapsed&&t.rangeCount&&(t=t.getRangeAt(0),h.trim(t.toString()).length||t.cloneContents().querySelectorAll("img").length)&&(t=h(t.commonAncestorContainer).closest(this.options.target)).length?t:null},showQuoteButton:function(t,e){var i=e.getRangeAt(0).cloneRange(),o=i.getBoundingClientRect?i.getBoundingClientRect():null,n=h(s).scrollTop(),e=(null!=this.tooltip&&this.hideQuoteButton(),this.createButton(t,i),this.tooltip.data("quote",{text:this.getSelectionHtml(e),container:t,target:"phpbb"}),i={left:o.left+o.width/2,top:o.top+o.height+n+5},null!==this.mouseOffset&&i.left>this.mouseOffset.x&&(i.left=this.mouseOffset.x),{left:i.left-this.tooltip.outerWidth()/2,top:i.top});e.left=Math.max(0,e.left),e.left+this.tooltip.outerWidth()>h(u).width()&&(e.left=h(u).width()<this.tooltip.outerWidth()),e.top+this.tooltip.outerHeight()>h(u).height()+n&&(e.top=o.top-this.tooltip.outerHeight()+n-5),this.tooltip.css(e).show(),c.dispatchEvent("quickquote.onShowTooltip",this)},createButton:function(l,a){var r=this,t=parseInt(h("body").css("font-size"));r.tooltip=c.template.get("quickquote-tooltip",null,!0),(!t||t<11)&&r.tooltip.addClass("min-font-size"),r.tooltip.appendTo("body").find("a").click(function(t){t.preventDefault();var e={action:h(this).attr("data-action"),container:l,data:r.tooltip.data("quote"),currentTarget:a.commonAncestorContainer};switch(e.data.postInfo=l.children(".js-qq-post-info:first"),(e=c.dispatchEvent("quickquote.onTooltipAction",e)).action){case"quote":case"reply":var i,o=h("<div />").append(e.data.text),n=r.$editors[e.data.target];try{i=JSON.parse(e.data.postInfo.text())}catch(t){i={}}if(r.repaseCode(o),i.text=o.html(),"reply"==e.action){if(n){r.insert(i,e.data.target,r.options.replyOverwrite);break}"phpbb"==e.data.target&&r.options.replyURL&&(c.storage.set(d,i),u.location.href=r.options.replyURL)}else{o=c.storage.get(p)||[];o.push(i),c.storage.set(p,o),r.adjustButtons(o)}}var s=u.getSelection();s.isCollapsed||(s.collapse(s.getRangeAt(0).commonAncestorContainer,0),r.hideQuoteButton())})},adjustButtons:function(t){var e,i;return(t=void 0===t?c.storage.get(p)||[]:t).length?(null!==this.$btn&&(e=this.$btn.attr("data-text")+" ("+t.length+")",i=this.$btn.is("input")?"val":"html",this.$btn[i].call(this.$btn,e),this.$btn.show()),c.dispatchEvent("quickquote.onShowBtn",{quickquote:this,storedData:t}),!0):(null!==this.$btn&&this.$btn.hide(),c.dispatchEvent("quickquote.onHideBtn",[this,t]),!1)},hideQuoteButton:function(){this.tooltip&&(this.tooltip.fadeOut("fast",function(){h(this).remove()}),this.tooltip=null)},getSelectionHtml:function(t){let e=s.createElement("div"),i,o;for(i=0,o=t.rangeCount;i<o;i++)e.appendChild(t.getRangeAt(i).cloneContents());return h(e).find("[data-decoded]").each(function(){h(this).replaceWith(h(this).attr("data-decoded"))}),e.innerHTML},htmlToBBcode:function(t,e){var i=h("<div />").append(t.replace(/<br>\n/g,"<br>"));return this.repaseCode(i),e&&this.$editors[e]&&this.$editors[e][0]._sceditor?this.$editors[e][0]._sceditor.toBBCode(i.html()):(h.each(this.bbcodes,function(t,e){i.find(e.elem).each(function(){var o=h(this),t="function"==typeof e.replacement?e.replacement.apply(o):e.replacement.replace("{html}",o.html()).replace("{text}",o.text()).replace(/\{(attr|css):([\d\w]+)\}/,function(t,e,i){return"css"==e?c.rgbToHex(o[e].apply(o,[i])):o[e].apply(o,[i])});o.replaceWith(t)})}),i.find("br").replaceWith("\n"),i.text())},repaseCode:function(t){var e,i=t.children("li");i.length&&((e=h("<ul />")).append(i.clone()),i.filter(":first").before(e),i.remove()),t.find(".js-qq-post-info, .cbb-helper-hidden").remove()}},!1)}(jQuery,cbbCore,window,document);
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickquote/styles/all/theme/quickquote.css" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickquote/styles/all/theme/quickquote.css"
+index d9ef98945..7f91eec5d 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickquote/styles/all/theme/quickquote.css"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickquote/styles/all/theme/quickquote.css"
+@@ -1,7 +1,7 @@
+ /*  cBB QuickQuote StyleSheet
+     --------------------------------------------------------------
+ 	Style:	All
+-	Copyright (c) 2025 CaniDev ( https://www.canidev.com )
++	Copyright (c) 2024 CaniDev ( https://www.canidev.com )
+     --------------------------------------------------------------
+ */
+ 
+@@ -139,11 +139,6 @@
+ 
+ /* RTL
+ ------------------------- */
+-.rtl .quickquote-tooltip a > i {
+-	margin-left: 5px;
+-	margin-right: unset;
+-}
+-
+ .rtl .quickquote-floatbtn {
+ 	left: 60px;
+ 	padding: 10px 10px 10px 30px;
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickquote/styles/zeina/template/event/overall_footer_body_after.html" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickquote/styles/zeina/template/event/overall_footer_body_after.html"
+deleted file mode 100644
+index 2239fa457..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickquote/styles/zeina/template/event/overall_footer_body_after.html"
++++ /dev/null
+@@ -1,59 +0,0 @@
+-{% if QQ_ENABLED %}
+-	<template id="quickquote-tooltip">
+-		<div class="quickquote-tooltip">
+-			<a href="#" data-action="quote"><i class="fa fa-plus"></i>{{ lang('QQ_SAVE_QUOTE') }}</a>
+-			<span class="tooltip-sep">|</span>
+-			<a href="#" data-action="reply"><i class="fa fa-reply"></i>{{ lang('QQ_REPLY') }}</a>
+-		</div>
+-	</template>
+-
+-	<template id="quickquote-floatbtn">
+-		<a href="#" class="quickquote-floatbtn card-sm" data-text="{{ lang('QUOTES') }}"></a>
+-	</template>
+-
+-	<template id="quickquote-inlinebtn">
+-		<button class="btn-primary-outline relative flex overflow-hidden transition-all duration-300 justify-center max-md:w-full quickquote-inlinebtn" data-text="{{ lang('QQ_INSERT_QUOTES') }}"></button>
+-	</template>
+-
+-	<template id="quickquote-dialog">
+-		<div class="qq-dialog" title="{{ lang('QUOTES') }}">
+-			<div class="cbb-dialog-content dialog-content">
+-				<ul class="js-quickquote-list">
+-					<li>
+-						<div class="titlebar">
+-							<input id="check-<%id%>" type="checkbox" class="cbb-checkbox" value="<%id%>" />
+-							<label for="check-<%id%>"></label><span><%username%></span>
+-							<a href="#" data-action="remove" title="{{ lang('QQ_REMOVE') }}"><i class="fa fa-close"></i></a>
+-							<a href="#" data-action="insert" title="{{ lang('QQ_INSERT') }}"><i class="fa fa-download"></i></a>
+-						</div>
+-						<div class="content"><%text%></div>
+-					</li>
+-				</ul>
+-			</div>
+-			<div class="cbb-dialog-buttons">
+-				<div class="js-btn-marked cbb-helper-hidden">
+-					<a href="#" class="cbb-btn" data-action="insertSelected">{{ lang('QQ_INSERT_SELECTED') }}</a>
+-					<a href="#" class="cbb-btn" data-action="removeSelected">{{ lang('QQ_REMOVE_SELECTED') }}</a>
+-				</div>
+-				<div class="js-btn-all cbb-helper-hidden">
+-					<a href="#" class="cbb-btn" data-action="insertAll">{{ lang('QQ_INSERT_ALL') }}</a>
+-					<a href="#" class="cbb-btn" data-action="removeAll">{{ lang('QQ_REMOVE_ALL') }}</a>
+-				</div>
+-			</div>
+-		</div>
+-	</template>
+-
+-	<script>
+-	(function($) {
+-		cbbCore.initService('quickquote', {
+-			btnTarget		: {% if QQ_FLOAT_BTN %}'body'{% else %}'#qr_postform div:has(.fullscreen-comment), #postform div:has(button[name="post"])'{% endif %},
+-			target			: '.post .content, .block-postbody',
+-			editors			: {
+-				phpbb: '#message-box textarea[name]'
+-			},
+-			replyURL		: '{{ U_QQ_REPLY }}',
+-			replyOverwrite	: '{{ QQ_REPLY_OVERWRITE }}'
+-		});
+-	})(jQuery);
+-	</script>
+-{% endif %}
diff --git "[FORUM_EXT]/canidev\\quickquote/diff_nospace.tmp" "[FORUM_EXT]/canidev\\quickquote/diff_nospace.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/canidev\\quickquote/diff_nospace.tmp"
@@ -0,0 +1,619 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickquote/acp/config_info.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickquote/acp/config_info.php"
+index 5b2d695b0..bbe64e71b 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickquote/acp/config_info.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickquote/acp/config_info.php"
+@@ -1,9 +1,9 @@
+ <?php
+ /**
+  * @package cBB Quickquote
+- * @version 1.0.5 08/04/2025
++ * @version 1.0.4 01/06/2024
+  *
+- * @copyright (c) 2025 CaniDev
++ * @copyright (c) 2024 CaniDev
+  * @license https://creativecommons.org/licenses/by-nc/4.0/
+  */
+ 
+@@ -16,7 +16,7 @@ class config_info
+ 		return [
+ 			'filename'	=> '\canidev\quickquote\acp\config_module',
+ 			'title'		=> 'ACP_CAT_QUICKQUOTE',
+-			'version'	=> '1.0.5',
++			'version'	=> '1.0.4',
+ 			'modes'		=> [
+ 				'config'	=> ['title' => 'ACP_QUICKQUOTE_CONFIG',		'auth' => 'ext_canidev/quickquote && acl_a_board', 'cat' => ['ACP_CAT_QUICKQUOTE']],
+ 			],
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickquote/acp/config_module.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickquote/acp/config_module.php"
+index 419266075..32f29fe53 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickquote/acp/config_module.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickquote/acp/config_module.php"
+@@ -1,9 +1,9 @@
+ <?php
+ /**
+  * @package cBB QuickQuote
+- * @version 1.0.5 08/04/2025
++ * @version 1.0.4 01/06/2024
+  *
+- * @copyright (c) 2025 CaniDev
++ * @copyright (c) 2024 CaniDev
+  * @license https://creativecommons.org/licenses/by-nc/4.0/
+  */
+ 
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickquote/adm/style/event/acp_overall_footer_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickquote/adm/style/event/acp_overall_footer_after.html"
+index f30a3f112..a266179f5 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickquote/adm/style/event/acp_overall_footer_after.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickquote/adm/style/event/acp_overall_footer_after.html"
+@@ -1,3 +1,3 @@
+-{% if IN_EXT_QUICKQUOTE and CANIDEV_CORE_STARTED %}
++{% if QUICKQUOTE_IN_ADMIN and CANIDEV_CORE_STARTED %}
+ 	{% include '@canidev_core/event/acp_overall_footer_after.html' %}
+ {% endif %}
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickquote/adm/style/event/acp_overall_header_head_append.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickquote/adm/style/event/acp_overall_header_head_append.html"
+index 173d4d230..6e95f0980 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickquote/adm/style/event/acp_overall_header_head_append.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickquote/adm/style/event/acp_overall_header_head_append.html"
+@@ -1,3 +1,3 @@
+-{% if IN_EXT_QUICKQUOTE and CANIDEV_CORE_STARTED %}
++{% if QUICKQUOTE_IN_ADMIN and CANIDEV_CORE_STARTED %}
+ 	{% include '@canidev_core/event/overall_header_head_append.html' %}
+ {% endif %}
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickquote/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickquote/composer.json"
+index 508890c17..b9ed46cc1 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickquote/composer.json"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickquote/composer.json"
+@@ -3,8 +3,7 @@
+ 	"type": "phpbb-extension",
+ 	"description": "",
+ 	"homepage": "https://www.canidev.com",
+-	"version": "1.0.5",
+-	"time": "2025-04-08",
++	"version": "1.0.4",
+ 	"keywords": ["phpbb", "extension", "canidev", "quotes"],
+ 	"license": "CreativeCommons Attribution-NonCommercial v4.0",
+ 	"authors": [
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickquote/controller/admin_controller_config.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickquote/controller/admin_controller_config.php"
+index 752784a7b..c5919c00a 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickquote/controller/admin_controller_config.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickquote/controller/admin_controller_config.php"
+@@ -1,9 +1,9 @@
+ <?php
+ /**
+  * @package cBB Quickquote
+- * @version 1.0.5 08/04/2025
++ * @version 1.0.4 01/06/2024
+  *
+- * @copyright (c) 2025 CaniDev
++ * @copyright (c) 2024 CaniDev
+  * @license https://creativecommons.org/licenses/by-nc/4.0/
+  */
+ 
+@@ -68,7 +68,7 @@ class admin_controller_config extends \canidev\core\controller\acp
+ 		if($submit)
+ 		{
+ 			$cfg_array = $this->request->variable('config', ['' => '']);
+-			$cfg_array['quickquote_groups'] = $this->tools->groups_select_submit('quickquote_groups');
++			$cfg_array['quickquote_groups'] = ($this->request->is_set_post('all_groups_quickquote_groups')) ? 'all' : $this->request->variable('quickquote_groups', [0]);
+ 
+ 			// We validate the complete config if whished
+ 			validate_config_vars($display_vars, $cfg_array, $error);
+@@ -92,7 +92,7 @@ class admin_controller_config extends \canidev\core\controller\acp
+ 		$this->new_config = $cfg_array;
+ 
+ 		// Do not write values if there is an error
+-		if(count($error))
++		if(sizeof($error))
+ 		{
+ 			$submit = false;
+ 		}
+@@ -107,7 +107,8 @@ class admin_controller_config extends \canidev\core\controller\acp
+ 
+ 			if($submit)
+ 			{
+-				$this->config->set($config_name, $this->new_config[$config_name]);
++				$value = is_array($this->new_config[$config_name]) ? implode(',', $this->new_config[$config_name]) : $this->new_config[$config_name];
++				$this->config->set($config_name, $value);
+ 			}
+ 		}
+ 
+@@ -117,7 +118,8 @@ class admin_controller_config extends \canidev\core\controller\acp
+ 		}
+ 		
+ 		$this->template->assign_vars([
+-			'S_ERROR'				=> count($error) > 0,
++			'QUICKQUOTE_IN_ADMIN'	=> true,
++			'S_ERROR'				=> (sizeof($error)) ? true : false,
+ 			'ERROR_MSG'				=> implode('<br />', $error),
+ 		]);
+ 
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickquote/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickquote/diff_full.tmp"
+new file mode 100644
+index 000000000..64b52f761
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickquote/diff_full.tmp"
+@@ -0,0 +1,564 @@
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickquote/acp/config_info.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickquote/acp/config_info.php"
++index 5b2d695b0..bbe64e71b 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickquote/acp/config_info.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickquote/acp/config_info.php"
++@@ -1,9 +1,9 @@
++ <?php
++ /**
++  * @package cBB Quickquote
++- * @version 1.0.5 08/04/2025
+++ * @version 1.0.4 01/06/2024
++  *
++- * @copyright (c) 2025 CaniDev
+++ * @copyright (c) 2024 CaniDev
++  * @license https://creativecommons.org/licenses/by-nc/4.0/
++  */
++ 
++@@ -16,7 +16,7 @@ class config_info
++ 		return [
++ 			'filename'	=> '\canidev\quickquote\acp\config_module',
++ 			'title'		=> 'ACP_CAT_QUICKQUOTE',
++-			'version'	=> '1.0.5',
+++			'version'	=> '1.0.4',
++ 			'modes'		=> [
++ 				'config'	=> ['title' => 'ACP_QUICKQUOTE_CONFIG',		'auth' => 'ext_canidev/quickquote && acl_a_board', 'cat' => ['ACP_CAT_QUICKQUOTE']],
++ 			],
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickquote/acp/config_module.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickquote/acp/config_module.php"
++index 419266075..32f29fe53 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickquote/acp/config_module.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickquote/acp/config_module.php"
++@@ -1,9 +1,9 @@
++ <?php
++ /**
++  * @package cBB QuickQuote
++- * @version 1.0.5 08/04/2025
+++ * @version 1.0.4 01/06/2024
++  *
++- * @copyright (c) 2025 CaniDev
+++ * @copyright (c) 2024 CaniDev
++  * @license https://creativecommons.org/licenses/by-nc/4.0/
++  */
++ 
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickquote/adm/style/event/acp_overall_footer_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickquote/adm/style/event/acp_overall_footer_after.html"
++index f30a3f112..a266179f5 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickquote/adm/style/event/acp_overall_footer_after.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickquote/adm/style/event/acp_overall_footer_after.html"
++@@ -1,3 +1,3 @@
++-{% if IN_EXT_QUICKQUOTE and CANIDEV_CORE_STARTED %}
+++{% if QUICKQUOTE_IN_ADMIN and CANIDEV_CORE_STARTED %}
++ 	{% include '@canidev_core/event/acp_overall_footer_after.html' %}
++ {% endif %}
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickquote/adm/style/event/acp_overall_header_head_append.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickquote/adm/style/event/acp_overall_header_head_append.html"
++index 173d4d230..6e95f0980 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickquote/adm/style/event/acp_overall_header_head_append.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickquote/adm/style/event/acp_overall_header_head_append.html"
++@@ -1,3 +1,3 @@
++-{% if IN_EXT_QUICKQUOTE and CANIDEV_CORE_STARTED %}
+++{% if QUICKQUOTE_IN_ADMIN and CANIDEV_CORE_STARTED %}
++ 	{% include '@canidev_core/event/overall_header_head_append.html' %}
++ {% endif %}
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickquote/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickquote/composer.json"
++index 508890c17..b9ed46cc1 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickquote/composer.json"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickquote/composer.json"
++@@ -3,8 +3,7 @@
++ 	"type": "phpbb-extension",
++ 	"description": "",
++ 	"homepage": "https://www.canidev.com",
++-	"version": "1.0.5",
++-	"time": "2025-04-08",
+++	"version": "1.0.4",
++ 	"keywords": ["phpbb", "extension", "canidev", "quotes"],
++ 	"license": "CreativeCommons Attribution-NonCommercial v4.0",
++ 	"authors": [
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickquote/controller/admin_controller_config.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickquote/controller/admin_controller_config.php"
++index 752784a7b..c5919c00a 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickquote/controller/admin_controller_config.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickquote/controller/admin_controller_config.php"
++@@ -1,9 +1,9 @@
++ <?php
++ /**
++  * @package cBB Quickquote
++- * @version 1.0.5 08/04/2025
+++ * @version 1.0.4 01/06/2024
++  *
++- * @copyright (c) 2025 CaniDev
+++ * @copyright (c) 2024 CaniDev
++  * @license https://creativecommons.org/licenses/by-nc/4.0/
++  */
++ 
++@@ -68,7 +68,7 @@ class admin_controller_config extends \canidev\core\controller\acp
++ 		if($submit)
++ 		{
++ 			$cfg_array = $this->request->variable('config', ['' => '']);
++-			$cfg_array['quickquote_groups'] = $this->tools->groups_select_submit('quickquote_groups');
+++			$cfg_array['quickquote_groups'] = ($this->request->is_set_post('all_groups_quickquote_groups')) ? 'all' : $this->request->variable('quickquote_groups', [0]);
++ 
++ 			// We validate the complete config if whished
++ 			validate_config_vars($display_vars, $cfg_array, $error);
++@@ -92,7 +92,7 @@ class admin_controller_config extends \canidev\core\controller\acp
++ 		$this->new_config = $cfg_array;
++ 
++ 		// Do not write values if there is an error
++-		if(count($error))
+++		if(sizeof($error))
++ 		{
++ 			$submit = false;
++ 		}
++@@ -107,7 +107,8 @@ class admin_controller_config extends \canidev\core\controller\acp
++ 
++ 			if($submit)
++ 			{
++-				$this->config->set($config_name, $this->new_config[$config_name]);
+++				$value = is_array($this->new_config[$config_name]) ? implode(',', $this->new_config[$config_name]) : $this->new_config[$config_name];
+++				$this->config->set($config_name, $value);
++ 			}
++ 		}
++ 
++@@ -117,7 +118,8 @@ class admin_controller_config extends \canidev\core\controller\acp
++ 		}
++ 		
++ 		$this->template->assign_vars([
++-			'S_ERROR'				=> count($error) > 0,
+++			'QUICKQUOTE_IN_ADMIN'	=> true,
+++			'S_ERROR'				=> (sizeof($error)) ? true : false,
++ 			'ERROR_MSG'				=> implode('<br />', $error),
++ 		]);
++ 
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickquote/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickquote/diff_full.tmp"
++new file mode 100644
++index 000000000..a9cf3f675
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickquote/diff_full.tmp"
++@@ -0,0 +1,69 @@
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickquote/acp/config_info.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickquote/acp/config_info.php"
+++index 5b2d695b0..bbe64e71b 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickquote/acp/config_info.php"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickquote/acp/config_info.php"
+++@@ -1,9 +1,9 @@
+++ <?php
+++ /**
+++  * @package cBB Quickquote
+++- * @version 1.0.5 08/04/2025
++++ * @version 1.0.4 01/06/2024
+++  *
+++- * @copyright (c) 2025 CaniDev
++++ * @copyright (c) 2024 CaniDev
+++  * @license https://creativecommons.org/licenses/by-nc/4.0/
+++  */
+++ 
+++@@ -16,7 +16,7 @@ class config_info
+++ 		return [
+++ 			'filename'	=> '\canidev\quickquote\acp\config_module',
+++ 			'title'		=> 'ACP_CAT_QUICKQUOTE',
+++-			'version'	=> '1.0.5',
++++			'version'	=> '1.0.4',
+++ 			'modes'		=> [
+++ 				'config'	=> ['title' => 'ACP_QUICKQUOTE_CONFIG',		'auth' => 'ext_canidev/quickquote && acl_a_board', 'cat' => ['ACP_CAT_QUICKQUOTE']],
+++ 			],
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickquote/acp/config_module.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickquote/acp/config_module.php"
+++index 419266075..32f29fe53 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickquote/acp/config_module.php"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickquote/acp/config_module.php"
+++@@ -1,9 +1,9 @@
+++ <?php
+++ /**
+++  * @package cBB QuickQuote
+++- * @version 1.0.5 08/04/2025
++++ * @version 1.0.4 01/06/2024
+++  *
+++- * @copyright (c) 2025 CaniDev
++++ * @copyright (c) 2024 CaniDev
+++  * @license https://creativecommons.org/licenses/by-nc/4.0/
+++  */
+++ 
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickquote/adm/style/event/acp_overall_footer_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickquote/adm/style/event/acp_overall_footer_after.html"
+++index f30a3f112..a266179f5 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickquote/adm/style/event/acp_overall_footer_after.html"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickquote/adm/style/event/acp_overall_footer_after.html"
+++@@ -1,3 +1,3 @@
+++-{% if IN_EXT_QUICKQUOTE and CANIDEV_CORE_STARTED %}
++++{% if QUICKQUOTE_IN_ADMIN and CANIDEV_CORE_STARTED %}
+++ 	{% include '@canidev_core/event/acp_overall_footer_after.html' %}
+++ {% endif %}
+++\ No newline at end of file
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickquote/adm/style/event/acp_overall_header_head_append.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickquote/adm/style/event/acp_overall_header_head_append.html"
+++index 173d4d230..6e95f0980 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickquote/adm/style/event/acp_overall_header_head_append.html"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickquote/adm/style/event/acp_overall_header_head_append.html"
+++@@ -1,3 +1,3 @@
+++-{% if IN_EXT_QUICKQUOTE and CANIDEV_CORE_STARTED %}
++++{% if QUICKQUOTE_IN_ADMIN and CANIDEV_CORE_STARTED %}
+++ 	{% include '@canidev_core/event/overall_header_head_append.html' %}
+++ {% endif %}
+++\ No newline at end of file
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickquote/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickquote/composer.json"
+++index 508890c17..b9ed46cc1 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickquote/composer.json"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickquote/composer.json"
+++@@ -3,8 +3,7 @@
+++ 	"type": "phpbb-extension",
+++ 	"description": "",
+++ 	"homepage": "https://ww
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickquote/event/listener.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickquote/event/listener.php"
++index 7278468ab..7d5f1373b 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickquote/event/listener.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickquote/event/listener.php"
++@@ -1,9 +1,9 @@
++ <?php
++ /**
++  * @package cBB Quickquote
++- * @version 1.0.5 08/04/2025
+++ * @version 1.0.4 01/06/2024
++  *
++- * @copyright (c) 2025 CaniDev
+++ * @copyright (c) 2024 CaniDev
++  * @license https://creativecommons.org/licenses/by-nc/4.0/
++  */
++ 
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickquote/ext.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickquote/ext.php"
++index 9a9ce33aa..555d5c57b 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickquote/ext.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickquote/ext.php"
++@@ -1,9 +1,9 @@
++ <?php
++ /**
++  * @package cBB Quickquote
++- * @version 1.0.5 08/04/2025
+++ * @version 1.0.4 01/06/2024
++  *
++- * @copyright (c) 2025 CaniDev
+++ * @copyright (c) 2024 CaniDev
++  * @license https://creativecommons.org/licenses/by-nc/4.0/
++  */
++ 
++@@ -12,7 +12,7 @@ namespace canidev\quickquote;
++ class ext extends \phpbb\extension\base
++ {
++ 	const REQUIRED_PHPBB	= '3.2.0';
++-	const REQUIRED_CORE		= '1.1.10';
+++	const REQUIRED_CORE		= '1.1.4';
++ 
++ 	/**
++ 	 * {@inheritDoc}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickquote/language/en/frontend.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickquote/language/en/frontend.php"
++index e87d9f66e..9b6f2b1e5 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickquote/language/en/frontend.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickquote/language/en/frontend.php"
++@@ -2,9 +2,9 @@
++ /**
++  * [English [En]]
++  * @package cBB QuickQuote
++- * @version 1.0.5 08/04/2025
+++ * @version 1.0.4 01/06/2024
++  *
++- * @copyright (c) 2025 CaniDev
+++ * @copyright (c) 2024 CaniDev
++  * @license https://creativecommons.org/licenses/by-nc/4.0/
++  */
++ 
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickquote/language/en/info_acp_quickquote.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickquote/language/en/info_acp_quickquote.php"
++index 2a6aadbb1..6a18bca31 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickquote/language/en/info_acp_quickquote.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickquote/language/en/info_acp_quickquote.php"
++@@ -2,9 +2,9 @@
++ /**
++  * [English [En]]
++  * @package cBB QuickQuote
++- * @version 1.0.5 08/04/2025
+++ * @version 1.0.4 01/06/2024
++  *
++- * @copyright (c) 2025 CaniDev
+++ * @copyright (c) 2024 CaniDev
++  * @license https://creativecommons.org/licenses/by-nc/4.0/
++  */
++ 
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickquote/language/es/frontend.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickquote/language/es/frontend.php"
++index 6d322dc45..8be6b29e4 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickquote/language/es/frontend.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickquote/language/es/frontend.php"
++@@ -2,9 +2,9 @@
++ /**
++  * [Spanish [Es]]
++  * @package cBB QuickQuote
++- * @version 1.0.5 08/04/2025
+++ * @version 1.0.4 01/06/2024
++  *
++- * @copyright (c) 2025 CaniDev
+++ * @copyright (c) 2024 CaniDev
++  * @license https://creativecommons.org/licenses/by-nc/4.0/
++  */
++ 
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickquote/language/es/info_acp_quickquote.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickquote/language/es/info_acp_quickquote.php"
++index 6afb2975a..eb22aa2c7 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickquote/language/es/info_acp_quickquote.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickquote/language/es/info_acp_quickquote.php"
++@@ -2,9 +2,9 @@
++ /**
++  * [Spanish [Es]]
++  * @package cBB QuickQuote
++- * @version 1.0.5 08/04/2025
+++ * @version 1.0.4 01/06/2024
++  *
++- * @copyright (c) 2025 CaniDev
+++ * @copyright (c) 2024 CaniDev
++  * @license https://creativecommons.org/licenses/by-nc/4.0/
++  */
++ 
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickquote/styles/BBOOTS/template/event/overall_footer_body_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickquote/styles/BBOOTS/template/event/overall_footer_body_after.html"
++index c8f711fb9..d0722b652 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickquote/styles/BBOOTS/template/event/overall_footer_body_after.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickquote/styles/BBOOTS/template/event/overall_footer_body_after.html"
++@@ -1,21 +1,21 @@
++ {% if QQ_ENABLED %}
++-	<template id="quickquote-tooltip">
+++	<script type="text/html" id="tpl-quickquote-tooltip">
++ 		<div class="quickquote-tooltip">
++ 			<a href="#" data-action="quote"><i class="fa fa-plus"></i> {{ lang('QQ_SAVE_QUOTE') }}</a>
++ 			<span class="tooltip-sep">|</span>
++ 			<a href="#" data-action="reply"><i class="fa fa-reply"></i> {{ lang('QQ_REPLY') }}</a>
++ 		</div>
++-	</template>
+++	</script>
++ 
++-	<template id="quickquote-floatbtn">
++-		<a href="#" class="quickquote-floatbtn btn btn-default" data-text="{{ lang('QUOTES') }}"></a>
++-	</template>
+++	<script type="text/html" id="tpl-quickquote-floatbtn">
+++	<a href="#" class="quickquote-floatbtn btn btn-default" data-text="{{ lang('QUOTES') }}"></a>
+++	</script>
++ 
++-	<template id="quickquote-inlinebtn">
+++	<script type="text/html" id="tpl-quickquote-inlinebtn">
++ 		<button type="button" class="btn btn-default" value="1" data-text="{{ lang('QQ_INSERT_QUOTES') }}"></button>
++-	</template>
+++	</script>
++ 
++-	<template id="quickquote-dialog">
+++	<script type="text/html" id="tpl-quickquote-dialog">
++ 		<div class="qq-dialog" title="{{ lang('QUOTES') }}">
++ 			<div class="cbb-dialog-content dialog-content">
++ 				<ul class="js-quickquote-list">
++@@ -41,13 +41,13 @@
++ 				</div>
++ 			</div>
++ 		</div>
++-	</template>
+++	</script>
++ 
++ 	<script>
++-	head.ready(['cbbcore.min.js', 'quickquote.min.js'], function() {
+++	head.ready(['cbbcore.min.js', 'quickquote.min.js'], function () {
++ 		cbbCore.initService('quickquote', {
++ 			btnTarget		: {% if QQ_FLOAT_BTN %}'body'{% else %}'#qr_postform .form-group:has(.btn), #postform .form-actions'{% endif %},
++-			target			: 'article .content, .pm .content, .block-postbody',
+++			target			: 'article .content, .pm .content',
++ 			editors			: {
++ 				phpbb: '#qr_postform textarea[name], #postform textarea[name]'
++ 			},
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickquote/styles/FLATBOOTS/template/event/overall_footer_body_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickquote/styles/FLATBOOTS/template/event/overall_footer_body_after.html"
++index c8f711fb9..d0722b652 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickquote/styles/FLATBOOTS/template/event/overall_footer_body_after.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickquote/styles/FLATBOOTS/template/event/overall_footer_body_after.html"
++@@ -1,21 +1,21 @@
++ {% if QQ_ENABLED %}
++-	<template id="quickquote-tooltip">
+++	<script type="text/html" id="tpl-quickquote-tooltip">
++ 		<div class="quickquote-tooltip">
++ 			<a href="#" data-action="quote"><i class="fa fa-plus"></i> {{ lang('QQ_SAVE_QUOTE') }}</a>
++ 			<span class="tooltip-sep">|</span>
++ 			<a href="#" data-action="reply"><i class="fa fa-reply"></i> {{ lang('QQ_REPLY') }}</a>
++ 		</div>
++-	</template>
+++	</script>
++ 
++-	<template id="quickquote-floatbtn">
++-		<a href="#" class="quickquote-floatbtn btn btn-default" data-text="{{ lang('QUOTES') }}"></a>
++-	</template>
+++	<script type="text/html" id="tpl-quickquote-floatbtn">
+++	<a href="#" class="quickquote-floatbtn btn btn-default" data-text="{{ lang('QUOTES') }}"></a>
+++	</script>
++ 
++-	<template id="quickquote-inlinebtn">
+++	<script type="text/html" id="tpl-quickquote-inlinebtn">
++ 		<button type="button" class="btn btn-default" value="1" data-text="{{ lang('QQ_INSERT_QUOTES') }}"></button>
++-	</template>
+++	</script>
++ 
++-	<template id="quickquote-dialog">
+++	<script type="text/html" id="tpl-quickquote-dialog">
++ 		<div class="qq-dialog" title="{{ lang('QUOTES') }}">
++ 			<div class="cbb-dialog-content dialog-content">
++ 				<ul class="js-quickquote-list">
++@@ -41,13 +41,13 @@
++ 				</div>
++ 			</div>
++ 		</div>
++-	</template>
+++	</script>
++ 
++ 	<script>
++-	head.ready(['cbbcore.min.js', 'quickquote.min.js'], function() {
+++	head.ready(['cbbcore.min.js', 'quickquote.min.js'], function () {
++ 		cbbCore.initService('quickquote', {
++ 			btnTarget		: {% if QQ_FLOAT_BTN %}'body'{% else %}'#qr_postform .form-group:has(.btn), #postform .form-actions'{% endif %},
++-			target			: 'article .content, .pm .content, .block-postbody',
+++			target			: 'article .content, .pm .content',
++ 			editors			: {
++ 				phpbb: '#qr_postform textarea[name], #postform textarea[name]'
++ 			},
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickquote/styles/all/template/event/overall_footer_body_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickquote/styles/all/template/event/overall_footer_body_after.html"
++index ac19e9a03..dddd9f9c1 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickquote/styles/all/template/event/overall_footer_body_after.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickquote/styles/all/template/event/overall_footer_body_after.html"
++@@ -1,21 +1,21 @@
++ {% if QQ_ENABLED %}
++-	<template id="quickquote-tooltip">
+++	<script type="text/html" id="tpl-quickquote-tooltip">
++ 		<div class="quickquote-tooltip">
++ 			<a href="#" data-action="quote"><i class="fa fa-plus"></i>{{ lang('QQ_SAVE_QUOTE') }}</a>
++ 			<span class="tooltip-sep">|</span>
++ 			<a href="#" data-action="reply"><i class="fa fa-reply"></i>{{ lang('QQ_REPLY') }}</a>
++ 		</div>
++-	</template>
+++	</script>
++ 
++-	<template id="quickquote-floatbtn">
++-		<a href="#" class="quickquote-floatbtn button" data-text="{{ lang('QUOTES') }}"></a>
++-	</template>
+++	<script type="text/html" id="tpl-quickquote-floatbtn">
+++	<a href="#" class="quickquote-floatbtn button" data-text="{{ lang('QUOTES') }}"></a>
+++	</script>
++ 
++-	<template id="quickquote-inlinebtn">
++-		<input type="button" class="button1 quickquote-inlinebtn" data-text="{{ lang('QQ_INSERT_QUOTES') }}" />
++-	</template>
+++	<script type="text/html" id="tpl-quickquote-inlinebtn">
+++	<input type="button" class="button1 quickquote-inlinebtn" data-text="{{ lang('QQ_INSERT_QUOTES') }}" />
+++	</script>
++ 
++-	<template id="quickquote-dialog">
+++	<script type="text/html" id="tpl-quickquote-dialog">
++ 		<div class="qq-dialog" title="{{ lang('QUOTES') }}">
++ 			<div class="cbb-dialog-content dialog-content">
++ 				<ul class="js-quickquote-list">
++@@ -41,7 +41,7 @@
++ 				</div>
++ 			</div>
++ 		</div>
++-	</template>
+++	</script>
++ 
++ 	<script>
++ 	(function($) {
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickquote/styles/all/template/quickquote.min.js" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickquote/styles/all/template/quickquote.min.js"
++index 34f91c61c..05647e644 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickquote/styles/all/template/quickquote.min.js"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickquote/styles/all/template/quickquote.min.js"
++@@ -1,8 +1,8 @@
++ /**
++  * @package cBB QuickQuote
++- * @version 1.0.5 08/04/2025
+++ * @version 1.0.4 01/06/2024
++  *
++- * @copyright (c) 2025 CaniDev
+++ * @copyright (c) 2024 CaniDev
++  * @license https://creativecommons.org/licenses/by-nc/4.0/
++  */
++-((h,c,u,s)=>{var d="quickquote_reply",p="quickquote_ary";c.registerService("quickquote",{options:{btnTarget:"body",editors:{},replyURL:"",replyOverwrite:!1,target:null},bbcodes:{b:{elem:'span[style="font-weight: bold"]',replacement:"[b]{html}[/b]"},i:{elem:'span[style="font-style: italic"]',replacement:"[i]{html}[/i]"},u:{elem:'span[style="text-decoration: underline"]',replacement:"[u]{html}[/u]"},code:{elem:"div.codebox",replacement:function(){return"[code]"+h(this).find("code").html()+"[/code]"}},quote:{elem:"blockquote",replacement:function(){var t=h(this).find("cite"),e="";return t.length&&(e='="'+t.text().replace("&nbsp;"," ").split(/\s/)[0]+'"',t.remove()),"[quote"+e+"]"+(h(this).children("div").length?h(this).children("div"):h(this)).html()+"[/quote]"}},url:{elem:"a[href]",replacement:function(){var t=h(this).html(),e=h(this).attr("href");return t==e?"[url]"+e+"[/url]":"[url="+e+"]"+t+"[/url]"}},img:{elem:"img[src]",replacement:function(){return h(this).hasClass("smilies")?h(this).attr("alt"):"[img]"+h(this).attr("src")+"[/img]"}},ul:{elem:"ul",replacement:"[list]{html}[/list]"},ol:{elem:"ol",replacement:"[list=1]{html}[/list]"},li:{elem:"li",replacement:"[*]{html}\n"},color:{elem:'span[style^="color"]',replacement:"[color={css:color}]{html}[/color]"},size:{elem:'span[style^="font-size"]',replacement:function(){return"[size="+h(this).css("font-size").replace("%","")+"]"+h(this).html()+"[/size]"}}},$editors:{def:"",length:0},$target:h([]),$dialog:null,$btn:null,isMouseDown:!1,stopPropagation:!1,mouseOffset:null,processing:!1,timeout:null,tooltip:null,__construct:function(){var i,t;u.getSelection&&((i=this).$target=h(this.options.target),this.options.replyOverwrite=!!+this.options.replyOverwrite,c.dispatchEvent("quickquote.beforeInit",this),h.each(this.options.editors,function(t,e){e=h(e);e.length&&(i.$editors[t]=e,i.$editors.length++,i.$editors.def&&"phpbb"!=t||(i.$editors.def=t))}),this.$editors.phpbb&&c.storage.get(d)&&(this.insert(c.storage.get(d),"phpbb",!0),c.storage.remove(d)),this.$target.length||this.$editors.length||this.options.replyURL||(this.options.btnTarget=!1),this.options.btnTarget&&(t=parseInt(h("body").css("font-size")),this.$btn=c.template.get("body"==this.options.btnTarget?"quickquote-floatbtn":"quickquote-inlinebtn",!1,!0),(!t||t<12)&&this.$btn.addClass("min-font-size"),this.$btn.appendTo(this.options.btnTarget),this.$btn.click(function(t){t.preventDefault(),i.initDialog(i.$editors.def)}),this.adjustButtons()),this.$target.length&&(this.$target.on("mousedown.qq",h.proxy(this,"mouseDown")),h(s).on({"selectionchange.qq":h.proxy(this,"selectionChange"),"mouseup.qq":h.proxy(this,"mouseUp")})),h(u).on("resize.quickquote",function(){null!=i.tooltip&&i.handleSelection()}),c.dispatchEvent("quickquote.onInit",this))},initDialog:function(e){this.$dialog=c.template.get("quickquote-dialog",!1,!0);var t=this.$dialog.find(".js-quickquote-list"),i=t.html(),o=this;t.hide(),this.adjustButtons([]),this.$dialog.data("quoteData",{storeData:c.storage.get(p)||[],rowStr:i,list:t}).cbbDialog({destroyOnClose:!0,movable:!1,height:300,width:700,onOpen:function(){h(this).find("a[data-action]").click(function(t){return t.preventDefault(),o.dialogTrigger(this,e)}),o.dataToDialog(e),o.$editors.length||o.options.replyURL||h(this).find('[data-action="insertAll"], [data-action="insertSelected"]').hide(),t.show()},onClose:function(){o.$dialog=null,o.adjustButtons(),c.dispatchEvent("quickquote.onCloseDialog",this)}}),c.dispatchEvent("quickquote.onInitDialog",this)},dataToDialog:function(e){var i=this,o=this.$dialog.data("quoteData");o.list.html(""),h.each(o.storeData,function(t,e){e.id=t,o.list.append(c.template.parse(o.rowStr,e))}),o.list.find("a[data-action]").click(function(t){return t.preventDefault(),i.dialogTrigger(this,e)}),o.list.find('input[type="checkbox"]').change(function(t){t.preventDefault(),o.list.find('input[type="checkbox"]:checked').length?(h(".js-btn-marked").objView(!0),h(".js-btn-all").objView(!1)):(h(".js-btn-marked").objView(!1),h(".js-btn-all").objView(!0))}).change(),this.$editors.length||this.options.replyURL||o.list.find('[data-action="insert"]').hide()},dialogTrigger:function(t,e){var i=h(t).attr("data-action"),o=null,n=this,s=this.$dialog.data("quoteData");switch("insert"!=i&&"remove"!=i||(o=parseInt(h(t).siblings("input").val())),i){case"insert":case"insertAll":case"insertSelected":var l=[];if(null!==o?l.push(s.storeData[o]):"insertSelected"==i?s.list.find('input[type="checkbox"]:checked').each(function(){l.push(s.storeData[this.value])}):h.each(s.storeData,function(t,e){l.push(e)}),n.$editors[e])n.insert(l,e);else{if(n.$editors.length||!n.options.replyURL)break;c.storage.set(d,l),u.location.href=n.options.replyURL}case"remove":case"removeAll":case"removeSelected":var a=h.extend([],s.storeData),r=[];null!==o?r.push(o):"removeSelected"==i||"insertSelected"==i?s.list.find('input[type="checkbox"]:checked').each(function(){r.push(parseInt(this.value)),s.list.children().has('input[value="'+this.value+'"]').fadeOut()}):(s.storeData=[],s.list.children().fadeOut()),r.length&&(s.storeData=[],h.each(a,function(t,e){-1==h.inArray(t,r)&&s.storeData.push(e)}))}s.storeData.length||(s.storeData=null),c.storage.set(p,s.storeData),s.storeData?n.dataToDialog(e):n.$dialog.cbbDialog("close")},buildQuote:function(t,e){var i="[quote]";return t.username&&(i='[quote="<%username%>"',i=(i+=t.post?" post_id=<%post%>":"")+(t.time?" time=<%time%> user_id=<%user%>":"")+"]"),c.template.parse(i,t)+this.htmlToBBcode(t.text,e)+"[/quote]"},insert:function(t,e,i){var o="";t=h.isArray(t)?t:[t];for(var n,s,l,a=0;a<t.length;a++)o+=this.buildQuote(t[a],e)+"\n";this.$editors[e][0]._sceditor?(!0===i&&this.$editors[e][0]._sceditor.val(""),this.$editors[e][0]._sceditor.insert(o).focus(),s=this.$editors[e][0]._sceditor.getRangeHelper(),n=h(s.parentNode()).closest("blockquote").get(0),(l=s.selectedRange()).setStartAfter(n),l.collapse(!0),s.selectRange(l)):(!0===i&&this.$editors[e].val(""),n=this.$editors[e].val(),s=this.$editors[e].cbbCaret(),l=n.substring(0,s.start),i=n.substring(s.end,n.length),this.$editors[e].val(n=l+(o+="\n")+i).cbbCaret(l.length+o.length).focus())},mouseDown:function(t){this.isMouseDown=!0,this.stopPropagation=0<h(t.target).closest("a").length},mouseUp:function(t){this.isMouseDown&&(this.isMouseDown=!1,this.trigger(),this.mouseOffset={x:t.clientX,y:t.clientY})},selectionChange:function(){this.isMouseDown||this.trigger()},trigger:function(){this.timeout||this.processing||(this.timeout=setTimeout(h.proxy(this,"handleSelection"),100))},handleSelection:function(){this.processing=!0,this.timeout=null;var t=u.getSelection(),e=this.stopPropagation?null:this.getValidSelectionContainer(t),i=(e?this.showQuoteButton(e,t):this.hideQuoteButton(),this);setTimeout(function(){i.processing=!1,i.mouseOffset=null},0)},getValidSelectionContainer:function(t){return!t.isCollapsed&&t.rangeCount&&(t=t.getRangeAt(0),h.trim(t.toString()).length||t.cloneContents().querySelectorAll("img").length)&&(t=h(t.commonAncestorContainer).closest(this.options.target)).length?t:null},showQuoteButton:function(t,e){var i=e.getRangeAt(0).cloneRange(),o=i.getBoundingClientRect?i.getBoundingClientRect():null,n=h(s).scrollTop(),e=(null!=this.tooltip&&this.hideQuoteButton(),this.createButton(t,i),this.tooltip.data("quote",{text:this.getSelectionHtml(e),container:t,target:"phpbb"}),i={left:o.left+o.width/2,top:o.top+o.height+n+5},null!==this.mouseOffset&&i.left>this.mouseOffset.x&&(i.left=this.mouseOffset.x),{left:i.left-this.tooltip.outerWidth()/2,top:i.top});e.left=Math.max(0,e.left),e.left+this.tooltip.outerWidth()>h(u).width()&&(e.left=h(u).width()<this.tooltip.outerWidth()),e.top+this.tooltip.outerHeight()>h(u).height()+n&&(e.top=o.top-this.tooltip.outerHeight()+n-5),this.tooltip.css(e).show(),c.dispatchEvent("quickquote.onShowTooltip",this)},createButton:function(l,a){var r=this,t=parseInt(h("body").css("font-size"));r.tooltip=c.template.get("quickquote-tooltip",null,!0),(!t||t<11)&&r.tooltip.addClass("min-font-size"),r.tooltip.appendTo("body").find("a").click(function(t){t.preventDefault();var e={action:h(this).attr("data-action"),container:l,data:r.tooltip.data("quote"),currentTarget:a.commonAncestorContainer};switch(e.data.postInfo=l.children(".js-qq-post-info:first"),(e=c.dispatchEvent("quickquote.onTooltipAction",e)).action){case"quote":case"reply":var i,o=h("<div />").append(e.data.text),n=r.$editors[e.data.target];try{i=JSON.parse(e.data.postInfo.text())}catch(t){i={}}if(r.repaseCode(o),i.text=o.html(),"reply"==e.action){if(n){r.insert(i,e.data.target,r.options.replyOverwrite);break}"phpbb"==e.data.target&&r.options.replyURL&&(c.storage.set(d,i),u.location.href=r.options.replyURL)}else{o=c.storage.get(p)||[];o.push(i),c.storage.set(p,o),r.adjustButtons(o)}}var s=u.getSelection();s.isCollapsed||(s.collapse(s.getRangeAt(0).commonAncestorContainer,0),r.hideQuoteButton())})},adjustButtons:function(t){var e,i;return(t=void 0===t?c.storage.get(p)||[]:t).length?(null!==this.$btn&&(e=this.$btn.attr("data-text")+" ("+t.length+")",i=this.$btn.is("input")?"val":"html",this.$btn[i].call(this.$btn,e),this.$btn.show()),c.dispatchEvent("quickquote.onShowBtn",{quickquote:this,storedData:t}),!0):(null!==this.$btn&&this.$btn.hide(),c.dispatchEvent("quickquote.onHideBtn",[this,t]),!1)},hideQuoteButton:function(){this.tooltip&&(this.tooltip.fadeOut("fast",function(){h(this).remove()}),this.tooltip=null)},getSelectionHtml:function(t){let e=s.createElement("div"),i,o;for(i=0,o=t.rangeCount;i<o;i++)e.appendChild(t.getRangeAt(i).cloneContents());return h(e).find("[data-decoded]").each(function(){h(this).replaceWith(h(this).attr("data-decoded"))}),e.innerHTML},htmlToBBcode:function(t,e){var i=h("<div />").append(t.replace(/<br>\n/g,"<br>"));return this.repaseCode(i),e&&this.$editors[e]&&this.$editors[e][0]._sceditor?this.$editors[e][0]._sceditor.toBBCode(i.html()):(h.each(this.bbcodes,function(t,e){i.find(e.elem).each(function(){var o=h(this),t="function"==typeof e.replacement?e.replacement.apply(o):e.replacement.replace("{html}",o.html()).replace("{text}",o.text()).replace(/\{(attr|css):([\d\w]+)\}/,function(t,e,i){return"css"==e?c.rgbToHex(o[e].apply(o,[i])):o[e].apply(o,[i])});o.replaceWith(t)})}),i.find("br").replaceWith("\n"),i.text())},repaseCode:function(t){var e,i=t.children("li");i.length&&((e=h("<ul />")).append(i.clone()),i.filter(":first").before(e),i.remove()),t.find(".js-qq-post-info, .cbb-helper-hidden").remove()}},!1)})(jQuery,cbbCore,window,document);
++\ No newline at end of file
+++!function(h,c,u,s){"use strict";var d="quickquote_reply",p="quickquote_ary";c.registerService("quickquote",{options:{btnTarget:"body",editors:{},replyURL:"",replyOverwrite:!1,target:null},bbcodes:{b:{elem:'span[style="font-weight: bold"]',replacement:"[b]{html}[/b]"},i:{elem:'span[style="font-style: italic"]',replacement:"[i]{html}[/i]"},u:{elem:'span[style="text-decoration: underline"]',replacement:"[u]{html}[/u]"},code:{elem:"div.codebox",replacement:function(){return"[code]"+h(this).find("code").html()+"[/code]"}},quote:{elem:"blockquote",replacement:function(){var t=h(this).find("cite"),e="";return t.length&&(e='="'+t.text().replace("&nbsp;"," ").split(/\s/)[0]+'"',t.remove()),"[quote"+e+"]"+(h(this).children("div").length?h(this).children("div"):h(this)).html()+"[/quote]"}},url:{elem:"a[href]",replacement:function(){var t=h(this).html(),e=h(this).attr("href");return t==e?"[url]"+e+"[/url]":"[url="+e+"]"+t+"[/url]"}},img:{elem:"img[src]",replacement:function(){return h(this).hasClass("smilies")?h(this).attr("alt"):"[img]"+h(this).attr("src")+"[/img]"}},ul:{elem:"ul",replacement:"[list]{html}[/list]"},ol:{elem:"ol",replacement:"[list=1]{html}[/list]"},li:{elem:"li",replacement:"[*]{html}\n"},color:{elem:'span[style^="color"]',replacement:"[color={css:color}]{html}[/color]"},size:{elem:'span[style^="font-size"]',replacement:function(){return"[size="+h(this).css("font-size").replace("%","")+"]"+h(this).html()+"[/size]"}}},$editors:{def:"",length:0},$target:h([]),$dialog:null,$btn:null,isMouseDown:!1,stopPropagation:!1,mouseOffset:null,processing:!1,timeout:null,tooltip:null,__construct:function(){var i,t;u.getSelection&&((i=this).$target=h(this.options.target),this.options.replyOverwrite=!!+this.options.replyOverwrite,c.dispatchEvent("quickquote.beforeInit",this),h.each(this.options.editors,function(t,e){e=h(e);e.length&&(i.$editors[t]=e,i.$editors.length++,i.$editors.def&&"phpbb"!=t||(i.$editors.def=t))}),this.$editors.phpbb&&c.storage.get(d)&&(this.insert(c.storage.get(d),"phpbb",!0),c.storage.remove(d)),this.$target.length||this.$editors.length||this.options.replyURL||(this.options.btnTarget=!1),this.options.btnTarget&&(t=parseInt(h("body").css("font-size")),this.$btn=c.template.get("body"==this.options.btnTarget?"quickquote-floatbtn":"quickquote-inlinebtn",!1,!0),(!t||t<12)&&this.$btn.addClass("min-font-size"),this.$btn.appendTo(this.options.btnTarget),this.$btn.click(function(t){t.preventDefault(),i.initDialog(i.$editors.def)}),this.adjustButtons()),this.$target.length&&(this.$target.on("mousedown.qq",h.proxy(this,"mouseDown")),h(s).on({"selectionchange.qq":h.proxy(this,"selectionChange"),"mouseup.qq":h.proxy(this,"mouseUp")})),h(u).on("resize.quickquote",function(){null!=i.tooltip&&i.handleSelection()}),c.dispatchEvent("quickquote.onInit",this))},initDialog:function(e){this.$dialog=c.template.get("quickquote-dialog",!1,!0);var t=this.$dialog.find(".js-quickquote-list"),i=t.html(),o=this;t.hide(),this.adjustButtons([]),this.$dialog.data("quoteData",{storeData:c.storage.get(p)||[],rowStr:i,list:t}).cbbDialog({destroyOnClose:!0,movable:!1,height:300,width:700,onOpen:function(){h(this).find("a[data-action]").click(function(t){return t.preventDefault(),o.dialogTrigger(this,e)}),o.dataToDialog(e),o.$editors.length||o.options.replyURL||h(this).find('[data-action="insertAll"], [data-action="insertSelected"]').hide(),t.show()},onClose:function(){o.$dialog=null,o.adjustButtons(),c.dispatchEvent("quickquote.onCloseDialog",this)}}),c.dispatchEvent("quickquote.onInitDialog",this)},dataToDialog:function(e){var i=this,o=this.$dialog.data("quoteData");o.list.html(""),h.each(o.storeData,function(t,e){e.id=t,o.list.append(c.template.parse(o.rowStr,e))}),o.list.find("a[data-action]").click(function(t){return t.preventDefault(),i.dialogTrigger(this,e)}),o.list.find('input[type="checkbox"]').change(function(t){t.preventDefault(),o.list.find('input[type="checkbox"]:checked').length?(h(".js-btn-marked").objView(!0),h(".js-btn-all").objView(!1)):(h(".js-btn-marked").objView(!1),h(".js-btn-all").objView(!0))}).change(),this.$editors.length||this.options.replyURL||o.list.find('[data-action="insert"]').hide()},dialogTrigger:function(t,e){var i=h(t).attr("data-action"),o=null,n=this,s=this.$dialog.data("quoteData");switch("insert"!=i&&"remove"!=i||(o=parseInt(h(t).siblings("input").val())),i){case"insert":case"insertAll":case"insertSelected":var l=[];if(null!==o?l.push(s.storeData[o]):"insertSelected"==i?s.list.find('input[type="checkbox"]:checked').each(function(){l.push(s.storeData[this.value])}):h.each(s.storeData,function(t,e){l.push(e)}),n.$editors[e])n.insert(l,e);else{if(n.$editors.length||!n.options.replyURL)break;c.storage.set(d,l),u.location.href=n.options.replyURL}case"remove":case"removeAll":case"removeSelected":var a=h.extend([],s.storeData),r=[];null!==o?r.push(o):"removeSelected"==i||"insertSelected"==i?s.list.find('input[type="checkbox"]:checked').each(function(){r.push(parseInt(this.value)),s.list.children().has('input[value="'+this.value+'"]').fadeOut()}):(s.storeData=[],s.list.children().fadeOut()),r.length&&(s.storeData=[],h.each(a,function(t,e){-1==h.inArray(t,r)&&s.storeData.push(e)}))}s.storeData.length||(s.storeData=null),c.storage.set(p,s.storeData),s.storeData?n.dataToDialog(e):n.$dialog.cbbDialog("close")},buildQuote:function(t,e){var i="[quote]";return t.username&&(i='[quote="<%username%>"',i=(i+=t.post?" post_id=<%post%>":"")+(t.time?" time=<%time%> user_id=<%user%>":"")+"]"),c.template.parse(i,t)+this.htmlToBBcode(t.text,e)+"[/quote]"},insert:function(t,e,i){var o="";t=h.isArray(t)?t:[t];for(var n,s,l,a=0;a<t.length;a++)o+=this.buildQuote(t[a],e)+"\n";this.$editors[e][0]._sceditor?(!0===i&&this.$editors[e][0]._sceditor.val(""),this.$editors[e][0]._sceditor.insert(o).focus(),s=this.$editors[e][0]._sceditor.getRangeHelper(),n=h(s.parentNode()).closest("blockquote").get(0),(l=s.selectedRange()).setStartAfter(n),l.collapse(!0),s.selectRange(l)):(!0===i&&this.$editors[e].val(""),n=this.$editors[e].val(),s=this.$editors[e].cbbCaret(),l=n.substring(0,s.start),i=n.substring(s.end,n.length),this.$editors[e].val(n=l+(o+="\n")+i).cbbCaret(l.length+o.length).focus())},mouseDown:function(t){this.isMouseDown=!0,this.stopPropagation=0<h(t.target).closest("a").length},mouseUp:function(t){this.isMouseDown&&(this.isMouseDown=!1,this.trigger(),this.mouseOffset={x:t.clientX,y:t.clientY})},selectionChange:function(){this.isMouseDown||this.trigger()},trigger:function(){this.timeout||this.processing||(this.timeout=setTimeout(h.proxy(this,"handleSelection"),100))},handleSelection:function(){this.processing=!0,this.timeout=null;var t=u.getSelection(),e=this.stopPropagation?null:this.getValidSelectionContainer(t),i=(e?this.showQuoteButton(e,t):this.hideQuoteButton(),this);setTimeout(function(){i.processing=!1,i.mouseOffset=null},0)},getValidSelectionContainer:function(t){return!t.isCollapsed&&t.rangeCount&&(t=t.getRangeAt(0),h.trim(t.toString()).length||t.cloneContents().querySelectorAll("img").length)&&(t=h(t.commonAncestorContainer).closest(this.options.target)).length?t:null},showQuoteButton:function(t,e){var i=e.getRangeAt(0).cloneRange(),o=i.getBoundingClientRect?i.getBoundingClientRect():null,n=h(s).scrollTop(),e=(null!=this.tooltip&&this.hideQuoteButton(),this.createButton(t,i),this.tooltip.data("quote",{text:this.getSelectionHtml(e),container:t,target:"phpbb"}),i={left:o.left+o.width/2,top:o.top+o.height+n+5},null!==this.mouseOffset&&i.left>this.mouseOffset.x&&(i.left=this.mouseOffset.x),{left:i.left-this.tooltip.outerWidth()/2,top:i.top});e.left=Math.max(0,e.left),e.left+this.tooltip.outerWidth()>h(u).width()&&(e.left=h(u).width()<this.tooltip.outerWidth()),e.top+this.tooltip.outerHeight()>h(u).height()+n&&(e.top=o.top-this.tooltip.outerHeight()+n-5),this.tooltip.css(e).show(),c.dispatchEvent("quickquote.onShowTooltip",this)},createButton:function(l,a){var r=this,t=parseInt(h("body").css("font-size"));r.tooltip=c.template.get("quickquote-tooltip",null,!0),(!t||t<11)&&r.tooltip.addClass("min-font-size"),r.tooltip.appendTo("body").find("a").click(function(t){t.preventDefault();var e={action:h(this).attr("data-action"),container:l,data:r.tooltip.data("quote"),currentTarget:a.commonAncestorContainer};switch(e.data.postInfo=l.children(".js-qq-post-info:first"),(e=c.dispatchEvent("quickquote.onTooltipAction",e)).action){case"quote":case"reply":var i,o=h("<div />").append(e.data.text),n=r.$editors[e.data.target];try{i=JSON.parse(e.data.postInfo.text())}catch(t){i={}}if(r.repaseCode(o),i.text=o.html(),"reply"==e.action){if(n){r.insert(i,e.data.target,r.options.replyOverwrite);break}"phpbb"==e.data.target&&r.options.replyURL&&(c.storage.set(d,i),u.location.href=r.options.replyURL)}else{o=c.storage.get(p)||[];o.push(i),c.storage.set(p,o),r.adjustButtons(o)}}var s=u.getSelection();s.isCollapsed||(s.collapse(s.getRangeAt(0).commonAncestorContainer,0),r.hideQuoteButton())})},adjustButtons:function(t){var e,i;return(t=void 0===t?c.storage.get(p)||[]:t).length?(null!==this.$btn&&(e=this.$btn.attr("data-text")+" ("+t.length+")",i=this.$btn.is("input")?"val":"html",this.$btn[i].call(this.$btn,e),this.$btn.show()),c.dispatchEvent("quickquote.onShowBtn",{quickquote:this,storedData:t}),!0):(null!==this.$btn&&this.$btn.hide(),c.dispatchEvent("quickquote.onHideBtn",[this,t]),!1)},hideQuoteButton:function(){this.tooltip&&(this.tooltip.fadeOut("fast",function(){h(this).remove()}),this.tooltip=null)},getSelectionHtml:function(t){let e=s.createElement("div"),i,o;for(i=0,o=t.rangeCount;i<o;i++)e.appendChild(t.getRangeAt(i).cloneContents());return h(e).find("[data-decoded]").each(function(){h(this).replaceWith(h(this).attr("data-decoded"))}),e.innerHTML},htmlToBBcode:function(t,e){var i=h("<div />").append(t.replace(/<br>\n/g,"<br>"));return this.repaseCode(i),e&&this.$editors[e]&&this.$editors[e][0]._sceditor?this.$editors[e][0]._sceditor.toBBCode(i.html()):(h.each(this.bbcodes,function(t,e){i.find(e.elem).each(function(){var o=h(this),t="function"==typeof e.replacement?e.replacement.apply(o):e.replacement.replace("{html}",o.html()).replace("{text}",o.text()).replace(/\{(attr|css):([\d\w]+)\}/,function(t,e,i){return"css"==e?c.rgbToHex(o[e].apply(o,[i])):o[e].apply(o,[i])});o.replaceWith(t)})}),i.find("br").replaceWith("\n"),i.text())},repaseCode:function(t){var e,i=t.children("li");i.length&&((e=h("<ul />")).append(i.clone()),i.filter(":first").before(e),i.remove()),t.find(".js-qq-post-info, .cbb-helper-hidden").remove()}},!1)}(jQuery,cbbCore,window,document);
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickquote/styles/all/theme/quickquote.css" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickquote/styles/all/theme/quickquote.css"
++index d9ef98945..7f91eec5d 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\canidev\\quickquote/styles/all/theme/quickquote.css"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\canidev\\quickquote/styles/all/theme/quickquote.css"
++@@ -1,7 +1,7 @@
++ /*  cBB QuickQuote StyleSheet
++     --------------------------------------------------------------
++ 	Style:	All
++-	Copyright (c) 2025 CaniDev ( https://www.canidev.com )
+++	Copyright (c
\ No newline at end of file
diff --git "[ORIGINAL]/canidev\\quickquote/event/listener.php" "[FORUM_EXT]/canidev\\quickquote/event/listener.php"
--- "[ORIGINAL]/canidev\\quickquote/event/listener.php"
+++ "[FORUM_EXT]/canidev\\quickquote/event/listener.php"
@@ -1,9 +1,9 @@
 <?php
 /**
  * @package cBB Quickquote
- * @version 1.0.5 08/04/2025
+ * @version 1.0.4 01/06/2024
  *
- * @copyright (c) 2025 CaniDev
+ * @copyright (c) 2024 CaniDev
  * @license https://creativecommons.org/licenses/by-nc/4.0/
  */
 
diff --git "[ORIGINAL]/canidev\\quickquote/ext.php" "[FORUM_EXT]/canidev\\quickquote/ext.php"
--- "[ORIGINAL]/canidev\\quickquote/ext.php"
+++ "[FORUM_EXT]/canidev\\quickquote/ext.php"
@@ -1,9 +1,9 @@
 <?php
 /**
  * @package cBB Quickquote
- * @version 1.0.5 08/04/2025
+ * @version 1.0.4 01/06/2024
  *
- * @copyright (c) 2025 CaniDev
+ * @copyright (c) 2024 CaniDev
  * @license https://creativecommons.org/licenses/by-nc/4.0/
  */
 
@@ -12,7 +12,7 @@ namespace canidev\quickquote;
 class ext extends \phpbb\extension\base
 {
 	const REQUIRED_PHPBB	= '3.2.0';
-	const REQUIRED_CORE		= '1.1.10';
+	const REQUIRED_CORE		= '1.1.4';
 
 	/**
 	 * {@inheritDoc}
diff --git "[ORIGINAL]/canidev\\quickquote/language/en/frontend.php" "[FORUM_EXT]/canidev\\quickquote/language/en/frontend.php"
--- "[ORIGINAL]/canidev\\quickquote/language/en/frontend.php"
+++ "[FORUM_EXT]/canidev\\quickquote/language/en/frontend.php"
@@ -2,9 +2,9 @@
 /**
  * [English [En]]
  * @package cBB QuickQuote
- * @version 1.0.5 08/04/2025
+ * @version 1.0.4 01/06/2024
  *
- * @copyright (c) 2025 CaniDev
+ * @copyright (c) 2024 CaniDev
  * @license https://creativecommons.org/licenses/by-nc/4.0/
  */
 
diff --git "[ORIGINAL]/canidev\\quickquote/language/en/info_acp_quickquote.php" "[FORUM_EXT]/canidev\\quickquote/language/en/info_acp_quickquote.php"
--- "[ORIGINAL]/canidev\\quickquote/language/en/info_acp_quickquote.php"
+++ "[FORUM_EXT]/canidev\\quickquote/language/en/info_acp_quickquote.php"
@@ -2,9 +2,9 @@
 /**
  * [English [En]]
  * @package cBB QuickQuote
- * @version 1.0.5 08/04/2025
+ * @version 1.0.4 01/06/2024
  *
- * @copyright (c) 2025 CaniDev
+ * @copyright (c) 2024 CaniDev
  * @license https://creativecommons.org/licenses/by-nc/4.0/
  */
 
diff --git "[ORIGINAL]/canidev\\quickquote/language/es/frontend.php" "[FORUM_EXT]/canidev\\quickquote/language/es/frontend.php"
--- "[ORIGINAL]/canidev\\quickquote/language/es/frontend.php"
+++ "[FORUM_EXT]/canidev\\quickquote/language/es/frontend.php"
@@ -2,9 +2,9 @@
 /**
  * [Spanish [Es]]
  * @package cBB QuickQuote
- * @version 1.0.5 08/04/2025
+ * @version 1.0.4 01/06/2024
  *
- * @copyright (c) 2025 CaniDev
+ * @copyright (c) 2024 CaniDev
  * @license https://creativecommons.org/licenses/by-nc/4.0/
  */
 
diff --git "[ORIGINAL]/canidev\\quickquote/language/es/info_acp_quickquote.php" "[FORUM_EXT]/canidev\\quickquote/language/es/info_acp_quickquote.php"
--- "[ORIGINAL]/canidev\\quickquote/language/es/info_acp_quickquote.php"
+++ "[FORUM_EXT]/canidev\\quickquote/language/es/info_acp_quickquote.php"
@@ -2,9 +2,9 @@
 /**
  * [Spanish [Es]]
  * @package cBB QuickQuote
- * @version 1.0.5 08/04/2025
+ * @version 1.0.4 01/06/2024
  *
- * @copyright (c) 2025 CaniDev
+ * @copyright (c) 2024 CaniDev
  * @license https://creativecommons.org/licenses/by-nc/4.0/
  */
 
diff --git "[ORIGINAL]/canidev\\quickquote/styles/BBOOTS/template/event/overall_footer_body_after.html" "[FORUM_EXT]/canidev\\quickquote/styles/BBOOTS/template/event/overall_footer_body_after.html"
--- "[ORIGINAL]/canidev\\quickquote/styles/BBOOTS/template/event/overall_footer_body_after.html"
+++ "[FORUM_EXT]/canidev\\quickquote/styles/BBOOTS/template/event/overall_footer_body_after.html"
@@ -1,21 +1,21 @@
 {% if QQ_ENABLED %}
-	<template id="quickquote-tooltip">
+	<script type="text/html" id="tpl-quickquote-tooltip">
 		<div class="quickquote-tooltip">
 			<a href="#" data-action="quote"><i class="fa fa-plus"></i> {{ lang('QQ_SAVE_QUOTE') }}</a>
 			<span class="tooltip-sep">|</span>
 			<a href="#" data-action="reply"><i class="fa fa-reply"></i> {{ lang('QQ_REPLY') }}</a>
 		</div>
-	</template>
+	</script>
 
-	<template id="quickquote-floatbtn">
+	<script type="text/html" id="tpl-quickquote-floatbtn">
 	<a href="#" class="quickquote-floatbtn btn btn-default" data-text="{{ lang('QUOTES') }}"></a>
-	</template>
+	</script>
 
-	<template id="quickquote-inlinebtn">
+	<script type="text/html" id="tpl-quickquote-inlinebtn">
 		<button type="button" class="btn btn-default" value="1" data-text="{{ lang('QQ_INSERT_QUOTES') }}"></button>
-	</template>
+	</script>
 
-	<template id="quickquote-dialog">
+	<script type="text/html" id="tpl-quickquote-dialog">
 		<div class="qq-dialog" title="{{ lang('QUOTES') }}">
 			<div class="cbb-dialog-content dialog-content">
 				<ul class="js-quickquote-list">
@@ -41,13 +41,13 @@
 				</div>
 			</div>
 		</div>
-	</template>
+	</script>
 
 	<script>
 	head.ready(['cbbcore.min.js', 'quickquote.min.js'], function () {
 		cbbCore.initService('quickquote', {
 			btnTarget		: {% if QQ_FLOAT_BTN %}'body'{% else %}'#qr_postform .form-group:has(.btn), #postform .form-actions'{% endif %},
-			target			: 'article .content, .pm .content, .block-postbody',
+			target			: 'article .content, .pm .content',
 			editors			: {
 				phpbb: '#qr_postform textarea[name], #postform textarea[name]'
 			},
diff --git "[ORIGINAL]/canidev\\quickquote/styles/FLATBOOTS/template/event/overall_footer_body_after.html" "[FORUM_EXT]/canidev\\quickquote/styles/FLATBOOTS/template/event/overall_footer_body_after.html"
--- "[ORIGINAL]/canidev\\quickquote/styles/FLATBOOTS/template/event/overall_footer_body_after.html"
+++ "[FORUM_EXT]/canidev\\quickquote/styles/FLATBOOTS/template/event/overall_footer_body_after.html"
@@ -1,21 +1,21 @@
 {% if QQ_ENABLED %}
-	<template id="quickquote-tooltip">
+	<script type="text/html" id="tpl-quickquote-tooltip">
 		<div class="quickquote-tooltip">
 			<a href="#" data-action="quote"><i class="fa fa-plus"></i> {{ lang('QQ_SAVE_QUOTE') }}</a>
 			<span class="tooltip-sep">|</span>
 			<a href="#" data-action="reply"><i class="fa fa-reply"></i> {{ lang('QQ_REPLY') }}</a>
 		</div>
-	</template>
+	</script>
 
-	<template id="quickquote-floatbtn">
+	<script type="text/html" id="tpl-quickquote-floatbtn">
 	<a href="#" class="quickquote-floatbtn btn btn-default" data-text="{{ lang('QUOTES') }}"></a>
-	</template>
+	</script>
 
-	<template id="quickquote-inlinebtn">
+	<script type="text/html" id="tpl-quickquote-inlinebtn">
 		<button type="button" class="btn btn-default" value="1" data-text="{{ lang('QQ_INSERT_QUOTES') }}"></button>
-	</template>
+	</script>
 
-	<template id="quickquote-dialog">
+	<script type="text/html" id="tpl-quickquote-dialog">
 		<div class="qq-dialog" title="{{ lang('QUOTES') }}">
 			<div class="cbb-dialog-content dialog-content">
 				<ul class="js-quickquote-list">
@@ -41,13 +41,13 @@
 				</div>
 			</div>
 		</div>
-	</template>
+	</script>
 
 	<script>
 	head.ready(['cbbcore.min.js', 'quickquote.min.js'], function () {
 		cbbCore.initService('quickquote', {
 			btnTarget		: {% if QQ_FLOAT_BTN %}'body'{% else %}'#qr_postform .form-group:has(.btn), #postform .form-actions'{% endif %},
-			target			: 'article .content, .pm .content, .block-postbody',
+			target			: 'article .content, .pm .content',
 			editors			: {
 				phpbb: '#qr_postform textarea[name], #postform textarea[name]'
 			},
diff --git "[ORIGINAL]/canidev\\quickquote/styles/all/template/event/overall_footer_body_after.html" "[FORUM_EXT]/canidev\\quickquote/styles/all/template/event/overall_footer_body_after.html"
--- "[ORIGINAL]/canidev\\quickquote/styles/all/template/event/overall_footer_body_after.html"
+++ "[FORUM_EXT]/canidev\\quickquote/styles/all/template/event/overall_footer_body_after.html"
@@ -1,21 +1,21 @@
 {% if QQ_ENABLED %}
-	<template id="quickquote-tooltip">
+	<script type="text/html" id="tpl-quickquote-tooltip">
 		<div class="quickquote-tooltip">
 			<a href="#" data-action="quote"><i class="fa fa-plus"></i>{{ lang('QQ_SAVE_QUOTE') }}</a>
 			<span class="tooltip-sep">|</span>
 			<a href="#" data-action="reply"><i class="fa fa-reply"></i>{{ lang('QQ_REPLY') }}</a>
 		</div>
-	</template>
+	</script>
 
-	<template id="quickquote-floatbtn">
+	<script type="text/html" id="tpl-quickquote-floatbtn">
 	<a href="#" class="quickquote-floatbtn button" data-text="{{ lang('QUOTES') }}"></a>
-	</template>
+	</script>
 
-	<template id="quickquote-inlinebtn">
+	<script type="text/html" id="tpl-quickquote-inlinebtn">
 	<input type="button" class="button1 quickquote-inlinebtn" data-text="{{ lang('QQ_INSERT_QUOTES') }}" />
-	</template>
+	</script>
 
-	<template id="quickquote-dialog">
+	<script type="text/html" id="tpl-quickquote-dialog">
 		<div class="qq-dialog" title="{{ lang('QUOTES') }}">
 			<div class="cbb-dialog-content dialog-content">
 				<ul class="js-quickquote-list">
@@ -41,7 +41,7 @@
 				</div>
 			</div>
 		</div>
-	</template>
+	</script>
 
 	<script>
 	(function($) {
diff --git "[ORIGINAL]/canidev\\quickquote/styles/all/template/quickquote.min.js" "[FORUM_EXT]/canidev\\quickquote/styles/all/template/quickquote.min.js"
--- "[ORIGINAL]/canidev\\quickquote/styles/all/template/quickquote.min.js"
+++ "[FORUM_EXT]/canidev\\quickquote/styles/all/template/quickquote.min.js"
@@ -1,8 +1,8 @@
 /**
  * @package cBB QuickQuote
- * @version 1.0.5 08/04/2025
+ * @version 1.0.4 01/06/2024
  *
- * @copyright (c) 2025 CaniDev
+ * @copyright (c) 2024 CaniDev
  * @license https://creativecommons.org/licenses/by-nc/4.0/
  */
-((h,c,u,s)=>{var d="quickquote_reply",p="quickquote_ary";c.registerService("quickquote",{options:{btnTarget:"body",editors:{},replyURL:"",replyOverwrite:!1,target:null},bbcodes:{b:{elem:'span[style="font-weight: bold"]',replacement:"[b]{html}[/b]"},i:{elem:'span[style="font-style: italic"]',replacement:"[i]{html}[/i]"},u:{elem:'span[style="text-decoration: underline"]',replacement:"[u]{html}[/u]"},code:{elem:"div.codebox",replacement:function(){return"[code]"+h(this).find("code").html()+"[/code]"}},quote:{elem:"blockquote",replacement:function(){var t=h(this).find("cite"),e="";return t.length&&(e='="'+t.text().replace("&nbsp;"," ").split(/\s/)[0]+'"',t.remove()),"[quote"+e+"]"+(h(this).children("div").length?h(this).children("div"):h(this)).html()+"[/quote]"}},url:{elem:"a[href]",replacement:function(){var t=h(this).html(),e=h(this).attr("href");return t==e?"[url]"+e+"[/url]":"[url="+e+"]"+t+"[/url]"}},img:{elem:"img[src]",replacement:function(){return h(this).hasClass("smilies")?h(this).attr("alt"):"[img]"+h(this).attr("src")+"[/img]"}},ul:{elem:"ul",replacement:"[list]{html}[/list]"},ol:{elem:"ol",replacement:"[list=1]{html}[/list]"},li:{elem:"li",replacement:"[*]{html}\n"},color:{elem:'span[style^="color"]',replacement:"[color={css:color}]{html}[/color]"},size:{elem:'span[style^="font-size"]',replacement:function(){return"[size="+h(this).css("font-size").replace("%","")+"]"+h(this).html()+"[/size]"}}},$editors:{def:"",length:0},$target:h([]),$dialog:null,$btn:null,isMouseDown:!1,stopPropagation:!1,mouseOffset:null,processing:!1,timeout:null,tooltip:null,__construct:function(){var i,t;u.getSelection&&((i=this).$target=h(this.options.target),this.options.replyOverwrite=!!+this.options.replyOverwrite,c.dispatchEvent("quickquote.beforeInit",this),h.each(this.options.editors,function(t,e){e=h(e);e.length&&(i.$editors[t]=e,i.$editors.length++,i.$editors.def&&"phpbb"!=t||(i.$editors.def=t))}),this.$editors.phpbb&&c.storage.get(d)&&(this.insert(c.storage.get(d),"phpbb",!0),c.storage.remove(d)),this.$target.length||this.$editors.length||this.options.replyURL||(this.options.btnTarget=!1),this.options.btnTarget&&(t=parseInt(h("body").css("font-size")),this.$btn=c.template.get("body"==this.options.btnTarget?"quickquote-floatbtn":"quickquote-inlinebtn",!1,!0),(!t||t<12)&&this.$btn.addClass("min-font-size"),this.$btn.appendTo(this.options.btnTarget),this.$btn.click(function(t){t.preventDefault(),i.initDialog(i.$editors.def)}),this.adjustButtons()),this.$target.length&&(this.$target.on("mousedown.qq",h.proxy(this,"mouseDown")),h(s).on({"selectionchange.qq":h.proxy(this,"selectionChange"),"mouseup.qq":h.proxy(this,"mouseUp")})),h(u).on("resize.quickquote",function(){null!=i.tooltip&&i.handleSelection()}),c.dispatchEvent("quickquote.onInit",this))},initDialog:function(e){this.$dialog=c.template.get("quickquote-dialog",!1,!0);var t=this.$dialog.find(".js-quickquote-list"),i=t.html(),o=this;t.hide(),this.adjustButtons([]),this.$dialog.data("quoteData",{storeData:c.storage.get(p)||[],rowStr:i,list:t}).cbbDialog({destroyOnClose:!0,movable:!1,height:300,width:700,onOpen:function(){h(this).find("a[data-action]").click(function(t){return t.preventDefault(),o.dialogTrigger(this,e)}),o.dataToDialog(e),o.$editors.length||o.options.replyURL||h(this).find('[data-action="insertAll"], [data-action="insertSelected"]').hide(),t.show()},onClose:function(){o.$dialog=null,o.adjustButtons(),c.dispatchEvent("quickquote.onCloseDialog",this)}}),c.dispatchEvent("quickquote.onInitDialog",this)},dataToDialog:function(e){var i=this,o=this.$dialog.data("quoteData");o.list.html(""),h.each(o.storeData,function(t,e){e.id=t,o.list.append(c.template.parse(o.rowStr,e))}),o.list.find("a[data-action]").click(function(t){return t.preventDefault(),i.dialogTrigger(this,e)}),o.list.find('input[type="checkbox"]').change(function(t){t.preventDefault(),o.list.find('input[type="checkbox"]:checked').length?(h(".js-btn-marked").objView(!0),h(".js-btn-all").objView(!1)):(h(".js-btn-marked").objView(!1),h(".js-btn-all").objView(!0))}).change(),this.$editors.length||this.options.replyURL||o.list.find('[data-action="insert"]').hide()},dialogTrigger:function(t,e){var i=h(t).attr("data-action"),o=null,n=this,s=this.$dialog.data("quoteData");switch("insert"!=i&&"remove"!=i||(o=parseInt(h(t).siblings("input").val())),i){case"insert":case"insertAll":case"insertSelected":var l=[];if(null!==o?l.push(s.storeData[o]):"insertSelected"==i?s.list.find('input[type="checkbox"]:checked').each(function(){l.push(s.storeData[this.value])}):h.each(s.storeData,function(t,e){l.push(e)}),n.$editors[e])n.insert(l,e);else{if(n.$editors.length||!n.options.replyURL)break;c.storage.set(d,l),u.location.href=n.options.replyURL}case"remove":case"removeAll":case"removeSelected":var a=h.extend([],s.storeData),r=[];null!==o?r.push(o):"removeSelected"==i||"insertSelected"==i?s.list.find('input[type="checkbox"]:checked').each(function(){r.push(parseInt(this.value)),s.list.children().has('input[value="'+this.value+'"]').fadeOut()}):(s.storeData=[],s.list.children().fadeOut()),r.length&&(s.storeData=[],h.each(a,function(t,e){-1==h.inArray(t,r)&&s.storeData.push(e)}))}s.storeData.length||(s.storeData=null),c.storage.set(p,s.storeData),s.storeData?n.dataToDialog(e):n.$dialog.cbbDialog("close")},buildQuote:function(t,e){var i="[quote]";return t.username&&(i='[quote="<%username%>"',i=(i+=t.post?" post_id=<%post%>":"")+(t.time?" time=<%time%> user_id=<%user%>":"")+"]"),c.template.parse(i,t)+this.htmlToBBcode(t.text,e)+"[/quote]"},insert:function(t,e,i){var o="";t=h.isArray(t)?t:[t];for(var n,s,l,a=0;a<t.length;a++)o+=this.buildQuote(t[a],e)+"\n";this.$editors[e][0]._sceditor?(!0===i&&this.$editors[e][0]._sceditor.val(""),this.$editors[e][0]._sceditor.insert(o).focus(),s=this.$editors[e][0]._sceditor.getRangeHelper(),n=h(s.parentNode()).closest("blockquote").get(0),(l=s.selectedRange()).setStartAfter(n),l.collapse(!0),s.selectRange(l)):(!0===i&&this.$editors[e].val(""),n=this.$editors[e].val(),s=this.$editors[e].cbbCaret(),l=n.substring(0,s.start),i=n.substring(s.end,n.length),this.$editors[e].val(n=l+(o+="\n")+i).cbbCaret(l.length+o.length).focus())},mouseDown:function(t){this.isMouseDown=!0,this.stopPropagation=0<h(t.target).closest("a").length},mouseUp:function(t){this.isMouseDown&&(this.isMouseDown=!1,this.trigger(),this.mouseOffset={x:t.clientX,y:t.clientY})},selectionChange:function(){this.isMouseDown||this.trigger()},trigger:function(){this.timeout||this.processing||(this.timeout=setTimeout(h.proxy(this,"handleSelection"),100))},handleSelection:function(){this.processing=!0,this.timeout=null;var t=u.getSelection(),e=this.stopPropagation?null:this.getValidSelectionContainer(t),i=(e?this.showQuoteButton(e,t):this.hideQuoteButton(),this);setTimeout(function(){i.processing=!1,i.mouseOffset=null},0)},getValidSelectionContainer:function(t){return!t.isCollapsed&&t.rangeCount&&(t=t.getRangeAt(0),h.trim(t.toString()).length||t.cloneContents().querySelectorAll("img").length)&&(t=h(t.commonAncestorContainer).closest(this.options.target)).length?t:null},showQuoteButton:function(t,e){var i=e.getRangeAt(0).cloneRange(),o=i.getBoundingClientRect?i.getBoundingClientRect():null,n=h(s).scrollTop(),e=(null!=this.tooltip&&this.hideQuoteButton(),this.createButton(t,i),this.tooltip.data("quote",{text:this.getSelectionHtml(e),container:t,target:"phpbb"}),i={left:o.left+o.width/2,top:o.top+o.height+n+5},null!==this.mouseOffset&&i.left>this.mouseOffset.x&&(i.left=this.mouseOffset.x),{left:i.left-this.tooltip.outerWidth()/2,top:i.top});e.left=Math.max(0,e.left),e.left+this.tooltip.outerWidth()>h(u).width()&&(e.left=h(u).width()<this.tooltip.outerWidth()),e.top+this.tooltip.outerHeight()>h(u).height()+n&&(e.top=o.top-this.tooltip.outerHeight()+n-5),this.tooltip.css(e).show(),c.dispatchEvent("quickquote.onShowTooltip",this)},createButton:function(l,a){var r=this,t=parseInt(h("body").css("font-size"));r.tooltip=c.template.get("quickquote-tooltip",null,!0),(!t||t<11)&&r.tooltip.addClass("min-font-size"),r.tooltip.appendTo("body").find("a").click(function(t){t.preventDefault();var e={action:h(this).attr("data-action"),container:l,data:r.tooltip.data("quote"),currentTarget:a.commonAncestorContainer};switch(e.data.postInfo=l.children(".js-qq-post-info:first"),(e=c.dispatchEvent("quickquote.onTooltipAction",e)).action){case"quote":case"reply":var i,o=h("<div />").append(e.data.text),n=r.$editors[e.data.target];try{i=JSON.parse(e.data.postInfo.text())}catch(t){i={}}if(r.repaseCode(o),i.text=o.html(),"reply"==e.action){if(n){r.insert(i,e.data.target,r.options.replyOverwrite);break}"phpbb"==e.data.target&&r.options.replyURL&&(c.storage.set(d,i),u.location.href=r.options.replyURL)}else{o=c.storage.get(p)||[];o.push(i),c.storage.set(p,o),r.adjustButtons(o)}}var s=u.getSelection();s.isCollapsed||(s.collapse(s.getRangeAt(0).commonAncestorContainer,0),r.hideQuoteButton())})},adjustButtons:function(t){var e,i;return(t=void 0===t?c.storage.get(p)||[]:t).length?(null!==this.$btn&&(e=this.$btn.attr("data-text")+" ("+t.length+")",i=this.$btn.is("input")?"val":"html",this.$btn[i].call(this.$btn,e),this.$btn.show()),c.dispatchEvent("quickquote.onShowBtn",{quickquote:this,storedData:t}),!0):(null!==this.$btn&&this.$btn.hide(),c.dispatchEvent("quickquote.onHideBtn",[this,t]),!1)},hideQuoteButton:function(){this.tooltip&&(this.tooltip.fadeOut("fast",function(){h(this).remove()}),this.tooltip=null)},getSelectionHtml:function(t){let e=s.createElement("div"),i,o;for(i=0,o=t.rangeCount;i<o;i++)e.appendChild(t.getRangeAt(i).cloneContents());return h(e).find("[data-decoded]").each(function(){h(this).replaceWith(h(this).attr("data-decoded"))}),e.innerHTML},htmlToBBcode:function(t,e){var i=h("<div />").append(t.replace(/<br>\n/g,"<br>"));return this.repaseCode(i),e&&this.$editors[e]&&this.$editors[e][0]._sceditor?this.$editors[e][0]._sceditor.toBBCode(i.html()):(h.each(this.bbcodes,function(t,e){i.find(e.elem).each(function(){var o=h(this),t="function"==typeof e.replacement?e.replacement.apply(o):e.replacement.replace("{html}",o.html()).replace("{text}",o.text()).replace(/\{(attr|css):([\d\w]+)\}/,function(t,e,i){return"css"==e?c.rgbToHex(o[e].apply(o,[i])):o[e].apply(o,[i])});o.replaceWith(t)})}),i.find("br").replaceWith("\n"),i.text())},repaseCode:function(t){var e,i=t.children("li");i.length&&((e=h("<ul />")).append(i.clone()),i.filter(":first").before(e),i.remove()),t.find(".js-qq-post-info, .cbb-helper-hidden").remove()}},!1)})(jQuery,cbbCore,window,document);
\ No newline at end of file
+!function(h,c,u,s){"use strict";var d="quickquote_reply",p="quickquote_ary";c.registerService("quickquote",{options:{btnTarget:"body",editors:{},replyURL:"",replyOverwrite:!1,target:null},bbcodes:{b:{elem:'span[style="font-weight: bold"]',replacement:"[b]{html}[/b]"},i:{elem:'span[style="font-style: italic"]',replacement:"[i]{html}[/i]"},u:{elem:'span[style="text-decoration: underline"]',replacement:"[u]{html}[/u]"},code:{elem:"div.codebox",replacement:function(){return"[code]"+h(this).find("code").html()+"[/code]"}},quote:{elem:"blockquote",replacement:function(){var t=h(this).find("cite"),e="";return t.length&&(e='="'+t.text().replace("&nbsp;"," ").split(/\s/)[0]+'"',t.remove()),"[quote"+e+"]"+(h(this).children("div").length?h(this).children("div"):h(this)).html()+"[/quote]"}},url:{elem:"a[href]",replacement:function(){var t=h(this).html(),e=h(this).attr("href");return t==e?"[url]"+e+"[/url]":"[url="+e+"]"+t+"[/url]"}},img:{elem:"img[src]",replacement:function(){return h(this).hasClass("smilies")?h(this).attr("alt"):"[img]"+h(this).attr("src")+"[/img]"}},ul:{elem:"ul",replacement:"[list]{html}[/list]"},ol:{elem:"ol",replacement:"[list=1]{html}[/list]"},li:{elem:"li",replacement:"[*]{html}\n"},color:{elem:'span[style^="color"]',replacement:"[color={css:color}]{html}[/color]"},size:{elem:'span[style^="font-size"]',replacement:function(){return"[size="+h(this).css("font-size").replace("%","")+"]"+h(this).html()+"[/size]"}}},$editors:{def:"",length:0},$target:h([]),$dialog:null,$btn:null,isMouseDown:!1,stopPropagation:!1,mouseOffset:null,processing:!1,timeout:null,tooltip:null,__construct:function(){var i,t;u.getSelection&&((i=this).$target=h(this.options.target),this.options.replyOverwrite=!!+this.options.replyOverwrite,c.dispatchEvent("quickquote.beforeInit",this),h.each(this.options.editors,function(t,e){e=h(e);e.length&&(i.$editors[t]=e,i.$editors.length++,i.$editors.def&&"phpbb"!=t||(i.$editors.def=t))}),this.$editors.phpbb&&c.storage.get(d)&&(this.insert(c.storage.get(d),"phpbb",!0),c.storage.remove(d)),this.$target.length||this.$editors.length||this.options.replyURL||(this.options.btnTarget=!1),this.options.btnTarget&&(t=parseInt(h("body").css("font-size")),this.$btn=c.template.get("body"==this.options.btnTarget?"quickquote-floatbtn":"quickquote-inlinebtn",!1,!0),(!t||t<12)&&this.$btn.addClass("min-font-size"),this.$btn.appendTo(this.options.btnTarget),this.$btn.click(function(t){t.preventDefault(),i.initDialog(i.$editors.def)}),this.adjustButtons()),this.$target.length&&(this.$target.on("mousedown.qq",h.proxy(this,"mouseDown")),h(s).on({"selectionchange.qq":h.proxy(this,"selectionChange"),"mouseup.qq":h.proxy(this,"mouseUp")})),h(u).on("resize.quickquote",function(){null!=i.tooltip&&i.handleSelection()}),c.dispatchEvent("quickquote.onInit",this))},initDialog:function(e){this.$dialog=c.template.get("quickquote-dialog",!1,!0);var t=this.$dialog.find(".js-quickquote-list"),i=t.html(),o=this;t.hide(),this.adjustButtons([]),this.$dialog.data("quoteData",{storeData:c.storage.get(p)||[],rowStr:i,list:t}).cbbDialog({destroyOnClose:!0,movable:!1,height:300,width:700,onOpen:function(){h(this).find("a[data-action]").click(function(t){return t.preventDefault(),o.dialogTrigger(this,e)}),o.dataToDialog(e),o.$editors.length||o.options.replyURL||h(this).find('[data-action="insertAll"], [data-action="insertSelected"]').hide(),t.show()},onClose:function(){o.$dialog=null,o.adjustButtons(),c.dispatchEvent("quickquote.onCloseDialog",this)}}),c.dispatchEvent("quickquote.onInitDialog",this)},dataToDialog:function(e){var i=this,o=this.$dialog.data("quoteData");o.list.html(""),h.each(o.storeData,function(t,e){e.id=t,o.list.append(c.template.parse(o.rowStr,e))}),o.list.find("a[data-action]").click(function(t){return t.preventDefault(),i.dialogTrigger(this,e)}),o.list.find('input[type="checkbox"]').change(function(t){t.preventDefault(),o.list.find('input[type="checkbox"]:checked').length?(h(".js-btn-marked").objView(!0),h(".js-btn-all").objView(!1)):(h(".js-btn-marked").objView(!1),h(".js-btn-all").objView(!0))}).change(),this.$editors.length||this.options.replyURL||o.list.find('[data-action="insert"]').hide()},dialogTrigger:function(t,e){var i=h(t).attr("data-action"),o=null,n=this,s=this.$dialog.data("quoteData");switch("insert"!=i&&"remove"!=i||(o=parseInt(h(t).siblings("input").val())),i){case"insert":case"insertAll":case"insertSelected":var l=[];if(null!==o?l.push(s.storeData[o]):"insertSelected"==i?s.list.find('input[type="checkbox"]:checked').each(function(){l.push(s.storeData[this.value])}):h.each(s.storeData,function(t,e){l.push(e)}),n.$editors[e])n.insert(l,e);else{if(n.$editors.length||!n.options.replyURL)break;c.storage.set(d,l),u.location.href=n.options.replyURL}case"remove":case"removeAll":case"removeSelected":var a=h.extend([],s.storeData),r=[];null!==o?r.push(o):"removeSelected"==i||"insertSelected"==i?s.list.find('input[type="checkbox"]:checked').each(function(){r.push(parseInt(this.value)),s.list.children().has('input[value="'+this.value+'"]').fadeOut()}):(s.storeData=[],s.list.children().fadeOut()),r.length&&(s.storeData=[],h.each(a,function(t,e){-1==h.inArray(t,r)&&s.storeData.push(e)}))}s.storeData.length||(s.storeData=null),c.storage.set(p,s.storeData),s.storeData?n.dataToDialog(e):n.$dialog.cbbDialog("close")},buildQuote:function(t,e){var i="[quote]";return t.username&&(i='[quote="<%username%>"',i=(i+=t.post?" post_id=<%post%>":"")+(t.time?" time=<%time%> user_id=<%user%>":"")+"]"),c.template.parse(i,t)+this.htmlToBBcode(t.text,e)+"[/quote]"},insert:function(t,e,i){var o="";t=h.isArray(t)?t:[t];for(var n,s,l,a=0;a<t.length;a++)o+=this.buildQuote(t[a],e)+"\n";this.$editors[e][0]._sceditor?(!0===i&&this.$editors[e][0]._sceditor.val(""),this.$editors[e][0]._sceditor.insert(o).focus(),s=this.$editors[e][0]._sceditor.getRangeHelper(),n=h(s.parentNode()).closest("blockquote").get(0),(l=s.selectedRange()).setStartAfter(n),l.collapse(!0),s.selectRange(l)):(!0===i&&this.$editors[e].val(""),n=this.$editors[e].val(),s=this.$editors[e].cbbCaret(),l=n.substring(0,s.start),i=n.substring(s.end,n.length),this.$editors[e].val(n=l+(o+="\n")+i).cbbCaret(l.length+o.length).focus())},mouseDown:function(t){this.isMouseDown=!0,this.stopPropagation=0<h(t.target).closest("a").length},mouseUp:function(t){this.isMouseDown&&(this.isMouseDown=!1,this.trigger(),this.mouseOffset={x:t.clientX,y:t.clientY})},selectionChange:function(){this.isMouseDown||this.trigger()},trigger:function(){this.timeout||this.processing||(this.timeout=setTimeout(h.proxy(this,"handleSelection"),100))},handleSelection:function(){this.processing=!0,this.timeout=null;var t=u.getSelection(),e=this.stopPropagation?null:this.getValidSelectionContainer(t),i=(e?this.showQuoteButton(e,t):this.hideQuoteButton(),this);setTimeout(function(){i.processing=!1,i.mouseOffset=null},0)},getValidSelectionContainer:function(t){return!t.isCollapsed&&t.rangeCount&&(t=t.getRangeAt(0),h.trim(t.toString()).length||t.cloneContents().querySelectorAll("img").length)&&(t=h(t.commonAncestorContainer).closest(this.options.target)).length?t:null},showQuoteButton:function(t,e){var i=e.getRangeAt(0).cloneRange(),o=i.getBoundingClientRect?i.getBoundingClientRect():null,n=h(s).scrollTop(),e=(null!=this.tooltip&&this.hideQuoteButton(),this.createButton(t,i),this.tooltip.data("quote",{text:this.getSelectionHtml(e),container:t,target:"phpbb"}),i={left:o.left+o.width/2,top:o.top+o.height+n+5},null!==this.mouseOffset&&i.left>this.mouseOffset.x&&(i.left=this.mouseOffset.x),{left:i.left-this.tooltip.outerWidth()/2,top:i.top});e.left=Math.max(0,e.left),e.left+this.tooltip.outerWidth()>h(u).width()&&(e.left=h(u).width()<this.tooltip.outerWidth()),e.top+this.tooltip.outerHeight()>h(u).height()+n&&(e.top=o.top-this.tooltip.outerHeight()+n-5),this.tooltip.css(e).show(),c.dispatchEvent("quickquote.onShowTooltip",this)},createButton:function(l,a){var r=this,t=parseInt(h("body").css("font-size"));r.tooltip=c.template.get("quickquote-tooltip",null,!0),(!t||t<11)&&r.tooltip.addClass("min-font-size"),r.tooltip.appendTo("body").find("a").click(function(t){t.preventDefault();var e={action:h(this).attr("data-action"),container:l,data:r.tooltip.data("quote"),currentTarget:a.commonAncestorContainer};switch(e.data.postInfo=l.children(".js-qq-post-info:first"),(e=c.dispatchEvent("quickquote.onTooltipAction",e)).action){case"quote":case"reply":var i,o=h("<div />").append(e.data.text),n=r.$editors[e.data.target];try{i=JSON.parse(e.data.postInfo.text())}catch(t){i={}}if(r.repaseCode(o),i.text=o.html(),"reply"==e.action){if(n){r.insert(i,e.data.target,r.options.replyOverwrite);break}"phpbb"==e.data.target&&r.options.replyURL&&(c.storage.set(d,i),u.location.href=r.options.replyURL)}else{o=c.storage.get(p)||[];o.push(i),c.storage.set(p,o),r.adjustButtons(o)}}var s=u.getSelection();s.isCollapsed||(s.collapse(s.getRangeAt(0).commonAncestorContainer,0),r.hideQuoteButton())})},adjustButtons:function(t){var e,i;return(t=void 0===t?c.storage.get(p)||[]:t).length?(null!==this.$btn&&(e=this.$btn.attr("data-text")+" ("+t.length+")",i=this.$btn.is("input")?"val":"html",this.$btn[i].call(this.$btn,e),this.$btn.show()),c.dispatchEvent("quickquote.onShowBtn",{quickquote:this,storedData:t}),!0):(null!==this.$btn&&this.$btn.hide(),c.dispatchEvent("quickquote.onHideBtn",[this,t]),!1)},hideQuoteButton:function(){this.tooltip&&(this.tooltip.fadeOut("fast",function(){h(this).remove()}),this.tooltip=null)},getSelectionHtml:function(t){let e=s.createElement("div"),i,o;for(i=0,o=t.rangeCount;i<o;i++)e.appendChild(t.getRangeAt(i).cloneContents());return h(e).find("[data-decoded]").each(function(){h(this).replaceWith(h(this).attr("data-decoded"))}),e.innerHTML},htmlToBBcode:function(t,e){var i=h("<div />").append(t.replace(/<br>\n/g,"<br>"));return this.repaseCode(i),e&&this.$editors[e]&&this.$editors[e][0]._sceditor?this.$editors[e][0]._sceditor.toBBCode(i.html()):(h.each(this.bbcodes,function(t,e){i.find(e.elem).each(function(){var o=h(this),t="function"==typeof e.replacement?e.replacement.apply(o):e.replacement.replace("{html}",o.html()).replace("{text}",o.text()).replace(/\{(attr|css):([\d\w]+)\}/,function(t,e,i){return"css"==e?c.rgbToHex(o[e].apply(o,[i])):o[e].apply(o,[i])});o.replaceWith(t)})}),i.find("br").replaceWith("\n"),i.text())},repaseCode:function(t){var e,i=t.children("li");i.length&&((e=h("<ul />")).append(i.clone()),i.filter(":first").before(e),i.remove()),t.find(".js-qq-post-info, .cbb-helper-hidden").remove()}},!1)}(jQuery,cbbCore,window,document);
\ No newline at end of file
diff --git "[ORIGINAL]/canidev\\quickquote/styles/all/theme/quickquote.css" "[FORUM_EXT]/canidev\\quickquote/styles/all/theme/quickquote.css"
--- "[ORIGINAL]/canidev\\quickquote/styles/all/theme/quickquote.css"
+++ "[FORUM_EXT]/canidev\\quickquote/styles/all/theme/quickquote.css"
@@ -1,7 +1,7 @@
 /*  cBB QuickQuote StyleSheet
     --------------------------------------------------------------
 	Style:	All
-	Copyright (c) 2025 CaniDev ( https://www.canidev.com )
+	Copyright (c) 2024 CaniDev ( https://www.canidev.com )
     --------------------------------------------------------------
 */
 
@@ -139,11 +139,6 @@
 
 /* RTL
 ------------------------- */
-.rtl .quickquote-tooltip a > i {
-	margin-left: 5px;
-	margin-right: unset;
-}
-
 .rtl .quickquote-floatbtn {
 	left: 60px;
 	padding: 10px 10px 10px 30px;
diff --git "[ORIGINAL]/canidev\\quickquote/styles/zeina/template/event/overall_footer_body_after.html" "[ORIGINAL]/canidev\\quickquote/styles/zeina/template/event/overall_footer_body_after.html"
deleted file mode 100644
--- "[ORIGINAL]/canidev\\quickquote/styles/zeina/template/event/overall_footer_body_after.html"
+++ /dev/null
@@ -1,59 +0,0 @@
-{% if QQ_ENABLED %}
-	<template id="quickquote-tooltip">
-		<div class="quickquote-tooltip">
-			<a href="#" data-action="quote"><i class="fa fa-plus"></i>{{ lang('QQ_SAVE_QUOTE') }}</a>
-			<span class="tooltip-sep">|</span>
-			<a href="#" data-action="reply"><i class="fa fa-reply"></i>{{ lang('QQ_REPLY') }}</a>
-		</div>
-	</template>
-
-	<template id="quickquote-floatbtn">
-		<a href="#" class="quickquote-floatbtn card-sm" data-text="{{ lang('QUOTES') }}"></a>
-	</template>
-
-	<template id="quickquote-inlinebtn">
-		<button class="btn-primary-outline relative flex overflow-hidden transition-all duration-300 justify-center max-md:w-full quickquote-inlinebtn" data-text="{{ lang('QQ_INSERT_QUOTES') }}"></button>
-	</template>
-
-	<template id="quickquote-dialog">
-		<div class="qq-dialog" title="{{ lang('QUOTES') }}">
-			<div class="cbb-dialog-content dialog-content">
-				<ul class="js-quickquote-list">
-					<li>
-						<div class="titlebar">
-							<input id="check-<%id%>" type="checkbox" class="cbb-checkbox" value="<%id%>" />
-							<label for="check-<%id%>"></label><span><%username%></span>
-							<a href="#" data-action="remove" title="{{ lang('QQ_REMOVE') }}"><i class="fa fa-close"></i></a>
-							<a href="#" data-action="insert" title="{{ lang('QQ_INSERT') }}"><i class="fa fa-download"></i></a>
-						</div>
-						<div class="content"><%text%></div>
-					</li>
-				</ul>
-			</div>
-			<div class="cbb-dialog-buttons">
-				<div class="js-btn-marked cbb-helper-hidden">
-					<a href="#" class="cbb-btn" data-action="insertSelected">{{ lang('QQ_INSERT_SELECTED') }}</a>
-					<a href="#" class="cbb-btn" data-action="removeSelected">{{ lang('QQ_REMOVE_SELECTED') }}</a>
-				</div>
-				<div class="js-btn-all cbb-helper-hidden">
-					<a href="#" class="cbb-btn" data-action="insertAll">{{ lang('QQ_INSERT_ALL') }}</a>
-					<a href="#" class="cbb-btn" data-action="removeAll">{{ lang('QQ_REMOVE_ALL') }}</a>
-				</div>
-			</div>
-		</div>
-	</template>
-
-	<script>
-	(function($) {
-		cbbCore.initService('quickquote', {
-			btnTarget		: {% if QQ_FLOAT_BTN %}'body'{% else %}'#qr_postform div:has(.fullscreen-comment), #postform div:has(button[name="post"])'{% endif %},
-			target			: '.post .content, .block-postbody',
-			editors			: {
-				phpbb: '#message-box textarea[name]'
-			},
-			replyURL		: '{{ U_QQ_REPLY }}',
-			replyOverwrite	: '{{ QQ_REPLY_OVERWRITE }}'
-		});
-	})(jQuery);
-	</script>
-{% endif %}
```
