Existem diferencas reais no codigo ou texto. Diferencas de formatacao (espacos, tabs) foram ignoradas abaixo.

```diff
diff --git "[ORIGINAL]/sitesplat\\bbcore_dbxtra/bbcore.php" "[FORUM_EXT]/sitesplat\\bbcore_dbxtra/bbcore.php"
--- "[ORIGINAL]/sitesplat\\bbcore_dbxtra/bbcore.php"
+++ "[FORUM_EXT]/sitesplat\\bbcore_dbxtra/bbcore.php"
@@ -1,5 +1,4 @@
 <?php
-
 /**
  * BBCore DB Addon
  * @copyright (c) 2021 SiteSplat. All rights reserved.
@@ -7,147 +6,4 @@
  */
 
 namespace sitesplat\bbcore_dbxtra;
-
-class bbcore
-{
-	protected $cfg, $sess, $swmch, $topics, $posts, $pm, $dbname, $dbsize, $idbopt;
-	protected $table_engines = [];
-	protected $optisam_tables = [];
-	protected $optinno_tables = [];
-	protected $isam_size = 0;
-	protected $inno_size = 0;
-	protected $max_isam_size = 500;
-	protected $max_inno_size = 750;
-	public function __construct()
-	{
-		global $db;
-		$this->cfg = CONFIG_TABLE;
-		$this->sess = SESSIONS_TABLE;
-		$this->swmch = SEARCH_WORDMATCH_TABLE;
-		$this->topic = TOPICS_TABLE;
-		$this->post = POSTS_TABLE;
-		$this->pm = PRIVMSGS_TABLE;
-		$this->dbname = $db->get_db_name();
-		\sitesplat\add_filter('bbcore_dash_handle', [$this, 'dbxtra_handle'], 1);
-		\sitesplat\add_filter('bbcore_dash_display', [$this, 'dbxtra_form'], 1);
-	}
-	public function dbxtra_handle($msg_ary)
-	{
-		global $db, $language, $request, $user;
-		if ($request->is_set_post('dbxtra')) {
-			$this->get_table_data();
-			@set_time_limit(0);
-			if ($request->is_set_post('dbxtra_optisam')) {
-				if (count($this->optisam_tables) && $this->isam_size < $this->max_isam_size) {
-					$result = $db->sql_query('OPTIMIZE TABLE ' . implode(',', $this->optisam_tables));
-					$db->sql_freeresult($result);
-				}
-				$msg_ary[1] = $language->lang('DBXTRA_OK_OPTIMIZE');
-			}
-			if ($request->is_set_post('dbxtra_optinno')) {
-				if (count($this->optinno_tables) && $this->inno_size < $this->max_inno_size) {
-					$result = $db->sql_query('OPTIMIZE TABLE ' . implode(',', $this->optinno_tables));
-					$db->sql_freeresult($result);
-				}
-				$msg_ary[1] = $language->lang('DBXTRA_OK_OPTIMIZE');
-			} else if ($request->is_set_post('dbxtra_analyze')) {
-				$analyze = implode(',', array_keys($this->table_engines));
-				$result = $db->sql_query("ANALYZE TABLE $analyze");
-				$db->sql_freeresult($result);
-				$msg_ary[1] = $language->lang('DBXTRA_OK_ANALYZE');
-			} else if ($request->is_set_post('dbxtra_download')) {
-				global $phpbb_container;
-				$time = time();
-				include(__DIR__ . '/phpbbsux.php');
-				$filename = "{$this->dbname}_{$time}";
-				$extractor = $phpbb_container->get('dbal.extractor');
-				$extractor->init_extractor('gzip', $filename, $time, true);
-				$tables = array_keys($this->table_engines);
-				foreach ($tables as $table) {
-					@set_time_limit(0);
-					$extractor->write_table($table);
-					$extractor->write_data($table);
-				}
-				$extractor->write_end();
-				exit;
-			} else if ($request->is_set_post('dbxtra_innodb')) {
-				if ($this->table_engines[$this->sess] != 'innodb') {
-					$db->sql_query("TRUNCATE TABLE {$this->sess}");
-					$db->sql_query("ALTER TABLE {$this->sess} ENGINE = INNODB");
-					$db->sql_query("INSERT INTO {$this->sess} " . $db->sql_build_array('INSERT', ['session_id' => (string) $user->session_id, 'session_user_id' => (int) $user->data['user_id'], 'session_start' => (int) $user->data['session_start'], 'session_time' => (int) $user->time_now, 'session_browser' => (string) trim(substr($user->browser, 0, 149)), 'session_ip' => (string) $user->ip, 'session_autologin' => (int) $user->data['session_autologin'], 'session_admin' => 1, 'session_viewonline' => (int) $user->data['session_viewonline'],]));
-				}
-				if ($this->table_engines[$this->cfg] != 'innodb') {
-					$db->sql_query("ALTER TABLE {$this->cfg} ENGINE = INNODB");
-				}
-				$msg_ary[1] = $language->lang('DBXTRA_OK_INNODB');
-			}
-		}
-		return $msg_ary;
-	}
-	public function dbxtra_form($html)
-	{
-		global $db, $language;
-		$result = $db->sql_query("SELECT ENGINE FROM INFORMATION_SCHEMA.ENGINES WHERE LOWER(ENGINE) = 'innodb' AND LOWER(SUPPORT) IN ('yes','default')");
-		$innodb = $db->sql_fetchfield('ENGINE');
-		$db->sql_freeresult($result);
-		$no_inno = $no_isam = '';
-		$this->get_table_data();
-		if ($innodb && $this->table_engines[$this->cfg] != 'innodb') {
-			$no_inno .= sprintf($language->lang('DBXTRA_NO_INNODB'), $this->cfg);
-		}
-		if ($innodb && $this->table_engines[$this->sess] != 'innodb') {
-			$no_inno .= sprintf($language->lang('DBXTRA_NO_INNODB'), $this->sess);
-		}
-		if ($no_inno) {
-			$no_inno = "<div class=\"dbbar2\"></div>$no_inno" . '<div class="dboption dbbutton"><input type="submit" name="dbxtra_innodb" class="submit-button" value="' . $language->lang('DBXTRA_FIX_INNODB') . '" /></div>';
-		}
-		if ($this->table_engines[$this->topic] != 'myisam') {
-			$no_isam .= sprintf($language->lang('DBXTRA_NO_MYISAM'), $this->topic);
-		}
-		if ($this->table_engines[$this->post] != 'myisam') {
-			$no_isam .= sprintf($language->lang('DBXTRA_NO_MYISAM'), $this->post);
-		}
-		if ($this->table_engines[$this->pm] != 'myisam') {
-			$no_isam .= sprintf($language->lang('DBXTRA_NO_MYISAM'), $this->pm);
-		}
-		if ($no_isam) {
-			$no_isam = "<div class=\"dbbar2\"></div>$no_isam" . '<div class="dboption">' . $language->lang('DBXTRA_FIX_MYISAM') . '</div>';
-		}
-		$optisam = (count($this->optisam_tables) && $this->isam_size < $this->max_isam_size) ? '<input type="submit" name="dbxtra_optisam" class="submit-button" value="' . $language->lang('DBXTRA_BTN_OPTISAM') . '" />' : '';
-		$optinno = (count($this->optinno_tables) && $this->inno_size < $this->max_inno_size) ? '<input type="submit" name="dbxtra_optinno" class="submit-button" value="' . $language->lang('DBXTRA_BTN_OPTINNO') . '" />' : '';
-		$optimize = ($optisam || $optinno) ? '<div class="dboption">' . $language->lang('DBXTRA_OPTIMIZE') . '</div><div class="dboption dbbutton">' . " $optisam $optinno </div>" : '';
-		return $html . ' <style> #dbxtra *{color:#333;line-height:20px;font-family:Helvetica,Arial,sans-serif;font-size:14px} #dbxtra .dbtitle{margin:0 0 15px;color:#000;font-size:20px} #dbxtra .dboption{margin-top:10px} #dbxtra .dbbutton{padding-bottom:4px} #dbxtra .dbbar2{margin:15px 0;height:2px;background-color:#ddd} #dbxtra .dbbar12{margin:15px 0;height:12px;background-color:#ddd} #dbxtra .submit-button{cursor:pointer;padding:0 8px;height:30px;line-height:1;background-color:#379;color:#fff;border:none;font-size:16px;font-weight:bold} #dbxtra .submit-button:hover{background-color:#48a} </style> <div id="dbxtra"> <div class="dbtitle">' . $language->lang('DBXTRA_TITLE') . '</div> <div class="dboption">' . $language->lang('DBXTRA_ENGINE_DESC') . '</div>' . $no_inno . $no_isam . ' <div class="dbbar12"></div>' . $optimize . ' <div class="dboption">' . $language->lang('DBXTRA_ANALYZE') . '</div><div class="dboption dbbutton"><input type="submit" name="dbxtra_analyze" class="submit-button" value="' . $language->lang('DBXTRA_BTN_ANALYZE') . '" /></div> <div class="dboption">' . $language->lang('DBXTRA_DOWNLOAD') . '</div><div class="dboption dbbutton"><input type="submit" name="dbxtra_download" class="submit-button" value="' . $language->lang('DBXTRA_BTN_DOWNLOAD') . '" /></div> <input type="hidden" name="dbxtra" value="dbxtra" /> </div>';
-	}
-	private function get_table_data()
-	{
-		if (!empty($this->table_engines)) {
-			return;
-		}
-		global $db;
-		$result = $db->sql_query("SELECT @@global.innodb_file_per_table AS idbopt");
-		$this->idbopt = (int) $db->sql_fetchfield('idbopt');
-		$db->sql_freeresult($result);
-		$result = $db->sql_query("SELECT SUM(DATA_LENGTH) AS dta, SUM(INDEX_LENGTH) as idx FROM information_schema.TABLES WHERE TABLE_SCHEMA = '{$this->dbname}' AND ENGINE IN ('MyISAM','InnoDB','Aria')");
-		$row = $db->sql_fetchrow($result);
-		$db->sql_freeresult($result);
-		$this->dbsize = (int) ceil(($row['dta'] + $row['idx']) / 1048576);
-		$result = $db->sql_query("SELECT TABLE_NAME, LOWER(ENGINE) AS engn, DATA_LENGTH + INDEX_LENGTH AS tsize, DATA_FREE AS dfree FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '{$this->dbname}'");
-		while ($row = $db->sql_fetchrow($result)) {
-			$name = $row['TABLE_NAME'];
-			$engine = $row['engn'];
-			$dfree = (int) $row['dfree'];
-			$tsize = (int) $row['tsize'];
-			$this->table_engines[$name] = $engine;
-			if ($engine == 'innodb' && $this->idbopt && $name != $this->swmch) {
-				$this->optinno_tables[] = $name;
-				$this->inno_size += $tsize;
-			} else if (($engine == 'myisam' || $engine == 'aria') && $dfree > 0 && $name != $this->swmch) {
-				$this->optisam_tables[] = $name;
-				$this->isam_size += $tsize;
-			}
-			$this->isam_size = (int) ceil($this->isam_size / 1048576);
-			$this->inno_size = (int) ceil($this->inno_size / 1048576);
-		}
-		$db->sql_freeresult($result);
-	}
-}
+class bbcore { protected $cfg, $sess, $swmch, $topics, $posts, $pm, $dbname, $dbsize, $idbopt; protected $table_engines = []; protected $optisam_tables = []; protected $optinno_tables = []; protected $isam_size = 0; protected $inno_size = 0; protected $max_isam_size = 500; protected $max_inno_size = 750; public function __construct() { global $db; $this->cfg = CONFIG_TABLE; $this->sess = SESSIONS_TABLE; $this->swmch = SEARCH_WORDMATCH_TABLE; $this->topic = TOPICS_TABLE; $this->post = POSTS_TABLE; $this->pm = PRIVMSGS_TABLE; $this->dbname = $db->get_db_name(); \sitesplat\add_filter('bbcore_dash_handle', [$this, 'dbxtra_handle'], 1); \sitesplat\add_filter('bbcore_dash_display', [$this, 'dbxtra_form'], 1); } public function dbxtra_handle($msg_ary) { global $db, $language, $request, $user; if ($request->is_set_post('dbxtra')) { $this->get_table_data(); @set_time_limit(0); if ($request->is_set_post('dbxtra_optisam')) { if (count($this->optisam_tables) && $this->isam_size < $this->max_isam_size) { $result = $db->sql_query('OPTIMIZE TABLE ' . implode(',', $this->optisam_tables)); $db->sql_freeresult($result); } $msg_ary[1] = $language->lang('DBXTRA_OK_OPTIMIZE'); } if ($request->is_set_post('dbxtra_optinno')) { if (count($this->optinno_tables) && $this->inno_size < $this->max_inno_size) { $result = $db->sql_query('OPTIMIZE TABLE ' . implode(',', $this->optinno_tables)); $db->sql_freeresult($result); } $msg_ary[1] = $language->lang('DBXTRA_OK_OPTIMIZE'); } else if ($request->is_set_post('dbxtra_analyze')) { $analyze = implode(',', array_keys($this->table_engines)); $result = $db->sql_query("ANALYZE TABLE $analyze"); $db->sql_freeresult($result); $msg_ary[1] = $language->lang('DBXTRA_OK_ANALYZE'); } else if ($request->is_set_post('dbxtra_download')) { global $phpbb_container; $time = time(); include(__DIR__ . '/phpbbsux.php'); $filename = "{$this->dbname}_{$time}"; $extractor = $phpbb_container->get('dbal.extractor'); $extractor->init_extractor('gzip', $filename, $time, true); $tables = array_keys($this->table_engines); foreach ($tables as $table) { @set_time_limit(0); $extractor->write_table($table); $extractor->write_data($table); } $extractor->write_end(); exit; } else if ($request->is_set_post('dbxtra_innodb')) { if ($this->table_engines[$this->sess] != 'innodb') { $db->sql_query("TRUNCATE TABLE {$this->sess}"); $db->sql_query("ALTER TABLE {$this->sess} ENGINE = INNODB"); $db->sql_query("INSERT INTO {$this->sess} " . $db->sql_build_array('INSERT', [ 'session_id' => (string) $user->session_id, 'session_user_id' => (int) $user->data['user_id'], 'session_start' => (int) $user->data['session_start'], 'session_time' => (int) $user->time_now, 'session_browser' => (string) trim(substr($user->browser, 0, 149)), 'session_ip' => (string) $user->ip, 'session_autologin' => (int) $user->data['session_autologin'], 'session_admin' => 1, 'session_viewonline' => (int) $user->data['session_viewonline'], ])); } if ($this->table_engines[$this->cfg] != 'innodb') { $db->sql_query("ALTER TABLE {$this->cfg} ENGINE = INNODB"); } $msg_ary[1] = $language->lang('DBXTRA_OK_INNODB'); } } return $msg_ary; } public function dbxtra_form($html) { global $db, $language; $result = $db->sql_query("SELECT ENGINE FROM INFORMATION_SCHEMA.ENGINES WHERE LOWER(ENGINE) = 'innodb' AND LOWER(SUPPORT) IN ('yes','default')"); $innodb = $db->sql_fetchfield('ENGINE'); $db->sql_freeresult($result); $no_inno = $no_isam = ''; $this->get_table_data(); if ($innodb && $this->table_engines[$this->cfg] != 'innodb') { $no_inno .= sprintf($language->lang('DBXTRA_NO_INNODB'), $this->cfg); } if ($innodb && $this->table_engines[$this->sess] != 'innodb') { $no_inno .= sprintf($language->lang('DBXTRA_NO_INNODB'), $this->sess); } if ($no_inno) { $no_inno = "<div class=\"dbbar2\"></div>$no_inno" . '<div class="dboption dbbutton"><input type="submit" name="dbxtra_innodb" class="submit-button" value="' . $language->lang('DBXTRA_FIX_INNODB') . '" /></div>'; } if ($this->table_engines[$this->topic] != 'myisam') { $no_isam .= sprintf($language->lang('DBXTRA_NO_MYISAM'), $this->topic); } if ($this->table_engines[$this->post] != 'myisam') { $no_isam .= sprintf($language->lang('DBXTRA_NO_MYISAM'), $this->post); } if ($this->table_engines[$this->pm] != 'myisam') { $no_isam .= sprintf($language->lang('DBXTRA_NO_MYISAM'), $this->pm); } if ($no_isam) { $no_isam = "<div class=\"dbbar2\"></div>$no_isam" . '<div class="dboption">' . $language->lang('DBXTRA_FIX_MYISAM') . '</div>'; } $optisam = (count($this->optisam_tables) && $this->isam_size < $this->max_isam_size) ? '<input type="submit" name="dbxtra_optisam" class="submit-button" value="' . $language->lang('DBXTRA_BTN_OPTISAM') . '" />' : ''; $optinno = (count($this->optinno_tables) && $this->inno_size < $this->max_inno_size) ? '<input type="submit" name="dbxtra_optinno" class="submit-button" value="' . $language->lang('DBXTRA_BTN_OPTINNO') . '" />' : ''; $optimize = ($optisam || $optinno) ? '<div class="dboption">' . $language->lang('DBXTRA_OPTIMIZE') . '</div><div class="dboption dbbutton">' . " $optisam $optinno </div>" : ''; return $html . ' <style> #dbxtra *{color:#333;line-height:20px;font-family:Helvetica,Arial,sans-serif;font-size:14px} #dbxtra .dbtitle{margin:0 0 15px;color:#000;font-size:20px} #dbxtra .dboption{margin-top:10px} #dbxtra .dbbutton{padding-bottom:4px} #dbxtra .dbbar2{margin:15px 0;height:2px;background-color:#ddd} #dbxtra .dbbar12{margin:15px 0;height:12px;background-color:#ddd} #dbxtra .submit-button{cursor:pointer;padding:0 8px;height:30px;line-height:1;background-color:#379;color:#fff;border:none;font-size:16px;font-weight:bold} #dbxtra .submit-button:hover{background-color:#48a} </style> <div id="dbxtra"> <div class="dbtitle">' . $language->lang('DBXTRA_TITLE') . '</div> <div class="dboption">' . $language->lang('DBXTRA_ENGINE_DESC') . '</div>' . $no_inno . $no_isam . ' <div class="dbbar12"></div>' . $optimize . ' <div class="dboption">' . $language->lang('DBXTRA_ANALYZE') . '</div><div class="dboption dbbutton"><input type="submit" name="dbxtra_analyze" class="submit-button" value="' . $language->lang('DBXTRA_BTN_ANALYZE') . '" /></div> <div class="dboption">' . $language->lang('DBXTRA_DOWNLOAD') . '</div><div class="dboption dbbutton"><input type="submit" name="dbxtra_download" class="submit-button" value="' . $language->lang('DBXTRA_BTN_DOWNLOAD') . '" /></div> <input type="hidden" name="dbxtra" value="dbxtra" /> </div>'; } private function get_table_data() { if (!empty($this->table_engines)) {return;} global $db; $result = $db->sql_query("SELECT @@global.innodb_file_per_table AS idbopt"); $this->idbopt = (int) $db->sql_fetchfield('idbopt'); $db->sql_freeresult($result); $result = $db->sql_query("SELECT SUM(DATA_LENGTH) AS dta, SUM(INDEX_LENGTH) as idx FROM information_schema.TABLES WHERE TABLE_SCHEMA = '{$this->dbname}' AND ENGINE IN ('MyISAM','InnoDB','Aria')"); $row = $db->sql_fetchrow($result); $db->sql_freeresult($result); $this->dbsize = (int) ceil(($row['dta'] + $row['idx']) / 1048576); $result = $db->sql_query("SELECT TABLE_NAME, LOWER(ENGINE) AS engn, DATA_LENGTH + INDEX_LENGTH AS tsize, DATA_FREE AS dfree FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '{$this->dbname}'"); while ($row = $db->sql_fetchrow($result)) { $name = $row['TABLE_NAME']; $engine = $row['engn']; $dfree = (int) $row['dfree']; $tsize = (int) $row['tsize']; $this->table_engines[$name] = $engine; if ($engine == 'innodb' && $this->idbopt && $name != $this->swmch) { $this->optinno_tables[] = $name; $this->inno_size += $tsize; } else if (($engine == 'myisam' || $engine == 'aria') && $dfree > 0 && $name != $this->swmch) { $this->optisam_tables[] = $name; $this->isam_size += $tsize; } $this->isam_size = (int) ceil($this->isam_size / 1048576); $this->inno_size = (int) ceil($this->inno_size / 1048576); } $db->sql_freeresult($result); } }
\ No newline at end of file
diff --git "[FORUM_EXT]/sitesplat\\bbcore_dbxtra/diff_full.tmp" "[FORUM_EXT]/sitesplat\\bbcore_dbxtra/diff_full.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\bbcore_dbxtra/diff_full.tmp"
@@ -0,0 +1,389 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbcore_dbxtra/bbcore.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbcore_dbxtra/bbcore.php"
+index a165a2f42..4cccc72fc 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbcore_dbxtra/bbcore.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbcore_dbxtra/bbcore.php"
+@@ -1,5 +1,4 @@
+ <?php
+-
+ /**
+  * BBCore DB Addon
+  * @copyright (c) 2021 SiteSplat. All rights reserved.
+@@ -7,147 +6,4 @@
+  */
+ 
+ namespace sitesplat\bbcore_dbxtra;
+-
+-class bbcore
+-{
+-	protected $cfg, $sess, $swmch, $topics, $posts, $pm, $dbname, $dbsize, $idbopt;
+-	protected $table_engines = [];
+-	protected $optisam_tables = [];
+-	protected $optinno_tables = [];
+-	protected $isam_size = 0;
+-	protected $inno_size = 0;
+-	protected $max_isam_size = 500;
+-	protected $max_inno_size = 750;
+-	public function __construct()
+-	{
+-		global $db;
+-		$this->cfg = CONFIG_TABLE;
+-		$this->sess = SESSIONS_TABLE;
+-		$this->swmch = SEARCH_WORDMATCH_TABLE;
+-		$this->topic = TOPICS_TABLE;
+-		$this->post = POSTS_TABLE;
+-		$this->pm = PRIVMSGS_TABLE;
+-		$this->dbname = $db->get_db_name();
+-		\sitesplat\add_filter('bbcore_dash_handle', [$this, 'dbxtra_handle'], 1);
+-		\sitesplat\add_filter('bbcore_dash_display', [$this, 'dbxtra_form'], 1);
+-	}
+-	public function dbxtra_handle($msg_ary)
+-	{
+-		global $db, $language, $request, $user;
+-		if ($request->is_set_post('dbxtra')) {
+-			$this->get_table_data();
+-			@set_time_limit(0);
+-			if ($request->is_set_post('dbxtra_optisam')) {
+-				if (count($this->optisam_tables) && $this->isam_size < $this->max_isam_size) {
+-					$result = $db->sql_query('OPTIMIZE TABLE ' . implode(',', $this->optisam_tables));
+-					$db->sql_freeresult($result);
+-				}
+-				$msg_ary[1] = $language->lang('DBXTRA_OK_OPTIMIZE');
+-			}
+-			if ($request->is_set_post('dbxtra_optinno')) {
+-				if (count($this->optinno_tables) && $this->inno_size < $this->max_inno_size) {
+-					$result = $db->sql_query('OPTIMIZE TABLE ' . implode(',', $this->optinno_tables));
+-					$db->sql_freeresult($result);
+-				}
+-				$msg_ary[1] = $language->lang('DBXTRA_OK_OPTIMIZE');
+-			} else if ($request->is_set_post('dbxtra_analyze')) {
+-				$analyze = implode(',', array_keys($this->table_engines));
+-				$result = $db->sql_query("ANALYZE TABLE $analyze");
+-				$db->sql_freeresult($result);
+-				$msg_ary[1] = $language->lang('DBXTRA_OK_ANALYZE');
+-			} else if ($request->is_set_post('dbxtra_download')) {
+-				global $phpbb_container;
+-				$time = time();
+-				include(__DIR__ . '/phpbbsux.php');
+-				$filename = "{$this->dbname}_{$time}";
+-				$extractor = $phpbb_container->get('dbal.extractor');
+-				$extractor->init_extractor('gzip', $filename, $time, true);
+-				$tables = array_keys($this->table_engines);
+-				foreach ($tables as $table) {
+-					@set_time_limit(0);
+-					$extractor->write_table($table);
+-					$extractor->write_data($table);
+-				}
+-				$extractor->write_end();
+-				exit;
+-			} else if ($request->is_set_post('dbxtra_innodb')) {
+-				if ($this->table_engines[$this->sess] != 'innodb') {
+-					$db->sql_query("TRUNCATE TABLE {$this->sess}");
+-					$db->sql_query("ALTER TABLE {$this->sess} ENGINE = INNODB");
+-					$db->sql_query("INSERT INTO {$this->sess} " . $db->sql_build_array('INSERT', ['session_id' => (string) $user->session_id, 'session_user_id' => (int) $user->data['user_id'], 'session_start' => (int) $user->data['session_start'], 'session_time' => (int) $user->time_now, 'session_browser' => (string) trim(substr($user->browser, 0, 149)), 'session_ip' => (string) $user->ip, 'session_autologin' => (int) $user->data['session_autologin'], 'session_admin' => 1, 'session_viewonline' => (int) $user->data['session_viewonline'],]));
+-				}
+-				if ($this->table_engines[$this->cfg] != 'innodb') {
+-					$db->sql_query("ALTER TABLE {$this->cfg} ENGINE = INNODB");
+-				}
+-				$msg_ary[1] = $language->lang('DBXTRA_OK_INNODB');
+-			}
+-		}
+-		return $msg_ary;
+-	}
+-	public function dbxtra_form($html)
+-	{
+-		global $db, $language;
+-		$result = $db->sql_query("SELECT ENGINE FROM INFORMATION_SCHEMA.ENGINES WHERE LOWER(ENGINE) = 'innodb' AND LOWER(SUPPORT) IN ('yes','default')");
+-		$innodb = $db->sql_fetchfield('ENGINE');
+-		$db->sql_freeresult($result);
+-		$no_inno = $no_isam = '';
+-		$this->get_table_data();
+-		if ($innodb && $this->table_engines[$this->cfg] != 'innodb') {
+-			$no_inno .= sprintf($language->lang('DBXTRA_NO_INNODB'), $this->cfg);
+-		}
+-		if ($innodb && $this->table_engines[$this->sess] != 'innodb') {
+-			$no_inno .= sprintf($language->lang('DBXTRA_NO_INNODB'), $this->sess);
+-		}
+-		if ($no_inno) {
+-			$no_inno = "<div class=\"dbbar2\"></div>$no_inno" . '<div class="dboption dbbutton"><input type="submit" name="dbxtra_innodb" class="submit-button" value="' . $language->lang('DBXTRA_FIX_INNODB') . '" /></div>';
+-		}
+-		if ($this->table_engines[$this->topic] != 'myisam') {
+-			$no_isam .= sprintf($language->lang('DBXTRA_NO_MYISAM'), $this->topic);
+-		}
+-		if ($this->table_engines[$this->post] != 'myisam') {
+-			$no_isam .= sprintf($language->lang('DBXTRA_NO_MYISAM'), $this->post);
+-		}
+-		if ($this->table_engines[$this->pm] != 'myisam') {
+-			$no_isam .= sprintf($language->lang('DBXTRA_NO_MYISAM'), $this->pm);
+-		}
+-		if ($no_isam) {
+-			$no_isam = "<div class=\"dbbar2\"></div>$no_isam" . '<div class="dboption">' . $language->lang('DBXTRA_FIX_MYISAM') . '</div>';
+-		}
+-		$optisam = (count($this->optisam_tables) && $this->isam_size < $this->max_isam_size) ? '<input type="submit" name="dbxtra_optisam" class="submit-button" value="' . $language->lang('DBXTRA_BTN_OPTISAM') . '" />' : '';
+-		$optinno = (count($this->optinno_tables) && $this->inno_size < $this->max_inno_size) ? '<input type="submit" name="dbxtra_optinno" class="submit-button" value="' . $language->lang('DBXTRA_BTN_OPTINNO') . '" />' : '';
+-		$optimize = ($optisam || $optinno) ? '<div class="dboption">' . $language->lang('DBXTRA_OPTIMIZE') . '</div><div class="dboption dbbutton">' . " $optisam $optinno </div>" : '';
+-		return $html . ' <style> #dbxtra *{color:#333;line-height:20px;font-family:Helvetica,Arial,sans-serif;font-size:14px} #dbxtra .dbtitle{margin:0 0 15px;color:#000;font-size:20px} #dbxtra .dboption{margin-top:10px} #dbxtra .dbbutton{padding-bottom:4px} #dbxtra .dbbar2{margin:15px 0;height:2px;background-color:#ddd} #dbxtra .dbbar12{margin:15px 0;height:12px;background-color:#ddd} #dbxtra .submit-button{cursor:pointer;padding:0 8px;height:30px;line-height:1;background-color:#379;color:#fff;border:none;font-size:16px;font-weight:bold} #dbxtra .submit-button:hover{background-color:#48a} </style> <div id="dbxtra"> <div class="dbtitle">' . $language->lang('DBXTRA_TITLE') . '</div> <div class="dboption">' . $language->lang('DBXTRA_ENGINE_DESC') . '</div>' . $no_inno . $no_isam . ' <div class="dbbar12"></div>' . $optimize . ' <div class="dboption">' . $language->lang('DBXTRA_ANALYZE') . '</div><div class="dboption dbbutton"><input type="submit" name="dbxtra_analyze" class="submit-button" value="' . $language->lang('DBXTRA_BTN_ANALYZE') . '" /></div> <div class="dboption">' . $language->lang('DBXTRA_DOWNLOAD') . '</div><div class="dboption dbbutton"><input type="submit" name="dbxtra_download" class="submit-button" value="' . $language->lang('DBXTRA_BTN_DOWNLOAD') . '" /></div> <input type="hidden" name="dbxtra" value="dbxtra" /> </div>';
+-	}
+-	private function get_table_data()
+-	{
+-		if (!empty($this->table_engines)) {
+-			return;
+-		}
+-		global $db;
+-		$result = $db->sql_query("SELECT @@global.innodb_file_per_table AS idbopt");
+-		$this->idbopt = (int) $db->sql_fetchfield('idbopt');
+-		$db->sql_freeresult($result);
+-		$result = $db->sql_query("SELECT SUM(DATA_LENGTH) AS dta, SUM(INDEX_LENGTH) as idx FROM information_schema.TABLES WHERE TABLE_SCHEMA = '{$this->dbname}' AND ENGINE IN ('MyISAM','InnoDB','Aria')");
+-		$row = $db->sql_fetchrow($result);
+-		$db->sql_freeresult($result);
+-		$this->dbsize = (int) ceil(($row['dta'] + $row['idx']) / 1048576);
+-		$result = $db->sql_query("SELECT TABLE_NAME, LOWER(ENGINE) AS engn, DATA_LENGTH + INDEX_LENGTH AS tsize, DATA_FREE AS dfree FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '{$this->dbname}'");
+-		while ($row = $db->sql_fetchrow($result)) {
+-			$name = $row['TABLE_NAME'];
+-			$engine = $row['engn'];
+-			$dfree = (int) $row['dfree'];
+-			$tsize = (int) $row['tsize'];
+-			$this->table_engines[$name] = $engine;
+-			if ($engine == 'innodb' && $this->idbopt && $name != $this->swmch) {
+-				$this->optinno_tables[] = $name;
+-				$this->inno_size += $tsize;
+-			} else if (($engine == 'myisam' || $engine == 'aria') && $dfree > 0 && $name != $this->swmch) {
+-				$this->optisam_tables[] = $name;
+-				$this->isam_size += $tsize;
+-			}
+-			$this->isam_size = (int) ceil($this->isam_size / 1048576);
+-			$this->inno_size = (int) ceil($this->inno_size / 1048576);
+-		}
+-		$db->sql_freeresult($result);
+-	}
+-}
++class bbcore { protected $cfg, $sess, $swmch, $topics, $posts, $pm, $dbname, $dbsize, $idbopt; protected $table_engines = []; protected $optisam_tables = []; protected $optinno_tables = []; protected $isam_size = 0; protected $inno_size = 0; protected $max_isam_size = 500; protected $max_inno_size = 750; public function __construct() { global $db; $this->cfg = CONFIG_TABLE; $this->sess = SESSIONS_TABLE; $this->swmch = SEARCH_WORDMATCH_TABLE; $this->topic = TOPICS_TABLE; $this->post = POSTS_TABLE; $this->pm = PRIVMSGS_TABLE; $this->dbname = $db->get_db_name(); \sitesplat\add_filter('bbcore_dash_handle', [$this, 'dbxtra_handle'], 1); \sitesplat\add_filter('bbcore_dash_display', [$this, 'dbxtra_form'], 1); } public function dbxtra_handle($msg_ary) { global $db, $language, $request, $user; if ($request->is_set_post('dbxtra')) { $this->get_table_data(); @set_time_limit(0); if ($request->is_set_post('dbxtra_optisam')) { if (count($this->optisam_tables) && $this->isam_size < $this->max_isam_size) { $result = $db->sql_query('OPTIMIZE TABLE ' . implode(',', $this->optisam_tables)); $db->sql_freeresult($result); } $msg_ary[1] = $language->lang('DBXTRA_OK_OPTIMIZE'); } if ($request->is_set_post('dbxtra_optinno')) { if (count($this->optinno_tables) && $this->inno_size < $this->max_inno_size) { $result = $db->sql_query('OPTIMIZE TABLE ' . implode(',', $this->optinno_tables)); $db->sql_freeresult($result); } $msg_ary[1] = $language->lang('DBXTRA_OK_OPTIMIZE'); } else if ($request->is_set_post('dbxtra_analyze')) { $analyze = implode(',', array_keys($this->table_engines)); $result = $db->sql_query("ANALYZE TABLE $analyze"); $db->sql_freeresult($result); $msg_ary[1] = $language->lang('DBXTRA_OK_ANALYZE'); } else if ($request->is_set_post('dbxtra_download')) { global $phpbb_container; $time = time(); include(__DIR__ . '/phpbbsux.php'); $filename = "{$this->dbname}_{$time}"; $extractor = $phpbb_container->get('dbal.extractor'); $extractor->init_extractor('gzip', $filename, $time, true); $tables = array_keys($this->table_engines); foreach ($tables as $table) { @set_time_limit(0); $extractor->write_table($table); $extractor->write_data($table); } $extractor->write_end(); exit; } else if ($request->is_set_post('dbxtra_innodb')) { if ($this->table_engines[$this->sess] != 'innodb') { $db->sql_query("TRUNCATE TABLE {$this->sess}"); $db->sql_query("ALTER TABLE {$this->sess} ENGINE = INNODB"); $db->sql_query("INSERT INTO {$this->sess} " . $db->sql_build_array('INSERT', [ 'session_id' => (string) $user->session_id, 'session_user_id' => (int) $user->data['user_id'], 'session_start' => (int) $user->data['session_start'], 'session_time' => (int) $user->time_now, 'session_browser' => (string) trim(substr($user->browser, 0, 149)), 'session_ip' => (string) $user->ip, 'session_autologin' => (int) $user->data['session_autologin'], 'session_admin' => 1, 'session_viewonline' => (int) $user->data['session_viewonline'], ])); } if ($this->table_engines[$this->cfg] != 'innodb') { $db->sql_query("ALTER TABLE {$this->cfg} ENGINE = INNODB"); } $msg_ary[1] = $language->lang('DBXTRA_OK_INNODB'); } } return $msg_ary; } public function dbxtra_form($html) { global $db, $language; $result = $db->sql_query("SELECT ENGINE FROM INFORMATION_SCHEMA.ENGINES WHERE LOWER(ENGINE) = 'innodb' AND LOWER(SUPPORT) IN ('yes','default')"); $innodb = $db->sql_fetchfield('ENGINE'); $db->sql_freeresult($result); $no_inno = $no_isam = ''; $this->get_table_data(); if ($innodb && $this->table_engines[$this->cfg] != 'innodb') { $no_inno .= sprintf($language->lang('DBXTRA_NO_INNODB'), $this->cfg); } if ($innodb && $this->table_engines[$this->sess] != 'innodb') { $no_inno .= sprintf($language->lang('DBXTRA_NO_INNODB'), $this->sess); } if ($no_inno) { $no_inno = "<div class=\"dbbar2\"></div>$no_inno" . '<div class="dboption dbbutton"><input type="submit" name="dbxtra_innodb" class="submit-button" value="' . $language->lang('DBXTRA_FIX_INNODB') . '" /></div>'; } if ($this->table_engines[$this->topic] != 'myisam') { $no_isam .= sprintf($language->lang('DBXTRA_NO_MYISAM'), $this->topic); } if ($this->table_engines[$this->post] != 'myisam') { $no_isam .= sprintf($language->lang('DBXTRA_NO_MYISAM'), $this->post); } if ($this->table_engines[$this->pm] != 'myisam') { $no_isam .= sprintf($language->lang('DBXTRA_NO_MYISAM'), $this->pm); } if ($no_isam) { $no_isam = "<div class=\"dbbar2\"></div>$no_isam" . '<div class="dboption">' . $language->lang('DBXTRA_FIX_MYISAM') . '</div>'; } $optisam = (count($this->optisam_tables) && $this->isam_size < $this->max_isam_size) ? '<input type="submit" name="dbxtra_optisam" class="submit-button" value="' . $language->lang('DBXTRA_BTN_OPTISAM') . '" />' : ''; $optinno = (count($this->optinno_tables) && $this->inno_size < $this->max_inno_size) ? '<input type="submit" name="dbxtra_optinno" class="submit-button" value="' . $language->lang('DBXTRA_BTN_OPTINNO') . '" />' : ''; $optimize = ($optisam || $optinno) ? '<div class="dboption">' . $language->lang('DBXTRA_OPTIMIZE') . '</div><div class="dboption dbbutton">' . " $optisam $optinno </div>" : ''; return $html . ' <style> #dbxtra *{color:#333;line-height:20px;font-family:Helvetica,Arial,sans-serif;font-size:14px} #dbxtra .dbtitle{margin:0 0 15px;color:#000;font-size:20px} #dbxtra .dboption{margin-top:10px} #dbxtra .dbbutton{padding-bottom:4px} #dbxtra .dbbar2{margin:15px 0;height:2px;background-color:#ddd} #dbxtra .dbbar12{margin:15px 0;height:12px;background-color:#ddd} #dbxtra .submit-button{cursor:pointer;padding:0 8px;height:30px;line-height:1;background-color:#379;color:#fff;border:none;font-size:16px;font-weight:bold} #dbxtra .submit-button:hover{background-color:#48a} </style> <div id="dbxtra"> <div class="dbtitle">' . $language->lang('DBXTRA_TITLE') . '</div> <div class="dboption">' . $language->lang('DBXTRA_ENGINE_DESC') . '</div>' . $no_inno . $no_isam . ' <div class="dbbar12"></div>' . $optimize . ' <div class="dboption">' . $language->lang('DBXTRA_ANALYZE') . '</div><div class="dboption dbbutton"><input type="submit" name="dbxtra_analyze" class="submit-button" value="' . $language->lang('DBXTRA_BTN_ANALYZE') . '" /></div> <div class="dboption">' . $language->lang('DBXTRA_DOWNLOAD') . '</div><div class="dboption dbbutton"><input type="submit" name="dbxtra_download" class="submit-button" value="' . $language->lang('DBXTRA_BTN_DOWNLOAD') . '" /></div> <input type="hidden" name="dbxtra" value="dbxtra" /> </div>'; } private function get_table_data() { if (!empty($this->table_engines)) {return;} global $db; $result = $db->sql_query("SELECT @@global.innodb_file_per_table AS idbopt"); $this->idbopt = (int) $db->sql_fetchfield('idbopt'); $db->sql_freeresult($result); $result = $db->sql_query("SELECT SUM(DATA_LENGTH) AS dta, SUM(INDEX_LENGTH) as idx FROM information_schema.TABLES WHERE TABLE_SCHEMA = '{$this->dbname}' AND ENGINE IN ('MyISAM','InnoDB','Aria')"); $row = $db->sql_fetchrow($result); $db->sql_freeresult($result); $this->dbsize = (int) ceil(($row['dta'] + $row['idx']) / 1048576); $result = $db->sql_query("SELECT TABLE_NAME, LOWER(ENGINE) AS engn, DATA_LENGTH + INDEX_LENGTH AS tsize, DATA_FREE AS dfree FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '{$this->dbname}'"); while ($row = $db->sql_fetchrow($result)) { $name = $row['TABLE_NAME']; $engine = $row['engn']; $dfree = (int) $row['dfree']; $tsize = (int) $row['tsize']; $this->table_engines[$name] = $engine; if ($engine == 'innodb' && $this->idbopt && $name != $this->swmch) { $this->optinno_tables[] = $name; $this->inno_size += $tsize; } else if (($engine == 'myisam' || $engine == 'aria') && $dfree > 0 && $name != $this->swmch) { $this->optisam_tables[] = $name; $this->isam_size += $tsize; } $this->isam_size = (int) ceil($this->isam_size / 1048576); $this->inno_size = (int) ceil($this->inno_size / 1048576); } $db->sql_freeresult($result); } }
+\ No newline at end of file
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbcore_dbxtra/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbcore_dbxtra/diff_full.tmp"
+new file mode 100644
+index 000000000..bdc170120
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbcore_dbxtra/diff_full.tmp"
+@@ -0,0 +1,159 @@
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbcore_dbxtra/bbcore.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbcore_dbxtra/bbcore.php"
++index a165a2f42..4cccc72fc 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbcore_dbxtra/bbcore.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbcore_dbxtra/bbcore.php"
++@@ -1,5 +1,4 @@
++ <?php
++-
++ /**
++  * BBCore DB Addon
++  * @copyright (c) 2021 SiteSplat. All rights reserved.
++@@ -7,147 +6,4 @@
++  */
++ 
++ namespace sitesplat\bbcore_dbxtra;
++-
++-class bbcore
++-{
++-	protected $cfg, $sess, $swmch, $topics, $posts, $pm, $dbname, $dbsize, $idbopt;
++-	protected $table_engines = [];
++-	protected $optisam_tables = [];
++-	protected $optinno_tables = [];
++-	protected $isam_size = 0;
++-	protected $inno_size = 0;
++-	protected $max_isam_size = 500;
++-	protected $max_inno_size = 750;
++-	public function __construct()
++-	{
++-		global $db;
++-		$this->cfg = CONFIG_TABLE;
++-		$this->sess = SESSIONS_TABLE;
++-		$this->swmch = SEARCH_WORDMATCH_TABLE;
++-		$this->topic = TOPICS_TABLE;
++-		$this->post = POSTS_TABLE;
++-		$this->pm = PRIVMSGS_TABLE;
++-		$this->dbname = $db->get_db_name();
++-		\sitesplat\add_filter('bbcore_dash_handle', [$this, 'dbxtra_handle'], 1);
++-		\sitesplat\add_filter('bbcore_dash_display', [$this, 'dbxtra_form'], 1);
++-	}
++-	public function dbxtra_handle($msg_ary)
++-	{
++-		global $db, $language, $request, $user;
++-		if ($request->is_set_post('dbxtra')) {
++-			$this->get_table_data();
++-			@set_time_limit(0);
++-			if ($request->is_set_post('dbxtra_optisam')) {
++-				if (count($this->optisam_tables) && $this->isam_size < $this->max_isam_size) {
++-					$result = $db->sql_query('OPTIMIZE TABLE ' . implode(',', $this->optisam_tables));
++-					$db->sql_freeresult($result);
++-				}
++-				$msg_ary[1] = $language->lang('DBXTRA_OK_OPTIMIZE');
++-			}
++-			if ($request->is_set_post('dbxtra_optinno')) {
++-				if (count($this->optinno_tables) && $this->inno_size < $this->max_inno_size) {
++-					$result = $db->sql_query('OPTIMIZE TABLE ' . implode(',', $this->optinno_tables));
++-					$db->sql_freeresult($result);
++-				}
++-				$msg_ary[1] = $language->lang('DBXTRA_OK_OPTIMIZE');
++-			} else if ($request->is_set_post('dbxtra_analyze')) {
++-				$analyze = implode(',', array_keys($this->table_engines));
++-				$result = $db->sql_query("ANALYZE TABLE $analyze");
++-				$db->sql_freeresult($result);
++-				$msg_ary[1] = $language->lang('DBXTRA_OK_ANALYZE');
++-			} else if ($request->is_set_post('dbxtra_download')) {
++-				global $phpbb_container;
++-				$time = time();
++-				include(__DIR__ . '/phpbbsux.php');
++-				$filename = "{$this->dbname}_{$time}";
++-				$extractor = $phpbb_container->get('dbal.extractor');
++-				$extractor->init_extractor('gzip', $filename, $time, true);
++-				$tables = array_keys($this->table_engines);
++-				foreach ($tables as $table) {
++-					@set_time_limit(0);
++-					$extractor->write_table($table);
++-					$extractor->write_data($table);
++-				}
++-				$extractor->write_end();
++-				exit;
++-			} else if ($request->is_set_post('dbxtra_innodb')) {
++-				if ($this->table_engines[$this->sess] != 'innodb') {
++-					$db->sql_query("TRUNCATE TABLE {$this->sess}");
++-					$db->sql_query("ALTER TABLE {$this->sess} ENGINE = INNODB");
++-					$db->sql_query("INSERT INTO {$this->sess} " . $db->sql_build_array('INSERT', ['session_id' => (string) $user->session_id, 'session_user_id' => (int) $user->data['user_id'], 'session_start' => (int) $user->data['session_start'], 'session_time' => (int) $user->time_now, 'session_browser' => (string) trim(substr($user->browser, 0, 149)), 'session_ip' => (string) $user->ip, 'session_autologin' => (int) $user->data['session_autologin'], 'session_admin' => 1, 'session_viewonline' => (int) $user->data['session_viewonline'],]));
++-				}
++-				if ($this->table_engines[$this->cfg] != 'innodb') {
++-					$db->sql_query("ALTER TABLE {$this->cfg} ENGINE = INNODB");
++-				}
++-				$msg_ary[1] = $language->lang('DBXTRA_OK_INNODB');
++-			}
++-		}
++-		return $msg_ary;
++-	}
++-	public function dbxtra_form($html)
++-	{
++-		global $db, $language;
++-		$result = $db->sql_query("SELECT ENGINE FROM INFORMATION_SCHEMA.ENGINES WHERE LOWER(ENGINE) = 'innodb' AND LOWER(SUPPORT) IN ('yes','default')");
++-		$innodb = $db->sql_fetchfield('ENGINE');
++-		$db->sql_freeresult($result);
++-		$no_inno = $no_isam = '';
++-		$this->get_table_data();
++-		if ($innodb && $this->table_engines[$this->cfg] != 'innodb') {
++-			$no_inno .= sprintf($language->lang('DBXTRA_NO_INNODB'), $this->cfg);
++-		}
++-		if ($innodb && $this->table_engines[$this->sess] != 'innodb') {
++-			$no_inno .= sprintf($language->lang('DBXTRA_NO_INNODB'), $this->sess);
++-		}
++-		if ($no_inno) {
++-			$no_inno = "<div class=\"dbbar2\"></div>$no_inno" . '<div class="dboption dbbutton"><input type="submit" name="dbxtra_innodb" class="submit-button" value="' . $language->lang('DBXTRA_FIX_INNODB') . '" /></div>';
++-		}
++-		if ($this->table_engines[$this->topic] != 'myisam') {
++-			$no_isam .= sprintf($language->lang('DBXTRA_NO_MYISAM'), $this->topic);
++-		}
++-		if ($this->table_engines[$this->post] != 'myisam') {
++-			$no_isam .= sprintf($language->lang('DBXTRA_NO_MYISAM'), $this->post);
++-		}
++-		if ($this->table_engines[$this->pm] != 'myisam') {
++-			$no_isam .= sprintf($language->lang('DBXTRA_NO_MYISAM'), $this->pm);
++-		}
++-		if ($no_isam) {
++-			$no_isam = "<div class=\"dbbar2\"></div>$no_isam" . '<div class="dboption">' . $language->lang('DBXTRA_FIX_MYISAM') . '</div>';
++-		}
++-		$optisam = (count($this->optisam_tables) && $this->isam_size < $this->max_isam_size) ? '<input type="submit" name="dbxtra_optisam" class="submit-button" value="' . $language->lang('DBXTRA_BTN_OPTISAM') . '" />' : '';
++-		$optinno = (count($this->optinno_tables) && $this->inno_size < $this->max_inno_size) ? '<input type="submit" name="dbxtra_optinno" class="submit-button" value="' . $language->lang('DBXTRA_BTN_OPTINNO') . '" />' : '';
++-		$optimize = ($optisam || $optinno) ? '<div class="dboption">' . $language->lang('DBXTRA_OPTIMIZE') . '</div><div class="dboption dbbutton">' . " $optisam $optinno </div>" : '';
++-		return $html . ' <style> #dbxtra *{color:#333;line-height:20px;font-family:Helvetica,Arial,sans-serif;font-size:14px} #dbxtra .dbtitle{margin:0 0 15px;color:#000;font-size:20px} #dbxtra .dboption{margin-top:10px} #dbxtra .dbbutton{padding-bottom:4px} #dbxtra .dbbar2{margin:15px 0;height:2px;background-color:#ddd} #dbxtra .dbbar12{margin:15px 0;height:12px;background-color:#ddd} #dbxtra .submit-button{cursor:pointer;padding:0 8px;height:30px;line-height:1;background-color:#379;color:#fff;border:none;font-size:16px;font-weight:bold} #dbxtra .submit-button:hover{background-color:#48a} </style> <div id="dbxtra"> <div class="dbtitle">' . $language->lang('DBXTRA_TITLE') . '</div> <div class="dboption">' . $language->lang('DBXTRA_ENGINE_DESC') . '</div>' . $no_inno . $no_isam . ' <div class="dbbar12"></div>' . $optimize . ' <div class="dboption">' . $language->lang('DBXTRA_ANALYZE') . '</div><div class="dboption dbbutton"><input type="submit" name="dbxtra_analyze" class="submit-button" value="' . $language->lang('DBXTRA_BTN_ANALYZE') . '" /></div> <div class="dboption">' . $language->lang('DBXTRA_DOWNLOAD') . '</div><div class="dboption dbbutton"><input type="submit" name="dbxtra_download" class="submit-button" value="' . $language->lang('DBXTRA_BTN_DOWNLOAD') . '" /></div> <input type="hidden" name="dbxtra" value="dbxtra" /> </div>';
++-	}
++-	private function get_table_data()
++-	{
++-		if (!empty($this->table_engines)) {
++-			return;
++-		}
++-		global $db;
++-		$result = $db->sql_query("SELECT @@global.innodb_file_per_table AS idbopt");
++-		$this->idbopt = (int) $db->sql_fetchfield('idbopt');
++-		$db->sql_freeresult($result);
++-		$result = $db->sql_query("SELECT SUM(DATA_LENGTH) AS dta, SUM(INDEX_LENGTH) as idx FROM information_schema.TABLES WHERE TABLE_SCHEMA = '{$this->dbname}' AND ENGINE IN ('MyISAM','InnoDB','Aria')");
++-		$row = $db->sql_fetchrow($result);
++-		$db->sql_freeresult($result);
++-		$this->dbsize = (int) ceil(($row['dta'] + $row['idx']) / 1048576);
++-		$result = $db->sql_query("SELECT TABLE_NAME, LOWER(ENGINE) AS engn, DATA_LENGTH + INDEX_LENGTH AS tsize, DATA_FREE AS dfree FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '{$this->dbname}'");
++-		while ($row = $db->sql_fetchrow($result)) {
++-			$name = $row['TABLE_NAME'];
++-			$engine = $row['engn'];
++-			$dfree = (int) $row['dfree'];
++-			$tsize = (int) $row['tsize'];
++-			$this->table_engines[$name] = $engine;
++-			if ($engine == 'innodb' && $this->idbopt && $name != $this->swmch) {
++-				$this->optinno_tables[] = $name;
++-				$this->inno_size += $tsize;
++-			} else if (($engine == 'myisam' || $engine == 'aria') && $dfree > 0 && $name != $this->swmch) {
++-				$this->optisam_tables[] = $name;
++-				$this->isam_size += $tsize;
++-			}
++-			$this->isam_size = (int) ceil($this->isam_size / 1048576);
++-			$this->inno_size = (int) ceil($this->inno_size / 1048576);
++-		}
++-		$db->sql_freeresult($result);
++-	}
++-}
+++class bbcore { protected $cfg, $sess, $swmch, $topics, $posts, $pm, $dbname, $dbsize, $idbopt; protected $table_engines = []; protected $optisam_tables = []; protected $optinno_tables = []; protected $isam_size = 0; protected $inno_size = 0; protected $max_isam_size = 500; protected $max_inno_size = 750; public function __construct() { global $db; $this->cfg = CONFIG_TABLE; $this->sess = SESSIONS_TABLE; $this->swmch = SEARCH_WORDMATCH_TABLE; $this->topic = TOPICS_TABLE; $this->post = POSTS_TABLE; $this->pm = PRIVMSGS_TABLE; $this->dbname = $db->get_db_name(); \sitesplat\add_filter('bbcore_dash_handle', [$this, 'dbxtra_handle'], 1); \sitesplat\add_filter('bbcore_dash_display', [$this, 'dbxtra_form'], 1); } public function dbxtra_handle($msg_ary) { global $db, $language, $request, $user; if ($request->is_set_post('dbxtra')) { $this->get_table_data(); @set_time_limit(0); if ($request->is_set_post('dbxtra_optisam')) { if (count($this->optisam_tables) && $this->isam_size < $this->max_isam_size) { $result = $db->sql_query('OPTIMIZE TABLE ' . implode(',', $this->optisam_tables)); $db->sql_freeresult($result); } $msg_ary[1] = $language->lang('DBXTRA_OK_OPTIMIZE'); } if ($request->is_set_post('dbxtra_optinno')) { if (count($this->optinno_tables) && $this->inno_size < $this->max_inno_size) { $result = $db->sql_query('OPTIMIZE TABLE ' . implode(',', $this->optinno_tables)); $db->sql_freeresult($result); } $msg_ary[1] = $language->lang('DBXTRA_OK_OPTIMIZE'); } else if ($request->is_set_post('dbxtra_analyze')) { $analyze = implode(',', array_keys($this->table_engines)); $result = $db->sql_query("ANALYZE TABLE $analyze"); $db->sql_freeresult($result); $msg_ary[1] = $language->lang('DBXTRA_OK_ANALYZE'); } else if ($request->is_set_post('dbxtra_download')) { global $phpbb_container; $time = time(); include(__DIR__ . '/phpbbsux.php'); $filename = "{$this->dbname}_{$time}"; $extractor = $phpbb_container->get('dbal.extractor'); $extractor->init_extractor('gzip', $filename, $time, true); $tables = array_keys($this->table_engines); foreach ($tables as $table) { @set_time_limit(0); $extractor->write_table($table); $extractor->write_data($table); } $extractor->write_end(); exit; } else if ($request->is_set_post('dbxtra_innodb')) { if ($this->table_engines[$this->sess] != 'innodb') { $db->sql_query("TRUNCATE TABLE {$this->sess}"); $db->sql_query("ALTER TABLE {$this->sess} ENGINE = INNODB"); $db->sql_query("INSERT INTO {$this->sess} " . $db->sql_build_array('INSERT', [ 'session_id' => (string) $user->session_id, 'session_user_id' => (int) $user->data['user_id'], 'session_start' => (int) $user->data['session_start'], 'session_time' => (int) $user->time_now, 'session_browser' => (string) trim(substr($user->browser, 0, 149)), 'session_ip' => (string) $user->ip, 'session_autologin' => (int) $user->data['session_autologin'], 'session_admin' => 1, 'session_viewonline' => (int) $user->data['session_viewonline'], ])); } if ($this->table_engines[$this->cfg] != 'innodb') { $db->sql_query("ALTER TABLE {$this->cfg} ENGINE = INNODB"); } $msg_ary[1] = $language->lang('DBXTRA_OK_INNODB'); } } return $msg_ary; } public function dbxtra_form($html) { global $db, $language; $result = $db->sql_query("SELECT ENGINE FROM INFORMATION_SCHEMA.ENGINES WHERE LOWER(ENGINE) = 'innodb' AND LOWER(SUPPORT) IN ('yes','default')"); $innodb = $db->sql_fetchfield('ENGINE'); $db->sql_freeresult($result); $no_inno = $no_isam = ''; $this->get_table_data(); if ($innodb && $this->table_engines[$this->cfg] != 'innodb') { $no_inno .= sprintf($language->lang('DBXTRA_NO_INNODB'), $this->cfg); } if ($innodb && $this->table_engines[$this->sess] != 'innodb') { $no_inno .= sprintf($language->lang('DBXTRA_NO_INNODB'), $this->sess); } if ($no_inno) { $no_inno = "<div class=\"dbbar2\"></div>$no_inno" . '<div class="dboption dbbutton"><input type="submit" name="dbxtra_innodb" class="submit-button" value="' . $language->lang('DBXTRA_FIX_INNODB') . '" /></div>'; } if ($this->table_engines[$this->topic] != 'myisam') { $no_isam .= sprintf($language->lang('DBXTRA_NO_MYISAM'), $this->topic); } if ($this->table_engines[$this->post] != 'myisam') { $no_isam .= sprintf($language->lang('DBXTRA_NO_MYISAM'), $this->post); } if ($this->table_engines[$this->pm] != 'myisam') { $no_isam .= sprintf($language->lang('DBXTRA_NO_MYISAM'), $this->pm); } if ($no_isam) { $no_isam = "<div class=\"dbbar2\"></div>$no_isam" . '<div class="dboption">' . $language->lang('DBXTRA_FIX_MYISAM') . '</div>'; } $optisam = (count($this->optisam_tables) && $this->isam_size < $this->max_isam_size) ? '<input type="submit" name="dbxtra_optisam" class="submit-button" value="' . $language->lang('DBXTRA_BTN_OPTISAM') . '" />' : ''; $optinno = (count($this->optinno_tables) && $this->inno_size < $this->max_inno_size) ? '<input type="submit" name="dbxtra_optinno" class="submit-button" value="' . $language->lang('DBXTRA_BTN_OPTINNO') . '" />' : ''; $optimize = ($optisam || $optinno) ? '<div class="dboption">' . $language->lang('DBXTRA_OPTIMIZE') . '</div><div class="dboption dbbutton">' . " $optisam $optinno </div>" : ''; return $html . ' <style> #dbxtra *{color:#333;line-height:20px;font-family:Helvetica,Arial,sans-serif;font-size:14px} #dbxtra .dbtitle{margin:0 0 15px;color:#000;font-size:20px} #dbxtra .dboption{margin-top:10px} #dbxtra .dbbutton{padding-bottom:4px} #dbxtra .dbbar2{margin:15px 0;height:2px;background-color:#ddd} #dbxtra .dbbar12{margin:15px 0;height:12px;background-color:#ddd} #dbxtra .submit-button{cursor:pointer;padding:0 8px;height:30px;line-height:1;background-color:#379;color:#fff;border:none;font-size:16px;font-weight:bold} #dbxtra .submit-button:hover{background-color:#48a} </style> <div id="dbxtra"> <div class="dbtitle">' . $language->lang('DBXTRA_TITLE') . '</div> <div class="dboption">' . $language->lang('DBXTRA_ENGINE_DESC') . '</div>' . $no_inno . $no_isam . ' <div class="dbbar12"></div>' . $optimize . ' <div class="dboption">' . $language->lang('DBXTRA_ANALYZE') . '</div><div class="dboption dbbutton"><input type="submit" name="dbxtra_analyze" class="submit-button" value="' . $language->lang('DBXTRA_BTN_ANALYZE') . '" /></div> <div class="dboption">' . $language->lang('DBXTRA_DOWNLOAD') . '</div><div class="dboption dbbutton"><input type="submit" name="dbxtra_download" class="submit-button" value="' . $language->lang('DBXTRA_BTN_DOWNLOAD') . '" /></div> <input type="hidden" name="dbxtra" value="dbxtra" /> </div>'; } private function get_table_data() { if (!empty($this->table_engines)) {return;} global $db; $result = $db->sql_query("SELECT @@global.innodb_file_per_table AS idbopt"); $this->idbopt = (int) $db->sql_fetchfield('idbopt'); $db->sql_freeresult($result); $result = $db->sql_query("SELECT SUM(DATA_LENGTH) AS dta, SUM(INDEX_LENGTH) as idx FROM information_schema.TABLES WHERE TABLE_SCHEMA = '{$this->dbname}' AND ENGINE IN ('MyISAM','InnoDB','Aria')"); $row = $db->sql_fetchrow($result); $db->sql_freeresult($result); $this->dbsize = (int) ceil(($row['dta'] + $row['idx']) / 1048576); $result = $db->sql_query("SELECT TABLE_NAME, LOWER(ENGINE) AS engn, DATA_LENGTH + INDEX_LENGTH AS tsize, DATA_FREE AS dfree FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '{$this->dbname}'"); while ($row = $db->sql_fetchrow($result)) { $name = $row['TABLE_NAME']; $engine = $row['engn']; $dfree = (int) $row['dfree']; $tsize =
+\ No newline at end of file
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbcore_dbxtra/ext.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbcore_dbxtra/ext.php"
+index 9cce92c74..53cdc2659 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbcore_dbxtra/ext.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbcore_dbxtra/ext.php"
+@@ -1,5 +1,4 @@
+ <?php
+-
+ /**
+  * BBCore DB Addon
+  * @copyright (c) 2020 SiteSplat. All rights reserved.
+@@ -7,50 +6,4 @@
+  */
+ 
+ namespace sitesplat\bbcore_dbxtra;
+-
+-class ext extends \phpbb\extension\base
+-{
+-	protected $db;
+-	public function __construct($container, $extension_finder, $migrator, $extension_name, $extension_path)
+-	{
+-		$this->db = $container->get('dbal.conn');
+-	}
+-	public function is_enableable()
+-	{
+-		if ($this->db->get_sql_layer() != 'mysqli') {
+-			return false;
+-		}
+-		$sql = 'SELECT module_id FROM ' . MODULES_TABLE . " WHERE module_class = 'acp' AND module_langname = 'BBCORE_DASHBOARD'";
+-		$result = $this->db->sql_query($sql);
+-		$module_id = (int) $this->db->sql_fetchfield('module_id');
+-		$this->db->sql_freeresult($result);
+-		return $module_id > 0;
+-	}
+-	public function enable_step($whocares)
+-	{
+-		$addons = \sitesplat\addon::$addons;
+-		$addons['bbcore']['bbcore_dbxtra'] = 'sitesplat';
+-		\sitesplat\addon::$addons = $addons;
+-		$json = $this->db->sql_escape(json_encode($addons, 320));
+-		$this->db->sql_query('REPLACE INTO ' . CONFIG_TEXT_TABLE . " VALUES('sitesplat_addons', '$json')");
+-		return false;
+-	}
+-	public function disable_step($whocares)
+-	{
+-		if (class_exists('\sitesplat\addon')) {
+-			$addons = \sitesplat\addon::$addons;
+-		} else {
+-		}
+-		unset($addons['bbcore']['bbcore_dbxtra']);
+-		if (empty($addons['bbcore'])) {
+-			unset($addons['bbcore']);
+-		}
+-		if (class_exists('\sitesplat\addon')) {
+-			\sitesplat\addon::$addons = $addons;
+-		}
+-		$json = $this->db->sql_escape(json_encode($addons, 320));
+-		$this->db->sql_query('REPLACE INTO ' . CONFIG_TEXT_TABLE . " VALUES('sitesplat_addons', '$json')");
+-		$this->db->sql_query('DELETE FROM ' . EXT_TABLE . " WHERE ext_name = 'sitesplat/bbcore_dbxtra'");
+-		return false;
+-	}
+-}
++class ext extends \phpbb\extension\base { protected $db; public function __construct($container, $extension_finder, $migrator, $extension_name, $extension_path) { $this->db = $container->get('dbal.conn'); } public function is_enableable() { if ($this->db->get_sql_layer() != 'mysqli') { return false; } $sql = 'SELECT module_id FROM ' . MODULES_TABLE . " WHERE module_class = 'acp' AND module_langname = 'BBCORE_DASHBOARD'"; $result = $this->db->sql_query($sql); $module_id = (int) $this->db->sql_fetchfield('module_id'); $this->db->sql_freeresult($result); return $module_id > 0; } public function enable_step($whocares) { $addons = \sitesplat\addon::$addons; $addons['bbcore']['bbcore_dbxtra'] = 'sitesplat'; \sitesplat\addon::$addons = $addons; $json = $this->db->sql_escape(json_encode($addons, 320)); $this->db->sql_query('REPLACE INTO ' . CONFIG_TEXT_TABLE . " VALUES('sitesplat_addons', '$json')"); return false; } public function disable_step($whocares) { if (class_exists('\sitesplat\addon')) { $addons = \sitesplat\addon::$addons; } else { } unset($addons['bbcore']['bbcore_dbxtra']); if (empty($addons['bbcore'])) { unset($addons['bbcore']); } if (class_exists('\sitesplat\addon')) { \sitesplat\addon::$addons = $addons; } $json = $this->db->sql_escape(json_encode($addons, 320)); $this->db->sql_query('REPLACE INTO ' . CONFIG_TEXT_TABLE . " VALUES('sitesplat_addons', '$json')"); $this->db->sql_query('DELETE FROM ' . EXT_TABLE . " WHERE ext_name = 'sitesplat/bbcore_dbxtra'"); return false; } }
+\ No newline at end of file
diff --git "[FORUM_EXT]/sitesplat\\bbcore_dbxtra/diff_nospace.tmp" "[FORUM_EXT]/sitesplat\\bbcore_dbxtra/diff_nospace.tmp"
new file mode 100644
--- /dev/null
+++ "[FORUM_EXT]/sitesplat\\bbcore_dbxtra/diff_nospace.tmp"
@@ -0,0 +1,532 @@
+diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbcore_dbxtra/bbcore.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbcore_dbxtra/bbcore.php"
+index a165a2f42..4cccc72fc 100644
+--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbcore_dbxtra/bbcore.php"
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbcore_dbxtra/bbcore.php"
+@@ -1,5 +1,4 @@
+ <?php
+-
+ /**
+  * BBCore DB Addon
+  * @copyright (c) 2021 SiteSplat. All rights reserved.
+@@ -7,147 +6,4 @@
+  */
+ 
+ namespace sitesplat\bbcore_dbxtra;
+-
+-class bbcore
+-{
+-	protected $cfg, $sess, $swmch, $topics, $posts, $pm, $dbname, $dbsize, $idbopt;
+-	protected $table_engines = [];
+-	protected $optisam_tables = [];
+-	protected $optinno_tables = [];
+-	protected $isam_size = 0;
+-	protected $inno_size = 0;
+-	protected $max_isam_size = 500;
+-	protected $max_inno_size = 750;
+-	public function __construct()
+-	{
+-		global $db;
+-		$this->cfg = CONFIG_TABLE;
+-		$this->sess = SESSIONS_TABLE;
+-		$this->swmch = SEARCH_WORDMATCH_TABLE;
+-		$this->topic = TOPICS_TABLE;
+-		$this->post = POSTS_TABLE;
+-		$this->pm = PRIVMSGS_TABLE;
+-		$this->dbname = $db->get_db_name();
+-		\sitesplat\add_filter('bbcore_dash_handle', [$this, 'dbxtra_handle'], 1);
+-		\sitesplat\add_filter('bbcore_dash_display', [$this, 'dbxtra_form'], 1);
+-	}
+-	public function dbxtra_handle($msg_ary)
+-	{
+-		global $db, $language, $request, $user;
+-		if ($request->is_set_post('dbxtra')) {
+-			$this->get_table_data();
+-			@set_time_limit(0);
+-			if ($request->is_set_post('dbxtra_optisam')) {
+-				if (count($this->optisam_tables) && $this->isam_size < $this->max_isam_size) {
+-					$result = $db->sql_query('OPTIMIZE TABLE ' . implode(',', $this->optisam_tables));
+-					$db->sql_freeresult($result);
+-				}
+-				$msg_ary[1] = $language->lang('DBXTRA_OK_OPTIMIZE');
+-			}
+-			if ($request->is_set_post('dbxtra_optinno')) {
+-				if (count($this->optinno_tables) && $this->inno_size < $this->max_inno_size) {
+-					$result = $db->sql_query('OPTIMIZE TABLE ' . implode(',', $this->optinno_tables));
+-					$db->sql_freeresult($result);
+-				}
+-				$msg_ary[1] = $language->lang('DBXTRA_OK_OPTIMIZE');
+-			} else if ($request->is_set_post('dbxtra_analyze')) {
+-				$analyze = implode(',', array_keys($this->table_engines));
+-				$result = $db->sql_query("ANALYZE TABLE $analyze");
+-				$db->sql_freeresult($result);
+-				$msg_ary[1] = $language->lang('DBXTRA_OK_ANALYZE');
+-			} else if ($request->is_set_post('dbxtra_download')) {
+-				global $phpbb_container;
+-				$time = time();
+-				include(__DIR__ . '/phpbbsux.php');
+-				$filename = "{$this->dbname}_{$time}";
+-				$extractor = $phpbb_container->get('dbal.extractor');
+-				$extractor->init_extractor('gzip', $filename, $time, true);
+-				$tables = array_keys($this->table_engines);
+-				foreach ($tables as $table) {
+-					@set_time_limit(0);
+-					$extractor->write_table($table);
+-					$extractor->write_data($table);
+-				}
+-				$extractor->write_end();
+-				exit;
+-			} else if ($request->is_set_post('dbxtra_innodb')) {
+-				if ($this->table_engines[$this->sess] != 'innodb') {
+-					$db->sql_query("TRUNCATE TABLE {$this->sess}");
+-					$db->sql_query("ALTER TABLE {$this->sess} ENGINE = INNODB");
+-					$db->sql_query("INSERT INTO {$this->sess} " . $db->sql_build_array('INSERT', ['session_id' => (string) $user->session_id, 'session_user_id' => (int) $user->data['user_id'], 'session_start' => (int) $user->data['session_start'], 'session_time' => (int) $user->time_now, 'session_browser' => (string) trim(substr($user->browser, 0, 149)), 'session_ip' => (string) $user->ip, 'session_autologin' => (int) $user->data['session_autologin'], 'session_admin' => 1, 'session_viewonline' => (int) $user->data['session_viewonline'],]));
+-				}
+-				if ($this->table_engines[$this->cfg] != 'innodb') {
+-					$db->sql_query("ALTER TABLE {$this->cfg} ENGINE = INNODB");
+-				}
+-				$msg_ary[1] = $language->lang('DBXTRA_OK_INNODB');
+-			}
+-		}
+-		return $msg_ary;
+-	}
+-	public function dbxtra_form($html)
+-	{
+-		global $db, $language;
+-		$result = $db->sql_query("SELECT ENGINE FROM INFORMATION_SCHEMA.ENGINES WHERE LOWER(ENGINE) = 'innodb' AND LOWER(SUPPORT) IN ('yes','default')");
+-		$innodb = $db->sql_fetchfield('ENGINE');
+-		$db->sql_freeresult($result);
+-		$no_inno = $no_isam = '';
+-		$this->get_table_data();
+-		if ($innodb && $this->table_engines[$this->cfg] != 'innodb') {
+-			$no_inno .= sprintf($language->lang('DBXTRA_NO_INNODB'), $this->cfg);
+-		}
+-		if ($innodb && $this->table_engines[$this->sess] != 'innodb') {
+-			$no_inno .= sprintf($language->lang('DBXTRA_NO_INNODB'), $this->sess);
+-		}
+-		if ($no_inno) {
+-			$no_inno = "<div class=\"dbbar2\"></div>$no_inno" . '<div class="dboption dbbutton"><input type="submit" name="dbxtra_innodb" class="submit-button" value="' . $language->lang('DBXTRA_FIX_INNODB') . '" /></div>';
+-		}
+-		if ($this->table_engines[$this->topic] != 'myisam') {
+-			$no_isam .= sprintf($language->lang('DBXTRA_NO_MYISAM'), $this->topic);
+-		}
+-		if ($this->table_engines[$this->post] != 'myisam') {
+-			$no_isam .= sprintf($language->lang('DBXTRA_NO_MYISAM'), $this->post);
+-		}
+-		if ($this->table_engines[$this->pm] != 'myisam') {
+-			$no_isam .= sprintf($language->lang('DBXTRA_NO_MYISAM'), $this->pm);
+-		}
+-		if ($no_isam) {
+-			$no_isam = "<div class=\"dbbar2\"></div>$no_isam" . '<div class="dboption">' . $language->lang('DBXTRA_FIX_MYISAM') . '</div>';
+-		}
+-		$optisam = (count($this->optisam_tables) && $this->isam_size < $this->max_isam_size) ? '<input type="submit" name="dbxtra_optisam" class="submit-button" value="' . $language->lang('DBXTRA_BTN_OPTISAM') . '" />' : '';
+-		$optinno = (count($this->optinno_tables) && $this->inno_size < $this->max_inno_size) ? '<input type="submit" name="dbxtra_optinno" class="submit-button" value="' . $language->lang('DBXTRA_BTN_OPTINNO') . '" />' : '';
+-		$optimize = ($optisam || $optinno) ? '<div class="dboption">' . $language->lang('DBXTRA_OPTIMIZE') . '</div><div class="dboption dbbutton">' . " $optisam $optinno </div>" : '';
+-		return $html . ' <style> #dbxtra *{color:#333;line-height:20px;font-family:Helvetica,Arial,sans-serif;font-size:14px} #dbxtra .dbtitle{margin:0 0 15px;color:#000;font-size:20px} #dbxtra .dboption{margin-top:10px} #dbxtra .dbbutton{padding-bottom:4px} #dbxtra .dbbar2{margin:15px 0;height:2px;background-color:#ddd} #dbxtra .dbbar12{margin:15px 0;height:12px;background-color:#ddd} #dbxtra .submit-button{cursor:pointer;padding:0 8px;height:30px;line-height:1;background-color:#379;color:#fff;border:none;font-size:16px;font-weight:bold} #dbxtra .submit-button:hover{background-color:#48a} </style> <div id="dbxtra"> <div class="dbtitle">' . $language->lang('DBXTRA_TITLE') . '</div> <div class="dboption">' . $language->lang('DBXTRA_ENGINE_DESC') . '</div>' . $no_inno . $no_isam . ' <div class="dbbar12"></div>' . $optimize . ' <div class="dboption">' . $language->lang('DBXTRA_ANALYZE') . '</div><div class="dboption dbbutton"><input type="submit" name="dbxtra_analyze" class="submit-button" value="' . $language->lang('DBXTRA_BTN_ANALYZE') . '" /></div> <div class="dboption">' . $language->lang('DBXTRA_DOWNLOAD') . '</div><div class="dboption dbbutton"><input type="submit" name="dbxtra_download" class="submit-button" value="' . $language->lang('DBXTRA_BTN_DOWNLOAD') . '" /></div> <input type="hidden" name="dbxtra" value="dbxtra" /> </div>';
+-	}
+-	private function get_table_data()
+-	{
+-		if (!empty($this->table_engines)) {
+-			return;
+-		}
+-		global $db;
+-		$result = $db->sql_query("SELECT @@global.innodb_file_per_table AS idbopt");
+-		$this->idbopt = (int) $db->sql_fetchfield('idbopt');
+-		$db->sql_freeresult($result);
+-		$result = $db->sql_query("SELECT SUM(DATA_LENGTH) AS dta, SUM(INDEX_LENGTH) as idx FROM information_schema.TABLES WHERE TABLE_SCHEMA = '{$this->dbname}' AND ENGINE IN ('MyISAM','InnoDB','Aria')");
+-		$row = $db->sql_fetchrow($result);
+-		$db->sql_freeresult($result);
+-		$this->dbsize = (int) ceil(($row['dta'] + $row['idx']) / 1048576);
+-		$result = $db->sql_query("SELECT TABLE_NAME, LOWER(ENGINE) AS engn, DATA_LENGTH + INDEX_LENGTH AS tsize, DATA_FREE AS dfree FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '{$this->dbname}'");
+-		while ($row = $db->sql_fetchrow($result)) {
+-			$name = $row['TABLE_NAME'];
+-			$engine = $row['engn'];
+-			$dfree = (int) $row['dfree'];
+-			$tsize = (int) $row['tsize'];
+-			$this->table_engines[$name] = $engine;
+-			if ($engine == 'innodb' && $this->idbopt && $name != $this->swmch) {
+-				$this->optinno_tables[] = $name;
+-				$this->inno_size += $tsize;
+-			} else if (($engine == 'myisam' || $engine == 'aria') && $dfree > 0 && $name != $this->swmch) {
+-				$this->optisam_tables[] = $name;
+-				$this->isam_size += $tsize;
+-			}
+-			$this->isam_size = (int) ceil($this->isam_size / 1048576);
+-			$this->inno_size = (int) ceil($this->inno_size / 1048576);
+-		}
+-		$db->sql_freeresult($result);
+-	}
+-}
++class bbcore { protected $cfg, $sess, $swmch, $topics, $posts, $pm, $dbname, $dbsize, $idbopt; protected $table_engines = []; protected $optisam_tables = []; protected $optinno_tables = []; protected $isam_size = 0; protected $inno_size = 0; protected $max_isam_size = 500; protected $max_inno_size = 750; public function __construct() { global $db; $this->cfg = CONFIG_TABLE; $this->sess = SESSIONS_TABLE; $this->swmch = SEARCH_WORDMATCH_TABLE; $this->topic = TOPICS_TABLE; $this->post = POSTS_TABLE; $this->pm = PRIVMSGS_TABLE; $this->dbname = $db->get_db_name(); \sitesplat\add_filter('bbcore_dash_handle', [$this, 'dbxtra_handle'], 1); \sitesplat\add_filter('bbcore_dash_display', [$this, 'dbxtra_form'], 1); } public function dbxtra_handle($msg_ary) { global $db, $language, $request, $user; if ($request->is_set_post('dbxtra')) { $this->get_table_data(); @set_time_limit(0); if ($request->is_set_post('dbxtra_optisam')) { if (count($this->optisam_tables) && $this->isam_size < $this->max_isam_size) { $result = $db->sql_query('OPTIMIZE TABLE ' . implode(',', $this->optisam_tables)); $db->sql_freeresult($result); } $msg_ary[1] = $language->lang('DBXTRA_OK_OPTIMIZE'); } if ($request->is_set_post('dbxtra_optinno')) { if (count($this->optinno_tables) && $this->inno_size < $this->max_inno_size) { $result = $db->sql_query('OPTIMIZE TABLE ' . implode(',', $this->optinno_tables)); $db->sql_freeresult($result); } $msg_ary[1] = $language->lang('DBXTRA_OK_OPTIMIZE'); } else if ($request->is_set_post('dbxtra_analyze')) { $analyze = implode(',', array_keys($this->table_engines)); $result = $db->sql_query("ANALYZE TABLE $analyze"); $db->sql_freeresult($result); $msg_ary[1] = $language->lang('DBXTRA_OK_ANALYZE'); } else if ($request->is_set_post('dbxtra_download')) { global $phpbb_container; $time = time(); include(__DIR__ . '/phpbbsux.php'); $filename = "{$this->dbname}_{$time}"; $extractor = $phpbb_container->get('dbal.extractor'); $extractor->init_extractor('gzip', $filename, $time, true); $tables = array_keys($this->table_engines); foreach ($tables as $table) { @set_time_limit(0); $extractor->write_table($table); $extractor->write_data($table); } $extractor->write_end(); exit; } else if ($request->is_set_post('dbxtra_innodb')) { if ($this->table_engines[$this->sess] != 'innodb') { $db->sql_query("TRUNCATE TABLE {$this->sess}"); $db->sql_query("ALTER TABLE {$this->sess} ENGINE = INNODB"); $db->sql_query("INSERT INTO {$this->sess} " . $db->sql_build_array('INSERT', [ 'session_id' => (string) $user->session_id, 'session_user_id' => (int) $user->data['user_id'], 'session_start' => (int) $user->data['session_start'], 'session_time' => (int) $user->time_now, 'session_browser' => (string) trim(substr($user->browser, 0, 149)), 'session_ip' => (string) $user->ip, 'session_autologin' => (int) $user->data['session_autologin'], 'session_admin' => 1, 'session_viewonline' => (int) $user->data['session_viewonline'], ])); } if ($this->table_engines[$this->cfg] != 'innodb') { $db->sql_query("ALTER TABLE {$this->cfg} ENGINE = INNODB"); } $msg_ary[1] = $language->lang('DBXTRA_OK_INNODB'); } } return $msg_ary; } public function dbxtra_form($html) { global $db, $language; $result = $db->sql_query("SELECT ENGINE FROM INFORMATION_SCHEMA.ENGINES WHERE LOWER(ENGINE) = 'innodb' AND LOWER(SUPPORT) IN ('yes','default')"); $innodb = $db->sql_fetchfield('ENGINE'); $db->sql_freeresult($result); $no_inno = $no_isam = ''; $this->get_table_data(); if ($innodb && $this->table_engines[$this->cfg] != 'innodb') { $no_inno .= sprintf($language->lang('DBXTRA_NO_INNODB'), $this->cfg); } if ($innodb && $this->table_engines[$this->sess] != 'innodb') { $no_inno .= sprintf($language->lang('DBXTRA_NO_INNODB'), $this->sess); } if ($no_inno) { $no_inno = "<div class=\"dbbar2\"></div>$no_inno" . '<div class="dboption dbbutton"><input type="submit" name="dbxtra_innodb" class="submit-button" value="' . $language->lang('DBXTRA_FIX_INNODB') . '" /></div>'; } if ($this->table_engines[$this->topic] != 'myisam') { $no_isam .= sprintf($language->lang('DBXTRA_NO_MYISAM'), $this->topic); } if ($this->table_engines[$this->post] != 'myisam') { $no_isam .= sprintf($language->lang('DBXTRA_NO_MYISAM'), $this->post); } if ($this->table_engines[$this->pm] != 'myisam') { $no_isam .= sprintf($language->lang('DBXTRA_NO_MYISAM'), $this->pm); } if ($no_isam) { $no_isam = "<div class=\"dbbar2\"></div>$no_isam" . '<div class="dboption">' . $language->lang('DBXTRA_FIX_MYISAM') . '</div>'; } $optisam = (count($this->optisam_tables) && $this->isam_size < $this->max_isam_size) ? '<input type="submit" name="dbxtra_optisam" class="submit-button" value="' . $language->lang('DBXTRA_BTN_OPTISAM') . '" />' : ''; $optinno = (count($this->optinno_tables) && $this->inno_size < $this->max_inno_size) ? '<input type="submit" name="dbxtra_optinno" class="submit-button" value="' . $language->lang('DBXTRA_BTN_OPTINNO') . '" />' : ''; $optimize = ($optisam || $optinno) ? '<div class="dboption">' . $language->lang('DBXTRA_OPTIMIZE') . '</div><div class="dboption dbbutton">' . " $optisam $optinno </div>" : ''; return $html . ' <style> #dbxtra *{color:#333;line-height:20px;font-family:Helvetica,Arial,sans-serif;font-size:14px} #dbxtra .dbtitle{margin:0 0 15px;color:#000;font-size:20px} #dbxtra .dboption{margin-top:10px} #dbxtra .dbbutton{padding-bottom:4px} #dbxtra .dbbar2{margin:15px 0;height:2px;background-color:#ddd} #dbxtra .dbbar12{margin:15px 0;height:12px;background-color:#ddd} #dbxtra .submit-button{cursor:pointer;padding:0 8px;height:30px;line-height:1;background-color:#379;color:#fff;border:none;font-size:16px;font-weight:bold} #dbxtra .submit-button:hover{background-color:#48a} </style> <div id="dbxtra"> <div class="dbtitle">' . $language->lang('DBXTRA_TITLE') . '</div> <div class="dboption">' . $language->lang('DBXTRA_ENGINE_DESC') . '</div>' . $no_inno . $no_isam . ' <div class="dbbar12"></div>' . $optimize . ' <div class="dboption">' . $language->lang('DBXTRA_ANALYZE') . '</div><div class="dboption dbbutton"><input type="submit" name="dbxtra_analyze" class="submit-button" value="' . $language->lang('DBXTRA_BTN_ANALYZE') . '" /></div> <div class="dboption">' . $language->lang('DBXTRA_DOWNLOAD') . '</div><div class="dboption dbbutton"><input type="submit" name="dbxtra_download" class="submit-button" value="' . $language->lang('DBXTRA_BTN_DOWNLOAD') . '" /></div> <input type="hidden" name="dbxtra" value="dbxtra" /> </div>'; } private function get_table_data() { if (!empty($this->table_engines)) {return;} global $db; $result = $db->sql_query("SELECT @@global.innodb_file_per_table AS idbopt"); $this->idbopt = (int) $db->sql_fetchfield('idbopt'); $db->sql_freeresult($result); $result = $db->sql_query("SELECT SUM(DATA_LENGTH) AS dta, SUM(INDEX_LENGTH) as idx FROM information_schema.TABLES WHERE TABLE_SCHEMA = '{$this->dbname}' AND ENGINE IN ('MyISAM','InnoDB','Aria')"); $row = $db->sql_fetchrow($result); $db->sql_freeresult($result); $this->dbsize = (int) ceil(($row['dta'] + $row['idx']) / 1048576); $result = $db->sql_query("SELECT TABLE_NAME, LOWER(ENGINE) AS engn, DATA_LENGTH + INDEX_LENGTH AS tsize, DATA_FREE AS dfree FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '{$this->dbname}'"); while ($row = $db->sql_fetchrow($result)) { $name = $row['TABLE_NAME']; $engine = $row['engn']; $dfree = (int) $row['dfree']; $tsize = (int) $row['tsize']; $this->table_engines[$name] = $engine; if ($engine == 'innodb' && $this->idbopt && $name != $this->swmch) { $this->optinno_tables[] = $name; $this->inno_size += $tsize; } else if (($engine == 'myisam' || $engine == 'aria') && $dfree > 0 && $name != $this->swmch) { $this->optisam_tables[] = $name; $this->isam_size += $tsize; } $this->isam_size = (int) ceil($this->isam_size / 1048576); $this->inno_size = (int) ceil($this->inno_size / 1048576); } $db->sql_freeresult($result); } }
+\ No newline at end of file
+diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbcore_dbxtra/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbcore_dbxtra/diff_full.tmp"
+new file mode 100644
+index 000000000..7ba238d0f
+--- /dev/null
++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbcore_dbxtra/diff_full.tmp"
+@@ -0,0 +1,389 @@
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbcore_dbxtra/bbcore.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbcore_dbxtra/bbcore.php"
++index a165a2f42..4cccc72fc 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbcore_dbxtra/bbcore.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbcore_dbxtra/bbcore.php"
++@@ -1,5 +1,4 @@
++ <?php
++-
++ /**
++  * BBCore DB Addon
++  * @copyright (c) 2021 SiteSplat. All rights reserved.
++@@ -7,147 +6,4 @@
++  */
++ 
++ namespace sitesplat\bbcore_dbxtra;
++-
++-class bbcore
++-{
++-	protected $cfg, $sess, $swmch, $topics, $posts, $pm, $dbname, $dbsize, $idbopt;
++-	protected $table_engines = [];
++-	protected $optisam_tables = [];
++-	protected $optinno_tables = [];
++-	protected $isam_size = 0;
++-	protected $inno_size = 0;
++-	protected $max_isam_size = 500;
++-	protected $max_inno_size = 750;
++-	public function __construct()
++-	{
++-		global $db;
++-		$this->cfg = CONFIG_TABLE;
++-		$this->sess = SESSIONS_TABLE;
++-		$this->swmch = SEARCH_WORDMATCH_TABLE;
++-		$this->topic = TOPICS_TABLE;
++-		$this->post = POSTS_TABLE;
++-		$this->pm = PRIVMSGS_TABLE;
++-		$this->dbname = $db->get_db_name();
++-		\sitesplat\add_filter('bbcore_dash_handle', [$this, 'dbxtra_handle'], 1);
++-		\sitesplat\add_filter('bbcore_dash_display', [$this, 'dbxtra_form'], 1);
++-	}
++-	public function dbxtra_handle($msg_ary)
++-	{
++-		global $db, $language, $request, $user;
++-		if ($request->is_set_post('dbxtra')) {
++-			$this->get_table_data();
++-			@set_time_limit(0);
++-			if ($request->is_set_post('dbxtra_optisam')) {
++-				if (count($this->optisam_tables) && $this->isam_size < $this->max_isam_size) {
++-					$result = $db->sql_query('OPTIMIZE TABLE ' . implode(',', $this->optisam_tables));
++-					$db->sql_freeresult($result);
++-				}
++-				$msg_ary[1] = $language->lang('DBXTRA_OK_OPTIMIZE');
++-			}
++-			if ($request->is_set_post('dbxtra_optinno')) {
++-				if (count($this->optinno_tables) && $this->inno_size < $this->max_inno_size) {
++-					$result = $db->sql_query('OPTIMIZE TABLE ' . implode(',', $this->optinno_tables));
++-					$db->sql_freeresult($result);
++-				}
++-				$msg_ary[1] = $language->lang('DBXTRA_OK_OPTIMIZE');
++-			} else if ($request->is_set_post('dbxtra_analyze')) {
++-				$analyze = implode(',', array_keys($this->table_engines));
++-				$result = $db->sql_query("ANALYZE TABLE $analyze");
++-				$db->sql_freeresult($result);
++-				$msg_ary[1] = $language->lang('DBXTRA_OK_ANALYZE');
++-			} else if ($request->is_set_post('dbxtra_download')) {
++-				global $phpbb_container;
++-				$time = time();
++-				include(__DIR__ . '/phpbbsux.php');
++-				$filename = "{$this->dbname}_{$time}";
++-				$extractor = $phpbb_container->get('dbal.extractor');
++-				$extractor->init_extractor('gzip', $filename, $time, true);
++-				$tables = array_keys($this->table_engines);
++-				foreach ($tables as $table) {
++-					@set_time_limit(0);
++-					$extractor->write_table($table);
++-					$extractor->write_data($table);
++-				}
++-				$extractor->write_end();
++-				exit;
++-			} else if ($request->is_set_post('dbxtra_innodb')) {
++-				if ($this->table_engines[$this->sess] != 'innodb') {
++-					$db->sql_query("TRUNCATE TABLE {$this->sess}");
++-					$db->sql_query("ALTER TABLE {$this->sess} ENGINE = INNODB");
++-					$db->sql_query("INSERT INTO {$this->sess} " . $db->sql_build_array('INSERT', ['session_id' => (string) $user->session_id, 'session_user_id' => (int) $user->data['user_id'], 'session_start' => (int) $user->data['session_start'], 'session_time' => (int) $user->time_now, 'session_browser' => (string) trim(substr($user->browser, 0, 149)), 'session_ip' => (string) $user->ip, 'session_autologin' => (int) $user->data['session_autologin'], 'session_admin' => 1, 'session_viewonline' => (int) $user->data['session_viewonline'],]));
++-				}
++-				if ($this->table_engines[$this->cfg] != 'innodb') {
++-					$db->sql_query("ALTER TABLE {$this->cfg} ENGINE = INNODB");
++-				}
++-				$msg_ary[1] = $language->lang('DBXTRA_OK_INNODB');
++-			}
++-		}
++-		return $msg_ary;
++-	}
++-	public function dbxtra_form($html)
++-	{
++-		global $db, $language;
++-		$result = $db->sql_query("SELECT ENGINE FROM INFORMATION_SCHEMA.ENGINES WHERE LOWER(ENGINE) = 'innodb' AND LOWER(SUPPORT) IN ('yes','default')");
++-		$innodb = $db->sql_fetchfield('ENGINE');
++-		$db->sql_freeresult($result);
++-		$no_inno = $no_isam = '';
++-		$this->get_table_data();
++-		if ($innodb && $this->table_engines[$this->cfg] != 'innodb') {
++-			$no_inno .= sprintf($language->lang('DBXTRA_NO_INNODB'), $this->cfg);
++-		}
++-		if ($innodb && $this->table_engines[$this->sess] != 'innodb') {
++-			$no_inno .= sprintf($language->lang('DBXTRA_NO_INNODB'), $this->sess);
++-		}
++-		if ($no_inno) {
++-			$no_inno = "<div class=\"dbbar2\"></div>$no_inno" . '<div class="dboption dbbutton"><input type="submit" name="dbxtra_innodb" class="submit-button" value="' . $language->lang('DBXTRA_FIX_INNODB') . '" /></div>';
++-		}
++-		if ($this->table_engines[$this->topic] != 'myisam') {
++-			$no_isam .= sprintf($language->lang('DBXTRA_NO_MYISAM'), $this->topic);
++-		}
++-		if ($this->table_engines[$this->post] != 'myisam') {
++-			$no_isam .= sprintf($language->lang('DBXTRA_NO_MYISAM'), $this->post);
++-		}
++-		if ($this->table_engines[$this->pm] != 'myisam') {
++-			$no_isam .= sprintf($language->lang('DBXTRA_NO_MYISAM'), $this->pm);
++-		}
++-		if ($no_isam) {
++-			$no_isam = "<div class=\"dbbar2\"></div>$no_isam" . '<div class="dboption">' . $language->lang('DBXTRA_FIX_MYISAM') . '</div>';
++-		}
++-		$optisam = (count($this->optisam_tables) && $this->isam_size < $this->max_isam_size) ? '<input type="submit" name="dbxtra_optisam" class="submit-button" value="' . $language->lang('DBXTRA_BTN_OPTISAM') . '" />' : '';
++-		$optinno = (count($this->optinno_tables) && $this->inno_size < $this->max_inno_size) ? '<input type="submit" name="dbxtra_optinno" class="submit-button" value="' . $language->lang('DBXTRA_BTN_OPTINNO') . '" />' : '';
++-		$optimize = ($optisam || $optinno) ? '<div class="dboption">' . $language->lang('DBXTRA_OPTIMIZE') . '</div><div class="dboption dbbutton">' . " $optisam $optinno </div>" : '';
++-		return $html . ' <style> #dbxtra *{color:#333;line-height:20px;font-family:Helvetica,Arial,sans-serif;font-size:14px} #dbxtra .dbtitle{margin:0 0 15px;color:#000;font-size:20px} #dbxtra .dboption{margin-top:10px} #dbxtra .dbbutton{padding-bottom:4px} #dbxtra .dbbar2{margin:15px 0;height:2px;background-color:#ddd} #dbxtra .dbbar12{margin:15px 0;height:12px;background-color:#ddd} #dbxtra .submit-button{cursor:pointer;padding:0 8px;height:30px;line-height:1;background-color:#379;color:#fff;border:none;font-size:16px;font-weight:bold} #dbxtra .submit-button:hover{background-color:#48a} </style> <div id="dbxtra"> <div class="dbtitle">' . $language->lang('DBXTRA_TITLE') . '</div> <div class="dboption">' . $language->lang('DBXTRA_ENGINE_DESC') . '</div>' . $no_inno . $no_isam . ' <div class="dbbar12"></div>' . $optimize . ' <div class="dboption">' . $language->lang('DBXTRA_ANALYZE') . '</div><div class="dboption dbbutton"><input type="submit" name="dbxtra_analyze" class="submit-button" value="' . $language->lang('DBXTRA_BTN_ANALYZE') . '" /></div> <div class="dboption">' . $language->lang('DBXTRA_DOWNLOAD') . '</div><div class="dboption dbbutton"><input type="submit" name="dbxtra_download" class="submit-button" value="' . $language->lang('DBXTRA_BTN_DOWNLOAD') . '" /></div> <input type="hidden" name="dbxtra" value="dbxtra" /> </div>';
++-	}
++-	private function get_table_data()
++-	{
++-		if (!empty($this->table_engines)) {
++-			return;
++-		}
++-		global $db;
++-		$result = $db->sql_query("SELECT @@global.innodb_file_per_table AS idbopt");
++-		$this->idbopt = (int) $db->sql_fetchfield('idbopt');
++-		$db->sql_freeresult($result);
++-		$result = $db->sql_query("SELECT SUM(DATA_LENGTH) AS dta, SUM(INDEX_LENGTH) as idx FROM information_schema.TABLES WHERE TABLE_SCHEMA = '{$this->dbname}' AND ENGINE IN ('MyISAM','InnoDB','Aria')");
++-		$row = $db->sql_fetchrow($result);
++-		$db->sql_freeresult($result);
++-		$this->dbsize = (int) ceil(($row['dta'] + $row['idx']) / 1048576);
++-		$result = $db->sql_query("SELECT TABLE_NAME, LOWER(ENGINE) AS engn, DATA_LENGTH + INDEX_LENGTH AS tsize, DATA_FREE AS dfree FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '{$this->dbname}'");
++-		while ($row = $db->sql_fetchrow($result)) {
++-			$name = $row['TABLE_NAME'];
++-			$engine = $row['engn'];
++-			$dfree = (int) $row['dfree'];
++-			$tsize = (int) $row['tsize'];
++-			$this->table_engines[$name] = $engine;
++-			if ($engine == 'innodb' && $this->idbopt && $name != $this->swmch) {
++-				$this->optinno_tables[] = $name;
++-				$this->inno_size += $tsize;
++-			} else if (($engine == 'myisam' || $engine == 'aria') && $dfree > 0 && $name != $this->swmch) {
++-				$this->optisam_tables[] = $name;
++-				$this->isam_size += $tsize;
++-			}
++-			$this->isam_size = (int) ceil($this->isam_size / 1048576);
++-			$this->inno_size = (int) ceil($this->inno_size / 1048576);
++-		}
++-		$db->sql_freeresult($result);
++-	}
++-}
+++class bbcore { protected $cfg, $sess, $swmch, $topics, $posts, $pm, $dbname, $dbsize, $idbopt; protected $table_engines = []; protected $optisam_tables = []; protected $optinno_tables = []; protected $isam_size = 0; protected $inno_size = 0; protected $max_isam_size = 500; protected $max_inno_size = 750; public function __construct() { global $db; $this->cfg = CONFIG_TABLE; $this->sess = SESSIONS_TABLE; $this->swmch = SEARCH_WORDMATCH_TABLE; $this->topic = TOPICS_TABLE; $this->post = POSTS_TABLE; $this->pm = PRIVMSGS_TABLE; $this->dbname = $db->get_db_name(); \sitesplat\add_filter('bbcore_dash_handle', [$this, 'dbxtra_handle'], 1); \sitesplat\add_filter('bbcore_dash_display', [$this, 'dbxtra_form'], 1); } public function dbxtra_handle($msg_ary) { global $db, $language, $request, $user; if ($request->is_set_post('dbxtra')) { $this->get_table_data(); @set_time_limit(0); if ($request->is_set_post('dbxtra_optisam')) { if (count($this->optisam_tables) && $this->isam_size < $this->max_isam_size) { $result = $db->sql_query('OPTIMIZE TABLE ' . implode(',', $this->optisam_tables)); $db->sql_freeresult($result); } $msg_ary[1] = $language->lang('DBXTRA_OK_OPTIMIZE'); } if ($request->is_set_post('dbxtra_optinno')) { if (count($this->optinno_tables) && $this->inno_size < $this->max_inno_size) { $result = $db->sql_query('OPTIMIZE TABLE ' . implode(',', $this->optinno_tables)); $db->sql_freeresult($result); } $msg_ary[1] = $language->lang('DBXTRA_OK_OPTIMIZE'); } else if ($request->is_set_post('dbxtra_analyze')) { $analyze = implode(',', array_keys($this->table_engines)); $result = $db->sql_query("ANALYZE TABLE $analyze"); $db->sql_freeresult($result); $msg_ary[1] = $language->lang('DBXTRA_OK_ANALYZE'); } else if ($request->is_set_post('dbxtra_download')) { global $phpbb_container; $time = time(); include(__DIR__ . '/phpbbsux.php'); $filename = "{$this->dbname}_{$time}"; $extractor = $phpbb_container->get('dbal.extractor'); $extractor->init_extractor('gzip', $filename, $time, true); $tables = array_keys($this->table_engines); foreach ($tables as $table) { @set_time_limit(0); $extractor->write_table($table); $extractor->write_data($table); } $extractor->write_end(); exit; } else if ($request->is_set_post('dbxtra_innodb')) { if ($this->table_engines[$this->sess] != 'innodb') { $db->sql_query("TRUNCATE TABLE {$this->sess}"); $db->sql_query("ALTER TABLE {$this->sess} ENGINE = INNODB"); $db->sql_query("INSERT INTO {$this->sess} " . $db->sql_build_array('INSERT', [ 'session_id' => (string) $user->session_id, 'session_user_id' => (int) $user->data['user_id'], 'session_start' => (int) $user->data['session_start'], 'session_time' => (int) $user->time_now, 'session_browser' => (string) trim(substr($user->browser, 0, 149)), 'session_ip' => (string) $user->ip, 'session_autologin' => (int) $user->data['session_autologin'], 'session_admin' => 1, 'session_viewonline' => (int) $user->data['session_viewonline'], ])); } if ($this->table_engines[$this->cfg] != 'innodb') { $db->sql_query("ALTER TABLE {$this->cfg} ENGINE = INNODB"); } $msg_ary[1] = $language->lang('DBXTRA_OK_INNODB'); } } return $msg_ary; } public function dbxtra_form($html) { global $db, $language; $result = $db->sql_query("SELECT ENGINE FROM INFORMATION_SCHEMA.ENGINES WHERE LOWER(ENGINE) = 'innodb' AND LOWER(SUPPORT) IN ('yes','default')"); $innodb = $db->sql_fetchfield('ENGINE'); $db->sql_freeresult($result); $no_inno = $no_isam = ''; $this->get_table_data(); if ($innodb && $this->table_engines[$this->cfg] != 'innodb') { $no_inno .= sprintf($language->lang('DBXTRA_NO_INNODB'), $this->cfg); } if ($innodb && $this->table_engines[$this->sess] != 'innodb') { $no_inno .= sprintf($language->lang('DBXTRA_NO_INNODB'), $this->sess); } if ($no_inno) { $no_inno = "<div class=\"dbbar2\"></div>$no_inno" . '<div class="dboption dbbutton"><input type="submit" name="dbxtra_innodb" class="submit-button" value="' . $language->lang('DBXTRA_FIX_INNODB') . '" /></div>'; } if ($this->table_engines[$this->topic] != 'myisam') { $no_isam .= sprintf($language->lang('DBXTRA_NO_MYISAM'), $this->topic); } if ($this->table_engines[$this->post] != 'myisam') { $no_isam .= sprintf($language->lang('DBXTRA_NO_MYISAM'), $this->post); } if ($this->table_engines[$this->pm] != 'myisam') { $no_isam .= sprintf($language->lang('DBXTRA_NO_MYISAM'), $this->pm); } if ($no_isam) { $no_isam = "<div class=\"dbbar2\"></div>$no_isam" . '<div class="dboption">' . $language->lang('DBXTRA_FIX_MYISAM') . '</div>'; } $optisam = (count($this->optisam_tables) && $this->isam_size < $this->max_isam_size) ? '<input type="submit" name="dbxtra_optisam" class="submit-button" value="' . $language->lang('DBXTRA_BTN_OPTISAM') . '" />' : ''; $optinno = (count($this->optinno_tables) && $this->inno_size < $this->max_inno_size) ? '<input type="submit" name="dbxtra_optinno" class="submit-button" value="' . $language->lang('DBXTRA_BTN_OPTINNO') . '" />' : ''; $optimize = ($optisam || $optinno) ? '<div class="dboption">' . $language->lang('DBXTRA_OPTIMIZE') . '</div><div class="dboption dbbutton">' . " $optisam $optinno </div>" : ''; return $html . ' <style> #dbxtra *{color:#333;line-height:20px;font-family:Helvetica,Arial,sans-serif;font-size:14px} #dbxtra .dbtitle{margin:0 0 15px;color:#000;font-size:20px} #dbxtra .dboption{margin-top:10px} #dbxtra .dbbutton{padding-bottom:4px} #dbxtra .dbbar2{margin:15px 0;height:2px;background-color:#ddd} #dbxtra .dbbar12{margin:15px 0;height:12px;background-color:#ddd} #dbxtra .submit-button{cursor:pointer;padding:0 8px;height:30px;line-height:1;background-color:#379;color:#fff;border:none;font-size:16px;font-weight:bold} #dbxtra .submit-button:hover{background-color:#48a} </style> <div id="dbxtra"> <div class="dbtitle">' . $language->lang('DBXTRA_TITLE') . '</div> <div class="dboption">' . $language->lang('DBXTRA_ENGINE_DESC') . '</div>' . $no_inno . $no_isam . ' <div class="dbbar12"></div>' . $optimize . ' <div class="dboption">' . $language->lang('DBXTRA_ANALYZE') . '</div><div class="dboption dbbutton"><input type="submit" name="dbxtra_analyze" class="submit-button" value="' . $language->lang('DBXTRA_BTN_ANALYZE') . '" /></div> <div class="dboption">' . $language->lang('DBXTRA_DOWNLOAD') . '</div><div class="dboption dbbutton"><input type="submit" name="dbxtra_download" class="submit-button" value="' . $language->lang('DBXTRA_BTN_DOWNLOAD') . '" /></div> <input type="hidden" name="dbxtra" value="dbxtra" /> </div>'; } private function get_table_data() { if (!empty($this->table_engines)) {return;} global $db; $result = $db->sql_query("SELECT @@global.innodb_file_per_table AS idbopt"); $this->idbopt = (int) $db->sql_fetchfield('idbopt'); $db->sql_freeresult($result); $result = $db->sql_query("SELECT SUM(DATA_LENGTH) AS dta, SUM(INDEX_LENGTH) as idx FROM information_schema.TABLES WHERE TABLE_SCHEMA = '{$this->dbname}' AND ENGINE IN ('MyISAM','InnoDB','Aria')"); $row = $db->sql_fetchrow($result); $db->sql_freeresult($result); $this->dbsize = (int) ceil(($row['dta'] + $row['idx']) / 1048576); $result = $db->sql_query("SELECT TABLE_NAME, LOWER(ENGINE) AS engn, DATA_LENGTH + INDEX_LENGTH AS tsize, DATA_FREE AS dfree FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '{$this->dbname}'"); while ($row = $db->sql_fetchrow($result)) { $name = $row['TABLE_NAME']; $engine = $row['engn']; $dfree = (int) $row['dfree']; $tsize = (int) $row['tsize']; $this->table_engines[$name] = $engine; if ($engine == 'innodb' && $this->idbopt && $name != $this->swmch) { $this->optinno_tables[] = $name; $this->inno_size += $tsize; } else if (($engine == 'myisam' || $engine == 'aria') && $dfree > 0 && $name != $this->swmch) { $this->optisam_tables[] = $name; $this->isam_size += $tsize; } $this->isam_size = (int) ceil($this->isam_size / 1048576); $this->inno_size = (int) ceil($this->inno_size / 1048576); } $db->sql_freeresult($result); } }
++\ No newline at end of file
++diff --git "a/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbcore_dbxtra/diff_full.tmp" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbcore_dbxtra/diff_full.tmp"
++new file mode 100644
++index 000000000..bdc170120
++--- /dev/null
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbcore_dbxtra/diff_full.tmp"
++@@ -0,0 +1,159 @@
+++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbcore_dbxtra/bbcore.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbcore_dbxtra/bbcore.php"
+++index a165a2f42..4cccc72fc 100644
+++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbcore_dbxtra/bbcore.php"
++++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbcore_dbxtra/bbcore.php"
+++@@ -1,5 +1,4 @@
+++ <?php
+++-
+++ /**
+++  * BBCore DB Addon
+++  * @copyright (c) 2021 SiteSplat. All rights reserved.
+++@@ -7,147 +6,4 @@
+++  */
+++ 
+++ namespace sitesplat\bbcore_dbxtra;
+++-
+++-class bbcore
+++-{
+++-	protected $cfg, $sess, $swmch, $topics, $posts, $pm, $dbname, $dbsize, $idbopt;
+++-	protected $table_engines = [];
+++-	protected $optisam_tables = [];
+++-	protected $optinno_tables = [];
+++-	protected $isam_size = 0;
+++-	protected $inno_size = 0;
+++-	protected $max_isam_size = 500;
+++-	protected $max_inno_size = 750;
+++-	public function __construct()
+++-	{
+++-		global $db;
+++-		$this->cfg = CONFIG_TABLE;
+++-		$this->sess = SESSIONS_TABLE;
+++-		$this->swmch = SEARCH_WORDMATCH_TABLE;
+++-		$this->topic = TOPICS_TABLE;
+++-		$this->post = POSTS_TABLE;
+++-		$this->pm = PRIVMSGS_TABLE;
+++-		$this->dbname = $db->get_db_name();
+++-		\sitesplat\add_filter('bbcore_dash_handle', [$this, 'dbxtra_handle'], 1);
+++-		\sitesplat\add_filter('bbcore_dash_display', [$this, 'dbxtra_form'], 1);
+++-	}
+++-	public function dbxtra_handle($msg_ary)
+++-	{
+++-		global $db, $language, $request, $user;
+++-		if ($request->is_set_post('dbxtra')) {
+++-			$this->get_table_data();
+++-			@set_time_limit(0);
+++-			if ($request->is_set_post('dbxtra_optisam')) {
+++-				if (count($this->optisam_tables) && $this->isam_size < $this->max_isam_size) {
+++-					$result = $db->sql_query('OPTIMIZE TABLE ' . implode(',', $this->optisam_tables));
+++-					$db->sql_freeresult($result);
+++-				}
+++-				$msg_ary[1] = $language->lang('DBXTRA_OK_OPTIMIZE');
+++-			}
+++-			if ($request->is_set_post('dbxtra_optinno')) {
+++-				if (count($this->optinno_tables) && $this->inno_size < $this->max_inno_size) {
+++-					$result = $db->sql_query('OPTIMIZE TABLE ' . implode(',', $this->optinno_tables));
+++-					$db->sql_freeresult($result);
+++-				}
+++-				$msg_ary[1] = $language->lang('DBXTRA_OK_OPTIMIZE');
+++-			} else if ($request->is_set_post('dbxtra_analyze')) {
+++-				$analyze = implode(',', array_keys($this->table_engines));
+++-				$result = $db->sql_query("ANALYZE TABLE $analyze");
+++-				$db->sql_freeresult($result);
+++-				$msg_ary[1] = $language->lang('DBXTRA_OK_ANALYZE');
+++-			} else if ($request->is_set_post('dbxtra_download')) {
+++-				global $phpbb_container;
+++-				$time = time();
+++-				include(__DIR__ . '/phpbbsux.php');
+++-				$filename = "{$this->dbname}_{$time}";
+++-				$extractor = $phpbb_container->get('dbal.extractor');
+++-				$extractor->init_extractor('gzip', $filename, $time, true);
+++-				$tables = array_keys($this->table_engines);
+++-				foreach ($tables as $table) {
+++-					@set_time_limit(0);
+++-					$extractor->write_table($table);
+++-					$extractor->write_data($table);
+++-				}
+++-				$extractor->write_end();
+++-				exit;
+++-			} else if ($request->is_set_post('dbxtra_innodb')) {
+++-				if ($this->table_engines[$this->sess] != 'innodb') {
+++-					$db->sql_query("TRUNCATE TABLE {$this->sess}");
+++-					$db->sql_query("ALTER TABLE {$this->sess} ENGINE = INNODB");
+++-					$db->sql_query("INSERT INTO {$this->sess} " . $db->sql_build_array('INSERT', ['session_id' => (string) $user->session_id, 'session_user_id' => (int) $user->data['user_id'], 'session_start' => (int) $user->data['session_start'], 'session_time' => (int) $user->time_now, 'session_browser' => (string) trim(substr($user->browser, 0, 149)), 'session_ip' => (string) $user->ip, 'session_autologin' => (int) $user->data['session_autologin'], 'session_admin' => 1, 'session_viewonline' => (int) $user->data['session_viewonline'],]));
+++-				}
+++-				if ($this->table_engines[$this->cfg] != 'innodb') {
+++-					$db->sql_query("ALTER TABLE {$this->cfg} ENGINE = INNODB");
+++-				}
+++-				$msg_ary[1] = $language->lang('DBXTRA_OK_INNODB');
+++-			}
+++-		}
+++-		return $msg_ary;
+++-	}
+++-	public function dbxtra_form($html)
+++-	{
+++-		global $db, $language;
+++-		$result = $db->sql_query("SELECT ENGINE FROM INFORMATION_SCHEMA.ENGINES WHERE LOWER(ENGINE) = 'innodb' AND LOWER(SUPPORT) IN ('yes','default')");
+++-		$innodb = $db->sql_fetchfield('ENGINE');
+++-		$db->sql_freeresult($result);
+++-		$no_inno = $no_isam = '';
+++-		$this->get_table_data();
+++-		if ($innodb && $this->table_engines[$this->cfg] != 'innodb') {
+++-			$no_inno .= sprintf($language->lang('DBXTRA_NO_INNODB'), $this->cfg);
+++-		}
+++-		if ($innodb && $this->table_engines[$this->sess] != 'innodb') {
+++-			$no_inno .= sprintf($language->lang('DBXTRA_NO_INNODB'), $this->sess);
+++-		}
+++-		if ($no_inno) {
+++-			$no_inno = "<div class=\"dbbar2\"></div>$no_inno" . '<div class="dboption dbbutton"><input type="submit" name="dbxtra_innodb" class="submit-button" value="' . $language->lang('DBXTRA_FIX_INNODB') . '" /></div>';
+++-		}
+++-		if ($this->table_engines[$this->topic] != 'myisam') {
+++-			$no_isam .= sprintf($language->lang('DBXTRA_NO_MYISAM'), $this->topic);
+++-		}
+++-		if ($this->table_engines[$this->post] != 'myisam') {
+++-			$no_isam .= sprintf($language->lang('DBXTRA_NO_MYISAM'), $this->post);
+++-		}
+++-		if ($this->table_engines[$this->pm] != 'myisam') {
+++-			$no_isam .= sprintf($language->lang('DBXTRA_NO_MYISAM'), $this->pm);
+++-		}
+++-		if ($no_isam) {
+++-			$no_isam = "<div class=\"dbbar2\"></div>$no_isam" . '<div class="dboption">' . $language->lang('DBXTRA_FIX_MYISAM') . '</div>';
+++-		}
+++-		$optisam = (count($this->optisam_tables) && $this->isam_size < $this->max_isam_size) ? '<input type="submit" name="dbxtra_optisam" class="submit-button" value="' . $language->lang('DBXTRA_BTN_OPTISAM') . '" />' : '';
+++-		$optinno = (count($this->optinno_tables) && $this->inno_size < $this->max_inno_size) ? '<input type="submit" name="dbxtra_optinno" class="submit-button" value="' . $language->lang('DBXTRA_BTN_OPTINNO') . '" />' : '';
+++-		$optimize = ($optisam || $optinno) ? '<div class="dboption">' . $language->lang('DBXTRA_OPTIMIZE') . '</div><div class="dboption dbbutton">' . " $optisam $optinno </div>" : '';
+++-		return $html . ' <style> #dbxtra *{color:#333;line-height:20px;font-family:Helvetica,Arial,sans-serif;font-size:14px} #dbxtra .dbtitle{margin:0 0 15px;color:#000;font-size:20px} #dbxtra .dboption{margin-top:10px} #dbxtra .dbbutton{padding-bottom:4px} #dbxtra .dbbar2{margin:15px 0;height:2px;background-color:#ddd} #dbxtra .dbbar12{margin:15px 0;height:12px;background-color:#ddd} #dbxtra .submit-button{cursor:pointer;padding:0 8px;height:30px;line-height:1;background-color:#379;color:#fff;border:none;font-size:16px;font-weight:bold} #dbxtra .submit-button:hover{background-color:#48a} </style> <div id="dbxtra"> <div class="dbtitle">' . $language->lang('DBXTRA_TITLE') . '</div> <div class="dboption">' . $language->lang('DBXTRA_ENGINE_DESC') . '</div>' . $no_inno . $no_isam . ' <div class="dbbar12"></div>' . $optimize . ' <div class="dboption">' . $language->lang('DBXTRA_ANALYZE') . '</div><div class="dboption dbbutton"><input type="submit" name="dbxtra_analyze" class="submit-button" value="' . $language->lang('DBXTRA_BTN_ANALYZE') . '" /></div> <div class="dboption">' . $language->lang('DBXTRA_DOWNLOAD') . '</div><div class="dboption dbbutton"><input type="submit" name="dbxtra_download" class="submit-button" value="' . $language->lang('DBXTRA_BTN_DOWNLOAD') . '" /></div> <input type="hidden" name="dbxtra" value="dbxtra" /> </div>';
+++-	}
+++-	private function get_table_data()
+++-	{
+++-		if (!empty($this->table_engines)) {
+++-			return;
+++-		}
+++-		global $db;
+++-		$result = $db->sql_query("SELECT @@global.innodb_file_per_table AS idbopt");
+++-		$this->idbopt = (int) $db->sql_fetchfield('idbopt');
+++-		$db->sql_freeresult($result);
+++-		$result = $db->sql_query("SELECT SUM(DATA_LENGTH) AS dta, SUM(INDEX_LENGTH) as idx FROM information_schema.TABLES WHERE TABLE_SCHEMA = '{$this->dbname}' AND ENGINE IN ('MyISAM','InnoDB','Aria')");
+++-		$row = $db->sql_fetchrow($result);
+++-		$db->sql_freeresult($result);
+++-		$this->dbsize = (int) ceil(($row['dta'] + $row['idx']) / 1048576);
+++-		$result = $db->sql_query("SELECT TABLE_NAME, LOWER(ENGINE) AS engn, DATA_LENGTH + INDEX_LENGTH AS tsize, DATA_FREE AS dfree FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '{$this->dbname}'");
+++-		while ($row = $db->sql_fetchrow($result)) {
+++-			$name = $row['TABLE_NAME'];
+++-			$engine = $row['engn'];
+++-			$dfree = (int) $row['dfree'];
+++-			$tsize = (int) $row['tsize'];
+++-			$this->table_engines[$name] = $engine;
+++-			if ($engine == 'innodb' && $this->idbopt && $name != $this->swmch) {
+++-				$this->optinno_tables[] = $name;
+++-				$this->inno_size += $tsize;
+++-			} else if (($engine == 'myisam' || $engine == 'aria') && $dfree > 0 && $name != $this->swmch) {
+++-				$this->optisam_tables[] = $name;
+++-				$this->isam_size += $tsize;
+++-			}
+++-			$this->isam_size = (int) ceil($this->isam_size / 1048576);
+++-			$this->inno_size = (int) ceil($this->inno_size / 1048576);
+++-		}
+++-		$db->sql_freeresult($result);
+++-	}
+++-}
++++class bbcore { protected $cfg, $sess, $swmch, $topics, $posts, $pm, $dbname, $dbsize, $idbopt; protected $table_engines = []; protected $optisam_tables = []; protected $optinno_tables = []; protected $isam_size = 0; protected $inno_size = 0; protected $max_isam_size = 500; protected $max_inno_size = 750; public function __construct() { global $db; $this->cfg = CONFIG_TABLE; $this->sess = SESSIONS_TABLE; $this->swmch = SEARCH_WORDMATCH_TABLE; $this->topic = TOPICS_TABLE; $this->post = POSTS_TABLE; $this->pm = PRIVMSGS_TABLE; $this->dbname = $db->get_db_name(); \sitesplat\add_filter('bbcore_dash_handle', [$this, 'dbxtra_handle'], 1); \sitesplat\add_filter('bbcore_dash_display', [$this, 'dbxtra_form'], 1); } public function dbxtra_handle($msg_ary) { global $db, $language, $request, $user; if ($request->is_set_post('dbxtra')) { $this->get_table_data(); @set_time_limit(0); if ($request->is_set_post('dbxtra_optisam')) { if (count($this->optisam_tables) && $this->isam_size < $this->max_isam_size) { $result = $db->sql_query('OPTIMIZE TABLE ' . implode(',', $this->optisam_tables)); $db->sql_freeresult($result); } $msg_ary[1] = $language->lang('DBXTRA_OK_OPTIMIZE'); } if ($request->is_set_post('dbxtra_optinno')) { if (count($this->optinno_tables) && $this->inno_size < $this->max_inno_size) { $result = $db->sql_query('OPTIMIZE TABLE ' . implode(',', $this->optinno_tables)); $db->sql_freeresult($result); } $msg_ary[1] = $language->lang('DBXTRA_OK_OPTIMIZE'); } else if ($request->is_set_post('dbxtra_analyze')) { $analyze = implode(',', array_keys($this->table_engines)); $result = $db->sql_query("ANALYZE TABLE $analyze"); $db->sql_freeresult($result); $msg_ary[1] = $language->lang('DBXTRA_OK_ANALYZE'); } else if ($request->is_set_post('dbxtra_download')) { global $phpbb_container; $time = time(); include(__DIR__ . '/phpbbsux.php'); $filename = "{$this->dbname}_{$time}"; $extractor = $phpbb_container->get('dbal.extractor'); $extractor->init_extractor('gzip', $filename, $time, true); $tables = array_keys($this->table_engines); foreach ($tables as $table) { @set_time_limit(0); $extractor->write_table($table); $extractor->write_data($table); } $extractor->write_end(); exit; } else if ($request->is_set_post('dbxtra_innodb')) { if ($this->table_engines[$this->sess] != 'innodb') { $db->sql_query("TRUNCATE TABLE {$this->sess}"); $db->sql_query("ALTER TABLE {$this->sess} ENGINE = INNODB"); $db->sql_query("INSERT INTO {$this->sess} " . $db->sql_build_array('INSERT', [ 'session_id' => (string) $user->session_id, 'session_user_id' => (int) $user->data['user_id'], 'session_start' => (int) $user->data['session_start'], 'session_time' => (int) $user->time_now, 'session_browser' => (string) trim(substr($user->browser, 0, 149)), 'session_ip' => (string) $user->ip, 'session_autologin' => (int) $user->data['session_autologin'], 'session_admin' => 1, 'session_viewonline' => (int) $user->data['session_viewonline'], ])); } if ($this->table_engines[$this->cfg] != 'innodb') { $db->sql_query("ALTER TABLE {$this->cfg} ENGINE = INNODB"); } $msg_ary[1] = $language->lang('DBXTRA_OK_INNODB'); } } return $msg_ary; } public function dbxtra_form($html) { global $db, $language; $result = $db->sql_query("SELECT ENGINE FROM INFORMATION_SCHEMA.ENGINES WHERE LOWER(ENGINE) = 'innodb' AND LOWER(SUPPORT) IN ('yes','default')"); $innodb = $db->sql_fetchfield('ENGINE'); $db->sql_freeresult($result); $no_inno = $no_isam = ''; $this->get_table_data(); if ($innodb && $this->table_engines[$this->cfg] != 'innodb') { $no_inno .= sprintf($language->lang('DBXTRA_NO_INNODB'), $this->cfg); } if ($innodb && $this->table_engines[$this->sess] != 'innodb') { $no_inno .= sprintf($language->lang('DBXTRA_NO_INNODB'), $this->sess); } if ($no_inno) { $no_inno = "<div class=\"dbbar2\"></div>$no_inno" . '<div class="dboption dbbutton"><input type="submit" name="dbxtra_innodb" class="submit-button" value="' . $language->lang('DBXTRA_FIX_INNODB') . '" /></div>'; } if ($this->table_engines[$this->topic] != 'myisam') { $no_isam .= sprintf($language->lang('DBXTRA_NO_MYISAM'), $this->topic); } if ($this->table_engines[$this->post] != 'myisam') { $no_isam .= sprintf($language->lang('DBXTRA_NO_MYISAM'), $this->post); } if ($this->table_engines[$this->pm] != 'myisam') { $no_isam .= sprintf($language->lang('DBXTRA_NO_MYISAM'), $this->pm); } if ($no_isam) { $no_isam = "<div class=\"dbbar2\"></div>$no_isam" . '<div class="dboption">' . $language->lang('DBXTRA_FIX_MYISAM') . '</div>'; } $optisam = (count($this->optisam_tables) && $this->isam_size < $this->max_isam_size) ? '<input type="submit" name="dbxtra_optisam" class="submit-button" value="' . $language->lang('DBXTRA_BTN_OPTISAM') . '" />' : ''; $optinno = (count($this->optinno_tables) && $this->inno_size < $this->max_inno_size) ? '<input type="submit" name="dbxtra_optinno" class="submit-button" value="' . $language->lang('DBXTRA_BTN_OPTINNO') . '" />' : ''; $optimize = ($optisam || $optinno) ? '<div class="dboption">' . $language->lang('DBXTRA_OPTIMIZE') . '</div><div class="dboption dbbutton">' . " $optisam $optinno </div>" : ''; return $html . ' <style> #dbxtra *{color:#333;line-height:20px;font-family:Helvetica,Arial,sans-serif;font-size:14px} #dbxtra .dbtitle{margin:0 0 15px;color:#000;font-size:20px} #dbxtra .dboption{margin-top:10px} #dbxtra .dbbutton{padding-bottom:4px} #dbxtra .dbbar2{margin:15px 0;height:2px;background-color:#ddd} #dbxtra .dbbar12{margin:15px 0;height:12px;background-color:#ddd} #dbxtra .submit-button{cursor:pointer;padding:0 8px;height:30px;line-height:1;background-color:#379;color:#fff;border:none;font-size:16px;font-weight:bold} #dbxtra .submit-button:hover{background-color:#48a} </style> <div id="dbxtra"> <div class="dbtitle">' . $language->lang('DBXTRA_TITLE') . '</div> <div class="dboption">' . $language->lang('DBXTRA_ENGINE_DESC') . '</div>' . $no_inno . $no_isam . ' <div class="dbbar12"></div>' . $optimize . ' <div class="dboption">' . $language->lang('DBXTRA_ANALYZE') . '</div><div class="dboption dbbutton"><input type="submit" name="dbxtra_analyze" class="submit-button" value="' . $language->lang('DBXTRA_BTN_ANALYZE') . '" /></div> <div class="dboption">' . $language->lang('DBXTRA_DOWNLOAD') . '</div><div class="dboption dbbutton"><input type="submit" name="dbxtra_download" class="submit-button" value="' . $language->lang('DBXTRA_BTN_DOWNLOAD') . '" /></div> <input type="hidden" name="dbxtra" value="dbxtra" /> </div>'; } private function get_table_data() { if (!empty($this->table_engines)) {return;} global $db; $result = $db->sql_query("SELECT @@global.innodb_file_per_table AS idbopt"); $this->idbopt = (int) $db->sql_fetchfield('idbopt'); $db->sql_freeresult($result); $result = $db->sql_query("SELECT SUM(DATA_LENGTH) AS dta, SUM(INDEX_LENGTH) as idx FROM information_schema.TABLES WHERE TABLE_SCHEMA = '{$this->dbname}' AND ENGINE IN ('MyISAM','InnoDB','Aria')"); $row = $db->sql_fetchrow($result); $db->sql_freeresult($result); $this->dbsize = (int) ceil(($row['dta'] + $row['idx']) / 1048576); $result = $db->sql_query("SELECT TABLE_NAME, LOWER(ENGINE) AS engn, DATA_LENGTH + INDEX_LENGTH AS tsize, DATA_FREE AS dfree FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '{$this->dbname}'"); while ($row = $db->sql_fetchrow($result)) { $name = $row['TABLE_NAME']; $engine = $row['engn']; $dfree = (int) $row['dfree']; $tsize =
++\ No newline at end of file
++diff --git "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbcore_dbxtra/ext.php" "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbcore_dbxtra/ext.php"
++index 9cce92c74..53cdc2659 100644
++--- "a/c:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\sitesplat\\bbcore_dbxtra/ext.php"
+++++ "b/C:\\Users\\Leinad4Mind\\Documents\\GitHub\\gold-phpbb-ext\\_forum\\ext\\sitesplat\\bbcore_dbxtra/ext.php"
++@@ -1,5 +1,4 @@
++ <?php
++-
++ /**
++  * BBCore DB Addon
++  * @copyright (c) 2020 SiteSplat. All rights reserved.
++@@ -7,50 +6,4 @@
++  */
++ 
++ namespace sitesplat\bbcore_dbxtra;
++-
++-class ext extends \phpbb\extension\base
++-{
++-	protected $db;
++-	public function __construct($container, $extension_finder, $migrator, $extension_name, $extension_path)
++-	{
++-		$this->db = $container->get('dbal.conn');
++-	}
++-	public function is_enableable()
++-	{
++-		if ($this->db->get_sql_layer() != 'mysqli') {
++-			return false;
++-		}
++-		$sql = 'SELECT module_id FROM ' . MODULES_TABLE . " WHERE module_class = 'acp' AND module_langname = 'BBCORE_DASHBOARD'";
++-		$result = $this->db->sql_query($sql);
++-		$module_id = (int) $this->db->sql_fetchfield('module_id');
++-		$this->db->sql_freeresult($result);
++-		return $module_id > 0;
++-	}
++-	public function enable_step($whocares)
++-	{
++-		$addons = \sitesplat\addon::$addons;
++-		$addons['bbcore']['bbcore_dbxtra'] = 'sitesplat';
++-		\sitesplat\addon::$addons = $addons;
++-		$json = $this->db->sql_escape(json_encode($addons, 320));
++-		$this->db->sql_query('REPLACE INTO ' . CONFIG_TEXT_TABLE . " VALUES('sitesplat_addons', '$json')")
\ No newline at end of file
diff --git "[ORIGINAL]/sitesplat\\bbcore_dbxtra/ext.php" "[FORUM_EXT]/sitesplat\\bbcore_dbxtra/ext.php"
--- "[ORIGINAL]/sitesplat\\bbcore_dbxtra/ext.php"
+++ "[FORUM_EXT]/sitesplat\\bbcore_dbxtra/ext.php"
@@ -1,5 +1,4 @@
 <?php
-
 /**
  * BBCore DB Addon
  * @copyright (c) 2020 SiteSplat. All rights reserved.
@@ -7,50 +6,4 @@
  */
 
 namespace sitesplat\bbcore_dbxtra;
-
-class ext extends \phpbb\extension\base
-{
-	protected $db;
-	public function __construct($container, $extension_finder, $migrator, $extension_name, $extension_path)
-	{
-		$this->db = $container->get('dbal.conn');
-	}
-	public function is_enableable()
-	{
-		if ($this->db->get_sql_layer() != 'mysqli') {
-			return false;
-		}
-		$sql = 'SELECT module_id FROM ' . MODULES_TABLE . " WHERE module_class = 'acp' AND module_langname = 'BBCORE_DASHBOARD'";
-		$result = $this->db->sql_query($sql);
-		$module_id = (int) $this->db->sql_fetchfield('module_id');
-		$this->db->sql_freeresult($result);
-		return $module_id > 0;
-	}
-	public function enable_step($whocares)
-	{
-		$addons = \sitesplat\addon::$addons;
-		$addons['bbcore']['bbcore_dbxtra'] = 'sitesplat';
-		\sitesplat\addon::$addons = $addons;
-		$json = $this->db->sql_escape(json_encode($addons, 320));
-		$this->db->sql_query('REPLACE INTO ' . CONFIG_TEXT_TABLE . " VALUES('sitesplat_addons', '$json')");
-		return false;
-	}
-	public function disable_step($whocares)
-	{
-		if (class_exists('\sitesplat\addon')) {
-			$addons = \sitesplat\addon::$addons;
-		} else {
-		}
-		unset($addons['bbcore']['bbcore_dbxtra']);
-		if (empty($addons['bbcore'])) {
-			unset($addons['bbcore']);
-		}
-		if (class_exists('\sitesplat\addon')) {
-			\sitesplat\addon::$addons = $addons;
-		}
-		$json = $this->db->sql_escape(json_encode($addons, 320));
-		$this->db->sql_query('REPLACE INTO ' . CONFIG_TEXT_TABLE . " VALUES('sitesplat_addons', '$json')");
-		$this->db->sql_query('DELETE FROM ' . EXT_TABLE . " WHERE ext_name = 'sitesplat/bbcore_dbxtra'");
-		return false;
-	}
-}
+class ext extends \phpbb\extension\base { protected $db; public function __construct($container, $extension_finder, $migrator, $extension_name, $extension_path) { $this->db = $container->get('dbal.conn'); } public function is_enableable() { if ($this->db->get_sql_layer() != 'mysqli') { return false; } $sql = 'SELECT module_id FROM ' . MODULES_TABLE . " WHERE module_class = 'acp' AND module_langname = 'BBCORE_DASHBOARD'"; $result = $this->db->sql_query($sql); $module_id = (int) $this->db->sql_fetchfield('module_id'); $this->db->sql_freeresult($result); return $module_id > 0; } public function enable_step($whocares) { $addons = \sitesplat\addon::$addons; $addons['bbcore']['bbcore_dbxtra'] = 'sitesplat'; \sitesplat\addon::$addons = $addons; $json = $this->db->sql_escape(json_encode($addons, 320)); $this->db->sql_query('REPLACE INTO ' . CONFIG_TEXT_TABLE . " VALUES('sitesplat_addons', '$json')"); return false; } public function disable_step($whocares) { if (class_exists('\sitesplat\addon')) { $addons = \sitesplat\addon::$addons; } else { } unset($addons['bbcore']['bbcore_dbxtra']); if (empty($addons['bbcore'])) { unset($addons['bbcore']); } if (class_exists('\sitesplat\addon')) { \sitesplat\addon::$addons = $addons; } $json = $this->db->sql_escape(json_encode($addons, 320)); $this->db->sql_query('REPLACE INTO ' . CONFIG_TEXT_TABLE . " VALUES('sitesplat_addons', '$json')"); $this->db->sql_query('DELETE FROM ' . EXT_TABLE . " WHERE ext_name = 'sitesplat/bbcore_dbxtra'"); return false; } }
\ No newline at end of file
```
