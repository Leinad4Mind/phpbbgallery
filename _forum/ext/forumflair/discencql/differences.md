Existem diferencas reais no codigo ou texto. Diferencas de formatacao (espacos, tabs) foram ignoradas abaixo.

```diff
diff --git "[FORUM_EXT]/forumflair\\discencql/diff_full.tmp" "[FORUM_EXT]/forumflair\\discencql/diff_full.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/forumflair\\discencql/diff_full.tmp"
@@ -0,0 +1,231 @@
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumflair\\discencql/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumflair\\discencql/diff_full.tmp"
+new file mode 100644
+index 000000000..e69de29bb
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumflair\\discencql/language/es/common.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumflair\\discencql/language/es/common.php"
+deleted file mode 100644
+index 67436abc6..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumflair\\discencql/language/es/common.php"
++++ /dev/null
+@@ -1,30 +0,0 @@
+-<?php
+-
+-/*
+-* @package phpBB Extension - Discussion Encouragement With Quick Login
+-* @copyright (c) 2022, ForumFlair, https://forumflair.co.uk
+-* @license GNU General Public License, version 2 (GPL-2.0)
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
+-$lang = array_merge($lang, array(
+-	'DISC_ENC_QL_TTL'				=> 'Cree una cuenta o inicie sesión para unirse a la discusión',
+-	'DISC_ENC_QL_NO_SGNUP_TTL'		=> 'Regístrese para unirse a la discusión',
+-	'DISC_ENC_QL_INF'				=> 'Necesita ser miembro para publicar una respuesta.',
+-
+-	'DISC_ENC_QL_SGN_UP_TTL'		=> 'Crear una cuenta',
+-	'DISC_ENC_QL_SGN_UP_INF'		=> '¿No es un miembro? regístrese para unirse a nuestra comunidad',
+-	'DISC_ENC_QL_SGN_UP_TPCS_INF'	=> 'Los miembros pueden iniciar sus propios temas y suscribirse a los temas',
+-	'DISC_ENC_QL_SGN_UP_FREE_INF'	=> 'Es gratis y solo toma un minuto',
+-
+-	'DISC_ENC_QL_SGN_IN_TTL'		=> 'Registrarse',
+-));
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumflair\\discencql/language/pt/common.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumflair\\discencql/language/pt/common.php"
+new file mode 100644
+index 000000000..6d714bddb
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumflair\\discencql/language/pt/common.php"
+@@ -0,0 +1,30 @@
++<?php
++
++/*
++* @package phpBB Extension - Discussion Encouragement With Quick Login
++* @copyright (c) 2022, ForumFlair, https://forumflair.co.uk
++* @license GNU General Public License, version 2 (GPL-2.0)
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
++	'DISC_ENC_QL_TTL'				=> 'Cria uma conta ou inicia sessão para participares na discussão',
++	'DISC_ENC_QL_NO_SGNUP_TTL'		=> 'Entra na tua conta e participa com outros malucos como tu!',
++	'DISC_ENC_QL_INF'				=> 'Precisas de ter conta para responder',
++
++	'DISC_ENC_QL_SGN_UP_TTL'		=> 'Criar uma conta',
++	'DISC_ENC_QL_SGN_UP_INF'		=> 'Não és membro ainda? Regista-te e une-te à melhor comunidade portuguesa de animação',
++	'DISC_ENC_QL_SGN_UP_TPCS_INF'	=> 'Os membros podem criar os seus próprios tópicos e seguir tópicos de outros',
++	'DISC_ENC_QL_SGN_UP_FREE_INF'	=> 'Não tem custos e demora menos de um minuto',
++
++	'DISC_ENC_QL_SGN_IN_TTL'		=> 'Entrar na conta',
++));
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumflair\\discencql/styles/FLATBOOTS/template/discencql.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumflair\\discencql/styles/FLATBOOTS/template/discencql.html"
+new file mode 100644
+index 000000000..f2f3893ba
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumflair\\discencql/styles/FLATBOOTS/template/discencql.html"
+@@ -0,0 +1,60 @@
++<div class="discencql panel">
++	<div class="inner">
++		{% if S_REGISTER_ENABLED and not (S_SHOW_COPPA or S_REGISTRATION) %}
++		<h2>{{ lang('DISC_ENC_QL_TTL') }}</h2>
++		{% else %}
++		<h2>{{ lang('DISC_ENC_QL_NO_SGNUP_TTL') }}</h2>
++		{% endif %}
++		<p>{{ lang('DISC_ENC_QL_INF') }}</p>
++		<div class="discencql-grid">
++			{% if S_REGISTER_ENABLED and not (S_SHOW_COPPA or S_REGISTRATION) %}
++			<div class="discencql-column">
++				<h2>{{ lang('DISC_ENC_QL_SGN_UP_TTL') }}</h2>
++				<p>
++				{{ lang('DISC_ENC_QL_SGN_UP_INF') }}<br />
++				{{ lang('DISC_ENC_QL_SGN_UP_TPCS_INF') }}<br />
++				{{ lang('DISC_ENC_QL_SGN_UP_FREE_INF') }}
++				</p>
++				<a href="{U_REGISTER}" class="discencql-button discencql-register-button button" title="{L_REGISTER}">
++					<i class="fa fa-pencil-square-o" aria-hidden="true"></i>&nbsp;<span>{L_REGISTER}</span>
++				</a>
++			</div>
++			{% endif %}
++			<div class="discencql-column">
++				{% if S_REGISTER_ENABLED and not (S_SHOW_COPPA or S_REGISTRATION) %}
++				<h2>{{ lang('DISC_ENC_QL_SGN_IN_TTL') }}</h2>
++				{% endif %}
++				<form method="post" action="{S_LOGIN_ACTION}" id="login">
++					<fieldset class="discencql-fieldset">
++						<div class="form-group">
++						<label class="sr-only" for="username-ql">{L_USERNAME}{L_COLON}</label>
++						<div class="form-icon">
++						 <input type="text" tabindex="1" name="username" id="username-ql" value="{LOGIN_USERNAME}" class="form-control input-lg inputbox" placeholder="{L_USERNAME}">
++						 
++						</div> 
++						</div> 
++						<div class="form-group">
++						 <label class="sr-only" for="password-ql">{L_PASSWORD}{L_COLON}</label>
++						  <div class="form-icon">
++							<input type="password" tabindex="2" id="password-ql" name="password" class="form-control input-lg inputbox" placeholder="{L_PASSWORD}" autocomplete="off">
++							
++						  </div> 
++						</div>
++						{% if U_SEND_PASSWORD %}
++							<a href="{U_SEND_PASSWORD}">{L_FORGOT_PASS}</a>
++						{% endif %}
++						{% if S_AUTOLOGIN_ENABLED %}
++							<label for="autologin-ql" class="">{L_LOG_ME_IN}<input type="checkbox" tabindex="4" name="autologin" id="autologin-ql" /></label>
++						{% endif %}
++						
++						<button class="discencql-button discencql-login-button button" type="submit" tabindex="5" name="login" value="{L_LOGIN}" title="{L_LOGIN_LOGOUT}">
++							<i class="fa fa-power-off" aria-hidden="true"></i>&nbsp;<span>{L_LOGIN_LOGOUT}</span>
++						</button>
++						{S_LOGIN_REDIRECT}
++						{S_FORM_TOKEN_LOGIN}
++					</fieldset>
++				</form>
++			</div>
++		</div>
++	</div>
++</div>
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumflair\\discencql/styles/FLATBOOTS/template/event/overall_header_head_append.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumflair\\discencql/styles/FLATBOOTS/template/event/overall_header_head_append.html"
+new file mode 100644
+index 000000000..45ca826eb
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumflair\\discencql/styles/FLATBOOTS/template/event/overall_header_head_append.html"
+@@ -0,0 +1,3 @@
++{% if not S_USER_LOGGED_IN and not S_IS_BOT and SCRIPT_NAME eq 'viewtopic' and not S_IS_LOCKED %}
++	{% INCLUDECSS '@forumflair_discencql/discencql.css' %}
++{% endif %}
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumflair\\discencql/styles/FLATBOOTS/template/event/viewtopic_body_footer_before.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumflair\\discencql/styles/FLATBOOTS/template/event/viewtopic_body_footer_before.html"
+new file mode 100644
+index 000000000..12e131dd9
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumflair\\discencql/styles/FLATBOOTS/template/event/viewtopic_body_footer_before.html"
+@@ -0,0 +1,3 @@
++{% if not S_USER_LOGGED_IN and not S_IS_BOT and SCRIPT_NAME eq 'viewtopic' and not S_IS_LOCKED %}
++	{% include '@forumflair_discencql/discencql.html' %}
++{% endif %}
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumflair\\discencql/styles/FLATBOOTS/theme/discencql.css" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumflair\\discencql/styles/FLATBOOTS/theme/discencql.css"
+new file mode 100644
+index 000000000..8c955d3c8
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumflair\\discencql/styles/FLATBOOTS/theme/discencql.css"
+@@ -0,0 +1,66 @@
++/*	phpBB3 Style Sheet
++	--------------------------------------------------------------
++	phpBB Extension Name:	Discussion Encouragement With Quick Login
++	Extension Developer:	ForumFlair (https://forumflair.co.uk)
++	Compatible Style:		Prosilver
++	--------------------------------------------------------------
++*/
++
++/* Main Panel */
++.discencql { margin: 20px auto 16px auto; max-width: 80%; padding: 12px; text-align: center; }
++.discencql h2 { border: 0; font-size: 2em; margin: 0 0 6px 0; padding: 0; }
++.discencql p { margin: 0 0 20px 0; }
++
++/* Grid & Columns */
++.discencql-grid { display: flex; }
++.discencql-column { display: flex; flex-direction: column; width: 100%; }
++
++/* Registration Info */
++.discencql-column p { line-height: 2em; }
++
++/* Quick Login Form */
++.discencql-column form { margin: auto auto 0 auto; width: 100%; }
++.discencql-fieldset { margin: 0 auto; max-width: 250px; }
++/* .discencql-fieldset label { font-size: 1.2em; padding: 0 } */
++.discencql-fieldset .inputbox { border-color: #DFE4E6; border-radius: 4px; margin: 0 0 8px 0; padding: 8px 0; text-indent: 6px; width: 100%; }
++.discencql-autologin { display: block; margin: auto auto 8px auto; width: fit-content; width: -moz-fit-content; }
++.discencql-autologin input[type="checkbox"] { margin: 0 0 0 4px; vertical-align: bottom; }
++
++/* RTL Quick Login Form */
++.rtl .discencql-autologin input[type="checkbox"] { margin: 0 4px 0 0; }
++
++/* Login/Register Buttons */
++.discencql-button { border: 0; border-radius: 4px; box-shadow: none; font-family: Arial; max-width: 200px; padding: 8px 0; width: 100%; }
++.discencql-button:focus, .discencql-button:hover { color: #FFFFFF; text-shadow: none; }
++.discencql-button .icon::before { padding: 0 4px 0 0; }
++.discencql-button .icon { color: #FFFFFF; width: auto; }
++.discencql-button:focus .icon, .discencql-button:hover .icon { color: #FFFFFF; }
++a.discencql-register-button { color: #FFFFFF; margin: auto auto 0 auto; text-decoration: none; }
++.discencql-register-button { background: #105289; }
++.discencql-register-button:focus, .discencql-register-button:hover { background: #1469B0; }
++.discencql-login-button { background: #6C7B84; color: #FFFFFF; }
++.discencql-login-button:focus, .discencql-login-button:hover { background: #7D8E99; }
++
++/* RTL Login/Register Buttons */
++.rtl .discencql-button .icon::before { padding: 0 0 0 4px; }
++
++/* Responsive Media Queries 800px */
++@media (max-width: 800px) {
++	/* Main Panel */
++	.discencql { max-width: 94%; }
++}
++
++/* Responsive Media Queries 700px */
++@media (max-width: 700px) {
++	/* Main Panel */
++	.discencql { max-width: 100%; }
++	.discencql p { margin: 0 0 14px 0; }
++
++	/* Grid & Columns */
++	.discencql-grid { display: block }
++	.discencql-column { display: block; margin: 0 0 14px 0; }
++}
++
++/* Prosilver RTL Bug Fix: fixes icon padding mistake found in prosilver bidi.css */
++.rtl .discencql-button .icon { padding: 0; }
++/* This can be removed when the mistake in the prosilver bidi.css file is fixed */
diff --git "[FORUM_EXT]/forumflair\\discencql/diff_nospace.tmp" "[FORUM_EXT]/forumflair\\discencql/diff_nospace.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/forumflair\\discencql/diff_nospace.tmp"
@@ -0,0 +1,163 @@
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumflair\\discencql/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumflair\\discencql/diff_full.tmp"
+new file mode 100644
+index 000000000..5dd4553e3
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumflair\\discencql/diff_full.tmp"
+@@ -0,0 +1,231 @@
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumflair\\discencql/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumflair\\discencql/diff_full.tmp"
++new file mode 100644
++index 000000000..e69de29bb
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumflair\\discencql/language/es/common.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumflair\\discencql/language/es/common.php"
++deleted file mode 100644
++index 67436abc6..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\forumflair\\discencql/language/es/common.php"
+++++ /dev/null
++@@ -1,30 +0,0 @@
++-<?php
++-
++-/*
++-* @package phpBB Extension - Discussion Encouragement With Quick Login
++-* @copyright (c) 2022, ForumFlair, https://forumflair.co.uk
++-* @license GNU General Public License, version 2 (GPL-2.0)
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
++-$lang = array_merge($lang, array(
++-	'DISC_ENC_QL_TTL'				=> 'Cree una cuenta o inicie sesión para unirse a la discusión',
++-	'DISC_ENC_QL_NO_SGNUP_TTL'		=> 'Regístrese para unirse a la discusión',
++-	'DISC_ENC_QL_INF'				=> 'Necesita ser miembro para publicar una respuesta.',
++-
++-	'DISC_ENC_QL_SGN_UP_TTL'		=> 'Crear una cuenta',
++-	'DISC_ENC_QL_SGN_UP_INF'		=> '¿No es un miembro? regístrese para unirse a nuestra comunidad',
++-	'DISC_ENC_QL_SGN_UP_TPCS_INF'	=> 'Los miembros pueden iniciar sus propios temas y suscribirse a los temas',
++-	'DISC_ENC_QL_SGN_UP_FREE_INF'	=> 'Es gratis y solo toma un minuto',
++-
++-	'DISC_ENC_QL_SGN_IN_TTL'		=> 'Registrarse',
++-));
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumflair\\discencql/language/pt/common.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumflair\\discencql/language/pt/common.php"
++new file mode 100644
++index 000000000..6d714bddb
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumflair\\discencql/language/pt/common.php"
++@@ -0,0 +1,30 @@
+++<?php
+++
+++/*
+++* @package phpBB Extension - Discussion Encouragement With Quick Login
+++* @copyright (c) 2022, ForumFlair, https://forumflair.co.uk
+++* @license GNU General Public License, version 2 (GPL-2.0)
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
+++	'DISC_ENC_QL_TTL'				=> 'Cria uma conta ou inicia sessão para participares na discussão',
+++	'DISC_ENC_QL_NO_SGNUP_TTL'		=> 'Entra na tua conta e participa com outros malucos como tu!',
+++	'DISC_ENC_QL_INF'				=> 'Precisas de ter conta para responder',
+++
+++	'DISC_ENC_QL_SGN_UP_TTL'		=> 'Criar uma conta',
+++	'DISC_ENC_QL_SGN_UP_INF'		=> 'Não és membro ainda? Regista-te e une-te à melhor comunidade portuguesa de animação',
+++	'DISC_ENC_QL_SGN_UP_TPCS_INF'	=> 'Os membros podem criar os seus próprios tópicos e seguir tópicos de outros',
+++	'DISC_ENC_QL_SGN_UP_FREE_INF'	=> 'Não tem custos e demora menos de um minuto',
+++
+++	'DISC_ENC_QL_SGN_IN_TTL'		=> 'Entrar na conta',
+++));
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumflair\\discencql/styles/FLATBOOTS/template/discencql.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumflair\\discencql/styles/FLATBOOTS/template/discencql.html"
++new file mode 100644
++index 000000000..f2f3893ba
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumflair\\discencql/styles/FLATBOOTS/template/discencql.html"
++@@ -0,0 +1,60 @@
+++<div class="discencql panel">
+++	<div class="inner">
+++		{% if S_REGISTER_ENABLED and not (S_SHOW_COPPA or S_REGISTRATION) %}
+++		<h2>{{ lang('DISC_ENC_QL_TTL') }}</h2>
+++		{% else %}
+++		<h2>{{ lang('DISC_ENC_QL_NO_SGNUP_TTL') }}</h2>
+++		{% endif %}
+++		<p>{{ lang('DISC_ENC_QL_INF') }}</p>
+++		<div class="discencql-grid">
+++			{% if S_REGISTER_ENABLED and not (S_SHOW_COPPA or S_REGISTRATION) %}
+++			<div class="discencql-column">
+++				<h2>{{ lang('DISC_ENC_QL_SGN_UP_TTL') }}</h2>
+++				<p>
+++				{{ lang('DISC_ENC_QL_SGN_UP_INF') }}<br />
+++				{{ lang('DISC_ENC_QL_SGN_UP_TPCS_INF') }}<br />
+++				{{ lang('DISC_ENC_QL_SGN_UP_FREE_INF') }}
+++				</p>
+++				<a href="{U_REGISTER}" class="discencql-button discencql-register-button button" title="{L_REGISTER}">
+++					<i class="fa fa-pencil-square-o" aria-hidden="true"></i>&nbsp;<span>{L_REGISTER}</span>
+++				</a>
+++			</div>
+++			{% endif %}
+++			<div class="discencql-column">
+++				{% if S_REGISTER_ENABLED and not (S_SHOW_COPPA or S_REGISTRATION) %}
+++				<h2>{{ lang('DISC_ENC_QL_SGN_IN_TTL') }}</h2>
+++				{% endif %}
+++				<form method="post" action="{S_LOGIN_ACTION}" id="login">
+++					<fieldset class="discencql-fieldset">
+++						<div class="form-group">
+++						<label class="sr-only" for="username-ql">{L_USERNAME}{L_COLON}</label>
+++						<div class="form-icon">
+++						 <input type="text" tabindex="1" name="username" id="username-ql" value="{LOGIN_USERNAME}" class="form-control input-lg inputbox" placeholder="{L_USERNAME}">
+++						 
+++						</div> 
+++						</div> 
+++						<div class="form-group">
+++						 <label class="sr-only" for="password-ql">{L_PASSWORD}{L_COLON}</label>
+++						  <div class="form-icon">
+++							<input type="password" tabindex="2" id="password-ql" name="password" class="form-control input-lg inputbox" placeholder="{L_PASSWORD}" autocomplete="off">
+++							
+++						  </div> 
+++						</div>
+++						{% if U_SEND_PASSWORD %}
+++							<a href="{U_SEND_PASSWORD}">{L_FORGOT_PASS}</a>
+++						{% endif %}
+++						{% if S_AUTOLOGIN_ENABLED %}
+++							<label for="autologin-ql" class="">{L_LOG_ME_IN}<input type="checkbox" tabindex="4" name="autologin" id="autologin-ql" /></label>
+++						{% endif %}
+++						
+++						<button class="discencql-button discencql-login-button button" type="submit" tabindex="5" name="login" value="{L_LOGIN}" title="{L_LOGIN_LOGOUT}">
+++							<i class="fa fa-power-off" aria-hidden="true"></i>&nbsp;<span>{L_LOGIN_LOGOUT}</span>
+++						</button>
+++						{S_LOGIN_REDIRECT}
+++						{S_FORM_TOKEN_LOGIN}
+++					</fieldset>
+++				</form>
+++			</div>
+++		</div>
+++	</div>
+++</div>
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumflair\\discencql/styles/FLATBOOTS/template/event/overall_header_head_append.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumflair\\discencql/styles/FLATBOOTS/template/event/overall_header_head_append.html"
++new file mode 100644
++index 000000000..45ca826eb
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumflair\\discencql/styles/FLATBOOTS/template/event/overall_header_head_append.html"
++@@ -0,0 +1,3 @@
+++{% if not S_USER_LOGGED_IN and not S_IS_BOT and SCRIPT_NAME eq 'viewtopic' and not S_IS_LOCKED %}
+++	{% INCLUDECSS '@forumflair_discencql/discencql.css' %}
+++{% endif %}
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumflair\\discencql/styles/FLATBOOTS/template/event/viewtopic_body_footer_before.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumflair\\discencql/styles/FLATBOOTS/template/event/viewtopic_body_footer_before.html"
++new file mode 100644
++index 000000000..12e131dd9
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\forumflair\\discencql/styles/FLATBOOTS/template/event/viewtopic_body_footer_before.html"
++@@ -0,0 +1,3 @@
+++{% if not S_USE
\ No newline at end of file
diff --git "[ORIGINAL]/forumflair\\discencql/language/es/common.php" "[ORIGINAL]/forumflair\\discencql/language/es/common.php"
deleted file mode 100644
--- "[ORIGINAL]/forumflair\\discencql/language/es/common.php"
+++ /dev/null
@@ -1,30 +0,0 @@
-<?php
-
-/*
-* @package phpBB Extension - Discussion Encouragement With Quick Login
-* @copyright (c) 2022, ForumFlair, https://forumflair.co.uk
-* @license GNU General Public License, version 2 (GPL-2.0)
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
-$lang = array_merge($lang, array(
-	'DISC_ENC_QL_TTL'				=> 'Cree una cuenta o inicie sesión para unirse a la discusión',
-	'DISC_ENC_QL_NO_SGNUP_TTL'		=> 'Regístrese para unirse a la discusión',
-	'DISC_ENC_QL_INF'				=> 'Necesita ser miembro para publicar una respuesta.',
-
-	'DISC_ENC_QL_SGN_UP_TTL'		=> 'Crear una cuenta',
-	'DISC_ENC_QL_SGN_UP_INF'		=> '¿No es un miembro? regístrese para unirse a nuestra comunidad',
-	'DISC_ENC_QL_SGN_UP_TPCS_INF'	=> 'Los miembros pueden iniciar sus propios temas y suscribirse a los temas',
-	'DISC_ENC_QL_SGN_UP_FREE_INF'	=> 'Es gratis y solo toma un minuto',
-
-	'DISC_ENC_QL_SGN_IN_TTL'		=> 'Registrarse',
-));
diff --git "[FORUM_EXT]/forumflair\\discencql/language/pt/common.php" "[FORUM_EXT]/forumflair\\discencql/language/pt/common.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/forumflair\\discencql/language/pt/common.php"
@@ -0,0 +1,30 @@
+<?php
+
+/*
+* @package phpBB Extension - Discussion Encouragement With Quick Login
+* @copyright (c) 2022, ForumFlair, https://forumflair.co.uk
+* @license GNU General Public License, version 2 (GPL-2.0)
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
+	'DISC_ENC_QL_TTL'				=> 'Cria uma conta ou inicia sessão para participares na discussão',
+	'DISC_ENC_QL_NO_SGNUP_TTL'		=> 'Entra na tua conta e participa com outros malucos como tu!',
+	'DISC_ENC_QL_INF'				=> 'Precisas de ter conta para responder',
+
+	'DISC_ENC_QL_SGN_UP_TTL'		=> 'Criar uma conta',
+	'DISC_ENC_QL_SGN_UP_INF'		=> 'Não és membro ainda? Regista-te e une-te à melhor comunidade portuguesa de animação',
+	'DISC_ENC_QL_SGN_UP_TPCS_INF'	=> 'Os membros podem criar os seus próprios tópicos e seguir tópicos de outros',
+	'DISC_ENC_QL_SGN_UP_FREE_INF'	=> 'Não tem custos e demora menos de um minuto',
+
+	'DISC_ENC_QL_SGN_IN_TTL'		=> 'Entrar na conta',
+));
diff --git "[FORUM_EXT]/forumflair\\discencql/styles/FLATBOOTS/template/discencql.html" "[FORUM_EXT]/forumflair\\discencql/styles/FLATBOOTS/template/discencql.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/forumflair\\discencql/styles/FLATBOOTS/template/discencql.html"
@@ -0,0 +1,60 @@
+<div class="discencql panel">
+	<div class="inner">
+		{% if S_REGISTER_ENABLED and not (S_SHOW_COPPA or S_REGISTRATION) %}
+		<h2>{{ lang('DISC_ENC_QL_TTL') }}</h2>
+		{% else %}
+		<h2>{{ lang('DISC_ENC_QL_NO_SGNUP_TTL') }}</h2>
+		{% endif %}
+		<p>{{ lang('DISC_ENC_QL_INF') }}</p>
+		<div class="discencql-grid">
+			{% if S_REGISTER_ENABLED and not (S_SHOW_COPPA or S_REGISTRATION) %}
+			<div class="discencql-column">
+				<h2>{{ lang('DISC_ENC_QL_SGN_UP_TTL') }}</h2>
+				<p>
+				{{ lang('DISC_ENC_QL_SGN_UP_INF') }}<br />
+				{{ lang('DISC_ENC_QL_SGN_UP_TPCS_INF') }}<br />
+				{{ lang('DISC_ENC_QL_SGN_UP_FREE_INF') }}
+				</p>
+				<a href="{U_REGISTER}" class="discencql-button discencql-register-button button" title="{L_REGISTER}">
+					<i class="fa fa-pencil-square-o" aria-hidden="true"></i>&nbsp;<span>{L_REGISTER}</span>
+				</a>
+			</div>
+			{% endif %}
+			<div class="discencql-column">
+				{% if S_REGISTER_ENABLED and not (S_SHOW_COPPA or S_REGISTRATION) %}
+				<h2>{{ lang('DISC_ENC_QL_SGN_IN_TTL') }}</h2>
+				{% endif %}
+				<form method="post" action="{S_LOGIN_ACTION}" id="login">
+					<fieldset class="discencql-fieldset">
+						<div class="form-group">
+						<label class="sr-only" for="username-ql">{L_USERNAME}{L_COLON}</label>
+						<div class="form-icon">
+						 <input type="text" tabindex="1" name="username" id="username-ql" value="{LOGIN_USERNAME}" class="form-control input-lg inputbox" placeholder="{L_USERNAME}">
+						 
+						</div> 
+						</div> 
+						<div class="form-group">
+						 <label class="sr-only" for="password-ql">{L_PASSWORD}{L_COLON}</label>
+						  <div class="form-icon">
+							<input type="password" tabindex="2" id="password-ql" name="password" class="form-control input-lg inputbox" placeholder="{L_PASSWORD}" autocomplete="off">
+							
+						  </div> 
+						</div>
+						{% if U_SEND_PASSWORD %}
+							<a href="{U_SEND_PASSWORD}">{L_FORGOT_PASS}</a>
+						{% endif %}
+						{% if S_AUTOLOGIN_ENABLED %}
+							<label for="autologin-ql" class="">{L_LOG_ME_IN}<input type="checkbox" tabindex="4" name="autologin" id="autologin-ql" /></label>
+						{% endif %}
+						
+						<button class="discencql-button discencql-login-button button" type="submit" tabindex="5" name="login" value="{L_LOGIN}" title="{L_LOGIN_LOGOUT}">
+							<i class="fa fa-power-off" aria-hidden="true"></i>&nbsp;<span>{L_LOGIN_LOGOUT}</span>
+						</button>
+						{S_LOGIN_REDIRECT}
+						{S_FORM_TOKEN_LOGIN}
+					</fieldset>
+				</form>
+			</div>
+		</div>
+	</div>
+</div>
diff --git "[FORUM_EXT]/forumflair\\discencql/styles/FLATBOOTS/template/event/overall_header_head_append.html" "[FORUM_EXT]/forumflair\\discencql/styles/FLATBOOTS/template/event/overall_header_head_append.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/forumflair\\discencql/styles/FLATBOOTS/template/event/overall_header_head_append.html"
@@ -0,0 +1,3 @@
+{% if not S_USER_LOGGED_IN and not S_IS_BOT and SCRIPT_NAME eq 'viewtopic' and not S_IS_LOCKED %}
+	{% INCLUDECSS '@forumflair_discencql/discencql.css' %}
+{% endif %}
diff --git "[FORUM_EXT]/forumflair\\discencql/styles/FLATBOOTS/template/event/viewtopic_body_footer_before.html" "[FORUM_EXT]/forumflair\\discencql/styles/FLATBOOTS/template/event/viewtopic_body_footer_before.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/forumflair\\discencql/styles/FLATBOOTS/template/event/viewtopic_body_footer_before.html"
@@ -0,0 +1,3 @@
+{% if not S_USER_LOGGED_IN and not S_IS_BOT and SCRIPT_NAME eq 'viewtopic' and not S_IS_LOCKED %}
+	{% include '@forumflair_discencql/discencql.html' %}
+{% endif %}
diff --git "[FORUM_EXT]/forumflair\\discencql/styles/FLATBOOTS/theme/discencql.css" "[FORUM_EXT]/forumflair\\discencql/styles/FLATBOOTS/theme/discencql.css"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/forumflair\\discencql/styles/FLATBOOTS/theme/discencql.css"
@@ -0,0 +1,66 @@
+/*	phpBB3 Style Sheet
+	--------------------------------------------------------------
+	phpBB Extension Name:	Discussion Encouragement With Quick Login
+	Extension Developer:	ForumFlair (https://forumflair.co.uk)
+	Compatible Style:		Prosilver
+	--------------------------------------------------------------
+*/
+
+/* Main Panel */
+.discencql { margin: 20px auto 16px auto; max-width: 80%; padding: 12px; text-align: center; }
+.discencql h2 { border: 0; font-size: 2em; margin: 0 0 6px 0; padding: 0; }
+.discencql p { margin: 0 0 20px 0; }
+
+/* Grid & Columns */
+.discencql-grid { display: flex; }
+.discencql-column { display: flex; flex-direction: column; width: 100%; }
+
+/* Registration Info */
+.discencql-column p { line-height: 2em; }
+
+/* Quick Login Form */
+.discencql-column form { margin: auto auto 0 auto; width: 100%; }
+.discencql-fieldset { margin: 0 auto; max-width: 250px; }
+/* .discencql-fieldset label { font-size: 1.2em; padding: 0 } */
+.discencql-fieldset .inputbox { border-color: #DFE4E6; border-radius: 4px; margin: 0 0 8px 0; padding: 8px 0; text-indent: 6px; width: 100%; }
+.discencql-autologin { display: block; margin: auto auto 8px auto; width: fit-content; width: -moz-fit-content; }
+.discencql-autologin input[type="checkbox"] { margin: 0 0 0 4px; vertical-align: bottom; }
+
+/* RTL Quick Login Form */
+.rtl .discencql-autologin input[type="checkbox"] { margin: 0 4px 0 0; }
+
+/* Login/Register Buttons */
+.discencql-button { border: 0; border-radius: 4px; box-shadow: none; font-family: Arial; max-width: 200px; padding: 8px 0; width: 100%; }
+.discencql-button:focus, .discencql-button:hover { color: #FFFFFF; text-shadow: none; }
+.discencql-button .icon::before { padding: 0 4px 0 0; }
+.discencql-button .icon { color: #FFFFFF; width: auto; }
+.discencql-button:focus .icon, .discencql-button:hover .icon { color: #FFFFFF; }
+a.discencql-register-button { color: #FFFFFF; margin: auto auto 0 auto; text-decoration: none; }
+.discencql-register-button { background: #105289; }
+.discencql-register-button:focus, .discencql-register-button:hover { background: #1469B0; }
+.discencql-login-button { background: #6C7B84; color: #FFFFFF; }
+.discencql-login-button:focus, .discencql-login-button:hover { background: #7D8E99; }
+
+/* RTL Login/Register Buttons */
+.rtl .discencql-button .icon::before { padding: 0 0 0 4px; }
+
+/* Responsive Media Queries 800px */
+@media (max-width: 800px) {
+	/* Main Panel */
+	.discencql { max-width: 94%; }
+}
+
+/* Responsive Media Queries 700px */
+@media (max-width: 700px) {
+	/* Main Panel */
+	.discencql { max-width: 100%; }
+	.discencql p { margin: 0 0 14px 0; }
+
+	/* Grid & Columns */
+	.discencql-grid { display: block }
+	.discencql-column { display: block; margin: 0 0 14px 0; }
+}
+
+/* Prosilver RTL Bug Fix: fixes icon padding mistake found in prosilver bidi.css */
+.rtl .discencql-button .icon { padding: 0; }
+/* This can be removed when the mistake in the prosilver bidi.css file is fixed */
```
