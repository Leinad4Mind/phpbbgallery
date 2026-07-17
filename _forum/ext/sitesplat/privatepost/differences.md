Existem diferencas reais no codigo ou texto. Diferencas de formatacao (espacos, tabs) foram ignoradas abaixo.

```diff
diff --git "[ORIGINAL]/sitesplat\\privatepost/composer.json" "[FORUM_EXT]/sitesplat\\privatepost/composer.json"
--- "[ORIGINAL]/sitesplat\\privatepost/composer.json"
+++ "[FORUM_EXT]/sitesplat\\privatepost/composer.json"
@@ -23,7 +23,8 @@
 		"version-check": {
             "host": "sitesplat.com",
             "directory": "/updatecheck/phpbb32/ext",
-            "filename": "privatepost.json"
+            "filename": "privatepost.json",
+			"ssl": true
 		}
     }
 }
\ No newline at end of file
diff --git "[FORUM_EXT]/sitesplat\\privatepost/diff_full.tmp" "[FORUM_EXT]/sitesplat\\privatepost/diff_full.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\privatepost/diff_full.tmp"
@@ -0,0 +1,250 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\privatepost/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\privatepost/composer.json"
+index 44dfbde4d..6992949ff 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\privatepost/composer.json"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\privatepost/composer.json"
+@@ -23,7 +23,8 @@
+ 		"version-check": {
+             "host": "sitesplat.com",
+             "directory": "/updatecheck/phpbb32/ext",
+-            "filename": "privatepost.json"
++            "filename": "privatepost.json",
++			"ssl": true
+ 		}
+     }
+ }
+\ No newline at end of file
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\privatepost/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\privatepost/diff_full.tmp"
+new file mode 100644
+index 000000000..e69de29bb
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\privatepost/language/pt/common.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\privatepost/language/pt/common.php"
+new file mode 100644
+index 000000000..f41aeb189
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\privatepost/language/pt/common.php"
+@@ -0,0 +1,41 @@
++<?php
++/**
++*
++* Private Post
++*
++* @copyright (c) 2016 SiteSplat All rights reserved
++* @license Proprietary
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
++	$lang = array();
++}
++
++$lang = array_merge($lang, array(
++	'PRIVATE_POST'						=> 'Mensagem Oculta',
++	'PRIVATE_POST_EXPLAIN'				=> 'Mensagens Ocultas podem APENAS ser lidas pela Equipa GoldTugAnime',
++	'PRIVATE_BY'						=> 'Mensagem Oculta por',
++	'PRIVATE_POST_NO_CONTENT'			=> 'O conteúdo desta mensagem foi marcado como oculto',
++	'NO_QUOTE_PRIVATE_POST'				=> 'Não podes citar mensagens ocultas.',
++	'NO_MANIPULATION_PRIVATE_POST'		=> 'Não podes manipular mensagens ocultas.',
++	'NO_QUICKMOD_WITH_PRIVATE_POST'		=> 'Não podes usar ferramentas de moderação rápidas em tópicos com mensagens ocultas.',
++	'NO_MCP_TOPIC_WITH_PRIVATE_POST'	=> 'Não podes moderar tópicos com mensagens ocultas.',
++	'NO_MCP_WARN_PRIVATE_POST'			=> 'Não podes avisar utilizador sobre mensagens ocultas.',
++	'NO_MCP_POST_DETAILS_PRIVATE_POST'	=> 'Não podes ver detalhes de mensagens ocultas de outrém.',
++	'NO_MCP_REPORT_PRIVATE_POST'		=> 'Não podes gerir relatórios de mensagens ocultas.',
++	'NO_REPORT_PRIVATE_POST'			=> 'Não podes reportar mensagens ocultas.',
++	'PRIVATE_TAG'						=> '<a title="Esta mensagem foi marcada como oculta."><span class="label label-warning" style="display: inline-block;font-size: 11px;margin-bottom: 3px;padding: 2px 4px;line-height: inherit;vertical-align: middle;"><i class="fa fa-exclamation-triangle"></i>&nbsp;[MENSAGEM OCULTA]</span></a>&nbsp;',
++
++	'FLTL_PRIVATE'		=> '[mensagem oculta]',
++	'BBPREVIEW_PRIVATE'	=> '[mensagem oculta]',
++));
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\privatepost/language/pt/info_acp_privatepost.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\privatepost/language/pt/info_acp_privatepost.php"
+new file mode 100644
+index 000000000..d6ae30f2f
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\privatepost/language/pt/info_acp_privatepost.php"
+@@ -0,0 +1,29 @@
++<?php
++/**
++*
++* Private Post
++*
++* @copyright (c) 2016 SiteSplat All rights reserved
++* @license Proprietary
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
++if ( empty($lang) || !is_array($lang) )
++{
++	$lang = array();
++}
++
++$lang = array_merge($lang, array(
++	'PRIVATEPOST_NOTICE'		    => '<div class="phpinfo"><p><br />The settings for this extensions are in <strong>%1$s » %2$s » %3$s</strong>.<br />The permission is forum-based. This means that you need to select a group AND a forum to which you want to grant the permission to.<br /> If you want to make this quicker, navigate to <strong>Permissions Roles -> Forum roles -> Full access</strong> and set permission there (for each role). It will be automatically update all groups that use Full access role (or any other roles you adjusted) across the board.<br /><br /> <strong>WARNING</strong>: Please note that due to the nature of this extension all the posts that have been marked as private will be deleted as "Soft Delete" when the extension is disabled. <br />Soft deleted posts or topics can be found under the Moderation Control Panel. (MCP)</p></div>',
++	'ACP_PRIVATEPOST_PERMISSIONS'	=> 'select Group and forum then "Advanced Permissions" » Content Tab "Can read private post"',
++	'SS_HELPER_NOTY'				=> 'SiteSplat BBcore does not exist!<br />Download the <a href="http://sitesplat.com" target="_blank">BBcore</a> and copy the BBcore folder into your sitesplat extension folder.',
++));
++
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\privatepost/language/pt/permissions_privatepost.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\privatepost/language/pt/permissions_privatepost.php"
+new file mode 100644
+index 000000000..3023d29c8
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\privatepost/language/pt/permissions_privatepost.php"
+@@ -0,0 +1,26 @@
++<?php
++/**
++*
++* Private Post
++*
++* @copyright (c) 2016 SiteSplat All rights reserved
++* @license Proprietary
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
++	$lang = array();
++}
++
++$lang = array_merge($lang, array(
++	'ACL_U_SEEPRIVATEPOSTS'	=> 'Can read private posts',
++));
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\privatepost/language/pt-preao/common.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\privatepost/language/pt-preao/common.php"
+new file mode 100644
+index 000000000..f41aeb189
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\privatepost/language/pt-preao/common.php"
+@@ -0,0 +1,41 @@
++<?php
++/**
++*
++* Private Post
++*
++* @copyright (c) 2016 SiteSplat All rights reserved
++* @license Proprietary
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
++	$lang = array();
++}
++
++$lang = array_merge($lang, array(
++	'PRIVATE_POST'						=> 'Mensagem Oculta',
++	'PRIVATE_POST_EXPLAIN'				=> 'Mensagens Ocultas podem APENAS ser lidas pela Equipa GoldTugAnime',
++	'PRIVATE_BY'						=> 'Mensagem Oculta por',
++	'PRIVATE_POST_NO_CONTENT'			=> 'O conteúdo desta mensagem foi marcado como oculto',
++	'NO_QUOTE_PRIVATE_POST'				=> 'Não podes citar mensagens ocultas.',
++	'NO_MANIPULATION_PRIVATE_POST'		=> 'Não podes manipular mensagens ocultas.',
++	'NO_QUICKMOD_WITH_PRIVATE_POST'		=> 'Não podes usar ferramentas de moderação rápidas em tópicos com mensagens ocultas.',
++	'NO_MCP_TOPIC_WITH_PRIVATE_POST'	=> 'Não podes moderar tópicos com mensagens ocultas.',
++	'NO_MCP_WARN_PRIVATE_POST'			=> 'Não podes avisar utilizador sobre mensagens ocultas.',
++	'NO_MCP_POST_DETAILS_PRIVATE_POST'	=> 'Não podes ver detalhes de mensagens ocultas de outrém.',
++	'NO_MCP_REPORT_PRIVATE_POST'		=> 'Não podes gerir relatórios de mensagens ocultas.',
++	'NO_REPORT_PRIVATE_POST'			=> 'Não podes reportar mensagens ocultas.',
++	'PRIVATE_TAG'						=> '<a title="Esta mensagem foi marcada como oculta."><span class="label label-warning" style="display: inline-block;font-size: 11px;margin-bottom: 3px;padding: 2px 4px;line-height: inherit;vertical-align: middle;"><i class="fa fa-exclamation-triangle"></i>&nbsp;[MENSAGEM OCULTA]</span></a>&nbsp;',
++
++	'FLTL_PRIVATE'		=> '[mensagem oculta]',
++	'BBPREVIEW_PRIVATE'	=> '[mensagem oculta]',
++));
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\privatepost/language/pt-preao/info_acp_privatepost.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\privatepost/language/pt-preao/info_acp_privatepost.php"
+new file mode 100644
+index 000000000..d6ae30f2f
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\privatepost/language/pt-preao/info_acp_privatepost.php"
+@@ -0,0 +1,29 @@
++<?php
++/**
++*
++* Private Post
++*
++* @copyright (c) 2016 SiteSplat All rights reserved
++* @license Proprietary
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
++if ( empty($lang) || !is_array($lang) )
++{
++	$lang = array();
++}
++
++$lang = array_merge($lang, array(
++	'PRIVATEPOST_NOTICE'		    => '<div class="phpinfo"><p><br />The settings for this extensions are in <strong>%1$s » %2$s » %3$s</strong>.<br />The permission is forum-based. This means that you need to select a group AND a forum to which you want to grant the permission to.<br /> If you want to make this quicker, navigate to <strong>Permissions Roles -> Forum roles -> Full access</strong> and set permission there (for each role). It will be automatically update all groups that use Full access role (or any other roles you adjusted) across the board.<br /><br /> <strong>WARNING</strong>: Please note that due to the nature of this extension all the posts that have been marked as private will be deleted as "Soft Delete" when the extension is disabled. <br />Soft deleted posts or topics can be found under the Moderation Control Panel. (MCP)</p></div>',
++	'ACP_PRIVATEPOST_PERMISSIONS'	=> 'select Group and forum then "Advanced Permissions" » Content Tab "Can read private post"',
++	'SS_HELPER_NOTY'				=> 'SiteSplat BBcore does not exist!<br />Download the <a href="http://sitesplat.com" target="_blank">BBcore</a> and copy the BBcore folder into your sitesplat extension folder.',
++));
++
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\privatepost/language/pt-preao/permissions_privatepost.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\privatepost/language/pt-preao/permissions_privatepost.php"
+new file mode 100644
+index 000000000..3023d29c8
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\privatepost/language/pt-preao/permissions_privatepost.php"
+@@ -0,0 +1,26 @@
++<?php
++/**
++*
++* Private Post
++*
++* @copyright (c) 2016 SiteSplat All rights reserved
++* @license Proprietary
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
++	$lang = array();
++}
++
++$lang = array_merge($lang, array(
++	'ACL_U_SEEPRIVATEPOSTS'	=> 'Can read private posts',
++));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\privatepost/styles/FLATBOOTS/template/event/posting_editor_options_prepend.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\privatepost/styles/FLATBOOTS/template/event/posting_editor_options_prepend_hide.html"
+similarity index 100%
+rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\privatepost/styles/FLATBOOTS/template/event/posting_editor_options_prepend.html"
+rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\privatepost/styles/FLATBOOTS/template/event/posting_editor_options_prepend_hide.html"
diff --git "[FORUM_EXT]/sitesplat\\privatepost/diff_nospace.tmp" "[FORUM_EXT]/sitesplat\\privatepost/diff_nospace.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\privatepost/diff_nospace.tmp"
@@ -0,0 +1,247 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\privatepost/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\privatepost/composer.json"
+index 44dfbde4d..6992949ff 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\privatepost/composer.json"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\privatepost/composer.json"
+@@ -23,7 +23,8 @@
+ 		"version-check": {
+             "host": "sitesplat.com",
+             "directory": "/updatecheck/phpbb32/ext",
+-            "filename": "privatepost.json"
++            "filename": "privatepost.json",
++			"ssl": true
+ 		}
+     }
+ }
+\ No newline at end of file
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\privatepost/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\privatepost/diff_full.tmp"
+new file mode 100644
+index 000000000..caac714a1
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\privatepost/diff_full.tmp"
+@@ -0,0 +1,250 @@
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\privatepost/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\privatepost/composer.json"
++index 44dfbde4d..6992949ff 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\privatepost/composer.json"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\privatepost/composer.json"
++@@ -23,7 +23,8 @@
++ 		"version-check": {
++             "host": "sitesplat.com",
++             "directory": "/updatecheck/phpbb32/ext",
++-            "filename": "privatepost.json"
+++            "filename": "privatepost.json",
+++			"ssl": true
++ 		}
++     }
++ }
++\ No newline at end of file
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\privatepost/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\privatepost/diff_full.tmp"
++new file mode 100644
++index 000000000..e69de29bb
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\privatepost/language/pt/common.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\privatepost/language/pt/common.php"
++new file mode 100644
++index 000000000..f41aeb189
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\privatepost/language/pt/common.php"
++@@ -0,0 +1,41 @@
+++<?php
+++/**
+++*
+++* Private Post
+++*
+++* @copyright (c) 2016 SiteSplat All rights reserved
+++* @license Proprietary
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
+++	$lang = array();
+++}
+++
+++$lang = array_merge($lang, array(
+++	'PRIVATE_POST'						=> 'Mensagem Oculta',
+++	'PRIVATE_POST_EXPLAIN'				=> 'Mensagens Ocultas podem APENAS ser lidas pela Equipa GoldTugAnime',
+++	'PRIVATE_BY'						=> 'Mensagem Oculta por',
+++	'PRIVATE_POST_NO_CONTENT'			=> 'O conteúdo desta mensagem foi marcado como oculto',
+++	'NO_QUOTE_PRIVATE_POST'				=> 'Não podes citar mensagens ocultas.',
+++	'NO_MANIPULATION_PRIVATE_POST'		=> 'Não podes manipular mensagens ocultas.',
+++	'NO_QUICKMOD_WITH_PRIVATE_POST'		=> 'Não podes usar ferramentas de moderação rápidas em tópicos com mensagens ocultas.',
+++	'NO_MCP_TOPIC_WITH_PRIVATE_POST'	=> 'Não podes moderar tópicos com mensagens ocultas.',
+++	'NO_MCP_WARN_PRIVATE_POST'			=> 'Não podes avisar utilizador sobre mensagens ocultas.',
+++	'NO_MCP_POST_DETAILS_PRIVATE_POST'	=> 'Não podes ver detalhes de mensagens ocultas de outrém.',
+++	'NO_MCP_REPORT_PRIVATE_POST'		=> 'Não podes gerir relatórios de mensagens ocultas.',
+++	'NO_REPORT_PRIVATE_POST'			=> 'Não podes reportar mensagens ocultas.',
+++	'PRIVATE_TAG'						=> '<a title="Esta mensagem foi marcada como oculta."><span class="label label-warning" style="display: inline-block;font-size: 11px;margin-bottom: 3px;padding: 2px 4px;line-height: inherit;vertical-align: middle;"><i class="fa fa-exclamation-triangle"></i>&nbsp;[MENSAGEM OCULTA]</span></a>&nbsp;',
+++
+++	'FLTL_PRIVATE'		=> '[mensagem oculta]',
+++	'BBPREVIEW_PRIVATE'	=> '[mensagem oculta]',
+++));
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\privatepost/language/pt/info_acp_privatepost.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\privatepost/language/pt/info_acp_privatepost.php"
++new file mode 100644
++index 000000000..d6ae30f2f
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\privatepost/language/pt/info_acp_privatepost.php"
++@@ -0,0 +1,29 @@
+++<?php
+++/**
+++*
+++* Private Post
+++*
+++* @copyright (c) 2016 SiteSplat All rights reserved
+++* @license Proprietary
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
+++if ( empty($lang) || !is_array($lang) )
+++{
+++	$lang = array();
+++}
+++
+++$lang = array_merge($lang, array(
+++	'PRIVATEPOST_NOTICE'		    => '<div class="phpinfo"><p><br />The settings for this extensions are in <strong>%1$s » %2$s » %3$s</strong>.<br />The permission is forum-based. This means that you need to select a group AND a forum to which you want to grant the permission to.<br /> If you want to make this quicker, navigate to <strong>Permissions Roles -> Forum roles -> Full access</strong> and set permission there (for each role). It will be automatically update all groups that use Full access role (or any other roles you adjusted) across the board.<br /><br /> <strong>WARNING</strong>: Please note that due to the nature of this extension all the posts that have been marked as private will be deleted as "Soft Delete" when the extension is disabled. <br />Soft deleted posts or topics can be found under the Moderation Control Panel. (MCP)</p></div>',
+++	'ACP_PRIVATEPOST_PERMISSIONS'	=> 'select Group and forum then "Advanced Permissions" » Content Tab "Can read private post"',
+++	'SS_HELPER_NOTY'				=> 'SiteSplat BBcore does not exist!<br />Download the <a href="http://sitesplat.com" target="_blank">BBcore</a> and copy the BBcore folder into your sitesplat extension folder.',
+++));
+++
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\privatepost/language/pt/permissions_privatepost.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\privatepost/language/pt/permissions_privatepost.php"
++new file mode 100644
++index 000000000..3023d29c8
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\privatepost/language/pt/permissions_privatepost.php"
++@@ -0,0 +1,26 @@
+++<?php
+++/**
+++*
+++* Private Post
+++*
+++* @copyright (c) 2016 SiteSplat All rights reserved
+++* @license Proprietary
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
+++	$lang = array();
+++}
+++
+++$lang = array_merge($lang, array(
+++	'ACL_U_SEEPRIVATEPOSTS'	=> 'Can read private posts',
+++));
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\privatepost/language/pt-preao/common.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\privatepost/language/pt-preao/common.php"
++new file mode 100644
++index 000000000..f41aeb189
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\privatepost/language/pt-preao/common.php"
++@@ -0,0 +1,41 @@
+++<?php
+++/**
+++*
+++* Private Post
+++*
+++* @copyright (c) 2016 SiteSplat All rights reserved
+++* @license Proprietary
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
+++	$lang = array();
+++}
+++
+++$lang = array_merge($lang, array(
+++	'PRIVATE_POST'						=> 'Mensagem Oculta',
+++	'PRIVATE_POST_EXPLAIN'				=> 'Mensagens Ocultas podem APENAS ser lidas pela Equipa GoldTugAnime',
+++	'PRIVATE_BY'						=> 'Mensagem Oculta por',
+++	'PRIVATE_POST_NO_CONTENT'			=> 'O conteúdo desta mensagem foi marcado como oculto',
+++	'NO_QUOTE_PRIVATE_POST'				=> 'Não podes citar mensagens ocultas.',
+++	'NO_MANIPULATION_PRIVATE_POST'		=> 'Não podes manipular mensagens ocultas.',
+++	'NO_QUICKMOD_WITH_PRIVATE_POST'		=> 'Não podes usar ferramentas de moderação rápidas em tópicos com mensagens ocultas.',
+++	'NO_MCP_TOPIC_WITH_PRIVATE_POST'	=> 'Não podes moderar tópicos com mensagens ocultas.',
+++	'NO_MCP_WARN_PRIVATE_POST'			=> 'Não podes avisar utilizador sobre mensagens ocultas.',
+++	'NO_MCP_POST_DETAILS_PRIVATE_POST'	=> 'Não podes ver detalhes de mensagens ocultas de outrém.',
+++	'NO_MCP_REPORT_PRIVATE_POST'		=> 'Não podes gerir relatórios de mensagens ocultas.',
+++	'NO_REPORT_PRIVATE_POST'			=> 'Não podes reportar mensagens ocultas.',
+++	'PRIVATE_TAG'						=> '<a title="Esta mensagem foi marcada como oculta."><span class="label label-warning" style="display: inline-block;font-size: 11px;margin-bottom: 3px;padding: 2px 4px;line-height: inherit;vertical-align: middle;"><i class="fa fa-exclamation-triangle"></i>&nbsp;[MENSAGEM OCULTA]</span></a>&nbsp;',
+++
+++	'FLTL_PRIVATE'		=> '[mensagem oculta]',
+++	'BBPREVIEW_PRIVATE'	=> '[mensagem oculta]',
+++));
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\privatepost/language/pt-preao/info_acp_privatepost.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\privatepost/language/pt-preao/info_acp_privatepost.php"
++new file mode 100644
++index 000000000..d6ae30f2f
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\privatepost/language/pt-preao/info_acp_privatepost.php"
++@@ -0,0 +1,29 @@
+++<?php
+++/**
+++*
+++* Private Post
+++*
+++* @copyright (c) 2016 SiteSplat All rights reserved
+++* @license Proprietary
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
+++if ( empty($lang) || !is_array($lang) )
+++{
+++	$lang = array();
+++}
+++
+++$lang = array_merge($lang, array(
+++	'PRIVATEPOST_NOTICE'		    => '<div class="phpinfo"><p><br />The settings for this extensions are in <strong>%1$s » %2$s » %3$s</strong>.<br />The permission is forum-based. This means that you need to select a group AND a forum to which you want to grant the permission to.<br /> If you want to make this quicker, navigate to <strong>Permissions Roles -> Forum roles -> Full access</strong> and set permission there (for each role). It will be automatically update all groups that use Full access role (or any other roles you adjusted) across the board.<br /><br /> <strong>WARNING</strong>: Please note that due to the nature of this extension all the posts that have been marked as private will be deleted as "Soft Delete" when the extension is disabled. <br />Soft deleted posts or topics can be found under the Moderation Control Panel. (MCP)</p></div>',
+++	'ACP_PRIVATEPOST_PERMISSIONS'	=> 'select Group and forum then "Advanced Permissions" » Content Tab "Can read private post"',
+++	'SS_HELPER_NOTY'				=> 'SiteSplat BBcore does not exist!<br />Download the <a href="http://sitesplat.com" target="_blank">BBcore</a> and copy the BBcore folder into your sitesplat extension folder.',
+++));
+++
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\privatepost/language/pt-preao/permissions_privatepost.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\privatepost/language/pt-preao/permissions_privatepost.php"
++new file mode 100644
++index 000000000..3023d29c8
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\privatepost/language/pt-preao/permissions_privatepost.php"
++@@ -0,0 +1,26 @@
+++<?php
+++/**
+++*
+++* Private Post
+++*
+++* @copyright (c) 2016 SiteSplat All righ
\ No newline at end of file
diff --git "[FORUM_EXT]/sitesplat\\privatepost/language/pt/common.php" "[FORUM_EXT]/sitesplat\\privatepost/language/pt/common.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\privatepost/language/pt/common.php"
@@ -0,0 +1,41 @@
+<?php
+/**
+*
+* Private Post
+*
+* @copyright (c) 2016 SiteSplat All rights reserved
+* @license Proprietary
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
+	$lang = array();
+}
+
+$lang = array_merge($lang, array(
+	'PRIVATE_POST'						=> 'Mensagem Oculta',
+	'PRIVATE_POST_EXPLAIN'				=> 'Mensagens Ocultas podem APENAS ser lidas pela Equipa GoldTugAnime',
+	'PRIVATE_BY'						=> 'Mensagem Oculta por',
+	'PRIVATE_POST_NO_CONTENT'			=> 'O conteúdo desta mensagem foi marcado como oculto',
+	'NO_QUOTE_PRIVATE_POST'				=> 'Não podes citar mensagens ocultas.',
+	'NO_MANIPULATION_PRIVATE_POST'		=> 'Não podes manipular mensagens ocultas.',
+	'NO_QUICKMOD_WITH_PRIVATE_POST'		=> 'Não podes usar ferramentas de moderação rápidas em tópicos com mensagens ocultas.',
+	'NO_MCP_TOPIC_WITH_PRIVATE_POST'	=> 'Não podes moderar tópicos com mensagens ocultas.',
+	'NO_MCP_WARN_PRIVATE_POST'			=> 'Não podes avisar utilizador sobre mensagens ocultas.',
+	'NO_MCP_POST_DETAILS_PRIVATE_POST'	=> 'Não podes ver detalhes de mensagens ocultas de outrém.',
+	'NO_MCP_REPORT_PRIVATE_POST'		=> 'Não podes gerir relatórios de mensagens ocultas.',
+	'NO_REPORT_PRIVATE_POST'			=> 'Não podes reportar mensagens ocultas.',
+	'PRIVATE_TAG'						=> '<a title="Esta mensagem foi marcada como oculta."><span class="label label-warning" style="display: inline-block;font-size: 11px;margin-bottom: 3px;padding: 2px 4px;line-height: inherit;vertical-align: middle;"><i class="fa fa-exclamation-triangle"></i>&nbsp;[MENSAGEM OCULTA]</span></a>&nbsp;',
+
+	'FLTL_PRIVATE'		=> '[mensagem oculta]',
+	'BBPREVIEW_PRIVATE'	=> '[mensagem oculta]',
+));
diff --git "[FORUM_EXT]/sitesplat\\privatepost/language/pt/info_acp_privatepost.php" "[FORUM_EXT]/sitesplat\\privatepost/language/pt/info_acp_privatepost.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\privatepost/language/pt/info_acp_privatepost.php"
@@ -0,0 +1,29 @@
+<?php
+/**
+*
+* Private Post
+*
+* @copyright (c) 2016 SiteSplat All rights reserved
+* @license Proprietary
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
+if ( empty($lang) || !is_array($lang) )
+{
+	$lang = array();
+}
+
+$lang = array_merge($lang, array(
+	'PRIVATEPOST_NOTICE'		    => '<div class="phpinfo"><p><br />The settings for this extensions are in <strong>%1$s » %2$s » %3$s</strong>.<br />The permission is forum-based. This means that you need to select a group AND a forum to which you want to grant the permission to.<br /> If you want to make this quicker, navigate to <strong>Permissions Roles -> Forum roles -> Full access</strong> and set permission there (for each role). It will be automatically update all groups that use Full access role (or any other roles you adjusted) across the board.<br /><br /> <strong>WARNING</strong>: Please note that due to the nature of this extension all the posts that have been marked as private will be deleted as "Soft Delete" when the extension is disabled. <br />Soft deleted posts or topics can be found under the Moderation Control Panel. (MCP)</p></div>',
+	'ACP_PRIVATEPOST_PERMISSIONS'	=> 'select Group and forum then "Advanced Permissions" » Content Tab "Can read private post"',
+	'SS_HELPER_NOTY'				=> 'SiteSplat BBcore does not exist!<br />Download the <a href="http://sitesplat.com" target="_blank">BBcore</a> and copy the BBcore folder into your sitesplat extension folder.',
+));
+
diff --git "[FORUM_EXT]/sitesplat\\privatepost/language/pt/permissions_privatepost.php" "[FORUM_EXT]/sitesplat\\privatepost/language/pt/permissions_privatepost.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\privatepost/language/pt/permissions_privatepost.php"
@@ -0,0 +1,26 @@
+<?php
+/**
+*
+* Private Post
+*
+* @copyright (c) 2016 SiteSplat All rights reserved
+* @license Proprietary
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
+	$lang = array();
+}
+
+$lang = array_merge($lang, array(
+	'ACL_U_SEEPRIVATEPOSTS'	=> 'Can read private posts',
+));
diff --git "[FORUM_EXT]/sitesplat\\privatepost/language/pt-preao/common.php" "[FORUM_EXT]/sitesplat\\privatepost/language/pt-preao/common.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\privatepost/language/pt-preao/common.php"
@@ -0,0 +1,41 @@
+<?php
+/**
+*
+* Private Post
+*
+* @copyright (c) 2016 SiteSplat All rights reserved
+* @license Proprietary
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
+	$lang = array();
+}
+
+$lang = array_merge($lang, array(
+	'PRIVATE_POST'						=> 'Mensagem Oculta',
+	'PRIVATE_POST_EXPLAIN'				=> 'Mensagens Ocultas podem APENAS ser lidas pela Equipa GoldTugAnime',
+	'PRIVATE_BY'						=> 'Mensagem Oculta por',
+	'PRIVATE_POST_NO_CONTENT'			=> 'O conteúdo desta mensagem foi marcado como oculto',
+	'NO_QUOTE_PRIVATE_POST'				=> 'Não podes citar mensagens ocultas.',
+	'NO_MANIPULATION_PRIVATE_POST'		=> 'Não podes manipular mensagens ocultas.',
+	'NO_QUICKMOD_WITH_PRIVATE_POST'		=> 'Não podes usar ferramentas de moderação rápidas em tópicos com mensagens ocultas.',
+	'NO_MCP_TOPIC_WITH_PRIVATE_POST'	=> 'Não podes moderar tópicos com mensagens ocultas.',
+	'NO_MCP_WARN_PRIVATE_POST'			=> 'Não podes avisar utilizador sobre mensagens ocultas.',
+	'NO_MCP_POST_DETAILS_PRIVATE_POST'	=> 'Não podes ver detalhes de mensagens ocultas de outrém.',
+	'NO_MCP_REPORT_PRIVATE_POST'		=> 'Não podes gerir relatórios de mensagens ocultas.',
+	'NO_REPORT_PRIVATE_POST'			=> 'Não podes reportar mensagens ocultas.',
+	'PRIVATE_TAG'						=> '<a title="Esta mensagem foi marcada como oculta."><span class="label label-warning" style="display: inline-block;font-size: 11px;margin-bottom: 3px;padding: 2px 4px;line-height: inherit;vertical-align: middle;"><i class="fa fa-exclamation-triangle"></i>&nbsp;[MENSAGEM OCULTA]</span></a>&nbsp;',
+
+	'FLTL_PRIVATE'		=> '[mensagem oculta]',
+	'BBPREVIEW_PRIVATE'	=> '[mensagem oculta]',
+));
diff --git "[FORUM_EXT]/sitesplat\\privatepost/language/pt-preao/info_acp_privatepost.php" "[FORUM_EXT]/sitesplat\\privatepost/language/pt-preao/info_acp_privatepost.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\privatepost/language/pt-preao/info_acp_privatepost.php"
@@ -0,0 +1,29 @@
+<?php
+/**
+*
+* Private Post
+*
+* @copyright (c) 2016 SiteSplat All rights reserved
+* @license Proprietary
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
+if ( empty($lang) || !is_array($lang) )
+{
+	$lang = array();
+}
+
+$lang = array_merge($lang, array(
+	'PRIVATEPOST_NOTICE'		    => '<div class="phpinfo"><p><br />The settings for this extensions are in <strong>%1$s » %2$s » %3$s</strong>.<br />The permission is forum-based. This means that you need to select a group AND a forum to which you want to grant the permission to.<br /> If you want to make this quicker, navigate to <strong>Permissions Roles -> Forum roles -> Full access</strong> and set permission there (for each role). It will be automatically update all groups that use Full access role (or any other roles you adjusted) across the board.<br /><br /> <strong>WARNING</strong>: Please note that due to the nature of this extension all the posts that have been marked as private will be deleted as "Soft Delete" when the extension is disabled. <br />Soft deleted posts or topics can be found under the Moderation Control Panel. (MCP)</p></div>',
+	'ACP_PRIVATEPOST_PERMISSIONS'	=> 'select Group and forum then "Advanced Permissions" » Content Tab "Can read private post"',
+	'SS_HELPER_NOTY'				=> 'SiteSplat BBcore does not exist!<br />Download the <a href="http://sitesplat.com" target="_blank">BBcore</a> and copy the BBcore folder into your sitesplat extension folder.',
+));
+
diff --git "[FORUM_EXT]/sitesplat\\privatepost/language/pt-preao/permissions_privatepost.php" "[FORUM_EXT]/sitesplat\\privatepost/language/pt-preao/permissions_privatepost.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\privatepost/language/pt-preao/permissions_privatepost.php"
@@ -0,0 +1,26 @@
+<?php
+/**
+*
+* Private Post
+*
+* @copyright (c) 2016 SiteSplat All rights reserved
+* @license Proprietary
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
+	$lang = array();
+}
+
+$lang = array_merge($lang, array(
+	'ACL_U_SEEPRIVATEPOSTS'	=> 'Can read private posts',
+));
diff --git "[ORIGINAL]/sitesplat\\privatepost/styles/FLATBOOTS/template/event/posting_editor_options_prepend.html" "[FORUM_EXT]/sitesplat\\privatepost/styles/FLATBOOTS/template/event/posting_editor_options_prepend_hide.html"
similarity index 100%
rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\privatepost/styles/FLATBOOTS/template/event/posting_editor_options_prepend.html"
rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\privatepost/styles/FLATBOOTS/template/event/posting_editor_options_prepend_hide.html"
```
