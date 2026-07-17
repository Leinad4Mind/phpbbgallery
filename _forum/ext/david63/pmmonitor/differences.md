Existem diferencas reais no codigo ou texto. Diferencas de formatacao (espacos, tabs) foram ignoradas abaixo.

```diff
diff --git "[ORIGINAL]/david63\\pmmonitor/adm/style/pmmonitor.css" "[FORUM_EXT]/david63\\pmmonitor/adm/style/pmmonitor.css"
--- "[ORIGINAL]/david63\\pmmonitor/adm/style/pmmonitor.css"
+++ "[FORUM_EXT]/david63\\pmmonitor/adm/style/pmmonitor.css"
@@ -1,3 +1,7 @@
+/**
+* pmmonitor.css
+**/
+
 /* Content container styles
 ----------------------------------------*/
 .content {
@@ -214,3 +218,22 @@ dl.thumbnail dt a:hover {
 dl.thumbnail dt a:hover img {
 	border: 1px solid #d2d2d2;
 }
+
+.version {
+		border-radius: 15px;
+	font-size: 1.00em;
+		color: #000000;
+	font-weight: bold;
+		background: #3EED0E;
+	text-align: center;
+	display: inline-block;
+	width: 50px;
+}
+
+.version_name{
+	font-size: 1.00em;
+	text-align: left;
+	font-weight: bold;
+	color: #4A5A73;
+	margin: 10px
+}
diff --git "[ORIGINAL]/david63\\pmmonitor/adm/style/pmmonitor.html" "[FORUM_EXT]/david63\\pmmonitor/adm/style/pmmonitor.html"
--- "[ORIGINAL]/david63\\pmmonitor/adm/style/pmmonitor.html"
+++ "[FORUM_EXT]/david63\\pmmonitor/adm/style/pmmonitor.html"
@@ -4,8 +4,8 @@
 <a name="maincontent"></a>
 
 <h1>{{ lang('PM_MONITOR_READ') }}</h1>
-{PM_MONITOR_VERSION}<br /><br />
 <p>{{ lang('PM_MONITOR_READ_EXPLAIN') }}</p>
+<span class="version_name">{{ lang('VERSION') }}{{ lang('COLON') }}</span><span class="version">{PM_MONITOR_VERSION}</span>
 <hr />
 
 <form id="pm_monitor" method="post" action="{U_ACTION}">
@@ -28,14 +28,14 @@
 	<thead>
 		<tr>
 			<th style="width: 6%;">{{ lang('MARK') }}</th>
-			<th style="width: 16%;">{{ lang('SUBJECT') }}</th>
-			<th style="width: 16%;">{{ lang('SORT_FROM') }}</th>
-			<th style="width: 15%;">{{ lang('TO') }}</th>
+			<th style="width: 15%;">{{ lang('SUBJECT') }}</th>
+			<th style="width: 15%;">{{ lang('SORT_FROM') }}</th>
+			<th style="width: 14%;">{{ lang('SORT_TO') }}</th>
 			<th style="width: 11%;">{{ lang('BCC') }}</th>
-			<th style="width: 1%;">&nbsp;</th>
+			<th style="width: 9%;">{{ lang('IS_GROUP') }}</th>
 			<th style="width: 9%;">{{ lang('PM_BOX') }}</th>
-			<th style="width: 14%;">{{ lang('AUTHOR_IP') }}</th>
-			<th style="width: 12%;">{{ lang('DATE') }}</th>
+			<th style="width: 10%;">{{ lang('AUTHOR_IP') }}</th>
+			<th style="width: 10%;">{{ lang('DATE') }}</th>
 		</tr>
 	</thead>
 
diff --git "[ORIGINAL]/david63\\pmmonitor/composer.json" "[FORUM_EXT]/david63\\pmmonitor/composer.json"
--- "[ORIGINAL]/david63\\pmmonitor/composer.json"
+++ "[FORUM_EXT]/david63\\pmmonitor/composer.json"
@@ -13,17 +13,17 @@
 	"license": "GPL-2.0",
 	"authors": [{
 			"name": "David Wood",
-			"username": "david63",
 			"role": "Developer"
 		}],
 	"require": {
-        "php": ">=5.3.3",
+        "php": ">=5.4,<7.1",
+		"phpbb/phpbb": ">=3.2.0-RC1",
         "composer/installers": "~1.0"
     },
 	"extra": {
 		"display-name": "PM monitor",
 		"soft-require": {
-			"phpbb/phpbb": ">=3.2.0-a1"
+			"phpbb/phpbb": ">=3.2.0-RC1"
       }
 	}
 }
diff --git "[ORIGINAL]/david63\\pmmonitor/config/services.yml" "[FORUM_EXT]/david63\\pmmonitor/config/services.yml"
--- "[ORIGINAL]/david63\\pmmonitor/config/services.yml"
+++ "[FORUM_EXT]/david63\\pmmonitor/config/services.yml"
@@ -18,3 +18,4 @@ services:
             - '%core.root_path%'
             - '%core.php_ext%'
             - '@language'
+            - '@log'
diff --git "[ORIGINAL]/david63\\pmmonitor/controller/admin_controller.php" "[FORUM_EXT]/david63\\pmmonitor/controller/admin_controller.php"
--- "[ORIGINAL]/david63\\pmmonitor/controller/admin_controller.php"
+++ "[FORUM_EXT]/david63\\pmmonitor/controller/admin_controller.php"
@@ -47,6 +47,9 @@ class admin_controller implements admin_interface
 	/** @var phpbb\language\language */
 	protected $language;
 
+	/** @var \phpbb\log\log */
+	protected $log;
+
 	/** @var string Custom form action */
 	protected $u_action;
 
@@ -63,11 +66,12 @@ class admin_controller implements admin_interface
 	* @param string 							$root_path
 	* @param string 							$php_ext
 	* @param phpbb\language\language			$language
+	* @param \phpbb\log\log						$log
 	*
 	* @return \david63\pmmonitor\controller\admin_controller
 	* @access public
 	*/
-	public function __construct(\phpbb\config\config $config, \phpbb\db\driver\driver_interface $db, \phpbb\request\request $request, \phpbb\template\template $template, \phpbb\pagination $pagination, \phpbb\user $user, \phpbb\auth\auth $auth, $root_path, $php_ext, \phpbb\language\language $language)
+	public function __construct(\phpbb\config\config $config, \phpbb\db\driver\driver_interface $db, \phpbb\request\request $request, \phpbb\template\template $template, \phpbb\pagination $pagination, \phpbb\user $user, \phpbb\auth\auth $auth, $root_path, $php_ext, \phpbb\language\language $language, \phpbb\log\log $log)
 	{
 		$this->config			= $config;
 		$this->db  				= $db;
@@ -79,6 +83,7 @@ class admin_controller implements admin_interface
 		$this->phpbb_root_path	= $root_path;
 		$this->phpEx			= $php_ext;
 		$this->language			= $language;
+		$this->log				= $log;
 	}
 
 	/**
@@ -147,8 +152,7 @@ class admin_controller implements admin_interface
 				}
 
 				// Add option settings change action to the admin log
-				$phpbb_log = $this->container->get('log');
-				$phpbb_log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_PM_MONITOR');
+				$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_PM_MONITOR');
 			}
 			else
 			{
diff --git "[FORUM_EXT]/david63\\pmmonitor/diff_full.tmp" "[FORUM_EXT]/david63\\pmmonitor/diff_full.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/david63\\pmmonitor/diff_full.tmp"
@@ -0,0 +1,304 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\david63\\pmmonitor/adm/style/pmmonitor.css" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\david63\\pmmonitor/adm/style/pmmonitor.css"
+index 1a92b2b82..fc063b8d0 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\david63\\pmmonitor/adm/style/pmmonitor.css"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\david63\\pmmonitor/adm/style/pmmonitor.css"
+@@ -1,3 +1,7 @@
++/**
++* pmmonitor.css
++**/
++
+ /* Content container styles
+ ----------------------------------------*/
+ .content {
+@@ -214,3 +218,22 @@ dl.thumbnail dt a:hover {
+ dl.thumbnail dt a:hover img {
+ 	border: 1px solid #d2d2d2;
+ }
++
++.version {
++		border-radius: 15px;
++	font-size: 1.00em;
++		color: #000000;
++	font-weight: bold;
++		background: #3EED0E;
++	text-align: center;
++	display: inline-block;
++	width: 50px;
++}
++
++.version_name{
++	font-size: 1.00em;
++	text-align: left;
++	font-weight: bold;
++	color: #4A5A73;
++	margin: 10px
++}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\david63\\pmmonitor/adm/style/pmmonitor.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\david63\\pmmonitor/adm/style/pmmonitor.html"
+index 430cfe035..41fad6c0e 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\david63\\pmmonitor/adm/style/pmmonitor.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\david63\\pmmonitor/adm/style/pmmonitor.html"
+@@ -4,8 +4,8 @@
+ <a name="maincontent"></a>
+ 
+ <h1>{{ lang('PM_MONITOR_READ') }}</h1>
+-{PM_MONITOR_VERSION}<br /><br />
+ <p>{{ lang('PM_MONITOR_READ_EXPLAIN') }}</p>
++<span class="version_name">{{ lang('VERSION') }}{{ lang('COLON') }}</span><span class="version">{PM_MONITOR_VERSION}</span>
+ <hr />
+ 
+ <form id="pm_monitor" method="post" action="{U_ACTION}">
+@@ -28,14 +28,14 @@
+ 	<thead>
+ 		<tr>
+ 			<th style="width: 6%;">{{ lang('MARK') }}</th>
+-			<th style="width: 16%;">{{ lang('SUBJECT') }}</th>
+-			<th style="width: 16%;">{{ lang('SORT_FROM') }}</th>
+-			<th style="width: 15%;">{{ lang('TO') }}</th>
++			<th style="width: 15%;">{{ lang('SUBJECT') }}</th>
++			<th style="width: 15%;">{{ lang('SORT_FROM') }}</th>
++			<th style="width: 14%;">{{ lang('SORT_TO') }}</th>
+ 			<th style="width: 11%;">{{ lang('BCC') }}</th>
+-			<th style="width: 1%;">&nbsp;</th>
++			<th style="width: 9%;">{{ lang('IS_GROUP') }}</th>
+ 			<th style="width: 9%;">{{ lang('PM_BOX') }}</th>
+-			<th style="width: 14%;">{{ lang('AUTHOR_IP') }}</th>
+-			<th style="width: 12%;">{{ lang('DATE') }}</th>
++			<th style="width: 10%;">{{ lang('AUTHOR_IP') }}</th>
++			<th style="width: 10%;">{{ lang('DATE') }}</th>
+ 		</tr>
+ 	</thead>
+ 
+@@ -81,4 +81,4 @@
+ </form>
+ 
+ {% INCLUDEJS '@david63_pmmonitor/dropdown.js' %}
+-{% include 'overall_footer.html' %}
++{% include 'overall_footer.html' %}
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\david63\\pmmonitor/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\david63\\pmmonitor/composer.json"
+index 9765ddc9c..ce186a268 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\david63\\pmmonitor/composer.json"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\david63\\pmmonitor/composer.json"
+@@ -13,17 +13,17 @@
+ 	"license": "GPL-2.0",
+ 	"authors": [{
+ 			"name": "David Wood",
+-			"username": "david63",
+ 			"role": "Developer"
+ 		}],
+ 	"require": {
+-        "php": ">=5.3.3",
++        "php": ">=5.4,<7.1",
++		"phpbb/phpbb": ">=3.2.0-RC1",
+         "composer/installers": "~1.0"
+     },
+ 	"extra": {
+ 		"display-name": "PM monitor",
+ 		"soft-require": {
+-			"phpbb/phpbb": ">=3.2.0-a1"
++			"phpbb/phpbb": ">=3.2.0-RC1"
+       }
+ 	}
+ }
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\david63\\pmmonitor/config/services.yml" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\david63\\pmmonitor/config/services.yml"
+index 4d041f2e2..303acf69f 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\david63\\pmmonitor/config/services.yml"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\david63\\pmmonitor/config/services.yml"
+@@ -17,4 +17,5 @@ services:
+             - '@auth'
+             - '%core.root_path%'
+             - '%core.php_ext%'
+-            - '@language'			
++            - '@language'
++            - '@log'
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\david63\\pmmonitor/controller/admin_controller.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\david63\\pmmonitor/controller/admin_controller.php"
+index 652c65029..874fb5530 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\david63\\pmmonitor/controller/admin_controller.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\david63\\pmmonitor/controller/admin_controller.php"
+@@ -47,6 +47,9 @@ class admin_controller implements admin_interface
+ 	/** @var phpbb\language\language */
+ 	protected $language;
+ 
++	/** @var \phpbb\log\log */
++	protected $log;
++
+ 	/** @var string Custom form action */
+ 	protected $u_action;
+ 
+@@ -63,11 +66,12 @@ class admin_controller implements admin_interface
+ 	* @param string 							$root_path
+ 	* @param string 							$php_ext
+ 	* @param phpbb\language\language			$language
++	* @param \phpbb\log\log						$log
+ 	*
+ 	* @return \david63\pmmonitor\controller\admin_controller
+ 	* @access public
+ 	*/
+-	public function __construct(\phpbb\config\config $config, \phpbb\db\driver\driver_interface $db, \phpbb\request\request $request, \phpbb\template\template $template, \phpbb\pagination $pagination, \phpbb\user $user, \phpbb\auth\auth $auth, $root_path, $php_ext, \phpbb\language\language $language)
++	public function __construct(\phpbb\config\config $config, \phpbb\db\driver\driver_interface $db, \phpbb\request\request $request, \phpbb\template\template $template, \phpbb\pagination $pagination, \phpbb\user $user, \phpbb\auth\auth $auth, $root_path, $php_ext, \phpbb\language\language $language, \phpbb\log\log $log)
+ 	{
+ 		$this->config			= $config;
+ 		$this->db  				= $db;
+@@ -79,6 +83,7 @@ class admin_controller implements admin_interface
+ 		$this->phpbb_root_path	= $root_path;
+ 		$this->phpEx			= $php_ext;
+ 		$this->language			= $language;
++		$this->log				= $log;
+ 	}
+ 
+ 	/**
+@@ -147,8 +152,7 @@ class admin_controller implements admin_interface
+ 				}
+ 
+ 				// Add option settings change action to the admin log
+-				$phpbb_log = $this->container->get('log');
+-				$phpbb_log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_PM_MONITOR');
++				$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_PM_MONITOR');
+ 			}
+ 			else
+ 			{
+@@ -223,7 +227,7 @@ class admin_controller implements admin_interface
+ 				'IS_GROUP'				=> (strstr($row['to_address'], 'g')) ? $this->language->lang('IS_GROUP') : '',
+ 				'LAST_VISIT_FROM'		=> $this->get_last_visit($row['author_id']),
+ 				'LAST_VISIT_TO'			=> ($row['to_address']) ? $this->get_last_visit($row['user_id'], $row['author_id']) : '',
+-				// Swapping ' for "is needed as request does not handle double quotes
++				// Swapping ' for " is needed as request does not handle double quotes
+ 				'PM_ID'					=> str_replace('"', "'", json_encode(array('msg_ids' => $row['msg_id'], 'user_id' => $row['user_id'], 'folder_id' => $row['folder_id']))),
+ 				// Create a unique key for the js script
+ 				'PM_KEY'				=> $row['msg_id'] . $row['user_id'],
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\david63\\pmmonitor/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\david63\\pmmonitor/diff_full.tmp"
+new file mode 100644
+index 000000000..adac3e78a
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\david63\\pmmonitor/diff_full.tmp"
+@@ -0,0 +1,104 @@
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\david63\\pmmonitor/adm/style/pmmonitor.css" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\david63\\pmmonitor/adm/style/pmmonitor.css"
++index 1a92b2b82..fc063b8d0 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\david63\\pmmonitor/adm/style/pmmonitor.css"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\david63\\pmmonitor/adm/style/pmmonitor.css"
++@@ -1,3 +1,7 @@
+++/**
+++* pmmonitor.css
+++**/
+++
++ /* Content container styles
++ ----------------------------------------*/
++ .content {
++@@ -214,3 +218,22 @@ dl.thumbnail dt a:hover {
++ dl.thumbnail dt a:hover img {
++ 	border: 1px solid #d2d2d2;
++ }
+++
+++.version {
+++		border-radius: 15px;
+++	font-size: 1.00em;
+++		color: #000000;
+++	font-weight: bold;
+++		background: #3EED0E;
+++	text-align: center;
+++	display: inline-block;
+++	width: 50px;
+++}
+++
+++.version_name{
+++	font-size: 1.00em;
+++	text-align: left;
+++	font-weight: bold;
+++	color: #4A5A73;
+++	margin: 10px
+++}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\david63\\pmmonitor/adm/style/pmmonitor.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\david63\\pmmonitor/adm/style/pmmonitor.html"
++index 430cfe035..41fad6c0e 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\david63\\pmmonitor/adm/style/pmmonitor.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\david63\\pmmonitor/adm/style/pmmonitor.html"
++@@ -4,8 +4,8 @@
++ <a name="maincontent"></a>
++ 
++ <h1>{{ lang('PM_MONITOR_READ') }}</h1>
++-{PM_MONITOR_VERSION}<br /><br />
++ <p>{{ lang('PM_MONITOR_READ_EXPLAIN') }}</p>
+++<span class="version_name">{{ lang('VERSION') }}{{ lang('COLON') }}</span><span class="version">{PM_MONITOR_VERSION}</span>
++ <hr />
++ 
++ <form id="pm_monitor" method="post" action="{U_ACTION}">
++@@ -28,14 +28,14 @@
++ 	<thead>
++ 		<tr>
++ 			<th style="width: 6%;">{{ lang('MARK') }}</th>
++-			<th style="width: 16%;">{{ lang('SUBJECT') }}</th>
++-			<th style="width: 16%;">{{ lang('SORT_FROM') }}</th>
++-			<th style="width: 15%;">{{ lang('TO') }}</th>
+++			<th style="width: 15%;">{{ lang('SUBJECT') }}</th>
+++			<th style="width: 15%;">{{ lang('SORT_FROM') }}</th>
+++			<th style="width: 14%;">{{ lang('SORT_TO') }}</th>
++ 			<th style="width: 11%;">{{ lang('BCC') }}</th>
++-			<th style="width: 1%;">&nbsp;</th>
+++			<th style="width: 9%;">{{ lang('IS_GROUP') }}</th>
++ 			<th style="width: 9%;">{{ lang('PM_BOX') }}</th>
++-			<th style="width: 14%;">{{ lang('AUTHOR_IP') }}</th>
++-			<th style="width: 12%;">{{ lang('DATE') }}</th>
+++			<th style="width: 10%;">{{ lang('AUTHOR_IP') }}</th>
+++			<th style="width: 10%;">{{ lang('DATE') }}</th>
++ 		</tr>
++ 	</thead>
++ 
++@@ -81,4 +81,4 @@
++ </form>
++ 
++ {% INCLUDEJS '@david63_pmmonitor/dropdown.js' %}
++-{% include 'overall_footer.html' %}
+++{% include 'overall_footer.html' %}
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\david63\\pmmonitor/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\david63\\pmmonitor/composer.json"
++index 9765ddc9c..ce186a268 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\david63\\pmmonitor/composer.json"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\david63\\pmmonitor/composer.json"
++@@ -13,17 +13,17 @@
++ 	"license": "GPL-2.0",
++ 	"authors": [{
++ 			"name": "David Wood",
++-			"username": "david63",
++ 			"role": "Developer"
++ 		}],
++ 	"require": {
++-        "php": ">=5.3.3",
+++        "php": ">=5.4,<7.1",
+++		"phpbb/phpbb": ">=3.2.0-RC1",
++         "composer/installers": "~1.0"
++     },
++ 	"extra": {
++ 		"display-name": "PM monitor",
++ 		"soft-require": {
++-			"phpbb/phpbb": ">=3.2.0-a1"
+++			"phpbb/phpbb": ">=3.2.0-RC1"
++       }
++ 	}
++ }
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\david63\\pmmonitor/config/services.yml" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\david63\\pmmonitor/config/services.yml"
++index 4d041
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\david63\\pmmonitor/language/en/acp_pmmonitor.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\david63\\pmmonitor/language/en/acp_pmmonitor.php"
+index 6344bb502..da8313747 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\david63\\pmmonitor/language/en/acp_pmmonitor.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\david63\\pmmonitor/language/en/acp_pmmonitor.php"
+@@ -65,4 +65,6 @@ $lang = array_merge($lang, array(
+ 	'SORT_FROM'					=> 'From',
+ 	'SORT_PM_BOX'				=> 'PM box',
+ 	'SORT_TO'					=> 'To',
++
++	'VERSION'					=> 'Version',
+ ));
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\david63\\pmmonitor/language/en/permissions_pmmonitor.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\david63\\pmmonitor/language/en/permissions_pmmonitor.php"
+index 49d80d2aa..e2bff9b0e 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\david63\\pmmonitor/language/en/permissions_pmmonitor.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\david63\\pmmonitor/language/en/permissions_pmmonitor.php"
+@@ -38,6 +38,4 @@ if (empty($lang) || !is_array($lang))
+ 
+ $lang = array_merge($lang, array(
+ 	'ACL_A_COMMS_PM_MANAGE'		=> 'Can manage PM monitor',
+-));
+-
+-?>
+\ No newline at end of file
++));
+\ No newline at end of file
diff --git "[FORUM_EXT]/david63\\pmmonitor/diff_nospace.tmp" "[FORUM_EXT]/david63\\pmmonitor/diff_nospace.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/david63\\pmmonitor/diff_nospace.tmp"
@@ -0,0 +1,447 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\david63\\pmmonitor/adm/style/pmmonitor.css" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\david63\\pmmonitor/adm/style/pmmonitor.css"
+index 1a92b2b82..fc063b8d0 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\david63\\pmmonitor/adm/style/pmmonitor.css"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\david63\\pmmonitor/adm/style/pmmonitor.css"
+@@ -1,3 +1,7 @@
++/**
++* pmmonitor.css
++**/
++
+ /* Content container styles
+ ----------------------------------------*/
+ .content {
+@@ -214,3 +218,22 @@ dl.thumbnail dt a:hover {
+ dl.thumbnail dt a:hover img {
+ 	border: 1px solid #d2d2d2;
+ }
++
++.version {
++		border-radius: 15px;
++	font-size: 1.00em;
++		color: #000000;
++	font-weight: bold;
++		background: #3EED0E;
++	text-align: center;
++	display: inline-block;
++	width: 50px;
++}
++
++.version_name{
++	font-size: 1.00em;
++	text-align: left;
++	font-weight: bold;
++	color: #4A5A73;
++	margin: 10px
++}
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\david63\\pmmonitor/adm/style/pmmonitor.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\david63\\pmmonitor/adm/style/pmmonitor.html"
+index 430cfe035..41fad6c0e 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\david63\\pmmonitor/adm/style/pmmonitor.html"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\david63\\pmmonitor/adm/style/pmmonitor.html"
+@@ -4,8 +4,8 @@
+ <a name="maincontent"></a>
+ 
+ <h1>{{ lang('PM_MONITOR_READ') }}</h1>
+-{PM_MONITOR_VERSION}<br /><br />
+ <p>{{ lang('PM_MONITOR_READ_EXPLAIN') }}</p>
++<span class="version_name">{{ lang('VERSION') }}{{ lang('COLON') }}</span><span class="version">{PM_MONITOR_VERSION}</span>
+ <hr />
+ 
+ <form id="pm_monitor" method="post" action="{U_ACTION}">
+@@ -28,14 +28,14 @@
+ 	<thead>
+ 		<tr>
+ 			<th style="width: 6%;">{{ lang('MARK') }}</th>
+-			<th style="width: 16%;">{{ lang('SUBJECT') }}</th>
+-			<th style="width: 16%;">{{ lang('SORT_FROM') }}</th>
+-			<th style="width: 15%;">{{ lang('TO') }}</th>
++			<th style="width: 15%;">{{ lang('SUBJECT') }}</th>
++			<th style="width: 15%;">{{ lang('SORT_FROM') }}</th>
++			<th style="width: 14%;">{{ lang('SORT_TO') }}</th>
+ 			<th style="width: 11%;">{{ lang('BCC') }}</th>
+-			<th style="width: 1%;">&nbsp;</th>
++			<th style="width: 9%;">{{ lang('IS_GROUP') }}</th>
+ 			<th style="width: 9%;">{{ lang('PM_BOX') }}</th>
+-			<th style="width: 14%;">{{ lang('AUTHOR_IP') }}</th>
+-			<th style="width: 12%;">{{ lang('DATE') }}</th>
++			<th style="width: 10%;">{{ lang('AUTHOR_IP') }}</th>
++			<th style="width: 10%;">{{ lang('DATE') }}</th>
+ 		</tr>
+ 	</thead>
+ 
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\david63\\pmmonitor/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\david63\\pmmonitor/composer.json"
+index 9765ddc9c..ce186a268 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\david63\\pmmonitor/composer.json"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\david63\\pmmonitor/composer.json"
+@@ -13,17 +13,17 @@
+ 	"license": "GPL-2.0",
+ 	"authors": [{
+ 			"name": "David Wood",
+-			"username": "david63",
+ 			"role": "Developer"
+ 		}],
+ 	"require": {
+-        "php": ">=5.3.3",
++        "php": ">=5.4,<7.1",
++		"phpbb/phpbb": ">=3.2.0-RC1",
+         "composer/installers": "~1.0"
+     },
+ 	"extra": {
+ 		"display-name": "PM monitor",
+ 		"soft-require": {
+-			"phpbb/phpbb": ">=3.2.0-a1"
++			"phpbb/phpbb": ">=3.2.0-RC1"
+       }
+ 	}
+ }
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\david63\\pmmonitor/config/services.yml" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\david63\\pmmonitor/config/services.yml"
+index 4d041f2e2..303acf69f 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\david63\\pmmonitor/config/services.yml"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\david63\\pmmonitor/config/services.yml"
+@@ -18,3 +18,4 @@ services:
+             - '%core.root_path%'
+             - '%core.php_ext%'
+             - '@language'
++            - '@log'
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\david63\\pmmonitor/controller/admin_controller.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\david63\\pmmonitor/controller/admin_controller.php"
+index 652c65029..874fb5530 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\david63\\pmmonitor/controller/admin_controller.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\david63\\pmmonitor/controller/admin_controller.php"
+@@ -47,6 +47,9 @@ class admin_controller implements admin_interface
+ 	/** @var phpbb\language\language */
+ 	protected $language;
+ 
++	/** @var \phpbb\log\log */
++	protected $log;
++
+ 	/** @var string Custom form action */
+ 	protected $u_action;
+ 
+@@ -63,11 +66,12 @@ class admin_controller implements admin_interface
+ 	* @param string 							$root_path
+ 	* @param string 							$php_ext
+ 	* @param phpbb\language\language			$language
++	* @param \phpbb\log\log						$log
+ 	*
+ 	* @return \david63\pmmonitor\controller\admin_controller
+ 	* @access public
+ 	*/
+-	public function __construct(\phpbb\config\config $config, \phpbb\db\driver\driver_interface $db, \phpbb\request\request $request, \phpbb\template\template $template, \phpbb\pagination $pagination, \phpbb\user $user, \phpbb\auth\auth $auth, $root_path, $php_ext, \phpbb\language\language $language)
++	public function __construct(\phpbb\config\config $config, \phpbb\db\driver\driver_interface $db, \phpbb\request\request $request, \phpbb\template\template $template, \phpbb\pagination $pagination, \phpbb\user $user, \phpbb\auth\auth $auth, $root_path, $php_ext, \phpbb\language\language $language, \phpbb\log\log $log)
+ 	{
+ 		$this->config			= $config;
+ 		$this->db  				= $db;
+@@ -79,6 +83,7 @@ class admin_controller implements admin_interface
+ 		$this->phpbb_root_path	= $root_path;
+ 		$this->phpEx			= $php_ext;
+ 		$this->language			= $language;
++		$this->log				= $log;
+ 	}
+ 
+ 	/**
+@@ -147,8 +152,7 @@ class admin_controller implements admin_interface
+ 				}
+ 
+ 				// Add option settings change action to the admin log
+-				$phpbb_log = $this->container->get('log');
+-				$phpbb_log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_PM_MONITOR');
++				$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_PM_MONITOR');
+ 			}
+ 			else
+ 			{
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\david63\\pmmonitor/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\david63\\pmmonitor/diff_full.tmp"
+new file mode 100644
+index 000000000..2cfc43dc9
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\david63\\pmmonitor/diff_full.tmp"
+@@ -0,0 +1,304 @@
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\david63\\pmmonitor/adm/style/pmmonitor.css" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\david63\\pmmonitor/adm/style/pmmonitor.css"
++index 1a92b2b82..fc063b8d0 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\david63\\pmmonitor/adm/style/pmmonitor.css"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\david63\\pmmonitor/adm/style/pmmonitor.css"
++@@ -1,3 +1,7 @@
+++/**
+++* pmmonitor.css
+++**/
+++
++ /* Content container styles
++ ----------------------------------------*/
++ .content {
++@@ -214,3 +218,22 @@ dl.thumbnail dt a:hover {
++ dl.thumbnail dt a:hover img {
++ 	border: 1px solid #d2d2d2;
++ }
+++
+++.version {
+++		border-radius: 15px;
+++	font-size: 1.00em;
+++		color: #000000;
+++	font-weight: bold;
+++		background: #3EED0E;
+++	text-align: center;
+++	display: inline-block;
+++	width: 50px;
+++}
+++
+++.version_name{
+++	font-size: 1.00em;
+++	text-align: left;
+++	font-weight: bold;
+++	color: #4A5A73;
+++	margin: 10px
+++}
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\david63\\pmmonitor/adm/style/pmmonitor.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\david63\\pmmonitor/adm/style/pmmonitor.html"
++index 430cfe035..41fad6c0e 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\david63\\pmmonitor/adm/style/pmmonitor.html"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\david63\\pmmonitor/adm/style/pmmonitor.html"
++@@ -4,8 +4,8 @@
++ <a name="maincontent"></a>
++ 
++ <h1>{{ lang('PM_MONITOR_READ') }}</h1>
++-{PM_MONITOR_VERSION}<br /><br />
++ <p>{{ lang('PM_MONITOR_READ_EXPLAIN') }}</p>
+++<span class="version_name">{{ lang('VERSION') }}{{ lang('COLON') }}</span><span class="version">{PM_MONITOR_VERSION}</span>
++ <hr />
++ 
++ <form id="pm_monitor" method="post" action="{U_ACTION}">
++@@ -28,14 +28,14 @@
++ 	<thead>
++ 		<tr>
++ 			<th style="width: 6%;">{{ lang('MARK') }}</th>
++-			<th style="width: 16%;">{{ lang('SUBJECT') }}</th>
++-			<th style="width: 16%;">{{ lang('SORT_FROM') }}</th>
++-			<th style="width: 15%;">{{ lang('TO') }}</th>
+++			<th style="width: 15%;">{{ lang('SUBJECT') }}</th>
+++			<th style="width: 15%;">{{ lang('SORT_FROM') }}</th>
+++			<th style="width: 14%;">{{ lang('SORT_TO') }}</th>
++ 			<th style="width: 11%;">{{ lang('BCC') }}</th>
++-			<th style="width: 1%;">&nbsp;</th>
+++			<th style="width: 9%;">{{ lang('IS_GROUP') }}</th>
++ 			<th style="width: 9%;">{{ lang('PM_BOX') }}</th>
++-			<th style="width: 14%;">{{ lang('AUTHOR_IP') }}</th>
++-			<th style="width: 12%;">{{ lang('DATE') }}</th>
+++			<th style="width: 10%;">{{ lang('AUTHOR_IP') }}</th>
+++			<th style="width: 10%;">{{ lang('DATE') }}</th>
++ 		</tr>
++ 	</thead>
++ 
++@@ -81,4 +81,4 @@
++ </form>
++ 
++ {% INCLUDEJS '@david63_pmmonitor/dropdown.js' %}
++-{% include 'overall_footer.html' %}
+++{% include 'overall_footer.html' %}
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\david63\\pmmonitor/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\david63\\pmmonitor/composer.json"
++index 9765ddc9c..ce186a268 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\david63\\pmmonitor/composer.json"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\david63\\pmmonitor/composer.json"
++@@ -13,17 +13,17 @@
++ 	"license": "GPL-2.0",
++ 	"authors": [{
++ 			"name": "David Wood",
++-			"username": "david63",
++ 			"role": "Developer"
++ 		}],
++ 	"require": {
++-        "php": ">=5.3.3",
+++        "php": ">=5.4,<7.1",
+++		"phpbb/phpbb": ">=3.2.0-RC1",
++         "composer/installers": "~1.0"
++     },
++ 	"extra": {
++ 		"display-name": "PM monitor",
++ 		"soft-require": {
++-			"phpbb/phpbb": ">=3.2.0-a1"
+++			"phpbb/phpbb": ">=3.2.0-RC1"
++       }
++ 	}
++ }
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\david63\\pmmonitor/config/services.yml" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\david63\\pmmonitor/config/services.yml"
++index 4d041f2e2..303acf69f 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\david63\\pmmonitor/config/services.yml"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\david63\\pmmonitor/config/services.yml"
++@@ -17,4 +17,5 @@ services:
++             - '@auth'
++             - '%core.root_path%'
++             - '%core.php_ext%'
++-            - '@language'			
+++            - '@language'
+++            - '@log'
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\david63\\pmmonitor/controller/admin_controller.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\david63\\pmmonitor/controller/admin_controller.php"
++index 652c65029..874fb5530 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\david63\\pmmonitor/controller/admin_controller.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\david63\\pmmonitor/controller/admin_controller.php"
++@@ -47,6 +47,9 @@ class admin_controller implements admin_interface
++ 	/** @var phpbb\language\language */
++ 	protected $language;
++ 
+++	/** @var \phpbb\log\log */
+++	protected $log;
+++
++ 	/** @var string Custom form action */
++ 	protected $u_action;
++ 
++@@ -63,11 +66,12 @@ class admin_controller implements admin_interface
++ 	* @param string 							$root_path
++ 	* @param string 							$php_ext
++ 	* @param phpbb\language\language			$language
+++	* @param \phpbb\log\log						$log
++ 	*
++ 	* @return \david63\pmmonitor\controller\admin_controller
++ 	* @access public
++ 	*/
++-	public function __construct(\phpbb\config\config $config, \phpbb\db\driver\driver_interface $db, \phpbb\request\request $request, \phpbb\template\template $template, \phpbb\pagination $pagination, \phpbb\user $user, \phpbb\auth\auth $auth, $root_path, $php_ext, \phpbb\language\language $language)
+++	public function __construct(\phpbb\config\config $config, \phpbb\db\driver\driver_interface $db, \phpbb\request\request $request, \phpbb\template\template $template, \phpbb\pagination $pagination, \phpbb\user $user, \phpbb\auth\auth $auth, $root_path, $php_ext, \phpbb\language\language $language, \phpbb\log\log $log)
++ 	{
++ 		$this->config			= $config;
++ 		$this->db  				= $db;
++@@ -79,6 +83,7 @@ class admin_controller implements admin_interface
++ 		$this->phpbb_root_path	= $root_path;
++ 		$this->phpEx			= $php_ext;
++ 		$this->language			= $language;
+++		$this->log				= $log;
++ 	}
++ 
++ 	/**
++@@ -147,8 +152,7 @@ class admin_controller implements admin_interface
++ 				}
++ 
++ 				// Add option settings change action to the admin log
++-				$phpbb_log = $this->container->get('log');
++-				$phpbb_log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_PM_MONITOR');
+++				$this->log->add('admin', $this->user->data['user_id'], $this->user->ip, 'LOG_PM_MONITOR');
++ 			}
++ 			else
++ 			{
++@@ -223,7 +227,7 @@ class admin_controller implements admin_interface
++ 				'IS_GROUP'				=> (strstr($row['to_address'], 'g')) ? $this->language->lang('IS_GROUP') : '',
++ 				'LAST_VISIT_FROM'		=> $this->get_last_visit($row['author_id']),
++ 				'LAST_VISIT_TO'			=> ($row['to_address']) ? $this->get_last_visit($row['user_id'], $row['author_id']) : '',
++-				// Swapping ' for "is needed as request does not handle double quotes
+++				// Swapping ' for " is needed as request does not handle double quotes
++ 				'PM_ID'					=> str_replace('"', "'", json_encode(array('msg_ids' => $row['msg_id'], 'user_id' => $row['user_id'], 'folder_id' => $row['folder_id']))),
++ 				// Create a unique key for the js script
++ 				'PM_KEY'				=> $row['msg_id'] . $row['user_id'],
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\david63\\pmmonitor/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\david63\\pmmonitor/diff_full.tmp"
++new file mode 100644
++index 000000000..adac3e78a
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\david63\\pmmonitor/diff_full.tmp"
++@@ -0,0 +1,104 @@
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\david63\\pmmonitor/adm/style/pmmonitor.css" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\david63\\pmmonitor/adm/style/pmmonitor.css"
+++index 1a92b2b82..fc063b8d0 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\david63\\pmmonitor/adm/style/pmmonitor.css"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\david63\\pmmonitor/adm/style/pmmonitor.css"
+++@@ -1,3 +1,7 @@
++++/**
++++* pmmonitor.css
++++**/
++++
+++ /* Content container styles
+++ ----------------------------------------*/
+++ .content {
+++@@ -214,3 +218,22 @@ dl.thumbnail dt a:hover {
+++ dl.thumbnail dt a:hover img {
+++ 	border: 1px solid #d2d2d2;
+++ }
++++
++++.version {
++++		border-radius: 15px;
++++	font-size: 1.00em;
++++		color: #000000;
++++	font-weight: bold;
++++		background: #3EED0E;
++++	text-align: center;
++++	display: inline-block;
++++	width: 50px;
++++}
++++
++++.version_name{
++++	font-size: 1.00em;
++++	text-align: left;
++++	font-weight: bold;
++++	color: #4A5A73;
++++	margin: 10px
++++}
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\david63\\pmmonitor/adm/style/pmmonitor.html" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\david63\\pmmonitor/adm/style/pmmonitor.html"
+++index 430cfe035..41fad6c0e 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\david63\\pmmonitor/adm/style/pmmonitor.html"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\david63\\pmmonitor/adm/style/pmmonitor.html"
+++@@ -4,8 +4,8 @@
+++ <a name="maincontent"></a>
+++ 
+++ <h1>{{ lang('PM_MONITOR_READ') }}</h1>
+++-{PM_MONITOR_VERSION}<br /><br />
+++ <p>{{ lang('PM_MONITOR_READ_EXPLAIN') }}</p>
++++<span class="version_name">{{ lang('VERSION') }}{{ lang('COLON') }}</span><span class="version">{PM_MONITOR_VERSION}</span>
+++ <hr />
+++ 
+++ <form id="pm_monitor" method="post" action="{U_ACTION}">
+++@@ -28,14 +28,14 @@
+++ 	<thead>
+++ 		<tr>
+++ 			<th style="width: 6%;">{{ lang('MARK') }}</th>
+++-			<th style="width: 16%;">{{ lang('SUBJECT') }}</th>
+++-			<th style="width: 16%;">{{ lang('SORT_FROM') }}</th>
+++-			<th style="width: 15%;">{{ lang('TO') }}</th>
++++			<th style="width: 15%;">{{ lang('SUBJECT') }}</th>
++++			<th style="width: 15%;">{{ lang('SORT_FROM') }}</th>
++++			<th style="width: 14%;">{{ lang('SORT_TO') }}</th>
+++ 			<th style="width: 11%;">{{ lang('BCC') }}</th>
+++-			<th style="width: 1%;">&nbsp;</th>
++++			<th style="width: 9%;">{{ lang('IS_GROUP') }}</th>
+++ 			<th style="width: 9%;">{{ lang('PM_BOX') }}</th>
+++-			<th style="width: 14%;">{{ lang('AUTHOR_IP') }}</th>
+++-			<th style="width: 12%;">{{ lang('DATE') }}</th>
++++			<th style="width: 10%;">{{ lang('AUTHOR_IP') }}</th>
++++			<th style="width: 10%;">{{ lang('DATE') }}</th>
+++ 		</tr>
+++ 	</thead>
+++ 
+++@@ -81,4 +81,4 @@
+++ </form>
+++ 
+++ {% INCLUDEJS '@david63_pmmonitor/dropdown.js' %}
+++-{% include 'overall_footer.html' %}
++++{% include 'overall_footer.html' %}
+++\ No newline at end of file
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\david63\\pmmonitor/composer.json" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\david63\\pmmonitor/composer.json"
+++index 9765ddc9c..ce186a268 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\david63\\pmmonitor/composer.json"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\david63\\pmmonitor/composer.json"
+++@@ -13,17 +13,17 @@
+++ 	"license": "GPL-2.0",
+++ 	"authors": [{
+++ 			"name": "David Wood",
+++-			"username": "david63",
+++ 			"role": "Developer"
+++ 		}],
+++ 	"require": {
+++-        "php": ">=5.3.3",
++++        "php": ">=5.4,<7.1",
++++		"phpbb/phpbb": ">=3.2.0-RC1",
+++         "composer/installers": "~1.0"
+++     },
+++ 	"extra": {
+++ 		"display-name": "PM monitor",
+++ 		"soft-require": {
+++-			"phpbb/phpbb": ">=3.2.0-a1"
++++			"phpbb/phpbb": ">=3.2.0-RC1"
+++       }
+++ 	}
+++ }
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\david63\\pmmonitor/config/services.yml" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\david63\\pmmonitor/config/services.yml"
+++index 4d041
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\david63\\pmmonitor/language/en/acp_pmmonitor.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\david63\\pmmonitor/language/en/acp_pmmonitor.php"
++index 6344bb502..da8313747 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\david63\\pmmonitor/language/en/acp_pmmonitor.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\david63\\pmmonitor/language/en/acp_pmmonitor.php"
++@@ -65,4 +65,6 @@ $lang = array_merge($lang, array(
++ 	'SORT_FROM'					=> 'From',
++ 	'SORT_PM_BOX'				=> 'PM box',
++ 	'SORT_TO'					=> 'To',
+++
+++	'VERSION'					=> 'Version',
++ ));
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub
\ No newline at end of file
diff --git "[ORIGINAL]/david63\\pmmonitor/language/en/acp_pmmonitor.php" "[FORUM_EXT]/david63\\pmmonitor/language/en/acp_pmmonitor.php"
--- "[ORIGINAL]/david63\\pmmonitor/language/en/acp_pmmonitor.php"
+++ "[FORUM_EXT]/david63\\pmmonitor/language/en/acp_pmmonitor.php"
@@ -65,4 +65,6 @@ $lang = array_merge($lang, array(
 	'SORT_FROM'					=> 'From',
 	'SORT_PM_BOX'				=> 'PM box',
 	'SORT_TO'					=> 'To',
+
+	'VERSION'					=> 'Version',
 ));
diff --git "[ORIGINAL]/david63\\pmmonitor/language/en/permissions_pmmonitor.php" "[FORUM_EXT]/david63\\pmmonitor/language/en/permissions_pmmonitor.php"
--- "[ORIGINAL]/david63\\pmmonitor/language/en/permissions_pmmonitor.php"
+++ "[FORUM_EXT]/david63\\pmmonitor/language/en/permissions_pmmonitor.php"
@@ -39,5 +39,3 @@ if (empty($lang) || !is_array($lang))
 $lang = array_merge($lang, array(
 	'ACL_A_COMMS_PM_MANAGE'		=> 'Can manage PM monitor',
 ));
\ No newline at end of file
-
-?>
\ No newline at end of file
```
