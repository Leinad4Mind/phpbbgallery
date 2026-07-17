Existem diferencas reais no codigo ou texto. Diferencas de formatacao (espacos, tabs) foram ignoradas abaixo.

```diff
diff --git "[ORIGINAL]/oxpus\\notes/README.md" "[ORIGINAL]/oxpus\\notes/README.md"
deleted file mode 100644
--- "[ORIGINAL]/oxpus\\notes/README.md"
+++ /dev/null
@@ -1,24 +0,0 @@
-ANZEIGENAME
-===================
-
-# phpBB 3.1 Personal Notes Extension
-
-Personal notes for all users
-
-## Description
-
-Allows to manage own personal notes which can not be viewed by other users
-
-## Installation
-
-Upload the content of the folder "ext" into your forum folder /ext/.
-After this enable the extension under "ACP" > "Customise" > "Extensions" > "Personal Notes"
-
-## Collaborate
-
-* For support visit the forum under http://phpbb3.oxpus.net
-* To post an issue with this extention please use the bug tracker http://phpbb3.oxpus.net/downloads.php?view=bug_tracker
-
-## License
-
-[GPLv2](license.txt)
diff --git "[ORIGINAL]/oxpus\\notes/config/services.yml" "[FORUM_EXT]/oxpus\\notes/config/services.yml"
--- "[ORIGINAL]/oxpus\\notes/config/services.yml"
+++ "[FORUM_EXT]/oxpus\\notes/config/services.yml"
@@ -11,6 +11,7 @@ services:
             - '@dbal.conn'
             - '@config'
             - '@controller.helper'
+            - '@auth'
             - '@request'
             - '@template'
             - '@user'
@@ -22,6 +23,7 @@ services:
         arguments:
             - '@dbal.conn'
             - '@controller.helper'
+            - '@auth'
             - '@template'
             - '@user'
             - '@language'
diff --git "[ORIGINAL]/oxpus\\notes/controller/main.php" "[FORUM_EXT]/oxpus\\notes/controller/main.php"
--- "[ORIGINAL]/oxpus\\notes/controller/main.php"
+++ "[FORUM_EXT]/oxpus\\notes/controller/main.php"
@@ -17,6 +17,7 @@ class main
 	protected $db;
 	protected $config;
 	protected $helper;
+	protected $auth;
 	protected $request;
 	protected $template;
 	protected $user;
@@ -31,6 +32,7 @@ class main
 	* @param \phpbb\db\driver\driver_interfacer		$db
 	* @param \phpbb\config\config					$config
 	* @param \phpbb\controller\helper				$helper
+	* @param \phpbb\auth\auth						$auth
 	* @param \phpbb\request\request_interface 		$request
 	* @param \phpbb\template\template				$template
 	* @param \phpbb\user							$user
@@ -43,6 +45,7 @@ class main
 		\phpbb\db\driver\driver_interface $db,
 		\phpbb\config\config $config,
 		\phpbb\controller\helper $helper,
+		\phpbb\auth\auth $auth,
 		\phpbb\request\request_interface $request,
 		\phpbb\template\template $template,
 		\phpbb\user $user,
@@ -55,19 +58,19 @@ class main
 		$this->db 						= $db;
 		$this->config 					= $config;
 		$this->helper 					= $helper;
+		$this->auth						= $auth;
 		$this->request					= $request;
 		$this->template 				= $template;
 		$this->user 					= $user;
 		$this->language					= $language;
-
 		$this->notes_table				= $notes_table;
 	}
 
 	public function handle()
 	{
-		if ( !$this->user->data['is_registered'] )
+		if (!$this->auth->acl_get('u_notes'))
 		{
-			redirect($this->root_path . 'index.' . $this->php_ext);
+			throw new \phpbb\exception\http_exception(404, 'PAGE_NOT_FOUND');
 		}
 
 		include_once($this->root_path . 'includes/functions_user.' . $this->php_ext);
@@ -82,7 +85,7 @@ class main
 		* Get the variable contents
 		*/
 		$cancel				= $this->request->variable('cancel', '');
-		$sql_order			= $this->request->variable('sort_order', 'ASC');
+		$sql_order			= $this->request->variable('sort_order', 'DESC');
 		$sql_order_by		= $this->request->variable('sort_by', 'note_time');
 		$search_keywords	= $this->request->variable('search_string', '', true);
 		$sql_search_in		= $this->request->variable('search_in', '');
@@ -107,7 +110,17 @@ class main
 		$notes_data = [];
 		$display_notes = 0;
 
+		/*
+		* Output page header
+		*/
+		if ( $this->user->data['user_popup_notes'] == true )
+		{
+			$this->template->assign_var('S_NOTES_POPUP', true);
+		}
+
 		if ($mode == 'delete')
+		{
+			if (confirm_box(true))
 			{
 				$sql = 'DELETE FROM ' . $this->notes_table . '
 						WHERE ' . $this->db->sql_build_array('SELECT', [
@@ -115,16 +128,13 @@ class main
 							'note_user_id' => $this->user->data['user_id'],
 						]);
 				$this->db->sql_query($sql);
-
-			$mode = '';
 			}
-
-		/*
-		* Output page header
-		*/
-		if ( $this->user->data['user_popup_notes'] == true )
+			else 
 			{
-			$this->template->assign_var('S_NOTES_POPUP', true);
+				confirm_box(false, $this->language->lang('NOTES_DELETE_CONFIRM'), '', 'note_confirm_body.html');
+			}
+
+			$mode = '';
 		}
 
 		/*
@@ -227,8 +237,8 @@ class main
 			}
 
 			$sql_notes_ary = [
-				'note_subject'	=> $note_subject,
-				'note_text'		=> $note_message,
+				'note_subject'  => utf8_encode_ucr($note_subject),
+				'note_text'     => utf8_encode_ucr($note_message),
 				'note_uid'      => $uid,
 				'note_bitfield' => $bitfield,
 				'note_flags'    => $flags,
@@ -435,6 +445,8 @@ class main
 			'S_NOTES_FORM_ACTION'	=> $this->helper->route('oxpus_notes_controller'),
 
 			'U_NEW_NOTE'			=> $this->helper->route('oxpus_notes_controller', ['mode' => 'new_note']),
+
+			'S_SHOW_BUTTON'			=> ($total_notes) ? true : false,
 		]);
 
 		/*
@@ -492,6 +504,7 @@ class main
 						'U_EDIT_NOTE'	=> $u_edit,
 					]);
 				}
+				$this->template->assign_var('S_SHOW_BUTTON', false);
 			}
 			else
 			{
diff --git "[FORUM_EXT]/oxpus\\notes/diff_full.tmp" "[FORUM_EXT]/oxpus\\notes/diff_full.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/oxpus\\notes/diff_full.tmp"
@@ -0,0 +1,1769 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\oxpus\\notes/README.md" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\oxpus\\notes/README.md"
+deleted file mode 100644
+index 886a99d2c..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\oxpus\\notes/README.md"
++++ /dev/null
+@@ -1,24 +0,0 @@
+-ANZEIGENAME
+-===================
+-
+-# phpBB 3.1 Personal Notes Extension
+-
+-Personal notes for all users
+-
+-## Description
+-
+-Allows to manage own personal notes which can not be viewed by other users
+-
+-## Installation
+-
+-Upload the content of the folder "ext" into your forum folder /ext/.
+-After this enable the extension under "ACP" > "Customise" > "Extensions" > "Personal Notes"
+-
+-## Collaborate
+-
+-* For support visit the forum under http://phpbb3.oxpus.net
+-* To post an issue with this extention please use the bug tracker http://phpbb3.oxpus.net/downloads.php?view=bug_tracker
+-
+-## License
+-
+-[GPLv2](license.txt)
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\oxpus\\notes/config/services.yml" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/config/services.yml"
+index 776226141..c159bc16d 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\oxpus\\notes/config/services.yml"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/config/services.yml"
+@@ -11,6 +11,7 @@ services:
+             - '@dbal.conn'
+             - '@config'
+             - '@controller.helper'
++            - '@auth'
+             - '@request'
+             - '@template'
+             - '@user'
+@@ -22,6 +23,7 @@ services:
+         arguments:
+             - '@dbal.conn'
+             - '@controller.helper'
++            - '@auth'
+             - '@template'
+             - '@user'
+             - '@language'
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\oxpus\\notes/controller/main.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/controller/main.php"
+index b49c45302..85cb191dd 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\oxpus\\notes/controller/main.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/controller/main.php"
+@@ -17,6 +17,7 @@ class main
+ 	protected $db;
+ 	protected $config;
+ 	protected $helper;
++	protected $auth;
+ 	protected $request;
+ 	protected $template;
+ 	protected $user;
+@@ -31,6 +32,7 @@ class main
+ 	* @param \phpbb\db\driver\driver_interfacer		$db
+ 	* @param \phpbb\config\config					$config
+ 	* @param \phpbb\controller\helper				$helper
++	* @param \phpbb\auth\auth						$auth
+ 	* @param \phpbb\request\request_interface 		$request
+ 	* @param \phpbb\template\template				$template
+ 	* @param \phpbb\user							$user
+@@ -43,6 +45,7 @@ class main
+ 		\phpbb\db\driver\driver_interface $db,
+ 		\phpbb\config\config $config,
+ 		\phpbb\controller\helper $helper,
++		\phpbb\auth\auth $auth,
+ 		\phpbb\request\request_interface $request,
+ 		\phpbb\template\template $template,
+ 		\phpbb\user $user,
+@@ -55,19 +58,19 @@ class main
+ 		$this->db 						= $db;
+ 		$this->config 					= $config;
+ 		$this->helper 					= $helper;
++		$this->auth						= $auth;
+ 		$this->request					= $request;
+ 		$this->template 				= $template;
+ 		$this->user 					= $user;
+ 		$this->language					= $language;
+-
+ 		$this->notes_table				= $notes_table;
+ 	}
+ 
+ 	public function handle()
+ 	{
+-		if ( !$this->user->data['is_registered'] )
++		if (!$this->auth->acl_get('u_notes'))
+ 		{
+-			redirect($this->root_path . 'index.' . $this->php_ext);
++			throw new \phpbb\exception\http_exception(404, 'PAGE_NOT_FOUND');
+ 		}
+ 
+ 		include_once($this->root_path . 'includes/functions_user.' . $this->php_ext);
+@@ -82,7 +85,7 @@ class main
+ 		* Get the variable contents
+ 		*/
+ 		$cancel				= $this->request->variable('cancel', '');
+-		$sql_order			= $this->request->variable('sort_order', 'ASC');
++		$sql_order			= $this->request->variable('sort_order', 'DESC');
+ 		$sql_order_by		= $this->request->variable('sort_by', 'note_time');
+ 		$search_keywords	= $this->request->variable('search_string', '', true);
+ 		$sql_search_in		= $this->request->variable('search_in', '');
+@@ -107,18 +110,6 @@ class main
+ 		$notes_data = [];
+ 		$display_notes = 0;
+ 
+-		if ($mode == 'delete')
+-		{
+-			$sql = 'DELETE FROM ' . $this->notes_table . '
+-					WHERE ' . $this->db->sql_build_array('SELECT', [
+-						'note_id' => $note_id,
+-						'note_user_id' => $this->user->data['user_id'],
+-					]);
+-			$this->db->sql_query($sql);
+-
+-			$mode = '';
+-		}
+-
+ 		/*
+ 		* Output page header
+ 		*/
+@@ -127,6 +118,25 @@ class main
+ 			$this->template->assign_var('S_NOTES_POPUP', true);
+ 		}
+ 
++		if ($mode == 'delete')
++		{
++			if (confirm_box(true))
++			{
++				$sql = 'DELETE FROM ' . $this->notes_table . '
++						WHERE ' . $this->db->sql_build_array('SELECT', [
++							'note_id' => $note_id,
++							'note_user_id' => $this->user->data['user_id'],
++						]);
++				$this->db->sql_query($sql);
++			}
++			else 
++			{
++				confirm_box(false, $this->language->lang('NOTES_DELETE_CONFIRM'), '', 'note_confirm_body.html');
++			}
++
++			$mode = '';
++		}
++
+ 		/*
+ 		* Check the number of notes for this user
+ 		*/
+@@ -227,12 +237,12 @@ class main
+ 			}
+ 
+ 			$sql_notes_ary = [
+-				'note_subject'	=> $note_subject,
+-				'note_text'		=> $note_message,
+-				'note_uid'		=> $uid,
+-				'note_bitfield'	=> $bitfield,
+-				'note_flags'	=> $flags,
+-				'note_mem'		=> $note_mem,
++				'note_subject'  => utf8_encode_ucr($note_subject),
++				'note_text'     => utf8_encode_ucr($note_message),
++				'note_uid'      => $uid,
++				'note_bitfield' => $bitfield,
++				'note_flags'    => $flags,
++				'note_mem'      => $note_mem,
+ 				'note_memx'		=> ($note_mem) ? 1 : 0,
+ 			];
+ 
+@@ -435,6 +445,8 @@ class main
+ 			'S_NOTES_FORM_ACTION'	=> $this->helper->route('oxpus_notes_controller'),
+ 
+ 			'U_NEW_NOTE'			=> $this->helper->route('oxpus_notes_controller', ['mode' => 'new_note']),
++
++			'S_SHOW_BUTTON'			=> ($total_notes) ? true : false,
+ 		]);
+ 
+ 		/*
+@@ -492,6 +504,7 @@ class main
+ 						'U_EDIT_NOTE'	=> $u_edit,
+ 					]);
+ 				}
++				$this->template->assign_var('S_SHOW_BUTTON', false);
+ 			}
+ 			else
+ 			{
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/diff_full.tmp"
+new file mode 100644
+index 000000000..29c0e517f
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/diff_full.tmp"
+@@ -0,0 +1,108 @@
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\oxpus\\notes/README.md" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\oxpus\\notes/README.md"
++deleted file mode 100644
++index 886a99d2c..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\oxpus\\notes/README.md"
+++++ /dev/null
++@@ -1,24 +0,0 @@
++-ANZEIGENAME
++-===================
++-
++-# phpBB 3.1 Personal Notes Extension
++-
++-Personal notes for all users
++-
++-## Description
++-
++-Allows to manage own personal notes which can not be viewed by other users
++-
++-## Installation
++-
++-Upload the content of the folder "ext" into your forum folder /ext/.
++-After this enable the extension under "ACP" > "Customise" > "Extensions" > "Personal Notes"
++-
++-## Collaborate
++-
++-* For support visit the forum under http://phpbb3.oxpus.net
++-* To post an issue with this extention please use the bug tracker http://phpbb3.oxpus.net/downloads.php?view=bug_tracker
++-
++-## License
++-
++-[GPLv2](license.txt)
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\oxpus\\notes/config/services.yml" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/config/services.yml"
++index 776226141..c159bc16d 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\oxpus\\notes/config/services.yml"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/config/services.yml"
++@@ -11,6 +11,7 @@ services:
++             - '@dbal.conn'
++             - '@config'
++             - '@controller.helper'
+++            - '@auth'
++             - '@request'
++             - '@template'
++             - '@user'
++@@ -22,6 +23,7 @@ services:
++         arguments:
++             - '@dbal.conn'
++             - '@controller.helper'
+++            - '@auth'
++             - '@template'
++             - '@user'
++             - '@language'
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\oxpus\\notes/controller/main.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/controller/main.php"
++index b49c45302..85cb191dd 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\oxpus\\notes/controller/main.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/controller/main.php"
++@@ -17,6 +17,7 @@ class main
++ 	protected $db;
++ 	protected $config;
++ 	protected $helper;
+++	protected $auth;
++ 	protected $request;
++ 	protected $template;
++ 	protected $user;
++@@ -31,6 +32,7 @@ class main
++ 	* @param \phpbb\db\driver\driver_interfacer		$db
++ 	* @param \phpbb\config\config					$config
++ 	* @param \phpbb\controller\helper				$helper
+++	* @param \phpbb\auth\auth						$auth
++ 	* @param \phpbb\request\request_interface 		$request
++ 	* @param \phpbb\template\template				$template
++ 	* @param \phpbb\user							$user
++@@ -43,6 +45,7 @@ class main
++ 		\phpbb\db\driver\driver_interface $db,
++ 		\phpbb\config\config $config,
++ 		\phpbb\controller\helper $helper,
+++		\phpbb\auth\auth $auth,
++ 		\phpbb\request\request_interface $request,
++ 		\phpbb\template\template $template,
++ 		\phpbb\user $user,
++@@ -55,19 +58,19 @@ class main
++ 		$this->db 						= $db;
++ 		$this->config 					= $config;
++ 		$this->helper 					= $helper;
+++		$this->auth						= $auth;
++ 		$this->request					= $request;
++ 		$this->template 				= $template;
++ 		$this->user 					= $user;
++ 		$this->language					= $language;
++-
++ 		$this->notes_table				= $notes_table;
++ 	}
++ 
++ 	public function handle()
++ 	{
++-		if ( !$this->user->data['is_registered'] )
+++		if (!$this->auth->acl_get('u_notes'))
++ 		{
++-			redirect($this->root_path . 'index.' . $this->php_ext);
+++			throw new \phpbb\exception\http_exception(404, 'PAGE_NOT_FOUND');
++ 		}
++ 
++ 		include_once($this->root_path . 'includes/functions_user.' . $this->php_ext);
++@@ -82,7 +85,7 @@ class main
++ 		* Get the variable contents
++ 		*/
++ 		$cancel				= $this->request->variable('cancel', '');
++-		$sql_order			= $this->request->variable('sort_order', 'ASC');
+++		$sql_order			= $this->request->variable('sort_order', 'DESC');
++ 		$sql_order_by		= $this->request
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\oxpus\\notes/event/main_listener.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/event/main_listener.php"
+index 9dc7355c5..92f7220ca 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\oxpus\\notes/event/main_listener.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/event/main_listener.php"
+@@ -33,6 +33,7 @@ class main_listener implements EventSubscriberInterface
+ 
+ 	protected $db;
+ 	protected $helper;
++	protected $auth;
+ 	protected $template;
+ 	protected $user;
+ 	protected $language;
+@@ -43,6 +44,7 @@ class main_listener implements EventSubscriberInterface
+ 	*
+ 	* @param \phpbb\db\driver\driver_interfacer		$db
+ 	* @param \phpbb\controller\helper				$helper
++	* @param \phpbb\auth\auth						$auth
+ 	* @param \phpbb\template\template				$template
+ 	* @param \phpbb\user							$user
+ 	* @param \phpbb\language\language				$language
+@@ -51,6 +53,7 @@ class main_listener implements EventSubscriberInterface
+ 	public function __construct(
+ 		\phpbb\db\driver\driver_interface $db,
+ 		\phpbb\controller\helper $helper,
++		\phpbb\auth\auth $auth,
+ 		\phpbb\template\template $template,
+ 		\phpbb\user $user,
+ 		\phpbb\language\language $language,
+@@ -59,10 +62,10 @@ class main_listener implements EventSubscriberInterface
+ 	{
+ 		$this->db 						= $db;
+ 		$this->helper 					= $helper;
++		$this->auth						= $auth;
+ 		$this->template 				= $template;
+ 		$this->user 					= $user;
+ 		$this->language					= $language;
+-
+ 		$this->notes_table 				= $notes_table;
+ 	}
+ 
+@@ -80,18 +83,20 @@ class main_listener implements EventSubscriberInterface
+ 
+ 	public function add_page_header_links()
+ 	{
+-		if ($this->user->data['is_registered'])
++		if ($this->auth->acl_get('u_notes'))
+ 		{
+ 			$ext_main_link = $this->helper->route('oxpus_notes_controller');
+ 
+ 			if ($this->user->data['user_popup_notes'])
+ 			{
+ 				$u_notes_path	= "javascript:notes()";
++				$u_notes_home	= $ext_main_link;
+ 				$u_notes_popup	= $ext_main_link;
+ 			}
+ 			else
+ 			{
+ 				$u_notes_path	= $ext_main_link;
++				$u_notes_home	= $ext_main_link;
+ 				$u_notes_popup	= '';
+ 			}
+ 
+@@ -111,6 +116,7 @@ class main_listener implements EventSubscriberInterface
+ 			if ($total_note_mems)
+ 			{
+ 				$u_notes_path = (!$this->user->data['user_popup_notes']) ? $this->helper->route('oxpus_notes_controller', ['mem_drop' => 1, 'mem_time' => $cur_time]) : $u_notes_path;
++				$u_notes_home = ($this->user->data['user_popup_notes']) ? $this->helper->route('oxpus_notes_controller', ['mem_drop' => 1, 'mem_time' => $cur_time]) : $u_notes_home;
+ 				$u_notes_popup = ($this->user->data['user_popup_notes']) ? $this->helper->route('oxpus_notes_controller', ['mem_drop' => 1, 'mem_time' => $cur_time]) : '';
+ 
+ 				$this->template->assign_var('S_NOTES_MEM', true);
+@@ -120,8 +126,9 @@ class main_listener implements EventSubscriberInterface
+ 			}
+ 
+ 			$this->template->assign_vars([
+-				'U_NOTES_PATH'	=> $u_notes_path,
+-				'U_NOTES_POPUP'	=> ($this->user->data['user_popup_notes']) ? str_replace('&amp;', '&', $u_notes_popup) : $u_notes_popup,
++				'U_NOTES_PATH'			=> $u_notes_path,
++				'U_NOTES_HOME'			=> $u_notes_home,
++				'U_NOTES_POPUP'			=> ($this->user->data['user_popup_notes']) ? str_replace('&amp;', '&', $u_notes_popup) : $u_notes_popup,
+ 			]);
+ 		}
+ 	}
+@@ -152,6 +159,7 @@ class main_listener implements EventSubscriberInterface
+ 
+ 		$permission = $event['permissions'];
+ 		$permission['a_notes'] = ['lang' => 'ACL_A_NOTES', 'cat' => 'notes'];
++		$permission['u_notes'] = ['lang' => 'ACL_U_NOTES', 'cat' => 'misc'];
+ 		$event['permissions'] = $permission;
+ 	}
+ }
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\oxpus\\notes/ext.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/ext.php"
+index 201d0c43d..ab4e45a99 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\oxpus\\notes/ext.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/ext.php"
+@@ -1,5 +1,4 @@
+ <?php
+-
+ /**
+ *
+ * @package phpBB Extension - Personal Notes
+@@ -12,4 +11,61 @@ namespace oxpus\notes;
+ 
+ class ext extends \phpbb\extension\base
+ {
++	/**
++	 * Check whether or not the extension can be enabled.
++	 * The current phpBB version should meet or exceed
++	 * the minimum version required by this extension:
++	 *
++	 * Requires phpBB 3.3.0 and PHP 7.3.0.
++	 *
++	 * @return bool
++	 * @access public
++	 */
++	public function is_enableable()
++	{
++		if (!version_compare(PHP_VERSION, '7.3.0', '>='))
++		{
++			$this->container->get('user')->add_lang_ext('oxpus/notes', 'info_acp_notes');
++			return [$this->container->get('user')->lang('PHP_ERROR')];
++		}
++
++		if (!phpbb_version_compare(PHPBB_VERSION, '3.3.0', '>='))
++		{
++			$this->container->get('user')->add_lang_ext('oxpus/notes', 'info_acp_notes');
++			return [$this->container->get('user')->lang('PHPBB_ERROR')];
++		}
++
++		return true;
++	}
++
++	/**
++	 * @param mixed $old_state State returned by previous call of this method
++	 * @return mixed Returns false after last step, otherwise temporary state
++	 * @access public
++	 */
++	function enable_step($old_state)
++	{
++		switch ($old_state)
++		{
++			case '': // Empty means nothing has run yet
++				if (empty($old_state))
++				{
++					$this->container->get('user')->add_lang_ext('oxpus/notes', 'info_acp_notes');
++					$this->container->get('template')->assign_var('L_EXTENSION_ENABLE_SUCCESS', $this->container->get('user')->lang['EXTENSION_ENABLE_SUCCESS'] . 
++					(isset($this->container->get('user')->lang['NOTES_NOTICE']) ? $this->container->get('user')->lang['NOTES_NOTICE'] : ''));
++				}
++
++				// Run parent enable step method
++				return parent::enable_step($old_state);
++			
++			break;
++			
++			default:
++			
++				// Run parent enable step method
++				return parent::enable_step($old_state);
++				
++			break;
++		}
++	}
+ }
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\oxpus\\notes/language/de/common.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\oxpus\\notes/language/de/common.php"
+deleted file mode 100644
+index 7b997e599..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\oxpus\\notes/language/de/common.php"
++++ /dev/null
+@@ -1,45 +0,0 @@
+-<?php
+-
+-/**
+-*
+-* @package phpBB Extension - Personal Notes
+-* @copyright (c) 2014 OXPUS - www.oxpus.net
+-* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+-*
+-*/
+-
+-/*
+-* [ german ] language file
+-*/
+-
+-/**
+-* DO NOT CHANGE
+-*/
+-if (!defined('IN_PHPBB'))
+-{
+-	exit;
+-}
+-
+-if (empty($lang) || !is_array($lang))
+-{
+-	$lang = [];
+-}
+-
+-$lang = array_merge($lang, [
+-	'ACP_NOTES'				=> 'Notizen einstellen',
+-	'ACP_NOTES_SETTINGS'	=> 'Max. Anzahl Notizen je Benutzer',
+-	'UCP_NOTES'				=> 'Notizen',
+-	'UCP_NOTES_CONFIG'		=> 'Einstellungen',
+-
+-	'NOTES'				=> 'Notizen',
+-	'POPUP_NOTES'		=> 'Zeige persönliche Notizen als Popup',
+-	'SLIDE_NOTES'		=> 'Notizen als Titelliste öffnen, Anzeigen per Klick auf den Titel',
+-	'FILTER_NOTES'		=> '<strong>Filteranzeige</strong><br />Klicke erneut auf den Such-Button oder ändere die Sortierung, um alle Notizen anzuzeigen.',
+-	'NOTES_MEM'			=> 'An Notiz erinnern',
+-	'NOTES_MEM_TIME'	=> 'Erinnerungszeit',
+-	'NOTES_MEMTEXT'		=> '<strong>Du hast Notizen erfasst, an die Du erinnert werden wolltest.</strong><br />%sKlicke hier, um diese Notizen anzuzeigen.%s<br />(Du wirst danach nicht mehr an diese Notizen erinnert)',
+-	'NO_NOTES'			=> 'Du hast zur Zeit keine Notizen',
+-
+-	'NOTES_CONFIG_SUCCESSFULL'	=> 'Die Einstellungen der Notizen wurden erfolgreich gespeichert.',
+-	'NOTES_LOG_CONFIG'			=> 'Anzahl Notizen je Benutzer geändert',
+-]);
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\oxpus\\notes/language/de/email/main_mail.txt" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\oxpus\\notes/language/de/email/main_mail.txt"
+deleted file mode 100644
+index f0c9e8b89..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\oxpus\\notes/language/de/email/main_mail.txt"
++++ /dev/null
+@@ -1,8 +0,0 @@
+-Subject: SUBJECT
+-
+-Hallo {USERNAME},
+-
+-TEXT
+-
+-
+-{BOARD_EMAIL}
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\oxpus\\notes/language/en/common.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/language/en/common.php"
+index ac11480c8..903cf3f21 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\oxpus\\notes/language/en/common.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/language/en/common.php"
+@@ -32,14 +32,21 @@ $lang = array_merge($lang, [
+ 	'UCP_NOTES_CONFIG'		=> 'Settings',
+ 
+ 	'NOTES'				=> 'Notes',
++	'NEW_NOTE'			=> 'New note',
++	'POST_NEW_NOTE'		=> 'Post a new note',
+ 	'POPUP_NOTES'		=> 'Display Personal Notes as Popup',
+ 	'SLIDE_NOTES'		=> 'Open notes as title list, display by clicking the title',
+ 	'FILTER_NOTES'		=> '<strong>Filter mode</strong><br />Press the search button again or change the sort method to display all notes.',
+-	'NOTES_MEM'			=> 'Remember note',
+-	'NOTES_MEM_TIME'	=> 'Remember time',
++	'NOTES_MEM'			=> 'Set a reminder',
++	'NOTES_MEM_ENABLE'	=> 'Yes remind me!',
++	'NOTES_MEM_TIME'	=> 'Set date and time',
+ 	'NOTES_MEMTEXT'		=> '<strong>You have entered notes with a reminder.</strong><br />%sClick here to list these notes.%s<br />(Clicking will remove the reminder)',
+ 	'NO_NOTES'			=> 'You currently have no notes',
+ 
++	'NOTES_DISCLAIMER'  		=> '**Notes you see here cannot be seen by anyone else, including administrators and moderators. If you have any questions or concerns, please contact a Board Administrator.',
++	'NOTES_DISCLAIMER_POPUP'	=> '**Notes you see here cannot be seen by anyone else, including administrators and moderators.',
++
+ 	'NOTES_CONFIG_SUCCESSFULL'	=> 'The settings for the notes are saved successfully.',
++	'NOTES_DELETE_CONFIRM'		=> 'Are you sure you want to delete this note?',
+ 	'NOTES_LOG_CONFIG'			=> 'Change number of notes per user',
+ ]);
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\oxpus\\notes/language/en/email/main_mail.txt" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/language/en/email/main_mail.txt"
+index a4c64aa3d..3e7ef246c 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\oxpus\\notes/language/en/email/main_mail.txt"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/language/en/email/main_mail.txt"
+@@ -1,8 +1,8 @@
+ Subject: SUBJECT
+ 
+-Hello {USERNAME},
++Hello {{ USERNAME }},
+ 
+ TEXT
+ 
+ 
+-{BOARD_EMAIL}
+\ No newline at end of file
++{{ BOARD_EMAIL }}
+\ No newline at end of file
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/language/en/info_acp_notes.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/language/en/info_acp_notes.php"
+new file mode 100644
+index 000000000..9832f319e
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/language/en/info_acp_notes.php"
+@@ -0,0 +1,43 @@
++<?php
++/**
++*
++* @package phpBB Extension - Personal Notes
++* @copyright (c) 2014 OXPUS - www.oxpus.net
++* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
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
++	$lang = [];
++}
++
++/// DEVELOPERS PLEASE NOTE
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
++	'NOTES_NOTICE'				    => '<div class="phpinfo"><p>Make sure to check the Group permission and adjust it as needed. By default the Registered user group doesn\'t have access personal notes.</p></div></p></div>',
++	'PHP_ERROR' 	=> 'This extension requires PHP 7.3.0 (or greater).',
++	'PHPBB_ERROR' 	=> 'This extension requires phpBB 3.3.0 (or greater).',
++]);
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\oxpus\\notes/language/en/permissions_notes.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/language/en/permissions_notes.php"
+index 05d3f6832..fccd73c7c 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\oxpus\\notes/language/en/permissions_notes.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/language/en/permissions_notes.php"
+@@ -30,4 +30,5 @@ $lang = array_merge($lang, [
+ 	'ACP_NOTES'		=> 'Notes',
+ 
+ 	'ACL_A_NOTES'	=> 'Can configure personal notes',
++	'ACL_U_NOTES'	=> 'Can use personal notes',
+ ]);
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/language/pt/common.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/language/pt/common.php"
+new file mode 100644
+index 000000000..5b2d8ce31
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/language/pt/common.php"
+@@ -0,0 +1,52 @@
++<?php
++
++/**
++*
++* @package phpBB Extension - Personal Notes
++* @copyright (c) 2014 OXPUS - www.oxpus.net
++* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
++*
++*/
++
++/*
++* [ english ] language file
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
++	$lang = [];
++}
++
++$lang = array_merge($lang, [
++	'ACP_NOTES'				=> 'Configurar Notas',
++	'ACP_NOTES_SETTINGS'	=> 'Número máximo de notas por utilizador',
++	'UCP_NOTES'				=> 'Notas',
++	'UCP_NOTES_CONFIG'		=> 'Configurações',
++
++	'NOTES'				=> 'Notas',
++	'NEW_NOTE'			=> 'Nova nota',
++	'POST_NEW_NOTE'		=> 'Adicionar nova nota',
++	'POPUP_NOTES'		=> 'Exibir Notas Pessoais como Popup',
++	'SLIDE_NOTES'		=> 'Abrir notas com lista de títulos, exibir ao clicar no título',
++	'FILTER_NOTES'		=> '<strong>Modo Filtrado</strong><br />Pressiona o botão de pesquisa novamente ou altera a ordenação para mostrar todas as notas.',
++	'NOTES_MEM'			=> 'Adicionar lembrete!',
++	'NOTES_MEM_ENABLE'	=> 'Sim, lembra-me!',
++	'NOTES_MEM_TIME'	=> 'Colocar data e hora',
++	'NOTES_MEMTEXT'		=> '<strong>Introduziste notas com lembretes.</strong><br />%sClica aqui para listas essas notas.%s<br />(Clicar irá remover o lembrete)',
++	'NO_NOTES'			=> 'Não tens quaisquer notas',
++
++	'NOTES_DISCLAIMER'  		=> '**As notas que aqui vês só podem ser vistas por ti, e isso inclui moderadores e administradores. Se tiveres alguma dúvida ou preocupações, por favor, contacta a Administração.',
++	'NOTES_DISCLAIMER_POPUP'	=> '**As notas que aqui vês só podem ser vistas por ti, e isso inclui moderadores e administradores.',
++
++	'NOTES_CONFIG_SUCCESSFULL'	=> 'As configurações das notas foram guardadas com sucesso.',
++	'NOTES_DELETE_CONFIRM'		=> 'Tens a certeza que desejas apagar esta nota?',
++	'NOTES_LOG_CONFIG'			=> 'Alterar número de notas por utilizador',
++]);
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/language/pt/email/main_mail.txt" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/language/pt/email/main_mail.txt"
+new file mode 100644
+index 000000000..57246e2b6
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/language/pt/email/main_mail.txt"
+@@ -0,0 +1,8 @@
++Subject: SUBJECT
++
++Olá {{ USERNAME }},
++
++TEXT
++
++
++{{ BOARD_EMAIL }}
+\ No newline at end of file
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/language/pt/info_acp_notes.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/language/pt/info_acp_notes.php"
+new file mode 100644
+index 000000000..9832f319e
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/language/pt/info_acp_notes.php"
+@@ -0,0 +1,43 @@
++<?php
++/**
++*
++* @package phpBB Extension - Personal Notes
++* @copyright (c) 2014 OXPUS - www.oxpus.net
++* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
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
++	$lang = [];
++}
++
++/// DEVELOPERS PLEASE NOTE
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
++	'NOTES_NOTICE'				    => '<div class="phpinfo"><p>Make sure to check the Group permission and adjust it as needed. By default the Registered user group doesn\'t have access personal notes.</p></div></p></div>',
++	'PHP_ERROR' 	=> 'This extension requires PHP 7.3.0 (or greater).',
++	'PHPBB_ERROR' 	=> 'This extension requires phpBB 3.3.0 (or greater).',
++]);
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/language/pt/permissions_notes.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/language/pt/permissions_notes.php"
+new file mode 100644
+index 000000000..44b588c10
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/language/pt/permissions_notes.php"
+@@ -0,0 +1,34 @@
++<?php
++
++/**
++*
++* @package phpBB Extension - Personal notes
++* @copyright (c) 2014 OXPUS - www.oxpus.net
++* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
++*
++*/
++
++/**
++* Language pack for Extension permissions [English]
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
++	$lang = [];
++}
++
++// Permissions
++$lang = array_merge($lang, [
++	'ACP_NOTES'		=> 'Notas',
++
++	'ACL_A_NOTES'	=> 'Pode configurar notas pessoais',
++	'ACL_U_NOTES'	=> 'Pode usar notas pessoais',
++]);
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/language/pt-preao/common.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/language/pt-preao/common.php"
+new file mode 100644
+index 000000000..5b2d8ce31
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/language/pt-preao/common.php"
+@@ -0,0 +1,52 @@
++<?php
++
++/**
++*
++* @package phpBB Extension - Personal Notes
++* @copyright (c) 2014 OXPUS - www.oxpus.net
++* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
++*
++*/
++
++/*
++* [ english ] language file
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
++	$lang = [];
++}
++
++$lang = array_merge($lang, [
++	'ACP_NOTES'				=> 'Configurar Notas',
++	'ACP_NOTES_SETTINGS'	=> 'Número máximo de notas por utilizador',
++	'UCP_NOTES'				=> 'Notas',
++	'UCP_NOTES_CONFIG'		=> 'Configurações',
++
++	'NOTES'				=> 'Notas',
++	'NEW_NOTE'			=> 'Nova nota',
++	'POST_NEW_NOTE'		=> 'Adicionar nova nota',
++	'POPUP_NOTES'		=> 'Exibir Notas Pessoais como Popup',
++	'SLIDE_NOTES'		=> 'Abrir notas com lista de títulos, exibir ao clicar no título',
++	'FILTER_NOTES'		=> '<strong>Modo Filtrado</strong><br />Pressiona o botão de pesquisa novamente ou altera a ordenação para mostrar todas as notas.',
++	'NOTES_MEM'			=> 'Adicionar lembrete!',
++	'NOTES_MEM_ENABLE'	=> 'Sim, lembra-me!',
++	'NOTES_MEM_TIME'	=> 'Colocar data e hora',
++	'NOTES_MEMTEXT'		=> '<strong>Introduziste notas com lembretes.</strong><br />%sClica aqui para listas essas notas.%s<br />(Clicar irá remover o lembrete)',
++	'NO_NOTES'			=> 'Não tens quaisquer notas',
++
++	'NOTES_DISCLAIMER'  		=> '**As notas que aqui vês só podem ser vistas por ti, e isso inclui moderadores e administradores. Se tiveres alguma dúvida ou preocupações, por favor, contacta a Administração.',
++	'NOTES_DISCLAIMER_POPUP'	=> '**As notas que aqui vês só podem ser vistas por ti, e isso inclui moderadores e administradores.',
++
++	'NOTES_CONFIG_SUCCESSFULL'	=> 'As configurações das notas foram guardadas com sucesso.',
++	'NOTES_DELETE_CONFIRM'		=> 'Tens a certeza que desejas apagar esta nota?',
++	'NOTES_LOG_CONFIG'			=> 'Alterar número de notas por utilizador',
++]);
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/language/pt-preao/email/main_mail.txt" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/language/pt-preao/email/main_mail.txt"
+new file mode 100644
+index 000000000..57246e2b6
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/language/pt-preao/email/main_mail.txt"
+@@ -0,0 +1,8 @@
++Subject: SUBJECT
++
++Olá {{ USERNAME }},
++
++TEXT
++
++
++{{ BOARD_EMAIL }}
+\ No newline at end of file
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/language/pt-preao/info_acp_notes.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/language/pt-preao/info_acp_notes.php"
+new file mode 100644
+index 000000000..9832f319e
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/language/pt-preao/info_acp_notes.php"
+@@ -0,0 +1,43 @@
++<?php
++/**
++*
++* @package phpBB Extension - Personal Notes
++* @copyright (c) 2014 OXPUS - www.oxpus.net
++* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
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
++	$lang = [];
++}
++
++/// DEVELOPERS PLEASE NOTE
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
++	'NOTES_NOTICE'				    => '<div class="phpinfo"><p>Make sure to check the Group permission and adjust it as needed. By default the Registered user group doesn\'t have access personal notes.</p></div></p></div>',
++	'PHP_ERROR' 	=> 'This extension requires PHP 7.3.0 (or greater).',
++	'PHPBB_ERROR' 	=> 'This extension requires phpBB 3.3.0 (or greater).',
++]);
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\oxpus\\notes/language/de/permissions_notes.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/language/pt-preao/permissions_notes.php"
+similarity index 67%
+rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\oxpus\\notes/language/de/permissions_notes.php"
+rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/language/pt-preao/permissions_notes.php"
+index ce3c705da..44b588c10 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\oxpus\\notes/language/de/permissions_notes.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/language/pt-preao/permissions_notes.php"
+@@ -9,7 +9,7 @@
+ */
+ 
+ /**
+-* Language pack for Extension permissions [German]
++* Language pack for Extension permissions [English]
+ */
+ 
+ /**
+@@ -27,6 +27,8 @@ if (empty($lang) || !is_array($lang))
+ 
+ // Permissions
+ $lang = array_merge($lang, [
+-	'ACP_NOTES'		=> 'Notizen',
+-	'ACL_A_NOTES'	=> 'Kann die persönlichen Notizen einstellen',
++	'ACP_NOTES'		=> 'Notas',
++
++	'ACL_A_NOTES'	=> 'Pode configurar notas pessoais',
++	'ACL_U_NOTES'	=> 'Pode usar notas pessoais',
+ ]);
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\oxpus\\notes/license.txt" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\oxpus\\notes/license.txt"
+deleted file mode 100644
+index ce992b2ce..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\oxpus\\notes/license.txt"
++++ /dev/null
+@@ -1,281 +0,0 @@
+-		    GNU GENERAL PUBLIC LICENSE
+-		       Version 2, June 1991
+-
+- Copyright (C) 1989, 1991 Free Software Foundation, Inc.
+-                          675 Mass Ave, Cambridge, MA 02139, USA
+- Everyone is permitted to copy and distribute verbatim copies
+- of this license document, but changing it is not allowed.
+-
+-			    Preamble
+-
+-  The licenses for most software are designed to take away your
+-freedom to share and change it.  By contrast, the GNU General Public
+-License is intended to guarantee your freedom to share and change free
+-software--to make sure the software is free for all its users.  This
+-General Public License applies to most of the Free Software
+-Foundation's software and to any other program whose authors commit to
+-using it.  (Some other Free Software Foundation software is covered by
+-the GNU Library General Public License instead.)  You can apply it to
+-your programs, too.
+-
+-  When we speak of free software, we are referring to freedom, not
+-price.  Our General Public Licenses are designed to make sure that you
+-have the freedom to distribute copies of free software (and charge for
+-this service if you wish), that you receive source code or can get it
+-if you want it, that you can change the software or use pieces of it
+-in new free programs; and that you know you can do these things.
+-
+-  To protect your rights, we need to make restrictions that forbid
+-anyone to deny you these rights or to ask you to surrender the rights.
+-These restrictions translate to certain responsibilities for you if you
+-distribute copies of the software, or if you modify it.
+-
+-  For example, if you distribute copies of such a program, whether
+-gratis or for a fee, you must give the recipients all the rights that
+-you have.  You must make sure that they, too, receive or can get the
+-source code.  And you must show them these terms so they know their
+-rights.
+-
+-  We protect your rights with two steps: (1) copyright the software, and
+-(2) offer you this license which gives you legal permission to copy,
+-distribute and/or modify the software.
+-
+-  Also, for each author's protection and ours, we want to make certain
+-that everyone understands that there is no warranty for this free
+-software.  If the software is modified by someone else and passed on, we
+-want its recipients to know that what they have is not the original, so
+-that any problems introduced by others will not reflect on the original
+-authors' reputations.
+-
+-  Finally, any free program is threatened constantly by software
+-patents.  We wish to avoid the danger that redistributors of a free
+-program will individually obtain patent licenses, in effect making the
+-program proprietary.  To prevent this, we have made it clear that any
+-patent must be licensed for everyone's free use or not licensed at all.
+-
+-  The precise terms and conditions for copying, distribution and
+-modification follow.
+-
+-		    GNU GENERAL PUBLIC LICENSE
+-   TERMS AND CONDITIONS FOR COPYING, DISTRIBUTION AND MODIFICATION
+-
+-  0. This License applies to any program or other work which contains
+-a notice placed by the copyright holder saying it may be distributed
+-under the terms of this General Public License.  The "Program", below,
+-refers to any such program or work, and a "work based on the Program"
+-means either the Program or any derivative work under copyright law:
+-that is to say, a work containing the Program or a portion of it,
+-either verbatim or with modifications and/or translated into another
+-language.  (Hereinafter, translation is included without limitation in
+-the term "modification".)  Each licensee is addressed as "you".
+-
+-Activities other than copying, distribution and modification are not
+-covered by this License; they are outside its scope.  The act of
+-running the Program is not restricted, and the output from the Program
+-is covered only if its contents constitute a work based on the
+-Program (independent of having been made by running the Program).
+-Whether that is true depends on what the Program does.
+-
+-  1. You may copy and distribute verbatim copies of the Program's
+-source code as you receive it, in any medium, provided that you
+-conspicuously and appropriately publish on each copy an appropriate
+-copyright notice and disclaimer of warranty; keep intact all the
+-notices that refer to this License and to the absence of any warranty;
+-and give any other recipients of the Program a copy of this License
+-along with the Program.
+-
+-You may charge a fee for the physical act of transferring a copy, and
+-you may at your option offer warranty protection in exchange for a fee.
+-
+-  2. You may modify your copy or copies of the Program or any portion
+-of it, thus forming a work based on the Program, and copy and
+-distribute such modifications or work under the terms of Section 1
+-above, provided that you also meet all of these conditions:
+-
+-    a) You must cause the modified files to carry prominent notices
+-    stating that you changed the files and the date of any change.
+-
+-    b) You must cause any work that you distribute or publish, that in
+-    whole or in part contains or is derived from the Program or any
+-    part thereof, to be licensed as a whole at no charge to all third
+-    parties under the terms of this License.
+-
+-    c) If the modified program normally reads commands interactively
+-    when run, you must cause it, when started running for such
+-    interactive use in the most ordinary way, to print or display an
+-    announcement including an appropriate copyright notice and a
+-    notice that there is no warranty (or else, saying that you provide
+-    a warranty) and that users may redistribute the program under
+-    these conditions, and telling the user how to view a copy of this
+-    License.  (Exception: if the Program itself is interactive but
+-    does not normally print such an announcement, your work based on
+-    the Program is not required to print an announcement.)
+-
+-These requirements apply to the modified work as a whole.  If
+-identifiable sections of that work are not derived from the Program,
+-and can be reasonably considered independent and separate works in
+-themselves, then this License, and its terms, do not apply to those
+-sections when you distribute them as separate works.  But when you
+-distribute the same sections as part of a whole which is a work based
+-on the Program, the distribution of the whole must be on the terms of
+-this License, whose permissions for other licensees extend to the
+-entire whole, and thus to each and every part regardless of who wrote it.
+-
+-Thus, it is not the intent of this section to claim rights or contest
+-your rights to work written entirely by you; rather, the intent is to
+-exercise the right to control the distribution of derivative or
+-collective works based on the Program.
+-
+-In addition, mere aggregation of another work not based on the Program
+-with the Program (or with a work based on the Program) on a volume of
+-a storage or distribution medium does not bring the other work under
+-the scope of this License.
+-
+-  3. You may copy and distribute the Program (or a work based on it,
+-under Section 2) in object code or executable form under the terms of
+-Sections 1 and 2 above provided that you also do one of the following:
+-
+-    a) Accompany it with the complete corresponding machine-readable
+-    source code, which must be distributed under the terms of Sections
+-    1 and 2 above on a medium customarily used for software interchange; or,
+-
+-    b) Accompany it with a written offer, valid for at least three
+-    years, to give any third party, for a charge no more than your
+-    cost of physically performing source distribution, a complete
+-    machine-readable copy of the corresponding source code, to be
+-    distributed under the terms of Sections 1 and 2 above on a medium
+-    customarily used for software interchange; or,
+-
+-    c) Accompany it with the information you received as to the offer
+-    to distribute corresponding source code.  (This alternative is
+-    allowed only for noncommercial distribution and only if you
+-    received the program in object code or executable form with such
+-    an offer, in accord with Subsection b above.)
+-
+-The source code for a work means the preferred form of the work for
+-making modifications to it.  For an executable work, complete source
+-code means all the source code for all modules it contains, plus any
+-associated interface definition files, plus the scripts used to
+-control compilation and installation of the executable.  However, as a
+-special exception, the source code distributed need not include
+-anything that is normally distributed (in either source or binary
+-form) with the major components (compiler, kernel, and so on) of the
+-operating system on which the executable runs, unless that component
+-itself accompanies the executable.
+-
+-If distribution of executable or object code is made by offering
+-access to copy from a designated place, then offering equivalent
+-access to copy the source code from the same place counts as
+-distribution of the source code, even though third parties are not
+-compelled to copy the source along with the object code.
+-
+-  4. You may not copy, modify, sublicense, or distribute the Program
+-except as expressly provided under this License.  Any attempt
+-otherwise to copy, modify, sublicense or distribute the Program is
+-void, and will automatically terminate your rights under this License.
+-However, parties who have received copies, or rights, from you under
+-this License will not have their licenses terminated so long as such
+-parties remain in full compliance.
+-
+-  5. You are not required to accept this License, since you have not
+-signed it.  However, nothing else grants you permission to modify or
+-distribute the Program or its derivative works.  These actions are
+-prohibited by law if you do not accept this License.  Therefore, by
+-modifying or distributing the Program (or any work based on the
+-Program), you indicate your acceptance of this License to do so, and
+-all its terms and conditions for copying, distributing or modifying
+-the Program or works based on it.
+-
+-  6. Each time you redistribute the Program (or any work based on the
+-Program), the recipient automatically receives a license from the
+-original licensor to copy, distribute or modify the Program subject to
+-these terms and conditions.  You may not impose any further
+-restrictions on the recipients' exercise of the rights granted herein.
+-You are not responsible for enforcing compliance by third parties to
+-this License.
+-
+-  7. If, as a consequence of a court judgment or allegation of patent
+-infringement or for any other reason (not limited to patent issues),
+-conditions are imposed on you (whether by court order, agreement or
+-otherwise) that contradict the conditions of this License, they do not
+-excuse you from the conditions of this License.  If you cannot
+-distribute so as to satisfy simultaneously your obligations under this
+-License and any other pertinent obligations, then as a consequence you
+-may not distribute the Program at all.  For example, if a patent
+-license would not permit royalty-free redistribution of the Program by
+-all those who receive copies directly or indirectly through you, then
+-the only way you could satisfy both it and this License would be to
+-refrain entirely from distribution of the Program.
+-
+-If any portion of this section is held invalid or unenforceable under
+-any particular circumstance, the balance of the section is intended to
+-apply and the section as a whole is intended to apply in other
+-circumstances.
+-
+-It is not the purpose of this section to induce you to infringe any
+-patents or other property right claims or to contest validity of any
+-such claims; this section has the sole purpose of protecting the
+-integrity of the free software distribution system, which is
+-implemented by public license practices.  Many people have made
+-generous contributions to the wide range of software distributed
+-through that system in reliance on consistent application of that
+-system; it is up to the author/donor to decide if he or she is willing
+-to distribute software through any other system and a licensee cannot
+-impose that choice.
+-
+-This section is intended to make thoroughly clear what is believed to
+-be a consequence of the rest of this License.
+-
+-  8. If the distribution and/or use of the Program is restricted in
+-certain countries either by patents or by copyrighted interfaces, the
+-original copyright holder who places the Program under this License
+-may add an explicit geographical distribution limitation excluding
+-those countries, so that distribution is permitted only in or among
+-countries not thus excluded.  In such case, this License incorporates
+-the limitation as if written in the body of this License.
+-
+-  9. The Free Software Foundation may publish revised and/or new versions
+-of the General Public License from time to time.  Such new versions will
+-be similar in spirit to the present version, but may differ in detail to
+-address new problems or concerns.
+-
+-Each version is given a distinguishing version number.  If the Program
+-specifies a version number of this License which applies to it and "any
+-later version", you have the option of following the terms and conditions
+-either of that version or of any later version published by the Free
+-Software Foundation.  If the Program does not specify a version number of
+-this License, you may choose any version ever published by the Free Software
+-Foundation.
+-
+-  10. If you wish to incorporate parts of the Program into other free
+-programs whose distribution conditions are different, write to the author
+-to ask for permission.  For software which is copyrighted by the Free
+-Software Foundation, write to the Free Software Foundation; we sometimes
+-make exceptions for this.  Our decision will be guided by the two goals
+-of preserving the free status of all derivatives of our free software and
+-of promoting the sharing and reuse of software generally.
+-
+-			    NO WARRANTY
+-
+-  11. BECAUSE THE PROGRAM IS LICENSED FREE OF CHARGE, THERE IS NO WARRANTY
+-FOR THE PROGRAM, TO THE EXTENT PERMITTED BY APPLICABLE LAW.  EXCEPT WHEN
+-OTHERWISE STATED IN WRITING THE COPYRIGHT HOLDERS AND/OR OTHER PARTIES
+-PROVIDE THE PROGRAM "AS IS" WITHOUT WARRANTY OF ANY KIND, EITHER EXPRESSED
+-OR IMPLIED, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF
+-MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE.  THE ENTIRE RISK AS
+-TO THE QUALITY AND PERFORMANCE OF THE PROGRAM IS WITH YOU.  SHOULD THE
+-PROGRAM PROVE DEFECTIVE, YOU ASSUME THE COST OF ALL NECESSARY SERVICING,
+-REPAIR OR CORRECTION.
+-
+-  12. IN NO EVENT UNLESS REQUIRED BY APPLICABLE LAW OR AGREED TO IN WRITING
+-WILL ANY COPYRIGHT HOLDER, OR ANY OTHER PARTY WHO MAY MODIFY AND/OR
+-REDISTRIBUTE THE PROGRAM AS PERMITTED ABOVE, BE LIABLE TO YOU FOR DAMAGES,
+-INCLUDING ANY GENERAL, SPECIAL, INCIDENTAL OR CONSEQUENTIAL DAMAGES ARISING
+-OUT OF THE USE OR INABILITY TO USE THE PROGRAM (INCLUDING BUT NOT LIMITED
+-TO LOSS OF DATA OR DATA BEING RENDERED INACCURATE OR LOSSES SUSTAINED BY
+-YOU OR THIRD PARTIES OR A FAILURE OF THE PROGRAM TO OPERATE WITH ANY OTHER
+-PROGRAMS), EVEN IF SUCH HOLDER OR OTHER PARTY HAS BEEN ADVISED OF THE
+-POSSIBILITY OF SUCH DAMAGES.
+-
+-		     END OF TERMS AND CONDITIONS
+-
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\oxpus\\notes/migrations/release_3_0_0.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/migrations/release_3_0_0.php"
+index 98c1a3020..716d6257b 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\oxpus\\notes/migrations/release_3_0_0.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/migrations/release_3_0_0.php"
+@@ -57,12 +57,14 @@ class release_3_0_0 extends \phpbb\db\migration\migration
+ 
+ 			// The needed permissions
+ 			['permission.add', ['a_notes']],
++			['permission.add', ['u_notes', 1, 0]],
+ 
+-			// Join permissions to administrators
++			// Join permissions
+ 			['permission.permission_set', ['ROLE_ADMIN_FULL', 'a_notes']],
++			['permission.permission_set', ['ROLE_USER_FULL', 'u_notes']],
+ 		];
+ 	}
+-
++			
+ 	public function update_schema()
+ 	{
+ 		return [
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/styles/FLATBOOTS/template/event/navbar_header_profile_list_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/styles/FLATBOOTS/template/event/navbar_header_profile_list_after.html"
+new file mode 100644
+index 000000000..fefe40b0f
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/styles/FLATBOOTS/template/event/navbar_header_profile_list_after.html"
+@@ -0,0 +1,3 @@
++{% if U_NOTES_PATH %}
++	<a class="btn btn-default btn-sm btn-block" href="{{ U_NOTES_PATH }}"><i class="fa fa-clipboard"></i>&nbsp;{{ lang('NOTES') }}</a>
++{% endif %}
+\ No newline at end of file
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/styles/FLATBOOTS/template/event/overall_header_content_before.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/styles/FLATBOOTS/template/event/overall_header_content_before.html"
+new file mode 100644
+index 000000000..89d00a165
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/styles/FLATBOOTS/template/event/overall_header_content_before.html"
+@@ -0,0 +1,12 @@
++{% if S_NOTES_MEM %}
++<div class="alert alert-warning fade in">
++    <i class="fa fa-info"></i> <strong>{{ lang('INFORMATION') }}{{ lang('COLON') }}</strong>&nbsp;{{ NOTES_MEM }}
++</div>
++{% endif %}
++{% if U_NOTES_POPUP %}
++<script type="text/javascript">
++    function notes() {
++        window.open("{{ U_NOTES_POPUP }}", "_blank", "width=800,height=600,scrollbars=yes,resizable=no");
++    }
++</script>
++{% endif %}
+\ No newline at end of file
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/styles/FLATBOOTS/template/event/overall_header_navigation_append.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/styles/FLATBOOTS/template/event/overall_header_navigation_append.html"
+new file mode 100644
+index 000000000..f80d8bc2d
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/styles/FLATBOOTS/template/event/overall_header_navigation_append.html"
+@@ -0,0 +1 @@
++{% if U_NOTES_PATH %}<li><a href="{{ U_NOTES_PATH }}"><i class="fa fa-fw fa-clipboard"></i>{{ lang('NOTES') }}</a></li>{% endif %}
+\ No newline at end of file
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/styles/FLATBOOTS/template/event/overall_header_stylesheets_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/styles/FLATBOOTS/template/event/overall_header_stylesheets_after.html"
+new file mode 100644
+index 000000000..2f473aa86
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/styles/FLATBOOTS/template/event/overall_header_stylesheets_after.html"
+@@ -0,0 +1,4 @@
++{% if PAGE_TITLE eq "Notes" %}
++{% INCLUDECSS '@oxpus_notes/notes.css' %}
++{% INCLUDEJS '@oxpus_notes/js/notes.js' %}
++{% endif %}
+\ No newline at end of file
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/styles/FLATBOOTS/template/event/simple_header_stylesheets_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/styles/FLATBOOTS/template/event/simple_header_stylesheets_after.html"
+new file mode 100644
+index 000000000..2f473aa86
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/styles/FLATBOOTS/template/event/simple_header_stylesheets_after.html"
+@@ -0,0 +1,4 @@
++{% if PAGE_TITLE eq "Notes" %}
++{% INCLUDECSS '@oxpus_notes/notes.css' %}
++{% INCLUDEJS '@oxpus_notes/js/notes.js' %}
++{% endif %}
+\ No newline at end of file
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/styles/FLATBOOTS/template/js/notes.js" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/styles/FLATBOOTS/template/js/notes.js"
+new file mode 100644
+index 000000000..b1d11af8e
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/styles/FLATBOOTS/template/js/notes.js"
+@@ -0,0 +1,16 @@
++/**
++*
++* @package phpBB Extension - Personal notes
++* @copyright (c) 2014 OXPUS - www.oxpus.net
++* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
++*
++*/
++
++/**
++* Show/hide notes text
++*/
++function showHideNote(note)
++{
++	$('#note_' + note).slideToggle();
++	$('#panel-heading-' + note).toggleClass('note-hidden');
++}
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/styles/FLATBOOTS/template/note_confirm_body.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/styles/FLATBOOTS/template/note_confirm_body.html"
+new file mode 100644
+index 000000000..7c82fa0d6
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/styles/FLATBOOTS/template/note_confirm_body.html"
+@@ -0,0 +1,31 @@
++{% if S_AJAX_REQUEST %}
++<form action="{{ S_CONFIRM_ACTION }}" method="post">
++	<h3 class="alert_title">{{ MESSAGE_TITLE }}</h3>
++	<p>{{ MESSAGE_TEXT }}</p>
++	<fieldset>
++		<input type="button" name="confirm" value="{{ lang('YES') }}" class="btn btn-default" />
++		<input type="button" name="cancel" value="{{ lang('NO') }}" class="btn btn-default" />
++	</fieldset>
++</form>
++{% endif %}
++{% if S_NOTES_POPUP %}
++{% INCLUDE 'simple_header.html' %}
++{% else %}
++{% INCLUDE 'overall_header.html' %}
++{% endif %}
++<form id="confirm" action="{{ S_CONFIRM_ACTION }}" method="post">
++	<div class="side-segment"><h3>{{ MESSAGE_TITLE }}</h3></div>
++<div class="well">
++	<p>{{ MESSAGE_TEXT }}</p>
++	<fieldset>
++		{{ S_HIDDEN_FIELDS }}
++		<button type="submit" name="confirm" value="{{ lang('YES') }}" class="btn btn-default">{{ lang('YES') }}</button>
++		<button type="submit" name="cancel" value="{{ lang('NO') }}" class="btn btn-default">{{ lang('NO') }}</button>
++	</fieldset>
++</div>
++</form>
++{% if S_NOTES_POPUP %}
++{% INCLUDE 'simple_footer.html' %}
++{% else %}
++{% INCLUDE 'overall_footer.html' %}
++{% endif %}
+\ No newline at end of file
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/styles/FLATBOOTS/template/note_edit_body.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/styles/FLATBOOTS/template/note_edit_body.html"
+new file mode 100644
+index 000000000..95686bae7
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/styles/FLATBOOTS/template/note_edit_body.html"
+@@ -0,0 +1,118 @@
++{% if S_NOTES_POPUP %}
++{% INCLUDE 'simple_header.html' %}
++{% else %}
++{% INCLUDE 'overall_header.html' %}
++{% endif %}
++
++<h2>{{ lang('NOTES') }} - {{ NOTES_TOTAL_USED }} / {{ NOTES_TOTAL_ALLOWED }}</h2>
++<form action="{{ S_NOTES_FORM_ACTION }}" method="post" id="postform">
++    <div class="clearfix">
++        <div class="well">
++            <div class="side-segment section-posting">
++                <h3>{{ lang('POST_NEW_NOTE') }}</h3>
++            </div>
++            <fieldset>
++                <div class="control-group">
++                    <label class="control-label" for="subject">{{ lang('SUBJECT') }}{{ lang('COLON') }}</label>
++                    <div class="row">
++                        <div class="col-xs-12 col-lg-8">
++                            <input type="text" class="form-control input-sm" placeholder="{{ lang('SUBJECT') }}{{ lang('COLON') }}" name="subject" id="subject" maxlength="124" tabindex="2" value="{{ NOTES_SUBJECT }}">
++                        </div>
++                    </div>
++                </div>
++
++                <div class="space10"></div>
++
++                <label class="control-label">{{ lang('NOTES_MEM') }}{{ lang('COLON') }}</label>
++
++                <div class="space10"></div>
++
++                <input type="checkbox" name="mem_yesno" id="mem_yesno" value="1"{% if NOTES_MEM_CHECKED %} checked="checked"{% endif %}><label class="checkbox-inline">{{ lang('NOTES_MEM_ENABLE') }}</label>
++                &nbsp;<i class="icon fa fa-bell" style="transform: rotate(40deg);vertical-align: middle;"></i>
++                <i class="icon fa fa-bell" style="transform: rotate(-40deg);vertical-align: middle;"></i>
++
++                <div class="space10"></div>
++
++                <div class="control-group">
++                    <label for="mem_yesno" class="control-label">{{ lang('NOTES_MEM_TIME') }}{{ lang('COLON') }}</label>
++                    <div class="controls controls-row">
++                        <div class="clearfix">
++                            <div class="controls">
++                                <div class="selector">
++                                    <select name="mem_day" class="selectpicker" data-width="auto">
++                                        {% for notes_days in loops.notes_days %}
++                                        <option value="{{ notes_days.DAY }}"{% if notes_days.DAY eq S_NOTE_MEM_DAY %} selected="selected"{% endif %}>{{ notes_days.DAY }}</option>
++                                        {% endfor %}
++                                    </select>
++                                    <select name="mem_month" class="selectpicker" data-width="auto">
++                                        {% for notes_months in loops.notes_months %}
++                                        <option value="{{ notes_months.MONTH }}"{% if notes_months.MONTH eq S_NOTE_MEM_MONTH %} selected="selected"{% endif %}>{{ notes_months.MONTH }}</option>
++                                        {% endfor %}
++                                    </select>
++                                    <select name="mem_year" class="selectpicker" data-width="auto">
++                                        {% for notes_years in loops.notes_years %}
++                                        <option value="{{ notes_years.YEAR }}"{% if notes_years.YEAR eq S_NOTE_MEM_YEAR %} selected="selected"{% endif %}>{{ notes_years.YEAR }}</option>
++                                        {% endfor %}
++                                    </select>
++                                </div>
++                                <div class="selector">
++                                    <select name="mem_hour" class="selectpicker" data-width="auto">
++                                        {% for notes_hours in loops.notes_hours %}
++                                        <option value="{{ notes_hours.HOUR }}"{% if notes_hours.HOUR eq S_NOTE_MEM_HOUR %} selected="selected"{% endif %}>{{ notes_hours.HOUR }}</option>
++                                        {% endfor %}
++                                    </select>
++                                    <select name="mem_minute" class="selectpicker" data-width="auto">
++                                        {% for notes_minutes in loops.notes_minutes %}
++                                        <option value="{{ notes_minutes.MINUTE }}"{% if notes_minutes.MINUTE eq S_NOTE_MEM_MIN %} selected="selected"{% endif %}>{{ notes_minutes.MIN }}</option>
++                                        {% endfor %}
++                                    </select>
++                                </div>
++                            </div>
++                        </div>
++                    </div>
++                </div>
++
++                {% INCLUDE 'posting_buttons.html' %}
++
++                <div class="space10"></div>
++
++                <div class="row">
++                    <div class="col-md-8">
++                        <textarea class="form-control" name="message" id="message" rows="10" tabindex="3" onselect="storeCaret(this);" onclick="storeCaret(this);" onkeyup="storeCaret(this);">{{ NOTES_MESSAGE }}</textarea>
++                    </div>
++
++                    <div class="col-md-4">
++                        {% if loops.smiley|length %}
++                        <strong>{{ lang('SMILIES') }}<a class="btn-link btn-xs" href="{{ U_MORE_SMILIES }}" onclick="popup(this.href, 450, 350, '_phpbbsmilies'); return false;" title="{{ lang('MORE_SMILIES') }}"><i class="fa fa-plus"></i></a></strong>
++                        <br />
++                        {% for smiley in loops.smiley %}
++                        <a href="#" onclick="insert_text('{{ smiley.A_SMILEY_CODE }}', true); return false;"><img src="{{ smiley.SMILEY_IMG }}" width="{{ smiley.SMILEY_WIDTH }}" height="{{ smiley.SMILEY_HEIGHT }}" alt="{{ smiley.SMILEY_CODE }}" title="{{ smiley.SMILEY_DESC }}" /></a>
++                        {% endfor %}
++                        {% endif %}
++                    </div>
++                </div>
++            </fieldset>
++
++            <div class="space10"></div>
++
++            <fieldset class="form-actions">
++                {{ S_NOTES_HIDDEN_FIELDS }}
++                <button type="submit" class="btn btn-default" name="save" value="{{ lang('SUBMIT') }}" data-loading-text="{{ lang('LOADING') }}<i class='fa fa-spin fa-spinner fa-lg icon-white'></i>">{{ lang('SUBMIT') }}</button>
++                {{ S_FORM_TOKEN }}
++            </fieldset>
++        </div>
++    </div>
++</form>
++
++<div class="space10"></div>
++
++{% if S_NOTES_POPUP %}
++<br />
++<p class="submit-buttons">
++    <input type="submit" name="cancel" class="btn btn-default" value="{{ lang('CLOSE_WINDOW') }}" onclick="javascript:window.close()" />
++</p>
++<br />
++{% INCLUDE 'simple_footer.html' %}
++{% else %}
++{% INCLUDE 'overall_footer.html' %}
++{% endif %}
+\ No newline at end of file
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/styles/FLATBOOTS/template/note_list_body.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/styles/FLATBOOTS/template/note_list_body.html"
+new file mode 100644
+index 000000000..08f725f49
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/styles/FLATBOOTS/template/note_list_body.html"
+@@ -0,0 +1,180 @@
++{% if S_NOTES_POPUP %}
++{% INCLUDE 'simple_header.html' %}
++{% else %}
++{% INCLUDE 'overall_header.html' %}
++{% endif %}
++<div class="side-segment">
++    <h3>{{ lang('NOTES') }}</h3>
++</div>
++
++{% if not S_NO_NOTES %}
++<div class="space10"></div>
++
++{% if NOTES_FILTER_ACTIVE %}
++<div class="alert alert-info fade in">
++    * {{ lang('FILTER_NOTES') }}
++</div>
++{% endif %}
++
++<div class="row">
++    <form action="{{ S_NOTES_FORM_ACTION }}" method="post" id="notes">
++        <fieldset>
++           <div class="col-md-6 col-sm-6">
++               <div class="input-group search-notes">
++                   <select name="search_in" class="selectpicker" data-width="auto">
++                       <option value="note_subject"{% if NOTES_SEARCH_IN eq 'note_subject' %} selected="selected"{% endif %}>{{ lang('SUBJECT') }}</option>
++                       <option value="note_text"{% if NOTES_SEARCH_IN eq 'note_text' %} selected="selected"{% endif %}>{{ lang('POST') }}</option>
++                   </select>
++                   <input name="search_string" value="all" id="search_string" type="hidden">
++                   <input class="form-control" name="search_string" type="text">
++                   <div class="input-group-btn">
++                       <button type="submit" class="btn btn-info" value="{{ lang('SEARCH') }}{% if NOTES_SEARCH_ACTIVE %}*{% endif %}">{{ lang('SEARCH') }}{% if NOTES_SEARCH_ACTIVE %}*{% endif %}</button>
++                   </div>
++               </div>
++           </div>
++
++           <div class="col-md-6 col-sm-6 hidden-xs">
++               <div class="input-group pull-right">
++               <select name="sort_by" class="selectpicker" data-width="auto">
++                   <option value="note_subject"{% if NOTES_SORT_BY eq 'note_subject' %} selected="selected"{% endif %}>{{ lang('SUBJECT') }}</option>
++                   <option value="note_time"{% if NOTES_SORT_BY eq 'note_time' %} selected="selected"{% endif %}>{{ lang('TIME') }}</option>
++                   <option value="note_mem"{% if NOTES_SORT_BY eq 'note_mem' %} selected="selected"{% endif %}>{{ lang('NOTES_MEM') }}</option>
++               </select>
++               &nbsp;
++               <select name="sort_order" class="selectpicker" data-width="auto">
++                   <option value="ASC"{% if NOTES_SORT_ORDER eq 'ASC' %} selected="selected"{% endif %}>{{ lang('ASCENDING') }}</option>
++                   <option value="DESC"{% if NOTES_SORT_ORDER eq 'DESC' %} selected="selected"{% endif %}>{{ lang('DESCENDING') }}</option>
++               </select>
++               &nbsp;
++               <button type="submit" value="{{ lang('SORT_BY') }}" class="btn btn-info">{{ lang('SORT_BY') }}</button>
++               </div>
++            </div>
++        </fieldset>
++    </form>
++</div>
++
++<div class="space10"></div>
++<div class="space10"></div>
++<div class="space10"></div>
++<div class="space10"></div>
++
++<div class="clearfix">
++    <div class="pull-left">
++        {% if S_NEW_NOTE %}<a href="{{ U_NEW_NOTE }}" role="button" class="btn btn-default btn-load" data-loading-text="{{ lang('LOADING') }}&nbsp;<i class='fa-spin fa fa-spinner fa-lg icon-white'></i>"><i class="fa fa-plus"></i>&nbsp;{{ lang('NEW_NOTE') }}</a>
++        {% endif %}
++    </div>
++
++    {% if not S_NO_NOTES %}
++    <div class="pull-right">
++        <ul class="pagination pagination-sm">
++            <li><a class="pagination-trigger" data-placement="top">{{ lang('NOTES') }}</a></li>
++            <li class="active"><a>{{ NOTES_TOTAL_USED }} / {{ NOTES_TOTAL_ALLOWED }}</a></li>
++        </ul>
++    </div>
++    {% endif %}
++</div>
++{% endif %}
++
++{% if S_NO_NOTES %}
++<div class="space10"></div>
++<div class="alert alert-info fade in">
++    <i class="fa fa-info"></i> <strong>{{ lang('INFORMATION') }}{{ lang('COLON') }}</strong>&nbsp;{% if NOTES_NOT_FOUND %}{{ lang('NO_SEARCH_RESULTS') }}{% else %}{{ lang('NO_NOTES') }}{% endif %}
++</div>
++{% else %}
++{% for notes_row in loops.notes_row %}
++<div class="panel">
++
++    <div class="panel-heading{% if NOTES_SLIDE_MODE %} note-hidden" id="panel-heading-{{ notes_row.NOTE_ID }}{% endif %}">
++        <div class="clearfix">
++
++            <div class="side-segment">
++                <h3 style="border-bottom: 4px solid #e5e5e5;">{% if NOTES_SLIDE_MODE %}<a href="#" onclick="showHideNote({{ notes_row.NOTE_ID }}); return false;">{% endif %}{{ notes_row.NOTE_SUBJECT }}{% if NOTES_SLIDE_MODE %}</a>{% endif %}</h3></div>
++            <div class="clearfix">
++                <div class="text-muted pull-left">
++                    <span><i class="fa fa-clock-o"></i>&nbsp;{{ notes_row.NOTE_DATE }}</span>
++                </div>
++                <div class="pull-right">
++                    <div role="toolbar" class="btn-toolbar">
++
++                        <div class="btn-group btn-group-sm" role="group">
++
++                            <a class="btn btn-default btn-sm" href="{{ notes_row.U_EDIT_NOTE }}" title="{{ lang('EDIT_POST') }}" role="button"><i class="fa fa-edit"></i></a>
++
++                        </div>
++                        <div class="btn-group btn-group-sm" role="group">
++
++                            <a class="btn btn-danger btn-sm" href="{{ notes_row.U_DELETE_NOTE }}" title="{{ lang('DELETE_POST') }}" role="button"><i class="fa fa-trash-o"></i></a>
++
++                        </div>
++
++                    </div>
++                </div>
++            </div>
++
++        </div>
++    </div>
++
++    <div class="panel-body{% if NOTES_SLIDE_MODE %} hide-note{% endif %}" id="note_{{ notes_row.NOTE_ID }}">
++        <div class="clearfix">
++            <div class="postbody">
++
++                <span class="hidden hook-bfr-message"></span>
++                <div class="content">{{ notes_row.NOTE_TEXT }}</div>
++                {% if notes_row.NOTES_MEM %}
++                <div class="notice text-muted">
++                    <div class="space10"></div>
++                    <small><span class="label label-danger"><i class="fa fa-bell-o"></i>&nbsp;{{ lang('NOTES_MEM') }}</span>&nbsp;&nbsp;&nbsp;<i class="fa fa-clock-o"></i>&nbsp;{{ notes_row.NOTES_MEM }}</small>
++                </div>
++                {% endif %}
++
++            </div>
++        </div>
++    </div>
++
++</div>
++
++{% endfor %}
++{% endif %}
++
++<div class="clearfix">
++    <div class="pull-left">
++        {% if S_NEW_NOTE %}<a href="{{ U_NEW_NOTE }}" role="button" class="btn btn-default btn-load" data-loading-text="{{ lang('LOADING') }}&nbsp;<i class='fa-spin fa fa-spinner fa-lg icon-white'></i>"><i class="fa fa-plus"></i>&nbsp;{{ lang('NEW_NOTE') }}</a>
++        {% endif %}
++        {% if S_SHOW_BUTTON or NOTES_FILTER_ACTIVE %}<a href="{{ U_NOTES_HOME }}" role="button" class="btn btn-default btn-load" data-loading-text="{{ lang('LOADING') }}&nbsp;<i class='fa-spin fa fa-spinner fa-lg icon-white'></i>"><i class="fa fa-list"></i>&nbsp;{{ lang('NOTES') }}</a>
++        {% endif %}
++    </div>
++
++    {% if not S_NO_NOTES %}
++    <div class="pull-right">
++        <ul class="pagination pagination-sm">
++            <li><a class="pagination-trigger" data-placement="top">{{ lang('NOTES') }}</a></li>
++            <li class="active"><a>{{ NOTES_TOTAL_USED }} / {{ NOTES_TOTAL_ALLOWED }}</a></li>
++        </ul>
++    </div>
++    {% endif %}
++</div>
++
++{% if S_NO_NOTES %}
++<div class="space10"></div>
++<div class="space10"></div>
++{% endif %}
++
++<div class="row">
++    <div class="col-md-12 col-sm-12">
++        <p class="text-muted"><small>{% if S_NOTES_POPUP %}{{ lang('NOTES_DISCLAIMER_POPUP') }}{% else %}{{ lang('NOTES_DISCLAIMER') }}{% endif %}</small></p>
++    </div>
++</div>
++
++{% if S_NOTES_POPUP %}
++<div class="space10"></div>
++
++<p class="submit-buttons">
++    <input type="submit" name="cancel" class="btn btn-default" value="{{ lang('CLOSE_WINDOW') }}" onclick="javascript:window.close()" />
++</p>
++
++<br />
++
++{% INCLUDE 'simple_footer.html' %}
++{% else %}
++{% INCLUDE 'overall_footer.html' %}
++{% endif %}
+\ No newline at end of file
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/styles/FLATBOOTS/template/ucp_notes.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/styles/FLATBOOTS/template/ucp_notes.html"
+new file mode 100644
+index 000000000..182f40604
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/styles/FLATBOOTS/template/ucp_notes.html"
+@@ -0,0 +1,45 @@
++{% INCLUDE 'ucp_header.html' %}
++<form id="notes_config" method="post" action="{{ U_NOTES_FORM_ACTION }}">
++<div class="tab-pane active">
++    <fieldset class="framed-ucp">
++        <legend>{{ lang('UCP_NOTES') }}</legend>
++        <div class="control-group">
++            <label for="notes_popup1" class="control-label">{{ lang('POPUP_NOTES') }}{{ lang('COLON') }}</label>
++            <div class="controls controls-row">
++                <div class="radio">
++                    <input type="radio" name="notes_popup" id="notes_popup1" value="1" {% if NOTES_POPUP %} checked="checked"{% endif %}/>
++                    <label for="notes_popup1">{{ lang('YES') }}</label>
++                </div>
++                <div class="radio">
++                    <input type="radio" name="notes_popup" id="notes_popup0" value="0" {% if not NOTES_POPUP %} checked="checked"{% endif %}/>
++                    <label for="notes_popup0">{{ lang('NO') }}</label>
++                </div>
++            </div>
++
++            <div class="controls controls-row">
++                <label for="notes_slide1" class="control-label">{{ lang('SLIDE_NOTES') }}{{ lang('COLON') }}</label>
++                <div class="controls controls-row">
++                    <div class="radio">
++                        <input type="radio" name="notes_slide" id="notes_slide1" value="1" {% if NOTES_SLIDE %} checked="checked"{% endif %}/>
++                        <label for="notes_slide1">{{ lang('YES') }}</label>
++                    </div>
++                    <div class="radio">
++                        <input type="radio" name="notes_slide" id="notes_slide0" value="0" {% if not NOTES_SLIDE %} checked="checked"{% endif %}/>
++                        <label for="notes_slide0">{{ lang('NO') }}</label>
++                    </div>
++                </div>
++            </div>
++        </div>
++    </fieldset>
++</div>
++
++<div class="space10"></div>
++
++<div class="form-actions"> 
++    {{ S_HIDDEN_FIELDS }}
++    <button type="submit" name="submit" value="{{ lang('SUBMIT') }}" class="btn btn-default" data-loading-text="{{ lang('LOADING') }}<i class='fa fa-spin fa-spinner fa-lg icon-white'></i>">{{ lang('SUBMIT') }}</button>
++    {{ S_FORM_TOKEN }}
++</div>
++
++</form>
++{% INCLUDE 'ucp_footer.html' %}
+\ No newline at end of file
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/styles/FLATBOOTS/theme/notes.css" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/styles/FLATBOOTS/theme/notes.css"
+new file mode 100644
+index 000000000..a683b2f06
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/styles/FLATBOOTS/theme/notes.css"
+@@ -0,0 +1,9 @@
++.hide-note
++{
++    display: none;
++}
++
++.note-hidden
++{
++    border-bottom: none;
++}
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\oxpus\\notes/ucp/main_info.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/ucp/main_info.php"
+index c0858faa5..cfece2f3f 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\oxpus\\notes/ucp/main_info.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/ucp/main_info.php"
+@@ -21,7 +21,7 @@ class main_info
+ 			'title'		=> 'NOTES',
+ 			'version'	=> $config['notes_version'],
+ 			'modes'		=> [
+-				'main'	=> ['title' => 'UCP_NOTES_CONFIG', 'auth' => 'ext_oxpus/notes', 'cat' => ['NOTES']],
++				'main'	=> ['title' => 'UCP_NOTES_CONFIG', 'auth' => 'ext_oxpus/notes && acl_u_notes', 'cat' => ['NOTES']],
+ 			],
+ 		];
+ 	}
diff --git "[FORUM_EXT]/oxpus\\notes/diff_nospace.tmp" "[FORUM_EXT]/oxpus\\notes/diff_nospace.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/oxpus\\notes/diff_nospace.tmp"
@@ -0,0 +1,1918 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\oxpus\\notes/README.md" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\oxpus\\notes/README.md"
+deleted file mode 100644
+index 886a99d2c..000000000
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\oxpus\\notes/README.md"
++++ /dev/null
+@@ -1,24 +0,0 @@
+-ANZEIGENAME
+-===================
+-
+-# phpBB 3.1 Personal Notes Extension
+-
+-Personal notes for all users
+-
+-## Description
+-
+-Allows to manage own personal notes which can not be viewed by other users
+-
+-## Installation
+-
+-Upload the content of the folder "ext" into your forum folder /ext/.
+-After this enable the extension under "ACP" > "Customise" > "Extensions" > "Personal Notes"
+-
+-## Collaborate
+-
+-* For support visit the forum under http://phpbb3.oxpus.net
+-* To post an issue with this extention please use the bug tracker http://phpbb3.oxpus.net/downloads.php?view=bug_tracker
+-
+-## License
+-
+-[GPLv2](license.txt)
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\oxpus\\notes/config/services.yml" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/config/services.yml"
+index 776226141..c159bc16d 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\oxpus\\notes/config/services.yml"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/config/services.yml"
+@@ -11,6 +11,7 @@ services:
+             - '@dbal.conn'
+             - '@config'
+             - '@controller.helper'
++            - '@auth'
+             - '@request'
+             - '@template'
+             - '@user'
+@@ -22,6 +23,7 @@ services:
+         arguments:
+             - '@dbal.conn'
+             - '@controller.helper'
++            - '@auth'
+             - '@template'
+             - '@user'
+             - '@language'
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\oxpus\\notes/controller/main.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/controller/main.php"
+index b49c45302..85cb191dd 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\oxpus\\notes/controller/main.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/controller/main.php"
+@@ -17,6 +17,7 @@ class main
+ 	protected $db;
+ 	protected $config;
+ 	protected $helper;
++	protected $auth;
+ 	protected $request;
+ 	protected $template;
+ 	protected $user;
+@@ -31,6 +32,7 @@ class main
+ 	* @param \phpbb\db\driver\driver_interfacer		$db
+ 	* @param \phpbb\config\config					$config
+ 	* @param \phpbb\controller\helper				$helper
++	* @param \phpbb\auth\auth						$auth
+ 	* @param \phpbb\request\request_interface 		$request
+ 	* @param \phpbb\template\template				$template
+ 	* @param \phpbb\user							$user
+@@ -43,6 +45,7 @@ class main
+ 		\phpbb\db\driver\driver_interface $db,
+ 		\phpbb\config\config $config,
+ 		\phpbb\controller\helper $helper,
++		\phpbb\auth\auth $auth,
+ 		\phpbb\request\request_interface $request,
+ 		\phpbb\template\template $template,
+ 		\phpbb\user $user,
+@@ -55,19 +58,19 @@ class main
+ 		$this->db 						= $db;
+ 		$this->config 					= $config;
+ 		$this->helper 					= $helper;
++		$this->auth						= $auth;
+ 		$this->request					= $request;
+ 		$this->template 				= $template;
+ 		$this->user 					= $user;
+ 		$this->language					= $language;
+-
+ 		$this->notes_table				= $notes_table;
+ 	}
+ 
+ 	public function handle()
+ 	{
+-		if ( !$this->user->data['is_registered'] )
++		if (!$this->auth->acl_get('u_notes'))
+ 		{
+-			redirect($this->root_path . 'index.' . $this->php_ext);
++			throw new \phpbb\exception\http_exception(404, 'PAGE_NOT_FOUND');
+ 		}
+ 
+ 		include_once($this->root_path . 'includes/functions_user.' . $this->php_ext);
+@@ -82,7 +85,7 @@ class main
+ 		* Get the variable contents
+ 		*/
+ 		$cancel				= $this->request->variable('cancel', '');
+-		$sql_order			= $this->request->variable('sort_order', 'ASC');
++		$sql_order			= $this->request->variable('sort_order', 'DESC');
+ 		$sql_order_by		= $this->request->variable('sort_by', 'note_time');
+ 		$search_keywords	= $this->request->variable('search_string', '', true);
+ 		$sql_search_in		= $this->request->variable('search_in', '');
+@@ -107,7 +110,17 @@ class main
+ 		$notes_data = [];
+ 		$display_notes = 0;
+ 
++		/*
++		* Output page header
++		*/
++		if ( $this->user->data['user_popup_notes'] == true )
++		{
++			$this->template->assign_var('S_NOTES_POPUP', true);
++		}
++
+ 		if ($mode == 'delete')
++		{
++			if (confirm_box(true))
+ 			{
+ 				$sql = 'DELETE FROM ' . $this->notes_table . '
+ 						WHERE ' . $this->db->sql_build_array('SELECT', [
+@@ -115,16 +128,13 @@ class main
+ 							'note_user_id' => $this->user->data['user_id'],
+ 						]);
+ 				$this->db->sql_query($sql);
+-
+-			$mode = '';
+ 			}
+-
+-		/*
+-		* Output page header
+-		*/
+-		if ( $this->user->data['user_popup_notes'] == true )
++			else 
+ 			{
+-			$this->template->assign_var('S_NOTES_POPUP', true);
++				confirm_box(false, $this->language->lang('NOTES_DELETE_CONFIRM'), '', 'note_confirm_body.html');
++			}
++
++			$mode = '';
+ 		}
+ 
+ 		/*
+@@ -227,8 +237,8 @@ class main
+ 			}
+ 
+ 			$sql_notes_ary = [
+-				'note_subject'	=> $note_subject,
+-				'note_text'		=> $note_message,
++				'note_subject'  => utf8_encode_ucr($note_subject),
++				'note_text'     => utf8_encode_ucr($note_message),
+ 				'note_uid'      => $uid,
+ 				'note_bitfield' => $bitfield,
+ 				'note_flags'    => $flags,
+@@ -435,6 +445,8 @@ class main
+ 			'S_NOTES_FORM_ACTION'	=> $this->helper->route('oxpus_notes_controller'),
+ 
+ 			'U_NEW_NOTE'			=> $this->helper->route('oxpus_notes_controller', ['mode' => 'new_note']),
++
++			'S_SHOW_BUTTON'			=> ($total_notes) ? true : false,
+ 		]);
+ 
+ 		/*
+@@ -492,6 +504,7 @@ class main
+ 						'U_EDIT_NOTE'	=> $u_edit,
+ 					]);
+ 				}
++				$this->template->assign_var('S_SHOW_BUTTON', false);
+ 			}
+ 			else
+ 			{
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/diff_full.tmp"
+new file mode 100644
+index 000000000..a73b2d2bc
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/diff_full.tmp"
+@@ -0,0 +1,1769 @@
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\oxpus\\notes/README.md" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\oxpus\\notes/README.md"
++deleted file mode 100644
++index 886a99d2c..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\oxpus\\notes/README.md"
+++++ /dev/null
++@@ -1,24 +0,0 @@
++-ANZEIGENAME
++-===================
++-
++-# phpBB 3.1 Personal Notes Extension
++-
++-Personal notes for all users
++-
++-## Description
++-
++-Allows to manage own personal notes which can not be viewed by other users
++-
++-## Installation
++-
++-Upload the content of the folder "ext" into your forum folder /ext/.
++-After this enable the extension under "ACP" > "Customise" > "Extensions" > "Personal Notes"
++-
++-## Collaborate
++-
++-* For support visit the forum under http://phpbb3.oxpus.net
++-* To post an issue with this extention please use the bug tracker http://phpbb3.oxpus.net/downloads.php?view=bug_tracker
++-
++-## License
++-
++-[GPLv2](license.txt)
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\oxpus\\notes/config/services.yml" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/config/services.yml"
++index 776226141..c159bc16d 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\oxpus\\notes/config/services.yml"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/config/services.yml"
++@@ -11,6 +11,7 @@ services:
++             - '@dbal.conn'
++             - '@config'
++             - '@controller.helper'
+++            - '@auth'
++             - '@request'
++             - '@template'
++             - '@user'
++@@ -22,6 +23,7 @@ services:
++         arguments:
++             - '@dbal.conn'
++             - '@controller.helper'
+++            - '@auth'
++             - '@template'
++             - '@user'
++             - '@language'
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\oxpus\\notes/controller/main.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/controller/main.php"
++index b49c45302..85cb191dd 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\oxpus\\notes/controller/main.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/controller/main.php"
++@@ -17,6 +17,7 @@ class main
++ 	protected $db;
++ 	protected $config;
++ 	protected $helper;
+++	protected $auth;
++ 	protected $request;
++ 	protected $template;
++ 	protected $user;
++@@ -31,6 +32,7 @@ class main
++ 	* @param \phpbb\db\driver\driver_interfacer		$db
++ 	* @param \phpbb\config\config					$config
++ 	* @param \phpbb\controller\helper				$helper
+++	* @param \phpbb\auth\auth						$auth
++ 	* @param \phpbb\request\request_interface 		$request
++ 	* @param \phpbb\template\template				$template
++ 	* @param \phpbb\user							$user
++@@ -43,6 +45,7 @@ class main
++ 		\phpbb\db\driver\driver_interface $db,
++ 		\phpbb\config\config $config,
++ 		\phpbb\controller\helper $helper,
+++		\phpbb\auth\auth $auth,
++ 		\phpbb\request\request_interface $request,
++ 		\phpbb\template\template $template,
++ 		\phpbb\user $user,
++@@ -55,19 +58,19 @@ class main
++ 		$this->db 						= $db;
++ 		$this->config 					= $config;
++ 		$this->helper 					= $helper;
+++		$this->auth						= $auth;
++ 		$this->request					= $request;
++ 		$this->template 				= $template;
++ 		$this->user 					= $user;
++ 		$this->language					= $language;
++-
++ 		$this->notes_table				= $notes_table;
++ 	}
++ 
++ 	public function handle()
++ 	{
++-		if ( !$this->user->data['is_registered'] )
+++		if (!$this->auth->acl_get('u_notes'))
++ 		{
++-			redirect($this->root_path . 'index.' . $this->php_ext);
+++			throw new \phpbb\exception\http_exception(404, 'PAGE_NOT_FOUND');
++ 		}
++ 
++ 		include_once($this->root_path . 'includes/functions_user.' . $this->php_ext);
++@@ -82,7 +85,7 @@ class main
++ 		* Get the variable contents
++ 		*/
++ 		$cancel				= $this->request->variable('cancel', '');
++-		$sql_order			= $this->request->variable('sort_order', 'ASC');
+++		$sql_order			= $this->request->variable('sort_order', 'DESC');
++ 		$sql_order_by		= $this->request->variable('sort_by', 'note_time');
++ 		$search_keywords	= $this->request->variable('search_string', '', true);
++ 		$sql_search_in		= $this->request->variable('search_in', '');
++@@ -107,18 +110,6 @@ class main
++ 		$notes_data = [];
++ 		$display_notes = 0;
++ 
++-		if ($mode == 'delete')
++-		{
++-			$sql = 'DELETE FROM ' . $this->notes_table . '
++-					WHERE ' . $this->db->sql_build_array('SELECT', [
++-						'note_id' => $note_id,
++-						'note_user_id' => $this->user->data['user_id'],
++-					]);
++-			$this->db->sql_query($sql);
++-
++-			$mode = '';
++-		}
++-
++ 		/*
++ 		* Output page header
++ 		*/
++@@ -127,6 +118,25 @@ class main
++ 			$this->template->assign_var('S_NOTES_POPUP', true);
++ 		}
++ 
+++		if ($mode == 'delete')
+++		{
+++			if (confirm_box(true))
+++			{
+++				$sql = 'DELETE FROM ' . $this->notes_table . '
+++						WHERE ' . $this->db->sql_build_array('SELECT', [
+++							'note_id' => $note_id,
+++							'note_user_id' => $this->user->data['user_id'],
+++						]);
+++				$this->db->sql_query($sql);
+++			}
+++			else 
+++			{
+++				confirm_box(false, $this->language->lang('NOTES_DELETE_CONFIRM'), '', 'note_confirm_body.html');
+++			}
+++
+++			$mode = '';
+++		}
+++
++ 		/*
++ 		* Check the number of notes for this user
++ 		*/
++@@ -227,12 +237,12 @@ class main
++ 			}
++ 
++ 			$sql_notes_ary = [
++-				'note_subject'	=> $note_subject,
++-				'note_text'		=> $note_message,
++-				'note_uid'		=> $uid,
++-				'note_bitfield'	=> $bitfield,
++-				'note_flags'	=> $flags,
++-				'note_mem'		=> $note_mem,
+++				'note_subject'  => utf8_encode_ucr($note_subject),
+++				'note_text'     => utf8_encode_ucr($note_message),
+++				'note_uid'      => $uid,
+++				'note_bitfield' => $bitfield,
+++				'note_flags'    => $flags,
+++				'note_mem'      => $note_mem,
++ 				'note_memx'		=> ($note_mem) ? 1 : 0,
++ 			];
++ 
++@@ -435,6 +445,8 @@ class main
++ 			'S_NOTES_FORM_ACTION'	=> $this->helper->route('oxpus_notes_controller'),
++ 
++ 			'U_NEW_NOTE'			=> $this->helper->route('oxpus_notes_controller', ['mode' => 'new_note']),
+++
+++			'S_SHOW_BUTTON'			=> ($total_notes) ? true : false,
++ 		]);
++ 
++ 		/*
++@@ -492,6 +504,7 @@ class main
++ 						'U_EDIT_NOTE'	=> $u_edit,
++ 					]);
++ 				}
+++				$this->template->assign_var('S_SHOW_BUTTON', false);
++ 			}
++ 			else
++ 			{
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/diff_full.tmp"
++new file mode 100644
++index 000000000..29c0e517f
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/diff_full.tmp"
++@@ -0,0 +1,108 @@
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\oxpus\\notes/README.md" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\oxpus\\notes/README.md"
+++deleted file mode 100644
+++index 886a99d2c..000000000
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\oxpus\\notes/README.md"
++++++ /dev/null
+++@@ -1,24 +0,0 @@
+++-ANZEIGENAME
+++-===================
+++-
+++-# phpBB 3.1 Personal Notes Extension
+++-
+++-Personal notes for all users
+++-
+++-## Description
+++-
+++-Allows to manage own personal notes which can not be viewed by other users
+++-
+++-## Installation
+++-
+++-Upload the content of the folder "ext" into your forum folder /ext/.
+++-After this enable the extension under "ACP" > "Customise" > "Extensions" > "Personal Notes"
+++-
+++-## Collaborate
+++-
+++-* For support visit the forum under http://phpbb3.oxpus.net
+++-* To post an issue with this extention please use the bug tracker http://phpbb3.oxpus.net/downloads.php?view=bug_tracker
+++-
+++-## License
+++-
+++-[GPLv2](license.txt)
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\oxpus\\notes/config/services.yml" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/config/services.yml"
+++index 776226141..c159bc16d 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\oxpus\\notes/config/services.yml"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/config/services.yml"
+++@@ -11,6 +11,7 @@ services:
+++             - '@dbal.conn'
+++             - '@config'
+++             - '@controller.helper'
++++            - '@auth'
+++             - '@request'
+++             - '@template'
+++             - '@user'
+++@@ -22,6 +23,7 @@ services:
+++         arguments:
+++             - '@dbal.conn'
+++             - '@controller.helper'
++++            - '@auth'
+++             - '@template'
+++             - '@user'
+++             - '@language'
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\oxpus\\notes/controller/main.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/controller/main.php"
+++index b49c45302..85cb191dd 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\oxpus\\notes/controller/main.php"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/controller/main.php"
+++@@ -17,6 +17,7 @@ class main
+++ 	protected $db;
+++ 	protected $config;
+++ 	protected $helper;
++++	protected $auth;
+++ 	protected $request;
+++ 	protected $template;
+++ 	protected $user;
+++@@ -31,6 +32,7 @@ class main
+++ 	* @param \phpbb\db\driver\driver_interfacer		$db
+++ 	* @param \phpbb\config\config					$config
+++ 	* @param \phpbb\controller\helper				$helper
++++	* @param \phpbb\auth\auth						$auth
+++ 	* @param \phpbb\request\request_interface 		$request
+++ 	* @param \phpbb\template\template				$template
+++ 	* @param \phpbb\user							$user
+++@@ -43,6 +45,7 @@ class main
+++ 		\phpbb\db\driver\driver_interface $db,
+++ 		\phpbb\config\config $config,
+++ 		\phpbb\controller\helper $helper,
++++		\phpbb\auth\auth $auth,
+++ 		\phpbb\request\request_interface $request,
+++ 		\phpbb\template\template $template,
+++ 		\phpbb\user $user,
+++@@ -55,19 +58,19 @@ class main
+++ 		$this->db 						= $db;
+++ 		$this->config 					= $config;
+++ 		$this->helper 					= $helper;
++++		$this->auth						= $auth;
+++ 		$this->request					= $request;
+++ 		$this->template 				= $template;
+++ 		$this->user 					= $user;
+++ 		$this->language					= $language;
+++-
+++ 		$this->notes_table				= $notes_table;
+++ 	}
+++ 
+++ 	public function handle()
+++ 	{
+++-		if ( !$this->user->data['is_registered'] )
++++		if (!$this->auth->acl_get('u_notes'))
+++ 		{
+++-			redirect($this->root_path . 'index.' . $this->php_ext);
++++			throw new \phpbb\exception\http_exception(404, 'PAGE_NOT_FOUND');
+++ 		}
+++ 
+++ 		include_once($this->root_path . 'includes/functions_user.' . $this->php_ext);
+++@@ -82,7 +85,7 @@ class main
+++ 		* Get the variable contents
+++ 		*/
+++ 		$cancel				= $this->request->variable('cancel', '');
+++-		$sql_order			= $this->request->variable('sort_order', 'ASC');
++++		$sql_order			= $this->request->variable('sort_order', 'DESC');
+++ 		$sql_order_by		= $this->request
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\oxpus\\notes/event/main_listener.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/event/main_listener.php"
++index 9dc7355c5..92f7220ca 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\oxpus\\notes/event/main_listener.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/event/main_listener.php"
++@@ -33,6 +33,7 @@ class main_listener implements EventSubscriberInterface
++ 
++ 	protected $db;
++ 	protected $helper;
+++	protected $auth;
++ 	protected $template;
++ 	protected $user;
++ 	protected $language;
++@@ -43,6 +44,7 @@ class main_listener implements EventSubscriberInterface
++ 	*
++ 	* @param \phpbb\db\driver\driver_interfacer		$db
++ 	* @param \phpbb\controller\helper				$helper
+++	* @param \phpbb\auth\auth						$auth
++ 	* @param \phpbb\template\template				$template
++ 	* @param \phpbb\user							$user
++ 	* @param \phpbb\language\language				$language
++@@ -51,6 +53,7 @@ class main_listener implements EventSubscriberInterface
++ 	public function __construct(
++ 		\phpbb\db\driver\driver_interface $db,
++ 		\phpbb\controller\helper $helper,
+++		\phpbb\auth\auth $auth,
++ 		\phpbb\template\template $template,
++ 		\phpbb\user $user,
++ 		\phpbb\language\language $language,
++@@ -59,10 +62,10 @@ class main_listener implements EventSubscriberInterface
++ 	{
++ 		$this->db 						= $db;
++ 		$this->helper 					= $helper;
+++		$this->auth						= $auth;
++ 		$this->template 				= $template;
++ 		$this->user 					= $user;
++ 		$this->language					= $language;
++-
++ 		$this->notes_table 				= $notes_table;
++ 	}
++ 
++@@ -80,18 +83,20 @@ class main_listener implements EventSubscriberInterface
++ 
++ 	public function add_page_header_links()
++ 	{
++-		if ($this->user->data['is_registered'])
+++		if ($this->auth->acl_get('u_notes'))
++ 		{
++ 			$ext_main_link = $this->helper->route('oxpus_notes_controller');
++ 
++ 			if ($this->user->data['user_popup_notes'])
++ 			{
++ 				$u_notes_path	= "javascript:notes()";
+++				$u_notes_home	= $ext_main_link;
++ 				$u_notes_popup	= $ext_main_link;
++ 			}
++ 			else
++ 			{
++ 				$u_notes_path	= $ext_main_link;
+++				$u_notes_home	= $ext_main_link;
++ 				$u_notes_popup	= '';
++ 			}
++ 
++@@ -111,6 +116,7 @@ class main_listener implements EventSubscriberInterface
++ 			if ($total_note_mems)
++ 			{
++ 				$u_notes_path = (!$this->user->data['user_popup_notes']) ? $this->helper->route('oxpus_notes_controller', ['mem_drop' => 1, 'mem_time' => $cur_time]) : $u_notes_path;
+++				$u_notes_home = ($this->user->data['user_popup_notes']) ? $this->helper->route('oxpus_notes_controller', ['mem_drop' => 1, 'mem_time' => $cur_time]) : $u_notes_home;
++ 				$u_notes_popup = ($this->user->data['user_popup_notes']) ? $this->helper->route('oxpus_notes_controller', ['mem_drop' => 1, 'mem_time' => $cur_time]) : '';
++ 
++ 				$this->template->assign_var('S_NOTES_MEM', true);
++@@ -120,8 +126,9 @@ class main_listener implements EventSubscriberInterface
++ 			}
++ 
++ 			$this->template->assign_vars([
++-				'U_NOTES_PATH'	=> $u_notes_path,
++-				'U_NOTES_POPUP'	=> ($this->user->data['user_popup_notes']) ? str_replace('&amp;', '&', $u_notes_popup) : $u_notes_popup,
+++				'U_NOTES_PATH'			=> $u_notes_path,
+++				'U_NOTES_HOME'			=> $u_notes_home,
+++				'U_NOTES_POPUP'			=> ($this->user->data['user_popup_notes']) ? str_replace('&amp;', '&', $u_notes_popup) : $u_notes_popup,
++ 			]);
++ 		}
++ 	}
++@@ -152,6 +159,7 @@ class main_listener implements EventSubscriberInterface
++ 
++ 		$permission = $event['permissions'];
++ 		$permission['a_notes'] = ['lang' => 'ACL_A_NOTES', 'cat' => 'notes'];
+++		$permission['u_notes'] = ['lang' => 'ACL_U_NOTES', 'cat' => 'misc'];
++ 		$event['permissions'] = $permission;
++ 	}
++ }
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\oxpus\\notes/ext.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/ext.php"
++index 201d0c43d..ab4e45a99 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\oxpus\\notes/ext.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/ext.php"
++@@ -1,5 +1,4 @@
++ <?php
++-
++ /**
++ *
++ * @package phpBB Extension - Personal Notes
++@@ -12,4 +11,61 @@ namespace oxpus\notes;
++ 
++ class ext extends \phpbb\extension\base
++ {
+++	/**
+++	 * Check whether or not the extension can be enabled.
+++	 * The current phpBB version should meet or exceed
+++	 * the minimum version required by this extension:
+++	 *
+++	 * Requires phpBB 3.3.0 and PHP 7.3.0.
+++	 *
+++	 * @return bool
+++	 * @access public
+++	 */
+++	public function is_enableable()
+++	{
+++		if (!version_compare(PHP_VERSION, '7.3.0', '>='))
+++		{
+++			$this->container->get('user')->add_lang_ext('oxpus/notes', 'info_acp_notes');
+++			return [$this->container->get('user')->lang('PHP_ERROR')];
+++		}
+++
+++		if (!phpbb_version_compare(PHPBB_VERSION, '3.3.0', '>='))
+++		{
+++			$this->container->get('user')->add_lang_ext('oxpus/notes', 'info_acp_notes');
+++			return [$this->container->get('user')->lang('PHPBB_ERROR')];
+++		}
+++
+++		return true;
+++	}
+++
+++	/**
+++	 * @param mixed $old_state State returned by previous call of this method
+++	 * @return mixed Returns false after last step, otherwise temporary state
+++	 * @access public
+++	 */
+++	function enable_step($old_state)
+++	{
+++		switch ($old_state)
+++		{
+++			case '': // Empty means nothing has run yet
+++				if (empty($old_state))
+++				{
+++					$this->container->get('user')->add_lang_ext('oxpus/notes', 'info_acp_notes');
+++					$this->container->get('template')->assign_var('L_EXTENSION_ENABLE_SUCCESS', $this->container->get('user')->lang['EXTENSION_ENABLE_SUCCESS'] . 
+++					(isset($this->container->get('user')->lang['NOTES_NOTICE']) ? $this->container->get('user')->lang['NOTES_NOTICE'] : ''));
+++				}
+++
+++				// Run parent enable step method
+++				return parent::enable_step($old_state);
+++			
+++			break;
+++			
+++			default:
+++			
+++				// Run parent enable step method
+++				return parent::enable_step($old_state);
+++				
+++			break;
+++		}
+++	}
++ }
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\oxpus\\notes/language/de/common.php" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\oxpus\\notes/language/de/common.php"
++deleted file mode 100644
++index 7b997e599..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\oxpus\\notes/language/de/common.php"
+++++ /dev/null
++@@ -1,45 +0,0 @@
++-<?php
++-
++-/**
++-*
++-* @package phpBB Extension - Personal Notes
++-* @copyright (c) 2014 OXPUS - www.oxpus.net
++-* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
++-*
++-*/
++-
++-/*
++-* [ german ] language file
++-*/
++-
++-/**
++-* DO NOT CHANGE
++-*/
++-if (!defined('IN_PHPBB'))
++-{
++-	exit;
++-}
++-
++-if (empty($lang) || !is_array($lang))
++-{
++-	$lang = [];
++-}
++-
++-$lang = array_merge($lang, [
++-	'ACP_NOTES'				=> 'Notizen einstellen',
++-	'ACP_NOTES_SETTINGS'	=> 'Max. Anzahl Notizen je Benutzer',
++-	'UCP_NOTES'				=> 'Notizen',
++-	'UCP_NOTES_CONFIG'		=> 'Einstellungen',
++-
++-	'NOTES'				=> 'Notizen',
++-	'POPUP_NOTES'		=> 'Zeige persönliche Notizen als Popup',
++-	'SLIDE_NOTES'		=> 'Notizen als Titelliste öffnen, Anzeigen per Klick auf den Titel',
++-	'FILTER_NOTES'		=> '<strong>Filteranzeige</strong><br />Klicke erneut auf den Such-Button oder ändere die Sortierung, um alle Notizen anzuzeigen.',
++-	'NOTES_MEM'			=> 'An Notiz erinnern',
++-	'NOTES_MEM_TIME'	=> 'Erinnerungszeit',
++-	'NOTES_MEMTEXT'		=> '<strong>Du hast Notizen erfasst, an die Du erinnert werden wolltest.</strong><br />%sKlicke hier, um diese Notizen anzuzeigen.%s<br />(Du wirst danach nicht mehr an diese Notizen erinnert)',
++-	'NO_NOTES'			=> 'Du hast zur Zeit keine Notizen',
++-
++-	'NOTES_CONFIG_SUCCESSFULL'	=> 'Die Einstellungen der Notizen wurden erfolgreich gespeichert.',
++-	'NOTES_LOG_CONFIG'			=> 'Anzahl Notizen je Benutzer geändert',
++-]);
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\oxpus\\notes/language/de/email/main_mail.txt" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\oxpus\\notes/language/de/email/main_mail.txt"
++deleted file mode 100644
++index f0c9e8b89..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\oxpus\\notes/language/de/email/main_mail.txt"
+++++ /dev/null
++@@ -1,8 +0,0 @@
++-Subject: SUBJECT
++-
++-Hallo {USERNAME},
++-
++-TEXT
++-
++-
++-{BOARD_EMAIL}
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\oxpus\\notes/language/en/common.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/language/en/common.php"
++index ac11480c8..903cf3f21 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\oxpus\\notes/language/en/common.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/language/en/common.php"
++@@ -32,14 +32,21 @@ $lang = array_merge($lang, [
++ 	'UCP_NOTES_CONFIG'		=> 'Settings',
++ 
++ 	'NOTES'				=> 'Notes',
+++	'NEW_NOTE'			=> 'New note',
+++	'POST_NEW_NOTE'		=> 'Post a new note',
++ 	'POPUP_NOTES'		=> 'Display Personal Notes as Popup',
++ 	'SLIDE_NOTES'		=> 'Open notes as title list, display by clicking the title',
++ 	'FILTER_NOTES'		=> '<strong>Filter mode</strong><br />Press the search button again or change the sort method to display all notes.',
++-	'NOTES_MEM'			=> 'Remember note',
++-	'NOTES_MEM_TIME'	=> 'Remember time',
+++	'NOTES_MEM'			=> 'Set a reminder',
+++	'NOTES_MEM_ENABLE'	=> 'Yes remind me!',
+++	'NOTES_MEM_TIME'	=> 'Set date and time',
++ 	'NOTES_MEMTEXT'		=> '<strong>You have entered notes with a reminder.</strong><br />%sClick here to list these notes.%s<br />(Clicking will remove the reminder)',
++ 	'NO_NOTES'			=> 'You currently have no notes',
++ 
+++	'NOTES_DISCLAIMER'  		=> '**Notes you see here cannot be seen by anyone else, including administrators and moderators. If you have any questions or concerns, please contact a Board Administrator.',
+++	'NOTES_DISCLAIMER_POPUP'	=> '**Notes you see here cannot be seen by anyone else, including administrators and moderators.',
+++
++ 	'NOTES_CONFIG_SUCCESSFULL'	=> 'The settings for the notes are saved successfully.',
+++	'NOTES_DELETE_CONFIRM'		=> 'Are you sure you want to delete this note?',
++ 	'NOTES_LOG_CONFIG'			=> 'Change number of notes per user',
++ ]);
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\oxpus\\notes/language/en/email/main_mail.txt" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/language/en/email/main_mail.txt"
++index a4c64aa3d..3e7ef246c 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\oxpus\\notes/language/en/email/main_mail.txt"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/language/en/email/main_mail.txt"
++@@ -1,8 +1,8 @@
++ Subject: SUBJECT
++ 
++-Hello {USERNAME},
+++Hello {{ USERNAME }},
++ 
++ TEXT
++ 
++ 
++-{BOARD_EMAIL}
++\ No newline at end of file
+++{{ BOARD_EMAIL }}
++\ No newline at end of file
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/language/en/info_acp_notes.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/language/en/info_acp_notes.php"
++new file mode 100644
++index 000000000..9832f319e
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/language/en/info_acp_notes.php"
++@@ -0,0 +1,43 @@
+++<?php
+++/**
+++*
+++* @package phpBB Extension - Personal Notes
+++* @copyright (c) 2014 OXPUS - www.oxpus.net
+++* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
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
+++	$lang = [];
+++}
+++
+++/// DEVELOPERS PLEASE NOTE
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
+++	'NOTES_NOTICE'				    => '<div class="phpinfo"><p>Make sure to check the Group permission and adjust it as needed. By default the Registered user group doesn\'t have access personal notes.</p></div></p></div>',
+++	'PHP_ERROR' 	=> 'This extension requires PHP 7.3.0 (or greater).',
+++	'PHPBB_ERROR' 	=> 'This extension requires phpBB 3.3.0 (or greater).',
+++]);
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\oxpus\\notes/language/en/permissions_notes.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/language/en/permissions_notes.php"
++index 05d3f6832..fccd73c7c 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\oxpus\\notes/language/en/permissions_notes.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/language/en/permissions_notes.php"
++@@ -30,4 +30,5 @@ $lang = array_merge($lang, [
++ 	'ACP_NOTES'		=> 'Notes',
++ 
++ 	'ACL_A_NOTES'	=> 'Can configure personal notes',
+++	'ACL_U_NOTES'	=> 'Can use personal notes',
++ ]);
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/language/pt/common.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/language/pt/common.php"
++new file mode 100644
++index 000000000..5b2d8ce31
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/language/pt/common.php"
++@@ -0,0 +1,52 @@
+++<?php
+++
+++/**
+++*
+++* @package phpBB Extension - Personal Notes
+++* @copyright (c) 2014 OXPUS - www.oxpus.net
+++* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+++*
+++*/
+++
+++/*
+++* [ english ] language file
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
+++	$lang = [];
+++}
+++
+++$lang = array_merge($lang, [
+++	'ACP_NOTES'				=> 'Configurar Notas',
+++	'ACP_NOTES_SETTINGS'	=> 'Número máximo de notas por utilizador',
+++	'UCP_NOTES'				=> 'Notas',
+++	'UCP_NOTES_CONFIG'		=> 'Configurações',
+++
+++	'NOTES'				=> 'Notas',
+++	'NEW_NOTE'			=> 'Nova nota',
+++	'POST_NEW_NOTE'		=> 'Adicionar nova nota',
+++	'POPUP_NOTES'		=> 'Exibir Notas Pessoais como Popup',
+++	'SLIDE_NOTES'		=> 'Abrir notas com lista de títulos, exibir ao clicar no título',
+++	'FILTER_NOTES'		=> '<strong>Modo Filtrado</strong><br />Pressiona o botão de pesquisa novamente ou altera a ordenação para mostrar todas as notas.',
+++	'NOTES_MEM'			=> 'Adicionar lembrete!',
+++	'NOTES_MEM_ENABLE'	=> 'Sim, lembra-me!',
+++	'NOTES_MEM_TIME'	=> 'Colocar data e hora',
+++	'NOTES_MEMTEXT'		=> '<strong>Introduziste notas com lembretes.</strong><br />%sClica aqui para listas essas notas.%s<br />(Clicar irá remover o lembrete)',
+++	'NO_NOTES'			=> 'Não tens quaisquer notas',
+++
+++	'NOTES_DISCLAIMER'  		=> '**As notas que aqui vês só podem ser vistas por ti, e isso inclui moderadores e administradores. Se tiveres alguma dúvida ou preocupações, por favor, contacta a Administração.',
+++	'NOTES_DISCLAIMER_POPUP'	=> '**As notas que aqui vês só podem ser vistas por ti, e isso inclui moderadores e administradores.',
+++
+++	'NOTES_CONFIG_SUCCESSFULL'	=> 'As configurações das notas foram guardadas com sucesso.',
+++	'NOTES_DELETE_CONFIRM'		=> 'Tens a certeza que desejas apagar esta nota?',
+++	'NOTES_LOG_CONFIG'			=> 'Alterar número de notas por utilizador',
+++]);
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/language/pt/email/main_mail.txt" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/language/pt/email/main_mail.txt"
++new file mode 100644
++index 000000000..57246e2b6
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/language/pt/email/main_mail.txt"
++@@ -0,0 +1,8 @@
+++Subject: SUBJECT
+++
+++Olá {{ USERNAME }},
+++
+++TEXT
+++
+++
+++{{ BOARD_EMAIL }}
++\ No newline at end of file
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/language/pt/info_acp_notes.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/language/pt/info_acp_notes.php"
++new file mode 100644
++index 000000000..9832f319e
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/language/pt/info_acp_notes.php"
++@@ -0,0 +1,43 @@
+++<?php
+++/**
+++*
+++* @package phpBB Extension - Personal Notes
+++* @copyright (c) 2014 OXPUS - www.oxpus.net
+++* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
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
+++	$lang = [];
+++}
+++
+++/// DEVELOPERS PLEASE NOTE
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
+++	'NOTES_NOTICE'				    => '<div class="phpinfo"><p>Make sure to check the Group permission and adjust it as needed. By default the Registered user group doesn\'t have access personal notes.</p></div></p></div>',
+++	'PHP_ERROR' 	=> 'This extension requires PHP 7.3.0 (or greater).',
+++	'PHPBB_ERROR' 	=> 'This extension requires phpBB 3.3.0 (or greater).',
+++]);
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/language/pt/permissions_notes.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/language/pt/permissions_notes.php"
++new file mode 100644
++index 000000000..44b588c10
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/language/pt/permissions_notes.php"
++@@ -0,0 +1,34 @@
+++<?php
+++
+++/**
+++*
+++* @package phpBB Extension - Personal notes
+++* @copyright (c) 2014 OXPUS - www.oxpus.net
+++* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+++*
+++*/
+++
+++/**
+++* Language pack for Extension permissions [English]
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
+++	$lang = [];
+++}
+++
+++// Permissions
+++$lang = array_merge($lang, [
+++	'ACP_NOTES'		=> 'Notas',
+++
+++	'ACL_A_NOTES'	=> 'Pode configurar notas pessoais',
+++	'ACL_U_NOTES'	=> 'Pode usar notas pessoais',
+++]);
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/language/pt-preao/common.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/language/pt-preao/common.php"
++new file mode 100644
++index 000000000..5b2d8ce31
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/language/pt-preao/common.php"
++@@ -0,0 +1,52 @@
+++<?php
+++
+++/**
+++*
+++* @package phpBB Extension - Personal Notes
+++* @copyright (c) 2014 OXPUS - www.oxpus.net
+++* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+++*
+++*/
+++
+++/*
+++* [ english ] language file
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
+++	$lang = [];
+++}
+++
+++$lang = array_merge($lang, [
+++	'ACP_NOTES'				=> 'Configurar Notas',
+++	'ACP_NOTES_SETTINGS'	=> 'Número máximo de notas por utilizador',
+++	'UCP_NOTES'				=> 'Notas',
+++	'UCP_NOTES_CONFIG'		=> 'Configurações',
+++
+++	'NOTES'				=> 'Notas',
+++	'NEW_NOTE'			=> 'Nova nota',
+++	'POST_NEW_NOTE'		=> 'Adicionar nova nota',
+++	'POPUP_NOTES'		=> 'Exibir Notas Pessoais como Popup',
+++	'SLIDE_NOTES'		=> 'Abrir notas com lista de títulos, exibir ao clicar no título',
+++	'FILTER_NOTES'		=> '<strong>Modo Filtrado</strong><br />Pressiona o botão de pesquisa novamente ou altera a ordenação para mostrar todas as notas.',
+++	'NOTES_MEM'			=> 'Adicionar lembrete!',
+++	'NOTES_MEM_ENABLE'	=> 'Sim, lembra-me!',
+++	'NOTES_MEM_TIME'	=> 'Colocar data e hora',
+++	'NOTES_MEMTEXT'		=> '<strong>Introduziste notas com lembretes.</strong><br />%sClica aqui para listas essas notas.%s<br />(Clicar irá remover o lembrete)',
+++	'NO_NOTES'			=> 'Não tens quaisquer notas',
+++
+++	'NOTES_DISCLAIMER'  		=> '**As notas que aqui vês só podem ser vistas por ti, e isso inclui moderadores e administradores. Se tiveres alguma dúvida ou preocupações, por favor, contacta a Administração.',
+++	'NOTES_DISCLAIMER_POPUP'	=> '**As notas que aqui vês só podem ser vistas por ti, e isso inclui moderadores e administradores.',
+++
+++	'NOTES_CONFIG_SUCCESSFULL'	=> 'As configurações das notas foram guardadas com sucesso.',
+++	'NOTES_DELETE_CONFIRM'		=> 'Tens a certeza que desejas apagar esta nota?',
+++	'NOTES_LOG_CONFIG'			=> 'Alterar número de notas por utilizador',
+++]);
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/language/pt-preao/email/main_mail.txt" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/language/pt-preao/email/main_mail.txt"
++new file mode 100644
++index 000000000..57246e2b6
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/language/pt-preao/email/main_mail.txt"
++@@ -0,0 +1,8 @@
+++Subject: SUBJECT
+++
+++Olá {{ USERNAME }},
+++
+++TEXT
+++
+++
+++{{ BOARD_EMAIL }}
++\ No newline at end of file
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/language/pt-preao/info_acp_notes.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/language/pt-preao/info_acp_notes.php"
++new file mode 100644
++index 000000000..9832f319e
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/language/pt-preao/info_acp_notes.php"
++@@ -0,0 +1,43 @@
+++<?php
+++/**
+++*
+++* @package phpBB Extension - Personal Notes
+++* @copyright (c) 2014 OXPUS - www.oxpus.net
+++* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
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
+++	$lang = [];
+++}
+++
+++/// DEVELOPERS PLEASE NOTE
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
+++	'NOTES_NOTICE'				    => '<div class="phpinfo"><p>Make sure to check the Group permission and adjust it as needed. By default the Registered user group doesn\'t have access personal notes.</p></div></p></div>',
+++	'PHP_ERROR' 	=> 'This extension requires PHP 7.3.0 (or greater).',
+++	'PHPBB_ERROR' 	=> 'This extension requires phpBB 3.3.0 (or greater).',
+++]);
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\oxpus\\notes/language/de/permissions_notes.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/language/pt-preao/permissions_notes.php"
++similarity index 67%
++rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\oxpus\\notes/language/de/permissions_notes.php"
++rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/language/pt-preao/permissions_notes.php"
++index ce3c705da..44b588c10 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\oxpus\\notes/language/de/permissions_notes.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/language/pt-preao/permissions_notes.php"
++@@ -9,7 +9,7 @@
++ */
++ 
++ /**
++-* Language pack for Extension permissions [German]
+++* Language pack for Extension permissions [English]
++ */
++ 
++ /**
++@@ -27,6 +27,8 @@ if (empty($lang) || !is_array($lang))
++ 
++ // Permissions
++ $lang = array_merge($lang, [
++-	'ACP_NOTES'		=> 'Notizen',
++-	'ACL_A_NOTES'	=> 'Kann die persönlichen Notizen einstellen',
+++	'ACP_NOTES'		=> 'Notas',
+++
+++	'ACL_A_NOTES'	=> 'Pode configurar notas pessoais',
+++	'ACL_U_NOTES'	=> 'Pode usar notas pessoais',
++ ]);
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\oxpus\\notes/license.txt" "b/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\oxpus\\notes/license.txt"
++deleted file mode 100644
++index ce992b2ce..000000000
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\oxpus\\notes/license.txt"
+++++ /dev/null
++@@ -1,281 +0,0 @@
++-		    GNU GENERAL PUBLIC LICENSE
++-		       Version 2, June 1991
++-
++- Copyright (C) 1989, 1991 Free Software Foundation, Inc.
++-                          675 Mass Ave, Cambridge, MA 02139, USA
++- Everyone is permitted to copy and distribute verbatim copies
++- of this license document, but changing it is not allowed.
++-
++-			    Preamble
++-
++-  The licenses for most software are designed to take away your
++-freedom to share and change it.  By contrast, the GNU General Public
++-License is intended to guarantee your freedom to share and change free
++-software--to make sure the software is free for all its users.  This
++-General Public License applies to most of the Free Software
++-Foundation's software and to any other program whose authors commit to
++-using it.  (Some other Free Software Foundation software is covered by
++-the GNU Library General Public License instead.)  You can apply it to
++-your programs, too.
++-
++-  When we speak of free software, we are referring to freedom, not
++-price.  Our General Public Licenses are designed to make sure that you
++-have the freedom to distribute copies of free software (and charge for
++-this service if you wish), that you receive source code or can get it
++-if you want it, that you can change the software or use pieces of it
++-in new free programs; and that you know you can do these things.
++-
++-  To protect your rights, we need to make restrictions that forbid
++-anyone to deny you these rights or to ask you to surrender the rights.
++-These restrictions translate to certain responsibilities for you if you
++-distribute copies of the software, or if you modify it.
++-
++-  For example, if you distribute copies of such a program, whether
++-gratis or for a fee, you must give the recipients all the rights that
++-you have.  You must make sure that they, too, receive or can get the
++-source code.  And you must show them these terms so they know their
++-rights.
++-
++-  We protect your rights with two steps: (1) copyright the software, and
++-(2) offer you this license which gives you legal permission to copy,
++-distribute and/or modify the software.
++-
++-  Also, for each author's protection and ours, we want to make certain
++-that everyone understands that there is no warranty for this free
++-software.  If the software is modified by someone else and passed on, we
++-want its recipients to know that what they have is not the original, so
++-that any problems introduced by others will not reflect on the original
++-authors' reputations.
++-
++-  Finally, any free program is threatened constantly by software
++-patents.  We wish to avoid the danger that redistributors of a free
++-program will individually obtain patent licenses, in effect making the
++-program proprietary.  To prevent this, we have made it clear that any
++-patent must be licensed for everyone's free use or not licensed at all.
++-
++-  The precise terms and conditions for copying, distribution and
++-modification follow.
++-
++-		    GNU GENERAL PUBLIC LICENSE
++-   TERMS AND CONDITIONS FOR COPYING, DISTRIBUTION AND MODIFICATION
++-
++-  0. This License applies to any program or other work which contains
++-a notice placed by the copyright holder saying it may be distributed
++-under the terms of this General Public License.  The "Program", below,
++-refers to any such program or work, and a "work based on the Program"
++-means either the Program or any derivative work under copyright law:
++-that is to say, a work containing the Program or a portion of it,
++-either verbatim or with modifications and/or translated into another
++-language.  (Hereinafter, translation is included without limitation in
++-the term "modification".)  Each licensee is addressed as "you".
++-
++-Activities other than copying, distribution and modification are not
++-covered by this License; they are outside its scope.  The act of
++-running the Program is not restricted, and the output from the Program
++-is covered only if its contents constitute a work based on the
++-Program (independent of having been made by running the Program).
++-Whether that is true depends on what the Program does.
++-
++-  1. You may copy and distribute verbatim copies of the Program's
++-source code as you receive it, in any medium, provided that you
++-conspicuously and appropriately publish on each copy an appropriate
++-copyright notice and disclaimer of warranty; keep intact all the
++-notices that refer to this License and to the absence of any warranty;
++-and give any other recipients of the Program a copy of this License
++-along with the Program.
++-
++-You may charge a fee for the physical act of transferring a copy, and
++-you may at your option offer warranty protection in exchange for a fee.
++-
++-  2. You may modify your copy or copies of the Program or any portion
++-of it, thus forming a work based on the Program, and copy and
++-distribute such modifications or work under the terms of Section 1
++-above, provided that you also meet all of these conditions:
++-
++-    a) You must cause the modified files to carry prominent notices
++-    stating that you changed the files and the date of any change.
++-
++-    b) You must cause any work that you distribute or publish, that in
++-    whole or in part contains or is derived from the Program or any
++-    part thereof, to be licensed as a whole at no charge to all third
++-    parties under the terms of this License.
++-
++-    c) If the modified program normally reads commands interactively
++-    when run, you must cause it, when started running for such
++-    interactive use in the most ordinary way, to print or display an
++-    announcement including an appropriate copyright notice and a
++-    notice that there is no warranty (or else, saying that you provide
++-    a warranty) and that users may redistribute the program under
++-    these conditions, and telling the user how to view a copy of this
++-    License.  (Exception: if the Program itself is interactive but
++-    does not normally print such an announcement, your work based on
++-    the Program is not required to print an announcement.)
++-
++-These requirements apply to the modified work as a whole.  If
++-identifiable sections of that work are not derived from the Program,
++-and can be reasonably considered independent and separate works in
++-themselves, then this License, and its terms, do not apply to those
++-sections when you distribute them as separate works.  But when you
++-distribute the same sections as part of a whole which is a work based
++-on the Program, the distribution of the whole must be on the terms of
++-this License, whose permissions for other licensees extend to the
++-entire whole, and thus to each and every part regardless of who wrote it.
++-
++-Thus, it is not the intent of this section to claim rights or contest
++-your rights to work written entirely by you; rather, the intent is to
++-exercise the right to control the distribution of derivative or
++-collective works based on the Program.
++-
++-In addition, mere aggregation of another work not based on the Program
++-with the Program (or with a work based on the Program) on a volume of
++-a storage or distribution medium does not bring the other work under
++-the scope of this License.
++-
++-  3. You may copy and distribute the Program (or a work based on it,
++-under Section 2) in object code or executable form under the terms of
++-Sections 1 and 2 above provided that you also do one of the following:
++-
++-    a) Accompany it with the complete corresponding machine-readable
++-    source code, which must be distributed under the terms of Sections
++-    1 and 2 above on a medium customarily used for software interchange; or,
++-
++-    b) Accompany it with a written offer, valid for at least three
++-    years, to give any third party, for a charge no more than your
++-    cost of physically performing source distribution, a complete
++-    machine-readable copy of the corresponding source code, to be
++-    distributed under the terms of Sections 1 and 2 above on a medium
++-    customarily used for software interchange; or,
++-
++-    c) Accompany it with the information you received as to the offer
++-    to distribute corresponding source code.  (This alternative is
++-    allowed only for noncommercial distribution and only if you
++-    received the program in object code or executable form with such
++-    an offer, in accord with Subsection b above.)
++-
++-The source code for a work means the preferred form of the work for
++-making modifications to it.  For an executable work, complete source
++-code means all the source code for all modules it contains, plus any
++-associated interface definition files, plus the scripts used to
++-control compilation and installation of the executable.  However, as a
++-special exception, the source code distributed need not include
++-anything that is normally distributed (in either source or binary
++-form) with the major components (compiler, kernel, and so on) of the
++-operating system on which the executable runs, unless that component
++-itself accompanies the executable.
++-
++-If distribution of executable or object code is made by offering
++-access to copy from a designated place, then offering equivalent
++-access to copy the source code from the same place counts as
++-distribution of the source code, even though third parties are not
++-compelled to copy the source along with the object code.
++-
++-  4. You may not copy, modify, sublicense, or distribute the Program
++-except as expressly provided under this License.  Any attempt
++-otherwise to copy, modify, sublicense or distribute the Program is
++-void, and will automatically terminate your rights under this License.
++-However, parties who have received copies, or rights, from you under
++-this License will not have their licenses terminated so long as such
++-parties remain in full compliance.
++-
++-  5. You are not required to accept this License, since you have not
++-signed it.  However, nothing else grants you permission to modify or
++-distribute the Program or its derivative works.  These actions are
++-prohibited by law if you do not accept this License.  Therefore, by
++-modifying or distributing the Program (or any work based on the
++-Program), you indicate your acceptance of this License to do so, and
++-all its terms and conditions for copying, distributing or modifying
++-the Program or works based on it.
++-
++-  6. Each time you redistribute the Program (or any work based on the
++-Program), the recipient automatically receives a license from the
++-original licensor to copy, distribute or modify the Program subject to
++-these terms and conditions.  You may not impose any further
++-restrictions on the recipients' exercise of the rights granted herein.
++-You are not responsible for enforcing compliance by third parties to
++-this License.
++-
++-  7. If, as a consequence of a court judgment or allegation of patent
++-infringement or for any other reason (not limited to patent issues),
++-conditions are imposed on you (whether by court order, agreement or
++-otherwise) that contradict the conditions of this License, they do not
++-excuse you from the conditions of this License.  If you cannot
++-distribute so as to satisfy simultaneously your obligations under this
++-License and any other pertinent obligations, then as a consequence you
++-may not distribute the Program at all.  For example, if a patent
++-license would not permit royalty-free redistribution of the Program by
++-all those who receive copies directly or indirectly through you, then
++-the only way you could satisfy both it and this License would be to
++-refrain entirely from distribution of the Program.
++-
++-If any portion of this section is held invalid or unenforceable under
++-any particular circumstance, the balance of the section is intended to
++-apply and the section as a whole is intended to apply in other
++-circumstances.
++-
++-It is not the purpose of this section to induce you to infringe any
++-patents or other property right claims or to contest validity of any
++-such claims; this section has the sole purpose of protecting the
++-integrity of the free software distribution system, which is
++-implemented by public license practices.  Many people have made
++-generous contributions to the wide range of software distributed
++-through that system in reliance on consistent application of that
++-system; it is up to the author/donor to decide if he or she is willing
++-to distribute software through any other system and a licensee cannot
++-impose that choice.
++-
++-This section is intended to make thoroughly clear what is believed to
++-be a consequence of the rest of this License.
++-
++-  8. If the distribution and/or use of the Program is restricted in
++-certain countries either by patents or by copyrighted interfaces, the
++-original copyright holder who places the Program under this License
++-may add an explicit geographical distribution limitation excluding
++-those countries, so that distribution is permitted only in or among
++-countries not thus excluded.  In such case, this License incorporates
++-the limitation as if written in the body of this License.
++-
++-  9. The Free Software Foundation may publish revised and/or new versions
++-of the General Public License from time to time.  Such new versions will
++-be similar in spirit to the present version, but may differ in detail to
++-address new problems or concerns.
++-
++-Each version is given a distinguishing version number.  If the Program
++-specifies a version number of this License which applies to it and "any
++-later version", you have the option of following the terms and conditions
++-either of that version or of any later version published by the Free
++-Software Foundation.  If the Program does not specify a version number of
++-this License, you may choose any version ever published by the Free Software
++-Foundation.
++-
++-  10. If you wish to incorporate parts of the Program into other free
++-programs whose distribution conditions are different, write to the author
++-to ask for permission.  For software which is copyrighted by the Free
++-Software Foundation, write to the Free Software Foundation; we sometimes
++-make exceptions for this.  Our decision will be guided by the two goals
++-of preserving the free status of all derivatives of our free software and
++-of promoting the sharing and reuse of software generally.
++-
++-			    NO WARRANTY
++-
++-  11. BECAUSE THE PROGRAM IS LICENSED FREE OF CHARGE, THERE IS NO WARRANTY
++-FOR THE PROGRAM, TO THE EXTENT PERMITTED BY APPLICABLE LAW.  EXCEPT WHEN
++-OTHERWISE STATED IN WRITING THE COPYRIGHT HOLDERS AND/OR OTHER PARTIES
++-PROVIDE THE PROGRAM "AS IS" WITHOUT WARRANTY OF ANY KIND, EITHER EXPRESSED
++-OR IMPLIED, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF
++-MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE.  THE ENTIRE RISK AS
++-TO THE QUALITY AND PERFORMANCE OF THE PROGRAM IS WITH YOU.  SHOULD THE
++-PROGRAM PROVE DEFECTIVE, YOU ASSUME THE COST OF ALL NECESSARY SERVICING,
++-REPAIR OR CORRECTION.
++-
++-  12. IN NO EVENT UNLESS REQUIRED BY APPLICABLE LAW OR AGREED TO IN WRITING
++-WILL ANY COPYRIGHT HOLDER, OR ANY OTHER PARTY WHO MAY MODIFY AND/OR
++-REDISTRIBUTE THE PROGRAM AS PERMITTED ABOVE, BE LIABLE TO YOU FOR DAMAGES,
++-INCLUDING ANY GENERAL, SPECIAL, INCIDENTAL OR CONSEQUENTIAL DAMAGES ARISING
++-OUT OF THE USE OR INABILITY TO USE THE PROGRAM (INCLUDING BUT NOT LIMITED
++-TO LOSS OF DATA OR DATA BEING RENDERED INACCURATE OR LOSSES SUSTAINED BY
++-YOU OR THIRD PARTIES OR A FAILURE OF THE PROGRAM TO OPERATE WITH ANY OTHER
++-PROGRAMS), EVEN IF SUCH HOLDER OR OTHER PARTY HAS BEEN ADVISED OF THE
++-POSSIBILITY OF SUCH DAMAGES.
++-
++-		     END OF TERMS AND CONDITIONS
++-
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\oxpus\\notes/migrations/release_3_0_0.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/migrations/release_3_0_0.php"
++index 98c1a3020..716d6257b 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\oxpus\\notes/migrations/release_3_0_0.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/migrations/release_3_0_0.php"
++@@ -57,12 +57,14 @@ class release_3_0_0 extends \phpbb\db\migration\migration
++ 
++ 			// The needed permissions
++ 			['permission.add', ['a_notes']],
+++			['permission.add', ['u_notes', 1, 0]],
++ 
++-			// Join permissions to administrators
+++			// Join permissions
++ 			['permission.permission_set', ['ROLE_ADMIN_FULL', 'a_notes']],
+++			['permission.permission_set', ['ROLE_USER_FULL', 'u_notes']],
++ 		];
++ 	}
++-
+++			
++ 	public function update_schema()
++ 	{
++ 		return [
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/styles/FLATBOOTS/template/event/navbar_header_profile_list_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/styles/FLATBOOTS/template/event/navbar_header_profile_list_after.html"
++new file mode 100644
++index 000000000..fefe40b0f
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/styles/FLATBOOTS/template/event/navbar_header_profile_list_after.html"
++@@ -0,0 +1,3 @@
+++{% if U_NOTES_PATH %}
+++	<a class="btn btn-default btn-sm btn-block" href="{{ U_NOTES_PATH }}"><i class="fa fa-clipboard"></i>&nbsp;{{ lang('NOTES') }}</a>
+++{% endif %}
++\ No newline at end of file
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/styles/FLATBOOTS/template/event/overall_header_content_before.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/styles/FLATBOOTS/template/event/overall_header_content_before.html"
++new file mode 100644
++index 000000000..89d00a165
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/styles/FLATBOOTS/template/event/overall_header_content_before.html"
++@@ -0,0 +1,12 @@
+++{% if S_NOTES_MEM %}
+++<div class="alert alert-warning fade in">
+++    <i class="fa fa-info"></i> <strong>{{ lang('INFORMATION') }}{{ lang('COLON') }}</strong>&nbsp;{{ NOTES_MEM }}
+++</div>
+++{% endif %}
+++{% if U_NOTES_POPUP %}
+++<script type="text/javascript">
+++    function notes() {
+++        window.open("{{ U_NOTES_POPUP }}", "_blank", "width=800,height=600,scrollbars=yes,resizable=no");
+++    }
+++</script>
+++{% endif %}
++\ No newline at end of file
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/styles/FLATBOOTS/template/event/overall_header_navigation_append.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/styles/FLATBOOTS/template/event/overall_header_navigation_append.html"
++new file mode 100644
++index 000000000..f80d8bc2d
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/styles/FLATBOOTS/template/event/overall_header_navigation_append.html"
++@@ -0,0 +1 @@
+++{% if U_NOTES_PATH %}<li><a href="{{ U_NOTES_PATH }}"><i class="fa fa-fw fa-clipboard"></i>{{ lang('NOTES') }}</a></li>{% endif %}
++\ No newline at end of file
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/styles/FLATBOOTS/template/event/overall_header_stylesheets_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/styles/FLATBOOTS/template/event/overall_header_stylesheets_after.html"
++new file mode 100644
++index 000000000..2f473aa86
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/styles/FLATBOOTS/template/event/overall_header_stylesheets_after.html"
++@@ -0,0 +1,4 @@
+++{% if PAGE_TITLE eq "Notes" %}
+++{% INCLUDECSS '@oxpus_notes/notes.css' %}
+++{% INCLUDEJS '@oxpus_notes/js/notes.js' %}
+++{% endif %}
++\ No newline at end of file
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/styles/FLATBOOTS/template/event/simple_header_stylesheets_after.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/styles/FLATBOOTS/template/event/simple_header_stylesheets_after.html"
++new file mode 100644
++index 000000000..2f473aa86
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/styles/FLATBOOTS/template/event/simple_header_stylesheets_after.html"
++@@ -0,0 +1,4 @@
+++{% if PAGE_TITLE eq "Notes" %}
+++{% INCLUDECSS '@oxpus_notes/notes.css' %}
+++{% INCLUDEJS '@oxpus_notes/js/notes.js' %}
+++{% endif %}
++\ No newline at end of file
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/styles/FLATBOOTS/template/js/notes.js" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/styles/FLATBOOTS/template/js/notes.js"
++new file mode 100644
++index 000000000..b1d11af8e
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/styles/FLATBOOTS/template/js/notes.js"
++@@ -0,0 +1,16 @@
+++/**
+++*
+++* @package phpBB Extension - Personal notes
+++* @copyright (c) 2014 OXPUS - www.oxpus.net
+++* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+++*
+++*/
+++
+++/**
+++* Show/hide notes text
+++*/
+++function showHideNote(note)
+++{
+++	$('#note_' + note).slideToggle();
+++	$('#panel-heading-' + note).toggleClass('note-hidden');
+++}
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/styles/FLATBOOTS/template/note_confirm_body.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/styles/FLATBOOTS/template/note_confirm_body.html"
++new file mode 100644
++index 000000000..7c82fa0d6
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/styles/FLATBOOTS/template/note_confirm_body.html"
++@@ -0,0 +1,31 @@
+++{% if S_AJAX_REQUEST %}
+++<form action="{{ S_CONFIRM_ACTION }}" method="post">
+++	<h3 class="alert_title">{{ MESSAGE_TITLE }}</h3>
+++	<p>{{ MESSAGE_TEXT }}</p>
+++	<fieldset>
+++		<input type="button" name="confirm" value="{{ lang('YES') }}" class="btn btn-default" />
+++		<input type="button" name="cancel" value="{{ lang('NO') }}" class="btn btn-default" />
+++	</fieldset>
+++</form>
+++{% endif %}
+++{% if S_NOTES_POPUP %}
+++{% INCLUDE 'simple_header.html' %}
+++{% else %}
+++{% INCLUDE 'overall_header.html' %}
+++{% endif %}
+++<form id="confirm" action="{{ S_CONFIRM_ACTION }}" method="post">
+++	<div class="side-segment"><h3>{{ MESSAGE_TITLE }}</h3></div>
+++<div class="well">
+++	<p>{{ MESSAGE_TEXT }}</p>
+++	<fieldset>
+++		{{ S_HIDDEN_FIELDS }}
+++		<button type="submit" name="confirm" value="{{ lang('YES') }}" class="btn btn-default">{{ lang('YES') }}</button>
+++		<button type="submit" name="cancel" value="{{ lang('NO') }}" class="btn btn-default">{{ lang('NO') }}</button>
+++	</fieldset>
+++</div>
+++</form>
+++{% if S_NOTES_POPUP %}
+++{% INCLUDE 'simple_footer.html' %}
+++{% else %}
+++{% INCLUDE 'overall_footer.html' %}
+++{% endif %}
++\ No newline at end of file
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/styles/FLATBOOTS/template/note_edit_body.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/styles/FLATBOOTS/template/note_edit_body.html"
++new file mode 100644
++index 000000000..95686bae7
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/styles/FLATBOOTS/template/note_edit_body.html"
++@@ -0,0 +1,118 @@
+++{% if S_NOTES_POPUP %}
+++{% INCLUDE 'simple_header.html' %}
+++{% else %}
+++{% INCLUDE 'overall_header.html' %}
+++{% endif %}
+++
+++<h2>{{ lang('NOTES') }} - {{ NOTES_TOTAL_USED }} / {{ NOTES_TOTAL_ALLOWED }}</h2>
+++<form action="{{ S_NOTES_FORM_ACTION }}" method="post" id="postform">
+++    <div class="clearfix">
+++        <div class="well">
+++            <div class="side-segment section-posting">
+++                <h3>{{ lang('POST_NEW_NOTE') }}</h3>
+++            </div>
+++            <fieldset>
+++                <div class="control-group">
+++                    <label class="control-label" for="subject">{{ lang('SUBJECT') }}{{ lang('COLON') }}</label>
+++                    <div class="row">
+++                        <div class="col-xs-12 col-lg-8">
+++                            <input type="text" class="form-control input-sm" placeholder="{{ lang('SUBJECT') }}{{ lang('COLON') }}" name="subject" id="subject" maxlength="124" tabindex="2" value="{{ NOTES_SUBJECT }}">
+++                        </div>
+++                    </div>
+++                </div>
+++
+++                <div class="space10"></div>
+++
+++                <label class="control-label">{{ lang('NOTES_MEM') }}{{ lang('COLON') }}</label>
+++
+++                <div class="space10"></div>
+++
+++                <input type="checkbox" name="mem_yesno" id="mem_yesno" value="1"{% if NOTES_MEM_CHECKED %} checked="checked"{% endif %}><label class="checkbox-inline">{{ lang('NOTES_MEM_ENABLE') }}</label>
+++                &nbsp;<i class="icon fa fa-bell" style="transform: rotate(40deg);vertical-align: middle;"></i>
+++                <i class="icon fa fa-bell" style="transform: rotate(-40deg);vertical-align: middle;"></i>
+++
+++                <div class="space10"></div>
+++
+++                <div class="control-group">
+++                    <label for="mem_yesno" class="control-label">{{ lang('NOTES_MEM_TIME') }}{{ lang('COLON') }}</label>
+++                    <div class="controls controls-row">
+++                        <div class="clearfix">
+++                            <div class="controls">
+++                                <div class="selector">
+++                                    <select name="mem_day" class="selectpicker" data-width="auto">
+++                                        {% for notes_days in loops.notes_days %}
+++                                        <option value="{{ notes_days.DAY }}"{% if notes_days.DAY eq S_NOTE_MEM_DAY %} selected="selected"{% endif %}>{{ notes_days.DAY }}</option>
+++                                        {% endfor %}
+++                                    </select>
+++                                    <select name="mem_month" class="selectpicker" data-width="auto">
+++                                        {% for notes_months in loops.notes_months %}
+++                                        <option value="{{ notes_months.MONTH }}"{% if notes_months.MONTH eq S_NOTE_MEM_MONTH %} selected="selected"{% endif %}>{{ notes_months.MONTH }}</option>
+++                                        {% endfor %}
+++                                    </select>
+++                                    <select name="mem_year" class="selectpicker" data-width="auto">
+++                                        {% for notes_years in loops.notes_years %}
+++                                        <option value="{{ notes_years.YEAR }}"{% if notes_years.YEAR eq S_NOTE_MEM_YEAR %} selected="selected"{% endif %}>{{ notes_years.YEAR }}</option>
+++                                        {% endfor %}
+++                                    </select>
+++                                </div>
+++                                <div class="selector">
+++                                    <select name="mem_hour" class="selectpicker" data-width="auto">
+++                                        {% for notes_hours in loops.notes_hours %}
+++                                        <option value="{{ notes_hours.HOUR }}"{% if notes_hours.HOUR eq S_NOTE_MEM_HOUR %} selected="selected"{% endif %}>{{ notes_hours.HOUR }}</option>
+++                                        {% endfor %}
+++                                    </select>
+++                                    <select name="mem_minute" class="selectpicker" data-width="auto">
+++                                        {% for notes_minutes in loops.notes_minutes %}
+++                                        <option value="{{ notes_minutes.MINUTE }}"{% if notes_minutes.MINUTE eq S_NOTE_MEM_MIN %} selected="selected"{% endif %}>{{ notes_minutes.MIN }}</option>
+++                                        {% endfor %}
+++                                    </select>
+++                                </div>
+++                            </div>
+++                        </div>
+++                    </div>
+++                </div>
+++
+++                {% INCLUDE 'posting_buttons.html' %}
+++
+++                <div class="space10"></div>
+++
+++                <div class="row">
+++                    <div class="col-md-8">
+++                        <textarea class="form-control" name="message" id="message" rows="10" tabindex="3" onselect="storeCaret(this);" onclick="storeCaret(this);" onkeyup="storeCaret(this);">{{ NOTES_MESSAGE }}</textarea>
+++                    </div>
+++
+++                    <div class="col-md-4">
+++                        {% if loops.smiley|length %}
+++                        <strong>{{ lang('SMILIES') }}<a class="btn-link btn-xs" href="{{ U_MORE_SMILIES }}" onclick="popup(this.href, 450, 350, '_phpbbsmilies'); return false;" title="{{ lang('MORE_SMILIES') }}"><i class="fa fa-plus"></i></a></strong>
+++                        <br />
+++                        {% for smiley in loops.smiley %}
+++                        <a href="#" onclick="insert_text('{{ smiley.A_SMILEY_CODE }}', true); return false;"><img src="{{ smiley.SMILEY_IMG }}" width="{{ smiley.SMILEY_WIDTH }}" height="{{ smiley.SMILEY_HEIGHT }}" alt="{{ smiley.SMILEY_CODE }}" title="{{ smiley.SMILEY_DESC }}" /></a>
+++                        {% endfor %}
+++                        {% endif %}
+++                    </div>
+++                </div>
+++            </fieldset>
+++
+++            <div class="space10"></div>
+++
+++            <fieldset class="form-actions">
+++                {{ S_NOTES_HIDDEN_FIELDS }}
+++                <button type="submit" class="btn btn-default" name="save" value="{{ lang('SUBMIT') }}" data-loading-text="{{ lang('LOADING') }}<i class='fa fa-spin fa-spinner fa-lg icon-white'></i>">{{ lang('SUBMIT') }}</button>
+++                {{ S_FORM_TOKEN }}
+++            </fieldset>
+++        </div>
+++    </div>
+++</form>
+++
+++<div class="space10"></div>
+++
+++{% if S_NOTES_POPUP %}
+++<br />
+++<p class="submit-buttons">
+++    <input type="submit" name="cancel" class="btn btn-default" value="{{ lang('CLOSE_WINDOW') }}" onclick="javascript:window.close()" />
+++</p>
+++<br />
+++{% INCLUDE 'simple_footer.html' %}
+++{% else %}
+++{% INCLUDE 'overall_footer.html' %}
+++{% endif %}
++\ No newline at end of file
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/styles/FLATBOOTS/template/note_list_body.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/styles/FLATBOOTS/template/note_list_body.html"
++new file mode 100644
++index 000000000..08f725f49
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/styles/FLATBOOTS/template/note_list_body.html"
++@@ -0,0 +1,180 @@
+++{% if S_NOTES_POPUP %}
+++{% INCLUDE 'simple_header.html' %}
+++{% else %}
+++{% INCLUDE 'overall_header.html' %}
+++{% endif %}
+++<div class="side-segment">
+++    <h3>{{ lang('NOTES') }}</h3>
+++</div>
+++
+++{% if not S_NO_NOTES %}
+++<div class="space10"></div>
+++
+++{% if NOTES_FILTER_ACTIVE %}
+++<div class="alert alert-info fade in">
+++    * {{ lang('FILTER_NOTES') }}
+++</div>
+++{% endif %}
+++
+++<div class="row">
+++    <form action="{{ S_NOTES_FORM_ACTION }}" method="post" id="notes">
+++        <fieldset>
+++           <div class="col-md-6 col-sm-6">
+++               <div class="input-group search-notes">
+++                   <select name="search_in" class="selectpicker" data-width="auto">
+++                       <option value="note_subject"{% if NOTES_SEARCH_IN eq 'note_subject' %} selected="selected"{% endif %}>{{ lang('SUBJECT') }}</option>
+++                       <option value="note_text"{% if NOTES_SEARCH_IN eq 'note_text' %} selected="selected"{% endif %}>{{ lang('POST') }}</option>
+++                   </select>
+++                   <input name="search_string" value="all" id="search_string" type="hidden">
+++                   <input class="form-control" name="search_string" type="text">
+++                   <div class="input-group-btn">
+++                       <button type="submit" class="btn btn-info" value="{{ lang('SEARCH') }}{% if NOTES_SEARCH_ACTIVE %}*{% endif %}">{{ lang('SEARCH') }}{% if NOTES_SEARCH_ACTIVE %}*{% endif %}</button>
+++                   </div>
+++               </div>
+++           </div>
+++
+++           <div class="col-md-6 col-sm-6 hidden-xs">
+++               <div class="input-group pull-right">
+++               <select name="sort_by" class="selectpicker" data-width="auto">
+++                   <option value="note_subject"{% if NOTES_SORT_BY eq 'note_subject' %} selected="selected"{% endif %}>{{ lang('SUBJECT') }}</option>
+++                   <option value="note_time"{% if NOTES_SORT_BY eq 'note_time' %} selected="selected"{% endif %}>{{ lang('TIME') }}</option>
+++                   <option value="note_mem"{% if NOTES_SORT_BY eq 'note_mem' %} selected="selected"{% endif %}>{{ lang('NOTES_MEM') }}</option>
+++               </select>
+++               &nbsp;
+++               <select name="sort_order" class="selectpicker" data-width="auto">
+++                   <option value="ASC"{% if NOTES_SORT_ORDER eq 'ASC' %} selected="selected"{% endif %}>{{ lang('ASCENDING') }}</option>
+++                   <option value="DESC"{% if NOTES_SORT_ORDER eq 'DESC' %} selected="selected"{% endif %}>{{ lang('DESCENDING') }}</option>
+++               </select>
+++               &nbsp;
+++               <button type="submit" value="{{ lang('SORT_BY') }}" class="btn btn-info">{{ lang('SORT_BY') }}</button>
+++               </div>
+++            </div>
+++        </fieldset>
+++    </form>
+++</div>
+++
+++<div class="space10"></div>
+++<div class="space10"></div>
+++<div class="space10"></div>
+++<div class="space10"></div>
+++
+++<div class="clearfix">
+++    <div class="pull-left">
+++        {% if S_NEW_NOTE %}<a href="{{ U_NEW_NOTE }}" role="button" class="btn btn-default btn-load" data-loading-text="{{ lang('LOADING') }}&nbsp;<i class='fa-spin fa fa-spinner fa-lg icon-white'></i>"><i class="fa fa-plus"></i>&nbsp;{{ lang('NEW_NOTE') }}</a>
+++        {% endif %}
+++    </div>
+++
+++    {% if not S_NO_NOTES %}
+++    <div class="pull-right">
+++        <ul class="pagination pagination-sm">
+++            <li><a class="pagination-trigger" data-placement="top">{{ lang('NOTES') }}</a></li>
+++            <li class="active"><a>{{ NOTES_TOTAL_USED }} / {{ NOTES_TOTAL_ALLOWED }}</a></li>
+++        </ul>
+++    </div>
+++    {% endif %}
+++</div>
+++{% endif %}
+++
+++{% if S_NO_NOTES %}
+++<div class="space10"></div>
+++<div class="alert alert-info fade in">
+++    <i class="fa fa-info"></i> <strong>{{ lang('INFORMATION') }}{{ lang('COLON') }}</strong>&nbsp;{% if NOTES_NOT_FOUND %}{{ lang('NO_SEARCH_RESULTS') }}{% else %}{{ lang('NO_NOTES') }}{% endif %}
+++</div>
+++{% else %}
+++{% for notes_row in loops.notes_row %}
+++<div class="panel">
+++
+++    <div class="panel-heading{% if NOTES_SLIDE_MODE %} note-hidden" id="panel-heading-{{ notes_row.NOTE_ID }}{% endif %}">
+++        <div class="clearfix">
+++
+++            <div class="side-segment">
+++                <h3 style="border-bottom: 4px solid #e5e5e5;">{% if NOTES_SLIDE_MODE %}<a href="#" onclick="showHideNote({{ notes_row.NOTE_ID }}); return false;">{% endif %}{{ notes_row.NOTE_SUBJECT }}{% if NOTES_SLIDE_MODE %}</a>{% endif %}</h3></div>
+++            <div class="clearfix">
+++                <div class="text-muted pull-left">
+++                    <span><i class="fa fa-clock-o"></i>&nbsp;{{ notes_row.NOTE_DATE }}</span>
+++                </div>
+++                <div class="pull-right">
+++                    <div role="toolbar" class="btn-toolbar">
+++
+++                        <div class="btn-group btn-group-sm" role="group">
+++
+++                            <a class="btn btn-default btn-sm" href="{{ notes_row.U_EDIT_NOTE }}" title="{{ lang('EDIT_POST') }}" role="button"><i class="fa fa-edit"></i></a>
+++
+++                        </div>
+++                        <div class="btn-group btn-group-sm" role="group">
+++
+++                            <a class="btn btn-danger btn-sm" href="{{ notes_row.U_DELETE_NOTE }}" title="{{ lang('DELETE_POST') }}" role="button"><i class="fa fa-trash-o"></i></a>
+++
+++                        </div>
+++
+++                    </div>
+++                </div>
+++            </div>
+++
+++        </div>
+++    </div>
+++
+++    <div class="panel-body{% if NOTES_SLIDE_MODE %} hide-note{% endif %}" id="note_{{ notes_row.NOTE_ID }}">
+++        <div class="clearfix">
+++            <div class="postbody">
+++
+++                <span class="hidden hook-bfr-message"></span>
+++                <div class="content">{{ notes_row.NOTE_TEXT }}</div>
+++                {% if notes_row.NOTES_MEM %}
+++                <div class="notice text-muted">
+++                    <div class="space10"></div>
+++                    <small><span class="label label-danger"><i class="fa fa-bell-o"></i>&nbsp;{{ lang('NOTES_MEM') }}</span>&nbsp;&nbsp;&nbsp;<i class="fa fa-clock-o"></i>&nbsp;{{ notes_row.NOTES_MEM }}</small>
+++                </div>
+++                {% endif %}
+++
+++            </div>
+++        </div>
+++    </div>
+++
+++</div>
+++
+++{% endfor %}
+++{% endif %}
+++
+++<div class="clearfix">
+++    <div class="pull-left">
+++        {% if S_NEW_NOTE %}<a href="{{ U_NEW_NOTE }}" role="button" class="btn btn-default btn-load" data-loading-text="{{ lang('LOADING') }}&nbsp;<i class='fa-spin fa fa-spinner fa-lg icon-white'></i>"><i class="fa fa-plus"></i>&nbsp;{{ lang('NEW_NOTE') }}</a>
+++        {% endif %}
+++        {% if S_SHOW_BUTTON or NOTES_FILTER_ACTIVE %}<a href="{{ U_NOTES_HOME }}" role="button" class="btn btn-default btn-load" data-loading-text="{{ lang('LOADING') }}&nbsp;<i class='fa-spin fa fa-spinner fa-lg icon-white'></i>"><i class="fa fa-list"></i>&nbsp;{{ lang('NOTES') }}</a>
+++        {% endif %}
+++    </div>
+++
+++    {% if not S_NO_NOTES %}
+++    <div class="pull-right">
+++        <ul class="pagination pagination-sm">
+++            <li><a class="pagination-trigger" data-placement="top">{{ lang('NOTES') }}</a></li>
+++            <li class="active"><a>{{ NOTES_TOTAL_USED }} / {{ NOTES_TOTAL_ALLOWED }}</a></li>
+++        </ul>
+++    </div>
+++    {% endif %}
+++</div>
+++
+++{% if S_NO_NOTES %}
+++<div class="space10"></div>
+++<div class="space10"></div>
+++{% endif %}
+++
+++<div class="row">
+++    <div class="col-md-12 col-sm-12">
+++        <p class="text-muted"><small>{% if S_NOTES_POPUP %}{{ lang('NOTES_DISCLAIMER_POPUP') }}{% else %}{{ lang('NOTES_DISCLAIMER') }}{% endif %}</small></p>
+++    </div>
+++</div>
+++
+++{% if S_NOTES_POPUP %}
+++<div class="space10"></div>
+++
+++<p class="submit-buttons">
+++    <input type="submit" name="cancel" class="btn btn-default" value="{{ lang('CLOSE_WINDOW') }}" onclick="javascript:window.close()" />
+++</p>
+++
+++<br />
+++
+++{% INCLUDE 'simple_footer.html' %}
+++{% else %}
+++{% INCLUDE 'overall_footer.html' %}
+++{% endif %}
++\ No newline at end of file
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/styles/FLATBOOTS/template/ucp_notes.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/styles/FLATBOOTS/template/ucp_notes.html"
++new file mode 100644
++index 000000000..182f40604
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/styles/FLATBOOTS/template/ucp_notes.html"
++@@ -0,0 +1,45 @@
+++{% INCLUDE 'ucp_header.html' %}
+++<form id="notes_config" method="post" action="{{ U_NOTES_FORM_ACTION }}">
+++<div class="tab-pane active">
+++    <fieldset class="framed-ucp">
+++        <legend>{{ lang('UCP_NOTES') }}</legend>
+++        <div class="control-group">
+++            <label for="notes_popup1" class="control-label">{{ lang('POPUP_NOTES') }}{{ lang('COLON') }}</label>
+++            <div class="controls controls-row">
+++                <div class="radio">
+++                    <input type="radio" name="notes_popup" id="notes_popup1" value="1" {% if NOTES_POPUP %} checked="checked"{% endif %}/>
+++                    <label for="notes_popup1">{{ lang('YES') }}</label>
+++                </div>
+++                <div class="radio">
+++                    <input type="radio" name="notes_popup" id="notes_popup0" value="0" {% if not NOTES_POPUP %} checked="checked"{% endif %}/>
+++                    <label for="notes_popup0">{{ lang('NO') }}</label>
+++                </div>
+++            </div>
+++
+++            <div class="controls controls-row">
+++                <label for="notes_slide1" class="control-label">{{ lang('SLIDE_NOTES') }}{{ lang('COLON') }}</label>
+++                <div class="controls controls-row">
+++                    <div class="radio">
+++                        <input type="radio" name="notes_slide" id="notes_slide1" value="1" {% if NOTES_SLIDE %} checked="checked"{% endif %}/>
+++                        <label for="notes_slide1">{{ lang('YES') }}</label>
+++                    </div>
+++                    <div class="radio">
+++                        <input type="radio" name="notes_slide" id="notes_slide0" value="0" {% if not NOTES_SLIDE %} checked="checked"{% endif %}/>
+++                        <label for="notes_slide0">{{ lang('NO') }}</label>
+++                    </div>
+++                </div>
+++            </div>
+++        </div>
+++    </fieldset>
+++</div>
+++
+++<div class="space10"></div>
+++
+++<div class="form-actions"> 
+++    {{ S_HIDDEN_FIELDS }}
+++    <button type="submit" name="submit" value="{{ lang('SUBMIT') }}" class="btn btn-default" data-loading-text="{{ lang('LOADING') }}<i class=
\ No newline at end of file
diff --git "[ORIGINAL]/oxpus\\notes/event/main_listener.php" "[FORUM_EXT]/oxpus\\notes/event/main_listener.php"
--- "[ORIGINAL]/oxpus\\notes/event/main_listener.php"
+++ "[FORUM_EXT]/oxpus\\notes/event/main_listener.php"
@@ -33,6 +33,7 @@ class main_listener implements EventSubscriberInterface
 
 	protected $db;
 	protected $helper;
+	protected $auth;
 	protected $template;
 	protected $user;
 	protected $language;
@@ -43,6 +44,7 @@ class main_listener implements EventSubscriberInterface
 	*
 	* @param \phpbb\db\driver\driver_interfacer		$db
 	* @param \phpbb\controller\helper				$helper
+	* @param \phpbb\auth\auth						$auth
 	* @param \phpbb\template\template				$template
 	* @param \phpbb\user							$user
 	* @param \phpbb\language\language				$language
@@ -51,6 +53,7 @@ class main_listener implements EventSubscriberInterface
 	public function __construct(
 		\phpbb\db\driver\driver_interface $db,
 		\phpbb\controller\helper $helper,
+		\phpbb\auth\auth $auth,
 		\phpbb\template\template $template,
 		\phpbb\user $user,
 		\phpbb\language\language $language,
@@ -59,10 +62,10 @@ class main_listener implements EventSubscriberInterface
 	{
 		$this->db 						= $db;
 		$this->helper 					= $helper;
+		$this->auth						= $auth;
 		$this->template 				= $template;
 		$this->user 					= $user;
 		$this->language					= $language;
-
 		$this->notes_table 				= $notes_table;
 	}
 
@@ -80,18 +83,20 @@ class main_listener implements EventSubscriberInterface
 
 	public function add_page_header_links()
 	{
-		if ($this->user->data['is_registered'])
+		if ($this->auth->acl_get('u_notes'))
 		{
 			$ext_main_link = $this->helper->route('oxpus_notes_controller');
 
 			if ($this->user->data['user_popup_notes'])
 			{
 				$u_notes_path	= "javascript:notes()";
+				$u_notes_home	= $ext_main_link;
 				$u_notes_popup	= $ext_main_link;
 			}
 			else
 			{
 				$u_notes_path	= $ext_main_link;
+				$u_notes_home	= $ext_main_link;
 				$u_notes_popup	= '';
 			}
 
@@ -111,6 +116,7 @@ class main_listener implements EventSubscriberInterface
 			if ($total_note_mems)
 			{
 				$u_notes_path = (!$this->user->data['user_popup_notes']) ? $this->helper->route('oxpus_notes_controller', ['mem_drop' => 1, 'mem_time' => $cur_time]) : $u_notes_path;
+				$u_notes_home = ($this->user->data['user_popup_notes']) ? $this->helper->route('oxpus_notes_controller', ['mem_drop' => 1, 'mem_time' => $cur_time]) : $u_notes_home;
 				$u_notes_popup = ($this->user->data['user_popup_notes']) ? $this->helper->route('oxpus_notes_controller', ['mem_drop' => 1, 'mem_time' => $cur_time]) : '';
 
 				$this->template->assign_var('S_NOTES_MEM', true);
@@ -121,6 +127,7 @@ class main_listener implements EventSubscriberInterface
 
 			$this->template->assign_vars([
 				'U_NOTES_PATH'			=> $u_notes_path,
+				'U_NOTES_HOME'			=> $u_notes_home,
 				'U_NOTES_POPUP'			=> ($this->user->data['user_popup_notes']) ? str_replace('&amp;', '&', $u_notes_popup) : $u_notes_popup,
 			]);
 		}
@@ -152,6 +159,7 @@ class main_listener implements EventSubscriberInterface
 
 		$permission = $event['permissions'];
 		$permission['a_notes'] = ['lang' => 'ACL_A_NOTES', 'cat' => 'notes'];
+		$permission['u_notes'] = ['lang' => 'ACL_U_NOTES', 'cat' => 'misc'];
 		$event['permissions'] = $permission;
 	}
 }
diff --git "[ORIGINAL]/oxpus\\notes/ext.php" "[FORUM_EXT]/oxpus\\notes/ext.php"
--- "[ORIGINAL]/oxpus\\notes/ext.php"
+++ "[FORUM_EXT]/oxpus\\notes/ext.php"
@@ -1,5 +1,4 @@
 <?php
-
 /**
 *
 * @package phpBB Extension - Personal Notes
@@ -12,4 +11,61 @@ namespace oxpus\notes;
 
 class ext extends \phpbb\extension\base
 {
+	/**
+	 * Check whether or not the extension can be enabled.
+	 * The current phpBB version should meet or exceed
+	 * the minimum version required by this extension:
+	 *
+	 * Requires phpBB 3.3.0 and PHP 7.3.0.
+	 *
+	 * @return bool
+	 * @access public
+	 */
+	public function is_enableable()
+	{
+		if (!version_compare(PHP_VERSION, '7.3.0', '>='))
+		{
+			$this->container->get('user')->add_lang_ext('oxpus/notes', 'info_acp_notes');
+			return [$this->container->get('user')->lang('PHP_ERROR')];
+		}
+
+		if (!phpbb_version_compare(PHPBB_VERSION, '3.3.0', '>='))
+		{
+			$this->container->get('user')->add_lang_ext('oxpus/notes', 'info_acp_notes');
+			return [$this->container->get('user')->lang('PHPBB_ERROR')];
+		}
+
+		return true;
+	}
+
+	/**
+	 * @param mixed $old_state State returned by previous call of this method
+	 * @return mixed Returns false after last step, otherwise temporary state
+	 * @access public
+	 */
+	function enable_step($old_state)
+	{
+		switch ($old_state)
+		{
+			case '': // Empty means nothing has run yet
+				if (empty($old_state))
+				{
+					$this->container->get('user')->add_lang_ext('oxpus/notes', 'info_acp_notes');
+					$this->container->get('template')->assign_var('L_EXTENSION_ENABLE_SUCCESS', $this->container->get('user')->lang['EXTENSION_ENABLE_SUCCESS'] . 
+					(isset($this->container->get('user')->lang['NOTES_NOTICE']) ? $this->container->get('user')->lang['NOTES_NOTICE'] : ''));
+				}
+
+				// Run parent enable step method
+				return parent::enable_step($old_state);
+			
+			break;
+			
+			default:
+			
+				// Run parent enable step method
+				return parent::enable_step($old_state);
+				
+			break;
+		}
+	}
 }
diff --git "[ORIGINAL]/oxpus\\notes/language/de/common.php" "[ORIGINAL]/oxpus\\notes/language/de/common.php"
deleted file mode 100644
--- "[ORIGINAL]/oxpus\\notes/language/de/common.php"
+++ /dev/null
@@ -1,45 +0,0 @@
-<?php
-
-/**
-*
-* @package phpBB Extension - Personal Notes
-* @copyright (c) 2014 OXPUS - www.oxpus.net
-* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
-*
-*/
-
-/*
-* [ german ] language file
-*/
-
-/**
-* DO NOT CHANGE
-*/
-if (!defined('IN_PHPBB'))
-{
-	exit;
-}
-
-if (empty($lang) || !is_array($lang))
-{
-	$lang = [];
-}
-
-$lang = array_merge($lang, [
-	'ACP_NOTES'				=> 'Notizen einstellen',
-	'ACP_NOTES_SETTINGS'	=> 'Max. Anzahl Notizen je Benutzer',
-	'UCP_NOTES'				=> 'Notizen',
-	'UCP_NOTES_CONFIG'		=> 'Einstellungen',
-
-	'NOTES'				=> 'Notizen',
-	'POPUP_NOTES'		=> 'Zeige persönliche Notizen als Popup',
-	'SLIDE_NOTES'		=> 'Notizen als Titelliste öffnen, Anzeigen per Klick auf den Titel',
-	'FILTER_NOTES'		=> '<strong>Filteranzeige</strong><br />Klicke erneut auf den Such-Button oder ändere die Sortierung, um alle Notizen anzuzeigen.',
-	'NOTES_MEM'			=> 'An Notiz erinnern',
-	'NOTES_MEM_TIME'	=> 'Erinnerungszeit',
-	'NOTES_MEMTEXT'		=> '<strong>Du hast Notizen erfasst, an die Du erinnert werden wolltest.</strong><br />%sKlicke hier, um diese Notizen anzuzeigen.%s<br />(Du wirst danach nicht mehr an diese Notizen erinnert)',
-	'NO_NOTES'			=> 'Du hast zur Zeit keine Notizen',
-
-	'NOTES_CONFIG_SUCCESSFULL'	=> 'Die Einstellungen der Notizen wurden erfolgreich gespeichert.',
-	'NOTES_LOG_CONFIG'			=> 'Anzahl Notizen je Benutzer geändert',
-]);
diff --git "[ORIGINAL]/oxpus\\notes/language/de/email/main_mail.txt" "[ORIGINAL]/oxpus\\notes/language/de/email/main_mail.txt"
deleted file mode 100644
--- "[ORIGINAL]/oxpus\\notes/language/de/email/main_mail.txt"
+++ /dev/null
@@ -1,8 +0,0 @@
-Subject: SUBJECT
-
-Hallo {USERNAME},
-
-TEXT
-
-
-{BOARD_EMAIL}
\ No newline at end of file
diff --git "[ORIGINAL]/oxpus\\notes/language/en/common.php" "[FORUM_EXT]/oxpus\\notes/language/en/common.php"
--- "[ORIGINAL]/oxpus\\notes/language/en/common.php"
+++ "[FORUM_EXT]/oxpus\\notes/language/en/common.php"
@@ -32,14 +32,21 @@ $lang = array_merge($lang, [
 	'UCP_NOTES_CONFIG'		=> 'Settings',
 
 	'NOTES'				=> 'Notes',
+	'NEW_NOTE'			=> 'New note',
+	'POST_NEW_NOTE'		=> 'Post a new note',
 	'POPUP_NOTES'		=> 'Display Personal Notes as Popup',
 	'SLIDE_NOTES'		=> 'Open notes as title list, display by clicking the title',
 	'FILTER_NOTES'		=> '<strong>Filter mode</strong><br />Press the search button again or change the sort method to display all notes.',
-	'NOTES_MEM'			=> 'Remember note',
-	'NOTES_MEM_TIME'	=> 'Remember time',
+	'NOTES_MEM'			=> 'Set a reminder',
+	'NOTES_MEM_ENABLE'	=> 'Yes remind me!',
+	'NOTES_MEM_TIME'	=> 'Set date and time',
 	'NOTES_MEMTEXT'		=> '<strong>You have entered notes with a reminder.</strong><br />%sClick here to list these notes.%s<br />(Clicking will remove the reminder)',
 	'NO_NOTES'			=> 'You currently have no notes',
 
+	'NOTES_DISCLAIMER'  		=> '**Notes you see here cannot be seen by anyone else, including administrators and moderators. If you have any questions or concerns, please contact a Board Administrator.',
+	'NOTES_DISCLAIMER_POPUP'	=> '**Notes you see here cannot be seen by anyone else, including administrators and moderators.',
+
 	'NOTES_CONFIG_SUCCESSFULL'	=> 'The settings for the notes are saved successfully.',
+	'NOTES_DELETE_CONFIRM'		=> 'Are you sure you want to delete this note?',
 	'NOTES_LOG_CONFIG'			=> 'Change number of notes per user',
 ]);
diff --git "[ORIGINAL]/oxpus\\notes/language/en/email/main_mail.txt" "[FORUM_EXT]/oxpus\\notes/language/en/email/main_mail.txt"
--- "[ORIGINAL]/oxpus\\notes/language/en/email/main_mail.txt"
+++ "[FORUM_EXT]/oxpus\\notes/language/en/email/main_mail.txt"
@@ -1,8 +1,8 @@
 Subject: SUBJECT
 
-Hello {USERNAME},
+Hello {{ USERNAME }},
 
 TEXT
 
 
-{BOARD_EMAIL}
\ No newline at end of file
+{{ BOARD_EMAIL }}
\ No newline at end of file
diff --git "[FORUM_EXT]/oxpus\\notes/language/en/info_acp_notes.php" "[FORUM_EXT]/oxpus\\notes/language/en/info_acp_notes.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/oxpus\\notes/language/en/info_acp_notes.php"
@@ -0,0 +1,43 @@
+<?php
+/**
+*
+* @package phpBB Extension - Personal Notes
+* @copyright (c) 2014 OXPUS - www.oxpus.net
+* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
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
+	$lang = [];
+}
+
+/// DEVELOPERS PLEASE NOTE
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
+	'NOTES_NOTICE'				    => '<div class="phpinfo"><p>Make sure to check the Group permission and adjust it as needed. By default the Registered user group doesn\'t have access personal notes.</p></div></p></div>',
+	'PHP_ERROR' 	=> 'This extension requires PHP 7.3.0 (or greater).',
+	'PHPBB_ERROR' 	=> 'This extension requires phpBB 3.3.0 (or greater).',
+]);
diff --git "[ORIGINAL]/oxpus\\notes/language/en/permissions_notes.php" "[FORUM_EXT]/oxpus\\notes/language/en/permissions_notes.php"
--- "[ORIGINAL]/oxpus\\notes/language/en/permissions_notes.php"
+++ "[FORUM_EXT]/oxpus\\notes/language/en/permissions_notes.php"
@@ -30,4 +30,5 @@ $lang = array_merge($lang, [
 	'ACP_NOTES'		=> 'Notes',
 
 	'ACL_A_NOTES'	=> 'Can configure personal notes',
+	'ACL_U_NOTES'	=> 'Can use personal notes',
 ]);
diff --git "[FORUM_EXT]/oxpus\\notes/language/pt/common.php" "[FORUM_EXT]/oxpus\\notes/language/pt/common.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/oxpus\\notes/language/pt/common.php"
@@ -0,0 +1,52 @@
+<?php
+
+/**
+*
+* @package phpBB Extension - Personal Notes
+* @copyright (c) 2014 OXPUS - www.oxpus.net
+* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+*
+*/
+
+/*
+* [ english ] language file
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
+	$lang = [];
+}
+
+$lang = array_merge($lang, [
+	'ACP_NOTES'				=> 'Configurar Notas',
+	'ACP_NOTES_SETTINGS'	=> 'Número máximo de notas por utilizador',
+	'UCP_NOTES'				=> 'Notas',
+	'UCP_NOTES_CONFIG'		=> 'Configurações',
+
+	'NOTES'				=> 'Notas',
+	'NEW_NOTE'			=> 'Nova nota',
+	'POST_NEW_NOTE'		=> 'Adicionar nova nota',
+	'POPUP_NOTES'		=> 'Exibir Notas Pessoais como Popup',
+	'SLIDE_NOTES'		=> 'Abrir notas com lista de títulos, exibir ao clicar no título',
+	'FILTER_NOTES'		=> '<strong>Modo Filtrado</strong><br />Pressiona o botão de pesquisa novamente ou altera a ordenação para mostrar todas as notas.',
+	'NOTES_MEM'			=> 'Adicionar lembrete!',
+	'NOTES_MEM_ENABLE'	=> 'Sim, lembra-me!',
+	'NOTES_MEM_TIME'	=> 'Colocar data e hora',
+	'NOTES_MEMTEXT'		=> '<strong>Introduziste notas com lembretes.</strong><br />%sClica aqui para listas essas notas.%s<br />(Clicar irá remover o lembrete)',
+	'NO_NOTES'			=> 'Não tens quaisquer notas',
+
+	'NOTES_DISCLAIMER'  		=> '**As notas que aqui vês só podem ser vistas por ti, e isso inclui moderadores e administradores. Se tiveres alguma dúvida ou preocupações, por favor, contacta a Administração.',
+	'NOTES_DISCLAIMER_POPUP'	=> '**As notas que aqui vês só podem ser vistas por ti, e isso inclui moderadores e administradores.',
+
+	'NOTES_CONFIG_SUCCESSFULL'	=> 'As configurações das notas foram guardadas com sucesso.',
+	'NOTES_DELETE_CONFIRM'		=> 'Tens a certeza que desejas apagar esta nota?',
+	'NOTES_LOG_CONFIG'			=> 'Alterar número de notas por utilizador',
+]);
diff --git "[FORUM_EXT]/oxpus\\notes/language/pt/email/main_mail.txt" "[FORUM_EXT]/oxpus\\notes/language/pt/email/main_mail.txt"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/oxpus\\notes/language/pt/email/main_mail.txt"
@@ -0,0 +1,8 @@
+Subject: SUBJECT
+
+Olá {{ USERNAME }},
+
+TEXT
+
+
+{{ BOARD_EMAIL }}
\ No newline at end of file
diff --git "[FORUM_EXT]/oxpus\\notes/language/pt/info_acp_notes.php" "[FORUM_EXT]/oxpus\\notes/language/pt/info_acp_notes.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/oxpus\\notes/language/pt/info_acp_notes.php"
@@ -0,0 +1,43 @@
+<?php
+/**
+*
+* @package phpBB Extension - Personal Notes
+* @copyright (c) 2014 OXPUS - www.oxpus.net
+* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
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
+	$lang = [];
+}
+
+/// DEVELOPERS PLEASE NOTE
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
+	'NOTES_NOTICE'				    => '<div class="phpinfo"><p>Make sure to check the Group permission and adjust it as needed. By default the Registered user group doesn\'t have access personal notes.</p></div></p></div>',
+	'PHP_ERROR' 	=> 'This extension requires PHP 7.3.0 (or greater).',
+	'PHPBB_ERROR' 	=> 'This extension requires phpBB 3.3.0 (or greater).',
+]);
diff --git "[FORUM_EXT]/oxpus\\notes/language/pt/permissions_notes.php" "[FORUM_EXT]/oxpus\\notes/language/pt/permissions_notes.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/oxpus\\notes/language/pt/permissions_notes.php"
@@ -0,0 +1,34 @@
+<?php
+
+/**
+*
+* @package phpBB Extension - Personal notes
+* @copyright (c) 2014 OXPUS - www.oxpus.net
+* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+*
+*/
+
+/**
+* Language pack for Extension permissions [English]
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
+	$lang = [];
+}
+
+// Permissions
+$lang = array_merge($lang, [
+	'ACP_NOTES'		=> 'Notas',
+
+	'ACL_A_NOTES'	=> 'Pode configurar notas pessoais',
+	'ACL_U_NOTES'	=> 'Pode usar notas pessoais',
+]);
diff --git "[FORUM_EXT]/oxpus\\notes/language/pt-preao/common.php" "[FORUM_EXT]/oxpus\\notes/language/pt-preao/common.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/oxpus\\notes/language/pt-preao/common.php"
@@ -0,0 +1,52 @@
+<?php
+
+/**
+*
+* @package phpBB Extension - Personal Notes
+* @copyright (c) 2014 OXPUS - www.oxpus.net
+* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+*
+*/
+
+/*
+* [ english ] language file
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
+	$lang = [];
+}
+
+$lang = array_merge($lang, [
+	'ACP_NOTES'				=> 'Configurar Notas',
+	'ACP_NOTES_SETTINGS'	=> 'Número máximo de notas por utilizador',
+	'UCP_NOTES'				=> 'Notas',
+	'UCP_NOTES_CONFIG'		=> 'Configurações',
+
+	'NOTES'				=> 'Notas',
+	'NEW_NOTE'			=> 'Nova nota',
+	'POST_NEW_NOTE'		=> 'Adicionar nova nota',
+	'POPUP_NOTES'		=> 'Exibir Notas Pessoais como Popup',
+	'SLIDE_NOTES'		=> 'Abrir notas com lista de títulos, exibir ao clicar no título',
+	'FILTER_NOTES'		=> '<strong>Modo Filtrado</strong><br />Pressiona o botão de pesquisa novamente ou altera a ordenação para mostrar todas as notas.',
+	'NOTES_MEM'			=> 'Adicionar lembrete!',
+	'NOTES_MEM_ENABLE'	=> 'Sim, lembra-me!',
+	'NOTES_MEM_TIME'	=> 'Colocar data e hora',
+	'NOTES_MEMTEXT'		=> '<strong>Introduziste notas com lembretes.</strong><br />%sClica aqui para listas essas notas.%s<br />(Clicar irá remover o lembrete)',
+	'NO_NOTES'			=> 'Não tens quaisquer notas',
+
+	'NOTES_DISCLAIMER'  		=> '**As notas que aqui vês só podem ser vistas por ti, e isso inclui moderadores e administradores. Se tiveres alguma dúvida ou preocupações, por favor, contacta a Administração.',
+	'NOTES_DISCLAIMER_POPUP'	=> '**As notas que aqui vês só podem ser vistas por ti, e isso inclui moderadores e administradores.',
+
+	'NOTES_CONFIG_SUCCESSFULL'	=> 'As configurações das notas foram guardadas com sucesso.',
+	'NOTES_DELETE_CONFIRM'		=> 'Tens a certeza que desejas apagar esta nota?',
+	'NOTES_LOG_CONFIG'			=> 'Alterar número de notas por utilizador',
+]);
diff --git "[FORUM_EXT]/oxpus\\notes/language/pt-preao/email/main_mail.txt" "[FORUM_EXT]/oxpus\\notes/language/pt-preao/email/main_mail.txt"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/oxpus\\notes/language/pt-preao/email/main_mail.txt"
@@ -0,0 +1,8 @@
+Subject: SUBJECT
+
+Olá {{ USERNAME }},
+
+TEXT
+
+
+{{ BOARD_EMAIL }}
\ No newline at end of file
diff --git "[FORUM_EXT]/oxpus\\notes/language/pt-preao/info_acp_notes.php" "[FORUM_EXT]/oxpus\\notes/language/pt-preao/info_acp_notes.php"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/oxpus\\notes/language/pt-preao/info_acp_notes.php"
@@ -0,0 +1,43 @@
+<?php
+/**
+*
+* @package phpBB Extension - Personal Notes
+* @copyright (c) 2014 OXPUS - www.oxpus.net
+* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
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
+	$lang = [];
+}
+
+/// DEVELOPERS PLEASE NOTE
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
+	'NOTES_NOTICE'				    => '<div class="phpinfo"><p>Make sure to check the Group permission and adjust it as needed. By default the Registered user group doesn\'t have access personal notes.</p></div></p></div>',
+	'PHP_ERROR' 	=> 'This extension requires PHP 7.3.0 (or greater).',
+	'PHPBB_ERROR' 	=> 'This extension requires phpBB 3.3.0 (or greater).',
+]);
diff --git "[ORIGINAL]/oxpus\\notes/language/de/permissions_notes.php" "[FORUM_EXT]/oxpus\\notes/language/pt-preao/permissions_notes.php"
similarity index 67%
rename from "c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\oxpus\\notes/language/de/permissions_notes.php"
rename to "C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\oxpus\\notes/language/pt-preao/permissions_notes.php"
--- "[ORIGINAL]/oxpus\\notes/language/de/permissions_notes.php"
+++ "[FORUM_EXT]/oxpus\\notes/language/pt-preao/permissions_notes.php"
@@ -9,7 +9,7 @@
 */
 
 /**
-* Language pack for Extension permissions [German]
+* Language pack for Extension permissions [English]
 */
 
 /**
@@ -27,6 +27,8 @@ if (empty($lang) || !is_array($lang))
 
 // Permissions
 $lang = array_merge($lang, [
-	'ACP_NOTES'		=> 'Notizen',
-	'ACL_A_NOTES'	=> 'Kann die persönlichen Notizen einstellen',
+	'ACP_NOTES'		=> 'Notas',
+
+	'ACL_A_NOTES'	=> 'Pode configurar notas pessoais',
+	'ACL_U_NOTES'	=> 'Pode usar notas pessoais',
 ]);
diff --git "[ORIGINAL]/oxpus\\notes/license.txt" "[ORIGINAL]/oxpus\\notes/license.txt"
deleted file mode 100644
--- "[ORIGINAL]/oxpus\\notes/license.txt"
+++ /dev/null
@@ -1,281 +0,0 @@
-		    GNU GENERAL PUBLIC LICENSE
-		       Version 2, June 1991
-
- Copyright (C) 1989, 1991 Free Software Foundation, Inc.
-                          675 Mass Ave, Cambridge, MA 02139, USA
- Everyone is permitted to copy and distribute verbatim copies
- of this license document, but changing it is not allowed.
-
-			    Preamble
-
-  The licenses for most software are designed to take away your
-freedom to share and change it.  By contrast, the GNU General Public
-License is intended to guarantee your freedom to share and change free
-software--to make sure the software is free for all its users.  This
-General Public License applies to most of the Free Software
-Foundation's software and to any other program whose authors commit to
-using it.  (Some other Free Software Foundation software is covered by
-the GNU Library General Public License instead.)  You can apply it to
-your programs, too.
-
-  When we speak of free software, we are referring to freedom, not
-price.  Our General Public Licenses are designed to make sure that you
-have the freedom to distribute copies of free software (and charge for
-this service if you wish), that you receive source code or can get it
-if you want it, that you can change the software or use pieces of it
-in new free programs; and that you know you can do these things.
-
-  To protect your rights, we need to make restrictions that forbid
-anyone to deny you these rights or to ask you to surrender the rights.
-These restrictions translate to certain responsibilities for you if you
-distribute copies of the software, or if you modify it.
-
-  For example, if you distribute copies of such a program, whether
-gratis or for a fee, you must give the recipients all the rights that
-you have.  You must make sure that they, too, receive or can get the
-source code.  And you must show them these terms so they know their
-rights.
-
-  We protect your rights with two steps: (1) copyright the software, and
-(2) offer you this license which gives you legal permission to copy,
-distribute and/or modify the software.
-
-  Also, for each author's protection and ours, we want to make certain
-that everyone understands that there is no warranty for this free
-software.  If the software is modified by someone else and passed on, we
-want its recipients to know that what they have is not the original, so
-that any problems introduced by others will not reflect on the original
-authors' reputations.
-
-  Finally, any free program is threatened constantly by software
-patents.  We wish to avoid the danger that redistributors of a free
-program will individually obtain patent licenses, in effect making the
-program proprietary.  To prevent this, we have made it clear that any
-patent must be licensed for everyone's free use or not licensed at all.
-
-  The precise terms and conditions for copying, distribution and
-modification follow.
-
-		    GNU GENERAL PUBLIC LICENSE
-   TERMS AND CONDITIONS FOR COPYING, DISTRIBUTION AND MODIFICATION
-
-  0. This License applies to any program or other work which contains
-a notice placed by the copyright holder saying it may be distributed
-under the terms of this General Public License.  The "Program", below,
-refers to any such program or work, and a "work based on the Program"
-means either the Program or any derivative work under copyright law:
-that is to say, a work containing the Program or a portion of it,
-either verbatim or with modifications and/or translated into another
-language.  (Hereinafter, translation is included without limitation in
-the term "modification".)  Each licensee is addressed as "you".
-
-Activities other than copying, distribution and modification are not
-covered by this License; they are outside its scope.  The act of
-running the Program is not restricted, and the output from the Program
-is covered only if its contents constitute a work based on the
-Program (independent of having been made by running the Program).
-Whether that is true depends on what the Program does.
-
-  1. You may copy and distribute verbatim copies of the Program's
-source code as you receive it, in any medium, provided that you
-conspicuously and appropriately publish on each copy an appropriate
-copyright notice and disclaimer of warranty; keep intact all the
-notices that refer to this License and to the absence of any warranty;
-and give any other recipients of the Program a copy of this License
-along with the Program.
-
-You may charge a fee for the physical act of transferring a copy, and
-you may at your option offer warranty protection in exchange for a fee.
-
-  2. You may modify your copy or copies of the Program or any portion
-of it, thus forming a work based on the Program, and copy and
-distribute such modifications or work under the terms of Section 1
-above, provided that you also meet all of these conditions:
-
-    a) You must cause the modified files to carry prominent notices
-    stating that you changed the files and the date of any change.
-
-    b) You must cause any work that you distribute or publish, that in
-    whole or in part contains or is derived from the Program or any
-    part thereof, to be licensed as a whole at no charge to all third
-    parties under the terms of this License.
-
-    c) If the modified program normally reads commands interactively
-    when run, you must cause it, when started running for such
-    interactive use in the most ordinary way, to print or display an
-    announcement including an appropriate copyright notice and a
-    notice that there is no warranty (or else, saying that you provide
-    a warranty) and that users may redistribute the program under
-    these conditions, and telling the user how to view a copy of this
-    License.  (Exception: if the Program itself is interactive but
-    does not normally print such an announcement, your work based on
-    the Program is not required to print an announcement.)
-
-These requirements apply to the modified work as a whole.  If
-identifiable sections of that work are not derived from the Program,
-and can be reasonably considered independent and separate works in
-themselves, then this License, and its terms, do not apply to those
-sections when you distribute them as separate works.  But when you
-distribute the same sections as part of a whole which is a work based
-on the Program, the distribution of the whole must be on the terms of
-this License, whose permissions for other licensees extend to the
-entire whole, and thus to each and every part regardless of who wrote it.
-
-Thus, it is not the intent of this section to claim rights or contest
-your rights to work written entirely by you; rather, the intent is to
-exercise the right to control the distribution of derivative or
-collective works based on the Program.
-
-In addition, mere aggregation of another work not based on the Program
-with the Program (or with a work based on the Program) on a volume of
-a storage or distribution medium does not bring the other work under
-the scope of this License.
-
-  3. You may copy and distribute the Program (or a work based on it,
-under Section 2) in object code or executable form under the terms of
-Sections 1 and 2 above provided that you also do one of the following:
-
-    a) Accompany it with the complete corresponding machine-readable
-    source code, which must be distributed under the terms of Sections
-    1 and 2 above on a medium customarily used for software interchange; or,
-
-    b) Accompany it with a written offer, valid for at least three
-    years, to give any third party, for a charge no more than your
-    cost of physically performing source distribution, a complete
-    machine-readable copy of the corresponding source code, to be
-    distributed under the terms of Sections 1 and 2 above on a medium
-    customarily used for software interchange; or,
-
-    c) Accompany it with the information you received as to the offer
-    to distribute corresponding source code.  (This alternative is
-    allowed only for noncommercial distribution and only if you
-    received the program in object code or executable form with such
-    an offer, in accord with Subsection b above.)
-
-The source code for a work means the preferred form of the work for
-making modifications to it.  For an executable work, complete source
-code means all the source code for all modules it contains, plus any
-associated interface definition files, plus the scripts used to
-control compilation and installation of the executable.  However, as a
-special exception, the source code distributed need not include
-anything that is normally distributed (in either source or binary
-form) with the major components (compiler, kernel, and so on) of the
-operating system on which the executable runs, unless that component
-itself accompanies the executable.
-
-If distribution of executable or object code is made by offering
-access to copy from a designated place, then offering equivalent
-access to copy the source code from the same place counts as
-distribution of the source code, even though third parties are not
-compelled to copy the source along with the object code.
-
-  4. You may not copy, modify, sublicense, or distribute the Program
-except as expressly provided under this License.  Any attempt
-otherwise to copy, modify, sublicense or distribute the Program is
-void, and will automatically terminate your rights under this License.
-However, parties who have received copies, or rights, from you under
-this License will not have their licenses terminated so long as such
-parties remain in full compliance.
-
-  5. You are not required to accept this License, since you have not
-signed it.  However, nothing else grants you permission to modify or
-distribute the Program or its derivative works.  These actions are
-prohibited by law if you do not accept this License.  Therefore, by
-modifying or distributing the Program (or any work based on the
-Program), you indicate your acceptance of this License to do so, and
-all its terms and conditions for copying, distributing or modifying
-the Program or works based on it.
-
-  6. Each time you redistribute the Program (or any work based on the
-Program), the recipient automatically receives a license from the
-original licensor to copy, distribute or modify the Program subject to
-these terms and conditions.  You may not impose any further
-restrictions on the recipients' exercise of the rights granted herein.
-You are not responsible for enforcing compliance by third parties to
-this License.
-
-  7. If, as a consequence of a court judgment or allegation of patent
-infringement or for any other reason (not limited to patent issues),
-conditions are imposed on you (whether by court order, agreement or
-otherwise) that contradict the conditions of this License, they do not
-excuse you from the conditions of this License.  If you cannot
-distribute so as to satisfy simultaneously your obligations under this
-License and any other pertinent obligations, then as a consequence you
-may not distribute the Program at all.  For example, if a patent
-license would not permit royalty-free redistribution of the Program by
-all those who receive copies directly or indirectly through you, then
-the only way you could satisfy both it and this License would be to
-refrain entirely from distribution of the Program.
-
-If any portion of this section is held invalid or unenforceable under
-any particular circumstance, the balance of the section is intended to
-apply and the section as a whole is intended to apply in other
-circumstances.
-
-It is not the purpose of this section to induce you to infringe any
-patents or other property right claims or to contest validity of any
-such claims; this section has the sole purpose of protecting the
-integrity of the free software distribution system, which is
-implemented by public license practices.  Many people have made
-generous contributions to the wide range of software distributed
-through that system in reliance on consistent application of that
-system; it is up to the author/donor to decide if he or she is willing
-to distribute software through any other system and a licensee cannot
-impose that choice.
-
-This section is intended to make thoroughly clear what is believed to
-be a consequence of the rest of this License.
-
-  8. If the distribution and/or use of the Program is restricted in
-certain countries either by patents or by copyrighted interfaces, the
-original copyright holder who places the Program under this License
-may add an explicit geographical distribution limitation excluding
-those countries, so that distribution is permitted only in or among
-countries not thus excluded.  In such case, this License incorporates
-the limitation as if written in the body of this License.
-
-  9. The Free Software Foundation may publish revised and/or new versions
-of the General Public License from time to time.  Such new versions will
-be similar in spirit to the present version, but may differ in detail to
-address new problems or concerns.
-
-Each version is given a distinguishing version number.  If the Program
-specifies a version number of this License which applies to it and "any
-later version", you have the option of following the terms and conditions
-either of that version or of any later version published by the Free
-Software Foundation.  If the Program does not specify a version number of
-this License, you may choose any version ever published by the Free Software
-Foundation.
-
-  10. If you wish to incorporate parts of the Program into other free
-programs whose distribution conditions are different, write to the author
-to ask for permission.  For software which is copyrighted by the Free
-Software Foundation, write to the Free Software Foundation; we sometimes
-make exceptions for this.  Our decision will be guided by the two goals
-of preserving the free status of all derivatives of our free software and
-of promoting the sharing and reuse of software generally.
-
-			    NO WARRANTY
-
-  11. BECAUSE THE PROGRAM IS LICENSED FREE OF CHARGE, THERE IS NO WARRANTY
-FOR THE PROGRAM, TO THE EXTENT PERMITTED BY APPLICABLE LAW.  EXCEPT WHEN
-OTHERWISE STATED IN WRITING THE COPYRIGHT HOLDERS AND/OR OTHER PARTIES
-PROVIDE THE PROGRAM "AS IS" WITHOUT WARRANTY OF ANY KIND, EITHER EXPRESSED
-OR IMPLIED, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF
-MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE.  THE ENTIRE RISK AS
-TO THE QUALITY AND PERFORMANCE OF THE PROGRAM IS WITH YOU.  SHOULD THE
-PROGRAM PROVE DEFECTIVE, YOU ASSUME THE COST OF ALL NECESSARY SERVICING,
-REPAIR OR CORRECTION.
-
-  12. IN NO EVENT UNLESS REQUIRED BY APPLICABLE LAW OR AGREED TO IN WRITING
-WILL ANY COPYRIGHT HOLDER, OR ANY OTHER PARTY WHO MAY MODIFY AND/OR
-REDISTRIBUTE THE PROGRAM AS PERMITTED ABOVE, BE LIABLE TO YOU FOR DAMAGES,
-INCLUDING ANY GENERAL, SPECIAL, INCIDENTAL OR CONSEQUENTIAL DAMAGES ARISING
-OUT OF THE USE OR INABILITY TO USE THE PROGRAM (INCLUDING BUT NOT LIMITED
-TO LOSS OF DATA OR DATA BEING RENDERED INACCURATE OR LOSSES SUSTAINED BY
-YOU OR THIRD PARTIES OR A FAILURE OF THE PROGRAM TO OPERATE WITH ANY OTHER
-PROGRAMS), EVEN IF SUCH HOLDER OR OTHER PARTY HAS BEEN ADVISED OF THE
-POSSIBILITY OF SUCH DAMAGES.
-
-		     END OF TERMS AND CONDITIONS
-
diff --git "[ORIGINAL]/oxpus\\notes/migrations/release_3_0_0.php" "[FORUM_EXT]/oxpus\\notes/migrations/release_3_0_0.php"
--- "[ORIGINAL]/oxpus\\notes/migrations/release_3_0_0.php"
+++ "[FORUM_EXT]/oxpus\\notes/migrations/release_3_0_0.php"
@@ -57,9 +57,11 @@ class release_3_0_0 extends \phpbb\db\migration\migration
 
 			// The needed permissions
 			['permission.add', ['a_notes']],
+			['permission.add', ['u_notes', 1, 0]],
 
-			// Join permissions to administrators
+			// Join permissions
 			['permission.permission_set', ['ROLE_ADMIN_FULL', 'a_notes']],
+			['permission.permission_set', ['ROLE_USER_FULL', 'u_notes']],
 		];
 	}
 			
diff --git "[FORUM_EXT]/oxpus\\notes/styles/FLATBOOTS/template/event/navbar_header_profile_list_after.html" "[FORUM_EXT]/oxpus\\notes/styles/FLATBOOTS/template/event/navbar_header_profile_list_after.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/oxpus\\notes/styles/FLATBOOTS/template/event/navbar_header_profile_list_after.html"
@@ -0,0 +1,3 @@
+{% if U_NOTES_PATH %}
+	<a class="btn btn-default btn-sm btn-block" href="{{ U_NOTES_PATH }}"><i class="fa fa-clipboard"></i>&nbsp;{{ lang('NOTES') }}</a>
+{% endif %}
\ No newline at end of file
diff --git "[FORUM_EXT]/oxpus\\notes/styles/FLATBOOTS/template/event/overall_header_content_before.html" "[FORUM_EXT]/oxpus\\notes/styles/FLATBOOTS/template/event/overall_header_content_before.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/oxpus\\notes/styles/FLATBOOTS/template/event/overall_header_content_before.html"
@@ -0,0 +1,12 @@
+{% if S_NOTES_MEM %}
+<div class="alert alert-warning fade in">
+    <i class="fa fa-info"></i> <strong>{{ lang('INFORMATION') }}{{ lang('COLON') }}</strong>&nbsp;{{ NOTES_MEM }}
+</div>
+{% endif %}
+{% if U_NOTES_POPUP %}
+<script type="text/javascript">
+    function notes() {
+        window.open("{{ U_NOTES_POPUP }}", "_blank", "width=800,height=600,scrollbars=yes,resizable=no");
+    }
+</script>
+{% endif %}
\ No newline at end of file
diff --git "[FORUM_EXT]/oxpus\\notes/styles/FLATBOOTS/template/event/overall_header_navigation_append.html" "[FORUM_EXT]/oxpus\\notes/styles/FLATBOOTS/template/event/overall_header_navigation_append.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/oxpus\\notes/styles/FLATBOOTS/template/event/overall_header_navigation_append.html"
@@ -0,0 +1 @@
+{% if U_NOTES_PATH %}<li><a href="{{ U_NOTES_PATH }}"><i class="fa fa-fw fa-clipboard"></i>{{ lang('NOTES') }}</a></li>{% endif %}
\ No newline at end of file
diff --git "[FORUM_EXT]/oxpus\\notes/styles/FLATBOOTS/template/event/overall_header_stylesheets_after.html" "[FORUM_EXT]/oxpus\\notes/styles/FLATBOOTS/template/event/overall_header_stylesheets_after.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/oxpus\\notes/styles/FLATBOOTS/template/event/overall_header_stylesheets_after.html"
@@ -0,0 +1,4 @@
+{% if PAGE_TITLE eq "Notes" %}
+{% INCLUDECSS '@oxpus_notes/notes.css' %}
+{% INCLUDEJS '@oxpus_notes/js/notes.js' %}
+{% endif %}
\ No newline at end of file
diff --git "[FORUM_EXT]/oxpus\\notes/styles/FLATBOOTS/template/event/simple_header_stylesheets_after.html" "[FORUM_EXT]/oxpus\\notes/styles/FLATBOOTS/template/event/simple_header_stylesheets_after.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/oxpus\\notes/styles/FLATBOOTS/template/event/simple_header_stylesheets_after.html"
@@ -0,0 +1,4 @@
+{% if PAGE_TITLE eq "Notes" %}
+{% INCLUDECSS '@oxpus_notes/notes.css' %}
+{% INCLUDEJS '@oxpus_notes/js/notes.js' %}
+{% endif %}
\ No newline at end of file
diff --git "[FORUM_EXT]/oxpus\\notes/styles/FLATBOOTS/template/js/notes.js" "[FORUM_EXT]/oxpus\\notes/styles/FLATBOOTS/template/js/notes.js"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/oxpus\\notes/styles/FLATBOOTS/template/js/notes.js"
@@ -0,0 +1,16 @@
+/**
+*
+* @package phpBB Extension - Personal notes
+* @copyright (c) 2014 OXPUS - www.oxpus.net
+* @license http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+*
+*/
+
+/**
+* Show/hide notes text
+*/
+function showHideNote(note)
+{
+	$('#note_' + note).slideToggle();
+	$('#panel-heading-' + note).toggleClass('note-hidden');
+}
diff --git "[FORUM_EXT]/oxpus\\notes/styles/FLATBOOTS/template/note_confirm_body.html" "[FORUM_EXT]/oxpus\\notes/styles/FLATBOOTS/template/note_confirm_body.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/oxpus\\notes/styles/FLATBOOTS/template/note_confirm_body.html"
@@ -0,0 +1,31 @@
+{% if S_AJAX_REQUEST %}
+<form action="{{ S_CONFIRM_ACTION }}" method="post">
+	<h3 class="alert_title">{{ MESSAGE_TITLE }}</h3>
+	<p>{{ MESSAGE_TEXT }}</p>
+	<fieldset>
+		<input type="button" name="confirm" value="{{ lang('YES') }}" class="btn btn-default" />
+		<input type="button" name="cancel" value="{{ lang('NO') }}" class="btn btn-default" />
+	</fieldset>
+</form>
+{% endif %}
+{% if S_NOTES_POPUP %}
+{% INCLUDE 'simple_header.html' %}
+{% else %}
+{% INCLUDE 'overall_header.html' %}
+{% endif %}
+<form id="confirm" action="{{ S_CONFIRM_ACTION }}" method="post">
+	<div class="side-segment"><h3>{{ MESSAGE_TITLE }}</h3></div>
+<div class="well">
+	<p>{{ MESSAGE_TEXT }}</p>
+	<fieldset>
+		{{ S_HIDDEN_FIELDS }}
+		<button type="submit" name="confirm" value="{{ lang('YES') }}" class="btn btn-default">{{ lang('YES') }}</button>
+		<button type="submit" name="cancel" value="{{ lang('NO') }}" class="btn btn-default">{{ lang('NO') }}</button>
+	</fieldset>
+</div>
+</form>
+{% if S_NOTES_POPUP %}
+{% INCLUDE 'simple_footer.html' %}
+{% else %}
+{% INCLUDE 'overall_footer.html' %}
+{% endif %}
\ No newline at end of file
diff --git "[FORUM_EXT]/oxpus\\notes/styles/FLATBOOTS/template/note_edit_body.html" "[FORUM_EXT]/oxpus\\notes/styles/FLATBOOTS/template/note_edit_body.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/oxpus\\notes/styles/FLATBOOTS/template/note_edit_body.html"
@@ -0,0 +1,118 @@
+{% if S_NOTES_POPUP %}
+{% INCLUDE 'simple_header.html' %}
+{% else %}
+{% INCLUDE 'overall_header.html' %}
+{% endif %}
+
+<h2>{{ lang('NOTES') }} - {{ NOTES_TOTAL_USED }} / {{ NOTES_TOTAL_ALLOWED }}</h2>
+<form action="{{ S_NOTES_FORM_ACTION }}" method="post" id="postform">
+    <div class="clearfix">
+        <div class="well">
+            <div class="side-segment section-posting">
+                <h3>{{ lang('POST_NEW_NOTE') }}</h3>
+            </div>
+            <fieldset>
+                <div class="control-group">
+                    <label class="control-label" for="subject">{{ lang('SUBJECT') }}{{ lang('COLON') }}</label>
+                    <div class="row">
+                        <div class="col-xs-12 col-lg-8">
+                            <input type="text" class="form-control input-sm" placeholder="{{ lang('SUBJECT') }}{{ lang('COLON') }}" name="subject" id="subject" maxlength="124" tabindex="2" value="{{ NOTES_SUBJECT }}">
+                        </div>
+                    </div>
+                </div>
+
+                <div class="space10"></div>
+
+                <label class="control-label">{{ lang('NOTES_MEM') }}{{ lang('COLON') }}</label>
+
+                <div class="space10"></div>
+
+                <input type="checkbox" name="mem_yesno" id="mem_yesno" value="1"{% if NOTES_MEM_CHECKED %} checked="checked"{% endif %}><label class="checkbox-inline">{{ lang('NOTES_MEM_ENABLE') }}</label>
+                &nbsp;<i class="icon fa fa-bell" style="transform: rotate(40deg);vertical-align: middle;"></i>
+                <i class="icon fa fa-bell" style="transform: rotate(-40deg);vertical-align: middle;"></i>
+
+                <div class="space10"></div>
+
+                <div class="control-group">
+                    <label for="mem_yesno" class="control-label">{{ lang('NOTES_MEM_TIME') }}{{ lang('COLON') }}</label>
+                    <div class="controls controls-row">
+                        <div class="clearfix">
+                            <div class="controls">
+                                <div class="selector">
+                                    <select name="mem_day" class="selectpicker" data-width="auto">
+                                        {% for notes_days in loops.notes_days %}
+                                        <option value="{{ notes_days.DAY }}"{% if notes_days.DAY eq S_NOTE_MEM_DAY %} selected="selected"{% endif %}>{{ notes_days.DAY }}</option>
+                                        {% endfor %}
+                                    </select>
+                                    <select name="mem_month" class="selectpicker" data-width="auto">
+                                        {% for notes_months in loops.notes_months %}
+                                        <option value="{{ notes_months.MONTH }}"{% if notes_months.MONTH eq S_NOTE_MEM_MONTH %} selected="selected"{% endif %}>{{ notes_months.MONTH }}</option>
+                                        {% endfor %}
+                                    </select>
+                                    <select name="mem_year" class="selectpicker" data-width="auto">
+                                        {% for notes_years in loops.notes_years %}
+                                        <option value="{{ notes_years.YEAR }}"{% if notes_years.YEAR eq S_NOTE_MEM_YEAR %} selected="selected"{% endif %}>{{ notes_years.YEAR }}</option>
+                                        {% endfor %}
+                                    </select>
+                                </div>
+                                <div class="selector">
+                                    <select name="mem_hour" class="selectpicker" data-width="auto">
+                                        {% for notes_hours in loops.notes_hours %}
+                                        <option value="{{ notes_hours.HOUR }}"{% if notes_hours.HOUR eq S_NOTE_MEM_HOUR %} selected="selected"{% endif %}>{{ notes_hours.HOUR }}</option>
+                                        {% endfor %}
+                                    </select>
+                                    <select name="mem_minute" class="selectpicker" data-width="auto">
+                                        {% for notes_minutes in loops.notes_minutes %}
+                                        <option value="{{ notes_minutes.MINUTE }}"{% if notes_minutes.MINUTE eq S_NOTE_MEM_MIN %} selected="selected"{% endif %}>{{ notes_minutes.MIN }}</option>
+                                        {% endfor %}
+                                    </select>
+                                </div>
+                            </div>
+                        </div>
+                    </div>
+                </div>
+
+                {% INCLUDE 'posting_buttons.html' %}
+
+                <div class="space10"></div>
+
+                <div class="row">
+                    <div class="col-md-8">
+                        <textarea class="form-control" name="message" id="message" rows="10" tabindex="3" onselect="storeCaret(this);" onclick="storeCaret(this);" onkeyup="storeCaret(this);">{{ NOTES_MESSAGE }}</textarea>
+                    </div>
+
+                    <div class="col-md-4">
+                        {% if loops.smiley|length %}
+                        <strong>{{ lang('SMILIES') }}<a class="btn-link btn-xs" href="{{ U_MORE_SMILIES }}" onclick="popup(this.href, 450, 350, '_phpbbsmilies'); return false;" title="{{ lang('MORE_SMILIES') }}"><i class="fa fa-plus"></i></a></strong>
+                        <br />
+                        {% for smiley in loops.smiley %}
+                        <a href="#" onclick="insert_text('{{ smiley.A_SMILEY_CODE }}', true); return false;"><img src="{{ smiley.SMILEY_IMG }}" width="{{ smiley.SMILEY_WIDTH }}" height="{{ smiley.SMILEY_HEIGHT }}" alt="{{ smiley.SMILEY_CODE }}" title="{{ smiley.SMILEY_DESC }}" /></a>
+                        {% endfor %}
+                        {% endif %}
+                    </div>
+                </div>
+            </fieldset>
+
+            <div class="space10"></div>
+
+            <fieldset class="form-actions">
+                {{ S_NOTES_HIDDEN_FIELDS }}
+                <button type="submit" class="btn btn-default" name="save" value="{{ lang('SUBMIT') }}" data-loading-text="{{ lang('LOADING') }}<i class='fa fa-spin fa-spinner fa-lg icon-white'></i>">{{ lang('SUBMIT') }}</button>
+                {{ S_FORM_TOKEN }}
+            </fieldset>
+        </div>
+    </div>
+</form>
+
+<div class="space10"></div>
+
+{% if S_NOTES_POPUP %}
+<br />
+<p class="submit-buttons">
+    <input type="submit" name="cancel" class="btn btn-default" value="{{ lang('CLOSE_WINDOW') }}" onclick="javascript:window.close()" />
+</p>
+<br />
+{% INCLUDE 'simple_footer.html' %}
+{% else %}
+{% INCLUDE 'overall_footer.html' %}
+{% endif %}
\ No newline at end of file
diff --git "[FORUM_EXT]/oxpus\\notes/styles/FLATBOOTS/template/note_list_body.html" "[FORUM_EXT]/oxpus\\notes/styles/FLATBOOTS/template/note_list_body.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/oxpus\\notes/styles/FLATBOOTS/template/note_list_body.html"
@@ -0,0 +1,180 @@
+{% if S_NOTES_POPUP %}
+{% INCLUDE 'simple_header.html' %}
+{% else %}
+{% INCLUDE 'overall_header.html' %}
+{% endif %}
+<div class="side-segment">
+    <h3>{{ lang('NOTES') }}</h3>
+</div>
+
+{% if not S_NO_NOTES %}
+<div class="space10"></div>
+
+{% if NOTES_FILTER_ACTIVE %}
+<div class="alert alert-info fade in">
+    * {{ lang('FILTER_NOTES') }}
+</div>
+{% endif %}
+
+<div class="row">
+    <form action="{{ S_NOTES_FORM_ACTION }}" method="post" id="notes">
+        <fieldset>
+           <div class="col-md-6 col-sm-6">
+               <div class="input-group search-notes">
+                   <select name="search_in" class="selectpicker" data-width="auto">
+                       <option value="note_subject"{% if NOTES_SEARCH_IN eq 'note_subject' %} selected="selected"{% endif %}>{{ lang('SUBJECT') }}</option>
+                       <option value="note_text"{% if NOTES_SEARCH_IN eq 'note_text' %} selected="selected"{% endif %}>{{ lang('POST') }}</option>
+                   </select>
+                   <input name="search_string" value="all" id="search_string" type="hidden">
+                   <input class="form-control" name="search_string" type="text">
+                   <div class="input-group-btn">
+                       <button type="submit" class="btn btn-info" value="{{ lang('SEARCH') }}{% if NOTES_SEARCH_ACTIVE %}*{% endif %}">{{ lang('SEARCH') }}{% if NOTES_SEARCH_ACTIVE %}*{% endif %}</button>
+                   </div>
+               </div>
+           </div>
+
+           <div class="col-md-6 col-sm-6 hidden-xs">
+               <div class="input-group pull-right">
+               <select name="sort_by" class="selectpicker" data-width="auto">
+                   <option value="note_subject"{% if NOTES_SORT_BY eq 'note_subject' %} selected="selected"{% endif %}>{{ lang('SUBJECT') }}</option>
+                   <option value="note_time"{% if NOTES_SORT_BY eq 'note_time' %} selected="selected"{% endif %}>{{ lang('TIME') }}</option>
+                   <option value="note_mem"{% if NOTES_SORT_BY eq 'note_mem' %} selected="selected"{% endif %}>{{ lang('NOTES_MEM') }}</option>
+               </select>
+               &nbsp;
+               <select name="sort_order" class="selectpicker" data-width="auto">
+                   <option value="ASC"{% if NOTES_SORT_ORDER eq 'ASC' %} selected="selected"{% endif %}>{{ lang('ASCENDING') }}</option>
+                   <option value="DESC"{% if NOTES_SORT_ORDER eq 'DESC' %} selected="selected"{% endif %}>{{ lang('DESCENDING') }}</option>
+               </select>
+               &nbsp;
+               <button type="submit" value="{{ lang('SORT_BY') }}" class="btn btn-info">{{ lang('SORT_BY') }}</button>
+               </div>
+            </div>
+        </fieldset>
+    </form>
+</div>
+
+<div class="space10"></div>
+<div class="space10"></div>
+<div class="space10"></div>
+<div class="space10"></div>
+
+<div class="clearfix">
+    <div class="pull-left">
+        {% if S_NEW_NOTE %}<a href="{{ U_NEW_NOTE }}" role="button" class="btn btn-default btn-load" data-loading-text="{{ lang('LOADING') }}&nbsp;<i class='fa-spin fa fa-spinner fa-lg icon-white'></i>"><i class="fa fa-plus"></i>&nbsp;{{ lang('NEW_NOTE') }}</a>
+        {% endif %}
+    </div>
+
+    {% if not S_NO_NOTES %}
+    <div class="pull-right">
+        <ul class="pagination pagination-sm">
+            <li><a class="pagination-trigger" data-placement="top">{{ lang('NOTES') }}</a></li>
+            <li class="active"><a>{{ NOTES_TOTAL_USED }} / {{ NOTES_TOTAL_ALLOWED }}</a></li>
+        </ul>
+    </div>
+    {% endif %}
+</div>
+{% endif %}
+
+{% if S_NO_NOTES %}
+<div class="space10"></div>
+<div class="alert alert-info fade in">
+    <i class="fa fa-info"></i> <strong>{{ lang('INFORMATION') }}{{ lang('COLON') }}</strong>&nbsp;{% if NOTES_NOT_FOUND %}{{ lang('NO_SEARCH_RESULTS') }}{% else %}{{ lang('NO_NOTES') }}{% endif %}
+</div>
+{% else %}
+{% for notes_row in loops.notes_row %}
+<div class="panel">
+
+    <div class="panel-heading{% if NOTES_SLIDE_MODE %} note-hidden" id="panel-heading-{{ notes_row.NOTE_ID }}{% endif %}">
+        <div class="clearfix">
+
+            <div class="side-segment">
+                <h3 style="border-bottom: 4px solid #e5e5e5;">{% if NOTES_SLIDE_MODE %}<a href="#" onclick="showHideNote({{ notes_row.NOTE_ID }}); return false;">{% endif %}{{ notes_row.NOTE_SUBJECT }}{% if NOTES_SLIDE_MODE %}</a>{% endif %}</h3></div>
+            <div class="clearfix">
+                <div class="text-muted pull-left">
+                    <span><i class="fa fa-clock-o"></i>&nbsp;{{ notes_row.NOTE_DATE }}</span>
+                </div>
+                <div class="pull-right">
+                    <div role="toolbar" class="btn-toolbar">
+
+                        <div class="btn-group btn-group-sm" role="group">
+
+                            <a class="btn btn-default btn-sm" href="{{ notes_row.U_EDIT_NOTE }}" title="{{ lang('EDIT_POST') }}" role="button"><i class="fa fa-edit"></i></a>
+
+                        </div>
+                        <div class="btn-group btn-group-sm" role="group">
+
+                            <a class="btn btn-danger btn-sm" href="{{ notes_row.U_DELETE_NOTE }}" title="{{ lang('DELETE_POST') }}" role="button"><i class="fa fa-trash-o"></i></a>
+
+                        </div>
+
+                    </div>
+                </div>
+            </div>
+
+        </div>
+    </div>
+
+    <div class="panel-body{% if NOTES_SLIDE_MODE %} hide-note{% endif %}" id="note_{{ notes_row.NOTE_ID }}">
+        <div class="clearfix">
+            <div class="postbody">
+
+                <span class="hidden hook-bfr-message"></span>
+                <div class="content">{{ notes_row.NOTE_TEXT }}</div>
+                {% if notes_row.NOTES_MEM %}
+                <div class="notice text-muted">
+                    <div class="space10"></div>
+                    <small><span class="label label-danger"><i class="fa fa-bell-o"></i>&nbsp;{{ lang('NOTES_MEM') }}</span>&nbsp;&nbsp;&nbsp;<i class="fa fa-clock-o"></i>&nbsp;{{ notes_row.NOTES_MEM }}</small>
+                </div>
+                {% endif %}
+
+            </div>
+        </div>
+    </div>
+
+</div>
+
+{% endfor %}
+{% endif %}
+
+<div class="clearfix">
+    <div class="pull-left">
+        {% if S_NEW_NOTE %}<a href="{{ U_NEW_NOTE }}" role="button" class="btn btn-default btn-load" data-loading-text="{{ lang('LOADING') }}&nbsp;<i class='fa-spin fa fa-spinner fa-lg icon-white'></i>"><i class="fa fa-plus"></i>&nbsp;{{ lang('NEW_NOTE') }}</a>
+        {% endif %}
+        {% if S_SHOW_BUTTON or NOTES_FILTER_ACTIVE %}<a href="{{ U_NOTES_HOME }}" role="button" class="btn btn-default btn-load" data-loading-text="{{ lang('LOADING') }}&nbsp;<i class='fa-spin fa fa-spinner fa-lg icon-white'></i>"><i class="fa fa-list"></i>&nbsp;{{ lang('NOTES') }}</a>
+        {% endif %}
+    </div>
+
+    {% if not S_NO_NOTES %}
+    <div class="pull-right">
+        <ul class="pagination pagination-sm">
+            <li><a class="pagination-trigger" data-placement="top">{{ lang('NOTES') }}</a></li>
+            <li class="active"><a>{{ NOTES_TOTAL_USED }} / {{ NOTES_TOTAL_ALLOWED }}</a></li>
+        </ul>
+    </div>
+    {% endif %}
+</div>
+
+{% if S_NO_NOTES %}
+<div class="space10"></div>
+<div class="space10"></div>
+{% endif %}
+
+<div class="row">
+    <div class="col-md-12 col-sm-12">
+        <p class="text-muted"><small>{% if S_NOTES_POPUP %}{{ lang('NOTES_DISCLAIMER_POPUP') }}{% else %}{{ lang('NOTES_DISCLAIMER') }}{% endif %}</small></p>
+    </div>
+</div>
+
+{% if S_NOTES_POPUP %}
+<div class="space10"></div>
+
+<p class="submit-buttons">
+    <input type="submit" name="cancel" class="btn btn-default" value="{{ lang('CLOSE_WINDOW') }}" onclick="javascript:window.close()" />
+</p>
+
+<br />
+
+{% INCLUDE 'simple_footer.html' %}
+{% else %}
+{% INCLUDE 'overall_footer.html' %}
+{% endif %}
\ No newline at end of file
diff --git "[FORUM_EXT]/oxpus\\notes/styles/FLATBOOTS/template/ucp_notes.html" "[FORUM_EXT]/oxpus\\notes/styles/FLATBOOTS/template/ucp_notes.html"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/oxpus\\notes/styles/FLATBOOTS/template/ucp_notes.html"
@@ -0,0 +1,45 @@
+{% INCLUDE 'ucp_header.html' %}
+<form id="notes_config" method="post" action="{{ U_NOTES_FORM_ACTION }}">
+<div class="tab-pane active">
+    <fieldset class="framed-ucp">
+        <legend>{{ lang('UCP_NOTES') }}</legend>
+        <div class="control-group">
+            <label for="notes_popup1" class="control-label">{{ lang('POPUP_NOTES') }}{{ lang('COLON') }}</label>
+            <div class="controls controls-row">
+                <div class="radio">
+                    <input type="radio" name="notes_popup" id="notes_popup1" value="1" {% if NOTES_POPUP %} checked="checked"{% endif %}/>
+                    <label for="notes_popup1">{{ lang('YES') }}</label>
+                </div>
+                <div class="radio">
+                    <input type="radio" name="notes_popup" id="notes_popup0" value="0" {% if not NOTES_POPUP %} checked="checked"{% endif %}/>
+                    <label for="notes_popup0">{{ lang('NO') }}</label>
+                </div>
+            </div>
+
+            <div class="controls controls-row">
+                <label for="notes_slide1" class="control-label">{{ lang('SLIDE_NOTES') }}{{ lang('COLON') }}</label>
+                <div class="controls controls-row">
+                    <div class="radio">
+                        <input type="radio" name="notes_slide" id="notes_slide1" value="1" {% if NOTES_SLIDE %} checked="checked"{% endif %}/>
+                        <label for="notes_slide1">{{ lang('YES') }}</label>
+                    </div>
+                    <div class="radio">
+                        <input type="radio" name="notes_slide" id="notes_slide0" value="0" {% if not NOTES_SLIDE %} checked="checked"{% endif %}/>
+                        <label for="notes_slide0">{{ lang('NO') }}</label>
+                    </div>
+                </div>
+            </div>
+        </div>
+    </fieldset>
+</div>
+
+<div class="space10"></div>
+
+<div class="form-actions"> 
+    {{ S_HIDDEN_FIELDS }}
+    <button type="submit" name="submit" value="{{ lang('SUBMIT') }}" class="btn btn-default" data-loading-text="{{ lang('LOADING') }}<i class='fa fa-spin fa-spinner fa-lg icon-white'></i>">{{ lang('SUBMIT') }}</button>
+    {{ S_FORM_TOKEN }}
+</div>
+
+</form>
+{% INCLUDE 'ucp_footer.html' %}
\ No newline at end of file
diff --git "[FORUM_EXT]/oxpus\\notes/styles/FLATBOOTS/theme/notes.css" "[FORUM_EXT]/oxpus\\notes/styles/FLATBOOTS/theme/notes.css"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/oxpus\\notes/styles/FLATBOOTS/theme/notes.css"
@@ -0,0 +1,9 @@
+.hide-note
+{
+    display: none;
+}
+
+.note-hidden
+{
+    border-bottom: none;
+}
\ No newline at end of file
diff --git "[ORIGINAL]/oxpus\\notes/ucp/main_info.php" "[FORUM_EXT]/oxpus\\notes/ucp/main_info.php"
--- "[ORIGINAL]/oxpus\\notes/ucp/main_info.php"
+++ "[FORUM_EXT]/oxpus\\notes/ucp/main_info.php"
@@ -21,7 +21,7 @@ class main_info
 			'title'		=> 'NOTES',
 			'version'	=> $config['notes_version'],
 			'modes'		=> [
-				'main'	=> ['title' => 'UCP_NOTES_CONFIG', 'auth' => 'ext_oxpus/notes', 'cat' => ['NOTES']],
+				'main'	=> ['title' => 'UCP_NOTES_CONFIG', 'auth' => 'ext_oxpus/notes && acl_u_notes', 'cat' => ['NOTES']],
 			],
 		];
 	}
```
