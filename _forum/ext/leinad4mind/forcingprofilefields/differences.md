Existem diferencas reais no codigo ou texto. Diferencas de formatacao (espacos, tabs) foram ignoradas abaixo.

```diff
diff --git "[FORUM_EXT]/leinad4mind\\forcingprofilefields/diff_full.tmp" "[FORUM_EXT]/leinad4mind\\forcingprofilefields/diff_full.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/leinad4mind\\forcingprofilefields/diff_full.tmp"
@@ -0,0 +1,97 @@
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\forcingprofilefields/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\forcingprofilefields/diff_full.tmp"
+new file mode 100644
+index 000000000..e69de29bb
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\forcingprofilefields/language/pt_preao/common.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\forcingprofilefields/language/pt_preao/common.php"
+new file mode 100644
+index 000000000..d9a844911
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\forcingprofilefields/language/pt_preao/common.php"
+@@ -0,0 +1,40 @@
++<?php
++
++/**
++ *
++ * Forcing Profile Fields. An extension for the phpBB Forum Software package.
++ *
++ * @copyright (c) 2017, leinad4mind, https://leinad4mind.top/forum
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
++	'UCP_PROFILE_UPDATE' => 'Por favor, atualiza os teus campos de perfil.',
++]);
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\forcingprofilefields/language/pt_preao/info_acp_forcingprofilefields.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\forcingprofilefields/language/pt_preao/info_acp_forcingprofilefields.php"
+new file mode 100644
+index 000000000..b97a600a6
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\forcingprofilefields/language/pt_preao/info_acp_forcingprofilefields.php"
+@@ -0,0 +1,42 @@
++<?php
++
++/**
++ *
++ * Forcing Profile Fields. An extension for the phpBB Forum Software package.
++ *
++ * @copyright (c) 2017, leinad4mind, https://leinad4mind.top/forum
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
++	'FORCINGPROFILEFIELDS_SKIP_METAREFRESH'			=> 'Omitir mensagem meta-refresh quando se redireciona o utilizador para o mesmo atualizar o seu perfil',
++	'FORCINGPROFILEFIELDS_SKIP_METAREFRESH_EXPLAIN'	=> 'Caso coloque sim, o utilizador será automaticamente enviado para a página de edição de perfil do UCP sem mostrar previamente uma página de redirecionamento.',
++	'FORCINGPROFILEFIELDS_ENABLE_NOTICE'			=> '<div style="margin:20px"><p>A configuração desta extensão encontra-se em <strong>%1$s</strong> » <strong>%2$s</strong> » <strong>%3$s</strong>.</p></div>',
++]);
diff --git "[FORUM_EXT]/leinad4mind\\forcingprofilefields/diff_nospace.tmp" "[FORUM_EXT]/leinad4mind\\forcingprofilefields/diff_nospace.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/leinad4mind\\forcingprofilefields/diff_nospace.tmp"
@@ -0,0 +1,95 @@
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\forcingprofilefields/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\forcingprofilefields/diff_full.tmp"
+new file mode 100644
+index 000000000..a0ef01463
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\forcingprofilefields/diff_full.tmp"
+@@ -0,0 +1,97 @@
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\forcingprofilefields/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\forcingprofilefields/diff_full.tmp"
++new file mode 100644
++index 000000000..e69de29bb
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\forcingprofilefields/language/pt_preao/common.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\forcingprofilefields/language/pt_preao/common.php"
++new file mode 100644
++index 000000000..d9a844911
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\forcingprofilefields/language/pt_preao/common.php"
++@@ -0,0 +1,40 @@
+++<?php
+++
+++/**
+++ *
+++ * Forcing Profile Fields. An extension for the phpBB Forum Software package.
+++ *
+++ * @copyright (c) 2017, leinad4mind, https://leinad4mind.top/forum
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
+++	'UCP_PROFILE_UPDATE' => 'Por favor, atualiza os teus campos de perfil.',
+++]);
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\forcingprofilefields/language/pt_preao/info_acp_forcingprofilefields.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\forcingprofilefields/language/pt_preao/info_acp_forcingprofilefields.php"
++new file mode 100644
++index 000000000..b97a600a6
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\forcingprofilefields/language/pt_preao/info_acp_forcingprofilefields.php"
++@@ -0,0 +1,42 @@
+++<?php
+++
+++/**
+++ *
+++ * Forcing Profile Fields. An extension for the phpBB Forum Software package.
+++ *
+++ * @copyright (c) 2017, leinad4mind, https://leinad4mind.top/forum
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
+++// Some cha
\ No newline at end of file
diff --git "[FORUM_EXT]/leinad4mind\\forcingprofilefields/language/pt_preao/common.php" "[FORUM_EXT]/leinad4mind\\forcingprofilefields/language/pt_preao/common.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/leinad4mind\\forcingprofilefields/language/pt_preao/common.php"
@@ -0,0 +1,40 @@
+<?php
+
+/**
+ *
+ * Forcing Profile Fields. An extension for the phpBB Forum Software package.
+ *
+ * @copyright (c) 2017, leinad4mind, https://leinad4mind.top/forum
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
+	'UCP_PROFILE_UPDATE' => 'Por favor, atualiza os teus campos de perfil.',
+]);
diff --git "[FORUM_EXT]/leinad4mind\\forcingprofilefields/language/pt_preao/info_acp_forcingprofilefields.php" "[FORUM_EXT]/leinad4mind\\forcingprofilefields/language/pt_preao/info_acp_forcingprofilefields.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/leinad4mind\\forcingprofilefields/language/pt_preao/info_acp_forcingprofilefields.php"
@@ -0,0 +1,42 @@
+<?php
+
+/**
+ *
+ * Forcing Profile Fields. An extension for the phpBB Forum Software package.
+ *
+ * @copyright (c) 2017, leinad4mind, https://leinad4mind.top/forum
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
+	'FORCINGPROFILEFIELDS_SKIP_METAREFRESH'			=> 'Omitir mensagem meta-refresh quando se redireciona o utilizador para o mesmo atualizar o seu perfil',
+	'FORCINGPROFILEFIELDS_SKIP_METAREFRESH_EXPLAIN'	=> 'Caso coloque sim, o utilizador será automaticamente enviado para a página de edição de perfil do UCP sem mostrar previamente uma página de redirecionamento.',
+	'FORCINGPROFILEFIELDS_ENABLE_NOTICE'			=> '<div style="margin:20px"><p>A configuração desta extensão encontra-se em <strong>%1$s</strong> » <strong>%2$s</strong> » <strong>%3$s</strong>.</p></div>',
+]);
```
