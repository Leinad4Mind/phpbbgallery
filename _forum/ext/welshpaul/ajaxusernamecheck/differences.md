Existem diferencas reais no codigo ou texto. Diferencas de formatacao (espacos, tabs) foram ignoradas abaixo.

```diff
diff --git "[ORIGINAL]/welshpaul\\ajaxusernamecheck/composer.json" "[FORUM_EXT]/welshpaul\\ajaxusernamecheck/composer.json"
--- "[ORIGINAL]/welshpaul\\ajaxusernamecheck/composer.json"
+++ "[FORUM_EXT]/welshpaul\\ajaxusernamecheck/composer.json"
@@ -2,8 +2,8 @@
     "name": "welshpaul/ajaxusernamecheck",
     "type": "phpbb-extension",
     "description": "Checks in real time if the username entered on the registration form is already in use",
-    "version": "1.0.2",
-    "time": "2025-08-15",
+    "version": "1.0.1",
+    "time": "2020-12-20",
     "keywords": [
         "ajax",
         "username",
@@ -16,10 +16,6 @@
     "authors": [
         {
             "name": "WelshPaul",
-            "role": "Previous Developer"
-        },
-        {
-            "name": "Leinad4Mind",
             "role": "Lead Developer"
         }
     ],
diff --git "[ORIGINAL]/welshpaul\\ajaxusernamecheck/controller/controller.php" "[FORUM_EXT]/welshpaul\\ajaxusernamecheck/controller/controller.php"
--- "[ORIGINAL]/welshpaul\\ajaxusernamecheck/controller/controller.php"
+++ "[FORUM_EXT]/welshpaul\\ajaxusernamecheck/controller/controller.php"
@@ -1,104 +1,8 @@
 <?php
-
 /**
  * AJAX Username Check
- * @copyright (c) 2020 WelshPaul. 2025 Leinad4Mind. All rights reserved.
- * @license   http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
- */
-
-namespace welshpaul\ajaxusernamecheck\controller;
-
-use phpbb\db\driver\factory;
-use phpbb\event\dispatcher;
-use phpbb\json_response;
-use phpbb\request\request;
-use phpbb\user;
-
-class controller
-{
-	/** @var request $request Request object */
-	protected $request;
-
-	/** @var factory $db Database object */
-	protected $db;
-
-	/** @var user $user User object */
-	protected $user;
-
-	/** @var dispatcher $dispatcher phpBB event dispatcher */
-	protected $dispatcher;
-
-	/**
-	 * Controller constructor
-	 *
-	 * @access public
-	 * @since  1.0.0
-	 *
-	 * @param request    $request    Request object
-	 * @param factory    $db         Database object
-	 * @param user       $user       User object
-	 * @param dispatcher $dispatcher phpBB event dispatcher
+ * @copyright (c) 2020 WelshPaul. All rights reserved.
+ * @license Proprietary
  */
-	public function __construct(request $request, factory $db, user $user, dispatcher $dispatcher)
-	{
-		$this->request = $request;
-		$this->db = $db;
-		$this->user = $user;
-		$this->dispatcher = $dispatcher;
-	}
 
-	/**
-	 * Function that checks the user input
-	 *
-	 * @access public
-	 * @since  1.0.0
-	 *
-	 * @param string $type The input type
-	 */
-	public function check($type)
-	{
-		// Load needed language data
-		$this->user->add_lang_ext('welshpaul/ajaxusernamecheck', ['ajaxusernamecheck']);
-		$response = new json_response();
-		$response_text = ['INVALID QUERY', $this->user->lang('WELSHPAUL_AJAXUSERNAMECHECK_INVALID_QUERY')];
-		if ($this->request->is_ajax()) {
-			switch ($type) {
-				case 'username':
-					$username = $this->request->variable('search', '');
-					if ($username !== '') {
-						$clean_username = utf8_clean_string($username);
-						$username_escaped = $this->db->sql_escape($clean_username);
-						// Check if the name is already used
-						$query = 'SELECT username FROM ' . USERS_TABLE . " WHERE username_clean = '" . $username_escaped . "'";
-						$result = $this->db->sql_query($query);
-						if ($this->db->sql_fetchrow($result)) {
-							$response_text[0] = 'NOT OK';
-							$response_text[1] = $this->user->lang('WELSHPAUL_AJAXUSERNAMECHECK_USERNAME_TAKEN');
-						}
-						$this->db->sql_freeresult($result);
-						if ($response_text[0] !== 'NOT OK') {
-							$query = 'SELECT disallow_username FROM ' . DISALLOW_TABLE;
-							// Check if the username is blocked by the board admin
-							$result = $this->db->sql_query($query);
-							while ($disallowed_user = $this->db->sql_fetchrow($result)) {
-								 // Check if the username matches the rule
-								if (preg_match('/^(' . str_replace('%', '.*', preg_quote($disallowed_user['disallow_username'])) . ')$/i', $username)) {
-									$response_text[0] = 'NOT OK';
-									$response_text[1] = $this->user->lang('WELSHPAUL_AJAXUSERNAMECHECK_USERNAME_DISALLOWED');
-									break;
-								}
-							}
-							$this->db->sql_freeresult($result);
-							if ($response_text[0] !== 'NOT OK') {
-								// All checks passed - set status to OK
-								$response_text[0] = 'OK';
-								$response_text[1] = $this->user->lang('WELSHPAUL_AJAXUSERNAMECHECK_USERNAME_OK');
-							}
-						}
-					}
-					break;
-			}
-		}
-		$response->send($response_text);
-	}
-}
+ namespace welshpaul\ajaxusernamecheck\controller; use phpbb\db\driver\factory; use phpbb\event\dispatcher; use phpbb\json_response; use phpbb\request\request; use phpbb\user; class controller { protected $request; protected $db; protected $user; protected $dispatcher; public function __construct(request $request, factory $db, user $user, dispatcher $dispatcher) { $this->request = $request; $this->db = $db; $this->user = $user; $this->dispatcher = $dispatcher; } public function check($type) { $this->user->add_lang_ext('welshpaul/ajaxusernamecheck', ['ajaxusernamecheck']); $response = new json_response(); $response_text = ['INVALID QUERY', $this->user->lang('WELSHPAUL_AJAXUSERNAMECHECK_INVALID_QUERY')]; if ($this->request->is_ajax()) { switch ($type) { case 'username': $username = $this->request->variable('search', ''); if ($username !== '') { $clean_username = utf8_clean_string($username); $username_escaped = $this->db->sql_escape($clean_username); $query = 'SELECT username FROM ' . USERS_TABLE . " WHERE username_clean = '" . $username_escaped . "'"; $result = $this->db->sql_query($query); if ($this->db->sql_fetchrow($result)) { $response_text[0] = 'NOT OK'; $response_text[1] = $this->user->lang('WELSHPAUL_AJAXUSERNAMECHECK_USERNAME_TAKEN'); } $this->db->sql_freeresult($result); if ($response_text[0] !== 'NOT OK') { $query = 'SELECT disallow_username FROM ' . DISALLOW_TABLE; $result = $this->db->sql_query($query); while ($disallowed_user = $this->db->sql_fetchrow($result)) { if (preg_match('/^(' . str_replace('%', '.*', preg_quote($disallowed_user['disallow_username'])) . ')$/i', $username)) { $response_text[0] = 'NOT OK'; $response_text[1] = $this->user->lang('WELSHPAUL_AJAXUSERNAMECHECK_USERNAME_DISALLOWED'); break; } } $this->db->sql_freeresult($result); if ($response_text[0] !== 'NOT OK') { $response_text[0] = 'OK'; $response_text[1] = $this->user->lang('WELSHPAUL_AJAXUSERNAMECHECK_USERNAME_OK'); } } } break; } } $response->send($response_text); } }
\ No newline at end of file
diff --git "[FORUM_EXT]/welshpaul\\ajaxusernamecheck/diff_full.tmp" "[FORUM_EXT]/welshpaul\\ajaxusernamecheck/diff_full.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/welshpaul\\ajaxusernamecheck/diff_full.tmp"
@@ -0,0 +1,407 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\welshpaul\\ajaxusernamecheck/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\welshpaul\\ajaxusernamecheck/composer.json"
+index bf9a7fa73..38554ded5 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\welshpaul\\ajaxusernamecheck/composer.json"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\welshpaul\\ajaxusernamecheck/composer.json"
+@@ -2,8 +2,8 @@
+     "name": "welshpaul/ajaxusernamecheck",
+     "type": "phpbb-extension",
+     "description": "Checks in real time if the username entered on the registration form is already in use",
+-    "version": "1.0.2",
+-    "time": "2025-08-15",
++    "version": "1.0.1",
++    "time": "2020-12-20",
+     "keywords": [
+         "ajax",
+         "username",
+@@ -16,10 +16,6 @@
+     "authors": [
+         {
+             "name": "WelshPaul",
+-            "role": "Previous Developer"
+-        },
+-        {
+-            "name": "Leinad4Mind",
+             "role": "Lead Developer"
+         }
+     ],
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\welshpaul\\ajaxusernamecheck/controller/controller.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\welshpaul\\ajaxusernamecheck/controller/controller.php"
+index 9a1108efd..8a413f562 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\welshpaul\\ajaxusernamecheck/controller/controller.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\welshpaul\\ajaxusernamecheck/controller/controller.php"
+@@ -1,104 +1,8 @@
+ <?php
+-
+ /**
+  * AJAX Username Check
+- * @copyright (c) 2020 WelshPaul. 2025 Leinad4Mind. All rights reserved.
+- * @license   http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
++ * @copyright (c) 2020 WelshPaul. All rights reserved.
++ * @license Proprietary
+  */
+ 
+-namespace welshpaul\ajaxusernamecheck\controller;
+-
+-use phpbb\db\driver\factory;
+-use phpbb\event\dispatcher;
+-use phpbb\json_response;
+-use phpbb\request\request;
+-use phpbb\user;
+-
+-class controller
+-{
+-	/** @var request $request Request object */
+-	protected $request;
+-
+-	/** @var factory $db Database object */
+-	protected $db;
+-
+-	/** @var user $user User object */
+-	protected $user;
+-
+-	/** @var dispatcher $dispatcher phpBB event dispatcher */
+-	protected $dispatcher;
+-
+-	/**
+-	 * Controller constructor
+-	 *
+-	 * @access public
+-	 * @since  1.0.0
+-	 *
+-	 * @param request    $request    Request object
+-	 * @param factory    $db         Database object
+-	 * @param user       $user       User object
+-	 * @param dispatcher $dispatcher phpBB event dispatcher
+-	 */
+-	public function __construct(request $request, factory $db, user $user, dispatcher $dispatcher)
+-	{
+-		$this->request = $request;
+-		$this->db = $db;
+-		$this->user = $user;
+-		$this->dispatcher = $dispatcher;
+-	}
+-
+-	/**
+-	 * Function that checks the user input
+-	 *
+-	 * @access public
+-	 * @since  1.0.0
+-	 *
+-	 * @param string $type The input type
+-	 */
+-	public function check($type)
+-	{
+-		// Load needed language data
+-		$this->user->add_lang_ext('welshpaul/ajaxusernamecheck', ['ajaxusernamecheck']);
+-		$response = new json_response();
+-		$response_text = ['INVALID QUERY', $this->user->lang('WELSHPAUL_AJAXUSERNAMECHECK_INVALID_QUERY')];
+-		if ($this->request->is_ajax()) {
+-			switch ($type) {
+-				case 'username':
+-					$username = $this->request->variable('search', '');
+-					if ($username !== '') {
+-						$clean_username = utf8_clean_string($username);
+-						$username_escaped = $this->db->sql_escape($clean_username);
+-						// Check if the name is already used
+-						$query = 'SELECT username FROM ' . USERS_TABLE . " WHERE username_clean = '" . $username_escaped . "'";
+-						$result = $this->db->sql_query($query);
+-						if ($this->db->sql_fetchrow($result)) {
+-							$response_text[0] = 'NOT OK';
+-							$response_text[1] = $this->user->lang('WELSHPAUL_AJAXUSERNAMECHECK_USERNAME_TAKEN');
+-						}
+-						$this->db->sql_freeresult($result);
+-						if ($response_text[0] !== 'NOT OK') {
+-							$query = 'SELECT disallow_username FROM ' . DISALLOW_TABLE;
+-							// Check if the username is blocked by the board admin
+-							$result = $this->db->sql_query($query);
+-							while ($disallowed_user = $this->db->sql_fetchrow($result)) {
+-								 // Check if the username matches the rule
+-								if (preg_match('/^(' . str_replace('%', '.*', preg_quote($disallowed_user['disallow_username'])) . ')$/i', $username)) {
+-									$response_text[0] = 'NOT OK';
+-									$response_text[1] = $this->user->lang('WELSHPAUL_AJAXUSERNAMECHECK_USERNAME_DISALLOWED');
+-									break;
+-								}
+-							}
+-							$this->db->sql_freeresult($result);
+-							if ($response_text[0] !== 'NOT OK') {
+-								// All checks passed - set status to OK
+-								$response_text[0] = 'OK';
+-								$response_text[1] = $this->user->lang('WELSHPAUL_AJAXUSERNAMECHECK_USERNAME_OK');
+-							}
+-						}
+-					}
+-					break;
+-			}
+-		}
+-		$response->send($response_text);
+-	}
+-}
++ namespace welshpaul\ajaxusernamecheck\controller; use phpbb\db\driver\factory; use phpbb\event\dispatcher; use phpbb\json_response; use phpbb\request\request; use phpbb\user; class controller { protected $request; protected $db; protected $user; protected $dispatcher; public function __construct(request $request, factory $db, user $user, dispatcher $dispatcher) { $this->request = $request; $this->db = $db; $this->user = $user; $this->dispatcher = $dispatcher; } public function check($type) { $this->user->add_lang_ext('welshpaul/ajaxusernamecheck', ['ajaxusernamecheck']); $response = new json_response(); $response_text = ['INVALID QUERY', $this->user->lang('WELSHPAUL_AJAXUSERNAMECHECK_INVALID_QUERY')]; if ($this->request->is_ajax()) { switch ($type) { case 'username': $username = $this->request->variable('search', ''); if ($username !== '') { $clean_username = utf8_clean_string($username); $username_escaped = $this->db->sql_escape($clean_username); $query = 'SELECT username FROM ' . USERS_TABLE . " WHERE username_clean = '" . $username_escaped . "'"; $result = $this->db->sql_query($query); if ($this->db->sql_fetchrow($result)) { $response_text[0] = 'NOT OK'; $response_text[1] = $this->user->lang('WELSHPAUL_AJAXUSERNAMECHECK_USERNAME_TAKEN'); } $this->db->sql_freeresult($result); if ($response_text[0] !== 'NOT OK') { $query = 'SELECT disallow_username FROM ' . DISALLOW_TABLE; $result = $this->db->sql_query($query); while ($disallowed_user = $this->db->sql_fetchrow($result)) { if (preg_match('/^(' . str_replace('%', '.*', preg_quote($disallowed_user['disallow_username'])) . ')$/i', $username)) { $response_text[0] = 'NOT OK'; $response_text[1] = $this->user->lang('WELSHPAUL_AJAXUSERNAMECHECK_USERNAME_DISALLOWED'); break; } } $this->db->sql_freeresult($result); if ($response_text[0] !== 'NOT OK') { $response_text[0] = 'OK'; $response_text[1] = $this->user->lang('WELSHPAUL_AJAXUSERNAMECHECK_USERNAME_OK'); } } } break; } } $response->send($response_text); } }
+\ No newline at end of file
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\welshpaul\\ajaxusernamecheck/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\welshpaul\\ajaxusernamecheck/diff_full.tmp"
+new file mode 100644
+index 000000000..4958a36d5
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\welshpaul\\ajaxusernamecheck/diff_full.tmp"
+@@ -0,0 +1,111 @@
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\welshpaul\\ajaxusernamecheck/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\welshpaul\\ajaxusernamecheck/composer.json"
++index bf9a7fa73..38554ded5 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\welshpaul\\ajaxusernamecheck/composer.json"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\welshpaul\\ajaxusernamecheck/composer.json"
++@@ -2,8 +2,8 @@
++     "name": "welshpaul/ajaxusernamecheck",
++     "type": "phpbb-extension",
++     "description": "Checks in real time if the username entered on the registration form is already in use",
++-    "version": "1.0.2",
++-    "time": "2025-08-15",
+++    "version": "1.0.1",
+++    "time": "2020-12-20",
++     "keywords": [
++         "ajax",
++         "username",
++@@ -16,10 +16,6 @@
++     "authors": [
++         {
++             "name": "WelshPaul",
++-            "role": "Previous Developer"
++-        },
++-        {
++-            "name": "Leinad4Mind",
++             "role": "Lead Developer"
++         }
++     ],
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\welshpaul\\ajaxusernamecheck/controller/controller.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\welshpaul\\ajaxusernamecheck/controller/controller.php"
++index 9a1108efd..8a413f562 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\welshpaul\\ajaxusernamecheck/controller/controller.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\welshpaul\\ajaxusernamecheck/controller/controller.php"
++@@ -1,104 +1,8 @@
++ <?php
++-
++ /**
++  * AJAX Username Check
++- * @copyright (c) 2020 WelshPaul. 2025 Leinad4Mind. All rights reserved.
++- * @license   http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+++ * @copyright (c) 2020 WelshPaul. All rights reserved.
+++ * @license Proprietary
++  */
++ 
++-namespace welshpaul\ajaxusernamecheck\controller;
++-
++-use phpbb\db\driver\factory;
++-use phpbb\event\dispatcher;
++-use phpbb\json_response;
++-use phpbb\request\request;
++-use phpbb\user;
++-
++-class controller
++-{
++-	/** @var request $request Request object */
++-	protected $request;
++-
++-	/** @var factory $db Database object */
++-	protected $db;
++-
++-	/** @var user $user User object */
++-	protected $user;
++-
++-	/** @var dispatcher $dispatcher phpBB event dispatcher */
++-	protected $dispatcher;
++-
++-	/**
++-	 * Controller constructor
++-	 *
++-	 * @access public
++-	 * @since  1.0.0
++-	 *
++-	 * @param request    $request    Request object
++-	 * @param factory    $db         Database object
++-	 * @param user       $user       User object
++-	 * @param dispatcher $dispatcher phpBB event dispatcher
++-	 */
++-	public function __construct(request $request, factory $db, user $user, dispatcher $dispatcher)
++-	{
++-		$this->request = $request;
++-		$this->db = $db;
++-		$this->user = $user;
++-		$this->dispatcher = $dispatcher;
++-	}
++-
++-	/**
++-	 * Function that checks the user input
++-	 *
++-	 * @access public
++-	 * @since  1.0.0
++-	 *
++-	 * @param string $type The input type
++-	 */
++-	public function check($type)
++-	{
++-		// Load needed language data
++-		$this->user->add_lang_ext('welshpaul/ajaxusernamecheck', ['ajaxusernamecheck']);
++-		$response = new json_response();
++-		$response_text = ['INVALID QUERY', $this->user->lang('WELSHPAUL_AJAXUSERNAMECHECK_INVALID_QUERY')];
++-		if ($this->request->is_ajax()) {
++-			switch ($type) {
++-				case 'username':
++-					$username = $this->request->variable('search', '');
++-					if ($username !== '') {
++-						$clean_username = utf8_clean_string($username);
++-						$username_escaped = $this->db->sql_escape($clean_username);
++-						// Check if the name is already used
++-						$query = 'SELECT username FROM ' . USERS_TABLE . " WHERE username_clean = '" . $username_escaped . "'";
++-						$result = $this->db->sql_query($query);
++-						if ($this->db->sql_fetchrow($result)) {
++-							$response_text[0] = 'NOT OK';
++-							$response_text[1] = $this->user->lang('WELSHPAUL_AJAXUSERNAMECHECK_USERNAME_TAKEN');
++-						}
++-						$this->db->sql_freeres
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\welshpaul\\ajaxusernamecheck/event/listener.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\welshpaul\\ajaxusernamecheck/event/listener.php"
+index 79c58093b..2a70800ef 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\welshpaul\\ajaxusernamecheck/event/listener.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\welshpaul\\ajaxusernamecheck/event/listener.php"
+@@ -1,103 +1,8 @@
+ <?php
+-
+ /**
+  * AJAX Username Check
+- * @copyright (c) 2020 WelshPaul. 2025 Leinad4Mind. All rights reserved.
++ * @copyright (c) 2020 WelshPaul. All rights reserved.
+  * @license Proprietary
+  */
+ 
+-namespace welshpaul\ajaxusernamecheck\event;
+-
+-use phpbb\config\config;
+-use phpbb\controller\helper;
+-use phpbb\template\template;
+-use phpbb\user;
+-use Symfony\Component\EventDispatcher\EventSubscriberInterface;
+-
+-class listener implements EventSubscriberInterface
+-{
+-	/** @var config $config Configuration object */
+-	protected $config;
+-
+-	/** @var helper $helper Controller helper object */
+-	protected $helper;
+-
+-	/** @var template $template Template object */
+-	protected $template;
+-
+-	/** @var user $user User object */
+-	protected $user;
+-
+-	/**
+-	 * Listener constructor
+-	 *
+-	 * @access public
+-	 * @since  1.0.0
+-	 *
+-	 * @param config   $config   Configuration object
+-	 * @param helper   $helper   Controller helper object
+-	 * @param template $template Template object
+-	 * @param user     $user     User object
+-	 */
+-	public function __construct(config $config, helper $helper, template $template, user $user)
+-	{
+-		$this->config = $config;
+-		$this->helper = $helper;
+-		$this->template = $template;
+-		$this->user = $user;
+-	}
+-
+-	/**
+-	 * Function that returns the subscribed events
+-	 *
+-	 * @access public
+-	 * @since  1.0.0
+-	 *
+-	 * @return array Array with the subscribed events
+-	 */
+-	static public function getSubscribedEvents()
+-	{
+-		return ['core.ucp_register_data_before' => 'assign_register_data',];
+-	}
+-
+-	/**
+-	 * Function to assign all needed data to the registration form
+-	 *
+-	 * @access public
+-	 * @since  1.0.0
+-	 */
+-	public function assign_register_data()
+-	{
+-		// Load language data
+-		$this->user->add_lang_ext('welshpaul/ajaxusernamecheck', ['ajaxusernamecheck']);
+-		$username_rule = $this->config['allow_name_chars'];
+-		switch ($username_rule) {
+-			case 'USERNAME_CHARS_ANY':
+-				$username_rule = "^.+$";
+-				break;
+-			case 'USERNAME_ALPHA_ONLY':
+-				$username_rule = "^[a-zA-Z0-9]+$";
+-				break;
+-			case 'USERNAME_ALPHA_SPACERS':
+-				$username_rule = "^[a-zA-Z0-9 \\-\\+_\\[\\\]]+$";
+-				break;
+-			case 'USERNAME_LETTER_NUM':
+-				$username_rule = "^[a-zA-Z0-9äöüÄÖÜ]+$";
+-				break;
+-			case 'USERNAME_LETTER_NUM_SPACERS':
+-				$username_rule = "^[a-zA-Z0-9äöüÄÖÜ \\-\\+_\\[\\\]]+$";
+-				break;
+-			case 'USERNAME_ASCII':
+-				$username_rule = "^[a-zA-Z0-9 !\\\"#\\$%&'\\(\\)\\*\\+,\\-\\.\\/:;<=>\\?@\\[\\\]\\^_`\\{\\|\\}~]+$";
+-				break;
+-		}
+-		$this->template->assign_vars([
+-			'WELSHPAUL_AJAXUSERNAMECHECK' => true,
+-			'WELSHPAUL_AJAXUSERNAMECHECK_USERNAME_MIN' => $this->config['min_name_chars'],
+-			'WELSHPAUL_AJAXUSERNAMECHECK_USERNAME_MAX' => $this->config['max_name_chars'],
+-			'WELSHPAUL_AJAXUSERNAMECHECK_USERNAME_RULE' => $username_rule,
+-			'WELSHPAUL_AJAXUSERNAMECHECK_USERNAME_INVALID_BOUNDARIES' => $this->user->lang($this->config['allow_name_chars'] . '_EXPLAIN', $this->config['min_name_chars'], $this->config['max_name_chars']),
+-			'WELSHPAUL_AJAXUSERNAMECHECK_CHECK_USERNAME_LINK' => $this->helper->route('welshpaul_ajaxusernamecheck_controller', ['type' => 'username']),
+-		]);
+-	}
+-}
++namespace welshpaul\ajaxusernamecheck\event; use phpbb\config\config; use phpbb\controller\helper; use phpbb\template\template; use phpbb\user; use Symfony\Component\EventDispatcher\EventSubscriberInterface; class listener implements EventSubscriberInterface { protected $config; protected $helper; protected $template; protected $user; public function __construct(config $config, helper $helper, template $template, user $user) { $this->config = $config; $this->helper = $helper; $this->template = $template; $this->user = $user; } static public function getSubscribedEvents() { return [ 'core.ucp_register_data_before' => 'assign_register_data', ]; } public function assign_register_data() { $this->user->add_lang_ext('welshpaul/ajaxusernamecheck', ['ajaxusernamecheck']); $username_rule = $this->config['allow_name_chars']; switch ($username_rule) { case 'USERNAME_CHARS_ANY': $username_rule = "^.+$"; break; case 'USERNAME_ALPHA_ONLY': $username_rule = "^[a-zA-Z0-9]+$"; break; case 'USERNAME_ALPHA_SPACERS': $username_rule = "^[a-zA-Z0-9 \\-\\+_\\[\\\]]+$"; break; case 'USERNAME_LETTER_NUM': $username_rule = "^[a-zA-Z0-9äöüÄÖÜ]+$"; break; case 'USERNAME_LETTER_NUM_SPACERS': $username_rule = "^[a-zA-Z0-9äöüÄÖÜ \\-\\+_\\[\\\]]+$"; break; case 'USERNAME_ASCII': $username_rule = "^[a-zA-Z0-9 !\\\"#\\$%&'\\(\\)\\*\\+,\\-\\.\\/:;<=>\\?@\\[\\\]\\^_`\\{\\|\\}~]+$"; break; } $this->template->assign_vars( [ 'WELSHPAUL_AJAXUSERNAMECHECK' => true, 'WELSHPAUL_AJAXUSERNAMECHECK_USERNAME_MIN' => $this->config['min_name_chars'], 'WELSHPAUL_AJAXUSERNAMECHECK_USERNAME_MAX' => $this->config['max_name_chars'], 'WELSHPAUL_AJAXUSERNAMECHECK_USERNAME_RULE' => $username_rule, 'WELSHPAUL_AJAXUSERNAMECHECK_USERNAME_INVALID_BOUNDARIES' => $this->user->lang($this->config['allow_name_chars'] . '_EXPLAIN', $this->config['min_name_chars'], $this->config['max_name_chars']), 'WELSHPAUL_AJAXUSERNAMECHECK_CHECK_USERNAME_LINK' => $this->helper->route('welshpaul_ajaxusernamecheck_controller', ['type' => 'username']), ] ); } }
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\welshpaul\\ajaxusernamecheck/language/en/ajaxusernamecheck.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\welshpaul\\ajaxusernamecheck/language/en/ajaxusernamecheck.php"
+index eef81822e..a382598a7 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\welshpaul\\ajaxusernamecheck/language/en/ajaxusernamecheck.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\welshpaul\\ajaxusernamecheck/language/en/ajaxusernamecheck.php"
+@@ -1,7 +1,7 @@
+ <?php
+ /**
+  * AJAX Username Check
+- * @copyright (c) 2020 WelshPaul. 2025 Leinad4Mind. All rights reserved.
++ * @copyright (c) 2020 WelshPaul. All rights reserved.
+  * @license Proprietary
+  */
+ 
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\welshpaul\\ajaxusernamecheck/language/pt/ajaxusernamecheck.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\welshpaul\\ajaxusernamecheck/language/pt/ajaxusernamecheck.php"
+index 83d4d65f5..09f3acf63 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\welshpaul\\ajaxusernamecheck/language/pt/ajaxusernamecheck.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\welshpaul\\ajaxusernamecheck/language/pt/ajaxusernamecheck.php"
+@@ -1,7 +1,7 @@
+ <?php
+ /**
+  * AJAX Username Check
+- * @copyright (c) 2020 WelshPaul. 2025 Leinad4Mind. All rights reserved.
++ * @copyright (c) 2020 WelshPaul. All rights reserved.
+  * @license Proprietary
+  */
+ 
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\welshpaul\\ajaxusernamecheck/language/pt_preao/ajaxusernamecheck.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\welshpaul\\ajaxusernamecheck/language/pt_preao/ajaxusernamecheck.php"
+index 83d4d65f5..09f3acf63 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\welshpaul\\ajaxusernamecheck/language/pt_preao/ajaxusernamecheck.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\welshpaul\\ajaxusernamecheck/language/pt_preao/ajaxusernamecheck.php"
+@@ -1,7 +1,7 @@
+ <?php
+ /**
+  * AJAX Username Check
+- * @copyright (c) 2020 WelshPaul. 2025 Leinad4Mind. All rights reserved.
++ * @copyright (c) 2020 WelshPaul. All rights reserved.
+  * @license Proprietary
+  */
+ 
diff --git "[FORUM_EXT]/welshpaul\\ajaxusernamecheck/diff_nospace.tmp" "[FORUM_EXT]/welshpaul\\ajaxusernamecheck/diff_nospace.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/welshpaul\\ajaxusernamecheck/diff_nospace.tmp"
@@ -0,0 +1,512 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\welshpaul\\ajaxusernamecheck/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\welshpaul\\ajaxusernamecheck/composer.json"
+index bf9a7fa73..38554ded5 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\welshpaul\\ajaxusernamecheck/composer.json"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\welshpaul\\ajaxusernamecheck/composer.json"
+@@ -2,8 +2,8 @@
+     "name": "welshpaul/ajaxusernamecheck",
+     "type": "phpbb-extension",
+     "description": "Checks in real time if the username entered on the registration form is already in use",
+-    "version": "1.0.2",
+-    "time": "2025-08-15",
++    "version": "1.0.1",
++    "time": "2020-12-20",
+     "keywords": [
+         "ajax",
+         "username",
+@@ -16,10 +16,6 @@
+     "authors": [
+         {
+             "name": "WelshPaul",
+-            "role": "Previous Developer"
+-        },
+-        {
+-            "name": "Leinad4Mind",
+             "role": "Lead Developer"
+         }
+     ],
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\welshpaul\\ajaxusernamecheck/controller/controller.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\welshpaul\\ajaxusernamecheck/controller/controller.php"
+index 9a1108efd..8a413f562 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\welshpaul\\ajaxusernamecheck/controller/controller.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\welshpaul\\ajaxusernamecheck/controller/controller.php"
+@@ -1,104 +1,8 @@
+ <?php
+-
+ /**
+  * AJAX Username Check
+- * @copyright (c) 2020 WelshPaul. 2025 Leinad4Mind. All rights reserved.
+- * @license   http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+- */
+-
+-namespace welshpaul\ajaxusernamecheck\controller;
+-
+-use phpbb\db\driver\factory;
+-use phpbb\event\dispatcher;
+-use phpbb\json_response;
+-use phpbb\request\request;
+-use phpbb\user;
+-
+-class controller
+-{
+-	/** @var request $request Request object */
+-	protected $request;
+-
+-	/** @var factory $db Database object */
+-	protected $db;
+-
+-	/** @var user $user User object */
+-	protected $user;
+-
+-	/** @var dispatcher $dispatcher phpBB event dispatcher */
+-	protected $dispatcher;
+-
+-	/**
+-	 * Controller constructor
+-	 *
+-	 * @access public
+-	 * @since  1.0.0
+-	 *
+-	 * @param request    $request    Request object
+-	 * @param factory    $db         Database object
+-	 * @param user       $user       User object
+-	 * @param dispatcher $dispatcher phpBB event dispatcher
++ * @copyright (c) 2020 WelshPaul. All rights reserved.
++ * @license Proprietary
+  */
+-	public function __construct(request $request, factory $db, user $user, dispatcher $dispatcher)
+-	{
+-		$this->request = $request;
+-		$this->db = $db;
+-		$this->user = $user;
+-		$this->dispatcher = $dispatcher;
+-	}
+ 
+-	/**
+-	 * Function that checks the user input
+-	 *
+-	 * @access public
+-	 * @since  1.0.0
+-	 *
+-	 * @param string $type The input type
+-	 */
+-	public function check($type)
+-	{
+-		// Load needed language data
+-		$this->user->add_lang_ext('welshpaul/ajaxusernamecheck', ['ajaxusernamecheck']);
+-		$response = new json_response();
+-		$response_text = ['INVALID QUERY', $this->user->lang('WELSHPAUL_AJAXUSERNAMECHECK_INVALID_QUERY')];
+-		if ($this->request->is_ajax()) {
+-			switch ($type) {
+-				case 'username':
+-					$username = $this->request->variable('search', '');
+-					if ($username !== '') {
+-						$clean_username = utf8_clean_string($username);
+-						$username_escaped = $this->db->sql_escape($clean_username);
+-						// Check if the name is already used
+-						$query = 'SELECT username FROM ' . USERS_TABLE . " WHERE username_clean = '" . $username_escaped . "'";
+-						$result = $this->db->sql_query($query);
+-						if ($this->db->sql_fetchrow($result)) {
+-							$response_text[0] = 'NOT OK';
+-							$response_text[1] = $this->user->lang('WELSHPAUL_AJAXUSERNAMECHECK_USERNAME_TAKEN');
+-						}
+-						$this->db->sql_freeresult($result);
+-						if ($response_text[0] !== 'NOT OK') {
+-							$query = 'SELECT disallow_username FROM ' . DISALLOW_TABLE;
+-							// Check if the username is blocked by the board admin
+-							$result = $this->db->sql_query($query);
+-							while ($disallowed_user = $this->db->sql_fetchrow($result)) {
+-								 // Check if the username matches the rule
+-								if (preg_match('/^(' . str_replace('%', '.*', preg_quote($disallowed_user['disallow_username'])) . ')$/i', $username)) {
+-									$response_text[0] = 'NOT OK';
+-									$response_text[1] = $this->user->lang('WELSHPAUL_AJAXUSERNAMECHECK_USERNAME_DISALLOWED');
+-									break;
+-								}
+-							}
+-							$this->db->sql_freeresult($result);
+-							if ($response_text[0] !== 'NOT OK') {
+-								// All checks passed - set status to OK
+-								$response_text[0] = 'OK';
+-								$response_text[1] = $this->user->lang('WELSHPAUL_AJAXUSERNAMECHECK_USERNAME_OK');
+-							}
+-						}
+-					}
+-					break;
+-			}
+-		}
+-		$response->send($response_text);
+-	}
+-}
++ namespace welshpaul\ajaxusernamecheck\controller; use phpbb\db\driver\factory; use phpbb\event\dispatcher; use phpbb\json_response; use phpbb\request\request; use phpbb\user; class controller { protected $request; protected $db; protected $user; protected $dispatcher; public function __construct(request $request, factory $db, user $user, dispatcher $dispatcher) { $this->request = $request; $this->db = $db; $this->user = $user; $this->dispatcher = $dispatcher; } public function check($type) { $this->user->add_lang_ext('welshpaul/ajaxusernamecheck', ['ajaxusernamecheck']); $response = new json_response(); $response_text = ['INVALID QUERY', $this->user->lang('WELSHPAUL_AJAXUSERNAMECHECK_INVALID_QUERY')]; if ($this->request->is_ajax()) { switch ($type) { case 'username': $username = $this->request->variable('search', ''); if ($username !== '') { $clean_username = utf8_clean_string($username); $username_escaped = $this->db->sql_escape($clean_username); $query = 'SELECT username FROM ' . USERS_TABLE . " WHERE username_clean = '" . $username_escaped . "'"; $result = $this->db->sql_query($query); if ($this->db->sql_fetchrow($result)) { $response_text[0] = 'NOT OK'; $response_text[1] = $this->user->lang('WELSHPAUL_AJAXUSERNAMECHECK_USERNAME_TAKEN'); } $this->db->sql_freeresult($result); if ($response_text[0] !== 'NOT OK') { $query = 'SELECT disallow_username FROM ' . DISALLOW_TABLE; $result = $this->db->sql_query($query); while ($disallowed_user = $this->db->sql_fetchrow($result)) { if (preg_match('/^(' . str_replace('%', '.*', preg_quote($disallowed_user['disallow_username'])) . ')$/i', $username)) { $response_text[0] = 'NOT OK'; $response_text[1] = $this->user->lang('WELSHPAUL_AJAXUSERNAMECHECK_USERNAME_DISALLOWED'); break; } } $this->db->sql_freeresult($result); if ($response_text[0] !== 'NOT OK') { $response_text[0] = 'OK'; $response_text[1] = $this->user->lang('WELSHPAUL_AJAXUSERNAMECHECK_USERNAME_OK'); } } } break; } } $response->send($response_text); } }
+\ No newline at end of file
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\welshpaul\\ajaxusernamecheck/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\welshpaul\\ajaxusernamecheck/diff_full.tmp"
+new file mode 100644
+index 000000000..cfda452e0
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\welshpaul\\ajaxusernamecheck/diff_full.tmp"
+@@ -0,0 +1,407 @@
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\welshpaul\\ajaxusernamecheck/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\welshpaul\\ajaxusernamecheck/composer.json"
++index bf9a7fa73..38554ded5 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\welshpaul\\ajaxusernamecheck/composer.json"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\welshpaul\\ajaxusernamecheck/composer.json"
++@@ -2,8 +2,8 @@
++     "name": "welshpaul/ajaxusernamecheck",
++     "type": "phpbb-extension",
++     "description": "Checks in real time if the username entered on the registration form is already in use",
++-    "version": "1.0.2",
++-    "time": "2025-08-15",
+++    "version": "1.0.1",
+++    "time": "2020-12-20",
++     "keywords": [
++         "ajax",
++         "username",
++@@ -16,10 +16,6 @@
++     "authors": [
++         {
++             "name": "WelshPaul",
++-            "role": "Previous Developer"
++-        },
++-        {
++-            "name": "Leinad4Mind",
++             "role": "Lead Developer"
++         }
++     ],
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\welshpaul\\ajaxusernamecheck/controller/controller.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\welshpaul\\ajaxusernamecheck/controller/controller.php"
++index 9a1108efd..8a413f562 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\welshpaul\\ajaxusernamecheck/controller/controller.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\welshpaul\\ajaxusernamecheck/controller/controller.php"
++@@ -1,104 +1,8 @@
++ <?php
++-
++ /**
++  * AJAX Username Check
++- * @copyright (c) 2020 WelshPaul. 2025 Leinad4Mind. All rights reserved.
++- * @license   http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
+++ * @copyright (c) 2020 WelshPaul. All rights reserved.
+++ * @license Proprietary
++  */
++ 
++-namespace welshpaul\ajaxusernamecheck\controller;
++-
++-use phpbb\db\driver\factory;
++-use phpbb\event\dispatcher;
++-use phpbb\json_response;
++-use phpbb\request\request;
++-use phpbb\user;
++-
++-class controller
++-{
++-	/** @var request $request Request object */
++-	protected $request;
++-
++-	/** @var factory $db Database object */
++-	protected $db;
++-
++-	/** @var user $user User object */
++-	protected $user;
++-
++-	/** @var dispatcher $dispatcher phpBB event dispatcher */
++-	protected $dispatcher;
++-
++-	/**
++-	 * Controller constructor
++-	 *
++-	 * @access public
++-	 * @since  1.0.0
++-	 *
++-	 * @param request    $request    Request object
++-	 * @param factory    $db         Database object
++-	 * @param user       $user       User object
++-	 * @param dispatcher $dispatcher phpBB event dispatcher
++-	 */
++-	public function __construct(request $request, factory $db, user $user, dispatcher $dispatcher)
++-	{
++-		$this->request = $request;
++-		$this->db = $db;
++-		$this->user = $user;
++-		$this->dispatcher = $dispatcher;
++-	}
++-
++-	/**
++-	 * Function that checks the user input
++-	 *
++-	 * @access public
++-	 * @since  1.0.0
++-	 *
++-	 * @param string $type The input type
++-	 */
++-	public function check($type)
++-	{
++-		// Load needed language data
++-		$this->user->add_lang_ext('welshpaul/ajaxusernamecheck', ['ajaxusernamecheck']);
++-		$response = new json_response();
++-		$response_text = ['INVALID QUERY', $this->user->lang('WELSHPAUL_AJAXUSERNAMECHECK_INVALID_QUERY')];
++-		if ($this->request->is_ajax()) {
++-			switch ($type) {
++-				case 'username':
++-					$username = $this->request->variable('search', '');
++-					if ($username !== '') {
++-						$clean_username = utf8_clean_string($username);
++-						$username_escaped = $this->db->sql_escape($clean_username);
++-						// Check if the name is already used
++-						$query = 'SELECT username FROM ' . USERS_TABLE . " WHERE username_clean = '" . $username_escaped . "'";
++-						$result = $this->db->sql_query($query);
++-						if ($this->db->sql_fetchrow($result)) {
++-							$response_text[0] = 'NOT OK';
++-							$response_text[1] = $this->user->lang('WELSHPAUL_AJAXUSERNAMECHECK_USERNAME_TAKEN');
++-						}
++-						$this->db->sql_freeresult($result);
++-						if ($response_text[0] !== 'NOT OK') {
++-							$query = 'SELECT disallow_username FROM ' . DISALLOW_TABLE;
++-							// Check if the username is blocked by the board admin
++-							$result = $this->db->sql_query($query);
++-							while ($disallowed_user = $this->db->sql_fetchrow($result)) {
++-								 // Check if the username matches the rule
++-								if (preg_match('/^(' . str_replace('%', '.*', preg_quote($disallowed_user['disallow_username'])) . ')$/i', $username)) {
++-									$response_text[0] = 'NOT OK';
++-									$response_text[1] = $this->user->lang('WELSHPAUL_AJAXUSERNAMECHECK_USERNAME_DISALLOWED');
++-									break;
++-								}
++-							}
++-							$this->db->sql_freeresult($result);
++-							if ($response_text[0] !== 'NOT OK') {
++-								// All checks passed - set status to OK
++-								$response_text[0] = 'OK';
++-								$response_text[1] = $this->user->lang('WELSHPAUL_AJAXUSERNAMECHECK_USERNAME_OK');
++-							}
++-						}
++-					}
++-					break;
++-			}
++-		}
++-		$response->send($response_text);
++-	}
++-}
+++ namespace welshpaul\ajaxusernamecheck\controller; use phpbb\db\driver\factory; use phpbb\event\dispatcher; use phpbb\json_response; use phpbb\request\request; use phpbb\user; class controller { protected $request; protected $db; protected $user; protected $dispatcher; public function __construct(request $request, factory $db, user $user, dispatcher $dispatcher) { $this->request = $request; $this->db = $db; $this->user = $user; $this->dispatcher = $dispatcher; } public function check($type) { $this->user->add_lang_ext('welshpaul/ajaxusernamecheck', ['ajaxusernamecheck']); $response = new json_response(); $response_text = ['INVALID QUERY', $this->user->lang('WELSHPAUL_AJAXUSERNAMECHECK_INVALID_QUERY')]; if ($this->request->is_ajax()) { switch ($type) { case 'username': $username = $this->request->variable('search', ''); if ($username !== '') { $clean_username = utf8_clean_string($username); $username_escaped = $this->db->sql_escape($clean_username); $query = 'SELECT username FROM ' . USERS_TABLE . " WHERE username_clean = '" . $username_escaped . "'"; $result = $this->db->sql_query($query); if ($this->db->sql_fetchrow($result)) { $response_text[0] = 'NOT OK'; $response_text[1] = $this->user->lang('WELSHPAUL_AJAXUSERNAMECHECK_USERNAME_TAKEN'); } $this->db->sql_freeresult($result); if ($response_text[0] !== 'NOT OK') { $query = 'SELECT disallow_username FROM ' . DISALLOW_TABLE; $result = $this->db->sql_query($query); while ($disallowed_user = $this->db->sql_fetchrow($result)) { if (preg_match('/^(' . str_replace('%', '.*', preg_quote($disallowed_user['disallow_username'])) . ')$/i', $username)) { $response_text[0] = 'NOT OK'; $response_text[1] = $this->user->lang('WELSHPAUL_AJAXUSERNAMECHECK_USERNAME_DISALLOWED'); break; } } $this->db->sql_freeresult($result); if ($response_text[0] !== 'NOT OK') { $response_text[0] = 'OK'; $response_text[1] = $this->user->lang('WELSHPAUL_AJAXUSERNAMECHECK_USERNAME_OK'); } } } break; } } $response->send($response_text); } }
++\ No newline at end of file
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\welshpaul\\ajaxusernamecheck/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\welshpaul\\ajaxusernamecheck/diff_full.tmp"
++new file mode 100644
++index 000000000..4958a36d5
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\welshpaul\\ajaxusernamecheck/diff_full.tmp"
++@@ -0,0 +1,111 @@
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\welshpaul\\ajaxusernamecheck/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\welshpaul\\ajaxusernamecheck/composer.json"
+++index bf9a7fa73..38554ded5 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\welshpaul\\ajaxusernamecheck/composer.json"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\welshpaul\\ajaxusernamecheck/composer.json"
+++@@ -2,8 +2,8 @@
+++     "name": "welshpaul/ajaxusernamecheck",
+++     "type": "phpbb-extension",
+++     "description": "Checks in real time if the username entered on the registration form is already in use",
+++-    "version": "1.0.2",
+++-    "time": "2025-08-15",
++++    "version": "1.0.1",
++++    "time": "2020-12-20",
+++     "keywords": [
+++         "ajax",
+++         "username",
+++@@ -16,10 +16,6 @@
+++     "authors": [
+++         {
+++             "name": "WelshPaul",
+++-            "role": "Previous Developer"
+++-        },
+++-        {
+++-            "name": "Leinad4Mind",
+++             "role": "Lead Developer"
+++         }
+++     ],
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\welshpaul\\ajaxusernamecheck/controller/controller.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\welshpaul\\ajaxusernamecheck/controller/controller.php"
+++index 9a1108efd..8a413f562 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\welshpaul\\ajaxusernamecheck/controller/controller.php"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\welshpaul\\ajaxusernamecheck/controller/controller.php"
+++@@ -1,104 +1,8 @@
+++ <?php
+++-
+++ /**
+++  * AJAX Username Check
+++- * @copyright (c) 2020 WelshPaul. 2025 Leinad4Mind. All rights reserved.
+++- * @license   http://opensource.org/licenses/gpl-2.0.php GNU General Public License v2
++++ * @copyright (c) 2020 WelshPaul. All rights reserved.
++++ * @license Proprietary
+++  */
+++ 
+++-namespace welshpaul\ajaxusernamecheck\controller;
+++-
+++-use phpbb\db\driver\factory;
+++-use phpbb\event\dispatcher;
+++-use phpbb\json_response;
+++-use phpbb\request\request;
+++-use phpbb\user;
+++-
+++-class controller
+++-{
+++-	/** @var request $request Request object */
+++-	protected $request;
+++-
+++-	/** @var factory $db Database object */
+++-	protected $db;
+++-
+++-	/** @var user $user User object */
+++-	protected $user;
+++-
+++-	/** @var dispatcher $dispatcher phpBB event dispatcher */
+++-	protected $dispatcher;
+++-
+++-	/**
+++-	 * Controller constructor
+++-	 *
+++-	 * @access public
+++-	 * @since  1.0.0
+++-	 *
+++-	 * @param request    $request    Request object
+++-	 * @param factory    $db         Database object
+++-	 * @param user       $user       User object
+++-	 * @param dispatcher $dispatcher phpBB event dispatcher
+++-	 */
+++-	public function __construct(request $request, factory $db, user $user, dispatcher $dispatcher)
+++-	{
+++-		$this->request = $request;
+++-		$this->db = $db;
+++-		$this->user = $user;
+++-		$this->dispatcher = $dispatcher;
+++-	}
+++-
+++-	/**
+++-	 * Function that checks the user input
+++-	 *
+++-	 * @access public
+++-	 * @since  1.0.0
+++-	 *
+++-	 * @param string $type The input type
+++-	 */
+++-	public function check($type)
+++-	{
+++-		// Load needed language data
+++-		$this->user->add_lang_ext('welshpaul/ajaxusernamecheck', ['ajaxusernamecheck']);
+++-		$response = new json_response();
+++-		$response_text = ['INVALID QUERY', $this->user->lang('WELSHPAUL_AJAXUSERNAMECHECK_INVALID_QUERY')];
+++-		if ($this->request->is_ajax()) {
+++-			switch ($type) {
+++-				case 'username':
+++-					$username = $this->request->variable('search', '');
+++-					if ($username !== '') {
+++-						$clean_username = utf8_clean_string($username);
+++-						$username_escaped = $this->db->sql_escape($clean_username);
+++-						// Check if the name is already used
+++-						$query = 'SELECT username FROM ' . USERS_TABLE . " WHERE username_clean = '" . $username_escaped . "'";
+++-						$result = $this->db->sql_query($query);
+++-						if ($this->db->sql_fetchrow($result)) {
+++-							$response_text[0] = 'NOT OK';
+++-							$response_text[1] = $this->user->lang('WELSHPAUL_AJAXUSERNAMECHECK_USERNAME_TAKEN');
+++-						}
+++-						$this->db->sql_freeres
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\welshpaul\\ajaxusernamecheck/event/listener.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\welshpaul\\ajaxusernamecheck/event/listener.php"
++index 79c58093b..2a70800ef 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\welshpaul\\ajaxusernamecheck/event/listener.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\welshpaul\\ajaxusernamecheck/event/listener.php"
++@@ -1,103 +1,8 @@
++ <?php
++-
++ /**
++  * AJAX Username Check
++- * @copyright (c) 2020 WelshPaul. 2025 Leinad4Mind. All rights reserved.
+++ * @copyright (c) 2020 WelshPaul. All rights reserved.
++  * @license Proprietary
++  */
++ 
++-namespace welshpaul\ajaxusernamecheck\event;
++-
++-use phpbb\config\config;
++-use phpbb\controller\helper;
++-use phpbb\template\template;
++-use phpbb\user;
++-use Symfony\Component\EventDispatcher\EventSubscriberInterface;
++-
++-class listener implements EventSubscriberInterface
++-{
++-	/** @var config $config Configuration object */
++-	protected $config;
++-
++-	/** @var helper $helper Controller helper object */
++-	protected $helper;
++-
++-	/** @var template $template Template object */
++-	protected $template;
++-
++-	/** @var user $user User object */
++-	protected $user;
++-
++-	/**
++-	 * Listener constructor
++-	 *
++-	 * @access public
++-	 * @since  1.0.0
++-	 *
++-	 * @param config   $config   Configuration object
++-	 * @param helper   $helper   Controller helper object
++-	 * @param template $template Template object
++-	 * @param user     $user     User object
++-	 */
++-	public function __construct(config $config, helper $helper, template $template, user $user)
++-	{
++-		$this->config = $config;
++-		$this->helper = $helper;
++-		$this->template = $template;
++-		$this->user = $user;
++-	}
++-
++-	/**
++-	 * Function that returns the subscribed events
++-	 *
++-	 * @access public
++-	 * @since  1.0.0
++-	 *
++-	 * @return array Array with the subscribed events
++-	 */
++-	static public function getSubscribedEvents()
++-	{
++-		return ['core.ucp_register_data_before' => 'assign_register_data',];
++-	}
++-
++-	/**
++-	 * Function to assign all needed data to the registration form
++-	 *
++-	 * @access public
++-	 * @since  1.0.0
++-	 */
++-	public function assign_register_data()
++-	{
++-		// Load language data
++-		$this->user->add_lang_ext('welshpaul/ajaxusernamecheck', ['ajaxusernamecheck']);
++-		$username_rule = $this->config['allow_name_chars'];
++-		switch ($username_rule) {
++-			case 'USERNAME_CHARS_ANY':
++-				$username_rule = "^.+$";
++-				break;
++-			case 'USERNAME_ALPHA_ONLY':
++-				$username_rule = "^[a-zA-Z0-9]+$";
++-				break;
++-			case 'USERNAME_ALPHA_SPACERS':
++-				$username_rule = "^[a-zA-Z0-9 \\-\\+_\\[\\\]]+$";
++-				break;
++-			case 'USERNAME_LETTER_NUM':
++-				$username_rule = "^[a-zA-Z0-9äöüÄÖÜ]+$";
++-				break;
++-			case 'USERNAME_LETTER_NUM_SPACERS':
++-				$username_rule = "^[a-zA-Z0-9äöüÄÖÜ \\-\\+_\\[\\\]]+$";
++-				break;
++-			case 'USERNAME_ASCII':
++-				$username_rule = "^[a-zA-Z0-9 !\\\"#\\$%&'\\(\\)\\*\\+,\\-\\.\\/:;<=>\\?@\\[\\\]\\^_`\\{\\|\\}~]+$";
++-				break;
++-		}
++-		$this->template->assign_vars([
++-			'WELSHPAUL_AJAXUSERNAMECHECK' => true,
++-			'WELSHPAUL_AJAXUSERNAMECHECK_USERNAME_MIN' => $this->config['min_name_chars'],
++-			'WELSHPAUL_AJAXUSERNAMECHECK_USERNAME_MAX' => $this->config['max_name_chars'],
++-			'WELSHPAUL_AJAXUSERNAMECHECK_USERNAME_RULE' => $username_rule,
++-			'WELSHPAUL_AJAXUSERNAMECHECK_USERNAME_INVALID_BOUNDARIES' => $this->user->lang($this->config['allow_name_chars'] . '_EXPLAIN', $this->config['min_name_chars'], $this->config['max_name_chars']),
++-			'WELSHPAUL_AJAXUSERNAMECHECK_CHECK_USERNAME_LINK' => $this->helper->route('welshpaul_ajaxusernamecheck_controller', ['type' => 'username']),
++-		]);
++-	}
++-}
+++namespace welshpaul\ajaxusernamecheck\event; use phpbb\config\config; use phpbb\controller\helper; use phpbb\template\template; use phpbb\user; use Symfony\Component\EventDispatcher\EventSubscriberInterface; class listener implements EventSubscriberInterface { protected $config; protected $helper; protected $template; protected $user; public function __construct(config $config, helper $helper, template $template, user $user) { $this->config = $config; $this->helper = $helper; $this->template = $template; $this->user = $user; } static public function getSubscribedEvents() { return [ 'core.ucp_register_data_before' => 'assign_register_data', ]; } public function assign_register_data() { $this->user->add_lang_ext('welshpaul/ajaxusernamecheck', ['ajaxusernamecheck']); $username_rule = $this->config['allow_name_chars']; switch ($username_rule) { case 'USERNAME_CHARS_ANY': $username_rule = "^.+$"; break; case 'USERNAME_ALPHA_ONLY': $username_rule = "^[a-zA-Z0-9]+$"; break; case 'USERNAME_ALPHA_SPACERS': $username_rule = "^[a-zA-Z0-9 \\-\\+_\
\ No newline at end of file
diff --git "[ORIGINAL]/welshpaul\\ajaxusernamecheck/event/listener.php" "[FORUM_EXT]/welshpaul\\ajaxusernamecheck/event/listener.php"
--- "[ORIGINAL]/welshpaul\\ajaxusernamecheck/event/listener.php"
+++ "[FORUM_EXT]/welshpaul\\ajaxusernamecheck/event/listener.php"
@@ -1,103 +1,8 @@
 <?php
-
 /**
  * AJAX Username Check
- * @copyright (c) 2020 WelshPaul. 2025 Leinad4Mind. All rights reserved.
+ * @copyright (c) 2020 WelshPaul. All rights reserved.
  * @license Proprietary
  */
 
-namespace welshpaul\ajaxusernamecheck\event;
-
-use phpbb\config\config;
-use phpbb\controller\helper;
-use phpbb\template\template;
-use phpbb\user;
-use Symfony\Component\EventDispatcher\EventSubscriberInterface;
-
-class listener implements EventSubscriberInterface
-{
-	/** @var config $config Configuration object */
-	protected $config;
-
-	/** @var helper $helper Controller helper object */
-	protected $helper;
-
-	/** @var template $template Template object */
-	protected $template;
-
-	/** @var user $user User object */
-	protected $user;
-
-	/**
-	 * Listener constructor
-	 *
-	 * @access public
-	 * @since  1.0.0
-	 *
-	 * @param config   $config   Configuration object
-	 * @param helper   $helper   Controller helper object
-	 * @param template $template Template object
-	 * @param user     $user     User object
-	 */
-	public function __construct(config $config, helper $helper, template $template, user $user)
-	{
-		$this->config = $config;
-		$this->helper = $helper;
-		$this->template = $template;
-		$this->user = $user;
-	}
-
-	/**
-	 * Function that returns the subscribed events
-	 *
-	 * @access public
-	 * @since  1.0.0
-	 *
-	 * @return array Array with the subscribed events
-	 */
-	static public function getSubscribedEvents()
-	{
-		return ['core.ucp_register_data_before' => 'assign_register_data',];
-	}
-
-	/**
-	 * Function to assign all needed data to the registration form
-	 *
-	 * @access public
-	 * @since  1.0.0
-	 */
-	public function assign_register_data()
-	{
-		// Load language data
-		$this->user->add_lang_ext('welshpaul/ajaxusernamecheck', ['ajaxusernamecheck']);
-		$username_rule = $this->config['allow_name_chars'];
-		switch ($username_rule) {
-			case 'USERNAME_CHARS_ANY':
-				$username_rule = "^.+$";
-				break;
-			case 'USERNAME_ALPHA_ONLY':
-				$username_rule = "^[a-zA-Z0-9]+$";
-				break;
-			case 'USERNAME_ALPHA_SPACERS':
-				$username_rule = "^[a-zA-Z0-9 \\-\\+_\\[\\\]]+$";
-				break;
-			case 'USERNAME_LETTER_NUM':
-				$username_rule = "^[a-zA-Z0-9äöüÄÖÜ]+$";
-				break;
-			case 'USERNAME_LETTER_NUM_SPACERS':
-				$username_rule = "^[a-zA-Z0-9äöüÄÖÜ \\-\\+_\\[\\\]]+$";
-				break;
-			case 'USERNAME_ASCII':
-				$username_rule = "^[a-zA-Z0-9 !\\\"#\\$%&'\\(\\)\\*\\+,\\-\\.\\/:;<=>\\?@\\[\\\]\\^_`\\{\\|\\}~]+$";
-				break;
-		}
-		$this->template->assign_vars([
-			'WELSHPAUL_AJAXUSERNAMECHECK' => true,
-			'WELSHPAUL_AJAXUSERNAMECHECK_USERNAME_MIN' => $this->config['min_name_chars'],
-			'WELSHPAUL_AJAXUSERNAMECHECK_USERNAME_MAX' => $this->config['max_name_chars'],
-			'WELSHPAUL_AJAXUSERNAMECHECK_USERNAME_RULE' => $username_rule,
-			'WELSHPAUL_AJAXUSERNAMECHECK_USERNAME_INVALID_BOUNDARIES' => $this->user->lang($this->config['allow_name_chars'] . '_EXPLAIN', $this->config['min_name_chars'], $this->config['max_name_chars']),
-			'WELSHPAUL_AJAXUSERNAMECHECK_CHECK_USERNAME_LINK' => $this->helper->route('welshpaul_ajaxusernamecheck_controller', ['type' => 'username']),
-		]);
-	}
-}
+namespace welshpaul\ajaxusernamecheck\event; use phpbb\config\config; use phpbb\controller\helper; use phpbb\template\template; use phpbb\user; use Symfony\Component\EventDispatcher\EventSubscriberInterface; class listener implements EventSubscriberInterface { protected $config; protected $helper; protected $template; protected $user; public function __construct(config $config, helper $helper, template $template, user $user) { $this->config = $config; $this->helper = $helper; $this->template = $template; $this->user = $user; } static public function getSubscribedEvents() { return [ 'core.ucp_register_data_before' => 'assign_register_data', ]; } public function assign_register_data() { $this->user->add_lang_ext('welshpaul/ajaxusernamecheck', ['ajaxusernamecheck']); $username_rule = $this->config['allow_name_chars']; switch ($username_rule) { case 'USERNAME_CHARS_ANY': $username_rule = "^.+$"; break; case 'USERNAME_ALPHA_ONLY': $username_rule = "^[a-zA-Z0-9]+$"; break; case 'USERNAME_ALPHA_SPACERS': $username_rule = "^[a-zA-Z0-9 \\-\\+_\\[\\\]]+$"; break; case 'USERNAME_LETTER_NUM': $username_rule = "^[a-zA-Z0-9äöüÄÖÜ]+$"; break; case 'USERNAME_LETTER_NUM_SPACERS': $username_rule = "^[a-zA-Z0-9äöüÄÖÜ \\-\\+_\\[\\\]]+$"; break; case 'USERNAME_ASCII': $username_rule = "^[a-zA-Z0-9 !\\\"#\\$%&'\\(\\)\\*\\+,\\-\\.\\/:;<=>\\?@\\[\\\]\\^_`\\{\\|\\}~]+$"; break; } $this->template->assign_vars( [ 'WELSHPAUL_AJAXUSERNAMECHECK' => true, 'WELSHPAUL_AJAXUSERNAMECHECK_USERNAME_MIN' => $this->config['min_name_chars'], 'WELSHPAUL_AJAXUSERNAMECHECK_USERNAME_MAX' => $this->config['max_name_chars'], 'WELSHPAUL_AJAXUSERNAMECHECK_USERNAME_RULE' => $username_rule, 'WELSHPAUL_AJAXUSERNAMECHECK_USERNAME_INVALID_BOUNDARIES' => $this->user->lang($this->config['allow_name_chars'] . '_EXPLAIN', $this->config['min_name_chars'], $this->config['max_name_chars']), 'WELSHPAUL_AJAXUSERNAMECHECK_CHECK_USERNAME_LINK' => $this->helper->route('welshpaul_ajaxusernamecheck_controller', ['type' => 'username']), ] ); } }
\ No newline at end of file
diff --git "[ORIGINAL]/welshpaul\\ajaxusernamecheck/language/en/ajaxusernamecheck.php" "[FORUM_EXT]/welshpaul\\ajaxusernamecheck/language/en/ajaxusernamecheck.php"
--- "[ORIGINAL]/welshpaul\\ajaxusernamecheck/language/en/ajaxusernamecheck.php"
+++ "[FORUM_EXT]/welshpaul\\ajaxusernamecheck/language/en/ajaxusernamecheck.php"
@@ -1,7 +1,7 @@
 <?php
 /**
  * AJAX Username Check
- * @copyright (c) 2020 WelshPaul. 2025 Leinad4Mind. All rights reserved.
+ * @copyright (c) 2020 WelshPaul. All rights reserved.
  * @license Proprietary
  */
 
diff --git "[ORIGINAL]/welshpaul\\ajaxusernamecheck/language/pt/ajaxusernamecheck.php" "[FORUM_EXT]/welshpaul\\ajaxusernamecheck/language/pt/ajaxusernamecheck.php"
--- "[ORIGINAL]/welshpaul\\ajaxusernamecheck/language/pt/ajaxusernamecheck.php"
+++ "[FORUM_EXT]/welshpaul\\ajaxusernamecheck/language/pt/ajaxusernamecheck.php"
@@ -1,7 +1,7 @@
 <?php
 /**
  * AJAX Username Check
- * @copyright (c) 2020 WelshPaul. 2025 Leinad4Mind. All rights reserved.
+ * @copyright (c) 2020 WelshPaul. All rights reserved.
  * @license Proprietary
  */
 
diff --git "[ORIGINAL]/welshpaul\\ajaxusernamecheck/language/pt_preao/ajaxusernamecheck.php" "[FORUM_EXT]/welshpaul\\ajaxusernamecheck/language/pt_preao/ajaxusernamecheck.php"
--- "[ORIGINAL]/welshpaul\\ajaxusernamecheck/language/pt_preao/ajaxusernamecheck.php"
+++ "[FORUM_EXT]/welshpaul\\ajaxusernamecheck/language/pt_preao/ajaxusernamecheck.php"
@@ -1,7 +1,7 @@
 <?php
 /**
  * AJAX Username Check
- * @copyright (c) 2020 WelshPaul. 2025 Leinad4Mind. All rights reserved.
+ * @copyright (c) 2020 WelshPaul. All rights reserved.
  * @license Proprietary
  */
 
```
