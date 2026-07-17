Existem diferencas reais no codigo ou texto. Diferencas de formatacao (espacos, tabs) foram ignoradas abaixo.

```diff
diff --git "[FORUM_EXT]/senky\\massnotification/diff_full.tmp" "[FORUM_EXT]/senky\\massnotification/diff_full.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/senky\\massnotification/diff_full.tmp"
@@ -0,0 +1,155 @@
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\senky\\massnotification/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\senky\\massnotification/diff_full.tmp"
+new file mode 100644
+index 000000000..e69de29bb
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\senky\\massnotification/language/pt/acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\senky\\massnotification/language/pt/acp.php"
+new file mode 100644
+index 000000000..4ebaecd53
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\senky\\massnotification/language/pt/acp.php"
+@@ -0,0 +1,41 @@
++<?php
++/**
++ *
++ * Mass Notification. An extension for the phpBB Forum Software package.
++ *
++ * @copyright (c) 2019, Jakub Senko
++ * @license GNU General Public License, version 2 (GPL-2.0)
++ * Brazilian Portuguese translation by eunaumtenhoid [2019][ver 1.0.2] (https://github.com/phpBBTraducoes)
++ */
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
++	'MASSNOTIFICATION_DESC'	=> 'Podes enviar uma notificação do fórum para todos os teus utilizadores ou grupos específicos.',
++
++	'COMPOSE'				=> 'Compor notificação em massa',
++	'ALL_USERS'				=> 'Todos os utilizadores',
++	'SEND_TO_GROUP'			=> 'Enviar para grupo',
++	'SEND_TO_USERS'			=> 'Enviar para utilizadores',
++	'SEND_TO_USERS_EXPLAIN'	=> 'Escrevendo nome de utilizador aqui substituirá qualquer grupo selecionado acima. Insira cada nome de utilizador numa nova linha.',
++	'TITLE'					=> 'Título da notificação',
++	'MESSAGE_EXPLAIN'		=> 'Mensagem curta, de preferência abaixo de 150 caracteres. Podes usar HTML.',
++	'URL'					=> 'URL de redirecionamento',
++	'URL_EXPLAIN'			=> 'Insere o URL para o qual o utilizador será redirecionado depois de clicar na notificação.',
++	'AUTHOR_EXPLAIN'		=> 'Insere o autor da notificação. Deixe em branco para notificação genérica sem autor.',
++	'SEND_NOTIFICATION'		=> 'Enviar notificação',
++
++	'NO_NOTIFICATION_TITLE'		=> 'Precisas especificar o título da notificação.',
++	'NO_NOTIFICATION_MESSAGE'	=> 'Precisas especificar uma mensagem de notificação.',
++	'NO_NOTIFICATION_AUTHOR'	=> 'Autor não existe.',
++
++	'NOTIFICATION_SEND'	=> 'A tua notificação foi enviada.',
++));
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\senky\\massnotification/language/pt/info_acp_demo.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\senky\\massnotification/language/pt/info_acp_demo.php"
+new file mode 100644
+index 000000000..d903ef9c8
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\senky\\massnotification/language/pt/info_acp_demo.php"
+@@ -0,0 +1,23 @@
++<?php
++/**
++ *
++ * Mass Notification. An extension for the phpBB Forum Software package.
++ *
++ * @copyright (c) 2019, Jakub Senko
++ * @license GNU General Public License, version 2 (GPL-2.0)
++ * Brazilian Portuguese translation by eunaumtenhoid (c) 2019 [ver 1.0.0] (https://github.com/phpBBTraducoes)
++ */
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
++	'ACP_SENKY_MASSNOTIFICATION_TITLE'	=> 'Notificação em massa',
++));
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\senky\\massnotification/language/pt_preao/acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\senky\\massnotification/language/pt_preao/acp.php"
+new file mode 100644
+index 000000000..4ebaecd53
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\senky\\massnotification/language/pt_preao/acp.php"
+@@ -0,0 +1,41 @@
++<?php
++/**
++ *
++ * Mass Notification. An extension for the phpBB Forum Software package.
++ *
++ * @copyright (c) 2019, Jakub Senko
++ * @license GNU General Public License, version 2 (GPL-2.0)
++ * Brazilian Portuguese translation by eunaumtenhoid [2019][ver 1.0.2] (https://github.com/phpBBTraducoes)
++ */
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
++	'MASSNOTIFICATION_DESC'	=> 'Podes enviar uma notificação do fórum para todos os teus utilizadores ou grupos específicos.',
++
++	'COMPOSE'				=> 'Compor notificação em massa',
++	'ALL_USERS'				=> 'Todos os utilizadores',
++	'SEND_TO_GROUP'			=> 'Enviar para grupo',
++	'SEND_TO_USERS'			=> 'Enviar para utilizadores',
++	'SEND_TO_USERS_EXPLAIN'	=> 'Escrevendo nome de utilizador aqui substituirá qualquer grupo selecionado acima. Insira cada nome de utilizador numa nova linha.',
++	'TITLE'					=> 'Título da notificação',
++	'MESSAGE_EXPLAIN'		=> 'Mensagem curta, de preferência abaixo de 150 caracteres. Podes usar HTML.',
++	'URL'					=> 'URL de redirecionamento',
++	'URL_EXPLAIN'			=> 'Insere o URL para o qual o utilizador será redirecionado depois de clicar na notificação.',
++	'AUTHOR_EXPLAIN'		=> 'Insere o autor da notificação. Deixe em branco para notificação genérica sem autor.',
++	'SEND_NOTIFICATION'		=> 'Enviar notificação',
++
++	'NO_NOTIFICATION_TITLE'		=> 'Precisas especificar o título da notificação.',
++	'NO_NOTIFICATION_MESSAGE'	=> 'Precisas especificar uma mensagem de notificação.',
++	'NO_NOTIFICATION_AUTHOR'	=> 'Autor não existe.',
++
++	'NOTIFICATION_SEND'	=> 'A tua notificação foi enviada.',
++));
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\senky\\massnotification/language/pt_preao/info_acp_demo.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\senky\\massnotification/language/pt_preao/info_acp_demo.php"
+new file mode 100644
+index 000000000..d903ef9c8
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\senky\\massnotification/language/pt_preao/info_acp_demo.php"
+@@ -0,0 +1,23 @@
++<?php
++/**
++ *
++ * Mass Notification. An extension for the phpBB Forum Software package.
++ *
++ * @copyright (c) 2019, Jakub Senko
++ * @license GNU General Public License, version 2 (GPL-2.0)
++ * Brazilian Portuguese translation by eunaumtenhoid (c) 2019 [ver 1.0.0] (https://github.com/phpBBTraducoes)
++ */
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
++	'ACP_SENKY_MASSNOTIFICATION_TITLE'	=> 'Notificação em massa',
++));
diff --git "[FORUM_EXT]/senky\\massnotification/diff_nospace.tmp" "[FORUM_EXT]/senky\\massnotification/diff_nospace.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/senky\\massnotification/diff_nospace.tmp"
@@ -0,0 +1,86 @@
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\senky\\massnotification/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\senky\\massnotification/diff_full.tmp"
+new file mode 100644
+index 000000000..1e3d8f6a4
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\senky\\massnotification/diff_full.tmp"
+@@ -0,0 +1,155 @@
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\senky\\massnotification/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\senky\\massnotification/diff_full.tmp"
++new file mode 100644
++index 000000000..e69de29bb
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\senky\\massnotification/language/pt/acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\senky\\massnotification/language/pt/acp.php"
++new file mode 100644
++index 000000000..4ebaecd53
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\senky\\massnotification/language/pt/acp.php"
++@@ -0,0 +1,41 @@
+++<?php
+++/**
+++ *
+++ * Mass Notification. An extension for the phpBB Forum Software package.
+++ *
+++ * @copyright (c) 2019, Jakub Senko
+++ * @license GNU General Public License, version 2 (GPL-2.0)
+++ * Brazilian Portuguese translation by eunaumtenhoid [2019][ver 1.0.2] (https://github.com/phpBBTraducoes)
+++ */
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
+++	'MASSNOTIFICATION_DESC'	=> 'Podes enviar uma notificação do fórum para todos os teus utilizadores ou grupos específicos.',
+++
+++	'COMPOSE'				=> 'Compor notificação em massa',
+++	'ALL_USERS'				=> 'Todos os utilizadores',
+++	'SEND_TO_GROUP'			=> 'Enviar para grupo',
+++	'SEND_TO_USERS'			=> 'Enviar para utilizadores',
+++	'SEND_TO_USERS_EXPLAIN'	=> 'Escrevendo nome de utilizador aqui substituirá qualquer grupo selecionado acima. Insira cada nome de utilizador numa nova linha.',
+++	'TITLE'					=> 'Título da notificação',
+++	'MESSAGE_EXPLAIN'		=> 'Mensagem curta, de preferência abaixo de 150 caracteres. Podes usar HTML.',
+++	'URL'					=> 'URL de redirecionamento',
+++	'URL_EXPLAIN'			=> 'Insere o URL para o qual o utilizador será redirecionado depois de clicar na notificação.',
+++	'AUTHOR_EXPLAIN'		=> 'Insere o autor da notificação. Deixe em branco para notificação genérica sem autor.',
+++	'SEND_NOTIFICATION'		=> 'Enviar notificação',
+++
+++	'NO_NOTIFICATION_TITLE'		=> 'Precisas especificar o título da notificação.',
+++	'NO_NOTIFICATION_MESSAGE'	=> 'Precisas especificar uma mensagem de notificação.',
+++	'NO_NOTIFICATION_AUTHOR'	=> 'Autor não existe.',
+++
+++	'NOTIFICATION_SEND'	=> 'A tua notificação foi enviada.',
+++));
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\senky\\massnotification/language/pt/info_acp_demo.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\senky\\massnotification/language/pt/info_acp_demo.php"
++new file mode 100644
++index 000000000..d903ef9c8
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\senky\\massnotification/language/pt/info_acp_demo.php"
++@@ -0,0 +1,23 @@
+++<?php
+++/**
+++ *
+++ * Mass Notification. An extension for the phpBB Forum Software package.
+++ *
+++ * @copyright (c) 2019, Jakub Senko
+++ * @license GNU General Public License, version 2 (GPL-2.0)
+++ * Brazilian Portuguese translation by eunaumtenhoid (c) 2019 [ver 1.0.0] (https://github.com/phpBBTraducoes)
+++ */
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
+++	'ACP_SENKY_MASSNOTIFICATION_TITLE'	=> 'Notificação em massa',
+++));
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\senky\\massnotification/language/pt_preao/acp.p
\ No newline at end of file
diff --git "[FORUM_EXT]/senky\\massnotification/language/pt/acp.php" "[FORUM_EXT]/senky\\massnotification/language/pt/acp.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/senky\\massnotification/language/pt/acp.php"
@@ -0,0 +1,41 @@
+<?php
+/**
+ *
+ * Mass Notification. An extension for the phpBB Forum Software package.
+ *
+ * @copyright (c) 2019, Jakub Senko
+ * @license GNU General Public License, version 2 (GPL-2.0)
+ * Brazilian Portuguese translation by eunaumtenhoid [2019][ver 1.0.2] (https://github.com/phpBBTraducoes)
+ */
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
+	'MASSNOTIFICATION_DESC'	=> 'Podes enviar uma notificação do fórum para todos os teus utilizadores ou grupos específicos.',
+
+	'COMPOSE'				=> 'Compor notificação em massa',
+	'ALL_USERS'				=> 'Todos os utilizadores',
+	'SEND_TO_GROUP'			=> 'Enviar para grupo',
+	'SEND_TO_USERS'			=> 'Enviar para utilizadores',
+	'SEND_TO_USERS_EXPLAIN'	=> 'Escrevendo nome de utilizador aqui substituirá qualquer grupo selecionado acima. Insira cada nome de utilizador numa nova linha.',
+	'TITLE'					=> 'Título da notificação',
+	'MESSAGE_EXPLAIN'		=> 'Mensagem curta, de preferência abaixo de 150 caracteres. Podes usar HTML.',
+	'URL'					=> 'URL de redirecionamento',
+	'URL_EXPLAIN'			=> 'Insere o URL para o qual o utilizador será redirecionado depois de clicar na notificação.',
+	'AUTHOR_EXPLAIN'		=> 'Insere o autor da notificação. Deixe em branco para notificação genérica sem autor.',
+	'SEND_NOTIFICATION'		=> 'Enviar notificação',
+
+	'NO_NOTIFICATION_TITLE'		=> 'Precisas especificar o título da notificação.',
+	'NO_NOTIFICATION_MESSAGE'	=> 'Precisas especificar uma mensagem de notificação.',
+	'NO_NOTIFICATION_AUTHOR'	=> 'Autor não existe.',
+
+	'NOTIFICATION_SEND'	=> 'A tua notificação foi enviada.',
+));
diff --git "[FORUM_EXT]/senky\\massnotification/language/pt/info_acp_demo.php" "[FORUM_EXT]/senky\\massnotification/language/pt/info_acp_demo.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/senky\\massnotification/language/pt/info_acp_demo.php"
@@ -0,0 +1,23 @@
+<?php
+/**
+ *
+ * Mass Notification. An extension for the phpBB Forum Software package.
+ *
+ * @copyright (c) 2019, Jakub Senko
+ * @license GNU General Public License, version 2 (GPL-2.0)
+ * Brazilian Portuguese translation by eunaumtenhoid (c) 2019 [ver 1.0.0] (https://github.com/phpBBTraducoes)
+ */
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
+	'ACP_SENKY_MASSNOTIFICATION_TITLE'	=> 'Notificação em massa',
+));
diff --git "[FORUM_EXT]/senky\\massnotification/language/pt_preao/acp.php" "[FORUM_EXT]/senky\\massnotification/language/pt_preao/acp.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/senky\\massnotification/language/pt_preao/acp.php"
@@ -0,0 +1,41 @@
+<?php
+/**
+ *
+ * Mass Notification. An extension for the phpBB Forum Software package.
+ *
+ * @copyright (c) 2019, Jakub Senko
+ * @license GNU General Public License, version 2 (GPL-2.0)
+ * Brazilian Portuguese translation by eunaumtenhoid [2019][ver 1.0.2] (https://github.com/phpBBTraducoes)
+ */
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
+	'MASSNOTIFICATION_DESC'	=> 'Podes enviar uma notificação do fórum para todos os teus utilizadores ou grupos específicos.',
+
+	'COMPOSE'				=> 'Compor notificação em massa',
+	'ALL_USERS'				=> 'Todos os utilizadores',
+	'SEND_TO_GROUP'			=> 'Enviar para grupo',
+	'SEND_TO_USERS'			=> 'Enviar para utilizadores',
+	'SEND_TO_USERS_EXPLAIN'	=> 'Escrevendo nome de utilizador aqui substituirá qualquer grupo selecionado acima. Insira cada nome de utilizador numa nova linha.',
+	'TITLE'					=> 'Título da notificação',
+	'MESSAGE_EXPLAIN'		=> 'Mensagem curta, de preferência abaixo de 150 caracteres. Podes usar HTML.',
+	'URL'					=> 'URL de redirecionamento',
+	'URL_EXPLAIN'			=> 'Insere o URL para o qual o utilizador será redirecionado depois de clicar na notificação.',
+	'AUTHOR_EXPLAIN'		=> 'Insere o autor da notificação. Deixe em branco para notificação genérica sem autor.',
+	'SEND_NOTIFICATION'		=> 'Enviar notificação',
+
+	'NO_NOTIFICATION_TITLE'		=> 'Precisas especificar o título da notificação.',
+	'NO_NOTIFICATION_MESSAGE'	=> 'Precisas especificar uma mensagem de notificação.',
+	'NO_NOTIFICATION_AUTHOR'	=> 'Autor não existe.',
+
+	'NOTIFICATION_SEND'	=> 'A tua notificação foi enviada.',
+));
diff --git "[FORUM_EXT]/senky\\massnotification/language/pt_preao/info_acp_demo.php" "[FORUM_EXT]/senky\\massnotification/language/pt_preao/info_acp_demo.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/senky\\massnotification/language/pt_preao/info_acp_demo.php"
@@ -0,0 +1,23 @@
+<?php
+/**
+ *
+ * Mass Notification. An extension for the phpBB Forum Software package.
+ *
+ * @copyright (c) 2019, Jakub Senko
+ * @license GNU General Public License, version 2 (GPL-2.0)
+ * Brazilian Portuguese translation by eunaumtenhoid (c) 2019 [ver 1.0.0] (https://github.com/phpBBTraducoes)
+ */
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
+	'ACP_SENKY_MASSNOTIFICATION_TITLE'	=> 'Notificação em massa',
+));
```
