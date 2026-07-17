Existem diferencas reais no codigo ou texto. Diferencas de formatacao (espacos, tabs) foram ignoradas abaixo.

```diff
diff --git "[ORIGINAL]/sitesplat\\bbprofile/composer.json" "[FORUM_EXT]/sitesplat\\bbprofile/composer.json"
--- "[ORIGINAL]/sitesplat\\bbprofile/composer.json"
+++ "[FORUM_EXT]/sitesplat\\bbprofile/composer.json"
@@ -24,7 +24,8 @@
 		"version-check": {
             "host": "sitesplat.com",
             "directory": "/updatecheck/phpbb32/ext",
-            "filename": "bbprofile.json"
+            "filename": "bbprofile.json",
+			"ssl": true
 		}
     }
 }
diff --git "[ORIGINAL]/sitesplat\\bbprofile/config/routing.yml" "[FORUM_EXT]/sitesplat\\bbprofile/config/routing.yml"
--- "[ORIGINAL]/sitesplat\\bbprofile/config/routing.yml"
+++ "[FORUM_EXT]/sitesplat\\bbprofile/config/routing.yml"
@@ -1,3 +1,3 @@
 sitesplat_bbprofile_controller:
-    path: /demo/{name}
+    path: /profile/{name}
     defaults: { _controller: sitesplat.bbprofile.controller:handle }
diff --git "[FORUM_EXT]/sitesplat\\bbprofile/diff_full.tmp" "[FORUM_EXT]/sitesplat\\bbprofile/diff_full.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\bbprofile/diff_full.tmp"
@@ -0,0 +1,465 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbprofile/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbprofile/composer.json"
+index 25fa181a7..29299abb2 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbprofile/composer.json"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbprofile/composer.json"
+@@ -24,7 +24,8 @@
+ 		"version-check": {
+             "host": "sitesplat.com",
+             "directory": "/updatecheck/phpbb32/ext",
+-            "filename": "bbprofile.json"
++            "filename": "bbprofile.json",
++			"ssl": true
+ 		}
+     }
+ }
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbprofile/config/routing.yml" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbprofile/config/routing.yml"
+index b6f8c3239..8139bebff 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbprofile/config/routing.yml"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbprofile/config/routing.yml"
+@@ -1,3 +1,3 @@
+ sitesplat_bbprofile_controller:
+-    path: /demo/{name}
++    path: /profile/{name}
+     defaults: { _controller: sitesplat.bbprofile.controller:handle }
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbprofile/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbprofile/diff_full.tmp"
+new file mode 100644
+index 000000000..e69de29bb
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbprofile/language/en/common.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbprofile/language/en/common.php"
+index 982e453d1..6179343e9 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbprofile/language/en/common.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbprofile/language/en/common.php"
+@@ -27,16 +27,27 @@ $lang = array_merge($lang, array(
+ 	'BBPROFILE_SIGNATURE_BUTTON'	=> 'Add signature under every post',
+ 	'BBPROFILE_AVATAR_TEXT'			=> 'Express yourself and show who you are or maybe represent, believe in...',
+ 	'BBPROFILE_AVATAR_BUTTON'		=> 'Add an avatar',
+-	'BBPROFILE_FACEBOOK_TEXT'		=> 'Make friends.',
++
++	'BBPROFILE_INTERESTS_TEXT'		=> 'Come on, stop being an asshole and share with your friends your awesome interests',
++	'BBPROFILE_INTERESTS_BUTTON'	=> 'Add your interests',
++	'BBPROFILE_OCCUPATION_TEXT'		=> 'What do you really do? Don\'t say "PLEASE"! Barney Stinson said it enough!',
++	'BBPROFILE_OCCUPATION_BUTTON'	=> 'Add your hobbies',
++	'BBPROFILE_WEBSITE_TEXT'		=> 'Do you own any website or blog?',
++	'BBPROFILE_WEBSITE_BUTTON'		=> 'Promote what is yours, be proud!',
++	'BBPROFILE_LOCATION_TEXT'		=> 'Do you want to share your location? What, did you call us stalkers?! But you always accept on Smartphone!',
++	'BBPROFILE_LOCATION_BUTTON'		=> 'Fine. I want to meet nerdy neighbors anyway!',
++
++	'BBPROFILE_FACEBOOK_TEXT'		=> 'Make friends. But doesn\'t talk with strangers (Mother Siny tip)',
+ 	'BBPROFILE_FACEBOOK_BUTTON'		=> 'Add your Facebook account',
+-	'BBPROFILE_TWITTER_TEXT'		=> 'Let your tweets be heard.',
+-	'BBPROFILE_TWITTER_BUTTON'		=> 'Add your Twitter account',
+ 	'BBPROFILE_SKYPE_TEXT'			=> 'Talk to others.',
+ 	'BBPROFILE_SKYPE_BUTTON'		=> 'Add your Skype account',
++	'BBPROFILE_TWITTER_TEXT'		=> 'Let your tweets be heard.',
++	'BBPROFILE_TWITTER_BUTTON'		=> 'Add your Twitter account',
+ 	'BBPROFILE_YOUTUBE_TEXT'		=> 'Make your videos popular.',
+ 	'BBPROFILE_YOUTUBE_BUTTON'		=> 'Add your Youtube account',
+ 	'BBPROFILE_GOOGLEPLUS_TEXT'		=> 'Make friends.',
+ 	'BBPROFILE_GOOGLEPLUS_BUTTON'	=> 'Add your Google+ account',
++
+ 	'BBPROFILE_FIRST_POST_TEXT'		=> 'Get involved in discussion. Select a forum and create a new topic!',
+ 	'BBPROFILE_FIRST_POST_BUTTON'	=> 'Create your first post.',
+ 
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbprofile/language/pt/common.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbprofile/language/pt/common.php"
+new file mode 100644
+index 000000000..06c5271eb
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbprofile/language/pt/common.php"
+@@ -0,0 +1,56 @@
++<?php
++/**
++*
++* BBbbprofile. An extension for the phpBB Forum Software package.
++* @copyright (c) 2016, SiteSplat
++* @license Proprietary
++*
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
++$lang = array_merge($lang, array(
++	'COMPLETE_PROFILE_TITLE'	=> 'Completa o teu perfil',
++	'COMPLETED_PERCENTAGE'		=> '%d%% completo',
++
++	'BBPROFILE_BIRTHDATE_TEXT'		=> 'Deixa os teus amigos goldtuganianos desejarem-te um feliz aniversário.',
++	'BBPROFILE_BIRTHDATE_BUTTON'	=> 'Adiciona lá a data',
++	'BBPROFILE_SIGNATURE_TEXT'		=> 'Usa para promover os teus projetos e as tuas ideias!',
++	'BBPROFILE_SIGNATURE_BUTTON'	=> 'Adiciona uma assinatura',
++	'BBPROFILE_AVATAR_TEXT'			=> 'Expressa-te e mostra-nos quem és e que personalidade é a tua!',
++	'BBPROFILE_AVATAR_BUTTON'		=> 'Adiciona um avatar',
++
++	'BBPROFILE_INTERESTS_TEXT'		=> 'Anda lá, deixa de ser cortes e partilha com os teus amigos os teus interesses',
++	'BBPROFILE_INTERESTS_BUTTON'	=> 'Adiciona os teus interesses',
++	'BBPROFILE_OCCUPATION_TEXT'		=> 'O que é que fazes mesmo? Não digas "PLEASE"! Basta-nos um Barney Stinson!',
++	'BBPROFILE_OCCUPATION_BUTTON'	=> 'Adiciona os teus hobbies',
++	'BBPROFILE_WEBSITE_TEXT'		=> 'Tens algum site ou blog da tua autoria?',
++	'BBPROFILE_WEBSITE_BUTTON'		=> 'Promove o que é teu, orgulha-te!',
++	'BBPROFILE_LOCATION_TEXT'		=> 'Desejas partilhar a tua localização? O quê, chamaste-nos stalkers?! Mas tu aceitas sempre no Smartphone!',
++	'BBPROFILE_LOCATION_BUTTON'		=> 'Ok! Quero encontrar vizinhos nerds!',
++
++	'BBPROFILE_FACEBOOK_TEXT'		=> 'Cria novas amizades, mas não fales com estranhos (Dica da mãezinha, Siny).',
++	'BBPROFILE_FACEBOOK_BUTTON'		=> 'Adiciona a tua conta Facebook',
++	'BBPROFILE_SKYPE_TEXT'			=> 'Se és daqueles que gosta de videochamadas em grupo e conhecer novas pessoas, partilha aí o skype.',
++	'BBPROFILE_SKYPE_BUTTON'		=> 'Adiciona a tua conta Skype',
++	'BBPROFILE_TWITTER_TEXT'		=> 'Faz ouvir os teus tweets.',
++	'BBPROFILE_TWITTER_BUTTON'		=> 'Adiciona a tua conta Twitter',
++	'BBPROFILE_YOUTUBE_TEXT'		=> 'Torna o teu canal mais popular ainda.',
++	'BBPROFILE_YOUTUBE_BUTTON'		=> 'Adiciona a tua conta YouTube',
++	'BBPROFILE_GOOGLEPLUS_TEXT'		=> 'Cria novas amizades.',
++	'BBPROFILE_GOOGLEPLUS_BUTTON'	=> 'Adiciona a tua conta Google+',
++	
++	'BBPROFILE_FIRST_POST_TEXT'		=> 'Envolve-te na comunidade e nas suas discussões e convívios. Seleciona um fórum e cria um tópico novo!',
++	'BBPROFILE_FIRST_POST_BUTTON'	=> 'Cria a tua primeira mensagem! Apresenta-te!',
++
++	'BBPROFILE_CPF_TEXT'		=> 'Conta-nos mais sobre ti, %s, tens?',
++	'BBPROFILE_CPF_BTN_LABEL'	=> 'Preenche o campo %s',
++));
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbprofile/language/pt/info_acp_bbprofile.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbprofile/language/pt/info_acp_bbprofile.php"
+new file mode 100644
+index 000000000..a5bcb6101
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbprofile/language/pt/info_acp_bbprofile.php"
+@@ -0,0 +1,44 @@
++<?php
++/**
++*
++* BBbbprofile. An extension for the phpBB Forum Software package.
++* @copyright (c) 2016, SiteSplat
++* @license Proprietary
++*
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
++$lang = array_merge($lang, array(
++	'ACP_BBPROFILE'					=> 'BBprofile',
++	'BBPROFILE_SETTING_SAVED'		=> 'BBprofile settings has been saved.',
++
++	'SS_HELPER_NOTY'	            => 'SiteSplat BBcore does not exist!<br />Download the <a href="http://sitesplat.com" target="_blank">BBcore</a> and copy the BBcore folder into your sitesplat extension folder.',
++	'BBPROFILE_NOTICE'	            => '<div class="phpinfo"><p>The settings for this extension are under the <strong>EXTENSIONS</strong> tab.</p><br /><p>Don\'t forget to check the Group Permissions "Can see BBprofile box" under: Group Permissions &#187; Misc.</p></div>',
++	
++	'BBPROFILE_LABEL'				=> 'When should we display BBprofile?',
++	'BBPROFILE_LABEL_EXPLAIN'	    => 'Choose the profile box location',
++	'UCP_ONLY'						=> 'UCP only',
++	'OVEARALL_HEADER'				=> 'Overall header',
++
++	'BBPROFILE_ENABLED'				=> 'Enabled BBprofile parts:',
++    'BBPROFILE_ENABLED_EXPLAIN'		=> 'Choose the profile parts that should be counted towards the 100% profile completion',
++
++        'PREDEFINED'					=> 'Predefined',
++	'CPF'							=> 'Custom Profile Fields',
++	
++	'BBPROFILE_HIDE_FOR_ADMINS'		=> 'Hide BBprofile box for admins:',
++	'HIDE_FOR_ADMINS'				=> 'Hide for admins',
++	'BBPROFILE_HIDE_FOR_MODS'		=> 'Hide BBprofile box for global moderators',
++	'HIDE_FOR_MODS'					=> 'Hide for global moderators',
++	'BBPROFILE_HIDDEN_FOR_ADMINS'	=> 'BBprofile box has been hidden for admins.',
++	'BBPROFILE_HIDDEN_FOR_MODS'		=> 'BBprofile box has been hidden for global moderators.',
++));
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbprofile/language/pt/permissions_bbprofile.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbprofile/language/pt/permissions_bbprofile.php"
+new file mode 100644
+index 000000000..53830b5a9
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbprofile/language/pt/permissions_bbprofile.php"
+@@ -0,0 +1,22 @@
++<?php
++/**
++*
++* BBbbprofile. An extension for the phpBB Forum Software package.
++* @copyright (c) 2016, SiteSplat
++* @license Proprietary
++*
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
++$lang = array_merge($lang, array(
++    'ACL_U_BBPROFILE' => 'Pode ver caixa BBprofile',
++));
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbprofile/language/pt_preao/common.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbprofile/language/pt_preao/common.php"
+new file mode 100644
+index 000000000..06c5271eb
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbprofile/language/pt_preao/common.php"
+@@ -0,0 +1,56 @@
++<?php
++/**
++*
++* BBbbprofile. An extension for the phpBB Forum Software package.
++* @copyright (c) 2016, SiteSplat
++* @license Proprietary
++*
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
++$lang = array_merge($lang, array(
++	'COMPLETE_PROFILE_TITLE'	=> 'Completa o teu perfil',
++	'COMPLETED_PERCENTAGE'		=> '%d%% completo',
++
++	'BBPROFILE_BIRTHDATE_TEXT'		=> 'Deixa os teus amigos goldtuganianos desejarem-te um feliz aniversário.',
++	'BBPROFILE_BIRTHDATE_BUTTON'	=> 'Adiciona lá a data',
++	'BBPROFILE_SIGNATURE_TEXT'		=> 'Usa para promover os teus projetos e as tuas ideias!',
++	'BBPROFILE_SIGNATURE_BUTTON'	=> 'Adiciona uma assinatura',
++	'BBPROFILE_AVATAR_TEXT'			=> 'Expressa-te e mostra-nos quem és e que personalidade é a tua!',
++	'BBPROFILE_AVATAR_BUTTON'		=> 'Adiciona um avatar',
++
++	'BBPROFILE_INTERESTS_TEXT'		=> 'Anda lá, deixa de ser cortes e partilha com os teus amigos os teus interesses',
++	'BBPROFILE_INTERESTS_BUTTON'	=> 'Adiciona os teus interesses',
++	'BBPROFILE_OCCUPATION_TEXT'		=> 'O que é que fazes mesmo? Não digas "PLEASE"! Basta-nos um Barney Stinson!',
++	'BBPROFILE_OCCUPATION_BUTTON'	=> 'Adiciona os teus hobbies',
++	'BBPROFILE_WEBSITE_TEXT'		=> 'Tens algum site ou blog da tua autoria?',
++	'BBPROFILE_WEBSITE_BUTTON'		=> 'Promove o que é teu, orgulha-te!',
++	'BBPROFILE_LOCATION_TEXT'		=> 'Desejas partilhar a tua localização? O quê, chamaste-nos stalkers?! Mas tu aceitas sempre no Smartphone!',
++	'BBPROFILE_LOCATION_BUTTON'		=> 'Ok! Quero encontrar vizinhos nerds!',
++
++	'BBPROFILE_FACEBOOK_TEXT'		=> 'Cria novas amizades, mas não fales com estranhos (Dica da mãezinha, Siny).',
++	'BBPROFILE_FACEBOOK_BUTTON'		=> 'Adiciona a tua conta Facebook',
++	'BBPROFILE_SKYPE_TEXT'			=> 'Se és daqueles que gosta de videochamadas em grupo e conhecer novas pessoas, partilha aí o skype.',
++	'BBPROFILE_SKYPE_BUTTON'		=> 'Adiciona a tua conta Skype',
++	'BBPROFILE_TWITTER_TEXT'		=> 'Faz ouvir os teus tweets.',
++	'BBPROFILE_TWITTER_BUTTON'		=> 'Adiciona a tua conta Twitter',
++	'BBPROFILE_YOUTUBE_TEXT'		=> 'Torna o teu canal mais popular ainda.',
++	'BBPROFILE_YOUTUBE_BUTTON'		=> 'Adiciona a tua conta YouTube',
++	'BBPROFILE_GOOGLEPLUS_TEXT'		=> 'Cria novas amizades.',
++	'BBPROFILE_GOOGLEPLUS_BUTTON'	=> 'Adiciona a tua conta Google+',
++	
++	'BBPROFILE_FIRST_POST_TEXT'		=> 'Envolve-te na comunidade e nas suas discussões e convívios. Seleciona um fórum e cria um tópico novo!',
++	'BBPROFILE_FIRST_POST_BUTTON'	=> 'Cria a tua primeira mensagem! Apresenta-te!',
++
++	'BBPROFILE_CPF_TEXT'		=> 'Conta-nos mais sobre ti, %s, tens?',
++	'BBPROFILE_CPF_BTN_LABEL'	=> 'Preenche o campo %s',
++));
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbprofile/language/pt_preao/info_acp_bbprofile.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbprofile/language/pt_preao/info_acp_bbprofile.php"
+new file mode 100644
+index 000000000..a5bcb6101
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbprofile/language/pt_preao/info_acp_bbprofile.php"
+@@ -0,0 +1,44 @@
++<?php
++/**
++*
++* BBbbprofile. An extension for the phpBB Forum Software package.
++* @copyright (c) 2016, SiteSplat
++* @license Proprietary
++*
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
++$lang = array_merge($lang, array(
++	'ACP_BBPROFILE'					=> 'BBprofile',
++	'BBPROFILE_SETTING_SAVED'		=> 'BBprofile settings has been saved.',
++
++	'SS_HELPER_NOTY'	            => 'SiteSplat BBcore does not exist!<br />Download the <a href="http://sitesplat.com" target="_blank">BBcore</a> and copy the BBcore folder into your sitesplat extension folder.',
++	'BBPROFILE_NOTICE'	            => '<div class="phpinfo"><p>The settings for this extension are under the <strong>EXTENSIONS</strong> tab.</p><br /><p>Don\'t forget to check the Group Permissions "Can see BBprofile box" under: Group Permissions &#187; Misc.</p></div>',
++	
++	'BBPROFILE_LABEL'				=> 'When should we display BBprofile?',
++	'BBPROFILE_LABEL_EXPLAIN'	    => 'Choose the profile box location',
++	'UCP_ONLY'						=> 'UCP only',
++	'OVEARALL_HEADER'				=> 'Overall header',
++
++	'BBPROFILE_ENABLED'				=> 'Enabled BBprofile parts:',
++    'BBPROFILE_ENABLED_EXPLAIN'		=> 'Choose the profile parts that should be counted towards the 100% profile completion',
++
++        'PREDEFINED'					=> 'Predefined',
++	'CPF'							=> 'Custom Profile Fields',
++	
++	'BBPROFILE_HIDE_FOR_ADMINS'		=> 'Hide BBprofile box for admins:',
++	'HIDE_FOR_ADMINS'				=> 'Hide for admins',
++	'BBPROFILE_HIDE_FOR_MODS'		=> 'Hide BBprofile box for global moderators',
++	'HIDE_FOR_MODS'					=> 'Hide for global moderators',
++	'BBPROFILE_HIDDEN_FOR_ADMINS'	=> 'BBprofile box has been hidden for admins.',
++	'BBPROFILE_HIDDEN_FOR_MODS'		=> 'BBprofile box has been hidden for global moderators.',
++));
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbprofile/language/pt_preao/permissions_bbprofile.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbprofile/language/pt_preao/permissions_bbprofile.php"
+new file mode 100644
+index 000000000..53830b5a9
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbprofile/language/pt_preao/permissions_bbprofile.php"
+@@ -0,0 +1,22 @@
++<?php
++/**
++*
++* BBbbprofile. An extension for the phpBB Forum Software package.
++* @copyright (c) 2016, SiteSplat
++* @license Proprietary
++*
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
++$lang = array_merge($lang, array(
++    'ACL_U_BBPROFILE' => 'Pode ver caixa BBprofile',
++));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbprofile/profile_parts/cpf_part.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbprofile/profile_parts/cpf_part.php"
+index 813869ee8..052118824 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbprofile/profile_parts/cpf_part.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbprofile/profile_parts/cpf_part.php"
+@@ -35,6 +35,39 @@ class cpf_part implements parts\part_interface
+ 
+ 	public function appeal_text()
+ 	{
++
++		if($this->data['field_ident'] == 'phpbb_interests') {
++			return $this->language->lang('BBPROFILE_INTERESTS_TEXT', $this->language->lang($this->data['lang_name']));
++		}
++
++		if($this->data['field_ident'] == 'phpbb_occupation') {
++			return $this->language->lang('BBPROFILE_OCCUPATION_TEXT', $this->language->lang($this->data['lang_name']));
++		}
++
++		if($this->data['field_ident'] == 'phpbb_website') {
++			return $this->language->lang('BBPROFILE_WEBSITE_TEXT', $this->language->lang($this->data['lang_name']));
++		}
++
++		if($this->data['field_ident'] == 'phpbb_location') {
++			return $this->language->lang('BBPROFILE_LOCATION_TEXT', $this->language->lang($this->data['lang_name']));
++		}
++
++		if($this->data['field_ident'] == 'phpbb_facebook') {
++			return $this->language->lang('BBPROFILE_FACEBOOK_TEXT', $this->language->lang($this->data['lang_name']));
++		}
++
++		if($this->data['field_ident'] == 'phpbb_skype') {
++			return $this->language->lang('BBPROFILE_SKYPE_TEXT', $this->language->lang($this->data['lang_name']));
++		}
++
++		if($this->data['field_ident'] == 'phpbb_twitter') {
++			return $this->language->lang('BBPROFILE_TWITTER_TEXT', $this->language->lang($this->data['lang_name']));
++		}
++
++		if($this->data['field_ident'] == 'phpbb_youtube') {
++			return $this->language->lang('BBPROFILE_YOUTUBE_TEXT', $this->language->lang($this->data['lang_name']));
++		}
++
+ 		return $this->language->lang('BBPROFILE_CPF_TEXT', $this->language->lang($this->data['lang_name']));
+ 	}
+ 
+@@ -45,6 +78,62 @@ class cpf_part implements parts\part_interface
+ 
+ 	public function appeal_button()
+ 	{
++		if($this->data['field_ident'] == 'phpbb_interests') {
++			return array(
++				'label'	=> $this->language->lang('BBPROFILE_INTERESTS_BUTTON', $this->language->lang($this->data['lang_name'])),
++				'url'	=> append_sid($this->root_path . 'ucp.' . $this->php_ext, 'i=ucp_profile&mode=profile_info#bbprofile_cpf_' . $this->data['field_ident']),
++			);
++		}
++
++		if($this->data['field_ident'] == 'phpbb_occupation') {
++			return array(
++				'label'	=> $this->language->lang('BBPROFILE_OCCUPATION_BUTTON', $this->language->lang($this->data['lang_name'])),
++				'url'	=> append_sid($this->root_path . 'ucp.' . $this->php_ext, 'i=ucp_profile&mode=profile_info#bbprofile_cpf_' . $this->data['field_ident']),
++			);
++		}
++		
++		if($this->data['field_ident'] == 'phpbb_website') {
++			return array(
++				'label'	=> $this->language->lang('BBPROFILE_WEBSITE_BUTTON', $this->language->lang($this->data['lang_name'])),
++				'url'	=> append_sid($this->root_path . 'ucp.' . $this->php_ext, 'i=ucp_profile&mode=profile_info#bbprofile_cpf_' . $this->data['field_ident']),
++			);
++		}
++
++		if($this->data['field_ident'] == 'phpbb_location') {
++			return array(
++				'label'	=> $this->language->lang('BBPROFILE_LOCATION_BUTTON', $this->language->lang($this->data['lang_name'])),
++				'url'	=> append_sid($this->root_path . 'ucp.' . $this->php_ext, 'i=ucp_profile&mode=profile_info#bbprofile_cpf_' . $this->data['field_ident']),
++			);
++		}
++
++		if($this->data['field_ident'] == 'phpbb_facebook') {
++			return array(
++				'label'	=> $this->language->lang('BBPROFILE_FACEBOOK_BUTTON', $this->language->lang($this->data['lang_name'])),
++				'url'	=> append_sid($this->root_path . 'ucp.' . $this->php_ext, 'i=ucp_profile&mode=profile_info#bbprofile_cpf_' . $this->data['field_ident']),
++			);
++		}
++		
++		if($this->data['field_ident'] == 'phpbb_skype') {
++			return array(
++				'label'	=> $this->language->lang('BBPROFILE_SKYPE_BUTTON', $this->language->lang($this->data['lang_name'])),
++				'url'	=> append_sid($this->root_path . 'ucp.' . $this->php_ext, 'i=ucp_profile&mode=profile_info#bbprofile_cpf_' . $this->data['field_ident']),
++			);
++		}
++
++		if($this->data['field_ident'] == 'phpbb_twitter') {
++			return array(
++				'label'	=> $this->language->lang('BBPROFILE_TWITTER_BUTTON', $this->language->lang($this->data['lang_name'])),
++				'url'	=> append_sid($this->root_path . 'ucp.' . $this->php_ext, 'i=ucp_profile&mode=profile_info#bbprofile_cpf_' . $this->data['field_ident']),
++			);
++		}
++		
++		if($this->data['field_ident'] == 'phpbb_youtube') {
++			return array(
++				'label'	=> $this->language->lang('BBPROFILE_YOUTUBE_BUTTON', $this->language->lang($this->data['lang_name'])),
++				'url'	=> append_sid($this->root_path . 'ucp.' . $this->php_ext, 'i=ucp_profile&mode=profile_info#bbprofile_cpf_' . $this->data['field_ident']),
++			);
++		}
++
+ 		return array(
+ 			'label'	=> $this->language->lang('BBPROFILE_CPF_BTN_LABEL', $this->language->lang($this->data['lang_name'])),
+ 			'url'	=> append_sid($this->root_path . 'ucp.' . $this->php_ext, 'i=ucp_profile&mode=profile_info#bbprofile_cpf_' . $this->data['field_ident']),
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbprofile/profile_parts/parts/first_post.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbprofile/profile_parts/parts/first_post.php"
+index afd3d339f..c6067dd0c 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbprofile/profile_parts/parts/first_post.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbprofile/profile_parts/parts/first_post.php"
+@@ -23,7 +23,7 @@ class first_post extends base
+ 	{
+ 		return array(
+ 			'label'	=> $this->language->lang('BBPROFILE_FIRST_POST_BUTTON'),
+-			'url'	=> append_sid($this->root_path . 'index.' . $this->php_ext),
++			'url'	=> append_sid($this->root_path . 'viewtopic.' . $this->php_ext . '?f=27&t=640'),
+ 		);
+ 	}
+ }
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbprofile/styles/FLATBOOTS/template/event/header_breadcrumb_before.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbprofile/styles/FLATBOOTS/template/event/header_content_after.html"
+similarity index 100%
+rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbprofile/styles/FLATBOOTS/template/event/header_breadcrumb_before.html"
+rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbprofile/styles/FLATBOOTS/template/event/header_content_after.html"
diff --git "[FORUM_EXT]/sitesplat\\bbprofile/diff_nospace.tmp" "[FORUM_EXT]/sitesplat\\bbprofile/diff_nospace.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\bbprofile/diff_nospace.tmp"
@@ -0,0 +1,478 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbprofile/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbprofile/composer.json"
+index 25fa181a7..29299abb2 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbprofile/composer.json"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbprofile/composer.json"
+@@ -24,7 +24,8 @@
+ 		"version-check": {
+             "host": "sitesplat.com",
+             "directory": "/updatecheck/phpbb32/ext",
+-            "filename": "bbprofile.json"
++            "filename": "bbprofile.json",
++			"ssl": true
+ 		}
+     }
+ }
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbprofile/config/routing.yml" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbprofile/config/routing.yml"
+index b6f8c3239..8139bebff 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbprofile/config/routing.yml"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbprofile/config/routing.yml"
+@@ -1,3 +1,3 @@
+ sitesplat_bbprofile_controller:
+-    path: /demo/{name}
++    path: /profile/{name}
+     defaults: { _controller: sitesplat.bbprofile.controller:handle }
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbprofile/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbprofile/diff_full.tmp"
+new file mode 100644
+index 000000000..c5efccdce
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbprofile/diff_full.tmp"
+@@ -0,0 +1,465 @@
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbprofile/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbprofile/composer.json"
++index 25fa181a7..29299abb2 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbprofile/composer.json"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbprofile/composer.json"
++@@ -24,7 +24,8 @@
++ 		"version-check": {
++             "host": "sitesplat.com",
++             "directory": "/updatecheck/phpbb32/ext",
++-            "filename": "bbprofile.json"
+++            "filename": "bbprofile.json",
+++			"ssl": true
++ 		}
++     }
++ }
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbprofile/config/routing.yml" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbprofile/config/routing.yml"
++index b6f8c3239..8139bebff 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbprofile/config/routing.yml"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbprofile/config/routing.yml"
++@@ -1,3 +1,3 @@
++ sitesplat_bbprofile_controller:
++-    path: /demo/{name}
+++    path: /profile/{name}
++     defaults: { _controller: sitesplat.bbprofile.controller:handle }
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbprofile/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbprofile/diff_full.tmp"
++new file mode 100644
++index 000000000..e69de29bb
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbprofile/language/en/common.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbprofile/language/en/common.php"
++index 982e453d1..6179343e9 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbprofile/language/en/common.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbprofile/language/en/common.php"
++@@ -27,16 +27,27 @@ $lang = array_merge($lang, array(
++ 	'BBPROFILE_SIGNATURE_BUTTON'	=> 'Add signature under every post',
++ 	'BBPROFILE_AVATAR_TEXT'			=> 'Express yourself and show who you are or maybe represent, believe in...',
++ 	'BBPROFILE_AVATAR_BUTTON'		=> 'Add an avatar',
++-	'BBPROFILE_FACEBOOK_TEXT'		=> 'Make friends.',
+++
+++	'BBPROFILE_INTERESTS_TEXT'		=> 'Come on, stop being an asshole and share with your friends your awesome interests',
+++	'BBPROFILE_INTERESTS_BUTTON'	=> 'Add your interests',
+++	'BBPROFILE_OCCUPATION_TEXT'		=> 'What do you really do? Don\'t say "PLEASE"! Barney Stinson said it enough!',
+++	'BBPROFILE_OCCUPATION_BUTTON'	=> 'Add your hobbies',
+++	'BBPROFILE_WEBSITE_TEXT'		=> 'Do you own any website or blog?',
+++	'BBPROFILE_WEBSITE_BUTTON'		=> 'Promote what is yours, be proud!',
+++	'BBPROFILE_LOCATION_TEXT'		=> 'Do you want to share your location? What, did you call us stalkers?! But you always accept on Smartphone!',
+++	'BBPROFILE_LOCATION_BUTTON'		=> 'Fine. I want to meet nerdy neighbors anyway!',
+++
+++	'BBPROFILE_FACEBOOK_TEXT'		=> 'Make friends. But doesn\'t talk with strangers (Mother Siny tip)',
++ 	'BBPROFILE_FACEBOOK_BUTTON'		=> 'Add your Facebook account',
++-	'BBPROFILE_TWITTER_TEXT'		=> 'Let your tweets be heard.',
++-	'BBPROFILE_TWITTER_BUTTON'		=> 'Add your Twitter account',
++ 	'BBPROFILE_SKYPE_TEXT'			=> 'Talk to others.',
++ 	'BBPROFILE_SKYPE_BUTTON'		=> 'Add your Skype account',
+++	'BBPROFILE_TWITTER_TEXT'		=> 'Let your tweets be heard.',
+++	'BBPROFILE_TWITTER_BUTTON'		=> 'Add your Twitter account',
++ 	'BBPROFILE_YOUTUBE_TEXT'		=> 'Make your videos popular.',
++ 	'BBPROFILE_YOUTUBE_BUTTON'		=> 'Add your Youtube account',
++ 	'BBPROFILE_GOOGLEPLUS_TEXT'		=> 'Make friends.',
++ 	'BBPROFILE_GOOGLEPLUS_BUTTON'	=> 'Add your Google+ account',
+++
++ 	'BBPROFILE_FIRST_POST_TEXT'		=> 'Get involved in discussion. Select a forum and create a new topic!',
++ 	'BBPROFILE_FIRST_POST_BUTTON'	=> 'Create your first post.',
++ 
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbprofile/language/pt/common.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbprofile/language/pt/common.php"
++new file mode 100644
++index 000000000..06c5271eb
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbprofile/language/pt/common.php"
++@@ -0,0 +1,56 @@
+++<?php
+++/**
+++*
+++* BBbbprofile. An extension for the phpBB Forum Software package.
+++* @copyright (c) 2016, SiteSplat
+++* @license Proprietary
+++*
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
+++$lang = array_merge($lang, array(
+++	'COMPLETE_PROFILE_TITLE'	=> 'Completa o teu perfil',
+++	'COMPLETED_PERCENTAGE'		=> '%d%% completo',
+++
+++	'BBPROFILE_BIRTHDATE_TEXT'		=> 'Deixa os teus amigos goldtuganianos desejarem-te um feliz aniversário.',
+++	'BBPROFILE_BIRTHDATE_BUTTON'	=> 'Adiciona lá a data',
+++	'BBPROFILE_SIGNATURE_TEXT'		=> 'Usa para promover os teus projetos e as tuas ideias!',
+++	'BBPROFILE_SIGNATURE_BUTTON'	=> 'Adiciona uma assinatura',
+++	'BBPROFILE_AVATAR_TEXT'			=> 'Expressa-te e mostra-nos quem és e que personalidade é a tua!',
+++	'BBPROFILE_AVATAR_BUTTON'		=> 'Adiciona um avatar',
+++
+++	'BBPROFILE_INTERESTS_TEXT'		=> 'Anda lá, deixa de ser cortes e partilha com os teus amigos os teus interesses',
+++	'BBPROFILE_INTERESTS_BUTTON'	=> 'Adiciona os teus interesses',
+++	'BBPROFILE_OCCUPATION_TEXT'		=> 'O que é que fazes mesmo? Não digas "PLEASE"! Basta-nos um Barney Stinson!',
+++	'BBPROFILE_OCCUPATION_BUTTON'	=> 'Adiciona os teus hobbies',
+++	'BBPROFILE_WEBSITE_TEXT'		=> 'Tens algum site ou blog da tua autoria?',
+++	'BBPROFILE_WEBSITE_BUTTON'		=> 'Promove o que é teu, orgulha-te!',
+++	'BBPROFILE_LOCATION_TEXT'		=> 'Desejas partilhar a tua localização? O quê, chamaste-nos stalkers?! Mas tu aceitas sempre no Smartphone!',
+++	'BBPROFILE_LOCATION_BUTTON'		=> 'Ok! Quero encontrar vizinhos nerds!',
+++
+++	'BBPROFILE_FACEBOOK_TEXT'		=> 'Cria novas amizades, mas não fales com estranhos (Dica da mãezinha, Siny).',
+++	'BBPROFILE_FACEBOOK_BUTTON'		=> 'Adiciona a tua conta Facebook',
+++	'BBPROFILE_SKYPE_TEXT'			=> 'Se és daqueles que gosta de videochamadas em grupo e conhecer novas pessoas, partilha aí o skype.',
+++	'BBPROFILE_SKYPE_BUTTON'		=> 'Adiciona a tua conta Skype',
+++	'BBPROFILE_TWITTER_TEXT'		=> 'Faz ouvir os teus tweets.',
+++	'BBPROFILE_TWITTER_BUTTON'		=> 'Adiciona a tua conta Twitter',
+++	'BBPROFILE_YOUTUBE_TEXT'		=> 'Torna o teu canal mais popular ainda.',
+++	'BBPROFILE_YOUTUBE_BUTTON'		=> 'Adiciona a tua conta YouTube',
+++	'BBPROFILE_GOOGLEPLUS_TEXT'		=> 'Cria novas amizades.',
+++	'BBPROFILE_GOOGLEPLUS_BUTTON'	=> 'Adiciona a tua conta Google+',
+++	
+++	'BBPROFILE_FIRST_POST_TEXT'		=> 'Envolve-te na comunidade e nas suas discussões e convívios. Seleciona um fórum e cria um tópico novo!',
+++	'BBPROFILE_FIRST_POST_BUTTON'	=> 'Cria a tua primeira mensagem! Apresenta-te!',
+++
+++	'BBPROFILE_CPF_TEXT'		=> 'Conta-nos mais sobre ti, %s, tens?',
+++	'BBPROFILE_CPF_BTN_LABEL'	=> 'Preenche o campo %s',
+++));
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbprofile/language/pt/info_acp_bbprofile.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbprofile/language/pt/info_acp_bbprofile.php"
++new file mode 100644
++index 000000000..a5bcb6101
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbprofile/language/pt/info_acp_bbprofile.php"
++@@ -0,0 +1,44 @@
+++<?php
+++/**
+++*
+++* BBbbprofile. An extension for the phpBB Forum Software package.
+++* @copyright (c) 2016, SiteSplat
+++* @license Proprietary
+++*
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
+++$lang = array_merge($lang, array(
+++	'ACP_BBPROFILE'					=> 'BBprofile',
+++	'BBPROFILE_SETTING_SAVED'		=> 'BBprofile settings has been saved.',
+++
+++	'SS_HELPER_NOTY'	            => 'SiteSplat BBcore does not exist!<br />Download the <a href="http://sitesplat.com" target="_blank">BBcore</a> and copy the BBcore folder into your sitesplat extension folder.',
+++	'BBPROFILE_NOTICE'	            => '<div class="phpinfo"><p>The settings for this extension are under the <strong>EXTENSIONS</strong> tab.</p><br /><p>Don\'t forget to check the Group Permissions "Can see BBprofile box" under: Group Permissions &#187; Misc.</p></div>',
+++	
+++	'BBPROFILE_LABEL'				=> 'When should we display BBprofile?',
+++	'BBPROFILE_LABEL_EXPLAIN'	    => 'Choose the profile box location',
+++	'UCP_ONLY'						=> 'UCP only',
+++	'OVEARALL_HEADER'				=> 'Overall header',
+++
+++	'BBPROFILE_ENABLED'				=> 'Enabled BBprofile parts:',
+++    'BBPROFILE_ENABLED_EXPLAIN'		=> 'Choose the profile parts that should be counted towards the 100% profile completion',
+++
+++        'PREDEFINED'					=> 'Predefined',
+++	'CPF'							=> 'Custom Profile Fields',
+++	
+++	'BBPROFILE_HIDE_FOR_ADMINS'		=> 'Hide BBprofile box for admins:',
+++	'HIDE_FOR_ADMINS'				=> 'Hide for admins',
+++	'BBPROFILE_HIDE_FOR_MODS'		=> 'Hide BBprofile box for global moderators',
+++	'HIDE_FOR_MODS'					=> 'Hide for global moderators',
+++	'BBPROFILE_HIDDEN_FOR_ADMINS'	=> 'BBprofile box has been hidden for admins.',
+++	'BBPROFILE_HIDDEN_FOR_MODS'		=> 'BBprofile box has been hidden for global moderators.',
+++));
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbprofile/language/pt/permissions_bbprofile.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbprofile/language/pt/permissions_bbprofile.php"
++new file mode 100644
++index 000000000..53830b5a9
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbprofile/language/pt/permissions_bbprofile.php"
++@@ -0,0 +1,22 @@
+++<?php
+++/**
+++*
+++* BBbbprofile. An extension for the phpBB Forum Software package.
+++* @copyright (c) 2016, SiteSplat
+++* @license Proprietary
+++*
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
+++$lang = array_merge($lang, array(
+++    'ACL_U_BBPROFILE' => 'Pode ver caixa BBprofile',
+++));
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbprofile/language/pt_preao/common.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbprofile/language/pt_preao/common.php"
++new file mode 100644
++index 000000000..06c5271eb
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbprofile/language/pt_preao/common.php"
++@@ -0,0 +1,56 @@
+++<?php
+++/**
+++*
+++* BBbbprofile. An extension for the phpBB Forum Software package.
+++* @copyright (c) 2016, SiteSplat
+++* @license Proprietary
+++*
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
+++$lang = array_merge($lang, array(
+++	'COMPLETE_PROFILE_TITLE'	=> 'Completa o teu perfil',
+++	'COMPLETED_PERCENTAGE'		=> '%d%% completo',
+++
+++	'BBPROFILE_BIRTHDATE_TEXT'		=> 'Deixa os teus amigos goldtuganianos desejarem-te um feliz aniversário.',
+++	'BBPROFILE_BIRTHDATE_BUTTON'	=> 'Adiciona lá a data',
+++	'BBPROFILE_SIGNATURE_TEXT'		=> 'Usa para promover os teus projetos e as tuas ideias!',
+++	'BBPROFILE_SIGNATURE_BUTTON'	=> 'Adiciona uma assinatura',
+++	'BBPROFILE_AVATAR_TEXT'			=> 'Expressa-te e mostra-nos quem és e que personalidade é a tua!',
+++	'BBPROFILE_AVATAR_BUTTON'		=> 'Adiciona um avatar',
+++
+++	'BBPROFILE_INTERESTS_TEXT'		=> 'Anda lá, deixa de ser cortes e partilha com os teus amigos os teus interesses',
+++	'BBPROFILE_INTERESTS_BUTTON'	=> 'Adiciona os teus interesses',
+++	'BBPROFILE_OCCUPATION_TEXT'		=> 'O que é que fazes mesmo? Não digas "PLEASE"! Basta-nos um Barney Stinson!',
+++	'BBPROFILE_OCCUPATION_BUTTON'	=> 'Adiciona os teus hobbies',
+++	'BBPROFILE_WEBSITE_TEXT'		=> 'Tens algum site ou blog da tua autoria?',
+++	'BBPROFILE_WEBSITE_BUTTON'		=> 'Promove o que é teu, orgulha-te!',
+++	'BBPROFILE_LOCATION_TEXT'		=> 'Desejas partilhar a tua localização? O quê, chamaste-nos stalkers?! Mas tu aceitas sempre no Smartphone!',
+++	'BBPROFILE_LOCATION_BUTTON'		=> 'Ok! Quero encontrar vizinhos nerds!',
+++
+++	'BBPROFILE_FACEBOOK_TEXT'		=> 'Cria novas amizades, mas não fales com estranhos (Dica da mãezinha, Siny).',
+++	'BBPROFILE_FACEBOOK_BUTTON'		=> 'Adiciona a tua conta Facebook',
+++	'BBPROFILE_SKYPE_TEXT'			=> 'Se és daqueles que gosta de videochamadas em grupo e conhecer novas pessoas, partilha aí o skype.',
+++	'BBPROFILE_SKYPE_BUTTON'		=> 'Adiciona a tua conta Skype',
+++	'BBPROFILE_TWITTER_TEXT'		=> 'Faz ouvir os teus tweets.',
+++	'BBPROFILE_TWITTER_BUTTON'		=> 'Adiciona a tua conta Twitter',
+++	'BBPROFILE_YOUTUBE_TEXT'		=> 'Torna o teu canal mais popular ainda.',
+++	'BBPROFILE_YOUTUBE_BUTTON'		=> 'Adiciona a tua conta YouTube',
+++	'BBPROFILE_GOOGLEPLUS_TEXT'		=> 'Cria novas amizades.',
+++	'BBPROFILE_GOOGLEPLUS_BUTTON'	=> 'Adiciona a tua conta Google+',
+++	
+++	'BBPROFILE_FIRST_POST_TEXT'		=> 'Envolve-te na comunidade e nas suas discussões e convívios. Seleciona um fórum e cria um tópico novo!',
+++	'BBPROFILE_FIRST_POST_BUTTON'	=> 'Cria a tua primeira mensagem! Apresenta-te!',
+++
+++	'BBPROFILE_CPF_TEXT'		=> 'Conta-nos mais sobre ti, %s, tens?',
+++	'BBPROFILE_CPF_BTN_LABEL'	=> 'Preenche o campo %s',
+++));
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbprofile/language/pt_preao/info_acp_bbprofile.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbprofile/language/pt_preao/info_acp_bbprofile.php"
++new file mode 100644
++index 000000000..a5bcb6101
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbprofile/language/pt_preao/info_acp_bbprofile.php"
++@@ -0,0 +1,44 @@
+++<?php
+++/**
+++*
+++* BBbbprofile. An extension for the phpBB Forum Software package.
+++* @copyright (c) 2016, SiteSplat
+++* @license Proprietary
+++*
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
+++$lang = array_merge($lang, array(
+++	'ACP_BBPROFILE'					=> 'BBprofile',
+++	'BBPROFILE_SETTING_SAVED'		=> 'BBprofile settings has been saved.',
+++
+++	'SS_HELPER_NOTY'	            => 'SiteSplat BBcore does not exist!<br />Download the <a href="http://sitesplat.com" target="_blank">BBcore</a> and copy the BBcore folder into your sitesplat extension folder.',
+++	'BBPROFILE_NOTICE'	            => '<div class="phpinfo"><p>The settings for this extension are under the <strong>EXTENSIONS</strong> tab.</p><br /><p>Don\'t forget to check the Group Permissions "Can see BBprofile box" under: Group Permissions &#187; Misc.</p></div>',
+++	
+++	'BBPROFILE_LABEL'				=> 'When should we display BBprofile?',
+++	'BBPROFILE_LABEL_EXPLAIN'	    => 'Choose the profile box location',
+++	'UCP_ONLY'						=> 'UCP only',
+++	'OVEARALL_HEADER'				=> 'Overall header',
+++
+++	'BBPROFILE_ENABLED'				=> 'Enabled BBprofile parts:',
+++    'BBPROFILE_ENABLED_EXPLAIN'		=> 'Choose the profile parts that should be counted towards the 100% profile completion',
+++
+++        'PREDEFINED'					=> 'Predefined',
+++	'CPF'							=> 'Custom Profile Fields',
+++	
+++	'BBPROFILE_HIDE_FOR_ADMINS'		=> 'Hide BBprofile box for admins:',
+++	'HIDE_FOR_ADMINS'				=> 'Hide for admins',
+++	'BBPROFILE_HIDE_FOR_MODS'		=> 'Hide BBprofile box for global moderators',
+++	'HIDE_FOR_MODS'					=> 'Hide for global moderators',
+++	'BBPROFILE_HIDDEN_FOR_ADMINS'	=> 'BBprofile box has been hidden for admins.',
+++	'BBPROFILE_HIDDEN_FOR_MODS'		=> 'BBprofile box has been hidden for global moderators.',
+++));
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbprofile/language/pt_preao/permissions_bbprofile.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbprofile/language/pt_preao/permissions_bbprofile.php"
++new file mode 100644
++index 000000000..53830b5a9
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbprofile/language/pt_preao/permissions_bbprofile.php"
++@@ -0,0 +1,22 @@
+++<?php
+++/**
+++*
+++* BBbbprofile. An extension for the phpBB Forum Software package.
+++* @copyright (c) 2016, SiteSplat
+++* @license Proprietary
+++*
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
+++$lang = array_merge($lang, array(
+++    'ACL_U_BBPROFILE' => 'Pode ver caixa BBprofile',
+++));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbprofile/profile_parts/cpf_part.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbprofile/profile_parts/cpf_part.php"
++index 813869ee8..052118824 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbprofile/profile_parts/cpf_part.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbprofile/profile_parts/cpf_part.php"
++@@ -35,6 +35,39 @@ class cpf_part implements parts\part_interface
++ 
++ 	public function appeal_text()
++ 	{
+++
+++		if($this->data['field_ident'] == 'phpbb_interests') {
+++			return $this->language->lang('BBPROFILE_INTERESTS_TEXT', $this->language->lang($this->data['lang_name']));
+++		}
+++
+++		if($this->data['field_ident'] == 'phpbb_occupation') {
+++			return $this->language->lang('BBPROFILE_OCCUPATION_TEXT', $this->language->lang($this->data['lang_name']));
+++		}
+++
+++		if($this->data['field_ident'] == 'phpbb_website') {
+++			return $this->language->lang('BBPROFILE_WEBSITE_TEXT', $this->language->lang($this->data['lang_name']));
+++		}
+++
+++		if($this->data['field_ident'] == 'phpbb_location') {
+++			return $this->language->lang('BBPROFILE_LOCATION_TEXT', $this->language->lang($this->data['lang_name']));
+++		}
+++
+++		if($this->data['field_ident'] == 'phpbb_facebook') {
+++			return $this->language->lang('BBPROFILE_FACEBOOK_TEXT', $this->language->lang($this->data['lang_name']));
+++		}
+++
+++		if($this->data['field_ident'] == 'phpbb_skype') {
+++			return $this->language->lang('BBPROFILE_SKYPE_TEXT', $this->language->lang($this->data['lang_name']));
+++		}
+++
+++		if($this->data['field_ident'] == 'phpbb_twitter') {
+++			return $this->language->lang('BBPROFILE_TWITTER_TEXT', $this->language->lang($this->data['lang_name']));
+++		}
+++
+++		if($this->data['field_ident'] == 'phpbb_youtube') {
+++			return $this->language->lang('BBPROFILE_YOUTUBE_TEXT', $this->language->lang($this->data['lang_name']));
+++		}
+++
++ 		return $this->language->lang('BBPROFILE_CPF_TEXT', $this->language->lang($this->data['lang_name']));
++ 	}
++ 
++@@ -45,6 +78,62 @@ class cpf_part implements parts\part_interface
++ 
++ 	public function appeal_button()
++ 	{
+++		if($this->data['field_ident'] == 'phpbb_interests') {
+++			return array(
+++				'label'	=> $this->language->lang('BBPROFILE_INTERESTS_BUTTON', $this->language->lang($this->data['lang_name'])),
+++				'url'	=> append_sid($this->root_path . 'ucp.' . $this->php_ext, 'i=ucp_profile&mode=profile_info#bbprofile_cpf_' . $this->data['field_ident']),
+++			);
+++		}
+++
+++		if($this->data['field_ident'] == 'phpbb_occupation') {
+++			return array(
+++				'label'	=> $this->language->lang('BBPROFILE_OCCUPATION_BUTTON', $this->language->lang($this->data['lang_name'])),
+++				'url'	=> append_sid($this->root_path . 'ucp.' . $this->php_ext, 'i=ucp_profile&mode=profile_info#bbprofile_cpf_' . $this->data['field_ident']),
+++			);
+++		}
+++		
+++		if($this->data['field_ident'] == 'phpbb_website') {
+++			return array(
+++				'label'	=> $this->language->lang('BBPROFILE_WEBSITE_BUTTON', $this->language->lang($this->data['lang_name'])),
+++				'url'	=> append_sid($this->root_path . 'ucp.' . $this->php_ext, 'i=ucp_profile&mode=profile_info#bbprofile_cpf_' . $this->data['field_ident']),
+++			);
+++		}
+++
+++		if($this->data['field_ident'] == 'phpbb_location') {
+++			return array(
+++				'label'	=> $this->language->lang('BBPROFILE_LOCATION_BUTTON', $this->language->lang($this->data['lang_name'])),
+++				'url'	=> append_sid($this->root_path . 'ucp.' . $this->php_ext, 'i=ucp_profile&mode=profile_info#bbprofile_cpf_' . $this->data['field_ident']),
+++			);
+++		}
+++
+++		if($this->data['field_ident'] == 'phpbb_facebook') {
+++			return array(
+++				'label'	=> $this->language->lang('BBPROFILE_FACEBOOK_BUTTON', $this->language->lang($this->data['lang_name'])),
+++				'url'	=> append_sid($this->root_path . 'ucp.' . $this->php_ext, 'i=ucp_profile&mode=profile_info#bbprofile_cpf_' . $this->data['field_ident']),
+++			);
+++		}
+++		
+++		if($this->data['field_ident'] == 'phpbb_skype') {
+++			return array(
+++				'label'	=> $this->language->lang('BBPROFILE_SKYPE_BUTTON', $this->language->lang($this->data['lang_name'])),
+++				'url'	=> append_sid($this->root_path . 'ucp.' . $this->php_ext, 'i=ucp_profile&mode=profile_info#bbprofile_cpf_' . $this->data['field_ident']),
+++			);
+++		}
+++
+++		if($this->data['field_ident'] == 'phpbb_twitter') {
+++			return array(
+++				'label'	=> $this->language->lang('BBPROFILE_TWITTER_BUTTON', $this->language->lang($this->data['lang_name'])),
+++				'url'	=> append_sid($this->root_path . 'ucp.' . $this->php_ext, 'i=ucp_profile&mode=profile_info#bbprofile_cpf_' . $this->data['field_ident']),
+++			);
+++		}
+++		
+++		if($this->data['field_ident'] == 'phpbb_youtube') {
+++			return array(
+++				'label'	=> $this->language->lang('BBPROFILE_YOUTUBE_BUTTON', $this->language->lang($this->data['lang_name'])),
+++				'url'	=> append_sid($this->root_path . 'ucp.' . $this->php_ext, 'i=ucp_profile&mode=profile_info#bbprofile_cpf_' . $this->data['field_ident']),
+++			);
+++		}
+++
++ 		return array(
++ 			'label'	=> $this->language->lang('BBPROFILE_CPF_BTN_LABEL', $this->language->lang($this->data['lang_name'])),
++ 			'url'	=> append_sid($this->root_path . 'ucp.' . $this->php_ext, 'i=ucp_profile&mode=profile_info#bbprofile_cpf_' . $this->data['field_ident']),
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbprofile/profile_parts/parts/first_post.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbprofile/profile_parts/parts/first_post
\ No newline at end of file
diff --git "[ORIGINAL]/sitesplat\\bbprofile/language/en/common.php" "[FORUM_EXT]/sitesplat\\bbprofile/language/en/common.php"
--- "[ORIGINAL]/sitesplat\\bbprofile/language/en/common.php"
+++ "[FORUM_EXT]/sitesplat\\bbprofile/language/en/common.php"
@@ -27,16 +27,27 @@ $lang = array_merge($lang, array(
 	'BBPROFILE_SIGNATURE_BUTTON'	=> 'Add signature under every post',
 	'BBPROFILE_AVATAR_TEXT'			=> 'Express yourself and show who you are or maybe represent, believe in...',
 	'BBPROFILE_AVATAR_BUTTON'		=> 'Add an avatar',
-	'BBPROFILE_FACEBOOK_TEXT'		=> 'Make friends.',
+
+	'BBPROFILE_INTERESTS_TEXT'		=> 'Come on, stop being an asshole and share with your friends your awesome interests',
+	'BBPROFILE_INTERESTS_BUTTON'	=> 'Add your interests',
+	'BBPROFILE_OCCUPATION_TEXT'		=> 'What do you really do? Don\'t say "PLEASE"! Barney Stinson said it enough!',
+	'BBPROFILE_OCCUPATION_BUTTON'	=> 'Add your hobbies',
+	'BBPROFILE_WEBSITE_TEXT'		=> 'Do you own any website or blog?',
+	'BBPROFILE_WEBSITE_BUTTON'		=> 'Promote what is yours, be proud!',
+	'BBPROFILE_LOCATION_TEXT'		=> 'Do you want to share your location? What, did you call us stalkers?! But you always accept on Smartphone!',
+	'BBPROFILE_LOCATION_BUTTON'		=> 'Fine. I want to meet nerdy neighbors anyway!',
+
+	'BBPROFILE_FACEBOOK_TEXT'		=> 'Make friends. But doesn\'t talk with strangers (Mother Siny tip)',
 	'BBPROFILE_FACEBOOK_BUTTON'		=> 'Add your Facebook account',
-	'BBPROFILE_TWITTER_TEXT'		=> 'Let your tweets be heard.',
-	'BBPROFILE_TWITTER_BUTTON'		=> 'Add your Twitter account',
 	'BBPROFILE_SKYPE_TEXT'			=> 'Talk to others.',
 	'BBPROFILE_SKYPE_BUTTON'		=> 'Add your Skype account',
+	'BBPROFILE_TWITTER_TEXT'		=> 'Let your tweets be heard.',
+	'BBPROFILE_TWITTER_BUTTON'		=> 'Add your Twitter account',
 	'BBPROFILE_YOUTUBE_TEXT'		=> 'Make your videos popular.',
 	'BBPROFILE_YOUTUBE_BUTTON'		=> 'Add your Youtube account',
 	'BBPROFILE_GOOGLEPLUS_TEXT'		=> 'Make friends.',
 	'BBPROFILE_GOOGLEPLUS_BUTTON'	=> 'Add your Google+ account',
+
 	'BBPROFILE_FIRST_POST_TEXT'		=> 'Get involved in discussion. Select a forum and create a new topic!',
 	'BBPROFILE_FIRST_POST_BUTTON'	=> 'Create your first post.',
 
diff --git "[FORUM_EXT]/sitesplat\\bbprofile/language/pt/common.php" "[FORUM_EXT]/sitesplat\\bbprofile/language/pt/common.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\bbprofile/language/pt/common.php"
@@ -0,0 +1,56 @@
+<?php
+/**
+*
+* BBbbprofile. An extension for the phpBB Forum Software package.
+* @copyright (c) 2016, SiteSplat
+* @license Proprietary
+*
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
+$lang = array_merge($lang, array(
+	'COMPLETE_PROFILE_TITLE'	=> 'Completa o teu perfil',
+	'COMPLETED_PERCENTAGE'		=> '%d%% completo',
+
+	'BBPROFILE_BIRTHDATE_TEXT'		=> 'Deixa os teus amigos goldtuganianos desejarem-te um feliz aniversário.',
+	'BBPROFILE_BIRTHDATE_BUTTON'	=> 'Adiciona lá a data',
+	'BBPROFILE_SIGNATURE_TEXT'		=> 'Usa para promover os teus projetos e as tuas ideias!',
+	'BBPROFILE_SIGNATURE_BUTTON'	=> 'Adiciona uma assinatura',
+	'BBPROFILE_AVATAR_TEXT'			=> 'Expressa-te e mostra-nos quem és e que personalidade é a tua!',
+	'BBPROFILE_AVATAR_BUTTON'		=> 'Adiciona um avatar',
+
+	'BBPROFILE_INTERESTS_TEXT'		=> 'Anda lá, deixa de ser cortes e partilha com os teus amigos os teus interesses',
+	'BBPROFILE_INTERESTS_BUTTON'	=> 'Adiciona os teus interesses',
+	'BBPROFILE_OCCUPATION_TEXT'		=> 'O que é que fazes mesmo? Não digas "PLEASE"! Basta-nos um Barney Stinson!',
+	'BBPROFILE_OCCUPATION_BUTTON'	=> 'Adiciona os teus hobbies',
+	'BBPROFILE_WEBSITE_TEXT'		=> 'Tens algum site ou blog da tua autoria?',
+	'BBPROFILE_WEBSITE_BUTTON'		=> 'Promove o que é teu, orgulha-te!',
+	'BBPROFILE_LOCATION_TEXT'		=> 'Desejas partilhar a tua localização? O quê, chamaste-nos stalkers?! Mas tu aceitas sempre no Smartphone!',
+	'BBPROFILE_LOCATION_BUTTON'		=> 'Ok! Quero encontrar vizinhos nerds!',
+
+	'BBPROFILE_FACEBOOK_TEXT'		=> 'Cria novas amizades, mas não fales com estranhos (Dica da mãezinha, Siny).',
+	'BBPROFILE_FACEBOOK_BUTTON'		=> 'Adiciona a tua conta Facebook',
+	'BBPROFILE_SKYPE_TEXT'			=> 'Se és daqueles que gosta de videochamadas em grupo e conhecer novas pessoas, partilha aí o skype.',
+	'BBPROFILE_SKYPE_BUTTON'		=> 'Adiciona a tua conta Skype',
+	'BBPROFILE_TWITTER_TEXT'		=> 'Faz ouvir os teus tweets.',
+	'BBPROFILE_TWITTER_BUTTON'		=> 'Adiciona a tua conta Twitter',
+	'BBPROFILE_YOUTUBE_TEXT'		=> 'Torna o teu canal mais popular ainda.',
+	'BBPROFILE_YOUTUBE_BUTTON'		=> 'Adiciona a tua conta YouTube',
+	'BBPROFILE_GOOGLEPLUS_TEXT'		=> 'Cria novas amizades.',
+	'BBPROFILE_GOOGLEPLUS_BUTTON'	=> 'Adiciona a tua conta Google+',
+	
+	'BBPROFILE_FIRST_POST_TEXT'		=> 'Envolve-te na comunidade e nas suas discussões e convívios. Seleciona um fórum e cria um tópico novo!',
+	'BBPROFILE_FIRST_POST_BUTTON'	=> 'Cria a tua primeira mensagem! Apresenta-te!',
+
+	'BBPROFILE_CPF_TEXT'		=> 'Conta-nos mais sobre ti, %s, tens?',
+	'BBPROFILE_CPF_BTN_LABEL'	=> 'Preenche o campo %s',
+));
diff --git "[FORUM_EXT]/sitesplat\\bbprofile/language/pt/info_acp_bbprofile.php" "[FORUM_EXT]/sitesplat\\bbprofile/language/pt/info_acp_bbprofile.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\bbprofile/language/pt/info_acp_bbprofile.php"
@@ -0,0 +1,44 @@
+<?php
+/**
+*
+* BBbbprofile. An extension for the phpBB Forum Software package.
+* @copyright (c) 2016, SiteSplat
+* @license Proprietary
+*
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
+$lang = array_merge($lang, array(
+	'ACP_BBPROFILE'					=> 'BBprofile',
+	'BBPROFILE_SETTING_SAVED'		=> 'BBprofile settings has been saved.',
+
+	'SS_HELPER_NOTY'	            => 'SiteSplat BBcore does not exist!<br />Download the <a href="http://sitesplat.com" target="_blank">BBcore</a> and copy the BBcore folder into your sitesplat extension folder.',
+	'BBPROFILE_NOTICE'	            => '<div class="phpinfo"><p>The settings for this extension are under the <strong>EXTENSIONS</strong> tab.</p><br /><p>Don\'t forget to check the Group Permissions "Can see BBprofile box" under: Group Permissions &#187; Misc.</p></div>',
+	
+	'BBPROFILE_LABEL'				=> 'When should we display BBprofile?',
+	'BBPROFILE_LABEL_EXPLAIN'	    => 'Choose the profile box location',
+	'UCP_ONLY'						=> 'UCP only',
+	'OVEARALL_HEADER'				=> 'Overall header',
+
+	'BBPROFILE_ENABLED'				=> 'Enabled BBprofile parts:',
+    'BBPROFILE_ENABLED_EXPLAIN'		=> 'Choose the profile parts that should be counted towards the 100% profile completion',
+
+        'PREDEFINED'					=> 'Predefined',
+	'CPF'							=> 'Custom Profile Fields',
+	
+	'BBPROFILE_HIDE_FOR_ADMINS'		=> 'Hide BBprofile box for admins:',
+	'HIDE_FOR_ADMINS'				=> 'Hide for admins',
+	'BBPROFILE_HIDE_FOR_MODS'		=> 'Hide BBprofile box for global moderators',
+	'HIDE_FOR_MODS'					=> 'Hide for global moderators',
+	'BBPROFILE_HIDDEN_FOR_ADMINS'	=> 'BBprofile box has been hidden for admins.',
+	'BBPROFILE_HIDDEN_FOR_MODS'		=> 'BBprofile box has been hidden for global moderators.',
+));
diff --git "[FORUM_EXT]/sitesplat\\bbprofile/language/pt/permissions_bbprofile.php" "[FORUM_EXT]/sitesplat\\bbprofile/language/pt/permissions_bbprofile.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\bbprofile/language/pt/permissions_bbprofile.php"
@@ -0,0 +1,22 @@
+<?php
+/**
+*
+* BBbbprofile. An extension for the phpBB Forum Software package.
+* @copyright (c) 2016, SiteSplat
+* @license Proprietary
+*
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
+$lang = array_merge($lang, array(
+    'ACL_U_BBPROFILE' => 'Pode ver caixa BBprofile',
+));
diff --git "[FORUM_EXT]/sitesplat\\bbprofile/language/pt_preao/common.php" "[FORUM_EXT]/sitesplat\\bbprofile/language/pt_preao/common.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\bbprofile/language/pt_preao/common.php"
@@ -0,0 +1,56 @@
+<?php
+/**
+*
+* BBbbprofile. An extension for the phpBB Forum Software package.
+* @copyright (c) 2016, SiteSplat
+* @license Proprietary
+*
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
+$lang = array_merge($lang, array(
+	'COMPLETE_PROFILE_TITLE'	=> 'Completa o teu perfil',
+	'COMPLETED_PERCENTAGE'		=> '%d%% completo',
+
+	'BBPROFILE_BIRTHDATE_TEXT'		=> 'Deixa os teus amigos goldtuganianos desejarem-te um feliz aniversário.',
+	'BBPROFILE_BIRTHDATE_BUTTON'	=> 'Adiciona lá a data',
+	'BBPROFILE_SIGNATURE_TEXT'		=> 'Usa para promover os teus projetos e as tuas ideias!',
+	'BBPROFILE_SIGNATURE_BUTTON'	=> 'Adiciona uma assinatura',
+	'BBPROFILE_AVATAR_TEXT'			=> 'Expressa-te e mostra-nos quem és e que personalidade é a tua!',
+	'BBPROFILE_AVATAR_BUTTON'		=> 'Adiciona um avatar',
+
+	'BBPROFILE_INTERESTS_TEXT'		=> 'Anda lá, deixa de ser cortes e partilha com os teus amigos os teus interesses',
+	'BBPROFILE_INTERESTS_BUTTON'	=> 'Adiciona os teus interesses',
+	'BBPROFILE_OCCUPATION_TEXT'		=> 'O que é que fazes mesmo? Não digas "PLEASE"! Basta-nos um Barney Stinson!',
+	'BBPROFILE_OCCUPATION_BUTTON'	=> 'Adiciona os teus hobbies',
+	'BBPROFILE_WEBSITE_TEXT'		=> 'Tens algum site ou blog da tua autoria?',
+	'BBPROFILE_WEBSITE_BUTTON'		=> 'Promove o que é teu, orgulha-te!',
+	'BBPROFILE_LOCATION_TEXT'		=> 'Desejas partilhar a tua localização? O quê, chamaste-nos stalkers?! Mas tu aceitas sempre no Smartphone!',
+	'BBPROFILE_LOCATION_BUTTON'		=> 'Ok! Quero encontrar vizinhos nerds!',
+
+	'BBPROFILE_FACEBOOK_TEXT'		=> 'Cria novas amizades, mas não fales com estranhos (Dica da mãezinha, Siny).',
+	'BBPROFILE_FACEBOOK_BUTTON'		=> 'Adiciona a tua conta Facebook',
+	'BBPROFILE_SKYPE_TEXT'			=> 'Se és daqueles que gosta de videochamadas em grupo e conhecer novas pessoas, partilha aí o skype.',
+	'BBPROFILE_SKYPE_BUTTON'		=> 'Adiciona a tua conta Skype',
+	'BBPROFILE_TWITTER_TEXT'		=> 'Faz ouvir os teus tweets.',
+	'BBPROFILE_TWITTER_BUTTON'		=> 'Adiciona a tua conta Twitter',
+	'BBPROFILE_YOUTUBE_TEXT'		=> 'Torna o teu canal mais popular ainda.',
+	'BBPROFILE_YOUTUBE_BUTTON'		=> 'Adiciona a tua conta YouTube',
+	'BBPROFILE_GOOGLEPLUS_TEXT'		=> 'Cria novas amizades.',
+	'BBPROFILE_GOOGLEPLUS_BUTTON'	=> 'Adiciona a tua conta Google+',
+	
+	'BBPROFILE_FIRST_POST_TEXT'		=> 'Envolve-te na comunidade e nas suas discussões e convívios. Seleciona um fórum e cria um tópico novo!',
+	'BBPROFILE_FIRST_POST_BUTTON'	=> 'Cria a tua primeira mensagem! Apresenta-te!',
+
+	'BBPROFILE_CPF_TEXT'		=> 'Conta-nos mais sobre ti, %s, tens?',
+	'BBPROFILE_CPF_BTN_LABEL'	=> 'Preenche o campo %s',
+));
diff --git "[FORUM_EXT]/sitesplat\\bbprofile/language/pt_preao/info_acp_bbprofile.php" "[FORUM_EXT]/sitesplat\\bbprofile/language/pt_preao/info_acp_bbprofile.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\bbprofile/language/pt_preao/info_acp_bbprofile.php"
@@ -0,0 +1,44 @@
+<?php
+/**
+*
+* BBbbprofile. An extension for the phpBB Forum Software package.
+* @copyright (c) 2016, SiteSplat
+* @license Proprietary
+*
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
+$lang = array_merge($lang, array(
+	'ACP_BBPROFILE'					=> 'BBprofile',
+	'BBPROFILE_SETTING_SAVED'		=> 'BBprofile settings has been saved.',
+
+	'SS_HELPER_NOTY'	            => 'SiteSplat BBcore does not exist!<br />Download the <a href="http://sitesplat.com" target="_blank">BBcore</a> and copy the BBcore folder into your sitesplat extension folder.',
+	'BBPROFILE_NOTICE'	            => '<div class="phpinfo"><p>The settings for this extension are under the <strong>EXTENSIONS</strong> tab.</p><br /><p>Don\'t forget to check the Group Permissions "Can see BBprofile box" under: Group Permissions &#187; Misc.</p></div>',
+	
+	'BBPROFILE_LABEL'				=> 'When should we display BBprofile?',
+	'BBPROFILE_LABEL_EXPLAIN'	    => 'Choose the profile box location',
+	'UCP_ONLY'						=> 'UCP only',
+	'OVEARALL_HEADER'				=> 'Overall header',
+
+	'BBPROFILE_ENABLED'				=> 'Enabled BBprofile parts:',
+    'BBPROFILE_ENABLED_EXPLAIN'		=> 'Choose the profile parts that should be counted towards the 100% profile completion',
+
+        'PREDEFINED'					=> 'Predefined',
+	'CPF'							=> 'Custom Profile Fields',
+	
+	'BBPROFILE_HIDE_FOR_ADMINS'		=> 'Hide BBprofile box for admins:',
+	'HIDE_FOR_ADMINS'				=> 'Hide for admins',
+	'BBPROFILE_HIDE_FOR_MODS'		=> 'Hide BBprofile box for global moderators',
+	'HIDE_FOR_MODS'					=> 'Hide for global moderators',
+	'BBPROFILE_HIDDEN_FOR_ADMINS'	=> 'BBprofile box has been hidden for admins.',
+	'BBPROFILE_HIDDEN_FOR_MODS'		=> 'BBprofile box has been hidden for global moderators.',
+));
diff --git "[FORUM_EXT]/sitesplat\\bbprofile/language/pt_preao/permissions_bbprofile.php" "[FORUM_EXT]/sitesplat\\bbprofile/language/pt_preao/permissions_bbprofile.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\bbprofile/language/pt_preao/permissions_bbprofile.php"
@@ -0,0 +1,22 @@
+<?php
+/**
+*
+* BBbbprofile. An extension for the phpBB Forum Software package.
+* @copyright (c) 2016, SiteSplat
+* @license Proprietary
+*
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
+$lang = array_merge($lang, array(
+    'ACL_U_BBPROFILE' => 'Pode ver caixa BBprofile',
+));
diff --git "[ORIGINAL]/sitesplat\\bbprofile/profile_parts/cpf_part.php" "[FORUM_EXT]/sitesplat\\bbprofile/profile_parts/cpf_part.php"
--- "[ORIGINAL]/sitesplat\\bbprofile/profile_parts/cpf_part.php"
+++ "[FORUM_EXT]/sitesplat\\bbprofile/profile_parts/cpf_part.php"
@@ -35,6 +35,39 @@ class cpf_part implements parts\part_interface
 
 	public function appeal_text()
 	{
+
+		if($this->data['field_ident'] == 'phpbb_interests') {
+			return $this->language->lang('BBPROFILE_INTERESTS_TEXT', $this->language->lang($this->data['lang_name']));
+		}
+
+		if($this->data['field_ident'] == 'phpbb_occupation') {
+			return $this->language->lang('BBPROFILE_OCCUPATION_TEXT', $this->language->lang($this->data['lang_name']));
+		}
+
+		if($this->data['field_ident'] == 'phpbb_website') {
+			return $this->language->lang('BBPROFILE_WEBSITE_TEXT', $this->language->lang($this->data['lang_name']));
+		}
+
+		if($this->data['field_ident'] == 'phpbb_location') {
+			return $this->language->lang('BBPROFILE_LOCATION_TEXT', $this->language->lang($this->data['lang_name']));
+		}
+
+		if($this->data['field_ident'] == 'phpbb_facebook') {
+			return $this->language->lang('BBPROFILE_FACEBOOK_TEXT', $this->language->lang($this->data['lang_name']));
+		}
+
+		if($this->data['field_ident'] == 'phpbb_skype') {
+			return $this->language->lang('BBPROFILE_SKYPE_TEXT', $this->language->lang($this->data['lang_name']));
+		}
+
+		if($this->data['field_ident'] == 'phpbb_twitter') {
+			return $this->language->lang('BBPROFILE_TWITTER_TEXT', $this->language->lang($this->data['lang_name']));
+		}
+
+		if($this->data['field_ident'] == 'phpbb_youtube') {
+			return $this->language->lang('BBPROFILE_YOUTUBE_TEXT', $this->language->lang($this->data['lang_name']));
+		}
+
 		return $this->language->lang('BBPROFILE_CPF_TEXT', $this->language->lang($this->data['lang_name']));
 	}
 
@@ -45,6 +78,62 @@ class cpf_part implements parts\part_interface
 
 	public function appeal_button()
 	{
+		if($this->data['field_ident'] == 'phpbb_interests') {
+			return array(
+				'label'	=> $this->language->lang('BBPROFILE_INTERESTS_BUTTON', $this->language->lang($this->data['lang_name'])),
+				'url'	=> append_sid($this->root_path . 'ucp.' . $this->php_ext, 'i=ucp_profile&mode=profile_info#bbprofile_cpf_' . $this->data['field_ident']),
+			);
+		}
+
+		if($this->data['field_ident'] == 'phpbb_occupation') {
+			return array(
+				'label'	=> $this->language->lang('BBPROFILE_OCCUPATION_BUTTON', $this->language->lang($this->data['lang_name'])),
+				'url'	=> append_sid($this->root_path . 'ucp.' . $this->php_ext, 'i=ucp_profile&mode=profile_info#bbprofile_cpf_' . $this->data['field_ident']),
+			);
+		}
+		
+		if($this->data['field_ident'] == 'phpbb_website') {
+			return array(
+				'label'	=> $this->language->lang('BBPROFILE_WEBSITE_BUTTON', $this->language->lang($this->data['lang_name'])),
+				'url'	=> append_sid($this->root_path . 'ucp.' . $this->php_ext, 'i=ucp_profile&mode=profile_info#bbprofile_cpf_' . $this->data['field_ident']),
+			);
+		}
+
+		if($this->data['field_ident'] == 'phpbb_location') {
+			return array(
+				'label'	=> $this->language->lang('BBPROFILE_LOCATION_BUTTON', $this->language->lang($this->data['lang_name'])),
+				'url'	=> append_sid($this->root_path . 'ucp.' . $this->php_ext, 'i=ucp_profile&mode=profile_info#bbprofile_cpf_' . $this->data['field_ident']),
+			);
+		}
+
+		if($this->data['field_ident'] == 'phpbb_facebook') {
+			return array(
+				'label'	=> $this->language->lang('BBPROFILE_FACEBOOK_BUTTON', $this->language->lang($this->data['lang_name'])),
+				'url'	=> append_sid($this->root_path . 'ucp.' . $this->php_ext, 'i=ucp_profile&mode=profile_info#bbprofile_cpf_' . $this->data['field_ident']),
+			);
+		}
+		
+		if($this->data['field_ident'] == 'phpbb_skype') {
+			return array(
+				'label'	=> $this->language->lang('BBPROFILE_SKYPE_BUTTON', $this->language->lang($this->data['lang_name'])),
+				'url'	=> append_sid($this->root_path . 'ucp.' . $this->php_ext, 'i=ucp_profile&mode=profile_info#bbprofile_cpf_' . $this->data['field_ident']),
+			);
+		}
+
+		if($this->data['field_ident'] == 'phpbb_twitter') {
+			return array(
+				'label'	=> $this->language->lang('BBPROFILE_TWITTER_BUTTON', $this->language->lang($this->data['lang_name'])),
+				'url'	=> append_sid($this->root_path . 'ucp.' . $this->php_ext, 'i=ucp_profile&mode=profile_info#bbprofile_cpf_' . $this->data['field_ident']),
+			);
+		}
+		
+		if($this->data['field_ident'] == 'phpbb_youtube') {
+			return array(
+				'label'	=> $this->language->lang('BBPROFILE_YOUTUBE_BUTTON', $this->language->lang($this->data['lang_name'])),
+				'url'	=> append_sid($this->root_path . 'ucp.' . $this->php_ext, 'i=ucp_profile&mode=profile_info#bbprofile_cpf_' . $this->data['field_ident']),
+			);
+		}
+
 		return array(
 			'label'	=> $this->language->lang('BBPROFILE_CPF_BTN_LABEL', $this->language->lang($this->data['lang_name'])),
 			'url'	=> append_sid($this->root_path . 'ucp.' . $this->php_ext, 'i=ucp_profile&mode=profile_info#bbprofile_cpf_' . $this->data['field_ident']),
diff --git "[ORIGINAL]/sitesplat\\bbprofile/profile_parts/parts/first_post.php" "[FORUM_EXT]/sitesplat\\bbprofile/profile_parts/parts/first_post.php"
--- "[ORIGINAL]/sitesplat\\bbprofile/profile_parts/parts/first_post.php"
+++ "[FORUM_EXT]/sitesplat\\bbprofile/profile_parts/parts/first_post.php"
@@ -23,7 +23,7 @@ class first_post extends base
 	{
 		return array(
 			'label'	=> $this->language->lang('BBPROFILE_FIRST_POST_BUTTON'),
-			'url'	=> append_sid($this->root_path . 'index.' . $this->php_ext),
+			'url'	=> append_sid($this->root_path . 'viewtopic.' . $this->php_ext . '?f=27&t=640'),
 		);
 	}
 }
diff --git "[ORIGINAL]/sitesplat\\bbprofile/styles/FLATBOOTS/template/event/header_breadcrumb_before.html" "[FORUM_EXT]/sitesplat\\bbprofile/styles/FLATBOOTS/template/event/header_content_after.html"
similarity index 100%
rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbprofile/styles/FLATBOOTS/template/event/header_breadcrumb_before.html"
rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbprofile/styles/FLATBOOTS/template/event/header_content_after.html"
```
