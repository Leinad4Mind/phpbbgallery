Existem diferencas reais no codigo ou texto. Diferencas de formatacao (espacos, tabs) foram ignoradas abaixo.

```diff
diff --git "[FORUM_EXT]/lmdi\\mytop/diff_full.tmp" "[FORUM_EXT]/lmdi\\mytop/diff_full.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/lmdi\\mytop/diff_full.tmp"
@@ -0,0 +1,124 @@
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lmdi\\mytop/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lmdi\\mytop/diff_full.tmp"
+new file mode 100644
+index 000000000..e69de29bb
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lmdi\\mytop/language/fr/mytop.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lmdi\\mytop/language/fr/mytop.php"
+deleted file mode 100644
+index 022c0deb7..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lmdi\\mytop/language/fr/mytop.php"
++++ /dev/null
+@@ -1,35 +0,0 @@
+-<?php
+-/**
+-*
+-* @package phpBB Extension - LMDI My Topics
+-* @copyright (c) 2015-2017 Pierre Duhem — LMDI
+-* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+-*
+-*/
+-
+-if (!defined('IN_PHPBB'))
+-{
+-	exit;
+-}
+-
+-if (empty($lang) || !is_array($lang))
+-{
+-	$lang = array();
+-}
+-
+-// Some characters you may want to copy&paste:
+-// ’ » “ ” …
+-
+-
+-$lang = array_merge($lang, array(
+-	'ACP_MYTOP_TITLE'		=> 'Mes sujets',
+-	'ACP_MYTOP_CONFIG'		=> 'Configuration de l’extension',
+-	'ACP_MYTOP_UPDATED'		=> 'La configuration a bien été mise à jour.',
+-	'ACP_MYTOP_TOP'		=> 'Haut',
+-	'ACP_MYTOP_BOTTOM'		=> 'Bas',
+-	'MY_TOPICS'			=> 'Mes sujets',
+-	'MYTOP_POS'			=> 'Rubrique « Mes sujets » en haut du menu',
+-	'MYTOP_POS_EXPLAIN'		=> 'Sélectionnez « Haut » pour insérer le nouveau menu en haut du menu « Accès rapide ». Sélectionnez « Bas » pour le mettre à la fin.',
+-	'MYPOST_NO'			=> 'Masquage de la rubrique « Mes messages »',
+-	'MYPOST_NO_EXPLAIN'		=> 'Vous pouvez souhaiter masquer la rubrique « Mes messages » dans le menu « Accès rapide », dans la mesure où les deux rubriques ont une utilisation très proche.',
+-));
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lmdi\\mytop/language/pt/mytop.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lmdi\\mytop/language/pt/mytop.php"
+new file mode 100644
+index 000000000..9bb38e65e
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lmdi\\mytop/language/pt/mytop.php"
+@@ -0,0 +1,34 @@
++<?php
++/**
++*
++* @package phpBB Extension - LMDI My Topics
++* @copyright (c) 2015-2017 Pierre Duhem - LMDI
++* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
++* Brazilian Portuguese translation by eunaumtenhoid (c) 2019 [ver 1.0.12] (https://github.com/phpBBTraducoes)
++*/
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
++// Some characters you may want to copy&paste:
++// ’ » “ ” …
++
++$lang = array_merge($lang, array(
++	'ACP_MYTOP_TITLE'		=> 'Os Meus Tópicos',
++	'ACP_MYTOP_CONFIG'		=> 'Configurações da Extensão',
++	'ACP_MYTOP_UPDATED'		=> 'A configuração foi atualizada com sucesso.',
++	'ACP_MYTOP_TOP'		=> 'Topo',
++	'ACP_MYTOP_BOTTOM'		=> 'Inferior',
++	'MY_TOPICS'			=> 'Os Meus Tópicos',
++	'MYTOP_POS'			=> '“Os Meus Tópicos” como primeiro item',
++	'MYTOP_POS_EXPLAIN'		=> 'Selecione "Topo" para colocar o novo item de menu no início do menu suspenso "Links rápidos". Selecione "Inferior" para colocá-lo no final.',
++	'MYPOST_NO'			=> 'Ocultar o item “As Minhas Mensagens”',
++	'MYPOST_NO_EXPLAIN'		=> 'Pode querer ocultar o item “As Minhas Mensagens” no menu “Links Rápidos”, já que ambos os itens do menu são realmente similares.',
++));
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lmdi\\mytop/language/pt_preao/mytop.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lmdi\\mytop/language/pt_preao/mytop.php"
+new file mode 100644
+index 000000000..9bb38e65e
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lmdi\\mytop/language/pt_preao/mytop.php"
+@@ -0,0 +1,34 @@
++<?php
++/**
++*
++* @package phpBB Extension - LMDI My Topics
++* @copyright (c) 2015-2017 Pierre Duhem - LMDI
++* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
++* Brazilian Portuguese translation by eunaumtenhoid (c) 2019 [ver 1.0.12] (https://github.com/phpBBTraducoes)
++*/
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
++// Some characters you may want to copy&paste:
++// ’ » “ ” …
++
++$lang = array_merge($lang, array(
++	'ACP_MYTOP_TITLE'		=> 'Os Meus Tópicos',
++	'ACP_MYTOP_CONFIG'		=> 'Configurações da Extensão',
++	'ACP_MYTOP_UPDATED'		=> 'A configuração foi atualizada com sucesso.',
++	'ACP_MYTOP_TOP'		=> 'Topo',
++	'ACP_MYTOP_BOTTOM'		=> 'Inferior',
++	'MY_TOPICS'			=> 'Os Meus Tópicos',
++	'MYTOP_POS'			=> '“Os Meus Tópicos” como primeiro item',
++	'MYTOP_POS_EXPLAIN'		=> 'Selecione "Topo" para colocar o novo item de menu no início do menu suspenso "Links rápidos". Selecione "Inferior" para colocá-lo no final.',
++	'MYPOST_NO'			=> 'Ocultar o item “As Minhas Mensagens”',
++	'MYPOST_NO_EXPLAIN'		=> 'Pode querer ocultar o item “As Minhas Mensagens” no menu “Links Rápidos”, já que ambos os itens do menu são realmente similares.',
++));
diff --git "[FORUM_EXT]/lmdi\\mytop/diff_nospace.tmp" "[FORUM_EXT]/lmdi\\mytop/diff_nospace.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/lmdi\\mytop/diff_nospace.tmp"
@@ -0,0 +1,91 @@
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lmdi\\mytop/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lmdi\\mytop/diff_full.tmp"
+new file mode 100644
+index 000000000..2767ce87e
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lmdi\\mytop/diff_full.tmp"
+@@ -0,0 +1,124 @@
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lmdi\\mytop/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lmdi\\mytop/diff_full.tmp"
++new file mode 100644
++index 000000000..e69de29bb
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lmdi\\mytop/language/fr/mytop.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lmdi\\mytop/language/fr/mytop.php"
++deleted file mode 100644
++index 022c0deb7..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lmdi\\mytop/language/fr/mytop.php"
+++++ /dev/null
++@@ -1,35 +0,0 @@
++-<?php
++-/**
++-*
++-* @package phpBB Extension - LMDI My Topics
++-* @copyright (c) 2015-2017 Pierre Duhem — LMDI
++-* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
++-*
++-*/
++-
++-if (!defined('IN_PHPBB'))
++-{
++-	exit;
++-}
++-
++-if (empty($lang) || !is_array($lang))
++-{
++-	$lang = array();
++-}
++-
++-// Some characters you may want to copy&paste:
++-// ’ » “ ” …
++-
++-
++-$lang = array_merge($lang, array(
++-	'ACP_MYTOP_TITLE'		=> 'Mes sujets',
++-	'ACP_MYTOP_CONFIG'		=> 'Configuration de l’extension',
++-	'ACP_MYTOP_UPDATED'		=> 'La configuration a bien été mise à jour.',
++-	'ACP_MYTOP_TOP'		=> 'Haut',
++-	'ACP_MYTOP_BOTTOM'		=> 'Bas',
++-	'MY_TOPICS'			=> 'Mes sujets',
++-	'MYTOP_POS'			=> 'Rubrique « Mes sujets » en haut du menu',
++-	'MYTOP_POS_EXPLAIN'		=> 'Sélectionnez « Haut » pour insérer le nouveau menu en haut du menu « Accès rapide ». Sélectionnez « Bas » pour le mettre à la fin.',
++-	'MYPOST_NO'			=> 'Masquage de la rubrique « Mes messages »',
++-	'MYPOST_NO_EXPLAIN'		=> 'Vous pouvez souhaiter masquer la rubrique « Mes messages » dans le menu « Accès rapide », dans la mesure où les deux rubriques ont une utilisation très proche.',
++-));
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lmdi\\mytop/language/pt/mytop.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lmdi\\mytop/language/pt/mytop.php"
++new file mode 100644
++index 000000000..9bb38e65e
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lmdi\\mytop/language/pt/mytop.php"
++@@ -0,0 +1,34 @@
+++<?php
+++/**
+++*
+++* @package phpBB Extension - LMDI My Topics
+++* @copyright (c) 2015-2017 Pierre Duhem - LMDI
+++* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+++* Brazilian Portuguese translation by eunaumtenhoid (c) 2019 [ver 1.0.12] (https://github.com/phpBBTraducoes)
+++*/
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
+++// Some characters you may want to copy&paste:
+++// ’ » “ ” …
+++
+++$lang = array_merge($lang, array(
+++	'ACP_MYTOP_TITLE'		=> 'Os Meus Tópicos',
+++	'ACP_MYTOP_CONFIG'		=> 'Configurações da Extensão',
+++	'ACP_MYTOP_UPDATED'		=> 'A configuração foi atualizada com sucesso.',
+++	'ACP_MYTOP_TOP'		=> 'Topo',
+++	'ACP_MYTOP_BOTTOM'		=> 'Inferior',
+++	'MY_TOPICS'			=> 'Os Meus Tópicos',
+++	'MYTOP_POS'			=> '“Os Meus Tópicos” como primeiro item',
+++	'MYTOP_POS_EXPLAIN'		=> 'Selecione "Topo" para colocar o novo item de menu no início do menu suspenso "Links rápidos". Selecione "Inferior" para colocá-lo no final.',
+++	'MYPOST_NO'			=> 'Ocultar o item “As Minhas Mensagens”',
+++	'MYPOST_NO_EXPLAIN'		=> 'Pode querer ocultar o item “As Minhas Mensagens” no menu “Links Rápidos”, já que ambos os itens do menu são realmente similares.',
+++));
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\G
\ No newline at end of file
diff --git "[ORIGINAL]/lmdi\\mytop/language/fr/mytop.php" "[ORIGINAL]/lmdi\\mytop/language/fr/mytop.php"
deleted file mode 100644
--- "[ORIGINAL]/lmdi\\mytop/language/fr/mytop.php"
+++ /dev/null
@@ -1,35 +0,0 @@
-<?php
-/**
-*
-* @package phpBB Extension - LMDI My Topics
-* @copyright (c) 2015-2017 Pierre Duhem — LMDI
-* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
-*
-*/
-
-if (!defined('IN_PHPBB'))
-{
-	exit;
-}
-
-if (empty($lang) || !is_array($lang))
-{
-	$lang = array();
-}
-
-// Some characters you may want to copy&paste:
-// ’ » “ ” …
-
-
-$lang = array_merge($lang, array(
-	'ACP_MYTOP_TITLE'		=> 'Mes sujets',
-	'ACP_MYTOP_CONFIG'		=> 'Configuration de l’extension',
-	'ACP_MYTOP_UPDATED'		=> 'La configuration a bien été mise à jour.',
-	'ACP_MYTOP_TOP'		=> 'Haut',
-	'ACP_MYTOP_BOTTOM'		=> 'Bas',
-	'MY_TOPICS'			=> 'Mes sujets',
-	'MYTOP_POS'			=> 'Rubrique « Mes sujets » en haut du menu',
-	'MYTOP_POS_EXPLAIN'		=> 'Sélectionnez « Haut » pour insérer le nouveau menu en haut du menu « Accès rapide ». Sélectionnez « Bas » pour le mettre à la fin.',
-	'MYPOST_NO'			=> 'Masquage de la rubrique « Mes messages »',
-	'MYPOST_NO_EXPLAIN'		=> 'Vous pouvez souhaiter masquer la rubrique « Mes messages » dans le menu « Accès rapide », dans la mesure où les deux rubriques ont une utilisation très proche.',
-));
diff --git "[FORUM_EXT]/lmdi\\mytop/language/pt/mytop.php" "[FORUM_EXT]/lmdi\\mytop/language/pt/mytop.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/lmdi\\mytop/language/pt/mytop.php"
@@ -0,0 +1,34 @@
+<?php
+/**
+*
+* @package phpBB Extension - LMDI My Topics
+* @copyright (c) 2015-2017 Pierre Duhem - LMDI
+* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+* Brazilian Portuguese translation by eunaumtenhoid (c) 2019 [ver 1.0.12] (https://github.com/phpBBTraducoes)
+*/
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
+// Some characters you may want to copy&paste:
+// ’ » “ ” …
+
+$lang = array_merge($lang, array(
+	'ACP_MYTOP_TITLE'		=> 'Os Meus Tópicos',
+	'ACP_MYTOP_CONFIG'		=> 'Configurações da Extensão',
+	'ACP_MYTOP_UPDATED'		=> 'A configuração foi atualizada com sucesso.',
+	'ACP_MYTOP_TOP'		=> 'Topo',
+	'ACP_MYTOP_BOTTOM'		=> 'Inferior',
+	'MY_TOPICS'			=> 'Os Meus Tópicos',
+	'MYTOP_POS'			=> '“Os Meus Tópicos” como primeiro item',
+	'MYTOP_POS_EXPLAIN'		=> 'Selecione "Topo" para colocar o novo item de menu no início do menu suspenso "Links rápidos". Selecione "Inferior" para colocá-lo no final.',
+	'MYPOST_NO'			=> 'Ocultar o item “As Minhas Mensagens”',
+	'MYPOST_NO_EXPLAIN'		=> 'Pode querer ocultar o item “As Minhas Mensagens” no menu “Links Rápidos”, já que ambos os itens do menu são realmente similares.',
+));
diff --git "[FORUM_EXT]/lmdi\\mytop/language/pt_preao/mytop.php" "[FORUM_EXT]/lmdi\\mytop/language/pt_preao/mytop.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/lmdi\\mytop/language/pt_preao/mytop.php"
@@ -0,0 +1,34 @@
+<?php
+/**
+*
+* @package phpBB Extension - LMDI My Topics
+* @copyright (c) 2015-2017 Pierre Duhem - LMDI
+* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+* Brazilian Portuguese translation by eunaumtenhoid (c) 2019 [ver 1.0.12] (https://github.com/phpBBTraducoes)
+*/
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
+// Some characters you may want to copy&paste:
+// ’ » “ ” …
+
+$lang = array_merge($lang, array(
+	'ACP_MYTOP_TITLE'		=> 'Os Meus Tópicos',
+	'ACP_MYTOP_CONFIG'		=> 'Configurações da Extensão',
+	'ACP_MYTOP_UPDATED'		=> 'A configuração foi atualizada com sucesso.',
+	'ACP_MYTOP_TOP'		=> 'Topo',
+	'ACP_MYTOP_BOTTOM'		=> 'Inferior',
+	'MY_TOPICS'			=> 'Os Meus Tópicos',
+	'MYTOP_POS'			=> '“Os Meus Tópicos” como primeiro item',
+	'MYTOP_POS_EXPLAIN'		=> 'Selecione "Topo" para colocar o novo item de menu no início do menu suspenso "Links rápidos". Selecione "Inferior" para colocá-lo no final.',
+	'MYPOST_NO'			=> 'Ocultar o item “As Minhas Mensagens”',
+	'MYPOST_NO_EXPLAIN'		=> 'Pode querer ocultar o item “As Minhas Mensagens” no menu “Links Rápidos”, já que ambos os itens do menu são realmente similares.',
+));
```
