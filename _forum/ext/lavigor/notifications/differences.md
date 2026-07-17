Existem diferencas reais no codigo ou texto. Diferencas de formatacao (espacos, tabs) foram ignoradas abaixo.

```diff
diff --git "[FORUM_EXT]/lavigor\\notifications/diff_full.tmp" "[FORUM_EXT]/lavigor\\notifications/diff_full.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/lavigor\\notifications/diff_full.tmp"
@@ -0,0 +1,818 @@
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/diff_full.tmp"
+new file mode 100644
+index 000000000..e69de29bb
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lavigor\\notifications/language/en/notifications.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/language/en/notifications.php"
+index e110c1e1e..a3f529721 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lavigor\\notifications/language/en/notifications.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/language/en/notifications.php"
+@@ -22,7 +22,7 @@ if (empty($lang) || !is_array($lang))
+ 
+ $lang = array_merge($lang, array(
+ 	'LAVIGOR_NOTIFICATIONS_NOTIFICATION_METHOD_BROWSER' => 'Browser',
+-	'BROWSER_NOTIFICATIONS'                             => 'Browser notifications',
++	'BROWSER_NOTIFICATIONS'                             => 'Browser Notifications',
+ 	'BROWSER_NOTIFICATIONS_ACTION_ENABLED'              => 'On',
+ 	'BROWSER_NOTIFICATIONS_ACTION_DISABLED'             => 'Off',
+ 	'BROWSER_NOTIFICATIONS_ACTION_DISALLOWED'           => 'Disallowed',
+@@ -30,7 +30,7 @@ $lang = array_merge($lang, array(
+ 	'BROWSER_NOTIFICATIONS_ENABLE'                      => 'Enable browser notifications.',
+ 	'BROWSER_NOTIFICATIONS_DISABLE'                     => 'Disable browser notifications.',
+ 	'BROWSER_NOTIFICATIONS_DISALLOWED'                  => 'Web Notifications are disallowed in this browser. Allow notifications for this website in browser settings if you want to subscribe.',
+-	'BROWSER_NOTIFICATIONS_INTRO'                       => 'Do you want to allow this portal to notify you about replies?',
++	'BROWSER_NOTIFICATIONS_INTRO'                       => 'Do you want to allow GoldTugAnime to notify you?',
+ 	'BROWSER_NOTIFICATIONS_MAX_LIMIT_REACHED'           => 'The maximum allowed number of browsers with enabled browser notifications (%s per user) has been reached. Please turn off browser notifications for this board in any other browser where you enabled them if you want to enable browser notifications in this browser.',
+ 	'BROWSER_NOTIFICATIONS_UNSUPPORTED'                 => 'Web Notifications are not supported by this browser.',
+ 	'BROWSER_NOTIFICATIONS_UPDATE_FAILED'               => 'There was an error (possibly connection error while contacting the server) during the subscription to Web Notifications. They have been disabled in this browser. Please check your Internet connection and try again. Contact the board administrator if the problem persists.',
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/language/pt/info_acp_notifications.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/language/pt/info_acp_notifications.php"
+new file mode 100644
+index 000000000..955b08e9f
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/language/pt/info_acp_notifications.php"
+@@ -0,0 +1,26 @@
++<?php
++/**
++ *
++ * @package Push Notifications
++ * @copyright (c) 2017 - 2018 LavIgor
++ * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
++ *
++ */
++
++/**
++ * DO NOT CHANGE
++ */
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
++	'LOG_WEB_PUSH_GENERAL_ERROR'	=> '<strong>Web Push error</strong><br />» %s',
++	'LOG_WEB_PUSH_SERVER_ERROR'		=> '<strong>Web Push error</strong> with code <strong>%1$s</strong><br />» %2$s',
++));
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/language/pt/info_ucp_notifications.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/language/pt/info_ucp_notifications.php"
+new file mode 100644
+index 000000000..fd979f521
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/language/pt/info_ucp_notifications.php"
+@@ -0,0 +1,25 @@
++<?php
++/**
++ *
++ * @package Push Notifications
++ * @copyright (c) 2017 - 2018 LavIgor
++ * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
++ *
++ */
++
++/**
++ * DO NOT CHANGE
++ */
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
++	'LAVIGOR_NOTIFICATIONS_NOTIFICATION_METHOD_BROWSER' => 'Navegador',
++));
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/language/pt/notifications.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/language/pt/notifications.php"
+new file mode 100644
+index 000000000..e6089cd3f
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/language/pt/notifications.php"
+@@ -0,0 +1,37 @@
++<?php
++/**
++ *
++ * @package       Push Notifications
++ * @copyright (c) 2017 - 2018 LavIgor
++ * @license       http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
++ *
++ */
++
++/**
++ * DO NOT CHANGE
++ */
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
++	'LAVIGOR_NOTIFICATIONS_NOTIFICATION_METHOD_BROWSER' => 'Navegador',
++	'BROWSER_NOTIFICATIONS'                             => 'Notificações de Navegador',
++	'BROWSER_NOTIFICATIONS_ACTION_ENABLED'              => 'Ligado',
++	'BROWSER_NOTIFICATIONS_ACTION_DISABLED'             => 'Desligado',
++	'BROWSER_NOTIFICATIONS_ACTION_DISALLOWED'           => 'Não é permitido',
++	'BROWSER_NOTIFICATIONS_ACTION_UNSUPPORTED'          => 'Não é suportado',
++	'BROWSER_NOTIFICATIONS_ENABLE'                      => 'Ativar notificações de navegador.',
++	'BROWSER_NOTIFICATIONS_DISABLE'                     => 'Desativar notificações de navegador.',
++	'BROWSER_NOTIFICATIONS_DISALLOWED'                  => 'Notificações Web não são permitidas neste navegador. Permita as notificações de navegador para esta página nas configurações do navegador, caso desejes te subscrever.',
++	'BROWSER_NOTIFICATIONS_INTRO'                       => 'Desejas permitir que o GoldTugAnime te envie notificações?',
++	'BROWSER_NOTIFICATIONS_MAX_LIMIT_REACHED'           => 'O número máximo de navegadores permitidos para as notificações de navegador (%s por utilizador) foi atingido. Por favor, desliga as notificações de navegador deste fórum que tenhas ativado em qualquer outro navegador para que possas ativá-lo neste.',
++	'BROWSER_NOTIFICATIONS_UNSUPPORTED'                 => 'Notificações Web não são suportadas pelo teu navegador atual.',
++	'BROWSER_NOTIFICATIONS_UPDATE_FAILED'               => 'Ocorreu um erro (possivelmente erro de conexão ao contactar o servidor) durante a assinatura da Notificação Web. Foi desativada neste navegador. Por favor, verifica a tua conexão de internet e tenta novamente. Entra em contacto com o administrador do fórum se o problema persistir.',
++));
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/language/pt/notifications_acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/language/pt/notifications_acp.php"
+new file mode 100644
+index 000000000..affba0407
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/language/pt/notifications_acp.php"
+@@ -0,0 +1,33 @@
++<?php
++/**
++ *
++ * @package       Push Notifications
++ * @copyright (c) 2017 - 2018 LavIgor
++ * @license       http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
++ *
++ */
++
++/**
++ * DO NOT CHANGE
++ */
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
++	'BROWSER_NOTIFICATION_BADGE_URL'            => 'Absolute URL to the badge image for Push Notifications',
++	'BROWSER_NOTIFICATION_DROPDOWN'             => 'Integrate the toggle for browser Push Notifications into the standard dropdown for notifications',
++	'BROWSER_NOTIFICATION_DROPDOWN_EXPLAIN'     => 'The toggle for browser Push Notifications on the notification options management page will be shown regardless of this setting.',
++	'BROWSER_NOTIFICATION_INTRO'                => 'Ask user whether he/she wants to enable Push Notifications when he/she logs in with a new browser',
++	'BROWSER_NOTIFICATION_INTRO_EXPLAIN'        => 'Modal dialog will be shown only once in each browser regardless of login amount with a certain browser.',
++	'BROWSER_NOTIFICATION_MAX_BROWSERS'         => 'Maximum allowed number of browsers with enabled Push Notifications per each user',
++	'BROWSER_NOTIFICATION_MAX_BROWSERS_EXPLAIN' => 'The user will not be able to turn on Push Notification for the board in any browser if the allowed amount of browsers with enabled Push Notifications has been reached. Enter 0 to disable this setting <em>(not recommended)</em>.',
++	'BROWSER_NOTIFICATION_TTL'                  => 'Time To Live for Web Notifications',
++	'BROWSER_NOTIFICATION_TTL_EXPLAIN'          => 'Time To Live (TTL) is how long a push message is retained by the push service (e.g. Mozilla) in case the user browser is not yet accessible (e.g. is not connected). You may want to use a very long time for important notifications. The default TTL is 4 weeks. However, if you send multiple nonessential notifications, set a TTL of 0: the push notification will be delivered only if the user is currently connected. For other cases, you should use a minimum of one day if your users have multiple time zones, and if they don’t, several hours will suffice.',
++));
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/language/pt_preao/info_acp_notifications.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/language/pt_preao/info_acp_notifications.php"
+new file mode 100644
+index 000000000..955b08e9f
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/language/pt_preao/info_acp_notifications.php"
+@@ -0,0 +1,26 @@
++<?php
++/**
++ *
++ * @package Push Notifications
++ * @copyright (c) 2017 - 2018 LavIgor
++ * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
++ *
++ */
++
++/**
++ * DO NOT CHANGE
++ */
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
++	'LOG_WEB_PUSH_GENERAL_ERROR'	=> '<strong>Web Push error</strong><br />» %s',
++	'LOG_WEB_PUSH_SERVER_ERROR'		=> '<strong>Web Push error</strong> with code <strong>%1$s</strong><br />» %2$s',
++));
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/language/pt_preao/info_ucp_notifications.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/language/pt_preao/info_ucp_notifications.php"
+new file mode 100644
+index 000000000..fd979f521
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/language/pt_preao/info_ucp_notifications.php"
+@@ -0,0 +1,25 @@
++<?php
++/**
++ *
++ * @package Push Notifications
++ * @copyright (c) 2017 - 2018 LavIgor
++ * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
++ *
++ */
++
++/**
++ * DO NOT CHANGE
++ */
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
++	'LAVIGOR_NOTIFICATIONS_NOTIFICATION_METHOD_BROWSER' => 'Navegador',
++));
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/language/pt_preao/notifications.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/language/pt_preao/notifications.php"
+new file mode 100644
+index 000000000..e6089cd3f
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/language/pt_preao/notifications.php"
+@@ -0,0 +1,37 @@
++<?php
++/**
++ *
++ * @package       Push Notifications
++ * @copyright (c) 2017 - 2018 LavIgor
++ * @license       http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
++ *
++ */
++
++/**
++ * DO NOT CHANGE
++ */
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
++	'LAVIGOR_NOTIFICATIONS_NOTIFICATION_METHOD_BROWSER' => 'Navegador',
++	'BROWSER_NOTIFICATIONS'                             => 'Notificações de Navegador',
++	'BROWSER_NOTIFICATIONS_ACTION_ENABLED'              => 'Ligado',
++	'BROWSER_NOTIFICATIONS_ACTION_DISABLED'             => 'Desligado',
++	'BROWSER_NOTIFICATIONS_ACTION_DISALLOWED'           => 'Não é permitido',
++	'BROWSER_NOTIFICATIONS_ACTION_UNSUPPORTED'          => 'Não é suportado',
++	'BROWSER_NOTIFICATIONS_ENABLE'                      => 'Ativar notificações de navegador.',
++	'BROWSER_NOTIFICATIONS_DISABLE'                     => 'Desativar notificações de navegador.',
++	'BROWSER_NOTIFICATIONS_DISALLOWED'                  => 'Notificações Web não são permitidas neste navegador. Permita as notificações de navegador para esta página nas configurações do navegador, caso desejes te subscrever.',
++	'BROWSER_NOTIFICATIONS_INTRO'                       => 'Desejas permitir que o GoldTugAnime te envie notificações?',
++	'BROWSER_NOTIFICATIONS_MAX_LIMIT_REACHED'           => 'O número máximo de navegadores permitidos para as notificações de navegador (%s por utilizador) foi atingido. Por favor, desliga as notificações de navegador deste fórum que tenhas ativado em qualquer outro navegador para que possas ativá-lo neste.',
++	'BROWSER_NOTIFICATIONS_UNSUPPORTED'                 => 'Notificações Web não são suportadas pelo teu navegador atual.',
++	'BROWSER_NOTIFICATIONS_UPDATE_FAILED'               => 'Ocorreu um erro (possivelmente erro de conexão ao contactar o servidor) durante a assinatura da Notificação Web. Foi desativada neste navegador. Por favor, verifica a tua conexão de internet e tenta novamente. Entra em contacto com o administrador do fórum se o problema persistir.',
++));
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/language/pt_preao/notifications_acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/language/pt_preao/notifications_acp.php"
+new file mode 100644
+index 000000000..affba0407
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/language/pt_preao/notifications_acp.php"
+@@ -0,0 +1,33 @@
++<?php
++/**
++ *
++ * @package       Push Notifications
++ * @copyright (c) 2017 - 2018 LavIgor
++ * @license       http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
++ *
++ */
++
++/**
++ * DO NOT CHANGE
++ */
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
++	'BROWSER_NOTIFICATION_BADGE_URL'            => 'Absolute URL to the badge image for Push Notifications',
++	'BROWSER_NOTIFICATION_DROPDOWN'             => 'Integrate the toggle for browser Push Notifications into the standard dropdown for notifications',
++	'BROWSER_NOTIFICATION_DROPDOWN_EXPLAIN'     => 'The toggle for browser Push Notifications on the notification options management page will be shown regardless of this setting.',
++	'BROWSER_NOTIFICATION_INTRO'                => 'Ask user whether he/she wants to enable Push Notifications when he/she logs in with a new browser',
++	'BROWSER_NOTIFICATION_INTRO_EXPLAIN'        => 'Modal dialog will be shown only once in each browser regardless of login amount with a certain browser.',
++	'BROWSER_NOTIFICATION_MAX_BROWSERS'         => 'Maximum allowed number of browsers with enabled Push Notifications per each user',
++	'BROWSER_NOTIFICATION_MAX_BROWSERS_EXPLAIN' => 'The user will not be able to turn on Push Notification for the board in any browser if the allowed amount of browsers with enabled Push Notifications has been reached. Enter 0 to disable this setting <em>(not recommended)</em>.',
++	'BROWSER_NOTIFICATION_TTL'                  => 'Time To Live for Web Notifications',
++	'BROWSER_NOTIFICATION_TTL_EXPLAIN'          => 'Time To Live (TTL) is how long a push message is retained by the push service (e.g. Mozilla) in case the user browser is not yet accessible (e.g. is not connected). You may want to use a very long time for important notifications. The default TTL is 4 weeks. However, if you send multiple nonessential notifications, set a TTL of 0: the push notification will be delivered only if the user is currently connected. For other cases, you should use a minimum of one day if your users have multiple time zones, and if they don’t, several hours will suffice.',
++));
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/styles/FLATBOOTS/template/event/overall_header_head_append.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/styles/FLATBOOTS/template/event/overall_header_head_append.html"
+new file mode 100644
+index 000000000..b8d586a06
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/styles/FLATBOOTS/template/event/overall_header_head_append.html"
+@@ -0,0 +1,45 @@
++<!-- IF S_REGISTERED_USER and not S_IS_BOT and (S_PUSH_DROPDOWN_INTEGRATION or S_IN_UCP and MODE == 'notification_options') -->
++<script>
++//<![CDATA[
++	var pushNotifications = {
++		dropdownIntegration: '{S_PUSH_DROPDOWN_INTEGRATION}',
++		introConfirmation: '{S_PUSH_INTRO_CONFIRMATION}',
++		language: {
++			ACTIONS: {
++				ENABLED: '{LA_BROWSER_NOTIFICATIONS_ACTION_ENABLED}',
++				DISABLED: '{LA_BROWSER_NOTIFICATIONS_ACTION_DISABLED}',
++				DISALLOWED: '{LA_BROWSER_NOTIFICATIONS_ACTION_DISALLOWED}',
++				UNSUPPORTED: '{LA_BROWSER_NOTIFICATIONS_ACTION_UNSUPPORTED}'
++			},
++			BROWSER_NOTIFICATIONS: '{LA_BROWSER_NOTIFICATIONS}{LA_COLON}',
++			ENABLE: '{LA_BROWSER_NOTIFICATIONS_ENABLE}',
++			DISABLE: '{LA_BROWSER_NOTIFICATIONS_DISABLE}',
++			DISALLOWED: '{LA_BROWSER_NOTIFICATIONS_DISALLOWED}',
++			INFORMATION: '{LA_INFORMATION}',
++			INTRO: '{LA_BROWSER_NOTIFICATIONS_INTRO}',
++			INTRO_NO: '{LA_NO}',
++			INTRO_YES: '{LA_YES}',
++			UNSUPPORTED: '{LA_BROWSER_NOTIFICATIONS_UNSUPPORTED}',
++			UPDATE_FAILED: '{LA_BROWSER_NOTIFICATIONS_UPDATE_FAILED}'
++		},
++		notificationsPath: '{ROOT_PATH}notifications/browser/',
++		notificationsPage: <!-- IF S_IN_UCP and MODE == 'notification_options' -->true<!-- ELSE -->false<!-- ENDIF -->,
++		serviceWorkerPath: '{ROOT_PATH}ext/lavigor/notifications/styles/all/template/js/sw.js',
++		serverAPIkey: '{PUSH_API_PUBLIC_KEY}'
++	};
++//]]>
++</script>
++<!-- INCLUDECSS @lavigor_notifications/notifications.css -->
++<!-- INCLUDEJS @lavigor_notifications/js/notifications.js -->
++<!-- IF S_IN_UCP and MODE == 'notification_options' -->
++<style>
++	.nojs form#ucp table thead:before {
++		content: '{L_BROWSER_NOTIFICATIONS_UNSUPPORTED}';
++		display: block;
++		padding: 10px 0;
++		font-size: 1.2em;
++		font-weight: bold;
++	}
++</style>
++<!-- ENDIF -->
++<!-- ENDIF -->
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/styles/FLATBOOTS/template/js/images/badge.png" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/styles/FLATBOOTS/template/js/images/badge.png"
+new file mode 100644
+index 000000000..774ae9e7c
+Binary files /dev/null and "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/styles/FLATBOOTS/template/js/images/badge.png" differ
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/styles/FLATBOOTS/template/js/images/icon.png" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/styles/FLATBOOTS/template/js/images/icon.png"
+new file mode 100644
+index 000000000..7242e9562
+Binary files /dev/null and "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/styles/FLATBOOTS/template/js/images/icon.png" differ
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/styles/FLATBOOTS/template/js/images/no_avatar.gif" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/styles/FLATBOOTS/template/js/images/no_avatar.gif"
+new file mode 100644
+index 000000000..ad73330e7
+Binary files /dev/null and "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/styles/FLATBOOTS/template/js/images/no_avatar.gif" differ
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/styles/FLATBOOTS/template/js/notifications.bak.js" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/styles/FLATBOOTS/template/js/notifications.bak.js"
+new file mode 100644
+index 000000000..462727296
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/styles/FLATBOOTS/template/js/notifications.bak.js"
+@@ -0,0 +1,179 @@
++/* jshint es3:false, esversion:6 */
++/* global pushNotifications, phpbb */
++head.ready(function () {
++;(function($, window, document) {
++	// do stuff here and use $, window and document safely
++	// https://www.phpbb.com/community/viewtopic.php?p=13589106#p13589106
++
++	'use strict';
++
++	var notificationButtonHTML = "<div class='push-notify'><span class='btn btn-default btn-sm'>" + pushNotifications.language.BROWSER_NOTIFICATIONS + "</span><span class='push-toggle'><span></span></span><span class='push-notify-status'></span></div>";
++	if (pushNotifications.notificationsPage) {
++		$('form#ucp table').before(notificationButtonHTML);
++	}
++	if (pushNotifications.dropdownIntegration) {
++		$('.dropdown-menu #notification_list .navbar-footer-content .row')
++			.after("<div class='text-left'>" + notificationButtonHTML + "</div>");
++	}
++
++	var $pushButton = $('.push-notify'), $pushStatus = $('.push-notify-status');
++	var isSubscribed = false;
++	var swRegistration = null;
++
++	function urlB64ToUint8Array(base64String) {
++		var padding = '='.repeat((4 - base64String.length % 4) % 4);
++		var base64 = (base64String + padding)
++			.replace(/\-/g, '+')
++			.replace(/_/g, '/');
++
++		var rawData = window.atob(base64);
++		var outputArray = new Uint8Array(rawData.length);
++
++		for (var i = 0; i < rawData.length; ++i) {
++			outputArray[i] = rawData.charCodeAt(i);
++		}
++		return outputArray;
++	}
++
++	function setButtonState(state) {
++		switch (state) {
++			case 'enabled':
++				$pushStatus.text(pushNotifications.language.ACTIONS.ENABLED);
++				$pushButton.removeClass('push-toggle-locked').addClass('push-toggle-enabled')
++					.attr('title', pushNotifications.language.DISABLE);
++				break;
++			case 'disabled':
++				$pushStatus.text(pushNotifications.language.ACTIONS.DISABLED);
++				$pushButton.removeClass('push-toggle-locked push-toggle-enabled')
++					.attr('title', pushNotifications.language.ENABLE);
++				break;
++			case 'disallowed':
++				$pushStatus.text(pushNotifications.language.ACTIONS.DISALLOWED);
++				$pushButton.addClass('push-toggle-locked').removeClass('push-toggle-enabled')
++					.attr('title', pushNotifications.language.DISALLOWED);
++				break;
++			case 'unsupported':
++				$pushStatus.text(pushNotifications.language.ACTIONS.UNSUPPORTED);
++				$pushButton.addClass('push-toggle-locked').removeClass('push-toggle-enabled')
++					.attr('title', pushNotifications.language.UNSUPPORTED);
++				break;
++		}
++	}
++
++	function updateBtn() {
++		if (Notification.permission === 'denied') {
++			setButtonState('disallowed');
++			return;
++		}
++		if (isSubscribed) {
++			setButtonState('enabled');
++		} else {
++			setButtonState('disabled');
++		}
++	}
++
++	function updateSubscriptionOnServer(subscription, unsubscribe) {
++		$.ajax({
++			url: pushNotifications.notificationsPath + (unsubscribe ? 'unsubscribe' : 'subscribe'),
++			data: JSON.parse(JSON.stringify(subscription)),
++			method: 'POST',
++			error: function() {
++				if (!unsubscribe) { // Unsubscribe in case of an error during subscription.
++					unsubscribeUser();
++					phpbb.alert(pushNotifications.language.INFORMATION, pushNotifications.language.UPDATE_FAILED);
++				}
++				// Do not show an error for failed unsubscription - it will be handled on the server side.
++			},
++			success: function(res) {
++				if (!res.id && !unsubscribe) { // Unsubscribe in case of an error during subscription.
++					unsubscribeUser();
++					phpbb.alert(
++						pushNotifications.language.INFORMATION,
++						(res.error) ? res.error : pushNotifications.language.UPDATE_FAILED
++					);
++					return;
++				} else if (unsubscribe) {
++					return;
++				}
++				localStorage.pushSubscription = JSON.stringify({
++					serverKey: pushNotifications.serverAPIkey,
++					serverURL: pushNotifications.notificationsPath,
++					subscriptionID: res.id
++				});
++			},
++			cache: false
++		});
++	}
++
++	function subscribeUser() {
++		var applicationServerKey = urlB64ToUint8Array(pushNotifications.serverAPIkey);
++		swRegistration.pushManager.subscribe({
++			userVisibleOnly: true,
++			applicationServerKey: applicationServerKey
++		}).then(function(subscription) {
++			updateSubscriptionOnServer(subscription);
++			isSubscribed = true;
++			updateBtn();
++		}).catch(function() {
++			phpbb.alert(pushNotifications.language.INFORMATION, pushNotifications.language.UPDATE_FAILED);
++			updateBtn();
++		});
++	}
++
++	function unsubscribeUser() {
++		swRegistration.pushManager.getSubscription().then(function(subscription) {
++			delete localStorage.pushSubscription;
++			isSubscribed = false;
++			updateBtn();
++			if (subscription) {
++				updateSubscriptionOnServer(subscription, true);
++				return subscription.unsubscribe();
++			}
++		});
++	}
++
++	function subscribe() {
++		if (isSubscribed) {
++			unsubscribeUser();
++		} else {
++			subscribeUser();
++		}
++	}
++
++	function showIntroConfirmation() {
++		var introContent = '<form action="{S_CONFIRM_ACTION}" method="post"><h2 style="text-align: center;">' + pushNotifications.language.INTRO + '</h2><fieldset class="submit-buttons" style="padding-top: 15px; font-size: 1.3em;"><input type="button" name="confirm" value="' + pushNotifications.language.INTRO_YES + '" class="btn btn-default" style="margin-right: 25px;" />&nbsp;<input type="button" name="cancel" value="' + pushNotifications.language.INTRO_NO + '" class="btn btn-default" /></fieldset></form>';
++		phpbb.confirm(introContent, function(confirm) {
++			if (confirm) {
++				$pushButton.first().click();
++			}
++		});
++		localStorage.pushConfirmation = "1";
++	}
++
++	if ('serviceWorker' in navigator && 'PushManager' in window) {
++		$pushButton.on('click', subscribe);
++		navigator.serviceWorker.register(pushNotifications.serviceWorkerPath).then(function(swReg) {
++			swRegistration = swReg;
++
++			if (pushNotifications.introConfirmation && !localStorage.pushConfirmation) {
++				showIntroConfirmation();
++			}
++
++			// Set the initial subscription value
++			swRegistration.pushManager.getSubscription().then(function(subscription) {
++				isSubscribed = (subscription !== null);
++
++				// It is better to show the real subscription state.
++				if (!localStorage.pushSubscription && subscription) {
++					isSubscribed = false;
++					return subscription.unsubscribe();
++				}
++
++				updateBtn();
++			});
++		});
++	} else {
++		setButtonState('unsupported');
++	}
++})(jQuery, window, document);
++});
+\ No newline at end of file
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/styles/FLATBOOTS/template/js/notifications.js" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/styles/FLATBOOTS/template/js/notifications.js"
+new file mode 100644
+index 000000000..33c40721a
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/styles/FLATBOOTS/template/js/notifications.js"
+@@ -0,0 +1 @@
++head.ready(function(){!function(t,i,e){"use strict";var a="<div class='push-notify'><span class='btn btn-default btn-sm'>"+pushNotifications.language.BROWSER_NOTIFICATIONS+"</span><span class='push-toggle'><span></span></span><span class='push-notify-status'></span></div>";pushNotifications.notificationsPage&&t("form#ucp table").before(a),pushNotifications.dropdownIntegration&&t(".dropdown-menu #notification_list .navbar-footer-content .row").after("<div class='text-left'>"+a+"</div>");var n=t(".push-notify"),s=t(".push-notify-status"),o=!1,u=null;function r(t){switch(t){case"enabled":s.text(pushNotifications.language.ACTIONS.ENABLED),n.removeClass("push-toggle-locked").addClass("push-toggle-enabled").attr("title",pushNotifications.language.DISABLE);break;case"disabled":s.text(pushNotifications.language.ACTIONS.DISABLED),n.removeClass("push-toggle-locked push-toggle-enabled").attr("title",pushNotifications.language.ENABLE);break;case"disallowed":s.text(pushNotifications.language.ACTIONS.DISALLOWED),n.addClass("push-toggle-locked").removeClass("push-toggle-enabled").attr("title",pushNotifications.language.DISALLOWED);break;case"unsupported":s.text(pushNotifications.language.ACTIONS.UNSUPPORTED),n.addClass("push-toggle-locked").removeClass("push-toggle-enabled").attr("title",pushNotifications.language.UNSUPPORTED)}}function c(){"denied"!==Notification.permission?r(o?"enabled":"disabled"):r("disallowed")}function l(i,e){t.ajax({url:pushNotifications.notificationsPath+(e?"unsubscribe":"subscribe"),data:JSON.parse(JSON.stringify(i)),method:"POST",error:function(){e||(g(),phpbb.alert(pushNotifications.language.INFORMATION,pushNotifications.language.UPDATE_FAILED))},success:function(t){if(!t.id&&!e)return g(),void phpbb.alert(pushNotifications.language.INFORMATION,t.error?t.error:pushNotifications.language.UPDATE_FAILED);e||(localStorage.pushSubscription=JSON.stringify({serverKey:pushNotifications.serverAPIkey,serverURL:pushNotifications.notificationsPath,subscriptionID:t.id}))},cache:!1})}function p(){var t=function(t){for(var e=(t+"=".repeat((4-t.length%4)%4)).replace(/\-/g,"+").replace(/_/g,"/"),a=i.atob(e),n=new Uint8Array(a.length),s=0;s<a.length;++s)n[s]=a.charCodeAt(s);return n}(pushNotifications.serverAPIkey);u.pushManager.subscribe({userVisibleOnly:!0,applicationServerKey:t}).then(function(t){l(t),o=!0,c()}).catch(function(){phpbb.alert(pushNotifications.language.INFORMATION,pushNotifications.language.UPDATE_FAILED),c()})}function g(){u.pushManager.getSubscription().then(function(t){if(delete localStorage.pushSubscription,o=!1,c(),t)return l(t,!0),t.unsubscribe()})}"serviceWorker"in navigator&&"PushManager"in i?(n.on("click",function(){o?g():p()}),navigator.serviceWorker.register(pushNotifications.serviceWorkerPath).then(function(t){var i;u=t,pushNotifications.introConfirmation&&!localStorage.pushConfirmation&&(i='<form action="{S_CONFIRM_ACTION}" method="post"><h2 style="text-align: center;">'+pushNotifications.language.INTRO+'</h2><fieldset class="submit-buttons" style="padding-top: 15px; font-size: 1.3em;"><input type="button" name="confirm" value="'+pushNotifications.language.INTRO_YES+'" class="btn btn-default" style="margin-right: 25px;" />&nbsp;<input type="button" name="cancel" value="'+pushNotifications.language.INTRO_NO+'" class="btn btn-default" /></fieldset></form>',phpbb.confirm(i,function(t){t&&n.first().click()}),localStorage.pushConfirmation="1"),u.pushManager.getSubscription().then(function(t){if(o=null!==t,!localStorage.pushSubscription&&t)return o=!1,t.unsubscribe();c()})})):r("unsupported")}(jQuery,window,document)});
+\ No newline at end of file
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/styles/FLATBOOTS/template/js/sw.bak.js" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/styles/FLATBOOTS/template/js/sw.bak.js"
+new file mode 100644
+index 000000000..e13827256
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/styles/FLATBOOTS/template/js/sw.bak.js"
+@@ -0,0 +1,105 @@
++/* jshint browser:true, worker:true, es3:false, esversion:6 */
++'use strict';
++head.ready(function () {
++function urlB64ToUint8Array(base64String) {
++	var padding = '='.repeat((4 - base64String.length % 4) % 4);
++	var base64 = (base64String + padding)
++		.replace(/\-/g, '+')
++		.replace(/_/g, '/');
++
++	var rawData = window.atob(base64);
++	var outputArray = new Uint8Array(rawData.length);
++
++	for (var i = 0; i < rawData.length; ++i) {
++		outputArray[i] = rawData.charCodeAt(i);
++	}
++	return outputArray;
++}
++
++self.addEventListener('install', function(event) {
++	event.waitUntil(self.skipWaiting());
++});
++
++self.addEventListener('activate', function(event) {
++	event.waitUntil(self.clients.claim());
++});
++
++self.addEventListener('notificationclick', function(event) {
++	var notification = event.notification,
++		data = notification.data;
++
++	notification.close();
++
++	if (data && data.url) {
++		event.waitUntil(
++			// Retrieve a list of the clients of this service worker.
++			self.clients.matchAll({ type: 'window' }).then(function(clientList) {
++				// If there is at least one client, focus it.
++				if (clientList.length > 0) {
++					clientList[0].navigate(data.url);
++					return clientList[0].focus();
++				}
++
++				// Otherwise, open a new page.
++				return self.clients.openWindow(data.url);
++			})
++		);
++	}
++});
++
++self.addEventListener('push', function(event) {
++	const data = event.data.json();
++	const title = data.title;
++	const options = {
++		body: data.message,
++		data: {url: data.url},
++		icon: data.avatar,
++		badge: data.badge,
++		vibrate: [300, 100, 400],
++		timestamp: data.time,
++		requireInteraction: true
++	};
++
++	event.waitUntil(self.registration.showNotification(title, options));
++});
++
++self.addEventListener('pushsubscriptionchange', function(event) {
++	if (!localStorage.pushSubscription) {
++		return;
++	}
++	var pushSubscription = JSON.parse(localStorage.pushSubscription);
++    const applicationServerKey = urlB64ToUint8Array(pushSubscription.serverKey);
++    event.waitUntil(
++        self.registration.pushManager.subscribe({
++            userVisibleOnly: true,
++            applicationServerKey: applicationServerKey
++        }).then(function(newSubscription) {
++	        var subscriptionArray = JSON.parse(JSON.stringify(newSubscription)),
++		        subscriptionString = 'endpoint=' + subscriptionArray.endpoint + '&keys[p256dh]=' + subscriptionArray.keys.p256dh + '&keys[auth]=' + subscriptionArray.keys.auth + '&subscription_id=' + pushSubscription.subscriptionID;
++
++	        var fetchOptions = {
++		        method: 'post',
++		        headers: new Headers({
++			        'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8',
++			        'X-Requested-With': 'XMLHttpRequest'
++		        }),
++		        credentials: 'include',
++		        body: subscriptionString
++	        };
++	        return fetch(pushSubscription.serverURL + 'subscribe', fetchOptions);
++        }).then(function(response) {
++	        return response.json();
++        }).then(function(res) {
++	        if (!res.id) {
++		        return;
++	        }
++	        localStorage.pushSubscription = JSON.stringify({
++		        serverKey: pushSubscription.serverKey,
++		        serverURL: pushSubscription.serverURL,
++		        subscriptionID: res.id
++	        });
++        })
++    );
++});
++
++});
+\ No newline at end of file
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/styles/FLATBOOTS/template/js/sw.js" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/styles/FLATBOOTS/template/js/sw.js"
+new file mode 100644
+index 000000000..bf724de21
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/styles/FLATBOOTS/template/js/sw.js"
+@@ -0,0 +1 @@
++"use strict";head.ready(function(){self.addEventListener("install",function(e){e.waitUntil(self.skipWaiting())}),self.addEventListener("activate",function(e){e.waitUntil(self.clients.claim())}),self.addEventListener("notificationclick",function(e){var t=e.notification,n=t.data;t.close(),n&&n.url&&e.waitUntil(self.clients.matchAll({type:"window"}).then(function(e){return e.length>0?(e[0].navigate(n.url),e[0].focus()):self.clients.openWindow(n.url)}))}),self.addEventListener("push",function(e){const t=e.data.json(),n=t.title,i={body:t.message,data:{url:t.url},icon:t.avatar,badge:t.badge,vibrate:[300,100,400],timestamp:t.time,requireInteraction:!0};e.waitUntil(self.registration.showNotification(n,i))}),self.addEventListener("pushsubscriptionchange",function(e){if(!localStorage.pushSubscription)return;var t=JSON.parse(localStorage.pushSubscription);const n=function(e){for(var t=(e+"=".repeat((4-e.length%4)%4)).replace(/\-/g,"+").replace(/_/g,"/"),n=window.atob(t),i=new Uint8Array(n.length),r=0;r<n.length;++r)i[r]=n.charCodeAt(r);return i}(t.serverKey);e.waitUntil(self.registration.pushManager.subscribe({userVisibleOnly:!0,applicationServerKey:n}).then(function(e){var n=JSON.parse(JSON.stringify(e)),i="endpoint="+n.endpoint+"&keys[p256dh]="+n.keys.p256dh+"&keys[auth]="+n.keys.auth+"&subscription_id="+t.subscriptionID,r={method:"post",headers:new Headers({"Content-Type":"application/x-www-form-urlencoded; charset=UTF-8","X-Requested-With":"XMLHttpRequest"}),credentials:"include",body:i};return fetch(t.serverURL+"subscribe",r)}).then(function(e){return e.json()}).then(function(e){e.id&&(localStorage.pushSubscription=JSON.stringify({serverKey:t.serverKey,serverURL:t.serverURL,subscriptionID:e.id}))}))})});
+\ No newline at end of file
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/styles/FLATBOOTS/theme/notifications.bak.css" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/styles/FLATBOOTS/theme/notifications.bak.css"
+new file mode 100644
+index 000000000..1f42af1a3
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/styles/FLATBOOTS/theme/notifications.bak.css"
+@@ -0,0 +1,86 @@
++.push-notify {
++	display: inline-block;
++	padding: 5px 0;
++	cursor: pointer;
++}
++
++.dropdown-contents .push-notify {
++	display: block;
++	text-align: center;
++}
++
++.push-notify .push-toggle {
++	display: inline-block;
++	position: relative;
++	background-color: #c74564;
++	border: 1px solid #757575;
++	border-radius: 15px;
++	width: 45px;
++	height: 14px;
++	line-height: 24px;
++	margin: 5px 7px;
++	vertical-align: top;
++	box-shadow: 0 1px 2px #373737 inset;
++	-webkit-transition: all 0.5s ease;
++	-moz-transition: all 0.5s ease;
++	-o-transition: all 0.5s ease;
++	transition: all 0.5s ease;
++}
++
++.push-notify.push-toggle-enabled .push-toggle {
++	background-color: #35a035;
++}
++
++.push-notify .push-toggle span {
++	display: block;
++	position: absolute;
++	top: 0;
++	left: -1px;
++	border-radius: 200%;
++	border: 1px solid #757575;
++	background-color: #fff;
++	width: 20px;
++	height: 20px;
++	margin-top: -4px;
++	-webkit-transition: all 0.3s ease;
++	-moz-transition: all 0.3s ease;
++	-o-transition: all 0.3s ease;
++	transition: all 0.3s ease;
++}
++
++.push-notify.push-toggle-enabled .push-toggle span {
++	left: 25px;
++}
++
++.push-notify:hover .push-toggle span {
++	background-color: #fdfcd3;
++}
++
++.push-notify.push-toggle-locked {
++	cursor: auto;
++}
++
++.push-notify.push-toggle-locked .push-toggle {
++	background-color: #a8a8a8;
++}
++
++.push-notify.push-toggle-locked .push-toggle span {
++	background-color: #e0e0e0;
++}
++
++.push-notify .push-notify-status {
++	display: inline-block;
++	font-size: 14px;
++	font-weight: bold;
++	line-height: 14px;
++	padding-top: 6px;
++	vertical-align: top;
++}
++
++.push-notify > span:first-of-type {
++	display: inline-block;
++	font-size: 12px;
++	line-height: 14px;
++	padding-top: 5px;
++	vertical-align: top;
++}
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/styles/FLATBOOTS/theme/notifications.css" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/styles/FLATBOOTS/theme/notifications.css"
+new file mode 100644
+index 000000000..5e0fd965f
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/styles/FLATBOOTS/theme/notifications.css"
+@@ -0,0 +1 @@
++.push-notify{display:inline-block;padding:5px 0;cursor:pointer}.dropdown-contents .push-notify{display:block;text-align:center}.push-notify .push-toggle{display:inline-block;position:relative;background-color:#c74564;border:1px solid #757575;border-radius:15px;width:45px;height:14px;line-height:24px;margin:5px 7px;vertical-align:top;box-shadow:0 1px 2px #373737 inset;-webkit-transition:all .5s ease;-moz-transition:all .5s ease;-o-transition:all .5s ease;transition:all .5s ease}.push-notify.push-toggle-enabled .push-toggle{background-color:#35a035}.push-notify .push-toggle span{display:block;position:absolute;top:0;left:-1px;border-radius:200%;border:1px solid #757575;background-color:#fff;width:20px;height:20px;margin-top:-4px;-webkit-transition:all .3s ease;-moz-transition:all .3s ease;-o-transition:all .3s ease;transition:all .3s ease}.push-notify.push-toggle-enabled .push-toggle span{left:25px}.push-notify:hover .push-toggle span{background-color:#fdfcd3}.push-notify.push-toggle-locked{cursor:auto}.push-notify.push-toggle-locked .push-toggle{background-color:#a8a8a8}.push-notify.push-toggle-locked .push-toggle span{background-color:#e0e0e0}.push-notify .push-notify-status{display:inline-block;font-size:14px;font-weight:700;line-height:14px;padding-top:6px;vertical-align:top}.push-notify > span:first-of-type{display:inline-block;font-size:12px;line-height:14px;padding-top:5px;vertical-align:top}
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lavigor\\notifications/styles/all/template/js/sw.js" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/styles/all/template/js/sw.js"
+index e617abc2d..e9e19a367 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lavigor\\notifications/styles/all/template/js/sw.js"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/styles/all/template/js/sw.js"
+@@ -56,7 +56,7 @@ self.addEventListener('push', function(event) {
+ 		icon: data.avatar,
+ 		badge: data.badge,
+ 		vibrate: [300, 100, 400],
+-		timestamp: data.time,
++		timestamp: data.time * 1000,
+ 		requireInteraction: true
+ 	};
+ 
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lavigor\\notifications/vendor/guzzlehttp/promises/src/Promise.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/vendor/guzzlehttp/promises/src/Promise.php"
+index 844ada073..a5e320e76 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lavigor\\notifications/vendor/guzzlehttp/promises/src/Promise.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/vendor/guzzlehttp/promises/src/Promise.php"
+@@ -148,7 +148,7 @@ class Promise implements PromiseInterface
+ 
+         // If the value was not a settled promise or a thenable, then resolve
+         // it in the task queue using the correct ID.
+-        if (!method_exists($value, 'then')) {
++        if (!is_object($value) || !method_exists($value, 'then')) {
+             $id = $state === self::FULFILLED ? 1 : 2;
+             // It's a success, so resolve the handlers in the queue.
+             queue()->add(static function () use ($id, $value, $handlers) {
diff --git "[FORUM_EXT]/lavigor\\notifications/diff_nospace.tmp" "[FORUM_EXT]/lavigor\\notifications/diff_nospace.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/lavigor\\notifications/diff_nospace.tmp"
@@ -0,0 +1,812 @@
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/diff_full.tmp"
+new file mode 100644
+index 000000000..e1a853db7
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/diff_full.tmp"
+@@ -0,0 +1,818 @@
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/diff_full.tmp"
++new file mode 100644
++index 000000000..e69de29bb
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lavigor\\notifications/language/en/notifications.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/language/en/notifications.php"
++index e110c1e1e..a3f529721 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lavigor\\notifications/language/en/notifications.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/language/en/notifications.php"
++@@ -22,7 +22,7 @@ if (empty($lang) || !is_array($lang))
++ 
++ $lang = array_merge($lang, array(
++ 	'LAVIGOR_NOTIFICATIONS_NOTIFICATION_METHOD_BROWSER' => 'Browser',
++-	'BROWSER_NOTIFICATIONS'                             => 'Browser notifications',
+++	'BROWSER_NOTIFICATIONS'                             => 'Browser Notifications',
++ 	'BROWSER_NOTIFICATIONS_ACTION_ENABLED'              => 'On',
++ 	'BROWSER_NOTIFICATIONS_ACTION_DISABLED'             => 'Off',
++ 	'BROWSER_NOTIFICATIONS_ACTION_DISALLOWED'           => 'Disallowed',
++@@ -30,7 +30,7 @@ $lang = array_merge($lang, array(
++ 	'BROWSER_NOTIFICATIONS_ENABLE'                      => 'Enable browser notifications.',
++ 	'BROWSER_NOTIFICATIONS_DISABLE'                     => 'Disable browser notifications.',
++ 	'BROWSER_NOTIFICATIONS_DISALLOWED'                  => 'Web Notifications are disallowed in this browser. Allow notifications for this website in browser settings if you want to subscribe.',
++-	'BROWSER_NOTIFICATIONS_INTRO'                       => 'Do you want to allow this portal to notify you about replies?',
+++	'BROWSER_NOTIFICATIONS_INTRO'                       => 'Do you want to allow GoldTugAnime to notify you?',
++ 	'BROWSER_NOTIFICATIONS_MAX_LIMIT_REACHED'           => 'The maximum allowed number of browsers with enabled browser notifications (%s per user) has been reached. Please turn off browser notifications for this board in any other browser where you enabled them if you want to enable browser notifications in this browser.',
++ 	'BROWSER_NOTIFICATIONS_UNSUPPORTED'                 => 'Web Notifications are not supported by this browser.',
++ 	'BROWSER_NOTIFICATIONS_UPDATE_FAILED'               => 'There was an error (possibly connection error while contacting the server) during the subscription to Web Notifications. They have been disabled in this browser. Please check your Internet connection and try again. Contact the board administrator if the problem persists.',
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/language/pt/info_acp_notifications.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/language/pt/info_acp_notifications.php"
++new file mode 100644
++index 000000000..955b08e9f
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/language/pt/info_acp_notifications.php"
++@@ -0,0 +1,26 @@
+++<?php
+++/**
+++ *
+++ * @package Push Notifications
+++ * @copyright (c) 2017 - 2018 LavIgor
+++ * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+++ *
+++ */
+++
+++/**
+++ * DO NOT CHANGE
+++ */
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
+++	'LOG_WEB_PUSH_GENERAL_ERROR'	=> '<strong>Web Push error</strong><br />» %s',
+++	'LOG_WEB_PUSH_SERVER_ERROR'		=> '<strong>Web Push error</strong> with code <strong>%1$s</strong><br />» %2$s',
+++));
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/language/pt/info_ucp_notifications.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/language/pt/info_ucp_notifications.php"
++new file mode 100644
++index 000000000..fd979f521
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/language/pt/info_ucp_notifications.php"
++@@ -0,0 +1,25 @@
+++<?php
+++/**
+++ *
+++ * @package Push Notifications
+++ * @copyright (c) 2017 - 2018 LavIgor
+++ * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+++ *
+++ */
+++
+++/**
+++ * DO NOT CHANGE
+++ */
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
+++	'LAVIGOR_NOTIFICATIONS_NOTIFICATION_METHOD_BROWSER' => 'Navegador',
+++));
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/language/pt/notifications.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/language/pt/notifications.php"
++new file mode 100644
++index 000000000..e6089cd3f
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/language/pt/notifications.php"
++@@ -0,0 +1,37 @@
+++<?php
+++/**
+++ *
+++ * @package       Push Notifications
+++ * @copyright (c) 2017 - 2018 LavIgor
+++ * @license       http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+++ *
+++ */
+++
+++/**
+++ * DO NOT CHANGE
+++ */
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
+++	'LAVIGOR_NOTIFICATIONS_NOTIFICATION_METHOD_BROWSER' => 'Navegador',
+++	'BROWSER_NOTIFICATIONS'                             => 'Notificações de Navegador',
+++	'BROWSER_NOTIFICATIONS_ACTION_ENABLED'              => 'Ligado',
+++	'BROWSER_NOTIFICATIONS_ACTION_DISABLED'             => 'Desligado',
+++	'BROWSER_NOTIFICATIONS_ACTION_DISALLOWED'           => 'Não é permitido',
+++	'BROWSER_NOTIFICATIONS_ACTION_UNSUPPORTED'          => 'Não é suportado',
+++	'BROWSER_NOTIFICATIONS_ENABLE'                      => 'Ativar notificações de navegador.',
+++	'BROWSER_NOTIFICATIONS_DISABLE'                     => 'Desativar notificações de navegador.',
+++	'BROWSER_NOTIFICATIONS_DISALLOWED'                  => 'Notificações Web não são permitidas neste navegador. Permita as notificações de navegador para esta página nas configurações do navegador, caso desejes te subscrever.',
+++	'BROWSER_NOTIFICATIONS_INTRO'                       => 'Desejas permitir que o GoldTugAnime te envie notificações?',
+++	'BROWSER_NOTIFICATIONS_MAX_LIMIT_REACHED'           => 'O número máximo de navegadores permitidos para as notificações de navegador (%s por utilizador) foi atingido. Por favor, desliga as notificações de navegador deste fórum que tenhas ativado em qualquer outro navegador para que possas ativá-lo neste.',
+++	'BROWSER_NOTIFICATIONS_UNSUPPORTED'                 => 'Notificações Web não são suportadas pelo teu navegador atual.',
+++	'BROWSER_NOTIFICATIONS_UPDATE_FAILED'               => 'Ocorreu um erro (possivelmente erro de conexão ao contactar o servidor) durante a assinatura da Notificação Web. Foi desativada neste navegador. Por favor, verifica a tua conexão de internet e tenta novamente. Entra em contacto com o administrador do fórum se o problema persistir.',
+++));
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/language/pt/notifications_acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/language/pt/notifications_acp.php"
++new file mode 100644
++index 000000000..affba0407
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/language/pt/notifications_acp.php"
++@@ -0,0 +1,33 @@
+++<?php
+++/**
+++ *
+++ * @package       Push Notifications
+++ * @copyright (c) 2017 - 2018 LavIgor
+++ * @license       http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+++ *
+++ */
+++
+++/**
+++ * DO NOT CHANGE
+++ */
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
+++	'BROWSER_NOTIFICATION_BADGE_URL'            => 'Absolute URL to the badge image for Push Notifications',
+++	'BROWSER_NOTIFICATION_DROPDOWN'             => 'Integrate the toggle for browser Push Notifications into the standard dropdown for notifications',
+++	'BROWSER_NOTIFICATION_DROPDOWN_EXPLAIN'     => 'The toggle for browser Push Notifications on the notification options management page will be shown regardless of this setting.',
+++	'BROWSER_NOTIFICATION_INTRO'                => 'Ask user whether he/she wants to enable Push Notifications when he/she logs in with a new browser',
+++	'BROWSER_NOTIFICATION_INTRO_EXPLAIN'        => 'Modal dialog will be shown only once in each browser regardless of login amount with a certain browser.',
+++	'BROWSER_NOTIFICATION_MAX_BROWSERS'         => 'Maximum allowed number of browsers with enabled Push Notifications per each user',
+++	'BROWSER_NOTIFICATION_MAX_BROWSERS_EXPLAIN' => 'The user will not be able to turn on Push Notification for the board in any browser if the allowed amount of browsers with enabled Push Notifications has been reached. Enter 0 to disable this setting <em>(not recommended)</em>.',
+++	'BROWSER_NOTIFICATION_TTL'                  => 'Time To Live for Web Notifications',
+++	'BROWSER_NOTIFICATION_TTL_EXPLAIN'          => 'Time To Live (TTL) is how long a push message is retained by the push service (e.g. Mozilla) in case the user browser is not yet accessible (e.g. is not connected). You may want to use a very long time for important notifications. The default TTL is 4 weeks. However, if you send multiple nonessential notifications, set a TTL of 0: the push notification will be delivered only if the user is currently connected. For other cases, you should use a minimum of one day if your users have multiple time zones, and if they don’t, several hours will suffice.',
+++));
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/language/pt_preao/info_acp_notifications.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/language/pt_preao/info_acp_notifications.php"
++new file mode 100644
++index 000000000..955b08e9f
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/language/pt_preao/info_acp_notifications.php"
++@@ -0,0 +1,26 @@
+++<?php
+++/**
+++ *
+++ * @package Push Notifications
+++ * @copyright (c) 2017 - 2018 LavIgor
+++ * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+++ *
+++ */
+++
+++/**
+++ * DO NOT CHANGE
+++ */
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
+++	'LOG_WEB_PUSH_GENERAL_ERROR'	=> '<strong>Web Push error</strong><br />» %s',
+++	'LOG_WEB_PUSH_SERVER_ERROR'		=> '<strong>Web Push error</strong> with code <strong>%1$s</strong><br />» %2$s',
+++));
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/language/pt_preao/info_ucp_notifications.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/language/pt_preao/info_ucp_notifications.php"
++new file mode 100644
++index 000000000..fd979f521
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/language/pt_preao/info_ucp_notifications.php"
++@@ -0,0 +1,25 @@
+++<?php
+++/**
+++ *
+++ * @package Push Notifications
+++ * @copyright (c) 2017 - 2018 LavIgor
+++ * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+++ *
+++ */
+++
+++/**
+++ * DO NOT CHANGE
+++ */
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
+++	'LAVIGOR_NOTIFICATIONS_NOTIFICATION_METHOD_BROWSER' => 'Navegador',
+++));
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/language/pt_preao/notifications.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/language/pt_preao/notifications.php"
++new file mode 100644
++index 000000000..e6089cd3f
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/language/pt_preao/notifications.php"
++@@ -0,0 +1,37 @@
+++<?php
+++/**
+++ *
+++ * @package       Push Notifications
+++ * @copyright (c) 2017 - 2018 LavIgor
+++ * @license       http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+++ *
+++ */
+++
+++/**
+++ * DO NOT CHANGE
+++ */
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
+++	'LAVIGOR_NOTIFICATIONS_NOTIFICATION_METHOD_BROWSER' => 'Navegador',
+++	'BROWSER_NOTIFICATIONS'                             => 'Notificações de Navegador',
+++	'BROWSER_NOTIFICATIONS_ACTION_ENABLED'              => 'Ligado',
+++	'BROWSER_NOTIFICATIONS_ACTION_DISABLED'             => 'Desligado',
+++	'BROWSER_NOTIFICATIONS_ACTION_DISALLOWED'           => 'Não é permitido',
+++	'BROWSER_NOTIFICATIONS_ACTION_UNSUPPORTED'          => 'Não é suportado',
+++	'BROWSER_NOTIFICATIONS_ENABLE'                      => 'Ativar notificações de navegador.',
+++	'BROWSER_NOTIFICATIONS_DISABLE'                     => 'Desativar notificações de navegador.',
+++	'BROWSER_NOTIFICATIONS_DISALLOWED'                  => 'Notificações Web não são permitidas neste navegador. Permita as notificações de navegador para esta página nas configurações do navegador, caso desejes te subscrever.',
+++	'BROWSER_NOTIFICATIONS_INTRO'                       => 'Desejas permitir que o GoldTugAnime te envie notificações?',
+++	'BROWSER_NOTIFICATIONS_MAX_LIMIT_REACHED'           => 'O número máximo de navegadores permitidos para as notificações de navegador (%s por utilizador) foi atingido. Por favor, desliga as notificações de navegador deste fórum que tenhas ativado em qualquer outro navegador para que possas ativá-lo neste.',
+++	'BROWSER_NOTIFICATIONS_UNSUPPORTED'                 => 'Notificações Web não são suportadas pelo teu navegador atual.',
+++	'BROWSER_NOTIFICATIONS_UPDATE_FAILED'               => 'Ocorreu um erro (possivelmente erro de conexão ao contactar o servidor) durante a assinatura da Notificação Web. Foi desativada neste navegador. Por favor, verifica a tua conexão de internet e tenta novamente. Entra em contacto com o administrador do fórum se o problema persistir.',
+++));
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/language/pt_preao/notifications_acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/language/pt_preao/notifications_acp.php"
++new file mode 100644
++index 000000000..affba0407
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/language/pt_preao/notifications_acp.php"
++@@ -0,0 +1,33 @@
+++<?php
+++/**
+++ *
+++ * @package       Push Notifications
+++ * @copyright (c) 2017 - 2018 LavIgor
+++ * @license       http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+++ *
+++ */
+++
+++/**
+++ * DO NOT CHANGE
+++ */
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
+++	'BROWSER_NOTIFICATION_BADGE_URL'            => 'Absolute URL to the badge image for Push Notifications',
+++	'BROWSER_NOTIFICATION_DROPDOWN'             => 'Integrate the toggle for browser Push Notifications into the standard dropdown for notifications',
+++	'BROWSER_NOTIFICATION_DROPDOWN_EXPLAIN'     => 'The toggle for browser Push Notifications on the notification options management page will be shown regardless of this setting.',
+++	'BROWSER_NOTIFICATION_INTRO'                => 'Ask user whether he/she wants to enable Push Notifications when he/she logs in with a new browser',
+++	'BROWSER_NOTIFICATION_INTRO_EXPLAIN'        => 'Modal dialog will be shown only once in each browser regardless of login amount with a certain browser.',
+++	'BROWSER_NOTIFICATION_MAX_BROWSERS'         => 'Maximum allowed number of browsers with enabled Push Notifications per each user',
+++	'BROWSER_NOTIFICATION_MAX_BROWSERS_EXPLAIN' => 'The user will not be able to turn on Push Notification for the board in any browser if the allowed amount of browsers with enabled Push Notifications has been reached. Enter 0 to disable this setting <em>(not recommended)</em>.',
+++	'BROWSER_NOTIFICATION_TTL'                  => 'Time To Live for Web Notifications',
+++	'BROWSER_NOTIFICATION_TTL_EXPLAIN'          => 'Time To Live (TTL) is how long a push message is retained by the push service (e.g. Mozilla) in case the user browser is not yet accessible (e.g. is not connected). You may want to use a very long time for important notifications. The default TTL is 4 weeks. However, if you send multiple nonessential notifications, set a TTL of 0: the push notification will be delivered only if the user is currently connected. For other cases, you should use a minimum of one day if your users have multiple time zones, and if they don’t, several hours will suffice.',
+++));
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/styles/FLATBOOTS/template/event/overall_header_head_append.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/styles/FLATBOOTS/template/event/overall_header_head_append.html"
++new file mode 100644
++index 000000000..b8d586a06
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/styles/FLATBOOTS/template/event/overall_header_head_append.html"
++@@ -0,0 +1,45 @@
+++<!-- IF S_REGISTERED_USER and not S_IS_BOT and (S_PUSH_DROPDOWN_INTEGRATION or S_IN_UCP and MODE == 'notification_options') -->
+++<script>
+++//<![CDATA[
+++	var pushNotifications = {
+++		dropdownIntegration: '{S_PUSH_DROPDOWN_INTEGRATION}',
+++		introConfirmation: '{S_PUSH_INTRO_CONFIRMATION}',
+++		language: {
+++			ACTIONS: {
+++				ENABLED: '{LA_BROWSER_NOTIFICATIONS_ACTION_ENABLED}',
+++				DISABLED: '{LA_BROWSER_NOTIFICATIONS_ACTION_DISABLED}',
+++				DISALLOWED: '{LA_BROWSER_NOTIFICATIONS_ACTION_DISALLOWED}',
+++				UNSUPPORTED: '{LA_BROWSER_NOTIFICATIONS_ACTION_UNSUPPORTED}'
+++			},
+++			BROWSER_NOTIFICATIONS: '{LA_BROWSER_NOTIFICATIONS}{LA_COLON}',
+++			ENABLE: '{LA_BROWSER_NOTIFICATIONS_ENABLE}',
+++			DISABLE: '{LA_BROWSER_NOTIFICATIONS_DISABLE}',
+++			DISALLOWED: '{LA_BROWSER_NOTIFICATIONS_DISALLOWED}',
+++			INFORMATION: '{LA_INFORMATION}',
+++			INTRO: '{LA_BROWSER_NOTIFICATIONS_INTRO}',
+++			INTRO_NO: '{LA_NO}',
+++			INTRO_YES: '{LA_YES}',
+++			UNSUPPORTED: '{LA_BROWSER_NOTIFICATIONS_UNSUPPORTED}',
+++			UPDATE_FAILED: '{LA_BROWSER_NOTIFICATIONS_UPDATE_FAILED}'
+++		},
+++		notificationsPath: '{ROOT_PATH}notifications/browser/',
+++		notificationsPage: <!-- IF S_IN_UCP and MODE == 'notification_options' -->true<!-- ELSE -->false<!-- ENDIF -->,
+++		serviceWorkerPath: '{ROOT_PATH}ext/lavigor/notifications/styles/all/template/js/sw.js',
+++		serverAPIkey: '{PUSH_API_PUBLIC_KEY}'
+++	};
+++//]]>
+++</script>
+++<!-- INCLUDECSS @lavigor_notifications/notifications.css -->
+++<!-- INCLUDEJS @lavigor_notifications/js/notifications.js -->
+++<!-- IF S_IN_UCP and MODE == 'notification_options' -->
+++<style>
+++	.nojs form#ucp table thead:before {
+++		content: '{L_BROWSER_NOTIFICATIONS_UNSUPPORTED}';
+++		display: block;
+++		padding: 10px 0;
+++		font-size: 1.2em;
+++		font-weight: bold;
+++	}
+++</style>
+++<!-- ENDIF -->
+++<!-- ENDIF -->
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/styles/FLATBOOTS/template/js/images/badge.png" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/styles/FLATBOOTS/template/js/images/badge.png"
++new file mode 100644
++index 000000000..774ae9e7c
++Binary files /dev/null and "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/styles/FLATBOOTS/template/js/images/badge.png" differ
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/styles/FLATBOOTS/template/js/images/icon.png" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/styles/FLATBOOTS/template/js/images/icon.png"
++new file mode 100644
++index 000000000..7242e9562
++Binary files /dev/null and "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/styles/FLATBOOTS/template/js/images/icon.png" differ
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/styles/FLATBOOTS/template/js/images/no_avatar.gif" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/styles/FLATBOOTS/template/js/images/no_avatar.gif"
++new file mode 100644
++index 000000000..ad73330e7
++Binary files /dev/null and "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/styles/FLATBOOTS/template/js/images/no_avatar.gif" differ
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/styles/FLATBOOTS/template/js/notifications.bak.js" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/styles/FLATBOOTS/template/js/notifications.bak.js"
++new file mode 100644
++index 000000000..462727296
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/styles/FLATBOOTS/template/js/notifications.bak.js"
++@@ -0,0 +1,179 @@
+++/* jshint es3:false, esversion:6 */
+++/* global pushNotifications, phpbb */
+++head.ready(function () {
+++;(function($, window, document) {
+++	// do stuff here and use $, window and document safely
+++	// https://www.phpbb.com/community/viewtopic.php?p=13589106#p13589106
+++
+++	'use strict';
+++
+++	var notificationButtonHTML = "<div class='push-notify'><span class='btn btn-default btn-sm'>" + pushNotifications.language.BROWSER_NOTIFICATIONS + "</span><span class='push-toggle'><span></span></span><span class='push-notify-status'></span></div>";
+++	if (pushNotifications.notificationsPage) {
+++		$('form#ucp table').before(notificationButtonHTML);
+++	}
+++	if (pushNotifications.dropdownIntegration) {
+++		$('.dropdown-menu #notification_list .navbar-footer-content .row')
+++			.after("<div class='text-left'>" + notificationButtonHTML + "</div>");
+++	}
+++
+++	var $pushButton = $('.push-notify'), $pushStatus = $('.push-notify-status');
+++	var isSubscribed = false;
+++	var swRegistration = null;
+++
+++	function urlB64ToUint8Array(base64String) {
+++		var padding = '='.repeat((4 - base64String.length % 4) % 4);
+++		var base64 = (base64String + padding)
+++			.replace(/\-/g, '+')
+++			.replace(/_/g, '/');
+++
+++		var rawData = window.atob(base64);
+++		var outputArray = new Uint8Array(rawData.length);
+++
+++		for (var i = 0; i < rawData.length; ++i) {
+++			outputArray[i] = rawData.charCodeAt(i);
+++		}
+++		return outputArray;
+++	}
+++
+++	function setButtonState(state) {
+++		switch (state) {
+++			case 'enabled':
+++				$pushStatus.text(pushNotifications.language.ACTIONS.ENABLED);
+++				$pushButton.removeClass('push-toggle-locked').addClass('push-toggle-enabled')
+++					.attr('title', pushNotifications.language.DISABLE);
+++				break;
+++			case 'disabled':
+++				$pushStatus.text(pushNotifications.language.ACTIONS.DISABLED);
+++				$pushButton.removeClass('push-toggle-locked push-toggle-enabled')
+++					.attr('title', pushNotifications.language.ENABLE);
+++				break;
+++			case 'disallowed':
+++				$pushStatus.text(pushNotifications.language.ACTIONS.DISALLOWED);
+++				$pushButton.addClass('push-toggle-locked').removeClass('push-toggle-enabled')
+++					.attr('title', pushNotifications.language.DISALLOWED);
+++				break;
+++			case 'unsupported':
+++				$pushStatus.text(pushNotifications.language.ACTIONS.UNSUPPORTED);
+++				$pushButton.addClass('push-toggle-locked').removeClass('push-toggle-enabled')
+++					.attr('title', pushNotifications.language.UNSUPPORTED);
+++				break;
+++		}
+++	}
+++
+++	function updateBtn() {
+++		if (Notification.permission === 'denied') {
+++			setButtonState('disallowed');
+++			return;
+++		}
+++		if (isSubscribed) {
+++			setButtonState('enabled');
+++		} else {
+++			setButtonState('disabled');
+++		}
+++	}
+++
+++	function updateSubscriptionOnServer(subscription, unsubscribe) {
+++		$.ajax({
+++			url: pushNotifications.notificationsPath + (unsubscribe ? 'unsubscribe' : 'subscribe'),
+++			data: JSON.parse(JSON.stringify(subscription)),
+++			method: 'POST',
+++			error: function() {
+++				if (!unsubscribe) { // Unsubscribe in case of an error during subscription.
+++					unsubscribeUser();
+++					phpbb.alert(pushNotifications.language.INFORMATION, pushNotifications.language.UPDATE_FAILED);
+++				}
+++				// Do not show an error for failed unsubscription - it will be handled on the server side.
+++			},
+++			success: function(res) {
+++				if (!res.id && !unsubscribe) { // Unsubscribe in case of an error during subscription.
+++					unsubscribeUser();
+++					phpbb.alert(
+++						pushNotifications.language.INFORMATION,
+++						(res.error) ? res.error : pushNotifications.language.UPDATE_FAILED
+++					);
+++					return;
+++				} else if (unsubscribe) {
+++					return;
+++				}
+++				localStorage.pushSubscription = JSON.stringify({
+++					serverKey: pushNotifications.serverAPIkey,
+++					serverURL: pushNotifications.notificationsPath,
+++					subscriptionID: res.id
+++				});
+++			},
+++			cache: false
+++		});
+++	}
+++
+++	function subscribeUser() {
+++		var applicationServerKey = urlB64ToUint8Array(pushNotifications.serverAPIkey);
+++		swRegistration.pushManager.subscribe({
+++			userVisibleOnly: true,
+++			applicationServerKey: applicationServerKey
+++		}).then(function(subscription) {
+++			updateSubscriptionOnServer(subscription);
+++			isSubscribed = true;
+++			updateBtn();
+++		}).catch(function() {
+++			phpbb.alert(pushNotifications.language.INFORMATION, pushNotifications.language.UPDATE_FAILED);
+++			updateBtn();
+++		});
+++	}
+++
+++	function unsubscribeUser() {
+++		swRegistration.pushManager.getSubscription().then(function(subscription) {
+++			delete localStorage.pushSubscription;
+++			isSubscribed = false;
+++			updateBtn();
+++			if (subscription) {
+++				updateSubscriptionOnServer(subscription, true);
+++				return subscription.unsubscribe();
+++			}
+++		});
+++	}
+++
+++	function subscribe() {
+++		if (isSubscribed) {
+++			unsubscribeUser();
+++		} else {
+++			subscribeUser();
+++		}
+++	}
+++
+++	function showIntroConfirmation() {
+++		var introContent = '<form action="{S_CONFIRM_ACTION}" method="post"><h2 style="text-align: center;">' + pushNotifications.language.INTRO + '</h2><fieldset class="submit-buttons" style="padding-top: 15px; font-size: 1.3em;"><input type="button" name="confirm" value="' + pushNotifications.language.INTRO_YES + '" class="btn btn-default" style="margin-right: 25px;" />&nbsp;<input type="button" name="cancel" value="' + pushNotifications.language.INTRO_NO + '" class="btn btn-default" /></fieldset></form>';
+++		phpbb.confirm(introContent, function(confirm) {
+++			if (confirm) {
+++				$pushButton.first().click();
+++			}
+++		});
+++		localStorage.pushConfirmation = "1";
+++	}
+++
+++	if ('serviceWorker' in navigator && 'PushManager' in window) {
+++		$pushButton.on('click', subscribe);
+++		navigator.serviceWorker.register(pushNotifications.serviceWorkerPath).then(function(swReg) {
+++			swRegistration = swReg;
+++
+++			if (pushNotifications.introConfirmation && !localStorage.pushConfirmation) {
+++				showIntroConfirmation();
+++			}
+++
+++			// Set the initial subscription value
+++			swRegistration.pushManager.getSubscription().then(function(subscription) {
+++				isSubscribed = (subscription !== null);
+++
+++				// It is better to show the real subscription state.
+++				if (!localStorage.pushSubscription && subscription) {
+++					isSubscribed = false;
+++					return subscription.unsubscribe();
+++				}
+++
+++				updateBtn();
+++			});
+++		});
+++	} else {
+++		setButtonState('unsupported');
+++	}
+++})(jQuery, window, document);
+++});
++\ No newline at end of file
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/styles/FLATBOOTS/template/js/notifications.js" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/styles/FLATBOOTS/template/js/notifications.js"
++new file mode 100644
++index 000000000..33c40721a
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/styles/FLATBOOTS/template/js/notifications.js"
++@@ -0,0 +1 @@
+++head.ready(function(){!function(t,i,e){"use strict";var a="<div class='push-notify'><span class='btn btn-default btn-sm'>"+pushNotifications.language.BROWSER_NOTIFICATIONS+"</span><span class='push-toggle'><span></span></span><span class='push-notify-status'></span></div>";pushNotifications.notificationsPage&&t("form#ucp table").before(a),pushNotifications.dropdownIntegration&&t(".dropdown-menu #notification_list .navbar-footer-content .row").after("<div class='text-left'>"+a+"</div>");var n=t(".push-notify"),s=t(".push-notify-status"),o=!1,u=null;function r(t){switch(t){case"enabled":s.text(pushNotifications.language.ACTIONS.ENABLED),n.removeClass("push-toggle-locked").addClass("push-toggle-enabled").attr("title",pushNotifications.language.DISABLE);break;case"disabled":s.text(pushNotifications.language.ACTIONS.DISABLED),n.removeClass("push-toggle-locked push-toggle-enabled").attr("title",pushNotifications.language.ENABLE);break;case"disallowed":s.text(pushNotifications.language.ACTIONS.DISALLOWED),n.addClass("push-toggle-locked").removeClass("push-toggle-enabled").attr("title",pushNotifications.language.DISALLOWED);break;case"unsupported":s.text(pushNotifications.language.ACTIONS.UNSUPPORTED),n.addClass("push-toggle-locked").removeClass("push-toggle-enabled").attr("title",pushNotifications.language.UNSUPPORTED)}}function c(){"denied"!==Notification.permission?r(o?"enabled":"disabled"):r("disallowed")}function l(i,e){t.ajax({url:pushNotifications.notificationsPath+(e?"unsubscribe":"subscribe"),data:JSON.parse(JSON.stringify(i)),method:"POST",error:function(){e||(g(),phpbb.alert(pushNotifications.language.INFORMATION,pushNotifications.language.UPDATE_FAILED))},success:function(t){if(!t.id&&!e)return g(),void phpbb.alert(pushNotifications.language.INFORMATION,t.error?t.error:pushNotifications.language.UPDATE_FAILED);e||(localStorage.pushSubscription=JSON.stringify({serverKey:pushNotifications.serverAPIkey,serverURL:pushNotifications.notificationsPath,subscriptionID:t.id}))},cache:!1})}function p(){var t=function(t){for(var e=(t+"=".repeat((4-t.length%4)%4)).replace(/\-/g,"+").replace(/_/g,"/"),a=i.atob(e),n=new Uint8Array(a.length),s=0;s<a.length;++s)n[s]=a.charCodeAt(s);return n}(pushNotifications.serverAPIkey);u.pushManager.subscribe({userVisibleOnly:!0,applicationServerKey:t}).then(function(t){l(t),o=!0,c()}).catch(function(){phpbb.alert(pushNotifications.language.INFORMATION,pushNotifications.language.UPDATE_FAILED),c()})}function g(){u.pushManager.getSubscription().then(function(t){if(delete localStorage.pushSubscription,o=!1,c(),t)return l(t,!0),t.unsubscribe()})}"serviceWorker"in navigator&&"PushManager"in i?(n.on("click",function(){o?g():p()}),navigator.serviceWorker.register(pushNotifications.serviceWorkerPath).then(function(t){var i;u=t,pushNotifications.introConfirmation&&!localStorage.pushConfirmation&&(i='<form action="{S_CONFIRM_ACTION}" method="post"><h2 style="text-align: center;">'+pushNotifications.language.INTRO+'</h2><fieldset class="submit-buttons" style="padding-top: 15px; font-size: 1.3em;"><input type="button" name="confirm" value="'+pushNotifications.language.INTRO_YES+'" class="btn btn-default" style="margin-right: 25px;" />&nbsp;<input type="button" name="cancel" value="'+pushNotifications.language.INTRO_NO+'" class="btn btn-default" /></fieldset></form>',phpbb.confirm(i,function(t){t&&n.first().click()}),localStorage.pushConfirmation="1"),u.pushManager.getSubscription().then(function(t){if(o=null!==t,!localStorage.pushSubscription&&t)return o=!1,t.unsubscribe();c()})})):r("unsupported")}(jQuery,window,document)});
++\ No newline at end of file
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/styles/FLATBOOTS/template/js/sw.bak.js" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/styles/FLATBOOTS/template/js/sw.bak.js"
++new file mode 100644
++index 000000000..e13827256
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/styles/FLATBOOTS/template/js/sw.bak.js"
++@@ -0,0 +1,105 @@
+++/* jshint browser:true, worker:true, es3:false, esversion:6 */
+++'use strict';
+++head.ready(function () {
+++function urlB64ToUint8Array(base64String) {
+++	var padding = '='.repeat((4 - base64String.length % 4) % 4);
+++	var base64 = (base64String + padding)
+++		.replace(/\-/g, '+')
+++		.replace(/_/g, '/');
+++
+++	var rawData = window.atob(base64);
+++	var outputArray = new Uint8Array(rawData.length);
+++
+++	for (var i = 0; i < rawData.length; ++i) {
+++		outputArray[i] = rawData.charCodeAt(i);
+++	}
+++	return outputArray;
+++}
+++
+++self.addEventListener('install', function(event) {
+++	event.waitUntil(self.skipWaiting());
+++});
+++
+++self.addEventListener('activate', function(event) {
+++	event.waitUntil(self.clients.claim());
+++});
+++
+++self.addEventListener('notificationclick', function(event) {
+++	var notification = event.notification,
+++		data = notification.data;
+++
+++	notification.close();
+++
+++	if (data && data.url) {
+++		event.waitUntil(
+++			// Retrieve a list of the clients of this service worker.
+++			self.clients.matchAll({ type: 'window' }).then(function(clientList) {
+++				// If there is at least one client, focus it.
+++				if (clientList.length > 0) {
+++					clientList[0].navigate(data.url);
+++					return clientList[0].focus();
+++				}
+++
+++				// Otherwise, open a new page.
+++				return self.clients.openWindow(data.url);
+++			})
+++		);
+++	}
+++});
+++
+++self.addEventListener('push', function(event) {
+++	const data = event.data.json();
+++	const title = data.title;
+++	const options = {
+++		body: data.message,
+++		data: {url: data.url},
+++		icon: data.avatar,
+++		badge: data.badge,
+++		vibrate: [300, 100, 400],
+++		timestamp: data.time,
+++		requireInteraction: true
+++	};
+++
+++	event.waitUntil(self.registration.showNotification(title, options));
+++});
+++
+++self.addEventListener('pushsubscriptionchange', function(event) {
+++	if (!localStorage.pushSubscription) {
+++		return;
+++	}
+++	var pushSubscription = JSON.parse(localStorage.pushSubscription);
+++    const applicationServerKey = urlB64ToUint8Array(pushSubscription.serverKey);
+++    event.waitUntil(
+++        self.registration.pushManager.subscribe({
+++            userVisibleOnly: true,
+++            applicationServerKey: applicationServerKey
+++        }).then(function(newSubscription) {
+++	        var subscriptionArray = JSON.parse(JSON.stringify(newSubscription)),
+++		        subscriptionString = 'endpoint=' + subscriptionArray.endpoint + '&keys[p256dh]=' + subscriptionArray.keys.p256dh + '&keys[auth]=' + subscriptionArray.keys.auth + '&subscription_id=' + pushSubscription.subscriptionID;
+++
+++	        var fetchOptions = {
+++		        method: 'post',
+++		        headers: new Headers({
+++			        'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8',
+++			        'X-Requested-With': 'XMLHttpRequest'
+++		        }),
+++		        credentials: 'include',
+++		        body: subscriptionString
+++	        };
+++	        return fetch(pushSubscription.serverURL + 'subscribe', fetchOptions);
+++        }).then(function(response) {
+++	        return response.json();
+++        }).then(function(res) {
+++	        if (!res.id) {
+++		        return;
+++	        }
+++	        localStorage.pushSubscription = JSON.stringify({
+++		        serverKey: pushSubscription.serverKey,
+++		        serverURL: pushSubscription.serverURL,
+++		        subscriptionID: res.id
+++	        });
+++        })
+++    );
+++});
+++
+++});
++\ No newline at end of file
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/styles/FLATBOOTS/template/js/sw.js" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/styles/FLATBOOTS/template/js/sw.js"
++new file mode 100644
++index 000000000..bf724de21
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/styles/FLATBOOTS/template/js/sw.js"
++@@ -0,0 +1 @@
+++"use strict";head.ready(function(){self.addEventListener("install",function(e){e.waitUntil(self.skipWaiting())}),self.addEventListener("activate",function(e){e.waitUntil(self.clients.claim())}),self.addEventListener("notificationclick",function(e){var t=e.notification,n=t.data;t.close(),n&&n.url&&e.waitUntil(self.clients.matchAll({type:"window"}).then(function(e){return e.length>0?(e[0].navigate(n.url),e[0].focus()):self.clients.openWindow(n.url)}))}),self.addEventListener("push",function(e){const t=e.data.json(),n=t.title,i={body:t.message,data:{url:t.url},icon:t.avatar,badge:t.badge,vibrate:[300,100,400],timestamp:t.time,requireInteraction:!0};e.waitUntil(self.registration.showNotification(n,i))}),self.addEventListener("pushsubscriptionchange",function(e){if(!localStorage.pushSubscription)return;var t=JSON.parse(localStorage.pushSubscription);const n=function(e){for(var t=(e+"=".repeat((4-e.length%4)%4)).replace(/\-/g,"+").replace(/_/g,"/"),n=window.atob(t),i=new Uint8Array(n.length),r=0;r<n.length;++r)i[r]=n.charCodeAt(r);return i}(t.serverKey);e.waitUntil(self.registration.pushManager.subscribe({userVisibleOnly:!0,applicationServerKey:n}).then(function(e){var n=JSON.parse(JSON.stringify(e)),i="endpoint="+n.endpoint+"&keys[p256dh]="+n.keys.p256dh+"&keys[auth]="+n.keys.auth+"&subscription_id="+t.subscriptionID,r={method:"post",headers:new Headers({"Content-Type":"application/x-www-form-urlencoded; charset=UTF-8","X-Requested-With":"XMLHttpRequest"}),credentials:"include",body:i};return fetch(t.serverURL+"subscribe",r)}).then(function(e){return e.json()}).then(function(e){e.id&&(localStorage.pushSubscription=JSON.stringify({serverKey:t.serverKey,serverURL:t.serverURL,subscriptionID:e.id}))}))})});
++\ No newline at end of file
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/styles/FLATBOOTS/theme/notifications.bak.css" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/styles/FLATBOOTS/theme/notifications.bak.css"
++new file mode 100644
++index 000000000..1f42af1a3
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/styles/FLATBOOTS/theme/notifications.bak.css"
++@@ -0,0 +1,86 @@
+++.push-notify {
+++	display: inline-block;
+++	padding: 5px 0;
+++	cursor: pointer;
+++}
+++
+++.dropdown-contents .push-notify {
+++	display: block;
+++	text-align: center;
+++}
+++
+++.push-notify .push-toggle {
+++	display: inline-block;
+++	position: relative;
+++	background-color: #c74564;
+++	border: 1px solid #757575;
+++	border-radius: 15px;
+++	width: 45px;
+++	height: 14px;
+++	line-height: 24px;
+++	margin: 5px 7px;
+++	vertical-align: top;
+++	box-shadow: 0 1px 2px #373737 inset;
+++	-webkit-transition: all 0.5s ease;
+++	-moz-transition: all 0.5s ease;
+++	-o-transition: all 0.5s ease;
+++	transition: all 0.5s ease;
+++}
+++
+++.push-notify.push-toggle-enabled .push-toggle {
+++	background-color: #35a035;
+++}
+++
+++.push-notify .push-toggle span {
+++	display: block;
+++	position: absolute;
+++	top: 0;
+++	left: -1px;
+++	border-radius: 200%;
+++	border: 1px solid #757575;
+++	background-color: #fff;
+++	width: 20px;
+++	height: 20px;
+++	margin-top: -4px;
+++	-webkit-transition: all 0.3s ease;
+++	-moz-transition: all 0.3s ease;
+++	-o-transition: all 0.3s ease;
+++	transition: all 0.3s ease;
+++}
+++
+++.push-notify.push-toggle-enabled .push-toggle span {
+++	left: 25px;
+++}
+++
+++.push-notify:hover .push-toggle span {
+++	background-color: #fdfcd3;
+++}
+++
+++.push-notify.push-toggle-locked {
+++	cursor: auto;
+++}
+++
+++.push-notify.push-toggle-locked .push-toggle {
+++	background-color: #a8a8a8;
+++}
+++
+++.push-notify.push-toggle-locked .push-toggle span {
+++	background-color: #e0e0e0;
+++}
+++
+++.push-notify .push-notify-status {
+++	display: inline-block;
+++	font-size: 14px;
+++	font-weight: bold;
+++	line-height: 14px;
+++	padding-top: 6px;
+++	vertical-align: top;
+++}
+++
+++.push-notify > span:first-of-type {
+++	display: inline-block;
+++	font-size: 12px;
+++	line-height: 14px;
+++	padding-top: 5px;
+++	vertical-align: top;
+++}
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/styles/FLATBOOTS/theme/notifications.css" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/styles/FLATBOOTS/theme/notifications.css"
++new file mode 100644
++index 000000000..5e0fd965f
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/styles/FLATBOOTS/theme/notifications.css"
++@@ -0,0 +1 @@
+++.push-notify{display:inline-block;padding:5px 0;cursor:pointer}.dropdown-contents .push-notify{display:block;text-align:center}.push-notify .push-toggle{display:inline-block;position:relative;background-color:#c74564;border:1px solid #757575;border-radius:15px;width:45px;height:14px;line-height:24px;margin:5px 7px;vertical-align:top;box-shadow:0 1px 2px #373737 inset;-webkit-transition:all .5s ease;-moz-transition:all .5s ease;-o-transition:all .5s ease;transition:all .5s ease}.push-notify.push-toggle-enabled .push-toggle{background-color:#35a035}.push-notify .push-toggle span{display:block;position:absolute;top:0;left:-1px;border-radius:200%;border:1px solid #757575;background-color:#fff;width:20px;height:20px;margin-top:-4px;-webkit-transition:all .3s ease;-moz-transition:all .3s ease;-o-transition:all .3s ease;transition:all .3s ease}.push-notify.push-toggle-enabled .push-toggle span{left:25px}.push-notify:hover .push-toggle span{background-color:#fdfcd3}.push-notify.push-toggle-locked{cursor:auto}.push-notify.push-toggle-locked .push-toggle{background-color:#a8a8a8}.push-notify.push-toggle-locked .push-toggle span{background-color:#e0e0e0}.push-notify .push-notify-status{display:inline-block;font-size:14px;font-weight:700;line-height:14px;padding-top:6px;vertical-align:top}.push-notify > span:first-of-type{display:inline-block;font-size:12px;line-height:14px;padding-top:5px;vertical-align:top}
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lavigor\\notifications/styles/all/template/js/sw.js" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/styles/all/template/js/sw.js"
++index e617abc2d..e9e19a367 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lavigor\\notifications/styles/all/template/js/sw.js"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/styles/all/template/js/sw.js"
++@@ -56,7 +56,7 @@ self.addEventListener('push', function(event) {
++ 		icon: data.avatar,
++ 		badge: data.badge,
++ 		vibrate: [300, 100, 400],
++-		timestamp: data.time,
+++		timestamp: data.time * 1000,
++ 		requireInteraction: true
++ 	};
++ 
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\lavigor\\notifications/vendor/guzzleh
\ No newline at end of file
diff --git "[ORIGINAL]/lavigor\\notifications/language/en/notifications.php" "[FORUM_EXT]/lavigor\\notifications/language/en/notifications.php"
--- "[ORIGINAL]/lavigor\\notifications/language/en/notifications.php"
+++ "[FORUM_EXT]/lavigor\\notifications/language/en/notifications.php"
@@ -22,7 +22,7 @@ if (empty($lang) || !is_array($lang))
 
 $lang = array_merge($lang, array(
 	'LAVIGOR_NOTIFICATIONS_NOTIFICATION_METHOD_BROWSER' => 'Browser',
-	'BROWSER_NOTIFICATIONS'                             => 'Browser notifications',
+	'BROWSER_NOTIFICATIONS'                             => 'Browser Notifications',
 	'BROWSER_NOTIFICATIONS_ACTION_ENABLED'              => 'On',
 	'BROWSER_NOTIFICATIONS_ACTION_DISABLED'             => 'Off',
 	'BROWSER_NOTIFICATIONS_ACTION_DISALLOWED'           => 'Disallowed',
@@ -30,7 +30,7 @@ $lang = array_merge($lang, array(
 	'BROWSER_NOTIFICATIONS_ENABLE'                      => 'Enable browser notifications.',
 	'BROWSER_NOTIFICATIONS_DISABLE'                     => 'Disable browser notifications.',
 	'BROWSER_NOTIFICATIONS_DISALLOWED'                  => 'Web Notifications are disallowed in this browser. Allow notifications for this website in browser settings if you want to subscribe.',
-	'BROWSER_NOTIFICATIONS_INTRO'                       => 'Do you want to allow this portal to notify you about replies?',
+	'BROWSER_NOTIFICATIONS_INTRO'                       => 'Do you want to allow GoldTugAnime to notify you?',
 	'BROWSER_NOTIFICATIONS_MAX_LIMIT_REACHED'           => 'The maximum allowed number of browsers with enabled browser notifications (%s per user) has been reached. Please turn off browser notifications for this board in any other browser where you enabled them if you want to enable browser notifications in this browser.',
 	'BROWSER_NOTIFICATIONS_UNSUPPORTED'                 => 'Web Notifications are not supported by this browser.',
 	'BROWSER_NOTIFICATIONS_UPDATE_FAILED'               => 'There was an error (possibly connection error while contacting the server) during the subscription to Web Notifications. They have been disabled in this browser. Please check your Internet connection and try again. Contact the board administrator if the problem persists.',
diff --git "[FORUM_EXT]/lavigor\\notifications/language/pt/info_acp_notifications.php" "[FORUM_EXT]/lavigor\\notifications/language/pt/info_acp_notifications.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/lavigor\\notifications/language/pt/info_acp_notifications.php"
@@ -0,0 +1,26 @@
+<?php
+/**
+ *
+ * @package Push Notifications
+ * @copyright (c) 2017 - 2018 LavIgor
+ * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+ *
+ */
+
+/**
+ * DO NOT CHANGE
+ */
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
+	'LOG_WEB_PUSH_GENERAL_ERROR'	=> '<strong>Web Push error</strong><br />» %s',
+	'LOG_WEB_PUSH_SERVER_ERROR'		=> '<strong>Web Push error</strong> with code <strong>%1$s</strong><br />» %2$s',
+));
diff --git "[FORUM_EXT]/lavigor\\notifications/language/pt/info_ucp_notifications.php" "[FORUM_EXT]/lavigor\\notifications/language/pt/info_ucp_notifications.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/lavigor\\notifications/language/pt/info_ucp_notifications.php"
@@ -0,0 +1,25 @@
+<?php
+/**
+ *
+ * @package Push Notifications
+ * @copyright (c) 2017 - 2018 LavIgor
+ * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+ *
+ */
+
+/**
+ * DO NOT CHANGE
+ */
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
+	'LAVIGOR_NOTIFICATIONS_NOTIFICATION_METHOD_BROWSER' => 'Navegador',
+));
diff --git "[FORUM_EXT]/lavigor\\notifications/language/pt/notifications.php" "[FORUM_EXT]/lavigor\\notifications/language/pt/notifications.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/lavigor\\notifications/language/pt/notifications.php"
@@ -0,0 +1,37 @@
+<?php
+/**
+ *
+ * @package       Push Notifications
+ * @copyright (c) 2017 - 2018 LavIgor
+ * @license       http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+ *
+ */
+
+/**
+ * DO NOT CHANGE
+ */
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
+	'LAVIGOR_NOTIFICATIONS_NOTIFICATION_METHOD_BROWSER' => 'Navegador',
+	'BROWSER_NOTIFICATIONS'                             => 'Notificações de Navegador',
+	'BROWSER_NOTIFICATIONS_ACTION_ENABLED'              => 'Ligado',
+	'BROWSER_NOTIFICATIONS_ACTION_DISABLED'             => 'Desligado',
+	'BROWSER_NOTIFICATIONS_ACTION_DISALLOWED'           => 'Não é permitido',
+	'BROWSER_NOTIFICATIONS_ACTION_UNSUPPORTED'          => 'Não é suportado',
+	'BROWSER_NOTIFICATIONS_ENABLE'                      => 'Ativar notificações de navegador.',
+	'BROWSER_NOTIFICATIONS_DISABLE'                     => 'Desativar notificações de navegador.',
+	'BROWSER_NOTIFICATIONS_DISALLOWED'                  => 'Notificações Web não são permitidas neste navegador. Permita as notificações de navegador para esta página nas configurações do navegador, caso desejes te subscrever.',
+	'BROWSER_NOTIFICATIONS_INTRO'                       => 'Desejas permitir que o GoldTugAnime te envie notificações?',
+	'BROWSER_NOTIFICATIONS_MAX_LIMIT_REACHED'           => 'O número máximo de navegadores permitidos para as notificações de navegador (%s por utilizador) foi atingido. Por favor, desliga as notificações de navegador deste fórum que tenhas ativado em qualquer outro navegador para que possas ativá-lo neste.',
+	'BROWSER_NOTIFICATIONS_UNSUPPORTED'                 => 'Notificações Web não são suportadas pelo teu navegador atual.',
+	'BROWSER_NOTIFICATIONS_UPDATE_FAILED'               => 'Ocorreu um erro (possivelmente erro de conexão ao contactar o servidor) durante a assinatura da Notificação Web. Foi desativada neste navegador. Por favor, verifica a tua conexão de internet e tenta novamente. Entra em contacto com o administrador do fórum se o problema persistir.',
+));
diff --git "[FORUM_EXT]/lavigor\\notifications/language/pt/notifications_acp.php" "[FORUM_EXT]/lavigor\\notifications/language/pt/notifications_acp.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/lavigor\\notifications/language/pt/notifications_acp.php"
@@ -0,0 +1,33 @@
+<?php
+/**
+ *
+ * @package       Push Notifications
+ * @copyright (c) 2017 - 2018 LavIgor
+ * @license       http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+ *
+ */
+
+/**
+ * DO NOT CHANGE
+ */
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
+	'BROWSER_NOTIFICATION_BADGE_URL'            => 'Absolute URL to the badge image for Push Notifications',
+	'BROWSER_NOTIFICATION_DROPDOWN'             => 'Integrate the toggle for browser Push Notifications into the standard dropdown for notifications',
+	'BROWSER_NOTIFICATION_DROPDOWN_EXPLAIN'     => 'The toggle for browser Push Notifications on the notification options management page will be shown regardless of this setting.',
+	'BROWSER_NOTIFICATION_INTRO'                => 'Ask user whether he/she wants to enable Push Notifications when he/she logs in with a new browser',
+	'BROWSER_NOTIFICATION_INTRO_EXPLAIN'        => 'Modal dialog will be shown only once in each browser regardless of login amount with a certain browser.',
+	'BROWSER_NOTIFICATION_MAX_BROWSERS'         => 'Maximum allowed number of browsers with enabled Push Notifications per each user',
+	'BROWSER_NOTIFICATION_MAX_BROWSERS_EXPLAIN' => 'The user will not be able to turn on Push Notification for the board in any browser if the allowed amount of browsers with enabled Push Notifications has been reached. Enter 0 to disable this setting <em>(not recommended)</em>.',
+	'BROWSER_NOTIFICATION_TTL'                  => 'Time To Live for Web Notifications',
+	'BROWSER_NOTIFICATION_TTL_EXPLAIN'          => 'Time To Live (TTL) is how long a push message is retained by the push service (e.g. Mozilla) in case the user browser is not yet accessible (e.g. is not connected). You may want to use a very long time for important notifications. The default TTL is 4 weeks. However, if you send multiple nonessential notifications, set a TTL of 0: the push notification will be delivered only if the user is currently connected. For other cases, you should use a minimum of one day if your users have multiple time zones, and if they don’t, several hours will suffice.',
+));
diff --git "[FORUM_EXT]/lavigor\\notifications/language/pt_preao/info_acp_notifications.php" "[FORUM_EXT]/lavigor\\notifications/language/pt_preao/info_acp_notifications.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/lavigor\\notifications/language/pt_preao/info_acp_notifications.php"
@@ -0,0 +1,26 @@
+<?php
+/**
+ *
+ * @package Push Notifications
+ * @copyright (c) 2017 - 2018 LavIgor
+ * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+ *
+ */
+
+/**
+ * DO NOT CHANGE
+ */
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
+	'LOG_WEB_PUSH_GENERAL_ERROR'	=> '<strong>Web Push error</strong><br />» %s',
+	'LOG_WEB_PUSH_SERVER_ERROR'		=> '<strong>Web Push error</strong> with code <strong>%1$s</strong><br />» %2$s',
+));
diff --git "[FORUM_EXT]/lavigor\\notifications/language/pt_preao/info_ucp_notifications.php" "[FORUM_EXT]/lavigor\\notifications/language/pt_preao/info_ucp_notifications.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/lavigor\\notifications/language/pt_preao/info_ucp_notifications.php"
@@ -0,0 +1,25 @@
+<?php
+/**
+ *
+ * @package Push Notifications
+ * @copyright (c) 2017 - 2018 LavIgor
+ * @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+ *
+ */
+
+/**
+ * DO NOT CHANGE
+ */
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
+	'LAVIGOR_NOTIFICATIONS_NOTIFICATION_METHOD_BROWSER' => 'Navegador',
+));
diff --git "[FORUM_EXT]/lavigor\\notifications/language/pt_preao/notifications.php" "[FORUM_EXT]/lavigor\\notifications/language/pt_preao/notifications.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/lavigor\\notifications/language/pt_preao/notifications.php"
@@ -0,0 +1,37 @@
+<?php
+/**
+ *
+ * @package       Push Notifications
+ * @copyright (c) 2017 - 2018 LavIgor
+ * @license       http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+ *
+ */
+
+/**
+ * DO NOT CHANGE
+ */
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
+	'LAVIGOR_NOTIFICATIONS_NOTIFICATION_METHOD_BROWSER' => 'Navegador',
+	'BROWSER_NOTIFICATIONS'                             => 'Notificações de Navegador',
+	'BROWSER_NOTIFICATIONS_ACTION_ENABLED'              => 'Ligado',
+	'BROWSER_NOTIFICATIONS_ACTION_DISABLED'             => 'Desligado',
+	'BROWSER_NOTIFICATIONS_ACTION_DISALLOWED'           => 'Não é permitido',
+	'BROWSER_NOTIFICATIONS_ACTION_UNSUPPORTED'          => 'Não é suportado',
+	'BROWSER_NOTIFICATIONS_ENABLE'                      => 'Ativar notificações de navegador.',
+	'BROWSER_NOTIFICATIONS_DISABLE'                     => 'Desativar notificações de navegador.',
+	'BROWSER_NOTIFICATIONS_DISALLOWED'                  => 'Notificações Web não são permitidas neste navegador. Permita as notificações de navegador para esta página nas configurações do navegador, caso desejes te subscrever.',
+	'BROWSER_NOTIFICATIONS_INTRO'                       => 'Desejas permitir que o GoldTugAnime te envie notificações?',
+	'BROWSER_NOTIFICATIONS_MAX_LIMIT_REACHED'           => 'O número máximo de navegadores permitidos para as notificações de navegador (%s por utilizador) foi atingido. Por favor, desliga as notificações de navegador deste fórum que tenhas ativado em qualquer outro navegador para que possas ativá-lo neste.',
+	'BROWSER_NOTIFICATIONS_UNSUPPORTED'                 => 'Notificações Web não são suportadas pelo teu navegador atual.',
+	'BROWSER_NOTIFICATIONS_UPDATE_FAILED'               => 'Ocorreu um erro (possivelmente erro de conexão ao contactar o servidor) durante a assinatura da Notificação Web. Foi desativada neste navegador. Por favor, verifica a tua conexão de internet e tenta novamente. Entra em contacto com o administrador do fórum se o problema persistir.',
+));
diff --git "[FORUM_EXT]/lavigor\\notifications/language/pt_preao/notifications_acp.php" "[FORUM_EXT]/lavigor\\notifications/language/pt_preao/notifications_acp.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/lavigor\\notifications/language/pt_preao/notifications_acp.php"
@@ -0,0 +1,33 @@
+<?php
+/**
+ *
+ * @package       Push Notifications
+ * @copyright (c) 2017 - 2018 LavIgor
+ * @license       http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+ *
+ */
+
+/**
+ * DO NOT CHANGE
+ */
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
+	'BROWSER_NOTIFICATION_BADGE_URL'            => 'Absolute URL to the badge image for Push Notifications',
+	'BROWSER_NOTIFICATION_DROPDOWN'             => 'Integrate the toggle for browser Push Notifications into the standard dropdown for notifications',
+	'BROWSER_NOTIFICATION_DROPDOWN_EXPLAIN'     => 'The toggle for browser Push Notifications on the notification options management page will be shown regardless of this setting.',
+	'BROWSER_NOTIFICATION_INTRO'                => 'Ask user whether he/she wants to enable Push Notifications when he/she logs in with a new browser',
+	'BROWSER_NOTIFICATION_INTRO_EXPLAIN'        => 'Modal dialog will be shown only once in each browser regardless of login amount with a certain browser.',
+	'BROWSER_NOTIFICATION_MAX_BROWSERS'         => 'Maximum allowed number of browsers with enabled Push Notifications per each user',
+	'BROWSER_NOTIFICATION_MAX_BROWSERS_EXPLAIN' => 'The user will not be able to turn on Push Notification for the board in any browser if the allowed amount of browsers with enabled Push Notifications has been reached. Enter 0 to disable this setting <em>(not recommended)</em>.',
+	'BROWSER_NOTIFICATION_TTL'                  => 'Time To Live for Web Notifications',
+	'BROWSER_NOTIFICATION_TTL_EXPLAIN'          => 'Time To Live (TTL) is how long a push message is retained by the push service (e.g. Mozilla) in case the user browser is not yet accessible (e.g. is not connected). You may want to use a very long time for important notifications. The default TTL is 4 weeks. However, if you send multiple nonessential notifications, set a TTL of 0: the push notification will be delivered only if the user is currently connected. For other cases, you should use a minimum of one day if your users have multiple time zones, and if they don’t, several hours will suffice.',
+));
diff --git "[FORUM_EXT]/lavigor\\notifications/styles/FLATBOOTS/template/event/overall_header_head_append.html" "[FORUM_EXT]/lavigor\\notifications/styles/FLATBOOTS/template/event/overall_header_head_append.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/lavigor\\notifications/styles/FLATBOOTS/template/event/overall_header_head_append.html"
@@ -0,0 +1,45 @@
+<!-- IF S_REGISTERED_USER and not S_IS_BOT and (S_PUSH_DROPDOWN_INTEGRATION or S_IN_UCP and MODE == 'notification_options') -->
+<script>
+//<![CDATA[
+	var pushNotifications = {
+		dropdownIntegration: '{S_PUSH_DROPDOWN_INTEGRATION}',
+		introConfirmation: '{S_PUSH_INTRO_CONFIRMATION}',
+		language: {
+			ACTIONS: {
+				ENABLED: '{LA_BROWSER_NOTIFICATIONS_ACTION_ENABLED}',
+				DISABLED: '{LA_BROWSER_NOTIFICATIONS_ACTION_DISABLED}',
+				DISALLOWED: '{LA_BROWSER_NOTIFICATIONS_ACTION_DISALLOWED}',
+				UNSUPPORTED: '{LA_BROWSER_NOTIFICATIONS_ACTION_UNSUPPORTED}'
+			},
+			BROWSER_NOTIFICATIONS: '{LA_BROWSER_NOTIFICATIONS}{LA_COLON}',
+			ENABLE: '{LA_BROWSER_NOTIFICATIONS_ENABLE}',
+			DISABLE: '{LA_BROWSER_NOTIFICATIONS_DISABLE}',
+			DISALLOWED: '{LA_BROWSER_NOTIFICATIONS_DISALLOWED}',
+			INFORMATION: '{LA_INFORMATION}',
+			INTRO: '{LA_BROWSER_NOTIFICATIONS_INTRO}',
+			INTRO_NO: '{LA_NO}',
+			INTRO_YES: '{LA_YES}',
+			UNSUPPORTED: '{LA_BROWSER_NOTIFICATIONS_UNSUPPORTED}',
+			UPDATE_FAILED: '{LA_BROWSER_NOTIFICATIONS_UPDATE_FAILED}'
+		},
+		notificationsPath: '{ROOT_PATH}notifications/browser/',
+		notificationsPage: <!-- IF S_IN_UCP and MODE == 'notification_options' -->true<!-- ELSE -->false<!-- ENDIF -->,
+		serviceWorkerPath: '{ROOT_PATH}ext/lavigor/notifications/styles/all/template/js/sw.js',
+		serverAPIkey: '{PUSH_API_PUBLIC_KEY}'
+	};
+//]]>
+</script>
+<!-- INCLUDECSS @lavigor_notifications/notifications.css -->
+<!-- INCLUDEJS @lavigor_notifications/js/notifications.js -->
+<!-- IF S_IN_UCP and MODE == 'notification_options' -->
+<style>
+	.nojs form#ucp table thead:before {
+		content: '{L_BROWSER_NOTIFICATIONS_UNSUPPORTED}';
+		display: block;
+		padding: 10px 0;
+		font-size: 1.2em;
+		font-weight: bold;
+	}
+</style>
+<!-- ENDIF -->
+<!-- ENDIF -->
diff --git "[FORUM_EXT]/lavigor\\notifications/styles/FLATBOOTS/template/js/images/badge.png" "[FORUM_EXT]/lavigor\\notifications/styles/FLATBOOTS/template/js/images/badge.png"
new file mode 100644
Binary files /dev/null and "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/styles/FLATBOOTS/template/js/images/badge.png" differ
diff --git "[FORUM_EXT]/lavigor\\notifications/styles/FLATBOOTS/template/js/images/icon.png" "[FORUM_EXT]/lavigor\\notifications/styles/FLATBOOTS/template/js/images/icon.png"
new file mode 100644
Binary files /dev/null and "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/styles/FLATBOOTS/template/js/images/icon.png" differ
diff --git "[FORUM_EXT]/lavigor\\notifications/styles/FLATBOOTS/template/js/images/no_avatar.gif" "[FORUM_EXT]/lavigor\\notifications/styles/FLATBOOTS/template/js/images/no_avatar.gif"
new file mode 100644
Binary files /dev/null and "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\lavigor\\notifications/styles/FLATBOOTS/template/js/images/no_avatar.gif" differ
diff --git "[FORUM_EXT]/lavigor\\notifications/styles/FLATBOOTS/template/js/notifications.bak.js" "[FORUM_EXT]/lavigor\\notifications/styles/FLATBOOTS/template/js/notifications.bak.js"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/lavigor\\notifications/styles/FLATBOOTS/template/js/notifications.bak.js"
@@ -0,0 +1,179 @@
+/* jshint es3:false, esversion:6 */
+/* global pushNotifications, phpbb */
+head.ready(function () {
+;(function($, window, document) {
+	// do stuff here and use $, window and document safely
+	// https://www.phpbb.com/community/viewtopic.php?p=13589106#p13589106
+
+	'use strict';
+
+	var notificationButtonHTML = "<div class='push-notify'><span class='btn btn-default btn-sm'>" + pushNotifications.language.BROWSER_NOTIFICATIONS + "</span><span class='push-toggle'><span></span></span><span class='push-notify-status'></span></div>";
+	if (pushNotifications.notificationsPage) {
+		$('form#ucp table').before(notificationButtonHTML);
+	}
+	if (pushNotifications.dropdownIntegration) {
+		$('.dropdown-menu #notification_list .navbar-footer-content .row')
+			.after("<div class='text-left'>" + notificationButtonHTML + "</div>");
+	}
+
+	var $pushButton = $('.push-notify'), $pushStatus = $('.push-notify-status');
+	var isSubscribed = false;
+	var swRegistration = null;
+
+	function urlB64ToUint8Array(base64String) {
+		var padding = '='.repeat((4 - base64String.length % 4) % 4);
+		var base64 = (base64String + padding)
+			.replace(/\-/g, '+')
+			.replace(/_/g, '/');
+
+		var rawData = window.atob(base64);
+		var outputArray = new Uint8Array(rawData.length);
+
+		for (var i = 0; i < rawData.length; ++i) {
+			outputArray[i] = rawData.charCodeAt(i);
+		}
+		return outputArray;
+	}
+
+	function setButtonState(state) {
+		switch (state) {
+			case 'enabled':
+				$pushStatus.text(pushNotifications.language.ACTIONS.ENABLED);
+				$pushButton.removeClass('push-toggle-locked').addClass('push-toggle-enabled')
+					.attr('title', pushNotifications.language.DISABLE);
+				break;
+			case 'disabled':
+				$pushStatus.text(pushNotifications.language.ACTIONS.DISABLED);
+				$pushButton.removeClass('push-toggle-locked push-toggle-enabled')
+					.attr('title', pushNotifications.language.ENABLE);
+				break;
+			case 'disallowed':
+				$pushStatus.text(pushNotifications.language.ACTIONS.DISALLOWED);
+				$pushButton.addClass('push-toggle-locked').removeClass('push-toggle-enabled')
+					.attr('title', pushNotifications.language.DISALLOWED);
+				break;
+			case 'unsupported':
+				$pushStatus.text(pushNotifications.language.ACTIONS.UNSUPPORTED);
+				$pushButton.addClass('push-toggle-locked').removeClass('push-toggle-enabled')
+					.attr('title', pushNotifications.language.UNSUPPORTED);
+				break;
+		}
+	}
+
+	function updateBtn() {
+		if (Notification.permission === 'denied') {
+			setButtonState('disallowed');
+			return;
+		}
+		if (isSubscribed) {
+			setButtonState('enabled');
+		} else {
+			setButtonState('disabled');
+		}
+	}
+
+	function updateSubscriptionOnServer(subscription, unsubscribe) {
+		$.ajax({
+			url: pushNotifications.notificationsPath + (unsubscribe ? 'unsubscribe' : 'subscribe'),
+			data: JSON.parse(JSON.stringify(subscription)),
+			method: 'POST',
+			error: function() {
+				if (!unsubscribe) { // Unsubscribe in case of an error during subscription.
+					unsubscribeUser();
+					phpbb.alert(pushNotifications.language.INFORMATION, pushNotifications.language.UPDATE_FAILED);
+				}
+				// Do not show an error for failed unsubscription - it will be handled on the server side.
+			},
+			success: function(res) {
+				if (!res.id && !unsubscribe) { // Unsubscribe in case of an error during subscription.
+					unsubscribeUser();
+					phpbb.alert(
+						pushNotifications.language.INFORMATION,
+						(res.error) ? res.error : pushNotifications.language.UPDATE_FAILED
+					);
+					return;
+				} else if (unsubscribe) {
+					return;
+				}
+				localStorage.pushSubscription = JSON.stringify({
+					serverKey: pushNotifications.serverAPIkey,
+					serverURL: pushNotifications.notificationsPath,
+					subscriptionID: res.id
+				});
+			},
+			cache: false
+		});
+	}
+
+	function subscribeUser() {
+		var applicationServerKey = urlB64ToUint8Array(pushNotifications.serverAPIkey);
+		swRegistration.pushManager.subscribe({
+			userVisibleOnly: true,
+			applicationServerKey: applicationServerKey
+		}).then(function(subscription) {
+			updateSubscriptionOnServer(subscription);
+			isSubscribed = true;
+			updateBtn();
+		}).catch(function() {
+			phpbb.alert(pushNotifications.language.INFORMATION, pushNotifications.language.UPDATE_FAILED);
+			updateBtn();
+		});
+	}
+
+	function unsubscribeUser() {
+		swRegistration.pushManager.getSubscription().then(function(subscription) {
+			delete localStorage.pushSubscription;
+			isSubscribed = false;
+			updateBtn();
+			if (subscription) {
+				updateSubscriptionOnServer(subscription, true);
+				return subscription.unsubscribe();
+			}
+		});
+	}
+
+	function subscribe() {
+		if (isSubscribed) {
+			unsubscribeUser();
+		} else {
+			subscribeUser();
+		}
+	}
+
+	function showIntroConfirmation() {
+		var introContent = '<form action="{S_CONFIRM_ACTION}" method="post"><h2 style="text-align: center;">' + pushNotifications.language.INTRO + '</h2><fieldset class="submit-buttons" style="padding-top: 15px; font-size: 1.3em;"><input type="button" name="confirm" value="' + pushNotifications.language.INTRO_YES + '" class="btn btn-default" style="margin-right: 25px;" />&nbsp;<input type="button" name="cancel" value="' + pushNotifications.language.INTRO_NO + '" class="btn btn-default" /></fieldset></form>';
+		phpbb.confirm(introContent, function(confirm) {
+			if (confirm) {
+				$pushButton.first().click();
+			}
+		});
+		localStorage.pushConfirmation = "1";
+	}
+
+	if ('serviceWorker' in navigator && 'PushManager' in window) {
+		$pushButton.on('click', subscribe);
+		navigator.serviceWorker.register(pushNotifications.serviceWorkerPath).then(function(swReg) {
+			swRegistration = swReg;
+
+			if (pushNotifications.introConfirmation && !localStorage.pushConfirmation) {
+				showIntroConfirmation();
+			}
+
+			// Set the initial subscription value
+			swRegistration.pushManager.getSubscription().then(function(subscription) {
+				isSubscribed = (subscription !== null);
+
+				// It is better to show the real subscription state.
+				if (!localStorage.pushSubscription && subscription) {
+					isSubscribed = false;
+					return subscription.unsubscribe();
+				}
+
+				updateBtn();
+			});
+		});
+	} else {
+		setButtonState('unsupported');
+	}
+})(jQuery, window, document);
+});
\ No newline at end of file
diff --git "[FORUM_EXT]/lavigor\\notifications/styles/FLATBOOTS/template/js/notifications.js" "[FORUM_EXT]/lavigor\\notifications/styles/FLATBOOTS/template/js/notifications.js"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/lavigor\\notifications/styles/FLATBOOTS/template/js/notifications.js"
@@ -0,0 +1 @@
+head.ready(function(){!function(t,i,e){"use strict";var a="<div class='push-notify'><span class='btn btn-default btn-sm'>"+pushNotifications.language.BROWSER_NOTIFICATIONS+"</span><span class='push-toggle'><span></span></span><span class='push-notify-status'></span></div>";pushNotifications.notificationsPage&&t("form#ucp table").before(a),pushNotifications.dropdownIntegration&&t(".dropdown-menu #notification_list .navbar-footer-content .row").after("<div class='text-left'>"+a+"</div>");var n=t(".push-notify"),s=t(".push-notify-status"),o=!1,u=null;function r(t){switch(t){case"enabled":s.text(pushNotifications.language.ACTIONS.ENABLED),n.removeClass("push-toggle-locked").addClass("push-toggle-enabled").attr("title",pushNotifications.language.DISABLE);break;case"disabled":s.text(pushNotifications.language.ACTIONS.DISABLED),n.removeClass("push-toggle-locked push-toggle-enabled").attr("title",pushNotifications.language.ENABLE);break;case"disallowed":s.text(pushNotifications.language.ACTIONS.DISALLOWED),n.addClass("push-toggle-locked").removeClass("push-toggle-enabled").attr("title",pushNotifications.language.DISALLOWED);break;case"unsupported":s.text(pushNotifications.language.ACTIONS.UNSUPPORTED),n.addClass("push-toggle-locked").removeClass("push-toggle-enabled").attr("title",pushNotifications.language.UNSUPPORTED)}}function c(){"denied"!==Notification.permission?r(o?"enabled":"disabled"):r("disallowed")}function l(i,e){t.ajax({url:pushNotifications.notificationsPath+(e?"unsubscribe":"subscribe"),data:JSON.parse(JSON.stringify(i)),method:"POST",error:function(){e||(g(),phpbb.alert(pushNotifications.language.INFORMATION,pushNotifications.language.UPDATE_FAILED))},success:function(t){if(!t.id&&!e)return g(),void phpbb.alert(pushNotifications.language.INFORMATION,t.error?t.error:pushNotifications.language.UPDATE_FAILED);e||(localStorage.pushSubscription=JSON.stringify({serverKey:pushNotifications.serverAPIkey,serverURL:pushNotifications.notificationsPath,subscriptionID:t.id}))},cache:!1})}function p(){var t=function(t){for(var e=(t+"=".repeat((4-t.length%4)%4)).replace(/\-/g,"+").replace(/_/g,"/"),a=i.atob(e),n=new Uint8Array(a.length),s=0;s<a.length;++s)n[s]=a.charCodeAt(s);return n}(pushNotifications.serverAPIkey);u.pushManager.subscribe({userVisibleOnly:!0,applicationServerKey:t}).then(function(t){l(t),o=!0,c()}).catch(function(){phpbb.alert(pushNotifications.language.INFORMATION,pushNotifications.language.UPDATE_FAILED),c()})}function g(){u.pushManager.getSubscription().then(function(t){if(delete localStorage.pushSubscription,o=!1,c(),t)return l(t,!0),t.unsubscribe()})}"serviceWorker"in navigator&&"PushManager"in i?(n.on("click",function(){o?g():p()}),navigator.serviceWorker.register(pushNotifications.serviceWorkerPath).then(function(t){var i;u=t,pushNotifications.introConfirmation&&!localStorage.pushConfirmation&&(i='<form action="{S_CONFIRM_ACTION}" method="post"><h2 style="text-align: center;">'+pushNotifications.language.INTRO+'</h2><fieldset class="submit-buttons" style="padding-top: 15px; font-size: 1.3em;"><input type="button" name="confirm" value="'+pushNotifications.language.INTRO_YES+'" class="btn btn-default" style="margin-right: 25px;" />&nbsp;<input type="button" name="cancel" value="'+pushNotifications.language.INTRO_NO+'" class="btn btn-default" /></fieldset></form>',phpbb.confirm(i,function(t){t&&n.first().click()}),localStorage.pushConfirmation="1"),u.pushManager.getSubscription().then(function(t){if(o=null!==t,!localStorage.pushSubscription&&t)return o=!1,t.unsubscribe();c()})})):r("unsupported")}(jQuery,window,document)});
\ No newline at end of file
diff --git "[FORUM_EXT]/lavigor\\notifications/styles/FLATBOOTS/template/js/sw.bak.js" "[FORUM_EXT]/lavigor\\notifications/styles/FLATBOOTS/template/js/sw.bak.js"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/lavigor\\notifications/styles/FLATBOOTS/template/js/sw.bak.js"
@@ -0,0 +1,105 @@
+/* jshint browser:true, worker:true, es3:false, esversion:6 */
+'use strict';
+head.ready(function () {
+function urlB64ToUint8Array(base64String) {
+	var padding = '='.repeat((4 - base64String.length % 4) % 4);
+	var base64 = (base64String + padding)
+		.replace(/\-/g, '+')
+		.replace(/_/g, '/');
+
+	var rawData = window.atob(base64);
+	var outputArray = new Uint8Array(rawData.length);
+
+	for (var i = 0; i < rawData.length; ++i) {
+		outputArray[i] = rawData.charCodeAt(i);
+	}
+	return outputArray;
+}
+
+self.addEventListener('install', function(event) {
+	event.waitUntil(self.skipWaiting());
+});
+
+self.addEventListener('activate', function(event) {
+	event.waitUntil(self.clients.claim());
+});
+
+self.addEventListener('notificationclick', function(event) {
+	var notification = event.notification,
+		data = notification.data;
+
+	notification.close();
+
+	if (data && data.url) {
+		event.waitUntil(
+			// Retrieve a list of the clients of this service worker.
+			self.clients.matchAll({ type: 'window' }).then(function(clientList) {
+				// If there is at least one client, focus it.
+				if (clientList.length > 0) {
+					clientList[0].navigate(data.url);
+					return clientList[0].focus();
+				}
+
+				// Otherwise, open a new page.
+				return self.clients.openWindow(data.url);
+			})
+		);
+	}
+});
+
+self.addEventListener('push', function(event) {
+	const data = event.data.json();
+	const title = data.title;
+	const options = {
+		body: data.message,
+		data: {url: data.url},
+		icon: data.avatar,
+		badge: data.badge,
+		vibrate: [300, 100, 400],
+		timestamp: data.time,
+		requireInteraction: true
+	};
+
+	event.waitUntil(self.registration.showNotification(title, options));
+});
+
+self.addEventListener('pushsubscriptionchange', function(event) {
+	if (!localStorage.pushSubscription) {
+		return;
+	}
+	var pushSubscription = JSON.parse(localStorage.pushSubscription);
+    const applicationServerKey = urlB64ToUint8Array(pushSubscription.serverKey);
+    event.waitUntil(
+        self.registration.pushManager.subscribe({
+            userVisibleOnly: true,
+            applicationServerKey: applicationServerKey
+        }).then(function(newSubscription) {
+	        var subscriptionArray = JSON.parse(JSON.stringify(newSubscription)),
+		        subscriptionString = 'endpoint=' + subscriptionArray.endpoint + '&keys[p256dh]=' + subscriptionArray.keys.p256dh + '&keys[auth]=' + subscriptionArray.keys.auth + '&subscription_id=' + pushSubscription.subscriptionID;
+
+	        var fetchOptions = {
+		        method: 'post',
+		        headers: new Headers({
+			        'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8',
+			        'X-Requested-With': 'XMLHttpRequest'
+		        }),
+		        credentials: 'include',
+		        body: subscriptionString
+	        };
+	        return fetch(pushSubscription.serverURL + 'subscribe', fetchOptions);
+        }).then(function(response) {
+	        return response.json();
+        }).then(function(res) {
+	        if (!res.id) {
+		        return;
+	        }
+	        localStorage.pushSubscription = JSON.stringify({
+		        serverKey: pushSubscription.serverKey,
+		        serverURL: pushSubscription.serverURL,
+		        subscriptionID: res.id
+	        });
+        })
+    );
+});
+
+});
\ No newline at end of file
diff --git "[FORUM_EXT]/lavigor\\notifications/styles/FLATBOOTS/template/js/sw.js" "[FORUM_EXT]/lavigor\\notifications/styles/FLATBOOTS/template/js/sw.js"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/lavigor\\notifications/styles/FLATBOOTS/template/js/sw.js"
@@ -0,0 +1 @@
+"use strict";head.ready(function(){self.addEventListener("install",function(e){e.waitUntil(self.skipWaiting())}),self.addEventListener("activate",function(e){e.waitUntil(self.clients.claim())}),self.addEventListener("notificationclick",function(e){var t=e.notification,n=t.data;t.close(),n&&n.url&&e.waitUntil(self.clients.matchAll({type:"window"}).then(function(e){return e.length>0?(e[0].navigate(n.url),e[0].focus()):self.clients.openWindow(n.url)}))}),self.addEventListener("push",function(e){const t=e.data.json(),n=t.title,i={body:t.message,data:{url:t.url},icon:t.avatar,badge:t.badge,vibrate:[300,100,400],timestamp:t.time,requireInteraction:!0};e.waitUntil(self.registration.showNotification(n,i))}),self.addEventListener("pushsubscriptionchange",function(e){if(!localStorage.pushSubscription)return;var t=JSON.parse(localStorage.pushSubscription);const n=function(e){for(var t=(e+"=".repeat((4-e.length%4)%4)).replace(/\-/g,"+").replace(/_/g,"/"),n=window.atob(t),i=new Uint8Array(n.length),r=0;r<n.length;++r)i[r]=n.charCodeAt(r);return i}(t.serverKey);e.waitUntil(self.registration.pushManager.subscribe({userVisibleOnly:!0,applicationServerKey:n}).then(function(e){var n=JSON.parse(JSON.stringify(e)),i="endpoint="+n.endpoint+"&keys[p256dh]="+n.keys.p256dh+"&keys[auth]="+n.keys.auth+"&subscription_id="+t.subscriptionID,r={method:"post",headers:new Headers({"Content-Type":"application/x-www-form-urlencoded; charset=UTF-8","X-Requested-With":"XMLHttpRequest"}),credentials:"include",body:i};return fetch(t.serverURL+"subscribe",r)}).then(function(e){return e.json()}).then(function(e){e.id&&(localStorage.pushSubscription=JSON.stringify({serverKey:t.serverKey,serverURL:t.serverURL,subscriptionID:e.id}))}))})});
\ No newline at end of file
diff --git "[FORUM_EXT]/lavigor\\notifications/styles/FLATBOOTS/theme/notifications.bak.css" "[FORUM_EXT]/lavigor\\notifications/styles/FLATBOOTS/theme/notifications.bak.css"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/lavigor\\notifications/styles/FLATBOOTS/theme/notifications.bak.css"
@@ -0,0 +1,86 @@
+.push-notify {
+	display: inline-block;
+	padding: 5px 0;
+	cursor: pointer;
+}
+
+.dropdown-contents .push-notify {
+	display: block;
+	text-align: center;
+}
+
+.push-notify .push-toggle {
+	display: inline-block;
+	position: relative;
+	background-color: #c74564;
+	border: 1px solid #757575;
+	border-radius: 15px;
+	width: 45px;
+	height: 14px;
+	line-height: 24px;
+	margin: 5px 7px;
+	vertical-align: top;
+	box-shadow: 0 1px 2px #373737 inset;
+	-webkit-transition: all 0.5s ease;
+	-moz-transition: all 0.5s ease;
+	-o-transition: all 0.5s ease;
+	transition: all 0.5s ease;
+}
+
+.push-notify.push-toggle-enabled .push-toggle {
+	background-color: #35a035;
+}
+
+.push-notify .push-toggle span {
+	display: block;
+	position: absolute;
+	top: 0;
+	left: -1px;
+	border-radius: 200%;
+	border: 1px solid #757575;
+	background-color: #fff;
+	width: 20px;
+	height: 20px;
+	margin-top: -4px;
+	-webkit-transition: all 0.3s ease;
+	-moz-transition: all 0.3s ease;
+	-o-transition: all 0.3s ease;
+	transition: all 0.3s ease;
+}
+
+.push-notify.push-toggle-enabled .push-toggle span {
+	left: 25px;
+}
+
+.push-notify:hover .push-toggle span {
+	background-color: #fdfcd3;
+}
+
+.push-notify.push-toggle-locked {
+	cursor: auto;
+}
+
+.push-notify.push-toggle-locked .push-toggle {
+	background-color: #a8a8a8;
+}
+
+.push-notify.push-toggle-locked .push-toggle span {
+	background-color: #e0e0e0;
+}
+
+.push-notify .push-notify-status {
+	display: inline-block;
+	font-size: 14px;
+	font-weight: bold;
+	line-height: 14px;
+	padding-top: 6px;
+	vertical-align: top;
+}
+
+.push-notify > span:first-of-type {
+	display: inline-block;
+	font-size: 12px;
+	line-height: 14px;
+	padding-top: 5px;
+	vertical-align: top;
+}
diff --git "[FORUM_EXT]/lavigor\\notifications/styles/FLATBOOTS/theme/notifications.css" "[FORUM_EXT]/lavigor\\notifications/styles/FLATBOOTS/theme/notifications.css"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/lavigor\\notifications/styles/FLATBOOTS/theme/notifications.css"
@@ -0,0 +1 @@
+.push-notify{display:inline-block;padding:5px 0;cursor:pointer}.dropdown-contents .push-notify{display:block;text-align:center}.push-notify .push-toggle{display:inline-block;position:relative;background-color:#c74564;border:1px solid #757575;border-radius:15px;width:45px;height:14px;line-height:24px;margin:5px 7px;vertical-align:top;box-shadow:0 1px 2px #373737 inset;-webkit-transition:all .5s ease;-moz-transition:all .5s ease;-o-transition:all .5s ease;transition:all .5s ease}.push-notify.push-toggle-enabled .push-toggle{background-color:#35a035}.push-notify .push-toggle span{display:block;position:absolute;top:0;left:-1px;border-radius:200%;border:1px solid #757575;background-color:#fff;width:20px;height:20px;margin-top:-4px;-webkit-transition:all .3s ease;-moz-transition:all .3s ease;-o-transition:all .3s ease;transition:all .3s ease}.push-notify.push-toggle-enabled .push-toggle span{left:25px}.push-notify:hover .push-toggle span{background-color:#fdfcd3}.push-notify.push-toggle-locked{cursor:auto}.push-notify.push-toggle-locked .push-toggle{background-color:#a8a8a8}.push-notify.push-toggle-locked .push-toggle span{background-color:#e0e0e0}.push-notify .push-notify-status{display:inline-block;font-size:14px;font-weight:700;line-height:14px;padding-top:6px;vertical-align:top}.push-notify > span:first-of-type{display:inline-block;font-size:12px;line-height:14px;padding-top:5px;vertical-align:top}
\ No newline at end of file
diff --git "[ORIGINAL]/lavigor\\notifications/styles/all/template/js/sw.js" "[FORUM_EXT]/lavigor\\notifications/styles/all/template/js/sw.js"
--- "[ORIGINAL]/lavigor\\notifications/styles/all/template/js/sw.js"
+++ "[FORUM_EXT]/lavigor\\notifications/styles/all/template/js/sw.js"
@@ -56,7 +56,7 @@ self.addEventListener('push', function(event) {
 		icon: data.avatar,
 		badge: data.badge,
 		vibrate: [300, 100, 400],
-		timestamp: data.time,
+		timestamp: data.time * 1000,
 		requireInteraction: true
 	};
 
diff --git "[ORIGINAL]/lavigor\\notifications/vendor/guzzlehttp/promises/src/Promise.php" "[FORUM_EXT]/lavigor\\notifications/vendor/guzzlehttp/promises/src/Promise.php"
--- "[ORIGINAL]/lavigor\\notifications/vendor/guzzlehttp/promises/src/Promise.php"
+++ "[FORUM_EXT]/lavigor\\notifications/vendor/guzzlehttp/promises/src/Promise.php"
@@ -148,7 +148,7 @@ class Promise implements PromiseInterface
 
         // If the value was not a settled promise or a thenable, then resolve
         // it in the task queue using the correct ID.
-        if (!method_exists($value, 'then')) {
+        if (!is_object($value) || !method_exists($value, 'then')) {
             $id = $state === self::FULFILLED ? 1 : 2;
             // It's a success, so resolve the handlers in the queue.
             queue()->add(static function () use ($id, $value, $handlers) {
```
