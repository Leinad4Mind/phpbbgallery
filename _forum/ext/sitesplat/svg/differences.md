Existem diferencas reais no codigo ou texto. Diferencas de formatacao (espacos, tabs) foram ignoradas abaixo.

```diff
diff --git "[FORUM_EXT]/sitesplat\\svg/diff_full.tmp" "[FORUM_EXT]/sitesplat\\svg/diff_full.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\svg/diff_full.tmp"
@@ -0,0 +1,16 @@
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\svg/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\svg/diff_full.tmp"
+new file mode 100644
+index 000000000..e69de29bb
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\svg/language/en/info_acp_svg.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\svg/language/en/info_acp_svg.php"
+index b1e74c3e0..1f337398b 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\svg/language/en/info_acp_svg.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\svg/language/en/info_acp_svg.php"
+@@ -21,7 +21,7 @@ if (empty($lang) || !is_array($lang))
+ 
+ $lang = array_merge($lang, array(
+ 	'FORUM_ICONS'	                            => 'Forum icons',
+-	'BBSVG_NOTICE'						        => '<div style="auto;margin:20px auto;"><p>The setting for this extension are in <strong>%1$s &#187; %2$s &#187; %3$s</strong>.<br />You can also add SVG for group ranks. <strong>ACP &#187; Users and Groups &#187; Users &#187; Manage ranks</strong>.</p></div>',
++	'BBSVG_NOTICE'						        => '<div style="width:auto;margin:20px auto;"><p>The setting for this extension are in <strong>%1$s &#187; %2$s &#187; %3$s</strong>.<br />You can also add SVG for group ranks. <strong>ACP &#187; Users and Groups &#187; Users &#187; Manage ranks</strong>.</p></div>',
+ 	'SS_HELPER_NOTY'	                        => 'SiteSplat BBcore does not exist!<br />Download the <a href="https://sitesplat.com" target="_blank">BBcore</a> and copy the BBcore folder into your sitesplat extension folder.',
+     'ACP_BBSVG_FORUMS'	                        => 'Forum administration. Select forum and edit to find the custom Forum icons settings',
+ 	'ACP_BBSVG_FORUMS_EXPLAIN'	                => 'If you need to remove the default gray circle in the forum/topic list you can add the following code to your custom.css:',
diff --git "[FORUM_EXT]/sitesplat\\svg/diff_nospace.tmp" "[FORUM_EXT]/sitesplat\\svg/diff_nospace.tmp"
new file mode 100644
diff --git "[ORIGINAL]/sitesplat\\svg/language/en/info_acp_svg.php" "[FORUM_EXT]/sitesplat\\svg/language/en/info_acp_svg.php"
--- "[ORIGINAL]/sitesplat\\svg/language/en/info_acp_svg.php"
+++ "[FORUM_EXT]/sitesplat\\svg/language/en/info_acp_svg.php"
@@ -21,7 +21,7 @@ if (empty($lang) || !is_array($lang))
 
 $lang = array_merge($lang, array(
 	'FORUM_ICONS'	                            => 'Forum icons',
-	'BBSVG_NOTICE'						        => '<div style="auto;margin:20px auto;"><p>The setting for this extension are in <strong>%1$s &#187; %2$s &#187; %3$s</strong>.<br />You can also add SVG for group ranks. <strong>ACP &#187; Users and Groups &#187; Users &#187; Manage ranks</strong>.</p></div>',
+	'BBSVG_NOTICE'						        => '<div style="width:auto;margin:20px auto;"><p>The setting for this extension are in <strong>%1$s &#187; %2$s &#187; %3$s</strong>.<br />You can also add SVG for group ranks. <strong>ACP &#187; Users and Groups &#187; Users &#187; Manage ranks</strong>.</p></div>',
 	'SS_HELPER_NOTY'	                        => 'SiteSplat BBcore does not exist!<br />Download the <a href="https://sitesplat.com" target="_blank">BBcore</a> and copy the BBcore folder into your sitesplat extension folder.',
     'ACP_BBSVG_FORUMS'	                        => 'Forum administration. Select forum and edit to find the custom Forum icons settings',
 	'ACP_BBSVG_FORUMS_EXPLAIN'	                => 'If you need to remove the default gray circle in the forum/topic list you can add the following code to your custom.css:',
```
