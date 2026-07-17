Existem diferencas reais no codigo ou texto. Diferencas de formatacao (espacos, tabs) foram ignoradas abaixo.

```diff
diff --git "[ORIGINAL]/leinad4mind\\invitation/controller/acp.php" "[FORUM_EXT]/leinad4mind\\invitation/controller/acp.php"
--- "[ORIGINAL]/leinad4mind\\invitation/controller/acp.php"
+++ "[FORUM_EXT]/leinad4mind\\invitation/controller/acp.php"
@@ -860,7 +860,8 @@ class acp extends controller_base
 							trigger_error($this->language->lang('ACP_INVITE_NO_SELECT_INVITE') . adm_back_link($u_action), E_USER_WARNING);
 						}
 
-						$confirm_lang = $action == 'del_all' ? $this->language->lang('ACP_INVITE_DELETE_ALL_PEND_CONFIRM') : count($marked) == 1 ? $this->language->lang('ACP_INVITE_DELETE_PEND_CONFIRM') : $this->language->lang('ACP_INVITE_DELETES_PEND_CONFIRM');
+						$confirm_lang = $action == 'del_all' ? $this->language->lang('ACP_INVITE_DELETE_ALL_PEND_CONFIRM') : (count($marked) == 1 ? $this->language->lang('ACP_INVITE_DELETE_PEND_CONFIRM') : $this->language->lang('ACP_INVITE_DELETES_PEND_CONFIRM'));
+
 
 						confirm_box(false, $confirm_lang, build_hidden_fields(array(
 							'i'			=> $id,
diff --git "[ORIGINAL]/leinad4mind\\invitation/controller/mcp.php" "[FORUM_EXT]/leinad4mind\\invitation/controller/mcp.php"
--- "[ORIGINAL]/leinad4mind\\invitation/controller/mcp.php"
+++ "[FORUM_EXT]/leinad4mind\\invitation/controller/mcp.php"
@@ -93,7 +93,8 @@ class mcp extends controller_base
 			trigger_error($this->language->lang('MCP_INVITE_DISABLED', '<a href="' . append_sid("{$this->root_path}mcp.$this->php_ext") . '">', '</a>'));
 		}
 
-		$action		= $this->request->is_set_post('allocate') ? 'allocate' : $this->request->is_set_post('deny') ? 'deny' : $this->request->variable('action', '');
+		$action 	= $this->request->is_set_post('allocate') ? 'allocate' : ($this->request->is_set_post('deny') ? 'deny' : $this->request->variable('action', ''));
+
 		$marked		= $this->request->variable('mark'	, array(0));
 		$start		= $this->request->variable('start'	, 0);
 		$sort_days	= $this->request->variable('st'	, 0);
diff --git "[ORIGINAL]/leinad4mind\\invitation/controller/ucp.php" "[FORUM_EXT]/leinad4mind\\invitation/controller/ucp.php"
--- "[ORIGINAL]/leinad4mind\\invitation/controller/ucp.php"
+++ "[FORUM_EXT]/leinad4mind\\invitation/controller/ucp.php"
@@ -401,8 +401,8 @@ class ucp extends controller_base
 					'S_HIDDEN_FIELDS'		=> build_hidden_fields($s_hidden_fields),
 					'MORE_RECIPIENTS'		=> $this->ext_config['invite_email_db'] > 1 ? $this->language->lang('UCP_INVITE_DB', $this->ext_config['invite_email_db']) : false,
 					'EMAIL_CIM'				=> $email,
-					'EMAIL_TEMA'			=> $lang ? $lang->lang('UCP_INVITE') : $this->language->lang('UCP_INVITE'),
-					'EMAIL_MESSAGE'			=> $message,
+					'EMAIL_TEMA'			=> $lang ? $lang->lang('UCP_INVITE_LABEL') : $this->language->lang('UCP_INVITE_LABEL'),
+					'EMAIL_MESSAGE' => $lang ? $message : $this->language->lang('UCP_INVITE_MESSAGE'),
 				));
 
 				unset($lang_row);
diff --git "[FORUM_EXT]/leinad4mind\\invitation/diff_full.tmp" "[FORUM_EXT]/leinad4mind\\invitation/diff_full.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/leinad4mind\\invitation/diff_full.tmp"
@@ -0,0 +1,2140 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/controller/acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/controller/acp.php"
+index 40f3b8fd8..74e01899b 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/controller/acp.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/controller/acp.php"
+@@ -860,7 +860,8 @@ class acp extends controller_base
+ 							trigger_error($this->language->lang('ACP_INVITE_NO_SELECT_INVITE') . adm_back_link($u_action), E_USER_WARNING);
+ 						}
+ 
+-						$confirm_lang = $action == 'del_all' ? $this->language->lang('ACP_INVITE_DELETE_ALL_PEND_CONFIRM') : count($marked) == 1 ? $this->language->lang('ACP_INVITE_DELETE_PEND_CONFIRM') : $this->language->lang('ACP_INVITE_DELETES_PEND_CONFIRM');
++						$confirm_lang = $action == 'del_all' ? $this->language->lang('ACP_INVITE_DELETE_ALL_PEND_CONFIRM') : (count($marked) == 1 ? $this->language->lang('ACP_INVITE_DELETE_PEND_CONFIRM') : $this->language->lang('ACP_INVITE_DELETES_PEND_CONFIRM'));
++
+ 
+ 						confirm_box(false, $confirm_lang, build_hidden_fields(array(
+ 							'i'			=> $id,
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/controller/mcp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/controller/mcp.php"
+index fa90fa653..7e1018a71 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/controller/mcp.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/controller/mcp.php"
+@@ -93,7 +93,8 @@ class mcp extends controller_base
+ 			trigger_error($this->language->lang('MCP_INVITE_DISABLED', '<a href="' . append_sid("{$this->root_path}mcp.$this->php_ext") . '">', '</a>'));
+ 		}
+ 
+-		$action		= $this->request->is_set_post('allocate') ? 'allocate' : $this->request->is_set_post('deny') ? 'deny' : $this->request->variable('action', '');
++		$action 	= $this->request->is_set_post('allocate') ? 'allocate' : ($this->request->is_set_post('deny') ? 'deny' : $this->request->variable('action', ''));
++
+ 		$marked		= $this->request->variable('mark'	, array(0));
+ 		$start		= $this->request->variable('start'	, 0);
+ 		$sort_days	= $this->request->variable('st'	, 0);
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/controller/ucp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/controller/ucp.php"
+index 394fba05d..2824ecebc 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/controller/ucp.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/controller/ucp.php"
+@@ -401,8 +401,8 @@ class ucp extends controller_base
+ 					'S_HIDDEN_FIELDS'		=> build_hidden_fields($s_hidden_fields),
+ 					'MORE_RECIPIENTS'		=> $this->ext_config['invite_email_db'] > 1 ? $this->language->lang('UCP_INVITE_DB', $this->ext_config['invite_email_db']) : false,
+ 					'EMAIL_CIM'				=> $email,
+-					'EMAIL_TEMA'			=> $lang ? $lang->lang('UCP_INVITE') : $this->language->lang('UCP_INVITE'),
+-					'EMAIL_MESSAGE'			=> $message,
++					'EMAIL_TEMA'			=> $lang ? $lang->lang('UCP_INVITE_LABEL') : $this->language->lang('UCP_INVITE_LABEL'),
++					'EMAIL_MESSAGE' => $lang ? $message : $this->language->lang('UCP_INVITE_MESSAGE'),
+ 				));
+ 
+ 				unset($lang_row);
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/diff_full.tmp"
+new file mode 100644
+index 000000000..e69de29bb
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/includes/functions.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/includes/functions.php"
+index 6d6fc0bca..9ac5f0fa8 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/includes/functions.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/includes/functions.php"
+@@ -435,7 +435,7 @@ class functions
+ 		$row2 = $this->db->sql_fetchrow($result);
+ 		$this->db->sql_freeresult($result);
+ 
+-		if ($row['user_id'])
++		if ($row !== false && $row['user_id'])
+ 		{
+ 			$this->template->assign_vars(array(
+ 				'INVITE_USER_NAME'	=> '<strong>' . get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']) . '</strong>',
+@@ -443,7 +443,7 @@ class functions
+ 		}
+ 		
+ 		
+-		if ($row2['user_id'])
++		if ($row2 !== false && $row2['user_id'])
+ 		{
+ 			$this->template->assign_vars(array(
+ 				'L_INVITE_MEMBER'	=> $this->language->lang('INVITE') . (($this->ext_config['invite_db'] || $this->auth->acl_get('u_invite_max')) ? '' : ' (' . $row2['user_invite'] . ')'),
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/language/de/permissions_invite.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/de/permissions_invite.php"
+index ba6f116a5..1cdd87b47 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/language/de/permissions_invite.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/de/permissions_invite.php"
+@@ -38,14 +38,14 @@ $lang = array_merge($lang, array(
+ 	'ACL_A_INVITE'			=> 'Benutzer kann Daten synchronisieren',
+ 	'ACL_A_INVITE_CONFIG'	=> 'Benutzer kann Einladungen konfigurieren.',
+ 	'ACL_A_INVITE_DELETE'	=> 'Benutzer kann Einladungen löschen',
+-	'ACL_A_INVITE_SIZE'		=> 'Benutzer kann Einladungen verwalten',
++	'ACL_A_INVITE_CLAIMING'		=> 'Benutzer kann Einladungen verwalten',
+ 	'ACL_A_INVITE_SEND'		=> 'Benutzer kann Einladungen Mitgliedern zuweisen',
+ 	'ACL_A_INVITE_PEND'		=> 'Benutzer kann ausstehende Einladungen verwalten',
+ 	'ACL_A_INVITE_USERS'	=> 'Benutzer kann eine Liste eingeladener Mitglieder einsehen',
+-	'ACL_M_INVITE_SIZE'		=> 'Benutzer kann Einladungsanfrage akzeptieren.',
++	'ACL_M_INVITE_CLAIMING'		=> 'Benutzer kann Einladungsanfrage akzeptieren.',
+ 	'ACL_U_INVITE_DELETE'	=> 'Benutzer kann Einladung zurückziehen<br /><em>Benutzer kann eine Einladung, die er vergeben hat, abbrechen.</em>',
+ 	'ACL_U_INVITE_REQUEST'	=> 'Benutzer kann Einladung anfordern',
+-	'ACL_U_INVITE_SEND'		=> 'Benutzer kann neue Mitglieder zur Seite einladen',
++	'ACL_U_INVITE_SENDING'		=> 'Benutzer kann neue Mitglieder zur Seite einladen',
+ 	'ACL_U_INVITE_MAX'		=> 'Benutzer hat unbegrenzte Einladungen',
+ 	'ACL_U_INVITE_USERS'	=> 'Benutzer kann eine Liste der von anderen Benutzern eingeladenen Mitglieder einsehen.',
+ ));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/language/de_x_sie/permissions_invite.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/de_x_sie/permissions_invite.php"
+index ba6f116a5..1cdd87b47 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/language/de_x_sie/permissions_invite.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/de_x_sie/permissions_invite.php"
+@@ -38,14 +38,14 @@ $lang = array_merge($lang, array(
+ 	'ACL_A_INVITE'			=> 'Benutzer kann Daten synchronisieren',
+ 	'ACL_A_INVITE_CONFIG'	=> 'Benutzer kann Einladungen konfigurieren.',
+ 	'ACL_A_INVITE_DELETE'	=> 'Benutzer kann Einladungen löschen',
+-	'ACL_A_INVITE_SIZE'		=> 'Benutzer kann Einladungen verwalten',
++	'ACL_A_INVITE_CLAIMING'		=> 'Benutzer kann Einladungen verwalten',
+ 	'ACL_A_INVITE_SEND'		=> 'Benutzer kann Einladungen Mitgliedern zuweisen',
+ 	'ACL_A_INVITE_PEND'		=> 'Benutzer kann ausstehende Einladungen verwalten',
+ 	'ACL_A_INVITE_USERS'	=> 'Benutzer kann eine Liste eingeladener Mitglieder einsehen',
+-	'ACL_M_INVITE_SIZE'		=> 'Benutzer kann Einladungsanfrage akzeptieren.',
++	'ACL_M_INVITE_CLAIMING'		=> 'Benutzer kann Einladungsanfrage akzeptieren.',
+ 	'ACL_U_INVITE_DELETE'	=> 'Benutzer kann Einladung zurückziehen<br /><em>Benutzer kann eine Einladung, die er vergeben hat, abbrechen.</em>',
+ 	'ACL_U_INVITE_REQUEST'	=> 'Benutzer kann Einladung anfordern',
+-	'ACL_U_INVITE_SEND'		=> 'Benutzer kann neue Mitglieder zur Seite einladen',
++	'ACL_U_INVITE_SENDING'		=> 'Benutzer kann neue Mitglieder zur Seite einladen',
+ 	'ACL_U_INVITE_MAX'		=> 'Benutzer hat unbegrenzte Einladungen',
+ 	'ACL_U_INVITE_USERS'	=> 'Benutzer kann eine Liste der von anderen Benutzern eingeladenen Mitglieder einsehen.',
+ ));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/language/en/info_acp_invite.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/en/info_acp_invite.php"
+index a5397f2da..7a94c6896 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/language/en/info_acp_invite.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/en/info_acp_invite.php"
+@@ -45,7 +45,9 @@ $lang = array_merge($lang, array(
+ 	'ACP_INVITED_PEND_COUNT'							=> 'All Invitations (%s)',
+ 	'ACP_INVITED_USERS_COUNT'							=> 'All users (%s)',
+ 	'ACP_INVITE_ALL_USER_INVITE_MAX'					=> 'Unlimited invitation for everyone',
+-	'ACP_INVITE_ALL_USER_INVITE_MAX_EXPLAIN'			=> 'if selected, all users will have unlimited invitations.',
++	'ACP_INVITE_ALL_USER_INVITE_MAX_EXPLAIN'			=> 'If selected, all users will have unlimited invitations.',
++	'ACP_INVITE_RESTORE_INVITES'						=> 'Restore expired and refused invitations',
++	'ACP_INVITE_RESTORE_INVITES_EXPLAIN'				=> 'If selected, invitations that were expired or refused could be reused again.',
+ 	'ACP_INVITE_BIRTHDAYS'								=> 'Birthday',
+ 	'ACP_INVITE_BIRTHDAYS_EXPLAIN'						=> 'You can set how many invitations a user will receive for their birthday. <em>To let this setting take effect the birthday feature needs to be enabled too.</em>',
+ 	'ACP_INVITE_CAPTCHA'								=> 'Visual confirmation',
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/language/en/info_ucp_invite.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/en/info_ucp_invite.php"
+index 5c4a7ebdd..a1f961d09 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/language/en/info_ucp_invite.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/en/info_ucp_invite.php"
+@@ -39,6 +39,10 @@ $lang = array_merge($lang, array(
+ 
+ 	'UCP_CAT_INVITE'						=> 'phpBB Invite',
+ 	'UCP_INVITE'							=> 'Invitation',
++	'UCP_INVITE_LABEL'						=> 'GoldTugAnime - Invitation',
++	'UCP_INVITE_MESSAGE'					=> 'Welcome to the most beautiful Portuguese (Portugal) Animation Community!
++
++We hope you have fun and that animation never stops being part of your life.',
+ 	'UCP_INVITE_DATA'						=> 'Invitation details',
+ 	'UCP_INVITE_BACK'						=> '<br /><br />%sBack to the user control panel%s',
+ 	'UCP_INVITE_DAYF'						=> 'Invitations sent today',
+@@ -92,9 +96,11 @@ $lang = array_merge($lang, array(
+ 	'UCP_INVITE_REQUEST_SUBMIT'				=> 'Send request',
+ 	'UCP_INVITE_REQUEST_SUCC'				=> 'The invitation request has been successfully sent!',
+ 	'UCP_INVITE_REQUEST_SUCCS'				=> 'The invitation requests have been successfully sent!',
+-	'UCP_INVITE_REQUEST_TITLE'				=> 'Required invitations',
+-	'UCP_INVITE_REQUEST_TITLE_EXPLAIN'		=> 'Enter the number of invitations you want to request. There is a maximum of <b>(%s)</b> invitation(s) available.<br />You take full responsibility for your invited user(s) if they behave inappropriately.',
++	'UCP_INVITE_REQUEST_TITLE'				=> 'Request invitations',
++	'UCP_INVITE_REQUEST_TITLE_EXPLAIN'		=> 'Enter the number of invitations you want to request. There is a maximum of <b>(%s)</b> invitation(s) available.',
++	'UCP_INVITE_REQUEST_COST'				=> '<div class="invitation_tred alert alert-danger">Invitation price is <b>50.000 points</b>.</div>',
+ 	'UCP_INVITE_SEND'						=> 'Send invitation',
++	'UCP_INVITE_SEND_EXPLAIN'			=> '<div class="invitation_tred alert alert-danger">You take some responsibility for your invited user(s) if they behave inappropriately.</div>',
+ 	'UCP_INVITE_SEND_EMAIL_MAX'				=> 'Maximum %s e-mail addresses can be used. However you listed %s!',
+ 	'UCP_INVITE_SEND_MAX'					=> '<span class="invitation_tred">Currently there is no limit!</span>',
+ 	'UCP_INVITE_LAST_ACTIVE'				=> 'Last active',
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/language/en/invite.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/en/invite.php"
+index 740a03f88..bacafca7f 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/language/en/invite.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/en/invite.php"
+@@ -36,6 +36,7 @@ if (empty($lang) || !is_array($lang))
+ 
+ $lang = array_merge($lang, array(
+ 	'INVITE'								=> 'Invite',
++	'INVITE_INFO'								=> 'Invite Information',
+ 	'INVITE_DELETE_CONFIRM'					=> 'If you want to delete the invitation, click %sHERE%s.',
+ 	'INVITE_DELETE_SUCCESS'					=> 'Your invitation was successfully deleted.',
+ 	'INVITE_DELETE_SUCCESSES'				=> 'Your invitations were successfully deleted.',
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/language/en/permissions_invite.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/en/permissions_invite.php"
+index 12d8e8f6b..2a2ac278b 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/language/en/permissions_invite.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/en/permissions_invite.php"
+@@ -38,14 +38,14 @@ $lang = array_merge($lang, array(
+ 	'ACL_A_INVITE'			=> 'User can synchronize data',
+ 	'ACL_A_INVITE_CONFIG'	=> 'User can change invitation settings.',
+ 	'ACL_A_INVITE_DELETE'	=> 'User can delete invitations',
+-	'ACL_A_INVITE_SIZE'		=> 'User can manage invitations',
++	'ACL_A_INVITE_CLAIMING'		=> 'User can manage invitations',
+ 	'ACL_A_INVITE_SEND'		=> 'User can allocate invitations to members',
+ 	'ACL_A_INVITE_PEND'		=> 'User can manage pending invitations',
+ 	'ACL_A_INVITE_USERS'	=> 'User can see a list of invited members',
+-	'ACL_M_INVITE_SIZE'		=> 'User can approve invitation application.',
++	'ACL_M_INVITE_CLAIMING'		=> 'User can approve invitation application.',
+ 	'ACL_U_INVITE_DELETE'	=> 'User can revoke invitation<br /><em>User can cancel an invitation he has sent.</em>',
+ 	'ACL_U_INVITE_REQUEST'	=> 'User can request invitation',
+-	'ACL_U_INVITE_SEND'		=> 'User can invite new members to the site',
++	'ACL_U_INVITE_SENDING'		=> 'User can invite new members to the site',
+ 	'ACL_U_INVITE_MAX'		=> 'User has unlimited invitations',
+ 	'ACL_U_INVITE_USERS'	=> 'User can view the list of users invited by others.',
+ ));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/language/fr/permissions_invite.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/fr/permissions_invite.php"
+index db5471479..c829b086e 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/language/fr/permissions_invite.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/fr/permissions_invite.php"
+@@ -38,14 +38,14 @@ $lang = array_merge($lang, array(
+ 	'ACL_A_INVITE'			=> 'Peut synchroniser les données',
+ 	'ACL_A_INVITE_CONFIG'	=> 'Peut changer les paramètres d’invitation',
+ 	'ACL_A_INVITE_DELETE'	=> 'Peut supprimer des invitations',
+-	'ACL_A_INVITE_SIZE'		=> 'Peut gérer les invitations',
++	'ACL_A_INVITE_CLAIMING'		=> 'Peut gérer les invitations',
+ 	'ACL_A_INVITE_SEND'		=> 'Peut allouer des invitations à des membres',
+ 	'ACL_A_INVITE_PEND'		=> 'Peut gérer les invitations en attente',
+ 	'ACL_A_INVITE_USERS'	=> 'Peut voir les listes de membres invités',
+-	'ACL_M_INVITE_SIZE'		=> 'Peut approuver une demande d’invitation',
++	'ACL_M_INVITE_CLAIMING'		=> 'Peut approuver une demande d’invitation',
+ 	'ACL_U_INVITE_DELETE'	=> 'Peut annuler une invitation qu’il a envoyée',
+ 	'ACL_U_INVITE_REQUEST'	=> 'Peut demander une invitation',
+-	'ACL_U_INVITE_SEND'		=> 'Peut inviter des nouveaux membres sur le site',
++	'ACL_U_INVITE_SENDING'		=> 'Peut inviter des nouveaux membres sur le site',
+ 	'ACL_U_INVITE_MAX'		=> 'Peut disposer d’un nombre illimité d’invitations',
+ 	'ACL_U_INVITE_USERS'	=> 'Peut voir la liste des membres invités par les autres',
+ ));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/language/hu/permissions_invite.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/hu/permissions_invite.php"
+index 6f3963e45..0c7d8b12d 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/language/hu/permissions_invite.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/hu/permissions_invite.php"
+@@ -38,14 +38,14 @@ $lang = array_merge($lang, array(
+ 	'ACL_A_INVITE'			=> 'Szinkronizálhatja az adatokat',
+ 	'ACL_A_INVITE_CONFIG'	=> 'Módosíthatja a beállításokat',
+ 	'ACL_A_INVITE_DELETE'	=> 'Törölheti a felhasználók meghívóját',
+-	'ACL_A_INVITE_SIZE'		=> 'Kezelheti a meghívó kérelmeket',
++	'ACL_A_INVITE_CLAIMING'		=> 'Kezelheti a meghívó kérelmeket',
+ 	'ACL_A_INVITE_SEND'		=> 'Kiutalhat meghívókat',
+ 	'ACL_A_INVITE_PEND'		=> 'Kezelheti a függőben lévő meghívókat',
+ 	'ACL_A_INVITE_USERS'	=> 'Láthatja a meghívott személyek listáját',
+-	'ACL_M_INVITE_SIZE'		=> 'Jóváhagyhat meghívó iránti kérelmet',
++	'ACL_M_INVITE_CLAIMING'		=> 'Jóváhagyhat meghívó iránti kérelmet',
+ 	'ACL_U_INVITE_DELETE'	=> 'Törölheti a már kiküldött meghívót<br /><em>Ha rossz címre küldi netán a meghívót akkor esélye van azt törölni.</em>',
+ 	'ACL_U_INVITE_REQUEST'	=> 'Igényelhet meghívót',
+-	'ACL_U_INVITE_SEND'		=> 'Meghívhat új tagot az pagera',
++	'ACL_U_INVITE_SENDING'		=> 'Meghívhat új tagot az pagera',
+ 	'ACL_U_INVITE_MAX'		=> 'Korlátlan meghívóval rendelkezzen',
+ 	'ACL_U_INVITE_USERS'	=> 'Megtekintheti a mások által meghívott felhasználók listáját.',
+ ));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/language/nl/permissions_invite.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/nl/permissions_invite.php"
+index 6ade6a512..805a255b7 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/language/nl/permissions_invite.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/nl/permissions_invite.php"
+@@ -38,14 +38,14 @@ $lang = array_merge($lang, array(
+ 	'ACL_A_INVITE'			=> 'Gebruiker kan data synchroniseren',
+ 	'ACL_A_INVITE_CONFIG'	=> 'Gebuiker kan uitnodigings instellingen veranderen.',
+ 	'ACL_A_INVITE_DELETE'	=> 'Gebruiker kan uitnodigingen verwijderen',
+-	'ACL_A_INVITE_SIZE'		=> 'Gebruiker kan uitnodigingen beheren',
++	'ACL_A_INVITE_CLAIMING'		=> 'Gebruiker kan uitnodigingen beheren',
+ 	'ACL_A_INVITE_SEND'		=> 'Gebruiker kan uitnodigingen toewijzen aan leden',
+ 	'ACL_A_INVITE_PEND'		=> 'Gebruiker kan wachtende uitnodigingen beheren',
+ 	'ACL_A_INVITE_USERS'	=> 'Gebruiker kan een lijst van uitgenodigde leden zien',
+-	'ACL_M_INVITE_SIZE'		=> 'Gebruiker kan een aanvraag van een uitnodiging accepteren.',
++	'ACL_M_INVITE_CLAIMING'		=> 'Gebruiker kan een aanvraag van een uitnodiging accepteren.',
+ 	'ACL_U_INVITE_DELETE'	=> 'Gebruiker kan een uitnodiging intrekken<br /><em>Gebruiker kan een uitnodiging die hij heeft gestuurd annuleren.</em>',
+ 	'ACL_U_INVITE_REQUEST'	=> 'Gebruiker kan een uitnodiging aanvragen',
+-	'ACL_U_INVITE_SEND'		=> 'Gebruiker kan leden uitnodigen naar de site',
++	'ACL_U_INVITE_SENDING'		=> 'Gebruiker kan leden uitnodigen naar de site',
+ 	'ACL_U_INVITE_MAX'		=> 'Gebruiker heeft ongelimiteerd uitnodigingen',
+ 	'ACL_U_INVITE_USERS'	=> 'Gebruiker kan de lijst met uitnodigingen door andere bekijken.',
+ ));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/language/pt_pt/common.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt/common.php"
+similarity index 100%
+rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/language/pt_pt/common.php"
+rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt/common.php"
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/language/pt_pt/email/user_invite.txt" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt/email/user_invite.txt"
+similarity index 100%
+rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/language/pt_pt/email/user_invite.txt"
+rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt/email/user_invite.txt"
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/language/pt_pt/email/user_invite_request.txt" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt/email/user_invite_request.txt"
+similarity index 100%
+rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/language/pt_pt/email/user_invite_request.txt"
+rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt/email/user_invite_request.txt"
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/language/pt_pt/email/user_invites.txt" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt/email/user_invites.txt"
+similarity index 100%
+rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/language/pt_pt/email/user_invites.txt"
+rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt/email/user_invites.txt"
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt/info_acp_invite.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt/info_acp_invite.php"
+new file mode 100644
+index 000000000..d929b5bcd
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt/info_acp_invite.php"
+@@ -0,0 +1,229 @@
++<?php
++
++/**
++ *
++ * Invite. An extension for the phpBB Forum Software package.
++ * Brazilian Portuguese translation by eunaumtenhoid [2019][ver 4.2.0] (https://github.com/phpBBTraducoes)
++ * @copyright (c) 2010-2015, KillBill
++ * @copyright (c) 2017, kasimi
++ * @copyright (c) 2017-2022, Leinad4Mind, https://leinad4mind.top/forum
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
++// Some characters you may want to copy&paste: ’ « » „ “ ” …
++
++$lang = array_merge($lang, array(
++	'ACC_INVITE_DISABLE'								=> 'Convite desativado',
++	'ACC_INVITE_ENABLE'									=> 'Apenas com convite',
++	'ACC_INVITE_REGISTER'								=> 'Convite + Registo',
++	'ACP_CAT_INVITE'									=> 'phpBB Invite',
++	'ACP_INVITE_REGISTER'								=> 'Criando ID por convite',
++	'ACP_INVITE_REGISTER_EXPLAIN'						=> 'definir opções de registo, pode ser usado como um único recurso, se necessário.<br />Desativar registo substitui todas as opções!',
++	'ACP_INVITE'										=> 'Convite',
++	'ACP_INVITED_PEND_COUNT'							=> 'Todos Convites (%s)',
++	'ACP_INVITED_USERS_COUNT'							=> 'Todos os utilizadores (%s)',
++	'ACP_INVITE_ALL_USER_INVITE_MAX'					=> 'Convite ilimitado para todos',
++	'ACP_INVITE_ALL_USER_INVITE_MAX_EXPLAIN'			=> 'Se sim, todos os utilizadores terão convites ilimitados.',
++	'ACP_INVITE_RESTORE_INVITES'						=> 'Restaurar convites expirados e recusados',
++	'ACP_INVITE_RESTORE_INVITES_EXPLAIN'				=> 'Caso um convite expire ou seja recusado deverá o convite ser novamente disponibilizado ao utilizador.',
++	'ACP_INVITE_BIRTHDAYS'								=> 'Aniversário',
++	'ACP_INVITE_BIRTHDAYS_EXPLAIN'						=> 'Podes definir quantos convites um utilizador receberá no seu aniversário. <em>Para que essa configuração tenha efeito, o recurso de aniversário também precisa ser activado.</em>',
++	'ACP_INVITE_CAPTCHA'								=> 'Confirmação visual',
++	'ACP_INVITE_CAPTCHA_EXPLAIN'						=> 'Os utilizadores devem inserir um código aleatório de uma imagem.',
++	'ACP_INVITE_CONFIG'									=> 'Configurações',
++	'ACP_INVITE_CONFIG_EXPLAIN'							=> 'Aqui poderás configurar a extensão de convite.',
++	'ACP_INVITE_CONFIG_GIFT'							=> 'Configurações de presente',
++	'ACP_INVITE_CONFIG_GROUP'							=> 'Configurações de grupo',
++	'ACP_INVITE_CONFIG_REQUEST'							=> 'Configurações de solicitações',
++	'ACP_INVITE_DB'										=> 'item',
++	'ACP_INVITE_DEFAULT_GROUP'							=> 'Tornar o grupo padrão',
++	'ACP_INVITE_DEFAULT_GROUP_EXPLAIN'					=> 'O grupo selecionado também será o grupo padrão para utilizadores convidados.<br /><em>Observe que essa configuração substitui a configuração "Definir utilizadores recém-registados como padrão".</em>',
++	'ACP_INVITE_DEFAULT_GROUP_USERS'					=> 'Todos os utilizadores no grupo',
++	'ACP_INVITE_DEFAULT_GROUP_USERS_EXPLAIN'			=> 'Você precisa selecionar no mínimo um grupo. Você precisa selecionar sim ou não para especificar se todos os utilizadores desse grupo seleccionado são afectados ou apenas se os utilizadores são membros do grupo padrão.',
++	'ACP_INVITE_DELETES_PEND_CONFIRM'					=> 'Tens a certeza de que desejas excluir os convites selecionados?<br /><em>Observação: Se confirmares, as pessoas convidadas não poderão mais usar os teus convites!</em>',
++	'ACP_INVITE_DELETE_ALL_PEND_CONFIRM'				=> 'Tens a certeza de que desejas excluir todos os convites?<br /><em>Observação: Se confirmares, os convidados não poderão mais usar o teu convite!</em>',
++	'ACP_INVITE_DELETE_GROUPS_CONFIRM'					=> 'Tens a certeza de que desejas excluir os convites de grupos selecionados?',
++	'ACP_INVITE_DELETE_GROUP_CONFIRM'					=> 'Tens a certeza de que desejas excluir os convites do grupo selecionado?',
++	'ACP_INVITE_DELETE_PEND_CONFIRM'					=> 'Tens a certeza de que desejas excluir o convite selecionado?<br /><em>Observação: Se confirmares, a pessoa convidada não poderá mais usar o convite!</em>',
++	'ACP_INVITE_DELETE_TIME'							=> 'Expirar tempo para excluir convites',
++	'ACP_INVITE_DELETE_TIME_EXPLAIN'					=> 'Podes definir a hora em que um utilizador pode excluir convites enviados para o endereço de e-mail errado.',
++	'ACP_INVITE_DELETE_USERS_CONFIRM'					=> 'Tens a certeza de que desejas excluir os convites dos utilizadores selecionados?',
++	'ACP_INVITE_DELETE_USER_CONFIRM'					=> 'Tens a certeza de que desejas excluir os convites do utilizador selecionado?',
++	'ACP_INVITE_DISABLED'								=> 'O sistema de convite está desativado!',
++	'ACP_INVITE_DENY'									=> 'Rejeitar',
++	'ACP_INVITE_EMAIL_BOARD_DISABLED'					=> '<strong>phpBB Invite:</strong> O envio de e-mails está, de momento, desativado!<br />Enquanto estiver desativado, os convites não devem funcionar. Se quiseres activá-lo, podes fazê-lo %sAQUI%s.',
++	'ACP_INVITE_EMAIL_DISABLED'							=> 'Envio de e-mails foi desativado, por favor, ative-o. %sVá às configurações de e-mail.%s ',
++	'ACP_INVITE_EMAIL_PRIORITY'							=> 'Prioridade do email de convite',
++	'ACP_INVITE_MEMBERSHIP_DAYS'						=> 'Número mínimo de dias de registo',
++	'ACP_INVITE_MEMBERSHIP_DAYS_EXPLAIN'				=> 'Número de dias que um utilizador precisa de ter para poder usar o sistema de convites. Colocar 0 para desativar e permitir uso imediato.',
++	'ACP_INVITE_ENABLE'									=> 'Ativar extensão de convite',
++	'ACP_INVITE_ENABLE_EXPLAIN'							=> 'Se o ativares, a extensão do convite será usada.',
++	'ACP_INVITE_VALIDATION'								=> 'Tempo de expiração dos convites enviados',
++	'ACP_INVITE_VALIDATION_EXPLAIN'						=> 'Podes definir o tempo de expiração dos convites enviados. Após esse período, o ID do convite será excluído, portanto, não é mais possível registá-lo.',
++	'ACP_INVITE_EXPLAIN'								=> 'O valor será adicionado.',
++	'ACP_INVITE_GIFT_NUMBER_INVITES'					=> 'Número de convites presenteado',
++	'ACP_INVITE_GIFT_INVITED_USERS'						=> 'Utilizadores convidados',
++	'ACP_INVITE_GIFT_INVITED_USERS_EXPLAIN'				=> 'Os utilizadores receberão um convite de presente após esse número de utilizadores convidados.<br /><em>Se "0", essa função será desativada.</em>',
++	'ACP_INVITE_POSTS_GIFT_INVITES'						=> 'Convites por Intervalo',
++	'ACP_INVITE_POSTS_GIFT_INVITES_EXPLAIN'				=> 'Número de convites que um utilizador irá receber após atingir o número de x mensagens. Colocar 0 para desativar.',
++	'ACP_INVITE_POSTS_GIFT_POSTS'						=> 'Intervalo de Mensagens',
++	'ACP_INVITE_POSTS_GIFT_POSTS_EXPLAIN'				=> 'O utilizador irá receber a cada x mensagens o número de convites inserido no campo acima. Colocar 0 para desativar.',
++	'ACP_INVITE_POSTS_GIFT_LIMIT'						=> 'Limite do Intervalo',
++	'ACP_INVITE_POSTS_GIFT_LIMIT_EXPLAIN'				=> 'Número máximo de intervalos que um utilizador irá receber convites. Por exemplo, colocar intervalo de 30 mensagens com limite de 3 vezes irá enviar convites quando o utilizador atingir 30, 60 e 90 mensagens. Colocar 0 para desativar.',
++	'ACP_INVITE_GROUP'									=> 'Grupo de utilizadores convidados',
++	'ACP_INVITE_GROUP_ENABLED'							=> 'Ativer o uso de grupo',
++	'ACP_INVITE_GROUP_ENABLED_EXPLAIN'					=> 'If enabled, invited users will automatically be added to the selected group.',
++	'ACP_INVITE_GROUP_EXPLAIN'							=> 'The invited users will be added to the selected group.<br /><em>Note that the pre-defined system groups are not on the list.</em>',
++	'ACP_INVITE_GROUPS_MANAGEMENT'						=> 'Manage Group',
++	'ACP_INVITE_CLAIMING'									=> 'Invitation requests',
++	'ACP_INVITE_CLAIMING_EXPLAIN'							=> 'View / decide about users invitation requests.',
++	'ACP_INVITE_INDEX_TITLE'							=> 'Welcome to phpBB Invite!',
++	'ACP_INVITE_INDEX_TITLE_EXPLAIN'					=> 'Thank you for choosing phpBB Invite. On this page you can see an overview of various statistical data of the invite system. On top of the page and via the links on the left side of the invite you can change every part in detail. On every page you will find a description of the current settings.',
++	'ACP_INVITE_INSTALL'								=> 'Installation date',
++	'ACP_INVITE_HANDLING'								=> 'Manage users/groups',
++	'ACP_INVITE_HANDLING_EXPLAIN'						=> 'Here you can grant or revoke the invitations for users and groups.',
++	'ACP_INVITE_HANDLING_GROUPS_DELETE'					=> 'The invitations of the following group were deleted successfully. <br /><br />(<em><b>%s</b></em>).',
++	'ACP_INVITE_HANDLING_GROUPS_DELETES'				=> 'The invitations of the following groups were deleted successfully. <br /><br />(<em><b>%s</b></em>).',
++	'ACP_INVITE_HANDLING_GROUPS_IG'						=> 'Successfully delivered the invitation to (<em><b>%s</b></em>) group.<br />Sent invitation: (<em><b>%s</b></em>)',
++	'ACP_INVITE_HANDLING_GROUPS_IGS'					=> 'Successfully delivered the invitation to (<em><b>%s</b></em>) groups.<br />Sent invitation: (<em><b>%s</b></em>)',
++	'ACP_INVITE_HANDLING_GROUPS_ISG'					=> 'Successfully delivered the invitations to (<em><b>%s</b></em>) group.<br />Sent invitations: (<em><b>%s</b></em>).',
++	'ACP_INVITE_HANDLING_GROUPS_ISGS'					=> 'Successfully delivered the invitations to (<em><b>%s</b></em>) groups.<br />Sent invitations: (<em><b>%s</b></em>).',
++	'ACP_INVITE_HANDLING_USERS_DELETE'					=> 'The invitations of the following user were deleted successfully<br /><br />(<em><b>%s</b></em>).',
++	'ACP_INVITE_HANDLING_USERS_DELETES'					=> 'The invitations of the following users were deleted successfully<br /><br />(<em><b>%s</b></em>).',
++	'ACP_INVITE_HANDLING_USERS_ISU'						=> 'Successfully delivered the invitations to (<em><b>%s</b></em>) user.<br />Sent invitations: (<em><b>%s</b></em>).',
++	'ACP_INVITE_HANDLING_USERS_ISUS'					=> 'Successfully delivered the invitations to (<em><b>%s</b></em>) users.<br />Sent invitations: (<em><b>%s</b></em>).',
++	'ACP_INVITE_HANDLING_USERS_IU'						=> 'Successfully delivered the invitation to (<em><b>%s</b></em>) user.<br /> Sent invitation: (<em><b>%s</b></em>).',
++	'ACP_INVITE_HANDLING_USERS_IUS'						=> 'Successfully delivered the invitation to (<em><b>%s</b></em>) users.<br />Sent invitation: (<em><b>%s</b></em>).',
++	'ACP_INVITE_HANDLING_USER_I'						=> 'Number of invitation changed successfully for user (<em><b>%s</b></em>).<br />New quantity: (<em><b>%s</b></em>).',
++	'ACP_INVITE_HANDLING_USER_IS'						=> 'Number of invitations changed successfully for user (<em><b>%s</b></em>).<br />New quantity: (<em><b>%s</b></em>).',
++	'ACP_INVITE_ALLOCATE'								=> 'Add',
++	'ACP_INVITE_SEND_DAY_DB'							=> 'Number of invitations to be sent per day',
++	'ACP_INVITE_SEND_DAY_DB_EXPLAIN'					=> 'You can set the maximum number of invites a user can send per day.<br /><em>(0=unlimited.)</em>',
++	'ACP_INVITE_SEND_DB_NUM'							=> 'number of pieces',
++	'ACP_INVITE_MAIL_FIX'								=> 'Allow e-mail address switching',
++	'ACP_INVITE_MAIL_FIX_EXPLAIN'						=> 'It allows to specify a different e-mail address during the registration.',
++	'ACP_INVITE_MAIN'									=> 'Overview',
++	'ACP_INVITE_MAINTENANCE_UPDATE_INVITE'				=> 'The oldest version the phpBB Invite updater supports is <strong>“%s”</strong>. Please update to version <strong>“%s”</strong> before running the update to version <strong>“%s”</strong>.',
++	'ACP_INVITE_MAINTENANCE_UPDATE_PHPBB'				=> 'You need to update phpBB to at least version <strong>“%s”</strong> before updating phpBB Invite to version <strong>“%s”</strong>.',
++	'ACP_INVITE_MAIN_CONFIG'							=> 'Main settings',
++	'ACP_INVITE_MEMBER'									=> '%s Pessoa',
++	'ACP_INVITE_MESSAGE'								=> 'User justification',
++	'ACP_INVITE_MESSAGE_TIME'							=> 'Request time',
++	'ACP_INVITE_MINUS'									=> 'You can’t set a minus value.',
++	'ACP_INVITE_MOD'									=> 'phpBB Invite',
++	'ACP_INVITE_MORE_EMAIL_DB'							=> 'Set recipients limit',
++	'ACP_INVITE_MORE_EMAIL_DB_EXPLAIN'					=> 'You can set the maximum number of invitations that can be sent at a time here.<br /><em>(1=disabled.)</em>',
++	'ACP_INVITE_NEW_MEMBER_POST_LIMIT_IGNORED'			=> 'Ignore new members post limit',
++	'ACP_INVITE_NEW_MEMBER_POST_LIMIT_IGNORED_EXPLAIN'	=> 'If set to yes, accepting an invitation will not get newly registered users into the “Newly registered users” group.',
++	'ACP_INVITE_NEW_REG'								=> 'New registration',
++	'ACP_INVITE_NEW_REG_EXPLAIN'						=> 'Number of invitations given to a new user once registered.',
++	'ACP_INVITE_NO_ANONYMOUS'							=> 'Guest users can not be selected!',
++	'ACP_INVITE_NO_GROUP'								=> 'No accessible group. If you want to create a new group can do it %sHERE%s.',
++	'ACP_INVITE_NO_GROUP_SPECIFIED'						=> 'You didn’t select a group.',
++	'ACP_INVITE_NO_PETITION'							=> 'There is currently no request for invitation!',
++	'ACP_INVITE_NO_MARKED'								=> 'You have not selected a user either!',
++	'ACP_INVITE_NO_PEND_INVITE'							=> 'There are currently no pending invitations.',
++	'ACP_INVITE_NO_SELECT_INVITE'						=> 'You didn’t select an invitation!',
++	'ACP_INVITE_NO_USERS'								=> 'Currently no received invitations!',
++	'ACP_INVITE_NO_VALUE'								=> 'You didn’t set the number of invitations!',
++	'ACP_INVITE_NUMBER_INVITED_USERS'					=> 'Number of invited users',
++	'ACP_INVITE_PENDING'								=> 'Pending invitations',
++	'ACP_INVITE_PENDING_EXPLAIN'						=> 'Here you can view and delete unused invitations sent out.',
++	'ACP_INVITE_PEND_DATE'								=> 'Shipping time',
++	'ACP_INVITE_PEND_DB'								=> 'Outstanding invitations',
++	'ACP_INVITE_PEND_DELETE_ALL_SUCCESSES'				=> 'All pending invitations have been successfully deleted.',
++	'ACP_INVITE_PEND_DELETE_MARKS_SUCCESSES'			=> 'The selected pending invitations have been successfully deleted.',
++	'ACP_INVITE_PEND_DELETE_MARK_SUCCESSES'				=> 'The selected pending invitation has been successfully deleted.',
++	'ACP_INVITE_PEND_EMAIL'								=> 'Recipient e-mail address',
++	'ACP_INVITE_PEND_END_DATE'							=> 'Expiration date',
++	'ACP_INVITE_PETITION_NSUCCESS'						=> 'The rejection was successful.',
++	'ACP_INVITE_PETITION_NSUCCESSES'					=> 'The rejections were successful.',
++	'ACP_INVITE_PETITION_YSUCCESS'						=> 'The allocation has been successfully completed.',
++	'ACP_INVITE_PETITION_YSUCCESSES'					=> 'The allocations have been successfully completed.',
++	'ACP_INVITE_NOTIFICATION_NO_USER'					=> 'The user name for sending notifications does not exist!',
++	'ACP_INVITE_NOTIFICATION_USERNAME'					=> 'Notifications sender name',
++	'ACP_INVITE_NOTIFICATION_USERNAME_EXPLAIN'			=> 'Name of the user who will send the notification.',
++	'ACP_INVITE_POST_LIMIT_DB'							=> 'Total posts',
++	'ACP_INVITE_POST_LIMIT_DB_EXPLAIN'					=> 'This is the post count needed to send out invitations.<br /><em>(0=disabled.)</em>',
++	'ACP_INVITE_REG_EMAIL'								=> 'Registered e-mail',
++	'ACP_INVITE_REQUEST_CAUSE'							=> 'Activation limit',
++	'ACP_INVITE_REQUEST_CAUSE_EXPLAIN'					=> 'When claiming more than this number of invitations, a reason is required to continue.<br /><em>(0=disabled.)</em>',
++	'ACP_INVITE_REQUEST_MAX'							=> 'Maximum number of invitations available',
++	'ACP_INVITE_REQUEST_MAX_EXPLAIN'					=> '<em>(0=disable requests.)</em>',
++	'ACP_INVITE_REQUIRE_AC_DISABLED'					=> 'Registration by invitation is not possible, since it is currently turned off!',
++	'ACP_INVITE_SORT_NAME'								=> 'Invited',
++	'ACP_INVITE_SYNC_DATA'								=> 'Resynchronise total data',
++	'ACP_INVITE_SYNC_DATA_CONFIRM'						=> 'Are you sure you want to resynchronise the invite totals data?',
++	'ACP_INVITE_SYNC_DATA_EXPLAIN'						=> 'The invite total data will be resynchronised, this includes the following: invited users, pending invitations and invitations claimed.',
++	'ACP_INVITE_SYNC_DATA_SUCCESSES'					=> 'The invite total data was successfully resynchronised.',
++	'ACP_INVITE_SYNC_USERS'								=> 'Ressincronize os dados dos utilizadores.',
++	'ACP_INVITE_SYNC_USERS_CONFIRM'						=> 'Tens a certeza de que deseja ressincronizar os dados dos utilizadores convidados?',
++	'ACP_INVITE_SYNC_USERS_EXPLAIN'						=> 'Os dados dos utilizadores convidados serão ressincronizados',
++	'ACP_INVITE_SYNC_USERS_SUCCESSES'					=> 'Os dados dos utilizadores convidados foram ressincronizados com sucesso.',
++	'ACP_INVITE_TOTAL_USERS'							=> 'Número de utilizadores convidados',
++	'ACP_INVITE_TOTAL_USERS_DAY'						=> 'Número de utilizadores convidados por dia',
++	'ACP_INVITE_UG_TASK'								=> 'Selecione uma tarefa',
++	'ACP_INVITE_USERS'									=> 'Utilizadores que convidaram',
++	'ACP_INVITE_USERS_COUNT'							=> 'Solicitações totais (%s)',
++	'ACP_INVITE_USERS_EXPLAIN'							=> 'Aqui podes ver a lista de utilizadores que já convidaram um novo membro para o site.',
++	'ACP_INVITE_USERS_MANAGEMENT'						=> 'Gerir utilizadores selecionados',
++	'ACP_INVITE_USERS_NO_GROUP'							=> 'Não há utilizador no grupo selecionado.',
++	'ACP_INVITE_USERS_NO_GROUPS'						=> 'Não há utilizador nos grupos selecionados.',
++	'ACP_INVITE_USER_EXPLAIN'							=> 'O valor mudará a quantidade de convites do utilizador.',
++	'ACP_INVITE_USER_LIST'								=> 'Número de utilizadores por página',
++	'ACP_INVITE_USER_LIST_EXPLAIN'						=> 'Este valor define o número de utilizadores listados em uma página.',
++	'ACP_INVITE_USER_MANAGEMENT'						=> 'Uma gestão de utilizadores',
++	'ACP_INVITE_USER_MANAGEMENT_EXPLAIN'				=> 'Aqui podes alterar a quantidade de convites do utilizador.',
++	'ACP_INVITE_USER_NAME'								=> 'nome',
++
++	'LOG_INVITE_CONFIG'							=> '<strong>Configuração de convite modificada.</strong>',
++	'LOG_INVITE_DELETE'							=> '<strong>Convite Revogado.</strong><br />» Endereço de e-mail: %s',
++	'LOG_INVITE_SIZE_DELETE'					=> '<strong>Convite Recusado</strong><br />» Utilizador: %s',
++	'LOG_INVITE_INSTALL'						=> '<strong>phpBB Invite instalado</strong><br />» Versão: %s',
++	'LOG_INVITE_HANDLING_GROUPS_DELETE'			=> '<strong>Convites apagados de um grupo.</strong><br />» <b>Grupo:</b> (<em>%s</em>).',
++	'LOG_INVITE_HANDLING_GROUPS_DELETES'		=> '<strong>Convites apagados de grupos.</strong><br />» <b>Grupos:</b> (<em>%s</em>).',
++	'LOG_INVITE_HANDLING_GROUPS_IG'				=> '<strong>Convite adicionado para um grupo.</strong><br />» <b>Grupo:</b> (<em>%s</em>)<br />» Convite adicionado: (%s).',
++	'LOG_INVITE_HANDLING_GROUPS_IGS'			=> '<strong>Convite adicionado para grupos.</strong><br />» <b>Grupos:</b> (<em>%s</em>)<br />» Convite adicionado: (%s).',
++	'LOG_INVITE_HANDLING_GROUPS_ISG'			=> '<strong>Convites adicionados para um grupo.</strong><br />» <b>Grupo:</b> (<em>%s</em>)<br />» Convites adicionados: (%s).',
++	'LOG_INVITE_HANDLING_GROUPS_ISGS'			=> '<strong>Convites adicionados para grupos.</strong><br />» <b>Grupos:</b> (<em>%s</em>)<br />» Convites adicionados: (%s)',
++	'LOG_INVITE_HANDLING_USERS_DELETE'			=> '<strong>Convites apagados de um utilizador.</strong><br />» <b>Utilizador:</b> (<em>%s</em>).',
++	'LOG_INVITE_HANDLING_USERS_DELETES'			=> '<strong>Convites apagados de utilizadores.</strong><br />» <b>Utilizadores:</b> (<em>%s</em>).',
++	'LOG_INVITE_HANDLING_USERS_ISU'				=> '<strong>Convite adicionado para um utilizador.</strong><br />» <b>Utilizador:</b> (<em>%s</em>)<br />» Convites adicionados: (%s).',
++	'LOG_INVITE_HANDLING_USERS_ISUS'			=> '<strong>Convites adicionados para utilizadores.</strong><br />» <b>Utilizadores:</b> (<em>%s</em>)<br />» Convites adicionados: (%s).',
++	'LOG_INVITE_HANDLING_USERS_IU'				=> '<strong>Convite adicionado para um utilizador.</strong><br />» <b>Utilizador:</b> (<em>%s</em>)<br />» Convites adicionados: (%s).',
++	'LOG_INVITE_HANDLING_USERS_IUS'				=> '<strong>Convites adicionados para utilizadores.</strong><br />» <b>Utilizadores:</b> (<em>%s</em>)<br />» Convites adicionados: (%s).',
++	'LOG_INVITE_HANDLING_USER_I'				=> '<strong>Mudou a quantidade de convites.</strong><br />» <b>Utilizador:</b> (<em>%s</em>)<br />» Nova quantidade: (%s) convite.',
++	'LOG_INVITE_HANDLING_USER_IS'				=> '<strong>Mudou a quantidade de convites.</strong><br />» <b>Utilizador:</b> (<em>%s</em>)<br />» Nova quantidade: (%s) convites.',
++	'LOG_INVITE_ALLOCATE'						=> '<strong>Convites adicionados para o utilizador %s.</strong><br />» Convites adicionados: %s.',
++
++	'LOG_INVITE_SEND_INVITATION'				=> '<strong>Convite enviado.</strong><br />» %s',
++	'LOG_INVITE_SEND_INVITATIONS'				=> '<strong>Convites enviados.</strong><br />» %s',
++
++	'LOG_INVITE_PEND_ALL_DELETE'				=> '<strong>Excluiu todos os convites pendentes.</strong>',
++	'LOG_INVITE_PEND_MARKED_DELETE'			=> '<strong>Excluído convite pendente selecionado.</strong><br />» Utilizador: %s',
++	'LOG_INVITE_PEND_MARKED_DELETES'			=> '<strong>Excluídos convites pendentes selecionados.</strong><br />» Utilizadores: %s',
++	'LOG_INVITE_SYNC_DATA'						=> '<strong>Ressincronização de dados de convite.</strong>',
++	'LOG_INVITE_SYNC_USERS'						=> '<strong>Ressincronização de dados de convite do utilizador.</strong>',
++));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/language/pt_pt/info_mcp_invite.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt/info_mcp_invite.php"
+similarity index 100%
+rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/language/pt_pt/info_mcp_invite.php"
+rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt/info_mcp_invite.php"
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/language/pt_pt/info_ucp_invite.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt/info_ucp_invite.php"
+similarity index 90%
+rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/language/pt_pt/info_ucp_invite.php"
+rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt/info_ucp_invite.php"
+index f4bc3ceb9..5f9f7062b 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/language/pt_pt/info_ucp_invite.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt/info_ucp_invite.php"
+@@ -39,6 +39,10 @@ $lang = array_merge($lang, array(
+ 
+ 	'UCP_CAT_INVITE'						=> 'phpBB Invite',
+ 	'UCP_INVITE'							=> 'Convites',
++	'UCP_INVITE_LABEL'						=> 'GoldTugAnime - Convite',
++	'UCP_INVITE_MESSAGE'					=> 'Bem-vindo à mais bela Comunidade de Animação em Português de Portugal!
++
++Esperamos que te divirtas e que a animação nunca deixe de fazer parte da tua vida.',
+ 	'UCP_INVITE_DATA'						=> 'Detalhes de convites',
+ 	'UCP_INVITE_BACK'						=> '<br /><br />%sVoltar para o painel de controlo do utilizador%s',
+ 	'UCP_INVITE_DAYF'						=> 'Convites enviados hoje',
+@@ -82,7 +86,7 @@ $lang = array_merge($lang, array(
+ 	'UCP_INVITE_REQUEST_BUY_SUBT_EXPLAIN'	=> 'Digita o número de convites que desejas comprar. O preço do convite é <b>%s %s</b>.<br />Assumes a responsabilidade pelo(s) teu(s) utilizador(es) convidado(s) se o(s) utilizador(es) convidado(s) causar(em) incidentes inapropriados.',
+ 	'UCP_INVITE_REQUEST_BUY_SUCCESS'		=> 'A compra do convite foi bem-sucedida.',
+ 	'UCP_INVITE_REQUEST_BUY_TITLE'			=> 'Comprar convite.',
+-	'UCP_INVITE_REQUEST_DISABLED'			=> 'As solicitacões de convites estão desactivadas!',
++	'UCP_INVITE_REQUEST_DISABLED'			=> 'As solicitações de convites estão desactivadas!',
+ 	'UCP_INVITE_REQUEST_MAX'				=> 'Número máximo de pedidos: (%s) convite(s)!',
+ 	'UCP_INVITE_REQUEST_MESSAGE_NO_DB'		=> '<em>Não! Não houve necessidade.</em>',
+ 	'UCP_INVITE_REQUEST_MIN'				=> 'Número mínimo de convites solicitados: (1)',
+@@ -92,9 +96,11 @@ $lang = array_merge($lang, array(
+ 	'UCP_INVITE_REQUEST_SUBMIT'				=> 'Enviar pedido',
+ 	'UCP_INVITE_REQUEST_SUCC'				=> 'A solicitação de convite foi enviada com sucesso!',
+ 	'UCP_INVITE_REQUEST_SUCCS'				=> 'A solicitação de convites foram enviadas com sucesso!',
+-	'UCP_INVITE_REQUEST_TITLE'				=> 'Convites requisitados',
+-	'UCP_INVITE_REQUEST_TITLE_EXPLAIN'		=> 'Digita o número de convites que desejas solicitar. Há um máximo de <b>(%s)</b> convites disponíveis.<br />Assumes total responsabilidade pelo(s) teu(s) utilizador(es) convidado(s) se eles se comportarem de maneira inapropriada.',
++	'UCP_INVITE_REQUEST_TITLE'				=> 'Requisitar convites',
++	'UCP_INVITE_REQUEST_TITLE_EXPLAIN'		=> 'Digita o número de convites que desejas solicitar. Há um máximo de <b>(%s)</b> convites disponíveis.',
++	'UCP_INVITE_REQUEST_COST'				=> '<div class="invitation_tred alert alert-danger">O preço por convite é de <b>50.000 pontos</b>.</div>',
+ 	'UCP_INVITE_SEND'						=> 'Enviar convite',
++	'UCP_INVITE_SEND_EXPLAIN'			=> '<div class="invitation_tred alert alert-danger">Assumes parte da responsabilidade dos utilizadores que convidares caso eles se comportarem de maneira inapropriada.</div>',
+ 	'UCP_INVITE_SEND_EMAIL_MAX'				=> 'Máximo de %s endereços de e-mail podem ser usados. No entanto, listaste %s!', 
+ 	'UCP_INVITE_SEND_MAX'					=> '<span class="invitation_tred">Actualmente não há limite!</span>',
+ 	'UCP_INVITE_LAST_ACTIVE'				=> 'Última visita',
+@@ -108,6 +114,7 @@ $lang = array_merge($lang, array(
+ 	'UCP_INVITE_NO_LOGIN'					=> 'Ele/ela não se registou neste site.',
+ 	'UCP_INVITE_NO_PERM'					=> 'Não está autorizado a enviar convites!',
+ 	'UCP_INVITE_NO_PERM_EMAIL'				=> 'Não está autorizado a enviar e-mail!',
++	'UCP_INVITE_MEMBERSHIP_DAYS'			=> 'A tua conta tem de ter pelo menos %1$d dias antes que possas fazer uso do sistema de convites. Poderás utilizar a partir de %2$s.',
+ 	'UCP_INVITE_NO_REG'						=> 'Ninguém foi convidado por ti.',
+ 	'UCP_INVITE_NULL'						=> 'Não tem convites! <em>Porque não comprar alguns?</em>', 
+ 	'UCP_INVITE_POINTS_AMOUNT'				=> 'Presente',
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt/install_invite.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt/install_invite.php"
+new file mode 100644
+index 000000000..dd11b1fa9
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt/install_invite.php"
+@@ -0,0 +1,156 @@
++<?php
++
++/**
++ *
++ * Invite. An extension for the phpBB Forum Software package.
++ *
++ * @copyright (c) 2010-2015, KillBill
++ * @copyright (c) 2017, kasimi
++ * @copyright (c) 2017-2022, Leinad4Mind, https://leinad4mind.top/forum
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
++// Some characters you may want to copy&paste: ’ « » „ “ ” …
++
++$lang = array_merge($lang, array(
++	'AUTH_CACHE_PURGE'						=> 'Clear permission cache',
++
++	'CACHE_PURGE'							=> 'Clear forum cache',
++	'CAT_INSTALL'							=> 'Install',
++	'CAT_OVERVIEW'							=> 'Overview',
++	'CAT_UNINSTALL'							=> 'Uninstall',
++	'CAT_UPDATE'							=> 'Update',
++	'CAT_VERIFY'							=> 'Verify',
++
++	'GPL'									=> 'General Public License',
++
++	'INCOMPLETE_FILES_UPLOAD'				=> 'All Invite files have not been uploaded! Please make sure to upload all files before running the installer.',
++	'INCOMPLETE_FILE_EDITS'					=> 'Editing of this file has not been done yet. The installation can not run unless all files are edited correctly!',
++	'INCOMPLETE_LANG_ROWS'					=> 'Some changes to the language files are missing. Please apply them as described %sHERE%s.',
++	'INSTALLATION'							=> 'phpBB Invite install',
++	'INSTALLATION_EXPLAIN'					=> '<br />phpBB Invite database install.<br /><br />',
++	'INSTALL_BODY'							=> 'Here you can see that the mod is well established and has been properly installed.',
++	'INSTALL_ERR_AUTH'						=> 'You are not authorized to use this script.<br /><br />Please note to use the script the following requirements must be met. First you must be logged in to the site and second you must have the user type founder. If you are logged in and are the founder then you have incorrect cookie settings in the ACP. Please check the cookie domain setting. If your site URL is <strong>http://www.example.com</strong> then the cookie domain should be <strong>.example.com</strong>.',
++	'INSTALL_FOLDER'						=> '<strong>Please delete the install folder. Until you have done this, only the ACP will be available.</strong>',
++	'INSTALL_LOGIN'							=> 'Proceed to ACP',
++
++	'INVITE_CONFIG_ADD'						=> 'Adding new invite config variable: %s',
++	'INVITE_CONFIG_ALREADY_EXISTS'			=> 'ERROR: Invite config variable %s already exists.',
++	'INVITE_CONFIG_NOT_EXIST'				=> 'ERROR: Invite config variable %s does not exist.',
++	'INVITE_CONFIG_REMOVE'					=> 'Removing Invite config variable: %s',
++	'INVITE_CONFIG_UPDATE'					=> 'Updating Invite config variable: %s',
++
++	'INVITE_INSTALL_INTRO'					=> 'Welcome to phpBB Invite Installation',
++	'INVITE_INSTALL_INTRO_BODY'				=> 'With this option, it is possible to install phpBB Invite to your database.',
++
++	'INVITE_VERSION'						=> 'The installed phpBB Invite version is <b>%s</b>, this file can be used to update version <b>%s</b> to version <b>%s</b>. <br /> You first need to upgrade to version <b>%s</b> to run this update script!',
++
++	'NOT_INSTALL_DIR'						=> 'Cannot open the install folder!',
++	'NOT_LANGUAGE_DIR'						=> 'The language library is not available!',
++	'NOT_LANGUAGE_DIR_DIR'					=> 'The %s language directory cannot be found!',
++	'NOT_MODULE'							=> 'The installation modules are not available!',
++	'NOT_MODULE_OPEN'						=> '%s Module is not available!',
++	'NO_TABLE_DATA'							=> '<span style="color:#FF0000;">Error:</span> The table data is missing.',
++
++	'OVERVIEW_BODY'							=> 'Welcome!<br /><br />The installation system presents a complete guide how to install the mod, or remove and update it.<br />Continue with the selection menu... Select the appropriate option from the menu.',
++
++	'PARENT_NOT_EXIST'						=> '<span style="color:#FF0000;">Error:</span> The parent category which shows the new module does not exist.',
++	'PERMISSIONS_WARNING'					=> 'New permission settings have been added.  Check your permission settings and make sure that they are as you would like them.',
++	'PHPBB_INVITE_DONATE'					=> 'Please make a small donation to appreciate the hard work and many hours used to make the “phpBB Invite”.',
++	'PHPBB_INVITE_DONATE_TITLE'				=> 'phpBB Invite donation',
++	'PHPBB_VERSION'							=> 'Your phpBB version is <b>%s</b>, the phpBB Invite mod requires version <b>%s</b> to run!',
++	'PHP_VERSION_RUN'						=> 'The current PHP version is not supported, please update your PHP to version 4.3.3 or later before you run the installation.</b>',
++
++	'ROLE_NOT_EXIST'						=> '<span style="color:#FF0000;">Error:</span> this role is not in the database.',
++
++	'STAGE_INSTALL'							=> 'Install',
++	'STAGE_INTRO'							=> 'Intro',
++	'STAGE_UNINSTALL'						=> 'Delete the database',
++	'STAGE_VERIFY'							=> 'Verify',
++	'STAGE_VERIFY_FILE_EXPLAIN'				=> '<br />The mod files are successfully deleted.',
++	'SUB_INTRO'								=> 'Intro',
++	'SUB_LICENSE'							=> 'License',
++	'SUB_SUPPORT'							=> 'Support',
++	'SUCCESSES'								=> '<span style="color:#000;"><b>Successfully completed!</b></span>',
++	'SUPPORT_BODY'							=> 'Full support will be provided for the current release and development versions, all for free.<br />This includes:</p><ul><li>information</li><li>configuration</li><li>update older versions to the newest version</li></ul><p>I encourage everyone who is using an older version to upgrade to the new version.</p><h2>Support forums</h2><br /><p><a href="http://jatek-vilag.com/viewtopic.php?p=204#p204" onclick="window.open(this.href); return false;">The main development site</a><br /><a href="https://www.phpbb.com/community/viewtopic.php?p=12855248#p12855248" onclick="window.open(this.href); return false;">phpBB.com Development topic</a><br /><a href="http://phpbb.hu/forum/hsz/40666#hsz-40666" onclick="window.open(this.href); return false;">phpBB.hu Development topic</a><br /><br />',
++
++	'UNINSTALL_BODY'						=> 'Here you can see that the mod database entries have been successfully removed.<br /><br /><b>Please delete the install folder. Until you have done this, only the ACP will be available.</b>',
++	'UNINSTALL_INTRO'						=> 'phpBB Invite delete',
++	'UNINSTALL_INTRO_BODY'					=> 'Under this option, you can delete the phpBB Invite from the database.',
++	'UNINSTALL_TITLE'						=> 'phpBB Invite deleted from the database',
++	'UPDATE_BODY'							=> 'Here you can see that database data created by this mod has been properly updated.<br /><br /><b>Please delete the install folder. Until you have done this, only the ACP will be available.</b>',
++	'UPDATE_INSTALLATION'					=> 'phpBB Invite update',
++	'UPDATE_INSTALLATION_EXPLAIN'			=> '<br />phpBB Invite update on the newest version.<br />',
++	'UPDATE_TITLE'							=> 'Updating database data',
++
++	'VERIFY_ERROR_EXPLAIN'					=> 'The check found an error.',
++	'VERIFY_ERROR_FILE'						=> 'Bad file modification',
++	'VERIFY_ERROR_FILE_EXPLAIN'				=> 'Here you can see those files which have been incorrectly edited or has been omitted.',
++	'VERIFY_EXITS_PRINT_MYAD'				=> '<br />The SQL command you see here you can install by yourself, if you load it in phpMyAdmin.',
++	'VERIFY_EXITS_PRINT_SQL'				=> '<b><span style="color:#FF0000;">%s</span> <span style="color:#000;">not found!</span></b><br />%s<br />',
++	'VERIFY_INVITE_MOD_CONFIG'				=> 'phpBB Invite configuration',
++	'VERIFY_INVITE_MOD_CONFIG_OK'			=> '<span style="color:#228822;"><strong>All phpBB Invite config found.</strong></span>',
++	'VERIFY_INVITE_MOD_FILES'				=> 'phpBB Invite files',
++	'VERIFY_INVITE_MOD_FILES_OK'			=> '<span style="color:#228822;"><strong>All files found.</strong></span>',
++	'VERIFY_INVITE_MOD_MODULES'				=> 'phpBB Invite modules',
++	'VERIFY_INVITE_MOD_MODULES_OK'			=> '<span style="color:#228822;"><strong>All modules found.</strong></span>',
++	'VERIFY_INVITE_MOD_PERM'				=> 'phpBB Invite permissions',
++	'VERIFY_INVITE_MOD_PERM_OK'				=> '<span style="color:#228822;"><strong>All permissions found.</strong></span>',
++	'VERIFY_INVITE_MOD_TABLES'				=> 'phpBB Invite tables',
++	'VERIFY_INVITE_MOD_TABLES_OK'			=> '<span style="color:#228822;"><strong>All tables found.</strong></span>',
++	'VERIFY_NOT_AC_FOUND'					=> '<b><span style="color:#FF0000;">%s</span> <span style="color:#000;">not found!</span></b>',
++	'VERIFY_NOT_COLUMN'						=> 'Missing columns',
++	'VERIFY_NOT_COLUMN_EXPLAIN'				=> 'Here you can see all the columns which were not installed.',
++	'VERIFY_NOT_CONFIG'						=> 'Missing config',
++	'VERIFY_NOT_CONFIG_EXPLAIN'				=> 'Here you can see the config files which have not been installed.',
++	'VERIFY_NOT_FILE'						=> 'Missing files',
++	'VERIFY_NOT_FILE_EXPLAIN'				=> 'Here you can see the files that have not been uploaded correctly or have been uploaded correctly but to the wrong place.',
++	'VERIFY_NOT_INVITE_CONFIG'				=> 'Missing phpBB Invite config',
++	'VERIFY_NOT_INVITE_CONFIG_EXPLAIN'		=> 'Here you can see the phpBB Invite config files which have not been installed.',
++	'VERIFY_NOT_MODULE'						=> 'Missing modules',
++	'VERIFY_NOT_MODULE_EXPLAIN'				=> 'Here you can see the modules which have not been installed.',
++	'VERIFY_NOT_PERMIS'						=> 'Missing permissions',
++	'VERIFY_NOT_PERMIS_EXPLAIN'				=> 'Here you can see the permissions that were not installed.',
++	'VERIFY_NOT_TABLE'						=> 'Missing table',
++	'VERIFY_NOT_TABLE_EXPLAIN'				=> 'Here you can see the signs which have not been installed.',
++	'VERIFY_NO_COLUMN'						=> '<b><span style="color:#FF0000;">%s</span> <span style="color:#000;">column not found!</span></b><br />%s<br />',
++	'VERIFY_NO_MODULE'						=> '<b><span style="color:#FF0000;">%s</span> <span style="color:#000;">module is not found in the database!</span></b>',
++	'VERIFY_NO_PERMIS'						=> '<b><span style="color:#FF0000;">%s</span> <span style="color:#000;">permission is not found in the database!</span></b>',
++	'VERIFY_NO_TABLE'						=> '<b><span style="color:#FF0000;">%s</span> <span style="color:#000;">table is not found in the database!</span></b>%s',
++	'VERIFY_PHPBB_MOD_COLUMNS'				=> 'phpBB users table new columns',
++	'VERIFY_PHPBB_MOD_COLUMNS_OK'			=> '<span style="color:#228822;"><strong>All columns found.</strong></span>',
++	'VERIFY_PHPBB_MOD_CONFIG'				=> 'phpBB new config',
++	'VERIFY_PHPBB_MOD_CONFIG_OK'			=> '<span style="color:#228822;"><strong>phpBB config found.</strong></span>',
++	'VERIFY_PHPBB_MOD_FILES'				=> 'phpBB file edits',
++	'VERIFY_PHPBB_MOD_FILES_OK'				=> '<span style="color:#228822;"><strong>All files are edited.</strong></span>',
++	'VERIFY_SUCCESSES_EXPLAIN'				=> 'The check found everything okay.',
++	'VERIFY_TITLE'							=> 'phpBB Invite control',
++	'VERIFY_TITLE_ELL'						=> 'Control error',
++	'VERIFY_TITLE_ELL_EXPLAIN'				=> '<span style="color:#000;"><b>Here you can see all occurred errors to fix everything carefully!</b></span>',
++	'VERIFY_TITLE_EXPLAIN'					=> '<br />Here you can check whether all required file changes, configuration changes and database entries have been made successfully.',
++	'VERIFY_NEW'							=> 'Check again',
++	'VERIFY_UNINSTALL_ERROR_FILE'			=> 'Existing files',
++	'VERIFY_UNINSTALL_ERROR_FILE_EXPLAIN'	=> 'Here you can see the files which have not been removed.',
++));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/language/pt_pt/invite.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt/invite.php"
+similarity index 97%
+rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/language/pt_pt/invite.php"
+rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt/invite.php"
+index 35b3be28c..07794c344 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/language/pt_pt/invite.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt/invite.php"
+@@ -36,6 +36,7 @@ if (empty($lang) || !is_array($lang))
+ 
+ $lang = array_merge($lang, array(
+ 	'INVITE'								=> 'Convites',
++	'INVITE_INFO'								=> 'Informação sobre Convites',
+ 	'INVITE_DELETE_CONFIRM'					=> 'Se quiseres apagar o convite, clica %sAQUI%s.',
+ 	'INVITE_DELETE_SUCCESS'					=> 'O teu convite foi apagados com sucesso.',
+ 	'INVITE_DELETE_SUCCESSES'				=> 'Os teus convites foram apagados com sucesso.',
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/language/pt_pt/permissions_invite.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt/permissions_invite.php"
+similarity index 96%
+rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/language/pt_pt/permissions_invite.php"
+rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt/permissions_invite.php"
+index 62e5529e0..90f45e670 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/language/pt_pt/permissions_invite.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt/permissions_invite.php"
+@@ -45,7 +45,7 @@ $lang = array_merge($lang, array(
+ 	'ACL_M_INVITE_CLAIMING'	=> 'O utilizador pode aprovar um pedido de convite.',
+ 	'ACL_U_INVITE_DELETE'	=> 'O utilizador pode revogar convites<br /><em>O utilizador pode cancelar um convite que ele enviou.</em>',
+ 	'ACL_U_INVITE_REQUEST'	=> 'O utilizador pode solicitar convite',
+-	'ACL_U_INVITE_SEND'		=> 'O utilizador pode convidar novos membros para o site',
++	'ACL_U_INVITE_SENDING'		=> 'O utilizador pode convidar novos membros para o site',
+ 	'ACL_U_INVITE_MAX'		=> 'O utilizador tem convites ilimitados',
+ 	'ACL_U_INVITE_USERS'	=> 'O utilizador pode visualizar a lista de utilizadores convidados por outras pessoas.',
+ ));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/language/pt_br/info_acp_invite.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt_br/info_acp_invite.php"
+index 78982283a..a8b6d0607 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/language/pt_br/info_acp_invite.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt_br/info_acp_invite.php"
+@@ -70,10 +70,12 @@ $lang = array_merge($lang, array(
+ 	'ACP_INVITE_DELETE_USERS_CONFIRM'					=> 'Tem certeza de que deseja excluir os convites dos usuários selecionados?',
+ 	'ACP_INVITE_DELETE_USER_CONFIRM'					=> 'Tem certeza de que deseja excluir os convites do usuário selecionado?',
+ 	'ACP_INVITE_DISABLED'								=> 'O sistema de convite está desativado!',
+-	'ACP_INVITE_DENY'									=> 'Rejeição',
++	'ACP_INVITE_DENY'									=> 'Rejeitar',
+ 	'ACP_INVITE_EMAIL_BOARD_DISABLED'					=> '<strong>phpBB Invite:</strong> O envio de e-mails está desativado no momento!<br />Enquanto estiver desativado, os convites não devem funcionar. Se você quiser ativa-lo, você pode fazê-lo %sAQUI%s.',
+ 	'ACP_INVITE_EMAIL_DISABLED'							=> 'Envio de e-mails foi desativado, por favor, ative-o. %sVá às configurações de e-mail.%s ',
+ 	'ACP_INVITE_EMAIL_PRIORITY'							=> 'Prioridade do email de convite',
++	'ACP_INVITE_MEMBERSHIP_DAYS'						=> 'Número mínimo de dias de registo',
++	'ACP_INVITE_MEMBERSHIP_DAYS_EXPLAIN'				=> 'Número de dias que um usuário precisa ter para poder usar o sistema de convites. Colocar 0 para desativar e permitir uso imediato.',
+ 	'ACP_INVITE_ENABLE'									=> 'Ativar extensão de convite',
+ 	'ACP_INVITE_ENABLE_EXPLAIN'							=> 'Se você ativá-lo, a extensão do convite será usada.',
+ 	'ACP_INVITE_VALIDATION'								=> 'Tempo de expiração dos convites enviados',
+@@ -82,6 +84,12 @@ $lang = array_merge($lang, array(
+ 	'ACP_INVITE_GIFT_NUMBER_INVITES'					=> 'Número de convites presenteado',
+ 	'ACP_INVITE_GIFT_INVITED_USERS'						=> 'Usuários convidados',
+ 	'ACP_INVITE_GIFT_INVITED_USERS_EXPLAIN'				=> 'Os usuários receberão um convite de presente após esse número de usuários convidados.<br /><em>Se "0", essa função será desativada.</em>',
++	'ACP_INVITE_POSTS_GIFT_INVITES'						=> 'Convites por Intervalo',
++	'ACP_INVITE_POSTS_GIFT_INVITES_EXPLAIN'				=> 'Número de convites que um usuário irá receber após atingir o número de x mensagens. Colocar 0 para desativar.',
++	'ACP_INVITE_POSTS_GIFT_POSTS'						=> 'Intervalo de Mensagens',
++	'ACP_INVITE_POSTS_GIFT_POSTS_EXPLAIN'				=> 'O usuário irá receber a cada x mensagens o número de convites inserido no campo acima. Colocar 0 para desativar.',
++	'ACP_INVITE_POSTS_GIFT_LIMIT'						=> 'Limite do Intervalo',
++	'ACP_INVITE_POSTS_GIFT_LIMIT_EXPLAIN'				=> 'Número máximo de intervalos que um usuário irá receber convites. Por exemplo, colocar intervalo de 30 mensagens com limite de 3 vezes irá enviar convites quando o usuário atingir 30, 60 e 90 mensagens. Colocar 0 para desativar.',
+ 	'ACP_INVITE_GROUP'									=> 'Grupo de usuários convidados',
+ 	'ACP_INVITE_GROUP_ENABLED'							=> 'Ativar o uso de grupo',
+ 	'ACP_INVITE_GROUP_ENABLED_EXPLAIN'					=> 'If enabled, invited users will automatically be added to the selected group.',
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/language/pt_br/info_ucp_invite.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt_br/info_ucp_invite.php"
+index 93e7cd565..6f2ed71f8 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/language/pt_br/info_ucp_invite.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt_br/info_ucp_invite.php"
+@@ -39,6 +39,10 @@ $lang = array_merge($lang, array(
+ 
+ 	'UCP_CAT_INVITE'						=> 'phpBB Invite',
+ 	'UCP_INVITE'							=> 'Convites',
++	'UCP_INVITE_LABEL'						=> 'GoldTugAnime - Convite',
++	'UCP_INVITE_MESSAGE'					=> 'Bem-vindo à mais bela Comunidade de Animação em Português de Portugal!
++
++Esperamos que se divirta e que a animação nunca deixe de fazer parte da sua vida.',
+ 	'UCP_INVITE_DATA'						=> 'Detalhes de convites',
+ 	'UCP_INVITE_BACK'						=> '<br /><br />%sVoltar para o painel de controle do usuário%s',
+ 	'UCP_INVITE_DAYF'						=> 'Convites enviados hoje',
+@@ -82,7 +86,7 @@ $lang = array_merge($lang, array(
+ 	'UCP_INVITE_REQUEST_BUY_SUBT_EXPLAIN'	=> 'Digite o número de convites que você deseja comprar. O preço do convite é <b>%s %s</b>.<br />Você assume a responsabilidade por seu(s) usuário(s) convidado(s) se o(s) usuário(s) convidado(s) causar incidentes inapropriados.',	
+ 	'UCP_INVITE_REQUEST_BUY_SUCCESS'		=> 'A compra do convite foi bem-sucedida.',
+ 	'UCP_INVITE_REQUEST_BUY_TITLE'			=> 'Comprar convite.',
+-	'UCP_INVITE_REQUEST_DISABLED'			=> 'As solicitacões de convites estão desativadas!',
++	'UCP_INVITE_REQUEST_DISABLED'			=> 'As solicitações de convites estão desativadas!',
+ 	'UCP_INVITE_REQUEST_MAX'				=> 'Número máximo de pedidos: (%s) convite(s)!',
+ 	'UCP_INVITE_REQUEST_MESSAGE_NO_DB'		=> '<em>Não! Não houve necessidade.</em>',
+ 	'UCP_INVITE_REQUEST_MIN'				=> 'Número mínimo de convites solicitados: (1)',
+@@ -92,9 +96,11 @@ $lang = array_merge($lang, array(
+ 	'UCP_INVITE_REQUEST_SUBMIT'				=> 'Enviar pedido',
+ 	'UCP_INVITE_REQUEST_SUCC'				=> 'A solicitação de convite foi enviada com sucesso!',
+ 	'UCP_INVITE_REQUEST_SUCCS'				=> 'A solicitação de convites foram enviadas com sucesso!',
+-	'UCP_INVITE_REQUEST_TITLE'				=> 'Convites requisitados',
+-	'UCP_INVITE_REQUEST_TITLE_EXPLAIN'		=> 'Digite o número de convites que você deseja solicitar. Há um máximo de <b>(%s)</b> convites disponíveis.<br />Você assume total responsabilidade por seu(s) usuário(s) convidado(s) se eles se comportarem de maneira inapropriada.',
++	'UCP_INVITE_REQUEST_TITLE'				=> 'Requisitar convites',
++	'UCP_INVITE_REQUEST_TITLE_EXPLAIN'		=> 'Digite o número de convites que você deseja solicitar. Há um máximo de <b>(%s)</b> convites disponíveis.',
++	'UCP_INVITE_REQUEST_COST'				=> '<div class="invitation_tred alert alert-danger">O preço por convite é de <b>50.000 pontos</b>.</div>',
+ 	'UCP_INVITE_SEND'						=> 'Enviar convite',
++	'UCP_INVITE_SEND_EXPLAIN'			=> '<div class="invitation_tred alert alert-danger">Você assume parte da responsabilidade dos usuários convidados caso eles se comportarem de maneira inapropriada.</div>',
+ 	'UCP_INVITE_SEND_EMAIL_MAX'				=> 'Máximo de %s endereços de e-mail podem ser usados. No entanto, você listou %s!', 
+ 	'UCP_INVITE_SEND_MAX'					=> '<span class="invitation_tred">Atualmente não há limite!</span>',
+ 	'UCP_INVITE_LAST_ACTIVE'				=> 'Última visita',
+@@ -108,6 +114,7 @@ $lang = array_merge($lang, array(
+ 	'UCP_INVITE_NO_LOGIN'					=> 'Ele/ela não se registrou neste site.',
+ 	'UCP_INVITE_NO_PERM'					=> 'Você não está autorizado a enviar convites!',
+ 	'UCP_INVITE_NO_PERM_EMAIL'				=> 'Você não está autorizado a enviar e-mail!',
++	'UCP_INVITE_MEMBERSHIP_DAYS'			=> 'A sua conta tem de ter pelo menos %1$d dias antes que possa fazer uso do sistema de convite. Poderá utilizar a partir de %2$s.',
+ 	'UCP_INVITE_NO_REG'						=> 'Ninguém foi convidado por você.',
+ 	'UCP_INVITE_NULL'						=> 'Você não tem convites!  <em>Porque não comprar alguns?</em>', 
+ 	'UCP_INVITE_POINTS_AMOUNT'				=> 'Presente',
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt_br/install_invite.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt_br/install_invite.php"
+new file mode 100644
+index 000000000..dd11b1fa9
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt_br/install_invite.php"
+@@ -0,0 +1,156 @@
++<?php
++
++/**
++ *
++ * Invite. An extension for the phpBB Forum Software package.
++ *
++ * @copyright (c) 2010-2015, KillBill
++ * @copyright (c) 2017, kasimi
++ * @copyright (c) 2017-2022, Leinad4Mind, https://leinad4mind.top/forum
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
++// Some characters you may want to copy&paste: ’ « » „ “ ” …
++
++$lang = array_merge($lang, array(
++	'AUTH_CACHE_PURGE'						=> 'Clear permission cache',
++
++	'CACHE_PURGE'							=> 'Clear forum cache',
++	'CAT_INSTALL'							=> 'Install',
++	'CAT_OVERVIEW'							=> 'Overview',
++	'CAT_UNINSTALL'							=> 'Uninstall',
++	'CAT_UPDATE'							=> 'Update',
++	'CAT_VERIFY'							=> 'Verify',
++
++	'GPL'									=> 'General Public License',
++
++	'INCOMPLETE_FILES_UPLOAD'				=> 'All Invite files have not been uploaded! Please make sure to upload all files before running the installer.',
++	'INCOMPLETE_FILE_EDITS'					=> 'Editing of this file has not been done yet. The installation can not run unless all files are edited correctly!',
++	'INCOMPLETE_LANG_ROWS'					=> 'Some changes to the language files are missing. Please apply them as described %sHERE%s.',
++	'INSTALLATION'							=> 'phpBB Invite install',
++	'INSTALLATION_EXPLAIN'					=> '<br />phpBB Invite database install.<br /><br />',
++	'INSTALL_BODY'							=> 'Here you can see that the mod is well established and has been properly installed.',
++	'INSTALL_ERR_AUTH'						=> 'You are not authorized to use this script.<br /><br />Please note to use the script the following requirements must be met. First you must be logged in to the site and second you must have the user type founder. If you are logged in and are the founder then you have incorrect cookie settings in the ACP. Please check the cookie domain setting. If your site URL is <strong>http://www.example.com</strong> then the cookie domain should be <strong>.example.com</strong>.',
++	'INSTALL_FOLDER'						=> '<strong>Please delete the install folder. Until you have done this, only the ACP will be available.</strong>',
++	'INSTALL_LOGIN'							=> 'Proceed to ACP',
++
++	'INVITE_CONFIG_ADD'						=> 'Adding new invite config variable: %s',
++	'INVITE_CONFIG_ALREADY_EXISTS'			=> 'ERROR: Invite config variable %s already exists.',
++	'INVITE_CONFIG_NOT_EXIST'				=> 'ERROR: Invite config variable %s does not exist.',
++	'INVITE_CONFIG_REMOVE'					=> 'Removing Invite config variable: %s',
++	'INVITE_CONFIG_UPDATE'					=> 'Updating Invite config variable: %s',
++
++	'INVITE_INSTALL_INTRO'					=> 'Welcome to phpBB Invite Installation',
++	'INVITE_INSTALL_INTRO_BODY'				=> 'With this option, it is possible to install phpBB Invite to your database.',
++
++	'INVITE_VERSION'						=> 'The installed phpBB Invite version is <b>%s</b>, this file can be used to update version <b>%s</b> to version <b>%s</b>. <br /> You first need to upgrade to version <b>%s</b> to run this update script!',
++
++	'NOT_INSTALL_DIR'						=> 'Cannot open the install folder!',
++	'NOT_LANGUAGE_DIR'						=> 'The language library is not available!',
++	'NOT_LANGUAGE_DIR_DIR'					=> 'The %s language directory cannot be found!',
++	'NOT_MODULE'							=> 'The installation modules are not available!',
++	'NOT_MODULE_OPEN'						=> '%s Module is not available!',
++	'NO_TABLE_DATA'							=> '<span style="color:#FF0000;">Error:</span> The table data is missing.',
++
++	'OVERVIEW_BODY'							=> 'Welcome!<br /><br />The installation system presents a complete guide how to install the mod, or remove and update it.<br />Continue with the selection menu... Select the appropriate option from the menu.',
++
++	'PARENT_NOT_EXIST'						=> '<span style="color:#FF0000;">Error:</span> The parent category which shows the new module does not exist.',
++	'PERMISSIONS_WARNING'					=> 'New permission settings have been added.  Check your permission settings and make sure that they are as you would like them.',
++	'PHPBB_INVITE_DONATE'					=> 'Please make a small donation to appreciate the hard work and many hours used to make the “phpBB Invite”.',
++	'PHPBB_INVITE_DONATE_TITLE'				=> 'phpBB Invite donation',
++	'PHPBB_VERSION'							=> 'Your phpBB version is <b>%s</b>, the phpBB Invite mod requires version <b>%s</b> to run!',
++	'PHP_VERSION_RUN'						=> 'The current PHP version is not supported, please update your PHP to version 4.3.3 or later before you run the installation.</b>',
++
++	'ROLE_NOT_EXIST'						=> '<span style="color:#FF0000;">Error:</span> this role is not in the database.',
++
++	'STAGE_INSTALL'							=> 'Install',
++	'STAGE_INTRO'							=> 'Intro',
++	'STAGE_UNINSTALL'						=> 'Delete the database',
++	'STAGE_VERIFY'							=> 'Verify',
++	'STAGE_VERIFY_FILE_EXPLAIN'				=> '<br />The mod files are successfully deleted.',
++	'SUB_INTRO'								=> 'Intro',
++	'SUB_LICENSE'							=> 'License',
++	'SUB_SUPPORT'							=> 'Support',
++	'SUCCESSES'								=> '<span style="color:#000;"><b>Successfully completed!</b></span>',
++	'SUPPORT_BODY'							=> 'Full support will be provided for the current release and development versions, all for free.<br />This includes:</p><ul><li>information</li><li>configuration</li><li>update older versions to the newest version</li></ul><p>I encourage everyone who is using an older version to upgrade to the new version.</p><h2>Support forums</h2><br /><p><a href="http://jatek-vilag.com/viewtopic.php?p=204#p204" onclick="window.open(this.href); return false;">The main development site</a><br /><a href="https://www.phpbb.com/community/viewtopic.php?p=12855248#p12855248" onclick="window.open(this.href); return false;">phpBB.com Development topic</a><br /><a href="http://phpbb.hu/forum/hsz/40666#hsz-40666" onclick="window.open(this.href); return false;">phpBB.hu Development topic</a><br /><br />',
++
++	'UNINSTALL_BODY'						=> 'Here you can see that the mod database entries have been successfully removed.<br /><br /><b>Please delete the install folder. Until you have done this, only the ACP will be available.</b>',
++	'UNINSTALL_INTRO'						=> 'phpBB Invite delete',
++	'UNINSTALL_INTRO_BODY'					=> 'Under this option, you can delete the phpBB Invite from the database.',
++	'UNINSTALL_TITLE'						=> 'phpBB Invite deleted from the database',
++	'UPDATE_BODY'							=> 'Here you can see that database data created by this mod has been properly updated.<br /><br /><b>Please delete the install folder. Until you have done this, only the ACP will be available.</b>',
++	'UPDATE_INSTALLATION'					=> 'phpBB Invite update',
++	'UPDATE_INSTALLATION_EXPLAIN'			=> '<br />phpBB Invite update on the newest version.<br />',
++	'UPDATE_TITLE'							=> 'Updating database data',
++
++	'VERIFY_ERROR_EXPLAIN'					=> 'The check found an error.',
++	'VERIFY_ERROR_FILE'						=> 'Bad file modification',
++	'VERIFY_ERROR_FILE_EXPLAIN'				=> 'Here you can see those files which have been incorrectly edited or has been omitted.',
++	'VERIFY_EXITS_PRINT_MYAD'				=> '<br />The SQL command you see here you can install by yourself, if you load it in phpMyAdmin.',
++	'VERIFY_EXITS_PRINT_SQL'				=> '<b><span style="color:#FF0000;">%s</span> <span style="color:#000;">not found!</span></b><br />%s<br />',
++	'VERIFY_INVITE_MOD_CONFIG'				=> 'phpBB Invite configuration',
++	'VERIFY_INVITE_MOD_CONFIG_OK'			=> '<span style="color:#228822;"><strong>All phpBB Invite config found.</strong></span>',
++	'VERIFY_INVITE_MOD_FILES'				=> 'phpBB Invite files',
++	'VERIFY_INVITE_MOD_FILES_OK'			=> '<span style="color:#228822;"><strong>All files found.</strong></span>',
++	'VERIFY_INVITE_MOD_MODULES'				=> 'phpBB Invite modules',
++	'VERIFY_INVITE_MOD_MODULES_OK'			=> '<span style="color:#228822;"><strong>All modules found.</strong></span>',
++	'VERIFY_INVITE_MOD_PERM'				=> 'phpBB Invite permissions',
++	'VERIFY_INVITE_MOD_PERM_OK'				=> '<span style="color:#228822;"><strong>All permissions found.</strong></span>',
++	'VERIFY_INVITE_MOD_TABLES'				=> 'phpBB Invite tables',
++	'VERIFY_INVITE_MOD_TABLES_OK'			=> '<span style="color:#228822;"><strong>All tables found.</strong></span>',
++	'VERIFY_NOT_AC_FOUND'					=> '<b><span style="color:#FF0000;">%s</span> <span style="color:#000;">not found!</span></b>',
++	'VERIFY_NOT_COLUMN'						=> 'Missing columns',
++	'VERIFY_NOT_COLUMN_EXPLAIN'				=> 'Here you can see all the columns which were not installed.',
++	'VERIFY_NOT_CONFIG'						=> 'Missing config',
++	'VERIFY_NOT_CONFIG_EXPLAIN'				=> 'Here you can see the config files which have not been installed.',
++	'VERIFY_NOT_FILE'						=> 'Missing files',
++	'VERIFY_NOT_FILE_EXPLAIN'				=> 'Here you can see the files that have not been uploaded correctly or have been uploaded correctly but to the wrong place.',
++	'VERIFY_NOT_INVITE_CONFIG'				=> 'Missing phpBB Invite config',
++	'VERIFY_NOT_INVITE_CONFIG_EXPLAIN'		=> 'Here you can see the phpBB Invite config files which have not been installed.',
++	'VERIFY_NOT_MODULE'						=> 'Missing modules',
++	'VERIFY_NOT_MODULE_EXPLAIN'				=> 'Here you can see the modules which have not been installed.',
++	'VERIFY_NOT_PERMIS'						=> 'Missing permissions',
++	'VERIFY_NOT_PERMIS_EXPLAIN'				=> 'Here you can see the permissions that were not installed.',
++	'VERIFY_NOT_TABLE'						=> 'Missing table',
++	'VERIFY_NOT_TABLE_EXPLAIN'				=> 'Here you can see the signs which have not been installed.',
++	'VERIFY_NO_COLUMN'						=> '<b><span style="color:#FF0000;">%s</span> <span style="color:#000;">column not found!</span></b><br />%s<br />',
++	'VERIFY_NO_MODULE'						=> '<b><span style="color:#FF0000;">%s</span> <span style="color:#000;">module is not found in the database!</span></b>',
++	'VERIFY_NO_PERMIS'						=> '<b><span style="color:#FF0000;">%s</span> <span style="color:#000;">permission is not found in the database!</span></b>',
++	'VERIFY_NO_TABLE'						=> '<b><span style="color:#FF0000;">%s</span> <span style="color:#000;">table is not found in the database!</span></b>%s',
++	'VERIFY_PHPBB_MOD_COLUMNS'				=> 'phpBB users table new columns',
++	'VERIFY_PHPBB_MOD_COLUMNS_OK'			=> '<span style="color:#228822;"><strong>All columns found.</strong></span>',
++	'VERIFY_PHPBB_MOD_CONFIG'				=> 'phpBB new config',
++	'VERIFY_PHPBB_MOD_CONFIG_OK'			=> '<span style="color:#228822;"><strong>phpBB config found.</strong></span>',
++	'VERIFY_PHPBB_MOD_FILES'				=> 'phpBB file edits',
++	'VERIFY_PHPBB_MOD_FILES_OK'				=> '<span style="color:#228822;"><strong>All files are edited.</strong></span>',
++	'VERIFY_SUCCESSES_EXPLAIN'				=> 'The check found everything okay.',
++	'VERIFY_TITLE'							=> 'phpBB Invite control',
++	'VERIFY_TITLE_ELL'						=> 'Control error',
++	'VERIFY_TITLE_ELL_EXPLAIN'				=> '<span style="color:#000;"><b>Here you can see all occurred errors to fix everything carefully!</b></span>',
++	'VERIFY_TITLE_EXPLAIN'					=> '<br />Here you can check whether all required file changes, configuration changes and database entries have been made successfully.',
++	'VERIFY_NEW'							=> 'Check again',
++	'VERIFY_UNINSTALL_ERROR_FILE'			=> 'Existing files',
++	'VERIFY_UNINSTALL_ERROR_FILE_EXPLAIN'	=> 'Here you can see the files which have not been removed.',
++));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/language/pt_br/permissions_invite.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt_br/permissions_invite.php"
+index 2341f4d0e..4c36d3661 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/language/pt_br/permissions_invite.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt_br/permissions_invite.php"
+@@ -45,7 +45,7 @@ $lang = array_merge($lang, array(
+ 	'ACL_M_INVITE_CLAIMING'	=> 'O usuário pode aprovar um pedido de convite.',
+ 	'ACL_U_INVITE_DELETE'	=> 'O usuário pode revogar convite<br /><em>O usuário pode cancelar um convite que ele enviou.</em>',
+ 	'ACL_U_INVITE_REQUEST'	=> 'O usuário pode solicitar convite',
+-	'ACL_U_INVITE_SEND'		=> 'O usuário pode convidar novos membros para o site',
++	'ACL_U_INVITE_SENDING'		=> 'O usuário pode convidar novos membros para o site',
+ 	'ACL_U_INVITE_MAX'		=> 'O usuário tem convites ilimitados',
+ 	'ACL_U_INVITE_USERS'	=> 'O usuário pode visualizar a lista de usuários convidados por outras pessoas.',
+ ));
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt_preao/common.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt_preao/common.php"
+new file mode 100644
+index 000000000..abff06760
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt_preao/common.php"
+@@ -0,0 +1,52 @@
++<?php
++
++/**
++ *
++ * Invite. An extension for the phpBB Forum Software package.
++ * Brazilian Portuguese translation by eunaumtenhoid [2019][ver 4.2.0] (https://github.com/phpBBTraducoes)
++ * @copyright (c) 2010-2015, KillBill
++ * @copyright (c) 2017, kasimi
++ * @copyright (c) 2017-2022, Leinad4Mind, https://leinad4mind.top/forum
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
++// Some characters you may want to copy&paste: ’ « » „ “ ” …
++
++$lang = array_merge($lang, array(
++	'INVITE_BIRTHDAY'						=> 'Parabéns! Recebeste %s convite(s) para o teu aniversário.<br /><br />Desejamos-te um feliz aniversário!', 
++
++	'INVITE_GIFT_INVITED_USERS_FIRST'		=> 'Olá, esta é uma mensagem que se recebe por convidar o utilizador %s para o site “%s”, por isso estamos muito gratos. Queremos que continues a usar o sistema de convite, para que recebas %s convites adicionais.<br /><br />Desejamos-te um momento agradável.',
++	
++	'INVITE_GIFT_INVITED_USERS_FURTHER'		=> 'Olá, esta é uma mensagem que se recebe por convidar mais %s utilizadores para o site “%s”, por isso estamos muito gratos. Queremos que continues a usar o sistema de convite, para que recebas %s convites adicionais.<br /><br />Desejamos-te um momento agradável.',
++
++	'INVITE_PETITION_TITLE'					=> 'Solicitação de convite',
++	'INVITE_PETITIONS_NO'					=> 'A tua solicitação não foi aprovada, portanto, os convites não te serão creditados!',
++	'INVITE_PETITION_NO'					=> 'A tua solicitação não foi aprovada, então o convite não te será creditado!',
++	'INVITE_PETITION_YES'					=> 'A tua solicitação foi aprovada, %s convite(s) creditado(s)!', 
++
++	'INVITE_PETITION_REQUEST'				=> 'O utilizador %s está a solicitar %d convite(s)', 
++
++	'INVITE_JOIN'							=> 'Obrigado por convidares o utilizador %s',
++));
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt_preao/email/user_invite.txt" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt_preao/email/user_invite.txt"
+new file mode 100644
+index 000000000..dd6c34656
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt_preao/email/user_invite.txt"
+@@ -0,0 +1,21 @@
++O utilizador {USERNAME} convidou-te para te registares no site "{SITENAME}".
++Podes clicar no link abaixo para criares conta.
++
++{U_ACTIVATE}
++
++A data de expiração deste convite é ({INVITE_TIME_END}). Quando o período de expiração terminar o teu convite ficará inválido!
++
++Se quiseres recusar este convite, simplesmente ignora este e-mail ou clica no link abaixo para excluí-lo:
++{U_DEACTIVATE}
++
++Mensagem de {USERNAME}:
++~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
++{MESSAGE}
++~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
++Se a mensagem acima te for ofensiva ou contiver comentários ofensivos, entra em contacto com o administrador do site no
++seguinte endereço de e-mail: {BOARD_CONTACT}
++Anexa esta mensagem ao e-mail (certifica-te de incluir o cabeçalho do e-mail).
++O endereço de retorno deste e-mail está definido para o endereço de e-mail de {USERNAME}, para que eles recebam a tua resposta.
++--------------------------------------
++
++Link do site: {U_BOARD}
+\ No newline at end of file
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt_preao/email/user_invite_request.txt" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt_preao/email/user_invite_request.txt"
+new file mode 100644
+index 000000000..d9e42b875
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt_preao/email/user_invite_request.txt"
+@@ -0,0 +1,7 @@
++Recebeste uma solicitação de convites adicionais do utilizador {USERNAME}.
++Ele solicitou {INVITE_NUMBER} convite(s).
++
++~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
++
++Link do site: {U_BOARD}
++Contacto: {BOARD_CONTACT}
+\ No newline at end of file
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt_preao/email/user_invites.txt" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt_preao/email/user_invites.txt"
+new file mode 100644
+index 000000000..5ec678fa3
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt_preao/email/user_invites.txt"
+@@ -0,0 +1,21 @@
++O utilizador {USERNAME} convidou-te para te registares no site "{SITENAME}".
++Podes clicar nos links abaixo para criares conta.
++
++{U_ACTIVATE}
++
++A data de expiração destes convites é ({INVITE_TIME_END}). Quando o período de expiração terminar os teus convites ficarão inválidos!
++
++Se quiseres recusar estes convites, simplesmente ignora este e-mail ou clica no link abaixo para excluí-los:
++{U_DEACTIVATE}
++
++Mensagem de {USERNAME}:
++~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
++{MESSAGE}
++~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
++Se a mensagem acima te for ofensiva ou contiver comentários ofensivos, entra em contacto com o administrador do site no
++seguinte endereço de e-mail: {BOARD_CONTACT}
++Anexa esta mensagem ao e-mail (certifica-te de incluir o cabeçalho do e-mail).
++O endereço de retorno deste e-mail está definido para o endereço de e-mail de {USERNAME}, para que eles recebam a tua resposta.
++--------------------------------------
++
++Link do site: {U_BOARD}
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/language/pt_pt/info_acp_invite.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt_preao/info_acp_invite.php"
+similarity index 93%
+rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/language/pt_pt/info_acp_invite.php"
+rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt_preao/info_acp_invite.php"
+index 41520ab7c..7f340bde1 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/language/pt_pt/info_acp_invite.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt_preao/info_acp_invite.php"
+@@ -45,7 +45,9 @@ $lang = array_merge($lang, array(
+ 	'ACP_INVITED_PEND_COUNT'							=> 'Todos Convites (%s)',
+ 	'ACP_INVITED_USERS_COUNT'							=> 'Todos os utilizadores (%s)',
+ 	'ACP_INVITE_ALL_USER_INVITE_MAX'					=> 'Convite ilimitado para todos',
+-	'ACP_INVITE_ALL_USER_INVITE_MAX_EXPLAIN'			=> 'se seleccionado, todos os utilizadores terão convites ilimitados.',
++	'ACP_INVITE_ALL_USER_INVITE_MAX_EXPLAIN'			=> 'Se sim, todos os utilizadores terão convites ilimitados.',
++	'ACP_INVITE_RESTORE_INVITES'						=> 'Restaurar convites expirados e recusados',
++	'ACP_INVITE_RESTORE_INVITES_EXPLAIN'				=> 'Caso um convite expire ou seja recusado deverá o convite ser novamente disponibilizado ao utilizador.',
+ 	'ACP_INVITE_BIRTHDAYS'								=> 'Aniversário',
+ 	'ACP_INVITE_BIRTHDAYS_EXPLAIN'						=> 'Podes definir quantos convites um utilizador receberá no seu aniversário. <em>Para que essa configuração tenha efeito, o recurso de aniversário também precisa ser activado.</em>',
+ 	'ACP_INVITE_CAPTCHA'								=> 'Confirmação visual',
+@@ -70,10 +72,12 @@ $lang = array_merge($lang, array(
+ 	'ACP_INVITE_DELETE_USERS_CONFIRM'					=> 'Tens a certeza de que desejas excluir os convites dos utilizadores seleccionados?',
+ 	'ACP_INVITE_DELETE_USER_CONFIRM'					=> 'Tens a certeza de que desejas excluir os convites do utilizador seleccionado?',
+ 	'ACP_INVITE_DISABLED'								=> 'O sistema de convite está desactivado!',
+-	'ACP_INVITE_DENY'									=> 'Rejeição',
++	'ACP_INVITE_DENY'									=> 'Rejeitar',
+ 	'ACP_INVITE_EMAIL_BOARD_DISABLED'					=> '<strong>phpBB Invite:</strong> O envio de e-mails está, de momento, desactivado!<br />Enquanto estiver desactivado, os convites não devem funcionar. Se quiseres activá-lo, podes fazê-lo %sAQUI%s.',
+ 	'ACP_INVITE_EMAIL_DISABLED'							=> 'Envio de e-mails foi desactivado, por favor, ative-o. %sVá às configurações de e-mail.%s ',
+ 	'ACP_INVITE_EMAIL_PRIORITY'							=> 'Prioridade do email de convite',
++	'ACP_INVITE_MEMBERSHIP_DAYS'						=> 'Número mínimo de dias de registo',
++	'ACP_INVITE_MEMBERSHIP_DAYS_EXPLAIN'				=> 'Número de dias que um utilizador precisa de ter para poder usar o sistema de convites. Colocar 0 para desactivar e permitir uso imediato.',
+ 	'ACP_INVITE_ENABLE'									=> 'Activar extensão de convite',
+ 	'ACP_INVITE_ENABLE_EXPLAIN'							=> 'Se o activares, a extensão do convite será usada.',
+ 	'ACP_INVITE_VALIDATION'								=> 'Tempo de expiração dos convites enviados',
+@@ -82,6 +86,12 @@ $lang = array_merge($lang, array(
+ 	'ACP_INVITE_GIFT_NUMBER_INVITES'					=> 'Número de convites presenteado',
+ 	'ACP_INVITE_GIFT_INVITED_USERS'						=> 'Utilizadores convidados',
+ 	'ACP_INVITE_GIFT_INVITED_USERS_EXPLAIN'				=> 'Os utilizadores receberão um convite de presente após esse número de utilizadores convidados.<br /><em>Se "0", essa função será desactivada.</em>',
++	'ACP_INVITE_POSTS_GIFT_INVITES'						=> 'Convites por Intervalo',
++	'ACP_INVITE_POSTS_GIFT_INVITES_EXPLAIN'				=> 'Número de convites que um utilizador irá receber após atingir o número de x mensagens. Colocar 0 para desactivar.',
++	'ACP_INVITE_POSTS_GIFT_POSTS'						=> 'Intervalo de Mensagens',
++	'ACP_INVITE_POSTS_GIFT_POSTS_EXPLAIN'				=> 'O utilizador irá receber a cada x mensagens o número de convites inserido no campo acima. Colocar 0 para desactivar.',
++	'ACP_INVITE_POSTS_GIFT_LIMIT'						=> 'Limite do Intervalo',
++	'ACP_INVITE_POSTS_GIFT_LIMIT_EXPLAIN'				=> 'Número máximo de intervalos que um utilizador irá receber convites. Por exemplo, colocar intervalo de 30 mensagens com limite de 3 vezes irá enviar convites quando o utilizador atingir 30, 60 e 90 mensagens. Colocar 0 para desactivar.',
+ 	'ACP_INVITE_GROUP'									=> 'Grupo de utilizadores convidados',
+ 	'ACP_INVITE_GROUP_ENABLED'							=> 'Activar o uso de grupo',
+ 	'ACP_INVITE_GROUP_ENABLED_EXPLAIN'					=> 'If enabled, invited users will automatically be added to the selected group.',
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt_preao/info_mcp_invite.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt_preao/info_mcp_invite.php"
+new file mode 100644
+index 000000000..b5c364c41
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt_preao/info_mcp_invite.php"
+@@ -0,0 +1,43 @@
++<?php
++
++/**
++ *
++ * Invite. An extension for the phpBB Forum Software package.
++ * Brazilian Portuguese translation by eunaumtenhoid [2019][ver 4.2.0] (https://github.com/phpBBTraducoes)
++ * @copyright (c) 2010-2015, KillBill
++ * @copyright (c) 2017, kasimi
++ * @copyright (c) 2017-2022, Leinad4Mind, https://leinad4mind.top/forum
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
++// Some characters you may want to copy&paste: ’ « » „ “ ” …
++
++$lang = array_merge($lang, array(
++	'MCP_CAT_INVITE'			=> 'phpBB Invite',
++	'MCP_INVITE'				=> 'Convite',
++	'MCP_INVITE_BACK'			=> '<br /><br />%sVoltar para o painel de controlo do moderador%s',
++	'MCP_INVITE_DISABLED'		=> '%sO sistema de convite foi desactivado!%s',
++	'MCP_INVITE_CONFIRMATION'	=> 'Solicitações de convite',
++));
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt_preao/info_ucp_invite.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt_preao/info_ucp_invite.php"
+new file mode 100644
+index 000000000..5f9f7062b
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt_preao/info_ucp_invite.php"
+@@ -0,0 +1,145 @@
++<?php
++
++/**
++ *
++ * Invite. An extension for the phpBB Forum Software package.
++ * Brazilian Portuguese translation by eunaumtenhoid [2019][ver 4.2.0] (https://github.com/phpBBTraducoes)
++ * @copyright (c) 2010-2015, KillBill
++ * @copyright (c) 2017, kasimi
++ * @copyright (c) 2017-2022, Leinad4Mind, https://leinad4mind.top/forum
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
++// Some characters you may want to copy&paste: ’ « » „ “ ” …
++
++$lang = array_merge($lang, array(
++	'POST_CONFIRM_EXPLAIN'					=> 'Digitar o código evita o convite automático de bots. Podes encontrar o código na imagem. Se não fores capaz de ler o código devido a problemas visuais ou outros, entra em contacto com o %sadministrador%s.',
++
++	'UCP_CAT_INVITE'						=> 'phpBB Invite',
++	'UCP_INVITE'							=> 'Convites',
++	'UCP_INVITE_LABEL'						=> 'GoldTugAnime - Convite',
++	'UCP_INVITE_MESSAGE'					=> 'Bem-vindo à mais bela Comunidade de Animação em Português de Portugal!
++
++Esperamos que te divirtas e que a animação nunca deixe de fazer parte da tua vida.',
++	'UCP_INVITE_DATA'						=> 'Detalhes de convites',
++	'UCP_INVITE_BACK'						=> '<br /><br />%sVoltar para o painel de controlo do utilizador%s',
++	'UCP_INVITE_DAYF'						=> 'Convites enviados hoje',
++	'UCP_INVITE_DAYF_EXPLAIN'				=> 'O número de convites que enviaste hoje.',
++	'UCP_INVITE_DAY_OFF'					=> 'Não estamos a aceitar mais convites hoje!',
++	'UCP_INVITE_DB'							=> '<b>%s convite(s).</b>',
++	'UCP_INVITE_DB_SEND'					=> 'Limite de convite diário',
++	'UCP_INVITE_DB_SEND_EXPLAIN'			=> 'Número máximo de convites por dia que podes enviar.',
++	'UCP_INVITE_DB_MAX'						=> '<span class="invitation_tred">Ilimitado!</span>',
++	'UCP_INVITE_DB_PENDING'					=> 'Convites pendentes',
++	'UCP_INVITE_DB_PENDING_EXPLAIN'			=> 'O número de utilizadores que convidaste e ainda não se registou.',
++	'UCP_INVITE_DB_NUMBER'					=> 'Número de convites',
++	'UCP_INVITE_DB_NUMBER_EXPLAIN'			=> 'O teu limite de convites restante',
++	'UCP_INVITE_DB_USER'					=> 'Utilizador convidado',
++	'UCP_INVITE_DB_USERS'					=> 'Utilizadores convidados',
++	'UCP_INVITE_DB_USERS_EXPLAIN'			=> 'Membros que convidaste.',
++	'UCP_INVITE_DB_USER_EXPLAIN'			=> 'Membro que convidaste.',
++	'UCP_INVITE_DELETE'						=> 'Apagar convite',
++	'UCP_INVITE_DELETE_EXPLAIN'				=> 'Se enviaste convites para os endereços errados, poderás revogar os mesmos aqui.<br /><em>Isso só é possível dentro de %s minutos após o envio do convite.</em>',	
++	'UCP_INVITE_DELETE_NO_CONFIRM'			=> 'A remoção não foi confirmada!',
++	'UCP_INVITE_DELETE_SUCCESS'				=> 'O convite foi apagado com sucesso.',
++	'UCP_INVITE_DISABLED'					=> '%sO sistema de convites está desactivado!%s',
++	'UCP_INVITE_DUP'						=> 'Já foi enviado um convite para o endereço de e-mail: %s',
++	'UCP_INVITE_EDUP'						=> 'Endereço de e-mail inserido repetidamente: %s',
++	'UCP_INVITE_EMAILS_SENT'				=> 'Os convites foram enviados com sucesso!',
++	'UCP_INVITE_EMAIL_LANG'					=> 'Idioma do e-mail',
++	'UCP_INVITE_EMAIL_REQUEST_EXPLAIN'		=> 'Razão para a solicitação de convites.',
++	'UCP_INVITE_EMAIL_SELECT'				=> 'Selecção de convite',
++	'UCP_INVITE_EMAIL_SELECT_EXPLAIN'		=> 'Escolhe qual dos destinatários desejas excluir.',
++	'UCP_INVITE_EMAIL_SENT'					=> 'O convite foi enviado com sucesso!',
++	'UCP_INVITE_FLOOD_LIMIT'				=> 'Não podes enviar mais convites. Por favor, tenta novamente mais tarde.',
++	'UCP_INVITE_FRIEND'						=> 'Adicionar um amigo',
++	'UCP_INVITE_FRIEND_EXPLAIN'				=> 'O utilizador convidado será adicionado à tua lista de amigos.',
++	'UCP_INVITE_DEP_LIMIT'					=> 'Apenas %s convites podem ser enviados hoje. No entanto, listaste %s destinatários.', 
++	'UCP_INVITE_REQUEST'					=> 'Solicitação de convites',
++	'UCP_INVITE_REQUEST_BUYS_SUCCESS'		=> 'Compraste convites com sucesso.',
++	'UCP_INVITE_REQUEST_BUY_MIN'			=> 'Mínimo (1) convite a ser comprado!',
++	'UCP_INVITE_REQUEST_BUY_NO'				=> 'Não tens %s suficiente para comprar essa quantidade de convites! Tens %s %s atualmente.',
++	'UCP_INVITE_REQUEST_BUY_SUBMIT'			=> 'Comprar',
++	'UCP_INVITE_REQUEST_BUY_SUBT'			=> 'Convites que desejas comprar',
++	'UCP_INVITE_REQUEST_BUY_SUBT_EXPLAIN'	=> 'Digita o número de convites que desejas comprar. O preço do convite é <b>%s %s</b>.<br />Assumes a responsabilidade pelo(s) teu(s) utilizador(es) convidado(s) se o(s) utilizador(es) convidado(s) causar(em) incidentes inapropriados.',
++	'UCP_INVITE_REQUEST_BUY_SUCCESS'		=> 'A compra do convite foi bem-sucedida.',
++	'UCP_INVITE_REQUEST_BUY_TITLE'			=> 'Comprar convite.',
++	'UCP_INVITE_REQUEST_DISABLED'			=> 'As solicitações de convites estão desactivadas!',
++	'UCP_INVITE_REQUEST_MAX'				=> 'Número máximo de pedidos: (%s) convite(s)!',
++	'UCP_INVITE_REQUEST_MESSAGE_NO_DB'		=> '<em>Não! Não houve necessidade.</em>',
++	'UCP_INVITE_REQUEST_MIN'				=> 'Número mínimo de convites solicitados: (1)',
++	'UCP_INVITE_REQUEST_NO_MESSAGE'			=> 'Não escreveste uma mensagem! Sem uma explicação não podes reivindicar tantos convites.',
++	'UCP_INVITE_REQUEST_OFF'				=> 'A tua solicitação de convite está pendente. Quando um administrador/moderador avaliar a tua solicitação, receberás uma notificação.',
++	'UCP_INVITE_REQUEST_SOK_EXPLAIN'		=> 'Ao enviar mais de <b>(%s)</b> pedidos, é necessária uma explicação para o administrador. Por favor, explica por que precisas de tantos convites.<br />Se acharmos que o teu pedido é aceitável, nós enviamos os convites. Se for um abuso, pode ser motivo para banir a tua conta.',	
++	'UCP_INVITE_REQUEST_SUBMIT'				=> 'Enviar pedido',
++	'UCP_INVITE_REQUEST_SUCC'				=> 'A solicitação de convite foi enviada com sucesso!',
++	'UCP_INVITE_REQUEST_SUCCS'				=> 'A solicitação de convites foram enviadas com sucesso!',
++	'UCP_INVITE_REQUEST_TITLE'				=> 'Requisitar convites',
++	'UCP_INVITE_REQUEST_TITLE_EXPLAIN'		=> 'Digita o número de convites que desejas solicitar. Há um máximo de <b>(%s)</b> convites disponíveis.',
++	'UCP_INVITE_REQUEST_COST'				=> '<div class="invitation_tred alert alert-danger">O preço por convite é de <b>50.000 pontos</b>.</div>',
++	'UCP_INVITE_SEND'						=> 'Enviar convite',
++	'UCP_INVITE_SEND_EXPLAIN'			=> '<div class="invitation_tred alert alert-danger">Assumes parte da responsabilidade dos utilizadores que convidares caso eles se comportarem de maneira inapropriada.</div>',
++	'UCP_INVITE_SEND_EMAIL_MAX'				=> 'Máximo de %s endereços de e-mail podem ser usados. No entanto, listaste %s!', 
++	'UCP_INVITE_SEND_MAX'					=> '<span class="invitation_tred">Actualmente não há limite!</span>',
++	'UCP_INVITE_LAST_ACTIVE'				=> 'Última visita',
++	'UCP_INVITE_MAX_ERROR'					=> 'Actualmente tens convites ilimitados.',
++	'UCP_INVITE_MAX_RECIPIENTS'				=> 'Digita todos os endereços numa nova linha! <br /> Número máximo de destinatários',
++	'UCP_INVITE_MESSAGE_BODY_EXPLAIN'		=> 'Escreve algumas linhas a explicar por que deveriam participar.',
++	'UCP_INVITE_NOT_DELETED_INVITE'			=> 'Não há convites para apagar!',
++	'UCP_INVITE_NOT_LANGUAGE'				=> 'Ficheiro de idioma inexistente: %s',
++	'UCP_INVITE_NO_EMAIL'					=> 'Não forneceste um endereço de e-mail!',
++	'UCP_INVITE_NO_INVITE_USERS'			=> 'Ainda não convidaste ninguém ou ainda não se registaram.',
++	'UCP_INVITE_NO_LOGIN'					=> 'Ele/ela não se registou neste site.',
++	'UCP_INVITE_NO_PERM'					=> 'Não está autorizado a enviar convites!',
++	'UCP_INVITE_NO_PERM_EMAIL'				=> 'Não está autorizado a enviar e-mail!',
++	'UCP_INVITE_MEMBERSHIP_DAYS'			=> 'A tua conta tem de ter pelo menos %1$d dias antes que possas fazer uso do sistema de convites. Poderás utilizar a partir de %2$s.',
++	'UCP_INVITE_NO_REG'						=> 'Ninguém foi convidado por ti.',
++	'UCP_INVITE_NULL'						=> 'Não tem convites! <em>Porque não comprar alguns?</em>', 
++	'UCP_INVITE_POINTS_AMOUNT'				=> 'Presente',
++	'UCP_INVITE_POINTS_AMOUNT_EXPLAIN'		=> 'Quantidade de pontos que o utilizador receberá quando ele convidar alguém e se essa pessoa convidada se tornar um membro registado.',
++	'UCP_INVITE_POINTS_COST'				=> 'Preço do convite',
++	'UCP_INVITE_POINTS_COST_EXPLAIN'		=> 'O custo do envio de um convite.',
++	'UCP_INVITE_POST_LIMIT'					=> 'Deves ter um mínimo de %s mensagens, para enviar convites!', 
++	'UCP_INVITE_REQUEST_SUBJECT'			=> 'Pedido de convite',
++	'UCP_INVITE_SDB'						=> 'convite(s).',
++	'UCP_INVITE_SEND_OFF'					=> 'O envio de convites está, de momento, desactivado!',
++	'UCP_INVITE_SEND_SUBMIT'				=> 'Enviar convite',
++	'UCP_INVITE_TIME_END'					=> 'Data de expiração',
++	'UCP_INVITE_TIME_END_EXPLAIN'			=> 'O utilizador convidado terá que se registar durante esse período.',
++	'UCP_INVITE_USER'						=> 'Utilizadores convidados',
++	'UCP_INVITE_USERS_COUNT'				=> 'Utilizadores convidados (%s)',
++	'UCP_INVITE_USER_OK'					=> 'Convite aceite',
++	'UCP_INVITE_LU_REG'						=> 'Último utilizador',
++	'UCP_INVITE_LU_REG_EXPLAIN'				=> 'Último utilizador dos seus convites.',
++	'UCP_INVITE_LU_REG_INFO'				=> '<b>%s</b> registado %s',
++
++	'WEEKS'									=> 'Semanas',
++
++	'NOTIFICATION_TYPE_INVITE_BIRTHDAY'			=> 'Recebeste convites para o teu aniversário',
++	'NOTIFICATION_TYPE_INVITE_GIFT'				=> 'Recebeste convites depois de convidar um utilizador com sucesso',
++	'NOTIFICATION_TYPE_INVITE_PETITION'			=> 'Recebeste uma resposta de uma solicitação de convite',
++	'NOTIFICATION_TYPE_INVITE_PETITION_REQUEST' => 'Recebeste uma solicitação de convite',
++	'NOTIFICATION_TYPE_INVITE_JOIN'				=> 'Um utilizador que convidaste criou uma conta',
++));
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt_preao/install_invite.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt_preao/install_invite.php"
+new file mode 100644
+index 000000000..dd11b1fa9
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt_preao/install_invite.php"
+@@ -0,0 +1,156 @@
++<?php
++
++/**
++ *
++ * Invite. An extension for the phpBB Forum Software package.
++ *
++ * @copyright (c) 2010-2015, KillBill
++ * @copyright (c) 2017, kasimi
++ * @copyright (c) 2017-2022, Leinad4Mind, https://leinad4mind.top/forum
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
++// Some characters you may want to copy&paste: ’ « » „ “ ” …
++
++$lang = array_merge($lang, array(
++	'AUTH_CACHE_PURGE'						=> 'Clear permission cache',
++
++	'CACHE_PURGE'							=> 'Clear forum cache',
++	'CAT_INSTALL'							=> 'Install',
++	'CAT_OVERVIEW'							=> 'Overview',
++	'CAT_UNINSTALL'							=> 'Uninstall',
++	'CAT_UPDATE'							=> 'Update',
++	'CAT_VERIFY'							=> 'Verify',
++
++	'GPL'									=> 'General Public License',
++
++	'INCOMPLETE_FILES_UPLOAD'				=> 'All Invite files have not been uploaded! Please make sure to upload all files before running the installer.',
++	'INCOMPLETE_FILE_EDITS'					=> 'Editing of this file has not been done yet. The installation can not run unless all files are edited correctly!',
++	'INCOMPLETE_LANG_ROWS'					=> 'Some changes to the language files are missing. Please apply them as described %sHERE%s.',
++	'INSTALLATION'							=> 'phpBB Invite install',
++	'INSTALLATION_EXPLAIN'					=> '<br />phpBB Invite database install.<br /><br />',
++	'INSTALL_BODY'							=> 'Here you can see that the mod is well established and has been properly installed.',
++	'INSTALL_ERR_AUTH'						=> 'You are not authorized to use this script.<br /><br />Please note to use the script the following requirements must be met. First you must be logged in to the site and second you must have the user type founder. If you are logged in and are the founder then you have incorrect cookie settings in the ACP. Please check the cookie domain setting. If your site URL is <strong>http://www.example.com</strong> then the cookie domain should be <strong>.example.com</strong>.',
++	'INSTALL_FOLDER'						=> '<strong>Please delete the install folder. Until you have done this, only the ACP will be available.</strong>',
++	'INSTALL_LOGIN'							=> 'Proceed to ACP',
++
++	'INVITE_CONFIG_ADD'						=> 'Adding new invite config variable: %s',
++	'INVITE_CONFIG_ALREADY_EXISTS'			=> 'ERROR: Invite config variable %s already exists.',
++	'INVITE_CONFIG_NOT_EXIST'				=> 'ERROR: Invite config variable %s does not exist.',
++	'INVITE_CONFIG_REMOVE'					=> 'Removing Invite config variable: %s',
++	'INVITE_CONFIG_UPDATE'					=> 'Updating Invite config variable: %s',
++
++	'INVITE_INSTALL_INTRO'					=> 'Welcome to phpBB Invite Installation',
++	'INVITE_INSTALL_INTRO_BODY'				=> 'With this option, it is possible to install phpBB Invite to your database.',
++
++	'INVITE_VERSION'						=> 'The installed phpBB Invite version is <b>%s</b>, this file can be used to update version <b>%s</b> to version <b>%s</b>. <br /> You first need to upgrade to version <b>%s</b> to run this update script!',
++
++	'NOT_INSTALL_DIR'						=> 'Cannot open the install folder!',
++	'NOT_LANGUAGE_DIR'						=> 'The language library is not available!',
++	'NOT_LANGUAGE_DIR_DIR'					=> 'The %s language directory cannot be found!',
++	'NOT_MODULE'							=> 'The installation modules are not available!',
++	'NOT_MODULE_OPEN'						=> '%s Module is not available!',
++	'NO_TABLE_DATA'							=> '<span style="color:#FF0000;">Error:</span> The table data is missing.',
++
++	'OVERVIEW_BODY'							=> 'Welcome!<br /><br />The installation system presents a complete guide how to install the mod, or remove and update it.<br />Continue with the selection menu... Select the appropriate option from the menu.',
++
++	'PARENT_NOT_EXIST'						=> '<span style="color:#FF0000;">Error:</span> The parent category which shows the new module does not exist.',
++	'PERMISSIONS_WARNING'					=> 'New permission settings have been added.  Check your permission settings and make sure that they are as you would like them.',
++	'PHPBB_INVITE_DONATE'					=> 'Please make a small donation to appreciate the hard work and many hours used to make the “phpBB Invite”.',
++	'PHPBB_INVITE_DONATE_TITLE'				=> 'phpBB Invite donation',
++	'PHPBB_VERSION'							=> 'Your phpBB version is <b>%s</b>, the phpBB Invite mod requires version <b>%s</b> to run!',
++	'PHP_VERSION_RUN'						=> 'The current PHP version is not supported, please update your PHP to version 4.3.3 or later before you run the installation.</b>',
++
++	'ROLE_NOT_EXIST'						=> '<span style="color:#FF0000;">Error:</span> this role is not in the database.',
++
++	'STAGE_INSTALL'							=> 'Install',
++	'STAGE_INTRO'							=> 'Intro',
++	'STAGE_UNINSTALL'						=> 'Delete the database',
++	'STAGE_VERIFY'							=> 'Verify',
++	'STAGE_VERIFY_FILE_EXPLAIN'				=> '<br />The mod files are successfully deleted.',
++	'SUB_INTRO'								=> 'Intro',
++	'SUB_LICENSE'							=> 'License',
++	'SUB_SUPPORT'							=> 'Support',
++	'SUCCESSES'								=> '<span style="color:#000;"><b>Successfully completed!</b></span>',
++	'SUPPORT_BODY'							=> 'Full support will be provided for the current release and development versions, all for free.<br />This includes:</p><ul><li>information</li><li>configuration</li><li>update older versions to the newest version</li></ul><p>I encourage everyone who is using an older version to upgrade to the new version.</p><h2>Support forums</h2><br /><p><a href="http://jatek-vilag.com/viewtopic.php?p=204#p204" onclick="window.open(this.href); return false;">The main development site</a><br /><a href="https://www.phpbb.com/community/viewtopic.php?p=12855248#p12855248" onclick="window.open(this.href); return false;">phpBB.com Development topic</a><br /><a href="http://phpbb.hu/forum/hsz/40666#hsz-40666" onclick="window.open(this.href); return false;">phpBB.hu Development topic</a><br /><br />',
++
++	'UNINSTALL_BODY'						=> 'Here you can see that the mod database entries have been successfully removed.<br /><br /><b>Please delete the install folder. Until you have done this, only the ACP will be available.</b>',
++	'UNINSTALL_INTRO'						=> 'phpBB Invite delete',
++	'UNINSTALL_INTRO_BODY'					=> 'Under this option, you can delete the phpBB Invite from the database.',
++	'UNINSTALL_TITLE'						=> 'phpBB Invite deleted from the database',
++	'UPDATE_BODY'							=> 'Here you can see that database data created by this mod has been properly updated.<br /><br /><b>Please delete the install folder. Until you have done this, only the ACP will be available.</b>',
++	'UPDATE_INSTALLATION'					=> 'phpBB Invite update',
++	'UPDATE_INSTALLATION_EXPLAIN'			=> '<br />phpBB Invite update on the newest version.<br />',
++	'UPDATE_TITLE'							=> 'Updating database data',
++
++	'VERIFY_ERROR_EXPLAIN'					=> 'The check found an error.',
++	'VERIFY_ERROR_FILE'						=> 'Bad file modification',
++	'VERIFY_ERROR_FILE_EXPLAIN'				=> 'Here you can see those files which have been incorrectly edited or has been omitted.',
++	'VERIFY_EXITS_PRINT_MYAD'				=> '<br />The SQL command you see here you can install by yourself, if you load it in phpMyAdmin.',
++	'VERIFY_EXITS_PRINT_SQL'				=> '<b><span style="color:#FF0000;">%s</span> <span style="color:#000;">not found!</span></b><br />%s<br />',
++	'VERIFY_INVITE_MOD_CONFIG'				=> 'phpBB Invite configuration',
++	'VERIFY_INVITE_MOD_CONFIG_OK'			=> '<span style="color:#228822;"><strong>All phpBB Invite config found.</strong></span>',
++	'VERIFY_INVITE_MOD_FILES'				=> 'phpBB Invite files',
++	'VERIFY_INVITE_MOD_FILES_OK'			=> '<span style="color:#228822;"><strong>All files found.</strong></span>',
++	'VERIFY_INVITE_MOD_MODULES'				=> 'phpBB Invite modules',
++	'VERIFY_INVITE_MOD_MODULES_OK'			=> '<span style="color:#228822;"><strong>All modules found.</strong></span>',
++	'VERIFY_INVITE_MOD_PERM'				=> 'phpBB Invite permissions',
++	'VERIFY_INVITE_MOD_PERM_OK'				=> '<span style="color:#228822;"><strong>All permissions found.</strong></span>',
++	'VERIFY_INVITE_MOD_TABLES'				=> 'phpBB Invite tables',
++	'VERIFY_INVITE_MOD_TABLES_OK'			=> '<span style="color:#228822;"><strong>All tables found.</strong></span>',
++	'VERIFY_NOT_AC_FOUND'					=> '<b><span style="color:#FF0000;">%s</span> <span style="color:#000;">not found!</span></b>',
++	'VERIFY_NOT_COLUMN'						=> 'Missing columns',
++	'VERIFY_NOT_COLUMN_EXPLAIN'				=> 'Here you can see all the columns which were not installed.',
++	'VERIFY_NOT_CONFIG'						=> 'Missing config',
++	'VERIFY_NOT_CONFIG_EXPLAIN'				=> 'Here you can see the config files which have not been installed.',
++	'VERIFY_NOT_FILE'						=> 'Missing files',
++	'VERIFY_NOT_FILE_EXPLAIN'				=> 'Here you can see the files that have not been uploaded correctly or have been uploaded correctly but to the wrong place.',
++	'VERIFY_NOT_INVITE_CONFIG'				=> 'Missing phpBB Invite config',
++	'VERIFY_NOT_INVITE_CONFIG_EXPLAIN'		=> 'Here you can see the phpBB Invite config files which have not been installed.',
++	'VERIFY_NOT_MODULE'						=> 'Missing modules',
++	'VERIFY_NOT_MODULE_EXPLAIN'				=> 'Here you can see the modules which have not been installed.',
++	'VERIFY_NOT_PERMIS'						=> 'Missing permissions',
++	'VERIFY_NOT_PERMIS_EXPLAIN'				=> 'Here you can see the permissions that were not installed.',
++	'VERIFY_NOT_TABLE'						=> 'Missing table',
++	'VERIFY_NOT_TABLE_EXPLAIN'				=> 'Here you can see the signs which have not been installed.',
++	'VERIFY_NO_COLUMN'						=> '<b><span style="color:#FF0000;">%s</span> <span style="color:#000;">column not found!</span></b><br />%s<br />',
++	'VERIFY_NO_MODULE'						=> '<b><span style="color:#FF0000;">%s</span> <span style="color:#000;">module is not found in the database!</span></b>',
++	'VERIFY_NO_PERMIS'						=> '<b><span style="color:#FF0000;">%s</span> <span style="color:#000;">permission is not found in the database!</span></b>',
++	'VERIFY_NO_TABLE'						=> '<b><span style="color:#FF0000;">%s</span> <span style="color:#000;">table is not found in the database!</span></b>%s',
++	'VERIFY_PHPBB_MOD_COLUMNS'				=> 'phpBB users table new columns',
++	'VERIFY_PHPBB_MOD_COLUMNS_OK'			=> '<span style="color:#228822;"><strong>All columns found.</strong></span>',
++	'VERIFY_PHPBB_MOD_CONFIG'				=> 'phpBB new config',
++	'VERIFY_PHPBB_MOD_CONFIG_OK'			=> '<span style="color:#228822;"><strong>phpBB config found.</strong></span>',
++	'VERIFY_PHPBB_MOD_FILES'				=> 'phpBB file edits',
++	'VERIFY_PHPBB_MOD_FILES_OK'				=> '<span style="color:#228822;"><strong>All files are edited.</strong></span>',
++	'VERIFY_SUCCESSES_EXPLAIN'				=> 'The check found everything okay.',
++	'VERIFY_TITLE'							=> 'phpBB Invite control',
++	'VERIFY_TITLE_ELL'						=> 'Control error',
++	'VERIFY_TITLE_ELL_EXPLAIN'				=> '<span style="color:#000;"><b>Here you can see all occurred errors to fix everything carefully!</b></span>',
++	'VERIFY_TITLE_EXPLAIN'					=> '<br />Here you can check whether all required file changes, configuration changes and database entries have been made successfully.',
++	'VERIFY_NEW'							=> 'Check again',
++	'VERIFY_UNINSTALL_ERROR_FILE'			=> 'Existing files',
++	'VERIFY_UNINSTALL_ERROR_FILE_EXPLAIN'	=> 'Here you can see the files which have not been removed.',
++));
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt_preao/invite.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt_preao/invite.php"
+new file mode 100644
+index 000000000..07794c344
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt_preao/invite.php"
+@@ -0,0 +1,53 @@
++<?php
++
++/**
++ *
++ * Invite. An extension for the phpBB Forum Software package.
++ * Brazilian Portuguese translation by eunaumtenhoid [2019][ver 4.2.0] (https://github.com/phpBBTraducoes)
++ * @copyright (c) 2010-2015, KillBill
++ * @copyright (c) 2017, kasimi
++ * @copyright (c) 2017-2022, Leinad4Mind, https://leinad4mind.top/forum
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
++// Some characters you may want to copy&paste: ’ « » „ “ ” …
++
++$lang = array_merge($lang, array(
++	'INVITE'								=> 'Convites',
++	'INVITE_INFO'								=> 'Informação sobre Convites',
++	'INVITE_DELETE_CONFIRM'					=> 'Se quiseres apagar o convite, clica %sAQUI%s.',
++	'INVITE_DELETE_SUCCESS'					=> 'O teu convite foi apagados com sucesso.',
++	'INVITE_DELETE_SUCCESSES'				=> 'Os teus convites foram apagados com sucesso.',
++	'INVITE_DISABLED'						=> '<span class="invitation_tred">O sistema de convite está atualmente desativado!</span>',
++	'INVITE_EMAIL_BLOCK'					=> 'Bloqueado!',
++	'INVITE_INVITED'						=> 'Convidado por',
++	'INVITE_INVITES'						=> 'Convidou',
++	'INVITE_KEY_ERROR'						=> '<div class="invitation_error">O convite não é válido!</div>',
++	'INVITE_PERSON'							=> '%s pessoa(s)',
++	'INVITE_POINTS_PRESENT'					=> 'A cada %s convite(s), enviamos %s %s !',
++	'INVITE_REGISTRATION'					=> '<div class="invitation_error">Registo apenas por convite!</div>',
++	'INVITE_REGISTRATION_EXPLAIN'			=> 'De momento os registos são restritos apenas a pessoas convidadas por utilizadores da comunidade, caso conheças alguém que tenha conta pede um convite!',
++	'INVITE_COPYRIGHT'						=> 'phpBB Invite by <a href="https://leinad4mind.top/forum">Leinad4Mind</a> &copy; 2018-2022',
++));
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt_preao/permissions_invite.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt_preao/permissions_invite.php"
+new file mode 100644
+index 000000000..90f45e670
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt_preao/permissions_invite.php"
+@@ -0,0 +1,51 @@
++<?php
++
++/**
++ *
++ * Invite. An extension for the phpBB Forum Software package.
++ * Brazilian Portuguese translation by eunaumtenhoid [2019][ver 4.2.0] (https://github.com/phpBBTraducoes)
++ * @copyright (c) 2010-2015, KillBill
++ * @copyright (c) 2017, kasimi
++ * @copyright (c) 2017-2022, Leinad4Mind, https://leinad4mind.top/forum
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
++// Some characters you may want to copy&paste: ’ « » „ “ ” …
++
++$lang = array_merge($lang, array(
++	'ACL_A_INVITE'			=> 'O utilizador pode sincronizar dados',
++	'ACL_A_INVITE_CONFIG'	=> 'O utilizador pode alterar as configurações do convite.',
++	'ACL_A_INVITE_DELETE'	=> 'O utilizador pode apagar convites',
++	'ACL_A_INVITE_CLAIMING' => 'O utilizador pode gerir convites',
++	'ACL_A_INVITE_SEND'		=> 'O utilizador pode adicionar convites para membros',
++	'ACL_A_INVITE_PEND'		=> 'O utilizador pode gerir convites pendentes',
++	'ACL_A_INVITE_USERS'	=> 'O utilizador pode ver uma lista de membros convidados',
++	'ACL_M_INVITE_CLAIMING'	=> 'O utilizador pode aprovar um pedido de convite.',
++	'ACL_U_INVITE_DELETE'	=> 'O utilizador pode revogar convites<br /><em>O utilizador pode cancelar um convite que ele enviou.</em>',
++	'ACL_U_INVITE_REQUEST'	=> 'O utilizador pode solicitar convite',
++	'ACL_U_INVITE_SENDING'		=> 'O utilizador pode convidar novos membros para o site',
++	'ACL_U_INVITE_MAX'		=> 'O utilizador tem convites ilimitados',
++	'ACL_U_INVITE_USERS'	=> 'O utilizador pode visualizar a lista de utilizadores convidados por outras pessoas.',
++));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/styles/FLATBOOTS/template/event/memberlist_body_memberlist_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/styles/FLATBOOTS/template/event/memberlist_body_memberlist_after.bak"
+similarity index 100%
+rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/styles/FLATBOOTS/template/event/memberlist_body_memberlist_after.html"
+rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/styles/FLATBOOTS/template/event/memberlist_body_memberlist_after.bak"
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/styles/FLATBOOTS/template/event/navbar_header_profile_list_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/styles/FLATBOOTS/template/event/navbar_header_profile_list_after.html"
+index 3f31a66e4..18fe47011 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/styles/FLATBOOTS/template/event/navbar_header_profile_list_after.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/styles/FLATBOOTS/template/event/navbar_header_profile_list_after.html"
+@@ -1 +1 @@
+-{% if U_INVITE %}<li><a class="btn btn-primary btn-sm btn-block" href="{{ U_INVITE }}"><i class="fa fa-ticket"></i>&nbsp;{{ lang('INVITE_GLOBAL') }}</a></li>{% endif %}
+\ No newline at end of file
++{% if U_INVITE %}<a class="btn btn-primary btn-sm btn-block" href="{{ U_INVITE }}"><i class="fa fa-id-card-o"></i>&nbsp;{{ lang('INVITE_GLOBAL') }}</a>{% endif %}
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/styles/FLATBOOTS/template/event/overall_header_navigation_append.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/styles/FLATBOOTS/template/event/overall_header_navigation_append.bak"
+similarity index 100%
+rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/styles/FLATBOOTS/template/event/overall_header_navigation_append.html"
+rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/styles/FLATBOOTS/template/event/overall_header_navigation_append.bak"
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/styles/FLATBOOTS/template/event/memberlist_view_user_statistics_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/styles/FLATBOOTS/template/event/ss_memberlist_view_timeline_item_after.html"
+similarity index 100%
+rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/styles/FLATBOOTS/template/event/memberlist_view_user_statistics_after.html"
+rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/styles/FLATBOOTS/template/event/ss_memberlist_view_timeline_item_after.html"
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/styles/FLATBOOTS/template/ucp_invite.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/styles/FLATBOOTS/template/ucp_invite.html"
+index c6a20c038..ff7ea1802 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/styles/FLATBOOTS/template/ucp_invite.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/styles/FLATBOOTS/template/ucp_invite.html"
+@@ -2,169 +2,171 @@
+ 
+ {% if S_INVITE_DATA %}
+ <fieldset class="framed-ucp">
+- <legend>{{ lang('UCP_INVITE_DATA') }}</legend>
+- <div class="space10"></div>
+-<div>
+-	<div class="inner">
+-	<div class="invite_info invite_info-odd">
+-		<div class="col-md-7">
+-			<label>{{ lang('UCP_INVITE_DB_NUMBER') }}{{ lang('COLON') }}</label><br /><span>{{ lang('UCP_INVITE_DB_NUMBER_EXPLAIN') }}</span>
+-		</div>
+-		<div class="col-md-5"><label>{{ INVITE_DB_NUMBER }}</label></div>
+-	</div>
+-	
++	<legend>{{ lang('UCP_INVITE_DATA') }}</legend>
+ 	<div class="space10"></div>
++	<div>
++		<div class="inner">
++			<div class="invite_info invite_info-odd">
++				<div class="col-md-7">
++					<label>{{ lang('UCP_INVITE_DB_NUMBER') }}{{ lang('COLON') }}</label><br /><span class="hidden-xs">{{ lang('UCP_INVITE_DB_NUMBER_EXPLAIN') }}</span>
++				</div>
++				<div class="col-md-5"><label>{{ INVITE_DB_NUMBER }}</label></div>
++			</div>
+ 
+-	<div class="invite_info invite_info-even">
+-		<div class="col-md-7">
+-			<label>{{ lang('UCP_INVITE_DB_USER') }}{{ lang('COLON') }}</label><br /><span>{{ lang('UCP_INVITE_DB_USER_EXPLAIN') }}</span>
+-		</div>
+-		<div class="col-md-5"><label>{{ INVITE_DB_USER }}</label></div>
+-	</div>
++			<div class="space10"></div>
+ 
+-	<div class="space10"></div>
++			<div class="invite_info invite_info-even">
++				<div class="col-md-7">
++					<label>{{ lang('UCP_INVITE_DB_USER') }}{{ lang('COLON') }}</label><br /><span class="hidden-xs">{{ lang('UCP_INVITE_DB_USER_EXPLAIN') }}</span>
++				</div>
++				<div class="col-md-5"><label>{{ INVITE_DB_USER }}</label></div>
++			</div>
+ 
+-	<div class="invite_info invite_info-odd">
+-		<div class="col-md-7">
+-			<label>{{ lang('UCP_INVITE_DB_SEND') }}{{ lang('COLON') }}</label><br /><span>{{ lang('UCP_INVITE_DB_SEND_EXPLAIN') }}</span>
+-		</div>
+-		<div class="col-md-5"><label>{{ INVITE_DB_SEND }}</label></div>
+-	</div>
++			<div class="space10"></div>
+ 
+-	<div class="space10"></div>
++			<div class="invite_info invite_info-odd">
++				<div class="col-md-7">
++					<label>{{ lang('UCP_INVITE_DB_SEND') }}{{ lang('COLON') }}</label><br /><span class="hidden-xs">{{ lang('UCP_INVITE_DB_SEND_EXPLAIN') }}</span>
++				</div>
++				<div class="col-md-5"><label>{{ INVITE_DB_SEND }}</label></div>
++			</div>
+ 
+-	<div class="invite_info invite_info-even">
+-		<div class="col-md-7">
+-			<label>{{ lang('UCP_INVITE_DAYF') }}{{ lang('COLON') }}</label><br /><span>{{ lang('UCP_INVITE_DAYF_EXPLAIN') }}</span>
+-		</div>
+-		<div class="col-md-5"><label>{{ INVITE_DAY_DB }}</label></div>
+-	</div>
++			<div class="space10"></div>
+ 
+-	<div class="space10"></div>
++			<div class="invite_info invite_info-even">
++				<div class="col-md-7">
++					<label>{{ lang('UCP_INVITE_DAYF') }}{{ lang('COLON') }}</label><br /><span class="hidden-xs">{{ lang('UCP_INVITE_DAYF_EXPLAIN') }}</span>
++				</div>
++				<div class="col-md-5"><label>{{ INVITE_DAY_DB }}</label></div>
++			</div>
+ 
+-	<div class="invite_info invite_info-odd">
+-		<div class="col-md-7">
+-			<label>{{ lang('UCP_INVITE_DB_PENDING') }}{{ lang('COLON') }}</label><br /><span>{{ lang('UCP_INVITE_DB_PENDING_EXPLAIN') }}</span>
+-		</div>
+-		<div class="col-md-5"><label>{{ INVITE_DB_PENDING }}</label></div>
+-	</div>
++			<div class="space10"></div>
+ 
+-	<div class="space10"></div>
++			<div class="invite_info invite_info-odd">
++				<div class="col-md-7">
++					<label>{{ lang('UCP_INVITE_DB_PENDING') }}{{ lang('COLON') }}</label><br /><span class="hidden-xs">{{ lang('UCP_INVITE_DB_PENDING_EXPLAIN') }}</span>
++				</div>
++				<div class="col-md-5"><label>{{ INVITE_DB_PENDING }}</label></div>
++			</div>
+ 
+-	<div class="invite_info invite_info-even">
+-		<div class="col-md-7">
+-			<label>{{ lang('UCP_INVITE_TIME_END') }}{{ lang('COLON') }}</label><br /><span>{{ lang('UCP_INVITE_TIME_END_EXPLAIN') }}</span>
+-		</div>
+-		<div class="col-md-5"><label><strong>{{ INVITE_TIME_END }} {{ lang('DAY') }}</strong></label></div>
+-	</div>
++			<div class="space10"></div>
+ 
+-	<div class="space10"></div>
++			<div class="invite_info invite_info-even">
++				<div class="col-md-7">
++					<label>{{ lang('UCP_INVITE_TIME_END') }}{{ lang('COLON') }}</label><br /><span class="hidden-xs">{{ lang('UCP_INVITE_TIME_END_EXPLAIN') }}</span>
++				</div>
++				<div class="col-md-5"><label><strong>{{ INVITE_TIME_END }}</strong></label></div>
++			</div>
++
++			<div class="space10"></div>
+ 
+-	<div class="invite_info invite_info-odd">
+-		<div class="col-md-7">
+-			<label>{{ lang('UCP_INVITE_LU_REG') }}{{ lang('COLON') }}</label><br /><span>{{ lang('UCP_INVITE_LU_REG_EXPLAIN') }}</span>
++			<div class="invite_info invite_info-odd">
++				<div class="col-md-7">
++					<label>{{ lang('UCP_INVITE_LU_REG') }}{{ lang('COLON') }}</label><br /><span class="hidden-xs">{{ lang('UCP_INVITE_LU_REG_EXPLAIN') }}</span>
++				</div>
++				<div class="col-md-5"><label>{{ INVITE_LAST_USER }}</label></div>
++			</div>
+ 		</div>
+-		<div class="col-md-5"><label>{{ INVITE_LAST_USER }}</label></div>
+-	</div>
+-</div>
+ </fieldset>
+ {% endif %}
+ 
+ {% if S_INVITE_MAIL %}
+ 
+-	{% if MORE_RECIPIENTS %}
+-		{% INCLUDECSS '@leinad4mind_invitation/multiple-emails.css' %}
+-		{% INCLUDEJS '@leinad4mind_invitation/js/multiple-emails.js' %}
+-		{% INCLUDEJS '@leinad4mind_invitation/js/email.js' %}
+-	{% endif %}
++{% if MORE_RECIPIENTS %}
++{% INCLUDECSS '@leinad4mind_invitation/multiple-emails.css' %}
++{% INCLUDEJS '@leinad4mind_invitation/js/multiple-emails.js' %}
++{% INCLUDEJS '@leinad4mind_invitation/js/email.js' %}
++{% endif %}
+ 
+ <fieldset class="framed-ucp">
+-<legend>{{ lang('UCP_INVITE_SEND') }}</legend>
+-<div class="space10"></div>
+-<form id="invite_send" method="post" action="{{ U_ACTION }}">
+-	<div>
+-		<div class="inner">
+-			{% if ERROR_MESSAGE %}
++	<legend>{{ lang('UCP_INVITE_SEND') }}</legend>
++	<div class="space10"></div>
++	<form id="invite_send" method="post" action="{{ U_ACTION }}">
++		<div>
++			<div class="inner">
++				{% if ERROR_MESSAGE %}
+ 				<div class="alert alert-danger">{{ ERROR_MESSAGE }}</div>
+-			{% endif %}
++				{% endif %}
++
++				<div>{{ lang('UCP_INVITE_SEND_EXPLAIN') }}</div>
+ 
+-			<fieldset class="fields2">
+-				{% if S_INVITE_LANG_OPTIONS %}
+-				<div> 
+-					<label class="control-label" for="invite_lang">{{ lang('UCP_INVITE_EMAIL_LANG') }}{{ lang('COLON') }}</label>
+-					<div class="controls controls-row"> 
+-					<select class="tz_select selectpicker" data-container="body" data-width="auto" onchange="document.forms['invite_send'].submit.click(); return false;" tabindex="1" name="invite_lang" id="invite_lang" title="{{ lang('LANGUAGE') }}">
+-						{{ S_INVITE_LANG_OPTIONS }}
+-					</select>
++				<fieldset class="fields2">
++					{% if S_INVITE_LANG_OPTIONS %}
++					<div>
++						<label class="control-label" for="invite_lang">{{ lang('UCP_INVITE_EMAIL_LANG') }}{{ lang('COLON') }}</label>
++						<div class="controls controls-row">
++							<select class="tz_select selectpicker" data-container="body" data-width="auto" onchange="document.forms['invite_send'].submit.click(); return false;" tabindex="1" name="invite_lang" id="invite_lang" title="{{ lang('LANGUAGE') }}">
++								{{ S_INVITE_LANG_OPTIONS }}
++							</select>
++						</div>
+ 					</div>
+-				</div>
+-				<div class="space10"></div>
+-				<div class="space10"></div>
+-				<div class="space10"></div>
+-				{% endif %}
+-				<div> 
+-					<label for="friend">{{ lang('UCP_INVITE_FRIEND') }}{{ lang('COLON') }}</label><br /><span>{{ lang('UCP_INVITE_FRIEND_EXPLAIN') }}</span>
+ 					<div class="space10"></div>
+-					<div> 
+-						<label for="friend1"><input type="radio" class="radio" name="friend" id="friend1" value="1"{% if S_FRIEND %} checked="checked"{% endif %} /> {{ lang('YES') }}</label>
+-						<label for="friend0"><input type="radio" class="radio" name="friend" id="friend0" value="0"{% if not S_FRIEND %} checked="checked"{% endif %} /> {{ lang('NO') }}</label>
++					<div class="space10"></div>
++					<div class="space10"></div>
++					{% endif %}
++					<div>
++						<label for="friend">{{ lang('UCP_INVITE_FRIEND') }}{{ lang('COLON') }}</label><br /><span>{{ lang('UCP_INVITE_FRIEND_EXPLAIN') }}</span>
++						<div class="space10"></div>
++						<div>
++							<label for="friend1"><input type="radio" class="radio" name="friend" id="friend1" value="1" {% if S_FRIEND %} checked="checked" {% endif %} /> {{ lang('YES') }}</label>
++							<label for="friend0"><input type="radio" class="radio" name="friend" id="friend0" value="0" {% if not S_FRIEND %} checked="checked" {% endif %} /> {{ lang('NO') }}</label>
++						</div>
+ 					</div>
+-				</div>
+-				<div class="space10"></div>
+-				<div class="space10"></div>
+-				<div class="space10"></div>
+-				<div class="form-group">
+-					<label for="email">{{ lang('EMAIL_ADDRESS') ~ lang('COLON') }}</label>{% if MORE_RECIPIENTS %}<br /><span>{{ lang('UCP_INVITE_MAX_RECIPIENTS') }}{{ lang('COLON') }}{{ MORE_RECIPIENTS }}</span>{% endif %}
+-					<div class="input-icon left">
+-						<i class="fa fa-at"></i>
+-						{% if MORE_RECIPIENTS %}
++					<div class="space10"></div>
++					<div class="space10"></div>
++					<div class="space10"></div>
++					<div class="form-group">
++						<label for="email">{{ lang('EMAIL_ADDRESS') ~ lang('COLON') }}</label>{% if MORE_RECIPIENTS %}<br /><span>{{ lang('UCP_INVITE_MAX_RECIPIENTS') }}{{ lang('COLON') }}{{ MORE_RECIPIENTS }}</span>{% endif %}
++						<div class="input-icon left">
++							<i class="fa fa-at"></i>
++							{% if MORE_RECIPIENTS %}
+ 							<textarea class="form-control input-sm" style="display:none;" name="email" id="email" rows="1" cols="25" tabindex="2">{{ EMAIL_CIM }}</textarea>
+-						{% else %}
++							{% else %}
+ 							<input class="form-control input-sm" type="email" name="email" id="email" size="25" maxlength="100" tabindex="2" value="{{ EMAIL_CIM }}" />
+-						{% endif %}
++							{% endif %}
++						</div>
+ 					</div>
+-				</div>
+-				<div class="space10"></div>
+-				<div class="space10"></div>
+-				<div class="form-group">
+-					<label for="subject">{{ lang('SUBJECT') ~ lang('COLON') }}</label>
+-					<div class="input-icon">
+-						<input class="form-control input-sm" type="text" name="subject" id="subject" size="50" maxlength="255" tabindex="3" value="{{ EMAIL_TEMA }}" />
++					<div class="space10"></div>
++					<div class="space10"></div>
++					<div class="form-group">
++						<label for="subject">{{ lang('SUBJECT') ~ lang('COLON') }}</label>
++						<div class="input-icon">
++							<input class="form-control input-sm" type="text" name="subject" id="subject" size="50" maxlength="255" tabindex="3" value="{{ EMAIL_TEMA }}" />
++						</div>
+ 					</div>
+-				</div>
+-				<div class="space10"></div>
+-				<div class="space10"></div>
+-				<div class="form-group">
+-					<label for="subject">{{ lang('MESSAGE_BODY') ~ lang('COLON') }}</label><br /><span>{{ lang('UCP_INVITE_MESSAGE_BODY_EXPLAIN') }}</span>
+-					<div class="input-icon">
+-						<textarea class="form-control input-sm" type="text" name="message" id="message" rows="15" cols="45" tabindex="4">{{ EMAIL_MESSAGE }}</textarea>
++					<div class="space10"></div>
++					<div class="space10"></div>
++					<div class="form-group">
++						<label for="subject">{{ lang('MESSAGE_BODY') ~ lang('COLON') }}</label><br /><span>{{ lang('UCP_INVITE_MESSAGE_BODY_EXPLAIN') }}</span>
++						<div class="input-icon">
++							<textarea class="form-control input-sm" type="text" name="message" id="message" rows="15" cols="45" tabindex="4">{{ EMAIL_MESSAGE }}</textarea>
++						</div>
+ 					</div>
+-				</div>
+-			</fieldset>
++				</fieldset>
++			</div>
+ 		</div>
+-	</div>
+ 
+-	{% if CAPTCHA_TEMPLATE %}
+-	<div>
+-		<div class="inner">
+-			<fieldset class="fields2">
+-			{% DEFINE CAPTCHA_TAB_INDEX = 5 %}
+-			{% INCLUDE ''~ CAPTCHA_TEMPLATE ~'' %}
+-			</fieldset>
++		{% if CAPTCHA_TEMPLATE %}
++		<div>
++			<div class="inner">
++				<fieldset class="fields2">
++					{% DEFINE CAPTCHA_TAB_INDEX = 5 %}
++					{% INCLUDE ''~ CAPTCHA_TEMPLATE ~'' %}
++				</fieldset>
++			</div>
+ 		</div>
+-	</div>
+-	{% endif %}
++		{% endif %}
+ 
+-	<div>
+-		<div class="inner">
+-			<fieldset class="submit-buttons">
+-				<input type="submit" name="submit" id="submit" value="{{ lang('UCP_INVITE_SEND_SUBMIT') }}" class="btn btn-default" />
+-				{{ S_HIDDEN_FIELDS }}
+-				{{ S_FORM_TOKEN }}
+-			</fieldset>
++		<div>
++			<div class="inner">
++				<fieldset class="submit-buttons">
++					<input type="submit" name="submit" id="submit" value="{{ lang('UCP_INVITE_SEND_SUBMIT') }}" class="btn btn-default" />
++					{{ S_HIDDEN_FIELDS }}
++					{{ S_FORM_TOKEN }}
++				</fieldset>
++			</div>
+ 		</div>
+-	</div>
+-</form>
++	</form>
+ </fieldset>
+ {% endif %}
+ 
+@@ -178,12 +180,15 @@
+ 			<div class="inner">
+ 				<fieldset>
+ 					{% if ERROR_MESSAGE %}
+-						<div class="alert alert-danger">{{ ERROR_MESSAGE }}</div>
++					<div class="alert alert-danger">{{ ERROR_MESSAGE }}</div>
+ 					{% endif %}
+-					<dl>
+-						<dt><label for="claiming_db">{{ SUBT_INVITE_REQUEST }}{{ lang('COLON') }}</label><br /><span>{{ SUBT_INVITE_REQUEST_EXPLAIN }}</span></dt>
+-						<dd><input class="inputbox autowidth" type="text" id="claiming_db" name="claiming_db" size="2" maxlength="2" value="{{ INVITE_REQUEST_DB_SELECT }}" /> {{ lang('UCP_INVITE_SDB') }}</dd>
+-					</dl>
++					{{ lang('UCP_INVITE_REQUEST_COST') }}
++					<div class="form-group">
++						<label for="subject">{{ SUBT_INVITE_REQUEST }}{{ lang('COLON') }}</label><br /><span>{{ SUBT_INVITE_REQUEST_EXPLAIN }}</span>
++						<div class="input-icon" style="display:flex;align-items:center">
++							<input class="form-control input-sm" style="width:5rem" type="text" id="claiming_db" name="claiming_db" size="2" maxlength="2" value="{{ INVITE_REQUEST_DB_SELECT }}" />&nbsp;{{ lang('UCP_INVITE_SDB') }}
++						</div>
++					</div>
+ 					{% if S_SIZE_POSTS_REQUIRED %}
+ 					<dl>
+ 						<dt class="invite_notice">{{ UCP_INVITE_REQUEST_MANY_EXPLAIN }}</dt>
+@@ -200,9 +205,10 @@
+ 		<div class="panel">
+ 			<div class="inner">
+ 				<fieldset class="submit-buttons">
+-					<input type="submit" name="submit" id="submit" value="{{ INVITE_REQUEST_SUBMIT }}" class="button1" />
++					<input type="submit" name="submit" id="submit" value="{{ INVITE_REQUEST_SUBMIT }}" class="btn btn-default" />
+ 					{{ S_FORM_TOKEN }}
+ 				</fieldset>
++				<div class="space10"></div>
+ 			</div>
+ 		</div>
+ 	</form>
+@@ -219,72 +225,72 @@
+ {% endif %}
+ 
+ {% if UCP_INVITE_USER %}
+-	{% if loops.users|length %}
+-		{% INCLUDE 'memberlist_invite.html' %}
+-	{% else %}
+-	<fieldset class="framed-ucp">
+-		<legend>{{ lang('INFORMATION') }}</legend>
+-		<div>
+-			<div class="inner">
+-				<fieldset style="text-align:center;">
+-					<span class="alert alert-warning">{{ lang('UCP_INVITE_NO_INVITE_USERS') }}</span>
+-				</fieldset>
+-			</div>
++{% if loops.users|length %}
++{% INCLUDE 'memberlist_invite.html' %}
++{% else %}
++<fieldset class="framed-ucp">
++	<legend>{{ lang('INFORMATION') }}</legend>
++	<div>
++		<div class="inner">
++			<fieldset style="text-align:center;">
++				<span class="alert alert-warning">{{ lang('UCP_INVITE_NO_INVITE_USERS') }}</span>
++			</fieldset>
+ 		</div>
+-		<div class="space10"></div>
+-	</fieldset>
+-	{% endif %}
++	</div>
++	<div class="space10"></div>
++</fieldset>
++{% endif %}
+ {% endif %}
+ 
+ {% if S_INVITE_DELETE %}
+ <fieldset class="framed-ucp">
+- <legend>{{ lang('UCP_INVITE_DELETE') }}</legend>
++	<legend>{{ lang('UCP_INVITE_DELETE') }}</legend>
+ 	<p>{{ UCP_INVITE_DELETE_EXPLAIN }}</p>
+ 	<form id="invite_delete" method="post" action="{{ U_ACTION }}">
+-	<div>
+-		<div class="inner">
+-			{% if ERROR_MESSAGE %}
++		<div>
++			<div class="inner">
++				{% if ERROR_MESSAGE %}
+ 				<div class="alert alert-danger">{{ ERROR_MESSAGE }}</div>
+-			{% endif %}
+-			<fieldset>
++				{% endif %}
++				<fieldset>
+ 
+-			<div> 
+-				{% if loops.email|length %}
+-					<label class="control-label" for="email">{{ lang('UCP_INVITE_EMAIL_SELECT') }}{{ lang('COLON') }}</label>
+-					<span>{{ lang('UCP_INVITE_EMAIL_SELECT_EXPLAIN') }}</span>
+-					<div class="space10"></div>
+-					<div class="controls controls-row"> 
+-					<select class="tz_select selectpicker" data-container="body" data-width="auto" onchange="document.forms['invite_send'].submit.click(); return false;" tabindex="1" name="email" id="email" title="{{ lang('LANGUAGE') }}">
+-						{% for email in loops.email %}
+-							<option class="bg1" value="{{ email.EMAIL }}">{% if email.COUNT %}({{ email.COUNT }} {{ lang('INVITE') }}) - {% endif %}{{ email.EMAIL }}</option>
+-						{% endfor %}
+-					</select>
+-					&nbsp;&nbsp;{{ lang('CONFIRM') }}&nbsp;&nbsp;<input type="checkbox" class="radio" id="delete" name="delete" value="1" />
++					<div>
++						{% if loops.email|length %}
++						<label class="control-label" for="email">{{ lang('UCP_INVITE_EMAIL_SELECT') }}{{ lang('COLON') }}</label>
++						<span>{{ lang('UCP_INVITE_EMAIL_SELECT_EXPLAIN') }}</span>
++						<div class="space10"></div>
++						<div class="controls controls-row">
++							<select class="tz_select selectpicker" data-container="body" data-width="auto" onchange="document.forms['invite_send'].submit.click(); return false;" tabindex="1" name="email" id="email" title="{{ lang('LANGUAGE') }}">
++								{% for email in loops.email %}
++								<option class="bg1" value="{{ email.EMAIL }}">{% if email.COUNT %}({{ email.COUNT }} {{ lang('INVITE') }}) - {% endif %}{{ email.EMAIL }}</option>
++								{% endfor %}
++							</select>
++							&nbsp;&nbsp;{{ lang('CONFIRM') }}&nbsp;&nbsp;<input type="checkbox" class="radio" id="delete" name="delete" value="1" />
++						</div>
++						{% else %}
++						<div class="space10"></div>
++						<span class="alert alert-warning">{{ lang('UCP_INVITE_NOT_DELETED_INVITE') }}</span>
++						<div class="space10"></div>
++						{% endif %}
+ 					</div>
+-				{% else %}
+-					<div class="space10"></div>
+-					<span class="alert alert-warning">{{ lang('UCP_INVITE_NOT_DELETED_INVITE') }}</span>
+-					<div class="space10"></div>
+-				{% endif %}
++				</fieldset>
+ 			</div>
+-			</fieldset>
+ 		</div>
+-	</div>
+-{% if loops.email|length %}
+-	<div class="space10"></div>
+-	<div class="panel">
+-		<div class="inner">
+-			<fieldset class="submit-buttons">
+-				<input type="submit" name="submit" id="submit" value="{{ lang('DELETE') }}" class="button1 btn btn-default" />
+-				{{ S_FORM_TOKEN }}
+-			</fieldset>
+-			<div class="space10"></div>
++		{% if loops.email|length %}
++		<div class="space10"></div>
++		<div class="panel">
++			<div class="inner">
++				<fieldset class="submit-buttons">
++					<input type="submit" name="submit" id="submit" value="{{ lang('DELETE') }}" class="btn btn-default" />
++					{{ S_FORM_TOKEN }}
++				</fieldset>
++				<div class="space10"></div>
++			</div>
+ 		</div>
+-	</div>
+-{% endif %}
++		{% endif %}
+ 
+-</form>
++	</form>
+ </fieldset>
+ {% endif %}
+ 
+-{% INCLUDE 'ucp_footer.html' %}
++{% INCLUDE 'ucp_footer.html' %}
+\ No newline at end of file
diff --git "[FORUM_EXT]/leinad4mind\\invitation/diff_nospace.tmp" "[FORUM_EXT]/leinad4mind\\invitation/diff_nospace.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/leinad4mind\\invitation/diff_nospace.tmp"
@@ -0,0 +1,2128 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/controller/acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/controller/acp.php"
+index 40f3b8fd8..74e01899b 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/controller/acp.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/controller/acp.php"
+@@ -860,7 +860,8 @@ class acp extends controller_base
+ 							trigger_error($this->language->lang('ACP_INVITE_NO_SELECT_INVITE') . adm_back_link($u_action), E_USER_WARNING);
+ 						}
+ 
+-						$confirm_lang = $action == 'del_all' ? $this->language->lang('ACP_INVITE_DELETE_ALL_PEND_CONFIRM') : count($marked) == 1 ? $this->language->lang('ACP_INVITE_DELETE_PEND_CONFIRM') : $this->language->lang('ACP_INVITE_DELETES_PEND_CONFIRM');
++						$confirm_lang = $action == 'del_all' ? $this->language->lang('ACP_INVITE_DELETE_ALL_PEND_CONFIRM') : (count($marked) == 1 ? $this->language->lang('ACP_INVITE_DELETE_PEND_CONFIRM') : $this->language->lang('ACP_INVITE_DELETES_PEND_CONFIRM'));
++
+ 
+ 						confirm_box(false, $confirm_lang, build_hidden_fields(array(
+ 							'i'			=> $id,
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/controller/mcp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/controller/mcp.php"
+index fa90fa653..7e1018a71 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/controller/mcp.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/controller/mcp.php"
+@@ -93,7 +93,8 @@ class mcp extends controller_base
+ 			trigger_error($this->language->lang('MCP_INVITE_DISABLED', '<a href="' . append_sid("{$this->root_path}mcp.$this->php_ext") . '">', '</a>'));
+ 		}
+ 
+-		$action		= $this->request->is_set_post('allocate') ? 'allocate' : $this->request->is_set_post('deny') ? 'deny' : $this->request->variable('action', '');
++		$action 	= $this->request->is_set_post('allocate') ? 'allocate' : ($this->request->is_set_post('deny') ? 'deny' : $this->request->variable('action', ''));
++
+ 		$marked		= $this->request->variable('mark'	, array(0));
+ 		$start		= $this->request->variable('start'	, 0);
+ 		$sort_days	= $this->request->variable('st'	, 0);
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/controller/ucp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/controller/ucp.php"
+index 394fba05d..2824ecebc 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/controller/ucp.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/controller/ucp.php"
+@@ -401,8 +401,8 @@ class ucp extends controller_base
+ 					'S_HIDDEN_FIELDS'		=> build_hidden_fields($s_hidden_fields),
+ 					'MORE_RECIPIENTS'		=> $this->ext_config['invite_email_db'] > 1 ? $this->language->lang('UCP_INVITE_DB', $this->ext_config['invite_email_db']) : false,
+ 					'EMAIL_CIM'				=> $email,
+-					'EMAIL_TEMA'			=> $lang ? $lang->lang('UCP_INVITE') : $this->language->lang('UCP_INVITE'),
+-					'EMAIL_MESSAGE'			=> $message,
++					'EMAIL_TEMA'			=> $lang ? $lang->lang('UCP_INVITE_LABEL') : $this->language->lang('UCP_INVITE_LABEL'),
++					'EMAIL_MESSAGE' => $lang ? $message : $this->language->lang('UCP_INVITE_MESSAGE'),
+ 				));
+ 
+ 				unset($lang_row);
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/diff_full.tmp"
+new file mode 100644
+index 000000000..dd926fba7
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/diff_full.tmp"
+@@ -0,0 +1,2140 @@
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/controller/acp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/controller/acp.php"
++index 40f3b8fd8..74e01899b 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/controller/acp.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/controller/acp.php"
++@@ -860,7 +860,8 @@ class acp extends controller_base
++ 							trigger_error($this->language->lang('ACP_INVITE_NO_SELECT_INVITE') . adm_back_link($u_action), E_USER_WARNING);
++ 						}
++ 
++-						$confirm_lang = $action == 'del_all' ? $this->language->lang('ACP_INVITE_DELETE_ALL_PEND_CONFIRM') : count($marked) == 1 ? $this->language->lang('ACP_INVITE_DELETE_PEND_CONFIRM') : $this->language->lang('ACP_INVITE_DELETES_PEND_CONFIRM');
+++						$confirm_lang = $action == 'del_all' ? $this->language->lang('ACP_INVITE_DELETE_ALL_PEND_CONFIRM') : (count($marked) == 1 ? $this->language->lang('ACP_INVITE_DELETE_PEND_CONFIRM') : $this->language->lang('ACP_INVITE_DELETES_PEND_CONFIRM'));
+++
++ 
++ 						confirm_box(false, $confirm_lang, build_hidden_fields(array(
++ 							'i'			=> $id,
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/controller/mcp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/controller/mcp.php"
++index fa90fa653..7e1018a71 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/controller/mcp.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/controller/mcp.php"
++@@ -93,7 +93,8 @@ class mcp extends controller_base
++ 			trigger_error($this->language->lang('MCP_INVITE_DISABLED', '<a href="' . append_sid("{$this->root_path}mcp.$this->php_ext") . '">', '</a>'));
++ 		}
++ 
++-		$action		= $this->request->is_set_post('allocate') ? 'allocate' : $this->request->is_set_post('deny') ? 'deny' : $this->request->variable('action', '');
+++		$action 	= $this->request->is_set_post('allocate') ? 'allocate' : ($this->request->is_set_post('deny') ? 'deny' : $this->request->variable('action', ''));
+++
++ 		$marked		= $this->request->variable('mark'	, array(0));
++ 		$start		= $this->request->variable('start'	, 0);
++ 		$sort_days	= $this->request->variable('st'	, 0);
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/controller/ucp.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/controller/ucp.php"
++index 394fba05d..2824ecebc 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/controller/ucp.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/controller/ucp.php"
++@@ -401,8 +401,8 @@ class ucp extends controller_base
++ 					'S_HIDDEN_FIELDS'		=> build_hidden_fields($s_hidden_fields),
++ 					'MORE_RECIPIENTS'		=> $this->ext_config['invite_email_db'] > 1 ? $this->language->lang('UCP_INVITE_DB', $this->ext_config['invite_email_db']) : false,
++ 					'EMAIL_CIM'				=> $email,
++-					'EMAIL_TEMA'			=> $lang ? $lang->lang('UCP_INVITE') : $this->language->lang('UCP_INVITE'),
++-					'EMAIL_MESSAGE'			=> $message,
+++					'EMAIL_TEMA'			=> $lang ? $lang->lang('UCP_INVITE_LABEL') : $this->language->lang('UCP_INVITE_LABEL'),
+++					'EMAIL_MESSAGE' => $lang ? $message : $this->language->lang('UCP_INVITE_MESSAGE'),
++ 				));
++ 
++ 				unset($lang_row);
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/diff_full.tmp"
++new file mode 100644
++index 000000000..e69de29bb
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/includes/functions.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/includes/functions.php"
++index 6d6fc0bca..9ac5f0fa8 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/includes/functions.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/includes/functions.php"
++@@ -435,7 +435,7 @@ class functions
++ 		$row2 = $this->db->sql_fetchrow($result);
++ 		$this->db->sql_freeresult($result);
++ 
++-		if ($row['user_id'])
+++		if ($row !== false && $row['user_id'])
++ 		{
++ 			$this->template->assign_vars(array(
++ 				'INVITE_USER_NAME'	=> '<strong>' . get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']) . '</strong>',
++@@ -443,7 +443,7 @@ class functions
++ 		}
++ 		
++ 		
++-		if ($row2['user_id'])
+++		if ($row2 !== false && $row2['user_id'])
++ 		{
++ 			$this->template->assign_vars(array(
++ 				'L_INVITE_MEMBER'	=> $this->language->lang('INVITE') . (($this->ext_config['invite_db'] || $this->auth->acl_get('u_invite_max')) ? '' : ' (' . $row2['user_invite'] . ')'),
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/language/de/permissions_invite.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/de/permissions_invite.php"
++index ba6f116a5..1cdd87b47 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/language/de/permissions_invite.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/de/permissions_invite.php"
++@@ -38,14 +38,14 @@ $lang = array_merge($lang, array(
++ 	'ACL_A_INVITE'			=> 'Benutzer kann Daten synchronisieren',
++ 	'ACL_A_INVITE_CONFIG'	=> 'Benutzer kann Einladungen konfigurieren.',
++ 	'ACL_A_INVITE_DELETE'	=> 'Benutzer kann Einladungen löschen',
++-	'ACL_A_INVITE_SIZE'		=> 'Benutzer kann Einladungen verwalten',
+++	'ACL_A_INVITE_CLAIMING'		=> 'Benutzer kann Einladungen verwalten',
++ 	'ACL_A_INVITE_SEND'		=> 'Benutzer kann Einladungen Mitgliedern zuweisen',
++ 	'ACL_A_INVITE_PEND'		=> 'Benutzer kann ausstehende Einladungen verwalten',
++ 	'ACL_A_INVITE_USERS'	=> 'Benutzer kann eine Liste eingeladener Mitglieder einsehen',
++-	'ACL_M_INVITE_SIZE'		=> 'Benutzer kann Einladungsanfrage akzeptieren.',
+++	'ACL_M_INVITE_CLAIMING'		=> 'Benutzer kann Einladungsanfrage akzeptieren.',
++ 	'ACL_U_INVITE_DELETE'	=> 'Benutzer kann Einladung zurückziehen<br /><em>Benutzer kann eine Einladung, die er vergeben hat, abbrechen.</em>',
++ 	'ACL_U_INVITE_REQUEST'	=> 'Benutzer kann Einladung anfordern',
++-	'ACL_U_INVITE_SEND'		=> 'Benutzer kann neue Mitglieder zur Seite einladen',
+++	'ACL_U_INVITE_SENDING'		=> 'Benutzer kann neue Mitglieder zur Seite einladen',
++ 	'ACL_U_INVITE_MAX'		=> 'Benutzer hat unbegrenzte Einladungen',
++ 	'ACL_U_INVITE_USERS'	=> 'Benutzer kann eine Liste der von anderen Benutzern eingeladenen Mitglieder einsehen.',
++ ));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/language/de_x_sie/permissions_invite.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/de_x_sie/permissions_invite.php"
++index ba6f116a5..1cdd87b47 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/language/de_x_sie/permissions_invite.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/de_x_sie/permissions_invite.php"
++@@ -38,14 +38,14 @@ $lang = array_merge($lang, array(
++ 	'ACL_A_INVITE'			=> 'Benutzer kann Daten synchronisieren',
++ 	'ACL_A_INVITE_CONFIG'	=> 'Benutzer kann Einladungen konfigurieren.',
++ 	'ACL_A_INVITE_DELETE'	=> 'Benutzer kann Einladungen löschen',
++-	'ACL_A_INVITE_SIZE'		=> 'Benutzer kann Einladungen verwalten',
+++	'ACL_A_INVITE_CLAIMING'		=> 'Benutzer kann Einladungen verwalten',
++ 	'ACL_A_INVITE_SEND'		=> 'Benutzer kann Einladungen Mitgliedern zuweisen',
++ 	'ACL_A_INVITE_PEND'		=> 'Benutzer kann ausstehende Einladungen verwalten',
++ 	'ACL_A_INVITE_USERS'	=> 'Benutzer kann eine Liste eingeladener Mitglieder einsehen',
++-	'ACL_M_INVITE_SIZE'		=> 'Benutzer kann Einladungsanfrage akzeptieren.',
+++	'ACL_M_INVITE_CLAIMING'		=> 'Benutzer kann Einladungsanfrage akzeptieren.',
++ 	'ACL_U_INVITE_DELETE'	=> 'Benutzer kann Einladung zurückziehen<br /><em>Benutzer kann eine Einladung, die er vergeben hat, abbrechen.</em>',
++ 	'ACL_U_INVITE_REQUEST'	=> 'Benutzer kann Einladung anfordern',
++-	'ACL_U_INVITE_SEND'		=> 'Benutzer kann neue Mitglieder zur Seite einladen',
+++	'ACL_U_INVITE_SENDING'		=> 'Benutzer kann neue Mitglieder zur Seite einladen',
++ 	'ACL_U_INVITE_MAX'		=> 'Benutzer hat unbegrenzte Einladungen',
++ 	'ACL_U_INVITE_USERS'	=> 'Benutzer kann eine Liste der von anderen Benutzern eingeladenen Mitglieder einsehen.',
++ ));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/language/en/info_acp_invite.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/en/info_acp_invite.php"
++index a5397f2da..7a94c6896 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/language/en/info_acp_invite.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/en/info_acp_invite.php"
++@@ -45,7 +45,9 @@ $lang = array_merge($lang, array(
++ 	'ACP_INVITED_PEND_COUNT'							=> 'All Invitations (%s)',
++ 	'ACP_INVITED_USERS_COUNT'							=> 'All users (%s)',
++ 	'ACP_INVITE_ALL_USER_INVITE_MAX'					=> 'Unlimited invitation for everyone',
++-	'ACP_INVITE_ALL_USER_INVITE_MAX_EXPLAIN'			=> 'if selected, all users will have unlimited invitations.',
+++	'ACP_INVITE_ALL_USER_INVITE_MAX_EXPLAIN'			=> 'If selected, all users will have unlimited invitations.',
+++	'ACP_INVITE_RESTORE_INVITES'						=> 'Restore expired and refused invitations',
+++	'ACP_INVITE_RESTORE_INVITES_EXPLAIN'				=> 'If selected, invitations that were expired or refused could be reused again.',
++ 	'ACP_INVITE_BIRTHDAYS'								=> 'Birthday',
++ 	'ACP_INVITE_BIRTHDAYS_EXPLAIN'						=> 'You can set how many invitations a user will receive for their birthday. <em>To let this setting take effect the birthday feature needs to be enabled too.</em>',
++ 	'ACP_INVITE_CAPTCHA'								=> 'Visual confirmation',
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/language/en/info_ucp_invite.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/en/info_ucp_invite.php"
++index 5c4a7ebdd..a1f961d09 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/language/en/info_ucp_invite.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/en/info_ucp_invite.php"
++@@ -39,6 +39,10 @@ $lang = array_merge($lang, array(
++ 
++ 	'UCP_CAT_INVITE'						=> 'phpBB Invite',
++ 	'UCP_INVITE'							=> 'Invitation',
+++	'UCP_INVITE_LABEL'						=> 'GoldTugAnime - Invitation',
+++	'UCP_INVITE_MESSAGE'					=> 'Welcome to the most beautiful Portuguese (Portugal) Animation Community!
+++
+++We hope you have fun and that animation never stops being part of your life.',
++ 	'UCP_INVITE_DATA'						=> 'Invitation details',
++ 	'UCP_INVITE_BACK'						=> '<br /><br />%sBack to the user control panel%s',
++ 	'UCP_INVITE_DAYF'						=> 'Invitations sent today',
++@@ -92,9 +96,11 @@ $lang = array_merge($lang, array(
++ 	'UCP_INVITE_REQUEST_SUBMIT'				=> 'Send request',
++ 	'UCP_INVITE_REQUEST_SUCC'				=> 'The invitation request has been successfully sent!',
++ 	'UCP_INVITE_REQUEST_SUCCS'				=> 'The invitation requests have been successfully sent!',
++-	'UCP_INVITE_REQUEST_TITLE'				=> 'Required invitations',
++-	'UCP_INVITE_REQUEST_TITLE_EXPLAIN'		=> 'Enter the number of invitations you want to request. There is a maximum of <b>(%s)</b> invitation(s) available.<br />You take full responsibility for your invited user(s) if they behave inappropriately.',
+++	'UCP_INVITE_REQUEST_TITLE'				=> 'Request invitations',
+++	'UCP_INVITE_REQUEST_TITLE_EXPLAIN'		=> 'Enter the number of invitations you want to request. There is a maximum of <b>(%s)</b> invitation(s) available.',
+++	'UCP_INVITE_REQUEST_COST'				=> '<div class="invitation_tred alert alert-danger">Invitation price is <b>50.000 points</b>.</div>',
++ 	'UCP_INVITE_SEND'						=> 'Send invitation',
+++	'UCP_INVITE_SEND_EXPLAIN'			=> '<div class="invitation_tred alert alert-danger">You take some responsibility for your invited user(s) if they behave inappropriately.</div>',
++ 	'UCP_INVITE_SEND_EMAIL_MAX'				=> 'Maximum %s e-mail addresses can be used. However you listed %s!',
++ 	'UCP_INVITE_SEND_MAX'					=> '<span class="invitation_tred">Currently there is no limit!</span>',
++ 	'UCP_INVITE_LAST_ACTIVE'				=> 'Last active',
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/language/en/invite.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/en/invite.php"
++index 740a03f88..bacafca7f 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/language/en/invite.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/en/invite.php"
++@@ -36,6 +36,7 @@ if (empty($lang) || !is_array($lang))
++ 
++ $lang = array_merge($lang, array(
++ 	'INVITE'								=> 'Invite',
+++	'INVITE_INFO'								=> 'Invite Information',
++ 	'INVITE_DELETE_CONFIRM'					=> 'If you want to delete the invitation, click %sHERE%s.',
++ 	'INVITE_DELETE_SUCCESS'					=> 'Your invitation was successfully deleted.',
++ 	'INVITE_DELETE_SUCCESSES'				=> 'Your invitations were successfully deleted.',
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/language/en/permissions_invite.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/en/permissions_invite.php"
++index 12d8e8f6b..2a2ac278b 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/language/en/permissions_invite.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/en/permissions_invite.php"
++@@ -38,14 +38,14 @@ $lang = array_merge($lang, array(
++ 	'ACL_A_INVITE'			=> 'User can synchronize data',
++ 	'ACL_A_INVITE_CONFIG'	=> 'User can change invitation settings.',
++ 	'ACL_A_INVITE_DELETE'	=> 'User can delete invitations',
++-	'ACL_A_INVITE_SIZE'		=> 'User can manage invitations',
+++	'ACL_A_INVITE_CLAIMING'		=> 'User can manage invitations',
++ 	'ACL_A_INVITE_SEND'		=> 'User can allocate invitations to members',
++ 	'ACL_A_INVITE_PEND'		=> 'User can manage pending invitations',
++ 	'ACL_A_INVITE_USERS'	=> 'User can see a list of invited members',
++-	'ACL_M_INVITE_SIZE'		=> 'User can approve invitation application.',
+++	'ACL_M_INVITE_CLAIMING'		=> 'User can approve invitation application.',
++ 	'ACL_U_INVITE_DELETE'	=> 'User can revoke invitation<br /><em>User can cancel an invitation he has sent.</em>',
++ 	'ACL_U_INVITE_REQUEST'	=> 'User can request invitation',
++-	'ACL_U_INVITE_SEND'		=> 'User can invite new members to the site',
+++	'ACL_U_INVITE_SENDING'		=> 'User can invite new members to the site',
++ 	'ACL_U_INVITE_MAX'		=> 'User has unlimited invitations',
++ 	'ACL_U_INVITE_USERS'	=> 'User can view the list of users invited by others.',
++ ));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/language/fr/permissions_invite.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/fr/permissions_invite.php"
++index db5471479..c829b086e 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/language/fr/permissions_invite.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/fr/permissions_invite.php"
++@@ -38,14 +38,14 @@ $lang = array_merge($lang, array(
++ 	'ACL_A_INVITE'			=> 'Peut synchroniser les données',
++ 	'ACL_A_INVITE_CONFIG'	=> 'Peut changer les paramètres d’invitation',
++ 	'ACL_A_INVITE_DELETE'	=> 'Peut supprimer des invitations',
++-	'ACL_A_INVITE_SIZE'		=> 'Peut gérer les invitations',
+++	'ACL_A_INVITE_CLAIMING'		=> 'Peut gérer les invitations',
++ 	'ACL_A_INVITE_SEND'		=> 'Peut allouer des invitations à des membres',
++ 	'ACL_A_INVITE_PEND'		=> 'Peut gérer les invitations en attente',
++ 	'ACL_A_INVITE_USERS'	=> 'Peut voir les listes de membres invités',
++-	'ACL_M_INVITE_SIZE'		=> 'Peut approuver une demande d’invitation',
+++	'ACL_M_INVITE_CLAIMING'		=> 'Peut approuver une demande d’invitation',
++ 	'ACL_U_INVITE_DELETE'	=> 'Peut annuler une invitation qu’il a envoyée',
++ 	'ACL_U_INVITE_REQUEST'	=> 'Peut demander une invitation',
++-	'ACL_U_INVITE_SEND'		=> 'Peut inviter des nouveaux membres sur le site',
+++	'ACL_U_INVITE_SENDING'		=> 'Peut inviter des nouveaux membres sur le site',
++ 	'ACL_U_INVITE_MAX'		=> 'Peut disposer d’un nombre illimité d’invitations',
++ 	'ACL_U_INVITE_USERS'	=> 'Peut voir la liste des membres invités par les autres',
++ ));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/language/hu/permissions_invite.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/hu/permissions_invite.php"
++index 6f3963e45..0c7d8b12d 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/language/hu/permissions_invite.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/hu/permissions_invite.php"
++@@ -38,14 +38,14 @@ $lang = array_merge($lang, array(
++ 	'ACL_A_INVITE'			=> 'Szinkronizálhatja az adatokat',
++ 	'ACL_A_INVITE_CONFIG'	=> 'Módosíthatja a beállításokat',
++ 	'ACL_A_INVITE_DELETE'	=> 'Törölheti a felhasználók meghívóját',
++-	'ACL_A_INVITE_SIZE'		=> 'Kezelheti a meghívó kérelmeket',
+++	'ACL_A_INVITE_CLAIMING'		=> 'Kezelheti a meghívó kérelmeket',
++ 	'ACL_A_INVITE_SEND'		=> 'Kiutalhat meghívókat',
++ 	'ACL_A_INVITE_PEND'		=> 'Kezelheti a függőben lévő meghívókat',
++ 	'ACL_A_INVITE_USERS'	=> 'Láthatja a meghívott személyek listáját',
++-	'ACL_M_INVITE_SIZE'		=> 'Jóváhagyhat meghívó iránti kérelmet',
+++	'ACL_M_INVITE_CLAIMING'		=> 'Jóváhagyhat meghívó iránti kérelmet',
++ 	'ACL_U_INVITE_DELETE'	=> 'Törölheti a már kiküldött meghívót<br /><em>Ha rossz címre küldi netán a meghívót akkor esélye van azt törölni.</em>',
++ 	'ACL_U_INVITE_REQUEST'	=> 'Igényelhet meghívót',
++-	'ACL_U_INVITE_SEND'		=> 'Meghívhat új tagot az pagera',
+++	'ACL_U_INVITE_SENDING'		=> 'Meghívhat új tagot az pagera',
++ 	'ACL_U_INVITE_MAX'		=> 'Korlátlan meghívóval rendelkezzen',
++ 	'ACL_U_INVITE_USERS'	=> 'Megtekintheti a mások által meghívott felhasználók listáját.',
++ ));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/language/nl/permissions_invite.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/nl/permissions_invite.php"
++index 6ade6a512..805a255b7 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/language/nl/permissions_invite.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/nl/permissions_invite.php"
++@@ -38,14 +38,14 @@ $lang = array_merge($lang, array(
++ 	'ACL_A_INVITE'			=> 'Gebruiker kan data synchroniseren',
++ 	'ACL_A_INVITE_CONFIG'	=> 'Gebuiker kan uitnodigings instellingen veranderen.',
++ 	'ACL_A_INVITE_DELETE'	=> 'Gebruiker kan uitnodigingen verwijderen',
++-	'ACL_A_INVITE_SIZE'		=> 'Gebruiker kan uitnodigingen beheren',
+++	'ACL_A_INVITE_CLAIMING'		=> 'Gebruiker kan uitnodigingen beheren',
++ 	'ACL_A_INVITE_SEND'		=> 'Gebruiker kan uitnodigingen toewijzen aan leden',
++ 	'ACL_A_INVITE_PEND'		=> 'Gebruiker kan wachtende uitnodigingen beheren',
++ 	'ACL_A_INVITE_USERS'	=> 'Gebruiker kan een lijst van uitgenodigde leden zien',
++-	'ACL_M_INVITE_SIZE'		=> 'Gebruiker kan een aanvraag van een uitnodiging accepteren.',
+++	'ACL_M_INVITE_CLAIMING'		=> 'Gebruiker kan een aanvraag van een uitnodiging accepteren.',
++ 	'ACL_U_INVITE_DELETE'	=> 'Gebruiker kan een uitnodiging intrekken<br /><em>Gebruiker kan een uitnodiging die hij heeft gestuurd annuleren.</em>',
++ 	'ACL_U_INVITE_REQUEST'	=> 'Gebruiker kan een uitnodiging aanvragen',
++-	'ACL_U_INVITE_SEND'		=> 'Gebruiker kan leden uitnodigen naar de site',
+++	'ACL_U_INVITE_SENDING'		=> 'Gebruiker kan leden uitnodigen naar de site',
++ 	'ACL_U_INVITE_MAX'		=> 'Gebruiker heeft ongelimiteerd uitnodigingen',
++ 	'ACL_U_INVITE_USERS'	=> 'Gebruiker kan de lijst met uitnodigingen door andere bekijken.',
++ ));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/language/pt_pt/common.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt/common.php"
++similarity index 100%
++rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/language/pt_pt/common.php"
++rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt/common.php"
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/language/pt_pt/email/user_invite.txt" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt/email/user_invite.txt"
++similarity index 100%
++rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/language/pt_pt/email/user_invite.txt"
++rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt/email/user_invite.txt"
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/language/pt_pt/email/user_invite_request.txt" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt/email/user_invite_request.txt"
++similarity index 100%
++rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/language/pt_pt/email/user_invite_request.txt"
++rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt/email/user_invite_request.txt"
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/language/pt_pt/email/user_invites.txt" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt/email/user_invites.txt"
++similarity index 100%
++rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/language/pt_pt/email/user_invites.txt"
++rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt/email/user_invites.txt"
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt/info_acp_invite.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt/info_acp_invite.php"
++new file mode 100644
++index 000000000..d929b5bcd
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt/info_acp_invite.php"
++@@ -0,0 +1,229 @@
+++<?php
+++
+++/**
+++ *
+++ * Invite. An extension for the phpBB Forum Software package.
+++ * Brazilian Portuguese translation by eunaumtenhoid [2019][ver 4.2.0] (https://github.com/phpBBTraducoes)
+++ * @copyright (c) 2010-2015, KillBill
+++ * @copyright (c) 2017, kasimi
+++ * @copyright (c) 2017-2022, Leinad4Mind, https://leinad4mind.top/forum
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
+++// Some characters you may want to copy&paste: ’ « » „ “ ” …
+++
+++$lang = array_merge($lang, array(
+++	'ACC_INVITE_DISABLE'								=> 'Convite desativado',
+++	'ACC_INVITE_ENABLE'									=> 'Apenas com convite',
+++	'ACC_INVITE_REGISTER'								=> 'Convite + Registo',
+++	'ACP_CAT_INVITE'									=> 'phpBB Invite',
+++	'ACP_INVITE_REGISTER'								=> 'Criando ID por convite',
+++	'ACP_INVITE_REGISTER_EXPLAIN'						=> 'definir opções de registo, pode ser usado como um único recurso, se necessário.<br />Desativar registo substitui todas as opções!',
+++	'ACP_INVITE'										=> 'Convite',
+++	'ACP_INVITED_PEND_COUNT'							=> 'Todos Convites (%s)',
+++	'ACP_INVITED_USERS_COUNT'							=> 'Todos os utilizadores (%s)',
+++	'ACP_INVITE_ALL_USER_INVITE_MAX'					=> 'Convite ilimitado para todos',
+++	'ACP_INVITE_ALL_USER_INVITE_MAX_EXPLAIN'			=> 'Se sim, todos os utilizadores terão convites ilimitados.',
+++	'ACP_INVITE_RESTORE_INVITES'						=> 'Restaurar convites expirados e recusados',
+++	'ACP_INVITE_RESTORE_INVITES_EXPLAIN'				=> 'Caso um convite expire ou seja recusado deverá o convite ser novamente disponibilizado ao utilizador.',
+++	'ACP_INVITE_BIRTHDAYS'								=> 'Aniversário',
+++	'ACP_INVITE_BIRTHDAYS_EXPLAIN'						=> 'Podes definir quantos convites um utilizador receberá no seu aniversário. <em>Para que essa configuração tenha efeito, o recurso de aniversário também precisa ser activado.</em>',
+++	'ACP_INVITE_CAPTCHA'								=> 'Confirmação visual',
+++	'ACP_INVITE_CAPTCHA_EXPLAIN'						=> 'Os utilizadores devem inserir um código aleatório de uma imagem.',
+++	'ACP_INVITE_CONFIG'									=> 'Configurações',
+++	'ACP_INVITE_CONFIG_EXPLAIN'							=> 'Aqui poderás configurar a extensão de convite.',
+++	'ACP_INVITE_CONFIG_GIFT'							=> 'Configurações de presente',
+++	'ACP_INVITE_CONFIG_GROUP'							=> 'Configurações de grupo',
+++	'ACP_INVITE_CONFIG_REQUEST'							=> 'Configurações de solicitações',
+++	'ACP_INVITE_DB'										=> 'item',
+++	'ACP_INVITE_DEFAULT_GROUP'							=> 'Tornar o grupo padrão',
+++	'ACP_INVITE_DEFAULT_GROUP_EXPLAIN'					=> 'O grupo selecionado também será o grupo padrão para utilizadores convidados.<br /><em>Observe que essa configuração substitui a configuração "Definir utilizadores recém-registados como padrão".</em>',
+++	'ACP_INVITE_DEFAULT_GROUP_USERS'					=> 'Todos os utilizadores no grupo',
+++	'ACP_INVITE_DEFAULT_GROUP_USERS_EXPLAIN'			=> 'Você precisa selecionar no mínimo um grupo. Você precisa selecionar sim ou não para especificar se todos os utilizadores desse grupo seleccionado são afectados ou apenas se os utilizadores são membros do grupo padrão.',
+++	'ACP_INVITE_DELETES_PEND_CONFIRM'					=> 'Tens a certeza de que desejas excluir os convites selecionados?<br /><em>Observação: Se confirmares, as pessoas convidadas não poderão mais usar os teus convites!</em>',
+++	'ACP_INVITE_DELETE_ALL_PEND_CONFIRM'				=> 'Tens a certeza de que desejas excluir todos os convites?<br /><em>Observação: Se confirmares, os convidados não poderão mais usar o teu convite!</em>',
+++	'ACP_INVITE_DELETE_GROUPS_CONFIRM'					=> 'Tens a certeza de que desejas excluir os convites de grupos selecionados?',
+++	'ACP_INVITE_DELETE_GROUP_CONFIRM'					=> 'Tens a certeza de que desejas excluir os convites do grupo selecionado?',
+++	'ACP_INVITE_DELETE_PEND_CONFIRM'					=> 'Tens a certeza de que desejas excluir o convite selecionado?<br /><em>Observação: Se confirmares, a pessoa convidada não poderá mais usar o convite!</em>',
+++	'ACP_INVITE_DELETE_TIME'							=> 'Expirar tempo para excluir convites',
+++	'ACP_INVITE_DELETE_TIME_EXPLAIN'					=> 'Podes definir a hora em que um utilizador pode excluir convites enviados para o endereço de e-mail errado.',
+++	'ACP_INVITE_DELETE_USERS_CONFIRM'					=> 'Tens a certeza de que desejas excluir os convites dos utilizadores selecionados?',
+++	'ACP_INVITE_DELETE_USER_CONFIRM'					=> 'Tens a certeza de que desejas excluir os convites do utilizador selecionado?',
+++	'ACP_INVITE_DISABLED'								=> 'O sistema de convite está desativado!',
+++	'ACP_INVITE_DENY'									=> 'Rejeitar',
+++	'ACP_INVITE_EMAIL_BOARD_DISABLED'					=> '<strong>phpBB Invite:</strong> O envio de e-mails está, de momento, desativado!<br />Enquanto estiver desativado, os convites não devem funcionar. Se quiseres activá-lo, podes fazê-lo %sAQUI%s.',
+++	'ACP_INVITE_EMAIL_DISABLED'							=> 'Envio de e-mails foi desativado, por favor, ative-o. %sVá às configurações de e-mail.%s ',
+++	'ACP_INVITE_EMAIL_PRIORITY'							=> 'Prioridade do email de convite',
+++	'ACP_INVITE_MEMBERSHIP_DAYS'						=> 'Número mínimo de dias de registo',
+++	'ACP_INVITE_MEMBERSHIP_DAYS_EXPLAIN'				=> 'Número de dias que um utilizador precisa de ter para poder usar o sistema de convites. Colocar 0 para desativar e permitir uso imediato.',
+++	'ACP_INVITE_ENABLE'									=> 'Ativar extensão de convite',
+++	'ACP_INVITE_ENABLE_EXPLAIN'							=> 'Se o ativares, a extensão do convite será usada.',
+++	'ACP_INVITE_VALIDATION'								=> 'Tempo de expiração dos convites enviados',
+++	'ACP_INVITE_VALIDATION_EXPLAIN'						=> 'Podes definir o tempo de expiração dos convites enviados. Após esse período, o ID do convite será excluído, portanto, não é mais possível registá-lo.',
+++	'ACP_INVITE_EXPLAIN'								=> 'O valor será adicionado.',
+++	'ACP_INVITE_GIFT_NUMBER_INVITES'					=> 'Número de convites presenteado',
+++	'ACP_INVITE_GIFT_INVITED_USERS'						=> 'Utilizadores convidados',
+++	'ACP_INVITE_GIFT_INVITED_USERS_EXPLAIN'				=> 'Os utilizadores receberão um convite de presente após esse número de utilizadores convidados.<br /><em>Se "0", essa função será desativada.</em>',
+++	'ACP_INVITE_POSTS_GIFT_INVITES'						=> 'Convites por Intervalo',
+++	'ACP_INVITE_POSTS_GIFT_INVITES_EXPLAIN'				=> 'Número de convites que um utilizador irá receber após atingir o número de x mensagens. Colocar 0 para desativar.',
+++	'ACP_INVITE_POSTS_GIFT_POSTS'						=> 'Intervalo de Mensagens',
+++	'ACP_INVITE_POSTS_GIFT_POSTS_EXPLAIN'				=> 'O utilizador irá receber a cada x mensagens o número de convites inserido no campo acima. Colocar 0 para desativar.',
+++	'ACP_INVITE_POSTS_GIFT_LIMIT'						=> 'Limite do Intervalo',
+++	'ACP_INVITE_POSTS_GIFT_LIMIT_EXPLAIN'				=> 'Número máximo de intervalos que um utilizador irá receber convites. Por exemplo, colocar intervalo de 30 mensagens com limite de 3 vezes irá enviar convites quando o utilizador atingir 30, 60 e 90 mensagens. Colocar 0 para desativar.',
+++	'ACP_INVITE_GROUP'									=> 'Grupo de utilizadores convidados',
+++	'ACP_INVITE_GROUP_ENABLED'							=> 'Ativer o uso de grupo',
+++	'ACP_INVITE_GROUP_ENABLED_EXPLAIN'					=> 'If enabled, invited users will automatically be added to the selected group.',
+++	'ACP_INVITE_GROUP_EXPLAIN'							=> 'The invited users will be added to the selected group.<br /><em>Note that the pre-defined system groups are not on the list.</em>',
+++	'ACP_INVITE_GROUPS_MANAGEMENT'						=> 'Manage Group',
+++	'ACP_INVITE_CLAIMING'									=> 'Invitation requests',
+++	'ACP_INVITE_CLAIMING_EXPLAIN'							=> 'View / decide about users invitation requests.',
+++	'ACP_INVITE_INDEX_TITLE'							=> 'Welcome to phpBB Invite!',
+++	'ACP_INVITE_INDEX_TITLE_EXPLAIN'					=> 'Thank you for choosing phpBB Invite. On this page you can see an overview of various statistical data of the invite system. On top of the page and via the links on the left side of the invite you can change every part in detail. On every page you will find a description of the current settings.',
+++	'ACP_INVITE_INSTALL'								=> 'Installation date',
+++	'ACP_INVITE_HANDLING'								=> 'Manage users/groups',
+++	'ACP_INVITE_HANDLING_EXPLAIN'						=> 'Here you can grant or revoke the invitations for users and groups.',
+++	'ACP_INVITE_HANDLING_GROUPS_DELETE'					=> 'The invitations of the following group were deleted successfully. <br /><br />(<em><b>%s</b></em>).',
+++	'ACP_INVITE_HANDLING_GROUPS_DELETES'				=> 'The invitations of the following groups were deleted successfully. <br /><br />(<em><b>%s</b></em>).',
+++	'ACP_INVITE_HANDLING_GROUPS_IG'						=> 'Successfully delivered the invitation to (<em><b>%s</b></em>) group.<br />Sent invitation: (<em><b>%s</b></em>)',
+++	'ACP_INVITE_HANDLING_GROUPS_IGS'					=> 'Successfully delivered the invitation to (<em><b>%s</b></em>) groups.<br />Sent invitation: (<em><b>%s</b></em>)',
+++	'ACP_INVITE_HANDLING_GROUPS_ISG'					=> 'Successfully delivered the invitations to (<em><b>%s</b></em>) group.<br />Sent invitations: (<em><b>%s</b></em>).',
+++	'ACP_INVITE_HANDLING_GROUPS_ISGS'					=> 'Successfully delivered the invitations to (<em><b>%s</b></em>) groups.<br />Sent invitations: (<em><b>%s</b></em>).',
+++	'ACP_INVITE_HANDLING_USERS_DELETE'					=> 'The invitations of the following user were deleted successfully<br /><br />(<em><b>%s</b></em>).',
+++	'ACP_INVITE_HANDLING_USERS_DELETES'					=> 'The invitations of the following users were deleted successfully<br /><br />(<em><b>%s</b></em>).',
+++	'ACP_INVITE_HANDLING_USERS_ISU'						=> 'Successfully delivered the invitations to (<em><b>%s</b></em>) user.<br />Sent invitations: (<em><b>%s</b></em>).',
+++	'ACP_INVITE_HANDLING_USERS_ISUS'					=> 'Successfully delivered the invitations to (<em><b>%s</b></em>) users.<br />Sent invitations: (<em><b>%s</b></em>).',
+++	'ACP_INVITE_HANDLING_USERS_IU'						=> 'Successfully delivered the invitation to (<em><b>%s</b></em>) user.<br /> Sent invitation: (<em><b>%s</b></em>).',
+++	'ACP_INVITE_HANDLING_USERS_IUS'						=> 'Successfully delivered the invitation to (<em><b>%s</b></em>) users.<br />Sent invitation: (<em><b>%s</b></em>).',
+++	'ACP_INVITE_HANDLING_USER_I'						=> 'Number of invitation changed successfully for user (<em><b>%s</b></em>).<br />New quantity: (<em><b>%s</b></em>).',
+++	'ACP_INVITE_HANDLING_USER_IS'						=> 'Number of invitations changed successfully for user (<em><b>%s</b></em>).<br />New quantity: (<em><b>%s</b></em>).',
+++	'ACP_INVITE_ALLOCATE'								=> 'Add',
+++	'ACP_INVITE_SEND_DAY_DB'							=> 'Number of invitations to be sent per day',
+++	'ACP_INVITE_SEND_DAY_DB_EXPLAIN'					=> 'You can set the maximum number of invites a user can send per day.<br /><em>(0=unlimited.)</em>',
+++	'ACP_INVITE_SEND_DB_NUM'							=> 'number of pieces',
+++	'ACP_INVITE_MAIL_FIX'								=> 'Allow e-mail address switching',
+++	'ACP_INVITE_MAIL_FIX_EXPLAIN'						=> 'It allows to specify a different e-mail address during the registration.',
+++	'ACP_INVITE_MAIN'									=> 'Overview',
+++	'ACP_INVITE_MAINTENANCE_UPDATE_INVITE'				=> 'The oldest version the phpBB Invite updater supports is <strong>“%s”</strong>. Please update to version <strong>“%s”</strong> before running the update to version <strong>“%s”</strong>.',
+++	'ACP_INVITE_MAINTENANCE_UPDATE_PHPBB'				=> 'You need to update phpBB to at least version <strong>“%s”</strong> before updating phpBB Invite to version <strong>“%s”</strong>.',
+++	'ACP_INVITE_MAIN_CONFIG'							=> 'Main settings',
+++	'ACP_INVITE_MEMBER'									=> '%s Pessoa',
+++	'ACP_INVITE_MESSAGE'								=> 'User justification',
+++	'ACP_INVITE_MESSAGE_TIME'							=> 'Request time',
+++	'ACP_INVITE_MINUS'									=> 'You can’t set a minus value.',
+++	'ACP_INVITE_MOD'									=> 'phpBB Invite',
+++	'ACP_INVITE_MORE_EMAIL_DB'							=> 'Set recipients limit',
+++	'ACP_INVITE_MORE_EMAIL_DB_EXPLAIN'					=> 'You can set the maximum number of invitations that can be sent at a time here.<br /><em>(1=disabled.)</em>',
+++	'ACP_INVITE_NEW_MEMBER_POST_LIMIT_IGNORED'			=> 'Ignore new members post limit',
+++	'ACP_INVITE_NEW_MEMBER_POST_LIMIT_IGNORED_EXPLAIN'	=> 'If set to yes, accepting an invitation will not get newly registered users into the “Newly registered users” group.',
+++	'ACP_INVITE_NEW_REG'								=> 'New registration',
+++	'ACP_INVITE_NEW_REG_EXPLAIN'						=> 'Number of invitations given to a new user once registered.',
+++	'ACP_INVITE_NO_ANONYMOUS'							=> 'Guest users can not be selected!',
+++	'ACP_INVITE_NO_GROUP'								=> 'No accessible group. If you want to create a new group can do it %sHERE%s.',
+++	'ACP_INVITE_NO_GROUP_SPECIFIED'						=> 'You didn’t select a group.',
+++	'ACP_INVITE_NO_PETITION'							=> 'There is currently no request for invitation!',
+++	'ACP_INVITE_NO_MARKED'								=> 'You have not selected a user either!',
+++	'ACP_INVITE_NO_PEND_INVITE'							=> 'There are currently no pending invitations.',
+++	'ACP_INVITE_NO_SELECT_INVITE'						=> 'You didn’t select an invitation!',
+++	'ACP_INVITE_NO_USERS'								=> 'Currently no received invitations!',
+++	'ACP_INVITE_NO_VALUE'								=> 'You didn’t set the number of invitations!',
+++	'ACP_INVITE_NUMBER_INVITED_USERS'					=> 'Number of invited users',
+++	'ACP_INVITE_PENDING'								=> 'Pending invitations',
+++	'ACP_INVITE_PENDING_EXPLAIN'						=> 'Here you can view and delete unused invitations sent out.',
+++	'ACP_INVITE_PEND_DATE'								=> 'Shipping time',
+++	'ACP_INVITE_PEND_DB'								=> 'Outstanding invitations',
+++	'ACP_INVITE_PEND_DELETE_ALL_SUCCESSES'				=> 'All pending invitations have been successfully deleted.',
+++	'ACP_INVITE_PEND_DELETE_MARKS_SUCCESSES'			=> 'The selected pending invitations have been successfully deleted.',
+++	'ACP_INVITE_PEND_DELETE_MARK_SUCCESSES'				=> 'The selected pending invitation has been successfully deleted.',
+++	'ACP_INVITE_PEND_EMAIL'								=> 'Recipient e-mail address',
+++	'ACP_INVITE_PEND_END_DATE'							=> 'Expiration date',
+++	'ACP_INVITE_PETITION_NSUCCESS'						=> 'The rejection was successful.',
+++	'ACP_INVITE_PETITION_NSUCCESSES'					=> 'The rejections were successful.',
+++	'ACP_INVITE_PETITION_YSUCCESS'						=> 'The allocation has been successfully completed.',
+++	'ACP_INVITE_PETITION_YSUCCESSES'					=> 'The allocations have been successfully completed.',
+++	'ACP_INVITE_NOTIFICATION_NO_USER'					=> 'The user name for sending notifications does not exist!',
+++	'ACP_INVITE_NOTIFICATION_USERNAME'					=> 'Notifications sender name',
+++	'ACP_INVITE_NOTIFICATION_USERNAME_EXPLAIN'			=> 'Name of the user who will send the notification.',
+++	'ACP_INVITE_POST_LIMIT_DB'							=> 'Total posts',
+++	'ACP_INVITE_POST_LIMIT_DB_EXPLAIN'					=> 'This is the post count needed to send out invitations.<br /><em>(0=disabled.)</em>',
+++	'ACP_INVITE_REG_EMAIL'								=> 'Registered e-mail',
+++	'ACP_INVITE_REQUEST_CAUSE'							=> 'Activation limit',
+++	'ACP_INVITE_REQUEST_CAUSE_EXPLAIN'					=> 'When claiming more than this number of invitations, a reason is required to continue.<br /><em>(0=disabled.)</em>',
+++	'ACP_INVITE_REQUEST_MAX'							=> 'Maximum number of invitations available',
+++	'ACP_INVITE_REQUEST_MAX_EXPLAIN'					=> '<em>(0=disable requests.)</em>',
+++	'ACP_INVITE_REQUIRE_AC_DISABLED'					=> 'Registration by invitation is not possible, since it is currently turned off!',
+++	'ACP_INVITE_SORT_NAME'								=> 'Invited',
+++	'ACP_INVITE_SYNC_DATA'								=> 'Resynchronise total data',
+++	'ACP_INVITE_SYNC_DATA_CONFIRM'						=> 'Are you sure you want to resynchronise the invite totals data?',
+++	'ACP_INVITE_SYNC_DATA_EXPLAIN'						=> 'The invite total data will be resynchronised, this includes the following: invited users, pending invitations and invitations claimed.',
+++	'ACP_INVITE_SYNC_DATA_SUCCESSES'					=> 'The invite total data was successfully resynchronised.',
+++	'ACP_INVITE_SYNC_USERS'								=> 'Ressincronize os dados dos utilizadores.',
+++	'ACP_INVITE_SYNC_USERS_CONFIRM'						=> 'Tens a certeza de que deseja ressincronizar os dados dos utilizadores convidados?',
+++	'ACP_INVITE_SYNC_USERS_EXPLAIN'						=> 'Os dados dos utilizadores convidados serão ressincronizados',
+++	'ACP_INVITE_SYNC_USERS_SUCCESSES'					=> 'Os dados dos utilizadores convidados foram ressincronizados com sucesso.',
+++	'ACP_INVITE_TOTAL_USERS'							=> 'Número de utilizadores convidados',
+++	'ACP_INVITE_TOTAL_USERS_DAY'						=> 'Número de utilizadores convidados por dia',
+++	'ACP_INVITE_UG_TASK'								=> 'Selecione uma tarefa',
+++	'ACP_INVITE_USERS'									=> 'Utilizadores que convidaram',
+++	'ACP_INVITE_USERS_COUNT'							=> 'Solicitações totais (%s)',
+++	'ACP_INVITE_USERS_EXPLAIN'							=> 'Aqui podes ver a lista de utilizadores que já convidaram um novo membro para o site.',
+++	'ACP_INVITE_USERS_MANAGEMENT'						=> 'Gerir utilizadores selecionados',
+++	'ACP_INVITE_USERS_NO_GROUP'							=> 'Não há utilizador no grupo selecionado.',
+++	'ACP_INVITE_USERS_NO_GROUPS'						=> 'Não há utilizador nos grupos selecionados.',
+++	'ACP_INVITE_USER_EXPLAIN'							=> 'O valor mudará a quantidade de convites do utilizador.',
+++	'ACP_INVITE_USER_LIST'								=> 'Número de utilizadores por página',
+++	'ACP_INVITE_USER_LIST_EXPLAIN'						=> 'Este valor define o número de utilizadores listados em uma página.',
+++	'ACP_INVITE_USER_MANAGEMENT'						=> 'Uma gestão de utilizadores',
+++	'ACP_INVITE_USER_MANAGEMENT_EXPLAIN'				=> 'Aqui podes alterar a quantidade de convites do utilizador.',
+++	'ACP_INVITE_USER_NAME'								=> 'nome',
+++
+++	'LOG_INVITE_CONFIG'							=> '<strong>Configuração de convite modificada.</strong>',
+++	'LOG_INVITE_DELETE'							=> '<strong>Convite Revogado.</strong><br />» Endereço de e-mail: %s',
+++	'LOG_INVITE_SIZE_DELETE'					=> '<strong>Convite Recusado</strong><br />» Utilizador: %s',
+++	'LOG_INVITE_INSTALL'						=> '<strong>phpBB Invite instalado</strong><br />» Versão: %s',
+++	'LOG_INVITE_HANDLING_GROUPS_DELETE'			=> '<strong>Convites apagados de um grupo.</strong><br />» <b>Grupo:</b> (<em>%s</em>).',
+++	'LOG_INVITE_HANDLING_GROUPS_DELETES'		=> '<strong>Convites apagados de grupos.</strong><br />» <b>Grupos:</b> (<em>%s</em>).',
+++	'LOG_INVITE_HANDLING_GROUPS_IG'				=> '<strong>Convite adicionado para um grupo.</strong><br />» <b>Grupo:</b> (<em>%s</em>)<br />» Convite adicionado: (%s).',
+++	'LOG_INVITE_HANDLING_GROUPS_IGS'			=> '<strong>Convite adicionado para grupos.</strong><br />» <b>Grupos:</b> (<em>%s</em>)<br />» Convite adicionado: (%s).',
+++	'LOG_INVITE_HANDLING_GROUPS_ISG'			=> '<strong>Convites adicionados para um grupo.</strong><br />» <b>Grupo:</b> (<em>%s</em>)<br />» Convites adicionados: (%s).',
+++	'LOG_INVITE_HANDLING_GROUPS_ISGS'			=> '<strong>Convites adicionados para grupos.</strong><br />» <b>Grupos:</b> (<em>%s</em>)<br />» Convites adicionados: (%s)',
+++	'LOG_INVITE_HANDLING_USERS_DELETE'			=> '<strong>Convites apagados de um utilizador.</strong><br />» <b>Utilizador:</b> (<em>%s</em>).',
+++	'LOG_INVITE_HANDLING_USERS_DELETES'			=> '<strong>Convites apagados de utilizadores.</strong><br />» <b>Utilizadores:</b> (<em>%s</em>).',
+++	'LOG_INVITE_HANDLING_USERS_ISU'				=> '<strong>Convite adicionado para um utilizador.</strong><br />» <b>Utilizador:</b> (<em>%s</em>)<br />» Convites adicionados: (%s).',
+++	'LOG_INVITE_HANDLING_USERS_ISUS'			=> '<strong>Convites adicionados para utilizadores.</strong><br />» <b>Utilizadores:</b> (<em>%s</em>)<br />» Convites adicionados: (%s).',
+++	'LOG_INVITE_HANDLING_USERS_IU'				=> '<strong>Convite adicionado para um utilizador.</strong><br />» <b>Utilizador:</b> (<em>%s</em>)<br />» Convites adicionados: (%s).',
+++	'LOG_INVITE_HANDLING_USERS_IUS'				=> '<strong>Convites adicionados para utilizadores.</strong><br />» <b>Utilizadores:</b> (<em>%s</em>)<br />» Convites adicionados: (%s).',
+++	'LOG_INVITE_HANDLING_USER_I'				=> '<strong>Mudou a quantidade de convites.</strong><br />» <b>Utilizador:</b> (<em>%s</em>)<br />» Nova quantidade: (%s) convite.',
+++	'LOG_INVITE_HANDLING_USER_IS'				=> '<strong>Mudou a quantidade de convites.</strong><br />» <b>Utilizador:</b> (<em>%s</em>)<br />» Nova quantidade: (%s) convites.',
+++	'LOG_INVITE_ALLOCATE'						=> '<strong>Convites adicionados para o utilizador %s.</strong><br />» Convites adicionados: %s.',
+++
+++	'LOG_INVITE_SEND_INVITATION'				=> '<strong>Convite enviado.</strong><br />» %s',
+++	'LOG_INVITE_SEND_INVITATIONS'				=> '<strong>Convites enviados.</strong><br />» %s',
+++
+++	'LOG_INVITE_PEND_ALL_DELETE'				=> '<strong>Excluiu todos os convites pendentes.</strong>',
+++	'LOG_INVITE_PEND_MARKED_DELETE'			=> '<strong>Excluído convite pendente selecionado.</strong><br />» Utilizador: %s',
+++	'LOG_INVITE_PEND_MARKED_DELETES'			=> '<strong>Excluídos convites pendentes selecionados.</strong><br />» Utilizadores: %s',
+++	'LOG_INVITE_SYNC_DATA'						=> '<strong>Ressincronização de dados de convite.</strong>',
+++	'LOG_INVITE_SYNC_USERS'						=> '<strong>Ressincronização de dados de convite do utilizador.</strong>',
+++));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/language/pt_pt/info_mcp_invite.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt/info_mcp_invite.php"
++similarity index 100%
++rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/language/pt_pt/info_mcp_invite.php"
++rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt/info_mcp_invite.php"
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/language/pt_pt/info_ucp_invite.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt/info_ucp_invite.php"
++similarity index 90%
++rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/language/pt_pt/info_ucp_invite.php"
++rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt/info_ucp_invite.php"
++index f4bc3ceb9..5f9f7062b 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/language/pt_pt/info_ucp_invite.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt/info_ucp_invite.php"
++@@ -39,6 +39,10 @@ $lang = array_merge($lang, array(
++ 
++ 	'UCP_CAT_INVITE'						=> 'phpBB Invite',
++ 	'UCP_INVITE'							=> 'Convites',
+++	'UCP_INVITE_LABEL'						=> 'GoldTugAnime - Convite',
+++	'UCP_INVITE_MESSAGE'					=> 'Bem-vindo à mais bela Comunidade de Animação em Português de Portugal!
+++
+++Esperamos que te divirtas e que a animação nunca deixe de fazer parte da tua vida.',
++ 	'UCP_INVITE_DATA'						=> 'Detalhes de convites',
++ 	'UCP_INVITE_BACK'						=> '<br /><br />%sVoltar para o painel de controlo do utilizador%s',
++ 	'UCP_INVITE_DAYF'						=> 'Convites enviados hoje',
++@@ -82,7 +86,7 @@ $lang = array_merge($lang, array(
++ 	'UCP_INVITE_REQUEST_BUY_SUBT_EXPLAIN'	=> 'Digita o número de convites que desejas comprar. O preço do convite é <b>%s %s</b>.<br />Assumes a responsabilidade pelo(s) teu(s) utilizador(es) convidado(s) se o(s) utilizador(es) convidado(s) causar(em) incidentes inapropriados.',
++ 	'UCP_INVITE_REQUEST_BUY_SUCCESS'		=> 'A compra do convite foi bem-sucedida.',
++ 	'UCP_INVITE_REQUEST_BUY_TITLE'			=> 'Comprar convite.',
++-	'UCP_INVITE_REQUEST_DISABLED'			=> 'As solicitacões de convites estão desactivadas!',
+++	'UCP_INVITE_REQUEST_DISABLED'			=> 'As solicitações de convites estão desactivadas!',
++ 	'UCP_INVITE_REQUEST_MAX'				=> 'Número máximo de pedidos: (%s) convite(s)!',
++ 	'UCP_INVITE_REQUEST_MESSAGE_NO_DB'		=> '<em>Não! Não houve necessidade.</em>',
++ 	'UCP_INVITE_REQUEST_MIN'				=> 'Número mínimo de convites solicitados: (1)',
++@@ -92,9 +96,11 @@ $lang = array_merge($lang, array(
++ 	'UCP_INVITE_REQUEST_SUBMIT'				=> 'Enviar pedido',
++ 	'UCP_INVITE_REQUEST_SUCC'				=> 'A solicitação de convite foi enviada com sucesso!',
++ 	'UCP_INVITE_REQUEST_SUCCS'				=> 'A solicitação de convites foram enviadas com sucesso!',
++-	'UCP_INVITE_REQUEST_TITLE'				=> 'Convites requisitados',
++-	'UCP_INVITE_REQUEST_TITLE_EXPLAIN'		=> 'Digita o número de convites que desejas solicitar. Há um máximo de <b>(%s)</b> convites disponíveis.<br />Assumes total responsabilidade pelo(s) teu(s) utilizador(es) convidado(s) se eles se comportarem de maneira inapropriada.',
+++	'UCP_INVITE_REQUEST_TITLE'				=> 'Requisitar convites',
+++	'UCP_INVITE_REQUEST_TITLE_EXPLAIN'		=> 'Digita o número de convites que desejas solicitar. Há um máximo de <b>(%s)</b> convites disponíveis.',
+++	'UCP_INVITE_REQUEST_COST'				=> '<div class="invitation_tred alert alert-danger">O preço por convite é de <b>50.000 pontos</b>.</div>',
++ 	'UCP_INVITE_SEND'						=> 'Enviar convite',
+++	'UCP_INVITE_SEND_EXPLAIN'			=> '<div class="invitation_tred alert alert-danger">Assumes parte da responsabilidade dos utilizadores que convidares caso eles se comportarem de maneira inapropriada.</div>',
++ 	'UCP_INVITE_SEND_EMAIL_MAX'				=> 'Máximo de %s endereços de e-mail podem ser usados. No entanto, listaste %s!', 
++ 	'UCP_INVITE_SEND_MAX'					=> '<span class="invitation_tred">Actualmente não há limite!</span>',
++ 	'UCP_INVITE_LAST_ACTIVE'				=> 'Última visita',
++@@ -108,6 +114,7 @@ $lang = array_merge($lang, array(
++ 	'UCP_INVITE_NO_LOGIN'					=> 'Ele/ela não se registou neste site.',
++ 	'UCP_INVITE_NO_PERM'					=> 'Não está autorizado a enviar convites!',
++ 	'UCP_INVITE_NO_PERM_EMAIL'				=> 'Não está autorizado a enviar e-mail!',
+++	'UCP_INVITE_MEMBERSHIP_DAYS'			=> 'A tua conta tem de ter pelo menos %1$d dias antes que possas fazer uso do sistema de convites. Poderás utilizar a partir de %2$s.',
++ 	'UCP_INVITE_NO_REG'						=> 'Ninguém foi convidado por ti.',
++ 	'UCP_INVITE_NULL'						=> 'Não tem convites! <em>Porque não comprar alguns?</em>', 
++ 	'UCP_INVITE_POINTS_AMOUNT'				=> 'Presente',
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt/install_invite.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt/install_invite.php"
++new file mode 100644
++index 000000000..dd11b1fa9
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt/install_invite.php"
++@@ -0,0 +1,156 @@
+++<?php
+++
+++/**
+++ *
+++ * Invite. An extension for the phpBB Forum Software package.
+++ *
+++ * @copyright (c) 2010-2015, KillBill
+++ * @copyright (c) 2017, kasimi
+++ * @copyright (c) 2017-2022, Leinad4Mind, https://leinad4mind.top/forum
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
+++// Some characters you may want to copy&paste: ’ « » „ “ ” …
+++
+++$lang = array_merge($lang, array(
+++	'AUTH_CACHE_PURGE'						=> 'Clear permission cache',
+++
+++	'CACHE_PURGE'							=> 'Clear forum cache',
+++	'CAT_INSTALL'							=> 'Install',
+++	'CAT_OVERVIEW'							=> 'Overview',
+++	'CAT_UNINSTALL'							=> 'Uninstall',
+++	'CAT_UPDATE'							=> 'Update',
+++	'CAT_VERIFY'							=> 'Verify',
+++
+++	'GPL'									=> 'General Public License',
+++
+++	'INCOMPLETE_FILES_UPLOAD'				=> 'All Invite files have not been uploaded! Please make sure to upload all files before running the installer.',
+++	'INCOMPLETE_FILE_EDITS'					=> 'Editing of this file has not been done yet. The installation can not run unless all files are edited correctly!',
+++	'INCOMPLETE_LANG_ROWS'					=> 'Some changes to the language files are missing. Please apply them as described %sHERE%s.',
+++	'INSTALLATION'							=> 'phpBB Invite install',
+++	'INSTALLATION_EXPLAIN'					=> '<br />phpBB Invite database install.<br /><br />',
+++	'INSTALL_BODY'							=> 'Here you can see that the mod is well established and has been properly installed.',
+++	'INSTALL_ERR_AUTH'						=> 'You are not authorized to use this script.<br /><br />Please note to use the script the following requirements must be met. First you must be logged in to the site and second you must have the user type founder. If you are logged in and are the founder then you have incorrect cookie settings in the ACP. Please check the cookie domain setting. If your site URL is <strong>http://www.example.com</strong> then the cookie domain should be <strong>.example.com</strong>.',
+++	'INSTALL_FOLDER'						=> '<strong>Please delete the install folder. Until you have done this, only the ACP will be available.</strong>',
+++	'INSTALL_LOGIN'							=> 'Proceed to ACP',
+++
+++	'INVITE_CONFIG_ADD'						=> 'Adding new invite config variable: %s',
+++	'INVITE_CONFIG_ALREADY_EXISTS'			=> 'ERROR: Invite config variable %s already exists.',
+++	'INVITE_CONFIG_NOT_EXIST'				=> 'ERROR: Invite config variable %s does not exist.',
+++	'INVITE_CONFIG_REMOVE'					=> 'Removing Invite config variable: %s',
+++	'INVITE_CONFIG_UPDATE'					=> 'Updating Invite config variable: %s',
+++
+++	'INVITE_INSTALL_INTRO'					=> 'Welcome to phpBB Invite Installation',
+++	'INVITE_INSTALL_INTRO_BODY'				=> 'With this option, it is possible to install phpBB Invite to your database.',
+++
+++	'INVITE_VERSION'						=> 'The installed phpBB Invite version is <b>%s</b>, this file can be used to update version <b>%s</b> to version <b>%s</b>. <br /> You first need to upgrade to version <b>%s</b> to run this update script!',
+++
+++	'NOT_INSTALL_DIR'						=> 'Cannot open the install folder!',
+++	'NOT_LANGUAGE_DIR'						=> 'The language library is not available!',
+++	'NOT_LANGUAGE_DIR_DIR'					=> 'The %s language directory cannot be found!',
+++	'NOT_MODULE'							=> 'The installation modules are not available!',
+++	'NOT_MODULE_OPEN'						=> '%s Module is not available!',
+++	'NO_TABLE_DATA'							=> '<span style="color:#FF0000;">Error:</span> The table data is missing.',
+++
+++	'OVERVIEW_BODY'							=> 'Welcome!<br /><br />The installation system presents a complete guide how to install the mod, or remove and update it.<br />Continue with the selection menu... Select the appropriate option from the menu.',
+++
+++	'PARENT_NOT_EXIST'						=> '<span style="color:#FF0000;">Error:</span> The parent category which shows the new module does not exist.',
+++	'PERMISSIONS_WARNING'					=> 'New permission settings have been added.  Check your permission settings and make sure that they are as you would like them.',
+++	'PHPBB_INVITE_DONATE'					=> 'Please make a small donation to appreciate the hard work and many hours used to make the “phpBB Invite”.',
+++	'PHPBB_INVITE_DONATE_TITLE'				=> 'phpBB Invite donation',
+++	'PHPBB_VERSION'							=> 'Your phpBB version is <b>%s</b>, the phpBB Invite mod requires version <b>%s</b> to run!',
+++	'PHP_VERSION_RUN'						=> 'The current PHP version is not supported, please update your PHP to version 4.3.3 or later before you run the installation.</b>',
+++
+++	'ROLE_NOT_EXIST'						=> '<span style="color:#FF0000;">Error:</span> this role is not in the database.',
+++
+++	'STAGE_INSTALL'							=> 'Install',
+++	'STAGE_INTRO'							=> 'Intro',
+++	'STAGE_UNINSTALL'						=> 'Delete the database',
+++	'STAGE_VERIFY'							=> 'Verify',
+++	'STAGE_VERIFY_FILE_EXPLAIN'				=> '<br />The mod files are successfully deleted.',
+++	'SUB_INTRO'								=> 'Intro',
+++	'SUB_LICENSE'							=> 'License',
+++	'SUB_SUPPORT'							=> 'Support',
+++	'SUCCESSES'								=> '<span style="color:#000;"><b>Successfully completed!</b></span>',
+++	'SUPPORT_BODY'							=> 'Full support will be provided for the current release and development versions, all for free.<br />This includes:</p><ul><li>information</li><li>configuration</li><li>update older versions to the newest version</li></ul><p>I encourage everyone who is using an older version to upgrade to the new version.</p><h2>Support forums</h2><br /><p><a href="http://jatek-vilag.com/viewtopic.php?p=204#p204" onclick="window.open(this.href); return false;">The main development site</a><br /><a href="https://www.phpbb.com/community/viewtopic.php?p=12855248#p12855248" onclick="window.open(this.href); return false;">phpBB.com Development topic</a><br /><a href="http://phpbb.hu/forum/hsz/40666#hsz-40666" onclick="window.open(this.href); return false;">phpBB.hu Development topic</a><br /><br />',
+++
+++	'UNINSTALL_BODY'						=> 'Here you can see that the mod database entries have been successfully removed.<br /><br /><b>Please delete the install folder. Until you have done this, only the ACP will be available.</b>',
+++	'UNINSTALL_INTRO'						=> 'phpBB Invite delete',
+++	'UNINSTALL_INTRO_BODY'					=> 'Under this option, you can delete the phpBB Invite from the database.',
+++	'UNINSTALL_TITLE'						=> 'phpBB Invite deleted from the database',
+++	'UPDATE_BODY'							=> 'Here you can see that database data created by this mod has been properly updated.<br /><br /><b>Please delete the install folder. Until you have done this, only the ACP will be available.</b>',
+++	'UPDATE_INSTALLATION'					=> 'phpBB Invite update',
+++	'UPDATE_INSTALLATION_EXPLAIN'			=> '<br />phpBB Invite update on the newest version.<br />',
+++	'UPDATE_TITLE'							=> 'Updating database data',
+++
+++	'VERIFY_ERROR_EXPLAIN'					=> 'The check found an error.',
+++	'VERIFY_ERROR_FILE'						=> 'Bad file modification',
+++	'VERIFY_ERROR_FILE_EXPLAIN'				=> 'Here you can see those files which have been incorrectly edited or has been omitted.',
+++	'VERIFY_EXITS_PRINT_MYAD'				=> '<br />The SQL command you see here you can install by yourself, if you load it in phpMyAdmin.',
+++	'VERIFY_EXITS_PRINT_SQL'				=> '<b><span style="color:#FF0000;">%s</span> <span style="color:#000;">not found!</span></b><br />%s<br />',
+++	'VERIFY_INVITE_MOD_CONFIG'				=> 'phpBB Invite configuration',
+++	'VERIFY_INVITE_MOD_CONFIG_OK'			=> '<span style="color:#228822;"><strong>All phpBB Invite config found.</strong></span>',
+++	'VERIFY_INVITE_MOD_FILES'				=> 'phpBB Invite files',
+++	'VERIFY_INVITE_MOD_FILES_OK'			=> '<span style="color:#228822;"><strong>All files found.</strong></span>',
+++	'VERIFY_INVITE_MOD_MODULES'				=> 'phpBB Invite modules',
+++	'VERIFY_INVITE_MOD_MODULES_OK'			=> '<span style="color:#228822;"><strong>All modules found.</strong></span>',
+++	'VERIFY_INVITE_MOD_PERM'				=> 'phpBB Invite permissions',
+++	'VERIFY_INVITE_MOD_PERM_OK'				=> '<span style="color:#228822;"><strong>All permissions found.</strong></span>',
+++	'VERIFY_INVITE_MOD_TABLES'				=> 'phpBB Invite tables',
+++	'VERIFY_INVITE_MOD_TABLES_OK'			=> '<span style="color:#228822;"><strong>All tables found.</strong></span>',
+++	'VERIFY_NOT_AC_FOUND'					=> '<b><span style="color:#FF0000;">%s</span> <span style="color:#000;">not found!</span></b>',
+++	'VERIFY_NOT_COLUMN'						=> 'Missing columns',
+++	'VERIFY_NOT_COLUMN_EXPLAIN'				=> 'Here you can see all the columns which were not installed.',
+++	'VERIFY_NOT_CONFIG'						=> 'Missing config',
+++	'VERIFY_NOT_CONFIG_EXPLAIN'				=> 'Here you can see the config files which have not been installed.',
+++	'VERIFY_NOT_FILE'						=> 'Missing files',
+++	'VERIFY_NOT_FILE_EXPLAIN'				=> 'Here you can see the files that have not been uploaded correctly or have been uploaded correctly but to the wrong place.',
+++	'VERIFY_NOT_INVITE_CONFIG'				=> 'Missing phpBB Invite config',
+++	'VERIFY_NOT_INVITE_CONFIG_EXPLAIN'		=> 'Here you can see the phpBB Invite config files which have not been installed.',
+++	'VERIFY_NOT_MODULE'						=> 'Missing modules',
+++	'VERIFY_NOT_MODULE_EXPLAIN'				=> 'Here you can see the modules which have not been installed.',
+++	'VERIFY_NOT_PERMIS'						=> 'Missing permissions',
+++	'VERIFY_NOT_PERMIS_EXPLAIN'				=> 'Here you can see the permissions that were not installed.',
+++	'VERIFY_NOT_TABLE'						=> 'Missing table',
+++	'VERIFY_NOT_TABLE_EXPLAIN'				=> 'Here you can see the signs which have not been installed.',
+++	'VERIFY_NO_COLUMN'						=> '<b><span style="color:#FF0000;">%s</span> <span style="color:#000;">column not found!</span></b><br />%s<br />',
+++	'VERIFY_NO_MODULE'						=> '<b><span style="color:#FF0000;">%s</span> <span style="color:#000;">module is not found in the database!</span></b>',
+++	'VERIFY_NO_PERMIS'						=> '<b><span style="color:#FF0000;">%s</span> <span style="color:#000;">permission is not found in the database!</span></b>',
+++	'VERIFY_NO_TABLE'						=> '<b><span style="color:#FF0000;">%s</span> <span style="color:#000;">table is not found in the database!</span></b>%s',
+++	'VERIFY_PHPBB_MOD_COLUMNS'				=> 'phpBB users table new columns',
+++	'VERIFY_PHPBB_MOD_COLUMNS_OK'			=> '<span style="color:#228822;"><strong>All columns found.</strong></span>',
+++	'VERIFY_PHPBB_MOD_CONFIG'				=> 'phpBB new config',
+++	'VERIFY_PHPBB_MOD_CONFIG_OK'			=> '<span style="color:#228822;"><strong>phpBB config found.</strong></span>',
+++	'VERIFY_PHPBB_MOD_FILES'				=> 'phpBB file edits',
+++	'VERIFY_PHPBB_MOD_FILES_OK'				=> '<span style="color:#228822;"><strong>All files are edited.</strong></span>',
+++	'VERIFY_SUCCESSES_EXPLAIN'				=> 'The check found everything okay.',
+++	'VERIFY_TITLE'							=> 'phpBB Invite control',
+++	'VERIFY_TITLE_ELL'						=> 'Control error',
+++	'VERIFY_TITLE_ELL_EXPLAIN'				=> '<span style="color:#000;"><b>Here you can see all occurred errors to fix everything carefully!</b></span>',
+++	'VERIFY_TITLE_EXPLAIN'					=> '<br />Here you can check whether all required file changes, configuration changes and database entries have been made successfully.',
+++	'VERIFY_NEW'							=> 'Check again',
+++	'VERIFY_UNINSTALL_ERROR_FILE'			=> 'Existing files',
+++	'VERIFY_UNINSTALL_ERROR_FILE_EXPLAIN'	=> 'Here you can see the files which have not been removed.',
+++));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/language/pt_pt/invite.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt/invite.php"
++similarity index 97%
++rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/language/pt_pt/invite.php"
++rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt/invite.php"
++index 35b3be28c..07794c344 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/language/pt_pt/invite.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt/invite.php"
++@@ -36,6 +36,7 @@ if (empty($lang) || !is_array($lang))
++ 
++ $lang = array_merge($lang, array(
++ 	'INVITE'								=> 'Convites',
+++	'INVITE_INFO'								=> 'Informação sobre Convites',
++ 	'INVITE_DELETE_CONFIRM'					=> 'Se quiseres apagar o convite, clica %sAQUI%s.',
++ 	'INVITE_DELETE_SUCCESS'					=> 'O teu convite foi apagados com sucesso.',
++ 	'INVITE_DELETE_SUCCESSES'				=> 'Os teus convites foram apagados com sucesso.',
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/language/pt_pt/permissions_invite.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt/permissions_invite.php"
++similarity index 96%
++rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/language/pt_pt/permissions_invite.php"
++rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt/permissions_invite.php"
++index 62e5529e0..90f45e670 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/language/pt_pt/permissions_invite.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt/permissions_invite.php"
++@@ -45,7 +45,7 @@ $lang = array_merge($lang, array(
++ 	'ACL_M_INVITE_CLAIMING'	=> 'O utilizador pode aprovar um pedido de convite.',
++ 	'ACL_U_INVITE_DELETE'	=> 'O utilizador pode revogar convites<br /><em>O utilizador pode cancelar um convite que ele enviou.</em>',
++ 	'ACL_U_INVITE_REQUEST'	=> 'O utilizador pode solicitar convite',
++-	'ACL_U_INVITE_SEND'		=> 'O utilizador pode convidar novos membros para o site',
+++	'ACL_U_INVITE_SENDING'		=> 'O utilizador pode convidar novos membros para o site',
++ 	'ACL_U_INVITE_MAX'		=> 'O utilizador tem convites ilimitados',
++ 	'ACL_U_INVITE_USERS'	=> 'O utilizador pode visualizar a lista de utilizadores convidados por outras pessoas.',
++ ));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/language/pt_br/info_acp_invite.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt_br/info_acp_invite.php"
++index 78982283a..a8b6d0607 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/language/pt_br/info_acp_invite.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt_br/info_acp_invite.php"
++@@ -70,10 +70,12 @@ $lang = array_merge($lang, array(
++ 	'ACP_INVITE_DELETE_USERS_CONFIRM'					=> 'Tem certeza de que deseja excluir os convites dos usuários selecionados?',
++ 	'ACP_INVITE_DELETE_USER_CONFIRM'					=> 'Tem certeza de que deseja excluir os convites do usuário selecionado?',
++ 	'ACP_INVITE_DISABLED'								=> 'O sistema de convite está desativado!',
++-	'ACP_INVITE_DENY'									=> 'Rejeição',
+++	'ACP_INVITE_DENY'									=> 'Rejeitar',
++ 	'ACP_INVITE_EMAIL_BOARD_DISABLED'					=> '<strong>phpBB Invite:</strong> O envio de e-mails está desativado no momento!<br />Enquanto estiver desativado, os convites não devem funcionar. Se você quiser ativa-lo, você pode fazê-lo %sAQUI%s.',
++ 	'ACP_INVITE_EMAIL_DISABLED'							=> 'Envio de e-mails foi desativado, por favor, ative-o. %sVá às configurações de e-mail.%s ',
++ 	'ACP_INVITE_EMAIL_PRIORITY'							=> 'Prioridade do email de convite',
+++	'ACP_INVITE_MEMBERSHIP_DAYS'						=> 'Número mínimo de dias de registo',
+++	'ACP_INVITE_MEMBERSHIP_DAYS_EXPLAIN'				=> 'Número de dias que um usuário precisa ter para poder usar o sistema de convites. Colocar 0 para desativar e permitir uso imediato.',
++ 	'ACP_INVITE_ENABLE'									=> 'Ativar extensão de convite',
++ 	'ACP_INVITE_ENABLE_EXPLAIN'							=> 'Se você ativá-lo, a extensão do convite será usada.',
++ 	'ACP_INVITE_VALIDATION'								=> 'Tempo de expiração dos convites enviados',
++@@ -82,6 +84,12 @@ $lang = array_merge($lang, array(
++ 	'ACP_INVITE_GIFT_NUMBER_INVITES'					=> 'Número de convites presenteado',
++ 	'ACP_INVITE_GIFT_INVITED_USERS'						=> 'Usuários convidados',
++ 	'ACP_INVITE_GIFT_INVITED_USERS_EXPLAIN'				=> 'Os usuários receberão um convite de presente após esse número de usuários convidados.<br /><em>Se "0", essa função será desativada.</em>',
+++	'ACP_INVITE_POSTS_GIFT_INVITES'						=> 'Convites por Intervalo',
+++	'ACP_INVITE_POSTS_GIFT_INVITES_EXPLAIN'				=> 'Número de convites que um usuário irá receber após atingir o número de x mensagens. Colocar 0 para desativar.',
+++	'ACP_INVITE_POSTS_GIFT_POSTS'						=> 'Intervalo de Mensagens',
+++	'ACP_INVITE_POSTS_GIFT_POSTS_EXPLAIN'				=> 'O usuário irá receber a cada x mensagens o número de convites inserido no campo acima. Colocar 0 para desativar.',
+++	'ACP_INVITE_POSTS_GIFT_LIMIT'						=> 'Limite do Intervalo',
+++	'ACP_INVITE_POSTS_GIFT_LIMIT_EXPLAIN'				=> 'Número máximo de intervalos que um usuário irá receber convites. Por exemplo, colocar intervalo de 30 mensagens com limite de 3 vezes irá enviar convites quando o usuário atingir 30, 60 e 90 mensagens. Colocar 0 para desativar.',
++ 	'ACP_INVITE_GROUP'									=> 'Grupo de usuários convidados',
++ 	'ACP_INVITE_GROUP_ENABLED'							=> 'Ativar o uso de grupo',
++ 	'ACP_INVITE_GROUP_ENABLED_EXPLAIN'					=> 'If enabled, invited users will automatically be added to the selected group.',
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/language/pt_br/info_ucp_invite.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt_br/info_ucp_invite.php"
++index 93e7cd565..6f2ed71f8 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/language/pt_br/info_ucp_invite.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt_br/info_ucp_invite.php"
++@@ -39,6 +39,10 @@ $lang = array_merge($lang, array(
++ 
++ 	'UCP_CAT_INVITE'						=> 'phpBB Invite',
++ 	'UCP_INVITE'							=> 'Convites',
+++	'UCP_INVITE_LABEL'						=> 'GoldTugAnime - Convite',
+++	'UCP_INVITE_MESSAGE'					=> 'Bem-vindo à mais bela Comunidade de Animação em Português de Portugal!
+++
+++Esperamos que se divirta e que a animação nunca deixe de fazer parte da sua vida.',
++ 	'UCP_INVITE_DATA'						=> 'Detalhes de convites',
++ 	'UCP_INVITE_BACK'						=> '<br /><br />%sVoltar para o painel de controle do usuário%s',
++ 	'UCP_INVITE_DAYF'						=> 'Convites enviados hoje',
++@@ -82,7 +86,7 @@ $lang = array_merge($lang, array(
++ 	'UCP_INVITE_REQUEST_BUY_SUBT_EXPLAIN'	=> 'Digite o número de convites que você deseja comprar. O preço do convite é <b>%s %s</b>.<br />Você assume a responsabilidade por seu(s) usuário(s) convidado(s) se o(s) usuário(s) convidado(s) causar incidentes inapropriados.',	
++ 	'UCP_INVITE_REQUEST_BUY_SUCCESS'		=> 'A compra do convite foi bem-sucedida.',
++ 	'UCP_INVITE_REQUEST_BUY_TITLE'			=> 'Comprar convite.',
++-	'UCP_INVITE_REQUEST_DISABLED'			=> 'As solicitacões de convites estão desativadas!',
+++	'UCP_INVITE_REQUEST_DISABLED'			=> 'As solicitações de convites estão desativadas!',
++ 	'UCP_INVITE_REQUEST_MAX'				=> 'Número máximo de pedidos: (%s) convite(s)!',
++ 	'UCP_INVITE_REQUEST_MESSAGE_NO_DB'		=> '<em>Não! Não houve necessidade.</em>',
++ 	'UCP_INVITE_REQUEST_MIN'				=> 'Número mínimo de convites solicitados: (1)',
++@@ -92,9 +96,11 @@ $lang = array_merge($lang, array(
++ 	'UCP_INVITE_REQUEST_SUBMIT'				=> 'Enviar pedido',
++ 	'UCP_INVITE_REQUEST_SUCC'				=> 'A solicitação de convite foi enviada com sucesso!',
++ 	'UCP_INVITE_REQUEST_SUCCS'				=> 'A solicitação de convites foram enviadas com sucesso!',
++-	'UCP_INVITE_REQUEST_TITLE'				=> 'Convites requisitados',
++-	'UCP_INVITE_REQUEST_TITLE_EXPLAIN'		=> 'Digite o número de convites que você deseja solicitar. Há um máximo de <b>(%s)</b> convites disponíveis.<br />Você assume total responsabilidade por seu(s) usuário(s) convidado(s) se eles se comportarem de maneira inapropriada.',
+++	'UCP_INVITE_REQUEST_TITLE'				=> 'Requisitar convites',
+++	'UCP_INVITE_REQUEST_TITLE_EXPLAIN'		=> 'Digite o número de convites que você deseja solicitar. Há um máximo de <b>(%s)</b> convites disponíveis.',
+++	'UCP_INVITE_REQUEST_COST'				=> '<div class="invitation_tred alert alert-danger">O preço por convite é de <b>50.000 pontos</b>.</div>',
++ 	'UCP_INVITE_SEND'						=> 'Enviar convite',
+++	'UCP_INVITE_SEND_EXPLAIN'			=> '<div class="invitation_tred alert alert-danger">Você assume parte da responsabilidade dos usuários convidados caso eles se comportarem de maneira inapropriada.</div>',
++ 	'UCP_INVITE_SEND_EMAIL_MAX'				=> 'Máximo de %s endereços de e-mail podem ser usados. No entanto, você listou %s!', 
++ 	'UCP_INVITE_SEND_MAX'					=> '<span class="invitation_tred">Atualmente não há limite!</span>',
++ 	'UCP_INVITE_LAST_ACTIVE'				=> 'Última visita',
++@@ -108,6 +114,7 @@ $lang = array_merge($lang, array(
++ 	'UCP_INVITE_NO_LOGIN'					=> 'Ele/ela não se registrou neste site.',
++ 	'UCP_INVITE_NO_PERM'					=> 'Você não está autorizado a enviar convites!',
++ 	'UCP_INVITE_NO_PERM_EMAIL'				=> 'Você não está autorizado a enviar e-mail!',
+++	'UCP_INVITE_MEMBERSHIP_DAYS'			=> 'A sua conta tem de ter pelo menos %1$d dias antes que possa fazer uso do sistema de convite. Poderá utilizar a partir de %2$s.',
++ 	'UCP_INVITE_NO_REG'						=> 'Ninguém foi convidado por você.',
++ 	'UCP_INVITE_NULL'						=> 'Você não tem convites!  <em>Porque não comprar alguns?</em>', 
++ 	'UCP_INVITE_POINTS_AMOUNT'				=> 'Presente',
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt_br/install_invite.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt_br/install_invite.php"
++new file mode 100644
++index 000000000..dd11b1fa9
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt_br/install_invite.php"
++@@ -0,0 +1,156 @@
+++<?php
+++
+++/**
+++ *
+++ * Invite. An extension for the phpBB Forum Software package.
+++ *
+++ * @copyright (c) 2010-2015, KillBill
+++ * @copyright (c) 2017, kasimi
+++ * @copyright (c) 2017-2022, Leinad4Mind, https://leinad4mind.top/forum
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
+++// Some characters you may want to copy&paste: ’ « » „ “ ” …
+++
+++$lang = array_merge($lang, array(
+++	'AUTH_CACHE_PURGE'						=> 'Clear permission cache',
+++
+++	'CACHE_PURGE'							=> 'Clear forum cache',
+++	'CAT_INSTALL'							=> 'Install',
+++	'CAT_OVERVIEW'							=> 'Overview',
+++	'CAT_UNINSTALL'							=> 'Uninstall',
+++	'CAT_UPDATE'							=> 'Update',
+++	'CAT_VERIFY'							=> 'Verify',
+++
+++	'GPL'									=> 'General Public License',
+++
+++	'INCOMPLETE_FILES_UPLOAD'				=> 'All Invite files have not been uploaded! Please make sure to upload all files before running the installer.',
+++	'INCOMPLETE_FILE_EDITS'					=> 'Editing of this file has not been done yet. The installation can not run unless all files are edited correctly!',
+++	'INCOMPLETE_LANG_ROWS'					=> 'Some changes to the language files are missing. Please apply them as described %sHERE%s.',
+++	'INSTALLATION'							=> 'phpBB Invite install',
+++	'INSTALLATION_EXPLAIN'					=> '<br />phpBB Invite database install.<br /><br />',
+++	'INSTALL_BODY'							=> 'Here you can see that the mod is well established and has been properly installed.',
+++	'INSTALL_ERR_AUTH'						=> 'You are not authorized to use this script.<br /><br />Please note to use the script the following requirements must be met. First you must be logged in to the site and second you must have the user type founder. If you are logged in and are the founder then you have incorrect cookie settings in the ACP. Please check the cookie domain setting. If your site URL is <strong>http://www.example.com</strong> then the cookie domain should be <strong>.example.com</strong>.',
+++	'INSTALL_FOLDER'						=> '<strong>Please delete the install folder. Until you have done this, only the ACP will be available.</strong>',
+++	'INSTALL_LOGIN'							=> 'Proceed to ACP',
+++
+++	'INVITE_CONFIG_ADD'						=> 'Adding new invite config variable: %s',
+++	'INVITE_CONFIG_ALREADY_EXISTS'			=> 'ERROR: Invite config variable %s already exists.',
+++	'INVITE_CONFIG_NOT_EXIST'				=> 'ERROR: Invite config variable %s does not exist.',
+++	'INVITE_CONFIG_REMOVE'					=> 'Removing Invite config variable: %s',
+++	'INVITE_CONFIG_UPDATE'					=> 'Updating Invite config variable: %s',
+++
+++	'INVITE_INSTALL_INTRO'					=> 'Welcome to phpBB Invite Installation',
+++	'INVITE_INSTALL_INTRO_BODY'				=> 'With this option, it is possible to install phpBB Invite to your database.',
+++
+++	'INVITE_VERSION'						=> 'The installed phpBB Invite version is <b>%s</b>, this file can be used to update version <b>%s</b> to version <b>%s</b>. <br /> You first need to upgrade to version <b>%s</b> to run this update script!',
+++
+++	'NOT_INSTALL_DIR'						=> 'Cannot open the install folder!',
+++	'NOT_LANGUAGE_DIR'						=> 'The language library is not available!',
+++	'NOT_LANGUAGE_DIR_DIR'					=> 'The %s language directory cannot be found!',
+++	'NOT_MODULE'							=> 'The installation modules are not available!',
+++	'NOT_MODULE_OPEN'						=> '%s Module is not available!',
+++	'NO_TABLE_DATA'							=> '<span style="color:#FF0000;">Error:</span> The table data is missing.',
+++
+++	'OVERVIEW_BODY'							=> 'Welcome!<br /><br />The installation system presents a complete guide how to install the mod, or remove and update it.<br />Continue with the selection menu... Select the appropriate option from the menu.',
+++
+++	'PARENT_NOT_EXIST'						=> '<span style="color:#FF0000;">Error:</span> The parent category which shows the new module does not exist.',
+++	'PERMISSIONS_WARNING'					=> 'New permission settings have been added.  Check your permission settings and make sure that they are as you would like them.',
+++	'PHPBB_INVITE_DONATE'					=> 'Please make a small donation to appreciate the hard work and many hours used to make the “phpBB Invite”.',
+++	'PHPBB_INVITE_DONATE_TITLE'				=> 'phpBB Invite donation',
+++	'PHPBB_VERSION'							=> 'Your phpBB version is <b>%s</b>, the phpBB Invite mod requires version <b>%s</b> to run!',
+++	'PHP_VERSION_RUN'						=> 'The current PHP version is not supported, please update your PHP to version 4.3.3 or later before you run the installation.</b>',
+++
+++	'ROLE_NOT_EXIST'						=> '<span style="color:#FF0000;">Error:</span> this role is not in the database.',
+++
+++	'STAGE_INSTALL'							=> 'Install',
+++	'STAGE_INTRO'							=> 'Intro',
+++	'STAGE_UNINSTALL'						=> 'Delete the database',
+++	'STAGE_VERIFY'							=> 'Verify',
+++	'STAGE_VERIFY_FILE_EXPLAIN'				=> '<br />The mod files are successfully deleted.',
+++	'SUB_INTRO'								=> 'Intro',
+++	'SUB_LICENSE'							=> 'License',
+++	'SUB_SUPPORT'							=> 'Support',
+++	'SUCCESSES'								=> '<span style="color:#000;"><b>Successfully completed!</b></span>',
+++	'SUPPORT_BODY'							=> 'Full support will be provided for the current release and development versions, all for free.<br />This includes:</p><ul><li>information</li><li>configuration</li><li>update older versions to the newest version</li></ul><p>I encourage everyone who is using an older version to upgrade to the new version.</p><h2>Support forums</h2><br /><p><a href="http://jatek-vilag.com/viewtopic.php?p=204#p204" onclick="window.open(this.href); return false;">The main development site</a><br /><a href="https://www.phpbb.com/community/viewtopic.php?p=12855248#p12855248" onclick="window.open(this.href); return false;">phpBB.com Development topic</a><br /><a href="http://phpbb.hu/forum/hsz/40666#hsz-40666" onclick="window.open(this.href); return false;">phpBB.hu Development topic</a><br /><br />',
+++
+++	'UNINSTALL_BODY'						=> 'Here you can see that the mod database entries have been successfully removed.<br /><br /><b>Please delete the install folder. Until you have done this, only the ACP will be available.</b>',
+++	'UNINSTALL_INTRO'						=> 'phpBB Invite delete',
+++	'UNINSTALL_INTRO_BODY'					=> 'Under this option, you can delete the phpBB Invite from the database.',
+++	'UNINSTALL_TITLE'						=> 'phpBB Invite deleted from the database',
+++	'UPDATE_BODY'							=> 'Here you can see that database data created by this mod has been properly updated.<br /><br /><b>Please delete the install folder. Until you have done this, only the ACP will be available.</b>',
+++	'UPDATE_INSTALLATION'					=> 'phpBB Invite update',
+++	'UPDATE_INSTALLATION_EXPLAIN'			=> '<br />phpBB Invite update on the newest version.<br />',
+++	'UPDATE_TITLE'							=> 'Updating database data',
+++
+++	'VERIFY_ERROR_EXPLAIN'					=> 'The check found an error.',
+++	'VERIFY_ERROR_FILE'						=> 'Bad file modification',
+++	'VERIFY_ERROR_FILE_EXPLAIN'				=> 'Here you can see those files which have been incorrectly edited or has been omitted.',
+++	'VERIFY_EXITS_PRINT_MYAD'				=> '<br />The SQL command you see here you can install by yourself, if you load it in phpMyAdmin.',
+++	'VERIFY_EXITS_PRINT_SQL'				=> '<b><span style="color:#FF0000;">%s</span> <span style="color:#000;">not found!</span></b><br />%s<br />',
+++	'VERIFY_INVITE_MOD_CONFIG'				=> 'phpBB Invite configuration',
+++	'VERIFY_INVITE_MOD_CONFIG_OK'			=> '<span style="color:#228822;"><strong>All phpBB Invite config found.</strong></span>',
+++	'VERIFY_INVITE_MOD_FILES'				=> 'phpBB Invite files',
+++	'VERIFY_INVITE_MOD_FILES_OK'			=> '<span style="color:#228822;"><strong>All files found.</strong></span>',
+++	'VERIFY_INVITE_MOD_MODULES'				=> 'phpBB Invite modules',
+++	'VERIFY_INVITE_MOD_MODULES_OK'			=> '<span style="color:#228822;"><strong>All modules found.</strong></span>',
+++	'VERIFY_INVITE_MOD_PERM'				=> 'phpBB Invite permissions',
+++	'VERIFY_INVITE_MOD_PERM_OK'				=> '<span style="color:#228822;"><strong>All permissions found.</strong></span>',
+++	'VERIFY_INVITE_MOD_TABLES'				=> 'phpBB Invite tables',
+++	'VERIFY_INVITE_MOD_TABLES_OK'			=> '<span style="color:#228822;"><strong>All tables found.</strong></span>',
+++	'VERIFY_NOT_AC_FOUND'					=> '<b><span style="color:#FF0000;">%s</span> <span style="color:#000;">not found!</span></b>',
+++	'VERIFY_NOT_COLUMN'						=> 'Missing columns',
+++	'VERIFY_NOT_COLUMN_EXPLAIN'				=> 'Here you can see all the columns which were not installed.',
+++	'VERIFY_NOT_CONFIG'						=> 'Missing config',
+++	'VERIFY_NOT_CONFIG_EXPLAIN'				=> 'Here you can see the config files which have not been installed.',
+++	'VERIFY_NOT_FILE'						=> 'Missing files',
+++	'VERIFY_NOT_FILE_EXPLAIN'				=> 'Here you can see the files that have not been uploaded correctly or have been uploaded correctly but to the wrong place.',
+++	'VERIFY_NOT_INVITE_CONFIG'				=> 'Missing phpBB Invite config',
+++	'VERIFY_NOT_INVITE_CONFIG_EXPLAIN'		=> 'Here you can see the phpBB Invite config files which have not been installed.',
+++	'VERIFY_NOT_MODULE'						=> 'Missing modules',
+++	'VERIFY_NOT_MODULE_EXPLAIN'				=> 'Here you can see the modules which have not been installed.',
+++	'VERIFY_NOT_PERMIS'						=> 'Missing permissions',
+++	'VERIFY_NOT_PERMIS_EXPLAIN'				=> 'Here you can see the permissions that were not installed.',
+++	'VERIFY_NOT_TABLE'						=> 'Missing table',
+++	'VERIFY_NOT_TABLE_EXPLAIN'				=> 'Here you can see the signs which have not been installed.',
+++	'VERIFY_NO_COLUMN'						=> '<b><span style="color:#FF0000;">%s</span> <span style="color:#000;">column not found!</span></b><br />%s<br />',
+++	'VERIFY_NO_MODULE'						=> '<b><span style="color:#FF0000;">%s</span> <span style="color:#000;">module is not found in the database!</span></b>',
+++	'VERIFY_NO_PERMIS'						=> '<b><span style="color:#FF0000;">%s</span> <span style="color:#000;">permission is not found in the database!</span></b>',
+++	'VERIFY_NO_TABLE'						=> '<b><span style="color:#FF0000;">%s</span> <span style="color:#000;">table is not found in the database!</span></b>%s',
+++	'VERIFY_PHPBB_MOD_COLUMNS'				=> 'phpBB users table new columns',
+++	'VERIFY_PHPBB_MOD_COLUMNS_OK'			=> '<span style="color:#228822;"><strong>All columns found.</strong></span>',
+++	'VERIFY_PHPBB_MOD_CONFIG'				=> 'phpBB new config',
+++	'VERIFY_PHPBB_MOD_CONFIG_OK'			=> '<span style="color:#228822;"><strong>phpBB config found.</strong></span>',
+++	'VERIFY_PHPBB_MOD_FILES'				=> 'phpBB file edits',
+++	'VERIFY_PHPBB_MOD_FILES_OK'				=> '<span style="color:#228822;"><strong>All files are edited.</strong></span>',
+++	'VERIFY_SUCCESSES_EXPLAIN'				=> 'The check found everything okay.',
+++	'VERIFY_TITLE'							=> 'phpBB Invite control',
+++	'VERIFY_TITLE_ELL'						=> 'Control error',
+++	'VERIFY_TITLE_ELL_EXPLAIN'				=> '<span style="color:#000;"><b>Here you can see all occurred errors to fix everything carefully!</b></span>',
+++	'VERIFY_TITLE_EXPLAIN'					=> '<br />Here you can check whether all required file changes, configuration changes and database entries have been made successfully.',
+++	'VERIFY_NEW'							=> 'Check again',
+++	'VERIFY_UNINSTALL_ERROR_FILE'			=> 'Existing files',
+++	'VERIFY_UNINSTALL_ERROR_FILE_EXPLAIN'	=> 'Here you can see the files which have not been removed.',
+++));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/language/pt_br/permissions_invite.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt_br/permissions_invite.php"
++index 2341f4d0e..4c36d3661 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/language/pt_br/permissions_invite.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt_br/permissions_invite.php"
++@@ -45,7 +45,7 @@ $lang = array_merge($lang, array(
++ 	'ACL_M_INVITE_CLAIMING'	=> 'O usuário pode aprovar um pedido de convite.',
++ 	'ACL_U_INVITE_DELETE'	=> 'O usuário pode revogar convite<br /><em>O usuário pode cancelar um convite que ele enviou.</em>',
++ 	'ACL_U_INVITE_REQUEST'	=> 'O usuário pode solicitar convite',
++-	'ACL_U_INVITE_SEND'		=> 'O usuário pode convidar novos membros para o site',
+++	'ACL_U_INVITE_SENDING'		=> 'O usuário pode convidar novos membros para o site',
++ 	'ACL_U_INVITE_MAX'		=> 'O usuário tem convites ilimitados',
++ 	'ACL_U_INVITE_USERS'	=> 'O usuário pode visualizar a lista de usuários convidados por outras pessoas.',
++ ));
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt_preao/common.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt_preao/common.php"
++new file mode 100644
++index 000000000..abff06760
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt_preao/common.php"
++@@ -0,0 +1,52 @@
+++<?php
+++
+++/**
+++ *
+++ * Invite. An extension for the phpBB Forum Software package.
+++ * Brazilian Portuguese translation by eunaumtenhoid [2019][ver 4.2.0] (https://github.com/phpBBTraducoes)
+++ * @copyright (c) 2010-2015, KillBill
+++ * @copyright (c) 2017, kasimi
+++ * @copyright (c) 2017-2022, Leinad4Mind, https://leinad4mind.top/forum
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
+++// Some characters you may want to copy&paste: ’ « » „ “ ” …
+++
+++$lang = array_merge($lang, array(
+++	'INVITE_BIRTHDAY'						=> 'Parabéns! Recebeste %s convite(s) para o teu aniversário.<br /><br />Desejamos-te um feliz aniversário!', 
+++
+++	'INVITE_GIFT_INVITED_USERS_FIRST'		=> 'Olá, esta é uma mensagem que se recebe por convidar o utilizador %s para o site “%s”, por isso estamos muito gratos. Queremos que continues a usar o sistema de convite, para que recebas %s convites adicionais.<br /><br />Desejamos-te um momento agradável.',
+++	
+++	'INVITE_GIFT_INVITED_USERS_FURTHER'		=> 'Olá, esta é uma mensagem que se recebe por convidar mais %s utilizadores para o site “%s”, por isso estamos muito gratos. Queremos que continues a usar o sistema de convite, para que recebas %s convites adicionais.<br /><br />Desejamos-te um momento agradável.',
+++
+++	'INVITE_PETITION_TITLE'					=> 'Solicitação de convite',
+++	'INVITE_PETITIONS_NO'					=> 'A tua solicitação não foi aprovada, portanto, os convites não te serão creditados!',
+++	'INVITE_PETITION_NO'					=> 'A tua solicitação não foi aprovada, então o convite não te será creditado!',
+++	'INVITE_PETITION_YES'					=> 'A tua solicitação foi aprovada, %s convite(s) creditado(s)!', 
+++
+++	'INVITE_PETITION_REQUEST'				=> 'O utilizador %s está a solicitar %d convite(s)', 
+++
+++	'INVITE_JOIN'							=> 'Obrigado por convidares o utilizador %s',
+++));
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt_preao/email/user_invite.txt" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt_preao/email/user_invite.txt"
++new file mode 100644
++index 000000000..dd6c34656
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt_preao/email/user_invite.txt"
++@@ -0,0 +1,21 @@
+++O utilizador {USERNAME} convidou-te para te registares no site "{SITENAME}".
+++Podes clicar no link abaixo para criares conta.
+++
+++{U_ACTIVATE}
+++
+++A data de expiração deste convite é ({INVITE_TIME_END}). Quando o período de expiração terminar o teu convite ficará inválido!
+++
+++Se quiseres recusar este convite, simplesmente ignora este e-mail ou clica no link abaixo para excluí-lo:
+++{U_DEACTIVATE}
+++
+++Mensagem de {USERNAME}:
+++~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
+++{MESSAGE}
+++~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
+++Se a mensagem acima te for ofensiva ou contiver comentários ofensivos, entra em contacto com o administrador do site no
+++seguinte endereço de e-mail: {BOARD_CONTACT}
+++Anexa esta mensagem ao e-mail (certifica-te de incluir o cabeçalho do e-mail).
+++O endereço de retorno deste e-mail está definido para o endereço de e-mail de {USERNAME}, para que eles recebam a tua resposta.
+++--------------------------------------
+++
+++Link do site: {U_BOARD}
++\ No newline at end of file
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt_preao/email/user_invite_request.txt" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt_preao/email/user_invite_request.txt"
++new file mode 100644
++index 000000000..d9e42b875
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt_preao/email/user_invite_request.txt"
++@@ -0,0 +1,7 @@
+++Recebeste uma solicitação de convites adicionais do utilizador {USERNAME}.
+++Ele solicitou {INVITE_NUMBER} convite(s).
+++
+++~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
+++
+++Link do site: {U_BOARD}
+++Contacto: {BOARD_CONTACT}
++\ No newline at end of file
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt_preao/email/user_invites.txt" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt_preao/email/user_invites.txt"
++new file mode 100644
++index 000000000..5ec678fa3
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt_preao/email/user_invites.txt"
++@@ -0,0 +1,21 @@
+++O utilizador {USERNAME} convidou-te para te registares no site "{SITENAME}".
+++Podes clicar nos links abaixo para criares conta.
+++
+++{U_ACTIVATE}
+++
+++A data de expiração destes convites é ({INVITE_TIME_END}). Quando o período de expiração terminar os teus convites ficarão inválidos!
+++
+++Se quiseres recusar estes convites, simplesmente ignora este e-mail ou clica no link abaixo para excluí-los:
+++{U_DEACTIVATE}
+++
+++Mensagem de {USERNAME}:
+++~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
+++{MESSAGE}
+++~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
+++Se a mensagem acima te for ofensiva ou contiver comentários ofensivos, entra em contacto com o administrador do site no
+++seguinte endereço de e-mail: {BOARD_CONTACT}
+++Anexa esta mensagem ao e-mail (certifica-te de incluir o cabeçalho do e-mail).
+++O endereço de retorno deste e-mail está definido para o endereço de e-mail de {USERNAME}, para que eles recebam a tua resposta.
+++--------------------------------------
+++
+++Link do site: {U_BOARD}
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/language/pt_pt/info_acp_invite.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt_preao/info_acp_invite.php"
++similarity index 93%
++rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/language/pt_pt/info_acp_invite.php"
++rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt_preao/info_acp_invite.php"
++index 41520ab7c..7f340bde1 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/language/pt_pt/info_acp_invite.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt_preao/info_acp_invite.php"
++@@ -45,7 +45,9 @@ $lang = array_merge($lang, array(
++ 	'ACP_INVITED_PEND_COUNT'							=> 'Todos Convites (%s)',
++ 	'ACP_INVITED_USERS_COUNT'							=> 'Todos os utilizadores (%s)',
++ 	'ACP_INVITE_ALL_USER_INVITE_MAX'					=> 'Convite ilimitado para todos',
++-	'ACP_INVITE_ALL_USER_INVITE_MAX_EXPLAIN'			=> 'se seleccionado, todos os utilizadores terão convites ilimitados.',
+++	'ACP_INVITE_ALL_USER_INVITE_MAX_EXPLAIN'			=> 'Se sim, todos os utilizadores terão convites ilimitados.',
+++	'ACP_INVITE_RESTORE_INVITES'						=> 'Restaurar convites expirados e recusados',
+++	'ACP_INVITE_RESTORE_INVITES_EXPLAIN'				=> 'Caso um convite expire ou seja recusado deverá o convite ser novamente disponibilizado ao utilizador.',
++ 	'ACP_INVITE_BIRTHDAYS'								=> 'Aniversário',
++ 	'ACP_INVITE_BIRTHDAYS_EXPLAIN'						=> 'Podes definir quantos convites um utilizador receberá no seu aniversário. <em>Para que essa configuração tenha efeito, o recurso de aniversário também precisa ser activado.</em>',
++ 	'ACP_INVITE_CAPTCHA'								=> 'Confirmação visual',
++@@ -70,10 +72,12 @@ $lang = array_merge($lang, array(
++ 	'ACP_INVITE_DELETE_USERS_CONFIRM'					=> 'Tens a certeza de que desejas excluir os convites dos utilizadores seleccionados?',
++ 	'ACP_INVITE_DELETE_USER_CONFIRM'					=> 'Tens a certeza de que desejas excluir os convites do utilizador seleccionado?',
++ 	'ACP_INVITE_DISABLED'								=> 'O sistema de convite está desactivado!',
++-	'ACP_INVITE_DENY'									=> 'Rejeição',
+++	'ACP_INVITE_DENY'									=> 'Rejeitar',
++ 	'ACP_INVITE_EMAIL_BOARD_DISABLED'					=> '<strong>phpBB Invite:</strong> O envio de e-mails está, de momento, desactivado!<br />Enquanto estiver desactivado, os convites não devem funcionar. Se quiseres activá-lo, podes fazê-lo %sAQUI%s.',
++ 	'ACP_INVITE_EMAIL_DISABLED'							=> 'Envio de e-mails foi desactivado, por favor, ative-o. %sVá às configurações de e-mail.%s ',
++ 	'ACP_INVITE_EMAIL_PRIORITY'							=> 'Prioridade do email de convite',
+++	'ACP_INVITE_MEMBERSHIP_DAYS'						=> 'Número mínimo de dias de registo',
+++	'ACP_INVITE_MEMBERSHIP_DAYS_EXPLAIN'				=> 'Número de dias que um utilizador precisa de ter para poder usar o sistema de convites. Colocar 0 para desactivar e permitir uso imediato.',
++ 	'ACP_INVITE_ENABLE'									=> 'Activar extensão de convite',
++ 	'ACP_INVITE_ENABLE_EXPLAIN'							=> 'Se o activares, a extensão do convite será usada.',
++ 	'ACP_INVITE_VALIDATION'								=> 'Tempo de expiração dos convites enviados',
++@@ -82,6 +86,12 @@ $lang = array_merge($lang, array(
++ 	'ACP_INVITE_GIFT_NUMBER_INVITES'					=> 'Número de convites presenteado',
++ 	'ACP_INVITE_GIFT_INVITED_USERS'						=> 'Utilizadores convidados',
++ 	'ACP_INVITE_GIFT_INVITED_USERS_EXPLAIN'				=> 'Os utilizadores receberão um convite de presente após esse número de utilizadores convidados.<br /><em>Se "0", essa função será desactivada.</em>',
+++	'ACP_INVITE_POSTS_GIFT_INVITES'						=> 'Convites por Intervalo',
+++	'ACP_INVITE_POSTS_GIFT_INVITES_EXPLAIN'				=> 'Número de convites que um utilizador irá receber após atingir o número de x mensagens. Colocar 0 para desactivar.',
+++	'ACP_INVITE_POSTS_GIFT_POSTS'						=> 'Intervalo de Mensagens',
+++	'ACP_INVITE_POSTS_GIFT_POSTS_EXPLAIN'				=> 'O utilizador irá receber a cada x mensagens o número de convites inserido no campo acima. Colocar 0 para desactivar.',
+++	'ACP_INVITE_POSTS_GIFT_LIMIT'						=> 'Limite do Intervalo',
+++	'ACP_INVITE_POSTS_GIFT_LIMIT_EXPLAIN'				=> 'Número máximo de intervalos que um utilizador irá receber convites. Por exemplo, colocar intervalo de 30 mensagens com limite de 3 vezes irá enviar convites quando o utilizador atingir 30, 60 e 90 mensagens. Colocar 0 para desactivar.',
++ 	'ACP_INVITE_GROUP'									=> 'Grupo de utilizadores convidados',
++ 	'ACP_INVITE_GROUP_ENABLED'							=> 'Activar o uso de grupo',
++ 	'ACP_INVITE_GROUP_ENABLED_EXPLAIN'					=> 'If enabled, invited users will automatically be added to the selected group.',
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt_preao/info_mcp_invite.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt_preao/info_mcp_invite.php"
++new file mode 100644
++index 000000000..b5c364c41
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt_preao/info_mcp_invite.php"
++@@ -0,0 +1,43 @@
+++<?php
+++
+++/**
+++ *
+++ * Invite. An extension for the phpBB Forum Software package.
+++ * Brazilian Portuguese translation by eunaumtenhoid [2019][ver 4.2.0] (https://github.com/phpBBTraducoes)
+++ * @copyright (c) 2010-2015, KillBill
+++ * @copyright (c) 2017, kasimi
+++ * @copyright (c) 2017-2022, Leinad4Mind, https://leinad4mind.top/forum
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
+++// Some characters you may want to copy&paste: ’ « » „ “ ” …
+++
+++$lang = array_merge($lang, array(
+++	'MCP_CAT_INVITE'			=> 'phpBB Invite',
+++	'MCP_INVITE'				=> 'Convite',
+++	'MCP_INVITE_BACK'			=> '<br /><br />%sVoltar para o painel de controlo do moderador%s',
+++	'MCP_INVITE_DISABLED'		=> '%sO sistema de convite foi desactivado!%s',
+++	'MCP_INVITE_CONFIRMATION'	=> 'Solicitações de convite',
+++));
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt_preao/info_ucp_invite.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt_preao/info_ucp_invite.php"
++new file mode 100644
++index 000000000..5f9f7062b
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt_preao/info_ucp_invite.php"
++@@ -0,0 +1,145 @@
+++<?php
+++
+++/**
+++ *
+++ * Invite. An extension for the phpBB Forum Software package.
+++ * Brazilian Portuguese translation by eunaumtenhoid [2019][ver 4.2.0] (https://github.com/phpBBTraducoes)
+++ * @copyright (c) 2010-2015, KillBill
+++ * @copyright (c) 2017, kasimi
+++ * @copyright (c) 2017-2022, Leinad4Mind, https://leinad4mind.top/forum
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
+++// Some characters you may want to copy&paste: ’ « » „ “ ” …
+++
+++$lang = array_merge($lang, array(
+++	'POST_CONFIRM_EXPLAIN'					=> 'Digitar o código evita o convite automático de bots. Podes encontrar o código na imagem. Se não fores capaz de ler o código devido a problemas visuais ou outros, entra em contacto com o %sadministrador%s.',
+++
+++	'UCP_CAT_INVITE'						=> 'phpBB Invite',
+++	'UCP_INVITE'							=> 'Convites',
+++	'UCP_INVITE_LABEL'						=> 'GoldTugAnime - Convite',
+++	'UCP_INVITE_MESSAGE'					=> 'Bem-vindo à mais bela Comunidade de Animação em Português de Portugal!
+++
+++Esperamos que te divirtas e que a animação nunca deixe de fazer parte da tua vida.',
+++	'UCP_INVITE_DATA'						=> 'Detalhes de convites',
+++	'UCP_INVITE_BACK'						=> '<br /><br />%sVoltar para o painel de controlo do utilizador%s',
+++	'UCP_INVITE_DAYF'						=> 'Convites enviados hoje',
+++	'UCP_INVITE_DAYF_EXPLAIN'				=> 'O número de convites que enviaste hoje.',
+++	'UCP_INVITE_DAY_OFF'					=> 'Não estamos a aceitar mais convites hoje!',
+++	'UCP_INVITE_DB'							=> '<b>%s convite(s).</b>',
+++	'UCP_INVITE_DB_SEND'					=> 'Limite de convite diário',
+++	'UCP_INVITE_DB_SEND_EXPLAIN'			=> 'Número máximo de convites por dia que podes enviar.',
+++	'UCP_INVITE_DB_MAX'						=> '<span class="invitation_tred">Ilimitado!</span>',
+++	'UCP_INVITE_DB_PENDING'					=> 'Convites pendentes',
+++	'UCP_INVITE_DB_PENDING_EXPLAIN'			=> 'O número de utilizadores que convidaste e ainda não se registou.',
+++	'UCP_INVITE_DB_NUMBER'					=> 'Número de convites',
+++	'UCP_INVITE_DB_NUMBER_EXPLAIN'			=> 'O teu limite de convites restante',
+++	'UCP_INVITE_DB_USER'					=> 'Utilizador convidado',
+++	'UCP_INVITE_DB_USERS'					=> 'Utilizadores convidados',
+++	'UCP_INVITE_DB_USERS_EXPLAIN'			=> 'Membros que convidaste.',
+++	'UCP_INVITE_DB_USER_EXPLAIN'			=> 'Membro que convidaste.',
+++	'UCP_INVITE_DELETE'						=> 'Apagar convite',
+++	'UCP_INVITE_DELETE_EXPLAIN'				=> 'Se enviaste convites para os endereços errados, poderás revogar os mesmos aqui.<br /><em>Isso só é possível dentro de %s minutos após o envio do convite.</em>',	
+++	'UCP_INVITE_DELETE_NO_CONFIRM'			=> 'A remoção não foi confirmada!',
+++	'UCP_INVITE_DELETE_SUCCESS'				=> 'O convite foi apagado com sucesso.',
+++	'UCP_INVITE_DISABLED'					=> '%sO sistema de convites está desactivado!%s',
+++	'UCP_INVITE_DUP'						=> 'Já foi enviado um convite para o endereço de e-mail: %s',
+++	'UCP_INVITE_EDUP'						=> 'Endereço de e-mail inserido repetidamente: %s',
+++	'UCP_INVITE_EMAILS_SENT'				=> 'Os convites foram enviados com sucesso!',
+++	'UCP_INVITE_EMAIL_LANG'					=> 'Idioma do e-mail',
+++	'UCP_INVITE_EMAIL_REQUEST_EXPLAIN'		=> 'Razão para a solicitação de convites.',
+++	'UCP_INVITE_EMAIL_SELECT'				=> 'Selecção de convite',
+++	'UCP_INVITE_EMAIL_SELECT_EXPLAIN'		=> 'Escolhe qual dos destinatários desejas excluir.',
+++	'UCP_INVITE_EMAIL_SENT'					=> 'O convite foi enviado com sucesso!',
+++	'UCP_INVITE_FLOOD_LIMIT'				=> 'Não podes enviar mais convites. Por favor, tenta novamente mais tarde.',
+++	'UCP_INVITE_FRIEND'						=> 'Adicionar um amigo',
+++	'UCP_INVITE_FRIEND_EXPLAIN'				=> 'O utilizador convidado será adicionado à tua lista de amigos.',
+++	'UCP_INVITE_DEP_LIMIT'					=> 'Apenas %s convites podem ser enviados hoje. No entanto, listaste %s destinatários.', 
+++	'UCP_INVITE_REQUEST'					=> 'Solicitação de convites',
+++	'UCP_INVITE_REQUEST_BUYS_SUCCESS'		=> 'Compraste convites com sucesso.',
+++	'UCP_INVITE_REQUEST_BUY_MIN'			=> 'Mínimo (1) convite a ser comprado!',
+++	'UCP_INVITE_REQUEST_BUY_NO'				=> 'Não tens %s suficiente para comprar essa quantidade de convites! Tens %s %s atualmente.',
+++	'UCP_INVITE_REQUEST_BUY_SUBMIT'			=> 'Comprar',
+++	'UCP_INVITE_REQUEST_BUY_SUBT'			=> 'Convites que desejas comprar',
+++	'UCP_INVITE_REQUEST_BUY_SUBT_EXPLAIN'	=> 'Digita o número de convites que desejas comprar. O preço do convite é <b>%s %s</b>.<br />Assumes a responsabilidade pelo(s) teu(s) utilizador(es) convidado(s) se o(s) utilizador(es) convidado(s) causar(em) incidentes inapropriados.',
+++	'UCP_INVITE_REQUEST_BUY_SUCCESS'		=> 'A compra do convite foi bem-sucedida.',
+++	'UCP_INVITE_REQUEST_BUY_TITLE'			=> 'Comprar convite.',
+++	'UCP_INVITE_REQUEST_DISABLED'			=> 'As solicitações de convites estão desactivadas!',
+++	'UCP_INVITE_REQUEST_MAX'				=> 'Número máximo de pedidos: (%s) convite(s)!',
+++	'UCP_INVITE_REQUEST_MESSAGE_NO_DB'		=> '<em>Não! Não houve necessidade.</em>',
+++	'UCP_INVITE_REQUEST_MIN'				=> 'Número mínimo de convites solicitados: (1)',
+++	'UCP_INVITE_REQUEST_NO_MESSAGE'			=> 'Não escreveste uma mensagem! Sem uma explicação não podes reivindicar tantos convites.',
+++	'UCP_INVITE_REQUEST_OFF'				=> 'A tua solicitação de convite está pendente. Quando um administrador/moderador avaliar a tua solicitação, receberás uma notificação.',
+++	'UCP_INVITE_REQUEST_SOK_EXPLAIN'		=> 'Ao enviar mais de <b>(%s)</b> pedidos, é necessária uma explicação para o administrador. Por favor, explica por que precisas de tantos convites.<br />Se acharmos que o teu pedido é aceitável, nós enviamos os convites. Se for um abuso, pode ser motivo para banir a tua conta.',	
+++	'UCP_INVITE_REQUEST_SUBMIT'				=> 'Enviar pedido',
+++	'UCP_INVITE_REQUEST_SUCC'				=> 'A solicitação de convite foi enviada com sucesso!',
+++	'UCP_INVITE_REQUEST_SUCCS'				=> 'A solicitação de convites foram enviadas com sucesso!',
+++	'UCP_INVITE_REQUEST_TITLE'				=> 'Requisitar convites',
+++	'UCP_INVITE_REQUEST_TITLE_EXPLAIN'		=> 'Digita o número de convites que desejas solicitar. Há um máximo de <b>(%s)</b> convites disponíveis.',
+++	'UCP_INVITE_REQUEST_COST'				=> '<div class="invitation_tred alert alert-danger">O preço por convite é de <b>50.000 pontos</b>.</div>',
+++	'UCP_INVITE_SEND'						=> 'Enviar convite',
+++	'UCP_INVITE_SEND_EXPLAIN'			=> '<div class="invitation_tred alert alert-danger">Assumes parte da responsabilidade dos utilizadores que convidares caso eles se comportarem de maneira inapropriada.</div>',
+++	'UCP_INVITE_SEND_EMAIL_MAX'				=> 'Máximo de %s endereços de e-mail podem ser usados. No entanto, listaste %s!', 
+++	'UCP_INVITE_SEND_MAX'					=> '<span class="invitation_tred">Actualmente não há limite!</span>',
+++	'UCP_INVITE_LAST_ACTIVE'				=> 'Última visita',
+++	'UCP_INVITE_MAX_ERROR'					=> 'Actualmente tens convites ilimitados.',
+++	'UCP_INVITE_MAX_RECIPIENTS'				=> 'Digita todos os endereços numa nova linha! <br /> Número máximo de destinatários',
+++	'UCP_INVITE_MESSAGE_BODY_EXPLAIN'		=> 'Escreve algumas linhas a explicar por que deveriam participar.',
+++	'UCP_INVITE_NOT_DELETED_INVITE'			=> 'Não há convites para apagar!',
+++	'UCP_INVITE_NOT_LANGUAGE'				=> 'Ficheiro de idioma inexistente: %s',
+++	'UCP_INVITE_NO_EMAIL'					=> 'Não forneceste um endereço de e-mail!',
+++	'UCP_INVITE_NO_INVITE_USERS'			=> 'Ainda não convidaste ninguém ou ainda não se registaram.',
+++	'UCP_INVITE_NO_LOGIN'					=> 'Ele/ela não se registou neste site.',
+++	'UCP_INVITE_NO_PERM'					=> 'Não está autorizado a enviar convites!',
+++	'UCP_INVITE_NO_PERM_EMAIL'				=> 'Não está autorizado a enviar e-mail!',
+++	'UCP_INVITE_MEMBERSHIP_DAYS'			=> 'A tua conta tem de ter pelo menos %1$d dias antes que possas fazer uso do sistema de convites. Poderás utilizar a partir de %2$s.',
+++	'UCP_INVITE_NO_REG'						=> 'Ninguém foi convidado por ti.',
+++	'UCP_INVITE_NULL'						=> 'Não tem convites! <em>Porque não comprar alguns?</em>', 
+++	'UCP_INVITE_POINTS_AMOUNT'				=> 'Presente',
+++	'UCP_INVITE_POINTS_AMOUNT_EXPLAIN'		=> 'Quantidade de pontos que o utilizador receberá quando ele convidar alguém e se essa pessoa convidada se tornar um membro registado.',
+++	'UCP_INVITE_POINTS_COST'				=> 'Preço do convite',
+++	'UCP_INVITE_POINTS_COST_EXPLAIN'		=> 'O custo do envio de um convite.',
+++	'UCP_INVITE_POST_LIMIT'					=> 'Deves ter um mínimo de %s mensagens, para enviar convites!', 
+++	'UCP_INVITE_REQUEST_SUBJECT'			=> 'Pedido de convite',
+++	'UCP_INVITE_SDB'						=> 'convite(s).',
+++	'UCP_INVITE_SEND_OFF'					=> 'O envio de convites está, de momento, desactivado!',
+++	'UCP_INVITE_SEND_SUBMIT'				=> 'Enviar convite',
+++	'UCP_INVITE_TIME_END'					=> 'Data de expiração',
+++	'UCP_INVITE_TIME_END_EXPLAIN'			=> 'O utilizador convidado terá que se registar durante esse período.',
+++	'UCP_INVITE_USER'						=> 'Utilizadores convidados',
+++	'UCP_INVITE_USERS_COUNT'				=> 'Utilizadores convidados (%s)',
+++	'UCP_INVITE_USER_OK'					=> 'Convite aceite',
+++	'UCP_INVITE_LU_REG'						=> 'Último utilizador',
+++	'UCP_INVITE_LU_REG_EXPLAIN'				=> 'Último utilizador dos seus convites.',
+++	'UCP_INVITE_LU_REG_INFO'				=> '<b>%s</b> registado %s',
+++
+++	'WEEKS'									=> 'Semanas',
+++
+++	'NOTIFICATION_TYPE_INVITE_BIRTHDAY'			=> 'Recebeste convites para o teu aniversário',
+++	'NOTIFICATION_TYPE_INVITE_GIFT'				=> 'Recebeste convites depois de convidar um utilizador com sucesso',
+++	'NOTIFICATION_TYPE_INVITE_PETITION'			=> 'Recebeste uma resposta de uma solicitação de convite',
+++	'NOTIFICATION_TYPE_INVITE_PETITION_REQUEST' => 'Recebeste uma solicitação de convite',
+++	'NOTIFICATION_TYPE_INVITE_JOIN'				=> 'Um utilizador que convidaste criou uma conta',
+++));
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt_preao/install_invite.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt_preao/install_invite.php"
++new file mode 100644
++index 000000000..dd11b1fa9
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt_preao/install_invite.php"
++@@ -0,0 +1,156 @@
+++<?php
+++
+++/**
+++ *
+++ * Invite. An extension for the phpBB Forum Software package.
+++ *
+++ * @copyright (c) 2010-2015, KillBill
+++ * @copyright (c) 2017, kasimi
+++ * @copyright (c) 2017-2022, Leinad4Mind, https://leinad4mind.top/forum
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
+++// Some characters you may want to copy&paste: ’ « » „ “ ” …
+++
+++$lang = array_merge($lang, array(
+++	'AUTH_CACHE_PURGE'						=> 'Clear permission cache',
+++
+++	'CACHE_PURGE'							=> 'Clear forum cache',
+++	'CAT_INSTALL'							=> 'Install',
+++	'CAT_OVERVIEW'							=> 'Overview',
+++	'CAT_UNINSTALL'							=> 'Uninstall',
+++	'CAT_UPDATE'							=> 'Update',
+++	'CAT_VERIFY'							=> 'Verify',
+++
+++	'GPL'									=> 'General Public License',
+++
+++	'INCOMPLETE_FILES_UPLOAD'				=> 'All Invite files have not been uploaded! Please make sure to upload all files before running the installer.',
+++	'INCOMPLETE_FILE_EDITS'					=> 'Editing of this file has not been done yet. The installation can not run unless all files are edited correctly!',
+++	'INCOMPLETE_LANG_ROWS'					=> 'Some changes to the language files are missing. Please apply them as described %sHERE%s.',
+++	'INSTALLATION'							=> 'phpBB Invite install',
+++	'INSTALLATION_EXPLAIN'					=> '<br />phpBB Invite database install.<br /><br />',
+++	'INSTALL_BODY'							=> 'Here you can see that the mod is well established and has been properly installed.',
+++	'INSTALL_ERR_AUTH'						=> 'You are not authorized to use this script.<br /><br />Please note to use the script the following requirements must be met. First you must be logged in to the site and second you must have the user type founder. If you are logged in and are the founder then you have incorrect cookie settings in the ACP. Please check the cookie domain setting. If your site URL is <strong>http://www.example.com</strong> then the cookie domain should be <strong>.example.com</strong>.',
+++	'INSTALL_FOLDER'						=> '<strong>Please delete the install folder. Until you have done this, only the ACP will be available.</strong>',
+++	'INSTALL_LOGIN'							=> 'Proceed to ACP',
+++
+++	'INVITE_CONFIG_ADD'						=> 'Adding new invite config variable: %s',
+++	'INVITE_CONFIG_ALREADY_EXISTS'			=> 'ERROR: Invite config variable %s already exists.',
+++	'INVITE_CONFIG_NOT_EXIST'				=> 'ERROR: Invite config variable %s does not exist.',
+++	'INVITE_CONFIG_REMOVE'					=> 'Removing Invite config variable: %s',
+++	'INVITE_CONFIG_UPDATE'					=> 'Updating Invite config variable: %s',
+++
+++	'INVITE_INSTALL_INTRO'					=> 'Welcome to phpBB Invite Installation',
+++	'INVITE_INSTALL_INTRO_BODY'				=> 'With this option, it is possible to install phpBB Invite to your database.',
+++
+++	'INVITE_VERSION'						=> 'The installed phpBB Invite version is <b>%s</b>, this file can be used to update version <b>%s</b> to version <b>%s</b>. <br /> You first need to upgrade to version <b>%s</b> to run this update script!',
+++
+++	'NOT_INSTALL_DIR'						=> 'Cannot open the install folder!',
+++	'NOT_LANGUAGE_DIR'						=> 'The language library is not available!',
+++	'NOT_LANGUAGE_DIR_DIR'					=> 'The %s language directory cannot be found!',
+++	'NOT_MODULE'							=> 'The installation modules are not available!',
+++	'NOT_MODULE_OPEN'						=> '%s Module is not available!',
+++	'NO_TABLE_DATA'							=> '<span style="color:#FF0000;">Error:</span> The table data is missing.',
+++
+++	'OVERVIEW_BODY'							=> 'Welcome!<br /><br />The installation system presents a complete guide how to install the mod, or remove and update it.<br />Continue with the selection menu... Select the appropriate option from the menu.',
+++
+++	'PARENT_NOT_EXIST'						=> '<span style="color:#FF0000;">Error:</span> The parent category which shows the new module does not exist.',
+++	'PERMISSIONS_WARNING'					=> 'New permission settings have been added.  Check your permission settings and make sure that they are as you would like them.',
+++	'PHPBB_INVITE_DONATE'					=> 'Please make a small donation to appreciate the hard work and many hours used to make the “phpBB Invite”.',
+++	'PHPBB_INVITE_DONATE_TITLE'				=> 'phpBB Invite donation',
+++	'PHPBB_VERSION'							=> 'Your phpBB version is <b>%s</b>, the phpBB Invite mod requires version <b>%s</b> to run!',
+++	'PHP_VERSION_RUN'						=> 'The current PHP version is not supported, please update your PHP to version 4.3.3 or later before you run the installation.</b>',
+++
+++	'ROLE_NOT_EXIST'						=> '<span style="color:#FF0000;">Error:</span> this role is not in the database.',
+++
+++	'STAGE_INSTALL'							=> 'Install',
+++	'STAGE_INTRO'							=> 'Intro',
+++	'STAGE_UNINSTALL'						=> 'Delete the database',
+++	'STAGE_VERIFY'							=> 'Verify',
+++	'STAGE_VERIFY_FILE_EXPLAIN'				=> '<br />The mod files are successfully deleted.',
+++	'SUB_INTRO'								=> 'Intro',
+++	'SUB_LICENSE'							=> 'License',
+++	'SUB_SUPPORT'							=> 'Support',
+++	'SUCCESSES'								=> '<span style="color:#000;"><b>Successfully completed!</b></span>',
+++	'SUPPORT_BODY'							=> 'Full support will be provided for the current release and development versions, all for free.<br />This includes:</p><ul><li>information</li><li>configuration</li><li>update older versions to the newest version</li></ul><p>I encourage everyone who is using an older version to upgrade to the new version.</p><h2>Support forums</h2><br /><p><a href="http://jatek-vilag.com/viewtopic.php?p=204#p204" onclick="window.open(this.href); return false;">The main development site</a><br /><a href="https://www.phpbb.com/community/viewtopic.php?p=12855248#p12855248" onclick="window.open(this.href); return false;">phpBB.com Development topic</a><br /><a href="http://phpbb.hu/forum/hsz/40666#hsz-40666" onclick="window.open(this.href); return false;">phpBB.hu Development topic</a><br /><br />',
+++
+++	'UNINSTALL_BODY'						=> 'Here you can see that the mod database entries have been successfully removed.<br /><br /><b>Please delete the install folder. Until you have done this, only the ACP will be available.</b>',
+++	'UNINSTALL_INTRO'						=> 'phpBB Invite delete',
+++	'UNINSTALL_INTRO_BODY'					=> 'Under this option, you can delete the phpBB Invite from the database.',
+++	'UNINSTALL_TITLE'						=> 'phpBB Invite deleted from the database',
+++	'UPDATE_BODY'							=> 'Here you can see that database data created by this mod has been properly updated.<br /><br /><b>Please delete the install folder. Until you have done this, only the ACP will be available.</b>',
+++	'UPDATE_INSTALLATION'					=> 'phpBB Invite update',
+++	'UPDATE_INSTALLATION_EXPLAIN'			=> '<br />phpBB Invite update on the newest version.<br />',
+++	'UPDATE_TITLE'							=> 'Updating database data',
+++
+++	'VERIFY_ERROR_EXPLAIN'					=> 'The check found an error.',
+++	'VERIFY_ERROR_FILE'						=> 'Bad file modification',
+++	'VERIFY_ERROR_FILE_EXPLAIN'				=> 'Here you can see those files which have been incorrectly edited or has been omitted.',
+++	'VERIFY_EXITS_PRINT_MYAD'				=> '<br />The SQL command you see here you can install by yourself, if you load it in phpMyAdmin.',
+++	'VERIFY_EXITS_PRINT_SQL'				=> '<b><span style="color:#FF0000;">%s</span> <span style="color:#000;">not found!</span></b><br />%s<br />',
+++	'VERIFY_INVITE_MOD_CONFIG'				=> 'phpBB Invite configuration',
+++	'VERIFY_INVITE_MOD_CONFIG_OK'			=> '<span style="color:#228822;"><strong>All phpBB Invite config found.</strong></span>',
+++	'VERIFY_INVITE_MOD_FILES'				=> 'phpBB Invite files',
+++	'VERIFY_INVITE_MOD_FILES_OK'			=> '<span style="color:#228822;"><strong>All files found.</strong></span>',
+++	'VERIFY_INVITE_MOD_MODULES'				=> 'phpBB Invite modules',
+++	'VERIFY_INVITE_MOD_MODULES_OK'			=> '<span style="color:#228822;"><strong>All modules found.</strong></span>',
+++	'VERIFY_INVITE_MOD_PERM'				=> 'phpBB Invite permissions',
+++	'VERIFY_INVITE_MOD_PERM_OK'				=> '<span style="color:#228822;"><strong>All permissions found.</strong></span>',
+++	'VERIFY_INVITE_MOD_TABLES'				=> 'phpBB Invite tables',
+++	'VERIFY_INVITE_MOD_TABLES_OK'			=> '<span style="color:#228822;"><strong>All tables found.</strong></span>',
+++	'VERIFY_NOT_AC_FOUND'					=> '<b><span style="color:#FF0000;">%s</span> <span style="color:#000;">not found!</span></b>',
+++	'VERIFY_NOT_COLUMN'						=> 'Missing columns',
+++	'VERIFY_NOT_COLUMN_EXPLAIN'				=> 'Here you can see all the columns which were not installed.',
+++	'VERIFY_NOT_CONFIG'						=> 'Missing config',
+++	'VERIFY_NOT_CONFIG_EXPLAIN'				=> 'Here you can see the config files which have not been installed.',
+++	'VERIFY_NOT_FILE'						=> 'Missing files',
+++	'VERIFY_NOT_FILE_EXPLAIN'				=> 'Here you can see the files that have not been uploaded correctly or have been uploaded correctly but to the wrong place.',
+++	'VERIFY_NOT_INVITE_CONFIG'				=> 'Missing phpBB Invite config',
+++	'VERIFY_NOT_INVITE_CONFIG_EXPLAIN'		=> 'Here you can see the phpBB Invite config files which have not been installed.',
+++	'VERIFY_NOT_MODULE'						=> 'Missing modules',
+++	'VERIFY_NOT_MODULE_EXPLAIN'				=> 'Here you can see the modules which have not been installed.',
+++	'VERIFY_NOT_PERMIS'						=> 'Missing permissions',
+++	'VERIFY_NOT_PERMIS_EXPLAIN'				=> 'Here you can see the permissions that were not installed.',
+++	'VERIFY_NOT_TABLE'						=> 'Missing table',
+++	'VERIFY_NOT_TABLE_EXPLAIN'				=> 'Here you can see the signs which have not been installed.',
+++	'VERIFY_NO_COLUMN'						=> '<b><span style="color:#FF0000;">%s</span> <span style="color:#000;">column not found!</span></b><br />%s<br />',
+++	'VERIFY_NO_MODULE'						=> '<b><span style="color:#FF0000;">%s</span> <span style="color:#000;">module is not found in the database!</span></b>',
+++	'VERIFY_NO_PERMIS'						=> '<b><span style="color:#FF0000;">%s</span> <span style="color:#000;">permission is not found in the database!</span></b>',
+++	'VERIFY_NO_TABLE'						=> '<b><span style="color:#FF0000;">%s</span> <span style="color:#000;">table is not found in the database!</span></b>%s',
+++	'VERIFY_PHPBB_MOD_COLUMNS'				=> 'phpBB users table new columns',
+++	'VERIFY_PHPBB_MOD_COLUMNS_OK'			=> '<span style="color:#228822;"><strong>All columns found.</strong></span>',
+++	'VERIFY_PHPBB_MOD_CONFIG'				=> 'phpBB new config',
+++	'VERIFY_PHPBB_MOD_CONFIG_OK'			=> '<span style="color:#228822;"><strong>phpBB config found.</strong></span>',
+++	'VERIFY_PHPBB_MOD_FILES'				=> 'phpBB file edits',
+++	'VERIFY_PHPBB_MOD_FILES_OK'				=> '<span style="color:#228822;"><strong>All files are edited.</strong></span>',
+++	'VERIFY_SUCCESSES_EXPLAIN'				=> 'The check found everything okay.',
+++	'VERIFY_TITLE'							=> 'phpBB Invite control',
+++	'VERIFY_TITLE_ELL'						=> 'Control error',
+++	'VERIFY_TITLE_ELL_EXPLAIN'				=> '<span style="color:#000;"><b>Here you can see all occurred errors to fix everything carefully!</b></span>',
+++	'VERIFY_TITLE_EXPLAIN'					=> '<br />Here you can check whether all required file changes, configuration changes and database entries have been made successfully.',
+++	'VERIFY_NEW'							=> 'Check again',
+++	'VERIFY_UNINSTALL_ERROR_FILE'			=> 'Existing files',
+++	'VERIFY_UNINSTALL_ERROR_FILE_EXPLAIN'	=> 'Here you can see the files which have not been removed.',
+++));
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt_preao/invite.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt_preao/invite.php"
++new file mode 100644
++index 000000000..07794c344
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt_preao/invite.php"
++@@ -0,0 +1,53 @@
+++<?php
+++
+++/**
+++ *
+++ * Invite. An extension for the phpBB Forum Software package.
+++ * Brazilian Portuguese translation by eunaumtenhoid [2019][ver 4.2.0] (https://github.com/phpBBTraducoes)
+++ * @copyright (c) 2010-2015, KillBill
+++ * @copyright (c) 2017, kasimi
+++ * @copyright (c) 2017-2022, Leinad4Mind, https://leinad4mind.top/forum
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
+++// Some characters you may want to copy&paste: ’ « » „ “ ” …
+++
+++$lang = array_merge($lang, array(
+++	'INVITE'								=> 'Convites',
+++	'INVITE_INFO'								=> 'Informação sobre Convites',
+++	'INVITE_DELETE_CONFIRM'					=> 'Se quiseres apagar o convite, clica %sAQUI%s.',
+++	'INVITE_DELETE_SUCCESS'					=> 'O teu convite foi apagados com sucesso.',
+++	'INVITE_DELETE_SUCCESSES'				=> 'Os teus convites foram apagados com sucesso.',
+++	'INVITE_DISABLED'						=> '<span class="invitation_tred">O sistema de convite está atualmente desativado!</span>',
+++	'INVITE_EMAIL_BLOCK'					=> 'Bloqueado!',
+++	'INVITE_INVITED'						=> 'Convidado por',
+++	'INVITE_INVITES'						=> 'Convidou',
+++	'INVITE_KEY_ERROR'						=> '<div class="invitation_error">O convite não é válido!</div>',
+++	'INVITE_PERSON'							=> '%s pessoa(s)',
+++	'INVITE_POINTS_PRESENT'					=> 'A cada %s convite(s), enviamos %s %s !',
+++	'INVITE_REGISTRATION'					=> '<div class="invitation_error">Registo apenas por convite!</div>',
+++	'INVITE_REGISTRATION_EXPLAIN'			=> 'De momento os registos são restritos apenas a pessoas convidadas por utilizadores da comunidade, caso conheças alguém que tenha conta pede um convite!',
+++	'INVITE_COPYRIGHT'						=> 'phpBB Invite by <a href="https://leinad4mind.top/forum">Leinad4Mind</a> &copy; 2018-2022',
+++));
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt_preao/permissions_invite.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt_preao/permissions_invite.php"
++new file mode 100644
++index 000000000..90f45e670
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt_preao/permissions_invite.php"
++@@ -0,0 +1,51 @@
+++<?php
+++
+++/**
+++ *
+++ * Invite. An extension for the phpBB Forum Software package.
+++ * Brazilian Portuguese translation by eunaumtenhoid [2019][ver 4.2.0] (https://github.com/phpBBTraducoes)
+++ * @copyright (c) 2010-2015, KillBill
+++ * @copyright (c) 2017, kasimi
+++ * @copyright (c) 2017-2022, Leinad4Mind, https://leinad4mind.top/forum
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
+++// Some characters you may want to copy&paste: ’ « » „ “ ” …
+++
+++$lang = array_merge($lang, array(
+++	'ACL_A_INVITE'			=> 'O utilizador pode sincronizar dados',
+++	'ACL_A_INVITE_CONFIG'	=> 'O utilizador pode alterar as configurações do convite.',
+++	'ACL_A_INVITE_DELETE'	=> 'O utilizador pode apagar convites',
+++	'ACL_A_INVITE_CLAIMING' => 'O utilizador pode gerir convites',
+++	'ACL_A_INVITE_SEND'		=> 'O utilizador pode adicionar convites para membros',
+++	'ACL_A_INVITE_PEND'		=> 'O utilizador pode gerir convites pendentes',
+++	'ACL_A_INVITE_USERS'	=> 'O utilizador pode ver uma lista de membros convidados',
+++	'ACL_M_INVITE_CLAIMING'	=> 'O utilizador pode aprovar um pedido de convite.',
+++	'ACL_U_INVITE_DELETE'	=> 'O utilizador pode revogar convites<br /><em>O utilizador pode cancelar um convite que ele enviou.</em>',
+++	'ACL_U_INVITE_REQUEST'	=> 'O utilizador pode solicitar convite',
+++	'ACL_U_INVITE_SENDING'		=> 'O utilizador pode convidar novos membros para o site',
+++	'ACL_U_INVITE_MAX'		=> 'O utilizador tem convites ilimitados',
+++	'ACL_U_INVITE_USERS'	=> 'O utilizador pode visualizar a lista de utilizadores convidados por outras pessoas.',
+++));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/styles/FLATBOOTS/template/event/memberlist_body_memberlist_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/styles/FLATBOOTS/template/event/memberlist_body_memberlist_after.bak"
++similarity index 100%
++rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/styles/FLATBOOTS/template/event/memberlist_body_memberlist_after.html"
++rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/styles/FLATBOOTS/template/event/memberlist_body_memberlist_after.bak"
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/styles/FLATBOOTS/template/event/navbar_header_profile_list_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/styles/FLATBOOTS/template/event/navbar_header_profile_list_after.html"
++index 3f31a66e4..18fe47011 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/styles/FLATBOOTS/template/event/navbar_header_profile_list_after.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/styles/FLATBOOTS/template/event/navbar_header_profile_list_after.html"
++@@ -1 +1 @@
++-{% if U_INVITE %}<li><a class="btn btn-primary btn-sm btn-block" href="{{ U_INVITE }}"><i class="fa fa-ticket"></i>&nbsp;{{ lang('INVITE_GLOBAL') }}</a></li>{% endif %}
++\ No newline at end of file
+++{% if U_INVITE %}<a class="btn btn-primary btn-sm btn-block" href="{{ U_INVITE }}"><i class="fa fa-id-card-o"></i>&nbsp;{{ lang('INVITE_GLOBAL') }}</a>{% endif %}
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/styles/FLATBOOTS/template/event/overall_header_navigation_append.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/styles/FLATBOOTS/template/event/overall_header_navigation_append.bak"
++similarity index 100%
++rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/styles/FLATBOOTS/template/event/overall_header_navigation_append.html"
++rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/styles/FLATBOOTS/template/event/overall_header_navigation_append.bak"
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/styles/FLATBOOTS/template/event/memberlist_view_user_statistics_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/styles/FLATBOOTS/template/event/ss_memberlist_view_timeline_item_after.html"
++similarity index 100%
++rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/styles/FLATBOOTS/template/event/memberlist_view_user_statistics_after.html"
++rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/styles/FLATBOOTS/template/event/ss_memberlist_view_timeline_item_after.html"
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/styles/FLATBOOTS/template/ucp_invite.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/styles/FLATBOOTS/template/ucp_invite.html"
++index c6a20c038..ff7ea1802 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/styles/FLATBOOTS/template/ucp_invite.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/styles/FLATBOOTS/template/ucp_invite.html"
++@@ -2,169 +2,171 @@
++ 
++ {% if S_INVITE_DATA %}
++ <fieldset class="framed-ucp">
++- <legend>{{ lang('UCP_INVITE_DATA') }}</legend>
++- <div class="space10"></div>
++-<div>
++-	<div class="inner">
++-	<div class="invite_info invite_info-odd">
++-		<div class="col-md-7">
++-			<label>{{ lang('UCP_INVITE_DB_NUMBER') }}{{ lang('COLON') }}</label><br /><span>{{ lang('UCP_INVITE_DB_NUMBER_EXPLAIN') }}</span>
++-		</div>
++-		<div class="col-md-5"><label>{{ INVITE_DB_NUMBER }}</label></div>
++-	</div>
++-	
+++	<legend>{{ lang('UCP_INVITE_DATA') }}</legend>
++ 	<div class="space10"></div>
+++	<div>
+++		<div class="inner">
+++			<div class="invite_info invite_info-odd">
+++				<div class="col-md-7">
+++					<label>{{ lang('UCP_INVITE_DB_NUMBER') }}{{ lang('COLON') }}</label><br /><span class="hidden-xs">{{ lang('UCP_INVITE_DB_NUMBER_EXPLAIN') }}</span>
+++				</div>
+++				<div class="col-md-5"><label>{{ INVITE_DB_NUMBER }}</label></div>
+++			</div>
++ 
++-	<div class="invite_info invite_info-even">
++-		<div class="col-md-7">
++-			<label>{{ lang('UCP_INVITE_DB_USER') }}{{ lang('COLON') }}</label><br /><span>{{ lang('UCP_INVITE_DB_USER_EXPLAIN') }}</span>
++-		</div>
++-		<div class="col-md-5"><label>{{ INVITE_DB_USER }}</label></div>
++-	</div>
+++			<div class="space10"></div>
++ 
++-	<div class="space10"></div>
+++			<div class="invite_info invite_info-even">
+++				<div class="col-md-7">
+++					<label>{{ lang('UCP_INVITE_DB_USER') }}{{ lang('COLON') }}</label><br /><span class="hidden-xs">{{ lang('UCP_INVITE_DB_USER_EXPLAIN') }}</span>
+++				</div>
+++				<div class="col-md-5"><label>{{ INVITE_DB_USER }}</label></div>
+++			</div>
++ 
++-	<div class="invite_info invite_info-odd">
++-		<div class="col-md-7">
++-			<label>{{ lang('UCP_INVITE_DB_SEND') }}{{ lang('COLON') }}</label><br /><span>{{ lang('UCP_INVITE_DB_SEND_EXPLAIN') }}</span>
++-		</div>
++-		<div class="col-md-5"><label>{{ INVITE_DB_SEND }}</label></div>
++-	</div>
+++			<div class="space10"></div>
++ 
++-	<div class="space10"></div>
+++			<div class="invite_info invite_info-odd">
+++				<div class="col-md-7">
+++					<label>{{ lang('UCP_INVITE_DB_SEND') }}{{ lang('COLON') }}</label><br /><span class="hidden-xs">{{ lang('UCP_INVITE_DB_SEND_EXPLAIN') }}</span>
+++				</div>
+++				<div class="col-md-5"><label>{{ INVITE_DB_SEND }}</label></div>
+++			</div>
++ 
++-	<div class="invite_info invite_info-even">
++-		<div class="col-md-7">
++-			<label>{{ lang('UCP_INVITE_DAYF') }}{{ lang('COLON') }}</label><br /><span>{{ lang('UCP_INVITE_DAYF_EXPLAIN') }}</span>
++-		</div>
++-		<div class="col-md-5"><label>{{ INVITE_DAY_DB }}</label></div>
++-	</div>
+++			<div class="space10"></div>
++ 
++-	<div class="space10"></div>
+++			<div class="invite_info invite_info-even">
+++				<div class="col-md-7">
+++					<label>{{ lang('UCP_INVITE_DAYF') }}{{ lang('COLON') }}</label><br /><span class="hidden-xs">{{ lang('UCP_INVITE_DAYF_EXPLAIN') }}</span>
+++				</div>
+++				<div class="col-md-5"><label>{{ INVITE_DAY_DB }}</label></div>
+++			</div>
++ 
++-	<div class="invite_info invite_info-odd">
++-		<div class="col-md-7">
++-			<label>{{ lang('UCP_INVITE_DB_PENDING') }}{{ lang('COLON') }}</label><br /><span>{{ lang('UCP_INVITE_DB_PENDING_EXPLAIN') }}</span>
++-		</div>
++-		<div class="col-md-5"><label>{{ INVITE_DB_PENDING }}</label></div>
++-	</div>
+++			<div class="space10"></div>
++ 
++-	<div class="space10"></div>
+++			<div class="invite_info invite_info-odd">
+++				<div class="col-md-7">
+++					<label>{{ lang('UCP_INVITE_DB_PENDING') }}{{ lang('COLON') }}</label><br /><span class="hidden-xs">{{ lang('UCP_INVITE_DB_PENDING_EXPLAIN') }}</span>
+++				</div>
+++				<div class="col-md-5"><label>{{ INVITE_DB_PENDING }}</label></div>
+++			</div>
++ 
++-	<div class="invite_info invite_info-even">
++-		<div class="col-md-7">
++-			<label>{{ lang('UCP_INVITE_TIME_END') }}{{ lang('COLON') }}</label><br /><span>{{ lang('UCP_INVITE_TIME_END_EXPLAIN') }}</span>
++-		</div>
++-		<div class="col-md-5"><label><strong>{{ INVITE_TIME_END }} {{ lang('DAY') }}</strong></label></div>
++-	</div>
+++			<div class="space10"></div>
++ 
++-	<div class="space10"></div>
+++			<div class="invite_info invite_info-even">
+++				<div class="col-md-7">
+++					<label>{{ lang('UCP_INVITE_TIME_END') }}{{ lang('COLON') }}</label><br /><span class="hidden-xs">{{ lang('UCP_INVITE_TIME_END_EXPLAIN') }}</span>
+++				</div>
+++				<div class="col-md-5"><label><strong>{{ INVITE_TIME_END }}</strong></label></div>
+++			</div>
+++
+++			<div class="space10"></div>
++ 
++-	<div class="invite_info invite_info-odd">
++-		<div class="col-md-7">
++-			<label>{{ lang('UCP_INVITE_LU_REG') }}{{ lang('COLON') }}</label><br /><span>{{ lang('UCP_INVITE_LU_REG_EXPLAIN') }}</span>
+++			<div class="invite_info invite_info-odd">
+++				<div class="col-md-7">
+++					<label>{{ lang('UCP_INVITE_LU_REG') }}{{ lang('COLON') }}</label><br /><span class="hidden-xs">{{ lang('UCP_INVITE_LU_REG_EXPLAIN') }}</span>
+++				</div>
+++				<div class="col-md-5"><label>{{ INVITE_LAST_USER }}</label></div>
+++			</div>
++ 		</div>
++-		<div class="col-md-5"><label>{{ INVITE_LAST_USER }}</label></div>
++-	</div>
++-</div>
++ </fieldset>
++ {% endif %}
++ 
++ {% if S_INVITE_MAIL %}
++ 
++-	{% if MORE_RECIPIENTS %}
++-		{% INCLUDECSS '@leinad4mind_invitation/multiple-emails.css' %}
++-		{% INCLUDEJS '@leinad4mind_invitation/js/multiple-emails.js' %}
++-		{% INCLUDEJS '@leinad4mind_invitation/js/email.js' %}
++-	{% endif %}
+++{% if MORE_RECIPIENTS %}
+++{% INCLUDECSS '@leinad4mind_invitation/multiple-emails.css' %}
+++{% INCLUDEJS '@leinad4mind_invitation/js/multiple-emails.js' %}
+++{% INCLUDEJS '@leinad4mind_invitation/js/email.js' %}
+++{% endif %}
++ 
++ <fieldset class="framed-ucp">
++-<legend>{{ lang('UCP_INVITE_SEND') }}</legend>
++-<div class="space10"></div>
++-<form id="invite_send" method="post" action="{{ U_ACTION }}">
++-	<div>
++-		<div class="inner">
++-			{% if ERROR_MESSAGE %}
+++	<legend>{{ lang('UCP_INVITE_SEND') }}</legend>
+++	<div class="space10"></div>
+++	<form id="invite_send" method="post" action="{{ U_ACTION }}">
+++		<div>
+++			<div class="inner">
+++				{% if ERROR_MESSAGE %}
++ 				<div class="alert alert-danger">{{ ERROR_MESSAGE }}</div>
++-			{% endif %}
+++				{% endif %}
+++
+++				<div>{{ lang('UCP_INVITE_SEND_EXPLAIN') }}</div>
++ 
++-			<fieldset class="fields2">
++-				{% if S_INVITE_LANG_OPTIONS %}
++-				<div> 
++-					<label class="control-label" for="invite_lang">{{ lang('UCP_INVITE_EMAIL_LANG') }}{{ lang('COLON') }}</label>
++-					<div class="controls controls-row"> 
++-					<select class="tz_select selectpicker" data-container="body" data-width="auto" onchange="document.forms['invite_send'].submit.click(); return false;" tabindex="1" name="invite_lang" id="invite_lang" title="{{ lang('LANGUAGE') }}">
++-						{{ S_INVITE_LANG_OPTIONS }}
++-					</select>
+++				<fieldset class="fields2">
+++					{% if S_INVITE_LANG_OPTIONS %}
+++					<div>
+++						<label class="control-label" for="invite_lang">{{ lang('UCP_INVITE_EMAIL_LANG') }}{{ lang('COLON') }}</label>
+++						<div class="controls controls-row">
+++							<select class="tz_select selectpicker" data-container="body" data-width="auto" onchange="document.forms['invite_send'].submit.click(); return false;" tabindex="1" name="invite_lang" id="invite_lang" title="{{ lang('LANGUAGE') }}">
+++								{{ S_INVITE_LANG_OPTIONS }}
+++							</select>
+++						</div>
++ 					</div>
++-				</div>
++-				<div class="space10"></div>
++-				<div class="space10"></div>
++-				<div class="space10"></div>
++-				{% endif %}
++-				<div> 
++-					<label for="friend">{{ lang('UCP_INVITE_FRIEND') }}{{ lang('COLON') }}</label><br /><span>{{ lang('UCP_INVITE_FRIEND_EXPLAIN') }}</span>
++ 					<div class="space10"></div>
++-					<div> 
++-						<label for="friend1"><input type="radio" class="radio" name="friend" id="friend1" value="1"{% if S_FRIEND %} checked="checked"{% endif %} /> {{ lang('YES') }}</label>
++-						<label for="friend0"><input type="radio" class="radio" name="friend" id="friend0" value="0"{% if not S_FRIEND %} checked="checked"{% endif %} /> {{ lang('NO') }}</label>
+++					<div class="space10"></div>
+++					<div class="space10"></div>
+++					{% endif %}
+++					<div>
+++						<label for="friend">{{ lang('UCP_INVITE_FRIEND') }}{{ lang('COLON') }}</label><br /><span>{{ lang('UCP_INVITE_FRIEND_EXPLAIN') }}</span>
+++						<div class="space10"></div>
+++						<div>
+++							<label for="friend1"><input type="radio" class="radio" name="friend" id="friend1" value="1" {% if S_FRIEND %} checked="checked" {% endif %} /> {{ lang('YES') }}</label>
+++							<label for="friend0"><input type="radio" class="radio" name="friend" id="friend0" value="0" {% if not S_FRIEND %} checked="checked" {% endif %} /> {{ lang('NO') }}</label>
+++						</div>
++ 					</div>
++-				</div>
++-				<div class="space10"></div>
++-				<div class="space10"></div>
++-				<div class="space10"></div>
++-				<div class="form-group">
++-					<label for="email">{{ lang('EMAIL_ADDRESS') ~ lang('COLON') }}</label>{% if MORE_RECIPIENTS %}<br /><span>{{ lang('UCP_INVITE_MAX_RECIPIENTS') }}{{ lang('COLON') }}{{ MORE_RECIPIENTS }}</span>{% endif %}
++-					<div class="input-icon left">
++-						<i class="fa fa-at"></i>
++-						{% if MORE_RECIPIENTS %}
+++					<div class="space10"></div>
+++					<div class="space10"></div>
+++					<div class="space10"></div>
+++					<div class="form-group">
+++						<label for="email">{{ lang('EMAIL_ADDRESS') ~ lang('COLON') }}</label>{% if MORE_RECIPIENTS %}<br /><span>{{ lang('UCP_INVITE_MAX_RECIPIENTS') }}{{ lang('COLON') }}{{ MORE_RECIPIENTS }}</span>{% endif %}
+++						<div class="input-icon left">
+++							<i class="fa fa-at"></i>
+++							{% if MORE_RECIPIENTS %}
++ 							<textarea class="form-control input-sm" style="display:none;" name="email" id="email" rows="1" cols="25" tabindex="2">{{ EMAIL_CIM }}</textarea>
++-						{% else %}
+++							{% else %}
++ 							<input class="form-control input-sm" type="email" name="email" id="email" size="25" maxlength="100" tabindex="2" value="{{ EMAIL_CIM }}" />
++-						{% endif %}
+++							{% endif %}
+++						</div>
++ 					</div>
++-				</div>
++-				<div class="space10"></div>
++-				<div class="space10"></div>
++-				<div class="form-group">
++-					<label for="subject">{{ lang('SUBJECT') ~ lang('COLON') }}</label>
++-					<div class="input-icon">
++-						<input class="form-control input-sm" type="text" name="subject" id="subject" size="50" maxlength="255" tabindex="3" value="{{ EMAIL_TEMA }}" />
+++					<div class="space10"></div>
+++					<div class="space10"></div>
+++					<div class="form-group">
+++						<label for="subject">{{ lang('SUBJECT') ~ lang('COLON') }}</label>
+++						<div class="input-icon">
+++							<input class="form-control input-sm" type="text" name="subject" id="subject" size="50" maxlength="255" tabindex="3" value="{{ EMAIL_TEMA }}" />
+++						</div>
++ 					</div>
++-				</div>
++-				<div class="space10"></div>
++-				<div class="space10"></div>
++-				<div class="form-group">
++-					<label for="subject">{{ lang('MESSAGE_BODY') ~ lang('COLON') }}</label><br /><span>{{ lang('UCP_INVITE_MESSAGE_BODY_EXPLAIN') }}</span>
++-					<div class="input-icon">
++-						<textarea class="form-control input-sm" type="text" name="message" id="message" rows="15" cols="45" tabindex="4">{{ EMAIL_MESSAGE }}</textarea>
+++					<div class="space10"></div>
+++					<div class="space10"></div>
+++					<div class="form-group">
+++						<label for="subject">{{ lang('MESSAGE_BODY') ~ lang('COLON') }}</label><br /><span>{{ lang('UCP_INVITE_MESSAGE_BODY_EXPLAIN') }}</span>
+++						<div class="input-icon">
+++							<textarea class="form-control input-sm" type="text" name="message" id="message" rows="15" cols="45" tabindex="4">{{ EMAIL_MESSAGE }}</textarea>
+++						</div>
++ 					</div>
++-				</div>
++-			</fieldset>
+++				</fieldset>
+++			</div>
++ 		</div>
++-	</div>
++ 
++-	{% if CAPTCHA_TEMPLATE %}
++-	<div>
++-		<div class="inner">
++-			<fieldset class="fields2">
++-			{% DEFINE CAPTCHA_TAB_INDEX = 5 %}
++-			{% INCLUDE ''~ CAPTCHA_TEMPLATE ~'' %}
++-			</fieldset>
+++		{% if CAPTCHA_TEMPLATE %}
+++		<div>
+++			<div class="inner">
+++				<fieldset class="fields2">
+++					{% DEFINE CAPTCHA_TAB_INDEX = 5 %}
+++					{% INCLUDE ''~ CAPTCHA_TEMPLATE ~'' %}
+++				</fieldset>
+++			</div>
++ 		</div>
++-	</div>
++-	{% endif %}
+++		{% endif %}
++ 
++-	<div>
++-		<div class="inner">
++-			<fieldset class="submit-buttons">
++-				<input type="submit" name="submit" id="submit" value="{{ lang('UCP_INVITE_SEND_SUBMIT') }}" class="btn btn-default" />
++-				{{ S_HIDDEN_FIELDS }}
++-				{{ S_FORM_TOKEN }}
++-			</fieldset>
+++		<div>
+++			<div class="inner">
+++				<fieldset class="submit-buttons">
+++					<input type="submit" name="submit" id="submit" value="{{ lang('UCP_INVITE_SEND_SUBMIT') }}" class="btn btn-default" />
+++					{{ S_HIDDEN_FIELDS }}
+++					{{ S_FORM_TOKEN }}
+++				</fieldset>
+++			</div>
++ 		</div>
++-	</div>
++-</form>
+++	</form>
++ </fieldset>
++ {% endif %}
++ 
++@@ -178,12 +180,15 @@
++ 			<div class="inner">
++ 				<fieldset>
++ 					{% if ERROR_MESSAGE %}
++-						<div class="alert alert-danger">{{ ERROR_MESSAGE }}</div>
+++					<div class="alert alert-danger">{{ ERROR_MESSAGE }}</div>
++ 					{% endif %}
++-					<dl>
++-						<dt><label for="claiming_db">{{ SUBT_INVITE_REQUEST }}{{ lang('COLON') }}</label><br /><span>{{ SUBT_INVITE_REQUEST_EXPLAIN }}</span></dt>
++-						<dd><input class="inputbox autowidth" type="text" id="claiming_db" name="claiming_db" size="2" maxlength="2" value="{{ INVITE_REQUEST_DB_SELECT }}" /> {{ lang('UCP_INVITE_SDB') }}</dd>
++-					</dl>
+++					{{ lang('UCP_INVITE_REQUEST_COST') }}
+++					<div class="form-group">
+++						<label for="subject">{{ SUBT_INVITE_REQUEST }}{{ lang('COLON') }}</label><br /><span>{{ SUBT_INVITE_REQUEST_EXPLAIN }}</span>
+++						<div class="input-icon" style="display:flex;align-items:center">
+++							<input class="form-control input-sm" style="width:5rem" type="text" id="claiming_db" name="claiming_db" size="2" maxlength="2" value="{{ INVITE_REQUEST_DB_SELECT }}" />&nbsp;{{ lang('UCP_INVITE_SDB') }}
+++						</div>
+++					</div>
++ 					{% if S_SIZE_POSTS_REQUIRED %}
++ 					<dl>
++ 						<dt class="invite_notice">{{ UCP_INVITE_REQUEST_MANY_EXPLAIN }}</dt>
++@@ -200,9 +205,10 @@
++ 		<div class="panel">
++ 			<div class="inner">
++ 				<fieldset class="submit-buttons">
++-					<input type="submit" name="submit" id="submit" value="{{ INVITE_REQUEST_SUBMIT }}" class="button1" />
+++					<input type="submit" name="submit" id="submit" value="{{ INVITE_REQUEST_SUBMIT }}" class="btn btn-default" />
++ 					{{ S_FORM_TOKEN }}
++ 				</fieldset>
+++				<div class="space10"></div>
++ 			</div>
++ 		</div>
++ 	</form>
++@@ -219,72 +225,72 @@
++ {% endif %}
++ 
++ {% if UCP_INVITE_USER %}
++-	{% if loops.users|length %}
++-		{% INCLUDE 'memberlist_invite.html' %}
++-	{% else %}
++-	<fieldset class="framed-ucp">
++-		<legend>{{ lang('INFORMATION') }}</legend>
++-		<div>
++-			<div class="inner">
++-				<fieldset style="text-align:center;">
++-					<span class="alert alert-warning">{{ lang('UCP_INVITE_NO_INVITE_USERS') }}</span>
++-				</fieldset>
++-			</div>
+++{% if loops.users|length %}
+++{% INCLUDE 'memberlist_invite.html' %}
+++{% else %}
+++<fieldset class="framed-ucp">
+++	<legend>{{ lang('INFORMATION') }}</legend>
+++	<div>
+++		<div class="inner">
+++			<fieldset style="text-align:center;">
+++				<span class="alert alert-warning">{{ lang('UCP_INVITE_NO_INVITE_USERS') }}</span>
+++			</fieldset>
++ 		</div>
++-		<div class="space10"></div>
++-	</fieldset>
++-	{% endif %}
+++	</div>
+++	<div class="space10"></div>
+++</fieldset>
+++{% endif %}
++ {% endif %}
++ 
++ {% if S_INVITE_DELETE %}
++ <fieldset class="framed-ucp">
++- <legend>{{ lang('UCP_INVITE_DELETE') }}</legend>
+++	<legend>{{ lang('UCP_INVITE_DELETE') }}</legend>
++ 	<p>{{ UCP_INVITE_DELETE_EXPLAIN }}</p>
++ 	<form id="invite_delete" method="post" action="{{ U_ACTION }}">
++-	<div>
++-		<div class="inner">
++-			{% if ERROR_MESSAGE %}
+++		<div>
+++			<div class="inner">
+++				{% if ERROR_MESSAGE %}
++ 				<div class="alert alert-danger">{{ ERROR_MESSAGE }}</div>
++-			{% endif %}
++-			<fieldset>
+++				{% endif %}
+++				<fieldset>
++ 
++-			<div> 
++-				{% if loops.email|length %}
++-					<label class="control-label" for="email">{{ lang('UCP_INVITE_EMAIL_SELECT') }}{{ lang('COLON') }}</label>
++-					<span>{{ lang('UCP_INVITE_EMAIL_SELECT_EXPLAIN') }}</span>
++-					<div class="space10"></div>
++-					<div class="controls controls-row"> 
++-					<select class="tz_select selectpicker" data-container="body" data-width="auto" onchange="document.forms['invite_send'].submit.click(); return false;" tabindex="1" name="email" id="email" title="{{ lang('LANGUAGE') }}">
++-						{% for email in loops.email %}
++-							<option class="bg1" value="{{ email.EMAIL }}">{% if email.COUNT %}({{ email.COUNT }} {{ lang('INVITE') }}) - {% endif %}{{ email.EMAIL }}</option>
++-						{% endfor %}
++-					</select>
++-					&nbsp;&nbsp;{{ lang('CONFIRM') }
\ No newline at end of file
diff --git "[ORIGINAL]/leinad4mind\\invitation/includes/functions.php" "[FORUM_EXT]/leinad4mind\\invitation/includes/functions.php"
--- "[ORIGINAL]/leinad4mind\\invitation/includes/functions.php"
+++ "[FORUM_EXT]/leinad4mind\\invitation/includes/functions.php"
@@ -435,7 +435,7 @@ class functions
 		$row2 = $this->db->sql_fetchrow($result);
 		$this->db->sql_freeresult($result);
 
-		if ($row['user_id'])
+		if ($row !== false && $row['user_id'])
 		{
 			$this->template->assign_vars(array(
 				'INVITE_USER_NAME'	=> '<strong>' . get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']) . '</strong>',
@@ -443,7 +443,7 @@ class functions
 		}
 		
 		
-		if ($row2['user_id'])
+		if ($row2 !== false && $row2['user_id'])
 		{
 			$this->template->assign_vars(array(
 				'L_INVITE_MEMBER'	=> $this->language->lang('INVITE') . (($this->ext_config['invite_db'] || $this->auth->acl_get('u_invite_max')) ? '' : ' (' . $row2['user_invite'] . ')'),
diff --git "[ORIGINAL]/leinad4mind\\invitation/language/de/permissions_invite.php" "[FORUM_EXT]/leinad4mind\\invitation/language/de/permissions_invite.php"
--- "[ORIGINAL]/leinad4mind\\invitation/language/de/permissions_invite.php"
+++ "[FORUM_EXT]/leinad4mind\\invitation/language/de/permissions_invite.php"
@@ -38,14 +38,14 @@ $lang = array_merge($lang, array(
 	'ACL_A_INVITE'			=> 'Benutzer kann Daten synchronisieren',
 	'ACL_A_INVITE_CONFIG'	=> 'Benutzer kann Einladungen konfigurieren.',
 	'ACL_A_INVITE_DELETE'	=> 'Benutzer kann Einladungen löschen',
-	'ACL_A_INVITE_SIZE'		=> 'Benutzer kann Einladungen verwalten',
+	'ACL_A_INVITE_CLAIMING'		=> 'Benutzer kann Einladungen verwalten',
 	'ACL_A_INVITE_SEND'		=> 'Benutzer kann Einladungen Mitgliedern zuweisen',
 	'ACL_A_INVITE_PEND'		=> 'Benutzer kann ausstehende Einladungen verwalten',
 	'ACL_A_INVITE_USERS'	=> 'Benutzer kann eine Liste eingeladener Mitglieder einsehen',
-	'ACL_M_INVITE_SIZE'		=> 'Benutzer kann Einladungsanfrage akzeptieren.',
+	'ACL_M_INVITE_CLAIMING'		=> 'Benutzer kann Einladungsanfrage akzeptieren.',
 	'ACL_U_INVITE_DELETE'	=> 'Benutzer kann Einladung zurückziehen<br /><em>Benutzer kann eine Einladung, die er vergeben hat, abbrechen.</em>',
 	'ACL_U_INVITE_REQUEST'	=> 'Benutzer kann Einladung anfordern',
-	'ACL_U_INVITE_SEND'		=> 'Benutzer kann neue Mitglieder zur Seite einladen',
+	'ACL_U_INVITE_SENDING'		=> 'Benutzer kann neue Mitglieder zur Seite einladen',
 	'ACL_U_INVITE_MAX'		=> 'Benutzer hat unbegrenzte Einladungen',
 	'ACL_U_INVITE_USERS'	=> 'Benutzer kann eine Liste der von anderen Benutzern eingeladenen Mitglieder einsehen.',
 ));
diff --git "[ORIGINAL]/leinad4mind\\invitation/language/de_x_sie/permissions_invite.php" "[FORUM_EXT]/leinad4mind\\invitation/language/de_x_sie/permissions_invite.php"
--- "[ORIGINAL]/leinad4mind\\invitation/language/de_x_sie/permissions_invite.php"
+++ "[FORUM_EXT]/leinad4mind\\invitation/language/de_x_sie/permissions_invite.php"
@@ -38,14 +38,14 @@ $lang = array_merge($lang, array(
 	'ACL_A_INVITE'			=> 'Benutzer kann Daten synchronisieren',
 	'ACL_A_INVITE_CONFIG'	=> 'Benutzer kann Einladungen konfigurieren.',
 	'ACL_A_INVITE_DELETE'	=> 'Benutzer kann Einladungen löschen',
-	'ACL_A_INVITE_SIZE'		=> 'Benutzer kann Einladungen verwalten',
+	'ACL_A_INVITE_CLAIMING'		=> 'Benutzer kann Einladungen verwalten',
 	'ACL_A_INVITE_SEND'		=> 'Benutzer kann Einladungen Mitgliedern zuweisen',
 	'ACL_A_INVITE_PEND'		=> 'Benutzer kann ausstehende Einladungen verwalten',
 	'ACL_A_INVITE_USERS'	=> 'Benutzer kann eine Liste eingeladener Mitglieder einsehen',
-	'ACL_M_INVITE_SIZE'		=> 'Benutzer kann Einladungsanfrage akzeptieren.',
+	'ACL_M_INVITE_CLAIMING'		=> 'Benutzer kann Einladungsanfrage akzeptieren.',
 	'ACL_U_INVITE_DELETE'	=> 'Benutzer kann Einladung zurückziehen<br /><em>Benutzer kann eine Einladung, die er vergeben hat, abbrechen.</em>',
 	'ACL_U_INVITE_REQUEST'	=> 'Benutzer kann Einladung anfordern',
-	'ACL_U_INVITE_SEND'		=> 'Benutzer kann neue Mitglieder zur Seite einladen',
+	'ACL_U_INVITE_SENDING'		=> 'Benutzer kann neue Mitglieder zur Seite einladen',
 	'ACL_U_INVITE_MAX'		=> 'Benutzer hat unbegrenzte Einladungen',
 	'ACL_U_INVITE_USERS'	=> 'Benutzer kann eine Liste der von anderen Benutzern eingeladenen Mitglieder einsehen.',
 ));
diff --git "[ORIGINAL]/leinad4mind\\invitation/language/en/info_acp_invite.php" "[FORUM_EXT]/leinad4mind\\invitation/language/en/info_acp_invite.php"
--- "[ORIGINAL]/leinad4mind\\invitation/language/en/info_acp_invite.php"
+++ "[FORUM_EXT]/leinad4mind\\invitation/language/en/info_acp_invite.php"
@@ -45,7 +45,9 @@ $lang = array_merge($lang, array(
 	'ACP_INVITED_PEND_COUNT'							=> 'All Invitations (%s)',
 	'ACP_INVITED_USERS_COUNT'							=> 'All users (%s)',
 	'ACP_INVITE_ALL_USER_INVITE_MAX'					=> 'Unlimited invitation for everyone',
-	'ACP_INVITE_ALL_USER_INVITE_MAX_EXPLAIN'			=> 'if selected, all users will have unlimited invitations.',
+	'ACP_INVITE_ALL_USER_INVITE_MAX_EXPLAIN'			=> 'If selected, all users will have unlimited invitations.',
+	'ACP_INVITE_RESTORE_INVITES'						=> 'Restore expired and refused invitations',
+	'ACP_INVITE_RESTORE_INVITES_EXPLAIN'				=> 'If selected, invitations that were expired or refused could be reused again.',
 	'ACP_INVITE_BIRTHDAYS'								=> 'Birthday',
 	'ACP_INVITE_BIRTHDAYS_EXPLAIN'						=> 'You can set how many invitations a user will receive for their birthday. <em>To let this setting take effect the birthday feature needs to be enabled too.</em>',
 	'ACP_INVITE_CAPTCHA'								=> 'Visual confirmation',
diff --git "[ORIGINAL]/leinad4mind\\invitation/language/en/info_ucp_invite.php" "[FORUM_EXT]/leinad4mind\\invitation/language/en/info_ucp_invite.php"
--- "[ORIGINAL]/leinad4mind\\invitation/language/en/info_ucp_invite.php"
+++ "[FORUM_EXT]/leinad4mind\\invitation/language/en/info_ucp_invite.php"
@@ -39,6 +39,10 @@ $lang = array_merge($lang, array(
 
 	'UCP_CAT_INVITE'						=> 'phpBB Invite',
 	'UCP_INVITE'							=> 'Invitation',
+	'UCP_INVITE_LABEL'						=> 'GoldTugAnime - Invitation',
+	'UCP_INVITE_MESSAGE'					=> 'Welcome to the most beautiful Portuguese (Portugal) Animation Community!
+
+We hope you have fun and that animation never stops being part of your life.',
 	'UCP_INVITE_DATA'						=> 'Invitation details',
 	'UCP_INVITE_BACK'						=> '<br /><br />%sBack to the user control panel%s',
 	'UCP_INVITE_DAYF'						=> 'Invitations sent today',
@@ -92,9 +96,11 @@ $lang = array_merge($lang, array(
 	'UCP_INVITE_REQUEST_SUBMIT'				=> 'Send request',
 	'UCP_INVITE_REQUEST_SUCC'				=> 'The invitation request has been successfully sent!',
 	'UCP_INVITE_REQUEST_SUCCS'				=> 'The invitation requests have been successfully sent!',
-	'UCP_INVITE_REQUEST_TITLE'				=> 'Required invitations',
-	'UCP_INVITE_REQUEST_TITLE_EXPLAIN'		=> 'Enter the number of invitations you want to request. There is a maximum of <b>(%s)</b> invitation(s) available.<br />You take full responsibility for your invited user(s) if they behave inappropriately.',
+	'UCP_INVITE_REQUEST_TITLE'				=> 'Request invitations',
+	'UCP_INVITE_REQUEST_TITLE_EXPLAIN'		=> 'Enter the number of invitations you want to request. There is a maximum of <b>(%s)</b> invitation(s) available.',
+	'UCP_INVITE_REQUEST_COST'				=> '<div class="invitation_tred alert alert-danger">Invitation price is <b>50.000 points</b>.</div>',
 	'UCP_INVITE_SEND'						=> 'Send invitation',
+	'UCP_INVITE_SEND_EXPLAIN'			=> '<div class="invitation_tred alert alert-danger">You take some responsibility for your invited user(s) if they behave inappropriately.</div>',
 	'UCP_INVITE_SEND_EMAIL_MAX'				=> 'Maximum %s e-mail addresses can be used. However you listed %s!',
 	'UCP_INVITE_SEND_MAX'					=> '<span class="invitation_tred">Currently there is no limit!</span>',
 	'UCP_INVITE_LAST_ACTIVE'				=> 'Last active',
diff --git "[ORIGINAL]/leinad4mind\\invitation/language/en/invite.php" "[FORUM_EXT]/leinad4mind\\invitation/language/en/invite.php"
--- "[ORIGINAL]/leinad4mind\\invitation/language/en/invite.php"
+++ "[FORUM_EXT]/leinad4mind\\invitation/language/en/invite.php"
@@ -36,6 +36,7 @@ if (empty($lang) || !is_array($lang))
 
 $lang = array_merge($lang, array(
 	'INVITE'								=> 'Invite',
+	'INVITE_INFO'								=> 'Invite Information',
 	'INVITE_DELETE_CONFIRM'					=> 'If you want to delete the invitation, click %sHERE%s.',
 	'INVITE_DELETE_SUCCESS'					=> 'Your invitation was successfully deleted.',
 	'INVITE_DELETE_SUCCESSES'				=> 'Your invitations were successfully deleted.',
diff --git "[ORIGINAL]/leinad4mind\\invitation/language/en/permissions_invite.php" "[FORUM_EXT]/leinad4mind\\invitation/language/en/permissions_invite.php"
--- "[ORIGINAL]/leinad4mind\\invitation/language/en/permissions_invite.php"
+++ "[FORUM_EXT]/leinad4mind\\invitation/language/en/permissions_invite.php"
@@ -38,14 +38,14 @@ $lang = array_merge($lang, array(
 	'ACL_A_INVITE'			=> 'User can synchronize data',
 	'ACL_A_INVITE_CONFIG'	=> 'User can change invitation settings.',
 	'ACL_A_INVITE_DELETE'	=> 'User can delete invitations',
-	'ACL_A_INVITE_SIZE'		=> 'User can manage invitations',
+	'ACL_A_INVITE_CLAIMING'		=> 'User can manage invitations',
 	'ACL_A_INVITE_SEND'		=> 'User can allocate invitations to members',
 	'ACL_A_INVITE_PEND'		=> 'User can manage pending invitations',
 	'ACL_A_INVITE_USERS'	=> 'User can see a list of invited members',
-	'ACL_M_INVITE_SIZE'		=> 'User can approve invitation application.',
+	'ACL_M_INVITE_CLAIMING'		=> 'User can approve invitation application.',
 	'ACL_U_INVITE_DELETE'	=> 'User can revoke invitation<br /><em>User can cancel an invitation he has sent.</em>',
 	'ACL_U_INVITE_REQUEST'	=> 'User can request invitation',
-	'ACL_U_INVITE_SEND'		=> 'User can invite new members to the site',
+	'ACL_U_INVITE_SENDING'		=> 'User can invite new members to the site',
 	'ACL_U_INVITE_MAX'		=> 'User has unlimited invitations',
 	'ACL_U_INVITE_USERS'	=> 'User can view the list of users invited by others.',
 ));
diff --git "[ORIGINAL]/leinad4mind\\invitation/language/fr/permissions_invite.php" "[FORUM_EXT]/leinad4mind\\invitation/language/fr/permissions_invite.php"
--- "[ORIGINAL]/leinad4mind\\invitation/language/fr/permissions_invite.php"
+++ "[FORUM_EXT]/leinad4mind\\invitation/language/fr/permissions_invite.php"
@@ -38,14 +38,14 @@ $lang = array_merge($lang, array(
 	'ACL_A_INVITE'			=> 'Peut synchroniser les données',
 	'ACL_A_INVITE_CONFIG'	=> 'Peut changer les paramètres d’invitation',
 	'ACL_A_INVITE_DELETE'	=> 'Peut supprimer des invitations',
-	'ACL_A_INVITE_SIZE'		=> 'Peut gérer les invitations',
+	'ACL_A_INVITE_CLAIMING'		=> 'Peut gérer les invitations',
 	'ACL_A_INVITE_SEND'		=> 'Peut allouer des invitations à des membres',
 	'ACL_A_INVITE_PEND'		=> 'Peut gérer les invitations en attente',
 	'ACL_A_INVITE_USERS'	=> 'Peut voir les listes de membres invités',
-	'ACL_M_INVITE_SIZE'		=> 'Peut approuver une demande d’invitation',
+	'ACL_M_INVITE_CLAIMING'		=> 'Peut approuver une demande d’invitation',
 	'ACL_U_INVITE_DELETE'	=> 'Peut annuler une invitation qu’il a envoyée',
 	'ACL_U_INVITE_REQUEST'	=> 'Peut demander une invitation',
-	'ACL_U_INVITE_SEND'		=> 'Peut inviter des nouveaux membres sur le site',
+	'ACL_U_INVITE_SENDING'		=> 'Peut inviter des nouveaux membres sur le site',
 	'ACL_U_INVITE_MAX'		=> 'Peut disposer d’un nombre illimité d’invitations',
 	'ACL_U_INVITE_USERS'	=> 'Peut voir la liste des membres invités par les autres',
 ));
diff --git "[ORIGINAL]/leinad4mind\\invitation/language/hu/permissions_invite.php" "[FORUM_EXT]/leinad4mind\\invitation/language/hu/permissions_invite.php"
--- "[ORIGINAL]/leinad4mind\\invitation/language/hu/permissions_invite.php"
+++ "[FORUM_EXT]/leinad4mind\\invitation/language/hu/permissions_invite.php"
@@ -38,14 +38,14 @@ $lang = array_merge($lang, array(
 	'ACL_A_INVITE'			=> 'Szinkronizálhatja az adatokat',
 	'ACL_A_INVITE_CONFIG'	=> 'Módosíthatja a beállításokat',
 	'ACL_A_INVITE_DELETE'	=> 'Törölheti a felhasználók meghívóját',
-	'ACL_A_INVITE_SIZE'		=> 'Kezelheti a meghívó kérelmeket',
+	'ACL_A_INVITE_CLAIMING'		=> 'Kezelheti a meghívó kérelmeket',
 	'ACL_A_INVITE_SEND'		=> 'Kiutalhat meghívókat',
 	'ACL_A_INVITE_PEND'		=> 'Kezelheti a függőben lévő meghívókat',
 	'ACL_A_INVITE_USERS'	=> 'Láthatja a meghívott személyek listáját',
-	'ACL_M_INVITE_SIZE'		=> 'Jóváhagyhat meghívó iránti kérelmet',
+	'ACL_M_INVITE_CLAIMING'		=> 'Jóváhagyhat meghívó iránti kérelmet',
 	'ACL_U_INVITE_DELETE'	=> 'Törölheti a már kiküldött meghívót<br /><em>Ha rossz címre küldi netán a meghívót akkor esélye van azt törölni.</em>',
 	'ACL_U_INVITE_REQUEST'	=> 'Igényelhet meghívót',
-	'ACL_U_INVITE_SEND'		=> 'Meghívhat új tagot az pagera',
+	'ACL_U_INVITE_SENDING'		=> 'Meghívhat új tagot az pagera',
 	'ACL_U_INVITE_MAX'		=> 'Korlátlan meghívóval rendelkezzen',
 	'ACL_U_INVITE_USERS'	=> 'Megtekintheti a mások által meghívott felhasználók listáját.',
 ));
diff --git "[ORIGINAL]/leinad4mind\\invitation/language/nl/permissions_invite.php" "[FORUM_EXT]/leinad4mind\\invitation/language/nl/permissions_invite.php"
--- "[ORIGINAL]/leinad4mind\\invitation/language/nl/permissions_invite.php"
+++ "[FORUM_EXT]/leinad4mind\\invitation/language/nl/permissions_invite.php"
@@ -38,14 +38,14 @@ $lang = array_merge($lang, array(
 	'ACL_A_INVITE'			=> 'Gebruiker kan data synchroniseren',
 	'ACL_A_INVITE_CONFIG'	=> 'Gebuiker kan uitnodigings instellingen veranderen.',
 	'ACL_A_INVITE_DELETE'	=> 'Gebruiker kan uitnodigingen verwijderen',
-	'ACL_A_INVITE_SIZE'		=> 'Gebruiker kan uitnodigingen beheren',
+	'ACL_A_INVITE_CLAIMING'		=> 'Gebruiker kan uitnodigingen beheren',
 	'ACL_A_INVITE_SEND'		=> 'Gebruiker kan uitnodigingen toewijzen aan leden',
 	'ACL_A_INVITE_PEND'		=> 'Gebruiker kan wachtende uitnodigingen beheren',
 	'ACL_A_INVITE_USERS'	=> 'Gebruiker kan een lijst van uitgenodigde leden zien',
-	'ACL_M_INVITE_SIZE'		=> 'Gebruiker kan een aanvraag van een uitnodiging accepteren.',
+	'ACL_M_INVITE_CLAIMING'		=> 'Gebruiker kan een aanvraag van een uitnodiging accepteren.',
 	'ACL_U_INVITE_DELETE'	=> 'Gebruiker kan een uitnodiging intrekken<br /><em>Gebruiker kan een uitnodiging die hij heeft gestuurd annuleren.</em>',
 	'ACL_U_INVITE_REQUEST'	=> 'Gebruiker kan een uitnodiging aanvragen',
-	'ACL_U_INVITE_SEND'		=> 'Gebruiker kan leden uitnodigen naar de site',
+	'ACL_U_INVITE_SENDING'		=> 'Gebruiker kan leden uitnodigen naar de site',
 	'ACL_U_INVITE_MAX'		=> 'Gebruiker heeft ongelimiteerd uitnodigingen',
 	'ACL_U_INVITE_USERS'	=> 'Gebruiker kan de lijst met uitnodigingen door andere bekijken.',
 ));
diff --git "[ORIGINAL]/leinad4mind\\invitation/language/pt_pt/common.php" "[FORUM_EXT]/leinad4mind\\invitation/language/pt/common.php"
similarity index 100%
rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/language/pt_pt/common.php"
rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt/common.php"
diff --git "[ORIGINAL]/leinad4mind\\invitation/language/pt_pt/email/user_invite.txt" "[FORUM_EXT]/leinad4mind\\invitation/language/pt/email/user_invite.txt"
similarity index 100%
rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/language/pt_pt/email/user_invite.txt"
rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt/email/user_invite.txt"
diff --git "[ORIGINAL]/leinad4mind\\invitation/language/pt_pt/email/user_invite_request.txt" "[FORUM_EXT]/leinad4mind\\invitation/language/pt/email/user_invite_request.txt"
similarity index 100%
rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/language/pt_pt/email/user_invite_request.txt"
rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt/email/user_invite_request.txt"
diff --git "[ORIGINAL]/leinad4mind\\invitation/language/pt_pt/email/user_invites.txt" "[FORUM_EXT]/leinad4mind\\invitation/language/pt/email/user_invites.txt"
similarity index 100%
rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/language/pt_pt/email/user_invites.txt"
rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt/email/user_invites.txt"
diff --git "[FORUM_EXT]/leinad4mind\\invitation/language/pt/info_acp_invite.php" "[FORUM_EXT]/leinad4mind\\invitation/language/pt/info_acp_invite.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/leinad4mind\\invitation/language/pt/info_acp_invite.php"
@@ -0,0 +1,229 @@
+<?php
+
+/**
+ *
+ * Invite. An extension for the phpBB Forum Software package.
+ * Brazilian Portuguese translation by eunaumtenhoid [2019][ver 4.2.0] (https://github.com/phpBBTraducoes)
+ * @copyright (c) 2010-2015, KillBill
+ * @copyright (c) 2017, kasimi
+ * @copyright (c) 2017-2022, Leinad4Mind, https://leinad4mind.top/forum
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
+// Some characters you may want to copy&paste: ’ « » „ “ ” …
+
+$lang = array_merge($lang, array(
+	'ACC_INVITE_DISABLE'								=> 'Convite desativado',
+	'ACC_INVITE_ENABLE'									=> 'Apenas com convite',
+	'ACC_INVITE_REGISTER'								=> 'Convite + Registo',
+	'ACP_CAT_INVITE'									=> 'phpBB Invite',
+	'ACP_INVITE_REGISTER'								=> 'Criando ID por convite',
+	'ACP_INVITE_REGISTER_EXPLAIN'						=> 'definir opções de registo, pode ser usado como um único recurso, se necessário.<br />Desativar registo substitui todas as opções!',
+	'ACP_INVITE'										=> 'Convite',
+	'ACP_INVITED_PEND_COUNT'							=> 'Todos Convites (%s)',
+	'ACP_INVITED_USERS_COUNT'							=> 'Todos os utilizadores (%s)',
+	'ACP_INVITE_ALL_USER_INVITE_MAX'					=> 'Convite ilimitado para todos',
+	'ACP_INVITE_ALL_USER_INVITE_MAX_EXPLAIN'			=> 'Se sim, todos os utilizadores terão convites ilimitados.',
+	'ACP_INVITE_RESTORE_INVITES'						=> 'Restaurar convites expirados e recusados',
+	'ACP_INVITE_RESTORE_INVITES_EXPLAIN'				=> 'Caso um convite expire ou seja recusado deverá o convite ser novamente disponibilizado ao utilizador.',
+	'ACP_INVITE_BIRTHDAYS'								=> 'Aniversário',
+	'ACP_INVITE_BIRTHDAYS_EXPLAIN'						=> 'Podes definir quantos convites um utilizador receberá no seu aniversário. <em>Para que essa configuração tenha efeito, o recurso de aniversário também precisa ser activado.</em>',
+	'ACP_INVITE_CAPTCHA'								=> 'Confirmação visual',
+	'ACP_INVITE_CAPTCHA_EXPLAIN'						=> 'Os utilizadores devem inserir um código aleatório de uma imagem.',
+	'ACP_INVITE_CONFIG'									=> 'Configurações',
+	'ACP_INVITE_CONFIG_EXPLAIN'							=> 'Aqui poderás configurar a extensão de convite.',
+	'ACP_INVITE_CONFIG_GIFT'							=> 'Configurações de presente',
+	'ACP_INVITE_CONFIG_GROUP'							=> 'Configurações de grupo',
+	'ACP_INVITE_CONFIG_REQUEST'							=> 'Configurações de solicitações',
+	'ACP_INVITE_DB'										=> 'item',
+	'ACP_INVITE_DEFAULT_GROUP'							=> 'Tornar o grupo padrão',
+	'ACP_INVITE_DEFAULT_GROUP_EXPLAIN'					=> 'O grupo selecionado também será o grupo padrão para utilizadores convidados.<br /><em>Observe que essa configuração substitui a configuração "Definir utilizadores recém-registados como padrão".</em>',
+	'ACP_INVITE_DEFAULT_GROUP_USERS'					=> 'Todos os utilizadores no grupo',
+	'ACP_INVITE_DEFAULT_GROUP_USERS_EXPLAIN'			=> 'Você precisa selecionar no mínimo um grupo. Você precisa selecionar sim ou não para especificar se todos os utilizadores desse grupo seleccionado são afectados ou apenas se os utilizadores são membros do grupo padrão.',
+	'ACP_INVITE_DELETES_PEND_CONFIRM'					=> 'Tens a certeza de que desejas excluir os convites selecionados?<br /><em>Observação: Se confirmares, as pessoas convidadas não poderão mais usar os teus convites!</em>',
+	'ACP_INVITE_DELETE_ALL_PEND_CONFIRM'				=> 'Tens a certeza de que desejas excluir todos os convites?<br /><em>Observação: Se confirmares, os convidados não poderão mais usar o teu convite!</em>',
+	'ACP_INVITE_DELETE_GROUPS_CONFIRM'					=> 'Tens a certeza de que desejas excluir os convites de grupos selecionados?',
+	'ACP_INVITE_DELETE_GROUP_CONFIRM'					=> 'Tens a certeza de que desejas excluir os convites do grupo selecionado?',
+	'ACP_INVITE_DELETE_PEND_CONFIRM'					=> 'Tens a certeza de que desejas excluir o convite selecionado?<br /><em>Observação: Se confirmares, a pessoa convidada não poderá mais usar o convite!</em>',
+	'ACP_INVITE_DELETE_TIME'							=> 'Expirar tempo para excluir convites',
+	'ACP_INVITE_DELETE_TIME_EXPLAIN'					=> 'Podes definir a hora em que um utilizador pode excluir convites enviados para o endereço de e-mail errado.',
+	'ACP_INVITE_DELETE_USERS_CONFIRM'					=> 'Tens a certeza de que desejas excluir os convites dos utilizadores selecionados?',
+	'ACP_INVITE_DELETE_USER_CONFIRM'					=> 'Tens a certeza de que desejas excluir os convites do utilizador selecionado?',
+	'ACP_INVITE_DISABLED'								=> 'O sistema de convite está desativado!',
+	'ACP_INVITE_DENY'									=> 'Rejeitar',
+	'ACP_INVITE_EMAIL_BOARD_DISABLED'					=> '<strong>phpBB Invite:</strong> O envio de e-mails está, de momento, desativado!<br />Enquanto estiver desativado, os convites não devem funcionar. Se quiseres activá-lo, podes fazê-lo %sAQUI%s.',
+	'ACP_INVITE_EMAIL_DISABLED'							=> 'Envio de e-mails foi desativado, por favor, ative-o. %sVá às configurações de e-mail.%s ',
+	'ACP_INVITE_EMAIL_PRIORITY'							=> 'Prioridade do email de convite',
+	'ACP_INVITE_MEMBERSHIP_DAYS'						=> 'Número mínimo de dias de registo',
+	'ACP_INVITE_MEMBERSHIP_DAYS_EXPLAIN'				=> 'Número de dias que um utilizador precisa de ter para poder usar o sistema de convites. Colocar 0 para desativar e permitir uso imediato.',
+	'ACP_INVITE_ENABLE'									=> 'Ativar extensão de convite',
+	'ACP_INVITE_ENABLE_EXPLAIN'							=> 'Se o ativares, a extensão do convite será usada.',
+	'ACP_INVITE_VALIDATION'								=> 'Tempo de expiração dos convites enviados',
+	'ACP_INVITE_VALIDATION_EXPLAIN'						=> 'Podes definir o tempo de expiração dos convites enviados. Após esse período, o ID do convite será excluído, portanto, não é mais possível registá-lo.',
+	'ACP_INVITE_EXPLAIN'								=> 'O valor será adicionado.',
+	'ACP_INVITE_GIFT_NUMBER_INVITES'					=> 'Número de convites presenteado',
+	'ACP_INVITE_GIFT_INVITED_USERS'						=> 'Utilizadores convidados',
+	'ACP_INVITE_GIFT_INVITED_USERS_EXPLAIN'				=> 'Os utilizadores receberão um convite de presente após esse número de utilizadores convidados.<br /><em>Se "0", essa função será desativada.</em>',
+	'ACP_INVITE_POSTS_GIFT_INVITES'						=> 'Convites por Intervalo',
+	'ACP_INVITE_POSTS_GIFT_INVITES_EXPLAIN'				=> 'Número de convites que um utilizador irá receber após atingir o número de x mensagens. Colocar 0 para desativar.',
+	'ACP_INVITE_POSTS_GIFT_POSTS'						=> 'Intervalo de Mensagens',
+	'ACP_INVITE_POSTS_GIFT_POSTS_EXPLAIN'				=> 'O utilizador irá receber a cada x mensagens o número de convites inserido no campo acima. Colocar 0 para desativar.',
+	'ACP_INVITE_POSTS_GIFT_LIMIT'						=> 'Limite do Intervalo',
+	'ACP_INVITE_POSTS_GIFT_LIMIT_EXPLAIN'				=> 'Número máximo de intervalos que um utilizador irá receber convites. Por exemplo, colocar intervalo de 30 mensagens com limite de 3 vezes irá enviar convites quando o utilizador atingir 30, 60 e 90 mensagens. Colocar 0 para desativar.',
+	'ACP_INVITE_GROUP'									=> 'Grupo de utilizadores convidados',
+	'ACP_INVITE_GROUP_ENABLED'							=> 'Ativer o uso de grupo',
+	'ACP_INVITE_GROUP_ENABLED_EXPLAIN'					=> 'If enabled, invited users will automatically be added to the selected group.',
+	'ACP_INVITE_GROUP_EXPLAIN'							=> 'The invited users will be added to the selected group.<br /><em>Note that the pre-defined system groups are not on the list.</em>',
+	'ACP_INVITE_GROUPS_MANAGEMENT'						=> 'Manage Group',
+	'ACP_INVITE_CLAIMING'									=> 'Invitation requests',
+	'ACP_INVITE_CLAIMING_EXPLAIN'							=> 'View / decide about users invitation requests.',
+	'ACP_INVITE_INDEX_TITLE'							=> 'Welcome to phpBB Invite!',
+	'ACP_INVITE_INDEX_TITLE_EXPLAIN'					=> 'Thank you for choosing phpBB Invite. On this page you can see an overview of various statistical data of the invite system. On top of the page and via the links on the left side of the invite you can change every part in detail. On every page you will find a description of the current settings.',
+	'ACP_INVITE_INSTALL'								=> 'Installation date',
+	'ACP_INVITE_HANDLING'								=> 'Manage users/groups',
+	'ACP_INVITE_HANDLING_EXPLAIN'						=> 'Here you can grant or revoke the invitations for users and groups.',
+	'ACP_INVITE_HANDLING_GROUPS_DELETE'					=> 'The invitations of the following group were deleted successfully. <br /><br />(<em><b>%s</b></em>).',
+	'ACP_INVITE_HANDLING_GROUPS_DELETES'				=> 'The invitations of the following groups were deleted successfully. <br /><br />(<em><b>%s</b></em>).',
+	'ACP_INVITE_HANDLING_GROUPS_IG'						=> 'Successfully delivered the invitation to (<em><b>%s</b></em>) group.<br />Sent invitation: (<em><b>%s</b></em>)',
+	'ACP_INVITE_HANDLING_GROUPS_IGS'					=> 'Successfully delivered the invitation to (<em><b>%s</b></em>) groups.<br />Sent invitation: (<em><b>%s</b></em>)',
+	'ACP_INVITE_HANDLING_GROUPS_ISG'					=> 'Successfully delivered the invitations to (<em><b>%s</b></em>) group.<br />Sent invitations: (<em><b>%s</b></em>).',
+	'ACP_INVITE_HANDLING_GROUPS_ISGS'					=> 'Successfully delivered the invitations to (<em><b>%s</b></em>) groups.<br />Sent invitations: (<em><b>%s</b></em>).',
+	'ACP_INVITE_HANDLING_USERS_DELETE'					=> 'The invitations of the following user were deleted successfully<br /><br />(<em><b>%s</b></em>).',
+	'ACP_INVITE_HANDLING_USERS_DELETES'					=> 'The invitations of the following users were deleted successfully<br /><br />(<em><b>%s</b></em>).',
+	'ACP_INVITE_HANDLING_USERS_ISU'						=> 'Successfully delivered the invitations to (<em><b>%s</b></em>) user.<br />Sent invitations: (<em><b>%s</b></em>).',
+	'ACP_INVITE_HANDLING_USERS_ISUS'					=> 'Successfully delivered the invitations to (<em><b>%s</b></em>) users.<br />Sent invitations: (<em><b>%s</b></em>).',
+	'ACP_INVITE_HANDLING_USERS_IU'						=> 'Successfully delivered the invitation to (<em><b>%s</b></em>) user.<br /> Sent invitation: (<em><b>%s</b></em>).',
+	'ACP_INVITE_HANDLING_USERS_IUS'						=> 'Successfully delivered the invitation to (<em><b>%s</b></em>) users.<br />Sent invitation: (<em><b>%s</b></em>).',
+	'ACP_INVITE_HANDLING_USER_I'						=> 'Number of invitation changed successfully for user (<em><b>%s</b></em>).<br />New quantity: (<em><b>%s</b></em>).',
+	'ACP_INVITE_HANDLING_USER_IS'						=> 'Number of invitations changed successfully for user (<em><b>%s</b></em>).<br />New quantity: (<em><b>%s</b></em>).',
+	'ACP_INVITE_ALLOCATE'								=> 'Add',
+	'ACP_INVITE_SEND_DAY_DB'							=> 'Number of invitations to be sent per day',
+	'ACP_INVITE_SEND_DAY_DB_EXPLAIN'					=> 'You can set the maximum number of invites a user can send per day.<br /><em>(0=unlimited.)</em>',
+	'ACP_INVITE_SEND_DB_NUM'							=> 'number of pieces',
+	'ACP_INVITE_MAIL_FIX'								=> 'Allow e-mail address switching',
+	'ACP_INVITE_MAIL_FIX_EXPLAIN'						=> 'It allows to specify a different e-mail address during the registration.',
+	'ACP_INVITE_MAIN'									=> 'Overview',
+	'ACP_INVITE_MAINTENANCE_UPDATE_INVITE'				=> 'The oldest version the phpBB Invite updater supports is <strong>“%s”</strong>. Please update to version <strong>“%s”</strong> before running the update to version <strong>“%s”</strong>.',
+	'ACP_INVITE_MAINTENANCE_UPDATE_PHPBB'				=> 'You need to update phpBB to at least version <strong>“%s”</strong> before updating phpBB Invite to version <strong>“%s”</strong>.',
+	'ACP_INVITE_MAIN_CONFIG'							=> 'Main settings',
+	'ACP_INVITE_MEMBER'									=> '%s Pessoa',
+	'ACP_INVITE_MESSAGE'								=> 'User justification',
+	'ACP_INVITE_MESSAGE_TIME'							=> 'Request time',
+	'ACP_INVITE_MINUS'									=> 'You can’t set a minus value.',
+	'ACP_INVITE_MOD'									=> 'phpBB Invite',
+	'ACP_INVITE_MORE_EMAIL_DB'							=> 'Set recipients limit',
+	'ACP_INVITE_MORE_EMAIL_DB_EXPLAIN'					=> 'You can set the maximum number of invitations that can be sent at a time here.<br /><em>(1=disabled.)</em>',
+	'ACP_INVITE_NEW_MEMBER_POST_LIMIT_IGNORED'			=> 'Ignore new members post limit',
+	'ACP_INVITE_NEW_MEMBER_POST_LIMIT_IGNORED_EXPLAIN'	=> 'If set to yes, accepting an invitation will not get newly registered users into the “Newly registered users” group.',
+	'ACP_INVITE_NEW_REG'								=> 'New registration',
+	'ACP_INVITE_NEW_REG_EXPLAIN'						=> 'Number of invitations given to a new user once registered.',
+	'ACP_INVITE_NO_ANONYMOUS'							=> 'Guest users can not be selected!',
+	'ACP_INVITE_NO_GROUP'								=> 'No accessible group. If you want to create a new group can do it %sHERE%s.',
+	'ACP_INVITE_NO_GROUP_SPECIFIED'						=> 'You didn’t select a group.',
+	'ACP_INVITE_NO_PETITION'							=> 'There is currently no request for invitation!',
+	'ACP_INVITE_NO_MARKED'								=> 'You have not selected a user either!',
+	'ACP_INVITE_NO_PEND_INVITE'							=> 'There are currently no pending invitations.',
+	'ACP_INVITE_NO_SELECT_INVITE'						=> 'You didn’t select an invitation!',
+	'ACP_INVITE_NO_USERS'								=> 'Currently no received invitations!',
+	'ACP_INVITE_NO_VALUE'								=> 'You didn’t set the number of invitations!',
+	'ACP_INVITE_NUMBER_INVITED_USERS'					=> 'Number of invited users',
+	'ACP_INVITE_PENDING'								=> 'Pending invitations',
+	'ACP_INVITE_PENDING_EXPLAIN'						=> 'Here you can view and delete unused invitations sent out.',
+	'ACP_INVITE_PEND_DATE'								=> 'Shipping time',
+	'ACP_INVITE_PEND_DB'								=> 'Outstanding invitations',
+	'ACP_INVITE_PEND_DELETE_ALL_SUCCESSES'				=> 'All pending invitations have been successfully deleted.',
+	'ACP_INVITE_PEND_DELETE_MARKS_SUCCESSES'			=> 'The selected pending invitations have been successfully deleted.',
+	'ACP_INVITE_PEND_DELETE_MARK_SUCCESSES'				=> 'The selected pending invitation has been successfully deleted.',
+	'ACP_INVITE_PEND_EMAIL'								=> 'Recipient e-mail address',
+	'ACP_INVITE_PEND_END_DATE'							=> 'Expiration date',
+	'ACP_INVITE_PETITION_NSUCCESS'						=> 'The rejection was successful.',
+	'ACP_INVITE_PETITION_NSUCCESSES'					=> 'The rejections were successful.',
+	'ACP_INVITE_PETITION_YSUCCESS'						=> 'The allocation has been successfully completed.',
+	'ACP_INVITE_PETITION_YSUCCESSES'					=> 'The allocations have been successfully completed.',
+	'ACP_INVITE_NOTIFICATION_NO_USER'					=> 'The user name for sending notifications does not exist!',
+	'ACP_INVITE_NOTIFICATION_USERNAME'					=> 'Notifications sender name',
+	'ACP_INVITE_NOTIFICATION_USERNAME_EXPLAIN'			=> 'Name of the user who will send the notification.',
+	'ACP_INVITE_POST_LIMIT_DB'							=> 'Total posts',
+	'ACP_INVITE_POST_LIMIT_DB_EXPLAIN'					=> 'This is the post count needed to send out invitations.<br /><em>(0=disabled.)</em>',
+	'ACP_INVITE_REG_EMAIL'								=> 'Registered e-mail',
+	'ACP_INVITE_REQUEST_CAUSE'							=> 'Activation limit',
+	'ACP_INVITE_REQUEST_CAUSE_EXPLAIN'					=> 'When claiming more than this number of invitations, a reason is required to continue.<br /><em>(0=disabled.)</em>',
+	'ACP_INVITE_REQUEST_MAX'							=> 'Maximum number of invitations available',
+	'ACP_INVITE_REQUEST_MAX_EXPLAIN'					=> '<em>(0=disable requests.)</em>',
+	'ACP_INVITE_REQUIRE_AC_DISABLED'					=> 'Registration by invitation is not possible, since it is currently turned off!',
+	'ACP_INVITE_SORT_NAME'								=> 'Invited',
+	'ACP_INVITE_SYNC_DATA'								=> 'Resynchronise total data',
+	'ACP_INVITE_SYNC_DATA_CONFIRM'						=> 'Are you sure you want to resynchronise the invite totals data?',
+	'ACP_INVITE_SYNC_DATA_EXPLAIN'						=> 'The invite total data will be resynchronised, this includes the following: invited users, pending invitations and invitations claimed.',
+	'ACP_INVITE_SYNC_DATA_SUCCESSES'					=> 'The invite total data was successfully resynchronised.',
+	'ACP_INVITE_SYNC_USERS'								=> 'Ressincronize os dados dos utilizadores.',
+	'ACP_INVITE_SYNC_USERS_CONFIRM'						=> 'Tens a certeza de que deseja ressincronizar os dados dos utilizadores convidados?',
+	'ACP_INVITE_SYNC_USERS_EXPLAIN'						=> 'Os dados dos utilizadores convidados serão ressincronizados',
+	'ACP_INVITE_SYNC_USERS_SUCCESSES'					=> 'Os dados dos utilizadores convidados foram ressincronizados com sucesso.',
+	'ACP_INVITE_TOTAL_USERS'							=> 'Número de utilizadores convidados',
+	'ACP_INVITE_TOTAL_USERS_DAY'						=> 'Número de utilizadores convidados por dia',
+	'ACP_INVITE_UG_TASK'								=> 'Selecione uma tarefa',
+	'ACP_INVITE_USERS'									=> 'Utilizadores que convidaram',
+	'ACP_INVITE_USERS_COUNT'							=> 'Solicitações totais (%s)',
+	'ACP_INVITE_USERS_EXPLAIN'							=> 'Aqui podes ver a lista de utilizadores que já convidaram um novo membro para o site.',
+	'ACP_INVITE_USERS_MANAGEMENT'						=> 'Gerir utilizadores selecionados',
+	'ACP_INVITE_USERS_NO_GROUP'							=> 'Não há utilizador no grupo selecionado.',
+	'ACP_INVITE_USERS_NO_GROUPS'						=> 'Não há utilizador nos grupos selecionados.',
+	'ACP_INVITE_USER_EXPLAIN'							=> 'O valor mudará a quantidade de convites do utilizador.',
+	'ACP_INVITE_USER_LIST'								=> 'Número de utilizadores por página',
+	'ACP_INVITE_USER_LIST_EXPLAIN'						=> 'Este valor define o número de utilizadores listados em uma página.',
+	'ACP_INVITE_USER_MANAGEMENT'						=> 'Uma gestão de utilizadores',
+	'ACP_INVITE_USER_MANAGEMENT_EXPLAIN'				=> 'Aqui podes alterar a quantidade de convites do utilizador.',
+	'ACP_INVITE_USER_NAME'								=> 'nome',
+
+	'LOG_INVITE_CONFIG'							=> '<strong>Configuração de convite modificada.</strong>',
+	'LOG_INVITE_DELETE'							=> '<strong>Convite Revogado.</strong><br />» Endereço de e-mail: %s',
+	'LOG_INVITE_SIZE_DELETE'					=> '<strong>Convite Recusado</strong><br />» Utilizador: %s',
+	'LOG_INVITE_INSTALL'						=> '<strong>phpBB Invite instalado</strong><br />» Versão: %s',
+	'LOG_INVITE_HANDLING_GROUPS_DELETE'			=> '<strong>Convites apagados de um grupo.</strong><br />» <b>Grupo:</b> (<em>%s</em>).',
+	'LOG_INVITE_HANDLING_GROUPS_DELETES'		=> '<strong>Convites apagados de grupos.</strong><br />» <b>Grupos:</b> (<em>%s</em>).',
+	'LOG_INVITE_HANDLING_GROUPS_IG'				=> '<strong>Convite adicionado para um grupo.</strong><br />» <b>Grupo:</b> (<em>%s</em>)<br />» Convite adicionado: (%s).',
+	'LOG_INVITE_HANDLING_GROUPS_IGS'			=> '<strong>Convite adicionado para grupos.</strong><br />» <b>Grupos:</b> (<em>%s</em>)<br />» Convite adicionado: (%s).',
+	'LOG_INVITE_HANDLING_GROUPS_ISG'			=> '<strong>Convites adicionados para um grupo.</strong><br />» <b>Grupo:</b> (<em>%s</em>)<br />» Convites adicionados: (%s).',
+	'LOG_INVITE_HANDLING_GROUPS_ISGS'			=> '<strong>Convites adicionados para grupos.</strong><br />» <b>Grupos:</b> (<em>%s</em>)<br />» Convites adicionados: (%s)',
+	'LOG_INVITE_HANDLING_USERS_DELETE'			=> '<strong>Convites apagados de um utilizador.</strong><br />» <b>Utilizador:</b> (<em>%s</em>).',
+	'LOG_INVITE_HANDLING_USERS_DELETES'			=> '<strong>Convites apagados de utilizadores.</strong><br />» <b>Utilizadores:</b> (<em>%s</em>).',
+	'LOG_INVITE_HANDLING_USERS_ISU'				=> '<strong>Convite adicionado para um utilizador.</strong><br />» <b>Utilizador:</b> (<em>%s</em>)<br />» Convites adicionados: (%s).',
+	'LOG_INVITE_HANDLING_USERS_ISUS'			=> '<strong>Convites adicionados para utilizadores.</strong><br />» <b>Utilizadores:</b> (<em>%s</em>)<br />» Convites adicionados: (%s).',
+	'LOG_INVITE_HANDLING_USERS_IU'				=> '<strong>Convite adicionado para um utilizador.</strong><br />» <b>Utilizador:</b> (<em>%s</em>)<br />» Convites adicionados: (%s).',
+	'LOG_INVITE_HANDLING_USERS_IUS'				=> '<strong>Convites adicionados para utilizadores.</strong><br />» <b>Utilizadores:</b> (<em>%s</em>)<br />» Convites adicionados: (%s).',
+	'LOG_INVITE_HANDLING_USER_I'				=> '<strong>Mudou a quantidade de convites.</strong><br />» <b>Utilizador:</b> (<em>%s</em>)<br />» Nova quantidade: (%s) convite.',
+	'LOG_INVITE_HANDLING_USER_IS'				=> '<strong>Mudou a quantidade de convites.</strong><br />» <b>Utilizador:</b> (<em>%s</em>)<br />» Nova quantidade: (%s) convites.',
+	'LOG_INVITE_ALLOCATE'						=> '<strong>Convites adicionados para o utilizador %s.</strong><br />» Convites adicionados: %s.',
+
+	'LOG_INVITE_SEND_INVITATION'				=> '<strong>Convite enviado.</strong><br />» %s',
+	'LOG_INVITE_SEND_INVITATIONS'				=> '<strong>Convites enviados.</strong><br />» %s',
+
+	'LOG_INVITE_PEND_ALL_DELETE'				=> '<strong>Excluiu todos os convites pendentes.</strong>',
+	'LOG_INVITE_PEND_MARKED_DELETE'			=> '<strong>Excluído convite pendente selecionado.</strong><br />» Utilizador: %s',
+	'LOG_INVITE_PEND_MARKED_DELETES'			=> '<strong>Excluídos convites pendentes selecionados.</strong><br />» Utilizadores: %s',
+	'LOG_INVITE_SYNC_DATA'						=> '<strong>Ressincronização de dados de convite.</strong>',
+	'LOG_INVITE_SYNC_USERS'						=> '<strong>Ressincronização de dados de convite do utilizador.</strong>',
+));
diff --git "[ORIGINAL]/leinad4mind\\invitation/language/pt_pt/info_mcp_invite.php" "[FORUM_EXT]/leinad4mind\\invitation/language/pt/info_mcp_invite.php"
similarity index 100%
rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/language/pt_pt/info_mcp_invite.php"
rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt/info_mcp_invite.php"
diff --git "[ORIGINAL]/leinad4mind\\invitation/language/pt_pt/info_ucp_invite.php" "[FORUM_EXT]/leinad4mind\\invitation/language/pt/info_ucp_invite.php"
similarity index 90%
rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/language/pt_pt/info_ucp_invite.php"
rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt/info_ucp_invite.php"
--- "[ORIGINAL]/leinad4mind\\invitation/language/pt_pt/info_ucp_invite.php"
+++ "[FORUM_EXT]/leinad4mind\\invitation/language/pt/info_ucp_invite.php"
@@ -39,6 +39,10 @@ $lang = array_merge($lang, array(
 
 	'UCP_CAT_INVITE'						=> 'phpBB Invite',
 	'UCP_INVITE'							=> 'Convites',
+	'UCP_INVITE_LABEL'						=> 'GoldTugAnime - Convite',
+	'UCP_INVITE_MESSAGE'					=> 'Bem-vindo à mais bela Comunidade de Animação em Português de Portugal!
+
+Esperamos que te divirtas e que a animação nunca deixe de fazer parte da tua vida.',
 	'UCP_INVITE_DATA'						=> 'Detalhes de convites',
 	'UCP_INVITE_BACK'						=> '<br /><br />%sVoltar para o painel de controlo do utilizador%s',
 	'UCP_INVITE_DAYF'						=> 'Convites enviados hoje',
@@ -82,7 +86,7 @@ $lang = array_merge($lang, array(
 	'UCP_INVITE_REQUEST_BUY_SUBT_EXPLAIN'	=> 'Digita o número de convites que desejas comprar. O preço do convite é <b>%s %s</b>.<br />Assumes a responsabilidade pelo(s) teu(s) utilizador(es) convidado(s) se o(s) utilizador(es) convidado(s) causar(em) incidentes inapropriados.',
 	'UCP_INVITE_REQUEST_BUY_SUCCESS'		=> 'A compra do convite foi bem-sucedida.',
 	'UCP_INVITE_REQUEST_BUY_TITLE'			=> 'Comprar convite.',
-	'UCP_INVITE_REQUEST_DISABLED'			=> 'As solicitacões de convites estão desactivadas!',
+	'UCP_INVITE_REQUEST_DISABLED'			=> 'As solicitações de convites estão desactivadas!',
 	'UCP_INVITE_REQUEST_MAX'				=> 'Número máximo de pedidos: (%s) convite(s)!',
 	'UCP_INVITE_REQUEST_MESSAGE_NO_DB'		=> '<em>Não! Não houve necessidade.</em>',
 	'UCP_INVITE_REQUEST_MIN'				=> 'Número mínimo de convites solicitados: (1)',
@@ -92,9 +96,11 @@ $lang = array_merge($lang, array(
 	'UCP_INVITE_REQUEST_SUBMIT'				=> 'Enviar pedido',
 	'UCP_INVITE_REQUEST_SUCC'				=> 'A solicitação de convite foi enviada com sucesso!',
 	'UCP_INVITE_REQUEST_SUCCS'				=> 'A solicitação de convites foram enviadas com sucesso!',
-	'UCP_INVITE_REQUEST_TITLE'				=> 'Convites requisitados',
-	'UCP_INVITE_REQUEST_TITLE_EXPLAIN'		=> 'Digita o número de convites que desejas solicitar. Há um máximo de <b>(%s)</b> convites disponíveis.<br />Assumes total responsabilidade pelo(s) teu(s) utilizador(es) convidado(s) se eles se comportarem de maneira inapropriada.',
+	'UCP_INVITE_REQUEST_TITLE'				=> 'Requisitar convites',
+	'UCP_INVITE_REQUEST_TITLE_EXPLAIN'		=> 'Digita o número de convites que desejas solicitar. Há um máximo de <b>(%s)</b> convites disponíveis.',
+	'UCP_INVITE_REQUEST_COST'				=> '<div class="invitation_tred alert alert-danger">O preço por convite é de <b>50.000 pontos</b>.</div>',
 	'UCP_INVITE_SEND'						=> 'Enviar convite',
+	'UCP_INVITE_SEND_EXPLAIN'			=> '<div class="invitation_tred alert alert-danger">Assumes parte da responsabilidade dos utilizadores que convidares caso eles se comportarem de maneira inapropriada.</div>',
 	'UCP_INVITE_SEND_EMAIL_MAX'				=> 'Máximo de %s endereços de e-mail podem ser usados. No entanto, listaste %s!', 
 	'UCP_INVITE_SEND_MAX'					=> '<span class="invitation_tred">Actualmente não há limite!</span>',
 	'UCP_INVITE_LAST_ACTIVE'				=> 'Última visita',
@@ -108,6 +114,7 @@ $lang = array_merge($lang, array(
 	'UCP_INVITE_NO_LOGIN'					=> 'Ele/ela não se registou neste site.',
 	'UCP_INVITE_NO_PERM'					=> 'Não está autorizado a enviar convites!',
 	'UCP_INVITE_NO_PERM_EMAIL'				=> 'Não está autorizado a enviar e-mail!',
+	'UCP_INVITE_MEMBERSHIP_DAYS'			=> 'A tua conta tem de ter pelo menos %1$d dias antes que possas fazer uso do sistema de convites. Poderás utilizar a partir de %2$s.',
 	'UCP_INVITE_NO_REG'						=> 'Ninguém foi convidado por ti.',
 	'UCP_INVITE_NULL'						=> 'Não tem convites! <em>Porque não comprar alguns?</em>', 
 	'UCP_INVITE_POINTS_AMOUNT'				=> 'Presente',
diff --git "[FORUM_EXT]/leinad4mind\\invitation/language/pt/install_invite.php" "[FORUM_EXT]/leinad4mind\\invitation/language/pt/install_invite.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/leinad4mind\\invitation/language/pt/install_invite.php"
@@ -0,0 +1,156 @@
+<?php
+
+/**
+ *
+ * Invite. An extension for the phpBB Forum Software package.
+ *
+ * @copyright (c) 2010-2015, KillBill
+ * @copyright (c) 2017, kasimi
+ * @copyright (c) 2017-2022, Leinad4Mind, https://leinad4mind.top/forum
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
+// Some characters you may want to copy&paste: ’ « » „ “ ” …
+
+$lang = array_merge($lang, array(
+	'AUTH_CACHE_PURGE'						=> 'Clear permission cache',
+
+	'CACHE_PURGE'							=> 'Clear forum cache',
+	'CAT_INSTALL'							=> 'Install',
+	'CAT_OVERVIEW'							=> 'Overview',
+	'CAT_UNINSTALL'							=> 'Uninstall',
+	'CAT_UPDATE'							=> 'Update',
+	'CAT_VERIFY'							=> 'Verify',
+
+	'GPL'									=> 'General Public License',
+
+	'INCOMPLETE_FILES_UPLOAD'				=> 'All Invite files have not been uploaded! Please make sure to upload all files before running the installer.',
+	'INCOMPLETE_FILE_EDITS'					=> 'Editing of this file has not been done yet. The installation can not run unless all files are edited correctly!',
+	'INCOMPLETE_LANG_ROWS'					=> 'Some changes to the language files are missing. Please apply them as described %sHERE%s.',
+	'INSTALLATION'							=> 'phpBB Invite install',
+	'INSTALLATION_EXPLAIN'					=> '<br />phpBB Invite database install.<br /><br />',
+	'INSTALL_BODY'							=> 'Here you can see that the mod is well established and has been properly installed.',
+	'INSTALL_ERR_AUTH'						=> 'You are not authorized to use this script.<br /><br />Please note to use the script the following requirements must be met. First you must be logged in to the site and second you must have the user type founder. If you are logged in and are the founder then you have incorrect cookie settings in the ACP. Please check the cookie domain setting. If your site URL is <strong>http://www.example.com</strong> then the cookie domain should be <strong>.example.com</strong>.',
+	'INSTALL_FOLDER'						=> '<strong>Please delete the install folder. Until you have done this, only the ACP will be available.</strong>',
+	'INSTALL_LOGIN'							=> 'Proceed to ACP',
+
+	'INVITE_CONFIG_ADD'						=> 'Adding new invite config variable: %s',
+	'INVITE_CONFIG_ALREADY_EXISTS'			=> 'ERROR: Invite config variable %s already exists.',
+	'INVITE_CONFIG_NOT_EXIST'				=> 'ERROR: Invite config variable %s does not exist.',
+	'INVITE_CONFIG_REMOVE'					=> 'Removing Invite config variable: %s',
+	'INVITE_CONFIG_UPDATE'					=> 'Updating Invite config variable: %s',
+
+	'INVITE_INSTALL_INTRO'					=> 'Welcome to phpBB Invite Installation',
+	'INVITE_INSTALL_INTRO_BODY'				=> 'With this option, it is possible to install phpBB Invite to your database.',
+
+	'INVITE_VERSION'						=> 'The installed phpBB Invite version is <b>%s</b>, this file can be used to update version <b>%s</b> to version <b>%s</b>. <br /> You first need to upgrade to version <b>%s</b> to run this update script!',
+
+	'NOT_INSTALL_DIR'						=> 'Cannot open the install folder!',
+	'NOT_LANGUAGE_DIR'						=> 'The language library is not available!',
+	'NOT_LANGUAGE_DIR_DIR'					=> 'The %s language directory cannot be found!',
+	'NOT_MODULE'							=> 'The installation modules are not available!',
+	'NOT_MODULE_OPEN'						=> '%s Module is not available!',
+	'NO_TABLE_DATA'							=> '<span style="color:#FF0000;">Error:</span> The table data is missing.',
+
+	'OVERVIEW_BODY'							=> 'Welcome!<br /><br />The installation system presents a complete guide how to install the mod, or remove and update it.<br />Continue with the selection menu... Select the appropriate option from the menu.',
+
+	'PARENT_NOT_EXIST'						=> '<span style="color:#FF0000;">Error:</span> The parent category which shows the new module does not exist.',
+	'PERMISSIONS_WARNING'					=> 'New permission settings have been added.  Check your permission settings and make sure that they are as you would like them.',
+	'PHPBB_INVITE_DONATE'					=> 'Please make a small donation to appreciate the hard work and many hours used to make the “phpBB Invite”.',
+	'PHPBB_INVITE_DONATE_TITLE'				=> 'phpBB Invite donation',
+	'PHPBB_VERSION'							=> 'Your phpBB version is <b>%s</b>, the phpBB Invite mod requires version <b>%s</b> to run!',
+	'PHP_VERSION_RUN'						=> 'The current PHP version is not supported, please update your PHP to version 4.3.3 or later before you run the installation.</b>',
+
+	'ROLE_NOT_EXIST'						=> '<span style="color:#FF0000;">Error:</span> this role is not in the database.',
+
+	'STAGE_INSTALL'							=> 'Install',
+	'STAGE_INTRO'							=> 'Intro',
+	'STAGE_UNINSTALL'						=> 'Delete the database',
+	'STAGE_VERIFY'							=> 'Verify',
+	'STAGE_VERIFY_FILE_EXPLAIN'				=> '<br />The mod files are successfully deleted.',
+	'SUB_INTRO'								=> 'Intro',
+	'SUB_LICENSE'							=> 'License',
+	'SUB_SUPPORT'							=> 'Support',
+	'SUCCESSES'								=> '<span style="color:#000;"><b>Successfully completed!</b></span>',
+	'SUPPORT_BODY'							=> 'Full support will be provided for the current release and development versions, all for free.<br />This includes:</p><ul><li>information</li><li>configuration</li><li>update older versions to the newest version</li></ul><p>I encourage everyone who is using an older version to upgrade to the new version.</p><h2>Support forums</h2><br /><p><a href="http://jatek-vilag.com/viewtopic.php?p=204#p204" onclick="window.open(this.href); return false;">The main development site</a><br /><a href="https://www.phpbb.com/community/viewtopic.php?p=12855248#p12855248" onclick="window.open(this.href); return false;">phpBB.com Development topic</a><br /><a href="http://phpbb.hu/forum/hsz/40666#hsz-40666" onclick="window.open(this.href); return false;">phpBB.hu Development topic</a><br /><br />',
+
+	'UNINSTALL_BODY'						=> 'Here you can see that the mod database entries have been successfully removed.<br /><br /><b>Please delete the install folder. Until you have done this, only the ACP will be available.</b>',
+	'UNINSTALL_INTRO'						=> 'phpBB Invite delete',
+	'UNINSTALL_INTRO_BODY'					=> 'Under this option, you can delete the phpBB Invite from the database.',
+	'UNINSTALL_TITLE'						=> 'phpBB Invite deleted from the database',
+	'UPDATE_BODY'							=> 'Here you can see that database data created by this mod has been properly updated.<br /><br /><b>Please delete the install folder. Until you have done this, only the ACP will be available.</b>',
+	'UPDATE_INSTALLATION'					=> 'phpBB Invite update',
+	'UPDATE_INSTALLATION_EXPLAIN'			=> '<br />phpBB Invite update on the newest version.<br />',
+	'UPDATE_TITLE'							=> 'Updating database data',
+
+	'VERIFY_ERROR_EXPLAIN'					=> 'The check found an error.',
+	'VERIFY_ERROR_FILE'						=> 'Bad file modification',
+	'VERIFY_ERROR_FILE_EXPLAIN'				=> 'Here you can see those files which have been incorrectly edited or has been omitted.',
+	'VERIFY_EXITS_PRINT_MYAD'				=> '<br />The SQL command you see here you can install by yourself, if you load it in phpMyAdmin.',
+	'VERIFY_EXITS_PRINT_SQL'				=> '<b><span style="color:#FF0000;">%s</span> <span style="color:#000;">not found!</span></b><br />%s<br />',
+	'VERIFY_INVITE_MOD_CONFIG'				=> 'phpBB Invite configuration',
+	'VERIFY_INVITE_MOD_CONFIG_OK'			=> '<span style="color:#228822;"><strong>All phpBB Invite config found.</strong></span>',
+	'VERIFY_INVITE_MOD_FILES'				=> 'phpBB Invite files',
+	'VERIFY_INVITE_MOD_FILES_OK'			=> '<span style="color:#228822;"><strong>All files found.</strong></span>',
+	'VERIFY_INVITE_MOD_MODULES'				=> 'phpBB Invite modules',
+	'VERIFY_INVITE_MOD_MODULES_OK'			=> '<span style="color:#228822;"><strong>All modules found.</strong></span>',
+	'VERIFY_INVITE_MOD_PERM'				=> 'phpBB Invite permissions',
+	'VERIFY_INVITE_MOD_PERM_OK'				=> '<span style="color:#228822;"><strong>All permissions found.</strong></span>',
+	'VERIFY_INVITE_MOD_TABLES'				=> 'phpBB Invite tables',
+	'VERIFY_INVITE_MOD_TABLES_OK'			=> '<span style="color:#228822;"><strong>All tables found.</strong></span>',
+	'VERIFY_NOT_AC_FOUND'					=> '<b><span style="color:#FF0000;">%s</span> <span style="color:#000;">not found!</span></b>',
+	'VERIFY_NOT_COLUMN'						=> 'Missing columns',
+	'VERIFY_NOT_COLUMN_EXPLAIN'				=> 'Here you can see all the columns which were not installed.',
+	'VERIFY_NOT_CONFIG'						=> 'Missing config',
+	'VERIFY_NOT_CONFIG_EXPLAIN'				=> 'Here you can see the config files which have not been installed.',
+	'VERIFY_NOT_FILE'						=> 'Missing files',
+	'VERIFY_NOT_FILE_EXPLAIN'				=> 'Here you can see the files that have not been uploaded correctly or have been uploaded correctly but to the wrong place.',
+	'VERIFY_NOT_INVITE_CONFIG'				=> 'Missing phpBB Invite config',
+	'VERIFY_NOT_INVITE_CONFIG_EXPLAIN'		=> 'Here you can see the phpBB Invite config files which have not been installed.',
+	'VERIFY_NOT_MODULE'						=> 'Missing modules',
+	'VERIFY_NOT_MODULE_EXPLAIN'				=> 'Here you can see the modules which have not been installed.',
+	'VERIFY_NOT_PERMIS'						=> 'Missing permissions',
+	'VERIFY_NOT_PERMIS_EXPLAIN'				=> 'Here you can see the permissions that were not installed.',
+	'VERIFY_NOT_TABLE'						=> 'Missing table',
+	'VERIFY_NOT_TABLE_EXPLAIN'				=> 'Here you can see the signs which have not been installed.',
+	'VERIFY_NO_COLUMN'						=> '<b><span style="color:#FF0000;">%s</span> <span style="color:#000;">column not found!</span></b><br />%s<br />',
+	'VERIFY_NO_MODULE'						=> '<b><span style="color:#FF0000;">%s</span> <span style="color:#000;">module is not found in the database!</span></b>',
+	'VERIFY_NO_PERMIS'						=> '<b><span style="color:#FF0000;">%s</span> <span style="color:#000;">permission is not found in the database!</span></b>',
+	'VERIFY_NO_TABLE'						=> '<b><span style="color:#FF0000;">%s</span> <span style="color:#000;">table is not found in the database!</span></b>%s',
+	'VERIFY_PHPBB_MOD_COLUMNS'				=> 'phpBB users table new columns',
+	'VERIFY_PHPBB_MOD_COLUMNS_OK'			=> '<span style="color:#228822;"><strong>All columns found.</strong></span>',
+	'VERIFY_PHPBB_MOD_CONFIG'				=> 'phpBB new config',
+	'VERIFY_PHPBB_MOD_CONFIG_OK'			=> '<span style="color:#228822;"><strong>phpBB config found.</strong></span>',
+	'VERIFY_PHPBB_MOD_FILES'				=> 'phpBB file edits',
+	'VERIFY_PHPBB_MOD_FILES_OK'				=> '<span style="color:#228822;"><strong>All files are edited.</strong></span>',
+	'VERIFY_SUCCESSES_EXPLAIN'				=> 'The check found everything okay.',
+	'VERIFY_TITLE'							=> 'phpBB Invite control',
+	'VERIFY_TITLE_ELL'						=> 'Control error',
+	'VERIFY_TITLE_ELL_EXPLAIN'				=> '<span style="color:#000;"><b>Here you can see all occurred errors to fix everything carefully!</b></span>',
+	'VERIFY_TITLE_EXPLAIN'					=> '<br />Here you can check whether all required file changes, configuration changes and database entries have been made successfully.',
+	'VERIFY_NEW'							=> 'Check again',
+	'VERIFY_UNINSTALL_ERROR_FILE'			=> 'Existing files',
+	'VERIFY_UNINSTALL_ERROR_FILE_EXPLAIN'	=> 'Here you can see the files which have not been removed.',
+));
diff --git "[ORIGINAL]/leinad4mind\\invitation/language/pt_pt/invite.php" "[FORUM_EXT]/leinad4mind\\invitation/language/pt/invite.php"
similarity index 97%
rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/language/pt_pt/invite.php"
rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt/invite.php"
--- "[ORIGINAL]/leinad4mind\\invitation/language/pt_pt/invite.php"
+++ "[FORUM_EXT]/leinad4mind\\invitation/language/pt/invite.php"
@@ -36,6 +36,7 @@ if (empty($lang) || !is_array($lang))
 
 $lang = array_merge($lang, array(
 	'INVITE'								=> 'Convites',
+	'INVITE_INFO'								=> 'Informação sobre Convites',
 	'INVITE_DELETE_CONFIRM'					=> 'Se quiseres apagar o convite, clica %sAQUI%s.',
 	'INVITE_DELETE_SUCCESS'					=> 'O teu convite foi apagados com sucesso.',
 	'INVITE_DELETE_SUCCESSES'				=> 'Os teus convites foram apagados com sucesso.',
diff --git "[ORIGINAL]/leinad4mind\\invitation/language/pt_pt/permissions_invite.php" "[FORUM_EXT]/leinad4mind\\invitation/language/pt/permissions_invite.php"
similarity index 96%
rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/language/pt_pt/permissions_invite.php"
rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt/permissions_invite.php"
--- "[ORIGINAL]/leinad4mind\\invitation/language/pt_pt/permissions_invite.php"
+++ "[FORUM_EXT]/leinad4mind\\invitation/language/pt/permissions_invite.php"
@@ -45,7 +45,7 @@ $lang = array_merge($lang, array(
 	'ACL_M_INVITE_CLAIMING'	=> 'O utilizador pode aprovar um pedido de convite.',
 	'ACL_U_INVITE_DELETE'	=> 'O utilizador pode revogar convites<br /><em>O utilizador pode cancelar um convite que ele enviou.</em>',
 	'ACL_U_INVITE_REQUEST'	=> 'O utilizador pode solicitar convite',
-	'ACL_U_INVITE_SEND'		=> 'O utilizador pode convidar novos membros para o site',
+	'ACL_U_INVITE_SENDING'		=> 'O utilizador pode convidar novos membros para o site',
 	'ACL_U_INVITE_MAX'		=> 'O utilizador tem convites ilimitados',
 	'ACL_U_INVITE_USERS'	=> 'O utilizador pode visualizar a lista de utilizadores convidados por outras pessoas.',
 ));
diff --git "[ORIGINAL]/leinad4mind\\invitation/language/pt_br/info_acp_invite.php" "[FORUM_EXT]/leinad4mind\\invitation/language/pt_br/info_acp_invite.php"
--- "[ORIGINAL]/leinad4mind\\invitation/language/pt_br/info_acp_invite.php"
+++ "[FORUM_EXT]/leinad4mind\\invitation/language/pt_br/info_acp_invite.php"
@@ -70,10 +70,12 @@ $lang = array_merge($lang, array(
 	'ACP_INVITE_DELETE_USERS_CONFIRM'					=> 'Tem certeza de que deseja excluir os convites dos usuários selecionados?',
 	'ACP_INVITE_DELETE_USER_CONFIRM'					=> 'Tem certeza de que deseja excluir os convites do usuário selecionado?',
 	'ACP_INVITE_DISABLED'								=> 'O sistema de convite está desativado!',
-	'ACP_INVITE_DENY'									=> 'Rejeição',
+	'ACP_INVITE_DENY'									=> 'Rejeitar',
 	'ACP_INVITE_EMAIL_BOARD_DISABLED'					=> '<strong>phpBB Invite:</strong> O envio de e-mails está desativado no momento!<br />Enquanto estiver desativado, os convites não devem funcionar. Se você quiser ativa-lo, você pode fazê-lo %sAQUI%s.',
 	'ACP_INVITE_EMAIL_DISABLED'							=> 'Envio de e-mails foi desativado, por favor, ative-o. %sVá às configurações de e-mail.%s ',
 	'ACP_INVITE_EMAIL_PRIORITY'							=> 'Prioridade do email de convite',
+	'ACP_INVITE_MEMBERSHIP_DAYS'						=> 'Número mínimo de dias de registo',
+	'ACP_INVITE_MEMBERSHIP_DAYS_EXPLAIN'				=> 'Número de dias que um usuário precisa ter para poder usar o sistema de convites. Colocar 0 para desativar e permitir uso imediato.',
 	'ACP_INVITE_ENABLE'									=> 'Ativar extensão de convite',
 	'ACP_INVITE_ENABLE_EXPLAIN'							=> 'Se você ativá-lo, a extensão do convite será usada.',
 	'ACP_INVITE_VALIDATION'								=> 'Tempo de expiração dos convites enviados',
@@ -82,6 +84,12 @@ $lang = array_merge($lang, array(
 	'ACP_INVITE_GIFT_NUMBER_INVITES'					=> 'Número de convites presenteado',
 	'ACP_INVITE_GIFT_INVITED_USERS'						=> 'Usuários convidados',
 	'ACP_INVITE_GIFT_INVITED_USERS_EXPLAIN'				=> 'Os usuários receberão um convite de presente após esse número de usuários convidados.<br /><em>Se "0", essa função será desativada.</em>',
+	'ACP_INVITE_POSTS_GIFT_INVITES'						=> 'Convites por Intervalo',
+	'ACP_INVITE_POSTS_GIFT_INVITES_EXPLAIN'				=> 'Número de convites que um usuário irá receber após atingir o número de x mensagens. Colocar 0 para desativar.',
+	'ACP_INVITE_POSTS_GIFT_POSTS'						=> 'Intervalo de Mensagens',
+	'ACP_INVITE_POSTS_GIFT_POSTS_EXPLAIN'				=> 'O usuário irá receber a cada x mensagens o número de convites inserido no campo acima. Colocar 0 para desativar.',
+	'ACP_INVITE_POSTS_GIFT_LIMIT'						=> 'Limite do Intervalo',
+	'ACP_INVITE_POSTS_GIFT_LIMIT_EXPLAIN'				=> 'Número máximo de intervalos que um usuário irá receber convites. Por exemplo, colocar intervalo de 30 mensagens com limite de 3 vezes irá enviar convites quando o usuário atingir 30, 60 e 90 mensagens. Colocar 0 para desativar.',
 	'ACP_INVITE_GROUP'									=> 'Grupo de usuários convidados',
 	'ACP_INVITE_GROUP_ENABLED'							=> 'Ativar o uso de grupo',
 	'ACP_INVITE_GROUP_ENABLED_EXPLAIN'					=> 'If enabled, invited users will automatically be added to the selected group.',
diff --git "[ORIGINAL]/leinad4mind\\invitation/language/pt_br/info_ucp_invite.php" "[FORUM_EXT]/leinad4mind\\invitation/language/pt_br/info_ucp_invite.php"
--- "[ORIGINAL]/leinad4mind\\invitation/language/pt_br/info_ucp_invite.php"
+++ "[FORUM_EXT]/leinad4mind\\invitation/language/pt_br/info_ucp_invite.php"
@@ -39,6 +39,10 @@ $lang = array_merge($lang, array(
 
 	'UCP_CAT_INVITE'						=> 'phpBB Invite',
 	'UCP_INVITE'							=> 'Convites',
+	'UCP_INVITE_LABEL'						=> 'GoldTugAnime - Convite',
+	'UCP_INVITE_MESSAGE'					=> 'Bem-vindo à mais bela Comunidade de Animação em Português de Portugal!
+
+Esperamos que se divirta e que a animação nunca deixe de fazer parte da sua vida.',
 	'UCP_INVITE_DATA'						=> 'Detalhes de convites',
 	'UCP_INVITE_BACK'						=> '<br /><br />%sVoltar para o painel de controle do usuário%s',
 	'UCP_INVITE_DAYF'						=> 'Convites enviados hoje',
@@ -82,7 +86,7 @@ $lang = array_merge($lang, array(
 	'UCP_INVITE_REQUEST_BUY_SUBT_EXPLAIN'	=> 'Digite o número de convites que você deseja comprar. O preço do convite é <b>%s %s</b>.<br />Você assume a responsabilidade por seu(s) usuário(s) convidado(s) se o(s) usuário(s) convidado(s) causar incidentes inapropriados.',	
 	'UCP_INVITE_REQUEST_BUY_SUCCESS'		=> 'A compra do convite foi bem-sucedida.',
 	'UCP_INVITE_REQUEST_BUY_TITLE'			=> 'Comprar convite.',
-	'UCP_INVITE_REQUEST_DISABLED'			=> 'As solicitacões de convites estão desativadas!',
+	'UCP_INVITE_REQUEST_DISABLED'			=> 'As solicitações de convites estão desativadas!',
 	'UCP_INVITE_REQUEST_MAX'				=> 'Número máximo de pedidos: (%s) convite(s)!',
 	'UCP_INVITE_REQUEST_MESSAGE_NO_DB'		=> '<em>Não! Não houve necessidade.</em>',
 	'UCP_INVITE_REQUEST_MIN'				=> 'Número mínimo de convites solicitados: (1)',
@@ -92,9 +96,11 @@ $lang = array_merge($lang, array(
 	'UCP_INVITE_REQUEST_SUBMIT'				=> 'Enviar pedido',
 	'UCP_INVITE_REQUEST_SUCC'				=> 'A solicitação de convite foi enviada com sucesso!',
 	'UCP_INVITE_REQUEST_SUCCS'				=> 'A solicitação de convites foram enviadas com sucesso!',
-	'UCP_INVITE_REQUEST_TITLE'				=> 'Convites requisitados',
-	'UCP_INVITE_REQUEST_TITLE_EXPLAIN'		=> 'Digite o número de convites que você deseja solicitar. Há um máximo de <b>(%s)</b> convites disponíveis.<br />Você assume total responsabilidade por seu(s) usuário(s) convidado(s) se eles se comportarem de maneira inapropriada.',
+	'UCP_INVITE_REQUEST_TITLE'				=> 'Requisitar convites',
+	'UCP_INVITE_REQUEST_TITLE_EXPLAIN'		=> 'Digite o número de convites que você deseja solicitar. Há um máximo de <b>(%s)</b> convites disponíveis.',
+	'UCP_INVITE_REQUEST_COST'				=> '<div class="invitation_tred alert alert-danger">O preço por convite é de <b>50.000 pontos</b>.</div>',
 	'UCP_INVITE_SEND'						=> 'Enviar convite',
+	'UCP_INVITE_SEND_EXPLAIN'			=> '<div class="invitation_tred alert alert-danger">Você assume parte da responsabilidade dos usuários convidados caso eles se comportarem de maneira inapropriada.</div>',
 	'UCP_INVITE_SEND_EMAIL_MAX'				=> 'Máximo de %s endereços de e-mail podem ser usados. No entanto, você listou %s!', 
 	'UCP_INVITE_SEND_MAX'					=> '<span class="invitation_tred">Atualmente não há limite!</span>',
 	'UCP_INVITE_LAST_ACTIVE'				=> 'Última visita',
@@ -108,6 +114,7 @@ $lang = array_merge($lang, array(
 	'UCP_INVITE_NO_LOGIN'					=> 'Ele/ela não se registrou neste site.',
 	'UCP_INVITE_NO_PERM'					=> 'Você não está autorizado a enviar convites!',
 	'UCP_INVITE_NO_PERM_EMAIL'				=> 'Você não está autorizado a enviar e-mail!',
+	'UCP_INVITE_MEMBERSHIP_DAYS'			=> 'A sua conta tem de ter pelo menos %1$d dias antes que possa fazer uso do sistema de convite. Poderá utilizar a partir de %2$s.',
 	'UCP_INVITE_NO_REG'						=> 'Ninguém foi convidado por você.',
 	'UCP_INVITE_NULL'						=> 'Você não tem convites!  <em>Porque não comprar alguns?</em>', 
 	'UCP_INVITE_POINTS_AMOUNT'				=> 'Presente',
diff --git "[FORUM_EXT]/leinad4mind\\invitation/language/pt_br/install_invite.php" "[FORUM_EXT]/leinad4mind\\invitation/language/pt_br/install_invite.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/leinad4mind\\invitation/language/pt_br/install_invite.php"
@@ -0,0 +1,156 @@
+<?php
+
+/**
+ *
+ * Invite. An extension for the phpBB Forum Software package.
+ *
+ * @copyright (c) 2010-2015, KillBill
+ * @copyright (c) 2017, kasimi
+ * @copyright (c) 2017-2022, Leinad4Mind, https://leinad4mind.top/forum
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
+// Some characters you may want to copy&paste: ’ « » „ “ ” …
+
+$lang = array_merge($lang, array(
+	'AUTH_CACHE_PURGE'						=> 'Clear permission cache',
+
+	'CACHE_PURGE'							=> 'Clear forum cache',
+	'CAT_INSTALL'							=> 'Install',
+	'CAT_OVERVIEW'							=> 'Overview',
+	'CAT_UNINSTALL'							=> 'Uninstall',
+	'CAT_UPDATE'							=> 'Update',
+	'CAT_VERIFY'							=> 'Verify',
+
+	'GPL'									=> 'General Public License',
+
+	'INCOMPLETE_FILES_UPLOAD'				=> 'All Invite files have not been uploaded! Please make sure to upload all files before running the installer.',
+	'INCOMPLETE_FILE_EDITS'					=> 'Editing of this file has not been done yet. The installation can not run unless all files are edited correctly!',
+	'INCOMPLETE_LANG_ROWS'					=> 'Some changes to the language files are missing. Please apply them as described %sHERE%s.',
+	'INSTALLATION'							=> 'phpBB Invite install',
+	'INSTALLATION_EXPLAIN'					=> '<br />phpBB Invite database install.<br /><br />',
+	'INSTALL_BODY'							=> 'Here you can see that the mod is well established and has been properly installed.',
+	'INSTALL_ERR_AUTH'						=> 'You are not authorized to use this script.<br /><br />Please note to use the script the following requirements must be met. First you must be logged in to the site and second you must have the user type founder. If you are logged in and are the founder then you have incorrect cookie settings in the ACP. Please check the cookie domain setting. If your site URL is <strong>http://www.example.com</strong> then the cookie domain should be <strong>.example.com</strong>.',
+	'INSTALL_FOLDER'						=> '<strong>Please delete the install folder. Until you have done this, only the ACP will be available.</strong>',
+	'INSTALL_LOGIN'							=> 'Proceed to ACP',
+
+	'INVITE_CONFIG_ADD'						=> 'Adding new invite config variable: %s',
+	'INVITE_CONFIG_ALREADY_EXISTS'			=> 'ERROR: Invite config variable %s already exists.',
+	'INVITE_CONFIG_NOT_EXIST'				=> 'ERROR: Invite config variable %s does not exist.',
+	'INVITE_CONFIG_REMOVE'					=> 'Removing Invite config variable: %s',
+	'INVITE_CONFIG_UPDATE'					=> 'Updating Invite config variable: %s',
+
+	'INVITE_INSTALL_INTRO'					=> 'Welcome to phpBB Invite Installation',
+	'INVITE_INSTALL_INTRO_BODY'				=> 'With this option, it is possible to install phpBB Invite to your database.',
+
+	'INVITE_VERSION'						=> 'The installed phpBB Invite version is <b>%s</b>, this file can be used to update version <b>%s</b> to version <b>%s</b>. <br /> You first need to upgrade to version <b>%s</b> to run this update script!',
+
+	'NOT_INSTALL_DIR'						=> 'Cannot open the install folder!',
+	'NOT_LANGUAGE_DIR'						=> 'The language library is not available!',
+	'NOT_LANGUAGE_DIR_DIR'					=> 'The %s language directory cannot be found!',
+	'NOT_MODULE'							=> 'The installation modules are not available!',
+	'NOT_MODULE_OPEN'						=> '%s Module is not available!',
+	'NO_TABLE_DATA'							=> '<span style="color:#FF0000;">Error:</span> The table data is missing.',
+
+	'OVERVIEW_BODY'							=> 'Welcome!<br /><br />The installation system presents a complete guide how to install the mod, or remove and update it.<br />Continue with the selection menu... Select the appropriate option from the menu.',
+
+	'PARENT_NOT_EXIST'						=> '<span style="color:#FF0000;">Error:</span> The parent category which shows the new module does not exist.',
+	'PERMISSIONS_WARNING'					=> 'New permission settings have been added.  Check your permission settings and make sure that they are as you would like them.',
+	'PHPBB_INVITE_DONATE'					=> 'Please make a small donation to appreciate the hard work and many hours used to make the “phpBB Invite”.',
+	'PHPBB_INVITE_DONATE_TITLE'				=> 'phpBB Invite donation',
+	'PHPBB_VERSION'							=> 'Your phpBB version is <b>%s</b>, the phpBB Invite mod requires version <b>%s</b> to run!',
+	'PHP_VERSION_RUN'						=> 'The current PHP version is not supported, please update your PHP to version 4.3.3 or later before you run the installation.</b>',
+
+	'ROLE_NOT_EXIST'						=> '<span style="color:#FF0000;">Error:</span> this role is not in the database.',
+
+	'STAGE_INSTALL'							=> 'Install',
+	'STAGE_INTRO'							=> 'Intro',
+	'STAGE_UNINSTALL'						=> 'Delete the database',
+	'STAGE_VERIFY'							=> 'Verify',
+	'STAGE_VERIFY_FILE_EXPLAIN'				=> '<br />The mod files are successfully deleted.',
+	'SUB_INTRO'								=> 'Intro',
+	'SUB_LICENSE'							=> 'License',
+	'SUB_SUPPORT'							=> 'Support',
+	'SUCCESSES'								=> '<span style="color:#000;"><b>Successfully completed!</b></span>',
+	'SUPPORT_BODY'							=> 'Full support will be provided for the current release and development versions, all for free.<br />This includes:</p><ul><li>information</li><li>configuration</li><li>update older versions to the newest version</li></ul><p>I encourage everyone who is using an older version to upgrade to the new version.</p><h2>Support forums</h2><br /><p><a href="http://jatek-vilag.com/viewtopic.php?p=204#p204" onclick="window.open(this.href); return false;">The main development site</a><br /><a href="https://www.phpbb.com/community/viewtopic.php?p=12855248#p12855248" onclick="window.open(this.href); return false;">phpBB.com Development topic</a><br /><a href="http://phpbb.hu/forum/hsz/40666#hsz-40666" onclick="window.open(this.href); return false;">phpBB.hu Development topic</a><br /><br />',
+
+	'UNINSTALL_BODY'						=> 'Here you can see that the mod database entries have been successfully removed.<br /><br /><b>Please delete the install folder. Until you have done this, only the ACP will be available.</b>',
+	'UNINSTALL_INTRO'						=> 'phpBB Invite delete',
+	'UNINSTALL_INTRO_BODY'					=> 'Under this option, you can delete the phpBB Invite from the database.',
+	'UNINSTALL_TITLE'						=> 'phpBB Invite deleted from the database',
+	'UPDATE_BODY'							=> 'Here you can see that database data created by this mod has been properly updated.<br /><br /><b>Please delete the install folder. Until you have done this, only the ACP will be available.</b>',
+	'UPDATE_INSTALLATION'					=> 'phpBB Invite update',
+	'UPDATE_INSTALLATION_EXPLAIN'			=> '<br />phpBB Invite update on the newest version.<br />',
+	'UPDATE_TITLE'							=> 'Updating database data',
+
+	'VERIFY_ERROR_EXPLAIN'					=> 'The check found an error.',
+	'VERIFY_ERROR_FILE'						=> 'Bad file modification',
+	'VERIFY_ERROR_FILE_EXPLAIN'				=> 'Here you can see those files which have been incorrectly edited or has been omitted.',
+	'VERIFY_EXITS_PRINT_MYAD'				=> '<br />The SQL command you see here you can install by yourself, if you load it in phpMyAdmin.',
+	'VERIFY_EXITS_PRINT_SQL'				=> '<b><span style="color:#FF0000;">%s</span> <span style="color:#000;">not found!</span></b><br />%s<br />',
+	'VERIFY_INVITE_MOD_CONFIG'				=> 'phpBB Invite configuration',
+	'VERIFY_INVITE_MOD_CONFIG_OK'			=> '<span style="color:#228822;"><strong>All phpBB Invite config found.</strong></span>',
+	'VERIFY_INVITE_MOD_FILES'				=> 'phpBB Invite files',
+	'VERIFY_INVITE_MOD_FILES_OK'			=> '<span style="color:#228822;"><strong>All files found.</strong></span>',
+	'VERIFY_INVITE_MOD_MODULES'				=> 'phpBB Invite modules',
+	'VERIFY_INVITE_MOD_MODULES_OK'			=> '<span style="color:#228822;"><strong>All modules found.</strong></span>',
+	'VERIFY_INVITE_MOD_PERM'				=> 'phpBB Invite permissions',
+	'VERIFY_INVITE_MOD_PERM_OK'				=> '<span style="color:#228822;"><strong>All permissions found.</strong></span>',
+	'VERIFY_INVITE_MOD_TABLES'				=> 'phpBB Invite tables',
+	'VERIFY_INVITE_MOD_TABLES_OK'			=> '<span style="color:#228822;"><strong>All tables found.</strong></span>',
+	'VERIFY_NOT_AC_FOUND'					=> '<b><span style="color:#FF0000;">%s</span> <span style="color:#000;">not found!</span></b>',
+	'VERIFY_NOT_COLUMN'						=> 'Missing columns',
+	'VERIFY_NOT_COLUMN_EXPLAIN'				=> 'Here you can see all the columns which were not installed.',
+	'VERIFY_NOT_CONFIG'						=> 'Missing config',
+	'VERIFY_NOT_CONFIG_EXPLAIN'				=> 'Here you can see the config files which have not been installed.',
+	'VERIFY_NOT_FILE'						=> 'Missing files',
+	'VERIFY_NOT_FILE_EXPLAIN'				=> 'Here you can see the files that have not been uploaded correctly or have been uploaded correctly but to the wrong place.',
+	'VERIFY_NOT_INVITE_CONFIG'				=> 'Missing phpBB Invite config',
+	'VERIFY_NOT_INVITE_CONFIG_EXPLAIN'		=> 'Here you can see the phpBB Invite config files which have not been installed.',
+	'VERIFY_NOT_MODULE'						=> 'Missing modules',
+	'VERIFY_NOT_MODULE_EXPLAIN'				=> 'Here you can see the modules which have not been installed.',
+	'VERIFY_NOT_PERMIS'						=> 'Missing permissions',
+	'VERIFY_NOT_PERMIS_EXPLAIN'				=> 'Here you can see the permissions that were not installed.',
+	'VERIFY_NOT_TABLE'						=> 'Missing table',
+	'VERIFY_NOT_TABLE_EXPLAIN'				=> 'Here you can see the signs which have not been installed.',
+	'VERIFY_NO_COLUMN'						=> '<b><span style="color:#FF0000;">%s</span> <span style="color:#000;">column not found!</span></b><br />%s<br />',
+	'VERIFY_NO_MODULE'						=> '<b><span style="color:#FF0000;">%s</span> <span style="color:#000;">module is not found in the database!</span></b>',
+	'VERIFY_NO_PERMIS'						=> '<b><span style="color:#FF0000;">%s</span> <span style="color:#000;">permission is not found in the database!</span></b>',
+	'VERIFY_NO_TABLE'						=> '<b><span style="color:#FF0000;">%s</span> <span style="color:#000;">table is not found in the database!</span></b>%s',
+	'VERIFY_PHPBB_MOD_COLUMNS'				=> 'phpBB users table new columns',
+	'VERIFY_PHPBB_MOD_COLUMNS_OK'			=> '<span style="color:#228822;"><strong>All columns found.</strong></span>',
+	'VERIFY_PHPBB_MOD_CONFIG'				=> 'phpBB new config',
+	'VERIFY_PHPBB_MOD_CONFIG_OK'			=> '<span style="color:#228822;"><strong>phpBB config found.</strong></span>',
+	'VERIFY_PHPBB_MOD_FILES'				=> 'phpBB file edits',
+	'VERIFY_PHPBB_MOD_FILES_OK'				=> '<span style="color:#228822;"><strong>All files are edited.</strong></span>',
+	'VERIFY_SUCCESSES_EXPLAIN'				=> 'The check found everything okay.',
+	'VERIFY_TITLE'							=> 'phpBB Invite control',
+	'VERIFY_TITLE_ELL'						=> 'Control error',
+	'VERIFY_TITLE_ELL_EXPLAIN'				=> '<span style="color:#000;"><b>Here you can see all occurred errors to fix everything carefully!</b></span>',
+	'VERIFY_TITLE_EXPLAIN'					=> '<br />Here you can check whether all required file changes, configuration changes and database entries have been made successfully.',
+	'VERIFY_NEW'							=> 'Check again',
+	'VERIFY_UNINSTALL_ERROR_FILE'			=> 'Existing files',
+	'VERIFY_UNINSTALL_ERROR_FILE_EXPLAIN'	=> 'Here you can see the files which have not been removed.',
+));
diff --git "[ORIGINAL]/leinad4mind\\invitation/language/pt_br/permissions_invite.php" "[FORUM_EXT]/leinad4mind\\invitation/language/pt_br/permissions_invite.php"
--- "[ORIGINAL]/leinad4mind\\invitation/language/pt_br/permissions_invite.php"
+++ "[FORUM_EXT]/leinad4mind\\invitation/language/pt_br/permissions_invite.php"
@@ -45,7 +45,7 @@ $lang = array_merge($lang, array(
 	'ACL_M_INVITE_CLAIMING'	=> 'O usuário pode aprovar um pedido de convite.',
 	'ACL_U_INVITE_DELETE'	=> 'O usuário pode revogar convite<br /><em>O usuário pode cancelar um convite que ele enviou.</em>',
 	'ACL_U_INVITE_REQUEST'	=> 'O usuário pode solicitar convite',
-	'ACL_U_INVITE_SEND'		=> 'O usuário pode convidar novos membros para o site',
+	'ACL_U_INVITE_SENDING'		=> 'O usuário pode convidar novos membros para o site',
 	'ACL_U_INVITE_MAX'		=> 'O usuário tem convites ilimitados',
 	'ACL_U_INVITE_USERS'	=> 'O usuário pode visualizar a lista de usuários convidados por outras pessoas.',
 ));
diff --git "[FORUM_EXT]/leinad4mind\\invitation/language/pt_preao/common.php" "[FORUM_EXT]/leinad4mind\\invitation/language/pt_preao/common.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/leinad4mind\\invitation/language/pt_preao/common.php"
@@ -0,0 +1,52 @@
+<?php
+
+/**
+ *
+ * Invite. An extension for the phpBB Forum Software package.
+ * Brazilian Portuguese translation by eunaumtenhoid [2019][ver 4.2.0] (https://github.com/phpBBTraducoes)
+ * @copyright (c) 2010-2015, KillBill
+ * @copyright (c) 2017, kasimi
+ * @copyright (c) 2017-2022, Leinad4Mind, https://leinad4mind.top/forum
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
+// Some characters you may want to copy&paste: ’ « » „ “ ” …
+
+$lang = array_merge($lang, array(
+	'INVITE_BIRTHDAY'						=> 'Parabéns! Recebeste %s convite(s) para o teu aniversário.<br /><br />Desejamos-te um feliz aniversário!', 
+
+	'INVITE_GIFT_INVITED_USERS_FIRST'		=> 'Olá, esta é uma mensagem que se recebe por convidar o utilizador %s para o site “%s”, por isso estamos muito gratos. Queremos que continues a usar o sistema de convite, para que recebas %s convites adicionais.<br /><br />Desejamos-te um momento agradável.',
+	
+	'INVITE_GIFT_INVITED_USERS_FURTHER'		=> 'Olá, esta é uma mensagem que se recebe por convidar mais %s utilizadores para o site “%s”, por isso estamos muito gratos. Queremos que continues a usar o sistema de convite, para que recebas %s convites adicionais.<br /><br />Desejamos-te um momento agradável.',
+
+	'INVITE_PETITION_TITLE'					=> 'Solicitação de convite',
+	'INVITE_PETITIONS_NO'					=> 'A tua solicitação não foi aprovada, portanto, os convites não te serão creditados!',
+	'INVITE_PETITION_NO'					=> 'A tua solicitação não foi aprovada, então o convite não te será creditado!',
+	'INVITE_PETITION_YES'					=> 'A tua solicitação foi aprovada, %s convite(s) creditado(s)!', 
+
+	'INVITE_PETITION_REQUEST'				=> 'O utilizador %s está a solicitar %d convite(s)', 
+
+	'INVITE_JOIN'							=> 'Obrigado por convidares o utilizador %s',
+));
diff --git "[FORUM_EXT]/leinad4mind\\invitation/language/pt_preao/email/user_invite.txt" "[FORUM_EXT]/leinad4mind\\invitation/language/pt_preao/email/user_invite.txt"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/leinad4mind\\invitation/language/pt_preao/email/user_invite.txt"
@@ -0,0 +1,21 @@
+O utilizador {USERNAME} convidou-te para te registares no site "{SITENAME}".
+Podes clicar no link abaixo para criares conta.
+
+{U_ACTIVATE}
+
+A data de expiração deste convite é ({INVITE_TIME_END}). Quando o período de expiração terminar o teu convite ficará inválido!
+
+Se quiseres recusar este convite, simplesmente ignora este e-mail ou clica no link abaixo para excluí-lo:
+{U_DEACTIVATE}
+
+Mensagem de {USERNAME}:
+~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
+{MESSAGE}
+~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
+Se a mensagem acima te for ofensiva ou contiver comentários ofensivos, entra em contacto com o administrador do site no
+seguinte endereço de e-mail: {BOARD_CONTACT}
+Anexa esta mensagem ao e-mail (certifica-te de incluir o cabeçalho do e-mail).
+O endereço de retorno deste e-mail está definido para o endereço de e-mail de {USERNAME}, para que eles recebam a tua resposta.
+--------------------------------------
+
+Link do site: {U_BOARD}
\ No newline at end of file
diff --git "[FORUM_EXT]/leinad4mind\\invitation/language/pt_preao/email/user_invite_request.txt" "[FORUM_EXT]/leinad4mind\\invitation/language/pt_preao/email/user_invite_request.txt"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/leinad4mind\\invitation/language/pt_preao/email/user_invite_request.txt"
@@ -0,0 +1,7 @@
+Recebeste uma solicitação de convites adicionais do utilizador {USERNAME}.
+Ele solicitou {INVITE_NUMBER} convite(s).
+
+~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
+
+Link do site: {U_BOARD}
+Contacto: {BOARD_CONTACT}
\ No newline at end of file
diff --git "[FORUM_EXT]/leinad4mind\\invitation/language/pt_preao/email/user_invites.txt" "[FORUM_EXT]/leinad4mind\\invitation/language/pt_preao/email/user_invites.txt"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/leinad4mind\\invitation/language/pt_preao/email/user_invites.txt"
@@ -0,0 +1,21 @@
+O utilizador {USERNAME} convidou-te para te registares no site "{SITENAME}".
+Podes clicar nos links abaixo para criares conta.
+
+{U_ACTIVATE}
+
+A data de expiração destes convites é ({INVITE_TIME_END}). Quando o período de expiração terminar os teus convites ficarão inválidos!
+
+Se quiseres recusar estes convites, simplesmente ignora este e-mail ou clica no link abaixo para excluí-los:
+{U_DEACTIVATE}
+
+Mensagem de {USERNAME}:
+~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
+{MESSAGE}
+~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
+Se a mensagem acima te for ofensiva ou contiver comentários ofensivos, entra em contacto com o administrador do site no
+seguinte endereço de e-mail: {BOARD_CONTACT}
+Anexa esta mensagem ao e-mail (certifica-te de incluir o cabeçalho do e-mail).
+O endereço de retorno deste e-mail está definido para o endereço de e-mail de {USERNAME}, para que eles recebam a tua resposta.
+--------------------------------------
+
+Link do site: {U_BOARD}
\ No newline at end of file
diff --git "[ORIGINAL]/leinad4mind\\invitation/language/pt_pt/info_acp_invite.php" "[FORUM_EXT]/leinad4mind\\invitation/language/pt_preao/info_acp_invite.php"
similarity index 93%
rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/language/pt_pt/info_acp_invite.php"
rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/language/pt_preao/info_acp_invite.php"
--- "[ORIGINAL]/leinad4mind\\invitation/language/pt_pt/info_acp_invite.php"
+++ "[FORUM_EXT]/leinad4mind\\invitation/language/pt_preao/info_acp_invite.php"
@@ -45,7 +45,9 @@ $lang = array_merge($lang, array(
 	'ACP_INVITED_PEND_COUNT'							=> 'Todos Convites (%s)',
 	'ACP_INVITED_USERS_COUNT'							=> 'Todos os utilizadores (%s)',
 	'ACP_INVITE_ALL_USER_INVITE_MAX'					=> 'Convite ilimitado para todos',
-	'ACP_INVITE_ALL_USER_INVITE_MAX_EXPLAIN'			=> 'se seleccionado, todos os utilizadores terão convites ilimitados.',
+	'ACP_INVITE_ALL_USER_INVITE_MAX_EXPLAIN'			=> 'Se sim, todos os utilizadores terão convites ilimitados.',
+	'ACP_INVITE_RESTORE_INVITES'						=> 'Restaurar convites expirados e recusados',
+	'ACP_INVITE_RESTORE_INVITES_EXPLAIN'				=> 'Caso um convite expire ou seja recusado deverá o convite ser novamente disponibilizado ao utilizador.',
 	'ACP_INVITE_BIRTHDAYS'								=> 'Aniversário',
 	'ACP_INVITE_BIRTHDAYS_EXPLAIN'						=> 'Podes definir quantos convites um utilizador receberá no seu aniversário. <em>Para que essa configuração tenha efeito, o recurso de aniversário também precisa ser activado.</em>',
 	'ACP_INVITE_CAPTCHA'								=> 'Confirmação visual',
@@ -70,10 +72,12 @@ $lang = array_merge($lang, array(
 	'ACP_INVITE_DELETE_USERS_CONFIRM'					=> 'Tens a certeza de que desejas excluir os convites dos utilizadores seleccionados?',
 	'ACP_INVITE_DELETE_USER_CONFIRM'					=> 'Tens a certeza de que desejas excluir os convites do utilizador seleccionado?',
 	'ACP_INVITE_DISABLED'								=> 'O sistema de convite está desactivado!',
-	'ACP_INVITE_DENY'									=> 'Rejeição',
+	'ACP_INVITE_DENY'									=> 'Rejeitar',
 	'ACP_INVITE_EMAIL_BOARD_DISABLED'					=> '<strong>phpBB Invite:</strong> O envio de e-mails está, de momento, desactivado!<br />Enquanto estiver desactivado, os convites não devem funcionar. Se quiseres activá-lo, podes fazê-lo %sAQUI%s.',
 	'ACP_INVITE_EMAIL_DISABLED'							=> 'Envio de e-mails foi desactivado, por favor, ative-o. %sVá às configurações de e-mail.%s ',
 	'ACP_INVITE_EMAIL_PRIORITY'							=> 'Prioridade do email de convite',
+	'ACP_INVITE_MEMBERSHIP_DAYS'						=> 'Número mínimo de dias de registo',
+	'ACP_INVITE_MEMBERSHIP_DAYS_EXPLAIN'				=> 'Número de dias que um utilizador precisa de ter para poder usar o sistema de convites. Colocar 0 para desactivar e permitir uso imediato.',
 	'ACP_INVITE_ENABLE'									=> 'Activar extensão de convite',
 	'ACP_INVITE_ENABLE_EXPLAIN'							=> 'Se o activares, a extensão do convite será usada.',
 	'ACP_INVITE_VALIDATION'								=> 'Tempo de expiração dos convites enviados',
@@ -82,6 +86,12 @@ $lang = array_merge($lang, array(
 	'ACP_INVITE_GIFT_NUMBER_INVITES'					=> 'Número de convites presenteado',
 	'ACP_INVITE_GIFT_INVITED_USERS'						=> 'Utilizadores convidados',
 	'ACP_INVITE_GIFT_INVITED_USERS_EXPLAIN'				=> 'Os utilizadores receberão um convite de presente após esse número de utilizadores convidados.<br /><em>Se "0", essa função será desactivada.</em>',
+	'ACP_INVITE_POSTS_GIFT_INVITES'						=> 'Convites por Intervalo',
+	'ACP_INVITE_POSTS_GIFT_INVITES_EXPLAIN'				=> 'Número de convites que um utilizador irá receber após atingir o número de x mensagens. Colocar 0 para desactivar.',
+	'ACP_INVITE_POSTS_GIFT_POSTS'						=> 'Intervalo de Mensagens',
+	'ACP_INVITE_POSTS_GIFT_POSTS_EXPLAIN'				=> 'O utilizador irá receber a cada x mensagens o número de convites inserido no campo acima. Colocar 0 para desactivar.',
+	'ACP_INVITE_POSTS_GIFT_LIMIT'						=> 'Limite do Intervalo',
+	'ACP_INVITE_POSTS_GIFT_LIMIT_EXPLAIN'				=> 'Número máximo de intervalos que um utilizador irá receber convites. Por exemplo, colocar intervalo de 30 mensagens com limite de 3 vezes irá enviar convites quando o utilizador atingir 30, 60 e 90 mensagens. Colocar 0 para desactivar.',
 	'ACP_INVITE_GROUP'									=> 'Grupo de utilizadores convidados',
 	'ACP_INVITE_GROUP_ENABLED'							=> 'Activar o uso de grupo',
 	'ACP_INVITE_GROUP_ENABLED_EXPLAIN'					=> 'If enabled, invited users will automatically be added to the selected group.',
diff --git "[FORUM_EXT]/leinad4mind\\invitation/language/pt_preao/info_mcp_invite.php" "[FORUM_EXT]/leinad4mind\\invitation/language/pt_preao/info_mcp_invite.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/leinad4mind\\invitation/language/pt_preao/info_mcp_invite.php"
@@ -0,0 +1,43 @@
+<?php
+
+/**
+ *
+ * Invite. An extension for the phpBB Forum Software package.
+ * Brazilian Portuguese translation by eunaumtenhoid [2019][ver 4.2.0] (https://github.com/phpBBTraducoes)
+ * @copyright (c) 2010-2015, KillBill
+ * @copyright (c) 2017, kasimi
+ * @copyright (c) 2017-2022, Leinad4Mind, https://leinad4mind.top/forum
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
+// Some characters you may want to copy&paste: ’ « » „ “ ” …
+
+$lang = array_merge($lang, array(
+	'MCP_CAT_INVITE'			=> 'phpBB Invite',
+	'MCP_INVITE'				=> 'Convite',
+	'MCP_INVITE_BACK'			=> '<br /><br />%sVoltar para o painel de controlo do moderador%s',
+	'MCP_INVITE_DISABLED'		=> '%sO sistema de convite foi desactivado!%s',
+	'MCP_INVITE_CONFIRMATION'	=> 'Solicitações de convite',
+));
diff --git "[FORUM_EXT]/leinad4mind\\invitation/language/pt_preao/info_ucp_invite.php" "[FORUM_EXT]/leinad4mind\\invitation/language/pt_preao/info_ucp_invite.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/leinad4mind\\invitation/language/pt_preao/info_ucp_invite.php"
@@ -0,0 +1,145 @@
+<?php
+
+/**
+ *
+ * Invite. An extension for the phpBB Forum Software package.
+ * Brazilian Portuguese translation by eunaumtenhoid [2019][ver 4.2.0] (https://github.com/phpBBTraducoes)
+ * @copyright (c) 2010-2015, KillBill
+ * @copyright (c) 2017, kasimi
+ * @copyright (c) 2017-2022, Leinad4Mind, https://leinad4mind.top/forum
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
+// Some characters you may want to copy&paste: ’ « » „ “ ” …
+
+$lang = array_merge($lang, array(
+	'POST_CONFIRM_EXPLAIN'					=> 'Digitar o código evita o convite automático de bots. Podes encontrar o código na imagem. Se não fores capaz de ler o código devido a problemas visuais ou outros, entra em contacto com o %sadministrador%s.',
+
+	'UCP_CAT_INVITE'						=> 'phpBB Invite',
+	'UCP_INVITE'							=> 'Convites',
+	'UCP_INVITE_LABEL'						=> 'GoldTugAnime - Convite',
+	'UCP_INVITE_MESSAGE'					=> 'Bem-vindo à mais bela Comunidade de Animação em Português de Portugal!
+
+Esperamos que te divirtas e que a animação nunca deixe de fazer parte da tua vida.',
+	'UCP_INVITE_DATA'						=> 'Detalhes de convites',
+	'UCP_INVITE_BACK'						=> '<br /><br />%sVoltar para o painel de controlo do utilizador%s',
+	'UCP_INVITE_DAYF'						=> 'Convites enviados hoje',
+	'UCP_INVITE_DAYF_EXPLAIN'				=> 'O número de convites que enviaste hoje.',
+	'UCP_INVITE_DAY_OFF'					=> 'Não estamos a aceitar mais convites hoje!',
+	'UCP_INVITE_DB'							=> '<b>%s convite(s).</b>',
+	'UCP_INVITE_DB_SEND'					=> 'Limite de convite diário',
+	'UCP_INVITE_DB_SEND_EXPLAIN'			=> 'Número máximo de convites por dia que podes enviar.',
+	'UCP_INVITE_DB_MAX'						=> '<span class="invitation_tred">Ilimitado!</span>',
+	'UCP_INVITE_DB_PENDING'					=> 'Convites pendentes',
+	'UCP_INVITE_DB_PENDING_EXPLAIN'			=> 'O número de utilizadores que convidaste e ainda não se registou.',
+	'UCP_INVITE_DB_NUMBER'					=> 'Número de convites',
+	'UCP_INVITE_DB_NUMBER_EXPLAIN'			=> 'O teu limite de convites restante',
+	'UCP_INVITE_DB_USER'					=> 'Utilizador convidado',
+	'UCP_INVITE_DB_USERS'					=> 'Utilizadores convidados',
+	'UCP_INVITE_DB_USERS_EXPLAIN'			=> 'Membros que convidaste.',
+	'UCP_INVITE_DB_USER_EXPLAIN'			=> 'Membro que convidaste.',
+	'UCP_INVITE_DELETE'						=> 'Apagar convite',
+	'UCP_INVITE_DELETE_EXPLAIN'				=> 'Se enviaste convites para os endereços errados, poderás revogar os mesmos aqui.<br /><em>Isso só é possível dentro de %s minutos após o envio do convite.</em>',	
+	'UCP_INVITE_DELETE_NO_CONFIRM'			=> 'A remoção não foi confirmada!',
+	'UCP_INVITE_DELETE_SUCCESS'				=> 'O convite foi apagado com sucesso.',
+	'UCP_INVITE_DISABLED'					=> '%sO sistema de convites está desactivado!%s',
+	'UCP_INVITE_DUP'						=> 'Já foi enviado um convite para o endereço de e-mail: %s',
+	'UCP_INVITE_EDUP'						=> 'Endereço de e-mail inserido repetidamente: %s',
+	'UCP_INVITE_EMAILS_SENT'				=> 'Os convites foram enviados com sucesso!',
+	'UCP_INVITE_EMAIL_LANG'					=> 'Idioma do e-mail',
+	'UCP_INVITE_EMAIL_REQUEST_EXPLAIN'		=> 'Razão para a solicitação de convites.',
+	'UCP_INVITE_EMAIL_SELECT'				=> 'Selecção de convite',
+	'UCP_INVITE_EMAIL_SELECT_EXPLAIN'		=> 'Escolhe qual dos destinatários desejas excluir.',
+	'UCP_INVITE_EMAIL_SENT'					=> 'O convite foi enviado com sucesso!',
+	'UCP_INVITE_FLOOD_LIMIT'				=> 'Não podes enviar mais convites. Por favor, tenta novamente mais tarde.',
+	'UCP_INVITE_FRIEND'						=> 'Adicionar um amigo',
+	'UCP_INVITE_FRIEND_EXPLAIN'				=> 'O utilizador convidado será adicionado à tua lista de amigos.',
+	'UCP_INVITE_DEP_LIMIT'					=> 'Apenas %s convites podem ser enviados hoje. No entanto, listaste %s destinatários.', 
+	'UCP_INVITE_REQUEST'					=> 'Solicitação de convites',
+	'UCP_INVITE_REQUEST_BUYS_SUCCESS'		=> 'Compraste convites com sucesso.',
+	'UCP_INVITE_REQUEST_BUY_MIN'			=> 'Mínimo (1) convite a ser comprado!',
+	'UCP_INVITE_REQUEST_BUY_NO'				=> 'Não tens %s suficiente para comprar essa quantidade de convites! Tens %s %s atualmente.',
+	'UCP_INVITE_REQUEST_BUY_SUBMIT'			=> 'Comprar',
+	'UCP_INVITE_REQUEST_BUY_SUBT'			=> 'Convites que desejas comprar',
+	'UCP_INVITE_REQUEST_BUY_SUBT_EXPLAIN'	=> 'Digita o número de convites que desejas comprar. O preço do convite é <b>%s %s</b>.<br />Assumes a responsabilidade pelo(s) teu(s) utilizador(es) convidado(s) se o(s) utilizador(es) convidado(s) causar(em) incidentes inapropriados.',
+	'UCP_INVITE_REQUEST_BUY_SUCCESS'		=> 'A compra do convite foi bem-sucedida.',
+	'UCP_INVITE_REQUEST_BUY_TITLE'			=> 'Comprar convite.',
+	'UCP_INVITE_REQUEST_DISABLED'			=> 'As solicitações de convites estão desactivadas!',
+	'UCP_INVITE_REQUEST_MAX'				=> 'Número máximo de pedidos: (%s) convite(s)!',
+	'UCP_INVITE_REQUEST_MESSAGE_NO_DB'		=> '<em>Não! Não houve necessidade.</em>',
+	'UCP_INVITE_REQUEST_MIN'				=> 'Número mínimo de convites solicitados: (1)',
+	'UCP_INVITE_REQUEST_NO_MESSAGE'			=> 'Não escreveste uma mensagem! Sem uma explicação não podes reivindicar tantos convites.',
+	'UCP_INVITE_REQUEST_OFF'				=> 'A tua solicitação de convite está pendente. Quando um administrador/moderador avaliar a tua solicitação, receberás uma notificação.',
+	'UCP_INVITE_REQUEST_SOK_EXPLAIN'		=> 'Ao enviar mais de <b>(%s)</b> pedidos, é necessária uma explicação para o administrador. Por favor, explica por que precisas de tantos convites.<br />Se acharmos que o teu pedido é aceitável, nós enviamos os convites. Se for um abuso, pode ser motivo para banir a tua conta.',	
+	'UCP_INVITE_REQUEST_SUBMIT'				=> 'Enviar pedido',
+	'UCP_INVITE_REQUEST_SUCC'				=> 'A solicitação de convite foi enviada com sucesso!',
+	'UCP_INVITE_REQUEST_SUCCS'				=> 'A solicitação de convites foram enviadas com sucesso!',
+	'UCP_INVITE_REQUEST_TITLE'				=> 'Requisitar convites',
+	'UCP_INVITE_REQUEST_TITLE_EXPLAIN'		=> 'Digita o número de convites que desejas solicitar. Há um máximo de <b>(%s)</b> convites disponíveis.',
+	'UCP_INVITE_REQUEST_COST'				=> '<div class="invitation_tred alert alert-danger">O preço por convite é de <b>50.000 pontos</b>.</div>',
+	'UCP_INVITE_SEND'						=> 'Enviar convite',
+	'UCP_INVITE_SEND_EXPLAIN'			=> '<div class="invitation_tred alert alert-danger">Assumes parte da responsabilidade dos utilizadores que convidares caso eles se comportarem de maneira inapropriada.</div>',
+	'UCP_INVITE_SEND_EMAIL_MAX'				=> 'Máximo de %s endereços de e-mail podem ser usados. No entanto, listaste %s!', 
+	'UCP_INVITE_SEND_MAX'					=> '<span class="invitation_tred">Actualmente não há limite!</span>',
+	'UCP_INVITE_LAST_ACTIVE'				=> 'Última visita',
+	'UCP_INVITE_MAX_ERROR'					=> 'Actualmente tens convites ilimitados.',
+	'UCP_INVITE_MAX_RECIPIENTS'				=> 'Digita todos os endereços numa nova linha! <br /> Número máximo de destinatários',
+	'UCP_INVITE_MESSAGE_BODY_EXPLAIN'		=> 'Escreve algumas linhas a explicar por que deveriam participar.',
+	'UCP_INVITE_NOT_DELETED_INVITE'			=> 'Não há convites para apagar!',
+	'UCP_INVITE_NOT_LANGUAGE'				=> 'Ficheiro de idioma inexistente: %s',
+	'UCP_INVITE_NO_EMAIL'					=> 'Não forneceste um endereço de e-mail!',
+	'UCP_INVITE_NO_INVITE_USERS'			=> 'Ainda não convidaste ninguém ou ainda não se registaram.',
+	'UCP_INVITE_NO_LOGIN'					=> 'Ele/ela não se registou neste site.',
+	'UCP_INVITE_NO_PERM'					=> 'Não está autorizado a enviar convites!',
+	'UCP_INVITE_NO_PERM_EMAIL'				=> 'Não está autorizado a enviar e-mail!',
+	'UCP_INVITE_MEMBERSHIP_DAYS'			=> 'A tua conta tem de ter pelo menos %1$d dias antes que possas fazer uso do sistema de convites. Poderás utilizar a partir de %2$s.',
+	'UCP_INVITE_NO_REG'						=> 'Ninguém foi convidado por ti.',
+	'UCP_INVITE_NULL'						=> 'Não tem convites! <em>Porque não comprar alguns?</em>', 
+	'UCP_INVITE_POINTS_AMOUNT'				=> 'Presente',
+	'UCP_INVITE_POINTS_AMOUNT_EXPLAIN'		=> 'Quantidade de pontos que o utilizador receberá quando ele convidar alguém e se essa pessoa convidada se tornar um membro registado.',
+	'UCP_INVITE_POINTS_COST'				=> 'Preço do convite',
+	'UCP_INVITE_POINTS_COST_EXPLAIN'		=> 'O custo do envio de um convite.',
+	'UCP_INVITE_POST_LIMIT'					=> 'Deves ter um mínimo de %s mensagens, para enviar convites!', 
+	'UCP_INVITE_REQUEST_SUBJECT'			=> 'Pedido de convite',
+	'UCP_INVITE_SDB'						=> 'convite(s).',
+	'UCP_INVITE_SEND_OFF'					=> 'O envio de convites está, de momento, desactivado!',
+	'UCP_INVITE_SEND_SUBMIT'				=> 'Enviar convite',
+	'UCP_INVITE_TIME_END'					=> 'Data de expiração',
+	'UCP_INVITE_TIME_END_EXPLAIN'			=> 'O utilizador convidado terá que se registar durante esse período.',
+	'UCP_INVITE_USER'						=> 'Utilizadores convidados',
+	'UCP_INVITE_USERS_COUNT'				=> 'Utilizadores convidados (%s)',
+	'UCP_INVITE_USER_OK'					=> 'Convite aceite',
+	'UCP_INVITE_LU_REG'						=> 'Último utilizador',
+	'UCP_INVITE_LU_REG_EXPLAIN'				=> 'Último utilizador dos seus convites.',
+	'UCP_INVITE_LU_REG_INFO'				=> '<b>%s</b> registado %s',
+
+	'WEEKS'									=> 'Semanas',
+
+	'NOTIFICATION_TYPE_INVITE_BIRTHDAY'			=> 'Recebeste convites para o teu aniversário',
+	'NOTIFICATION_TYPE_INVITE_GIFT'				=> 'Recebeste convites depois de convidar um utilizador com sucesso',
+	'NOTIFICATION_TYPE_INVITE_PETITION'			=> 'Recebeste uma resposta de uma solicitação de convite',
+	'NOTIFICATION_TYPE_INVITE_PETITION_REQUEST' => 'Recebeste uma solicitação de convite',
+	'NOTIFICATION_TYPE_INVITE_JOIN'				=> 'Um utilizador que convidaste criou uma conta',
+));
diff --git "[FORUM_EXT]/leinad4mind\\invitation/language/pt_preao/install_invite.php" "[FORUM_EXT]/leinad4mind\\invitation/language/pt_preao/install_invite.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/leinad4mind\\invitation/language/pt_preao/install_invite.php"
@@ -0,0 +1,156 @@
+<?php
+
+/**
+ *
+ * Invite. An extension for the phpBB Forum Software package.
+ *
+ * @copyright (c) 2010-2015, KillBill
+ * @copyright (c) 2017, kasimi
+ * @copyright (c) 2017-2022, Leinad4Mind, https://leinad4mind.top/forum
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
+// Some characters you may want to copy&paste: ’ « » „ “ ” …
+
+$lang = array_merge($lang, array(
+	'AUTH_CACHE_PURGE'						=> 'Clear permission cache',
+
+	'CACHE_PURGE'							=> 'Clear forum cache',
+	'CAT_INSTALL'							=> 'Install',
+	'CAT_OVERVIEW'							=> 'Overview',
+	'CAT_UNINSTALL'							=> 'Uninstall',
+	'CAT_UPDATE'							=> 'Update',
+	'CAT_VERIFY'							=> 'Verify',
+
+	'GPL'									=> 'General Public License',
+
+	'INCOMPLETE_FILES_UPLOAD'				=> 'All Invite files have not been uploaded! Please make sure to upload all files before running the installer.',
+	'INCOMPLETE_FILE_EDITS'					=> 'Editing of this file has not been done yet. The installation can not run unless all files are edited correctly!',
+	'INCOMPLETE_LANG_ROWS'					=> 'Some changes to the language files are missing. Please apply them as described %sHERE%s.',
+	'INSTALLATION'							=> 'phpBB Invite install',
+	'INSTALLATION_EXPLAIN'					=> '<br />phpBB Invite database install.<br /><br />',
+	'INSTALL_BODY'							=> 'Here you can see that the mod is well established and has been properly installed.',
+	'INSTALL_ERR_AUTH'						=> 'You are not authorized to use this script.<br /><br />Please note to use the script the following requirements must be met. First you must be logged in to the site and second you must have the user type founder. If you are logged in and are the founder then you have incorrect cookie settings in the ACP. Please check the cookie domain setting. If your site URL is <strong>http://www.example.com</strong> then the cookie domain should be <strong>.example.com</strong>.',
+	'INSTALL_FOLDER'						=> '<strong>Please delete the install folder. Until you have done this, only the ACP will be available.</strong>',
+	'INSTALL_LOGIN'							=> 'Proceed to ACP',
+
+	'INVITE_CONFIG_ADD'						=> 'Adding new invite config variable: %s',
+	'INVITE_CONFIG_ALREADY_EXISTS'			=> 'ERROR: Invite config variable %s already exists.',
+	'INVITE_CONFIG_NOT_EXIST'				=> 'ERROR: Invite config variable %s does not exist.',
+	'INVITE_CONFIG_REMOVE'					=> 'Removing Invite config variable: %s',
+	'INVITE_CONFIG_UPDATE'					=> 'Updating Invite config variable: %s',
+
+	'INVITE_INSTALL_INTRO'					=> 'Welcome to phpBB Invite Installation',
+	'INVITE_INSTALL_INTRO_BODY'				=> 'With this option, it is possible to install phpBB Invite to your database.',
+
+	'INVITE_VERSION'						=> 'The installed phpBB Invite version is <b>%s</b>, this file can be used to update version <b>%s</b> to version <b>%s</b>. <br /> You first need to upgrade to version <b>%s</b> to run this update script!',
+
+	'NOT_INSTALL_DIR'						=> 'Cannot open the install folder!',
+	'NOT_LANGUAGE_DIR'						=> 'The language library is not available!',
+	'NOT_LANGUAGE_DIR_DIR'					=> 'The %s language directory cannot be found!',
+	'NOT_MODULE'							=> 'The installation modules are not available!',
+	'NOT_MODULE_OPEN'						=> '%s Module is not available!',
+	'NO_TABLE_DATA'							=> '<span style="color:#FF0000;">Error:</span> The table data is missing.',
+
+	'OVERVIEW_BODY'							=> 'Welcome!<br /><br />The installation system presents a complete guide how to install the mod, or remove and update it.<br />Continue with the selection menu... Select the appropriate option from the menu.',
+
+	'PARENT_NOT_EXIST'						=> '<span style="color:#FF0000;">Error:</span> The parent category which shows the new module does not exist.',
+	'PERMISSIONS_WARNING'					=> 'New permission settings have been added.  Check your permission settings and make sure that they are as you would like them.',
+	'PHPBB_INVITE_DONATE'					=> 'Please make a small donation to appreciate the hard work and many hours used to make the “phpBB Invite”.',
+	'PHPBB_INVITE_DONATE_TITLE'				=> 'phpBB Invite donation',
+	'PHPBB_VERSION'							=> 'Your phpBB version is <b>%s</b>, the phpBB Invite mod requires version <b>%s</b> to run!',
+	'PHP_VERSION_RUN'						=> 'The current PHP version is not supported, please update your PHP to version 4.3.3 or later before you run the installation.</b>',
+
+	'ROLE_NOT_EXIST'						=> '<span style="color:#FF0000;">Error:</span> this role is not in the database.',
+
+	'STAGE_INSTALL'							=> 'Install',
+	'STAGE_INTRO'							=> 'Intro',
+	'STAGE_UNINSTALL'						=> 'Delete the database',
+	'STAGE_VERIFY'							=> 'Verify',
+	'STAGE_VERIFY_FILE_EXPLAIN'				=> '<br />The mod files are successfully deleted.',
+	'SUB_INTRO'								=> 'Intro',
+	'SUB_LICENSE'							=> 'License',
+	'SUB_SUPPORT'							=> 'Support',
+	'SUCCESSES'								=> '<span style="color:#000;"><b>Successfully completed!</b></span>',
+	'SUPPORT_BODY'							=> 'Full support will be provided for the current release and development versions, all for free.<br />This includes:</p><ul><li>information</li><li>configuration</li><li>update older versions to the newest version</li></ul><p>I encourage everyone who is using an older version to upgrade to the new version.</p><h2>Support forums</h2><br /><p><a href="http://jatek-vilag.com/viewtopic.php?p=204#p204" onclick="window.open(this.href); return false;">The main development site</a><br /><a href="https://www.phpbb.com/community/viewtopic.php?p=12855248#p12855248" onclick="window.open(this.href); return false;">phpBB.com Development topic</a><br /><a href="http://phpbb.hu/forum/hsz/40666#hsz-40666" onclick="window.open(this.href); return false;">phpBB.hu Development topic</a><br /><br />',
+
+	'UNINSTALL_BODY'						=> 'Here you can see that the mod database entries have been successfully removed.<br /><br /><b>Please delete the install folder. Until you have done this, only the ACP will be available.</b>',
+	'UNINSTALL_INTRO'						=> 'phpBB Invite delete',
+	'UNINSTALL_INTRO_BODY'					=> 'Under this option, you can delete the phpBB Invite from the database.',
+	'UNINSTALL_TITLE'						=> 'phpBB Invite deleted from the database',
+	'UPDATE_BODY'							=> 'Here you can see that database data created by this mod has been properly updated.<br /><br /><b>Please delete the install folder. Until you have done this, only the ACP will be available.</b>',
+	'UPDATE_INSTALLATION'					=> 'phpBB Invite update',
+	'UPDATE_INSTALLATION_EXPLAIN'			=> '<br />phpBB Invite update on the newest version.<br />',
+	'UPDATE_TITLE'							=> 'Updating database data',
+
+	'VERIFY_ERROR_EXPLAIN'					=> 'The check found an error.',
+	'VERIFY_ERROR_FILE'						=> 'Bad file modification',
+	'VERIFY_ERROR_FILE_EXPLAIN'				=> 'Here you can see those files which have been incorrectly edited or has been omitted.',
+	'VERIFY_EXITS_PRINT_MYAD'				=> '<br />The SQL command you see here you can install by yourself, if you load it in phpMyAdmin.',
+	'VERIFY_EXITS_PRINT_SQL'				=> '<b><span style="color:#FF0000;">%s</span> <span style="color:#000;">not found!</span></b><br />%s<br />',
+	'VERIFY_INVITE_MOD_CONFIG'				=> 'phpBB Invite configuration',
+	'VERIFY_INVITE_MOD_CONFIG_OK'			=> '<span style="color:#228822;"><strong>All phpBB Invite config found.</strong></span>',
+	'VERIFY_INVITE_MOD_FILES'				=> 'phpBB Invite files',
+	'VERIFY_INVITE_MOD_FILES_OK'			=> '<span style="color:#228822;"><strong>All files found.</strong></span>',
+	'VERIFY_INVITE_MOD_MODULES'				=> 'phpBB Invite modules',
+	'VERIFY_INVITE_MOD_MODULES_OK'			=> '<span style="color:#228822;"><strong>All modules found.</strong></span>',
+	'VERIFY_INVITE_MOD_PERM'				=> 'phpBB Invite permissions',
+	'VERIFY_INVITE_MOD_PERM_OK'				=> '<span style="color:#228822;"><strong>All permissions found.</strong></span>',
+	'VERIFY_INVITE_MOD_TABLES'				=> 'phpBB Invite tables',
+	'VERIFY_INVITE_MOD_TABLES_OK'			=> '<span style="color:#228822;"><strong>All tables found.</strong></span>',
+	'VERIFY_NOT_AC_FOUND'					=> '<b><span style="color:#FF0000;">%s</span> <span style="color:#000;">not found!</span></b>',
+	'VERIFY_NOT_COLUMN'						=> 'Missing columns',
+	'VERIFY_NOT_COLUMN_EXPLAIN'				=> 'Here you can see all the columns which were not installed.',
+	'VERIFY_NOT_CONFIG'						=> 'Missing config',
+	'VERIFY_NOT_CONFIG_EXPLAIN'				=> 'Here you can see the config files which have not been installed.',
+	'VERIFY_NOT_FILE'						=> 'Missing files',
+	'VERIFY_NOT_FILE_EXPLAIN'				=> 'Here you can see the files that have not been uploaded correctly or have been uploaded correctly but to the wrong place.',
+	'VERIFY_NOT_INVITE_CONFIG'				=> 'Missing phpBB Invite config',
+	'VERIFY_NOT_INVITE_CONFIG_EXPLAIN'		=> 'Here you can see the phpBB Invite config files which have not been installed.',
+	'VERIFY_NOT_MODULE'						=> 'Missing modules',
+	'VERIFY_NOT_MODULE_EXPLAIN'				=> 'Here you can see the modules which have not been installed.',
+	'VERIFY_NOT_PERMIS'						=> 'Missing permissions',
+	'VERIFY_NOT_PERMIS_EXPLAIN'				=> 'Here you can see the permissions that were not installed.',
+	'VERIFY_NOT_TABLE'						=> 'Missing table',
+	'VERIFY_NOT_TABLE_EXPLAIN'				=> 'Here you can see the signs which have not been installed.',
+	'VERIFY_NO_COLUMN'						=> '<b><span style="color:#FF0000;">%s</span> <span style="color:#000;">column not found!</span></b><br />%s<br />',
+	'VERIFY_NO_MODULE'						=> '<b><span style="color:#FF0000;">%s</span> <span style="color:#000;">module is not found in the database!</span></b>',
+	'VERIFY_NO_PERMIS'						=> '<b><span style="color:#FF0000;">%s</span> <span style="color:#000;">permission is not found in the database!</span></b>',
+	'VERIFY_NO_TABLE'						=> '<b><span style="color:#FF0000;">%s</span> <span style="color:#000;">table is not found in the database!</span></b>%s',
+	'VERIFY_PHPBB_MOD_COLUMNS'				=> 'phpBB users table new columns',
+	'VERIFY_PHPBB_MOD_COLUMNS_OK'			=> '<span style="color:#228822;"><strong>All columns found.</strong></span>',
+	'VERIFY_PHPBB_MOD_CONFIG'				=> 'phpBB new config',
+	'VERIFY_PHPBB_MOD_CONFIG_OK'			=> '<span style="color:#228822;"><strong>phpBB config found.</strong></span>',
+	'VERIFY_PHPBB_MOD_FILES'				=> 'phpBB file edits',
+	'VERIFY_PHPBB_MOD_FILES_OK'				=> '<span style="color:#228822;"><strong>All files are edited.</strong></span>',
+	'VERIFY_SUCCESSES_EXPLAIN'				=> 'The check found everything okay.',
+	'VERIFY_TITLE'							=> 'phpBB Invite control',
+	'VERIFY_TITLE_ELL'						=> 'Control error',
+	'VERIFY_TITLE_ELL_EXPLAIN'				=> '<span style="color:#000;"><b>Here you can see all occurred errors to fix everything carefully!</b></span>',
+	'VERIFY_TITLE_EXPLAIN'					=> '<br />Here you can check whether all required file changes, configuration changes and database entries have been made successfully.',
+	'VERIFY_NEW'							=> 'Check again',
+	'VERIFY_UNINSTALL_ERROR_FILE'			=> 'Existing files',
+	'VERIFY_UNINSTALL_ERROR_FILE_EXPLAIN'	=> 'Here you can see the files which have not been removed.',
+));
diff --git "[FORUM_EXT]/leinad4mind\\invitation/language/pt_preao/invite.php" "[FORUM_EXT]/leinad4mind\\invitation/language/pt_preao/invite.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/leinad4mind\\invitation/language/pt_preao/invite.php"
@@ -0,0 +1,53 @@
+<?php
+
+/**
+ *
+ * Invite. An extension for the phpBB Forum Software package.
+ * Brazilian Portuguese translation by eunaumtenhoid [2019][ver 4.2.0] (https://github.com/phpBBTraducoes)
+ * @copyright (c) 2010-2015, KillBill
+ * @copyright (c) 2017, kasimi
+ * @copyright (c) 2017-2022, Leinad4Mind, https://leinad4mind.top/forum
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
+// Some characters you may want to copy&paste: ’ « » „ “ ” …
+
+$lang = array_merge($lang, array(
+	'INVITE'								=> 'Convites',
+	'INVITE_INFO'								=> 'Informação sobre Convites',
+	'INVITE_DELETE_CONFIRM'					=> 'Se quiseres apagar o convite, clica %sAQUI%s.',
+	'INVITE_DELETE_SUCCESS'					=> 'O teu convite foi apagados com sucesso.',
+	'INVITE_DELETE_SUCCESSES'				=> 'Os teus convites foram apagados com sucesso.',
+	'INVITE_DISABLED'						=> '<span class="invitation_tred">O sistema de convite está atualmente desativado!</span>',
+	'INVITE_EMAIL_BLOCK'					=> 'Bloqueado!',
+	'INVITE_INVITED'						=> 'Convidado por',
+	'INVITE_INVITES'						=> 'Convidou',
+	'INVITE_KEY_ERROR'						=> '<div class="invitation_error">O convite não é válido!</div>',
+	'INVITE_PERSON'							=> '%s pessoa(s)',
+	'INVITE_POINTS_PRESENT'					=> 'A cada %s convite(s), enviamos %s %s !',
+	'INVITE_REGISTRATION'					=> '<div class="invitation_error">Registo apenas por convite!</div>',
+	'INVITE_REGISTRATION_EXPLAIN'			=> 'De momento os registos são restritos apenas a pessoas convidadas por utilizadores da comunidade, caso conheças alguém que tenha conta pede um convite!',
+	'INVITE_COPYRIGHT'						=> 'phpBB Invite by <a href="https://leinad4mind.top/forum">Leinad4Mind</a> &copy; 2018-2022',
+));
diff --git "[FORUM_EXT]/leinad4mind\\invitation/language/pt_preao/permissions_invite.php" "[FORUM_EXT]/leinad4mind\\invitation/language/pt_preao/permissions_invite.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/leinad4mind\\invitation/language/pt_preao/permissions_invite.php"
@@ -0,0 +1,51 @@
+<?php
+
+/**
+ *
+ * Invite. An extension for the phpBB Forum Software package.
+ * Brazilian Portuguese translation by eunaumtenhoid [2019][ver 4.2.0] (https://github.com/phpBBTraducoes)
+ * @copyright (c) 2010-2015, KillBill
+ * @copyright (c) 2017, kasimi
+ * @copyright (c) 2017-2022, Leinad4Mind, https://leinad4mind.top/forum
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
+// Some characters you may want to copy&paste: ’ « » „ “ ” …
+
+$lang = array_merge($lang, array(
+	'ACL_A_INVITE'			=> 'O utilizador pode sincronizar dados',
+	'ACL_A_INVITE_CONFIG'	=> 'O utilizador pode alterar as configurações do convite.',
+	'ACL_A_INVITE_DELETE'	=> 'O utilizador pode apagar convites',
+	'ACL_A_INVITE_CLAIMING' => 'O utilizador pode gerir convites',
+	'ACL_A_INVITE_SEND'		=> 'O utilizador pode adicionar convites para membros',
+	'ACL_A_INVITE_PEND'		=> 'O utilizador pode gerir convites pendentes',
+	'ACL_A_INVITE_USERS'	=> 'O utilizador pode ver uma lista de membros convidados',
+	'ACL_M_INVITE_CLAIMING'	=> 'O utilizador pode aprovar um pedido de convite.',
+	'ACL_U_INVITE_DELETE'	=> 'O utilizador pode revogar convites<br /><em>O utilizador pode cancelar um convite que ele enviou.</em>',
+	'ACL_U_INVITE_REQUEST'	=> 'O utilizador pode solicitar convite',
+	'ACL_U_INVITE_SENDING'		=> 'O utilizador pode convidar novos membros para o site',
+	'ACL_U_INVITE_MAX'		=> 'O utilizador tem convites ilimitados',
+	'ACL_U_INVITE_USERS'	=> 'O utilizador pode visualizar a lista de utilizadores convidados por outras pessoas.',
+));
diff --git "[ORIGINAL]/leinad4mind\\invitation/styles/FLATBOOTS/template/event/memberlist_body_memberlist_after.html" "[FORUM_EXT]/leinad4mind\\invitation/styles/FLATBOOTS/template/event/memberlist_body_memberlist_after.bak"
similarity index 100%
rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/styles/FLATBOOTS/template/event/memberlist_body_memberlist_after.html"
rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/styles/FLATBOOTS/template/event/memberlist_body_memberlist_after.bak"
diff --git "[ORIGINAL]/leinad4mind\\invitation/styles/FLATBOOTS/template/event/navbar_header_profile_list_after.html" "[FORUM_EXT]/leinad4mind\\invitation/styles/FLATBOOTS/template/event/navbar_header_profile_list_after.html"
--- "[ORIGINAL]/leinad4mind\\invitation/styles/FLATBOOTS/template/event/navbar_header_profile_list_after.html"
+++ "[FORUM_EXT]/leinad4mind\\invitation/styles/FLATBOOTS/template/event/navbar_header_profile_list_after.html"
@@ -1 +1 @@
-{% if U_INVITE %}<li><a class="btn btn-primary btn-sm btn-block" href="{{ U_INVITE }}"><i class="fa fa-ticket"></i>&nbsp;{{ lang('INVITE_GLOBAL') }}</a></li>{% endif %}
\ No newline at end of file
+{% if U_INVITE %}<a class="btn btn-primary btn-sm btn-block" href="{{ U_INVITE }}"><i class="fa fa-id-card-o"></i>&nbsp;{{ lang('INVITE_GLOBAL') }}</a>{% endif %}
\ No newline at end of file
diff --git "[ORIGINAL]/leinad4mind\\invitation/styles/FLATBOOTS/template/event/overall_header_navigation_append.html" "[FORUM_EXT]/leinad4mind\\invitation/styles/FLATBOOTS/template/event/overall_header_navigation_append.bak"
similarity index 100%
rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/styles/FLATBOOTS/template/event/overall_header_navigation_append.html"
rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/styles/FLATBOOTS/template/event/overall_header_navigation_append.bak"
diff --git "[ORIGINAL]/leinad4mind\\invitation/styles/FLATBOOTS/template/event/memberlist_view_user_statistics_after.html" "[FORUM_EXT]/leinad4mind\\invitation/styles/FLATBOOTS/template/event/ss_memberlist_view_timeline_item_after.html"
similarity index 100%
rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\leinad4mind\\invitation/styles/FLATBOOTS/template/event/memberlist_view_user_statistics_after.html"
rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\leinad4mind\\invitation/styles/FLATBOOTS/template/event/ss_memberlist_view_timeline_item_after.html"
diff --git "[ORIGINAL]/leinad4mind\\invitation/styles/FLATBOOTS/template/ucp_invite.html" "[FORUM_EXT]/leinad4mind\\invitation/styles/FLATBOOTS/template/ucp_invite.html"
--- "[ORIGINAL]/leinad4mind\\invitation/styles/FLATBOOTS/template/ucp_invite.html"
+++ "[FORUM_EXT]/leinad4mind\\invitation/styles/FLATBOOTS/template/ucp_invite.html"
@@ -8,7 +8,7 @@
 		<div class="inner">
 			<div class="invite_info invite_info-odd">
 				<div class="col-md-7">
-			<label>{{ lang('UCP_INVITE_DB_NUMBER') }}{{ lang('COLON') }}</label><br /><span>{{ lang('UCP_INVITE_DB_NUMBER_EXPLAIN') }}</span>
+					<label>{{ lang('UCP_INVITE_DB_NUMBER') }}{{ lang('COLON') }}</label><br /><span class="hidden-xs">{{ lang('UCP_INVITE_DB_NUMBER_EXPLAIN') }}</span>
 				</div>
 				<div class="col-md-5"><label>{{ INVITE_DB_NUMBER }}</label></div>
 			</div>
@@ -17,7 +17,7 @@
 
 			<div class="invite_info invite_info-even">
 				<div class="col-md-7">
-			<label>{{ lang('UCP_INVITE_DB_USER') }}{{ lang('COLON') }}</label><br /><span>{{ lang('UCP_INVITE_DB_USER_EXPLAIN') }}</span>
+					<label>{{ lang('UCP_INVITE_DB_USER') }}{{ lang('COLON') }}</label><br /><span class="hidden-xs">{{ lang('UCP_INVITE_DB_USER_EXPLAIN') }}</span>
 				</div>
 				<div class="col-md-5"><label>{{ INVITE_DB_USER }}</label></div>
 			</div>
@@ -26,7 +26,7 @@
 
 			<div class="invite_info invite_info-odd">
 				<div class="col-md-7">
-			<label>{{ lang('UCP_INVITE_DB_SEND') }}{{ lang('COLON') }}</label><br /><span>{{ lang('UCP_INVITE_DB_SEND_EXPLAIN') }}</span>
+					<label>{{ lang('UCP_INVITE_DB_SEND') }}{{ lang('COLON') }}</label><br /><span class="hidden-xs">{{ lang('UCP_INVITE_DB_SEND_EXPLAIN') }}</span>
 				</div>
 				<div class="col-md-5"><label>{{ INVITE_DB_SEND }}</label></div>
 			</div>
@@ -35,7 +35,7 @@
 
 			<div class="invite_info invite_info-even">
 				<div class="col-md-7">
-			<label>{{ lang('UCP_INVITE_DAYF') }}{{ lang('COLON') }}</label><br /><span>{{ lang('UCP_INVITE_DAYF_EXPLAIN') }}</span>
+					<label>{{ lang('UCP_INVITE_DAYF') }}{{ lang('COLON') }}</label><br /><span class="hidden-xs">{{ lang('UCP_INVITE_DAYF_EXPLAIN') }}</span>
 				</div>
 				<div class="col-md-5"><label>{{ INVITE_DAY_DB }}</label></div>
 			</div>
@@ -44,7 +44,7 @@
 
 			<div class="invite_info invite_info-odd">
 				<div class="col-md-7">
-			<label>{{ lang('UCP_INVITE_DB_PENDING') }}{{ lang('COLON') }}</label><br /><span>{{ lang('UCP_INVITE_DB_PENDING_EXPLAIN') }}</span>
+					<label>{{ lang('UCP_INVITE_DB_PENDING') }}{{ lang('COLON') }}</label><br /><span class="hidden-xs">{{ lang('UCP_INVITE_DB_PENDING_EXPLAIN') }}</span>
 				</div>
 				<div class="col-md-5"><label>{{ INVITE_DB_PENDING }}</label></div>
 			</div>
@@ -53,16 +53,16 @@
 
 			<div class="invite_info invite_info-even">
 				<div class="col-md-7">
-			<label>{{ lang('UCP_INVITE_TIME_END') }}{{ lang('COLON') }}</label><br /><span>{{ lang('UCP_INVITE_TIME_END_EXPLAIN') }}</span>
+					<label>{{ lang('UCP_INVITE_TIME_END') }}{{ lang('COLON') }}</label><br /><span class="hidden-xs">{{ lang('UCP_INVITE_TIME_END_EXPLAIN') }}</span>
 				</div>
-		<div class="col-md-5"><label><strong>{{ INVITE_TIME_END }} {{ lang('DAY') }}</strong></label></div>
+				<div class="col-md-5"><label><strong>{{ INVITE_TIME_END }}</strong></label></div>
 			</div>
 
 			<div class="space10"></div>
 
 			<div class="invite_info invite_info-odd">
 				<div class="col-md-7">
-			<label>{{ lang('UCP_INVITE_LU_REG') }}{{ lang('COLON') }}</label><br /><span>{{ lang('UCP_INVITE_LU_REG_EXPLAIN') }}</span>
+					<label>{{ lang('UCP_INVITE_LU_REG') }}{{ lang('COLON') }}</label><br /><span class="hidden-xs">{{ lang('UCP_INVITE_LU_REG_EXPLAIN') }}</span>
 				</div>
 				<div class="col-md-5"><label>{{ INVITE_LAST_USER }}</label></div>
 			</div>
@@ -88,6 +88,8 @@
 				<div class="alert alert-danger">{{ ERROR_MESSAGE }}</div>
 				{% endif %}
 
+				<div>{{ lang('UCP_INVITE_SEND_EXPLAIN') }}</div>
+
 				<fieldset class="fields2">
 					{% if S_INVITE_LANG_OPTIONS %}
 					<div>
@@ -180,10 +182,13 @@
 					{% if ERROR_MESSAGE %}
 					<div class="alert alert-danger">{{ ERROR_MESSAGE }}</div>
 					{% endif %}
-					<dl>
-						<dt><label for="claiming_db">{{ SUBT_INVITE_REQUEST }}{{ lang('COLON') }}</label><br /><span>{{ SUBT_INVITE_REQUEST_EXPLAIN }}</span></dt>
-						<dd><input class="inputbox autowidth" type="text" id="claiming_db" name="claiming_db" size="2" maxlength="2" value="{{ INVITE_REQUEST_DB_SELECT }}" /> {{ lang('UCP_INVITE_SDB') }}</dd>
-					</dl>
+					{{ lang('UCP_INVITE_REQUEST_COST') }}
+					<div class="form-group">
+						<label for="subject">{{ SUBT_INVITE_REQUEST }}{{ lang('COLON') }}</label><br /><span>{{ SUBT_INVITE_REQUEST_EXPLAIN }}</span>
+						<div class="input-icon" style="display:flex;align-items:center">
+							<input class="form-control input-sm" style="width:5rem" type="text" id="claiming_db" name="claiming_db" size="2" maxlength="2" value="{{ INVITE_REQUEST_DB_SELECT }}" />&nbsp;{{ lang('UCP_INVITE_SDB') }}
+						</div>
+					</div>
 					{% if S_SIZE_POSTS_REQUIRED %}
 					<dl>
 						<dt class="invite_notice">{{ UCP_INVITE_REQUEST_MANY_EXPLAIN }}</dt>
@@ -200,9 +205,10 @@
 		<div class="panel">
 			<div class="inner">
 				<fieldset class="submit-buttons">
-					<input type="submit" name="submit" id="submit" value="{{ INVITE_REQUEST_SUBMIT }}" class="button1" />
+					<input type="submit" name="submit" id="submit" value="{{ INVITE_REQUEST_SUBMIT }}" class="btn btn-default" />
 					{{ S_FORM_TOKEN }}
 				</fieldset>
+				<div class="space10"></div>
 			</div>
 		</div>
 	</form>
@@ -275,7 +281,7 @@
 		<div class="panel">
 			<div class="inner">
 				<fieldset class="submit-buttons">
-				<input type="submit" name="submit" id="submit" value="{{ lang('DELETE') }}" class="button1 btn btn-default" />
+					<input type="submit" name="submit" id="submit" value="{{ lang('DELETE') }}" class="btn btn-default" />
 					{{ S_FORM_TOKEN }}
 				</fieldset>
 				<div class="space10"></div>
```
