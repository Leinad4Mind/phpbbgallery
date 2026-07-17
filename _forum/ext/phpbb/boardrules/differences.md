Existem diferencas reais no codigo ou texto. Diferencas de formatacao (espacos, tabs) foram ignoradas abaixo.

```diff
diff --git "[FORUM_EXT]/phpbb\\boardrules/diff_full.tmp" "[FORUM_EXT]/phpbb\\boardrules/diff_full.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/phpbb\\boardrules/diff_full.tmp"
@@ -0,0 +1,877 @@
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/diff_full.tmp"
+new file mode 100644
+index 000000000..e69de29bb
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/language/pt_preao/boardrules_acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/language/pt_preao/boardrules_acp.php"
+new file mode 100644
+index 000000000..9163ea0a1
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/language/pt_preao/boardrules_acp.php"
+@@ -0,0 +1,99 @@
++<?php
++/**
++*
++* Board Rules extension for the phpBB Forum Software package.
++* @Traduzido por: http://phpbbportugal.com - segundo as normas do Acordo Ortográfico
++*
++* @copyright (c) 2014 phpBB Limited <https://www.phpbb.com>
++* @license GNU General Public License, version 2 (GPL-2.0)
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
++$lang = array_merge($lang, array(
++	// Settings page
++	'ACP_BOARDRULES'						=> 'Regras do Fórum',
++	'ACP_BOARDRULES_SETTINGS'				=> 'Configurar regras',
++	'ACP_BOARDRULES_SETTINGS_EXPLAIN'		=> 'Aqui pode configurar as definições principais das regras do Fórum.',
++	'ACP_BOARDRULES_ENABLE'					=> 'Ativar regras',
++	'ACP_BOARDRULES_HEADER_LINK'			=> 'Mostrar link no cabeçalho',
++	'ACP_BOARDRULES_FONT_ICON'				=> 'Board rules link icon',
++	'ACP_BOARDRULES_FONT_ICON_EXPLAIN'		=> 'Enter the name of a <strong><a href="%s" target="_blank">Font Awesome</a></strong> icon to use for the board rules link in the header. Leave this field blank for no board rules icon.',
++	'ACP_BOARDRULES_FONT_ICON_INVALID'		=> 'The board rules link icon contained invalid characters.',
++	'ACP_BOARDRULES_AT_REGISTRATION'		=> 'Exigir aceitação das regras no momento do registo',
++	'ACP_BOARDRULES_AT_REGISTRATION_EXPLAIN'=> 'Acrescenta as Regras do Fórum às "Condições de utilização", permitindo a sua leitura e obrigando à sua aceitação antes do registo.',
++	'ACP_BOARDRULES_NOTIFY'					=> 'Notificar Utilizadores',
++	'ACP_BOARDRULES_NOTIFY_EXPLAIN'			=> 'Enviar uma notificação a todos os utilizadores registrados que as regras da comunidade foram atualizados. (Esta ação pode demorar alguns segundos para ser concluída em Fóruns com muitos milhares de membros.)',
++	'ACP_BOARDRULES_NOTIFY_CONFIRM'			=> 'Tem certeza que deseja enviar notificações a todos os utilizadores?',
++	'ACP_BOARDRULES_SETTINGS_CHANGED'		=> 'A configuração das regras do fórum foi alterada.',
++	'ACP_BOARDRULES_LIST_STYLE'				=> 'Board rules list style',
++	'ACP_BOARDRULES_LIST_STYLE_EXPLAIN'		=> 'Board rules are presented in a list format. Decide if you want rule and category items to be preceded by ordered alpha-numeric ordinals (this is the default behavior), bullets or nothing.',
++	'ACP_BOARDRULES_LIST_STYLE_ORDERED'		=> 'Ordered alpha-numeric',
++	'ACP_BOARDRULES_LIST_STYLE_BULLET'		=> 'Bullet',
++	'ACP_BOARDRULES_LIST_STYLE_NONE'		=> 'None',
++
++	// Manage page
++	'ACP_BOARDRULES_MANAGE'					=> 'Gerir regras',
++	'ACP_BOARDRULES_MANAGE_EXPLAIN'			=> 'Nesta página pode adicionar, editar, apagar e reordenar as categorias e regras. A categoria é um conjunto de regras inter-relacionadas. Cada categoria pode ter um número ilimitado de regras.',
++	'ACP_BOARDRULES_LANGUAGE_EXPLAIN'		=> 'Choose a language for your Board Rules. Users will see the rules you create for their preferred language. If you do not create any rules in their preferred language, then users will see rules created using the board’s default language.',
++	'ACP_BOARDRULES_CATEGORY'				=> 'Categoria de regras',
++	'ACP_BOARDRULES_RULE'					=> 'Regra',
++	'ACP_BOARDRULES_SELECT_LANGUAGE'		=> 'Escolha um idioma',
++	'ACP_BOARDRULES_CREATE_RULE'			=> 'Criar regra',
++	'ACP_BOARDRULES_CREATE_RULE_EXPLAIN'	=> 'Através do formulário abaixo pode criar uma nova regra que será mostrada aos utilizadores.',
++	'ACP_BOARDRULES_EDIT_RULE'				=> 'Editar regra',
++	'ACP_BOARDRULES_EDIT_RULE_EXPLAIN'		=> 'Através do formulário abaixo pode atualizar uma regra que será mostrada aos utilizadores.',
++	'ACP_RULE_SETTINGS'						=> 'Configurar regra',
++	'ACP_RULE_PARENT'						=> 'Regra pai',
++	'ACP_RULE_NO_PARENT'					=> 'Nenhum pai',
++	'ACP_RULE_TITLE'						=> 'Título da regra',
++	'ACP_RULE_TITLE_EXPLAIN'				=> 'Os Títulos das Regras são exibidos na página de regras apenas para categorias de regras. Títulos das regras também são usados para identificar as regras na gestão do ACP.',
++	'ACP_RULE_ANCHOR'						=> 'Regra âncora',
++	'ACP_RULE_ANCHOR_EXPLAIN'				=> 'Âncoras de regras são opcionais e usadas como pontos de ligação de ancoragem na página regras. Devem ser URL amigáveis (não podem conter espaços ou caracteres especiais), devem começar com uma letra, e devem ser exclusivos.',
++	'ACP_RULE_MESSAGE'						=> 'Mensagem da regra',
++	'ACP_RULE_MESSAGE_EXPLAIN'				=> 'A mensagem da regra é exibida na página de regra para cada regra (categorias não exibem mensagens das regras).',
++	'ACP_RULE_MESSAGE_DISABLED'				=> 'Esta é uma categoria que contém regras, o editor mensagem foi desativado.',
++	'ACP_ADD_RULE'							=> 'Criar nova regra',
++	'ACP_DELETE_RULE_CONFIRM'				=> array(
++		0 => 'Tem a certeza que deseja eliminar esta regra?',
++		1 => 'Tem a certeza que deseja eliminar esta categoria de regra?<br />Aviso: Removendo um categoria de regra irá remover todas as regras contidas dentro dela.',
++	),
++	'ACP_RULE_ADDED'						=> 'Regra criada com sucesso.',
++	'ACP_RULE_DELETED'						=> 'Regra eliminada com sucesso.',
++	'ACP_RULE_EDITED'						=> 'Regra editada com sucesso.',
++	'ACP_RULE_TITLE_EMPTY'					=> 'Tem que dar um titulo à regra.',
++
++	// Nested set exception messages (only appears in PHP error logging)
++	// Translators: Feel free to not translate these language strings
++	'RULES_NESTEDSET_LOCK_FAILED_ACQUIRE'	=> 'Board rules failed to acquire the table lock. Another process may be holding the lock. Locks are forcibly released after a timeout of 1 hour.',
++	'RULES_NESTEDSET_INVALID_ITEM'			=> 'The requested rule does not exist.',
++	'RULES_NESTEDSET_INVALID_PARENT'		=> 'The requested rule has no parent.',
++));
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/language/pt_preao/boardrules_common.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/language/pt_preao/boardrules_common.php"
+new file mode 100644
+index 000000000..6020f291b
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/language/pt_preao/boardrules_common.php"
+@@ -0,0 +1,47 @@
++<?php
++/**
++*
++* Board Rules extension for the phpBB Forum Software package.
++* @Traduzido por: http://phpbbportugal.com - segundo as normas do Acordo Ortográfico
++*
++* @copyright (c) 2013 phpBB Limited <https://www.phpbb.com>
++* @license GNU General Public License, version 2 (GPL-2.0)
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
++$lang = array_merge($lang, array(
++	'BOARDRULES'				=> 'Regras',
++	'BOARDRULES_TITLE'			=> 'Ver as regras deste Fórum',
++	'BOARDRULES_AGREEMENT'		=> 'Concorda em respeitar as regras deste fórum estabelecidas na secção “Regras”',
++	'BOARDRULES_VIEWONLINE'		=> 'A ler as regras do Fórum',
++	'BOARDRULES_NOTIFICATION'	=> 'As regras do Fórum foram actualizadas. Clique aqui para as rever.',
++));
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/language/pt_preao/boardrules_controller.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/language/pt_preao/boardrules_controller.php"
+new file mode 100644
+index 000000000..5254f6303
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/language/pt_preao/boardrules_controller.php"
+@@ -0,0 +1,48 @@
++<?php
++/**
++*
++* Board Rules extension for the phpBB Forum Software package.
++* @Traduzido por: http://phpbbportugal.com - segundo as normas do Acordo Ortográfico
++*
++* @copyright (c) 2014 phpBB Limited <https://www.phpbb.com>
++* @license GNU General Public License, version 2 (GPL-2.0)
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
++$lang = array_merge($lang, array(
++	'BOARDRULES_HEADER'			=> 'Regras do Fórum',
++	'BOARDRULES_EXPLAIN'		=> 'Estas regras servem para esclarecer as várias responsabilidades de todos os membros da comunidade %s. Devem ser respeitadas por todos para garantir que o nosso Fórum funciona sem problemas e oferece uma experiência divertida e produtiva para todos os membros da comunidade.',
++	'BOARDRULES_CATEGORIES'		=> 'Secções de Regras',
++	'BOARDRULES_CATEGORY_ANCHOR'=> 'seccao-%s',
++	'BOARDRULES_RULE_ANCHOR'	=> 'regra-%s',
++	'BOARDRULES_REGISTERED'		=> 'Precisa de estar registado para ter acesso às regras',
++));
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/language/pt_preao/boardrules_install.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/language/pt_preao/boardrules_install.php"
+new file mode 100644
+index 000000000..ce4906be1
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/language/pt_preao/boardrules_install.php"
+@@ -0,0 +1,49 @@
++<?php
++/**
++*
++* Board Rules extension for the phpBB Forum Software package.
++* @Traduzido por: http://phpbbportugal.com - segundo as normas do Acordo Ortográfico
++*
++* @copyright (c) 2014 phpBB Limited <https://www.phpbb.com>
++* @license GNU General Public License, version 2 (GPL-2.0)
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
++$lang = array_merge($lang, array(
++	'BOARDRULES_SAMPLE_CATEGORY_TITLE'		=> 'Examplo Regra Categoria',
++	'BOARDRULES_SAMPLE_CATEGORY_MESSAGE'	=> 'Esta é uma categoria de exemplo das Regras do Fórum. Categorias contêm grupos de regras relacionadas. Mensagens Categoria (como esta) não são exibidas na página de regras.',
++	'BOARDRULES_SAMPLE_CATEGORY_ANCHOR'		=> 'examplo-categoria',
++
++	'BOARDRULES_SAMPLE_RULE_TITLE'			=> 'Examplo de Regra',
++	'BOARDRULES_SAMPLE_RULE_MESSAGE'		=> 'Esta é uma Regras de exemplo das Regras do Fórum. Tudo parece funcionar bem. Pode editar ou excluir esta regra e categoria e continuar a configurar suas próprias regras deste Fórum.',
++	'BOARDRULES_SAMPLE_RULE_ANCHOR'			=> 'examplo-regra',
++));
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/language/pt_preao/exceptions.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/language/pt_preao/exceptions.php"
+new file mode 100644
+index 000000000..a3a4a29f3
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/language/pt_preao/exceptions.php"
+@@ -0,0 +1,62 @@
++<?php
++/**
++*
++* Board Rules extension for the phpBB Forum Software package.
++* @Traduzido por: http://phpbbportugal.com - segundo as normas do Acordo Ortográfico
++*
++* @copyright (c) 2014 phpBB Limited <https://www.phpbb.com>
++* @license GNU General Public License, version 2 (GPL-2.0)
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
++/*
++* These are errors which can be triggered by sending invalid data to the
++* boardrules extension API.
++*
++* These errors will never show to a user unless they are either modifying
++* the core boardrules extension code OR unless they are writing an extension
++* which makes calls to this extension.
++*
++* Translators: Feel free to not translate these language strings
++*/
++$lang = array_merge($lang, array(
++	'EXCEPTION_FIELD_MISSING'		=> 'Campo obrigatório em falta',
++	'EXCEPTION_INVALID_ARGUMENT'	=> 'O argumento especificado para `%1$s` é inválido. Razão: %2$s',
++	'EXCEPTION_OUT_OF_BOUNDS'		=> 'O Campo `%1$s` recebeu dados além do limite',
++	'EXCEPTION_TOO_LONG'			=> 'A entrada foi maior do que o máximo permitido.',
++	'EXCEPTION_NOT_UNIQUE'			=> 'A entrada não é única.',
++	'EXCEPTION_UNEXPECTED_VALUE'	=> 'O campo `%1$s` recebeu dados não previstos. Razão: %2$s',
++	'EXCEPTION_ILLEGAL_CHARACTERS'	=> 'A entrada tem caracteres inválidos.',
++
++	// Translators: do not change this
++	'EXCEPTION_WRONG_DATA_LANG'		=> $lang['WRONG_DATA_LANG'],
++));
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/language/pt_preao/info_acp_boardrules.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/language/pt_preao/info_acp_boardrules.php"
+new file mode 100644
+index 000000000..1daddb6d1
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/language/pt_preao/info_acp_boardrules.php"
+@@ -0,0 +1,50 @@
++<?php
++/**
++*
++* Board Rules extension for the phpBB Forum Software package.
++* @Traduzido por: http://phpbbportugal.com - segundo as normas do Acordo Ortográfico
++*
++* @copyright (c) 2014 phpBB Limited <https://www.phpbb.com>
++* @license GNU General Public License, version 2 (GPL-2.0)
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
++$lang = array_merge($lang, array(
++	// ACP modules
++	'ACP_BOARDRULES'				=> 'Regras do Fórum',
++	'ACP_BOARDRULES_MANAGE'			=> 'Gerir regras',
++	'ACP_BOARDRULES_SETTINGS'		=> 'Configurar regras',
++
++	// ACP Logs
++	'ACP_BOARDRULES_SETTINGS_LOG'	=> '<strong>Configurações das regras do fórum foram alteradas</strong>',
++	'ACP_BOARDRULES_NOTIFY_LOG'		=> '<strong>Enviadas notificações das regras a todos os utilizadores</strong>',
++));
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/language/pt_preao/permissions_boardrules.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/language/pt_preao/permissions_boardrules.php"
+new file mode 100644
+index 000000000..95135cda9
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/language/pt_preao/permissions_boardrules.php"
+@@ -0,0 +1,43 @@
++<?php
++/**
++*
++* Board Rules extension for the phpBB Forum Software package.
++* @Traduzido por: http://phpbbportugal.com - segundo as normas do Acordo Ortográfico
++*
++* @copyright (c) 2014 phpBB Limited <https://www.phpbb.com>
++* @license GNU General Public License, version 2 (GPL-2.0)
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
++$lang = array_merge($lang, array(
++	'ACL_A_BOARDRULES'		=> 'Pode administrar as regras do fórum',
++));
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/styles/BBOOTS/template/boardrules_controller.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/styles/BBOOTS/template/boardrules_controller.html"
+new file mode 100644
+index 000000000..e664ff7be
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/styles/BBOOTS/template/boardrules_controller.html"
+@@ -0,0 +1,54 @@
++{% INCLUDECSS '@phpbb_boardrules/boardrules_controller.css' %}
++{% INCLUDE 'overall_header.html' %}
++<div class="row bs-docs-container">
++<div class="col-md-9">
++	<div class="side-segment"><h3>{L_BOARDRULES_HEADER}</h3></div>
++	<div class="content panel">
++	 <div class="panel-body">
++		<p>{BOARDRULES_EXPLAIN}</p>
++		<ol class="boardrules-rules{{ BOARDRULES_LIST_STYLE ? ' br-list-style-' ~ BOARDRULES_LIST_STYLE }}" id="rules">
++			{% for rules in loops.rules %}
++				{% if rules.S_CLOSE_LIST %}
++						</ol>
++					</li>
++				{% elseif rules.S_IS_CATEGORY %}
++					<li id="{{ rules.U_ANCHOR }}">
++						<h3 class="rule-heading">{{ rules.TITLE }}</h3>
++						<ol>
++				{% else %}
++							<li class="rule-item" id="{{ rules.U_ANCHOR }}">
++								{{ rules.MESSAGE }} <a class="rule-anchor postlink" href="#{{ rules.U_ANCHOR }}">&#35;</a>
++							</li>
++				{% endif %}
++			{% endfor %}
++		</ol>
++	 </div>	
++	</div>
++</div>
++
++{% if S_CATEGORIES %}
++<div class="col-md-3 scrollspy hidden-xs hidden-sm">
++ <div class="side-segment"><h3>{{ lang('BOARDRULES_CATEGORIES') }}</h3></div>
++    <div role="complementary" class="bs-sidebar hidden-print">
++		<ul id="nav" class="nav bs-sidenav" data-spy="affix">
++			{% for rules in loops.rules %}
++				{% if rules.S_IS_CATEGORY %}<li><a href="#{{ rules.U_ANCHOR }}">{{ rules.TITLE }}</a></li>{% endif %}
++			{% endfor %}
++		</ul>
++	</div>	
++</div>
++{% endif %}
++
++<script>
++head.ready(function () {
++   $('#nav').affix({
++    offset: {
++        top: $('#nav').offset().top,
++        bottom: $('footer').outerHeight(true) + $('.section-page').outerHeight(true) + 432
++    }
++});
++});
++</script>
++</div>
++{% INCLUDEJS '@phpbb_boardrules/boardrules_controller.js' %}
++{% INCLUDE 'overall_footer.html' %}
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/styles/BBOOTS/template/event/overall_header_navigation_append.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/styles/BBOOTS/template/event/overall_header_navigation_append.html"
+new file mode 100644
+index 000000000..77e2de256
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/styles/BBOOTS/template/event/overall_header_navigation_append.html"
+@@ -0,0 +1,3 @@
++<!-- IF S_BOARDRULES_LINK_ENABLED-->
++	<li class="icon-boardrules"><a href="{U_BOARDRULES}" role="menuitem"><i class="fa fa-book"></i>&nbsp;{L_BOARDRULES}</a><span></span></li>
++<!-- ENDIF -->
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/styles/BBOOTS/template/event/ucp_agreement_terms_before.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/styles/BBOOTS/template/event/ucp_agreement_terms_before.html"
+new file mode 100644
+index 000000000..5cf6f88ad
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/styles/BBOOTS/template/event/ucp_agreement_terms_before.html"
+@@ -0,0 +1,3 @@
++<!-- IF S_BOARDRULES_AT_REGISTRATION and not S_SHOW_COPPA -->
++	<p><strong>&#42;&#42;&#42;&nbsp;</strong>{L_BOARDRULES_AGREEMENT}{L_COLON}&nbsp;<a href="{U_BOARDRULES}" title="{L_BOARDRULES_TITLE}" target="_blank"><strong>{L_BOARDRULES_TITLE}</strong></a></p>
++<!-- ENDIF -->
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/styles/BBOOTS/template/js/boardrules_controller.js" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/styles/BBOOTS/template/js/boardrules_controller.js"
+new file mode 100644
+index 000000000..ea54f45d9
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/styles/BBOOTS/template/js/boardrules_controller.js"
+@@ -0,0 +1,20 @@
++head.ready(function () {
++$(function() {
++
++  'use strict';
++
++	// Function to apply highlight class to an element identifier
++	var highlight = function (id) {
++		$('#' + decodeURIComponent(id)).addClass('bg-info');
++	};
++
++	// Apply highlight to clicked rule anchor
++	$('.rule-anchor').on('click', function () {
++		$('li').removeClass('bg-info');
++		highlight($(this).closest('.rule-item').attr('id'));
++	});
++
++	// Apply highlight on page load to a rule category
++	highlight(window.location.hash.substring(1));
++});
++});
+\ No newline at end of file
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/styles/BBOOTS/theme/boardrules_controller.css" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/styles/BBOOTS/theme/boardrules_controller.css"
+new file mode 100644
+index 000000000..496aedd2e
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/styles/BBOOTS/theme/boardrules_controller.css"
+@@ -0,0 +1,87 @@
++/**
++* Some CSS adapted from phpBB.com rules page
++*/
++
++.bs-sidenav {
++    background-color: #f7f5fa;
++    border-radius: 5px;
++    margin-bottom: 30px;
++    padding-bottom: 10px;
++    padding-top: 10px;
++    text-shadow: 0 1px 0 #fff;
++}
++
++.bs-sidebar .nav > li > a {
++    color: #716b7a;
++    display: block;
++    padding: 5px 20px;
++}
++
++.bs-sidebar .nav > li > a:hover, .bs-sidebar .nav > li > a:focus {
++    background-color: #e5e3e9;
++    border-right: 2px solid #26BCB5;
++    text-decoration: none;
++}
++
++.bs-sidebar .nav > .active > a, .bs-sidebar .nav > .active:hover > a, .bs-sidebar .nav > .active:focus > a {
++    background-color: transparent;
++    border-right: 2px solid #26BCB5;
++    color: #26BCB5;
++    font-weight: bold;
++}
++.bs-sidebar .nav .nav {
++    display: none;
++    margin-bottom: 8px;
++}
++.bs-sidebar .nav .nav > li > a {
++    font-size: 90%;
++    padding-bottom: 3px;
++    padding-left: 30px;
++    padding-top: 3px;
++}
++
++.bs-sidebar.affix-bottom, .bs-sidebar.affix {
++    width: 263px;
++}
++
++.bs-sidebar.affix {
++    position: fixed;
++    top: 0;
++}
++
++.bs-sidebar .nav > .active > ul {
++    display: block;
++}
++.bs-sidebar .nav .nav {
++    display: none;
++    margin-bottom: 8px;
++}
++
++
++.bs-docs-container .affix {
++  top: 20px;
++  width: 213px;
++}
++ 
++@media (min-width: 1200px) {
++  .bs-docs-container .affix {
++    width: 263px;
++  }         
++}
++
++.bs-docs-container .affix-bottom {
++  position: absolute;
++  width: 213px;
++}
++ 
++@media (min-width: 1200px) {
++  .bs-docs-container .affix-bottom {
++    width: 263px;
++  }
++}
++
++#rules > li {
++    padding-top: 20px;
++}
++
++
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/styles/FLATBOOTS/template/boardrules_controller.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/styles/FLATBOOTS/template/boardrules_controller.html"
+new file mode 100644
+index 000000000..464c1e6c3
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/styles/FLATBOOTS/template/boardrules_controller.html"
+@@ -0,0 +1,75 @@
++{% INCLUDECSS '@phpbb_boardrules/boardrules_controller.css' %}
++{% INCLUDE 'overall_header.html' %}
++
++{% if not S_IS_BOT %}
++<div class="row bs-docs-container">
++	<div class="col-md-9">
++		<div class="side-segment">
++			<h3>{{ lang('BOARDRULES_HEADER') }}</h3>
++		</div>
++		<div class="content panel">
++			<div class="panel-body">
++				<p>{{ BOARDRULES_EXPLAIN }}</p>
++				<ol id="rules" class="boardrules-rules{{ BOARDRULES_LIST_STYLE ? ' br-list-style-' ~ BOARDRULES_LIST_STYLE }}">
++					{% for rules in loops.rules %}
++					{% if rules.S_CLOSE_LIST %}
++				</ol>
++				</li>
++				{% elseif rules.S_IS_CATEGORY %}
++				<li id="{{ rules.U_ANCHOR }}">
++					<h3 class="rule-heading"><a class="rule-anchor postlink" href="#{{ rules.U_ANCHOR }}">{{ rules.TITLE }}</a></h3>
++					<ol{{ BOARDRULES_LIST_STYLE ? ' class="br-list-style-' ~ BOARDRULES_LIST_STYLE ~ '"' }}>
++						{% elseif rules.MESSAGE %}
++				<li class="rule-item" id="{{ rules.U_ANCHOR }}">
++					{{ rules.MESSAGE }}
++				</li>
++				{% endif %}
++				{% endfor %}
++				</ol>
++			</div>
++		</div>
++	</div>
++
++	{% if S_CATEGORIES %}
++	<div class="col-md-3 scrollspy hidden-xs hidden-sm">
++		<div class="side-segment">
++			<h3>{{ lang('BOARDRULES_CATEGORIES') }}</h3>
++		</div>
++		<div role="complementary" class="bs-sidebar hidden-print">
++			<ul id="nav" class="nav bs-sidenav" data-spy="affix">
++				{% for rules in loops.rules %}
++				{% if rules.S_IS_CATEGORY %}<li><a href="#{{ rules.U_ANCHOR }}">{{ rules.TITLE }}</a></li>{% endif %}
++				{% endfor %}
++			</ul>
++		</div>
++	</div>
++	{% endif %}
++
++	<script>
++		head.ready(function () {
++			$('#nav').affix({
++				offset: {
++					top: $('#nav').offset().top,
++					bottom: $('footer').outerHeight(true) + $('.section-page').outerHeight(true) + 432
++				}
++			});
++		});
++	</script>
++</div>
++{% else %}
++<div class="row bs-docs-container">
++	<div class="col-md-12">
++		<div class="side-segment">
++			<h3>{{ lang('BOARDRULES_HEADER') }}</h3>
++		</div>
++		<div class="content panel">
++			<div class="panel-body">
++				<span>{{ lang('BOARDRULES_REGISTERED') }}</span>
++			</div>
++		</div>
++	</div>
++</div>
++{% endif %}
++
++{% INCLUDEJS '@phpbb_boardrules/boardrules_controller.js' %}
++{% INCLUDE 'overall_footer.html' %}
+\ No newline at end of file
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/styles/FLATBOOTS/template/event/overall_header_navigation_append.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/styles/FLATBOOTS/template/event/overall_header_navigation_append.html"
+new file mode 100644
+index 000000000..a0b983482
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/styles/FLATBOOTS/template/event/overall_header_navigation_append.html"
+@@ -0,0 +1,3 @@
++<!-- IF S_BOARDRULES_LINK_ENABLED -->
++	<li class="icon-boardrules"><a href="{U_BOARDRULES}" role="menuitem"><i class="fa fa-book"></i>{L_BOARDRULES}</a></li>
++<!-- ENDIF -->
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/styles/FLATBOOTS/template/event/ucp_agreement_terms_before.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/styles/FLATBOOTS/template/event/ucp_agreement_terms_before.html"
+new file mode 100644
+index 000000000..5cf6f88ad
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/styles/FLATBOOTS/template/event/ucp_agreement_terms_before.html"
+@@ -0,0 +1,3 @@
++<!-- IF S_BOARDRULES_AT_REGISTRATION and not S_SHOW_COPPA -->
++	<p><strong>&#42;&#42;&#42;&nbsp;</strong>{L_BOARDRULES_AGREEMENT}{L_COLON}&nbsp;<a href="{U_BOARDRULES}" title="{L_BOARDRULES_TITLE}" target="_blank"><strong>{L_BOARDRULES_TITLE}</strong></a></p>
++<!-- ENDIF -->
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/styles/FLATBOOTS/template/js/boardrules_controller.bak.js" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/styles/FLATBOOTS/template/js/boardrules_controller.bak.js"
+new file mode 100644
+index 000000000..ea54f45d9
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/styles/FLATBOOTS/template/js/boardrules_controller.bak.js"
+@@ -0,0 +1,20 @@
++head.ready(function () {
++$(function() {
++
++  'use strict';
++
++	// Function to apply highlight class to an element identifier
++	var highlight = function (id) {
++		$('#' + decodeURIComponent(id)).addClass('bg-info');
++	};
++
++	// Apply highlight to clicked rule anchor
++	$('.rule-anchor').on('click', function () {
++		$('li').removeClass('bg-info');
++		highlight($(this).closest('.rule-item').attr('id'));
++	});
++
++	// Apply highlight on page load to a rule category
++	highlight(window.location.hash.substring(1));
++});
++});
+\ No newline at end of file
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/styles/FLATBOOTS/template/js/boardrules_controller.js" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/styles/FLATBOOTS/template/js/boardrules_controller.js"
+new file mode 100644
+index 000000000..2a7edd3e7
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/styles/FLATBOOTS/template/js/boardrules_controller.js"
+@@ -0,0 +1 @@
++head.ready(function(){$(function(){"use strict";var n=function(n){$("#"+decodeURIComponent(n)).addClass("bg-info")};$(".rule-anchor").on("click",function(){$("li").removeClass("bg-info"),n($(this).closest(".rule-item").attr("id"))}),n(window.location.hash.substring(1))})});
+\ No newline at end of file
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/styles/FLATBOOTS/theme/boardrules_controller.bak.css" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/styles/FLATBOOTS/theme/boardrules_controller.bak.css"
+new file mode 100644
+index 000000000..496aedd2e
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/styles/FLATBOOTS/theme/boardrules_controller.bak.css"
+@@ -0,0 +1,87 @@
++/**
++* Some CSS adapted from phpBB.com rules page
++*/
++
++.bs-sidenav {
++    background-color: #f7f5fa;
++    border-radius: 5px;
++    margin-bottom: 30px;
++    padding-bottom: 10px;
++    padding-top: 10px;
++    text-shadow: 0 1px 0 #fff;
++}
++
++.bs-sidebar .nav > li > a {
++    color: #716b7a;
++    display: block;
++    padding: 5px 20px;
++}
++
++.bs-sidebar .nav > li > a:hover, .bs-sidebar .nav > li > a:focus {
++    background-color: #e5e3e9;
++    border-right: 2px solid #26BCB5;
++    text-decoration: none;
++}
++
++.bs-sidebar .nav > .active > a, .bs-sidebar .nav > .active:hover > a, .bs-sidebar .nav > .active:focus > a {
++    background-color: transparent;
++    border-right: 2px solid #26BCB5;
++    color: #26BCB5;
++    font-weight: bold;
++}
++.bs-sidebar .nav .nav {
++    display: none;
++    margin-bottom: 8px;
++}
++.bs-sidebar .nav .nav > li > a {
++    font-size: 90%;
++    padding-bottom: 3px;
++    padding-left: 30px;
++    padding-top: 3px;
++}
++
++.bs-sidebar.affix-bottom, .bs-sidebar.affix {
++    width: 263px;
++}
++
++.bs-sidebar.affix {
++    position: fixed;
++    top: 0;
++}
++
++.bs-sidebar .nav > .active > ul {
++    display: block;
++}
++.bs-sidebar .nav .nav {
++    display: none;
++    margin-bottom: 8px;
++}
++
++
++.bs-docs-container .affix {
++  top: 20px;
++  width: 213px;
++}
++ 
++@media (min-width: 1200px) {
++  .bs-docs-container .affix {
++    width: 263px;
++  }         
++}
++
++.bs-docs-container .affix-bottom {
++  position: absolute;
++  width: 213px;
++}
++ 
++@media (min-width: 1200px) {
++  .bs-docs-container .affix-bottom {
++    width: 263px;
++  }
++}
++
++#rules > li {
++    padding-top: 20px;
++}
++
++
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/styles/FLATBOOTS/theme/boardrules_controller.css" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/styles/FLATBOOTS/theme/boardrules_controller.css"
+new file mode 100644
+index 000000000..a1eab2694
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/styles/FLATBOOTS/theme/boardrules_controller.css"
+@@ -0,0 +1 @@
++.bs-sidenav{background-color:#f7f5fa;border-radius:5px;margin-bottom:30px;padding-bottom:10px;padding-top:10px;text-shadow:0 1px 0 #fff}.bs-sidebar .nav > li > a{color:#716b7a;display:block;padding:5px 20px}.bs-sidebar .nav > li > a:hover,.bs-sidebar .nav > li > a:focus{background-color:#e5e3e9;border-right:2px solid #26BCB5;text-decoration:none}.bs-sidebar .nav > .active > a,.bs-sidebar .nav > .active:hover > a,.bs-sidebar .nav > .active:focus > a{background-color:transparent;border-right:2px solid #26BCB5;color:#26BCB5;font-weight:700}.bs-sidebar .nav .nav{display:none;margin-bottom:8px}.bs-sidebar .nav .nav > li > a{font-size:90%;padding-bottom:3px;padding-left:30px;padding-top:3px}.bs-sidebar.affix-bottom,.bs-sidebar.affix{width:263px}.bs-sidebar.affix{position:fixed;top:0}.bs-sidebar .nav > .active > ul{display:block}.bs-sidebar .nav .nav{display:none;margin-bottom:8px}.bs-docs-container .affix{top:20px;width:213px;z-index:1}@media (min-width: 1200px){.bs-docs-container .affix{width:320px}}.bs-docs-container .affix-bottom{position:absolute;width:213px;z-index:1}@media (min-width: 1200px){.bs-docs-container .affix-bottom{width:320px}}#rules > li{padding-top:20px}.content .br-list-style-disc{list-style-type:disc}.content .br-list-style-none{list-style-type:none}.content > .br-list-style-none{margin-left:0}.rtl .content > .br-list-style-none{margin-right:0}
+\ No newline at end of file
diff --git "[FORUM_EXT]/phpbb\\boardrules/diff_nospace.tmp" "[FORUM_EXT]/phpbb\\boardrules/diff_nospace.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/phpbb\\boardrules/diff_nospace.tmp"
@@ -0,0 +1,855 @@
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/diff_full.tmp"
+new file mode 100644
+index 000000000..8266bb8e1
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/diff_full.tmp"
+@@ -0,0 +1,877 @@
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/diff_full.tmp"
++new file mode 100644
++index 000000000..e69de29bb
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/language/pt_preao/boardrules_acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/language/pt_preao/boardrules_acp.php"
++new file mode 100644
++index 000000000..9163ea0a1
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/language/pt_preao/boardrules_acp.php"
++@@ -0,0 +1,99 @@
+++<?php
+++/**
+++*
+++* Board Rules extension for the phpBB Forum Software package.
+++* @Traduzido por: http://phpbbportugal.com - segundo as normas do Acordo Ortográfico
+++*
+++* @copyright (c) 2014 phpBB Limited <https://www.phpbb.com>
+++* @license GNU General Public License, version 2 (GPL-2.0)
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
+++$lang = array_merge($lang, array(
+++	// Settings page
+++	'ACP_BOARDRULES'						=> 'Regras do Fórum',
+++	'ACP_BOARDRULES_SETTINGS'				=> 'Configurar regras',
+++	'ACP_BOARDRULES_SETTINGS_EXPLAIN'		=> 'Aqui pode configurar as definições principais das regras do Fórum.',
+++	'ACP_BOARDRULES_ENABLE'					=> 'Ativar regras',
+++	'ACP_BOARDRULES_HEADER_LINK'			=> 'Mostrar link no cabeçalho',
+++	'ACP_BOARDRULES_FONT_ICON'				=> 'Board rules link icon',
+++	'ACP_BOARDRULES_FONT_ICON_EXPLAIN'		=> 'Enter the name of a <strong><a href="%s" target="_blank">Font Awesome</a></strong> icon to use for the board rules link in the header. Leave this field blank for no board rules icon.',
+++	'ACP_BOARDRULES_FONT_ICON_INVALID'		=> 'The board rules link icon contained invalid characters.',
+++	'ACP_BOARDRULES_AT_REGISTRATION'		=> 'Exigir aceitação das regras no momento do registo',
+++	'ACP_BOARDRULES_AT_REGISTRATION_EXPLAIN'=> 'Acrescenta as Regras do Fórum às "Condições de utilização", permitindo a sua leitura e obrigando à sua aceitação antes do registo.',
+++	'ACP_BOARDRULES_NOTIFY'					=> 'Notificar Utilizadores',
+++	'ACP_BOARDRULES_NOTIFY_EXPLAIN'			=> 'Enviar uma notificação a todos os utilizadores registrados que as regras da comunidade foram atualizados. (Esta ação pode demorar alguns segundos para ser concluída em Fóruns com muitos milhares de membros.)',
+++	'ACP_BOARDRULES_NOTIFY_CONFIRM'			=> 'Tem certeza que deseja enviar notificações a todos os utilizadores?',
+++	'ACP_BOARDRULES_SETTINGS_CHANGED'		=> 'A configuração das regras do fórum foi alterada.',
+++	'ACP_BOARDRULES_LIST_STYLE'				=> 'Board rules list style',
+++	'ACP_BOARDRULES_LIST_STYLE_EXPLAIN'		=> 'Board rules are presented in a list format. Decide if you want rule and category items to be preceded by ordered alpha-numeric ordinals (this is the default behavior), bullets or nothing.',
+++	'ACP_BOARDRULES_LIST_STYLE_ORDERED'		=> 'Ordered alpha-numeric',
+++	'ACP_BOARDRULES_LIST_STYLE_BULLET'		=> 'Bullet',
+++	'ACP_BOARDRULES_LIST_STYLE_NONE'		=> 'None',
+++
+++	// Manage page
+++	'ACP_BOARDRULES_MANAGE'					=> 'Gerir regras',
+++	'ACP_BOARDRULES_MANAGE_EXPLAIN'			=> 'Nesta página pode adicionar, editar, apagar e reordenar as categorias e regras. A categoria é um conjunto de regras inter-relacionadas. Cada categoria pode ter um número ilimitado de regras.',
+++	'ACP_BOARDRULES_LANGUAGE_EXPLAIN'		=> 'Choose a language for your Board Rules. Users will see the rules you create for their preferred language. If you do not create any rules in their preferred language, then users will see rules created using the board’s default language.',
+++	'ACP_BOARDRULES_CATEGORY'				=> 'Categoria de regras',
+++	'ACP_BOARDRULES_RULE'					=> 'Regra',
+++	'ACP_BOARDRULES_SELECT_LANGUAGE'		=> 'Escolha um idioma',
+++	'ACP_BOARDRULES_CREATE_RULE'			=> 'Criar regra',
+++	'ACP_BOARDRULES_CREATE_RULE_EXPLAIN'	=> 'Através do formulário abaixo pode criar uma nova regra que será mostrada aos utilizadores.',
+++	'ACP_BOARDRULES_EDIT_RULE'				=> 'Editar regra',
+++	'ACP_BOARDRULES_EDIT_RULE_EXPLAIN'		=> 'Através do formulário abaixo pode atualizar uma regra que será mostrada aos utilizadores.',
+++	'ACP_RULE_SETTINGS'						=> 'Configurar regra',
+++	'ACP_RULE_PARENT'						=> 'Regra pai',
+++	'ACP_RULE_NO_PARENT'					=> 'Nenhum pai',
+++	'ACP_RULE_TITLE'						=> 'Título da regra',
+++	'ACP_RULE_TITLE_EXPLAIN'				=> 'Os Títulos das Regras são exibidos na página de regras apenas para categorias de regras. Títulos das regras também são usados para identificar as regras na gestão do ACP.',
+++	'ACP_RULE_ANCHOR'						=> 'Regra âncora',
+++	'ACP_RULE_ANCHOR_EXPLAIN'				=> 'Âncoras de regras são opcionais e usadas como pontos de ligação de ancoragem na página regras. Devem ser URL amigáveis (não podem conter espaços ou caracteres especiais), devem começar com uma letra, e devem ser exclusivos.',
+++	'ACP_RULE_MESSAGE'						=> 'Mensagem da regra',
+++	'ACP_RULE_MESSAGE_EXPLAIN'				=> 'A mensagem da regra é exibida na página de regra para cada regra (categorias não exibem mensagens das regras).',
+++	'ACP_RULE_MESSAGE_DISABLED'				=> 'Esta é uma categoria que contém regras, o editor mensagem foi desativado.',
+++	'ACP_ADD_RULE'							=> 'Criar nova regra',
+++	'ACP_DELETE_RULE_CONFIRM'				=> array(
+++		0 => 'Tem a certeza que deseja eliminar esta regra?',
+++		1 => 'Tem a certeza que deseja eliminar esta categoria de regra?<br />Aviso: Removendo um categoria de regra irá remover todas as regras contidas dentro dela.',
+++	),
+++	'ACP_RULE_ADDED'						=> 'Regra criada com sucesso.',
+++	'ACP_RULE_DELETED'						=> 'Regra eliminada com sucesso.',
+++	'ACP_RULE_EDITED'						=> 'Regra editada com sucesso.',
+++	'ACP_RULE_TITLE_EMPTY'					=> 'Tem que dar um titulo à regra.',
+++
+++	// Nested set exception messages (only appears in PHP error logging)
+++	// Translators: Feel free to not translate these language strings
+++	'RULES_NESTEDSET_LOCK_FAILED_ACQUIRE'	=> 'Board rules failed to acquire the table lock. Another process may be holding the lock. Locks are forcibly released after a timeout of 1 hour.',
+++	'RULES_NESTEDSET_INVALID_ITEM'			=> 'The requested rule does not exist.',
+++	'RULES_NESTEDSET_INVALID_PARENT'		=> 'The requested rule has no parent.',
+++));
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/language/pt_preao/boardrules_common.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/language/pt_preao/boardrules_common.php"
++new file mode 100644
++index 000000000..6020f291b
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/language/pt_preao/boardrules_common.php"
++@@ -0,0 +1,47 @@
+++<?php
+++/**
+++*
+++* Board Rules extension for the phpBB Forum Software package.
+++* @Traduzido por: http://phpbbportugal.com - segundo as normas do Acordo Ortográfico
+++*
+++* @copyright (c) 2013 phpBB Limited <https://www.phpbb.com>
+++* @license GNU General Public License, version 2 (GPL-2.0)
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
+++$lang = array_merge($lang, array(
+++	'BOARDRULES'				=> 'Regras',
+++	'BOARDRULES_TITLE'			=> 'Ver as regras deste Fórum',
+++	'BOARDRULES_AGREEMENT'		=> 'Concorda em respeitar as regras deste fórum estabelecidas na secção “Regras”',
+++	'BOARDRULES_VIEWONLINE'		=> 'A ler as regras do Fórum',
+++	'BOARDRULES_NOTIFICATION'	=> 'As regras do Fórum foram actualizadas. Clique aqui para as rever.',
+++));
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/language/pt_preao/boardrules_controller.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/language/pt_preao/boardrules_controller.php"
++new file mode 100644
++index 000000000..5254f6303
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/language/pt_preao/boardrules_controller.php"
++@@ -0,0 +1,48 @@
+++<?php
+++/**
+++*
+++* Board Rules extension for the phpBB Forum Software package.
+++* @Traduzido por: http://phpbbportugal.com - segundo as normas do Acordo Ortográfico
+++*
+++* @copyright (c) 2014 phpBB Limited <https://www.phpbb.com>
+++* @license GNU General Public License, version 2 (GPL-2.0)
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
+++$lang = array_merge($lang, array(
+++	'BOARDRULES_HEADER'			=> 'Regras do Fórum',
+++	'BOARDRULES_EXPLAIN'		=> 'Estas regras servem para esclarecer as várias responsabilidades de todos os membros da comunidade %s. Devem ser respeitadas por todos para garantir que o nosso Fórum funciona sem problemas e oferece uma experiência divertida e produtiva para todos os membros da comunidade.',
+++	'BOARDRULES_CATEGORIES'		=> 'Secções de Regras',
+++	'BOARDRULES_CATEGORY_ANCHOR'=> 'seccao-%s',
+++	'BOARDRULES_RULE_ANCHOR'	=> 'regra-%s',
+++	'BOARDRULES_REGISTERED'		=> 'Precisa de estar registado para ter acesso às regras',
+++));
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/language/pt_preao/boardrules_install.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/language/pt_preao/boardrules_install.php"
++new file mode 100644
++index 000000000..ce4906be1
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/language/pt_preao/boardrules_install.php"
++@@ -0,0 +1,49 @@
+++<?php
+++/**
+++*
+++* Board Rules extension for the phpBB Forum Software package.
+++* @Traduzido por: http://phpbbportugal.com - segundo as normas do Acordo Ortográfico
+++*
+++* @copyright (c) 2014 phpBB Limited <https://www.phpbb.com>
+++* @license GNU General Public License, version 2 (GPL-2.0)
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
+++$lang = array_merge($lang, array(
+++	'BOARDRULES_SAMPLE_CATEGORY_TITLE'		=> 'Examplo Regra Categoria',
+++	'BOARDRULES_SAMPLE_CATEGORY_MESSAGE'	=> 'Esta é uma categoria de exemplo das Regras do Fórum. Categorias contêm grupos de regras relacionadas. Mensagens Categoria (como esta) não são exibidas na página de regras.',
+++	'BOARDRULES_SAMPLE_CATEGORY_ANCHOR'		=> 'examplo-categoria',
+++
+++	'BOARDRULES_SAMPLE_RULE_TITLE'			=> 'Examplo de Regra',
+++	'BOARDRULES_SAMPLE_RULE_MESSAGE'		=> 'Esta é uma Regras de exemplo das Regras do Fórum. Tudo parece funcionar bem. Pode editar ou excluir esta regra e categoria e continuar a configurar suas próprias regras deste Fórum.',
+++	'BOARDRULES_SAMPLE_RULE_ANCHOR'			=> 'examplo-regra',
+++));
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/language/pt_preao/exceptions.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/language/pt_preao/exceptions.php"
++new file mode 100644
++index 000000000..a3a4a29f3
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/language/pt_preao/exceptions.php"
++@@ -0,0 +1,62 @@
+++<?php
+++/**
+++*
+++* Board Rules extension for the phpBB Forum Software package.
+++* @Traduzido por: http://phpbbportugal.com - segundo as normas do Acordo Ortográfico
+++*
+++* @copyright (c) 2014 phpBB Limited <https://www.phpbb.com>
+++* @license GNU General Public License, version 2 (GPL-2.0)
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
+++/*
+++* These are errors which can be triggered by sending invalid data to the
+++* boardrules extension API.
+++*
+++* These errors will never show to a user unless they are either modifying
+++* the core boardrules extension code OR unless they are writing an extension
+++* which makes calls to this extension.
+++*
+++* Translators: Feel free to not translate these language strings
+++*/
+++$lang = array_merge($lang, array(
+++	'EXCEPTION_FIELD_MISSING'		=> 'Campo obrigatório em falta',
+++	'EXCEPTION_INVALID_ARGUMENT'	=> 'O argumento especificado para `%1$s` é inválido. Razão: %2$s',
+++	'EXCEPTION_OUT_OF_BOUNDS'		=> 'O Campo `%1$s` recebeu dados além do limite',
+++	'EXCEPTION_TOO_LONG'			=> 'A entrada foi maior do que o máximo permitido.',
+++	'EXCEPTION_NOT_UNIQUE'			=> 'A entrada não é única.',
+++	'EXCEPTION_UNEXPECTED_VALUE'	=> 'O campo `%1$s` recebeu dados não previstos. Razão: %2$s',
+++	'EXCEPTION_ILLEGAL_CHARACTERS'	=> 'A entrada tem caracteres inválidos.',
+++
+++	// Translators: do not change this
+++	'EXCEPTION_WRONG_DATA_LANG'		=> $lang['WRONG_DATA_LANG'],
+++));
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/language/pt_preao/info_acp_boardrules.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/language/pt_preao/info_acp_boardrules.php"
++new file mode 100644
++index 000000000..1daddb6d1
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/language/pt_preao/info_acp_boardrules.php"
++@@ -0,0 +1,50 @@
+++<?php
+++/**
+++*
+++* Board Rules extension for the phpBB Forum Software package.
+++* @Traduzido por: http://phpbbportugal.com - segundo as normas do Acordo Ortográfico
+++*
+++* @copyright (c) 2014 phpBB Limited <https://www.phpbb.com>
+++* @license GNU General Public License, version 2 (GPL-2.0)
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
+++$lang = array_merge($lang, array(
+++	// ACP modules
+++	'ACP_BOARDRULES'				=> 'Regras do Fórum',
+++	'ACP_BOARDRULES_MANAGE'			=> 'Gerir regras',
+++	'ACP_BOARDRULES_SETTINGS'		=> 'Configurar regras',
+++
+++	// ACP Logs
+++	'ACP_BOARDRULES_SETTINGS_LOG'	=> '<strong>Configurações das regras do fórum foram alteradas</strong>',
+++	'ACP_BOARDRULES_NOTIFY_LOG'		=> '<strong>Enviadas notificações das regras a todos os utilizadores</strong>',
+++));
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/language/pt_preao/permissions_boardrules.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/language/pt_preao/permissions_boardrules.php"
++new file mode 100644
++index 000000000..95135cda9
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/language/pt_preao/permissions_boardrules.php"
++@@ -0,0 +1,43 @@
+++<?php
+++/**
+++*
+++* Board Rules extension for the phpBB Forum Software package.
+++* @Traduzido por: http://phpbbportugal.com - segundo as normas do Acordo Ortográfico
+++*
+++* @copyright (c) 2014 phpBB Limited <https://www.phpbb.com>
+++* @license GNU General Public License, version 2 (GPL-2.0)
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
+++$lang = array_merge($lang, array(
+++	'ACL_A_BOARDRULES'		=> 'Pode administrar as regras do fórum',
+++));
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/styles/BBOOTS/template/boardrules_controller.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/styles/BBOOTS/template/boardrules_controller.html"
++new file mode 100644
++index 000000000..e664ff7be
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/styles/BBOOTS/template/boardrules_controller.html"
++@@ -0,0 +1,54 @@
+++{% INCLUDECSS '@phpbb_boardrules/boardrules_controller.css' %}
+++{% INCLUDE 'overall_header.html' %}
+++<div class="row bs-docs-container">
+++<div class="col-md-9">
+++	<div class="side-segment"><h3>{L_BOARDRULES_HEADER}</h3></div>
+++	<div class="content panel">
+++	 <div class="panel-body">
+++		<p>{BOARDRULES_EXPLAIN}</p>
+++		<ol class="boardrules-rules{{ BOARDRULES_LIST_STYLE ? ' br-list-style-' ~ BOARDRULES_LIST_STYLE }}" id="rules">
+++			{% for rules in loops.rules %}
+++				{% if rules.S_CLOSE_LIST %}
+++						</ol>
+++					</li>
+++				{% elseif rules.S_IS_CATEGORY %}
+++					<li id="{{ rules.U_ANCHOR }}">
+++						<h3 class="rule-heading">{{ rules.TITLE }}</h3>
+++						<ol>
+++				{% else %}
+++							<li class="rule-item" id="{{ rules.U_ANCHOR }}">
+++								{{ rules.MESSAGE }} <a class="rule-anchor postlink" href="#{{ rules.U_ANCHOR }}">&#35;</a>
+++							</li>
+++				{% endif %}
+++			{% endfor %}
+++		</ol>
+++	 </div>	
+++	</div>
+++</div>
+++
+++{% if S_CATEGORIES %}
+++<div class="col-md-3 scrollspy hidden-xs hidden-sm">
+++ <div class="side-segment"><h3>{{ lang('BOARDRULES_CATEGORIES') }}</h3></div>
+++    <div role="complementary" class="bs-sidebar hidden-print">
+++		<ul id="nav" class="nav bs-sidenav" data-spy="affix">
+++			{% for rules in loops.rules %}
+++				{% if rules.S_IS_CATEGORY %}<li><a href="#{{ rules.U_ANCHOR }}">{{ rules.TITLE }}</a></li>{% endif %}
+++			{% endfor %}
+++		</ul>
+++	</div>	
+++</div>
+++{% endif %}
+++
+++<script>
+++head.ready(function () {
+++   $('#nav').affix({
+++    offset: {
+++        top: $('#nav').offset().top,
+++        bottom: $('footer').outerHeight(true) + $('.section-page').outerHeight(true) + 432
+++    }
+++});
+++});
+++</script>
+++</div>
+++{% INCLUDEJS '@phpbb_boardrules/boardrules_controller.js' %}
+++{% INCLUDE 'overall_footer.html' %}
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/styles/BBOOTS/template/event/overall_header_navigation_append.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/styles/BBOOTS/template/event/overall_header_navigation_append.html"
++new file mode 100644
++index 000000000..77e2de256
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/styles/BBOOTS/template/event/overall_header_navigation_append.html"
++@@ -0,0 +1,3 @@
+++<!-- IF S_BOARDRULES_LINK_ENABLED-->
+++	<li class="icon-boardrules"><a href="{U_BOARDRULES}" role="menuitem"><i class="fa fa-book"></i>&nbsp;{L_BOARDRULES}</a><span></span></li>
+++<!-- ENDIF -->
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/styles/BBOOTS/template/event/ucp_agreement_terms_before.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/styles/BBOOTS/template/event/ucp_agreement_terms_before.html"
++new file mode 100644
++index 000000000..5cf6f88ad
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/styles/BBOOTS/template/event/ucp_agreement_terms_before.html"
++@@ -0,0 +1,3 @@
+++<!-- IF S_BOARDRULES_AT_REGISTRATION and not S_SHOW_COPPA -->
+++	<p><strong>&#42;&#42;&#42;&nbsp;</strong>{L_BOARDRULES_AGREEMENT}{L_COLON}&nbsp;<a href="{U_BOARDRULES}" title="{L_BOARDRULES_TITLE}" target="_blank"><strong>{L_BOARDRULES_TITLE}</strong></a></p>
+++<!-- ENDIF -->
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/styles/BBOOTS/template/js/boardrules_controller.js" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/styles/BBOOTS/template/js/boardrules_controller.js"
++new file mode 100644
++index 000000000..ea54f45d9
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/styles/BBOOTS/template/js/boardrules_controller.js"
++@@ -0,0 +1,20 @@
+++head.ready(function () {
+++$(function() {
+++
+++  'use strict';
+++
+++	// Function to apply highlight class to an element identifier
+++	var highlight = function (id) {
+++		$('#' + decodeURIComponent(id)).addClass('bg-info');
+++	};
+++
+++	// Apply highlight to clicked rule anchor
+++	$('.rule-anchor').on('click', function () {
+++		$('li').removeClass('bg-info');
+++		highlight($(this).closest('.rule-item').attr('id'));
+++	});
+++
+++	// Apply highlight on page load to a rule category
+++	highlight(window.location.hash.substring(1));
+++});
+++});
++\ No newline at end of file
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/styles/BBOOTS/theme/boardrules_controller.css" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/styles/BBOOTS/theme/boardrules_controller.css"
++new file mode 100644
++index 000000000..496aedd2e
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/styles/BBOOTS/theme/boardrules_controller.css"
++@@ -0,0 +1,87 @@
+++/**
+++* Some CSS adapted from phpBB.com rules page
+++*/
+++
+++.bs-sidenav {
+++    background-color: #f7f5fa;
+++    border-radius: 5px;
+++    margin-bottom: 30px;
+++    padding-bottom: 10px;
+++    padding-top: 10px;
+++    text-shadow: 0 1px 0 #fff;
+++}
+++
+++.bs-sidebar .nav > li > a {
+++    color: #716b7a;
+++    display: block;
+++    padding: 5px 20px;
+++}
+++
+++.bs-sidebar .nav > li > a:hover, .bs-sidebar .nav > li > a:focus {
+++    background-color: #e5e3e9;
+++    border-right: 2px solid #26BCB5;
+++    text-decoration: none;
+++}
+++
+++.bs-sidebar .nav > .active > a, .bs-sidebar .nav > .active:hover > a, .bs-sidebar .nav > .active:focus > a {
+++    background-color: transparent;
+++    border-right: 2px solid #26BCB5;
+++    color: #26BCB5;
+++    font-weight: bold;
+++}
+++.bs-sidebar .nav .nav {
+++    display: none;
+++    margin-bottom: 8px;
+++}
+++.bs-sidebar .nav .nav > li > a {
+++    font-size: 90%;
+++    padding-bottom: 3px;
+++    padding-left: 30px;
+++    padding-top: 3px;
+++}
+++
+++.bs-sidebar.affix-bottom, .bs-sidebar.affix {
+++    width: 263px;
+++}
+++
+++.bs-sidebar.affix {
+++    position: fixed;
+++    top: 0;
+++}
+++
+++.bs-sidebar .nav > .active > ul {
+++    display: block;
+++}
+++.bs-sidebar .nav .nav {
+++    display: none;
+++    margin-bottom: 8px;
+++}
+++
+++
+++.bs-docs-container .affix {
+++  top: 20px;
+++  width: 213px;
+++}
+++ 
+++@media (min-width: 1200px) {
+++  .bs-docs-container .affix {
+++    width: 263px;
+++  }         
+++}
+++
+++.bs-docs-container .affix-bottom {
+++  position: absolute;
+++  width: 213px;
+++}
+++ 
+++@media (min-width: 1200px) {
+++  .bs-docs-container .affix-bottom {
+++    width: 263px;
+++  }
+++}
+++
+++#rules > li {
+++    padding-top: 20px;
+++}
+++
+++
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/styles/FLATBOOTS/template/boardrules_controller.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/styles/FLATBOOTS/template/boardrules_controller.html"
++new file mode 100644
++index 000000000..464c1e6c3
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/styles/FLATBOOTS/template/boardrules_controller.html"
++@@ -0,0 +1,75 @@
+++{% INCLUDECSS '@phpbb_boardrules/boardrules_controller.css' %}
+++{% INCLUDE 'overall_header.html' %}
+++
+++{% if not S_IS_BOT %}
+++<div class="row bs-docs-container">
+++	<div class="col-md-9">
+++		<div class="side-segment">
+++			<h3>{{ lang('BOARDRULES_HEADER') }}</h3>
+++		</div>
+++		<div class="content panel">
+++			<div class="panel-body">
+++				<p>{{ BOARDRULES_EXPLAIN }}</p>
+++				<ol id="rules" class="boardrules-rules{{ BOARDRULES_LIST_STYLE ? ' br-list-style-' ~ BOARDRULES_LIST_STYLE }}">
+++					{% for rules in loops.rules %}
+++					{% if rules.S_CLOSE_LIST %}
+++				</ol>
+++				</li>
+++				{% elseif rules.S_IS_CATEGORY %}
+++				<li id="{{ rules.U_ANCHOR }}">
+++					<h3 class="rule-heading"><a class="rule-anchor postlink" href="#{{ rules.U_ANCHOR }}">{{ rules.TITLE }}</a></h3>
+++					<ol{{ BOARDRULES_LIST_STYLE ? ' class="br-list-style-' ~ BOARDRULES_LIST_STYLE ~ '"' }}>
+++						{% elseif rules.MESSAGE %}
+++				<li class="rule-item" id="{{ rules.U_ANCHOR }}">
+++					{{ rules.MESSAGE }}
+++				</li>
+++				{% endif %}
+++				{% endfor %}
+++				</ol>
+++			</div>
+++		</div>
+++	</div>
+++
+++	{% if S_CATEGORIES %}
+++	<div class="col-md-3 scrollspy hidden-xs hidden-sm">
+++		<div class="side-segment">
+++			<h3>{{ lang('BOARDRULES_CATEGORIES') }}</h3>
+++		</div>
+++		<div role="complementary" class="bs-sidebar hidden-print">
+++			<ul id="nav" class="nav bs-sidenav" data-spy="affix">
+++				{% for rules in loops.rules %}
+++				{% if rules.S_IS_CATEGORY %}<li><a href="#{{ rules.U_ANCHOR }}">{{ rules.TITLE }}</a></li>{% endif %}
+++				{% endfor %}
+++			</ul>
+++		</div>
+++	</div>
+++	{% endif %}
+++
+++	<script>
+++		head.ready(function () {
+++			$('#nav').affix({
+++				offset: {
+++					top: $('#nav').offset().top,
+++					bottom: $('footer').outerHeight(true) + $('.section-page').outerHeight(true) + 432
+++				}
+++			});
+++		});
+++	</script>
+++</div>
+++{% else %}
+++<div class="row bs-docs-container">
+++	<div class="col-md-12">
+++		<div class="side-segment">
+++			<h3>{{ lang('BOARDRULES_HEADER') }}</h3>
+++		</div>
+++		<div class="content panel">
+++			<div class="panel-body">
+++				<span>{{ lang('BOARDRULES_REGISTERED') }}</span>
+++			</div>
+++		</div>
+++	</div>
+++</div>
+++{% endif %}
+++
+++{% INCLUDEJS '@phpbb_boardrules/boardrules_controller.js' %}
+++{% INCLUDE 'overall_footer.html' %}
++\ No newline at end of file
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/styles/FLATBOOTS/template/event/overall_header_navigation_append.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/styles/FLATBOOTS/template/event/overall_header_navigation_append.html"
++new file mode 100644
++index 000000000..a0b983482
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/styles/FLATBOOTS/template/event/overall_header_navigation_append.html"
++@@ -0,0 +1,3 @@
+++<!-- IF S_BOARDRULES_LINK_ENABLED -->
+++	<li class="icon-boardrules"><a href="{U_BOARDRULES}" role="menuitem"><i class="fa fa-book"></i>{L_BOARDRULES}</a></li>
+++<!-- ENDIF -->
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/styles/FLATBOOTS/template/event/ucp_agreement_terms_before.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/styles/FLATBOOTS/template/event/ucp_agreement_terms_before.html"
++new file mode 100644
++index 000000000..5cf6f88ad
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/styles/FLATBOOTS/template/event/ucp_agreement_terms_before.html"
++@@ -0,0 +1,3 @@
+++<!-- IF S_BOARDRULES_AT_REGISTRATION and not S_SHOW_COPPA -->
+++	<p><strong>&#42;&#42;&#42;&nbsp;</strong>{L_BOARDRULES_AGREEMENT}{L_COLON}&nbsp;<a href="{U_BOARDRULES}" title="{L_BOARDRULES_TITLE}" target="_blank"><strong>{L_BOARDRULES_TITLE}</strong></a></p>
+++<!-- ENDIF -->
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/styles/FLATBOOTS/template/js/boardrules_controller.bak.js" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/styles/FLATBOOTS/template/js/boardrules_controller.bak.js"
++new file mode 100644
++index 000000000..ea54f45d9
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/styles/FLATBOOTS/template/js/boardrules_controller.bak.js"
++@@ -0,0 +1,20 @@
+++head.ready(function () {
+++$(function() {
+++
+++  'use strict';
+++
+++	// Function to apply highlight class to an element identifier
+++	var highlight = function (id) {
+++		$('#' + decodeURIComponent(id)).addClass('bg-info');
+++	};
+++
+++	// Apply highlight to clicked rule anchor
+++	$('.rule-anchor').on('click', function () {
+++		$('li').removeClass('bg-info');
+++		highlight($(this).closest('.rule-item').attr('id'));
+++	});
+++
+++	// Apply highlight on page load to a rule category
+++	highlight(window.location.hash.substring(1));
+++});
+++});
++\ No newline at end of file
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/styles/FLATBOOTS/template/js/boardrules_controller.js" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/styles/FLATBOOTS/template/js/boardrules_controller.js"
++new file mode 100644
++index 000000000..2a7edd3e7
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/styles/FLATBOOTS/template/js/boardrules_controller.js"
++@@ -0,0 +1 @@
+++head.ready(function(){$(function(){"use strict";var n=function(n){$("#"+decodeURIComponent(n)).addClass("bg-info")};$(".rule-anchor").on("click",function(){$("li").removeClass("bg-info"),n($(this).closest(".rule-item").attr("id"))}),n(window.location.hash.substring(1))})});
++\ No newline at end of file
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/styles/FLATBOOTS/theme/boardrules_controller.bak.css" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/styles/FLATBOOTS/theme/boardrules_controller.bak.css"
++new file mode 100644
++index 000000000..496aedd2e
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\phpbb\\boardrules/styles/FLATBOOTS/theme/boardrules_controller.bak.css"
++@@ -0,0 +1,87 @@
+++/**
+++* Some CSS adapted from phpBB.com rules page
+++*/
+++
+++.bs-sidenav {
+++    background-color: #f7f5fa;
+++    border-radius: 5px;
+++    margin-bottom: 30px;
+++    padding-bottom: 10px;
+++    padding-top: 10px;
+++    text-shadow: 0 1px 0 #fff;
+++}
+++
+++.bs-sidebar .nav > li > a {
+++    color: #716b7a;
+++    display: block;
+++    padding: 5px 20px;
+++}
+++
+++.bs-sidebar .nav > li > a:hover, .bs-sidebar .nav > li > a:focus {
+++    background-color: #e5e3e9;
+++    border-right: 2px solid #26BCB5;
+++    text-decoration: none;
+++}
+++
+++.bs-sidebar .nav > .active > a, .bs-sidebar .nav > .active:hover > a, .bs-sidebar .nav > .active:focus > a {
+++    background-color: transparent;
+++    border-right: 2px solid #26BCB5;
+++    color: #26BCB5;
+++    font-weight: bold;
+++}
+++.bs-sidebar .nav .nav {
+++    display: none;
+++    margin-bottom: 8px;
+++}
+++.bs-sidebar .nav .nav > li > a {
+++    font-size: 90%;
+++    padding-bottom: 3px;
+++    padding-left: 30px;
+++    padding-top: 3px;
+++}
+++
+++.bs-sidebar.affix-bottom, .bs-sidebar.affix {
+++    width: 263px;
+++}
+++
+++.bs-sidebar.affix {
+++    position: fixed;
+++    top: 0;
+++}
+++
+++.bs-sidebar .nav > .active > ul {
+++    display: block;
+++}
+++.bs-sidebar .nav .nav {
+++    display: none;
+++    margin-bottom: 8px;
+++}
+++
+++
+++.bs-docs-container .affix {
+++  top: 20px;
+++  width: 213px;
+++}
+++ 
+++@media (min-width: 1200px) {
+++  .bs-doc
\ No newline at end of file
diff --git "[FORUM_EXT]/phpbb\\boardrules/language/pt_preao/boardrules_acp.php" "[FORUM_EXT]/phpbb\\boardrules/language/pt_preao/boardrules_acp.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/phpbb\\boardrules/language/pt_preao/boardrules_acp.php"
@@ -0,0 +1,99 @@
+<?php
+/**
+*
+* Board Rules extension for the phpBB Forum Software package.
+* @Traduzido por: http://phpbbportugal.com - segundo as normas do Acordo Ortográfico
+*
+* @copyright (c) 2014 phpBB Limited <https://www.phpbb.com>
+* @license GNU General Public License, version 2 (GPL-2.0)
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
+$lang = array_merge($lang, array(
+	// Settings page
+	'ACP_BOARDRULES'						=> 'Regras do Fórum',
+	'ACP_BOARDRULES_SETTINGS'				=> 'Configurar regras',
+	'ACP_BOARDRULES_SETTINGS_EXPLAIN'		=> 'Aqui pode configurar as definições principais das regras do Fórum.',
+	'ACP_BOARDRULES_ENABLE'					=> 'Ativar regras',
+	'ACP_BOARDRULES_HEADER_LINK'			=> 'Mostrar link no cabeçalho',
+	'ACP_BOARDRULES_FONT_ICON'				=> 'Board rules link icon',
+	'ACP_BOARDRULES_FONT_ICON_EXPLAIN'		=> 'Enter the name of a <strong><a href="%s" target="_blank">Font Awesome</a></strong> icon to use for the board rules link in the header. Leave this field blank for no board rules icon.',
+	'ACP_BOARDRULES_FONT_ICON_INVALID'		=> 'The board rules link icon contained invalid characters.',
+	'ACP_BOARDRULES_AT_REGISTRATION'		=> 'Exigir aceitação das regras no momento do registo',
+	'ACP_BOARDRULES_AT_REGISTRATION_EXPLAIN'=> 'Acrescenta as Regras do Fórum às "Condições de utilização", permitindo a sua leitura e obrigando à sua aceitação antes do registo.',
+	'ACP_BOARDRULES_NOTIFY'					=> 'Notificar Utilizadores',
+	'ACP_BOARDRULES_NOTIFY_EXPLAIN'			=> 'Enviar uma notificação a todos os utilizadores registrados que as regras da comunidade foram atualizados. (Esta ação pode demorar alguns segundos para ser concluída em Fóruns com muitos milhares de membros.)',
+	'ACP_BOARDRULES_NOTIFY_CONFIRM'			=> 'Tem certeza que deseja enviar notificações a todos os utilizadores?',
+	'ACP_BOARDRULES_SETTINGS_CHANGED'		=> 'A configuração das regras do fórum foi alterada.',
+	'ACP_BOARDRULES_LIST_STYLE'				=> 'Board rules list style',
+	'ACP_BOARDRULES_LIST_STYLE_EXPLAIN'		=> 'Board rules are presented in a list format. Decide if you want rule and category items to be preceded by ordered alpha-numeric ordinals (this is the default behavior), bullets or nothing.',
+	'ACP_BOARDRULES_LIST_STYLE_ORDERED'		=> 'Ordered alpha-numeric',
+	'ACP_BOARDRULES_LIST_STYLE_BULLET'		=> 'Bullet',
+	'ACP_BOARDRULES_LIST_STYLE_NONE'		=> 'None',
+
+	// Manage page
+	'ACP_BOARDRULES_MANAGE'					=> 'Gerir regras',
+	'ACP_BOARDRULES_MANAGE_EXPLAIN'			=> 'Nesta página pode adicionar, editar, apagar e reordenar as categorias e regras. A categoria é um conjunto de regras inter-relacionadas. Cada categoria pode ter um número ilimitado de regras.',
+	'ACP_BOARDRULES_LANGUAGE_EXPLAIN'		=> 'Choose a language for your Board Rules. Users will see the rules you create for their preferred language. If you do not create any rules in their preferred language, then users will see rules created using the board’s default language.',
+	'ACP_BOARDRULES_CATEGORY'				=> 'Categoria de regras',
+	'ACP_BOARDRULES_RULE'					=> 'Regra',
+	'ACP_BOARDRULES_SELECT_LANGUAGE'		=> 'Escolha um idioma',
+	'ACP_BOARDRULES_CREATE_RULE'			=> 'Criar regra',
+	'ACP_BOARDRULES_CREATE_RULE_EXPLAIN'	=> 'Através do formulário abaixo pode criar uma nova regra que será mostrada aos utilizadores.',
+	'ACP_BOARDRULES_EDIT_RULE'				=> 'Editar regra',
+	'ACP_BOARDRULES_EDIT_RULE_EXPLAIN'		=> 'Através do formulário abaixo pode atualizar uma regra que será mostrada aos utilizadores.',
+	'ACP_RULE_SETTINGS'						=> 'Configurar regra',
+	'ACP_RULE_PARENT'						=> 'Regra pai',
+	'ACP_RULE_NO_PARENT'					=> 'Nenhum pai',
+	'ACP_RULE_TITLE'						=> 'Título da regra',
+	'ACP_RULE_TITLE_EXPLAIN'				=> 'Os Títulos das Regras são exibidos na página de regras apenas para categorias de regras. Títulos das regras também são usados para identificar as regras na gestão do ACP.',
+	'ACP_RULE_ANCHOR'						=> 'Regra âncora',
+	'ACP_RULE_ANCHOR_EXPLAIN'				=> 'Âncoras de regras são opcionais e usadas como pontos de ligação de ancoragem na página regras. Devem ser URL amigáveis (não podem conter espaços ou caracteres especiais), devem começar com uma letra, e devem ser exclusivos.',
+	'ACP_RULE_MESSAGE'						=> 'Mensagem da regra',
+	'ACP_RULE_MESSAGE_EXPLAIN'				=> 'A mensagem da regra é exibida na página de regra para cada regra (categorias não exibem mensagens das regras).',
+	'ACP_RULE_MESSAGE_DISABLED'				=> 'Esta é uma categoria que contém regras, o editor mensagem foi desativado.',
+	'ACP_ADD_RULE'							=> 'Criar nova regra',
+	'ACP_DELETE_RULE_CONFIRM'				=> array(
+		0 => 'Tem a certeza que deseja eliminar esta regra?',
+		1 => 'Tem a certeza que deseja eliminar esta categoria de regra?<br />Aviso: Removendo um categoria de regra irá remover todas as regras contidas dentro dela.',
+	),
+	'ACP_RULE_ADDED'						=> 'Regra criada com sucesso.',
+	'ACP_RULE_DELETED'						=> 'Regra eliminada com sucesso.',
+	'ACP_RULE_EDITED'						=> 'Regra editada com sucesso.',
+	'ACP_RULE_TITLE_EMPTY'					=> 'Tem que dar um titulo à regra.',
+
+	// Nested set exception messages (only appears in PHP error logging)
+	// Translators: Feel free to not translate these language strings
+	'RULES_NESTEDSET_LOCK_FAILED_ACQUIRE'	=> 'Board rules failed to acquire the table lock. Another process may be holding the lock. Locks are forcibly released after a timeout of 1 hour.',
+	'RULES_NESTEDSET_INVALID_ITEM'			=> 'The requested rule does not exist.',
+	'RULES_NESTEDSET_INVALID_PARENT'		=> 'The requested rule has no parent.',
+));
diff --git "[FORUM_EXT]/phpbb\\boardrules/language/pt_preao/boardrules_common.php" "[FORUM_EXT]/phpbb\\boardrules/language/pt_preao/boardrules_common.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/phpbb\\boardrules/language/pt_preao/boardrules_common.php"
@@ -0,0 +1,47 @@
+<?php
+/**
+*
+* Board Rules extension for the phpBB Forum Software package.
+* @Traduzido por: http://phpbbportugal.com - segundo as normas do Acordo Ortográfico
+*
+* @copyright (c) 2013 phpBB Limited <https://www.phpbb.com>
+* @license GNU General Public License, version 2 (GPL-2.0)
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
+$lang = array_merge($lang, array(
+	'BOARDRULES'				=> 'Regras',
+	'BOARDRULES_TITLE'			=> 'Ver as regras deste Fórum',
+	'BOARDRULES_AGREEMENT'		=> 'Concorda em respeitar as regras deste fórum estabelecidas na secção “Regras”',
+	'BOARDRULES_VIEWONLINE'		=> 'A ler as regras do Fórum',
+	'BOARDRULES_NOTIFICATION'	=> 'As regras do Fórum foram actualizadas. Clique aqui para as rever.',
+));
diff --git "[FORUM_EXT]/phpbb\\boardrules/language/pt_preao/boardrules_controller.php" "[FORUM_EXT]/phpbb\\boardrules/language/pt_preao/boardrules_controller.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/phpbb\\boardrules/language/pt_preao/boardrules_controller.php"
@@ -0,0 +1,48 @@
+<?php
+/**
+*
+* Board Rules extension for the phpBB Forum Software package.
+* @Traduzido por: http://phpbbportugal.com - segundo as normas do Acordo Ortográfico
+*
+* @copyright (c) 2014 phpBB Limited <https://www.phpbb.com>
+* @license GNU General Public License, version 2 (GPL-2.0)
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
+$lang = array_merge($lang, array(
+	'BOARDRULES_HEADER'			=> 'Regras do Fórum',
+	'BOARDRULES_EXPLAIN'		=> 'Estas regras servem para esclarecer as várias responsabilidades de todos os membros da comunidade %s. Devem ser respeitadas por todos para garantir que o nosso Fórum funciona sem problemas e oferece uma experiência divertida e produtiva para todos os membros da comunidade.',
+	'BOARDRULES_CATEGORIES'		=> 'Secções de Regras',
+	'BOARDRULES_CATEGORY_ANCHOR'=> 'seccao-%s',
+	'BOARDRULES_RULE_ANCHOR'	=> 'regra-%s',
+	'BOARDRULES_REGISTERED'		=> 'Precisa de estar registado para ter acesso às regras',
+));
diff --git "[FORUM_EXT]/phpbb\\boardrules/language/pt_preao/boardrules_install.php" "[FORUM_EXT]/phpbb\\boardrules/language/pt_preao/boardrules_install.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/phpbb\\boardrules/language/pt_preao/boardrules_install.php"
@@ -0,0 +1,49 @@
+<?php
+/**
+*
+* Board Rules extension for the phpBB Forum Software package.
+* @Traduzido por: http://phpbbportugal.com - segundo as normas do Acordo Ortográfico
+*
+* @copyright (c) 2014 phpBB Limited <https://www.phpbb.com>
+* @license GNU General Public License, version 2 (GPL-2.0)
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
+$lang = array_merge($lang, array(
+	'BOARDRULES_SAMPLE_CATEGORY_TITLE'		=> 'Examplo Regra Categoria',
+	'BOARDRULES_SAMPLE_CATEGORY_MESSAGE'	=> 'Esta é uma categoria de exemplo das Regras do Fórum. Categorias contêm grupos de regras relacionadas. Mensagens Categoria (como esta) não são exibidas na página de regras.',
+	'BOARDRULES_SAMPLE_CATEGORY_ANCHOR'		=> 'examplo-categoria',
+
+	'BOARDRULES_SAMPLE_RULE_TITLE'			=> 'Examplo de Regra',
+	'BOARDRULES_SAMPLE_RULE_MESSAGE'		=> 'Esta é uma Regras de exemplo das Regras do Fórum. Tudo parece funcionar bem. Pode editar ou excluir esta regra e categoria e continuar a configurar suas próprias regras deste Fórum.',
+	'BOARDRULES_SAMPLE_RULE_ANCHOR'			=> 'examplo-regra',
+));
diff --git "[FORUM_EXT]/phpbb\\boardrules/language/pt_preao/exceptions.php" "[FORUM_EXT]/phpbb\\boardrules/language/pt_preao/exceptions.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/phpbb\\boardrules/language/pt_preao/exceptions.php"
@@ -0,0 +1,62 @@
+<?php
+/**
+*
+* Board Rules extension for the phpBB Forum Software package.
+* @Traduzido por: http://phpbbportugal.com - segundo as normas do Acordo Ortográfico
+*
+* @copyright (c) 2014 phpBB Limited <https://www.phpbb.com>
+* @license GNU General Public License, version 2 (GPL-2.0)
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
+/*
+* These are errors which can be triggered by sending invalid data to the
+* boardrules extension API.
+*
+* These errors will never show to a user unless they are either modifying
+* the core boardrules extension code OR unless they are writing an extension
+* which makes calls to this extension.
+*
+* Translators: Feel free to not translate these language strings
+*/
+$lang = array_merge($lang, array(
+	'EXCEPTION_FIELD_MISSING'		=> 'Campo obrigatório em falta',
+	'EXCEPTION_INVALID_ARGUMENT'	=> 'O argumento especificado para `%1$s` é inválido. Razão: %2$s',
+	'EXCEPTION_OUT_OF_BOUNDS'		=> 'O Campo `%1$s` recebeu dados além do limite',
+	'EXCEPTION_TOO_LONG'			=> 'A entrada foi maior do que o máximo permitido.',
+	'EXCEPTION_NOT_UNIQUE'			=> 'A entrada não é única.',
+	'EXCEPTION_UNEXPECTED_VALUE'	=> 'O campo `%1$s` recebeu dados não previstos. Razão: %2$s',
+	'EXCEPTION_ILLEGAL_CHARACTERS'	=> 'A entrada tem caracteres inválidos.',
+
+	// Translators: do not change this
+	'EXCEPTION_WRONG_DATA_LANG'		=> $lang['WRONG_DATA_LANG'],
+));
diff --git "[FORUM_EXT]/phpbb\\boardrules/language/pt_preao/info_acp_boardrules.php" "[FORUM_EXT]/phpbb\\boardrules/language/pt_preao/info_acp_boardrules.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/phpbb\\boardrules/language/pt_preao/info_acp_boardrules.php"
@@ -0,0 +1,50 @@
+<?php
+/**
+*
+* Board Rules extension for the phpBB Forum Software package.
+* @Traduzido por: http://phpbbportugal.com - segundo as normas do Acordo Ortográfico
+*
+* @copyright (c) 2014 phpBB Limited <https://www.phpbb.com>
+* @license GNU General Public License, version 2 (GPL-2.0)
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
+$lang = array_merge($lang, array(
+	// ACP modules
+	'ACP_BOARDRULES'				=> 'Regras do Fórum',
+	'ACP_BOARDRULES_MANAGE'			=> 'Gerir regras',
+	'ACP_BOARDRULES_SETTINGS'		=> 'Configurar regras',
+
+	// ACP Logs
+	'ACP_BOARDRULES_SETTINGS_LOG'	=> '<strong>Configurações das regras do fórum foram alteradas</strong>',
+	'ACP_BOARDRULES_NOTIFY_LOG'		=> '<strong>Enviadas notificações das regras a todos os utilizadores</strong>',
+));
diff --git "[FORUM_EXT]/phpbb\\boardrules/language/pt_preao/permissions_boardrules.php" "[FORUM_EXT]/phpbb\\boardrules/language/pt_preao/permissions_boardrules.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/phpbb\\boardrules/language/pt_preao/permissions_boardrules.php"
@@ -0,0 +1,43 @@
+<?php
+/**
+*
+* Board Rules extension for the phpBB Forum Software package.
+* @Traduzido por: http://phpbbportugal.com - segundo as normas do Acordo Ortográfico
+*
+* @copyright (c) 2014 phpBB Limited <https://www.phpbb.com>
+* @license GNU General Public License, version 2 (GPL-2.0)
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
+$lang = array_merge($lang, array(
+	'ACL_A_BOARDRULES'		=> 'Pode administrar as regras do fórum',
+));
diff --git "[FORUM_EXT]/phpbb\\boardrules/styles/BBOOTS/template/boardrules_controller.html" "[FORUM_EXT]/phpbb\\boardrules/styles/BBOOTS/template/boardrules_controller.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/phpbb\\boardrules/styles/BBOOTS/template/boardrules_controller.html"
@@ -0,0 +1,54 @@
+{% INCLUDECSS '@phpbb_boardrules/boardrules_controller.css' %}
+{% INCLUDE 'overall_header.html' %}
+<div class="row bs-docs-container">
+<div class="col-md-9">
+	<div class="side-segment"><h3>{L_BOARDRULES_HEADER}</h3></div>
+	<div class="content panel">
+	 <div class="panel-body">
+		<p>{BOARDRULES_EXPLAIN}</p>
+		<ol class="boardrules-rules{{ BOARDRULES_LIST_STYLE ? ' br-list-style-' ~ BOARDRULES_LIST_STYLE }}" id="rules">
+			{% for rules in loops.rules %}
+				{% if rules.S_CLOSE_LIST %}
+						</ol>
+					</li>
+				{% elseif rules.S_IS_CATEGORY %}
+					<li id="{{ rules.U_ANCHOR }}">
+						<h3 class="rule-heading">{{ rules.TITLE }}</h3>
+						<ol>
+				{% else %}
+							<li class="rule-item" id="{{ rules.U_ANCHOR }}">
+								{{ rules.MESSAGE }} <a class="rule-anchor postlink" href="#{{ rules.U_ANCHOR }}">&#35;</a>
+							</li>
+				{% endif %}
+			{% endfor %}
+		</ol>
+	 </div>	
+	</div>
+</div>
+
+{% if S_CATEGORIES %}
+<div class="col-md-3 scrollspy hidden-xs hidden-sm">
+ <div class="side-segment"><h3>{{ lang('BOARDRULES_CATEGORIES') }}</h3></div>
+    <div role="complementary" class="bs-sidebar hidden-print">
+		<ul id="nav" class="nav bs-sidenav" data-spy="affix">
+			{% for rules in loops.rules %}
+				{% if rules.S_IS_CATEGORY %}<li><a href="#{{ rules.U_ANCHOR }}">{{ rules.TITLE }}</a></li>{% endif %}
+			{% endfor %}
+		</ul>
+	</div>	
+</div>
+{% endif %}
+
+<script>
+head.ready(function () {
+   $('#nav').affix({
+    offset: {
+        top: $('#nav').offset().top,
+        bottom: $('footer').outerHeight(true) + $('.section-page').outerHeight(true) + 432
+    }
+});
+});
+</script>
+</div>
+{% INCLUDEJS '@phpbb_boardrules/boardrules_controller.js' %}
+{% INCLUDE 'overall_footer.html' %}
diff --git "[FORUM_EXT]/phpbb\\boardrules/styles/BBOOTS/template/event/overall_header_navigation_append.html" "[FORUM_EXT]/phpbb\\boardrules/styles/BBOOTS/template/event/overall_header_navigation_append.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/phpbb\\boardrules/styles/BBOOTS/template/event/overall_header_navigation_append.html"
@@ -0,0 +1,3 @@
+<!-- IF S_BOARDRULES_LINK_ENABLED-->
+	<li class="icon-boardrules"><a href="{U_BOARDRULES}" role="menuitem"><i class="fa fa-book"></i>&nbsp;{L_BOARDRULES}</a><span></span></li>
+<!-- ENDIF -->
diff --git "[FORUM_EXT]/phpbb\\boardrules/styles/BBOOTS/template/event/ucp_agreement_terms_before.html" "[FORUM_EXT]/phpbb\\boardrules/styles/BBOOTS/template/event/ucp_agreement_terms_before.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/phpbb\\boardrules/styles/BBOOTS/template/event/ucp_agreement_terms_before.html"
@@ -0,0 +1,3 @@
+<!-- IF S_BOARDRULES_AT_REGISTRATION and not S_SHOW_COPPA -->
+	<p><strong>&#42;&#42;&#42;&nbsp;</strong>{L_BOARDRULES_AGREEMENT}{L_COLON}&nbsp;<a href="{U_BOARDRULES}" title="{L_BOARDRULES_TITLE}" target="_blank"><strong>{L_BOARDRULES_TITLE}</strong></a></p>
+<!-- ENDIF -->
diff --git "[FORUM_EXT]/phpbb\\boardrules/styles/BBOOTS/template/js/boardrules_controller.js" "[FORUM_EXT]/phpbb\\boardrules/styles/BBOOTS/template/js/boardrules_controller.js"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/phpbb\\boardrules/styles/BBOOTS/template/js/boardrules_controller.js"
@@ -0,0 +1,20 @@
+head.ready(function () {
+$(function() {
+
+  'use strict';
+
+	// Function to apply highlight class to an element identifier
+	var highlight = function (id) {
+		$('#' + decodeURIComponent(id)).addClass('bg-info');
+	};
+
+	// Apply highlight to clicked rule anchor
+	$('.rule-anchor').on('click', function () {
+		$('li').removeClass('bg-info');
+		highlight($(this).closest('.rule-item').attr('id'));
+	});
+
+	// Apply highlight on page load to a rule category
+	highlight(window.location.hash.substring(1));
+});
+});
\ No newline at end of file
diff --git "[FORUM_EXT]/phpbb\\boardrules/styles/BBOOTS/theme/boardrules_controller.css" "[FORUM_EXT]/phpbb\\boardrules/styles/BBOOTS/theme/boardrules_controller.css"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/phpbb\\boardrules/styles/BBOOTS/theme/boardrules_controller.css"
@@ -0,0 +1,87 @@
+/**
+* Some CSS adapted from phpBB.com rules page
+*/
+
+.bs-sidenav {
+    background-color: #f7f5fa;
+    border-radius: 5px;
+    margin-bottom: 30px;
+    padding-bottom: 10px;
+    padding-top: 10px;
+    text-shadow: 0 1px 0 #fff;
+}
+
+.bs-sidebar .nav > li > a {
+    color: #716b7a;
+    display: block;
+    padding: 5px 20px;
+}
+
+.bs-sidebar .nav > li > a:hover, .bs-sidebar .nav > li > a:focus {
+    background-color: #e5e3e9;
+    border-right: 2px solid #26BCB5;
+    text-decoration: none;
+}
+
+.bs-sidebar .nav > .active > a, .bs-sidebar .nav > .active:hover > a, .bs-sidebar .nav > .active:focus > a {
+    background-color: transparent;
+    border-right: 2px solid #26BCB5;
+    color: #26BCB5;
+    font-weight: bold;
+}
+.bs-sidebar .nav .nav {
+    display: none;
+    margin-bottom: 8px;
+}
+.bs-sidebar .nav .nav > li > a {
+    font-size: 90%;
+    padding-bottom: 3px;
+    padding-left: 30px;
+    padding-top: 3px;
+}
+
+.bs-sidebar.affix-bottom, .bs-sidebar.affix {
+    width: 263px;
+}
+
+.bs-sidebar.affix {
+    position: fixed;
+    top: 0;
+}
+
+.bs-sidebar .nav > .active > ul {
+    display: block;
+}
+.bs-sidebar .nav .nav {
+    display: none;
+    margin-bottom: 8px;
+}
+
+
+.bs-docs-container .affix {
+  top: 20px;
+  width: 213px;
+}
+ 
+@media (min-width: 1200px) {
+  .bs-docs-container .affix {
+    width: 263px;
+  }         
+}
+
+.bs-docs-container .affix-bottom {
+  position: absolute;
+  width: 213px;
+}
+ 
+@media (min-width: 1200px) {
+  .bs-docs-container .affix-bottom {
+    width: 263px;
+  }
+}
+
+#rules > li {
+    padding-top: 20px;
+}
+
+
diff --git "[FORUM_EXT]/phpbb\\boardrules/styles/FLATBOOTS/template/boardrules_controller.html" "[FORUM_EXT]/phpbb\\boardrules/styles/FLATBOOTS/template/boardrules_controller.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/phpbb\\boardrules/styles/FLATBOOTS/template/boardrules_controller.html"
@@ -0,0 +1,75 @@
+{% INCLUDECSS '@phpbb_boardrules/boardrules_controller.css' %}
+{% INCLUDE 'overall_header.html' %}
+
+{% if not S_IS_BOT %}
+<div class="row bs-docs-container">
+	<div class="col-md-9">
+		<div class="side-segment">
+			<h3>{{ lang('BOARDRULES_HEADER') }}</h3>
+		</div>
+		<div class="content panel">
+			<div class="panel-body">
+				<p>{{ BOARDRULES_EXPLAIN }}</p>
+				<ol id="rules" class="boardrules-rules{{ BOARDRULES_LIST_STYLE ? ' br-list-style-' ~ BOARDRULES_LIST_STYLE }}">
+					{% for rules in loops.rules %}
+					{% if rules.S_CLOSE_LIST %}
+				</ol>
+				</li>
+				{% elseif rules.S_IS_CATEGORY %}
+				<li id="{{ rules.U_ANCHOR }}">
+					<h3 class="rule-heading"><a class="rule-anchor postlink" href="#{{ rules.U_ANCHOR }}">{{ rules.TITLE }}</a></h3>
+					<ol{{ BOARDRULES_LIST_STYLE ? ' class="br-list-style-' ~ BOARDRULES_LIST_STYLE ~ '"' }}>
+						{% elseif rules.MESSAGE %}
+				<li class="rule-item" id="{{ rules.U_ANCHOR }}">
+					{{ rules.MESSAGE }}
+				</li>
+				{% endif %}
+				{% endfor %}
+				</ol>
+			</div>
+		</div>
+	</div>
+
+	{% if S_CATEGORIES %}
+	<div class="col-md-3 scrollspy hidden-xs hidden-sm">
+		<div class="side-segment">
+			<h3>{{ lang('BOARDRULES_CATEGORIES') }}</h3>
+		</div>
+		<div role="complementary" class="bs-sidebar hidden-print">
+			<ul id="nav" class="nav bs-sidenav" data-spy="affix">
+				{% for rules in loops.rules %}
+				{% if rules.S_IS_CATEGORY %}<li><a href="#{{ rules.U_ANCHOR }}">{{ rules.TITLE }}</a></li>{% endif %}
+				{% endfor %}
+			</ul>
+		</div>
+	</div>
+	{% endif %}
+
+	<script>
+		head.ready(function () {
+			$('#nav').affix({
+				offset: {
+					top: $('#nav').offset().top,
+					bottom: $('footer').outerHeight(true) + $('.section-page').outerHeight(true) + 432
+				}
+			});
+		});
+	</script>
+</div>
+{% else %}
+<div class="row bs-docs-container">
+	<div class="col-md-12">
+		<div class="side-segment">
+			<h3>{{ lang('BOARDRULES_HEADER') }}</h3>
+		</div>
+		<div class="content panel">
+			<div class="panel-body">
+				<span>{{ lang('BOARDRULES_REGISTERED') }}</span>
+			</div>
+		</div>
+	</div>
+</div>
+{% endif %}
+
+{% INCLUDEJS '@phpbb_boardrules/boardrules_controller.js' %}
+{% INCLUDE 'overall_footer.html' %}
\ No newline at end of file
diff --git "[FORUM_EXT]/phpbb\\boardrules/styles/FLATBOOTS/template/event/overall_header_navigation_append.html" "[FORUM_EXT]/phpbb\\boardrules/styles/FLATBOOTS/template/event/overall_header_navigation_append.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/phpbb\\boardrules/styles/FLATBOOTS/template/event/overall_header_navigation_append.html"
@@ -0,0 +1,3 @@
+<!-- IF S_BOARDRULES_LINK_ENABLED -->
+	<li class="icon-boardrules"><a href="{U_BOARDRULES}" role="menuitem"><i class="fa fa-book"></i>{L_BOARDRULES}</a></li>
+<!-- ENDIF -->
diff --git "[FORUM_EXT]/phpbb\\boardrules/styles/FLATBOOTS/template/event/ucp_agreement_terms_before.html" "[FORUM_EXT]/phpbb\\boardrules/styles/FLATBOOTS/template/event/ucp_agreement_terms_before.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/phpbb\\boardrules/styles/FLATBOOTS/template/event/ucp_agreement_terms_before.html"
@@ -0,0 +1,3 @@
+<!-- IF S_BOARDRULES_AT_REGISTRATION and not S_SHOW_COPPA -->
+	<p><strong>&#42;&#42;&#42;&nbsp;</strong>{L_BOARDRULES_AGREEMENT}{L_COLON}&nbsp;<a href="{U_BOARDRULES}" title="{L_BOARDRULES_TITLE}" target="_blank"><strong>{L_BOARDRULES_TITLE}</strong></a></p>
+<!-- ENDIF -->
diff --git "[FORUM_EXT]/phpbb\\boardrules/styles/FLATBOOTS/template/js/boardrules_controller.bak.js" "[FORUM_EXT]/phpbb\\boardrules/styles/FLATBOOTS/template/js/boardrules_controller.bak.js"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/phpbb\\boardrules/styles/FLATBOOTS/template/js/boardrules_controller.bak.js"
@@ -0,0 +1,20 @@
+head.ready(function () {
+$(function() {
+
+  'use strict';
+
+	// Function to apply highlight class to an element identifier
+	var highlight = function (id) {
+		$('#' + decodeURIComponent(id)).addClass('bg-info');
+	};
+
+	// Apply highlight to clicked rule anchor
+	$('.rule-anchor').on('click', function () {
+		$('li').removeClass('bg-info');
+		highlight($(this).closest('.rule-item').attr('id'));
+	});
+
+	// Apply highlight on page load to a rule category
+	highlight(window.location.hash.substring(1));
+});
+});
\ No newline at end of file
diff --git "[FORUM_EXT]/phpbb\\boardrules/styles/FLATBOOTS/template/js/boardrules_controller.js" "[FORUM_EXT]/phpbb\\boardrules/styles/FLATBOOTS/template/js/boardrules_controller.js"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/phpbb\\boardrules/styles/FLATBOOTS/template/js/boardrules_controller.js"
@@ -0,0 +1 @@
+head.ready(function(){$(function(){"use strict";var n=function(n){$("#"+decodeURIComponent(n)).addClass("bg-info")};$(".rule-anchor").on("click",function(){$("li").removeClass("bg-info"),n($(this).closest(".rule-item").attr("id"))}),n(window.location.hash.substring(1))})});
\ No newline at end of file
diff --git "[FORUM_EXT]/phpbb\\boardrules/styles/FLATBOOTS/theme/boardrules_controller.bak.css" "[FORUM_EXT]/phpbb\\boardrules/styles/FLATBOOTS/theme/boardrules_controller.bak.css"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/phpbb\\boardrules/styles/FLATBOOTS/theme/boardrules_controller.bak.css"
@@ -0,0 +1,87 @@
+/**
+* Some CSS adapted from phpBB.com rules page
+*/
+
+.bs-sidenav {
+    background-color: #f7f5fa;
+    border-radius: 5px;
+    margin-bottom: 30px;
+    padding-bottom: 10px;
+    padding-top: 10px;
+    text-shadow: 0 1px 0 #fff;
+}
+
+.bs-sidebar .nav > li > a {
+    color: #716b7a;
+    display: block;
+    padding: 5px 20px;
+}
+
+.bs-sidebar .nav > li > a:hover, .bs-sidebar .nav > li > a:focus {
+    background-color: #e5e3e9;
+    border-right: 2px solid #26BCB5;
+    text-decoration: none;
+}
+
+.bs-sidebar .nav > .active > a, .bs-sidebar .nav > .active:hover > a, .bs-sidebar .nav > .active:focus > a {
+    background-color: transparent;
+    border-right: 2px solid #26BCB5;
+    color: #26BCB5;
+    font-weight: bold;
+}
+.bs-sidebar .nav .nav {
+    display: none;
+    margin-bottom: 8px;
+}
+.bs-sidebar .nav .nav > li > a {
+    font-size: 90%;
+    padding-bottom: 3px;
+    padding-left: 30px;
+    padding-top: 3px;
+}
+
+.bs-sidebar.affix-bottom, .bs-sidebar.affix {
+    width: 263px;
+}
+
+.bs-sidebar.affix {
+    position: fixed;
+    top: 0;
+}
+
+.bs-sidebar .nav > .active > ul {
+    display: block;
+}
+.bs-sidebar .nav .nav {
+    display: none;
+    margin-bottom: 8px;
+}
+
+
+.bs-docs-container .affix {
+  top: 20px;
+  width: 213px;
+}
+ 
+@media (min-width: 1200px) {
+  .bs-docs-container .affix {
+    width: 263px;
+  }         
+}
+
+.bs-docs-container .affix-bottom {
+  position: absolute;
+  width: 213px;
+}
+ 
+@media (min-width: 1200px) {
+  .bs-docs-container .affix-bottom {
+    width: 263px;
+  }
+}
+
+#rules > li {
+    padding-top: 20px;
+}
+
+
diff --git "[FORUM_EXT]/phpbb\\boardrules/styles/FLATBOOTS/theme/boardrules_controller.css" "[FORUM_EXT]/phpbb\\boardrules/styles/FLATBOOTS/theme/boardrules_controller.css"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/phpbb\\boardrules/styles/FLATBOOTS/theme/boardrules_controller.css"
@@ -0,0 +1 @@
+.bs-sidenav{background-color:#f7f5fa;border-radius:5px;margin-bottom:30px;padding-bottom:10px;padding-top:10px;text-shadow:0 1px 0 #fff}.bs-sidebar .nav > li > a{color:#716b7a;display:block;padding:5px 20px}.bs-sidebar .nav > li > a:hover,.bs-sidebar .nav > li > a:focus{background-color:#e5e3e9;border-right:2px solid #26BCB5;text-decoration:none}.bs-sidebar .nav > .active > a,.bs-sidebar .nav > .active:hover > a,.bs-sidebar .nav > .active:focus > a{background-color:transparent;border-right:2px solid #26BCB5;color:#26BCB5;font-weight:700}.bs-sidebar .nav .nav{display:none;margin-bottom:8px}.bs-sidebar .nav .nav > li > a{font-size:90%;padding-bottom:3px;padding-left:30px;padding-top:3px}.bs-sidebar.affix-bottom,.bs-sidebar.affix{width:263px}.bs-sidebar.affix{position:fixed;top:0}.bs-sidebar .nav > .active > ul{display:block}.bs-sidebar .nav .nav{display:none;margin-bottom:8px}.bs-docs-container .affix{top:20px;width:213px;z-index:1}@media (min-width: 1200px){.bs-docs-container .affix{width:320px}}.bs-docs-container .affix-bottom{position:absolute;width:213px;z-index:1}@media (min-width: 1200px){.bs-docs-container .affix-bottom{width:320px}}#rules > li{padding-top:20px}.content .br-list-style-disc{list-style-type:disc}.content .br-list-style-none{list-style-type:none}.content > .br-list-style-none{margin-left:0}.rtl .content > .br-list-style-none{margin-right:0}
\ No newline at end of file
```
