Existem diferencas reais no codigo ou texto. Diferencas de formatacao (espacos, tabs) foram ignoradas abaixo.

```diff
diff --git "[ORIGINAL]/sitesplat\\bbwatchlist/bbwatchlist/bbwatchlist.php" "[FORUM_EXT]/sitesplat\\bbwatchlist/bbwatchlist/bbwatchlist.php"
--- "[ORIGINAL]/sitesplat\\bbwatchlist/bbwatchlist/bbwatchlist.php"
+++ "[FORUM_EXT]/sitesplat\\bbwatchlist/bbwatchlist/bbwatchlist.php"
@@ -79,6 +79,7 @@ class bbwatchlist
 				FROM ' . $this->watch_keywords_table . '
 				WHERE user_id <> ' . $this->user->data['user_id'];
 		$result = $this->db->sql_query($sql);
+
 		while ($row = $this->db->sql_fetchrow($result))
 		{
 			if ($row['search_type'] == type::SEARCH_TYPE_POST_CONTENT)
@@ -88,9 +89,9 @@ class bbwatchlist
 					$this->notifications->add_notifications('sitesplat.bbwatchlist.notification.type.content_keyword', [
 						'user_ids'	=> [$row['user_id']],
 						'keyword'	=> $row['keyword'],
-						'post_id'	=> $post_data['post_id'],
-						'topic_id'	=> $post_data['topic_id'],
-						'forum_id'	=> $post_data['forum_id'],
+						'post_id'	=> is_array($post_data) ? $post_data['post_id'] : 0,
+						'topic_id'	=> is_array($post_data) ? $post_data['topic_id'] : 0,
+						'forum_id'	=> is_array($post_data) ? $post_data['forum_id'] : 0,
 					]);
 				}
 			} elseif (!empty($this->topic_subject))
@@ -100,9 +101,9 @@ class bbwatchlist
 					$this->notifications->add_notifications('sitesplat.bbwatchlist.notification.type.subject_keyword', [
 						'user_ids'	=> [$row['user_id']],
 						'keyword'	=> $row['keyword'],
-						'post_id'	=> $post_data['post_id'],
-						'topic_id'	=> $post_data['topic_id'],
-						'forum_id'	=> $post_data['forum_id'],
+						'post_id'	=> is_array($post_data) ? $post_data['post_id'] : 0,
+						'topic_id'	=> is_array($post_data) ? $post_data['topic_id'] : 0,
+						'forum_id'	=> is_array($post_data) ? $post_data['forum_id'] : 0,
 					]);
 				}
 			}
diff --git "[FORUM_EXT]/sitesplat\\bbwatchlist/diff_full.tmp" "[FORUM_EXT]/sitesplat\\bbwatchlist/diff_full.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\bbwatchlist/diff_full.tmp"
@@ -0,0 +1,345 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbwatchlist/bbwatchlist/bbwatchlist.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbwatchlist/bbwatchlist/bbwatchlist.php"
+index 58f8851be..83ce3d219 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbwatchlist/bbwatchlist/bbwatchlist.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbwatchlist/bbwatchlist/bbwatchlist.php"
+@@ -79,6 +79,7 @@ class bbwatchlist
+ 				FROM ' . $this->watch_keywords_table . '
+ 				WHERE user_id <> ' . $this->user->data['user_id'];
+ 		$result = $this->db->sql_query($sql);
++
+ 		while ($row = $this->db->sql_fetchrow($result))
+ 		{
+ 			if ($row['search_type'] == type::SEARCH_TYPE_POST_CONTENT)
+@@ -88,9 +89,9 @@ class bbwatchlist
+ 					$this->notifications->add_notifications('sitesplat.bbwatchlist.notification.type.content_keyword', [
+ 						'user_ids'	=> [$row['user_id']],
+ 						'keyword'	=> $row['keyword'],
+-						'post_id'	=> $post_data['post_id'],
+-						'topic_id'	=> $post_data['topic_id'],
+-						'forum_id'	=> $post_data['forum_id'],
++						'post_id'	=> is_array($post_data) ? $post_data['post_id'] : 0,
++						'topic_id'	=> is_array($post_data) ? $post_data['topic_id'] : 0,
++						'forum_id'	=> is_array($post_data) ? $post_data['forum_id'] : 0,
+ 					]);
+ 				}
+ 			} elseif (!empty($this->topic_subject))
+@@ -100,9 +101,9 @@ class bbwatchlist
+ 					$this->notifications->add_notifications('sitesplat.bbwatchlist.notification.type.subject_keyword', [
+ 						'user_ids'	=> [$row['user_id']],
+ 						'keyword'	=> $row['keyword'],
+-						'post_id'	=> $post_data['post_id'],
+-						'topic_id'	=> $post_data['topic_id'],
+-						'forum_id'	=> $post_data['forum_id'],
++						'post_id'	=> is_array($post_data) ? $post_data['post_id'] : 0,
++						'topic_id'	=> is_array($post_data) ? $post_data['topic_id'] : 0,
++						'forum_id'	=> is_array($post_data) ? $post_data['forum_id'] : 0,
+ 					]);
+ 				}
+ 			}
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbwatchlist/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbwatchlist/diff_full.tmp"
+new file mode 100644
+index 000000000..e69de29bb
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbwatchlist/language/en/info_ucp_bbwatchlist.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbwatchlist/language/en/info_ucp_bbwatchlist.php"
+index 968b4bfe5..422e4826e 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbwatchlist/language/en/info_ucp_bbwatchlist.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbwatchlist/language/en/info_ucp_bbwatchlist.php"
+@@ -33,7 +33,8 @@ $lang = array_merge($lang, array(
+ 
+ 	'KEYWORD_EMPTY'		=> 'Oops! You didn\'t enter a keyword.',
+ 	'KEYWORD_PATTERN'	=> '3 to 50 characters',
+-	'KEYWORD_TOO_LONG'	=> 'Keyword is too long. Maximum length of one keyword is 255 characters',
++	'KEYWORD_TOO_SHORT'	=> 'Keyword is too short. Minimum length of one keyword is 3 characters',
++	'KEYWORD_TOO_LONG'	=> 'Keyword is too long. Maximum length of one keyword is 50 characters',
+ 	'KEYWORD_EXISTS'	=> 'You already have such keyword defined.',
+ 	'KEYWORD_ADDED'		=> 'Keyword has been added',
+ 	'KEYWORD_DELETED'	=> 'Keyword has been deleted',
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbwatchlist/language/pt/common.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbwatchlist/language/pt/common.php"
+new file mode 100644
+index 000000000..4e51f6da4
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbwatchlist/language/pt/common.php"
+@@ -0,0 +1,26 @@
++<?php
++/**
++ *
++ * BBwatchlist. An extension for the phpBB Forum Software package.
++ *
++ * @copyright (c) 2018 SiteSplat All rights reserved
++ * @license Proprietary
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
++	$lang = array();
++}
++
++$lang = array_merge($lang, array(
++	'SUBJECT_KEYWORD_NOTIFICATION_TITLE'	=> 'Uma palavra-chave que segues foi encontrada no título de um tópico',
++	'SUBJECT_KEYWORD_NOTIFICATION_CONTENT'	=> 'A palavra-chave "%s" surgiu no título de um novo tópico.',
++	'CONTENT_KEYWORD_NOTIFICATION_TITLE'	=> 'Uma palavra-chave que segues foi encontrada no conteúdo de uma mensagem',
++	'CONTENT_KEYWORD_NOTIFICATION_CONTENT'	=> 'A palavra-chave "%s" surgiu no conteúdo de uma nova mensagem.',
++));
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbwatchlist/language/pt/email/content_keyword.txt" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbwatchlist/language/pt/email/content_keyword.txt"
+new file mode 100644
+index 000000000..4eb539a07
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbwatchlist/language/pt/email/content_keyword.txt"
+@@ -0,0 +1,8 @@
++Assunto: Palavra-chave encontrada no conteúdo de uma mensagem
++
++Olá,
++
++a palavra-chave "{KEYWORD}" que segues foi encontrada no conteúdo de uma mensagem. Clica aqui para veres:
++{U_TOPIC_LINK}
++
++{EMAIL_SIG}
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbwatchlist/language/pt/email/subject_keyword.txt" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbwatchlist/language/pt/email/subject_keyword.txt"
+new file mode 100644
+index 000000000..02a8e8c9e
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbwatchlist/language/pt/email/subject_keyword.txt"
+@@ -0,0 +1,8 @@
++Assunto: Palavra-chave encontrada no título de um tópico
++
++Olá,
++
++a palavra-chave "{KEYWORD}" que segues foi encontrada no título de um tópico. Clica aqui para veres:
++{U_TOPIC_LINK}
++
++{EMAIL_SIG}
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbwatchlist/language/pt/info_ucp_bbwatchlist.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbwatchlist/language/pt/info_ucp_bbwatchlist.php"
+new file mode 100644
+index 000000000..58c6216bb
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbwatchlist/language/pt/info_ucp_bbwatchlist.php"
+@@ -0,0 +1,46 @@
++<?php
++/**
++ *
++ * BBwatchlist. An extension for the phpBB Forum Software package.
++ *
++ * @copyright (c) 2018 SiteSplat All rights reserved
++ * @license Proprietary
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
++	$lang = array();
++}
++
++$lang = array_merge($lang, array(
++	'UCP_SITESPLAT_BBWATCHLIST'	=> 'Gerir a Minha Lista',
++
++	'KEYWORD'					=> 'Palavra-chave',
++	'SEARCH_TYPE'				=> 'Tipo de Pesquisa',
++	'ACTIONS'					=> 'Ações',
++	'KEYWORDS'					=> 'Palavras-chave',
++	'UCP_SITESPLAT_BBWATCHLIST_EXPLAIN'	=> 'Podes adicionar palavras-chave para seguir e ser notificado quando estas forem usadas em mensagens ou nos títulos dos tópicos',
++	'NO_UCP_KEYWORDS'			=> 'Não tens quaisquer palavras-chave definidas. Estás à espera de quê? Adiciona lá algumas!',
++	'ADD_NEW_KEYWORD'			=> 'Adicionar nova palavra-chave',
++	'SEARCH_TYPE_TOPIC_SUBJECT'	=> 'Correspondência no título dos tópicos',
++	'SEARCH_TYPE_POST_CONTENT'	=> 'Correspondência no conteúdo das mensagens',
++
++	'KEYWORD_EMPTY'		=> 'Ups! Não inseriste nenhuma palavra-chave.',
++	'KEYWORD_PATTERN'	=> '3 a 50 caracteres',
++	'KEYWORD_TOO_SHORT'	=> 'Palavra-chave demasiado curta. Tem de ter pelo menos 3 caracteres',
++	'KEYWORD_TOO_LONG'	=> 'Palavra-chave demasiado longa. Não pode ultrapassar os 50 caracteres',
++	'KEYWORD_EXISTS'	=> 'Outra vez arroz? Já tens essa palavra-chave definida.',
++	'KEYWORD_ADDED'		=> 'Palavra-chave adicionada',
++	'KEYWORD_DELETED'	=> 'Palavra-chave removida',
++
++	// Notifications
++	'NOTIFICATION_GROUP_BBWATCHLIST'	=> 'Watchlist',
++	'NOTIFICATION_TYPE_SUBJECT_KEYWORD'	=> 'Uma das tuas palavra-chave que segues foi detectada no título do tópico',
++	'NOTIFICATION_TYPE_CONTENT_KEYWORD'	=> 'Uma das tuas palavra-chave que segues foi detectada no conteúdo de uma mensagem',
++));
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbwatchlist/language/pt_preao/common.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbwatchlist/language/pt_preao/common.php"
+new file mode 100644
+index 000000000..4e51f6da4
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbwatchlist/language/pt_preao/common.php"
+@@ -0,0 +1,26 @@
++<?php
++/**
++ *
++ * BBwatchlist. An extension for the phpBB Forum Software package.
++ *
++ * @copyright (c) 2018 SiteSplat All rights reserved
++ * @license Proprietary
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
++	$lang = array();
++}
++
++$lang = array_merge($lang, array(
++	'SUBJECT_KEYWORD_NOTIFICATION_TITLE'	=> 'Uma palavra-chave que segues foi encontrada no título de um tópico',
++	'SUBJECT_KEYWORD_NOTIFICATION_CONTENT'	=> 'A palavra-chave "%s" surgiu no título de um novo tópico.',
++	'CONTENT_KEYWORD_NOTIFICATION_TITLE'	=> 'Uma palavra-chave que segues foi encontrada no conteúdo de uma mensagem',
++	'CONTENT_KEYWORD_NOTIFICATION_CONTENT'	=> 'A palavra-chave "%s" surgiu no conteúdo de uma nova mensagem.',
++));
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbwatchlist/language/pt_preao/email/content_keyword.txt" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbwatchlist/language/pt_preao/email/content_keyword.txt"
+new file mode 100644
+index 000000000..4eb539a07
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbwatchlist/language/pt_preao/email/content_keyword.txt"
+@@ -0,0 +1,8 @@
++Assunto: Palavra-chave encontrada no conteúdo de uma mensagem
++
++Olá,
++
++a palavra-chave "{KEYWORD}" que segues foi encontrada no conteúdo de uma mensagem. Clica aqui para veres:
++{U_TOPIC_LINK}
++
++{EMAIL_SIG}
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbwatchlist/language/pt_preao/email/subject_keyword.txt" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbwatchlist/language/pt_preao/email/subject_keyword.txt"
+new file mode 100644
+index 000000000..02a8e8c9e
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbwatchlist/language/pt_preao/email/subject_keyword.txt"
+@@ -0,0 +1,8 @@
++Assunto: Palavra-chave encontrada no título de um tópico
++
++Olá,
++
++a palavra-chave "{KEYWORD}" que segues foi encontrada no título de um tópico. Clica aqui para veres:
++{U_TOPIC_LINK}
++
++{EMAIL_SIG}
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbwatchlist/language/pt_preao/info_ucp_bbwatchlist.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbwatchlist/language/pt_preao/info_ucp_bbwatchlist.php"
+new file mode 100644
+index 000000000..32418da36
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbwatchlist/language/pt_preao/info_ucp_bbwatchlist.php"
+@@ -0,0 +1,46 @@
++<?php
++/**
++ *
++ * BBwatchlist. An extension for the phpBB Forum Software package.
++ *
++ * @copyright (c) 2018 SiteSplat All rights reserved
++ * @license Proprietary
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
++	$lang = array();
++}
++
++$lang = array_merge($lang, array(
++	'UCP_SITESPLAT_BBWATCHLIST'	=> 'Gerir a Minha Lista',
++
++	'KEYWORD'					=> 'Palavra-chave',
++	'SEARCH_TYPE'				=> 'Tipo de Pesquisa',
++	'ACTIONS'					=> 'Acções',
++	'KEYWORDS'					=> 'Palavras-chave',
++	'UCP_SITESPLAT_BBWATCHLIST_EXPLAIN'			=> 'Podes adicionar palavras-chave para seguir e ser notificado quando estas forem usadas em mensagens ou nos títulos dos tópicos',
++	'NO_UCP_KEYWORDS'			=> 'Não tens quaisquer palavras-chave definidas. Estás à espera de quê? Adiciona lá algumas!',
++	'ADD_NEW_KEYWORD'			=> 'Adicionar nova palavra-chave',
++	'SEARCH_TYPE_TOPIC_SUBJECT'	=> 'Correspondência no título dos tópicos',
++	'SEARCH_TYPE_POST_CONTENT'	=> 'Correspondência no conteúdo das mensagens',
++
++	'KEYWORD_EMPTY'		=> 'Ups! Não inseriste nenhuma palavra-chave.',
++	'KEYWORD_PATTERN'	=> '3 a 50 caracteres',
++	'KEYWORD_TOO_SHORT'	=> 'Palavra-chave demasiado curta. Tem de ter pelo menos 3 caracteres',
++	'KEYWORD_TOO_LONG'	=> 'Palavra-chave demasiado longa. Não pode ultrapassar os 50 caracteres',
++	'KEYWORD_EXISTS'	=> 'Outra vez arroz? Já tens essa palavra-chave definida.',
++	'KEYWORD_ADDED'		=> 'Palavra-chave adicionada',
++	'KEYWORD_DELETED'	=> 'Palavra-chave removida',
++
++	// Notifications
++	'NOTIFICATION_GROUP_BBWATCHLIST'	=> 'Watchlist',
++	'NOTIFICATION_TYPE_SUBJECT_KEYWORD'	=> 'Uma das tuas palavra-chave que segues foi detectada no título do tópico',
++	'NOTIFICATION_TYPE_CONTENT_KEYWORD'	=> 'Uma das tuas palavra-chave que segues foi detectada no conteúdo de uma mensagem',
++));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbwatchlist/styles/FLATBOOTS/template/bbwatchlist.js" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbwatchlist/styles/FLATBOOTS/template/bbwatchlist.js"
+index a291d2cdd..914ab1d5f 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbwatchlist/styles/FLATBOOTS/template/bbwatchlist.js"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbwatchlist/styles/FLATBOOTS/template/bbwatchlist.js"
+@@ -4,6 +4,10 @@ head.ready(function() {
+ 	phpbb.addAjaxCallback('remove_keyword', function() {
+ 		$(this).parent().parent().remove();
+ 
++		document.getElementById('keyword').value = '';
++		$('#delete_msg').slideToggle(200);
++		setTimeout(function(){$('#delete_msg').slideToggle(500);}, 2500);
++
+ 		// Reload page if there is no keyword left. It will display a nice
+ 		// information about it.
+ 		if ($('#bbwatchlist_keywords tr').length < 2)
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbwatchlist/styles/FLATBOOTS/template/ucp_bbwatchlist.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbwatchlist/styles/FLATBOOTS/template/ucp_bbwatchlist.html"
+index fe76440c1..3fa82c464 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbwatchlist/styles/FLATBOOTS/template/ucp_bbwatchlist.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbwatchlist/styles/FLATBOOTS/template/ucp_bbwatchlist.html"
+@@ -7,12 +7,13 @@
+ 	<p>{{ lang('UCP_SITESPLAT_BBWATCHLIST_EXPLAIN') }}</p>
+ 
+ 	<div id="success_msg" class="alert alert-success" style="display:none"><h4 style="margin:0">{{ lang('KEYWORD_ADDED') }}</h4></div>
++	<div id="delete_msg" class="alert alert-danger" style="display:none"><h4 style="margin:0">{{ lang('KEYWORD_DELETED') }}</h4></div>
+ 
+ <div class="side-segment"><h3>{{ lang('ADD_NEW_KEYWORD') }}</h3></div>
+ 
+ <form id="ucp" method="post" action="{S_UCP_ACTION}" data-ajax="add_keyword">
+ 	<div class="input-group">
+-		<input id="keyword" class="form-control" type="text" name="keyword" pattern=".{3,50}" required title="{{ lang('KEYWORD_PATTERN') }}">
++		<input id="keyword" class="form-control" type="text" name="keyword" pattern=".{3,50}" required title="{{ lang('KEYWORD_PATTERN') }}" placeholder="{{ lang('KEYWORD') ~ lang('COLON') }}">
+ 		<span class="input-group-btn">
+ 			<input class="btn btn-default" type="submit" value="{{ lang('SUBMIT') }}">
+ 		</span>
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbwatchlist/ucp/main_module.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbwatchlist/ucp/main_module.php"
+index 5205fb31a..f842ab0e6 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbwatchlist/ucp/main_module.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbwatchlist/ucp/main_module.php"
+@@ -56,7 +56,12 @@ class main_module
+ 					trigger_error('KEYWORD_EMPTY');
+ 				}
+ 
+-				if (strlen($keyword) > 255)
++				if (strlen($keyword) < 3)
++				{
++					trigger_error('KEYWORD_TOO_SHORT');
++				}
++
++				if (strlen($keyword) > 50)
+ 				{
+ 					trigger_error('KEYWORD_TOO_LONG');
+ 				}
+@@ -101,13 +106,6 @@ class main_module
+ 							AND user_id = ' . (int) $this->user->data['user_id'];
+ 				$this->db->sql_query($sql);
+ 
+-				$message = $this->language->lang('KEYWORD_DELETED');
+-				if (!$this->request->is_ajax())
+-				{
+-					$message .= '<br /><br />' . $this->language->lang('RETURN_UCP', '<a href="' . $this->u_action . '">', '</a>');
+-				}
+-				trigger_error($message);
+-
+ 			break;
+ 
+ 			default:
diff --git "[FORUM_EXT]/sitesplat\\bbwatchlist/diff_nospace.tmp" "[FORUM_EXT]/sitesplat\\bbwatchlist/diff_nospace.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\bbwatchlist/diff_nospace.tmp"
@@ -0,0 +1,324 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbwatchlist/bbwatchlist/bbwatchlist.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbwatchlist/bbwatchlist/bbwatchlist.php"
+index 58f8851be..83ce3d219 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbwatchlist/bbwatchlist/bbwatchlist.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbwatchlist/bbwatchlist/bbwatchlist.php"
+@@ -79,6 +79,7 @@ class bbwatchlist
+ 				FROM ' . $this->watch_keywords_table . '
+ 				WHERE user_id <> ' . $this->user->data['user_id'];
+ 		$result = $this->db->sql_query($sql);
++
+ 		while ($row = $this->db->sql_fetchrow($result))
+ 		{
+ 			if ($row['search_type'] == type::SEARCH_TYPE_POST_CONTENT)
+@@ -88,9 +89,9 @@ class bbwatchlist
+ 					$this->notifications->add_notifications('sitesplat.bbwatchlist.notification.type.content_keyword', [
+ 						'user_ids'	=> [$row['user_id']],
+ 						'keyword'	=> $row['keyword'],
+-						'post_id'	=> $post_data['post_id'],
+-						'topic_id'	=> $post_data['topic_id'],
+-						'forum_id'	=> $post_data['forum_id'],
++						'post_id'	=> is_array($post_data) ? $post_data['post_id'] : 0,
++						'topic_id'	=> is_array($post_data) ? $post_data['topic_id'] : 0,
++						'forum_id'	=> is_array($post_data) ? $post_data['forum_id'] : 0,
+ 					]);
+ 				}
+ 			} elseif (!empty($this->topic_subject))
+@@ -100,9 +101,9 @@ class bbwatchlist
+ 					$this->notifications->add_notifications('sitesplat.bbwatchlist.notification.type.subject_keyword', [
+ 						'user_ids'	=> [$row['user_id']],
+ 						'keyword'	=> $row['keyword'],
+-						'post_id'	=> $post_data['post_id'],
+-						'topic_id'	=> $post_data['topic_id'],
+-						'forum_id'	=> $post_data['forum_id'],
++						'post_id'	=> is_array($post_data) ? $post_data['post_id'] : 0,
++						'topic_id'	=> is_array($post_data) ? $post_data['topic_id'] : 0,
++						'forum_id'	=> is_array($post_data) ? $post_data['forum_id'] : 0,
+ 					]);
+ 				}
+ 			}
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbwatchlist/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbwatchlist/diff_full.tmp"
+new file mode 100644
+index 000000000..2cfbd7c29
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbwatchlist/diff_full.tmp"
+@@ -0,0 +1,345 @@
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbwatchlist/bbwatchlist/bbwatchlist.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbwatchlist/bbwatchlist/bbwatchlist.php"
++index 58f8851be..83ce3d219 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbwatchlist/bbwatchlist/bbwatchlist.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbwatchlist/bbwatchlist/bbwatchlist.php"
++@@ -79,6 +79,7 @@ class bbwatchlist
++ 				FROM ' . $this->watch_keywords_table . '
++ 				WHERE user_id <> ' . $this->user->data['user_id'];
++ 		$result = $this->db->sql_query($sql);
+++
++ 		while ($row = $this->db->sql_fetchrow($result))
++ 		{
++ 			if ($row['search_type'] == type::SEARCH_TYPE_POST_CONTENT)
++@@ -88,9 +89,9 @@ class bbwatchlist
++ 					$this->notifications->add_notifications('sitesplat.bbwatchlist.notification.type.content_keyword', [
++ 						'user_ids'	=> [$row['user_id']],
++ 						'keyword'	=> $row['keyword'],
++-						'post_id'	=> $post_data['post_id'],
++-						'topic_id'	=> $post_data['topic_id'],
++-						'forum_id'	=> $post_data['forum_id'],
+++						'post_id'	=> is_array($post_data) ? $post_data['post_id'] : 0,
+++						'topic_id'	=> is_array($post_data) ? $post_data['topic_id'] : 0,
+++						'forum_id'	=> is_array($post_data) ? $post_data['forum_id'] : 0,
++ 					]);
++ 				}
++ 			} elseif (!empty($this->topic_subject))
++@@ -100,9 +101,9 @@ class bbwatchlist
++ 					$this->notifications->add_notifications('sitesplat.bbwatchlist.notification.type.subject_keyword', [
++ 						'user_ids'	=> [$row['user_id']],
++ 						'keyword'	=> $row['keyword'],
++-						'post_id'	=> $post_data['post_id'],
++-						'topic_id'	=> $post_data['topic_id'],
++-						'forum_id'	=> $post_data['forum_id'],
+++						'post_id'	=> is_array($post_data) ? $post_data['post_id'] : 0,
+++						'topic_id'	=> is_array($post_data) ? $post_data['topic_id'] : 0,
+++						'forum_id'	=> is_array($post_data) ? $post_data['forum_id'] : 0,
++ 					]);
++ 				}
++ 			}
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbwatchlist/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbwatchlist/diff_full.tmp"
++new file mode 100644
++index 000000000..e69de29bb
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbwatchlist/language/en/info_ucp_bbwatchlist.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbwatchlist/language/en/info_ucp_bbwatchlist.php"
++index 968b4bfe5..422e4826e 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbwatchlist/language/en/info_ucp_bbwatchlist.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbwatchlist/language/en/info_ucp_bbwatchlist.php"
++@@ -33,7 +33,8 @@ $lang = array_merge($lang, array(
++ 
++ 	'KEYWORD_EMPTY'		=> 'Oops! You didn\'t enter a keyword.',
++ 	'KEYWORD_PATTERN'	=> '3 to 50 characters',
++-	'KEYWORD_TOO_LONG'	=> 'Keyword is too long. Maximum length of one keyword is 255 characters',
+++	'KEYWORD_TOO_SHORT'	=> 'Keyword is too short. Minimum length of one keyword is 3 characters',
+++	'KEYWORD_TOO_LONG'	=> 'Keyword is too long. Maximum length of one keyword is 50 characters',
++ 	'KEYWORD_EXISTS'	=> 'You already have such keyword defined.',
++ 	'KEYWORD_ADDED'		=> 'Keyword has been added',
++ 	'KEYWORD_DELETED'	=> 'Keyword has been deleted',
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbwatchlist/language/pt/common.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbwatchlist/language/pt/common.php"
++new file mode 100644
++index 000000000..4e51f6da4
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbwatchlist/language/pt/common.php"
++@@ -0,0 +1,26 @@
+++<?php
+++/**
+++ *
+++ * BBwatchlist. An extension for the phpBB Forum Software package.
+++ *
+++ * @copyright (c) 2018 SiteSplat All rights reserved
+++ * @license Proprietary
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
+++	$lang = array();
+++}
+++
+++$lang = array_merge($lang, array(
+++	'SUBJECT_KEYWORD_NOTIFICATION_TITLE'	=> 'Uma palavra-chave que segues foi encontrada no título de um tópico',
+++	'SUBJECT_KEYWORD_NOTIFICATION_CONTENT'	=> 'A palavra-chave "%s" surgiu no título de um novo tópico.',
+++	'CONTENT_KEYWORD_NOTIFICATION_TITLE'	=> 'Uma palavra-chave que segues foi encontrada no conteúdo de uma mensagem',
+++	'CONTENT_KEYWORD_NOTIFICATION_CONTENT'	=> 'A palavra-chave "%s" surgiu no conteúdo de uma nova mensagem.',
+++));
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbwatchlist/language/pt/email/content_keyword.txt" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbwatchlist/language/pt/email/content_keyword.txt"
++new file mode 100644
++index 000000000..4eb539a07
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbwatchlist/language/pt/email/content_keyword.txt"
++@@ -0,0 +1,8 @@
+++Assunto: Palavra-chave encontrada no conteúdo de uma mensagem
+++
+++Olá,
+++
+++a palavra-chave "{KEYWORD}" que segues foi encontrada no conteúdo de uma mensagem. Clica aqui para veres:
+++{U_TOPIC_LINK}
+++
+++{EMAIL_SIG}
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbwatchlist/language/pt/email/subject_keyword.txt" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbwatchlist/language/pt/email/subject_keyword.txt"
++new file mode 100644
++index 000000000..02a8e8c9e
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbwatchlist/language/pt/email/subject_keyword.txt"
++@@ -0,0 +1,8 @@
+++Assunto: Palavra-chave encontrada no título de um tópico
+++
+++Olá,
+++
+++a palavra-chave "{KEYWORD}" que segues foi encontrada no título de um tópico. Clica aqui para veres:
+++{U_TOPIC_LINK}
+++
+++{EMAIL_SIG}
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbwatchlist/language/pt/info_ucp_bbwatchlist.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbwatchlist/language/pt/info_ucp_bbwatchlist.php"
++new file mode 100644
++index 000000000..58c6216bb
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbwatchlist/language/pt/info_ucp_bbwatchlist.php"
++@@ -0,0 +1,46 @@
+++<?php
+++/**
+++ *
+++ * BBwatchlist. An extension for the phpBB Forum Software package.
+++ *
+++ * @copyright (c) 2018 SiteSplat All rights reserved
+++ * @license Proprietary
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
+++	$lang = array();
+++}
+++
+++$lang = array_merge($lang, array(
+++	'UCP_SITESPLAT_BBWATCHLIST'	=> 'Gerir a Minha Lista',
+++
+++	'KEYWORD'					=> 'Palavra-chave',
+++	'SEARCH_TYPE'				=> 'Tipo de Pesquisa',
+++	'ACTIONS'					=> 'Ações',
+++	'KEYWORDS'					=> 'Palavras-chave',
+++	'UCP_SITESPLAT_BBWATCHLIST_EXPLAIN'	=> 'Podes adicionar palavras-chave para seguir e ser notificado quando estas forem usadas em mensagens ou nos títulos dos tópicos',
+++	'NO_UCP_KEYWORDS'			=> 'Não tens quaisquer palavras-chave definidas. Estás à espera de quê? Adiciona lá algumas!',
+++	'ADD_NEW_KEYWORD'			=> 'Adicionar nova palavra-chave',
+++	'SEARCH_TYPE_TOPIC_SUBJECT'	=> 'Correspondência no título dos tópicos',
+++	'SEARCH_TYPE_POST_CONTENT'	=> 'Correspondência no conteúdo das mensagens',
+++
+++	'KEYWORD_EMPTY'		=> 'Ups! Não inseriste nenhuma palavra-chave.',
+++	'KEYWORD_PATTERN'	=> '3 a 50 caracteres',
+++	'KEYWORD_TOO_SHORT'	=> 'Palavra-chave demasiado curta. Tem de ter pelo menos 3 caracteres',
+++	'KEYWORD_TOO_LONG'	=> 'Palavra-chave demasiado longa. Não pode ultrapassar os 50 caracteres',
+++	'KEYWORD_EXISTS'	=> 'Outra vez arroz? Já tens essa palavra-chave definida.',
+++	'KEYWORD_ADDED'		=> 'Palavra-chave adicionada',
+++	'KEYWORD_DELETED'	=> 'Palavra-chave removida',
+++
+++	// Notifications
+++	'NOTIFICATION_GROUP_BBWATCHLIST'	=> 'Watchlist',
+++	'NOTIFICATION_TYPE_SUBJECT_KEYWORD'	=> 'Uma das tuas palavra-chave que segues foi detectada no título do tópico',
+++	'NOTIFICATION_TYPE_CONTENT_KEYWORD'	=> 'Uma das tuas palavra-chave que segues foi detectada no conteúdo de uma mensagem',
+++));
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbwatchlist/language/pt_preao/common.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbwatchlist/language/pt_preao/common.php"
++new file mode 100644
++index 000000000..4e51f6da4
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbwatchlist/language/pt_preao/common.php"
++@@ -0,0 +1,26 @@
+++<?php
+++/**
+++ *
+++ * BBwatchlist. An extension for the phpBB Forum Software package.
+++ *
+++ * @copyright (c) 2018 SiteSplat All rights reserved
+++ * @license Proprietary
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
+++	$lang = array();
+++}
+++
+++$lang = array_merge($lang, array(
+++	'SUBJECT_KEYWORD_NOTIFICATION_TITLE'	=> 'Uma palavra-chave que segues foi encontrada no título de um tópico',
+++	'SUBJECT_KEYWORD_NOTIFICATION_CONTENT'	=> 'A palavra-chave "%s" surgiu no título de um novo tópico.',
+++	'CONTENT_KEYWORD_NOTIFICATION_TITLE'	=> 'Uma palavra-chave que segues foi encontrada no conteúdo de uma mensagem',
+++	'CONTENT_KEYWORD_NOTIFICATION_CONTENT'	=> 'A palavra-chave "%s" surgiu no conteúdo de uma nova mensagem.',
+++));
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbwatchlist/language/pt_preao/email/content_keyword.txt" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbwatchlist/language/pt_preao/email/content_keyword.txt"
++new file mode 100644
++index 000000000..4eb539a07
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbwatchlist/language/pt_preao/email/content_keyword.txt"
++@@ -0,0 +1,8 @@
+++Assunto: Palavra-chave encontrada no conteúdo de uma mensagem
+++
+++Olá,
+++
+++a palavra-chave "{KEYWORD}" que segues foi encontrada no conteúdo de uma mensagem. Clica aqui para veres:
+++{U_TOPIC_LINK}
+++
+++{EMAIL_SIG}
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbwatchlist/language/pt_preao/email/subject_keyword.txt" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbwatchlist/language/pt_preao/email/subject_keyword.txt"
++new file mode 100644
++index 000000000..02a8e8c9e
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbwatchlist/language/pt_preao/email/subject_keyword.txt"
++@@ -0,0 +1,8 @@
+++Assunto: Palavra-chave encontrada no título de um tópico
+++
+++Olá,
+++
+++a palavra-chave "{KEYWORD}" que segues foi encontrada no título de um tópico. Clica aqui para veres:
+++{U_TOPIC_LINK}
+++
+++{EMAIL_SIG}
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbwatchlist/language/pt_preao/info_ucp_bbwatchlist.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbwatchlist/language/pt_preao/info_ucp_bbwatchlist.php"
++new file mode 100644
++index 000000000..32418da36
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbwatchlist/language/pt_preao/info_ucp_bbwatchlist.php"
++@@ -0,0 +1,46 @@
+++<?php
+++/**
+++ *
+++ * BBwatchlist. An extension for the phpBB Forum Software package.
+++ *
+++ * @copyright (c) 2018 SiteSplat All rights reserved
+++ * @license Proprietary
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
+++	$lang = array();
+++}
+++
+++$lang = array_merge($lang, array(
+++	'UCP_SITESPLAT_BBWATCHLIST'	=> 'Gerir a Minha Lista',
+++
+++	'KEYWORD'					=> 'Palavra-chave',
+++	'SEARCH_TYPE'				=> 'Tipo de Pesquisa',
+++	'ACTIONS'					=> 'Acções',
+++	'KEYWORDS'					=> 'Palavras-chave',
+++	'UCP_SITESPLAT_BBWATCHLIST_EXPLAIN'			=> 'Podes adicionar palavras-chave para seguir e ser notificado quando estas forem usadas em mensagens ou nos títulos dos tópicos',
+++	'NO_UCP_KEYWORDS'			=> 'Não tens quaisquer palavras-chave definidas. Estás à espera de quê? Adiciona lá algumas!',
+++	'ADD_NEW_KEYWORD'			=> 'Adicionar nova palavra-chave',
+++	'SEARCH_TYPE_TOPIC_SUBJECT'	=> 'Correspondência no título dos tópicos',
+++	'SEARCH_TYPE_POST_CONTENT'	=> 'Correspondência no conteúdo das mensagens',
+++
+++	'KEYWORD_EMPTY'		=> 'Ups! Não inseriste nenhuma palavra-chave.',
+++	'KEYWORD_PATTERN'	=> '3 a 50 caracteres',
+++	'KEYWORD_TOO_SHORT'	=> 'Palavra-chave demasiado curta. Tem de ter pelo menos 3 caracteres',
+++	'KEYWORD_TOO_LONG'	=> 'Palavra-chave demasiado longa. Não pode ultrapassar os 50 caracteres',
+++	'KEYWORD_EXISTS'	=> 'Outra vez arroz? Já tens essa palavra-chave definida.',
+++	'KEYWORD_ADDED'		=> 'Palavra-chave adicionada',
+++	'KEYWORD_DELETED'	=> 'Palavra-chave removida',
+++
+++	// Notifications
+++	'NOTIFICATION_GROUP_BBWATCHLIST'	=> 'Watchlist',
+++	'NOTIFICATION_TYPE_SUBJECT_KEYWORD'	=> 'Uma das tuas palavra-chave que segues foi detectada no título do tópico',
+++	'NOTIFICATION_TYPE_CONTENT_KEYWORD'	=> 'Uma das tuas palavra-chave que segues foi detectada no conteúdo de uma mensagem',
+++));
++diff --git "a/c:
\ No newline at end of file
diff --git "[ORIGINAL]/sitesplat\\bbwatchlist/language/en/info_ucp_bbwatchlist.php" "[FORUM_EXT]/sitesplat\\bbwatchlist/language/en/info_ucp_bbwatchlist.php"
--- "[ORIGINAL]/sitesplat\\bbwatchlist/language/en/info_ucp_bbwatchlist.php"
+++ "[FORUM_EXT]/sitesplat\\bbwatchlist/language/en/info_ucp_bbwatchlist.php"
@@ -33,7 +33,8 @@ $lang = array_merge($lang, array(
 
 	'KEYWORD_EMPTY'		=> 'Oops! You didn\'t enter a keyword.',
 	'KEYWORD_PATTERN'	=> '3 to 50 characters',
-	'KEYWORD_TOO_LONG'	=> 'Keyword is too long. Maximum length of one keyword is 255 characters',
+	'KEYWORD_TOO_SHORT'	=> 'Keyword is too short. Minimum length of one keyword is 3 characters',
+	'KEYWORD_TOO_LONG'	=> 'Keyword is too long. Maximum length of one keyword is 50 characters',
 	'KEYWORD_EXISTS'	=> 'You already have such keyword defined.',
 	'KEYWORD_ADDED'		=> 'Keyword has been added',
 	'KEYWORD_DELETED'	=> 'Keyword has been deleted',
diff --git "[FORUM_EXT]/sitesplat\\bbwatchlist/language/pt/common.php" "[FORUM_EXT]/sitesplat\\bbwatchlist/language/pt/common.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\bbwatchlist/language/pt/common.php"
@@ -0,0 +1,26 @@
+<?php
+/**
+ *
+ * BBwatchlist. An extension for the phpBB Forum Software package.
+ *
+ * @copyright (c) 2018 SiteSplat All rights reserved
+ * @license Proprietary
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
+	$lang = array();
+}
+
+$lang = array_merge($lang, array(
+	'SUBJECT_KEYWORD_NOTIFICATION_TITLE'	=> 'Uma palavra-chave que segues foi encontrada no título de um tópico',
+	'SUBJECT_KEYWORD_NOTIFICATION_CONTENT'	=> 'A palavra-chave "%s" surgiu no título de um novo tópico.',
+	'CONTENT_KEYWORD_NOTIFICATION_TITLE'	=> 'Uma palavra-chave que segues foi encontrada no conteúdo de uma mensagem',
+	'CONTENT_KEYWORD_NOTIFICATION_CONTENT'	=> 'A palavra-chave "%s" surgiu no conteúdo de uma nova mensagem.',
+));
diff --git "[FORUM_EXT]/sitesplat\\bbwatchlist/language/pt/email/content_keyword.txt" "[FORUM_EXT]/sitesplat\\bbwatchlist/language/pt/email/content_keyword.txt"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\bbwatchlist/language/pt/email/content_keyword.txt"
@@ -0,0 +1,8 @@
+Assunto: Palavra-chave encontrada no conteúdo de uma mensagem
+
+Olá,
+
+a palavra-chave "{KEYWORD}" que segues foi encontrada no conteúdo de uma mensagem. Clica aqui para veres:
+{U_TOPIC_LINK}
+
+{EMAIL_SIG}
diff --git "[FORUM_EXT]/sitesplat\\bbwatchlist/language/pt/email/subject_keyword.txt" "[FORUM_EXT]/sitesplat\\bbwatchlist/language/pt/email/subject_keyword.txt"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\bbwatchlist/language/pt/email/subject_keyword.txt"
@@ -0,0 +1,8 @@
+Assunto: Palavra-chave encontrada no título de um tópico
+
+Olá,
+
+a palavra-chave "{KEYWORD}" que segues foi encontrada no título de um tópico. Clica aqui para veres:
+{U_TOPIC_LINK}
+
+{EMAIL_SIG}
diff --git "[FORUM_EXT]/sitesplat\\bbwatchlist/language/pt/info_ucp_bbwatchlist.php" "[FORUM_EXT]/sitesplat\\bbwatchlist/language/pt/info_ucp_bbwatchlist.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\bbwatchlist/language/pt/info_ucp_bbwatchlist.php"
@@ -0,0 +1,46 @@
+<?php
+/**
+ *
+ * BBwatchlist. An extension for the phpBB Forum Software package.
+ *
+ * @copyright (c) 2018 SiteSplat All rights reserved
+ * @license Proprietary
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
+	$lang = array();
+}
+
+$lang = array_merge($lang, array(
+	'UCP_SITESPLAT_BBWATCHLIST'	=> 'Gerir a Minha Lista',
+
+	'KEYWORD'					=> 'Palavra-chave',
+	'SEARCH_TYPE'				=> 'Tipo de Pesquisa',
+	'ACTIONS'					=> 'Ações',
+	'KEYWORDS'					=> 'Palavras-chave',
+	'UCP_SITESPLAT_BBWATCHLIST_EXPLAIN'	=> 'Podes adicionar palavras-chave para seguir e ser notificado quando estas forem usadas em mensagens ou nos títulos dos tópicos',
+	'NO_UCP_KEYWORDS'			=> 'Não tens quaisquer palavras-chave definidas. Estás à espera de quê? Adiciona lá algumas!',
+	'ADD_NEW_KEYWORD'			=> 'Adicionar nova palavra-chave',
+	'SEARCH_TYPE_TOPIC_SUBJECT'	=> 'Correspondência no título dos tópicos',
+	'SEARCH_TYPE_POST_CONTENT'	=> 'Correspondência no conteúdo das mensagens',
+
+	'KEYWORD_EMPTY'		=> 'Ups! Não inseriste nenhuma palavra-chave.',
+	'KEYWORD_PATTERN'	=> '3 a 50 caracteres',
+	'KEYWORD_TOO_SHORT'	=> 'Palavra-chave demasiado curta. Tem de ter pelo menos 3 caracteres',
+	'KEYWORD_TOO_LONG'	=> 'Palavra-chave demasiado longa. Não pode ultrapassar os 50 caracteres',
+	'KEYWORD_EXISTS'	=> 'Outra vez arroz? Já tens essa palavra-chave definida.',
+	'KEYWORD_ADDED'		=> 'Palavra-chave adicionada',
+	'KEYWORD_DELETED'	=> 'Palavra-chave removida',
+
+	// Notifications
+	'NOTIFICATION_GROUP_BBWATCHLIST'	=> 'Watchlist',
+	'NOTIFICATION_TYPE_SUBJECT_KEYWORD'	=> 'Uma das tuas palavra-chave que segues foi detectada no título do tópico',
+	'NOTIFICATION_TYPE_CONTENT_KEYWORD'	=> 'Uma das tuas palavra-chave que segues foi detectada no conteúdo de uma mensagem',
+));
diff --git "[FORUM_EXT]/sitesplat\\bbwatchlist/language/pt_preao/common.php" "[FORUM_EXT]/sitesplat\\bbwatchlist/language/pt_preao/common.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\bbwatchlist/language/pt_preao/common.php"
@@ -0,0 +1,26 @@
+<?php
+/**
+ *
+ * BBwatchlist. An extension for the phpBB Forum Software package.
+ *
+ * @copyright (c) 2018 SiteSplat All rights reserved
+ * @license Proprietary
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
+	$lang = array();
+}
+
+$lang = array_merge($lang, array(
+	'SUBJECT_KEYWORD_NOTIFICATION_TITLE'	=> 'Uma palavra-chave que segues foi encontrada no título de um tópico',
+	'SUBJECT_KEYWORD_NOTIFICATION_CONTENT'	=> 'A palavra-chave "%s" surgiu no título de um novo tópico.',
+	'CONTENT_KEYWORD_NOTIFICATION_TITLE'	=> 'Uma palavra-chave que segues foi encontrada no conteúdo de uma mensagem',
+	'CONTENT_KEYWORD_NOTIFICATION_CONTENT'	=> 'A palavra-chave "%s" surgiu no conteúdo de uma nova mensagem.',
+));
diff --git "[FORUM_EXT]/sitesplat\\bbwatchlist/language/pt_preao/email/content_keyword.txt" "[FORUM_EXT]/sitesplat\\bbwatchlist/language/pt_preao/email/content_keyword.txt"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\bbwatchlist/language/pt_preao/email/content_keyword.txt"
@@ -0,0 +1,8 @@
+Assunto: Palavra-chave encontrada no conteúdo de uma mensagem
+
+Olá,
+
+a palavra-chave "{KEYWORD}" que segues foi encontrada no conteúdo de uma mensagem. Clica aqui para veres:
+{U_TOPIC_LINK}
+
+{EMAIL_SIG}
diff --git "[FORUM_EXT]/sitesplat\\bbwatchlist/language/pt_preao/email/subject_keyword.txt" "[FORUM_EXT]/sitesplat\\bbwatchlist/language/pt_preao/email/subject_keyword.txt"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\bbwatchlist/language/pt_preao/email/subject_keyword.txt"
@@ -0,0 +1,8 @@
+Assunto: Palavra-chave encontrada no título de um tópico
+
+Olá,
+
+a palavra-chave "{KEYWORD}" que segues foi encontrada no título de um tópico. Clica aqui para veres:
+{U_TOPIC_LINK}
+
+{EMAIL_SIG}
diff --git "[FORUM_EXT]/sitesplat\\bbwatchlist/language/pt_preao/info_ucp_bbwatchlist.php" "[FORUM_EXT]/sitesplat\\bbwatchlist/language/pt_preao/info_ucp_bbwatchlist.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\bbwatchlist/language/pt_preao/info_ucp_bbwatchlist.php"
@@ -0,0 +1,46 @@
+<?php
+/**
+ *
+ * BBwatchlist. An extension for the phpBB Forum Software package.
+ *
+ * @copyright (c) 2018 SiteSplat All rights reserved
+ * @license Proprietary
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
+	$lang = array();
+}
+
+$lang = array_merge($lang, array(
+	'UCP_SITESPLAT_BBWATCHLIST'	=> 'Gerir a Minha Lista',
+
+	'KEYWORD'					=> 'Palavra-chave',
+	'SEARCH_TYPE'				=> 'Tipo de Pesquisa',
+	'ACTIONS'					=> 'Acções',
+	'KEYWORDS'					=> 'Palavras-chave',
+	'UCP_SITESPLAT_BBWATCHLIST_EXPLAIN'			=> 'Podes adicionar palavras-chave para seguir e ser notificado quando estas forem usadas em mensagens ou nos títulos dos tópicos',
+	'NO_UCP_KEYWORDS'			=> 'Não tens quaisquer palavras-chave definidas. Estás à espera de quê? Adiciona lá algumas!',
+	'ADD_NEW_KEYWORD'			=> 'Adicionar nova palavra-chave',
+	'SEARCH_TYPE_TOPIC_SUBJECT'	=> 'Correspondência no título dos tópicos',
+	'SEARCH_TYPE_POST_CONTENT'	=> 'Correspondência no conteúdo das mensagens',
+
+	'KEYWORD_EMPTY'		=> 'Ups! Não inseriste nenhuma palavra-chave.',
+	'KEYWORD_PATTERN'	=> '3 a 50 caracteres',
+	'KEYWORD_TOO_SHORT'	=> 'Palavra-chave demasiado curta. Tem de ter pelo menos 3 caracteres',
+	'KEYWORD_TOO_LONG'	=> 'Palavra-chave demasiado longa. Não pode ultrapassar os 50 caracteres',
+	'KEYWORD_EXISTS'	=> 'Outra vez arroz? Já tens essa palavra-chave definida.',
+	'KEYWORD_ADDED'		=> 'Palavra-chave adicionada',
+	'KEYWORD_DELETED'	=> 'Palavra-chave removida',
+
+	// Notifications
+	'NOTIFICATION_GROUP_BBWATCHLIST'	=> 'Watchlist',
+	'NOTIFICATION_TYPE_SUBJECT_KEYWORD'	=> 'Uma das tuas palavra-chave que segues foi detectada no título do tópico',
+	'NOTIFICATION_TYPE_CONTENT_KEYWORD'	=> 'Uma das tuas palavra-chave que segues foi detectada no conteúdo de uma mensagem',
+));
diff --git "[ORIGINAL]/sitesplat\\bbwatchlist/styles/FLATBOOTS/template/bbwatchlist.js" "[FORUM_EXT]/sitesplat\\bbwatchlist/styles/FLATBOOTS/template/bbwatchlist.js"
--- "[ORIGINAL]/sitesplat\\bbwatchlist/styles/FLATBOOTS/template/bbwatchlist.js"
+++ "[FORUM_EXT]/sitesplat\\bbwatchlist/styles/FLATBOOTS/template/bbwatchlist.js"
@@ -4,6 +4,10 @@ head.ready(function() {
 	phpbb.addAjaxCallback('remove_keyword', function() {
 		$(this).parent().parent().remove();
 
+		document.getElementById('keyword').value = '';
+		$('#delete_msg').slideToggle(200);
+		setTimeout(function(){$('#delete_msg').slideToggle(500);}, 2500);
+
 		// Reload page if there is no keyword left. It will display a nice
 		// information about it.
 		if ($('#bbwatchlist_keywords tr').length < 2)
diff --git "[ORIGINAL]/sitesplat\\bbwatchlist/styles/FLATBOOTS/template/ucp_bbwatchlist.html" "[FORUM_EXT]/sitesplat\\bbwatchlist/styles/FLATBOOTS/template/ucp_bbwatchlist.html"
--- "[ORIGINAL]/sitesplat\\bbwatchlist/styles/FLATBOOTS/template/ucp_bbwatchlist.html"
+++ "[FORUM_EXT]/sitesplat\\bbwatchlist/styles/FLATBOOTS/template/ucp_bbwatchlist.html"
@@ -7,12 +7,13 @@
 	<p>{{ lang('UCP_SITESPLAT_BBWATCHLIST_EXPLAIN') }}</p>
 
 	<div id="success_msg" class="alert alert-success" style="display:none"><h4 style="margin:0">{{ lang('KEYWORD_ADDED') }}</h4></div>
+	<div id="delete_msg" class="alert alert-danger" style="display:none"><h4 style="margin:0">{{ lang('KEYWORD_DELETED') }}</h4></div>
 
 <div class="side-segment"><h3>{{ lang('ADD_NEW_KEYWORD') }}</h3></div>
 
 <form id="ucp" method="post" action="{S_UCP_ACTION}" data-ajax="add_keyword">
 	<div class="input-group">
-		<input id="keyword" class="form-control" type="text" name="keyword" pattern=".{3,50}" required title="{{ lang('KEYWORD_PATTERN') }}">
+		<input id="keyword" class="form-control" type="text" name="keyword" pattern=".{3,50}" required title="{{ lang('KEYWORD_PATTERN') }}" placeholder="{{ lang('KEYWORD') ~ lang('COLON') }}">
 		<span class="input-group-btn">
 			<input class="btn btn-default" type="submit" value="{{ lang('SUBMIT') }}">
 		</span>
diff --git "[ORIGINAL]/sitesplat\\bbwatchlist/ucp/main_module.php" "[FORUM_EXT]/sitesplat\\bbwatchlist/ucp/main_module.php"
--- "[ORIGINAL]/sitesplat\\bbwatchlist/ucp/main_module.php"
+++ "[FORUM_EXT]/sitesplat\\bbwatchlist/ucp/main_module.php"
@@ -56,7 +56,12 @@ class main_module
 					trigger_error('KEYWORD_EMPTY');
 				}
 
-				if (strlen($keyword) > 255)
+				if (strlen($keyword) < 3)
+				{
+					trigger_error('KEYWORD_TOO_SHORT');
+				}
+
+				if (strlen($keyword) > 50)
 				{
 					trigger_error('KEYWORD_TOO_LONG');
 				}
@@ -101,13 +106,6 @@ class main_module
 							AND user_id = ' . (int) $this->user->data['user_id'];
 				$this->db->sql_query($sql);
 
-				$message = $this->language->lang('KEYWORD_DELETED');
-				if (!$this->request->is_ajax())
-				{
-					$message .= '<br /><br />' . $this->language->lang('RETURN_UCP', '<a href="' . $this->u_action . '">', '</a>');
-				}
-				trigger_error($message);
-
 			break;
 
 			default:
```
